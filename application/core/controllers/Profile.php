<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends CI_Controller {
    
    /////////////////////////////////////////////////////////////////////////////////////////////
    // INDEX PAGE
    /////////////////////////////////////////////////////////////////////////////////////////////
    
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
				if(is_view_profile($prof_fid)==false) redirect(base_url()."profile","refresh");
				
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
			
			// $qSql="Select * from info_education where user_id='$prof_uid'";
			if(get_user_office_id()=='CAS'){
				$qSql = "SELECT ie.*,mq.qualification as exam_name from master_qualifications 
				as mq LEFT JOIN info_education as ie ON mq.id=ie.exam where ie.user_id='$prof_uid' ";
				}else{
					$qSql="select * from info_education where user_id='$prof_uid'";
				}
			$data["education_info"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql="Select * from info_experience where user_id='$prof_uid'";
			$data["experience_info"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql="Select * from info_skills where user_id='$prof_uid'";
			$data["skills_info"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql="Select * from info_passport where user_id='$prof_uid'";
			$data["passport_info"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql="Select * from info_visa where user_id='$prof_uid'";
			$data["visa_info"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql="Select * from info_payroll where user_id='$prof_uid'";
			//echo $qSql;
			$data["payroll_info"] = $this->Common_model->get_query_row_array($qSql);
			
			$qSql="Select * from info_bank where user_id='$prof_uid'";
			$data["bank_info"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql="Select * from info_family where user_id='$prof_uid'";
			$data["family_info"] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql="Select * from info_nominee where user_id='$prof_uid'";
			$data["nominee_info"] = $this->Common_model->get_query_result_array($qSql);
			
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
			$user_oth_office=get_user_oth_office();
			
			if($prof_fid==""){
				$prof_fid=get_user_fusion_id();
				$prof_uid=$current_user;
			}else{
				if(is_view_profile($prof_fid)==false) redirect(base_url()."profile","refresh");
				$prof_uid=$this->Common_model->get_single_value("Select id as value from signin where fusion_id='$prof_fid'");
			}
			
			$sql_selected = "SELECT * from master_currency WHERE is_active = '1'";
			$data['mastercurrency'] = $this->Common_model->get_query_result_array($sql_selected);
			
			////////////////
			
			if(get_role_dir()=="super" || get_role_dir()=="admin" || $is_global_access==1){
				
				$qSql="SELECT id,name, org_role FROM role where is_active=1 and id>0 ORDER BY name";	
				$data['role_list'] = $this->Common_model->get_rolls_for_assignment2($qSql);
				$data['role_organization'] = $this->Common_model->role_organization();
				
			}else if(get_dept_folder()=="hr"){
				
				$qSql="SELECT id,name, org_role FROM role where is_active=1 and id>0 ORDER BY name";
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
			
			if(get_role_dir()=="super" || $is_global_access==1 || get_dept_folder()=="hr"){
				$data['tl_list'] = $this->Common_model->get_tls_for_assign2("");	
			}else{
				
				//$tl_cnd=" and (site_id='$user_site_id' OR office_id='$user_office_id') ";
				$tl_cnd = " and (office_id='$user_office_id' OR '$user_oth_office' like CONCAT('%',office_id,'%')) ";
				$data['tl_list'] = $this->Common_model->get_tls_for_assign2($tl_cnd);
			}
			
			///////////////
			
			$data['prof_fid']=$prof_fid;
			$data['prof_uid']=$prof_uid;
			
			$data['prof_pic_url']=$this->Profile_model->get_profile_pic($prof_fid);
			$data['prof_widget_left']=$this->Profile_model->get_profile_widget($prof_fid,"left");
			$data['prof_widget']=$this->Profile_model->get_profile_widget($prof_fid,"");
						
			$data["aside_template"] = "profile/aside.php";
			$data["content_template"] = "profile/system.php";
			// $data["content_js"] = "profile/scripts_js.php";
			
			/* $qSql="select ac.*, (select GROUP_CONCAT(' ', shname) from client c where CONCAT(',',ac.client_id,',') like CONCAT('%,',c.id,',%')) as name from info_assign_client ac where ac.user_id = '$prof_uid' ";
			$data["client_info"] = $this->Common_model->get_query_result_array($qSql); */
						
			$data["main_info"] = $this->Profile_model->get_main_info($prof_fid);
			// print_r($data["main_info"]);exit;
			  
		    $data['cur_user'] = $prof_uid;
			
			$data['client_list'] = $this->Common_model->get_client_list_1();			
			$data['assign_client'] = $this->Common_model->info_assign_client("SELECT client_id as id,user_id,client_id,(select fullname from client where id=info_assign_client.client_id)as client_info FROM info_assign_client where user_id='".$data['cur_user'] ."'");			
			$data['assigned_clients'] = array_column($data['assign_client'], 'client_id');
			
			
			$data['client_list_2'] = $this->Common_model->get_process_list_1();		
			$data['client_list_3'] = $data['client_list_2'];			
			if(!empty($data['assigned_clients'])){
				$assignedClients = implode(',', $data['assigned_clients']);
				$data['client_list_3'] = $this->Common_model->info_assign_client("SELECT ip.process_id as id,ip.user_id,ip.process_id,p.name FROM info_assign_process as ip LEFT JOIN process as p ON p.id = ip.process_id where p.client_id IN ($assignedClients) GROUP BY ip.process_id");
			}				
			$data['assign_process'] = $this->Common_model->info_assign_client("SELECT id,user_id,process_id,(select name from process where process.id= info_assign_process.process_id) as process_info FROM info_assign_process where user_id='".$data['cur_user'] ."'");			
			$data['assigned_process'] = array_column($data['assign_process'], 'process_id');
			
			/* echo "<pre>";
			print_r($data['assign_process']); 
		 	*/	

			 if(get_user_office_id()=="CAS"){
				 $Sqls= "SELECT * from master_emp_status where is_active=1";
				//  $Sqls= "SELECT * from master_emp_status where is_active=1 and id  BETWEEN 5 and 7";
				 $data['type_of_contract'] = $this->Common_model->get_query_result_array($Sqls);

				//  $saqlain = "SELECT s.emp_status,mes.name as type_of_con_name from master_emp_status as mes LEFT JOIN signin as s ON s.emp_status=mes.id";
				//  $data['type_of_contract_name'] = $this->Common_model->get_query_result_array($saqlain);
				//  print_r($data['type_of_contract_name']);exit();
			// 	 $qSql = "SELECT ie.*,mq.qualification as exam_name from master_qualifications 
			// as mq LEFT JOIN info_education as ie ON mq.id=ie.exam where ie.user_id='$prof_uid' ";
			 }
			
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
			
			// print_r($_POST); exit;
				
			$current_user = get_user_id();
			$evt_date = CurrMySqlDate();
			$user_office_id=get_user_office_id();
			
			$office_id = trim($this->input->post('office_id'));
			$prof_id = trim($this->input->post('prof_id'));
			$prof_fid=trim($this->input->post('prof_fid'));
			
			// if(is_update_system_data()==false) redirect('profile/maininfo/'.$prof_fid);
			
			$site_id = trim($this->input->post('site_id'));
			
			$dept_id = trim($this->input->post('dept_id'));
			$sub_dept_id = trim($this->input->post('sub_dept_id'));
			$xpoid = trim($this->input->post('xpoid'));
			
			$doj = trim($this->input->post('doj'));
			if(isIndiaLocation($office_id) ==true) $doj= ddmmyy2mysql($doj);
			else  $doj= mmddyy2mysql($doj);
			
			$dstart = $this->input->post('dstart');
			$dstart= mmddyy2mysql($dstart);
			// echo $dstart; exit;
			$dend = $this->input->post('dend');
			$dend= mmddyy2mysql($dend);

			$dob = trim($this->input->post('dob'));
			
			if(isIndiaLocation($office_id) ==true) $dob= ddmmyy2mysql($dob);
			else  $dob= mmddyy2mysql($dob);
			
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
			$payroll_currency=trim($this->input->post('currency'));
			
			$type_of_contract=trim($this->input->post('emp_status'));

			
			
			
			$qSql="Select gross_pay as value from  info_payroll where user_id='$prof_id'";
			$gross_pay_old = $this->Common_model->get_single_value($qSql);
						
			$gross_pay = $this->input->post('gross_pay');
			$gross_pay = trim($gross_pay);
			
			if(is_null($gross_pay)) $gross_pay='0';
			if($gross_pay=="") $gross_pay='0';
			
			if($gross_pay == '0') $gross_pay = $gross_pay_old;
			
			/////
			//$is_bod=trim($this->input->post('is_bod'));
			//$reporting_level1=trim($this->input->post('reporting_level1'));
			//$reporting_level2=trim($this->input->post('reporting_level2'));
			//$reporting_level3=trim($this->input->post('reporting_level3'));
			/////
			
			$qSql="Select log from signin where id = '$prof_id'";
			$prevLog=getDBPrevLogs($qSql);
			
			$log = "Update System Info :: ". get_logs($prevLog);
			
			if($prof_id!=""){
				
				$qSql="Select assigned_to as value from  signin where id='$prof_id'";
				$old_l1=$this->Common_model->get_single_value($qSql);
				
				$field_array1 = array(
					"dept_id" => $dept_id,
					"site_id" => $site_id,
					"sub_dept_id" => $sub_dept_id,
					"xpoid" => $xpoid,
					"doj" => $doj,
					"dob" => $dob,
					"sex" => $sex,
					"batch_code" => $batch_code,
					"fname" => $fname,
					"lname" => $lname,
					"role_id" => $role_id,
					"org_role_id" => $org_role_id,
					"assigned_to" => $assigned_to,
					"last_updated_date" => $evt_date,
					"last_updated_by" => $current_user,
					"emp_status" => $type_of_contract,
					"fixed_term_start" => $dstart,
					"fixed_term_end" => $dend,
					"log" => $log
				);
				
				
				$this->db->where('id', $prof_id);
				$this->db->update('signin', $field_array1);
				////////
				
				$new_l1=$assigned_to;
				if($old_l1!=$assigned_to){
					$logs=get_logs();
					$msg=" Old Value: ".$old_l1 . "";
					log_record($prof_id,$msg,'SystemInfo L1 Supervisor',$this->input->post(),$logs);
				}	
				
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
						"gross_pay" => $gross_pay,
						"currency" => $payroll_currency,
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
				
				$logs=get_logs(); 
				$msg="Update";
				log_record($prof_id,$msg,'System Info',$this->input->post(),$logs);
						
				$ans="Done";
			}else{
				$ans="error";
			}
			
			//echo $ans;
			redirect('profile/maininfo/'.$prof_fid);
		}	
	}
	
	
	public function updateHRInfo(){
		
		if(check_logged_in()){
			
			$current_user = get_user_id();
			$evt_date=CurrMySqlDate();
			
			$qSql="Select log from signin where id = '$current_user'";
			$prevLog=getDBPrevLogs($qSql);
			$log=get_logs($prevLog);
			$log = "Update DOB & Gender:: " .$log;
			
			$dob = trim($this->input->post('dob'));
			$sex=trim($this->input->post('sex'));
			
			if($current_user!=""){
				
				$field_array = array(
					"sex" => $sex,
					"last_updated_date" => $evt_date,
					"last_updated_by" => $current_user,
					"log" => $log
				);
				
				if($dob!=""){
				 $dob=mmddyy2mysql($dob);
				 $field_array['dob']=$dob;
				}

				
				$this->db->where('id', $current_user);
				$this->db->update('signin', $field_array);	
				
				$ans="done";
			}else{
				$ans="error";
			}
			
			$referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'profile/personal/'.$prof_fid;
			redirect($referer);
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
				if(is_view_profile($prof_fid)==false) redirect(base_url()."profile","refresh");
				$prof_uid=$this->Common_model->get_single_value("Select id as value from signin where fusion_id='$prof_fid'");
			}
			
			$data['prof_fid']=$prof_fid;
			$data['prof_uid']=$prof_uid;
			
			$data['prof_pic_url']=$this->Profile_model->get_profile_pic($prof_fid);
			$data['prof_widget_left']=$this->Profile_model->get_profile_widget($prof_fid,"left");
			$data['prof_widget']=$this->Profile_model->get_profile_widget($prof_fid,"");
						
			$data["aside_template"] = "profile/aside.php";
			$data["content_template"] = "profile/personal.php";
			
			/*
			$qSql="select info.*,
			(SELECT name FROM master_countries WHERE id=country_pre) AS country_present,
			(SELECT name FROM master_states WHERE id=state_pre) AS state_present,
			IFNULL((SELECT name FROM master_cities WHERE id=city_pre),info.city_pre) AS city_present,
			(SELECT name FROM master_countries WHERE id=country) AS country_permanent,
			(SELECT name FROM master_states WHERE id=state) AS state_permanent,
			IFNULL((SELECT name FROM master_cities WHERE id=city),info.city) AS city_permanent,
			IFNULL((SELECT name FROM master_cities WHERE id=city_pre),'other') AS city_present_other,
			IFNULL((SELECT name FROM master_cities WHERE id=city),'other') AS city_permanent_other
			from info_personal as info 
			WHERE info.user_id='$prof_uid'";
			*/
			
			$qSql="Select * from info_personal as info WHERE info.user_id='$prof_uid'";
			
			$data["personal_info"] = $this->Common_model->get_query_row_array($qSql);
			$data["main_info"] = $this->Profile_model->get_main_info($prof_fid);
			
			$country_pre_Sql="Select * FROM master_countries ORDER BY name ASC";
			$data["get_countries"] = $this->Common_model->get_query_result_array($country_pre_Sql);
			
			//$state_pre_Sql="Select * FROM master_states WHERE country_id='".$data["personal_info"]["country_pre"]."' ORDER BY name ASC";
			
			$state_pre_Sql="Select * FROM master_states WHERE country_id=(select id from master_countries where name ='".$data["personal_info"]["country_pre"]."') ORDER BY name ASC";
			
			//echo $state_pre_Sql;
			
			$data["get_pre_states"] = $this->Common_model->get_query_result_array($state_pre_Sql);
			
			//$city_pre_Sql="Select * FROM master_cities WHERE state_id='".$data["personal_info"]["state_pre"]."' ORDER BY name ASC";
			$city_pre_Sql="Select * FROM master_cities WHERE state_id in (select id from master_states where name ='".$data["personal_info"]["state_pre"]."') ORDER BY name ASC";
			$data["get_pre_cities"] = $this->Common_model->get_query_result_array($city_pre_Sql);
			
			//$state_per_Sql="Select * FROM master_states WHERE country_id='".$data["personal_info"]["country"]."' ORDER BY name ASC";
			$state_per_Sql="Select * FROM master_states WHERE country_id=(select id from master_countries where name ='".$data["personal_info"]["country"]."') ORDER BY name ASC";
			$data["get_per_states"] = $this->Common_model->get_query_result_array($state_per_Sql);
			
			//$city_per_Sql="Select * FROM master_cities WHERE state_id='".$data["personal_info"]["state"]."' ORDER BY name ASC";
			$city_per_Sql="Select * FROM master_cities WHERE state_id in (select id from master_states where name ='".$data["personal_info"]["state"]."') ORDER BY name ASC";
			$data["get_per_cities"] = $this->Common_model->get_query_result_array($city_per_Sql);
			
			$qStrParam=$_SERVER["QUERY_STRING"];
			$data['qStrParam']=$qStrParam;
			$this->load->view('dashboard',$data);
		}
    }	
	
	public function stateList()
	{
		$json = array();
		$country	=	$this->input->post("country");
		$stateSql="Select * from master_states where country_id='$country' ORDER BY name ASC";
		$get_states = $this->Common_model->get_query_result_array($stateSql);
		$json['error'] = false;
		$json['state_list'] = $get_states;
		echo json_encode($json);exit();
	}
	
	public function cityList()
	{
		$json = array();
		$state	=	$this->input->post("state");
		$citySql="Select * from master_cities where state_id='$state' ORDER BY name ASC";
		$get_cities = $this->Common_model->get_query_result_array($citySql);
		$json['error'] = false;
		$json['city_list'] = $get_cities;
		echo json_encode($json);exit();
	}
	
	public function editPersonal()
	{
		
		if(check_logged_in()){
			$prof_id = trim($this->input->post('prof_id'));
			$prof_fid=trim($this->input->post('prof_fid'));
			$office_id=trim($this->input->post('office_id'));
			$dob = trim($this->input->post('dob'));
			if($dob!=""){
				if(isIndiaLocation($office_id) ==true)
				{
					$dob=ddmmyy2mysql($dob);
				}
				else
				{
					$dob=mmddyy2mysql($dob);
				}
				$field_array['dob']=$dob;
			}

			$dexp = trim($this->input->post('dexp'));
			if($dexp!=""){
				if(isIndiaLocation($office_id) ==true)
				{
					$dexp=ddmmyy2mysql($dexp);
				}
				else
				{
					$dexp=mmddyy2mysql($dexp);
				}
			}

			$sex = trim($this->input->post('sex'));
			
			$dom = trim($this->input->post('dom'));
			if($dom!=""){
				if(isIndiaLocation($office_id) ==true )
				{
					$dom=ddmmyy2mysql($dom);
				}
				else
				{
					$dom=mmddyy2mysql($dom);
				}
			}
			$blood_group = trim($this->input->post('blood_group'));
			
			$nationality = trim($this->input->post('nationality'));
			$caste = trim($this->input->post('caste'));
			$is_ph = trim($this->input->post('is_ph'));
			$is_diff_abled = trim($this->input->post('is_diff_abled'));
			$ph_type = !empty($this->input->post('ph_type')) ? implode(',',$this->input->post('ph_type')):"";
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
			
			$pre_pin = trim($this->input->post('pre_pin'));
			if($this->input->post('pre_city'))
			{
				$pre_city =	trim($this->input->post('pre_city'));
			}
			else
			{
				$pre_city =	trim($this->input->post('pre_city_other'));
			}
			
			$pre_state = trim($this->input->post('pre_state'));
			$pre_country = trim($this->input->post('pre_country'));
			$address_present = trim($this->input->post('address_present'));
			$per_pin = trim($this->input->post('per_pin'));
			
			if($this->input->post('per_city'))
			{
				$per_city =	trim($this->input->post('per_city'));
			}
			else
			{
				$per_city =	trim($this->input->post('per_city_other'));
			}
			$per_state = trim($this->input->post('per_state'));
			$per_country = trim($this->input->post('per_country'));
			$address_permanent = trim($this->input->post('address_permanent'));
			
			$same_addr = trim($this->input->post('same_addr'));
			$social_security_no = trim($this->input->post('social_security_no'));
			$pan_no = trim($this->input->post('pan_no'));
			$uan_no = trim($this->input->post('uan_no'));
			$esi_no = trim($this->input->post('esi_no'));
			
			$current_user = get_user_id();
			$log = get_logs();
			$curDateTime  = CurrMySqlDate();
						
			if($prof_id!=""){
				
				$sqlCheck = "SELECT count(*) as value from info_personal WHERE user_id = '".$prof_id."'";
				$queryCheck = $this->Common_model->get_single_value($sqlCheck);
				
				$field_array = [				
					"blood_group" => $blood_group,
					"nationality" => $nationality,
					"caste" => $caste,
					"is_ph" => $is_ph,
					"ph_type" => $ph_type,
					"ph_per" => $ph_per,
					"father_name" => $father_name,
					"email_id_per" => $email_id_per,
					"email_id_off" => $email_id_off,
					"mother_name" => $mother_name,
					"phone" => $phone,
					"phone_emar" => $phone_emar,
					"marital_status" => $marital_status,
					"dom" => $dom,
					"spouse_name" => $spouse_name,
					"no_of_children" => $no_of_children,
					"pin_pre" => $pre_pin,
					"city_pre" => $pre_city,
					"state_pre" => $pre_state,
					"country_pre" => $pre_country,
					"address_present" => $address_present,
					"pin" => $per_pin,
					"city" => $per_city,
					"state" => $per_state,
					"country" => $per_country,
					"address_permanent" => $address_permanent,
					"same_addr" => $same_addr,
					"social_security_no" => $social_security_no,
					"pan_no" => $pan_no,
					"id_expiration_date" => $dexp,
					"uan_no" => $uan_no,
					"esi_no" => $esi_no,
					"log" => $log
				];
				
				if($queryCheck > 0)
				{
					$this->db->where('user_id', $prof_id);
					$this->db->update('info_personal', $field_array);
					
				} else {
					
					$field_array += [ "user_id" => $prof_id ];
					$rowid= data_inserter('info_personal',$field_array);
				}
				
				//$this->db->query('DELETE FROM info_personal WHERE user_id = "'.$prof_id.'"');
								
			//////////	
				
				$field_array1 = array(
					"dob" => $dob,
					"sex" => $sex
				);
				$this->db->where('id', $prof_id);
				$this->db->update('signin', $field_array1);
				
				$logs=get_logs(); 
				$msg="Update";
				log_record($prof_id,$msg,'Personal Info',$this->input->post(),$logs);
					
					
			/////////	
				
				$ans="done";
			}else{
				$ans="error";
			}	
			//echo $ans;	
			//redirect('profile/personal/'.$prof_fid);
			
			$referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'profile/personal/'.$prof_fid;
			redirect($referer);
			
		}
	}
	
	
	public function updateSocialInfo(){
		
		if(check_logged_in()){
			
			$current_user = get_user_id();
			
			$pan_no = trim($this->input->post('pan_no'));
			$social_security_no=trim($this->input->post('social_security_no'));
			
			$email_id_per = mmddyy2mysql(trim($this->input->post('email_id_per')));
			$email_id_off = trim($this->input->post('email_id_off'));
			
			$phone = trim($this->input->post('phone'));
			$is_correct_nos = trim($this->input->post('is_correct_nos'));
			
			$qSql = "Select count(id) as value from info_personal where user_id = $current_user";
			$isExistData = $this->Common_model->get_single_value($qSql);
					
			if($current_user!=""){
				
				$field_array = array(
					"user_id" => $current_user,
					"pan_no" => $pan_no,
					"social_security_no" => $social_security_no,
					"email_id_per" => $email_id_per,
					"email_id_off" => $email_id_off,
					"phone" => $phone,
					"is_correct_nos" => $is_correct_nos
				);
				
				if($isExistData ==0)data_inserter('info_personal',$field_array);
				else{
					$this->db->where('user_id', $current_user);
					$this->db->update('info_personal', $field_array);	
				}
				$ans="done";
			}else{
				$ans="error";
			}
			
			$referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'profile/personal/'.$prof_fid;
			redirect($referer);
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
				if(is_view_profile($prof_fid)==false) redirect(base_url()."profile","refresh");
				$prof_uid=$this->Common_model->get_single_value("Select id as value from signin where fusion_id='$prof_fid'");
			}
			
			$data['prof_fid']=$prof_fid;
			$data['prof_uid']=$prof_uid;
			
			$data['prof_pic_url']=$this->Profile_model->get_profile_pic($prof_fid);
			$data['prof_widget_left']=$this->Profile_model->get_profile_widget($prof_fid,"left");
			$data['prof_widget']=$this->Profile_model->get_profile_widget($prof_fid,"");
						
			$data["aside_template"] = "profile/aside.php";
			$data["content_template"] = "profile/education.php";
			
			if(get_user_office_id()=='CAS'){
			$qSql = "SELECT ie.*,mq.qualification as exam_name from master_qualifications 
			as mq LEFT JOIN info_education as ie ON mq.id=ie.exam where ie.user_id='$prof_uid' ";
			}else{
				$qSql="select * from info_education where user_id='$prof_uid'";
			}
			$data["education_info"] = $this->Common_model->get_query_result_array($qSql);
			// print_r($data['education_info']);exit;

			$qSql2="select * from master_qualifications where location_id='CAS' and is_active=1";
			$data['qualification_s'] = $this->Common_model->get_query_result_array($qSql2);
			// print_r($data['qualification_s']);exit;
			
			$qSql3="select * from master_language where is_active=1";
			$data['languages'] = $this->Common_model->get_query_result_array($qSql3);


			$qStrParam=$_SERVER["QUERY_STRING"];
			$data['qStrParam']=$qStrParam;
            $this->load->view('dashboard',$data);	
				
		}
    }
	
	public function add_education()
	{
		// print_r($_POST); exit;
		if(check_logged_in()){
			$prof_fid = trim($this->input->post('prof_fid'));
			$prof_uid = trim($this->input->post('prof_uid'));
			$exam = trim($this->input->post('exam'));
			$passing_year = trim($this->input->post('passing_year'));
			$board_uv = trim($this->input->post('board_uv'));
			$specialization = trim($this->input->post('specialization'));
			$grade_cgpa = trim($this->input->post('grade_cgpa'));
			$type_of_lan_known = $this->input->post('type_of_lan_known');
			$training_in_progress = trim($this->input->post('training_in_progress'));
			$lang = implode(',', $type_of_lan_known);
			if($prof_fid!=""){
				$log=get_logs();
				$field_array = array(
					"user_id" => $prof_uid,
					"exam" => $exam,
					"passing_year" => $passing_year,
					"board_uv" => $board_uv,
					"specialization" => $specialization,
					"grade_cgpa" => $grade_cgpa,
					"type_of_lan_known" => $lang,
					"training_in_progress" => $training_in_progress,
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
			$type_of_lan_known = $this->input->post('type_of_lan_known');
			$training_in_progress = trim($this->input->post('training_in_progress'));
			$lang = implode(',', $type_of_lan_known);
			if($did!=""){
				$log=get_logs();
				$field_array = array(
					"exam" => $exam,
					"passing_year" => $passing_year,
					"board_uv" => $board_uv,
					"specialization" => $specialization,
					"grade_cgpa" => $grade_cgpa,
					"type_of_lan_known" => $lang,
					"training_in_progress" => $training_in_progress,
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
	
	public function delete_education()
	{
		if(check_logged_in()){
			
			$did = $this->uri->segment(3);
			$profileid = "SELECT fusion_id as value from signin WHERE id IN (SELECT user_id from info_education WHERE id = '$did')";
			$prof_fid = $this->Common_model->get_single_value($profileid);
			
			if($prof_fid != ""){
				$sqld = "DELETE from info_education WHERE id = '$did'";
				$queryd = $this->db->query($sqld);
			}
			
			redirect('profile/education/'.$prof_fid);
		}
	}
	

///////////////////////////////////FAMILY DETAILS/////////////////////////////////////////////	
//////
	public function family()
    {
        if(check_logged_in()){
			
			//setcookie("pmenu", "4");
			$_SESSION['pmenu'] = "10";
			
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
				if(is_view_profile($prof_fid)==false) redirect(base_url()."profile","refresh");
				$prof_uid=$this->Common_model->get_single_value("Select id as value from signin where fusion_id='$prof_fid'");
			}
			
			$data['prof_fid']=$prof_fid;
			$data['prof_uid']=$prof_uid;
			
			$data['prof_pic_url']=$this->Profile_model->get_profile_pic($prof_fid);
			$data['prof_widget_left']=$this->Profile_model->get_profile_widget($prof_fid,"left");
			$data['prof_widget']=$this->Profile_model->get_profile_widget($prof_fid,"");
						
			$data["aside_template"] = "profile/aside.php";
			$data["content_template"] = "profile/family.php";
			
			$qSql="select * from info_family where user_id='$prof_uid'";
			$data["family_info"] = $this->Common_model->get_query_result_array($qSql);
						
			$qStrParam=$_SERVER["QUERY_STRING"];
			$data['qStrParam']=$qStrParam;
            $this->load->view('dashboard',$data);	
		}
    }
	
	public function add_family()
	{
		if(check_logged_in()){
			
			$current_user = get_user_id();
			$curDateTime  = CurrMySqlDate();
			
			$prof_fid = trim($this->input->post('prof_fid'));
			$prof_uid = trim($this->input->post('prof_uid'));
			
			$family_name = trim($this->input->post('family_name'));
			$family_dob = mmddyy2mysql(trim($this->input->post('family_dob')));
			$family_phone = $this->input->post('family_phone');
			$family_relation = trim($this->input->post('family_relation'));
			$family_relation_other = trim($this->input->post('other_relation'));
			
			if($family_relation == "Others"){ $family_relation = $family_relation_other; }
			
			if($family_name!=""){				
				$log=get_logs();
				$field_array = array(
					"user_id" => $prof_uid,
					"name" => $family_name,
					"relation" => $family_relation,
					"dateofbirth" => $family_dob,
					"family_phone" => $family_phone,
					"added_by" => $current_user,
					"added_date" => $curDateTime,
					"log" => $log
				);
				$rowid= data_inserter('info_family',$field_array);
				$ans="done";
			}else{
				$ans="error";
			}	
			//echo $ans;
			redirect('profile/family/'.$prof_fid);
		}	
	}
	
	public function edit_family()
	{
		if(check_logged_in()){
			
			$current_user = get_user_id();
			$curDateTime  = CurrMySqlDate();
			
			$prof_fid = trim($this->input->post('prof_fid'));
			$did = trim($this->input->post('did'));
			$e_user_id = trim($this->input->post('e_userid'));
			$family_name = trim($this->input->post('e_family_name'));
			$family_dob = mmddyy2mysql(trim($this->input->post('e_family_dob')));
			$family_phone = $this->input->post('e_family_phone');
			$family_relation = trim($this->input->post('e_family_relation'));
			$family_relation_other = trim($this->input->post('e_other_relation'));
			
			if($family_relation == "Others"){ $family_relation = $family_relation_other; }
			
			if($did!=""){
				$log=get_logs();
				$field_array = array(
				    "user_id" => $e_user_id,
					"name" => $family_name,
					"relation" => $family_relation,
					"dateofbirth" => $family_dob,
					"family_phone" => $family_phone,
					"added_by" => $current_user,
					"added_date" => $curDateTime,
					"log" => $log
				);
				$this->db->where('id', $did);
				$this->db->update('info_family', $field_array);
				$ans="Done";
			}else{
				$ans="error";
			}	
			//echo $ans;	
			redirect('profile/family/'.$prof_fid);
		}	
	}
	
	public function delete_family()
	{
		if(check_logged_in()){
			
			$did = $this->uri->segment(3);
			$profileid = "SELECT fusion_id as value from signin WHERE id IN (SELECT user_id from info_family WHERE id = '$did')";
			$prof_fid = $this->Common_model->get_single_value($profileid);
			
			if($prof_fid != ""){
				$sqld = "DELETE from info_family WHERE id = '$did'";
				$queryd = $this->db->query($sqld);
			}
			
			redirect('profile/family/'.$prof_fid);
		}
	}
	

///////////////////////////////////NOMINEE DETAILS/////////////////////////////////////////////	
//////
	public function nominee()
    {
        if(check_logged_in()){
			
			//setcookie("pmenu", "4");
			$_SESSION['pmenu'] = "11";
			
			$data['default_country'] = $default_country = "101";
			
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
				if(is_view_profile($prof_fid)==false) redirect(base_url()."profile","refresh");
				$prof_uid=$this->Common_model->get_single_value("Select id as value from signin where fusion_id='$prof_fid'");
			}
			
			$data['prof_fid']=$prof_fid;
			$data['prof_uid']=$prof_uid;
			
			$data['prof_pic_url']=$this->Profile_model->get_profile_pic($prof_fid);
			$data['prof_widget_left']=$this->Profile_model->get_profile_widget($prof_fid,"left");
			$data['prof_widget']=$this->Profile_model->get_profile_widget($prof_fid,"");
						
			$data["aside_template"] = "profile/aside.php";
			$data["content_template"] = "profile/nominee.php";
			
			$qSql="select * from info_nominee where user_id='$prof_uid'";
			$data["nominee_info"] = $this->Common_model->get_query_result_array($qSql);
			
			
			$get_country = "SELECT country_id as value from master_states WHERE name IN (SELECT state from info_nominee WHERE user_id='$prof_uid')";
			$data['country_id_get'] = $this->Common_model->get_single_value($get_country);
			
			if($data['country_id_get'] != ""){
				$default_country = $data['country_id_get'];
			}
			
			$qSqlCountry="select * from master_countries";
			$data["country_list"] = $this->Common_model->get_query_result_array($qSqlCountry);
			
			$qSqlstate="select * from master_states where country_id='$default_country'";
			$data["state_list"] = $this->Common_model->get_query_result_array($qSqlstate);
			
			$qSqlcity="select * from master_cities where state_id IN (SELECT id from master_states WHERE country_id='$default_country')";
			$data["city_list"] = $this->Common_model->get_query_result_array($qSqlcity);
			
			$qStrParam=$_SERVER["QUERY_STRING"];
			$data['qStrParam']=$qStrParam;
            $this->load->view('dashboard',$data);	
		}
    }
	
	public function add_nominee()
	{
		if(check_logged_in()){
			
			$current_user = get_user_id();
			$curDateTime  = CurrMySqlDate();
			
			$prof_fid = trim($this->input->post('prof_fid'));
			$prof_uid = trim($this->input->post('prof_uid'));
			
			$nominee_name = trim($this->input->post('nominee_name'));
			$nominee_relation = trim($this->input->post('nominee_relation'));
			$nominee_state = trim($this->input->post('nominee_state'));
			$nominee_district = trim($this->input->post('nominee_district'));
			$nominee_address = trim($this->input->post('nominee_address'));
			$nominee_pincode = trim($this->input->post('nominee_pincode'));
			
			$family_relation_other = trim($this->input->post('n_other_relation'));
			
			if($nominee_relation == "Others"){ $nominee_relation = $family_relation_other; }
			
			$dob = "";
			
			if(($nominee_name!="") && ($nominee_relation!="") && ($nominee_state!="") && ($nominee_district!="") && ($nominee_address!="") && ($nominee_pincode!="")){				
				$log=get_logs();
				$field_array = array(
					"user_id" => $prof_uid,
					"name" => $nominee_name,
					"relation" => $nominee_relation,
					"dateofbirth" => $dob,
					"address" => $nominee_address,
					"state" => $nominee_state,
					"district" => $nominee_district,
					"pin" => $nominee_pincode,
					"added_by" => $current_user,
					"added_date" => $curDateTime,
					"log" => $log
				);
				$rowid= data_inserter('info_nominee',$field_array);
				$ans="done";
			}else{
				$ans="error";
			}	
			//echo $ans;
			redirect('profile/nominee/'.$prof_fid);
		}	
	}
	
	public function edit_nominee()
	{
		if(check_logged_in()){
			
			$current_user = get_user_id();
			$curDateTime  = CurrMySqlDate();
			
			$prof_fid = trim($this->input->post('prof_fid'));
			$did = trim($this->input->post('did'));
			$e_user_id = trim($this->input->post('e_userid'));
	
			$nominee_name = trim($this->input->post('nominee_name'));
			$nominee_relation = trim($this->input->post('nominee_relation'));
			$nominee_state = trim($this->input->post('nominee_state'));
			$nominee_district = trim($this->input->post('nominee_district'));
			$nominee_address = trim($this->input->post('nominee_address'));
			$nominee_pincode = trim($this->input->post('nominee_pincode'));
			
			//$get_country = "SELECT country_id as value from master_states WHERE name = '$nominee_state'";
			//$data['country_id_get'] = $this->Common_model->get_single_value($get_country);
			
			$nominee_relation_other = trim($this->input->post('e_nother_relation'));
			if($nominee_relation == "Others"){ $nominee_relation = $nominee_relation_other; }
			
			$dob = "";
			
			if($did!=""){
				$log=get_logs();
				$field_array = array(
				    "user_id" => $e_user_id,
					"name" => $nominee_name,
					"relation" => $nominee_relation,
					"dateofbirth" => $dob,
					"address" => $nominee_address,
					"state" => $nominee_state,
					"district" => $nominee_district,
					"pin" => $nominee_pincode,
					"added_by" => $current_user,
					"added_date" => $curDateTime,
					"log" => $log
				);
				$this->db->where('id', $did);
				$this->db->update('info_nominee', $field_array);
				$ans="Done";
			}else{
				$ans="error";
			}	
			//echo $ans;	
			redirect('profile/nominee/'.$prof_fid);
		}	
	}
	
	public function delete_nominee()
	{
		if(check_logged_in()){
			
			$did = $this->uri->segment(3);
			$profileid = "SELECT fusion_id as value from signin WHERE id IN (SELECT user_id from info_nominee WHERE id = '$did')";
			$prof_fid = $this->Common_model->get_single_value($profileid);
			
			if($prof_fid != ""){
				$sqld = "DELETE from info_nominee WHERE id = '$did'";
				$queryd = $this->db->query($sqld);
			}
			
			redirect('profile/nominee/'.$prof_fid);
		}
	}

	public function get_ncity()
    {
        if(check_logged_in()){
			
			$staten = trim($this->input->post('stateid'));
			
			$qSqlcity="select * from master_states where name = '$staten'";
			$statelist = $this->Common_model->get_query_result_array($qSqlcity);
			foreach($statelist as $token)
			{
				$stateid = $token['id'];
			}
			
			$qSqlcity="select * from master_cities where state_id = '$stateid'";
			$data["city_list"] = $this->Common_model->get_query_result_array($qSqlcity);
			
			echo '<option>--- Select District ----</option>';
			foreach($data["city_list"] as $token)
			{
				echo '<option>'.$token['name'] .'</option>';
			}
		}
    }
	
	
	public function get_nstate()
    {
        if(check_logged_in()){
			
			$countryid = trim($this->input->post('countryid'));
						
			$qSqlcity="select * from master_states where country_id = '$countryid'";
			$data["state_list"] = $this->Common_model->get_query_result_array($qSqlcity);
			
			echo '<option>--- Select State ----</option>';
			foreach($data["state_list"] as $token)
			{
				echo '<option>'.$token['name'] .'</option>';
			}
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
				if(is_view_profile($prof_fid)==false) redirect(base_url()."profile","refresh");
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
			$work_exp_year = trim($this->input->post('work_exp_year'));
			$work_exp_months = trim($this->input->post('work_exp_months'));
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
					"work_exp_year" => $work_exp_year,
					"work_exp_months" => $work_exp_months,
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
			$work_exp_year = trim($this->input->post('work_exp_year'));
			$work_exp_months = trim($this->input->post('work_exp_months'));
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
					"work_exp_year" => $work_exp_year,
					"work_exp_months" => $work_exp_months,
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
	
	public function delete_experience()
	{
		if(check_logged_in()){
			
			$did = $this->uri->segment(3);
			$profileid = "SELECT fusion_id as value from signin WHERE id IN (SELECT user_id from info_experience WHERE id = '$did')";
			$prof_fid = $this->Common_model->get_single_value($profileid);
			
			if($prof_fid != ""){
				$sqld = "DELETE from info_experience WHERE id = '$did'";
				$queryd = $this->db->query($sqld);
			}
			
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
				if(is_view_profile($prof_fid)==false) redirect(base_url()."profile","refresh");
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
				if(is_view_profile($prof_fid)==false) redirect(base_url()."profile","refresh");
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
				$rowid= data_inserter('info_passport',$field_array);
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
				$this->db->where('id', $did);
				$this->db->update('info_passport', $field_array);
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
				if(is_view_profile($prof_fid)==false) redirect(base_url()."profile","refresh");
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
				if(is_view_profile($prof_fid)==false) redirect(base_url()."profile","refresh");
				$prof_uid=$this->Common_model->get_single_value("Select id as value from signin where fusion_id='$prof_fid'");
			}
			
			$data['prof_fid']=$prof_fid;
			$data['prof_uid']=$prof_uid;
			
			$data['prof_pic_url']=$this->Profile_model->get_profile_pic($prof_fid);
			$data['prof_widget_left']=$this->Profile_model->get_profile_widget($prof_fid,"left");
			$data['prof_widget']=$this->Profile_model->get_profile_widget($prof_fid,"");
						
			$data["main_info"] = $this->Profile_model->get_main_info($prof_fid);
	
			$data["aside_template"] = "profile/aside.php";
			$data["content_template"] = "profile/bank.php";
			
			$qSql="select * from info_bank where user_id='$prof_uid'";
			$data["bank_info"] = $this->Common_model->get_query_result_array($qSql);
						
			$qStrParam=$_SERVER["QUERY_STRING"];
			$data['qStrParam']=$qStrParam;
            $this->load->view('dashboard',$data);
		}
    }
	
	public function add_bank(){
		if(check_logged_in()){
			
			$current_user = get_user_id();
							
			$prof_fid = trim($this->input->post('prof_fid'));
			$prof_uid = trim($this->input->post('prof_uid'));
			
			$bank_name = trim($this->input->post('bank_name'));
			$branch = trim($this->input->post('branch'));
			$acc_no = trim($this->input->post('acc_no'));
			$acc_type = trim($this->input->post('acc_type'));
			$ifsc_code = trim($this->input->post('ifsc_code'));
			
			$is_accept = trim($this->input->post('is_accept'));
			//$is_accept = 1;
			
			$evt_date=CurrMySqlDate();
			
			$log=get_logs();
			
			if($prof_fid == "") $prof_fid = get_user_fusion_id();
			if($prof_uid == "") $prof_uid = $current_user;
			
			if($prof_fid!=""){
				$field_array = array(
					"user_id" => $prof_uid,
					"bank_name" => $bank_name,
					"branch" => $branch,
					"acc_no" => $acc_no,
					"acc_type" => $acc_type,
					"ifsc_code" => $ifsc_code,
					"is_accept" => $is_accept,
					"accepted_time" => $evt_date,
					"log" => $log
				);
				
				$rowid= data_inserter('info_bank',$field_array);
				$ans="done";
				
			}else{
				$ans="error";
			}
			
			//echo $ans;
			//redirect('profile/bank/'.$prof_fid);
			
			$referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'profile/bank/'.$prof_fid;
			redirect($referer);
			
			
		}
	}	
	
	public function bankInfoAccept(){
		if(check_logged_in()){
			
			$current_user = get_user_id();
			
			$id = trim($this->input->post('id'));
			$user_id = trim($this->input->post('user_id'));
			
			if($current_user == $user_id){
				
				$is_accept = 1;
				$evt_date=CurrMySqlDate();
				
				$field_array = array(
					"is_accept" => $is_accept,
					"accepted_time" => $evt_date,
				);
				$this->db->where('id', $id);
				$this->db->update('info_bank', $field_array);
				
			}
			
			$referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'home';
			redirect($referer);
			
		}
	}
	
	public function bankUploadInfoAccept(){
		if(check_logged_in()){
			$current_user = get_user_id();
			$a = array();
			
			$prof_fid=$this->Common_model->get_single_value("Select fusion_id as value from signin where id='$current_user'");
			
			$id = trim($this->input->post('id'));
			$uid = trim($this->input->post('uid'));
			
			//echo "<pre>".print_r($_POST,1)."</pre>";
			//echo "<pre>".print_r($_FILES,1)."</pre>";
			//die();
			if($_FILES['upl_bank_info']['size'][0] <= 204800){
			
			if($current_user == $uid){
				$BaseRealPath = $this->config->item('BaseRealPath');
				$destination_path = $BaseRealPath.'/uploads/bank_upload';
				
				$field_array = array( 
					"is_acpt_document" => trim($this->input->post('is_acpt_document'))
				);
				
				$a = $this->prof_upload_files($_FILES['upl_bank_info'],$prof_fid,$destination_path);
				$field_array["upl_bank_info"] = implode(',',$a);
				
				$this->db->where('user_id', $uid);
				$this->db->update('info_bank', $field_array);
			}
			$referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'home';
			$url = $referer;
			$pos = strpos($referer, "?");
			if(!empty($pos)){ $url = substr($referer, 0, $pos); }
			redirect($url);
			
			} else {
				$referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'home';
				$url = $referer;
				$pos = strpos($referer, "?");
				if(!empty($pos)){ $url = substr($referer, 0, $pos); }
				
				redirect($url.'?errorupload=1');
			}
		
			$data["array"] = $a;
		}
	}
	
	
	public function adhaarUploadDoc(){
		if(check_logged_in()){
			$current_user = get_user_id();
			$a = array();
			
			$prof_fid=$this->Common_model->get_single_value("Select fusion_id as value from signin where id='$current_user'");
			$uid = trim($this->input->post('uid'));
						
			if($current_user == $uid){
				$destination_path = $this->config->item('profileUploadPath');
				
				$data_array = array( 
					"user_id" => $uid,
					"entry_by" => $uid,
					"entry_date" => CurrMySqlDate(),
					"log" => get_logs()
				);
				
				$a = $this->prof_upload_files($_FILES['upl_adhaar_info'],$prof_fid,$destination_path);
				$field_array["aadhar_doc"] = implode(',',$a);
				$data_array["aadhar_doc"] = implode(',',$a);
				
				$sqlcheckFile = "SELECT count(*) as value from info_document_upload WHERE user_id = '$uid'";
				$checkedFile = $this->Common_model->get_single_value($sqlcheckFile);
				if($checkedFile < 1)
				{
					data_inserter('info_document_upload', $data_array);
				} else {
					$this->db->where('user_id', $uid);
					$this->db->update('info_document_upload', $field_array);
				}
				
			}
			$referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'home';
			redirect($referer);
		
			$data["array"] = $a;
		}
	}
	
	
	
	public function payVarify(){
		if(check_logged_in()){
			
			$current_user = get_user_id();
			
			$id = trim($this->input->post('id'));
			$user_id = trim($this->input->post('user_id'));
			$pay_varify = trim($this->input->post('pay_varify'));
			if($pay_varify == "") $pay_varify = "X";
			
			if($current_user == $user_id){
				
				$evt_date=CurrMySqlDate();
				
				$field_array = array(
					"pay_varify" => $pay_varify,
					"pay_varify_time" => $evt_date,
				);
				
				$this->db->where('id', $id);
				$this->db->update('info_bank', $field_array);
				
			}
			
			$referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'home';
			//redirect($referer);
			
		}
	}
	
	public function edit_bank(){
		if(check_logged_in()){
			
			$current_user = get_user_id();
			
			$prof_fid = trim($this->input->post('prof_fid'));
			$did = trim($this->input->post('did'));
			$bank_name = trim($this->input->post('bank_name'));
			$branch = trim($this->input->post('branch'));
			$acc_no = trim($this->input->post('acc_no'));
			$acc_type = trim($this->input->post('acc_type'));
			$ifsc_code = trim($this->input->post('ifsc_code'));
			
			if($prof_fid == "") $prof_fid = get_user_fusion_id();
						
			$log=get_logs();
			
			if($did!=""){
				$field_array = array(
					"bank_name" => $bank_name,
					"branch" => $branch,
					"acc_no" => $acc_no,
					"acc_type" => $acc_type,
					"ifsc_code" => $ifsc_code,
					"log" => $log
				);
				$this->db->where('id', $did);
				$this->db->update('info_bank', $field_array);
				$ans="Done";
			}else{
				$ans="error";
			}	
			
			echo $ans;
			
			//redirect('profile/bank/'.$prof_fid);
			
			$referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'profile/bank/'.$prof_fid;
			redirect($referer);
			
		}	
	}
	
	
	
////////////////////////////////Files Uploaded Part/////////////////////////////////
	public function profileDocument(){
		if(check_logged_in()){
			$_SESSION['pmenu'] = "12";
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
				if(is_view_profile($prof_fid)==false) redirect(base_url()."profile","refresh");
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
			// var_dump($qSql);
			$data['bank_list'] = $processArray = $this->Common_model->get_query_result_array($qSql);
			// print_r($data['bank_list']);
			
			$qSql= 'SELECT * FROM `info_passport` where user_id="'.$prof_uid.'"';
			$data['passport_list'] = $processArray = $this->Common_model->get_query_result_array($qSql);
			
			
			$qSql= 'SELECT * FROM `info_education` where user_id="'.$prof_uid.'"';
			$data['education_list'] = $processArray = $this->Common_model->get_query_result_array($qSql);
			
			$qSql= 'SELECT * FROM `info_others_doc` where user_id="'.$prof_uid.'"';
			$data['other_list'] = $processArray = $this->Common_model->get_query_result_array($qSql);
			
		////////////////	
			$qSql= 'SELECT * FROM `info_personal` where user_id="'.$prof_uid.'"';
			$data['info_personal_list'] = $processArray = $this->Common_model->get_query_row_array($qSql);
			
			$qSql= 'SELECT * FROM `info_document_upload` where user_id="'.$prof_uid.'"';
			$data['docu_upload_list'] = $processArray = $this->Common_model->get_query_row_array($qSql);
			
			$data['others_uid'] = $this->Common_model->get_single_value("Select office_id as value from signin where id='$prof_uid'");
		////////////////
			
			$qStrParam=$_SERVER["QUERY_STRING"];
			$data['qStrParam']=$qStrParam;
			$this->load->view('dashboard',$data);
		}
	}
	
//////////////////////////////////////
	public function document_upload(){
		if(check_logged_in()){
			$prof_fid=$this->uri->segment(3);
			$current_user = get_user_id();
			$a = array();
			$user_id = $this->input->post('user_id');
			$oth_uid = $this->input->post('oth_uid');
			
			$others_uid = $this->Common_model->get_single_value("Select office_id as value from signin where id='$oth_uid'");
			$others_fid = $this->Common_model->get_single_value("Select fusion_id as value from signin where id='$oth_uid'");
			
			if($user_id==$oth_uid){
				$uid = $current_user;
				$prof_fid=get_user_fusion_id();
				$user_office = get_user_office_id();
			}else{
				$uid = $oth_uid;
				$prof_fid=$others_fid;
				$user_office = $others_uid;
			}
			
			$destination_path = $this->config->item('profileUploadPath');
			
			if($uid!=''){
				
				$profileUpload_array = array(
					"user_id" => $uid,
					"entry_by" => $current_user,
					"entry_date" => CurrMySqlDate()
				);
				
				if($user_office=='JAM'){
					$uploadProfileArr = array('pan_doc','nis_doc','birth_certi_doc','marrige_certi_doc');
				}else if(isIndiaLocation($user_office) ==true){
					$uploadProfileArr = array('pan_doc','aadhar_doc','photograph','covid19declare_doc');
				}else if($user_office=='ELS'){
					$uploadProfileArr = array('resume_doc','nit_doc','isss_doc','afp_info_doc','background_local_doc');
				}else if($user_office=='CEB' || $user_office=='MAN'){
					$uploadProfileArr = array('sss_no_doc','tin_no_doc','philhealth_no_doc','dependent_birth_certi_doc','bir_2316_doc','nbi_clearance_doc','birth_certi_doc','marrige_certi_doc');
				}
				
				foreach($uploadProfileArr as $value){
					$a = $this->prof_upload_files($_FILES[$value],$prof_fid,$destination_path);
					$profileUpload_array[$value] = implode(',',$a);
				}
				
				$rowid= data_inserter('info_document_upload',$profileUpload_array);
				
				$referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'profile/profileDocument/'.$prof_fid;
				redirect($referer);
			}
			$data["array"] = $a;
			
		}
	}
	
	public function document_edit_upload(){
		if(check_logged_in()){
			$prof_fid=$this->uri->segment(3);
			$current_user = get_user_id();
			$a = array();
			$user_id = $this->input->post('user_id');
			$oth_uid = $this->input->post('oth_uid');
			
			$others_uid = $this->Common_model->get_single_value("Select office_id as value from signin where id='$oth_uid'");
			$others_fid = $this->Common_model->get_single_value("Select fusion_id as value from signin where id='$oth_uid'");
			
			if($user_id==$oth_uid){
				$uid = $current_user;
				$prof_fid=get_user_fusion_id();
				$user_office = get_user_office_id();
			}else{
				$uid = $oth_uid;
				$prof_fid=$others_fid;
				$user_office = $others_uid;
			}
			
			if($uid!=''){
				
				if($user_office=='JAM'){
					$uploadProfileArr = array('pan_doc','nis_doc','birth_certi_doc','marrige_certi_doc');
				}else if(isIndiaLocation($user_office) ==true){
					$uploadProfileArr = array('pan_doc','aadhar_doc','aadhar_doc_back','photograph','covid19declare_doc');
				}else if($user_office=='ELS'){
					$uploadProfileArr = array('resume_doc','nit_doc','isss_doc','afp_info_doc','background_local_doc');
				}else if($user_office=='CEB' || $user_office=='MAN'){
					$uploadProfileArr = array('sss_no_doc','tin_no_doc','philhealth_no_doc','dependent_birth_certi_doc','bir_2316_doc','nbi_clearance_doc','birth_certi_doc','marrige_certi_doc');
				}
				
				foreach($uploadProfileArr as $value){
					if($_FILES[$value]['tmp_name'][0]!='') {
						$valuesss = explode(",",$this->input->post($value));
						$destination_path = $this->config->item('profileUploadPath');
						foreach($valuesss as $rp){
							unlink($destination_path.'/'.$prof_fid.'/'.$rp);
						}
						$a = $this->prof_upload_files($_FILES[$value],$prof_fid,$destination_path);
						$editUpload_attay[$value] = implode(',',$a);
						
						$this->db->where('user_id', $uid);
						$this->db->update('info_document_upload', $editUpload_attay);
					}
				}
				$referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'profile/profileDocument/'.$prof_fid;
				redirect($referer);
			}
			$data["array"] = $a;
			
		}
	}
	
	//======================== MULTIPLE PAGE MANDATORY DOCUMENT VARIANTS =========================================//
	
	public function multiple_document_page_upload()
	{
		if(check_logged_in()){
			
			$this->load->library('m_pdf');
			
			$prof_fid = $this->uri->segment(3);
			$current_user = get_user_id();
			
			$user_id = $this->input->post('user_id');
			$oth_uid = $this->input->post('oth_id');
			
			$others_uid = $this->Common_model->get_single_value("Select office_id as value from signin where id='$oth_uid'");
			$others_fid = $this->Common_model->get_single_value("Select fusion_id as value from signin where id='$oth_uid'");
			
			if($user_id==$oth_uid){
				$uid = $current_user;
				$prof_fid=get_user_fusion_id();
				$user_office = get_user_office_id();
			}else{
				$uid = $oth_uid;
				$prof_fid=$others_fid;
				$user_office = $others_uid;
			}
			
			$flag = "success";
			if($uid!='' && $prof_fid != ""){
				
			$destination_path = $this->config->item('profileUploadPath');	
			$user_folder = $destination_path ."/" .$prof_fid ."/";
			
			if (!is_dir($user_folder)) {
				mkdir($user_folder, 0777, true);
			}
			
			$uploadCheck = true;
			$upload_type = $this->input->post('upload_type');
			$upload_max = $this->input->post('upload_max');
			if($upload_type == 1 || $upload_type == 2  || $upload_type == 4)
			{
				
				$c_file = $_FILES['c_file_multi'];
				
				$prefix = "mandoc_";
				if($upload_type == 1){ $prefix = "offer_"; $_column = "offer_letter"; }
				if($upload_type == 2){ $prefix = "contract_"; $_column = "employment_contract"; }
				if($upload_type == 4){ $prefix = "cv_"; $_column = "updated_cv"; }
				
				// COUNT FILES
				$u_total_file = count($c_file['name']);
				if($u_total_file <= $upload_max)
				{
					// CHECK EXTENSIONS
					$currentEXT = ""; $pdfCount = 0; $imgCount = 0;
					foreach($c_file['name'] as $token)
					{
						$fileEXT = pathinfo($token, PATHINFO_EXTENSION);
						if($fileEXT == 'pdf')
						{
							$pdfCount++;
						}
						if($fileEXT == 'jpeg' || $fileEXT == 'jpg'  || $fileEXT == 'png')
						{
							$imgCount++;
						}
						if($currentEXT != "" && $currentEXT != $fileEXT)
						{
							$flag = "extError";
							$uploadCheck = false;
						}
						$currentEXT = $fileEXT;
					}
					echo $currentEXT;
					if($pdfCount > 1 && $uploadCheck == true){ $flag = "pdfCountError"; $uploadCheck = false; }
					if($pdfCount == 0){
						if($imgCount > $upload_max && $uploadCheck == true){ $flag = "imgCountError"; $uploadCheck = false; }					
						if($imgCount < $upload_max && $uploadCheck == true){ $flag = "imgCountError"; $uploadCheck = false; }
					}
					
					if($uploadCheck == true)
					{						
						// FOR PDF
						if($currentEXT == 'pdf')
						{
							$sn = 0;
							foreach($c_file['name'] as $token)
							{
								$currentTemp = $c_file['tmp_name'][$sn];
								$currentFile = $c_file['name'][$sn];
								
								//$uploadDir = FCPATH .'uploads/multiple_doc_temp/';
								//$currUploadFile = $uploadDir .$currentFile;
								//move_uploaded_file($currentTemp, $currUploadFile);
								
								$finalFile = $prefix.$currentFile; 
								move_uploaded_file($currentTemp, $user_folder .$finalFile);							
								$sn++;								
							}							
						}
						
						// FOR IMAGES
						if($currentEXT == 'jpeg' || $currentEXT == 'jpg'  || $currentEXT == 'png')
						{
							$sn = 0; $imgArr = array();
							foreach($c_file['name'] as $token)
							{
								$currentTemp = $c_file['tmp_name'][$sn];
								$currentFile = $c_file['name'][$sn];								
								$uploadDir = FCPATH .'uploads/multiple_doc_temp/';
								$currUploadFile = $uploadDir .$currentFile;
								move_uploaded_file($currentTemp, $uploadDir .$currentFile);
								$sn++;								
								$imgArr[] = $currUploadFile;								
							}
							
							$pdf = new m_pdf();
							foreach($imgArr as $tokenFile)
							{						
								$pdf->pdf->AddPage();
								$html='<img src="'.$tokenFile.'"/>';		
								$pdf->pdf->WriteHTML($html);							
							}
							
							$finalFile = $prefix. mt_rand(11,99) ."_record.pdf"; 
							$finalDir = $user_folder.$finalFile;
							$pdf->pdf->Output($finalDir, 'F');
							
						}
					}
				} else {
					$flag = "fileError";
					$uploadCheck = false;
				}			
				
				//echo "<pre>" .print_r($c_file, 1) ."</pre>"; die();
				
			}
			
			if($upload_type == 3)
			{				
				$prefix = "sketch_"; 
				$_column = "profile_sketch";
				$c_file = $_FILES['c_file'];				
				$currentTemp = $c_file['tmp_name'];
				$currentFile = $c_file['name'];
				$finalFile = "sketch_" .$currentFile;
				move_uploaded_file($currentTemp, $user_folder.$finalFile);				
			}
			
			if($uploadCheck == true)
			{
				$sqlCheck = "SELECT count(*) as value from info_document_upload WHERE user_id = '$uid'";
				$checkExist = $this->Common_model->get_single_value($sqlCheck);				
				if($checkExist > 0){ 
					$dataArray = [ $_column => $finalFile ];
					$this->db->where('user_id', $uid);
					$this->db->update('info_document_upload', $dataArray);
				} else {
					$dataArray = [ $_column => $finalFile, 'user_id' => $uid, 'entry_by' => $current_user, 'entry_date' => CurrMySqlDate(), 'log' => get_logs() ];
					data_inserter('info_document_upload', $dataArray);
				}
				
				$referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'profile/profileDocument/'.$prof_fid;
				$moveReferer = $referer ."/" .$flag;
				redirect($moveReferer);
				
			} else {				
				//if($flag == 'extError'){ }
				//if($flag == 'pdfCountError'){ }
				//if($flag == 'imgCountError'){ }
				//if($flag == 'fileError'){ }
				$referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'profile/profileDocument/'.$prof_fid;
				$moveReferer = $referer ."/" .$flag;
				redirect($moveReferer);
			}		
			
			} else {
				
				$flag = "invalid";
				$referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'profile/profileDocument/'.$prof_fid;
				$moveReferer = $referer ."/" .$flag;
				redirect($moveReferer);
				
			}
			
		}
	}
	
	public function public_view_files(){
		if(check_logged_in())
		{
			$current_user = get_user_id();
			$get_fusion_id = get_user_fusion_id();
			
			$uid = $this->uri->segment(3);
			$file_name = $this->uri->segment(4);
			$file_id = base64_decode(urldecode($file_name));
			
			if($uid != "" || get_global_access()=='1'){
				
				$file = $this->config->item('profileUploadPath')."/".$uid."/".$file_id;
			 
				if(file_exists($file) && ($view != true || $view =='')) {					
					 $ext = pathinfo($file, PATHINFO_EXTENSION);					 
					 if($ext == "jpeg" || $ext == "jpg" || $ext == "gif" || $ext == "png")
					 {
						 if($ext == 'jpg'){ $ext = "jpeg"; }
						header("Content-type: image/".$ext); 
						header('Content-Disposition: attachment; filename="'.basename($file).'"');
					    readfile($file);
					 } else {
						header("Content-type: application/".$ext); 
						header('Content-Disposition: attachment; filename="'.basename($file).'"');
					    readfile($file);
					 }					 
					
				}elseif(file_exists($file) && $view == true ) {
						header("Content-type: application/".$ext);
						header('Content-Disposition: inline; filename="'.basename($file).'"');
						@readfile($file);
				}
					
			}else{
				echo "You are not authorised to View";
			}
		}
	}
	
	//======================== END ----- MULTIPLE PAGE MANDATORY DOCUMENT VARIANTS ----- END =========================================//


	private function prof_upload_files($files,$prof_fid,$destination_path){
		//$destination_path = $this->config->item('profileUploadPath');
		
		if (!is_dir($destination_path.'/'.$prof_fid)) {
			mkdir($destination_path.'/'.$prof_fid, 0777, true);
		}
		
        $config['upload_path'] = $destination_path.'/'.$prof_fid.'/';
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
	
	
	public function check_view($uid,$file_name,$view=''){
		if(check_logged_in())
		{
			$current_user = get_user_id();
			$get_fusion_id=get_user_fusion_id();
			$file_id = base64_decode(urldecode($file_name));
			
			if($uid == $get_fusion_id || get_global_access()=='1' || is_update_system_data()==true){
				
			$file = $this->config->item('profileUploadPath')."/".$uid."/".$file_id;
			
			$content_type=mime_content_type($file);
			if($content_type=="") $content_type="application/octet-stream";
			
			//echo $content_type;
			
				if(file_exists($file) && ($view != true || $view =='')) {
					
					 $ext = pathinfo($file, PATHINFO_EXTENSION);
						header("Content-type: ".$content_type);
						header('Content-Disposition: attachment; filename="'.basename($file).'"');
						header('Content-Length: ' . filesize($file));
						ob_clean();
						flush();
						@readfile($file);
				}elseif(file_exists($file) && $view == true ) {
						header("Content-type: ". $content_type);
						header('Content-Disposition: inline; filename="'.basename($file).'"');
						header('Content-Length: ' . filesize($file));
						ob_clean();
						flush();
						readfile($file);
				}
					
			}else{
				echo "You are not authorised to View";
			}
		}
	}
	
	public function check_photo($uid,$file_name,$view=''){
		if(check_logged_in())
		{
			$current_user = get_user_id();
			$get_fusion_id=get_user_fusion_id();
			$file_id = base64_decode(urldecode($file_name));
			
			if($uid == $get_fusion_id || get_global_access()=='1' || is_update_system_data()==true){
				// if($uid=='FKOL007054'){
				// 	$file = FCPATH ."/pimgs/".$uid."/".$file_id;
				// }else{

				// 	$file = FCPATH ."/uploads/photo/".$file_id;
				// }
				$file = FCPATH ."/uploads/photo/".$file_id;
				// $file = FCPATH ."/pimgs/".$uid."/".$file_id;
			$content_type=mime_content_type($file);
			if($content_type=="") $content_type="application/octet-stream";
			//echo $content_type;
			$ext = pathinfo($file, PATHINFO_EXTENSION);
			//echo $ext;
				if(file_exists($file) && ($view != true || $view =='')) {
						header("Content-type: ".$content_type);
						header('Content-Disposition: attachment; filename="'.basename($file).'"');
						header('Content-Length: ' . filesize($file));
						ob_clean();
						flush();
						@readfile($file);
				}elseif(file_exists($file) && $view == true ) {
					header("Content-type: ". $content_type);
					header('Content-Disposition: inline; filename="'.basename($file).'"');
					header('Content-Length: ' . filesize($file));
					ob_clean();
					flush();
					readfile($file);
				}
					
			}else{
				echo "You are not authorised to View";
			}
		}
	}
	
	
	public function bank_esi_view($uid,$file_name,$view=''){
		if(check_logged_in())
		{
			$current_user = get_user_id();
			$get_fusion_id=get_user_fusion_id();
			
			//$uid = $this->uri->segment(3);
			//$file_name = $this->uri->segment(4);
			
			$file_id = base64_decode(urldecode($file_name));
			
			if($uid == $get_fusion_id || get_global_access()=='1'){
				
				// if($uid=='FKOL007054'){
				// 	$file = FCPATH ."/pimgs/".$uid."/".$file_id;
				// }else{
				// 	$file = FCPATH ."/uploads/bank_upload/".$uid."/".$file_id;
				// }
					$file = FCPATH ."/uploads/bank_upload/".$uid."/".$file_id;
					// 	$file = FCPATH ."/pimgs/".$uid."/".$file_id;
				$content_type=mime_content_type($file);
				if($content_type=="") $content_type="application/octet-stream";

				if(file_exists($file) && ($view != true || $view =='')) {
					
					 $ext = pathinfo($file, PATHINFO_EXTENSION);
						header("Content-type: ".$content_type);
						header('Content-Disposition: attachment; filename="'.basename($file).'"');
						header('Content-Length: ' . filesize($file));
						ob_clean();
						flush();
						@readfile($file);
				}elseif(file_exists($file) && $view == true ) {
						header("Content-type: ".$content_type);
						header('Content-Disposition: inline; filename="'.basename($file).'"');
						header('Content-Length: ' . filesize($file));
						ob_clean();
						flush();
						@readfile($file);
				}
					
			}else{
				echo "You are not authorised to View";
			}
		}
	}
	
	
	
	
/////////////////////////////////////	
	
	public function upload(){
        if(check_logged_in()){
			$user_site_id= get_user_site_id();
			$role_id= get_role_id();
			$current_user = get_user_id();
			$data_type = $this->input->post();
			$prof_fid= trim($this->input->post('prof_fid'));
			if($prof_fid==""){
				$prof_fid=get_user_fusion_id();
				$prof_uid=$current_user;
			}else{
				$prof_uid=$this->Common_model->get_single_value("Select id as value from signin where fusion_id='$prof_fid'");
			}
			$data['prof_fid']=$prof_fid;
			$data['prof_uid']=$prof_uid;
	
			$config['upload_path'] = 'pimgs/'.$prof_fid.'/';
			
			if (!is_dir($config['upload_path']))
			{
				mkdir($config['upload_path'], 0777, TRUE);
			}
			
			$config['allowed_types']        = 'pdf|jpg|png|doc|docx|xls|xlsx';
			///$config['max_size']             = 2048;

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
					$query = $this->db->query('INSERT INTO `info_others_doc`(`user_id`, `info_type`, `info_doc`) VALUES ("'.$prof_uid.'","'.$data_type['info_type'].'","'.$this->upload->data('file_name').'")');
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
					$query = $this->db->query('UPDATE `info_others_doc` SET `info_doc`="'.$this->upload->data('file_name').'" WHERE id="'.$data_type['other_id'].'"');
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
   
   
   ///================================= UPLOAD PHOTOGRAPH ========================================================//
   
   public function photograph()
   {
	    $current_user = get_user_id();
		$user_site_id= get_user_site_id();
		$user_office_id= get_user_office_id();
		$user_oth_office=get_user_oth_office();
		$is_global_access=get_global_access();
		$is_role_dir=get_role_dir();
		$get_dept_id=get_dept_id();
		
		$data['today'] = GetLocalTime();
		
		//IF TABLE NOT AVAILABLE CREATE
		$sqlCheck = "SELECT count(*) as value from info_document_upload WHERE user_id = '$current_user'";
		$counterCheck = $this->Common_model->get_single_value($sqlCheck);
		if($counterCheck < 1){
			$dataCounter = [ 'user_id' => $current_user ];
			data_inserter('info_document_upload', $dataCounter);
		}

		$sqlCheck = "SELECT count(*) as value from info_personal WHERE user_id = '$current_user'";
		$counterCheck = $this->Common_model->get_single_value($sqlCheck);
		if($counterCheck < 1){
			$dataCounter = [ 'user_id' => $current_user ];
			data_inserter('info_personal', $dataCounter);
		}
		
		$fusion_id = "";
		$agent_sql = "SELECT s.*, ip.is_photo, iu.photograph, ip.is_idcard, ip.is_photo_submit, ip.is_photo_uploaded, ip.is_photo_check  from signin as s 
		              LEFT JOIN info_personal as ip ON ip.user_id = s.id 
		              LEFT JOIN info_document_upload as iu ON iu.user_id = s.id 
					  WHERE s.id = '$current_user'";		
					  
		$data['agent_details'] = $agent_details = $this->Common_model->get_query_row_array($agent_sql);
		
		if(!empty($agent_details['fusion_id'])){ $fusion_id = $agent_details['fusion_id']; }
		
		
		$data['prof_pic_url']=$this->Profile_model->get_profile_pic($fusion_id);
		
		$is_photo_check = $agent_details['is_photo_check'];		
		$data['photoQCheck'] = $is_photo_check;
		
		$is_photo = $agent_details['is_photo'];		
		$data['photoUCheck'] = $is_photo;
		
		$is_idcard = $agent_details['is_idcard'];
		$is_photo_submit = $agent_details['is_photo_submit'];
		$is_photo_uploaded = $agent_details['is_photo_uploaded'];		
		
		$uploadChecker = false; $uploadShow = false;
		if($is_idcard == 'Yes'){
			$uploadChecker = true;
			$uploadShow = false;
		} else {
			if($is_photo_submit == 'Yes')
			{
				$uploadChecker = true;
				$uploadShow = false;
			} else {
				if($is_photo_uploaded == 'Yes'){
					$uploadChecker = true;
					$uploadShow = false;
				} else {
					$uploadShow = true;
				}
			}
		}
		$data['uploadChecker'] = $uploadChecker;
		$data['photoShow'] = $uploadShow;
		
		
		
		$currentImage = "";
		$idFolder = FCPATH ."uploads/photo/";
		//$agentCard = $agent_details['fname'] ."_" .$agent_details['lname'] ."_".$agent_details['fusion_id'].".png";
		/*if(file_exists($idFolder .$agentCard))
		{
			$currentImage = base_url() ."uploads/photo/".$agentCard;
		}*/
		
		if(!empty($agent_details['photograph'])){
			if(file_exists($idFolder .$agent_details['photograph']))
			{
				$currentImage = base_url() ."uploads/photo/".$agent_details['photograph'];
			}
		}
		$data['id_card'] = $currentImage;
		
		// CHECK SKIP
		$skipUploadPhoto = $this->session->userdata('skipUploadPhotograph');
		if(($agent_details['is_photo'] == 1)  || $skipUploadPhoto == 'Y')
		{
			//redirect(base_url('home')); 
		}
						
		$data["content_template"] = "profile/upload_photograph.php";
		$data["content_js"] = "profile/upload_photo_js.php";
		
		$this->load->view('dashboard_single_col',$data);
	 
   }
   
    function imageCropping()
	{	
		$data = $_POST['image'];		
		$fusion_id = $this->input->post('fusionid');
		
		list($type, $data) = explode(';', $data);
		list(, $data) = explode(',', $data);
		$data = base64_decode($data);
		
		$agent_sql = "SELECT * from signin WHERE fusion_id = '$fusion_id'";		
		$agent_details = $this->Common_model->get_query_row_array($agent_sql);
		$user_id = $agent_details['id'];
		
		//$imageName = "id_" .$fusion_id ."_" .time().'.png';
		//$imageName = "id_" .$fusion_id.'.png';
		$imageName = $agent_details['fname'] ."_" .$agent_details['lname'] ."_".$agent_details['fusion_id'].".png";
		
		$idFolder = FCPATH ."uploads/photo/";
		$idDir = $idFolder;
		if(!file_exists($idDir)){ mkdir($idDir, 0777, true); }
		$uploadDir = $idDir ."/" .$imageName;
		
		// UPDATE PHOTO
		$dataUpdate = [ 'photograph' => $imageName];
		$this->db->where('user_id', $user_id);
		$this->db->update('info_document_upload', $dataUpdate);
		
		$dataUpdate = [ 'is_photo' => 1, 'is_photo_check' => 2 ];
		$this->db->where('user_id', $user_id);
		$this->db->update('info_personal', $dataUpdate);
		
		file_put_contents($uploadDir, $data);
	}
	
	function phototographCheckSubmission()
	{		
		$f_uid = $this->input->post('agent_uid');
		$f_fusion_id = $this->input->post('agent_profile');
		
		$q1 = $this->input->post('fusion_is_idcard');
		$q2 = $this->input->post('fusion_is_submitted');
		$q3 = $this->input->post('fusion_is_uploaded');
		
		if(empty($q1)){ $q1 = NULL; }	
		if(empty($q2)){ $q2 = NULL; }	
		if(empty($q3)){ $q3 = NULL; }
		
		$dataUpdate = [ 
			'is_idcard' => $q1,
			'is_photo_submit' => $q2,
			'is_photo_uploaded' => $q3,			
			'is_photo_check' => 1,			
		];
		$this->db->where('user_id', $f_uid);
		$this->db->update('info_personal', $dataUpdate);
		
		redirect('home');
	}
	
	function skipPhotoUpload()
	{
		$current_user = get_user_id();
		$dataUpdate = [ 'is_photo' => 2 ];
		$this->db->where('user_id', $current_user);
		$this->db->update('info_personal', $dataUpdate);
		$this->session->set_userdata('skipUploadPhotograph', 'Y');
		sleep(1);
		redirect('home',"refresh");
				
	}
	
	function ReceivedPhototograph()
	{		
		$current_user = get_user_id();
		$user_site_id= get_user_site_id();
		$user_office_id= get_user_office_id();
		$user_oth_office=get_user_oth_office();
		$is_global_access=get_global_access();
		$is_role_dir=get_role_dir();
		$get_dept_id=get_dept_id();
		
		$fusion_id=get_user_fusion_id();
		
		$data['today'] = GetLocalTime();
		
		$agent_sql = "SELECT s.*, ip.is_photo, iu.photograph, ip.is_idcard, ip.is_photo_submit, ip.is_photo_uploaded, ip.is_photo_check  from signin as s 
		              LEFT JOIN info_personal as ip ON ip.user_id = s.id 
		              LEFT JOIN info_document_upload as iu ON iu.user_id = s.id 
					  WHERE s.id = '$current_user'";		
					  
		$data['agent_details'] = $agent_details = $this->Common_model->get_query_row_array($agent_sql);
		
		$data['prof_pic_url']=$this->Profile_model->get_profile_pic($fusion_id);
		
		$data["content_template"] = "profile/received_photograph.php";
		//$data["content_js"] = "profile/upload_photo_js.php";
		
		$this->load->view('dashboard_single_col',$data);
	}
	
	
	function ReceivedPhototographSubmit()
	{		
		$current_user = get_user_id();		
		$q1 = $this->input->post('fusion_is_idcard');
				
		if(empty($q1)){ $q1 = NULL; }
		
		$dataUpdate = [ 
			'is_idcard' => $q1		
		];
		
		$this->db->where('user_id', $current_user);
		$this->db->update('info_personal', $dataUpdate);
		redirect('home');
	}


	// public function add_master_lang(){
	// 	$lang = array('Afrikaans','Albanian','Arabic','Armenian','Basque','Bengali','Bulgarian','Catalan','Cambodian', 'Chinese (Mandarin)', 'Croatian', 'Czech', 'Danish', 'Dutch', 'English', 'Estonian', 'Fiji', 'Finnish', 'French', 'Georgian', 'German', 'Greek', 'Gujarati', 'Hebrew', 'Hindi', 'Hungarian', 'Icelandic', 'Indonesian', 'Irish', 'Italian', 'Japanese', 'Javanese', 'Korean', 'Latin', 'Latvian', 'Lithuanian', 'Macedonian', 'Malay', 'Malayalam', 'Maltese', 'Maori', 'Marathi', 'Mongolian', 'Nepali', 'Norwegian', 'Persian', 'Polish', 'Portuguese', 'Punjabi', 'Quechua', 'Romanian', 'Russian', 'Samoan', 'Serbian', 'Slovak', 'Slovenian', 'Spanish', 'Swahili', 'Swedish', 'Tamil', 'Tatar', 'Telugu', 'Thai', 'Tibetan', 'Tonga', 'Turkish', 'Ukrainian', 'Urdu', 'Uzbek', 'Vietnamese', 'Welsh', 'Xhosa' 
	// 	);

	// 	foreach ($lang as $key => $value) {
	// 		$this->db->set('name',$value);
	// 		$this->db->set('is_active',1);
	// 		$this->db->insert('master_language');
	// 	}


	// }
	
	
}
?>