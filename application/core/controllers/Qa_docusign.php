<?php 

 class Qa_docusign extends CI_Controller{
	
	public function __construct(){
		parent::__construct();
		$this->load->model('user_model');
		$this->load->model('Common_model');
	}
	
	private function ds_upload_files($files,$path){
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
            }else{
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
			$data["content_template"] = "qa_docusign/qa_feedback.php";
			$data["content_js"] = "qa_kabbage_js.php";
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,30) and status=1  order by name";
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
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_docusign_email_feedback $cond) xx Left Join
				(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";
			$data["docu_email"] = $this->Common_model->get_query_result_array($qSql);
			
			
			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_docusign_phone_chat_feedback $cond) xx Left Join
				(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";
			$data["docu_phonechat"] = $this->Common_model->get_query_result_array($qSql);

			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_docusign_feedback $cond) xx Left Join
				(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";
			$data["docu_new"] = $this->Common_model->get_query_result_array($qSql);

			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_docusign_sales_feedback $cond) xx Left Join
				(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid) $ops_cond order by audit_date";
			$data["docu_sales"] = $this->Common_model->get_query_result_array($qSql);
			
			
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			$data["agent_id"] = $agent_id;
			
			$this->load->view("dashboard",$data);
		}
	}


//////////////////////// EMAIL ///////////////////////	
////////////	
	public function add_feedback($stratEmailAuditTime){
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_docusign/add_feedback.php";
			$data["content_js"] = "qa_kabbage_js.php";
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,30) and status=1 order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
			$data["stratEmailAuditTime"]=$stratEmailAuditTime;
			
			$audit_start_time = $this->input->post('audit_start_time');
			$curDateTime=CurrMySqlDate();
			$a = array();
			
			if($this->input->post('agent_id')){
				$field_array=array(
					"audit_date" => CurrDate(),
					"agent_id" => $this->input->post('agent_id'),
					"tl_id" => $this->input->post('tl_id'),
					"call_date" => mmddyy2mysql($this->input->post('call_date')),
					"case_no" => $this->input->post('case_no'),
					"call_duration" => $this->input->post('call_duration'),
					"topic" => $this->input->post('topic'),
					"subtopic" => $this->input->post('subtopic'),
					"oppor_area" => $this->input->post('oppor_area'),
					"audit_type" => $this->input->post('audit_type'),
					"auditor_type" => $this->input->post('auditor_type'),
					"voc" => $this->input->post('voc'),
					"possible_score" => $this->input->post('possible_score'),
					"earned_score" => $this->input->post('earned_score'),
					"overall_score" => $this->input->post('overall_score'),
					"adminPropertyVerify" => $this->input->post('adminPropertyVerify'),
					"donotCloseCorporateAccount" => $this->input->post('donotCloseCorporateAccount'),
					"submitAllEligibleRefund" => $this->input->post('submitAllEligibleRefund'),
					"properlySubmitACR" => $this->input->post('properlySubmitACR'),
					"obtainRetainPermission" => $this->input->post('obtainRetainPermission'),
					"verifyAccountBillingInfo" => $this->input->post('verifyAccountBillingInfo'),
					"volunteerPIIInformation" => $this->input->post('volunteerPIIInformation'),
					"managerDeleteCustomerPII" => $this->input->post('managerDeleteCustomerPII'),
					"customerCallMaybeRecorded" => $this->input->post('customerCallMaybeRecorded'),
					"engageReverseScreening" => $this->input->post('engageReverseScreening'),
					"sendAllEmailComunication" => $this->input->post('sendAllEmailComunication'),
					"doesnotProvidePersonalEmail" => $this->input->post('doesnotProvidePersonalEmail'),
					"observesCustomerContact" => $this->input->post('observesCustomerContact'),
					"directCustomerAMScenario" => $this->input->post('directCustomerAMScenario'),
					"doesnotEnablePaidFeature" => $this->input->post('doesnotEnablePaidFeature'),
					"properlyInformAccountManager" => $this->input->post('properlyInformAccountManager'),
					"followstheFlowchart" => $this->input->post('followstheFlowchart'),
					"caseSubjectAreHighLevel" => $this->input->post('caseSubjectAreHighLevel'),
					"caseSubjectFieldnotInclude" => $this->input->post('caseSubjectFieldnotInclude'),
					"taxonomyStatusFieldAccurate" => $this->input->post('taxonomyStatusFieldAccurate'),
					"duplicateCaseProperlyTied" => $this->input->post('duplicateCaseProperlyTied'),
					"caseDescriptionFieldContain" => $this->input->post('caseDescriptionFieldContain'),
					"caseTiedCorrectContact" => $this->input->post('caseTiedCorrectContact'),
					"expartFirstRespondtoPortal" => $this->input->post('expartFirstRespondtoPortal'),
					"expertNeverAssign" => $this->input->post('expertNeverAssign'),
					"allInformationRelevent" => $this->input->post('allInformationRelevent'),
					"clearlyDocumentedCallDisconnect" => $this->input->post('clearlyDocumentedCallDisconnect'),
					"envelopeIDsInformation" => $this->input->post('envelopeIDsInformation'),
					"expertRefrainNegativeComment" => $this->input->post('expertRefrainNegativeComment'),
					"unresponsiveFollowup" => $this->input->post('unresponsiveFollowup'),
					"customerRepliesBusinessDay" => $this->input->post('customerRepliesBusinessDay'),
					"agreedUponFollowup" => $this->input->post('agreedUponFollowup'),
					"expertObtainOwenership" => $this->input->post('expertObtainOwenership'),
					"technicalInformationAccurate" => $this->input->post('technicalInformationAccurate'),
					"useTargetedProbingQuestion" => $this->input->post('useTargetedProbingQuestion'),
					"performLogicalTroubleshooting" => $this->input->post('performLogicalTroubleshooting'),
					"attemptOfferAllTroubleshooting" => $this->input->post('attemptOfferAllTroubleshooting'),
					"appropiateAcknowledgeResponce" => $this->input->post('appropiateAcknowledgeResponce'),
					"maintainFriendlyInteraction" => $this->input->post('maintainFriendlyInteraction'),
					"stayFocusAndConcise" => $this->input->post('stayFocusAndConcise'),
					"refrainFromUsingLanguage" => $this->input->post('refrainFromUsingLanguage'),
					"demonstrateActiveListening" => $this->input->post('demonstrateActiveListening'),
					"appropiateAdviseCaseStatus" => $this->input->post('appropiateAdviseCaseStatus'),
					"followTroughWithExpectation" => $this->input->post('followTroughWithExpectation'),
					"customerTestFilesSent" => $this->input->post('customerTestFilesSent'),
					"closeAllScreenSharing" => $this->input->post('closeAllScreenSharing'),
					"toworFewerSpelling" => $this->input->post('toworFewerSpelling'),
					"allSpecializedCompanyBranding" => $this->input->post('allSpecializedCompanyBranding'),
					"cmt1" => $this->input->post('cmt1'),
					"cmt2" => $this->input->post('cmt2'),
					"cmt3" => $this->input->post('cmt3'),
					"cmt4" => $this->input->post('cmt4'),
					"cmt5" => $this->input->post('cmt5'),
					"cmt6" => $this->input->post('cmt6'),
					"cmt7" => $this->input->post('cmt7'),
					"cmt8" => $this->input->post('cmt8'),
					"cmt9" => $this->input->post('cmt9'),
					"cmt10" => $this->input->post('cmt10'),
					"cmt11" => $this->input->post('cmt11'),
					"cmt12" => $this->input->post('cmt12'),
					"cmt13" => $this->input->post('cmt13'),
					"cmt14" => $this->input->post('cmt14'),
					"cmt15" => $this->input->post('cmt15'),
					"cmt16" => $this->input->post('cmt16'),
					"cmt17" => $this->input->post('cmt17'),
					"cmt18" => $this->input->post('cmt18'),
					"cmt19" => $this->input->post('cmt19'),
					"cmt20" => $this->input->post('cmt20'),
					"cmt21" => $this->input->post('cmt21'),
					"cmt22" => $this->input->post('cmt22'),
					"cmt23" => $this->input->post('cmt23'),
					"cmt24" => $this->input->post('cmt24'),
					"cmt25" => $this->input->post('cmt25'),
					"cmt26" => $this->input->post('cmt26'),
					"cmt27" => $this->input->post('cmt27'),
					"cmt28" => $this->input->post('cmt28'),
					"cmt29" => $this->input->post('cmt29'),
					"cmt30" => $this->input->post('cmt30'),
					"cmt31" => $this->input->post('cmt31'),
					"cmt32" => $this->input->post('cmt32'),
					"cmt33" => $this->input->post('cmt33'),
					"cmt34" => $this->input->post('cmt34'),
					"cmt35" => $this->input->post('cmt35'),
					"cmt36" => $this->input->post('cmt36'),
					"cmt37" => $this->input->post('cmt37'),
					"cmt38" => $this->input->post('cmt38'),
					"cmt39" => $this->input->post('cmt39'),
					"cmt40" => $this->input->post('cmt40'),
					"cmt41" => $this->input->post('cmt41'),
					"cmt42" => $this->input->post('cmt42'),
					"cmt43" => $this->input->post('cmt43'),
					"cmt44" => $this->input->post('cmt44'),
					"cmt45" => $this->input->post('cmt45'),
					"cmt46" => $this->input->post('cmt46'),
					"cmt47" => $this->input->post('cmt47'),
					"cmt48" => $this->input->post('cmt48'),
					"call_summary" => $this->input->post('call_summary'),
					"feedback" => $this->input->post('feedback'),
					"audit_start_time" => $audit_start_time,
					"entry_date" => $curDateTime
				);
				$a = $this->ds_upload_files($_FILES['attach_file'], $path='./qa_files/qa_docusign/email/');
				$field_array["attach_file"] = implode(',',$a);
				$rowid= data_inserter('qa_docusign_email_feedback',$field_array);
				
			/////////////	
				if(get_login_type()=="client"){
					$field_array1 = array("client_entryby" => $current_user);
				}else{
					$field_array1 = array("entry_by" => $current_user);
				}
				$this->db->where('id', $rowid);
				$this->db->update('qa_docusign_email_feedback',$field_array1);
			///////////	
				redirect('Qa_docusign');
			}
			$data["array"] = $a;
			
			$this->load->view("dashboard",$data);
		}
	}
	
	
	
	public function mgnt_docusign_rvw($id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_docusign/mgnt_rvw.php";
			$data["content_js"] = "qa_kabbage_js.php";
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM signin where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,30) and status=1 order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_docusign_email_feedback where id='$id') xx Left Join
				(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid)";
			$data["docu_feedback"] = $this->Common_model->get_query_row_array($qSql);
			
			$data["dsid"]=$id;
			
		///////Edit Part///////	
			if($this->input->post('dsid'))
			{
				$dsid=$this->input->post('dsid');
				$curDateTime=CurrMySqlDate();
				$log=get_logs();
				
				$field_array = array(
					"agent_id" => $this->input->post('agent_id'),
					"tl_id" => $this->input->post('tl_id'),
					"call_date" => mmddyy2mysql($this->input->post('call_date')),
					"case_no" => $this->input->post('case_no'),
					"call_duration" => $this->input->post('call_duration'),
					"topic" => $this->input->post('topic'),
					"subtopic" => $this->input->post('subtopic'),
					"oppor_area" => $this->input->post('oppor_area'),
					"audit_type" => $this->input->post('audit_type'),
					"auditor_type" => $this->input->post('auditor_type'),
					"voc" => $this->input->post('voc'),
					"possible_score" => $this->input->post('possible_score'),
					"earned_score" => $this->input->post('earned_score'),
					"overall_score" => $this->input->post('overall_score'),
					"adminPropertyVerify" => $this->input->post('adminPropertyVerify'),
					"donotCloseCorporateAccount" => $this->input->post('donotCloseCorporateAccount'),
					"submitAllEligibleRefund" => $this->input->post('submitAllEligibleRefund'),
					"properlySubmitACR" => $this->input->post('properlySubmitACR'),
					"obtainRetainPermission" => $this->input->post('obtainRetainPermission'),
					"verifyAccountBillingInfo" => $this->input->post('verifyAccountBillingInfo'),
					"volunteerPIIInformation" => $this->input->post('volunteerPIIInformation'),
					"managerDeleteCustomerPII" => $this->input->post('managerDeleteCustomerPII'),
					"customerCallMaybeRecorded" => $this->input->post('customerCallMaybeRecorded'),
					"engageReverseScreening" => $this->input->post('engageReverseScreening'),
					"sendAllEmailComunication" => $this->input->post('sendAllEmailComunication'),
					"doesnotProvidePersonalEmail" => $this->input->post('doesnotProvidePersonalEmail'),
					"observesCustomerContact" => $this->input->post('observesCustomerContact'),
					"directCustomerAMScenario" => $this->input->post('directCustomerAMScenario'),
					"doesnotEnablePaidFeature" => $this->input->post('doesnotEnablePaidFeature'),
					"properlyInformAccountManager" => $this->input->post('properlyInformAccountManager'),
					"followstheFlowchart" => $this->input->post('followstheFlowchart'),
					"caseSubjectAreHighLevel" => $this->input->post('caseSubjectAreHighLevel'),
					"caseSubjectFieldnotInclude" => $this->input->post('caseSubjectFieldnotInclude'),
					"taxonomyStatusFieldAccurate" => $this->input->post('taxonomyStatusFieldAccurate'),
					"duplicateCaseProperlyTied" => $this->input->post('duplicateCaseProperlyTied'),
					"caseDescriptionFieldContain" => $this->input->post('caseDescriptionFieldContain'),
					"caseTiedCorrectContact" => $this->input->post('caseTiedCorrectContact'),
					"expartFirstRespondtoPortal" => $this->input->post('expartFirstRespondtoPortal'),
					"expertNeverAssign" => $this->input->post('expertNeverAssign'),
					"allInformationRelevent" => $this->input->post('allInformationRelevent'),
					"clearlyDocumentedCallDisconnect" => $this->input->post('clearlyDocumentedCallDisconnect'),
					"envelopeIDsInformation" => $this->input->post('envelopeIDsInformation'),
					"expertRefrainNegativeComment" => $this->input->post('expertRefrainNegativeComment'),
					"unresponsiveFollowup" => $this->input->post('unresponsiveFollowup'),
					"customerRepliesBusinessDay" => $this->input->post('customerRepliesBusinessDay'),
					"agreedUponFollowup" => $this->input->post('agreedUponFollowup'),
					"expertObtainOwenership" => $this->input->post('expertObtainOwenership'),
					"technicalInformationAccurate" => $this->input->post('technicalInformationAccurate'),
					"useTargetedProbingQuestion" => $this->input->post('useTargetedProbingQuestion'),
					"performLogicalTroubleshooting" => $this->input->post('performLogicalTroubleshooting'),
					"attemptOfferAllTroubleshooting" => $this->input->post('attemptOfferAllTroubleshooting'),
					"appropiateAcknowledgeResponce" => $this->input->post('appropiateAcknowledgeResponce'),
					"maintainFriendlyInteraction" => $this->input->post('maintainFriendlyInteraction'),
					"stayFocusAndConcise" => $this->input->post('stayFocusAndConcise'),
					"refrainFromUsingLanguage" => $this->input->post('refrainFromUsingLanguage'),
					"demonstrateActiveListening" => $this->input->post('demonstrateActiveListening'),
					"appropiateAdviseCaseStatus" => $this->input->post('appropiateAdviseCaseStatus'),
					"followTroughWithExpectation" => $this->input->post('followTroughWithExpectation'),
					"customerTestFilesSent" => $this->input->post('customerTestFilesSent'),
					"closeAllScreenSharing" => $this->input->post('closeAllScreenSharing'),
					"toworFewerSpelling" => $this->input->post('toworFewerSpelling'),
					"allSpecializedCompanyBranding" => $this->input->post('allSpecializedCompanyBranding'),
					"cmt1" => $this->input->post('cmt1'),
					"cmt2" => $this->input->post('cmt2'),
					"cmt3" => $this->input->post('cmt3'),
					"cmt4" => $this->input->post('cmt4'),
					"cmt5" => $this->input->post('cmt5'),
					"cmt6" => $this->input->post('cmt6'),
					"cmt7" => $this->input->post('cmt7'),
					"cmt8" => $this->input->post('cmt8'),
					"cmt9" => $this->input->post('cmt9'),
					"cmt10" => $this->input->post('cmt10'),
					"cmt11" => $this->input->post('cmt11'),
					"cmt12" => $this->input->post('cmt12'),
					"cmt13" => $this->input->post('cmt13'),
					"cmt14" => $this->input->post('cmt14'),
					"cmt15" => $this->input->post('cmt15'),
					"cmt16" => $this->input->post('cmt16'),
					"cmt17" => $this->input->post('cmt17'),
					"cmt18" => $this->input->post('cmt18'),
					"cmt19" => $this->input->post('cmt19'),
					"cmt20" => $this->input->post('cmt20'),
					"cmt21" => $this->input->post('cmt21'),
					"cmt22" => $this->input->post('cmt22'),
					"cmt23" => $this->input->post('cmt23'),
					"cmt24" => $this->input->post('cmt24'),
					"cmt25" => $this->input->post('cmt25'),
					"cmt26" => $this->input->post('cmt26'),
					"cmt27" => $this->input->post('cmt27'),
					"cmt28" => $this->input->post('cmt28'),
					"cmt29" => $this->input->post('cmt29'),
					"cmt30" => $this->input->post('cmt30'),
					"cmt31" => $this->input->post('cmt31'),
					"cmt32" => $this->input->post('cmt32'),
					"cmt33" => $this->input->post('cmt33'),
					"cmt34" => $this->input->post('cmt34'),
					"cmt35" => $this->input->post('cmt35'),
					"cmt36" => $this->input->post('cmt36'),
					"cmt37" => $this->input->post('cmt37'),
					"cmt38" => $this->input->post('cmt38'),
					"cmt39" => $this->input->post('cmt39'),
					"cmt40" => $this->input->post('cmt40'),
					"cmt41" => $this->input->post('cmt41'),
					"cmt42" => $this->input->post('cmt42'),
					"cmt43" => $this->input->post('cmt43'),
					"cmt44" => $this->input->post('cmt44'),
					"cmt45" => $this->input->post('cmt45'),
					"cmt46" => $this->input->post('cmt46'),
					"cmt47" => $this->input->post('cmt47'),
					"cmt48" => $this->input->post('cmt48'),
					"call_summary" => $this->input->post('call_summary'),
					"feedback" => $this->input->post('feedback')
				);
				$this->db->where('id', $dsid);
				$this->db->update('qa_docusign_email_feedback',$field_array);
				
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
				$this->db->where('id', $dsid);
				$this->db->update('qa_docusign_email_feedback',$field_array1);
			///////////	
				redirect('Qa_docusign');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}
	
	
