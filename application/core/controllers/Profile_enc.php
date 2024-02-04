<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends CI_Controller {
    
    /////////////////////////////////////////////////////////////////////////////////////////////
    // INDEX PAGE
    /////////////////////////////////////////////////////////////////////////////////////////////

		private $per_encrypted_fields  = array('father_name','mother_name','phone','phone_emar','marital_status','spouse_name','city','state','country','address_present','address_permanent','social_security_no');
		private $pass_encrypted_fields  = array('pno','note');
		private $bank_encrypted_fields  = array('bank_name','branch','acc_no','ifsc_code');
		private $visa_encrypted_fields  = array('vno','location');
		
	 function __construct() {
		parent::__construct();
		
		$this->load->model('Common_model');
		$this->load->model('user_model');
		$this->load->model('Profile_model');
		
	 }
	 
    public function index()
    {
        if(check_logged_in()){
			
			//setcookie("pmenu", "1");
			$_SESSION['pmenu'] = "1";
			
			$prof_fid=$this->uri->segment(2);
						
			$user_site_id= get_user_site_id();
			$role_id= get_role_id();
			$user_office_id=get_user_office_id();
			$ses_dept_id=get_dept_id();						
			$is_global_access=get_global_access();
			$current_user = get_user_id();
			
			if($prof_fid==""){
				$prof_fid=get_user_fusion_id();
				$prof_uid=$current_user;
			}else{
				$prof_uid=$this->Common_model->get_single_value("Select id as value from signin where fusion_id='$prof_fid'");
			}
			
			$data['prof_fid']=$prof_fid;
			$data['prof_uid']=$prof_uid;
			
			$data['prof_pic_url']=$this->Profile_model->get_profile_pic($prof_fid); 
			$data['prof_widget_left']=$this->Profile_model->get_profile_widget($prof_fid,"left");
			$data['prof_widget']=$this->Profile_model->get_profile_widget($prof_fid,"");
						
			$data["aside_template"] = "profile/aside.php";
			$data["content_template"] = "profile/profile.php";
			
			$data["main_info"] = $this->Profile_model->get_main_info($prof_fid);
			
			$qSql="Select * from info_personal where user_id='$prof_uid'";
			$data["personal_info"] = $this->Common_model->get_query_row_array($qSql);
			
			
			
			if(!empty($data["personal_info"])){	
				$data["personal_info"]  =  decryption($data["personal_info"] ,$this->per_encrypted_fields);
			}
			
			
			
			$qSql="Select * from info_education where user_id='$prof_uid'";
			$data["education_info"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql="Select * from info_experience where user_id='$prof_uid'";
			$data["experience_info"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql="Select * from info_skills where user_id='$prof_uid'";
			$data["skills_info"] = $this->Common_model->get_query_result_array($qSql);
			 
			$qSql="Select * from info_passport where user_id='$prof_uid'";
			$data["passport_info"] = $this->Common_model->get_query_result_array($qSql);
			
			
			
			if(!empty($data["passport_info"])){	
				$data["passport_info"]   =  multidecryption($data["passport_info"] ,$this->pass_encrypted_fields);
			}
			
			$qSql="Select * from info_visa where user_id='$prof_uid'";
			$data["visa_info"] = $this->Common_model->get_query_result_array($qSql);
			
			
			
			if(!empty($data["visa_info"])){	
				$data["visa_info"]   =  multidecryption($data["visa_info"] ,$this->visa_encrypted_fields);
			} 
			
			$qSql="Select * from info_payroll where user_id='$prof_uid'";
			$data["payroll_info"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql="Select * from info_bank where user_id='$prof_uid'";
			$data["bank_info"] = $this->Common_model->get_query_result_array($qSql);
			
			
			if(!empty($data["bank_info"])){	
				$data["bank_info"]   =  multidecryption($data["bank_info"] ,$this->bank_encrypted_fields);
			} 
			
			
			/*
			$qSql="Select * from info_repoting_head where user_id='$prof_uid'";
			$data["repoting_head_info"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql="Select * from info_assign_client where user_id='$prof_uid'";
			$data["assign_client_info"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql="Select * from info_assign_process where user_id='$prof_uid'";
			$data["assign_process_info"] = $this->Common_model->get_query_result_array($qSql);
			*/
			
			// History Report Details
							
	
						
			$SQLtxt = "SELECT a.*, getHistryFormTo(h_type,from_id) as m_from_name,
			 getHistryFormTo(h_type,to_id) as m_to_namegetHistryFormTo,
			 (Select name from history_type mt where mt.id=a.h_type) as m_type_name, 
			 fusion_id, office_id, fname, lname, role_id,site_id, omuid , status,assigned_to,doj, 
			 (Select name from site z where z.id=b.site_id) as site_name, (Select CONCAT(fname,' ' ,lname) from signin
			 x where x.id=b.assigned_to) as asign_tl FROM 
			 history_emp_all a , signin b where a.user_id=b.id AND user_id='".$prof_uid."'";
						
			
			$fields = $this->db->query($SQLtxt);
			if($fields->num_rows()>0){
				
				$data["history_emp"] = $fields->result();
				
			}
			
			
			
			
			
			$qStrParam=$_SERVER["QUERY_STRING"];
			$data['qStrParam']=$qStrParam;
            $this->load->view('dashboard',$data);
			
		}
    }
	
	public function maininfo()
    {
        if(check_logged_in()){
			
			//setcookie("pmenu", "2");
			$_SESSION['pmenu'] = "2";
			
			$prof_fid=$this->uri->segment(3);
			$user_site_id= get_user_site_id();
			$role_id= get_role_id();
			$user_office_id=get_user_office_id();
			$ses_dept_id=get_dept_id();						
			$is_global_access=get_global_access();
			$current_user = get_user_id();
			
			if($prof_fid==""){
				$prof_fid=get_user_fusion_id();
				$prof_uid=$current_user;
			}else{
				$prof_uid=$this->Common_model->get_single_value("Select id as value from signin where fusion_id='$prof_fid'");
			}
			
			////////////////
			
			if(get_role_dir()=="super" || get_role_dir()=="admin" || $is_global_access==1){
				
				$qSql="SELECT id,name, org_role FROM role where is_active=1 and folder not in('super') ORDER BY name";	
				$data['role_list'] = $this->Common_model->get_rolls_for_assignment2($qSql);
				$data['role_organization'] = $this->Common_model->role_organization();
				
				
			}else if(get_role_dir()=="tl" || get_role_dir()=="trainer"){
				//$cond=" and id not in(0,1,4,11)";
				$qSql="SELECT id,name, org_role FROM role where is_active=1 and folder not in('super','admin','manager') ORDER BY name";
				$data['role_list'] = $this->Common_model->get_rolls_for_assignment2($qSql);
				$data['role_organization'] = $this->Common_model->role_organization();
				
			}else{
				$qSql="SELECT id,name, org_role FROM role where is_active=1 and folder not in('super','admin') ORDER BY name";
				$data['role_list'] = $this->Common_model->get_rolls_for_assignment2($qSql);
				$data['role_organization'] = $this->Common_model->role_organization();
			}
			
			$data['client_list'] = $this->Common_model->get_client_list();			
			$data['payroll_type_list'] = $this->Common_model->get_query_result_array("select * from master_payroll_type where is_active=1");
			$data['payroll_status_list'] = $this->Common_model->get_query_result_array("select * from master_payroll_status where is_active=1");
			
			
								
			if(get_role_dir()=="super" || $is_global_access==1){
				
				$data['location_list'] = $this->Common_model->get_office_location_list();
				$data['site_list'] = $this->Common_model->get_sites_for_assign();
			}else{
				$sCond=" Where id = '$user_site_id'";
				$data['site_list'] = $this->Common_model->get_sites_for_assign2($sCond);
				$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
			}
			
			$data['process_list'] = $this->Common_model->get_process_for_assign();
						
			$data['department_list'] = $this->Common_model->get_department_list();
			$data['sub_department_list'] = $this->Common_model->get_sub_department_list($ses_dept_id);
			
			if(get_role_dir()!="super" && $is_global_access!=1){
				
				//$tl_cnd=" and site_id=".$user_site_id;
				
				$tl_cnd=" and (site_id='$user_site_id' OR office_id='$user_office_id') ";
				$data['tl_list'] = $this->Common_model->get_tls_for_assign2($tl_cnd);
				
			}else $data['tl_list'] = $this->Common_model->get_tls_for_assign2("");
			
			///////////////
			
			$data['prof_fid']=$prof_fid;
			$data['prof_uid']=$prof_uid;
			
			$data['prof_pic_url']=$this->Profile_model->get_profile_pic($prof_fid);
			$data['prof_widget_left']=$this->Profile_model->get_profile_widget($prof_fid,"left");
			$data['prof_widget']=$this->Profile_model->get_profile_widget($prof_fid,"");
						
			$data["aside_template"] = "profile/aside.php";
			$data["content_template"] = "profile/system.php";
			
			/* $qSql="select ac.*, (select GROUP_CONCAT(' ', shname) from client c where CONCAT(',',ac.client_id,',') like CONCAT('%,',c.id,',%')) as name from info_assign_client ac where ac.user_id = '$prof_uid' ";
			$data["client_info"] = $this->Common_model->get_query_result_array($qSql); */
						
			$data["main_info"] = $this->Profile_model->get_main_info($prof_fid);
			
		    $data['cur_user'] = $prof_uid;
			
			$data['client_list'] = $this->Common_model->get_client_list_1();	
			
			$data['assign_client'] = $this->Common_model->info_assign_client("SELECT id,user_id,client_id,(select fullname from client where id=info_assign_client.client_id)as client_info 
				FROM info_assign_client where user_id='".$data['cur_user'] ."'");
				
			$data['client_list_2'] = $this->Common_model->get_client_list_2();		
				
			$data['assign_process'] = $this->Common_model->info_assign_client("SELECT id,user_id,process_id,(select name from process where process.id= info_assign_process.process_id)as process_info 
			FROM info_assign_process where user_id='".$data['cur_user'] ."'");	
				
		    //echo "<pre>";
			//print_r($data['assign_process']);
		 			
			$data["error"]="";
			
			$qStrParam=$_SERVER["QUERY_STRING"];
			$data['qStrParam']=$qStrParam;
            $this->load->view('dashboard',$data);
		}
    }	
	
/////////////////////////////// SYSTEM INFORMATION////////////////////////////////////
/////////	
	public function editHRInfo(){
		if(check_logged_in()){
			
			$prof_id = trim($this->input->post('prof_id'));
			$prof_fid=trim($this->input->post('prof_fid'));
			
			$site_id = trim($this->input->post('site_id'));
			
			$dept_id = trim($this->input->post('dept_id'));
			$sub_dept_id = trim($this->input->post('sub_dept_id'));
			$xpoid = trim($this->input->post('xpoid'));
			
			$doj = trim($this->input->post('doj'));
			$join_dt = explode("/", $doj);
			$_d_o_j = $join_dt[2]."-".$join_dt[0]."-".$join_dt[1];
			
			$dob = mmddyy2mysql(trim($this->input->post('dob')));
			$sex = trim($this->input->post('sex'));
			
			$batch_code=trim($this->input->post('batch_code'));
			$fname = $this->input->post('fname');
            $lname = $this->input->post('lname'); 
			$role_id = trim($this->input->post('role_id')); 
			$org_role_id = trim($this->input->post('org_role_id')); 
			$assigned_to = trim($this->input->post('assigned_to'));
			/////
			$client_array = $this->input->post('client_id');
			$process_array = $this->input->post('process_id');
			/////
			$payroll_type=trim($this->input->post('payroll_type'));
			$payroll_status=trim($this->input->post('payroll_status'));
			/////
			//$is_bod=trim($this->input->post('is_bod'));
			//$reporting_level1=trim($this->input->post('reporting_level1'));
			//$reporting_level2=trim($this->input->post('reporting_level2'));
			//$reporting_level3=trim($this->input->post('reporting_level3'));
			/////
			$log = get_logs();
			
			if($prof_id!=""){
				
				$field_array1 = array(
					"dept_id" => $dept_id,
					"site_id" => $site_id,
					"sub_dept_id" => $sub_dept_id,
					"xpoid" => $xpoid,
					"doj" => $_d_o_j,
					"dob" => $dob,
					"sex" => $sex,
					"batch_code" => $batch_code,
					"fname" => $fname,
					"lname" => $lname,
					"role_id" => $role_id,
					"org_role_id" => $org_role_id,
					"assigned_to" => $assigned_to
				);
				$this->db->where('id', $prof_id);
				$this->db->update('signin', $field_array1);
				////////
				
				$this->db->query('DELETE FROM info_assign_client WHERE user_id = "'.$prof_id.'"');
				foreach ($client_array as $key => $client_value){	
					$field_array2 = array(
						"user_id" => $prof_id,
						"client_id" => $client_value,
						"log" => $log
					);
					$rowid= data_inserter('info_assign_client',$field_array2);
				}
				//////
				
				$this->db->query('DELETE FROM info_assign_process WHERE user_id = "'.$prof_id.'"');
				foreach ($process_array as $key => $process_value){	
					$field_array3 = array(
						"user_id" => $prof_id,
						"process_id" => $process_value,
						"log" => $log
					);
					$rowid= data_inserter('info_assign_process',$field_array3);
				}
				///////
				
				$this->db->query('DELETE FROM info_payroll WHERE user_id = "'.$prof_id.'"');
					$field_array4 = array(
						"user_id" => $prof_id,
						"payroll_type" => $payroll_type,
						"payroll_status" => $payroll_status,
						"log" => $log
					);
				$rowid= data_inserter('info_payroll',$field_array4);
				//////
				
				/*
				$this->db->query('DELETE FROM info_repoting_head WHERE user_id = "'.$prof_id.'"');
				if($is_bod=="") $is_bod=0;			
					$head_array = array(
						"user_id" => $prof_id,
						"is_bod" => $is_bod,
						"log" => $log
					);
					
				if($is_bod==0){
					if($reporting_level1!="") $head_array['level1']=$reporting_level1;
					if($reporting_level2!="") $head_array['level2']=$reporting_level2;
					if($reporting_level3!="") $head_array['level3']=$reporting_level3;
				}
				
				$rowid= data_inserter('info_repoting_head',$head_array);
				*/
				
				$ans="Done";
			}else{
				$ans="error";
			}
			//echo $ans;
			redirect('profile/maininfo/'.$prof_fid);
		}	
	}
	
	public function getUserName(){
		if(check_logged_in()){
			
			$fid = trim($this->input->post('fid'));
			if($fid!=="")
			{
				$qSql="Select CONCAT(fname,' ' ,lname) as value from signin Where fusion_id = '$fid' ";
				echo $this->Common_model->get_single_value($qSql);
			}else{
				echo "";
			}
		}	
	}
	
	/////////////////////////////////// PERSONAL INFORMATION /////////////////////////////////////////
	////////
	public function personal()
    {
        if(check_logged_in()){
			
			//setcookie("pmenu", "3");
			$_SESSION['pmenu'] = "3";
			
			$prof_fid=$this->uri->segment(3);
			$user_site_id= get_user_site_id();
			$role_id= get_role_id();
			$user_office_id=get_user_office_id();
			$ses_dept_id=get_dept_id();						
			$is_global_access=get_global_access();
			$current_user = get_user_id();
			
			if($prof_fid==""){
				$prof_fid=get_user_fusion_id();
				$prof_uid=$current_user;
			}else{
				$prof_uid=$this->Common_model->get_single_value("Select id as value from signin where fusion_id='$prof_fid'");
			}
			
			$data['prof_fid']=$prof_fid;
			$data['prof_uid']=$prof_uid;
			
			$data['prof_pic_url']=$this->Profile_model->get_profile_pic($prof_fid);
			$data['prof_widget_left']=$this->Profile_model->get_profile_widget($prof_fid,"left");
			$data['prof_widget']=$this->Profile_model->get_profile_widget($prof_fid,"");
						
			$data["aside_template"] = "profile/aside.php";
			$data["content_template"] = "profile/personal.php";
			
			$qSql="select *, DATE_FORMAT(dom,'%m/%d/%Y') AS dom from info_personal where user_id='$prof_uid'";
			$data["personal_info"] = $this->Common_model->get_query_row_array($qSql);

			$data["main_info"] = $this->Profile_model->get_main_info($prof_fid);
			
			
			if(!empty($data["personal_info"])){	
				$data["personal_info"]  =  decryption($data["personal_info"] , $this->per_encrypted_fields);
			}

			
			$qStrParam=$_SERVER["QUERY_STRING"];
			$data['qStrParam']=$qStrParam;
			$this->load->view('dashboard',$data);
		}
    }	
	
	public function editPersonal(){
		if(check_logged_in()){
			
			$prof_id = trim($this->input->post('prof_id'));
			$prof_fid=trim($this->input->post('prof_fid'));
			
			$dob = mmddyy2mysql(trim($this->input->post('dob')));
			$sex = trim($this->input->post('sex'));
			
			$dom = trim($this->input->post('dom'));
			$blood_group = trim($this->input->post('blood_group'));
			
			$nationality = trim($this->input->post('nationality'));
			$caste = trim($this->input->post('caste'));
			$is_ph = trim($this->input->post('is_ph'));
			$ph_per = trim($this->input->post('ph_per'));
			$father_name = trim($this->input->post('father_name'));
			$email_id_per = trim($this->input->post('email_id_per'));
			$email_id_off = trim($this->input->post('email_id_off'));
			$mother_name = trim($this->input->post('mother_name'));
			$phone = trim($this->input->post('phone'));
			$phone_emar = trim($this->input->post('phone_emar'));
			$marital_status = trim($this->input->post('marital_status'));
			$spouse_name = trim($this->input->post('spouse_name'));
			$no_of_children = trim($this->input->post('no_of_children'));
			$pin = trim($this->input->post('pin'));
			$city = trim($this->input->post('city'));
			$state = trim($this->input->post('state'));
			$country = trim($this->input->post('country'));
			$address_present = trim($this->input->post('address_present'));
			$address_permanent = trim($this->input->post('address_permanent'));
			$social_security_no = trim($this->input->post('social_security_no'));
			$pan_no = trim($this->input->post('pan_no'));
			$uan_no = trim($this->input->post('uan_no'));
			$log=get_logs();
						
			if($prof_id!=""){
				
				$this->db->query('DELETE FROM info_personal WHERE user_id = "'.$prof_id.'"');
				
				$field_array = array(
					"user_id" => $prof_id,
					"blood_group" => $blood_group,
					"nationality" => $nationality,
					"caste" => $caste,
					"is_ph" => $is_ph,
					"ph_per" => $ph_per,
					"father_name" => $father_name,
					"email_id_per" => $email_id_per,
					"email_id_off" => $email_id_off,
					"mother_name" => $mother_name,
					"phone" => $phone,
					"phone_emar" => $phone_emar,
					"marital_status" => $marital_status,
					"spouse_name" => $spouse_name,
					"no_of_children" => $no_of_children,
					"pin" => $pin,
					"city" => $city,
					"state" => $state,
					"country" => $country,
					"address_present" => $address_present,
					"address_permanent" => $address_permanent,
					"social_security_no" => $social_security_no,
					"pan_no" => $pan_no,
					"uan_no" => $uan_no,
					"log" => $log
				);
				
				if($dom!=""){
				 $dom=mmddyy2mysql($dom);
				 $field_array['dom']=$dom;
				}
			
				$field_array  =  encryption($field_array , $this->per_encrypted_fields);
				
				$rowid= data_inserter('info_personal',$field_array);
				
				$field_array1 = array(
					"dob" => $dob,
					"sex" => $sex
				);
				$this->db->where('id', $prof_id);
				$this->db->update('signin', $field_array1);
				
			/////////	
				
				$ans="done";
			}else{
				$ans="error";
			}	
			//echo $ans;	
			redirect('profile/personal/'.$prof_fid);
		}
	}	
	
///////////////////////////////////Education Info/////////////////////////////////////////////	
//////
	public function education()
    {
        if(check_logged_in()){
			
			//setcookie("pmenu", "4");
			$_SESSION['pmenu'] = "4";
			
			$prof_fid=$this->uri->segment(3);
			$user_site_id= get_user_site_id();
			$role_id= get_role_id();
			$user_office_id=get_user_office_id();
			$ses_dept_id=get_dept_id();						
			$is_global_access=get_global_access();
			$current_user = get_user_id();
			
			if($prof_fid==""){
				$prof_fid=get_user_fusion_id();
				$prof_uid=$current_user;
			}else{
				$prof_uid=$this->Common_model->get_single_value("Select id as value from signin where fusion_id='$prof_fid'");
			}
			
			$data['prof_fid']=$prof_fid;
			$data['prof_uid']=$prof_uid;
			
			$data['prof_pic_url']=$this->Profile_model->get_profile_pic($prof_fid);
			$data['prof_widget_left']=$this->Profile_model->get_profile_widget($prof_fid,"left");
			$data['prof_widget']=$this->Profile_model->get_profile_widget($prof_fid,"");
						
			$data["aside_template"] = "profile/aside.php";
			$data["content_template"] = "profile/education.php";
			
			$qSql="select * from info_education where user_id='$prof_uid'";
			$data["education_info"] = $this->Common_model->get_query_result_array($qSql);
						
			$qStrParam=$_SERVER["QUERY_STRING"];
			$data['qStrParam']=$qStrParam;
            $this->load->view('dashboard',$data);	
		}
    }
	
	public function add_education()
	{
		if(check_logged_in()){
			$prof_fid = trim($this->input->post('prof_fid'));
			$prof_uid = trim($this->input->post('prof_uid'));
			$exam = trim($this->input->post('exam'));
			$passing_year = trim($this->input->post('passing_year'));
			$board_uv = trim($this->input->post('board_uv'));
			$specialization = trim($this->input->post('specialization'));
			$grade_cgpa = trim($this->input->post('grade_cgpa'));
			
			if($prof_fid!=""){
				$log=get_logs();
				$field_array = array(
					"user_id" => $prof_uid,
					"exam" => $exam,
					"passing_year" => $passing_year,
					"board_uv" => $board_uv,
					"specialization" => $specialization,
					"grade_cgpa" => $grade_cgpa,
					"log" => $log
				);
				$rowid= data_inserter('info_education',$field_array);
				$ans="done";
			}else{
				$ans="error";
			}	
			//echo $ans;
			redirect('profile/education/'.$prof_fid);
		}	
	}
	
	public function edit_education()
	{
		if(check_logged_in()){
			$prof_fid = trim($this->input->post('prof_fid'));
			$did = trim($this->input->post('did'));
			$exam = trim($this->input->post('exam'));
			$passing_year = trim($this->input->post('passing_year'));
			$board_uv = trim($this->input->post('board_uv'));
			$specialization = trim($this->input->post('specialization'));
			$grade_cgpa = trim($this->input->post('grade_cgpa'));
			
			if($did!=""){
				$log=get_logs();
				$field_array = array(
					"exam" => $exam,
					"passing_year" => $passing_year,
					"board_uv" => $board_uv,
					"specialization" => $specialization,
					"grade_cgpa" => $grade_cgpa,
					"log" => $log
				);
				$this->db->where('id', $did);
				$this->db->update('info_education', $field_array);
				$ans="Done";
			}else{
				$ans="error";
			}	
			//echo $ans;	
			redirect('profile/education/'.$prof_fid);
		}	
	}

///////////////////////////////////Experience Info/////////////////////////////////////////////	
//////	
	public function experience()
    {
        if(check_logged_in()){
			
			//setcookie("pmenu", "5");
			$_SESSION['pmenu'] = "5";
			
			$prof_fid=$this->uri->segment(3);
			$user_site_id= get_user_site_id();
			$role_id= get_role_id();
			$user_office_id=get_user_office_id();
			$ses_dept_id=get_dept_id();						
			$is_global_access=get_global_access();
			$current_user = get_user_id();
			
			if($prof_fid==""){
				$prof_fid=get_user_fusion_id();
				$prof_uid=$current_user;
			}else{
				$prof_uid=$this->Common_model->get_single_value("Select id as value from signin where fusion_id='$prof_fid'");
			}
			
			$data['prof_fid']=$prof_fid;
			$data['prof_uid']=$prof_uid;
			
			$data['prof_pic_url']=$this->Profile_model->get_profile_pic($prof_fid);
			$data['prof_widget_left']=$this->Profile_model->get_profile_widget($prof_fid,"left");
			$data['prof_widget']=$this->Profile_model->get_profile_widget($prof_fid,"");
						
			$data["aside_template"] = "profile/aside.php";
			$data["content_template"] = "profile/experience.php";
			
			$qSql="select *, DATE_FORMAT(from_date,'%m/%d/%Y') as fromdate, DATE_FORMAT(to_date,'%m/%d/%Y') as todate from info_experience where user_id='$prof_uid'";
			$data["experience_info"] = $this->Common_model->get_query_result_array($qSql);
						
			$qStrParam=$_SERVER["QUERY_STRING"];
			$data['qStrParam']=$qStrParam;
            $this->load->view('dashboard',$data);
			
		}
    }
	
	public function add_experience()
	{
		if(check_logged_in()){
			$prof_fid = trim($this->input->post('prof_fid'));
			$prof_uid = trim($this->input->post('prof_uid'));
			$org_name = trim($this->input->post('org_name'));
			$desig = trim($this->input->post('desig'));
			$from_date = mmddyy2mysql(trim($this->input->post('from_date')));
			$to_date = mmddyy2mysql(trim($this->input->post('to_date')));
			$work_exp = trim($this->input->post('work_exp'));
			$contact = trim($this->input->post('contact'));
			$job_desc = trim($this->input->post('job_desc'));
			$address = trim($this->input->post('address'));
			$log=get_logs();
			
			if($prof_fid!=""){
				$field_array = array(
					"user_id" => $prof_uid,
					"org_name" => $org_name,
					"desig" => $desig,
					"from_date" => $from_date,
					"to_date" => $to_date,
					"work_exp" => $work_exp,
					"contact" => $contact,
					"job_desc" => $job_desc,
					"address" => $address,
					"log" => $log
				);
				$rowid= data_inserter('info_experience',$field_array);
				$ans="done";
			}else{
				$ans="error";
			}	
			//echo $ans;
			redirect('profile/experience/'.$prof_fid);
		}	
	}
	
	public function edit_experience()
	{
		if(check_logged_in()){
			$prof_fid = trim($this->input->post('prof_fid'));
			$did = trim($this->input->post('did'));
			$org_name = trim($this->input->post('org_name'));
			$desig = trim($this->input->post('desig'));
			$from_date = mmddyy2mysql(trim($this->input->post('from_date')));
			$to_date = mmddyy2mysql(trim($this->input->post('to_date')));
			$work_exp = trim($this->input->post('work_exp'));
			$contact = trim($this->input->post('contact'));
			$job_desc = trim($this->input->post('job_desc'));
			$address = trim($this->input->post('address'));
			$log=get_logs();
			
			if($did!=""){
				$field_array = array(
					"org_name" => $org_name,
					"desig" => $desig,
					"from_date" => $from_date,
					"to_date" => $to_date,
					"work_exp" => $work_exp,
					"contact" => $contact,
					"job_desc" => $job_desc,
					"address" => $address,
					"log" => $log
				);
				$this->db->where('id', $did);
				$this->db->update('info_experience', $field_array);
				$ans="Done";
			}else{
				$ans="error";
			}	
			//echo $ans;	
			redirect('profile/experience/'.$prof_fid);
		}	
	}

///////////////////////////////////Skill Info/////////////////////////////////////////////	
//////	
	public function skills()
    {
        if(check_logged_in()){
			
			//setcookie("pmenu", "6");
			$_SESSION['pmenu'] = "6";
			
			$prof_fid=$this->uri->segment(3);
			$user_site_id= get_user_site_id();
			$role_id= get_role_id();
			$user_office_id=get_user_office_id();
			$ses_dept_id=get_dept_id();						
			$is_global_access=get_global_access();
			$current_user = get_user_id();
			
			if($prof_fid==""){
				$prof_fid=get_user_fusion_id();
				$prof_uid=$current_user;
			}else{
				$prof_uid=$this->Common_model->get_single_value("Select id as value from signin where fusion_id='$prof_fid'");
			}
			
			$data['prof_fid']=$prof_fid;
			$data['prof_uid']=$prof_uid;
			
			$data['prof_pic_url']=$this->Profile_model->get_profile_pic($prof_fid);
			$data['prof_widget_left']=$this->Profile_model->get_profile_widget($prof_fid,"left");
			$data['prof_widget']=$this->Profile_model->get_profile_widget($prof_fid,"");
						
			$data["aside_template"] = "profile/aside.php";
			$data["content_template"] = "profile/skills.php";
			
			$qSql="select * from info_skills where user_id='$prof_uid'";
			$data["skills_info"] = $this->Common_model->get_query_result_array($qSql);
						
			$qStrParam=$_SERVER["QUERY_STRING"];
			$data['qStrParam']=$qStrParam;
            $this->load->view('dashboard',$data);
			
		}
    }
	
	public function add_skills()
	{
		if(check_logged_in()){
			$prof_fid = trim($this->input->post('prof_fid'));
			$prof_uid = trim($this->input->post('prof_uid'));
			$skills = trim($this->input->post('skills'));
			$log=get_logs();
			
			if($prof_fid!=""){
				$field_array = array(
					"user_id" => $prof_uid,
					"skills" => $skills,
					"log" => $log
				);
				$rowid= data_inserter('info_skills',$field_array);
				$ans="done";
			}else{
				$ans="error";
			}	
			//echo $ans;
			redirect('profile/skills/'.$prof_fid);
		}	
	}
	
	public function edit_skills()
	{
		if(check_logged_in()){
			$prof_fid = trim($this->input->post('prof_fid'));
			$did = trim($this->input->post('did'));
			$skills = trim($this->input->post('skills'));
			$log=get_logs();
			
			if($did!=""){
				$field_array = array(
					"skills" => $skills,
					"log" => $log
				);
				$this->db->where('id', $did);
				$this->db->update('info_skills', $field_array);
				$ans="Done";
			}else{
				$ans="error";
			}	
			//echo $ans;
			redirect('profile/skills/'.$prof_fid);
		}	
	}
	

///////////////////////////////////Passport Info/////////////////////////////////////////////	
//////	
	public function passport()
    {
        if(check_logged_in()){
			
			//setcookie("pmenu", "7");
			$_SESSION['pmenu'] = "7";
			
			$prof_fid=$this->uri->segment(3);
			$user_site_id= get_user_site_id();
			$role_id= get_role_id();
			$user_office_id=get_user_office_id();
			$ses_dept_id=get_dept_id();						
			$is_global_access=get_global_access();
			$current_user = get_user_id();
			
			if($prof_fid==""){
				$prof_fid=get_user_fusion_id();
				$prof_uid=$current_user;
			}else{
				$prof_uid=$this->Common_model->get_single_value("Select id as value from signin where fusion_id='$prof_fid'");
			}
			
			$data['prof_fid']=$prof_fid;
			$data['prof_uid']=$prof_uid;
			
			$data['prof_pic_url']=$this->Profile_model->get_profile_pic($prof_fid);
			$data['prof_widget_left']=$this->Profile_model->get_profile_widget($prof_fid,"left");
			$data['prof_widget']=$this->Profile_model->get_profile_widget($prof_fid,"");
						
			$data["aside_template"] = "profile/aside.php";
			$data["content_template"] = "profile/passport.php";
			
			$qSql="select *, DATE_FORMAT(issue_date,'%m/%d/%Y') AS issue_date, DATE_FORMAT(expiry_date,'%m/%d/%Y') AS expiry_date from info_passport where user_id='$prof_uid'";
			$data["passport_info"] = $this->Common_model->get_query_result_array($qSql);
			
						
			
			
			if(!empty($data["passport_info"])){	
				$data["passport_info"]   =  multidecryption($data["passport_info"] ,$this->pass_encrypted_fields);
			} 
		 
		
						
			$qStrParam=$_SERVER["QUERY_STRING"];
			$data['qStrParam']=$qStrParam;
            $this->load->view('dashboard',$data);
		}
    }
	
	public function add_passport(){
		if(check_logged_in()){
			$issue_date = trim($this->input->post('issue_date'));
				$dt_issue = explode("/", $issue_date);
				$iss_dt = $dt_issue[2]."-".$dt_issue[0]."-".$dt_issue[1];
				
			$expiry_date = trim($this->input->post('expiry_date'));
				$date_exp = explode("/", $expiry_date);
				$exp_dt = $date_exp[2]."-".$date_exp[0]."-".$date_exp[1];
			
			$prof_fid = trim($this->input->post('prof_fid'));
			$prof_uid = trim($this->input->post('prof_uid'));
			$pno = trim($this->input->post('pno'));
			$note = trim($this->input->post('note'));
			$log=get_logs();
			
			if($prof_fid!=""){
				$field_array = array(
					"user_id" => $prof_uid,
					"pno" => $pno,
					"issue_date" => $iss_dt,
					"expiry_date" => $exp_dt,
					"note" => $note,
					"log" => $log
				);
				
				
				$field_data  =  encryption($field_array ,$this->pass_encrypted_fields);
				
				$rowid= data_inserter('info_passport',$field_data);
				$ans="done";
			}else{
				$ans="error";
			}	
			//echo $ans;
			redirect('profile/passport/'.$prof_fid);
		}	
	}
	
	public function edit_passport(){
		if(check_logged_in()){
			
			$issue_date = trim($this->input->post('issue_date'));
				$dt_issue = explode("/", $issue_date);
				$iss_dt = $dt_issue[2]."-".$dt_issue[0]."-".$dt_issue[1];
				
			$expiry_date = trim($this->input->post('expiry_date'));
				$date_exp = explode("/", $expiry_date);
				$exp_dt = $date_exp[2]."-".$date_exp[0]."-".$date_exp[1];
			
			$prof_fid = trim($this->input->post('prof_fid'));
			$did = trim($this->input->post('did'));
			$pno = trim($this->input->post('pno'));	
			$note = trim($this->input->post('note'));
			$log=get_logs();
			
			if($did!=""){
				$field_array = array(
					"pno" => $pno,
					"issue_date" => $iss_dt,
					"expiry_date" => $exp_dt,
					"note" => $note,
					"log" => $log
				);
				
				
				$field_data  =  encryption($field_array ,$this->pass_encrypted_fields);
				
				
				$this->db->where('id', $did);
				$this->db->update('info_passport', $field_data);
				$ans="Done";
			}else{
				$ans="error";
			}	
			//echo $ans;
			redirect('profile/passport/'.$prof_fid);
		}	
	}	

///////////////////////////////////Visa Info/////////////////////////////////////////////	
//////	
	public function visa()
    {
        if(check_logged_in()){
			
			//setcookie("pmenu", "8");
			$_SESSION['pmenu'] = "8";
			
			$prof_fid=$this->uri->segment(3);
			$user_site_id= get_user_site_id();
			$role_id= get_role_id();
			$user_office_id=get_user_office_id();
			$ses_dept_id=get_dept_id();						
			$is_global_access=get_global_access();
			$current_user = get_user_id();
			
			if($prof_fid==""){
				$prof_fid=get_user_fusion_id();
				$prof_uid=$current_user;
			}else{
				$prof_uid=$this->Common_model->get_single_value("Select id as value from signin where fusion_id='$prof_fid'");
			}
			
			$data['prof_fid']=$prof_fid;
			$data['prof_uid']=$prof_uid;
			
			$data['prof_pic_url']=$this->Profile_model->get_profile_pic($prof_fid);
			$data['prof_widget_left']=$this->Profile_model->get_profile_widget($prof_fid,"left");
			$data['prof_widget']=$this->Profile_model->get_profile_widget($prof_fid,"");
						
			$data["aside_template"] = "profile/aside.php";
			$data["content_template"] = "profile/visa.php";
			
			$qSql="select *, DATE_FORMAT(issue_date,'%m/%d/%Y') AS issue_date, DATE_FORMAT(expiry_date,'%m/%d/%Y') AS expiry_date from info_visa where user_id='$prof_uid'";
			$data["visa_info"] = $this->Common_model->get_query_result_array($qSql);
			
			
			
			
			if(!empty($data["visa_info"])){	
				$data["visa_info"]   =  multidecryption($data["visa_info"] ,$this->visa_encrypted_fields);
			} 
			
			$qStrParam=$_SERVER["QUERY_STRING"];
			$data['qStrParam']=$qStrParam;
            $this->load->view('dashboard',$data);
		}
    }
	
	public function add_visa(){
		if(check_logged_in()){
			
			$issue_date = mmddyy2mysql(trim($this->input->post('issue_date')));
			$expiry_date = mmddyy2mysql(trim($this->input->post('expiry_date')));
			
			$prof_fid = trim($this->input->post('prof_fid'));
			$prof_uid = trim($this->input->post('prof_uid'));
			$vno = trim($this->input->post('vno'));
			$location = trim($this->input->post('location'));
			$note = trim($this->input->post('note'));
			$log=get_logs();
			
			if($prof_fid!=""){
				$field_array = array(
					"user_id" => $prof_uid,
					"vno" => $vno,
					"issue_date" => $issue_date,
					"expiry_date" => $expiry_date,
					"location" => $location,
					"note" => $note,
					"log" => $log
				);
				
				
				$field_array  =  encryption($field_array ,$this->visa_encrypted_fields);
				 
				$rowid= data_inserter('info_visa',$field_array);
				$ans="done";
			}else{
				$ans="error";
			}	
			//echo $ans;
			redirect('profile/visa/'.$prof_fid);
		}	
	}
	
	
	public function edit_visa(){
		if(check_logged_in()){
			
			$issue_date = mmddyy2mysql(trim($this->input->post('issue_date')));
			$expiry_date = mmddyy2mysql(trim($this->input->post('expiry_date')));
			
			$prof_fid = trim($this->input->post('prof_fid'));
			$did = trim($this->input->post('did'));
			$vno = trim($this->input->post('vno'));	
			$location = trim($this->input->post('location'));	
			$note = trim($this->input->post('note'));
			$log=get_logs();
			
			if($did!=""){
				$field_array = array(
					"vno" => $vno,
					"location" => $location,
					"issue_date" => $issue_date,
					"expiry_date" => $expiry_date,
					"note" => $note,
					"log" => $log
				);
				
				
				$field_array  =  encryption($field_array ,$this->visa_encrypted_fields);
				 
				
				$this->db->where('id', $did);
				$this->db->update('info_visa', $field_array);
				$ans="Done";
			}else{
				$ans="error";
			}	
			//echo $ans;
			redirect('profile/visa/'.$prof_fid);
		}	
	}

///////////////////////////////////Bank Info/////////////////////////////////////////////	
//////	
	public function bank()
    {
        if(check_logged_in()){
			
			//setcookie("pmenu", "9");
			$_SESSION['pmenu'] = "9";
			
			$prof_fid=$this->uri->segment(3);
			$user_site_id= get_user_site_id();
			$role_id= get_role_id();
			$user_office_id=get_user_office_id();
			$ses_dept_id=get_dept_id();						
			$is_global_access=get_global_access();
			$current_user = get_user_id();
			
			if($prof_fid==""){
				$prof_fid=get_user_fusion_id();
				$prof_uid=$current_user;
			}else{
				$prof_uid=$this->Common_model->get_single_value("Select id as value from signin where fusion_id='$prof_fid'");
			}
			
			$data['prof_fid']=$prof_fid;
			$data['prof_uid']=$prof_uid;
			
			$data['prof_pic_url']=$this->Profile_model->get_profile_pic($prof_fid);
			$data['prof_widget_left']=$this->Profile_model->get_profile_widget($prof_fid,"left");
			$data['prof_widget']=$this->Profile_model->get_profile_widget($prof_fid,"");
						
			$data["aside_template"] = "profile/aside.php";
			$data["content_template"] = "profile/bank.php";
			
			$qSql="select * from info_bank where user_id='$prof_uid'";
			$data["bank_info"] = $this->Common_model->get_query_result_array($qSql);
						
						
			
			
			if(!empty($data["bank_info"])){	
				$data["bank_info"]   =  multidecryption($data["bank_info"] ,$this->bank_encrypted_fields);
			} 			
						
			$qStrParam=$_SERVER["QUERY_STRING"];
			$data['qStrParam']=$qStrParam;
            $this->load->view('dashboard',$data);
		}
    }
	
	public function add_bank(){
		if(check_logged_in()){
			$prof_fid = trim($this->input->post('prof_fid'));
			$prof_uid = trim($this->input->post('prof_uid'));
			$bank_name = trim($this->input->post('bank_name'));
			$branch = trim($this->input->post('branch'));
			$acc_no = trim($this->input->post('acc_no'));
			$ifsc_code = trim($this->input->post('ifsc_code'));
			$log=get_logs();
			
			if($prof_fid!=""){
				$field_array = array(
					"user_id" => $prof_uid,
					"bank_name" => $bank_name,
					"branch" => $branch,
					"acc_no" => $acc_no,
					"ifsc_code" => $ifsc_code,
					"log" => $log
				);
				
				$encrypted_fields  = array('bank_name','branch','acc_no','ifsc_code');
				$field_array  =  encryption($field_array ,$encrypted_fields);

				$rowid= data_inserter('info_bank',$field_array);
				$ans="done";
			}else{
				$ans="error";
			}	
			//echo $ans;
			redirect('profile/bank/'.$prof_fid);
		}
	}	
	
	public function edit_bank(){
		if(check_logged_in()){	
			$prof_fid = trim($this->input->post('prof_fid'));
			$did = trim($this->input->post('did'));
			$bank_name = trim($this->input->post('bank_name'));
			$branch = trim($this->input->post('branch'));
			$acc_no = trim($this->input->post('acc_no'));
			$ifsc_code = trim($this->input->post('ifsc_code'));
			$log=get_logs();
			
			if($did!=""){
				$field_array = array(
					"bank_name" => $bank_name,
					"branch" => $branch,
					"acc_no" => $acc_no,
					"ifsc_code" => $ifsc_code,
					"log" => $log
				);
				
				$encrypted_fields  = array('bank_name','branch','acc_no','ifsc_code');
				$field_array  =  encryption($field_array ,$encrypted_fields);
				
				echo "<prE>";
				print_r($field_array);	
				
				$this->db->where('id', $did);
				$this->db->update('info_bank', $field_array);
				$ans="Done";
			}else{
				$ans="error";
			}	
			//echo $ans;
			redirect('profile/bank/'.$prof_fid);
		}	
	}
	
////////////////////////////////Files Uploaded Part/////////////////////////////////
	public function profileDocument(){
		if(check_logged_in()){
			$_SESSION['pmenu'] = "10";
			$prof_fid=$this->uri->segment(3);
			$user_site_id= get_user_site_id();
			$role_id= get_role_id();
			$user_office_id=get_user_office_id();
			$ses_dept_id=get_dept_id();						
			$is_global_access=get_global_access();
			$current_user = get_user_id();
			$current_user_fusion_id = get_user_fusion_id();
			
			if($prof_fid==""){
				$prof_fid=get_user_fusion_id();
				$prof_uid=$current_user;
			}else{
				$prof_uid=$this->Common_model->get_single_value("Select id as value from signin where fusion_id='$prof_fid'");
			}
			
			$data['prof_fid']=$prof_fid;
			$data['prof_uid']=$prof_uid;
			
			$data['prof_pic_url']=$this->Profile_model->get_profile_pic($prof_fid);
			$data['prof_widget_left']=$this->Profile_model->get_profile_widget($prof_fid,"left");
			$data['prof_widget']=$this->Profile_model->get_profile_widget($prof_fid,"");
						
			$data["aside_template"] = "profile/aside.php";
			$data["content_template"] = "profile/your_documents.php";
			
		/////////////	
			$qSql= 'SELECT * FROM `info_experience` where user_id="'.$prof_uid.'"';
			$data['experiance_list'] = $processArray = $this->Common_model->get_query_result_array($qSql);
			
			$qSql= 'SELECT * FROM `info_bank` where user_id="'.$prof_uid.'"';
			$data['bank_list'] = $processArray = $this->Common_model->get_query_result_array($qSql);
			
			$qSql= 'SELECT * FROM `info_passport` where user_id="'.$prof_uid.'"';
			$data['passport_list'] = $processArray = $this->Common_model->get_query_result_array($qSql);
			
			
			$qSql= 'SELECT * FROM `info_education` where user_id="'.$prof_uid.'"';
			$data['education_list'] = $processArray = $this->Common_model->get_query_result_array($qSql);
			
			$qSql= 'SELECT * FROM `info_others` where user_id="'.$prof_uid.'"';
			$data['other_list'] = $processArray = $this->Common_model->get_query_result_array($qSql);
			
		/////////////	
			
			$qStrParam=$_SERVER["QUERY_STRING"];
			$data['qStrParam']=$qStrParam;
            $this->load->view('dashboard',$data);
			
		}
	}
	
	
	public function upload(){
        if(check_logged_in()){
			$user_site_id= get_user_site_id();
			$role_id= get_role_id();
			$current_user = get_user_id();
			$data_type = $this->input->post();
			$prof_fid = get_user_fusion_id();
			
			if($prof_fid==""){
				$prof_fid=get_user_fusion_id();
				$prof_uid=$current_user;
			}else{
				$prof_uid=$this->Common_model->get_single_value("Select id as value from signin where fusion_id='$prof_fid'");
			}
			
			$data['prof_fid']=$prof_fid;
			$data['prof_uid']=$prof_uid;
	
			$config['upload_path']          = 'pimgs/'.$prof_fid.'/';
			if (!is_dir($config['upload_path']))
			{
				mkdir($config['upload_path'], 0777, TRUE);
			}
			
			$config['allowed_types']        = 'pdf|jpg|png|doc|docx';
			$config['max_size']             = 2048;

			$this->load->library('upload', $config);
			$response = array();
			if ( ! $this->upload->do_upload('myfile'))
			{
				$response = array('error' => $this->upload->display_errors());
			}
			else
			{
				$data = array('upload_data' => $this->upload->data());

				if(isset($data_type['exp_id']))
				{
					$query = $this->db->query('UPDATE `info_experience` SET `job_doc`="'.$this->upload->data('file_name').'" WHERE id="'.$data_type['exp_id'].'"');
					if(!$query)
					{
						$response = array('error'=>'query');
					}
					else
					{
						$response = array("success"=>"true","exp_id"=>$data_type['exp_id'],"file_name"=>$this->upload->data('file_name'));
					}
				}
				else if(isset($data_type['bank_id']))
				{
					$query = $this->db->query('UPDATE `info_bank` SET `bank_doc`="'.$this->upload->data('file_name').'" WHERE id="'.$data_type['bank_id'].'"');
					if(!$query)
					{
						$response = array('error'=>'query');
					}
					else
					{
						$response = array("success"=>"true","bank_id"=>$data_type['bank_id'],"file_name"=>$this->upload->data('file_name'));
					}
				}
				else if(isset($data_type['passport_id']))
				{
					$query = $this->db->query('UPDATE `info_passport` SET `passport_doc`="'.$this->upload->data('file_name').'" WHERE id="'.$data_type['passport_id'].'"');
					if(!$query)
					{
						$response = array('error'=>'query');
					}
					else
					{
						$response = array("success"=>"true","passport_id"=>$data_type['passport_id'],"file_name"=>$this->upload->data('file_name'));
					}
				}
				else if(isset($data_type['education_id']))
				{
					$query = $this->db->query('UPDATE `info_education` SET `education_doc`="'.$this->upload->data('file_name').'" WHERE id="'.$data_type['education_id'].'"');
					if(!$query)
					{
						$response = array('error'=>'query');
					}
					else
					{
						$response = array("success"=>"true","education_id"=>$data_type['education_id'],"file_name"=>$this->upload->data('file_name'));
					}
				}
				else if(isset($data_type['info_type']))
				{
					$query = $this->db->query('INSERT INTO `info_others`(`user_id`, `info_type`, `info_doc`) VALUES ("'.$current_user.'","'.$data_type['info_type'].'","'.$this->upload->data('file_name').'")');
					if(!$query)
					{
						$response = array('error'=>'query');
					}
					else
					{
						$insert_id = $this->db->insert_id();
						$response = array("success"=>"true",'sl'=>$data_type['sl'],'insert_id'=>$insert_id,"info_type"=>$data_type['info_type'],"file_name"=>$this->upload->data('file_name'));
					}
				}
				else if(isset($data_type['other_id']))
				{
					$query = $this->db->query('UPDATE `info_others` SET `info_doc`="'.$this->upload->data('file_name').'" WHERE id="'.$data_type['other_id'].'"');
					if(!$query)
					{
						$response = array('error'=>'query');
					}
					else
					{
						$response = array("success"=>"true","other_id"=>$data_type['other_id'],"file_name"=>$this->upload->data('file_name'));
					}
				}
			}
			echo json_encode($response);
		}
   }

	
}
?>