<?php 

 class Qa_stratus extends CI_Controller{
	
	public function __construct(){
		parent::__construct();
		$this->load->model('user_model');
		$this->load->model('Common_model');
	}
	
	
	private function stratus_upload_files($files,$path)
    {
        $config['upload_path'] = $path;
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
				
				
            } else {
                return false;
            }
        }
        return $images;
    }

	// private function park_west_upload_files($files,$path)// this is for file uploaging purpose
	// {
	// 	$result=$this->createPath($path);
	// 	if($result){
	// 	$config['upload_path'] = $path;
	// 	$config['allowed_types'] = '*';

	// 	  $config['allowed_types'] = 'm4a|mp4|mp3|wav';
	// 	  $config['max_size'] = '2024000';
	// 	  $this->load->library('upload', $config);
	// 	  $this->upload->initialize($config);
	// 	  $images = array();
	// 	  foreach ($files['name'] as $key => $image) {
	// 	$_FILES['uFiles']['name']= $files['name'][$key];
	// 	$_FILES['uFiles']['type']= $files['type'][$key];
	// 	$_FILES['uFiles']['tmp_name']= $files['tmp_name'][$key];
	// 	$_FILES['uFiles']['error']= $files['error'][$key];
	// 	$_FILES['uFiles']['size']= $files['size'][$key];

	// 	      if ($this->upload->do_upload('uFiles')) {
	// 	  $info = $this->upload->data();
	// 	  $ext = $info['file_ext'];
	// 	  $file_path = $info['file_path'];
	// 	  $full_path = $info['full_path'];
	// 	  $file_name = $info['file_name'];
	// 	  if(strtolower($ext)== '.wav'){

	// 	    $file_name = str_replace(".","_",$file_name).".mp3";
	// 	    $new_path = $file_path.$file_name;
	// 	    $comdFile=FCPATH."assets/script/wavtomp3.sh '$full_path' '$new_path'";
	// 	    $output = shell_exec( $comdFile);
	// 	    sleep(2);
	// 	  }
	// 	  $images[] = $file_name;
	// 	      }else{
	// 	          return false;
	// 	      }
	// 	  }
	// 	  return $images;
	// 	}
	// }



	public function index(){
		if(check_logged_in())
		{
			$current_user = get_user_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_stratus/qa_stratus_feedback.php";
			$data["content_js"] = "qa_loanxm_js.php";
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM signin where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client(id,211) and status=1 order by name";
			/* and is_assign_process(id,474) */
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
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_stratus_feedback $cond) xx Left Join
				(Select id as sid, fname, lname, fusion_id, get_client_ids(id) as client, get_process_ids(id) as pid, get_process_names(id) as process, assigned_to from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";
			$data["stratus"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_stratus_csr_feedback $cond) xx Left Join
				(Select id as sid, fname, lname, fusion_id, get_client_ids(id) as client, get_process_ids(id) as pid, get_process_names(id) as process, assigned_to from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";
			$data["stratus_csr"] = $this->Common_model->get_query_result_array($qSql);

			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_stratus_outbound_feedback $cond) xx Left Join
				(Select id as sid, fname, lname, fusion_id, get_client_ids(id) as client, get_process_ids(id) as pid, get_process_names(id) as process, assigned_to from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";
			$data["stratus_outbound"] = $this->Common_model->get_query_result_array($qSql);

			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_stratus_calltech_feedback $cond) xx Left Join
				(Select id as sid, fname, lname, fusion_id, get_client_ids(id) as client, get_process_ids(id) as pid, get_process_names(id) as process, assigned_to from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";
			$data["call_tech"] = $this->Common_model->get_query_result_array($qSql);

			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_stratus_monitoringtech_feedback $cond) xx Left Join
				(Select id as sid, fname, lname, fusion_id, get_client_ids(id) as client, get_process_ids(id) as pid, get_process_names(id) as process, assigned_to from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";
			$data["monitoring_tech"] = $this->Common_model->get_query_result_array($qSql);
		
			
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			$data["agent_id"] = $agent_id;
			
			$this->load->view("dashboard",$data);
		}
	}

	
	public function add_edit_stratus($stratus_id){
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_stratus/add_edit_stratus.php";
			$data["content_js"] = "qa_loanxm_js.php";
			$data['stratus_id']=$stratus_id;
			$tl_mgnt_cond='';
			
			if(get_role_dir()=='manager' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";
			}else if(get_role_dir()=='tl' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and assigned_to='$current_user'";
			}else{
				$tl_mgnt_cond="";
			}
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client(id,211) and status=1  order by name";
			/* and is_assign_process(id,474) */
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT id,concat(fname, ' ', lname) as name, fusion_id,office_id FROM signin where role_id in (select id from role where folder in ('tl','trainer','am','manager')) and status=1";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
		    $qSql =	"SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
				from qa_stratus_feedback where id='$stratus_id') xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";

			$data["stratus"] = $this->Common_model->get_query_row_array($qSql);
			
			//$currDate=CurrDate();
			$curDateTime=CurrMySqlDate();
			$a = array();
			
			
			$field_array['agent_id']=!empty($_POST['data']['agent_id'])?$_POST['data']['agent_id']:"";
			if($field_array['agent_id']){
				
				if($stratus_id==0){
					
					$field_array=$this->input->post('data');
					$field_array['audit_date']=CurrDate();
					$field_array['call_date']=mmddyy2mysql($this->input->post('call_date'));
					$field_array['entry_date']=$curDateTime;
					$field_array['audit_start_time']=$this->input->post('audit_start_time');
					$a = $this->stratus_upload_files($_FILES['attach_file'], $path='./qa_files/qa_stratus/');
					$field_array["attach_file"] = implode(',',$a);
					$rowid= data_inserter('qa_stratus_feedback',$field_array);
				///////////
					if(get_login_type()=="client"){
						$add_array = array("client_entryby" => $current_user);
					}else{
						$add_array = array("entry_by" => $current_user);
					}
					$this->db->where('id', $rowid);
					$this->db->update('qa_stratus_feedback',$add_array);
					/*******************Fatal Call Email Send functionality added on 14-12-22 START ***********************/
					if($field_array['overall_score'] == 0){
						$tablename = "qa_stratus_feedback";
						$sql = "SELECT tname.*, ip.email_id_off, ip_tl.email_id_off as tl_email, concat(s.fname, ' ', s.lname) as fullname,
							(SELECT concat(tls.fname, ' ', tls.lname) as tl_fullname FROM signin tls WHERE tls.id=tname.tl_id) as tl_fullname
							FROM $tablename tname
							LEFT JOIN info_personal ip ON ip.user_id=tname.agent_id 
							LEFT JOIN signin s ON s.id=tname.agent_id
							LEFT JOIN signin tl ON tl.id = tname.tl_id
							LEFT JOIN info_personal ip_tl ON ip_tl.user_id = tname.tl_id
							WHERE tname.id=$rowid";
						$result= $this->Common_model->get_query_row_array($sql);				
						$sqlParam ="SELECT process_id,params_columns, fatal_param, param_column_desc FROM qa_defect where table_name='$tablename'"; 
						$resultParams = $this->Common_model->get_query_row_array($sqlParam);
						
						$process = floor($resultParams['process_id']);
						$sqlProcess ="SELECT name FROM process where id='$process'"; 
						$resultProcess = $this->Common_model->get_query_row_array($sqlProcess);
						
						$params = explode(",", $resultParams['params_columns']);
						$fatal_params = explode(",", $resultParams['fatal_param']);
						$descArr = explode(",", $resultParams['param_column_desc']);
						
						$msgTable = "<Table BORDER=1>";
						$msgTable .= "<TR><TH>SL.</TH> <TH>CALL AUDIT PARAMETERS</TH><TH>QA Rating</TH> <TH>QA Remarks</TH></TR>";
						
						$i=1;
						$j=0;
						foreach($params as $par){
							//echo $str = str_replace('_', ' ', $par)."<BR>";
							if($result[$par]=='No'){
								$msgTable .= "<TR><TD>".$i."</TD><TD>". $descArr[$j]."</TD> <TD style='color:#FF0000'>".$result[$par]."</TD><TD>".$result['cmt'.$i]."</TD></TR>";
							}else{
								$msgTable .= "<TR><TD>".$i."</TD><TD>". $descArr[$j]."</TD> <TD>".$result[$par]."</TD><TD>".$result['cmt'.$i]."</TD></TR>";
							}
							
							$i++;
							$j++;
						}
						///////////////////////////
						//$j=1;
						/* if(!empty($fatal_params)){
							foreach($fatal_params as $fatal_par){
								if(!empty($fatal_par)){
								$msgTable .= "<TR><TD>".$i."</TD><TD style='color:#FF0000'>".ucwords( str_replace('_', ' ',$fatal_par))."</TD> <TD>".$result[$fatal_par]."</TD><TD>".$result['cmt'.($i-10)]."</TD></TR>";
								
								$i++;
								}
							}
						} */
						$msgTable .= "<TR><TD colspan='3'>Overall Score</TD> <TD>".$result['overall_score']."%</TD></TR>";
						$msgTable .= "</Table>";

						$eccA=array();
						//$to = $result['tl_email']; // Have to open when email will trigger to the Respective TL of the Agent
						$to = 'cherry.daluraya@fusionbposervices.com,sherryl.demape@fusionbposervices.com,vincent.butaya@fusionbposervices.com,Zephaniah.Satiembre@fusionbposervices.com,bryan.carpio@fusionbposervices.com,Acha.Joseph@fusionbposervices.com';
						$ebody = "Hello ". $result['tl_fullname'].",<br>";
						$ebody .= "<p>Agent Name : ".$result['fullname']."</p>";
						$ebody .= "<p>Order Number :  ".$result['order_number']."</p>";
						$ebody .= "<p>Call Date : ".$result['call_date']."</p>";
						$ebody .= "<p>Audit Date time : ".ConvServerToLocal($result['entry_date'])."</p>";
						$ebody .= "<p>Call Summary : ".$result['call_summary']."</p>";
						$ebody .= "<p>Feedback : ".$result['feedback']."</p><br><br>";
						$ebody .= "<p>Please listen the call from the MWP Tool and share feedback acceptancy :</p>";
						$ebody .=  $msgTable;
						$ebody .= "<p>Regards,</p>";
						$ebody .= "<p>MWP Team</p>";
						$esubject = "Fatal Call Alert - "." For Process - ".$resultProcess['name'].", Agent Name - ".$result['fullname']." Audit Date - ".$result['audit_date'];
						$eccA[]="Bompalli.Somasundaram@omindtech.com";
						$eccA[]="deb.dasgupta@omindtech.com";
						$eccA[]="sumitra.bagchi@omindtech.com";
						$eccA[]="anshuman.sarkar@fusionbposervices.com";
						/* $eccA[]="danish.khan@fusionbposervices.com";
						$eccA[]="Faisal.Anwar@fusionbposervices.com"; */
						$ecc = implode(',',$eccA);
						$path = "";
						$from_email="";
						$from_name="";
						//echo $esubject."<br>";
						//echo $ebody."<br>";
						//exit;
						//$send = $this->Email_model->send_email_sox("",$to, $ecc, $ebody, $esubject, $path, $from_email, $from_name, $isBcc="Y");
						unset($eccA);
					}
					/*******************Fatal Call Email Send functionality added on 14-12-22 END ***********************/
					
				}else{
					
					$field_array1=$this->input->post('data');
					$field_array1['call_date']=mmddyy2mysql($this->input->post('call_date'));
					$this->db->where('id', $stratus_id);
					$this->db->update('qa_stratus_feedback',$field_array1);
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
					$this->db->where('id', $stratus_id);
					$this->db->update('qa_stratus_feedback',$edit_array);
					
				}
				redirect('qa_stratus');
			}
			$data["array"] = $a;
			$this->load->view("dashboard",$data);
		}
	}

	public function add_edit_stratus_csr($stratus_id){
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_stratus/add_edit_stratus_csr.php";
			$data["content_js"] = "qa_loanxm_js.php";
			$data['stratus_id']=$stratus_id;
			$tl_mgnt_cond='';
			
			if(get_role_dir()=='manager' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";
			}else if(get_role_dir()=='tl' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and assigned_to='$current_user'";
			}else{
				$tl_mgnt_cond="";
			}
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client(id,211) and status=1  order by name";
			/* and is_assign_process(id,474) */
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT id,concat(fname, ' ', lname) as name, fusion_id,office_id FROM signin where role_id in (select id from role where folder in ('tl','trainer','am','manager')) and status=1";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
		    	 $qSql =	"SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
				from qa_stratus_csr_feedback where id='$stratus_id') xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";

			$data["stratus_csr"] = $this->Common_model->get_query_row_array($qSql);
			
			//$currDate=CurrDate();
			$curDateTime=CurrMySqlDate();
			$a = array();
			
			
			$field_array['agent_id']=!empty($_POST['data']['agent_id'])?$_POST['data']['agent_id']:"";
			if($field_array['agent_id']){
				
				if($stratus_id==0){
					
					$field_array=$this->input->post('data');
					$field_array['audit_date']=CurrDate();
					$field_array['call_date']=mmddyy2mysql($this->input->post('call_date'));
					$field_array['entry_date']=$curDateTime;
					$field_array['audit_start_time']=$this->input->post('audit_start_time');
					$a = $this->stratus_upload_files($_FILES['attach_file'], $path='./qa_files/qa_stratus/');
					$field_array["attach_file"] = implode(',',$a);
					$rowid= data_inserter('qa_stratus_csr_feedback',$field_array);
				///////////
					if(get_login_type()=="client"){
						$add_array = array("client_entryby" => $current_user);
					}else{
						$add_array = array("entry_by" => $current_user);
					}
					$this->db->where('id', $rowid);
					$this->db->update('qa_stratus_csr_feedback',$add_array);
					/*******************Fatal Call Email Send functionality added on 14-12-22 START ***********************/
					if($field_array['overall_score'] == 0){
						$tablename = "qa_stratus_csr_feedback";
						$sql = "SELECT tname.*, ip.email_id_off, ip_tl.email_id_off as tl_email, concat(s.fname, ' ', s.lname) as fullname,
							(SELECT concat(tls.fname, ' ', tls.lname) as tl_fullname FROM signin tls WHERE tls.id=tname.tl_id) as tl_fullname
							FROM $tablename tname
							LEFT JOIN info_personal ip ON ip.user_id=tname.agent_id 
							LEFT JOIN signin s ON s.id=tname.agent_id
							LEFT JOIN signin tl ON tl.id = tname.tl_id
							LEFT JOIN info_personal ip_tl ON ip_tl.user_id = tname.tl_id
							WHERE tname.id=$rowid";
						$result= $this->Common_model->get_query_row_array($sql);				
						$sqlParam ="SELECT process_id,params_columns, fatal_param, param_column_desc FROM qa_defect where table_name='$tablename'"; 
						$resultParams = $this->Common_model->get_query_row_array($sqlParam);
						
						$process = floor($resultParams['process_id']);
						$sqlProcess ="SELECT name FROM process where id='$process'"; 
						$resultProcess = $this->Common_model->get_query_row_array($sqlProcess);
						
						$params = explode(",", $resultParams['params_columns']);
						$fatal_params = explode(",", $resultParams['fatal_param']);
						$descArr = explode(",", $resultParams['param_column_desc']);
						
						$msgTable = "<Table BORDER=1>";
						$msgTable .= "<TR><TH>SL.</TH> <TH>CALL AUDIT PARAMETERS</TH><TH>QA Rating</TH> <TH>QA Remarks</TH></TR>";
						
						$i=1;
						$j=0;
						foreach($params as $par){
							//echo $str = str_replace('_', ' ', $par)."<BR>";
							if($result[$par]=='No'){
								$msgTable .= "<TR><TD>".$i."</TD><TD>". $descArr[$j]."</TD> <TD style='color:#FF0000'>".$result[$par]."</TD><TD>".$result['cmt'.$i]."</TD></TR>";
							}else{
								$msgTable .= "<TR><TD>".$i."</TD><TD>". $descArr[$j]."</TD> <TD>".$result[$par]."</TD><TD>".$result['cmt'.$i]."</TD></TR>";
							}
							
							$i++;
							$j++;
						}
						///////////////////////////
						//$j=1;
						/* if(!empty($fatal_params)){
							foreach($fatal_params as $fatal_par){
								if(!empty($fatal_par)){
								$msgTable .= "<TR><TD>".$i."</TD><TD style='color:#FF0000'>".ucwords( str_replace('_', ' ',$fatal_par))."</TD> <TD>".$result[$fatal_par]."</TD><TD>".$result['cmt'.($i-10)]."</TD></TR>";
								
								$i++;
								}
							}
						} */
						$msgTable .= "<TR><TD colspan='3'>Overall Score</TD> <TD>".$result['overall_score']."%</TD></TR>";
						$msgTable .= "</Table>";

						$eccA=array();
						//$to = $result['tl_email']; // Have to open when email will trigger to the Respective TL of the Agent
						$to = 'cherry.daluraya@fusionbposervices.com,sherryl.demape@fusionbposervices.com,vincent.butaya@fusionbposervices.com,Zephaniah.Satiembre@fusionbposervices.com,bryan.carpio@fusionbposervices.com,Acha.Joseph@fusionbposervices.com';
						$ebody = "Hello ". $result['tl_fullname'].",<br>";
						$ebody .= "<p>Agent Name : ".$result['fullname']."</p>";
						$ebody .= "<p>Order Number :  ".$result['order_number']."</p>";
						$ebody .= "<p>Call Date : ".$result['call_date']."</p>";
						$ebody .= "<p>Audit Date time : ".ConvServerToLocal($result['entry_date'])."</p>";
						$ebody .= "<p>Call Summary : ".$result['call_summary']."</p>";
						$ebody .= "<p>Feedback : ".$result['feedback']."</p><br><br>";
						$ebody .= "<p>Please listen the call from the MWP Tool and share feedback acceptancy :</p>";
						$ebody .=  $msgTable;
						$ebody .= "<p>Regards,</p>";
						$ebody .= "<p>MWP Team</p>";
						$esubject = "Fatal Call Alert - "." For Process - ".$resultProcess['name'].", Agent Name - ".$result['fullname']." Audit Date - ".$result['audit_date'];
						$eccA[]="Bompalli.Somasundaram@omindtech.com";
						$eccA[]="deb.dasgupta@omindtech.com";
						$eccA[]="sumitra.bagchi@omindtech.com";
						$eccA[]="anshuman.sarkar@fusionbposervices.com";
						/* $eccA[]="danish.khan@fusionbposervices.com";
						$eccA[]="Faisal.Anwar@fusionbposervices.com"; */
						$ecc = implode(',',$eccA);
						$path = "";
						$from_email="";
						$from_name="";
						//echo $esubject."<br>";
						//echo $ebody."<br>";
						//exit;
						//$send = $this->Email_model->send_email_sox("",$to, $ecc, $ebody, $esubject, $path, $from_email, $from_name, $isBcc="Y");
						unset($eccA);
					}
					/*******************Fatal Call Email Send functionality added on 14-12-22 END ***********************/
				}else{
					
					$field_array1=$this->input->post('data');
					$field_array1['call_date']=mmddyy2mysql($this->input->post('call_date'));
					$this->db->where('id', $stratus_id);
					$this->db->update('qa_stratus_csr_feedback',$field_array1);
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
					$this->db->where('id', $stratus_id);
					$this->db->update('qa_stratus_csr_feedback',$edit_array);
					
				}
				redirect('qa_stratus');
			}
			$data["array"] = $a;
			$this->load->view("dashboard",$data);
		}
	}

	public function add_edit_stratus_outbound($stratus_id){
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_stratus/add_edit_stratus_outbound.php";
			$data["content_js"] = "qa_loanxm_js.php";
			$data['stratus_id']=$stratus_id;
			$tl_mgnt_cond='';
			
			if(get_role_dir()=='manager' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";
			}else if(get_role_dir()=='tl' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and assigned_to='$current_user'";
			}else{
				$tl_mgnt_cond="";
			}
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client(id,211) and status=1  order by name";
			/* and is_assign_process(id,474) */
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT id,concat(fname, ' ', lname) as name, fusion_id,office_id FROM signin where role_id in (select id from role where folder in ('tl','trainer','am','manager')) and status=1";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
		    	 $qSql =	"SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
				from qa_stratus_outbound_feedback where id='$stratus_id') xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";

			$data["stratus_outbound"] = $this->Common_model->get_query_row_array($qSql);
			
			//$currDate=CurrDate();
			$curDateTime=CurrMySqlDate();
			$a = array();
			
			
			$field_array['agent_id']=!empty($_POST['data']['agent_id'])?$_POST['data']['agent_id']:"";
			if($field_array['agent_id']){
				
				if($stratus_id==0){
					
					$field_array=$this->input->post('data');
					$field_array['audit_date']=CurrDate();
					$field_array['call_date']=mmddyy2mysql($this->input->post('call_date'));
					$field_array['entry_date']=$curDateTime;
					$field_array['audit_start_time']=$this->input->post('audit_start_time');
					$a = $this->stratus_upload_files($_FILES['attach_file'], $path='./qa_files/qa_stratus/');
					$field_array["attach_file"] = implode(',',$a);
					$rowid= data_inserter('qa_stratus_outbound_feedback',$field_array);
				///////////
					if(get_login_type()=="client"){
						$add_array = array("client_entryby" => $current_user);
					}else{
						$add_array = array("entry_by" => $current_user);
					}
					$this->db->where('id', $rowid);
					$this->db->update('qa_stratus_outbound_feedback',$add_array);
					/*******************Fatal Call Email Send functionality added on 14-12-22 START ***********************/
					if($field_array['overall_score'] == 0){
						$tablename = "qa_stratus_outbound_feedback";
						$sql = "SELECT tname.*, ip.email_id_off, ip_tl.email_id_off as tl_email, concat(s.fname, ' ', s.lname) as fullname,
							(SELECT concat(tls.fname, ' ', tls.lname) as tl_fullname FROM signin tls WHERE tls.id=tname.tl_id) as tl_fullname
							FROM $tablename tname
							LEFT JOIN info_personal ip ON ip.user_id=tname.agent_id 
							LEFT JOIN signin s ON s.id=tname.agent_id
							LEFT JOIN signin tl ON tl.id = tname.tl_id
							LEFT JOIN info_personal ip_tl ON ip_tl.user_id = tname.tl_id
							WHERE tname.id=$rowid";
						$result= $this->Common_model->get_query_row_array($sql);				
						$sqlParam ="SELECT process_id,params_columns, fatal_param, param_column_desc FROM qa_defect where table_name='$tablename'"; 
						$resultParams = $this->Common_model->get_query_row_array($sqlParam);
						
						$process = floor($resultParams['process_id']);
						$sqlProcess ="SELECT name FROM process where id='$process'"; 
						$resultProcess = $this->Common_model->get_query_row_array($sqlProcess);
						
						$params = explode(",", $resultParams['params_columns']);
						$fatal_params = explode(",", $resultParams['fatal_param']);
						$descArr = explode(",", $resultParams['param_column_desc']);
						
						$msgTable = "<Table BORDER=1>";
						$msgTable .= "<TR><TH>SL.</TH> <TH>CALL AUDIT PARAMETERS</TH><TH>QA Rating</TH> <TH>QA Remarks</TH></TR>";
						
						$i=1;
						$j=0;
						foreach($params as $par){
							//echo $str = str_replace('_', ' ', $par)."<BR>";
							if($result[$par]=='No'){
								$msgTable .= "<TR><TD>".$i."</TD><TD>". $descArr[$j]."</TD> <TD style='color:#FF0000'>".$result[$par]."</TD><TD>".$result['cmt'.$i]."</TD></TR>";
							}else{
								$msgTable .= "<TR><TD>".$i."</TD><TD>". $descArr[$j]."</TD> <TD>".$result[$par]."</TD><TD>".$result['cmt'.$i]."</TD></TR>";
							}
							
							$i++;
							$j++;
						}
						///////////////////////////
						//$j=1;
						/* if(!empty($fatal_params)){
							foreach($fatal_params as $fatal_par){
								if(!empty($fatal_par)){
								$msgTable .= "<TR><TD>".$i."</TD><TD style='color:#FF0000'>".ucwords( str_replace('_', ' ',$fatal_par))."</TD> <TD>".$result[$fatal_par]."</TD><TD>".$result['cmt'.($i-10)]."</TD></TR>";
								
								$i++;
								}
							}
						} */
						$msgTable .= "<TR><TD colspan='3'>Overall Score</TD> <TD>".$result['overall_score']."%</TD></TR>";
						$msgTable .= "</Table>";

						$eccA=array();
						//$to = $result['tl_email']; // Have to open when email will trigger to the Respective TL of the Agent
						$to = 'cherry.daluraya@fusionbposervices.com,sherryl.demape@fusionbposervices.com,vincent.butaya@fusionbposervices.com,Zephaniah.Satiembre@fusionbposervices.com,bryan.carpio@fusionbposervices.com,Acha.Joseph@fusionbposervices.com';
						$ebody = "Hello ". $result['tl_fullname'].",<br>";
						$ebody .= "<p>Agent Name : ".$result['fullname']."</p>";
						$ebody .= "<p>Order Number :  ".$result['order_number']."</p>";
						$ebody .= "<p>Call Date : ".$result['call_date']."</p>";
						$ebody .= "<p>Audit Date time : ".ConvServerToLocal($result['entry_date'])."</p>";
						$ebody .= "<p>Call Summary : ".$result['call_summary']."</p>";
						$ebody .= "<p>Feedback : ".$result['feedback']."</p><br><br>";
						$ebody .= "<p>Please listen the call from the MWP Tool and share feedback acceptancy :</p>";
						$ebody .=  $msgTable;
						$ebody .= "<p>Regards,</p>";
						$ebody .= "<p>MWP Team</p>";
						$esubject = "Fatal Call Alert - "." For Process - ".$resultProcess['name'].", Agent Name - ".$result['fullname']." Audit Date - ".$result['audit_date'];
						$eccA[]="Bompalli.Somasundaram@omindtech.com";
						$eccA[]="deb.dasgupta@omindtech.com";
						$eccA[]="sumitra.bagchi@omindtech.com";
						$eccA[]="anshuman.sarkar@fusionbposervices.com";
						/* $eccA[]="danish.khan@fusionbposervices.com";
						$eccA[]="Faisal.Anwar@fusionbposervices.com"; */
						$ecc = implode(',',$eccA);
						$path = "";
						$from_email="";
						$from_name="";
						//echo $esubject."<br>";
						//echo $ebody."<br>";
						//exit;
						//$send = $this->Email_model->send_email_sox("",$to, $ecc, $ebody, $esubject, $path, $from_email, $from_name, $isBcc="Y");
						unset($eccA);
					}
					/*******************Fatal Call Email Send functionality added on 14-12-22 END ***********************/
					
				}else{
					
					$field_array1=$this->input->post('data');
					$field_array1['call_date']=mmddyy2mysql($this->input->post('call_date'));
					$this->db->where('id', $stratus_id);
					$this->db->update('qa_stratus_outbound_feedback',$field_array1);
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
					$this->db->where('id', $stratus_id);
					$this->db->update('qa_stratus_outbound_feedback',$edit_array);
					
				}
				redirect('qa_stratus');
			}
			$data["array"] = $a;
			$this->load->view("dashboard",$data);
		}
	}

	public function add_edit_call_tech($calltech_id){
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_stratus/add_edit_call_tech.php";
			$data["content_js"] = "qa_loanxm_js.php";
			$data['calltech_id']=$calltech_id;
			$tl_mgnt_cond='';
			
			if(get_role_dir()=='manager' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";
			}else if(get_role_dir()=='tl' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and assigned_to='$current_user'";
			}else{
				$tl_mgnt_cond="";
			}
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client(id,211) and status=1  order by name";
			/* and is_assign_process(id,474) */
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT id,concat(fname, ' ', lname) as name, fusion_id,office_id FROM signin where role_id in (select id from role where folder in ('tl','trainer','am','manager')) and status=1";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
		    	 $qSql =	"SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
				from qa_stratus_calltech_feedback where id='$calltech_id') xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";

			$data["call_tech"] = $this->Common_model->get_query_row_array($qSql);
			
			//$currDate=CurrDate();
			$curDateTime=CurrMySqlDate();
			$a = array();
			
			
			$field_array['agent_id']=!empty($_POST['data']['agent_id'])?$_POST['data']['agent_id']:"";
			if($field_array['agent_id']){
				
				if($calltech_id==0){
					
					$field_array=$this->input->post('data');
					$field_array['audit_date']=CurrDate();
					$field_array['call_date']=mmddyy2mysql($this->input->post('call_date'));
					$field_array['entry_date']=$curDateTime;
					$field_array['audit_start_time']=$this->input->post('audit_start_time');
					$a = $this->stratus_upload_files($_FILES['attach_file'], $path='./qa_files/qa_stratus/');
					$field_array["attach_file"] = implode(',',$a);
					$rowid= data_inserter('qa_stratus_calltech_feedback',$field_array);
				///////////
					if(get_login_type()=="client"){
						$add_array = array("client_entryby" => $current_user);
					}else{
						$add_array = array("entry_by" => $current_user);
					}
					$this->db->where('id', $rowid);
					$this->db->update('qa_stratus_calltech_feedback',$add_array);
					/*******************Fatal Call Email Send functionality added on 14-12-22 START ***********************/
					if($field_array['overall_score'] == 0){
						$tablename = "qa_stratus_calltech_feedback";
						$sql = "SELECT tname.*, ip.email_id_off, ip_tl.email_id_off as tl_email, concat(s.fname, ' ', s.lname) as fullname,
							(SELECT concat(tls.fname, ' ', tls.lname) as tl_fullname FROM signin tls WHERE tls.id=tname.tl_id) as tl_fullname
							FROM $tablename tname
							LEFT JOIN info_personal ip ON ip.user_id=tname.agent_id 
							LEFT JOIN signin s ON s.id=tname.agent_id
							LEFT JOIN signin tl ON tl.id = tname.tl_id
							LEFT JOIN info_personal ip_tl ON ip_tl.user_id = tname.tl_id
							WHERE tname.id=$rowid";
						$result= $this->Common_model->get_query_row_array($sql);				
						$sqlParam ="SELECT process_id,params_columns, fatal_param, param_column_desc FROM qa_defect where table_name='$tablename'"; 
						$resultParams = $this->Common_model->get_query_row_array($sqlParam);
						
						$process = floor($resultParams['process_id']);
						$sqlProcess ="SELECT name FROM process where id='$process'"; 
						$resultProcess = $this->Common_model->get_query_row_array($sqlProcess);
						
						$params = explode(",", $resultParams['params_columns']);
						$fatal_params = explode(",", $resultParams['fatal_param']);
						$descArr = explode(",", $resultParams['param_column_desc']);
						
						$msgTable = "<Table BORDER=1>";
						$msgTable .= "<TR><TH>SL.</TH> <TH>CALL AUDIT PARAMETERS</TH><TH>QA Rating</TH> <TH>QA Remarks</TH></TR>";
						
						$i=1;
						$j=0;
						foreach($params as $par){
							//echo $str = str_replace('_', ' ', $par)."<BR>";
							if($result[$par]=='No'){
								$msgTable .= "<TR><TD>".$i."</TD><TD>". $descArr[$j]."</TD> <TD style='color:#FF0000'>".$result[$par]."</TD><TD>".$result['cmt'.$i]."</TD></TR>";
							}else{
								$msgTable .= "<TR><TD>".$i."</TD><TD>". $descArr[$j]."</TD> <TD>".$result[$par]."</TD><TD>".$result['cmt'.$i]."</TD></TR>";
							}
							
							$i++;
							$j++;
						}
						///////////////////////////
						//$j=1;
						/* if(!empty($fatal_params)){
							foreach($fatal_params as $fatal_par){
								if(!empty($fatal_par)){
								$msgTable .= "<TR><TD>".$i."</TD><TD style='color:#FF0000'>".ucwords( str_replace('_', ' ',$fatal_par))."</TD> <TD>".$result[$fatal_par]."</TD><TD>".$result['cmt'.($i-10)]."</TD></TR>";
								
								$i++;
								}
							}
						} */
						$msgTable .= "<TR><TD colspan='3'>Overall Score</TD> <TD>".$result['overall_score']."%</TD></TR>";
						$msgTable .= "</Table>";

						$eccA=array();
						//$to = $result['tl_email']; // Have to open when email will trigger to the Respective TL of the Agent
						$to = 'cherry.daluraya@fusionbposervices.com,sherryl.demape@fusionbposervices.com,vincent.butaya@fusionbposervices.com,Zephaniah.Satiembre@fusionbposervices.com,bryan.carpio@fusionbposervices.com,Acha.Joseph@fusionbposervices.com';
						$ebody = "Hello ". $result['tl_fullname'].",<br>";
						$ebody .= "<p>Agent Name : ".$result['fullname']."</p>";
						$ebody .= "<p>Order Number :  ".$result['order_number']."</p>";
						$ebody .= "<p>Call Date : ".$result['call_date']."</p>";
						$ebody .= "<p>Audit Date time : ".ConvServerToLocal($result['entry_date'])."</p>";
						$ebody .= "<p>Call Summary : ".$result['call_summary']."</p>";
						$ebody .= "<p>Feedback : ".$result['feedback']."</p><br><br>";
						$ebody .= "<p>Please listen the call from the MWP Tool and share feedback acceptancy :</p>";
						$ebody .=  $msgTable;
						$ebody .= "<p>Regards,</p>";
						$ebody .= "<p>MWP Team</p>";
						$esubject = "Fatal Call Alert - "." For Process - ".$resultProcess['name'].", Agent Name - ".$result['fullname']." Audit Date - ".$result['audit_date'];
						$eccA[]="Bompalli.Somasundaram@omindtech.com";
						$eccA[]="deb.dasgupta@omindtech.com";
						$eccA[]="sumitra.bagchi@omindtech.com";
						$eccA[]="anshuman.sarkar@fusionbposervices.com";
						/* $eccA[]="danish.khan@fusionbposervices.com";
						$eccA[]="Faisal.Anwar@fusionbposervices.com"; */
						$ecc = implode(',',$eccA);
						$path = "";
						$from_email="";
						$from_name="";
						//echo $esubject."<br>";
						//echo $ebody."<br>";
						//exit;
						//$send = $this->Email_model->send_email_sox("",$to, $ecc, $ebody, $esubject, $path, $from_email, $from_name, $isBcc="Y");
						unset($eccA);
					}
					/*******************Fatal Call Email Send functionality added on 14-12-22 END ***********************/
					
				}else{
					
					$field_array1=$this->input->post('data');
					$field_array1['call_date']=mmddyy2mysql($this->input->post('call_date'));
					$this->db->where('id', $calltech_id);
					$this->db->update('qa_stratus_calltech_feedback',$field_array1);
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
					$this->db->where('id', $calltech_id);
					$this->db->update('qa_stratus_calltech_feedback',$edit_array);
					
				}
				redirect('qa_stratus');
			}
			$data["array"] = $a;
			$this->load->view("dashboard",$data);
		}
	}

	public function add_edit_monitoring_tech($monitoringtech_id){
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_stratus/add_edit_monitoring_tech.php";
			$data["content_js"] = "qa_loanxm_js.php";
			$data['monitoringtech_id']=$monitoringtech_id;
			$tl_mgnt_cond='';
			
			if(get_role_dir()=='manager' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";
			}else if(get_role_dir()=='tl' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and assigned_to='$current_user'";
			}else{
				$tl_mgnt_cond="";
			}
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client(id,211) and status=1  order by name";
			/* and is_assign_process(id,474) */
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT id,concat(fname, ' ', lname) as name, fusion_id,office_id FROM signin where role_id in (select id from role where folder in ('tl','trainer','am','manager')) and status=1";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
		    	 $qSql =	"SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
				from qa_stratus_monitoringtech_feedback where id='$monitoringtech_id') xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";

			$data["monitoring_tech"] = $this->Common_model->get_query_row_array($qSql);
			
			//$currDate=CurrDate();
			$curDateTime=CurrMySqlDate();
			$a = array();
			
			
			$field_array['agent_id']=!empty($_POST['data']['agent_id'])?$_POST['data']['agent_id']:"";
			if($field_array['agent_id']){
				
				if($monitoringtech_id==0){
					
					$field_array=$this->input->post('data');
					$field_array['audit_date']=CurrDate();
					$field_array['call_date']=mmddyy2mysql($this->input->post('call_date'));
					$field_array['entry_date']=$curDateTime;
					$field_array['audit_start_time']=$this->input->post('audit_start_time');
					$a = $this->stratus_upload_files($_FILES['attach_file'], $path='./qa_files/qa_stratus/');
					$field_array["attach_file"] = implode(',',$a);
					$rowid= data_inserter('qa_stratus_monitoringtech_feedback',$field_array);
				///////////
					if(get_login_type()=="client"){
						$add_array = array("client_entryby" => $current_user);
					}else{
						$add_array = array("entry_by" => $current_user);
					}
					$this->db->where('id', $rowid);
					$this->db->update('qa_stratus_monitoringtech_feedback',$add_array);
					/*******************Fatal Call Email Send functionality added on 14-12-22 START ***********************/
					if($field_array['overall_score'] == 0){
						$tablename = "qa_stratus_monitoringtech_feedback";
						$sql = "SELECT tname.*, ip.email_id_off, ip_tl.email_id_off as tl_email, concat(s.fname, ' ', s.lname) as fullname,
							(SELECT concat(tls.fname, ' ', tls.lname) as tl_fullname FROM signin tls WHERE tls.id=tname.tl_id) as tl_fullname
							FROM $tablename tname
							LEFT JOIN info_personal ip ON ip.user_id=tname.agent_id 
							LEFT JOIN signin s ON s.id=tname.agent_id
							LEFT JOIN signin tl ON tl.id = tname.tl_id
							LEFT JOIN info_personal ip_tl ON ip_tl.user_id = tname.tl_id
							WHERE tname.id=$rowid";
						$result= $this->Common_model->get_query_row_array($sql);				
						$sqlParam ="SELECT process_id,params_columns, fatal_param, param_column_desc FROM qa_defect where table_name='$tablename'"; 
						$resultParams = $this->Common_model->get_query_row_array($sqlParam);
						
						$process = floor($resultParams['process_id']);
						$sqlProcess ="SELECT name FROM process where id='$process'"; 
						$resultProcess = $this->Common_model->get_query_row_array($sqlProcess);
						
						$params = explode(",", $resultParams['params_columns']);
						$fatal_params = explode(",", $resultParams['fatal_param']);
						$descArr = explode(",", $resultParams['param_column_desc']);
						
						$msgTable = "<Table BORDER=1>";
						$msgTable .= "<TR><TH>SL.</TH> <TH>CALL AUDIT PARAMETERS</TH><TH>QA Rating</TH> <TH>QA Remarks</TH></TR>";
						
						$i=1;
						$j=0;
						foreach($params as $par){
							//echo $str = str_replace('_', ' ', $par)."<BR>";
							if($result[$par]=='No'){
								$msgTable .= "<TR><TD>".$i."</TD><TD>". $descArr[$j]."</TD> <TD style='color:#FF0000'>".$result[$par]."</TD><TD>".$result['cmt'.$i]."</TD></TR>";
							}else{
								$msgTable .= "<TR><TD>".$i."</TD><TD>". $descArr[$j]."</TD> <TD>".$result[$par]."</TD><TD>".$result['cmt'.$i]."</TD></TR>";
							}
							
							$i++;
							$j++;
						}
						///////////////////////////
						//$j=1;
						/* if(!empty($fatal_params)){
							foreach($fatal_params as $fatal_par){
								if(!empty($fatal_par)){
								$msgTable .= "<TR><TD>".$i."</TD><TD style='color:#FF0000'>".ucwords( str_replace('_', ' ',$fatal_par))."</TD> <TD>".$result[$fatal_par]."</TD><TD>".$result['cmt'.($i-10)]."</TD></TR>";
								
								$i++;
								}
							}
						} */
						$msgTable .= "<TR><TD colspan='3'>Overall Score</TD> <TD>".$result['overall_score']."%</TD></TR>";
						$msgTable .= "</Table>";

						$eccA=array();
						//$to = $result['tl_email']; // Have to open when email will trigger to the Respective TL of the Agent
						$to = 'cherry.daluraya@fusionbposervices.com,sherryl.demape@fusionbposervices.com,vincent.butaya@fusionbposervices.com,Zephaniah.Satiembre@fusionbposervices.com,bryan.carpio@fusionbposervices.com,Acha.Joseph@fusionbposervices.com';
						$ebody = "Hello ". $result['tl_fullname'].",<br>";
						$ebody .= "<p>Agent Name : ".$result['fullname']."</p>";
						$ebody .= "<p>Order Number :  ".$result['order_number']."</p>";
						$ebody .= "<p>Call Date : ".$result['call_date']."</p>";
						$ebody .= "<p>Audit Date time : ".ConvServerToLocal($result['entry_date'])."</p>";
						$ebody .= "<p>Call Summary : ".$result['call_summary']."</p>";
						$ebody .= "<p>Feedback : ".$result['feedback']."</p><br><br>";
						$ebody .= "<p>Please listen the call from the MWP Tool and share feedback acceptancy :</p>";
						$ebody .=  $msgTable;
						$ebody .= "<p>Regards,</p>";
						$ebody .= "<p>MWP Team</p>";
						$esubject = "Fatal Call Alert - "." For Process - ".$resultProcess['name'].", Agent Name - ".$result['fullname']." Audit Date - ".$result['audit_date'];
						$eccA[]="Bompalli.Somasundaram@omindtech.com";
						$eccA[]="deb.dasgupta@omindtech.com";
						$eccA[]="sumitra.bagchi@omindtech.com";
						$eccA[]="anshuman.sarkar@fusionbposervices.com";
						/* $eccA[]="danish.khan@fusionbposervices.com";
						$eccA[]="Faisal.Anwar@fusionbposervices.com"; */
						$ecc = implode(',',$eccA);
						$path = "";
						$from_email="";
						$from_name="";
						//echo $esubject."<br>";
						//echo $ebody."<br>";
						//exit;
						//$send = $this->Email_model->send_email_sox("",$to, $ecc, $ebody, $esubject, $path, $from_email, $from_name, $isBcc="Y");
						unset($eccA);
					}
					/*******************Fatal Call Email Send functionality added on 14-12-22 END ***********************/
					
				}else{
					
					$field_array1=$this->input->post('data');
					$field_array1['call_date']=mmddyy2mysql($this->input->post('call_date'));

					if($_FILES['attach_file']['tmp_name'][0]!=''){
						if(!file_exists("./qa_files/qa_stratus/")){
							mkdir("./qa_files/qa_stratus/");
						}
						$a = $this->stratus_upload_files( $_FILES['attach_file'], $path = './qa_files/qa_stratus/' );
						$field_array1['attach_file'] = implode( ',', $a );
					}

					$this->db->where('id', $monitoringtech_id);
					$this->db->update('qa_stratus_monitoringtech_feedback',$field_array1);
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
					$this->db->where('id', $monitoringtech_id);
					$this->db->update('qa_stratus_monitoringtech_feedback',$edit_array);
					
				}
				redirect('qa_stratus');
			}
			$data["array"] = $a;
			$this->load->view("dashboard",$data);
		}
	}

