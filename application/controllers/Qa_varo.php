<?php 

 class Qa_varo extends CI_Controller{
	
	public function __construct(){
		parent::__construct();
		$this->load->model('user_model');
		$this->load->model('Common_model');
	}
	
	
	private function mt_upload_files($files,$path)
    {
        $config['upload_path'] = $path;
		$config['allowed_types'] = 'mp3|avi|mp4|wmv|wav|jpg|jpeg|png';
		$config['max_size'] = '2024000';
		$this->load->library('upload', $config);
		$this->upload->initialize($config);

        $images = array();
        foreach ($files['name'] as $key => $image) {           
			$_FILES['images[]']['name']= $files['name'][$key];
			$_FILES['images[]']['type']= $files['type'][$key];
			$_FILES['images[]']['tmp_name']= $files['tmp_name'][$key];
			$_FILES['images[]']['error']= $files['error'][$key];
			$_FILES['images[]']['size']= $files['size'][$key];

            if ($this->upload->do_upload('images[]')) {
				$info = $this->upload->data();
				$images[] = $info['file_name'];
            } else {
                return false;
            }
        }
        return $images;
    }
	
	
////////////////////// VARO /////////////////////////

	public function index(){
		if(check_logged_in())
		{
			$current_user = get_user_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_varo/qa_varo_feedback.php";
			$data["content_js"] = "qa_clio_js.php";
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,240) and is_assign_process (id,541) and status=1  order by name";
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
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_varo_rp_feedback $cond) xx Left Join
				(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";
			$data["varo_list"] = $this->Common_model->get_query_result_array($qSql);

			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_varo_lm_feedback $cond) xx Left Join
				(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";
			$data["varo_lm_list"] = $this->Common_model->get_query_result_array($qSql);

			///////////VIKAS///////////
			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_varo_rp_v2_feedback $cond) xx Left Join
				(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";
			$data["varo_RP_V2_list"] = $this->Common_model->get_query_result_array($qSql);

			///////////VIKAS ENDS//////
			
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			$data["agent_id"] = $agent_id;
			
			$this->load->view("dashboard",$data);
		}
	}



	public function add_edit_varo_rp($varo_rp_id){
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_varo/add_edit_varo_rp.php";
			$data["content_js"] = "qa_clio_js.php";
			$data['varo_rp_id']=$varo_rp_id;
			$tl_mgnt_cond='';
			
			if(get_role_dir()=='manager' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";
			}else if(get_role_dir()=='tl' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and assigned_to='$current_user'";
			}else{
				$tl_mgnt_cond="";
			}
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client(id,240) and is_assign_process(id,541) and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * FROM signin where role_id not in (select id from role where folder='agent')";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
				from qa_varo_rp_feedback where id='$varo_rp_id') xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
			$data["varo_rp"] = $this->Common_model->get_query_row_array($qSql);
			
			//$currDate=CurrDate();
			$curDateTime=CurrMySqlDate();
			$a = array();
			
			
			$field_array['agent_id']=!empty($_POST['data']['agent_id'])?$_POST['data']['agent_id']:"";
			
			if($field_array['agent_id']){
				
				if($varo_rp_id==0){
					$field_array=$this->input->post('data');
					$field_array['audit_date']=CurrDate();
					$field_array['call_date']=mmddyy2mysql($this->input->post('call_date'));
					//$field_array['go_live_date']=mmddyy2mysql($this->input->post('go_live_date'));
					$field_array['entry_date']=$curDateTime;
					$field_array['audit_start_time']=$this->input->post('audit_start_time');

					$a = $this->mt_upload_files($_FILES['attach_file'], $path='./qa_files/qa_varo_rp/');
                    $field_array["attach_file"] = implode(',',$a);

					$rowid= data_inserter('qa_varo_rp_feedback',$field_array);
					if(get_login_type()=="client"){
						$add_array = array("client_entryby" => $current_user);
					}else{
						$add_array = array("entry_by" => $current_user);
					}
					$this->db->where('id', $rowid);
					$this->db->update('qa_varo_rp_feedback',$add_array);
					
				}else{
					
					$field_array1=$this->input->post('data');
					$field_array1['call_date']=mmddyy2mysql($this->input->post('call_date'));
					$this->db->where('id', $varo_rp_id);
					$this->db->update('qa_varo_rp_feedback',$field_array1);
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
					$this->db->where('id', $varo_rp_id);
					$this->db->update('qa_varo_rp_feedback',$edit_array);
					
				}
					
				redirect('qa_varo');
			}
			$data["array"] = $a;
			
			$this->load->view("dashboard",$data);
		}
	}
	
	/* VARO RP V2 Start Date : 15-06-23*/
	
	public function add_edit_varo_rp_v2($varo_rp_id){
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_varo/add_edit_varo_rp_v2.php";
			$data["content_js"] = "qa_varo_js.php";
			$data['varo_rp_id']=$varo_rp_id;
			$tl_mgnt_cond='';
			
			if(get_role_dir()=='manager' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";
			}else if(get_role_dir()=='tl' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and assigned_to='$current_user'";
			}else{
				$tl_mgnt_cond="";
			}
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client(id,240) and is_assign_process(id,541) and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * FROM signin where role_id not in (select id from role where folder='agent')";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
				from qa_varo_rp_v2_feedback where id='$varo_rp_id') xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
			$data["varo_rp"] = $this->Common_model->get_query_row_array($qSql);
			
			//$currDate=CurrDate();
			$curDateTime=CurrMySqlDate();
			$a = array();
			
			
			$field_array['agent_id']=!empty($_POST['data']['agent_id'])?$_POST['data']['agent_id']:"";
			
			if($field_array['agent_id']){
				
				if($varo_rp_id==0){
					$field_array=$this->input->post('data');
					$field_array['audit_date']=CurrDate();
					$field_array['call_date']=mmddyy2mysql($this->input->post('call_date'));
					//$field_array['go_live_date']=mmddyy2mysql($this->input->post('go_live_date'));
					$field_array['entry_date']=$curDateTime;
					$field_array['audit_start_time']=$this->input->post('audit_start_time');

					$a = $this->mt_upload_files($_FILES['attach_file'], $path='./qa_files/qa_varo_rp/');
                    $field_array["attach_file"] = implode(',',$a);

					$rowid= data_inserter('qa_varo_rp_v2_feedback',$field_array);
					if(get_login_type()=="client"){
						$add_array = array("client_entryby" => $current_user);
					}else{
						$add_array = array("entry_by" => $current_user);
					}
					$this->db->where('id', $rowid);
					$this->db->update('qa_varo_rp_v2_feedback',$add_array);
					
				}else{
					
					$field_array1=$this->input->post('data');
					$field_array1['call_date']=mmddyy2mysql($this->input->post('call_date'));
					$this->db->where('id', $varo_rp_id);
					$this->db->update('qa_varo_rp_v2_feedback',$field_array1);
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
					$this->db->where('id', $varo_rp_id);
					$this->db->update('qa_varo_rp_v2_feedback',$edit_array);
					
				}
					
				redirect('qa_varo');
			}
			$data["array"] = $a;
			
			$this->load->view("dashboard",$data);
		}
	}
	
	/* END */

	public function add_edit_varo_lm($varo_lm_id){
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_varo/add_edit_varo_lm.php";
			$data["content_js"] = "qa_clio_js.php";
			$data['varo_lm_id']=$varo_lm_id;
			$tl_mgnt_cond='';
			
			if(get_role_dir()=='manager' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";
			}else if(get_role_dir()=='tl' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and assigned_to='$current_user'";
			}else{
				$tl_mgnt_cond="";
			}
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client(id,199) and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * FROM signin where role_id not in (select id from role where folder='agent')";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
				from qa_varo_lm_feedback where id='$varo_lm_id') xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
			$data["varo_lm"] = $this->Common_model->get_query_row_array($qSql);
			
			//$currDate=CurrDate();
			$curDateTime=CurrMySqlDate();
			$a = array();
			
			
			$field_array['agent_id']=!empty($_POST['data']['agent_id'])?$_POST['data']['agent_id']:"";
			
			if($field_array['agent_id']){
				
				if($varo_lm_id==0){
					$field_array=$this->input->post('data');
					$field_array['audit_date']=CurrDate();
					$field_array['call_date']=mmddyy2mysql($this->input->post('call_date'));
					$field_array['entry_date']=$curDateTime;
					$field_array['audit_start_time']=$this->input->post('audit_start_time');

					$a = $this->mt_upload_files($_FILES['attach_file'], $path='./qa_files/qa_varo_lm/');
                    $field_array["attach_file"] = implode(',',$a);

					$rowid= data_inserter('qa_varo_lm_feedback',$field_array);
					if(get_login_type()=="client"){
						$add_array = array("client_entryby" => $current_user);
					}else{
						$add_array = array("entry_by" => $current_user);
					}
					$this->db->where('id', $rowid);
					$this->db->update('qa_varo_lm_feedback',$add_array);
					
				}else{
					
					$field_array1=$this->input->post('data');
					$field_array1['call_date']=mmddyy2mysql($this->input->post('call_date'));
					$this->db->where('id', $varo_lm_id);
					$this->db->update('qa_varo_lm_feedback',$field_array1);
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
					$this->db->where('id', $varo_lm_id);
					$this->db->update('qa_varo_lm_feedback',$edit_array);
					
				}
					
				redirect('qa_varo');
			}
			$data["array"] = $a;
			
			$this->load->view("dashboard",$data);
		}
	}


