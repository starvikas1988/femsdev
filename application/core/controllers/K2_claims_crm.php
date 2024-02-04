<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class K2_claims_crm extends CI_Controller {
	
	
	function __construct() {
		parent::__construct();
		error_reporting(E_ERROR | E_WARNING | E_PARSE);
		$this->load->model('user_model');
		$this->load->model('Common_model');	
		$this->load->library('excel');
		$this->load->model('Email_model');
		$this->objPHPExcel = new PHPExcel();		
	}
	
	
	
//==========================================================================================
///=========================== K2 CRM  ================================///

    public function index(){		 		
		redirect(base_url()."k2_claims_crm/dashboard");	 
	}
	
	//=================================== CONFIGURE EMAIL =============================================//
	
	public function k2_email_set($type = 1)
	{
		
		// ALL Claims go to below 
		$resultEmail[1] = array( "claimsq@aegisfirst.com" );
		
		// Supervisors 
		$resultEmail[2] = array( "mhayes@aegisfirst.com", "7175146284@vtext.com", "dsayers@aegisfirst.com", "7178056066@txt.att.net", "lcastellaneta@aegisfirst.com", "3303097440@vtext.com" );
		
		// Liability & Auto 
		$resultEmail[3] = array( "dcarlson@k2insclaims.com", "7605220905@txt.att.net" );
		
		$resultEmail[4] = array( "lcastellaneta@aegisfirst.com", "3303097440@vtext.com" );
		$resultEmail[5] = array( "mhayes@aegisfirst.com", "7175146284@vtext.com", "dsayers@aegisfirst.com", "7178056066@txt.att.net" );
		
		/*
		$resultEmail[1] = array( "sachin.paswan@fusionbposervices.com" );
		$resultEmail[2] = array( "sachin.paswan@omindtech.com" ,"sachin.paswan@fusionbposervices.com" );
		$resultEmail[3] = array( "sachin.paswan@omindtech.com", "sachinkrpaswan17@gmail.com" );
		$resultEmail[4] = array( "sachin.paswan@omindtech.com", "sachinkrpaswan17@gmail.com" );
		$resultEmail[5] = array( "sachin.paswan@omindtech.com", "sachinkrpaswan17@gmail.com" );
		*/
		
		return $resultEmail[$type];
	}
	
	
	//=================================== CRM OVERVIEW =============================================//
	
	public function overview()
	{
		$is_global_access=get_global_access();
		$role_id        = get_role_id();
		$current_user   = get_user_id();
		$role_dir       = get_role_dir();			
		$user_office_id = get_user_office_id();
		$ses_dept_id    = get_dept_id();	
		
		$get_client_id  = get_client_ids(); 
		$get_process_id = get_process_ids(); 
		$get_user_site_id = get_user_site_id();
			
		$extraFilter = ""; $extraTotal = "";
		$todayStartDate = date('Y-m-01', strtotime(CurrDate()))." 00:00:00"; 
		$todayEndDate = CurrDate()." 23:59:59";
		
		if(!empty($this->input->get('start')))
		{ 
			$todayStartDate = date('Y-m-d',strtotime($this->input->get('start'))) ." 00:00:00";
			$todayEndDate = date('Y-m-d',strtotime($this->input->get('end'))) ." 23:59:59";			
		}		
		
		if($role_dir == "agent" && get_login_type != 'client')
		{
			//$extraFilter .= " AND (c.added_by = '$current_user') ";
			//$extraTotal .= " AND (c.added_by = '$current_user') ";
		}
		
		$extraFilter .= " AND (c.created_at >= '$todayStartDate' AND c.created_at <= '$todayEndDate') ";
		
		$data['from_date'] = date('Y-m-d',strtotime($todayStartDate));
		$data['to_date'] = date('Y-m-d',strtotime($todayEndDate));
		
		// TABLES
		$data['tableArray'] = $tableArray = array(			
			"0" => array( "name" => "New Loss California Property", "table" => "k2_claims_crm_cps" ),        
			"1" => array( "name" => "New Loss No California Property", "table" => "k2_claims_crm_ncps" ),
			"2" => array( "name" => "New Loss Liability", "table" => "k2_claims_crm_als" ),
			"3" => array( "name" => "New Loss Auto-Motorcycle", "table" => "k2_claims_crm_aas" ),
			"4" => array( "name" => "Calling About Existing Claim", "table" => "k2_claims_crm_caef" ),
			"5" => array( "name" => "Other Issue", "table" => "k2_claims_crm_oi" ),      
		);
		$data['tableNames'] = $tableNames = array_column($tableArray, 'table');
		$data['formNames'] = $formNames = array_column($tableArray, 'name');
		
		$total_records = 0;
		$todays_records = 0;
		foreach($tableArray as $token)
		{
			$tableName = $token['table'];
			$formName = $token['name'];
			$sql = "SELECT count(*) as value from $tableName as c WHERE 1 AND c.is_active = 1 $extraTotal";
			$data['total'][$tableName] = $total = $this->Common_model->get_single_value($sql);
			
			$sql = "SELECT count(*) as value from $tableName as c WHERE 1 AND c.is_active = 1 $extraFilter";
			$data['today'][$tableName] = $today = $this->Common_model->get_single_value($sql);
						
			$total_records = $total_records + $total;
			$todays_records = $todays_records + $today;
			
		}
		
		$data['total_records'] = $total_records;
		$data['todays_records'] = $todays_records;
		
		$data['randomColors'] = array("#FAEBD7", "#FF7F50","#9ACD32", "#008000", "#FFA500", "#7B68EE", "#BC8F8F", "#FFF0F5", "#FF1493", "#CD853F", "#87CEEB", "#40E0D0", "#DB7093");
		$data['randomColors'] = array("#B23418", "#57B218", "#1BB87A", "#1DB4BB", "#0F7F85", "#CC1212", "#B95D32", "#55A03E", "#A2764B", "#B51183", "#7311B7", "#9D5E5F", "#2AB10F" );
		
		$data["aside_template"] = "k2_claims_crm/aside.php";
		$data["content_template"] = "k2_claims_crm/k2_claims_crm_overview.php";				
		$data["content_js"] = "k2_claims_crm/k2_claims_overview_js.php";				
		
		$this->load->view('dashboard',$data);
	}
	
	
	
	//=================================== CRM DASHBOARD SELECTION =============================================//
	
	public function dashboard()
	{
		$is_global_access=get_global_access();
		$role_id        = get_role_id();
		$current_user   = get_user_id();
		$role_dir       = get_role_dir();			
		$user_office_id = get_user_office_id();
		$ses_dept_id    = get_dept_id();	
		
		$get_client_id  = get_client_ids(); 
		$get_process_id = get_process_ids(); 
		$get_user_site_id = get_user_site_id();
		
		$dropdownOptions = $this->dropdowns_relationship();
		$data["dropdown_relation"] = $dropdownOptions;		
		$data["catastropheList"] = $this->dropdown_catastrophe_master();
		
		$data["draftID"] = "DR".strtotime("now").mt_rand(111,999);
		
		// TABLES
		$data['tableArray'] = $tableArray = array(			
			"0" => array( "name" => "New Loss California Property", "table" => "k2_claims_crm_cps" ),        
			"1" => array( "name" => "New Loss No California Property", "table" => "k2_claims_crm_ncps" ),
			"2" => array( "name" => "New Loss Liability", "table" => "k2_claims_crm_als" ),
			"3" => array( "name" => "New Loss Auto-Motorcycle", "table" => "k2_claims_crm_aas" ),
			"4" => array( "name" => "Calling About Existing Claim", "table" => "k2_claims_crm_caef" ),
			"5" => array( "name" => "Other Issue", "table" => "k2_claims_crm_oi" ),      
		);
		
		// LATEST DATA
		$latestData = array();
		$extraTotal = " AND c.added_by = '$current_user'";
		$agentArray['overall'] = array();
		$checkDateAdded = "2000-01-01 00:00:00";
		foreach($tableArray as $token)
		{
			$tableName = $token['table'];
			$formName = $token['name'];
			$caller_name = "";
			if($tableName == 'k2_claims_crm_cps'){ $caller_name = ",CONCAT(c.first_name, ' ', c.last_name) as caller_name"; }
			if($tableName == 'k2_claims_crm_ncps'){ $caller_name = ",CONCAT(c.first_name, ' ', c.last_name) as caller_name"; }
			if($tableName == 'k2_claims_crm_als'){ $caller_name = ",CONCAT(c.first_name, ' ', c.last_name) as caller_name"; }
			if($tableName == 'k2_claims_crm_aas'){ $caller_name = ",CONCAT(c.first_name, ' ', c.last_name) as caller_name"; }
			if($tableName == 'k2_claims_crm_caef'){ $caller_name = ",c.callername as caller_name"; }
			if($tableName == 'k2_claims_crm_oi'){ $caller_name = ",c.callername as caller_name"; }
			$sql = "SELECT CONCAT(s.fname, ' ', s.lname) as agent_name, s.fusion_id, c.* $caller_name from $tableName as c INNER JOIN signin as s ON s.id = c.added_by WHERE 1 AND c.is_active = 1 $extraTotal ORDER by c.id DESC LIMIT 1";
			$listquery = $this->Common_model->get_query_row_array($sql);
			if(!empty($listquery['id'])){			
			$currentDateAdded = $listquery['created_at'];
			if(strtotime($currentDateAdded) >= strtotime($checkDateAdded)){
				$latestData['name'] = $formName;
				$latestData['data'] = $listquery;				
				$checkDateAdded = $listquery['created_at'];
			}
			}
		}
		$data["latestData"] = $latestData;
		
		$data["aside_template"] = "k2_claims_crm/aside.php";
		$data["content_template"] = "k2_claims_crm/k2_claims_crm_dashboard.php";				
		$data["content_js"] = "k2_claims_crm/k2_claims_crm_js.php";				
		
		$this->load->view('dashboard',$data);
	}
	
	
	//===== CATASTROPHE MASTER =============================//
	
	public function catastrophe_master()
	{
		$is_global_access=get_global_access();
		$role_id        = get_role_id();
		$current_user   = get_user_id();
		$role_dir       = get_role_dir();			
		$user_office_id = get_user_office_id();
		$ses_dept_id    = get_dept_id();	
		
		$get_client_id  = get_client_ids(); 
		$get_process_id = get_process_ids(); 
		$get_user_site_id = get_user_site_id();
		
		$data["dropdown_relation"] = $this->dropdown_catastrophe_master();
		
		$data["aside_template"] = "k2_claims_crm/aside.php";
		$data["content_template"] = "k2_claims_crm/k2_claims_crm_catastrophe_master.php";				
		$data["content_js"] = "k2_claims_crm/k2_claims_list_js.php";				
		
		$this->load->view('dashboard',$data);
	}
	
	public function dropdown_catastrophe_master()
	{
		$dropdownOptions = "SELECT * from k2_claims_crm_catastrophe WHERE is_active = '1'";
		$resultArray = $this->Common_model->get_query_result_array($dropdownOptions);
		return $resultArray;
	}
	
	public function submit_catastrophe_master()
	{
		$id= $this->input->post('catastrophe_id');
		$code= $this->input->post('catastrophe_code');
		$data = [
			"code" => $code,
		];
		if(empty($id)){ 
			$data += [
				"added_by" => get_user_id(),
				"date_added" => CurrMySqlDate(),
				"is_active" => 1,
				"logs" => get_logs(),
			];
			data_inserter('k2_claims_crm_catastrophe', $data);
		} else {
			$this->db->where('id', $id);
			$this->db->update('k2_claims_crm_catastrophe', $data);
		}
		
		redirect($_SERVER['HTTP_REFERER']);
	}
	
	public function delete_catastrophe_master()
	{
		$id= $this->input->get('did');
		$data = [
			"is_active" => 0,
		];
		$this->db->where('id', $id);
		$this->db->update('k2_claims_crm_catastrophe', $data);
		redirect($_SERVER['HTTP_REFERER']);
	}


	//======================== 1. New Loss California Property ============================================//

	public function process_cpsform()
	{  
		$tablename = 'k2_claims_crm_cps';
		$current_user   = get_user_id();
		$infos = $this->input->post();
		
		$waterLoss = ""; $fireLoss = ""; $otherLoss = "";
		if($infos['type'] == 'cpswater'){
			$waterLoss = $infos['who_was_at_the_loss_time'];
		}
		if($infos['type'] == 'cpsfire'){
			$fireLoss = $infos['who_was_at_the_loss_time'];
		}
		if($infos['type'] == 'cpsother'){
			$otherLoss = $infos['who_was_at_the_loss_time'];
		}
				
		$data = array(
					"draft_id" => $infos['draftid'],
					"is_active" => 1,
					"date_of_loss" => $infos['date_of_loss'],
					"maintype" => $infos['maintype'],
					"policy_number" =>  $infos['policy_number'],
					"catastrophe" =>  $infos['which_catastrophe'],					
					"related_to_catastrophe" =>  $infos['related_to_catastrophe'],					
					"insured" => $infos['relationship_to_insured'],
					"r_policy_holder" => $infos['r_policy_holder'],
					"r_policy_phone" => $infos['r_policy_phone'],
					"r_policy_firm" => $infos['r_policy_firm'],
					"first_name" => $infos['first_name'],
					"last_name" => $infos['last_name'],
					"address" => $infos['address'],
					"city" => $infos['city'],
					"state" => $infos['state'],
					"zipcode" => $infos['zipcode'],
					"primary_phone" => $infos['primary_phone'],
					"secondary_phone" => $infos['secondary_phone'],
					"primay_mail" => $infos['email1'],
					"secondary_mail" => $infos['email2'],
					"loss_location" => $infos['loss_state'],
					"location_address" => $infos['address_description'],
					"loss_description" => $infos['loss_description'],
					"type" => $infos['type'],
					"souce_of_water" => $infos['source_of_water'],
					"plumber" => $infos['have_called_plumber'],
					"effected_rooms" => $infos['number_of_rooms_effected'],
					"who_was_at_the_time_of_loss" => $waterLoss,
					"how_long_property_been_vacant" => $infos['how_long_property_been_vacant'],
					"emergency_services" => $infos['emergency_services'],
					"emergency_services_needed" => $infos['do_they_need_emergency_services'],
					"other_structure_damage" => $infos['damage_other_structure'],
					"personal_property_damage" => $infos['damage_personal_structure'],
					"stay_home_tonight" => $infos['can_you_stay_in_the_room_tonight'],

					"fire_source" => $infos['source_of_fire'],
					"responce_of_fire_department" => $infos['fire_department_respond'],
					"effected_rooms_of_fire" => $infos['number_of_room_effected_fire'],
					"who_was_living_at_the_time_of_loss" => $fireLoss,
					"property_vacant_time_of_fire" => $infos['how_long_property_vacant_fire'],
					"emergency_services_called" => $infos['called_emergency_services_fire'],
					"do_they_need_emergency_services" => $infos['do_they_need_emergency_services_fire'],
					"other_structure_damage_fire" => $infos['damage_of_other_structure_fire'],
					"personal_property_damage_fire" => $infos['damage_of_personal_property_fire'],
					"can_you_stay_in_the_home_tonight" => $infos['can_you_stay_in_the_room_tonight_fire'],

					"other_damages_located" => $infos['damages_location_other'],
					"other_how_many_rooms_effected" => $infos['how_many_rooms_effected_other'],
					"other_who_was_at_the_time_of_loss" => $otherLoss,
					"other_how_long_has_the_property_been_vacant" => $infos['how_long_property_vacant_other'],
					"other_called_emergency_services" => $infos['called_emergency_services_other'],
					"other_describe_of_other_structure" => $infos['damage_other_structure_other'],
					"other_describe_personal_property" => $infos['damage_personal_structure_other'],
					"what_items_were_stolen" => $infos['theft_loss_other'],
					"theft_loss_police_report_other" => $infos['theft_loss_police_report_other'],
					"other_can_you_stay_home_tonight" => $infos['can_you_stay_in_the_room_tonight_other'],
					"added_by" => $current_user,
					"created_at" => date('Y-m-d H:i:s')
				);
		if(!empty($infos['maintype']) && !empty($infos['first_name']) && !empty($infos['zipcode']) && !empty($infos['primary_phone'])){
			if ($this->db->insert($tablename, $data) == true) {
			
				$insert_id = $this->db->insert_id();
				
				if(!empty($insert_id)){
					$this->db->where('draft_id', $infos['draftid']);				
					$this->db->where('is_active', 0);
					$this->db->delete($tablename);
				}

				
				$subject = 'New Loss California Property';
				$h1tag = 'New entry for New Loss California Property';
				$eto = $this->k2_email_set();
				
				$ecc = NULL;
				$checkType_1 = $checkType_2 = $checkType_3 = $checkType_4 = $checkType_5 = false;
				
				if ($infos['do_they_need_emergency_services'] == 'yes') {
					$checkType_1 = true;
				}
				if($infos['can_you_stay_in_the_room_tonight'] == 'yes') {
					$checkType_2 = true;
				}
				if ($infos['do_they_need_emergency_services_fire'] == 'yes') {
					$checkType_3 = true;
				}
				if ($infos['can_you_stay_in_the_room_tonight_fire'] == 'yes') {
					$checkType_4 = true;
				}
				if ($infos['can_you_stay_in_the_room_tonight_other'] == 'yes') {
					$checkType_5 = true;
				}
				if ($checkType_1 == true || $checkType_2 == true || $checkType_3 == true ||  $checkType_4 == true ||  $checkType_5 == true) {
				   $ecc = $this->k2_email_set(4);				   
		        }
				
				$sendTo = implode(',', $eto);
				$sendCC = implode(',', $ecc);
				$this->send_email_crm_logs($tablename, $insert_id, $subject, $h1tag, $sendTo, $sendCC);

				if(!empty($insert_id)){
					$this->db->where('draft_id', $infos['draftid']);				
					$this->db->where('is_active', 0);
					$this->db->delete($tablename);
				}
				
				redirect('k2_claims_crm/dashboard');
				
		    } else {
				redirect('k2_claims_crm/dashboard/error');
			}

	    } else {
			redirect('k2_claims_crm/dashboard/warning');
		}
    }
	
	
	public function process_cpsform_draft()
	{  
		$tablename = 'k2_claims_crm_cps';
		$current_user   = get_user_id();
		$infos = $this->input->post();
		
		$waterLoss = ""; $fireLoss = ""; $otherLoss = "";
		if($infos['type'] == 'cpswater'){
			$waterLoss = $infos['who_was_at_the_loss_time'];
		}
		if($infos['type'] == 'cpsfire'){
			$fireLoss = $infos['who_was_at_the_loss_time'];
		}
		if($infos['type'] == 'cpsother'){
			$otherLoss = $infos['who_was_at_the_loss_time'];
		}
						
		$data = array(
					"date_of_loss" => $infos['date_of_loss'],
					"date_of_loss" => $infos['date_of_loss'],
					"maintype" => $infos['maintype'],
					"policy_number" =>  $infos['policy_number'],
					"catastrophe" =>  $infos['which_catastrophe'],					
					"related_to_catastrophe" =>  $infos['related_to_catastrophe'],					
					"insured" => $infos['relationship_to_insured'],
					"r_policy_holder" => $infos['r_policy_holder'],
					"r_policy_phone" => $infos['r_policy_phone'],
					"r_policy_firm" => $infos['r_policy_firm'],
					"first_name" => $infos['first_name'],
					"last_name" => $infos['last_name'],
					"address" => $infos['address'],
					"city" => $infos['city'],
					"state" => $infos['state'],
					"zipcode" => $infos['zipcode'],
					"primary_phone" => $infos['primary_phone'],
					"secondary_phone" => $infos['secondary_phone'],
					"primay_mail" => $infos['email1'],
					"secondary_mail" => $infos['email2'],
					"loss_location" => $infos['loss_state'],
					"location_address" => $infos['address_description'],
					"loss_description" => $infos['loss_description'],
					"type" => $infos['type'],
					"souce_of_water" => $infos['source_of_water'],
					"plumber" => $infos['have_called_plumber'],
					"effected_rooms" => $infos['number_of_rooms_effected'],
					"who_was_at_the_time_of_loss" => $waterLoss,
					"how_long_property_been_vacant" => $infos['how_long_property_been_vacant'],
					"emergency_services" => $infos['emergency_services'],
					"emergency_services_needed" => $infos['do_they_need_emergency_services'],
					"other_structure_damage" => $infos['damage_other_structure'],
					"personal_property_damage" => $infos['damage_personal_structure'],
					"stay_home_tonight" => $infos['can_you_stay_in_the_room_tonight'],

					"fire_source" => $infos['source_of_fire'],
					"responce_of_fire_department" => $infos['fire_department_respond'],
					"effected_rooms_of_fire" => $infos['number_of_room_effected_fire'],
					"who_was_living_at_the_time_of_loss" => $fireLoss,
					"property_vacant_time_of_fire" => $infos['how_long_property_vacant_fire'],
					"emergency_services_called" => $infos['called_emergency_services_fire'],
					"do_they_need_emergency_services" => $infos['do_they_need_emergency_services_fire'],
					"other_structure_damage_fire" => $infos['damage_of_other_structure_fire'],
					"personal_property_damage_fire" => $infos['damage_of_personal_property_fire'],
					"can_you_stay_in_the_home_tonight" => $infos['can_you_stay_in_the_room_tonight_fire'],

					"other_damages_located" => $infos['damages_location_other'],
					"other_how_many_rooms_effected" => $infos['how_many_rooms_effected_other'],
					"other_who_was_at_the_time_of_loss" => $otherLoss,
					"other_how_long_has_the_property_been_vacant" => $infos['how_long_property_vacant_other'],
					"other_called_emergency_services" => $infos['called_emergency_services_other'],
					"other_describe_of_other_structure" => $infos['damage_other_structure_other'],
					"other_describe_personal_property" => $infos['damage_personal_structure_other'],
					"what_items_were_stolen" => $infos['theft_loss_other'],
					"theft_loss_police_report_other" => $infos['theft_loss_police_report_other'],
					"other_can_you_stay_home_tonight" => $infos['can_you_stay_in_the_room_tonight_other'],					
				);
			
			
			$draftId = $infos['draftid'];
			$sqlCheck = "SELECT * from $tablename WHERE draft_id  = '$draftId' AND is_active = '0'";
			$queryCheck = $this->Common_model->get_query_result_array($sqlCheck);
			if(!empty($queryCheck))
			{
				$this->db->where('draft_id', $draftId);
				$this->db->where('is_active', 0);
				$this->db->update($tablename, $data);
			} else {
				$data += [
					"is_active" => 0,
					"draft_id" => $draftId,
					"added_by" => $current_user,
					"created_at" => date('Y-m-d H:i:s')
				];
				$this->db->insert($tablename, $data);
			}
			
    }



	//======================== 2. New Loss No California Property ============================================//
	
	public function process_ncpsform()
	{   
		$tablename = 'k2_claims_crm_ncps';
		$current_user   = get_user_id();
		$infos = $this->input->post();
		
		$waterLoss = ""; $fireLoss = ""; $otherLoss = "";
		if($infos['type'] == 'ncpswater'){
			$waterLoss = $infos['who_was_at_the_loss_time'];
		}
		if($infos['type'] == 'ncpsfire'){
			$fireLoss = $infos['who_was_at_the_loss_time'];
		}
		if($infos['type'] == 'ncpsother'){
			$otherLoss = $infos['who_was_at_the_loss_time'];
		}
		
		$data = array(
					"draft_id" => $infos['draftid'],
					"is_active" => 1,
					"date_of_loss" => $infos['date_of_loss'],
					"maintype" => $infos['maintype'],
					"policy_number" =>  $infos['policy_number'],
					"catastrophe" =>  $infos['which_catastrophe'],					
					"related_to_catastrophe" =>  $infos['related_to_catastrophe'],					
					"insured" => $infos['relationship_to_insured'],
					"r_policy_holder" => $infos['r_policy_holder'],
					"r_policy_phone" => $infos['r_policy_phone'],
					"r_policy_firm" => $infos['r_policy_firm'],
					"first_name" => $infos['first_name'],
					"last_name" => $infos['last_name'],
					"address" => $infos['address'],
					"city" => $infos['city'],
					"state" => $infos['state'],
					"zipcode" => $infos['zipcode'],
					"primary_phone" => $infos['primary_phone'],
					"secondary_phone" => $infos['secondary_phone'],
					"primay_mail" => $infos['email1'],
					"secondary_mail" => $infos['email2'],
					"loss_location" => $infos['loss_state'],
					"location_address" => $infos['address_description'],
					"loss_description" => $infos['loss_description'],
					"type" => $infos['type'],
					"souce_of_water" => $infos['source_of_water'],
					"plumber" => $infos['have_called_plumber'],
					"effected_rooms" => $infos['number_of_rooms_effected'],
					"who_was_at_the_time_of_loss" => $waterLoss,
					"how_long_property_been_vacant" => $infos['how_long_property_been_vacant'],
					"emergency_services" => $infos['emergency_services'],
					"other_structure_damage" => $infos['damage_other_structure'],
					"personal_property_damage" => $infos['damage_personal_structure'],
					"stay_home_tonight" => $infos['can_you_stay_in_the_room_tonight'],

					"fire_source" => $infos['source_of_fire'],
					"responce_of_fire_department" => $infos['fire_department_respond'],
					"effected_rooms_of_fire" => $infos['number_of_room_effected_fire'],
					"who_was_living_at_the_time_of_loss" => $fireLoss,
					"property_vacant_time_of_fire" => $infos['how_long_property_vacant_fire'],
					"emergency_services_called" => $infos['called_emergency_services_fire'],
					"other_structure_damage_fire" => $infos['damage_of_other_structure_fire'],
					"personal_property_damage_fire" => $infos['damage_of_personal_property_fire'],
					"can_you_stay_in_the_home_tonight" => $infos['can_you_stay_in_the_room_tonight_fire'],

					"other_damages_located" => $infos['damages_location_other'],
					"other_how_many_rooms_effected" => $infos['how_many_rooms_effected_other'],
					"other_who_was_at_the_time_of_loss" => $otherLoss,
					"other_how_long_has_the_property_been_vacant" => $infos['how_long_property_vacant_other'],
					"other_called_emergency_services" => $infos['called_emergency_services_other'],
					"other_describe_of_other_structure" => $infos['damage_other_structure_other'],
					"other_describe_personal_property" => $infos['damage_personal_structure_other'],
					"what_items_were_stolen" => $infos['theft_loss_other'],
					"theft_loss_police_report_other" => $infos['theft_loss_police_report_other'],
					"other_can_you_stay_home_tonight" => $infos['can_you_stay_in_the_room_tonight_other'],
					"added_by" => $current_user,
					"created_at" => date('Y-m-d H:i:s')
				);

		if(!empty($infos['maintype']) && !empty($infos['first_name']) && !empty($infos['zipcode']) && !empty($infos['primary_phone'])){

			if ($this->db->insert($tablename, $data) == true) {
				
					$insert_id = $this->db->insert_id();
					
					if(!empty($insert_id)){
						$this->db->where('draft_id', $infos['draftid']);				
						$this->db->where('is_active', 0);
						$this->db->delete($tablename);
					}
				
					$subject = 'New Loss No California Property';
					$h1tag = 'New entry for New Loss No California Property';
					$eto = $this->k2_email_set();
					
					$ecc = NULL;
					$checkType_1 = $checkType_2 = $checkType_3 = false;
					
					if ($infos['can_you_stay_in_the_room_tonight'] == 'yes') {
						$checkType_1 = true;
					}

					if ($infos['can_you_stay_in_the_room_tonight_fire'] == 'yes') {
						$checkType_2 = true;
					}

					if ($infos['can_you_stay_in_the_room_tonight_other'] == 'yes') {
						$checkType_3 = true;
					}
					
					if ($checkType_1 == true || $checkType_2 == true || $checkType_3 == true) {
					   $ecc = $this->k2_email_set(5);				   
					}
				
					$sendTo = implode(',', $eto);
					$sendCC = implode(',', $ecc);
					$this->send_email_crm_logs($tablename, $insert_id, $subject, $h1tag, $sendTo, $sendCC);
					
					if(!empty($insert_id)){
						$this->db->where('draft_id', $infos['draftid']);				
						$this->db->where('is_active', 0);
						$this->db->delete($tablename);
					}
				
					redirect('k2_claims_crm/dashboard');
				
		    } else {
				redirect('k2_claims_crm/dashboard/error');
			}

	    } else {
			redirect('k2_claims_crm/dashboard/warning');
		}
    }
	
	public function process_ncpsform_draft()
	{   
		$tablename = 'k2_claims_crm_ncps';
		$current_user   = get_user_id();
		$infos = $this->input->post();
		
		$waterLoss = ""; $fireLoss = ""; $otherLoss = "";
		if($infos['type'] == 'ncpswater'){
			$waterLoss = $infos['who_was_at_the_loss_time'];
		}
		if($infos['type'] == 'ncpsfire'){
			$fireLoss = $infos['who_was_at_the_loss_time'];
		}
		if($infos['type'] == 'ncpsother'){
			$otherLoss = $infos['who_was_at_the_loss_time'];
		}
		
		$data = array(
					"date_of_loss" => $infos['date_of_loss'],
					"maintype" => $infos['maintype'],
					"policy_number" =>  $infos['policy_number'],
					"catastrophe" =>  $infos['which_catastrophe'],					
					"related_to_catastrophe" =>  $infos['related_to_catastrophe'],					
					"insured" => $infos['relationship_to_insured'],
					"r_policy_holder" => $infos['r_policy_holder'],
					"r_policy_phone" => $infos['r_policy_phone'],
					"r_policy_firm" => $infos['r_policy_firm'],
					"first_name" => $infos['first_name'],
					"last_name" => $infos['last_name'],
					"address" => $infos['address'],
					"city" => $infos['city'],
					"state" => $infos['state'],
					"zipcode" => $infos['zipcode'],
					"primary_phone" => $infos['primary_phone'],
					"secondary_phone" => $infos['secondary_phone'],
					"primay_mail" => $infos['email1'],
					"secondary_mail" => $infos['email2'],
					"loss_location" => $infos['loss_state'],
					"location_address" => $infos['address_description'],
					"loss_description" => $infos['loss_description'],
					"type" => $infos['type'],
					"souce_of_water" => $infos['source_of_water'],
					"plumber" => $infos['have_called_plumber'],
					"effected_rooms" => $infos['number_of_rooms_effected'],
					"who_was_at_the_time_of_loss" => $waterLoss,
					"how_long_property_been_vacant" => $infos['how_long_property_been_vacant'],
					"emergency_services" => $infos['emergency_services'],
					"other_structure_damage" => $infos['damage_other_structure'],
					"personal_property_damage" => $infos['damage_personal_structure'],
					"stay_home_tonight" => $infos['can_you_stay_in_the_room_tonight'],

					"fire_source" => $infos['source_of_fire'],
					"responce_of_fire_department" => $infos['fire_department_respond'],
					"effected_rooms_of_fire" => $infos['number_of_room_effected_fire'],
					"who_was_living_at_the_time_of_loss" => $fireLoss,
					"property_vacant_time_of_fire" => $infos['how_long_property_vacant_fire'],
					"emergency_services_called" => $infos['called_emergency_services_fire'],
					"other_structure_damage_fire" => $infos['damage_of_other_structure_fire'],
					"personal_property_damage_fire" => $infos['damage_of_personal_property_fire'],
					"can_you_stay_in_the_home_tonight" => $infos['can_you_stay_in_the_room_tonight_fire'],

					"other_damages_located" => $infos['damages_location_other'],
					"other_how_many_rooms_effected" => $infos['how_many_rooms_effected_other'],
					"other_who_was_at_the_time_of_loss" => $otherLoss,
					"other_how_long_has_the_property_been_vacant" => $infos['how_long_property_vacant_other'],
					"other_called_emergency_services" => $infos['called_emergency_services_other'],
					"other_describe_of_other_structure" => $infos['damage_other_structure_other'],
					"other_describe_personal_property" => $infos['damage_personal_structure_other'],
					"what_items_were_stolen" => $infos['theft_loss_other'],
					"theft_loss_police_report_other" => $infos['theft_loss_police_report_other'],
					"other_can_you_stay_home_tonight" => $infos['can_you_stay_in_the_room_tonight_other'],
				);
				
				$draftId = $infos['draftid'];
				$sqlCheck = "SELECT * from $tablename WHERE draft_id  = '$draftId' AND is_active = '0'";
				$queryCheck = $this->Common_model->get_query_result_array($sqlCheck);
				if(!empty($queryCheck))
				{
					$this->db->where('draft_id', $draftId);
					$this->db->where('is_active', 0);
					$this->db->update($tablename, $data);
				} else {
					$data += [
						"is_active" => 0,
						"draft_id" => $draftId,
						"added_by" => $current_user,
						"created_at" => date('Y-m-d H:i:s')
					];
					$this->db->insert($tablename, $data);
				}
    }
	
	
	//======================== 3. New Loss Liability ============================================//
	
	public function process_alsform()
	{   
		$tablename = 'k2_claims_crm_als';
		$current_user   = get_user_id();
		$infos = $this->input->post();

		$data = array(
					"draft_id" => $infos['draftid'],
					"is_active" => 1,
					"date_of_loss" => $infos['date_of_loss'],
					"maintype" => $infos['maintype'],
					"policy_number" =>  $infos['policy_number'],
					"catastrophe" =>  $infos['which_catastrophe'],					
					"related_to_catastrophe" =>  $infos['related_to_catastrophe'],					
					"relationship_to_insured" => $infos['relationship_to_insured'],
					"r_policy_holder" => $infos['r_policy_holder'],
					"r_policy_phone" => $infos['r_policy_phone'],
					"r_policy_firm" => $infos['r_policy_firm'],
					"first_name" => $infos['first_name'],
					"last_name" => $infos['last_name'],
					"address" => $infos['address'],
					"city" => $infos['city'],
					"state" => $infos['state'],
					"zipcode" => $infos['zipcode'],
					"primary_phone" => $infos['primary_phone'],
					"secondary_phone" => $infos['secondary_phone'],
					"primay_mail" => $infos['email1'],
					"secondary_mail" => $infos['email2'],
					"loss_location" => $infos['loss_state'],
					"location_address" => $infos['address_description'],
					"loss_description" => $infos['loss_description'],

					"police_called" => $infos['police_called'],
					"police_arrived" => $infos['police_arrived'],
					"report_taken" => $infos['report_taken'],
					"report_id" => $infos['report_id'],

					"name_of_claimant" => $infos['name_of_claimant'],
					"address_of_claimant" => $infos['address_of_claimant'],
					"phone_number_of_claimant" => $infos['phone_number_claimant'],
					"email_of_claimant" => $infos['email_address_claimant'],
					"types_of_injuries" => $infos['types_of_injuries'],
					"injuries" => $infos['injuries_details'],
					"parties_represented" => $infos['parties_represented'],
					"name_of_attrony" => $infos['attorny_of_contact'],
					"added_by" => $current_user,
					"created_at" => date('Y-m-d H:i:s')
				);

		if(!empty($infos['maintype']) && !empty($infos['first_name']) && !empty($infos['zipcode']) && !empty($infos['primary_phone'])){
			if ($this->db->insert($tablename, $data) == true) {

					$insert_id = $this->db->insert_id();
					
					if(!empty($insert_id)){
						$this->db->where('draft_id', $infos['draftid']);				
						$this->db->where('is_active', 0);
						$this->db->delete($tablename);
					}
					
					$subject = 'New Loss Liability';
					$h1tag = 'New entry for New Loss Liability';
					$eto = $this->k2_email_set();
					
					$ecc = NULL;
					$checkType_1 = false;
					
					if ($infos['types_of_injuries'] == 'yes') {
						$checkType_1 = true;
					}
					
					if ($checkType_1 == true) {
					   $ecc = $this->k2_email_set(3);				   
					}
					
					$sendTo = implode(',', $eto);
					$sendCC = implode(',', $ecc);
					$this->send_email_crm_logs($tablename, $insert_id, $subject, $h1tag, $sendTo, $sendCC);
					
					if(!empty($insert_id)){
						$this->db->where('draft_id', $infos['draftid']);				
						$this->db->where('is_active', 0);
						$this->db->delete($tablename);
					}
				
					redirect('k2_claims_crm/dashboard');
				
		    } else {
				redirect('k2_claims_crm/dashboard/error');
			}

	    } else {
			redirect('k2_claims_crm/dashboard/warning');
		}
    }
	
	public function process_alsform_draft()
	{   
		$tablename = 'k2_claims_crm_als';
		$current_user   = get_user_id();
		$infos = $this->input->post();

		$data = array(
					"date_of_loss" => $infos['date_of_loss'],
					"maintype" => $infos['maintype'],
					"policy_number" =>  $infos['policy_number'],
					"catastrophe" =>  $infos['which_catastrophe'],					
					"related_to_catastrophe" =>  $infos['related_to_catastrophe'],					
					"relationship_to_insured" => $infos['relationship_to_insured'],
					"r_policy_holder" => $infos['r_policy_holder'],
					"r_policy_phone" => $infos['r_policy_phone'],
					"r_policy_firm" => $infos['r_policy_firm'],
					"first_name" => $infos['first_name'],
					"last_name" => $infos['last_name'],
					"address" => $infos['address'],
					"city" => $infos['city'],
					"state" => $infos['state'],
					"zipcode" => $infos['zipcode'],
					"primary_phone" => $infos['primary_phone'],
					"secondary_phone" => $infos['secondary_phone'],
					"primay_mail" => $infos['email1'],
					"secondary_mail" => $infos['email2'],
					"loss_location" => $infos['loss_state'],
					"location_address" => $infos['address_description'],
					"loss_description" => $infos['loss_description'],

					"police_called" => $infos['police_called'],
					"police_arrived" => $infos['police_arrived'],
					"report_taken" => $infos['report_taken'],
					"report_id" => $infos['report_id'],

					"name_of_claimant" => $infos['name_of_claimant'],
					"address_of_claimant" => $infos['address_of_claimant'],
					"phone_number_of_claimant" => $infos['phone_number_claimant'],
					"email_of_claimant" => $infos['email_address_claimant'],
					"types_of_injuries" => $infos['types_of_injuries'],
					"injuries" => $infos['injuries_details'],
					"parties_represented" => $infos['parties_represented'],
					"name_of_attrony" => $infos['attorny_of_contact'],
				);

			$draftId = $infos['draftid'];
			$sqlCheck = "SELECT * from $tablename WHERE draft_id  = '$draftId' AND is_active = '0'";
			$queryCheck = $this->Common_model->get_query_result_array($sqlCheck);
			if(!empty($queryCheck))
			{
				$this->db->where('draft_id', $draftId);
				$this->db->where('is_active', 0);
				$this->db->update($tablename, $data);
			} else {
				$data += [
					"is_active" => 0,
					"draft_id" => $draftId,
					"added_by" => $current_user,
					"created_at" => date('Y-m-d H:i:s')
				];
				$this->db->insert($tablename, $data);
			}
			//echo "<pre>".print_r($data, 1)."</pre>";
    }
	
	
	//======================== 4. New Loss Auto-Motorcycle ============================================//
	
	public function process_aasform()
	{   
		$tablename = 'k2_claims_crm_aas';
		$current_user   = get_user_id();
		$infos = $this->input->post();

		$data = array(
					"draft_id" => $infos['draftid'],
					"is_active" => 1,
					"date_of_loss" => $infos['date_of_loss'],
					"maintype" => $infos['maintype'],
					"policy_number" =>  $infos['policy_number'],
					"catastrophe" =>  $infos['which_catastrophe'],					
					"related_to_catastrophe" =>  $infos['related_to_catastrophe'],					
					"relationship_to_insured" => $infos['relationship_to_insured'],
					"r_policy_holder" => $infos['r_policy_holder'],
					"r_policy_phone" => $infos['r_policy_phone'],
					"r_policy_firm" => $infos['r_policy_firm'],
					"first_name" => $infos['first_name'],
					"last_name" => $infos['last_name'],
					"address" => $infos['address'],
					"city" => $infos['city'],
					"state" => $infos['state'],
					"zipcode" => $infos['zipcode'],
					"primary_phone" => $infos['primary_phone'],
					"secondary_phone" => $infos['secondary_phone'],
					"primay_mail" => $infos['email1'],
					"secondary_mail" => $infos['email2'],
					"loss_location" => $infos['loss_state'],
					"location_address" => $infos['address_description'],
					"loss_description" => $infos['loss_description'],

					"police_called" => $infos['police_called'],
					"police_arrived" => $infos['police_arrived'],
					"report_taken" => $infos['report_taken'],
					"report_id" => $infos['report_id'],

					"model_of_insured_vehicle" => $infos['insured_vehicle_driven'],
					"model_of_claimant_vehicle" => $infos['claimant_vehicle_driven'],
					"name_of_claimant_driver" => $infos['claimant_driver'],
					"address_of_claimant_driver" => $infos['address_of_claimant_driver'],
					"phone_number_of_claimant" => $infos['phone_number_claimant'],
					"email_of_claimant" => $infos['email_address_claimant'],
					"child_restraint" => $infos['child_restraint'],
					"vehicle_driveable" => $infos['vehicle_driveable'],
					"any_passengers" => $infos['any_passengers'],
					"name_of_passengers" => $infos['name_of_passengers'],
					"types_of_injuries" => $infos['types_of_injuries'],
					"injuries_details" => $infos['injuries_details'],
					"added_by" => $current_user,
					"created_at" => date('Y-m-d H:i:s')
				);
		if(!empty($infos['maintype']) && !empty($infos['first_name']) && !empty($infos['zipcode']) && !empty($infos['primary_phone'])){
			if ($this->db->insert($tablename, $data) == true) {

				$insert_id = $this->db->insert_id();
				
				if(!empty($insert_id)){
					$this->db->where('draft_id', $infos['draftid']);				
					$this->db->where('is_active', 0);
					$this->db->delete($tablename);
				}
					
				$subject = 'New Loss Auto-Motorcycle';
				$h1tag = 'New entry for New Loss Auto-Motorcycle';
				$eto = $this->k2_email_set();
				
				$ecc = NULL;
				$checkType_1 = false;
				
				if ($infos['types_of_injuries'] == 'yes') {
					$checkType_1 = true;
				}
				
				if ($checkType_1 == true) {
				   $ecc = $this->k2_email_set(3);				   
				}
					
				$sendTo = implode(',', $eto);
				$sendCC = implode(',', $ecc);
				$this->send_email_crm_logs($tablename, $insert_id, $subject, $h1tag, $sendTo, $sendCC);
				
				if(!empty($insert_id)){
					$this->db->where('draft_id', $infos['draftid']);				
					$this->db->where('is_active', 0);
					$this->db->delete($tablename);
				}
				
				redirect('k2_claims_crm/dashboard');
				
		    } else {
				redirect('k2_claims_crm/dashboard/error');
			}

	    } else {
			redirect('k2_claims_crm/dashboard/warning');
		}
    }
	
	
	public function process_aasform_draft()
	{   
		$tablename = 'k2_claims_crm_aas';
		$current_user   = get_user_id();
		$infos = $this->input->post();

		$data = array(
					"date_of_loss" => $infos['date_of_loss'],
					"maintype" => $infos['maintype'],
					"policy_number" =>  $infos['policy_number'],
					"catastrophe" =>  $infos['which_catastrophe'],					
					"related_to_catastrophe" =>  $infos['related_to_catastrophe'],					
					"relationship_to_insured" => $infos['relationship_to_insured'],
					"r_policy_holder" => $infos['r_policy_holder'],
					"r_policy_phone" => $infos['r_policy_phone'],
					"r_policy_firm" => $infos['r_policy_firm'],
					"first_name" => $infos['first_name'],
					"last_name" => $infos['last_name'],
					"address" => $infos['address'],
					"city" => $infos['city'],
					"state" => $infos['state'],
					"zipcode" => $infos['zipcode'],
					"primary_phone" => $infos['primary_phone'],
					"secondary_phone" => $infos['secondary_phone'],
					"primay_mail" => $infos['email1'],
					"secondary_mail" => $infos['email2'],
					"loss_location" => $infos['loss_state'],
					"location_address" => $infos['address_description'],
					"loss_description" => $infos['loss_description'],

					"police_called" => $infos['police_called'],
					"police_arrived" => $infos['police_arrived'],
					"report_taken" => $infos['report_taken'],
					"report_id" => $infos['report_id'],

					"model_of_insured_vehicle" => $infos['insured_vehicle_driven'],
					"model_of_claimant_vehicle" => $infos['claimant_vehicle_driven'],
					"name_of_claimant_driver" => $infos['claimant_driver'],
					"address_of_claimant_driver" => $infos['address_of_claimant_driver'],
					"phone_number_of_claimant" => $infos['phone_number_claimant'],
					"email_of_claimant" => $infos['email_address_claimant'],
					"child_restraint" => $infos['child_restraint'],
					"vehicle_driveable" => $infos['vehicle_driveable'],
					"any_passengers" => $infos['any_passengers'],
					"name_of_passengers" => $infos['name_of_passengers'],
					"types_of_injuries" => $infos['types_of_injuries'],
					"injuries_details" => $infos['injuries_details'],
				);
		
			$draftId = $infos['draftid'];
			$sqlCheck = "SELECT * from $tablename WHERE draft_id  = '$draftId' AND is_active = '0'";
			$queryCheck = $this->Common_model->get_query_result_array($sqlCheck);
			if(!empty($queryCheck))
			{
				$this->db->where('draft_id', $draftId);
				$this->db->where('is_active', 0);
				$this->db->update($tablename, $data);
			} else {
				$data += [
					"is_active" => 0,
					"draft_id" => $draftId,
					"added_by" => $current_user,
					"created_at" => date('Y-m-d H:i:s')
				];
				$this->db->insert($tablename, $data);
			}
    }
	
	//======================== 5. New Loss About Existing Claim ============================================//
	
	public function process_caefform()
	{   
		$tablename = 'k2_claims_crm_caef';
		$infos = $this->input->post();
		$current_user   = get_user_id();
		$data = array(
					"draft_id" => $infos['draftid'],
					"is_active" => 1,
					"maintype" => $infos['maintype'],
					"callername" =>  $infos['callername'],
					"return_call_number" =>  $infos['return_call_number'],					
					"email" => $infos['email'],
					"reason_for_call" => $infos['reason_for_call'],
					"policy_number" => $infos['policy_number'],
					"claim" => $infos['claim'],
					"added_by" => $current_user,
					"created_at" => date('Y-m-d H:i:s')
				);

		if(!empty($infos['maintype']) && !empty($infos['callername']) && !empty($infos['email']) &&!empty($infos['reason_for_call'])){
			if ($this->db->insert($tablename, $data) == true) {

					$insert_id = $this->db->insert_id();
					
					if(!empty($insert_id)){
						$this->db->where('draft_id', $infos['draftid']);				
						$this->db->where('is_active', 0);
						$this->db->delete($tablename);
					}
					
					$subject = 'About Existing Claim';
					$h1tag = 'New entry for Existing Clam';
					$eto = $this->k2_email_set();
					
					$sendTo = implode(',', $eto);
					$this->send_email_crm_logs($tablename, $insert_id, $subject, $h1tag, $sendTo);
					
					if(!empty($insert_id)){
						$this->db->where('draft_id', $infos['draftid']);				
						$this->db->where('is_active', 0);
						$this->db->delete($tablename);
					}
				
					redirect('k2_claims_crm/dashboard');
				
		    } else {
				redirect('k2_claims_crm/dashboard/error');
			}

	    } else {
			redirect('k2_claims_crm/dashboard/warning');
		}
    }
	
	public function process_caefform_draft()
	{   
		$tablename = 'k2_claims_crm_caef';
		$infos = $this->input->post();
		$current_user   = get_user_id();
		$data = array(
					"maintype" => $infos['maintype'],
					"callername" =>  $infos['callername'],
					"return_call_number" =>  $infos['return_call_number'],					
					"email" => $infos['email'],
					"reason_for_call" => $infos['reason_for_call'],
					"policy_number" => $infos['policy_number'],
					"claim" => $infos['claim'],
				);

			$draftId = $infos['draftid'];
			$sqlCheck = "SELECT * from $tablename WHERE draft_id  = '$draftId' AND is_active = '0'";
			$queryCheck = $this->Common_model->get_query_result_array($sqlCheck);
			if(!empty($queryCheck))
			{
				$this->db->where('draft_id', $draftId);
				$this->db->where('is_active', 0);
				$this->db->update($tablename, $data);
			} else {
				$data += [
					"is_active" => 0,
					"draft_id" => $draftId,
					"added_by" => $current_user,
					"created_at" => date('Y-m-d H:i:s')
				];
				$this->db->insert($tablename, $data);
			}
    }
	
	
	//======================== 6. New Loss Other Issue ============================================//
	
	public function process_oiform()
	{   
		$tablename = 'k2_claims_crm_oi';
		$infos = $this->input->post();
		$current_user   = get_user_id();
		$data = array(
					"draft_id" => $infos['draftid'],
					"is_active" => 1,
					"maintype" => $infos['maintype'],
					"callername" =>  $infos['callername'],
					"return_call_number" =>  $infos['return_call_number'],					
					"email" => $infos['email'],
					"reason_for_call" => $infos['reason_for_call'],
					"policy_number" => $infos['policy_number'],
					"claim" => $infos['claim'],
					"added_by" => $current_user,
					"created_at" => date('Y-m-d H:i:s')
				);

		if(!empty($infos['maintype']) && !empty($infos['callername']) && !empty($infos['email']) &&!empty($infos['reason_for_call'])){
			if ($this->db->insert($tablename, $data) == true) {

					$insert_id = $this->db->insert_id();
					
					if(!empty($insert_id)){
						$this->db->where('draft_id', $infos['draftid']);				
						$this->db->where('is_active', 0);
						$this->db->delete($tablename);
					}
					
					$subject = 'Other Issue';
					$h1tag = 'New entry for Other Issue';
					$eto = $this->k2_email_set();
					
					$sendTo = implode(',', $eto);
					$this->send_email_crm_logs($tablename, $insert_id, $subject, $h1tag, $sendTo);
					
					if(!empty($insert_id)){
						$this->db->where('draft_id', $infos['draftid']);				
						$this->db->where('is_active', 0);
						$this->db->delete($tablename);
					}
				
					redirect('k2_claims_crm/dashboard');
				
		    } else {
				redirect('k2_claims_crm/dashboard/error');
			}

	    } else {
			redirect('k2_claims_crm/dashboard/warning');
		}
    }
	
	public function process_oiform_draft()
	{   
		$tablename = 'k2_claims_crm_oi';
		$infos = $this->input->post();
		$current_user   = get_user_id();
		$data = array(
					"maintype" => $infos['maintype'],
					"callername" =>  $infos['callername'],
					"return_call_number" =>  $infos['return_call_number'],					
					"email" => $infos['email'],
					"reason_for_call" => $infos['reason_for_call'],
					"policy_number" => $infos['policy_number'],
					"claim" => $infos['claim'],
				);

			$draftId = $infos['draftid'];
			$sqlCheck = "SELECT * from $tablename WHERE draft_id  = '$draftId' AND is_active = '0'";
			$queryCheck = $this->Common_model->get_query_result_array($sqlCheck);
			if(!empty($queryCheck))
			{
				$this->db->where('draft_id', $draftId);
				$this->db->where('is_active', 0);
				$this->db->update($tablename, $data);
			} else {
				$data += [
					"is_active" => 0,
					"draft_id" => $draftId,
					"added_by" => $current_user,
					"created_at" => date('Y-m-d H:i:s')
				];
				$this->db->insert($tablename, $data);
			}
    }
	
	
	//====================== SEND EMAIL LOGS ====================================//
	
	public function send_email_crm_logs($tablename = '', $insert_id = '', $subject = '', $h1tag = '', $eto = '', $ecc = '')
	{
		
		$from_email="noreply.fems@fusionbposervices.com";
		$from_name="Fusion FEMS";
		$nbody="";
		
		$sql_dataLog = "SELECT c.*, CONCAT(s.fname,' ', s.lname) as added_by_name, r.name as designation, s.fusion_id,
		                      get_process_names(s.id) as process_name, CONCAT(l.fname, ' ', l.lname) as l1_supervisor, CONCAT(sc.fname, ' ', sc.lname) as client_name
		                      from $tablename as c 
		                      LEFT JOIN signin as s ON s.id = c.added_by
							  LEFT JOIN signin as l ON l.id = s.assigned_to
							  LEFT JOIN signin_client as sc ON sc.id = c.added_by
		                      LEFT JOIN role as r ON r.id = s.role_id 
							  WHERE c.id = $insert_id ORDER by id DESC LIMIT 1";

		$datLogs = $this->Common_model->get_query_row_array($sql_dataLog);
		if(!empty($datLogs['id']))
		{
			$lossDate = $datLogs['created_at'];
			$catastrophe = !empty($datLogs['callername']) ? $datLogs['callername'] : "";
			if($datLogs['maintype'] == 'aas' || $datLogs['maintype'] == 'als' || $datLogs['maintype'] == 'als' || $datLogs['maintype'] == 'cps' || $datLogs['maintype'] == 'ncps')
			{
				$lossDate = $datLogs['date_of_loss'];
				$catastrophe = $datLogs['catastrophe'];
			}
			$email_subject = $subject." | ".$datLogs['id'] ." | " .$catastrophe ." | " .$lossDate;
			$type = $datLogs['type'];
			
			// CLIENT LOGIN CHECK
			if(get_login_type() == "client"){
				$additionalInfo = '<br/><b>Date Added : </b> '.$datLogs['created_at'] .'<br/>
								<b>Added By : </b> '.$datLogs['client_name'] .'<br/>								
								</br>';
				$additionalInfo .=  '</br><b>Regards, </br>
								  Fusion - FEMS	</b></br>
							     ';
								 
			} else {
				$additionalInfo = '<br/><b>Date Added : </b> '.$datLogs['created_at'] .'<br/>
								<b>Added By : </b> '.$datLogs['added_by_name'] .'<br/>
								<b>Designation : </b> '.$datLogs['designation'] .'<br/>
								<b>Supervisor : </b> '.$datLogs['l1_supervisor'] .'<br/>
								<b>Process : </b> '.$datLogs['process_name'] .'<br/>								
								</br>';
				$additionalInfo .=  '</br><b>Regards, </br>
								  Fusion - FEMS	</b></br>
							     ';
			}
			
			
			// LOSS TYPE
			switch ($type) {
				case 'cpswater':
					$stype = 'Water';
					$waterarray = array(
							   "What is the source of the water" => $datLogs['souce_of_water'],
							   "Have you called a plumber? Who?" => $datLogs['plumber'],
							   "How many rooms are affected?" => $datLogs['effected_rooms'],
							   "Who was living in the house at the time of the loss?" => $datLogs['who_was_at_the_time_of_loss'],
							   "If nobody, how long has the property been vacant?" => $datLogs['how_long_property_been_vacant'],
							   "Have you called emergency servcies? Who? When did they get there?" => $datLogs['emergency_services'],
							   "If no, do they need emergency services?" => $datLogs['emergency_services_needed'],
							   "Describe any damage to other structures? (fences, sheds, outbuildings)" => $datLogs['other_structure_damage'],
							   "Describe any damage to personal property? (clothing, furniture)" => $datLogs['personal_property_damage'],
							   "Do you need a place to stay tonight?" => $datLogs['stay_home_tonight']
							);
					break;
				case 'cpsfire':
					$stype = 'Fire';
					$firearray = array(
							   "Where did the fire start?" => $datLogs['fire_source'],
							   "Did the fire department respond?" => $datLogs['responce_of_fire_department'],
							   "How many rooms are affected?" => $datLogs['effected_rooms_of_fire'],
							   "Who was living in the house at the time of the loss?" => $datLogs['who_was_living_at_the_time_of_loss'],
							   "If nobody, how long has the property been vacant?" => $datLogs['property_vacant_time_of_fire'],
							   "Have you called emergency services/board up? Who? When did they get there?" => $datLogs['emergency_services_called'],
							   "If no, do they need emergency services?" => $datLogs['do_they_need_emergency_services'],
							   "Describe any damage to other structures? (fences, sheds, outbuildings)" => $datLogs['other_structure_damage_fire'],
							   "Describe any damage to personal property? (clothing, furniture)" => $datLogs['personal_property_damage_fire'],
							   "Do you need a place to stay tonight?" => $datLogs['can_you_stay_in_the_home_tonight']
							);
					break;
				case 'cpsother':
					$stype = 'Other';
					$otherarray = array(
							   "Where are the damages located?" => $datLogs['other_damages_located'],
							   "How many rooms are affected?" => $datLogs['other_how_many_rooms_effected'],
							   "Who was living in the house at the time of the loss?" => $datLogs['other_who_was_at_the_time_of_loss'],
							   "If nobody, how long has the property been vacant" => $datLogs['other_how_long_has_the_property_been_vacant'],
							   "Have you called emergency services? Who? When did they get there?" => $datLogs['other_called_emergency_services'],
							   "Describe any damage to other structures? (fences, sheds, outbuildings)" => $datLogs['other_describe_of_other_structure'],
							   "Describe any damage to persojnal property? (clothing, furniture)" => $datLogs['other_describe_personal_property'],
							   "If theft/burglary loss try to ask the insured what items were stolen" => $datLogs['what_items_were_stolen'],
							   "If THEFT / BURGLARY / VANDALISM try to ask If they filed a police report and ask for their police report no" => $datLogs['theft_loss_police_report_other'],
							   "Do you need a place to stay tonight?" => $datLogs['other_can_you_stay_home_tonight'],
							);
					break;
				case 'ncpswater':
					$stype = 'Water';
					$waterarray = array(
							   "What is the source of the water" => $datLogs['souce_of_water'],
							   "Have you called a plumber? Who?" => $datLogs['plumber'],
							   "How many rooms are affected?" => $datLogs['effected_rooms'],
							   "Who was living in the house at the time of the loss?" => $datLogs['who_was_at_the_time_of_loss'],
							   "If nobody, how long has the property been vacant?" => $datLogs['how_long_property_been_vacant'],
							   "Have you called emergency servcies? Who? When did they get there?" => $datLogs['emergency_services'],
							   "Describe any damage to other structures? (fences, sheds, outbuildings)" => $datLogs['other_structure_damage'],
							   "Describe any damage to personal property? (clothing, furniture)" => $datLogs['personal_property_damage'],
							   "Do you need a place to stay tonight?" => $datLogs['stay_home_tonight']
							);
					break;
				case 'ncpsfire':
					$stype = 'Fire';
					$firearray = array(
							   "Where did the fire start?" => $datLogs['fire_source'],
							   "Did the fire department respond?" => $datLogs['responce_of_fire_department'],
							   "How many rooms are affected?" => $datLogs['effected_rooms_of_fire'],
							   "Who was living in the house at the time of the loss?" => $datLogs['who_was_living_at_the_time_of_loss'],
							   "If nobody, how long has the property been vacant?" => $datLogs['property_vacant_time_of_fire'],
							   "Have you called emergency services/board up? Who? When did they get there?" => $datLogs['emergency_services_called'],
							   "If no, do they need emergency services?" => $datLogs['do_they_need_emergency_services'],
							   "Describe any damage to other structures? (fences, sheds, outbuildings)" => $datLogs['other_structure_damage_fire'],
							   "Describe any damage to personal property? (clothing, furniture)" => $datLogs['personal_property_damage_fire'],
							   "Do you need a place to stay tonight?" => $datLogs['can_you_stay_in_the_home_tonight']
							);
					break;
				case 'ncpsother':
					$stype = 'Other';
					$otherarray = array(
							   "Where are the damages located?" => $datLogs['other_damages_located'],
							   "How many rooms are affected?" => $datLogs['other_how_many_rooms_effected'],
							   "Who was living in the house at the time of the loss?" => $datLogs['other_who_was_at_the_time_of_loss'],
							   "If nobody, how long has the property been vacant" => $datLogs['other_how_long_has_the_property_been_vacant'],
							   "Have you called emergency services? Who? When did they get there?" => $datLogs['other_called_emergency_services'],
							   "Describe any damage to other structures? (fences, sheds, outbuildings)" => $datLogs['other_describe_of_other_structure'],
							   "Describe any damage to persojnal property? (clothing, furniture)" => $datLogs['other_describe_personal_property'],
							   "If theft/burglary loss try to ask the insured what items were stolen" => $datLogs['what_items_were_stolen'],
							   "If THEFT / BURGLARY / VANDALISM try to ask If they filed a police report and ask for their police report no" => $datLogs['theft_loss_police_report_other'],
							   "Do you need a place to stay tonight?" => $datLogs['other_can_you_stay_home_tonight'],
							);
					break;
				default:
					# code...
					break;
			}
			
			
			// EMAIL BODY 			
		    switch ($datLogs['maintype']) {

		    	case 'cps':
		    	$dataarray = array(
				    		   "Date of Loss" =>$datLogs['date_of_loss'],
							   "Policy Number" => $datLogs['policy_number'], 
							   "Related to Catastrophe" => $datLogs['related_to_catastrophe'], 
							   "What Catastrophe" => $datLogs['catastrophe'], 
							   "Relationship to Insured" => $datLogs['insured'],
							   "Policy Holder" => !empty($datLogs['r_policy_holder']) ? $datLogs['r_policy_holder'] : "-",
							   "Policy Holder Phone Number" => !empty($datLogs['r_policy_phone']) ? $datLogs['r_policy_phone'] : "-",
							   "Firm/Contractor Name" => !empty($datLogs['r_policy_firm']) ? $datLogs['r_policy_firm'] : "-",
							   "Address" => $datLogs['address'],
							   "City" => $datLogs['city'],
							   "State" => $datLogs['state'],
							   "Zipcode" => $datLogs['zipcode'],
							   "Primary Phone" => $datLogs['primary_phone'],
							   "Secondary Phone" => $datLogs['secondary_phone'],
							   "Primary Email" => $datLogs['primay_mail'],
							   "Secondary Email" => $datLogs['secondary_mail'],
							   "Loss Location" => $datLogs['loss_location'],
							   //"Location/Address Description" => $datLogs['location_address'],
							   "Loss Description" => $datLogs['loss_description'],

							   "Loss Type" => $stype
							);

		   		if ($stype == 'Water') {
		   			$dataarray = array_merge($dataarray,$waterarray);
		   		}else if($stype == 'Fire'){
		   			$dataarray = array_merge($dataarray,$firearray);
		   		}else if($stype == 'Other'){
		   			$dataarray = array_merge($dataarray,$otherarray);
		   		}else{}

		    	$nbody ='<h4><b>'.$h1tag.'</b></h4><br/>
						Please find the details below : <br/><br/>
						<table border="1" width="80%" cellpadding="0" cellspacing="0">';
						$nbody .= '<tr>
									<td style="background-color:powderblue;padding:2px 0px 2px 8px">Customer Name :</td>
									<td style="padding:2px 0px 2px 8px">'.$datLogs["first_name"] ." " .$datLogs["last_name"] .'</td>
								   </tr>';
						foreach ($dataarray as $key => $value) {
							//if ($value) {
								if(empty($value)){ $value = "-"; }
								$nbody .= '<tr>
												<td style="background-color:powderblue;padding:2px 0px 2px 8px">'.$key.' :</td>
												<td style="padding:2px 0px 2px 8px">'.$value .'</td>
								 		   </tr>';
							//}
						}
							
						$nbody .= '</table>
						<br/>
						<br/>';
						
					
					$nbody .= $additionalInfo;
								
		    		break;
		    	case 'ncps':
		    	$dataarray = array(
				    		   "Date of Loss" =>$datLogs['date_of_loss'],
							   "Policy Number" => $datLogs['policy_number'], 
							   "Related to Catastrophe" => $datLogs['related_to_catastrophe'], 
							   "What Catastrophe" => $datLogs['catastrophe'],  
							   "Relationship to Insured" => $datLogs['insured'],
							   "Policy Holder" => !empty($datLogs['r_policy_holder']) ? $datLogs['r_policy_holder'] : "-",
							   "Policy Holder Phone Number" => !empty($datLogs['r_policy_phone']) ? $datLogs['r_policy_phone'] : "-",
							   "Firm/Contractor Name" => !empty($datLogs['r_policy_firm']) ? $datLogs['r_policy_firm'] : "-",
							   "Address" => $datLogs['address'],
							   "City" => $datLogs['city'],
							   "State" => $datLogs['state'],
							   "Zipcode" => $datLogs['zipcode'],
							   "Primary Phone" => $datLogs['primary_phone'],
							   "Secondary Phone" => $datLogs['secondary_phone'],
							   "Primary Email" => $datLogs['primay_mail'],
							   "Secondary Email" => $datLogs['secondary_mail'],
							   "Loss Location" => $datLogs['loss_location'],
							   //"Location/Address Description" => $datLogs['location_address'],
							   "Loss Description" => $datLogs['loss_description'],

							   "Loss Type" => $stype
							);

		    	if ($stype == 'Water') {
		   			$dataarray = array_merge($dataarray,$waterarray);
		   		}else if($stype == 'Fire'){
		   			$dataarray = array_merge($dataarray,$firearray);
		   		}else if($stype == 'Other'){
		   			$dataarray = array_merge($dataarray,$otherarray);
		   		}else{}

		    	$nbody ='<h4><b>'.$h1tag.'</b></h4><br/>
						Please find the details below : </br></br>
						<table border="1" width="80%" cellpadding="0" cellspacing="0">';
						$nbody .= '<tr>
									<td style="background-color:powderblue;padding:2px 0px 2px 8px">Customer Name :</td>
									<td style="padding:2px 0px 2px 8px">'.$datLogs["first_name"] ." " .$datLogs["last_name"] .'</td>
								 </tr>';
						foreach ($dataarray as $key => $value) {
							//if ($value) {
								if(empty($value)){ $value = "-"; }
								$nbody .= '<tr>
												<td style="background-color:powderblue;padding:2px 0px 2px 8px">'.$key.' :</td>
												<td style="padding:2px 0px 2px 8px">'.$value .'</td>
								 		  </tr>';
							//}
						}
							
					$nbody .= '</table>
				<br/>
				<br/>';
				$nbody .= $additionalInfo;
						
		    		break;
		    	case 'als':
		    	$dataarray = array(
				    		   "Date of Loss" =>$datLogs['date_of_loss'],
							   "Policy Number" => $datLogs['policy_number'], 
							   "Related to Catastrophe" => $datLogs['related_to_catastrophe'], 
							   "What Catastrophe" => $datLogs['catastrophe'],  
							   "Relationship to Insured" => $datLogs['relationship_to_insured'],
							   "Policy Holder" => !empty($datLogs['r_policy_holder']) ? $datLogs['r_policy_holder'] : "-",
							   "Policy Holder Phone Number" => !empty($datLogs['r_policy_phone']) ? $datLogs['r_policy_phone'] : "-",
							   "Firm/Contractor Name" => !empty($datLogs['r_policy_firm']) ? $datLogs['r_policy_firm'] : "-",
							   "Address" => $datLogs['address'],
							   "City" => $datLogs['city'],
							   "State" => $datLogs['state'],
							   "Zipcode" => $datLogs['zipcode'],
							   "Primary Phone" => $datLogs['primary_phone'],
							   "Secondary Phone" => $datLogs['secondary_phone'],
							   "Primary Email" => $datLogs['primay_mail'],
							   "Secondary Email" => $datLogs['secondary_mail'],
							   "Loss Location" => $datLogs['loss_location'],
							   //"Location/Address Description" => $datLogs['location_address'],
							   "Loss Description" => $datLogs['loss_description'],

							   "Police Called" => $datLogs['police_called'],
							   "Police Arrived" => $datLogs['police_arrived'],
							   "Report Taken" => $datLogs['report_taken'],
							   "Report ID & Department" => $datLogs['report_id'],

							   "Name of Claimant" => $datLogs['name_of_claimant'],
							   "Address of Claimant" => $datLogs['address_of_claimant'],
							   "Phone Number of Claimant" => $datLogs['phone_number_of_claimant'],
							   "E-mail Address of Claimant" => $datLogs['email_of_claimant'],
							   "Were there any Injuries?" => $datLogs['types_of_injuries'],
							   "If yes, Please describe injuries details" => $datLogs['injuries'],
							   "Are any parties represented by at attorney?" => $datLogs['parties_represented'],
							   "Name of Attorny and Contact" => $datLogs['name_of_attrony']
							);

		    	$nbody ='<h4><b>'.$h1tag.'</b></h4><br/>
						Please find the details below : <br/><br/>
						<table border="1" width="80%" cellpadding="0" cellspacing="0">';
						$nbody .= '<tr>
									<td style="background-color:powderblue;padding:2px 0px 2px 8px">Customer Name :</td>
									<td style="padding:2px 0px 2px 8px">'.$datLogs["first_name"] ." " .$datLogs["last_name"] .'</td>
								   </tr>';
						foreach ($dataarray as $key => $value) {
							//if ($value) {
								if(empty($value)){ $value = "-"; }
								$nbody .= '<tr>
												<td style="background-color:powderblue;padding:2px 0px 2px 8px">'.$key.' :</td>
												<td style="padding:2px 0px 2px 8px">'.$value .'</td>
								 		  </tr>';
							//}
						}
							
					$nbody .= '</table>
						<br/>
						<br/>';
					$nbody .= $additionalInfo;
								
		    		break;
		    	case 'aas':
		    	$dataarray = array(
				    		   "Date of Loss" =>$datLogs['date_of_loss'],
							   "Policy Number" => $datLogs['policy_number'], 
							   "Related to Catastrophe" => $datLogs['related_to_catastrophe'], 
							   "What Catastrophe" => $datLogs['catastrophe'],  
							   "Relationship to Insured" => $datLogs['relationship_to_insured'],
							   "Policy Holder" => !empty($datLogs['r_policy_holder']) ? $datLogs['r_policy_holder'] : "-",
							   "Policy Holder Phone Number" => !empty($datLogs['r_policy_phone']) ? $datLogs['r_policy_phone'] : "-",
							   "Firm/Contractor Name" => !empty($datLogs['r_policy_firm']) ? $datLogs['r_policy_firm'] : "-",
							   "Address" => $datLogs['address'],
							   "City" => $datLogs['city'],
							   "State" => $datLogs['state'],
							   "Zipcode" => $datLogs['zipcode'],
							   "Primary Phone" => $datLogs['primary_phone'],
							   "Secondary Phone" => $datLogs['secondary_phone'],
							   "Primary Email" => $datLogs['primay_mail'],
							   "Secondary Email" => $datLogs['secondary_mail'],
							   "Loss Location" => $datLogs['loss_location'],
							   //"Location/Address Description" => $datLogs['location_address'],
							   "Loss Description" => $datLogs['loss_description'],

							   "Police Called" => $datLogs['police_called'],
							   "Police Arrived" => $datLogs['police_arrived'],
							   "Report Taken" => $datLogs['report_taken'],
							   "Report ID & Department" => $datLogs['report_id'],

							   "Year, Make, Model, Plate of Insured Vehicle Driven" => $datLogs['model_of_insured_vehicle'],
							   "Year, Make, Model, Plate of Claimant Vehicle Driven" => $datLogs['model_of_claimant_vehicle'],
							   "Name of Claimant Driver" => $datLogs['name_of_claimant_driver'],
							   "Address of Claimant Driver" => $datLogs['address_of_claimant_driver'],
							   "Phone Number of Claimant" => $datLogs['phone_number_of_claimant'],
							   "E-mail Address of Claimant" => $datLogs['email_of_claimant'],
							   "Did any vehicles have a child restraint/carseat? If so, please indentify vehicle" => $datLogs['child_restraint'],

							   "Is the vehicle driveable? If not - Where is it located? Who towed?" => $datLogs['vehicle_driveable'],
							   "Any Passengers? If yes" => $datLogs['any_passengers'],
							   "Name of the passengers?" => $datLogs['name_of_passengers'],
							   "Were there any Injuries?" => $datLogs['types_of_injuries'],
							   "Injuries Details" => $datLogs['injuries_details'],
							);

		    	$nbody ='<h4><b>'.$h1tag.'</b></h4><br/>
						Please find the details below : <br/><br/>
						<table border="1" width="80%" cellpadding="0" cellspacing="0">';
						$nbody .= '<tr>
									<td style="background-color:powderblue;padding:2px 0px 2px 8px">Customer Name :</td>
									<td style="padding:2px 0px 2px 8px">'.$datLogs["first_name"] ." " .$datLogs["last_name"] .'</td>
								   </tr>';
						foreach ($dataarray as $key => $value) {
							//if ($value) {
								if(empty($value)){ $value = "-"; }
								$nbody .= '<tr>
												<td style="background-color:powderblue;padding:2px 0px 2px 8px">'.$key.' :</td>
												<td style="padding:2px 0px 2px 8px">'.$value .'</td>
								 		  </tr>';
							//}
						}
							
							$nbody .= '</table>
						<br/>
						<br/>';
					$nbody .= $additionalInfo;
								
		    		break;

		    	case 'caef':
					$policyNumber = !empty($datLogs['policy_number']) ? $datLogs['policy_number'] : "n/a";
					$claimNumber = !empty($datLogs['claim']) ? $datLogs['claim'] : "n/a";
		    		$nbody='<h4><b>'.$h1tag.'</b></h4><br/>
							<b>Please find the details below :</b> <br/><br/>
							<b>Caller Name: '.strtoupper($datLogs['callername']) .'</b><br/>
							<b>Return Call Number : '.$datLogs['return_call_number'] .'</b><br/>
							<b>Caller Email : </b>'.$datLogs['email'] .'<br/>
							<b>Reason for Call : </b>'.$datLogs['reason_for_call'] .'<br/>
							<b>Policy Number : </b>'.$policyNumber .'<br/>
							<b>Claim : </b>'.$claimNumber .'<br/>
							<br/>
							<br/>';
					$nbody .= $additionalInfo;
			
		    		break;
		    	
		    	default:
		    		# code...
		    		break;
		    }
			
			
			$this->Email_model->send_email_sox($uid, $eto, $ecc, $nbody, $email_subject, "", $from_email, $from_name,'N');	
			//$this->test_send_email_sox($uid, $eto, $ecc, $nbody, $email_subject, "", $from_email, $from_name,'N');
		}			
				
	}
	
	/// ================== ONLY FOR TESTING PURPOSE ===========================================================//
	
	public function test_send_email_sox($uid,$eto,$ecc,$ebody,$esubject,$attch_file="",$from_email="noreply.fems@fusionbposervices.com",$from_name="Fusion FEMS", $isBcc="Y")
	{
		
		$ebody .="<br/><br/><p style='font-size:9px'>Note: please do not reply.</p>";
		
		if(trim($from_email)=="")$from_email="noreply.fems@fusionbposervices.com";
		if(trim($from_name)=="")$from_name="Fusion FEMS";
		
		//Open it for testing
		$esubject = " TEST - " . $esubject;
		
		$eto = str_replace(';', ',', $eto);
		$ecc = str_replace(';', ',', $ecc);
		
		//Open it for testing and add your email id
		//$eto = 'sachin.paswan@fusionbposervices.com';
		//$ecc = 'sachin.paswan@fusionbposervices.com';
		
		$this->load->library('email');
		$this->email->clear(TRUE);
		
		$this->email->set_newline("\r\n");
		$this->email->from($from_email, $from_name);
		
		$this->email->to($eto);
		
		if($ecc!="") $this->email->cc($ecc);
		
		//$this->email->bcc('kunal.bose@fusionbposervices.com, saikat.ray@fusionbposervices.com, manash.kundu@fusionbposervices.com, arif.anam@fusionbposervices.com');
		//if($isBcc=="Y") $this->email->bcc('saikat.ray@fusionbposervices.com, kunal.bose@fusionbposervices.com');
				
		$this->email->subject($esubject);
		$this->email->message($ebody);
				
		if($attch_file!="") $this->email->attach($attch_file);
		
		//-----------------------------------//
		$ebody=addslashes($ebody);
		$eto=addslashes($eto);
		$esubj=addslashes($esubject);
		
		$myCDate=CurrMySqlDate();	
		if($eto!=""){
			if($this->email->send()){
				return true;
			}else{
				$log=addslashes($this->email->print_debugger());
				return false;
				//show_error($this->email->print_debugger());
			}
		}
		
		
	}
	
	
	//=================================== CRM REPORT =============================================//
	
	public function report()
	{
		$is_global_access=get_global_access();
		$role_id        = get_role_id();
		$current_user   = get_user_id();
		$role_dir       = get_role_dir();			
		$user_office_id = get_user_office_id();
		$ses_dept_id    = get_dept_id();	
		
		$get_client_id  = get_client_ids(); 
		$get_process_id = get_process_ids(); 
		$get_user_site_id = get_user_site_id();
		
		$data["aside_template"] = "k2_claims_crm/aside.php";
		$data["content_template"] = "k2_claims_crm/k2_claims_crm_reports.php";				
		
		$this->load->view('dashboard',$data);
	}
	
	public function report_agent()
	{
		$is_global_access=get_global_access();
		$role_id        = get_role_id();
		$current_user   = get_user_id();
		$role_dir       = get_role_dir();			
		$user_office_id = get_user_office_id();
		$ses_dept_id    = get_dept_id();	
		
		$get_client_id  = get_client_ids(); 
		$get_process_id = get_process_ids(); 
		$get_user_site_id = get_user_site_id();
		
		// TABLES
		$data['tableArray'] = $tableArray = array(			
			"0" => array( "name" => "New Loss California Property", "table" => "k2_claims_crm_cps" ),        
			"1" => array( "name" => "New Loss No California Property", "table" => "k2_claims_crm_ncps" ),
			"2" => array( "name" => "New Loss Liability", "table" => "k2_claims_crm_als" ),
			"3" => array( "name" => "New Loss Auto-Motorcycle", "table" => "k2_claims_crm_aas" ),
			"4" => array( "name" => "Calling About Existing Claim", "table" => "k2_claims_crm_caef" ),
			"5" => array( "name" => "Other Issue", "table" => "k2_claims_crm_oi" ),      
		);
		
		$extraTotal = "";
		$agentArray['overall'] = array();
		foreach($tableArray as $token)
		{
			$tableName = $token['table'];
			$formName = $token['name'];
			$sql = "SELECT c.added_by as agent_id, CONCAT(s.fname, ' ', s.lname) as agent_name, s.fusion_id, count(c.id) as total from $tableName as c INNER JOIN signin as s ON s.id = c.added_by WHERE 1 $extraTotal GROUP BY c.added_by";
			$listquery = $this->Common_model->get_query_result_array($sql);
			$agent_list = $this->array_indexed($listquery, 'agent_id');
			$agentArray[$tableName] = $agent_list;
			$agentArray['overall'] += $agent_list;		
		}
		//echo "<pre>".print_r($agentArray, 1)."</pre>"; die();
		$data['agent_list'] = $agentArray;
		$data["aside_template"] = "k2_claims_crm/aside.php";
		$data["content_template"] = "k2_claims_crm/k2_claims_crm_reports_agents.php";				
		
		$this->load->view('dashboard',$data);
	}
	
	
	public function report_draft()
	{
		$is_global_access=get_global_access();
		$role_id        = get_role_id();
		$current_user   = get_user_id();
		$role_dir       = get_role_dir();			
		$user_office_id = get_user_office_id();
		$ses_dept_id    = get_dept_id();	
		
		$get_client_id  = get_client_ids(); 
		$get_process_id = get_process_ids(); 
		$get_user_site_id = get_user_site_id();
		
		// TABLES
		$data['tableArray'] = $tableArray = array(			
			"0" => array( "name" => "New Loss California Property", "table" => "k2_claims_crm_cps" ),        
			"1" => array( "name" => "New Loss No California Property", "table" => "k2_claims_crm_ncps" ),
			"2" => array( "name" => "New Loss Liability", "table" => "k2_claims_crm_als" ),
			"3" => array( "name" => "New Loss Auto-Motorcycle", "table" => "k2_claims_crm_aas" ),
			"4" => array( "name" => "Calling About Existing Claim", "table" => "k2_claims_crm_caef" ),
			"5" => array( "name" => "Other Issue", "table" => "k2_claims_crm_oi" ),      
		);
		
		$extraTotal = "";
		$agentArray['overall'] = array();
		foreach($tableArray as $token)
		{
			$tableName = $token['table'];
			$formName = $token['name'];
			$sql = "SELECT c.added_by as agent_id, CONCAT(s.fname, ' ', s.lname) as agent_name, s.fusion_id, count(c.id) as total from $tableName as c INNER JOIN signin as s ON s.id = c.added_by WHERE 1 $extraTotal GROUP BY c.added_by";
			$listquery = $this->Common_model->get_query_result_array($sql);
			$agent_list = $this->array_indexed($listquery, 'agent_id');
			$agentArray[$tableName] = $agent_list;
			$agentArray['overall'] += $agent_list;		
		}
		//echo "<pre>".print_r($agentArray, 1)."</pre>"; die();
		$data['agent_list'] = $agentArray;
		$data["aside_template"] = "k2_claims_crm/aside.php";
		$data["content_template"] = "k2_claims_crm/k2_claims_crm_reports_drafts.php";				
		
		$this->load->view('dashboard',$data);
	}
	
	
	//=================================== REPORT FORM =============================================//
	
	public function process_reportform()
	{  
		$startdate = date('Y-m-d');
		$enddate = date('Y-m-d');
		$maintype = '';
		$agent_id = '';
		$report_type = 'active';
		if(!empty($this->input->post('startdate'))) {
			$startdate = $this->input->post('startdate');
			$enddate = $this->input->post('enddate');
			$maintype = $this->input->post('maintype');
		}
		if(!empty($this->input->post('agent_id'))) {	
			$agent_id = $this->input->post('agent_id');
		}
		if(!empty($this->input->post('report_type'))){			
			$report_type = $this->input->post('report_type');
		}

		switch ($maintype) {
			case 'cps':
				$table = 'k2_claims_crm_cps';
				$title = 'New Loss California Property';
				//$this->generate_cps_report_xls($startdate, $enddate, $table, $title);
				$this->generate_report_excel_all_lob_feedback_xls($startdate, $enddate, $agent_id, '0', $report_type);
				break;

			case 'ncps':
				$table = 'k2_claims_crm_ncps';
				$title = 'New Loss No California Property';
				//$this->generate_ncps_report_xls($startdate, $enddate, $table, $title);
				$this->generate_report_excel_all_lob_feedback_xls($startdate, $enddate, $agent_id, 1, $report_type);
				break;

			case 'als':
				$table = 'k2_claims_crm_als';
				$title = 'New Loss Liability';
				//$this->generate_als_report_xls($startdate, $enddate, $table, $title);
				$this->generate_report_excel_all_lob_feedback_xls($startdate, $enddate, $agent_id, 2, $report_type);
				break;

			case 'aas':
				$table = 'k2_claims_crm_aas';
				$title = 'New Loss Auto-Motorcycle';
				//$this->generate_aas_report_xls($startdate, $enddate, $table, $title);
				$this->generate_report_excel_all_lob_feedback_xls($startdate, $enddate, $agent_id, 3, $report_type);
				break;

			case 'caef':
				$table = 'k2_claims_crm_caef';
				$title = 'Calling About Existing Claim';
				//$this->generate_caef_report_xls($startdate, $enddate, $table, $title);
				$this->generate_report_excel_all_lob_feedback_xls($startdate, $enddate, $agent_id, 4, $report_type);
				break;

			case 'oi':
				$table = 'k2_claims_crm_oi';
				$title = 'Other Issue';
				//$this->generate_oi_report_xls($startdate, $enddate, $table, $title);
				$this->generate_report_excel_all_lob_feedback_xls($startdate, $enddate, $agent_id, 5, $report_type);
				break;
				
			case 'all':
				$this->generate_report_excel_all_lob_feedback_xls($startdate, $enddate, $agent_id, 'all', $report_type);
				break;
			
			default:
				# code...
				break;
		}

	}
	
	//=================================== REPORT EXCEL GENERATE =============================================//
	
	
	public function generate_report_excel_all_lob_feedback_xls($startdate="", $enddate="", $agent_id="", $type='all', $report_type='active')
	{
		$current_user = get_user_id();
		$user_site_id = get_user_site_id();
		$user_office_id = get_user_office_id();
		$user_oth_office = get_user_oth_office();
		$is_global_access = get_global_access();
		$is_role_dir = get_role_dir();
		$get_dept_id = get_dept_id();
		
		$extraFilter = "";
		if(!empty($agent_id) && $agent_id != 'all'){
			$extraFilter .= " AND t.added_by = '$agent_id'";
		}
		if($report_type == 'draft'){
			$extraFilter .= "  AND t.is_active='0'";
		} else {
			$extraFilter .= " AND t.is_active='1'";
		}
		
		$tableArray = array(			
			"0" => array( "name" => "New Loss California Property", "table" => "k2_claims_crm_cps" ),        
			"1" => array( "name" => "New Loss No California Property", "table" => "k2_claims_crm_ncps" ),
			"2" => array( "name" => "New Loss Liability", "table" => "k2_claims_crm_als" ),
			"3" => array( "name" => "New Loss Auto Motorcycle", "table" => "k2_claims_crm_aas" ),
			"4" => array( "name" => "Calling About Existing Claim", "table" => "k2_claims_crm_caef" ),
			"5" => array( "name" => "Other Issue", "table" => "k2_claims_crm_oi" ),      
		);
		
		$CurWorksheet = -1;
		
		//============================================== AGENT WISE
		if($agent_id != ""){
			$title = "AGENT REPORT";
			$CurWorksheet++;
			$this->objPHPExcel->createSheet($CurWorksheet);
			$this->objPHPExcel->setActiveSheetIndex($CurWorksheet);
			$objWorksheet = $this->objPHPExcel->getActiveSheet($CurWorksheet);
			$objWorksheet->setTitle($title);
			
			$objWorksheet->setShowGridlines(true);
			$this->objPHPExcel->getDefaultStyle()->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->objPHPExcel->getDefaultStyle()->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			$this->objPHPExcel->getActiveSheet($CurWorksheet)->getStyle('A1:K1'.$this->objPHPExcel->getActiveSheet($CurWorksheet)->getHighestRow())->getAlignment()->setWrapText(true);
			$objWorksheet->getColumnDimension('A')->setAutoSize(true);
			$objWorksheet->getColumnDimension('B')->setAutoSize(true); 
			$objWorksheet->getColumnDimension('C')->setAutoSize(true);
			$objWorksheet->getColumnDimension('D')->setAutoSize(true);
			$objWorksheet->getColumnDimension('E')->setAutoSize(true);
			$objWorksheet->getColumnDimension('F')->setAutoSize(true);
			$objWorksheet->getColumnDimension('G')->setAutoSize(true);
			$objWorksheet->getColumnDimension('H')->setAutoSize(true);
			$objWorksheet->getColumnDimension('I')->setAutoSize(true);
			$objWorksheet->getColumnDimension('J')->setAutoSize(true); 
			$objWorksheet->getColumnDimension('K')->setAutoSize(true);
			
			$r=0; $c = 2;
			$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Sl");
			$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Date Added");
			$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Fusion ID");
			$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Agent Name");
			$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Name of Caller");
			$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Form Type");

			$agentDataArray = array();
			foreach($tableArray as $token){
				$tablename = $token['table'];
				$formtype = $token['name'];
				$caller_name = "";
				if($tablename == 'k2_claims_crm_cps'){ $caller_name = ",CONCAT(first_name, ' ', last_name) as caller_name"; }
				if($tablename == 'k2_claims_crm_ncps'){ $caller_name = ",CONCAT(first_name, ' ', last_name) as caller_name"; }
				if($tablename == 'k2_claims_crm_als'){ $caller_name = ",CONCAT(first_name, ' ', last_name) as caller_name"; }
				if($tablename == 'k2_claims_crm_aas'){ $caller_name = ",CONCAT(first_name, ' ', last_name) as caller_name"; }
				if($tablename == 'k2_claims_crm_caef'){ $caller_name = ",callername as caller_name"; }
				if($tablename == 'k2_claims_crm_oi'){ $caller_name = ",callername as caller_name"; }
				
				$extraFilterDraft = "";
				if($report_type == 'draft'){
					$extraFilterDraft = "  AND t.draft_id NOT IN (SELECT r.draft_id from $tablename as r WHERE r.is_active = '1' AND r.draft_id IS NOT NULL)";
				}
				
				$reports_sql = "SELECT DATE(t.created_at) as date_added, t.created_at, CONCAT(s.fname,' ', s.lname) as fullname, s.office_id, s.fusion_id, r.name as designation, 
				        get_process_names(s.id) as process_name, '$formtype' as form_type $caller_name FROM $tablename as t 
		                LEFT JOIN signin as s ON s.id = t.added_by 
		                LEFT JOIN role as r ON r.id = s.role_id 
		                WHERE DATE(t.created_at) >= '$startdate' AND DATE(t.created_at) <= '$enddate' $extraFilter $extraFilterDraft ORDER by t.id DESC";
				$querySql = $this->Common_model->get_query_result_array($reports_sql);
				if(!empty($querySql)){
					$agentDataArray = array_merge_recursive($agentDataArray, $querySql);
				}				
			}
			
			usort($agentDataArray, function($a, $b) {
			  return new DateTime($b['created_at']) <=> new DateTime($a['created_at']);
			});
			
			$styleArray = array(
				'font'  => array(
					'bold'  => true,
					'color' => array('rgb' => 'FFFFFF'),
					'size'  => 10
			));
						
			$headerArray = array(
				'font'  => array(
					'bold'  => true,
					'color' => array('rgb' => '000000'),
					'size'  => 14
			));
		
			$this->objPHPExcel->setActiveSheetIndex($CurWorksheet)->mergeCells('A1:K1');
			$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValue('A1', "K2 CLAIMS CRM - Agent Report");
			$this->objPHPExcel->getActiveSheet($CurWorksheet)->getRowDimension('1')->setRowHeight(40);
			$this->objPHPExcel->getActiveSheet($CurWorksheet)->getStyle('A1')->applyFromArray($headerArray);
		
		
			$this->objPHPExcel->getActiveSheet($CurWorksheet)->getStyle('A2:K2')->applyFromArray($styleArray);
			$this->objPHPExcel->getActiveSheet($CurWorksheet)->getStyle('A2:K2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('000000');
		
			$sl=0;
			foreach($agentDataArray as $wk=>$wv)
			{
				$sl++;
				$agent_id = $wv['added_by'];

				$c++; $r=0; 
				$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $sl);
				$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv["created_at"]);
				$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv["fusion_id"]);
				$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv["fullname"]);
				//$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv["office_id"]);
				//$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv["process_name"]);
				//$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv["designation"]);

				$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv["caller_name"]);
				$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv["form_type"]);
			}
		
		
		}
		
		
		//============================================== New Loss California Property
		if($type == 'all' || $type == 0){
		$CurWorksheet++; 
		$tableType = 0;
		$tablename = $tableArray[$tableType]['table'];
		$title = $tableArray[$tableType]['name'];
		
		$extraFilterDraft = "";
		if($report_type == 'draft'){
			$extraFilterDraft = "  AND t.draft_id NOT IN (SELECT r.draft_id from $tablename as r WHERE r.is_active = '1' AND r.draft_id IS NOT NULL)";
		}
				
		$reports_sql = "SELECT t.*, CONCAT(s.fname,' ', s.lname) as fullname, s.office_id, s.fusion_id, r.name as designation, get_process_names(s.id) as process_name 
		                FROM $tablename as t 
		                LEFT JOIN signin as s ON s.id = t.added_by 
		                LEFT JOIN role as r ON r.id = s.role_id 
		                WHERE DATE(t.created_at) >= '$startdate' AND DATE(t.created_at) <= '$enddate' $extraFilter $extraFilterDraft ORDER by t.id DESC"; 
		$report_list = $this->Common_model->get_query_result_array($reports_sql);

		$this->objPHPExcel->createSheet($CurWorksheet);
		$this->objPHPExcel->setActiveSheetIndex($CurWorksheet);
		$objWorksheet = $this->objPHPExcel->getActiveSheet($CurWorksheet);
		$objWorksheet->setTitle($title);
		
		$objWorksheet->setShowGridlines(true);
		$this->objPHPExcel->getDefaultStyle()->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->objPHPExcel->getDefaultStyle()->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$this->objPHPExcel->getActiveSheet($CurWorksheet)->getStyle('A1:N1'.$this->objPHPExcel->getActiveSheet($CurWorksheet)->getHighestRow())->getAlignment()->setWrapText(true);
		$objWorksheet->getColumnDimension('A')->setAutoSize(true);
		$objWorksheet->getColumnDimension('B')->setAutoSize(true); 
		$objWorksheet->getColumnDimension('C')->setAutoSize(true);
		$objWorksheet->getColumnDimension('D')->setAutoSize(true);
		$objWorksheet->getColumnDimension('E')->setAutoSize(true);
		$objWorksheet->getColumnDimension('F')->setAutoSize(true);
		$objWorksheet->getColumnDimension('G')->setAutoSize(true);
		$objWorksheet->getColumnDimension('H')->setAutoSize(true);
		$objWorksheet->getColumnDimension('I')->setAutoSize(true);
		$objWorksheet->getColumnDimension('J')->setAutoSize(true); 
		$objWorksheet->getColumnDimension('K')->setAutoSize(true); 
		$objWorksheet->getColumnDimension('L')->setAutoSize(true);
		$objWorksheet->getColumnDimension('M')->setAutoSize(true);
		$objWorksheet->getColumnDimension('N')->setAutoSize(true);
		$objWorksheet->getColumnDimension('O')->setAutoSize(true);
		$objWorksheet->getColumnDimension('P')->setAutoSize(true);
		$objWorksheet->getColumnDimension('Q')->setAutoSize(true);
		$objWorksheet->getColumnDimension('R')->setAutoSize(true);
		$objWorksheet->getColumnDimension('S')->setAutoSize(true);
		$objWorksheet->getColumnDimension('T')->setAutoSize(true);
		$objWorksheet->getColumnDimension('U')->setAutoSize(true);
		$objWorksheet->getColumnDimension('V')->setAutoSize(true);
		$objWorksheet->getColumnDimension('U')->setAutoSize(true);
		$objWorksheet->getColumnDimension('X')->setAutoSize(true);
		$objWorksheet->getColumnDimension('Y')->setAutoSize(true);
		$objWorksheet->getColumnDimension('Z')->setAutoSize(true);
		$objWorksheet->getColumnDimension('AA')->setAutoSize(true);
		$objWorksheet->getColumnDimension('AB')->setAutoSize(true);
		$objWorksheet->getColumnDimension('AC')->setAutoSize(true);
		$objWorksheet->getColumnDimension('AD')->setAutoSize(true);
		$objWorksheet->getColumnDimension('AE')->setAutoSize(true);
		$objWorksheet->getColumnDimension('AF')->setAutoSize(true);
		$objWorksheet->getColumnDimension('AG')->setAutoSize(true);
		$objWorksheet->getColumnDimension('AH')->setAutoSize(true);
		$objWorksheet->getColumnDimension('AI')->setAutoSize(true);
		$objWorksheet->getColumnDimension('AJ')->setAutoSize(true);
		$objWorksheet->getColumnDimension('AK')->setAutoSize(true);
		$objWorksheet->getColumnDimension('AL')->setAutoSize(true);
		$objWorksheet->getColumnDimension('AM')->setAutoSize(true);
		$objWorksheet->getColumnDimension('AN')->setAutoSize(true);
		$objWorksheet->getColumnDimension('AO')->setAutoSize(true);
		$objWorksheet->getColumnDimension('AP')->setAutoSize(true);
		$objWorksheet->getColumnDimension('AQ')->setAutoSize(true);
		$objWorksheet->getColumnDimension('AR')->setAutoSize(true);
		$objWorksheet->getColumnDimension('AS')->setAutoSize(true);
		$objWorksheet->getColumnDimension('AT')->setAutoSize(true);
		$objWorksheet->getColumnDimension('AU')->setAutoSize(true);
		$objWorksheet->getColumnDimension('AV')->setAutoSize(true);
		$objWorksheet->getColumnDimension('AW')->setAutoSize(true);
		$objWorksheet->getColumnDimension('AX')->setAutoSize(true);
		$objWorksheet->getColumnDimension('AY')->setAutoSize(true);
		$objWorksheet->getColumnDimension('AZ')->setAutoSize(true);
		$objWorksheet->getColumnDimension('BA')->setAutoSize(true);
		$objWorksheet->getColumnDimension('BB')->setAutoSize(true);
		$objWorksheet->getColumnDimension('BC')->setAutoSize(true);
		
		$r=0; $c = 2;
		$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Sl");
		$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Date Added");
		$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Fusion ID");
		$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Agent Name");
		//$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Office");
		//$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Process");
		//$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Designation");

		$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Name of Caller");
		$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Date of Loss");
		$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Policy Number");
		$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Related to Catastrophe");
		$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Relationship to Insured");
		$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Policy Holder");
		$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Policy Holder Phone Number");
		$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Firm/Contractor Name");
		$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Address");		
		$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "City");
		$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "State");
		$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Zipcode");
		$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Primary Phone");
		$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Secondary Phone");
		$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Primary Email");
		$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Secondary Email");
		$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Loss Location");
		//$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Location/Address Description");
		$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Loss Description");
		$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Loss Type");

		$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "What is the source of the water");
		$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Have you called a plumber? Who?");
		$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "How many rooms are affected?");
		$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Who was living in the house at the time of the loss?");
		$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "If nobody, how long has the property been vacant?");
		$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Have you called emergency servcies? Who? When did they get there?");
		$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "If no, do they need emergency services?");
		$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Describe any damage to other structures? (fences, sheds, outbuildings)");
		$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Describe any damage to personal property? (clothing, furniture)");
		$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Can you stay in the home tonight?");

		$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Where did the fire start?");
		$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Did the fire department respond?");
		$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "How many rooms are affected?");
		$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Who was living in the house at the time of the loss?");
		$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "If nobody, how long has the property been vacant?");
		$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Have you called emergency services/board up? Who? When did they get there?");
		$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "If no, do they need emergency services?");
		$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Describe any damage to other structures? (fences, sheds, outbuildings)");
		$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Describe any damage to personal property? (clothing, furniture)");
		$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Can you stay in the home tonight?");

		$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Where are the damages located?");
		$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "How many rooms are affected?");
		$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Who was living in the house at the time of the loss?");
		$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "If nobody, how long has the property been vacant");
		$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Have you called emergency services? Who? When did they get there?");
		$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Describe any damage to other structures? (fences, sheds, outbuildings)");
		$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Describe any damage to persojnal property? (clothing, furniture)");
		$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "If theft/burglary loss try to ask the insured what items were stolen");
		$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "If THEFT / BURGLARY / VANDALISM try to ask If they filed a police report and ask for their police report no");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Can you stay in the home tonight?");
				
		$styleArray = array(
		'font'  => array(
			'bold'  => true,
			'color' => array('rgb' => 'FFFFFF'),
			'size'  => 10
		));
				
		$headerArray = array(
		'font'  => array(
			'bold'  => true,
			'color' => array('rgb' => '000000'),
			'size'  => 14
		));
		
		$this->objPHPExcel->setActiveSheetIndex($CurWorksheet)->mergeCells('A1:J1');
		$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValue('A1', "K2 CRM - New Loss California Property");
		$this->objPHPExcel->getActiveSheet($CurWorksheet)->getRowDimension('1')->setRowHeight(40);
		$this->objPHPExcel->getActiveSheet($CurWorksheet)->getStyle('A1')->applyFromArray($headerArray);
		
		
		$this->objPHPExcel->getActiveSheet($CurWorksheet)->getStyle('A2:BC2')->applyFromArray($styleArray);
		$this->objPHPExcel->getActiveSheet($CurWorksheet)->getStyle('A2:BC2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('000000');
		//$this->objPHPExcel->getActiveSheet()->getStyle('K1:O1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FEEC9F');
		//$this->objPHPExcel->getActiveSheet()->getStyle('P1:V1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('BBF7F0');
		
		$sl=0;
		foreach($report_list as $wk=>$wv)
		{
			$sl++;
			$agent_id = $wv['added_by'];

			switch ($wv["type"]) {
				case 'cpswater':
					$stype = 'Water';
				break;
				case 'cpsfire':
					$stype = 'Fire';
				break;
				case 'cpsother':
					$stype = 'Other';
				break;
				case 'ncpswater':
					$stype = 'Water';
				break;
				case 'ncpsfire':
					$stype = 'Fire';
				break;
				case 'ncpsother':
					$stype = 'Other';
				break;
				default:
				break;
			}

			$c++; $r=0; 
			$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $sl);
			$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv["created_at"]);
			$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv["fusion_id"]);
			$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv["fullname"]);
			//$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["office_id"]);
			//$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["process_name"]);
			//$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["designation"]);
			
			
			$related_catastrophe = $wv["related_to_catastrophe"];
			$catastrophe = $wv["related_to_catastrophe"] == "no" ? 'No' : $wv["catastrophe"];
			
			
			$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv["first_name"]." ".$wv["last_name"]);
			$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv["date_of_loss"]);
			$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv["policy_number"]);
			$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $catastrophe);			
			$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv["insured"]);
			$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv["r_policy_holder"]);
			$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv["r_policy_phone"]);
			$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv["r_policy_firm"]);
			$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv["address"]);
			$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv["city"]);
			$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv["state"]);
			$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv["zipcode"]);
			$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv["primary_phone"]);
			$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv["secondary_phone"]);
			$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv["primay_mail"]);		
			$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv["secondary_mail"]);		
			$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv["loss_location"]);		
			//$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $wv["location_address"]);		
			$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv["loss_description"]);	
			$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $stype);	

			$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv["souce_of_water"]);		
			$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv["plumber"]);		
			$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv["effected_rooms"]);		
			$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv["who_was_at_the_time_of_loss"]);		
			$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv["how_long_property_been_vacant"]);		
			$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv["emergency_services"]);	
			$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv["emergency_services_needed"]);		
			$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv["other_structure_damage"]);		
			$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv["personal_property_damage"]);
			$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv["stay_home_tonight"]);

			$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv["fire_source"]);		
			$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv["responce_of_fire_department"]);	
			$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv["effected_rooms_of_fire"]);		
			$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv["who_was_living_at_the_time_of_loss"]);		
			$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv["property_vacant_time_of_fire"]);		
			$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv["emergency_services_called"]);		
			$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv["do_they_need_emergency_services"]);		
			$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv["other_structure_damage_fire"]);	
			$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv["personal_property_damage_fire"]);		
			$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv["can_you_stay_in_the_home_tonight"]);	

			$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv["other_damages_located"]);		
			$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv["other_how_many_rooms_effected"]);		
			$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv["other_who_was_at_the_time_of_loss"]);		
			$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv["other_how_long_has_the_property_been_vacant"]);	
			$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv["other_called_emergency_services"]);		
			$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv["other_describe_of_other_structure"]);		
			$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv["other_describe_personal_property"]);		
			$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv["what_items_were_stolen"]);	
			$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv["theft_loss_police_report_other"]);	
			$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv["other_can_you_stay_home_tonight"]);
		}
		
		}
		
		
		//============================================== New Loss No California Property
		
		if($type == 'all' || $type == 1){
		$CurWorksheet++; $tableType = 1;
		$tablename = $tableArray[$tableType]['table'];
		$title = $tableArray[$tableType]['name'];
		
		$extraFilterDraft = "";
		if($report_type == 'draft'){
			$extraFilterDraft = "  AND t.draft_id NOT IN (SELECT r.draft_id from $tablename as r WHERE r.is_active = '1' AND r.draft_id IS NOT NULL)";
		}
		
		$reports_sql = "SELECT t.*, CONCAT(s.fname,' ', s.lname) as fullname, s.office_id, s.fusion_id, r.name as designation, get_process_names(s.id) as process_name 
		                FROM $tablename as t 
		                LEFT JOIN signin as s ON s.id = t.added_by 
		                LEFT JOIN role as r ON r.id = s.role_id 
		                WHERE DATE(t.created_at) >= '$startdate' AND DATE(t.created_at) <= '$enddate' $extraFilter $extraFilterDraft ORDER by t.id DESC";
		$report_list = $this->Common_model->get_query_result_array($reports_sql);

		$this->objPHPExcel->createSheet($CurWorksheet);
		$this->objPHPExcel->setActiveSheetIndex($CurWorksheet);
		$objWorksheet = $this->objPHPExcel->getActiveSheet($CurWorksheet);
		$objWorksheet->setTitle($title);
		
		$objWorksheet->setShowGridlines(true);
		$this->objPHPExcel->getDefaultStyle()->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->objPHPExcel->getDefaultStyle()->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$this->objPHPExcel->getActiveSheet($CurWorksheet)->getStyle('A1:N1'.$this->objPHPExcel->getActiveSheet()->getHighestRow())->getAlignment()->setWrapText(true);
		$objWorksheet->getColumnDimension('A')->setAutoSize(true);
		$objWorksheet->getColumnDimension('B')->setAutoSize(true); 
		$objWorksheet->getColumnDimension('C')->setAutoSize(true);
		$objWorksheet->getColumnDimension('D')->setAutoSize(true);
		$objWorksheet->getColumnDimension('E')->setAutoSize(true);
		$objWorksheet->getColumnDimension('F')->setAutoSize(true);
		$objWorksheet->getColumnDimension('G')->setAutoSize(true);
		$objWorksheet->getColumnDimension('H')->setAutoSize(true);
		$objWorksheet->getColumnDimension('I')->setAutoSize(true);
		$objWorksheet->getColumnDimension('J')->setAutoSize(true); 
		$objWorksheet->getColumnDimension('K')->setAutoSize(true); 
		$objWorksheet->getColumnDimension('L')->setAutoSize(true);
		$objWorksheet->getColumnDimension('M')->setAutoSize(true);
		$objWorksheet->getColumnDimension('N')->setAutoSize(true);
		$objWorksheet->getColumnDimension('O')->setAutoSize(true);
		$objWorksheet->getColumnDimension('P')->setAutoSize(true);
		$objWorksheet->getColumnDimension('Q')->setAutoSize(true);
		$objWorksheet->getColumnDimension('R')->setAutoSize(true);
		$objWorksheet->getColumnDimension('S')->setAutoSize(true);
		$objWorksheet->getColumnDimension('T')->setAutoSize(true);
		$objWorksheet->getColumnDimension('U')->setAutoSize(true);
		$objWorksheet->getColumnDimension('V')->setAutoSize(true);
		$objWorksheet->getColumnDimension('U')->setAutoSize(true);
		$objWorksheet->getColumnDimension('X')->setAutoSize(true);
		$objWorksheet->getColumnDimension('Y')->setAutoSize(true);
		$objWorksheet->getColumnDimension('Z')->setAutoSize(true);
		$objWorksheet->getColumnDimension('AA')->setAutoSize(true);
		$objWorksheet->getColumnDimension('AB')->setAutoSize(true);
		$objWorksheet->getColumnDimension('AC')->setAutoSize(true);
		$objWorksheet->getColumnDimension('AD')->setAutoSize(true);
		$objWorksheet->getColumnDimension('AE')->setAutoSize(true);
		$objWorksheet->getColumnDimension('AF')->setAutoSize(true);
		$objWorksheet->getColumnDimension('AG')->setAutoSize(true);
		$objWorksheet->getColumnDimension('AH')->setAutoSize(true);
		$objWorksheet->getColumnDimension('AI')->setAutoSize(true);
		$objWorksheet->getColumnDimension('AJ')->setAutoSize(true);
		$objWorksheet->getColumnDimension('AK')->setAutoSize(true);
		$objWorksheet->getColumnDimension('AL')->setAutoSize(true);
		$objWorksheet->getColumnDimension('AM')->setAutoSize(true);
		$objWorksheet->getColumnDimension('AN')->setAutoSize(true);
		$objWorksheet->getColumnDimension('AO')->setAutoSize(true);
		$objWorksheet->getColumnDimension('AP')->setAutoSize(true);
		$objWorksheet->getColumnDimension('AQ')->setAutoSize(true);
		$objWorksheet->getColumnDimension('AR')->setAutoSize(true);
		$objWorksheet->getColumnDimension('AS')->setAutoSize(true);
		$objWorksheet->getColumnDimension('AT')->setAutoSize(true);
		$objWorksheet->getColumnDimension('AU')->setAutoSize(true);
		$objWorksheet->getColumnDimension('AV')->setAutoSize(true);
		$objWorksheet->getColumnDimension('AW')->setAutoSize(true);
		$objWorksheet->getColumnDimension('AX')->setAutoSize(true);
		$objWorksheet->getColumnDimension('AY')->setAutoSize(true);
		$objWorksheet->getColumnDimension('AZ')->setAutoSize(true);
		$objWorksheet->getColumnDimension('BA')->setAutoSize(true);
		$objWorksheet->getColumnDimension('BB')->setAutoSize(true);
		$objWorksheet->getColumnDimension('BC')->setAutoSize(true);
		
		$r=0; $c = 2;
		$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Sl");
		$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Date Added");
		$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Fusion ID");
		$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Agent Name");
		//$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Office");
		//$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Process");
		//$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Designation");

		$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Name of Caller");
		$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Date of Loss");
		$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Policy Number");
		$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Related to Catastrophe");
		$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Relationship to Insured");
		$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Policy Holder");
		$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Policy Holder Phone Number");
		$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Firm/Contractor Name");
		$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Address");		
		$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "City");
		$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "State");
		$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Zipcode");
		$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Primary Phone");
		$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Secondary Phone");
		$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Primary Email");
		$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Secondary Email");
		$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Loss Location");
		//$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Location/Address Description");
		$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Loss Description");
		$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Loss Type");

		$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "What is the source of the water");
		$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Have you called a plumber? Who?");
		$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "How many rooms are affected?");
		$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Who was living in the house at the time of the loss?");
		$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "If nobody, how long has the property been vacant?");
		$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Have you called emergency servcies? Who? When did they get there?");
		$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "If no, do they need emergency services?");
		$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Describe any damage to other structures? (fences, sheds, outbuildings)");
		$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Describe any damage to personal property? (clothing, furniture)");
		$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Can you stay in the home tonight?");

		$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Where did the fire start?");
		$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Did the fire department respond?");
		$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "How many rooms are affected?");
		$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Who was living in the house at the time of the loss?");
		$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "If nobody, how long has the property been vacant?");
		$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Have you called emergency services/board up? Who? When did they get there?");
		$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "If no, do they need emergency services?");
		$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Describe any damage to other structures? (fences, sheds, outbuildings)");
		$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Describe any damage to personal property? (clothing, furniture)");
		$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Can you stay in the home tonight?");

		$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Where are the damages located?");
		$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "How many rooms are affected?");
		$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Who was living in the house at the time of the loss?");
		$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "If nobody, how long has the property been vacant");
		$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Have you called emergency services? Who? When did they get there?");
		$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Describe any damage to other structures? (fences, sheds, outbuildings)");
		$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Describe any damage to persojnal property? (clothing, furniture)");
		$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "If theft/burglary loss try to ask the insured what items were stolen");
		$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "If THEFT / BURGLARY / VANDALISM try to ask If they filed a police report and ask for their police report no");
		$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Can you stay in the home tonight?");
				
		$styleArray = array(
		'font'  => array(
			'bold'  => true,
			'color' => array('rgb' => 'FFFFFF'),
			'size'  => 10
		));
				
		$headerArray = array(
		'font'  => array(
			'bold'  => true,
			'color' => array('rgb' => '000000'),
			'size'  => 14
		));
		
		$this->objPHPExcel->setActiveSheetIndex($CurWorksheet)->mergeCells('A1:J1');
		$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValue('A1', "K2 Claims - New Loss No California Property");
		$this->objPHPExcel->getActiveSheet($CurWorksheet)->getRowDimension('1')->setRowHeight(40);
		$this->objPHPExcel->getActiveSheet($CurWorksheet)->getStyle('A1')->applyFromArray($headerArray);
		
		
		$this->objPHPExcel->getActiveSheet($CurWorksheet)->getStyle('A2:BC2')->applyFromArray($styleArray);
		$this->objPHPExcel->getActiveSheet($CurWorksheet)->getStyle('A2:BC2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('000000');
		//$this->objPHPExcel->getActiveSheet($CurWorksheet)->getStyle('K1:O1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FEEC9F');
		//$this->objPHPExcel->getActiveSheet($CurWorksheet)->getStyle('P1:V1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('BBF7F0');
		
		$sl=0;
		foreach($report_list as $wk=>$wv)
		{
			$sl++;
			$agent_id = $wv['added_by'];

			switch ($wv["type"]) {
				case 'cpswater':
					$stype = 'Water';
				break;
				case 'cpsfire':
					$stype = 'Fire';
				break;
				case 'cpsother':
					$stype = 'Other';
				break;
				case 'ncpswater':
					$stype = 'Water';
				break;
				case 'ncpsfire':
					$stype = 'Fire';
				break;
				case 'ncpsother':
					$stype = 'Other';
				break;
				default:
				break;
			}

			$c++; $r=0; 
			$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $sl);
			$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv["created_at"]);
			$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv["fusion_id"]);
			$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv["fullname"]);
			//$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv["office_id"]);
			//$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv["process_name"]);
			//$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv["designation"]);
			
			$related_catastrophe = $wv["related_to_catastrophe"];
			$catastrophe = $wv["related_to_catastrophe"] == "no" ? 'No' : $wv["catastrophe"];
			
			$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv["first_name"]." ".$wv["last_name"]);			
			$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv["date_of_loss"]);
			$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv["policy_number"]);
			$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $catastrophe);			
			$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv["insured"]);
			$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv["r_policy_holder"]);
			$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv["r_policy_phone"]);
			$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv["r_policy_firm"]);
			$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv["address"]);
			$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv["city"]);
			$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv["state"]);
			$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv["zipcode"]);
			$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv["primary_phone"]);
			$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv["secondary_phone"]);
			$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv["primay_mail"]);		
			$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv["secondary_mail"]);		
			$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv["loss_location"]);		
			//$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv["location_address"]);		
			$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv["loss_description"]);	
			$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $stype);	

			$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv["souce_of_water"]);		
			$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv["plumber"]);		
			$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv["effected_rooms"]);		
			$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv["who_was_at_the_time_of_loss"]);		
			$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv["how_long_property_been_vacant"]);		
			$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv["emergency_services"]);	
			$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv["emergency_services_needed"]);		
			$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv["other_structure_damage"]);		
			$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv["personal_property_damage"]);
			$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv["stay_home_tonight"]);

			$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv["fire_source"]);		
			$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv["responce_of_fire_department"]);	
			$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv["effected_rooms_of_fire"]);		
			$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv["who_was_living_at_the_time_of_loss"]);		
			$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv["property_vacant_time_of_fire"]);		
			$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv["emergency_services_called"]);		
			$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv["do_they_need_emergency_services"]);		
			$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv["other_structure_damage_fire"]);	
			$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv["personal_property_damage_fire"]);		
			$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv["can_you_stay_in_the_home_tonight"]);	

			$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv["other_damages_located"]);		
			$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv["other_how_many_rooms_effected"]);		
			$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv["other_who_was_at_the_time_of_loss"]);		
			$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv["other_how_long_has_the_property_been_vacant"]);	
			$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv["other_called_emergency_services"]);		
			$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv["other_describe_of_other_structure"]);		
			$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv["other_describe_personal_property"]);		
			$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv["what_items_were_stolen"]);	
			$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv["theft_loss_police_report_other"]);		
			$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv["other_can_you_stay_home_tonight"]);
		}
		}
		
		
		//================================================= New Loss Liability
		
		if($type == 'all' || $type == 2){
		$CurWorksheet++; $tableType = 2;
		$tablename = $tableArray[$tableType]['table'];
		$title = $tableArray[$tableType]['name'];
		
		$extraFilterDraft = "";
		if($report_type == 'draft'){
			$extraFilterDraft = "  AND t.draft_id NOT IN (SELECT r.draft_id from $tablename as r WHERE r.is_active = '1' AND r.draft_id IS NOT NULL)";
		}
		
		$reports_sql = "SELECT t.*, CONCAT(s.fname,' ', s.lname) as fullname, s.office_id, s.fusion_id, r.name as designation, get_process_names(s.id) as process_name 
		                FROM $tablename as t 
		                LEFT JOIN signin as s ON s.id = t.added_by 
		                LEFT JOIN role as r ON r.id = s.role_id 
		                WHERE DATE(t.created_at) >= '$startdate' AND DATE(t.created_at) <= '$enddate' $extraFilter $extraFilterDraft ORDER by t.id DESC";
 
		$report_list = $this->Common_model->get_query_result_array($reports_sql);

		$this->objPHPExcel->createSheet($CurWorksheet);
		$this->objPHPExcel->setActiveSheetIndex($CurWorksheet);
		$objWorksheet = $this->objPHPExcel->getActiveSheet($CurWorksheet);
		$objWorksheet->setTitle($title);
		
		$objWorksheet->setShowGridlines(true);
		$this->objPHPExcel->getDefaultStyle()->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->objPHPExcel->getDefaultStyle()->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$this->objPHPExcel->getActiveSheet($CurWorksheet)->getStyle('A1:N1'.$this->objPHPExcel->getActiveSheet($CurWorksheet)->getHighestRow())->getAlignment()->setWrapText(true);
		$objWorksheet->getColumnDimension('A')->setAutoSize(true);
		$objWorksheet->getColumnDimension('B')->setAutoSize(true); 
		$objWorksheet->getColumnDimension('C')->setAutoSize(true);
		$objWorksheet->getColumnDimension('D')->setAutoSize(true);
		$objWorksheet->getColumnDimension('E')->setAutoSize(true);
		$objWorksheet->getColumnDimension('F')->setAutoSize(true);
		$objWorksheet->getColumnDimension('G')->setAutoSize(true);
		$objWorksheet->getColumnDimension('H')->setAutoSize(true);
		$objWorksheet->getColumnDimension('I')->setAutoSize(true);
		$objWorksheet->getColumnDimension('J')->setAutoSize(true); 
		$objWorksheet->getColumnDimension('K')->setAutoSize(true); 
		$objWorksheet->getColumnDimension('L')->setAutoSize(true);
		$objWorksheet->getColumnDimension('M')->setAutoSize(true);
		$objWorksheet->getColumnDimension('N')->setAutoSize(true);
		$objWorksheet->getColumnDimension('O')->setAutoSize(true);
		$objWorksheet->getColumnDimension('P')->setAutoSize(true);
		$objWorksheet->getColumnDimension('Q')->setAutoSize(true);
		$objWorksheet->getColumnDimension('R')->setAutoSize(true);
		$objWorksheet->getColumnDimension('S')->setAutoSize(true);
		$objWorksheet->getColumnDimension('T')->setAutoSize(true);
		$objWorksheet->getColumnDimension('U')->setAutoSize(true);
		$objWorksheet->getColumnDimension('V')->setAutoSize(true);
		$objWorksheet->getColumnDimension('U')->setAutoSize(true);
		$objWorksheet->getColumnDimension('X')->setAutoSize(true);
		$objWorksheet->getColumnDimension('Y')->setAutoSize(true);
		$objWorksheet->getColumnDimension('Z')->setAutoSize(true);
		$objWorksheet->getColumnDimension('AA')->setAutoSize(true);
		$objWorksheet->getColumnDimension('AB')->setAutoSize(true);
		$objWorksheet->getColumnDimension('AC')->setAutoSize(true);
		$objWorksheet->getColumnDimension('AD')->setAutoSize(true);
		$objWorksheet->getColumnDimension('AE')->setAutoSize(true);
		$objWorksheet->getColumnDimension('AF')->setAutoSize(true);
		$objWorksheet->getColumnDimension('AG')->setAutoSize(true);
		$objWorksheet->getColumnDimension('AH')->setAutoSize(true);
		$objWorksheet->getColumnDimension('AI')->setAutoSize(true);
		$objWorksheet->getColumnDimension('AJ')->setAutoSize(true);
		$objWorksheet->getColumnDimension('AK')->setAutoSize(true);
		$objWorksheet->getColumnDimension('AL')->setAutoSize(true);
		
		$r=0; $c = 2;

		$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Sl");
		$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Date Added");
		$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Fusion ID");
		$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Agent Name");
		//$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Office");
		//$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Process");
		//$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Designation");
	
		$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Name of Caller");		
		$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Date of Loss");
		$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Policy Number");
		$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Related to Catastrophe");
		$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Relationship to Insured");
		$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Policy Holder");
		$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Policy Holder Phone Number");
		$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Firm/Contractor Name");
		$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Address");		
		$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "City");
		$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "State");
		$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Zipcode");
		$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Primary Phone");
		$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Secondary Phone");
		$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Primary Email");
		$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Secondary Email");
		$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Loss Location");
		//$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Location/Address Description");
		$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Loss Description");

		$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Police Called");
		$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Police Arrived");
		$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Report Taken");
		$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Report ID & Department");
		$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Name of Claimant");
		$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Address of Claimant");
		$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Phone Number of Claimant");
		$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "E-mail Address of Claimant");
		$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Were there any Injuries?");
		$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Injury Details");
		$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Are any parties represented by at attorney?");
		$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Name of Attorny and Contact");
		$styleArray = array(
		'font'  => array(
			'bold'  => true,
			'color' => array('rgb' => 'FFFFFF'),
			'size'  => 10
		));
				
		$headerArray = array(
		'font'  => array(
			'bold'  => true,
			'color' => array('rgb' => '000000'),
			'size'  => 14
		));
		
		$this->objPHPExcel->setActiveSheetIndex($CurWorksheet)->mergeCells('A1:J1');
		$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValue('A1', "K2 Claims - New Loss Liability");
		$this->objPHPExcel->getActiveSheet($CurWorksheet)->getRowDimension('1')->setRowHeight(40);
		$this->objPHPExcel->getActiveSheet($CurWorksheet)->getStyle('A1')->applyFromArray($headerArray);
		
		
		$this->objPHPExcel->getActiveSheet($CurWorksheet)->getStyle('A2:AL2')->applyFromArray($styleArray);
		$this->objPHPExcel->getActiveSheet($CurWorksheet)->getStyle('A2:AL2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('000000');
		//$this->objPHPExcel->getActiveSheet($CurWorksheet)->getStyle('K1:O1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FEEC9F');
		//$this->objPHPExcel->getActiveSheet($CurWorksheet)->getStyle('P1:V1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('BBF7F0');
		
		$sl=0;
		foreach($report_list as $wk=>$wv)
		{
			$sl++;
			$agent_id = $wv['added_by'];

			$c++; $r=0; 
			$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $sl);
			$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv["created_at"]);
			$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv["fusion_id"]);
			$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv["fullname"]);
			//$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv["office_id"]);
			//$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv["process_name"]);
			//$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv["designation"]);
			
			
			$related_catastrophe = $wv["related_to_catastrophe"];
			$catastrophe = $wv["related_to_catastrophe"] == "no" ? 'No' : $wv["catastrophe"];
		
			$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv["first_name"]." ".$wv["last_name"]);			
			$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv["date_of_loss"]);
			$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv["policy_number"]);
			$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $catastrophe);			
			$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv["relationship_to_insured"]);
			$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv["r_policy_holder"]);
			$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv["r_policy_phone"]);
			$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv["r_policy_firm"]);
			$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv["address"]);
			$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv["city"]);
			$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv["state"]);
			$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv["zipcode"]);
			$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv["primary_phone"]);
			$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv["secondary_phone"]);
			$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv["primay_mail"]);		
			$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv["secondary_mail"]);		
			$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv["loss_location"]);		
			//$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv["location_address"]);		
			$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv["loss_description"]);	

			$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv["police_called"]);		
			$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv["police_arrived"]);		
			$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv["report_taken"]);		
			$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv["report_id"]);		
			$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv["name_of_claimant"]);		
			$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv["address_of_claimant"]);	
			$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv["phone_number_of_claimant"]);		
			$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv["email_of_claimant"]);		
			$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv["injuries"]);
			$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv["types_of_injuries"]);
			$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv["parties_represented"]);		
			$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv["name_of_attrony"]);	
		}
		}
		
		
		//========================================== New Loss Auto-Motorcycle
		
		if($type == 'all' || $type == 3){
		$CurWorksheet++; $tableType = 3;
		$tablename = $tableArray[$tableType]['table'];
		$title = $tableArray[$tableType]['name'];
				
		$extraFilterDraft = "";
		if($report_type == 'draft'){
			$extraFilterDraft = "  AND t.draft_id NOT IN (SELECT r.draft_id from $tablename as r WHERE r.is_active = '1' AND r.draft_id IS NOT NULL)";
		}
		
		$reports_sql = "SELECT t.*, CONCAT(s.fname,' ', s.lname) as fullname, s.office_id, s.fusion_id, r.name as designation, get_process_names(s.id) as process_name 
		                FROM $tablename as t 
		                LEFT JOIN signin as s ON s.id = t.added_by 
		                LEFT JOIN role as r ON r.id = s.role_id 
		                WHERE DATE(t.created_at) >= '$startdate' AND DATE(t.created_at) <= '$enddate' $extraFilter $extraFilterDraft ORDER by t.id DESC";
 
		$report_list = $this->Common_model->get_query_result_array($reports_sql);

		$this->objPHPExcel->createSheet($CurWorksheet);
		$this->objPHPExcel->setActiveSheetIndex($CurWorksheet);
		$objWorksheet = $this->objPHPExcel->getActiveSheet($CurWorksheet);
		$objWorksheet->setTitle($title);
		
		$objWorksheet->setShowGridlines(true);
		$this->objPHPExcel->getDefaultStyle()->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->objPHPExcel->getDefaultStyle()->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$this->objPHPExcel->getActiveSheet($CurWorksheet)->getStyle('A1:N1'.$this->objPHPExcel->getActiveSheet($CurWorksheet)->getHighestRow())->getAlignment()->setWrapText(true);
		$objWorksheet->getColumnDimension('A')->setAutoSize(true);
		$objWorksheet->getColumnDimension('B')->setAutoSize(true); 
		$objWorksheet->getColumnDimension('C')->setAutoSize(true);
		$objWorksheet->getColumnDimension('D')->setAutoSize(true);
		$objWorksheet->getColumnDimension('E')->setAutoSize(true);
		$objWorksheet->getColumnDimension('F')->setAutoSize(true);
		$objWorksheet->getColumnDimension('G')->setAutoSize(true);
		$objWorksheet->getColumnDimension('H')->setAutoSize(true);
		$objWorksheet->getColumnDimension('I')->setAutoSize(true);
		$objWorksheet->getColumnDimension('J')->setAutoSize(true); 
		$objWorksheet->getColumnDimension('K')->setAutoSize(true); 
		$objWorksheet->getColumnDimension('L')->setAutoSize(true);
		$objWorksheet->getColumnDimension('M')->setAutoSize(true);
		$objWorksheet->getColumnDimension('N')->setAutoSize(true);
		$objWorksheet->getColumnDimension('O')->setAutoSize(true);
		$objWorksheet->getColumnDimension('P')->setAutoSize(true);
		$objWorksheet->getColumnDimension('Q')->setAutoSize(true);
		$objWorksheet->getColumnDimension('R')->setAutoSize(true);
		$objWorksheet->getColumnDimension('S')->setAutoSize(true);
		$objWorksheet->getColumnDimension('T')->setAutoSize(true);
		$objWorksheet->getColumnDimension('U')->setAutoSize(true);
		$objWorksheet->getColumnDimension('V')->setAutoSize(true);
		$objWorksheet->getColumnDimension('U')->setAutoSize(true);
		$objWorksheet->getColumnDimension('X')->setAutoSize(true);
		$objWorksheet->getColumnDimension('Y')->setAutoSize(true);
		$objWorksheet->getColumnDimension('Z')->setAutoSize(true);
		$objWorksheet->getColumnDimension('AA')->setAutoSize(true);
		$objWorksheet->getColumnDimension('AB')->setAutoSize(true);
		$objWorksheet->getColumnDimension('AC')->setAutoSize(true);
		$objWorksheet->getColumnDimension('AD')->setAutoSize(true);
		$objWorksheet->getColumnDimension('AE')->setAutoSize(true);
		$objWorksheet->getColumnDimension('AF')->setAutoSize(true);
		$objWorksheet->getColumnDimension('AG')->setAutoSize(true);
		$objWorksheet->getColumnDimension('AH')->setAutoSize(true);
		$objWorksheet->getColumnDimension('AI')->setAutoSize(true);
		$objWorksheet->getColumnDimension('AJ')->setAutoSize(true);
		$objWorksheet->getColumnDimension('AK')->setAutoSize(true);
		$objWorksheet->getColumnDimension('AL')->setAutoSize(true);
		
		$r=0; $c = 2;

		$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Sl");
		$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Date Added");
		$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Fusion ID");
		$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Agent Name");
		//$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Office");
		//$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Process");
		//$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Designation");

		$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Name of Caller");		
		$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Date of Loss");
		$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Policy Number");
		$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Related to Catastrophe");
		$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Relationship to Insured");
		$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Policy Holder");
		$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Policy Holder Phone Number");
		$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Firm/Contractor Name");
		$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Address");		
		$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "City");
		$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "State");
		$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Zipcode");
		$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Primary Phone");
		$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Secondary Phone");
		$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Primary Email");
		$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Secondary Email");
		$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Loss Location");
		//$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Location/Address Description");
		$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Loss Description");

		$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Police Called");
		$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Police Arrived");
		$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Report Taken");
		$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Report ID & Department");

		$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Year, Make, Model, Plate of Insured Vehicle Driven");
		$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Year, Make, Model, Plate of Claimant Vehicle Driven");
		$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Name of Claimant Driver");
		$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Address of Claimant Driver");
		$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Phone Number of Claimant");
		$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "E-mail Address of Claimant");
		$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Did any vehicles have a child restraint/carseat? If so, please indentify vehicle");
		$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Is the vehicle driveable? If not - Where is it located? Who towed?");
		$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Any Passengers? If yes");
		$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Name of the passengers?");
		$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Were there any Injuries?");
		$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Injuries Details");
		$styleArray = array(
		'font'  => array(
			'bold'  => true,
			'color' => array('rgb' => 'FFFFFF'),
			'size'  => 10
		));
				
		$headerArray = array(
		'font'  => array(
			'bold'  => true,
			'color' => array('rgb' => '000000'),
			'size'  => 14
		));
		
		$this->objPHPExcel->setActiveSheetIndex($CurWorksheet)->mergeCells('A1:J1');
		$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValue('A1', "K2 Claims - New Loss Auto-Motorcycle");
		$this->objPHPExcel->getActiveSheet($CurWorksheet)->getRowDimension('1')->setRowHeight(40);
		$this->objPHPExcel->getActiveSheet($CurWorksheet)->getStyle('A1')->applyFromArray($headerArray);
		
		
		$this->objPHPExcel->getActiveSheet($CurWorksheet)->getStyle('A2:AL2')->applyFromArray($styleArray);
		$this->objPHPExcel->getActiveSheet($CurWorksheet)->getStyle('A2:AL2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('000000');
		//$this->objPHPExcel->getActiveSheet($CurWorksheet)->getStyle('K1:O1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FEEC9F');
		//$this->objPHPExcel->getActiveSheet($CurWorksheet)->getStyle('P1:V1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('BBF7F0');
		
		$sl=0;
		foreach($report_list as $wk=>$wv)
		{
			$sl++;
			$agent_id = $wv['added_by'];

			$c++; $r=0; 
			$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $sl);
			$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv["created_at"]);
			$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv["fusion_id"]);
			$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv["fullname"]);
			//$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv["office_id"]);
			//$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv["process_name"]);
			//$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv["designation"]);
			
			
			$related_catastrophe = $wv["related_to_catastrophe"];
			$catastrophe = $wv["related_to_catastrophe"] == "no" ? 'No' : $wv["catastrophe"];
			
			$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv["first_name"]." ".$wv["last_name"]);
			$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv["date_of_loss"]);
			$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv["policy_number"]);
			$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $catastrophe);			
			$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv["relationship_to_insured"]);
			$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv["r_policy_holder"]);
			$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv["r_policy_phone"]);
			$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv["r_policy_firm"]);
			$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv["address"]);
			$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv["city"]);
			$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv["state"]);
			$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv["zipcode"]);
			$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv["primary_phone"]);
			$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv["secondary_phone"]);
			$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv["primay_mail"]);		
			$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv["secondary_mail"]);		
			$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv["loss_location"]);		
			//$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv["location_address"]);		
			$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv["loss_description"]);	

			$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv["police_called"]);		
			$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv["police_arrived"]);		
			$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv["report_taken"]);		
			$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv["report_id"]);		

			$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv["model_of_insured_vehicle"]);		
			$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv["model_of_claimant_vehicle"]);	
			$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv["name_of_claimant_driver"]);		
			$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv["address_of_claimant_driver"]);		
			$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv["phone_number_of_claimant"]);
			$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv["email_of_claimant"]);		
			$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv["child_restraint"]);

			$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv["vehicle_driveable"]);
			$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv["any_passengers"]);
			$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv["name_of_passengers"]);
			$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv["types_of_injuries"]);
			$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv["injuries_details"]);
		}
		}
		
		
		//=========================================== Call Existing About Claim
		
		if($type == 'all' || $type == 4){
		$CurWorksheet++; $tableType = 4;
		$tablename = $tableArray[$tableType]['table'];
		$title = $tableArray[$tableType]['name'];
		
		$extraFilterDraft = "";
		if($report_type == 'draft'){
			$extraFilterDraft = "  AND t.draft_id NOT IN (SELECT r.draft_id from $tablename as r WHERE r.is_active = '1' AND r.draft_id IS NOT NULL)";
		}
		
		$reports_sql = "SELECT t.*, CONCAT(s.fname,' ', s.lname) as fullname, s.office_id, s.fusion_id, r.name as designation, get_process_names(s.id) as process_name 
		                FROM $tablename as t 
		                LEFT JOIN signin as s ON s.id = t.added_by 
		                LEFT JOIN role as r ON r.id = s.role_id 
		                WHERE DATE(t.created_at) >= '$startdate' AND DATE(t.created_at) <= '$enddate' $extraFilter $extraFilterDraft ORDER by t.id DESC";
 
		$report_list = $this->Common_model->get_query_result_array($reports_sql);

		$this->objPHPExcel->createSheet($CurWorksheet);
		$this->objPHPExcel->setActiveSheetIndex($CurWorksheet);
		$objWorksheet = $this->objPHPExcel->getActiveSheet($CurWorksheet);
		$objWorksheet->setTitle($title);
		
		$objWorksheet->setShowGridlines(true);
		$this->objPHPExcel->getDefaultStyle()->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->objPHPExcel->getDefaultStyle()->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$this->objPHPExcel->getActiveSheet($CurWorksheet)->getStyle('A1:N1'.$this->objPHPExcel->getActiveSheet($CurWorksheet)->getHighestRow())->getAlignment()->setWrapText(true);
		$objWorksheet->getColumnDimension('A')->setAutoSize(true);
		$objWorksheet->getColumnDimension('B')->setAutoSize(true); 
		$objWorksheet->getColumnDimension('C')->setAutoSize(true);
		$objWorksheet->getColumnDimension('D')->setAutoSize(true);
		$objWorksheet->getColumnDimension('E')->setAutoSize(true);
		$objWorksheet->getColumnDimension('F')->setAutoSize(true);
		$objWorksheet->getColumnDimension('G')->setAutoSize(true);
		$objWorksheet->getColumnDimension('H')->setAutoSize(true);
		$objWorksheet->getColumnDimension('I')->setAutoSize(true);
		$objWorksheet->getColumnDimension('J')->setAutoSize(true); 
		$objWorksheet->getColumnDimension('K')->setAutoSize(true); 
		$objWorksheet->getColumnDimension('L')->setAutoSize(true);
		
		$r=0; $c = 2;

		$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Sl");
		$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Date Added");
		$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Fusion ID");
		$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Agent Name");
		//$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Office");
		//$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Process");
		//$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Designation");

		$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "What is the callers name");
		$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "What is the callers best return call number");
		$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "What is the callers e-mail address");
		$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "What is the reason for the call");
		$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Policy Number");
		$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Claim");		

		$styleArray = array(
		'font'  => array(
			'bold'  => true,
			'color' => array('rgb' => 'FFFFFF'),
			'size'  => 10
		));
				
		$headerArray = array(
		'font'  => array(
			'bold'  => true,
			'color' => array('rgb' => '000000'),
			'size'  => 14
		));
		
		$this->objPHPExcel->setActiveSheetIndex($CurWorksheet)->mergeCells('A1:J1');
		$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValue('A1', "K2 CLAIMS CRM - Call Existing About Claim");
		$this->objPHPExcel->getActiveSheet($CurWorksheet)->getRowDimension('1')->setRowHeight(40);
		$this->objPHPExcel->getActiveSheet($CurWorksheet)->getStyle('A1')->applyFromArray($headerArray);
		
		
		$this->objPHPExcel->getActiveSheet($CurWorksheet)->getStyle('A2:L2')->applyFromArray($styleArray);
		$this->objPHPExcel->getActiveSheet($CurWorksheet)->getStyle('A2:L2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('000000');
		//$this->objPHPExcel->getActiveSheet($CurWorksheet)->getStyle('K1:O1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FEEC9F');
		//$this->objPHPExcel->getActiveSheet($CurWorksheet)->getStyle('P1:V1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('BBF7F0');
		
		$sl=0;
		foreach($report_list as $wk=>$wv)
		{
			$sl++;
			$agent_id = $wv['added_by'];

			$c++; $r=0; 
			$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $sl);
			$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv["created_at"]);
			$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv["fusion_id"]);
			$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv["fullname"]);
			//$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv["office_id"]);
			//$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv["process_name"]);
			//$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv["designation"]);

			$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv["callername"]);
			$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv["return_call_number"]);
			$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv["email"]);
			$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv["reason_for_call"]);			
			$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv["policy_number"]);
			$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv["claim"]);
		}
		}
		
		
		//======================================== Other Issue
		
		if($type == 'all' || $type == 5){
		$CurWorksheet++; $tableType = 5;
		$tablename = $tableArray[$tableType]['table'];
		$title = $tableArray[$tableType]['name'];
		
		$extraFilterDraft = "";
		if($report_type == 'draft'){
			$extraFilterDraft = "  AND t.draft_id NOT IN (SELECT r.draft_id from $tablename as r WHERE r.is_active = '1' AND r.draft_id IS NOT NULL)";
		}
		
		$reports_sql = "SELECT t.*, CONCAT(s.fname,' ', s.lname) as fullname, s.office_id, s.fusion_id, r.name as designation, get_process_names(s.id) as process_name 
		                FROM $tablename as t 
		                LEFT JOIN signin as s ON s.id = t.added_by 
		                LEFT JOIN role as r ON r.id = s.role_id 
		                WHERE DATE(t.created_at) >= '$startdate' AND DATE(t.created_at) <= '$enddate' $extraFilter $extraFilterDraft ORDER by t.id DESC";
 
		$report_list = $this->Common_model->get_query_result_array($reports_sql);

		$this->objPHPExcel->createSheet($CurWorksheet);
		$this->objPHPExcel->setActiveSheetIndex($CurWorksheet);
		$objWorksheet = $this->objPHPExcel->getActiveSheet($CurWorksheet);
		$objWorksheet->setTitle($title);
		
		$objWorksheet->setShowGridlines(true);
		$this->objPHPExcel->getDefaultStyle()->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->objPHPExcel->getDefaultStyle()->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$this->objPHPExcel->getActiveSheet($CurWorksheet)->getStyle('A1:N1'.$this->objPHPExcel->getActiveSheet($CurWorksheet)->getHighestRow())->getAlignment()->setWrapText(true);
		$objWorksheet->getColumnDimension('A')->setAutoSize(true);
		$objWorksheet->getColumnDimension('B')->setAutoSize(true); 
		$objWorksheet->getColumnDimension('C')->setAutoSize(true);
		$objWorksheet->getColumnDimension('D')->setAutoSize(true);
		$objWorksheet->getColumnDimension('E')->setAutoSize(true);
		$objWorksheet->getColumnDimension('F')->setAutoSize(true);
		$objWorksheet->getColumnDimension('G')->setAutoSize(true);
		$objWorksheet->getColumnDimension('H')->setAutoSize(true);
		$objWorksheet->getColumnDimension('I')->setAutoSize(true);
		$objWorksheet->getColumnDimension('J')->setAutoSize(true); 
		$objWorksheet->getColumnDimension('K')->setAutoSize(true); 
		$objWorksheet->getColumnDimension('L')->setAutoSize(true);
		
		$r=0; $c = 2;

		$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Sl");
		$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Date Added");
		$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Fusion ID");
		$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Agent Name");
		//$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Office");
		//$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Process");
		//$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Designation");

		$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "What is the callers name");
		$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "What is the callers best return call number");
		$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "What is the callers e-mail address");
		$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "What is the reason for the call");
		$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Policy Number");
		$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Claim");		

		$styleArray = array(
		'font'  => array(
			'bold'  => true,
			'color' => array('rgb' => 'FFFFFF'),
			'size'  => 10
		));
				
		$headerArray = array(
		'font'  => array(
			'bold'  => true,
			'color' => array('rgb' => '000000'),
			'size'  => 14
		));
		
		$this->objPHPExcel->setActiveSheetIndex($CurWorksheet)->mergeCells('A1:J1');
		$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValue('A1', "K2 CLAIMS CRM - Other Issue");
		$this->objPHPExcel->getActiveSheet($CurWorksheet)->getRowDimension('1')->setRowHeight(40);
		$this->objPHPExcel->getActiveSheet($CurWorksheet)->getStyle('A1')->applyFromArray($headerArray);
		
		
		$this->objPHPExcel->getActiveSheet($CurWorksheet)->getStyle('A2:L2')->applyFromArray($styleArray);
		$this->objPHPExcel->getActiveSheet($CurWorksheet)->getStyle('A2:L2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('000000');
		//$this->objPHPExcel->getActiveSheet($CurWorksheet)->getStyle('K1:O1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FEEC9F');
		//$this->objPHPExcel->getActiveSheet($CurWorksheet)->getStyle('P1:V1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('BBF7F0');
		
		$sl=0;
		foreach($report_list as $wk=>$wv)
		{
			$sl++;
			$agent_id = $wv['added_by'];

			$c++; $r=0; 
			$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $sl);
			$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv["created_at"]);
			$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv["fusion_id"]);
			$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv["fullname"]);
			//$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv["office_id"]);
			//$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv["process_name"]);
			//$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv["designation"]);

			$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv["callername"]);
			$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv["return_call_number"]);
			$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv["email"]);
			$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv["reason_for_call"]);			
			$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv["policy_number"]);
			$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv["claim"]);
		}
		}
		
		$this->objPHPExcel->setActiveSheetIndex(0);
		
		ob_end_clean();
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="K2_claims_crm_reports.xlsx"');
		header('Cache-Control: max-age=0');
		$objWriter = PHPExcel_IOFactory::createWriter($this->objPHPExcel , 'Excel2007');
		$objWriter->setIncludeCharts(TRUE);
		$objWriter->save('php://output');
		exit(); 
	}
	
	public function dropdowns_relationship(){
		$result_array = array(
			"Policy Holder",
			"Public Adjuster/Attorney",
			"Agent/Broker",
			"Relative",
			"Claimant",
			"Contractor",
		);
		return $result_array;
	}
	
	private function array_indexed($dataArray = NULL, $column = "")
	{
		$result = array();
		if(!empty($dataArray) && !empty($column))
		{
			$arrOne = array_column($dataArray, $column);
			$arrTwo = $dataArray;
			$result = array_combine($arrOne, $arrTwo);
		}		
		return $result;
	}
	
}