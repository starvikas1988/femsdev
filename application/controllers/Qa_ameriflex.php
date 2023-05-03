<?php 

 class Qa_ameriflex extends CI_Controller{
	
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
	
	
    private function audio_upload_files($files,$path)
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
					
					
				} else {
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
			$data["content_template"] = "qa_ameriflex/qa_ameriflex.php";
			//$data["content_js"] = "qa_bsnl_js.php";
			$data["content_js"] = "qa_ameriflex_js.php";
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client(id,328) and status=1  order by name";
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
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_ameriflex_feedback $cond) xx Left Join
				(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";
			$data["auditData"] = $this->Common_model->get_query_result_array($qSql);
			
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			$data["agent_id"] = $agent_id;
			
			$this->load->view("dashboard",$data);
		}
	}

	public function add_edit_ameriflex($ameriflex_id){
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_ameriflex/add_edit_ameriflex.php";
			//$data["content_js"] = "qa_bsnl_js.php";
			$data["content_js"] = "qa_ameriflex_js.php";
			$data['ameriflex_id']=$ameriflex_id;
			$tl_mgnt_cond='';
			if(get_role_dir()=='manager' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";
			}else if(get_role_dir()=='tl' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and assigned_to='$current_user'";
			}else{
				$tl_mgnt_cond="";
			}
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client(id,328) and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT id, fname, lname, fusion_id, office_id FROM signin where role_id in (select id from role where (folder in ('tl','trainer','am','manager')) or (name in ('Client Services'))) and status=1";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
			/******** Randamiser Start***********/
			$rand_id=0;
			if(!empty($this->uri->segment(4))){
				$rand_id=$this->uri->segment(4);
			}
			$data['rand_id']=$rand_id;
			$data["rand_data"] = "";			
			if($rand_id!=0){
				$client_id=328;
				$pro_id = 699;
				$curDateTime=CurrMySqlDate();
				$upArr = array('distribution_opend_by' =>$current_user,'distribution_opened_datetime'=>$curDateTime);
				$this->db->where('id', $rand_id);
				$this->db->update('qa_randamiser_ameriflex_data',$upArr);
				$randSql="Select srd.*,srd.aht as call_duration, S.id as sid, S.fname, S.lname, S.xpoid, S.assigned_to,
				(select concat(fname, ' ', lname) as name from signin s1 where s1.id=S.assigned_to) as tl_name,DATEDIFF(CURDATE(), S.doj) as tenure
				from qa_randamiser_ameriflex_data srd Left Join signin S On srd.fusion_id=S.fusion_id where srd.audit_status=0 and srd.id='$rand_id'";
				$data["rand_data"] = $rand_data =  $this->Common_model->get_query_row_array($randSql);
				
			}
			//print_r($data["rand_data"]);
			/******** Randamiser Ends**********/
			
			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
				from qa_ameriflex_feedback where id='$ameriflex_id') xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
			$data["auditData"] = $this->Common_model->get_query_row_array($qSql);
			

			$curDateTime=CurrMySqlDate();
			$a = array();
			
			
			$field_array['agent_id']=!empty($_POST['data']['agent_id'])?$_POST['data']['agent_id']:"";
			
			if($field_array['agent_id']){
				
				if($ameriflex_id==0){
					$field_array=$this->input->post('data');
					$field_array['audit_date']=CurrDate();
					$field_array['entry_date']=$curDateTime;
					$field_array['call_date']=mmddyy2mysql($this->input->post('call_date'));
					$field_array['audit_start_time']=$this->input->post('audit_start_time');
					$a = $this->audio_upload_files($_FILES['attach_file'], $path='./qa_files/qa_ameriflex/');
					$field_array["attach_file"] = implode(',',$a);
					$rowid= data_inserter('qa_ameriflex_feedback',$field_array);
				///////////
					if(get_login_type()=="client"){
						$add_array = array("client_entryby" => $current_user);
					}else{
						$add_array = array("entry_by" => $current_user);
					}
					$this->db->where('id', $rowid);
					$this->db->update('qa_ameriflex_feedback',$add_array);
					
					if($rand_id!=0){					
					$rand_cdr_array = array("audit_status" => 1);
					$this->db->where('id', $rand_id);
					$this->db->update('qa_randamiser_ameriflex_data',$rand_cdr_array);
					
					$rand_array = array("is_rand" => 1);
					$this->db->where('id', $rowid);
					$this->db->update('qa_ameriflex_feedback',$rand_array);
					}
				///////////// Client & Process Table Update ////////////////
					$clientSql="Select * from client where id=328";
					$clientData = $this->Common_model->get_query_row_array($clientSql);
					if($clientData['qa_report_url']==""){
						$this->db->query("UPDATE client SET qa_report_url='qa_ameriflex_report' WHERE id=328");
					}
					
					$processSql="Select * from process where id=699";
					$processData = $this->Common_model->get_query_row_array($processSql);
					if($processData['qa_agent_url']==""){
						$this->db->query("UPDATE process SET qa_url='qa_ameriflex', qa_agent_url='qa_ameriflex/agent_ameriflex_feedback' WHERE id=699");
					}
					/*******************Fatal Call Email Send functionality added on 14-12-22 START ***********************/
					if($field_array['overall_score'] == 0){
						$tablename = "qa_ameriflex_feedback";
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
						$to = 'AMFLX_Operations@fusionbposervices.com,bella.fabricante@fusionbposervices.com,Rizzie.Larios@fusionbposervices.com,Jessa.Wenceslao@fusionbposervices.com,Zephaniah.Satiembre@fusionbposervices.com,bryan.carpio@fusionbposervices.com,Acha.Joseph@fusionbposervices.com';
						$ebody = "Hello ". $result['tl_fullname'].",<br>";
						$ebody .= "<p>Agent Name : ".$result['fullname']."</p>";
						$ebody .= "<p>Interaction ID :  ".$result['interaction_id']."</p>";
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
					if(!isset($field_array1['auditor_type'])){
						$field_array1['auditor_type'] = "";
					}
					$this->db->where('id', $ameriflex_id);
					$this->db->update('qa_ameriflex_feedback',$field_array1);
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
					$this->db->where('id', $ameriflex_id);
					$this->db->update('qa_ameriflex_feedback',$edit_array);
					
				}
				if(isset($rand_data['upload_date']) && !empty($rand_data['upload_date'])){
					$up_date = date('Y-m-d', strtotime($rand_data['upload_date']));
					redirect('Qa_randamiser/data_distribute_freshdesk?from_date='.$up_date.'&client_id='.$client_id.'&pro_id='.$pro_id.'&submit=Submit');
				}else{
					redirect('qa_ameriflex');
				}
				//redirect('qa_ameriflex');
			}
			$data["array"] = $a;
			$this->load->view("dashboard",$data);
		}
	}
	

