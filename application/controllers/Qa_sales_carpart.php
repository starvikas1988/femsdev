<?php 

 class Qa_sales_carpart extends CI_Controller{
	
	public function __construct(){
		parent::__construct();
		$this->load->model('user_model');
		$this->load->model('Common_model');
		$this->load->model('Qa_vrs_model');
	}

	public function salesName(){
		return "sales_carpart";
	}

	public function index(){
		if(check_logged_in())
		{
			$current_user = get_user_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_".$this->salesName()."/qa_".$this->salesName()."_feedback.php";
			$data["content_js"] = "qa_".$this->salesName()."_js.php";
			$data["page"]=$this->salesName();
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

			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,54) and status=1  order by name";
			/* and is_assign_process (id,124) */
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
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_".$this->salesName()."_feedback $cond) xx Left Join
				(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";
				//echo $qSql;
			$data[$this->salesName()."_new_data"] = $this->Common_model->get_query_result_array($qSql);

			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_".$this->salesName()."_inbound_feedback $cond) xx Left Join
				(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";
				//echo $qSql;
			$data[$this->salesName()."_new_data_inbound"] = $this->Common_model->get_query_result_array($qSql);


			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_".$this->salesName()."_inbound2_feedback $cond) xx Left Join
				(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";
				//echo $qSql;
			$data[$this->salesName()."_new_data_inbound2"] = $this->Common_model->get_query_result_array($qSql);
		////////////////////////////////////////////////////////////////////////////////////////////////
			
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			$data["agent_id"] = $agent_id;
			
			$this->load->view("dashboard",$data);
		}
	}


	public function process($parm="",$formparam="",$campaign=""){

		if ($parm=="add") {
			$this->add_process($formparam);
		}elseif ($parm=="mgnt_rvw") {
			$this->mgnt_process_rvw($formparam);
		}elseif($parm=="agent"){
			$this->agent_process_feedback();
		}elseif($parm=="agnt_feedback"){
			$this->agent_process_rvw($formparam,$campaign);
		}elseif ($parm=="add_inbound") {
			$this->add_process_inbound($formparam);
		}elseif ($parm=="mgnt_rvw_inbound") {
			$this->mgnt_process_rvw_inbound($formparam);
		}elseif($parm=="agent_inbound"){
			$this->agent_process_feedback_inbound();
		}elseif ($parm=="add_inbound2") {
			$this->add_process_inbound2($formparam);
		}elseif ($parm=="mgnt_rvw_inbound2") {
			$this->mgnt_process_rvw_inbound2($formparam);
		}elseif($parm=="agent_inbound2"){
			$this->agent_process_feedback_inbound2();
		}

	}


	public function add_process($stratAuditTime){
	
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_".$this->salesName()."/add_".$this->salesName().".php";
			$data["content_js"] = "qa_".$this->salesName()."_js.php";
			$data["page"]=$this->salesName();
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,54) and status=1  order by name";
			/* and is_assign_process (id,124) */
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
				$a = $this->mt_upload_files($_FILES['attach_file']);
				$field_array["attach_file"] = implode(',',$a);
				$rowid= data_inserter('qa_'.$this->salesName().'_feedback',$field_array);
				redirect('Qa_'.$this->salesName());
			}
			$data["array"] = $a;
			
			$this->load->view("dashboard",$data);
		}
	}

	public function add_process_inbound($stratAuditTime){
	
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_".$this->salesName()."/add_".$this->salesName()."_inbound.php";
			$data["content_js"] = "qa_".$this->salesName()."_js.php";
			$data["page"]=$this->salesName();
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,54) and status=1  order by name";
			/* and is_assign_process (id,124) */
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
				$a = $this->mt_upload_files($_FILES['attach_file']);
				$field_array["attach_file"] = implode(',',$a);
				$rowid= data_inserter('qa_'.$this->salesName().'_inbound_feedback',$field_array);
				redirect('Qa_'.$this->salesName());
			}
			$data["array"] = $a;
			
			$this->load->view("dashboard",$data);
		}
	}

	public function add_process_inbound2($stratAuditTime){
	
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_".$this->salesName()."/add_".$this->salesName()."_inbound2.php";
			$data["content_js"] = "qa_".$this->salesName()."_js.php";
			$data["page"]=$this->salesName();
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,54) and status=1  order by name";
			/* and is_assign_process (id,124) */
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
				$a = $this->mt_upload_files($_FILES['attach_file']);
				$field_array["attach_file"] = implode(',',$a);
				$rowid= data_inserter('qa_'.$this->salesName().'_inbound2_feedback',$field_array);
				redirect('Qa_'.$this->salesName());
			}
			$data["array"] = $a;
			
			$this->load->view("dashboard",$data);
		}
	}
	
	private function mt_upload_files($files)
    {
        $config['upload_path'] = './qa_files/qa_sales_carpart';
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
	

	public function mgnt_process_rvw($id){
		
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_".$this->salesName()."/mgnt_".$this->salesName()."_rvw.php";
			$data["content_js"] = "qa_".$this->salesName()."_js.php";
			$data["page"]=$this->salesName();
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,54) and status=1  order by name";
			/* and is_assign_process (id,124) */
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_".$this->salesName()."_feedback where id='$id') xx Left Join
				(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid)";
			$data[$this->salesName()."_new"] = $this->Common_model->get_query_row_array($qSql);
			
			$data["pnid"]=$id;
			$a = array();
			
		///////Edit Part///////	
			if($this->input->post('pnid'))
			{
				$pnid=$this->input->post('pnid');
				$curDateTime=CurrMySqlDate();
				$log=get_logs();
				
				$field_array=$this->input->post('data');
				
				if($_FILES['attach_file']['tmp_name'][0]!=''){
					$a = $this->mt_upload_files($_FILES['attach_file']);
					$field_array["attach_file"] = implode(',',$a);
				}
				
				$this->db->where('id', $pnid);
				$this->db->update('qa_'.$this->salesName().'_feedback',$field_array);
				
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
				$this->db->update('qa_'.$this->salesName().'_feedback',$field_array1);
			///////////	
				redirect('Qa_'.$this->salesName());
				$data["array"] = $a;
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}
	
	public function mgnt_process_rvw_inbound($id){
		
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_".$this->salesName()."/mgnt_".$this->salesName()."_rvw_inbound.php";
			$data["content_js"] = "qa_".$this->salesName()."_js.php";
			$data["page"]=$this->salesName();
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,54) and status=1  order by name";
			/* and is_assign_process (id,124) */
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_".$this->salesName()."_inbound_feedback where id='$id') xx Left Join
				(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid)";
			$data[$this->salesName()."_new"] = $this->Common_model->get_query_row_array($qSql);
			
			$data["pnid"]=$id;
			$a = array();
			
		///////Edit Part///////	
			if($this->input->post('pnid'))
			{
				$pnid=$this->input->post('pnid');
				$curDateTime=CurrMySqlDate();
				$log=get_logs();
				
				$field_array=$this->input->post('data');
				
				if($_FILES['attach_file']['tmp_name'][0]!=''){
					$a = $this->mt_upload_files($_FILES['attach_file']);
					$field_array["attach_file"] = implode(',',$a);
				}
				
				$this->db->where('id', $pnid);
				$this->db->update('qa_'.$this->salesName().'_inbound_feedback',$field_array);
				
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
				$this->db->update('qa_'.$this->salesName().'_inbound_feedback',$field_array1);
			///////////	
				redirect('Qa_'.$this->salesName());
				$data["array"] = $a;
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}



	public function mgnt_process_rvw_inbound2($id){
		
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_".$this->salesName()."/mgnt_".$this->salesName()."_rvw_inbound2.php";
			$data["content_js"] = "qa_".$this->salesName()."_js.php";
			$data["page"]=$this->salesName();
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,54) and status=1  order by name";
			/* and is_assign_process (id,124) */
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_".$this->salesName()."_inbound2_feedback where id='$id') xx Left Join
				(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid)";
			$data[$this->salesName()."_new"] = $this->Common_model->get_query_row_array($qSql);
			
			$data["pnid"]=$id;
			$a = array();
			
		///////Edit Part///////	
			if($this->input->post('pnid'))
			{
				$pnid=$this->input->post('pnid');
				$curDateTime=CurrMySqlDate();
				$log=get_logs();
				
				$field_array=$this->input->post('data');
				
				if($_FILES['attach_file']['tmp_name'][0]!=''){
					$a = $this->mt_upload_files($_FILES['attach_file']);
					$field_array["attach_file"] = implode(',',$a);
				}
				
				$this->db->where('id', $pnid);
				$this->db->update('qa_'.$this->salesName().'_inbound2_feedback',$field_array);
				
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
				$this->db->update('qa_'.$this->salesName().'_inbound2_feedback',$field_array1);
			///////////	
				redirect('Qa_'.$this->salesName());
				$data["array"] = $a;
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}
	
	


