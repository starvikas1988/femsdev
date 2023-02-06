<?php 

 class Qa_alpha extends CI_Controller{
	
	public function __construct(){
		parent::__construct();
		$this->load->model('user_model');
		$this->load->model('Common_model');
		$this->load->model('CreateTable_model');
		$this->load->model('Qa_vrs_model');
	}

	public function serviceName(){
		return "alpha";
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


	public function scoreCard(){
    	return $arrayName = array('YES','NO','N/A');
    }

    public function scoreVal(){
    	return $arrayName = array("val0"=>"0","val1"=>"1","val1p5"=>"1.5","val2"=>"2","val3"=>"3","val4"=>"4","val5"=>"5","val6"=>"6","val8"=>"8","val10"=>"10","val15"=>"15");
    }

    public function alpha_columnname(){
    	return array("openingCall","enthusiastically","ageBrandName","verificationProcess","custInformation","authorizedPerson","interactCust","skillProbTelephoneCallerRapport","customerwithCare","alphaGasElec","resolutionCall","accomplishmentsConversation","policiesProcedures","dispositionedProperly","agentEndedCall","statementOvercome","CustomerConcern","PreventCancellation","agentAbleConsent","understandsSignals","appropriateQuestions","relevantFeatures","customerIsEighteen","agentGivingCall","followedCorrectScript","captureUSrep","AgentREPID","agentCRM","agentCapturedInfo","agentCapturedAddress","agentCorrectPhone","agentCorrectUtility","agentCorrectFirstLastName","agentCorrectAccountNumber","agentCapturedCorrectLanguage","customerUnderstandsTPV","agentAskComplete","agentCorrectCallSource");
    }

    public function parameter_alpha_scrorecard_details(){
    	return array("Did the agent properly execute the opening of the call?","Did the agent  enthusiastically welcomes or greet the caller?","Did the agent able to introduce AGE as the brand name?","Did the agent properly execute the verification process?","Did the agent able to verify customers information?","Did the agent follow the protocol in verifying the authorized person?","Did the agent properly interact with the customer?","Did the agent used active listening skills /probe to correctly diagnose caller issue(s)/ concern(s)?
			Did the agent followed the correct procedures for telephone handling?
			Did the agent showed/expressed appropriate empathy and concern towards the caller/customer?
			Did the agent attempted to build a rapport to the customer?","Did the agent treat the customer/caller with care, respect and professionalism?","Did the customer understands the offers of Alpha Gas and Elec?
			Did the agent explained clearly one by one the offer of AGE?","Did the agent properly execute the resolution of the call?","Did the agent summarizes the actions/accomplishments within the conversation?","Provide correct / complete information based on policies and procedures?","Did the agent properly documented the call?Was the call dispositioned properly?","Did the agent properly ended the call?","Did the agent used an effective rebuttal statement to overcome objections and move customer for enrollment?","Did the agent ask and address the concern of the customer?","Did the agent offered an option to the customer to prevent cancellation?","Did the agent able to verify and ask a consent from the customer to enroll/retain the account?","Did the agent understands buying signals or concerns to avoid cancellation?","Did the agent asked appropriate questions when transitioning to offer(s)?","Did the agent gave the relevant features, benefits and results to the customer?","Did the agent able to verify if the customer is atleast 18 years old and not part of the HEAP when they enroll?","Did the agent used a correct script when giving calls?","Did the agent followed the correct script?","Did the agent capture the correct information from the US rep?","i Agent captured the correct 'Rep ID' in recording and CRM","ii	Agent captured the correct device used in recording and CRM","Did the agent captured the correct information from the customer?","i	Agent captured the correct address, city, state and zip code in recording and CRM","ii	Agent captured the correct phone number in recording and CRM","iii	Agent captured the correct utility in recording and CRM","iv	Agent captured the correct first name and last name in recording and CRM","v	Agent captured the correct account number in recording and CRM","vi	Agent captured the correct language in recording and CRM","Did the customer understands the TPV question properly","Did the agent able to ask and complete all qualifying questions?","Did the agent selected the correct call source in CRM?");
    }

    public function parameter_alpha_comments_details(){
    	return array();  /// not required for english lang
    }

    public function doAllDBTableWorkQA($custcomp=""){

    		$header=$this->headerColumn();
    		$process=$this->processId();
    		$Client=$this->clientId();
    		// print_r($process);
			$page=$this->serviceName();

    		$table_schema="SELECT COUNT(*) tableDetails FROM information_schema.tables WHERE table_schema = 'femsdev' AND table_name = 'qa_".$page."_feedback';";
						$tableDetails=$this->db->query($table_schema)->row();

				if($tableDetails->tableDetails == 0){

		    		$column_val=$this->alpha_columnname();
					$comment_val=$this->parameter_alpha_scrorecard_details();

					if(count($column_val)==count($comment_val)){

						$extraHeaderInfo=$header;
						$manualColumn=$this->manualColumnProcess($column_val,$comment_val);
						$createdTableorNot=$this->CreateTable_model->createQASingleTable($page,$manualColumn,$extraHeaderInfo,$custcomp);
					}else{
						echo "Table not created,comment column not matching";
					}

					if ($process[0]!="" && $Client[0]!="") {
						
						$insertedQADefect=$this->CreateTable_model->qaDefectInsertUpdate($processID=$process[0],$ClientID=$Client[0],$table=$page,$fullcol=$column_val);

						$processAgentUrlUpload=$this->CreateTable_model->processUpdateAgentUrl($process=$process,$table=$page);

					}else{

						echo "not inserted and not updated, process id else client id is missing";
					}

				return $createdTableorNot;
			}else{

				return 1;
			}

    }

    public function headerColumn(){
		return	array('recording','TPV','LOB','Issue');
	}

    public function clientId(){
    	return $clientId= array(104);
    }

    public function processId(){
    	return $processId=array(186);			
    }

    public function agentName(){

    		$processId=$this->processId();
    		$clientId=$this->clientId();

    		$countClient=count($clientId);
    		$countProcess=count($processId);

    		$clientInAgent="";
    		$ProcessInAgent="";

    		if (!empty($clientId)) {
	    		if($countClient<=1){
	    			$clientInAgent=" and  is_assign_client (id,$clientId[0]) ";
			    }else{
	    			$clientInAgent=" and  is_assign_client (id,$clientId[0]) ";
		    		for($i=1;$i<$countClient;$i++){
		    			$clientInAgent.=" or is_assign_client (id,$clientId[$i])";
		    		}
		    	}
    		}

    		if (!empty($processId)) {
	    		if($countProcess<=1){
	    			$ProcessInAgent=" or  is_assign_process (id,$processId[0]) ";
			    }else{
	    			$ProcessInAgent=" or  is_assign_process (id,$processId[0]) ";
		    		for($i=1;$i<$countProcess;$i++){
		    			$ProcessInAgent.=" or is_assign_process (id,$processId[$i])";
		    		}
		    	}
    		}

    		if(check_logged_in())
		{
			$current_user = get_user_id();

    		if(get_role_dir()=='manager' && get_dept_folder()=='operations'){
				$ops_cond=" where (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user')) and ";
			}else if(get_role_dir()=='tl' && get_dept_folder()=='operations'){
				$ops_cond=" where assigned_to='$current_user' and ";
			}else{
				$ops_cond=" where ";
			}

    		$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin`  ".$ops_cond." dept_id=6 ".$clientInAgent.$ProcessInAgent."  and status=1  order by name";
    	}

			/* and is_assign_process (id,66) or is_assign_process (id,123) */
			return $this->Common_model->get_query_result_array($qSql);
    }

	public function index(){
		if(check_logged_in())
		{
			$page=$this->serviceName();
			$current_user = get_user_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_".$page."/qa_".$page."_feedback.php";
			$data["content_js"] = "qa_".$page."_js.php";
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


			$tableCreated=$this->doAllDBTableWorkQA(1);		

			if($tableCreated){	

			/* and is_assign_process (id,66) or is_assign_process (id,123) */
			
			$data["agentName"] = $this->agentName();
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
		
		///////////////////	

			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_".$page."_feedback $cond) xx Left Join
				(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";
			$data[$page."_new_data"] = $this->Common_model->get_query_result_array($qSql);
			
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			$data["agent_id"] = $agent_id;
			
			$this->load->view("dashboard",$data);
		}else{
			echo "Table not created";
		}

		}
	}


	public function process($parm="",$formparam="",$table=""){

		if ($parm=="add") {
			$this->add_process($formparam,$table);
		}elseif ($parm=="mgnt_rvw") {
			$this->mgnt_process_rvw($formparam,$table);
		}elseif($parm=="agent"){
			$this->agent_process_feedback();
		}elseif($parm=="agnt_feedback"){
			$this->agent_process_rvw($formparam,$table);
		}

	}


	public function add_process($stratAuditTime,$table){
	
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			$page=$this->serviceName();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_".$page."/".$table."/add_".$table.".php";
			$data["content_js"] = "qa_".$page."_js.php";
			$data["page"]=$table;

			
			$data["columname"]=$this->alpha_columnname();
			$data["scoreParametername"]=$this->parameter_alpha_scrorecard_details();
			
			/* and is_assign_process (id,66) or is_assign_process (id,123) */
			$data["agentName"] = $this->agentName();
			
			$qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			$data["stratAuditTime"]=$stratAuditTime;
			$curDateTime=CurrMySqlDate();
			$a = array();
			$data["scoreCard"]=$this->scoreCard();
			$data["scoreVal"]=$this->scoreVal();
			// print_r($data['scoreVal']);
			// die;
			
			$field_array['agent_id']=!empty($_POST['data']['agent_id'])?$_POST['data']['agent_id']:"";
			if($field_array['agent_id']){
				$field_array=$this->input->post('data');
				$field_array['audit_date']=CurrDate();
				$field_array['entry_by']=$current_user;
				$field_array['call_date']=mmddyy2mysql($this->input->post('call_date'));
				$field_array['entry_date']=$curDateTime;
				$a = $this->mt_upload_files($_FILES['attach_file'],$table);
				$field_array["attach_file"] = implode(',',$a);
				$rowid= data_inserter('qa_'.$table.'_feedback',$field_array);
				redirect('Qa_'.$page);
			}
			$data["array"] = $a;
			
			$this->load->view("dashboard",$data);
		}
	}
	
	private function mt_upload_files($files,$table)
    {
        $config['upload_path'] = './qa_files/qa_'.$this->serviceName().'/'.$table;
        $result=$this->createPath($config['upload_path']);
        // print_r($result);
        // die;
    	if($result){
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


	public function mgnt_process_rvw($id,$table){
		
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			$page=$this->serviceName();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_".$page."/".$table."/mgnt_".$table."_rvw.php";
			$data["content_js"] = "qa_".$page."_js.php";
			$data["page"]=$table;

			$data["columname"]=$this->alpha_columnname();
			$data["scoreParametername"]=$this->parameter_alpha_scrorecard_details();
			
			/* and is_assign_process (id,66) or is_assign_process (id,123) */
			$data["agentName"] = $this->agentName();
			
			$qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			$data['scoreCard']=$this->scoreCard();
			$data['scoreVal']=$this->scoreVal();
			
			$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_".$table."_feedback where id='$id') xx Left Join
				(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid)";
			$data[$table."_new"] = $this->Common_model->get_query_row_array($qSql);
			
			$data["pnid"]=$id;
			
		///////Edit Part///////	
			if($this->input->post('pnid'))
			{
				$pnid=$this->input->post('pnid');
				$curDateTime=CurrMySqlDate();
				$log=get_logs();
				$file_str="";

				

				$field_array=$this->input->post('data');
				$this->db->where('id', $pnid);
				$this->db->update('qa_'.$table.'_feedback',$field_array);
				
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
				$this->db->update('qa_'.$table.'_feedback',$field_array1);
				
				redirect('Qa_'.$page);
				
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
			$page=$this->serviceName();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_".$page."/agent_".$page."_feedback.php";
			$data["agentUrl"] = "qa_".$page."/agent_process_feedback";
			$data["content_js"] = "qa_".$page."_js.php";
			$data["page"]=$page;
			
			$from_date = '';
			$to_date = '';
			$cond="";

				$qSql="Select count(id) as value from qa_".$page."_feedback where agent_id='$current_user' and audit_type in ('CQ Audit', 'BQ Audit')";
				$data["tot_feedback_ta"] =  $this->Common_model->get_single_value($qSql);
				
				$qSql="Select count(id) as value from qa_".$page."_feedback where agent_rvw_date is null and agent_id='$current_user' and audit_type in ('CQ Audit', 'BQ Audit') ";
				$data["yet_rvw_ta"] =  $this->Common_model->get_single_value($qSql);
								
				if($this->input->get('btnView')=='View')
				{
				
					$fromdate = $this->input->get('from_date');
					if($fromdate!="") $from_date = mmddyy2mysql($fromdate);
					
					$todate = $this->input->get('to_date');
					if($todate!="") $to_date = mmddyy2mysql($todate);
					
					if($from_date !=="" && $to_date!=="" ){ 
						$cond= " Where (audit_date >= '$from_date' and audit_date <= '$to_date') And agent_id='$current_user' and audit_type in ('CQ Audit', 'BQ Audit')";
					}else{
						$cond= " Where agent_id='$current_user' and audit_type in ('CQ Audit', 'BQ Audit')";
					}
					

					$qSql="SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, (select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_name from qa_".$page."_feedback $cond) xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to from signin) yy on (xx.agent_id=yy.sid) order by audit_date";
					$data[$page."_agent_list"] = $this->Common_model->get_query_result_array($qSql);	

				}else{
					$cond= " Where agent_id='$current_user' and audit_type in ('CQ Audit', 'BQ Audit')";

					$qSql="SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, (select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_name from qa_".$page."_feedback $cond) xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to from signin) yy on (xx.agent_id=yy.sid) order by audit_date";
					$data[$page."_agent_list"] = $this->Common_model->get_query_result_array($qSql);
				}
			
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			$this->load->view('dashboard',$data);
		}
	}
	
	public function agent_process_rvw($id,$table){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			$page=$this->serviceName();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_".$page."/".$table."/agent_".$table."_rvw.php";
			$data["agentUrl"] = "qa_".$page."/agent_process_feedback";
			$data["content_js"] = "qa_".$page."_js.php";
			$data["page"]=$table;

			$data["columname"]=$this->alpha_columnname();
			$data["scoreParametername"]=$this->parameter_alpha_scrorecard_details();
						
			$qSql="SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, (select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_name,agent_rvw_note as agent_note,mgnt_rvw_note as mgnt_note from qa_".$table."_feedback where id=$id) xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to from signin) yy on (xx.agent_id=yy.sid) order by audit_date";

			$data[$table."_agnt_feedback"] = $this->Common_model->get_query_row_array($qSql);
			
			$data["pnid"]=$id;
			$data['scoreCard']=$this->scoreCard();
			$data['scoreVal']=$this->scoreVal();			
			
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
				$this->db->update('qa_'.$table.'_feedback',$field_array);
				
				redirect('Qa_'.$page.'/process/agent');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	} 
	
	

////////////////////////////////////////////////////////////////////////////////////////////////////////
/////// REPORT PART
	public function qa_alpha_report()
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
			$data["content_template"] = "qa_alpha/qa_alpha_report.php";
			$data["content_js"] = "qa_alpha_js.php";
			
			$data['location_list'] = $this->Common_model->get_office_location_list();
			
			$office_id = "";
			$date_from="";
			$date_to="";
			$audit_type="";
			$action="";
			$dn_link="";
			$cond="";
			$offcond="";
			$atcond="";
			$cond1="";
			
			$data["alpha_list"] = array();
			
			if($this->input->get('show')=='Show')
			{
				$date_from = mmddyy2mysql($this->input->get('date_from'));
				$date_to = mmddyy2mysql($this->input->get('date_to'));
				$office_id = $this->input->get('office_id');
				$audit_type = $this->input->get('audit_type');
				
				if($date_from !="" && $date_to!=="" )  $cond= " Where (date(audit_date) >= '$date_from' and date(audit_date) <= '$date_to')";
		
				if($office_id=="All") $offcond .= "";
				else $offcond .=" and office_id='$office_id'";
				
				if($audit_type=="All"){ 
					if(get_login_type()=="client"){
						$atcond .= " and audit_type not in ('Operation Audit','Trainer Audit')";
					}else{
						$atcond .= "";
					}
				}else{ 
					$atcond .=" and audit_type='$audit_type'";
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
				(select concat(fname, ' ', lname) as name from signin_client scx where scx.id=client_rvw_by) as client_rvw_name from qa_alpha_feedback) xx Left Join
				(Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_ids(id) as process_id, get_process_names(id) as process, doj, DATEDIFF(CURDATE(), doj) as tenure from signin) yy on (xx.agent_id=yy.sid) $cond $offcond $atcond $cond1 order by audit_date";
				
				$fullAray = $this->Common_model->get_query_result_array($qSql);
				$data["alpha_list"] = $fullAray;
				$this->create_qa_alpha_CSV($fullAray);	
				$dn_link = base_url()."qa_alpha/download_qa_alpha_CSV/";	
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
	 

	public function download_qa_alpha_CSV()
	{
		$currDate=date("Y-m-d");
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$newfile="QA Alpha Audit List-'".$currDate."'.csv";
		header('Content-Disposition: attachment;  filename="'.$newfile.'"');
		readfile($filename);
	}


	public function create_qa_alpha_CSV($rr)
	{
		$currDate=date("Y-m-d");
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$currentURL = base_url();
		$controller = "Qa_alpha";
		$edit_url = "process/mgnt_rvw";
		$main_url =  $currentURL.''.$controller.'/'.$edit_url;
		$fopen = fopen($filename,"w+");
		
		$header = array("Auditor Name","Audit Date","Agent","Agent ID","L1 Super","Contact Date","Contact Duration","LOB","Issue","Audit Type","VOC","Audit Link","Business Score ","Customer Score ","Compliance Score ","Overall Score ","Possible Score ","Earned Score ",
		"Did the agent properly execute the opening of the call? ","Did the agent enthusiastically welcomes or greet the caller?","Did the agent able to introduce AGE as the brand name?","Did the agent properly execute the verification process?","Did the agent able to verify customers information?","Did the agent follow the protocol in verifying the authorized person?","Did the agent properly interact with the customer?","Did the agent used active listening skills?","Did the agent treat the customer/caller with care respect and professionalism?","Did the customer understands the offers of Alpha Gas and Elec?","Did the agent properly execute the resolution of the call?","Did the agent summarizes the actions/accomplishments within the conversation?","Provide correct / complete information based on policies and procedures? ","Did the agent properly documented the call?Was the call dispositioned properly? ","Did the agent properly ended the call? ","Did the agent used an effective rebuttal statement to overcome objections and move customer for enrollment? ","Did the agent ask and address the concern of the customer? ","Did the agent offered an option to the customer to prevent cancellation? ","Did the agent able to verify and ask a consent from the customer to enroll/retain the account? ","Did the agent understands buying signals or concerns to avoid cancellation? ","Did the agent asked appropriate questions when transitioning to offer(s)? ","Did the agent gave the relevant features benefits and results to the customer? ","Did the agent able to verify if the customer is atleast 18 years old and not part of the HEAP when they enroll? ","Did the agent used a correct script when giving calls? ","Did the agent followed the correct script? ","Did the agent capture the correct information from the US rep? ","i Agent captured the correct 'Rep ID' in recording and CRM ","ii Agent captured the correct device used in recording and CRM ","Did the agent captured the correct information from the customer? ","i Agent captured the correct address city state and zip code in recording and CRM ","ii Agent captured the correct phone number in recording and CRM ","iii Agent captured the correct utility in recording and CRM ","iv Agent captured the correct first name and last name in recording and CRM ","v Agent captured the correct account number in recording and CRM ","vi Agent captured the correct language in recording and CRM ","Did the customer understands the TPV question properly ","Did the agent able to ask and complete all qualifying questions? ","Did the agent selected the correct call source in CRM? ",
		"Comments 1 ","Comments 2 ","Comments 3 ","Comments 4 ","Comments 5 ","Comments 6 ","Comments 7 ","Comments 8 ","Comments 9 ","Comments 10 ","Comments 11 ","Comments 12 ","Comments 13 ","Comments 14 ","Comments 15 ","Comments 16 ","Comments 17 ","Comments 18 ","Comments 19 ","Comments 20 ","Comments 21 ","Comments 22 ","Comments 23 ","Comments 24 ","Comments 25 ","Comments 26 ","Comments 27 ","Comments 28 ","Comments 29 ","Comments 30 ","Comments 31 ","Comments 32 ","Comments 33 ","Comments 34 ","Comments 35 ","Comments 36 ","Comments 37 ","Comments 38 ",
		"Call Summary ","Feedback ","Entry By ","Entry Date ","Audit Start Time", "Interval(In Second)","Client entry by [","Mgnt review by","Mgnt review note","Mgnt review date ","Agent review note","Agent Feedback Acceptance ","Agent review date ","Client_rvw_date","Client review by ","Client review note");
		
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

			$main_urls = $main_url.'/'.$user['id'].'/alpha';
			
			$row = '"'.$auditorName.'",'; 
			$row .= '"'.$user['audit_date'].'",'; 
			$row .= '"'.$user['fname']." ".$user['lname'].'",';
			$row .= '"'.$user['fusion_id'].'",';
			$row .= '"'.$user['tl_name'].'",';
			$row .= '"'.$user['call_date'].'",';
			$row .= '"'.$user['call_duration'].'",';
			$row .= '"'.$user['LOB'].'",';
			$row .= '"'.$user['Issue'].'",';
			$row .= '"'.$user['audit_type'].'",';
			$row .= '"'.$user['voc'].'",';	
			$row .= '"'.$main_urls.'",';
			$row .= '"'.$user['busi_score'].'",';
			$row .= '"'.$user['cust_score'].'",';
			$row .= '"'.$user['comp_score'].'",';
			$row .= '"'.$user['overall_score'].'",';
			$row .= '"'.$user['possible_score'].'",';
			$row .= '"'.$user['earned_score'].'",';
			$row .= '"'.$user['openingCall'].'",';
			$row .= '"'.$user['enthusiastically'].'",';
			$row .= '"'.$user['ageBrandName'].'",';
			$row .= '"'.$user['verificationProcess'].'",';
			$row .= '"'.$user['custInformation'].'",';
			$row .= '"'.$user['authorizedPerson'].'",';
			$row .= '"'.$user['interactCust'].'",';
			$row .= '"'.$user['skillProbTelephoneCallerRapport'].'",';
			$row .= '"'.$user['customerwithCare'].'",';
			$row .= '"'.$user['alphaGasElec'].'",';
			$row .= '"'.$user['resolutionCall'].'",';
			$row .= '"'.$user['accomplishmentsConversation'].'",';
			$row .= '"'.$user['policiesProcedures'].'",';
			$row .= '"'.$user['dispositionedProperly'].'",';
			$row .= '"'.$user['agentEndedCall'].'",';
			$row .= '"'.$user['statementOvercome'].'",';
			$row .= '"'.$user['CustomerConcern'].'",';
			$row .= '"'.$user['PreventCancellation'].'",';
			$row .= '"'.$user['agentAbleConsent'].'",';
			$row .= '"'.$user['understandsSignals'].'",';
			$row .= '"'.$user['appropriateQuestions'].'",';
			$row .= '"'.$user['relevantFeatures'].'",';
			$row .= '"'.$user['customerIsEighteen'].'",';
			$row .= '"'.$user['agentGivingCall'].'",';
			$row .= '"'.$user['followedCorrectScript'].'",';
			$row .= '"'.$user['captureUSrep'].'",';
			$row .= '"'.$user['AgentREPID'].'",';
			$row .= '"'.$user['agentCRM'].'",';
			$row .= '"'.$user['agentCapturedInfo'].'",';
			$row .= '"'.$user['agentCapturedAddress'].'",';
			$row .= '"'.$user['agentCorrectPhone'].'",';
			$row .= '"'.$user['agentCorrectUtility'].'",';
			$row .= '"'.$user['agentCorrectFirstLastName'].'",';
			$row .= '"'.$user['agentCorrectAccountNumber'].'",';
			$row .= '"'.$user['agentCapturedCorrectLanguage'].'",';
			$row .= '"'.$user['customerUnderstandsTPV'].'",';
			$row .= '"'.$user['agentAskComplete'].'",';
			$row .= '"'.$user['agentCorrectCallSource'].'",';
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
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt30'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt31'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt32'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt33'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt34'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt35'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt36'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt37'])).'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt38'])).'",';
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