/////////////////////////////////////////////////////////////////////
/////////////////////////Agent part/////////////////////////////////	
	public function agent_ameriflex_feedback()
	{
		if(check_logged_in()){
			$role_id= get_role_id();
			$current_user = get_user_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_ameriflex/agent_ameriflex_feedback.php";
			//$data["content_js"] = "qa_bsnl_js.php";
			$data["content_js"] = "qa_ameriflex_js.php";
			$data["agentUrl"] = "Qa_ameriflex/agent_ameriflex_feedback";
			
			$qSql="Select count(id) as value from qa_ameriflex_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit', 'Calibration', 'Pre-Certificate Mock Call', 'Certificate Audit')";
			$data["tot_feedback"] =  $this->Common_model->get_single_value($qSql);
			
			$qSql="Select count(id) as value from qa_ameriflex_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit') and agent_rvw_date is Null";
			$data["yet_rvw"] =  $this->Common_model->get_single_value($qSql);
			
			$from_date = '';
			$to_date = '';
			$cond="";
			
			if($this->input->get('btnView')=='View'){
			
				$from_date = mmddyy2mysql($this->input->get('from_date'));
				$to_date = mmddyy2mysql($this->input->get('to_date'));
				
				if($from_date !="" && $to_date!=="" )  $cond= " Where (audit_date >= '$from_date' and audit_date <= '$to_date') and agent_id='$current_user' ";
				
				$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_ameriflex_feedback $cond And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit')) xx Inner Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_client_names(id) as client, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
				$data["agent_rvw_list"] = $this->Common_model->get_query_result_array($qSql);
			
			}else{
				
				$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_ameriflex_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit')) xx Inner Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_client_names(id) as client, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid) Where xx.agent_rvw_date is Null";
				$data["agent_rvw_list"] = $this->Common_model->get_query_result_array($qSql);

			}
			
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			$this->load->view('dashboard',$data);
		}
	}

	public function agent_ameriflex_rvw($id){
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_ameriflex/agent_ameriflex_rvw.php";
			//$data["content_js"] = "qa_bsnl_js.php";
			$data["content_js"] = "qa_ameriflex_js.php";
			$data["agentUrl"] = "Qa_ameriflex/agent_ameriflex_feedback";
			
			$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_ameriflex_feedback where id='$id') xx Left Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
			$data["ameriflex"] = $this->Common_model->get_query_row_array($qSql);
			
			$data["ameriflex_id"]=$id;
			
			if($this->input->post('ameriflex_id'))
			{
				$pnid=$this->input->post('ameriflex_id');
				$curDateTime=CurrMySqlDate();
				$log=get_logs();
					
				$field_array1=array(
					"agnt_fd_acpt" => $this->input->post('agnt_fd_acpt'),
					"agent_rvw_note" => $this->input->post('note'),
					"agent_rvw_date" => $curDateTime
				);
				$this->db->where('id', $pnid);
				$this->db->update('qa_ameriflex_feedback',$field_array1);
					
				redirect('Qa_ameriflex/agent_ameriflex_feedback');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}