////////////////////// PHONE & CHAT ///////////////////////////
///////////////
	public function add_phonechat($startPhoneChatAuditTime){
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_docusign/add_phonechat.php";
			$data["content_js"] = "qa_kabbage_js.php";
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,30) and status=1 order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
			$data['startPhoneChatAuditTime']=$startPhoneChatAuditTime;
			
			$audit_start_time = $this->input->post('audit_start_time');
			$curDateTime=CurrMySqlDate();
			$a = array();
			
			if($this->input->post('agent_id')){
				$field_array=array(
					"audit_date" => CurrDate(),
					"agent_id" => $this->input->post('agent_id'),
					"tl_id" => $this->input->post('tl_id'),
					"call_date" => mmddyy2mysql($this->input->post('call_date')),
					"case_no" => $this->input->post('case_no'),
					"call_duration" => $this->input->post('call_duration'),
					"topic" => $this->input->post('topic'),
					"subtopic" => $this->input->post('subtopic'),
					"oppor_area" => $this->input->post('oppor_area'),
					"audit_type" => $this->input->post('audit_type'),
					"auditor_type" => $this->input->post('auditor_type'),
					"voc" => $this->input->post('voc'),
					"possible_score" => $this->input->post('possible_score'),
					"earned_score" => $this->input->post('earned_score'),
					"overall_score" => $this->input->post('overall_score'),
					"adminPropertyVerify" => $this->input->post('adminPropertyVerify'),
					"donotCloseCorporateAccount" => $this->input->post('donotCloseCorporateAccount'),
					"submitAllEligibleRefund" => $this->input->post('submitAllEligibleRefund'),
					"properlySubmitACR" => $this->input->post('properlySubmitACR'),
					"obtainRetainPermission" => $this->input->post('obtainRetainPermission'),
					"verifyAccountBillingInfo" => $this->input->post('verifyAccountBillingInfo'),
					"volunteerPIIInformation" => $this->input->post('volunteerPIIInformation'),
					"managerDeleteCustomerPII" => $this->input->post('managerDeleteCustomerPII'),
					"customerCallMaybeRecorded" => $this->input->post('customerCallMaybeRecorded'),
					"engageReverseScreening" => $this->input->post('engageReverseScreening'),
					"sendAllEmailComunication" => $this->input->post('sendAllEmailComunication'),
					"doesnotProvidePersonalEmail" => $this->input->post('doesnotProvidePersonalEmail'),
					"observesCustomerContact" => $this->input->post('observesCustomerContact'),
					"directCustomerAMScenario" => $this->input->post('directCustomerAMScenario'),
					"doesnotEnablePaidFeature" => $this->input->post('doesnotEnablePaidFeature'),
					"properlyInformAccountManager" => $this->input->post('properlyInformAccountManager'),
					"followstheFlowchart" => $this->input->post('followstheFlowchart'),
					"caseSubjectAreHighLevel" => $this->input->post('caseSubjectAreHighLevel'),
					"caseSubjectFieldnotInclude" => $this->input->post('caseSubjectFieldnotInclude'),
					"taxonomyStatusFieldAccurate" => $this->input->post('taxonomyStatusFieldAccurate'),
					"duplicateCaseProperlyTied" => $this->input->post('duplicateCaseProperlyTied'),
					"caseDescriptionFieldContain" => $this->input->post('caseDescriptionFieldContain'),
					"caseTiedCorrectContact" => $this->input->post('caseTiedCorrectContact'),
					"expartFirstRespondtoPortal" => $this->input->post('expartFirstRespondtoPortal'),
					"expertNeverAssign" => $this->input->post('expertNeverAssign'),
					"allInformationRelevent" => $this->input->post('allInformationRelevent'),
					"clearlyDocumentedCallDisconnect" => $this->input->post('clearlyDocumentedCallDisconnect'),
					"envelopeIDsInformation" => $this->input->post('envelopeIDsInformation'),
					"expertRefrainNegativeComment" => $this->input->post('expertRefrainNegativeComment'),
					"unresponsiveFollowup" => $this->input->post('unresponsiveFollowup'),
					"customerRepliesBusinessDay" => $this->input->post('customerRepliesBusinessDay'),
					"agreedUponFollowup" => $this->input->post('agreedUponFollowup'),
					"expertObtainOwenership" => $this->input->post('expertObtainOwenership'),
					"technicalInformationAccurate" => $this->input->post('technicalInformationAccurate'),
					"useTargetedProbingQuestion" => $this->input->post('useTargetedProbingQuestion'),
					"performLogicalTroubleshooting" => $this->input->post('performLogicalTroubleshooting'),
					"attemptOfferAllTroubleshooting" => $this->input->post('attemptOfferAllTroubleshooting'),
					"appropiateAcknowledgeResponce" => $this->input->post('appropiateAcknowledgeResponce'),
					"maintainFriendlyInteraction" => $this->input->post('maintainFriendlyInteraction'),
					"stayFocusAndConcise" => $this->input->post('stayFocusAndConcise'),
					"refrainFromUsingLanguage" => $this->input->post('refrainFromUsingLanguage'),
					"demonstrateActiveListening" => $this->input->post('demonstrateActiveListening'),
					"appropiateAdviseCaseStatus" => $this->input->post('appropiateAdviseCaseStatus'),
					"setHoldMuteExpectation" => $this->input->post('setHoldMuteExpectation'),
					"followTroughWithExpectation" => $this->input->post('followTroughWithExpectation'),
					"customerTestFilesSent" => $this->input->post('customerTestFilesSent'),
					"closeAllScreenSharing" => $this->input->post('closeAllScreenSharing'),
					"toworFewerSpelling" => $this->input->post('toworFewerSpelling'),
					"allSpecializedCompanyBranding" => $this->input->post('allSpecializedCompanyBranding'),
					"cmt1" => $this->input->post('cmt1'),
					"cmt2" => $this->input->post('cmt2'),
					"cmt3" => $this->input->post('cmt3'),
					"cmt4" => $this->input->post('cmt4'),
					"cmt5" => $this->input->post('cmt5'),
					"cmt6" => $this->input->post('cmt6'),
					"cmt7" => $this->input->post('cmt7'),
					"cmt8" => $this->input->post('cmt8'),
					"cmt9" => $this->input->post('cmt9'),
					"cmt10" => $this->input->post('cmt10'),
					"cmt11" => $this->input->post('cmt11'),
					"cmt12" => $this->input->post('cmt12'),
					"cmt13" => $this->input->post('cmt13'),
					"cmt14" => $this->input->post('cmt14'),
					"cmt15" => $this->input->post('cmt15'),
					"cmt16" => $this->input->post('cmt16'),
					"cmt17" => $this->input->post('cmt17'),
					"cmt18" => $this->input->post('cmt18'),
					"cmt19" => $this->input->post('cmt19'),
					"cmt20" => $this->input->post('cmt20'),
					"cmt21" => $this->input->post('cmt21'),
					"cmt22" => $this->input->post('cmt22'),
					"cmt23" => $this->input->post('cmt23'),
					"cmt24" => $this->input->post('cmt24'),
					"cmt25" => $this->input->post('cmt25'),
					"cmt26" => $this->input->post('cmt26'),
					"cmt27" => $this->input->post('cmt27'),
					"cmt28" => $this->input->post('cmt28'),
					"cmt29" => $this->input->post('cmt29'),
					"cmt30" => $this->input->post('cmt30'),
					"cmt31" => $this->input->post('cmt31'),
					"cmt32" => $this->input->post('cmt32'),
					"cmt33" => $this->input->post('cmt33'),
					"cmt34" => $this->input->post('cmt34'),
					"cmt35" => $this->input->post('cmt35'),
					"cmt36" => $this->input->post('cmt36'),
					"cmt37" => $this->input->post('cmt37'),
					"cmt38" => $this->input->post('cmt38'),
					"cmt39" => $this->input->post('cmt39'),
					"cmt40" => $this->input->post('cmt40'),
					"cmt41" => $this->input->post('cmt41'),
					"cmt42" => $this->input->post('cmt42'),
					"cmt43" => $this->input->post('cmt43'),
					"cmt44" => $this->input->post('cmt44'),
					"cmt45" => $this->input->post('cmt45'),
					"cmt46" => $this->input->post('cmt46'),
					"cmt47" => $this->input->post('cmt47'),
					"cmt48" => $this->input->post('cmt48'),
					"cmt49" => $this->input->post('cmt49'),
					"call_summary" => $this->input->post('call_summary'),
					"feedback" => $this->input->post('feedback'),
					"audit_start_time" => $audit_start_time,
					"entry_date" => $curDateTime
				);
				$a = $this->ds_upload_files($_FILES['attach_file'], $path='./qa_files/qa_docusign/phone_chat/');
				$field_array["attach_file"] = implode(',',$a);
				$rowid= data_inserter('qa_docusign_phone_chat_feedback',$field_array);
				
			/////////////	
				if(get_login_type()=="client"){
					$field_array1 = array("client_entryby" => $current_user);
				}else{
					$field_array1 = array("entry_by" => $current_user);
				}
				$this->db->where('id', $rowid);
				$this->db->update('qa_docusign_phone_chat_feedback',$field_array1);
			///////////	
				redirect('Qa_docusign');
			}
			$data["array"] = $a;
			
			$this->load->view("dashboard",$data);
		}
	}
	
	
	
	public function mgnt_phonechat_rvw($id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_docusign/mgnt_phonechat_rvw.php";
			$data["content_js"] = "qa_kabbage_js.php";
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM signin where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,30) and status=1 order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_docusign_phone_chat_feedback where id='$id') xx Left Join
				(Select id as sid, fname, lname, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid)";
			$data["docu_feedback"] = $this->Common_model->get_query_row_array($qSql);
			
			$data["dsid"]=$id;
			
		///////Edit Part///////	
			if($this->input->post('dsid'))
			{
				$dsid=$this->input->post('dsid');
				$curDateTime=CurrMySqlDate();
				$log=get_logs();
				
				$field_array = array(
					"agent_id" => $this->input->post('agent_id'),
					"tl_id" => $this->input->post('tl_id'),
					"call_date" => mmddyy2mysql($this->input->post('call_date')),
					"case_no" => $this->input->post('case_no'),
					"call_duration" => $this->input->post('call_duration'),
					"topic" => $this->input->post('topic'),
					"subtopic" => $this->input->post('subtopic'),
					"oppor_area" => $this->input->post('oppor_area'),
					"audit_type" => $this->input->post('audit_type'),
					"auditor_type" => $this->input->post('auditor_type'),
					"voc" => $this->input->post('voc'),
					"possible_score" => $this->input->post('possible_score'),
					"earned_score" => $this->input->post('earned_score'),
					"overall_score" => $this->input->post('overall_score'),
					"adminPropertyVerify" => $this->input->post('adminPropertyVerify'),
					"donotCloseCorporateAccount" => $this->input->post('donotCloseCorporateAccount'),
					"submitAllEligibleRefund" => $this->input->post('submitAllEligibleRefund'),
					"properlySubmitACR" => $this->input->post('properlySubmitACR'),
					"obtainRetainPermission" => $this->input->post('obtainRetainPermission'),
					"verifyAccountBillingInfo" => $this->input->post('verifyAccountBillingInfo'),
					"volunteerPIIInformation" => $this->input->post('volunteerPIIInformation'),
					"managerDeleteCustomerPII" => $this->input->post('managerDeleteCustomerPII'),
					"customerCallMaybeRecorded" => $this->input->post('customerCallMaybeRecorded'),
					"engageReverseScreening" => $this->input->post('engageReverseScreening'),
					"sendAllEmailComunication" => $this->input->post('sendAllEmailComunication'),
					"doesnotProvidePersonalEmail" => $this->input->post('doesnotProvidePersonalEmail'),
					"observesCustomerContact" => $this->input->post('observesCustomerContact'),
					"directCustomerAMScenario" => $this->input->post('directCustomerAMScenario'),
					"doesnotEnablePaidFeature" => $this->input->post('doesnotEnablePaidFeature'),
					"properlyInformAccountManager" => $this->input->post('properlyInformAccountManager'),
					"followstheFlowchart" => $this->input->post('followstheFlowchart'),
					"caseSubjectAreHighLevel" => $this->input->post('caseSubjectAreHighLevel'),
					"caseSubjectFieldnotInclude" => $this->input->post('caseSubjectFieldnotInclude'),
					"taxonomyStatusFieldAccurate" => $this->input->post('taxonomyStatusFieldAccurate'),
					"duplicateCaseProperlyTied" => $this->input->post('duplicateCaseProperlyTied'),
					"caseDescriptionFieldContain" => $this->input->post('caseDescriptionFieldContain'),
					"caseTiedCorrectContact" => $this->input->post('caseTiedCorrectContact'),
					"expartFirstRespondtoPortal" => $this->input->post('expartFirstRespondtoPortal'),
					"expertNeverAssign" => $this->input->post('expertNeverAssign'),
					"allInformationRelevent" => $this->input->post('allInformationRelevent'),
					"clearlyDocumentedCallDisconnect" => $this->input->post('clearlyDocumentedCallDisconnect'),
					"envelopeIDsInformation" => $this->input->post('envelopeIDsInformation'),
					"expertRefrainNegativeComment" => $this->input->post('expertRefrainNegativeComment'),
					"unresponsiveFollowup" => $this->input->post('unresponsiveFollowup'),
					"customerRepliesBusinessDay" => $this->input->post('customerRepliesBusinessDay'),
					"agreedUponFollowup" => $this->input->post('agreedUponFollowup'),
					"expertObtainOwenership" => $this->input->post('expertObtainOwenership'),
					"technicalInformationAccurate" => $this->input->post('technicalInformationAccurate'),
					"useTargetedProbingQuestion" => $this->input->post('useTargetedProbingQuestion'),
					"performLogicalTroubleshooting" => $this->input->post('performLogicalTroubleshooting'),
					"attemptOfferAllTroubleshooting" => $this->input->post('attemptOfferAllTroubleshooting'),
					"appropiateAcknowledgeResponce" => $this->input->post('appropiateAcknowledgeResponce'),
					"maintainFriendlyInteraction" => $this->input->post('maintainFriendlyInteraction'),
					"stayFocusAndConcise" => $this->input->post('stayFocusAndConcise'),
					"refrainFromUsingLanguage" => $this->input->post('refrainFromUsingLanguage'),
					"demonstrateActiveListening" => $this->input->post('demonstrateActiveListening'),
					"appropiateAdviseCaseStatus" => $this->input->post('appropiateAdviseCaseStatus'),
					"setHoldMuteExpectation" => $this->input->post('setHoldMuteExpectation'),
					"followTroughWithExpectation" => $this->input->post('followTroughWithExpectation'),
					"customerTestFilesSent" => $this->input->post('customerTestFilesSent'),
					"closeAllScreenSharing" => $this->input->post('closeAllScreenSharing'),
					"toworFewerSpelling" => $this->input->post('toworFewerSpelling'),
					"allSpecializedCompanyBranding" => $this->input->post('allSpecializedCompanyBranding'),
					"cmt1" => $this->input->post('cmt1'),
					"cmt2" => $this->input->post('cmt2'),
					"cmt3" => $this->input->post('cmt3'),
					"cmt4" => $this->input->post('cmt4'),
					"cmt5" => $this->input->post('cmt5'),
					"cmt6" => $this->input->post('cmt6'),
					"cmt7" => $this->input->post('cmt7'),
					"cmt8" => $this->input->post('cmt8'),
					"cmt9" => $this->input->post('cmt9'),
					"cmt10" => $this->input->post('cmt10'),
					"cmt11" => $this->input->post('cmt11'),
					"cmt12" => $this->input->post('cmt12'),
					"cmt13" => $this->input->post('cmt13'),
					"cmt14" => $this->input->post('cmt14'),
					"cmt15" => $this->input->post('cmt15'),
					"cmt16" => $this->input->post('cmt16'),
					"cmt17" => $this->input->post('cmt17'),
					"cmt18" => $this->input->post('cmt18'),
					"cmt19" => $this->input->post('cmt19'),
					"cmt20" => $this->input->post('cmt20'),
					"cmt21" => $this->input->post('cmt21'),
					"cmt22" => $this->input->post('cmt22'),
					"cmt23" => $this->input->post('cmt23'),
					"cmt24" => $this->input->post('cmt24'),
					"cmt25" => $this->input->post('cmt25'),
					"cmt26" => $this->input->post('cmt26'),
					"cmt27" => $this->input->post('cmt27'),
					"cmt28" => $this->input->post('cmt28'),
					"cmt29" => $this->input->post('cmt29'),
					"cmt30" => $this->input->post('cmt30'),
					"cmt31" => $this->input->post('cmt31'),
					"cmt32" => $this->input->post('cmt32'),
					"cmt33" => $this->input->post('cmt33'),
					"cmt34" => $this->input->post('cmt34'),
					"cmt35" => $this->input->post('cmt35'),
					"cmt36" => $this->input->post('cmt36'),
					"cmt37" => $this->input->post('cmt37'),
					"cmt38" => $this->input->post('cmt38'),
					"cmt39" => $this->input->post('cmt39'),
					"cmt40" => $this->input->post('cmt40'),
					"cmt41" => $this->input->post('cmt41'),
					"cmt42" => $this->input->post('cmt42'),
					"cmt43" => $this->input->post('cmt43'),
					"cmt44" => $this->input->post('cmt44'),
					"cmt45" => $this->input->post('cmt45'),
					"cmt46" => $this->input->post('cmt46'),
					"cmt47" => $this->input->post('cmt47'),
					"cmt48" => $this->input->post('cmt48'),
					"cmt49" => $this->input->post('cmt49'),
					"call_summary" => $this->input->post('call_summary'),
					"feedback" => $this->input->post('feedback')
				);
				$this->db->where('id', $dsid);
				$this->db->update('qa_docusign_phone_chat_feedback',$field_array);
				
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
				$this->db->where('id', $dsid);
				$this->db->update('qa_docusign_phone_chat_feedback',$field_array1);
			///////////	
				redirect('Qa_docusign');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}

