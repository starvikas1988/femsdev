<?php 

 class Qa_cq_squad_stack extends CI_Controller{
	
	public function __construct(){
		parent::__construct();
		$this->load->model('user_model');
		$this->load->model('Common_model');
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


	private function ajio_upload_files($files,$path)   // this is for file uploaging purpose 
    {
    	$result=$this->createPath($path);
    	if($result){
        $config['upload_path'] = $path;
	   	$config['allowed_types'] = '*';
		
	 //  $config['allowed_types'] = 'avi|mp4|3gp|mpeg|mpg|mov|mp3|flv|wmv|mkv';
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


	public function index(){
		if(check_logged_in())
		{
			$current_user = get_user_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_cq_squad_stack/qa_cq_squad_stack_feedback.php";
			$data["content_js"] = "qa_squad_stack_js.php";

			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,359) and is_assign_process (id,757)  and status=1  order by name";
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
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_name from qa_cq_squad_stack $cond) xx Left Join
				(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";
			$data["qa_cq_squad_stack"] = $this->Common_model->get_query_result_array($qSql);

			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_name from qa_squad_stack_feedback $cond) xx Left Join
				(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";
			$data["qa_squad_stack"] = $this->Common_model->get_query_result_array($qSql);

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
			$data["content_template"] = "qa_cq_squad_stack/add_edit_squad_stack.php";
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
					$field_array['call_date']=mdydt2mysql($this->input->post('call_date'));
					$field_array['entry_date']=$curDateTime;
					$field_array['audit_start_time']=$this->input->post('audit_start_time');
					
					if($_FILES['attach_file']['tmp_name'][0]!=''){
						$a = $this->squad_stack_upload_files($_FILES['attach_file'], $path='./qa_files/qa_stack/inbound/');
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
					$field_array1['call_date']=mdydt2mysql($this->input->post('call_date'));
					if($_FILES['attach_file']['tmp_name'][0]!=''){
						if(!file_exists("./qa_files/qa_stack/inbound/")){
							mkdir("./qa_files/qa_stack/inbound/");
						}
						$a = $this->squad_stack_upload_files( $_FILES['attach_file'], $path = './qa_files/qa_stack/inbound/' );
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
					redirect('Qa_cq_squad_stack');
				}

				
			}
			$data["array"] = $a;

			$this->load->view("dashboard",$data);
		}
	}

	///////////////////vikas ends/////////////////////////////

public function edit_qa_cq_squad_stack($ajio_id)  // working file sougata  
{
	if(check_logged_in()){
	
		$_SESSION['id'] = $ajio_id;


		if(isset($_POST['mgnt_rvw_by']) && $_POST['note'])
		{

			//$time_now=mktime(date('h')+5,date('i')+30,date('s'));
			date_default_timezone_set('Asia/Manila');
			$curDateTime = date('d-m-Y H:i');
			$mgnt_rvw_note=$this->input->post('note');
			$mgnt_rvw_note=ucwords($mgnt_rvw_note);
			$edit_array = array(
			"mgnt_rvw_by" => $this->input->post('mgnt_rvw_by'),
			"mgnt_rvw_note" =>$mgnt_rvw_note,
			"mgnt_rvw_date" => $curDateTime
		);
	
	$this->db->where('id', $ajio_id);
	$this->db->update('qa_cq_squad_stack',$edit_array);

	redirect(base_url('qa_cq_squad_stack'));
	}
   else{

	$qSql = " SELECT * from
	(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
	(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
	(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
	(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from  qa_cq_squad_stack where id='$ajio_id') xx Left Join
	(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";

	$data["stack_edit"] = $this->Common_model->get_query_result_array($qSql);
	
	$data["aside_template"] = "qa/aside.php";
	
	$data["content_template"] = "qa_cq_squad_stack/edit_qa_cq_squad_stack.php";
	$data["content_js"] = "qa_cq_squad_stack_js.php";// js file for this page 
	
	$this->load->view('dashboard',$data);

   }

	}
}

   public function add_qa_cq_squad_stack($ajio_id)  // working file sougata 
	 {
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php"; // side bar of the page 
			
			$data["content_template"] = "qa_cq_squad_stack/curd_qa_cq_squad_stack.php"; // working disable for testing 
			


			$data["content_js"] = "qa_cq_squad_stack_js.php";
			
			// js file for this page 
			
			$data['ajio_id']=$ajio_id;

       


			$tl_mgnt_cond='';
			
			if(get_role_dir()=='manager' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";
			}else if(get_role_dir()=='tl' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and assigned_to='$current_user'";
			}else{
				$tl_mgnt_cond="";
			}
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_process(id,757) and status=1 order by name";
			
			
			
			
			/*  and is_assign_process(id,495) */
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT id, fname, lname, fusion_id, office_id FROM signin where role_id in (select id from role where (folder in ('tl','trainer','am','manager')) or (name in ('Client Services'))) and status=1";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
			
           $qSql="SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, (select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, (select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_cq_squad_stack where id='1') xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";

			
			$data["stack_add"] = $this->Common_model->get_query_row_array($qSql);
			
			//$curDateTime=CurrMySqlDate();
			date_default_timezone_set('Asia/Manila');
			//date_default_timezone_set('Asia/Kolkata');
			$curDateTime = date('d-m-Y H:i');
			$a = array();
			
			
			$field_array['agent_id']=!empty($_POST['data']['agent_id'])?$_POST['data']['agent_id']:"";
			if($field_array['agent_id']){
				
				if($ajio_id==0){
					
					$field_array=$this->input->post('data');
					///$sum=$field_array['used_suggested_opening_spiel']+$field_array['obtained_customer_consent']+$field_array['active_listening_or_reading']+$field_array['proper_hold_procedure']+$field_array['dead_air']+$field_array['interruption']+$field_array['customer_experience']+$field_array['complete_accurate_information']+$field_array['probing_question']+$field_array['complete_accurate_notes']+$field_array['use_proper_disposition_tagging']+$field_array['additional_assistance']+$field_array['used_Suggested_Closing_Spiel'];
                    
				
                   
					$field_array['audit_date']=CurrDate();
					$field_array['call_date']=mdydt2mysql($this->input->post('call_date'));
					$field_array['entry_date']=$curDateTime;
					$field_array['audit_start_time']=$this->input->post('audit_start_time');
					$a = $this->ajio_upload_files($_FILES['attach_file'], $path='./qa_files/qa_stack/inbound/');
					$field_array["attach_file"] = implode(',',$a);
					$rowid= data_inserter('qa_cq_squad_stack',$field_array);
				///////////
					if(get_login_type()=="client"){
						$add_array = array("client_entryby" => $current_user);
					}else{
						$add_array = array("entry_by" => $current_user);
					}
					$this->db->where('id', $rowid);
					
					$this->db->update('qa_cq_squad_stack',$add_array);
					
			 }
				
				redirect('qa_cq_squad_stack');
			}
			$data["array"] = $a;
			$this->load->view("dashboard",$data);
		}
	}
	

/*------------------- Agent Part ---------------------*/

//public function agent_stack_feedback() // working fine - thi sis client side dashboard page 
public function qa_cq_squad_stack_agent_feedback() 
{
	if(check_logged_in()){
		$user_site_id= get_user_site_id();
		$role_id= get_role_id();
		$current_user = get_user_id();
		$data["aside_template"] = "qa/aside.php";
		
		

		$data["content_template"] = "qa_cq_squad_stack/qa_cq_squad_stack_agent_feedback.php"; // working disable for testing 
		


		$data["content_js"] = "qa_squad_stack_js.php";// js file for this page 


		$data["agentUrl"] = "qa_cq_squad_stack/agent_stack_feedback";
		
		$from_date = '';
		$to_date = '';
		
		$cond="";
		
		// $campaign = $this->input->get('campaign');
		
		
		
			$qSql="Select count(id) as value from  qa_cq_squad_stack where agent_id='$current_user'";
			$data["tot_feedback"] =  $this->Common_model->get_single_value($qSql);
			
			$qSql="Select count(id) as value from  qa_cq_squad_stack where agent_id='$current_user' and agent_rvw_date=' '";
			$data["yet_rvw"] =  $this->Common_model->get_single_value($qSql);

			$qSql="Select count(id) as value from qa_squad_stack_feedback where agent_id='$current_user' and audit_type not in ('Calibration', 'Pre-Certificate Mock Call', 'Certification Audit','QA Supervisor Audit')";
			$data["tot_agent_feedback"] =  $this->Common_model->get_single_value($qSql);

			$qSql="Select count(id) as value from qa_squad_stack_feedback where agent_rvw_date is null and agent_id='$current_user' and audit_type not in ('Calibration', 'Pre-Certificate Mock Call', 'Certification Audit','QA Supervisor Audit')";

			$data["tot_agent_yet_rvw"] =  $this->Common_model->get_single_value($qSql);
			
			
			if($this->input->get('btnView')=='View')
			{
				$fromDate = $this->input->get('from_date');
				if($fromDate!="") $from_date = mmddyy2mysql($fromDate);
				
				$toDate = $this->input->get('to_date');
				if($toDate!="") $to_date = mmddyy2mysql($toDate);
				
				if($fromDate !="" && $toDate!=="" ){ 
					$cond= " Where (audit_date >= '$from_date' and audit_date <= '$to_date') And agent_id='$current_user'";
				}else{
					$cond= " Where agent_id='$current_user' ";
				}
				
				if($from_date !="" && $to_date!=="" )  $cond= " Where (audit_date >= '$from_date' and audit_date <= '$to_date') and agent_id='$current_user'";
				
				$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_cq_squad_stack $cond) xx Left Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_client_names(id) as client, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
				$data["agent_rvw_list"] = $this->Common_model->get_query_result_array($qSql);

				$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_squad_stack_feedback $cond) xx Left Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_client_names(id) as client, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
				$data["agent_squad_stack_rvw_list"] = $this->Common_model->get_query_result_array($qSql);
					
			}else{
	
				$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_cq_squad_stack where agent_id='$current_user') xx Left Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_client_names(id) as client, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid) Where xx.agent_rvw_date is Null";
				$data["agent_rvw_list"] = $this->Common_model->get_query_result_array($qSql);

				$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_squad_stack_feedback where agent_id='$current_user') xx Left Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_client_names(id) as client, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid) ";
				//Where xx.agent_rvw_date is Null
				$data["agent_squad_stack_rvw_list"] = $this->Common_model->get_query_result_array($qSql);
	
			}
			
		
		
		$data["from_date"] = $from_date;
		$data["to_date"] = $to_date;
		
		
		$this->load->view('dashboard',$data);
	}
}
  //////vikas////////////////
