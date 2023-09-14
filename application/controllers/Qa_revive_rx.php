<?php 

 class Qa_revive_rx extends CI_Controller{
	
	public function __construct(){
		parent::__construct();
		$this->load->model('user_model');
		$this->load->model('Common_model');
		$this->load->model('Qa_vrs_model');
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
// nur_upload_files
  private function revive_rx_upload_files($files,$path)   // this is for file uploaging
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

    private function edu_upload_files($files,$path)
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
	
	public function index(){
		if(check_logged_in())
		{
			$current_user = get_user_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_revive_rx/qa_revive_rx_feedback.php";
			$data["content_js"] = "qa_revive_rx_inbound_js.php";	
			//$data["content_js"] = "qa_clio_js.php";		

			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM signin where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_process(id,649) and status=1 order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);	
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
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_revive_rx_inbound_feedback $cond) xx Left Join
				(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";
				// qa_revive_rx_inbound_feedback
			$data["revive_rx_list"] = $this->Common_model->get_query_result_array($qSql);


			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_revive_rx_new_feedback $cond) xx Left Join
				(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";
				// qa_revive_rx_inbound_feedback
			$data["revive_rx_new_list"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_revive_rx_inbound_feedback $cond) xx Left Join
				(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";
				// qa_revive_rx_inbound_feedback
			$data["revive_rx_inbound_data"] = $this->Common_model->get_query_result_array($qSql);

			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			
			$this->load->view("dashboard",$data);
		}
	}

//////////////////////Revive Rx Audit//////////////////////////////

	//revive_rx_id
	public function add_edit_revive_rx($revive_rx_id){

		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_revive_rx/add_edit_revive_rx.php";
			$data["content_js"] = "qa_revive_rx_js.php";	
			//$data["content_js"] = "qa_add_nurture_js.php";
			//$data["content_js"] = "qa_cars24_js.php";
			$data['revive_rx_id']=$revive_rx_id;
			$tl_mgnt_cond='';
			if(get_role_dir()=='manager' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";
			}else if(get_role_dir()=='tl' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and assigned_to='$current_user'";
			}else{
				$tl_mgnt_cond="";
			}
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client(id,304) and is_assign_process(id,649) and status=1 order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			//is_assign_process(id,529)
			$qSql = "SELECT id, fname, lname, fusion_id, office_id FROM signin where role_id in (select id from role where (folder in ('tl','trainer','am','manager')) or (name in ('Client Services'))) and status=1";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
				from qa_revive_rx_inbound_feedback where id='$revive_rx_id') xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
			$data["revive_rx"] = $this->Common_model->get_query_row_array($qSql);
			 //qa_revive_rx_inbound_feedback

			$curDateTime=CurrMySqlDate();
			$a = array();
			
			$field_array['agent_id']=!empty($_POST['data']['agent_id'])?$_POST['data']['agent_id']:"";
			
			if($field_array['agent_id']){
				
				if($revive_rx_id==0){
					$field_array=$this->input->post('data');
					$field_array['audit_date']=CurrDate();
					$field_array['entry_date']=$curDateTime;
					$field_array['call_date']=mmddyy2mysql($this->input->post('call_date'));
					$field_array['audit_start_time']=$this->input->post('audit_start_time');
					$a = $this->revive_rx_upload_files($_FILES['attach_file'], $path='./qa_files/nurture_farms/');
					$field_array["attach_file"] = implode(',',$a);
					$rowid= data_inserter('qa_revive_rx_inbound_feedback',$field_array);
				
					if(get_login_type()=="client"){
						$current_user=get_user_id();
						$add_array = array("client_entryby" => $current_user);
					}else{
						$current_user=get_user_id();
						$add_array = array("entry_by" => $current_user);
					}
					$this->db->where('id', $rowid);
					$this->db->update('qa_revive_rx_inbound_feedback',$add_array);
					/*******************Fatal Call Email Send functionality added on 12-12-22 START ***********************/
					if($field_array['overall_score'] == 0){
						$tablename = "qa_revive_rx_inbound_feedback";
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
						$to = 'Gustavo.Diaz@fusionbposervices.com,walter.miranda@fusionbposervices.com,rene.martinez@fusionbposervices.com,Diego.Quezada@fusionbposervices.com,aaron.munguia@fusionbposervices.com,Roxana.Martinez@fusionbposervices.com,amitabh.vartak@fusionbposervices.com,ashish.tere@fusionbposervices.com,Faisal.Anwar@fusionbposervices.com';
						$ebody = "Hello ". $result['tl_fullname'].",<br>";
						$ebody .= "<p>Agent Name : ".$result['fullname']."</p>";
						
						$ebody .= "<p>Call ID :  ".$result['call_id']."</p>";
						$ebody .= "<p>Total Talk time : ".$result['call_duration']."</p>";
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
					/*******************Fatal Call Email Send functionality added on 12-12-22 END ***********************/
					
				}else{
					$field_array1=$this->input->post('data');
					$field_array1['call_date']=mmddyy2mysql($this->input->post('call_date'));
					$this->db->where('id', $revive_rx_id);
					$this->db->update('qa_revive_rx_inbound_feedback',$field_array1);
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
					$this->db->where('id', $revive_rx_id);
					$this->db->update('qa_revive_rx_inbound_feedback',$edit_array);
					
				}
				redirect('qa_revive_rx');
			}
			$data["array"] = $a;
			$this->load->view("dashboard",$data);
		}
	}


	/////////////////////////////////////////////New Revive Audit///////////////////////////

	public function add_edit_revive_rx_new($revive_rx_id){

		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_revive_rx/add_edit_revive_rx_new.php";
			$data["content_js"] = "qa_revive_rx_js.php";	
			//$data["content_js"] = "qa_add_nurture_js.php";
			//$data["content_js"] = "qa_cars24_js.php";
			$data['revive_rx_id']=$revive_rx_id;
			$tl_mgnt_cond='';
			if(get_role_dir()=='manager' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";
			}else if(get_role_dir()=='tl' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and assigned_to='$current_user'";
			}else{
				$tl_mgnt_cond="";
			}
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client(id,304) and is_assign_process(id,649) and status=1 order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			//is_assign_process(id,529)
			$qSql = "SELECT id, fname, lname, fusion_id, office_id FROM signin where role_id in (select id from role where (folder in ('tl','trainer','am','manager')) or (name in ('Client Services'))) and status=1";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
				from qa_revive_rx_new_feedback where id='$revive_rx_id') xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
			$data["revive_rx"] = $this->Common_model->get_query_row_array($qSql);
			 //qa_revive_rx_inbound_feedback

			$curDateTime=CurrMySqlDate();
			$a = array();
			
			$field_array['agent_id']=!empty($_POST['data']['agent_id'])?$_POST['data']['agent_id']:"";
			
			if($field_array['agent_id']){
				
				if($revive_rx_id==0){
					$field_array=$this->input->post('data');
					$field_array['audit_date']=CurrDate();
					$field_array['entry_date']=$curDateTime;
					$field_array['call_date']=mmddyy2mysql($this->input->post('call_date'));
					$field_array['audit_start_time']=$this->input->post('audit_start_time');
					$a = $this->revive_rx_upload_files($_FILES['attach_file'], $path='./qa_files/nurture_farms/');
					$field_array["attach_file"] = implode(',',$a);
					$rowid= data_inserter('qa_revive_rx_new_feedback',$field_array);
				
					if(get_login_type()=="client"){
						$current_user=get_user_id();
						$add_array = array("client_entryby" => $current_user);
					}else{
						$current_user=get_user_id();
						$add_array = array("entry_by" => $current_user);
					}
					$this->db->where('id', $rowid);
					$this->db->update('qa_revive_rx_new_feedback',$add_array);
					/*******************Fatal Call Email Send functionality added on 12-12-22 START ***********************/
					if($field_array['overall_score'] == 0){
						$tablename = "qa_revive_rx_new_feedback";
						$sql = "SELECT tname.*, ip.email_id_off, ip_tl.email_id_off as tl_email, concat(s.fname, ' ', s.lname) as fullname,
							(SELECT concat(tls.fname, ' ', tls.lname) as tl_fullname FROM signin tls WHERE tls.id=tname.tl_id) as tl_fullname
							FROM $tablename tname
							LEFT JOIN info_personal ip ON ip.user_id=tname.agent_id 
							LEFT JOIN signin s ON s.id=tname.agent_id
							LEFT JOIN signin tl ON tl.id = tname.tl_id
							LEFT JOIN info_personal ip_tl ON ip_tl.user_id = tname.tl_id
							WHERE tname.id=$rowid";
						$result= $this->Common_model->get_query_row_array($sql);				
						$sqlParam ="SELECT process_id,params_columns, fatal_param,param_column_desc FROM qa_defect where table_name='$tablename'"; 
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
						$to = 'Gustavo.Diaz@fusionbposervices.com,walter.miranda@fusionbposervices.com,rene.martinez@fusionbposervices.com,Diego.Quezada@fusionbposervices.com,aaron.munguia@fusionbposervices.com,Roxana.Martinez@fusionbposervices.com,amitabh.vartak@fusionbposervices.com,ashish.tere@fusionbposervices.com,Faisal.Anwar@fusionbposervices.com';
						$ebody = "Hello ". $result['tl_fullname'].",<br>";
						$ebody .= "<p>Agent Name : ".$result['fullname']."</p>";
						
						$ebody .= "<p>Call ID :  ".$result['call_id']."</p>";
						$ebody .= "<p>Total Talk time : ".$result['call_duration']."</p>";
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
						$eccA[]="danish.khan@fusionbposervices.com";
						$eccA[]="sumitra.bagchi@omindtech.com";
						$eccA[]="anshuman.sarkar@fusionbposervices.com";
						$ecc = implode(',',$eccA);
						$path = "";
						$from_email="";
						$from_name="";
						//echo $esubject."<br>";
						//echo $ebody."<br>";
						//exit;
						$send = $this->Email_model->send_email_sox("",$to, $ecc, $ebody, $esubject, $path, $from_email, $from_name, $isBcc="Y");
						unset($eccA);
					}
					/*******************Fatal Call Email Send functionality added on 12-12-22 END ***********************/
					
				}else{
					$field_array1=$this->input->post('data');
					$field_array1['call_date']=mmddyy2mysql($this->input->post('call_date'));
					$this->db->where('id', $revive_rx_id);
					$this->db->update('qa_revive_rx_new_feedback',$field_array1);
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
					$this->db->where('id', $revive_rx_id);
					$this->db->update('qa_revive_rx_new_feedback',$edit_array);
					
				}
				redirect('qa_revive_rx');
			}
			$data["array"] = $a;
			$this->load->view("dashboard",$data);
		}
	}

	//////////////////////////////////vikas ///End///////////////////////////////////////////////

	public function add_edit_revive_rx_inbound($revive_rx_inbound_id){
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();

			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_revive_rx/add_edit_revive_rx_inbound.php";
			$data["content_js"] = "qa_revive_rx_inbound_js.php";
			//$data["content_js"] = "qa_clio_js.php";
			$data['revive_rx_inbound_id']=$revive_rx_inbound_id;
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

			$qSql = "SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,304) and is_assign_process(id,649) and status=1  order by name";
	      $data['agentName'] = $this->Common_model->get_query_result_array( $qSql );

			$qSql = "SELECT id, fname, lname, fusion_id, office_id FROM signin where role_id in (select id from role where (folder in ('tl','trainer','am','manager')) or (name in ('Client Services'))) and status=1";

			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);

			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
				from qa_revive_rx_inbound_feedback where id='$revive_rx_inbound_id') xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
			$data["revive_rx_inbound_data"] = $this->Common_model->get_query_row_array($qSql);

			$curDateTime=CurrMySqlDate();
			$a = array();

			$field_array['agent_id']=!empty($_POST['data']['agent_id'])?$_POST['data']['agent_id']:"";

			if($field_array['agent_id']){

				if($revive_rx_inbound_id==0){
					$field_array=$this->input->post('data');
					$field_array['audit_date']=CurrDate();
					$field_array['call_date']=mmddyy2mysql($this->input->post('call_date'));
					$field_array['entry_date']=$curDateTime;
					$field_array['audit_start_time']=$this->input->post('audit_start_time');
					
					if($_FILES['attach_file']['tmp_name'][0]!=''){
						$a = $this->revive_rx_upload_files($_FILES['attach_file'], $path='./qa_files/revive_rx_inbound/');
						$field_array["attach_file"] = implode(',',$a);
					}

					$rowid= data_inserter('qa_revive_rx_inbound_feedback',$field_array);
					if(get_login_type()=="client"){
						$add_array = array("client_entryby" => $current_user);
					}else{
						$add_array = array("entry_by" => $current_user);
					}
					$this->db->where('id', $rowid);
					$this->db->update('qa_revive_rx_inbound_feedback',$add_array);

				}else{

					$field_array1=$this->input->post('data');
					$field_array1['call_date']=mmddyy2mysql($this->input->post('call_date'));
					if($_FILES['attach_file']['tmp_name'][0]!=''){
						if(!file_exists("./qa_files/revive_rx_inbound/")){
							mkdir("./qa_files/revive_rx_inbound/");
						}
						$a = $this->revive_rx_upload_files( $_FILES['attach_file'], $path = './qa_files/revive_rx_inbound/' );
						$field_array1['attach_file'] = implode( ',', $a );
					}

					$this->db->where('id', $revive_rx_inbound_id);
					$this->db->update('qa_revive_rx_inbound_feedback',$field_array1);
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
					$this->db->where('id', $revive_rx_inbound_id);
					$this->db->update('qa_revive_rx_inbound_feedback',$edit_array);

						/* Randamiser section */
					if($rand_id!=0){
						$rand_cdr_array = array("audit_status" => 1);
						$this->db->where('id', $rand_id);
						$this->db->update('qa_randamiser_general_data',$rand_cdr_array);
						
						$rand_array = array("is_rand" => 1);
						$this->db->where('id', $rowid);
						$this->db->update('qa_revive_rx_inbound_feedback',$rand_array);
					}

				}

				if(isset($rand_data['upload_date']) && !empty($rand_data['upload_date'])){
					$up_date = date('Y-m-d', strtotime($rand_data['upload_date']));
					redirect('Impoter_xls/data_distribute?from_date='.$up_date.'&client_id='.$client_id.'&pro_id='.$pro_id.'&submit=Submit');
				}else{
					redirect('Qa_revive_rx');
				}

				
			}
			$data["array"] = $a;

			$this->load->view("dashboard",$data);
		}
	}



