<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Employee_id extends CI_Controller {
	
	
	function __construct() {
		parent::__construct();
		$this->load->model('user_model');
		$this->load->model('Common_model');
		$this->load->model('Profile_model');
		$this->load->library('excel');	
		$this->load->helper('dynamic_qa_functions');	
		$this->load->helper('dynamic_qa_scorecard');	
		$this->load->model('Dynamic_qa_model', 'Dynamic_QA');	
		$this->objPHPExcel = new PHPExcel();
	}
	
	public function index(){				
		redirect(base_url()."employee_id/card");	 
	}
	
	
	public function get_night_login()
	{
		
		//$login = "2020-12-03 16:00:00";
		//$logout = "2020-12-04 01:00:00";
		
		if(!empty($this->input->get('logindate'))){
			$login = $this->input->get('logindate');
			$logout = $this->input->get('logoutdate');
		}
		
		
		$data['result'] = $this->calcNightLogin_SKT($login,$logout);
		
		//$data["aside_template"] = "employee_id/aside.php";
		//$data["content_template"] = "employee_id/test_time.php";
		$this->load->view('employee_id/test_time',$data);
		
	}
	
	
	function calcNightLogin_SKT($login,$logout) {
		
		
		$NCalLoginDate="";
		$NCalLogoutDate="";
		
		$loginSet = "22:00:00";
		$logoutSet = "06:00:00";
		
		$NightLoginDate = date('Y-m-d', strtotime($login)) ." " .$loginSet;
		$PrevNightLoginDate =date('Y-m-d', strtotime("-1 day", strtotime($login)))." " .$loginSet;
		
		$NightLogoutDate = date('Y-m-d', strtotime("+1 day", strtotime($login)))." " .$logoutSet;
		$PrevNightLogoutDate = date('Y-m-d', strtotime($login)) ." " .$logoutSet;
		
		if(strtotime($login) >= strtotime($PrevNightLoginDate) && strtotime($login) <= strtotime($PrevNightLogoutDate)) $NCalLoginDate = $login;
		else if(strtotime($login) <= strtotime($NightLoginDate)) $NCalLoginDate = $NightLoginDate;
		else $NCalLoginDate = $login;
		
		if(strtotime($logout) >= strtotime($PrevNightLogoutDate) && strtotime($logout) <= strtotime($NightLoginDate)){ 		$NCalLogoutDate = $PrevNightLogoutDate;
		}else if( strtotime($logout) <= strtotime($NightLogoutDate) ){
			$NCalLogoutDate = $logout;
		}else $NCalLogoutDate = $NightLogoutDate;
		
		echo "<br>Login:" . $login;
		echo "<br>logout:" . $logout;
		echo "<br>NCalLoginDate:" . $NCalLoginDate;
		echo "<br>NCalLogoutDate:" . $NCalLogoutDate;
		
		echo "<br><br>";
		
		// ACTUAL LOGIN SECONDS
		$totalLoginSeconds = 0;
		if(strtotime($logout) > strtotime($login)){
			$totalLoginSeconds = strtotime($logout) - strtotime($login);
		}
		
		// ACTUAL Light Login SECONDS
		$nightLoginSeconds = 0;
		if(strtotime($NCalLogoutDate) > strtotime($NCalLoginDate)){
			$nightLoginSeconds = strtotime($NCalLogoutDate) - strtotime($NCalLoginDate);
		}
		
		$retAArray= [
			"login" => $login,
			"logout" => $logout,
			"nightLogin" => $this->convertSecToTime($nightLoginSeconds),
			"actualLogin" => $this->convertSecToTime($totalLoginSeconds),
		];
		
		
		return $retAArray;
		
		
	}
	
	
	function calcNightLogin_SP($login,$logout) {
		
				
		$loginSet = "22:00:00";
		$logoutSet = "06:00:00";
		
		$loginDate = date('Y-m-d', strtotime($login)) ." " .$loginSet;
		$logoutDate = date('Y-m-d', strtotime("+1 day", strtotime($login)))." " .$logoutSet;
		
		// NIGHT FIX CHECK
		$nightCheckLoginDate = date('Y-m-d', strtotime($login)) ." " ."06:00:00";
		if(strtotime($login) <= strtotime($nightCheckLoginDate))
		{
			$loginDate = date('Y-m-d', strtotime('-1 day', strtotime($login))) ." " .$loginSet;
			$logoutDate = date('Y-m-d', strtotime("+1 day", strtotime($login)))." " .$logoutSet;
		}
		
		// ACTUAL LOGIN SECONDS
		$totalLoginSeconds = 0;
		if(strtotime($logout) > strtotime($login)){
			$totalLoginSeconds = strtotime($logout) - strtotime($login);
		}
		
		// PRE LOGIN SECONDS
		$preLoginTimeSeconds = 0;
		if(strtotime($login) < strtotime($loginDate) && strtotime($login) < strtotime($logout))
		{
			$preLoginTimeSeconds = strtotime($loginDate) - strtotime($login);
		}
		
		// POST LOGIN SECONDS
		$postLoginTimeSeconds = 0;
		if(strtotime($logout) > strtotime($loginDate) && strtotime($logout) > strtotime($logoutDate))
		{
			$postLoginTimeSeconds = strtotime($logout) - strtotime($logoutDate);
		}
		
		// NIGHT LOGIN SECONDS
		$nightLoginSeconds = 0;
		if(strtotime($logout) >= strtotime($loginDate) && strtotime($login) <= strtotime($logoutDate))
		{
			$nightLoginSeconds = $totalLoginSeconds - ($preLoginTimeSeconds + $postLoginTimeSeconds);
		}
		
		$loginTime = $this->convertSecToTime($nightLoginSeconds);
		
		$retAArray= [
			"login" => $login,
			"logout" => $logout,
			"nightLogin" => $loginTime,
			"actualLogin" => $this->convertSecToTime($totalLoginSeconds),
		];
		
		
		return $retAArray;
		
		
	}
	
	
	function convertSecToTime($sec) {
		return lz(floor($sec / (60*60))).":".lz(floor(($sec % (60*60))/60)).":". lz(floor(($sec % (60*60))%60));
	}

	function seconds_to_interval($seconds)
	{
		$diff = $seconds;
		$hours = floor($diff / (60*60));
		$minutes = floor(($diff - $hours*60*60)/ 60);
		$seconds = floor(($diff - $hours*60*60 - $minutes*60));
		
		$times = "";
		if($hours > 0){ $times .= sprintf('%02d',$hours) .":"; } else {  $times .= "00:"; }
		if($minutes > 0){ $times .= sprintf('%02d',$minutes) .":"; }  else {  $times .= "00:"; }
		if($seconds > 0){ if($minutes <= 0) { $times .= sprintf('%02d',$seconds); } else {  $times .= "00"; } } else { $times .= "00"; } 
		return $times;
	}
	
	///=========================== EMPLOYEE ID CARD ================================///
	
	public function card()
	{		 
		$current_user = get_user_id();
		$user_site_id= get_user_site_id();
		$user_office_id= get_user_office_id();
		$user_oth_office=get_user_oth_office();
		$is_global_access=get_global_access();
		$is_role_dir=get_role_dir();
		$get_dept_id=get_dept_id();
		
		$data['today'] = GetLocalTime();
		
		$fusion_id = "";
		$agent_sql = "SELECT * from signin WHERE id = '$current_user'";
		$currentFusionID = $this->uri->segment(3);
		if($currentFusionID != "")
		{
			$fusion_id = $currentFusionID;
			$agent_sql = "SELECT * from signin WHERE fusion_id = '$currentFusionID'";
		}
		
		$data['agent_details'] = $agent_details = $this->Common_model->get_query_row_array($agent_sql);
		if(!empty($agent_details['fusion_id'])){ $fusion_id = $agent_details['fusion_id']; }
		$data['prof_pic_url']=$this->Profile_model->get_profile_pic($fusion_id);
		$data['prof_widget_left']=$this->Profile_model->get_profile_widget($fusion_id,"left");
		$data['prof_widget']=$this->Profile_model->get_profile_widget($fusion_id,"");
		
		$data['prof_fid']=$fusion_id;
		if(is_view_profile($fusion_id)==false) redirect(base_url()."profile","refresh");
		
		$currentImage = "";
		$idFolder = FCPATH ."uploads/id_card/";
		$agentCard = $agent_details['fusion_id'] ."/" ."id_".$agent_details['fusion_id'].".png";
		if(file_exists($idFolder .$agentCard))
		{
			$currentImage = base_url() ."uploads/id_card/".$agentCard;
		}
		$data['id_card'] = $currentImage;
						
		$data["aside_template"] = "profile/aside.php";
		$data["content_template"] = "employee_id/idcard.php";
		$data["content_js"] = "employee_id/idcard_js.php";
		
		$this->load->view('dashboard',$data);
	 
	}
	
	
	
	public function generateCard()
	{		 
		$current_user = get_user_id();
		$user_site_id= get_user_site_id();
		$user_office_id= get_user_office_id();
		$user_oth_office=get_user_oth_office();
		$is_global_access=get_global_access();
		$is_role_dir=get_role_dir();
		$get_dept_id=get_dept_id();
		
		$data['today'] = GetLocalTime();
		
		//$this->load->library('m_pdf');
		require_once APPPATH.'/third_party/mpdf-5.7/mpdf.php';		
		$type = 'I';
		
		$agent_sql = "SELECT * from signin WHERE id = '$current_user'";
		$data['agent_details'] = $agent_details = $this->Common_model->get_query_row_array($agent_sql);		
		$fusion_id = $agent_details['fusion_id'];
		
		if(!empty($this->uri->segment(4))){ 
			$fusion_id = $this->uri->segment(4); 
			$agent_sql = "SELECT * from signin WHERE fusion_id = '$fusion_id'";
			$data['agent_details'] = $agent_details = $this->Common_model->get_query_row_array($agent_sql);
		}
		
		if(is_view_profile($fusion_id)==false) redirect(base_url()."profile","refresh");
		
		if(!empty($this->uri->segment(3))){ 
			if($this->uri->segment(3) == 'download'){ $type = 'D'; } 
			if($this->uri->segment(3) == 'view'){ $type = 'I'; }
		}	
			
		$currentImage = "assets/idcard/profile.jpg";
		$idFolder = FCPATH ."uploads/id_card/";
		$agentCard = $fusion_id ."/" ."id_".$fusion_id.".png";
		if(file_exists($idFolder .$agentCard))
		{
			$currentImage = "uploads/id_card/".$agentCard;
		}
		$data['id_card'] = $currentImage;
		
		$html=$this->load->view('employee_id/template_1', $data,true);
	
		if((!empty($fusion_id) && $type == 'F') || $type == 'I' || $type == 'D')
		{
			//if($type == 'F')
			//{
				$pdfFilePath = "id_card_" .$fusion_id.".pdf";
				$uploadDir = FCPATH .'uploads/id_card/'.$fusion_id.'/';
				$finalDir = $uploadDir .$pdfFilePath;
				if (!file_exists($uploadDir)) {
					mkdir($uploadDir, 0777, true);
				}				
			//}
			
			//$pdf = new m_pdf();
			//$pdf->pdf->AddPage('L');			
			//$pdf->pdf->shrink_tables_to_fit;;			
			//$pdf->pdf->WriteHTML($html);			
			//$pdf->pdf->Output($finalDir, $type);
			
			$pdf = new mpdf('utf-8', array(80,115),0, '', 0, 0, 0, 0, 0, 0);			
			$pdf->SetHTMLFooter('
			<div style="width:100%;text-align:center;"><img src="assets/idcard/fusion-logo.png" style="max-width:100%;height:90px;" alt=""></div>
			<div style="width:100%;margin-top:10px"><img src="assets/idcard/bottom-divider.jpg" style="width:100%;margin:0 0 0px 0;" alt=""></div>
			');			
			$pdf->WriteHTML($html);
			$pdf->Output($finalDir, 'F');
			$pdf->Output($pdfFilePath, $type);
		}
	 
	}
		
	
	function imageCropping()
	{	
		$data = $_POST['image'];		
		$fusion_id = $this->input->post('fusionid');
		
		list($type, $data) = explode(';', $data);
		list(, $data) = explode(',', $data);
		$data = base64_decode($data);
		
		//$imageName = "id_" .$fusion_id ."_" .time().'.png';
		$imageName = "id_" .$fusion_id.'.png';
		
		$idFolder = FCPATH ."uploads/id_card/";
		$idDir = $idFolder .$fusion_id;
		if(!file_exists($idDir)){ mkdir($idDir, 0777, true); }
		$uploadDir = $idDir ."/" .$imageName;
		
		file_put_contents($uploadDir, $data);
	}
	
	
	//====== Automated Reminder Every 24 HOURS for Assgining L1 Supervisor for Production Hiring Requisition ========//
	/*function cron_dfr_l1_assign_reminder()
	{	
		$this->load->model('dfr_email_model');
		$this->dfr_email_model->send_email_autocron_notification_supervisor();
		
	}*/  
	
	
	///=========================== TEST QA ================================///
	function test_qa()
	{
		$designID = $this->uri->segment(3);
		if(empty($designID)){ show_error('Sorry! Design ID Missing'); }
		
		$data['designID'] = $designID;
		
		$data['officeList'] = "";
		
		$data["aside_template"] = "dynamic_qa_scorecard/scorecard_aside.php";
		$data["content_template"] = "employee_id/test_qa_form.php";
		$data["content_js"] = "employee_id/test_qa_js.php";
		
		$this->load->view('dashboard',$data);
	}
	
	
	function test_qa_form_template()
	{	
		$designID = $this->uri->segment(3);
		$showType = $this->uri->segment(4);
		if(empty($showType)){ $showType = 1; }
		if(empty($designID)){ show_error('Sorry! Design ID Missing'); }
		
		$data['designID'] = $designID;
		$data['showType'] = $showType;
		$limit = "";
		if($showType == 2){ $limit = 10; }
		
		$sqlDesign = "SELECT * from test_qa_design WHERE id = '$designID'";
		$data['designDetails'] = $designDetails = $this->Common_model->get_query_row_array($sqlDesign);
		
		// DESIGN DETAILS
		$d_officeID = $designDetails['office_id'];
		$d_clientID = $designDetails['client_id'];
		$d_processID = $designDetails['process_id'];
		$d_campaignID = $designDetails['campaign_id'];
				
		$sqlTemplate = "SELECT * from test_qa_design_template WHERE design_id = '$designID' ORDER by overall_position, line_position";
		$data['tempalteDesign'] = $designArray = $this->Common_model->get_query_result_array($sqlTemplate);
		$data['designElements'] = d_array_indexed($designArray, 'id');
		
		$data['masterDesign'] = $masterDesign = array_filter($designArray, function($token){
			$elementType = explode('_', $token['element_type']);
			if(!empty($elementType) && $elementType[0] == 'master'){ return $token; }
		});
		
		//========== MASTER LIST
		$gotList = false;
		$d_agentList = array();
		$d_supervisorList = array();
		$masterElementCol = array_unique(array_column($masterDesign, 'reference_type'));
		foreach($masterElementCol as $token)
		{
			if(($token == 'master_agent_list' || $token == 'master_supervisor_list') && $gotList == false)
			{
				$gotList = true;
				$extraFilter = " AND r.folder = 'agent'";
				$d_agentList = $this->Dynamic_QA->user_list($extraFilter, $d_officeID, $d_clientID, $d_processID, '', '', '', $limit);
				$agentIDs_Arr = array_column($d_agentList, 'assigned_to');
				$agentIDs = implode(',', $agentIDs_Arr);
				
				$extraFilter = " AND r.folder <> 'agent'";				
				if($agentIDs == ""){ $agentIDs = '0'; }
				$extraOption = " s.id IN ($agentIDs)";
				$d_supervisorList = $this->Dynamic_QA->user_list($extraFilter, $d_officeID, $d_clientID, $d_processID, '', '', $extraOption, $limit);
			}
		}
		$data['master_agent_list'] = $d_agentList;
		$data['master_supervisor_list'] = $d_supervisorList;
		
		//========== DROPDOWN LIST
		$dropdownList = $this->Dynamic_QA->element_dropdown_list($designID);
		$data['dropdown_list'] = $dropdownList['list'];
		$data['dropdown_options'] = $dropdownList['data'];
		//d_printr($dropdownList, 1);
		
		//========== SCORECARD LIST
		$scoreCardList = $this->Dynamic_QA->element_scorecard_parent_list($designID);
		$data['scorecard_parent'] = $scoreCardList['parent'];
		$data['scorecard_child'] = $scoreCardList['child'];
		$data['scorecard_param'] = $scoreCardList['param'];
		//d_printr($scoreCardList);
		
		//========== SCORECARD PARAMETER LIST
		$paramterList = $this->Dynamic_QA->element_parameter_dropdown_list($designID);
		$data['parameter_list'] = $paramterList['list'];
		$data['parameter_options'] = $paramterList['data'];
		//d_printr($paramterList, 1);
		
		//========== SCORECARD CALCULATION LIST
		$calculationList = $this->Dynamic_QA->element_parameter_calculation_options($designID);
		$data['calculation_list'] = $calculationList['list'];
		$data['calculation_params'] = $calculationList['data'];
		$data['calculation_calc'] = $calculationList['calc'];
		//d_printr($calculationList);
		
		//========== SCORECARD OVERALL CALCULATION LIST
		$calculationOverallList = $this->Dynamic_QA->element_overall_calculation_options($designID);
		$data['calculation_overall_list'] = $calculationOverallList['list'];
		$data['calculation_overall_params'] = $calculationOverallList['data'];
		$data['calculation_overall_calc'] = $calculationOverallList['calc'];		
		
		$this->load->view('employee_id/test_qa_view.php',$data);
	}
	
	function test_qa_form_template_submit()
	{	
		$designID = $this->input->post('design_id');
		$format_type = $this->input->post('format_type');
		$f_label = $this->input->post('f_label');
		$f_value = $this->input->post('f_value');
		$f_type = $this->input->post('f_type');
		$f_code = $this->input->post('f_code');
		$f_input = $this->input->post('f_input');
		$f_width = $this->input->post('f_width');
		$f_featured = $this->input->post('f_featured');
		$f_reference_type = $this->input->post('f_reference_type');
		$f_reference_format = $this->input->post('f_reference_format');
		$f_is_custom = $this->input->post('f_is_custom');
		$f_has_child = $this->input->post('f_has_child');
		$f_is_weightage = $this->input->post('f_is_weightage');
		$f_parent_category = $this->input->post('f_parent_category');
		$f_child_category = $this->input->post('f_child_category');
		
		$inputType = "";
		if(!empty($f_type)){
			$inputType = implode(',', $f_type);
		}
		
		$linePosition = 0;
		$sqlPosition= "SELECT max(overall_position) as value from test_qa_design_template WHERE design_id = '$designID'";
		$position = $this->Common_model->get_single_value($sqlPosition);
		if(empty($position)){ $position = 0; }
		$position = $position + 1;
		
		$this->db->trans_start();
		
		$is_input = 0;
		$format_typeAr = explode('_', $format_type);
		if($format_type[0] == 'input'){ $is_input = 1; }
		if($format_type[0] == 'master'){ $is_input = 1; }
		if($format_type[0] == 'calculation'){ $is_input = 1; }
		
		$dataArray = [
			"design_id" => $designID,
			"element_type" => $format_type,			
			"format_type" => $f_input,
			"is_input" => $is_input,
			"line_position" => $linePosition,
			"overall_position" => $position,
			"element_width" => $f_width,
		];
		
		if(!empty($f_label)){
			$dataArray += [ "label_name" => $f_label ]; 
		}
		if(!empty($inputType)){
			$dataArray += [ "input_type" => $inputType ]; 
		}
		if(!empty($f_featured)){
			$dataArray += [ "featured_type" => $f_featured ]; 
		}		
		if(!empty($f_value)){
			$dataArray += [ "label_value" => $f_value ]; 
		}
		if(!empty($f_is_custom)){
			$dataArray += [ "is_custom" => $f_is_custom ]; 
		}
		if(!empty($f_reference_type) && $f_reference_type != 'default'){
			$dataArray += [ "reference_type" => $f_reference_type ]; 
		}
		if(!empty($f_reference_format) && $f_reference_format != 'default'){
			$dataArray += ["reference_format" => $f_reference_format ]; 
		}
		if(!empty($f_has_child)){
			$dataArray += [ "has_child" => $f_has_child ]; 
		}
		if(!empty($f_is_weightage)){
			$dataArray += [ "is_weightage" => $f_is_weightage ]; 
		}
		if(!empty($f_parent_category)){
			$dataArray += [ "parent_id" => $f_parent_category ]; 
			$dataArray += [ "is_child" => 1 ]; 
		}
		if(!empty($f_child_category)){
			$dataArray += [ "sub_parent_id" => $f_child_category ];
		}
		
		$f_is_dropdown = 0;
		if($format_type == 'dropdown_select'){ $f_is_dropdown = 1; }
		$template_id = data_inserter('test_qa_design_template', $dataArray);
		
		//============================================
		//  FOR DROPDOWNS
		//=============================================
		if($format_type == 'dropdown_select')
		{
			$sl_active = 1;
			$select_options = $this->input->post('selectOption');
			$select_values = $this->input->post('selectValue');
			$selectOptionsArray = count($select_options);
			$selectValuesArray = count($select_values);
			$option_id = array();
			for($i=0; $i<$selectOptionsArray;$i++)
			{
				$currentOption = $select_options[$i];
				$currentValue = $select_values[$i];
				if($f_reference_type == 'default'){ $currentValue = d_space_trim($currentOption); }
				$option_array = [
					"sl_template_id" => $template_id,
					"sl_design_id" => $designID,
					"sl_option" => $currentOption,
					"sl_value" => $currentValue,
					"sl_type" => $f_reference_type,
					"sl_active" => $sl_active,
				];
				
				$option_id[] = data_inserter('test_qa_design_template_dropdowns', $option_array);
			}
			
			$option_ids = implode(',', $option_id);
			if($option_ids != ""){
				$updateArray = [
					"is_dropdown" => 1,
					"dropdown_ids" => $option_ids
				];
				$this->db->where('id', $template_id);
				$this->db->update('test_qa_design_template', $updateArray);				
			}
			
		}
		
		//============================================
		//  FOR PARAMETER SCORE
		//=============================================
		if($format_type == 'scorecard_param')
		{
			$sl_active = 1;
			$select_options = $this->input->post('selectOption');
			$select_values = $this->input->post('selectValue');
			$select_score = $this->input->post('selectScore');
			$selectOptionsArray = count($select_options);
			$selectValuesArray = count($select_values);
			$selectScoreArray = count($select_score);
			$option_id = array();
			for($i=0; $i<$selectOptionsArray;$i++)
			{
				$currentOption = $select_options[$i];
				$currentValue = $select_values[$i];
				$currentScore = $select_score[$i];
				if($f_reference_type == 'default'){ $currentValue = d_space_trim($currentOption); }
				$option_array = [
					"sl_template_id" => $template_id,
					"sl_design_id" => $designID,
					"sl_option" => $currentOption,
					"sl_score" => $currentScore,
					"sl_value" => $currentValue,
					"sl_type" => $f_reference_type,
					"sl_active" => $sl_active,
				];
				
				$option_id[] = data_inserter('test_qa_design_template_dropdowns', $option_array);
			}
			
			$option_ids = implode(',', $option_id);
			if($option_ids != ""){
				$updateArray = [
					"is_dropdown" => 1,
					"dropdown_ids" => $option_ids
				];
				$this->db->where('id', $template_id);
				$this->db->update('test_qa_design_template', $updateArray);				
			}
			
		}
		
		
		//==============================================
		//  FOR PARAMETER SCORE WEIGHTAGE CALCULATION
		//==============================================
		if($format_type == 'calculation_parameter_weightage')
		{
			$cal_type = "calculation_parameter_weightage";
			$sl_active = 1;
			$f_weightage_parameter = $this->input->post('f_weightage_parameter');
			$f_element_calculators = $this->input->post('f_element_calculators');
			$option_id = array();
			
			// DELETE PREVIOUS
			//$this->db->where('cal_template_id', $template_id);
			//$this->db->where('cal_design_id', $designID);
			//$this->db->delete('test_qa_design_template_calculations');
				
			$sl_pm_id = $this->input->post('sl_pm_id');
			$sl_pm_score = $this->input->post('sl_pm_score');
			$sl_pm_options = $this->input->post('sl_pm_options');
			$sl_pm_id_Array = count($sl_pm_id);
			$sl_pm_score_Array = count($sl_pm_score);
			$sl_pm_options_Array = count($sl_pm_options);
			for($i=0; $i<$sl_pm_id_Array;$i++)
			{
				$w_currentParam = $sl_pm_id[$i];
				$w_currentScore = $sl_pm_score[$i];
				$w_currentOptionsCheck = $sl_pm_options[$w_currentParam];
				$w_currentOptions = implode(',', $w_currentOptionsCheck);
				$option_array = [
					"cal_calculation_id" => $template_id,
					"cal_template_id" => $f_weightage_parameter,
					"cal_design_id" => $designID,
					"cal_parameter_id" => $w_currentParam,
					"cal_type" => $cal_type,
					"cal_options_score" => $w_currentScore,
					"cal_options_exclusion" => $w_currentOptions,
				];
				
				$option_id[] = data_inserter('test_qa_design_template_calculations', $option_array);
			}
			
			$option_ids = implode(',', $option_id);
			if($option_ids != ""){
				$updateArray = [
					"weightage_calculation" => 1,
					"weightage_calculation_ids" => $option_ids,
					"is_calculation" => 1
				];
				$this->db->where('id', $f_weightage_parameter);
				$this->db->update('test_qa_design_template', $updateArray);
				
				$updateArray += [ "weightage_parameter" => $f_weightage_parameter ];
				$this->db->where('id', $template_id);
				$this->db->update('test_qa_design_template', $updateArray);				
			}
			
		}
		
		
		//==============================================
		//  FOR OVERALL SCORE WEIGHTAGE CALCULATION
		//==============================================
		if($format_type == 'calculation_overall_weightage')
		{
			$cal_type = "calculation_overall_weightage";
			$sl_active = 1;
			$f_calculation_parameter = $this->input->post('f_calculation_parameter');
			$f_element_calculators = $this->input->post('f_element_calculators');
			$option_id = array();
			
			// DELETE PREVIOUS
			//$this->db->where('cal_template_id', $template_id);
			//$this->db->where('cal_design_id', $designID);
			//$this->db->delete('test_qa_design_template_calculations');
			
			if($f_calculation_parameter == 'parameter'){
				
			$sl_pm_id = $this->input->post('sl_pm_id');
			$sl_pm_score = $this->input->post('sl_pm_score');
			$sl_pm_options = $this->input->post('sl_pm_options');
			$sl_pm_id_Array = count($sl_pm_id);
			$sl_pm_score_Array = count($sl_pm_score);
			$sl_pm_options_Array = count($sl_pm_options);
			for($i=0; $i<$sl_pm_id_Array;$i++)
			{
				$w_currentParam = $sl_pm_id[$i];
				$w_currentScore = $sl_pm_score[$i];
				$w_currentOptionsCheck = $sl_pm_options[$w_currentParam];
				$w_currentOptions = implode(',', $w_currentOptionsCheck);
				$option_array = [
					"cal_calculation_id" => $template_id,
					"cal_template_id" => $template_id,
					"cal_design_id" => $designID,
					"cal_parameter_id" => $w_currentParam,
					"cal_type" => $cal_type,
					"cal_options_score" => $w_currentScore,
					"cal_options_exclusion" => $w_currentOptions,
				];
				
				$option_id[] = data_inserter('test_qa_design_template_calculations', $option_array);
			}
			
			$option_ids = implode(',', $option_id);
			if($option_ids != ""){
				$updateArray = [
					"weightage_calculation" => 1,
					"weightage_calculation_ids" => $option_ids,
					"calculation_type" => $f_calculation_parameter,
					"calculation_ids" => $option_ids,
					"is_calculation" => 1
				];
				$this->db->where('id', $template_id);
				$this->db->update('test_qa_design_template', $updateArray);			
			}
			
			}
			
			if($f_calculation_parameter == 'weightage'){
				$calculationIDs = implode(',', $f_element_calculators);
				$updateArray = [ 
					"is_calculation" => 1,
					"weightage_calculation" => 1,
					"weightage_calculation_ids" => $calculationIDs,
					"calculation_type" => $f_calculation_parameter,
					"calculation_ids" => $calculationIDs,
				];
				$this->db->where('id', $template_id);
				$this->db->update('test_qa_design_template', $updateArray);	
			}
			
		}
		
		$this->db->trans_complete();
		
		redirect($_SERVER['HTTP_REFERER']);
	}
	
	
	function test_qa_form_template_element_delete()
	{	
		$designID = $this->uri->segment(3);
		if(empty($designID)){ $designID = $this->input->get('did'); }
		
		$elementID = $this->uri->segment(4);
		if(empty($elementID)){ $elementID = $this->input->get('eid'); }
		
		$this->db->where('id', $elementID);
		$this->db->where('design_id', $designID);
		$this->db->delete('test_qa_design_template');
		
		$this->db->where('id', $elementID);
		$this->db->where('design_id', $designID);
		$this->db->delete('test_qa_design_template');
		
		$this->db->where('sl_template_id', $elementID);
		$this->db->where('sl_design_id', $designID);
		$this->db->delete('test_qa_design_template_dropdowns');
		
		$this->db->where('cal_calculation_id', $elementID);
		$this->db->where('cal_design_id', $designID);
		$this->db->delete('test_qa_design_template_calculations');
		
		redirect($_SERVER['HTTP_REFERER']);
	}
	
	
	function test_qa_form_template_element_position()
	{	
		$designID = $this->uri->segment(3);
		if(empty($designID)){ $designID = $this->input->get('did'); }
		
		$elementID = $this->uri->segment(4);
		if(empty($elementID)){ $elementID = $this->input->get('eid'); }
		
		$positionType = $this->uri->segment(5);
		if(empty($positionType)){ $positionType = $this->input->get('pid'); }
		
		$elementDetails = $this->Dynamic_QA->element_details($elementID, $designID);
		$elementType = $elementDetails['element_type'];
		$currentPosition = $elementDetails['overall_position'];
		$currentLinePosition = $elementDetails['line_position'];
		
		$gotPosition = d_element_position_status($elementType);		
		$positionNames = d_element_position_status($gotPosition, 'name');
		$searchNames = implode("','", explode(',', $positionNames));
		
		$updatePosition = $currentPosition; $updateColumn = "overall_position"; 
		if($gotPosition > 1){ $updatePosition = $currentLinePosition; $updateColumn = "line_position";  }
		
		// UPDATER FIX
		$sqlCount = "SELECT count(*) as value from test_qa_design_template WHERE design_id = '$designID' AND element_type IN ('$searchNames') ORDER by overall_position, line_position";
		$totalElements = $this->Common_model->get_single_value($sqlCount);
			
		if($positionType == 'up'){ $updatePosition--; }
		if($positionType == 'down'){ $updatePosition++; }
		//echo $updatePosition ."-" .$totalElements;
		if($updatePosition <= $totalElements && $updatePosition > 0)
		{
			echo "<br/>" .$updateColumn ."-" .$updatePosition ."-" .$elementDetails['label_name'] ."--<br/>";
			$dataUpdate = [ $updateColumn => $updatePosition ];
			$this->db->where('id', $elementID);
			$this->db->where('design_id', $designID);
			$this->db->update('test_qa_design_template', $dataUpdate);
		}
		
		$snPosition = 0;
		$sqlUpdate = "SELECT * from test_qa_design_template WHERE design_id = '$designID' AND element_type IN ('$searchNames') AND id NOT IN ($elementID) ORDER by overall_position, line_position";
		$queryUpdater = $this->Common_model->get_query_result_array($sqlUpdate);
		foreach($queryUpdater as $tokenUpdate)
		{
			$snPosition++;
			if($snPosition == $updatePosition){ $snPosition++; }
			//echo "<br>".$updateColumn ."-" .$snPosition ."-" .$tokenUpdate['label_name'];
			$dataUpdate = [ $updateColumn => $snPosition ];
			if($snPosition <= $totalElements && $snPosition > 0)
			{	
				$this->db->where('id', $tokenUpdate['id']);
				$this->db->where('design_id', $designID);
				$this->db->update('test_qa_design_template', $dataUpdate);
			}
		}
		
		redirect($_SERVER['HTTP_REFERER']);
	}
	
	
	function test_qa_form_template_update_position()
	{	
		$designID = $this->uri->segment(3);
		if(empty($designID)){ $designID = $this->input->get('did'); }
		
		echo $sqlUpdate = "SELECT * from test_qa_design_template WHERE design_id = '$designID'";
		$queryUpdate = $this->Common_model->get_query_result_array($sqlUpdate);
		$slPosition = 0; $positionArray = array(); $elementDetails = array();
		foreach($queryUpdate as $token)
		{	
			$detailsArray = array(
				"element_id" => $token['id'],
				"element_name" => $token['label_name'],
				"element_type" => $token['element_type'],
				"has_child" => $token['has_child'],
				"line_position" => $token['line_position'],
				"overall_position" => $token['overall_position'],
			);
			$d_eid = $token['id'];
			$d_etype = $token['element_type'];
			$elementPositionType = d_element_position_status($token['element_type']);
			$elementDetails[$d_eid] = $token;
			
			if($elementPositionType == 1)
			{
				$slPosition++;
				$positionArray['elements'][$d_eid]['info'] = $detailsArray;			
				$positionArray['navigation']['main'][$d_eid] = $detailsArray;			
			}
			
			if($elementPositionType == 3)
			{
				$parentID = $token['parent_id'];
				$positionArray['elements'][$parentID]['child'][$d_eid]['info'] = $detailsArray;
				$positionArray['navigation']['child'][$d_eid] = $detailsArray;
			}
			
			if($elementPositionType == 2)
			{
				$parentID = $token['parent_id'];
				$childID = $token['sub_parent_id'];
				if(!empty($childID)){
					$positionArray['elements'][$parentID]['child'][$childID]['parameters'][$d_eid]['info'] = $detailsArray;
					$positionArray['navigation']['parameters'][$d_eid] = $detailsArray;
				} else {
					$positionArray['elements'][$parentID]['parameters'][$d_eid]['info'] = $detailsArray;
					$positionArray['navigation']['parameters'][$d_eid] = $detailsArray;
				}				
			}
			
			if($elementPositionType == 4)
			{
				$weightage_parameter = $token['weightage_parameter'];
				$positionArray['weightage'][$weightage_parameter][$d_eid] = $detailsArray;
				$positionArray['navigation']['weightage'][$d_eid] = $detailsArray;				
			}
		}
		
		$sl = 0;
		$mainKeys = array_keys($positionArray['navigation']['main']);
		$childKeys = array_keys($positionArray['navigation']['child']);
		$parameterKeys = array_keys($positionArray['navigation']['parameters']);
		$weightageKeys = array_keys($positionArray['navigation']['weightage']);
		
		$sl = 0;
		foreach($mainKeys as $key)
		{
			$sl++;
			$dataCheck = [ "line_position" => 0 ];
			$dataCheck = [ "overall_position" => $sl ];
			$this->db->where('id', $key);
			$this->db->where('design_id', $designID);
			$this->db->update('test_qa_design_template', $dataCheck);
		}
		
		$sl = 0;
		foreach($childKeys as $key)
		{
			$sl++;
			$dataCheck = [ "line_position" => $sl ];
			$dataCheck = [ "overall_position" => 0 ];
			$this->db->where('id', $key);
			$this->db->where('design_id', $designID);
			$this->db->update('test_qa_design_template', $dataCheck);
		}
		
		$sl = 0;
		foreach($parameterKeys as $key)
		{
			$sl++;
			$dataCheck = [ "line_position" => $sl ];
			$dataCheck = [ "overall_position" => 0 ];
			$this->db->where('id', $key);
			$this->db->where('design_id', $designID);
			$this->db->update('test_qa_design_template', $dataCheck);
		}
		
		$sl = 0;
		foreach($weightageKeys as $key)
		{
			$sl++;
			$dataCheck = [ "line_position" => $sl ];
			$dataCheck = [ "overall_position" => 0 ];
			$this->db->where('id', $key);
			$this->db->where('design_id', $designID);
			$this->db->update('test_qa_design_template', $dataCheck);
		}
		
		d_printr($mainKeys, 0);
		d_printr($childKeys, 0);
		d_printr($parameterKeys, 0);
		d_printr($weightageKeys, 1);		
		
	}
	
	function test_qa_user_info()
	{
		$uid = $this->uri->segment(3);
		if(empty($uid)){ $uid = $this->input->get('uid'); }
		if(empty($uid)){ $uid = $this->input->post('uid'); }
				
		$userDetails = $this->Dynamic_QA->user_info($uid);		
		$result_array =  json_encode($userDetails);
		echo $result_array;
	}
	
	function test_qa_template_scorecard_parent()
	{
		$did = $this->uri->segment(3);
		if(empty($did)){ $did = $this->input->get('did'); }
		if(empty($did)){ $did = $this->input->post('did'); }
				
		$templateDetails = $this->Dynamic_QA->design_scorecard_parent_list($did);		
		$result_array =  json_encode($templateDetails);
		echo $result_array;
	}
	
	function test_qa_template_scorecard_parent_child()
	{
		$did = $this->uri->segment(3);
		$pid = $this->uri->segment(4);
		if(empty($did)){ $did = $this->input->get('did'); $pid = $this->input->get('pid'); }
		if(empty($did)){ $did = $this->input->post('did'); $pid = $this->input->post('pid'); }
				
		$templateDetails = $this->Dynamic_QA->design_scorecard_parent_child_list($did, $pid);		
		$result_array =  json_encode($templateDetails);
		echo $result_array;
	}
	
	function test_qa_template_scorecard_parameters()
	{
		$did = $this->input->post('did'); 
		$eType = $this->input->post('eType');
		$isWeightage = $this->input->post('isWeightage');
		$isCalculation = $this->input->post('isCalculation');
		$parentID = $this->input->post('parent_id');
		$childID = $this->input->post('child_id');
		
		//$did = 1; $eType = 'scorecard_param'; $parentID = '24'; $childID = '27';
		
		$extraFilter= "";
		if(!empty($isWeightage)){ $extraFilter .= " AND q.is_weightage = 1"; }		
		if(!empty($isCalculation)){ $extraFilter .= " AND q.is_calculation = 1"; }
		if(!empty($parentID)){ $extraFilter .= " AND q.parent_id = '$parentID'"; }
		if(!empty($childID)){ $extraFilter .= " AND q.sub_parent_id = '$childID'"; }
		
		$templateDetails = $this->Dynamic_QA->design_scorecard_custom_list($did, $eType, $extraFilter);		
		$result_array =  json_encode($templateDetails);
		echo $result_array;
	}
	
	function test_qa_template_scorecard_parameter_options()
	{
		$did = $this->input->post('did'); 
		$tid = $this->input->post('tid');
		$templateDetails = $this->Dynamic_QA->element_parameter_dropdown_options($did, $tid);	
		$data['templates'] = $templateDetails;
		$this->load->view('employee_id/elements/ajax/cal_parameter_weightage_row', $data);
		
		//$result_array =  json_encode($templateDetails['data']);
		//echo $result_array;
	}

}