<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Search_candidate extends CI_Controller {
    
    /////////////////////////////////////////////////////////////////////////////////////////////
    // INDEX PAGE
    /////////////////////////////////////////////////////////////////////////////////////////////
   	
	function __construct() {
		parent::__construct();
		
		$this->load->model('Common_model');
		$this->load->model('user_model');
		$this->load->model('Pmetrix_model');
		$this->load->library('excel');
		$this->load->helper('common_functions_helper');
		$this->load->helper('tl_pmetrix_helper');
		$this->load->helper('pmetrix_helper');
		$this->load->helper('new_pmetrix_helper');		
	}
	 
	//
	//	
    public function index()
    {
        if(check_logged_in()){
						
			$current_user = get_user_id();
			$data['oValue'] = get_user_office_id();
			$data['cValue'] = get_client_ids();
			$data['pValue'] = get_process_ids();
			$data['rValue'] = get_role_dir();
			$is_global_access=get_global_access();
			
			$data["aside_template"] = "search_candidate/aside.php";
			
			$data["content_template"] = "search_candidate/index.php";

			$this->load->view('dashboard',$data);
		}
	}

	public function search_candidate()
	{
		$form_data = $this->input->post();

		if(!empty($form_data)){
		if($form_data['f_name'] != "" && $form_data['l_name'] != "" && $form_data['dob'] != ""){
			$qSql="SELECT *,rol.name as role_name FROM `signin` Left Join office_location inf on signin.office_id = inf.abbr Left Join role rol on signin.role_id = rol.id Left Join role_organization ro on signin.org_role_id = ro.id Left Join client cit on signin.client_id = cit.id Left Join department dpt on signin.dept_id = dpt.id WHERE fname like '%".$form_data['f_name']."%' AND lname like '%".$form_data['l_name']."%' AND dob ='".$form_data['dob']."'";
		}
		elseif ($form_data['phone'] != "") {
			$qSql="SELECT *,rol.name as role_name FROM signin Left Join office_location inf on signin.office_id = inf.abbr Left Join role rol on signin.role_id = rol.id Left Join role_organization ro on signin.org_role_id = ro.id Left Join client cit on signin.client_id = cit.id Left Join department dpt on signin.dept_id = dpt.id WHERE phno = ".$form_data['phone']."";
		}
		elseif ($form_data['mail'] != "") {
			$qSql="SELECT *,rol.name as role_name FROM `signin` Left Join office_location off on signin.office_id = off.abbr Left Join role rol on signin.role_id = rol.id Left Join role_organization ro on signin.org_role_id = ro.id Left Join client cit on signin.client_id = cit.id Left Join department dpt on signin.dept_id = dpt.id Left Join info_personal inf on signin.id = inf.user_id WHERE email_id = '".$form_data['mail']."'";
		}
		elseif ($form_data['adhar'] != "") {
			$qSql="SELECT *,rol.name as role_name FROM `signin` Left Join office_location off on signin.office_id = off.abbr Left Join role rol on signin.role_id = rol.id Left Join role_organization ro on signin.org_role_id = ro.id Left Join client cit on signin.client_id = cit.id Left Join department dpt on signin.dept_id = dpt.id Left Join info_personal inf on signin.id = inf.user_id WHERE social_security_no = '".$form_data['adhar']."'";
		}
		elseif ($form_data['pan'] != "") {
			$qSql="SELECT *,rol.name as role_name FROM `signin` Left Join office_location off on signin.office_id = off.abbr Left Join role rol on signin.role_id = rol.id Left Join role_organization ro on signin.org_role_id = ro.id Left Join client cit on signin.client_id = cit.id Left Join department dpt on signin.dept_id = dpt.id Left Join info_personal inf on signin.id = inf.user_id WHERE pan_no = '".$form_data['pan']."'";
		}
		
		$query = $this->db->query($qSql);
		// print_r($this->db->last_query());
		// print_r($query->result_object());
		// exit;
		if($query){
			$data['user_list'] = $query->result_array();
		}
		else{
			$data['user_list'] = "";
		}
		$data['form_data'] = $form_data;

		$data["aside_template"] = "search_candidate/aside.php";
			
		$data["content_template"] = "search_candidate/manager_users.php";

		$this->load->view('dashboard',$data);
		}
		else{
			redirect(base_url()."search_candidate");
		}

	}

	// public function search()
 //    {
 //        if(check_logged_in()){
		
	// 		$this->check_access();
			
			
	// 		$user_site_id= get_user_site_id();
	// 		$role_id= get_role_id();
			
	// 		$user_office_id=get_user_office_id();
	// 		$ses_dept_id=get_dept_id();
						
	// 		$is_global_access=get_global_access();
	// 		$current_user = get_user_id();
	// 		$ses_process_ids=get_process_ids();
	// 		$user_oth_office=get_user_oth_office();
			
	// 		$data["download_link"] = ""; ///////////////////
	// 		$action="";					 // CSV Report
	// 		$dn_link="";				 ///////////////////
			
	// 		// $data["aside_template"] = ;
	// 		$data["aside_template"] = "Search_candidate/aside.php";
			
	// 		$data["content_template"] = "Search_candidate/manage_users.php";
	// 		$data["error"] = ''; 
			
	// 		$dValue = trim($this->input->post('dept_id'));
	// 		if($dValue=="") $dValue = trim($this->input->get('dept_id'));
			
	// 		$sdValue = trim($this->input->post('sub_dept_id'));
	// 		if($sdValue=="") $sdValue = trim($this->input->get('sub_dept_id'));
			
	// 		$cValue = trim($this->input->post('client_id'));
	// 		if($cValue=="") $cValue = trim($this->input->get('client_id'));
			
	// 		/* $sValue = trim($this->input->post('site_id'));
	// 		if($sValue=="") $sValue = trim($this->input->get('site_id')); */
									
	// 		$oValue = trim($this->input->post('office_id'));
	// 		if($oValue=="") $oValue = trim($this->input->get('office_id'));
			
	// 		$pValue = trim($this->input->post('process_id'));
	// 		if($pValue=="") $pValue = trim($this->input->get('process_id'));
			
	// 		$spValue = trim($this->input->post('sub_process_id'));
	// 		if($spValue=="") $spValue = trim($this->input->get('sub_process_id'));
			
	// 		$rValue = trim($this->input->post('role_id'));
	// 		if($rValue=="") $rValue = trim($this->input->get('role_id'));
			
	// 		$fusionid = trim($this->input->post('fusionid'));
	// 		if($fusionid=="") $fusionid = trim($this->input->get('fusionid'));
			
	// 		$status = trim($this->input->post('status'));
	// 		if($status=="") $status = trim($this->input->get('status'));
	// 		if($status=="") $status=1;
			
			
			
	// 		if($dValue=="") $dValue=$ses_dept_id;
	// 		if($oValue=="") $oValue=$user_office_id;

	// 		if($is_global_access!=1){
	// 			if($oValue=="") $oValue=$user_office_id;
	// 		}
			
	// 		if($status==1) $_filterCond=" role_id > 0 and status in (1,2,3) ";
	// 		else if($status==6) $_filterCond=" role_id > 0 and status in (5,6) ";
	// 		else if($status==9) $_filterCond=" role_id > 0 and status in (8,9) ";
	// 		else $_filterCond=" role_id > 0 and status=".$status;
			
	// 		if($is_global_access!=1){
	// 			if($_filterCond=="") $_filterCond .=" role_id>0 ";
	// 			else $_filterCond .=" and role_id>0 ";
	// 		}
			
	// 		if($dValue!="ALL" && $dValue!=""){
	// 			if($_filterCond=="") $_filterCond .= " dept_id='".$dValue."'";
	// 			else $_filterCond .= " and dept_id='".$dValue."'";
	// 		}
						
	// 		if($sdValue!="ALL" && $sdValue!=""){
	// 			if($_filterCond=="") $_filterCond .= " sub_dept_id='".$sdValue."'";
	// 			else $_filterCond .= " and sub_dept_id='".$sdValue."'";
	// 		}
			
	// 		if($cValue!="ALL" && $cValue!=""){
	// 			//if($_filterCond=="") $_filterCond .= " client_id='".$cValue."'";
	// 			//else $_filterCond .= " and client_id='".$cValue."'";
				
	// 			if($_filterCond=="") $_filterCond .= " is_assign_client (b.id,$cValue)";
	// 			else $_filterCond .= " and is_assign_client (b.id,$cValue)";
				
	// 		}
			
	// 		/* if($sValue!="ALL" && $sValue!=""){
	// 			if($_filterCond=="") $_filterCond .= " site_id='".$sValue."'";
	// 			else $_filterCond .= " And site_id='".$sValue."'";
	// 		} */
			
	// 		if($oValue!="ALL" && $oValue!=""){
	// 			if($_filterCond=="") $_filterCond .= " office_id='".$oValue."'";
	// 			else $_filterCond .= " And office_id='".$oValue."'";
	// 		}
			
	// 		if($pValue!="ALL" && $pValue!="" && $pValue!="0"){
	// 			//if($_filterCond=="") $_filterCond .= " process_id='".$pValue."'";
	// 			//else $_filterCond .= " And process_id='".$pValue."'";
				
	// 			if($_filterCond=="") $_filterCond .= " is_assign_process (b.id,$pValue)";
	// 			else $_filterCond .= " and is_assign_process (b.id,$pValue)";
	// 		}
			
	// 		if($spValue!="ALL" && $spValue!=""){
	// 			if($_filterCond=="") $_filterCond .= " sub_process_id='".$spValue."'";
	// 			else $_filterCond .= " And sub_process_id='".$spValue."'";
	// 		}
			
	// 		if($rValue!="ALL" && $rValue!=""){
	// 			if($_filterCond=="") $_filterCond .= " role_id='".$rValue."'";
	// 			else $_filterCond .= " And role_id='".$rValue."'";
	// 		}
			
			
	// 		$data['fusionid']=$fusionid;
			
	// 		if($fusionid!=""){
				
	// 			$fusionid = str_replace(",","','",$fusionid);
				
	// 			if($_filterCond=="") $_filterCond .= " fusion_id in ('".$fusionid."') ";
	// 			else $_filterCond .= " And fusion_id in ('".$fusionid."') ";
	// 		}
			
	// 		//if(get_role_dir()!="admin" && get_role_dir()!="super" && get_role_dir()!="support" && get_role_dir()!="head" && get_dept_folder()=="hr" && get_dept_folder()=="rta" && get_dept_folder()=="wfm") $_filterCond .=" And (site_id='$user_site_id' OR office_id='$user_office_id') ";
			
	// 		if($is_global_access!=1) $_filterCond .=" And (office_id='$user_office_id' OR '$user_oth_office' like CONCAT('%',office_id,'%') )";
						
	// 		if((get_role_dir()=="tl" || get_role_dir()=="trainer" || get_role_dir()=="manager") && ($is_global_access !=1 && get_dept_folder()!="mis" && get_dept_folder()!="hr" && get_dept_folder()!="wfm" )){
				
	// 				//$assToCond = " (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where  assigned_to ='$current_user')) ";
					
	// 				$assToCond = " (assigned_to='$current_user' OR (is_assign_process(b.id,'$ses_process_ids')=1 AND dept_id='$ses_dept_id') OR (assigned_to in (SELECT id FROM signin where  assigned_to ='$current_user')) OR (assigned_to in (SELECT id FROM signin where assigned_to in (SELECT id FROM signin where  assigned_to ='$current_user' ))) ) ";
					
	// 				if($_filterCond=="") $_filterCond .= $assToCond;
	// 				else $_filterCond .= " And " . $assToCond;
	// 		}
			
	// 		if($is_global_access==1 || get_role_dir()=="admin"){
				
	// 			$qSql="SELECT id,name FROM role where is_active=1 and id > 0 ORDER BY name";	
				
	// 			$data['role_list'] = $this->Common_model->get_rolls_for_assignment2($qSql);
			
	// 		}else if(get_role_dir()=="tl" || get_role_dir()=="trainer"){
			
	// 			$qSql="SELECT id,name FROM role where is_active=1 and folder not in('super','admin') ORDER BY name";
	// 			$data['role_list'] = $this->Common_model->get_rolls_for_assignment2($qSql);
				
	// 		}else{
	// 			$qSql="SELECT id,name FROM role where is_active=1 and folder not in('super') ORDER BY name";
	// 			$data['role_list'] = $this->Common_model->get_rolls_for_assignment2($qSql);
	// 		}
			
	// 		//if($role_id>'1' && $role_id<'6'){
	// 		//if(get_role_dir()!="super" && get_role_dir()!="admin"){
	// 		if(get_role_dir()!="super" && $is_global_access!=1){
	// 			//$tl_cnd=" and site_id=".$user_site_id;
	// 			$tl_cnd=" and office_id='$user_office_id' ";
	// 			$data['tl_list'] = $this->Common_model->get_tls_for_assign2($tl_cnd);
				
	// 		}else $data['tl_list'] = $this->Common_model->get_tls_for_assign2("");
					
			
	// 		if(get_role_dir()=="super" || $is_global_access==1 ){ 
			
	// 			$data['location_list'] = $this->Common_model->get_office_location_list();
	// 			$data['site_list'] = $this->Common_model->get_sites_for_assign();
	// 		}else{
	// 			$sCond=" Where id = '$user_site_id'";
	// 			$data['site_list'] = $this->Common_model->get_sites_for_assign2($sCond);
	// 			$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
	// 		}
						
	// 		$data['sub_department_list'] = $this->Common_model->get_sub_department_list($dValue);
			
			
	// 		if($is_global_access=='1' ||  get_role_dir()=="admin" || get_dept_folder()=="hr" || get_dept_folder()=="wfm" || is_all_dept_access() ){
				
	// 			$data['department_list'] = $this->Common_model->get_department_list();
				
	// 			if($dValue=="ALL" || $dValue=="") $data['sub_department_list'] = array();
	// 			else $data['sub_department_list'] = $this->Common_model->get_sub_department_list($dValue);
				
	// 		}else{
	// 			$data['department_list'] = $this->Common_model->get_department_session($ses_dept_id);
	// 			$data['sub_department_list'] = $this->Common_model->get_sub_department_list($ses_dept_id);
	// 		}
			
						
	// 		/*
	// 		if($is_global_access==1 ||  get_role_dir()=="admin"){
				
	// 			$data['department_list'] = $this->Common_model->get_department_list();
				
	// 			if($dValue=="ALL" || $dValue=="") $data['sub_department_list'] = array();
	// 			else $data['sub_department_list'] = $this->Common_model->get_sub_department_list($dValue);
				
	// 		}else{
				
	// 			$data['department_list'] = $this->Common_model->get_department_session($ses_dept_id);
	// 			$data['sub_department_list'] = $this->Common_model->get_sub_department_list($ses_dept_id);
	// 		}
	// 		*/
		
			
	// 		$qSql="Select id,name from master_term_type where is_active=1";
	// 		$data['ttype_list'] = $this->Common_model->get_query_result_array($qSql);
			
	// 		$qSql="Select id,name from master_sub_term_type where is_active=1";
	// 		$data['sub_ttype_list'] = $this->Common_model->get_query_result_array($qSql);
			
	// 		$qSql="Select id,description from master_resign_reason where is_active=1";
	// 		$data['resign_reason'] = $this->Common_model->get_query_result_array($qSql);
			
	// 		$data['client_list'] = $this->Common_model->get_client_list();
	// 		$data['process_list'] = $this->Common_model->get_process_for_assign();
			
	// 		if($current_user==20399 || $current_user == 20400){
	// 					$data['client_list'] = array();
	// 					$data['process_list'] = array();
	// 		}
			
	// 		// Phase List
	// 		$data['phaseList'] = $this->display_user_phase('', 'array');
					
	// 		$fullArray = $this->Common_model->get_manage_ulist($_filterCond);
	// 		$data['user_list'] = $fullArray;
			
	// 		$this->create_CSV($fullArray);					//////////////////////////////
	// 														//// CSV Report
	// 		$dn_link = base_url()."user/downloadCsv";		//////////////////////////////
						
	// 		if($pValue!="" && $pValue!="ALL") $data['sub_process_list'] = $this->Common_model->get_sub_process_list($pValue);
	// 		else $data['sub_process_list']=array();
		
	// 		$data['dValue']=$dValue;
	// 		$data['sdValue']=$sdValue;
			
	// 		$data['cValue']=$cValue;
	// 		$data['oValue']=$oValue;
	// 		//$data['sValue']=$sValue;
	// 		$data['pValue']=$pValue;
	// 		$data['spValue']=$spValue;
	// 		$data['rValue']=$rValue;
			
	// 		$data['status']=$status;
			
	// 		$data['download_link']=$dn_link;	//////////////////////////////
	// 											//// CSV Report
	// 		$data["action"] = $action;			//////////////////////////////
		
	// 		$this->load->view('dashboard',$data);
			
	// 	}
 //    }	

}