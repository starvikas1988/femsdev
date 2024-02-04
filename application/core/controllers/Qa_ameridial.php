<?php 

 class Qa_ameridial extends CI_Controller{
	
	public function __construct(){
		parent::__construct();
		$this->load->model('user_model');
		$this->load->model('Common_model');
		$this->load->model('CreateTable_model');
	}

//////////////////////////////////////	
	public function getTLname(){
		if(check_logged_in()){
			$aid=$this->input->post('aid');
			$qSql = "Select id, assigned_to, fusion_id, get_process_names(id) as process_name, office_id FROM signin where id = '$aid'";
			echo json_encode($this->Common_model->get_query_result_array($qSql));
		}
	}

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
	
	
	private function amd_upload_files($files,$path)
    {
    	$result=$this->createPath($path);
    	if($result){
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
            }else{
                return false;
            }
        }
        return $images;
    	}
    }
	
///////////////////////////////////////////////////////////////////////////////////
/*-------------------------- Fortune Builder (Start) ---------------------------*/
///////////////////////////////////////////////////////////////////////////////////	
	public function index(){
		if(check_logged_in())
		{
			$current_user = get_user_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_ameridial/fortune_builder/qa_feedback.php";
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,134) and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$from_date = $this->input->get('from_date');
			$to_date = $this->input->get('to_date');
			$agent_id = $this->input->get('agent_id');
			$file = $this->input->get('file');
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
			
			if($from_date !="" && $to_date!=="" )  $cond= " Where (date(audit_date) >= '$from_date' and date(audit_date) <= '$to_date' ) ";
			if($agent_id !="")	$cond .=" and agent_id='$agent_id'";
			if($file !="")	$cond .=" and file_no like '%$file%'";
			
			if(get_user_fusion_id()!='FMIN000011' || get_user_fusion_id()!='FUTA000007' || get_user_fusion_id()!='FUTA000012'){
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
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
				from qa_amd_fortunebuilder_feedback $cond) xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to from signin) yy on (xx.agent_id=yy.sid)  $ops_cond order by audit_date";
			$data["fobi_data"] = $this->Common_model->get_query_result_array($qSql);
			
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			$data["agent_id"] = $agent_id;
			$data["file"] = $file;
			
			$this->load->view("dashboard",$data);
		}
	}
	
	public function add_fobi(){
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_ameridial/fortune_builder/add_feedback.php";
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,134) and status=1  order by name";
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
					"call_date" => mmddyy2mysql($this->input->post('call_date')),
					"file_no" => $this->input->post('file_no'),
					"call_duration" => $this->input->post('call_duration'),
					"audit_type" => $this->input->post('audit_type'),
					"auditor_type" => $this->input->post('auditor_type'),
					"voc" => $this->input->post('voc'),
					"possible_score" => $this->input->post('possible_score'),
					"earned_score" => $this->input->post('earned_score'),
					"overall_score" => $this->input->post('overall_score'),
					"callans5sec" => $this->input->post('callans5sec'),
					"agentintro" => $this->input->post('agentintro'),
					"agentadvise" => $this->input->post('agentadvise'),
					"agentgreeting" => $this->input->post('agentgreeting'),
					"agentzip" => $this->input->post('agentzip'),
					"verifycaller" => $this->input->post('verifycaller'),
					"calleremail" => $this->input->post('calleremail'),
					"agentseminar" => $this->input->post('agentseminar'),
					"agentphone" => $this->input->post('agentphone'),
					"callerreminder" => $this->input->post('callerreminder'),
					"agentsummerize" => $this->input->post('agentsummerize'),
					"registerguest" => $this->input->post('registerguest'),
					"verifyguest" => $this->input->post('verifyguest'),
					"agentdemonstrate" => $this->input->post('agentdemonstrate'),
					"appropiategrammer" => $this->input->post('appropiategrammer'),
					"goodpacing" => $this->input->post('goodpacing'),
					"agentdisplay" => $this->input->post('agentdisplay'),
					"callcontrol" => $this->input->post('callcontrol'),
					"agentclosing" => $this->input->post('agentclosing'),
					"correctdisposition" => $this->input->post('correctdisposition'),
					"call_summary" => $this->input->post('call_summary'),
					"feedback" => $this->input->post('feedback'),
					"entry_date" => $curDateTime,
					"audit_start_time" => $this->input->post('audit_start_time')
				);
				$a = $this->amd_upload_files($_FILES['attach_file'], $path='./qa_files/qa_ameridial/fortune_builder/');
				$field_array["attach_file"] = implode(',',$a);
				$rowid= data_inserter('qa_amd_fortunebuilder_feedback',$field_array);
			/////////////	
				if(get_login_type()=="client"){
					$field_array1 = array("client_entryby" => $current_user);
				}else{
					$field_array1 = array("entry_by" => $current_user);
				}
				$this->db->where('id', $rowid);
				$this->db->update('qa_amd_fortunebuilder_feedback',$field_array1);
			///////////	
				redirect('Qa_ameridial');
			}
			$data["array"] = $a;
			
			$this->load->view("dashboard",$data);
		}
	}
	
	
	public function mgnt_fobi_rvw($id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_ameridial/fortune_builder/mgnt_rvw.php";
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM signin where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,134) and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql="SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name from qa_amd_fortunebuilder_feedback where id='$id') xx Left Join (Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, office_id from signin) yy on (xx.agent_id=yy.sid)";
			$data["fobi_data"] = $this->Common_model->get_query_row_array($qSql);
			
			$data["fbid"]=$id;
			
			if($this->input->post('fbid'))
			{
				$fbid=$this->input->post('fbid');
				$curDateTime=CurrMySqlDate();
				$log=get_logs();
				
				$field_array = array(
					"agent_id" => $this->input->post('agent_id'),
					"tl_id" => $this->input->post('tl_id'),
					"call_date" => mmddyy2mysql($this->input->post('call_date')),
					"file_no" => $this->input->post('file_no'),
					"call_duration" => $this->input->post('call_duration'),
					"audit_type" => $this->input->post('audit_type'),
					"auditor_type" => $this->input->post('auditor_type'),
					"voc" => $this->input->post('voc'),
					"possible_score" => $this->input->post('possible_score'),
					"earned_score" => $this->input->post('earned_score'),
					"overall_score" => $this->input->post('overall_score'),
					"callans5sec" => $this->input->post('callans5sec'),
					"agentintro" => $this->input->post('agentintro'),
					"agentadvise" => $this->input->post('agentadvise'),
					"agentgreeting" => $this->input->post('agentgreeting'),
					"agentzip" => $this->input->post('agentzip'),
					"verifycaller" => $this->input->post('verifycaller'),
					"calleremail" => $this->input->post('calleremail'),
					"agentseminar" => $this->input->post('agentseminar'),
					"agentphone" => $this->input->post('agentphone'),
					"callerreminder" => $this->input->post('callerreminder'),
					"agentsummerize" => $this->input->post('agentsummerize'),
					"registerguest" => $this->input->post('registerguest'),
					"verifyguest" => $this->input->post('verifyguest'),
					"agentdemonstrate" => $this->input->post('agentdemonstrate'),
					"appropiategrammer" => $this->input->post('appropiategrammer'),
					"goodpacing" => $this->input->post('goodpacing'),
					"agentdisplay" => $this->input->post('agentdisplay'),
					"callcontrol" => $this->input->post('callcontrol'),
					"agentclosing" => $this->input->post('agentclosing'),
					"correctdisposition" => $this->input->post('correctdisposition'),
					"call_summary" => $this->input->post('call_summary'),
					"feedback" => $this->input->post('feedback')
				);
				$this->db->where('id', $fbid);
				$this->db->update('qa_amd_fortunebuilder_feedback',$field_array);
				
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
				$this->db->where('id', $fbid);
				$this->db->update('qa_amd_fortunebuilder_feedback',$field_array1);	
			///////////
				redirect('Qa_ameridial');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}
///////////////////////////////////////////////////////////////////////////////////
/*-------------------------- Fortune Builder (End) ---------------------------*/
///////////////////////////////////////////////////////////////////////////////////	

/********************************************************/
/**********PURITY FREE BOTTLE  START*********************/
/********************************************************/
	public function purity_bottle()
	{
		if(check_logged_in())
		{
			$current_user = get_user_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_ameridial/purity_bottle/qa_feedback.php";
			
			$data['location_list'] = $this->Common_model->get_office_location_list();
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,134) and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$from_date = $this->input->get('from_date');
			$to_date = $this->input->get('to_date');
			$agent_id = $this->input->get('agent_id');
			$file = $this->input->get('file');
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
			
			if($from_date !="" && $to_date!=="" )  $cond= " Where (date(audit_date) >= '$from_date' and date(audit_date) <= '$to_date' ) ";
			if($agent_id !="")	$cond .=" and agent_id='$agent_id'";
			if($file !="")	$cond .=" and file_no like '%$file%'";
			
			if(get_user_fusion_id()!='FMIN000011' || get_user_fusion_id()!='FUTA000007' || get_user_fusion_id()!='FUTA000012'){
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
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
				from qa_amd_purity_free_bottle_feedback $cond) xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";
			$data["purity_data"] = $this->Common_model->get_query_result_array($qSql);
			
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			$data["agent_id"] = $agent_id;
			$data["file"] = $file;
			
			$this->load->view("dashboard",$data);
		}
	}
	public function add_purity_bottle(){
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_ameridial/purity_bottle/add_feedback.php";
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,134) and status=1  order by name";
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
					"call_date" => mmddyy2mysql($this->input->post('call_date')),
					"call_duration" => $this->input->post('call_duration'),
					"file_no" => $this->input->post('file_no'),
					"call_type_lob" => $this->input->post('call_type_lob'),
					"audit_type" => $this->input->post('audit_type'),
					"auditor_type" => $this->input->post('auditor_type'),
					"voc" => $this->input->post('voc'),
					"overall_score" => $this->input->post('overall_score'),
					"customer_prompt" => $this->input->post('customer_prompt'),
					"soft_skills" => $this->input->post('soft_skills'),
					"customer_information" => $this->input->post('customer_information'),
					"super_saver_offer" => $this->input->post('super_saver_offer'),
					"upsell" => $this->input->post('upsell'),
					"payment_procedure" => $this->input->post('payment_procedure'),
					"knowledge_of_product" => $this->input->post('knowledge_of_product'),
					"call_control" => $this->input->post('call_control'),
					"faq" => $this->input->post('faq'),
					"objection_response" => $this->input->post('objection_response'),
					"personalize_the_call" => $this->input->post('personalize_the_call'),
					"correct_confirmation" => $this->input->post('correct_confirmation'),
					"cost_of_delivery" => $this->input->post('cost_of_delivery'),
					"misrepresentation" => $this->input->post('misrepresentation'),
					"dnc_response" => $this->input->post('dnc_response'),
					"call_summary" => $this->input->post('call_summary'),
					"feedback" => $this->input->post('feedback'),
					"entry_date" => $curDateTime,
					"audit_start_time" => $this->input->post('audit_start_time')
				);
				
				$a = $this->amd_upload_files($_FILES['attach_file'], $path='./qa_files/qa_ameridial/purity_bottle/');
				$field_array["attach_file"] = implode(',',$a);
				$rowid= data_inserter('qa_amd_purity_free_bottle_feedback',$field_array);
			/////////////	
				if(get_login_type()=="client"){
					$field_array1 = array("client_entryby" => $current_user);
				}else{
					$field_array1 = array("entry_by" => $current_user);
				}
				$this->db->where('id', $rowid);
				$this->db->update('qa_amd_purity_free_bottle_feedback',$field_array1);
			///////////	
				redirect('qa_ameridial/purity_bottle/');
			}
			$data["array"] = $a;
			
			$this->load->view("dashboard",$data);
		}
	}
	
	
	public function mgnt_purity_bottle_rvw($id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_ameridial/purity_bottle/mgnt_rvw.php";
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM signin where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,134) and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql="SELECT * from 
			(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
			(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
			(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
			from qa_amd_purity_free_bottle_feedback where id='$id') xx Left Join 
			(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, office_id from signin) yy on (xx.agent_id=yy.sid)";
			$data["purity_data"] = $this->Common_model->get_query_row_array($qSql);
			
			$data["fbid"]=$id;
			
			
			if($this->input->post('fbid'))
			{
				$fbid=$this->input->post('fbid');
				$curDateTime=CurrMySqlDate();
				$log=get_logs();
				
				$field_array = array(
					"agent_id" => $this->input->post('agent_id'),
					"tl_id" => $this->input->post('tl_id'),
					"call_date" => mmddyy2mysql($this->input->post('call_date')),
					"call_duration" => $this->input->post('call_duration'),
					"file_no" => $this->input->post('file_no'),
					"audit_type" => $this->input->post('audit_type'),
					"auditor_type" => $this->input->post('auditor_type'),
					"voc" => $this->input->post('voc'),
					"overall_score" => $this->input->post('overall_score'),
					"customer_prompt" => $this->input->post('customer_prompt'),
					"soft_skills" => $this->input->post('soft_skills'),
					"customer_information" => $this->input->post('customer_information'),
					"super_saver_offer" => $this->input->post('super_saver_offer'),
					"upsell" => $this->input->post('upsell'),
					"payment_procedure" => $this->input->post('payment_procedure'),
					"knowledge_of_product" => $this->input->post('knowledge_of_product'),
					"call_control" => $this->input->post('call_control'),
					"faq" => $this->input->post('faq'),
					"objection_response" => $this->input->post('objection_response'),
					"personalize_the_call" => $this->input->post('personalize_the_call'),
					"correct_confirmation" => $this->input->post('correct_confirmation'),
					"cost_of_delivery" => $this->input->post('cost_of_delivery'),
					"misrepresentation" => $this->input->post('misrepresentation'),
					"dnc_response" => $this->input->post('dnc_response'),
					"call_summary" => $this->input->post('call_summary'),
					"feedback" => $this->input->post('feedback')
				);
				$this->db->where('id', $fbid);
				$this->db->update('qa_amd_purity_free_bottle_feedback',$field_array);
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
				$this->db->where('id', $fbid);
				$this->db->update('qa_amd_purity_free_bottle_feedback',$field_array1);	
			///////////
				redirect('qa_ameridial/purity_bottle/');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}
/********************************************************/
/**********PURITY FREE BOTTLE  END*********************/
/********************************************************/

/********************************************************/
/**********PURITY CATALOG START**************************/
/********************************************************/
	public function purity_catalog()
	{
		if(check_logged_in())
		{
			$current_user = get_user_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_ameridial/purity_catalog/qa_feedback.php";
			
			$data['location_list'] = $this->Common_model->get_office_location_list();
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,134) and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$from_date = $this->input->get('from_date');
			$to_date = $this->input->get('to_date');
			$agent_id = $this->input->get('agent_id');
			$file = $this->input->get('file');
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
			
			if($from_date !="" && $to_date!=="" )  $cond= " Where (date(audit_date) >= '$from_date' and date(audit_date) <= '$to_date' ) ";
			if($agent_id !="")	$cond .=" and agent_id='$agent_id'";
			if($file !="")	$cond .=" and file_no like '%$file%'";
			
			if(get_user_fusion_id()!='FMIN000011' || get_user_fusion_id()!='FUTA000007' || get_user_fusion_id()!='FUTA000012'){
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
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
				from qa_amd_purity_catalog_feedback $cond) xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to from signin) yy on (xx.agent_id=yy.sid)  $ops_cond order by audit_date";
			$data["purity_data"] = $this->Common_model->get_query_result_array($qSql);
			
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			$data["agent_id"] = $agent_id;
			$data["file"] = $file;
			
			$this->load->view("dashboard",$data);
		}
	}
	
	public function add_purity_catalog(){
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_ameridial/purity_catalog/add_feedback.php";
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,134) and status=1  order by name";
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
					"call_date" => mmddyy2mysql($this->input->post('call_date')),
					"call_duration" => $this->input->post('call_duration'),
					"file_no" => $this->input->post('file_no'),
					"audit_type" => $this->input->post('audit_type'),
					"auditor_type" => $this->input->post('auditor_type'),
					"voc" => $this->input->post('voc'),
					"overall_score" => $this->input->post('overall_score'),
					"proper_greeting" => $this->input->post('proper_greeting'),
					"customer_first_name_address_verification" => $this->input->post('customer_first_name_address_verification'),
					"identified_type_of_account" => $this->input->post('identified_type_of_account'),
					"properly_transfer_account" => $this->input->post('properly_transfer_account'),
					"accurate_note_taken" => $this->input->post('accurate_note_taken'),
					"correct_information_given" => $this->input->post('correct_information_given'),
					"proper_terminology" => $this->input->post('proper_terminology'),
					"free_gift_scripting" => $this->input->post('free_gift_scripting'),
					"bulk_offer" => $this->input->post('bulk_offer'),
					"promotion_offered_correctly" => $this->input->post('promotion_offered_correctly'),
					"super_saver_offer_explained_correctly" => $this->input->post('super_saver_offer_explained_correctly'),
					"additional_product_offered" => $this->input->post('additional_product_offered'),
					"order_placed_properly" => $this->input->post('order_placed_properly'),
					"order_confirmation" => $this->input->post('order_confirmation'),
					"user_tool_faq" => $this->input->post('user_tool_faq'),
					"address_verification_at_confirmation" => $this->input->post('address_verification_at_confirmation'),
					"credit_card_verification" => $this->input->post('credit_card_verification'),
					"attemp_to_gather_cvv_code" => $this->input->post('attemp_to_gather_cvv_code'),
					"daily_special_offer" => $this->input->post('daily_special_offer'),
					"product_offered_with_daily_special" => $this->input->post('product_offered_with_daily_special'),
					"thank_you_statement" => $this->input->post('thank_you_statement'),
					"maintained_call_control" => $this->input->post('maintained_call_control'),
					"response_time" => $this->input->post('response_time'),
					"used_proper_hold_techniques" => $this->input->post('used_proper_hold_techniques'),
					"good_attitude" => $this->input->post('good_attitude'),
					"energy_attentiveness" => $this->input->post('energy_attentiveness'),
					"context_related_response" => $this->input->post('context_related_response'),
					"empathy_respectfulness" => $this->input->post('empathy_respectfulness'),
					"call_summary" => $this->input->post('call_summary'),
					"feedback" => $this->input->post('feedback'),
					"entry_date" => $curDateTime,
					"audit_start_time" => $this->input->post('audit_start_time')
				);
				$a = $this->amd_upload_files($_FILES['attach_file'], $path='./qa_files/qa_ameridial/purity_catalog/');
				$field_array["attach_file"] = implode(',',$a);
				$rowid= data_inserter('qa_amd_purity_catalog_feedback',$field_array);
			/////////////	
				if(get_login_type()=="client"){
					$field_array1 = array("client_entryby" => $current_user);
				}else{
					$field_array1 = array("entry_by" => $current_user);
				}
				$this->db->where('id', $rowid);
				$this->db->update('qa_amd_purity_catalog_feedback',$field_array1);
			///////////	
				redirect('qa_ameridial/purity_catalog/');
			}
			$data["array"] = $a;
			
			$this->load->view("dashboard",$data);
		}
	}
	
	
	public function mgnt_purity_catalog_rvw($id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_ameridial/purity_catalog/mgnt_rvw.php";
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM signin where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,134) and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql="SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name from qa_amd_purity_catalog_feedback where id='$id') xx Left Join (Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, office_id from signin) yy on (xx.agent_id=yy.sid)";
			$data["purity_data"] = $this->Common_model->get_query_row_array($qSql);
			
			$data["fbid"]=$id;
			
			
			if($this->input->post('fbid'))
			{
				$fbid=$this->input->post('fbid');
				$curDateTime=CurrMySqlDate();
				$log=get_logs();
				
				$field_array = array(
					"agent_id" => $this->input->post('agent_id'),
					"tl_id" => $this->input->post('tl_id'),
					"call_date" => mmddyy2mysql($this->input->post('call_date')),
					"call_duration" => $this->input->post('call_duration'),
					"file_no" => $this->input->post('file_no'),
					"audit_type" => $this->input->post('audit_type'),
					"auditor_type" => $this->input->post('auditor_type'),
					"voc" => $this->input->post('voc'),
					"overall_score" => $this->input->post('overall_score'),
					"proper_greeting" => $this->input->post('proper_greeting'),
					"customer_first_name_address_verification" => $this->input->post('customer_first_name_address_verification'),
					"identified_type_of_account" => $this->input->post('identified_type_of_account'),
					"properly_transfer_account" => $this->input->post('properly_transfer_account'),
					"accurate_note_taken" => $this->input->post('accurate_note_taken'),
					"correct_information_given" => $this->input->post('correct_information_given'),
					"proper_terminology" => $this->input->post('proper_terminology'),
					"free_gift_scripting" => $this->input->post('free_gift_scripting'),
					"bulk_offer" => $this->input->post('bulk_offer'),
					"promotion_offered_correctly" => $this->input->post('promotion_offered_correctly'),
					"super_saver_offer_explained_correctly" => $this->input->post('super_saver_offer_explained_correctly'),
					"additional_product_offered" => $this->input->post('additional_product_offered'),
					"order_placed_properly" => $this->input->post('order_placed_properly'),
					"order_confirmation" => $this->input->post('order_confirmation'),
					"user_tool_faq" => $this->input->post('user_tool_faq'),
					"address_verification_at_confirmation" => $this->input->post('address_verification_at_confirmation'),
					"credit_card_verification" => $this->input->post('credit_card_verification'),
					"attemp_to_gather_cvv_code" => $this->input->post('attemp_to_gather_cvv_code'),
					"daily_special_offer" => $this->input->post('daily_special_offer'),
					"product_offered_with_daily_special" => $this->input->post('product_offered_with_daily_special'),
					"thank_you_statement" => $this->input->post('thank_you_statement'),
					"maintained_call_control" => $this->input->post('maintained_call_control'),
					"response_time" => $this->input->post('response_time'),
					"used_proper_hold_techniques" => $this->input->post('used_proper_hold_techniques'),
					"good_attitude" => $this->input->post('good_attitude'),
					"energy_attentiveness" => $this->input->post('energy_attentiveness'),
					"context_related_response" => $this->input->post('context_related_response'),
					"empathy_respectfulness" => $this->input->post('empathy_respectfulness'),
					"call_summary" => $this->input->post('call_summary'),
					"feedback" => $this->input->post('feedback')
				);
				$this->db->where('id', $fbid);
				$this->db->update('qa_amd_purity_catalog_feedback',$field_array);
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
				$this->db->where('id', $fbid);
				$this->db->update('qa_amd_purity_catalog_feedback',$field_array1);	
			///////////	
				redirect('qa_ameridial/purity_catalog/');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}
/********************************************************/
/**********PURITY CATALOG END****************************/
/********************************************************/

/********************************************************/
/************PURITY CARE START**************************/
/********************************************************/
	public function purity_care()
	{
		if(check_logged_in())
		{
			$current_user = get_user_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_ameridial/purity_care/qa_feedback.php";
			
			$data['location_list'] = $this->Common_model->get_office_location_list();
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,134) and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$from_date = $this->input->get('from_date');
			$to_date = $this->input->get('to_date');
			$agent_id = $this->input->get('agent_id');
			$file = $this->input->get('file');
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
			
			if($from_date !="" && $to_date!=="" )  $cond= " Where (date(audit_date) >= '$from_date' and date(audit_date) <= '$to_date' ) ";
			if($agent_id !="")	$cond .=" and agent_id='$agent_id'";
			if($file !="")	$cond .=" and file_no like '%$file%'";
			
			if(get_user_fusion_id()!='FMIN000011' || get_user_fusion_id()!='FUTA000007' || get_user_fusion_id()!='FUTA000012'){
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
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
				from qa_amd_purity_care_feedback $cond) xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";
			$data["purity_data"] = $this->Common_model->get_query_result_array($qSql);
		///////////
			/* $qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
				from qa_amd_puritycare_new_feedback $cond) xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";
			$data["purity_new_data"] = $this->Common_model->get_query_result_array($qSql); */
			
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			$data["agent_id"] = $agent_id;
			$data["file"] = $file;
			
			$this->load->view("dashboard",$data);
		}
	}
	public function add_purity_care($id = 0){
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_ameridial/purity_care/add_feedback.php";
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,134) and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql	=	"SELECT * FROM qa_amd_purity_care_feedback WHERE id='".$id."'";
			$data['call_data'] = $this->Common_model->get_query_row_array($qSql);
			$curDateTime=CurrMySqlDate();
			$a = array();

			if($this->input->post('agent_id')){
				$field_array=array(
						"agent_id" => $this->input->post('agent_id'),
						"tl_id" => $this->input->post('tl_id'),
						"call_date" => mmddyy2mysql($this->input->post('call_date')),
						"call_one_call_duration" => $this->input->post('call_one_call_duration'),
						"call_one_file_no" => $this->input->post('call_one_file_no'),
						"voc" => $this->input->post('voc'),
						"call_two_call_duration" => $this->input->post('call_two_call_duration'),
						"call_two_file_no" => $this->input->post('call_two_file_no'),
						//"call_two_voc" => $this->input->post('call_two_voc'),
						"call_three_call_duration" => $this->input->post('call_three_call_duration'),
						"call_three_file_no" => $this->input->post('call_three_file_no'),
						//"call_three_voc" => $this->input->post('call_three_voc'),
						"audit_type" => $this->input->post('audit_type'),
						"auditor_type" => $this->input->post('auditor_type'),
						"earned_score" => $this->input->post('earned_score'),
						"possible_score" => $this->input->post('possible_score'),
						"overall_score" => $this->input->post('overall_score'),
						"call_one_proper_introduction" => $this->input->post('call_one_proper_introduction'),
						"call_two_proper_introduction" => $this->input->post('call_two_proper_introduction'),
						"call_three_proper_introduction" => $this->input->post('call_three_proper_introduction'),
						"review_proper_introduction" => $this->input->post('review_proper_introduction'),
						"score_proper_introduction" => $this->input->post('score_proper_introduction'),
						"call_one_cust_fname_addrs_verification" => $this->input->post('call_one_cust_fname_addrs_verification'),
						"call_two_cust_fname_addrs_verification" => $this->input->post('call_two_cust_fname_addrs_verification'),
						"call_three_cust_fname_addrs_verification" => $this->input->post('call_three_cust_fname_addrs_verification'),
						"review_cust_fname_addrs_verification" => $this->input->post('review_cust_fname_addrs_verification'),
						"score_cust_fname_addrs_verification" => $this->input->post('score_cust_fname_addrs_verification'),
						"call_one_opening_question" => $this->input->post('call_one_opening_question'),
						"call_two_opening_question" => $this->input->post('call_two_opening_question'),
						"call_three_opening_question" => $this->input->post('call_three_opening_question'),
						"review_opening_question" => $this->input->post('review_opening_question'),
						"score_opening_question" => $this->input->post('score_opening_question'),
						"call_one_accurate_note" => $this->input->post('call_one_accurate_note'),
						"call_two_accurate_note" => $this->input->post('call_two_accurate_note'),
						"call_three_accurate_note" => $this->input->post('call_three_accurate_note'),
						"review_accurate_note" => $this->input->post('review_accurate_note'),
						"score_accurate_note" => $this->input->post('score_accurate_note'),
						"call_one_correct_reason" => $this->input->post('call_one_correct_reason'),
						"call_two_correct_reason" => $this->input->post('call_two_correct_reason'),
						"call_three_correct_reason" => $this->input->post('call_three_correct_reason'),
						"review_correct_reason" => $this->input->post('review_correct_reason'),
						"score_correct_reason" => $this->input->post('score_correct_reason'),
						"call_one_correct_information_given" => $this->input->post('call_one_correct_information_given'),
						"call_two_correct_information_given" => $this->input->post('call_two_correct_information_given'),
						"call_three_correct_information_given" => $this->input->post('call_three_correct_information_given'),
						"review_correct_information_given" => $this->input->post('review_correct_information_given'),
						"score_correct_information_given" => $this->input->post('score_correct_information_given'),
						"call_one_proper_terminology" => $this->input->post('call_one_proper_terminology'),
						"call_two_proper_terminology" => $this->input->post('call_two_proper_terminology'),
						"call_three_proper_terminology" => $this->input->post('call_three_proper_terminology'),
						"review_proper_terminology" => $this->input->post('review_proper_terminology'),
						"score_proper_terminology" => $this->input->post('score_proper_terminology'),
						"call_one_proper_inquiry" => $this->input->post('call_one_proper_inquiry'),
						"call_two_proper_inquiry" => $this->input->post('call_two_proper_inquiry'),
						"call_three_proper_inquiry" => $this->input->post('call_three_proper_inquiry'),
						"review_proper_inquiry" => $this->input->post('review_proper_inquiry'),
						"score_proper_inquiry" => $this->input->post('score_proper_inquiry'),
						"call_one_company_promotion" => $this->input->post('call_one_company_promotion'),
						"call_two_company_promotion" => $this->input->post('call_two_company_promotion'),
						"call_three_company_promotion" => $this->input->post('call_three_company_promotion'),
						"review_company_promotion" => $this->input->post('review_company_promotion'),
						"score_company_promotion" => $this->input->post('score_company_promotion'),
						"call_one_correct_use_of_action" => $this->input->post('call_one_correct_use_of_action'),
						"call_two_correct_use_of_action" => $this->input->post('call_two_correct_use_of_action'),
						"call_three_correct_use_of_action" => $this->input->post('call_three_correct_use_of_action'),
						"review_correct_use_of_action" => $this->input->post('review_correct_use_of_action'),
						"score_correct_use_of_action" => $this->input->post('score_correct_use_of_action'),
						"call_one_database_follow_up" => $this->input->post('call_one_database_follow_up'),
						"call_two_database_follow_up" => $this->input->post('call_two_database_follow_up'),
						"call_three_database_follow_up" => $this->input->post('call_three_database_follow_up'),
						"review_database_follow_up" => $this->input->post('review_database_follow_up'),
						"score_database_follow_up" => $this->input->post('score_database_follow_up'),
						"call_one_product_promotion" => $this->input->post('call_one_product_promotion'),
						"call_two_product_promotion" => $this->input->post('call_two_product_promotion'),
						"call_three_product_promotion" => $this->input->post('call_three_product_promotion'),
						"review_product_promotion" => $this->input->post('review_product_promotion'),
						"score_product_promotion" => $this->input->post('score_product_promotion'),
						"call_one_reason_for_cancel" => $this->input->post('call_one_reason_for_cancel'),
						"call_two_reason_for_cancel" => $this->input->post('call_two_reason_for_cancel'),
						"call_three_reason_for_cancel" => $this->input->post('call_three_reason_for_cancel'),
						"review_reason_for_cancel" => $this->input->post('review_reason_for_cancel'),
						"score_reason_for_cancel" => $this->input->post('score_reason_for_cancel'),
						"call_one_legimate_sequence_offer" => $this->input->post('call_one_legimate_sequence_offer'),
						"call_two_legimate_sequence_offer" => $this->input->post('call_two_legimate_sequence_offer'),
						"call_three_legimate_sequence_offer" => $this->input->post('call_three_legimate_sequence_offer'),
						"review_legimate_sequence_offer" => $this->input->post('review_legimate_sequence_offer'),
						"score_legimate_sequence_offer" => $this->input->post('score_legimate_sequence_offer'),
						"call_one_first_retention_offer" => $this->input->post('call_one_first_retention_offer'),
						"call_two_first_retention_offer" => $this->input->post('call_two_first_retention_offer'),
						"call_three_first_retention_offer" => $this->input->post('call_three_first_retention_offer'),
						"review_first_retention_offer" => $this->input->post('review_first_retention_offer'),
						"score_first_retention_offer" => $this->input->post('score_first_retention_offer'),
						"call_one_second_retention_offer" => $this->input->post('call_one_second_retention_offer'),
						"call_two_second_retention_offer" => $this->input->post('call_two_second_retention_offer'),
						"call_three_second_retention_offer" => $this->input->post('call_three_second_retention_offer'),
						"review_second_retention_offer" => $this->input->post('review_second_retention_offer'),
						"score_second_retention_offer" => $this->input->post('score_second_retention_offer'),
						"call_one_valid_delay" => $this->input->post('call_one_valid_delay'),
						"call_two_valid_delay" => $this->input->post('call_two_valid_delay'),
						"call_three_valid_delay" => $this->input->post('call_three_valid_delay'),
						"review_valid_delay" => $this->input->post('review_valid_delay'),
						"score_valid_delay" => $this->input->post('score_valid_delay'),
						"call_one_preserved_avg_unit" => $this->input->post('call_one_preserved_avg_unit'),
						"call_two_preserved_avg_unit" => $this->input->post('call_two_preserved_avg_unit'),
						"call_three_preserved_avg_unit" => $this->input->post('call_three_preserved_avg_unit'),
						"review_preserved_avg_unit" => $this->input->post('review_preserved_avg_unit'),
						"score_preserved_avg_unit" => $this->input->post('score_preserved_avg_unit'),
						"call_one_proper_confirmation" => $this->input->post('call_one_proper_confirmation'),
						"call_two_proper_confirmation" => $this->input->post('call_two_proper_confirmation'),
						"call_three_proper_confirmation" => $this->input->post('call_three_proper_confirmation'),
						"review_proper_confirmation" => $this->input->post('review_proper_confirmation'),
						"score_proper_confirmation" => $this->input->post('score_proper_confirmation'),
						"call_one_daily_special_offer" => $this->input->post('call_one_daily_special_offer'),
						"call_two_daily_special_offer" => $this->input->post('call_two_daily_special_offer'),
						"call_three_daily_special_offer" => $this->input->post('call_three_daily_special_offer'),
						"review_daily_special_offer" => $this->input->post('review_daily_special_offer'),
						"score_daily_special_offer" => $this->input->post('score_daily_special_offer'),
						"call_one_anything_else" => $this->input->post('call_one_anything_else'),
						"call_two_anything_else" => $this->input->post('call_two_anything_else'),
						"call_three_anything_else" => $this->input->post('call_three_anything_else'),
						"review_anything_else" => $this->input->post('review_anything_else'),
						"score_anything_else" => $this->input->post('score_anything_else'),
						"call_one_thank_you" => $this->input->post('call_one_thank_you'),
						"call_two_thank_you" => $this->input->post('call_two_thank_you'),
						"call_three_thank_you" => $this->input->post('call_three_thank_you'),
						"review_thank_you" => $this->input->post('review_thank_you'),
						"score_thank_you" => $this->input->post('score_thank_you'),
						"call_one_mantained_call" => $this->input->post('call_one_mantained_call'),
						"call_two_mantained_call" => $this->input->post('call_two_mantained_call'),
						"call_three_mantained_call" => $this->input->post('call_three_mantained_call'),
						"review_mantained_call" => $this->input->post('review_mantained_call'),
						"score_mantained_call" => $this->input->post('score_mantained_call'),
						"call_one_response_time" => $this->input->post('call_one_response_time'),
						"call_two_response_time" => $this->input->post('call_two_response_time'),
						"call_three_response_time" => $this->input->post('call_three_response_time'),
						"review_response_time" => $this->input->post('review_response_time'),
						"score_response_time" => $this->input->post('score_response_time'),
						"call_one_proper_hold_technique" => $this->input->post('call_one_proper_hold_technique'),
						"call_two_proper_hold_technique" => $this->input->post('call_two_proper_hold_technique'),
						"call_three_proper_hold_technique" => $this->input->post('call_three_proper_hold_technique'),
						"review_proper_hold_technique" => $this->input->post('review_proper_hold_technique'),
						"score_proper_hold_technique" => $this->input->post('score_proper_hold_technique'),
						"call_one_good_attitude" => $this->input->post('call_one_good_attitude'),
						"call_two_good_attitude" => $this->input->post('call_two_good_attitude'),
						"call_three_good_attitude" => $this->input->post('call_three_good_attitude'),
						"review_good_attitude" => $this->input->post('review_good_attitude'),
						"score_good_attitude" => $this->input->post('score_good_attitude'),
						"call_one_attentiveness" => $this->input->post('call_one_attentiveness'),
						"call_two_attentiveness" => $this->input->post('call_two_attentiveness'),
						"call_three_attentiveness" => $this->input->post('call_three_attentiveness'),
						"review_attentiveness" => $this->input->post('review_attentiveness'),
						"score_attentiveness" => $this->input->post('score_attentiveness'),
						"call_one_context_related_response" => $this->input->post('call_one_context_related_response'),
						"call_two_context_related_response" => $this->input->post('call_two_context_related_response'),
						"call_three_context_related_response" => $this->input->post('call_three_context_related_response'),
						"review_context_related_response" => $this->input->post('review_context_related_response'),
						"score_context_related_response" => $this->input->post('score_context_related_response'),
						"call_one_empathy" => $this->input->post('call_one_empathy'),
						"call_two_empathy" => $this->input->post('call_two_empathy'),
						"call_three_empathy" => $this->input->post('call_three_empathy'),
						"review_empathy" => $this->input->post('review_empathy'),
						"score_empathy" => $this->input->post('score_empathy'),
						"call_one_badgering" => $this->input->post('call_one_badgering'),
						"call_two_badgering" => $this->input->post('call_two_badgering'),
						"call_three_badgering" => $this->input->post('call_three_badgering'),
						"review_badgering" => $this->input->post('review_badgering'),
						"score_badgering" => $this->input->post('score_badgering'),
						"call_one_avg_call" => $this->input->post('call_one_avg_call'),
						"call_two_avg_call" => $this->input->post('call_two_avg_call'),
						"call_three_avg_call" => $this->input->post('call_three_avg_call'),
						"review_avg_call" => $this->input->post('review_avg_call'),
						"score_avg_call" => $this->input->post('score_avg_call'),
						"call_one_avg_save" => $this->input->post('call_one_avg_save'),
						"call_two_avg_save" => $this->input->post('call_two_avg_save'),
						"call_three_avg_save" => $this->input->post('call_three_avg_save'),
						"review_avg_save" => $this->input->post('review_avg_save'),
						"score_avg_save" => $this->input->post('score_avg_save'),
						"call_one_avg_call_length" => $this->input->post('call_one_avg_call_length'),
						"call_two_avg_call_length" => $this->input->post('call_two_avg_call_length'),
						"call_three_avg_call_length" => $this->input->post('call_three_avg_call_length'),
						"review_avg_call_length" => $this->input->post('review_avg_call_length'),
						"score_avg_call_length" => $this->input->post('score_avg_call_length'),
						"call_summary" => $this->input->post('call_summary'),
						"feedback" => $this->input->post('feedback'),
						"entry_date" => $curDateTime
					);
				if($id == 0)
				{
					$field_array["audit_date"] = CurrDate();
					$a = $this->amd_upload_files($_FILES['attach_file'], $path='./qa_files/qa_ameridial/purity_care/');
					$attach_file	=	implode(',',$a);
					$field_array["attach_file"] = implode(',',$a);
					$rowid= data_inserter('qa_amd_purity_care_feedback',$field_array);
				}
				else
				{
					$a = $this->amd_upload_files($_FILES['attach_file'], $path='./qa_files/qa_ameridial/purity_care/');
					$attach_file	=	implode(',',$a);
					if($attach_file != "")
					{
						$field_array["attach_file"] = $attach_file;
					}
					$this->db->where('id', $id);
					$this->db->update('qa_amd_purity_care_feedback',$field_array);
				}
			
			/////////////	
				if(get_login_type()=="client"){
					$field_array1 = array("client_entryby" => $current_user);
				}else{
					$field_array1 = array("entry_by" => $current_user);
				}
				$this->db->where('id', $rowid);
				$this->db->update('qa_amd_purity_care_feedback',$field_array1);
			///////////	
				
				redirect('qa_ameridial/purity_care/');
			}
			$data["array"] = $a;
			$this->load->view("dashboard",$data);
		}
	}
	
	
	public function mgnt_purity_care_rvw($id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_ameridial/purity_care/mgnt_rvw.php";
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM signin where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,134) and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql="SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name from qa_amd_purity_care_feedback where id='$id') xx Left Join (Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, office_id from signin) yy on (xx.agent_id=yy.sid)";
			$data["purity_data"] = $this->Common_model->get_query_row_array($qSql);
			
			$data["fbid"]=$id;
				
			if($this->input->post('fbid'))
			{
				$fbid=$this->input->post('fbid');
				$curDateTime=CurrMySqlDate();
				$log=get_logs();
				
				$field_array = array(
					"agent_id" => $this->input->post('agent_id'),
					"tl_id" => $this->input->post('tl_id'),
					"call_date" => mmddyy2mysql($this->input->post('call_date')),
					"call_one_call_duration" => $this->input->post('call_one_call_duration'),
					"call_one_file_no" => $this->input->post('call_one_file_no'),
					"voc" => $this->input->post('voc'),
					"call_two_call_duration" => $this->input->post('call_two_call_duration'),
					"call_two_file_no" => $this->input->post('call_two_file_no'),
					//"call_two_voc" => $this->input->post('call_two_voc'),
					"call_three_call_duration" => $this->input->post('call_three_call_duration'),
					"call_three_file_no" => $this->input->post('call_three_file_no'),
					//"call_three_voc" => $this->input->post('call_three_voc'),
					"audit_type" => $this->input->post('audit_type'),
					"auditor_type" => $this->input->post('auditor_type'),
					"earned_score" => $this->input->post('earned_score'),
					"possible_score" => $this->input->post('possible_score'),
					"overall_score" => $this->input->post('overall_score'),
					"call_one_proper_introduction" => $this->input->post('call_one_proper_introduction'),
					"call_two_proper_introduction" => $this->input->post('call_two_proper_introduction'),
					"call_three_proper_introduction" => $this->input->post('call_three_proper_introduction'),
					"review_proper_introduction" => $this->input->post('review_proper_introduction'),
					"score_proper_introduction" => $this->input->post('score_proper_introduction'),
					"call_one_cust_fname_addrs_verification" => $this->input->post('call_one_cust_fname_addrs_verification'),
					"call_two_cust_fname_addrs_verification" => $this->input->post('call_two_cust_fname_addrs_verification'),
					"call_three_cust_fname_addrs_verification" => $this->input->post('call_three_cust_fname_addrs_verification'),
					"review_cust_fname_addrs_verification" => $this->input->post('review_cust_fname_addrs_verification'),
					"score_cust_fname_addrs_verification" => $this->input->post('score_cust_fname_addrs_verification'),
					"call_one_opening_question" => $this->input->post('call_one_opening_question'),
					"call_two_opening_question" => $this->input->post('call_two_opening_question'),
					"call_three_opening_question" => $this->input->post('call_three_opening_question'),
					"review_opening_question" => $this->input->post('review_opening_question'),
					"score_opening_question" => $this->input->post('score_opening_question'),
					"call_one_accurate_note" => $this->input->post('call_one_accurate_note'),
					"call_two_accurate_note" => $this->input->post('call_two_accurate_note'),
					"call_three_accurate_note" => $this->input->post('call_three_accurate_note'),
					"review_accurate_note" => $this->input->post('review_accurate_note'),
					"score_accurate_note" => $this->input->post('score_accurate_note'),
					"call_one_correct_reason" => $this->input->post('call_one_correct_reason'),
					"call_two_correct_reason" => $this->input->post('call_two_correct_reason'),
					"call_three_correct_reason" => $this->input->post('call_three_correct_reason'),
					"review_correct_reason" => $this->input->post('review_correct_reason'),
					"score_correct_reason" => $this->input->post('score_correct_reason'),
					"call_one_correct_information_given" => $this->input->post('call_one_correct_information_given'),
					"call_two_correct_information_given" => $this->input->post('call_two_correct_information_given'),
					"call_three_correct_information_given" => $this->input->post('call_three_correct_information_given'),
					"review_correct_information_given" => $this->input->post('review_correct_information_given'),
					"score_correct_information_given" => $this->input->post('score_correct_information_given'),
					"call_one_proper_terminology" => $this->input->post('call_one_proper_terminology'),
					"call_two_proper_terminology" => $this->input->post('call_two_proper_terminology'),
					"call_three_proper_terminology" => $this->input->post('call_three_proper_terminology'),
					"review_proper_terminology" => $this->input->post('review_proper_terminology'),
					"score_proper_terminology" => $this->input->post('score_proper_terminology'),
					"call_one_proper_inquiry" => $this->input->post('call_one_proper_inquiry'),
					"call_two_proper_inquiry" => $this->input->post('call_two_proper_inquiry'),
					"call_three_proper_inquiry" => $this->input->post('call_three_proper_inquiry'),
					"review_proper_inquiry" => $this->input->post('review_proper_inquiry'),
					"score_proper_inquiry" => $this->input->post('score_proper_inquiry'),
					"call_one_company_promotion" => $this->input->post('call_one_company_promotion'),
					"call_two_company_promotion" => $this->input->post('call_two_company_promotion'),
					"call_three_company_promotion" => $this->input->post('call_three_company_promotion'),
					"review_company_promotion" => $this->input->post('review_company_promotion'),
					"score_company_promotion" => $this->input->post('score_company_promotion'),
					"call_one_correct_use_of_action" => $this->input->post('call_one_correct_use_of_action'),
					"call_two_correct_use_of_action" => $this->input->post('call_two_correct_use_of_action'),
					"call_three_correct_use_of_action" => $this->input->post('call_three_correct_use_of_action'),
					"review_correct_use_of_action" => $this->input->post('review_correct_use_of_action'),
					"score_correct_use_of_action" => $this->input->post('score_correct_use_of_action'),
					"call_one_database_follow_up" => $this->input->post('call_one_database_follow_up'),
					"call_two_database_follow_up" => $this->input->post('call_two_database_follow_up'),
					"call_three_database_follow_up" => $this->input->post('call_three_database_follow_up'),
					"review_database_follow_up" => $this->input->post('review_database_follow_up'),
					"score_database_follow_up" => $this->input->post('score_database_follow_up'),
					"call_one_product_promotion" => $this->input->post('call_one_product_promotion'),
					"call_two_product_promotion" => $this->input->post('call_two_product_promotion'),
					"call_three_product_promotion" => $this->input->post('call_three_product_promotion'),
					"review_product_promotion" => $this->input->post('review_product_promotion'),
					"score_product_promotion" => $this->input->post('score_product_promotion'),
					"call_one_reason_for_cancel" => $this->input->post('call_one_reason_for_cancel'),
					"call_two_reason_for_cancel" => $this->input->post('call_two_reason_for_cancel'),
					"call_three_reason_for_cancel" => $this->input->post('call_three_reason_for_cancel'),
					"review_reason_for_cancel" => $this->input->post('review_reason_for_cancel'),
					"score_reason_for_cancel" => $this->input->post('score_reason_for_cancel'),
					"call_one_legimate_sequence_offer" => $this->input->post('call_one_legimate_sequence_offer'),
					"call_two_legimate_sequence_offer" => $this->input->post('call_two_legimate_sequence_offer'),
					"call_three_legimate_sequence_offer" => $this->input->post('call_three_legimate_sequence_offer'),
					"review_legimate_sequence_offer" => $this->input->post('review_legimate_sequence_offer'),
					"score_legimate_sequence_offer" => $this->input->post('score_legimate_sequence_offer'),
					"call_one_first_retention_offer" => $this->input->post('call_one_first_retention_offer'),
					"call_two_first_retention_offer" => $this->input->post('call_two_first_retention_offer'),
					"call_three_first_retention_offer" => $this->input->post('call_three_first_retention_offer'),
					"review_first_retention_offer" => $this->input->post('review_first_retention_offer'),
					"score_first_retention_offer" => $this->input->post('score_first_retention_offer'),
					"call_one_second_retention_offer" => $this->input->post('call_one_second_retention_offer'),
					"call_two_second_retention_offer" => $this->input->post('call_two_second_retention_offer'),
					"call_three_second_retention_offer" => $this->input->post('call_three_second_retention_offer'),
					"review_second_retention_offer" => $this->input->post('review_second_retention_offer'),
					"score_second_retention_offer" => $this->input->post('score_second_retention_offer'),
					"call_one_valid_delay" => $this->input->post('call_one_valid_delay'),
					"call_two_valid_delay" => $this->input->post('call_two_valid_delay'),
					"call_three_valid_delay" => $this->input->post('call_three_valid_delay'),
					"review_valid_delay" => $this->input->post('review_valid_delay'),
					"score_valid_delay" => $this->input->post('score_valid_delay'),
					"call_one_preserved_avg_unit" => $this->input->post('call_one_preserved_avg_unit'),
					"call_two_preserved_avg_unit" => $this->input->post('call_two_preserved_avg_unit'),
					"call_three_preserved_avg_unit" => $this->input->post('call_three_preserved_avg_unit'),
					"review_preserved_avg_unit" => $this->input->post('review_preserved_avg_unit'),
					"score_preserved_avg_unit" => $this->input->post('score_preserved_avg_unit'),
					"call_one_proper_confirmation" => $this->input->post('call_one_proper_confirmation'),
					"call_two_proper_confirmation" => $this->input->post('call_two_proper_confirmation'),
					"call_three_proper_confirmation" => $this->input->post('call_three_proper_confirmation'),
					"review_proper_confirmation" => $this->input->post('review_proper_confirmation'),
					"score_proper_confirmation" => $this->input->post('score_proper_confirmation'),
					"call_one_daily_special_offer" => $this->input->post('call_one_daily_special_offer'),
					"call_two_daily_special_offer" => $this->input->post('call_two_daily_special_offer'),
					"call_three_daily_special_offer" => $this->input->post('call_three_daily_special_offer'),
					"review_daily_special_offer" => $this->input->post('review_daily_special_offer'),
					"score_daily_special_offer" => $this->input->post('score_daily_special_offer'),
					"call_one_anything_else" => $this->input->post('call_one_anything_else'),
					"call_two_anything_else" => $this->input->post('call_two_anything_else'),
					"call_three_anything_else" => $this->input->post('call_three_anything_else'),
					"review_anything_else" => $this->input->post('review_anything_else'),
					"score_anything_else" => $this->input->post('score_anything_else'),
					"call_one_thank_you" => $this->input->post('call_one_thank_you'),
					"call_two_thank_you" => $this->input->post('call_two_thank_you'),
					"call_three_thank_you" => $this->input->post('call_three_thank_you'),
					"review_thank_you" => $this->input->post('review_thank_you'),
					"score_thank_you" => $this->input->post('score_thank_you'),
					"call_one_mantained_call" => $this->input->post('call_one_mantained_call'),
					"call_two_mantained_call" => $this->input->post('call_two_mantained_call'),
					"call_three_mantained_call" => $this->input->post('call_three_mantained_call'),
					"review_mantained_call" => $this->input->post('review_mantained_call'),
					"score_mantained_call" => $this->input->post('score_mantained_call'),
					"call_one_response_time" => $this->input->post('call_one_response_time'),
					"call_two_response_time" => $this->input->post('call_two_response_time'),
					"call_three_response_time" => $this->input->post('call_three_response_time'),
					"review_response_time" => $this->input->post('review_response_time'),
					"score_response_time" => $this->input->post('score_response_time'),
					"call_one_proper_hold_technique" => $this->input->post('call_one_proper_hold_technique'),
					"call_two_proper_hold_technique" => $this->input->post('call_two_proper_hold_technique'),
					"call_three_proper_hold_technique" => $this->input->post('call_three_proper_hold_technique'),
					"review_proper_hold_technique" => $this->input->post('review_proper_hold_technique'),
					"score_proper_hold_technique" => $this->input->post('score_proper_hold_technique'),
					"call_one_good_attitude" => $this->input->post('call_one_good_attitude'),
					"call_two_good_attitude" => $this->input->post('call_two_good_attitude'),
					"call_three_good_attitude" => $this->input->post('call_three_good_attitude'),
					"review_good_attitude" => $this->input->post('review_good_attitude'),
					"score_good_attitude" => $this->input->post('score_good_attitude'),
					"call_one_attentiveness" => $this->input->post('call_one_attentiveness'),
					"call_two_attentiveness" => $this->input->post('call_two_attentiveness'),
					"call_three_attentiveness" => $this->input->post('call_three_attentiveness'),
					"review_attentiveness" => $this->input->post('review_attentiveness'),
					"score_attentiveness" => $this->input->post('score_attentiveness'),
					"call_one_context_related_response" => $this->input->post('call_one_context_related_response'),
					"call_two_context_related_response" => $this->input->post('call_two_context_related_response'),
					"call_three_context_related_response" => $this->input->post('call_three_context_related_response'),
					"review_context_related_response" => $this->input->post('review_context_related_response'),
					"score_context_related_response" => $this->input->post('score_context_related_response'),
					"call_one_empathy" => $this->input->post('call_one_empathy'),
					"call_two_empathy" => $this->input->post('call_two_empathy'),
					"call_three_empathy" => $this->input->post('call_three_empathy'),
					"review_empathy" => $this->input->post('review_empathy'),
					"score_empathy" => $this->input->post('score_empathy'),
					"call_one_badgering" => $this->input->post('call_one_badgering'),
					"call_two_badgering" => $this->input->post('call_two_badgering'),
					"call_three_badgering" => $this->input->post('call_three_badgering'),
					"review_badgering" => $this->input->post('review_badgering'),
					"score_badgering" => $this->input->post('score_badgering'),
					"call_one_avg_call" => $this->input->post('call_one_avg_call'),
					"call_two_avg_call" => $this->input->post('call_two_avg_call'),
					"call_three_avg_call" => $this->input->post('call_three_avg_call'),
					"review_avg_call" => $this->input->post('review_avg_call'),
					"score_avg_call" => $this->input->post('score_avg_call'),
					"call_one_avg_save" => $this->input->post('call_one_avg_save'),
					"call_two_avg_save" => $this->input->post('call_two_avg_save'),
					"call_three_avg_save" => $this->input->post('call_three_avg_save'),
					"review_avg_save" => $this->input->post('review_avg_save'),
					"score_avg_save" => $this->input->post('score_avg_save'),
					"call_one_avg_call_length" => $this->input->post('call_one_avg_call_length'),
					"call_two_avg_call_length" => $this->input->post('call_two_avg_call_length'),
					"call_three_avg_call_length" => $this->input->post('call_three_avg_call_length'),
					"review_avg_call_length" => $this->input->post('review_avg_call_length'),
					"score_avg_call_length" => $this->input->post('score_avg_call_length'),
					"call_summary" => $this->input->post('call_summary'),
					"feedback" => $this->input->post('feedback')
				);
				$this->db->where('id', $fbid);
				$this->db->update('qa_amd_purity_care_feedback',$field_array);
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
				$this->db->where('id', $fbid);
				$this->db->update('qa_amd_purity_care_feedback',$field_array1);	
			///////////
				
				redirect('qa_ameridial/purity_care/');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}
	
////////////////////////// New Purity ////////////////////////////
////////////
	/* public function add_new_puritycare($pcare_new_id){
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_ameridial/purity_care/add_new_puritycare.php";
			$data['pcare_new_id']=$pcare_new_id;
			$tl_mgnt_cond='';
			
			if(get_role_dir()=='manager' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";
			}else if(get_role_dir()=='tl' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and assigned_to='$current_user'";
			}else{
				$tl_mgnt_cond="";
			}
			$qSql="Select id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM signin where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client(id,134) and status=1 $tl_mgnt_cond order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
				from qa_amd_puritycare_new_feedback where id='$pcare_new_id') xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
			$data["purity_new_data"] = $this->Common_model->get_query_row_array($qSql);
			
			//$currDate=CurrDate();
			$curDateTime=CurrMySqlDate();
			$a = array();
			
			if($this->input->post('agent_id')){
				
				$field_array=array(
					"agent_id" => $this->input->post('agent_id'),
					"tl_id" => $this->input->post('tl_id'),
					"call_date" => mmddyy2mysql($this->input->post('call_date')),
					"file_no" => $this->input->post('file_no'),
					"call_duration" => $this->input->post('call_duration'),
					"audit_type" => $this->input->post('audit_type'),
					"auditor_type" => $this->input->post('auditor_type'),
					"voc" => $this->input->post('voc'),
					"possible_score" => $this->input->post('possible_score'),
					"earned_score" => $this->input->post('earned_score'),
					"overall_score" => $this->input->post('overall_score'),
					"customer_address_verfication_call1" => $this->input->post('customer_address_verfication_call1'),
					"customer_address_verfication_call2" => $this->input->post('customer_address_verfication_call2'),
					"customer_address_verfication_call3" => $this->input->post('customer_address_verfication_call3'),
					"script_compliance_call1" => $this->input->post('script_compliance_call1'),
					"script_compliance_call2" => $this->input->post('script_compliance_call2'),
					"script_compliance_call3" => $this->input->post('script_compliance_call3'),
					"opening_question_call1" => $this->input->post('opening_question_call1'),
					"opening_question_call2" => $this->input->post('opening_question_call2'),
					"opening_question_call3" => $this->input->post('opening_question_call3'),
					"detail_note_call1" => $this->input->post('detail_note_call1'),
					"detail_note_call2" => $this->input->post('detail_note_call2'),
					"detail_note_call3" => $this->input->post('detail_note_call3'),
					"correct_info_call1" => $this->input->post('correct_info_call1'),
					"correct_info_call2" => $this->input->post('correct_info_call2'),
					"correct_info_call3" => $this->input->post('correct_info_call3'),
					"correct_reason_call1" => $this->input->post('correct_reason_call1'),
					"correct_reason_call2" => $this->input->post('correct_reason_call2'),
					"correct_reason_call3" => $this->input->post('correct_reason_call3'),
					"proper_terminilogy_call1" => $this->input->post('proper_terminilogy_call1'),
					"proper_terminilogy_call2" => $this->input->post('proper_terminilogy_call2'),
					"proper_terminilogy_call3" => $this->input->post('proper_terminilogy_call3'),
					"proper_inquiry_call1" => $this->input->post('proper_inquiry_call1'),
					"proper_inquiry_call2" => $this->input->post('proper_inquiry_call2'),
					"proper_inquiry_call3" => $this->input->post('proper_inquiry_call3'),
					"product_promotion_call1" => $this->input->post('product_promotion_call1'),
					"product_promotion_call2" => $this->input->post('product_promotion_call2'),
					"product_promotion_call3" => $this->input->post('product_promotion_call3'),
					"company_promotion_call1" => $this->input->post('company_promotion_call1'),
					"company_promotion_call2" => $this->input->post('company_promotion_call2'),
					"company_promotion_call3" => $this->input->post('company_promotion_call3'),
					"database_followup_call1" => $this->input->post('database_followup_call1'),
					"database_followup_call2" => $this->input->post('database_followup_call2'),
					"database_followup_call3" => $this->input->post('database_followup_call3'),
					"reason_cancel_call1" => $this->input->post('reason_cancel_call1'),
					"reason_cancel_call2" => $this->input->post('reason_cancel_call2'),
					"reason_cancel_call3" => $this->input->post('reason_cancel_call3'),
					"1st_retention_call1" => $this->input->post('1st_retention_call1'),
					"1st_retention_call2" => $this->input->post('1st_retention_call2'),
					"1st_retention_call3" => $this->input->post('1st_retention_call3'),
					"two_tools_call1" => $this->input->post('two_tools_call1'),
					"two_tools_call2" => $this->input->post('two_tools_call2'),
					"two_tools_call3" => $this->input->post('two_tools_call3'),
					"sequence_offers_call1" => $this->input->post('sequence_offers_call1'),
					"sequence_offers_call2" => $this->input->post('sequence_offers_call2'),
					"sequence_offers_call3" => $this->input->post('sequence_offers_call3'),
					"2nd_retention_call1" => $this->input->post('2nd_retention_call1'),
					"2nd_retention_call2" => $this->input->post('2nd_retention_call2'),
					"2nd_retention_call3" => $this->input->post('2nd_retention_call3'),
					"bottles_call1" => $this->input->post('bottles_call1'),
					"bottles_call2" => $this->input->post('bottles_call2'),
					"bottles_call3" => $this->input->post('bottles_call3'),
					"correct_delay_call1" => $this->input->post('correct_delay_call1'),
					"correct_delay_call2" => $this->input->post('correct_delay_call2'),
					"correct_delay_call3" => $this->input->post('correct_delay_call3'),
					"complete_recap_call1" => $this->input->post('complete_recap_call1'),
					"complete_recap_call2" => $this->input->post('complete_recap_call2'),
					"complete_recap_call3" => $this->input->post('complete_recap_call3'),
					"question_call1" => $this->input->post('question_call1'),
					"question_call2" => $this->input->post('question_call2'),
					"question_call3" => $this->input->post('question_call3'),
					"special_offer_call1" => $this->input->post('special_offer_call1'),
					"special_offer_call2" => $this->input->post('special_offer_call2'),
					"special_offer_call3" => $this->input->post('special_offer_call3'),
					"thank_you_call1" => $this->input->post('thank_you_call1'),
					"thank_you_call2" => $this->input->post('thank_you_call2'),
					"thank_you_call3" => $this->input->post('thank_you_call3'),
					"call_control_call1" => $this->input->post('call_control_call1'),
					"call_control_call2" => $this->input->post('call_control_call2'),
					"call_control_call3" => $this->input->post('call_control_call3'),
					"hold_technique_call1" => $this->input->post('hold_technique_call1'),
					"hold_technique_call2" => $this->input->post('hold_technique_call2'),
					"hold_technique_call3" => $this->input->post('hold_technique_call3'),
					"dead_air_call1" => $this->input->post('dead_air_call1'),
					"dead_air_call2" => $this->input->post('dead_air_call2'),
					"dead_air_call3" => $this->input->post('dead_air_call3'),
					"used_dead_call1" => $this->input->post('used_dead_call1'),
					"used_dead_call2" => $this->input->post('used_dead_call2'),
					"used_dead_call3" => $this->input->post('used_dead_call3'),
					"good_attitude_call1" => $this->input->post('good_attitude_call1'),
					"good_attitude_call2" => $this->input->post('good_attitude_call2'),
					"good_attitude_call3" => $this->input->post('good_attitude_call3'),
					"context_related_call1" => $this->input->post('context_related_call1'),
					"context_related_call2" => $this->input->post('context_related_call2'),
					"context_related_call3" => $this->input->post('context_related_call3'),
					"enthusiasm_call1" => $this->input->post('enthusiasm_call1'),
					"enthusiasm_call2" => $this->input->post('enthusiasm_call2'),
					"enthusiasm_call3" => $this->input->post('enthusiasm_call3'),
					"respectful_call1" => $this->input->post('respectful_call1'),
					"respectful_call2" => $this->input->post('respectful_call2'),
					"respectful_call3" => $this->input->post('respectful_call3'),
					"call_length_call1" => $this->input->post('call_length_call1'),
					"call_length_call2" => $this->input->post('call_length_call2'),
					"call_length_call3" => $this->input->post('call_length_call3'),
					"call_summary" => $this->input->post('call_summary'),
					"feedback" => $this->input->post('feedback')
				);
				
				
				if($pcare_new_id==0){
					
					$a = $this->amd_upload_files($_FILES['attach_file'], $path='./qa_files/qa_ameridial/purity_care/pcare_new/');
					$field_array["attach_file"] = implode(',',$a);
					$rowid= data_inserter('qa_amd_puritycare_new_feedback',$field_array);
					/////////
					$field_array2 = array(
						"audit_date" => CurrDate(),
						"entry_date" => $curDateTime,
						"audit_start_time" => $this->input->post('audit_start_time')
					);
					$this->db->where('id', $rowid);
					$this->db->update('qa_amd_puritycare_new_feedback',$field_array2);
					///////////
					if(get_login_type()=="client"){
						$field_array1 = array("client_entryby" => $current_user);
					}else{
						$field_array1 = array("entry_by" => $current_user);
					}
					$this->db->where('id', $rowid);
					$this->db->update('qa_amd_puritycare_new_feedback',$field_array1);
					
				}else{
					
					$this->db->where('id', $pcare_new_id);
					$this->db->update('qa_amd_puritycare_new_feedback',$field_array);
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
					$this->db->where('id', $pcare_new_id);
					$this->db->update('qa_amd_puritycare_new_feedback',$field_array1);
					
				}
				
				redirect('qa_ameridial/purity_care');
			}
			$data["array"] = $a;
			$this->load->view("dashboard",$data);
		}
	} */
	
/********************************************************/
/**********PURITY CARE END****************************/
/********************************************************/

/********************************************************/
/**************JFMI START****************************/
/********************************************************/
	public function jfmi_feedback()
	{
		if(check_logged_in())
		{
			$current_user = get_user_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_ameridial/jfmi/qa_feedback.php";
			
			$data['location_list'] = $this->Common_model->get_office_location_list();
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,134) and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$from_date = $this->input->get('from_date');
			$to_date = $this->input->get('to_date');
			$agent_id = $this->input->get('agent_id');
			$file = $this->input->get('file');
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
			
			if($from_date !="" && $to_date!=="" )  $cond= " Where (date(audit_date) >= '$from_date' and date(audit_date) <= '$to_date' ) ";
			if($agent_id !="")	$cond .=" and agent_id='$agent_id'";
			if($file !="")	$cond .=" and file_no like '%$file%'";
			
			if(get_user_fusion_id()!='FMIN000011' || get_user_fusion_id()!='FUTA000007' || get_user_fusion_id()!='FUTA000012'){
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
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
				from qa_amd_jfmi_feedback $cond) xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to from signin) yy on (xx.agent_id=yy.sid) 
				$ops_cond order by audit_date";
			$data["purity_data"] = $this->Common_model->get_query_result_array($qSql);
			
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			$data["agent_id"] = $agent_id;
			$data["file"] = $file;
			
			$this->load->view("dashboard",$data);
		}
	}
	
	public function add_jfmi(){
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_ameridial/jfmi/add_feedback.php";
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,134) and status=1  order by name";
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
					"call_date" => mmddyy2mysql($this->input->post('call_date')),
					"call_duration" => $this->input->post('call_duration'),
					"audit_type" => $this->input->post('audit_type'),
					"auditor_type" => $this->input->post('auditor_type'),
					"voc" => $this->input->post('voc'),
					"overall_score" => $this->input->post('overall_score'),
					"greets_customer_promptly"	=>	$this->input->post('greets_customer_promptly'),
					"uses_professionalism"	=>	$this->input->post('uses_professionalism'),
					"shows_gratitude"	=>	$this->input->post('shows_gratitude'),
					"collects_and_verifies_customer_information"	=>	$this->input->post('collects_and_verifies_customer_information'),
					"follows_correct_scripting_path"	=>	$this->input->post('follows_correct_scripting_path'),
					"collects_information_to_provide_to_partner_relations"	=>	$this->input->post('collects_information_to_provide_to_partner_relations'),
					"covers_all_payment_scripting"	=>	$this->input->post('covers_all_payment_scripting'),
					"maintains_call_control"	=>	$this->input->post('maintains_call_control'),
					"keeps_dead_air_to_minimum"	=>	$this->input->post('keeps_dead_air_to_minimum'),
					"uses_faq_agent_note"	=>	$this->input->post('uses_faq_agent_note'),
					"brands_the_call_with_proper_close"	=>	$this->input->post('brands_the_call_with_proper_close'),
					"stop_recording"	=>	$this->input->post('stop_recording'),
					"read_legal_script"	=>	$this->input->post('read_legal_script'),
					"call_summary" => $this->input->post('call_summary'),
					"feedback" => $this->input->post('feedback'),
					"entry_date" => $curDateTime,
					"audit_start_time" => $this->input->post('audit_start_time')
				);
				$a = $this->amd_upload_files($_FILES['attach_file'], $path='./qa_files/qa_ameridial/jfmi/');
				$field_array["attach_file"] = implode(',',$a);
				$rowid= data_inserter('qa_amd_jfmi_feedback',$field_array);
			/////////////	
				if(get_login_type()=="client"){
					$field_array1 = array("client_entryby" => $current_user);
				}else{
					$field_array1 = array("entry_by" => $current_user);
				}
				$this->db->where('id', $rowid);
				$this->db->update('qa_amd_jfmi_feedback',$field_array1);
			///////////	
				redirect('qa_ameridial/jfmi_feedback/');
			}
			$data["array"] = $a;
			
			$this->load->view("dashboard",$data);
		}
	}
	
	public function mgnt_jfmi_rvw($id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_ameridial/jfmi/mgnt_rvw.php";
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM signin where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,134) and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql="SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name from qa_amd_jfmi_feedback where id='$id') xx Left Join (Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, office_id from signin) yy on (xx.agent_id=yy.sid)";
			$data["jfmi_data"] = $this->Common_model->get_query_row_array($qSql);
			
			$data["jfmiid"]=$id;
			
			if($this->input->post('jfmiid'))
			{
				$jfmiid=$this->input->post('jfmiid');
				$curDateTime=CurrMySqlDate();
				$log=get_logs();
				
				$field_array = array(
					"agent_id" => $this->input->post('agent_id'),
					"tl_id" => $this->input->post('tl_id'),
					"call_date" => mmddyy2mysql($this->input->post('call_date')),
					"call_duration" => $this->input->post('call_duration'),
					"audit_type" => $this->input->post('audit_type'),
					"auditor_type" => $this->input->post('auditor_type'),
					"voc" => $this->input->post('voc'),
					"overall_score" => $this->input->post('overall_score'),
					"greets_customer_promptly"	=>	$this->input->post('greets_customer_promptly'),
					"uses_professionalism"	=>	$this->input->post('uses_professionalism'),
					"shows_gratitude"	=>	$this->input->post('shows_gratitude'),
					"collects_and_verifies_customer_information"	=>	$this->input->post('collects_and_verifies_customer_information'),
					"follows_correct_scripting_path"	=>	$this->input->post('follows_correct_scripting_path'),
					"collects_information_to_provide_to_partner_relations"	=>	$this->input->post('collects_information_to_provide_to_partner_relations'),
					"covers_all_payment_scripting"	=>	$this->input->post('covers_all_payment_scripting'),
					"maintains_call_control"	=>	$this->input->post('maintains_call_control'),
					"keeps_dead_air_to_minimum"	=>	$this->input->post('keeps_dead_air_to_minimum'),
					"uses_faq_agent_note"	=>	$this->input->post('uses_faq_agent_note'),
					"brands_the_call_with_proper_close"	=>	$this->input->post('brands_the_call_with_proper_close'),
					"stop_recording"	=>	$this->input->post('stop_recording'),
					"read_legal_script"	=>	$this->input->post('read_legal_script'),
					"call_summary" => $this->input->post('call_summary'),
					"feedback" => $this->input->post('feedback')
				);
				$this->db->where('id', $jfmiid);
				$this->db->update('qa_amd_jfmi_feedback',$field_array);
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
				$this->db->where('id', $jfmiid);
				$this->db->update('qa_amd_jfmi_feedback',$field_array1);	
			///////////
				redirect('qa_ameridial/jfmi_feedback/');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}
/********************************************************/
/**********JFMI END****************************/
/********************************************************/

///////////////////////////////////////////////////////////////////////////////////
/*------------------------- Hoveround (Start) ----------------------*/
///////////////////////////////////////////////////////////////////////////////////	
	public function hoveround_feedback(){
		if(check_logged_in())
		{
			$current_user = get_user_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_ameridial/hoveround/hoveround_feedback.php";
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,134) and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$from_date = $this->input->get('from_date');
			$to_date = $this->input->get('to_date');
			$agent_id = $this->input->get('agent_id');
			$file = $this->input->get('file');
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
			
			if($from_date !="" && $to_date!=="" )  $cond= " Where (date(audit_date) >= '$from_date' and date(audit_date) <= '$to_date' ) ";
			if($agent_id !="")	$cond .=" and agent_id='$agent_id'";
			if($file !="")	$cond .=" and file_no like '%$file%'";
			
			if(get_user_fusion_id()!='FMIN000011' || get_user_fusion_id()!='FUTA000007' || get_user_fusion_id()!='FUTA000012'){
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
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
				from qa_amd_hoveround_feedback $cond) xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to from signin) yy on (xx.agent_id=yy.sid)  $ops_cond order by audit_date";
			$data["hoveround_data"] = $this->Common_model->get_query_result_array($qSql);
			
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			$data["agent_id"] = $agent_id;
			$data["file"] = $file;
			
			$this->load->view("dashboard",$data);
		}
	}
	
	public function add_hoveround(){
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_ameridial/hoveround/add_hoveround.php";
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,134) and status=1  order by name";
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
					"call_date" => mmddyy2mysql($this->input->post('call_date')),
					"file_no" => $this->input->post('file_no'),
					"call_duration" => $this->input->post('call_duration'),
					"audit_type" => $this->input->post('audit_type'),
					"auditor_type" => $this->input->post('auditor_type'),
					"voc" => $this->input->post('voc'),
					"possible_score" => $this->input->post('possible_score'),
					"earned_score" => $this->input->post('earned_score'),
					"overall_score" => $this->input->post('overall_score'),
					"agentreadyforcall" => $this->input->post('agentreadyforcall'),
					"agentgiveintro" => $this->input->post('agentgiveintro'),
					"agentcorrectprobe" => $this->input->post('agentcorrectprobe'),
					"agentverifycustomer" => $this->input->post('agentverifycustomer'),
					"agentclosecall" => $this->input->post('agentclosecall'),
					"agentdisposition" => $this->input->post('agentdisposition'),
					"agentpolite" => $this->input->post('agentpolite'),
					"agentshowenergy" => $this->input->post('agentshowenergy'),
					"agenthavegoodtone" => $this->input->post('agenthavegoodtone'),
					"agentgiveaccurateinfo" => $this->input->post('agentgiveaccurateinfo'),
					"call_summary" => $this->input->post('call_summary'),
					"feedback" => $this->input->post('feedback'),
					"entry_date" => $curDateTime,
					"audit_start_time" => $this->input->post('audit_start_time')
				);
				$a = $this->amd_upload_files($_FILES['attach_file'], $path='./qa_files/qa_ameridial/hoveround/');
				$field_array["attach_file"] = implode(',',$a);
				$rowid= data_inserter('qa_amd_hoveround_feedback',$field_array);
			/////////////	
				if(get_login_type()=="client"){
					$field_array1 = array("client_entryby" => $current_user);
				}else{
					$field_array1 = array("entry_by" => $current_user);
				}
				$this->db->where('id', $rowid);
				$this->db->update('qa_amd_hoveround_feedback',$field_array1);
			///////////	
				redirect('Qa_ameridial/hoveround_feedback');
			}
			$data["array"] = $a;
			
			$this->load->view("dashboard",$data);
		}
	}
	
	
	public function mgnt_hoveround_rvw($id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_ameridial/hoveround/mgnt_hoveround_rvw.php";
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM signin where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,134) and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql="SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name from qa_amd_hoveround_feedback where id='$id') xx Left Join (Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, office_id from signin) yy on (xx.agent_id=yy.sid)";
			$data["hoveround_data"] = $this->Common_model->get_query_row_array($qSql);
			
			$data["hndid"]=$id;
				
			if($this->input->post('hndid'))
			{
				$hndid=$this->input->post('hndid');
				$curDateTime=CurrMySqlDate();
				$log=get_logs();
				
				$field_array = array(
					"agent_id" => $this->input->post('agent_id'),
					"tl_id" => $this->input->post('tl_id'),
					"call_date" => mmddyy2mysql($this->input->post('call_date')),
					"file_no" => $this->input->post('file_no'),
					"call_duration" => $this->input->post('call_duration'),
					"audit_type" => $this->input->post('audit_type'),
					"auditor_type" => $this->input->post('auditor_type'),
					"voc" => $this->input->post('voc'),
					"possible_score" => $this->input->post('possible_score'),
					"earned_score" => $this->input->post('earned_score'),
					"overall_score" => $this->input->post('overall_score'),
					"agentreadyforcall" => $this->input->post('agentreadyforcall'),
					"agentgiveintro" => $this->input->post('agentgiveintro'),
					"agentcorrectprobe" => $this->input->post('agentcorrectprobe'),
					"agentverifycustomer" => $this->input->post('agentverifycustomer'),
					"agentclosecall" => $this->input->post('agentclosecall'),
					"agentdisposition" => $this->input->post('agentdisposition'),
					"agentpolite" => $this->input->post('agentpolite'),
					"agentshowenergy" => $this->input->post('agentshowenergy'),
					"agenthavegoodtone" => $this->input->post('agenthavegoodtone'),
					"agentgiveaccurateinfo" => $this->input->post('agentgiveaccurateinfo'),
					"call_summary" => $this->input->post('call_summary'),
					"feedback" => $this->input->post('feedback')
				);
				$this->db->where('id', $hndid);
				$this->db->update('qa_amd_hoveround_feedback',$field_array);
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
				$this->db->where('id', $hndid);
				$this->db->update('qa_amd_hoveround_feedback',$field_array1);	
			///////////
				redirect('Qa_ameridial/hoveround_feedback');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}
///////////////////////////////////////////////////////////////////////////////////
/*----------------------------- Hoveround (End) --------------------------------*/
///////////////////////////////////////////////////////////////////////////////////

///////////////////////////////////////////////////////////////////////////////////
/*------------------------- NCPSSM (Start) ----------------------*/
///////////////////////////////////////////////////////////////////////////////////	
	public function ncpssm_feedback(){
		if(check_logged_in())
		{
			$current_user = get_user_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_ameridial/ncpssm/ncpssm_feedback.php";
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,134) and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$from_date = $this->input->get('from_date');
			$to_date = $this->input->get('to_date');
			$agent_id = $this->input->get('agent_id');
			$file = $this->input->get('file');
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
			
			if($from_date !="" && $to_date!=="" )  $cond= " Where (date(audit_date) >= '$from_date' and date(audit_date) <= '$to_date' ) ";
			if($agent_id !="")	$cond .=" and agent_id='$agent_id'";
			if($file !="")	$cond .=" and file_no like '%$file%'";
			
			if(get_user_fusion_id()!='FMIN000011' || get_user_fusion_id()!='FUTA000007' || get_user_fusion_id()!='FUTA000012'){
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
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
				from qa_amd_ncpssm_feedback $cond) xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to from signin) yy on (xx.agent_id=yy.sid)
				$ops_cond order by audit_date";
			$data["ncpssm_data"] = $this->Common_model->get_query_result_array($qSql);
			
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			$data["agent_id"] = $agent_id;
			$data["file"] = $file;
			
			$this->load->view("dashboard",$data);
		}
	}

	public function add_ncpssm(){
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_ameridial/ncpssm/add_ncpssm.php";
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,134) and status=1  order by name";
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
					"call_date" => mmddyy2mysql($this->input->post('call_date')),
					"file_no" => $this->input->post('file_no'),
					"call_duration" => $this->input->post('call_duration'),
					"audit_type" => $this->input->post('audit_type'),
					"auditor_type" => $this->input->post('auditor_type'),
					"voc" => $this->input->post('voc'),
					"possible_score" => $this->input->post('possible_score'),
					"earned_score" => $this->input->post('earned_score'),
					"overall_score" => $this->input->post('overall_score'),
					"introcaller" => $this->input->post('introcaller'),
					"introopenning" => $this->input->post('introopenning'),
					"scriptgathered" => $this->input->post('scriptgathered'),
					"scriptemail" => $this->input->post('scriptemail'),
					"scriptstatement" => $this->input->post('scriptstatement'),
					"scriptmedicareissue" => $this->input->post('scriptmedicareissue'),
					"scriptpersonalizecall" => $this->input->post('scriptpersonalizecall'),
					"scriptcallersupport" => $this->input->post('scriptcallersupport'),
					"toneenthusiasm" => $this->input->post('toneenthusiasm'),
					"toneproperpace" => $this->input->post('toneproperpace'),
					"tonecontroldeadair" => $this->input->post('tonecontroldeadair'),
					"tonespokeclearly" => $this->input->post('tonespokeclearly'),
					"tonegoodlistening" => $this->input->post('tonegoodlistening'),
					"toneempathized" => $this->input->post('toneempathized'),
					"toneprofessionalism" => $this->input->post('toneprofessionalism'),
					"closecallconslusion" => $this->input->post('closecallconslusion'),
					"closecorrectinfo" => $this->input->post('closecorrectinfo'),
					"closeconfirmcaller" => $this->input->post('closeconfirmcaller'),
					"autofailinfo" => $this->input->post('autofailinfo'),
					"autofailhungup" => $this->input->post('autofailhungup'),
					"autofailbehaviour" => $this->input->post('autofailbehaviour'),
					"autofaillanguage" => $this->input->post('autofaillanguage'),
					"call_summary" => $this->input->post('call_summary'),
					"feedback" => $this->input->post('feedback'),
					"entry_by" => $current_user,
					"entry_date" => $curDateTime,
					"audit_start_time" => $this->input->post('audit_start_time')
				);
				$a = $this->amd_upload_files($_FILES['attach_file'], $path='./qa_files/qa_ameridial/ncpssm/');
				$field_array["attach_file"] = implode(',',$a);
				$rowid= data_inserter('qa_amd_ncpssm_feedback',$field_array);
			/////////////	
				if(get_login_type()=="client"){
					$field_array1 = array("client_entryby" => $current_user);
				}else{
					$field_array1 = array("entry_by" => $current_user);
				}
				$this->db->where('id', $rowid);
				$this->db->update('qa_amd_ncpssm_feedback',$field_array1);
			///////////	
				redirect('Qa_ameridial/ncpssm_feedback');
			}
			$data["array"] = $a;
			
			$this->load->view("dashboard",$data);
		}
	}
	
	
	public function mgnt_ncpssm_rvw($id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_ameridial/ncpssm/mgnt_ncpssm_rvw.php";
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM signin where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,134) and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql="SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name from qa_amd_ncpssm_feedback where id='$id') xx Left Join (Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, office_id from signin) yy on (xx.agent_id=yy.sid)";
			$data["ncpssm_data"] = $this->Common_model->get_query_row_array($qSql);
			
			$data["ncpid"]=$id;
			
			
			if($this->input->post('ncpid'))
			{
				$ncpid=$this->input->post('ncpid');
				$curDateTime=CurrMySqlDate();
				$log=get_logs();
				
				$field_array = array(
					"agent_id" => $this->input->post('agent_id'),
					"tl_id" => $this->input->post('tl_id'),
					"call_date" => mmddyy2mysql($this->input->post('call_date')),
					"file_no" => $this->input->post('file_no'),
					"call_duration" => $this->input->post('call_duration'),
					"audit_type" => $this->input->post('audit_type'),
					"auditor_type" => $this->input->post('auditor_type'),
					"voc" => $this->input->post('voc'),
					"possible_score" => $this->input->post('possible_score'),
					"earned_score" => $this->input->post('earned_score'),
					"overall_score" => $this->input->post('overall_score'),
					"introcaller" => $this->input->post('introcaller'),
					"introopenning" => $this->input->post('introopenning'),
					"scriptgathered" => $this->input->post('scriptgathered'),
					"scriptemail" => $this->input->post('scriptemail'),
					"scriptstatement" => $this->input->post('scriptstatement'),
					"scriptmedicareissue" => $this->input->post('scriptmedicareissue'),
					"scriptpersonalizecall" => $this->input->post('scriptpersonalizecall'),
					"scriptcallersupport" => $this->input->post('scriptcallersupport'),
					"toneenthusiasm" => $this->input->post('toneenthusiasm'),
					"toneproperpace" => $this->input->post('toneproperpace'),
					"tonecontroldeadair" => $this->input->post('tonecontroldeadair'),
					"tonespokeclearly" => $this->input->post('tonespokeclearly'),
					"tonegoodlistening" => $this->input->post('tonegoodlistening'),
					"toneempathized" => $this->input->post('toneempathized'),
					"toneprofessionalism" => $this->input->post('toneprofessionalism'),
					"closecallconslusion" => $this->input->post('closecallconslusion'),
					"closecorrectinfo" => $this->input->post('closecorrectinfo'),
					"closeconfirmcaller" => $this->input->post('closeconfirmcaller'),
					"autofailinfo" => $this->input->post('autofailinfo'),
					"autofailhungup" => $this->input->post('autofailhungup'),
					"autofailbehaviour" => $this->input->post('autofailbehaviour'),
					"autofaillanguage" => $this->input->post('autofaillanguage'),
					"call_summary" => $this->input->post('call_summary'),
					"feedback" => $this->input->post('feedback')
				);
				$this->db->where('id', $ncpid);
				$this->db->update('qa_amd_ncpssm_feedback',$field_array);
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
				$this->db->where('id', $ncpid);
				$this->db->update('qa_amd_ncpssm_feedback',$field_array1);	
			///////////
				redirect('Qa_ameridial/ncpssm_feedback');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}
///////////////////////////////////////////////////////////////////////////////////
/*----------------------------- NCPSSM (End) --------------------------------*/
///////////////////////////////////////////////////////////////////////////////////	

///////////////////////////////////////////////////////////////////////////////////
/*------------------------- STC Scoresheet (Start) ----------------------*/
///////////////////////////////////////////////////////////////////////////////////	
	public function stc_feedback(){
		if(check_logged_in())
		{
			$current_user = get_user_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_ameridial/stc/stc_feedback.php";
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,134) and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$from_date = $this->input->get('from_date');
			$to_date = $this->input->get('to_date');
			$agent_id = $this->input->get('agent_id');
			$file = $this->input->get('file');
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
			
			if($from_date !="" && $to_date!=="" )  $cond= " Where (date(audit_date) >= '$from_date' and date(audit_date) <= '$to_date' ) ";
			if($agent_id !="")	$cond .=" and agent_id='$agent_id'";
			if($file !="")	$cond .=" and file_no like '%$file%'";
			
			if(get_user_fusion_id()!='FMIN000011' || get_user_fusion_id()!='FUTA000007' || get_user_fusion_id()!='FUTA000012'){
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
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
				from qa_amd_stc_feedback $cond) xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to from signin) yy on (xx.agent_id=yy.sid)
				$ops_cond order by audit_date";
			$data["stc_data"] = $this->Common_model->get_query_result_array($qSql);
			
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			$data["agent_id"] = $agent_id;
			$data["file"] = $file;
			
			$this->load->view("dashboard",$data);
		}
	}

	
	public function add_stc(){
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_ameridial/stc/add_stc.php";
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,134) and status=1  order by name";
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
					"call_date" => mmddyy2mysql($this->input->post('call_date')),
					"file_no" => $this->input->post('file_no'),
					"call_duration" => $this->input->post('call_duration'),
					"audit_type" => $this->input->post('audit_type'),
					"auditor_type" => $this->input->post('auditor_type'),
					"voc" => $this->input->post('voc'),
					"possible_score" => $this->input->post('possible_score'),
					"earned_score" => $this->input->post('earned_score'),
					"overall_score" => $this->input->post('overall_score'),
					"agentproperintro" => $this->input->post('agentproperintro'),
					"agentcapturedonorname" => $this->input->post('agentcapturedonorname'),
					"agentreadscript" => $this->input->post('agentreadscript'),
					"agentcovermonthlyrequest" => $this->input->post('agentcovermonthlyrequest'),
					"agentcapturedonationamount" => $this->input->post('agentcapturedonationamount'),
					"agentofferpayment" => $this->input->post('agentofferpayment'),
					"agentcapturedonoraddress" => $this->input->post('agentcapturedonoraddress'),
					"agentcapturedonorphone" => $this->input->post('agentcapturedonorphone'),
					"agentcapturedonoremail" => $this->input->post('agentcapturedonoremail'),
					"agentproperlyrebuttals" => $this->input->post('agentproperlyrebuttals'),
					"agentfollowscript" => $this->input->post('agentfollowscript'),
					"agentshowfamiliarity" => $this->input->post('agentshowfamiliarity'),
					"agentusescriptnavigation" => $this->input->post('agentusescriptnavigation'),
					"agentfollowproperclose" => $this->input->post('agentfollowproperclose'),
					"agentuseeffectivecommunication" => $this->input->post('agentuseeffectivecommunication'),
					"agentmaintaincontrol" => $this->input->post('agentmaintaincontrol'),
					"agentshowappreciation" => $this->input->post('agentshowappreciation'),
					"autofailfalseinfo" => $this->input->post('autofailfalseinfo'),
					"autofailhungup" => $this->input->post('autofailhungup'),
					"autofailagentbehaviuor" => $this->input->post('autofailagentbehaviuor'),
					"call_summary" => $this->input->post('call_summary'),
					"feedback" => $this->input->post('feedback'),
					"entry_date" => $curDateTime,
					"audit_start_time" => $this->input->post('audit_start_time')
				);
				$a = $this->amd_upload_files($_FILES['attach_file'], $path='./qa_files/qa_ameridial/stc/');
				$field_array["attach_file"] = implode(',',$a);
				$rowid= data_inserter('qa_amd_stc_feedback',$field_array);
			/////////////	
				if(get_login_type()=="client"){
					$field_array1 = array("client_entryby" => $current_user);
				}else{
					$field_array1 = array("entry_by" => $current_user);
				}
				$this->db->where('id', $rowid);
				$this->db->update('qa_amd_stc_feedback',$field_array1);
			///////////	
				redirect('Qa_ameridial/stc_feedback');
			}
			$data["array"] = $a;
			
			$this->load->view("dashboard",$data);
		}
	}
	
	
	public function mgnt_stc_rvw($id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_ameridial/stc/mgnt_stc_rvw.php";
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM signin where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,134) and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql="SELECT * from 
			(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
			(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
			(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
			from qa_amd_stc_feedback where id='$id') xx Left Join 
			(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, office_id from signin) yy on (xx.agent_id=yy.sid)";
			$data["stc_data"] = $this->Common_model->get_query_row_array($qSql);
			
			$data["stcid"]=$id;
			
			if($this->input->post('stcid'))
			{
				$stcid=$this->input->post('stcid');
				$curDateTime=CurrMySqlDate();
				$log=get_logs();
				
				$field_array = array(
					"agent_id" => $this->input->post('agent_id'),
					"tl_id" => $this->input->post('tl_id'),
					"call_date" => mmddyy2mysql($this->input->post('call_date')),
					"file_no" => $this->input->post('file_no'),
					"call_duration" => $this->input->post('call_duration'),
					"audit_type" => $this->input->post('audit_type'),
					"auditor_type" => $this->input->post('auditor_type'),
					"voc" => $this->input->post('voc'),
					"possible_score" => $this->input->post('possible_score'),
					"earned_score" => $this->input->post('earned_score'),
					"overall_score" => $this->input->post('overall_score'),
					"agentproperintro" => $this->input->post('agentproperintro'),
					"agentcapturedonorname" => $this->input->post('agentcapturedonorname'),
					"agentreadscript" => $this->input->post('agentreadscript'),
					"agentcovermonthlyrequest" => $this->input->post('agentcovermonthlyrequest'),
					"agentcapturedonationamount" => $this->input->post('agentcapturedonationamount'),
					"agentofferpayment" => $this->input->post('agentofferpayment'),
					"agentcapturedonoraddress" => $this->input->post('agentcapturedonoraddress'),
					"agentcapturedonorphone" => $this->input->post('agentcapturedonorphone'),
					"agentcapturedonoremail" => $this->input->post('agentcapturedonoremail'),
					"agentproperlyrebuttals" => $this->input->post('agentproperlyrebuttals'),
					"agentfollowscript" => $this->input->post('agentfollowscript'),
					"agentshowfamiliarity" => $this->input->post('agentshowfamiliarity'),
					"agentusescriptnavigation" => $this->input->post('agentusescriptnavigation'),
					"agentfollowproperclose" => $this->input->post('agentfollowproperclose'),
					"agentuseeffectivecommunication" => $this->input->post('agentuseeffectivecommunication'),
					"agentmaintaincontrol" => $this->input->post('agentmaintaincontrol'),
					"agentshowappreciation" => $this->input->post('agentshowappreciation'),
					"autofailfalseinfo" => $this->input->post('autofailfalseinfo'),
					"autofailhungup" => $this->input->post('autofailhungup'),
					"autofailagentbehaviuor" => $this->input->post('autofailagentbehaviuor'),
					"call_summary" => $this->input->post('call_summary'),
					"feedback" => $this->input->post('feedback')
				);
				$this->db->where('id', $stcid);
				$this->db->update('qa_amd_stc_feedback',$field_array);
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
				$this->db->where('id', $stcid);
				$this->db->update('qa_amd_stc_feedback',$field_array1);	
			///////////
				redirect('Qa_ameridial/stc_feedback');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}
///////////////////////////////////////////////////////////////////////////////////
/*----------------------------- STC Scoresheet (End) --------------------------------*/
///////////////////////////////////////////////////////////////////////////////////	

///////////////////////////////////////////////////////////////////////////////////
/*---------------------------- TOUCHFUSE (Start) -------------------------------*/
///////////////////////////////////////////////////////////////////////////////////	
	public function touchfuse(){
		if(check_logged_in())
		{
			$current_user = get_user_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_ameridial/touchfuse/tf_feedback.php";
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,134) and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$from_date = $this->input->get('from_date');
			$to_date = $this->input->get('to_date');
			$agent_id = $this->input->get('agent_id');
			$file = $this->input->get('file');
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
			
			if($from_date !="" && $to_date!=="" )  $cond= " Where (date(audit_date) >= '$from_date' and date(audit_date) <= '$to_date' ) ";
			if($agent_id !="")	$cond .=" and agent_id='$agent_id'";
			if($file !="")	$cond .=" and file_no like '%$file%'";
			
			if(get_user_fusion_id()!='FMIN000011' || get_user_fusion_id()!='FUTA000007' || get_user_fusion_id()!='FUTA000012'){
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
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
				from qa_amd_touchfuse_feedback $cond) xx Left Join 
				(Select id as sid, fname, lname, fusion_id, office_id, assigned_to from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";
			$data["tf_data"] = $this->Common_model->get_query_result_array($qSql);
			
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			$data["agent_id"] = $agent_id;
			$data["file"] = $file;
			
			$this->load->view("dashboard",$data);
		}
	}
	
	public function add_tf(){
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_ameridial/touchfuse/add_tf.php";
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,134) and status=1  order by name";
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
					"call_date" => mmddyy2mysql($this->input->post('call_date')),
					"file_no" => $this->input->post('file_no'),
					"call_duration" => $this->input->post('call_duration'),
					"call_status" => $this->input->post('call_status'),
					"audit_type" => $this->input->post('audit_type'),
					"auditor_type" => $this->input->post('auditor_type'),
					"voc" => $this->input->post('voc'),
					"possible_score" => $this->input->post('possible_score'),
					"earned_score" => $this->input->post('earned_score'),
					"overall_score" => $this->input->post('overall_score'),
					"callasnwer" => $this->input->post('callasnwer'),
					"agentanswer" => $this->input->post('agentanswer'),
					"agentzip" => $this->input->post('agentzip'),
					"agentoffer" => $this->input->post('agentoffer'),
					"callerwish" => $this->input->post('callerwish'),
					"agentconfirm" => $this->input->post('agentconfirm'),
					"calleraddress" => $this->input->post('calleraddress'),
					"calleremail" => $this->input->post('calleremail'),
					"agentphone" => $this->input->post('agentphone'),
					"agentsummerize" => $this->input->post('agentsummerize'),
					"registerguest" => $this->input->post('registerguest'),
					"dispocall" => $this->input->post('dispocall'),
					"agentclosing" => $this->input->post('agentclosing'),
					"agenttone" => $this->input->post('agenttone'),
					"activelistening" => $this->input->post('activelistening'),
					"agentprofession" => $this->input->post('agentprofession'),
					"agentknowledge" => $this->input->post('agentknowledge'),
					"callcontrol" => $this->input->post('callcontrol'),
					"call_summary" => $this->input->post('call_summary'),
					"feedback" => $this->input->post('feedback'),
					"entry_date" => $curDateTime,
					"audit_start_time" => $this->input->post('audit_start_time')
				);
				$a = $this->amd_upload_files($_FILES['attach_file'], $path='./qa_files/qa_ameridial/touchfuse/');
				$field_array["attach_file"] = implode(',',$a);
				$rowid= data_inserter('qa_amd_touchfuse_feedback',$field_array);
			/////////////	
				if(get_login_type()=="client"){
					$field_array1 = array("client_entryby" => $current_user);
				}else{
					$field_array1 = array("entry_by" => $current_user);
				}
				$this->db->where('id', $rowid);
				$this->db->update('qa_amd_touchfuse_feedback',$field_array1);
			///////////		
				redirect('Qa_ameridial/touchfuse');
			}
			$data["array"] = $a;
			
			$this->load->view("dashboard",$data);
		}
	}
	
	
	public function mgnt_tf_rvw($id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_ameridial/touchfuse/mgnt_tf_rvw.php";
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM signin where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,134) and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql="SELECT * from 
			(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, 
			(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
			(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
			from qa_amd_touchfuse_feedback where id='$id') xx Left Join (Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, office_id from signin) yy on (xx.agent_id=yy.sid)";
			$data["tf_data"] = $this->Common_model->get_query_row_array($qSql);
			
			$data["tfid"]=$id;
				
			if($this->input->post('tfid'))
			{
				$tfid=$this->input->post('tfid');
				$curDateTime=CurrMySqlDate();
				$log=get_logs();
				
				$field_array = array(
					"agent_id" => $this->input->post('agent_id'),
					"tl_id" => $this->input->post('tl_id'),
					"call_date" => mmddyy2mysql($this->input->post('call_date')),
					"call_duration" => $this->input->post('call_duration'),
					"file_no" => $this->input->post('file_no'),
					"call_status" => $this->input->post('call_status'),
					"audit_type" => $this->input->post('audit_type'),
					"auditor_type" => $this->input->post('auditor_type'),
					"voc" => $this->input->post('voc'),
					"possible_score" => $this->input->post('possible_score'),
					"earned_score" => $this->input->post('earned_score'),
					"overall_score" => $this->input->post('overall_score'),
					"callasnwer" => $this->input->post('callasnwer'),
					"agentanswer" => $this->input->post('agentanswer'),
					"agentzip" => $this->input->post('agentzip'),
					"agentoffer" => $this->input->post('agentoffer'),
					"callerwish" => $this->input->post('callerwish'),
					"agentconfirm" => $this->input->post('agentconfirm'),
					"calleraddress" => $this->input->post('calleraddress'),
					"calleremail" => $this->input->post('calleremail'),
					"agentphone" => $this->input->post('agentphone'),
					"agentsummerize" => $this->input->post('agentsummerize'),
					"registerguest" => $this->input->post('registerguest'),
					"dispocall" => $this->input->post('dispocall'),
					"agentclosing" => $this->input->post('agentclosing'),
					"agenttone" => $this->input->post('agenttone'),
					"activelistening" => $this->input->post('activelistening'),
					"agentprofession" => $this->input->post('agentprofession'),
					"agentknowledge" => $this->input->post('agentknowledge'),
					"callcontrol" => $this->input->post('callcontrol'),
					"call_summary" => $this->input->post('call_summary'),
					"feedback" => $this->input->post('feedback')
				);
				$this->db->where('id', $tfid);
				$this->db->update('qa_amd_touchfuse_feedback',$field_array);
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
				$this->db->where('id', $tfid);
				$this->db->update('qa_amd_touchfuse_feedback',$field_array1);	
			///////////
				redirect('Qa_ameridial/touchfuse');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}
//////////////////////////////////////////////////////////////////////////
/*-------------------------- TOUCHFUSE (End) ---------------------------*/
//////////////////////////////////////////////////////////////////////////

///////////////////////////////////////////////////////////////////////////////////
/*------------------------------ TBN (Start) ------------------------------------*/
///////////////////////////////////////////////////////////////////////////////////	
	public function tbn_feedback(){
		if(check_logged_in())
		{
			$current_user = get_user_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_ameridial/tbn/tbn_feedback.php";
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,134) and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$from_date = $this->input->get('from_date');
			$to_date = $this->input->get('to_date');
			$agent_id = $this->input->get('agent_id');
			$file = $this->input->get('file');
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
			
			if($from_date !="" && $to_date!=="" )  $cond= " Where (date(audit_date) >= '$from_date' and date(audit_date) <= '$to_date' ) ";
			if($agent_id !="")	$cond .=" and agent_id='$agent_id'";
			if($file !="")	$cond .=" and file_no like '%$file%'";
			
			if(get_user_fusion_id()!='FMIN000011' || get_user_fusion_id()!='FUTA000007' || get_user_fusion_id()!='FUTA000012'){
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
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
				from qa_amd_tbn_feedback $cond) xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to from signin) yy on (xx.agent_id=yy.sid)
				$ops_cond order by audit_date";
			$data["tbn_data"] = $this->Common_model->get_query_result_array($qSql);
			
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			$data["agent_id"] = $agent_id;
			$data["file"] = $file;
			
			$this->load->view("dashboard",$data);
		}
	}
	public function add_tbn(){
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_ameridial/tbn/add_tbn.php";
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,134) and status=1  order by name";
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
					"call_date" => mmddyy2mysql($this->input->post('call_date')),
					"file_no" => $this->input->post('file_no'),
					"call_duration" => $this->input->post('call_duration'),
					"call_id" => $this->input->post('call_id'),
					"audit_type" => $this->input->post('audit_type'),
					"auditor_type" => $this->input->post('auditor_type'),
					"voc" => $this->input->post('voc'),
					"possible_score" => $this->input->post('possible_score'),
					"earned_score" => $this->input->post('earned_score'),
					"overall_score" => $this->input->post('overall_score'),
					"introrecord" => $this->input->post('introrecord'),
					"introcall" => $this->input->post('introcall'),
					"introname" => $this->input->post('introname'),
					"introstate" => $this->input->post('introstate'),
					"introscript" => $this->input->post('introscript'),
					"introdisclose" => $this->input->post('introdisclose'),
					"verifydonor" => $this->input->post('verifydonor'),
					"verifyaddress" => $this->input->post('verifyaddress'),
					"verifyspelled" => $this->input->post('verifyspelled'),
					"verifyemail" => $this->input->post('verifyemail'),
					"verifyback" => $this->input->post('verifyback'),
					"verifyasked" => $this->input->post('verifyasked'),
					"verifyconfirm" => $this->input->post('verifyconfirm'),
					"verifytype" => $this->input->post('verifytype'),
					"verifycell" => $this->input->post('verifycell'),
					"verifyaskalterphn" => $this->input->post('verifyaskalterphn'),
					"verifyalterphn" => $this->input->post('verifyalterphn'),
					"verifyalterno" => $this->input->post('verifyalterno'),
					"verifyconsent" => $this->input->post('verifyconsent'),
					"presentrequest" => $this->input->post('presentrequest'),
					"presenttieroffer" => $this->input->post('presenttieroffer'),
					"presentmonthask" => $this->input->post('presentmonthask'),
					"presentnavigate" => $this->input->post('presentnavigate'),
					"presenttbnknowledge" => $this->input->post('presenttbnknowledge'),
					"presentauthor" => $this->input->post('presentauthor'),
					"presentadherence" => $this->input->post('presentadherence'),
					"cartclosedonation" => $this->input->post('cartclosedonation'),
					"cartcloseamount" => $this->input->post('cartcloseamount'),
					"cartclosemonthly" => $this->input->post('cartclosemonthly'),
					"cartcloseresource" => $this->input->post('cartcloseresource'),
					"cartclosescript" => $this->input->post('cartclosescript'),
					"callhandleclearly" => $this->input->post('callhandleclearly'),
					"callhandledemeanor" => $this->input->post('callhandledemeanor'),
					"callhandlepace" => $this->input->post('callhandlepace'),
					"callhandlelisten" => $this->input->post('callhandlelisten'),
					"callhandleexhibit" => $this->input->post('callhandleexhibit'),
					"callhandlecommunicate" => $this->input->post('callhandlecommunicate'),
					"callhandlecontrol" => $this->input->post('callhandlecontrol'),
					"autofinfo" => $this->input->post('autofinfo'),
					"autofcall" => $this->input->post('autofcall'),
					"autofbehaviour" => $this->input->post('autofbehaviour'),
					"call_summary" => $this->input->post('call_summary'),
					"feedback" => $this->input->post('feedback'),
					"entry_date" => $curDateTime,
					"audit_start_time" => $this->input->post('audit_start_time')
				);
				$a = $this->amd_upload_files($_FILES['attach_file'], $path='./qa_files/qa_ameridial/tbn/');
				$field_array["attach_file"] = implode(',',$a);
				$rowid= data_inserter('qa_amd_tbn_feedback',$field_array);
			/////////////	
				if(get_login_type()=="client"){
					$field_array1 = array("client_entryby" => $current_user);
				}else{
					$field_array1 = array("entry_by" => $current_user);
				}
				$this->db->where('id', $rowid);
				$this->db->update('qa_amd_tbn_feedback',$field_array1);
			///////////	
				redirect('Qa_ameridial/tbn_feedback');
			}
			$data["array"] = $a;
			
			$this->load->view("dashboard",$data);
		}
	}
	
	
	
	public function mgnt_tbn_rvw($id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_ameridial/tbn/mgnt_tbn_rvw.php";
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM signin where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,134) and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql="SELECT * from 
			(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, 
			(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
			(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
			from qa_amd_tbn_feedback where id='$id') xx Left Join (Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, office_id from signin) yy on (xx.agent_id=yy.sid)";
			$data["tbn_data"] = $this->Common_model->get_query_row_array($qSql);
			
			$data["tbnid"]=$id;
			
			if($this->input->post('tbnid'))
			{
				$tbnid=$this->input->post('tbnid');
				$curDateTime=CurrMySqlDate();
				$log=get_logs();
				
				$field_array = array(
					"agent_id" => $this->input->post('agent_id'),
					"tl_id" => $this->input->post('tl_id'),
					"call_date" => mmddyy2mysql($this->input->post('call_date')),
					"file_no" => $this->input->post('file_no'),
					"call_duration" => $this->input->post('call_duration'),
					"call_id" => $this->input->post('call_id'),
					"audit_type" => $this->input->post('audit_type'),
					"auditor_type" => $this->input->post('auditor_type'),
					"voc" => $this->input->post('voc'),
					"possible_score" => $this->input->post('possible_score'),
					"earned_score" => $this->input->post('earned_score'),
					"overall_score" => $this->input->post('overall_score'),
					"introrecord" => $this->input->post('introrecord'),
					"introcall" => $this->input->post('introcall'),
					"introname" => $this->input->post('introname'),
					"introstate" => $this->input->post('introstate'),
					"introscript" => $this->input->post('introscript'),
					"introdisclose" => $this->input->post('introdisclose'),
					"verifydonor" => $this->input->post('verifydonor'),
					"verifyaddress" => $this->input->post('verifyaddress'),
					"verifyspelled" => $this->input->post('verifyspelled'),
					"verifyemail" => $this->input->post('verifyemail'),
					"verifyback" => $this->input->post('verifyback'),
					"verifyasked" => $this->input->post('verifyasked'),
					"verifyconfirm" => $this->input->post('verifyconfirm'),
					"verifytype" => $this->input->post('verifytype'),
					"verifycell" => $this->input->post('verifycell'),
					"verifyaskalterphn" => $this->input->post('verifyaskalterphn'),
					"verifyalterphn" => $this->input->post('verifyalterphn'),
					"verifyalterno" => $this->input->post('verifyalterno'),
					"verifyconsent" => $this->input->post('verifyconsent'),
					"presentrequest" => $this->input->post('presentrequest'),
					"presenttieroffer" => $this->input->post('presenttieroffer'),
					"presentmonthask" => $this->input->post('presentmonthask'),
					"presentnavigate" => $this->input->post('presentnavigate'),
					"presenttbnknowledge" => $this->input->post('presenttbnknowledge'),
					"presentauthor" => $this->input->post('presentauthor'),
					"presentadherence" => $this->input->post('presentadherence'),
					"cartclosedonation" => $this->input->post('cartclosedonation'),
					"cartcloseamount" => $this->input->post('cartcloseamount'),
					"cartclosemonthly" => $this->input->post('cartclosemonthly'),
					"cartcloseresource" => $this->input->post('cartcloseresource'),
					"cartclosescript" => $this->input->post('cartclosescript'),
					"callhandleclearly" => $this->input->post('callhandleclearly'),
					"callhandledemeanor" => $this->input->post('callhandledemeanor'),
					"callhandlepace" => $this->input->post('callhandlepace'),
					"callhandlelisten" => $this->input->post('callhandlelisten'),
					"callhandleexhibit" => $this->input->post('callhandleexhibit'),
					"callhandlecommunicate" => $this->input->post('callhandlecommunicate'),
					"callhandlecontrol" => $this->input->post('callhandlecontrol'),
					"autofinfo" => $this->input->post('autofinfo'),
					"autofcall" => $this->input->post('autofcall'),
					"autofbehaviour" => $this->input->post('autofbehaviour'),
					"call_summary" => $this->input->post('call_summary'),
					"feedback" => $this->input->post('feedback')
				);
				$this->db->where('id', $tbnid);
				$this->db->update('qa_amd_tbn_feedback',$field_array);
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
				$this->db->where('id', $tbnid);
				$this->db->update('qa_amd_tbn_feedback',$field_array1);	
			///////////
				redirect('Qa_ameridial/tbn_feedback');
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}
///////////////////////////////////////////////////////////////////////////////////
/*--------------------------------- TBN (End) -----------------------------------*/
///////////////////////////////////////////////////////////////////////////////////	

///////////////////////////////////////////////////////////////////////////////////
/*------------------------ TPM Scoresheet (Start) -------------------------------*/
///////////////////////////////////////////////////////////////////////////////////	
	public function tpm_feedback(){
		if(check_logged_in())
		{
			$current_user = get_user_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_ameridial/tpm/tpm_feedback.php";
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,134) and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$from_date = $this->input->get('from_date');
			$to_date = $this->input->get('to_date');
			$agent_id = $this->input->get('agent_id');
			$file = $this->input->get('file');
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
			
			if($from_date !="" && $to_date!=="" )  $cond= " Where (date(audit_date) >= '$from_date' and date(audit_date) <= '$to_date' ) ";
			if($agent_id !="")	$cond .=" and agent_id='$agent_id'";
			if($file !="")	$cond .=" and file_no like '%$file%'";
			
			if(get_user_fusion_id()!='FMIN000011' || get_user_fusion_id()!='FUTA000007' || get_user_fusion_id()!='FUTA000012'){
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
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, (select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_amd_tpm_feedback $cond) xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";
			$data["tpm_data"] = $this->Common_model->get_query_result_array($qSql);
			
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			$data["agent_id"] = $agent_id;
			$data["file"] = $file;
			
			$this->load->view("dashboard",$data);
		}
	}
	public function add_tpm(){
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_ameridial/tpm/add_tpm.php";
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,134) and status=1  order by name";
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
					"call_date" => mmddyy2mysql($this->input->post('call_date')),
					"file_no" => $this->input->post('file_no'),
					"call_duration" => $this->input->post('call_duration'),
					"audit_type" => $this->input->post('audit_type'),
					"auditor_type" => $this->input->post('auditor_type'),
					"voc" => $this->input->post('voc'),
					"possible_score" => $this->input->post('possible_score'),
					"earned_score" => $this->input->post('earned_score'),
					"overall_score" => $this->input->post('overall_score'),
					"introcall" => $this->input->post('introcall'),
					"verifycall" => $this->input->post('verifycall'),
					"verifypayment" => $this->input->post('verifypayment'),
					"verifycommunicator" => $this->input->post('verifycommunicator'),
					"verifyspelledname" => $this->input->post('verifyspelledname'),
					"verifyaskedaddress" => $this->input->post('verifyaskedaddress'),
					"verifyspelledaddress" => $this->input->post('verifyspelledaddress'),
					"verifyaskedphone" => $this->input->post('verifyaskedphone'),
					"verifycommunicatorphone" => $this->input->post('verifycommunicatorphone'),
					"verifylandline" => $this->input->post('verifylandline'),
					"verifycallverbatim" => $this->input->post('verifycallverbatim'),
					"verifytextverbatim" => $this->input->post('verifytextverbatim'),
					"verifyaskedemail" => $this->input->post('verifyaskedemail'),
					"verifyspelledemail" => $this->input->post('verifyspelledemail'),
					"scriptadherence" => $this->input->post('scriptadherence'),
					"scripthighertier" => $this->input->post('scripthighertier'),
					"scriptnavigate" => $this->input->post('scriptnavigate'),
					"scriptdisplaytpm" => $this->input->post('scriptdisplaytpm'),
					"closedcontent" => $this->input->post('closedcontent'),
					"closedmonthlyask" => $this->input->post('closedmonthlyask'),
					"closedshippingtime" => $this->input->post('closedshippingtime'),
					"closedprovidecart" => $this->input->post('closedprovidecart'),
					"closedreadscript" => $this->input->post('closedreadscript'),
					"callhandlespeakclearly" => $this->input->post('callhandlespeakclearly'),
					"callhandledemeanor" => $this->input->post('callhandledemeanor'),
					"callhandleprofesionalism" => $this->input->post('callhandleprofesionalism'),
					"callhandlepace" => $this->input->post('callhandlepace'),
					"callhandleresponds" => $this->input->post('callhandleresponds'),
					"callhandleemphaty" => $this->input->post('callhandleemphaty'),
					"callhandledonor" => $this->input->post('callhandledonor'),
					"callhandletalktime" => $this->input->post('callhandletalktime'),
					"autofinfo" => $this->input->post('autofinfo'),
					"autofhungup" => $this->input->post('autofhungup'),
					"autofrude" => $this->input->post('autofrude'),
					"call_summary" => $this->input->post('call_summary'),
					"feedback" => $this->input->post('feedback'),
					"entry_date" => $curDateTime,
					"audit_start_time" => $this->input->post('audit_start_time')
				);
				$a = $this->amd_upload_files($_FILES['attach_file'], $path='./qa_files/qa_ameridial/tpm/');
				$field_array["attach_file"] = implode(',',$a);
				$rowid= data_inserter('qa_amd_tpm_feedback',$field_array);
			/////////////	
				if(get_login_type()=="client"){
					$field_array1 = array("client_entryby" => $current_user);
				}else{
					$field_array1 = array("entry_by" => $current_user);
				}
				$this->db->where('id', $rowid);
				$this->db->update('qa_amd_tpm_feedback',$field_array1);
			///////////		
				redirect('Qa_ameridial/tpm_feedback');
			}
			$data["array"] = $a;
			
			$this->load->view("dashboard",$data);
		}
	}
	
	
	public function mgnt_tpm_rvw($id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_ameridial/tpm/mgnt_tpm_rvw.php";
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM signin where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,134) and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql="SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, (select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_amd_tpm_feedback where id='$id') xx Left Join (Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, office_id from signin) yy on (xx.agent_id=yy.sid)";
			$data["tpm_data"] = $this->Common_model->get_query_row_array($qSql);
			
			$data["tpmid"]=$id;
			
		///////Edit Part///////	
			if($this->input->post('tpmid'))
			{
				$tpmid=$this->input->post('tpmid');
				$curDateTime=CurrMySqlDate();
				$log=get_logs();
				
				$field_array = array(
					"agent_id" => $this->input->post('agent_id'),
					"tl_id" => $this->input->post('tl_id'),
					"call_date" => mmddyy2mysql($this->input->post('call_date')),
					"file_no" => $this->input->post('file_no'),
					"call_duration" => $this->input->post('call_duration'),
					"audit_type" => $this->input->post('audit_type'),
					"auditor_type" => $this->input->post('auditor_type'),
					"voc" => $this->input->post('voc'),
					"possible_score" => $this->input->post('possible_score'),
					"earned_score" => $this->input->post('earned_score'),
					"overall_score" => $this->input->post('overall_score'),
					"introcall" => $this->input->post('introcall'),
					"verifycall" => $this->input->post('verifycall'),
					"verifypayment" => $this->input->post('verifypayment'),
					"verifycommunicator" => $this->input->post('verifycommunicator'),
					"verifyspelledname" => $this->input->post('verifyspelledname'),
					"verifyaskedaddress" => $this->input->post('verifyaskedaddress'),
					"verifyspelledaddress" => $this->input->post('verifyspelledaddress'),
					"verifyaskedphone" => $this->input->post('verifyaskedphone'),
					"verifycommunicatorphone" => $this->input->post('verifycommunicatorphone'),
					"verifylandline" => $this->input->post('verifylandline'),
					"verifycallverbatim" => $this->input->post('verifycallverbatim'),
					"verifytextverbatim" => $this->input->post('verifytextverbatim'),
					"verifyaskedemail" => $this->input->post('verifyaskedemail'),
					"verifyspelledemail" => $this->input->post('verifyspelledemail'),
					"scriptadherence" => $this->input->post('scriptadherence'),
					"scripthighertier" => $this->input->post('scripthighertier'),
					"scriptnavigate" => $this->input->post('scriptnavigate'),
					"scriptdisplaytpm" => $this->input->post('scriptdisplaytpm'),
					"closedcontent" => $this->input->post('closedcontent'),
					"closedmonthlyask" => $this->input->post('closedmonthlyask'),
					"closedshippingtime" => $this->input->post('closedshippingtime'),
					"closedprovidecart" => $this->input->post('closedprovidecart'),
					"closedreadscript" => $this->input->post('closedreadscript'),
					"callhandlespeakclearly" => $this->input->post('callhandlespeakclearly'),
					"callhandledemeanor" => $this->input->post('callhandledemeanor'),
					"callhandleprofesionalism" => $this->input->post('callhandleprofesionalism'),
					"callhandlepace" => $this->input->post('callhandlepace'),
					"callhandleresponds" => $this->input->post('callhandleresponds'),
					"callhandleemphaty" => $this->input->post('callhandleemphaty'),
					"callhandledonor" => $this->input->post('callhandledonor'),
					"callhandletalktime" => $this->input->post('callhandletalktime'),
					"autofinfo" => $this->input->post('autofinfo'),
					"autofhungup" => $this->input->post('autofhungup'),
					"autofrude" => $this->input->post('autofrude'),
					"call_summary" => $this->input->post('call_summary'),
					"feedback" => $this->input->post('feedback')
				);
				$this->db->where('id', $tpmid);
				$this->db->update('qa_amd_tpm_feedback',$field_array);
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
				$this->db->where('id', $tpmid);
				$this->db->update('qa_amd_tpm_feedback',$field_array1);	
			///////////
				redirect('Qa_ameridial/tpm_feedback');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}
///////////////////////////////////////////////////////////////////////////////////
/*------------------------ TPM Scoresheet (End) ---------------------------------*/
///////////////////////////////////////////////////////////////////////////////////

///////////////////////////////////////////////////////////////////////////////////
/*---------------------------- Patchology (Start) -------------------------------*/
///////////////////////////////////////////////////////////////////////////////////	
	public function patchology_feedback(){
		if(check_logged_in())
		{
			$current_user = get_user_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_ameridial/patchology/patchology_feedback.php";
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,134) and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$from_date = $this->input->get('from_date');
			$to_date = $this->input->get('to_date');
			$agent_id = $this->input->get('agent_id');
			$file = $this->input->get('file');
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
			
			if($from_date !="" && $to_date!=="" )  $cond= " Where (date(audit_date) >= '$from_date' and date(audit_date) <= '$to_date' ) ";
			if($agent_id !="")	$cond .=" and agent_id='$agent_id'";
			if($file !="")	$cond .=" and file_no like '%$file%'";
			
			if(get_user_fusion_id()!='FMIN000011' || get_user_fusion_id()!='FUTA000007' || get_user_fusion_id()!='FUTA000012'){
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
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, (select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_amd_patchology_feedback $cond) xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";
			$data["patchology_data"] = $this->Common_model->get_query_result_array($qSql);
			
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			$data["agent_id"] = $agent_id;
			$data["file"] = $file;
			
			$this->load->view("dashboard",$data);
		}
	}
	
	
	public function add_patchology(){
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_ameridial/patchology/add_patchology.php";
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,134) and status=1  order by name";
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
					"call_date" => mmddyy2mysql($this->input->post('call_date')),
					"file_no" => $this->input->post('file_no'),
					"call_duration" => $this->input->post('call_duration'),
					"audit_type" => $this->input->post('audit_type'),
					"auditor_type" => $this->input->post('auditor_type'),
					"voc" => $this->input->post('voc'),
					"possible_score" => $this->input->post('possible_score'),
					"earned_score" => $this->input->post('earned_score'),
					"overall_score" => $this->input->post('overall_score'),
					"agentcallopening" => $this->input->post('agentcallopening'),
					"agentclosecall" => $this->input->post('agentclosecall'),
					"agentverifyinformation" => $this->input->post('agentverifyinformation'),
					"agentprovideinformation" => $this->input->post('agentprovideinformation'),
					"agenthippinginformation" => $this->input->post('agenthippinginformation'),
					"callanswertimely" => $this->input->post('callanswertimely'),
					"agentengagedcustomer" => $this->input->post('agentengagedcustomer'),
					"customersatisfaction" => $this->input->post('customersatisfaction'),
					"escalatedresources" => $this->input->post('escalatedresources'),
					"remarks1" => $this->input->post('remarks1'),
					"remarks2" => $this->input->post('remarks2'),
					"remarks3" => $this->input->post('remarks3'),
					"call_summary" => $this->input->post('call_summary'),
					"feedback" => $this->input->post('feedback'),
					"entry_date" => $curDateTime,
					"audit_start_time" => $this->input->post('audit_start_time')
				);
				$a = $this->patchology_upload_files($_FILES['attach_file'], $path='./qa_files/qa_ameridial/patchology/');
				$field_array["attach_file"] = implode(',',$a);
				$rowid= data_inserter('qa_amd_patchology_feedback',$field_array);
			/////////////	
				if(get_login_type()=="client"){
					$field_array1 = array("client_entryby" => $current_user);
				}else{
					$field_array1 = array("entry_by" => $current_user);
				}
				$this->db->where('id', $rowid);
				$this->db->update('qa_amd_patchology_feedback',$field_array1);
			///////////		
				redirect('Qa_ameridial/patchology_feedback');
			}
			$data["array"] = $a;
			$this->load->view("dashboard",$data);
		}
	}
	
	public function mgnt_patchology_rvw($id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_ameridial/patchology/mgnt_patchology_rvw.php";
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM signin where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,134) and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql="SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, (select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_amd_patchology_feedback where id='$id') xx Left Join (Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, office_id from signin) yy on (xx.agent_id=yy.sid)";
			$data["patchology_data"] = $this->Common_model->get_query_row_array($qSql);
			
			$data["ptcid"]=$id;
			
		///////Edit Part///////	
			if($this->input->post('ptcid'))
			{
				$ptcid=$this->input->post('ptcid');
				$curDateTime=CurrMySqlDate();
				$log=get_logs();
				
				$field_array = array(
					"agent_id" => $this->input->post('agent_id'),
					"tl_id" => $this->input->post('tl_id'),
					"call_date" => mmddyy2mysql($this->input->post('call_date')),
					"file_no" => $this->input->post('file_no'),
					"call_duration" => $this->input->post('call_duration'),
					"audit_type" => $this->input->post('audit_type'),
					"auditor_type" => $this->input->post('auditor_type'),
					"voc" => $this->input->post('voc'),
					"possible_score" => $this->input->post('possible_score'),
					"earned_score" => $this->input->post('earned_score'),
					"overall_score" => $this->input->post('overall_score'),
					"agentcallopening" => $this->input->post('agentcallopening'),
					"agentclosecall" => $this->input->post('agentclosecall'),
					"agentverifyinformation" => $this->input->post('agentverifyinformation'),
					"agentprovideinformation" => $this->input->post('agentprovideinformation'),
					"agenthippinginformation" => $this->input->post('agenthippinginformation'),
					"callanswertimely" => $this->input->post('callanswertimely'),
					"agentengagedcustomer" => $this->input->post('agentengagedcustomer'),
					"customersatisfaction" => $this->input->post('customersatisfaction'),
					"escalatedresources" => $this->input->post('escalatedresources'),
					"remarks1" => $this->input->post('remarks1'),
					"remarks2" => $this->input->post('remarks2'),
					"remarks3" => $this->input->post('remarks3'),
					"call_summary" => $this->input->post('call_summary'),
					"feedback" => $this->input->post('feedback')
				);
				$this->db->where('id', $ptcid);
				$this->db->update('qa_amd_patchology_feedback',$field_array);
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
				$this->db->where('id', $ptcid);
				$this->db->update('qa_amd_patchology_feedback',$field_array1);	
			///////////
				redirect('Qa_ameridial/patchology_feedback');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}
///////////////////////////////////////////////////////////////////////////////////
/*---------------------------- Patchology (End) ---------------------------------*/
///////////////////////////////////////////////////////////////////////////////////

///////////////////////////////////////////////////////////////////////////////////
/*---------------------------- Heat Surge (Start) -------------------------------*/
///////////////////////////////////////////////////////////////////////////////////	
	public function heatsurge_feedback(){
		if(check_logged_in())
		{
			$current_user = get_user_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_ameridial/heatsurge/heatsurge_feedback.php";
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,134) and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$from_date = $this->input->get('from_date');
			$to_date = $this->input->get('to_date');
			$agent_id = $this->input->get('agent_id');
			$file = $this->input->get('file');
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
			
			if($from_date !="" && $to_date!=="" )  $cond= " Where (date(audit_date) >= '$from_date' and date(audit_date) <= '$to_date' ) ";
			if($agent_id !="")	$cond .=" and agent_id='$agent_id'";
			if($file !="")	$cond .=" and file_no like '%$file%'";
			
			if(get_user_fusion_id()!='FMIN000011' || get_user_fusion_id()!='FUTA000007' || get_user_fusion_id()!='FUTA000012'){
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
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, (select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_amd_heatsurge_feedback $cond) xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";
			$data["heatsurge_data"] = $this->Common_model->get_query_result_array($qSql);
			
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			$data["agent_id"] = $agent_id;
			$data["file"] = $file;
			
			$this->load->view("dashboard",$data);
		}
	}
	
	
	public function add_heatsurge(){
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_ameridial/heatsurge/add_heatsurge.php";
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,134) and status=1  order by name";
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
					"call_date" => mmddyy2mysql($this->input->post('call_date')),
					"file_no" => $this->input->post('file_no'),
					"call_duration" => $this->input->post('call_duration'),
					"audit_type" => $this->input->post('audit_type'),
					"auditor_type" => $this->input->post('auditor_type'),
					"voc" => $this->input->post('voc'),
					"possible_score" => $this->input->post('possible_score'),
					"earned_score" => $this->input->post('earned_score'),
					"overall_score" => $this->input->post('overall_score'),
					"callprepared5sec" => $this->input->post('callprepared5sec'),
					"useibobgreeting" => $this->input->post('useibobgreeting'),
					"accesscustomeraccount" => $this->input->post('accesscustomeraccount'),
					"vreifynameaddress" => $this->input->post('vreifynameaddress'),
					"askforemail" => $this->input->post('askforemail'),
					"readminiMiranda" => $this->input->post('readminiMiranda'),
					"giveaccuratepricing" => $this->input->post('giveaccuratepricing'),
					"giveaccurateshiping" => $this->input->post('giveaccurateshiping'),
					"accuratedescribeproduct" => $this->input->post('accuratedescribeproduct'),
					"askforupsellproduct" => $this->input->post('askforupsellproduct'),
					"provideappropiatesolution" => $this->input->post('provideappropiatesolution'),
					"codedordercorrectly" => $this->input->post('codedordercorrectly'),
					"askforcancelarion" => $this->input->post('askforcancelarion'),
					"usePKkeybuying" => $this->input->post('usePKkeybuying'),
					"useappropiateguideline" => $this->input->post('useappropiateguideline'),
					"askforbillingname" => $this->input->post('askforbillingname'),
					"authorizeuserofcheck" => $this->input->post('authorizeuserofcheck'),
					"billingaddressforpayment" => $this->input->post('billingaddressforpayment'),
					"permissiontoauthorizepayment" => $this->input->post('permissiontoauthorizepayment'),
					"vrifyshippingaddress" => $this->input->post('vrifyshippingaddress'),
					"accountwithissue" => $this->input->post('accountwithissue'),
					"summarizesreviewcall" => $this->input->post('summarizesreviewcall'),
					"gaveCSphonenumber" => $this->input->post('gaveCSphonenumber'),
					"wasagentpolite" => $this->input->post('wasagentpolite'),
					"usinginappropiatecomment" => $this->input->post('usinginappropiatecomment'),
					"usesholdtrasferproperly" => $this->input->post('usesholdtrasferproperly'),
					"automaticzero" => $this->input->post('automaticzero'),
					"call_summary" => $this->input->post('call_summary'),
					"feedback" => $this->input->post('feedback'),
					"entry_date" => $curDateTime,
					"audit_start_time" => $this->input->post('audit_start_time')
				);
				$a = $this->amd_upload_files($_FILES['attach_file'], $path='./qa_files/qa_ameridial/heatsurge/');
				$field_array["attach_file"] = implode(',',$a);
				$rowid= data_inserter('qa_amd_heatsurge_feedback',$field_array);
			/////////////	
				if(get_login_type()=="client"){
					$field_array1 = array("client_entryby" => $current_user);
				}else{
					$field_array1 = array("entry_by" => $current_user);
				}
				$this->db->where('id', $rowid);
				$this->db->update('qa_amd_heatsurge_feedback',$field_array1);
			///////////	
				redirect('Qa_ameridial/heatsurge_feedback');
			}
			$data["array"] = $a;
			
			$this->load->view("dashboard",$data);
		}
	}
	
	
	public function mgnt_heatsurge_rvw($id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_ameridial/heatsurge/mgnt_heatsurge_rvw.php";
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM signin where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,134) and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql="SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, (select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_amd_heatsurge_feedback where id='$id') xx Left Join (Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, office_id from signin) yy on (xx.agent_id=yy.sid)";
			$data["heatsurge_data"] = $this->Common_model->get_query_row_array($qSql);
			
			$data["hsid"]=$id;
			
		///////Edit Part///////	
			if($this->input->post('hsid'))
			{
				$hsid=$this->input->post('hsid');
				$curDateTime=CurrMySqlDate();
				$log=get_logs();
				
				$field_array = array(
					"agent_id" => $this->input->post('agent_id'),
					"tl_id" => $this->input->post('tl_id'),
					"call_date" => mmddyy2mysql($this->input->post('call_date')),
					"file_no" => $this->input->post('file_no'),
					"call_duration" => $this->input->post('call_duration'),
					"audit_type" => $this->input->post('audit_type'),
					"auditor_type" => $this->input->post('auditor_type'),
					"voc" => $this->input->post('voc'),
					"possible_score" => $this->input->post('possible_score'),
					"earned_score" => $this->input->post('earned_score'),
					"overall_score" => $this->input->post('overall_score'),
					"callprepared5sec" => $this->input->post('callprepared5sec'),
					"useibobgreeting" => $this->input->post('useibobgreeting'),
					"accesscustomeraccount" => $this->input->post('accesscustomeraccount'),
					"vreifynameaddress" => $this->input->post('vreifynameaddress'),
					"askforemail" => $this->input->post('askforemail'),
					"readminiMiranda" => $this->input->post('readminiMiranda'),
					"giveaccuratepricing" => $this->input->post('giveaccuratepricing'),
					"giveaccurateshiping" => $this->input->post('giveaccurateshiping'),
					"accuratedescribeproduct" => $this->input->post('accuratedescribeproduct'),
					"askforupsellproduct" => $this->input->post('askforupsellproduct'),
					"provideappropiatesolution" => $this->input->post('provideappropiatesolution'),
					"codedordercorrectly" => $this->input->post('codedordercorrectly'),
					"askforcancelarion" => $this->input->post('askforcancelarion'),
					"usePKkeybuying" => $this->input->post('usePKkeybuying'),
					"useappropiateguideline" => $this->input->post('useappropiateguideline'),
					"askforbillingname" => $this->input->post('askforbillingname'),
					"authorizeuserofcheck" => $this->input->post('authorizeuserofcheck'),
					"billingaddressforpayment" => $this->input->post('billingaddressforpayment'),
					"permissiontoauthorizepayment" => $this->input->post('permissiontoauthorizepayment'),
					"vrifyshippingaddress" => $this->input->post('vrifyshippingaddress'),
					"accountwithissue" => $this->input->post('accountwithissue'),
					"summarizesreviewcall" => $this->input->post('summarizesreviewcall'),
					"gaveCSphonenumber" => $this->input->post('gaveCSphonenumber'),
					"wasagentpolite" => $this->input->post('wasagentpolite'),
					"usinginappropiatecomment" => $this->input->post('usinginappropiatecomment'),
					"usesholdtrasferproperly" => $this->input->post('usesholdtrasferproperly'),
					"automaticzero" => $this->input->post('automaticzero'),
					"call_summary" => $this->input->post('call_summary'),
					"feedback" => $this->input->post('feedback')
				);
				$this->db->where('id', $hsid);
				$this->db->update('qa_amd_heatsurge_feedback',$field_array);
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
				$this->db->where('id', $hsid);
				$this->db->update('qa_amd_heatsurge_feedback',$field_array1);	
			///////////
				redirect('Qa_ameridial/heatsurge_feedback');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}
///////////////////////////////////////////////////////////////////////////////////
/*---------------------------- Heat Surge (End) ---------------------------------*/
///////////////////////////////////////////////////////////////////////////////////


///////////////////////////////////////////////////////////////////////////////////
/*-------------------------- ASPCA (Start) ---------------------------*/
///////////////////////////////////////////////////////////////////////////////////	
	public function aspca(){
		if(check_logged_in())
		{
			$current_user = get_user_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_ameridial/aspca/qa_feedback.php";
			
			$from_date = $this->input->get('from_date');
			$to_date = $this->input->get('to_date');
			$agent_id = $this->input->get('agent_id');
			$file = $this->input->get('file');
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
			
			if($from_date !="" && $to_date!=="" )  $cond= " Where (date(audit_date) >= '$from_date' and date(audit_date) <= '$to_date' ) ";
			if($agent_id !="")	$cond .=" and agent_id='$agent_id'";
			if($file !="")	$cond .=" and file_no like '%$file%'";
			
			if(get_user_fusion_id()!='FMIN000011' || get_user_fusion_id()!='FUTA000007' || get_user_fusion_id()!='FUTA000012'){
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
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_name
				from qa_amd_aspca_feedback $cond) xx Left Join
				(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";
			$data["aspca_data"] = $this->Common_model->get_query_result_array($qSql);
			
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			$data["agent_id"] = $agent_id;
			$data["file"] = $file;
			
			$this->load->view("dashboard",$data);
		}
	}
	
	public function add_aspca_feedback(){
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_ameridial/aspca/add_feedback.php";
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,134) and status=1  order by name";
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
					"call_date" => mmddyy2mysql($this->input->post('call_date')),
					"file_no" => $this->input->post('file_no'),
					"call_duration" => $this->input->post('call_duration'),
					"audit_type" => $this->input->post('audit_type'),
					"auditor_type" => $this->input->post('auditor_type'),
					"voc" => $this->input->post('voc'),
					"possible_score" => $this->input->post('possible_score'),
					"earned_score" => $this->input->post('earned_score'),
					"overall_score" => $this->input->post('overall_score'),
					"Greet_customer" => $this->input->post('text1'),
					"Uses_professionalism" => $this->input->post('text2'),
					"Shows_gratitude" => $this->input->post('text3'),
					"Collects_verifies" => $this->input->post('text4'),
					"guardians_program" => $this->input->post('text5'),
					"gift_scripting" => $this->input->post('text7'),
					"payment_scripting" => $this->input->post('text8'),
					"Animal_champion" => $this->input->post('text9'),
					"donation_processing" => $this->input->post('text10'),
					"pet_insurance" => $this->input->post('text12'),
					"correct_script" => $this->input->post('text13'),
					"call_control" => $this->input->post('text14'),
					"min_deadair" => $this->input->post('text15'),
					"faq" => $this->input->post('text16'),
					"personalizes_call" => $this->input->post('text17'),
					"monthly_guardian" => $this->input->post('text6'),
					"onetime_donation" => $this->input->post('text11'),
					"call_summary" => $this->input->post('call_summary'),
					"feedback" => $this->input->post('feedback'),
					"entry_date" => $curDateTime,
					"audit_start_time" => $this->input->post('audit_start_time')
				);
				$a = $this->amd_upload_files($_FILES['attach_file'], $path='./qa_files/qa_ameridial/aspca/');
				$field_array["attach_file"] = implode(',',$a);
				$rowid= data_inserter('qa_amd_aspca_feedback',$field_array);
			/////////////	
				if(get_login_type()=="client"){
					$field_array1 = array("client_entryby" => $current_user);
				}else{
					$field_array1 = array("entry_by" => $current_user);
				}
				$this->db->where('id', $rowid);
				$this->db->update('qa_amd_aspca_feedback',$field_array1);
			///////////
				redirect('Qa_ameridial/aspca');
			}
			$data["array"] = $a;
			
			$this->load->view("dashboard",$data);
		}
	}
	
	public function mgnt_aspca_rvw($id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_ameridial/aspca/mgnt_rvw.php";
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM signin where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,134) and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
				from qa_amd_aspca_feedback where id='$id') xx Left Join
				(Select office_id,id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid)";
			$data["aspca_data"] = $this->Common_model->get_query_row_array($qSql);
			
			$data["fbid"]=$id;
			
			if($this->input->post('fbid'))
			{
				$fbid=$this->input->post('fbid');
				$curDateTime=CurrMySqlDate();
				$log=get_logs();
				
				$field_array = array(
					"agent_id" => $this->input->post('agent_id'),
					"tl_id" => $this->input->post('tl_id'),
					"call_date" => mmddyy2mysql($this->input->post('call_date')),
					"file_no" => $this->input->post('file_no'),
					"call_duration" => $this->input->post('call_duration'),
					"audit_type" => $this->input->post('audit_type'),
					"auditor_type" => $this->input->post('auditor_type'),
					"voc" => $this->input->post('voc'),
					"possible_score" => $this->input->post('possible_score'),
					"earned_score" => $this->input->post('earned_score'),
					"overall_score" => $this->input->post('overall_score'),
					"Greet_customer" => $this->input->post('text1'),
					"Uses_professionalism" => $this->input->post('text2'),
					"Shows_gratitude" => $this->input->post('text3'),
					"Collects_verifies" => $this->input->post('text4'),
					"guardians_program" => $this->input->post('text5'),
					"gift_scripting" => $this->input->post('text7'),
					"payment_scripting" => $this->input->post('text8'),
					"Animal_champion" => $this->input->post('text9'),
					"donation_processing" => $this->input->post('text10'),
					"pet_insurance" => $this->input->post('text12'),
					"correct_script" => $this->input->post('text13'),
					"call_control" => $this->input->post('text14'),
					"min_deadair" => $this->input->post('text15'),
					"faq" => $this->input->post('text16'),
					"personalizes_call" => $this->input->post('text17'),
					"monthly_guardian" => $this->input->post('text6'),
					"onetime_donation" => $this->input->post('text11'),
					"call_summary" => $this->input->post('call_summary'),
					"feedback" => $this->input->post('feedback')
				);
				$this->db->where('id', $fbid);
				$this->db->update('qa_amd_aspca_feedback',$field_array);
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
				$this->db->where('id', $fbid);
				$this->db->update('qa_amd_aspca_feedback',$field_array1);	
			///////////
				redirect('Qa_ameridial/aspca');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}
///////////////////////////////////////////////////////////////////////////////////
/*-------------------------- ASPCA (End) ---------------------------*/
///////////////////////////////////////////////////////////////////////////////////	

///////////////////////////////////////////////////////////////////////////////////
/*--------------- FILTER FIRST AGENT IMPROVEMENT  (Start) -----------------------*/
///////////////////////////////////////////////////////////////////////////////////	
	public function ffai(){
		if(check_logged_in())
		{
			$current_user = get_user_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_ameridial/ffaif/qa_feedback.php";
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,134) and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$from_date = $this->input->get('from_date');
			$to_date = $this->input->get('to_date');
			$agent_id = $this->input->get('agent_id');
			$file = $this->input->get('file');
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
			
			if($from_date !="" && $to_date!=="" )  $cond= " Where (date(audit_date) >= '$from_date' and date(audit_date) <= '$to_date' ) ";
			if($agent_id !="")	$cond .=" and agent_id='$agent_id'";
			if($file !="")	$cond .=" and file_no like '%$file%'";
			
			if(get_user_fusion_id()!='FMIN000011' || get_user_fusion_id()!='FUTA000007' || get_user_fusion_id()!='FUTA000012'){
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
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_name
				from qa_amd_ffai_feedback $cond) xx Left Join
				(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";
			$data["aspca_data"] = $this->Common_model->get_query_result_array($qSql);
			
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			$data["agent_id"] = $agent_id;
			$data["file"] = $file;
			
			$this->load->view("dashboard",$data);
		}
	}

	
	public function add_ffai_feedback(){
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_ameridial/ffaif/add_feedback.php";
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,134) and status=1  order by name";
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
					"call_date" => mmddyy2mysql($this->input->post('call_date')),
					"file_no" => $this->input->post('file_no'),
					"call_duration" => $this->input->post('call_duration'),
					"audit_type" => $this->input->post('audit_type'),
					"auditor_type" => $this->input->post('auditor_type'),
					"voc" => $this->input->post('voc'),
					"possible_score" => $this->input->post('possible_score'),
					"earned_score" => $this->input->post('earned_score'),
					"overall_score" => $this->input->post('overall_score'),
					"open_call_appropriate_branding" => $this->input->post('text1'),
					"close_call_appropriate_branding" => $this->input->post('text2'),
					"before_with_filtersfast" => $this->input->post('text3'),
					"address_using_nato" => $this->input->post('text4'),
					"products_availability" => $this->input->post('text5'),
					"one_call_resolution" => $this->input->post('text6'),
					"agent_accurately_clearly" => $this->input->post('text7'),
					"agent_engaged_customer" => $this->input->post('text8'),
					"membership" => $this->input->post('text9'),
					"offer_donation" => $this->input->post('text10'),
					"explored_before_transferring" => $this->input->post('text11'),
					"call_summary" => $this->input->post('call_summary'),
					"feedback" => $this->input->post('feedback'),
					"entry_date" => $curDateTime,
					"audit_start_time" => $this->input->post('audit_start_time')
				);
				$a = $this->amd_upload_files($_FILES['attach_file'], $path='./qa_files/qa_ameridial/ffai/');
				$field_array["attach_file"] = implode(',',$a);
				$rowid= data_inserter('qa_amd_ffai_feedback',$field_array);
			/////////////	
				if(get_login_type()=="client"){
					$field_array1 = array("client_entryby" => $current_user);
				}else{
					$field_array1 = array("entry_by" => $current_user);
				}
				$this->db->where('id', $rowid);
				$this->db->update('qa_amd_ffai_feedback',$field_array1);
			///////////
				redirect('Qa_ameridial/ffai');
			}
			$data["array"] = $a;
			
			$this->load->view("dashboard",$data);
		}
	}
	
	public function mgnt_ffai_rvw($id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_ameridial/ffaif/mgnt_rvw.php";
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM signin where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,134) and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
				from qa_amd_ffai_feedback where id='$id') xx Left Join
				(Select office_id,id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid)";
			$data["aspca_data"] = $this->Common_model->get_query_row_array($qSql);
			
			$data["fbid"]=$id;
			
			if($this->input->post('fbid'))
			{
				$fbid=$this->input->post('fbid');
				$curDateTime=CurrMySqlDate();
				$log=get_logs();
				
				$field_array = array(
					"agent_id" => $this->input->post('agent_id'),
					"tl_id" => $this->input->post('tl_id'),
					"call_date" => mmddyy2mysql($this->input->post('call_date')),
					"file_no" => $this->input->post('file_no'),
					"call_duration" => $this->input->post('call_duration'),
					"audit_type" => $this->input->post('audit_type'),
					"auditor_type" => $this->input->post('auditor_type'),
					"voc" => $this->input->post('voc'),
					"possible_score" => $this->input->post('possible_score'),
					"earned_score" => $this->input->post('earned_score'),
					"overall_score" => $this->input->post('overall_score'),
					"open_call_appropriate_branding" => $this->input->post('text1'),
					"close_call_appropriate_branding" => $this->input->post('text2'),
					"before_with_filtersfast" => $this->input->post('text3'),
					"address_using_nato" => $this->input->post('text4'),
					"products_availability" => $this->input->post('text5'),
					"one_call_resolution" => $this->input->post('text6'),
					"agent_accurately_clearly" => $this->input->post('text7'),
					"agent_engaged_customer" => $this->input->post('text8'),
					"membership" => $this->input->post('text9'),
					"offer_donation" => $this->input->post('text10'),
					"explored_before_transferring" => $this->input->post('text11'),
					"call_summary" => $this->input->post('call_summary'),
					"feedback" => $this->input->post('feedback')
				);
				$this->db->where('id', $fbid);
				$this->db->update('qa_amd_ffai_feedback',$field_array);
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
				$this->db->where('id', $fbid);
				$this->db->update('qa_amd_ffai_feedback',$field_array1);	
			///////////
				redirect('Qa_ameridial/ffai');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}
///////////////////////////////////////////////////////////////////////////////////
/*-------------------- FILTER FIRST AGENT IMPROVEMENT (End) ---------------------*/
///////////////////////////////////////////////////////////////////////////////////	

///////////////////////////////////////////////////////////////////////////////////
/*--------------- LIFE QUOTE LIFI QA EVALUATION FORM  (START) -------------------*/
///////////////////////////////////////////////////////////////////////////////////	

public function lifi(){
		if(check_logged_in())
		{
			$current_user = get_user_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_ameridial/lifi/qa_feedback.php";
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,134) and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$from_date = $this->input->get('from_date');
			$to_date = $this->input->get('to_date');
			$agent_id = $this->input->get('agent_id');
			$file = $this->input->get('file');
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
			
			if($from_date !="" && $to_date!=="" )  $cond= " Where (date(audit_date) >= '$from_date' and date(audit_date) <= '$to_date' ) ";
			if($agent_id !="")	$cond .=" and agent_id='$agent_id'";
			if($file !="")	$cond .=" and file_no like '%$file%'";
			
			if(get_user_fusion_id()!='FMIN000011' || get_user_fusion_id()!='FUTA000007' || get_user_fusion_id()!='FUTA000012'){
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
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_name
				from qa_amd_lifi_feedback $cond) xx Left Join
				(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";
			$data["aspca_data"] = $this->Common_model->get_query_result_array($qSql);
			
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			$data["agent_id"] = $agent_id;
			$data["file"] = $file;
			
			$this->load->view("dashboard",$data);
		}
	}
	
	public function add_lifi_feedback(){
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_ameridial/lifi/add_feedback.php";
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,134) and status=1  order by name";
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
					"call_date" => mmddyy2mysql($this->input->post('call_date')),
					"file_no" => $this->input->post('file_no'),
					"call_duration" => $this->input->post('call_duration'),
					"audit_type" => $this->input->post('audit_type'),
					"auditor_type" => $this->input->post('auditor_type'),
					"voc" => $this->input->post('voc'),
					"possible_score" => $this->input->post('possible_score'),
					"earned_score" => $this->input->post('earned_score'),
					"overall_score" => $this->input->post('overall_score'),
					"life_quotes_greeting" => $this->input->post('text1'),
					"agent_positive_response" => $this->input->post('text2'),
					"customer_name_capture" => $this->input->post('text3'),
					"capture_address" => $this->input->post('text4'),
					"phone_number_confirmation" => $this->input->post('text5'),
					"email_Address" => $this->input->post('text6'),
					"customer_dob" => $this->input->post('text7'),
					"script_adherence" => $this->input->post('text8'),
					"coverage_amount_insurance" => $this->input->post('text9'),
					"tobacco_smoking" => $this->input->post('text10'),
					"height_weight_customer" => $this->input->post('text11'),
					"mention_price_comparison" => $this->input->post('text12'),
					"overall_confidence_level" => $this->input->post('text13'),
					"call_closing" => $this->input->post('text14'),
					"call_summary" => $this->input->post('call_summary'),
					"feedback" => $this->input->post('feedback'),
					"entry_date" => $curDateTime,
					"audit_start_time" => $this->input->post('audit_start_time')
				);
				$a = $this->amd_upload_files($_FILES['attach_file'], $path='./qa_files/qa_ameridial/lifi/');
				$field_array["attach_file"] = implode(',',$a);
				$rowid= data_inserter('qa_amd_lifi_feedback',$field_array);
			/////////////	
				if(get_login_type()=="client"){
					$field_array1 = array("client_entryby" => $current_user);
				}else{
					$field_array1 = array("entry_by" => $current_user);
				}
				$this->db->where('id', $rowid);
				$this->db->update('qa_amd_lifi_feedback',$field_array1);
			///////////
				redirect('Qa_ameridial/lifi');
			}
			$data["array"] = $a;
			
			$this->load->view("dashboard",$data);
		}
	}
	
	public function mgnt_lifi_rvw($id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_ameridial/lifi/mgnt_rvw.php";
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM signin where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,134) and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
				from qa_amd_lifi_feedback where id='$id') xx Left Join
				(Select office_id,id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid)";
			$data["lifi_data"] = $this->Common_model->get_query_row_array($qSql);
			
			$data["fbid"]=$id;
			
			if($this->input->post('fbid'))
			{
				$fbid=$this->input->post('fbid');
				$curDateTime=CurrMySqlDate();
				$log=get_logs();
				
				$field_array = array(
					"agent_id" => $this->input->post('agent_id'),
					"tl_id" => $this->input->post('tl_id'),
					"call_date" => mmddyy2mysql($this->input->post('call_date')),
					"file_no" => $this->input->post('file_no'),
					"call_duration" => $this->input->post('call_duration'),
					"audit_type" => $this->input->post('audit_type'),
					"auditor_type" => $this->input->post('auditor_type'),
					"voc" => $this->input->post('voc'),
					"possible_score" => $this->input->post('possible_score'),
					"earned_score" => $this->input->post('earned_score'),
					"overall_score" => $this->input->post('overall_score'),
					"life_quotes_greeting" => $this->input->post('text1'),
					"agent_positive_response" => $this->input->post('text2'),
					"customer_name_capture" => $this->input->post('text3'),
					"capture_address" => $this->input->post('text4'),
					"phone_number_confirmation" => $this->input->post('text5'),
					"email_Address" => $this->input->post('text6'),
					"customer_dob" => $this->input->post('text7'),
					"script_adherence" => $this->input->post('text8'),
					"coverage_amount_insurance" => $this->input->post('text9'),
					"tobacco_smoking" => $this->input->post('text10'),
					"height_weight_customer" => $this->input->post('text11'),
					"mention_price_comparison" => $this->input->post('text12'),
					"overall_confidence_level" => $this->input->post('text13'),
					"call_closing" => $this->input->post('text14'),
					"call_summary" => $this->input->post('call_summary'),
					"feedback" => $this->input->post('feedback')
				);
				$this->db->where('id', $fbid);
				$this->db->update('qa_amd_lifi_feedback',$field_array);
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
				$this->db->where('id', $fbid);
				$this->db->update('qa_amd_lifi_feedback',$field_array1);	
			///////////
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}

///////////////////////////////////////////////////////////////////////////////////
/*--------------- LIFE QUOTE LIFI QA EVALUATION FORM  (END) ---------------------*/
///////////////////////////////////////////////////////////////////////////////////	

///////////////////////////////////////////////////////////////////////////////////
/*-------------------------- Stauer Sales (Start) ---------------------------*/
///////////////////////////////////////////////////////////////////////////////////	

	public function stauers_sales(){
		if(check_logged_in())
		{
			$current_user = get_user_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_ameridial/stauers_sales/qa_feedback.php";
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,134) and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$from_date = $this->input->get('from_date');
			$to_date = $this->input->get('to_date');
			$agent_id = $this->input->get('agent_id');
			$file = $this->input->get('file');
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
			
			if($from_date !="" && $to_date!=="" )  $cond= " Where (date(audit_date) >= '$from_date' and date(audit_date) <= '$to_date' ) ";
			if($agent_id !="")	$cond .=" and agent_id='$agent_id'";
			if($file !="")	$cond .=" and file_no like '%$file%'";
			
			if(get_user_fusion_id()!='FMIN000011' || get_user_fusion_id()!='FUTA000007' || get_user_fusion_id()!='FUTA000012'){
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
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_name
				from qa_amd_stauers_sales_feedback $cond) xx Left Join
				(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";
			$data["aspca_data"] = $this->Common_model->get_query_result_array($qSql);
			
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			$data["agent_id"] = $agent_id;
			$data["file"] = $file;
			
			$this->load->view("dashboard",$data);
		}
	}

	
	public function add_stauers_sales_feedback(){
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_ameridial/stauers_sales/add_feedback.php";
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,134) and status=1  order by name";
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
					"call_date" => mmddyy2mysql($this->input->post('call_date')),
					"file_no" => $this->input->post('file_no'),
					"call_duration" => $this->input->post('call_duration'),
					"audit_type" => $this->input->post('audit_type'),
					"auditor_type" => $this->input->post('auditor_type'),
					"voc" => $this->input->post('voc'),
					"possible_score" => $this->input->post('possible_score'),
					"earned_score" => $this->input->post('earned_score'),
					"overall_score" => $this->input->post('overall_score'),
					"call_answered_5_seconds" => $this->input->post('text1'),
					"agent_verify_customer_name_address" => $this->input->post('text2'),
					"agent_capture_correct_offer" => $this->input->post('text3'),
					"agent_verify_phone_number" => $this->input->post('text4'),
					"agent_verify_customer_email" => $this->input->post('text5'),
					"agent_compliment_caller_purchase" => $this->input->post('text6'),
					"agent_recap_item" => $this->input->post('text7'),
					"agent_cover_one_upsell" => $this->input->post('text8'),
					"agent_cover_replacement" => $this->input->post('text9'),
					"agent_appropriate_rebuttal" => $this->input->post('text10'),
					"agent_cover_membership" => $this->input->post('text11'),
					"agent_appropriate_rebuttal_declined" => $this->input->post('text12'),
					"agent_offer_membership" => $this->input->post('text13'),
					"agent_cover_autorenew" => $this->input->post('text14'),
					"shipping_address_verified" => $this->input->post('text15'),
					"quote_correct_delivery_time" => $this->input->post('text16'),
					"agent_total_product_appropriately" => $this->input->post('text17'),
					"agent_quote_shipping_taxes" => $this->input->post('text18'),
					"agent_give_total_charged" => $this->input->post('text19'),
					"agent_provide_order_number" => $this->input->post('text20'),
					"agent_close_call_brand_correctly" => $this->input->post('text21'),
					"customer_satisfied_experience" => $this->input->post('text22'),
					"customer_dissatisfied_professionalism" => $this->input->post('text23'),
					"call_summary" => $this->input->post('call_summary'),
					"feedback" => $this->input->post('feedback'),
					"entry_date" => $curDateTime,
					"audit_start_time" => $this->input->post('audit_start_time')
				);
				$a = $this->amd_upload_files($_FILES['attach_file'], $path='./qa_files/qa_ameridial/stauers_sales/');
				$field_array["attach_file"] = implode(',',$a);
				$rowid= data_inserter('qa_amd_stauers_sales_feedback',$field_array); 
			/////////////	
				if(get_login_type()=="client"){
					$field_array1 = array("client_entryby" => $current_user);
				}else{
					$field_array1 = array("entry_by" => $current_user);
				}
				$this->db->where('id', $rowid);
				$this->db->update('qa_amd_stauers_sales_feedback',$field_array1);
			///////////	
				redirect('Qa_ameridial/stauers_sales');
			}
			$data["array"] = $a;
			
			$this->load->view("dashboard",$data);
		}
	}
	
	public function mgnt_stauers_sales_rvw($id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_ameridial/stauers_sales/mgnt_rvw.php";
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM signin where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,134) and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
				from qa_amd_stauers_sales_feedback where id='$id') xx Left Join
				(Select office_id,id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid)";
			$data["aspca_data"] = $this->Common_model->get_query_row_array($qSql);
			
			$data["fbid"]=$id;
			
			if($this->input->post('fbid'))
			{
				$fbid=$this->input->post('fbid');
				$curDateTime=CurrMySqlDate();
				$log=get_logs();
				
				$field_array = array(
					"agent_id" => $this->input->post('agent_id'),
					"tl_id" => $this->input->post('tl_id'),
					"call_date" => mmddyy2mysql($this->input->post('call_date')),
					"file_no" => $this->input->post('file_no'),
					"call_duration" => $this->input->post('call_duration'),
					"audit_type" => $this->input->post('audit_type'),
					"auditor_type" => $this->input->post('auditor_type'),
					"voc" => $this->input->post('voc'),
					"possible_score" => $this->input->post('possible_score'),
					"earned_score" => $this->input->post('earned_score'),
					"overall_score" => $this->input->post('overall_score'),
					"call_answered_5_seconds" => $this->input->post('text1'),
					"agent_verify_customer_name_address" => $this->input->post('text2'),
					"agent_capture_correct_offer" => $this->input->post('text3'),
					"agent_verify_phone_number" => $this->input->post('text4'),
					"agent_verify_customer_email" => $this->input->post('text5'),
					"agent_compliment_caller_purchase" => $this->input->post('text6'),
					"agent_recap_item" => $this->input->post('text7'),
					"agent_cover_one_upsell" => $this->input->post('text8'),
					"agent_cover_replacement" => $this->input->post('text9'),
					"agent_appropriate_rebuttal" => $this->input->post('text10'),
					"agent_cover_membership" => $this->input->post('text11'),
					"agent_appropriate_rebuttal_declined" => $this->input->post('text12'),
					"agent_offer_membership" => $this->input->post('text13'),
					"agent_cover_autorenew" => $this->input->post('text14'),
					"shipping_address_verified" => $this->input->post('text15'),
					"quote_correct_delivery_time" => $this->input->post('text16'),
					"agent_total_product_appropriately" => $this->input->post('text17'),
					"agent_quote_shipping_taxes" => $this->input->post('text18'),
					"agent_give_total_charged" => $this->input->post('text19'),
					"agent_provide_order_number" => $this->input->post('text20'),
					"agent_close_call_brand_correctly" => $this->input->post('text21'),
					"customer_satisfied_experience" => $this->input->post('text22'),
					"customer_dissatisfied_professionalism" => $this->input->post('text23'),
					"call_summary" => $this->input->post('call_summary'),
					"feedback" => $this->input->post('feedback')
				);
				$this->db->where('id', $fbid);
				$this->db->update('qa_amd_stauers_sales_feedback',$field_array);
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
				$this->db->where('id', $fbid);
				$this->db->update('qa_amd_stauers_sales_feedback',$field_array1);	
			///////////
				redirect('Qa_ameridial/stauers_sales');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}
///////////////////////////////////////////////////////////////////////////////////
/*-------------------------- stauers_sales (End) ---------------------------*/
///////////////////////////////////////////////////////////////////////////////////	

///////////////////////////////////////////////////////////////////////////////////
/*-------------------------- Operation Smile (Start) ---------------------------*/
///////////////////////////////////////////////////////////////////////////////////	

	public function operation_smile(){
		if(check_logged_in())
		{
			$current_user = get_user_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_ameridial/operation_smile/operation_smile_feedback.php";
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,134) and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$from_date = $this->input->get('from_date');
			$to_date = $this->input->get('to_date');
			$agent_id = $this->input->get('agent_id');
			$file = $this->input->get('file');
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
			
			if($from_date !="" && $to_date!=="" )  $cond= " Where (date(audit_date) >= '$from_date' and date(audit_date) <= '$to_date' ) ";
			if($agent_id !="")	$cond .=" and agent_id='$agent_id'";
			if($file !="")	$cond .=" and file_no like '%$file%'";
			
			if(get_user_fusion_id()!='FMIN000011' || get_user_fusion_id()!='FUTA000007' || get_user_fusion_id()!='FUTA000012'){
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
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
				from qa_amd_operation_smile_feedback $cond) xx Left Join
				(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to, office_id from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";
			$data["operation_smile"] = $this->Common_model->get_query_result_array($qSql);
			
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			$data["agent_id"] = $agent_id;
			$data["file"] = $file;
			
			$this->load->view("dashboard",$data);
		}
	}

	
	public function add_operation_smile(){
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_ameridial/operation_smile/add_operation_smile.php";
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,134) and status=1  order by name";
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
					"call_date" => mmddyy2mysql($this->input->post('call_date')),
					"file_no" => $this->input->post('file_no'),
					"call_duration" => $this->input->post('call_duration'),
					"audit_type" => $this->input->post('audit_type'),
					"auditor_type" => $this->input->post('auditor_type'),
					"voc" => $this->input->post('voc'),
					"possible_score" => $this->input->post('possible_score'),
					"earned_score" => $this->input->post('earned_score'),
					"overall_score" => $this->input->post('overall_score'),
					"agentreadytohandle" => $this->input->post('agentreadytohandle'),
					"agentgreetthecaller" => $this->input->post('agentgreetthecaller'),
					"agentconfirminfo" => $this->input->post('agentconfirminfo'),
					"agentshowgraduate" => $this->input->post('agentshowgraduate'),
					"agentuserebuttals" => $this->input->post('agentuserebuttals'),
					"agentofferupsell" => $this->input->post('agentofferupsell'),
					"agentfollowscript" => $this->input->post('agentfollowscript'),
					"agentaddressquestion" => $this->input->post('agentaddressquestion'),
					"agentspeakenergy" => $this->input->post('agentspeakenergy'),
					"agentuseproperpacing" => $this->input->post('agentuseproperpacing'),
					"agentmaintaincontrol" => $this->input->post('agentmaintaincontrol'),
					"agentprofessionalspeak" => $this->input->post('agentprofessionalspeak'),
					"agentgoodlistening" => $this->input->post('agentgoodlistening'),
					"agentempathize" => $this->input->post('agentempathize'),
					"agentprovidedonor" => $this->input->post('agentprovidedonor'),
					"agnetaskprompted" => $this->input->post('agnetaskprompted'),
					"agentthankcaller" => $this->input->post('agentthankcaller'),
					"agentgaveinformation" => $this->input->post('agentgaveinformation'),
					"agenthangup" => $this->input->post('agenthangup'),
					"agentlaguage" => $this->input->post('agentlaguage'),
					"call_summary" => $this->input->post('call_summary'),
					"feedback" => $this->input->post('feedback'),
					"entry_date" => $curDateTime,
					"audit_start_time" => $this->input->post('audit_start_time')
				);
				$a = $this->amd_upload_files($_FILES['attach_file'], $path='./qa_files/qa_ameridial/operation_smile/');
				$field_array["attach_file"] = implode(',',$a);
				$rowid= data_inserter('qa_amd_operation_smile_feedback',$field_array); 
			/////////////	
				if(get_login_type()=="client"){
					$field_array1 = array("client_entryby" => $current_user);
				}else{
					$field_array1 = array("entry_by" => $current_user);
				}
				$this->db->where('id', $rowid);
				$this->db->update('qa_amd_operation_smile_feedback',$field_array1);
			///////////	
				redirect('Qa_ameridial/operation_smile');
			}
			$data["array"] = $a;
			
			$this->load->view("dashboard",$data);
		}
	}
	
	public function mgnt_operation_smile_rvw($id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_ameridial/operation_smile/mgnt_operation_smile_rvw.php";
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM signin where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,134) and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
				from qa_amd_operation_smile_feedback where id='$id') xx Left Join
				(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to, office_id from signin) yy on (xx.agent_id=yy.sid)";
			$data["operation_smile"] = $this->Common_model->get_query_row_array($qSql);
			
			$data["osid"]=$id;
			
		///////Edit Part///////	
			if($this->input->post('osid'))
			{
				$osid=$this->input->post('osid');
				$curDateTime=CurrMySqlDate();
				$log=get_logs();
				
				$field_array = array(
					"agent_id" => $this->input->post('agent_id'),
					"tl_id" => $this->input->post('tl_id'),
					"call_date" => mmddyy2mysql($this->input->post('call_date')),
					"file_no" => $this->input->post('file_no'),
					"call_duration" => $this->input->post('call_duration'),
					"audit_type" => $this->input->post('audit_type'),
					"auditor_type" => $this->input->post('auditor_type'),
					"voc" => $this->input->post('voc'),
					"possible_score" => $this->input->post('possible_score'),
					"earned_score" => $this->input->post('earned_score'),
					"overall_score" => $this->input->post('overall_score'),
					"agentreadytohandle" => $this->input->post('agentreadytohandle'),
					"agentgreetthecaller" => $this->input->post('agentgreetthecaller'),
					"agentconfirminfo" => $this->input->post('agentconfirminfo'),
					"agentshowgraduate" => $this->input->post('agentshowgraduate'),
					"agentuserebuttals" => $this->input->post('agentuserebuttals'),
					"agentofferupsell" => $this->input->post('agentofferupsell'),
					"agentfollowscript" => $this->input->post('agentfollowscript'),
					"agentaddressquestion" => $this->input->post('agentaddressquestion'),
					"agentspeakenergy" => $this->input->post('agentspeakenergy'),
					"agentuseproperpacing" => $this->input->post('agentuseproperpacing'),
					"agentmaintaincontrol" => $this->input->post('agentmaintaincontrol'),
					"agentprofessionalspeak" => $this->input->post('agentprofessionalspeak'),
					"agentgoodlistening" => $this->input->post('agentgoodlistening'),
					"agentempathize" => $this->input->post('agentempathize'),
					"agentprovidedonor" => $this->input->post('agentprovidedonor'),
					"agnetaskprompted" => $this->input->post('agnetaskprompted'),
					"agentthankcaller" => $this->input->post('agentthankcaller'),
					"agentgaveinformation" => $this->input->post('agentgaveinformation'),
					"agenthangup" => $this->input->post('agenthangup'),
					"agentlaguage" => $this->input->post('agentlaguage'),
					"call_summary" => $this->input->post('call_summary'),
					"feedback" => $this->input->post('feedback'),
					"mgnt_rvw_note" => $this->input->post('note'),
					"mgnt_rvw_by" => $current_user,
					"mgnt_rvw_date" => $curDateTime
				);
				$this->db->where('id', $osid);
				$this->db->update('qa_amd_operation_smile_feedback',$field_array);
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
				$this->db->where('id', $osid);
				$this->db->update('qa_amd_operation_smile_feedback',$field_array1);	
			///////////
				redirect('Qa_ameridial/operation_smile');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}
///////////////////////////////////////////////////////////////////////////////////
/*-------------------------- Operation Smile (End) ----------------------------*/
///////////////////////////////////////////////////////////////////////////////////

///////////////////////////////////////////////////////////////////////////////////
/*---------------------------- Tactical 5-11 (Start) ---------------------------*/
///////////////////////////////////////////////////////////////////////////////////	

	public function tactical_5_11(){
		if(check_logged_in())
		{
			$current_user = get_user_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_ameridial/tactical_5_11/tactical_5_11_feedback.php";
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,134) and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$from_date = $this->input->get('from_date');
			$to_date = $this->input->get('to_date');
			$agent_id = $this->input->get('agent_id');
			$file = $this->input->get('file');
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
			
			if($from_date !="" && $to_date!=="" )  $cond= " Where (date(audit_date) >= '$from_date' and date(audit_date) <= '$to_date' ) ";
			if($agent_id !="")	$cond .=" and agent_id='$agent_id'";
			if($file !="")	$cond .=" and file_no like '%$file%'";
			
			if(get_user_fusion_id()!='FMIN000011' || get_user_fusion_id()!='FUTA000007' || get_user_fusion_id()!='FUTA000012'){
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
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
				from qa_amd_5_11_tactical_feedback $cond) xx Left Join
				(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to, office_id from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";
			$data["tactical"] = $this->Common_model->get_query_result_array($qSql);
			
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			$data["agent_id"] = $agent_id;
			$data["file"] = $file;
			
			$this->load->view("dashboard",$data);
		}
	}

	
	public function add_tactical_5_11(){
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_ameridial/tactical_5_11/add_tactical_5_11.php";
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,134) and status=1  order by name";
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
					"call_date" => mmddyy2mysql($this->input->post('call_date')),
					"file_no" => $this->input->post('file_no'),
					"call_duration" => $this->input->post('call_duration'),
					"audit_type" => $this->input->post('audit_type'),
					"auditor_type" => $this->input->post('auditor_type'),
					"voc" => $this->input->post('voc'),
					"possible_score" => $this->input->post('possible_score'),
					"earned_score" => $this->input->post('earned_score'),
					"overall_score" => $this->input->post('overall_score'),
					"greetthecustomer" => $this->input->post('greetthecustomer'),
					"customeritemtoorder" => $this->input->post('customeritemtoorder'),
					"wouldaddyourorder" => $this->input->post('wouldaddyourorder'),
					"customerlogininformation" => $this->input->post('customerlogininformation'),
					"callerinformationaccuracy" => $this->input->post('callerinformationaccuracy'),
					"coverfinalconfirmation" => $this->input->post('coverfinalconfirmation'),
					"givecustomerordernumber" => $this->input->post('givecustomerordernumber'),
					"userapplicablesearch" => $this->input->post('userapplicablesearch'),
					"coverreturnprocess" => $this->input->post('coverreturnprocess'),
					"coverexchangeprocess" => $this->input->post('coverexchangeprocess'),
					"coverrefundprocess" => $this->input->post('coverrefundprocess'),
					"trackthepackage" => $this->input->post('trackthepackage'),
					"agentaskforassist" => $this->input->post('agentaskforassist'),
					"agentbrandthecall" => $this->input->post('agentbrandthecall'),
					"answerquestions" => $this->input->post('answerquestions'),
					"maintaincallcontrol" => $this->input->post('maintaincallcontrol'),
					"properlynotateAX" => $this->input->post('properlynotateAX'),
					"escalationwaranted" => $this->input->post('escalationwaranted'),
					"agentdispositioncall" => $this->input->post('agentdispositioncall'),
					"maintainprofessionalism" => $this->input->post('maintainprofessionalism'),
					"call_summary" => $this->input->post('call_summary'),
					"feedback" => $this->input->post('feedback'),
					"entry_by" => $current_user,
					"entry_date" => $curDateTime,
					"audit_start_time" => $this->input->post('audit_start_time')
				);
				$a = $this->amd_upload_files($_FILES['attach_file'], $path='./qa_files/qa_ameridial/tactical_5_11/');
				$field_array["attach_file"] = implode(',',$a);
				$rowid= data_inserter('qa_amd_5_11_tactical_feedback',$field_array); 
			/////////////	
				if(get_login_type()=="client"){
					$field_array1 = array("client_entryby" => $current_user);
				}else{
					$field_array1 = array("entry_by" => $current_user);
				}
				$this->db->where('id', $rowid);
				$this->db->update('qa_amd_5_11_tactical_feedback',$field_array1);
			///////////	
				redirect('Qa_ameridial/tactical_5_11');
			}
			$data["array"] = $a;
			$this->load->view("dashboard",$data);
		}
	}
	
	public function mgnt_tactical_5_11_rvw($id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_ameridial/tactical_5_11/mgnt_tactical_5_11_rvw.php";
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM signin where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,134) and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
				from qa_amd_5_11_tactical_feedback where id='$id') xx Left Join
				(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to, office_id from signin) yy on (xx.agent_id=yy.sid)";
			$data["tectical"] = $this->Common_model->get_query_row_array($qSql);
			
			$data["tecid"]=$id;
				
			if($this->input->post('tecid'))
			{
				$tecid=$this->input->post('tecid');
				$curDateTime=CurrMySqlDate();
				$log=get_logs();
				
				$field_array = array(
					"agent_id" => $this->input->post('agent_id'),
					"tl_id" => $this->input->post('tl_id'),
					"call_date" => mmddyy2mysql($this->input->post('call_date')),
					"file_no" => $this->input->post('file_no'),
					"call_duration" => $this->input->post('call_duration'),
					"audit_type" => $this->input->post('audit_type'),
					"auditor_type" => $this->input->post('auditor_type'),
					"voc" => $this->input->post('voc'),
					"possible_score" => $this->input->post('possible_score'),
					"earned_score" => $this->input->post('earned_score'),
					"overall_score" => $this->input->post('overall_score'),
					"greetthecustomer" => $this->input->post('greetthecustomer'),
					"customeritemtoorder" => $this->input->post('customeritemtoorder'),
					"wouldaddyourorder" => $this->input->post('wouldaddyourorder'),
					"customerlogininformation" => $this->input->post('customerlogininformation'),
					"callerinformationaccuracy" => $this->input->post('callerinformationaccuracy'),
					"coverfinalconfirmation" => $this->input->post('coverfinalconfirmation'),
					"givecustomerordernumber" => $this->input->post('givecustomerordernumber'),
					"userapplicablesearch" => $this->input->post('userapplicablesearch'),
					"coverreturnprocess" => $this->input->post('coverreturnprocess'),
					"coverexchangeprocess" => $this->input->post('coverexchangeprocess'),
					"coverrefundprocess" => $this->input->post('coverrefundprocess'),
					"trackthepackage" => $this->input->post('trackthepackage'),
					"agentaskforassist" => $this->input->post('agentaskforassist'),
					"agentbrandthecall" => $this->input->post('agentbrandthecall'),
					"answerquestions" => $this->input->post('answerquestions'),
					"maintaincallcontrol" => $this->input->post('maintaincallcontrol'),
					"properlynotateAX" => $this->input->post('properlynotateAX'),
					"escalationwaranted" => $this->input->post('escalationwaranted'),
					"agentdispositioncall" => $this->input->post('agentdispositioncall'),
					"maintainprofessionalism" => $this->input->post('maintainprofessionalism'),
					"call_summary" => $this->input->post('call_summary'),
					"feedback" => $this->input->post('feedback')
				);
				$this->db->where('id', $tecid);
				$this->db->update('qa_amd_5_11_tactical_feedback',$field_array);
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
				$this->db->where('id', $tecid);
				$this->db->update('qa_amd_5_11_tactical_feedback',$field_array1);	
			///////////
				redirect('Qa_ameridial/tactical_5_11');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}
///////////////////////////////////////////////////////////////////////////////////
/*---------------------------- 5-11 Tactical (End) -----------------------------*/
///////////////////////////////////////////////////////////////////////////////////	


///////////////////////////////////////////////////////////////////////////////////
/*----------------------------- Non-Profit (Start) ---------------------------*/
///////////////////////////////////////////////////////////////////////////////////	

	public function non_profit(){
		if(check_logged_in())
		{
			$current_user = get_user_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_ameridial/non_profit/non_profit_feedback.php";
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,134) and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$from_date = $this->input->get('from_date');
			$to_date = $this->input->get('to_date');
			$agent_id = $this->input->get('agent_id');
			$file = $this->input->get('file');
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
			
			if($from_date !="" && $to_date!=="" )  $cond= " Where (date(audit_date) >= '$from_date' and date(audit_date) <= '$to_date' ) ";
			if($agent_id !="")	$cond .=" and agent_id='$agent_id'";
			if($file !="")	$cond .=" and file_no like '%$file%'";
			
			if(get_user_fusion_id()!='FMIN000011' || get_user_fusion_id()!='FUTA000007' || get_user_fusion_id()!='FUTA000012'){
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
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
				from qa_amd_non_profit_feedback $cond) xx Left Join
				(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to, office_id from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";
			$data["nonProfit"] = $this->Common_model->get_query_result_array($qSql);
			
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			$data["agent_id"] = $agent_id;
			$data["file"] = $file;
			
			$this->load->view("dashboard",$data);
		}
	}

	
	public function add_non_profit(){
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_ameridial/non_profit/add_non_profit.php";
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,134) and status=1  order by name";
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
					"call_date" => mmddyy2mysql($this->input->post('call_date')),
					"file_no" => $this->input->post('file_no'),
					"call_duration" => $this->input->post('call_duration'),
					"audit_type" => $this->input->post('audit_type'),
					"auditor_type" => $this->input->post('auditor_type'),
					"voc" => $this->input->post('voc'),
					"possible_score" => $this->input->post('possible_score'),
					"earned_score" => $this->input->post('earned_score'),
					"overall_score" => $this->input->post('overall_score'),
					"preparedtakecall" => $this->input->post('preparedtakecall'),
					"paidcallerfromdonor" => $this->input->post('paidcallerfromdonor'),
					"communicatorstarted" => $this->input->post('communicatorstarted'),
					"pronouncedclients" => $this->input->post('pronouncedclients'),
					"gavewarmgreeting" => $this->input->post('gavewarmgreeting'),
					"followedscript1stReq" => $this->input->post('followedscript1stReq'),
					"usedcorrectdollar" => $this->input->post('usedcorrectdollar'),
					"assumptivegiftask" => $this->input->post('assumptivegiftask'),
					"shownempathy" => $this->input->post('shownempathy'),
					"repeatedobjection" => $this->input->post('repeatedobjection'),
					"personalizedobjection" => $this->input->post('personalizedobjection'),
					"attemptedhandleobjection" => $this->input->post('attemptedhandleobjection'),
					"reinforcethenegative" => $this->input->post('reinforcethenegative'),
					"deadendcall" => $this->input->post('deadendcall'),
					"followed2ndReq" => $this->input->post('followed2ndReq'),
					"usedoller2ndReq" => $this->input->post('usedoller2ndReq'),
					"assumptive2ndReq" => $this->input->post('assumptive2ndReq'),
					"attempted3rdReq" => $this->input->post('attempted3rdReq'),
					"usedoller3rdReq" => $this->input->post('usedoller3rdReq'),
					"assumptive3rdReq" => $this->input->post('assumptive3rdReq'),
					"confirmationgiftamount" => $this->input->post('confirmationgiftamount'),
					"assumedhigherdoller" => $this->input->post('assumedhigherdoller'),
					"meaningfulgratitude" => $this->input->post('meaningfulgratitude'),
					"readcreditcard" => $this->input->post('readcreditcard'),
					"confirmedfullname" => $this->input->post('confirmedfullname'),
					"followedmaybeclose" => $this->input->post('followedmaybeclose'),
					"readclosescript" => $this->input->post('readclosescript'),
					"endedcalltime" => $this->input->post('endedcalltime'),
					"soundedconversational" => $this->input->post('soundedconversational'),
					"useappropiatepace" => $this->input->post('useappropiatepace'),
					"confidentpresentation" => $this->input->post('confidentpresentation'),
					"didnotlosecontrol" => $this->input->post('didnotlosecontrol'),
					"properpersonalization" => $this->input->post('properpersonalization'),
					"utilizedpropergrammer" => $this->input->post('utilizedpropergrammer'),
					"bailing" => $this->input->post('bailing'),
					"askforcreditcard" => $this->input->post('askforcreditcard'),
					"gavefalseinformation" => $this->input->post('gavefalseinformation'),
					"donorcarecenter" => $this->input->post('donorcarecenter'),
					"askconfirmationquestion" => $this->input->post('askconfirmationquestion'),
					"unsolidgift" => $this->input->post('unsolidgift'),
					"codingrefusal" => $this->input->post('codingrefusal'),
					"unprofessionalbehaviour" => $this->input->post('unprofessionalbehaviour'),
					"improperpresentation" => $this->input->post('improperpresentation'),
					"omittedDNCcode" => $this->input->post('omittedDNCcode'),
					"falsificationgift" => $this->input->post('falsificationgift'),
					"call_summary" => $this->input->post('call_summary'),
					"feedback" => $this->input->post('feedback'),
					"entry_by" => $current_user,
					"entry_date" => $curDateTime,
					"audit_start_time" => $this->input->post('audit_start_time')
				);
				$a = $this->amd_upload_files($_FILES['attach_file'], $path='./qa_files/qa_ameridial/non_profit/');
				$field_array["attach_file"] = implode(',',$a);
				$rowid= data_inserter('qa_amd_non_profit_feedback',$field_array); 
			/////////////	
				if(get_login_type()=="client"){
					$field_array1 = array("client_entryby" => $current_user);
				}else{
					$field_array1 = array("entry_by" => $current_user);
				}
				$this->db->where('id', $rowid);
				$this->db->update('qa_amd_non_profit_feedback',$field_array1);
			///////////	
				redirect('Qa_ameridial/non_profit');
			}
			$data["array"] = $a;
			
			$this->load->view("dashboard",$data);
		}
	}
	
	public function mgnt_non_profit_rvw($id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_ameridial/non_profit/mgnt_non_profit_rvw.php";
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM signin where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,134) and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
				from qa_amd_non_profit_feedback where id='$id') xx Left Join
				(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to, office_id from signin) yy on (xx.agent_id=yy.sid)";
			$data["nonProfit"] = $this->Common_model->get_query_row_array($qSql);
			
			$data["tecid"]=$id;
				
			if($this->input->post('tecid'))
			{
				$tecid=$this->input->post('tecid');
				$curDateTime=CurrMySqlDate();
				$log=get_logs();
				
				$field_array = array(
					"agent_id" => $this->input->post('agent_id'),
					"tl_id" => $this->input->post('tl_id'),
					"call_date" => mmddyy2mysql($this->input->post('call_date')),
					"file_no" => $this->input->post('file_no'),
					"call_duration" => $this->input->post('call_duration'),
					"audit_type" => $this->input->post('audit_type'),
					"auditor_type" => $this->input->post('auditor_type'),
					"voc" => $this->input->post('voc'),
					"possible_score" => $this->input->post('possible_score'),
					"earned_score" => $this->input->post('earned_score'),
					"overall_score" => $this->input->post('overall_score'),
					"preparedtakecall" => $this->input->post('preparedtakecall'),
					"paidcallerfromdonor" => $this->input->post('paidcallerfromdonor'),
					"communicatorstarted" => $this->input->post('communicatorstarted'),
					"pronouncedclients" => $this->input->post('pronouncedclients'),
					"gavewarmgreeting" => $this->input->post('gavewarmgreeting'),
					"followedscript1stReq" => $this->input->post('followedscript1stReq'),
					"usedcorrectdollar" => $this->input->post('usedcorrectdollar'),
					"assumptivegiftask" => $this->input->post('assumptivegiftask'),
					"shownempathy" => $this->input->post('shownempathy'),
					"repeatedobjection" => $this->input->post('repeatedobjection'),
					"personalizedobjection" => $this->input->post('personalizedobjection'),
					"attemptedhandleobjection" => $this->input->post('attemptedhandleobjection'),
					"reinforcethenegative" => $this->input->post('reinforcethenegative'),
					"deadendcall" => $this->input->post('deadendcall'),
					"followed2ndReq" => $this->input->post('followed2ndReq'),
					"usedoller2ndReq" => $this->input->post('usedoller2ndReq'),
					"assumptive2ndReq" => $this->input->post('assumptive2ndReq'),
					"attempted3rdReq" => $this->input->post('attempted3rdReq'),
					"usedoller3rdReq" => $this->input->post('usedoller3rdReq'),
					"assumptive3rdReq" => $this->input->post('assumptive3rdReq'),
					"confirmationgiftamount" => $this->input->post('confirmationgiftamount'),
					"assumedhigherdoller" => $this->input->post('assumedhigherdoller'),
					"meaningfulgratitude" => $this->input->post('meaningfulgratitude'),
					"readcreditcard" => $this->input->post('readcreditcard'),
					"confirmedfullname" => $this->input->post('confirmedfullname'),
					"followedmaybeclose" => $this->input->post('followedmaybeclose'),
					"readclosescript" => $this->input->post('readclosescript'),
					"endedcalltime" => $this->input->post('endedcalltime'),
					"soundedconversational" => $this->input->post('soundedconversational'),
					"useappropiatepace" => $this->input->post('useappropiatepace'),
					"confidentpresentation" => $this->input->post('confidentpresentation'),
					"didnotlosecontrol" => $this->input->post('didnotlosecontrol'),
					"properpersonalization" => $this->input->post('properpersonalization'),
					"utilizedpropergrammer" => $this->input->post('utilizedpropergrammer'),
					"bailing" => $this->input->post('bailing'),
					"askforcreditcard" => $this->input->post('askforcreditcard'),
					"gavefalseinformation" => $this->input->post('gavefalseinformation'),
					"donorcarecenter" => $this->input->post('donorcarecenter'),
					"askconfirmationquestion" => $this->input->post('askconfirmationquestion'),
					"unsolidgift" => $this->input->post('unsolidgift'),
					"codingrefusal" => $this->input->post('codingrefusal'),
					"unprofessionalbehaviour" => $this->input->post('unprofessionalbehaviour'),
					"improperpresentation" => $this->input->post('improperpresentation'),
					"omittedDNCcode" => $this->input->post('omittedDNCcode'),
					"falsificationgift" => $this->input->post('falsificationgift'),
					"call_summary" => $this->input->post('call_summary'),
					"feedback" => $this->input->post('feedback'),
					"mgnt_rvw_note" => $this->input->post('note'),
					"mgnt_rvw_by" => $current_user,
					"mgnt_rvw_date" => $curDateTime
				);
				$this->db->where('id', $tecid);
				$this->db->update('qa_amd_non_profit_feedback',$field_array);
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
				$this->db->where('id', $tecid);
				$this->db->update('qa_amd_non_profit_feedback',$field_array1);	
			///////////
				redirect('Qa_ameridial/non_profit');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}
///////////////////////////////////////////////////////////////////////////////////
/*---------------------------- Non-Profit (End) -----------------------------*/
///////////////////////////////////////////////////////////////////////////////////

///////////////////////////////////////////////////////////////////////////////////
/*------------------------------ JMMI (Start) ------------------------------*/
///////////////////////////////////////////////////////////////////////////////////	

	public function jmmi(){
		if(check_logged_in())
		{
			$current_user = get_user_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_ameridial/jmmi/qa_feedback.php";
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,134) and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$from_date = $this->input->get('from_date');
			$to_date = $this->input->get('to_date');
			$agent_id = $this->input->get('agent_id');
			$file = $this->input->get('file');
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
			
			if($from_date !="" && $to_date!=="" )  $cond= " Where (date(audit_date) >= '$from_date' and date(audit_date) <= '$to_date' ) ";
			if($agent_id !="")	$cond .=" and agent_id='$agent_id'";
			if($file !="")	$cond .=" and file_no like '%$file%'";
			
			if(get_user_fusion_id()!='FMIN000011' || get_user_fusion_id()!='FUTA000007' || get_user_fusion_id()!='FUTA000012'){
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
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_name
				from qa_amd_jmmi_feedback $cond) xx Left Join
				(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";
			$data["aspca_data"] = $this->Common_model->get_query_result_array($qSql);
			
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			$data["agent_id"] = $agent_id;
			$data["file"] = $file;
			
			$this->load->view("dashboard",$data);
		}
	}

	
	public function add_jmmi_feedback(){
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_ameridial/jmmi/add_feedback.php";
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,134) and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
			$curDateTime=CurrMySqlDate();
			$a = array();
			
			if($this->input->post('agent_id')){
				/* if($this->input->post('text24')=='Yes') $text24 = 'No';
				else if ($this->input->post('text24')=='No') $text24 = 'Yes';
				else $text24 = 'N/A'; */
				
				$field_array=array(
					"audit_date" => CurrDate(),
					"agent_id" => $this->input->post('agent_id'),
					"tl_id" => $this->input->post('tl_id'),
					"call_date" => mmddyy2mysql($this->input->post('call_date')),
					"file_no" => $this->input->post('file_no'),
					"call_duration" => $this->input->post('call_duration'),
					"audit_type" => $this->input->post('audit_type'),
					"auditor_type" => $this->input->post('auditor_type'),
					"voc" => $this->input->post('voc'),
					"possible_score" => $this->input->post('possible_score'),
					"earned_score" => $this->input->post('earned_score'),
					"overall_score" => $this->input->post('overall_score'),
					"agent_appropriate_greeting" => $this->input->post('text1'),
					"agent_excellent_conversational_responses" => $this->input->post('text2'),
					"agent_verify_opening_information" => $this->input->post('text3'),
					"agent_follow_call_flow" => $this->input->post('text4'),
					"agent_appropriate_gratitude" => $this->input->post('text5'),
					"agent_share_upsells" => $this->input->post('text6'),
					"agent_show_familiarity_search" => $this->input->post('text7'),
					"agent_thank_caller_specifically" => $this->input->post('text8'),
					"agent_share_facts_appropriate" => $this->input->post('text9'),
					"agent_professional_communication" => $this->input->post('text10'),
					"agent_proper_enthusiasm" => $this->input->post('text11'),
					"agent_maintain_control_conversation" => $this->input->post('text12'),
					"agent_spoke_clearly" => $this->input->post('text13'),
					"agent_good_listening_skills_responses" => $this->input->post('text14'),
					"agent_empathize_caller_and_compassion" => $this->input->post('text15'),
					"agent_have_minimal_dead_air" => $this->input->post('text16'),
					"agent_have_caller_provide_address" => $this->input->post('text17'),
					"agent_confirm_dollar_amount" => $this->input->post('text18'),
					"agent_read_shipping_information" => $this->input->post('text19'),
					"agent_ask_caller_email_tv_information" => $this->input->post('text20'),
					"agent_proper_thanks" => $this->input->post('text21'),
					"agent_transfer_call_prayer_appropriate" => $this->input->post('text22'),
					"agent_follow_payment" => $this->input->post('text23'),
					"agent_read_back_customer_details_properly" => $this->input->post('text24'),
					"call_summary" => $this->input->post('call_summary'),
					"feedback" => $this->input->post('feedback'),
					"entry_date" => $curDateTime,
					"audit_start_time" => $this->input->post('audit_start_time')
				);
				$a = $this->amd_upload_files($_FILES['attach_file'], $path='./qa_files/qa_ameridial/jmmi/');
				$field_array["attach_file"] = implode(',',$a);
				$rowid= data_inserter('qa_amd_jmmi_feedback',$field_array); 
			/////////////	
				if(get_login_type()=="client"){
					$field_array1 = array("client_entryby" => $current_user);
				}else{
					$field_array1 = array("entry_by" => $current_user);
				}
				$this->db->where('id', $rowid);
				$this->db->update('qa_amd_jmmi_feedback',$field_array1);
			///////////
				redirect('Qa_ameridial/jmmi');
			}
			$data["array"] = $a;
			$this->load->view("dashboard",$data);
		}
	}
	
	
	public function mgnt_jmmi_rvw($id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_ameridial/jmmi/mgnt_rvw.php";
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM signin where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,134) and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
				from qa_amd_jmmi_feedback where id='$id') xx Left Join
				(Select office_id,id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid)";
			$data["jmmi_data"] = $this->Common_model->get_query_row_array($qSql);
			
			$data["fbid"]=$id;
			
			if($this->input->post('fbid'))
			{
				$fbid=$this->input->post('fbid');
				$curDateTime=CurrMySqlDate();
				$log=get_logs();
				
				/* if($this->input->post('text24')=='Yes') $text24 = 'No';
				else if ($this->input->post('text24')=='No') $text24 = 'Yes';
				else $text24 = 'N/A'; */
				
				$field_array = array(
					"agent_id" => $this->input->post('agent_id'),
					"tl_id" => $this->input->post('tl_id'),
					"call_date" => mmddyy2mysql($this->input->post('call_date')),
					"file_no" => $this->input->post('file_no'),
					"call_duration" => $this->input->post('call_duration'),
					"audit_type" => $this->input->post('audit_type'),
					"auditor_type" => $this->input->post('auditor_type'),
					"voc" => $this->input->post('voc'),
					"possible_score" => $this->input->post('possible_score'),
					"earned_score" => $this->input->post('earned_score'),
					"overall_score" => $this->input->post('overall_score'),
					"agent_appropriate_greeting" => $this->input->post('text1'),
					"agent_excellent_conversational_responses" => $this->input->post('text2'),
					"agent_verify_opening_information" => $this->input->post('text3'),
					"agent_follow_call_flow" => $this->input->post('text4'),
					"agent_appropriate_gratitude" => $this->input->post('text5'),
					"agent_share_upsells" => $this->input->post('text6'),
					"agent_show_familiarity_search" => $this->input->post('text7'),
					"agent_thank_caller_specifically" => $this->input->post('text8'),
					"agent_share_facts_appropriate" => $this->input->post('text9'),
					"agent_professional_communication" => $this->input->post('text10'),
					"agent_proper_enthusiasm" => $this->input->post('text11'),
					"agent_maintain_control_conversation" => $this->input->post('text12'),
					"agent_spoke_clearly" => $this->input->post('text13'),
					"agent_good_listening_skills_responses" => $this->input->post('text14'),
					"agent_empathize_caller_and_compassion" => $this->input->post('text15'),
					"agent_have_minimal_dead_air" => $this->input->post('text16'),
					"agent_have_caller_provide_address" => $this->input->post('text17'),
					"agent_confirm_dollar_amount" => $this->input->post('text18'),
					"agent_read_shipping_information" => $this->input->post('text19'),
					"agent_ask_caller_email_tv_information" => $this->input->post('text20'),
					"agent_proper_thanks" => $this->input->post('text21'),
					"agent_transfer_call_prayer_appropriate" => $this->input->post('text22'),
					"agent_follow_payment" => $this->input->post('text23'),
					"agent_read_back_customer_details_properly" => $this->input->post('text24'),
					"call_summary" => $this->input->post('call_summary'),
					"feedback" => $this->input->post('feedback')
				);
				$this->db->where('id', $fbid);
				$this->db->update('qa_amd_jmmi_feedback',$field_array);
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
				$this->db->where('id', $fbid);
				$this->db->update('qa_amd_jmmi_feedback',$field_array1);	
			///////////
				redirect('Qa_ameridial/jmmi');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}
///////////////////////////////////////////////////////////////////////////////////
/*-------------------------- JMMI (End) ---------------------------*/
///////////////////////////////////////////////////////////////////////////////////

///////////////////////////////////////////////////////////////////////////////////
/*-------------------------- REVEL (Start) ---------------------------*/
///////////////////////////////////////////////////////////////////////////////////	

	public function revel(){
		if(check_logged_in())
		{
			$current_user = get_user_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_ameridial/revel/qa_feedback.php";
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,134) and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$from_date = $this->input->get('from_date');
			$to_date = $this->input->get('to_date');
			$agent_id = $this->input->get('agent_id');
			$file = $this->input->get('file');
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
			
			if($from_date !="" && $to_date!=="" )  $cond= " Where (date(audit_date) >= '$from_date' and date(audit_date) <= '$to_date' ) ";
			if($agent_id !="")	$cond .=" and agent_id='$agent_id'";
			if($file !="")	$cond .=" and file_no like '%$file%'";
			
			if(get_user_fusion_id()!='FMIN000011' || get_user_fusion_id()!='FUTA000007' || get_user_fusion_id()!='FUTA000012'){
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
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_name
				from qa_amd_revel_feedback $cond) xx Left Join
				(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";
			$data["revel_data"] = $this->Common_model->get_query_result_array($qSql);
			
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			$data["agent_id"] = $agent_id;
			$data["file"] = $file;
			
			$this->load->view("dashboard",$data);
		}
	}

	
	public function add_revel_feedback(){
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_ameridial/revel/add_feedback.php";
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,134) and status=1  order by name";
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
					"call_date" => mmddyy2mysql($this->input->post('call_date')),
					"file_no" => $this->input->post('file_no'),
					"csr_id" => $this->input->post('csr_id'),
					//"call_type" => $this->input->post('call_type'),
					//"caller_type" => $this->input->post('caller_type'),
					"call_duration" => $this->input->post('call_duration'),
					"audit_type" => $this->input->post('audit_type'),
					"auditor_type" => $this->input->post('auditor_type'),
					"voc" => $this->input->post('voc'),
					"possible_score" => $this->input->post('possible_score'),
					"earned_score" => $this->input->post('earned_score'),
					"overall_score" => $this->input->post('overall_score'),
					"repgreetingcustomer" => $this->input->post('repgreetingcustomer'),
					"repuserespectfultone" => $this->input->post('repuserespectfultone'),
					"repasnwertimelymanner" => $this->input->post('repasnwertimelymanner'),
					"repcollectcallerinformation" => $this->input->post('repcollectcallerinformation'),
					"repuselisteningskills" => $this->input->post('repuselisteningskills'),
					"repdemonstratecalltechnique" => $this->input->post('repdemonstratecalltechnique'),
					"repreframeinterruptcaller" => $this->input->post('repreframeinterruptcaller'),
					"repspeakclearlyatpace" => $this->input->post('repspeakclearlyatpace'),
					"repavoiduseofterms" => $this->input->post('repavoiduseofterms'),
					"repconfidentinresponce" => $this->input->post('repconfidentinresponce'),
					"repusercallerlastname" => $this->input->post('repusercallerlastname'),
					"repusefiltertoobtain" => $this->input->post('repusefiltertoobtain'),
					"repmaintaincallcontrol" => $this->input->post('repmaintaincallcontrol'),
					"repusetoolappropiately" => $this->input->post('repusetoolappropiately'),
					"repdemonstrateproductknowledge" => $this->input->post('repdemonstrateproductknowledge'),
					"repuseappropiatescript" => $this->input->post('repuseappropiatescript'),
					"repaccuratelycalldocument" => $this->input->post('repaccuratelycalldocument'),
					"repcompletecorrectclosing" => $this->input->post('repcompletecorrectclosing'),
					"repthankthecaller" => $this->input->post('repthankthecaller'),
					"repgiveMedicaladvice" => $this->input->post('repgiveMedicaladvice'),
					"cmt1" => $this->input->post('cmt1'),
					"cmt2" => $this->input->post('cmt2'),
					"cmt3" => $this->input->post('cmt3'),
					"cmt4" => $this->input->post('cmt4'),
					"cmt5" => $this->input->post('cmt5'),
					"cmt6" => $this->input->post('cmt6'),
					"cmt7" => $this->input->post('cmt7'),
					"cmt8" => $this->input->post('cmt8'),
					"cmt9" => $this->input->post('cmt9'),
					"cmt10" => $this->input->post('cmt10'),
					"cmt11" => $this->input->post('cmt11'),
					"cmt12" => $this->input->post('cmt12'),
					"cmt13" => $this->input->post('cmt13'),
					"cmt14" => $this->input->post('cmt14'),
					"cmt15" => $this->input->post('cmt15'),
					"cmt16" => $this->input->post('cmt16'),
					"cmt17" => $this->input->post('cmt17'),
					"cmt18" => $this->input->post('cmt18'),
					"cmt19" => $this->input->post('cmt19'),
					"cmt20" => $this->input->post('cmt20'),
					"agentMiscodeCall" => $this->input->post('agentMiscodeCall'),
					"cmt21" => $this->input->post('cmt21'),
					"call_summary" => $this->input->post('call_summary'),
					"feedback" => $this->input->post('feedback'),
					"entry_date" => $curDateTime,
					"audit_start_time" => $this->input->post('audit_start_time')
				);
				$a = $this->amd_upload_files($_FILES['attach_file'], $path='./qa_files/qa_ameridial/revel/');
				$field_array["attach_file"] = implode(',',$a);
				$rowid= data_inserter('qa_amd_revel_feedback',$field_array); 
			/////////////	
				if(get_login_type()=="client"){
					$field_array1 = array("client_entryby" => $current_user);
				}else{
					$field_array1 = array("entry_by" => $current_user);
				}
				$this->db->where('id', $rowid);
				$this->db->update('qa_amd_revel_feedback',$field_array1);
			///////////
				redirect('Qa_ameridial/revel');
			}
			$data["array"] = $a;
			$this->load->view("dashboard",$data);
		}
	}
	
	public function mgnt_revel_rvw($id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_ameridial/revel/mgnt_rvw.php";
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM signin where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,134) and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
				from qa_amd_revel_feedback where id='$id') xx Left Join
				(Select office_id,id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid)";
			$data["revel_data"] = $this->Common_model->get_query_row_array($qSql);
			
			$data["rvlid"]=$id;
			
			if($this->input->post('rvlid'))
			{
				$rvlid=$this->input->post('rvlid');
				$curDateTime=CurrMySqlDate();
				$log=get_logs();
				
				$field_array = array(
					"agent_id" => $this->input->post('agent_id'),
					"tl_id" => $this->input->post('tl_id'),
					"call_date" => mmddyy2mysql($this->input->post('call_date')),
					"file_no" => $this->input->post('file_no'),
					"csr_id" => $this->input->post('csr_id'),
					//"call_type" => $this->input->post('call_type'),
					//"caller_type" => $this->input->post('caller_type'),
					"call_duration" => $this->input->post('call_duration'),
					"audit_type" => $this->input->post('audit_type'),
					"auditor_type" => $this->input->post('auditor_type'),
					"voc" => $this->input->post('voc'),
					"possible_score" => $this->input->post('possible_score'),
					"earned_score" => $this->input->post('earned_score'),
					"overall_score" => $this->input->post('overall_score'),
					"repgreetingcustomer" => $this->input->post('repgreetingcustomer'),
					"repuserespectfultone" => $this->input->post('repuserespectfultone'),
					"repasnwertimelymanner" => $this->input->post('repasnwertimelymanner'),
					"repcollectcallerinformation" => $this->input->post('repcollectcallerinformation'),
					"repuselisteningskills" => $this->input->post('repuselisteningskills'),
					"repdemonstratecalltechnique" => $this->input->post('repdemonstratecalltechnique'),
					"repreframeinterruptcaller" => $this->input->post('repreframeinterruptcaller'),
					"repspeakclearlyatpace" => $this->input->post('repspeakclearlyatpace'),
					"repavoiduseofterms" => $this->input->post('repavoiduseofterms'),
					"repconfidentinresponce" => $this->input->post('repconfidentinresponce'),
					"repusercallerlastname" => $this->input->post('repusercallerlastname'),
					"repusefiltertoobtain" => $this->input->post('repusefiltertoobtain'),
					"repmaintaincallcontrol" => $this->input->post('repmaintaincallcontrol'),
					"repusetoolappropiately" => $this->input->post('repusetoolappropiately'),
					"repdemonstrateproductknowledge" => $this->input->post('repdemonstrateproductknowledge'),
					"repuseappropiatescript" => $this->input->post('repuseappropiatescript'),
					"repaccuratelycalldocument" => $this->input->post('repaccuratelycalldocument'),
					"repcompletecorrectclosing" => $this->input->post('repcompletecorrectclosing'),
					"repthankthecaller" => $this->input->post('repthankthecaller'),
					"repgiveMedicaladvice" => $this->input->post('repgiveMedicaladvice'),
					"cmt1" => $this->input->post('cmt1'),
					"cmt2" => $this->input->post('cmt2'),
					"cmt3" => $this->input->post('cmt3'),
					"cmt4" => $this->input->post('cmt4'),
					"cmt5" => $this->input->post('cmt5'),
					"cmt6" => $this->input->post('cmt6'),
					"cmt7" => $this->input->post('cmt7'),
					"cmt8" => $this->input->post('cmt8'),
					"cmt9" => $this->input->post('cmt9'),
					"cmt10" => $this->input->post('cmt10'),
					"cmt11" => $this->input->post('cmt11'),
					"cmt12" => $this->input->post('cmt12'),
					"cmt13" => $this->input->post('cmt13'),
					"cmt14" => $this->input->post('cmt14'),
					"cmt15" => $this->input->post('cmt15'),
					"cmt16" => $this->input->post('cmt16'),
					"cmt17" => $this->input->post('cmt17'),
					"cmt18" => $this->input->post('cmt18'),
					"cmt19" => $this->input->post('cmt19'),
					"cmt20" => $this->input->post('cmt20'),
					"agentMiscodeCall" => $this->input->post('agentMiscodeCall'),
					"cmt21" => $this->input->post('cmt21'),
					"call_summary" => $this->input->post('call_summary'),
					"feedback" => $this->input->post('feedback')
				);
				$this->db->where('id', $rvlid);
				$this->db->update('qa_amd_revel_feedback',$field_array);
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
				$this->db->where('id', $rvlid);
				$this->db->update('qa_amd_revel_feedback',$field_array1);	
			///////////
				redirect('Qa_ameridial/revel');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}
///////////////////////////////////////////////////////////////////////////////////
/*-------------------------- REVEL (End) ---------------------------*/
///////////////////////////////////////////////////////////////////////////////////

///////////////////////////////////////////////////////////////////////////////////
/*-------------------------- QPC (Start) ---------------------------*/
///////////////////////////////////////////////////////////////////////////////////	

	public function qpc(){
		if(check_logged_in())
		{
			$current_user = get_user_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_ameridial/qpc/qa_feedback.php";
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,134) and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$from_date = $this->input->get('from_date');
			$to_date = $this->input->get('to_date');
			$agent_id = $this->input->get('agent_id');
			$file = $this->input->get('file');
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
			
			if($from_date !="" && $to_date!=="" )  $cond= " Where (date(audit_date) >= '$from_date' and date(audit_date) <= '$to_date' ) ";
			if($agent_id !="")	$cond .=" and agent_id='$agent_id'";
			if($file !="")	$cond .=" and file_no like '%$file%'";
			
			if(get_user_fusion_id()!='FMIN000011' || get_user_fusion_id()!='FUTA000007' || get_user_fusion_id()!='FUTA000012'){
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
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_name
				from qa_amd_qpc_feedback $cond) xx Left Join
				(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";
			$data["qpc_data"] = $this->Common_model->get_query_result_array($qSql);
			
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			$data["agent_id"] = $agent_id;
			$data["file"] = $file;
			
			$this->load->view("dashboard",$data);
		}
	}

	
	public function add_qpc_feedback(){
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_ameridial/qpc/add_feedback.php";
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,134) and status=1  order by name";
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
					"call_date" => mmddyy2mysql($this->input->post('call_date')),
					"file_no" => $this->input->post('file_no'),
					"call_duration" => $this->input->post('call_duration'),
					//"csr_id" => $this->input->post('csr_id'),
					//"call_type" => $this->input->post('call_type'),
					//"caller_type" => $this->input->post('caller_type'),
					"audit_type" => $this->input->post('audit_type'),
					"auditor_type" => $this->input->post('auditor_type'),
					"voc" => $this->input->post('voc'),
					"possible_score" => $this->input->post('possible_score'),
					"earned_score" => $this->input->post('earned_score'),
					"overall_score" => $this->input->post('overall_score'),
					"unpreparedCallIntroduce" => $this->input->post('unpreparedCallIntroduce'),
					"didnotUseBranding" => $this->input->post('didnotUseBranding'),
					"dataNotCollected" => $this->input->post('dataNotCollected'),
					"secondDataOccurrence" => $this->input->post('secondDataOccurrence'),
					"inaccurateCallResult" => $this->input->post('inaccurateCallResult'),
					"unusableAfterCallComment" => $this->input->post('unusableAfterCallComment'),
					"underutilizedCallNarration" => $this->input->post('underutilizedCallNarration'),
					"inappropiateFAQResponce" => $this->input->post('inappropiateFAQResponce'),
					"imprpperTransaction" => $this->input->post('imprpperTransaction'),
					"underAcknowledgeCaller" => $this->input->post('underAcknowledgeCaller'),
					"inappropiateScript" => $this->input->post('inappropiateScript'),
					"notDisplayOwnership" => $this->input->post('notDisplayOwnership'),
					"incorrectTransfer" => $this->input->post('incorrectTransfer'),
					"didagentabruptendcall" => $this->input->post('didagentabruptendcall'),
					"didagentanswerpremiumquestion" => $this->input->post('didagentanswerpremiumquestion'),
					"didagentgivewrongcallback" => $this->input->post('didagentgivewrongcallback'),
					"didagentuseincorrectname" => $this->input->post('didagentuseincorrectname'),
					"cmt1" => $this->input->post('cmt1'),
					"cmt2" => $this->input->post('cmt2'),
					"cmt3" => $this->input->post('cmt3'),
					"cmt4" => $this->input->post('cmt4'),
					"cmt5" => $this->input->post('cmt5'),
					"cmt6" => $this->input->post('cmt6'),
					"cmt7" => $this->input->post('cmt7'),
					"cmt8" => $this->input->post('cmt8'),
					"cmt9" => $this->input->post('cmt9'),
					"cmt10" => $this->input->post('cmt10'),
					"cmt11" => $this->input->post('cmt11'),
					"cmt12" => $this->input->post('cmt12'),
					"cmt13" => $this->input->post('cmt13'),
					"cmt14" => $this->input->post('cmt14'),
					"cmt15" => $this->input->post('cmt15'),
					"cmt16" => $this->input->post('cmt16'),
					"cmt17" => $this->input->post('cmt17'),
					"call_summary" => $this->input->post('call_summary'),
					"feedback" => $this->input->post('feedback'),
					"entry_date" => $curDateTime,
					"audit_start_time" => $this->input->post('audit_start_time')
				);
				$a = $this->amd_upload_files($_FILES['attach_file'], $path='./qa_files/qa_ameridial/qpc/');
				$field_array["attach_file"] = implode(',',$a);
				$rowid= data_inserter('qa_amd_qpc_feedback',$field_array); 
			/////////////	
				if(get_login_type()=="client"){
					$field_array1 = array("client_entryby" => $current_user);
				}else{
					$field_array1 = array("entry_by" => $current_user);
				}
				$this->db->where('id', $rowid);
				$this->db->update('qa_amd_qpc_feedback',$field_array1);
			///////////
				redirect('Qa_ameridial/qpc');
			}
			$data["array"] = $a;
			$this->load->view("dashboard",$data);
		}
	}
	
	
	public function mgnt_qpc_rvw($id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_ameridial/qpc/mgnt_rvw.php";
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM signin where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,134) and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
				from qa_amd_qpc_feedback where id='$id') xx Left Join
				(Select office_id,id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid)";
			$data["qpc_data"] = $this->Common_model->get_query_row_array($qSql);
			
			$data["qpcid"]=$id;
			
			if($this->input->post('qpcid'))
			{
				$qpcid=$this->input->post('qpcid');
				$curDateTime=CurrMySqlDate();
				$log=get_logs();
				
				$field_array = array(
					"agent_id" => $this->input->post('agent_id'),
					"tl_id" => $this->input->post('tl_id'),
					"call_date" => mmddyy2mysql($this->input->post('call_date')),
					"file_no" => $this->input->post('file_no'),
					"call_duration" => $this->input->post('call_duration'),
					//"csr_id" => $this->input->post('csr_id'),
					//"call_type" => $this->input->post('call_type'),
					//"caller_type" => $this->input->post('caller_type'),
					"audit_type" => $this->input->post('audit_type'),
					"auditor_type" => $this->input->post('auditor_type'),
					"voc" => $this->input->post('voc'),
					"possible_score" => $this->input->post('possible_score'),
					"earned_score" => $this->input->post('earned_score'),
					"overall_score" => $this->input->post('overall_score'),
					"unpreparedCallIntroduce" => $this->input->post('unpreparedCallIntroduce'),
					"didnotUseBranding" => $this->input->post('didnotUseBranding'),
					"dataNotCollected" => $this->input->post('dataNotCollected'),
					"secondDataOccurrence" => $this->input->post('secondDataOccurrence'),
					"inaccurateCallResult" => $this->input->post('inaccurateCallResult'),
					"unusableAfterCallComment" => $this->input->post('unusableAfterCallComment'),
					"underutilizedCallNarration" => $this->input->post('underutilizedCallNarration'),
					"inappropiateFAQResponce" => $this->input->post('inappropiateFAQResponce'),
					"imprpperTransaction" => $this->input->post('imprpperTransaction'),
					"underAcknowledgeCaller" => $this->input->post('underAcknowledgeCaller'),
					"inappropiateScript" => $this->input->post('inappropiateScript'),
					"notDisplayOwnership" => $this->input->post('notDisplayOwnership'),
					"incorrectTransfer" => $this->input->post('incorrectTransfer'),
					"didagentabruptendcall" => $this->input->post('didagentabruptendcall'),
					"didagentanswerpremiumquestion" => $this->input->post('didagentanswerpremiumquestion'),
					"didagentgivewrongcallback" => $this->input->post('didagentgivewrongcallback'),
					"didagentuseincorrectname" => $this->input->post('didagentuseincorrectname'),
					"cmt1" => $this->input->post('cmt1'),
					"cmt2" => $this->input->post('cmt2'),
					"cmt3" => $this->input->post('cmt3'),
					"cmt4" => $this->input->post('cmt4'),
					"cmt5" => $this->input->post('cmt5'),
					"cmt6" => $this->input->post('cmt6'),
					"cmt7" => $this->input->post('cmt7'),
					"cmt8" => $this->input->post('cmt8'),
					"cmt9" => $this->input->post('cmt9'),
					"cmt10" => $this->input->post('cmt10'),
					"cmt11" => $this->input->post('cmt11'),
					"cmt12" => $this->input->post('cmt12'),
					"cmt13" => $this->input->post('cmt13'),
					"cmt14" => $this->input->post('cmt14'),
					"cmt15" => $this->input->post('cmt15'),
					"cmt16" => $this->input->post('cmt16'),
					"cmt17" => $this->input->post('cmt17'),
					"call_summary" => $this->input->post('call_summary'),
					"feedback" => $this->input->post('feedback')
				);
				$this->db->where('id', $qpcid);
				$this->db->update('qa_amd_qpc_feedback',$field_array);
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
				$this->db->where('id', $qpcid);
				$this->db->update('qa_amd_qpc_feedback',$field_array1);	
			///////////
				redirect('Qa_ameridial/qpc');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}
///////////////////////////////////////////////////////////////////////////////////
/*-------------------------- QPC (End) ---------------------------*/
///////////////////////////////////////////////////////////////////////////////////	

///////////////////////////////////////////////////////////////////////////////////
/*-------------------------- Ancient Nutrition (Start) ---------------------------*/
///////////////////////////////////////////////////////////////////////////////////	

	public function ancient_nutrition(){
		if(check_logged_in())
		{
			$current_user = get_user_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_ameridial/ancient_nutrition/qa_feedback.php";
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,134) and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$from_date = $this->input->get('from_date');
			$to_date = $this->input->get('to_date');
			$agent_id = $this->input->get('agent_id');
			$file = $this->input->get('file');
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
			
			if($from_date !="" && $to_date!=="" )  $cond= " Where (date(audit_date) >= '$from_date' and date(audit_date) <= '$to_date' ) ";
			if($agent_id !="")	$cond .=" and agent_id='$agent_id'";
			if($file !="")	$cond .=" and file_no like '%$file%'";
			
			if(get_user_fusion_id()!='FMIN000011' || get_user_fusion_id()!='FUTA000007' || get_user_fusion_id()!='FUTA000012'){
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
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_name
				from qa_amd_ancient_nutrition_feedback $cond) xx Left Join
				(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";
			$data["ancient_nutrition_data"] = $this->Common_model->get_query_result_array($qSql);
			
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			$data["agent_id"] = $agent_id;
			$data["file"] = $file;
			
			$this->load->view("dashboard",$data);
		}
	}

	
	public function add_ancient_nutrition_feedback(){
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_ameridial/ancient_nutrition/add_feedback.php";
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,134) and status=1  order by name";
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
					"call_date" => mmddyy2mysql($this->input->post('call_date')),
					"file_no" => $this->input->post('file_no'),
					"call_duration" => $this->input->post('call_duration'),
					"audit_type" => $this->input->post('audit_type'),
					"auditor_type" => $this->input->post('auditor_type'),
					"voc" => $this->input->post('voc'),
					"possible_score" => $this->input->post('possible_score'),
					"earned_score" => $this->input->post('earned_score'),
					"overall_score" => $this->input->post('overall_score'),
					"repgreetingcustomer" => $this->input->post('repgreetingcustomer'),
					"repuserespectfultone" => $this->input->post('repuserespectfultone'),
					"repasnwertimelymanner" => $this->input->post('repasnwertimelymanner'),
					"repcollectcustomerinfo" => $this->input->post('repcollectcustomerinfo'),
					"repcoverpaymentprocedure" => $this->input->post('repcoverpaymentprocedure'),
					"repuselisteningskills" => $this->input->post('repuselisteningskills'),
					"repdemonstratecalltechnique" => $this->input->post('repdemonstratecalltechnique'),
					"repreframeinterruptcaller" => $this->input->post('repreframeinterruptcaller'),
					"repspeakclearlyatpace" => $this->input->post('repspeakclearlyatpace'),
					"repavoiduseinternalterms" => $this->input->post('repavoiduseinternalterms'),
					"repconfidentinresponce" => $this->input->post('repconfidentinresponce'),
					"repusercallerlastname" => $this->input->post('repusercallerlastname'),
					"repusefiltertoobtain" => $this->input->post('repusefiltertoobtain'),
					"repcoverautoshipping" => $this->input->post('repcoverautoshipping'),
					"repgatheredemail" => $this->input->post('repgatheredemail'),
					"repcoverRushshipping" => $this->input->post('repcoverRushshipping'),
					"repcompleteorderconfirmation" => $this->input->post('repcompleteorderconfirmation'),
					"repmaintaincallcontrol" => $this->input->post('repmaintaincallcontrol'),
					"repusetoolappropiately" => $this->input->post('repusetoolappropiately'),
					"repdemonstrateproductknowledge" => $this->input->post('repdemonstrateproductknowledge'),
					"repuseappropiateobjection" => $this->input->post('repuseappropiateobjection'),
					"repaccuratelycalldocument" => $this->input->post('repaccuratelycalldocument'),
					"repcompletecorrectclosing" => $this->input->post('repcompletecorrectclosing'),
					"repthankthecallerbeforeclosing" => $this->input->post('repthankthecallerbeforeclosing'),
					"repcoveroffersappropiately" => $this->input->post('repcoveroffersappropiately'),
					"repcoverupsellappropiately" => $this->input->post('repcoverupsellappropiately'),
					"cmt1" => $this->input->post('cmt1'),
					"cmt2" => $this->input->post('cmt2'),
					"cmt3" => $this->input->post('cmt3'),
					"cmt4" => $this->input->post('cmt4'),
					"cmt5" => $this->input->post('cmt5'),
					"cmt6" => $this->input->post('cmt6'),
					"cmt7" => $this->input->post('cmt7'),
					"cmt8" => $this->input->post('cmt8'),
					"cmt9" => $this->input->post('cmt9'),
					"cmt10" => $this->input->post('cmt10'),
					"cmt11" => $this->input->post('cmt11'),
					"cmt12" => $this->input->post('cmt12'),
					"cmt13" => $this->input->post('cmt13'),
					"cmt14" => $this->input->post('cmt14'),
					"cmt15" => $this->input->post('cmt15'),
					"cmt16" => $this->input->post('cmt16'),
					"cmt17" => $this->input->post('cmt17'),
					"cmt18" => $this->input->post('cmt18'),
					"cmt19" => $this->input->post('cmt19'),
					"cmt20" => $this->input->post('cmt20'),
					"cmt21" => $this->input->post('cmt21'),
					"cmt22" => $this->input->post('cmt22'),
					"cmt23" => $this->input->post('cmt23'),
					"cmt24" => $this->input->post('cmt24'),
					"cmt25" => $this->input->post('cmt25'),
					"cmt26" => $this->input->post('cmt26'),
					"agentReadConfirmScript" => $this->input->post('agentReadConfirmScript'),
					"cmt27" => $this->input->post('cmt27'),
					"call_summary" => $this->input->post('call_summary'),
					"feedback" => $this->input->post('feedback'),
					"entry_date" => $curDateTime,
					"audit_start_time" => $this->input->post('audit_start_time')
				);
				$a = $this->amd_upload_files($_FILES['attach_file'], $path='./qa_files/qa_ameridial/ancient_nutrition/');
				$field_array["attach_file"] = implode(',',$a);
				$rowid= data_inserter('qa_amd_ancient_nutrition_feedback',$field_array); 
			/////////////	
				if(get_login_type()=="client"){
					$field_array1 = array("client_entryby" => $current_user);
				}else{
					$field_array1 = array("entry_by" => $current_user);
				}
				$this->db->where('id', $rowid);
				$this->db->update('qa_amd_ancient_nutrition_feedback',$field_array1);
			///////////
				redirect('Qa_ameridial/ancient_nutrition');
			}
			$data["array"] = $a;
			$this->load->view("dashboard",$data);
		}
	}
	
	public function mgnt_ancient_nutrition_rvw($id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_ameridial/ancient_nutrition/mgnt_rvw.php";
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM signin where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,134) and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
				from qa_amd_ancient_nutrition_feedback where id='$id') xx Left Join
				(Select office_id,id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid)";
			$data["ancient_nutrition_data"] = $this->Common_model->get_query_row_array($qSql);
			
			$data["anid"]=$id;
			
			if($this->input->post('anid'))
			{
				$anid=$this->input->post('anid');
				$curDateTime=CurrMySqlDate();
				$log=get_logs();
				
				$field_array = array(
					"agent_id" => $this->input->post('agent_id'),
					"tl_id" => $this->input->post('tl_id'),
					"call_date" => mmddyy2mysql($this->input->post('call_date')),
					"file_no" => $this->input->post('file_no'),
					"call_duration" => $this->input->post('call_duration'),
					"audit_type" => $this->input->post('audit_type'),
					"auditor_type" => $this->input->post('auditor_type'),
					"voc" => $this->input->post('voc'),
					"possible_score" => $this->input->post('possible_score'),
					"earned_score" => $this->input->post('earned_score'),
					"overall_score" => $this->input->post('overall_score'),
					"repgreetingcustomer" => $this->input->post('repgreetingcustomer'),
					"repuserespectfultone" => $this->input->post('repuserespectfultone'),
					"repasnwertimelymanner" => $this->input->post('repasnwertimelymanner'),
					"repcollectcustomerinfo" => $this->input->post('repcollectcustomerinfo'),
					"repcoverpaymentprocedure" => $this->input->post('repcoverpaymentprocedure'),
					"repuselisteningskills" => $this->input->post('repuselisteningskills'),
					"repdemonstratecalltechnique" => $this->input->post('repdemonstratecalltechnique'),
					"repreframeinterruptcaller" => $this->input->post('repreframeinterruptcaller'),
					"repspeakclearlyatpace" => $this->input->post('repspeakclearlyatpace'),
					"repavoiduseinternalterms" => $this->input->post('repavoiduseinternalterms'),
					"repconfidentinresponce" => $this->input->post('repconfidentinresponce'),
					"repusercallerlastname" => $this->input->post('repusercallerlastname'),
					"repusefiltertoobtain" => $this->input->post('repusefiltertoobtain'),
					"repcoverautoshipping" => $this->input->post('repcoverautoshipping'),
					"repgatheredemail" => $this->input->post('repgatheredemail'),
					"repcoverRushshipping" => $this->input->post('repcoverRushshipping'),
					"repcompleteorderconfirmation" => $this->input->post('repcompleteorderconfirmation'),
					"repmaintaincallcontrol" => $this->input->post('repmaintaincallcontrol'),
					"repusetoolappropiately" => $this->input->post('repusetoolappropiately'),
					"repdemonstrateproductknowledge" => $this->input->post('repdemonstrateproductknowledge'),
					"repuseappropiateobjection" => $this->input->post('repuseappropiateobjection'),
					"repaccuratelycalldocument" => $this->input->post('repaccuratelycalldocument'),
					"repcompletecorrectclosing" => $this->input->post('repcompletecorrectclosing'),
					"repthankthecallerbeforeclosing" => $this->input->post('repthankthecallerbeforeclosing'),
					"repcoveroffersappropiately" => $this->input->post('repcoveroffersappropiately'),
					"repcoverupsellappropiately" => $this->input->post('repcoverupsellappropiately'),
					"cmt1" => $this->input->post('cmt1'),
					"cmt2" => $this->input->post('cmt2'),
					"cmt3" => $this->input->post('cmt3'),
					"cmt4" => $this->input->post('cmt4'),
					"cmt5" => $this->input->post('cmt5'),
					"cmt6" => $this->input->post('cmt6'),
					"cmt7" => $this->input->post('cmt7'),
					"cmt8" => $this->input->post('cmt8'),
					"cmt9" => $this->input->post('cmt9'),
					"cmt10" => $this->input->post('cmt10'),
					"cmt11" => $this->input->post('cmt11'),
					"cmt12" => $this->input->post('cmt12'),
					"cmt13" => $this->input->post('cmt13'),
					"cmt14" => $this->input->post('cmt14'),
					"cmt15" => $this->input->post('cmt15'),
					"cmt16" => $this->input->post('cmt16'),
					"cmt17" => $this->input->post('cmt17'),
					"cmt18" => $this->input->post('cmt18'),
					"cmt19" => $this->input->post('cmt19'),
					"cmt20" => $this->input->post('cmt20'),
					"cmt21" => $this->input->post('cmt21'),
					"cmt22" => $this->input->post('cmt22'),
					"cmt23" => $this->input->post('cmt23'),
					"cmt24" => $this->input->post('cmt24'),
					"cmt25" => $this->input->post('cmt25'),
					"cmt26" => $this->input->post('cmt26'),
					"agentReadConfirmScript" => $this->input->post('agentReadConfirmScript'),
					"cmt27" => $this->input->post('cmt27'),
					"call_summary" => $this->input->post('call_summary'),
					"feedback" => $this->input->post('feedback')
				);
				$this->db->where('id', $anid);
				$this->db->update('qa_amd_ancient_nutrition_feedback',$field_array);
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
				$this->db->where('id', $anid);
				$this->db->update('qa_amd_ancient_nutrition_feedback',$field_array1);	
			///////////
				redirect('Qa_ameridial/ancient_nutrition');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}
///////////////////////////////////////////////////////////////////////////////////
/*-------------------------- Ancient Nutrition (End) ---------------------------*/
///////////////////////////////////////////////////////////////////////////////////

///////////////////////////////////////////////////////////////////////////////////
/*----------------------------- Power Fan (Start) ------------------------------*/
///////////////////////////////////////////////////////////////////////////////////	

	public function power_fan(){
		if(check_logged_in())
		{
			$current_user = get_user_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_ameridial/power_fan/qa_feedback.php";
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,134) and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$from_date = $this->input->get('from_date');
			$to_date = $this->input->get('to_date');
			$agent_id = $this->input->get('agent_id');
			$file = $this->input->get('file');
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
			
			if($from_date !="" && $to_date!=="" )  $cond= " Where (date(audit_date) >= '$from_date' and date(audit_date) <= '$to_date' ) ";
			if($agent_id !="")	$cond .=" and agent_id='$agent_id'";
			if($file !="")	$cond .=" and file_no like '%$file%'";
			
			if(get_user_fusion_id()!='FMIN000011' || get_user_fusion_id()!='FUTA000007' || get_user_fusion_id()!='FUTA000012'){
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
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
				from qa_amd_powerfan_feedback $cond) xx Left Join
				(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";
			$data["powerfan_data"] = $this->Common_model->get_query_result_array($qSql);
			
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			$data["agent_id"] = $agent_id;
			$data["file"] = $file;
			
			$this->load->view("dashboard",$data);
		}
	}

	
	public function add_powerfan_feedback(){
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_ameridial/power_fan/add_feedback.php";
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,134) and status=1  order by name";
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
					"call_date" => mmddyy2mysql($this->input->post('call_date')),
					"file_no" => $this->input->post('file_no'),
					"call_duration" => $this->input->post('call_duration'),
					"audit_type" => $this->input->post('audit_type'),
					"auditor_type" => $this->input->post('auditor_type'),
					"voc" => $this->input->post('voc'),
					"possible_score" => $this->input->post('possible_score'),
					"earned_score" => $this->input->post('earned_score'),
					"overall_score" => $this->input->post('overall_score'),
					"answerCallWithin5sec" => $this->input->post('answerCallWithin5sec'),
					"agentIdentifySelftandCompany" => $this->input->post('agentIdentifySelftandCompany'),
					"collectIntroInformation" => $this->input->post('collectIntroInformation'),
					"mainSelftAgentGiveTerms" => $this->input->post('mainSelftAgentGiveTerms'),
					"agentPromoteUpsell" => $this->input->post('agentPromoteUpsell'),
					"describedProductAccurately" => $this->input->post('describedProductAccurately'),
					"useAppropiateObjection" => $this->input->post('useAppropiateObjection'),
					"askForBillingNamesOnCheck" => $this->input->post('askForBillingNamesOnCheck'),
					"agentVerifyCallerUseofCheck" => $this->input->post('agentVerifyCallerUseofCheck'),
					"askForBillingAddressForPayment" => $this->input->post('askForBillingAddressForPayment'),
					"agentVerifyShippingAddress" => $this->input->post('agentVerifyShippingAddress'),
					"orderWasSetUpAndCodedCorrectly" => $this->input->post('orderWasSetUpAndCodedCorrectly'),
					"askForEmailAddress" => $this->input->post('askForEmailAddress'),
					"gaveTotalAmountCharged" => $this->input->post('gaveTotalAmountCharged'),
					"gaveCorrectShippingInfo" => $this->input->post('gaveCorrectShippingInfo'),
					"gaveMBGInfo" => $this->input->post('gaveMBGInfo'),
					"gaveCSPhoneNumber" => $this->input->post('gaveCSPhoneNumber'),
					"permissionToAuthorizePayment" => $this->input->post('permissionToAuthorizePayment'),
					"wasAgentPolite" => $this->input->post('wasAgentPolite'),
					"agentUsingAppropiateComment" => $this->input->post('agentUsingAppropiateComment'),
					"useHoldAndTransferProperly" => $this->input->post('useHoldAndTransferProperly'),
					"power_fan_autofail" => $this->input->post('power_fan_autofail'),
					"call_summary" => $this->input->post('call_summary'),
					"feedback" => $this->input->post('feedback'),
					"entry_date" => $curDateTime,
					"audit_start_time" => $this->input->post('audit_start_time')
				);
				$a = $this->amd_upload_files($_FILES['attach_file'], $path='./qa_files/qa_ameridial/power_fan/');
				$field_array["attach_file"] = implode(',',$a);
				$rowid= data_inserter('qa_amd_powerfan_feedback',$field_array); 
			/////////////	
				if(get_login_type()=="client"){
					$field_array1 = array("client_entryby" => $current_user);
				}else{
					$field_array1 = array("entry_by" => $current_user);
				}
				$this->db->where('id', $rowid);
				$this->db->update('qa_amd_powerfan_feedback',$field_array1);
			///////////
				redirect('Qa_ameridial/power_fan');
			}
			$data["array"] = $a;
			$this->load->view("dashboard",$data);
		}
	}
	
	public function mgnt_powerfan_rvw($id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_ameridial/power_fan/mgnt_rvw.php";
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM signin where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,134) and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
				from qa_amd_powerfan_feedback where id='$id') xx Left Join
				(Select office_id,id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid)";
			$data["powerfan_data"] = $this->Common_model->get_query_row_array($qSql);
			
			$data["pfid"]=$id;
			
			if($this->input->post('pfid'))
			{
				$pfid=$this->input->post('pfid');
				$curDateTime=CurrMySqlDate();
				$log=get_logs();
				
				$field_array = array(
					"agent_id" => $this->input->post('agent_id'),
					"tl_id" => $this->input->post('tl_id'),
					"call_date" => mmddyy2mysql($this->input->post('call_date')),
					"file_no" => $this->input->post('file_no'),
					"call_duration" => $this->input->post('call_duration'),
					"audit_type" => $this->input->post('audit_type'),
					"auditor_type" => $this->input->post('auditor_type'),
					"voc" => $this->input->post('voc'),
					"possible_score" => $this->input->post('possible_score'),
					"earned_score" => $this->input->post('earned_score'),
					"overall_score" => $this->input->post('overall_score'),
					"answerCallWithin5sec" => $this->input->post('answerCallWithin5sec'),
					"agentIdentifySelftandCompany" => $this->input->post('agentIdentifySelftandCompany'),
					"collectIntroInformation" => $this->input->post('collectIntroInformation'),
					"mainSelftAgentGiveTerms" => $this->input->post('mainSelftAgentGiveTerms'),
					"agentPromoteUpsell" => $this->input->post('agentPromoteUpsell'),
					"describedProductAccurately" => $this->input->post('describedProductAccurately'),
					"useAppropiateObjection" => $this->input->post('useAppropiateObjection'),
					"askForBillingNamesOnCheck" => $this->input->post('askForBillingNamesOnCheck'),
					"agentVerifyCallerUseofCheck" => $this->input->post('agentVerifyCallerUseofCheck'),
					"askForBillingAddressForPayment" => $this->input->post('askForBillingAddressForPayment'),
					"agentVerifyShippingAddress" => $this->input->post('agentVerifyShippingAddress'),
					"orderWasSetUpAndCodedCorrectly" => $this->input->post('orderWasSetUpAndCodedCorrectly'),
					"askForEmailAddress" => $this->input->post('askForEmailAddress'),
					"gaveTotalAmountCharged" => $this->input->post('gaveTotalAmountCharged'),
					"gaveCorrectShippingInfo" => $this->input->post('gaveCorrectShippingInfo'),
					"gaveMBGInfo" => $this->input->post('gaveMBGInfo'),
					"gaveCSPhoneNumber" => $this->input->post('gaveCSPhoneNumber'),
					"permissionToAuthorizePayment" => $this->input->post('permissionToAuthorizePayment'),
					"wasAgentPolite" => $this->input->post('wasAgentPolite'),
					"agentUsingAppropiateComment" => $this->input->post('agentUsingAppropiateComment'),
					"useHoldAndTransferProperly" => $this->input->post('useHoldAndTransferProperly'),
					"power_fan_autofail" => $this->input->post('power_fan_autofail'),
					"call_summary" => $this->input->post('call_summary'),
					"feedback" => $this->input->post('feedback')
				);
				$this->db->where('id', $pfid);
				$this->db->update('qa_amd_powerfan_feedback',$field_array);
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
				$this->db->where('id', $pfid);
				$this->db->update('qa_amd_powerfan_feedback',$field_array1);	
			///////////
				redirect('Qa_ameridial/power_fan');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}
///////////////////////////////////////////////////////////////////////////////////
/*---------------------------- Power Fan (End) ------------------------------*/
///////////////////////////////////////////////////////////////////////////////////

///////////////////////////////////////////////////////////////////////////////////
/*---------------------------- NuWave (Start) ------------------------------*/
///////////////////////////////////////////////////////////////////////////////////

	public function nuwave(){
		if(check_logged_in())
		{
			$current_user = get_user_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_ameridial/nuwave/qa_feedback.php";
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM signin where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,194) and is_assign_process(id,390) and status=1  order by name";
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
			}else{
				$ops_cond="";
			}
		
			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_amd_nuwave_feedback $cond) xx Left Join
				(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";
			$data["nuwave"] = $this->Common_model->get_query_result_array($qSql);			
			
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			$data["agent_id"] = $agent_id;
			
			$this->load->view("dashboard",$data);
		}
	}
	
	public function add_nuwave_feedback(){
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_ameridial/nuwave/add_feedback.php";
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM signin where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,194) and is_assign_process(id,390) and status=1  order by name";
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
					"call_date" => mmddyy2mysql($this->input->post('call_date')),
					"file_no" => $this->input->post('file_no'),
					"order_id" => $this->input->post('order_id'),
					"call_duration" => $this->input->post('call_duration'),
					"interaction" => $this->input->post('interaction'),
					"audit_type" => $this->input->post('audit_type'),
					"auditor_type" => $this->input->post('auditor_type'),
					"voc" => $this->input->post('voc'),
					"possible_score" => $this->input->post('possible_score'),
					"earned_score" => $this->input->post('earned_score'),
					"overall_score" => $this->input->post('overall_score'),
					"greeting_identification" => $this->input->post('greeting_identification'),
					"verified_customer" => $this->input->post('verified_customer'),
					"use_caller_CSR_name" => $this->input->post('use_caller_CSR_name'),
					"doesnot_interrupt_customer" => $this->input->post('doesnot_interrupt_customer'),
					"converses_clear_concise_mannaer" => $this->input->post('converses_clear_concise_mannaer'),
					"avoid_use_slang_jargon" => $this->input->post('avoid_use_slang_jargon'),
					"empathy_toward_customer" => $this->input->post('empathy_toward_customer'),
					"CSR_sound_helpful" => $this->input->post('CSR_sound_helpful'),
					"gain_customer_permission" => $this->input->post('gain_customer_permission'),
					"thanks_customer_holding" => $this->input->post('thanks_customer_holding'),
					"hold_time_appropiate" => $this->input->post('hold_time_appropiate'),
					"utilized_established_guidelines" => $this->input->post('utilized_established_guidelines'),
					"use_probing_question" => $this->input->post('use_probing_question'),
					"verbally_verfied_problem" => $this->input->post('verbally_verfied_problem'),
					"manage_customer_expectation" => $this->input->post('manage_customer_expectation'),
					"reason_for_troubleshooting" => $this->input->post('reason_for_troubleshooting'),
					"use_available_resources" => $this->input->post('use_available_resources'),
					"complete_customer_documentation" => $this->input->post('complete_customer_documentation'),
					"customer_comfortable_with_outcome" => $this->input->post('customer_comfortable_with_outcome'),
					"additional_needs_uncovered" => $this->input->post('additional_needs_uncovered'),
					"product_served_their_needs" => $this->input->post('product_served_their_needs'),
					"used_correct_closing" => $this->input->post('used_correct_closing'),
					"infractions" => $this->input->post('infractions'),
					"sub_infractions" => $this->input->post('sub_infractions'),
					"call_summary" => $this->input->post('call_summary'),
					"feedback" => $this->input->post('feedback'),
					"entry_date" => $curDateTime,
					"audit_start_time" => $this->input->post('audit_start_time')
				);
				$a = $this->amd_upload_files($_FILES['attach_file'], $path='./qa_files/qa_ameridial/nuwave/');
				$field_array["attach_file"] = implode(',',$a);
				$rowid= data_inserter('qa_amd_nuwave_feedback',$field_array);
				
			/////////////	
				if(get_login_type()=="client"){
					$field_array1 = array("client_entryby" => $current_user);
				}else{
					$field_array1 = array("entry_by" => $current_user);
				}
				$this->db->where('id', $rowid);
				$this->db->update('qa_amd_nuwave_feedback',$field_array1);
			///////////	
				redirect('Qa_ameridial/nuwave');
			}
			$data["array"] = $a;
			
			$this->load->view("dashboard",$data);
		}
	}
	
	
	public function mgnt_nuwave_rvw($id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_ameridial/nuwave/mgnt_rvw.php";
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM signin where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,194) and is_assign_process(id,390) and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_amd_nuwave_feedback where id='$id') xx Left Join
				(Select id as sid, fname, lname, fusion_id, office_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid)";
			$data["nuwave"] = $this->Common_model->get_query_row_array($qSql);
			
			$data["nwid"]=$id;
			
		///////Edit Part///////	
			if($this->input->post('nwid'))
			{
				$nwid=$this->input->post('nwid');
				$curDateTime=CurrMySqlDate();
				$log=get_logs();
				
				$field_array = array(
					"agent_id" => $this->input->post('agent_id'),
					"tl_id" => $this->input->post('tl_id'),
					"call_date" => mmddyy2mysql($this->input->post('call_date')),
					"file_no" => $this->input->post('file_no'),
					"order_id" => $this->input->post('order_id'),
					"call_duration" => $this->input->post('call_duration'),
					"interaction" => $this->input->post('interaction'),
					"audit_type" => $this->input->post('audit_type'),
					"auditor_type" => $this->input->post('auditor_type'),
					"voc" => $this->input->post('voc'),
					"possible_score" => $this->input->post('possible_score'),
					"earned_score" => $this->input->post('earned_score'),
					"overall_score" => $this->input->post('overall_score'),
					"greeting_identification" => $this->input->post('greeting_identification'),
					"verified_customer" => $this->input->post('verified_customer'),
					"use_caller_CSR_name" => $this->input->post('use_caller_CSR_name'),
					"doesnot_interrupt_customer" => $this->input->post('doesnot_interrupt_customer'),
					"converses_clear_concise_mannaer" => $this->input->post('converses_clear_concise_mannaer'),
					"avoid_use_slang_jargon" => $this->input->post('avoid_use_slang_jargon'),
					"empathy_toward_customer" => $this->input->post('empathy_toward_customer'),
					"CSR_sound_helpful" => $this->input->post('CSR_sound_helpful'),
					"gain_customer_permission" => $this->input->post('gain_customer_permission'),
					"thanks_customer_holding" => $this->input->post('thanks_customer_holding'),
					"hold_time_appropiate" => $this->input->post('hold_time_appropiate'),
					"utilized_established_guidelines" => $this->input->post('utilized_established_guidelines'),
					"use_probing_question" => $this->input->post('use_probing_question'),
					"verbally_verfied_problem" => $this->input->post('verbally_verfied_problem'),
					"manage_customer_expectation" => $this->input->post('manage_customer_expectation'),
					"reason_for_troubleshooting" => $this->input->post('reason_for_troubleshooting'),
					"use_available_resources" => $this->input->post('use_available_resources'),
					"complete_customer_documentation" => $this->input->post('complete_customer_documentation'),
					"customer_comfortable_with_outcome" => $this->input->post('customer_comfortable_with_outcome'),
					"additional_needs_uncovered" => $this->input->post('additional_needs_uncovered'),
					"product_served_their_needs" => $this->input->post('product_served_their_needs'),
					"used_correct_closing" => $this->input->post('used_correct_closing'),
					"infractions" => $this->input->post('infractions'),
					"sub_infractions" => $this->input->post('sub_infractions'),
					"call_summary" => $this->input->post('call_summary'),
					"feedback" => $this->input->post('feedback')
				);
				$this->db->where('id', $nwid);
				$this->db->update('qa_amd_nuwave_feedback',$field_array);
				
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
				$this->db->where('id', $nwid);
				$this->db->update('qa_amd_nuwave_feedback',$field_array1);
			///////////	
				redirect('Qa_ameridial/nuwave');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}

///////////////////////////////////////////////////////////////////////////////////
/*---------------------------- NuWave (End) ------------------------------*/
///////////////////////////////////////////////////////////////////////////////////

//////////*----------------------------------------------------------------- HEALTHCARE -------------------------------------------------------------------------*//////////

///////////////////////////////////////////////////////////////////////////////////
/*-------------------------------- SABAL (Start) -------------------------------*/
///////////////////////////////////////////////////////////////////////////////////	

	public function sabal(){
		if(check_logged_in())
		{
			$current_user = get_user_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_ameridial/sabal/qa_feedback.php";
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM signin where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,133) and status=1 order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$from_date = $this->input->get('from_date');
			$to_date = $this->input->get('to_date');
			$agent_id = $this->input->get('agent_id');
			$file = $this->input->get('file');
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
			
			if($from_date !="" && $to_date!=="" )  $cond= " Where (date(audit_date) >= '$from_date' and date(audit_date) <= '$to_date' ) ";
			if($agent_id !="")	$cond .=" and agent_id='$agent_id'";
			if($file !="")	$cond .=" and file_no like '%$file%'";
			
			if(get_user_fusion_id()!='FMIN000011' || get_user_fusion_id()!='FUTA000007' || get_user_fusion_id()!='FUTA000012'){
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
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_name
				from qa_amd_sabal_feedback $cond) xx Left Join
				(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";
			$data["sabal_data"] = $this->Common_model->get_query_result_array($qSql);
			
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			$data["agent_id"] = $agent_id;
			$data["file"] = $file;
			
			$this->load->view("dashboard",$data);
		}
	}

	
	public function add_sabal_feedback(){
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_ameridial/sabal/add_feedback.php";
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,133) and status=1  order by name";
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
					"call_date" => mmddyy2mysql($this->input->post('call_date')),
					"file_no" => $this->input->post('file_no'),
					"call_duration" => $this->input->post('call_duration'),
					"audit_type" => $this->input->post('audit_type'),
					"auditor_type" => $this->input->post('auditor_type'),
					"voc" => $this->input->post('voc'),
					"possible_score" => $this->input->post('possible_score'),
					"earned_score" => $this->input->post('earned_score'),
					"overall_score" => $this->input->post('overall_score'),
					"agentaskIndividualName" => $this->input->post('agentaskIndividualName'),
					"agentIntroduceHimHerself" => $this->input->post('agentIntroduceHimHerself'),
					"agentStateCustomerService" => $this->input->post('agentStateCustomerService'),
					"agentApologizePhoneCall" => $this->input->post('agentApologizePhoneCall'),
					"agentIndividualRXplan" => $this->input->post('agentIndividualRXplan'),
					"agentReadListedExample" => $this->input->post('agentReadListedExample'),
					"agentAskIndividualColorCard" => $this->input->post('agentAskIndividualColorCard'),
					"agentAskIndividualUpdate" => $this->input->post('agentAskIndividualUpdate'),
					"agentAskIndividualEffectiveDate" => $this->input->post('agentAskIndividualEffectiveDate'),
					"agentUseCorrectRebuttal" => $this->input->post('agentUseCorrectRebuttal'),
					"agentUseIndividualScript" => $this->input->post('agentUseIndividualScript'),
					"agentSaysHeShenotInterested" => $this->input->post('agentSaysHeShenotInterested'),
					"agentAbruptlyEndCall" => $this->input->post('agentAbruptlyEndCall'),
					"agentbecomeUrgumentative" => $this->input->post('agentbecomeUrgumentative'),
					"agentRecordIncirrectMedicare" => $this->input->post('agentRecordIncirrectMedicare'),
					"agentProvideFalseInformation" => $this->input->post('agentProvideFalseInformation'),
					"cmt1" => $this->input->post('cmt1'),
					"cmt2" => $this->input->post('cmt2'),
					"cmt3" => $this->input->post('cmt3'),
					"cmt4" => $this->input->post('cmt4'),
					"cmt5" => $this->input->post('cmt5'),
					"cmt6" => $this->input->post('cmt6'),
					"cmt7" => $this->input->post('cmt7'),
					"cmt8" => $this->input->post('cmt8'),
					"cmt9" => $this->input->post('cmt9'),
					"cmt10" => $this->input->post('cmt10'),
					"cmt11" => $this->input->post('cmt11'),
					"cmt12" => $this->input->post('cmt12'),
					"cmt13" => $this->input->post('cmt13'),
					"cmt14" => $this->input->post('cmt14'),
					"cmt15" => $this->input->post('cmt15'),
					"cmt16" => $this->input->post('cmt16'),
					"call_summary" => $this->input->post('call_summary'),
					"feedback" => $this->input->post('feedback'),
					"entry_date" => $curDateTime,
					"audit_start_time" => $this->input->post('audit_start_time')
				);
				$a = $this->amd_upload_files($_FILES['attach_file'], $path='./qa_files/qa_ameridial/sabal/');
				$field_array["attach_file"] = implode(',',$a);
				$rowid= data_inserter('qa_amd_sabal_feedback',$field_array); 
			/////////////	
				if(get_login_type()=="client"){
					$field_array1 = array("client_entryby" => $current_user);
				}else{
					$field_array1 = array("entry_by" => $current_user);
				}
				$this->db->where('id', $rowid);
				$this->db->update('qa_amd_sabal_feedback',$field_array1);
			///////////
				redirect('Qa_ameridial/sabal');
			}
			$data["array"] = $a;
			$this->load->view("dashboard",$data);
		}
	}
	
	
	public function mgnt_sabal_rvw($id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_ameridial/sabal/mgnt_rvw.php";
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM signin where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,133) and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
				from qa_amd_sabal_feedback where id='$id') xx Left Join
				(Select office_id,id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid)";
			$data["sabal_data"] = $this->Common_model->get_query_row_array($qSql);
			
			$data["sabalid"]=$id;
			
			if($this->input->post('sabalid'))
			{
				$sabalid=$this->input->post('sabalid');
				$curDateTime=CurrMySqlDate();
				$log=get_logs();
				
				$field_array = array(
					"agent_id" => $this->input->post('agent_id'),
					"tl_id" => $this->input->post('tl_id'),
					"call_date" => mmddyy2mysql($this->input->post('call_date')),
					"file_no" => $this->input->post('file_no'),
					"call_duration" => $this->input->post('call_duration'),
					"audit_type" => $this->input->post('audit_type'),
					"auditor_type" => $this->input->post('auditor_type'),
					"voc" => $this->input->post('voc'),
					"possible_score" => $this->input->post('possible_score'),
					"earned_score" => $this->input->post('earned_score'),
					"overall_score" => $this->input->post('overall_score'),
					"agentaskIndividualName" => $this->input->post('agentaskIndividualName'),
					"agentIntroduceHimHerself" => $this->input->post('agentIntroduceHimHerself'),
					"agentStateCustomerService" => $this->input->post('agentStateCustomerService'),
					"agentApologizePhoneCall" => $this->input->post('agentApologizePhoneCall'),
					"agentIndividualRXplan" => $this->input->post('agentIndividualRXplan'),
					"agentReadListedExample" => $this->input->post('agentReadListedExample'),
					"agentAskIndividualColorCard" => $this->input->post('agentAskIndividualColorCard'),
					"agentAskIndividualUpdate" => $this->input->post('agentAskIndividualUpdate'),
					"agentAskIndividualEffectiveDate" => $this->input->post('agentAskIndividualEffectiveDate'),
					"agentUseCorrectRebuttal" => $this->input->post('agentUseCorrectRebuttal'),
					"agentUseIndividualScript" => $this->input->post('agentUseIndividualScript'),
					"agentSaysHeShenotInterested" => $this->input->post('agentSaysHeShenotInterested'),
					"agentAbruptlyEndCall" => $this->input->post('agentAbruptlyEndCall'),
					"agentbecomeUrgumentative" => $this->input->post('agentbecomeUrgumentative'),
					"agentRecordIncirrectMedicare" => $this->input->post('agentRecordIncirrectMedicare'),
					"agentProvideFalseInformation" => $this->input->post('agentProvideFalseInformation'),
					"cmt1" => $this->input->post('cmt1'),
					"cmt2" => $this->input->post('cmt2'),
					"cmt3" => $this->input->post('cmt3'),
					"cmt4" => $this->input->post('cmt4'),
					"cmt5" => $this->input->post('cmt5'),
					"cmt6" => $this->input->post('cmt6'),
					"cmt7" => $this->input->post('cmt7'),
					"cmt8" => $this->input->post('cmt8'),
					"cmt9" => $this->input->post('cmt9'),
					"cmt10" => $this->input->post('cmt10'),
					"cmt11" => $this->input->post('cmt11'),
					"cmt12" => $this->input->post('cmt12'),
					"cmt13" => $this->input->post('cmt13'),
					"cmt14" => $this->input->post('cmt14'),
					"cmt15" => $this->input->post('cmt15'),
					"cmt16" => $this->input->post('cmt16'),
					"call_summary" => $this->input->post('call_summary'),
					"feedback" => $this->input->post('feedback')
				);
				$this->db->where('id', $sabalid);
				$this->db->update('qa_amd_sabal_feedback',$field_array);
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
				$this->db->where('id', $sabalid);
				$this->db->update('qa_amd_sabal_feedback',$field_array1);	
			///////////
				redirect('Qa_ameridial/sabal');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}
///////////////////////////////////////////////////////////////////////////////////
/*------------------------------- SABAL (End) ---------------------------------*/
///////////////////////////////////////////////////////////////////////////////////


///////////////////////////////////////////////////////////////////////////////////
/*-------------------------------- CURATIVE (Start) -------------------------------*/
///////////////////////////////////////////////////////////////////////////////////	

	public function curative(){
		if(check_logged_in())
		{
			$current_user = get_user_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_ameridial/curative/qa_feedback.php";
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM signin where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client(id,133) and is_assign_process(id,302) and status=1 order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$from_date = $this->input->get('from_date');
			$to_date = $this->input->get('to_date');
			$agent_id = $this->input->get('agent_id');
			$file = $this->input->get('file');
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
			
			if($from_date !="" && $to_date!=="" )  $cond= " Where (date(audit_date) >= '$from_date' and date(audit_date) <= '$to_date' ) ";
			if($agent_id !="")	$cond .=" and agent_id='$agent_id'";
			if($file !="")	$cond .=" and file_no like '%$file%'";
			
			if(get_user_fusion_id()!='FMIN000011' || get_user_fusion_id()!='FUTA000007' || get_user_fusion_id()!='FUTA000012'){
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
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_name
				from qa_amd_curative_feedback $cond) xx Left Join
				(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";
			$data["curative_data"] = $this->Common_model->get_query_result_array($qSql);
			
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			$data["agent_id"] = $agent_id;
			$data["file"] = $file;
			
			$this->load->view("dashboard",$data);
		}
	}

	
	public function add_curative_feedback(){
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_ameridial/curative/add_feedback.php";
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client(id,133) and is_assign_process(id,302) and status=1  order by name";
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
					"call_date" => mmddyy2mysql($this->input->post('call_date')),
					"file_no" => $this->input->post('file_no'),
					"call_duration" => $this->input->post('call_duration'),
					"audit_type" => $this->input->post('audit_type'),
					"auditor_type" => $this->input->post('auditor_type'),
					"voc" => $this->input->post('voc'),
					"possible_score" => $this->input->post('possible_score'),
					"earned_score" => $this->input->post('earned_score'),
					"overall_score" => $this->input->post('overall_score'),
					"greetCustomerProperly" => $this->input->post('greetCustomerProperly'),
					"useRespectfulTone" => $this->input->post('useRespectfulTone'),
					"answerInTimelyManner" => $this->input->post('answerInTimelyManner'),
					"verifyCustomerInformation" => $this->input->post('verifyCustomerInformation'),
					"verifyPatientPHI" => $this->input->post('verifyPatientPHI'),
					"agentProvideAccurateResult" => $this->input->post('agentProvideAccurateResult'),
					"accidentalIncorrectInformation" => $this->input->post('accidentalIncorrectInformation'),
					"agentEscalateTier2Correctly" => $this->input->post('agentEscalateTier2Correctly'),
					"agentRespectPatientPrivacy" => $this->input->post('agentRespectPatientPrivacy'),
					"agentSpeakConcisely" => $this->input->post('agentSpeakConcisely'),
					"agentAvoidInternalTerms" => $this->input->post('agentAvoidInternalTerms'),
					"agentDemonstrateEmpathyUse" => $this->input->post('agentDemonstrateEmpathyUse'),
					"agentUsePleaseThankyou" => $this->input->post('agentUsePleaseThankyou'),
					"agentMinimizeExtendedSilence" => $this->input->post('agentMinimizeExtendedSilence'),
					"agentSpeakWarmthVoice" => $this->input->post('agentSpeakWarmthVoice'),
					"agentDemonstrateCallerPatient" => $this->input->post('agentDemonstrateCallerPatient'),
					"repCompletlyCallDocument" => $this->input->post('repCompletlyCallDocument'),
					"repConfirmCompleteClosing" => $this->input->post('repConfirmCompleteClosing'),
					"thankCallerBeforeClosing" => $this->input->post('thankCallerBeforeClosing'),
					"cmt1" => $this->input->post('cmt1'),
					"cmt2" => $this->input->post('cmt2'),
					"cmt3" => $this->input->post('cmt3'),
					"cmt4" => $this->input->post('cmt4'),
					"cmt5" => $this->input->post('cmt5'),
					"cmt6" => $this->input->post('cmt6'),
					"cmt7" => $this->input->post('cmt7'),
					"cmt8" => $this->input->post('cmt8'),
					"cmt9" => $this->input->post('cmt9'),
					"cmt10" => $this->input->post('cmt10'),
					"cmt11" => $this->input->post('cmt11'),
					"cmt12" => $this->input->post('cmt12'),
					"cmt13" => $this->input->post('cmt13'),
					"cmt14" => $this->input->post('cmt14'),
					"cmt15" => $this->input->post('cmt15'),
					"cmt16" => $this->input->post('cmt16'),
					"cmt17" => $this->input->post('cmt17'),
					"cmt18" => $this->input->post('cmt18'),
					"cmt19" => $this->input->post('cmt19'),
					"agentEnsureEmailAddress" => $this->input->post('agentEnsureEmailAddress'),
					"agentUseCorrectSentence" => $this->input->post('agentUseCorrectSentence'),
					"callerGaveAgentKUDOS" => $this->input->post('callerGaveAgentKUDOS'),
					"repDoEverythingPossible" => $this->input->post('repDoEverythingPossible'),
					"repAncipateCallerNeed" => $this->input->post('repAncipateCallerNeed'),
					"cmt20" => $this->input->post('cmt20'),
					"cmt21" => $this->input->post('cmt21'),
					"cmt22" => $this->input->post('cmt22'),
					"cmt23" => $this->input->post('cmt23'),
					"cmt24" => $this->input->post('cmt24'),
					"call_summary" => $this->input->post('call_summary'),
					"feedback" => $this->input->post('feedback'),
					"entry_date" => $curDateTime,
					"audit_start_time" => $this->input->post('audit_start_time')
				);
				$a = $this->amd_upload_files($_FILES['attach_file'], $path='./qa_files/qa_ameridial/curative/');
				$field_array["attach_file"] = implode(',',$a);
				$rowid= data_inserter('qa_amd_curative_feedback',$field_array); 
			/////////////	
				if(get_login_type()=="client"){
					$field_array1 = array("client_entryby" => $current_user);
				}else{
					$field_array1 = array("entry_by" => $current_user);
				}
				$this->db->where('id', $rowid);
				$this->db->update('qa_amd_curative_feedback',$field_array1);
			///////////
				redirect('Qa_ameridial/curative');
			}
			$data["array"] = $a;
			$this->load->view("dashboard",$data);
		}
	}
	
	
	public function mgnt_curative_rvw($id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_ameridial/curative/mgnt_rvw.php";
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM signin where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client(id,133) and is_assign_process(id,302) and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
				from qa_amd_curative_feedback where id='$id') xx Left Join
				(Select office_id,id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid)";
			$data["curative_data"] = $this->Common_model->get_query_row_array($qSql);
			
			$data["curid"]=$id;
			
			if($this->input->post('curid'))
			{
				$curid=$this->input->post('curid');
				$curDateTime=CurrMySqlDate();
				$log=get_logs();
				
				$field_array = array(
					"agent_id" => $this->input->post('agent_id'),
					"tl_id" => $this->input->post('tl_id'),
					"call_date" => mmddyy2mysql($this->input->post('call_date')),
					"file_no" => $this->input->post('file_no'),
					"call_duration" => $this->input->post('call_duration'),
					"audit_type" => $this->input->post('audit_type'),
					"auditor_type" => $this->input->post('auditor_type'),
					"voc" => $this->input->post('voc'),
					"possible_score" => $this->input->post('possible_score'),
					"earned_score" => $this->input->post('earned_score'),
					"overall_score" => $this->input->post('overall_score'),
					"greetCustomerProperly" => $this->input->post('greetCustomerProperly'),
					"useRespectfulTone" => $this->input->post('useRespectfulTone'),
					"answerInTimelyManner" => $this->input->post('answerInTimelyManner'),
					"verifyCustomerInformation" => $this->input->post('verifyCustomerInformation'),
					"verifyPatientPHI" => $this->input->post('verifyPatientPHI'),
					"agentProvideAccurateResult" => $this->input->post('agentProvideAccurateResult'),
					"accidentalIncorrectInformation" => $this->input->post('accidentalIncorrectInformation'),
					"agentEscalateTier2Correctly" => $this->input->post('agentEscalateTier2Correctly'),
					"agentRespectPatientPrivacy" => $this->input->post('agentRespectPatientPrivacy'),
					"agentSpeakConcisely" => $this->input->post('agentSpeakConcisely'),
					"agentAvoidInternalTerms" => $this->input->post('agentAvoidInternalTerms'),
					"agentDemonstrateEmpathyUse" => $this->input->post('agentDemonstrateEmpathyUse'),
					"agentUsePleaseThankyou" => $this->input->post('agentUsePleaseThankyou'),
					"agentMinimizeExtendedSilence" => $this->input->post('agentMinimizeExtendedSilence'),
					"agentSpeakWarmthVoice" => $this->input->post('agentSpeakWarmthVoice'),
					"agentDemonstrateCallerPatient" => $this->input->post('agentDemonstrateCallerPatient'),
					"repCompletlyCallDocument" => $this->input->post('repCompletlyCallDocument'),
					"repConfirmCompleteClosing" => $this->input->post('repConfirmCompleteClosing'),
					"thankCallerBeforeClosing" => $this->input->post('thankCallerBeforeClosing'),
					"cmt1" => $this->input->post('cmt1'),
					"cmt2" => $this->input->post('cmt2'),
					"cmt3" => $this->input->post('cmt3'),
					"cmt4" => $this->input->post('cmt4'),
					"cmt5" => $this->input->post('cmt5'),
					"cmt6" => $this->input->post('cmt6'),
					"cmt7" => $this->input->post('cmt7'),
					"cmt8" => $this->input->post('cmt8'),
					"cmt9" => $this->input->post('cmt9'),
					"cmt10" => $this->input->post('cmt10'),
					"cmt11" => $this->input->post('cmt11'),
					"cmt12" => $this->input->post('cmt12'),
					"cmt13" => $this->input->post('cmt13'),
					"cmt14" => $this->input->post('cmt14'),
					"cmt15" => $this->input->post('cmt15'),
					"cmt16" => $this->input->post('cmt16'),
					"cmt17" => $this->input->post('cmt17'),
					"cmt18" => $this->input->post('cmt18'),
					"cmt19" => $this->input->post('cmt19'),
					"agentEnsureEmailAddress" => $this->input->post('agentEnsureEmailAddress'),
					"agentUseCorrectSentence" => $this->input->post('agentUseCorrectSentence'),
					"callerGaveAgentKUDOS" => $this->input->post('callerGaveAgentKUDOS'),
					"repDoEverythingPossible" => $this->input->post('repDoEverythingPossible'),
					"repAncipateCallerNeed" => $this->input->post('repAncipateCallerNeed'),
					"cmt20" => $this->input->post('cmt20'),
					"cmt21" => $this->input->post('cmt21'),
					"cmt22" => $this->input->post('cmt22'),
					"cmt23" => $this->input->post('cmt23'),
					"cmt24" => $this->input->post('cmt24'),
					"call_summary" => $this->input->post('call_summary'),
					"feedback" => $this->input->post('feedback')
				);
				$this->db->where('id', $curid);
				$this->db->update('qa_amd_curative_feedback',$field_array);
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
				$this->db->where('id', $curid);
				$this->db->update('qa_amd_curative_feedback',$field_array1);	
			///////////
				redirect('Qa_ameridial/curative');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}
///////////////////////////////////////////////////////////////////////////////////
/*------------------------------- CURATIVE (End) --------------------------------*/
///////////////////////////////////////////////////////////////////////////////////

///////////////////////////////////////////////////////////////////////////////////
/*----------------------------- Episource (Start) -------------------------------*/
///////////////////////////////////////////////////////////////////////////////////
	public function episource(){
		if(check_logged_in())
		{
			$current_user = get_user_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_ameridial/episource/qa_amd_episource_feedback.php";
						
			$from_date = $this->input->get('from_date');
			$to_date = $this->input->get('to_date');
			$cond='';
			
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
			if($from_date !="" && $to_date!=="" )  $cond= " Where (audit_date >= '$from_date' and audit_date <= '$to_date' ) ";
			
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
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_amd_episource_feedback $cond) xx Left Join
				(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";
			$data["hra_new_data"] = $this->Common_model->get_query_result_array($qSql);
		///////////////////	
			
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			
			$this->load->view("dashboard",$data);
		}
	}

	public function add_amd_episource_new(){
	
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_ameridial/episource/add_amd_episource_new.php";
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,133) and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
			$curDateTime=CurrMySqlDate();
			$a = array(); 
						
			$field_array['agent_id']=!empty($_POST['data']['agent_id'])?$_POST['data']['agent_id']:"";
			if($field_array['agent_id']){
				// echo var_dump(mmddyy2mysql($this->input->post('call_date')));
				// die;
				$field_array=$this->input->post('data');
				$field_array['audit_date']=CurrDate();
				$field_array['entry_by']=$current_user;
				$field_array['call_date']=mmddyy2mysql($this->input->post('call_date'));
				$field_array['entry_date']=$curDateTime;
				$a = $this->amd_upload_files($_FILES['attach_file'],$path='./qa_files/qa_ameridial/episource/');
				$field_array["attach_file"] = implode(',',$a);
				$rowid= data_inserter('qa_amd_episource_feedback',$field_array);
				redirect('Qa_ameridial/episource');
			}
			$data["array"] = $a;
			
			$this->load->view("dashboard",$data);
		}
	}

	public function mgnt_amd_episource_rvw($id){
		
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_ameridial/episource/mgnt_amd_episource_rvw.php";
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,133) and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_amd_episource_feedback where id='$id') xx Left Join
				(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid)";
			$data["hra_new"] = $this->Common_model->get_query_row_array($qSql);
			
			$data["pnid"]=$id;
			
		///////Edit Part///////	
			if($this->input->post('pnid'))
			{
				$pnid=$this->input->post('pnid');
				$curDateTime=CurrMySqlDate();
				$log=get_logs();
				
				$field_array=$this->input->post('data');
				$field_array['call_date']=mmddyy2mysql($this->input->post('call_date'));
				$this->db->where('id', $pnid);
				$this->db->update('qa_amd_episource_feedback',$field_array);
				
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
				$this->db->update('qa_amd_episource_feedback',$field_array1);
			///////////	
				redirect('Qa_ameridial/episource');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}
///////////////////////////////////////////////////////////////////////////////////
/*----------------------------- Episource (End) -------------------------------*/
///////////////////////////////////////////////////////////////////////////////////


///////////////////////////////////////////////////////////////////////////////////
/*----------------------------- Magnilife (Start) -------------------------------*/
///////////////////////////////////////////////////////////////////////////////////
	public function magnilife(){
		if(check_logged_in())
		{
			$current_user = get_user_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_ameridial/magnilife/qa_amd_magnilife_feedback.php";
						
			$from_date = $this->input->get('from_date');
			$to_date = $this->input->get('to_date');
			$cond='';
			
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
			if($from_date !="" && $to_date!=="" )  $cond= " Where (audit_date >= '$from_date' and audit_date <= '$to_date' ) ";
			
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
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_amd_magnilife_feedback $cond) xx Left Join
				(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";
			$data["msb_new_data"] = $this->Common_model->get_query_result_array($qSql);
		///////////////////	
			
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			
			$this->load->view("dashboard",$data);
		}
	}

	public function add_amd_magnilife($stratAuditTime){
	
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_ameridial/magnilife/add_amd_magnilife.php";
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,195) and is_assign_process(id,391) and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			$data["stratAuditTime"]=$stratAuditTime;
			$curDateTime=CurrMySqlDate();
			$a = array(); 
						
			$field_array['agent_id']=!empty($_POST['data']['agent_id'])?$_POST['data']['agent_id']:"";
			if($field_array['agent_id']){
				// echo var_dump(mmddyy2mysql($this->input->post('call_date')));
				// die;
				$field_array=$this->input->post('data');
				$field_array['audit_date']=CurrDate();
				$field_array['entry_by']=$current_user;
				$field_array['call_date']=mmddyy2mysql($this->input->post('call_date'));
				$field_array['entry_date']=$curDateTime;
				$a = $this->amd_upload_files($_FILES['attach_file'],$path='./qa_files/qa_ameridial/magnilife/');
				$field_array["attach_file"] = implode(',',$a);
				$rowid= data_inserter('qa_amd_magnilife_feedback',$field_array);
				redirect('Qa_ameridial/magnilife');
			}
			$data["array"] = $a;
			
			$this->load->view("dashboard",$data);
		}
	}

	public function mgnt_amd_magnilife_rvw($id){
		
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_ameridial/magnilife/mgnt_amd_magnilife_rvw.php";
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,195) and is_assign_process(id,391) and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_amd_magnilife_feedback where id='$id') xx Left Join
				(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid)";
			$data["msb_new"] = $this->Common_model->get_query_row_array($qSql);
			
			$data["pnid"]=$id;
			
		///////Edit Part///////	
			if($this->input->post('pnid'))
			{
				$pnid=$this->input->post('pnid');
				$curDateTime=CurrMySqlDate();
				$log=get_logs();
				
				$field_array=$this->input->post('data');
				$this->db->where('id', $pnid);
				$this->db->update('qa_amd_magnilife_feedback',$field_array);
				
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
				$this->db->update('qa_amd_magnilife_feedback',$field_array1);
			///////////	
				redirect('Qa_ameridial/magnilife');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}
///////////////////////////////////////////////////////////////////////////////////
/*----------------------------- Magnilife (End) -------------------------------*/
///////////////////////////////////////////////////////////////////////////////////


///////////////////////////////////////////////////////////////////////////////////
/*----------------------------- Blains (Start) -------------------------------*/
///////////////////////////////////////////////////////////////////////////////////


public function process($page="",$parm="",$formparam=""){

		if ($parm=="add") {
			$this->add_process($page,$formparam);
		}elseif ($parm=="mgnt_rvw") {
			$this->mgnt_process_rvw($page,$formparam);
		}elseif($parm=="agent"){
			$this->agent_process_feedback($page);
		}elseif($parm=="agnt_feedback"){
			$this->agent_process_rvw($page,$formparam);
		}else{
			$this->$page();
		}

	}

public function blains(){
		if(check_logged_in())
		{
			$current_user = get_user_id();
			$page="blains";
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_ameridial/".$page."/qa_amd_".$page."_feedback.php";
			$data["page"]=$page;
			$from_date = $this->input->get('from_date');
			$to_date = $this->input->get('to_date');
			$agent_id = $this->input->get('agent_id');
			$cond='';
			
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

			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,134) and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
		////////////////////////	
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
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_amd_".$page."_feedback $cond) xx Left Join
				(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";
			$data[$page."_new_data"] = $this->Common_model->get_query_result_array($qSql);
		///////////////////	
			
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			$data["agent_id"] = $agent_id;
			
			$this->load->view("dashboard",$data);
		}
	}


//////////////////////// Add Blains //////////////////////////////////////////////

	public function add_process($page="",$stratAuditTime=""){
	
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_ameridial/".$page."/add_amd_".$page.".php";
			// $data["content_js"] = "qa_".$page."_js.php";
			$data["page"]=$page;

			if($page=="trapollo"){
				
				$data["scoreCard"]=$this->scoreCard();
				$data["scoreVal"]=$this->scoreVal();
				$data["columname"]=$this->tropollo_columnname();
				$data["scoreParametername"]=$this->parameter_tropollo_scrorecard_details();
			}

			if($page=='delta'){
				$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client(id,133) and is_assign_process(id,268) and status=1  order by name";
			}else if($page=='trapollo'){
				$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client(id,133) and status=1  order by name";
			}else if($page=='follet'){
				$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and (is_assign_client (id,184) or is_assign_client (id,185)) and (is_assign_process (id,378) or is_assign_process (id,379)) and status=1  order by name";
			}else{
				$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6  and is_assign_client (id,134) and status=1  order by name";
			}
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			$data["stratAuditTime"]=$stratAuditTime;
			$curDateTime=CurrMySqlDate();
			$a = array();

			
			$field_array['agent_id']=!empty($_POST['data']['agent_id'])?$_POST['data']['agent_id']:"";
			if($field_array['agent_id']){
				$field_array=$this->input->post('data');
				$field_array['audit_date']=CurrDate();
				$field_array['entry_by']=$current_user;
				$field_array['call_date']=mmddyy2mysql($this->input->post('call_date'));
				$field_array['entry_date']=$curDateTime;
				$a = $this->amd_upload_files($_FILES['attach_file'],$path='./qa_files/qa_ameridial/'.$page);
				$field_array["attach_file"] = implode(',',$a);
				$rowid= data_inserter('qa_amd_'.$page.'_feedback',$field_array);
				redirect('Qa_ameridial/'.$page);
			}
			$data["array"] = $a;
			
			$this->load->view("dashboard",$data);
		}
	}

/////////////////////////////// MGNT Blains ///////////////////////////////////////

public function mgnt_process_rvw($page,$id){
		
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_ameridial/".$page."/mgnt_amd_".$page."_rvw.php";
			// $data["content_js"] = "qa_".$page."_js.php";
			$data["page"]=$page;

			if($page=="trapollo"){
				
				$data["scoreCard"]=$this->scoreCard();
				$data["scoreVal"]=$this->scoreVal();
				$data["columname"]=$this->tropollo_columnname();
				$data["scoreParametername"]=$this->parameter_tropollo_scrorecard_details();
			}
			
			if($page=='delta'){
				$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client(id,133) and is_assign_process(id,268) and status=1  order by name";
			}else if($page=='trapollo'){
				$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client(id,133) and status=1  order by name";
			}else if($page=='follet'){
				$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and (is_assign_client (id,184) or is_assign_client (id,185)) and (is_assign_process (id,378) or is_assign_process (id,379)) and status=1  order by name";
			}else{
				$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6  and is_assign_client (id,133) and status=1  order by name";
			}
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_amd_".$page."_feedback where id='$id') xx Left Join
				(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid)";
			$data[$page."_new"] = $this->Common_model->get_query_row_array($qSql);
			
			$data["pnid"]=$id;
			
		///////Edit Part///////	
			if($this->input->post('pnid'))
			{
				$pnid=$this->input->post('pnid');
				$curDateTime=CurrMySqlDate();
				$log=get_logs();
				
				$field_array=$this->input->post('data');
				$this->db->where('id', $pnid);
				$this->db->update('qa_amd_'.$page.'_feedback',$field_array);
				
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
				$this->db->update('qa_amd_'.$page.'_feedback',$field_array1);
			///////////	
				redirect('Qa_ameridial/'.$page);
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}

///////////////////////////////////////////////////////////////////////////////////
/*----------------------------- Blains (End) -------------------------------*/
///////////////////////////////////////////////////////////////////////////////////



///////////////////////////////////////////////////////////////////////////////////
///////////////////////////// Pajama (Start) /////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////

public function pajamagram(){
		if(check_logged_in())
		{
			$current_user = get_user_id();
			$page="pajamagram";
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_ameridial/".$page."/qa_amd_".$page."_feedback.php";
			$data["page"]=$page;
			$from_date = $this->input->get('from_date');
			$to_date = $this->input->get('to_date');
			$agent_id = $this->input->get('agent_id');
			$cond='';
			
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

			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,134) and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
		////////////////////////	
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
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_amd_".$page."_feedback $cond) xx Left Join
				(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";
			$data[$page."_new_data"] = $this->Common_model->get_query_result_array($qSql);
		///////////////////	
			
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			$data["agent_id"] = $agent_id;
			
			$this->load->view("dashboard",$data);
		}
	}

///////////////////////////////////////////////////////////////////////////////////
///////////////////////////// Pajama (End) /////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////

///////////////////////////////////////////////////////////////////////////////////
///////////////////////////// Delta (Start) /////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////

public function delta(){
		if(check_logged_in())
		{
			$current_user = get_user_id();
			$page="delta";
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_ameridial/".$page."/qa_amd_".$page."_feedback.php";
			$data["page"]=$page;
			$from_date = $this->input->get('from_date');
			$to_date = $this->input->get('to_date');
			$agent_id = $this->input->get('agent_id');
			$cond='';
			
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

			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,133) and is_assign_process (id,268) and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
		////////////////////////	
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
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_amd_".$page."_feedback $cond) xx Left Join
				(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";
			$data[$page."_new_data"] = $this->Common_model->get_query_result_array($qSql);
		///////////////////	
			
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			$data["agent_id"] = $agent_id;
			
			$this->load->view("dashboard",$data);
		}
	}


public function scoreCard(){
    	return $arrayName = array('Effective','Unacceptable','N/A');
    }

public function scoreVal(){
    	return $arrayName = array("val0"=>"0","val1"=>"1","val1p5"=>"1.5","val2"=>"2","val3"=>"3","val4"=>"4","val5"=>"5","val6"=>"6","val8"=>"8","val10"=>"10","val15"=>"15");
    }

public function tropollo_columnname(){
    	return array("promply","goodTimeTalk","callRecord","priorReaching","memberCorrectly","availabilityBox","availabilityTape","callerIns","confirmAddress","dateSpecified","handledEffectively","leastOnce","pleaseThankYou","silencesCall","agentSpeak","agentSpeakClearly","repReapeat","memberQuestions","anythingElse","memberCall","TMCfollowing","ticketNote","promisedTime","custEmpathy","repMember","callPromised","agentConfirmAdd","properGreeting","agentAdviceRecorded","agentDocument","callRepPromised");
    }

public function parameter_tropollo_scrorecard_details(){
    	return array("1.1 Did the rep greet the caller promptly and properly?","1.2 Did the rep ask if it is a good time to talk?","1.3 Did the rep advise that the call is recorded?","2.1 Did the rep try all phone numbers on file prior to reaching back out to the customer?","2.2 Did the rep verify the member correctly?","2.3 Did the agent correctly check availability of box?","2.4 Did the rep correctly check availability of tape?","2.5 Did the rep refer the caller to the instructions in the box? ","2.6 Did the rep confirm the address?","2.7 Was the correct call tag initiated and pick up by date specified?","3.1 Did the agent reassure the caller that everything would be handled effectively?","3.3 Did the agent address the member by name at least once?","3.4 Did the agent use 'please' and 'thank you' throughout the call?","3.5 Did the agent minimize extended silences throughout the call?","3.6 Did the agent speak with sincere warmth in his/her voice? (empathy)","3.7 Did the agent speak clearly?","4.1 Did the rep repeat or reiterate the instructions so that they are clear?","4.2 Did the rep ask if the member had any questions or was clear on the process?","4.3 Did the rep ask if there was anything else we could help with? ","4.4 Did the rep collect a good call back number?","4.5 Did the rep leave complete, detailed notes in documentation in TMC following the 5 'w s?'","4.1 Did the rep have all information updated correctly in the ticket note?","4.2 If a callback was promised, was this done on time?","4.3 Did the rep treat the customer with both empathy and respect and behave professionally?","4.4 Did the rep call the correct member?","4.5 Did the rep initiate the call tag as promised?","4.6 Did the agent confirm the address?","4.7 Did the agent use the proper greeting? ","4.8 Did the agent advise that the call was recorded?","4.9 Did the agent document using the 4 'w s?'","4.10 Did the rep initiate the call tag as promised?");
    }

    public function manualColumnProcess($column_val,$comment_val){
    	
			 	$cnt=count($column_val);
				 	$manualColumn="";
			 	if($cnt!=0){
				 	for($i=0;$i<$cnt;$i++){
				 					 		
				 			$manualColumn.='`'.$column_val[$i].'`  varchar(20) NOT NULL COMMENT "'.$comment_val[$i].'",';
				 		
				 	}

				 	for($j=1;$j<=$cnt;$j++){
				 		
				 			$manualColumn.='`cmt'.$j.'`  TEXT NULL COMMENT "Comments '.$j.'",';
				 		
				 	}
			 }

			 return $manualColumn;
    }

///////////////////////// Trapollo start //////////////////////////////////

	public function trapollo(){
		if(check_logged_in())
		{
			$current_user = get_user_id();
			$page="trapollo";
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_ameridial/".$page."/qa_amd_".$page."_feedback.php";
			$data["page"]=$page;
			$from_date = $this->input->get('from_date');
			$to_date = $this->input->get('to_date');
			$agent_id = $this->input->get('agent_id');
			$cond='';
			
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

			$column_val=$this->tropollo_columnname();
			$comment_val=$this->parameter_tropollo_scrorecard_details();

			 $manualColumn=$this->manualColumnProcess($column_val,$comment_val);
			 $createdTableorNot=$this->CreateTable_model->createTable($page,$manualColumn);

			 if($createdTableorNot){

					$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,133) and status=1  order by name";
					$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
					
				////////////////////////	
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
						(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_amd_".$page."_feedback $cond) xx Left Join
						(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";
					$data[$page."_new_data"] = $this->Common_model->get_query_result_array($qSql);
				///////////////////	
					
					$data["from_date"] = $from_date;
					$data["to_date"] = $to_date;
					$data["agent_id"] = $agent_id;
					
					$this->load->view("dashboard",$data);

			}else{
				echo "table not created";
			}
		}
	}

//////////////////////// Trapollo end ////////////////////////////////////

////////////// Delta Dental (IOWA) ///////////////////
	public function delta_dental_iowa(){
		if(check_logged_in())
		{
			$current_user = get_user_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_ameridial/delta/dd_iowa_feedback.php";
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client(id,133) and is_assign_process(id,262) and status=1  order by name";
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
			
			if($from_date !="" && $to_date!=="" )  $cond= " Where (date(audit_date) >= '$from_date' and date(audit_date) <= '$to_date' ) ";
			if($agent_id !="")	$cond .=" and agent_id='$agent_id'";
			
			if(get_user_fusion_id()!='FMIN000011' || get_user_fusion_id()!='FUTA000007' || get_user_fusion_id()!='FUTA000012'){
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
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
				from qa_amd_delta_iowa_feedback $cond) xx Left Join
				(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to, office_id from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";
			$data["iowa"] = $this->Common_model->get_query_result_array($qSql);
			
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			$data["agent_id"] = $agent_id;
			
			$this->load->view("dashboard",$data);
		}
	}
	
	
	public function add_edit_dd_iowa($iowa_id){
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_ameridial/delta/add_edit_dd_iowa.php";
			$data["iowa_id"]=$iowa_id;
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client(id,133) and is_assign_process(id,262) and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
			 $qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
				from qa_amd_delta_iowa_feedback where id='$iowa_id') xx Left Join
				(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to, office_id from signin) yy on (xx.agent_id=yy.sid) order by audit_date";
			$data["iowa"] = $this->Common_model->get_query_row_array($qSql);
			
			$curDateTime=CurrMySqlDate();
			$a = array(); 
			
			$field_array['agent_id']=!empty($_POST['data']['agent_id'])?$_POST['data']['agent_id']:"";
			if($field_array['agent_id']){
				if($iowa_id==0){
					
					$field_array=$this->input->post('data');
					$field_array['audit_date']=CurrDate();
					$field_array['entry_by']=$current_user;
					$field_array['call_date']=mmddyy2mysql($this->input->post('call_date'));
					$field_array['entry_date']=$curDateTime;
					$a = $this->amd_upload_files($_FILES['attach_file'],$path='./qa_files/qa_ameridial/delta/iowa/');
					$field_array["attach_file"] = implode(',',$a);
					$rowid= data_inserter('qa_amd_delta_iowa_feedback',$field_array);
					
				}else{
					
					$field_array=$this->input->post('data');
					$field_array['call_date']=mmddyy2mysql($this->input->post('call_date'));
					$this->db->where('id', $iowa_id);
					$this->db->update('qa_amd_delta_iowa_feedback',$field_array);
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
					$this->db->where('id', $iowa_id);
					$this->db->update('qa_amd_delta_iowa_feedback',$field_array1);
				}
				
				redirect('Qa_ameridial/delta_dental_iowa');
			}
			$data["array"] = $a;
			
			$this->load->view("dashboard",$data);
		}
	}

///////////////////////////////////////////////////////////////////////////////////
///////////////////////////// Delta (End) /////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////

///////////////////////////////////////////////////////////////////////////////////
///////////////////////////// Follet (Start) /////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////

public function follet(){
		if(check_logged_in())
		{
			$current_user = get_user_id();
			$page="follet";
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_ameridial/".$page."/qa_amd_".$page."_feedback.php";
			$data["page"]=$page;
			$from_date = $this->input->get('from_date');
			$to_date = $this->input->get('to_date');
			$agent_id = $this->input->get('agent_id');
			$cond='';
			
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

			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and (is_assign_client (id,184) or is_assign_client (id,185)) and (is_assign_process (id,378) or is_assign_process (id,379)) and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
		////////////////////////	
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
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_amd_".$page."_feedback $cond) xx Left Join
				(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";
			$data[$page."_new_data"] = $this->Common_model->get_query_result_array($qSql);
		///////////////////	
			
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			$data["agent_id"] = $agent_id;
			
			$this->load->view("dashboard",$data);
		}
	}

///////////////////////////////////////////////////////////////////////////////////
///////////////////////////// Follet (End) /////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////

///////////////////////////////////////////////////////////////////////////////////
///////////////////////////// Brightway Prescreen (Start) /////////////////////////
//////////////////////////////////////////////////////////////////////////////////

public function brightway_prescreen(){
		if(check_logged_in())
		{
			$current_user = get_user_id();
			$page="brightway_prescreen";
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_ameridial/".$page."/qa_amd_".$page."_feedback.php";
			$data["page"]=$page;
			$from_date = $this->input->get('from_date');
			$to_date = $this->input->get('to_date');
			$agent_id = $this->input->get('agent_id');
			$cond='';
			
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

			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,134) and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
		////////////////////////	
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
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_amd_".$page."_feedback $cond) xx Left Join
				(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";
			$data[$page."_new_data"] = $this->Common_model->get_query_result_array($qSql);
		///////////////////	
			
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			$data["agent_id"] = $agent_id;
			
			$this->load->view("dashboard",$data);
		}
	}

///////////////////////////////////////////////////////////////////////////////////
///////////////////////////// Brightway Prescreen (End) /////////////////////////
//////////////////////////////////////////////////////////////////////////////////

///////////////////////////////////////////////////////////////////////////////////
///////////////////////////// Brightway Evaluation (Start) /////////////////////////
//////////////////////////////////////////////////////////////////////////////////

public function brightway_evaluation(){
		if(check_logged_in())
		{
			$current_user = get_user_id();
			$page="brightway_evaluation";
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_ameridial/".$page."/qa_amd_".$page."_feedback.php";
			$data["page"]=$page;
			$from_date = $this->input->get('from_date');
			$to_date = $this->input->get('to_date');
			$agent_id = $this->input->get('agent_id');
			$cond='';
			
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

			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,134) and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
		////////////////////////	
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
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_amd_".$page."_feedback $cond) xx Left Join
				(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";
			$data[$page."_new_data"] = $this->Common_model->get_query_result_array($qSql);
		///////////////////	
			
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			$data["agent_id"] = $agent_id;
			
			$this->load->view("dashboard",$data);
		}
	}

///////////////////////////////////////////////////////////////////////////////////
///////////////////////////// Brightway Evaluation (End) /////////////////////////
//////////////////////////////////////////////////////////////////////////////////


/*----------------------------- REPORT PART ------------------------------*/
	public function qa_ameridial_report(){
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
			$data["content_template"] = "qa_ameridial/qa_ameridial_report.php";
			
			$data['location_list'] = $this->Common_model->get_office_location_list();
			
			$office_id = "";
			$from_date="";
			$to_date="";
			$process_id="";
			$action="";
			$dn_link="";
			$cond="";
			$cond1="";
			$cond2="";
			$cmp1='';
			
			$process_id = $this->input->get('process_id');
			
			$data["qa_ameridial_list"] = array();
			
			if($process_id!=""){
			
				if($this->input->get('show')=='Show')
				{
					$from_date = mmddyy2mysql($this->input->get('from_date'));
					$to_date = mmddyy2mysql($this->input->get('to_date'));
					$office_id = $this->input->get('office_id');
					$lob = $this->input->get('lob');
					
					
					if($from_date !="" && $to_date!=="" )  $cond= " Where (date(audit_date) >= '$from_date' and date(audit_date) <= '$to_date' ) ";
					
					if($office_id=="All") $cond .= "";
					else $cond .=" and office_id='$office_id'";
					
					if(get_user_fusion_id()!='FMIN000011' || get_user_fusion_id()!='FUTA000007' || get_user_fusion_id()!='FUTA000012'){
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

					$qSql="SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, (select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_amd_".$process_id."_feedback) xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, get_process_names(id) as campaign, DATEDIFF(CURDATE(), doj) as tenure, assigned_to from signin) yy on (xx.agent_id=yy.sid) $cond $cond1 order by audit_date";
					
					$fullAray = $this->Common_model->get_query_result_array($qSql);
					
					$data["qa_ameridial_list"] = $fullAray;

					if(!in_array($process_id,array('episource','magnilife','blains','pajamagram','delta','brightway_prescreen','brightway_evaluation'))){
					
						$this->create_qa_ameridial_CSV($fullAray,$process_id);	
						
					
					}else{

						$header=$process_id."Header";
						$header=$this->$header();
						
						$this->create_qa_amd_common_new_CSV($header,$fullAray,$process_id);
					
					}

					$dn_link = base_url()."qa_ameridial/download_qa_ameridial_CSV/".$process_id;
					
					
				}
			
			}
			
			$data['download_link']=$dn_link;
			$data["action"] = $action;	
			$data['from_date'] = $from_date;
			$data['to_date'] = $to_date;	
			$data['office_id']=$office_id;
			$data['process_id']=$process_id;
			//$data['lob']=$lob;
			
			$this->load->view('dashboard',$data);
		}
	}	
	 

	public function download_qa_ameridial_CSV($pid)
	{
		if($pid=='fortunebuilder'){
			$pname='Fortune Biulder';
		}else if($pid=='hoveround'){
			$pname='Hoveround';
		}else if($pid=='ncpssm'){
			$pname='NCPSSM';
		}else if($pid=='stc'){
			$pname='STC Scoresheet';
		}else if($pid=='touchfuse'){
			$pname='TouchFuse';
		}else if($pid=='tbn'){
			$pname='TBN Scoresheet';
		}else if($pid=='purity_free_bottle'){
			$pname='Purity Free Bottle';
		}else if($pid=='purity_catalog'){
			$pname='Purity Catalog';
		}else if($pid=='purity_care'){
			$pname='Purity Care';
		}else if($pid=='puritycare_new'){
			$pname='Purity Care New';
		}else if($pid=='jfmi'){
			$pname='JFMI';
		}else if($pid=='tpm'){
			$pname='TPM Scoresheet';
		}else if($pid=='patchology'){
			$pname='Patchology Agent Improvement';
		}else if($pid=='aspca'){
			$pname='ASPCA Scoresheet';
		}else if($pid=='ffai'){
			$pname='FilterFast Agent Improvement Scoresheet';
		}else if($pid=='lifi'){
			$pname='LIFI Improvement Scoresheet';
		}else if($pid=='heatsurge'){
			$pname='Heat Surge';
		}else if($pid=='stauers_sales'){
			$pname='Stauers Sales'; 
		}else if($pid=='operation_smile'){
			$pname='Operation Smile'; 
		}else if($pid=='5_11_tactical'){
			$pname='5-11 Tactical'; 
		}else if($pid=='jmmi'){
			$pname='JMMI'; 
		}else if($pid=='non_profit'){
			$pname='Non-Profit'; 
		}else if($pid=='revel'){
			$pname='REVEL'; 
		}else if($pid=='qpc'){
			$pname='QPC'; 
		}else if($pid=='ancient_nutrition'){
			$pname='Ancient Nutrition'; 
		}else if($pid=='powerfan'){
			$pname='Power Fan';
		}else if($pid=='nuwave'){
			$pname='NuWave';
		}else if($pid=='sabal'){
			$pname='SABAL'; 
		}else if($pid=='curative'){
			$pname='CURATIVE'; 
		}else if($pid=='episource'){
			$pname='EPISOURCE'; 
		}else if($pid=='magnilife'){
			$pname='MAGNILIFE'; 
		}else if($pid=='blains'){
			$pname='BLAINS'; 
		}else if($pid=='pajamagram'){
			$pname='PAJAMAGRAM'; 
		}else if($pid=='delta'){
			$pname='DELTA DENTAL [ILLINOIS]';
		}else if($pid=='delta_iowa'){
			$pname='DELTA DENTAL [IOWA]';
		}else if($pid=='brightway_prescreen'){
			$pname='Brightway Prescreen'; 
		}else if($pid=='brightway_evaluation'){
			$pname='Brightway Evaluation'; 
		}
		
		$currDate=date("Y-m-d");
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$newfile="QA Ameridial ".$pname." Audit List-'".$currDate."'.csv";
		
		header('Content-Disposition: attachment;  filename="'.$newfile.'"');
		readfile($filename);
	}

//////////// qa_amd_report_header///////////////////////////////////

	function episourceHeader(){

		return Array ("Auditor Name","Audit Date","Call Date","Fusion Id","Agent","L1 Super","Call Reference","Call Status","System","Site","Call Duration","File No.","Audit Type","Auditor Type","VOC", "Audit Start Date Time", "Audit End Date Time", "Interval(In Second)", "Overall Score","Did the agent provide the appropriate introduction? ","Did the agent provide a clear reason for the call?","Did the agent accurately respond to the member’s questions?","Did the agent allow the member to speak uninterrupted?","Did the agent avoid long periods of silence?","Did the agent ask to schedule the visit.","Did the agent verify the member?","Did the agent include all relevant details for the appointment?","Did the agent verify the full address?","Did the agent advise member to take note of all confirmation details?","Did the agent accurately document notes to NP?","Did the agent provide two response?","Did the agent advise of a reminder call?","Did the agent provide a fitting  closing for each call?","Did the agent status and document Salesforce correctly?","Did the agent advise the member he/she was on a recorded line?","Did the agent follow verification requirements for the script?","Did the agent maintain security of PHI and abide by HIPAA requirements?","Did the agent Inappropriately release the call prior ot providing an approptiate closing?","Did the agent perform any unauthorized action on a member profile","Did the agent knowingly providing false information?","Did the agent place blame?","Call Summary","Feedback","Entry By","Entry Date","Client entry by","Mgnt review by","Mgnt review note","Mgnt review date","Agent Feedback Acceptance","Agent review note","Agent review date","Client review by","Client review note","Client_rvw_date");

	}

	///////////////////////Magnilife/////////////////////////////////////

	function magnilifeHeader(){
		return Array ("Auditor Name","Audit Date","Fusion Id","Agent","L1 Super","File No","Call Date","Call Duration","Audit Type","Auditor Type","VOC", "Audit Start Date Time", "Audit End Date Time", "Interval(In Second)", "disposition","Overall Score","Possible Score","Earned Score","Greeting (Agent complied with greeting mentioned Brand and call reason )","Enthusiasm (Agent sounds with enthusiasm good energy when speaking)","Clarity (Agent demonstrate a good level of grammar pronunciation pace and confidence at the time of speaking)","Professionalism (listening skills phone etiquette maintain call control and ethics agent's ethics)","Product knowledge (Agent answers product questions sounds as a product expert)","Accuracy (Agent provides accurate product information to the customer avoid providing false expectation/information to the customer)","Efficiency (Agent works effectively during the call to complete the purpose of the call )","System Knowledge (Agent demonstrates program knowledge)","Offer Information (Agents read offer information to the customer including price and features with good and clear pace)","Purchase confirmation (Agent confirms purchase information including prices provides confirmation number to the customer)","Call Summary","Feedback","Entry By","Entry Date","Client entry by","Mgnt review by","Mgnt review note","Mgnt review date","Agent Feedback Acceptance","Agent review note","Agent review date","Client review by","Client review note","Client_rvw_date" );
	}

	///////////////////////Blains/////////////////////////////////////

	function blainsHeader(){
		return Array ("Auditor Name","Audit Date","Call Date","Fusion Id","Agent","L1 Super","Phone","Filler 2","Area Code","Site","Call Duration","File No","Audit Type","Auditor Type","VOC", "Audit Start Date Time", "Audit End Date Time", "Interval(In Second)", "Possible Score","Earned Score","Overall Score","Correct Call Path Procedures","Data & Program Integrity for Order Capture","Correct use of Flags/Escalations/Transfer","Correct use of FAQs/Memos/Promotions/Website","Professionalism/Courtesy","Ready for call and no dead air","Tone / Grammar & Pronunciation / Pacing","Offers e-alerts to caller","Attentive Listening","Blain's Culture Followed","Comments 1","Comments 2","Comments 3","Comments 4","Comments 5","Comments 6","Comments 7","Comments 8","Comments 9","Comments 10","Call Summary","Feedback","Entry By","Entry Date","Audit Start Time","Client entry by","Mgnt review by","Mgnt review note","Mgnt review date","Agent Feedback Acceptance","Agent review note","Agent review date","Client review by","Client review note","Client_rvw_date");
	}

	function brightway_evaluationHeader(){
		return Array ("Auditor Name","Audit Date","Fusion Id","Agent","L1 Super","Phone","Call Date","Call Duration","Audit Type","Auditor Type ","VOC ","Enter Policy Information ","Skill - Select all the Apply ","File No. ", "Audit Start Date Time", "Audit End Date Time", "Interval(In Second)", "Overall Score ","Possible Score ","Earned Score ","Did the CSR use the approved greeting ","Did rep advise they were on a recorded line ","Did the associate use the appropriate tone pace and professionalism while avoidinginsurance jargon? ","Did the associate demonstrate the right level of empathy or sympathy? ","Did the associate listen carefully to understand and address the customers needs askingprobing questions and verbally verify the information obtained and processed? ","Did the CSR follow the appropriate hold procedure and provide a wrap-up summary ","The associate maintained call control throughout the call by guiding the conversation ","All verbal and written information provided by associate to insured and other parties wasclear ","If call was transferred was the appropriate transfer process followed? ","Did the CSR attempt to contact the callerback to complete the call? ","Worked correct policy. ","Created all activities corresponding with the interaction with clear ","Were the correct interaction templates used? ","Attached all emails fax confirmations and other documents as needed ","Was the issue or request resolved/completed? ","Effectively accessed and utilized all appropriate systems and resources to obtaininformation ","If a renewal payment was processed and there is an open renewal suspense was thesuspense updated and closed? ","Did the associate offer additional assistance thanked the customer? ","Was the customer adversely impacted? ","Were there any additional adverse impacts? ","Comments 1 ","Comments 2 ","Comments 3 ","Comments 4 ","Comments 5 ","Comments 6 ","Comments 7 ","Comments 8 ","Comments 9 ","Comments 10 ","Comments 11 ","Comments 12 ","Comments 13 ","Comments 14 ","Comments 15 ","Comments 16 ","Comments 17 ","Comments 18 ","Comments 19 ","Comments 20 ","Call Summary ","Feedback ","Entry By ","Entry Date ","Audit Start Time ","Client entry by ","Mgnt review by ","Mgnt review note ","Mgnt review date ","Agent Feedback Acceptance","Agent review note ","Agent review date ","Client review by ","Client review note ","Client_rvw_date");
	}

	function brightway_prescreenHeader(){
		return Array ("Auditor Name","Audit Date","Call Date","Fusion Id","Agent","L1 Super","Phone","Filler 2","Area Code","Site ","Call Duration ","File No. ","Audit Type ","Auditor Type ","VOC ", "Audit Start Date Time", "Audit End Date Time", "Interval(In Second)", "Possible Score ","Earned Score ","Overall Score ","Transfer to ","Did the associate use the appropriate greeting? ","Was the Pre-Screen template completed correctly? ","Did the associate disposition the call correctly? ","Did the associate use the appropriate verbiage tone pace and professionalism? ","Did the associate transfer to the correct skill based on the decision flow diagram? ","Was the caller appropriately authenticated? ","If verified and change needed was AMS updated? ","Comments 1 ","Comments 2 ","Comments 3 ","Comments 4 ","Comments 5 ","Comments 6 ","Comments 7 ","Comments 8 ","Call Summary ","Feedback ","Entry By ","Entry Date ","Audit Start Time ","Client entry by ","Mgnt review by ","Mgnt review note ","Mgnt review date ","Agent Feedback Acceptance","Agent review note ","Agent review date ","Client review by ","Client review note ","Client_rvw_date");
	}

	function pajamagramHeader(){
		return Array ("Auditor Name","Audit Date","Call Date","Fusion Id","Agent","L1 Super","Phone","Call Duration","File No","Audit Type","Auditor Type","VOC", "Audit Start Date Time", "Audit End Date Time", "Interval(In Second)", "Possible Score","Earned Score","Overall Score","Caller is ready and logged in to website to handle call","Greet caller and Thank them for calling Pajamagram or Vermont Teddy Bear","Ask caller what can we order for them today","Verify all  caller and product information","Assist search if caller doesn’t know specific item","Offer personalization if available","Offer Upsell","Ask for additional items","Confirm email and phone number","Energy/enthusiasm","Proper pace","Maintained control of the conversation/Minimal Dead Air","Spoke clearly/utilized proper grammar (NO SLANG)","Good listening skills/Does not interrupt","Empathized with caller","Overall professionalism","Ask for Priority code if caller has catalog","Enter advertising source from CRM screen or ask caller for it","Close call with order confirmaiton and Thank caller for their order","False/inappropriate information","Hung up inappropriately","Unprofessional or rude behavior","Inappropriate language","Comments 1","Comments 2","Comments 3","Comments 4","Comments 5","Call Summary","Feedback","Entry By","Entry Date","Audit Start Time","Client entry by","Mgnt review by","Mgnt review note","Mgnt review date","Agent Feedback Acceptance","Agent review note","Agent review date","Client review by","Client review note","Client_rvw_date");
	}

	public function deltaHeader(){

		return $arrayName = Array ("Auditor Name","Audit Date","Fusion Id","Agent","L1 Super","Phone","Call Date","Call Duration","Audit Type","Auditor Type","VOC","File No.", "Audit Start Date Time", "Audit End Date Time", "Interval(In Second)", "Overall Score","Possible Score","Earned Score","Did CER appropriately greet the caller?","Did CER use a pleasant respectful tone and use the caller's name at least once during the call?","Did CER answer in a timely manner?","Did CER obtain 3 pieces of PHI?","Did CER obtain member's information first and then provider's if on provider call?","If Non-Covered Parent did the caller answer yes to all 3 questions on Guidelines tab?","Did CER ask appropriate questions to determine the purpose of the call?","Did CER assess all information before responding to the caller? (BVN)","Did CER pose appropriate questions to clarify the caller's issue? (Restate Issue)","Did CER utilize active listening skills throughout the inquiry?","Did CER demonstrate use of call control techniques?","Did CER refrain from interrupting the caller?","Did CER speak clearly and concisely and at an appropriate pace?","Did CER avoid use of internal terms technical terms slang and jargon?","Did CER demonstrate confidence in responses?","Did CER minimize silences and use fillers to obtain additional information?","Did CER provide accurate information and/or demonstrate knowledge of client's benefit programs?","Did CER take correct action to resolve the caller's issues?","Did CER promote self-service options where appropriate?","Did CER answer questions clearly and completely?","Was CER proactive by anticipating additional needs of the caller?","Did CER accurately and completely document the call's outcome?","Did the CER document the callers phone number name call type CITS code etc?","Did CER close CITS if it did not require a follow up?","Did CER confirm resolution of the caller's question?","Did CER ask if any additional information could be provided?","Did CER thank the individual for calling and release the call within 5 seconds","Comments 1","Comments 2","Comments 3","Comments 4","Comments 5","Comments 6","Comments 7","Comments 8","Comments 9","Comments 10","Comments 11","Comments 12","Comments 13","Comments 14","Comments 15","Comments 16","Comments 17","Comments 18","Comments 19","Comments 20","Comments 21","Comments 22","Comments 23","Comments 24","Comments 25","Comments 26","Comments 27","Call Summary","Feedback","Entry By","Entry Date","Audit Start Time","Client entry by","Mgnt review by","Mgnt review note","Mgnt review date","Agent Feedback Acceptance","Agent review note","Agent review date","Client review by","Client review note","Client_rvw_date");
	}

	////////////////////support function for Report///////////////////////

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


	// function abc(){

	// 	echo "work please";

	// 	// $this->db->query("create table xyz1 as SELECT phno as phone1,concat(fname,' ',lname) as name,email_id as email FROM `signin` WHERE 1");

		
	// 	$field_name=$this->Common_model->get_query_result_array("SELECT phno as phone1,concat(fname,' ',lname) as name,email_id as email FROM `signin` WHERE 1");
	// 	// print_r($field_name);
	// 	$this->create_qa_ameridial_CSV($field_name,"xyz");
	// 	$dn_link = base_url()."qa_ameridial/download_qa_ameridial_CSV/"."Full User Details";



	// }

	////////////////Dynamic function for automatic report generation//////////////

	public function create_qa_amd_common_new_CSV($header,$rr,$pid)
	{
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$fopen = fopen($filename,"w+");		
		
		$field_name="SHOW FULL COLUMNS FROM qa_amd_".$pid."_feedback WHERE Comment!=''";
		$field_name=$this->Common_model->get_query_result_array($field_name);
		$fld_cnt=count($field_name);
		for($i=0;$i<$fld_cnt;$i++){
						$val=$field_name[$i]['Field'];
						if($val!=""){
							$field_val[]=$val;
						}		
					 }
		
		array_unshift($field_val ,"auditor_name");
		$key = array_search ('agent_id', $field_val);
		array_splice($field_val, $key, 0, 'fusion_id');
		$field_val=array_values($field_val);

		$count_for_field=count($field_val);

		$row = "";
		foreach($header as $data) $row .= ''.$data.',';
		fwrite($fopen,rtrim($row,",")."\r\n");
		$searches = array("\r", "\n", "\r\n");
		$row = "";
		// print_r($rr);
		// die;
		foreach($rr as $user)
		{	
			for($z=0;$z<$count_for_field;$z++){
				
				if($field_val[$z]==="auditor_name"){
					$row = '"'.$user['auditor_name'].'",';
				}elseif($field_val[$z]==="fusion_id"){
					$row .= '"'.$user['fusion_id'].'",';
				}elseif($field_val[$z]==="agent_id"){
					$row .= '"'.$user['fname']." ".$user['lname'].'",';
				}elseif($field_val[$z]==="tl_id"){
					$row .= '"'.$user['tl_name'].'",';	
				}elseif(in_array($field_val[$z], array('call_summary','feedback','agent_rvw_note','mgnt_rvw_note'))) {
    			
    			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user[$field_val[$z]])).'",';

				}else{
					$row .= '"'.$user[$field_val[$z]].'",';	
				}
				
			}
				
				fwrite($fopen,$row."\r\n");
				$row = "";
		}
		
		fclose($fopen);
	}

	public function create_qa_ameridial_CSV($rr,$pid)
	{
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$fopen = fopen($filename,"w+");
		
		if($pid=='fortunebuilder'){
			$header = array("Auditor Name", "Audit Date", "Fusion ID", "Agent", "L1 Super", "Call Date", "File No", "Call Duration", "Audit Type", "VOC", "Audit Start Date Time", "Audit End Date Time", "Interval(In Second)", "Overall Score", "Was the call answered within 5 seconds?", "Did the agent introduce him/herself to the caller?", "Did the agent advise the call is being recorded?", "Did the agent use the standard greeting?", "Did the agent ask for the zip code?", "Did the agent verify callers first and last name and complete address?", "Did the agent ask for and verify the caller's email address", "Did the agent correctly offer the seminars?", "Did the agent correctly ask for and verify the phone number?", "Did the agent inform the caller about the text reminders he/she will receive?", "Did the agent summarize the call with relevant details?", "Did the agent offer to register a guest?", "Did the agents collect and verify the guests email address?", "Did the agent demonstrate knowledge of Fortune Builders?", "Did the agent use appropriate grammar and pronunciation?", "Did the agent use good pacing and tone?", "Did the agent display professionalism and handle difficult callers appropriately?", "Did the agent maintain call control throughout the call?", "Did the agent use the appropriate Closing?", "Did the agent correctly disposition the call?", "Call Summary", "Feedback", "Agent Feedback Acceptance","Agent Review Date", "Agent Comment", "Mgnt Review Date","Mgnt Review By", "Mgnt Comment");
		}else if($pid=='xyz'){
			$header=array("phone1","Name","Email");
	}else if($pid=='purity_free_bottle'){
			$header = array("Auditor Name", "Audit Date", "Fusion ID", "Agent", "L1 Super", "Call Date", "Call Duration", "File No", "Call Type/LOB", "Audit Type", "VOC", "Audit Start Date Time", "Audit End Date Time", "Interval(In Second)", "Overall Score", "Did the rep greet the customer promptly and properly?", "Did the rep use their soft skills appropriately?", "Did the rep collect and verify the customers information appropriately?", "Did the rep cover the super saver offer appropriately?", "Did the rep cover the upsell appropriately?", "Did the rep cover the payment procedures appropriately?", "Did the rep demonstrate knowledge of the product/program?", "Did the rep maintain call control?", "Did the rep use the tools/FAQ's appropriately?", "Did the rep use the appropriate objection responses?", "Did the rep use the callers last name to personalize the call at least once per section?", "Did the rep complete the correct confirmation and closing?", "Did the rep cover the frequency and cost of each delivery when applicable?", "Did the rep have any misrepresentation?", "Did the rep response appropriately to a DNC response?", "Call Summary", "Feedback","Agent Feedback Acceptance", "Agent Review Date", "Agent Comment", "Mgnt Review Date","Mgnt Review By", "Mgnt Comment");
		}else if($pid=='purity_catalog'){
			$header = array("Auditor Name", "Audit Date", "Fusion ID", "Agent", "L1 Super", "Call Date", "Call Duration", "Audit Type", "VOC", "Audit Start Date Time", "Audit End Date Time", "Interval(In Second)", "Overall Score", "Proper Greeting", "Customer First Name and Address Verification", "Identifies Type of Account Properly", "Properly transfers the Account", "Accurate Notes Taken/Info Verified Appropriately", "Correct Information Given", "Proper Terminology/Use of Disc Names, etc", "Free Gift Scripting", "Bulk Offer", "Promotions Offered Correctly", "Super Saver Offered and Explained Properly", "Additional Product Offered", "Order Placed Properly/Cancelled Properly", "Order Confirmation", "Uses Tools and FAQ", "Address Verification at Confirmation", "Credit Card Verification/Charged Correct Information", "Attempt to Gather CVV Code", "Daily Special Offer", "Product/Benefits Offered with Daily Special", "Thank You Statement", "Maintained Call Control/Call Flow", "Response Time/Minimal Dead Air", "Used Proper Hold Techniques", "Good Attitude/Maintained Composure", "Energy/Enthusiasm/Attentiveness", "Context Related Responses", "Empathy/Respectfulness/Courteous", "Call Summary", "Feedback","Agent Feedback Acceptance", "Agent Review Date", "Agent Comment", "Mgnt Review Date","Mgnt Review By", "Mgnt Comment");
		}else if($pid =='purity_care'){
			$header = array("Auditor Name", "Audit Date", "Fusion ID", "Agent", "L1 Super", "Call Date",
			"Call 1 Call Duration", "Call 1 File No","Call 2 Call Duration", "Call 2 File No","Call 3 Call Duration", "Call 3 File No", "Audit Type", "VOC","Overall Score","Proper Introduction Call 1","Proper Introduction Call 2","Proper Introduction Call 3","Proper Introduction Review","Proper Introduction Score","Customer First Name and Address Verification Call 1","Customer First Name and Address Verification Call 2","Customer First Name and Address Verification Call 3","Customer First Name and Address Verification Review","Customer First Name and Address Verification Score", "Opening Question Call 1","Opening Question Call 2","Opening Question Call 3","Opening Question Review"
			,"Opening Question Score","Accurate Notes Taken Call 1","Accurate Notes Taken Call 2","Accurate Notes Taken Call 3","Accurate Notes Taken Review","Accurate Notes Taken Score","Correct Reason Code Call 1","Correct Reason Code Call 2","Correct Reason Code Call 3","Correct Reason Code Review","Correct Reason Code Score","Correct Information Given Call 1","Correct Information Given Call 2","Correct Information Given Call 3","Correct Information Given Review","Correct Information Given Score","Proper Terminology/use of disc names. etc. Call 1","Proper Terminology/use of disc names. etc. Call 2","Proper Terminology/use of disc names. etc. Call 3","Proper Terminology/use of disc names. etc. Review","Proper Terminology/use of disc names. etc. Score","Proper Inquiry Call 1","Proper Inquiry Call 2","Proper Inquiry Call 3","Proper Inquiry Review","Proper Inquiry Score","Company Promotion Call 1","Company Promotion Call 2","Company Promotion Call 3","Company Promotion Review","Company Promotion Score","Correct Use of Actions Call 1","Correct Use of Actions Call 2","Correct Use of Actions 3","Correct Use of Actions Review","Correct Use of Actions Score","Database Follow Up Call 1","Database Follow Up Call 2","Database Follow Up Call 3","Database Follow Up Review","Database Follow Up Score","Product Promotion Call 1","Product Promotion Call 2","Product Promotion Call 3","Product Promotion Review","Product Promotion Score","Reason for Cancel Call 1","Reason for Cancel Call 2","Reason for Cancel Call 3","Reason for Cancel Review","Reason for Cancel Score","Legitimate Offers/Sequence of Offers Call 1","Legitimate Offers/Sequence of Offers Call 2","Legitimate Offers/Sequence of Offers Call 3","Legitimate Offers/Sequence of Offers Review","Legitimate Offers/Sequence of Offers Score","1st Retention Offer Call 1","1st Retention Offer Call 2","1st Retention Offer Call 3","1st Retention Offer Review","1st Retention Offer Score","2nd Retention Offer Call 1","2nd Retention Offer Call 2","2nd Retention Offer Call 3","2nd Retention Offer Review","2nd Retention Offer Score","Valid Delay Call 1","Valid Delay Call 2","Valid Delay Call 3","Valid Delay Review","Valid Delay Score","Preserved Avg # Units/Shipment Call 1","Preserved Avg # Units/Shipment Call 2","Preserved Avg # Units/Shipment Call 3","Preserved Avg # Units/Shipment Review","Preserved Avg # Units/Shipment Score","Proper Confirmation Call 1","Proper Confirmation Call 2","Proper Confirmation Call 3","Proper Confirmation Review","Proper Confirmation Score","Daily Special Offer Call 1","Daily Special Offer Call 2","Daily Special Offer Call 3","Daily Special Offer Review","Daily Special Offer Score","Anything Else Statement Call 1","Anything Else Statement Call 2","Anything Else Statement Call 3","Anything Else Statement Review","Anything Else Statement Score","Thank You Statement Call 1","Thank You Statement Call 2","Thank You Statement Call 3","Thank You Statement Review","Thank You Statement Score","Maintained call control Call 1","Maintained call control Call 2","Maintained call control Call 3","Maintained call control Review","Maintained call control Score","Response Time/Minimal dead air Call 1","Response Time/Minimal dead air Call 2","Response Time/Minimal dead air Call 3","Response Time/Minimal dead air Review","Response Time/Minimal dead air Score","Uses proper hold techniques Call 1","Uses proper hold techniques Call 2","Uses proper hold techniques Call 3","Uses proper hold techniques Review","Uses proper hold techniques Score","Good Attitude/Maintained Composure Call 1","Good Attitude/Maintained Composure Call 2","Good Attitude/Maintained Composure Call 3","Good Attitude/Maintained Composure Review","Good Attitude/Maintained Composure Score","Energy/Enthusiasm/Attentiveness Call 1","Energy/Enthusiasm/Attentiveness Call 2","Energy/Enthusiasm/Attentiveness Call 3","Energy/Enthusiasm/Attentiveness Review","Energy/Enthusiasm/Attentiveness Score","Context Related Responses Call 1","Context Related Responses Call 2","Context Related Responses Call 3","Context Related Responses Review","Context Related Responses Score","Empathy/Respectfulness/Courteous Call 1","Empathy/Respectfulness/Courteous Call 2","Empathy/Respectfulness/Courteous Call 3","Empathy/Respectfulness/Courteous Review","Empathy/Respectfulness/Courteous Score","Badgering Call 1","Badgering Call 2","Badgering Call 3","Badgering Review","Badgering Score","Average Calls Per Hour/4 or More Call 1","Average Calls Per Hour/4 or More Call 2","Average Calls Per Hour/4 or More Call 3","Average Calls Per Hour/4 or More Review","Average Calls Per Hour/4 or More Score","Average Save % Above 44% Call 1","Average Save % Above 44% Call 2","Average Save % Above 44% Call 3","Average Save % Above 44% Review","Average Save % Above 44% Score","Average Call Length Does Not Exceed 8 min. Call 1","Average Call Length Does Not Exceed 8 min. Call 2","Average Call Length Does Not Exceed 8 min. Call 3","Average Call Length Does Not Exceed 8 min. Review","Average Call Length Does Not Exceed 8 min. Score","Call Summary", "Feedback","Agent Feedback Acceptance", "Agent Review Date", "Agent Comment", "Mgnt Review Date","Mgnt Review By", "Mgnt Comment");
		}else if($pid =='puritycare_new'){
			$header = array("Auditor Name", "Audit Date", "Fusion ID", "Agent", "L1 Super", "Call Date", "File No", "Call Duration", "Audit Type", "VOC","Overall Score", "Customer Address Verification Call 1", "Customer Address Verification Call2", "Customer Address Verification Call3", "Script Compliance Call1", "Script Compliance Call2", "Script Compliance Call3", "Opening Question Call1", "Opening Question Call2", "Opening Question Call3", "Accurate Detailed Notes Taken Call1", "Accurate Detailed Notes Taken Call2", "Accurate Detailed Notes Taken Call3", "Correct Important Info Given Call1", "Correct Important Info Given Call2", "Correct Important Info Given Call3", "Correct Reason Code Call1", "Correct Reason Code Call2", "Correct Reason Code Call3", "Proper Terminology Call1", "Proper Terminology Call2", "Proper Terminology Call3", "Proper Inquiry Effective Questions Call1", "Proper Inquiry Effective Questions Call2", "Proper Inquiry Effective Questions Call3", "Product Promotion Call1", "Product Promotion Call2", "Product Promotion Call3", "Company Promotion Call1", "Company Promotion Call2", "Company Promotion Call3", "Database Follow-Up Call1", "Database Follow-Up Call2", "Database Follow-Up Call3", "Reason for Cancel Call1", "Reason for Cancel Call2", "Reason for Cancel Call3", "1st Retention Offer Call1", "1st Retention Offer Call2", "1st Retention Offer Call3", "Two Tools Each Offer Call1", "Two Tools Each Offer Call2", "Two Tools Each Offer Call3", "Sequence of Legitimate Offers Call1", "Sequence of Legitimate Offers Call2", "Sequence of Legitimate Offers Call3", "2nd Retention Offer Call1", "2nd Retention Offer Call2", "2nd Retention Offer Call3", "# of bottles Call1", "# of bottles Call2", "# of bottles Call3", "Correct Delay Length Call1", "Correct Delay Length Call2", "Correct Delay Length Call3", "Complete Confirmation Recap Call1", "Complete Confirmation Recap Call2", "Complete Confirmation Recap Call3", "Anything Else Question Call1", "Anything Else Question Call2", "Anything Else Question Call3", "Daily Special Offer Call1", "Daily Special Offer Call2", "Daily Special Offer Call3", "Thank You Statement Call1", "Thank You Statement Call2", "Thank You Statement Call3", "Maintained Call Control Call1", "Maintained Call Control Call2", "Maintained Call Control Call3", "Hold Technique Call1", "Hold Technique Call2", "Hold Technique Call3", "Response Time Min Dead Air Call1", "Response Time Min Dead Air Call2", "Response Time Min Dead Air Call3", "Used hold Tactically Call1", "Used hold Tactically Call2", "Used hold Tactically Call3", "Good Attitude Maintained Composure Call1", "Good Attitude Maintained Composure Call2", "Good Attitude Maintained Composure Call3", "Context Related Responses Call1", "Context Related Responses Call2", "Context Related Responses Call3", "Energy & Enthusiasm Call1", "Energy & Enthusiasm Call2", "Energy & Enthusiasm Call3", "Respectful & Courteous Call1", "Respectful & Courteous Call2", "Respectful & Courteous Call3", "Call Length Call1", "Call Length Call2", "Call Length Call3", "Call Summary", "Feedback","Agent Feedback Acceptance", "Agent Review Date", "Agent Comment", "Mgnt Review Date","Mgnt Review By", "Mgnt Comment");
		}else if($pid=='touchfuse'){
			$header = array("Auditor Name", "Audit Date", "Fusion ID", "Agent", "L1 Super", "Call Date", "Call Duration", "File No", "Call Status", "Audit Type", "VOC", "Audit Start Date Time", "Audit End Date Time", "Interval(In Second)", "Overall Score", "Was the call answered promptly?", "Did the agent answer with thank you for calling", "Did the agent ask for the zip code?", "Did the agent correctly offer the seminars?", "Did the caller wish to cancel the seminar?", "Did the agent confirm the callers first and last name?", "Did the agent confirm the callers address?", "Did the agent ask for and correctly verify the email phonetically?", "Did the agent correctly ask for and verify the phone number", "Did the agent summarize the call with relevant detail?", "Did the agent offer to register a guest", "Did the agent correctly disposition the call?", "Did the agent use the appropriate closing?", "Did the agent use appropriate tone/pacing/grammar/pronunciation?", "Did the agent use active listening throughout the call?", "Was the agent professional throughout the call?", "Did the agent show knowledge of TouchFuse throughout the call?", "Did the agent maintain call control throughout the call?", "Call Summary", "Feedback","Agent Feedback Acceptance", "Agent Review Date", "Agent Comment", "Mgnt Review Date","Mgnt Review By", "Mgnt Comment");
		}else if($pid=='tbn'){
			$header = array("Auditor Name", "Audit Date", "Fusion ID", "Agent", "L1 Super", "Call Date", "File No", "Call Duration", "Call ID", "Audit Type", "VOC", "Audit Start Date Time", "Audit End Date Time", "Interval(In Second)", "Overall Score", "Full Recording Between Communicator and Caller is Captured", "Communicator Properly Prepared for Call", "Communicator Gave Her/His First Name", "Stated-This Call May Be Recorded For Training Purposes", "Stated Offer Title as Scripted", "Stated No Offer Disclosure (if applicable)", "Spelled Donors Full Name Back on ALL CALLS", "EXISTING File - Communicator Verified Address", "IF NEW ADDRESS - Communicator Spelled Address", "IF No Existing Email - Asked for Email", "Spelled Back Email", "Asked for Phone Number", "Confirmed Phone Number", "Verified Phone Number Type", "IF Cell Asked for Consent", "Asked for Alternate Phone Number", "Verified Alternate Phone Number", "Verified Alternate Number Type", "IF Alternate Phone Number is Cell - Asked for Consent", "Read First Request as Scripted", "Appropriately Presented Higher Tier Offers (if applicable )", "Read Monthly Ask As Scripted (if applicable)", "Navigates Script With Ease", "Displays TBN Knowledge and Answers Questions Appropriately", "Correctly Pronounces Speaker/Author Name and Title of Offer", "Overall Script Adherence", "Verified Donation Frequency (One-Time/Monthly)", "Verified Donation Amount", "Verified Monthly Donation Beginning and End Date (if applicable)", "Verified Resource Donor Will Be Receiving (if applicable)", "Read Close as Scripted", "Speaks Clearly with Proper Articulation (no slang)", "Pleasant Demeanor", "Speaks at an Appropriate Pace", "Actively Listens and Responds Appropriately", "Exhibits Empathy (if appropriate)", "Communicator Shows Sincere Appreciation for Donor and Donations", "Maintained Control of the Conversation and Talk Time", "Autofail - False and/or Inappropriate Information", "Autofail - Inappropriately Ended Call", "Autofail - Rudeness/Unprofessional Behavior", "Call Summary", "Feedback","Agent Feedback Acceptance", "Agent Review Date", "Agent Comment", "Mgnt Review Date","Mgnt Review By", "Mgnt Comment");
		}else if($pid=='jfmi'){
			$header = array("Auditor Name", "Audit Date", "Fusion ID", "Agent", "L1 Super", "Call Date", "Call Duration", "Audit Type", "VOC", "Audit Start Date Time", "Audit End Date Time", "Interval(In Second)", "Overall Score","Greets the customer promptly and properly","Uses professionalism/courtesy/enthusiasm/proper grammar/no jargon","Shows gratitude throughout the call","Collects and verifies all customer information/uses phonetic when applicable","Follows correct Scripting Path","Collects information to provide to Partner Relations if necessary","Covers all payment scripting and responses properly","Maintains call control","Keeps dead air to a minimum","Uses FAQ's/Agent notes to answer questions properly","Brands the call with proper close", "Not stopping the recording for credit card capture", "Agent read legal scripting to the caller", "Call Summary", "Feedback","Agent Feedback Acceptance", "Agent Review Date", "Agent Comment", "Mgnt Review Date","Mgnt Review By", "Mgnt Comment");
		}else if($pid=='hoveround'){
			$header = array("Auditor Name", "Audit Date", "Fusion ID", "Agent", "L1 Super", "Call Date", "Call Duration", "File No", "Audit Type", "VOC", "Audit Start Date Time", "Audit End Date Time", "Interval(In Second)", "Overall Score","Was the agent ready for the call (no dead air)?", "Did the agent give the proper introduction including company name?", "Did the agent correctly probe and transfer if applicable?", "Did the agent verify all customer information/NATO spell back of email address?", "Did the agent close the call with proper branding?", "Did the agent disposition the call properly?", "Was the agent polite and courteous?", "Did the agent show energy empathy and enthusiasm?", "Did the agent have good tone grammer?", "Did the agent give accurate information and show a complete grasp of information?", "Call Summary", "Feedback","Agent Feedback Acceptance", "Agent Review Date", "Agent Comment", "Mgnt Review Date","Mgnt Review By", "Mgnt Comment");
		}else if($pid=='ncpssm'){
			$header = array("Auditor Name", "Audit Date", "Fusion ID", "Agent", "L1 Super", "Call Date", "Call Duration", "File No", "Audit Type", "VOC", "Audit Start Date Time", "Audit End Date Time", "Interval(In Second)", "Overall Score", "Thanks caller for calling NCPSSM", "Verified opening info", "Gathered and spelled back all necessary information", "Verified/Asked for Email Address", "Makes thank you/supporting statements", "Familiarity with FAQ -Organization", "Personalized call (Mr./Mrs etc)", "Thanked Caller for being a member/previous support", "Energy/enthusiasm", "Proper pace", "Maintained control of the conversation/Minimal Dead Air", "Spoke clearly/utilized proper grammar (NO SLANG)", "Good listening skills/Does not interrupt", "Empathized with caller", "Overall professionalism", "Proper thanks at call conclusion", "Provided correct and appropriate information", "Confirmed caller has no further questions", "False/inappropriate information", "Hung up inappropriately", "Unprofessional behavior", "Inappropriate language", "Call Summary", "Feedback","Agent Feedback Acceptance", "Agent Review Date", "Agent Comment", "Mgnt Review Date","Mgnt Review By", "Mgnt Comment");
		}else if($pid=='stc'){
			$header = array("Auditor Name", "Audit Date", "Fusion ID", "Agent", "L1 Super", "Call Date", "Call Duration", "File No", "Audit Type", "VOC", "Audit Start Date Time", "Audit End Date Time", "Interval(In Second)", "Overall Score", "Did the agent use proper introduction?", "Did the agent correctly capture and verify donor name?", "Did the agent read first request as scripted?", "Did the agent cover second monthly request (if applicable)?", "Did the agent correctly capture and verify donation amount?", "Did the agent offer payment types?", "Did the agent correctly capture and verify donor address?", "Did the agent correctly capture and verify donor phone number?", "Did the agent correctly capture and verify donor email address?", "Did the agent properly present rebuttals (if applicable)?", "Did the agent follow overall script adherence?", "Did the agent show familiarity with Save the Children?", "Did the agent use appropriate script navigation and proper disposition?", "Did the agent follow proper close?", "Did the agent use effective communication?", "Did the agent maintain control of the conversation and talk time?", " Did the agent show appreciation for donor and donations?", "Did the agent give false or inappropriate information?", "Did the agent hang up inappropriately?", "Did the agent show any rudeness or unprofessional behavior?", "Call Summary", "Feedback","Agent Feedback Acceptance", "Agent Review Date", "Agent Comment", "Mgnt Review Date","Mgnt Review By", "Mgnt Comment");
		}else if($pid=='tpm'){
			$header = array("Auditor Name", "Audit Date", "Fusion ID", "Agent", "L1 Super", "Call Date", "Call Duration", "File No", "Audit Type", "VOC", "Audit Start Date Time", "Audit End Date Time", "Interval(In Second)", "Overall Score", "Read Call Opening as Scripted", "Are You Calling From the US or Canada", "Verify Form of Payment", "Communicator Asked for Name", "Communicator Spelled Name", "Communicator Asked for Address", "Communicator Spelled Address", "Communicator Asked for Phone Number", "Communicator Verified Phone Number", "Communicator Verified Landline or Cell", "Communicator Read Consent to Call Verbatim", "Communicator Read Consent to Text Verbatim", "Communicator Asked for Email", "Communicator Spelled Email", "Overall Script Adherence", "Appropriately Presented higher Tier Offers (If applicable)", "Navigates Script with Ease", "Displays TPM Knowledge and Answers Questions Appropriately", "Verified Contents of the Cart", "Monthly Ask Presented (If Applicable)", "Reviewed Shipping Time Frame", "Provided Cart Total Including Shipping (If Applicable)", "Read Close As Scripted", "Speaks Clearly and Articulately", "Pleasant Demeanor", "Professionalism", "Speaks at an Appropriate Pace", "Listens and Responds Approriately", "Exibits Empathy If Applicable", "Communicator Shows Sincere Appreciation for Donor and Donations", "Maintained Control of the Conversation and Talk Time", "Blatantly False/Inappropriate Information", "Rudely Hung up on Donor", "Rude/Hostile/Uses Profanity", "Call Summary", "Feedback","Agent Feedback Acceptance", "Agent Review Date", "Agent Comment", "Mgnt Review Date","Mgnt Review By", "Mgnt Comment");
		}else if($pid=='patchology'){
			$header = array("Auditor Name", "Audit Date", "Fusion ID", "Agent", "L1 Super", "Call Date", "Call Duration", "File No", "Audit Type", "VOC", "Audit Start Date Time", "Audit End Date Time", "Interval(In Second)", "Overall Score", "Did the agent open the call using their name and the appropriate branding for the call?", "Did the agent close the call using the appropriate branding?", "Remarks1", "Did the agent verify/confirm all necessary information?", "Did agent provide consistent/accurate information regarding products and availability?", "Did agent provide/confirm shipping information/next steps/resolution of issue?", "Remarks2", "Was call answered in a timely manner?", "Was agent engaged/helpful with customer?", "Was customer satisfied/fulfilled?", "If escalated were all resources explored before sending escalation form?", "Remarks3", "Call Summary", "Feedback","Agent Feedback Acceptance", "Agent Review Date", "Agent Comment", "Mgnt Review Date","Mgnt Review By", "Mgnt Comment");
		}else if($pid=='aspca'){
			$header = array("Auditor Name", "Audit Date", "Fusion ID", "Agent", "L1 Super", "Call Date", "Call Duration", "File No", "Audit Type", "VOC", "Audit Start Date Time", "Audit End Date Time", "Interval(In Second)", "Overall Score", "Greets the customer promptly and properly", "Uses professionalism/courtesy/enthusiasm/proper grammar/no jargon",  "Shows gratitude throughout the call","Collects and verifies all customer information/ uses phonetic when applicable", "Asks if they are calling to join ASPCA guardians program",  "Covered monthly guardian/roundup upsell $25", "Covered one time gift scripting (when applicable)", "Covered all payment scripting and responses properly", "Offers the Animal Champion T-Shirt", "Covers donation processing script", "Covers additional one time donation", "Covers pet insurance / proper close", "Followed correct script path/followed transfer procedures and scripting", "Maintains call control", "Keeps dead air to a minimum", "Uses FAQ's/KB's to answer questions properly", "Personalizes the call", "Call Summary", "Feedback","Agent Feedback Acceptance", "Agent Review Date", "Agent Comment", "Mgnt Review Date", "Mgnt Review By","Mgnt Comment");
		}else if($pid=='ffai'){
			$header = array("Auditor Name", "Audit Date", "Fusion ID", "Agent", "L1 Super", "Call Date", "Call Duration", "File No", "Audit Type", "VOC", "Audit Start Date Time", "Audit End Date Time", "Interval(In Second)", "Overall Score", "Did the agent open the call using their name and the appropriate branding for the call?", "Did the agent close the call using the appropriate branding?", "Did agent verify if caller had ordered before with FiltersFast?", "Did the agent verify/confirm all necessary information and spell back email address using NATO?", "Did agent provide consistent/accurate information regarding products and availability?", "Did agent provide confirm shipping information/next steps/resolution of issue to ensure one call resolution?", "Did agent accurately and clearly fill out pulse on Monday.com?", "Was agent engaged/empathetic with customer?", "Did agent offer membership in the Home Filter Club (if applicable)?", "Did agent offer donation to Wine to Water?", "If escalated were all resources explored before transferring?", "Call Summary", "Feedback","Agent Feedback Acceptance", "Agent Review Date", "Agent Comment", "Mgnt Review Date", "Mgnt Review By","Mgnt Comment");
		}else if($pid=='lifi'){
			$header = array("Auditor Name", "Audit Date", "Fusion ID", "Agent", "L1 Super", "Call Date", "Call Duration", "File No", "Audit Type", "VOC", "Audit Start Date Time", "Audit End Date Time", "Interval(In Second)", "Overall Score", "Life Quotes Greeting & Introduction", "Did the agent give positive response to the caller", "Customer Name Capture", "Did the agent capture the address of the customer", "Phone Number confirmation", "Email address", "Customer's DOB", "Overall Script Adherence", "Did the agent ask for coverage amount of the Insurance", "Confirmation of Tobacco or smoking", "Did the agent ask for Height & Weight of the customer", "Did the agent mention about price comparison report", "Overall confidence level professionalism & tone", "Call closing", "Call Summary", "Feedback","Agent Feedback Acceptance", "Agent Review Date", "Agent Comment", "Mgnt Review Date", "Mgnt Review By","Mgnt Comment");
		}else if($pid=='heatsurge'){
			$header = array("Auditor Name", "Audit Date", "Fusion ID", "Agent", "L1 Super", "Call Date", "Call Duration", "File No", "Audit Type", "VOC", "Audit Start Date Time", "Audit End Date Time", "Interval(In Second)", "Overall Score", "Was the agent Prepared for call or answer within 5 seconds", "Did the agent use inbound or outbound greeting", "Accesses customers accounts or any reports needed", "Agent verifies cst name address phone and TPA if needed", "Verifies or Asks for email address spelling and gave email disclaimer", "Reads mini Miranda and or Recording statement on outbound calls", "Gives accurate pricing or refund or return information", "Gives accurate shipping or delivery information", "Accurately describes product or promo or answers questions", "Asks for Upsell or add on product where appropriate", "Provides appropriate solution or alternatives", "Keyed or coded order correctly and corrected info as needed", "Asks for cancelation reason", "1st save attempt did agent use PK key buying factors", "2nd save attempt used appropriately and per guidelines", "Asks for billing Name as it appears on cc or check", "agent verified caller is an authorized user of the cc or check", "Asks for billing address for payment method used", "Asks for permission to authorize payment (cc or check)", "Agent verifies shipping address", "Notates account with issue or resolution", "Summarizes and reviews call or appropriate closure to call", "Gave CS hours of operation and CS phone number", "Was the agent polite courteous and patient", "Agent refrained from using inappropriate comments or presentation", "Uses hold and transfers properly", "**Automatic Zero", "Call Summary", "Feedback","Agent Feedback Acceptance", "Agent Review Date", "Agent Comment", "Mgnt Review Date", "Mgnt Review By","Mgnt Comment");
		}else if($pid=='stauers_sales'){
			$header = array("Auditor Name", "Audit Date", "Fusion ID", "Agent", "L1 Super", "Call Date", "Call Duration", "File No", "Audit Type", "VOC", "Audit Start Date Time", "Audit End Date Time", "Interval(In Second)", "Overall Score", "Was the call answered within 5 seconds?","Did the agent verify the customer's name and address on the account?","Did the agent capture the correct offer code?","Did the agent verify the phone number with the customer?","Did the agent verify the customer's email address?","Did the agent compliment the caller's purchase choice?","Did the agent recap the item and ask if the customer would be interested in any other product(s)?","Did the agent cover at least one upsell?","Did the agent cover the replacement guarantee pitch?","Did the agent use an appropriate rebuttal if the replacement guarantee was declined?","Did the agent cover the membership pitch?","Did the agent use an appropriate rebuttal if the membership pitch was declined?","Did the agent offer the membership accurately?","Did the agent cover the auto-renew offer correctly?","Was the shipping address verified?","Did the agent quote the correct delivery time?","Did the agent give a total product quote appropriately?","Did the agent quote shipping & taxes correctly?","Did the agent give the total to be charged and verify the credit card to be charged correctly?","Did the agent provide the order number correctly?","Did the agent close the call with the brand correctly?","Was the customer satisfied with his/her experience?","Was the customer dissatisfied with the agent's professionalism and/or tone?","Call Summary", "Feedback","Agent Feedback Acceptance", "Agent Review Date", "Agent Comment", "Mgnt Review Date", "Mgnt Review By","Mgnt Comment");
		}else if($pid=='operation_smile'){
			$header = array("Auditor Name", "Audit Date", "Fusion ID", "Agent", "L1 Super", "Call Date", "Call Duration", "File No", "Audit Type", "VOC", "Audit Start Date Time", "Audit End Date Time", "Interval(In Second)", "Overall Score", "Was the agent ready to handle the call promptly and answer properly?", "Did the agent greet the caller read the scripted opening?", "Did the agent confirm all information and utilize phonetic spell back when necessary?", "Does the agent show gratitude and acknowledge callers concerns?", "Did the agent use rebuttals appropriately?", "Did the agent offer the upsell?", "Did the agent follow the script correctly and with confidence?", "Did the agent address questions about the program and utilize the FAQs correctly?", "Did the agent speak with energy and enthusiasm?", "Did the agent use proper pacing?", "Did the agent maintain control of the conversation and minimize dead air?", "Was the agent professional and speak with proper enunciation grammar and tone?", "Did the agent use good listening skills and does not interrupt?", "Did the agent empathize with the caller?", "Did the agent provide a good donor experience and show appropriate appreciation?", "Did the agent ask what prompted them to call today?", "Did the agent thank the caller for their call today and close appropriately?", "***Did the agent give false or inappropriate information?", "***Did the agent hang up inappropriately?", "***Did the agent use inappropriate language?", "Call Summary", "Feedback","Agent Feedback Acceptance", "Agent Review Date", "Agent Comment", "Mgnt Review Date", "Mgnt Review By","Mgnt Comment");
		}else if($pid=='5_11_tactical'){
			$header = array("Auditor Name", "Audit Date", "Fusion ID", "Agent", "L1 Super", "Call Date", "Call Duration", "File No", "Audit Type", "VOC", "Audit Start Date Time", "Audit End Date Time", "Interval(In Second)", "Overall Score", "Did the rep greet the customer promptly and properly?", "Did the rep confirm the customers item to order (product size colour price)", "Did the rep ask is there anything else you would like to add to your order?", "Did the rep ask for customer login information or continue as guest appropriately", "Did the rep gather/verify the callers information for accuracy", "Did the rep cover the final confirmation (each product total cost to be charged)?", "Did the rep give customer their order number?", "Did the rep use all applicable search method?", "Did the rep cover the returns process appropriately?", "Did the rep cover the exchange process appropriately?", "Did the rep cover the refund process appropriately?", "Did the rep track the package appropriately", "Did the agent ask is there anything else I can assist you with today?", "Did the agent close and brand the call appropriately?", "Did the rep answer questions appropriately", "Did the rep maintain call control?", "Did the rep properly notate AX?", "If an escalation was done was it warranted?", "Did the agent disposition the call appropriately?", "Did the rep maintain professionalism throughout the call?", "Call Summary", "Feedback","Agent Feedback Acceptance", "Agent Review Date", "Agent Comment", "Mgnt Review Date", "Mgnt Review By","Mgnt Comment");
		}else if($pid=='jmmi'){
			$header = array("Auditor Name", "Audit Date", "Fusion ID", "Agent", "L1 Super", "Call Date", "Call Duration", "File No", "Audit Type", "VOC", "Audit Start Date Time", "Audit End Date Time", "Interval(In Second)", "Overall Score", "1) Did the agent give appropriate greeting?",	"2) Did the agent give excellent conversational responses to caller's requests?",	"3) Did the agent verify the opening information (name-zip code-address-phone number)?",	"4) Did the agent follow call flow with caller's initial request (orders what the caller asks for)?",	"5) Did the agent show appropriate gratitude throughout the call?",	"6) Did the agent share upsells when presented?",	"7) Did the agent show familiarity and search all options for offers products?", "8) If partner-did the agent thank the caller specifically?",	"9) Did the agent share HOM/JMM facts as appropriate and make good use of dead air?",	"10) Was the agent professional with communication?",	"11) Did the agent use proper pace energy & enthusiasm?",	"12) Did the agent maintain control of the conversation?",	"13) Did the agent spoke clearly and utilize proper grammar (no slang)?",	"14) Did the agent use good listening skills and appropriate responses?",	"15) Did the agent empathize with the caller and show compassion?",	"16) Did the agent have minimal dead air?",	"17) Did the agent have the caller provide the address if not populated on review screen?",	"18) Did the agent confirm dollar amount and frequency as well as reviewing cart?", "19) Did the agent read shipping information as scripted/share charges as appropriate?", "20) Did the agent ask caller for email and tv information?", "21) Did the agent use proper thanks at the call conclusion?", "22) Did the agent transfer the call to prayer/CS when appropriate?", "23) ***Did the agent follow payment industry compliance policies properly?", "24) ***Did the agent read back the customer's details properly? Like name - phone number etc.", "Call Summary", "Feedback","Agent Feedback Acceptance", "Agent Review Date", "Agent Comment", "Mgnt Review Date", "Mgnt Review By","Mgnt Comment");
		}else if($pid=='non_profit'){
			$header = array("Auditor Name", "Audit Date", "Fusion ID", "Agent", "L1 Super", "Call Date", "Call Duration", "File No", "Audit Type", "VOC", "Audit Start Date Time", "Audit End Date Time", "Interval(In Second)", "Overall Score", "Properly prepared to take calls", "Clearly stated paid caller from Donor Care Center/recorded line", "Communicator stated his/her full name", "Pronounced clients name correctly", "Gave a warm friendly greeting", "Followed scripted 1st request as scripted", "1st request Used correct dollar amounts", "1st request Assumptive gift ask", "Showed empathy/Concern", "Repeated the objection", "Personalized the objection", "Attempted to handle objection", "Did not reinforce the negative", "Exited a dead-end call", "Followed scripted 2nd request as scripted", "2nd request Used correct dollar amounts", "2nd request Assumptive gift ask", "Attempted 3rd request as scripted (when applicable)", "3rd request Used correct dollar amounts", "3rd request Assumptive gift ask", "Confirmation question/Confirmed gift amount & waited for response", "Assumed the higher dollar amount", "Showed meaningful gratitude/Thanked the donor or volunteer", "Read credit card/ACH ask verbatim/assumptively asked for credit card", "Confirmed full name and address", "Followed Maybe Close appropriately", "Read close as scripted", "Ended call in a reasonable time", "Sounded conversational used good voice inflection not read or monotone", "Mirrored donor / Used appropriate pace", "Confident presentation w/out hesitation filler words or uptalking", "Did not lose control of the conversation", "Proper personalization", "Utilized proper grammar & pronunciation", "BAILING", "DID NOT ASK FOR A CREDIT CARD/ACH", "GAVE FALSE INFORMATION", "OMITTED PAID CALLER FROM DONOR CARE CENTER STATEMENT", "DID NOT ASK CONFIRMATION QUESTION", "UNSOLID GIFT", "NOT CODING A REFUSAL/CODING A REFUSAL INAPPROPRIATELY", "UNPROFESSIONAL BEHAVIOR/RUDENESS (not extreme)", "IMPROPER PRESENTATION", "OMITTED DNC CODE/USED DNC CODE INCORRECTLY", "FALSIFICATION OF A GIFT", "Call Summary", "Feedback","Agent Feedback Acceptance", "Agent Review Date", "Agent Comment", "Mgnt Review Date", "Mgnt Review By","Mgnt Comment");
		}else if($pid=='revel'){
			$header = array("Auditor Name", "Audit Date", "Fusion ID", "Agent", "L1 Super", "Call Date", "Call Duration", "File No", "CSR ID", "Audit Type", "VOC", "Audit Start Date Time", "Audit End Date Time", "Interval(In Second)", "Overall Score", "Did the rep greet the customer promptly and properly?", "Did the rep use a pleasant respectful tone and use the caller name", "Did the rep answer in a timely manner?", "Did the rep collect and verify the caller information appropriately and accurately?", "Did the rep use active listening skills throughout the inquiry so the caller did not have to repeat themselves?", "Did the rep demonstrate use of call control techniques?", "Did the rep refrain from interrupting the caller?", "Did the rep speak clearly and concisely and at an appropriate pace?", "Did the rep avoid use of internal terms technical terms slang and jargon?", "Did the rep demonstrate confidence in responses?", "Did the rep use the callers last name to personalize the call at least once per section?", "Did the rep minimize silences and use fillers to obtain additional information?", "Did the rep maintain call control?", "Did the rep use the tools appropriately?", "Did the rep demonstrate knowledge of the product/program?", "Did the rep use the appropriate scripting responses verbatim?", "Did the rep accurately and completely document the call?", "Did the rep complete the correct confirmation and closing?", "Did the rep thank the caller before closing?", "***Did the rep attempt give Medical Advice to the caller?", "***Did the agent miscode the call?", "Greeting Comment 1.1", "Greeting Comment 1.2", "Greeting Comment 1.3", "Authentication Comment 2.1", "Listening Skills Comment 3.1", "Listening Skills Comment 3.2", "Listening Skills Comment 3.3", "Soft Skills Comment 4.1", "Soft Skills Comment 4.2", "Soft Skills Comment 4.3", "Soft Skills Comment 4.4", "Soft Skills Comment 4.5", "Knowledge Procedure & Call Flow Comment 5.1", "Knowledge Procedure & Call Flow Comment 5.2", "Knowledge Procedure & Call Flow Comment 5.3", "Knowledge Procedure & Call Flow Comment 5.4", "Closing Comment 6.1", "Closing Comment 6.2", "Closing Comment 6.3", "Auto-Fail Comment 7.1", "Auto-Fail Comment 7.2", "Call Summary", "Feedback","Agent Feedback Acceptance", "Agent Review Date", "Agent Comment", "Mgnt Review Date", "Mgnt Review By","Mgnt Comment");
		}else if($pid=='qpc'){
			$header = array("Auditor Name", "Audit Date", "Fusion ID", "Agent", "L1 Super", "Call Date", "Call Duration", "File No", "Audit Type", "VOC", "Audit Start Date Time", "Audit End Date Time", "Interval(In Second)", "Overall Score", "Unprepared to Introduce Call", "Did Not Use Branding", "Data Not Collected or Collected Incorrectly", "Second Data Occurrence", "Inaccurate Call Result Code", "Inappropriate or Unusable After-Call Comments", "Underutilized Call Narration", "Inappropriate FAQ Responses", "No or Improper Transitions", "Under-Acknowledged Caller's Concerns", "Inappropriate Script Navigation", "Did Not Display Ownership", "Incorrect Transfer or Referral", "***Did the agent abruptly end the call or display any rude behavior?", "***Did the agent answer premium/cover questions?", "***Did the agent give a wrong callback or referral number?", "***Did the agent use an incorrect carrier name?", "Open/Close Comment 1.1", "Open/Close Comment 1.2", "Data Accuracy Comment 2.1", "Data Accuracy Comment 2.2", "Data Accuracy Comment 2.3", "Data Accuracy Comment 2.4", "Active Listening Comment 3.1", "Active Listening Comment 3.2", "Customer Experience Comment 4.1", "Customer Experience Comment 4.2", "Customer Experience Comment 4.3", "Customer Experience Comment 4.4", "Customer Experience Comment 4.5", "Auto-Fail Comment 5.1", "Auto-Fail Comment 5.2", "Auto-Fail Comment 5.3", "Auto-Fail Comment 5.4", "Call Summary", "Feedback","Agent Feedback Acceptance", "Agent Review Date", "Agent Comment", "Mgnt Review Date", "Mgnt Review By","Mgnt Comment");
		}else if($pid=='ancient_nutrition'){
			$header = array("Auditor Name", "Audit Date", "Fusion ID", "Agent", "L1 Super", "Call Date", "Call Duration", "File No", "Audit Type", "VOC", "Audit Start Date Time", "Audit End Date Time", "Interval(In Second)", "Overall Score", "1.1 Did the rep greet the customer promptly and properly?", "1.2 Did the rep use a pleasant respectful tone and use the callers name at least once?", "1.3 Did the rep answer in a timely manner?", "2.1 Did the rep collect and verify the callers information appropriately and accurately?", "2.2 Did the rep cover the payment procedures appropriately?", "3.1 Did the rep use active listening skills throughout the inquiry so the caller did not have to repeat themselves?", "3.2 Did the rep demonstrate use of call control techniques?", "3.3 Did the rep refrain from interrupting the caller?", "4.1 Did the rep speak clearly and concisely and at an appropriate pace?", "4.2 Did the rep avoid use of internal terms technical terms slang and jargon?", "4.3 Did the rep demonstrate confidence in responses?", "4.4 Did the rep use the callers last name to personalize the call at least once per section?", "4.5 Did the rep minimize silences and use fillers to obtain additional information?", "5.1 Did the rep cover the Auto Shipping appropriately?", "5.2 If rep gathered email did they read the complete email scripting?", "5.3 Did the rep cover the Rush Shipping appropriately?", "5.4 Did the rep complete order confirmation?", "5.5 Did the rep maintain call control?", "5.6 Did the rep use the tools appropriately?", "5.7 Did the rep demonstrate knowledge of the product/program?", "5.8 Did the rep use the appropriate objection responses?", "6.1 Did the rep accurately and completely document the call?", "6.2 Did the rep complete the correct confirmation and closing?", "6.3 Did the rep thank the caller before closing?", "7.1 ***Did the rep attempt give Medical Advice to the caller?", "7.2 ***Did the rep cover the upsell appropriately?", "7.3 ***Did the agent read the confirmation script if email address was obtained?", "Greeting Comment 1.1", "Greeting Comment 1.2", "Greeting Comment 1.3", "Authentication Comment 2.1", "Authentication Comment 2.2", "Listening Skills Comment 3.1", "Listening Skills Comment 3.2", "Listening Skills Comment 3.3", "Soft Skills Comment 4.1", "Soft Skills Comment 4.2", "Soft Skills Comment 4.3", "Soft Skills Comment 4.4", "Soft Skills Comment 4.5", "Knowledge Procedure& Call Flow Comment 5.1", "Knowledge Procedure& Call Flow Comment 5.2", "Knowledge Procedure& Call Flow Comment 5.3", "Knowledge Procedure& Call Flow Comment 5.4", "Knowledge Procedure& Call Flow Comment 5.5", "Knowledge Procedure& Call Flow Comment 5.6", "Knowledge Procedure& Call Flow Comment 5.7", "Knowledge Procedure& Call Flow Comment 5.8", "Closing Comment 6.1", "Closing Comment 6.2", "Closing Comment 6.3", "Auto-Fail Comment 7.1", "Auto-Fail Comment 7.2", "Auto-Fail Comment 7.3", "Call Summary", "Feedback","Agent Feedback Acceptance", "Agent Review Date", "Agent Comment", "Mgnt Review Date", "Mgnt Review By","Mgnt Comment");
		}else if($pid=='sabal'){
			$header = array("Auditor Name", "Audit Date", "Fusion ID", "Agent", "L1 Super", "Call Date", "Call Duration", "File No", "Audit Type", "VOC", "Audit Start Date Time", "Audit End Date Time", "Interval(In Second)", "Overall Score", "Did the agent ask for the individual by Mr. or Mrs. Last Name?", "Did the agent introduce him/herself?", "Did the agent state he/she is a Customer Service Specialist for WellCare?", "Did the agent apologize for the unannounced phone call and state reason for the call?", "Did the agent ask how the individuals Rx plan is currently working for him/her and respond with the appropriate scripted response?", "Did the agent read the listed examples of benefits they could add? Comprehensive Dental i)Complete Vision ii)Extensive Hearing iii)Transportation iv)Free membership to fitness centers and some even come with a free Fitbit!", "Did the agent ask for the individuals red white and blue card and explain why this was needed?", "Did the agent ask for the individuals updated Medicare ID and accurately record the inforamtion?", "Did the agent ask for the individuals Part A effective date and accurately record the information?", "Did the agent use correct rebuttal is individual doesnt want to give ID over the phone?", "Did the agent use scripting if the individual wants to know the cost to him/her?", "Did the agent use correct rebuttal if the agent says he/she is not interested?", "***Did the agent abruptly end the call or display any rude behavior?", "***Did the agent become argumentative with the individual?", "***Did the agent record the incorrect Medicare members information?", "***Did agent provide any false or misleading information?", "Greeting Comment 1.1", "Greeting Comment 1.2", "Greeting Comment 1.3", "Call Flow Comment 2.1", "Call Flow Comment 2.2", "Call Flow Comment 2.3", "Data Collection Comment 3.1", "Data Collection Comment 3.2", "Data Collection Comment 3.3", "Rebuttals Comment 4.1", "Rebuttals Comment 4.2", "Rebuttals Comment 4.3", "Auto-Fail Comment 5.1", "Auto-Fail Comment 5.2", "Auto-Fail Comment 5.3", "Auto-Fail Comment 5.4", "Call Summary", "Feedback","Agent Feedback Acceptance", "Agent Review Date", "Agent Comment", "Mgnt Review Date", "Mgnt Review By","Mgnt Comment");
		}else if($pid=='curative'){
			$header = array("Auditor Name", "Audit Date", "Fusion ID", "Agent", "L1 Super", "Call Date", "Call Duration", "File No", "Audit Type", "VOC", "Audit Start Date Time", "Audit End Date Time", "Interval(In Second)", "Overall Score", "1.1 Did the rep greet the customer promptly and properly?", "1.2 Did the rep use a pleasant respectful tone?", "1.3 Did the rep answer in a timely manner? (within 5 seconds)", "2.1 Did the rep collect and verify the customers information appropriately and accurately?", "2.2 Did the rep verify patients PHI (name email phone number address email address DOB) is entered correctly in Patient Portal?", "2.3 Did the agent accurately send the email regarding correct use of all PHI?", "2.4 Did the agent escalate to Tier 2 when necessary? (Helpscout ticket tag Tier 2 Escalation) Test Cancelled", "2.5 Did the agent respect the patients privacy and provide results only to the verified caller?", "2.6 Did the agent ensure the email address was correct prior to sending the email message and only send to the verified caller?", "3.1 Did the agent speak clearly concisely and at an appropriate pace?", "3.2 Did the agent avoid use of internal terms technical terms slang and jargon on the call and in email?", "3.3 Did the agent demonstrate a strong use of empathy in responses where required on the call and in email?", "3.4 Did the agent use please and thank you throughout the call and in email communication?", "3.5 Did the agent minimize extended silences throughout the call?", "3.6 Did the agent speak with sincere warmth in his/her voice?", "3.7 Did the agent use correct sentence structure and grammar in email commumnication?", "3.8 Did the agent demonstrate patience with the caller?", "3.9 Did the caller give the agent a KUDOS or express happiness with the rep?", "4.1 Did the rep accurately and completely document the call?", "4.2 Did the rep complete the correct confirmation and closing?", "4.3 Did the rep thank the caller before closing?", "4.4 Did the agent provide accurate results?", "4.5 Did the rep anticipate the caller's needs?", "4.6 Did the rep do everything possible to assist the caller?", "Greeting Comment 1.1", "Greeting Comment 1.2", "Greeting Comment 1.3", "AutoFail Comment 2.1", "AutoFail Comment 2.2", "AutoFail Comment 2.3", "AutoFail Comment 2.4", "AutoFail Comment 2.5", "AutoFail Comment 2.6", "Soft Skills Comment 3.1", "Soft Skills Comment 3.2", "Soft Skills Comment 3.3", "Soft Skills Comment 3.4", "Soft Skills Comment 3.5", "Soft Skills Comment 3.6", "Soft Skills Comment 3.7", "Soft Skills Comment 3.8", "Soft Skills Comment 3.9", "Closing Comment 4.1", "Closing Comment 4.2", "Closing Comment 4.3", "Closing Comment 4.4", "Closing Comment 4.5", "Closing Comment 4.6", "Call Summary", "Feedback","Agent Feedback Acceptance", "Agent Review Date", "Agent Comment", "Mgnt Review Date", "Mgnt Review By","Mgnt Comment");
		}else if($pid=='powerfan'){
			$header = array("Auditor Name", "Audit Date", "Fusion ID", "Agent", "L1 Super", "Call Date", "Call Duration", "File No", "Audit Type", "VOC", "Audit Start Date Time", "Audit End Date Time", "Interval(In Second)", "Overall Score", "Was the agent Prepared for call answer within 5 seconds", "Did the agent identify self and the company?", "Collects intro information Claim code zip code", "Main Sell agent accurately gave terms of offer asks for sale per script quanity", "Did the agent promote upsell downsell asks for sale per script", "Accurately Described Product answered", "Used appropriate Objection Handling", "Asks for billing Name as it appears on cc or check", "If billing name is different than caller agent verified caller is an authorized user of the cc or check", "Asks for billing address for payment method used", "Agent verifies shipping address", "Order was set up and or coded correctly", "Asks for email address spelling and gave email disclaimer", "Gave total amount charged payment information", "Gave correct shipping information", "Gave MBG return info in", "Gave CS phone number", "Asks for permission to authorize payment cc or check", "Was the agent polite courteous and patient", "Agent refrained from using inappropriate comments presentation", "Uses hold and transfers properly", "Auto Fail", "Call Summary", "Feedback","Agent Feedback Acceptance", "Agent Review Date", "Agent Comment", "Mgnt Review Date", "Mgnt Review By","Mgnt Comment");
		}else if($pid=='nuwave'){
			$header = array("Auditor Name", "Audit Date", "Fusion ID", "Agent", "L1 Super", "Call Date", "File No", "Order ID", "Call Duration", "Interaction", "Audit Type", "VOC", "Audit Start Date Time", "Audit End Date Time", "Interval(In Second)", "Overall Score", "Greeting & Identification: Example Thank you for calling NuWave", "Asked and Verified Customer Information: May I please have your Order ID Primary name or e-mail address?", "Used the Callers Name: CSR should address the customer as he/she addresses him/herself Mr. Mrs. Dr. Rev. etc.", "Active Listening: Doesnt interrupt the customer understands customers frame of reference doesnt anticipate or make assumptions", "Communication Skills: Converses in a clear concise manner", "Professionalism: Avoids the use of slang jargon and acronyms", "Empathy Towards Customer: CSR sounds sincere about helping the customer and apologizes", "Courtesy: CSR sounds helpful upbeat friendly and patient", "Put On Hold: Asked customer May I put you on hold or Could you hold while I research this further please?", "Thanked Customer for Holding: CSR thanked customer for holding upon returning to customers call", "Hold Time/Reason Appropriate/Inappropriate: Was it really necessary for the CSR to put the customer on hold?", "Escalation/Referral Procedures: Utilized established guidelines and procedures policy from the leadership team", "Fact Finding: Used probing questions and resources to identify problem", "Verbally Verified Problem Reported: Clearly defined and restated needs reported by the customer", "Managed Customer Expectations: Regarding the order of the product and the shipping time", "Explained: Reason for troubleshooting for possible resolution", "Used Available Resources Well: Referred to knowledge training or other resource programs for order troubleshooting", "Complete & Accurate Customer Documentation: Complete description of the order and or the troubleshooting steps", "Trial Close: Confirmed customer is comfortable with outcome", "Additional Needs Uncovered: CSR asked Is there anything else that I can assist you with today?", "Upsale: Ask customer if the product completely serves their needs", "Used Correct Closing Gave Customer Order Number: Mr. Ms. Mrs. I would like to thank you for ordering with NuWave", "Infractions", "Sub-Infractions", "Call Summary", "Feedback","Agent Feedback Acceptance", "Agent Review Date", "Agent Comment", "Mgnt Review Date","Mgnt Review By", "Mgnt Comment");
		}else if($pid=='delta_iowa'){
			$header = array("Auditor Name", "Audit Date", "Fusion ID", "Agent", "L1 Super", "Call Date", "File No", "Call ID", "Call Duration", "Audit Type", "VOC", "Audit Start Date Time", "Audit End Date Time", "Interval(In Second)", "Overall Score", "1.1 Answered the call promptly (within 5 seconds)", "1.2 Opens the call properly obtains caller name", "1.3 Verifies all identifying information to continue the call", "2.1 Adhered to HIPAA/PCI guidelines depending on the type of call", "2.2 Adhered to Client Policies & Procedures", "2.3 Performed the correct actions for the caller", "2.4 Set approriate expectations", "2.5 Gave accurate and complete information", "2.6 Routed issue to the appropriate department", "2.7 Completed all necessary documentation", "3.1 Used courtesy phrases like please and thank you throughout the call", "3.2 Used the caller's name at least once during the call", "3.3 Followed acceptable hold and transfer procedures", "3.4 Allowed the caller to state the reason for the call", "3.5 Avoided the use of jargon acronyms and slang", "3.6 Allowed the caller to speak without interruption", "3.7 Explained all positives of the plan-type without pushing the caller to purchase", "3.8 Stated a willingness to help the caller usually at the beginning of the call", "3.9 Gained agreement with the caller on the proposed solution", "3.10 Demonstrated an empathetic manner professional tone", "4.1 Closed call by offering further assistance", "4.2 Resolved and followed through on all actions to resolve the customers issue", "4.3 Assured customer their concern will be handled to resolution when possible", "4.4 Made an effective attempt to handle a difficult situation", "*** Agent disconnects customer inappropriately", "*** Agent transfers customer without notifying customer", "*** Agent uses offensive words or profanity", "*** Agent was antagonistic talked back or talked down to caller", "*** Agent discloses confidential information inappropriately", "Greeting Comment 1.1", "Greeting Comment 1.2", "Greeting Comment 1.3", "Call Handling Comment 2.1", "Call Handling Comment 2.2", "Call Handling Comment 2.3", "Call Handling Comment 2.4", "Call Handling Comment 2.5", "Call Handling Comment 2.6", "Call Handling Comment 2.7", "Soft Skills Comment 3.1", "Soft Skills Comment 3.2", "Soft Skills Comment 3.3", "Soft Skills Comment 3.4", "Soft Skills Comment 3.5", "Soft Skills Comment 3.6", "Soft Skills Comment 3.7", "Soft Skills Comment 3.8", "Soft Skills Comment 3.9", "Soft Skills Comment 3.10", "Closing Comment 4.1", "Closing Comment 4.2", "Closing Comment 4.3", "Closing Comment 4.4", "Auto Fail Comment 1.1", "Auto Fail Comment 1.2", "Auto Fail Comment 1.3", "Auto Fail Comment 1.4", "Auto Fail Comment 1.5", "Call Summary", "Feedback","Agent Feedback Acceptance", "Agent Review Date", "Agent Comment", "Mgnt Review Date","Mgnt Review By", "Mgnt Comment");
		}

		$row = "";
		foreach($header as $data) $row .= ''.$data.',';
		fwrite($fopen,rtrim($row,",")."\r\n");
		$searches = array("\r", "\n", "\r\n");
		
		if($pid=='fortunebuilder'){
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
				$row .= '"'.$user['call_date'].'",';
				$row .= '"'.$user['file_no'].'",';
				$row .= '"'.$user['call_duration'].'",';
				$row .= '"'.$user['audit_type'].'",';
				$row .= '"'.$user['voc'].'",';
				$row .= '"'.$user['audit_start_time'].'",';
				$row .= '"'.$user['entry_date'].'",';
				$row .= '"'.$interval1.'",';
				$row .= '"'.$user['overall_score'].'%'.'",';
				$row .= '"'.$user['callans5sec'].'",';
				$row .= '"'.$user['agentintro'].'",';
				$row .= '"'.$user['agentadvise'].'",';
				$row .= '"'.$user['agentgreeting'].'",';
				$row .= '"'.$user['agentzip'].'",';
				$row .= '"'.$user['verifycaller'].'",';
				$row .= '"'.$user['calleremail'].'",';
				$row .= '"'.$user['agentseminar'].'",';
				$row .= '"'.$user['agentphone'].'",';
				$row .= '"'.$user['callerreminder'].'",';
				$row .= '"'.$user['agentsummerize'].'",';
				$row .= '"'.$user['registerguest'].'",';
				$row .= '"'.$user['verifyguest'].'",';
				$row .= '"'.$user['agentdemonstrate'].'",';
				$row .= '"'.$user['appropiategrammer'].'",';
				$row .= '"'.$user['goodpacing'].'",';
				$row .= '"'.$user['agentdisplay'].'",';
				$row .= '"'.$user['callcontrol'].'",';
				$row .= '"'.$user['agentclosing'].'",';
				$row .= '"'.$user['correctdisposition'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['call_summary'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['feedback'])).'",';
				$row .= '"'.$user['agnt_fd_acpt'].'",';
				$row .= '"'.$user['agent_rvw_date'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['agent_rvw_note'])).'",';
				$row .= '"'.$user['mgnt_rvw_date'].'",';
				$row .= '"'.$user['mgnt_rvw_name'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['mgnt_rvw_note'])).'"';
				
				fwrite($fopen,$row."\r\n");
			}
			fclose($fopen);
			
		}else if($pid=='xyz'){
			echo "User";
			foreach($rr as $user){
			$row = '"'.$user['phone1'].'",'; 
				$row .= '"'.$user['name'].'",'; 
				$row .= '"'.$user['email'].'",'; 
				fwrite($fopen,$row."\r\n");
			}
			fclose($fopen);
		}else if($pid=='purity_free_bottle'){
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
				$row .= '"'.$user['call_date'].'",';
				$row .= '"'.$user['call_duration'].'",';
				$row .= '"'.$user['file_no'].'",';
				$row .= '"'.$user['call_type_lob'].'",';
				$row .= '"'.$user['audit_type'].'",';
				$row .= '"'.$user['voc'].'",';
				$row .= '"'.$user['audit_start_time'].'",';
				$row .= '"'.$user['entry_date'].'",';
				$row .= '"'.$interval1.'",';
				$row .= '"'.$user['overall_score'].'%'.'",';
				$row .= '"'.$user['customer_prompt'].'",';
				$row .= '"'.$user['soft_skills'].'",';
				$row .= '"'.$user['customer_information'].'",';
				$row .= '"'.$user['super_saver_offer'].'",';
				$row .= '"'.$user['upsell'].'",';
				$row .= '"'.$user['payment_procedure'].'",';
				$row .= '"'.$user['knowledge_of_product'].'",';
				$row .= '"'.$user['call_control'].'",';
				$row .= '"'.$user['faq'].'",';
				$row .= '"'.$user['objection_response'].'",';
				$row .= '"'.$user['personalize_the_call'].'",';
				$row .= '"'.$user['correct_confirmation'].'",';
				$row .= '"'.$user['cost_of_delivery'].'",';
				$row .= '"'.$user['misrepresentation'].'",';
				$row .= '"'.$user['dnc_response'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['call_summary'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['feedback'])).'",';
				$row .= '"'.$user['agnt_fd_acpt'].'",';
				$row .= '"'.$user['agent_rvw_date'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['agent_rvw_note'])).'",';
				$row .= '"'.$user['mgnt_rvw_date'].'",';
				$row .= '"'.$user['mgnt_rvw_name'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['mgnt_rvw_note'])).'"';
				
				fwrite($fopen,$row."\r\n");
			}
			fclose($fopen);
			
		}else if($pid=='purity_catalog'){
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
				$row .= '"'.$user['call_date'].'",';
				$row .= '"'.$user['call_duration'].'",';
				$row .= '"'.$user['audit_type'].'",';
				$row .= '"'.$user['voc'].'",';
				$row .= '"'.$user['audit_start_time'].'",';
				$row .= '"'.$user['entry_date'].'",';
				$row .= '"'.$interval1.'",';
				$row .= '"'.$user['overall_score'].'%'.'",';
				$row .= '"'.$user['proper_greeting'].'",';
				$row .= '"'.$user['customer_first_name_address_verification'].'",';
				$row .= '"'.$user['identified_type_of_account'].'",';
				$row .= '"'.$user['properly_transfer_account'].'",';
				$row .= '"'.$user['accurate_note_taken'].'",';
				$row .= '"'.$user['correct_information_given'].'",';
				$row .= '"'.$user['proper_terminology'].'",';
				$row .= '"'.$user['free_gift_scripting'].'",';
				$row .= '"'.$user['bulk_offer'].'",';
				$row .= '"'.$user['super_saver_offer_explained_correctly'].'",';
				$row .= '"'.$user['additional_product_offered'].'",';
				$row .= '"'.$user['order_placed_properly'].'",';
				$row .= '"'.$user['order_confirmation'].'",';
				$row .= '"'.$user['user_tool_faq'].'",';
				$row .= '"'.$user['address_verification_at_confirmation'].'",';
				$row .= '"'.$user['credit_card_verification'].'",';
				$row .= '"'.$user['attemp_to_gather_cvv_code'].'",';
				$row .= '"'.$user['daily_special_offer'].'",';
				$row .= '"'.$user['product_offered_with_daily_special'].'",';
				$row .= '"'.$user['thank_you_statement'].'",';
				$row .= '"'.$user['maintained_call_control'].'",';
				$row .= '"'.$user['response_time'].'",';
				$row .= '"'.$user['used_proper_hold_techniques'].'",';
				$row .= '"'.$user['good_attitude'].'",';
				$row .= '"'.$user['energy_attentiveness'].'",';
				$row .= '"'.$user['context_related_response'].'",';
				$row .= '"'.$user['empathy_respectfulness'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['call_summary'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['feedback'])).'",';
				$row .= '"'.$user['agnt_fd_acpt'].'",';
				$row .= '"'.$user['agent_rvw_date'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['agent_rvw_note'])).'",';
				$row .= '"'.$user['mgnt_rvw_date'].'",';
				$row .= '"'.$user['mgnt_rvw_name'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['mgnt_rvw_note'])).'"';
				
				fwrite($fopen,$row."\r\n");
			}
			fclose($fopen);
		
		}else if($pid=='purity_care'){
			foreach($rr as $user){
				$row = '"'.$user['auditor_name'].'",'; 
				$row .= '"'.$user['audit_date'].'",'; 
				$row .= '"'.$user['fusion_id'].'",'; 
				$row .= '"'.$user['fname']." ".$user['lname'].'",';
				$row .= '"'.$user['tl_name'].'",';
				$row .= '"'.$user['call_date'].'",';
				$row .= '"'.$user['call_one_call_duration'].'",';
				$row .= '"'.$user['call_one_file_no'].'",';
				$row .= '"'.$user['call_two_call_duration'].'",';
				$row .= '"'.$user['call_two_file_no'].'",';
				//$row .= '"'.$user['call_two_voc'].'",';
				$row .= '"'.$user['call_three_call_duration'].'",';
				$row .= '"'.$user['call_three_file_no'].'",';
				//$row .= '"'.$user['call_three_voc'].'",';
				$row .= '"'.$user['audit_type'].'",';
				$row .= '"'.$user['voc'].'",';
				$row .= '"'.$user['overall_score'].'%'.'",';
				$row .= '"'.$user['call_one_proper_introduction'].'",';
				$row .= '"'.$user['call_two_proper_introduction'].'",';
				$row .= '"'.$user['call_three_proper_introduction'].'",';
				$row .= '"'.$user['review_proper_introduction'].'",';
				$row .= '"'.$user['score_proper_introduction'].'",';
				$row .= '"'.$user['call_one_cust_fname_addrs_verification'].'",';
				$row .= '"'.$user['call_two_cust_fname_addrs_verification'].'",';
				$row .= '"'.$user['call_three_cust_fname_addrs_verification'].'",';
				$row .= '"'.$user['review_cust_fname_addrs_verification'].'",';
				$row .= '"'.$user['score_cust_fname_addrs_verification'].'",';
				$row .= '"'.$user['call_one_opening_question'].'",';
				$row .= '"'.$user['call_two_opening_question'].'",';
				$row .= '"'.$user['call_three_opening_question'].'",';
				$row .= '"'.$user['review_opening_question'].'",';
				$row .= '"'.$user['score_opening_question'].'",';
				$row .= '"'.$user['call_one_accurate_note'].'",';
				$row .= '"'.$user['call_two_accurate_note'].'",';
				$row .= '"'.$user['call_three_accurate_note'].'",';
				$row .= '"'.$user['review_accurate_note'].'",';
				$row .= '"'.$user['score_accurate_note'].'",';
				$row .= '"'.$user['call_one_correct_reason'].'",';
				$row .= '"'.$user['call_two_correct_reason'].'",';
				$row .= '"'.$user['call_three_correct_reason'].'",';
				$row .= '"'.$user['review_correct_reason'].'",';
				$row .= '"'.$user['score_correct_reason'].'",';
				$row .= '"'.$user['call_one_correct_information_given'].'",';
				$row .= '"'.$user['call_two_correct_information_given'].'",';
				$row .= '"'.$user['call_three_correct_information_given'].'",';
				$row .= '"'.$user['review_correct_information_given'].'",';
				$row .= '"'.$user['score_correct_information_given'].'",';
				$row .= '"'.$user['call_one_proper_terminology'].'",';
				$row .= '"'.$user['call_two_proper_terminology'].'",';
				$row .= '"'.$user['call_three_proper_terminology'].'",';
				$row .= '"'.$user['review_proper_terminology'].'",';
				$row .= '"'.$user['score_proper_terminology'].'",';
				$row .= '"'.$user['call_one_proper_inquiry'].'",';
				$row .= '"'.$user['call_two_proper_inquiry'].'",';
				$row .= '"'.$user['call_three_proper_inquiry'].'",';
				$row .= '"'.$user['review_proper_inquiry'].'",';
				$row .= '"'.$user['score_company_promotion'].'",';
				$row .= '"'.$user['call_one_company_promotion'].'",';
				$row .= '"'.$user['call_two_company_promotion'].'",';
				$row .= '"'.$user['call_three_company_promotion'].'",';
				$row .= '"'.$user['review_company_promotion'].'",';
				$row .= '"'.$user['score_company_promotion'].'",';
				$row .= '"'.$user['call_one_correct_use_of_action'].'",';
				$row .= '"'.$user['call_two_correct_use_of_action'].'",';
				$row .= '"'.$user['call_three_correct_use_of_action'].'",';
				$row .= '"'.$user['review_correct_use_of_action'].'",';
				$row .= '"'.$user['score_correct_use_of_action'].'",';
				$row .= '"'.$user['call_one_database_follow_up'].'",';
				$row .= '"'.$user['call_two_database_follow_up'].'",';
				$row .= '"'.$user['call_three_database_follow_up'].'",';
				$row .= '"'.$user['review_database_follow_up'].'",';
				$row .= '"'.$user['score_database_follow_up'].'",';
				$row .= '"'.$user['call_one_product_promotion'].'",';
				$row .= '"'.$user['call_two_product_promotion'].'",';
				$row .= '"'.$user['call_three_product_promotion'].'",';
				$row .= '"'.$user['review_product_promotion'].'",';
				$row .= '"'.$user['score_product_promotion'].'",';
				$row .= '"'.$user['call_one_reason_for_cancel'].'",';
				$row .= '"'.$user['call_two_reason_for_cancel'].'",';
				$row .= '"'.$user['call_three_reason_for_cancel'].'",';
				$row .= '"'.$user['review_reason_for_cancel'].'",';
				$row .= '"'.$user['score_reason_for_cancel'].'",';
				$row .= '"'.$user['call_one_legimate_sequence_offer'].'",';
				$row .= '"'.$user['call_two_legimate_sequence_offer'].'",';
				$row .= '"'.$user['call_three_legimate_sequence_offer'].'",';
				$row .= '"'.$user['review_legimate_sequence_offer'].'",';
				$row .= '"'.$user['score_legimate_sequence_offer'].'",';
				$row .= '"'.$user['call_one_first_retention_offer'].'",';
				$row .= '"'.$user['call_two_first_retention_offer'].'",';
				$row .= '"'.$user['call_three_first_retention_offer'].'",';
				$row .= '"'.$user['review_first_retention_offer'].'",';
				$row .= '"'.$user['score_first_retention_offer'].'",';
				$row .= '"'.$user['call_one_second_retention_offer'].'",';
				$row .= '"'.$user['call_two_second_retention_offer'].'",';
				$row .= '"'.$user['call_three_second_retention_offer'].'",';
				$row .= '"'.$user['review_second_retention_offer'].'",';
				$row .= '"'.$user['score_second_retention_offer'].'",';
				$row .= '"'.$user['call_one_valid_delay'].'",';
				$row .= '"'.$user['call_two_valid_delay'].'",';
				$row .= '"'.$user['call_three_valid_delay'].'",';
				$row .= '"'.$user['review_valid_delay'].'",';
				$row .= '"'.$user['score_valid_delay'].'",';
				$row .= '"'.$user['call_one_preserved_avg_unit'].'",';
				$row .= '"'.$user['call_two_preserved_avg_unit'].'",';
				$row .= '"'.$user['call_three_preserved_avg_unit'].'",';
				$row .= '"'.$user['review_preserved_avg_unit'].'",';
				$row .= '"'.$user['score_preserved_avg_unit'].'",';
				$row .= '"'.$user['call_one_proper_confirmation'].'",';
				$row .= '"'.$user['call_two_proper_confirmation'].'",';
				$row .= '"'.$user['call_three_proper_confirmation'].'",';
				$row .= '"'.$user['review_proper_confirmation'].'",';
				$row .= '"'.$user['score_proper_confirmation'].'",';
				$row .= '"'.$user['call_one_daily_special_offer'].'",';
				$row .= '"'.$user['call_two_daily_special_offer'].'",';
				$row .= '"'.$user['call_three_daily_special_offer'].'",';
				$row .= '"'.$user['review_daily_special_offer'].'",';
				$row .= '"'.$user['score_daily_special_offer'].'",';
				$row .= '"'.$user['call_one_anything_else'].'",';
				$row .= '"'.$user['call_two_anything_else'].'",';
				$row .= '"'.$user['call_three_anything_else'].'",';
				$row .= '"'.$user['review_anything_else'].'",';
				$row .= '"'.$user['score_anything_else'].'",';
				$row .= '"'.$user['call_one_thank_you'].'",';
				$row .= '"'.$user['call_two_thank_you'].'",';
				$row .= '"'.$user['call_three_thank_you'].'",';
				$row .= '"'.$user['review_thank_you'].'",';
				$row .= '"'.$user['score_thank_you'].'",';
				$row .= '"'.$user['call_one_mantained_call'].'",';
				$row .= '"'.$user['call_two_mantained_call'].'",';
				$row .= '"'.$user['call_three_mantained_call'].'",';
				$row .= '"'.$user['review_mantained_call'].'",';
				$row .= '"'.$user['score_mantained_call'].'",';
				$row .= '"'.$user['call_one_response_time'].'",';
				$row .= '"'.$user['call_two_response_time'].'",';
				$row .= '"'.$user['call_three_response_time'].'",';
				$row .= '"'.$user['review_response_time'].'",';
				$row .= '"'.$user['score_response_time'].'",';
				$row .= '"'.$user['call_one_proper_hold_technique'].'",';
				$row .= '"'.$user['call_two_proper_hold_technique'].'",';
				$row .= '"'.$user['call_three_proper_hold_technique'].'",';
				$row .= '"'.$user['review_proper_hold_technique'].'",';
				$row .= '"'.$user['score_proper_hold_technique'].'",';
				$row .= '"'.$user['call_one_good_attitude'].'",';
				$row .= '"'.$user['call_two_good_attitude'].'",';
				$row .= '"'.$user['call_three_good_attitude'].'",';
				$row .= '"'.$user['review_good_attitude'].'",';
				$row .= '"'.$user['score_good_attitude'].'",';
				$row .= '"'.$user['call_one_attentiveness'].'",';
				$row .= '"'.$user['call_two_attentiveness'].'",';
				$row .= '"'.$user['call_three_attentiveness'].'",';
				$row .= '"'.$user['review_attentiveness'].'",';
				$row .= '"'.$user['score_attentiveness'].'",';
				$row .= '"'.$user['call_one_context_related_response'].'",';
				$row .= '"'.$user['call_two_context_related_response'].'",';
				$row .= '"'.$user['call_three_context_related_response'].'",';
				$row .= '"'.$user['review_context_related_response'].'",';
				$row .= '"'.$user['score_context_related_response'].'",';
				$row .= '"'.$user['call_one_empathy'].'",';
				$row .= '"'.$user['call_two_empathy'].'",';
				$row .= '"'.$user['call_three_empathy'].'",';
				$row .= '"'.$user['review_empathy'].'",';
				$row .= '"'.$user['score_empathy'].'",';
				$row .= '"'.$user['call_one_badgering'].'",';
				$row .= '"'.$user['call_two_badgering'].'",';
				$row .= '"'.$user['call_three_badgering'].'",';
				$row .= '"'.$user['review_badgering'].'",';
				$row .= '"'.$user['score_badgering'].'",';
				$row .= '"'.$user['call_one_avg_call'].'",';
				$row .= '"'.$user['call_two_avg_call'].'",';
				$row .= '"'.$user['call_three_avg_call'].'",';
				$row .= '"'.$user['review_avg_call'].'",';
				$row .= '"'.$user['score_avg_call'].'",';
				$row .= '"'.$user['call_one_avg_save'].'",';
				$row .= '"'.$user['call_two_avg_save'].'",';
				$row .= '"'.$user['call_three_avg_save'].'",';
				$row .= '"'.$user['review_avg_save'].'",';
				$row .= '"'.$user['score_avg_save'].'",';
				$row .= '"'.$user['call_one_avg_call_length'].'",';
				$row .= '"'.$user['call_two_avg_call_length'].'",';
				$row .= '"'.$user['call_three_avg_call_length'].'",';
				$row .= '"'.$user['review_avg_call_length'].'",';
				$row .= '"'.$user['score_avg_call_length'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['call_summary'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['feedback'])).'",';
				$row .= '"'.$user['agent_rvw_date'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['agent_rvw_note'])).'",';
				$row .= '"'.$user['mgnt_rvw_date'].'",';
				$row .= '"'.$user['mgnt_rvw_name'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['mgnt_rvw_note'])).'"';

				fwrite($fopen,$row."\r\n");
			}
			fclose($fopen);
		
		}else if($pid=='puritycare_new'){
			foreach($rr as $user){
				$row = '"'.$user['auditor_name'].'",'; 
				$row .= '"'.$user['audit_date'].'",'; 
				$row .= '"'.$user['fusion_id'].'",'; 
				$row .= '"'.$user['fname']." ".$user['lname'].'",';
				$row .= '"'.$user['tl_name'].'",';
				$row .= '"'.$user['call_date'].'",';
				$row .= '"'.$user['file_no'].'",';
				$row .= '"'.$user['call_duration'].'",';
				$row .= '"'.$user['audit_type'].'",';
				$row .= '"'.$user['voc'].'",';
				$row .= '"'.$user['overall_score'].'%'.'",';
				$row .= '"'.$user['customer_address_verfication_call1'].'",';
				$row .= '"'.$user['customer_address_verfication_call2'].'",';
				$row .= '"'.$user['customer_address_verfication_call3'].'",';
				$row .= '"'.$user['script_compliance_call1'].'",';
				$row .= '"'.$user['script_compliance_call2'].'",';
				$row .= '"'.$user['script_compliance_call3'].'",';
				$row .= '"'.$user['opening_question_call1'].'",';
				$row .= '"'.$user['opening_question_call2'].'",';
				$row .= '"'.$user['opening_question_call3'].'",';
				$row .= '"'.$user['detail_note_call1'].'",';
				$row .= '"'.$user['detail_note_call2'].'",';
				$row .= '"'.$user['detail_note_call3'].'",';
				$row .= '"'.$user['correct_info_call1'].'",';
				$row .= '"'.$user['correct_info_call2'].'",';
				$row .= '"'.$user['correct_info_call3'].'",';
				$row .= '"'.$user['correct_reason_call1'].'",';
				$row .= '"'.$user['correct_reason_call2'].'",';
				$row .= '"'.$user['correct_reason_call3'].'",';
				$row .= '"'.$user['proper_terminilogy_call1'].'",';
				$row .= '"'.$user['proper_terminilogy_call2'].'",';
				$row .= '"'.$user['proper_terminilogy_call3'].'",';
				$row .= '"'.$user['proper_inquiry_call1'].'",';
				$row .= '"'.$user['proper_inquiry_call2'].'",';
				$row .= '"'.$user['proper_inquiry_call3'].'",';
				$row .= '"'.$user['product_promotion_call1'].'",';
				$row .= '"'.$user['product_promotion_call2'].'",';
				$row .= '"'.$user['product_promotion_call3'].'",';
				$row .= '"'.$user['company_promotion_call1'].'",';
				$row .= '"'.$user['company_promotion_call2'].'",';
				$row .= '"'.$user['company_promotion_call3'].'",';
				$row .= '"'.$user['database_followup_call1'].'",';
				$row .= '"'.$user['database_followup_call2'].'",';
				$row .= '"'.$user['database_followup_call3'].'",';
				$row .= '"'.$user['reason_cancel_call1'].'",';
				$row .= '"'.$user['reason_cancel_call2'].'",';
				$row .= '"'.$user['reason_cancel_call3'].'",';
				$row .= '"'.$user['1st_retention_call1'].'",';
				$row .= '"'.$user['1st_retention_call2'].'",';
				$row .= '"'.$user['1st_retention_call3'].'",';
				$row .= '"'.$user['two_tools_call1'].'",';
				$row .= '"'.$user['two_tools_call2'].'",';
				$row .= '"'.$user['two_tools_call3'].'",';
				$row .= '"'.$user['sequence_offers_call1'].'",';
				$row .= '"'.$user['sequence_offers_call2'].'",';
				$row .= '"'.$user['sequence_offers_call3'].'",';
				$row .= '"'.$user['2nd_retention_call1'].'",';
				$row .= '"'.$user['2nd_retention_call2'].'",';
				$row .= '"'.$user['2nd_retention_call3'].'",';
				$row .= '"'.$user['bottles_call1'].'",';
				$row .= '"'.$user['bottles_call2'].'",';
				$row .= '"'.$user['bottles_call3'].'",';
				$row .= '"'.$user['correct_delay_call1'].'",';
				$row .= '"'.$user['correct_delay_call2'].'",';
				$row .= '"'.$user['correct_delay_call3'].'",';
				$row .= '"'.$user['complete_recap_call1'].'",';
				$row .= '"'.$user['complete_recap_call2'].'",';
				$row .= '"'.$user['complete_recap_call3'].'",';
				$row .= '"'.$user['question_call1'].'",';
				$row .= '"'.$user['question_call2'].'",';
				$row .= '"'.$user['question_call3'].'",';
				$row .= '"'.$user['special_offer_call1'].'",';
				$row .= '"'.$user['special_offer_call2'].'",';
				$row .= '"'.$user['special_offer_call3'].'",';
				$row .= '"'.$user['thank_you_call1'].'",';
				$row .= '"'.$user['thank_you_call2'].'",';
				$row .= '"'.$user['thank_you_call3'].'",';
				$row .= '"'.$user['call_control_call1'].'",';
				$row .= '"'.$user['call_control_call2'].'",';
				$row .= '"'.$user['call_control_call3'].'",';
				$row .= '"'.$user['hold_technique_call1'].'",';
				$row .= '"'.$user['hold_technique_call2'].'",';
				$row .= '"'.$user['hold_technique_call3'].'",';
				$row .= '"'.$user['dead_air_call1'].'",';
				$row .= '"'.$user['dead_air_call2'].'",';
				$row .= '"'.$user['dead_air_call3'].'",';
				$row .= '"'.$user['used_dead_call1'].'",';
				$row .= '"'.$user['used_dead_call2'].'",';
				$row .= '"'.$user['used_dead_call3'].'",';
				$row .= '"'.$user['good_attitude_call1'].'",';
				$row .= '"'.$user['good_attitude_call2'].'",';
				$row .= '"'.$user['good_attitude_call3'].'",';
				$row .= '"'.$user['context_related_call1'].'",';
				$row .= '"'.$user['context_related_call2'].'",';
				$row .= '"'.$user['context_related_call3'].'",';
				$row .= '"'.$user['enthusiasm_call1'].'",';
				$row .= '"'.$user['enthusiasm_call2'].'",';
				$row .= '"'.$user['enthusiasm_call3'].'",';
				$row .= '"'.$user['respectful_call1'].'",';
				$row .= '"'.$user['respectful_call2'].'",';
				$row .= '"'.$user['respectful_call3'].'",';
				$row .= '"'.$user['call_length_call1'].'",';
				$row .= '"'.$user['call_length_call2'].'",';
				$row .= '"'.$user['call_length_call3'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['call_summary'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['feedback'])).'",';
				$row .= '"'.$user['agent_rvw_date'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['agent_rvw_note'])).'",';
				$row .= '"'.$user['mgnt_rvw_date'].'",';
				$row .= '"'.$user['mgnt_rvw_name'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['mgnt_rvw_note'])).'"';

				fwrite($fopen,$row."\r\n");
			}
			fclose($fopen);
		
		}else if($pid=='touchfuse'){
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
				$row .= '"'.$user['call_date'].'",';
				$row .= '"'.$user['call_duration'].'",';
				$row .= '"'.$user['file_no'].'",';
				$row .= '"'.$user['call_status'].'",';
				$row .= '"'.$user['audit_type'].'",';
				$row .= '"'.$user['voc'].'",';
				$row .= '"'.$user['audit_start_time'].'",';
				$row .= '"'.$user['entry_date'].'",';
				$row .= '"'.$interval1.'",';
				$row .= '"'.$user['overall_score'].'%'.'",';
				$row .= '"'.$user['callasnwer'].'",';
				$row .= '"'.$user['agentanswer'].'",';
				$row .= '"'.$user['agentzip'].'",';
				$row .= '"'.$user['agentoffer'].'",';
				$row .= '"'.$user['callerwish'].'",';
				$row .= '"'.$user['agentconfirm'].'",';
				$row .= '"'.$user['calleraddress'].'",';
				$row .= '"'.$user['calleremail'].'",';
				$row .= '"'.$user['agentphone'].'",';
				$row .= '"'.$user['agentsummerize'].'",';
				$row .= '"'.$user['registerguest'].'",';
				$row .= '"'.$user['dispocall'].'",';
				$row .= '"'.$user['agentclosing'].'",';
				$row .= '"'.$user['agenttone'].'",';
				$row .= '"'.$user['activelistening'].'",';
				$row .= '"'.$user['agentprofession'].'",';
				$row .= '"'.$user['agentknowledge'].'",';
				$row .= '"'.$user['callcontrol'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['call_summary'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['feedback'])).'",';
				$row .= '"'.$user['agnt_fd_acpt'].'",';
				$row .= '"'.$user['agent_rvw_date'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['agent_rvw_note'])).'",';
				$row .= '"'.$user['mgnt_rvw_date'].'",';
				$row .= '"'.$user['mgnt_rvw_name'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['mgnt_rvw_note'])).'"';
				
				fwrite($fopen,$row."\r\n");
			}
			fclose($fopen);
		
		}else if($pid=='tbn'){
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
				$row .= '"'.$user['call_date'].'",';
				$row .= '"'.$user['file_no'].'",';
				$row .= '"'.$user['call_duration'].'",';
				$row .= '"'.$user['call_id'].'",';
				$row .= '"'.$user['audit_type'].'",';
				$row .= '"'.$user['voc'].'",';
				$row .= '"'.$user['audit_start_time'].'",';
				$row .= '"'.$user['entry_date'].'",';
				$row .= '"'.$interval1.'",';
				$row .= '"'.$user['overall_score'].'%'.'",';
				$row .= '"'.$user['introrecord'].'",';
				$row .= '"'.$user['introcall'].'",';
				$row .= '"'.$user['introname'].'",';
				$row .= '"'.$user['introstate'].'",';
				$row .= '"'.$user['introscript'].'",';
				$row .= '"'.$user['introdisclose'].'",';
				$row .= '"'.$user['verifydonor'].'",';
				$row .= '"'.$user['verifyaddress'].'",';
				$row .= '"'.$user['verifyspelled'].'",';
				$row .= '"'.$user['verifyemail'].'",';
				$row .= '"'.$user['verifyback'].'",';
				$row .= '"'.$user['verifyasked'].'",';
				$row .= '"'.$user['verifyconfirm'].'",';
				$row .= '"'.$user['verifytype'].'",';
				$row .= '"'.$user['verifycell'].'",';
				$row .= '"'.$user['verifyaskalterphn'].'",';
				$row .= '"'.$user['verifyalterphn'].'",';
				$row .= '"'.$user['verifyalterno'].'",';
				$row .= '"'.$user['verifyconsent'].'",';
				$row .= '"'.$user['presentrequest'].'",';
				$row .= '"'.$user['presenttieroffer'].'",';
				$row .= '"'.$user['presentmonthask'].'",';
				$row .= '"'.$user['presentnavigate'].'",';
				$row .= '"'.$user['presenttbnknowledge'].'",';
				$row .= '"'.$user['presentauthor'].'",';
				$row .= '"'.$user['presentadherence'].'",';
				$row .= '"'.$user['cartclosedonation'].'",';
				$row .= '"'.$user['cartcloseamount'].'",';
				$row .= '"'.$user['cartclosemonthly'].'",';
				$row .= '"'.$user['cartcloseresource'].'",';
				$row .= '"'.$user['cartclosescript'].'",';
				$row .= '"'.$user['callhandleclearly'].'",';
				$row .= '"'.$user['callhandledemeanor'].'",';
				$row .= '"'.$user['callhandlepace'].'",';
				$row .= '"'.$user['callhandlelisten'].'",';
				$row .= '"'.$user['callhandleexhibit'].'",';
				$row .= '"'.$user['callhandlecommunicate'].'",';
				$row .= '"'.$user['callhandlecontrol'].'",';
				$row .= '"'.$user['autofinfo'].'",';
				$row .= '"'.$user['autofcall'].'",';
				$row .= '"'.$user['autofbehaviour'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['call_summary'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['feedback'])).'",';
				$row .= '"'.$user['agnt_fd_acpt'].'",';
				$row .= '"'.$user['agent_rvw_date'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['agent_rvw_note'])).'",';
				$row .= '"'.$user['mgnt_rvw_date'].'",';
				$row .= '"'.$user['mgnt_rvw_name'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['mgnt_rvw_note'])).'"';
				
				fwrite($fopen,$row."\r\n");
			}
			fclose($fopen);
		
		}else if($pid=='jfmi'){
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
				$row .= '"'.$user['call_date'].'",';
				$row .= '"'.$user['call_duration'].'",';
				$row .= '"'.$user['audit_type'].'",';
				$row .= '"'.$user['voc'].'",';
				$row .= '"'.$user['audit_start_time'].'",';
				$row .= '"'.$user['entry_date'].'",';
				$row .= '"'.$interval1.'",';
				$row .= '"'.$user['overall_score'].'%'.'",';
				$row .= '"'.$user['greets_customer_promptly'].'",';
				$row .= '"'.$user['uses_professionalism'].'",';
				$row .= '"'.$user['shows_gratitude'].'",';
				$row .= '"'.$user['collects_and_verifies_customer_information'].'",';
				$row .= '"'.$user['follows_correct_scripting_path'].'",';
				$row .= '"'.$user['collects_information_to_provide_to_partner_relations'].'",';
				$row .= '"'.$user['covers_all_payment_scripting'].'",';
				$row .= '"'.$user['maintains_call_control'].'",';
				$row .= '"'.$user['keeps_dead_air_to_minimum'].'",';
				$row .= '"'.$user['uses_faq_agent_note'].'",';
				$row .= '"'.$user['brands_the_call_with_proper_close'].'",';
				$row .= '"'.$user['stop_recording'].'",';
				$row .= '"'.$user['read_legal_script'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['call_summary'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['feedback'])).'",';
				$row .= '"'.$user['agnt_fd_acpt'].'",';
				$row .= '"'.$user['agent_rvw_date'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['agent_rvw_note'])).'",';
				$row .= '"'.$user['mgnt_rvw_date'].'",';
				$row .= '"'.$user['mgnt_rvw_name'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['mgnt_rvw_note'])).'"';
				
				fwrite($fopen,$row."\r\n");
			}
			fclose($fopen);
			
		}else if($pid=='hoveround'){
		
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
				$row .= '"'.$user['call_date'].'",';
				$row .= '"'.$user['call_duration'].'",';
				$row .= '"'.$user['file_no'].'",';
				$row .= '"'.$user['audit_type'].'",';
				$row .= '"'.$user['voc'].'",';
				$row .= '"'.$user['audit_start_time'].'",';
				$row .= '"'.$user['entry_date'].'",';
				$row .= '"'.$interval1.'",';
				$row .= '"'.$user['overall_score'].'%'.'",';
				$row .= '"'.$user['agentreadyforcall'].'",';
				$row .= '"'.$user['agentgiveintro'].'",';
				$row .= '"'.$user['agentcorrectprobe'].'",';
				$row .= '"'.$user['agentverifycustomer'].'",';
				$row .= '"'.$user['agentclosecall'].'",';
				$row .= '"'.$user['agentdisposition'].'",';
				$row .= '"'.$user['agentpolite'].'",';
				$row .= '"'.$user['agentshowenergy'].'",';
				$row .= '"'.$user['agenthavegoodtone'].'",';
				$row .= '"'.$user['agentgiveaccurateinfo'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['call_summary'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['feedback'])).'",';
				$row .= '"'.$user['agnt_fd_acpt'].'",';
				$row .= '"'.$user['agent_rvw_date'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['agent_rvw_note'])).'",';
				$row .= '"'.$user['mgnt_rvw_date'].'",';
				$row .= '"'.$user['mgnt_rvw_name'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['mgnt_rvw_note'])).'"';
				
				fwrite($fopen,$row."\r\n");
			}
			fclose($fopen);
		
		}else if($pid=='ncpssm'){
		
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
				$row .= '"'.$user['call_date'].'",';
				$row .= '"'.$user['call_duration'].'",';
				$row .= '"'.$user['file_no'].'",';
				$row .= '"'.$user['audit_type'].'",';
				$row .= '"'.$user['voc'].'",';
				$row .= '"'.$user['audit_start_time'].'",';
				$row .= '"'.$user['entry_date'].'",';
				$row .= '"'.$interval1.'",';
				$row .= '"'.$user['overall_score'].'%'.'",';
				$row .= '"'.$user['introcaller'].'",';
				$row .= '"'.$user['introopenning'].'",';
				$row .= '"'.$user['scriptgathered'].'",';
				$row .= '"'.$user['scriptemail'].'",';
				$row .= '"'.$user['scriptstatement'].'",';
				$row .= '"'.$user['scriptmedicareissue'].'",';
				$row .= '"'.$user['scriptpersonalizecall'].'",';
				$row .= '"'.$user['scriptcallersupport'].'",';
				$row .= '"'.$user['toneenthusiasm'].'",';
				$row .= '"'.$user['toneproperpace'].'",';
				$row .= '"'.$user['tonecontroldeadair'].'",';
				$row .= '"'.$user['tonespokeclearly'].'",';
				$row .= '"'.$user['tonegoodlistening'].'",';
				$row .= '"'.$user['toneempathized'].'",';
				$row .= '"'.$user['toneprofessionalism'].'",';
				$row .= '"'.$user['closecallconslusion'].'",';
				$row .= '"'.$user['closecorrectinfo'].'",';
				$row .= '"'.$user['closeconfirmcaller'].'",';
				$row .= '"'.$user['autofailinfo'].'",';
				$row .= '"'.$user['autofailhungup'].'",';
				$row .= '"'.$user['autofailbehaviour'].'",';
				$row .= '"'.$user['autofaillanguage'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['call_summary'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['feedback'])).'",';
				$row .= '"'.$user['agnt_fd_acpt'].'",';
				$row .= '"'.$user['agent_rvw_date'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['agent_rvw_note'])).'",';
				$row .= '"'.$user['mgnt_rvw_date'].'",';
				$row .= '"'.$user['mgnt_rvw_name'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['mgnt_rvw_note'])).'"';
				
				fwrite($fopen,$row."\r\n");
			}
			fclose($fopen);
		
		}else if($pid=='stc'){
		
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
				$row .= '"'.$user['call_date'].'",';
				$row .= '"'.$user['call_duration'].'",';
				$row .= '"'.$user['file_no'].'",';
				$row .= '"'.$user['audit_type'].'",';
				$row .= '"'.$user['voc'].'",';
				$row .= '"'.$user['audit_start_time'].'",';
				$row .= '"'.$user['entry_date'].'",';
				$row .= '"'.$interval1.'",';
				$row .= '"'.$user['overall_score'].'%'.'",';
				$row .= '"'.$user['agentproperintro'].'",';
				$row .= '"'.$user['agentcapturedonorname'].'",';
				$row .= '"'.$user['agentreadscript'].'",';
				$row .= '"'.$user['agentcovermonthlyrequest'].'",';
				$row .= '"'.$user['agentcapturedonationamount'].'",';
				$row .= '"'.$user['agentofferpayment'].'",';
				$row .= '"'.$user['agentcapturedonoraddress'].'",';
				$row .= '"'.$user['agentcapturedonorphone'].'",';
				$row .= '"'.$user['agentcapturedonoremail'].'",';
				$row .= '"'.$user['agentproperlyrebuttals'].'",';
				$row .= '"'.$user['agentfollowscript'].'",';
				$row .= '"'.$user['agentshowfamiliarity'].'",';
				$row .= '"'.$user['agentusescriptnavigation'].'",';
				$row .= '"'.$user['agentfollowproperclose'].'",';
				$row .= '"'.$user['agentuseeffectivecommunication'].'",';
				$row .= '"'.$user['agentmaintaincontrol'].'",';
				$row .= '"'.$user['agentshowappreciation'].'",';
				$row .= '"'.$user['autofailfalseinfo'].'",';
				$row .= '"'.$user['autofailhungup'].'",';
				$row .= '"'.$user['autofailagentbehaviuor'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['call_summary'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['feedback'])).'",';
				$row .= '"'.$user['agnt_fd_acpt'].'",';
				$row .= '"'.$user['agent_rvw_date'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['agent_rvw_note'])).'",';
				$row .= '"'.$user['mgnt_rvw_date'].'",';
				$row .= '"'.$user['mgnt_rvw_name'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['mgnt_rvw_note'])).'"';
				
				fwrite($fopen,$row."\r\n");
			}
			fclose($fopen);
			
		}else if($pid=='tpm'){
		
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
				$row .= '"'.$user['call_date'].'",';
				$row .= '"'.$user['call_duration'].'",';
				$row .= '"'.$user['file_no'].'",';
				$row .= '"'.$user['audit_type'].'",';
				$row .= '"'.$user['voc'].'",';
				$row .= '"'.$user['audit_start_time'].'",';
				$row .= '"'.$user['entry_date'].'",';
				$row .= '"'.$interval1.'",';
				$row .= '"'.$user['overall_score'].'%'.'",';
				$row .= '"'.$user['introcall'].'",';
				$row .= '"'.$user['verifycall'].'",';
				$row .= '"'.$user['verifypayment'].'",';
				$row .= '"'.$user['verifycommunicator'].'",';
				$row .= '"'.$user['verifyspelledname'].'",';
				$row .= '"'.$user['verifyaskedaddress'].'",';
				$row .= '"'.$user['verifyspelledaddress'].'",';
				$row .= '"'.$user['verifyaskedphone'].'",';
				$row .= '"'.$user['verifycommunicatorphone'].'",';
				$row .= '"'.$user['verifylandline'].'",';
				$row .= '"'.$user['verifycallverbatim'].'",';
				$row .= '"'.$user['verifytextverbatim'].'",';
				$row .= '"'.$user['verifyaskedemail'].'",';
				$row .= '"'.$user['verifyspelledemail'].'",';
				$row .= '"'.$user['scriptadherence'].'",';
				$row .= '"'.$user['scripthighertier'].'",';
				$row .= '"'.$user['scriptnavigate'].'",';
				$row .= '"'.$user['scriptdisplaytpm'].'",';
				$row .= '"'.$user['closedcontent'].'",';
				$row .= '"'.$user['closedmonthlyask'].'",';
				$row .= '"'.$user['closedshippingtime'].'",';
				$row .= '"'.$user['closedprovidecart'].'",';
				$row .= '"'.$user['closedreadscript'].'",';
				$row .= '"'.$user['callhandlespeakclearly'].'",';
				$row .= '"'.$user['callhandledemeanor'].'",';
				$row .= '"'.$user['callhandleprofesionalism'].'",';
				$row .= '"'.$user['callhandlepace'].'",';
				$row .= '"'.$user['callhandleresponds'].'",';
				$row .= '"'.$user['callhandleemphaty'].'",';
				$row .= '"'.$user['callhandledonor'].'",';
				$row .= '"'.$user['callhandletalktime'].'",';
				$row .= '"'.$user['autofinfo'].'",';
				$row .= '"'.$user['autofhungup'].'",';
				$row .= '"'.$user['autofrude'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['call_summary'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['feedback'])).'",';
				$row .= '"'.$user['agnt_fd_acpt'].'",';
				$row .= '"'.$user['agent_rvw_date'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['agent_rvw_note'])).'",';
				$row .= '"'.$user['mgnt_rvw_date'].'",';
				$row .= '"'.$user['mgnt_rvw_name'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['mgnt_rvw_note'])).'"';
				
				fwrite($fopen,$row."\r\n");
			}
			fclose($fopen);
			
		}else if($pid=='patchology'){
		
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
				$row .= '"'.$user['call_date'].'",';
				$row .= '"'.$user['call_duration'].'",';
				$row .= '"'.$user['file_no'].'",';
				$row .= '"'.$user['audit_type'].'",';
				$row .= '"'.$user['voc'].'",';
				$row .= '"'.$user['audit_start_time'].'",';
				$row .= '"'.$user['entry_date'].'",';
				$row .= '"'.$interval1.'",';
				$row .= '"'.$user['overall_score'].'%'.'",';
				$row .= '"'.$user['agentcallopening'].'",';
				$row .= '"'.$user['agentclosecall'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['remarks1'])).'",';
				$row .= '"'.$user['agentverifyinformation'].'",';
				$row .= '"'.$user['agentprovideinformation'].'",';
				$row .= '"'.$user['agenthippinginformation'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['remarks2'])).'",';
				$row .= '"'.$user['callanswertimely'].'",';
				$row .= '"'.$user['agentengagedcustomer'].'",';
				$row .= '"'.$user['customersatisfaction'].'",';
				$row .= '"'.$user['escalatedresources'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['remarks3'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['call_summary'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['feedback'])).'",';
				$row .= '"'.$user['agnt_fd_acpt'].'",';
				$row .= '"'.$user['agent_rvw_date'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['agent_rvw_note'])).'",';
				$row .= '"'.$user['mgnt_rvw_date'].'",';
				$row .= '"'.$user['mgnt_rvw_name'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['mgnt_rvw_note'])).'"';
				
				fwrite($fopen,$row."\r\n");
			}
			fclose($fopen);	
			
		}else if($pid=='aspca'){
		
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
				$row .= '"'.$user['call_date'].'",';
				$row .= '"'.$user['call_duration'].'",';
				$row .= '"'.$user['file_no'].'",';
				$row .= '"'.$user['audit_type'].'",';
				$row .= '"'.$user['voc'].'",';
				$row .= '"'.$user['audit_start_time'].'",';
				$row .= '"'.$user['entry_date'].'",';
				$row .= '"'.$interval1.'",';
				$row .= '"'.$user['overall_score'].'%'.'",';
				$row .= '"'.$user['Greet_customer'].'",';
				$row .= '"'.$user['Uses_professionalism'].'",';
				$row .= '"'.$user['Shows_gratitude'].'",';
				$row .= '"'.$user['Collects_verifies'].'",';
				$row .= '"'.$user['guardians_program'].'",';
				$row .= '"'.$user['monthly_guardian'].'",';
				$row .= '"'.$user['gift_scripting'].'",';
				$row .= '"'.$user['payment_scripting'].'",';
				$row .= '"'.$user['Animal_champion'].'",';
				$row .= '"'.$user['donation_processing'].'",';
				$row .= '"'.$user['onetime_donation'].'",';
				$row .= '"'.$user['pet_insurance'].'",';
				$row .= '"'.$user['correct_script'].'",';
				$row .= '"'.$user['call_control'].'",';
				$row .= '"'.$user['min_deadair'].'",';
				$row .= '"'.$user['faq'].'",';
				$row .= '"'.$user['personalizes_call'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['call_summary'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['feedback'])).'",';
				$row .= '"'.$user['agnt_fd_acpt'].'",';
				$row .= '"'.$user['agent_rvw_date'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['agent_rvw_note'])).'",';
				$row .= '"'.$user['mgnt_rvw_date'].'",';
				$row .= '"'.$user['mgnt_rvw_name'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['mgnt_rvw_note'])).'"';
				
				fwrite($fopen,$row."\r\n");
			}
			fclose($fopen);
		
		}else if($pid=='ffai'){
		
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
				$row .= '"'.$user['call_date'].'",';
				$row .= '"'.$user['call_duration'].'",';
				$row .= '"'.$user['file_no'].'",';
				$row .= '"'.$user['audit_type'].'",';
				$row .= '"'.$user['voc'].'",';
				$row .= '"'.$user['audit_start_time'].'",';
				$row .= '"'.$user['entry_date'].'",';
				$row .= '"'.$interval1.'",';
				$row .= '"'.$user['overall_score'].'%'.'",';
				$row .= '"'.$user['open_call_appropriate_branding'].'",';
				$row .= '"'.$user['close_call_appropriate_branding'].'",';
				$row .= '"'.$user['before_with_filtersfast'].'",';
				$row .= '"'.$user['address_using_nato'].'",';
				$row .= '"'.$user['products_availability'].'",';
				$row .= '"'.$user['one_call_resolution'].'",';
				$row .= '"'.$user['agent_accurately_clearly'].'",';
				$row .= '"'.$user['agent_engaged_customer'].'",';
				$row .= '"'.$user['membership'].'",';
				$row .= '"'.$user['offer_donation'].'",';
				$row .= '"'.$user['explored_before_transferring'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['call_summary'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['feedback'])).'",';
				$row .= '"'.$user['agnt_fd_acpt'].'",';
				$row .= '"'.$user['agent_rvw_date'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['agent_rvw_note'])).'",';
				$row .= '"'.$user['mgnt_rvw_date'].'",';
				$row .= '"'.$user['mgnt_rvw_name'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['mgnt_rvw_note'])).'"';
				
				fwrite($fopen,$row."\r\n");
			}
			fclose($fopen);
			
		}else if($pid=='lifi'){
		
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
				$row .= '"'.$user['call_date'].'",';
				$row .= '"'.$user['call_duration'].'",';
				$row .= '"'.$user['file_no'].'",';
				$row .= '"'.$user['audit_type'].'",';
				$row .= '"'.$user['voc'].'",';
				$row .= '"'.$user['audit_start_time'].'",';
				$row .= '"'.$user['entry_date'].'",';
				$row .= '"'.$interval1.'",';
				$row .= '"'.$user['overall_score'].'%'.'",';
				$row .= '"'.$user['life_quotes_greeting'].'",';
				$row .= '"'.$user['agent_positive_response'].'",';
				$row .= '"'.$user['customer_name_capture'].'",';
				$row .= '"'.$user['capture_address'].'",';
				$row .= '"'.$user['phone_number_confirmation'].'",';
				$row .= '"'.$user['email_Address'].'",';
				$row .= '"'.$user['customer_dob'].'",';
				$row .= '"'.$user['script_adherence'].'",';
				$row .= '"'.$user['coverage_amount_insurance'].'",';
				$row .= '"'.$user['tobacco_smoking'].'",';
				$row .= '"'.$user['height_weight_customer'].'",';
				$row .= '"'.$user['mention_price_comparison'].'",';
				$row .= '"'.$user['overall_confidence_level'].'",';
				$row .= '"'.$user['call_closing'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['call_summary'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['feedback'])).'",';
				$row .= '"'.$user['agnt_fd_acpt'].'",';
				$row .= '"'.$user['agent_rvw_date'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['agent_rvw_note'])).'",';
				$row .= '"'.$user['mgnt_rvw_date'].'",';
				$row .= '"'.$user['mgnt_rvw_name'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['mgnt_rvw_note'])).'"';
				
				fwrite($fopen,$row."\r\n");
			}
			fclose($fopen);
		
		}else if($pid=='heatsurge'){
		
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
				$row .= '"'.$user['call_date'].'",';
				$row .= '"'.$user['call_duration'].'",';
				$row .= '"'.$user['file_no'].'",';
				$row .= '"'.$user['audit_type'].'",';
				$row .= '"'.$user['voc'].'",';
				$row .= '"'.$user['audit_start_time'].'",';
				$row .= '"'.$user['entry_date'].'",';
				$row .= '"'.$interval1.'",';
				$row .= '"'.$user['overall_score'].'%'.'",';
				$row .= '"'.$user['callprepared5sec'].'",';
				$row .= '"'.$user['useibobgreeting'].'",';
				$row .= '"'.$user['accesscustomeraccount'].'",';
				$row .= '"'.$user['vreifynameaddress'].'",';
				$row .= '"'.$user['askforemail'].'",';
				$row .= '"'.$user['readminiMiranda'].'",';
				$row .= '"'.$user['giveaccuratepricing'].'",';
				$row .= '"'.$user['giveaccurateshiping'].'",';
				$row .= '"'.$user['accuratedescribeproduct'].'",';
				$row .= '"'.$user['askforupsellproduct'].'",';
				$row .= '"'.$user['provideappropiatesolution'].'",';
				$row .= '"'.$user['codedordercorrectly'].'",';
				$row .= '"'.$user['askforcancelarion'].'",';
				$row .= '"'.$user['usePKkeybuying'].'",';
				$row .= '"'.$user['useappropiateguideline'].'",';
				$row .= '"'.$user['askforbillingname'].'",';
				$row .= '"'.$user['authorizeuserofcheck'].'",';
				$row .= '"'.$user['billingaddressforpayment'].'",';
				$row .= '"'.$user['permissiontoauthorizepayment'].'",';
				$row .= '"'.$user['vrifyshippingaddress'].'",';
				$row .= '"'.$user['accountwithissue'].'",';
				$row .= '"'.$user['summarizesreviewcall'].'",';
				$row .= '"'.$user['gaveCSphonenumber'].'",';
				$row .= '"'.$user['wasagentpolite'].'",';
				$row .= '"'.$user['usinginappropiatecomment'].'",';
				$row .= '"'.$user['usesholdtrasferproperly'].'",';
				$row .= '"'.$user['automaticzero'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['call_summary'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['feedback'])).'",';
				$row .= '"'.$user['agnt_fd_acpt'].'",';
				$row .= '"'.$user['agent_rvw_date'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['agent_rvw_note'])).'",';
				$row .= '"'.$user['mgnt_rvw_date'].'",';
				$row .= '"'.$user['mgnt_rvw_name'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['mgnt_rvw_note'])).'"';
				
				fwrite($fopen,$row."\r\n");
			}
			fclose($fopen);	
			
		}else if($pid=='stauers_sales'){
		
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
				$row .= '"'.$user['call_date'].'",';
				$row .= '"'.$user['call_duration'].'",';
				$row .= '"'.$user['file_no'].'",';
				$row .= '"'.$user['audit_type'].'",';
				$row .= '"'.$user['voc'].'",';
				$row .= '"'.$user['audit_start_time'].'",';
				$row .= '"'.$user['entry_date'].'",';
				$row .= '"'.$interval1.'",';
				$row .= '"'.$user['overall_score'].'%'.'",';
				$row .= '"'.$user['call_answered_5_seconds'].'",';
				$row .= '"'.$user['agent_verify_customer_name_address'].'",';
				$row .= '"'.$user['agent_capture_correct_offer'].'",';
				$row .= '"'.$user['agent_verify_phone_number'].'",';
				$row .= '"'.$user['agent_verify_customer_email'].'",';
				$row .= '"'.$user['agent_compliment_caller_purchase'].'",';
				$row .= '"'.$user['agent_recap_item'].'",';
				$row .= '"'.$user['agent_cover_one_upsell'].'",';
				$row .= '"'.$user['agent_cover_replacement'].'",';
				$row .= '"'.$user['agent_appropriate_rebuttal'].'",';
				$row .= '"'.$user['agent_cover_membership'].'",';
				$row .= '"'.$user['agent_appropriate_rebuttal_declined'].'",';
				$row .= '"'.$user['agent_offer_membership'].'",';
				$row .= '"'.$user['agent_cover_autorenew'].'",';
				$row .= '"'.$user['shipping_address_verified'].'",';
				$row .= '"'.$user['quote_correct_delivery_time'].'",';
				$row .= '"'.$user['agent_total_product_appropriately'].'",';
				$row .= '"'.$user['agent_quote_shipping_taxes'].'",';
				$row .= '"'.$user['agent_give_total_charged'].'",';
				$row .= '"'.$user['agent_provide_order_number'].'",';
				$row .= '"'.$user['agent_close_call_brand_correctly'].'",';
				$row .= '"'.$user['customer_satisfied_experience'].'",';
				$row .= '"'.$user['customer_dissatisfied_professionalism'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['call_summary'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['feedback'])).'",';
				$row .= '"'.$user['agnt_fd_acpt'].'",';
				$row .= '"'.$user['agent_rvw_date'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['agent_rvw_note'])).'",';
				$row .= '"'.$user['mgnt_rvw_date'].'",';
				$row .= '"'.$user['mgnt_rvw_name'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['mgnt_rvw_note'])).'"';
				
				fwrite($fopen,$row."\r\n");
			}
			fclose($fopen);	
			
		}else if($pid=='operation_smile'){
		
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
				$row .= '"'.$user['call_date'].'",';
				$row .= '"'.$user['call_duration'].'",';
				$row .= '"'.$user['file_no'].'",';
				$row .= '"'.$user['audit_type'].'",';
				$row .= '"'.$user['voc'].'",';
				$row .= '"'.$user['audit_start_time'].'",';
				$row .= '"'.$user['entry_date'].'",';
				$row .= '"'.$interval1.'",';
				$row .= '"'.$user['overall_score'].'%'.'",';
				$row .= '"'.$user['agentreadytohandle'].'",';
				$row .= '"'.$user['agentgreetthecaller'].'",';
				$row .= '"'.$user['agentconfirminfo'].'",';
				$row .= '"'.$user['agentshowgraduate'].'",';
				$row .= '"'.$user['agentuserebuttals'].'",';
				$row .= '"'.$user['agentofferupsell'].'",';
				$row .= '"'.$user['agentfollowscript'].'",';
				$row .= '"'.$user['agentaddressquestion'].'",';
				$row .= '"'.$user['agentspeakenergy'].'",';
				$row .= '"'.$user['agentuseproperpacing'].'",';
				$row .= '"'.$user['agentmaintaincontrol'].'",';
				$row .= '"'.$user['agentprofessionalspeak'].'",';
				$row .= '"'.$user['agentgoodlistening'].'",';
				$row .= '"'.$user['agentempathize'].'",';
				$row .= '"'.$user['agentprovidedonor'].'",';
				$row .= '"'.$user['agnetaskprompted'].'",';
				$row .= '"'.$user['agentthankcaller'].'",';
				$row .= '"'.$user['agentgaveinformation'].'",';
				$row .= '"'.$user['agenthangup'].'",';
				$row .= '"'.$user['agentlaguage'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['call_summary'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['feedback'])).'",';
				$row .= '"'.$user['agnt_fd_acpt'].'",';
				$row .= '"'.$user['agent_rvw_date'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['agent_rvw_note'])).'",';
				$row .= '"'.$user['mgnt_rvw_date'].'",';
				$row .= '"'.$user['mgnt_rvw_name'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['mgnt_rvw_note'])).'"';
				
				fwrite($fopen,$row."\r\n");
			}
			fclose($fopen);	
			
		}else if($pid=='5_11_tactical'){ 
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
				$row .= '"'.$user['call_date'].'",';
				$row .= '"'.$user['call_duration'].'",';
				$row .= '"'.$user['file_no'].'",';
				$row .= '"'.$user['audit_type'].'",';
				$row .= '"'.$user['voc'].'",';
				$row .= '"'.$user['audit_start_time'].'",';
				$row .= '"'.$user['entry_date'].'",';
				$row .= '"'.$interval1.'",';
				$row .= '"'.$user['overall_score'].'%'.'",';
				$row .= '"'.$user['greetthecustomer'].'",';
				$row .= '"'.$user['customeritemtoorder'].'",';
				$row .= '"'.$user['wouldaddyourorder'].'",';
				$row .= '"'.$user['customerlogininformation'].'",';
				$row .= '"'.$user['callerinformationaccuracy'].'",';
				$row .= '"'.$user['coverfinalconfirmation'].'",';
				$row .= '"'.$user['givecustomerordernumber'].'",';
				$row .= '"'.$user['userapplicablesearch'].'",';
				$row .= '"'.$user['coverreturnprocess'].'",';
				$row .= '"'.$user['coverexchangeprocess'].'",';
				$row .= '"'.$user['coverrefundprocess'].'",';
				$row .= '"'.$user['trackthepackage'].'",';
				$row .= '"'.$user['agentaskforassist'].'",';
				$row .= '"'.$user['agentbrandthecall'].'",';
				$row .= '"'.$user['answerquestions'].'",';
				$row .= '"'.$user['maintaincallcontrol'].'",';
				$row .= '"'.$user['properlynotateAX'].'",';
				$row .= '"'.$user['escalationwaranted'].'",';
				$row .= '"'.$user['agentdispositioncall'].'",';
				$row .= '"'.$user['maintainprofessionalism'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['call_summary'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['feedback'])).'",';
				$row .= '"'.$user['agnt_fd_acpt'].'",';
				$row .= '"'.$user['agent_rvw_date'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['agent_rvw_note'])).'",';
				$row .= '"'.$user['mgnt_rvw_date'].'",';
				$row .= '"'.$user['mgnt_rvw_name'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['mgnt_rvw_note'])).'"';
				
				fwrite($fopen,$row."\r\n");
			}
			fclose($fopen);	
			
		}else if($pid=='jmmi'){
		
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
				$row .= '"'.$user['call_date'].'",';
				$row .= '"'.$user['call_duration'].'",';
				$row .= '"'.$user['file_no'].'",';
				$row .= '"'.$user['audit_type'].'",';
				$row .= '"'.$user['voc'].'",';
				$row .= '"'.$user['audit_start_time'].'",';
				$row .= '"'.$user['entry_date'].'",';
				$row .= '"'.$interval1.'",';
				$row .= '"'.$user['overall_score'].'%'.'",';
				$row .= '"'.$user['agent_appropriate_greeting'].'",';
				$row .= '"'.$user['agent_excellent_conversational_responses'].'",';
				$row .= '"'.$user['agent_verify_opening_information'].'",';
				$row .= '"'.$user['agent_follow_call_flow'].'",';
				$row .= '"'.$user['agent_appropriate_gratitude'].'",';
				$row .= '"'.$user['agent_share_upsells'].'",';
				$row .= '"'.$user['agent_show_familiarity_search'].'",';
				$row .= '"'.$user['agent_thank_caller_specifically'].'",';
				$row .= '"'.$user['agent_share_facts_appropriate'].'",';
				$row .= '"'.$user['agent_professional_communication'].'",';
				$row .= '"'.$user['agent_proper_enthusiasm'].'",';
				$row .= '"'.$user['agent_maintain_control_conversation'].'",';
				$row .= '"'.$user['agent_spoke_clearly'].'",';
				$row .= '"'.$user['agent_good_listening_skills_responses'].'",';
				$row .= '"'.$user['agent_empathize_caller_and_compassion'].'",';
				$row .= '"'.$user['agent_have_minimal_dead_air'].'",';
				$row .= '"'.$user['agent_have_caller_provide_address'].'",';
				$row .= '"'.$user['agent_confirm_dollar_amount'].'",';
				$row .= '"'.$user['agent_read_shipping_information'].'",';
				$row .= '"'.$user['agent_ask_caller_email_tv_information'].'",';
				$row .= '"'.$user['agent_proper_thanks'].'",';
				$row .= '"'.$user['agent_transfer_call_prayer_appropriate'].'",';
				$row .= '"'.$user['agent_follow_payment'].'",';
				$row .= '"'.$user['agent_read_back_customer_details_properly'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['call_summary'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['feedback'])).'",';
				$row .= '"'.$user['agnt_fd_acpt'].'",';
				$row .= '"'.$user['agent_rvw_date'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['agent_rvw_note'])).'",';
				$row .= '"'.$user['mgnt_rvw_date'].'",';
				$row .= '"'.$user['mgnt_rvw_name'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['mgnt_rvw_note'])).'"';
				
				fwrite($fopen,$row."\r\n");
			}
			fclose($fopen);	
			
		}else if($pid=='non_profit'){
		
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
				$row .= '"'.$user['call_date'].'",';
				$row .= '"'.$user['call_duration'].'",';
				$row .= '"'.$user['file_no'].'",';
				$row .= '"'.$user['audit_type'].'",';
				$row .= '"'.$user['voc'].'",';
				$row .= '"'.$user['audit_start_time'].'",';
				$row .= '"'.$user['entry_date'].'",';
				$row .= '"'.$interval1.'",';
				$row .= '"'.$user['overall_score'].'%'.'",';
				$row .= '"'.$user['preparedtakecall'].'",';
				$row .= '"'.$user['paidcallerfromdonor'].'",';
				$row .= '"'.$user['communicatorstarted'].'",';
				$row .= '"'.$user['pronouncedclients'].'",';
				$row .= '"'.$user['gavewarmgreeting'].'",';
				$row .= '"'.$user['followedscript1stReq'].'",';
				$row .= '"'.$user['usedcorrectdollar'].'",';
				$row .= '"'.$user['assumptivegiftask'].'",';
				$row .= '"'.$user['shownempathy'].'",';
				$row .= '"'.$user['repeatedobjection'].'",';
				$row .= '"'.$user['personalizedobjection'].'",';
				$row .= '"'.$user['attemptedhandleobjection'].'",';
				$row .= '"'.$user['reinforcethenegative'].'",';
				$row .= '"'.$user['deadendcall'].'",';
				$row .= '"'.$user['followed2ndReq'].'",';
				$row .= '"'.$user['usedoller2ndReq'].'",';
				$row .= '"'.$user['assumptive2ndReq'].'",';
				$row .= '"'.$user['attempted3rdReq'].'",';
				$row .= '"'.$user['usedoller3rdReq'].'",';
				$row .= '"'.$user['assumptive3rdReq'].'",';
				$row .= '"'.$user['confirmationgiftamount'].'",';
				$row .= '"'.$user['assumedhigherdoller'].'",';
				$row .= '"'.$user['meaningfulgratitude'].'",';
				$row .= '"'.$user['readcreditcard'].'",';
				$row .= '"'.$user['confirmedfullname'].'",';
				$row .= '"'.$user['followedmaybeclose'].'",';
				$row .= '"'.$user['readclosescript'].'",';
				$row .= '"'.$user['endedcalltime'].'",';
				$row .= '"'.$user['soundedconversational'].'",';
				$row .= '"'.$user['useappropiatepace'].'",';
				$row .= '"'.$user['confidentpresentation'].'",';
				$row .= '"'.$user['didnotlosecontrol'].'",';
				$row .= '"'.$user['properpersonalization'].'",';
				$row .= '"'.$user['utilizedpropergrammer'].'",';
				$row .= '"'.$user['bailing'].'",';
				$row .= '"'.$user['askforcreditcard'].'",';
				$row .= '"'.$user['gavefalseinformation'].'",';
				$row .= '"'.$user['donorcarecenter'].'",';
				$row .= '"'.$user['askconfirmationquestion'].'",';
				$row .= '"'.$user['unsolidgift'].'",';
				$row .= '"'.$user['codingrefusal'].'",';
				$row .= '"'.$user['unprofessionalbehaviour'].'",';
				$row .= '"'.$user['improperpresentation'].'",';
				$row .= '"'.$user['omittedDNCcode'].'",';
				$row .= '"'.$user['falsificationgift'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['call_summary'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['feedback'])).'",';
				$row .= '"'.$user['agnt_fd_acpt'].'",';
				$row .= '"'.$user['agent_rvw_date'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['agent_rvw_note'])).'",';
				$row .= '"'.$user['mgnt_rvw_date'].'",';
				$row .= '"'.$user['mgnt_rvw_name'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['mgnt_rvw_note'])).'"';
				
				fwrite($fopen,$row."\r\n");
			}
			fclose($fopen);	
			
		}else if($pid=='revel'){
		
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
				$row .= '"'.$user['call_date'].'",';
				$row .= '"'.$user['call_duration'].'",';
				$row .= '"'.$user['file_no'].'",';
				$row .= '"'.$user['csr_id'].'",';
				//$row .= '"'.$user['call_type'].'",';
				//$row .= '"'.$user['caller_type'].'",';
				$row .= '"'.$user['audit_type'].'",';
				$row .= '"'.$user['voc'].'",';
				$row .= '"'.$user['audit_start_time'].'",';
				$row .= '"'.$user['entry_date'].'",';
				$row .= '"'.$interval1.'",';
				$row .= '"'.$user['overall_score'].'%'.'",';
				$row .= '"'.$user['repgreetingcustomer'].'",';
				$row .= '"'.$user['repuserespectfultone'].'",';
				$row .= '"'.$user['repasnwertimelymanner'].'",';
				$row .= '"'.$user['repcollectcallerinformation'].'",';
				$row .= '"'.$user['repuselisteningskills'].'",';
				$row .= '"'.$user['repdemonstratecalltechnique'].'",';
				$row .= '"'.$user['repreframeinterruptcaller'].'",';
				$row .= '"'.$user['repspeakclearlyatpace'].'",';
				$row .= '"'.$user['repavoiduseofterms'].'",';
				$row .= '"'.$user['repconfidentinresponce'].'",';
				$row .= '"'.$user['repusercallerlastname'].'",';
				$row .= '"'.$user['repusefiltertoobtain'].'",';
				$row .= '"'.$user['repmaintaincallcontrol'].'",';
				$row .= '"'.$user['repusetoolappropiately'].'",';
				$row .= '"'.$user['repdemonstrateproductknowledge'].'",';
				$row .= '"'.$user['repuseappropiatescript'].'",';
				$row .= '"'.$user['repaccuratelycalldocument'].'",';
				$row .= '"'.$user['repcompletecorrectclosing'].'",';
				$row .= '"'.$user['repthankthecaller'].'",';
				$row .= '"'.$user['repgiveMedicaladvice'].'",';
				$row .= '"'.$user['agentMiscodeCall'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt1'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt2'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt3'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt4'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt5'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt6'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt7'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt8'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt9'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt10'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt11'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt12'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt13'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt14'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt15'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt16'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt17'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt18'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt19'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt20'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt21'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['call_summary'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['feedback'])).'",';
				$row .= '"'.$user['agnt_fd_acpt'].'",';
				$row .= '"'.$user['agent_rvw_date'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['agent_rvw_note'])).'",';
				$row .= '"'.$user['mgnt_rvw_date'].'",';
				$row .= '"'.$user['mgnt_rvw_name'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['mgnt_rvw_note'])).'"';
				
				fwrite($fopen,$row."\r\n");
			}
			fclose($fopen);	
			
		}else if($pid=='qpc'){
		
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
				$row .= '"'.$user['call_date'].'",';
				$row .= '"'.$user['call_duration'].'",';
				$row .= '"'.$user['file_no'].'",';
				//$row .= '"'.$user['csr_id'].'",';
				//$row .= '"'.$user['call_type'].'",';
				//$row .= '"'.$user['caller_type'].'",';
				$row .= '"'.$user['audit_type'].'",';
				$row .= '"'.$user['voc'].'",';
				$row .= '"'.$user['audit_start_time'].'",';
				$row .= '"'.$user['entry_date'].'",';
				$row .= '"'.$interval1.'",';
				$row .= '"'.$user['overall_score'].'%'.'",';
				$row .= '"'.$user['unpreparedCallIntroduce'].'",';
				$row .= '"'.$user['didnotUseBranding'].'",';
				$row .= '"'.$user['dataNotCollected'].'",';
				$row .= '"'.$user['secondDataOccurrence'].'",';
				$row .= '"'.$user['inaccurateCallResult'].'",';
				$row .= '"'.$user['unusableAfterCallComment'].'",';
				$row .= '"'.$user['underutilizedCallNarration'].'",';
				$row .= '"'.$user['inappropiateFAQResponce'].'",';
				$row .= '"'.$user['imprpperTransaction'].'",';
				$row .= '"'.$user['underAcknowledgeCaller'].'",';
				$row .= '"'.$user['inappropiateScript'].'",';
				$row .= '"'.$user['notDisplayOwnership'].'",';
				$row .= '"'.$user['incorrectTransfer'].'",';
				$row .= '"'.$user['didagentabruptendcall'].'",';
				$row .= '"'.$user['didagentanswerpremiumquestion'].'",';
				$row .= '"'.$user['didagentgivewrongcallback'].'",';
				$row .= '"'.$user['didagentuseincorrectname'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt1'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt2'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt3'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt4'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt5'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt6'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt7'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt8'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt9'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt10'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt11'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt12'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt13'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt14'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt15'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt16'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt17'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['call_summary'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['feedback'])).'",';
				$row .= '"'.$user['agnt_fd_acpt'].'",';
				$row .= '"'.$user['agent_rvw_date'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['agent_rvw_note'])).'",';
				$row .= '"'.$user['mgnt_rvw_date'].'",';
				$row .= '"'.$user['mgnt_rvw_name'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['mgnt_rvw_note'])).'"';
				
				fwrite($fopen,$row."\r\n");
			}
			fclose($fopen);	
			
		}else if($pid=='ancient_nutrition'){
		
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
				$row .= '"'.$user['call_date'].'",';
				$row .= '"'.$user['call_duration'].'",';
				$row .= '"'.$user['file_no'].'",';
				$row .= '"'.$user['audit_type'].'",';
				$row .= '"'.$user['voc'].'",';
				$row .= '"'.$user['audit_start_time'].'",';
				$row .= '"'.$user['entry_date'].'",';
				$row .= '"'.$interval1.'",';
				$row .= '"'.$user['overall_score'].'%'.'",';
				$row .= '"'.$user['repgreetingcustomer'].'",';
				$row .= '"'.$user['repuserespectfultone'].'",';
				$row .= '"'.$user['repasnwertimelymanner'].'",';
				$row .= '"'.$user['repcollectcustomerinfo'].'",';
				$row .= '"'.$user['repcoverpaymentprocedure'].'",';
				$row .= '"'.$user['repuselisteningskills'].'",';
				$row .= '"'.$user['repdemonstratecalltechnique'].'",';
				$row .= '"'.$user['repreframeinterruptcaller'].'",';
				$row .= '"'.$user['repspeakclearlyatpace'].'",';
				$row .= '"'.$user['repavoiduseinternalterms'].'",';
				$row .= '"'.$user['repconfidentinresponce'].'",';
				$row .= '"'.$user['repusercallerlastname'].'",';
				$row .= '"'.$user['repusefiltertoobtain'].'",';
				$row .= '"'.$user['repcoverautoshipping'].'",';
				$row .= '"'.$user['repgatheredemail'].'",';
				$row .= '"'.$user['repcoverRushshipping'].'",';
				$row .= '"'.$user['repcompleteorderconfirmation'].'",';
				$row .= '"'.$user['repmaintaincallcontrol'].'",';
				$row .= '"'.$user['repusetoolappropiately'].'",';
				$row .= '"'.$user['repdemonstrateproductknowledge'].'",';
				$row .= '"'.$user['repuseappropiateobjection'].'",';
				$row .= '"'.$user['repaccuratelycalldocument'].'",';
				$row .= '"'.$user['repcompletecorrectclosing'].'",';
				$row .= '"'.$user['repthankthecallerbeforeclosing'].'",';
				$row .= '"'.$user['repcoveroffersappropiately'].'",';
				$row .= '"'.$user['repcoverupsellappropiately'].'",';
				$row .= '"'.$user['agentReadConfirmScript'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt1'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt2'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt3'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt4'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt5'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt6'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt7'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt8'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt9'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt10'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt11'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt12'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt13'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt14'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt15'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt16'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt17'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt18'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt19'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt20'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt21'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt22'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt23'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt24'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt25'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt26'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt27'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['call_summary'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['feedback'])).'",';
				$row .= '"'.$user['agnt_fd_acpt'].'",';
				$row .= '"'.$user['agent_rvw_date'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['agent_rvw_note'])).'",';
				$row .= '"'.$user['mgnt_rvw_date'].'",';
				$row .= '"'.$user['mgnt_rvw_name'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['mgnt_rvw_note'])).'"';
				
				fwrite($fopen,$row."\r\n");
			}
			fclose($fopen);	
			
		}else if($pid=='sabal'){
		
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
				$row .= '"'.$user['call_date'].'",';
				$row .= '"'.$user['call_duration'].'",';
				$row .= '"'.$user['file_no'].'",';
				$row .= '"'.$user['audit_type'].'",';
				$row .= '"'.$user['voc'].'",';
				$row .= '"'.$user['audit_start_time'].'",';
				$row .= '"'.$user['entry_date'].'",';
				$row .= '"'.$interval1.'",';
				$row .= '"'.$user['overall_score'].'%'.'",';
				$row .= '"'.$user['agentaskIndividualName'].'",';
				$row .= '"'.$user['agentIntroduceHimHerself'].'",';
				$row .= '"'.$user['agentStateCustomerService'].'",';
				$row .= '"'.$user['agentApologizePhoneCall'].'",';
				$row .= '"'.$user['agentIndividualRXplan'].'",';
				$row .= '"'.$user['agentReadListedExample'].'",';
				$row .= '"'.$user['agentAskIndividualColorCard'].'",';
				$row .= '"'.$user['agentAskIndividualUpdate'].'",';
				$row .= '"'.$user['agentAskIndividualEffectiveDate'].'",';
				$row .= '"'.$user['agentUseCorrectRebuttal'].'",';
				$row .= '"'.$user['agentUseIndividualScript'].'",';
				$row .= '"'.$user['agentSaysHeShenotInterested'].'",';
				$row .= '"'.$user['agentAbruptlyEndCall'].'",';
				$row .= '"'.$user['agentbecomeUrgumentative'].'",';
				$row .= '"'.$user['agentRecordIncirrectMedicare'].'",';
				$row .= '"'.$user['agentProvideFalseInformation'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt1'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt2'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt3'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt4'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt5'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt6'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt7'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt8'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt9'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt10'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt11'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt12'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt13'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt14'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt15'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt16'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['call_summary'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['feedback'])).'",';
				$row .= '"'.$user['agnt_fd_acpt'].'",';
				$row .= '"'.$user['agent_rvw_date'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['agent_rvw_note'])).'",';
				$row .= '"'.$user['mgnt_rvw_date'].'",';
				$row .= '"'.$user['mgnt_rvw_name'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['mgnt_rvw_note'])).'"';
				
				fwrite($fopen,$row."\r\n");
			}
			fclose($fopen);	
			
		}else if($pid=='curative'){
		
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
				$row .= '"'.$user['call_date'].'",';
				$row .= '"'.$user['call_duration'].'",';
				$row .= '"'.$user['file_no'].'",';
				$row .= '"'.$user['audit_type'].'",';
				$row .= '"'.$user['voc'].'",';
				$row .= '"'.$user['audit_start_time'].'",';
				$row .= '"'.$user['entry_date'].'",';
				$row .= '"'.$interval1.'",';
				$row .= '"'.$user['overall_score'].'%'.'",';
				$row .= '"'.$user['greetCustomerProperly'].'",';
				$row .= '"'.$user['useRespectfulTone'].'",';
				$row .= '"'.$user['answerInTimelyManner'].'",';
				$row .= '"'.$user['verifyCustomerInformation'].'",';
				$row .= '"'.$user['verifyPatientPHI'].'",';
				$row .= '"'.$user['accidentalIncorrectInformation'].'",';
				$row .= '"'.$user['agentEscalateTier2Correctly'].'",';
				$row .= '"'.$user['agentEnsureEmailAddress'].'",';
				$row .= '"'.$user['agentRespectPatientPrivacy'].'",';
				$row .= '"'.$user['agentSpeakConcisely'].'",';
				$row .= '"'.$user['agentAvoidInternalTerms'].'",';
				$row .= '"'.$user['agentDemonstrateEmpathyUse'].'",';
				$row .= '"'.$user['agentUsePleaseThankyou'].'",';
				$row .= '"'.$user['agentMinimizeExtendedSilence'].'",';
				$row .= '"'.$user['agentUseCorrectSentence'].'",';
				$row .= '"'.$user['agentSpeakWarmthVoice'].'",';
				$row .= '"'.$user['callerGaveAgentKUDOS'].'",';
				$row .= '"'.$user['agentDemonstrateCallerPatient'].'",';
				$row .= '"'.$user['repCompletlyCallDocument'].'",';
				$row .= '"'.$user['repConfirmCompleteClosing'].'",';
				$row .= '"'.$user['thankCallerBeforeClosing'].'",';
				$row .= '"'.$user['repDoEverythingPossible'].'",';
				$row .= '"'.$user['repAncipateCallerNeed'].'",';
				$row .= '"'.$user['agentProvideAccurateResult'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt1'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt2'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt3'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt4'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt5'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt7'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt8'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt9'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt10'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt11'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt12'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt13'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt14'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt15'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt16'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt17'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt18'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt19'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt20'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt21'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt22'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt23'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt24'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt6'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['call_summary'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['feedback'])).'",';
				$row .= '"'.$user['agnt_fd_acpt'].'",';
				$row .= '"'.$user['agent_rvw_date'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['agent_rvw_note'])).'",';
				$row .= '"'.$user['mgnt_rvw_date'].'",';
				$row .= '"'.$user['mgnt_rvw_name'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['mgnt_rvw_note'])).'"';
				
				fwrite($fopen,$row."\r\n");
			}
			fclose($fopen);	
			
		}else if($pid=='powerfan'){
		
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
				$row .= '"'.$user['call_date'].'",';
				$row .= '"'.$user['call_duration'].'",';
				$row .= '"'.$user['file_no'].'",';
				$row .= '"'.$user['audit_type'].'",';
				$row .= '"'.$user['voc'].'",';
				$row .= '"'.$user['audit_start_time'].'",';
				$row .= '"'.$user['entry_date'].'",';
				$row .= '"'.$interval1.'",';
				$row .= '"'.$user['overall_score'].'%'.'",';
				$row .= '"'.$user['answerCallWithin5sec'].'",';
				$row .= '"'.$user['agentIdentifySelftandCompany'].'",';
				$row .= '"'.$user['collectIntroInformation'].'",';
				$row .= '"'.$user['mainSelftAgentGiveTerms'].'",';
				$row .= '"'.$user['agentPromoteUpsell'].'",';
				$row .= '"'.$user['describedProductAccurately'].'",';
				$row .= '"'.$user['useAppropiateObjection'].'",';
				$row .= '"'.$user['askForBillingNamesOnCheck'].'",';
				$row .= '"'.$user['agentVerifyCallerUseofCheck'].'",';
				$row .= '"'.$user['askForBillingAddressForPayment'].'",';
				$row .= '"'.$user['agentVerifyShippingAddress'].'",';
				$row .= '"'.$user['orderWasSetUpAndCodedCorrectly'].'",';
				$row .= '"'.$user['askForEmailAddress'].'",';
				$row .= '"'.$user['gaveTotalAmountCharged'].'",';
				$row .= '"'.$user['gaveCorrectShippingInfo'].'",';
				$row .= '"'.$user['gaveMBGInfo'].'",';
				$row .= '"'.$user['gaveCSPhoneNumber'].'",';
				$row .= '"'.$user['permissionToAuthorizePayment'].'",';
				$row .= '"'.$user['wasAgentPolite'].'",';
				$row .= '"'.$user['agentUsingAppropiateComment'].'",';
				$row .= '"'.$user['useHoldAndTransferProperly'].'",';
				$row .= '"'.$user['power_fan_autofail'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['call_summary'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['feedback'])).'",';
				$row .= '"'.$user['agnt_fd_acpt'].'",';
				$row .= '"'.$user['agent_rvw_date'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['agent_rvw_note'])).'",';
				$row .= '"'.$user['mgnt_rvw_date'].'",';
				$row .= '"'.$user['mgnt_rvw_name'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['mgnt_rvw_note'])).'"';
				
				fwrite($fopen,$row."\r\n");
			}
			fclose($fopen);	
			
		}else if($pid=='nuwave'){
		
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
				$row .= '"'.$user['call_date'].'",';
				$row .= '"'.$user['file_no'].'",';
				$row .= '"'.$user['order_id'].'",';
				$row .= '"'.$user['call_duration'].'",';
				$row .= '"'.$user['interaction'].'",';
				$row .= '"'.$user['audit_type'].'",';
				$row .= '"'.$user['voc'].'",';
				$row .= '"'.$user['audit_start_time'].'",';
				$row .= '"'.$user['entry_date'].'",';
				$row .= '"'.$interval1.'",';
				$row .= '"'.$user['overall_score'].'%'.'",';
				$row .= '"'.$user['greeting_identification'].'",';
				$row .= '"'.$user['verified_customer'].'",';
				$row .= '"'.$user['use_caller_CSR_name'].'",';
				$row .= '"'.$user['doesnot_interrupt_customer'].'",';
				$row .= '"'.$user['converses_clear_concise_mannaer'].'",';
				$row .= '"'.$user['avoid_use_slang_jargon'].'",';
				$row .= '"'.$user['empathy_toward_customer'].'",';
				$row .= '"'.$user['CSR_sound_helpful'].'",';
				$row .= '"'.$user['gain_customer_permission'].'",';
				$row .= '"'.$user['thanks_customer_holding'].'",';
				$row .= '"'.$user['hold_time_appropiate'].'",';
				$row .= '"'.$user['utilized_established_guidelines'].'",';
				$row .= '"'.$user['use_probing_question'].'",';
				$row .= '"'.$user['verbally_verfied_problem'].'",';
				$row .= '"'.$user['manage_customer_expectation'].'",';
				$row .= '"'.$user['reason_for_troubleshooting'].'",';
				$row .= '"'.$user['use_available_resources'].'",';
				$row .= '"'.$user['complete_customer_documentation'].'",';
				$row .= '"'.$user['customer_comfortable_with_outcome'].'",';
				$row .= '"'.$user['additional_needs_uncovered'].'",';
				$row .= '"'.$user['product_served_their_needs'].'",';
				$row .= '"'.$user['used_correct_closing'].'",';
				$row .= '"'.$user['infractions'].'",';
				$row .= '"'.$user['sub_infractions'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['call_summary'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['feedback'])).'",';
				$row .= '"'.$user['agnt_fd_acpt'].'",';
				$row .= '"'.$user['agent_rvw_date'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['agent_rvw_note'])).'",';
				$row .= '"'.$user['mgnt_rvw_date'].'",';
				$row .= '"'.$user['mgnt_rvw_name'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['mgnt_rvw_note'])).'",';
					
				fwrite($fopen,$row."\r\n");
			}
			fclose($fopen);	
			
		}else if($pid=='delta_iowa'){
		
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
				$row .= '"'.$user['call_date'].'",';
				$row .= '"'.$user['file_no'].'",';
				$row .= '"'.$user['call_id'].'",';
				$row .= '"'.$user['call_duration'].'",';
				$row .= '"'.$user['audit_type'].'",';
				$row .= '"'.$user['voc'].'",';
				$row .= '"'.$user['audit_start_time'].'",';
				$row .= '"'.$user['entry_date'].'",';
				$row .= '"'.$interval1.'",';
				$row .= '"'.$user['overall_score'].'%'.'",';
				$row .= '"'.$user['answer_call_promptly'].'",';
				$row .= '"'.$user['open_call_property'].'",';
				$row .= '"'.$user['verify_identify_information'].'",';
				$row .= '"'.$user['adhered_HIPAA'].'",';
				$row .= '"'.$user['adhere_client_policies'].'",';
				$row .= '"'.$user['perform_correct_action'].'",';
				$row .= '"'.$user['set_appropiate_expectation'].'",';
				$row .= '"'.$user['gave_accurate_info'].'",';
				$row .= '"'.$user['routed_issue'].'",';
				$row .= '"'.$user['complete_documentation'].'",';
				$row .= '"'.$user['phrases_courtsey'].'",';
				$row .= '"'.$user['use_caller_name'].'",';
				$row .= '"'.$user['hold_and_transfer'].'",';
				$row .= '"'.$user['state_call_reason'].'",';
				$row .= '"'.$user['use_jargon'].'",';
				$row .= '"'.$user['allow_caller_speak'].'",';
				$row .= '"'.$user['positive_plan_type'].'",';
				$row .= '"'.$user['willingness_help_caller'].'",';
				$row .= '"'.$user['gained_agrrement'].'",';
				$row .= '"'.$user['emphathetic_manner'].'",';
				$row .= '"'.$user['closed_call'].'",';
				$row .= '"'.$user['resolved_customer_issue'].'",';
				$row .= '"'.$user['assure_customer_comcern'].'",';
				$row .= '"'.$user['effective_attempt'].'",';
				$row .= '"'.$user['agent_disconnect_customer'].'",';
				$row .= '"'.$user['agent_transfer_customer'].'",';
				$row .= '"'.$user['agent_use_offensive_word'].'",';
				$row .= '"'.$user['agent_talked_down_caller'].'",';
				$row .= '"'.$user['agent_disclosed_info'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt1'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt2'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt3'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt4'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt5'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt6'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt7'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt8'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt9'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt10'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt11'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt12'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt13'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt14'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt15'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt16'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt17'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt18'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt19'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt20'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt21'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt22'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt23'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt24'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt25'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt26'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt27'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt28'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt29'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['call_summary'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['feedback'])).'",';
				$row .= '"'.$user['agnt_fd_acpt'].'",';
				$row .= '"'.$user['agent_rvw_date'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['agent_rvw_note'])).'",';
				$row .= '"'.$user['mgnt_rvw_date'].'",';
				$row .= '"'.$user['mgnt_rvw_name'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['mgnt_rvw_note'])).'"';
				
				fwrite($fopen,$row."\r\n");
			}
			fclose($fopen);	
			
		}
		
		
	}
	
	
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/*--------------------------------------------------------------------*/
/*					ALL AGENT FEEDBACK PART							  */
/*--------------------------------------------------------------------*/
	public function agent_amd_feedback()
	{
		if(check_logged_in())
		{
			$user_site_id= get_user_site_id();
			$role_id= get_role_id();
			$current_user = get_user_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_ameridial/agent_amd_feedback.php";
			$data["agentUrl"] = "qa_ameridial/agent_amd_feedback";
			
			$from_date = '';
			$to_date = '';
			$campaign='';
			$cond="";
			
			$campaign = $this->input->get('campaign');
			
			
			if($campaign!=''){	
			
				if($campaign=="mercy_ship"){
					$qSql1="Select count(id) as value from qa_mercy_feedback where agent_id='$current_user' and audit_type in ('CQ Audit', 'BQ Audit')";
					$qSql2="Select count(id) as value from qa_mercy_feedback where agent_rvw_date is null and agent_id='$current_user' and audit_type in ('CQ Audit', 'BQ Audit')";
				}else{
					$qSql1="Select count(id) as value from qa_amd_".$campaign."_feedback where agent_id='$current_user' and audit_type in ('CQ Audit', 'BQ Audit')";
					$qSql2="Select count(id) as value from qa_amd_".$campaign."_feedback where agent_rvw_date is null and agent_id='$current_user' and audit_type in ('CQ Audit', 'BQ Audit')";
				}
				$data["tot_feedback"] =  $this->Common_model->get_single_value($qSql1);
				$data["yet_rvw"] =  $this->Common_model->get_single_value($qSql2);
				
			
				if($this->input->get('btnView')=='View')
				{
					$fromDate = $this->input->get('from_date');
					if($fromDate!="") $from_date = mmddyy2mysql($fromDate);
					
					$toDate = $this->input->get('to_date');
					if($toDate!="") $to_date = mmddyy2mysql($toDate);
					
					if($fromDate !="" && $toDate!=="" ){ 
						$cond= " Where (audit_date >= '$from_date' and audit_date <= '$to_date') And agent_id='$current_user' and audit_type in ('CQ Audit', 'BQ Audit') ";
					}else{
						$cond= " Where agent_id='$current_user' and audit_type in ('CQ Audit', 'BQ Audit') ";
					}
					
					if($campaign=="mercy_ship"){
						$qSql="SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, (select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_name from qa_mercy_feedback $cond) xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to from signin) yy on (xx.agent_id=yy.sid) order by audit_date";
					}else{
						$qSql="SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, (select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_name from qa_amd_".$campaign."_feedback $cond) xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to from signin) yy on (xx.agent_id=yy.sid) order by audit_date";
					}
					$data["agent_list"] = $this->Common_model->get_query_result_array($qSql);	
				}
			}
			
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			$data["campaign"] = $campaign;
			$this->load->view('dashboard',$data);
		}
	}
	
	public function agent_amd_rvw($id,$campaign){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_ameridial/agent_amd_rvw.php";
			$data["agentUrl"] = "qa_ameridial/agent_amd_feedback";
			
			if($campaign=="mercy_ship"){
				$qSql="SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, (select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_name,agent_rvw_note as agent_note,mgnt_rvw_note as mgnt_note from qa_mercy_feedback where id=$id) xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to from signin) yy on (xx.agent_id=yy.sid) order by audit_date";
			}else{
				$qSql="SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, (select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_name,agent_rvw_note as agent_note,mgnt_rvw_note as mgnt_note from qa_amd_".$campaign."_feedback where id=$id) xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to from signin) yy on (xx.agent_id=yy.sid) order by audit_date";
			}
			$data["agnt_feedback"] = $this->Common_model->get_query_row_array($qSql);
			
			$data["pnid"]=$id;
			$data["campaign"]=$campaign;
			
			if($campaign=="mercy_ship"){
				$table='qa_mercy_feedback';
			}else{
				$table='qa_amd_'.$campaign.'_feedback';
			}

			if($campaign=="trapollo"){
				
				$data["columname"]=$this->tropollo_columnname();
				$data["scoreParametername"]=$this->parameter_tropollo_scrorecard_details();
				$data["cnt"]=count($data["columname"]);
			}
			
			if($this->input->post('pnid'))
			{
				$pnid=$this->input->post('pnid');
				$curDateTime=CurrMySqlDate();
				$log=get_logs();
				
				$field_array=array(
					"agnt_fd_acpt" => $this->input->post('agnt_fd_acpt'),
					"agent_rvw_note" => $this->input->post('note'),
					"agent_rvw_date" => $curDateTime
				);
				$this->db->where('id', $pnid);
				$this->db->update($table,$field_array);
				
				redirect('Qa_ameridial/agent_amd_feedback');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}
	
	 

 }