/////////////////////////////////////////////////////////////////////////////////////
///////Report Part
	public function qa_ameriflex_report(){
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
			$data["content_template"] = "qa_ameriflex/qa_ameriflex_report.php";
			//$data["content_js"] = "qa_bsnl_js.php";
			$data["content_js"] = "qa_ameriflex_js.php";
			
			$data['location_list'] = $this->Common_model->get_office_location_list();
			
			$office_id = "";
			$date_from="";
			$date_to="";
			$audit_type="";
			$action="";
			$dn_link="";
			$cond="";
			$cond1="";
			$user="";
			
			$data["ameriflex_list"] = array();
			
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
				(select concat(fname, ' ', lname) as name from signin_client scx where scx.id=client_rvw_by) as client_rvw_name from qa_ameriflex_feedback) xx Inner Join
				(Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_ids(id) as process_id, get_process_names(id) as process, doj, DATEDIFF(CURDATE(), doj) as tenure from signin) yy on (xx.agent_id=yy.sid) $cond $cond1 order by audit_date";
				
				$fullAray = $this->Common_model->get_query_result_array($qSql);
				$data["ameriflex_list"] = $fullAray;
				$this->create_qa_ameriflex_CSV($fullAray);	
				$dn_link = base_url()."Qa_ameriflex/download_qa_ameriflex_CSV/";	
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
	 

	public function download_qa_ameriflex_CSV()
	{
		$currDate=date("Y-m-d");
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$newfile="QA Ameriflex Audit List-'".$currDate."'.csv";
		header('Content-Disposition: attachment;  filename="'.$newfile.'"');
		readfile($filename);
	}


	public function create_qa_ameriflex_CSV($rr)
	{
		$currDate=date("Y-m-d");
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$fopen = fopen($filename,"w+");
		
		$header = array("Auditor Name", "Audit Date", "Agent", "Fusion ID", "L1 Super", "Call Date", "Call Duration", "Type", "Interaction ID", "Audit Type", "Auditor Type", "VOC", "Earned Score", "Possible Score","Overall Score",
		"Has the caller been properly greeted and verified?", "Did we show empathy/sympathy when necessary if applicable?", "Did we adjust to the callers pace and demeanor?", "Did we use the callers name two times throughout the call?", "Did we sound as though we wanted to assist the caller?", "Did we avoid interruptions and speaking over the caller?", "Did we use thank yous and apologies as appropriate?", "Did we own the issue ?", "Did we avoid dead air?", "Did we confirm/update callers contact information?", "Did we communicate all appropriate timelines and steps?", "Did we repeat the callers question/issue verify or confirm our understanding?", "Did we provide professional accurate details via call/chat?", "Did we take appropriate actions in Ameriflex Systems?", "Did we demonstrate appropriate use of the hold process?", "Did we avoid internal jargon?", "Did we validate if the issue/question was resolved?", "Did we ask if any additional assistance is needed?", "Did we properly close the call?",
		"Remarks 1", "Remarks 2", "Remarks 3", "Remarks 4", "Remarks 5", "Remarks 6", "Remarks 7", "Remarks 8", "Remarks 9", "Remarks 10", "Remarks 11", "Remarks 12", "Remarks 13", "Remarks 14", "Remarks 15", "Remarks 16", "Remarks 17", "Remarks 18", "Remarks 19",
		"Call Summary", "Feedback","Agent Feedback Acceptance", "Agent Review Date","Agent Comment","Mgnt Review Date","Mgnt Review By", "Mgnt Comment");
		
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
			$row .= '"'.$user['type'].'",';
			$row .= '"'.$user['interaction_id'].'",';
			$row .= '"'.$user['audit_type'].'",';
			$row .= '"'.$user['auditor_type'].'",';
			$row .= '"'.$user['voc'].'",';	
			$row .= '"'.$user['earned_score'].'",';
			$row .= '"'.$user['possible_score'].'",';
			$row .= '"'.$user['overall_score'].'",';
			$row .= '"'.$user['caller_properly_greed'].'",';
			$row .= '"'.$user['show_empathy_sympathy'].'",';
			$row .= '"'.$user['adjust_caller_pace'].'",';
			$row .= '"'.$user['use_caller_name_two_times'].'",';
			$row .= '"'.$user['sound_though_assist_caller'].'",';
			$row .= '"'.$user['avoid_interruption_caller_speaking'].'",';
			$row .= '"'.$user['use_thatnk_you_appologies'].'",';
			$row .= '"'.$user['own_the_issue'].'",';
			$row .= '"'.$user['avoid_dead_air'].'",';
			$row .= '"'.$user['confirm_caller_contact'].'",';
			$row .= '"'.$user['communicate_timelines'].'",';
			$row .= '"'.$user['repeat_caller_question_issue'].'",';
			$row .= '"'.$user['provide_professional_accurate'].'",';
			$row .= '"'.$user['take_appropiate_actiona'].'",';
			$row .= '"'.$user['demonstrate_appropiate_hold_process'].'",';
			$row .= '"'.$user['avoid_internal_jargon'].'",';
			$row .= '"'.$user['validate_issue_was_resolved'].'",';
			$row .= '"'.$user['ask_any_additional_assistance'].'",';
			$row .= '"'.$user['properly_close_the_call'].'",';
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
 
