<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Download_document extends CI_Controller {

    private $aside = "reports/aside.php";
	private $objPHPExcel;
    /////////////////////////////////////////////////////////////////////////////////////////////
    // INDEX PAGE
    /////////////////////////////////////////////////////////////////////////////////////////////
    
	 function __construct() {
		parent::__construct();
		
		$this->load->library('excel');
		$this->load->model('reports_model');
		$this->load->model('Common_model');
		$this->load->model('user_model');
		$this->load->model('Dfr_model');
		$this->reports_model->set_report_database("report");
		
		$this->objPHPExcel = new PHPExcel();
		
	 }
	 
	public function index(){
		if(check_logged_in()){
			$user_office_id=get_user_office_id();
			$current_user = get_user_id();
			$is_global_access=get_global_access();
			$role_dir=get_role_dir();
			$data["show_download"] = false;
			$data["download_link"] = "";
			$data["show_table"] = false;
			$data["show_table"] = false;
			$data["aside_template"] = "reports_hr/aside.php";
			$data["content_template"] = "reports/new_document_upload_report.php";
			
			$data['location_list'] = $this->Common_model->get_office_location_list();
			$data['dept_list'] = $this->Common_model->get_department_list();
			
			$cValue = trim($this->input->post('client_id'));
			if($cValue=="") $cValue = trim($this->input->get('client_id'));
			
			$pValue = trim($this->input->post('process_id'));
			if($pValue=="") $pValue = trim($this->input->get('process_id'));
			
			$data['cValue']=$cValue;
			$data['pValue']=$pValue;
			
			
			$data['client_list'] = $this->Common_model->get_client_list();
			
			if($cValue=="" || $cValue=="ALL") $data['process_list'] = array();
			else $data['process_list'] = $this->Common_model->get_process_list($cValue);
			
			$office_id = "";
			$dept_id = "";
			$date_from="";
			$date_to="";
			$action="";
			$dn_link="";
			$cond="";
			
			
			$data["docu_upl_list"] = array();
			
			if($this->input->get('show')=='Show')
			{
				$office_id = $this->input->get('office_id');
				$dept_id = $this->input->get('dept_id');
				//$fusion_id = $this->input->get('fusion_id');
				
				if($office_id=='All') $cond .= "";
				else $cond .= " and office_id='$office_id'";
				
				if($dept_id=='All') $cond .= "";
				else $cond .= " and dept_id='$dept_id'";
				
				if($cValue=='All' || $cValue=='') $cond .= "";
				else $cond .= " and client='$cValue'";
				
				if($pValue=='All' || $pValue=='') $cond .= "";
				else $cond .= " and process='$pValue'";
				
				
				$qSql="SELECT * from 
				(select id, fusion_id, office_id, dept_id, (select description from department d where d.id=dept_id) as dept_name, concat(fname, ' ', lname) as name, status, get_client_ids(id) as client, get_process_ids(id) as process, get_client_names(id) as client_name, get_process_names(id) as process_name, (select GROUP_CONCAT(iod.info_type) as other_info FROM info_others_doc iod where iod.user_id=signin.id) as other_docu_info from signin) masdt Left Join 
				(select user_id as ie_uid, max(job_doc) as job_doc from info_experience group by ie_uid) aa On (masdt.id=aa.ie_uid) Left Join
				(select user_id as ib_uid, max(bank_doc) as bank_doc from info_bank group by ib_uid) bb On (masdt.id=bb.ib_uid) Left join
				(select user_id as ip_uid, max(passport_doc) as passport_doc from info_passport group by ip_uid) cc On (masdt.id=cc.ip_uid) Left join
				(select user_id as ied_uid, max(education_doc) as education_doc from info_education group by ied_uid) dd On (masdt.id=dd.ied_uid) Left join
				(select user_id as uid, marital_status from info_personal group by uid) ee On (masdt.id=ee.uid) Left Join
				(select user_id as idu_uid,pan_doc,aadhar_doc,nis_doc,birth_certi_doc,marrige_certi_doc,photograph,resume_doc,nit_doc,isss_doc,afp_info_doc,background_local_doc, sss_no_doc,tin_no_doc,philhealth_no_doc,dependent_birth_certi_doc,bir_2316_doc,nbi_clearance_doc,offer_letter,employment_contract,profile_sketch,updated_cv from info_document_upload) ff On (masdt.id=ff.idu_uid)
				where status=1 $cond GROUP BY fusion_id";
				
				//$fullAray = $this->Common_model->get_query_result_array($qSql);
				//$data["docu_upl_list"] = $fullAray;
				//$this->create_docu_upl_CSV($fullAray, $office_id);
								
				$extraOffice = "";
				if($office_id!='All'){ $extraOffice = " AND s.office_id = '$office_id' "; }
				
				$extraDept = "";
				if($dept_id!='All'){ $extraDept = " AND s.dept_id = '$dept_id' "; }
				
				$extraClient = "";
				if($cValue!='All' && $cValue!='' && !empty($cValue)){ $extraClient .= " AND $cValue IN (get_client_ids(s.id)) "; }
				
				if($pValue!='All' && $pValue!='' && !empty($pValue)){ $extraClient .= " AND $pValue IN (get_process_ids(s.id)) "; }
								
				$extraFusion = "";
				$fusionSelection = $this->input->get('report_fusion_id');
				if(!empty($fusionSelection))
				{
					$extraOffice = ""; $extraDept = ""; $extraClient = "";
					$fusion_ids_ar = explode(',', $fusionSelection);
					$fusion_ids = implode("','", $fusion_ids_ar);
					$extraFusion = " AND s.fusion_id IN ('".$fusion_ids."') ";
				}
				
				$reports_sql = "SELECT s.fusion_id, CONCAT(s.fname, ' ', s.lname) as fullname, s.office_id as office, b.* from info_bank as b
								  LEFT JOIN signin as s ON b.user_id = s.id
								  WHERE 1 $extraOffice $extraDept $extraClient $extraFusion";
				$report_list = $this->Common_model->get_query_result_array($reports_sql);
				
				$info_sql = "SELECT s.fusion_id, CONCAT(s.fname, ' ', s.lname) as fullname, s.office_id as office, b.* from info_document_upload as b
								LEFT JOIN signin as s ON b.user_id = s.id
								  WHERE 1 $extraOffice $extraDept $extraClient $extraFusion";
				$info_list = $this->Common_model->get_query_result_array($info_sql);

				$edu_sql = "SELECT s.fusion_id, CONCAT(s.fname, ' ', s.lname) as fullname, s.office_id as office, b.* from info_education as b
								LEFT JOIN signin as s ON b.user_id = s.id
								  WHERE 1 $extraOffice $extraDept $extraClient $extraFusion";
				$edu_list = $this->Common_model->get_query_result_array($edu_sql);

				$exp_sql = "SELECT s.fusion_id, CONCAT(s.fname, ' ', s.lname) as fullname, s.office_id as office, b.* from info_experience as b
								LEFT JOIN signin as s ON b.user_id = s.id
								  WHERE 1 $extraOffice $extraDept $extraClient $extraFusion";
				$exp_list = $this->Common_model->get_query_result_array($exp_sql);

				$other_sql = "SELECT s.fusion_id, CONCAT(s.fname, ' ', s.lname) as fullname, s.office_id as office, b.* from info_others_doc as b
								LEFT JOIN signin as s ON b.user_id = s.id
								  WHERE 1 $extraOffice $extraDept $extraClient $extraFusion";
				$other_list = $this->Common_model->get_query_result_array($other_sql);

				$passport_sql = "SELECT s.fusion_id, CONCAT(s.fname, ' ', s.lname) as fullname, s.office_id as office, b.* from info_passport as b
								LEFT JOIN signin as s ON b.user_id = s.id
								  WHERE 1 $extraOffice $extraDept $extraClient $extraFusion";
				$pass_list = $this->Common_model->get_query_result_array($passport_sql);
				
				$filename = "";
				//$filename = "./assets/reports/Report".get_user_id().".csv";
				$this->generate_document_download_archieve($info_list,$edu_list,$exp_list,$other_list,$pass_list,$report_list,$filename, $office_id);
				exit();
				// $dn_link = base_url()."reports/download_docu_upl_CSV/".$office_id
			}
			
			$data['download_link']=$dn_link;
			$data["action"] = $action;	
			$data['date_from'] = $date_from;
			$data['date_to'] = $date_to;	
			$data['office_id']=$office_id;
			$data['dept_id']=$dept_id;
			
			$this->load->view('dashboard',$data);
		}
	}	
	 

	public function download_docu_upl_CSV($off)
	{
		$currDate=date("Y-m-d");
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$newfile="Profile Document Upload List-'".$off."' - '".$currDate."'.csv";
		
		header('Content-Disposition: attachment;  filename="'.$newfile.'"');
		readfile($filename);
		// return $filename;
	}
	
	public function create_docu_upl_CSV($rr,$off)
	{
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$fopen = fopen($filename,"w+");
		
		if($off=='JAM'){
			$header = array("Fusion ID", "Full Name", "Location", "Client", "Process", "Department", "Tax Registration Number ID", "National Insurance Scheme ID", "Birth Certificate", "Married", "Marriage Certificate", "Bank Info", "Education Info", "Passport", "Other Document Upload");
		}else if(isIndiaLocation($off)==true){
			$header = array("Fusion ID", "Full Name", "Location", "Client", "Process", "Department", "Aadhar Card / Social Secuirity No", "PAN Card", "Photograph", "Covid-19 Declaration", "Education Info", "Passport", "Experience Info", "Bank Info", "Other Document Upload");
		}else if($off=='ELS'){
			$header = array("Fusion ID", "Full Name", "Location", "Client", "Process", "Department", "Resume", "NIT", "ISSS Information", "AFP Information", "Background Local",  "Passport", "Other Document Upload");
		}else if($off=='CEB' || $off=='MAN'){
			$header = array("Fusion ID", "Full Name", "Location", "Client", "Process", "Department", "SSS Number", "TIN Number", "Birth Certificate", "Philhealth Number", "Dependents Birth Certificate",  "Married", "Marriage Certificate", "BIR 2316 from previous",  "NBI Clearance", "Offer Letter", "Employment Contract", "Profile Sketch", "Updated CV",  "Other Document Upload");
		}
		
		$row = "";
		foreach($header as $data) $row .= ''.$data.',';
		fwrite($fopen,rtrim($row,",")."\r\n");
		$searches = array("\r", "\n", "\r\n");
		
		if($off=='JAM'){
			
			foreach($rr as $user)
			{
				if($user['pan_doc']!='') $pan_doc='Yes';
				else $pan_doc='No';
				if($user['nis_doc']!='') $nis_doc='Yes';
				else $nis_doc='No';
				if($user['birth_certi_doc']!='') $birth_certi_doc='Yes';
				else $birth_certi_doc='No';
				if($user['marrige_certi_doc']!='') $marrige_certi_doc='Yes';
				else $marrige_certi_doc='No';
				if($user['bank_doc']!='') $bank_doc='Yes';
				else $bank_doc='No';
				if($user['education_doc']!='') $education_doc='Yes';
				else $education_doc='No';
				if($user['passport_doc']!='') $passport_doc='Yes';
				else $passport_doc='No';
			
				$row = '"'.$user['fusion_id'].'",';
				$row .= '"'.$user['name'].'",';
				$row .= '"'.$user['office_id'].'",';
				$row .= '"'.$user['client_name'].'",';
				$row .= '"'.$user['process_name'].'",';
				$row .= '"'.$user['dept_name'].'",';
				$row .= '"'.$pan_doc.'",';
				$row .= '"'.$nis_doc.'",';
				$row .= '"'.$birth_certi_doc.'",';
				$row .= '"'.$user['marital_status'].'",';
				$row .= '"'.$marrige_certi_doc.'",';
				$row .= '"'.$bank_doc.'",';
				$row .= '"'.$education_doc.'",';
				$row .= '"'.$passport_doc.'",';
				$row .= '"'.$user['other_docu_info'].'"';
				
				fwrite($fopen,$row."\r\n");
			}
			fclose($fopen);
		
		}else if(isIndiaLocation($off)==true){
		
			foreach($rr as $user)
			{
				if($user['aadhar_doc']!='') $aadhar_doc='Yes';
				else $aadhar_doc='No';
				if($user['pan_doc']!='') $pan_doc='Yes';
				else $pan_doc='No';
				if($user['photograph']!='') $photograph='Yes';
				else $photograph='No';
				if($user['covid19declare_doc']!='') $covid19declare_doc='Yes';
				else $covid19declare_doc='No';
				if($user['education_doc']!='') $education_doc='Yes';
				else $education_doc='No';
				if($user['passport_doc']!='') $passport_doc='Yes';
				else $passport_doc='No';
				if($user['job_doc']!='') $experience_doc='Yes';
				else $experience_doc='No';
				if($user['bank_doc']!='') $bank_doc='Yes';
				else $bank_doc='No';
				
				$row = '"'.$user['fusion_id'].'",';
				$row .= '"'.$user['name'].'",';
				$row .= '"'.$user['office_id'].'",';
				$row .= '"'.$user['client_name'].'",';
				$row .= '"'.$user['process_name'].'",';
				$row .= '"'.$user['dept_name'].'",';
				$row .= '"'.$aadhar_doc.'",';
				$row .= '"'.$pan_doc.'",';
				$row .= '"'.$photograph.'",';
				$row .= '"'.$covid19declare_doc.'",';
				$row .= '"'.$education_doc.'",';
				$row .= '"'.$passport_doc.'",';
				$row .= '"'.$experience_doc.'",';
				$row .= '"'.$bank_doc.'",';
				$row .= '"'.$user['other_docu_info'].'"';
				
				fwrite($fopen,$row."\r\n");
			}
			fclose($fopen);
		
		}else if($off=='ELS'){
		
			foreach($rr as $user)
			{
				if($user['resume_doc']!='') $resume_doc='Yes';
				else $resume_doc='No';
				if($user['nit_doc']!='') $nit_doc='Yes';
				else $nit_doc='No';
				if($user['isss_doc']!='') $isss_doc='Yes';
				else $isss_doc='No';
				if($user['afp_info_doc']!='') $afp_info_doc='Yes';
				else $afp_info_doc='No';
				if($user['background_local_doc']!='') $background_local_doc='Yes';
				else $background_local_doc='No';
				if($user['passport_doc']!='') $passport_doc='Yes';
				else $passport_doc='No';
				
				$row = '"'.$user['fusion_id'].'",';
				$row .= '"'.$user['name'].'",';
				$row .= '"'.$user['office_id'].'",';
				$row .= '"'.$user['client_name'].'",';
				$row .= '"'.$user['process_name'].'",';
				$row .= '"'.$user['dept_name'].'",';
				$row .= '"'.$resume_doc.'",';
				$row .= '"'.$nit_doc.'",';
				$row .= '"'.$isss_doc.'",';
				$row .= '"'.$afp_info_doc.'",';
				$row .= '"'.$background_local_doc.'",';
				$row .= '"'.$passport_doc.'"';
				$row .= '"'.$user['other_docu_info'].'"';
				
				fwrite($fopen,$row."\r\n");
			}
			fclose($fopen);
		
		}else if($off=='CEB' || $off=='MAN'){
		
			foreach($rr as $user)
			{
				if($user['sss_no_doc']!='') $sss_no_doc='Yes';
				else $sss_no_doc='No';
				if($user['tin_no_doc']!='') $tin_no_doc='Yes';
				else $tin_no_doc='No';
				if($user['birth_certi_doc']!='') $birth_certi_doc='Yes';
				else $birth_certi_doc='No';
				if($user['philhealth_no_doc']!='') $philhealth_no_doc='Yes';
				else $philhealth_no_doc='No';
				if($user['dependent_birth_certi_doc']!='') $dependent_birth_certi_doc='Yes';
				else $dependent_birth_certi_doc='No';
				if($user['marrige_certi_doc']!='') $marrige_certi_doc='Yes';
				else $marrige_certi_doc='No';
				if($user['bir_2316_doc']!='') $bir_2316_doc='Yes';
				else $bir_2316_doc='No';
				if($user['nbi_clearance_doc']!='') $nbi_clearance_doc='Yes';
				else $nbi_clearance_doc='No';
				if($user['offer_letter']!='') $m_offer_doc='Yes';
				else $m_offer_doc='No';
				if($user['employment_contract']!='') $m_contract_doc='Yes';
				else $m_contract_doc='No';
				if($user['profile_sketch']!='') $m_profile_doc='Yes';
				else $m_profile_doc='No';
				if($user['updated_cv']!='') $m_updatedcv_doc='Yes';
				else $m_updatedcv_doc='No';
				
				$row = '"'.$user['fusion_id'].'",';
				$row .= '"'.$user['name'].'",';
				$row .= '"'.$user['office_id'].'",';
				$row .= '"'.$user['client_name'].'",';
				$row .= '"'.$user['process_name'].'",';
				$row .= '"'.$user['dept_name'].'",';
				$row .= '"'.$sss_no_doc.'",';
				$row .= '"'.$tin_no_doc.'",';
				$row .= '"'.$birth_certi_doc.'",';
				$row .= '"'.$philhealth_no_doc.'",';
				$row .= '"'.$dependent_birth_certi_doc.'",';
				$row .= '"'.$user['marital_status'].'",';
				$row .= '"'.$marrige_certi_doc.'",';
				$row .= '"'.$bir_2316_doc.'",';
				$row .= '"'.$nbi_clearance_doc.'",';
				$row .= '"'.$m_offer_doc.'",';
				$row .= '"'.$m_contract_doc.'",';
				$row .= '"'.$m_profile_doc.'",';
				$row .= '"'.$m_updatedcv_doc.'",';
				$row .= '"'.$user['other_docu_info'].'"';
				
				fwrite($fopen,$row."\r\n");
			}
			fclose($fopen);
		
		}
		
		fclose($fopen);
	}
///////////////////////////////	
	

	public function generate_document_download_archieve($info_list,$edu_list,$exp_list,$other_list,$pass_list,$reportArray, $csvfile, $office ='', $zipfile = '')
	{
		if(empty($zipFile)){ $zipFileName = "reports_archieve"; }
        $this->load->library('zip');
        $this->load->helper('download');
		$i=0;
		$filename = "./assets/reports/Bank_Upload_Report_.xlsx";
		$dataCounter = 0;
		
		// ADDED FOR ZIP SAVE TO DIRECTORY
		$zipfileDir = 'uploads/manadatory_document_zip/';
		$zipfilename = $zipfileDir .'reports_archieve_'.strtotime('now').'.zip';
		
		// DELETING OLD FILES
		$scanFiles = scandir($zipfileDir);
		$totalFilesAr = count($scanFiles);
		if($totalFilesAr > 10)
		{
			if(file_exists(FCPATH.$zipfileDir.$scanFiles[2])){
				unlink(FCPATH.$zipfileDir.$scanFiles[2]);
			}
		}
		
		// CREATING NEW ARCHIEVE
		$zip = new ZipArchive;
		if ($zip->open(FCPATH . $zipfilename, ZipArchive::CREATE) === TRUE) {
		//	
			
		//$this->zip->read_file($csvfile);
		//$zip->addFile($csvfile, "reports/mandatory_doc_reports.csv");		
		
		
		// print_r($reportArray);
		// exit;
		
		//========== BANK INFO =====//
        foreach ($reportArray as $token)
		{
			$fusionID   = $token["fusion_id"];
			$firstname  = $token["fullname"];
			$office     = $token["office"];
			$uploadDir = FCPATH.'/uploads/bank_upload/'.$fusionID.'/';
			
			$fileName = $uploadDir.$token['upl_bank_info'];
			$newFileName = "bank/" .$fusionID."_".$firstname."_".$office."_bank.".pathinfo($fileName, PATHINFO_EXTENSION);
			
			if(file_exists($fileName) && $token['upl_bank_info'] != ""){
				//$this->zip->read_file($fileName, $newFileName);
				$zip->addFile($fileName, $newFileName);
				$dataCounter++;
			}			
        }
		
		//==== INFO ODOCUMENT UPLOAD =======//
        foreach ($info_list as $token)
		{
			$fusionID   = $token["fusion_id"];
			$firstname  = $token["fullname"];
			$office     = $token["office"];
			$uploadDir = $this->config->item('profileUploadPath').'/'.$fusionID.'/';
			
			
			// FOR PHOTOPGRAPH
			$fileName = $uploadDir.$token['photograph'];
			$newFileName = "photo/" .$fusionID."_".$firstname."_".$office."_photograph.".pathinfo($fileName, PATHINFO_EXTENSION);			
			if(file_exists($fileName) && $token['photograph'] != ""){
				//$this->zip->read_file($fileName, $newFileName);
				$zip->addFile($fileName, $newFileName);
				$dataCounter++;
			}
			
			// FOR ADHAAR
			$fileName = $uploadDir.$token['aadhar_doc'];
			$newFileName = "adhaar/" .$fusionID."_".$firstname."_".$office."_aadhar.".pathinfo($fileName, PATHINFO_EXTENSION);			
			if(file_exists($fileName) && $token['aadhar_doc'] != ""){
				//$this->zip->read_file($fileName, $newFileName);
				$zip->addFile($fileName, $newFileName);
				$dataCounter++;
			}

			// FOR PAN
			$fileName = $uploadDir.$token['pan_doc'];
			$newFileName = "pan/" .$fusionID."_".$firstname."_".$office."_pan.".pathinfo($fileName, PATHINFO_EXTENSION);			
			if(file_exists($fileName) && $token['pan_doc'] != ""){
				//$this->zip->read_file($fileName, $newFileName);
				$zip->addFile($fileName, $newFileName);
				$dataCounter++;
			}
			
			// FOR COVID DECLARE
			$fileName = $uploadDir.$token['covid19declare_doc'];
			$newFileName = "covid19/" .$fusionID."_".$firstname."_".$office."_covid19declare.".pathinfo($fileName, PATHINFO_EXTENSION);			
			if(file_exists($fileName) && $token['covid19declare_doc'] != ""){
				//$this->zip->read_file($fileName, $newFileName);
				$zip->addFile($fileName, $newFileName);
				$dataCounter++;
			}
			
			
			// MANDATORY DOC FOR CEBU & MANILA
			if($office=='CEB' || $office=='MAN'){
				
				// SS NO
				$fileName = $uploadDir.$token['sss_no_doc'];
				$newFileName = "mandatory/" .$fusionID."_".$firstname."_".$office."_sss_no_doc.".pathinfo($fileName, PATHINFO_EXTENSION);			
				if(file_exists($fileName) && $token['sss_no_doc'] != ""){
					//$this->zip->read_file($fileName, $newFileName);
					$zip->addFile($fileName, $newFileName);
					$dataCounter++;
				}

				// tin_no_doc
				$fileName = $uploadDir.$token['tin_no_doc'];
				$newFileName = "mandatory/" .$fusionID."_".$firstname."_".$office."_tin_no_doc.".pathinfo($fileName, PATHINFO_EXTENSION);			
				if(file_exists($fileName) && $token['tin_no_doc'] != ""){
					//$this->zip->read_file($fileName, $newFileName);
					$zip->addFile($fileName, $newFileName);
					$dataCounter++;
				}

				// birth_certi_doc
				$fileName = $uploadDir.$token['birth_certi_doc'];
				$newFileName = "mandatory/" .$fusionID."_".$firstname."_".$office."_birth_certi_doc.".pathinfo($fileName, PATHINFO_EXTENSION);			
				if(file_exists($fileName) && $token['birth_certi_doc'] != ""){
					//$this->zip->read_file($fileName, $newFileName);
					$zip->addFile($fileName, $newFileName);
					$dataCounter++;
				}
				
				// philhealth_no_doc
				$fileName = $uploadDir.$token['philhealth_no_doc'];
				$newFileName = "mandatory/" .$fusionID."_".$firstname."_".$office."_philhealth_no_doc.".pathinfo($fileName, PATHINFO_EXTENSION);			
				if(file_exists($fileName) && $token['philhealth_no_doc'] != ""){
					//$this->zip->read_file($fileName, $newFileName);
					$zip->addFile($fileName, $newFileName);
					$dataCounter++;
				}
				
				// dependent_birth_certi_doc
				$fileName = $uploadDir.$token['dependent_birth_certi_doc'];
				$newFileName = "mandatory/" .$fusionID."_".$firstname."_".$office."_dependent_birth_certi_doc.".pathinfo($fileName, PATHINFO_EXTENSION);			
				if(file_exists($fileName) && $token['dependent_birth_certi_doc'] != ""){
					//$this->zip->read_file($fileName, $newFileName);
					$zip->addFile($fileName, $newFileName);
					$dataCounter++;
				}
				
				// marrige_certi_doc
				$fileName = $uploadDir.$token['marrige_certi_doc'];
				$newFileName = "mandatory/" .$fusionID."_".$firstname."_".$office."_marrige_certi_doc.".pathinfo($fileName, PATHINFO_EXTENSION);			
				if(file_exists($fileName) && $token['marrige_certi_doc'] != ""){
					//$this->zip->read_file($fileName, $newFileName);
					$zip->addFile($fileName, $newFileName);
					$dataCounter++;
				}
				
				// bir_2316_doc
				$fileName = $uploadDir.$token['bir_2316_doc'];
				$newFileName = "mandatory/" .$fusionID."_".$firstname."_".$office."_bir_2316_doc.".pathinfo($fileName, PATHINFO_EXTENSION);			
				if(file_exists($fileName) && $token['bir_2316_doc'] != ""){
					//$this->zip->read_file($fileName, $newFileName);
					$zip->addFile($fileName, $newFileName);
					$dataCounter++;
				}
				
				// nbi_clearance_doc
				$fileName = $uploadDir.$token['nbi_clearance_doc'];
				$newFileName = "mandatory/" .$fusionID."_".$firstname."_".$office."_nbi_clearance_doc.".pathinfo($fileName, PATHINFO_EXTENSION);			
				if(file_exists($fileName) && $token['nbi_clearance_doc'] != ""){
					//$this->zip->read_file($fileName, $newFileName);
					$zip->addFile($fileName, $newFileName);
					$dataCounter++;
				}
				
				// offer_letter
				$fileName = $uploadDir.$token['offer_letter'];
				$newFileName = "mandatory/" .$fusionID."_".$firstname."_".$office."_offer_letter.".pathinfo($fileName, PATHINFO_EXTENSION);			
				if(file_exists($fileName) && $token['offer_letter'] != ""){
					//$this->zip->read_file($fileName, $newFileName);
					$zip->addFile($fileName, $newFileName);
					$dataCounter++;
				}
				
				// offer_letter
				$fileName = $uploadDir.$token['offer_letter'];
				$newFileName = "mandatory/" .$fusionID."_".$firstname."_".$office."_offer_letter.".pathinfo($fileName, PATHINFO_EXTENSION);			
				if(file_exists($fileName) && $token['offer_letter'] != ""){
					//$this->zip->read_file($fileName, $newFileName);
					$zip->addFile($fileName, $newFileName);
					$dataCounter++;
				}
				
				// employment_contract
				$fileName = $uploadDir.$token['employment_contract'];
				$newFileName = "mandatory/" .$fusionID."_".$firstname."_".$office."_employment_contract.".pathinfo($fileName, PATHINFO_EXTENSION);			
				if(file_exists($fileName) && $token['employment_contract'] != ""){
					//$this->zip->read_file($fileName, $newFileName);
					$zip->addFile($fileName, $newFileName);
					$dataCounter++;
				}
				
				// profile_sketch
				$fileName = $uploadDir.$token['profile_sketch'];
				$newFileName = "mandatory/" .$fusionID."_".$firstname."_".$office."_profile_sketch.".pathinfo($fileName, PATHINFO_EXTENSION);			
				if(file_exists($fileName) && $token['profile_sketch'] != ""){
					//$this->zip->read_file($fileName, $newFileName);
					$zip->addFile($fileName, $newFileName);
					$dataCounter++;
				}
				
				// updated_cv
				$fileName = $uploadDir.$token['updated_cv'];
				$newFileName = "mandatory/" .$fusionID."_".$firstname."_".$office."_updated_cv.".pathinfo($fileName, PATHINFO_EXTENSION);			
				if(file_exists($fileName) && $token['updated_cv'] != ""){
					//$this->zip->read_file($fileName, $newFileName);
					$zip->addFile($fileName, $newFileName);
					$dataCounter++;
				}
			}
			
        }
		
		//==== EDUCATION DOC =========//
        foreach ($edu_list as $token)
		{
			$fusionID   = $token["fusion_id"];
			$firstname  = $token["fullname"];
			$office     = $token["office"];
			$uploadDir = $this->config->item('profileUploadPath').'/'.$fusionID.'/';
			
			$fileName = $uploadDir.$token['education_doc'];
			$newFileName = "education/" .$fusionID."_".$firstname."_".$office."_education.".pathinfo($fileName, PATHINFO_EXTENSION);
			
			if(file_exists($fileName) && $token['education_doc'] != ""){
				//$this->zip->read_file($fileName, $newFileName);
				$zip->addFile($fileName, $newFileName);
				$dataCounter++;
			}			
        }
		
		//==== EXPERIENCE DOC =========//
        foreach ($exp_list as $token)
		{
			$fusionID   = $token["fusion_id"];
			$firstname  = $token["fullname"];
			$office     = $token["office"];
			$uploadDir = $this->config->item('profileUploadPath').'/'.$fusionID.'/';
			
			$fileName = $uploadDir.$token['job_doc'];
			$newFileName = "experience/" .$fusionID."_".$firstname."_".$office."_job.".pathinfo($fileName, PATHINFO_EXTENSION);
			
			if(file_exists($fileName) && $token['job_doc'] != ""){
				//$this->zip->read_file($fileName, $newFileName);
				$zip->addFile($fileName, $newFileName);
				$dataCounter++;
			}			
        }
		
		//==== OTHERS INFO DOC =========//
        foreach ($other_list as $token)
		{
			$fusionID   = $token["fusion_id"];
			$firstname  = $token["fullname"];
			$office     = $token["office"];
			$uploadDir = $this->config->item('profileUploadPath').'/'.$fusionID.'/';
			
			$fileName = $uploadDir.$token['info_doc'];
			$newFileName = "others/" .$fusionID."_".$firstname."_".$office."_other.".pathinfo($fileName, PATHINFO_EXTENSION);
			
			if(file_exists($fileName) && $token['info_doc'] != ""){
				//$this->zip->read_file($fileName, $newFileName);
				$zip->addFile($fileName, $newFileName);
				$dataCounter++;
			}			
        }
		
		//==== PASSPORT DOC =========//
        foreach ($pass_list as $token)
		{
			$fusionID   = $token["fusion_id"];
			$firstname  = $token["fullname"];
			$office     = $token["office"];
			$uploadDir = $this->config->item('profileUploadPath').'/'.$fusionID.'/';
			
			$fileName = $uploadDir.$token['passport_doc'];
			$newFileName = "passport/" .$fusionID."_".$firstname."_".$office."_passport.".pathinfo($fileName, PATHINFO_EXTENSION);
			
			if(file_exists($fileName) && $token['passport_doc'] != ""){
				//$this->zip->read_file($fileName, $newFileName);
				$zip->addFile($fileName, $newFileName);
				$dataCounter++;
			}			
        }
		
		$zip->close();
		
		}
		
		if($dataCounter > 0)
		{
			header('Location:'.base_url() . $zipfilename);
		} else {
			header('Location:'.base_url().'download_document?nodata=1');
		}
		
        //$this->zip->download($zipFileName.'.zip');		
	}
	
	
	
	
	
	///============= Download Photograph ===============================================//
	
	public function photograph()
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
			$data["aside_template"] = "reports/aside.php";
			$data["content_template"] = "reports/photo_upload_report.php";
			
			$data['location_list'] = $this->Common_model->get_office_location_list();
			$data['dept_list'] = $this->Common_model->get_department_list();
			
			$cValue = trim($this->input->post('client_id'));
			if($cValue=="") $cValue = trim($this->input->get('client_id'));
			
			$pValue = trim($this->input->post('process_id'));
			if($pValue=="") $pValue = trim($this->input->get('process_id'));
			
			$data['cValue']=$cValue;
			$data['pValue']=$pValue;
			
			
			$data['client_list'] = $this->Common_model->get_client_list();
			
			if($cValue=="" || $cValue=="ALL") $data['process_list'] = array();
			else $data['process_list'] = $this->Common_model->get_process_list($cValue);
			
			$office_id = "";
			$dept_id = "";
			$date_from="";
			$date_to="";
			$action="";
			$dn_link="";
			$cond="";
			
			
			$data["docu_upl_list"] = array();
			
			if($this->input->get('show')=='Show')
			{
				$office_id = $this->input->get('office_id');
				$dept_id = $this->input->get('dept_id');
				$client_id = $this->input->get('client_id');
				$process_id = $this->input->get('process_id');
												
				$extraOffice = "";
				if($office_id!='ALL'){ $extraOffice = " AND s.office_id = '$office_id' "; }
				
				$extraDept = "";
				if($dept_id!='ALL'){ $extraDept = " AND s.dept_id = '$dept_id' "; }
				
				$extraClient = "";
				if($client_id!='ALL' && $client_id!='' && !empty($client_id)){ $extraClient .= " AND is_assign_client(s.id, $client_id) "; }
				
				if($process_id!='ALL' && $process_id!='' && !empty($process_id)){ $extraClient .= " AND is_assign_process(s.id, $process_id) "; }
								
				$extraFusion = "";
				$fusionSelection = $this->input->get('report_fusion_id');
				if(!empty($fusionSelection))
				{
					$extraOffice = ""; $extraDept = ""; $extraClient = "";
					$fusion_ids_ar = explode(',', $fusionSelection);
					$fusion_ids = implode("','", $fusion_ids_ar);
					$extraFusion = " AND s.fusion_id IN ('".$fusion_ids."') ";
				}
				
				$reports_sql = "SELECT s.*, d.photograph as myphotograph from signin as s
								  LEFT JOIN info_document_upload as d ON s.id = d.user_id
								  WHERE 1 $extraOffice $extraDept $extraClient $extraFusion";
				$report_list = $this->Common_model->get_query_result_array($reports_sql);
				
				$filename = "";
				$this->generate_photo_download_archieve($report_list, $filename, $office_id);
				exit();
			}
			
			$data['download_link']=$dn_link;
			$data["action"] = $action;	
			$data['date_from'] = $date_from;
			$data['date_to'] = $date_to;	
			$data['office_id']=$office_id;
			$data['dept_id']=$dept_id;
			
			$this->load->view('dashboard',$data);
		}
	}
	
	public function generate_photo_download_archieve($reportArray, $csvfile='', $office ='', $zipfile = '')
	{
		if(empty($zipFile)){ $zipFileName = "reports_archieve_photo"; }
        $this->load->library('zip');
        $this->load->helper('download');
		$i=0;
		$filename = "./assets/reports/Bank_Upload_Report_.xlsx";
		$dataCounter = 0;
		
		// ADDED FOR ZIP SAVE TO DIRECTORY
		$zipfileDir = 'uploads/document_zip/photograph/';
		$zipfilename = $zipfileDir .'reports_archieve_photo_'.strtotime('now').'.zip';
		
		// DELETING OLD FILES
		$scanFiles = scandir($zipfileDir);
		$totalFilesAr = count($scanFiles);
		if($totalFilesAr > 10)
		{
			if(file_exists(FCPATH.$zipfileDir.$scanFiles[2])){
				unlink(FCPATH.$zipfileDir.$scanFiles[2]);
			}
		}
		
		// CREATING NEW ARCHIEVE
		$zip = new ZipArchive;
		if ($zip->open(FCPATH . $zipfilename, ZipArchive::CREATE) === TRUE) {
				
			//$this->zip->read_file($csvfile);
			//$zip->addFile($csvfile, "reports/mandatory_doc_reports.csv");		
						
			//========== PHOTO INFO =====//
			foreach($reportArray as $token)
			{
				$fusionID   = $token["fusion_id"];
				$firstname  = $token["fname"];
				$lastname  = $token["lname"];
				$office_id  = $token["office_id"];
				$photograph = $token["myphotograph"];
				$uploadDir = FCPATH.'uploads/photo/';
								
				$newFileName = $firstname ."_" .$lastname."_".$fusionID.".png";
				$newFileName = preg_replace('/\s/', '', $newFileName);
				
				$fileName = $uploadDir.$photograph;
				
				$found = false;
				if(file_exists($fileName) && !empty($photograph)){				
					$found = true;
					$zip->addFile($fileName, $newFileName);
					$dataCounter++;
				}
				if($found == false)
				{
					if(file_exists($newFileName)){
						$found = true;
						$zip->addFile($newFileName, $newFileName);
						$dataCounter++;
					}
				}
				if($found == false)
				{
					$checkFileName = $firstname ."_" .$lastname."_".$fusionID.".png";
					if(file_exists($checkFileName)){
						$found = true;
						$zip->addFile($checkFileName, $newFileName);
						$dataCounter++;
					}
				}
			}
			
			$zip->close();
		
		}
		if($dataCounter > 0)
		{
			header('Location:'.base_url() . $zipfilename);
		} else {
			header('Location:'.base_url().'download_document/photograph?nodata=1');
		}
		
        //$this->zip->download($zipFileName.'.zip');		
	}
		
}

?>