<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {
    
    /////////////////////////////////////////////////////////////////////////////////////////////
    // INDEX PAGE
    /////////////////////////////////////////////////////////////////////////////////////////////
    
	 function __construct() {
		parent::__construct();
		
		$this->load->model('Common_model');
		$this->load->model('Client_model');
		$this->load->model('user_model');
		$this->load->library("pagination");
		$this->load->model('Email_model');
		
	 }
	 
    public function index()
    {
        if(check_logged_in()){
		
			$this->check_access();
			
			
			$user_site_id= get_user_site_id();
			$role_id= get_role_id();
			
			$user_office_id=get_user_office_id();
			$ses_dept_id=get_dept_id();
						
			$is_global_access=get_global_access();
			$current_user = get_user_id();
			$ses_process_ids=get_process_ids();
			$user_oth_office=get_user_oth_office();
			
			$data["download_link"] = ""; ///////////////////
			$action="";					 // CSV Report
			$dn_link="";				 ///////////////////
			
			$data["aside_template"] = get_aside_template();
			//$data["aside_template"] = "user/aside.php";
			
			$data["content_template"] = "user/manage_users.php";
			$data["error"] = ''; 
			
			$dValue = trim($this->input->post('dept_id'));
			if($dValue=="") $dValue = trim($this->input->get('dept_id'));
			
			$sdValue = trim($this->input->post('sub_dept_id'));
			if($sdValue=="") $sdValue = trim($this->input->get('sub_dept_id'));
			
			$cValue = trim($this->input->post('client_id'));
			if($cValue=="") $cValue = trim($this->input->get('client_id'));
			
			/* $sValue = trim($this->input->post('site_id'));
			if($sValue=="") $sValue = trim($this->input->get('site_id')); */
									
			$oValue = trim($this->input->post('office_id'));
			if($oValue=="") $oValue = trim($this->input->get('office_id'));
			
			$pValue = trim($this->input->post('process_id'));
			if($pValue=="") $pValue = trim($this->input->get('process_id'));
			
			$spValue = trim($this->input->post('sub_process_id'));
			if($spValue=="") $spValue = trim($this->input->get('sub_process_id'));
			
			$rValue = trim($this->input->post('role_id'));
			if($rValue=="") $rValue = trim($this->input->get('role_id'));
			
			$fusionid = trim($this->input->post('fusionid'));
			if($fusionid=="") $fusionid = trim($this->input->get('fusionid'));
			
			$status = trim($this->input->post('status'));
			if($status=="") $status = trim($this->input->get('status'));
			if($status=="") $status=1;
			
			if($dValue=="") $dValue=$ses_dept_id;			
						
			if($oValue=="") $oValue=$user_office_id;

			if($is_global_access!=1){
				if($oValue=="") $oValue=$user_office_id;
			}
			
			
			if($is_global_access!=1 && is_all_dept_access()==false){
				
				if(get_dept_folder()=="mis" && $dValue!=6 && $dValue!=7)$dValue=$ses_dept_id;
				if(get_dept_folder()=="transition" && $dValue!=6 && $dValue!=7)$dValue=$ses_dept_id;
				
			}
			
			if($status==1) $_filterCond=" role_id > 0 and status in (1,2,3) ";
			else if($status==6) $_filterCond=" role_id > 0 and status in (5,6) ";
			else if($status==9) $_filterCond=" role_id > 0 and status in (8,9) ";
			else $_filterCond=" role_id > 0 and status=".$status;
			
			if($is_global_access!=1){
				if($_filterCond=="") $_filterCond .=" role_id>0 ";
				else $_filterCond .=" and role_id>0 ";
			}
			
			if($dValue!="ALL" && $dValue!="" ){
				if($_filterCond=="") $_filterCond .= " dept_id='".$dValue."'";
				else $_filterCond .= " and dept_id='".$dValue."'";
			}
						
			if($sdValue!="ALL" && $sdValue!=""){
				if($_filterCond=="") $_filterCond .= " sub_dept_id='".$sdValue."'";
				else $_filterCond .= " and sub_dept_id='".$sdValue."'";
			}
			
			if($cValue!="ALL" && $cValue!=""){
				//if($_filterCond=="") $_filterCond .= " client_id='".$cValue."'";
				//else $_filterCond .= " and client_id='".$cValue."'";
				
				if($_filterCond=="") $_filterCond .= " is_assign_client (b.id,$cValue)";
				else $_filterCond .= " and is_assign_client (b.id,$cValue)";
				
			}
			
			/* if($sValue!="ALL" && $sValue!=""){
				if($_filterCond=="") $_filterCond .= " site_id='".$sValue."'";
				else $_filterCond .= " And site_id='".$sValue."'";
			} */
			
			if($oValue!="ALL" && $oValue!=""){
				if($_filterCond=="") $_filterCond .= " office_id='".$oValue."'";
				else $_filterCond .= " And office_id='".$oValue."'";
			}
			
			if($pValue!="ALL" && $pValue!="" && $pValue!="0"){
				//if($_filterCond=="") $_filterCond .= " process_id='".$pValue."'";
				//else $_filterCond .= " And process_id='".$pValue."'";
				
				if($_filterCond=="") $_filterCond .= " is_assign_process (b.id,$pValue)";
				else $_filterCond .= " and is_assign_process (b.id,$pValue)";
			}
			
			if($spValue!="ALL" && $spValue!=""){
				if($_filterCond=="") $_filterCond .= " sub_process_id='".$spValue."'";
				else $_filterCond .= " And sub_process_id='".$spValue."'";
			}
			
			if($rValue!="ALL" && $rValue!=""){
				if($_filterCond=="") $_filterCond .= " role_id='".$rValue."'";
				else $_filterCond .= " And role_id='".$rValue."'";
			}
			
			
			$data['fusionid']=$fusionid;
			
			if($fusionid!=""){
				
				$fusionid = str_replace(",","','",$fusionid);
				
				if($_filterCond=="") $_filterCond .= " fusion_id in ('".$fusionid."') ";
				else $_filterCond .= " And fusion_id in ('".$fusionid."') ";
			}
			
			//if(get_role_dir()!="admin" && get_role_dir()!="super" && get_role_dir()!="support" && get_role_dir()!="head" && get_dept_folder()=="hr" && get_dept_folder()=="rta" && get_dept_folder()=="wfm") $_filterCond .=" And (site_id='$user_site_id' OR office_id='$user_office_id') ";
			
			if($is_global_access!=1) $_filterCond .=" And (office_id='$user_office_id' OR '$user_oth_office' like CONCAT('%',office_id,'%') )";
						
			// Remove mis on if condition on 04-12-20 (kb)
			if((get_role_dir()=="tl" || get_role_dir()=="trainer" || get_role_dir()=="manager") && ($is_global_access !=1 &&  get_dept_folder()!="hr" && get_dept_folder()!="wfm" && is_all_dept_access()==false)){
				
					//$assToCond = " (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where  assigned_to ='$current_user')) ";
					
					$assToCond ="";
					$skip=false;
					
					if(get_dept_folder()=="mis" && $dValue==6) $skip=true;
					if(get_dept_folder()=="transition" && $dValue==6) $skip=true;
					
					
					if($skip==false){
						if(get_role_dir()=="manager"){
													
							if(get_dept_folder()=="operations"){
								$assToCond = " (assigned_to='$current_user' OR (is_assign_process(b.id,'$ses_process_ids')=1 AND dept_id='$ses_dept_id') OR (assigned_to in (SELECT id FROM signin where  assigned_to ='$current_user')) OR (assigned_to in (SELECT id FROM signin where assigned_to in (SELECT id FROM signin where  assigned_to ='$current_user' ))) ) ";
							}else{
								$assToCond = " ( dept_id='$ses_dept_id' ) ";
							}
							
						}else{
							$assToCond = " (assigned_to='$current_user' OR (assigned_to in (SELECT id FROM signin where  assigned_to ='$current_user')) OR (assigned_to in (SELECT id FROM signin where assigned_to in (SELECT id FROM signin where  assigned_to ='$current_user' ))) ) ";
						}
					}
					
					if($_filterCond=="") $_filterCond .= $assToCond;
					else if($assToCond!="")  $_filterCond .= " And " . $assToCond;
			}
			
			if($is_global_access==1 || get_role_dir()=="admin"){
				
				$qSql="SELECT id,name FROM role where is_active=1 and id > 0 ORDER BY name";	
				
				$data['role_list'] = $this->Common_model->get_rolls_for_assignment2($qSql);
			
			}else if(get_role_dir()=="tl" || get_role_dir()=="trainer"){
			
				$qSql="SELECT id,name FROM role where is_active=1 and folder not in('super','admin') ORDER BY name";
				$data['role_list'] = $this->Common_model->get_rolls_for_assignment2($qSql);
				
			}else{
				$qSql="SELECT id,name FROM role where is_active=1 and folder not in('super') ORDER BY name";
				$data['role_list'] = $this->Common_model->get_rolls_for_assignment2($qSql);
			}
			
			//if($role_id>'1' && $role_id<'6'){
			//if(get_role_dir()!="super" && get_role_dir()!="admin"){
			if(get_role_dir()!="super" && $is_global_access!=1){
				//$tl_cnd=" and site_id=".$user_site_id;
				$tl_cnd=" and office_id='$user_office_id' ";
				$data['tl_list'] = $this->Common_model->get_tls_for_assign2($tl_cnd);
				
			}else $data['tl_list'] = $this->Common_model->get_tls_for_assign2("");
					
			
			if( $is_global_access==1 ){ 
			
				$data['location_list'] = $this->Common_model->get_office_location_list();
				$data['site_list'] = $this->Common_model->get_sites_for_assign();
			}else{
				$sCond=" Where id = '$user_site_id'";
				$data['site_list'] = $this->Common_model->get_sites_for_assign2($sCond);
				$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
			}
						
			$data['sub_department_list'] = $this->Common_model->get_sub_department_list($dValue);
			
			
			if($is_global_access=='1' ||  get_role_dir()=="admin" || get_dept_folder()=="hr" || get_dept_folder()=="wfm" || is_all_dept_access() ){
				
				$data['department_list'] = $this->Common_model->get_department_list();
				
				if($dValue=="ALL" || $dValue=="") $data['sub_department_list'] = array();
				else $data['sub_department_list'] = $this->Common_model->get_sub_department_list($dValue);
				
			}else{
				if( get_dept_folder()=="mis" || get_dept_folder()=="transition" || is_executive_access_as_supervisor($current_user, get_role_dir_original(), get_dept_folder()) ) $data['department_list'] = $this->Common_model->get_department_session_withops($ses_dept_id);
				else $data['department_list'] = $this->Common_model->get_department_session($ses_dept_id);
				
				$data['sub_department_list'] = $this->Common_model->get_sub_department_list($ses_dept_id);
			}
			
						
			/*
			if($is_global_access==1 ||  get_role_dir()=="admin"){
				
				$data['department_list'] = $this->Common_model->get_department_list();
				
				if($dValue=="ALL" || $dValue=="") $data['sub_department_list'] = array();
				else $data['sub_department_list'] = $this->Common_model->get_sub_department_list($dValue);
				
			}else{
				
				$data['department_list'] = $this->Common_model->get_department_session($ses_dept_id);
				$data['sub_department_list'] = $this->Common_model->get_sub_department_list($ses_dept_id);
			}
			*/
		
			
			$qSql="Select id,name from master_term_type where is_active=1";
			$data['ttype_list'] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql="Select id,name from master_sub_term_type where is_active=1";
			$data['sub_ttype_list'] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql="Select id,description from master_resign_reason where is_active=1";
			$data['resign_reason'] = $this->Common_model->get_query_result_array($qSql);
			
			$data['client_list'] = $this->Common_model->get_client_list();
			$data['process_list'] = $this->Common_model->get_process_for_assign();
			
			if($current_user==20399 || $current_user == 20400){
						$data['client_list'] = array();
						$data['process_list'] = array();
			}
			
			// Phase List
			$data['phaseList'] = $this->display_user_phase('', 'array');
			
			//echo $_filterCond;
			
			$fullArray = $this->Common_model->get_manage_ulist($_filterCond);
			$data['user_list'] = $fullArray;
			
			$this->create_CSV($fullArray);					//////////////////////////////
															//// CSV Report
			$dn_link = base_url()."user/downloadCsv";		//////////////////////////////
						
			if($pValue!="" && $pValue!="ALL") $data['sub_process_list'] = $this->Common_model->get_sub_process_list($pValue);
			else $data['sub_process_list']=array();
		
			$data['dValue']=$dValue;
			$data['sdValue']=$sdValue;
			
			$data['cValue']=$cValue;
			$data['oValue']=$oValue;
			//$data['sValue']=$sValue;
			$data['pValue']=$pValue;
			$data['spValue']=$spValue;
			$data['rValue']=$rValue;
			
			$data['status']=$status;
			
			$data['download_link']=$dn_link;	//////////////////////////////
												//// CSV Report
			$data["action"] = $action;			//////////////////////////////
		
			$this->load->view('dashboard',$data);
			
		}
    }
	
	
//////////////////////////// Manage CSV Report part ////////////////////////////////////	
	public function downloadCsv()
	{	
		$currdate = date('Ymd');
		
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$newfile="user_list_".$currdate.".csv";
		header('Content-Disposition: attachment;  filename="'.$newfile.'"');
		readfile($filename);
	}
	
	public function create_CSV($rr)
	{		
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$fopen = fopen($filename,"w+");
		
		//$header = array("Fusion ID", "XPO ID", "Fname", "Lname", "DOB", "DOJ", "Status", "Designation", "Location", "Client", "Process", "Assign TL", "Blood Group", "Sex", "Nationality", "Caste", "Is_PH", "Office Mail ID", "Personal Mail ID", "Phone No", "Emergency No", "Father Name", "Mother Name", "Present Address", "Parmanent Address", "PIN", "City", "State", "Country", "Marital Status", "DOM", "Spouse Name", "No of Chidren", "Security No/Adhaar No", "Employee Status");
		
		$header = array("Fusion ID", "Site ID/XPO ID", "User ID", "Last Name", "First Name" , "Employee Name", "Gender", "Client", "Function", "Location", "Department", "DoB", "DoJ", "Site", "Designation", "Organization Role", "Level-1 Supervisor", "Process", "Email ID", "Class/Batch", "Phase", "Status", "Terms Date", "Furlough Date", "Bench Date", "Suspended Date");
		
		$row = "";
		foreach($header as $data) $row .= ''.$data.',';
		fwrite($fopen,rtrim($row,",")."\r\n");
		$searches = array("\r", "\n", "\r\n");
		
		foreach($rr as $user)
		{	
			/* if($user['status']==1) $status="Active";
			else $status="Inactive";
		
			$row = '"'.$user['fusion_id'].'",';
			$row .= '"'.$user['xpoid'].'",'; 
			$row .= '"'.$user['fname'].'",'; 
			$row .= '"'.$user['lname'].'",';
			$row .= '"'.$user['dob'].'",';
			$row .= '"'.$user['doj'].'",';
			$row .= '"'.$status.'",';
			$row .= '"'.$user['role_name'].'",';
			$row .= '"'.$user['office_name'].'",';
			$row .= '"'.$user['client_name'].'",';
			$row .= '"'.$user['process_name'].'",'; 
			$row .= '"'.$user['asign_tl'].'",'; 
			$row .= '"'.$user['blood_group'].'",';			
			$row .= '"'.$user['sex'].'",';			
			$row .= '"'.$user['nationality'].'",';			
			$row .= '"'.$user['caste'].'",';			
			$row .= '"'.$user['is_ph'].'",';			
			$row .= '"'.$user['email_id_off'].'",';			
			$row .= '"'.$user['email_id_per'].'",';			
			$row .= '"'.$user['phone'].'",';			
			$row .= '"'.$user['phone_emar'].'",';			
			$row .= '"'.$user['father_name'].'",';			
			$row .= '"'.$user['mother_name'].'",';			
			$row .= '"'.$user['address_present'].'",';			
			$row .= '"'.$user['address_permanent'].'",';			
			$row .= '"'.$user['pin'].'",';			
			$row .= '"'.$user['city'].'",';			
			$row .= '"'.$user['state'].'",';			
			$row .= '"'.$user['country'].'",';			
			$row .= '"'.$user['marital_status'].'",';			
			$row .= '"'.$user['dom'].'",';			
			$row .= '"'.$user['spouse_name'].'",';			
			$row .= '"'.$user['no_of_children'].'",';			
			$row .= '"'.$user['social_security_no'].'",';			
			$row .= '"'.$user['employee_status'].'",';		 */	
			
			if($user['dept_name']=='Operations') $department='Operations';
			else $department='Support';
									
			$susp_date='';
			$bench_date='';
			$furlough_date='';
			
			if($user['status']==0) $status='Term';
			else if($user['status']==1) $status='Active';
			else if($user['status']==2) $status='Pre-Term';
			else if($user['status']==3){
				$status='Suspended';
				$susp_date=$user['susp_date'];
			}else if($user['status']==4) $status='Active';
			else if($user['status']==5){
				$status='Bench-Paid';
				$bench_date=$user['bench_date'];
			}else if($user['status']==6){
				$status='Bench-Unpaid';
				$bench_date=$user['bench_date'];
			}else if($user['status']==7){
				$status='Furlough';
				$furlough_date=$user['furlough_date'];
			}else if($user['status']==9 || $user['status']==8) $status='Deactive';
			else $status='UN';
			
			$phaseStatus = $this->display_user_phase($user['phase']);
			
			$row = '"'.$user['fusion_id'].'",'; 
			$row .= '"'.$user['xpoid'].'",'; 
			$row .= '"'.$user['omuid'].'",';
			$row .= '"'. $user['lname'].'",';
			$row .= '"'.$user['fname'] .'",'; 
			$row .= '"'.$user['fname'] . " ". $user['lname'].'",';
			$row .= '"'. $user['sex'].'",';
			$row .= '"'. $user['client_name'].'",';	
			$row .= '"'.$department.'",';
			$row .= '"'. $user['office_name'].'",';
			$row .= '"'. $user['dept_name'].'",'; 
			$row .= '"'. $user['dob'].'",';
			$row .= '"'.$user['doj'].'",';
			$row .= '"'.$user['site_name'].'",'; 
			$row .= '"'.$user['role_name'].'",'; 
			$row .= '"'.$user['org_name'].'",'; 
			$row .= '"'.$user['asign_tl'].'",'; 
			$row .= '"'.$user['process_name'].'",'; 
			$row .= '"'.$user['email_id_per'].'",'; 
			$row .= '"'.$user['batch_code'].'",'; 
			$row .= '"'.$phaseStatus.'",'; 
			$row .= '"'.$status.'",'; 
			$row .= '"'.$user['terms_date'].'",'; 
			$row .= '"'.$furlough_date.'",';
			$row .= '"'.$bench_date.'",';
			$row .= '"'.$susp_date.'"'; 
						
			fwrite($fopen,$row."\r\n");	
			
		}
		
		fclose($fopen);
	}
///////////////////////////////////////////////////////////////////////////////	
	
	public function chkuser()
    {
        if(check_logged_in())
        {
			$this->check_access();
			
			$user_site_id= get_user_site_id();
			$srole_id= get_role_id();
			$current_user = get_user_id();
			$ses_dept_id=get_dept_id();
			
			$user_office_id=get_user_office_id();
			$is_global_access=get_global_access();
			
			
            $data["aside_template"] = get_aside_template();
			//$data["aside_template"] = "user/aside.php";
			
            $data["content_template"] = "user/add.php";
            $data["error"] = ''; 
            	
			if(get_role_dir()=="super" || $is_global_access==1){
				
				$data['location_list'] = $this->Common_model->get_office_location_list();
				$data['site_list'] = $this->Common_model->get_sites_for_assign();
			}else{
				$sCond=" Where id = '$user_site_id'";
				$data['site_list'] = $this->Common_model->get_sites_for_assign2($sCond);
				$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
			}
						
									
			$office_id = "";
			$_fname = "";
            $_lname = "";
			$doj = ""; 
			$qSql="";
			$isRedirect=false;
			
			$data['user_list'] =array();
			
            if($this->input->get('submit')=="Add" || $this->input->get('submit')=="Ajouter" )
            {
                 
				$_fname = $this->input->get('fname');
                $_lname = $this->input->get('lname'); 
				$doj = trim($this->input->get('doj')); 
						
                if($_fname!="" && $_lname!="" )
                {		
						$qSql="select *,get_client_names(b.id) as client_name, get_process_names(b.id) as process_name, (Select name from role k  where k.id=b.role_id) as role_name  from signin b where fname like '%$_fname%' and lname like '%$_lname%' ";
						$res=$this->Common_model->get_query_result_array($qSql);
						if(empty($res)) $isRedirect=true;
						$data['user_list'] =$res;
				}
            }
			
			   
			if($this->input->get('submit')=="Confirm & Add" || $this->input->get('submit')=="Confirmer et ajouter" ){
				$_fname = $this->input->get('fname');
                $_lname = $this->input->get('lname'); 
				$doj = trim($this->input->get('doj')); 
				$isRedirect=true;
			}
			
			if($isRedirect==true){
				redirect(base_url()."users/add?fname=$_fname&lname=$_lname","refresh");				
			}
			
            
			$data['qSql'] =$qSql; 
			$data['fname'] =$_fname;
			$data['lname'] =$_lname;
			$data['doj'] =$doj;
			   
			//$this->load->view('dashboard_ajax',$data);
			$this->load->view('dashboard',$data);
								
        }                  
   }
   
	
	
public function add_users()
    {
        if(check_logged_in())
        {
			$this->check_access();
			
			$user_site_id= get_user_site_id();
			$srole_id= get_role_id();
			$current_user = get_user_id();
			$ses_dept_id=get_dept_id();
			
			$user_office_id=get_user_office_id();
								
			$is_global_access=get_global_access();
			$user_oth_office=get_user_oth_office();
			
            $data["aside_template"] = get_aside_template();
			//$data["aside_template"] = "user/aside.php";
			
            $data["content_template"] = "user/add_users.php";
            $data["error"] = ''; 
            
			//$data['role_list'] = $this->Common_model->get_rolls_for_assignment_all();
			//if($srole_id<='1'){
			
			if(get_role_dir()=="super" || get_role_dir()=="admin" || $is_global_access==1){
				
				$qSql="SELECT id,name, org_role FROM role where is_active=1 and id>0 ORDER BY name";	
				$data['role_list'] = $this->Common_model->get_rolls_for_assignment2($qSql);
				
			}else if(get_role_dir()=="tl" || get_role_dir()=="trainer"){
				//$cond=" and id not in(0,1,4,11)";
				$qSql="SELECT id,name, org_role  FROM role where is_active=1 and folder not in('super','admin') ORDER BY name";
				$data['role_list'] = $this->Common_model->get_rolls_for_assignment2($qSql);
								
			}else{
				$qSql="SELECT id,name, org_role  FROM role where is_active=1 and folder not in('super') ORDER BY name";
				$data['role_list'] = $this->Common_model->get_rolls_for_assignment2($qSql);
			}
			
			$data['organization_role'] = $this->Common_model->role_organization();
			
			
			$data['client_list'] = $this->Common_model->get_client_list();			
			$data['payroll_type_list'] = $this->Common_model->get_query_result_array("select * from master_payroll_type where is_active=1");
			$data['payroll_status_list'] = $this->Common_model->get_query_result_array("select * from master_payroll_status where is_active=1");
				
				
			if($is_global_access==1){
				
				$data['location_list'] = $this->Common_model->get_office_location_list();
				$data['site_list'] = $this->Common_model->get_sites_for_assign();
			}else{
				$sCond=" Where id = '$user_site_id'";
				$data['site_list'] = $this->Common_model->get_sites_for_assign2($sCond);
				$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
			}
			
			
			if($is_global_access==1){
				$data['tl_list'] = $this->Common_model->get_tls_for_assign2("");
							
			}else{
				
				//$tl_cnd=" and office_id='$user_office_id' ";
				$tl_cnd = " and (office_id='$user_office_id' OR '$user_oth_office' like CONCAT('%',office_id,'%')) ";
				$data['tl_list'] = $this->Common_model->get_tls_for_assign2($tl_cnd);
				
			}
			
			
			$data['process_list'] = $this->Common_model->get_process_for_assign();
						
			$data['department_list'] = $this->Common_model->get_department_list();
			$data['sub_department_list'] = $this->Common_model->get_sub_department_list($ses_dept_id);
		
			
			
			/*
			if($is_global_access==1 || get_role_dir()=="super" ||  get_role_dir()=="admin"){
				
				$data['department_list'] = $this->Common_model->get_department_list();
				$data['sub_department_list'] = array();
				
			}else{
				
				$data['department_list'] = $this->Common_model->get_department_session($ses_dept_id);
				$data['sub_department_list'] = $this->Common_model->get_sub_department_list($ses_dept_id);
			}
			*/
			
			
			$_fname = "";
            $_lname = "";
			
            //if($this->input->post('submit')=="Add")
			if($this->input->post('submit'))
            {
                  
				$_run = false;  
				
				$log=get_logs();
				
				$office_id = trim($this->input->post('office_id'));
				
				$dept_id = trim($this->input->post('dept_id'));
				$sub_dept_id = trim($this->input->post('sub_dept_id'));
				
				$xpoid = trim($this->input->post('xpoid'));
				$xpoid = strtoupper($xpoid);
				
                $_omuid = trim($this->input->post('omuid'));
				$red_login_id = trim($this->input->post('red_login_id'));
                //$_passwd = trim($this->input->post('passwd'));
                $_fname = $this->input->post('fname');
                $_lname = $this->input->post('lname'); 
				$sex = trim($this->input->post('sex')); 
				
				$client_array = $this->input->post('client_id');
				$process_array = $this->input->post('process_id');
								
				$_role_id = trim($this->input->post('role_id')); 
				
				$_org_role_id = trim($this->input->post('org_role')); 
				
				$_assigned_to = trim($this->input->post('assigned_to'));

				$email_id_per = trim($this->input->post('email_id_per'));
				$email_id_off = trim($this->input->post('email_id_off'));
				
				$phone = trim($this->input->post('phone'));
				$phone_emar = trim($this->input->post('phone_emar'));
								
				$_site_id = trim($this->input->post('site_id'));
				
				//$sub_process_id = trim($this->input->post('sub_process_id'));
				
				$doj = trim($this->input->post('doj')); 
				$batch_code=trim($this->input->post('batch_code'));
				
				$dob = trim($this->input->post('dob')); 
												
				$payroll_type=trim($this->input->post('payroll_type'));
				$payroll_status=trim($this->input->post('payroll_status'));
				
				$uan_no=trim($this->input->post('uan_no'));
				$esi_no=trim($this->input->post('esi_no'));
				
				//$reporting_level1=trim($this->input->post('reporting_level1'));
				//$reporting_level2=trim($this->input->post('reporting_level2'));
				//$reporting_level3=trim($this->input->post('reporting_level3'));
				//$is_bod=trim($this->input->post('is_bod'));
				
				$_omuid="";
				if($office_id == 'KOL') $_omuid = $xpoid;
				else $_omuid = $fname.".".$lname;
			
				$_status= 4;
				$_disp_id= 1;
                
                				
                if($_role_id!="" && $_fname!="" && $_lname!=""  && $office_id!="" && $dept_id!="" )
                {
                    if($this->user_model->user_omid_exists($_omuid)===false) $_run = true;  
                    else{
						
						$_run = false;  
						$data["error"] = show_msgbox('User Creation Failed. OM ID already present',true);
						
					}
					
					if($this->user_model->user_xpoid_exists_off($xpoid,$office_id)===false) $_run = true;  
                    else{
						$_run = false;
						$data["error"] = show_msgbox('User Creation Failed. Emp ID/XPO ID already present',true);
					}
					
                } 
                    					
                    if($_run===true)
                    {
						//"passwd" => $_passwd,
                        $_field_array = array(
                            "office_id" => $office_id,
							"site_id" => $_site_id,
							"dept_id" => $dept_id,
							"sub_dept_id" => $sub_dept_id,
                            "fname" => $_fname,
                            "lname" => $_lname,
							"sex" => $sex,
							"role_id" => $_role_id,
							"org_role_id" => $_org_role_id,
							"disposition_id" => $_disp_id,
							"status" => $_status,
							"created_by" => $current_user,
							"log" => $log,
							
                        ); 
						
						if($xpoid!="") $_field_array['xpoid']=$xpoid;
						if($_omuid!="") $_field_array['omuid']=$_omuid;
						if($red_login_id!="") $_field_array['red_login_id']=$red_login_id;
						
						if($doj!=""){
							 $doj=mmddyy2mysql($doj);
							 $_field_array['doj']=$doj;
						}
						if($dob!=""){
							 $dob=mmddyy2mysql($dob);
							 $_field_array['dob']=$dob;
						}
						
						if($_assigned_to!="") $_field_array['assigned_to']=$_assigned_to;
						
						if($batch_code!="") $_field_array['batch_code']=$batch_code;
												
						$this->db->trans_begin();
						
						////////////////////////////
						
                        $_user_id = data_inserter('signin',$_field_array);
                        
						////
						$evt_date = CurrMySqlDate();

						$role_his_array = array(
							"user_id" => $_user_id,
							"role_id" => $_role_id,
							"stdate" => $doj,
							"change_date" => $evt_date,
							"change_by" => $current_user,
                            "log" => $log,
                        ); 
						
						$rowid= data_inserter('role_history',$role_his_array);
												
						$fusion_id="";					
						
						if($_user_id!==FALSE)
                        {
														
							// will be update
							
							$max_id=$this->Common_model->get_single_value("SELECT max(substr(fusion_id,5)) as value FROM signin where office_id='$office_id'");
							$max_id=$max_id+1;							
							$fusion_id="F".$office_id."".addLeadingZero($max_id,6);
							
							$passwd = md5($fusion_id);
							
							$Update_array = array(
								"fusion_id" => $fusion_id,
								"passwd" => $passwd
							);
							
							$this->db->where('id', $_user_id);
							$this->db->update('signin', $Update_array);	

							foreach ($client_array as $key => $value){
								
								$iClientArr = array(
									"user_id" => $_user_id,
									"client_id" => $value,
									"log" => $log,
								); 
								$rowid= data_inserter('info_assign_client',$iClientArr);
							}
							
							foreach ($process_array as $key => $value){
								$iProcessArr = array(
									"user_id" => $_user_id,
									"process_id" => $value,
									"log" => $log,
								);
								$rowid= data_inserter('info_assign_process',$iProcessArr);
							}

								
								/*
								
								if($is_bod=="")$is_bod=0;
								
								$head_array = array(
									"user_id" => $_user_id,
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
								 
								if($payroll_type=="")$payroll_type='1';
								if($payroll_status=="")$payroll_status='1';
								
								$payroll_array = array(
									"user_id" => $_user_id,
									"payroll_type" => $payroll_type,
									"payroll_status" => $payroll_status,
									"log" => $log
								);
								$rowid= data_inserter('info_payroll',$payroll_array);
								
								//encode_string
								
								$personal_array = array(
									"user_id" => $_user_id,
									"email_id_per" => $email_id_per,
									"email_id_off" => $email_id_off,
									"phone" => $phone,
									"phone_emar" => $phone_emar,
									"uan_no" => $uan_no,
									"esi_no" => $esi_no,
									"log" => $log
								);
								$rowid= data_inserter('info_personal',$personal_array);
                        }
						
												
						$this->db->trans_complete();						
						////////////////////////////
												
						if($fusion_id=="" || $_user_id===FALSE || $this->db->trans_status() === FALSE){
							$this->db->trans_rollback();
							$data['error'] = show_msgbox('User Creation Failed. Try Again',true);								
						}else{
								//////////LOG////////
								$this->db->trans_commit();
								
								$Lfull_name=get_username();
								$LOMid=get_user_fusion_id();
								
								$LogMSG="Added User $_fname $_lname ($_omuid), Fusion id: $fusion_id";
								log_message('FEMS', $LOMid.' - ' . $Lfull_name . ' | '.$LogMSG );
											
								//////////
				
								//$this->session->set_flashdata("error",show_msgbox("User Added Successfully",false));
							   
								//redirect(base_url().get_role_dir()."/manage_users");
								redirect(base_url()."users/addsuccess?uid=$_user_id");
								//redirect(base_url()."admin/dashboard#users/manage");
																			   
						}
							                        
                    }
					
               }
			   
			   if($_fname=="") $_fname = $this->input->get('fname');
			   if($_lname=="") $_lname = $this->input->get('lname'); 
			   $data['fname'] =$_fname;
			   $data['lname'] =$_lname;
			   
			   
			   //$this->load->view('dashboard_ajax',$data);
			   $this->load->view('dashboard',$data);
								
            }                
   }
   
/*-------------------------Client Add & Manage-----------------------------*/   
	public function add_client(){
        if(check_logged_in()){
			
			$this->check_access();
			
			$user_site_id= get_user_site_id();
			$srole_id= get_role_id();
			$current_user = get_user_id();
			$ses_dept_id=get_dept_id();
			$user_office_id=get_user_office_id();					
			$is_global_access=get_global_access();
			
            $data["aside_template"] = get_aside_template();
            $data["content_template"] = "user/add_client.php";
            $data["error"] = ''; 
			
			$data['client_list'] = $this->Common_model->get_client_list();
			$data['process_list'] = $this->Common_model->get_process_for_assign();
			$data['location_list'] = $this->Common_model->get_office_location_list();
			$data['site_list'] = $this->Common_model->get_sites_for_assign();
			
			if(get_login_type() == 'client'){
				$data['client_list'] = $this->Client_model->get_my_client_list();
				$data['process_list'] = $this->Client_model->get_my_process_list();
				
				// ONLY FOR KYT
				if(get_clients_allow_kyt_crm()){					
					$sqlCourses = "SELECT * from kyt_course_master WHERE is_active = '1'";
					$data['courses_list'] = $this->Common_model->get_query_result_array($sqlCourses);
				}
			}
			
            //if($this->input->post('submit')=="Add")
			if($this->input->post('submit'))
            {
              
				$log=get_logs();
				$office_id = $this->input->post('office_id');
                $_passwd = trim($this->input->post('passwd'));
                $_fname = $this->input->post('fname');
                $_lname = $this->input->post('lname'); 
				$sex = trim($this->input->post('sex')); 
				$client_id = $this->input->post('client_id');
				$process_id = $this->input->post('process_id'); 
				$email_id_per = trim($this->input->post('email_id_per'));
				$phone = trim($this->input->post('phone'));
				
				$role = trim($this->input->post('role'));
				if(empty($role)){ $role = "client"; }
				
				$multiple_office_id = implode(',', $office_id);
				$multiple_process_id = implode(',', $process_id);
				
				$allow_process_update = trim($this->input->post('allow_process_update'));
				$allow_qa_module = trim($this->input->post('allow_qa_module'));
				$allow_ba_modile = trim($this->input->post('allow_ba_module'));
				$allow_knowledge = trim($this->input->post('allow_knowledge'));
				$allow_dfr_interview = trim($this->input->post('allow_dfr_interview'));
				$allow_qa_audit = trim($this->input->post('allow_qa_audit'));
				$allow_qa_review = trim($this->input->post('allow_qa_review'));
				$allow_mind_faq = trim($this->input->post('allow_mind_faq'));
				$allow_dfr_report = trim($this->input->post('allow_dfr_report'));
				
				$allow_qa_dashboard = trim($this->input->post('allow_qa_dashboard'));
				$allow_qa_dipcheck = trim($this->input->post('allow_qa_dipcheck'));
				$allow_qa_report = trim($this->input->post('allow_qa_report'));
				$allow_calibration = trim($this->input->post('allow_calibration'));
				
				$allow_follett = trim($this->input->post('allow_follett'));
				$allow_zovio = trim($this->input->post('allow_zovio'));
				$allow_mpower_voc = trim($this->input->post('allow_mpower_voc'));
				
				$allow_kyt = trim($this->input->post('allow_kyt'));
				$allow_naps = trim($this->input->post('allow_naps'));
				$allow_consultant_report = trim($this->input->post('allow_consultant_report'));
				
				$dob = date('Y-m-d', strtotime(trim($this->input->post('dob')))); 	
				$_status= 1;
				
					$_field_array = array(
						"office_id" => $multiple_office_id,
						"passwd" => $_passwd,
						"fname" => $_fname,
						"lname" => $_lname,
						"sex" => $sex,
						"client_id" => $client_id,
						"process_id" => $multiple_process_id,
						"email_id" => $email_id_per,
						"phno" => $phone,
						"dob" => $dob,
						"role" => $role,
						"allow_process_update" => $allow_process_update,
						"allow_qa_module" => $allow_qa_module,
						"allow_ba_module" => $allow_ba_modile,
						"allow_knowledge" => $allow_knowledge,
						"allow_dfr_interview" => $allow_dfr_interview,
						"allow_qa_audit" => $allow_qa_audit,
						"allow_qa_review" => $allow_qa_review,
						"allow_mind_faq" => $allow_mind_faq,
						"allow_dfr_report" => $allow_dfr_report,
						"allow_qa_dashboard" => $allow_qa_dashboard,
						"allow_qa_dipcheck" => $allow_qa_dipcheck,
						"allow_qa_report" => $allow_qa_report,
						"allow_calibration" => $allow_calibration,
						"allow_follett" => $allow_follett,
						"allow_zovio" => $allow_zovio,
						"allow_mpower_voc" => $allow_mpower_voc,
						"allow_kyt" => $allow_kyt,
						"allow_naps" => $allow_naps,
						"allow_consultant_report" => $allow_consultant_report,
						"status" => $_status,
						"log" => $log	
					); 
					$rowid = data_inserter('signin_client',$_field_array);
					
					
					// EXTRA INFO
					if(get_login_type() == 'client'){
						if(get_clients_allow_kyt_crm()){
							$client_course = $this->input->post('client_course'); 
							$multiple_course_id = implode(',', $client_course);
							$infoArray = [
								"user_id" => $rowid,
								"course_id" => $multiple_course_id,
							];
							data_inserter('info_personal_client',$infoArray);
						}				
					}
                      
				    redirect('user/manage_client');
               }
			   
			   $this->load->view('dashboard',$data);
								
            }               
   }


   public function manage_client(){
	   if(check_logged_in()){
		   $user_site_id= get_user_site_id();
			$srole_id= get_role_id();
			$current_user = get_user_id();
			$ses_dept_id=get_dept_id();
			$user_office_id=get_user_office_id();					
			$is_global_access=get_global_access();
			
			$data["aside_template"] = get_aside_template();
            $data["content_template"] = "user/manage_client.php";
            $data["error"] = '';
			
			$data['client_list'] = $this->Common_model->get_client_list();
			$data['process_list'] = $this->Common_model->get_process_for_assign();
			$data['location_list'] = $this->Common_model->get_office_location_list();
			$data['site_list'] = $this->Common_model->get_sites_for_assign();			
			
			if(get_login_type() == 'client'){
				$data['client_list'] = $this->Client_model->get_my_client_list();
				$data['process_list'] = $this->Client_model->get_my_process_list();
			}
			
			$extraWhere = " AND (s.role IS NULL OR s.role = 'client' || s.role = 'consultant')"; $extraLeftJoin = "";  $extraSelectData = "";
			if(get_login_type() == 'client'){
				$user_id = get_user_id();
				if(empty($user_id)){ $user_id = 0; }
				$user_client_ids = get_client_ids();
				if(empty($user_client_ids)){ $user_client_ids = 0; }
				$extraWhere = " AND s.client_id IN ($user_client_ids) AND s.id NOT IN ($user_id)";
				
				// ONLY FOR KYT
				if(get_clients_allow_kyt_crm()){					
					$sqlCourses = "SELECT * from kyt_course_master WHERE is_active = '1'";
					$data['courses_list'] = $this->Common_model->get_query_result_array($sqlCourses);
					$extraLeftJoin = " LEFT JOIN info_personal_client as ip ON ip.user_id = s.id LEFT JOIN kyt_course_master as mc ON mc.id = ip.course_id ";
					$extraSelectData = " ip.course_id, mc.name as course_name, ";
				}
			}
			
			$qSql="Select s.*, $extraSelectData (select shname from client c where c.id=client_id) as client_name, 
			(SELECT GROUP_CONCAT(p.name) from process as p WHERE  p.id IN (s.process_id)) as process_name,
			(SELECT GROUP_CONCAT(o.location) from office_location as o WHERE  s.office_id like CONCAT('%',o.abbr,'%')) as office_name, 
			DATE_FORMAT(dob, '%m/%d/%Y') as dob from signin_client as s $extraLeftJoin WHERE 1 $extraWhere";
			$data["client_info"]=$this->Common_model->get_query_result_array($qSql);
			
			$this->load->view('dashboard',$data);
	   }
   }
   
   
   public function userClientActDeact(){
		if(check_logged_in()){
			$this->check_access();
			$c_id = trim($this->input->post('c_id'));
			$sid = trim($this->input->post('sid'));
			
			if($c_id!=""){
				$this->db->where('id', $c_id);
				$this->db->update('signin_client', array('status' => $sid));
				$ans="done";
			}else{
				$ans="error";
			}
			echo $ans;
		}
	}
	
	
	 public function userUnlockLoginType(){
		if(check_logged_in()){
			$this->check_access();
			$c_id = trim($this->input->get('c_id'));
			$l_type = trim($this->input->get('l_type'));
			
			if(!empty($c_id) && !empty($l_type)){
				$this->db->where('id', $c_id);
				$this->db->update('signin_client', array('login_type' => $l_type));
				$ans="done";
			}			
		}
		redirect($_SERVER['HTTP_REFERER']);
	}
	
	public function editUserClient(){
		if(check_logged_in()){
			$this->check_access();
			
				$log=get_logs();
				$c_id = trim($this->input->post('c_id'));
				$office_id = $this->input->post('office_id');
                $_fname = $this->input->post('fname');
                $_lname = $this->input->post('lname'); 
				$sex = trim($this->input->post('sex')); 
				$client_id = $this->input->post('client_id');
				$process_id = $this->input->post('process_id');
				$email_id_per = trim($this->input->post('email_id_per'));
				$phone = trim($this->input->post('phone'));
				$dob = date('Y-m-d', strtotime(trim($this->input->post('dob'))));
				
				$role = trim($this->input->post('role'));
				if(empty($role)){ $role = "client"; }

				$multiple_office_id = NULL;
				$multiple_process_id = NULL;
				if(!empty($office_id)){
				    $multiple_office_id = implode(',', $office_id);
				}
				if(!empty($process_id)){
					$multiple_process_id = implode(',', $process_id);
				}
				
				$allow_process_update = trim($this->input->post('allow_process_update'));
				$allow_qa_module = trim($this->input->post('allow_qa_module'));
				$allow_ba_modile = trim($this->input->post('allow_ba_module'));
				$allow_knowledge = trim($this->input->post('allow_knowledge'));
				$allow_dfr_interview = trim($this->input->post('allow_dfr_interview'));
				$allow_qa_audit = trim($this->input->post('allow_qa_audit'));
				$allow_qa_review = trim($this->input->post('allow_qa_review'));
				$allow_mind_faq = trim($this->input->post('allow_mind_faq'));
				$allow_dfr_report = trim($this->input->post('allow_dfr_report'));
				
				$allow_qa_dashboard = trim($this->input->post('allow_qa_dashboard'));
				$allow_qa_dipcheck = trim($this->input->post('allow_qa_dipcheck'));
				$allow_qa_report = trim($this->input->post('allow_qa_report'));
				$allow_calibration = trim($this->input->post('allow_calibration'));
				
				$allow_follett = trim($this->input->post('allow_follett'));
				$allow_zovio = trim($this->input->post('allow_zovio'));
				$allow_mpower_voc = trim($this->input->post('allow_mpower_voc'));
				
				$allow_kyt = trim($this->input->post('allow_kyt'));
				$allow_naps = trim($this->input->post('allow_naps'));
				$allow_consultant_report = trim($this->input->post('allow_consultant_report'));
				
				if($c_id!=""){
					$field_array = array(
						"office_id" => $multiple_office_id,
						"fname" => $_fname,
						"lname" => $_lname,
						"sex" => $sex,
						"client_id" => $client_id,
						"process_id" => $multiple_process_id,
						"email_id" => $email_id_per,
						"phno" => $phone,
						"role" => $role,
						"allow_process_update" => $allow_process_update,
						"allow_qa_module" => $allow_qa_module,
						"allow_ba_module" => $allow_ba_modile,
						"allow_knowledge" => $allow_knowledge,
						"allow_dfr_interview" => $allow_dfr_interview,
						"allow_qa_audit" => $allow_qa_audit,
						"allow_qa_review" => $allow_qa_review,
						"allow_mind_faq" => $allow_mind_faq,
						"allow_dfr_report" => $allow_dfr_report,
						"allow_qa_dashboard" => $allow_qa_dashboard,
						"allow_qa_dipcheck" => $allow_qa_dipcheck,
						"allow_qa_report" => $allow_qa_report,
						"allow_calibration" => $allow_calibration,
						"allow_follett" => $allow_follett,
						"allow_zovio" => $allow_zovio,
						"allow_mpower_voc" => $allow_mpower_voc,
						"allow_kyt" => $allow_kyt,
						"allow_naps" => $allow_naps,
						"allow_consultant_report" => $allow_consultant_report,
						"dob" => $dob
					);
					$this->db->where('id', $c_id);
					$this->db->update('signin_client', $field_array);
					
					// EXTRA INFO
					if(get_login_type() == 'client'){						
						if(get_clients_allow_kyt_crm()){
							$sqlCheck = "SELECT count(*) as value from info_personal_client WHERE user_id = '$c_id'";
							$foundCheck = $this->Common_model->get_single_value($sqlCheck);
							$client_course = $this->input->post('client_course'); 
							$multiple_course_id = implode(',', $client_course);
							$infoArray = [
								"user_id" => $c_id,
								"course_id" => $multiple_course_id,
							];
							if($foundCheck > 0){
								$this->db->where('user_id', $c_id);
								$this->db->update('info_personal_client', $infoArray);
							} else {
								data_inserter('info_personal_client',$infoArray);
							}
						}						
					}
				}
				redirect('user/manage_client');
		}
	}

/*------------------------------------*/   
 
   
public function add_user_success()
{
	if(check_logged_in())
    {
		
		$user_site_id= get_user_site_id();
		$role_id= get_role_id();
		
		$data["aside_template"] = get_aside_template();
		//$data["aside_template"] = "user/aside.php";
		
        $data["error"] = '';
		$user_id = $this->input->get('uid');
		$user_id=addslashes(trim($user_id));
		
		//$fusion_id = $this->input->get('fid');
		
		$qSql="SELECT id,fusion_id,omuid,fname,lname,office_id,role_id,(Select office_name from office_location b where b.abbr=a.office_id) as office_name, (Select name from role c where c.id=a.role_id) as role_name  from signin a WHERE id=\"$user_id\"";
		//echo $qSql;
		
		$user_info=$this->Common_model->get_query_result_array($qSql);
							
		if(!empty($user_info)){
			
			$data["user_id"] =$user_id;
			$data["user_name"] =$user_info[0]['fname']." ".$user_info[0]['lname'];
			
			$data["fusion_id"] =$user_info[0]['fusion_id'];
			$data["office_id"] =$user_info[0]['office_id'];
			$data["office_name"] =$user_info[0]['office_name'];
			$data["role_name"] =$user_info[0]['role_name'];
			$data["omuid"] =$user_info[0]['omuid'];
						
		}else{
			 redirect(base_url()."users/manage");
		}
			
			
		$data["content_template"] = "user/adduser_success.php";
		$this->load->view('dashboard',$data);
		
		
	}
	
} 


public function getSubDepartmentList()
{
	if(check_logged_in())
    {
		$did = trim($this->input->post('did'));
		echo json_encode($this->Common_model->get_sub_department_list($did));
	}
}

public function getAssignList()
{
	if(check_logged_in())
    {
		$oid = trim($this->input->post('oid'));
		
		//echo json_encode($this->Common_model->get_assign_list($oid));
		
		echo json_encode($this->Common_model->get_tls_for_assign2(""));
	}
}

 
 
public function getProcessList()
{
	if(check_logged_in())
    {
		$cid = trim($this->input->post('cid'));
		
		if(get_login_type()=="client"){
			$clients_client_id=get_clients_client_id();
			$clients_process_id=get_clients_process_id();
			$qSql = "SELECT * from process WHERE id in ( $clients_process_id ) and client_id='$cid' ORDER BY name";
			echo json_encode($this->Common_model->get_query_result($qSql));
			
		}else{
			//echo $this->Common_model->get_process_list($cid);		
			echo json_encode($this->Common_model->get_process_list($cid));
		}
	}
}

//////////////access control////////////////
public function getAccessControl()
{
	if(check_logged_in())
    {
		$off_id = trim($this->input->post('off_id'));
		
		//echo $this->Common_model->get_process_list($cid);
		
		echo json_encode($this->user_model->get_access_control_list($off_id));
	}
}

/////////////////////////User model for service request///////////////////////////////////

public function getAccessControlServicerequest()
{
	if(check_logged_in())
    {
		$off_id = trim($this->input->post('off_id'));
		
		//echo $this->Common_model->get_process_list($cid);
		
		echo json_encode($this->user_model->get_servicerequest_access_control_list($off_id));
	}
}

//////////////access control using Department////////////////
public function getAccessControlDept()
{
	if(check_logged_in())
    {
		$cat_id = trim($this->input->post('cat_id'));
		
		//echo $this->Common_model->get_process_list($cid);
		
		echo json_encode($this->user_model->get_access_control_dept_list($cat_id));
	}
}


public function getSubProcessList()
{
	if(check_logged_in())
    {
		$pid = trim($this->input->post('pid'));
		
		//echo $this->Common_model->get_process_list($cid);
		
		echo json_encode($this->Common_model->get_sub_process_list($pid));
	}
}


public function getUserName()
{
	if(check_logged_in())
    {
		$fid = trim($this->input->post('fid'));
		if($fid!=="")
		{
			$qSql="Select CONCAT(fname,' ' ,lname) as value from signin Where fusion_id = '$fid' ";
			//echo $qSql;
			echo $this->Common_model->get_single_value($qSql);
			
		}else{
			echo "";
		}
	}
	
} 

 
 public function getUserList()
{
	if(check_logged_in())
    {
		$aname = trim($this->input->post('aname'));
		$aomuid = trim($this->input->post('aomuid'));
		$cond="";
		
		if($aname!="") $cond=" Where fname like '%$aname%' OR lname like '%$aname%' ";
		if($aomuid!=""){
			if($cond=="") $cond=" Where omuid like '%$aomuid%' OR fusion_id like '%$aomuid%' OR red_login_id like '%$aomuid%' ";
			else $cond .=" OR omuid like '%$aomuid%' OR fusion_id like '%$aomuid%' OR red_login_id like '%$aomuid%' ";
		}
		
		if($aname!=="" || $aomuid!="")
		{
			$qSql="Select id,fusion_id,omuid,fname,lname,office_id,status,get_process_names(s.id) as process_names,(Select name from role a  where a.id=s.role_id) as role_name from signin s $cond ";
			echo json_encode($this->Common_model->get_query_result_array($qSql));
			
		}else{
			json_encode(array());
		}
	}
	
} 

 public function getAgentList()
{
	if(check_logged_in())
    {
		$aname = trim($this->input->post('aname'));
		$aomuid = trim($this->input->post('aomuid'));
		$cond="";
		
		if($aname!="") $cond=" Where fname like '%$aname%' OR lname like '%$aname%' ";
		if($aomuid!=""){
			if($cond=="") $cond=" Where omuid like '%$aomuid%' OR fusion_id like '%$aomuid%' OR red_login_id like '%$aomuid%' ";
			else $cond .=" OR omuid like '%$aomuid%' OR fusion_id like '%$aomuid%' OR red_login_id like '%$aomuid%' ";
		}
		if($aname!=="" || $aomuid!="")
		{
			$qSql="Select id,fusion_id,omuid,fname,lname,office_id, status,get_process_names(s.id) as process_names,(Select name from role a  where a.id=s.role_id) as role_name from signin s $cond ";
			
			echo json_encode($this->Common_model->get_query_result_array($qSql));
			
		}else{
			json_encode(array());
		}
	}
	
} 

 
public function get_user_details()
{
	if(check_logged_in())
    {
		$_uid = trim($this->input->get('uid'));
		//$data["error"] = ''; 
		echo json_encode($this->user_model->get_user_details($_uid));
	}
	
} 


public function update_user_not_req()
{
	if(check_logged_in())
    {
		$srole_id= get_role_id();
		$current_user = get_user_id();
		
		$uid = trim($this->input->post('uid'));
		
		$fusion_id = trim($this->input->post('fusion_id'));
		$office_id = trim($this->input->post('office_id'));
		$dept_id = trim($this->input->post('dept_id'));
		$sub_dept_id = trim($this->input->post('sub_dept_id'));
		
		$xpoid = trim($this->input->post('xpoid'));
		$omuid = trim($this->input->post('omuid'));
		$red_login_id = trim($this->input->post('red_login_id'));
		
		$fname = trim($this->input->post('fname'));
		$lname = trim($this->input->post('lname'));
		$sex = trim($this->input->post('sex'));
		
		$role_id = trim($this->input->post('role_id'));
		
		$old_role_id = trim($this->input->post('old_role_id'));
		
		$org_role_id = trim($this->input->post('org_role_id')); 
		
		$site_id = trim($this->input->post('site_id'));
		$process_id = trim($this->input->post('process_id')); 
		
		$assigned_to = trim($this->input->post('assigned_to'));
						
		$email_id = trim($this->input->post('email_id')); 
		
		$phno = trim($this->input->post('phno')); 
		$doj = trim($this->input->post('doj')); 
		$dob = trim($this->input->post('dob')); 
		
		$sub_process_id = trim($this->input->post('sub_process_id'));
		$client_id = trim($this->input->post('client_id'));
		
		$batch_code=trim($this->input->post('batch_code'));
		
		$_field_array = array(
			"fusion_id" => $fusion_id,
			"office_id" => $office_id,
			"dept_id" => $dept_id,
			"sub_dept_id" => $sub_dept_id,
			"fname" => $fname,
			"lname" => $lname,
			"role_id" => $role_id,
		); 
				
		
		$_field_array['xpoid']=$xpoid;
		$_field_array['omuid']=$omuid;
		$_field_array['red_login_id']=$red_login_id;
		
		if($phno!="") $_field_array['phno']=$phno;
		
		if($sex!="") $_field_array['sex']=$sex;
				
		if($doj!=""){
			 $doj=mmddyy2mysql($doj);
			 $_field_array['doj']=$doj;
		}
		
		if($dob!=""){
			 $dob=mmddyy2mysql($dob);
			 $_field_array['dob']=$dob;
		}
		
		if($email_id!=""){
			$_field_array['email_id']=$email_id;
		}
				
		$_field_array['site_id']=$site_id;
		$_field_array['process_id']=$process_id;
		$_field_array['assigned_to']=$assigned_to;
		$_field_array['org_role_id']=$org_role_id;
		
		$_field_array['client_id']=$client_id;
		$_field_array['sub_process_id']=$sub_process_id;
		$_field_array['batch_code']=$batch_code;
		
		if($uid!=""){
			
			$this->db->trans_start();
			/////////////////////////////////
			
			$this->db->where('id', $uid);
			$this->db->update('signin',$_field_array );
			
			if($old_role_id != $role_id){
				
				$log=get_logs();
				
				$evt_date = CurrMySqlDate();
				$cur_date = CurrDate();
				
				$up_his_array = array(
					"endate" => $cur_date,
				);
				
				$this->db->where('user_id', $uid);
				$this->db->where('role_id', $old_role_id);
				$this->db->update('role_history',$up_his_array );
							
				$role_his_array = array(
					"user_id" => $uid,
					"role_id" => $role_id,
					"stdate" => $cur_date,
					"change_date" => $evt_date,
					"change_by" => $current_user,
					"log" => $log,
				); 
						
				$rowid= data_inserter('role_history',$role_his_array);
				
			}
			
			$this->db->trans_complete();
			//////////////
			
			//////////LOG////////
			
			$Lfull_name=get_username();
			$LOMid=get_user_fusion_id();
		
			$LogMSG="Update User Info of $fname $lname ($fusion_id) ";
			log_message('FEMS', $LOMid.' - ' . $Lfull_name . ' | '.$LogMSG );
						
			//////////
			
			$ans="done";
		}else{
			$ans="error";
		}
		echo $ans;
	}
}

public function update_disposition()
	{
		
		$this->load->model('Common_model');
	 
		if(check_logged_in())
		{		
			$uid = trim($this->input->post('uid'));
			$event_master_id = trim($this->input->post('event_master_id'));
			
			//$terms_date = trim($this->input->post('kterms_date'));
			
			$qSql="select count(user_id) as value from terminate_users_pre where user_id ='$uid' and action_status='P'";
			$is_in_preterm=$this->Common_model->get_single_value($qSql);
			
			$qSql="select count(user_id) as value from terminate_users where user_id ='$uid' and is_term_complete='N' and rejon_date is null";
			$is_in_knownterm=$this->Common_model->get_single_value($qSql);
			
			$terms_date = trim($this->input->post('terms_date'));
			
			if($is_in_preterm==0 && $is_in_knownterm==0){
				
				$evt_date=CurrMySqlDate();
				
				if($event_master_id==7){
					
					if($terms_date=="") $terms_date=$evt_date;
					 $start_date =mdyDateTime2MysqlDate($terms_date);
					 $terms_date=mdydt2mysql($terms_date);
					 //$start_date=CurrDate();
				}else{
					$start_date = mmddyy2mysql(trim($this->input->post('start_date')));
				}
				
				$end_date = trim($this->input->post('end_date'));
				$request_type = trim($this->input->post('request_type'));
				$ticket_no = trim($this->input->post('ticket_no'));
				$remarks = trim($this->input->post('remarks'));
				$t_type = trim($this->input->post('t_type'));
				$is_rehire = trim($this->input->post('is_rehire'));
				$sub_t_type = trim($this->input->post('sub_t_type'));
				$request_id = trim($this->input->post('request_id'));
				
				$lwd = trim($this->input->post('lwd'));
				if($lwd != "") $lwd=mmddyy2mysql($lwd);
				
				if($end_date=="") $end_date=$start_date;
				else $end_date=mmddyy2mysql($end_date);
					
										
				$event_by= get_user_id();
				$log=get_logs();
				
				$_field_array = array(
					"user_id" => $uid,
					"event_time" => $evt_date,
					"event_by" => $event_by,
					"event_master_id" => $event_master_id,
					"start_date" => $start_date,
					"end_date" => $end_date,
					"ticket_no" => $ticket_no,
					"remarks" => $remarks,
					"log" => $log
				); 
				
				if($event_master_id==4){
				   $_field_array['request_type']=$request_type;
				}
				
				if($uid!="" && $event_by!="" && $event_master_id!="" && $start_date!="" ){
					
					$this->db->trans_start();
					/////////////////////////////
					
					$this->db->where('id', $uid);
					$this->db->update('signin', array('disposition_id' => $event_master_id));
					
					$event_id = data_inserter('event_disposition',$_field_array);
					
					if($event_id!==false)
					{
						
						if($event_master_id==19){
							
							$in_time= trim($this->input->post('in_time'));
							$break1= trim($this->input->post('break1'));
							$break2= trim($this->input->post('break2'));
							$lunch= trim($this->input->post('lunch'));
							$out_time= trim($this->input->post('out_time'));
							
							if ($in_time !="" && $out_time !="" && $start_date !="" && $uid !=""){
								$_field_array = array(
									"in_time" => $in_time,
									"break1" => $break1,
									"break2" => $break2,
									"lunch" => $lunch,
									"out_time" => $out_time,
									"update_by" => $event_by,
									"update_date" => $evt_date
								); 
								
								$this->db->where('user_id', $uid);
								$this->db->where('shdate', $start_date);
								$this->db->update('user_shift_schedule', $_field_array);
							}
							
						}else if($event_master_id==9){
							
							$this->db->where('id', $uid);
							$this->db->update('signin', array('status' =>'3'));
							
							$_field_array = array(
								"user_id" => $uid,
								"from_date" => $start_date,
								"to_date" => $end_date,
								"request_id" => $request_id,
								"ticket_no" => $ticket_no,
								"comments" => $remarks,
								"evt_by" => $event_by,
								"evt_date" => $evt_date,
								"is_complete" => "N"
									
							);
														
							data_inserter('suspended_users',$_field_array);
							
						}else if($event_master_id==7){
							
							
							$qSql="Select count(id) as value from suspended_users where user_id='".$uid."' and is_complete='N'";
							$rowcount=$this->Common_model->get_single_value($qSql);
							if($rowcount>0){
								$this->updateSuspensionWhenTerm($uid,$start_date,"Update by Term Process");
								$this->updateBenchWhenTerm($uid,$start_date,"Update by Term Process");
								$this->updateFurloughWhenTerm($uid,$start_date,"Update by Term Process");
								//$this->updateUserResignWhenTerm($uid,"Reject by Term Process");
								
							}
														
							$this->db->where('id', $uid);
							$this->db->update('signin', array('status' =>'2'));
							
							$_field_array = array(
								"user_id" => $uid,
								"terms_date" => $terms_date,
								"comments" => $remarks,
								"t_type" => $t_type,
								"is_rehire" => $is_rehire,
								"sub_t_type" => $sub_t_type,
								"terms_by" => $event_by,
								"is_term_complete" => "N",
								"evt_date" => $evt_date
							);
							
							if($lwd != ""){
								$_field_array['lwd']=$lwd;
							}
							
							data_inserter('terminate_users',$_field_array);
						}
						
						$ans="done";
					 
					}else $ans="error";
										
					$this->db->trans_complete();
					///////////////////
					
				}else $ans="error";
				
				if($ans=="done"){
				
				///////////
				
					$disp_name=$this->Common_model->get_single_value("Select description as value from event_master where id='$event_master_id'");
					
					$qSql="select fusion_id,CONCAT(fname,' ' ,lname) as full_name from signin where id='$uid'";
					$query = $this->db->query($qSql);
					$uRow=$query->row_array();
					
					$fusion_id=$uRow["fusion_id"];
					$full_name=$uRow["full_name"];
					
					$Lfull_name=get_username();
					$LOMid=get_user_fusion_id();
					
					$LogMSG="Update Disposition of $full_name ($fusion_id) with $disp_name (DbId: $event_master_id)";
					log_message('FEMS', $LOMid.' - ' . $Lfull_name . ' | '.$LogMSG );
										
					
					log_record($uid, 'Update Disposition', $LogMSG, $this->input->post() , $logs);
				
				//////////
					
					if($event_master_id==7){
						
						$this->Email_model->send_email_submit_ticket($uid,$terms_date,$remarks);
						
					}else if($event_master_id==2){
						
						$this->Email_model->send_email_ncns($uid,$start_date);
						$this->Email_model->send_email_ncns_agent($uid,$start_date);						
					}else{
						$this->Email_model->send_email_loa_req($uid,$start_date);					
					}
					
				}
				
				echo $ans;
				
			}else{
				echo "PRETREM";
			}
		}	
	}
	

public function updateDailyStatus()
	{
	
		if(check_logged_in())
		{		
			$uid = trim($this->input->post('uid'));
			$event_master_id = trim($this->input->post('event_master_id'));
			
			$qSql="select count(user_id) as value from terminate_users_pre where user_id ='$uid' and action_status='P'";
			$is_in_preterm=$this->Common_model->get_single_value($qSql);
			
			$qSql="select count(user_id) as value from terminate_users where user_id ='$uid' and is_term_complete='N' and rejon_date is null";
			$is_in_knownterm=$this->Common_model->get_single_value($qSql);
						
			if($is_in_preterm==0 && $is_in_knownterm==0){
				
				$evt_date=CurrMySqlDate();
				
				$start_date = mmddyy2mysql(trim($this->input->post('start_date')));
				$end_date=$start_date;
									
				$event_by= get_user_id();
				$log=get_logs();
				
				$_field_array = array(
					"user_id" => $uid,
					"event_time" => $evt_date,
					"event_by" => $event_by,
					"event_master_id" => $event_master_id,
					"start_date" => $start_date,
					"end_date" => $end_date,
					"log" => $log
				); 
				
				if($uid!="" && $event_by!="" && $event_master_id!="" && $start_date!="" ){
					
					$this->db->trans_start();
					/////////////////////////////
					$this->db->where('id', $uid);
					$this->db->update('signin', array('disposition_id' => $event_master_id));
					
					$event_id = data_inserter('event_disposition',$_field_array);
					////////////////////////////
					$this->db->trans_complete();
					
					$ans="done";
					
					///////////////////
					
				}else $ans="error";
				
				if($ans=="done"){
				
				///////////
					$disp_name=$this->Common_model->get_single_value("Select description as value from event_master where id='$event_master_id'");
					
					$qSql="select fusion_id,CONCAT(fname,' ' ,lname) as full_name from signin where id='$uid'";
					$query = $this->db->query($qSql);
					$uRow=$query->row_array();
					
					$fusion_id=$uRow["fusion_id"];
					$full_name=$uRow["full_name"];
					
					$Lfull_name=get_username();
					$LOMid=get_user_fusion_id();
					
					$LogMSG="Update Disposition of $full_name ($fusion_id) with $disp_name (DbId: $event_master_id)";
					log_message('FEMS', $LOMid.' - ' . $Lfull_name . ' | '.$LogMSG );
					
				//////////
					if($event_master_id==2){
						
						$this->Email_model->send_email_ncns($uid,$start_date);
						$this->Email_model->send_email_ncns_agent($uid,$start_date);						
					}else{
						$this->Email_model->send_email_loa_req($uid,$start_date);					
					}
				}
				echo $ans;
				
			}else{
				echo "PRETREM";
			}
		}
	}
	
public function update_disposition_bulk()
	{
	
		$this->load->model('Common_model');
	 
		if(check_logged_in())
		{		
			$uids = trim($this->input->post('uids'));
			$disp_id = trim($this->input->post('disp_id'));
			
			$start_date = CurrDate();
			$end_date = CurrDate();
			$event_by= get_user_id();
			
			$Lfull_name=get_username();
			$LOMid=get_user_fusion_id();
			$log=get_logs();
			
			if($uids!="" && $disp_id!=""){
			
				$arrUids = explode(",", $uids);
				for($i=0;$i<count($arrUids);$i++){
				
					$uid=$arrUids[$i];
					
					$_field_array = array(
						"user_id" => $uid,
						"event_time" => CurrMySqlDate(),
						"event_by" => $event_by,
						"event_master_id" => $disp_id,
						"start_date" => $start_date,
						"end_date" => $end_date,
						"log" => $log
					); 
					
					if($uid!="" && $event_by!="" && $disp_id!="" ){
						
						$this->db->where('id', $uid);
						$this->db->update('signin', array('disposition_id' => $disp_id));	
						
						if($this->db->affected_rows()>0){
						
							$event_id = data_inserter('event_disposition',$_field_array);
							
							///////////
							$disp_name=$this->Common_model->get_single_value("Select description as value from event_master where id='$disp_id'");
							
							$qSql="select fusion_id,CONCAT(fname,' ' ,lname) as full_name from signin where id='$uid'";
							$query = $this->db->query($qSql);
							$uRow=$query->row_array();
							
							$fusion_id=$uRow["fusion_id"];
							$full_name=$uRow["full_name"];
							
							
							
							$LogMSG="Update Disposition of $full_name ($fusion_id) with $disp_name (DbId: $disp_id)";
							log_message('FEMS', $LOMid.' - ' . $Lfull_name . ' | '.$LogMSG );
							
							//////////
							//$this->Email_model->send_email_loa_req($uid,$start_date);
						}
						
					}
					
				}
				
				$ans="done";
				
			}else{
				$ans="error";
			}				
			echo $ans;
		}
		
	}
	
 

public function get_pre_term_user_info()
{
	if(check_logged_in())
    {
		
		$uid = trim($this->input->post('uid'));
		$uid=addslashes($uid);
		
		$preRowId = trim($this->input->post('preRowId'));
		$preRowId=addslashes($preRowId);
		
		$qSql="select a.omuid,pre_req_date,last_login_time,last_logout_time,CONCAT(fname,' ' ,lname) as full_name,(Select name from site z  where z.id=a.site_id) as site_name,(select name from process y where y.id=a.process_id) as process_name from signin a left join terminate_users_pre b on a.id=b.user_id where a.id='$uid' and b.id='$preRowId'";
		
		$query = $this->db->query($qSql);
		$uRow=$query->row_array();
		
		$omuid=$uRow["omuid"];
		$full_name=$uRow["full_name"];
		$site_name=$uRow["site_name"];
		$last_login_time=$uRow["last_login_time"];
		$last_logout_time=$uRow["last_logout_time"];
		$pre_req_date=$uRow["pre_req_date"];
		$process_name=$uRow["process_name"];
				
		$html="";
		$html .="<table width='100%'  cellspacing='2' cellpadding='2' style='border:1px solid #ccc;'>";
		$html .="<tr style='background-color: #FFCC00; text-align:center;'> <td style='padding:5px; border:1px solid #ccc;'>Agent Name</td> <td style='padding:5px; border:1px solid #ccc;'>OM ID</td> <td style='padding:5px; border:1px solid #ccc;'>SITE</td><td style='padding:5px; border:1px solid #ccc;'>Process</td><td style='padding:5px; border:1px solid #ccc;'> Last Logout Time</td></tr>";
		
		$html .="<tr style='text-align:center;'> <td style='padding:5px; border:1px solid #ccc;'>$full_name</td> <td style='padding:5px; border:1px solid #ccc;'>$omuid</td> <td style='padding:5px; border:1px solid #ccc;'>$site_name</td><td style='padding:5px; border:1px solid #ccc;'>$process_name</td><td style='padding:5px; border:1px solid #ccc;'>$last_logout_time</td></tr>";
		$html .="</table>";
				
		echo $html;
	}
}


public function getLastLoginInfo()
{
	if(check_logged_in())
    {
		
		$uid = trim($this->input->post('uid'));
		$uid=addslashes($uid);
		

		$qSql="select a.office_id, max(login_time) as last_login_time, max(logout_time) as last_logout_time from signin a left join logged_in_details b on a.id=b.user_id where a.id='$uid'";
		
		//echo $qSql;
		
		$query = $this->db->query($qSql);
		$uRow=$query->row_array();
		$office_id=$uRow["office_id"];
		$last_login_time=$uRow["last_login_time"];
		$last_logout_time=$uRow["last_logout_time"];
		if($last_login_time=="") echo "";
		else echo mysqlDt2mmddyyDate(ConvServerToLocalAny($last_login_time,$office_id));
		
	}
}


public function get_last_disposition()
{
	if(check_logged_in())
    {
		
		$uid = trim($this->input->post('uid'));
		$uid=addslashes($uid);
		
		$qSql="select * from event_disposition where user_id='$uid' order by id desc limit 1";
		
		$query = $this->db->query($qSql);
		$uRow=$query->row_array();
		
		$start_date=mysql2mmddyySls($uRow["start_date"]);
		//$disp_id=$uRow["event_master_id"];
		//$disp_name=$uRow["disp_name"];
		
		echo $start_date;
	}
}

public function get_last_lldate()
{
	if(check_logged_in())
    {
		
		$uid = trim($this->input->post('uid'));
		$uid=addslashes($uid);
		
		$qSql="select date(max(login_time)) as llogin_time, date(max(logout_time)) as llogout_time from logged_in_details where user_id='$uid'";
		
		$query = $this->db->query($qSql);
		$uRow=$query->row_array();
		
		$dtString= mysql2mmddyySls($uRow["llogin_time"]) ."#". mysql2mmddyySls($uRow["llogout_time"]);
		
		echo $dtString;
	}
}


public function get_schedule_info()
{
	if(check_logged_in())
    {
		
		$uid = trim($this->input->post('uid'));
		$uid=addslashes($uid);
		
		$shdate = mmddyy2mysql(trim($this->input->post('shdate')));
		
		$qSql="select * from user_shift_schedule where user_id='$uid' and shdate = '$shdate'";
		//echo $qSql;
		echo json_encode($this->Common_model->get_query_result_array($qSql));
	}
	
}

public function update_pre_term_user_info()
{
	if(check_logged_in())
    {
	
		$uid = trim($this->input->post('pTermUid'));
		$uid=addslashes($uid);
		
		$preRowId = trim($this->input->post('preRowId'));
		$preRowId=addslashes($preRowId);
		
		$next_shift_time = mdydt2mysql(trim($this->input->post('next_shift_time')));
		$terms_time = mdydt2mysql(trim($this->input->post('terms_time')));
				
		$lastDispDt = trim($this->input->post('lastDispDt'));
		if($lastDispDt!=""){
			 $lastDispDt=mmddyy2mysql($lastDispDt);
		}
		
		$terms_by = get_user_id();
		$evt_date = CurrMySqlDate();
		
		$s_dt = date('Y-m-d', strtotime(date($lastDispDt) .'1 day'));
		$e_dt = date('Y-m-d', strtotime(date($next_shift_time) .'-1 day'));
		
		$start = strtotime($s_dt);
		$end = strtotime($e_dt);
	
		$diff = ($end - $start) / 86400; 
		//echo $diff;	
		
		for ($i = 0; $i <= $diff; $i++) {
			$date = $start + ($i * 86400);
			$cDate= date('Y-m-d', $date);
			
			
			$_field_array = array(
				"user_id" => $uid,
				"event_time" => $evt_date,
				"event_by" => $terms_by,
				"event_master_id" => '5',
				"start_date" => $cDate,
				"end_date" => $cDate
			); 
			data_inserter('event_disposition',$_field_array);
			
		}
		
		if($uid!="" && $terms_time!="" && $next_shift_time!=""){
		
			$Update_array = array(
					"is_update" => 'Y',
					"next_shift_time" => $next_shift_time,
					"term_time" => $terms_time,
				);
				
			$this->db->where('user_id', $uid);
			$this->db->where('id', $preRowId);
			$this->db->where('action_status ','P');
			
			$this->db->update('terminate_users_pre', $Update_array);
			
			if($this->db->affected_rows()>0){
			
				//////////LOG////////
							
				$qSql="select fusion_id,CONCAT(fname,' ' ,lname) as full_name from signin where id='$uid'";
				$query = $this->db->query($qSql);
				$uRow=$query->row_array();			
				$fusion_id=$uRow["fusion_id"];
				$full_name=$uRow["full_name"];
				
				$Lfull_name=get_username();
				$LOMid=get_user_fusion_id();
						
				$LogMSG="Pre terminate request of $full_name ($fusion_id) is Updated with NextShift: $next_shift_time and TermTime: $terms_time";
				log_message('FEMS', $LOMid.' - ' . $Lfull_name . ' | '.$LogMSG );
							
				//////////
				//$this->Email_model->send_email_tarms_pre($uid,$preRowId);
			
			}
			
			echo "done";
		}else
			echo "error";
	}
}


public function reject_pre_term_request()
{
	if(check_logged_in())
    {
		$uid = trim($this->input->post('rejPreTermUid'));
		
		$rejPreRowId = trim($this->input->post('rejPreRowId'));
		
		$action_desc = trim($this->input->post('action_desc'));
			
		if($uid!="" && $action_desc!="" && $rejPreRowId!=""){
			
			$current_user = get_user_id();
			$evt_date = CurrMySqlDate();
			$action_status="R";
			
			$Update_array = array(
					"action_status" =>$action_status,
					"action_desc" => $action_desc,
					"action_by" => $current_user,
					"action_time" => $evt_date,
				);
			
			$this->db->where('user_id', $uid);
			$this->db->where('id', $rejPreRowId);
			$this->db->where('action_status ','P');
			$this->db->update('terminate_users_pre', $Update_array);
			
			if($this->db->affected_rows()>0){
			
				$agent_name=$this->Common_model->get_single_value("Select CONCAT(fname,' ' ,lname) as value from signin where id='$uid'");
				$rej_by=$this->Common_model->get_single_value("Select CONCAT(fname,' ' ,lname) as value from signin where id='$current_user'");
				
				//$esubject="Pre terminate request of ".$agent_name." is canceled by ".$rej_by." on ".$evt_date;
				
				$esubject=" Pre terminate request is canceled ";
				
				$body="<b>Pre terminate request is canceled by ".$rej_by." on ".$evt_date."<br><br>".$action_desc."<b>";
				//send email reject 
				
				//////////LOG////////
							
				$qSql="select fusion_id,CONCAT(fname,' ' ,lname) as full_name from signin where id='$uid'";
				$query = $this->db->query($qSql);
				$uRow=$query->row_array();			
				$fusion_id=$uRow["fusion_id"];
				$full_name=$uRow["full_name"];
				
				$Lfull_name=get_username();
				$Lfusion_id=get_user_fusion_id();
						
				$LogMSG="Pre terminate request of $full_name ($fusion_id) is canceled ";
				log_message('FEMS', $Lfusion_id.' - ' . $Lfull_name . ' | '.$LogMSG );
							
				//////////
					
				//$this->Email_model->send_email_reject_pre_tarms($uid,$rejPreRowId,$body,$esubject);
			}
				
			echo "done";
		}else
			echo "error";
			
	}
	
}

public function user_act_deact()
{
	if(check_logged_in())
    {
		$evt_by = get_user_id();
		$evt_date = CurrMySqlDate();
		
		$_uid = trim($this->input->post('uid'));
		$_sid = trim($this->input->post('sid'));
		
		if($_uid!=""){
			$this->db->where('id', $_uid);
			$this->db->update('signin', array('status' => $_sid));
			
			$qSql="select fusion_id, CONCAT(fname,' ' ,lname) as full_name from signin where id='$_uid'";
			$query = $this->db->query($qSql);
			$uRow=$query->row_array();
			
			$evtfusion_id=$uRow["fusion_id"];
			$evtfull_name=$uRow["full_name"];
			
			$Lfull_name=get_username();
			$Lfusion_id=get_user_fusion_id();
			
			$LogMSG="Activate/Deactivate for User $evtfull_name , Fusion id: $evtfusion_id";
			log_message('FEMS', $Lfusion_id.' - ' . $Lfull_name . ' | '.$LogMSG );
			
			$ans="done";
		}else{
			$ans="error";
		}
		echo $ans;
	}
}


public function setGlobalAccess()
{
	if(check_logged_in())
    {
		$evt_by = get_user_id();
		$evt_date = CurrMySqlDate();
		
		$_uid = trim($this->input->post('uid'));
		$cgval = trim($this->input->post('cgval'));
		if($cgval==1)$cgval=0;
		else $cgval=1;
		if($_uid!=""){
			$this->db->where('id', $_uid);
			$this->db->update('signin', array('is_global_access' => $cgval));
			
			
			$qSql="select fusion_id, CONCAT(fname,' ' ,lname) as full_name from signin where id='$_uid'";
			$query = $this->db->query($qSql);
			$uRow=$query->row_array();
			
			$evtfusion_id=$uRow["fusion_id"];
			$evtfull_name=$uRow["full_name"];
			
			$Lfull_name=get_username();
			$Lfusion_id=get_user_fusion_id();
			
			$LogMSG="Global Access for User $evtfull_name , Fusion id: $evtfusion_id";
			log_message('FEMS', $Lfusion_id.' - ' . $Lfull_name . ' | '.$LogMSG );
			
			$ans="done";
		}else{
			$ans="error";
		}
		echo $ans;
	}
}

public function reset_password()
{
	if(check_logged_in())
    {
		$_uid = trim($this->input->post('uid'));	
		if($_uid!=""){
			
			$current_user = get_user_id();
			
			$uSql="Update signin set passwd = md5(fusion_id), is_update_pswd='N' where id='".$_uid."'";
			//echo $uSql;
			$this->db->query($uSql);
			
			$update_by = $current_user;
			$update_date = CurrMySqlDate();
			$log=get_logs();
		
			$_field_array = array(
				"user_id" => $_uid,
				"update_date" => $update_date,
				"update_by" => $update_by,
				"log" => $log
			); 
			
			data_inserter('user_reset_psswd_log',$_field_array);
			
			//////////LOG////////
						
			$qSql="select fusion_id,omuid,CONCAT(fname,' ' ,lname) as full_name from signin where id='$uid'";
			$query = $this->db->query($qSql);
			$uRow=$query->row_array();			
			$omuid=$uRow["fusion_id"];
			$full_name=$uRow["full_name"];
			
			$Lfull_name=get_username();
			$LOMid=get_user_omuid();
					
			$LogMSG="Reset Password of $full_name ($omuid) ";
			log_message('FEMS', $LOMid.' - ' . $Lfull_name . ' | '.$LogMSG );
						
			//////////
			
			
			$ans="done";
		}else{
			$ans="error";
		}
		echo $ans;
	}
}



// for Complete pre terminate users (NCNS)
public function terminate_user()
{
	if(check_logged_in())
    {
		$current_user = get_user_id();
					
		$uid = trim($this->input->post('tuid'));
		
		$ticket_no = trim($this->input->post('ticket_no'));
		$comments = trim($this->input->post('comments'));
		
		$terms_date = trim($this->input->post('terms_date'));
		if($terms_date!=""){
		
			 $start_date =mdyDateTime2MysqlDate($terms_date);
			 $end_date=$start_date;
			 
			 $terms_date=mdydt2mysql($terms_date);
			 
		}
		
		$ticket_date = trim($this->input->post('ticket_date'));
		
		if($ticket_date!=""){
			 $ticket_date=mdydt2mysql($ticket_date);
		}
		
		
		
			$terms_by = $current_user;
			$evt_date = CurrMySqlDate();
		
			$_field_array = array(
				"user_id" => $uid,
				"terms_date" => $terms_date,
				"ticket_no" => $ticket_no,
				"ticket_date" => $ticket_date,
				"comments" => $comments,
				"terms_by" => $terms_by,
				"is_term_complete" => "Y",
				"evt_date" => $evt_date,
			); 
			
			if($uid!="" && $terms_date!=""){
				
				$Update_array = array(
					"action_status" => 'T',
					"action_desc" => $comments,
					"action_by" => $terms_by,
					"action_time" => $evt_date,
				);
			
				$this->db->where('user_id', $uid);
				$this->db->where('action_status ','P');
				$this->db->update('terminate_users_pre', $Update_array);
				
				if($this->db->affected_rows()>0){
				
					data_inserter('terminate_users',$_field_array);
					
					$this->db->where('id', $uid);
					$this->db->update('signin', array('status' =>'0','disposition_id' =>'7'));
					
					//////////////////////
					
					$_field_array = array(
						"user_id" => $uid,
						"event_time" => $evt_date,
						"event_by" => $terms_by,
						"event_master_id" => '7',
						"start_date" => $start_date,
						"end_date" => $end_date,
						"ticket_no" => $ticket_no,
						"remarks" => $comments,
					); 
					
					data_inserter('event_disposition',$_field_array);
					
					
					
							
						$qSql="select omuid,CONCAT(fname,' ' ,lname) as full_name from signin where id='$uid'";
						$query = $this->db->query($qSql);
						$uRow=$query->row_array();
						
						$omuid=$uRow["omuid"];
						$full_name=$uRow["full_name"];
						
						$Lfull_name=get_username();
						$LOMid=get_user_omuid();
								
						$LogMSG=" Terminate User $full_name ($omuid) Ticket no: $ticket_no";
						log_message('FEMS', $LOMid.' - ' . $Lfull_name . ' | '.$LogMSG );
						
						//////////
						$this->Email_model->send_email_tarms($uid,$ticket_no,$ticket_date,$comments);
						
					}
			
			$ans="done";
			
		}else{
			$ans="error";
		}
		echo $ans;
	}
}

// final known term 
public function update_termination_ticket()
{
	
	if(check_logged_in())
    {
		$current_user = get_user_id();	
		$uid = trim($this->input->post('ut_uid'));
		
		$request_id = trim($this->input->post('ut_request_id'));
		$ticket_no = trim($this->input->post('ut_ticket_no'));
				
		$ticket_date = trim($this->input->post('ut_ticket_date'));
		
		$term_comments = trim($this->input->post('t_comments'));
		
		if($ticket_date!=""){
			 $ticket_date=mdydt2mysql($ticket_date);
		}
		
		$lwd = trim($this->input->post('lwd'));
		if($lwd != "") $lwd=mmddyy2mysql($lwd);
		
		//$comments = trim($this->input->post('ut_comments'));
		//if($uid!="" && $ticket_no!="" && $ticket_date!=""){
						
		if($uid!=""){
			
			//$user_term_date=$this->Common_model->get_single_value("SELECT date(terms_date)as value FROM `terminate_users` where user_id='$uid' and is_term_complete = 'N'");
				
			$term_id=$this->Common_model->get_single_value("SELECT max(id) as value FROM terminate_users where user_id='$uid' and is_term_complete = 'N'");
		
			$log= get_logs();
			
			$update_by = $current_user;
			$update_date = CurrMySqlDate();
		
			$_Ufield_array = array(
				"user_id" => $uid,
				"update_by" => $update_by,
				"is_term_complete" => "Y",
				"update_date" => $update_date,
			); 
		
		if($request_id!="")$_Ufield_array['request_id']=$request_id;
		if($ticket_no!="")$_Ufield_array['ticket_no']=$ticket_no;
		if($ticket_date!="")$_Ufield_array['ticket_date']=$ticket_date;
		if($lwd != "") $_Ufield_array['lwd']=$lwd;
		if($term_comments != "") $_Ufield_array['comments']=$term_comments;
		
		
		$this->db->where('user_id', $uid);
		$this->db->where('is_term_complete ','N');
		$this->db->update('terminate_users', $_Ufield_array);
		
		if($this->db->affected_rows()>0){
		
			$this->db->where('id', $uid);
			$this->db->update('signin', array('status' =>'0'));
			
			
			$this->updateUserResignWhenTerm($uid,"Reject by Final Term Process");
			
			////////////
			
			
			
			$_field_array = array(
				"term_id" => $term_id,
				"user_id" => $uid,
				"it_helpdesk_status" => 'P',
				"it_security_status" => 'P',
				"payroll_status" => 'P',
				"fnf_status" => 'P',
				"updated" => $update_date,
				"date_added" => $update_date,
				"log" => $log
			);
							
			data_inserter('user_fnf',$_field_array);
					
							
			///////////////////////////////////////////////////
							
			$qSql="select omuid,fusion_id, CONCAT(fname,' ' ,lname) as full_name from signin where id='$uid'";
			$query = $this->db->query($qSql);
			$uRow=$query->row_array();
			
			$fusion_id=$uRow["fusion_id"];
			$full_name=$uRow["full_name"];
					
			$Lfull_name=get_username();
			$LOMid=get_user_omuid();
					
			$LogMSG=" Upadete Terminate User info of $full_name ($fusion_id) Ticket no: $ticket_no";
			log_message('FEMS', $LOMid.' - ' . $Lfull_name . ' | '.$LogMSG );
			
			$logs=get_logs();
			log_record($uid,'Final Term', $LogMSG,  $this->input->post() , $logs);
					
			///
			$this->Email_model->send_email_tarms($uid,$ticket_no,$ticket_date,"");
			
			$this->Email_model->send_fnf_email($user_id,"term",$lwd);
			
			/////
			$this->user_model->update_after_term_l1_supervisor($uid);
			
		}
			
			$ans="done";
		}else{
			
			$ans="error";
		}
		
		echo $ans;
		
	}
	
}


	
public function cancelSuspension()
{
	if(check_logged_in())
    {
		
		$evt_date = CurrMySqlDate();
		$current_user = get_user_id();
		
		$csuid = trim($this->input->post('csuid'));
		
		$final_return_date = trim($this->input->post('final_return_date'));
		
		$update_comments = trim($this->input->post('update_comments'));	
		
		
		
		if($csuid!="" && $final_return_date!=""){
			
			$this->db->update("signin",array("status"=>'1',"disposition_id"=>'1'),array("id"=>$csuid));
			
			$final_return_date=mmddyy2mysql($final_return_date);
			$update_array = array(
						"final_return_date" => $final_return_date,
						"update_date" => $evt_date,
						"update_by" => $current_user,
						"update_comments" => $update_comments,
						"is_complete" => "Y"
					);
					
			$this->db->where('user_id', $csuid);
			$this->db->where('is_complete', 'N');
			$this->db->update('suspended_users',$update_array );
			
			$qSql="select id as value from event_disposition where user_id='$csuid' and event_master_id=9 order by id desc limit 1";
			$disp_row_id=$this->Common_model->get_single_value($qSql);
			
			$update_array = array(
				"end_date" => $final_return_date
			);
			
			$this->db->where('user_id', $csuid);
			$this->db->where('id', $disp_row_id);
			$this->db->update('event_disposition',$update_array );
			
			//////////LOG////////
						
			$qSql="select fusion_id,omuid,CONCAT(fname,' ' ,lname) as full_name from signin where id='$csuid'";
			$query = $this->db->query($qSql);
			$uRow=$query->row_array();			
			$omuid=$uRow["fusion_id"];
			$full_name=$uRow["full_name"];
			
			$Lfull_name=get_username();
			$LOMid=get_user_omuid();
					
			$LogMSG="Cancel Suspension of $full_name ($omuid) ";
			log_message('FEMS', $LOMid.' - ' . $Lfull_name . ' | '.$LogMSG );
			
			$logs=get_logs(); 
			log_record($csuid,'Cancel_Suspension', $LogMSG,  $this->input->post() , $logs);
					
			//////////
			
			
			$ans="done";
		}else{
			$ans="error";
		}
		echo $ans;
	}
	
}


public function cancel_termination()
{
	if(check_logged_in())
    {
		echo $uid = trim($this->input->post('uid'));
		$update_remarks = trim($this->input->post('ct_update_remarks'));
		$current_user = get_user_id();
		$user_fid = get_user_fusion_id();
		
		if($uid!=""){
							
				$update_date=CurrMySqlDate();
				$update_by = get_user_id();
				$log=get_logs();
				
				$tfusion_id=$this->Common_model->get_single_value("Select fusion_id as value from signin where id='$uid'");
				
				$user_term_date=$this->Common_model->get_single_value("SELECT date(terms_date)as value FROM `terminate_users` where user_id='$uid' and is_term_complete = 'N'");
				
				$this->db->trans_begin();
				
				$Update_array = array(
					"is_term_complete" => 'R',
					"update_remarks" => $update_remarks,
					"update_date" => $update_date,
					"update_by" => $update_by
					
				);
									
				$this->db->where('user_id', $uid);
				$this->db->where('is_term_complete', 'N');
				$this->db->update('terminate_users', $Update_array);

				$Update_array = array(
					"status" => '1',
					"disposition_id" => '1',
					"is_logged_in" => '0'
				);
										
				$curl_array = array(
					"uid" => $current_user,
					"fid" => $user_fid,
					"tfusion_id" => $tfusion_id,
					"is_term_complete" => 'R',
					"update_remarks" => $update_remarks,
					"update_date" => $update_date,
					"update_by" => $update_by,
					"log" => $log
				); 
			   					
				$this->db->where('id', $uid);
				$this->db->update('signin', $Update_array);
				
				$this->db->delete('event_disposition', array('user_id' => $uid,'event_master_id'=>'7', 'start_date'=>$user_term_date));
								
				$this->db->trans_complete();						
				////////////////////////////		
				
				if($this->db->trans_status() === FALSE){
					//echo "Failed DB Error Try Again";	
					$this->db->trans_rollback();
					$ans="error";
				}else{
						
					$this->db->trans_commit();
											
					$qSql="select omuid,fusion_id,CONCAT(fname,' ' ,lname) as full_name from signin where id='$uid'";
					$query = $this->db->query($qSql);
					$uRow=$query->row_array();
					
					$fusion_id=$uRow["fusion_id"];
					$full_name=$uRow["full_name"];
					
					$Lfull_name=get_username();
					$LOMid=get_user_omuid();
				
					$LogMSG=" Cancel Terminate of $full_name ($fusion_id) ";
					log_message('FEMS', $LOMid.' - ' . $Lfull_name . ' | '.$LogMSG );
					
					$logs=get_logs(); 
					log_record($uid,'cancel_termination', $LogMSG,  $this->input->post() , $logs);
				
					$ans="DONE";														   
				}
					
		}else{
			$ans="error";
		}
		echo $ans;
	}	
}

/////////////////


public function rejoin_term_user()
{
	if(check_logged_in())
    {
		$uid = trim($this->input->post('rjuid'));
		$remarks = trim($this->input->post('remarks'));
		$rejoin_date=trim($this->input->post('rejoin_date'));
		
		if($uid!="" && $rejoin_date!=""){
							
				$evt_date=CurrMySqlDate();
				
				$start_date = mmddyy2mysql($rejoin_date);
				$end_date=$start_date;
				
				$event_by= get_user_id();
				$log=get_logs();
				
				$_field_array = array(
					"user_id" => $uid,
					"event_time" => $evt_date,
					"event_by" => $event_by,
					"event_master_id" => '8',
					"start_date" => $start_date,
					"end_date" => $end_date,
					"remarks" => $remarks,
					"log" => $log
				); 
				
				if($uid!="" && $event_by!="" ){
					
					$this->db->trans_start();
					/////////////////////////////
					
					$this->db->update("signin",array("status"=>1,"disposition_id" =>1),array("id"=>$uid));
					
					$this->db->update("terminate_users",array("rejon_date"=>$start_date),array("user_id"=>$uid,"rejon_date" =>null));
					
					$event_id = data_inserter('event_disposition',$_field_array);
					
					$this->db->update("user_fnf",array("fnf_status"=>"R"),array("user_id"=>$uid));
					
					$this->db->trans_complete();
					
					$ans="done";
					$rj_msg="Rejoin ";
			}else{

				$rj_msg="Fail to Rejoin ";
				$ans="error";
			}
					
					
				//////////LOG////////
							
				$qSql="select fusion_id,omuid,CONCAT(fname,' ' ,lname) as full_name from signin where id='$uid'";
				$query = $this->db->query($qSql);
				$uRow=$query->row_array();			
				$omuid=$uRow["omuid"];
				$full_name=$uRow["full_name"];
				
				$Lfull_name=get_username();
				$LOMid=get_user_omuid();
						
				$LogMSG=$rj_msg." the $full_name ($omuid) ";
				log_message('FEMS', $LOMid.' - ' . $Lfull_name . ' | '.$LogMSG );
							
				//////////
			
			
		}else{
			$ans="error";
		}
		echo $ans;
	}
	
}

	

public function save_manual_login_details_not_used()
{
	
	if(check_logged_in())
    {
		$current_user = get_user_id();	
		
		$uid = trim($this->input->post('uid'));
		$login_time = trim($this->input->post('login_time'));
		$logout_time = trim($this->input->post('logout_time'));
		$disp_id = trim($this->input->post('disp_id'));
		$comments = trim($this->input->post('comments'));
				
		if($uid!="" && $login_time!="" && $logout_time!=""){
			
			if($login_time!="")$login_time=mdydt2mysql($login_time);
			if($logout_time!="")$logout_time=mdydt2mysql($logout_time);
		
			$added_by = $current_user;
			$added_time = CurrMySqlDate();
			$log=get_logs();
			
		$_sfield_array = array(
			"user_id" => $uid,
			"login_time" => $login_time,
			"logout_time" => $logout_time,
			"disp_id" => $disp_id,
			"added_by" => $added_by,
			"added_time" => $added_time,
			"comments" => $comments,
			"log" => $log
		); 
			
		$rowid= data_inserter('logged_in_details_manual',$_sfield_array);
		if($rowid!=false){
				///
				
				$qSql="select omuid,CONCAT(fname,' ' ,lname) as full_name from signin where id='$uid'";
				$query = $this->db->query($qSql);
				$uRow=$query->row_array();
				
				$omuid=$uRow["omuid"];
				$full_name=$uRow["full_name"];
						
				$Lfull_name=get_username();
				$LOMid=get_user_omuid();
						
				$LogMSG="Added Manual Login Details of $full_name ";
				log_message('FEMS', $LOMid.' - ' . $Lfull_name . ' | '.$LogMSG );	
				
			}
			$ans="done";
		}else{			
			$ans="error";
		}
		echo $ans;
	}
	
}




public function save_manual_login_details()
{
	
	if(check_logged_in())
    {
		$current_user = get_user_id();	
		
		$uid = trim($this->input->post('uid'));
		$login_date = trim($this->input->post('login_date'));
		$login_time = trim($this->input->post('login_time'));
				
		$logout_date = trim($this->input->post('logout_date'));
		$logout_time = trim($this->input->post('logout_time'));
		
		$disp_id = trim($this->input->post('disp_id'));
		$comments = trim($this->input->post('comments'));
				
		if($uid!="" && $login_date!="" && $login_time!="" && $logout_date!="" && $logout_time!=""){
			
			if($login_date!="") $login_time=mmddyy2mysql($login_date).' '.$login_time;
			if($logout_date!="") $logout_time=mmddyy2mysql($logout_date).' '.$logout_time;
				
			$added_by = $current_user;
			$added_time = CurrMySqlDate();
			$log=get_logs();
			
		$_sfield_array = array(
			"user_id" => $uid,
			"login_time" => $login_time,
			"logout_time" => $logout_time,
			"disp_id" => $disp_id,
			"added_by" => $added_by,
			"added_time" => $added_time,
			"comments" => $comments,
			"log" => $log
		); 
		
		//print_r($_sfield_array);
		
		$rowid= data_inserter('logged_in_details_manual',$_sfield_array);
		if($rowid!=false){
				///
				
				$qSql="select omuid,CONCAT(fname,' ' ,lname) as full_name from signin where id='$uid'";
				$query = $this->db->query($qSql);
				$uRow=$query->row_array();
				
				$omuid=$uRow["omuid"];
				$full_name=$uRow["full_name"];
						
				$Lfull_name=get_username();
				$LOMid=get_user_omuid();
						
				$LogMSG="Added Manual Login Details of $full_name ";
				log_message('FEMS', $LOMid.' - ' . $Lfull_name . ' | '.$LogMSG );	
				
			}
			$ans="done";
		}else{			
			$ans="error";
		}
		echo $ans;
	}
	
}


public function save_manual_login_details_any()
{
	
	if(check_logged_in())
    {
		$current_user = get_user_id();	
		
		$agent_fusion_id = trim($this->input->post('agent_fusion_id'));
		$login_date = trim($this->input->post('mlogin_date'));
		$login_time = trim($this->input->post('mlogin_time'));
				
		$logout_date = trim($this->input->post('mlogout_date'));
		$logout_time = trim($this->input->post('mlogout_time'));
		
		$disp_id = trim($this->input->post('mdisp_id'));
		$comments = trim($this->input->post('mcomments'));
		
		if($agent_fusion_id!="" && $login_date!="" && $login_time!="" && $logout_date!="" && $logout_time!=""){
			
			$qSql="Select id as value from signin Where fusion_id = '$agent_fusion_id'";
			$user_id = $this->Common_model->get_single_value($qSql);
				
			if($login_date!="") $login_time=mmddyy2mysql($login_date).' '.$login_time;
			if($logout_date!="") $logout_time=mmddyy2mysql($logout_date).' '.$logout_time;
		
			$added_by = $current_user;
			$added_time = CurrMySqlDate();
			$log=get_logs();
			
		$_sfield_array = array(
			"user_id" => $user_id,
			"login_time" => $login_time,
			"logout_time" => $logout_time,
			"disp_id" => $disp_id,
			"added_by" => $added_by,
			"added_time" => $added_time,
			"comments" => $comments,
			"log" => $log
		); 
			
		$rowid= data_inserter('logged_in_details_manual',$_sfield_array);
		if($rowid!=false){
				///
				
				$qSql="select omuid,CONCAT(fname,' ' ,lname) as full_name from signin where id='$user_id'";
				$query = $this->db->query($qSql);
				$uRow=$query->row_array();
				
				$omuid=$uRow["omuid"];
				$full_name=$uRow["full_name"];
						
				$Lfull_name=get_username();
				$LOMid=get_user_omuid();
						
				$LogMSG="Added Manual Login Details of $full_name ";
				log_message('FEMS', $LOMid.' - ' . $Lfull_name . ' | '.$LogMSG );	
				
			}
			$ans="done";
		}else{			
			$ans="error";
		}
		echo $ans;
	}
	
}



		
public function update_user_info()
{

	
	if(check_logged_in())
    {
	
		$data["aside_template"] = get_aside_template();
		//$data["aside_template"] = "user/aside.php";
		
		$data["content_template"] = "user/update_user_info.php";
		$data["error"] = ''; 
		
		$sUid=get_user_id();
		
		//if($this->input->post('submit')=="Update")
		if($this->input->post('submit'))
		{
				
				$uid = trim($this->input->post('uid'));
				$email_id = trim($this->input->post('email_id')); 
				$phno = trim($this->input->post('phno'));
				$xpoid = trim($this->input->post('xpoid')); 
				
				if($uid==$sUid){
				
					$_field_array = array(
						"phno" => $phno,
						"email_id" => $email_id,
						"xpoid" => $xpoid
					);
					
					//print_r($_field_array);
					
					if($uid!=""){
						$this->db->where('id', $uid);
						$this->db->update('signin',$_field_array );
						
						//////////LOG////////
						
						$Lfull_name=get_username();
						$LOMid=get_user_omuid();
					
						$LogMSG="Update Contacts Information with $email_id , $phno of user_id $uid ";
						log_message('FEMS', $LOMid.' - ' . $Lfull_name . ' | '.$LogMSG );						
						//////////
						//$ans="done";
					}else{
						//$ans="error";
					}
					
					//echo $ans;
				}	
		}
		
		$qSql="Select id,phno,email_id,xpoid,doj from signin where id='$sUid'";
		$data['user_info'] = $this->Common_model->get_query_result_array($qSql);
		
		$this->load->view('dashboard',$data);
		 
	}
	
}

	
public function break_on()
	{
		if(check_logged_in())
		{
			
			$current_user = get_user_id();
			$_field_array = array(
								"last_break_on_time" => date("Y-m-d H:i:s"),
								"is_break_on" => 1
							);
			
			$this->db->update("signin",$_field_array,array("id"=>$current_user));
			
			//////////LOG////////
			
			$Lfull_name=get_username();
			$LOMid=get_user_omuid();
					
			$LogMSG="Others Break Timer on";
			log_message('FEMS', $LOMid.' - ' . $Lfull_name . ' | '.$LogMSG );
						
			//////////
			
			
			if($this->user_model->check_dialer_logged_in($current_user)===true) print true;
			else print false;
		}
	}
	
	public function break_off()
	{
		if(check_logged_in())
		{
			$current_user = get_user_id();
			$log=get_logs();
			$currDate=CurrMySqlDate();	
			
			$out_time = $this->user_model->get_break_on_time($current_user);
			$out_time_local = getEstToLocalCurrUser($out_time);
			$in_time_local= getEstToLocalCurrUser($currDate);
			
			$_insert_array = array(
					"user_id" => $current_user,
					"out_time" => $out_time,
					"out_time_local" => $out_time_local,
					"in_time" => $currDate,
					"in_time_local" => $in_time_local,
					"log" => $log
				);
				
			$_table = "break_details";			
			
			if($this->user_model->check_break_on($current_user)===true)
			{
				//$uSql="Update signin set last_logged_date=NULL,disposition_id=1,is_logged_in=0 where id=".$current_user;
				//$this->db->query($uSql);
				
				$this->db->update("signin",array("last_break_on_time"=>"NULL","is_break_on" =>0),array("id"=>$current_user));
				
				$this->db->insert($_table,$_insert_array);
				
				//////////LOG////////
				$Lfull_name=get_username();
				$LOMid=get_user_omuid();
						
				$LogMSG="Others Break Timer off";
				log_message('FEMS', $LOMid.' - ' . $Lfull_name . ' | '.$LogMSG );
				//////////
				
				if($this->db->affected_rows() > 0) print true;
				else print false;	
			} 
			else print false;
		}
		
	}
	
	
	public function break_on_ld()
	{
		if(check_logged_in())
		{
			
			$current_user = get_user_id();
			$_field_array = array(
					"last_break_on_time_ld" => date("Y-m-d H:i:s"),
					"is_break_on_ld" => 1
				);
			
			$this->db->update("signin",$_field_array,array("id"=>$current_user));
			
			//////////LOG////////
			
			$Lfull_name=get_username();
			$LOMid=get_user_omuid();
					
			$LogMSG="Lunch/Dinner Break Timer on";
			log_message('FEMS', $LOMid.' - ' . $Lfull_name . ' | '.$LogMSG );
						
			//////////
						
			if($this->user_model->check_dialer_logged_in($current_user)===true) print true;
			else print false;
		}
	}
	
	public function break_off_ld()
	{
		if(check_logged_in())
		{
			$current_user = get_user_id();
			$currDate=CurrMySqlDate();
			$log=get_logs();
			
			$out_time = $this->user_model->get_break_on_time_ld($current_user);
			$out_time_local = getEstToLocalCurrUser($out_time);
			$in_time_local= getEstToLocalCurrUser($currDate);
								
			$_insert_array = array(
					"user_id" => $current_user,
					"out_time" => $out_time,
					"out_time_local" => $out_time_local,
					"in_time" => $currDate,
					"in_time_local" => $in_time_local,
					"log" => $log
				);
			
			$_table = "break_details_ld";			
			
			if($this->user_model->check_break_on_ld($current_user)===true)
			{
				//$uSql="Update signin set last_logged_date=NULL,disposition_id=1,is_logged_in=0 where id=".$current_user;
				//$this->db->query($uSql);
				
				$this->db->update("signin",array("last_break_on_time_ld"=>"NULL","is_break_on_ld" =>0),array("id"=>$current_user));
				
				$this->db->insert($_table,$_insert_array);
				
				//////////LOG////////
				$Lfull_name=get_username();
				$LOMid=get_user_omuid();
						
				$LogMSG="Lunch/Dinner Timer off";
				log_message('FEMS', $LOMid.' - ' . $Lfull_name . ' | '.$LogMSG );
				//////////
				
				if($this->db->affected_rows() > 0) print true;
				else print false;	
			} 
			else print false;
		}
		
	}
		
		

	////////////////////////////////////////////////////////////////////////////////////////////////////////
	// Update login details
	////////////////////////////////////////////////////////////////////////////////////////////////////////
	
	public function loggin_to_dialer()
	{
		if(check_logged_in())
		{
			$current_user = get_user_id();
					
			$_field_array = array(
								"last_logged_date" => date("Y-m-d H:i:s"),
								"is_logged_in" => 1,
								"disposition_id" =>0
							);
			
			$this->db->update("signin",$_field_array,array("id"=>$current_user));
			
			if($this->user_model->check_dialer_logged_in($current_user)===true) print true;
			else print false;
		}
	}
	
	////////////////////////////////////////////////////////////////////////////////////////////////////////
	// Update dialer logout details
	////////////////////////////////////////////////////////////////////////////////////////////////////////
	
	public function logout_from_dialer()
	{
		if(check_logged_in())
		{
			$current_user = get_user_id();
			$log=get_logs();
			
			$currDate=CurrMySqlDate();	
			//"logout_time" => date("Y-m-d H:i:s"),
			$login_time = $this->user_model->get_dialer_logged_in_time($current_user);
			$login_time_local = getEstToLocalCurrUser($login_time);
			$logout_time_local= getEstToLocalCurrUser($currDate);
			
			$_insert_array = array(
					"user_id" => $current_user,
					"login_time" => $login_time,
					"login_time_local" => $login_time_local,
					"logout_time" => $currDate,
					"logout_time_local" => $logout_time_local,
					"logout_by"	=> $current_user,
					"log" => $log
			);
			
			$_table = "logged_in_details";			
			
			if($this->user_model->check_dialer_logged_in($current_user)===true)
			{
				$this->db->update("signin",array("last_logged_date"=>"","disposition_id"=>1,"is_logged_in" =>0),array("id"=>$current_user));
			
				$this->db->insert($_table,$_insert_array);
				if($this->db->affected_rows() > 0) print true;
				else print false;	
			} 
			else print false;
		}
	}
	
	private function check_access()
	{
		$is_global_access=get_global_access();
		if( get_role_dir()=="agent" && $is_global_access !=1 && get_dept_folder() !="hr" && get_dept_folder() !="rta" && get_dept_folder() !="wfm" ) redirect(base_url()."home","refresh");
	}
	
	
	public function select_process(){
		$set_array = array ();
				if(check_logged_in())
				{
						$client_id = $this->input->get('client_id');

						$SQLtxt = "SELECT id,name FROM process where client_id in($client_id) and is_active=1 order by name";
						$fields = $this->db->query($SQLtxt);
						
							$process_data =  $fields->result_array();
							  
							echo  json_encode($process_data);
					 
				}
		}
		 
////////////////////////////////////////////////////////

	public function get_consultancy_info(){
		
			$data_type = trim($this->input->get('val1'));
			
			if($data_type == 'Job Portal')
			{
				$qSql="SELECT id, job_portal as name from master_job_portal_list";
				echo json_encode($this->Common_model->get_query_result_array($qSql));
			}
			else if($data_type == 'Consultancy')
			{
				$query = "SELECT id, consultancy as name from master_consultancy_list'";
				echo json_encode($this->Common_model->get_query_result_array($qSql));
			}
			
	}
	
	
//////////////////////////////////////////	


private function updateSuspensionWhenTerm($csuid,$final_return_date,$update_comments)
{
	if(check_logged_in())
    {
		
		$evt_date = CurrMySqlDate();
		$current_user = get_user_id();
		
		if($csuid!="" && $final_return_date!=""){
			
			//$this->db->update("signin",array("status"=>'1',"disposition_id"=>'1'),array("id"=>$csuid));
			//$final_return_date=mmddyy2mysql($final_return_date);
			
			$update_array = array(
						"final_return_date" => $final_return_date,
						"update_date" => $evt_date,
						"update_by" => $current_user,
						"update_comments" => $update_comments,
						"is_complete" => "Y"
					);
					
			$this->db->where('user_id', $csuid);
			$this->db->where('is_complete', "N");
			$this->db->update('suspended_users',$update_array );
			
			$qSql="select id as value from event_disposition where user_id='$csuid' and event_master_id=9 order by id desc limit 1";
			$disp_row_id=$this->Common_model->get_single_value($qSql);
			if($disp_row_id!=""){
				$update_array = array(
					"end_date" => $final_return_date
				);
				
				$this->db->where('user_id', $csuid);
				$this->db->where('id', $disp_row_id);
				$this->db->update('event_disposition',$update_array );
				
							
				//////////LOG////////
							
				$qSql="select fusion_id,omuid,CONCAT(fname,' ' ,lname) as full_name from signin where id='$csuid'";
				$query = $this->db->query($qSql);
				$uRow=$query->row_array();			
				$omuid=$uRow["omuid"];
				$full_name=$uRow["full_name"];
				
				$Lfull_name=get_username();
				$LOMid=get_user_omuid();
						
				$LogMSG="Cancel Suspension(WhenTerm) of $full_name ($omuid) ";
				log_message('FEMS', $LOMid.' - ' . $Lfull_name . ' | '.$LogMSG );
			}			
			//////////
						
			$ans="done";
		}else{
			$ans="error";
		}
		echo $ans;
	}
	
}



private function updateBenchWhenTerm($csuid,$final_return_date,$update_comments)
{
	if(check_logged_in())
    {
		
		$evt_date = CurrMySqlDate();
		$current_user = get_user_id();
		
		if($csuid!="" && $final_return_date!=""){
			
			//$this->db->update("signin",array("status"=>'1',"disposition_id"=>'1'),array("id"=>$csuid));
			//$final_return_date=mmddyy2mysql($final_return_date);
			
			$update_array = array(
						"final_expiry_date" => $final_return_date,
						"move_status" => '0',
						"update_date" => $evt_date,
						"update_by" => $current_user,
						"update_remarks" => $update_comments,
						"is_on_bench" => "N"
					);
					
			$this->db->where('user_id', $csuid);
			$this->db->where('is_on_bench', "Y");
			$this->db->update('user_bench',$update_array );
			
			$qSql="select id as value from event_disposition where user_id='$csuid' and event_master_id in (22,23) order by id desc limit 1";
			$disp_row_id=$this->Common_model->get_single_value($qSql);
			if($disp_row_id!=""){
				
				$update_array = array(
					"end_date" => $final_return_date
				);
				
				$this->db->where('user_id', $csuid);
				$this->db->where('id', $disp_row_id);
				$this->db->update('event_disposition',$update_array );
				
							
				//////////LOG////////
							
				$qSql="select fusion_id,omuid,CONCAT(fname,' ' ,lname) as full_name from signin where id='$csuid'";
				$query = $this->db->query($qSql);
				$uRow=$query->row_array();			
				$omuid=$uRow["omuid"];
				$full_name=$uRow["full_name"];
				
				$Lfull_name=get_username();
				$LOMid=get_user_omuid();
						
				$LogMSG="Cancel Bench(WhenTerm) of $full_name ($omuid) ";
				log_message('FEMS', $LOMid.' - ' . $Lfull_name . ' | '.$LogMSG );
			}	
			//////////
						
			$ans="done";
		}else{
			$ans="error";
		}
		echo $ans;
	}
	
}

private function updateFurloughWhenTerm($csuid,$final_return_date,$update_comments)
{
	if(check_logged_in())
    {
		
		$evt_date = CurrMySqlDate();
		$current_user = get_user_id();
		
		if($csuid!="" && $final_return_date!=""){
			
			//$this->db->update("signin",array("status"=>'1',"disposition_id"=>'1'),array("id"=>$csuid));
			//$final_return_date=mmddyy2mysql($final_return_date);
			
			$update_array = array(
						"final_expiry_date" => $final_return_date,
						"move_status" => '0',
						"update_date" => $evt_date,
						"update_by" => $current_user,
						"update_remarks" => $update_comments,
						"is_on_furlough" => "N"
					);
					
			$this->db->where('user_id', $csuid);
			$this->db->where('is_on_furlough', "Y");
			$this->db->update('user_furlough',$update_array );
			
			$qSql="select id as value from event_disposition where user_id='$csuid' and event_master_id = '24' order by id desc limit 1";
			$disp_row_id=$this->Common_model->get_single_value($qSql);
			if($disp_row_id!=""){
				
				$update_array = array(
					"end_date" => $final_return_date
				);
				
				$this->db->where('user_id', $csuid);
				$this->db->where('id', $disp_row_id);
				$this->db->update('event_disposition',$update_array );
				
							
				//////////LOG////////
							
				$qSql="select fusion_id,omuid,CONCAT(fname,' ' ,lname) as full_name from signin where id='$csuid'";
				$query = $this->db->query($qSql);
				$uRow=$query->row_array();			
				$omuid=$uRow["omuid"];
				$full_name=$uRow["full_name"];
				
				$Lfull_name=get_username();
				$LOMid=get_user_omuid();
						
				$LogMSG="Cancel Furlough (WhenTerm) of $full_name ($omuid) ";
				log_message('FEMS', $LOMid.' - ' . $Lfull_name . ' | '.$LogMSG );
			}	
			//////////
						
			$ans="done";
		}else{
			$ans="error";
		}
		echo $ans;
	}
	
}


private function updateUserResignWhenTerm($uid,$comments)
{
	if(check_logged_in())
    {
		
		$evt_date = CurrMySqlDate();
		$current_user = get_user_id();
		
		if($uid!=""){
			
			$qSql="select resign_status as value from user_resign where user_id='$uid' and resign_status!='R' order by id desc limit 1";
			$resign_status=$this->Common_model->get_single_value($qSql);
			
			$qSql="select id as value from user_resign where user_id='$uid' and resign_status!='R' order by id desc limit 1";
			$resign_id=$this->Common_model->get_single_value($qSql);
			
			
			$qSql="Select log from user_resign where user_id='$uid' and resign_status!='R' order by id desc limit 1";
			$prevLog=getDBPrevLogs($qSql);
			$log = "Updete for term user :: ". get_logs($prevLog);
			
			if($resign_id!=""){
				
				$field_array = array(
					"fnf_status" => "R",
					"final_comments" => $comments,
					"final_update_by" => $current_user,
					"final_update_date" => $evt_date
				);
				
				$this->db->where('resign_id', $resign_id);
				$this->db->update('user_fnf', $field_array);
					
						
				if($resign_status=="A"){
					$field_array = array(
							"approved_by" => $current_user,
							"approved_remarks" => $comments,
							"approved_date" => $evt_date,
							"resign_status" => 'R',
							"log" => $log
						);
				}else{
					
					$field_array = array(
						"accepted_by" => $current_user,
						"accepted_remarks" => $comments,
						"accepted_date" => $evt_date,
						"resign_status" => 'R',
						"log" => $log
					);
				
				}
				
				$this->db->where('user_id', $uid);
				$this->db->where('id', $resign_id);
				$this->db->update('user_resign', $field_array);
			
			}			
						
			//////////
						
			$ans="done";
		}else{
			$ans="error";
		}
		echo $ans;
	}
	
}





	public function benchuserUpdate()
	{
		$current_user=get_user_id();
		
		$bench_user         =  $this->input->post('uid');
		$bench_lwd          = date('Y-m-d',  strtotime($this->input->post('lwd')));
		$bench_date         = date('Y-m-d H:i:s', strtotime($this->input->post('bench_date')));
		$expiry_date         = date('Y-m-d', strtotime($this->input->post('expiry_date')));
		$bench_type         = $this->input->post('b_type');
		$bench_remarks      = $this->input->post('remarks');
		$curDateTime        = CurrMySqlDate();
		
		$disp_id='23';
		if($bench_type=='5') $disp_id='22';
		else $disp_id='23';
		
		$sqlupdate = "UPDATE signin SET status = '$bench_type', disposition_id = '$disp_id' WHERE id = '$bench_user'";
		$this->db->query($sqlupdate);
		
		//$qSql  =  "select a.office_id, max(login_time_local) as last_login_time, max(logout_time_local) as last_logout_time from signin a left join logged_in_details b on a.id=b.user_id where a.id='$user_id'";
		//$query             =  $this->db->query($qSql);
		//$uRow              =  $query->row_array();
		//$office_id         =  $uRow["office_id"];
		//$last_login_time   =  $uRow["last_login_time"];
		//$last_logout_time  =  $uRow["last_logout_time"];
		
		$event_by = get_user_id();
		$evt_date = CurrMySqlDate();
		$start_date=GetLocalDate();
		$log = get_logs();
		
		$_field_array = array(
					"user_id" => $bench_user,
					"bench_date" => $bench_date,
					"bench_type" => $bench_type,
					"lwd" => $bench_lwd,
					"comments" => $bench_remarks,
					"evt_by" => $event_by,
					"evt_date" => $evt_date,
					"expiry_date" => $expiry_date,
					"is_on_bench" => 'Y',
					"log" => $log
				);
		data_inserter('user_bench',$_field_array);
		
		
		
		$_field_array = array(
			"user_id" => $bench_user,
			"event_time" => $evt_date,
			"event_by" => $event_by,
			"event_master_id" => $disp_id,
			"start_date" => $bench_date,
			"end_date" => $expiry_date,
			"ticket_no" => "",
			"remarks" => $bench_remarks,
			"log" => $log
		); 
		
		$event_id = data_inserter('event_disposition',$_field_array);
		
	}
	
	public function revokeUserUpdate()
	{
		$userid  =  $this->input->post('uid');
		$assigned_to = $this->input->post('revoke_assigned_to');
		$client_array = $this->input->post('revoke_client_id');
		$process_array = $this->input->post('revoke_process_id');
		$reactivation = date('Y-m-d', strtotime($this->input->post('reativation')));
		$remarks = $this->input->post('remarks');
		
		$field_array = array(
			"assigned_to" => $assigned_to,
			"status" => 1,
			"disposition_id" => 1
		);
		$this->db->where('id', $userid);
		$this->db->update('signin', $field_array);
		///////
		
		$this->db->query('DELETE FROM info_assign_client WHERE user_id = "'.$userid.'"');
		foreach ($client_array as $key => $client_value){	
			$field_array2 = array(
				"user_id" => $userid,
				"client_id" => $client_value,
				"log" => $log
			);
			$rowid= data_inserter('info_assign_client',$field_array2);
		}
		//////
		
		$this->db->query('DELETE FROM info_assign_process WHERE user_id = "'.$userid.'"');
		foreach ($process_array as $key => $process_value){	
			$field_array3 = array(
				"user_id" => $userid,
				"process_id" => $process_value,
				"log" => $log
			);
			$rowid= data_inserter('info_assign_process',$field_array3);
		}
		///////
		
		
		$qSql  =  "select a.office_id, max(login_time_local) as last_login_time, max(logout_time_local) as last_logout_time from signin a left join logged_in_details b on a.id=b.user_id where a.id='$userid'";
		$query             =  $this->db->query($qSql);
		$uRow              =  $query->row_array();
		$office_id         =  $uRow["office_id"];
		$last_login_time   =  $uRow["last_login_time"];
		$last_logout_time  =  $uRow["last_logout_time"];
		
		$current_user=get_user_id();
		$event_by = get_user_id();
		$evt_date = CurrMySqlDate();
		$start_date=GetLocalDate();
		$log = get_logs();
		
		$_field_array = array(
					"is_on_bench" => 'N',
					"move_status" => '1',
					"update_date" => $evt_date,
					"update_by" => $current_user,
					"update_remarks" => $remarks,
					"final_expiry_date" => $reactivation,
					"log" => $log
				);
		$this->db->where('user_id', $userid);
		$this->db->where('is_on_bench', 'Y');
		$this->db->update('user_bench', $_field_array);
		
		
		//EVENT DISPOSITION
		$qSql="select id as value from event_disposition where user_id='$userid' and event_master_id in (22,23) order by id desc limit 1";
		$disp_row_id=$this->Common_model->get_single_value($qSql);
		
		$update_array = array(
			"end_date" => $reactivation
		);
		
		$this->db->where('user_id', $userid);
		$this->db->where('id', $disp_row_id);
		$this->db->update('event_disposition',$update_array );
		
		$LogMSG="";
		$logs=get_logs(); 
		log_record($userid,'Revoke_bench', $LogMSG,  $this->input->post() , $logs);
				
				
		redirect($_SERVER['HTTP_REFERER']);
		
	}
	
	
	public function revokeUserForm()
	{
		$data['userid'] = $userid  =  $this->input->post('uid');
		
		$sql_assigned_to = "SELECT assigned_to as value from signin WHERE id = '$userid'";
		$data['assigned_to'] = $query_assigned_to = $this->Common_model->get_single_value($sql_assigned_to);
		
		$data['tl_list'] = $this->Common_model->get_tls_for_assign2("");
		$data['client_list'] = $this->Common_model->get_client_list_1();	
		
		$data['client_list_2'] = $this->Common_model->get_process_list_1();		
		$data['client_list_3'] = $data['client_list_2'];
			
		$data['assign_client'] = $this->Common_model->info_assign_client("SELECT id,user_id,client_id,(select fullname from client where id=info_assign_client.client_id)as client_info FROM info_assign_client where user_id='".$userid ."'");
		
		$data['assign_process'] = $this->Common_model->info_assign_client("SELECT id,user_id,process_id,(select name from process where process.id= info_assign_process.process_id)as process_info FROM info_assign_process where user_id='".$userid ."'");	
		
		$this->load->view('user/revoke_user',$data);
		
		
	}
	
	
	
	public function saveFurloughLeave()
	{
		$current_user=get_user_id();
		
		$furlough_user         =  $this->input->post('uid');
		$furlough_lwd          = date('Y-m-d',  strtotime($this->input->post('lwd')));
		$furlough_date         = date('Y-m-d H:i:s', strtotime($this->input->post('furlough_date')));
		$expiry_date         = date('Y-m-d', strtotime($this->input->post('expiry_date')));
		$furlough_type         = '7';
		$furlough_comments      = $this->input->post('comments');
		$curDateTime        = CurrMySqlDate();
		
		$sqlupdate = "UPDATE signin SET status = '$furlough_type', disposition_id = '24' WHERE id = '$furlough_user'";
		$this->db->query($sqlupdate);
		
				
		$event_by = get_user_id();
		$evt_date = CurrMySqlDate();
		$start_date=GetLocalDate();
		$log = get_logs();
		
		$_field_array = array(
					"user_id" => $furlough_user,
					"furlough_date" => $furlough_date,
					"lwd" => $furlough_lwd,
					"comments" => $furlough_comments,
					"evt_by" => $event_by,
					"evt_date" => $evt_date,
					"expiry_date" => $expiry_date,
					"is_on_furlough" => 'Y',
					"log" => $log
				);
		data_inserter('user_furlough',$_field_array);
		
				
		$_field_array = array(
			"user_id" => $furlough_user,
			"event_time" => $evt_date,
			"event_by" => $event_by,
			"event_master_id" => '24',
			"start_date" => $furlough_date,
			"end_date" => $expiry_date,
			"ticket_no" => "",
			"remarks" => $furlough_comments,
			"log" => $log
		); 
		
		$event_id = data_inserter('event_disposition',$_field_array);
		
	}
			
public function revokeFurloughUser()
{
	if(check_logged_in())
    {
		
		$evt_date = CurrMySqlDate();
		$current_user = get_user_id();
		
		$uid = trim($this->input->post('uid'));
		$final_expiry_date = date('Y-m-d', strtotime($this->input->post('final_expiry_date'))); 
		$update_remarks = trim($this->input->post('update_remarks'));	
	
		if($uid!="" && $final_expiry_date!=""){
			
			$this->db->update("signin",array("status"=>'1',"disposition_id"=>'1'),array("id"=>$uid));
			
			$update_array = array(
						"final_expiry_date" => $final_expiry_date,
						"update_date" => $evt_date,
						"update_by" => $current_user,
						"update_remarks" => $update_remarks,
						"move_status" => '1',					
						"is_on_furlough" => "N"
					);
					
			$this->db->where('user_id', $uid);
			$this->db->where('is_on_furlough', 'Y');
			$this->db->update('user_furlough',$update_array );
			
			$qSql="select id as value from event_disposition where user_id='$uid' and event_master_id=24 order by id desc limit 1";
			$disp_row_id=$this->Common_model->get_single_value($qSql);
			
			if($disp_row_id!=""){
				
				$update_array = array(
					"end_date" => $final_expiry_date
				);
				
				$this->db->where('user_id', $uid);
				$this->db->where('id', $disp_row_id);
				$this->db->update('event_disposition',$update_array );
				
				//////////LOG////////
							
				$qSql="select fusion_id,omuid,CONCAT(fname,' ' ,lname) as full_name from signin where id='$uid'";
				$query = $this->db->query($qSql);
				$uRow=$query->row_array();			
				$omuid=$uRow["fusion_id"];
				$full_name=$uRow["full_name"];
				
				$Lfull_name=get_username();
				$LOMid=get_user_omuid();
						
				$LogMSG="Cancel Furlough of $full_name ($omuid) ";
				log_message('FEMS', $LOMid.' - ' . $Lfull_name . ' | '.$LogMSG );
				
				$logs=get_logs(); 
				log_record($csuid,'Cancel_Furlough', $LogMSG,  $this->input->post() , $logs);
				
			}
			//////////
			
			redirect($_SERVER['HTTP_REFERER']);
			
			$ans="done";
		}else{
			$ans="error";
		}
		
		//echo $ans;
	}
	
	}
	
	
	//===== SIGNIN USER PHASE =======================//
	public function display_user_phase($phaseid="", $type="")
	{
		$phaseName = ""; 
		$phaseArr = array(
			'1' => "Hiring",
			'2' => "Training",
			'3' => "Nesting",
			'4' => "Production",
			'5' => "BENCH-PAID",
			'6' => "BENCH-UNPAID",
			'7' => "Recurisve Training",
		);
		foreach($phaseArr as $key => $value){
		  if($key == $phaseid){  $phaseName = $value; }
		}
		if($type == 'array'){ 
			return $phaseArr; 
		} else {
			return $phaseName;
		}		
	}
	
	
	
	
	public function resend_offer_letter(){
		if(check_logged_in()){
			$current_user = get_user_id();
			$user_office_id = get_user_office_id();
			
			$c_id=trim($this->input->get('cid'));
			$qSql="select fusion_id, fname, lname, doj, role_id, office_id from signin Where id=$c_id ";
			
			$query = $this->db->query($qSql);
			$dRow=$query->row_array();
			$location_id=$dRow["office_id"];
			
			$pdfFileName = $this->offer_letter_pdf($c_id,'Y','Y');
				
			if($location_id=="CEB" || $location_id=="MAN") $offer_letter="";
			else $offer_letter = FCPATH."temp_files/offer_letter/".$pdfFileName;
			
			/////////////
			$linkURL="";
			
			///////////
							
			$this->Email_model->resend_employee_offer_letter($c_id,$offer_letter,$linkURL);
			
			$referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : "users/manage";
			redirect($referer);
									
		}
	}
	

	public function offer_letter_pdf($c_id,$isLHead='Y',$isSave='N'){ 
			
			if(check_logged_in()){
				
			//load mPDF library
			$this->load->library('m_pdf');
						
			$qSql="select fusion_id,fname,lname, doj, role_id, org_role_id, office_id, office_id as location, (Select location from office_location o where o.abbr=s.office_id) as location_name, (select name from role r where r.id=s.role_id) as position_name, (select org_role from role  where role.id = s.role_id ) as org_role,  concat(address_permanent, ', ', city, ', ', state, ' - ', pin) as address, payroll_type as pay_type , gross_pay, office_id as pool_location from signin s
			LEFT JOIN info_personal iper on iper.user_id=s.id
			LEFT JOIN info_payroll ipay on ipay.user_id=s.id
			Where s.id=$c_id limit 1";
			
			$data["can_dtl_row"] = $can_dtl_row = $this->Common_model->get_query_row_array($qSql);
			$location= $can_dtl_row['location'];
			if($location=="") $location = $can_dtl_row['pool_location'];
			
			$fname= $can_dtl_row['fname'];
			$lname= $can_dtl_row['lname'];
			$pay_type= $can_dtl_row['pay_type'];
			$stipend_array = array(2,3,4,5,6);
			
			
			$data['c_id'] = $c_id;  
			$html="";
									
			$footer="";
			$header="";
			
			if(isIndiaLocation($location)==true){
			
				if($location=="HWH"){
					
					if(in_array($pay_type,$stipend_array)){
						$html=$this->load->view('dfr/candidateoffer_stipend_hwh_pdf.php', $data, true);
					} else {
						$html=$this->load->view('dfr/candidateoffer_hwh_pdf.php', $data, true);
					}
					
					$header="<div><img src='" . APPPATH . "/../assets/images/logohwr.png' height='70px;'></div>";
		
					$footer = "<p style='text-align:center; font-weight:lighter; '>
						<span style='font-size:14px'>WINDOW TECHNOLOGIES PVT LTD.</span><br>
							<span style='font-size:11px'><i>(A Fusion BPO Services Company)</i></span><br>
							<span style='font-size:11px'>Plot Y9, Block-EP, Sector-V, Salt Lake City, Kolkata-700091</span><br>
							<span style='font-size:11px'>www.fusionbposervices.com</span>
						</p>";
				
				}else{
					
					if(in_array($pay_type,$stipend_array)){
						$html=$this->load->view('dfr/candidateoffer_stipend_kol_pdf.php', $data, true);
					} else {
						$html=$this->load->view('dfr/candidateoffer_kol_pdf.php', $data, true);
					}
					
					$header="<div><img src='" . APPPATH . "/../assets/images/logoxt.jpg' height='90px;'></div>";
					
					$footer = "<p style='text-align:center; font-weight:lighter; '><span style='font-size:14px'>XPLORE-TECH SERVICES PRIVATE LIMITED</span><br>
					<span style='font-size:11px'>CIN: U72900WB2004PTC097921</span><br>
					<span style='font-size:11px'><i>(A Fusion BPO Services Company)</i></span><br>
					<span style='font-size:11px'>Plot Y9, Block-EP, Sector-V, Salt Lake City, Kolkata-700091</span><br>
					<span style='font-size:11px'>www. xplore-tech.com | www.fusionbposervices.com</span></p>";
					
				}
			
			}else if($location=="CEB" ){
				
				$html=$this->load->view('dfr/candidateoffer_ceb_pdf.php', $data, true);
				
				$header="<p style='text-align:center;'><img src='" . APPPATH . "/../assets/images/logoceb.png' height='80px;'><br>
				<span style='font-size:11px'>US: 1480 Vine Street | Suite 402 | Los Angeles | CA | 90028</span><br>
				<span style='font-size:11px'>PH: 7F Cybergate Bldg. | Fuente Osmeña | Cebu City | Cebu | PH | 6000</span><br>
				<span style='font-size:11px'>Phone: 310-734-8225 | Fax: 206-350-0106 | www.supportsave.com</span><br>
				</p>";
				
				$footer = "<p style='text-align:left; font-weight:lighter; '><span style='font-size:11px'>Issued by:  HR Organizational Development</span><br></p>";
				
			}			
			else if($location=="ELS" ){
				
				$html=$this->load->view('dfr/candidateoffer_els_pdf.php', $data, true);
				
				$header="<p style='text-align:left;'><img src='" . APPPATH . "/../assets/images/fusion-bpo.png' height='80px;'></p><br>";
				
				$footer = "";
				
			}
			else if($location=="JAM" ){
				
				$html=$this->load->view('dfr/candidateoffer_jam_pdf.php', $data, true);
				
				$header="<p style='text-align:left;'><img src='" . APPPATH . "/../assets/images/fusion-bpo.png' height='80px;'><br><br>
				<span style='font-size:14px'>Fusion BPO Service Ltd.,</span><br>
				<span style='font-size:14px'>15 Old Hope Road,</span><br>
				<span style='font-size:14px'>Kingston 5,</span><br>
				<span style='font-size:14px'>Jamaica</span>
				</p>";
				
				$footer = "<p style='text-align:left; font-weight:lighter; '><span style='font-size:11px'>Issued by:  HR Organizational Development</span><br></p>";
				
			}
			else if($location=="UKL" ){
				
				$html=$this->load->view('dfr/candidateoffer_uk_pdf.php', $data, true);
				
				$header="";
				
				$footer = "";
				
			}
			else $html="";
			

			if($isLHead=="Y"){
				$this->m_pdf->pdf->SetHTMLHeader($header);
				$this->m_pdf->pdf->SetHTMLFooter($footer);	
			}
			
			
			//this the the PDF filename that user will get to download
			$pdfFileName = $fname."_".$lname."_offer_letter".$c_id.".pdf";
			
			$this->m_pdf->shrink_tables_to_fit;
		   //generate the PDF from the given html
			$this->m_pdf->pdf->WriteHTML($html);
			
			//download it.
			if($isSave=="Y") {
				$file_path =FCPATH."temp_files/offer_letter/".$pdfFileName;
				$this->m_pdf->pdf->Output($file_path, "F");
				return $pdfFileName;
			}
			else $this->m_pdf->pdf->Output($pdfFileName, "D");		
		}
			
	}
	///////////////// end offer letter //////////////////////////////////////
	
	
	
	  
}

?>