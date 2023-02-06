<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Qa_od extends CI_Controller {
    
     	
	 function __construct() {
		parent::__construct();
		
		//$this->load->helper(array('form', 'url'));
		$this->load->model('user_model');
		$this->load->model('Common_model');
		$this->load->model('Qa_od_model');		
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

	 private function od_upload_files($files,$path)
    {
    	$result=$this->createPath($path);
    	if($result){
        $config['upload_path'] = $path;
		$config['allowed_types'] = '*';
		//$config['detect_mime'] = FALSE;
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
	
//////////////// management filtering data /source///////////////////////
	
	public function qaod_management_sorting_feedback()
	{
		if(check_logged_in()){
			$current_user = get_user_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_od/qaod_management_feedback_review.php"; 
			
			$data["get_agent_id_list"] = $this->Qa_od_model->get_agent_id(42);
			
			$from_date = $this->input->get('from_date');
			$to_date = $this->input->get('to_date');
			$agent_id = $this->input->get('agent_id');
			
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
			
			
			
			$field_array = array(
				//"qa" => $qa,
				"from_date"=>$from_date,
				"to_date" => $to_date,
				"agent_id" => $agent_id,
				"current_user" => $current_user
			);	
			
			$data["get_management_review_list"] = $this->Qa_od_model->get_management_review_data($field_array);
			$data["od_voice_list"] = $this->Qa_od_model->get_voice_review_data($field_array);
			$data["od_ecommerce_list"] = $this->Qa_od_model->get_ecommerce_review_data($field_array);
			$data["od_chat_list"] = $this->Qa_od_model->get_chat_review_data($field_array);
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			$data["agent_id"] = $agent_id;
			
			$this->load->view('dashboard',$data);
		}
	}
	
	//////////////// NPS ACPT filtering data /source///////////////////////
	
	public function qaod_nps_feedback()
	{
		if(check_logged_in()){
			$current_user = get_user_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_od/qaod_nps_feedback.php"; 
			
			$data["get_agent_id_list"] = $this->Qa_od_model->get_agent_id(42);
			
			$from_date = $this->input->get('from_date');
			$to_date = $this->input->get('to_date');
			$agent_id = $this->input->get('agent_id');
			
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
			
			
			
			$field_array = array(
				//"qa" => $qa,
				"from_date"=>$from_date,
				"to_date" => $to_date,
				"agent_id" => $agent_id,
				"current_user" => $current_user
			);	
			

			$data["od_nps_list"] = $this->Qa_od_model->get_nps_review_data($field_array);
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			$data["agent_id"] = $agent_id;
			
			$this->load->view('dashboard',$data);
		}
	}

	public function add_edit_od_voice($od_voice_id){
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_od/add_edit_od_voice.php";
			$data["content_js"] = "qa_universal_js.php";
			$data['od_voice_id']=$od_voice_id;
			$tl_mgnt_cond='';
			if(get_role_dir()=='manager' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";
			}else if(get_role_dir()=='tl' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and assigned_to='$current_user'";
			}else{
				$tl_mgnt_cond="";
			}
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client(id,42) and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
			

			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
				from qa_od_voice_feedback where id='$od_voice_id') xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
			$data["od_voice"] = $this->Common_model->get_query_row_array($qSql);
			// echo '<pre>';
			// print_r($data);
			// die();

			$curDateTime=CurrMySqlDate();
			$a = array();

			//$voice_chkbox= $this->input->get('check_list1');
			//echo $voice_chkbox;

			$field_array['agent_id']=!empty($_POST['data']['agent_id'])?$_POST['data']['agent_id']:"";
			
			if($field_array['agent_id']){
				
				if($od_voice_id==0){
					
					$field_array=$this->input->post('data');
					$field_array['audit_date']=CurrDate();
					$field_array['call_date']=mmddyy2mysql($this->input->post('call_date'));
					$field_array['review_date']=mmddyy2mysql($this->input->post('review_date'));
					$field_array['entry_date']=$curDateTime;
					$field_array['audit_start_time']=$this->input->post('audit_start_time');
					$a = $this->od_upload_files($_FILES['attach_file'], $path='./qa_files/qa_od/');
                       $field_array["attach_file"] = implode(',',$a);
					
					
					$voice_chkbox= $this->input->post('check_list1');
					if(!empty('voice_chkbox')){
						$field_array['check_list1']=implode(',',$voice_chkbox);
					}
					
					$voice_chkbox1= $this->input->post('check_list2');
					if(!empty('voice_chkbox1')){
						$field_array['check_list2']=implode(',',$voice_chkbox1);
					}
					$voice_chkbox2= $this->input->post('check_list3');
					if(!empty('voice_chkbox2')){
						$field_array['check_list3']=implode(',',$voice_chkbox2);
					}
					$voice_chkbox3= $this->input->post('check_list4');
					if(!empty('voice_chkbox3')){
						$field_array['check_list4']=implode(',',$voice_chkbox3);	
					}
					$voice_chkbox4= $this->input->post('check_list5');
					if(!empty('voice_chkbox4')){
						$field_array['check_list5']=implode(',',$voice_chkbox4);	
					}	
					$rowid= data_inserter('qa_od_voice_feedback',$field_array);

					// foreach ($voice_chkbox as $key => $value) {

					// 	$rowid= data_inserter('qa_od_voice_feedback',$value);

					// }
				///////////
					if(get_login_type()=="client"){
						$add_array = array("client_entryby" => $current_user);
					}else{
						$add_array = array("entry_by" => $current_user);
					}
					$this->db->where('id', $rowid);
					$this->db->update('qa_od_voice_feedback',$add_array);
					
				}else{
					
					$field_array1=$this->input->post('data');
					$field_array1['call_date']=mmddyy2mysql($this->input->post('call_date'));
					$field_array['review_date']=mmddyy2mysql($this->input->post('review_date'));
					if($_FILES['attach_file']['tmp_name'][0]!=''){
						$a = $this->amd_upload_files($_FILES['attach_file'], $path='./qa_files/qa_od/');
                       $field_array1["attach_file"] = implode(',',$a);
					}
					
					$voice_chkbox= $this->input->post('check_list1');
					if(!empty('voice_chkbox')){
						$field_array1['check_list1']=implode(',',$voice_chkbox);
					}
					
					$voice_chkbox1= $this->input->post('check_list2');
					if(!empty('voice_chkbox1')){
						$field_array1['check_list2']=implode(',',$voice_chkbox1);
					}
					$voice_chkbox2= $this->input->post('check_list3');
					if(!empty('voice_chkbox2')){
						$field_array1['check_list3']=implode(',',$voice_chkbox2);
					}
					$voice_chkbox3= $this->input->post('check_list4');
					if(!empty('voice_chkbox3')){
						$field_array1['check_list4']=implode(',',$voice_chkbox3);	
					}
					$voice_chkbox4= $this->input->post('check_list5');
					if(!empty('voice_chkbox4')){
						$field_array1['check_list5']=implode(',',$voice_chkbox4);	
					}
					
					$this->db->where('id', $od_voice_id);
					$this->db->update('qa_od_voice_feedback',$field_array1);

					
					// foreach ($voice_chkbox as $key => $value) {
					// 	$dataVoiceCheckArr = array('voice_feedback_id' => $rowid,
					// 	                          'voice_checkbox' => $value);
						
					// 	$rowid= data_inserter('od_voice_checkbox',$dataVoiceCheckArr);
					//  $rowid= data_delete('od_voice_checkbox',$dataVoiceCheckArr);

					// }
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
					$this->db->where('id', $od_voice_id);
					$this->db->update('qa_od_voice_feedback',$edit_array);
					
				}
				redirect('Qa_od/qaod_management_sorting_feedback');
			}
			$data["array"] = $a;
			$this->load->view("dashboard",$data);
		}
	}

	public function add_edit_od_ecommerce($od_ecommerce_id){
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_od/add_edit_od_ecommerce.php";
			$data["content_js"] = "qa_universal_js.php";
			$data['od_ecommerce_id']=$od_ecommerce_id;
			$tl_mgnt_cond='';
			if(get_role_dir()=='manager' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";
			}else if(get_role_dir()=='tl' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and assigned_to='$current_user'";
			}else{
				$tl_mgnt_cond="";
			}
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client(id,42) and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
				from qa_od_ecommerce_feedback where id='$od_ecommerce_id') xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
			$data["od_ecommerce"] = $this->Common_model->get_query_row_array($qSql);
			

			$curDateTime=CurrMySqlDate();
			$a = array();
			
			
			$field_array['agent_id']=!empty($_POST['data']['agent_id'])?$_POST['data']['agent_id']:"";
			
			if($field_array['agent_id']){
				
				if($od_ecommerce_id==0){
					
					$field_array=$this->input->post('data');
					$field_array['audit_date']=CurrDate();
					$field_array['call_date']=mmddyy2mysql($this->input->post('call_date'));
					$field_array['review_date']=mmddyy2mysql($this->input->post('review_date'));
					$field_array['entry_date']=$curDateTime;
					$field_array['audit_start_time']=$this->input->post('audit_start_time');
					$a = $this->od_upload_files($_FILES['attach_file'], $path='./qa_files/qa_od/');
                       $field_array["attach_file"] = implode(',',$a);
					$rowid= data_inserter('qa_od_ecommerce_feedback',$field_array);
				///////////
					if(get_login_type()=="client"){
						$add_array = array("client_entryby" => $current_user);
					}else{
						$add_array = array("entry_by" => $current_user);
					}
					$this->db->where('id', $rowid);
					$this->db->update('qa_od_ecommerce_feedback',$add_array);
					
				}else{
					
					$field_array1=$this->input->post('data');
					$field_array1['call_date']=mmddyy2mysql($this->input->post('call_date'));
					$field_array['review_date']=mmddyy2mysql($this->input->post('review_date'));
					if($_FILES['attach_file']['tmp_name'][0]!=''){
						$a = $this->amd_upload_files($_FILES['attach_file'], $path='./qa_files/qa_od/');
                       $field_array1["attach_file"] = implode(',',$a);
					}
					$this->db->where('id', $od_ecommerce_id);
					$this->db->update('qa_od_ecommerce_feedback',$field_array1);
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
					$this->db->where('id', $od_ecommerce_id);
					$this->db->update('qa_od_ecommerce_feedback',$edit_array);
					
				}
				redirect('Qa_od/qaod_management_sorting_feedback');
			}
			$data["array"] = $a;
			$this->load->view("dashboard",$data);
		}
	}

	public function add_edit_od_chat($od_chat_id){

		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_od/add_edit_od_chat.php";
			$data["content_js"] = "qa_universal_js.php";
			$data['od_chat_id']=$od_chat_id;
			$tl_mgnt_cond='';
			if(get_role_dir()=='manager' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";
			}else if(get_role_dir()=='tl' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and assigned_to='$current_user'";
			}else{
				$tl_mgnt_cond="";
			}
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client(id,42) and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
				from qa_od_chat_feedback where id='$od_chat_id') xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
			$data["od_voice"] = $this->Common_model->get_query_row_array($qSql);
			

			$curDateTime=CurrMySqlDate();
			$a = array();
			
			
			$field_array['agent_id']=!empty($_POST['data']['agent_id'])?$_POST['data']['agent_id']:"";
			
			if($field_array['agent_id']){
				
				if($od_chat_id==0){
					
					$field_array=$this->input->post('data');
					$field_array['audit_date']=CurrDate();
					$field_array['call_date']=mmddyy2mysql($this->input->post('call_date'));
					$field_array['review_date']=mmddyy2mysql($this->input->post('review_date'));
					$field_array['entry_date']=$curDateTime;
					$field_array['audit_start_time']=$this->input->post('audit_start_time');
					$a = $this->od_upload_files($_FILES['attach_file'], $path='./qa_files/qa_od/');
                       $field_array["attach_file"] = implode(',',$a);
					$rowid= data_inserter('qa_od_chat_feedback',$field_array);
				///////////
					if(get_login_type()=="client"){
						$add_array = array("client_entryby" => $current_user);
					}else{
						$add_array = array("entry_by" => $current_user);
					}
					$this->db->where('id', $rowid);
					$this->db->update('qa_od_chat_feedback',$add_array);
					
				}else{
					
					$field_array1=$this->input->post('data');
					$field_array1['call_date']=mmddyy2mysql($this->input->post('call_date'));
					$field_array1['review_date']=mmddyy2mysql($this->input->post('review_date'));
					if($_FILES['attach_file']['tmp_name'][0]!=''){
						$a = $this->amd_upload_files($_FILES['attach_file'], $path='./qa_files/qa_od/');
                       $field_array1["attach_file"] = implode(',',$a);
					}
					$this->db->where('id', $od_chat_id);
					$this->db->update('qa_od_chat_feedback',$field_array1);
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
					$this->db->where('id', $od_chat_id);
					$this->db->update('qa_od_chat_feedback',$edit_array);
					
				}
				redirect('Qa_od/qaod_management_sorting_feedback');
			}
			$data["array"] = $a;
			$this->load->view("dashboard",$data);
		}
	}

