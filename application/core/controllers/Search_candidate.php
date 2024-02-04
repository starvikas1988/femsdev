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
				
			if(get_global_access()=='1' ||  get_site_admin()=='1' || get_dept_folder()=="hr" || get_dept_folder()=="wfm"  || get_dept_folder()=="rta"   ){
				$data['oValue'] = get_user_office_id();
				$data['cValue'] = get_client_ids();
				$data['pValue'] = get_process_ids();
				$data['rValue'] = get_role_dir();
				
				$data["aside_template"] = "search_candidate/aside.php";
				
				$data["content_template"] = "search_candidate/index.php";

				$this->load->view('dashboard',$data);
			}
			else{
				redirect($_SERVER['HTTP_REFRER']);
			}
		}
	}

	public function candidates()
	{
		$form_data = $this->input->post();

		if(!empty($form_data)){
		if($form_data['f_name'] != "" && $form_data['l_name'] != "" ){
			$qSql="SELECT *,rol.name as role_name,prt.name as process_name FROM `signin` Left Join office_location inf on signin.office_id = inf.abbr Left Join role rol on signin.role_id = rol.id Left Join role_organization ro on signin.org_role_id = ro.id Left Join info_assign_client cit on signin.id = cit.user_id Left Join client clt on cit.client_id = clt.id Left Join info_assign_process pit on signin.id = pit.user_id Left Join process prt on pit.process_id = prt.id Left Join department dpt on signin.dept_id = dpt.id WHERE fname like '%".$form_data['f_name']."%' AND lname like '%".$form_data['l_name']."%'";
		}
		elseif ($form_data['fems_ids'] != "") {
			$ids = explode(",",$form_data['fems_ids']);
			$fmsid = implode("','",$ids);
			$qSql="SELECT *,rol.name as role_name,prt.name as process_name FROM signin Left Join office_location off on signin.office_id = off.abbr Left Join role rol on signin.role_id = rol.id Left Join role_organization ro on signin.org_role_id = ro.id Left Join info_assign_client cit on signin.id = cit.user_id Left Join client clt on cit.client_id = clt.id Left Join info_assign_process pit on signin.id = pit.user_id Left Join process prt on pit.process_id = prt.id Left Join department dpt on signin.dept_id = dpt.id Left Join info_personal inf on signin.id = inf.user_id WHERE fusion_id in('".$fmsid."')";
		}
		elseif ($form_data['phone'] != "") {
			$qSql="SELECT *,rol.name as role_name,prt.name as process_name FROM signin Left Join office_location off on signin.office_id = off.abbr Left Join role rol on signin.role_id = rol.id Left Join role_organization ro on signin.org_role_id = ro.id Left Join info_assign_client cit on signin.id = cit.user_id Left Join client clt on cit.client_id = clt.id Left Join info_assign_process pit on signin.id = pit.user_id Left Join process prt on pit.process_id = prt.id Left Join department dpt on signin.dept_id = dpt.id Left Join info_personal inf on signin.id = inf.user_id WHERE phone = ".$form_data['phone']." OR phone_emar = ".$form_data['phone']."";
		}
		elseif ($form_data['mail'] != "") {
			$qSql="SELECT *,rol.name as role_name,prt.name as process_name FROM `signin` Left Join office_location off on signin.office_id = off.abbr Left Join role rol on signin.role_id = rol.id Left Join role_organization ro on signin.org_role_id = ro.id Left Join info_assign_client cit on signin.id = cit.user_id Left Join client clt on cit.client_id = clt.id Left Join info_assign_process pit on signin.id = pit.user_id Left Join process prt on pit.process_id = prt.id Left Join department dpt on signin.dept_id = dpt.id Left Join info_personal inf on signin.id = inf.user_id WHERE email_id_off = '".$form_data['mail']."' OR email_id_per = '".$form_data['mail']."'";
		}
		elseif ($form_data['adhar'] != "") {
			$qSql="SELECT *,rol.name as role_name,prt.name as process_name FROM `signin` Left Join office_location off on signin.office_id = off.abbr Left Join role rol on signin.role_id = rol.id Left Join role_organization ro on signin.org_role_id = ro.id Left Join info_assign_client cit on signin.id = cit.user_id Left Join client clt on cit.client_id = clt.id Left Join info_assign_process pit on signin.id = pit.user_id Left Join process prt on pit.process_id = prt.id Left Join department dpt on signin.dept_id = dpt.id Left Join info_personal inf on signin.id = inf.user_id WHERE social_security_no = '".$form_data['adhar']."'";
		}
		elseif ($form_data['pan'] != "") {
			$qSql="SELECT *,rol.name as role_name,prt.name as process_name FROM `signin` Left Join office_location off on signin.office_id = off.abbr Left Join role rol on signin.role_id = rol.id Left Join role_organization ro on signin.org_role_id = ro.id Left Join info_assign_client cit on signin.id = cit.user_id Left Join client clt on cit.client_id = clt.id Left Join info_assign_process pit on signin.id = pit.user_id Left Join process prt on pit.process_id = prt.id Left Join department dpt on signin.dept_id = dpt.id Left Join info_personal inf on signin.id = inf.user_id WHERE pan_no = '".$form_data['pan']."'";
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

		
			
		$data["content_template"] = "search_candidate/manage_users.php";

		$data["content_js"] = "manage_users_js.php";

		$this->load->view('dashboard',$data);
		}
		else{
			redirect(base_url()."search_candidate");
		}

	}

}