public function agent_squad_stack_rvw($id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_cq_squad_stack/agent_squad_stack_rvw.php";
			$data["agentUrl"] = "qa_cq_squad_stack/agent_squad_stack_feedback";
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
				
				redirect('qa_cq_squad_stack/qa_cq_squad_stack_agent_feedback');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}

	//////////////////////VIKAS ENDS///////////////////////////////////


public function agent_stack_rvw($id) // working fine sougata thisis form 
{
	if(check_logged_in()){
		$current_user=get_user_id();
		$user_office_id=get_user_office_id();
		$data["aside_template"] = "qa/aside.php";
	
		$data["content_template"] = "qa_cq_squad_stack/qa_cq_squad_stack_rvw.php";
		
		
		
		$data["content_js"] = "qa_cq_squad_stack_js.php";// js file for this page 
		$data["agentUrl"] = "qa_cq_squad_stack/agent_stack_feedback";
		
		
		//$data["campaign"] = $campaign;
		$data["pnid"]=$id;
		
		$qSql="SELECT * from
			(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
			(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
			(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
			(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_cq_squad_stack where id='$id') xx Left Join
			(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
		$data["agent_stack_dna"] = $this->Common_model->get_query_row_array($qSql);
		
		if($this->input->post('pnid'))
		{
			$pnid=$this->input->post('pnid');
		//	$curDateTime=CurrMySqlDate();
		date_default_timezone_set('Asia/Manila');
		//date_default_timezone_set('Asia/Kolkata');
			$curDateTime = date('d-m-Y H:i');
			$log=get_logs();
				
			$field_array1=array(
				"agnt_fd_acpt" => $this->input->post('agnt_fd_acpt'),
				"agent_rvw_note" => ucwords($this->input->post('note')),
				"agent_rvw_date" => $curDateTime
			);
			$this->db->where('id', $pnid);
			$this->db->update("qa_cq_squad_stack",$field_array1);
				
			redirect('qa_cq_squad_stack/qa_cq_squad_stack_agent_feedback');
			
		}else{
			$this->load->view('dashboard',$data);
		}
	}
}

	
/*------------------------------ Report Part ---------------------------*/


public function qa_stack_report() // working 
	
	
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
			$data["content_template"] = "qa_cq_squad_stack/qa_cq_squad_stack_report.php";
			
			$data["content_js"] = "qa_squad_stack_js.php";// js file for this page 
		
		
			$data['location_list'] = $this->Common_model->get_office_location_list();

			$office_id = "";
			$date_from="";
			$date_to="";
			$campaign="";
			$action="";
			$dn_link="";
			$cond="";
			$cond1="";

			

			$data["qa_stack_list"] = array();

			
				if($this->input->get('show')=='Show')
				{
					$date_from = mmddyy2mysql($this->input->get('date_from'));
					$date_to = mmddyy2mysql($this->input->get('date_to'));
					$office_id = $this->input->get('office_id');
					$campaign = $this->input->get('campaign');

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
					(select concat(fname, ' ', lname) as name from signin_client scx where scx.id=client_rvw_by) as client_rvw_name from qa_".$campaign.") xx 
					Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_ids(id) as process_id, get_process_names(id) as process, doj, DATEDIFF(CURDATE(), doj) as tenure from signin) yy on (xx.agent_id=yy.sid) $cond $cond1 order by audit_date";

					$fullAray = $this->Common_model->get_query_result_array($qSql);
					
					$data["qa_stack_list"]=$fullAray;
				

					$this->create_stack_CSV($fullAray,$campaign);
					$dn_link = base_url()."qa_cq_squad_stack/download_stack_CSV/".$campaign;
				}
				
			

			$data['download_link']=$dn_link;
			$data["action"] = $action;
			$data['date_from'] = $date_from;
			$data['date_to'] = $date_to;
			$data['campaign']=$campaign;
			$this->load->view('dashboard',$data);
		}
	}



	public  function download_stack_CSV($campaign) // testing sougata 
	{
		$currDate=date("Y-m-d");
		$filename = "./qa_files/qa_stack/Report".get_user_id().".csv";
		$newfile=" ".$campaign."   List-'".$currDate."'.csv";
		header('Content-Disposition: attachment;  filename="'.$newfile.'"');
		readfile($filename);
	}


	public function create_stack_CSV($rr,$campaign)
	{
		$currDate=date("Y-m-d");
		
		
		$filename = FCPATH . "qa_files/qa_stack/Report".get_user_id().".csv";
		$fopen = fopen($filename,"w+");
if($campaign=='cq_squad_stack'){
	$header = array("Auditor Name", "Audit Date ", "Agent Name ", "Fusion ID ", "L1 Supervisor ", "Call Date ", "Audit Type ", "Type of Auditor ", "Earned Score ", "Possible Score ", "Overall Score % ", "Auditor Type", "VOC", "Did Sales Expert (SE) follow the mandatory part of scripts?", "Did Sales Expert (SE) follow the mandatory part of scripts? observation ","Did the SE write/record correct answers to the questions provided?","Did the SE write/record correct answers to the questions provided? observation ","Did SE conduct the call without using abusive words or heated words?","Did SE conduct the call without using abusive words words or heated words?","Did SE pronounce the brand correctly?","Did SE pronounce the brand correctly? observation ","Was correct information provided by SE on Price, Product & scheme?","Was correct information provided by SE on Price, Product & scheme? observation ","Was the sales expert able to probe the lead? (Define Probe and Guidelines)","Was the sales expert able to probe the lead? (Define Probe and Guidelines)observation 	","Did the agent give accurate information to the lead on the call? (Without Misselling/misleading)","Did the agent give accurate information to the lead on the call? observation ","Did the sales expert explain all the product's benefits and solutions to the lead?","Did the sales expert explain all the product's benefits and solutions to the lead? observation ","Did the sales expert do enough to create an urgency for the deal or try to convince them?","Did the sales expert do enough to create an urgency for the deal or try to convince them?","Did the Sales Expert Handle Objections and rebuttals on calls?","Did the Sales Expert Handle Objections and rebuttals on calls?","Did the Sales Expert use correct disposition on call?","Did the Sales Expert use correct disposition on call?","Was the call free from noise at SE's side?","Was the call free from noise at SE's side?","Did the Sales Expert modulate the rate of speech and tone when talking to the lead?","Did the Sales Expert modulate the rate of speech and tone when talking to the lead?","Was the Sales Expert able to build rapport with the lead?","Was the Sales Expert able to build rapport with the lead?","Did the sales expert write additional notes for future reference ?","Did the sales expert write additional notes for future reference ?","Did the SE use jargons and slangs during the call?","Did the SE use jargons and slangs during the call?","Did the agent actively listen to the customer without interruption?	","Did the agent actively listen to the customer without interruption?	","Did the Sales Expert discuss the purpose of the call with the lead?","Did the Sales Expert discuss the purpose of the call with the lead?","Did the Sales Expert Greet the lead with good energy?","Did the Sales Expert Greet the lead with good energy?","Did the sales expert use correct language in conversation?","Did the sales expert use correct language in conversation?","Did the SE make the call without dead air, fumbling or using filler words?	","Did the SE make the call without dead air, fumbling or using filler words?	","Was the Sales Expert empathetic towards the lead during the call?","Was the Sales Expert empathetic towards the lead during the call?","Did the agent follow the proper closing verbiage? (Thanked the customer for the time)","Did the agent follow the proper closing verbiage? (Thanked the customer for the time)","Did the sales expert close the discussion with a summarization?","Did the sales expert close the discussion with a summarization?",
		 "Audit Start date and  Time ", "Audit End Date and  Time"," Call Interval",  "Call Summary ","Agent Feedback Status ", "Feedback Acceptance","Agent Review Date","Agent Review Note","Management Review Date ", "Management Review Name ","Management Review Note", "Client Review Name","Client Review Note","Client Review Date " );

		
		$row = "";
		foreach($header as $data) $row .= ''.$data.',';
		fwrite($fopen,rtrim($row,",")."\r\n");
		$searches = array("\r", "\n", "\r\n");

	

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
				$row .= '"'.$user['audit_type'].'",';
				$row .= '"'.$user['auditor_type'].'",';
				
				
				$row .= '"'.$user['earned_score'].'",';
				$row .= '"'.$user['possible_score'].'",';
				//$row .= '"'.$user['overall_score'].'",';
				$row .= '"'.$user['overall_score'].'"% ,';
                $row .= '"'.$user['auditor_type'].'",';
				$row .= '"'.$user['voc'].'",';
				$row .= '"'.$user['mandatory_part'].'",';
//$row .= '"'.$user['mandatory_part_reason'].'",';
$row .= '"'.$user['mandatory_part_observation'].'",';
$row .= '"'.$user['record_correct'].'",';
//$row .= '"'.$user['record_correct_reason'].'",';
$row .= '"'.$user['record_correct_observation'].'",';
$row .= '"'.$user['abusive_words'].'",';
			//$row .= '"'.$user['abusive_words_reason'].'",';
$row .= '"'.$user['abusive_words_observation'].'",';
$row .= '"'.$user['pronounce_brand'].'",';
//$row .= '"'.$user['pronounce_brand_reason'].'",';
$row .= '"'.$user['pronounce_brand_observation'].'",';
$row .= '"'.$user['price_product_scheme'].'",';
//$row .= '"'.$user['price_product_scheme_reason'].'",';
							$row .= '"'.$user['price_product_scheme_observation'].'",';
$row .= '"'.$user['probe_guideline'].'",';
//$row .= '"'.$user['probe_guideline_reason'].'",';
$row .= '"'.$user['probe_guideline_observation'].'",';
$row .= '"'.$user['misselling_misleading'].'",';
//$row .= '"'.$user['misselling_misleading_reason'].'",';
$row .= '"'.$user['misselling_misleading_observation'].'",';
			$row .= '"'.$user['product_benefits_solution'].'",';
//$row .= '"'.$user['product_benefits_solution_reason'].'",';
$row .= '"'.$user['product_benefits_solution_observation'].'",';
$row .= '"'.$user['convince'].'",';
//$row .= '"'.$user['convince_reason'].'",';
$row .= '"'.$user['convince_observation'].'",';
$row .= '"'.$user['objections_rebuttal'].'",';				
							//$row .= '"'.$user['objections_rebuttal_reason'].'",';
$row .= '"'.$user['objections_rebuttal_observation'].'",';
$row .= '"'.$user['correct_disposition'].'",';
//$row .= '"'.$user['correct_disposition_reason'].'",';
$row .= '"'.$user['correct_disposition_observation'].'",';
$row .= '"'.$user['noise'].'",';
//$row .= '"'.$user['noise_reason'].'",';

$row .= '"'.$user['noise_observation'].'",';
			$row .= '"'.$user['rate_speech'].'",';
//$row .= '"'.$user['rate_speech_reason'].'",';
$row .= '"'.$user['rate_speech_observation'].'",';
$row .= '"'.$user['build_rapport'].'",';
//$row .= '"'.$user['build_rapport_reason'].'",';
$row .= '"'.$user['build_rapport_observation'].'",';
$row .= '"'.$user['additional_notes'].'",';
							//$row .= '"'.$user['additional_notes_reason'].'",';
$row .= '"'.$user['additional_notes_observation'].'",';
$row .= '"'.$user['jargons_slangs'].'",';
//$row .= '"'.$user['jargons_slangs_reason'].'",';
$row .= '"'.$user['jargons_slangs_observation'].'",';
$row .= '"'.$user['interruption'].'",';
//$row .= '"'.$user['interruption_reason'].'",';
			$row .= '"'.$user['interruption_observation'].'",';
$row .= '"'.$user['purpose'].'",';
//$row .= '"'.$user['purpose_reason'].'",';
$row .= '"'.$user['purpose_observation'].'",';
$row .= '"'.$user['Greet'].'",';
//$row .= '"'.$user['Greet_reason'].'",';
$row .= '"'.$user['Greet_observation'].'",';				
							$row .= '"'.$user['correct_language'].'",';
//$row .= '"'.$user['correct_language_reason'].'",';
$row .= '"'.$user['correct_language_observation'].'",';
$row .= '"'.$user['dead_air'].'",';
//$row .= '"'.$user['dead_air_reason'].'",';
$row .= '"'.$user['dead_air_observation'].'",';
$row .= '"'.$user['empathetic'].'",';
//$row .= '"'.$user['empathetic_reason'].'",';
$row .= '"'.$user['empathetic_observation'].'",';
$row .= '"'.$user['verbiage'].'",';
//$row .= '"'.$user['verbiage_reason'].'",';
$row .= '"'.$user['verbiage_observation'].'",';
$row .= '"'.$user['summarization'].'",';
//$row .= '"'.$user['summarization_reason'].'",';
$row .= '"'.$user['summarization_observation'].'",';



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
				
				
				
				
				$row .= '"'.$user['client_rvw_name'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['client_rvw_note'])).'"';

				$row .= '"'.$user['client_rvw_date'].'",';

		


				fwrite($fopen,$row."\r\n");
			}
			fclose($fopen);

}else if($campaign=='squad_stack_feedback'){
	///////////////////////////
$header = array("Auditor Name", "Audit Date ", "Agent Name ", "Employee ID ", "L1 Supervisor ", "Call Date/Time ", "Audit Type ", "Type of Auditor ", "Earned Score ", "Possible Score ", "Overall Score % ", "Auditor Type", "VOC","Call Id","Auditor's BP Id","KPI - ACPT", 
	"Did the Sales Expert use correct disposition on call?","Remarks",
	"Was the call free from noise at SE's side?","Remarks",
	"Did the Sales Expert modulate the rate of speech and tone when talking to the lead?","Remarks",
	"Was the Sales Expert able to build rapport with the lead?","Remarks",
	"Did the sales expert write additional notes for future reference?","Remarks",
	"Did sales expert follow the mandatory part of scripts?","Remarks",
	"Did the SE write/record correct answers to the questions provided?","Remarks",
	"Did the Sales Expert conduct the call without using abusive words or heated words?","Remarks",
	"Did the SE do correct brand pronunciation?","Remarks",
	"Was correct information provided by SE on Price Product & scheme?","Remarks",
	"Was the sales expert able to probe the lead? (Define Probe and Guidelines)","Remarks",
	"Did the agent give accurate information to the lead on the call? (Without Misselling/misleading)","Remarks",
	"Did the sales expert explain all the product's benefits and solutions to the lead?","Remarks",
	"Did the sales expert do enough to create an urgency for the deal or try to convince them?","Remarks",
	"Did the Sales Expert Handle Objections and rebuttals on calls?","Remarks",
	"Did the SE use jargons and slangs during the call?","Remarks",
	"Did the agent actively listen to the customer without interruption?","Remarks",
	"Did the Sales Expert discuss the purpose of the call with the lead?","Remarks",
	"Did the Sales Expert Greet the lead with good energy?","Remarks",
	"Did the sales expert use correct language in conversation?","Remarks",
	"Did the SE make the call without dead air fumbling or using filler words?","Remarks",
	"Was the Sales Expert empathetic towards the lead during the call?","Remarks",
	"Did the agent follow the proper closing verbiage? (Thanked the customer for the time)","Remarks",
	"Did the sales expert close the discussion with a summarization?","Remarks",

	"Audit Start date and  Time ", "Audit End Date and  Time"," Call Interval",  "Call Summary ","Agent Feedback Status ", "Feedback Acceptance","Agent Review Date","Agent Review Note","Management Review Date ", "Management Review Name ","Management Review Note", "Client Review Name","Client Review Note","Client Review Date " );

		
		$row = "";
		foreach($header as $data) $row .= ''.$data.',';
		fwrite($fopen,rtrim($row,",")."\r\n");
		$searches = array("\r", "\n", "\r\n");

	

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
				$row .= '"'.$user['audit_type'].'",';
				$row .= '"'.$user['auditor_type'].'",';
				$row .= '"'.$user['earned_score'].'",';
				$row .= '"'.$user['possible_score'].'",';
				$row .= '"'.$user['overall_score'].'"% ,';
        $row .= '"'.$user['auditor_type'].'",';
				$row .= '"'.$user['voc'].'",';
				$row .= '"'.$user['call_id'].'",';
				$row .= '"'.$user['bp_id'].'",';
				$row .= '"'.$user['kpi_acpt'].'",';
				$row .= '"'.$user['correct_disposition'].'",';
				$row .= '"'.$user['cmt1'].'",';
				$row .= '"'.$user['call_noise_free'].'",';
				$row .= '"'.$user['cmt2'].'",';
				$row .= '"'.$user['rate_of_speech'].'",';
				$row .= '"'.$user['cmt3'].'",';
				$row .= '"'.$user['build_rapport'].'",';
				$row .= '"'.$user['cmt4'].'",';
				$row .= '"'.$user['additional_notes'].'",';
				$row .= '"'.$user['cmt5'].'",';
				$row .= '"'.$user['mandatory_part_of_scripts'].'",';
				$row .= '"'.$user['cmt6'].'",';
				$row .= '"'.$user['record_correct_answers'].'",';
				$row .= '"'.$user['cmt7'].'",';
				$row .= '"'.$user['conduct_call_without_abusive'].'",';
				$row .= '"'.$user['cmt8'].'",';
				$row .= '"'.$user['correct_brand_pronunciation'].'",';
				$row .= '"'.$user['cmt9'].'",';	
				$row .= '"'.$user['correct_information_by_SE'].'",';	
				$row .= '"'.$user['cmt10'].'",';	
				$row .= '"'.$user['probe_lead'].'",';						
				$row .= '"'.$user['cmt11'].'",';	
				$row .= '"'.$user['accurate_information'].'",';	
				$row .= '"'.$user['cmt12'].'",';	
				$row .= '"'.$user['products_benefits'].'",';	
				$row .= '"'.$user['cmt13'].'",';	
				$row .= '"'.$user['urgency_for_deal'].'",';	
				$row .= '"'.$user['cmt14'].'",';	
				$row .= '"'.$user['handle_objections'].'",';	
				$row .= '"'.$user['cmt15'].'",';	
				$row .= '"'.$user['use_jargons'].'",';	
				$row .= '"'.$user['cmt16'].'",';	
				$row .= '"'.$user['active_listening'].'",';	
				$row .= '"'.$user['cmt17'].'",';	
				$row .= '"'.$user['purpose_of_call'].'",';	
				$row .= '"'.$user['cmt18'].'",';	
				$row .= '"'.$user['greet_lead'].'",';	
				$row .= '"'.$user['cmt19'].'",';	
				$row .= '"'.$user['correct_language'].'",';	
				$row .= '"'.$user['cmt20'].'",';	
				$row .= '"'.$user['dead_air'].'",';	
				$row .= '"'.$user['cmt21'].'",';	
				$row .= '"'.$user['empathetic_towards_lead'].'",';	
				$row .= '"'.$user['cmt22'].'",';	
				$row .= '"'.$user['proper_closing'].'",';	
				$row .= '"'.$user['cmt23'].'",';	
				$row .= '"'.$user['summarization'].'",';	
				$row .= '"'.$user['cmt24'].'",';	
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
				
				
				
				
				$row .= '"'.$user['client_rvw_name'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['client_rvw_note'])).'"';

				$row .= '"'.$user['client_rvw_date'].'",';

		


				fwrite($fopen,$row."\r\n");
			}
			fclose($fopen);



	//////////////////////////

}



	
	}
	
}