///* review page of the feedback management portal *///

	public function qaod_management_status_form($id)
	{
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_od/qaod_management_status_form.php"; 
			
			
			$data["get_agent_id_list"] = $this->Qa_od_model->get_agent_id(42);
			$data["get_tl_id_list"] = $this->Qa_od_model->get_tl_id();
			
			$qSql="Select fusion_id, concat(fname, ' ', lname) as name from signin where (role_id in (select id from role where folder not in ('agent', 'support', 'super')) or dept_id in (5,11) )  and status=1 order by fusion_id";
			$data["get_coach_name"] = $this->Common_model->get_query_result_array($qSql);
			
			
			$data["get_view_feedback_entry"] = $this->Qa_od_model->view_feedback_entry_data($id);
			
			$data["fid"]=$id;
			
			$data["row1"] = $this->Qa_od_model->view_agent_review_data($id);//AGENT PURPOSE
			
			$data["row2"] = $this->Qa_od_model->view_management_review_data($id);//MGNT PURPOSE
			
			
			if($this->input->post('fd_id'))
			{
				$fd_id=$this->input->post('fd_id');
				$curDateTime=CurrMySqlDate();
				
				$field_array1 = array(
					"agent_id" => $this->input->post('agent_id'),
					"chat_date" => mmddyy2mysql($this->input->post('chat_date')),
					"customer_id" => $this->input->post('customer_id'),
					"ani" => $this->input->post('ani'),
					"call_pass_fail" => $this->input->post('call_pass_fail'),
					"overall_score" => $this->input->post('overall_score'),
					"audit_type" => $this->input->post('audit_type'),
					"auditor_type" => $this->input->post('auditor_type'),
					"voc" => $this->input->post('voc'),
					"ack_chat_cust" => $this->input->post('ack_chat_cust'),
					"made_cust_feel_imp" => $this->input->post('made_cust_feel_imp'),
					"appro_sin_empathy" => $this->input->post('appro_sin_empathy'),
					"cust_clr_understood_crs" => $this->input->post('cust_clr_understood_crs'),
					"ccp_ask_sale" => $this->input->post('ccp_ask_sale'),
					"read_ack_understood_cust" => $this->input->post('read_ack_understood_cust'),
					"used_proper_guidelines" => $this->input->post('used_proper_guidelines'),
					"noted_appropriately" => $this->input->post('noted_appropriately'),
					"agent_maintained_control_chat" => $this->input->post('agent_maintained_control_chat'),
					"verified_info_appropriate_chat" => $this->input->post('verified_info_appropriate_chat'),
					"was_the_offer" => $this->input->post('was_the_offer'),
					"was_the_proper_dispo" => $this->input->post('was_the_proper_dispo'),
					"possible_score" => $this->input->post('possible_score'),
					"score" => $this->input->post('score'),					
					"call_summary" => $this->input->post('call_summary'),					
					"feedback" => $this->input->post('feedback')
				);
				$this->db->where('id', $fd_id);
				$this->db->update('qa_od_feedback',$field_array1);
			////////////	
				$field_array=array(
					"fd_id" => $fd_id,
					"mgnt_review_date" => CurrDate(),
					"coach_name" => $this->input->post('coach_name'),
					"note" => $this->input->post('note'),
					"entry_by" => $current_user,
					"entry_date" => $curDateTime
				);
				
				if($this->input->post('action')==''){
					$rowid = data_inserter('qa_od_mgnt_review', $field_array);
				}else{
					$this->db->where('fd_id', $fd_id);
					$this->db->update('qa_od_mgnt_review',$field_array);
				}
				
				redirect('qa_od/qaod_management_sorting_feedback');
				
			}else{
				$this->load->view('dashboard',$data);
			}
			
		}	
	}
	
	