/////////////////////////////////////////////////////////////////////
/////////////////////////Agent part/////////////////////////////////	
public function agent_varo_feedback()
	{
		if(check_logged_in())
		{
			$user_site_id= get_user_site_id();
			$role_id= get_role_id();
			$current_user = get_user_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_varo/agent_varo_feedback.php";
			$data["content_js"] = "qa_varo_js.php";
			$data["agentUrl"] = "qa_varo/agent_varo_feedback";
			
			$qSql="Select count(id) as value from qa_varo_rp_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit')";
			$data["tot_feedback"] =  $this->Common_model->get_single_value($qSql);

			$qSql="Select count(id) as value from qa_varo_rp_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit') and agent_rvw_date is Null";
			$data["yet_rvw"] =  $this->Common_model->get_single_value($qSql);

			$qSql="Select count(id) as value from qa_varo_lm_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit')";
			$data["tot_lm_feedback"] =  $this->Common_model->get_single_value($qSql);
			
			$qSql="Select count(id) as value from qa_varo_lm_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit') and agent_rvw_date is Null";
			$data["yet_lm_rvw"] =  $this->Common_model->get_single_value($qSql);

			$qSql="Select count(id) as value from qa_varo_rp_v2_feedback where agent_id='$current_user' and audit_type not in ('Calibration', 'Pre-Certificate Mock Call', 'Certification Audit')";
			$data["tot_feedback_varo_v2"] =  $this->Common_model->get_single_value($qSql);

			$qSql="Select count(id) as value from qa_varo_rp_v2_feedback where agent_rvw_date is null and agent_id='$current_user' and audit_type not in ('Calibration', 'Pre-Certificate Mock Call', 'Certification Audit')";
			$data["yet_rvw_varo_v2"] =  $this->Common_model->get_single_value($qSql);


			$from_date = '';
			$to_date = '';
			$cond="";
			$user="";
			if(get_role_dir()=='agent'){
					$user .="where id ='$current_user'";
				}
			
			if($this->input->get('btnView')=='View')
			{
				$from_date = mmddyy2mysql($this->input->get('from_date'));
				$to_date = mmddyy2mysql($this->input->get('to_date'));
				
				if($from_date !="" && $to_date!=="" )  $cond= " Where (audit_date >= '$from_date' and audit_date <= '$to_date' ) ";
				
				$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_varo_rp_feedback $cond And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit')) xx Inner Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_client_names(id) as client, get_process_names(id) as process from signin $user) yy on (xx.agent_id=yy.sid)";
				$data["agent_rvw_list"] = $this->Common_model->get_query_result_array($qSql);

				$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_varo_lm_feedback $cond And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit')) xx Inner Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_client_names(id) as client, get_process_names(id) as process from signin $user) yy on (xx.agent_id=yy.sid)";
				$data["agent_lm_rvw_list"] = $this->Common_model->get_query_result_array($qSql);

				//////////////vikas//////////////////////

				$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_varo_rp_v2_feedback $cond and agent_id='$current_user' And audit_type not in ('Calibration', 'Pre-Certificate Mock Call', 'Certification Audit')) xx Left Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid)";
				$data["agent_rvw_rp_v2_list"] = $this->Common_model->get_query_result_array($qSql);

			}else{
             $qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_varo_rp_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit')) xx Inner Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_client_names(id) as client, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid) Where xx.agent_rvw_date is Null";
				$data["agent_rvw_list"] = $this->Common_model->get_query_result_array($qSql);
				$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_varo_lm_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit')) xx Inner Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_client_names(id) as client, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid) Where xx.agent_rvw_date is Null";
				$data["agent_lm_rvw_list"] = $this->Common_model->get_query_result_array($qSql);

				//////////////vikas/////////////////////	
				$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_varo_rp_v2_feedback where agent_id='$current_user' And audit_type not in ('Calibration', 'Pre-Certificate Mock Call', 'Certification Audit')) xx Left Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid) ";
				//Where xx.agent_rvw_date is Null
				$data["agent_rvw_rp_v2_list"] = $this->Common_model->get_query_result_array($qSql);

			}
			
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			
			$this->load->view('dashboard',$data);
		}
	}

	public function agent_varo_rp_rvw($id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			$data['varo_rp_id']=$id;
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_varo/agent_varo_rp_rvw.php";
			$data["content_js"] = "qa_clio_js.php";
			$data["agentUrl"] = "qa_varo/agent_varo_feedback";
			
			$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_varo_rp_feedback where id='$id') xx Left Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
			$data["varo_rp"] = $this->Common_model->get_query_row_array($qSql);
			
			$data["varo_rp_id"]=$id;
			
			if($this->input->post('varo_rp_id'))
			{
				$varo_rp_id=$this->input->post('varo_rp_id');
				$curDateTime=CurrMySqlDate();
				$log=get_logs();
					
				$field_array1=array(
					"agnt_fd_acpt" => $this->input->post('agnt_fd_acpt'),
					"agent_rvw_note" => $this->input->post('note'),
					"agent_rvw_date" => $curDateTime
				);
				$this->db->where('id', $varo_rp_id);
				$this->db->update('qa_varo_rp_feedback',$field_array1);
					
				redirect('qa_varo/agent_varo_feedback');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}

	public function agent_varo_lm_rvw($id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			$data['varo_lm_id']=$id;
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_varo/agent_varo_lm_rvw.php";
			$data["content_js"] = "qa_clio_js.php";
			$data["agentUrl"] = "qa_varo/agent_varo_feedback";
			
			$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_varo_lm_feedback where id='$id') xx Left Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
			$data["varo_lm"] = $this->Common_model->get_query_row_array($qSql);
			
			$data["varo_lm_id"]=$id;
			
			if($this->input->post('varo_lm_id'))
			{
				$varo_lm_id=$this->input->post('varo_lm_id');
				$curDateTime=CurrMySqlDate();
				$log=get_logs();
					
				$field_array1=array(
					"agnt_fd_acpt" => $this->input->post('agnt_fd_acpt'),
					"agent_rvw_note" => $this->input->post('note'),
					"agent_rvw_date" => $curDateTime
				);
				$this->db->where('id', $varo_lm_id);
				$this->db->update('qa_varo_lm_feedback',$field_array1);
					
				redirect('qa_varo/agent_varo_feedback');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}

	/////////////vikas//////////////////////

	public function agent_varo_rp_v2_rvw($id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			$data['varo_rp_id']=$id;
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_varo/agent_varo_rp_v2_rvw.php";
			$data["content_js"] = "qa_varo_js.php";
			$data["agentUrl"] = "qa_varo/agent_varo_feedback";
			
			$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_varo_rp_v2_feedback where id='$id') xx Left Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
			$data["varo_rp"] = $this->Common_model->get_query_row_array($qSql);
			
			$data["varo_rp_v2_id"]=$id;
			
			if($this->input->post('varo_rp_v2_id'))
			{
				$varo_rp_v2_id=$this->input->post('varo_rp_v2_id');
				$curDateTime=CurrMySqlDate();
				$log=get_logs();
					
				$field_array1=array(
					"agnt_fd_acpt" => $this->input->post('agnt_fd_acpt'),
					"agent_rvw_note" => $this->input->post('note'),
					"agent_rvw_date" => $curDateTime
				);
				$this->db->where('id', $varo_rp_v2_id);
				$this->db->update('qa_varo_rp_v2_feedback',$field_array1);
					
				redirect('qa_varo/agent_varo_feedback');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}

	/////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////// Report Part //////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////


	public function qa_varo_report(){
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
			$data["content_template"] = "reports_qa/qa_varo_report.php";
			$data["content_js"] = "qa_clio_js.php";
			
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
			
			//$campaign ="varo_rp";
			
			$data["qa_varo_list"] = array();
			
			if($this->input->get('show')=='Show')
			{
				$date_from = mmddyy2mysql($this->input->get('from_date'));
				$date_to = mmddyy2mysql($this->input->get('to_date'));
				$office_id = $this->input->get('office_id');
				$audit_type = $this->input->get('audit_type');
				$campaign = $this->input->get('p_id');
				
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
					//$cond .=" and audit_type='All'";
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
				
                 $qSql="SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, (select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_".$campaign."_feedback) xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, get_process_names(id) as campaign, DATEDIFF(CURDATE(), doj) as tenure, assigned_to from signin) yy on (xx.agent_id=yy.sid) $cond $cond1";
                      
				$fullAray = $this->Common_model->get_query_result_array($qSql);
				$data["qa_varo_list"] = $fullAray;
				$this->create_qa_varo_CSV($fullAray,$campaign);	
				$dn_link = base_url()."qa_varo/download_varo_CSV/".$campaign;	
			}
			
			$data['download_link']=$dn_link;
			$data["action"] = $action;	
			$data['date_from'] = $date_from;
			$data['date_to'] = $date_to;	
			$data['office_id']=$office_id;
			$data['process_id']=$campaign;
			$data['audit_type']=$audit_type;
			$data['campaign']=$campaign;
			
			$this->load->view('dashboard',$data);
		}
	}

	public function download_varo_CSV($campaign)
	{
		$currDate=date("Y-m-d");
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$newfile="QA ".$campaign." Audit List-'".$currDate."'.csv";
		header('Content-Disposition: attachment;  filename="'.$newfile.'"');
		readfile($filename);
	}


	public function create_qa_varo_CSV($rr,$campaign)
	{
		$currDate=date("Y-m-d");
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$fopen = fopen($filename,"w+");
		   if($campaign=='varo_rp') {
			$header = array("Auditor Name", "Audit Date", "Agent", "Fusion ID", "L1 Super", "Contact Date","Audit Type", "Auditor Type", "Voc","Audit Start Date Time","Audit End Date Time","Interval","VSI Account","QA Type","Call ID","Area of Opportunity","Overall Score","Identify himself/herself by first and last name at the beginning of the call? **SQ**","Provide the Quality Assurance Statement verbatim before any specific account information was discussed?**SQ**","State Varo Bank with no deviation? **SQ**","Verify that he/she was speaking to a right party according to the client requirements (First and Last Name) and before providing the disclosures?","Verify two pieces of demographics information on an outbound call and two pieces on an inbound call? 1) must abide by client requirements and 2) Consumer must provide information unless there is a resistance. 3)Must be completed before disclosures 4) Exception on consumer fail to verify two pieces of demographics information/fail to verify complete address (missing street number etc) ","Provide the Mini Miranda disclosure verbatim before any specific account information was discussed? **SQ**","State the client name and the purpose of the communication?","State/Ask for balance due?","Ask for intention to resolve the account?","Ask for the payment to the account?","Help customer reset password for app incase customer states they have forgotten password ?","Followed the previous conversations on the account for the follow-up call","Able to take a promise to pay on the account?","Did Collector try to negotiate effectively to convince the customer for payment?","Did not  Misrepresent their identity or authorization and status of the consumers account?","Did not Discuss or imply that any type of legal actions - will be taken or property repossessed also on time barred accounts amd Did not Threaten to take actions that VRS or the client cannot legally take? ","Did not Make any false representations regarding the nature of the communication?","Did not Contact the consumer at any unusual times (sate regulations) or outside the hours of 8:00 am and 9:00 pm at the consumers location?","Did not Communicate with the consumer at work if it is known or there is reason to know that such calls are prohibited?","Did not Communicate with the consumer after learning the consumer is represented by an attorney filed for bankruptcy unless a permissible reason exists?","Adhere to the cell phone policy/TCPA regulations and policy regarding contacting consumers via cell phone email and fax?","Adhere to policy regarding third parties for the sole purpose of obtaining location information for the consumer?","Enter Status code/disposition codes correctly to ensure that inappropriate dialing does not take place?","Did not Make any statement that could constitute unfair deceptive or abusive acts or practices that may raise UDAAP concerns?","Did not Communicate or threaten to communicate false credit information or information which should be known to be false and utilized the proper CBR script whenever a consumer enquires about that?","Handle the consumers dispute correctly and take appropriate action including providing the consumer with the correct contact information to submit a written dispute or complaint or offer to escalate the call?","Did not Make the required statement on time barred accounts indicating that the consumer cannot be pursued with legal action?","Adhere to FDCPA  laws?","Did not Make any statement that could be considered discriminatory towards a consumer or a violation of VRS ECOA policy?","Did the collectors adhere to the State Restrictions?","Demonstrate Active Listening?","Represent the company and the client in a positive manner?","Anticipate and overcome objections?","Transfer call to Varo support appropriately?","Summarize the call?","Provided Varo Bank support number incase its required?","Set appropriate timelines and expectations for follow up?","Close the call Professionally?","Use the proper action code?","Use the proper result code?","Document thoroughly the context of the conversation?","Confirmation Code captured on note incase of payment?","Remove any phone numbers known to be incorrect?**SQ**","Update address information if appropriate?**SQ**","Change the status of the account if appropriate?**SQ**","Escalate the account to a supervisor for handling if appropriate?","Call Summary", "Feedback","Agent Feedback Acceptance", "Agent Review Date","Agent Comment","Mgnt Review Date","Mgnt Review By", "Mgnt Comment");
		        
		        } else if($campaign=='varo_lm'){
		        $header = array("Auditor Name", "Audit Date", "Agent", "Fusion ID", "L1 Super", "Call Date","Audit Type", "Auditor Type", "Voc","Hire Date","Audit Start Date Time","Audit End Date Time","Interval","VSI Account","Overall Score","State the First/Second left message attempt with no deviation or did not leave any message in NYC or with consumers of clients that prohibit the leaving of voice mail messages. **SQ**","Misrepresent their identity? **SQ**","Make any false representations about the nature of the call/ **SQ**","Make an attempt at any unusual times (state restrictions) or outside the hours of 8am and 9pm? **SQ**","Make an attempt at a work number if it is known or there is reason to know that such calls are prohibited? **SQ**","Make an attempt after learning that the consumer is represented by an attorney unless a permissible reason exists? **SQ**	","Adhere to policy regarding third parties and third party disclosure? **SQ**","Enter dialer disposition codes correctly to ensure that inappropriate dialing does not take place? **SQ**","Use the proper Action Code? **SQ**","Use the proper Result Code? **SQ**","Document the account thoroughly?","Call Summary", "Feedback","Agent Feedback Acceptance", "Agent Review Date","Agent Comment","Mgnt Review Date","Mgnt Review By", "Mgnt Comment");	
		        }

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

			    if($campaign=='varo_rp') {
				$row = '"'.$auditorName.'",'; 
				$row .= '"'.$user['audit_date'].'",'; 
				$row .= '"'.$user['fname']." ".$user['lname'].'",';
				$row .= '"'.$user['fusion_id'].'",';
				$row .= '"'.$user['tl_name'].'",';
				$row .= '"'.$user['call_date'].'",';
				$row .= '"'.$user['audit_type'].'",';
				$row .= '"'.$user['auditor_type'].'",';
				$row .= '"'.$user['voc'].'",';
				$row .= '"'.$user['audit_start_time'].'",';
				$row .= '"'.$user['entry_date'].'",';
				$row .= '"'.$interval1.'",';
				$row .= '"'.$user['vsi_account'].'",';
				$row .= '"'.$user['qa_type'].'",';
				$row .= '"'.$user['call_id'].'",';
				$row .= '"'.$user['area_of_opportunity'].'",';
				$row .= '"'.$user['overall_score'].'",';
				$row .= '"'.$user['identify_himself'].'",';
				$row .= '"'.$user['provide_the_uality'].'",';
				$row .= '"'.$user['state_varo_bank'].'",';
				$row .= '"'.$user['verify_that_he'].'",';
				$row .= '"'.$user['verify_two_pieces'].'",';
				$row .= '"'.$user['provide_the_mini'].'",';
				$row .= '"'.$user['state_the_client'].'",';
				$row .= '"'.$user['state_ssk_for'].'",';
				$row .= '"'.$user['ask_for_intention'].'",';
				$row .= '"'.$user['ask_for_the_payment'].'",';
				$row .= '"'.$user['help_customer_reset'].'",';
				$row .= '"'.$user['followed_the_previous'].'",';
				$row .= '"'.$user['able_to_take'].'",';
				$row .= '"'.$user['did_collector_try'].'",';
				$row .= '"'.$user['did_not_misrepresent'].'",';
				$row .= '"'.$user['did_discuss_or_imply'].'",';
				$row .= '"'.$user['did_not_make_any'].'",';
				$row .= '"'.$user['did_contact_the_consumer'].'",';
				$row .= '"'.$user['did_not_communicate_consumar'].'",';
				$row .= '"'.$user['did_not_communicate_exists'].'",';
				$row .= '"'.$user['aahereto_the_cell'].'",';
				$row .= '"'.$user['adhere_to_policy'].'",';
				$row .= '"'.$user['enter_status_code'].'",';
				$row .= '"'.$user['did_not_make_any_statement'].'",';
				$row .= '"'.$user['did_not_communicate'].'",';
				$row .= '"'.$user['handle_the_consumer'].'",';
				$row .= '"'.$user['did_ake_the_required'].'",';
				$row .= '"'.$user['adhere_to_fdcpa'].'",';
				$row .= '"'.$user['make_any_statement'].'",';
				$row .= '"'.$user['did_the_collectors'].'",';
				$row .= '"'.$user['aemonstrate_active'].'",';
				$row .= '"'.$user['represent_the_company'].'",';
				$row .= '"'.$user['anticipate_and_overcome'].'",';
				$row .= '"'.$user['transfer_call_varo'].'",';
				$row .= '"'.$user['summarize_the_call'].'",';
				$row .= '"'.$user['provided_varo_bank'].'",';
				$row .= '"'.$user['set_appropriate_timelines'].'",';
				$row .= '"'.$user['close_the_call'].'",';
				$row .= '"'.$user['proper_action_code'].'",';
				$row .= '"'.$user['proper_result_code'].'",';
				$row .= '"'.$user['document_thoroughly'].'",';
				$row .= '"'.$user['confirmation_code'].'",';
				$row .= '"'.$user['remove_any_phone'].'",';
				$row .= '"'.$user['update_address_information'].'",';
				$row .= '"'.$user['change_the_status'].'",';
	

	            $row .= '"'.$user['escalate_the_account'].'",';
                $row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['call_summary'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['feedback'])).'",';
				$row .= '"'.$user['agnt_fd_acpt'].'",';
				$row .= '"'.$user['agent_rvw_date'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['agent_rvw_note'])).'",';
				$row .= '"'.$user['mgnt_rvw_date'].'",';
				$row .= '"'.$user['mgnt_rvw_name'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['mgnt_rvw_note'])).'"';
				
				fwrite($fopen,$row."\r\n");


               } else if($campaign=='varo_lm'){

                $row = '"'.$auditorName.'",'; 
				$row .= '"'.$user['audit_date'].'",'; 
				$row .= '"'.$user['fname']." ".$user['lname'].'",';
				$row .= '"'.$user['fusion_id'].'",';
				$row .= '"'.$user['tl_name'].'",';
				$row .= '"'.$user['call_date'].'",';
				$row .= '"'.$user['audit_type'].'",';
				$row .= '"'.$user['auditor_type'].'",';
				$row .= '"'.$user['voc'].'",';
				$row .= '"'.$user['hire_date'].'",';
				$row .= '"'.$user['audit_start_time'].'",';
				$row .= '"'.$user['entry_date'].'",';
				$row .= '"'.$interval1.'",';
				$row .= '"'.$user['vsi_account'].'",';
				$row .= '"'.$user['overall_score'].'",';

				$row .= '"'.$user['state_the_first'].'",';
				$row .= '"'.$user['misrepresent_their'].'",';
				$row .= '"'.$user['make_any_false'].'",';
				$row .= '"'.$user['make_an_attempt'].'",';
				$row .= '"'.$user['make_an_attempt_work'].'",';
				$row .= '"'.$user['make_an_attempt_after'].'",';
				$row .= '"'.$user['adhere_policy_regarding'].'",';
				$row .= '"'.$user['enter_dialer_disposition'].'",';
				$row .= '"'.$user['use_the_proper_action'].'",';
				$row .= '"'.$user['use_the_proper_result'].'",';
				$row .= '"'.$user['document_the_account'].'",';

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


			}
			fclose($fopen);
		

        }

	
	
 }