////////////////////////////Docusign New///////////////////////////

	public function add_docusign_new($ds_new_id){
	
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_docusign/add_docusign_new.php";
			$data["content_js"] = "qa_kabbage_js.php";
			$data["ds_new_id"] = $ds_new_id;
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,30) and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
				from qa_docusign_feedback where id='$ds_new_id') xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
			$data["dc_new_data"] = $this->Common_model->get_query_row_array($qSql);
			
			$curDateTime=CurrMySqlDate();
			$a = array(); 
						
			$field_array['agent_id']=!empty($_POST['data']['agent_id'])?$_POST['data']['agent_id']:"";
			if($field_array['agent_id']){
				$field_array=$this->input->post('data');
				$field_array['call_date']=mmddyy2mysql($this->input->post('call_date'));
				
				if($ds_new_id==0){
					
					$a = $this->ds_upload_files($_FILES['attach_file'], $path='./qa_files/qa_docusign/docusign_new/');
					$field_array["attach_file"] = implode(',',$a);
					$rowid= data_inserter('qa_docusign_feedback',$field_array);
					///////
					$date_array = array(
						"audit_date" => CurrDate(),
						"entry_date" => $curDateTime,
						"audit_start_time" => $this->input->post('audit_start_time')
					);
					$this->db->where('id', $rowid);
					$this->db->update('qa_docusign_feedback',$date_array);
					///////
					if(get_login_type()=="client"){
						$entry_array = array("client_entryby" => $current_user);
					}else{
						$entry_array = array("entry_by" => $current_user);
					}
					$this->db->where('id', $rowid);
					$this->db->update('qa_docusign_feedback',$entry_array);
					
				}else{
					
					$this->db->where('id', $ds_new_id);
					$this->db->update('qa_docusign_feedback',$field_array);
					////////
					if(get_login_type()=="client"){
						$review_array = array(
							"client_rvw_by" => $current_user,
							"client_rvw_note" => $this->input->post('note'),
							"client_rvw_date" => $curDateTime
						);
					}else{
						$review_array = array(
							"mgnt_rvw_by" => $current_user,
							"mgnt_rvw_note" => $this->input->post('note'),
							"mgnt_rvw_date" => $curDateTime
						);
					}
					$this->db->where('id', $ds_new_id);
					$this->db->update('qa_docusign_feedback',$review_array);
				}
				
				redirect('Qa_docusign');
			}
			$data["array"] = $a;
			$this->load->view("dashboard",$data);
		}
	}