///* add management page of the OD feedback management portal *///		
	
	public function qaod_management_feedback_entry()
	{
		if(check_logged_in()){
			
			$user_office_id=get_user_office_id();
			
			$data["get_agent_id_list"] = $this->Qa_od_model->get_agent_id(42);
			$data["get_tl_id_list"] = $this->Qa_od_model->get_tl_id();
			
			$data["aside_template"] = "qa/aside.php";
            $data["content_template"] = "qa_od/qaod_management_feedback_entry.php"; 
			
			
			$current_user=get_user_id();
			$curDateTime=date("Y-m-d h:i:sa");
			$log=get_logs();
			if($this->input->post('chat_date')!=''){
				$chat_date = mmddyy2mysql($this->input->post('chat_date'));
			}else{
				$chat_date = CurrDate();
			}
			
			
			if($this->input->post('agent_id'))
			{
				
				$config['upload_path'] = './qa_files/qa_od/';
				$config['allowed_types'] = 'mp3|avi|mp4|wmv';
				$config['max_size']     = '2024000';
				$this->load->library('upload', $config);
				$this->upload->initialize($config);
				
				$field_array=array(
					"chat_date" => $chat_date,
					"agent_id" => $this->input->post('agent_id'),
					"audit_date" => CurrDate(),
					"customer_id" => $this->input->post('customer_id'),
					"ani" => $this->input->post('ani'),
					"call_pass_fail" => $this->input->post('call_pass_fail'),
					"overall_score" => $this->input->post('overall_score'),
					"audit_type" => $this->input->post('audit_type'),
					"auditor_type" => $this->input->post('auditor_type'),
					"voc" => $this->input->post('voc'),
					"ack_chat_cust" => $this->input->post('ack_chat_cust'),
					"made_cust_feel_imp" => $this->input->post('made_cust_feel_imp'),
					"appro_sin_empathy" => $this->input->post('appro_sin_empathy'),
					"cust_clr_understood_crs" => $this->input->post('cust_clr_understood_crs'),
					"ccp_ask_sale" => $this->input->post('ccp_ask_sale'),
					"read_ack_understood_cust" => $this->input->post('read_ack_understood_cust'),
					"used_proper_guidelines" => $this->input->post('used_proper_guidelines'),
					"noted_appropriately" => $this->input->post('noted_appropriately'),
					"agent_maintained_control_chat" => $this->input->post('agent_maintained_control_chat'),
					"verified_info_appropriate_chat" => $this->input->post('verified_info_appropriate_chat'),
					"was_the_offer" => $this->input->post('was_the_offer'),
					"was_the_proper_dispo" => $this->input->post('was_the_proper_dispo'),
					"possible_score" => $this->input->post('possible_score'),
					"score" => $this->input->post('score'),					
					"call_summary" => $this->input->post('call_summary'),					
					"feedback" => $this->input->post('feedback'),
					"entry_by" => $current_user,
					"entry_date" => $curDateTime,
					"audit_start_time" => $this->input->post('audit_start_time')
				);
				
				if (!$this->upload->do_upload('attach_file')){
					$error = $this->upload->display_errors();
					$data['message'] = $error;
					//$field_array["attach_file"] = $error;
					//echo $error;
				}else{
					$resume_file = $this->upload->data();
					//print_r($resume_file);
					$field_array["attach_file"] = $resume_file['file_name'];
				}
				
				$data["insert_feedback_entry"] = $this->Qa_od_model->data_insert_feedback_entry($field_array); 
				redirect('qa_od/qaod_management_sorting_feedback');
			}

			$this->load->view('dashboard',$data); 
			
		}
	}
	
	
	public function getTLname()
	{
		if(check_logged_in())
		{
			$aid=$this->input->post('aid');
			
			$qSql = "SELECT fusion_id, xpoid, batch_code, assigned_to, (select concat(fname, ' ', lname) as name from signin sx where sx.id=signin.assigned_to) as tl_name, DATEDIFF(CURDATE(), doj) as tenure from signin where id='$aid' and status='1'";
			echo json_encode($this->Common_model->get_query_result_array($qSql));
		}
	}
/////////////////////////////////////////////////////////////

