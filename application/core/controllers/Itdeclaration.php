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
			
				$qSql="Select *, (Select pan_no from info_personal ip where ip.user_id=$tbl.user_id) as pan_no from $tbl where user_id='$current_user'";
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
			
			$a = array();
			
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
					"80e" => trim($this->input->post('80e')),
					"80u_type" => trim($this->input->post('80u_type')),
					"80u" => trim($this->input->post('80u')),
					"80dd1" => trim($this->input->post('80dd1')),
					"80dd2" => trim($this->input->post('80dd2')),
					"80g1" => trim($this->input->post('80g1')),
					"80g2" => trim($this->input->post('80g2')),
					"is_lock" => 1,
					"log" => $log,
				); 
												
				$this->db->trans_begin();
				$row_id = data_inserter($tbl,$_field_array);
				
				$info_arr = array(
					"pan_no" => $pan_no,
				);
						
				$this->db->where('user_id', $current_user);
				$this->db->update('info_personal', $info_arr);
				
			///////////////	
				$itdeclarationAttach_array = array(
					"user_id" => $current_user,
					"itdcl_id" => $row_id
				);
				
				$upl_itdcl_arr = array('rentpaid','us24hl','80clic','80cncs','80ctutionfee','80cvpf','80cppf','80cmf','80cfd','80cpo','80cssyojna','80cother','80dsec','80esec','80usec','80ddsec','80g1sec','80g2sec');
				
				foreach($upl_itdcl_arr as $value){
					$a = $this->itd_upload_files($_FILES[$value]);
					$itdeclarationAttach_array[$value] = implode(',',$a);
				}
				
				$rowid = data_inserter('itdeclaration_ind_attach',$itdeclarationAttach_array);
				
			//////////////		
				
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
			$data["array"] = $a;				
			//$data["array"] = $b;				
       }                
   }
   
 ///////////////////////////
	private function itd_upload_files($files)
    {
		$currYear = date("Y");
		$prevYear = $currYear -1;
		$currMonth = date('m');
		if($currMonth > 4){
			$fyear = $currYear ."-".($currYear+1);
		}else{
			$fyear = $prevYear ."-".$currYear;
		}
		
		$get_fusion_id=get_user_fusion_id();
		
		$destination_path = $this->config->item('ITDeclarationPath');
		mkdir($destination_path.'/'.$get_fusion_id.'/'.$fyear, 0777, true);
		
        $config['upload_path'] = $destination_path.'/'.$get_fusion_id.'/'.$fyear.'/';
		$config['allowed_types'] = 'doc|docx|xls|xlsx|jpg|jpeg|png|gif|pdf';
		$config['max_size'] = '2024000';
		$this->load->library('upload', $config);
		$this->upload->initialize($config);

        $images = array();
        foreach ($files['name'] as $key => $image) {          
			$_FILES['images[]']['name']= $files['name'][$key];
			$_FILES['images[]']['type']= $files['type'][$key];
			$_FILES['images[]']['tmp_name']= $files['tmp_name'][$key];
			$_FILES['images[]']['error']= $files['error'][$key];
			$_FILES['images[]']['size']= $files['size'][$key];

            if ($this->upload->do_upload('images[]')) {
				$info = $this->upload->data();
				$images[] = $info['file_name'];
            } else {
                return false;
            }
        }

        return $images;
    }

/////////////////////// 
   
   
   public function view($id){
	
        if(check_logged_in()){
			
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
			
			$qSql="SELECT * from 
				(Select * from $tbl where user_id='$current_user' and id='$id') xx Left Join 
				(Select itdcl_id, user_id as userid, rentpaid, us24hl, 80clic, 80cncs, 80ctutionfee, 80cvpf, 80cppf, 80cmf, 80cfd, 80cpo, 80cssyojna, 80cother, 80dsec, 80esec, 80usec, 80ddsec, 80g1sec, 80g2sec from itdeclaration_ind_attach) yy On (xx.id=yy.itdcl_id)";
			$data['itrow'] = $this->Common_model->get_query_row_array($qSql);
				
			$this->load->view('dashboard',$data);
								
       }                
   }
   