/////////////////////////////////////////////////////////////////////////////

////////////////////////////Docusign sALES///////////////////////////

	public function add_docusign_sales($ds_new_id){
	
		if(check_logged_in())
		{
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_docusign/add_docusign_sales.php";
			$data["content_js"] = "qa_kabbage_js.php";
			$data["ds_new_id"] = $ds_new_id;
			
			$qSql="SELECT id, concat(fname, ' ', lname) as name, assigned_to, fusion_id FROM `signin` where role_id in (select id from role where folder ='agent') and dept_id=6 and is_assign_client (id,30) and status=1  order by name";
			$data["agentName"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * FROM signin where id not in (select id from role where folder='agent')";
			$data['tlname'] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name
				from qa_docusign_sales_feedback where id='$ds_new_id') xx Left Join (Select id as sid, fname, lname, fusion_id, office_id, assigned_to, get_process_names(id) as process from signin) yy on (xx.agent_id=yy.sid)";
			$data["dc_new_data"] = $this->Common_model->get_query_row_array($qSql);
			
			$curDateTime=CurrMySqlDate();
			$a = array(); 
						
			$field_array['agent_id']=!empty($_POST['data']['agent_id'])?$_POST['data']['agent_id']:"";
			if($field_array['agent_id']){
				$field_array=$this->input->post('data');
				$field_array['call_date']=mmddyy2mysql($this->input->post('call_date'));
				
				if($ds_new_id==0){
					
					$a = $this->ds_upload_files($_FILES['attach_file'], $path='./qa_files/qa_docusign/docusign_sales/');
					$field_array["attach_file"] = implode(',',$a);
					$rowid= data_inserter('qa_docusign_sales_feedback',$field_array);
					///////
					$date_array = array(
						"audit_date" => CurrDate(),
						"entry_date" => $curDateTime,
						"audit_start_time" => $this->input->post('audit_start_time')
					);
					$this->db->where('id', $rowid);
					$this->db->update('qa_docusign_sales_feedback',$date_array);
					///////
					if(get_login_type()=="client"){
						$entry_array = array("client_entryby" => $current_user);
					}else{
						$entry_array = array("entry_by" => $current_user);
					}
					$this->db->where('id', $rowid);
					$this->db->update('qa_docusign_sales_feedback',$entry_array);
					
				}else{
					
					$this->db->where('id', $ds_new_id);
					$this->db->update('qa_docusign_sales_feedback',$field_array);
					////////
					if(get_login_type()=="client"){
						$review_array = array(
							"client_rvw_by" => $current_user,
							"client_rvw_note" => $this->input->post('note'),
							"client_rvw_date" => $curDateTime
						);
					}else{
						$review_array = array(
							"mgnt_rvw_by" => $current_user,
							"mgnt_rvw_note" => $this->input->post('note'),
							"mgnt_rvw_date" => $curDateTime
						);
					}
					$this->db->where('id', $ds_new_id);
					$this->db->update('qa_docusign_sales_feedback',$review_array);
				}
				
				redirect('Qa_docusign');
			}
			$data["array"] = $a;
			$this->load->view("dashboard",$data);
		}
	}

/////////////////////////////////////////////////////////////////////////////