/////////////////////////NPS ACPT////////////////////////////
public function add_edit_od_npsACPT($od_nps_id){
	if(check_logged_in())
	{
		$current_user=get_user_id();
		$user_office_id=get_user_office_id();
		$data["aside_template"] = "qa/aside.php";
		$data["content_template"] = "qa_od/add_edit_od_npsACPT.php";
		$data["content_js"] = "qa_universal_js.php";
		$data['od_nps_id']=$od_nps_id;
		$tl_mgnt_cond='';
		if(get_role_dir()=='manager' && get_dept_folder()=='operations'){
			$tl_mgnt_cond=" and (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";
		}else if(get_role_dir()=='tl' && get_dept_folder()=='operations'){
			$tl_mgnt_cond=" and assigned_to='$current_user'";
		}else{
			$tl_mgnt_cond="";
		}
		
		$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client(id,42) and status=1  order by name";
		$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
		
		$qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
		$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
		
		

		$qSql = "SELECT * from
			(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
			(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
			(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
			(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
			from qa_od_npsACPT_feedback where id='$od_nps_id') xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
		$data["od_nps"] = $this->Common_model->get_query_row_array($qSql);
		// echo '<pre>';
		// print_r($data);
		// die();

		$curDateTime=CurrMySqlDate();
		$a = array();

		
		$field_array['agent_id']=!empty($_POST['data']['agent_id'])?$_POST['data']['agent_id']:"";
		
		if($field_array['agent_id']){
			
			if($od_nps_id==0){
				
				$field_array=$this->input->post('data');
				$field_array['audit_date']=CurrDate();
				$field_array['call_date']=mmddyy2mysql($this->input->post('call_date'));
				$field_array['review_date']=mmddyy2mysql($this->input->post('review_date'));
				$field_array['entry_date']=$curDateTime;
				$field_array['audit_start_time']=$this->input->post('audit_start_time');
				$a = $this->od_upload_files($_FILES['attach_file'], $path='./qa_files/qa_od/');
				   $field_array["attach_file"] = implode(',',$a);
				
				$rowid= data_inserter('qa_od_npsACPT_feedback',$field_array);

			///////////
				if(get_login_type()=="client"){
					$add_array = array("client_entryby" => $current_user);
				}else{
					$add_array = array("entry_by" => $current_user);
				}
				$this->db->where('id', $rowid);
				$this->db->update('qa_od_npsACPT_feedback',$add_array);
				
			}else{
				
				$field_array1=$this->input->post('data');
				$field_array1['call_date']=mmddyy2mysql($this->input->post('call_date'));
				$field_array['review_date']=mmddyy2mysql($this->input->post('review_date'));
				if($_FILES['attach_file']['tmp_name'][0]!=''){
					$a = $this->amd_upload_files($_FILES['attach_file'], $path='./qa_files/qa_od/');
				   $field_array1["attach_file"] = implode(',',$a);
				}
				
				
				$this->db->where('id', $od_nps_id);
				$this->db->update('qa_od_npsACPT_feedback',$field_array1);

					
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
				$this->db->where('id', $od_nps_id);
				$this->db->update('qa_od_npsACPT_feedback',$edit_array);
				
			}
			redirect('Qa_od/qaod_nps_feedback');
		}
		$data["array"] = $a;
		$this->load->view("dashboard",$data);
	}
}
//////////////////Agent QA OD Feedback///////////////////////

	public function qaod_agent_sorting_feedback()
	{
		if(check_logged_in())
		{
			$user_site_id= get_user_site_id();
			$role_id= get_role_id();
			$current_user = get_user_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_od/qaod_agent_feedback_review.php"; 
			$data["agentUrl"] = "qa_od/qaod_agent_sorting_feedback"; 
			$url="qa_od/qaod_agent_sorting_feedback";
			$this->session->set_userdata('reroute',$url);
			$campaign = $this->input->get('process');
			$data["total_feedback"]=0;
			$data["total_review_needed"]=0;
			
			if($campaign=='old_chat'){
				$qSql="Select count(id) as value from qa_od_feedback where agent_id = '$current_user' And audit_type in ('CQ Audit', 'BQ Audit','Operation Audit','Trainer Audit')";
				$data["total_feedback"] =  $this->Common_model->get_single_value($qSql);
				$qSql="Select count(id) as value from qa_od_feedback where id not in (select fd_id from qa_od_agent_review) and agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit','Operation Audit','Trainer Audit')";
				$data["total_review_needed"] =  $this->Common_model->get_single_value($qSql);
			}else if($campaign=='od_voice'){
				$qSql="Select count(id) as value from qa_od_voice_feedback where agent_id = '$current_user' And audit_type in ('CQ Audit', 'BQ Audit','Operation Audit','Trainer Audit')";
				$data["total_feedback"] =  $this->Common_model->get_single_value($qSql);
				$qSql="Select count(id) as value from qa_od_voice_feedback where id not in (select fd_id from qa_od_agent_review) and agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit','Operation Audit','Trainer Audit')";
				$data["total_review_needed"] =  $this->Common_model->get_single_value($qSql);
			}else if($campaign=='od_ecommerce'){
					$qSql="Select count(id) as value from qa_od_ecommerce_feedback where agent_id = '$current_user' And audit_type in ('CQ Audit', 'BQ Audit','Operation Audit','Trainer Audit')";
					$data["total_feedback"] =  $this->Common_model->get_single_value($qSql);
					$qSql="Select count(id) as value from qa_od_ecommerce_feedback where id not in (select fd_id from qa_od_agent_review) and agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit','Operation Audit','Trainer Audit')";
					$data["total_review_needed"] =  $this->Common_model->get_single_value($qSql);
            }else if($campaign=='chat'){
				$qSql="Select count(id) as value from qa_od_chat_feedback where agent_id = '$current_user' And audit_type in ('CQ Audit', 'BQ Audit','Operation Audit','Trainer Audit')";
				$data["total_feedback"] =  $this->Common_model->get_single_value($qSql);
				$qSql="Select count(id) as value from qa_od_chat_feedback where id not in (select fd_id from qa_od_agent_review) and agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit','Operation Audit','Trainer Audit')";
				$data["total_review_needed"] =  $this->Common_model->get_single_value($qSql);
			}else if($campaign=='od_nps'){
				$qSql="Select count(id) as value from qa_od_npsACPT_feedback where agent_id = '$current_user' And audit_type in ('CQ Audit', 'BQ Audit','Operation Audit','Trainer Audit')";
				$data["total_feedback"] =  $this->Common_model->get_single_value($qSql);
				$qSql="Select count(id) as value from qa_od_npsACPT_feedback where id not in (select fd_id from qa_od_agent_review) and agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit','Operation Audit','Trainer Audit')";
				$data["total_review_needed"] =  $this->Common_model->get_single_value($qSql);
			}else if($campaign=='od_nps_coaching'){
				$qSql="Select count(id) as value from qa_agent_coaching_office_depot_feedback where agent_id = '$current_user' And audit_type in ('CQ Audit', 'BQ Audit','Operation Audit','Trainer Audit')";
				$data["total_feedback"] =  $this->Common_model->get_single_value($qSql);
				$qSql="Select count(id) as value from qa_agent_coaching_office_depot_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit','Operation Audit','Trainer Audit') and agent_rvw_date is Null";

				// "Select count(id) as value from qa_agent_coaching_office_depot_feedback where id not in (select fd_id from qa_od_agent_review) and agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit','Operation Audit','Trainer Audit')";
				$data["total_review_needed"] =  $this->Common_model->get_single_value($qSql);
			}
			$from_date = $this->input->get('from_date');
			$to_date = $this->input->get('to_date');

			if($from_date==""){ 
				$from_date='';
			}else{
				$from_date = mmddyy2mysql($from_date);
			}
			
			if($to_date==""){ 
				$to_date='';
			}else{
				$to_date = mmddyy2mysql($to_date);
			}
				
		if($this->input->get('btnView')=='View')
		{
			$field_array = array(
				"from_date"=>$from_date,
				"to_date" => $to_date,
				"current_user" => $current_user
			);
			
			if($campaign=='od_voice'){
				$data["get_agent_review_list"] = $this->Qa_od_model->get_agent_voice_data($field_array);
			}else if($campaign=='od_nps'){
				$data["get_agent_review_list"] = $this->Qa_od_model->get_agent_nps_data($field_array);
			}else if($campaign=='od_nps_coaching'){
				$data["get_agent_review_list"] = $this->Qa_od_model->get_agent_od_nps_coaching_data($field_array);
			}else if($campaign=='od_ecommerce'){
				$data["get_agent_review_list"] = $this->Qa_od_model->get_agent_ecommerce_data($field_array);
			}else if($campaign=='chat'){
				$data["get_agent_review_list"] = $this->Qa_od_model->get_agent_chat_data($field_array);
			}else if($campaign=='old_chat'){
				$data["get_agent_review_list"] = $this->Qa_od_model->get_agent_review_data($field_array);
			}	
				
		}else{
			$data["get_agent_review_list"] = $this->Qa_od_model->get_agent_not_review_data($current_user);		
		}
		
			
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			$data["lob"] = $campaign;
			
			$this->load->view('dashboard',$data);
		}
	}

	public function qaod_agent_voice_rvw($id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_od/qaod_agent_voice_rvw.php";
			$data["content_js"] = "qa_universal_js.php";
			$data["agentUrl"] = "qa_od/qaod_agent_sorting_feedback";
			
			$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_od_voice_feedback where id='$id') xx Left Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
			$data["od_voice"] = $this->Common_model->get_query_row_array($qSql);
			
			$data["od_voice_id"]=$id;
			
			if($this->input->post('od_voice_id'))
			{
				$pnid=$this->input->post('od_voice_id');
				$curDateTime=CurrMySqlDate();
				$log=get_logs();
					
				$field_array=array(
					"agnt_fd_acpt" => $this->input->post('agnt_fd_acpt'),
					"agent_rvw_note" => $this->input->post('note'),
					"agent_rvw_date" => $curDateTime
				);
				$this->db->where('id', $pnid);
				$this->db->update('qa_od_voice_feedback',$field_array);
					
				redirect('qa_od/qaod_agent_sorting_feedback');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}

	public function qaod_agent_ecommerce_rvw($id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_od/qaod_agent_ecommerce_rvw.php";
			$data["content_js"] = "qa_universal_js.php";
			$data["agentUrl"] = "qa_od/qaod_agent_sorting_feedback";
			
			$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_od_ecommerce_feedback where id='$id') xx Left Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
			$data["od_ecommerce"] = $this->Common_model->get_query_row_array($qSql);
			
			$data["od_ecommerce_id"]=$id;
			
			if($this->input->post('od_ecommerce_id'))
			{
				$pnid=$this->input->post('od_ecommerce_id');
				$curDateTime=CurrMySqlDate();
				$log=get_logs();
					
				$field_array=array(
					"agnt_fd_acpt" => $this->input->post('agnt_fd_acpt'),
					"agent_rvw_note" => $this->input->post('note'),
					"agent_rvw_date" => $curDateTime
				);
				$this->db->where('id', $pnid);
				$this->db->update('qa_od_ecommerce_feedback',$field_array);
					
				redirect('qa_od/qaod_agent_sorting_feedback');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}

	public function qaod_agent_chat_rvw($id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_od/qaod_agent_chat_rvw.php";
			$data["content_js"] = "qa_universal_js.php";
			$data["agentUrl"] = "qa_od/qaod_agent_sorting_feedback";
			
			$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_od_chat_feedback where id='$id') xx Left Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
			$data["od_chat"] = $this->Common_model->get_query_row_array($qSql);
			
			$data["od_chat_id"]=$id;
			
			if($this->input->post('od_chat_id'))
			{
				$pnid=$this->input->post('od_chat_id');
				$curDateTime=CurrMySqlDate();
				$log=get_logs();
					
				$field_array=array(
					"agnt_fd_acpt" => $this->input->post('agnt_fd_acpt'),
					"agent_rvw_note" => $this->input->post('note'),
					"agent_rvw_date" => $curDateTime
				);
				$this->db->where('id', $pnid);
				$this->db->update('qa_od_chat_feedback',$field_array);
					
				redirect('qa_od/qaod_agent_sorting_feedback');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}
	
	public function qaod_agent_nps_rvw($id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_od/qaod_agent_nps_rvw.php";
			$data["content_js"] = "qa_universal_js.php";
			$data["agentUrl"] = "qa_od/qaod_agent_sorting_feedback";
			
			$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_od_npsACPT_feedback where id='$id') xx Left Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
			$data["od_nps"] = $this->Common_model->get_query_row_array($qSql);
			
			$data["od_nps_id"]=$id;
			
			if($this->input->post('od_nps_id'))
			{
				$pnid=$this->input->post('od_nps_id');
				$curDateTime=CurrMySqlDate();
				$log=get_logs();
					
				$field_array=array(
					"agnt_fd_acpt" => $this->input->post('agnt_fd_acpt'),
					"agent_rvw_note" => $this->input->post('note'),
					"agent_rvw_date" => $curDateTime
				);
				$this->db->where('id', $pnid);
				$this->db->update('qa_od_npsACPT_feedback',$field_array);
					
				redirect('qa_od/qaod_agent_sorting_feedback');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}
	
///* review page of the feedback agent portal *///

	public function qaod_agent_status_form($id)
	{
		if(check_logged_in())
		{
			$user_site_id= get_user_site_id();
			$role_id= get_role_id();
			$current_user = get_user_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_od/qaod_agent_status_form.php";
			$data["agentUrl"] = "qa_od/qaod_agent_sorting_feedback";
			
			$data["view_agent_feedback_entry"] = $this->Qa_od_model->view_feedback_entry_data($id);//all agent data
			
			$data["fid"]=$id;
			
			$data["row1"] = $this->Qa_od_model->view_agent_review_data($id);//AGENT PURPOSE
			
			$data["row2"] = $this->Qa_od_model->view_management_review_data($id);//MGNT PURPOSE
			
			
			if($this->input->post('fd_id'))
			{
				$fd_id=$this->input->post('fd_id');
				$curDateTime=CurrMySqlDate();
				
				$field_array=array(
					"fd_id" => $fd_id,
					"review_date" => CurrDate(),
					"agent_fd_acpt" => $this->input->post('agent_fd_acpt'),
					"note" => $this->input->post('note'),
					"entry_by" => $current_user,
					"entry_date" => $curDateTime
				);
				
				if($this->input->post('action')==''){
					$rowid = data_inserter('qa_od_agent_review', $field_array);
				}else{
					$this->db->where('fd_id', $fd_id);
					$this->db->update('qa_od_agent_review',$field_array );
				}
				
				redirect('qa_od/qaod_agent_sorting_feedback');
				
			}else{
				$this->load->view('dashboard',$data);
			}
			
		}	
	}

	public function qaod_agent_nps_coaching_rvw($id){
		if(check_logged_in()){
			//$data["content_template"] = "qa_od/qaod_agent_nps_rvw.php";
			
			$current_user = get_user_id(); 
            $user_office = get_user_office_id(); 
            $data["aside_template"] = "qa/aside.php";
            $data["content_template"] = "qa_agent_coaching/qaod_agent_nps_coaching_rvw.php";
            //$data["content_template"] = "qa_agent_coaching/add_agent_raw_feedback.php";
            $data["content_js"] = "qa_raw_upload_js.php";
            $data["agentUrl"] = "qa_od/qaod_agent_sorting_feedback";
            $data['od_nps_coaching_id']=$id;

            if($id!=""){
                $cond= " Where (id = '$id') ";
               $qSql = "SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,(select  name from process pr where pr.id=process_id) as process_name, (select fullname as name from client sc where sc.id=42) as client_name, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name  from qa_agent_coaching_office_depot_feedback $cond ) xx Left Join (Select id as sid,concat(fname, ' ', lname) as agent_name, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid) order by audit_date";
                $data["od_nps_coaching"] = $this->Common_model->get_query_row_array($qSql);
            }else{
                $data["od_nps_coaching"] = array();
            }  
            //(select s.id as tl_idd from signin s where s.id=tl_id) as tl_id
            

            $sql_process = "Select id,name from process where client_id =42 and is_active=1";
            $data["process_details"] = $this->Common_model->get_query_result_array($sql_process);
			
			if($this->input->post('od_nps_coaching_id'))
			{
				$pnid=$this->input->post('od_nps_coaching_id');
				$curDateTime=CurrMySqlDate();
				$log=get_logs();
					
				$field_array=array(
					"agnt_fd_acpt" => $this->input->post('agnt_fd_acpt'),
					"agent_rvw_note" => $this->input->post('note'),
					"agent_rvw_date" => $curDateTime
				);
				$this->db->where('id', $pnid);
				$this->db->update('qa_agent_coaching_office_depot_feedback',$field_array);
					
				redirect('qa_od/qaod_agent_sorting_feedback');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}

	////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////// Office Depot Report////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////
public function qaod_report(){
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
		$data["content_template"] = "qa_od/qaod_report.php";
		$data["content_js"] = "qa_od_js.php";

		$data["get_agent_id_list"] = $this->Qa_od_model->get_agent_id(42);
		$data['location_list'] = $this->Common_model->get_office_location_list();
		$campaign="";
		$office_id = "";
		$agent_id="";
		$audit_type="";
		$action="";
		$dn_link="";
		$cond="";
		$cond1="";

		$date_from=$this->input->get('date_from');
		$date_to=$this->input->get('date_to');
		$campaign = $this->input->get('process');
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

		$data["qa_od_list"] = array();

		if($this->input->get('show')=='Show')
		{
			$date_from = $date_from;
			$date_to = $date_to;
			$office_id = $this->input->get('office_id');
			$agent_id = $this->input->get('agent_id');
			$audit_type = $this->input->get('audit_type');


			if($date_from !="" && $date_to!=="" )  $cond= " Where (audit_date >= '$date_from' and audit_date <= '$date_to' ) ";
			if($agent_id!="") $cond .=" and agent_id='$agent_id'";
			if($audit_type!="")	$cond .=" and audit_type='$audit_type'";

			if($office_id=="All") $cond .= "";
			else $cond .=" and office_id='$office_id'";

			if(get_role_dir()=='manager' && get_dept_folder()=='operations'){
				$cond1 .=" And (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";
			}else if(get_role_dir()=='tl' && get_dept_folder()=='operations'){
				$cond1 .=" And assigned_to='$current_user'";
			}else{
				$cond1 .="";
			}

			if($campaign=='od_voice'){
			 $qSql="SELECT * from
			(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
			(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
			(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
			(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name,
			(select concat(fname, ' ', lname) as name from signin_client scx where scx.id=client_rvw_by) as client_rvw_name from qa_od_voice_feedback) xx Left Join
			(Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_ids(id) as process_id, get_process_names(id) as process, doj, DATEDIFF(CURDATE(), doj) as tenure from signin) yy on (xx.agent_id=yy.sid) $cond $cond1 order by audit_date";
			} else if($campaign=='od_ecommerce'){
				$qSql="SELECT * from
			   (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
			   (select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
			   (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
			   (select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name,
			   (select concat(fname, ' ', lname) as name from signin_client scx where scx.id=client_rvw_by) as client_rvw_name from qa_od_ecommerce_feedback) xx Left Join
			   (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_ids(id) as process_id, get_process_names(id) as process, doj, DATEDIFF(CURDATE(), doj) as tenure from signin) yy on (xx.agent_id=yy.sid) $cond $cond1 order by audit_date";
			
			} else if($campaign=='chat'){
			$qSql="SELECT * from
			(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
			(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
			(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
			(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name,
			(select concat(fname, ' ', lname) as name from signin_client scx where scx.id=client_rvw_by) as client_rvw_name from qa_od_chat_feedback) xx Left Join
			(Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_ids(id) as process_id, get_process_names(id) as process, doj, DATEDIFF(CURDATE(), doj) as tenure from signin) yy on (xx.agent_id=yy.sid) $cond $cond1 order by audit_date";
			} else if($campaign=='od_chat'){
			$qSql="SELECT * from
			(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, (select concat(fname, ' ', lname) as name from signin s where s.id=(select assigned_to from signin where id=agent_id)) as tl_name from qa_od_feedback) xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, get_process_names(id) as campaign, DATEDIFF(CURDATE(), doj) as tenure, batch_code, assigned_to from signin) yy on (xx.agent_id=yy.sid) Left join (Select fd_id, note as agent_note,agent_fd_acpt, date(entry_date) as agent_rvw_date from qa_od_agent_review) zz on (xx.id=zz.fd_id) Left Join (Select fd_id as mgnt_fd_id, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as mgnt_name, note as mgnt_note, date(entry_date) as mgnt_rvw_date from qa_od_mgnt_review) ww on (xx.id=ww.mgnt_fd_id) $cond $cond1 order by audit_date";
			}

			$fullAray = $this->Common_model->get_query_result_array($qSql);
			$data["qa_od_list"] = $fullAray;
			$this->create_qaod_CSV($fullAray,$campaign);
			$dn_link = base_url()."qa_od/download_qaod_CSV";

		}

		$data['download_link']=$dn_link;
		$data["action"] = $action;
		$data['date_from'] = $date_from;
		$data['date_to'] = $date_to;
		$data['office_id']=$office_id;
		$data['agent_id']=$agent_id;
		$data['audit_type']=$audit_type;

		$this->load->view('dashboard',$data);
	}
}

public function download_qaod_CSV()
{
	$currDate=date("Y-m-d");
	$filename = "./qa_files/qa_reports_data/Report".get_user_id().".csv";
	$newfile="QA Office Depot Audit List-'".$currDate."'.csv";

	header('Content-Disposition: attachment;  filename="'.$newfile.'"');
	readfile($filename);
}

public function create_qaod_CSV($rr,$campaign)
{
	$filename = "./qa_files/qa_reports_data/Report".get_user_id().".csv";
	$fopen = fopen($filename,"w+");
	if($campaign=='od_voice'){
	$header = array("Auditor Name", "Audit Date", "Fusion ID", "Agent", "L1 Super", "Call Date","Call Duration","ANI","Reviewed By","Review Date", "Customer ID", "Session ID","LOB", "Disposition Category", "Disposition Sub Category", "Audit Type", "Workgroup","VOC", "Call Pass/Fail", "Audit Start Date Time", "Audit End Date Time", "Interval(In Second)", "Overall Score", "Earned Score", "Possible Score",
	"Acknowledge the caller matched style and pace/put customer at ease","Remarks1","Made the customer feel important and top priority","Remarks2","Appropriate and sincere use of empathy","Remarks3","Customer clearly understood the CSR agent used proper English (no OD jargon)",	"Remarks4","CCP recognized Customer contacted us multiple times regarding the same issue and escalated to Supervisor/Team Lead as appropriate?","Remarks5","Verified line item quantity price total and delivery info AS NEEDED to place the order/return","Remarks6","Followed SOP/iDepot article and account level pop up box instructions while maintaining control of the call? ","Remarks7","CCP noted appropriately? (Transaction History Special Instructions etc.)","Remarks8","Listened and paraphrased identified wants/needs and gained agreement by asking open-ended follow up questions.","Remarks9","Verified information as appropriate to the call proactively utilized CTI","Remarks10","Did the CCP submit the proper forms based on the resolution needed and summarize the resolutions steps? ","Remarks11","Was the proper dispostion code used on the call","Remarks12","Please provide the type of call (Sales or Service)","Remarks13",
	"Compliance Score Percent","Customer Score Percent","Business Score Percent","Acknowledge RCAL1","Acknowledge RCAL2","Acknowledge RCAL3","Acknowledge RCAL Cmnt","Customer RCAL1","Customer RCAL2","Customer RCAL3","Customer RCAL Cmnt","Appropriate RCAL1","Appropriate RCAL2","Appropriate RCAL3","Appropriate RCAL Cmnt","Understood RCAL1","Understood RCAL2","Understood RCAL3","Understood RCAL Cmnt","Recognized RCAL1","Recognized RCAL2","Recognized RCAL3","Recognized RCAL Cmnt",
	"Verified RCAL1","Verified RCAL2","Verified RCAL3","Verified RCAL Cmnt","Idepot RCAL1","Idepot RCAL2","Idepot RCAL3","Idepot RCAL Cmnt","Appropriately RCAL1","Appropriately RCAL2","Appropriately RCAL3","Appropriately RCAL Cmnt","Paraphrased RCAL1","Paraphrased RCAL2","Paraphrased RCAL3","Paraphrased RCAL Cmnt","Information RCAL1","Information RCAL2","Information RCAL3","Information RCAL Cmnt","Submit RCAL1","Submit RCAL2","Submit RCAL3","Submit RCAL Cmnt","Dispostion RCAL1","Dispostion RCAL2","Dispostion RCAL3","Dispostion RCAL Cmnt","Please RCAL1","Please RCAL2","Please RCAL3","Please RCAL Cmnt",
	"Call Summary", "Feedback","Agent Review Status","Agent Review Date", "Agent Comment", "Mgnt Review Date","Mgnt Review By", "Mgnt Comment");
	}else if($campaign=='od_ecommerce'){
		$header = array("Auditor Name", "Audit Date", "Fusion ID", "Agent", "L1 Super", "Call Date","Call Duration","ANI","Reviewed By","Review Date", "Customer ID", "Session ID","LOB", "Disposition Category", "Disposition Sub Category", "Audit Type", "Workgroup","VOC", "Call Pass/Fail", "Audit Start Date Time", "Audit End Date Time", "Interval(In Second)", "Overall Score", "Earned Score", "Possible Score",
		"Acknowledged the caller match style and pace put customer at ease.","Remarks1","Properly identified customer and/or account.","Remarks2","Appropriate and sincere use of empathy.","Remarks3","Made the customer feel important and top priority.","Remarks4","Followed processing guidelines for ECOM/ODR.","Remarks5","Did agent utilize all available resources/Did agent escalate the issue appropriately?","Remarks6","CCP noted appropriately? (Transaction History, Special Instructions, etc.)","Remarks7","Agent maintained control of the call (kept call on track).","Remarks8","Listened and paraphrased identified wants needs and gained agreement by asking open-ended follow up questions.","Remarks9","Verified information as appropriate to the call proactively utilized CTI.","Remarks10","Was the proper disposition code used on the call?","Remarks11",
		
		"Call Summary", "Feedback","Agent Review Status","Agent Review Date", "Agent Comment", "Mgnt Review Date","Mgnt Review By", "Mgnt Comment");
	} else if($campaign=='chat') {
	 $header = array("Auditor Name", "Audit Date", "Fusion ID", "Agent", "L1 Super", "Call Date","Call Duration","ANI","Reviewed By","Review Date", "Customer ID", "Session ID", "Disposition Category", "Disposition Sub Category", "Audit Type", "VOC", "Call Pass/Fail", "Audit Start Date Time", "Audit End Date Time", "Interval(In Second)", "Overall Score", "Earned Score", "Possible Score",
	 "Acknowledge the caller matched style and pace/put customer at ease","Made the customer feel important and top priority","Appropriate and sincere use of empathy","Customer clearly understood the CSR agent used proper English (no OD jargon)","CCP recognized Customer contacted us multiple times regarding the same issue and escalated to Supervisor/Team Lead as appropriate?","Listened and paraphrased identified wants/needs and gained agreement by asking open-ended follow up questions.","Followed SOP/iDepot article and account level pop up box instructions?","CCP noted appropriately? (Transaction History Special Instructions etc.)","Agent maintained control of the chat (kept chat on track).","Verified information as appropriate to the call proactively utilized CTI","Did the CCP submit the proper forms based on the resolution needed and summarize the resolutions steps? ","Was the proper dispostion code used on the call","Please provide the type of call (Sales or Service)",
	 "Remarks1","Remarks2","Remarks3","Remarks4","Remarks5","Remarks6","Remarks7","Remarks8","Remarks9","Remarks10","Remarks11","Remarks12","Remarks13",
	 "Call Summary", "Feedback","Agent Review Status","Agent Review Date", "Agent Comment", "Mgnt Review Date","Mgnt Review By", "Mgnt Comment");
	} else if($campaign=='od_chat') {
	$header = array("Auditor Name", "Audit Date", "Fusion ID", "Agent", "L1 Super", "WAVE", "Session ID/ANI", "Chat Date", "Customer ID", "Audit Type", "VOC", "Call Pass/Fail", "Audit Start Date Time", "Audit End Date Time", "Interval(In Second)", "Overall Score", "Earned Score", "Possible Score", "Acknowledged the chat customer", "Made the customer feel important", "Appropriate and sincere use of empathy", "Customer clearly understood the CSR", "The CCP must ASK FOR THE SALE", "Read acknowledged and understood the customer", "Used proper guidelines followed account level", "Noted appropriately", "Agent maintained control of the chat", "Verified information as appropriate to the chat", "Was the offer micro-conversion accepted", "Was the proper disposition code used on the chat", "Call Summary", "Feedback","Agent Review Status","Agent Review Date", "Agent Comment", "Mgnt Review Date","Mgnt Review By", "Mgnt Comment");
   }

	$row = "";
	foreach($header as $data) $row .= ''.$data.',';
	fwrite($fopen,rtrim($row,",")."\r\n");
	$searches = array("\r", "\n", "\r\n");

	foreach($rr as $user)
	{
		if($user['audit_start_time']=="" || $user['audit_start_time']=='0000-00-00 00:00:00'){
			$interval1 = '---';
		}else{
			$interval1 = strtotime($user['entry_date']) - strtotime($user['audit_start_time']);
		}

		if($campaign=='od_voice'){
			$row = '"'.$user['auditor_name'].'",';
			$row .= '"'.$user['audit_date'].'",';
			$row .= '"'.$user['fusion_id'].'",';
			$row .= '"'.$user['fname']." ".$user['lname'].'",';
			$row .= '"'.$user['tl_name'].'",';
			$row .= '"'.$user['call_date'].'",';
			$row .= '"'.$user['call_duration'].'",';
			$row .= '"'.$user['ani'].'",';
			$row .= '"'.$user['reviewed'].'",';
			$row .= '"'.$user['review_date'].'",';
			$row .= '"'.$user['customer_id'].'",';
			$row .= '"'.$user['session_id'].'",';
			$row .= '"'.$user['lob'].'",';
			$row .= '"'.$user['disposition_cate'].'",';
			$row .= '"'.$user['disposition_sub_cate'].'",';
			$row .= '"'.$user['audit_type'].'",';
			$row .= '"'.$user['workgroup'].'",';
			$row .= '"'.$user['voc'].'",';
			$row .= '"'.$user['division_status'].'",';
			$row .= '"'.$user['audit_start_time'].'",';
			$row .= '"'.$user['entry_date'].'",';
			$row .= '"'.$interval1.'",';
			$row .= '"'.$user['overall_score'].'%'.'",';
			$row .= '"'.$user['earned_score'].'",';
			$row .= '"'.$user['possible_score'].'",';
			$row .= '"'.$user['acknowledge_the_caller'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt1'])).'",';
			$row .= '"'.$user['made_the_customer'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt2'])).'",';
			$row .= '"'.$user['appropriate_and_sincere'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt3'])).'",';
			$row .= '"'.$user['customer_clearly_understood'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt4'])).'",';
			$row .= '"'.$user['recognized_customer_contacted'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt5'])).'",';
			$row .= '"'.$user['verified_line_item'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt6'])).'",';
			$row .= '"'.$user['idepot_article_and'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt7'])).'",';
			$row .= '"'.$user['noted_appropriately'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt8'])).'",';
			$row .= '"'.$user['listened_and_paraphrased'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt9'])).'",';
			$row .= '"'.$user['verified_information'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt10'])).'",';
			$row .= '"'.$user['submit_the_proper_forms'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt11'])).'",';
			$row .= '"'.$user['proper_dispostion_code'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt12'])).'",';
			$row .= '"'.$user['please_provide_type'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt13'])).'",';
			$row .= '"'.$user['compliance_score_percent'].'%'.'",';
			$row .= '"'.$user['customer_score_percent'].'%'.'",';
			$row .= '"'.$user['business_score_percent'].'%'.'",';
			$row .= '"'.$user['acknowledge_rcal1'].'",';
			$row .= '"'.$user['acknowledge_rcal2'].'",';
			$row .= '"'.$user['acknowledge_rcal3'].'",';
			$row .= '"'.$user['acknowledge_rcal_cmt'].'",';
			$row .= '"'.$user['customer_rcal1'].'",';
			$row .= '"'.$user['customer_rcal2'].'",';
			$row .= '"'.$user['customer_rcal3'].'",';
			$row .= '"'.$user['customer_rcal_cmt'].'",';
			$row .= '"'.$user['appropriate_rcal1'].'",';
			$row .= '"'.$user['appropriate_rcal2'].'",';
			$row .= '"'.$user['appropriate_rcal3'].'",';
			$row .= '"'.$user['appropriate_rcal_cmt'].'",';
			$row .= '"'.$user['understood_rcal1'].'",';
			$row .= '"'.$user['understood_rcal2'].'",';
			$row .= '"'.$user['understood_rcal3'].'",';
			$row .= '"'.$user['understood_rcal_cmt'].'",';
			$row .= '"'.$user['recognized_rcal1'].'",';
			$row .= '"'.$user['recognized_rcal2'].'",';
			$row .= '"'.$user['recognized_rcal3'].'",';
			$row .= '"'.$user['recognized_rcal_cmt'].'",';
			$row .= '"'.$user['verified_rcal1'].'",';
			$row .= '"'.$user['verified_rcal2'].'",';
			$row .= '"'.$user['verified_rcal3'].'",';
			$row .= '"'.$user['verified_rcal_cmt'].'",';
			$row .= '"'.$user['idepot_rcal1'].'",';
			$row .= '"'.$user['idepot_rcal2'].'",';
			$row .= '"'.$user['idepot_rcal3'].'",';
			$row .= '"'.$user['idepot_rcal_cmt'].'",';
			$row .= '"'.$user['appropriately_rcal1'].'",';
			$row .= '"'.$user['appropriately_rcal2'].'",';
			$row .= '"'.$user['appropriately_rcal3'].'",';
			$row .= '"'.$user['appropriately_rcal_cmt'].'",';
			$row .= '"'.$user['paraphrased_rcal1'].'",';
			$row .= '"'.$user['paraphrased_rcal2'].'",';
			$row .= '"'.$user['paraphrased_rcal3'].'",';
			$row .= '"'.$user['paraphrased_rcal_cmt'].'",';
			$row .= '"'.$user['information_rcal1'].'",';
			$row .= '"'.$user['information_rcal2'].'",';
			$row .= '"'.$user['information_rcal3'].'",';
			$row .= '"'.$user['information_rcal_cmt'].'",';
			$row .= '"'.$user['submit_rcal1'].'",';
			$row .= '"'.$user['submit_rcal2'].'",';
			$row .= '"'.$user['submit_rcal3'].'",';
			$row .= '"'.$user['submit_rcal_cmt'].'",';
			$row .= '"'.$user['dispostion_rcal1'].'",';
			$row .= '"'.$user['dispostion_rcal2'].'",';
			$row .= '"'.$user['dispostion_rcal3'].'",';
			$row .= '"'.$user['dispostion_rcal_cmt'].'",';
			$row .= '"'.$user['please_rcal1'].'",';
			$row .= '"'.$user['please_rcal2'].'",';
			$row .= '"'.$user['please_rcal3'].'",';
			$row .= '"'.$user['please_rcal_cmt'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['call_summary'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['feedback'])).'",';
			$row .= '"'.$user['agnt_fd_acpt'].'",';
			$row .= '"'.$user['agent_rvw_date'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['agent_rvw_note'])).'",';
			$row .= '"'.$user['mgnt_rvw_date'].'",';
			$row .= '"'.$user['mgnt_rvw_name'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['mgnt_rvw_note'])).'"';

		}else if($campaign=='od_ecommerce'){
			$row = '"'.$user['auditor_name'].'",';
			$row .= '"'.$user['audit_date'].'",';
			$row .= '"'.$user['fusion_id'].'",';
			$row .= '"'.$user['fname']." ".$user['lname'].'",';
			$row .= '"'.$user['tl_name'].'",';
			$row .= '"'.$user['call_date'].'",';
			$row .= '"'.$user['call_duration'].'",';
			$row .= '"'.$user['ani'].'",';
			$row .= '"'.$user['reviewed'].'",';
			$row .= '"'.$user['review_date'].'",';
			$row .= '"'.$user['customer_id'].'",';
			$row .= '"'.$user['session_id'].'",';
			$row .= '"'.$user['lob'].'",';
			$row .= '"'.$user['disposition_cate'].'",';
			$row .= '"'.$user['disposition_sub_cate'].'",';
			$row .= '"'.$user['audit_type'].'",';
			$row .= '"'.$user['workgroup'].'",';
			$row .= '"'.$user['voc'].'",';
			$row .= '"'.$user['division_status'].'",';
			$row .= '"'.$user['audit_start_time'].'",';
			$row .= '"'.$user['entry_date'].'",';
			$row .= '"'.$interval1.'",';
			$row .= '"'.$user['overall_score'].'%'.'",';
			$row .= '"'.$user['earned_score'].'",';
			$row .= '"'.$user['possible_score'].'",';
			$row .= '"'.$user['acknowledge_the_caller'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt1'])).'",';
			$row .= '"'.$user['made_the_customer'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt2'])).'",';
			$row .= '"'.$user['appropriate_and_sincere'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt3'])).'",';
			$row .= '"'.$user['customer_clearly_understood'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt4'])).'",';
			$row .= '"'.$user['recognized_customer_contacted'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt5'])).'",';
			$row .= '"'.$user['verified_line_item'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt6'])).'",';
			$row .= '"'.$user['idepot_article_and'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt7'])).'",';
			$row .= '"'.$user['noted_appropriately'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt8'])).'",';
			$row .= '"'.$user['listened_and_paraphrased'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt9'])).'",';
			$row .= '"'.$user['verified_information'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt10'])).'",';
			$row .= '"'.$user['submit_the_proper_forms'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt11'])).'",';
			$row .= '"'.$user['compliance_score_percent'].'%'.'",';
			$row .= '"'.$user['customer_score_percent'].'%'.'",';
			$row .= '"'.$user['business_score_percent'].'%'.'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['call_summary'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['feedback'])).'",';
			$row .= '"'.$user['agnt_fd_acpt'].'",';
			$row .= '"'.$user['agent_rvw_date'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['agent_rvw_note'])).'",';
			$row .= '"'.$user['mgnt_rvw_date'].'",';
			$row .= '"'.$user['mgnt_rvw_name'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['mgnt_rvw_note'])).'"';	
			
		}else if($campaign=='chat') {
			$row = '"'.$user['auditor_name'].'",';
			$row .= '"'.$user['audit_date'].'",';
			$row .= '"'.$user['fusion_id'].'",';
			$row .= '"'.$user['fname']." ".$user['lname'].'",';
			$row .= '"'.$user['tl_name'].'",';
			$row .= '"'.$user['call_date'].'",';
			$row .= '"'.$user['call_duration'].'",';
			$row .= '"'.$user['ani'].'",';
			$row .= '"'.$user['reviewed'].'",';
			$row .= '"'.$user['review_date'].'",';
			$row .= '"'.$user['customer_id'].'",';
			$row .= '"'.$user['session_id'].'",';
			$row .= '"'.$user['disposition_cate'].'",';
			$row .= '"'.$user['disposition_sub_cate'].'",';
			$row .= '"'.$user['audit_type'].'",';
			$row .= '"'.$user['voc'].'",';
			$row .= '"'.$user['division_status'].'",';
			$row .= '"'.$user['audit_start_time'].'",';
			$row .= '"'.$user['entry_date'].'",';
			$row .= '"'.$interval1.'",';
			$row .= '"'.$user['overall_score'].'%'.'",';
			$row .= '"'.$user['earned_score'].'",';
			$row .= '"'.$user['possible_score'].'",';
			$row .= '"'.$user['acknowledge_the_caller'].'",';
			$row .= '"'.$user['made_the_customer'].'",';
			$row .= '"'.$user['appropriate_and_sincere'].'",';
			$row .= '"'.$user['customer_clearly_understood'].'",';
			$row .= '"'.$user['recognized_customer_contacted'].'",';
			$row .= '"'.$user['verified_line_item'].'",';
			$row .= '"'.$user['idepot_article_and'].'",';
			$row .= '"'.$user['noted_appropriately'].'",';
			$row .= '"'.$user['listened_and_paraphrased'].'",';
			$row .= '"'.$user['verified_information'].'",';
			$row .= '"'.$user['submit_the_proper_forms'].'",';
			$row .= '"'.$user['proper_dispostion_code'].'",';
			$row .= '"'.$user['please_provide_type'].'",';
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
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['call_summary'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['feedback'])).'",';
			$row .= '"'.$user['agnt_fd_acpt'].'",';
			$row .= '"'.$user['agent_rvw_date'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['agent_rvw_note'])).'",';
			$row .= '"'.$user['mgnt_rvw_date'].'",';
			$row .= '"'.$user['mgnt_rvw_name'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['mgnt_rvw_note'])).'"';
		}else if($campaign=='od_chat') {
			$row = '"'.$user['auditor_name'].'",';
			$row .= '"'.$user['audit_date'].'",';
			$row .= '"'.$user['fusion_id'].'",';
			$row .= '"'.$user['fname']." ".$user['lname'].'",';
			$row .= '"'.$user['tl_name'].'",';
			$row .= '"'.$user['batch_code'].'",';
			$row .= '"'.$user['ani'].'",';
			$row .= '"'.$user['chat_date'].'",';
			$row .= '"'.$user['customer_id'].'",';
			$row .= '"'.$user['audit_type'].'",';
			$row .= '"'.$user['voc'].'",';
			$row .= '"'.$user['call_pass_fail'].'",';
			$row .= '"'.$user['audit_start_time'].'",';
			$row .= '"'.$user['entry_date'].'",';
			$row .= '"'.$interval1.'",';
			$row .= '"'.$user['overall_score'].'%'.'",';
			$row .= '"'.$user['score'].'",';
			$row .= '"'.$user['possible_score'].'",';
			$row .= '"'.$user['ack_chat_cust'].'",';
			$row .= '"'.$user['made_cust_feel_imp'].'",';
			$row .= '"'.$user['appro_sin_empathy'].'",';
			$row .= '"'.$user['cust_clr_understood_crs'].'",';
			$row .= '"'.$user['ccp_ask_sale'].'",';
			$row .= '"'.$user['read_ack_understood_cust'].'",';
			$row .= '"'.$user['used_proper_guidelines'].'",';
			$row .= '"'.$user['noted_appropriately'].'",';
			$row .= '"'.$user['agent_maintained_control_chat'].'",';
			$row .= '"'.$user['verified_info_appropriate_chat'].'",';
			$row .= '"'.$user['was_the_offer'].'",';
			$row .= '"'.$user['was_the_proper_dispo'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['call_summary'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['feedback'])).'",';
			$row .= '"'.$user['agent_fd_acpt'].'",';
			$row .= '"'.$user['agent_rvw_date'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['agent_note'])).'",';
			$row .= '"'.$user['mgnt_rvw_date'].'",';
			$row .= '"'.$user['mgnt_name'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['mgnt_note'])).'"';
		}
		fwrite($fopen,$row."\r\n");
	}

	fclose($fopen);
}
////////////////////////////////	
	// public function qaod_report(){
	// 	if(check_logged_in()){
	// 		$user_office_id=get_user_office_id();
	// 		$current_user = get_user_id();
	// 		$is_global_access=get_global_access();
	// 		$role_dir=get_role_dir();
	// 		$data["show_download"] = false;
	// 		$data["download_link"] = "";
	// 		$data["show_table"] = false;
	// 		$data["show_table"] = false;
	// 		$data["aside_template"] = "reports/aside.php";
	// 		$data["content_template"] = "qa_od/qaod_report.php";
			
	// 		$data["get_agent_id_list"] = $this->Qa_od_model->get_agent_id(42);
	// 		$data['location_list'] = $this->Common_model->get_office_location_list();
			
	// 		$office_id = "";
	// 		$agent_id="";
	// 		$audit_type="";
	// 		$action="";
	// 		$dn_link="";
	// 		$cond="";
	// 		$cond1="";
			
	// 		$date_from=$this->input->get('date_from');
	// 		$date_to=$this->input->get('date_to');
			
	// 		if($date_from==""){ 
	// 			$date_from=CurrDate();
	// 		}else{
	// 			$date_from = mmddyy2mysql($date_from);
	// 		}
			
	// 		if($date_to==""){ 
	// 			$date_to=CurrDate();
	// 		}else{
	// 			$date_to = mmddyy2mysql($date_to);
	// 		}
			
	// 		$data["qa_od_list"] = array();
			
	// 		if($this->input->get('show')=='Show')
	// 		{
	// 			$date_from = $date_from;
	// 			$date_to = $date_to;
	// 			$office_id = $this->input->get('office_id');
	// 			$agent_id = $this->input->get('agent_id');
	// 			$audit_type = $this->input->get('audit_type');
				
				
	// 			if($date_from !="" && $date_to!=="" )  $cond= " Where (audit_date >= '$date_from' and audit_date <= '$date_to' ) ";
	// 			if($agent_id!="") $cond .=" and agent_id='$agent_id'";
	// 			if($audit_type!="")	$cond .=" and audit_type='$audit_type'";
		
	// 			if($office_id=="All") $cond .= "";
	// 			else $cond .=" and office_id='$office_id'";
				
	// 			if(get_role_dir()=='manager' && get_dept_folder()=='operations'){
	// 				$cond1 .=" And (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";
	// 			}else if(get_role_dir()=='tl' && get_dept_folder()=='operations'){
	// 				$cond1 .=" And assigned_to='$current_user'";
	// 			}else{
	// 				$cond1 .="";
	// 			}
		
	// 			$qSql="SELECT * from
	// 			(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, (select concat(fname, ' ', lname) as name from signin s where s.id=(select assigned_to from signin where id=agent_id)) as tl_name from qa_od_feedback) xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, get_process_names(id) as campaign, DATEDIFF(CURDATE(), doj) as tenure, batch_code, assigned_to from signin) yy on (xx.agent_id=yy.sid) Left join (Select fd_id, note as agent_note,agent_fd_acpt, date(entry_date) as agent_rvw_date from qa_od_agent_review) zz on (xx.id=zz.fd_id) Left Join (Select fd_id as mgnt_fd_id, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as mgnt_name, note as mgnt_note, date(entry_date) as mgnt_rvw_date from qa_od_mgnt_review) ww on (xx.id=ww.mgnt_fd_id) $cond $cond1 order by audit_date";
				
	// 			$fullAray = $this->Common_model->get_query_result_array($qSql);
	// 			$data["qa_od_list"] = $fullAray;
	// 			$this->create_qaod_CSV($fullAray);	
	// 			$dn_link = base_url()."qa_od/download_qaod_CSV";
				
	// 		}
			
	// 		$data['download_link']=$dn_link;
	// 		$data["action"] = $action;	
	// 		$data['date_from'] = $date_from;
	// 		$data['date_to'] = $date_to;	
	// 		$data['office_id']=$office_id;
	// 		$data['agent_id']=$agent_id;
	// 		$data['audit_type']=$audit_type;
			
	// 		$this->load->view('dashboard',$data);
	// 	}
	// }
	
	// public function download_qaod_CSV()
	// {
	// 	$currDate=date("Y-m-d");
	// 	$filename = "./assets/reports/Report".get_user_id().".csv";
	// 	$newfile="QA Office Depot Audit List-'".$currDate."'.csv";
		
	// 	header('Content-Disposition: attachment;  filename="'.$newfile.'"');
	// 	readfile($filename);
	// }
	
	// public function create_qaod_CSV($rr)
	// {
	// 	$filename = "./assets/reports/Report".get_user_id().".csv";
	// 	$fopen = fopen($filename,"w+");
	// 	$header = array("Auditor Name", "Audit Date", "Fusion ID", "Agent", "L1 Super", "WAVE", "Session ID/ANI", "Chat Date", "Customer ID", "Audit Type", "Workgroup","VOC", "Call Pass/Fail", "Audit Start Date Time", "Audit End Date Time", "Interval(In Second)", "Overall Score", "Earned Score", "Possible Score", "Acknowledged the chat customer", "Made the customer feel important", "Appropriate and sincere use of empathy", "Customer clearly understood the CSR", "The CCP must ASK FOR THE SALE", "Read acknowledged and understood the customer", "Used proper guidelines followed account level", "Noted appropriately", "Agent maintained control of the chat", "Verified information as appropriate to the chat", "Was the offer micro-conversion accepted", "Was the proper disposition code used on the chat", "Call Summary", "Feedback","Agent Review Status","Agent Review Date", "Agent Comment", "Mgnt Review Date","Mgnt Review By", "Mgnt Comment");
		
	// 	$row = "";
	// 	foreach($header as $data) $row .= ''.$data.',';
	// 	fwrite($fopen,rtrim($row,",")."\r\n");
	// 	$searches = array("\r", "\n", "\r\n");
		
	// 	foreach($rr as $user)
	// 	{	
	// 		if($user['audit_start_time']=="" || $user['audit_start_time']=='0000-00-00 00:00:00'){
	// 			$interval1 = '---';
	// 		}else{
	// 			$interval1 = strtotime($user['entry_date']) - strtotime($user['audit_start_time']);
	// 		}
		
	// 		$row = '"'.$user['auditor_name'].'",'; 
	// 		$row .= '"'.$user['audit_date'].'",'; 
	// 		$row .= '"'.$user['fusion_id'].'",'; 
	// 		$row .= '"'.$user['fname']." ".$user['lname'].'",';
	// 		$row .= '"'.$user['tl_name'].'",'; 
	// 		$row .= '"'.$user['batch_code'].'",'; 
	// 		$row .= '"'.$user['ani'].'",'; 
	// 		$row .= '"'.$user['chat_date'].'",'; 
	// 		$row .= '"'.$user['customer_id'].'",'; 
	// 		$row .= '"'.$user['audit_type'].'",'; 
	// 		$row .= '"'.$user['workgroup'].'",'; 
	// 		$row .= '"'.$user['voc'].'",'; 
	// 		$row .= '"'.$user['call_pass_fail'].'",'; 
	// 		$row .= '"'.$user['audit_start_time'].'",';
	// 		$row .= '"'.$user['entry_date'].'",';
	// 		$row .= '"'.$interval1.'",';
	// 		$row .= '"'.$user['overall_score'].'%'.'",'; 
	// 		$row .= '"'.$user['score'].'",';
	// 		$row .= '"'.$user['possible_score'].'",'; 
	// 		$row .= '"'.$user['ack_chat_cust'].'",'; 
	// 		$row .= '"'.$user['made_cust_feel_imp'].'",'; 
	// 		$row .= '"'.$user['appro_sin_empathy'].'",'; 
	// 		$row .= '"'.$user['cust_clr_understood_crs'].'",'; 
	// 		$row .= '"'.$user['ccp_ask_sale'].'",'; 
	// 		$row .= '"'.$user['read_ack_understood_cust'].'",'; 
	// 		$row .= '"'.$user['used_proper_guidelines'].'",'; 
	// 		$row .= '"'.$user['noted_appropriately'].'",'; 
	// 		$row .= '"'.$user['agent_maintained_control_chat'].'",'; 
	// 		$row .= '"'.$user['verified_info_appropriate_chat'].'",'; 
	// 		$row .= '"'.$user['was_the_offer'].'",'; 
	// 		$row .= '"'.$user['was_the_proper_dispo'].'",';
	// 		$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['call_summary'])).'",';
	// 		$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['feedback'])).'",';
	// 		$row .= '"'.$user['agent_fd_acpt'].'",';
	// 		$row .= '"'.$user['agent_rvw_date'].'",';
	// 		$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['agent_note'])).'",';
	// 		$row .= '"'.$user['mgnt_rvw_date'].'",';
	// 		$row .= '"'.$user['mgnt_name'].'",';
	// 		$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['mgnt_note'])).'"';				
			
	// 		fwrite($fopen,$row."\r\n");
	// 	}
		
	// 	fclose($fopen);
	// }
	
	
}

?>