// ///////////////////////////////////////////////////////////////////////////////////////////	 
// ////////////////////////////////////// QA  REPORT //////////////////////////////////////	
// ///////////////////////////////////////////////////////////////////////////////////////////

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

/////////////////Revive Rx Agent part//////////////////////////	

	public function agent_revive_rx_feedback(){
		if(check_logged_in())
		{
			$current_user = get_user_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_revive_rx/agent_revive_rx_feedback.php";
			
			$data["content_js"] = "qa_revive_rx_inbound_js.php";
			//$data["content_js"] = "qa_revive_rx_js.php";	
			$data["agentUrl"] = "qa_revive_rx/agent_revive_rx_feedback";
			
			$qSql="Select count(id) as value from qa_revive_rx_inbound_feedback where agent_id='$current_user' and audit_type not in ('Calibration', 'Pre-Certificate Mock Call', 'Certification Audit','QA Supervisor Audit')";
			$data["tot_feedback"] =  $this->Common_model->get_single_value($qSql);
			$qSql="Select count(id) as value from qa_revive_rx_inbound_feedback where agent_rvw_date is null and agent_id='$current_user' and audit_type not in ('Calibration', 'Pre-Certificate Mock Call', 'Certification Audit','QA Supervisor Audit')";
			$data["yet_rvw"] =  $this->Common_model->get_single_value($qSql);


			$qSql="Select count(id) as value from qa_revive_rx_new_feedback where agent_id='$current_user'";
			$data["tot_feedback_new"] =  $this->Common_model->get_single_value($qSql);

			$qSql="Select count(id) as value from qa_revive_rx_new_feedback where agent_rvw_date is null and agent_id='$current_user'";
			$data["yet_rvw_new"] =  $this->Common_model->get_single_value($qSql);

			$qSql="Select count(id) as value from qa_revive_rx_inbound_feedback where agent_id='$current_user' and audit_type not in ('Calibration', 'Pre-Certificate Mock Call', 'Certification Audit','QA Supervisor Audit')";
			$data["tot_agent_inbound_feedback"] =  $this->Common_model->get_single_value($qSql);

			$qSql="Select count(id) as value from qa_revive_rx_inbound_feedback where agent_rvw_date is null and agent_id='$current_user' and audit_type not in ('Calibration', 'Pre-Certificate Mock Call', 'Certification Audit','QA Supervisor Audit')";

			$data["tot_agent_inbound_yet_rvw"] =  $this->Common_model->get_single_value($qSql);

			
			$from_date = '';
			$to_date = '';
			$cond="";

			
			if($this->input->get('btnView')=='View')
			{
				$from_date = mmddyy2mysql($this->input->get('from_date'));
				$to_date = mmddyy2mysql($this->input->get('to_date'));
				
				if($from_date !="" && $to_date!=="" )  $cond= " Where (audit_date >= '$from_date' and audit_date <= '$to_date') and agent_id='$current_user' And audit_type not in ('Calibration', 'Pre-Certificate Mock Call','QA Supervisor Audit', 'Certification Audit')";

				$qSql = "SELECT * from
					(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
					(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
					(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
					(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_revive_rx_inbound_feedback $cond) xx Left Join
					(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid) order by audit_date";
				$data["agent_rvw_list"] = $this->Common_model->get_query_result_array($qSql);

				$qSql = "SELECT * from
					(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
					(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
					(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
					(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_revive_rx_new_feedback $cond) xx Left Join
					(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid) order by audit_date";
				$data["agent_rvw_list_new"] = $this->Common_model->get_query_result_array($qSql);

				$qSql = "SELECT * from
					(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
					(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
					(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
					(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_revive_rx_inbound_feedback $cond) xx Left Join
					(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid) order by audit_date";
				$data["agent_rvw_list_inbound"] = $this->Common_model->get_query_result_array($qSql);

			}else{
				$qSql = "SELECT * from
					(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
					(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
					(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
					(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_revive_rx_inbound_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit')) xx Left Join
					(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid) Where xx.agent_rvw_date is Null";
				$data["agent_rvw_list"] = $this->Common_model->get_query_result_array($qSql);

				$qSql = "SELECT * from
					(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
					(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
					(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
					(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_revive_rx_new_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit')) xx Left Join
					(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid) Where xx.agent_rvw_date is Null";
				$data["agent_rvw_list_new"] = $this->Common_model->get_query_result_array($qSql);

				$qSql = "SELECT * from
					(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
					(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
					(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
					(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_revive_rx_inbound_feedback where agent_id='$current_user' And audit_type not in ('Calibration', 'Pre-Certificate Mock Call','QA Supervisor Audit', 'Certification Audit')) xx Left Join
					(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid) ";
					//Where xx.agent_rvw_date is Null
				$data["agent_rvw_list_inbound"] = $this->Common_model->get_query_result_array($qSql);
			}
			$campaign="";
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			$data['campaign']=$campaign;
			$this->load->view("dashboard",$data);
		}
	}
	
	public function agent_revive_rx_feedback_rvw($id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_revive_rx/agent_revive_rx_feedback_rvw.php";
			$data["content_js"] = "qa_revive_rx_js.php";
			$data["agentUrl"] = "qa_revive_rx/agent_revive_rx_feedback";
			$data["revive_rx_id"]=$id;	
			
			$qSql="SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, (select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_name,agent_rvw_note as agent_note,mgnt_rvw_note as mgnt_note from qa_revive_rx_inbound_feedback where id=$id) xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to from signin) yy on (xx.agent_id=yy.sid) order by audit_date";
			$data["revive_rx"] = $this->Common_model->get_query_row_array($qSql);
			
			if($this->input->post('revive_rx_id'))
			{
				$revive_rx_id=$this->input->post('revive_rx_id');
				$curDateTime=CurrMySqlDate();
				$log=get_logs();
				
				$field_array=array(
					"agnt_fd_acpt" => $this->input->post('agnt_fd_acpt'),
					"agent_rvw_note" => $this->input->post('note'),
					"agent_rvw_date" => $curDateTime
				);
				$this->db->where('id', $revive_rx_id);
				$this->db->update('qa_revive_rx_inbound_feedback',$field_array);
				redirect('qa_revive_rx/agent_revive_rx_feedback');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}	

	public function agent_revive_rx_feedback_rvw_new($id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_revive_rx/agent_revive_rx_feedback_rvw_new.php";
			$data["content_js"] = "qa_revive_rx_js.php";
			$data["agentUrl"] = "qa_revive_rx/agent_revive_rx_feedback";
			$data["revive_rx_id"]=$id;	
			
			$qSql="SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, (select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_name,agent_rvw_note as agent_note,mgnt_rvw_note as mgnt_note from qa_revive_rx_new_feedback where id=$id) xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to from signin) yy on (xx.agent_id=yy.sid) order by audit_date";
			$data["revive_rx"] = $this->Common_model->get_query_row_array($qSql);
			
			if($this->input->post('revive_rx_id'))
			{
				$revive_rx_id=$this->input->post('revive_rx_id');
				$curDateTime=CurrMySqlDate();
				$log=get_logs();
				
				$field_array=array(
					"agnt_fd_acpt" => $this->input->post('agnt_fd_acpt'),
					"agent_rvw_note" => $this->input->post('note'),
					"agent_rvw_date" => $curDateTime
				);
				$this->db->where('id', $revive_rx_id);
				$this->db->update('qa_revive_rx_new_feedback',$field_array);
				redirect('qa_revive_rx/agent_revive_rx_feedback');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}

	public function agent_revive_rx_feedback_rvw_inbound($revive_rx_inbound_id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_revive_rx/agent_revive_rx_feedback_rvw_inbound.php";
			$data["content_js"] = "qa_revive_rx_inbound_js.php";
			$data["agentUrl"] = "qa_revive_rx/agent_revive_rx_feedback";
			$data["revive_rx_inbound_id"]=$revive_rx_inbound_id;

			$qSql = "SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,304) and is_assign_process(id,649) and status=1  order by name";
	      	$data['agentName'] = $this->Common_model->get_query_result_array( $qSql );	
			
			$qSql="SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, (select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_name,agent_rvw_note as agent_note,mgnt_rvw_note as mgnt_note from qa_revive_rx_inbound_feedback where id=$revive_rx_inbound_id) xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to from signin) yy on (xx.agent_id=yy.sid) order by audit_date";
			$data["revive_rx_inbound_data"] = $this->Common_model->get_query_row_array($qSql);
			
			if($this->input->post('revive_rx_inbound_id'))
			{
				$revive_rx_inbound_id=$this->input->post('revive_rx_inbound_id');
				$curDateTime=CurrMySqlDate();
				$log=get_logs();
				
				$field_array=array(
					"agnt_fd_acpt" => $this->input->post('agnt_fd_acpt'),
					"agent_rvw_note" => $this->input->post('note'),
					"agent_rvw_date" => $curDateTime
				);
				$this->db->where('id', $revive_rx_inbound_id);
				$this->db->update('qa_revive_rx_inbound_feedback',$field_array);
				redirect('qa_revive_rx/agent_revive_rx_feedback');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}
//////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////// Revive Rx ////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////
	public function qa_revive_rx_report(){
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
			$data["content_template"] = "reports_qa/qa_revive_rx_report.php";
			$data["content_js"] = "qa_revive_rx_inbound_js.php";

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

			$data["qa_revive_rx_list"] = array();

			if($this->input->get('show')=='Show')
			{
				$date_from 	= mmddyy2mysql($this->input->get('date_from'));
				$date_to 	= mmddyy2mysql($this->input->get('date_to'));
				$office_id 	= $this->input->get('office_id');
				$audit_type = $this->input->get('audit_type');
				$campaign 	= $this->input->get('campaign');

				if($date_from !="" && $date_to!=="" )  $cond= " Where (audit_date >= '$date_from' and audit_date <= '$date_to' )";

				if($office_id=="All") $cond .= "";
				else $cond .=" and office_id='$office_id'";

				// if($audit_type=="All"){
				// 	if(get_login_type()=="client"){
				// 		$cond .= "audit_type not in ('Operation Audit','Trainer Audit')";
				// 	}else{
				// 		$cond .= "";
				// 	}
				// }else{
				// 	$cond .=" and audit_type='$audit_type'";
				// }

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
				$data["qa_revive_rx_list"] = $fullAray;
				$this->create_qa_revive_rx_CSV($fullAray,$campaign);
				$dn_link = base_url()."Qa_revive_rx/download_qa_revive_rx_CSV/";
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


	public function download_qa_revive_rx_CSV()
	{
		$currDate=date("Y-m-d");
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$newfile="QA Revive Rx Audit List-'".$currDate."'.csv";
		header('Content-Disposition: attachment;  filename="'.$newfile.'"');
		readfile($filename);
	}

	public function create_qa_revive_rx_CSV($rr,$campaign)
	{
		$currDate=date("Y-m-d");
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$currentURL = base_url();
		$controller = "qa_revive_rx";
		
		$fopen = fopen($filename,"w+");
		if($campaign == 'revive_rx')
		{
			////////////////////////////////////////////////////////
			$header = array("Auditor Name", "Audit Date","L1 Supervisor:" ,"Agent", "Fusion ID","Call Id","Call Duration","Contact Number","Audit Type","VOC","Audit Link","Audit Start Date Time", "Audit End Date Time", "Interval(in sec)","Possible Score","Earned Score","Overall Score","Did the agent confirm the shipping address before transfer the call?","Did the agent used soft skills during the call?","Did the agent send a text message and leave voice mail?","Did the agent used all phone numbers on the account to contact the patient?","Did the agent confirm the payment method and ask for authorization to process the payment?","Did the agent leave proper notes on the account?","Did the agent check the account to make sure that a call was needed?","Did the agent adhere properly to the hold/dead air policy?","Did the agent use a warm transfer?", "Did the agent cerify the patiente identity before provide details of the prescription?","Remarks1","Remarks2","Remarks3","Remarks4","Remarks5","Remarks6","Remarks7","Remarks8","Remarks9","Remarks10","Call Summary","Remark","Agent Feedback Acceptance","Agent Review Date","Agent Comment", "Mgnt Review Date","Mgnt Review By", "Mgnt Comment", "Client Review Date", "Client Review Name", "Client Review Note");
		}else if($campaign=='revive_rx_new'){
			$header = array("Auditor Name", "Audit Date","L1 Supervisor:" ,"Agent", "Fusion ID","Call Id","Call Duration","Contact Number","Audit Type","VOC","Audit Link","Audit Start Date Time", "Audit End Date Time", "Interval(in sec)","Possible Score","Earned Score","Overall Score","Used proper opening providing pharmacy's name and asking for patient's name","Soft skills","Did not over talk the customer","Tone was warm and genuine throughout the call","Took ownweship and sounded confident and creditable throughout the call","Verified patients current contact information","Verifed and updated personal information","Provided accurate and complete information","Followed proper hold and transfer procedures", "Left appropiate notes on the account","Asked for authorization to process the payment and fill the medication if needed","Verified allergies and intolerances","Left voicemail and sent text message (Unable to contact patient)","Closed the call positively","Propertly authenticates (Complete shipping address and DOB)","Navigated effectively through the sytem (Verify if call is needed)",
				"Used proper opening providing pharmacy's name and asking for patient's name Remarks1","Soft skills Remarks2","Did not over talk the customer Remarks3","Tone was warm and genuine throughout the call Remarks4","Took ownweship and sounded confident and creditable throughout the call Remarks5","Verified patients current contact information Remarks6","Verifed and updated personal information Remarks7","Provided accurate and complete information Remarks8","Followed proper hold and transfer procedures Remarks9","Left appropiate notes on the account Remarks10","Asked for authorization to process the payment and fill the medication if needed Remarks11","Verified allergies and intolerances Remarks12","Left voicemail and sent text message (Unable to contact patient) Remarks13","Closed the call positively Remarks14","Propertly authenticates (Complete shipping address and DOB) Remarks15","Navigated effectively through the sytem (Verify if call is needed) Remarks16","Call Summary","Remark","Agent Feedback Acceptance","Agent Review Date","Agent Comment", "Mgnt Review Date","Mgnt Review By", "Mgnt Comment", "Client Review Date", "Client Review Name", "Client Review Note");
		}else if($campaign=='revive_rx_inbound'){
			$header = array("Auditor Name", "Audit Date","L1 Supervisor:" ,"Agent", "Fusion ID","Call Id","Call Duration","Contact Number","Audit Type","VOC","Call Type","Audit Link","Audit Start Date Time", "Audit End Date Time", "Interval(in sec)","Possible Score","Earned Score","Overall Score",
				"Soft skills:Used proper opening providing pharmacys name and asking for patients name",
				"Remarks1",
				"Soft skills:Did we use polite vocabulary (Thank you and appologies)",
				"Remarks2",
				"Soft skills:Did not overtalk the costumer",
				"Remarks3",
				"Soft skills:The agent adjust and speaks with a strong steady speed or pace",
				"Remarks4",
				"Soft skills:Tone was warm and genuine throughout the call",
				"Remarks5",
				"Soft skills:Took ownership and sounded confident and creditable throughout the call",
				"Remarks6",
				"Soft skills:Did we avoid dead air",
				"Remarks7",
				"Compliance:Verified Patients current contact information",
				"Remarks8",
				"Compliance:Verified and gather patient information",
				"Remarks9",
				"Compliance:Provided accurate and complete information",
				"Remarks10",
				"Compliance:Agent asked for claryfing and probing questions",
				"Remarks11",
				"Compliance:Followed proper hold and transder procedures",
				"Remarks12",
				"Compliance:Left appropiate notes in the account",
				"Remarks13",
				"Compliance:Update the system acordingly (TXT messages assessment allergies future tasks pay simple payment)",
				"Remarks14",
				"Compliance:Confirmed the total amount asked for authorization to process the payment and fill.",
				"Remarks15",
				"Compliance:Left voicemail and sent TXT message (unable to contact patient).",
				"Remarks16",
				"Compliance:Did we ask If additional assitance was needed.",
				"Remarks17",
				"Compliance:Closed the call positively.",
				"Remarks18",
				"Business Critical-Fatal:Propertly authenticates (Complete shipping address and DOB)",
				"Remarks19",
				"Business Critical-Fatal:Navigated effectively through the system (Verify if calls is needed)",
				"Remarks20",
				"Call Summary","Remark","Agent Feedback Acceptance","Agent Review Date","Agent Comment", "Mgnt Review Date","Mgnt Review By", "Mgnt Comment", "Client Review Date", "Client Review Name", "Client Review Note");
		}

			$row = "";
			foreach($header as $data) $row .= ''.$data.',';
			fwrite($fopen,rtrim($row,",")."\r\n");
			$searches = array("\r", "\n", "\r\n");

			if($campaign=='revive_rx'){
			$edit_url = "add_edit_revive_rx";
		    $main_url =  $currentURL.''.$controller.'/'.$edit_url;

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
				$row .= '"'.$user['tl_name'].'",';
				$row .= '"'.$user['fname']." ".$user['lname'].'",';
				$row .= '"'.$user['fusion_id'].'",';
				$row .= '"'.$user['call_id'].'",';
				$row .= '"'.$user['call_duration'].'",';
				$row .= '"'.$user['customer_contact_number'].'",';
				$row .= '"'.$user['audit_type'].'",';
				$row .= '"'.$user['voc'].'",';
				$row .= '"'.$main_urls.'",';
				$row .= '"'.$user['audit_start_time'].'",';
				$row .= '"'.$user['entry_date'].'",';
				$row .= '"'.$interval1.'",';
				$row .= '"'.$user['possible_score'].'%'.'",';
				$row .= '"'.$user['earned_score'].'%'.'",';
				$row .= '"'.$user['overall_score'].'%'.'",';
				$row .= '"'.$user['confirm_shipping_address'].'",';
				$row .= '"'.$user['soft_skills'].'",';
				$row .= '"'.$user['voice_mail'].'",';
				$row .= '"'.$user['contact_patient'].'",';
				$row .= '"'.$user['payment_confirm'].'",';
				$row .= '"'.$user['proper_note'].'",';
				$row .= '"'.$user['verify_call'].'",';
				$row .= '"'.$user['hold'].'",';
				$row .= '"'.$user['warm_transfer'].'",';
				$row .= '"'.$user['validate_account'].'",';
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
		}if($campaign=='revive_rx_new'){
			$edit_url = "add_edit_revive_rx_new";
		    $main_url =  $currentURL.''.$controller.'/'.$edit_url;

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
				$row .= '"'.$user['tl_name'].'",';
				$row .= '"'.$user['fname']." ".$user['lname'].'",';
				$row .= '"'.$user['fusion_id'].'",';
				$row .= '"'.$user['call_id'].'",';
				$row .= '"'.$user['call_duration'].'",';
				$row .= '"'.$user['customer_contact_number'].'",';
				$row .= '"'.$user['audit_type'].'",';
				$row .= '"'.$user['voc'].'",';
				$row .= '"'.$main_urls.'",';
				$row .= '"'.ConvServerToLocal($user['audit_start_time']).'",';
				$row .= '"'.ConvServerToLocal($user['entry_date']).'",';
				$row .= '"'.$interval1.'",';
				$row .= '"'.$user['possible_score'].'%'.'",';
				$row .= '"'.$user['earned_score'].'%'.'",';
				$row .= '"'.$user['overall_score'].'%'.'",';
				$row .= '"'.$user['patients_name'].'",';
				$row .= '"'.$user['Soft_skills'].'",';
				$row .= '"'.$user['the_customer'].'",';
				$row .= '"'.$user['throughout_the_call'].'",';
				$row .= '"'.$user['creditable_throughout'].'",';
				$row .= '"'.$user['contact_information'].'",';
				$row .= '"'.$user['personalinformation'].'",';
				$row .= '"'.$user['complete_information'].'",';
				$row .= '"'.$user['transfer_procedures'].'",';
				$row .= '"'.$user['the_account'].'",';
				$row .= '"'.$user['if_needed'].'",';
				$row .= '"'.$user['and_intolerances'].'",';
				$row .= '"'.$user['text_message'].'",';
				$row .= '"'.$user['call_positively'].'",';
				$row .= '"'.$user['Propertly_authenticates'].'",';
				$row .= '"'.$user['Navigated_effectively'].'",';
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
		if($campaign=='revive_rx_inbound'){
			$edit_url = "add_edit_revive_rx_inbound";
		    $main_url =  $currentURL.''.$controller.'/'.$edit_url;

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
				$row .= '"'.$user['tl_name'].'",';
				$row .= '"'.$user['fname']." ".$user['lname'].'",';
				$row .= '"'.$user['fusion_id'].'",';
				$row .= '"'.$user['call_id'].'",';
				$row .= '"'.$user['call_duration'].'",';
				$row .= '"'.$user['contact_no'].'",';
				$row .= '"'.$user['audit_type'].'",';
				$row .= '"'.$user['voc'].'",';
				$row .= '"'.$user['call_type'].'",';
				$row .= '"'.$main_urls.'",';
				$row .= '"'.ConvServerToLocal($user['audit_start_time']).'",';
				$row .= '"'.ConvServerToLocal($user['entry_date']).'",';
				$row .= '"'.$interval1.'",';
				$row .= '"'.$user['possible_score'].'%'.'",';
				$row .= '"'.$user['earned_score'].'%'.'",';
				$row .= '"'.$user['overall_score'].'%'.'",';
				$row .= '"'.$user['proper_opening'].'",';
				$row .= '"'.$user['cmt1'].'",';
				$row .= '"'.$user['polite_vocabulary'].'",';
				$row .= '"'.$user['cmt2'].'",';
				$row .= '"'.$user['overtalk_customer'].'",';
				$row .= '"'.$user['cmt3'].'",';
				$row .= '"'.$user['speaks_strong'].'",';
				$row .= '"'.$user['cmt4'].'",';
				$row .= '"'.$user['tone_warm'].'",';
				$row .= '"'.$user['cmt5'].'",';
				$row .= '"'.$user['took_ownership'].'",';
				$row .= '"'.$user['cmt6'].'",';
				$row .= '"'.$user['dead_air'].'",';
				$row .= '"'.$user['cmt7'].'",';
				$row .= '"'.$user['contact_information'].'",';
				$row .= '"'.$user['cmt8'].'",';
				$row .= '"'.$user['patient_information'].'",';
				$row .= '"'.$user['cmt9'].'",';
				$row .= '"'.$user['complete_information'].'",';
				$row .= '"'.$user['cmt10'].'",';
				$row .= '"'.$user['probing_questions'].'",';
				$row .= '"'.$user['cmt11'].'",';
				$row .= '"'.$user['hold_transfer'].'",';
				$row .= '"'.$user['cmt12'].'",';
				$row .= '"'.$user['appropiate_notes'].'",';
				$row .= '"'.$user['cmt13'].'",';
				$row .= '"'.$user['update_system'].'",';
				$row .= '"'.$user['cmt14'].'",';
				$row .= '"'.$user['confirm_total_amount'].'",';
				$row .= '"'.$user['cmt15'].'",';
				$row .= '"'.$user['left_voicemail'].'",';
				$row .= '"'.$user['cmt16'].'",';
				$row .= '"'.$user['additional_assitance'].'",';
				$row .= '"'.$user['cmt17'].'",';
				$row .= '"'.$user['close_call'].'",';
				$row .= '"'.$user['cmt18'].'",';
				$row .= '"'.$user['propertly_authenticates'].'",';
				$row .= '"'.$user['cmt19'].'",';
				$row .= '"'.$user['navigated_effectively'].'",';
				$row .= '"'.$user['cmt20'].'",';
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
	

//////////////////////////////////////////////////////////////////////////////////





}