/////////////////////////Agent part/////////////////////////////////	

	public function agent_docusign_feedback()
	{
		if(check_logged_in())
		{
			$user_site_id= get_user_site_id();
			$role_id= get_role_id();
			$current_user = get_user_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_docusign/agent_feedback.php";
			$data["content_js"] = "qa_kabbage_js.php";
			$data["agentUrl"] = "qa_docusign/agent_docusign_feedback";
			
			
			$qSql="Select count(id) as value from qa_docusign_email_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit')";
			$data["tot_feedback"] =  $this->Common_model->get_single_value($qSql);
			
			$qSql="Select count(id) as value from qa_docusign_email_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit') and agent_rvw_date is Null";
			$data["yet_rvw"] =  $this->Common_model->get_single_value($qSql);
		///////////////
			$qSql="Select count(id) as value from qa_docusign_phone_chat_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit')";
			$data["tot_phonechat_feedback"] =  $this->Common_model->get_single_value($qSql);
			
			$qSql="Select count(id) as value from qa_docusign_phone_chat_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit') and agent_rvw_date is Null";
			$data["yet_phonechat_rvw"] =  $this->Common_model->get_single_value($qSql);
		///////////////
			$qSql="Select count(id) as value from qa_docusign_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit')";
			$data["tot_ds_new_fd"] =  $this->Common_model->get_single_value($qSql);
			
			$qSql="Select count(id) as value from qa_docusign_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit') and agent_rvw_date is Null";
			$data["yet_ds_new_rvw"] =  $this->Common_model->get_single_value($qSql);

			$qSql="Select count(id) as value from qa_docusign_sales_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit')";
			$data["tot_ds_sales_fd"] =  $this->Common_model->get_single_value($qSql);
			
			$qSql="Select count(id) as value from qa_docusign_sales_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit') and agent_rvw_date is Null";
			$data["yet_ds_sales_rvw"] =  $this->Common_model->get_single_value($qSql);
				
			$from_date = '';
			$to_date = '';
			$cond="";
			
			
			if($this->input->get('btnView')=='View')
			{
				$from_date = mmddyy2mysql($this->input->get('from_date'));
				$to_date = mmddyy2mysql($this->input->get('to_date'));
				
				if($from_date !="" && $to_date!=="" )  $cond= " Where (audit_date >= '$from_date' and audit_date <= '$to_date' ) ";
				
				$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_docusign_email_feedback $cond and agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit')) xx Left Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid)";
				$data["agent_rvw_list"] = $this->Common_model->get_query_result_array($qSql);
			////////////////
				$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_docusign_phone_chat_feedback $cond and agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit')) xx Left Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid)";
				$data["agent_phonechat_rvw_list"] = $this->Common_model->get_query_result_array($qSql);
			////////////
				$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_docusign_feedback $cond and agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit')) xx Left Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid)";
				$data["agent_ds_new_list"] = $this->Common_model->get_query_result_array($qSql);

				$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_docusign_sales_feedback $cond and agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit')) xx Left Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid)";
				$data["agent_ds_sales_list"] = $this->Common_model->get_query_result_array($qSql);
					
			}else{
	
				$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_docusign_email_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit')) xx Left Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid) Where xx.agent_rvw_date is Null";
				$data["agent_rvw_list"] = $this->Common_model->get_query_result_array($qSql);
			//////////////////
				$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_docusign_phone_chat_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit')) xx Left Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid)";
				$data["agent_phonechat_rvw_list"] = $this->Common_model->get_query_result_array($qSql);
			///////////////
				$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_docusign_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit')) xx Left Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid)";
				$data["agent_ds_new_list"] = $this->Common_model->get_query_result_array($qSql);

				$qSql = "SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_docusign_sales_feedback where agent_id='$current_user' And audit_type in ('CQ Audit', 'BQ Audit')) xx Left Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid)";
				$data["agent_ds_sales_list"] = $this->Common_model->get_query_result_array($qSql);
	
			}
			
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			
			$this->load->view('dashboard',$data);
		}
	}
	
	
	public function agent_docusign_rvw($id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_docusign/agent_rvw.php";
			$data["content_js"] = "qa_kabbage_js.php";
			$data["agentUrl"] = "qa_docusign/agent_docusign_feedback";
			
			$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_docusign_email_feedback where id='$id') xx Left Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid)";
			$data["docu_feedback"] = $this->Common_model->get_query_row_array($qSql);
			
			$data["dsid"]=$id;
			
			if($this->input->post('dsid'))
			{
				$dsid=$this->input->post('dsid');
				$curDateTime=CurrMySqlDate();
				$log=get_logs();
					
				$field_array1=array(
					"agent_rvw_note" => $this->input->post('note'),
					"agent_rvw_date" => $curDateTime
				);
				$this->db->where('id', $dsid);
				$this->db->update('qa_docusign_email_feedback',$field_array1);
					
				redirect('Qa_docusign/agent_docusign_feedback');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}
	
	public function agent_phonechat_rvw($id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_docusign/agent_phonechat_rvw.php";
			$data["content_js"] = "qa_kabbage_js.php";
			$data["agentUrl"] = "qa_docusign/agent_docusign_feedback";
			
			$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_docusign_phone_chat_feedback where id='$id') xx Left Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid)";
			$data["docu_feedback"] = $this->Common_model->get_query_row_array($qSql);
			
			$data["dsid"]=$id;
			
			if($this->input->post('dsid'))
			{
				$dsid=$this->input->post('dsid');
				$curDateTime=CurrMySqlDate();
				$log=get_logs();
					
				$field_array1=array(
					"agent_rvw_note" => $this->input->post('note'),
					"agent_rvw_date" => $curDateTime
				);
				$this->db->where('id', $dsid);
				$this->db->update('qa_docusign_phone_chat_feedback',$field_array1);
					
				redirect('Qa_docusign/agent_docusign_feedback');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}

	public function agent_docusign_new_rvw($id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_docusign/agent_ds_new_rvw.php";
			$data["content_js"] = "qa_kabbage_js.php";
			$data["agentUrl"] = "qa_docusign/agent_docusign_feedback";
			
			$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_docusign_feedback where id='$id') xx Left Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid)";
			$data["docu_feedback"] = $this->Common_model->get_query_row_array($qSql);
			
			$data["dsid"]=$id;
			
			if($this->input->post('dsid'))
			{
				$dsid=$this->input->post('dsid');
				$curDateTime=CurrMySqlDate();
				$log=get_logs();
					
				$field_array1=array(
					"agent_rvw_note" => $this->input->post('note'),
					"agent_rvw_date" => $curDateTime
				);
				$this->db->where('id', $dsid);
				$this->db->update('qa_docusign_feedback',$field_array1);
					
				redirect('Qa_docusign/agent_docusign_feedback');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}
	
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//////////////////////////////////////////// Docusign Sales Feedback///////////////////////////////////////

public function agent_docusign_sales_rvw($id){
		if(check_logged_in()){
			$current_user=get_user_id();
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_docusign/agent_ds_sales_rvw.php";
			$data["content_js"] = "qa_kabbage_js.php";
			$data["agentUrl"] = "qa_docusign/agent_docusign_feedback";
			
			$qSql="SELECT * from
				(Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name,
				(select concat(fname, ' ', lname) as name from signin_client sc where sc.id=client_entryby) as client_name,
				(select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name,
				(select concat(fname, ' ', lname) as name from signin sx where sx.id=mgnt_rvw_by) as mgnt_rvw_name from qa_docusign_sales_feedback where id='$id') xx Left Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid)";
			$data["docu_feedback"] = $this->Common_model->get_query_row_array($qSql);
			
			$data["dsid"]=$id;
			
			if($this->input->post('dsid'))
			{
				$dsid=$this->input->post('dsid');
				$curDateTime=CurrMySqlDate();
				$log=get_logs();
					
				$field_array1=array(
					"agent_rvw_note" => $this->input->post('note'),
					"agent_rvw_date" => $curDateTime
				);
				$this->db->where('id', $dsid);
				$this->db->update('qa_docusign_sales_feedback',$field_array1);
					
				redirect('Qa_docusign/agent_docusign_feedback');
				
			}else{
				$this->load->view('dashboard',$data);
			}
		}
	}

	////////////////////////////////////////////////////////////////////////////////////////////////////
	///////////////////////////////////////////////////////////////////////////////////////////////////

