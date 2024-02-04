<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Mck extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model('user_model');
		$this->load->model('Common_model');	
		$this->load->library('excel');
		$this->load->model('Email_model');
		$this->objPHPExcel = new PHPExcel();
	}

	 public function index(){

	 	/*$sql="select * from contract_tracing_mckinsey where status='A'";
	  	$data['case_list']=$this->Common_model->get_query_result_array($sql);
		$this->load->view('contact_tracing_crm/mackinsy/list',$data);*/
		// redirect('mck/confirmed', 'refresh');
		$this->load->view('contact_tracing_crm/mackinsy/index');
	 }
	public function case($type){
	  	$incident_id = $this->generate_crm_id();
	  	$d_array['case_id']=$incident_id;
	  	$d_array['added_by']=get_user_id();
	  	$d_array['added_date']=CurrMySqlDate();
	  	$d_array['log']=get_logs();
	  	data_inserter('contract_tracing_mckinsey', $d_array);
	  	$data['incident_id']=$incident_id;
	  	$sql_cnt="select * from mckinsey_country where status='A'";
	  	$data['country_list']=$this->Common_model->get_query_result_array($sql_cnt);
	  	$sql_off="select * from mckinsey_location where status='A'";
	  	$data['office_loc']=$this->Common_model->get_query_result_array($sql_off);
	  	$sql_off="select * from mckinsey_symptoms where status='1'";
	  	$data['symptoms']=$this->Common_model->get_query_result_array($sql_off);
	  	$sql_medical="select * from mckinsey_medical_attention where status=1";
	  	$data['medical_attention']=$this->Common_model->get_query_result_array($sql_medical);
		$this->load->view('contact_tracing_crm/mackinsy/form',$data);
	  }

	//============================= CRM ID =============================================================//
	
	public function generate_crm_id()
	{
		$sql = "SELECT count(*) as value from contract_tracing_mckinsey ORDER by id DESC LIMIT 1";
		$lastid = $this->Common_model->get_single_value($sql);
		$new_incident_id = "MCK-" .sprintf('%04d', $lastid + 1);
		return $new_incident_id;
	}
	public function save_data(){
		$rows=$_POST;
		//echo'<pre>';print_r($rows);echo'<br>';
		$symptom=implode(",", $rows['symptom']);
		$medical_attention=implode(",",$rows['medical_attention']);
		$case_id=$rows['incident_id'];
		$update_data=[
			"name"=>$rows['person'],
			"communication"=>$rows['communication'],
			"phone"=>$rows['phone'],
			"fmno"=>$rows['fmno'],
			"email"=>$rows['email'],
			"location"=>$rows['location'],
			"other_location"=>$row['other_location'],
			"country"=>$rows['country'],
			"city"=>$rows['city'],
			"case_manager"=>$rows['case_manager'],
			"home_office_lmp"=>$rows['home_office_lmp'],
			"assess_situation"=>$rows['assess_situation'],
			"assumed_location_exposer"=>$rows['assumed_location_exposure'],
			"date_mck_notified"=>$rows['date_mck_notified'],
			"contact_status"=>$rows['contact_status'],
			"date_of_symptom_onset"=>$rows['date_of_symptom_onset'],
			"self_lsolated_start_date"=>$rows['self_isolated_start_date'],
			"self_isolated_end_date"=>$rows['self_isolated_end_date'],
			"positive_test_date"=>$rows['positive_test_date'],
			"client_contacts_notified"=>$rows['client_contacts_notified'],
			"firm_contacts_notified"=>$rows['firm_contacts_notified'],
			"symptoms_currently"=>$rows['symptoms_currently'],
			"fully_vaccinated"=>$rows['fully_vaccinated'],
			"you_boosted"=>$rows['you_boosted'],
			"medical_primary_provider"=>$rows['medical_primary_provider'],
			"you_worried"=>$rows['you_worried'],
			"last_mckinsey_colleagues"=>$rows['when_you_with_mckinsey'],
			"last_clients"=>$rows['las_with_client'],
			"who_is_dcs"=>$rows['who_is_dcs'],
			"what_is_dcs"=>$rows['what_is_dcs'],
			"you_worried"=>$rows['you_worried'],
			"last_mckinsey_office"=>$rows['last_mckinsey_office'],
			"which_one"=>$rows['which_one'],
			"last_attending_mckinsey_event"=>$rows['last_mckinsey_event'],
			"case_manager_notes"=>$rows['case_manager_note'],
			"who_event_sponsor"=>$rows['who_event_sponsor'],
			"event_sponsor_email"=>$rows['event_sponsor_email'],
			"sponsor_already_aware"=>$rows['sponsor_already_aware'],
			"contract_tracing"=>$rows['contact_tracing'],
			"working_mckinsey_office"=>$rows['working_mckinsey_office'],
			"mckinsey_event_close_contact"=>$rows['mckinsey_event_close_contact'],
			"client_close_contact"=>$rows['client_close_contact'],
			"colleague_close_contact"=>$rows['colleague_close_contact'],
			"colleague_ill_5_day"=>$rows['colleague_ill_5_day'],
			"colleague_away_from_home"=>$rows['colleague_away_from_home'],
			"drivable_well"=>$rows['drivable_well'],
			"quarantining_place"=>$rows['quarantining_place'],
			"international"=>$rows['international'],
			"colleague_seriously_ill"=>$rows['colleague_seriously_ill'],
			"colleague_exhibiting"=>$rows['colleague_exhibiting'],
			"colleague_underlying_complications"=>$rows['colleague_underlying_complications'],
			"symptoms"=>$symptom,
			"medical_attention"=>$medical_attention,
			"status"=>'A',
			"log"=>get_logs(),
		];
		$this->db->where('case_id', $case_id);
		$this->db->update('contract_tracing_mckinsey', $update_data);

		$mckinsey_colleagues_fname=$rows['mckinsey_colleagues_fname'];
		$mckinsey_colleagues_lname=$rows['mckinsey_colleagues_lname'];
		$mckinsey_colleagues_email=$rows['mckinsey_colleagues_email'];
		$mckinsey_colleagues_date=$rows['mckinsey_colleagues_date'];
		$mckinsey_colleagues_location=$rows['mckinsey_colleagues_location'];
		$mckinsey_colleagues_other_location=$rows['mckinsey_colleagues_other_location'];

		$client_fname=$rows['client_fname'];
		$client_lname=$rows['client_lname'];
		$client_date=$rows['client_date'];
		$client_location=$rows['client_location'];
		$this->db->where('case_id',$case_id);	
		$this->db->delete('mckinsey_close_contact');
		foreach ($mckinsey_colleagues_fname as $key => $rows) {
			$colleagues=[
				"case_id"=>$case_id,
				"fname"=>$rows,
				"lname"=>$mckinsey_colleagues_lname[$key],
				"email"=>$mckinsey_colleagues_email[$key],
				"date"=>$mckinsey_colleagues_date[$key],
				"location"=>$mckinsey_colleagues_location[$key],
				"other_location"=>$mckinsey_colleagues_other_location[$key],
				"type"=>'colleagues'
			];
			data_inserter('mckinsey_close_contact', $colleagues);
		}
		foreach($client_fname as $key =>$rows){
			$client=[
				"case_id"=>$case_id,
				"fname"=>$rows,
				"lname"=>$client_lname[$key],
				"date"=>$client_date[$key],
				"location"=>$client_location[$key],
				"type"=>'client'
			];
			data_inserter('mckinsey_close_contact', $client);
		}
	}

	public function delete(){
		$case_id=$this->input->get('case_id');
		$update_data=[
			'status'=>'D',
		];
		$this->db->where('case_id', $case_id);
		$this->db->update('contract_tracing_mckinsey', $update_data);

	}
	public function confirmed(){
		$sql_cnt="select * from mckinsey_country where status='A'";
	  	$data['country_list']=$this->Common_model->get_query_result_array($sql_cnt);

	  	$extra="";
	  	$search_case_name=$this->input->post('search_case_name');
	  	$search_country=$this->input->post('search_country');
	  	$search_location=$this->input->post('search_location');
	  	if($search_case_name!=""){
	  		$data['search_case_name']=$search_case_name;
	  		$extra.=" AND case_id='".$search_case_name."'";
	  	}
	  	if($search_country!=""){
	  		$data['search_country']=$search_country;
	  		$extra.=" AND country='".$search_country."'";
	  	}
	  	if($search_location!=""){
	  		$data['search_location']=$search_location;
	  		$extra.=" AND search_location='".$search_location."'";
	  	}


		$sql="select ct.*,mc.name as country_name from contract_tracing_mckinsey ct LEFT join mckinsey_country mc on mc.id=ct.country where ct.status='A' and ct.assess_situation='Confirmed' $extra";
	  	$data['case_list']=$this->Common_model->get_query_result_array($sql);

		$this->load->view('contact_tracing_crm/mackinsy/confirmed',$data);

	}
	public function myconfirmed(){
		$userid=get_user_id();
		$sql_cnt="select * from mckinsey_country where status='A'";
	  	$data['country_list']=$this->Common_model->get_query_result_array($sql_cnt);

	  	$extra="";
		$search_case_name=$this->input->post('search_case_name');
	  	$search_country=$this->input->post('search_country');
	  	$search_location=$this->input->post('search_location');
	  	if($search_case_name!=""){
	  		$data['search_case_name']=$search_case_name;
	  		$extra.=" AND case_id='".$search_case_name."'";
	  	}
	  	if($search_country!=""){
	  		$data['search_country']=$search_country;
	  		$extra.=" AND country='".$search_country."'";
	  	}
	  	if($search_location!=""){
	  		$data['search_location']=$search_location;
	  		$extra.=" AND search_location='".$search_location."'";
	  	}
		$sql="select ct.*,mc.name as country_name from contract_tracing_mckinsey ct LEFT join mckinsey_country mc on mc.id=ct.country where ct.status='A' and ct.assess_situation='Confirmed' and added_by='".$userid."' $extra";
	  	$data['case_list']=$this->Common_model->get_query_result_array($sql);

		$this->load->view('contact_tracing_crm/mackinsy/confirmed',$data);

	}
	public function suspect_cases(){

		$sql_cnt="select * from mckinsey_country where status='A'";
	  	$data['country_list']=$this->Common_model->get_query_result_array($sql_cnt);

	  	$extra="";
	  	$search_case_name=$this->input->post('search_case_name');
	  	$search_country=$this->input->post('search_country');
	  	$search_location=$this->input->post('search_location');
	  	if($search_case_name!=""){
	  		$data['search_case_name']=$search_case_name;
	  		$extra.=" AND case_id='".$search_case_name."'";
	  	}
	  	if($search_country!=""){
	  		$data['search_country']=$search_country;
	  		$extra.=" AND country='".$search_country."'";
	  	}
	  	if($search_location!=""){
	  		$data['search_location']=$search_location;
	  		$extra.=" AND search_location='".$search_location."'";
	  	}

		$sql="select ct.*,mc.name as country_name from contract_tracing_mckinsey ct LEFT join mckinsey_country mc on mc.id=ct.country where ct.status='A' and ct.assess_situation='Suspect' $extra";
	  	$data['case_list']=$this->Common_model->get_query_result_array($sql);

		$this->load->view('contact_tracing_crm/mackinsy/suspect_cases',$data);

	}

	public function my_suspect_cases(){
		$userid=get_user_id();
		$sql_cnt="select * from mckinsey_country where status='A'";
	  	$data['country_list']=$this->Common_model->get_query_result_array($sql_cnt);

	  	$extra="";
	  	$search_case_name=$this->input->post('search_case_name');
	  	$search_country=$this->input->post('search_country');
	  	$search_location=$this->input->post('search_location');
	  	if($search_case_name!=""){
	  		$data['search_case_name']=$search_case_name;
	  		$extra.=" AND case_id='".$search_case_name."'";
	  	}
	  	if($search_country!=""){
	  		$data['search_country']=$search_country;
	  		$extra.=" AND country='".$search_country."'";
	  	}
	  	if($search_location!=""){
	  		$data['search_location']=$search_location;
	  		$extra.=" AND search_location='".$search_location."'";
	  	}
		$sql="select ct.*,mc.name as country_name from contract_tracing_mckinsey ct LEFT join mckinsey_country mc on mc.id=ct.country where ct.status='A' and ct.assess_situation='Suspect' and added_by='".$userid."' $extra";
	  	$data['case_list']=$this->Common_model->get_query_result_array($sql);

		$this->load->view('contact_tracing_crm/mackinsy/my_suspect_cases',$data);

	}
	public function other_cases(){
		$sql_cnt="select * from mckinsey_country where status='A'";
	  	$data['country_list']=$this->Common_model->get_query_result_array($sql_cnt);

	  	$extra="";
	  	$search_case_name=$this->input->post('search_case_name');
	  	$search_country=$this->input->post('search_country');
	  	$search_location=$this->input->post('search_location');
	  	if($search_case_name!=""){
	  		$data['search_case_name']=$search_case_name;
	  		$extra.=" AND case_id='".$search_case_name."'";
	  	}
	  	if($search_country!=""){
	  		$data['search_country']=$search_country;
	  		$extra.=" AND country='".$search_country."'";
	  	}
	  	if($search_location!=""){
	  		$data['search_location']=$search_location;
	  		$extra.=" AND search_location='".$search_location."'";
	  	}

		$sql="select ct.*,mc.name as country_name from contract_tracing_mckinsey ct LEFT join mckinsey_country mc on mc.id=ct.country where ct.status='A' and ct.assess_situation='other' $extra";
	  	$data['case_list']=$this->Common_model->get_query_result_array($sql);

		$this->load->view('contact_tracing_crm/mackinsy/other_symptomatic',$data);

	}

	public function my_other_cases(){
		$userid=get_user_id();
		$sql_cnt="select * from mckinsey_country where status='A'";
	  	$data['country_list']=$this->Common_model->get_query_result_array($sql_cnt);

	  	$extra="";
	  	$search_case_name=$this->input->post('search_case_name');
	  	$search_country=$this->input->post('search_country');
	  	$search_location=$this->input->post('search_location');
	  	if($search_case_name!=""){
	  		$data['search_case_name']=$search_case_name;
	  		$extra.=" AND case_id='".$search_case_name."'";
	  	}
	  	if($search_country!=""){
	  		$data['search_country']=$search_country;
	  		$extra.=" AND country='".$search_country."'";
	  	}
	  	if($search_location!=""){
	  		$data['search_location']=$search_location;
	  		$extra.=" AND search_location='".$search_location."'";
	  	}
		$sql="select ct.*,mc.name as country_name from contract_tracing_mckinsey ct LEFT join mckinsey_country mc on mc.id=ct.country where ct.status='A' and ct.assess_situation='other' and added_by='".$userid."'";
	  	$data['case_list']=$this->Common_model->get_query_result_array($sql);

		$this->load->view('contact_tracing_crm/mackinsy/my_other_symptomatic',$data);

	}
	public function close_contact(){
		$sql_cnt="select * from mckinsey_country where status='A'";
	  	$data['country_list']=$this->Common_model->get_query_result_array($sql_cnt);

	  	$extra="";
	  	$search_case_name=$this->input->post('search_case_name');
	  	$search_country=$this->input->post('search_country');
	  	$search_location=$this->input->post('search_location');
	  	if($search_case_name!=""){
	  		$data['search_case_name']=$search_case_name;
	  		$extra.=" AND ct.case_id='".$search_case_name."'";
	  	}
	  	if($search_country!=""){
	  		$data['search_country']=$search_country;
	  		$extra.=" AND ct.country='".$search_country."'";
	  	}
	  	if($search_location!=""){
	  		$data['search_location']=$search_location;
	  		$extra.=" AND ct.search_location='".$search_location."'";
	  	}

		$sql="SELECT ct.*,mt.*,ct.case_id as caseID,mc.name as country_name FROM  `contract_tracing_mckinsey`as ct LEFT JOIN `mckinsey_close_contact` as mt ON ct.case_id=mt.case_id LEFT JOIN mckinsey_country mc on  ct.country=mc.id where ct.status='A' $extra
				UNION All
			SELECT ct.*,mt.*,ct.case_id as caseID,mc.name as country_name FROM  `contract_tracing_mckinsey`as ct RIGHT JOIN `mckinsey_close_contact` as mt ON ct.case_id=mt.case_id LEFT JOIN mckinsey_country mc on  ct.country=mc.id Where ct.`assess_situation`='Close contact & what type' and ct.status='A' $extra";
		$data['case_list']=$this->Common_model->get_query_result_array($sql);

		//echo'<pre>';print_r($data['case_list']);

		$this->load->view('contact_tracing_crm/mackinsy/close_contact',$data);	
	}
	public function my_close_contact(){
		$userid=get_user_id();
		$sql_cnt="select * from mckinsey_country where status='A'";
	  	$data['country_list']=$this->Common_model->get_query_result_array($sql_cnt);

	  	$extra=" AND ct.added_by='".$userid."'";
	  	$search_case_name=$this->input->post('search_case_name');
	  	$search_country=$this->input->post('search_country');
	  	$search_location=$this->input->post('search_location');
	  	if($search_case_name!=""){
	  		$data['search_case_name']=$search_case_name;
	  		$extra.=" AND ct.case_id='".$search_case_name."'";
	  	}
	  	if($search_country!=""){
	  		$data['search_country']=$search_country;
	  		$extra.=" AND ct.country='".$search_country."'";
	  	}
	  	if($search_location!=""){
	  		$data['search_location']=$search_location;
	  		$extra.=" AND ct.search_location='".$search_location."'";
	  	}

		$sql="SELECT ct.*,mt.*,ct.case_id as caseID,mc.name as country_name FROM  `contract_tracing_mckinsey`as ct LEFT JOIN `mckinsey_close_contact` as mt ON ct.case_id=mt.case_id LEFT JOIN mckinsey_country mc on  ct.country=mc.id where ct.status='A' $extra
				UNION All
			SELECT ct.*,mt.*,ct.case_id as caseID,mc.name as country_name FROM  `contract_tracing_mckinsey`as ct RIGHT JOIN `mckinsey_close_contact` as mt ON ct.case_id=mt.case_id LEFT JOIN mckinsey_country mc on  ct.country=mc.id Where ct.`assess_situation`='Close contact & what type' and ct.status='A' $extra";
		$data['case_list']=$this->Common_model->get_query_result_array($sql);

		//echo'<pre>';print_r($data['case_list']);

		$this->load->view('contact_tracing_crm/mackinsy/my_close_contact',$data);	
	}
	public function edit_case($case_id){
		$data['incident_id']=$case_id;
		//echo'<br>'.$case_id;
	  	$sql_cnt="select * from mckinsey_country where status='A'";
	  	$data['country_list']=$this->Common_model->get_query_result_array($sql_cnt);
	  	$sql_off="select * from mckinsey_location where status='A'";
	  	$data['office_loc']=$this->Common_model->get_query_result_array($sql_off);
	  	$sql_off="select * from mckinsey_symptoms where status='1'";
	  	$data['symptoms']=$this->Common_model->get_query_result_array($sql_off);
	  	$sql_medical="select * from mckinsey_medical_attention where status=1";
	  	$data['medical_attention']=$this->Common_model->get_query_result_array($sql_medical);

	  	$sql="select * from contract_tracing_mckinsey  where case_id='".$case_id."'";
	  	$data['case_list']=$this->Common_model->get_query_result_array($sql);
	  	//echo'<pre>';print_r($data['case_list']);
	  	$sql="select * from mckinsey_close_contact  where case_id='".$case_id."' and type='colleagues'";
	  	$data['colleague']=$this->Common_model->get_query_result_array($sql);
	  	$sql="select * from mckinsey_close_contact  where case_id='".$case_id."' and type='client'";
	  	$data['client']=$this->Common_model->get_query_result_array($sql);
	  	$sql_email_log="select ml.*,s.fname,s.lname from mckinsey_email_log ml LEFT JOIN signin s ON s.id=ml.sender_id where ml.incident_id='".$case_id."'";
	  	$data['sql_email_log']=$this->Common_model->get_query_result_array($sql_email_log);
	  	
		$this->load->view('contact_tracing_crm/mackinsy/edit_form',$data);
	}
	public function update_data(){
		$rows=$_POST;
		//echo'<pre>';print_r($rows);echo'<br>';
		$symptom=implode(",", $rows['symptom']);
		$medical_attention=implode(",",$rows['medical_attention']);
		$case_id=$rows['incident_id'];
		$update_data=[
			"name"=>$rows['person'],
			"communication"=>$rows['communication'],
			"phone"=>$rows['phone'],
			"fmno"=>$rows['fmno'],
			"email"=>$rows['email'],
			"location"=>$rows['location'],
			"other_location"=>$row['other_location'],
			"country"=>$rows['country'],
			"city"=>$rows['city'],
			"case_manager"=>$rows['case_manager'],
			"home_office_lmp"=>$rows['home_office_lmp'],
			"assess_situation"=>$rows['assess_situation'],
			"assumed_location_exposer"=>$rows['assumed_location_exposure'],
			"date_mck_notified"=>$rows['date_mck_notified'],
			"contact_status"=>$rows['contact_status'],
			"date_of_symptom_onset"=>$rows['date_of_symptom_onset'],
			"self_lsolated_start_date"=>$rows['self_isolated_start_date'],
			"self_isolated_end_date"=>$rows['self_isolated_end_date'],
			"positive_test_date"=>$rows['positive_test_date'],
			"client_contacts_notified"=>$rows['client_contacts_notified'],
			"firm_contacts_notified"=>$rows['firm_contacts_notified'],
			"symptoms_currently"=>$rows['symptoms_currently'],
			"fully_vaccinated"=>$rows['fully_vaccinated'],
			"you_boosted"=>$rows['you_boosted'],
			"medical_primary_provider"=>$rows['medical_primary_provider'],
			"you_worried"=>$rows['you_worried'],
			"last_mckinsey_colleagues"=>$rows['when_you_with_mckinsey'],
			"last_clients"=>$rows['las_with_client'],
			"who_is_dcs"=>$rows['who_is_dcs'],
			"what_is_dcs"=>$rows['what_is_dcs'],
			"you_worried"=>$rows['you_worried'],
			"last_mckinsey_office"=>$rows['last_mckinsey_office'],
			"which_one"=>$rows['which_one'],
			"last_attending_mckinsey_event"=>$rows['last_mckinsey_event'],
			"case_manager_notes"=>$rows['case_manager_note'],
			"who_event_sponsor"=>$rows['who_event_sponsor'],
			"event_sponsor_email"=>$rows['event_sponsor_email'],
			"sponsor_already_aware"=>$rows['sponsor_already_aware'],
			"contract_tracing"=>$rows['contact_tracing'],
			"working_mckinsey_office"=>$rows['working_mckinsey_office'],
			"mckinsey_event_close_contact"=>$rows['mckinsey_event_close_contact'],
			"client_close_contact"=>$rows['client_close_contact'],
			"colleague_close_contact"=>$rows['colleague_close_contact'],
			"colleague_ill_5_day"=>$rows['colleague_ill_5_day'],
			"colleague_away_from_home"=>$rows['colleague_away_from_home'],
			"drivable_well"=>$rows['drivable_well'],
			"quarantining_place"=>$rows['quarantining_place'],
			"international"=>$rows['international'],
			"colleague_seriously_ill"=>$rows['colleague_seriously_ill'],
			"colleague_exhibiting"=>$rows['colleague_exhibiting'],
			"colleague_underlying_complications"=>$rows['colleague_underlying_complications'],
			"symptoms"=>$symptom,
			"medical_attention"=>$medical_attention,
			"status"=>'A',
			"log"=>get_logs(),
		];
		$this->db->where('case_id', $case_id);
		$this->db->update('contract_tracing_mckinsey', $update_data);

		$mckinsey_colleagues_fname=$rows['mckinsey_colleagues_fname'];
		$mckinsey_colleagues_lname=$rows['mckinsey_colleagues_lname'];
		$mckinsey_colleagues_email=$rows['mckinsey_colleagues_email'];
		$mckinsey_colleagues_date=$rows['mckinsey_colleagues_date'];
		$mckinsey_colleagues_location=$rows['mckinsey_colleagues_location'];
		$mckinsey_colleagues_other_location=$rows['mckinsey_colleagues_other_location'];

		$client_fname=$rows['client_fname'];
		$client_lname=$rows['client_lname'];
		$client_date=$rows['client_date'];
		$client_location=$rows['client_location'];
		$this->db->where('case_id',$case_id);	
		$this->db->delete('mckinsey_close_contact');
		foreach ($mckinsey_colleagues_fname as $key => $rows) {
			$colleagues=[
				"case_id"=>$case_id,
				"fname"=>$rows,
				"lname"=>$mckinsey_colleagues_lname[$key],
				"email"=>$mckinsey_colleagues_email[$key],
				"date"=>$mckinsey_colleagues_date[$key],
				"location"=>$mckinsey_colleagues_location[$key],
				"other_location"=>$mckinsey_colleagues_other_location[$key],
				"type"=>'colleagues'
			];
			data_inserter('mckinsey_close_contact', $colleagues);
		}
		foreach($client_fname as $key =>$rows){
			$client=[
				"case_id"=>$case_id,
				"fname"=>$rows,
				"lname"=>$client_lname[$key],
				"date"=>$client_date[$key],
				"location"=>$client_location[$key],
				"type"=>'client'
			];
			data_inserter('mckinsey_close_contact', $client);
		}
	}

	public function email_config_list(){
		$sql="select * from `mckinsey_email` where status='A'";
		$rws=$this->Common_model->get_query_result_array($sql);
		$data['list']=$rws;
		$this->load->view('contact_tracing_crm/mackinsy/email_list',$data);
	}
	public function get_mail(){
		$rows=$_POST;
		$sql="select * from `mckinsey_email` where `email_identifier`='".$rows['email_map_id']."' and status='A'";
		$rws=$this->Common_model->get_query_result_array($sql);
		$result=$rws[0];
		echo json_encode($result);
	}
	public function get_mail_data(){
		$rows=$_POST;
		$sql="select * from `mckinsey_email` where `email_identifier`='".$rows['email_map_id']."' and status='A'";
		$rws=$this->Common_model->get_query_result_array($sql);
		$case_manager=get_username();
		
		if($rows['email_map_id']=='working_mckinsey_office_email'){
			$result['to_email']='';//$rws[0]['to_email'];
			$result['cc_email']=$rws[0]['cc_email'];
			$result['subject']=$rws[0]['subject'];
			
			$dt=str_replace('<span style="color:#000;background:#ffff00;padding:2px 0;margin:2px 0 0 0;display:inline-block;">Ameridial/Fusion email signature</span>','McKinsey COVID Support Team (North America)<br>
			Email: <a href="">McKinseyNACovidSupport@fusionbposervices.com</a><br>
			Phone: Canada- 4382881596, US-8558433307, Mexico- 525571000320',$dt);
			$dt=str_replace('Hello –', 'Hello '.$rows['person'],$rws[0]['body']);
			$dtime=str_replace('T', ' ', $rows['when_you_with_mckinsey']);
			$dtime=($dtime!='')?$dtime:'[insert date]';
			$dt=str_replace ('[insert date]',$dtime,$dt);
			if($rows['home_office_lmp']!=''){
			$dt=str_replace('[insert office #, if known or floor or description from colleague of where they were physically]',$rows['home_office_lmp'], $dt);
			}
			$dt=str_replace('<span style="color:#000;background:#ffff00;padding:2px 0;margin:2px 0 0 0;display:inline-block;">Ameridial/Fusion email signature</span>','McKinsey COVID Support Team (North America)<br>
			Email: <a href="">McKinseyNACovidSupport@fusionbposervices.com</a><br>
			Phone: Canada- 4382881596, US-8558433307, Mexico- 525571000320',$dt);
			$dt=str_replace('Case Manager name',$case_manager,$dt);
			$result['body']=$dt;//html_entity_decode($dt);

		}
		elseif($rows['email_map_id']=='mckinsey_event_close_contact_email'){
			
			$edate=str_replace('T',' ', $rows['last_mckinsey_event']);
			$result['to_email']=$rows['event_sponsor_email'];//$rws[0]['to_email'];
			$result['cc_email']=$rws[0]['cc_email'];
			$sub=$edate.' , '.$rows['who_event_sponsor'];
			$smpt=($rows['symptoms_currently']=='Yes')?$rows['date_of_symptom_onset']:$rows['positive_test_date'];
			$result['subject']=str_replace('[Event Date, Sponsor Name]', $sub,$rws[0]['subject']);
			$dt=str_replace('<span style="color:#000;background:#ffff00;padding:2px 0;margin:2px 0 0 0;display:inline-block;font-style:italic;">Ameridial/Fusion email signature</span>','McKinsey COVID Support Team (North America)<br>
			Email: <a href="">McKinseyNACovidSupport@fusionbposervices.com</a><br>
			Phone: Canada- 4382881596, US-8558433307, Mexico- 525571000320',$rws[0]['body']);
			$dt=str_replace('Hello –', 'Hello '.$rows['person'],$dt);
			if($edate!=''){
			$dt=str_replace('[event date] ',$edate, $dt);
			}
			if($rows['who_event_sponsor']!=''){
			$dt=str_replace('[insert sponsor name]',$rows['who_event_sponsor'], $dt);
			}
			if($edate!=''){
				$dt=str_replace('[event name on date]','[event name] on '.$edate, $dt);
				
			}
			if($rows['positive_test_date']!=''){
				$dt=str_replace('[date]',$rows['positive_test_date'],$dt);
			}
			if($smpt!=''){
				$dt=str_replace('[symptom onset / the positive test]',$smpt,$dt);
			}
			$dt=str_replace('Case Manager name',$case_manager,$dt);
			$result['body']=$dt;
			//echo'<pre>';print_r($dt);die();
		}
		elseif($rows['email_map_id']=='client_close_contact_email'){

			$edate=str_replace('T',' ', $rows['last_mckinsey_event']);
			$result['to_email']=$rows['what_is_dcs'];//$rws[0]['to_email'];
			$result['cc_email']=$rws[0]['cc_email'];
			$result['subject']=$rws[0]['subject'];//str_replace('[Event Date, Sponsor Name]', $sub,$rws[0]['subject']);
			$smpt=($rows['symptoms_currently']=='Yes')?$rows['date_of_symptom_onset']:$rows['positive_test_date'];
			$entry_date=date('Y-m-d');
			$dt=str_replace('<span style="color:#000;background:#ffff00;padding:2px 0;margin:2px 0 0 0;display:inline-block;font-style:italic;">Ameridial/Fusion email signature</span>','McKinsey COVID Support Team (North America)<br>
			Email: <a href="">McKinseyNACovidSupport@fusionbposervices.com</a><br>
			Phone: Canada- 4382881596, US-8558433307, Mexico- 525571000320',$rws[0]['body']);
			$dt=str_replace('Hello –', 'Hello '.$rows['person'],$dt);
			$dt=str_replace('[date] ',$edate, $dt);
			$dt=str_replace('[symptom onset / positive test if no symptoms]',$smpt, $dt);
			$dt=str_replace('Case Manager name',$case_manager,$dt);
			$dt=str_replace('[approx time, date]',$rows['positive_test_date'],$dt);
			$dt=str_replace('[date of symptom onset / positive test if asymptomatic]',$smpt,$dt);
			//$dt=str_replace('[Client name]','Clients',$dt);
			$dt=str_replace('[location]',$rows['when_you_with_mckinsey'],$dt);
			$dt=str_replace('[date]',$entry_date,$dt);
			$dt=str_replace('DCS name',$rows['who_is_dcs'],$dt);
			$result['body']=$dt;
		}
		elseif($rows['email_map_id']=='colleague_close_contact_email'){
			$result['to_email']='';//$rws[0]['to_email'];
			$result['cc_email']=$rws[0]['cc_email'];
			$result['subject']=$rws[0]['subject'];
			$dt=str_replace('<span style="color:#000;background:#ffff00;padding:2px 0;margin:2px 0 0 0;display:inline-block;font-style:italic;">Ameridial/Fusion email signature</span>','McKinsey COVID Support Team (North America)<br>
			Email: <a href="">McKinseyNACovidSupport@fusionbposervices.com</a><br>
			Phone: Canada- 4382881596, US-8558433307, Mexico- 525571000320',$rws[0]['body']);
			$dt=str_replace('[insert name]', $rows['person'],$dt);
			$dt=str_replace('Case Manager name',$case_manager,$dt);
			$result['body']=$dt;
		}
		elseif($rows['email_map_id']=='drivable_well_email'){
			$result['to_email']='';//$rws[0]['to_email'];
			$result['cc_email']=$rws[0]['cc_email'];
			$result['subject']=$rws[0]['subject'];
			$dt=str_replace('<span style="color:#000;background:#ffff00;padding:2px 0;margin:2px 0 0 0;display:inline-block;font-style:italic;">Ameridial/Fusion email signature</span>','McKinsey COVID Support Team (North America)<br>
			Email: <a href="">McKinseyNACovidSupport@fusionbposervices.com</a><br>
			Phone: Canada- 4382881596, US-8558433307, Mexico- 525571000320',$rws[0]['body']);
			$dt=str_replace('Case Manager name',$case_manager,$dt);
			$result['body']=$dt;
		}
		elseif($rows['email_map_id']=='colleague_away_from_home_email'){
			$result['to_email']='';//$rws[0]['to_email'];
			$result['cc_email']=$rws[0]['cc_email'];
			$result['subject']=$rws[0]['subject'];
			$dt=str_replace('<span style="color:#000;background:#ffff00;padding:2px 0;margin:2px 0 0 0;display:inline-block;font-style:italic;">Ameridial/Fusion email signature</span>','McKinsey COVID Support Team (North America)<br>
			Email: <a href="">McKinseyNACovidSupport@fusionbposervices.com</a><br>
			Phone: Canada- 4382881596, US-8558433307, Mexico- 525571000320',$rws[0]['body']);
			$dt=str_replace('Case Manager name',$case_manager,$dt);
			$result['body']=$dt;
		}
		elseif($rows['email_map_id']=='quarantining_place_email'){
			$result['to_email']='';//$rws[0]['to_email'];
			$result['cc_email']=$rws[0]['cc_email'];
			$result['subject']=$rws[0]['subject'];
		
			$dt=str_replace('<span style="color:#000;background:#ffff00;padding:2px 0;margin:2px 0 0 0;display:inline-block;font-style:italic;">Ameridial/Fusion email signature</span>','McKinsey COVID Support Team (North America)<br>
			Email: <a href="">McKinseyNACovidSupport@fusionbposervices.com</a><br>
			Phone: Canada- 4382881596, US-8558433307, Mexico- 525571000320',$rws[0]['body']);
			
			//$dt=str_replace('[McKinsey home office / home country]',$rows['home_office_lmp'], $dt);
			$dt=str_replace('Case Manager name',$case_manager,$dt);
			$result['body']=$dt;
		}
		
		elseif($rows['email_map_id']=='international_email'){
			$result['to_email']='';//$rws[0]['to_email'];
			$result['cc_email']=$rws[0]['cc_email'];
			$result['subject']=$rws[0]['subject'];
			$lc=$rows['location'].' - '.$rows['city'];
			$dt=str_replace('<span style="color:#000;background:#ffff00;padding:2px 0;margin:2px 0 0 0;display:inline-block;font-style:italic;">Ameridial/Fusion email signature</span>','McKinsey COVID Support Team (North America)<br>
			Email: <a href="">McKinseyNACovidSupport@fusionbposervices.com</a><br>
			Phone: Canada- 4382881596, US-8558433307, Mexico- 525571000320',$rws[0]['body']);
			$dt=str_replace('[location – city, state]',$lc, $dt);
			$dt=str_replace('[McKinsey home office / home country]',$rows['home_office_lmp'], $dt);
			$dt=str_replace('Case Manager name',$case_manager,$dt);
			$result['body']=$dt;
		}
		elseif($rows['email_map_id']=='colleague_ill_5_day_email'){
			$result['to_email']='';//$rws[0]['to_email'];
			$result['cc_email']=$rws[0]['cc_email'];
			$result['subject']=$rws[0]['subject'];
			$dt=str_replace('<span style="color:#000;background:#ffff00;padding:2px 0;margin:2px 0 0 0;display:inline-block;font-style:italic;">Ameridial/Fusion email signature</span>','McKinsey COVID Support Team (North America)<br>
			Email: <a href="">McKinseyNACovidSupport@fusionbposervices.com</a><br>
			Phone: Canada- 4382881596, US-8558433307, Mexico- 525571000320',$rws[0]['body']);
			$dt=str_replace('Hello –','Hello '.$rows['person'], $dt);
			$dt=str_replace('[Name of sick colleague]',$rows['person'], $dt);
			$dt=str_replace('Case Manager name',$case_manager,$dt);
			$result['body']=$dt;
		}elseif($rows['email_map_id']=='colleague_seriously_ill_email'){
			$result['to_email']='';//$rws[0]['to_email'];
			$result['cc_email']=$rws[0]['cc_email'];
			$result['subject']=$rws[0]['subject'];
			$dt=str_replace('<span style="color:#000;background:#ffff00;padding:2px 0;margin:2px 0 0 0;display:inline-block;font-style:italic;">Ameridial/Fusion email signature</span>','McKinsey COVID Support Team (North America)<br>
			Email: <a href="">McKinseyNACovidSupport@fusionbposervices.com</a><br>
			Phone: Canada- 4382881596, US-8558433307, Mexico- 525571000320',$rws[0]['body']);
			$dt=str_replace('Case Manager name',$case_manager,$dt);
			$result['body']=$dt;
		}elseif($rows['email_map_id']=='colleague_exhibiting_email'){
			$result['to_email']='';//$rws[0]['to_email'];
			$result['cc_email']=$rws[0]['cc_email'];
			$result['subject']=$rws[0]['subject'];
			$dt=str_replace('<span style="color:#000;background:#ffff00;padding:2px 0;margin:2px 0 0 0;display:inline-block;font-style:italic;">Ameridial/Fusion email signature</span>','McKinsey COVID Support Team (North America)<br>
			Email: <a href="">McKinseyNACovidSupport@fusionbposervices.com</a><br>
			Phone: Canada- 4382881596, US-8558433307, Mexico- 525571000320',$rws[0]['body']);
			$dt=str_replace('Case Manager name',$case_manager,$dt);
			$result['body']=$dt;
		}
		elseif($rows['email_map_id']=='colleague_underlying_complications_email'){
			$result['to_email']='';//$rws[0]['to_email'];
			$result['cc_email']=$rws[0]['cc_email'];
			$result['subject']=$rws[0]['subject'];
			$dt=str_replace('<span style="color:#000;background:#ffff00;padding:2px 0;margin:2px 0 0 0;display:inline-block;font-style:italic;">Ameridial/Fusion email signature</span>','McKinsey COVID Support Team (North America)<br>
			Email: <a href="">McKinseyNACovidSupport@fusionbposervices.com</a><br>
			Phone: Canada- 4382881596, US-8558433307, Mexico- 525571000320',$rws[0]['body']);
			$dt=str_replace('Case Manager name',$case_manager,$dt);
			$result['body']=$dt;
		}
		elseif($rows['email_map_id']=='confirm'){
			$result['to_email']='';//$rws[0]['to_email'];
			$result['cc_email']=$rws[0]['cc_email'];
			$result['subject']=$rws[0]['subject'];
			$dt=str_replace('<span style="color:#000;background:#ffff00;padding:2px 0;margin:2px 0 0 0;display:inline-block;font-style:italic;">Ameridial/Fusion email signature</span>','McKinsey COVID Support Team (North America)<br>
			Email: <a href="">McKinseyNACovidSupport@fusionbposervices.com</a><br>
			Phone: Canada- 4382881596, US-8558433307, Mexico- 525571000320',$rws[0]['body']);
			$dt=str_replace('Case Manager name',$case_manager,$dt);
			$result['body']=$dt;
		}
		elseif($rows['email_map_id']=='close_contact'){
			$result['to_email']='';//$rws[0]['to_email'];
			$result['cc_email']=$rws[0]['cc_email'];
			$result['subject']=$rws[0]['subject'];
			$dt=str_replace('<span style="color:#000;background:#ffff00;padding:2px 0;margin:2px 0 0 0;display:inline-block;font-style:italic;">Ameridial/Fusion email signature</span>','McKinsey COVID Support Team (North America)<br>
			Email: <a href="">McKinseyNACovidSupport@fusionbposervices.com</a><br>
			Phone: Canada- 4382881596, US-8558433307, Mexico- 525571000320',$rws[0]['body']);
			$dt=str_replace('Case Manager name',$case_manager,$dt);
			$result['body']=$dt;
		}
		elseif($rows['email_map_id']=='auto_reply'){
			$result['to_email']='';//$rws[0]['to_email'];
			$result['cc_email']=$rws[0]['cc_email'];
			$result['subject']=$rws[0]['subject'];
			$dt=str_replace('<span style="color:#000;background:#ffff00;padding:2px 0;margin:2px 0 0 0;display:inline-block;font-style:italic;">Ameridial/Fusion email signature</span>','McKinsey COVID Support Team (North America)<br>
			Email: <a href="">McKinseyNACovidSupport@fusionbposervices.com</a><br>
			Phone: Canada- 4382881596, US-8558433307, Mexico- 525571000320',$rws[0]['body']);
			$dt=str_replace('Case Manager name',$case_manager,$dt);
			$result['body']=$dt;
		}	
		else{
			$result=$rws[0];
		}
		
		echo json_encode($result);
	}
	public function send_mail(){
		$rows=$_POST;
		//echo'<pre>';print_r($rows);
		$msg="";
		$name = '';
	 	$from_email="noreply.fems@fusionbposervices.com";
		$from_name="Fusion FEMS";
		$eto=$rows['to_email'];//'souvik.mondal@omindtech.com';//
		$email_subject=$rows['subject'];
		$uid= get_user_id();
		$nbody=$rows['summernote'];
		//echo'<pre>';print_r($nbody);
		$pathurl="";
		
			 $msg=$this->Email_model->send_email_sox($uid, $eto, $ecc, $nbody, $email_subject, $pathurl,$from_email,$from_name,'N');
		 
		if($msg==1){
			$emailData=[
				"incident_id"=>$rows['incident_id'],
				"to_email"=>$rows['to_email'],
				"cc_email"=>$rows['cc_mail'],
				"subject"=>$rows['subject'],
				"email_body"=>$nbody,
				"sender_id"=>$uid,
				"sended_on"=>date('Y-m-d H:i:s'),
				'status'=>'send',
			];
			data_inserter('mckinsey_email_log', $emailData);
		}else{
			$emailData=[
				"incident_id"=>$rows['incident_id'],
				"to_email"=>$rows['to_email'],
				"cc_email"=>$rows['cc_mail'],
				"subject"=>$rows['subject'],
				"email_body"=>$nbody,
				"sender_id"=>$uid,
				"sended_on"=>date('Y-m-d H:i:s'),
				'status'=>'failed',
			];
			data_inserter('mckinsey_email_log', $emailData);
		}
		echo $msg;
	}
	public function get_mail_log(){
		$rows=$_POST;
		$sql="select * from `mckinsey_email_log` where `incident_id`='".$rows['incident_id']."'";
		$rws=$this->Common_model->get_query_result_array($sql);
		$result=$rws[0];
		echo json_encode($result);
	} 
	public function case_info(){
		$id=$_POST['case_id'];
		if($id=='confirm'){
		?>
			<html>
				<head>
					<title>E-mail Template</title>
					<link rel="preconnect" href="https://fonts.googleapis.com">
			<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
			<link href="https://fonts.googleapis.com/css2?family=PT+Sans&display=swap" rel="stylesheet">
				</head>
				<body>
					<div style="width:720px;margin:0 auto;max-width:100%;font-family: 'PT Sans', sans-serif;font-size:15px;line-height:22px;">
						
						<p>				
							Thank you for reaching out / answering
						</p>			
						<p>				
							Note: Who we are / what we’ll do / who we are not
						</p>
						<ul style="margin:0;">
							<li style="margin:0 0 3px 0;font-family: 'PT Sans', sans-serif;font-size:15px;">
								We are a group of agents through an external COVID Case Management service contracted through McKinsey's North American office to be the primary point of contact for colleagues in North America who are impacted by COVID-19 - whether positive, exposed, or inquiring about COVID.
							</li>
							<li style="margin:0 0 3px 0;font-family: 'PT Sans', sans-serif;font-size:15px;">
								We are NOT medical providers - any guidance we discuss during today's discussion or in follow-ups is based on CDC guidance and McKinsey's NA protocols
							</li>
							<li style="margin:0 0 3px 0;font-family: 'PT Sans', sans-serif;font-size:15px;">
								Our primary objective will be to ensure:
								<ul>
									<li style="margin:0 0 3px 0;font-family: 'PT Sans', sans-serif;font-size:15px;">
										You understand the instructions about isolation/quarantine and comply with same
									</li>
									<li style="margin:0 0 3px 0;font-family: 'PT Sans', sans-serif;font-size:15px;">
										You have the medical, mental health, & other Firm resources you need (will send in follow-up note; is in automatic response if emailed as well)
									</li>
									<li style="margin:0 0 3px 0;font-family: 'PT Sans', sans-serif;font-size:15px;">
										Timely and accurate contact tracing of exposed McKinsey colleagues and/or clients; Providing quarantine, travel, and symptom monitoring/testing instruction to all close contacts in professional setting (not personal contacts but will send you information so you can provide to them, as needed)
									</li>
									<li style="margin:0 0 3px 0;font-family: 'PT Sans', sans-serif;font-size:15px;">
										Tracking & reporting on the health status of NA colleagues & reporting at aggregated level to leadership team
									</li>
								</ul>
							</li>
							<li style="margin:0 0 3px 0;font-family: 'PT Sans', sans-serif;font-size:15px;">
								Note: we will never share your name directly with your close contacts, clients, CST leadership, or OMP / Office Services teams without your permission to do so.  We will need to share your name & details of your situation (potentially) with our case management leadership from McKinsey - both individuals (Gretchen Scheidler, Sarah Althaus) are in the NA People leadership team (PD, HR) and will use extreme discretion.  Have you already shared your status with others? (Y/N)
							</li>
						</ul>
						<p>
							Before we begin, let me get a few logistical questions out of the way:
						</p>
					</div>
				</body>
			</html>
		<?php	
		}elseif($id=='close_contact'){
		?>
			<html>
					<head>
						<title>E-mail Template</title>
						<link rel="preconnect" href="https://fonts.googleapis.com">
				<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
				<link href="https://fonts.googleapis.com/css2?family=PT+Sans&display=swap" rel="stylesheet">
					</head>
					<body>
						<div style="width:720px;margin:0 auto;max-width:100%;font-family: 'PT Sans', sans-serif;font-size:15px;line-height:22px;">
							
							<p>				
								Calling from NA COVID-19 case management team
							</p>			
							<p>				
								We are a group of PD&HR colleagues who are the primary point of contact for colleagues in NA who are impacted by COVID-19 (or are sick and worried that they might be).
							</p>
							<p>				
								I'll be your primary point of contact and will work with you to ensure:
							</p>
							<ul style="margin:0;">
								<li style="margin:0 0 3px 0;font-family: 'PT Sans', sans-serif;font-size:15px;">
									You understand the instructions about isolation and symptom management, given your current situation
								</li>				
								<li style="margin:0 0 3px 0;font-family: 'PT Sans', sans-serif;font-size:15px;">
									You have the medical & mental health resources you need (reference Box folder link from na-coronavirus-response mailbox)
									<ul>
										<li style="margin:0 0 3px 0;font-family: 'PT Sans', sans-serif;font-size:15px;">
											We are keeping our colleagues and clients safe by contact tracing (and giving isolation instructions); Informing you of same for your family or friends, as applicable
										</li>
									</ul>
								</li>
								<li style="margin:0 0 3px 0;font-family: 'PT Sans', sans-serif;font-size:15px;">
									 We are monitoring the health status of our colleagues in NA (and reporting on numbers of cases, symptoms, etc. to NA leadership)
								</li>
							</ul>
							<p>
								I will be here to support you throughout the time you are feeling sick, providing you with information on firm resources, facilitating their use, and serving as your central point of contact for all communications with other firm members
							</p>
							<p>
								What is your preferred phone # and email (if someone covering inbox) for the duration of case management?
							</p>
							<p>
								In the unfortunate circumstance that you need to go to the hospital, we will trust the healthcare system to care for you medically and we will contact your emergency contacts and family. Could you please provide me with the list of those people? Do we have your permission to contact them?
							</p>
							<p>
								I'll also liaise with the Location Managing Partner and the DCS(s) of your CSTs (if relevant) to ensure that they are aware of the suspect & confirmed cases in their offices & CSTs.  In doing so, are you comfortable with me sharing your name? There's NO pressure...it's just that they will likely want to reach out and offer their well wishes & support if you do become ill
							</p>
							<p>
								I will ask you a number of questions today. I am not your healthcare provider, nor is the Firm
							</p>
							<p>
								[Check that colleague is receiving quality medical advice, if applicable, during call - Note list of urgent care centers tied in to health systems with critical care capabilities in their city – on Box] 
							</p>
							<p>
								I'm unfortunately calling to let you know that you have been identified as a close contact of a [confirmed or suspect case of] COVID-19
							</p>
						</div>
					</body>
				</html>
		<?php
		}
		elseif($id=='event_case'){
			?>
				<html>
					<head>
						<title>E-mail Template</title>
						<link rel="preconnect" href="https://fonts.googleapis.com">
				<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
				<link href="https://fonts.googleapis.com/css2?family=PT+Sans&display=swap" rel="stylesheet">
					</head>
					<body>
						<div style="width:720px;margin:0 auto;max-width:100%;font-family: 'PT Sans', sans-serif;font-size:15px;line-height:22px;">
							
							<p>				
								Calling from NA COVID-19 case management team. 
							</p>			
							<p>				
								We are a group of PD&HR colleagues who are the primary point of contact for colleagues in NA who are impacted by COVID-19 (or are sick and worried that they might be).
							</p>
							<p>				
								I'll be your primary point of contact and will work with you to ensure: 
							</p>
							<ul style="margin:0;">
								<li style="margin:0 0 3px 0;font-family: 'PT Sans', sans-serif;font-size:15px;">
									You understand the instructions about isolation and symptom management, given your current situation
								</li>				
								<li style="margin:0 0 3px 0;font-family: 'PT Sans', sans-serif;font-size:15px;">
									You have the medical & mental health resources you need (reference Box folder link from na-coronavirus-response mailbox)					
								</li>
								<li style="margin:0 0 3px 0;font-family: 'PT Sans', sans-serif;font-size:15px;">
									We are keeping our colleagues and clients safe by contact tracing (and giving isolation instructions); Informing you of same for your family or friends, as applicable
								</li>
								<li style="margin:0 0 3px 0;font-family: 'PT Sans', sans-serif;font-size:15px;">
									We are monitoring the health status of our colleagues in NA (and reporting on numbers of cases, symptoms, etc. to NA leadership)
								</li>
							</ul>
							<p>
								I will be here to support you throughout the time you are feeling sick, providing you with information on firm resources, facilitating their use, and serving as your central point of contact for all communications with other firm members
							</p>
							<p>
								What is your preferred phone # and email (if someone covering inbox) for the duration of case management? 
							</p>
							<p>
								In the unfortunate circumstance that you need to go to the hospital, we will trust the healthcare system to care for you medically and we will contact your emergency contacts and family. Could you please provide me with the list of those people? Do we have your permission to contact them?
							</p>
							<p>
								I'll also liaise with the Location Managing Partner and the DCS(s) of your CSTs (if relevant) to ensure that they are aware of the suspect & confirmed cases in their offices & CSTs.  In doing so, are you comfortable with me sharing your name? There's NO pressure...it's just that they will likely want to reach out and offer their well wishes & support if you test positive or are sick.
							</p>
							<p>
								I will ask you a number of questions today. I am not your healthcare provider, nor is the Firm Check that colleague is receiving quality medical advice
							</p>
							<p>
								Wanted to connect with you to give advice, and also to gather details regarding any potential close contacts that you may have had
							</p>
							<p>
								Advise that this conversation is confidential and that information will be de-identified and restricted to a limited number of People and contact tracing colleagues only
							</p>
							<p>
								Check if the colleague is at his home/hotel/hospital & in self-isolation (more on that below)
							</p>
						</div>
					</body>
				</html>
			<?php
			}
	}
	public function report($type){
		if($type=='close_contacts'){
			$start_date=$this->input->post('start_date');
			$end_date=$this->input->post('end_date');
			if($start_date!=""){
				$data['start_date']=$start_date;
				$extra.=" AND date>='".$start_date."'";
			}
			
			if($end_date!=""){
				$data['end_date']=$end_date;
				$extra.=" AND date<='".$end_date."'";
			}

			$sql="SELECT * FROM  `mckinsey_close_contact`  where status='1' and fname!='' and lname!='' $extra";
			$data['case_list']=$this->Common_model->get_query_result_array($sql);

			//echo'<pre>';print_r($data['case_list']);

			$this->load->view('contact_tracing_crm/mackinsy/close_contact_report',$data);	
		}
		if($type=='all_cases'){

			$start_date=$this->input->post('start_date');
			$end_date=$this->input->post('end_date');
			if($start_date!=""){
				$data['start_date']=$start_date;
				$extra.=" AND added_date>='".$start_date."'";
			}
			if($end_date!=""){
				$data['end_date']=$end_date;
				$extra.=" AND added_date<='".$end_date."'";
			}
			
	
	
			  	$sql="select * from contract_tracing_mckinsey  where status='A' or status='c'  $extra";
				$data['case_list']=$rows=$this->Common_model->get_query_result_array($sql);
				$this->load->view('contact_tracing_crm/mackinsy/all_cases_report',$data);
			if($_POST['download']=='download_report'){
						$CurWorksheet = -1;
						$title = "All Cases Data ";
						$CurWorksheet++;
						$this->objPHPExcel->createSheet($CurWorksheet);
						$this->objPHPExcel->setActiveSheetIndex($CurWorksheet);
						$objWorksheet = $this->objPHPExcel->getActiveSheet($CurWorksheet);
						$objWorksheet->setTitle($title);
						
						$objWorksheet->setShowGridlines(true);
						$this->objPHPExcel->getDefaultStyle()->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
						$this->objPHPExcel->getDefaultStyle()->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
						$this->objPHPExcel->getActiveSheet($CurWorksheet)->getStyle('A1:V1'.$this->objPHPExcel->getActiveSheet($CurWorksheet)->getHighestRow())->getAlignment()->setWrapText(true);
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
						$objWorksheet->getColumnDimension('W')->setAutoSize(true);
						$objWorksheet->getColumnDimension('X')->setAutoSize(true);
						$objWorksheet->getColumnDimension('Y')->setAutoSize(true);
						$objWorksheet->getColumnDimension('Z')->setAutoSize(true);
						

						/*$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow(0,2, "Name of Facility:");
						$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow(0,3, "Caller Name:");
						$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow(0,4, "Contact Number:");
						$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow(0,5, "Contact Email:");
						$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow(0,6, "Facility Address:");*/
	
	
						$r=0; $c = 2;			
						$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Sl");
						$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Name");
						$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Communication");
						$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Phone");
						$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "FMNO");
						$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Email");
						$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Location");
						$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Country");
						$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "City");
						$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Case Manager");
						$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Assess situation");
						$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Assumed Location of exposure)");
						$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Impacted Mck Office");
						$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Contact status");
						$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Date of symptom onset ");
						$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Positive test date ");
						$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Isolation/quarantine start date");
						$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Isolation/quarantine end date");
						$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Symptoms currently");
						$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Are you fully vaccinated? ");
						$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Are you Boosted?");
						$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Do you have a medical provider / Primary Care Provider? ");
						$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Any needs currently? Things about which you are worried / stressed ");
						$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Case Manager notes");
						$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "symptoms");
						$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Emergency warning signs ");
						$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "When were you last with McKinsey colleagues or clients?");
						$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "When were you last with clients?");
						$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Who is the DCS - Responsible Sr Partner - for your engagement or the client?");
						$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "What is DCS's email? ");
						$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "When were you last in a McKinsey office?");
						$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Which one? ");
						$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Only if applicable: When were you last attending a Mckinsey Event?");
						$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Who is the event sponsor? (Partner, senior Firm leader) (name, spelled)");
						$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "What is event sponsor's email? ");
						$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Is event sponsor already aware?");
						$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Contact Tracing ");
						$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "client contacts notified");
						$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "firm contacts notified ");
						$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Colleague working in McKinsey office (in last 48 hours) ");
						$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Colleague at McKinsey event & close contacts (in last 48 hours) ");
						$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Colleague with client close contacts (in last 48 hours) ");
						$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Colleague / close contacts still interacting (e.g., ongoing office meeting, client meeting, event) & need urgent next steps");
						$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Colleague ill 5+ days ");
						$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Colleague away from home (confirmed or ‘not up to date on vaccination’ close contact) ");
						$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Drivable & well ");
						$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Isolating / quarantining in place (hotel)");
						$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "International ");
						$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Colleague seriously ill / ED visit / admitted to hospital");
						$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Colleague exhibiting or reporting anxiety / duress");
						$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, "Colleague with underlying complications / seeking second opinion");
						
						
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
					
						$this->objPHPExcel->setActiveSheetIndex($CurWorksheet)->mergeCells('A1:N1');
						$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValue('A1', "All Cases");
						$this->objPHPExcel->getActiveSheet($CurWorksheet)->getRowDimension('1')->setRowHeight(40);
						$this->objPHPExcel->getActiveSheet($CurWorksheet)->getStyle('A1')->applyFromArray($headerArray);
					
					
						/*$this->objPHPExcel->getActiveSheet($CurWorksheet)->getStyle('A1:BL2')->applyFromArray($styleArray);
						$this->objPHPExcel->getActiveSheet($CurWorksheet)->getStyle('A1:BL2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('000000');*/
					
						$sl=0;
						foreach($rows as $wk=>$wv)
						{

							$sl++;
							
							

							
							//echo'<br>'.$wv["test_type"].'***'.$test_type;die();
							/*$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow(1,2, $namefacility);
							$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow(1,3, $caller_name);
							$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow(1,4, $caller_phone);
							$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow(1,5, $facility_contact_mail);
							$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow(1,6, $facility_address);*/

							$c++; $r=0; 
							$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $sl);
							$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv['name']);
							$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv['communication']);
							$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv['phone']);
							$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv['fmno']);
							$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv['email']);
							$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv['location']);
							
							$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $this->get_countrt_name($wv['country']));
							$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv['city']);
							$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c,$wv['case_manager']);
							$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv['assess_situation']);
							$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv['assumed_location_exposer']);
							$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv['home_office_lmp']);
							$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv['contact_status']);
							//$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv['contract_tracing']);
							//$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv['date_mck_notified']);
							
							$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv['date_of_symptom_onset']);
							$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv['positive_test_date']);
							$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv['self_lsolated_start_date']);
							$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv['self_isolated_end_date']);
							
							
							$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv['symptoms_currently']);
							$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv['fully_vaccinated']);
							$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv['you_boosted']);
							$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv['medical_primary_provider']);
							$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv['you_worried	']);
							$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv['case_manager_notes']);
							$symptom=$this->get_symptom_names($wv['symptoms']);
							$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c,$symptom);
							$medical_attention=$this->get_medical_attendence($wv['medical_attention']);
							$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $medical_attention);
							$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv['last_mckinsey_colleagues']);
							$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv['last_clients']);
							$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv['last_mckinsey_office']);
							$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv['which_one']);
							$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv['who_is_dcs']);
							$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c,$wv['what_is_dcs']);$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv['dcs_already_aware']);
							$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv['last_attending_mckinsey_event']);
							$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv['who_event_sponsor']);
							$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv['event_sponsor_email']);
							$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv['sponsor_already_aware']);
							$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv['contract_tracing']);
							$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c,$wv['client_contacts_notified']);
							$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv['firm_contacts_notified']);

							$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv['working_mckinsey_office']);
							$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv['mckinsey_event_close_contact']);
							$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv['client_close_contact']);
							$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv['colleague_close_contact']);
							$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv['colleague_ill_5_day']);
							$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv['colleague_away_from_home']);
							$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c,$wv['drivable_well']);$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv['quarantining_place']);
							$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv['international']);
							$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv['colleague_seriously_ill']);
							$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv['colleague_exhibiting']);
							$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv['colleague_underlying_complications']);
							

							
							/*$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c,$wv['name']);$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $sl);
							$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv['name']);
							$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv['name']);
							$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv['name']);
							$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv['name']);
							$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv['name']);
							$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv['name']);
							$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv['name']);
							$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv['name']);
							$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv['name']);
							$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c,$wv['name']);
							
							$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv['name']);
							$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv['name']);
							$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv['name']);
							$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv['name']);
							$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv['name']);
							$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv['name']);
							$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv['name']);
							$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv['name']);
							$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c, $wv['name']);
							$this->objPHPExcel->getActiveSheet($CurWorksheet)->setCellValueByColumnAndRow($r++,$c,$wv['name']);*/
						}
					
				
				$this->objPHPExcel->setActiveSheetIndex(0);
				$new_header = "Mckinsey_case_reports.xlsx";
				ob_end_clean();
				header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
				header('Content-Disposition: attachment;filename="'.$new_header.'"');
				header('Cache-Control: max-age=0');
				$objWriter = PHPExcel_IOFactory::createWriter($this->objPHPExcel , 'Excel2007');
				$objWriter->setIncludeCharts(TRUE);
				$objWriter->save('php://output');
				exit();
				}
			}	
		}

	public function get_countrt_name($id){
		$name="";
		if($id==1){
			$name="Canada";
		}elseif($id==2){
			$name="Mexico";
		}elseif($id==3){
			$name="United States";
		}
		return $name;
	}
	public function get_symptom_names($id){
		$ids=explode(',',$id);
		$symptom_id=implode("','",$ids);
		$name="";
		$sql="select * from mckinsey_symptoms where id in('".$symptom_id."')";
		$rows=$this->Common_model->get_query_result_array($sql);
		$i=1;
		foreach($rows as $key=>$tr){
			if($i==1){
				$name=$tr['name'];
			}else{
				$name=$name.','.$tr['name'];
			}
			$i++;
		}
		return $name;

	}
	public function get_medical_attendence($id){
		$ids=explode(',',$id);
		$symptom_id=implode("','",$ids);
		$name="";
		$sql="select * from mckinsey_medical_attention where id in('".$symptom_id."')";
		$rows=$this->Common_model->get_query_result_array($sql);
		$i=1;
		foreach($rows as $key=>$tr){
			if($i==1){
				$name=$tr['name'];
			}else{
				$name=$name.','.$tr['name'];
			}
			$i++;
		}
		return $name;

	}
	public function close_case(){
		$case_id=$this->input->get('case_id');
		$update_data=[
			'status'=>'C',
		];
		$this->db->where('case_id', $case_id);
		$this->db->update('contract_tracing_mckinsey', $update_data);
		
	}
}