///////////////////////////////////
	public function edit($id){
        if(check_logged_in()){
			$user_site_id= get_user_site_id();
			$srole_id= get_role_id();
			$current_user = get_user_id();
			$ses_dept_id=get_dept_id();
			$user_office_id=get_user_office_id();
			$get_fusion_id=get_user_fusion_id();
			
			$data["aside_template"] = "itdeclaration/aside.php";
			$tbl="";
			if($user_office_id=="KOL" || $user_office_id=="HWH" || $user_office_id=="BLR"){
				$data["content_template"] = "itdeclaration/ind_itform_edit.php";
				$data["tbl"] = $tbl = "itdeclaration_ind";
			}
			else{
				$data["content_template"] = "itdeclaration/blank.php";
				$data["tbl"] = $tbl = "";
			}
			
			$data["content_js"] = "itdeclaration/itdeclaration_js.php";
			
			$qSql = "Select pan_no as value from info_personal where user_id = '$current_user'";
			$data['pan_no'] = $this->Common_model->get_single_value($qSql);
			
			$qSql="SELECT * from 
				(Select * from $tbl where user_id='$current_user' and id='$id') xx Left Join 
				(Select itdcl_id, user_id as userid, rentpaid, us24hl, 80clic, 80cncs, 80ctutionfee, 80cvpf, 80cppf, 80cmf, 80cfd, 80cpo, 80cssyojna, 80cother, 80dsec, 80esec, 80usec, 80ddsec, 80g1sec, 80g2sec from itdeclaration_ind_attach) yy On (xx.id=yy.itdcl_id)";
			$data['itrow'] = $this->Common_model->get_query_row_array($qSql);
			
		//////////////Start Edit Part///////////////////
			
			$a = array();
			
            if($this->input->post('itd_id'))
            {				
				$log=get_logs();
				
				$pan_no = trim($this->input->post('pan_no'));
				$itd_id = trim($this->input->post('itd_id'));
				
				$_field_array = array(
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
					"80e" => trim($this->input->post('80e')),
					"80u_type" => trim($this->input->post('80u_type')),
					"80u" => trim($this->input->post('80u')),
					"80dd1" => trim($this->input->post('80dd1')),
					"80dd2" => trim($this->input->post('80dd2')),
					"80g1" => trim($this->input->post('80g1')),
					"80g2" => trim($this->input->post('80g2')),
					"is_lock" => 1,
					"log" => $log,
				); 
												
				$this->db->trans_begin();
				
				$this->db->where('id', $itd_id);
				$this->db->update('itdeclaration_ind', $_field_array);
				
				$info_arr = array(
					"pan_no" => $pan_no,
				);
				$this->db->where('user_id', $current_user);
				$this->db->update('info_personal', $info_arr);
				
			///////////////
				$file_upl_element = array('rentpaid','us24hl','80clic','80cncs','80ctutionfee','80cvpf','80cppf','80cmf','80cfd','80cpo','80cssyojna','80cother','80dsec','80esec','80usec','80ddsec','80g1sec','80g2sec');
				
				foreach($file_upl_element as $value)
				{
					
					if($_FILES[$value]['tmp_name'][0]!='') {
						
						$currYear = date("Y");
						$prevYear = $currYear -1;
						$currMonth = date('m');
						if($currMonth > 4){
							$fyear = $currYear ."-".($currYear+1);
						}else{
							$fyear = $prevYear ."-".$currYear;
						}
						
						$destination_path = $this->config->item('ITDeclarationPath');
						$val = "upl_".$value;
						
						$valuesss = explode(",",$this->input->post($val));
						foreach($valuesss as $rp){
							unlink($destination_path.'/'.$get_fusion_id.'/'.$fyear.'/'.$rp);
						}
						
						$a = $this->itd_edit_upload_files($_FILES[$value]);
						$itdeclarationAttach_array[$value] = implode(',',$a);
						
						$this->db->where('itdcl_id', $itd_id);
						$this->db->update('itdeclaration_ind_attach', $itdeclarationAttach_array);
						
					}
					
				}
				
				
				
				$this->db->trans_complete();						
				////////////////////////////
										
				if($this->db->trans_status() === FALSE){
					$this->db->trans_rollback();
				}else{
						//////////LOG////////
						$this->db->trans_commit();
						
						$Lfull_name=get_username();
						$LOMid=get_user_fusion_id();
						
						$LogMSG="It Declaration Updated by : ";
						log_message('FEMS', $LOMid.' - ' . $Lfull_name . ' | '.$LogMSG );
						
						redirect(base_url()."itdeclaration");
				}
						
            }else{
			  	$this->load->view('dashboard',$data);
			}
			  
			$data["array"] = $a;
		///////End Edit Part////////////
				
			//$this->load->view('dashboard',$data);
       }                
   }
   
	/* public function deleteimage(){
		if(check_logged_in()){
			$r_p  = $this->input->post('r_p');
			$itdcl_id  = $this->input->post('itdcl_id');
			
			$get_fusion_id=get_user_fusion_id();
			$destination_path = $this->config->item('ITDeclarationPath');
			
			$this->db->query("UPDATE itdeclaration_ind_attach SET rentpaid=replace(rentpaid, '".$r_p.",','') WHERE itdcl_id='".$itdcl_id."' ");
			unlink($destination_path.'/'.$get_fusion_id.'/'.$r_p);
		}
	} */
   
	private function itd_edit_upload_files($files)
    {
		$currYear = date("Y");
		$prevYear = $currYear -1;
		$currMonth = date('m');
		if($currMonth > 4){
			$fyear = $currYear ."-".($currYear+1);
		}else{
			$fyear = $prevYear ."-".$currYear;
		}
		
		$get_fusion_id=get_user_fusion_id();
		$destination_path = $this->config->item('ITDeclarationPath');
		
        $config['upload_path'] = $destination_path.'/'.$get_fusion_id.'/'.$fyear.'/';
		$config['allowed_types'] = 'doc|docx|xls|xlsx|jpg|jpeg|png|gif|pdf';
		$config['max_size'] = '2024000';
		$this->load->library('upload', $config);
		$this->upload->initialize($config);

        $images = array();
		
        foreach ($files['name'] as $key => $image) {          
			$_FILES['images[]']['name']= $files['name'][$key];
			$_FILES['images[]']['type']= $files['type'][$key];
			$_FILES['images[]']['tmp_name']= $files['tmp_name'][$key];
			$_FILES['images[]']['error']= $files['error'][$key];
			$_FILES['images[]']['size']= $files['size'][$key];

            if ($this->upload->do_upload('images[]')) {
				$info = $this->upload->data();
				$images[] = $info['file_name'];
            } else {
				
                return false;
            }
        }
		
        return $images;
    }
   
   
   public function itdeclaration_dump(){
	   if(check_logged_in()){
			$user_site_id= get_user_site_id();
			$srole_id= get_role_id();
			$current_user = get_user_id();
			$ses_dept_id=get_dept_id();
			$get_fusion_id=get_user_fusion_id();
			$user_office_id=get_user_office_id();
			
			$data["content_js"] = "itdeclaration/itdeclaration_js.php";
			$data["aside_template"] = "itdeclaration/aside.php";
			if($user_office_id=="KOL" || $user_office_id=="HWH" || $user_office_id=="BLR"){
				$data["content_template"] = "itdeclaration/ind_itform_report.php";
			}
			else{
				$data["content_template"] = "itdeclaration/blank.php";
			}
			
			$data["location_data"] = $this->Common_model->get_office_location_list();
			
			$qSql="Select fyear from itdeclaration_ind group by fyear";
			$data['fyear'] = $this->Common_model->get_query_result_array($qSql);
			
			//$date_from="";
			//$date_to="";
			$finacial_yr="";
			$office_id="";
			$fusion_id="";
			$action="";
			$dn_link="";
			$cond="";
			
			/* $date_from = $this->input->get('date_from');
			$date_to = $this->input->get('date_to');
			
			if($date_from!='') $date_from = mmddyy2mysql($date_from);
			if($date_to!='') $date_to = mmddyy2mysql($date_to); */
			
			$finacial_yr = $this->input->get('finacial_yr');
			$office_id = $this->input->get('office_id');
			$fusion_id = $this->input->get('fusion_id');
			
			
			$data["itdcl_list"] = array();
			
			if($this->input->get('show')=='Show')
			{
				if($fusion_id==""){
					//if($date_from !="" && $date_to!=="" )  $cond= " Where (date(updated_date) >= '$date_from' and date(updated_date) <= '$date_to' ) ";
					
					if($finacial_yr!="") $cond= " Where fyear='$finacial_yr'";
					
					if($office_id=='All') $cond .="";
					else $cond .=" and office_id='$office_id'";
					
				}else{
					$cond=" where (fusion_id='$fusion_id' or xpoid='$fusion_id')";
				}
		
				$qSql="SELECT * from 
				(Select * from itdeclaration_ind) xx Left Join 
				(Select itdcl_id, user_id as userid, rentpaid, us24hl, 80clic, 80cncs, 80ctutionfee, 80cvpf, 80cppf, 80cmf, 80cfd, 80cpo, 80cssyojna, 80cother, 80dsec, 80esec, 80usec, 80ddsec, 80g1sec, 80g2sec from itdeclaration_ind_attach) yy On (xx.id=yy.itdcl_id) Left Join
				(select id as uid, fusion_id, xpoid, office_id, concat(fname, ' ', lname) as name, (select pan_no as value from info_personal ip where ip.user_id=uid) as pan_no, (select location from office_location ol where ol.abbr=office_id) as off_location from signin) ww On (xx.user_id=ww.uid) $cond";
				//echo $qSql;
				
				$fullAray = $this->Common_model->get_query_result_array($qSql);
				$data["itdcl_list"] = $fullAray;
				$this->create_itdcl_CSV($fullAray);	
				$dn_link = base_url()."itdeclaration/download_itdcl_CSV";
				
			}
			
			$data['download_link']=$dn_link;
			$data["action"] = $action;	
			//$data['date_from'] = $date_from;
			//$data['date_to'] = $date_to;
			$data['finacial_yr'] = $finacial_yr;
			$data['office_id'] = $office_id;
			$data['fusion_id'] = $fusion_id;
				
			$this->load->view('dashboard',$data);
			
	   }
   }
   
   public function islockEdit(){
		if(check_logged_in()){
			$itd_id = trim($this->input->post('itd_id'));
			$sid = trim($this->input->post('sid'));
			
			if($itd_id!=""){
				$this->db->where('id', $itd_id);
				$this->db->update('itdeclaration_ind', array('is_lock' => $sid));
				$ans="done";
			}else{
				$ans="error";
			}
			echo $ans;
		}
	}
   