///////////////////////////////////////////////////////////////////////////////////// 
/////////////////////////////// QA DocuSign REPORT ////////////////////////////////	
/////////////////////////////////////////////////////////////////////////////////////

	public function qa_docusign_report(){
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
			$data["content_template"] = "qa_docusign/qa_report.php";
			$data["content_js"] = "qa_kabbage_js.php";
			
			$data['location_list'] = $this->Common_model->get_office_location_list();
			
			$office_id = "";
			$date_from="";
			$date_to="";
			$p_id="";
			//$pid="";
			$action="";
			$dn_link="";
			$cond="";
			$cond1="";
			
			$p_id = $this->input->get('p_id');
			if($p_id=='email'){
				$pid='qa_docusign_email_feedback';
			}else if($p_id=='phone_chat'){
				$pid='qa_docusign_phone_chat_feedback';
			}else if($p_id=='dc_new'){
				$pid='qa_docusign_feedback';
			}else if($p_id=='dc_sales'){
				$pid='qa_docusign_sales_feedback';
			}
			
			$data["qa_docusign_list"] = array();
			
			if($this->input->get('show')=='Show')
			{
				$date_from = mmddyy2mysql($this->input->get('date_from'));
				$date_to = mmddyy2mysql($this->input->get('date_to'));
				$office_id = $this->input->get('office_id');
				
				if($date_from !="" && $date_to!=="" )  $cond= " Where (audit_date >= '$date_from' and audit_date <= '$date_to' ) ";
		
				if($office_id=="All") $cond .= "";
				else $cond .=" and office_id='$office_id'";
				
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
				(select concat(fname, ' ', lname) as name from signin_client scx where scx.id=client_rvw_by) as client_rvw_name from ".$pid.") xx Left Join
				(Select id as sid, fname, lname, fusion_id, assigned_to, office_id, get_process_names(id) as campaign from signin) yy on (xx.agent_id=yy.sid) $cond $cond1 order by audit_date";
				
				$fullAray = $this->Common_model->get_query_result_array($qSql);
				$data["qa_docusign_list"] = $fullAray;
				$this->create_qa_docusign_CSV($fullAray,$p_id);	
				$dn_link = base_url()."qa_docusign/download_qa_docusign_CSV/".$p_id;
				
			}
			
			$data['download_link']=$dn_link;
			$data["action"] = $action;	
			$data['date_from'] = $date_from;
			$data['date_to'] = $date_to;	
			$data['office_id']=$office_id;
			$data['p_id']=$p_id;
			
			$this->load->view('dashboard',$data);
		}
	}	
	 

	public function download_qa_docusign_CSV($p_id)
	{
		$currDate=date("Y-m-d");
		
		if($p_id=='email'){
			$pname='Email';
		}else if($p_id=='phone_chat'){
			$pname='Phone & Chat';
		}else if($p_id=='dc_new'){
			$pname='New';
		}else if($p_id=='dc_sales'){
			$pname='Sales';
		}
		
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$newfile="QA Docusign ".$pname." Audit List-'".$currDate."'.csv";
		
		header('Content-Disposition: attachment;  filename="'.$newfile.'"');
		readfile($filename);
	}
	
	
	public function create_qa_docusign_CSV($rr,$p_id)
	{
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$fopen = fopen($filename,"w+");
		
		if($p_id=='email'){
			$header = array("Auditor Name", "Audit Date", "Fusion ID", "Agent", "L1 Super", "Call Date", "Case Number", "Call Duration", "Topic", "Sub-Topic", "Opportunity Area", "Audit Type", "VOC", "Audit Start Date Time", "Audit End Date Time", "Interval(In Second)", "Overall Score", "Properly verifies the admin before making any account changes", "Does not close or cancel any corporate accounts and prior to closing Web accounts advises that documents will be inaccessible upon closure", "Submits all eligible refund requests in accordance with the Refund Policy", "Properly submits ACRs in all applicable scenarios", "Obtains verbal or written permission from an authenticated admin before enabling or disabling any account features", "Verifies the necessary account billing information OR ensures that an email sent by an authenticated Account", "Does not volunteer PII information to the customer If the customer is an admin PII information can only be provided to them", "Requests that a manager deletes all sensitive customer-provided PII", "Informs the customer that the call may be recorded on outbound or Click-to-Call customer engagements", "Does not engage in a reverse screen sharing", "Sends all email communications from within the Salesforce case", "Does not provide their personal work email address in any fashion", "Observes all procedures of unique customer contacts", "Directs the customer to their AM in scenarios listed on the Procedures page linked to in Policy section 4a", "Does not enable a Paid Feature or discuss the price of a feature", "Properly informs the Account Manager of a bug that affects one of their accounts", "Follows this flowchart when working a case for a customer with a TCSM", "Case Subjects are a high-level concise issue descriptor that is appropriately customer facing", "Case Subject and Description fields do not include abbreviations or shorthand", "Taxonomy status fields email alias and product field are accurate and any Case Issues relating to the case are properly linked", "Duplicate cases are properly tied to their parent case and case notes are input on the parent case rather than child", "The Case Description field contains only a concise summary of the problem the customer is having", "Case is tied to the correct Contact and Account records", "The Expert first responds to a Portal-originated case within a Public Case Comment", "The Expert never assigns the case outside of Support", "All information relevant to the interaction is captured", "If it is clearly documented when a call disconnects and the customer has to be called back", "All envelope IDs version numbers browser types and environment information that is required to troubleshoot a specific problem is documented", "The Expert refrains from negative or derogatory comments about customers", "Unresponsive follow up cadence procedure is observed", "Customer replies are responded to within one business day", "Agreed upon follow-ups with the customer occur when scheduled", "The Expert obtain ownership of the case and contacts the customer the same day", "All technical information provided is accurate", "Uses targeted probing questions and pays attention to key words and phrases to quickly determine the issue", "Asks the customer to perform logical and necessary troubleshooting steps throughout the interaction", "Attempts to offer all troubleshooting steps and utilizes their tools", "Immediately and appropriately acknowledges and responds to the customers emotional statements", "Maintains a friendly confident and professional voice tone throughout interaction", "Stays focused and concise with directions and allows customers to complete tasks prior to moving to next steps", "Refrains from using language that could be interpreted as offensive or controversial to a customer", "Demonstrates active listening by not ignoring customer information", "Appropriately advises of case status next steps and relevant time frames", "Follows through with expectations set for the customer", "Appropriately advises the customer that any test files sent to DocuSign Support", "Closes all screen sharing sessions prior to disconnecting the call or chat", "Two or fewer spelling or grammatical mistakes are observed throughout the customer-facing correspondences", "All specialized company branding such as DocuSign PowerForm etc", "Comment1", "Comment2", "Comment3", "Comment4", "Comment5", "Comment6", "Comment7", "Comment8", "Comment9", "Comment10", "Comment11", "Comment12", "Comment13", "Comment14", "Comment15", "Comment16", "Comment17", "Comment18", "Comment19", "Comment20", "Comment21", "Comment22", "Comment23", "Comment24", "Comment25", "Comment26", "Comment27", "Comment28", "Comment29", "Comment30", "Comment31", "Comment32", "Comment33", "Comment34", "Comment35", "Comment36", "Comment37", "Comment38", "Comment39", "Comment40", "Comment41", "Comment42", "Comment43", "Comment44", "Comment45", "Comment46", "Comment47", "Comment48", "Call Summary", "Feedback", "Agent Review Date", "Agent Comment", "Mgnt Review Date","Mgnt Review By", "Mgnt Comment", "Client Review Date", "Client Review Name", "Client Review Note");
		}else if($p_id=='phone_chat'){
			$header = array("Auditor Name", "Audit Date", "Fusion ID", "Agent", "L1 Super", "Call Date", "Case Number", "Call Duration", "Topic", "Sub-Topic", "Opportunity Area", "Audit Type", "VOC", "Audit Start Date Time", "Audit End Date Time", "Interval(In Second)", "Overall Score", "Properly verifies the admin before making any account changes", "Does not close or cancel any corporate accounts and prior to closing Web accounts advises that documents will be inaccessible upon closure", "Submits all eligible refund requests in accordance with the Refund Policy", "Properly submits ACRs in all applicable scenarios", "Obtains verbal or written permission from an authenticated admin before enabling or disabling any account features", "Verifies the necessary account billing information OR ensures that an email sent by an authenticated Account", "Does not volunteer PII information to the customer If the customer is an admin PII information can only be provided to them", "Requests that a manager deletes all sensitive customer-provided PII", "Informs the customer that the call may be recorded on outbound or Click-to-Call customer engagements", "Does not engage in a reverse screen sharing", "Sends all email communications from within the Salesforce case", "Does not provide their personal work email address in any fashion", "Observes all procedures of unique customer contacts", "Directs the customer to their AM in scenarios listed on the Procedures page linked to in Policy section 4a", "Does not enable a Paid Feature or discuss the price of a feature", "Properly informs the Account Manager of a bug that affects one of their accounts", "Follows this flowchart when working a case for a customer with a TCSM", "Case Subjects are a high-level concise issue descriptor that is appropriately customer facing", "Case Subject and Description fields do not include abbreviations or shorthand", "Taxonomy status fields email alias and product field are accurate and any Case Issues relating to the case are properly linked", "Duplicate cases are properly tied to their parent case and case notes are input on the parent case rather than child", "The Case Description field contains only a concise summary of the problem the customer is having", "Case is tied to the correct Contact and Account records", "The Expert first responds to a Portal-originated case within a Public Case Comment", "The Expert never assigns the case outside of Support", "All information relevant to the interaction is captured", "If it is clearly documented when a call disconnects and the customer has to be called back", "All envelope IDs version numbers browser types and environment information that is required to troubleshoot a specific problem is documented", "The Expert refrains from negative or derogatory comments about customers", "Unresponsive follow up cadence procedure is observed", "Customer replies are responded to within one business day", "Agreed upon follow-ups with the customer occur when scheduled", "The Expert obtain ownership of the case and contacts the customer the same day", "All technical information provided is accurate", "Uses targeted probing questions and pays attention to key words and phrases to quickly determine the issue", "Asks the customer to perform logical and necessary troubleshooting steps throughout the interaction", "Attempts to offer all troubleshooting steps and utilizes their tools", "Immediately and appropriately acknowledges and responds to the customers emotional statements", "Maintains a friendly confident and professional voice tone throughout interaction", "Stays focused and concise with directions and allows customers to complete tasks prior to moving to next steps", "Refrains from using language that could be interpreted as offensive or controversial to a customer", "Demonstrates active listening by not ignoring customer information", "Appropriately advises of case status next steps and relevant time frames", "Clearly and appropriately sets hold and mute expectations", "Follows through with expectations set for the customer", "Appropriately advises the customer that any test files sent to DocuSign Support", "Closes all screen sharing sessions prior to disconnecting the call or chat", "Two or fewer spelling or grammatical mistakes are observed throughout the customer-facing correspondences", "All specialized company branding such as DocuSign PowerForm etc", "Comment1", "Comment2", "Comment3", "Comment4", "Comment5", "Comment6", "Comment7", "Comment8", "Comment9", "Comment10", "Comment11", "Comment12", "Comment13", "Comment14", "Comment15", "Comment16", "Comment17", "Comment18", "Comment19", "Comment20", "Comment21", "Comment22", "Comment23", "Comment24", "Comment25", "Comment26", "Comment27", "Comment28", "Comment29", "Comment30", "Comment31", "Comment32", "Comment33", "Comment34", "Comment35", "Comment36", "Comment37", "Comment38", "Comment39", "Comment40", "Comment41", "Comment42", "Comment43", "Comment44", "Comment45", "Comment46", "Comment47", "Comment48", "Comment49", "Call Summary", "Feedback", "Agent Review Date", "Agent Comment", "Mgnt Review Date","Mgnt Review By", "Mgnt Comment", "Client Review Date", "Client Review Name", "Client Review Note"); 
		}else if($p_id=='dc_new'){
			$header = array("Auditor Name", "Audit Date", "Fusion ID", "Agent", "L1 Super", "Call Date", "Case Number", "Call Duration", "Time Stamp", "Case Topic", "Case Sub-Topic", "ACPT", "Industry", "Industry Other", "Audit Type", "VOC", "Audit Start Date Time", "Audit End Date Time", "Interval(In Second)", "Overall Score", "1) Did the agent execute properly any of these processes and properly verifies the admin", "Qustion1 Checkbox1", "Qustion2 Checkbox2", "2) Did the agent advise the customer that documents will be inaccessible upon closure?", "3) Did the agent properly submit ACRs in all applicable scenarios?", "4) Did the agent execute any of these processes about proper handling of PII information?", "Qustion4 Checkbox1", "Qustion4 Checkbox2", "5) Did the agent inform the customer that the call may be recorded on outbound", "6) Did the agent send all email communications only from within the Salesforce case?", "7) Did the agent not provide their personal work email address in any fashion?", "8) Did the agent appropriately advise the customer that any test files sent to DocuSign", "9) Did the agent execute properly any of the Escalation to Service Management", "Qustion9 Checkbox1", "Qustion9 Checkbox2", "Qustion9 Checkbox3", "10) Did the agent properly execute any of the process for CASE MANAGEMENT & POLICIES: Were all case fields filled out properly?", "Qustion10 Checkbox1", "Qustion10 Checkbox2", "Qustion10 Checkbox3", "Qustion10 Checkbox4", "Qustion10 Checkbox5", "Qustion10 Checkbox6", "Qustion10 Checkbox7", "Qustion10 Checkbox8", "11) Did the agent properly execute any of the process for CASE MANAGEMENT & POLICIES: Were Case Comments Complete and Accurate?", "Qustion11 Checkbox1", "Qustion11 Checkbox2", "Qustion11 Checkbox3", "Qustion11 Checkbox4", "12) Did the agent execute properly any of the cost-affecting process?", "Qustion12 Checkbox1", "Qustion12 Checkbox2", "Qustion12 Checkbox3", "Qustion12 Checkbox4", "Qustion12 Checkbox5", "13) Did the agent execute any of troubleshooting standard procedure and demonstrate logical", "Qustion13 Checkbox1", "Qustion13 Checkbox2", "Qustion13 Checkbox3", "Qustion13 Checkbox4", "14) Did the agent properly execute any of the process for CASE MANAGEMENT & POLICIES: Were all follow up policies observed when appropriate?", "Qustion14 Checkbox1", "Qustion14 Checkbox2", "Qustion14 Checkbox3", "15) Did the agent properly execute any of the process for SOFT SKILLS: Agent display courtesy positive tone and active listening?", "Qustion15 Checkbox1", "Qustion15 Checkbox2", "Qustion15 Checkbox3", "Qustion15 Checkbox4", "Qustion15 Checkbox5", "16) Did the agent properly execute any of the process for SOFT SKILLS and meet the expectations they set during the interactions?", "Qustion16 Checkbox1", "Qustion16 Checkbox2", "Qustion16 Checkbox3", "Qustion16 Checkbox4", "17) Did the agent properly execute any of the process for SOFT SKILLS and use proper spelling and grammar for all written or verbal customer-facing communication?", "Qustion17 Checkbox1", "Qustion17 Checkbox2", "Qustion17 Checkbox3", "Comment1", "Comment2", "Comment3", "Comment4", "Comment5", "Comment6", "Comment7", "Comment8", "Comment9", "Comment10", "Comment11", "Comment12", "Comment13", "Comment14", "Comment15", "Comment16", "Comment17", "Call Summary", "Feedback", "Agent Review Date", "Agent Comment", "Mgnt Review Date","Mgnt Review By", "Mgnt Comment", "Client Review Date", "Client Review Name", "Client Review Note"); 
		}else if ($p_id=="dc_sales") {

			$header = array("Auditor Name", "Audit Date", "Fusion ID", "Agent", "L1 Super", "Call Date", "Case Number", "Call Duration", "Time Stamp", "Case Topic", "Case Sub-Topic", "ACPT", "Industry", "Industry Other", "Audit Type", "VOC", "Audit Start Date Time", "Audit End Date Time", "Interval(In Second)", "Overall Score", "Did the agent follow call and chat cadence?","Did the agent provide specific accurate and complete technical information for the plans?","Did the agent followed proper business procedures on upselling?","Did agent express empathy and maintain a friendly professional voice tone?","Did the agent used professional chat salutation?","Did the agent stay focus and concise with the directions and allows customers to complete tasks prior to moving to next steps?","Did the agent refrain from using language that could be interpreted as offensive or controversial to a customer?","Did the agent demonstrate active listening by not ignoring customer information or interrupting the customer without a courteous attempt to yield the conversation?","Did the agent follow through with expectations set for the customer","Did the agent observed proper grammar usage?","Did the agent mention the brand 'DocuSign' upon opening and end spiel?","Comments 1","Comments 2","Comments 3","Comments 4","Comments 5","Comments 6","Comments 7","Comments 8","Comments 9","Comments 10","Comments 11","Call Summary", "Feedback", "Agent Review Date", "Agent Comment", "Mgnt Review Date","Mgnt Review By", "Mgnt Comment", "Client Review Date", "Client Review Name", "Client Review Note"); 
		
		}
		
		$row = "";
		foreach($header as $data) $row .= ''.$data.',';
		fwrite($fopen,rtrim($row,",")."\r\n");
		$searches = array("\r", "\n", "\r\n");
		
		if($p_id=='email'){
		
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
				$row .= '"'.$user['fusion_id'].'",'; 
				$row .= '"'.$user['fname']." ".$user['lname'].'",';
				$row .= '"'.$user['tl_name'].'",';
				$row .= '"'.$user['call_date'].'",';
				$row .= '"'.$user['case_no'].'",';
				$row .= '"'.$user['call_duration'].'",';
				$row .= '"'.$user['topic'].'",';
				$row .= '"'.$user['subtopic'].'",';
				$row .= '"'.$user['oppor_area'].'",';
				$row .= '"'.$user['audit_type'].'",';
				$row .= '"'.$user['voc'].'",';
				$row .= '"'.$user['audit_start_time'].'",';
				$row .= '"'.$user['entry_date'].'",';
				$row .= '"'.$interval1.'",';
				$row .= '"'.$user['overall_score'].'%'.'",';
				$row .= '"'.$user['adminPropertyVerify'].'",';
				$row .= '"'.$user['donotCloseCorporateAccount'].'",';
				$row .= '"'.$user['submitAllEligibleRefund'].'",';
				$row .= '"'.$user['properlySubmitACR'].'",';
				$row .= '"'.$user['obtainRetainPermission'].'",';
				$row .= '"'.$user['verifyAccountBillingInfo'].'",';
				$row .= '"'.$user['volunteerPIIInformation'].'",';
				$row .= '"'.$user['managerDeleteCustomerPII'].'",';
				$row .= '"'.$user['customerCallMaybeRecorded'].'",';
				$row .= '"'.$user['engageReverseScreening'].'",';
				$row .= '"'.$user['sendAllEmailComunication'].'",';
				$row .= '"'.$user['doesnotProvidePersonalEmail'].'",';
				$row .= '"'.$user['observesCustomerContact'].'",';
				$row .= '"'.$user['directCustomerAMScenario'].'",';
				$row .= '"'.$user['doesnotEnablePaidFeature'].'",';
				$row .= '"'.$user['properlyInformAccountManager'].'",';
				$row .= '"'.$user['followstheFlowchart'].'",';
				$row .= '"'.$user['caseSubjectAreHighLevel'].'",';
				$row .= '"'.$user['caseSubjectFieldnotInclude'].'",';
				$row .= '"'.$user['taxonomyStatusFieldAccurate'].'",';
				$row .= '"'.$user['duplicateCaseProperlyTied'].'",';
				$row .= '"'.$user['caseDescriptionFieldContain'].'",';
				$row .= '"'.$user['caseTiedCorrectContact'].'",';
				$row .= '"'.$user['expartFirstRespondtoPortal'].'",';
				$row .= '"'.$user['expertNeverAssign'].'",';
				$row .= '"'.$user['allInformationRelevent'].'",';
				$row .= '"'.$user['clearlyDocumentedCallDisconnect'].'",';
				$row .= '"'.$user['envelopeIDsInformation'].'",';
				$row .= '"'.$user['expertRefrainNegativeComment'].'",';
				$row .= '"'.$user['unresponsiveFollowup'].'",';
				$row .= '"'.$user['customerRepliesBusinessDay'].'",';
				$row .= '"'.$user['agreedUponFollowup'].'",';
				$row .= '"'.$user['expertObtainOwenership'].'",';
				$row .= '"'.$user['technicalInformationAccurate'].'",';
				$row .= '"'.$user['useTargetedProbingQuestion'].'",';
				$row .= '"'.$user['performLogicalTroubleshooting'].'",';
				$row .= '"'.$user['attemptOfferAllTroubleshooting'].'",';
				$row .= '"'.$user['appropiateAcknowledgeResponce'].'",';
				$row .= '"'.$user['maintainFriendlyInteraction'].'",';
				$row .= '"'.$user['stayFocusAndConcise'].'",';
				$row .= '"'.$user['refrainFromUsingLanguage'].'",';
				$row .= '"'.$user['demonstrateActiveListening'].'",';
				$row .= '"'.$user['appropiateAdviseCaseStatus'].'",';
				$row .= '"'.$user['followTroughWithExpectation'].'",';
				$row .= '"'.$user['customerTestFilesSent'].'",';
				$row .= '"'.$user['closeAllScreenSharing'].'",';
				$row .= '"'.$user['toworFewerSpelling'].'",';
				$row .= '"'.$user['allSpecializedCompanyBranding'].'",';
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
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt39'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt40'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt41'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt42'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt43'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt44'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt45'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt46'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt47'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt48'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['call_summary'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['feedback'])).'",';
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
		
		}else if($p_id=='phone_chat'){
			
			foreach($rr as $user)
			{	
				if($user['entry_by']!=''){
					$auditorName = $user['auditor_name'];
				}else{
					$auditorName = $user['client_name'];
				}
				
				if($user['audit_start_time']=="" || $user['audit_start_time']=='0000-00-00 00:00:00'){
					$interval2 = '---';
				}else{
					$interval2 = strtotime($user['entry_date']) - strtotime($user['audit_start_time']);
				}
			
				$row = '"'.$auditorName.'",'; 
				$row .= '"'.$user['audit_date'].'",'; 
				$row .= '"'.$user['fusion_id'].'",'; 
				$row .= '"'.$user['fname']." ".$user['lname'].'",';
				$row .= '"'.$user['tl_name'].'",';
				$row .= '"'.$user['call_date'].'",';
				$row .= '"'.$user['case_no'].'",';
				$row .= '"'.$user['call_duration'].'",';
				$row .= '"'.$user['topic'].'",';
				$row .= '"'.$user['subtopic'].'",';
				$row .= '"'.$user['oppor_area'].'",';
				$row .= '"'.$user['audit_type'].'",';
				$row .= '"'.$user['voc'].'",';
				$row .= '"'.$user['audit_start_time'].'",';
				$row .= '"'.$user['entry_date'].'",';
				$row .= '"'.$interval2.'",';
				$row .= '"'.$user['overall_score'].'%'.'",';
				$row .= '"'.$user['adminPropertyVerify'].'",';
				$row .= '"'.$user['donotCloseCorporateAccount'].'",';
				$row .= '"'.$user['submitAllEligibleRefund'].'",';
				$row .= '"'.$user['properlySubmitACR'].'",';
				$row .= '"'.$user['obtainRetainPermission'].'",';
				$row .= '"'.$user['verifyAccountBillingInfo'].'",';
				$row .= '"'.$user['volunteerPIIInformation'].'",';
				$row .= '"'.$user['managerDeleteCustomerPII'].'",';
				$row .= '"'.$user['customerCallMaybeRecorded'].'",';
				$row .= '"'.$user['engageReverseScreening'].'",';
				$row .= '"'.$user['sendAllEmailComunication'].'",';
				$row .= '"'.$user['doesnotProvidePersonalEmail'].'",';
				$row .= '"'.$user['observesCustomerContact'].'",';
				$row .= '"'.$user['directCustomerAMScenario'].'",';
				$row .= '"'.$user['doesnotEnablePaidFeature'].'",';
				$row .= '"'.$user['properlyInformAccountManager'].'",';
				$row .= '"'.$user['followstheFlowchart'].'",';
				$row .= '"'.$user['caseSubjectAreHighLevel'].'",';
				$row .= '"'.$user['caseSubjectFieldnotInclude'].'",';
				$row .= '"'.$user['taxonomyStatusFieldAccurate'].'",';
				$row .= '"'.$user['duplicateCaseProperlyTied'].'",';
				$row .= '"'.$user['caseDescriptionFieldContain'].'",';
				$row .= '"'.$user['caseTiedCorrectContact'].'",';
				$row .= '"'.$user['expartFirstRespondtoPortal'].'",';
				$row .= '"'.$user['expertNeverAssign'].'",';
				$row .= '"'.$user['allInformationRelevent'].'",';
				$row .= '"'.$user['clearlyDocumentedCallDisconnect'].'",';
				$row .= '"'.$user['envelopeIDsInformation'].'",';
				$row .= '"'.$user['expertRefrainNegativeComment'].'",';
				$row .= '"'.$user['unresponsiveFollowup'].'",';
				$row .= '"'.$user['customerRepliesBusinessDay'].'",';
				$row .= '"'.$user['agreedUponFollowup'].'",';
				$row .= '"'.$user['expertObtainOwenership'].'",';
				$row .= '"'.$user['technicalInformationAccurate'].'",';
				$row .= '"'.$user['useTargetedProbingQuestion'].'",';
				$row .= '"'.$user['performLogicalTroubleshooting'].'",';
				$row .= '"'.$user['attemptOfferAllTroubleshooting'].'",';
				$row .= '"'.$user['appropiateAcknowledgeResponce'].'",';
				$row .= '"'.$user['maintainFriendlyInteraction'].'",';
				$row .= '"'.$user['stayFocusAndConcise'].'",';
				$row .= '"'.$user['refrainFromUsingLanguage'].'",';
				$row .= '"'.$user['demonstrateActiveListening'].'",';
				$row .= '"'.$user['appropiateAdviseCaseStatus'].'",';
				$row .= '"'.$user['setHoldMuteExpectation'].'",';
				$row .= '"'.$user['followTroughWithExpectation'].'",';
				$row .= '"'.$user['customerTestFilesSent'].'",';
				$row .= '"'.$user['closeAllScreenSharing'].'",';
				$row .= '"'.$user['toworFewerSpelling'].'",';
				$row .= '"'.$user['allSpecializedCompanyBranding'].'",';
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
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt39'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt40'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt41'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt42'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt43'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt44'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt45'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt46'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt47'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt48'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['cmt49'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['call_summary'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['feedback'])).'",';
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
			
		}else if($p_id=='dc_new'){
			
			foreach($rr as $user)
			{	
				if($user['entry_by']!=''){
					$auditorName = $user['auditor_name'];
				}else{
					$auditorName = $user['client_name'];
				}
				
				if($user['audit_start_time']=="" || $user['audit_start_time']=='0000-00-00 00:00:00'){
					$interval2 = '---';
				}else{
					$interval2 = strtotime($user['entry_date']) - strtotime($user['audit_start_time']);
				}
				
				$row = '"'.$auditorName.'",'; 
				$row .= '"'.$user['audit_date'].'",'; 
				$row .= '"'.$user['fusion_id'].'",'; 
				$row .= '"'.$user['fname']." ".$user['lname'].'",';
				$row .= '"'.$user['tl_name'].'",';
				$row .= '"'.$user['call_date'].'",';
				$row .= '"'.$user['case_no'].'",';
				$row .= '"'.$user['call_duration'].'",';
				$row .= '"'.$user['time_stamp'].'",';
				$row .= '"'.$user['case_topic'].'",';
				$row .= '"'.$user['case_sub_topic'].'",';
				$row .= '"'.$user['acpt'].'",';
				$row .= '"'.$user['industry'].'",';
				$row .= '"'.$user['industry_other'].'",';
				$row .= '"'.$user['audit_type'].'",';
				$row .= '"'.$user['voc'].'",';
				$row .= '"'.$user['audit_start_time'].'",';
				$row .= '"'.$user['entry_date'].'",';
				$row .= '"'.$interval2.'",';
				$row .= '"'.$user['overall_score'].'%'.'",';
				$row .= '"'.$user['making_account_change'].'",';
				$row .= '"'.$user['compliance1_check1'].'",';
				$row .= '"'.$user['compliance1_check2'].'",';
				$row .= '"'.$user['for_account_closure'].'",';
				$row .= '"'.$user['properly_submit_ACRs'].'",';
				$row .= '"'.$user['proper_handling_PII'].'",';
				$row .= '"'.$user['compliance4_check1'].'",';
				$row .= '"'.$user['compliance4_check2'].'",';
				$row .= '"'.$user['inform_customer_call_record'].'",';
				$row .= '"'.$user['send_email_communication'].'",';
				$row .= '"'.$user['not_provide_personal_eork'].'",';
				$row .= '"'.$user['testfile_sent_to_docusign'].'",';
				$row .= '"'.$user['escalation_service_management'].'",';
				$row .= '"'.$user['business9_check1'].'",';
				$row .= '"'.$user['business9_check2'].'",';
				$row .= '"'.$user['business9_check3'].'",';
				$row .= '"'.$user['process_of_case_management'].'",';
				$row .= '"'.$user['business10_check1'].'",';
				$row .= '"'.$user['business10_check2'].'",';
				$row .= '"'.$user['business10_check3'].'",';
				$row .= '"'.$user['business10_check4'].'",';
				$row .= '"'.$user['business10_check5'].'",';
				$row .= '"'.$user['business10_check6'].'",';
				$row .= '"'.$user['business10_check7'].'",';
				$row .= '"'.$user['business10_check8'].'",';
				$row .= '"'.$user['process_of_case_policies'].'",';
				$row .= '"'.$user['business11_check1'].'",';
				$row .= '"'.$user['business11_check2'].'",';
				$row .= '"'.$user['business11_check3'].'",';
				$row .= '"'.$user['business11_check4'].'",';
				$row .= '"'.$user['cost_affecting_process'].'",';
				$row .= '"'.$user['business12_check1'].'",';
				$row .= '"'.$user['business12_check2'].'",';
				$row .= '"'.$user['business12_check3'].'",';
				$row .= '"'.$user['business12_check4'].'",';
				$row .= '"'.$user['business12_check5'].'",';
				$row .= '"'.$user['troushooting_standard_procedure'].'",';
				$row .= '"'.$user['customer13_check1'].'",';
				$row .= '"'.$user['customer13_check2'].'",';
				$row .= '"'.$user['customer13_check3'].'",';
				$row .= '"'.$user['customer13_check4'].'",';
				$row .= '"'.$user['observe_policies_appropiately'].'",';
				$row .= '"'.$user['customer14_check1'].'",';
				$row .= '"'.$user['customer14_check2'].'",';
				$row .= '"'.$user['customer14_check3'].'",';
				$row .= '"'.$user['process_of_soft_skill'].'",';
				$row .= '"'.$user['customer15_check1'].'",';
				$row .= '"'.$user['customer15_check2'].'",';
				$row .= '"'.$user['customer15_check3'].'",';
				$row .= '"'.$user['customer15_check4'].'",';
				$row .= '"'.$user['customer15_check5'].'",';
				$row .= '"'.$user['expectation_during_interaction'].'",';
				$row .= '"'.$user['customer16_check1'].'",';
				$row .= '"'.$user['customer16_check2'].'",';
				$row .= '"'.$user['customer16_check3'].'",';
				$row .= '"'.$user['customer16_check4'].'",';
				$row .= '"'.$user['use_proper_spelling'].'",';
				$row .= '"'.$user['customer17_check1'].'",';
				$row .= '"'.$user['customer17_check2'].'",';
				$row .= '"'.$user['customer17_check3'].'",';
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
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['call_summary'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['feedback'])).'",';
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
			
		}else if($p_id=='dc_sales'){
			
			foreach($rr as $user)
			{	
				if($user['entry_by']!=''){
					$auditorName = $user['auditor_name'];
				}else{
					$auditorName = $user['client_name'];
				}
				
				if($user['audit_start_time']=="" || $user['audit_start_time']=='0000-00-00 00:00:00'){
					$interval2 = '---';
				}else{
					$interval2 = strtotime($user['entry_date']) - strtotime($user['audit_start_time']);
				}
				
				$row = '"'.$auditorName.'",'; 
				$row .= '"'.$user['audit_date'].'",'; 
				$row .= '"'.$user['fusion_id'].'",'; 
				$row .= '"'.$user['fname']." ".$user['lname'].'",';
				$row .= '"'.$user['tl_name'].'",';
				$row .= '"'.$user['call_date'].'",';
				$row .= '"'.$user['case_no'].'",';
				$row .= '"'.$user['call_duration'].'",';
				$row .= '"'.$user['time_stamp'].'",';
				$row .= '"'.$user['case_topic'].'",';
				$row .= '"'.$user['case_sub_topic'].'",';
				$row .= '"'.$user['acpt'].'",';
				$row .= '"'.$user['industry'].'",';
				$row .= '"'.$user['industry_other'].'",';
				$row .= '"'.$user['audit_type'].'",';
				$row .= '"'.$user['voc'].'",';
				$row .= '"'.$user['audit_start_time'].'",';
				$row .= '"'.$user['entry_date'].'",';
				$row .= '"'.$interval2.'",';
				$row .= '"'.$user['overall_score'].'%'.'",';
				$row .= '"'.$user['identifynameatbeginning'].'",';
				$row .= '"'.$user['assurancetsatementverbatim'].'",';
				$row .= '"'.$user['msbFinancial'].'",';
				$row .= '"'.$user['speakingtorightparty'].'",';
				$row .= '"'.$user['SbSResolution'].'",';
				$row .= '"'.$user['demographicsinformation'].'",';
				$row .= '"'.$user['minimirandadisclosure'].'",';
				$row .= '"'.$user['statetheclientname'].'",';
				$row .= '"'.$user['askforbalancedue'].'",';
				$row .= '"'.$user['completeinformationtaken'].'",';
				$row .= '"'.$user['askforpaymentonphone'].'",';
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
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['call_summary'])).'",';
				$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['feedback'])).'",';
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