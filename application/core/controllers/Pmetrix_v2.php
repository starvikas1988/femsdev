<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pmetrix_v2 extends CI_Controller {
    
    /////////////////////////////////////////////////////////////////////////////////////////////
    // INDEX PAGE
    /////////////////////////////////////////////////////////////////////////////////////////////
   	
	 function __construct() {
		parent::__construct();
		
		$this->load->model('Common_model');
		$this->load->model('user_model');
		$this->load->library('excel');
		
	 }
	 
    public function index()
    {
        if(check_logged_in()){
			
			if(isDisableModule()==true) redirect(base_url()."home","refresh");
			
			if(get_login_type() == "client") redirect(base_url().'pmetrix_v2_client',"refresh");
			
			if (get_dept_folder()=="mis" ){
				
				// mis default
								
			}else if (get_role_dir() == "agent" && get_dept_folder()=="operations" ){
				
				redirect('/Pmetrix_v2_agent/', 'refresh');
			}
			else if(get_role_dir() == 'tl')
			{
				redirect('/Pmetrix_v2_tl/', 'refresh');
			}
			else 
			{
				redirect('/Pmetrix_v2_management/', 'refresh');
			}
			
			$user_site_id = get_user_site_id();
			$user_office_id=get_user_office_id();
			
			$role_id= get_role_id();
			$current_user = get_user_id();
			$role_dir=get_role_dir();
			$ses_dept_id=get_dept_id();
			$ses_dept_folde=get_dept_folder();
			
			$mdid_type = '9';
			
			
			$is_global_access=get_global_access();
			
			$data["user_site_id"]=$user_site_id;
			$data["user_role_id"]=$role_id;
			
			
			$data["aside_template"] = "pmetrix_v2/aside.php"; //get_aside_template();
			
			
			$oValue = trim($this->input->post('office_id'));
			if($oValue=="") $oValue = trim($this->input->get('office_id'));
			
			$cValue = trim($this->input->post('client_id'));
			if($cValue=="") $cValue = trim($this->input->get('client_id'));
			if($cValue=="") $cValue="0";
			
            $pValue = trim($this->input->post('process_id'));
			if($pValue=="") $pValue = trim($this->input->get('process_id'));
			
			$start_date = trim($this->input->get('start_date'));
			$end_date = trim($this->input->get('end_date'));
			$sch_range_arr[]=$start_date;
			$sch_range_arr[]=$end_date;
			
			$data['start_date']=$start_date;
			$data['end_date']=$end_date;
			
			$data['oValue']=$oValue;
			$data['cValue']=$cValue;
			$data['pValue']=$pValue;
			

			$filterArray = array(
					"process_id" => $pValue,
					"client_id" => $cValue,
					"office_id" => $oValue
			 );
							 
			$_filterCond="";
			
			if($oValue!="ALL" && $oValue!="") $_filterCond = " And office_id='".$oValue."'";
			if($cValue!="ALL" && $cValue!="") $_filterCond .= " And client_id='".$cValue."'";
			if($pValue!="ALL" && $pValue!="" && $pValue!="0" ) $_filterCond .= " And process_id='".$pValue."'";
			
			
			$qSql=" Select id, name, is_summtype, is_active, is_datatype from pm_kpi_type_mas where is_active='1' and is_datatype =1";
			$data['kpi_type_list'] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql=" Select id, name, is_summtype, is_active, is_datatype from pm_kpi_type_mas where is_active='1' and is_summtype =1";
			$data['kpi_summtype_list'] = $this->Common_model->get_query_result_array($qSql);
			
			if($cValue!="ALL" && $cValue!="" && $cValue!="0"){
				
				$data['process_list'] = $this->Common_model->get_process_list($cValue);
				
			}else{
				
				$data['process_list'] =array();
				//$data['process_list'] = $this->Common_model->get_process_for_assign();
				
			}
			
			$data['client_list'] =array();
			
			
			if(get_role_dir()=="super" || $is_global_access==1){
				$data['location_list'] = $this->Common_model->get_office_location_list();
			}else{
				
				$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
			}
							
			if($role_dir=="super" || $is_global_access==1)
			{
				$search_type = $this->input->get('search_type');
				if($search_type == null)
				{
					$cond=" ";
				}
				else
				{
					if($search_type == 2)
					{
						$tl_fusion_id = $this->input->get('tl_fusion_id');
						$cond=" And (assigned_to='$tl_fusion_id' OR assigned_to in (SELECT id FROM signin where  assigned_to ='$tl_fusion_id')) ";
						
						
						$process_id = $this->input->get('process_id');
						$query = 'SELECT signin.id,signin.fusion_id,CONCAT(signin.fname," ",signin.lname) AS tl_name FROM signin 
						LEFT JOIN role_organization ON role_organization.id=signin.org_role_id
						LEFT JOIN info_assign_process ON info_assign_process.user_id=signin.id
						WHERE role_organization.controller="tl" AND info_assign_process.process_id="'.$process_id.'" AND signin.status=1';
												
						$data["tl_list"] = $pm_design = $this->Common_model->get_query_result_array($query);
						
						$data["tl_fusion_id"] = $this->input->get('tl_fusion_id');
						$data["search_type"] = $this->input->get('search_type');
					}
					else
					{
						$data['tl_fusion_id'] = $this->input->get('tl_fusion_id');
						$cond="";
						
						
						$process_id = $this->input->get('process_id');
						$query = 'SELECT signin.id,signin.fusion_id,CONCAT(signin.fname," ",signin.lname) AS tl_name FROM signin 
						LEFT JOIN role_organization ON role_organization.id=signin.org_role_id
						LEFT JOIN info_assign_process ON info_assign_process.user_id=signin.id
						WHERE role_organization.controller="tl" AND info_assign_process.process_id="'.$process_id.'" AND signin.status=1';
						$data["tl_list"] = $pm_design = $this->Common_model->get_query_result_array($query);
						$data["search_type"] = $this->input->get('search_type');
					}
				}
			}
			/*
			else if($role_dir=="admin") $cond=" and office_id='$user_office_id' ";
			else if($role_dir=="manager") $cond=" and dept_id='$ses_dept_id'";
			else if($role_dir=="trainer" || $role_dir=="tl") $cond=" And (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where  assigned_to ='$current_user')) ";
			//else $cond=" and b.id='".$current_user."'";
			else $cond="";
			*/
			
			// By Lawrence
			//**********************************************
			if($role_dir=="admin") $cond=" and office_id='$user_office_id' ";
			else if($role_dir=="manager") $cond=" and dept_id='$ses_dept_id'";
			else if($role_dir=="trainer" || $role_dir=="tl") $cond=" AND f.assigned_to = '".$current_user."' ";
			else $cond="";
			//*********************************************		
						
			if(count($sch_range_arr)>=2){
				$shMonDate=$sch_range_arr[0];
				$shSunDate=$sch_range_arr[1];
			}else{
				$currDate=CurrDate();	
				if(date('D', strtotime($currDate)) == "Mon") $shMonDate=$currDate;
				else $shMonDate=date('Y-m-d',strtotime($currDate.' -1 Monday'));
				if(date('D', strtotime($currDate)) == "Sun") $shSunDate=$currDate;
				else $shSunDate=date('Y-m-d',strtotime($currDate.' +1 Sunday'));
			}
			
		///echo get_role_dir();
		
		if (get_role_dir() == "agent" and get_dept_folder() !="wfm" and get_dept_folder() !="rta" and get_dept_folder() !="mis"  ){
	
				$qSql="Select mp.id as mp_id,office_id,client_id ,process_id, mp_type,is_active,description, (Select name from process y where y.id=mp.process_id) as process_name,(Select office_name from office_location k  where k.abbr=mp.office_id) as office_name,(Select shname from client c where c.id=mp.client_id) as client_name from pm_design_v2 mp Where mp.is_active=1 and  mp.process_id in (get_process_ids($current_user)) and mp.client_id in (get_client_ids($current_user)) and (mp.office_id = '$user_office_id' OR mp.office_id = 'ALL')";
		
		}else if($role_dir=="super" || $is_global_access==1){
			if($search_type == 1)
			{
				$query = $this->db->query('SELECT id FROM signin WHERE fusion_id="'.$this->input->get('agent_fusion_id').'"');
				$row = $query->row();
				$data['fusion_id'] = $this->input->get('agent_fusion_id');
				$data['search_type'] = $search_type;
				
				$qSql="Select mp.id as mp_id,office_id,client_id ,process_id, mp_type,is_active,description, (Select name from process y where y.id=mp.process_id) as process_name,(Select office_name from office_location k  where k.abbr=mp.office_id) as office_name,(Select shname from client c where c.id=mp.client_id) as client_name from pm_design_v2 mp Where mp.is_active=1 and  mp.process_id in (get_process_ids($row->id)) and mp.client_id in (get_client_ids($row->id))";
				
			}
			else
			{
				$qSql="Select mp.id as mp_id,office_id,client_id ,process_id, mp_type,is_active,description, (Select name from process y where y.id=mp.process_id) as process_name,(Select office_name from office_location k  where k.abbr=mp.office_id) as office_name,(Select shname from client c where c.id=mp.client_id) as client_name from pm_design_v2 mp Where mp.is_active=1 $_filterCond";
			}
			
		}else{
			
			$qSql="Select mp.id as mp_id,office_id,client_id ,process_id, mp_type,is_active,description, (Select name from process y where y.id=mp.process_id) as process_name,(Select office_name from office_location k  where k.abbr=mp.office_id) as office_name,(Select shname from client c where c.id=mp.client_id) as client_name from pm_design_v2 mp Where mp.is_active=1 and (mp.office_id = '$user_office_id' OR mp.office_id = 'ALL') $_filterCond";
				
			
		}
			 
			//echo "<br><br>" . $qSql . "<br><br>";
			
			$data["pm_design"] = $pm_design = $this->Common_model->get_query_result_array($qSql);					
			$pmAllArray=array();
						
			foreach($pm_design as $row){
				
				$mp_id=$row['mp_id'];
				$client_id=$row['client_id'];
				$office_id= $row['office_id'];
				$mdid_type = $row['mp_type'];
				
				$qSql="SELECT DISTINCT client_id as id ,client.shname FROM `pm_design_v2` LEFT JOIN client ON client.id=pm_design_v2.client_id WHERE office_id='".$office_id."'";
				$data['client_list'] = $this->Common_model->get_query_result_array($qSql);
								
				
				$qSql = "Select *,(Select name from pm_kpi_type_mas km where km.id=kp.kpi_type) as mp_type_name from pm_design_kpi_v2 kp where did = $mp_id";
				
				//echo $qSql . "<br><br>";
				 
				$pmAllArray[$mp_id."kpi"]=$this->Common_model->get_query_result_array($qSql);
				
				$condP ="";
				
				if($pValue=="0" || $pValue=="" || $pValue =="ALL") $condP ="";
				else $condP =" and is_assign_process(b.id,$pValue) ";
								
				//$qSql = "Select id,fusion_id,office_id, fname, lname, (Select name from role a  where a.id=b.role_id) as role_name, get_client_names(b.id) as client_name, get_process_names(b.id) as process_name from signin b where status in (1,4) and id in (Select user_id from pm_data_v2 where mdid = $mp_id ) $cond $condP  ";
				
				$qSql = "SELECT b.id, fusion_id, office_id,
					fname,lname,a.name AS role_name,GET_CLIENT_NAMES(b.id) AS client_name, GET_PROCESS_NAMES(b.id) AS process_name FROM
					signin b Inner JOIN role a ON a.id = b.role_id where b.id in 
					( select pd.user_id from pm_data_v2 pd inner join signin f on f.id = pd.user_id  
					where mdid = '".$mp_id."' $cond and f.status in ('1','4')  group by pd.user_id)"; 
			
				 
				$pmAllArray[$mp_id."user"] = $userlist = $this->Common_model->get_query_result_array($qSql);
				
				
				$pmDataArray=array();
				
				foreach($userlist as $urow){
					
					$fusion_id=$urow['fusion_id'];
					$user_id=$urow['id'];
					
					if (get_role_dir() == "agent" and get_dept_folder() !="wfm" and get_dept_folder() !="rta" and get_dept_folder() !="mis"  ){
						
						$qSql = "Select start_date, end_date from pm_data_v2 where user_id = $user_id and start_date >='".date('Y-m-01')."' and end_date <='".date('Y-m-t')."' group by start_date";
						$data['cur_month_year'] = date('F Y');
						
					}else{
						if($this->input->get('showReports') == 'Show')
						{
							$qSql = "Select start_date, end_date from pm_data_v2 where user_id = $user_id and start_date >='$shMonDate' and end_date <='$shSunDate'";
						}
						else
						{
							$query_date = $shMonDate;

							// First day of the month.
							$month_start = date('Y-m-01', strtotime($query_date));

							// Last day of the month.
							$month_end = date('Y-m-t', strtotime($query_date));
							$qSql = "Select start_date, end_date from pm_data_v2 where user_id = $user_id and start_date >= '".$month_start."' AND end_date <= '".$month_end."'";
						}
					}
					
					$pmDataArray[$fusion_id."date"] = $DateArray = $this->Common_model->get_query_result_array($qSql);
					
					$pmValueArray=array();
					
					foreach($DateArray as $dtrow){
						
						$start_date=$dtrow['start_date'];
						
						$qSql = "Select * from pm_data_v2 where user_id = $user_id and start_date = '$start_date' " ;
						//echo $qSql . "<br><br>";
						$pmValueArray[$fusion_id.$start_date]=$this->Common_model->get_query_result_array($qSql);
						
						
					}// date 
					
					
					$pmDataArray[$fusion_id."value"]= $pmValueArray;
					
					
				} // user
					
										
					if($search_type == null)
					{
							$best_sql = "Select max(IF(isnumeric(pm_data_v2.kpi_value) = 1 , CAST(pm_data_v2.kpi_value AS DECIMAL(5,2)), -999999)) as max_value, min(IF(isnumeric(pm_data_v2.kpi_value) = 1 , CAST(pm_data_v2.kpi_value AS DECIMAL(5,2)), 999999)) as min_value, kpi_name, kpi_type,pm_design_kpi_v2.weightage_comp 
						from pm_data_v2  
						left join pm_design_kpi_v2 on pm_design_kpi_v2.id=pm_data_v2.kpi_id
						where pm_data_v2.mdid=$mp_id  and start_date >='".date('Y-m-01')."' and end_date <='".date('Y-m-t')."' group by pm_data_v2.kpi_id ";
					}
					else
					{
							$best_sql = "Select max(IF(isnumeric(pm_data_v2.kpi_value) = 1 , CAST(pm_data_v2.kpi_value AS DECIMAL(5,2)), -999999)) as max_value, min(IF(isnumeric(pm_data_v2.kpi_value) = 1 , CAST(pm_data_v2.kpi_value AS DECIMAL(5,2)), 999999)) as min_value, kpi_name, kpi_type,pm_design_kpi_v2.weightage_comp 
						from pm_data_v2  
						left join pm_design_kpi_v2 on pm_design_kpi_v2.id=pm_data_v2.kpi_id
						where pm_data_v2.mdid=$mp_id  and start_date >='$shMonDate' and end_date <='$shSunDate' group by pm_data_v2.kpi_id ";
					}
				
					$data['best_value'.$mp_id]=$this->Common_model->get_query_result_array($best_sql); 
						
						
				$pmAllArray[$mp_id."data"] =$pmDataArray;
				
				}// fd
				
			$data['pmAllArray'] = $pmAllArray;
			
			$data["sch_date_range"]= mysql2mmddyy($shMonDate) . " To " . mysql2mmddyy($shSunDate);
			
			if($this->input->get('start_date'))
			{
				$process_id = trim($this->input->get('process_id'));
				$office_id = trim($this->input->get('office_id'));
				$client_id = trim($this->input->get('client_id'));
				
				$query = array();
				if($client_id != "0")
				{
					$query[] = "client_id='".$client_id."'";
				}
				if($process_id != "0")
				{
					$query[] = "process_id='".$process_id."'";
				}
				
				if(!empty($query))
				{
					$string = ' and '.implode(' and ',$query);
				}
				else
				{
					$string = '';
				}
		
				$qSql="Select start_date,end_date,CONCAT(DATE_FORMAT(start_date,'%m-%d-%Y'),' To ' ,DATE_FORMAT(end_date,'%m-%d-%Y')) as shrange from pm_data_v2 left join pm_design_v2 ON pm_design_v2.id=pm_data_v2.mdid WHERE office_id='".$office_id."' ".$string." group by start_date order by start_date desc";
				
				$data['all_sch_date_range'] = $this->Common_model->get_query_result_array($qSql);
			}
			
			
			$data['department_list'] = $this->Common_model->get_department_list();
			$data['client_ids'] = get_client_ids();
			$data['show_report'] = trim($this->input->get('showReports'));
			$data['report_type'] = $this->input->get('showReports');
			
			
			$data["mdid_type"] = $mdid_type;
			
			///////////////////
			
			//echo "mdid_type :: " . $mdid_type;
			
			if($mdid_type > 1)
			{
				if (get_role_dir() == "agent" and get_dept_folder()!="wfm" and get_dept_folder() !="rta" and get_dept_folder() !="mis" ) $data["content_template"] = "pmetrix_v2/metrix_screen_agent.php";
				else $data["content_template"] = "pmetrix_v2/metrix_screen.php";
				
				//echo "OK";
			}
			else
			{
				//echo "OK2";
				
				if (get_role_dir() == "agent" and get_dept_folder() !="wfm" and get_dept_folder() !="rta" and get_dept_folder() !="mis"){
					$data["content_template"] = "pmetrix_v2/metrix_screen_agent.php";
					
				}else
				{
					if($this->input->get('showReports') == 'Show')
					{
						if($search_type == 1)
						{
							$data["content_template"] = "pmetrix_v2/metrix_screen_admin_agent.php";
						}
						else
						{
							$data["content_template"] = "pmetrix_v2/metrix_screen.php";
						}
					}
					else
					{
						$data["content_template"] = "pmetrix_v2/metrix_screen_summary.php";
					}
				}
				
				
			}
			
						
			$this->load->view('dashboard',$data);
			
		}
    }
	
	
	
	public function supervisor()
	{
		if(check_logged_in()){
			
			$is_global_access=get_global_access();
			
			//FKOL002152//FKOL002543
			$current_user = get_user_id();
			$data['oValue'] = get_user_office_id();
			$data['cValue'] = get_client_ids();
			$data['pValue'] = get_process_ids();
			$data['rValue'] = get_role_dir();
			
			 
				$data["aside_template"] = "pmetrix_v2/aside.php";
			
			if(get_role_dir()=="super" || $is_global_access==1){
				$data['location_list'] = $this->Common_model->get_office_location_list();
			}else{
				
				$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
			}
			
			$post_period_query = $this->db->query('SELECT DISTINCT post_period FROM `pm_vrs_bonus_sup` ORDER BY post_period ASC');
			if($post_period_query)
			{
				$data['post_period'] = $post_period_query->result_object();
			}
			
			$data['client_list'] =array();
			$data['process_list'] =array();
			$process_ids = get_process_ids();
			
			//$data['table'] = $this->prepare_row();
			$data["content_template"] = "pmetrix_v2/matrix_screen_sup_wise.php";
			$data["content_js"] = "pmetrix_v2_tl/tl_js.php";
			$this->load->view('dashboard',$data);
		}
	}


	public function get_bonus_sup()
	{
		if(check_logged_in()){
			$fusion_id = get_user_fusion_id();
			// echo $fusion_id; exit;
			
			$is_global_access=get_global_access();
			
			//FKOL002152//FKOL002543
			$current_user = get_user_id();
			$data['oValue'] = get_user_office_id();
			$data['cValue'] = get_client_ids();
			$data['pValue'] = get_process_ids();
			$data['rValue'] = get_role_dir();
			// print_r($data['oValue']); exit;
			$data["aside_template"] = "pmetrix_v2/aside.php";
			
			if(get_role_dir()=="super" || $is_global_access==1){
				$data['location_list'] = $this->Common_model->get_office_location_list();
			}else{
				
				$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
			}
			
			$post_period_query = $this->db->query('SELECT DISTINCT post_period FROM `pm_vrs_bonus_sup` ORDER BY post_period ASC');
			if($post_period_query)
			{
				$data['post_period'] = $post_period_query->result_object();
			}
			
			$data['client_list'] =array();
			$data['process_list'] =array();
			$process_ids = get_process_ids();
			$post_period = $this->input->post('post_period');
			$pay_period = $this->input->post('pay_period');
			// echo $post_period; exit;

			$vrs_sup_query = $this->db->query('SELECT * FROM `pm_vrs_bonus_sup` WHERE post_period="'.$post_period.'" AND pay_period="'.$pay_period.'" ');
			// echo $current_user; exit;
			if($vrs_sup_query)
			{
				$data['vrs_sup'] = $vrs_sup_query->result_object();
			}

			// $data['table'] = 'Check your Bonus form 
			// 	<button type="button" class="btn btn-xs btn-success" id="pay_period_1sup_btn" value="1">Pay Period 1</button>
			// 	<button type="button" class="btn btn-xs btn-success" id="pay_period_2sup_btn" value="2">Pay Period 2</button>';

			// print_r($this->db->error());
			// print_r($data['vrs_sup']); exit;
			//$data['table'] = $this->prepare_row();
			$data["content_template"] = "pmetrix_v2/matrix_screen_sup.php";
			$data["content_js"] = "pmetrix_v2_tl/tl_js.php";
			$this->load->view('dashboard',$data);
		}
	}



	public function get_bouns_info()
	{
		// $fusion_id = get_user_fusion_id();
		$form_data = $this->input->post();
		$query = $this->db->query('SELECT * FROM pm_vrs_bonus_sup WHERE pay_period="'.$form_data['pay_period'].'" AND  fems_id="'.$form_data['fusion_id'].'" AND post_period="'.$form_data['post_period'].'"');
		if($query)
		{
			$response['stat'] = true;
			$response['datas'] = $query->result_object();
		}
		else
		{
			$response['stat'] = false;
		}
		echo json_encode($response);
	}

	public function process_bonus()
	{
		$form_data = $this->input->post();
		// print_r($form_data);
		// exit;
		
		$query = $this->db->query('UPDATE pm_vrs_bonus_sup SET om_comment="'.$form_data['om_comment'].'" WHERE pay_period="'.$form_data['pay_period'].'" AND  fems_id="'.$form_data['fusion_id'].'" AND post_period="'.$form_data['post_period'].'"');
		if($query)
		{
			$response['stat'] = true;
		}
		else
		{
			$response['stat'] = false;
		}
		echo json_encode($response);
	}	
	
	
	public function get_matrix_week()
	{
		$process_id = trim($this->input->post('process_id'));
		$office_id = trim($this->input->post('office_id'));
		$client_id = trim($this->input->post('client_id'));
		
		$query = array();
		if($client_id != "0")
		{
			$query[] = "client_id='".$client_id."'";
		}
		if($process_id != "0")
		{
			$query[] = "process_id='".$process_id."'";
		}
		
		if(!empty($query))
		{
			$string = ' and '.implode(' and ',$query);
		}
		else
		{
			$string = '';
		}
		
		
		$qSql="Select start_date,end_date,CONCAT(DATE_FORMAT(start_date,'%m-%d-%Y'),' To ' ,DATE_FORMAT(end_date,'%m-%d-%Y')) as shrange,pm_design_v2.mp_type from pm_data_v2 left join pm_design_v2 ON pm_design_v2.id=pm_data_v2.mdid WHERE office_id='".$office_id."' ".$string." group by start_date order by start_date desc";
			
		echo json_encode($this->Common_model->get_query_result_array($qSql));
	}
	
	
	public function design()
    {
        if(check_logged_in())
        {
			$user_site_id = get_user_site_id();
			$user_office_id=get_user_office_id();
			
			$role_id= get_role_id();
			$current_user = get_user_id();
			$role_dir=get_role_dir();
			
			$ses_dept_id=get_dept_id();
						
			$is_global_access=get_global_access();
			
			if(isDisableModule()==true) redirect(base_url()."home","refresh");
			
			$data["user_site_id"]=$user_site_id;
			$data["user_role_id"]=$role_id;
			
			$data["aside_template"] = "pmetrix_v2/aside.php"; //get_aside_template();
			
			$data["content_template"] = "pmetrix_v2/metrix_screen.php";
			
			$oValue = trim($this->input->post('office_id'));
			if($oValue=="") $oValue = trim($this->input->get('office_id'));
			
			$cValue = trim($this->input->post('client_id'));
			if($cValue=="") $cValue = trim($this->input->get('client_id'));
			if($cValue=="") $cValue="0";
			
            $pValue = trim($this->input->post('process_id'));
			if($pValue=="") $pValue = trim($this->input->get('process_id'));
			
			$data['oValue']=$oValue;
			$data['cValue']=$cValue;
			$data['pValue']=$pValue;
							
							
			$_filterCond="";
			
			if($oValue!="ALL" && $oValue!="") $_filterCond = " And office_id='".$oValue."'";
			if($cValue!="ALL" && $cValue!="") $_filterCond .= " And client_id='".$cValue."'";
			if($pValue!="ALL" && $pValue!="" ) $_filterCond .= " And process_id='".$pValue."'";
			
			$qSql=" Select * from client where is_active='1' ";
			$data['client_list_all'] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql=" Select * from pm_kpi_type_mas where is_active='1' and is_datatype =1";
			$data['kpi_type_list'] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql=" Select * from pm_kpi_type_mas where is_active='1' and is_summtype =1";
			$data['kpi_summtype_list'] = $this->Common_model->get_query_result_array($qSql);
			
			if($cValue!="ALL" && $cValue!="" && $cValue!="0") $data['process_list'] = $this->Common_model->get_process_list($cValue);
			else $data['process_list'] = $this->Common_model->get_process_for_assign();
			
			if(get_role_dir()=="super" || $is_global_access==1){
				$data['location_list'] = $this->Common_model->get_office_location_list();
			}else{
				$sCond=" Where id = '$user_site_id'";
				$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
			}
			
			$qSql="SELECT DISTINCT client_id as id ,client.shname FROM `pm_design_v2` LEFT JOIN client ON client.id=pm_design_v2.client_id WHERE office_id='".$oValue."'";
			$data['client_list'] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql="Select mp.id as mp_id,office_id,client_id ,process_id, mp_type,is_active,description, (Select name from process y where y.id=mp.process_id) as process_name,(Select office_name from office_location k  where k.abbr=mp.office_id) as office_name,(Select shname from client c where c.id=mp.client_id) as client_name from pm_design_v2 mp Where is_active=1 $_filterCond";
			
			//echo $qSql;
			
			$data["pm_design"] = $pm_design = $this->Common_model->get_query_result_array($qSql);
			
			$pmkpiarray=array();
			foreach($pm_design as $row):
			$mp_id=$row['mp_id'];
				$qSql = "Select *,(Select name from pm_kpi_type_mas km where km.id=kp.kpi_type) as mp_type_name from pm_design_kpi_v2 kp where did = $mp_id";
				$pmkpiarray[$mp_id]=$this->Common_model->get_query_result_array($qSql);
			endforeach;
			
			$data['pm_designkpi']=$pmkpiarray;
			
		
            $data["aside_template"] = "pmetrix_v2/aside.php"; //get_aside_template();
            $data["content_template"] = "pmetrix_v2/kpi_design.php";
			
            $data["error"] = '';  
			$this->load->view('dashboard',$data);			 
			   
		}
   }
   
   
   public function addDesign()
	{
        if(check_logged_in())
        {
						
			$user_site_id= get_user_site_id();
			$srole_id= get_role_id();
			$current_user = get_user_id();
			$ses_dept_id=get_dept_id();
			
			$user_office_id=get_user_office_id();
			$is_global_access=get_global_access();
			
			$_run = false;  
			
			$log=get_logs();
			
			$office_id = trim($this->input->post('office_id'));
			$client_id = trim($this->input->post('client_id'));
			$process_id = trim($this->input->post('process_id'));
			$mp_type = trim($this->input->post('mp_type'));
			$description = trim($this->input->post('description'));
			
			
			//$target_arr = $this->input->post('target');
			$weightage_arr = $this->input->post('weightage');
			
			$kpi_name_arr = $this->input->post('kpi_name');
			$kpi_type_arr = $this->input->post('kpi_type');
			$kpi_summ_type_arr = $this->input->post('summ_type');
			$kpi_summ_formula_arr = $this->input->post('summ_formula');
			$weightage_comp_arr = $this->input->post('weightage_comp');
			$agent_view_arr = $this->input->post('agent_view');
			$tl_view_arr = $this->input->post('tl_view');
			$management_view_arr = $this->input->post('management_view');
			$currency_arr = $this->input->post('currency');
						
			$field_array = array(
				"office_id" => $office_id,
				"client_id" => $client_id,
				"process_id" => $process_id,
				"mp_type" => $mp_type,
				"description" => $description,
				"added_by" => $current_user,
				"is_active" => '1'
			);
			
			$did = data_inserter('pm_design_v2',$field_array);
			
			foreach($kpi_name_arr as $index => $kpi_name){
				
				if($kpi_name<>""){
					
					$field_array = array(
						"did" => $did,
						"kpi_name" => $kpi_name,
						"kpi_type" => $kpi_type_arr[$index],
						"summ_type" => $kpi_summ_type_arr[$index],
						"summ_formula" => $kpi_summ_formula_arr[$index],
						"weightage_comp" => $weightage_comp_arr[$index],
						//"target"=>$target_arr[$index],
						"weightage" => $weightage_arr[$index],
						"agent_view" => $agent_view_arr[$index],
						"tl_view" => $tl_view_arr[$index],
						"management_view" => $management_view_arr[$index],
						"currency" => $currency_arr[$index],
						"added_by" => $current_user
					);
					
					data_inserter('pm_design_kpi_v2',$field_array);
					
				}
				
			}
			
			redirect($_SERVER['HTTP_REFERER']);
			
       }        
   }
   
   
   
   public function getDesignForm()
{
	if(check_logged_in())
    {
		
		$mdid = trim($this->input->post('mdid'));
		$mdid=addslashes($mdid);
		
		$qSql=" Select * from pm_kpi_type_mas where is_active='1' and is_datatype =1";
		$kpi_type_list = $this->Common_model->get_query_result_array($qSql);
		
		$qSql=" Select * from pm_kpi_type_mas where is_active='1' and is_summtype =1";
		$kpi_summtype_list = $this->Common_model->get_query_result_array($qSql);
			
		//$qSql="select * from pm_design where id = $mdid";
		//$design_row=$this->Common_model->get_query_row_array($qSql);
		
		$qSql="select * from pm_design_kpi_v2 where did = $mdid";
		$design_kpi_arr=$this->Common_model->get_query_result_array($qSql);
		
		
		/////////
		$html ="";
		
		$TotRow=count($design_kpi_arr);
		
		$cnt=1;
		foreach($design_kpi_arr as $kpiRow) {
		
		
		$html .= "<div class='col-md-12 kpi_input_row'>";
			
			$html .= "<input type='hidden' value='". $kpiRow['id'] ."' class='form-control' name='kpi_id[]'>";
			
			$html .= "<div class='col-md-2'><input type='text' value='". $kpiRow['kpi_name'] ."' class='form-control' placeholder='KPI Name' name='kpi_name[]'></div>";
			
			$html .= "<div class='col-md-1'><select class='form-control' name='kpi_type[]' > ";
			foreach($kpi_type_list as $kpimas){
				
				$sCss="";
				if($kpimas['id']==$kpiRow['kpi_type']) $sCss="selected";
				$html .= "<option value='".$kpimas['id']."' $sCss >". $kpimas['name'] ."</option>";
			}
							
			$html .= "</select></div>";
			
			$html .= "<div class='col-md-1'><select class='form-control' name='summ_type[]' > ";
			
			foreach($kpi_summtype_list as $kpimas){
				
				$sCss="";
				if($kpimas['id']==$kpiRow['summ_type']) $sCss="selected";
				$html .= "<option value='".$kpimas['id']."' $sCss >". $kpimas['name'] ."</option>";
			}
							
			$html .= "</select></div>";
			
			$html .= "<div class='col-md-1'><input type='text' value='". $kpiRow['summ_formula'] ."' class='form-control' placeholder='Formula' name='summ_formula[]'></div>";
			
			$html .= "<div class='col-md-1'><select class='form-control' name='currency[]' > ";
			$currency_array = array(''=>'','$'=>'$','R'=>'₹','P'=>'£');
			foreach($currency_array as $key=>$value)
			{
				if($kpiRow['currency'] == $key)
				{
					$html .= "<option value='".$key."' selected>".$value."</option>";
				}
				else
				{
					$html .= "<option value='".$key."'>".$value."</option>";
				}
			}
							
			$html .= "</select></div>";
			
			$html .= "<div class='col-md-1'><input type='number' min='0' step='1' pattern='\d+' value='". $kpiRow['weightage'] ."' class='form-control' placeholder='Integer' name='weightage[]'></div>";
			
			$weightage_comp = $kpiRow['weightage_comp'];
			$select1 = '';
			$select2 = '';
			if($weightage_comp == 1)
			{
				$select1 = "SELECTED";
			}
			else
			{
				$select2 = "SELECTED";
			}
			$html .= "<div class='col-md-1'><select class='form-control' name='weightage_comp[]' ><option value='1' ".$select1.">MAX</option><option value='0' ".$select2.">MIN</option></select></div>";
			
			
			$agent_view = $kpiRow['agent_view'];
			$tl_view = $kpiRow['tl_view'];
			$management_view = $kpiRow['management_view'];
			if($agent_view == 0)
			{
				$html .= '<div class="col-md-1"><select class="form-control" name="agent_view[]"><option value="1">Yes</option><option value="0" selected>No</option></select></div>';
			}
			else
			{
				$html .= '<div class="col-md-1"><select class="form-control" name="agent_view[]"><option value="1" selected>Yes</option><option value="0">No</option></select></div>';
			}
			if($tl_view == 0)
			{
				$html .= '<div class="col-md-1"><select class="form-control" name="tl_view[]"><option value="1">Yes</option><option value="0" selected>No</option></select></div>';
			}
			else
			{
				$html .= '<div class="col-md-1"><select class="form-control" name="tl_view[]"><option value="1" selected>Yes</option><option value="0">No</option></select></div>';
			}
			if($management_view == 0)
			{
				$html .= '<div class="col-md-1"><select class="form-control" name="management_view[]"><option value="1">Yes</option><option value="0" selected>No</option></select></div>';
			}
			else
			{
				$html .= '<div class="col-md-1"><select class="form-control" name="management_view[]"><option value="1" selected>Yes</option><option value="0">No</option></select></div>';
			}
			$html .= "<div class='col-md-1'>";
				
				if( $cnt++<$TotRow){
					
					$html .= "<button type='button' style='margin-top:1px;' class='btn btn-primary btnEdMore hide'>More</button>";
					$html .= "<button type='button' style='margin-top:1px;' class='btn btn-danger btnEdRemove'>Remove</button>";
				}else{
					$html .= "<button type='button' style='margin-top:1px;' class='btn btn-primary btnEdMore'>More</button>";
					$html .= "<button type='button' style='margin-top:1px;' class='btn btn-danger btnEdRemove'>Remove</button>";
				}
							
			$html .= "</div>";
		$html .= "</div>";
		
		}	
				
		echo $html;
	}
}

   
   
   public function updateDesign()
   {
		if(check_logged_in())
        {
						
			$user_site_id= get_user_site_id();
			$srole_id= get_role_id();
			$current_user = get_user_id();
			$ses_dept_id=get_dept_id();
			
			$user_office_id=get_user_office_id();
			$is_global_access=get_global_access();
			
			$_run = false;  
			
			$log=get_logs();
			
			$mdid = trim($this->input->post('mdid'));
			
			$office_id = trim($this->input->post('office_id'));
			$client_id = trim($this->input->post('client_id'));
			$process_id = trim($this->input->post('process_id'));
			$mp_type = trim($this->input->post('mp_type'));
			$description = trim($this->input->post('description'));
			
			$kpi_id_arr = $this->input->post('kpi_id');
			$kpi_name_arr = $this->input->post('kpi_name');
			$kpi_type_arr = $this->input->post('kpi_type');
			//$target_arr = $this->input->post('target');
			$weightage_arr = $this->input->post('weightage');
			
			$kpi_summ_type_arr = $this->input->post('summ_type');
			$kpi_summ_formula_arr = $this->input->post('summ_formula');
			$weightage_comp_arr = $this->input->post('weightage_comp');
			$agent_view_arr = $this->input->post('agent_view');
			$tl_view_arr = $this->input->post('tl_view');
			$management_view_arr = $this->input->post('management_view');
			$currency_arr = $this->input->post('currency');
			
			//echo "<pre>";
			//echo print_r($agent_view_arr);
			//echo "</pre>";
			//die();
			
			//echo "<pre>";
			//echo print_r($kpi_name_arr);
			//echo "</pre>";
			
			$field_array = array(
				"office_id" => $office_id,
				"client_id" => $client_id,
				"process_id" => $process_id,
				"mp_type" => $mp_type,
				"description" => $description,
				"added_by" => $current_user,
				"is_active" => '1'
			);
			
			$this->db->where('id', $mdid);
			$this->db->update('pm_design_v2',$field_array );
			
			$TotID=count($kpi_id_arr);
			
			foreach($kpi_name_arr as $index => $kpi_name){
				
				//echo $TotID . " >> ". $index . "<br>";
				//$kpiid="";
				//if($TotID < $index) 
				
				$kpiid = $kpi_id_arr[$index];
				
				if($kpiid == ""){
					
					$field_array = array(
						"did" => $mdid,
						"kpi_name" => $kpi_name,
						"kpi_type" => $kpi_type_arr[$index],
						//"target" => $target_arr[$index],
						"weightage" => $weightage_arr[$index],
						"summ_type" => $kpi_summ_type_arr[$index],
						"summ_formula" => $kpi_summ_formula_arr[$index],
						"weightage_comp" => $weightage_comp_arr[$index],
						"agent_view" => $agent_view_arr[$index],
						"tl_view" => $tl_view_arr[$index],
						"management_view" => $management_view_arr[$index],
						"currency" => $currency_arr[$index],
						"added_by" => $current_user
					);
					
					data_inserter('pm_design_kpi_v2',$field_array);
				}else{
									
					$field_array = array(
						"kpi_name" => $kpi_name,
						"kpi_type" => $kpi_type_arr[$index],
						//"target" => $target_arr[$index],
						"weightage" => $weightage_arr[$index],
						"summ_type" => $kpi_summ_type_arr[$index],
						"summ_formula" => $kpi_summ_formula_arr[$index],
						"weightage_comp" => $weightage_comp_arr[$index],
						"agent_view" => $agent_view_arr[$index],
						"tl_view" => $tl_view_arr[$index],
						"management_view" => $management_view_arr[$index],
						"currency" => $currency_arr[$index],
						"added_by" => $current_user
					);
					
					$this->db->where('id', $kpiid);
					$this->db->update('pm_design_kpi_v2',$field_array );
					
				}
				
			}
			
			redirect($_SERVER['HTTP_REFERER']);
			
		}
   }
      
	public function uploadMetrix()
    {
        if(check_logged_in())
        {
			
			$user_site_id = get_user_site_id();
			$user_office_id=get_user_office_id();
			
			$role_id= get_role_id();
			$current_user = get_user_id();
			$role_dir=get_role_dir();
			
			$ses_dept_id=get_dept_id();
						
			$is_global_access=get_global_access();
			
			$data["user_site_id"]=$user_site_id;
			$data["user_role_id"]=$role_id;
			
						
			$oValue = trim($this->input->post('office_id'));
			if($oValue=="") $oValue = trim($this->input->get('office_id'));
			
			$cValue = trim($this->input->post('client_id'));
			if($cValue=="") $cValue = trim($this->input->get('client_id'));
			if($cValue=="") $cValue="0";
			
            $pValue = trim($this->input->post('process_id'));
			if($pValue=="") $pValue = trim($this->input->get('process_id'));
			
			$data['oValue']=$oValue;
			$data['cValue']=$cValue;
			$data['pValue']=$pValue;
			$data['override']=trim($this->input->get('override'));
			

			$filterArray = array(
					"process_id" => $pValue,
					"client_id" => $cValue,
					"office_id" => $oValue
			 );
							 
			$_filterCond="";
			
			if($oValue!="ALL" && $oValue!="") $_filterCond = " And office_id='".$oValue."'";
			if($cValue!="ALL" && $cValue!="") $_filterCond .= " And client_id='".$cValue."'";
			if($pValue!="ALL" && $pValue!="" ) $_filterCond .= " And process_id='".$pValue."'";
			
			
			
			$qSql=" Select * from client where is_active='1' ";
			$data['client_list'] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql=" Select * from pm_kpi_type_mas where is_active='1' and is_datatype =1";
			$data['kpi_type_list'] = $this->Common_model->get_query_result_array($qSql);
			
			$qSql=" Select * from pm_kpi_type_mas where is_active='1' and is_summtype =1";
			$data['kpi_summtype_list'] = $this->Common_model->get_query_result_array($qSql);
			
			if($cValue!="ALL" && $cValue!="" && $cValue!="0") $data['process_list'] = $this->Common_model->get_process_list($cValue);
			else $data['process_list'] = $this->Common_model->get_process_for_assign();
			
			if(get_role_dir()=="super" || $is_global_access==1){
				$data['location_list'] = $this->Common_model->get_office_location_list();
			}else{
				$sCond=" Where id = '$user_site_id'";
				$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
			}
			
			$qSql="Select mp.id as mp_id,office_id,client_id ,process_id, mp_type,is_active, (Select name from process y where y.id=mp.process_id) 
			as process_name,(Select office_name from office_location k  where k.abbr=mp.office_id) as office_name,
			(Select shname from client c where c.id=mp.client_id) as client_name from pm_design_v2 mp Where is_active=1 $_filterCond";
			
			//echo $qSql;
			$data["pm_design"] = $pm_design = $this->Common_model->get_query_result_array($qSql);
			
			$headerDownloadUrl = "pmetrix_v2/downloadMetrixHeader?";
			$data["headerDownloadUrl"] = $headerDownloadUrl;
			
            $data["aside_template"] = "pmetrix_v2/aside.php"; //get_aside_template();
			
			$data["date_range"] = $this->input->post('date_range');
			
            $data["content_template"] = "pmetrix_v2/upload.php";
			
            $data["error"] = '';  
			$this->load->view('dashboard',$data);			 
			   
		}
   }
	
	
	public function downloadMetrixHeader()
    {
		
		
		$pmdid = trim($this->input->get('pmdid'));
					
		$qSql="Select mp.id as mp_id,office_id,client_id ,process_id, mp_type,is_active, (Select name from process y where y.id=mp.process_id) as process_name,(Select office_name from office_location k  where k.abbr=mp.office_id) as office_name,(Select shname from client c where c.id=mp.client_id) as client_name from pm_design_v2 mp Where is_active=1 and id=$pmdid";
			
		//echo $qSql;
		$pm_design_row = $this->Common_model->get_query_row_array($qSql);
		
		
		$fn=$pm_design_row['office_id']. "-".$pm_design_row['client_name']."-".$pm_design_row['process_name'];
		$fn = str_replace("/","_",$fn);
		$sht_title= $fn;
		 
		if(strlen($sht_title)>29) $sht_title =  substr($sht_title,29);
		$filename = "./assets/reports/".$fn.".xls";
		$title = $fn;
		
		
		$letters = array(); 
		$k=0;
		 for ($i = 'A'; $i !== 'ZZ'; $i++){
			$letters[$k++]=$i;
		}
		
		
		//activate worksheet number 1
		$this->excel->setActiveSheetIndex(0);
		//name the worksheet
		$this->excel->getActiveSheet()->setTitle($sht_title);
		//set cell A1 content with some text
	
		$this->excel->getActiveSheet()->setCellValue('A1', $title);
		$this->excel->getActiveSheet()->mergeCells('A1:E1');
		$this->excel->getActiveSheet()->mergeCells('G1:H1');
	
		//change the font size
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(14);
		//make the font become bold
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
		if($pm_design_row['mp_type'] != 1)
		{
			$this->excel->getActiveSheet()->setCellValue('A2', 'SLNo');
			$this->excel->getActiveSheet()->setCellValue('B2', 'FUSIONID');
			$this->excel->getActiveSheet()->setCellValue('C2', 'NAME');
			$j=3;
			$r=2;
		}
		else
		{
			$this->excel->getActiveSheet()->setCellValue('A2', 'SLNo');
			$this->excel->getActiveSheet()->setCellValue('B2', 'Date (mm/dd/yy)');
			$this->excel->getActiveSheet()->setCellValue('C2', 'FUSIONID');
			$this->excel->getActiveSheet()->setCellValue('D2', 'NAME');
			$j=4;
			$r=2;
		}
		
		
		$mp_id=$pm_design_row['mp_id'];
		
		$qSql = "Select *,(Select name from pm_kpi_type_mas km where km.id=kp.kpi_type) as mp_type_name from pm_design_kpi_v2 kp where did = $mp_id";
		$kpiarray=$this->Common_model->get_query_result_array($qSql);
		
		foreach($kpiarray as $row):
		
			$cell=$letters[$j++].$r;
			//echo $cell .">>";
			$this->excel->getActiveSheet()->setCellValue($cell, $row['kpi_name']);
			
		endforeach;
		
		
		header('Content-Type: application/vnd.ms-excel'); //mime type
		header('Content-Disposition: attachment;filename="'.$fn.'.xls"'); //tell browser what's the file name
		header('Cache-Control: max-age=0'); //no cache
					 
		//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
		//if you want to save it as .XLSX Excel 2007 format
		
		$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5'); 
		ob_end_clean();
		//force user to download the Excel file without writing it to server's HD
		$objWriter->save('php://output');
		
		
	}
	
	
	public function upload()
    {
        if(check_logged_in())
        {
			$user_site_id= get_user_site_id();
			$role_id= get_role_id();
			$current_user = get_user_id();
			
			$sdate = trim($this->input->post('sdate'));
			$edate = trim($this->input->post('edate'));
			$mpid = trim($this->input->post('mpid'));
			$mptype = trim($this->input->post('mptype'));
			$override = trim($this->input->post('override'));
			
			$ret = array();
			
			if($sdate!="" && $edate!=""){
			
				$output_dir = "uploads/";
							
				$error =$_FILES["myfile"]["error"];
				//You need to handle  both cases
				//If Any browser does not support serializing of multiple files using FormData() 
				if(!is_array($_FILES["myfile"]["name"])) //single file
				{
					//$fileName = time().$_FILES["myfile"]["name"];
					$fileName = time().str_replace(' ','',$_FILES["myfile"]["name"]);
					
					move_uploaded_file($_FILES["myfile"]["tmp_name"],$output_dir.$fileName);
					
					$ret[]= $this->Import_excel_file($fileName,$sdate,$edate,$mpid, $mptype,$override);
					
					
				}
				else  //Multiple files, file[]
				{
				  $fileCount = count($_FILES["myfile"]["name"]);
				  for($i=0; $i < $fileCount; $i++)
				  {
					//$fileName = time().$_FILES["myfile"]["name"][$i];
					$fileName = time().str_replace(' ','',$_FILES["myfile"]["name"]);
					
					move_uploaded_file($_FILES["myfile"]["tmp_name"][$i],$output_dir.$fileName);
					
					$ret[]= $this->Import_excel_file($fileName,$sdate,$edate,$mpid, $mptype,$override);
					
					 
					
				  }
				
				}
			}else{
				$output_dir = "uploads/";
							
				$error =$_FILES["myfile"]["error"];
				//You need to handle  both cases
				//If Any browser does not support serializing of multiple files using FormData() 
				if(!is_array($_FILES["myfile"]["name"])) //single file
				{
					//$fileName = time().$_FILES["myfile"]["name"];
					$fileName = time().str_replace(' ','',$_FILES["myfile"]["name"]);
					
					move_uploaded_file($_FILES["myfile"]["tmp_name"],$output_dir.$fileName);
					
					$ret[]= $this->Import_excel_file($fileName,'','',$mpid, $mptype,$override);
					
					
				}
				else  //Multiple files, file[]
				{
				  $fileCount = count($_FILES["myfile"]["name"]);
				  for($i=0; $i < $fileCount; $i++)
				  {
					//$fileName = time().$_FILES["myfile"]["name"][$i];
					$fileName = time().str_replace(' ','',$_FILES["myfile"]["name"]);
					
					move_uploaded_file($_FILES["myfile"]["tmp_name"][$i],$output_dir.$fileName);
					
					$ret[]= $this->Import_excel_file($fileName,'','',$mpid, $mptype,$override);
					//$ret = [];
					//print $fileName." --> ".$mpid." --> ".$mptype." --> ".$override; 
					
				  }
				
				}
					
			}
			
			echo json_encode($ret);
			
		}
   }
   
	public function uploadBonus()
	{
		
		if(check_logged_in())
        {
			
			$output_dir = "uploads/";
			if(!is_array($_FILES["myfile"]["name"])) //single file
			{
				//$fileName = time().$_FILES["myfile"]["name"];
				$fileName = time().str_replace(' ','',$_FILES["myfile"]["name"]);
				
				move_uploaded_file($_FILES["myfile"]["tmp_name"],$output_dir.$fileName);
				
				$ret[]= $this->UploadExcelBonus($fileName);
				$ret[]= 'ok';
				
				
			}
			else  //Multiple files, file[]
			{
			  $fileCount = count($_FILES["myfile"]["name"]);
			  for($i=0; $i < $fileCount; $i++)
			  {
				//$fileName = time().$_FILES["myfile"]["name"][$i];
				$fileName = time().str_replace(' ','',$_FILES["myfile"]["name"]);
				
				move_uploaded_file($_FILES["myfile"]["tmp_name"][$i],$output_dir.$fileName);
				
				$ret[]= $this->UploadExcelBonus($fileName);
				$ret[]= 'ok1';
				 
				
			  }
			
			}
			echo json_encode($ret);
		}
	}



	public function uploadBonusSupervisor()
	{
		
		if(check_logged_in())
        {
			
			$output_dir = "uploads/";
			if(!is_array($_FILES["myfile"]["name"])) //single file
			{
				//$fileName = time().$_FILES["myfile"]["name"];
				$fileName = time().str_replace(' ','',$_FILES["myfile"]["name"]);
				
				move_uploaded_file($_FILES["myfile"]["tmp_name"],$output_dir.$fileName);
				
				$ret[]= $this->UploadExcelBonusSup($fileName);
				$ret[]= 'ok';
				
				
			}
			else  //Multiple files, file[]
			{
			  $fileCount = count($_FILES["myfile"]["name"]);
			  for($i=0; $i < $fileCount; $i++)
			  {
				//$fileName = time().$_FILES["myfile"]["name"][$i];
				$fileName = time().str_replace(' ','',$_FILES["myfile"]["name"]);
				
				move_uploaded_file($_FILES["myfile"]["tmp_name"][$i],$output_dir.$fileName);
				
				$ret[]= $this->UploadExcelBonusSup($fileName);
				$ret[]= 'ok1';
				 
				
			  }
			
			}
			echo json_encode($ret);
		}
	}


	private function UploadExcelBonusSup($fn)
	{
		
		$file_name = "./uploads/".$fn;
				
		$inputFileType = PHPExcel_IOFactory::identify($file_name);
		$objReader = PHPExcel_IOFactory::createReader($inputFileType);
		$objReader->setReadDataOnly(true);
		
		$objPHPExcel = $objReader->load($file_name);
		// print_r($objPHPExcel);
		
		$i = 1;
		foreach ($objPHPExcel->getWorksheetIterator() as $worksheet)
		{
			
			if($i > 1)
			{
				break;
			}
			$worksheetTitle     = $worksheet->getTitle();
			$highestRow         = $worksheet->getHighestRow();
			$highestColumn      = $worksheet->getHighestColumn();
			
			for ($row = 2; $row <= $highestRow; $row++)
			{
				$rowData = $worksheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,NULL,TRUE,FALSE);
    			if($this->isEmptyRow(reset($rowData))) { continue; }
    			else{
    				$val = array();
					for ($col = 0; $col < 25; $col++)
					{
						$cell = $worksheet->getCellByColumnAndRow($col, $row);
						$val[] = '"'.$cell->getValue().'"';
						
					}
    			}
					


				// print_r($val);
				// $val[] = '"'.get_user_id().'"';
				$all_value[] = '('.implode(',',$val).')';
			}

			
			
			
			$query = 'REPLACE INTO `pm_vrs_bonus_sup`(`pay_period`, `post_period`, `supervisor_name`, `unit`, `eligible`, `fees`, `budget`, `over_under`, `class`, `plan`, `level`, `raw_per`, `qm_avg`, `kqm`, `pro_r`, `base_bonus`, `kicker`, `misc_bonus`, `total_bonus`, `fems_id`, `deductions`, `supervisor_comment`, `om_comment`, `accepted_on`, `accepted_status`) VALUES '.implode(',',$all_value).'';
			$process_query = $this->db->query($query);
			if(!$process_query)
			{
				log_message('FEMS',  'SQL : '.  $query);
			}
			
			$i++;
		}

		unlink($file_name);
		$retval= $fn."=>done";
		return $retval;
	}


	function isEmptyRow($row) {
	    foreach($row as $cell){
	        if (null !== $cell) return false;
	    }
	    return true;
	}



	private function UploadExcelBonus($fn)
	{
		
		$file_name = "./uploads/".$fn;
				
		$inputFileType = PHPExcel_IOFactory::identify($file_name);
		$objReader = PHPExcel_IOFactory::createReader($inputFileType);
		$objReader->setReadDataOnly(true);
		
		$objPHPExcel = $objReader->load($file_name);
		
		$i = 1;
		foreach ($objPHPExcel->getWorksheetIterator() as $worksheet)
		{
			
			if($i > 1)
			{
				break;
			}
			$worksheetTitle     = $worksheet->getTitle();
			$highestRow         = $worksheet->getHighestRow();
			$highestColumn      = $worksheet->getHighestColumn();
			$highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
			
			for ($row = 2; $row <= $highestRow; $row++)
			{
				$val = array();
				for ($col = 0; $col < $highestColumnIndex; $col++)
				{
					$cell = $worksheet->getCellByColumnAndRow($col, $row);
					$val[] = '"'.$cell->getValue().'"';
				}
				$val[] = '"'.get_user_id().'"';
				$all_value[] = '('.implode(',',$val).')';
			}
			
			
			
			$query = 'REPLACE INTO `pm_vrs_bonus`(`pay_period`, `post_period`, `erps_id`, `collector_name`, `unit`, `eligible`, `fees`, `budget`, `over_under`, `class`, `plan`, `level`, `raw_per`, `qm_avg`, `kqm`, `pro_r`, `base_bonus`, `kicker`, `misc_bonus`, `total_bonus`, `fems_id`, `deductions`, `supervisor_comment`, `agent_comment`, `om_comment`, `accepted_on`, `accepted_status`, `added_by`) VALUES '.implode(',',$all_value).'';
			$process_query = $this->db->query($query);
			if(!$process_query)
			{
				log_message('FEMS',  'SQL : '.  $query);
			}
			
			$i++;
		}

		unlink($file_name);
		$retval= $fn."=>done";
		return $retval;
	}
   
   /*
   private function Import_excel_file($fn,$sdate,$edate, $mpid, $mptype, $override)
   {
		
		$retval="";
		
		if(check_logged_in())
        {
			$current_user = get_user_id();
			
			try{
					if($sdate != '')
					{
					$sdate=mmddyy2mysql($sdate);
					$edate=mmddyy2mysql($edate);
					
					$this->db->query('DELETE FROM `pm_data_v2` WHERE (start_date BETWEEN "'.$sdate.'" AND "'.$edate.'") and mdid="'.$mpid.'"');
					$sdate = '';
					$edate = '';
					}
								
				$kpiArry = array();
				
				$qSql = "Select * from pm_design_kpi_v2 kp where did = $mpid";
				
				//log_message('FEMS',  'qSql = '.  $qSql);
				
				$kpiarray=$this->Common_model->get_query_result_array($qSql);
				foreach($kpiarray as $row){
					$kpiArry[ $row['id'] ] = $row['kpi_name'];
				}
				//----------------
				
				$file_name = "./uploads/".$fn;
				
			$inputFileType = PHPExcel_IOFactory::identify($file_name);
			$objReader = PHPExcel_IOFactory::createReader($inputFileType);
			$objReader->setReadDataOnly(true);
			
			$objPHPExcel = $objReader->load($file_name);
			$html ="";
			
			$ii=1;
			
			foreach ($objPHPExcel->getWorksheetIterator() as $worksheet){

				$worksheetTitle     = $worksheet->getTitle();
				$highestRow         = $worksheet->getHighestRow(); // 
				
				$highestColumn      = $worksheet->getHighestColumn(); // 
				
				$highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
				
				//$html .= "<br><br>The worksheet ".$worksheetTitle." has ";
				//$html .= $highestColumnIndex . ' columns (A-' . $highestColumn . ') ' ;
				//$html .= ' and ' . $highestRow . ' row.<br>';
				
				$text = $ii++. " The worksheet ".$worksheetTitle." has ";
				$text .= $highestColumnIndex . ' columns (A-' . $highestColumn . ') ' ;
				$text .= ' and ' . $highestRow . ' row.';
				
				//log_message('FEMS',  ' INFO:  '.$text );
				
				////////////////////////////////////////////////////////
				$sheetData = $worksheet->toArray(null,true,true,true);
				//$html .= "<pre>";
				//$html .= json_encode($sheetData);
				//$html .="</pre>";
				
				/////////////////////////////////////////
								
				//$html .= '<br><table border="1"><tr>';
				
				$row = 2;
				$col_indexs="";
				$wc_index=0;
				$fusion_index=0;
				$kpiIDArry = array();
				
				for ($col = 0; $col <= $highestColumnIndex; $col++) {
				
					$cell = $worksheet->getCellByColumnAndRow($col, $row);
					$val = $cell->getValue();
					$val=trim($val);	
					
					//log_message('FEMS',  ' Column val:  ' .$col. " | " .$row. " => " . $val );
					
					if(strtoupper($val) =="FUSION ID" || strtoupper($val) =="FUSIONID" || strtoupper($val) =="FUSION_ID" ){
						
						$col_indexs .=",".$col;
						$fusion_index=$col;
						
						//log_message('FEMS',  ' fusion_index:  ' . $fusion_index );
						
					}else{
						
						$kpiID = array_search($val,$kpiArry);
						
						if($kpiID != FALSE ){
							$col_indexs .=",".$col;
							$kpiIDArry[$col] = $kpiID;
						}
					}
				}
				
				$col_indexs=substr($col_indexs,1);
				
				//log_message('FEMS',  ' col_indexs:  '.$col_indexs );
				
				$col_ind_arry=explode(",",$col_indexs);
												
				$jj=0;
				
				for ($row = 3; $row <= $highestRow; $row++) {
					//$html .= '<tr>';
					$jj++;
					
					$iData="";
					
					$found_uid=false;
					$found_week=false;
					
					$omid="";
					$fusion_id="";
					$w_start="";
					$w_end="";
					$user_id="";
					
					$kpiValuesArry = array();
					
					for ($col = 0; $col <= $highestColumnIndex; $col++) {
					
						$cell = $worksheet->getCellByColumnAndRow($col, $row);
						
						if (in_array($col, $col_ind_arry)){
							
							$val = $cell->getValue();
							$val=trim($val);
							
							if($col==$fusion_index ){
								
								$fusion_id=$val;
								
								if($found_uid==false){
																		
									if($fusion_id!="" && $fusion_id!="-"){
									
										$qSql="select id as value from signin where fusion_id ='$fusion_id'";
										//log_message('FEMS',  ' get user_id: '.$qSql );
										
										$user_id=$this->Common_model->get_single_value($qSql);
										if($user_id!=""){
											$found_uid=true;
										}
									}
								}
								
							}else{
								$val = $cell->getFormattedValue();
								$kpiValuesArry[ $kpiIDArry[$col] ] = $val;
							}
														
							//log_message('FEMS',  ' Coll data iData v2: '.$jj." -> " . " $col >> " .$val );
							
						}else{
							//log_message('FEMS',  ' metrix v2 Not In Array Data col : '.$col);
						}
					}
					
					if($found_uid==true && $user_id!="" ){
						
						$iSql="";
						
						foreach($kpiValuesArry as $kpiID => $kpiVal){
							
							try{
								if($sdate == '')
								{
									
									$cell = $worksheet->getCellByColumnAndRow(1, $row);
									$val = PHPExcel_Style_NumberFormat::toFormattedString($cell->getCalculatedValue(), 'yyyy-mm-dd');
									
									$start_date = $val;
									$end_date = $val;
									
								}
								else
								{
									$start_date = $sdate;
									$end_date = $edate;
								}
								
								$iSql="INSERT INTO pm_data_v2 (user_id,added_by,added_date,start_date,end_date,mdid,kpi_id, kpi_value ) Values($user_id,'$current_user', now() ,'$start_date', '$end_date', $mpid, $kpiID,'$kpiVal')";
									
								
								log_message('FEMS',  'PMV2 SQL : '.  $iSql);
								
																
								$this->db->query($iSql);
								
							}catch(Exception $ex){
							
								log_message('FEMS',  'Caught PMV2 exception: '.  $ex->getMessage());
								log_message('FEMS',  'Error : PMV2  -> '. $fusion_id. " >> " . " $user_id >> :: " .$iSql );
								
							}
						
						}
					
						
					}else 
					{
				
						$iSql="";
						log_message('FEMS',  'Error : v2  -> blank user id OF (fusion_id)::' . $fusion_id );
					}
					
				}//end row
				
				log_message('FEMS',  ' Metrix  v2 INFO Total Record :  ' . $jj );
				
				//$html .= '</table>';
			} //worksheet
			
			
				unlink($file_name);
				//$check_ex_all[] = $check_ex;
				//$iSql_all[] = $iSql;
				$retval= $fn."=>done";
			
			}catch(Exception $e){
				
				log_message('FEMS',  'Caught exception: '.  $e->getMessage());
				
				$newfn= "Error.". $fn;
				
				$new_file_name = "./uploads/".$newfn;
				rename($file_name , $new_file_name);
				
				$retval= $fn."=>error";	
			}
			
			/////////////
			return $retval;
			
		}else{
			return "SessionError";
		}
   }
   */
   
   private function Import_excel_file($fn,$sdate="",$edate="", $mpid="", $mptype="", $override=""){
		/*$sdate = ""; 
		$edate =""; 
		$mpid = $mpid; 
		$mptype = $mptype; 
		$override = $override;*/
		
		$current_user = get_user_id();
		
		try{
			if($sdate != ''){
				$sdate=mmddyy2mysql($sdate);
				$edate=mmddyy2mysql($edate);
				
				$this->db->query('DELETE FROM `pm_data_v2` WHERE (start_date BETWEEN "'.$sdate.'" AND "'.$edate.'") and mdid="'.$mpid.'"');
				$sdate = '';
				$edate = '';
			}
			
			$qSql = "Select id, kpi_name from pm_design_kpi_v2 kp where did = '$mpid'";
			$kpiarray = $this->Common_model->get_query_result_array($qSql);
			foreach($kpiarray as $row){
				$kpiArry[$row['id']] = $row['kpi_name'];
			}
			
			$file_name = "./uploads/".$fn;
			
			$inputFileType = PHPExcel_IOFactory::identify($file_name);
			$objReader = PHPExcel_IOFactory::createReader($inputFileType);
			$objReader->setReadDataOnly(true);
			
			$objPHPExcel = $objReader->load($file_name);
			$html ="";
			
			$ii=1;
			
			foreach ($objPHPExcel->getWorksheetIterator() as $worksheet){

				$worksheetTitle = $worksheet->getTitle();
				$highestRow = $worksheet->getHighestRow(); // 
				
				$highestColumn = $worksheet->getHighestColumn(); // 
				
				$highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
				
				$text = $ii++. " The worksheet ".$worksheetTitle." has ";
				$text .= $highestColumnIndex . ' columns (A-' . $highestColumn . ') ' ;
				$text .= ' and ' . $highestRow . ' row.';
				
				
				$sheetData = $worksheet->toArray(null,true,true,true);
				
				$row = 2;
				$wc_index=0;
				$fusion_index=0;
				$kpiIDArry = array();
				
				$kpi_check = True;
				
				$headers = array();
				
				//
				// Check Column Headers Against KPIs 
				//
				
				for ($col = 0; $col <= $highestColumnIndex; $col++){			
					$cell = $worksheet->getCellByColumnAndRow($col, $row);
					$val = trim($cell->getValue());
					$_headers[] = $val;
					
					if(strtoupper($val) =="FUSION ID" || strtoupper($val) =="FUSIONID" || strtoupper($val) =="FUSION_ID" ){
						$fusion_index = $col;
					}	
				}	

				//
				// GET KPI IDS AGAINST COLS
				//
				
				//print_r($kpiArry);
				
				foreach($kpiArry as $kpi){
					
					if(in_array($kpi,$_headers)){
						$kpiID = array_search($kpi,$kpiArry);
					}else{
						$kpi_temp = str_replace(" ","",$kpi);
											
						if(in_array($kpi_temp,$_headers)){
							$kpiID = array_search($kpi,$kpiArry);						
						}else $kpiID = FALSE;
					}	
					
					if($kpiID != FALSE ){
						$kpiIDArry[array_search($kpi, $_headers)] = $kpiID;
					}
				}
				
				//
				// GENERATE FUSION IDS 
				//
				
				$row += 1;
				
				
				
				foreach($kpiIDArry as $key=>$kpi_id){
					
					$_sql = "INSERT INTO pm_data_v2 (user_id,added_by,added_date,start_date,end_date,mdid,kpi_id, kpi_value ) values "; 
					
					for($i = $row; $i <= $highestRow; $i++){
						$cell = $worksheet->getCellByColumnAndRow(1, $i);
						$dates = PHPExcel_Style_NumberFormat::toFormattedString($cell->getCalculatedValue(), 'yyyy-mm-dd');
						
						if($sdate == ''){						
							$cell = $worksheet->getCellByColumnAndRow(1, $i);
							$dates = PHPExcel_Style_NumberFormat::toFormattedString($cell->getCalculatedValue(), 'yyyy-mm-dd');						
							$start_date = $dates;
							$end_date = $dates;
						}
						else{
							$start_date = $sdate;
							$end_date = $edate;
						}
						
						//
						// FUSIONID - > USER_ID
						//
						
						$user_id = FALSE;
						$cell = $worksheet->getCellByColumnAndRow($fusion_index, $i);
						$fusion_id = trim($cell->getValue());
						
						$user_id = $this->Common_model->get_single_value("select id as value from signin where fusion_id = '".$fusion_id."'");
						
						//
						// KPI VALUE
						//
						$cell = $worksheet->getCellByColumnAndRow($key, $i);
						$kpi_val = $cell->getFormattedValue();
						
						
						if($user_id!=""){
							$_sql .= "($user_id,'$current_user', now() ,'$start_date', '$end_date', $mpid, $kpi_id,'".addslashes($kpi_val)."'),";
						}				
					}
					
					$_sql = rtrim($_sql, ",");
					
					
					//print $_sql."<br/><br/>";
					
					
					//fwrite($ff, $_sql."\n\r");
					
					
					$this->db->query($_sql);
					
				}
			}
			$retval= $fn."=>done";	
		}	
		catch(Exception $e){
			log_message('FEMS',  'Caught exception: '.  $e->getMessage());			
			$retval= $fn."=>error";	
		}
		unlink($file_name);
		//fclose($ff);
		
		return $retval;
	}
  
  
    public function get_data()
    {
        if(check_logged_in())
        {
			$user_site_id= get_user_site_id();
			$role_id= get_role_id();
			
			$shid = trim($this->input->post('shid'));
			
			if($shid!=""){
				
				$qSql="Select *,(Select CONCAT(fname,' ' ,lname) from signin x where x.id=b.user_id) as agent_name from user_shift_schedule b where id='$shid'";
				$sch_data= $this->Common_model->get_query_result_array($qSql);
				echo json_encode($sch_data);
				
			}else{
				echo "error";
			}
		}
   }
   
   public function update_data()
    {
        if(check_logged_in())
        {
			$user_site_id= get_user_site_id();
			$role_id= get_role_id();
			
			$shid = trim($this->input->post('shid'));
			$user_id = trim($this->input->post('user_id'));
			
			$omuid = trim($this->input->post('omuid'));
			
			$mon_in = trim($this->input->post('mon_in'));
			$mon_out = trim($this->input->post('mon_out'));
			
			$tue_in = trim($this->input->post('tue_in'));
			$tue_out = trim($this->input->post('tue_out'));
			
			$wed_in = trim($this->input->post('wed_in'));
			$wed_out = trim($this->input->post('wed_out'));
			
			$thu_in = trim($this->input->post('thu_in'));
			$thu_out = trim($this->input->post('thu_out'));
			
			$fri_in = trim($this->input->post('fri_in'));
			$fri_out = trim($this->input->post('fri_out'));
			
			$sat_in = trim($this->input->post('sat_in'));
			$sat_out = trim($this->input->post('sat_out'));
			
			$sun_in = trim($this->input->post('sun_in'));
			$sun_out = trim($this->input->post('sun_out'));
			
			
			if($shid!="" && $user_id!="" && $omuid!=""){
				
				$uSql="UPDATE user_shift_schedule set mon_in='$mon_in', mon_out='$mon_out', tue_in='$tue_in', tue_out='$tue_out', wed_in='$wed_in', wed_out='$wed_out', thu_in='$thu_in', thu_out='$thu_out', fri_in='$fri_in', fri_out='$fri_out', sat_in='$sat_in', sat_out='$sat_out', sat_in='$sat_in', sun_in='$sun_in' WHERE id='$shid' and user_id='$user_id'";
				$this->db->query($uSql);
				echo "done";
			}else{
				echo "error";
			}
		}
   }
   
   public function get_clients()
   {
	   $office_id = $this->input->post('office_id');
	   $clients_client_id=get_clients_client_id();
	   if(get_login_type()=="client"){
		   
		   
		if($office_id != 'ALL')
		{
			$qSql="SELECT DISTINCT client_id,client.shname FROM `pm_design_v2` LEFT JOIN client ON client.id=pm_design_v2.client_id WHERE office_id='".$office_id."' and client.id='".$clients_client_id."'";
		}
		else
		{
			$qSql="SELECT DISTINCT client_id,client.shname FROM `pm_design_v2` LEFT JOIN client ON client.id=pm_design_v2.client_id and client.id='".$clients_client_id."'";
		}
		
	   }else{
		   
		
		if($office_id != 'ALL')
		{
			$qSql="SELECT DISTINCT client_id,client.shname FROM `pm_design_v2` LEFT JOIN client ON client.id=pm_design_v2.client_id WHERE office_id='".$office_id."'";
		}
		else
		{
			$qSql="SELECT DISTINCT client_id,client.shname FROM `pm_design_v2` LEFT JOIN client ON client.id=pm_design_v2.client_id";
		}
	   }
	   
		echo json_encode($this->Common_model->get_query_result_array($qSql));
   }
   
   
   public function get_tl_list()
   {
		$process_id = $this->input->post('process_id');
		$query = $this->db->query('SELECT signin.id,signin.fusion_id,CONCAT(signin.fname," ",signin.lname) AS tl_name FROM signin LEFT JOIN role_organization ON role_organization.id=signin.org_role_id
LEFT JOIN info_assign_process ON info_assign_process.user_id=signin.id
WHERE role_organization.controller="tl" AND info_assign_process.process_id="'.$process_id.'" AND signin.status=1');
		echo json_encode($query->result_object());
   }
    
      
	public function upload_target()
	{
		$user_site_id = get_user_site_id();
		$user_office_id=get_user_office_id();
		$role_id= get_role_id();
		$current_user = get_user_id();
		$role_dir=get_role_dir();
		$ses_dept_id=get_dept_id();
		$ses_dept_folde=get_dept_folder();
		$is_global_access=get_global_access();
		
		$data['oValue'] = get_user_office_id();
		$data['cValue'] = get_client_ids();
		$data['pValue'] = get_process_ids();
		$data['rValue'] = get_role_dir();
		
		if(get_role_dir()=="super" || $is_global_access==1){
			$data['location_list'] = $this->Common_model->get_office_location_list();
		}else{
			
			$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
		}
		
		$data["aside_template"] = "pmetrix_v2/aside.php";
		$data["content_template"] = "pmetrix_v2/target_screen.php";
		$data["content_js"] = "pmetrix_v2/target_screen_js.php";
		$this->load->view('dashboard',$data);
	}
	
	public function get_metrix_design()
	{
		$from_data = $this->input->post();
		$query = $this->db->query('SELECT id,description FROM `pm_design_v2` WHERE office_id="'.$from_data['office_id'].'" AND client_id="'.$from_data['client_id'].'" AND process_id="'.$from_data['process_id'].'" AND is_active=1');
		if($query)
		{
			if($query->num_rows() > 0)
			{
				$response['stat'] = true;
				$designs = $query->result_object();
				$i = 1;
				foreach($designs as $key=>$value)
				{
					if($i == 1)
					{
						$response['table'] = '<div class="table-responsive">';
						$response['table'] .= '<table id="default-datatable" data-plugin="DataTable" class="table table-striped skt-table" width="100%" cellspacing="0">';
						$response['table'] .= '<thead>';
						$response['table'] .= '<tr class="bg-info">';
						$response['table'] .= '<td>Sl</td>';
						$response['table'] .= '<td>Metrix Name</td>';
						$response['table'] .= '<td>Action</td>';
						$response['table'] .= '</tr>';
						$response['table'] .= '</thead>';
						$response['table'] .= '<tbody>';
					}
					$response['table'] .=  '<tr>';
						$response['table'] .=  '<td>'.$i.'</td>';
						$response['table'] .=  '<td>'.$value->description.'</td>';
						$response['table'] .=  '<td><button type="button" class="upload_target btn btn-success btn-xs" data-design_id="'.$value->id.'" data-process_id="'.$from_data['process_id'].'"><i class="fa fa-cloud-upload" aria-hidden="true"></i></button></td>';
					$response['table'] .=  '</tr>';
					if($i==1)
					{
						$response['table'] .= '</tbody>';
						$response['table'] .= '</table>';
						$response['table'] .= '</div>';
					}
					$i++;
				}
			}
			else
			{
				$response['stat'] = false;
			}
		}
		else
		{
			$response['stat'] = false;
		}
		
		
		echo json_encode($response);
	}
	
	public function get_metrix_col()
	{
		$form_data = $this->input->post();
		$query = $this->db->query('SELECT id,kpi_name,kpi_type FROM `pm_design_kpi_v2` WHERE did="'.$form_data['design_id'].'"');
		if($query)
		{
			$rows = $query->result_object();
			$response['stat'] = true;
			
			$i=1;
			$response['table'] = '';
			foreach($rows as $key=>$value)
			{
				if($value->kpi_type != 1 && $value->kpi_type != 11 && $value->kpi_type != 10)
				{
					$response['table'] .= '<tr>';
					$response['table'] .=  '<td>'.$i.'</td>';
					if($value->kpi_type == 2)
					{
						$response['table'] .=  '<td>'.$value->kpi_name.' (%)</td>';
						$response['table'] .=  '<td><input type="text" name="col_value[]" class="form-control" placeholder="Target" value="" pattern="^\d*\.?\d*$" title="Format as 62% => 0.62 "><input type="hidden" name="col_ids[]" class="form-control" value="'.$value->id.'"><input type="hidden" name="kpi_type[]" class="form-control" value="'.$value->kpi_type.'"></td>';
					}
					else if($value->kpi_type == 9)
					{
						$response['table'] .=  '<td>'.$value->kpi_name.' (Hr)</td>';
						$response['table'] .=  '<td><input type="text" name="col_value[]" class="form-control" placeholder="Target" value="" pattern="^\d*\.?\d*$" title="Format as 6:00 => 0.25 "><input type="hidden" name="col_ids[]" class="form-control" value="'.$value->id.'"><input type="hidden" name="kpi_type[]" class="form-control" value="'.$value->kpi_type.'"></td>';
					}
					else
					{
						$response['table'] .=  '<td>'.$value->kpi_name.' (Int)</td>';
						$response['table'] .=  '<td><input type="text" name="col_value[]" class="form-control" placeholder="Target" value="" pattern="^\d*\.?\d*$"><input type="hidden" name="col_ids[]" class="form-control" value="'.$value->id.'"><input type="hidden" name="kpi_type[]" class="form-control" value="'.$value->kpi_type.'"></td>';
					}
					
					$response['table'] .= '</tr>';
				$i++;
				}
			}
			
		}
		else
		{
			$response['stat'] = false;
		}
		echo json_encode($response);
	}
	
	public function add_target()
	{
		$form_data = $this->input->post();
		
		foreach($form_data['col_value'] as $key=>$value)
		{
			$t_b_arr = explode('-',$form_data['tenure_bucket']);
			$t_start = $t_b_arr[0];
			$t_end = $t_b_arr[1];
			if($value != '')
			{
				if($form_data['kpi_type'][$key] == 2)
				{
					$value = ($value / 100);
				}
				else if($form_data['kpi_type'][$key] == 9)
				{
					$value = ($value / 24);
				}
				else
				{
					$value = $value;
				}
			}
			$datas[] = '("'.$form_data['target_month'].'","'.$form_data['target_year'].'","'.$t_start.'","'.$t_end.'","'.$form_data['col_ids'][$key].'","'.$value.'","'.$form_data['did'].'")';
		}
		$query = $this->db->query('REPLACE INTO pm_target_v2(month, year, tenure_bucket_start, tenure_bucket_end, pm_design_kpi_id,target,did) VALUES '.implode(',',$datas).'');
		
		if($query)
		{
			$response['stat'] = true;
		}
		else
		{
			$response['stat'] = false;
		}
		echo json_encode($response);
	}
	
	public function get_target()
	{
		$form_data = $this->input->post();
		$t_b_arr = explode('-',$form_data['tenure_bucket']);
		$t_start = $t_b_arr[0];
		$t_end = $t_b_arr[1];
		$is_global_access=get_global_access();
		
		$query = $this->db->query('SELECT pm_design_kpi_id,pm_target_v2.target,pm_design_kpi_v2.kpi_type FROM `pm_target_v2` LEFT JOIN pm_design_kpi_v2 ON pm_design_kpi_v2.id=pm_target_v2.pm_design_kpi_id WHERE pm_target_v2.did="'.$form_data['did'].'" AND pm_target_v2.month="'.$form_data['trg_month'].'" AND pm_target_v2.year="'.$form_data['target_year'].'" AND pm_target_v2.tenure_bucket_start="'.$t_start.'" AND pm_target_v2.tenure_bucket_end="'.$t_end.'"');
		$rows = $query->result_object();
		foreach($rows as $key=>$value)
		{
			if($value->target != '')
			{
				if($value->kpi_type == 2)
				{
					$value->target = round(($value->target * 100),2);
				}
				else if($value->kpi_type == 9)
				{
					$value->target = round(($value->target * 24),2);
				}
				else
				{
					$value->target = $value->target;
				}
			}
		}
		if($query)
		{
			$response['stat'] = true;
			$response['datas'] = $rows;
		}
		else
		{
			$response['stat'] = false;
		}
		echo json_encode($response);
	}
	public function upload_grade()
	{
		$user_site_id = get_user_site_id();
		$user_office_id=get_user_office_id();
		$role_id= get_role_id();
		$current_user = get_user_id();
		$role_dir=get_role_dir();
		$ses_dept_id=get_dept_id();
		$ses_dept_folde=get_dept_folder();
		$is_global_access=get_global_access();
		
		$data['oValue'] = get_user_office_id();
		$data['cValue'] = get_client_ids();
		$data['pValue'] = get_process_ids();
		$data['rValue'] = get_role_dir();
		
		if(get_role_dir()=="super" || $is_global_access==1){
			$data['location_list'] = $this->Common_model->get_office_location_list();
		}else{
			
			$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
		}
		
		$data["aside_template"] = "pmetrix_v2/aside.php";
		$data["content_template"] = "pmetrix_v2/upload_grade.php";
		$data["content_js"] = "pmetrix_v2/upload_grade_js.php";
		$this->load->view('dashboard',$data);
	}
	public function get_exisiting_grade()
	{
		$form_data = $this->input->post();
		//echo 'SELECT * FROM `pm_grade_v2` WHERE did="'.$form_data['did'].'" AND month="'.$form_data['target_month'].'" AND year="'.$form_data['target_year'].'"';
		$query = $this->db->query('SELECT * FROM `pm_grade_v2` WHERE did="'.$form_data['did'].'" AND month="'.$form_data['target_month'].'" AND year="'.$form_data['target_year'].'"');
		if($query)
		{
			if($query->num_rows() > 0)
			{
				$response['stat'] = true;
				$response['data'] = $query->result_object();
			}
			else
			{
				$response['stat'] = false;
			}
		}
		else
		{
			$response['stat'] = false;
		}
		echo json_encode($response);
	}
	
	public function add_grade()
	{
		$form_data = $this->input->post();
		if($form_data['grade'][2] == 'C')
		{
			$grade = $form_data['grade'][2];
			$start_value = 0;
			$end_value = ($form_data['grade_end'][2] - 0.0000001);
			$year = $form_data['target_year'];
			$month = $form_data['target_month'];
			$data[] = '("'.$form_data['did'].'","'.$form_data['process_id'].'","'.$grade.'","'.$start_value.'","'.$end_value.'","'.$month.'","'.$year.'")';
		}
		if($form_data['grade'][1] == 'B')
		{
			$grade = $form_data['grade'][1];
			$start_value = $form_data['grade_end'][2];
			$end_value = ($form_data['grade_end'][0] - 0.0000001);
			$data[] = '("'.$form_data['did'].'","'.$form_data['process_id'].'","'.$grade.'","'.$start_value.'","'.$end_value.'","'.$month.'","'.$year.'")';
		}
		if($form_data['grade'][0] == 'A')
		{
			$grade = $form_data['grade'][0];
			$start_value = $form_data['grade_end'][0];
			$end_value = 100;
			$data[] = '("'.$form_data['did'].'","'.$form_data['process_id'].'","'.$grade.'","'.$start_value.'","'.$end_value.'","'.$month.'","'.$year.'")';
		}
		
		//echo 'REPLACE INTO `pm_grade_v2`(`did`, `process_id`,`grade`, `grade_start`, `grade_end`) VALUES '.implode(',',$data).'';
		$query = $this->db->query('REPLACE INTO `pm_grade_v2`(`did`, `process_id`,`grade`, `grade_start`, `grade_end`,month,year) VALUES '.implode(',',$data).'');
		if($query)
		{
			$response['stat'] = true;
		}
		else
		{
			$response['stat'] = false;
		}
		echo json_encode($response);
	}
	
	public function delete_metrix()
	{
		$form_data = $this->input->post();
		$this->db->query('DELETE FROM `pm_data_v2` WHERE mdid="'.$form_data['mdid'].'"');
		
		
		$this->db->query('DELETE FROM `pm_design_kpi_v2` WHERE `pm_design_kpi_v2`.`id` = "'.$form_data['kpi_id'].'"');
		
		
		//$this->db->query('DELETE FROM `pm_design_kpi_v2` WHERE did="'.$form_data['mdid'].'"');
		//$this->db->query('DELETE FROM `pm_target_v2` WHERE did="'.$form_data['mdid'].'"');
		//$this->db->query('DELETE FROM `pm_grade_v2` WHERE did="'.$form_data['mdid'].'"');
		//$query = $this->db->query('DELETE FROM `pm_design_v2` WHERE id="'.$form_data['mdid'].'"');
		if($query)
		{
			$response['stat'] = true;
		}
		else
		{
			$response['stat'] = false;
		}
		echo json_encode($response);
	}
	
	public function check_existing_data()
	{
		$form_data = $this->input->post();
		$query = $this->db->query('SELECT * FROM `pm_data_v2` WHERE mdid="'.$form_data['mdid'].'"');
		if($query)
		{
			if($query->num_rows() > 0)
			{
				$response['stat'] = true;
			}
			else
			{
				$response['stat'] = null;
			}
		}
		else
		{
			$response['stat'] = false;
		}
		echo json_encode($response);
	}
	
	public function get_kpi_cols()
	{
		$form_data = $this->input->post();
		//$query = $this->db->query('SELECT * FROM `pm_design_kpi_v2` WHERE did="'.$form_data['id'].'"');
		$query1 = $this->db->query('SELECT * FROM `pm_summary_v2` WHERE mdid="'.$form_data['id'].'"');
		if($query)
		{
			if($query->num_rows() > 0)
			{
				$response['stat'] = true;
				//$result = $query->result_object();
				$result1 = $query1->result_object();
				$response['data'] = '';
				foreach($result1 as $key=>$value)
				{
					$response['data'] += '<div class="row" >
						<div class="col-md-3">
							<input type="hidden" class="form-control" name="col_name[]" value="'.$value['summary_name'].'">
						</div>
						<div class="col-md-3">
							<input type="text" class="form-control" name="formula[]" value="'.$value['summary_formula'].'">
						</div>
						
					</div>';
				}
				 
			}
			else
			{
				$response['stat'] = null;
			}
		}
		else
		{
			$response['stat'] = false;
		}
		echo json_encode($response);
	}
	
	public function copy_metrix()
	{
		$form_data = $this->input->post();
		$current_user = get_user_id();
		$insert_id = $this->db->insert_id();
		//echo 'SELECT * FROM `pm_design_v2` WHERE office_id="'.$form_data['office_id'].'" AND client_id="'.$form_data['client_id'].'" AND process_id="'.$form_data['process_id'].'" AND mp_type="'.$form_data['mp_type'].'"';
		$check_exist_query = $this->db->query('SELECT * FROM `pm_design_v2` WHERE office_id="'.$form_data['office_id'].'" AND client_id="'.$form_data['client_id'].'" AND process_id="'.$form_data['process_id'].'" AND mp_type="'.$form_data['mp_type'].'"');
		if($check_exist_query->num_rows() > 0)
		{
			$response['stat'] = false;
			$response['message'] = 'Information Already Exist';
		}
		else
		{
		
			$this->db->query('INSERT INTO pm_design_v2 (office_id,client_id,process_id,mp_type,description,is_active,added_by,added_date) VALUES("'.$form_data['office_id'].'","'.$form_data['client_id'].'","'.$form_data['process_id'].'","'.$form_data['mp_type'].'","'.$form_data['description'].'","1","'.$current_user.'",now())');
			
			$insert_id = $this->db->insert_id();
			
			$querySTring = 'INSERT INTO pm_design_kpi_v2 (did,kpi_name,kpi_type,summ_type,summ_formula,currency,target,weightage,weightage_comp,isdel,agent_view,tl_view,management_view,added_by,added_date) SELECT "'.$insert_id.'",kpi_name,kpi_type,summ_type,summ_formula,currency,target,weightage,weightage_comp,isdel,agent_view,tl_view,management_view,"'.$current_user.'",now() FROM pm_design_kpi_v2 WHERE did="'.$form_data['mdid'].'"';
			
			$query = $this->db->query($querySTring);
			
			if($query)
			{
				$response['stat'] = true;
				
			}
			else
			{
				$response['stat'] = false;
				
			}
		}
		
		echo json_encode($response);
	}
}

?>