//////////////////////Download ZIP File///////////////////////   
	/* public function createzip($fusion_id){
		if(check_logged_in()){
			if($this->input->post('zipCreate') != NULL){
				
				// Load zip library
				$this->load->library('zip');
				
				// File name
				$filename = "IT Declaration - ".$fusion_id.".zip";
				
				// Directory path (uploads directory stored in project root)
				$filepath1 = 'it_declaration/'.$fusion_id.'/';

				// Add directory to zip
				$this->zip->read_dir($filepath1,false);

				// Download
				$this->zip->download($filename);
				
			}
			$this->load->view('dashboard',$data);
		}
	} */
	
	public function totalzip(){
		if(check_logged_in()){
			if($this->input->post('total_zip') != NULL){
				$this->load->library('zip');
				
				$zip_array = $this->input->post('chk_dwnl_zip');
				$filename = "IT Declaration-.zip";
				
				foreach($zip_array as $za){
					$filepath1 = 'it_declaration/'.$za;
					$this->zip->read_dir($filepath1,false);
				}
				$this->zip->download($filename);
				
			}
			$this->load->view('dashboard',$data);
		}
	}
	

///////////////////////Report Download///////////////////////

	public function download_itdcl_CSV()
	{
		$currDate=date("Y-m-d");
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$newfile="IT Declaration List-'".$currDate."'.csv";
		
		header('Content-Disposition: attachment;  filename="'.$newfile.'"');
		readfile($filename);
	}
	
	public function create_itdcl_CSV($rr)
	{
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$fopen = fopen($filename,"w+");
		$header = array("Fusion ID", "Location", "Name", "IT Declaration Year", "PAN No", "Income From House Property", "PAN of Financer", "PAN of Lanlord", "April", "May", "June", "July", "August", "September", "October", "November", "December", "January", "February", "March", "Total Rent Paid", "Interest On House Loan", "Provident Fund", "Life Insurance Premium", "NSC Purchased", "Tution Fee", "Voluentry Providend Fund", "PPF Deposit", "Investment in Mutual Fund", "Repayment of House Loan (Principal)", "Fixed Deposit for 5Yrs or More", "5 Yrs Post Office Time Deposit", "Sukanya Samriddhi Yojna", "Others", "Total 80c Paid", "Under Sec 80D Type", "Under Sec 80D", "Under Sec 80E", "Under Sec 80U Type", "Under Sec 80U", "Disabled with 40% or more (Max Rs. 75000)", "Severe Disabled with 80% or More (Max Rs. 125000)", "Donation for 100% Deduction", "Donation for 50% Deduction", "Is Lock", "Updated Date");
		
		$row = "";
		foreach($header as $data) $row .= ''.$data.',';
		fwrite($fopen,rtrim($row,",")."\r\n");
		$searches = array("\r", "\n", "\r\n");
		
		foreach($rr as $user)
		{	
			if($user['80d_type']==1) $type80d='Paid for Self, Spouse or Dependent Children (Max Rs. 25000)';
			else if($user['80d_type']==2) $type80d='Paid for Self, Spouse or Dependent Children incl. either one of Senior Citizen Parants (Max Rs. 50000)';
			else $type80d='';
			
			if($user['80u_type']==1) $type80u='Disabled with 40% or more (Max Rs. 75000)';
			else if($user['80u_type']==2) $type80u='Severe Disabled with 80% or More (Max Rs. 125000)';
			else $type80u='';
			
			if($user['is_lock']==1) $is_lock='View';
			else $is_lock='Edit';
			
			$row = '"'.$user['fusion_id'].'",'; 
			$row .= '"'.$user['off_location'].'",';
			$row .= '"'.$user['name'].'",';
			$row .= '"'.$user['fyear'].'",';
			$row .= '"'.$user['pan_no'].'",'; 
			$row .= '"'.$user['income_house'].'",'; 
			$row .= '"'.$user['pan_trn_financer'].'",'; 
			$row .= '"'.$user['pan_trn_lanlord'].'",'; 
			$row .= '"'.$user['apr'].'",'; 
			$row .= '"'.$user['may'].'",'; 
			$row .= '"'.$user['jun'].'",'; 
			$row .= '"'.$user['jul'].'",'; 
			$row .= '"'.$user['aug'].'",'; 
			$row .= '"'.$user['sep'].'",'; 
			$row .= '"'.$user['oct'].'",'; 
			$row .= '"'.$user['nov'].'",'; 
			$row .= '"'.$user['dcm'].'",'; 
			$row .= '"'.$user['jan'].'",'; 
			$row .= '"'.$user['feb'].'",'; 
			$row .= '"'.$user['mar'].'",'; 
			$row .= '"'.$user['total_rent_paid'].'",'; 
			$row .= '"'.$user['us24_house_loan_interest'].'",'; 
			$row .= '"'.$user['80c_pf'].'",'; 
			$row .= '"'.$user['80c_lic'].'",'; 
			$row .= '"'.$user['80c_nsc'].'",'; 
			$row .= '"'.$user['80c_tution_fee'].'",'; 
			$row .= '"'.$user['80c_vpf'].'",'; 
			$row .= '"'.$user['80c_ppf'].'",'; 
			$row .= '"'.$user['80c_mutual_fund'].'",'; 
			$row .= '"'.$user['80c_house_loan_principal'].'",'; 
			$row .= '"'.$user['80c_fixed_deposit'].'",'; 
			$row .= '"'.$user['80c_post_office'].'",'; 
			$row .= '"'.$user['80c_ssyojna'].'",'; 
			$row .= '"'.$user['80c_others'].'",'; 
			$row .= '"'.$user['total_80c_paid'].'",'; 
			$row .= '"'.$type80d.'",'; 
			$row .= '"'.$user['80d'].'",'; 
			$row .= '"'.$user['80e'].'",'; 
			$row .= '"'.$type80u.'",'; 
			$row .= '"'.$user['80u'].'",'; 
			$row .= '"'.$user['80dd1'].'",'; 
			$row .= '"'.$user['80dd2'].'",'; 
			$row .= '"'.$user['80g1'].'",'; 
			$row .= '"'.$user['80g2'].'",'; 
			$row .= '"'.$is_lock.'",'; 
			$row .= '"'.$user['updated_date'].'"'; 
			
			fwrite($fopen,$row."\r\n");
		}
		
		fclose($fopen);
	}
	
}