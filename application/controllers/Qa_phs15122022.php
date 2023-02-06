<?php 

 class Qa_phs extends CI_Controller{
	
	public function __construct(){
		parent::__construct();
		$this->load->model('user_model');
		$this->load->model('Common_model');
		$this->load->model('CreateTable_model');
		$this->load->model('Qa_vrs_model');
	}

    ///////////////// Dynamic process name use function part//////////////////////////


	public function serviceName(){
		return "phs";
	}

    ///////////////// Dynamic process name use function end part//////////////////////////


    ///////////////// Dynamic path creation function part//////////////////////////


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

    ///////////////// Dynamic path creation function end part//////////////////////////


    ///////////////// Manula column process for table creation with column name part//////////////////////////


	public function manualColumnProcess($column_val,$comment_val){

				$process=$this->processName();
    	
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

    ///////////////// Manula column process for table creation with column name end part//////////////////////////

     ///////////////// Dynamic View table scorcard column name and scorecard plus dynamic sql help table creation process wise function part//////////////////////////

	public function scoreCard(){
    	return $arrayName = array("YES","NO",'N/A');
    }

    public function phsScoreVal(){
    	return $arrayName = array(5,5,5,5,5,5,5,5,5,5,5,5,5,5,5,5,5,5,2,5);
    }

    public function phs_columnname(){
    	return array("didtheCSRadheretoa","callCSRadhereProcess","didtheagentprovide","didtheagentabletoh","foraccountclosured","didtheagentsubmito","didtheagentproper","didtheagentprop","didtheagentabletop","didtheagentinformt","didtheagentpro","didtheagentp","didtheagentexecute","didtheagentproperl","didtheagentfollowe","maintainsafriendly","accuratelycommunic","didtheagentmeetthe","goingaboveandbeyon","did_the_agent_resolve");
    }

    public function parameter_phs_scrorecard_details(){
    	return array("Did the CSR adhere to all Authentication and Security Policies of the account member?","Properly verifies the account holder information before providing/discussing any account information.","For account changes, caller should be authorized on the account (ie,wife or dependent)","Obtain verbal or written permission from an authenticated account owner before providing any account information.","Obtain LOA in order to speak  to someone other than the account holder regarding benefits or payment methods?", "Did the CSR adhere to call back process?","Ask for the provider name of the facility and reliable call back number","Ask member reliable call back number",
		"Did the agent  provide information to a provider about the status of the member’s account?","Did the agent able to handle a credit card information correctly?","For account closure, did the agent follow cancellation process?","Agent should identify that the member has cancellation exception process.","Did the agent submit/process all eligible refund requests in accordance with the Refund Policy.","Did the agent properly change the payment method?","Did the agent properly discussed member benefits?","Did the agent able to properly provide the claims phone number and PO box?","Did the agent inform the customer that the calls may be recorded for security purposes during callback?","Was all product information provided accurately?","Did the agent locate the information in a timely manner?","Did the agent execute properly any of the Escalation?","Did the agent properly execute any of the process for DOCUMENTATION: Were Case Comments Complete and Accurate?","All information relevant to the interaction is captured ( verify your name, address and the phone number that is listed on the plan)","All cases should be documented in the E123 tool, specific to member interaction.","Did the agent followed proper call handling?","Maintains a friendly, confident and professional voice tone throughout interaction.","Accurately communicate during the interaction?","Did the agent meet the expectations they set during the interaction?","Going above and beyond or doing the extra mile.","Did the agent resolve the issue and addressed the caller needs on this call?");
    }

    public function parameter_phs_comments_details(){
    	return array("Did the CSR adhere to all Authentication and Security Policies of the account member?","Did the CSR adhere to call back process?",
		"Did the agent  provide information to a provider about the status of the member’s account?","Did the agent able to handle a credit card information correctly?","For account closure did the agent follow cancellation process?","Did the agent submit or process all eligible refund requests in accordance with the Refund Policy.","Did the agent properly change the payment method?","Did the agent properly discussed member benefits?","Did the agent able to properly provide the claims phone number and PO box?","Did the agent inform the customer that the calls may be recorded for security purposes during callback?","Was all product information provided accurately?","Did the agent locate the information in a timely manner?","Did the agent execute properly any of the Escalation?","Did the agent properly execute any of the process for DOCUMENTATION Were Case Comments Complete and Accurate?","Did the agent followed proper call handling?","Maintains a friendly confident and professional voice tone throughout interaction.","Accurately communicate during the interaction?","Did the agent meet the expectations they set during the interaction?","Going above and beyond or doing the extra mile.","Did the agent resolve the issue and addressed the caller needs on this call?");  /// not required for english lang
    }

    ///////////////// Dynamic View table scorcard column name and scorecard plus dynamic sql help table creation process wise function end part//////////////////////////


    ///////////////// Dynamic single multi Process table creation qa_defect and process table update part//////////////////////////


    public function doAllDBTableWorkQA($custcomp=""){

    		$process=$this->processId();
    		$Client=$this->clientId();
    		// print_r($process);
    		$processName=$this->processName();
			$processCnt=count($processName);
			$page=$this->serviceName();
			if(!empty($processCnt)){

				if($processCnt<=1){
					$table_schema="SELECT COUNT(*) tableDetails FROM information_schema.tables WHERE table_schema = 'femsdev' AND table_name = 'qa_".$page."_feedback';";
						$tableDetails=$this->db->query($table_schema)->row();

						if($tableDetails->tableDetails == 0){

				    		$header=$page."headerColumn";
		    				$header=$this->$header();
							$column_val=$page."_columnname";
							$comment_val="parameter_".$page."_comments_details";
				    		$column_val=$this->$column_val();
							$comment_val=$this->$comment_val();

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

					}else{

						return 1;
					}

				}else{

					for($i=0;$i<$processCnt;$i++){
    				
    				$header=$processName[$i]."headerColumn";
    				$header=$this->$header();
					$column_val=$processName[$i]."_columnname";
					$comment_val="parameter_".$processName[$i]."_comments_details";
		    		$column_val=$this->$column_val();
					$comment_val=$this->$comment_val();

					$table_schema="SELECT COUNT(*) tableDetails FROM information_schema.tables WHERE table_schema = 'femsdev' AND table_name = 'qa_".$page."_".$processName[$i]."_feedback';";
						$tableDetails=$this->db->query($table_schema)->row();

						if($tableDetails->tableDetails == 0){


							if(count($column_val)==count($comment_val)){

											$extraHeaderInfo=$header;
											$manualColumn=$this->manualColumnProcess($column_val,$comment_val);
											$createdTableorNot=$this->CreateTable_model->createQASingleTable($page."_".$processName[$i],$manualColumn,$extraHeaderInfo,$custcomp);
										}else{
											echo "Table not created,comment column not matching";
										}

										if ($process[$i]!="" && $Client[0]!="") {
											
											$insertedQADefect=$this->CreateTable_model->qaDefectInsertUpdate($processID=$process[$i],$ClientID=$Client[0],$table=$page."_".$processName[$i],$fullcol=$column_val);

											$processAgentUrlUpload=$this->CreateTable_model->processUpdateAgentUrl($process=$process,$table=$page."_".$processName[$i]);

										}else{

											echo "not inserted and not updated, process id else client id is missing";
										}

					}

					}
					return 1;
				}

			}

				

    }

    ///////////////// Dynamic single multi Process table creation qa_defect and process table update end part//////////////////////////


    ///////////////// Process wise extra header column Name part//////////////////////////


    public function phsheaderColumn(){
		return	array("channel","file_number","acpt","ztp","member_id");
	}

    ///////////////// Process wise extra header column Name end part//////////////////////////

    ///////////////// Process wise client process id details part//////////////////////////

    public function clientId(){
    	return $clientId= array(196);
    }

    public function processId(){
    	return $processId=array(392);	
    }

    ///////////////// Process wise client process id details end part//////////////////////////

    ///////////////// Process wise processName part//////////////////////////

    public function processName(){
    	return array("phs");
    }

    ///////////////// Process wise processName end part//////////////////////////


    ///////////////// Agent Name process part//////////////////////////


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

    		$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 ".$clientInAgent.$ProcessInAgent."  and status=1  order by name";

			/* and is_assign_process (id,66) or is_assign_process (id,123) */
			return $this->Common_model->get_query_result_array($qSql);
    }

	///////////////// Agent Name process end part//////////////////////////


    ///////////////// Dynamic process part//////////////////////////

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

	///////////////// Dynamic process end part//////////////////////////

    ///////////////// QA Feedback process part//////////////////////////

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
			$data['processName']=$this->processName();
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

			$processName=$this->processName();
			$processCnt=count($processName);
			$page=$this->serviceName();
			if(!empty($processCnt)){

				if($processCnt<=1){

					$qSql = "SELECT * from
						(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
						(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
						(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
						(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_".$page."_feedback $cond) xx Left Join
						(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";
					$data[$page."_new_data"] = $this->Common_model->get_query_result_array($qSql);

				}else{

					for($i=0;$i<$processCnt;$i++){

						$qSql = "SELECT * from
						(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
						(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
						(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
						(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_".$page."_".$processName[$i]."_feedback $cond) xx Left Join
						(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";
						$data[$page."_".$processName[$i]."_new_data"] = $this->Common_model->get_query_result_array($qSql);

					}

				}

			}
			
		}else{
			echo "Table not created";
		}
		
		/////////////////////
			
			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_phs_email_feedback $cond) xx Left Join
				(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";
			$data["phs_email"] = $this->Common_model->get_query_result_array($qSql);
		///////////
			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_phs_chat_feedback $cond) xx Left Join
				(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";
			$data["phs_chat"] = $this->Common_model->get_query_result_array($qSql);

			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_phs_chat_v2_feedback $cond) xx Left Join
				(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";
			$data["phs_chat_v2"] = $this->Common_model->get_query_result_array($qSql);

			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_phs_email_v2_feedback $cond) xx Left Join
				(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";
			$data["phs_email_v2"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_phs_voice_v2_feedback $cond) xx Left Join
				(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";
			$data["phs_voice_v2"] = $this->Common_model->get_query_result_array($qSql);

			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			$data["agent_id"] = $agent_id;
			
			$this->load->view("dashboard",$data);
		

		}
	}

	///////////////// QA Feedback process end part//////////////////////////

	///////////////// ADD process part//////////////////////////

	public function add_process($stratAuditTime,$table){
	
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			$page=$this->serviceName();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_".$page."/".$table."/add_".$table.".php";
			$data["content_js"] = "qa_".$page."_js.php";
			$processName=$this->processName();
			$processCnt=count($processName);
			if(!empty($processCnt)){

				if($processCnt<=1){
						$table=$page;
						$tableTemp=$table;
						$data["page"]=$table;
						$columname=$page."_columnname";
						$scoreParametername="parameter_".$page."_scrorecard_details";
						$scoreVal=$page."ScoreVal";
						$data["columname"]=$this->$columname();
						$data["scoreParametername"]=$this->$scoreParametername();
						$data["scoreVal"]=$this->$scoreVal();
				}else{

					if(in_array($table, $processName)){
						$tableTemp=$table;
						$table=$page."_".$tableTemp;
						$data["page"]=$table;
						$columname=$tableTemp."_columnname";
						$scoreParametername="parameter_".$tableTemp."_scrorecard_details";
						$scoreVal=$tableTemp."ScoreVal";
						$data["columname"]=$this->$columname();
						$data["scoreParametername"]=$this->$scoreParametername();
						$data["scoreVal"]=$this->$scoreVal();
					}
				}
			}
				
			
			/* and is_assign_process (id,66) or is_assign_process (id,123) */
			$data["agentName"] = $this->agentName();
			
			$qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			$data["stratAuditTime"]=$stratAuditTime;
			$curDateTime=CurrMySqlDate();
			$a = array();
			// print_r($data['scoreVal']);
			// die;
			$data["scoreCard"]=$this->scoreCard();
			
			$field_array['agent_id']=!empty($_POST['data']['agent_id'])?$_POST['data']['agent_id']:"";
			if($field_array['agent_id']){
				$field_array=$this->input->post('data');
				$field_array['audit_date']=CurrDate();
				$field_array['entry_by']=$current_user;
				$field_array['call_date']=mmddyy2mysql($this->input->post('call_date'));
				$field_array['entry_date']=$curDateTime;
				$a = $this->mt_upload_files($_FILES['attach_file'],$tableTemp);
				$field_array["attach_file"] = implode(',',$a);
				$rowid= data_inserter('qa_'.$table.'_feedback',$field_array);
				redirect('Qa_'.$page);
			}
			$data["array"] = $a;
			
			$this->load->view("dashboard",$data);
		}
	}

	///////////////// ADD process end part//////////////////////////
	
	///////////////// UPLOAD FILE with path existance checking part//////////////////////////

	private function mt_upload_files($files,$table)
    {
        $path = './qa_files/qa_'.$this->serviceName().'/'.$table;
        $result=$this->createPath($path);
        // print_r($result);
        // die;
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

    ///////////////// UPLOAD FILE with path existance checking end part//////////////////////////

    ///////////////// Mgnt process part//////////////////////////

	public function mgnt_process_rvw($id,$table){
		
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			$page=$this->serviceName();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_".$page."/".$table."/mgnt_".$table."_rvw.php";
			$data["content_js"] = "qa_".$page."_js.php";

			$processName=$this->processName();
			$processCnt=count($processName);
			if(!empty($processCnt)){

				if($processCnt<=1){
						$table=$page;
						$tableTemp=$table;
						$data["page"]=$table;
						$columname=$page."_columnname";
						$scoreParametername="parameter_".$page."_scrorecard_details";
						$scoreVal=$page."ScoreVal";
						$data["columname"]=$this->$columname();
						$data["scoreParametername"]=$this->$scoreParametername();
						$data["scoreVal"]=$this->$scoreVal();
				}else{

					if(in_array($table, $processName)){
						$tableTemp=$table;
						$table=$page."_".$tableTemp;
						$data["page"]=$table;
						$columname=$tableTemp."_columnname";
						$scoreParametername="parameter_".$tableTemp."_scrorecard_details";
						$scoreVal=$tableTemp."ScoreVal";
						$data["columname"]=$this->$columname();
						$data["scoreParametername"]=$this->$scoreParametername();
						$data["scoreVal"]=$this->$scoreVal();
					}
				}
			}
			
			/* and is_assign_process (id,66) or is_assign_process (id,123) */
			$data["agentName"] = $this->agentName();
			
			$qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			$data['scoreCard']=$this->scoreCard();
			
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
	
	///////////////// Mgnt process end part//////////////////////////

////////////////////////////////////////////////////////////	
////////////////////// Email & Chat ///////////////////////
	private function phs_upload_files($files,$path)
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
	
	
	public function add_edit_phs_email($email_id){
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_phs/phs_email/add_edit_phs_email.php";
			$data["content_js"] = "qa_phs_js.php";
			$data['email_id']=$email_id;
			$tl_mgnt_cond='';
			
			if(get_role_dir()=='manager' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";
			}else if(get_role_dir()=='tl' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and assigned_to='$current_user'";
			}else{
				$tl_mgnt_cond="";
			}
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client(id,196) and is_assign_process(id,392) and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
				from qa_phs_email_feedback where id='$email_id') xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
			$data["phs_email"] = $this->Common_model->get_query_row_array($qSql);
			
			//$currDate=CurrDate();
			$curDateTime=CurrMySqlDate();
			$a = array();
			
			
			$field_array['agent_id']=!empty($_POST['data']['agent_id'])?$_POST['data']['agent_id']:"";
			
			if($field_array['agent_id']){
				
				if($email_id==0){
					
					$field_array=$this->input->post('data');
					$field_array['audit_date']=CurrDate();
					$field_array['call_date']=mmddyy2mysql($this->input->post('call_date'));
					$field_array['entry_date']=$curDateTime;
					$field_array['audit_start_time']=$this->input->post('audit_start_time');
					$a = $this->phs_upload_files($_FILES['attach_file'], $path='./qa_files/qa_phs/email/');
					$field_array["attach_file"] = implode(',',$a);
					$rowid= data_inserter('qa_phs_email_feedback',$field_array);
				///////////
					if(get_login_type()=="client"){
						$add_array = array("client_entryby" => $current_user);
					}else{
						$add_array = array("entry_by" => $current_user);
					}
					$this->db->where('id', $rowid);
					$this->db->update('qa_phs_email_feedback',$add_array);
					
				}else{
					
					$field_array1=$this->input->post('data');
					$field_array1['call_date']=mmddyy2mysql($this->input->post('call_date'));
					if($_FILES['attach_file']['tmp_name'][0]!=''){
						$a = $this->mt_upload_files($_FILES['attach_file'],$path='./qa_files/qa_phs/email/');
						$field_array1['attach_file'] = implode(',',$a);
					}
					$this->db->where('id', $email_id);
					$this->db->update('qa_phs_email_feedback',$field_array1);
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
					$this->db->where('id', $email_id);
					$this->db->update('qa_phs_email_feedback',$edit_array);
					
				}
				redirect('qa_phs');
			}
			$data["array"] = $a;
			$this->load->view("dashboard",$data);
		}
	}
	
	
	public function add_edit_phs_chat($chat_id){
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_phs/phs_chat/add_edit_phs_chat.php";
			$data["content_js"] = "qa_phs_js.php";
			$data['chat_id']=$chat_id;
			$tl_mgnt_cond='';
			
			if(get_role_dir()=='manager' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";
			}else if(get_role_dir()=='tl' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and assigned_to='$current_user'";
			}else{
				$tl_mgnt_cond="";
			}
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client(id,196) and is_assign_process(id,392) and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
				from qa_phs_chat_feedback where id='$chat_id') xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
			$data["phs_chat"] = $this->Common_model->get_query_row_array($qSql);
			
			//$currDate=CurrDate();
			$curDateTime=CurrMySqlDate();
			$a = array();
			
			
			$field_array['agent_id']=!empty($_POST['data']['agent_id'])?$_POST['data']['agent_id']:"";
			
			if($field_array['agent_id']){
				
				if($chat_id==0){
					
					$field_array=$this->input->post('data');
					$field_array['audit_date']=CurrDate();
					$field_array['call_date']=mmddyy2mysql($this->input->post('call_date'));
					$field_array['entry_date']=$curDateTime;
					$field_array['audit_start_time']=$this->input->post('audit_start_time');
					$a = $this->phs_upload_files($_FILES['attach_file'], $path='./qa_files/qa_phs/chat/');
					$field_array["attach_file"] = implode(',',$a);
					$rowid= data_inserter('qa_phs_chat_feedback',$field_array);
				///////////
					if(get_login_type()=="client"){
						$add_array = array("client_entryby" => $current_user);
					}else{
						$add_array = array("entry_by" => $current_user);
					}
					$this->db->where('id', $rowid);
					$this->db->update('qa_phs_chat_feedback',$add_array);
					
				}else{
					
					$field_array1=$this->input->post('data');
					$field_array1['call_date']=mmddyy2mysql($this->input->post('call_date'));
					if($_FILES['attach_file']['tmp_name'][0]!=''){
						$a = $this->mt_upload_files($_FILES['attach_file'],$path='./qa_files/qa_phs/chat/');
						$field_array1['attach_file'] = implode(',',$a);
					}
					$this->db->where('id', $chat_id);
					$this->db->update('qa_phs_chat_feedback',$field_array1);
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
					$this->db->where('id', $chat_id);
					$this->db->update('qa_phs_chat_feedback',$edit_array);
					
				}
				redirect('qa_phs');
			}
			$data["array"] = $a;
			$this->load->view("dashboard",$data);
		}
	}

	//////////////////////////////////////////

	public function add_edit_phs_chat_v2($chat_id){
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_phs/phs_chat/add_edit_phs_chat_v2.php";
			$data["content_js"] = "qa_phs_js.php";
			$data['chat_id']=$chat_id;
			$tl_mgnt_cond='';
			
			if(get_role_dir()=='manager' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";
			}else if(get_role_dir()=='tl' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and assigned_to='$current_user'";
			}else{
				$tl_mgnt_cond="";
			}
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client(id,196) and is_assign_process(id,392) and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT id, fname, lname, fusion_id, office_id FROM signin where role_id in (select id from role where (folder in ('tl','trainer','am','manager')) or (name in ('Client Services'))) and status=1";
			
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
				from qa_phs_chat_v2_feedback where id='$chat_id') xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
			$data["phs_chat"] = $this->Common_model->get_query_row_array($qSql);
			
			//$currDate=CurrDate();
			$curDateTime=CurrMySqlDate();
			$a = array();
			
			
			$field_array['agent_id']=!empty($_POST['data']['agent_id'])?$_POST['data']['agent_id']:"";
			
			if($field_array['agent_id']){
				
				if($chat_id==0){
					
					$field_array=$this->input->post('data');
					$field_array['audit_date']=CurrDate();
					$field_array['call_date']=mmddyy2mysql($this->input->post('call_date'));
					$field_array['entry_date']=$curDateTime;
					$field_array['audit_start_time']=$this->input->post('audit_start_time');
					$a = $this->phs_upload_files($_FILES['attach_file'], $path='./qa_files/qa_phs/chat/');
					$field_array["attach_file"] = implode(',',$a);
					$rowid= data_inserter('qa_phs_chat_v2_feedback',$field_array);
				///////////
					if(get_login_type()=="client"){
						$add_array = array("client_entryby" => $current_user);
					}else{
						$add_array = array("entry_by" => $current_user);
					}
					$this->db->where('id', $rowid);
					$this->db->update('qa_phs_chat_v2_feedback',$add_array);
					
				}else{
					
					$field_array1=$this->input->post('data');
					$field_array1['call_date']=mmddyy2mysql($this->input->post('call_date'));
					if($_FILES['attach_file']['tmp_name'][0]!=''){
						$a = $this->mt_upload_files($_FILES['attach_file'],$path='./qa_files/qa_phs/chat/');
						$field_array1['attach_file'] = implode(',',$a);
					}
					$this->db->where('id', $chat_id);
					$this->db->update('qa_phs_chat_v2_feedback',$field_array1);
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
					$this->db->where('id', $chat_id);
					$this->db->update('qa_phs_chat_v2_feedback',$edit_array);
					
				}
				redirect('qa_phs');
			}
			$data["array"] = $a;
			$this->load->view("dashboard",$data);
		}
	}

	public function add_edit_phs_email_v2($email_id){
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_phs/phs_email/add_edit_phs_email_v2.php";
			$data["content_js"] = "qa_phs_js.php";
			$data['email_id']=$email_id;
			$tl_mgnt_cond='';
			
			if(get_role_dir()=='manager' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";
			}else if(get_role_dir()=='tl' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and assigned_to='$current_user'";
			}else{
				$tl_mgnt_cond="";
			}
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client(id,196) and is_assign_process(id,392) and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT id, fname, lname, fusion_id, office_id FROM signin where role_id in (select id from role where (folder in ('tl','trainer','am','manager')) or (name in ('Client Services'))) and status=1";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
				from qa_phs_email_v2_feedback where id='$email_id') xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
			$data["phs_email_v2"] = $this->Common_model->get_query_row_array($qSql);
			
			//$currDate=CurrDate();
			$curDateTime=CurrMySqlDate();
			$a = array();
			
			
			$field_array['agent_id']=!empty($_POST['data']['agent_id'])?$_POST['data']['agent_id']:"";
			
			if($field_array['agent_id']){
				
				if($email_id==0){
					
					$field_array=$this->input->post('data');
					$field_array['audit_date']=CurrDate();
					$field_array['call_date']=mmddyy2mysql($this->input->post('call_date'));
					$field_array['entry_date']=$curDateTime;
					$field_array['audit_start_time']=$this->input->post('audit_start_time');
					$a = $this->phs_upload_files($_FILES['attach_file'], $path='./qa_files/qa_phs/email/');
					$field_array["attach_file"] = implode(',',$a);
					$rowid= data_inserter('qa_phs_email_v2_feedback',$field_array);
				///////////
					if(get_login_type()=="client"){
						$add_array = array("client_entryby" => $current_user);
					}else{
						$add_array = array("entry_by" => $current_user);
					}
					$this->db->where('id', $rowid);
					$this->db->update('qa_phs_email_v2_feedback',$add_array);
					
				}else{
					
					$field_array1=$this->input->post('data');
					$field_array1['call_date']=mmddyy2mysql($this->input->post('call_date'));
					if($_FILES['attach_file']['tmp_name'][0]!=''){
						$a = $this->mt_upload_files($_FILES['attach_file'],$path='./qa_files/qa_phs/email/');
						$field_array1['attach_file'] = implode(',',$a);
					}
					$this->db->where('id', $email_id);
					$this->db->update('qa_phs_email_v2_feedback',$field_array1);
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
					$this->db->where('id', $email_id);
					$this->db->update('qa_phs_email_v2_feedback',$edit_array);
					
				}
				redirect('qa_phs');
			}
			$data["array"] = $a;
			$this->load->view("dashboard",$data);
		}
	}

	public function add_edit_phs_voice_v2($voice_id){
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_phs/phs/add_edit_phs_voice_v2.php";
			$data["content_js"] = "qa_phs_js.php";
			$data['voice_id']=$voice_id;
			$tl_mgnt_cond='';
			
			if(get_role_dir()=='manager' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where assigned_to ='$current_user'))";
			}else if(get_role_dir()=='tl' && get_dept_folder()=='operations'){
				$tl_mgnt_cond=" and assigned_to='$current_user'";
			}else{
				$tl_mgnt_cond="";
			}
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client(id,196) and is_assign_process(id,392) and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT id, fname, lname, fusion_id, office_id FROM signin where role_id in (select id from role where (folder in ('tl','trainer','am','manager')) or (name in ('Client Services'))) and status=1";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
				from qa_phs_voice_v2_feedback where id='$voice_id') xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
			$data["phs_voice_v2"] = $this->Common_model->get_query_row_array($qSql);
			
			//$currDate=CurrDate();
			$curDateTime=CurrMySqlDate();
			$a = array();
			
			
			$field_array['agent_id']=!empty($_POST['data']['agent_id'])?$_POST['data']['agent_id']:"";
			
			if($field_array['agent_id']){
				
				if($voice_id==0){
					
					$field_array=$this->input->post('data');
					$field_array['audit_date']=CurrDate();
					$field_array['call_date']=mmddyy2mysql($this->input->post('call_date'));
					$field_array['entry_date']=$curDateTime;
					$field_array['audit_start_time']=$this->input->post('audit_start_time');
					$a = $this->phs_upload_files($_FILES['attach_file'], $path='./qa_files/qa_phs/phs/');
					$field_array["attach_file"] = implode(',',$a);
					$rowid= data_inserter('qa_phs_voice_v2_feedback',$field_array);
				///////////
					if(get_login_type()=="client"){
						$add_array = array("client_entryby" => $current_user);
					}else{
						$add_array = array("entry_by" => $current_user);
					}
					$this->db->where('id', $rowid);
					$this->db->update('qa_phs_voice_v2_feedback',$add_array);
					
				}else{
					
					$field_array1=$this->input->post('data');
					$field_array1['call_date']=mmddyy2mysql($this->input->post('call_date'));
					if($_FILES['attach_file']['tmp_name'][0]!=''){
						$a = $this->mt_upload_files($_FILES['attach_file'],$path='./qa_files/qa_phs/phs/');
						$field_array1['attach_file'] = implode(',',$a);
					}
					$this->db->where('id', $voice_id);
					$this->db->update('qa_phs_voice_v2_feedback',$field_array1);
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
					$this->db->where('id', $voice_id);
					$this->db->update('qa_phs_voice_v2_feedback',$edit_array);
					
				}
				redirect('qa_phs');
			}
			$data["array"] = $a;
			$this->load->view("dashboard",$data);
		}
	}
    ///////////////////////voice Version 2 ends////////////////////////////////////

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
			$processName=$this->processName();
			$processCnt=count($processName);
			$data['processName']=$this->processName();
			$from_date = '';
			$to_date = '';
			$cond="";

			if(!empty($processCnt)){

				if($processCnt<=1){
						$qSql="Select count(id) as value from qa_".$page."_feedback where agent_id='$current_user' and audit_type in ('CQ Audit', 'BQ Audit')";
						$data["tot_feedback_".$page] =  $this->Common_model->get_single_value($qSql);
						
						$qSql="Select count(id) as value from qa_".$page."_feedback where agent_rvw_date is null and agent_id='$current_user' and audit_type in ('CQ Audit', 'BQ Audit') ";
						$data["yet_rvw_".$page] =  $this->Common_model->get_single_value($qSql);
					}else{

					for($i=0;$i<$processCnt;$i++){
						
						$qSql="Select count(id) as value from qa_".$page."_".$processName[$i]."_feedback where agent_id='$current_user' and audit_type in ('CQ Audit', 'BQ Audit')";
						$data["tot_feedback_".$processName[$i]] =  $this->Common_model->get_single_value($qSql);
						
						$qSql="Select count(id) as value from qa_".$page."_".$processName[$i]."_feedback where agent_rvw_date is null and agent_id='$current_user' and audit_type in ('CQ Audit', 'BQ Audit') ";
						$data["yet_rvw_".$processName[$i]] =  $this->Common_model->get_single_value($qSql);

					}

					}
					
				/*-----------------------*/
					$phs_chat_Sql1="Select count(id) as value from qa_phs_chat_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit')";
					$data["chat_pending"] =  $this->Common_model->get_single_value($phs_chat_Sql1);
					
					$phs_chat_Sql2="Select count(id) as value from qa_phs_chat_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit') and agent_rvw_date is Null";
					$data["yet_chat"] =  $this->Common_model->get_single_value($phs_chat_Sql2);
				////////////
					$phs_chat_Sql1="Select count(id) as value from qa_phs_email_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit')";
					$data["email_pending"] =  $this->Common_model->get_single_value($phs_chat_Sql1);
					
					$phs_chat_Sql2="Select count(id) as value from qa_phs_email_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit') and agent_rvw_date is Null";
					$data["yet_email"] =  $this->Common_model->get_single_value($phs_chat_Sql2);

					$phs_chat_Sql1="Select count(id) as value from qa_phs_chat_v2_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit')";
					$data["chat_v2_pending"] =  $this->Common_model->get_single_value($phs_chat_Sql1);
					
					$phs_chat_Sql2="Select count(id) as value from qa_phs_chat_v2_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit') and agent_rvw_date is Null";
					$data["yet_chat_v2"] =  $this->Common_model->get_single_value($phs_chat_Sql2);

					$phs_email_v2_Sql1="Select count(id) as value from qa_phs_email_v2_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit')";
					$data["email_v2_pending"] =  $this->Common_model->get_single_value($phs_email_v2_Sql1);
					
					$phs_email_v2_Sql2="Select count(id) as value from qa_phs_email_v2_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit') and agent_rvw_date is Null";
					$data["yet_email_v2"] =  $this->Common_model->get_single_value($phs_email_v2_Sql2);

					$phs_voice_v2_Sql1="Select count(id) as value from qa_phs_voice_v2_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit')";
					$data["voice_v2_pending"] =  $this->Common_model->get_single_value($phs_voice_v2_Sql1);
					
					$phs_voice_v2_Sql2="Select count(id) as value from qa_phs_voice_v2_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit') and agent_rvw_date is Null";
					$data["yet_voice_v2"] =  $this->Common_model->get_single_value($phs_voice_v2_Sql2);
				/*-----------------------*/

				}								
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
					
					if(!empty($processCnt)){
					 if($processCnt<=1){			
						$qSql="SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, (select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_name from qa_".$page."_feedback $cond) xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to from signin) yy on (xx.agent_id=yy.sid) order by audit_date";
						$data[$page."_agent_list"] = $this->Common_model->get_query_result_array($qSql);
						}else{
							for($i=0;$i<$processCnt;$i++){

								$qSql="SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, (select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_name from qa_".$page."_".$processName[$i]."_feedback $cond) xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to from signin) yy on (xx.agent_id=yy.sid) order by audit_date";
								$data[$page."_".$processName[$i]."_agent_list"] = $this->Common_model->get_query_result_array($qSql);	
							}
						}
					
					///////////////
					$qSql="SELECT * from
					(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
					(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
					(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
					(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_phs_chat_feedback $cond and agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit')) xx Left Join
					(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid)";
					$data["phs_chat"] = $this->Common_model->get_query_result_array($qSql);
					
					$qSql="SELECT * from
					(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
					(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
					(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
					(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_phs_email_feedback $cond and agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit')) xx Left Join
					(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid)";
					$data["phs_email"] = $this->Common_model->get_query_result_array($qSql);

					$qSql="SELECT * from
					(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
					(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
					(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
					(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_phs_chat_v2_feedback $cond and agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit')) xx Left Join
					(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid)";
					$data["phs_chat_v2"] = $this->Common_model->get_query_result_array($qSql);

					$qSql="SELECT * from
					(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
					(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
					(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
					(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_phs_email_v2_feedback $cond and agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit')) xx Left Join
					(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid)";
					$data["phs_email_v2"] = $this->Common_model->get_query_result_array($qSql);

					$qSql="SELECT * from
					(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
					(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
					(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
					(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_phs_voice_v2_feedback $cond and agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit')) xx Left Join
					(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid)";
					$data["phs_voice_v2"] = $this->Common_model->get_query_result_array($qSql);
					}
					}else{
					$cond= " Where agent_id='$current_user' and audit_type in ('CQ Audit', 'BQ Audit')";

					if(!empty($processCnt)){

					if($processCnt<=1){				

						$qSql="SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, (select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_name from qa_".$page."_feedback $cond) xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to from signin) yy on (xx.agent_id=yy.sid) order by audit_date";
						$data[$page."_agent_list"] = $this->Common_model->get_query_result_array($qSql);

					}else{

					for($i=0;$i<$processCnt;$i++){

							$qSql="SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, (select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_name from qa_".$page."_".$processName[$i]."_feedback $cond) xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to from signin) yy on (xx.agent_id=yy.sid) order by audit_date";
							$data[$page."_".$processName[$i]."_agent_list"] = $this->Common_model->get_query_result_array($qSql);	

							}

						}

					}
					
					///////////////
					$qSql="SELECT * from
					(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
					(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
					(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
					(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_phs_chat_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit')) xx Left Join
					(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid) Where xx.agent_rvw_date is Null";
					$data["phs_chat"] = $this->Common_model->get_query_result_array($qSql);
					
					$qSql="SELECT * from
					(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
					(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
					(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
					(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_phs_email_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit')) xx Left Join
					(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid) Where xx.agent_rvw_date is Null";
					$data["phs_email"] = $this->Common_model->get_query_result_array($qSql);

					$qSql="SELECT * from
					(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
					(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
					(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
					(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_phs_chat_v2_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit')) xx Left Join
					(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid)";
					$data["phs_chat_v2"] = $this->Common_model->get_query_result_array($qSql);

					$qSql="SELECT * from
					(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
					(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
					(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
					(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_phs_email_v2_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit')) xx Left Join
					(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid)";
					$data["phs_email_v2"] = $this->Common_model->get_query_result_array($qSql);

					$qSql="SELECT * from
					(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
					(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
					(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
					(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_phs_voice_v2_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit', 'Operation Audit', 'Trainer Audit')) xx Left Join
					(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid)";
					$data["phs_voice_v2"] = $this->Common_model->get_query_result_array($qSql);
				}
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			$this->load->view('dashboard',$data);
		}
	}
	/////////////////Agent Feecback end part//////////////////////////

	///////////////////////// Agent feedback RVW ////////////////////////////

	public function agent_process_rvw($id,$table){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			$page=$this->serviceName();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_".$page."/".$table."/agent_".$table."_rvw.php";
			$data["agentUrl"] = "qa_".$page."/agent_process_feedback";
			$data["content_js"] = "qa_".$page."_js.php";

			$processName=$this->processName();
			$processCnt=count($processName);
			if(!empty($processCnt)){

				if($processCnt<=1){
						$table=$page;
						$tableTemp=$table;
						$data["page"]=$table;
						$columname=$page."_columnname";
						$scoreParametername="parameter_".$page."_scrorecard_details";
						$scoreVal=$page."ScoreVal";
						$data["columname"]=$this->$columname();
						$data["scoreParametername"]=$this->$scoreParametername();
						$data["scoreVal"]=$this->$scoreVal();
				}else{

					if(in_array($table, $processName)){
						$tableTemp=$table;
						$table=$page."_".$tableTemp;
						$data["page"]=$table;
						$columname=$tableTemp."_columnname";
						$scoreParametername="parameter_".$tableTemp."_scrorecard_details";
						$scoreVal=$tableTemp."ScoreVal";
						$data["columname"]=$this->$columname();
						$data["scoreParametername"]=$this->$scoreParametername();
						$data["scoreVal"]=$this->$scoreVal();
					}
				}
			}
						
			$qSql="SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name, (select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_name,agent_rvw_note as agent_note,mgnt_rvw_note as mgnt_note from qa_".$table."_feedback where id=$id) xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to from signin) yy on (xx.agent_id=yy.sid) order by audit_date";

			$data[$table."_agnt_feedback"] = $this->Common_model->get_query_row_array($qSql);
			
			$data["pnid"]=$id;
			$data['scoreCard']=$this->scoreCard();			
			
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
				$this->db->update('qa_'.$table.'_feedback',$field_array);
				
				redirect('Qa_'.$page.'/process/agent');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	} 

	
	public function agent_phs_email_rvw($id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			$page=$this->serviceName();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_phs/phs_email/agent_phs_email_rvw.php";
			$data["agentUrl"] = "qa_".$page."/agent_process_feedback";
			$data["content_js"] = "qa_".$page."_js.php";
			
			$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_phs_email_feedback where id='$id') xx Left Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid)";
			$data["phs_email"] = $this->Common_model->get_query_row_array($qSql);
			
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
				$this->db->update('qa_phs_email_feedback',$field_array1);
				redirect('Qa_'.$page.'/process/agent');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}
	
	
	public function agent_phs_chat_rvw($id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			$page=$this->serviceName();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_phs/phs_chat/agent_phs_chat_rvw.php";
			$data["agentUrl"] = "qa_".$page."/agent_process_feedback";
			$data["content_js"] = "qa_".$page."_js.php";
			
			$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_phs_chat_feedback where id='$id') xx Left Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid)";
			$data["phs_chat"] = $this->Common_model->get_query_row_array($qSql);
			
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
				$this->db->update('qa_phs_chat_feedback',$field_array1);
				redirect('Qa_phs/agent_process_rvw');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}

	public function agent_phs_chat_v2_rvw($id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			$page=$this->serviceName();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_phs/phs_chat/agent_phs_chat_v2_rvw.php";
			$data["agentUrl"] = "qa_".$page."/agent_process_feedback";
			$data["content_js"] = "qa_".$page."_js.php";
			
			$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_phs_chat_v2_feedback where id='$id') xx Left Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid)";
			$data["phs_chat_v2"] = $this->Common_model->get_query_row_array($qSql);
			
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
				$this->db->update('qa_phs_chat_v2_feedback',$field_array1);
				redirect('Qa_phs/agent_process_feedback');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}

	public function agent_phs_email_v2_rvw($id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			$page=$this->serviceName();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_phs/phs_email/agent_phs_email_v2_rvw.php";
			$data["agentUrl"] = "qa_".$page."/agent_process_feedback";
			$data["content_js"] = "qa_".$page."_js.php";
			
			$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_phs_email_v2_feedback where id='$id') xx Left Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid)";
			$data["phs_email_v2"] = $this->Common_model->get_query_row_array($qSql);
			
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
				$this->db->update('qa_phs_email_v2_feedback',$field_array1);
				redirect('Qa_'.$page.'/process/agent');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}

	public function agent_phs_voice_v2_rvw($id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			$page=$this->serviceName();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_phs/phs/agent_phs_voice_v2_rvw.php";
			$data["agentUrl"] = "qa_".$page."/agent_process_feedback";
			$data["content_js"] = "qa_".$page."_js.php";
			
			$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_phs_voice_v2_feedback where id='$id') xx Left Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid)";
			$data["phs_voice_v2"] = $this->Common_model->get_query_row_array($qSql);
			
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
				$this->db->update('qa_phs_voice_v2_feedback',$field_array1);
				redirect('Qa_'.$page.'/process/agent');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}		
}