/////////////////Agent part//////////////////////////	

	public function agent_process_feedback()
	{
		if(check_logged_in())
		{
			$user_site_id= get_user_site_id();
			$role_id= get_role_id();
			$current_user = get_user_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_".$this->salesName()."/agent_".$this->salesName()."_feedback.php";

			$data["agentUrl"] = "qa_".$this->salesName()."/agent_process_feedback";
			$data["content_js"] = "qa_".$this->salesName()."_js.php";
			$data["page"]=$this->salesName();
			
			$from_date = '';
			$to_date = '';
			$campaign = '';
			$cond="";
			
			$campaign=$this->input->get('campaign');
			
			if($campaign=='sales'){
				$cmp_tbl='qa_sales_carpart_feedback';
				$data["page"]=$this->salesName();
			}else if($campaign=='service'){
				$cmp_tbl='qa_service_feedback';
				$data["page"]="service";
			}else if($campaign=='inbound'){
				$cmp_tbl='qa_sales_carpart_inbound_feedback';
				$data["page"]=$this->salesName();
			}else if($campaign=='inbound2'){
				$cmp_tbl='qa_sales_carpart_inbound2_feedback';
				$data["page"]=$this->salesName();
			}
			
			if($campaign!=''){
				
				$qSql="Select count(id) as value from $cmp_tbl where agent_id='$current_user' and audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit')";
				$data["tot_feedback"] =  $this->Common_model->get_single_value($qSql);
				
				$qSql="Select count(id) as value from $cmp_tbl where agent_rvw_date is null and agent_id='$current_user' and audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit') ";
				$data["yet_rvw"] =  $this->Common_model->get_single_value($qSql);
				
				if($this->input->get('btnView')=='View')
				{
				
					$fromdate = $this->input->get('from_date');
					if($fromdate!="") $from_date = mmddyy2mysql($fromdate);
					
					$todate = $this->input->get('to_date');
					if($todate!="") $to_date = mmddyy2mysql($todate);
					
					if($from_date !=="" && $to_date!=="" ){ 
						$cond= " Where (audit_date >= '$from_date' and audit_date <= '$to_date') And agent_id='$current_user' and audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit')";
					}else{
						$cond= " Where agent_id='$current_user' and audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit')";
					}
					
					$qSql="SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, (select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_name from $cmp_tbl $cond) xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to from signin) yy on (xx.agent_id=yy.sid) order by audit_date";
					$data[$data["page"]."_agent_list"] = $this->Common_model->get_query_result_array($qSql);	
				}
				/* else{
					$cond= " Where agent_id='$current_user' and audit_type in ('CQ Audit', 'BQ Audit')";
					$qSql="SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, (select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_name from qa_".$this->salesName()."_feedback $cond) xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to from signin) yy on (xx.agent_id=yy.sid) order by audit_date";
					$data[$this->salesName()."_agent_list"] = $this->Common_model->get_query_result_array($qSql);
				} */
			
			}
			
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			$data["campaign"] = $campaign;
			$this->load->view('dashboard',$data);
		}
	}
	
	public function agent_process_rvw($id,$campaign){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_".$this->salesName()."/agent_".$this->salesName()."_rvw.php";
			$data["agentUrl"] = "qa_".$this->salesName()."/agent_process_feedback";
			$data["content_js"] = "qa_".$this->salesName()."_js.php";
			
			$data["campaign"]=$campaign;
			
			if($campaign=='sales'){
				$cmp_tbl='qa_sales_carpart_feedback';
				$data["page"]=$this->salesName();
			}else if($campaign=='service'){
				$cmp_tbl='qa_service_feedback';
				$data["page"]="service";
			}else if($campaign=='inbound'){
				$cmp_tbl='qa_sales_carpart_inbound_feedback';
				$data["page"]=$this->salesName();
			}else if($campaign=='inbound2'){
				$cmp_tbl='qa_sales_carpart_inbound2_feedback';
				$data["page"]=$this->salesName();
			}
						
			$qSql="SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, (select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_name,agent_rvw_note as agent_note,mgnt_rvw_note as mgnt_note from $cmp_tbl where id=$id) xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to from signin) yy on (xx.agent_id=yy.sid) order by audit_date";
			$data[$data["page"]."_agnt_feedback"] = $this->Common_model->get_query_row_array($qSql);
			
			$data["pnid"]=$id;			
			
			if($this->input->post('pnid'))
			{
				$pnid=$this->input->post('pnid');
				$curDateTime=CurrMySqlDate();
				$log=get_logs();
				$agnt_fd_acpt = $this->input->post('agnt_fd_acpt');
				if($agnt_fd_acpt!=''){
						$field_array=array(
						"agent_rvw_note" => $this->input->post('note'),
						"agnt_fd_acpt" => $this->input->post('agnt_fd_acpt'),
						"agent_rvw_date" => $curDateTime
					);
				}else{
					$field_array=array(
						"agent_rvw_note" => $this->input->post('note'),
						"agent_rvw_date" => $curDateTime
					);
				}
				
				
				$this->db->where('id', $pnid);
				$this->db->update($cmp_tbl,$field_array);
				
				redirect('Qa_'.$this->salesName().'/process/agent');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}



	public function agent_process_rvw_inbound($id,$campaign){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_".$this->salesName()."/agent_".$this->salesName()."_rvw.php";
			$data["agentUrl"] = "qa_".$this->salesName()."/agent_process_feedback";
			$data["content_js"] = "qa_".$this->salesName()."_js.php";
			
			$data["campaign"]=$campaign;
			
			if($campaign=='sales'){
				$cmp_tbl='qa_sales_carpart_feedback';
				$data["page"]=$this->salesName();
			}else if($campaign=='service'){
				$cmp_tbl='qa_service_feedback';
				$data["page"]="service";
			}else if($campaign=='inbound'){
				$cmp_tbl='qa_service_inbound_feedback';
				$data["page"]=$this->salesName();
			}
						
			$qSql="SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, (select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_name,agent_rvw_note as agent_note,mgnt_rvw_note as mgnt_note from $cmp_tbl where id=$id) xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to from signin) yy on (xx.agent_id=yy.sid) order by audit_date";
			$data[$data["page"]."_agnt_feedback"] = $this->Common_model->get_query_row_array($qSql);
			
			$data["pnid"]=$id;			
			
			if($this->input->post('pnid'))
			{
				$pnid=$this->input->post('pnid');
				$curDateTime=CurrMySqlDate();
				$log=get_logs();
				
				$field_array=array(
					"agent_rvw_note" => $this->input->post('note'),
					"agent_rvw_date" => $curDateTime
				);
				$this->db->where('id', $pnid);
				$this->db->update($cmp_tbl,$field_array);
				
				redirect('Qa_'.$this->salesName().'/process/agent');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}

	public function agent_process_rvw_inbound2($id,$campaign){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_".$this->salesName()."/agent_".$this->salesName()."_rvw.php";
			$data["agentUrl"] = "qa_".$this->salesName()."/agent_process_feedback";
			$data["content_js"] = "qa_".$this->salesName()."_js.php";
			
			$data["campaign"]=$campaign;
			
			if($campaign=='sales'){
				$cmp_tbl='qa_sales_carpart_feedback';
				$data["page"]=$this->salesName();
			}else if($campaign=='service'){
				$cmp_tbl='qa_service_feedback';
				$data["page"]="service";
			}else if($campaign=='inbound'){
				$cmp_tbl='qa_service_inbound_feedback';
				$data["page"]=$this->salesName();
			}else if($campaign=='inbound2'){
				$cmp_tbl='qa_service_inbound2_feedback';
				$data["page"]=$this->salesName();
			}
						
			$qSql="SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, (select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_name,agent_rvw_note as agent_note,mgnt_rvw_note as mgnt_note from $cmp_tbl where id=$id) xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to from signin) yy on (xx.agent_id=yy.sid) order by audit_date";
			$data[$data["page"]."_agnt_feedback"] = $this->Common_model->get_query_row_array($qSql);
			
			$data["pnid"]=$id;			
			
			if($this->input->post('pnid'))
			{
				$pnid=$this->input->post('pnid');
				$curDateTime=CurrMySqlDate();
				$log=get_logs();
				
				$field_array=array(
					"agent_rvw_note" => $this->input->post('note'),
					"agent_rvw_date" => $curDateTime
				);
				$this->db->where('id', $pnid);
				$this->db->update($cmp_tbl,$field_array);
				
				redirect('Qa_'.$this->salesName().'/process/agent');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}

	/////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////// Report Part //////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////

	public function qa_sales_carpart_report(){
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
			$data["content_template"] = "qa_sales_carpart/qa_sales_carpart_report.php";
			$data["content_js"] = "qa_sales_carpart_js.php";
			
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
			$user="";
			
			$campaign ="inbound";
			
			$data["inbound_list"] = array();
			
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
               
				if(get_role_dir()=='agent'){
					$user .="where id ='$current_user'";
				}
				
				
				$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name,
				(select concat(fname, ' ', lname) as name from signin_client scx where scx.id=client_rvw_by) as client_rvw_name from qa_sales_carpart_inbound_feedback) xx Inner Join
				(Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_ids(id) as process_id, get_process_names(id) as process, doj, DATEDIFF(CURDATE(), doj) as tenure from signin) yy on (xx.agent_id=yy.sid) $cond $cond1 order by audit_date";
				
				$fullAray = $this->Common_model->get_query_result_array($qSql);
				$data["inbound_list"] = $fullAray;
				$this->create_qa_inbound_CSV($fullAray,$campaign);	
				$dn_link = base_url()."Qa_sales_carpart/download_qa_inbound_CSV/".$campaign;	
			}
			
			$data['download_link']=$dn_link;
			$data["action"] = $action;	
			$data['date_from'] = $date_from;
			$data['date_to'] = $date_to;	
			$data['office_id']=$office_id;
			$data['audit_type']=$audit_type;
			$data['campaign']=$campaign;
			
			$this->load->view('dashboard',$data);
		}
	}	
	 

	public function download_qa_inbound_CSV($campaign)
	{
		$currDate=date("Y-m-d");
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$newfile="QA ".$campaign." Audit List-'".$currDate."'.csv";
		header('Content-Disposition: attachment;  filename="'.$newfile.'"');
		readfile($filename);
	}


	public function create_qa_inbound_CSV($rr,$campaign)
	{
		$currDate=date("Y-m-d");
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$fopen = fopen($filename,"w+");
		
			$header = array("Auditor Name","Audit Date","Fusion Id","Agent","L1 Super","Call Id","Call Date","Call Duration","Call Type","Audit Type ","Auditor Type ","VOC ","QA Sampling ","Order Number ","NPS","CSAT","Overall Score ","Possible Score ","Earned Score ","Auto Fail ","Sales Call Type ","Introduction ","Obtaining Customer' Needs","Questioning ","Presentation ","Closing the Sale ","CPP ","Related Parts / Parts Tray","RepairPal","Shipping Options / Shipping Details","Shipping & Billing / YMMSE / Part Name(s)","Tracking Email ","Asking / Offering for additional assistance","CSAT / NPS Survey","Rebranding ","Discount Rules","MyAccount utilization","Data Gathering Compliance","Accuracy", "Documentation ", "Hold Time","Overcoming Objections","Comments 1 ","Comments 2 ","Comments 3 ","Comments 4 ","Comments 5 ","Comments 6 ","Comments 7 ","Comments 8 ","Comments 9 ","Comments 10 ","Comments 11 ","Comments 12 ","Comments 13 ","Comments 14 ","Comments 15 ","Comments 16 ","Comments 17 ","Comments 18 ", "Comments 19", "Comments 20","Comments 21", "Call Summary ","Feedback ","Entry By ","Entry Date ","Audit Start Time ","Client entry by ","Mgnt review by ","Mgnt review note ","Mgnt review date ","Agent review note ","Agent review date ","Client review by ","Client review note ","Client_rvw_date");
		
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
				$row .= '"'.$user['fusion_id'].'",';
				$row .= '"'.$user['fname']." ".$user['lname'].'",';	
				$row .= '"'.$user['tl_name'].'",';
				$row .= '"'.$user['call_id'].'",';
				$row .= '"'.$user['call_date'].'",';
				$row .= '"'.$user['call_duration'].'",';
				$row .= '"'.$user['call_type'].'",';
				$row .= '"'.$user['audit_type'].'",';
				$row .= '"'.$user['auditor_type'].'",';
				$row .= '"'.$user['voc'].'",';
				$row .= '"'.$user['qa_sampling'].'",';
				$row .= '"'.$user['order_no'].'",';
				$row .= '"'.$user['nps'].'",';
				$row .= '"'.$user['csat'].'",';
				$row .= '"'.$user['overall_score'].'",';
				$row .= '"'.$user['possible_score'].'",';
				$row .= '"'.$user['earned_score'].'",';
				$row .= '"'.$user['auto_fail'].'",';
				$row .= '"'.$user['sales_call_type'].'",';
				
                $row .= '"'.$user['Introduction'].'",';
				$row .= '"'.$user['active_listening'].'",';
				$row .= '"'.$user['questioning'].'",';
				$row .= '"'.$user['presentation'].'",';
				$row .= '"'.$user['closing_sale'].'",';
				$row .= '"'.$user['add_cpp'].'",';
				$row .= '"'.$user['add_parts'].'",';
				$row .= '"'.$user['RepairPal'].'",';
				$row .= '"'.$user['shipping_options'].'",';
				$row .= '"'.$user['shipping_billing'].'",';
				$row .= '"'.$user['tracking_email_recap'].'",';
				$row .= '"'.$user['additional_assistance'].'",';
				$row .= '"'.$user['NPS_survey'].'",';
				$row .= '"'.$user['rebranding_new'].'",';
				$row .= '"'.$user['discount_rules'].'",';
				$row .= '"'.$user['account_verification'].'",';
				$row .= '"'.$user['data_gathering'].'",';
				$row .= '"'.$user['account_accuracy'].'",';
				$row .= '"'.$user['documentation'].'",';
				$row .= '"'.$user['hold_time'].'",';
				$row .= '"'.$user['Overcoming_Objections'].'",';

              
                $row .= '"'.$user['cmt1'].'",';
                $row .= '"'.$user['cmt2'].'",';
                $row .= '"'.$user['cmt3'].'",';
                $row .= '"'.$user['cmt4'].'",';
                $row .= '"'.$user['cmt5'].'",';
                $row .= '"'.$user['cmt6'].'",';
                $row .= '"'.$user['cmt7'].'",';
                $row .= '"'.$user['cmt8'].'",';
                $row .= '"'.$user['cmt9'].'",';
                $row .= '"'.$user['cmt10'].'",';
                $row .= '"'.$user['cmt11'].'",';
                $row .= '"'.$user['cmt12'].'",';
                $row .= '"'.$user['cmt13'].'",';
                $row .= '"'.$user['cmt14'].'",';
                $row .= '"'.$user['cmt15'].'",';
                $row .= '"'.$user['cmt16'].'",';
                $row .= '"'.$user['cmt17'].'",';
                $row .= '"'.$user['cmt18'].'",';
                $row .= '"'.$user['cmt19'].'",';
                $row .= '"'.$user['cmt20'].'",';
                $row .= '"'.$user['cmt21'].'",';
                
                
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