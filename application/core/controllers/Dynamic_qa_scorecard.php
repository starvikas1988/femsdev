<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dynamic_qa_scorecard extends CI_Controller {
		
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
		redirect(base_url()."dynamic_qa_scorecard/scorecard");	 
	}
	
	//========================= SCORECARD LIST ===========================================================//
	
	public function scorecard()
	{
		$currentUser = d_login_user_id();
		
		// DROPDOWNS
		$officeList = $this->Dynamic_QA->office_list();
		$clientList = $this->Dynamic_QA->client_list();
		$processList = array();
		$data['officeList'] = $officeList;
		$data['clientList'] = $clientList;
		$data['processList'] = $processList;
		
		//SEARCH FILTER
		$extraFilter = "";
		$searchClient = "";
		if(!empty($this->input->get('client_id')) && $this->input->get('client_id') != "ALL"){
			$searchClient = $this->input->get('client_id');
			$extraFilter  .= " AND d.client_id = '$searchClient'";
		}
		$searchProcess = "";
		if(!empty($this->input->get('process_id')) && $this->input->get('client_id') != "ALL"){
			$searchProcess = $this->input->get('process_id');
			$extraFilter  .= " AND d.process_id = '$searchProcess'";
		}
		$searchOffice = "";
		if(!empty($this->input->get('office_id')) && $this->input->get('client_id') != "ALL"){
			$searchOffice = $this->input->get('office_id');
			$extraFilter  .= " AND d.office_id = '$searchOffice'";
		}
		$searchCampaign = "";
		if(!empty($this->input->get('campaign_id')) && $this->input->get('client_id') != "ALL"){
			$searchCampaign = $this->input->get('campaign_id');
			$extraFilter  .= " AND d.campaign_id = '$searchCampaign'";
		}
		$searchKeyword = "";
		if(!empty($this->input->get('keyword'))){
			$searchKeyword = $this->input->get('keyword');
			$extraFilter  .= " AND d.name LIKE '%$searchKeyword%'";
		}
		
		$data['searchClient'] = $searchClient;
		$data['searchProcess'] = $searchProcess;
		$data['searchOffice'] = $searchOffice;
		$data['searchCampaign'] = $searchCampaign;
		$data['searchKeyword'] = $searchKeyword;
		$data['designList'] = $this->Dynamic_QA->scorecard_design_list($extraFilter);
		
		$data["aside_template"] = "dynamic_qa_scorecard/scorecard_aside.php";
		$data["content_template"] = "dynamic_qa_scorecard/scorecard_list.php";
		$data["content_js"] = "dynamic_qa_scorecard/scorecard_js.php";
		//echo "<pre>";
		//print_r($data);
		//echo "</pre>";
		//die;
		$this->load->view('dashboard',$data);		
	}
	
	
	//========================= SCORECARD MASTER ===========================================================//
	
	public function design()
	{
		$currentUser = d_login_user_id();
		
		// DROPDOWNS
		$officeList = $this->Dynamic_QA->office_list();
		$clientList = $this->Dynamic_QA->client_list();
		$processList = array();
		$data['officeList'] = $officeList;
		$data['clientList'] = $clientList;
		$data['processList'] = $processList;
		
		$data["aside_template"] = "dynamic_qa_scorecard/scorecard_aside.php";
		$data["content_template"] = "dynamic_qa_scorecard/add_scorecard_design.php";
		$data["content_js"] = "dynamic_qa_scorecard/scorecard_js.php";
		
		$this->load->view('dashboard',$data);		
	}
	
	
	public function campaign()
	{		
		$currentUser = d_login_user_id();
		
		// DROPDOWNS
		$clientList = $this->Dynamic_QA->client_list();
		$processList = array();
		$data['clientList'] = $clientList;
		$data['processList'] = $processList;
		
		//SEARCH FILTER
		$searchClient = "";
		if(!empty($this->input->get('client_id'))){
			$searchClient = $this->input->get('client_id');
		}
		$searchProcess = "";
		if(!empty($this->input->get('process_id'))){
			$searchProcess = $this->input->get('process_id');
		}
		$data['campaignList'] = $this->Dynamic_QA->scorecard_campaign_list($searchClient, $searchProcess);
		
		$data["aside_template"] = "dynamic_qa_scorecard/scorecard_aside.php";
		$data["content_template"] = "dynamic_qa_scorecard/master_campaign.php";
		$data["content_js"] = "dynamic_qa_scorecard/scorecard_js.php";
		
		$this->load->view('dashboard',$data);		
	}
	
	public function addCampaignData()
	{				
		$campaign_name = $this->input->post('campaign_name');
		$process_id = $this->input->post('process_id');
		$client_id = $this->input->post('client_id');
		
		$dataSet = [
			"campaign_name" => $campaign_name,
			"process_id" => $process_id,
			"client_id" => $client_id,
			"added_by" => d_login_user_id(),
			"date_added" => d_current_date_time(),
			"date_modified" => d_current_date_time(),
			"is_active" => 1,
		];
		data_inserter('test_qa_campaign', $dataSet);
		redirect($_SERVER['HTTP_REFERER'] .'/success');
	}
	
	public function deleteCampaignData()
	{				
		$id = $this->input->get('did');		
		$dataSet = [
			"is_active" => 0,
		];
		$this->db->where('id', $id);
		$this->db->update('test_qa_campaign', $dataSet);
		redirect($_SERVER['HTTP_REFERER'] .'/deleted');
	}
	
	
	public function addCampaignDesignData()
	{				
		$scorecard_name = $this->input->post('scorecard_name');
		$scorecard_description = $this->input->post('scorecard_description');
		$process_id = $this->input->post('process_id');
		$client_id = $this->input->post('client_id');
		$office_id = $this->input->post('office_id');
		$campaign_id = $this->input->post('campaign_id');
		
		$dataSet = [
			"name" => $scorecard_name,
			"description" => $scorecard_description,
			"office_id" => $office_id,
			"campaign_id" => $campaign_id,
			"process_id" => $process_id,
			"client_id" => $client_id,
			"added_by" => d_login_user_id(),
			"date_added" => d_current_date_time(),
			"date_modified" => d_current_date_time(),
			"is_active" => 1,
		];
		data_inserter('test_qa_design', $dataSet);
		redirect($_SERVER['HTTP_REFERER'] .'/success');
	}
	
	public function deleteCampaignDesignData()
	{				
		$id = $this->input->get('did');		
		$dataSet = [
			"is_active" => 0,
		];
		$this->db->where('id', $id);
		$this->db->update('test_qa_design', $dataSet);
		redirect($_SERVER['HTTP_REFERER'] .'/deleted');
	}
	
	
	
	//========================= SCORECARD MASTER ===========================================================//
	
	public function scorecard_generate_modal_db()
	{				
		$currentUser = d_login_user_id();		
		$designID = $this->uri->segment(3);
		if(empty($designID)){ $designID = $this->input->get('did'); }
		if(empty($designID)){ $designID = $this->input->post('did'); }
		
		// DEISGN DETAILS
		$sqlDesign = "SELECT * from test_qa_design WHERE id = '$designID'";
		$designDetails = $this->Common_model->get_query_row_array($sqlDesign);
		
		$attributesList = $this->Dynamic_QA->scorecard_attributes_list();
		$designList = $this->Dynamic_QA->element_list($designID);
		
		$parameterArray = array_filter($designList, function($n){
			if($n['element_type'] == 'scorecard_param'){ return $n; }
		});
		$data['designID'] = $designID;
		$data['designDetails'] = $designDetails;
		$data['parameterList'] = $parameterArray;
		$data['attributesList'] = $attributesList;
		$data['designList'] = $designList;
		$this->load->view('dynamic_qa_scorecard/ajax/modal_generate_db', $data);
		
	}
	
	
	public function scorecard_generate_db_structure()
	{
		//d_printr($_POST, 1);
		
		// POST PARAMETERS
		$designID = $this->input->post('design_id');
		$attribute_ids = $this->input->post('c_attribute');
		$attribute_labels = $this->input->post('c_attribute_label');
		$attributesList = $this->Dynamic_QA->scorecard_attributes_list('', 0);
		$attributeArray = d_array_indexed($attributesList, 'id');
		
		// DEISGN DETAILS
		$sqlDesign = "SELECT * from test_qa_design WHERE id = '$designID'";
		$designDetails = $this->Common_model->get_query_row_array($sqlDesign);
		
		// ALTER TEMPLATE DESIGN TABLE
		$updateArray = array();
		$indexSQL = array(); $starter_column = "description";
		$g_attribute_ids = implode(',', $attribute_ids);		
		foreach($attribute_ids as $token)
		{
			$attributeDetails = $attributeArray[$token];
			$attributeColumn = $attributeDetails['column_name'];			
			if(!array_key_exists($attributeColumn, $designDetails)){
				$limit = "";
				$attributeType = $attributeDetails['column_type'];
				$attributeType = $attributeDetails['column_type'];
				if($attributeType == 'varchar'){ $limit = "(300)"; }
				$attributeCheckType = "varchar"; $attributelimit = "(300)";
				$indexSQL[] = "ADD ".$attributeColumn." " .$attributeCheckType .$attributelimit ." NULL AFTER ".$starter_column;						
			}
			
			$starter_column = $attributeColumn;	
			$updateArray += [ $attributeColumn => $attribute_labels[$token] ];
		}
		
		$table_name = "test_qa_design";
		$sqlTable = "ALTER TABLE " .$table_name ." ".implode(',', $indexSQL);
		$queryTable = $this->db->query($sqlTable);
		
		$updateArray += [ "attribute_ids" => $g_attribute_ids ];
		$this->db->where('id', $designID);
		$this->db->update('test_qa_design', $updateArray);
		
		// GENERATE TABLE
		$this->scorecard_generate_db($designID, $attribute_ids, $attributeArray);
		
		redirect($_SERVER['HTTP_REFERER']);
		
	}
	
	
	public function scorecard_generate_db($designID = '', $attribute_ids = '', $attributeArray = NULL)
	{		
		$currentUser = d_login_user_id();		
		if(empty($designID)){
			$designID = $this->uri->segment(3);
			if(empty($designID)){ $designID = $this->input->get('did'); }
			if(empty($designID)){ $designID = $this->input->post('did'); }
		}
		
		$sqlTemplate = "SELECT * from test_qa_design_template WHERE design_id = '$designID' ORDER by overall_position, line_position";
		$templateDetails = $this->Common_model->get_query_result_array($sqlTemplate);
		
		$table_name = "test_qa_scorecard_" .$designID;
		
		// BACKUP TABLE IF EXIST
		$currentDB = $this->db->database;
		$sqlCheckc = "SELECT count(*) as value FROM information_schema.TABLES WHERE TABLE_SCHEMA = '$currentDB' AND TABLE_NAME = '$table_name'";
		$queryCheckc = $this->Common_model->get_single_value($sqlCheckc);
		if($queryCheckc > 0){		
			$backupTable = $table_name ."_backup_".strtotime("now");
			$sqlDelete = "RENAME TABLE " .$table_name ." TO ". $backupTable;
			$queryDelete = $this->db->query($sqlDelete);
		}
		
		// GET COLUMN NAMES
		$columns = array(); $createTable = array(); $parameterColumns = array();
		foreach($templateDetails as $tokenArray)
		{
			$element_id = $tokenArray['id'];
			$element_column_name = "f_label_" .$tokenArray['id'];
			$element_column_type = d_element_db_table($tokenArray['element_type']);			
			
			if(!empty($element_column_type)){
				$columnName = $element_column_name;
				$columnType = $element_column_type['type'];
				$columnLimit = $element_column_type['limit'];
				if($element_column_type['is_reference'] == 1)
				{
					if($tokenArray['reference_type'] == 'datepicker')
					{
						$columnType = 'date';
					}
					if($tokenArray['reference_type'] == 'datetimepicker')
					{
						$columnType = 'datetime';
					}
					if($tokenArray['reference_type'] == 'timepicker')
					{
						$columnType = 'time';
					}
				}
				
				$columns[] = array(
					"name" => $columnName,
					"type" => $columnType,
					"limit" => $columnLimit,
				);
				$addLimit = "";
				if(!empty($columnLimit)){ $addLimit = "(".$columnLimit.")"; }
				$createTable[] = $columnName ." " .$columnType .$addLimit ." DEFAULT NULL";			
			}
			if($tokenArray['element_type'] == 'scorecard_param'){ $parameterColumns[] = $element_column_name; }			
		}
		
		// CREATE TABLE
		$mainTable = "CREATE TABLE " .$table_name ." (
						id bigint(200) NOT NULL,
						design_id int(11) NOT NULL,
						agent_id bigint(200) NOT NULL,
						date_added datetime NOT NULL,
						date_modifed datetime NOT NULL,
						added_by bigint(200) NOT NULL,
						is_active int(1) DEFAULT '1',
						".implode(',', $createTable)."
					 ) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
		$queryTable = $this->db->query($mainTable);
		
		// ADD INDEXES TABLE
		$indexSQL = array();
		$indexColumns = array('design_id', 'agent_id', 'added_by', 'date_added');
		foreach($indexColumns as $token)
		{
			$indexSQL[] = "ADD INDEX " .$token ."_index (" .$token.")";
		}
		
		$sqlTable = "ALTER TABLE " .$table_name ." ADD PRIMARY KEY (id), ".implode(',', $indexSQL);
		$queryTable = $this->db->query($sqlTable);
		
		$sqlTable = "ALTER TABLE " .$table_name ." MODIFY id bigint(200) UNSIGNED NOT NULL AUTO_INCREMENT";
		$queryTable = $this->db->query($sqlTable);
		
		// UPDATE ATTRIBUTE COLUMNS AND INDEXING
		if(!empty($attributeArray) && !empty($attribute_ids))
		{
			// ALTER TEMPLATE DESIGN TABLE
			$indexSQL = array(); $alterSQL = array(); $starter_column = "agent_id";
			$g_attribute_ids = implode(',', $attribute_ids);		
			foreach($attribute_ids as $token)
			{
				$attributeDetails = $attributeArray[$token];
				$attributeColumn = $attributeDetails['column_name'];
				$limit = "";
				$attributeType = $attributeDetails['column_type'];
				$attributeType = $attributeDetails['column_type'];
				if($attributeType == 'varchar'){ $limit = "(300)"; }
				$alterSQL[] = "ADD ".$attributeColumn." " .$attributeType .$limit ." NULL AFTER ".$starter_column;			
				$indexSQL[] = "ADD INDEX " .$attributeColumn ."_index (" .$attributeColumn.")";
				$starter_column = $attributeColumn;
			}
			if(!empty($alterSQL)){
			$sqlTable = "ALTER TABLE " .$table_name ." ".implode(',', $alterSQL);
			$queryTable = $this->db->query($sqlTable);
			}
			
			if(!empty($indexSQL)){
			$sqlTable = "ALTER TABLE " .$table_name ." " .implode(',', $indexSQL);
			$queryTable = $this->db->query($sqlTable);
			}
		}
		
		$parameterColumnsNames = implode(',', $parameterColumns);
		$updateArray = [ "design_table" => $table_name, "parameter_columns" => $parameterColumnsNames ];
		$this->db->where('id', $designID);
		$this->db->update('test_qa_design', $updateArray);
		
	}
	
	
	
	//========================= SCORECARD ATTRIBUTES ===========================================================//
	
	public function attributes()
	{
		$currentUser = d_login_user_id();
		
		// DROPDOWNS
		$attributesList = $this->Dynamic_QA->scorecard_attributes_list();
		$data['attributesList'] = $attributesList;
		
		$data["aside_template"] = "dynamic_qa_scorecard/scorecard_aside.php";
		$data["content_template"] = "dynamic_qa_scorecard/master_attributes.php";
		$data["content_js"] = "dynamic_qa_scorecard/scorecard_js.php";
		
		$this->load->view('dashboard',$data);		
	}
	
	public function addAttributes()
	{
		$currentUser = d_login_user_id();
		
		$attribute_name = $this->input->post('attribute_name');
		$column_name = $this->input->post('column_name');
		$column_type = $this->input->post('column_type');
		$data = [
			"name" => $attribute_name,
			"column_name" => $column_name,
			"column_type" => d_space_trim($column_type),
		];
		data_inserter('test_qa_design_attributes', $data);
		redirect($_SERVER['HTTP_REFERER']);		
	}
	
	public function deleteAttributes()
	{				
		$id = $this->input->get('did');		
		$dataSet = [
			"is_active" => 0,
		];
		$this->db->where('id', $id);
		$this->db->update('test_qa_design_attributes', $dataSet);
		redirect($_SERVER['HTTP_REFERER'] .'/deleted');
	}
	
	
	//========================= SCORECARD FEEDBACK ===========================================================//
	
	public function feedback()
	{
		$currentUser = d_login_user_id();
		$designID = $this->uri->segment(3);
		if(empty($designID)){ $designID = $this->input->get('did'); }
		if(empty($designID)){ $designID = $this->input->post('did'); }
		
		// INITIALIZE INFO
		$designDetails = $this->Dynamic_QA->scorecard_design_details($designID);
		$data['designDetails'] = $designDetails;
		
		$attributesList = $this->Dynamic_QA->scorecard_attributes_list();
		$data['attributesList'] = $attributesListIndexed = d_array_indexed($attributesList, 'id');
		
		// FILTER ATTRIBUTE
		$dateColumn = "date_added";
		$attributeArray = explode(',', $designDetails['attribute_ids']);
		foreach($attributeArray as $tokenAttr){
			if($tokenAttr['column_name'] == 'audit_date'){
				$dateColumn = "audit_date";
			}
		}
		
		//==== SET DATA =====//
		$todayStartDate = date('Y-m-01', strtotime(CurrDate()))." 00:00:00"; 
		$todayEndDate = CurrDate()." 23:59:59";		
		if(!empty($this->input->get('start_date')))
		{ 
			$todayStartDate = date('Y-m-d',strtotime($this->input->get('start_date'))) ." 00:00:00";
			$todayEndDate = date('Y-m-d',strtotime($this->input->get('end_date'))) ." 23:59:59";			
		}
		$data['from_date'] = date('Y-m-d',strtotime($todayStartDate));
		$data['to_date'] = date('Y-m-d',strtotime($todayEndDate));
		
		//=== FILTER DATA =======//
		$extraFilter = "";
		$extraFilter .= " AND (d.$dateColumn >= '$todayStartDate' AND d.$dateColumn <= '$todayEndDate') ";
		
		//=== SEARCH RECORDS =======//
		$tableName = $designDetails['design_table'];
		$designDataSql = "SELECT d.*, CONCAT(s.fname, ' ', s.lname) as fullName, s.office_id , s.fusion_id from $tableName as d 
						  LEFT JOIN signin as s ON s.id = d.agent_id
						  WHERE 1 $extraFilter";
		$feedbackList = $this->Common_model->get_query_result_array($designDataSql);
		$data['feedbackList'] = $feedbackList;
		
		$data["aside_template"] = "dynamic_qa_scorecard/scorecard_aside.php";
		$data["content_template"] = "dynamic_qa_scorecard/scorecard_feedback_list.php";
		$data["content_js"] = "dynamic_qa_scorecard/scorecard_list_js.php";
		
		$this->load->view('dashboard',$data);		
	}
	
	
	function new_feedback()
	{	
		$designID = $this->uri->segment(3);
		$showType = "";
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
		
		$data["aside_template"] = "dynamic_qa_scorecard/scorecard_aside.php";
		$data["content_template"] = "dynamic_qa_scorecard/scorecard_feedback_add.php";
		$data["content_js"] = "dynamic_qa_scorecard/scorecard_feedback_js.php";
		
		$this->load->view('dashboard',$data);	
	}
	
	function store_feedback()
	{	
		$designID = $this->input->post('design_id');
		if(empty($designID)){ show_error('Sorry! Design ID Missing'); }
		
		$data['designID'] = $designID;
		
		// INITIALIZE INFO
		$designDetails = $this->Dynamic_QA->scorecard_design_details($designID);
		$data['designDetails'] = $designDetails;
		
		$attributesList = $this->Dynamic_QA->scorecard_attributes_list();
		$data['attributesList'] = $attributesListIndexed = d_array_indexed($attributesList, 'id');
		
		$elementsList = $this->Dynamic_QA->element_list($designID);
		$data['elementsList'] = $elementListIndexed = d_array_indexed($elementsList, 'id');
		
		
		// POST DATA
		$dataUpdate = array();
		$postArray = $this->input->post();
		foreach($postArray as $key=>$val)
		{
			$currElement = explode('_', $key);
			if(!empty($currElement) && count($currElement) == 3){
				$currID = $currElement[2];
				if($currElement[0] == 'f' && $currElement[1] == 'label'){					
					$elementDetails = $elementListIndexed[$currID];
					$dataUpdate += [ $key => d_element_db_format_check($val, $elementDetails['element_type'], $elementDetails['reference_type']) ];
				}
			}						
		}		
		
		// INITIALIZE
		$dataUpdate += [ "design_id" => $designID ];
		$dataUpdate += [ "agent_id" => d_login_user_id() ];	
		$dataUpdate += [ "added_by" => d_login_user_id() ];
		$dataUpdate += [ "date_added" => d_current_date_time() ];
		$dataUpdate += [ "date_modifed" => d_current_date_time() ];
		$dataUpdate += [ "is_active" => 1 ];
		
		// FILTER ATTRIBUTE
		$columnNames = "";
		$attributeArray = explode(',', $designDetails['attribute_ids']);
		foreach($attributeArray as $tokenAttr){
			$colName = $attributesListIndexed[$tokenAttr]['column_name'];
			$colType = $attributesListIndexed[$tokenAttr]['column_type'];
			$postData = $this->input->post($designDetails[$colName]);
			if($colType == 'date'){ $postData = date('Y-m-d', strtotime($postData)); }
			$dataUpdate += [ $colName => $postData ];
		}
		
		$insertID = "";
		$tableName = $designDetails['design_table'];
		if(!empty($tableName)){
			$insertID = data_inserter($tableName, $dataUpdate);
		}
		
		if(!empty($insertID)){
			redirect($_SERVER['HTTP_REFERER']);
		}
		
	}
	
	
	
	//========================= MASTER ===========================================================//
	
	public function get_process(){				
		
		$currentUser = d_login_user_id();		
		$clientID = $this->uri->segment(3);
		if(empty($clientID)){ $clientID = $this->input->get('cid'); }
		if(empty($clientID)){ $clientID = $this->input->post('cid'); }
		
		$processList = $this->Dynamic_QA->process_list($clientID);
		$data['processList'] = $processList;
		
		echo json_encode($processList);
	}
	
	
	public function get_client(){				
		
		$currentUser = d_login_user_id();
		$clientList = $this->Dynamic_QA->client_list();
		$data['clientList'] = $clientList;		
		echo json_encode($processList);
	}
	
	public function get_campaign(){				
		
		$currentUser = d_login_user_id();
		$clientID = $this->uri->segment(3);
		if(empty($clientID)){ $clientID = $this->input->get('cid'); }
		if(empty($clientID)){ $clientID = $this->input->post('cid'); }
		
		$processID = $this->uri->segment(4);
		if(empty($processID)){ $processID = $this->input->get('pid'); }
		if(empty($processID)){ $processID = $this->input->post('pid'); }
		
		$campaignList = $this->Dynamic_QA->scorecard_campaign_list($clientID, $processID);
		$data['campaignList'] = $campaignList;		
		echo json_encode($campaignList);
	}
}

?>