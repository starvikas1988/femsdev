<?php 

 class Qa_nordnet extends CI_Controller{
	
	public function __construct(){
		parent::__construct();
		$this->load->model('user_model');
		$this->load->model('Common_model');
		$this->load->model('CreateTable_model');
		$this->load->model('Qa_vrs_model');
	}

    ///////////////// Dynamic process name use function part//////////////////////////


	public function serviceName(){
		return "nordnet";
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
    	return $arrayName = array(100,50,0,'N/A');
    }

    public function nordnetScoreVal(){
    	return $arrayName = array(1,2,1,2,3,1,2,3,3,2,1);
    }

    public function nordnet_columnname(){
    	return array("cust_welcome","smile_courtesy","french_expression","put_hold","inappr_hold","taking_leave","identification_client","ans_expected","quality_explanations","use_tool","attitude_vendeurs");
    }

    public function parameter_nordnet_comments_details(){
    	return array("Customer welcome","Smile and courtesy of the advisor","French expression of the counselor","Put on hold","Inappropriate hold?","Taking leave","Identification of the client and his request","Is the answer the one expected?","Quality of explanations and customer support","Use of tool","Attitude Tous vendeurs");
    }

    public function parameter_nordnet_scrorecard_details(){
    	return array("Accueil du client (politesse, respect de la phrase d'accueil)","Sourire et courtoisie du conseiller (climat général de l'interaction)","Expression française du conseiller (prononciation des mots (oral) / usage de la grammaire (écrit))","Mise en attente","Mise en attente inappropriée ? Trop longue ? Sans présenter ses excuses ?","Prise de congé","Identification du client et de sa demande (questionnement, écoute active, reformulation, etc.)","La réponse est celle attendue ? ( Efficacité)","Qualité des explications et accompagnement du client","Utilisation des outils (gestes welcome, purecloud, outils externes à welcome)","l'agent promeut les produits de l'entreprise la migration supérieure les options etc auprès des clients");  /// not required for english lang
    }

    ///////////////// Dynamic View table scorcard column name and scorecard plus dynamic sql help table creation process wise function end part//////////////////////////


    ///////////////// Dynamic single multi Process table creation qa_defect and process table update part//////////////////////////


    public function doAllDBTableWorkQA_Controller($custcomp=""){

    		$process=$this->processId();
    		$Client=$this->clientId();
    		$processName=$this->processName();
			$processCnt=count($processName);
			$page=$this->serviceName();
			$dbname=$this->db->database
			;
			if(!empty($processCnt)){
				
				$createdTableorNot="1";
				
				$qSql="SELECT COUNT(*) as value FROM information_schema.tables WHERE table_schema = '".$dbname."' AND table_name = 'qa_".$page."_feedback';";
				
				$hasTable = $this->Common_model->get_single_value($qSql);
				
				if($hasTable==0){
					
					$createdTableorNot="0";
					
					if($processCnt<=1){

								$header=$page."headerColumn";
								$header=$this->$header();
								$column_val=$page."_columnname";
								$comment_val="parameter_".$page."_comments_details";
								$column_val=$this->$column_val();
								$comment_val=$this->$comment_val();

								$createdTableorNot=$this->CreateTable_model->doAllDBTableWorkQA($custcomp,$process[0],$Client[0],$processName,$page,$dbname,$header,$column_val,$comment_val,$MtoS_Dashboard_Process=1,$process);

					}else{

						for($i=0;$i<$processCnt;$i++){
						
								$header=$processName[$i]."headerColumn";
								$header=$this->$header();
								$column_val=$processName[$i]."_columnname";
								$comment_val="parameter_".$processName[$i]."_comments_details";
								$column_val=$this->$column_val();
								$comment_val=$this->$comment_val();

								$createdTableorNot=$this->CreateTable_model->doAllDBTableWorkQA($custcomp,$process[$i],$Client[0],$processName[$i],$page,$dbname,$header,$column_val,$comment_val,$MtoS_Dashboard_Process=1,$process);

						}
					
					}
				}else{
					$createdTableorNot="1";
				}
			
			return $createdTableorNot;

		}else{
			return "Error no processName";
		}

    }

    ///////////////// Dynamic single multi Process table creation qa_defect and process table update end part//////////////////////////


    ///////////////// Process wise extra header column Name part//////////////////////////


    public function nordnetheaderColumn(){
		return	array();
	}

    ///////////////// Process wise extra header column Name end part//////////////////////////

    ///////////////// Process wise client process id details part//////////////////////////

    public function clientId(){
    	return $clientId= array(178);
    }

    public function processId(){
    	return $processId=array(371);	
    }

    ///////////////// Process wise client process id details end part//////////////////////////

    ///////////////// Process wise processName part//////////////////////////

    public function processName(){
    	return array("nordnet");
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

    	
    		$processId_str=implode(",",$processId);
			
			$ProcessInAgent = " And is_assign_process (id,'$processId_str') ";
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 ".$ProcessInAgent."  and status=1  order by name";
    		

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
			
			//Only run one time to set index in an existing table. Then comment it.
			//$this->CreateTable_model->arrayIndexColumn($page);
			
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


			$tableCreated=$this->doAllDBTableWorkQA_Controller();		

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
			
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			$data["agent_id"] = $agent_id;
			
			$this->load->view("dashboard_no_ameyo",$data);
		}else{
			echo "Table not created";
		}

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
			
			// $qSql = "SELECT id,fname,lname FROM signin where id not in (select id from role where folder='agent')";
			$data['tlname'] = array();
			$curDateTime=CurrMySqlDate();
			$data["stratAuditTime"]=$curDateTime;
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
			
			$this->load->view("dashboard_no_ameyo",$data);
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
			
			// $qSql = "SELECT id,fname,lname FROM signin where id not in (select id from role where folder='agent')";
			$data['tlname'] = array();
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

	////////////////////////  Agent feedback end RVW ///////////////////////////
	
 }