<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Itdeclaration extends CI_Controller {

	function __construct() {
		parent::__construct();
		
		$this->load->model('Common_model');
		$this->load->model('Email_model');
		$this->load->model('user_model');
		
		
	}
	
	public function index()
	{
		if(check_logged_in())
		{
			
			$current_user = get_user_id();
			$user_office_id=get_user_office_id();
			$user_oth_office=get_user_oth_office();
			$is_global_access = get_global_access();
			$user_site_id= get_user_site_id();
			$data["is_global_access"] = get_global_access();
			
			$data["is_role_dir"] = get_role_dir();
			$tbl="";
			//loading aside template
			$data["aside_template"] = "itdeclaration/aside.php";
			if($user_office_id=="KOL" || $user_office_id=="HWH" || $user_office_id=="BLR"){
				$data["tbl"]= $tbl = "itdeclaration_ind";
			}
			else{
				$data["tbl"]= $tbl ="";
			}
			
			//loading itdeclaration javascript
			//$data["content_js"] = "itdeclaration/itdeclaration_js.php";
			
			$currYear = date("Y");
			$prevYear = $currYear -1;
			$currMonth = date('m');
			if($currMonth > 4){
				$fyear = $currYear ."-".($currYear+1);
			}else{
				$fyear = $prevYear ."-".$currYear;
			}
			
			$data["fyear"]=$fyear;
			$data['itdec']=array();
			$data['isAddCurrent']=0;
			
			if($tbl==""){
				$data["content_template"] = "itdeclaration/blank.php";
			}else{
			
				$qSql="Select * from $tbl where user_id='$current_user'";
				$data['itdec'] = $this->Common_model->get_query_result_array($qSql);
				
				$qSql = "Select count(id) as value from $tbl where fyear='$fyear' and user_id = '$current_user'";
				$data['isAddCurrent'] = $this->Common_model->get_single_value($qSql);
			
			}
			
			if( empty($data['itdec'])) 	redirect(base_url()."itdeclaration/add");
			else $data["content_template"] = "itdeclaration/index.php";
			
			$this->load->view('dashboard',$data);
			
			
		}
	}
	
	public function add(){
	
        if(check_logged_in())
        {
			
			$user_site_id= get_user_site_id();
			$srole_id= get_role_id();
			$current_user = get_user_id();
			$ses_dept_id=get_dept_id();
			
			$user_office_id=get_user_office_id();
								
			$is_global_access=get_global_access();
			
			
			//loading aside template
			$data["aside_template"] = "itdeclaration/aside.php";
			
			if($user_office_id=="KOL" || $user_office_id=="HWH" || $user_office_id=="BLR"){
				$data["content_template"] = "itdeclaration/ind_itform.php";
				$data["tbl"]="itdeclaration_ind";
			}
			else{
				$data["content_template"] = "itdeclaration/blank.php";
				$data["tbl"]="";
			}
			
			$data["content_js"] = "itdeclaration/itdeclaration_js.php";
			
			
			
			$currYear = date("Y");
			$prevYear = $currYear -1;
			$currMonth = date('m');
			if($currMonth > 4){
				$fyear = $currYear ."-".($currYear+1);
			}else{
				$fyear = $prevYear ."-".$currYear;
			}
			
			$data["fyear"]=$fyear;
			
			$qSql = "Select pan_no as value from info_personal where user_id = '$current_user'";
			$data['pan_no'] = $this->Common_model->get_single_value($qSql);
			
            if($this->input->post('action')=="Save")
            {
                				
				$log=get_logs();
				
				$tbl = trim($this->input->post('tbl'));
				
				$fyear = trim($this->input->post('fyear'));
				$pan_no = trim($this->input->post('pan_no'));
				
				$_field_array = array(
					"user_id" => $current_user,
					"fyear" => trim($this->input->post('fyear')),
					"income_house" => trim($this->input->post('income_house')),
					"pan_trn_financer" => trim($this->input->post('pan_trn_financer')),
					"pan_trn_lanlord" => trim($this->input->post('pan_trn_lanlord')),
					"apr" => trim($this->input->post('apr')),
					"may" => trim($this->input->post('may')),
					"jun" => trim($this->input->post('jun')),
					"jul" => trim($this->input->post('jul')),
					"aug" => trim($this->input->post('aug')),
					"sep" => trim($this->input->post('sep')),
					"oct" => trim($this->input->post('oct')),
					"nov" => trim($this->input->post('nov')),
					"dcm" => trim($this->input->post('dcm')),
					"jan" => trim($this->input->post('jan')),
					"feb" => trim($this->input->post('feb')),
					"mar" => trim($this->input->post('mar')),
					"total_rent_paid" => trim($this->input->post('total_rent_paid')),
					"us24_house_loan_interest" => trim($this->input->post('us24_house_loan_interest')),
					"80c_pf" => trim($this->input->post('80c_pf')),
					"80c_lic" => trim($this->input->post('80c_lic')),
					"80c_nsc" => trim($this->input->post('80c_nsc')),
					"80c_tution_fee" => trim($this->input->post('80c_tution_fee')),
					"80c_vpf" => trim($this->input->post('80c_vpf')),
					"80c_ppf" => trim($this->input->post('80c_ppf')),
					"80c_mutual_fund" => trim($this->input->post('80c_mutual_fund')),
					"80c_house_loan_principal" => trim($this->input->post('80c_house_loan_principal')),
					"80c_fixed_deposit" => trim($this->input->post('80c_fixed_deposit')),
					"80c_post_office" => trim($this->input->post('80c_post_office')),
					"80c_ssyojna" => trim($this->input->post('80c_ssyojna')),
					"80c_others" => trim($this->input->post('80c_others')),
					"total_80c_paid" => trim($this->input->post('total_80c_paid')),
					"80d_type" => trim($this->input->post('80d_type')),
					"80d" => trim($this->input->post('80d')),
					"80u_type" => trim($this->input->post('80u_type')),
					"80u" => trim($this->input->post('80u')),
					"80dd1" => trim($this->input->post('80dd1')),
					"80dd2" => trim($this->input->post('80dd2')),
					"80g1" => trim($this->input->post('80g1')),
					"80g2" => trim($this->input->post('80g2')),
					"log" => $log,
				); 
												
				$this->db->trans_begin();
				data_inserter($tbl,$_field_array);
				
				$info_arr = array(
					"pan_no" => $pan_no,
				);
						
				$this->db->where('user_id', $current_user);
				$this->db->update('info_personal', $info_arr);
					
				
				$this->db->trans_complete();						
				////////////////////////////
										
				if($this->db->trans_status() === FALSE){
					$this->db->trans_rollback();
				}else{
						//////////LOG////////
						$this->db->trans_commit();
						
						$Lfull_name=get_username();
						$LOMid=get_user_fusion_id();
						
						$LogMSG="It Declaration Added by : ";
						log_message('FEMS', $LOMid.' - ' . $Lfull_name . ' | '.$LogMSG );
						
						//redirect(base_url()."itdeclaration");
				}
						
              }else{
			  	  $this->load->view('dashboard',$data);
			  }
								
       }                
   }
   
   public function view($id){
	
        if(check_logged_in())
        {
			
			$user_site_id= get_user_site_id();
			$srole_id= get_role_id();
			$current_user = get_user_id();
			$ses_dept_id=get_dept_id();
			
			$user_office_id=get_user_office_id();
			
			$data["aside_template"] = "itdeclaration/aside.php";
			$tbl="";
			if($user_office_id=="KOL" || $user_office_id=="HWH" || $user_office_id=="BLR"){
				$data["content_template"] = "itdeclaration/ind_itform_view.php";
				$data["tbl"] = $tbl = "itdeclaration_ind";
			}
			else{
				$data["content_template"] = "itdeclaration/blank.php";
				$data["tbl"] = $tbl = "";
			}
			
			$qSql = "Select pan_no as value from info_personal where user_id = '$current_user'";
			$data['pan_no'] = $this->Common_model->get_single_value($qSql);
			
			$qSql="Select * from $tbl where user_id='$current_user' and id='$id'";
			$data['itrow'] = $this->Common_model->get_query_row_array($qSql);
				
			$this->load->view('dashboard',$data);
								
       }                
   }
   
   
   
	
}