/*------------------- Agent Part ---------------------*/
	// public function agent_stratus_feedback(){
	// 	if(check_logged_in()){
	// 		$user_site_id= get_user_site_id();
	// 		$role_id= get_role_id();
	// 		$current_user = get_user_id();
	// 		$data["aside_template"] = "qa/aside.php";
	// 		$data["content_template"] = "qa_stratus/agent_stratus_feedback.php";
	// 		$data["content_js"] = "qa_loanxm_js.php";
	// 		$data["agentUrl"] = "qa_stratus/agent_stratus_feedback";
			
			
	// 		$qSql="Select count(id) as value from qa_stratus_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit')";
	// 		$data["tot_feedback"] =  $this->Common_model->get_single_value($qSql);
			
	// 		$qSql="Select count(id) as value from qa_stratus_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit') and agent_rvw_date is Null";
	// 		$data["yet_rvw"] =  $this->Common_model->get_single_value($qSql);
			
	// 		$from_date = '';
	// 		$to_date = '';
	// 		$cond="";
			
			
	// 		if($this->input->get('btnView')=='View')
	// 		{
	// 			$from_date = mmddyy2mysql($this->input->get('from_date'));
	// 			$to_date = mmddyy2mysql($this->input->get('to_date'));
				
	// 			if($from_date !="" && $to_date!=="" )  $cond= " Where (audit_date >= '$from_date' and audit_date <= '$to_date') and agent_id='$current_user'";
				
	// 			$qSql = "SELECT * from
	// 			(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
	// 			(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
	// 			(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
	// 			(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_stratus_feedback $cond And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit')) xx Left Join
	// 			(Select id as sid, fname, lname, fusion_id, assigned_to, get_client_names(id) as client, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
	// 			$data["agent_rvw_list"] = $this->Common_model->get_query_result_array($qSql);
					
	// 		}else{
	
	// 			$qSql="SELECT * from
	// 			(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
	// 			(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
	// 			(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
	// 			(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_stratus_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit')) xx Left Join
	// 			(Select id as sid, fname, lname, fusion_id, assigned_to, get_client_names(id) as client, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid) Where xx.agent_rvw_date is Null";
	// 			$data["agent_rvw_list"] = $this->Common_model->get_query_result_array($qSql);
	
	// 		}
			
	// 		$data["from_date"] = $from_date;
	// 		$data["to_date"] = $to_date;
			
	// 		$this->load->view('dashboard',$data);
	// 	}
	// }
	
	// public function agent_stratus_feedback(){
	// 	if(check_logged_in()){
	// 		$user_site_id= get_user_site_id();
	// 		$role_id= get_role_id();
	// 		$current_user = get_user_id();
	// 		$data["aside_template"] = "qa/aside.php";
	// 		$data["content_template"] = "qa_stratus/agent_stratus_feedback.php";
	// 		$data["content_js"] = "qa_loanxm_js.php";
	// 		$data["agentUrl"] = "qa_stratus/agent_stratus_feedback";
			
			
	// 		$qSql="Select count(id) as value from qa_stratus_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit')";
	// 		$data["tot_feedback"] =  $this->Common_model->get_single_value($qSql);
			
	// 		$qSql="Select count(id) as value from qa_stratus_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit') and agent_rvw_date is Null";
	// 		$data["yet_rvw"] =  $this->Common_model->get_single_value($qSql);
			
	// 		$from_date = '';
	// 		$to_date = '';
	// 		$cond="";
			
			
	// 		if($this->input->get('btnView')=='View')
	// 		{
	// 			$from_date = mmddyy2mysql($this->input->get('from_date'));
	// 			$to_date = mmddyy2mysql($this->input->get('to_date'));
				
	// 			if($from_date !="" && $to_date!=="" )  $cond= " Where (audit_date >= '$from_date' and audit_date <= '$to_date') and agent_id='$current_user'";
				
	// 			$qSql = "SELECT * from
	// 			(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
	// 			(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
	// 			(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
	// 			(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_stratus_feedback $cond And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit')) xx Left Join
	// 			(Select id as sid, fname, lname, fusion_id, assigned_to, get_client_names(id) as client, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
	// 			$data["agent_rvw_list"] = $this->Common_model->get_query_result_array($qSql);
					
	// 		}else{
	
	// 			$qSql="SELECT * from
	// 			(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
	// 			(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
	// 			(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
	// 			(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_stratus_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit')) xx Left Join
	// 			(Select id as sid, fname, lname, fusion_id, assigned_to, get_client_names(id) as client, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid) Where xx.agent_rvw_date is Null";
	// 			$data["agent_rvw_list"] = $this->Common_model->get_query_result_array($qSql);
	
	// 		}
			
	// 		$data["from_date"] = $from_date;
	// 		$data["to_date"] = $to_date;
			
	// 		$this->load->view('dashboard',$data);
	// 	}
	// }

	public function agent_stratus_feedback(){
		if(check_logged_in())
		{
			$current_user = get_user_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_stratus/agent_stratus_feedback.php";
			//$data["content_js"] = "qa_nurture_js.php";	
			$data["content_js"] = "qa_loanxm_js.php";
			$data["agentUrl"] = "qa_stratus/agent_stratus_feedback";		
			$campaign="";
			$from_date = '';
			$to_date = '';
			$cond="";
			
			$campaign = $this->input->get('campaign');
			
			if($campaign!=""){
			
				$qSql="Select count(id) as value from qa_".$campaign."_feedback where agent_id='$current_user'";
				$data["tot_feedback"] =  $this->Common_model->get_single_value($qSql);
			
				$qSql="Select count(id) as value from qa_".$campaign."_feedback where agent_rvw_date is null and agent_id='$current_user'";
				$data["yet_rvw"] =  $this->Common_model->get_single_value($qSql);

				if($this->input->get('btnView')=='View')
				{
					$from_date = mmddyy2mysql($this->input->get('from_date'));
					$to_date = mmddyy2mysql($this->input->get('to_date'));
					
					if($from_date !="" && $to_date!=="" )  $cond= " Where (audit_date >= '$from_date' and audit_date <= '$to_date') and agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit')";

					$qSql = "SELECT * from
						(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
						(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
						(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
						(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_".$campaign."_feedback $cond) xx Left Join
						(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid) order by audit_date";
					$data["agent_rvw_list"] = $this->Common_model->get_query_result_array($qSql);
				}else{
					
					$qSql = "SELECT * from
						(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
						(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
						(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
						(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_".$campaign."_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit')) xx Left Join
						(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid) Where xx.agent_rvw_date is Null";
					$data["agent_rvw_list"] = $this->Common_model->get_query_result_array($qSql);
				}
				
			}
			
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			$data['campaign']=$campaign;
			$this->load->view("dashboard",$data);
		}
	}
	
	public function agent_stratus_rvw($id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_stratus/agent_stratus_rvw.php";
			// $data["content_js"] = "qa_kabbage_js.php";
			$data["content_js"] = "qa_loanxm_js.php";
			$data["agentUrl"] = "qa_stratus/agent_stratus_feedback";
			$campaign="";
			$campaign = $this->input->get('campaign');
			
			$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_stratus_feedback where id='$id') xx Left Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
			$data["stratus"] = $this->Common_model->get_query_row_array($qSql);
			
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
				$this->db->update('qa_stratus_feedback',$field_array1);
					
				redirect('qa_stratus/agent_stratus_feedback');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}

	public function agent_stratus_csr_rvw($id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_stratus/agent_stratus_csr_rvw.php";
			// $data["content_js"] = "qa_kabbage_js.php";
			$data["content_js"] = "qa_loanxm_js.php";
			$data["agentUrl"] = "qa_stratus/agent_stratus_feedback";
			$campaign="";
			$campaign = $this->input->get('campaign');
			
			$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_stratus_csr_feedback where id='$id') xx Left Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
			$data["stratus_csr"] = $this->Common_model->get_query_row_array($qSql);
			
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
				$this->db->update('qa_stratus_csr_feedback',$field_array1);
					
				redirect('qa_stratus/agent_stratus_feedback');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}

	public function agent_stratus_outbound_rvw($id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_stratus/agent_stratus_outbound_rvw.php";
			// $data["content_js"] = "qa_kabbage_js.php";
			$data["content_js"] = "qa_loanxm_js.php";
			$data["agentUrl"] = "qa_stratus/agent_stratus_feedback";
			$campaign="";
			$campaign = $this->input->get('campaign');
			
			$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_stratus_outbound_feedback where id='$id') xx Left Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
			$data["stratus_outbound"] = $this->Common_model->get_query_row_array($qSql);
			
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
				$this->db->update('qa_stratus_outbound_feedback',$field_array1);
					
				redirect('qa_stratus/agent_stratus_feedback');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}

	public function agent_call_tech_rvw($id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_stratus/agent_call_tech_rvw.php";
			// $data["content_js"] = "qa_kabbage_js.php";
			$data["content_js"] = "qa_loanxm_js.php";
			$data["agentUrl"] = "qa_stratus/agent_stratus_feedback";
			$campaign="";
			$campaign = $this->input->get('campaign');
			
			$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_stratus_calltech_feedback where id='$id') xx Left Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
			$data["call_tech"] = $this->Common_model->get_query_row_array($qSql);
			
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
				$this->db->update('qa_stratus_calltech_feedback',$field_array1);
					
				redirect('qa_stratus/agent_stratus_feedback');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}
	
	public function agent_monitoring_tech_rvw($id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_stratus/agent_monitoring_tech_rvw.php";
			// $data["content_js"] = "qa_kabbage_js.php";
			$data["content_js"] = "qa_loanxm_js.php";
			$data["agentUrl"] = "qa_stratus/agent_stratus_feedback";
			$campaign="";
			$campaign = $this->input->get('campaign');
			
			$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_stratus_monitoringtech_feedback where id='$id') xx Left Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
			$data["monitoring_tech"] = $this->Common_model->get_query_row_array($qSql);
			
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
				$this->db->update('qa_stratus_monitoringtech_feedback',$field_array1);
					
				redirect('qa_stratus/agent_stratus_feedback');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}
/*-------------- Report Part ---------------*/
	public function qa_stratus_report(){
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
			$data["content_template"] = "qa_stratus/qa_stratus_report.php";
			$data["content_js"] = "qa_loanxm_js.php";
			
			$data['location_list'] = $this->Common_model->get_office_location_list();
			
			$office_id = "";
			$date_from="";
			$date_to="";
			$audit_type="";
			$campaign="";
			$campaign = $this->input->get('campaign');
			$action="";
			$dn_link="";
			$cond="";
			$cond1="";
			
			$data["qa_stratus_list"] = array();
			
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
				(select concat(fname, ' ', lname) as name from signin_client scx where scx.id=client_rvw_by) as client_rvw_name from qa_".$campaign."_feedback) xx Left Join
				(Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_ids(id) as process_id, get_process_names(id) as process, doj, DATEDIFF(CURDATE(), doj) as tenure from signin) yy on (xx.agent_id=yy.sid) $cond $cond1 order by audit_date";
				
				$fullAray = $this->Common_model->get_query_result_array($qSql);
				$data["qa_stratus_list"] = $fullAray;
				$this->create_qa_stratus_CSV($fullAray,$campaign);	
				$dn_link = base_url()."qa_stratus/download_qa_stratus_CSV/".$campaign;	
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
	 

	public function download_qa_stratus_CSV($campaign)
	{
		$currDate=date("Y-m-d");
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$newfile="QA ".$campaign." Audit List-'".$currDate."'.csv";
		header('Content-Disposition: attachment;  filename="'.$newfile.'"');
		readfile($filename);
	}
	
	public function create_qa_stratus_CSV($rr,$campaign)
	{
		$currDate=date("Y-m-d");
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$currentURL = base_url();
		$controller = "qa_stratus";
		

		$fopen = fopen($filename,"w+");
		
		if($campaign == 'stratus')
		{
		$edit_url = "add_edit_stratus";
		$main_url =  $currentURL.''.$controller.'/'.$edit_url;

		$header = array("Auditor Name", "Audit Date","Call Date", "Agent", "Fusion ID", "L1 Super","Order Number", "Customer Name", "Audit Type", "VOC","Audit Link", "Audit Start Date Time", "Audit End Date Time", "Interval(in sec)", "Auto Fail", "Overall Score",
		
		"PATIENT INFORMATION",
		"Markdown Comments1",
		"Did the agent input the correct patients first and last name?",
		"Markdown Comments2",
		"Did the agent input the correct patient's date of birth?",
		"Markdown Comments3",
		"Did the agent input the correct patient's physical address?",
		"Markdown Comments4",
		"Did the agents added the correct patient's phone and alternative number/s?",
		"Markdown Comments5",
		"Did the agents added the correct (Social Security Number) SSN Email Address when applicable.",
		"Markdown Comments6",
		"Did the agent selected the correct branch facility and place of service?",
		"Markdown Comments7",
		"CLINICAL",
		"Markdown Comments8",
		"Did the agent selected the correct patient's gender?",
		"Markdown Comments9",
		"Did the agent added the correct Ordering Provider?",
		"Markdown Comments10",
		"Did the agent added the correct Marketing Rep?",
		"Markdown Comments11",
		"Did the agent input the correct patient's diagnosis code?",
		"Markdown Comments12",
		"INSURANCE",
		"Markdown Comments13",
		"Unable to add/update insurance info to the order ",
		"Markdown Comments14",
		"Failure to check insurance eligibility?",
		"Markdown Comments15",
		"Did the agent updated the insurance eligibility date?",
		"Markdown Comments16",
		"Failure to update the Insurance policy holder information?",
		"Markdown Comments17",
		"SALES ORDER",
		"Markdown Comments18",
		"Failure to delete scheduled unit delivery date.",
		"Markdown Comments19",
		"Did the agent selected the correct branch office and Inv Location?",
		"Markdown Comments20",
		"Did the agent added the Order Reference?",
		"Markdown Comments21",
		"Did the agent updated the WIP state?",
		"Markdown Comments22",
		"Did the agent add the appropriate EEG length of service?",
		"Markdown Comments23",
		"Order Entry",
		"Markdown Comments24",
		"Failure to mark work fax.",
		"Markdown Comments25",
		"Did not move to EEG today.",
		"Markdown Comments26",
		"Failure to update missing information",
		"Markdown Comments27",
		"ATTACHMENT",
		"Markdown Comments28",
		"Wrong attachment to order belonging to another patient? HIPAA",
		"Markdown Comments29",
		"Did the agent create a duplicate order?",
		"Markdown Comments30",
		"Did the agent upload the fax file to the order?",
		"Markdown Comments31",
		"MAJOR ERRORS",
		"Markdown Comments32",
		"Did the agent documented the account properly?",
		"Markdown Comments33",
		"Did the agent input the correct ordered items?",
		"Markdown Comments34",
		"Did the agent send an email to the correct marketing representative?",
		"Markdown Comments35",
		"Did the agent send the missing fax information to the Doctor's office?",
		"Markdown Comments36",
		
		"Call Summary", "Feedback", "Agent Feedback Acceptance","Agent Review Date", "Agent Comment","Mgnt Review Date","Mgnt Review By", "Mgnt Comment", "Client Review Date", "Client Review Name", "Client Review Note");
		
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
			$main_urls = $main_url.'/'.$user['id'];
			
			$row = '"'.$auditorName.'",'; 
			$row .= '"'.$user['audit_date'].'",';
			$row .= '"'.$user['call_date'].'",'; 
			$row .= '"'.$user['fname']." ".$user['lname'].'",';
			$row .= '"'.$user['fusion_id'].'",';
			$row .= '"'.$user['tl_name'].'",';
			$row .= '"'.$user['order_number'].'",';
			$row .= '"'.$user['customer_name'].'",';
			$row .= '"'.$user['audit_type'].'",';
			$row .= '"'.$user['voc'].'",';
			$row .= '"'.$main_urls.'",';
			$row .= '"'.$user['audit_start_time'].'",';
			$row .= '"'.$user['entry_date'].'",';
			$row .= '"'.$interval1.'",';
			$row .= '"'.$user['auto_fail'].'",';
			$row .= '"'.$user['possible_score'].'",';
			$row .= '"'.$user['earned_score'].'",';
			$row .= '"'.$user['overall_score'].'%'.'",';
			$row .= '"'.$user['patient_information'].'",';
			$row .= '"'.$user['cmt1'].'",';
			$row .= '"'.$user['patient_name'].'",';
			$row .= '"'.$user['cmt2'].'",';
			$row .= '"'.$user['patient_dob'].'",';
			$row .= '"'.$user['cmt3'].'",';
			$row .= '"'.$user['patient_physical_address'].'",';
			$row .= '"'.$user['cmt4'].'",';
			$row .= '"'.$user['patient_phone_number'].'",';
			$row .= '"'.$user['cmt5'].'",';
            $row .= '"'.$user['agent_added_email'].'",';
			$row .= '"'.$user['cmt6'].'",';
            $row .= '"'.$user['agent_select_branch_facility'].'",';
			$row .= '"'.$user['cmt7'].'",';
            $row .= '"'.$user['clinical'].'",';
			$row .= '"'.$user['cmt8'].'",';
            $row .= '"'.$user['patient_gender'].'",';
			$row .= '"'.$user['cmt9'].'",';
            $row .= '"'.$user['ordering_provider'].'",';
			$row .= '"'.$user['cmt10'].'",';
            $row .= '"'.$user['marketing_rep'].'",';
			$row .= '"'.$user['cmt11'].'",';
            $row .= '"'.$user['diagnosis_code'].'",';
			$row .= '"'.$user['cmt12'].'",';
            $row .= '"'.$user['insurance'].'",';
			$row .= '"'.$user['cmt13'].'",';
            $row .= '"'.$user['info_order'].'",';
			$row .= '"'.$user['cmt14'].'",';
            $row .= '"'.$user['insurance_eligibility'].'",';
			$row .= '"'.$user['cmt15'].'",';
            $row .= '"'.$user['eligibility_date'].'",';
			$row .= '"'.$user['cmt16'].'",';
			$row .= '"'.$user['policy_holder_info'].'",';
			$row .= '"'.$user['cmt17'].'",';
            $row .= '"'.$user['sales_order'].'",';
			$row .= '"'.$user['cmt18'].'",';
            $row .= '"'.$user['delete_scheduled'].'",';
			$row .= '"'.$user['cmt19'].'",';
		    $row .= '"'.$user['branch_office'].'",';
			$row .= '"'.$user['cmt20'].'",';
            $row .= '"'.$user['order_reference'].'",';
			$row .= '"'.$user['cmt21'].'",';
            $row .= '"'.$user['wip_state'].'",';
			$row .= '"'.$user['cmt22'].'",';
            $row .= '"'.$user['eeg_length'].'",';
			$row .= '"'.$user['cmt23'].'",';
            $row .= '"'.$user['order_entry'].'",';
			$row .= '"'.$user['cmt24'].'",';
            $row .= '"'.$user['work_fax'].'",';
			$row .= '"'.$user['cmt25'].'",';
            $row .= '"'.$user['eeg_today'].'",';
			$row .= '"'.$user['cmt26'].'",';
            $row .= '"'.$user['missing_info'].'",';
			$row .= '"'.$user['cmt27'].'",';
            $row .= '"'.$user['attachment'].'",';
			$row .= '"'.$user['cmt28'].'",';
            $row .= '"'.$user['hippa'].'",';
			$row .= '"'.$user['cmt29'].'",';
            $row .= '"'.$user['duplicate_order'].'",';
			$row .= '"'.$user['cmt30'].'",';
            $row .= '"'.$user['fax_file'].'",';
			$row .= '"'.$user['cmt31'].'",';
            $row .= '"'.$user['major_errors'].'",';
			$row .= '"'.$user['cmt32'].'",';
            $row .= '"'.$user['account_properly'].'",';
			$row .= '"'.$user['cmt33'].'",';
            $row .= '"'.$user['ordered_items'].'",';
			$row .= '"'.$user['cmt34'].'",';
            $row .= '"'.$user['market_represent'].'",';
			$row .= '"'.$user['cmt35'].'",';
            $row .= '"'.$user['doctor_office'].'",';
			$row .= '"'.$user['cmt36'].'",';

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
		
	}elseif($campaign == 'stratus_csr')
	{
		$edit_url = "add_edit_stratus_csr";
		$main_url =  $currentURL.''.$controller.'/'.$edit_url;
	$header = array("Auditor Name", "Audit Date","Call Date", "Agent", "Fusion ID", "L1 Super","Order Number", "Customer Name", "Audit Type", "VOC","Audit Link", "Audit Start Date Time", "Audit End Date Time", "Interval(in sec)", "Possible Score","Earned Score","Overall Score",
	
	"Did the agent deliver the opening spiel in 3 seconds.",
	"Markdown Comments1",
	"Properly verifies the account holder information before providing/discussing any account information.",
	"Markdown Comments2",
	"Did the agent provide correct and complete information.",
	"Markdown Comments3",
	"Active Listening Skills",
	"Markdown Comments4",
	"Did the agent use proper tone and speed?",
	"Markdown Comments5",
	"Did the agent able to maintain the less than 20 seconds allowable time for dead air?",
	"Markdown Comments6",
	" Did the agent follow the correct hold procedure? (two-three minutes allowable hold time)",
	"Markdown Comments7",
	"Did the agent transfer the call to the correct extension?",
	"Markdown Comments8",
	"Proper documentation",
	"Markdown Comments9",
	"Compliance Score Percent",
	"Customer Score Percent",
	"Business Score Percent",
		
	"Call Summary", "Feedback", "Agent Feedback Acceptance","Agent Review Date", "Agent Comment","Mgnt Review Date","Mgnt Review By", "Mgnt Comment", "Client Review Date", "Client Review Name", "Client Review Note");
	
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
		$main_urls = $main_url.'/'.$user['id'];
		
		$row = '"'.$auditorName.'",'; 
		$row .= '"'.$user['audit_date'].'",';
		$row .= '"'.$user['call_date'].'",'; 
		$row .= '"'.$user['fname']." ".$user['lname'].'",';
		$row .= '"'.$user['fusion_id'].'",';
		$row .= '"'.$user['tl_name'].'",';
		$row .= '"'.$user['order_number'].'",';
		$row .= '"'.$user['customer_name'].'",';
		$row .= '"'.$user['audit_type'].'",';
		$row .= '"'.$user['voc'].'",';
		$row .= '"'.$main_urls.'",';
		$row .= '"'.$user['audit_start_time'].'",';
		$row .= '"'.$user['entry_date'].'",';
		$row .= '"'.$interval1.'",';
		$row .= '"'.$user['possible_score'].'",';
		$row .= '"'.$user['earned_score'].'",';
		$row .= '"'.$user['overall_score'].'%'.'",';
		$row .= '"'.$user['opening_spiel'].'",';
		$row .= '"'.$user['cmt1'].'",';
		$row .= '"'.$user['account_holder'].'",';
		$row .= '"'.$user['cmt2'].'",';
		$row .= '"'.$user['complete_info'].'",';
		$row .= '"'.$user['cmt3'].'",';
		$row .= '"'.$user['listening_skills'].'",';
		$row .= '"'.$user['cmt4'].'",';
		$row .= '"'.$user['tone_speed'].'",';
		$row .= '"'.$user['cmt5'].'",';
		$row .= '"'.$user['dead_air'].'",';
		$row .= '"'.$user['cmt6'].'",';
		$row .= '"'.$user['procedure'].'",';
		$row .= '"'.$user['cmt7'].'",';
		$row .= '"'.$user['extension'].'",';
		$row .= '"'.$user['cmt8'].'",';
		$row .= '"'.$user['documentation'].'",';
		$row .= '"'.$user['cmt9'].'",';
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
		$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['mgnt_rvw_note'])).'",';
		$row .= '"'.$user['client_rvw_date'].'",';
		$row .= '"'.$user['client_rvw_name'].'",';
		$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['client_rvw_note'])).'"';
		
		fwrite($fopen,$row."\r\n");
	}
	fclose($fopen);
	
		}elseif($campaign == 'stratus_outbound')
		{
		$edit_url = "add_edit_stratus_outbound";
		$main_url =  $currentURL.''.$controller.'/'.$edit_url;
		$header = array("Auditor Name", "Audit Date","Call Date", "Agent", "Fusion ID", "L1 Super","Order Number", "Customer Name", "Audit Type", "VOC","Audit Link", "Audit Start Date Time", "Audit End Date Time", "Interval(in sec)", "Possible Score","Earn Score","Overall Score",

		"Did the agent deliver the outbound spiel correctly?",
		"Markdown Comments1",
		"Did the agent call the patient on a correct time frame",
		"Markdown Comments2",
		"Did the agent answer acknowledge the patient's inquiry (if there is any)",
		"Markdown Comments3",
		"Did the agent apply active listening?",
		"Markdown Comments4",
		"Did the agent use proper tone and speed?",
		"Markdown Comments5",
		" Did the agent ask for the missing items needed (if there is any)",
		"Markdown Comments6",
		"Proper notation",
		"Markdown Comments7",
		"Proper color coding (report)",
		"Markdown Comments8",
		"Compliance Score Percent",
		"Customer Score Percent",
		"Business Score Percent",

		"Call Summary", "Feedback", "Agent Feedback Acceptance","Agent Review Date", "Agent Comment","Mgnt Review Date","Mgnt Review By", "Mgnt Comment", "Client Review Date", "Client Review Name", "Client Review Note");

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
			$main_urls = $main_url.'/'.$user['id'];
			
			$row = '"'.$auditorName.'",'; 
			$row .= '"'.$user['audit_date'].'",';
			$row .= '"'.$user['call_date'].'",'; 
			$row .= '"'.$user['fname']." ".$user['lname'].'",';
			$row .= '"'.$user['fusion_id'].'",';
			$row .= '"'.$user['tl_name'].'",';
			$row .= '"'.$user['order_number'].'",';
			$row .= '"'.$user['customer_name'].'",';
			$row .= '"'.$user['audit_type'].'",';
			$row .= '"'.$user['voc'].'",';
			$row .= '"'.$main_urls.'",';
			$row .= '"'.$user['audit_start_time'].'",';
			$row .= '"'.$user['entry_date'].'",';
			$row .= '"'.$interval1.'",';
			$row .= '"'.$user['possible_score'].'",';
			$row .= '"'.$user['earned_score'].'",';
			$row .= '"'.$user['overall_score'].'%'.'",';
			$row .= '"'.$user['outbound_spiel'].'",';
			$row .= '"'.$user['cmt1'].'",';
			$row .= '"'.$user['correct_time'].'",';
			$row .= '"'.$user['cmt2'].'",';
			$row .= '"'.$user['acknowledge'].'",';
			$row .= '"'.$user['cmt3'].'",';
			$row .= '"'.$user['active_listening'].'",';
			$row .= '"'.$user['cmt4'].'",';
			$row .= '"'.$user['tone_speed'].'",';
			$row .= '"'.$user['cmt5'].'",';
			$row .= '"'.$user['missing_items'].'",';
			$row .= '"'.$user['cmt6'].'",';
			$row .= '"'.$user['proper_notation'].'",';
			$row .= '"'.$user['cmt7'].'",';
			$row .= '"'.$user['color_coding'].'",';
			$row .= '"'.$user['cmt8'].'",';
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
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['mgnt_rvw_note'])).'",';
			$row .= '"'.$user['client_rvw_date'].'",';
			$row .= '"'.$user['client_rvw_name'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['client_rvw_note'])).'"';
			
			fwrite($fopen,$row."\r\n");
		}
		fclose($fopen);

		}elseif($campaign == 'stratus_monitoringtech')
		{
		$edit_url = "add_edit_monitoring_tech";
		$main_url =  $currentURL.''.$controller.'/'.$edit_url;
		$header = array("Auditor Name", "Audit Date","Call Date", "Agent", "Fusion ID", "L1 Super","Order Number", "Customer Name", "Auto Fail", "Audit Type", "VOC","Audit Link", "Audit Start Date Time", "Audit End Date Time", "Interval(in sec)", "Possible Score","Earn Score","Overall Score",

		"Did the agent do his/her routine checks.",
		"Comments1",
		"Did the agent documents Q2 checks on the patient report using the correct template?",
		"Comments2",
		"Did the agent notate the hours collected and amplifier battery percentage on every check?",
		"Comments3",
		"Did the agent document if the patient is on camera 1 camera 2 both cameras or off camera?",
		"Comments4",
		"Day Shift: Highlighting the patient blue and documenting the field tech that disconnected the patient.",
		"Comments5",
		"Did the agent document in the call log when contacting a patient. All Calls successful or unsuccessful?",
		"Comments6",
		"Did the agent document the patients last name leaving a detailed note and including their initials? No blank notes.",
		"Comments7",
		"Did the agent call the patient whenever they are not seen on cam or out of range after two checks?",
		"Comments8",
		"Did the agent transfer the information that is on the Master Setup List on to their patient report?",
		"Comments9",
		"Did the agent verify and document the patients name DOB and BT ID number.",
		"Comments10",
		"Did the agent document all phone numbers listed for the patient?",
		"Comments11",
		"Did the agent document the exact start time?",
		"Comments12",
		"Did the agent document if the patient has 2 cams 1 cam or no cameras?",
		"Comments13",
		"Did the agent document the state and time zone the patient is located in?",
		"Comments14",
		"Did the agent update WIP state in Bright Tree?",
		"Comments15",
		"Did the agent sync the time on units if it is the incorrect time zone or has not been completed in the past ten days?",
		"Comments16",
		"Did the agent format the data card?",
		"Comments17",
		"Did the agent check the A/V Log to ensure audio is on the cameras are configured properly",
		"Comments18",
		"Compliance Score Percent",
		"Customer Score Percent",
		"Business Score Percent",

		"Call Summary", "Feedback", "Agent Feedback Acceptance","Agent Review Date", "Agent Comment","Mgnt Review Date","Mgnt Review By", "Mgnt Comment", "Client Review Date", "Client Review Name", "Client Review Note");

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
			$main_urls = $main_url.'/'.$user['id'];
			
			$row = '"'.$auditorName.'",'; 
			$row .= '"'.$user['audit_date'].'",';
			$row .= '"'.$user['call_date'].'",'; 
			$row .= '"'.$user['fname']." ".$user['lname'].'",';
			$row .= '"'.$user['fusion_id'].'",';
			$row .= '"'.$user['tl_name'].'",';
			$row .= '"'.$user['order_number'].'",';
			$row .= '"'.$user['customer_name'].'",';
			$row .= '"'.$user['auto_fail'].'",';
			$row .= '"'.$user['audit_type'].'",';
			$row .= '"'.$user['voc'].'",';
			$row .= '"'.$main_urls.'",';
			$row .= '"'.$user['audit_start_time'].'",';
			$row .= '"'.$user['entry_date'].'",';
			$row .= '"'.$interval1.'",';
			$row .= '"'.$user['possible_score'].'",';
			$row .= '"'.$user['earned_score'].'",';
			$row .= '"'.$user['overall_score'].'%'.'",';
			$row .= '"'.$user['routine_checks'].'",';
			$row .= '"'.$user['cmt1'].'",';
			$row .= '"'.$user['patient_report'].'",';
			$row .= '"'.$user['cmt2'].'",';
			$row .= '"'.$user['amplifier'].'",';
			$row .= '"'.$user['cmt3'].'",';
			$row .= '"'.$user['cameras'].'",';
			$row .= '"'.$user['cmt4'].'",';
			$row .= '"'.$user['highlighting'].'",';
			$row .= '"'.$user['cmt5'].'",';
			$row .= '"'.$user['contacting'].'",';
			$row .= '"'.$user['cmt6'].'",';
			$row .= '"'.$user['initials'].'",';
			$row .= '"'.$user['cmt7'].'",';
			$row .= '"'.$user['patient_call'].'",';
			$row .= '"'.$user['cmt8'].'",';
			$row .= '"'.$user['patient_rept'].'",';
			$row .= '"'.$user['cmt9'].'",';
			$row .= '"'.$user['patient_id'].'",';
			$row .= '"'.$user['cmt10'].'",';
			$row .= '"'.$user['patient_phone'].'",';
			$row .= '"'.$user['cmt11'].'",';
			$row .= '"'.$user['start_time'].'",';
			$row .= '"'.$user['cmt12'].'",';
			$row .= '"'.$user['patient_cameras'].'",';
			$row .= '"'.$user['cmt13'].'",';
			$row .= '"'.$user['patient_location'].'",';
			$row .= '"'.$user['cmt14'].'",';
			$row .= '"'.$user['bright_tree'].'",';
			$row .= '"'.$user['cmt15'].'",';
			$row .= '"'.$user['incorrect_time'].'",';
			$row .= '"'.$user['cmt16'].'",';
			$row .= '"'.$user['data_card'].'",';
			$row .= '"'.$user['cmt17'].'",';
			$row .= '"'.$user['configured'].'",';
			$row .= '"'.$user['cmt18'].'",';
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
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['mgnt_rvw_note'])).'",';
			$row .= '"'.$user['client_rvw_date'].'",';
			$row .= '"'.$user['client_rvw_name'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['client_rvw_note'])).'"';
			
			fwrite($fopen,$row."\r\n");
		}
		fclose($fopen);

		}elseif($campaign == 'stratus_calltech')
		{
		$edit_url = "add_edit_call_tech";
		$main_url =  $currentURL.''.$controller.'/'.$edit_url;
		$header = array("Auditor Name", "Audit Date","Call Date", "Agent", "Fusion ID", "L1 Super","Order Number", "Customer Name", "Audit Type", "VOC","Audit Link", "Audit Start Date Time", "Audit End Date Time", "Interval(in sec)", "Possible Score","Earn Score","Overall Score",

		"Did the agent deliver the outboundi inbound spiel correctly?",
		"Markdown Comments1",
		"Did the agent get the two identifiers?",
		"Markdown Comments2",
		"During courtesy call did the agent get all needed information?",
		"Markdown Comments3",
		"Did the agent apply active listening?",
		"Markdown Comments4",
		" Did the agent use proper tone and speed?",
		"Markdown Comments5",
		"Did the agent observe proper Hold Procedure and avoid long silences?",
		"Markdown Comments6",
		"Did the agent transfer the call to the correct monitoring tech or extension?",
		"Markdown Comments7",
		" Did the agent provide accurate reminders for the patient?",
		"Markdown Comments8",
		"Proper documentation.",
		"Markdown Comments9",
		"Compliance Score Percent",
		"Customer Score Percent",
		"Business Score Percent",

		"Call Summary", "Feedback", "Agent Feedback Acceptance","Agent Review Date", "Agent Comment","Mgnt Review Date","Mgnt Review By", "Mgnt Comment", "Client Review Date", "Client Review Name", "Client Review Note");

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
			$main_urls = $main_url.'/'.$user['id'];
			
			$row = '"'.$auditorName.'",'; 
			$row .= '"'.$user['audit_date'].'",';
			$row .= '"'.$user['call_date'].'",'; 
			$row .= '"'.$user['fname']." ".$user['lname'].'",';
			$row .= '"'.$user['fusion_id'].'",';
			$row .= '"'.$user['tl_name'].'",';
			$row .= '"'.$user['order_number'].'",';
			$row .= '"'.$user['customer_name'].'",';
			$row .= '"'.$user['audit_type'].'",';
			$row .= '"'.$user['voc'].'",';
			$row .= '"'.$main_urls.'",';
			$row .= '"'.$user['audit_start_time'].'",';
			$row .= '"'.$user['entry_date'].'",';
			$row .= '"'.$interval1.'",';
			$row .= '"'.$user['possible_score'].'",';
			$row .= '"'.$user['earned_score'].'",';
			$row .= '"'.$user['overall_score'].'%'.'",';
			$row .= '"'.$user['agent_deliver'].'",';
			$row .= '"'.$user['cmt1'].'",';
			$row .= '"'.$user['identifiers'].'",';
			$row .= '"'.$user['cmt2'].'",';
			$row .= '"'.$user['courtesy_call'].'",';
			$row .= '"'.$user['cmt3'].'",';
			$row .= '"'.$user['active_listening'].'",';
			$row .= '"'.$user['cmt4'].'",';
			$row .= '"'.$user['tone_speed'].'",';
			$row .= '"'.$user['cmt5'].'",';
			$row .= '"'.$user['silences'].'",';
			$row .= '"'.$user['cmt6'].'",';
			$row .= '"'.$user['call_transfer'].'",';
			$row .= '"'.$user['cmt7'].'",';
			$row .= '"'.$user['patient'].'",';
			$row .= '"'.$user['cmt8'].'",';
			$row .= '"'.$user['documentation'].'",';
			$row .= '"'.$user['cmt9'].'",';
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
