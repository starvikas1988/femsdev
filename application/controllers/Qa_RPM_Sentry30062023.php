<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Qa_RPM_Sentry extends CI_Controller {

    public function __construct(){
		parent::__construct();
		$this->load->model('user_model');
		$this->load->model('Common_model');
		$this->load->model('Qa_RPM_Sentry_model');
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
    
    private function sentry_upload_files($files,$path) // this is for file uploaging purpose
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

    public function getTLname(){
		if(check_logged_in()){
			$aid=$this->input->post('aid');
            $qSql = "Select s.id, s.assigned_to,  CONCAT(s1.fname,' ' ,s1.lname) as tl_name, 
            s.fusion_id, get_process_names(s.id) as process_name FROM signin s 
            left join signin s1 on s1.id = s.assigned_to where s.id ='$aid'";
			echo json_encode($this->Common_model->get_query_result_array($qSql));
		}
	}
	 

    public function index()
	{
		if(check_logged_in()){
            redirect('/Qa_RPM_Sentry/rpm', 'refresh');
        }
    }

	public function rpm()
	{
		if(check_logged_in())
		{
			$current_user = get_user_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_rpm_sentry/qa_rpm.php"; 
			
			$from_date = $this->input->get('from_date');
			$to_date = 	$this->input->get('to_date');
			$agent = $this->input->get('agent');
			
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
						
			$data["from_date"] 	= $from_date;
            $data["to_date"] 	= $to_date;
            $data["agent"] 	= $agent;
            
			$rpm_data =	$this->Qa_RPM_Sentry_model->get_rpm_data($from_date,$to_date,$agent,$current_user);
			$data['rpm_data'] =	$rpm_data;
			$data["agent_list"] = $this->Qa_RPM_Sentry_model->get_agent_id(56,68);
			$this->load->view('dashboard',$data);
		}
    }

    public function add_rpm_form(){
        if(check_logged_in())
		{
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_rpm_sentry/add_rpm_form.php"; 
			
            $current_user=get_user_id();
			$user_office_id=get_user_office_id();
			$qSql="select concat(fname, ' ', lname) as value from signin where id='$current_user'";
            $data['curr_user'] = $this->Common_model->get_single_value($qSql);
            
            $qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
            $data["agentName"] = $this->Qa_RPM_Sentry_model->get_agent_id(56,68);
			
			/******** Randamiser Start***********/
			
			
			$rand_id=0;
			if(!empty($this->uri->segment(3))){
				$rand_id=$this->uri->segment(3);
			}
			$data['rand_id']=$rand_id;
			$data["rand_data"] = "";
			
			
			
			if($rand_id!=0){
				$client_id=56;
				$pro_id = 68;
				$curDateTime=CurrMySqlDate();
				$upArr = array('distribution_opend_by' =>$current_user,'distribution_opened_datetime'=>$curDateTime);
				$this->db->where('id', $rand_id);
				$this->db->update('qa_randamiser_rpm_data',$upArr);
				
				$randSql="Select srd.*,srd.aht as call_duration, S.id as sid, S.fname, S.lname, S.xpoid, S.assigned_to,get_process_names(S.id) as process_name,
				(select concat(fname, ' ', lname) as name from signin s1 where s1.id=S.assigned_to) as tl_name,DATEDIFF(CURDATE(), S.doj) as tenure
				from qa_randamiser_rpm_data srd Left Join signin S On srd.fusion_id=S.fusion_id where srd.audit_status=0 and srd.id='$rand_id'";
				$data["rand_data"] = $rand_data =  $this->Common_model->get_query_row_array($randSql);
				
			}
			//print_r($data["rand_data"]);
			/******** Randamiser Ends**********/
			
			$curDateTime=CurrMySqlDate();
			
            if($this->input->post('save_button')=='save'){
                $_field_array = array(
                    "auditor_name" => $this->input->post('auditor_name'),
					"audit_date" => CurrDate(),
					"agent_id" => $this->input->post('agent_id'),
					"caller_title" => $this->input->post('caller_title'),
					"caller_name" => $this->input->post('caller_name'),
					"caller_phone" => $this->input->post('caller_phone'),
					"audit_type" => $this->input->post('audit_type'),
					"auditor_type" => $this->input->post('auditor_type'),
					"voc" => $this->input->post('voc'),
					"call_type" => $this->input->post('call_type'),
					"disposition_type" => $this->input->post('disposition_type'),
					"overall_score" => $this->input->post('total_score'),
					//"total_score_count" => $this->input->post('total_score_count'),
					"customer_information" => $this->input->post('customer_information'),
					"voice_delivery" => $this->input->post('voice_delivery'),
					"communication_skills" => $this->input->post('communication_skills'),
					"customer_service" => $this->input->post('customer_service'),
					"disposition" => $this->input->post('disposition'),
					"transfer" => $this->input->post('transfer'),
					"protocol" => $this->input->post('protocol'),
					"call_summary" => $this->input->post('call_summary'),
					"feedback" => $this->input->post('feedback'),
					"entry_by" => $current_user,
					"entry_date" => $curDateTime
                );
				
                $rowid = data_inserter('qa_rpm', $_field_array);
				if($rand_id!=0){					
					$rand_cdr_array = array("audit_status" => 1);
					$this->db->where('id', $rand_id);
					$this->db->update('qa_randamiser_rpm_data',$rand_cdr_array);
					
					$rand_array = array("is_rand" => 1);
					$this->db->where('id', $rowid);
					$this->db->update('qa_rpm',$rand_array);
					}
				if(isset($rand_data['upload_date']) && !empty($rand_data['upload_date'])){
					$up_date = date('Y-m-d', strtotime($rand_data['upload_date']));
					redirect('Qa_randamiser/data_distribute_freshdesk?from_date='.$up_date.'&client_id='.$client_id.'&pro_id='.$pro_id.'&submit=Submit');
				}else{
					redirect(base_url().'Qa_RPM_Sentry/rpm/','refresh');
				}
				//redirect(base_url().'Qa_RPM_Sentry/rpm/','refresh');
            }
            $this->load->view('dashboard',$data);
        }
    }
    
	public function edit_rpm()
	{
		if(check_logged_in())
		{
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_rpm_sentry/edit_rpm_form_rvw.php"; 
			
            $current_user=get_user_id();
			$user_office_id=get_user_office_id();
			$rpmId	=	$this->uri->segment(3);
			$curDateTime=CurrMySqlDate();
			
			$qSql="select concat(fname, ' ', lname) as value from signin where id='$current_user'";
            $data['curr_user'] = $this->Common_model->get_single_value($qSql);
            
            $qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
            $data["agentName"] = $this->Qa_RPM_Sentry_model->get_agent_id(56,68);
			$rpmSQL = "SELECT * FROM qa_rpm WHERE id='$rpmId'";
			$data["rpm_detail"] = $this->Common_model->get_query_result_array($rpmSQL);
			$data["row1"] = $this->Qa_RPM_Sentry_model->view_rpm_agent_rvw($rpmId);//AGENT PURPOSE
			$data["row2"] = $this->Qa_RPM_Sentry_model->view_rpm_mgnt_rvw($rpmId);//MGNT PURPOSE
			
            if($this->input->post('update_button')=='update'){
                $_field_array = array(
                    "auditor_name" => $this->input->post('auditor_name'),
					//"audit_time" => $this->input->post('audit_time'),
					"agent_id" => $this->input->post('agent_id'),
					"caller_title" => $this->input->post('caller_title'),
					"caller_name" => $this->input->post('caller_name'),
					"caller_phone" => $this->input->post('caller_phone'),
					"audit_type" => $this->input->post('audit_type'),
					"auditor_type" => $this->input->post('auditor_type'),
					"voc" => $this->input->post('voc'),
					"call_type" => $this->input->post('call_type'),
					"disposition_type" => $this->input->post('disposition_type'),
					"overall_score" => $this->input->post('total_score'),
					"total_score_count" => $this->input->post('total_score_count'),
					"customer_information" => $this->input->post('customer_information'),
					"voice_delivery" => $this->input->post('voice_delivery'),
					"communication_skills" => $this->input->post('communication_skills'),
					"customer_service" => $this->input->post('customer_service'),
					"disposition" => $this->input->post('disposition'),
					"transfer" => $this->input->post('transfer'),
					"protocol" => $this->input->post('protocol'),
					"call_summary" => $this->input->post('call_summary'),
					"feedback" => $this->input->post('feedback')
                );
				$this->db->update('qa_rpm', $_field_array, array('id' => $rpmId));
				////////////	
				$field_array1=array(
					"fd_id" => $rpmId,
					"note" => $this->input->post('note'),
					"entry_by" => $current_user,
					"entry_date" => $curDateTime
				);
				
				if($this->input->post('action')==''){
					$rowid= data_inserter('qa_rpm_mgnt_rvw',$field_array1);
				}else{
					$this->db->where('fd_id', $rpmId);
					$this->db->update('qa_rpm_mgnt_rvw',$field_array1);
				}
				///////////	
				redirect(base_url().'Qa_RPM_Sentry/rpm/','refresh');
            }
            $this->load->view('dashboard',$data);
        }
	}
	
	public function rpm_dashboard()
	{
		if(check_logged_in())
		{
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_rpm_sentry/rpm_dashboard.php"; 
			$from_date = $this->input->get('from_date');
			$to_date = $this->input->get('to_date');
			$agent = $this->input->get('agent');
			
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
						
			$data["from_date"] = $from_date;
            $data["to_date"] = $to_date;
			$data['agent'] = $agent;
			$data["agent_list"] = $this->Qa_RPM_Sentry_model->get_agent_id(56,68);
			if($this->input->get('agent'))
			{
				$rpm_data =	$this->Qa_RPM_Sentry_model->get_rpm_data($from_date,$to_date,$agent);
				$data['rpm_data'] = $rpm_data;
			}
			else
			{
				$data['rpm_data'] = array();
			}
			$this->load->view('dashboard',$data);
		}
	}
	
    public function sentry()
	{
		if(check_logged_in())
		{
			$current_user = get_user_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_rpm_sentry/sentry.php"; 
			$data["content_js"] = "qa_sentry_js.php";
			$from_date = $this->input->get('from_date');
			$to_date = 	$this->input->get('to_date');
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
			$agent = $this->input->get('agent');	
			$agent_id = $agent;		
			$data["from_date"] 	= $from_date;
            $data["to_date"] 	= $to_date;
			$data["agent"] 	= $agent;
			$sentry_data =	$this->Qa_RPM_Sentry_model->get_sentry_data($from_date,$to_date,$agent,$current_user);
			$data['sentry_data'] =	$sentry_data;
			$data["agent_list"] = $this->Qa_RPM_Sentry_model->get_agent_id(55,174);

			///vikas starts/////
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
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_name from qa_sentry_credit_feedback $cond) xx Left Join
				(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";
			$data["sentry_credit_data"] = $this->Common_model->get_query_result_array($qSql);
			///vikas ends/////
			
			$this->load->view('dashboard',$data);
		}
	}

	//////////////////////vikas starts//////////////////////////////////

	public function add_edit_sentry_credit($sentry_credit_id){
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();

			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_rpm_sentry/add_edit_sentry_credit.php";
			$data["content_js"] = "qa_sentry_js.php";
			$data['sentry_credit_id']=$sentry_credit_id;
			$tl_mgnt_cond='';

			if(get_role_dir()=='manager' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";
			}else if(get_role_dir()=='tl' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and assigned_to='$current_user'";
			}else{
				$tl_mgnt_cond="";
			}


			$qSql = "SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,55) and is_assign_process(id,174) and status=1  order by name";
	          $data['agentName'] = $this->Common_model->get_query_result_array( $qSql );

			$qSql = "SELECT id, fname, lname, fusion_id, office_id FROM signin where role_id in (select id from role where (folder in ('tl','trainer','am','manager')) or (name in ('Client Services'))) and status=1";

			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);

			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
				from qa_sentry_credit_feedback where id='$sentry_credit_id') xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
			$data["sentry_credit_data"] = $this->Common_model->get_query_row_array($qSql);

			$curDateTime=CurrMySqlDate();
			$a = array();

			$field_array['agent_id']=!empty($_POST['data']['agent_id'])?$_POST['data']['agent_id']:"";

			if($field_array['agent_id']){

				if($sentry_credit_id==0){
					$field_array=$this->input->post('data');
					$field_array['audit_date']=CurrDate();
					$field_array['call_date']=mmddyy2mysql($this->input->post('call_date'));
					$field_array['entry_date']=$curDateTime;
					$field_array['audit_start_time']=$this->input->post('audit_start_time');
					
					if($_FILES['attach_file']['tmp_name'][0]!=''){
						$a = $this->sentry_upload_files($_FILES['attach_file'], $path='./qa_files/qa_sentry/');
						$field_array["attach_file"] = implode(',',$a);
					}

					$rowid= data_inserter('qa_sentry_credit_feedback',$field_array);
					if(get_login_type()=="client"){
						$add_array = array("client_entryby" => $current_user);
					}else{
						$add_array = array("entry_by" => $current_user);
					}
					$this->db->where('id', $rowid);
					$this->db->update('qa_sentry_credit_feedback',$add_array);

				}else{

					$field_array1=$this->input->post('data');
					$field_array1['call_date']=mmddyy2mysql($this->input->post('call_date'));
					if($_FILES['attach_file']['tmp_name'][0]!=''){
						if(!file_exists("./qa_files/qa_sentry/")){
							mkdir("./qa_files/qa_sentry/");
						}
						$a = $this->sentry_upload_files( $_FILES['attach_file'], $path = './qa_files/qa_sentry/' );
						$field_array1['attach_file'] = implode( ',', $a );
					}

					$this->db->where('id', $sentry_credit_id);
					$this->db->update('qa_sentry_credit_feedback',$field_array1);
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
					$this->db->where('id', $sentry_credit_id);
					$this->db->update('qa_sentry_credit_feedback',$edit_array);

				}

				redirect('Qa_RPM_Sentry/sentry');
				//$this->load->view('dashboard',$data);
			}
			$data["array"] = $a;

			$this->load->view("dashboard",$data);
		}
	}

	public function qa_sentry_credit_report(){
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
			$data["content_template"] = "qa_rpm_sentry/qa_sentry_credit_report.php";
			$data["content_js"] = "qa_sentry_js.php";

			$date_from="";
			$date_to="";
			$action="";
			$dn_link="";
			$cond="";
			$cond1="";
			$cond2="";
			$audit_type="";

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

			$data["qa_sentry_list"] = array();
			//if($this->input->get('show')=='Show') {
			   // $campaign = $this->input->get('campaign');
				
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
					(select concat(fname, ' ', lname) as name from signin_client scx where scx.id=client_rvw_by) as client_rvw_name from qa_sentry_credit_feedback) xx Left Join
					(Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_ids(id) as process_id, get_process_names(id) as process, doj, DATEDIFF(CURDATE(), doj) as tenure from signin) yy on (xx.agent_id=yy.sid) $cond $cond1 $cond2 order by audit_date";

					$fullAray = $this->Common_model->get_query_result_array($qSql);
					$data["qa_sentry_list"] = $fullAray;
			 

				$this->create_qa_sentry_credit_CSV($fullAray);

				$dn_link = base_url()."Qa_RPM_Sentry/download_qa_sentry_credit_CSV";


			//}
			$data['location_list'] = $this->Common_model->get_office_location_list();

			$data['download_link']=$dn_link;
			$data["action"] = $action;
			$data['from_date'] = $date_from;
			$data['to_date'] = $date_to;
			$data['office_id']=$office_id;
			$data['audit_type']=$audit_type;

			$this->load->view('dashboard',$data);
		}
	}

   ////////////Norther ///////////////////////////////
	public function download_qa_sentry_credit_CSV()
	{
		$currDate=date("Y-m-d");
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$newfile="Sentry Credit Audit List-'".$currDate."'.csv";

		header('Content-Disposition: attachment;  filename="'.$newfile.'"');
		readfile($filename);
	}

	public function create_qa_sentry_credit_CSV($rr)
	{

		$filename = "./assets/reports/Report".get_user_id().".csv";
		$fopen = fopen($filename,"w+");
	
		 $header = array("Auditor Name", "Audit Date", "Employee ID", "Agent Name", "L1 Supervisor", "ACPT","Site/Location", "Call Date", "Call Duration", "Audit Type", "Auditor Type", "VOC","Collector","Agent Tenurity","SCI","Client","VT ID","Possible Score", "Earned Score", "Overall Score",

		 	"Did the collector begin with the exact call recording disclosure?",
		 	"Did the collector begin with the exact call recording disclosure? - Remarks",

		 	"Did collector verify they are speaking to the debtor or authorized party prior to collecting a debt? (DOB/SSN/ADDY/EMAIL)",
		 	"Did collector verify they are speaking to the debtor or authorized party prior to collecting a debt? (DOB/SSN/ADDY/EMAIL) - Remarks",
		 	"Email Requested/Confirmed?","Email Requested/Confirmed? - Remarks",
		 	"Did collector Identify themselves by name prior to attempting to collect a debt?",
		 	"Did collector Identify themselves by name prior to attempting to collect a debt? - Remarks",

		 	"Did collector Identify collection agency by name prior to attempting to collect a debt?",
		 	"Did collector Identify collection agency by name prior to attempting to collect a debt? - Remarks",

		 	"Did collector give Mini Miranda prior to attempting to collect the debt (this should happen at the beginning of call after debtor confirms he/she is a right party and prior to collector concluding the opening of call and debtor speaking)?",
		 	"Did collector give Mini Miranda prior to attempting to collect the debt (this should happen at the beginning of call after debtor confirms he/she is a right party and prior to collector concluding the opening of call and debtor speaking)? - Remarks",

		 	"Did collector identify the original creditor current creditor client merchant or credit card type if not identified by the consumer? Was balance disclosed on the call?",
		 	"Did collector identify the original creditor current creditor client merchant or credit card type if not identified by the consumer? Was balance disclosed on the call? - Remarks",

		 	"Did the collector avoid communicating any false deceptive or misleading information? (UDAAP)",
		 	"Did the collector avoid communicating any false deceptive or misleading information? (UDAAP) - Remarks",

		 	"Did the collector avoid abusive rude or unprofessional behavior? (UDAAP)",
		 	"Did the collector avoid abusive rude or unprofessional behavior? (UDAAP) - Remarks",

		 	"Did collector obtain reason for delinquency?",
		 	"Did collector obtain reason for delinquency? - Remarks",

		 	"Did collector follow negotiation hierarchy?",
		 	"Did collector follow negotiation hierarchy? - Remarks",

		 	"Did the collector properly handle any dispute or complaint? (FDCPA)",
		 	"Did the collector properly handle any dispute or complaint? (FDCPA) - Remarks",

		 	"Did collector offer appropriate resolutions based on information available?",
		 	"Did collector offer appropriate resolutions based on information available? - Remarks",

		 	"For accounts that resulted in a payment did collector follow the appropriate script for the payment type with the required disclosures for Debit Card Credit Cards Check by Phone and Post Dates?",
		 	"For accounts that resulted in a payment did collector follow the appropriate script for the payment type with the required disclosures for Debit Card Credit Cards Check by Phone and Post Dates? - Remarks",

		 	"For accounts that resulted in a payment did the collector ask for the name as it appears on the card or checking account and ask for the billing or account address for the account?",
		 	"For accounts that resulted in a payment did the collector ask for the name as it appears on the card or checking account and ask for the billing or account address for the account? - Remarks",

		 	"If agency system notes have been reviewed did collector correctly and accurately update the system notes?",
		 	"If agency system notes have been reviewed did collector correctly and accurately update the system notes? - Remarks",

		 	"Did the collector properly complete any promise tab required?",
		 	"Did the collector properly complete any promise tab required? - Remarks",

		 	"Did the collector properly handle the account based on the specific compliance popup screen (OOS disclosures spouse communication requirements REG F etc)?",
		 	"Did the collector properly handle the account based on the specific compliance popup screen (OOS disclosures spouse communication requirements REG F etc)? - Remarks",

		 	"Did the collector complete all necessary file upkeep work (update mailing address update bankruptcy tab etc)?",
		 	"Did the collector complete all necessary file upkeep work (update mailing address update bankruptcy tab etc)? - Remarks",

    "Call Summary/Observation","Audit Start date and  Time ", "Audit End Date and  Time","Interval (in sec)",  "Feedback","Agent Feedback Acceptance", "Agent Review Date/Time", "Agent Comment", "Mgnt Review Date/Time","Mgnt Review By", "Mgnt Comment","Client Review Name","Client Review Note","Client Review Date and Time");
		

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
				$row .= '"'.$user['site'].'",';
				$row .= '"'.$user['call_date'].'",';
				$row .= '"'.$user['call_duration'].'",';
				$row .= '"'.$user['audit_type'].'",';
				$row .= '"'.$user['auditor_type'].'",';
				$row .= '"'.$user['voc'].'",';
				$row .= '"'.$user['collector'].'",';
				$row .= '"'.$user['tenurity'].'",';
				$row .= '"'.$user['sci'].'",';
				$row .= '"'.$user['client'].'",';
				$row .= '"'.$user['call_id'].'",';
				$row .= '"'.$user['possible_score'].'",';
				$row .= '"'.$user['earned_score'].'",';
				$row .= '"'.$user['overall_score'].'",';
				$row .= '"'.$user['begin_call_recording'].'",';
				$row .= '"'.$user['cmt1'].'",';
				$row .= '"'.$user['verify_speacking'].'",';
				$row .= '"'.$user['cmt2'].'",';
				$row .= '"'.$user['email_requested'].'",';
				$row .= '"'.$user['cmt3'].'",';
				$row .= '"'.$user['identify_themselves'].'",';
				$row .= '"'.$user['cmt4'].'",';
				$row .= '"'.$user['identify_collection_agency'].'",';
				$row .= '"'.$user['cmt5'].'",';
				$row .= '"'.$user['give_Mini_Miranda'].'",';
				$row .= '"'.$user['cmt6'].'",';
				$row .= '"'.$user['identify_original_creditor'].'",';
				$row .= '"'.$user['cmt7'].'",';
				$row .= '"'.$user['avoid_communicating_false'].'",';
				$row .= '"'.$user['cmt8'].'",';
				$row .= '"'.$user['avoid_unprofessional_behavior'].'",';
				$row .= '"'.$user['cmt9'].'",';
				$row .= '"'.$user['reason_for_delinquency'].'",';
				$row .= '"'.$user['cmt10'].'",';
				$row .= '"'.$user['follow_negotiation_hierarchy'].'",';
				$row .= '"'.$user['cmt11'].'",';
				$row .= '"'.$user['handle_dispute'].'",';
				$row .= '"'.$user['cmt12'].'",';
				$row .= '"'.$user['offer_appropriate_resolutions'].'",';
				$row .= '"'.$user['cmt13'].'",';
				$row .= '"'.$user['follow_appropriate_script'].'",';
				$row .= '"'.$user['cmt14'].'",';
				$row .= '"'.$user['checking_account'].'",';
				$row .= '"'.$user['cmt15'].'",';
				$row .= '"'.$user['update_system_notes'].'",';
				$row .= '"'.$user['cmt16'].'",';
				$row .= '"'.$user['complete_promise_tab'].'",';
				$row .= '"'.$user['cmt17'].'",';
				$row .= '"'.$user['OOS_disclosures'].'",';
				$row .= '"'.$user['cmt18'].'",';
				$row .= '"'.$user['complete_file_upkeep_work'].'",';
				$row .= '"'.$user['cmt19'].'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['call_summary'])).'",';
				$row .= '"'.$user['audit_start_time'].'",';
	            $row .= '"'.$user['entry_date'].'",';
	            $row .= '"'.$interval1.'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['feedback'])).'",';
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
	}

	/////////////////////vikas ends////////////////////////////////////
	
	public function add_sentry()
	{
		if(check_logged_in())
		{
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_rpm_sentry/add_sentry_form.php"; 

            $current_user=get_user_id();
			$user_office_id=get_user_office_id();
			$curDateTime=CurrMySqlDate();
			
			$qSql="select concat(fname, ' ', lname) as value from signin where id='$current_user'";
            $data['curr_user'] = $this->Common_model->get_single_value($qSql);
            
            $qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
			$data["agentName"] = $this->Qa_RPM_Sentry_model->get_agent_id(55,174);
			if($this->input->post('save_button')=='save'){
				$caller_date = $this->input->post('caller_date');
				if($this->input->post('audit_result') == "YES"){
					$audit_result = 1;
				}
				else{
					$audit_result = 0;
				}
                $_field_array = array(
                    "auditor_name" => $this->input->post('auditor_name'),
					"audit_date" => CurrDate(),
					"audit_time" => $this->input->post('audit_time'),
					"agent_id" => $this->input->post('agent_id'),
					"caller_name" => $this->input->post('caller_name'),
					"caller_date" => mmddyy2mysql($this->input->post('caller_date')),
					"caller_phone" => $this->input->post('caller_phone'),
					"audit_type" => $this->input->post('audit_type'),
					"auditor_type" => $this->input->post('auditor_type'),
					"voc" => $this->input->post('voc'),
					"audit_result" => $audit_result,
					"overall_score" => number_format($this->input->post('total_score'),2),
					"total_score_count" => $this->input->post('total_score_count'),
					"verified_consumer" => $this->input->post('verified_consumer'),
					"advise_recording" => $this->input->post('advise_recording'),
					"professional" => $this->input->post('professional'),
					"speech" => $this->input->post('speech'),
					"objections" => $this->input->post('objections'),
					"fluidity" => $this->input->post('fluidity'),
					"experience" => $this->input->post('experience'),
					"call_summary" => $this->input->post('call_summary'),
					"feedback" => $this->input->post('feedback'),
					"entry_by" => $current_user,
					"entry_date" => $curDateTime
                );

                data_inserter('qa_sentry', $_field_array);
				redirect(base_url()."Qa_RPM_Sentry/sentry/","refresh");
            }
			$this->load->view('dashboard',$data);
		}
	}
	
	public function edit_sentry()
	{
		if(check_logged_in())
		{
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_rpm_sentry/edit_sentry_form_rvw.php"; 

            $current_user=get_user_id();
			$user_office_id=get_user_office_id();
			$sentryId	=	$this->uri->segment(3);
			$curDateTime=CurrMySqlDate();
			
			$qSql="select concat(fname, ' ', lname) as value from signin where id='$current_user'";
            $data['curr_user'] = $this->Common_model->get_single_value($qSql);
            
            $qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
			$data["agentName"] = $this->Qa_RPM_Sentry_model->get_agent_id(55,174);
			$sentrySQL = "SELECT * FROM qa_sentry WHERE id=$sentryId";
			$data['sentry_detail'] = $this->Common_model->get_query_result_array($sentrySQL);
			$data["row1"] = $this->Qa_RPM_Sentry_model->view_sentry_agent_rvw($sentryId);//AGENT PURPOSE
			$data["row2"] = $this->Qa_RPM_Sentry_model->view_sentry_mgnt_rvw($sentryId);//MGNT PURPOSE
			if($this->input->post('update_button')=='update'){
				$caller_date = $this->input->post('caller_date');
				if($this->input->post('audit_result') == "YES"){
					$audit_result = 1;
				}
				else{
					$audit_result = 0;
				}
                $_field_array = array(
                    "auditor_name" => $this->input->post('auditor_name'),
					"audit_time" => $this->input->post('audit_time'),
					"agent_id" => $this->input->post('agent_id'),
					"caller_name" => $this->input->post('caller_name'),
					"caller_date" => $this->input->post('caller_date'),
					"caller_phone" => $this->input->post('caller_phone'),
					"audit_type" => $this->input->post('audit_type'),
					"auditor_type" => $this->input->post('auditor_type'),
					"voc" => $this->input->post('voc'),
					"audit_result" => $audit_result,
					"overall_score" => number_format($this->input->post('total_score'),2),
					"total_score_count" => $this->input->post('total_score_count'),
					"verified_consumer" => $this->input->post('verified_consumer'),
					"advise_recording" => $this->input->post('advise_recording'),
					"professional" => $this->input->post('professional'),
					"speech" => $this->input->post('speech'),
					"objections" => $this->input->post('objections'),
					"fluidity" => $this->input->post('fluidity'),
					"experience" => $this->input->post('experience'),
					"call_summary" => $this->input->post('call_summary'),
					"feedback" => $this->input->post('feedback')
                );
				$this->db->update('qa_sentry', $_field_array, array('id' => $sentryId));
				////////////	
				$field_array1=array(
					"fd_id" => $sentryId,
					"note" => $this->input->post('note'),
					"entry_by" => $current_user,
					"entry_date" => $curDateTime
				);
				
				if($this->input->post('action')==''){
					$rowid= data_inserter('qa_sentry_mgnt_rvw',$field_array1);
				}else{
					$this->db->where('fd_id', $sentryId);
					$this->db->update('qa_sentry_mgnt_rvw',$field_array1);
				}
				///////////	
				redirect(base_url().'Qa_RPM_Sentry/sentry/','refresh');
			}
			$this->load->view('dashboard',$data);
		}
	}
	public function sentry_dashboard()
	{
		if(check_logged_in())
		{
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_rpm_sentry/sentry_dashboard.php"; 
			$from_date = $this->input->get('from_date');
			$to_date = $this->input->get('to_date');
			$agent = $this->input->get('agent');
			
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
						
			$data["from_date"] = $from_date;
            $data["to_date"] = $to_date;
			$data['agent'] = $agent;
			$data["agent_list"] = $this->Qa_RPM_Sentry_model->get_agent_id(55,174);
			if($this->input->get('agent'))
			{
				$sentry_data =	$this->Qa_RPM_Sentry_model->get_sentry_data($from_date,$to_date,$agent);
				$data['sentry_data'] = $sentry_data;
			}
			else
			{
				$data['sentry_data'] = array();
			}
			$this->load->view('dashboard',$data);
		}
	}
	/******************Agent Feedback********************/
	public function agent_rpm_feedback()
	{
		if(check_logged_in()){
			$user_site_id= get_user_site_id();
			$role_id= get_role_id();
			$current_user = get_user_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_rpm_sentry/agent_rpm_feedback.php";
			$data["agentUrl"] = "Qa_RPM_Sentry/agent_rpm_feedback";
			
			
			$qSql="Select count(id) as value from qa_rpm where agent_id='$current_user'";
			$data["tot_agent_feedback"] =  $this->Common_model->get_single_value($qSql);
			
			$qSql="Select count(id) as value from qa_rpm where id  not in (select fd_id from qa_rpm_agent_rvw ) and agent_id='$current_user'";
			$data["tot_agent_yet_rvw"] =  $this->Common_model->get_single_value($qSql);
				
			$from_date = '';
			$to_date = '';
			
			
			if($this->input->get('btnView')=='View')
			{
				$from_date = mmddyy2mysql($this->input->get('from_date'));
				$to_date = mmddyy2mysql($this->input->get('to_date'));
					
				$field_array = array(
					"from_date"=>$from_date,
					"to_date" => $to_date,
					"current_user" => $current_user
				);

				$data["agent_review_list"] = $this->Qa_RPM_Sentry_model->get_rpm_agent_review_data($field_array);
					
			 }else{	
				$data["agent_review_list"] = $this->Qa_RPM_Sentry_model->get_rpm_agent_not_review_data($current_user);			
			}
			
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			
			$this->load->view('dashboard',$data);
		}
	}
	public function agent_rpm_feedback_rvw($id)
	{
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_rpm_sentry/agent_rpm_feedback_rvw.php";
			$data["agentUrl"] = "Qa_RPM_Sentry/agent_rpm_feedback";
						
			$data["get_rpm_feedback"] = $this->Qa_RPM_Sentry_model->view_rpm_feedback($id);
			
			$data["rdid"]=$id;
			
			$data["row1"] = $this->Qa_RPM_Sentry_model->view_rpm_agent_rvw($id);//AGENT PURPOSE
			$data["row2"] = $this->Qa_RPM_Sentry_model->view_rpm_mgnt_rvw($id);//MGNT PURPOSE
			
		
			if($this->input->post('rd_id'))
			{
				$rd_id=$this->input->post('rd_id');
				$curDateTime=CurrMySqlDate();
				$log=get_logs();
					
				$field_array1=array(
					"fd_id" => $rd_id,
					"note" => $this->input->post('note'),
					"entry_by" => $current_user,
					"entry_date" => $curDateTime
				);
				
				if($this->input->post('action')==''){
					$rowid= data_inserter('qa_rpm_agent_rvw',$field_array1);
				}else{
					$this->db->where('fd_id', $rd_id);
					$this->db->update('qa_rpm_agent_rvw',$field_array1);
				}	
				redirect('Qa_RPM_Sentry/agent_rpm_feedback');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}
	public function agent_sentry_feedback()
	{
		if(check_logged_in()){
			$user_site_id= get_user_site_id();
			$role_id= get_role_id();
			$current_user = get_user_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_rpm_sentry/agent_sentry_feedback.php";
			$data["agentUrl"] = "Qa_RPM_Sentry/agent_sentry_feedback";
			$data["content_js"] = "qa_sentry_js.php";
			
			
			$qSql="Select count(id) as value from qa_sentry where agent_id='$current_user'";
			$data["tot_agent_feedback"] =  $this->Common_model->get_single_value($qSql);
			
			$qSql="Select count(id) as value from qa_sentry where id  not in (select fd_id from qa_sentry_agent_rvw ) and agent_id='$current_user'";
			$data["tot_agent_yet_rvw"] =  $this->Common_model->get_single_value($qSql);

			$qSql="Select count(id) as value from qa_sentry_credit_feedback where agent_id='$current_user' and audit_type not in ('Calibration', 'Pre-Certificate Mock Call', 'Certification Audit','QA Supervisor Audit')";
			$data["tot_agent_credit_feedback"] =  $this->Common_model->get_single_value($qSql);

			$qSql="Select count(id) as value from qa_sentry_credit_feedback where agent_rvw_date is null and agent_id='$current_user' and audit_type not in ('Calibration', 'Pre-Certificate Mock Call', 'Certification Audit','QA Supervisor Audit')";

			$data["tot_agent_credit_yet_rvw"] =  $this->Common_model->get_single_value($qSql);
				
			$from_date = '';
			$to_date = '';
			
			
			if($this->input->get('btnView')=='View')
			{
				$from_date = mmddyy2mysql($this->input->get('from_date'));
				$to_date = mmddyy2mysql($this->input->get('to_date'));
					
				$field_array = array(
					"from_date"=>$from_date,
					"to_date" => $to_date,
					"current_user" => $current_user
				);

				$data["agent_review_list"] = $this->Qa_RPM_Sentry_model->get_sentry_agent_review_data($field_array);
				///////////////////////////////////////////////////
				$fromDate = $this->input->get('from_date');
				if($fromDate!="") $from_date = mmddyy2mysql($fromDate);
				
				$toDate = $this->input->get('to_date');
				if($toDate!="") $to_date = mmddyy2mysql($toDate);
					
				if($fromDate!="" && $toDate!=="" ){ 
					$cond= " Where (audit_date >= '$from_date' and audit_date <= '$to_date') And agent_id='$current_user' and audit_type not in ('Calibration', 'Pre-Certificate Mock Call', 'Certification Audit','QA Supervisor Audit') ";
				}else{
					$cond= " Where agent_id='$current_user' and audit_type not in ('Calibration', 'Pre-Certificate Mock Call', 'Certification Audit','QA Supervisor Audit') ";
				}
					
				$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_sentry_credit_feedback $cond) xx Left Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid)";
				$data["agent_review_credit_list"] = $this->Common_model->get_query_result_array($qSql);
				//////////////////////////////////////////////////
					
			 }else{	
				$data["agent_review_list"] = $this->Qa_RPM_Sentry_model->get_sentry_agent_not_review_data($current_user);	

				$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_sentry_credit_feedback where agent_id='$current_user' And audit_type not in ('Calibration', 'Pre-Certificate Mock Call','QA Supervisor Audit', 'Certification Audit')) xx Inner Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_client_names(id) as client, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
				$data["agent_review_credit_list"] = $this->Common_model->get_query_result_array($qSql);		
			}
			
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			
			$this->load->view('dashboard',$data);
		}
	}

	public function agent_sentry_credit_rvw($id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_rpm_sentry/agent_sentry_credit_rvw.php";
			$data["agentUrl"] = "Qa_RPM_Sentry/agent_rpm_feedback";
			//$data["agentUrl"] = "qa_sentry/agent_sentry_feedback";
			$data["content_js"] = "qa_sentry_js.php";
			
			
			$qSql="SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, (select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_name,agent_rvw_note as agent_note,mgnt_rvw_note as mgnt_note from qa_sentry_credit_feedback where id=$id) xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to from signin) yy on (xx.agent_id=yy.sid) order by audit_date";
			$data["sentry_credit_data"] = $this->Common_model->get_query_row_array($qSql);
			
			$data["sentry_credit_id"]=$id;			
			
			if($this->input->post('sentry_credit_id'))
			{
				$sentry_credit_id=$this->input->post('sentry_credit_id');
				$curDateTime=CurrMySqlDate();
				$log=get_logs();
				
				$field_array=array(
					"agent_rvw_note" => $this->input->post('note'),
					"agnt_fd_acpt" => $this->input->post('agnt_fd_acpt'),
					"agent_rvw_date" => $curDateTime
				);
				$this->db->where('id', $sentry_credit_id);
				$this->db->update('qa_sentry_credit_feedback',$field_array);
				
				redirect('Qa_RPM_Sentry/agent_sentry_feedback');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}

	public function agent_sentry_feedback_rvw($id)
	{
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_rpm_sentry/agent_sentry_feedback_rvw.php";
			$data["agentUrl"] = "Qa_RPM_Sentry/agent_sentry_feedback";
						
			$data["get_sentry_feedback"] = $this->Qa_RPM_Sentry_model->view_sentry_feedback($id);
			
			$data["rdid"]=$id;
			
			$data["row1"] = $this->Qa_RPM_Sentry_model->view_sentry_agent_rvw($id);//AGENT PURPOSE
			$data["row2"] = $this->Qa_RPM_Sentry_model->view_sentry_mgnt_rvw($id);//MGNT PURPOSE
			
		
			if($this->input->post('rd_id'))
			{
				$rd_id=$this->input->post('rd_id');
				$curDateTime=CurrMySqlDate();
				$log=get_logs();
					
				$field_array1=array(
					"fd_id" => $rd_id,
					"note" => $this->input->post('note'),
					"entry_by" => $current_user,
					"entry_date" => $curDateTime
				);
				
				if($this->input->post('action')==''){
					$rowid= data_inserter('qa_sentry_agent_rvw',$field_array1);
				}else{
					$this->db->where('fd_id', $rd_id);
					$this->db->update('qa_sentry_agent_rvw',$field_array1);
				}	
				redirect('Qa_RPM_Sentry/agent_sentry_feedback');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}
	/****************QA RPM Report*****************/
	
	public function qa_rpm_report()
	{
		if(check_logged_in())
		{
			$current_user = get_user_id();
			$data["aside_template"] = "reports/aside.php";
			$data["content_template"] = "qa_rpm_sentry/qa_rpm_report.php";
			$from_date="";
			$to_date="";
			$action="";
			$agent ="";
			$dn_link="";
			$rpm_data = array();
			
			if($this->input->get('show')=='Show')
			{
				$from_date = $this->input->get('from_date');
				$to_date = $this->input->get('to_date');
				$agent = $this->input->get('agent');
				if($from_date!="" && $to_date!="")
				{
					$rpm_data =	$this->Qa_RPM_Sentry_model->qa_rpm_report(mmddyy2mysql($from_date),mmddyy2mysql($to_date),$agent,$current_user);
				}
				$this->create_qa_rpm_CSV($rpm_data);
				$dn_link = base_url()."Qa_RPM_Sentry/download_qa_rpm_CSV";
			}
			$data["from_date"] = $from_date;
            $data["to_date"] = $to_date;
			$data['agent'] = $agent;
			$data['rpm_data'] =	$rpm_data;
			$data['download_link']=$dn_link;
			$data["agent_list"] = $this->Qa_RPM_Sentry_model->get_agent_id(56,68);
			$this->load->view('dashboard',$data);
		}
	}
	/****************QA RPM CSV Generator*****************/
	public function create_qa_rpm_CSV($rr)
	{
		$filename = "./assets/reports/qa_rpm_report".get_user_id().".csv";
		$fopen = fopen($filename,"w+");
		$header = array("Auditor Name", "Audit Date","Audit Time","Agent","Audit Type","VOC","Caller Title","Caller Name","Caller Phone","Call Type","Disposition Type","Total Score","Total Score Count","Customer Information/Opening","Voice Delivery","Communication Skills","Customer Service","Disposition","Transfer","Protocol","Call Summary","Feedback");
		
		$row = "";
		foreach($header as $data) $row .= ''.$data.',';
		fwrite($fopen,rtrim($row,",")."\r\n");
		$searches = array("\r", "\n", "\r\n");
		
		foreach($rr as $rdata)
		{	
			$row = '"'.$rdata['auditor_name'].'",';
			$row .= '"'.$rdata['audit_date'].'",';
			$row .= '"'.$rdata['audit_time'].'",';
			$row .= '"'.$rdata['agent_name'].'",';
			$row .= '"'.$rdata['audit_type'].'",';
			$row .= '"'.$rdata['voc'].'",';
			$row .= '"'.$rdata['caller_title'].'",';
			$row .= '"'.$rdata['caller_name'].'",';
			$row .= '"'.$rdata['caller_phone'].'",';
			$row .= '"'.$rdata['call_type'].'",';
			$row .= '"'.$rdata['disposition_type'].'",';
			$row .= '"'.$rdata['overall_score'].'",';
			$row .= '"'.$rdata['total_score_count'].'",';
			$row .= '"'.$rdata['customer_information'].'",';
			$row .= '"'.$rdata['voice_delivery'].'",';
			$row .= '"'.$rdata['communication_skills'].'",';
			$row .= '"'.$rdata['customer_service'].'",';
			$row .= '"'.$rdata['disposition'].'",';
			$row .= '"'.$rdata['transfer'].'",';
			$row .= '"'.$rdata['protocol'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $rdata['call_summary'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $rdata['feedback'])).'"';	
			
			fwrite($fopen,$row."\r\n");
		}
		
		fclose($fopen);
	}
	public function download_qa_rpm_CSV()
	{
		$currDate=date("Y-m-d");
		$filename = "./assets/reports/qa_rpm_report".get_user_id().".csv";
		$newfile="QA RPM List-".$currDate.".csv";
		
		header('Content-Disposition: attachment;  filename="'.$newfile.'"');
		readfile($filename);
	}
	
	/****************QA Sentry Report*****************/
	public function qa_sentry_report()
	{
		if(check_logged_in())
		{
			$current_user = get_user_id();
			$data["aside_template"] = "reports/aside.php";
			$data["content_template"] = "qa_rpm_sentry/qa_sentry_report.php";
			
			$from_date="";
			$to_date="";
			$action="";
			$agent ="";
			$dn_link="";
			$sentry_data = array();
			
			if($this->input->get('show')=='Show')
			{
				$from_date = $this->input->get('from_date');
				$to_date = $this->input->get('to_date');
				$agent = $this->input->get('agent');
				if($from_date!="" && $to_date!="")
				{
					$sentry_data =	$this->Qa_RPM_Sentry_model->qa_sentry_report(mmddyy2mysql($from_date),mmddyy2mysql($to_date),$agent,$current_user);
				}
				$this->create_qa_sentry_CSV($sentry_data);
				$dn_link = base_url()."Qa_RPM_Sentry/download_qa_sentry_CSV";
			}
			$data["from_date"] = $from_date;
            $data["to_date"] = $to_date;
			$data['agent'] = $agent;
			$data['sentry_data'] =	$sentry_data;
			$data['download_link']=$dn_link;
			$data["agent_list"] = $this->Qa_RPM_Sentry_model->get_agent_id(55,174);
			$this->load->view('dashboard',$data);
		}
	}
	/****************QA Sentry CSV Generator*****************/
	public function create_qa_sentry_CSV($rr)
	{
		$filename = "./assets/reports/qa_sentry_report".get_user_id().".csv";
		$fopen = fopen($filename,"w+");
		$header = array("Auditor Name", "Audit Date","Audit Time","Agent","Audit Type","VOC","Caller Name","Caller Date","Caller Phone","Audit Result","Total Score","Total Score Count","Verified Consumer","Advise Recording","Professional","Speech","Objections","Fluidity","Experience","Call Summary","Feedback");
		
		$row = "";
		foreach($header as $data) $row .= ''.$data.',';
		fwrite($fopen,rtrim($row,",")."\r\n");
		$searches = array("\r", "\n", "\r\n");
		
		foreach($rr as $rdata)
		{	
		
			
			$row = '"'.$rdata['auditor_name'].'",';
			$row .= '"'.$rdata['audit_date'].'",';
			$row .= '"'.$rdata['audit_time'].'",';
			$row .= '"'.$rdata['agent_name'].'",';
			$row .= '"'.$rdata['audit_type'].'",';
			$row .= '"'.$rdata['voc'].'",';
			$row .= '"'.$rdata['caller_name'].'",';
			$row .= '"'.$rdata['caller_date'].'",';
			$row .= '"'.$rdata['caller_phone'].'",';
			$row .= '"'.$rdata['audit_result'].'",';
			$row .= '"'.$rdata['overall_score'].'",';
			$row .= '"'.$rdata['total_score_count'].'",';
			$row .= $rdata['verified_consumer']==0?'"No",':'"Yes",';
			$row .= $rdata['advise_recording']==0?'"No",':'"Yes",';
			$row .= '"'.$rdata['professional'].'",';
			$row .= '"'.$rdata['speech'].'",';
			$row .= '"'.$rdata['objections'].'",';
			$row .= '"'.$rdata['fluidity'].'",';
			$row .= '"'.$rdata['experience'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $rdata['call_summary'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $rdata['feedback'])).'"';	
			
			fwrite($fopen,$row."\r\n");
		}
		
		fclose($fopen);
	}
	public function download_qa_sentry_CSV()
	{
		$currDate=date("Y-m-d");
		$filename = "./assets/reports/qa_sentry_report".get_user_id().".csv";
		$newfile="QA Sentry List-".$currDate.".csv";
		
		header('Content-Disposition: attachment;  filename="'.$newfile.'"');
		readfile($filename);
	}
}