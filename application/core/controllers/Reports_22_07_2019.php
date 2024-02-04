<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reports_22_07_2019 extends CI_Controller {

    private $aside = "reports/aside.php";
	private $objPHPExcel;
    /////////////////////////////////////////////////////////////////////////////////////////////
    // INDEX PAGE
    /////////////////////////////////////////////////////////////////////////////////////////////
    
	 function __construct() {
		parent::__construct();
		$this->load->library('excel');
		$this->load->model('reports_model');
		$this->load->model('Common_model');
		$this->load->model('user_model');
		$this->load->model('Dfr_model');
		
		$this->objPHPExcel = new PHPExcel();
		
	 }
	 
    public function index()
    {
				
        if(check_logged_in())
        {
			$this->check_access();
			
			$role_id= get_role_id();
			$current_user = get_user_id();
			$role_dir= get_role_dir();
			
			$user_office_id=get_user_office_id();
			$ses_dept_id=get_dept_id();
			
			
			//echo $current_user;
			//////////////////////////////////
			$user_site_id= get_user_site_id();
			//////////////////////////////////
			$is_global_access=get_global_access();
			
			$data["role_dir"]=$role_dir;
			
				
				$data['user_list'] =array();
								
				$start_date="";
				$end_date="";
				$filter_key="";
				$filter_value="";
				
				$client_id = "";
				$site_id = "";
				$office_id = "";
				$dept_id = "";
				$sdValue="";
				
				$dn_link="";
				
				if($office_id=="")  $office_id=$user_office_id;
				
				if($this->input->get('showReports')=='Show')
				{
					$start_date = $this->input->get('start_date');
					$end_date = $this->input->get('end_date');
					
					$client_id = $this->input->get('client_id');
					$site_id = $this->input->get('site_id');
					$office_id = $this->input->get('office_id');
					
					if($office_id=="")  $office_id=$user_office_id;
					
					$dept_id = $this->input->get('dept_id');
					//if($dept_id=="")  $dept_id=$ses_dept_id;
					
					$sdValue = $this->input->get('sub_dept_id');
					
					
					$filter_key = $this->input->get('filter_key');
										
					$filterArray = array(
                            "start_date" => $start_date,
							"end_date" => $end_date,
							"client_id" => $client_id,
							"office_id" => $office_id,
							"site_id" => $site_id,
							"filter_key" => $filter_key,
							"user_site_id"=> $user_site_id,
							"dept_id"=> $dept_id,
							"sub_dept_id"=> $sdValue,
                     ); 
					
					
					//print_r ($filterArray);
					
					if($filter_key!="" && $filter_key!="OfflineList" ){
					
						switch(trim($filter_key)){
							case 'Site':
								$filter_value = $this->input->get('site_id');
								break;
							case 'Agent':
								$filter_value = $this->input->get('agent_id');
								break;
							case 'Process':
								$filter_value = $this->input->get('process_id');
								
								break;
							case 'Disposition':
								$filter_value = $this->input->get('disp_id');
								break;
							case 'Role':
								$filter_value = $this->input->get('role_id');
								break;
							case 'AOF':
								$filter_value = $this->input->get('assign_id');
								break;	
						}
						
						if($filter_value=="") $filter_value = $this->input->get('filter_value');
						
									
					}
					
					$filterArray["filter_value"]=$filter_value;
					
					//if($role_id =='2' || $role_id=='5' || $role_id=='9') $filterArray["assigned_to"]=$current_user;
					if(get_dept_folder()=="hr" || get_dept_folder()=="rta" || get_dept_folder()=="wfm" || get_dept_folder()=="mis") $filterArray["assigned_to"]="";	 
					else if(get_role_dir()=="trainer" || get_role_dir()=="tl") $filterArray["assigned_to"]=$current_user;
					else $filterArray["assigned_to"]="";	

					$data['process_list'] = array(); // $this->Common_model->get_process_for_assign();
					
					//print_r($filterArray);
					
					$rr = $fullArr = $this->reports_model->get_user_list_report($filterArray);
					
					//////////LOG////////
				
					$Lfull_name=get_username();
					$LOMid=get_user_omuid();
					$all_params=str_replace('%2F','/',http_build_query($filterArray));
					
					$LogMSG="View OR Download Main Report with ". $all_params;
					
					log_message('FEMS', $LOMid.' - ' . $Lfull_name . ' | '.$LogMSG );
						
					////////////////////////////////////////////////////////////////
					
					//
					// Pagination Module Start
					//
					
					$_total_rows = count($rr);
					
					$_per_page = 50;	// defaults for number of records to show
					$_uri_segment = 2;
					
					$_page_url = base_url()."reports";
					
					$qStr = array(
                            "start_date" => $start_date,
							"end_date" => $end_date,
							"client_id" => $client_id,
							"office_id" => $office_id,
							"site_id" => $site_id,
							"dept_id"=> $dept_id,
							"sub_dept_id"=> $sdValue,
                            "filter_value" => $filter_value,
							"filter_key" => $filter_key,
							"showReports" => "Show"
                        ); 
					
					//print_r($qStr);
					
					$res = pagination_config( $_page_url , $_total_rows , $_per_page, $_uri_segment,$qStr );
					
					$data['links'] = $res["links"];
					$data['total'] = $_total_rows;
					$data['start'] = $res['start'];
					$data['limit'] = $res['limit'];
					$data['no_records'] = ($_total_rows==0 ? true : false);
					
					if($res['start'] > $_total_rows) redirect($_page_url,"refresh");
					
					if((($res["page_number"]-1) * $_per_page) <= $_total_rows ) 
					{
						if(($res["page_number"] * $_per_page) - $_per_page < 0) $_start_limit = 0;
						else $_start_limit = ($res["page_number"] * $_per_page) - $_per_page;
						
						$data['user_list'] = array_splice($rr,$_start_limit,$_per_page);
						
					}
					else
					{
						$data['user_list'] = $rr;
						redirect($_page_url,"refresh");
					}
										
					//
					// Pagination Module End
					//				
					//print $this->reports_model->get_user_list_report_count($filterArray);
					$this->create_CSV($fullArr,$filterArray);
					//$dn_link = "../assets/reports/Report".get_user_id().".csv";
					$dn_link = base_url()."reports/downloadCsv";
					
				} else{
					$data['links'] = "";
					$data['total'] = "";
					$data['start'] = "";
					$data['limit'] = "";
					$data['no_records'] = true;
				}
				
					
				$data['start_date']=$start_date;
				$data['end_date']=$end_date;
				$data['filter_key']=$filter_key;
				$data['filter_value']=$filter_value;
				
				$data['cValue']=$client_id;
				$data['sValue']=$site_id;
				$data['oValue']=$office_id;
				$data['dept_id']=$dept_id;
				$data['sdValue']=$sdValue;
				
				$data['ses_role_id']=$role_id;
				
				
				//$data["aside_template"] = get_aside_template();
				$data["aside_template"] = $this->aside;
				
				$data["content_template"] = "reports/rep_main.php";
			    
				$data['client_list'] = $this->Common_model->get_client_list();
				
				if(get_role_dir()=="super" || $is_global_access==1){
					$data['site_list'] = $this->Common_model->get_sites_for_assign();
					$data['location_list'] = $this->Common_model->get_office_location_list();
				}else{
					$sCond=" Where id = '$user_site_id'";
					
					$data['site_list'] = $this->Common_model->get_sites_for_assign2($sCond);
					$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
				}
					
					
				$data['process_list'] = array(); // $this->Common_model->get_process_for_assign();
				$data['disp_list'] = $this->Common_model->get_event_for_assign();
				
				if(get_role_dir()=="tl" || get_role_dir()=="trainer"){
					$qSql="SELECT id,name FROM role where is_active=1 and folder not in('super','admin','manager') ORDER BY name";
					$data['role_list'] = $this->Common_model->get_rolls_for_assignment2($qSql); 
				}else{
					//$data['roll_list'] = $this->Common_model->get_rolls_for_assignment();
					$qSql="SELECT id,name FROM role where is_active=1 and folder not in('super','admin') ORDER BY name";
					$data['role_list'] = $this->Common_model->get_rolls_for_assignment2($qSql);	
				}
				
				if(get_role_dir()=="super"){			
						$data['assign_list'] = $this->Common_model->get_tls_for_assign2("");
				}else if(get_role_dir()=="admin"){
					$tl_cnd=" and dept_id='$ses_dept_id' ";
					$data['assign_list'] = $this->Common_model->get_tls_for_assign2($tl_cnd);
				}else{
					$tl_cnd=" and (site_id='$user_site_id' OR office_id='$user_office_id') ";
					$data['assign_list'] = $this->Common_model->get_tls_for_assign2($tl_cnd);
				}
				
				$data['department_list'] = $this->Common_model->get_department_list();	
				$data['sub_department_list'] = $this->Common_model->get_sub_department_list($dept_id);
								
				if($filter_key=="") $othVal="";
				else if($filter_key=="OfflineList") $othVal="OfflineList";
				else $othVal=$filter_key."-".$filter_value;
				
				$dn_param='sd='.$start_date.'&ed='.$end_date.'&oth='.$othVal; 
				$dn_param2=$_SERVER["QUERY_STRING"];
								
				$data['dn_param']=$dn_param;
				$data['dn_param2']=$dn_param2;
				$data['download_link']=$dn_link;
				
				$this->load->view('dashboard',$data);
			
        }
    }
	
	public function downloadCsv()
	{		
		$s_date = $this->input->get('sd');
		$e_date = $this->input->get('ed');
		$oth = $this->input->get('oth');
		
		//////////LOG////////
		$Lfull_name=get_username();
		$LOMid=get_user_omuid();
		$LogMSG="Download Main Report";
		log_message('FEMS', $LOMid.' - ' . $Lfull_name . ' | '.$LogMSG );
		//////////
		
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$newfile="report-".$s_date."to".$e_date. "-" .$oth.".csv";
		header('Content-Disposition: attachment;  filename="'.$newfile.'"');
		readfile($filename);
	}
	
	public function create_CSV($rr,$fArray)
	{
		
		
		$filter_key=$fArray["filter_key"];
		if($filter_key!="" && $filter_key!="OfflineList") $filter_value=$fArray["filter_value"];
		else $filter_value="";
		
		$filename = "./assets/reports/Report".get_user_id().".csv";
		
		$fopen = fopen($filename,"w+");
	
		//$header = array("Date", "OM ID", "Agent Name", "Site", "Process", "Role", "Team Leader", "Login Date", "Login Time", "Logout Time", "Logged In Hours", "Disposition", "Comments");
		
		if($filter_key=="OfflineList" || $filter_value=="2,3,4"){
			$header = array("Date", "Fusion ID", "OM ID", "Agent Name","Dept","Client Name", "Site", "Process", "L1 Supervisor", "Login Time (EST)", "Login Time(Local)", "Logout Time (EST)", "Logout Time (Local)",  "Logged In Hours","Other Break Time","Lunch/Dinner Break Time", "Disposition", "Ticket No" , "Comments");
		}else{
			$header = array("Date", "Fusion ID", "OM ID", "Agent Name","Dept","Client Name", "Site", "Process", "L1 Supervisor", "Login Time (EST)", "Login Time(Local)", "Logout Time (EST)", "Logout Time (Local)", "Logged In Hours","Other Break Time","Lunch/Dinner Break Time", "Disposition", "Comments");
		}
		
		
		
		$row = "";
		
		foreach($header as $data) $row .= ''.$data.',';
		
		fwrite($fopen,rtrim($row,",")."\r\n");

		foreach($rr as $user)
		{	
		
			$logged_in_hours = $user['logged_in_hours'];
			$tBrkTime=$user['tBrkTime'];
			$ldBrkTime=$user['ldBrkTime'];
			$disposition=$user['disposition'];
			$work_time=$logged_in_hours;
			
			
			$office_id = $user['office_id'];
			$todayLoginTime=$user['todayLoginTime'];
			$is_logged_in = $user['is_logged_in'];
								
			$flogin_time = $user['flogin_time'];
			$flogin_time_local = $user['flogin_time_local'];
			
			$logout_time=$user['logout_time'];
			$logout_time_local=$user['logout_time_local'];
			
			$total_break=$tBrkTime+$ldBrkTime;
			
			$comments = $user['comments'];
			
			////////// For System Logout /////////////////////
			if($user['logout_by']=='0'){
				//$work_time=0;
				//$logout_time="";
				$comments = "System Logout";
			}
			
			$net_work_time=gmdate('H:i:s',$work_time);
			$total_break = gmdate('H:i:s',$total_break);
			$tBrkTime = gmdate('H:i:s',$tBrkTime);
			$ldBrkTime = gmdate('H:i:s',$ldBrkTime);
			
			if($logged_in_hours!="0"){
				$disposition = 'P'; 
			}else if($disposition!="") $disposition = $disposition;
			 else $disposition = 'MIA';
			 
			
			if($is_logged_in == '1'){
				$todayLoginArray = explode(" ",$todayLoginTime);
				if($rdate == $todayLoginArray[0]){
					
					$flogin_time = $todayLoginTime;
					$flogin_time_local = ConvServerToLocalAny($todayLoginTime,$office_id);
					
					$ldBrkTime="";
					$tBrkTime= "";
					$logged_in_hours = "";										
					$disposition="online";
					$logout_time = "online";
					$logout_time_local = "online";
					$net_work_time="";									
				}
			}
			
			$row = '"'.$user['rDate'].'",'; 
			$row .= '"'.$user['fusion_id'].'",'; 
			$row .= '"'.$user['omuid'].'",'; 
			$row .= '"'.$user['fname'] . " ". $user['lname'].'",'; 
			$row .= '"'.$user['dept_name'].'",'; 
			$row .= '"'.$user['client_name'].'",'; 
			$row .= '"'.$user['office_id'].'",'; 
			$row .= '"'.$user['process_name'].' '.$user['sub_process_name'].'",'; 
			$row .= '"'.$user['asign_tl'].'",'; 
			
			//$row .= '"'.$user['role_name'].'",'; 
			//$row .= '"'.$user['login_date'].'",'; 
			
			$row .= '"'.$flogin_time.'",';
			$row .= '"'.$flogin_time_local.'",'; 
			$row .= '"'.$logout_time.'",'; 
			$row .= '"'.$logout_time_local.'",'; 
			$row .= '"'.$net_work_time.'",';
			$row .= '"'.$tBrkTime.'",'; 
			$row .= '"'.$ldBrkTime.'",'; 
			
			$row .= '"'.$disposition.'",';
			
			if($filter_key=="OfflineList" || $filter_value=="2,3,4"){
				$row .= '"'.$user['ticket_no'].'",'; 
			} 
											
			$row .= '"'. $comments .'"'; 
			
			fwrite($fopen,$row."\r\n");
		}
		
		fclose($fopen);
		
	}
	
	
	public function attrition()
	{
		
		if(check_logged_in())
        {
			$this->check_access();
			
			$role_id= get_role_id();
			$current_user = get_user_id();
			//echo $current_user;
			//////////////////////////////////
			$user_site_id= get_user_site_id();
			//////////////////////////////////
			$user_office_id=get_user_office_id();
			$ses_dept_id=get_dept_id();
			
			$start_date="";
			$end_date="";
			$filter_key="";
			$filter_value="";
			$client_id="";
			$site_id="";
			$office_id="";
			$dept_id = "";
			
				//$data["aside_template"] = get_aside_template();
				$data["aside_template"] = $this->aside;
				$data["content_template"] = "reports/attrition.php";
			    
				$this->load->model('Common_model');
				
				//$data['department_list'] = $this->Common_model->get_department_list();	
				
				$data['client_list'] = $this->Common_model->get_client_list();				
				$data['location_list'] = $this->Common_model->get_office_location_list();
				
				$data['site_list'] = $this->Common_model->get_sites_for_assign();
				
				$data['process_list'] = array(); // $this->Common_model->get_process_for_assign();
				
				if(get_role_dir()=="tl" || get_role_dir()=="trainer"){
					$qSql="SELECT id,name FROM role where is_active=1 and folder not in('super','admin','manager') ORDER BY name";
					$data['role_list'] = $this->Common_model->get_rolls_for_assignment2($qSql); 
				}else{
					//$data['roll_list'] = $this->Common_model->get_rolls_for_assignment();
					$qSql="SELECT id,name FROM role where is_active=1 and folder not in('super','admin') ORDER BY name";
					$data['role_list'] = $this->Common_model->get_rolls_for_assignment2($qSql);	
				}
								
				if(get_role_dir()=="super"){			
						$data['assign_list'] = $this->Common_model->get_tls_for_assign2("");
				}else if(get_role_dir()=="admin"){
					$tl_cnd=" and dept_id='$ses_dept_id' ";
					$data['assign_list'] = $this->Common_model->get_tls_for_assign2($tl_cnd);
				}else{
					$tl_cnd=" and (site_id='$user_site_id' OR office_id='$user_office_id') ";
					$data['assign_list'] = $this->Common_model->get_tls_for_assign2($tl_cnd);
				}
				
				$data['user_list'] =array();
				
				$data['rep_done']="N";
				
				$data['timeframe_days']="";
				$data['year']="";
				$data['avg_days_month']="";
				$data['hired_count']="";
				$data['train_term_count']="";
				$data['nest_term_count']="";
				$data['prod_term_count']="";
				$data['active_count']="";
				$data['prod_term_tenure']="";
				$data['active_tenure']="";
				$data['timeframe_attrition']="";
				$data['active_monthly_attrition']="";
				$data['annualized_attrition']="";
							
				$_atitle="";
				
				if($this->input->post('showReports')=='Show')
				{
				
						$start_date = $this->input->post('start_date');
						$end_date = $this->input->post('end_date');
						$filter_key = $this->input->post('filter_key');
						
						$client_id = $this->input->post('client_id');
						$site_id = $this->input->post('site_id');
						$office_id = $this->input->post('office_id');
						
						//$dept_id = $this->input->post('dept_id');
						//if($dept_id=="")  $dept_id=$ses_dept_id;
				 
						$filterArray = array(
									"start_date" => $start_date,
									"end_date" => $end_date,
									"client_id" => $client_id,
									"office_id" => $office_id,
									"site_id" => $site_id,
									"filter_key" => $filter_key,
									"user_site_id"=> $user_site_id,
							 ); 
							 
						$_cnd="";
						$site_cond="";
						$aof_cond="";
						
						if($filter_key!="" ){
								
							switch(trim($filter_key)){
								case 'Site':
									$filter_value = $this->input->post('site_id');
									$_cnd = " and site_id = '".$filter_value."'";
									//$site_cond = " and id = '".$filter_value."'";
									
									$qSql="Select name as value from  site where id='$filter_value'";
									$_atitle = " - ".$this->Common_model->get_single_value($qSql);
									break;
									
								case 'Agent':
									$filter_value = $this->input->post('agent_id');
									$_cnd = " and  (omuid = '".$filter_value."' OR fusion_id='".$filter_value."') ";
									$_atitle = " - Agent-'".$filter_value."'";
									break;
											
								case 'Process':
									$filter_value = $this->input->post('process_id');
									if($filter_value !="0") $_cnd = " and process_id = '".$filter_value."'";
									
									$qSql="Select name as value from  process where id='$filter_value'";
									$_atitle = " - ".$this->Common_model->get_single_value($qSql);
						
									break;
								case 'Role':
									$filter_value = $this->input->post('role_id');
									$_cnd = " and role_id = '".$filter_value."'";
									
									$qSql="Select name as value from  role where id='$filter_value'";
									$_atitle = " - ".$this->Common_model->get_single_value($qSql);
						
									break;
								case 'AOF':
									$filter_value = $this->input->post('assign_id');
									$_cnd = " and assigned_to = '".$filter_value."'";
																		
									$qSql="Select CONCAT(fname,' ' ,lname) as value from  signin where id='$filter_value'";
									$_atitle = " - All Agents of ".$this->Common_model->get_single_value($qSql);
									break;	
							}
							
							if($filter_value=="") $filter_value = $this->input->get('filter_value');
										
						}
						
						$filterArray["filter_value"]=$filter_value;
						
						//if($role_id =='2' || $role_id=='5' || $role_id=='9') $filterArray["assigned_to"]=$current_user;
						if(get_dept_folder()=="hr" || get_dept_folder()=="rta" || get_dept_folder()=="wfm" || get_dept_folder()=="mis") $filterArray["assigned_to"]="";	 						
						else if(get_role_dir()=="trainer" || get_role_dir()=="tl") $filterArray["assigned_to"]=$current_user;
						else $filterArray["assigned_to"]="";		
										
						if(get_role_id()>1 && get_role_id()!=6){
							if($user_site_id!="" && $user_site_id!="0" && $user_site_id!="ALL" ) $_cnd .= " and site_id = '".$user_site_id."'";
						}
												
						if($client_id!=="" && $client_id!="ALL")  $_cnd .= " and client_id = '".$client_id."'";
						
						if($client_id=='1'){
							if($site_id!=="" && $site_id!="ALL")  $_cnd .= " and site_id = '".$site_id."'";
						}else{
							if($office_id!=="" && $office_id!="ALL")  $_cnd .= " and office_id = '".$office_id."'";
						}

						//if($dept_id!=="" && $dept_id!="ALL")  $_cnd .= " and dept_id = '".$dept_id."'";
												
											
						$attr_rep_title="Attrition Report ".$_atitle;
						$data['attr_rep_title']=$attr_rep_title;
										
						////////////
					
						//$currDate=CurrDate();
						//$currDate=date('Y-m-d',strtotime($currDate.' -1 day'));
						//echo "Current Date : ".CurrMySqlDate() ."\r\n";
						//echo "Current Date : ".$currDate ."\r\n";
						//echo "Month No: ".getMonthNumber($currDate) ."\r\n";	
						//echo "Year: ". getYear($currDate) ."\r\n";
						//echo "Month day: ". daysInMonth($currDate) ."\r\n";
						//echo "year days: ".daysInYear($year) ."\r\n";			
						//echo dateDiffCount("2016-03-15","2016-03-10");
						////
						
						$all_arr=$this->getAttritionData($filterArray,$_cnd);
						
						$this->createExcelAttrition($all_arr,$filterArray);
												
						//////////LOG////////
		
						$Lfull_name=get_username();
						$LOMid=get_user_omuid();
						$all_params=str_replace('%2F','/',http_build_query($filterArray));
						$LogMSG="Download attrition Report with ". $all_params;
						log_message('FEMS', $LOMid.' - ' . $Lfull_name . ' | '.$LogMSG );
							
						//////////
						
				}
			
			$data['start_date']=$start_date;
			$data['end_date']=$end_date;
			$data['filter_key']=$filter_key;
			$data['filter_value']=$filter_value;
			
			$data['ses_role_id']=$role_id;
			
			$data['cValue']=$client_id;
			$data['sValue']=$site_id;
			$data['oValue']=$office_id;
			$data['dept_id']=$dept_id;
						
			$data['dn_param']="";
			$data['dn_param2']="";
			$data['download_link']="";				
			$this->load->view('dashboard',$data);
			
	   }
	}
	
	
	
	
	public function sendMonthlyAttrition()
	{

				$cDateYmd=CurrDate();
				$start_date=date('m-01-Y', strtotime($cDateYmd));
				//$end_date =date("m-d-Y",time());
				$end_date=date('m-d-Y',strtotime($cDateYmd.' -1 day'));	
				
				//echo $start_date . " >> ".$end_date ."<br>";
				
				$filterArray = array(
						"start_date" => $start_date,
						"end_date" => $end_date,
						"filter_key" => "",
						"client_id" => '1',
						"assigned_to" => "",
						"user_site_id" => "",
						"filter_value" => "",
						"dept_id"=> "",
				 ); 
				 
				//$file_month=strtolower(date('F-Y', strtotime($cDateYmd)));
				//$file_name=$this->createExcelSummary($filterArray,'Y');
				$_cnd="";
				$_cnd = " and client_id = '1";
				
				$all_arr=$this->getAttritionData($filterArray,$_cnd);
										
				$file_name=$this->createExcelAttrition($all_arr,$filterArray,'Y');
				
				//echo "\r\n". $file_name ."\r\n";
				
				if($file_name!="ERROR"){
				
					$file_path =FCPATH."temp_files/attrition/".$file_name;
					
					//echo $file_path;
					
					$uid="";
					
					$eto="arif.anam@fusionbposervices.com, saikat.ray@fusionbposervices.com,kunal.bose@fusionbposervices.com, rabi.dhar@fusionbposervices.com";
					
					$from_email="noreply.sox@fusionbposervices.com";
					$from_name="Fusion SOX";
				
					$ecc="";
					$ebody="Hi<br>Please check the attachment files.";
					$esubject="Test Email to Auto Send Attrition Report.";
					
					$email_resp=false;
					
					// $email_resp=$this->Common_model->send_email_sox($uid,$eto,$ecc,$ebody,$esubject,$file_path,$from_email,$from_name);
					if($email_resp==true){
						
						unlink($file_path);
						//$LogMSG="successfully Sent Attrition Report of ".$file_month;	
						//log_message('FEMS', ' | '.$LogMSG );
						
					}else{
					
						$uid="";
						$eto="arif.anam@fusionbposervices.com, saikat.ray@fusionbposervices.com,kunal.bose@fusionbposervices.com, rabi.dhar@fusionbposervices.com";
						$ecc="";
						$ebody="Hi<br>Failure to send Attrition Report.";
						$esubject="Failure to Send Attrition Report.";
						
						// $email_resp=$this->Common_model->send_email_sox($uid,$eto,$ecc,$ebody,$esubject);
					
						//$LogMSG="successfully Sent Attrition Report of ".$file_month;	
						//log_message('FEMS', ' | '.$LogMSG );
					}
					
				}else{
										
					//$LogMSG="Error To Sent Attrition Report of ".$file_month;	
					//log_message('FEMS', ' | '.$LogMSG );
					
					$uid="";
					$eto="arif.anam@fusionbposervices.com, saikat.ray@fusionbposervices.com,kunal.bose@fusionbposervices.com, rabi.dhar@fusionbposervices.com";
					$ecc="";
					$ebody="Hi<br>Failure to Export Attrition Report.";
					$esubject="Failure to Export Attrition Report.";
					
					// $email_resp=$this->Common_model->send_email_sox($uid,$eto,$ecc,$ebody,$esubject);
					
				}
	}
			
	
	//////
	private function getAttritionData($filterArr,$_cnd)
	{
	
						
			$start_date=$filterArr['start_date'];
			$end_date=$filterArr['end_date'];		
			$filter_key=$filterArr['filter_key'];
			
			
			$stDate=mmddyy2mysql($start_date);
			$enDate=mmddyy2mysql($end_date);
								
			$year=getYear($stDate);
			$avg_days_month=daysInYear($year)/12;
			
			//$stDate=mmddyy2mysql($start_date);
			//$enDate=mmddyy2mysql($end_date);							
			
			$full_timeframe_days=dateDiffCount($stDate,$enDate);
								
			
			if($_cnd=="" ) $qSql="SELECT * FROM site where is_active=1 order by name";
			else $qSql="SELECT * FROM site where id in (SELECT DISTINCT site_id from signin where status=1 $_cnd) order by name";
			
			
			$site_list=$this->Common_model->get_query_result_array($qSql);
			
			$tot_site=count($site_list);
			if($filter_key=="Site" || $tot_site==1) $oatag=0;
			else $oatag=-1;
			
			$all_arr = array();
			
			//foreach($site_list as $sRow){
			for($i=$oatag;$i<$tot_site;$i++){
				
				$proc_arr = array();
				
				if($i==-1){
					$site_name="OVERALL";										
					$site_cond="";
					$site_cond2="";						
				}else{
					$sRow=$site_list[$i];
					$site_id=$sRow['id'];	
					$site_name=$sRow['name'];										
					$site_cond=" and site_id='$site_id'";
					$site_cond2=" where site_id='$site_id' $_cnd";
				}
				//$qSql="SELECT * FROM process  where is_active=1 order by name";
				$qSql="SELECT * from process where id in (SELECT DISTINCT process_id FROM `signin` $site_cond2 ) order by name";			
				$process_list=$this->Common_model->get_query_result_array($qSql);
				
				foreach($process_list as $row){
	
					$week_count_arr = array();
					$weekCnt=0;
					
					$process_id=$row['id'];	
					$process_name=$row['name'];								
					
					//echo $process_name. " (". $process_id .")\r\n";
					//////////
					
					$wStDate=mmddyy2mysql($start_date);
					$wEnDate=mmddyy2mysql($end_date);
					
					$is_overall=false;
												
					while(($wStDate <= $wEnDate) || ($is_overall==true && $weekCnt>1) ){
					
					$count_arr = array();
					
					
					$stDate=$wStDate;
					
					if($is_overall==false){
														
						if(date('D', strtotime($stDate)) == "Sun") $enDate=$stDate;
						else{
							$enDate=date('Y-m-d',strtotime($stDate.' +1 Sunday'));
							
							if($enDate>=$wEnDate){
								$enDate=$wEnDate;
								$is_overall=true;
							}
						}
					
					 $wStDate= date('Y-m-d',strtotime($enDate .' +1 day'));
						
					}else{
						$is_overall=false;
						$stDate=mmddyy2mysql($start_date);
						$enDate=mmddyy2mysql($end_date);
						
					}
					
				//	echo $wStDate . " >> ". $wStDate . " >> "  .$is_overall ."\r\n";
					
			
					$qSql="Select count(id) as value from signin where doj>='$stDate' and doj<='$enDate' and process_id='$process_id' $site_cond $_cnd";
					
					$hired_count=$this->Common_model->get_single_value($qSql);
					
					$qSql="Select count(user_id) as value from terminate_users a, signin b where a.user_id=b.id and role_id='7' and cast(terms_date as date)>='$stDate' and cast(terms_date as date)<='$enDate' and is_term_complete='Y' and process_id='$process_id' $site_cond $_cnd";
					$train_term_count=$this->Common_model->get_single_value($qSql);
					
					$qSql="Select count(user_id) as value from terminate_users a, signin b where a.user_id=b.id and role_id='8' and cast(terms_date as date)>='$stDate' and cast(terms_date as date)<='$enDate' and is_term_complete='Y' and process_id='$process_id' $site_cond $_cnd";
					$nest_term_count=$this->Common_model->get_single_value($qSql);
					
					$qSql="Select count(user_id) as value from terminate_users a, signin b where a.user_id=b.id and role_id='3' and cast(terms_date as date)>='$stDate' and cast(terms_date as date)<='$enDate' and is_term_complete='Y' and process_id='$process_id' $site_cond $_cnd";
					$prod_term_count=$this->Common_model->get_single_value($qSql);
					
					
					// (Total number of Active Agents) - (Any Agent Hired after the last date entered)			
					//$qSql="Select count(id) as value from signin where status=1 and role_id='3' and doj<='$enDate' and process_id='$process_id' $site_cond $_cnd";
					
					// role_id in (3,7,9) 3-> agent ,7->Trainee, 8-> Nesting
					
					$qSql="Select count(id) as value from signin where id not in (Select user_id from terminate_users where cast(terms_date as date)<='$enDate' and is_term_complete='Y' and (rejon_date is null OR rejon_date>'$enDate')) and role_id='3' and status!='9'  and (doj is null OR doj<='$enDate') and process_id='$process_id' $site_cond $_cnd";
					$active_count=$this->Common_model->get_single_value($qSql);
								
					//Prod Term Tenure = average number of days between Hire Date and Term Date for Prod Term agents whose Term Date falls between the 2 Dates.
					
					$qSql="Select AVG(datediff(terms_date,doj)+1) as value from terminate_users a, signin b where a.user_id=b.id and role_id='3' and cast(terms_date as date)>='$stDate' and cast(terms_date as date)<='$enDate' and is_term_complete='Y' and process_id='$process_id' $site_cond $_cnd";
					$prod_term_tenure =$this->Common_model->get_single_value($qSql);
								
					//average the difference between Hire Date and Last Date
					//$qSql="Select AVG(datediff(CONVERT('$enDate',DATE),doj)+1) as value from signin where status=1 and role_id='3' and doj<='$enDate' and process_id='$process_id' $site_cond $_cnd";
					
					$qSql="Select AVG(datediff(CONVERT('$enDate',DATE),doj)+1) as value from signin where id not in (Select user_id from terminate_users where cast(terms_date as date)<='$enDate' and is_term_complete='Y' and (rejon_date is null OR rejon_date>'$enDate')) and role_id='3' and status!='9' and (doj is null OR doj<='$enDate') and process_id='$process_id' $site_cond $_cnd";
					//echo $qSql;
					$active_tenure = $this->Common_model->get_single_value($qSql);
					
					//Attrition during the timeframe
												
					$timeframe_days=dateDiffCount($stDate,$enDate);
					
					$tot_count=$nest_term_count+$prod_term_count+$active_count;
					if($tot_count==0) $timeframe_attrition=0;
					else  $timeframe_attrition=($nest_term_count+$prod_term_count)/$tot_count;
								
					//Active Monthly Attrition = (Nest Term Count + Prod Term Count) / (Active Count + Nest Term Count + Prod Term Count) * (Days between From/To) / 30.42
					
					$active_monthly_attrition = $timeframe_attrition*($timeframe_days/$avg_days_month);
					
					$annualized_attrition = $active_monthly_attrition*12;
					
					if($full_timeframe_days==$timeframe_days && $weekCnt>1) $count_arr['TOTAL']='Y';
					else $count_arr['TOTAL']='N';
					
					$count_arr['Week']="Week-".($weekCnt+1);
					
					$count_arr['stdate']=$stDate;
					$count_arr['endate']=$enDate;
					
					$count_arr['timeframe_days']=$timeframe_days;
					$count_arr['year']=$year;
					$count_arr['avg_days_month']=$avg_days_month;
					
					$count_arr['hired_count']=$hired_count;
					$count_arr['train_term_count']=$train_term_count;
					$count_arr['nest_term_count']=$nest_term_count;
					$count_arr['prod_term_count']=$prod_term_count;
					$count_arr['active_count']=$active_count;
					$count_arr['prod_term_tenure']=round($prod_term_tenure,2);
					$count_arr['active_tenure']=round($active_tenure,2);
					$count_arr['timeframe_attrition']=$timeframe_attrition;
					$count_arr['active_monthly_attrition']=$active_monthly_attrition;
					$count_arr['annualized_attrition']=$annualized_attrition;
					//$process_name
					
					$week_count_arr[$weekCnt++]=$count_arr;
					
					}//week
					
					$proc_arr[$process_name]=$week_count_arr;
												
				} //process
				
				//////
				$all_arr[$site_name]=$proc_arr;
			} //site
			
			//$data['all_list']=$all_arr;
			//$data['rep_done']="Y";
			//print_r($all_arr);
						
			return $all_arr;
			
	}
	
	
	
	private function createExcelAttrition($all_list,$filterArr,$is_monthly='N')
	{
		
			$start_date =$filterArr['start_date'];
			$end_date =$filterArr['end_date'];		
			$filter_key =$filterArr['filter_key'];
			$assigned_to=$filterArr['assigned_to'];
			$user_site_id =$filterArr['user_site_id'];
			
			$client_id=$filterArr['client_id'];
			$client_name="";
			if($client_id!=="" && $client_id!="ALL"){
				$client_name="-".$this->Common_model->get_single_value("Select shname as value from  client where id='$client_id'");
			}
			
			
			$stDate=mmddyy2mysql($start_date);
			$enDate=mmddyy2mysql($end_date);
								
			$year=getYear($stDate);
			$avg_days_month=daysInYear($year)/12;
			
			//$stDate=mmddyy2mysql($start_date);
			//$enDate=mmddyy2mysql($end_date);
			
			$timeframe_days=dateDiffCount($stDate,$enDate);
			
			
			$filter_value="";
			$_atitle="";
			
			if($filter_key!=""){
			
				$filter_value =$filterArr['filter_value'];
				
				switch($filter_key){
					case 'Site':
						
						$qSql="Select name as value from  site where id='$filter_value'";
						$_atitle = " - All Agents in ".$this->Common_model->get_single_value($qSql);
					
						break;
					case 'Agent':
						
						$_atitle = " - Agent-'".$filter_value."'";
						
						break;
					case 'Process':
						
						$qSql="Select name as value from  process where id='$filter_value'";
						$_atitle = " - ".$this->Common_model->get_single_value($qSql);
					
						break;
					case 'Role':
						$qSql="Select name as value from  role where id='$filter_value'";
						$_atitle = " - ".$this->Common_model->get_single_value($qSql);
						break;
					case 'AOF':
						$qSql="Select CONCAT(fname,' ' ,lname) as value from  signin where id='$filter_value'";
						$_atitle = " - All Agents of ".$this->Common_model->get_single_value($qSql);
						break;
						
				}	
			}	
						
			$start_date =str_replace("/","-",$start_date);
			$end_date =str_replace("/","-",$end_date);
			
			if($_atitle=="") $_atitle = " - All Agents";
			
			if($is_monthly!="Y"){
				
				$fn="attrition".$client_name.'-'.$start_date."_".$end_date.$_atitle.".xls";
				//$filename = "./assets/reports/".$fn;
			}else{
				$file_name="attrition".$client_name.'_'.strtolower(date('F', strtotime($stDate)));
				$fn=$file_name."_".$stDate."_".$enDate.".xls";
			}
			
			$filename =FCPATH."temp_files/attrition/".$fn;
			
			$sht_title=$start_date." To ".$end_date;
			
			
			$default_border = array(
				'style' => PHPExcel_Style_Border::BORDER_THIN,
				'color' => array('rgb'=>'1006A3')
			);

			$style_header = array(
				'borders' => array(
					'bottom' => $default_border,
					'left' => $default_border,
					'top' => $default_border,
					'right' => $default_border,
				),
				'fill' => array(
					'type' => PHPExcel_Style_Fill::FILL_SOLID,
					'color' => array('rgb'=>'E1E0F7'),
				),
				'font' => array(
					'bold' => true,
					'size' => 11,
				),
				'alignment' => array(
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
					'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
				)
			);
			
			$style_header_left = array(
				'borders' => array(
					'bottom' => $default_border,
					'left' => $default_border,
					'top' => $default_border,
					'right' => $default_border,
				),
				'fill' => array(
					'type' => PHPExcel_Style_Fill::FILL_SOLID,
					'color' => array('rgb'=>'00008B'),
				),
				'font' => array(
					'bold' => true,
					'size' => 11,
					'color' => array('rgb'=>'FFFFFF'),
				),
				'alignment' => array(
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
					'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
				)
			);
			
			$style_p = array(
				'borders' => array(
					'bottom' => $default_border,
					'left' => $default_border,
					'top' => $default_border,
					'right' => $default_border,
				),
				'fill' => array(
					'type' => PHPExcel_Style_Fill::FILL_SOLID,
					'color' => array('rgb'=>'68A368'),
				),
				'font' => array(
					'size' => 10,
				),
				'alignment' => array(
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
					'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
				)
			);
			
			$style_sum = array(
				'borders' => array(
					'bottom' => $default_border,
					'left' => $default_border,
					'top' => $default_border,
					'right' => $default_border,
				),
				'fill' => array(
					'type' => PHPExcel_Style_Fill::FILL_SOLID,
					'color' => array('rgb'=>'00b0f0'),
				),
				'font' => array(
					'size' => 10,
					'bold' => true,
				),
				'alignment' => array(
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
					'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
				)
			);
			
			$style_l = array(
				'borders' => array(
					'bottom' => $default_border,
					'left' => $default_border,
					'top' => $default_border,
					'right' => $default_border,
				),
				'fill' => array(
					'type' => PHPExcel_Style_Fill::FILL_SOLID,
					'color' => array('rgb'=>'FFFF00'),
				),
				'font' => array(
					'size' => 10,
				),
				'alignment' => array(
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
					'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
				)
			);
			
			$style_def = array(
				'borders' => array(
					'bottom' => $default_border,
					'left' => $default_border,
					'top' => $default_border,
					'right' => $default_border,
				),
				'font' => array(
					'size' => 10,
				),
				'alignment' => array(
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
					'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
				)
			);
			
			$style_def_left = array(
				'font' => array(
					'size' => 10,
				),
				'alignment' => array(
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
					'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
				)
			);
			
			/*
			$style_def_left = array(
				'borders' => array(
					'bottom' => $default_border,
					'left' => $default_border,
					'top' => $default_border,
					'right' => $default_border,
				),
				'font' => array(
					'size' => 10,
				)
			);
			*/
			//'code' => PHPExcel_Style_NumberFormat::FORMAT_PERCENTAGE_00
			//$letters = range('A', 'Z');
			
			$letters = array(); 
			$k=0;
			 for ($i = 'A'; $i !== 'ZZ'; $i++){
				$letters[$k++]=$i;
			}
		
		////////////////////////////////
			
			//$currDate=CurrDate();
			//$currDate=date('Y-m-d',strtotime($currDate.' -1 day'));			
			//echo "Current Date : ".CurrMySqlDate() ."\r\n";
			//echo "report On Date : ".$currDate ."\r\n";
			
			//$todayDate=CurrDate();
			//$stDate=mmddyy2mysql($start_date);
			//$enDate=mmddyy2mysql($end_date);
			//$dayDiff=dateDiffCount($stDate,$enDate);
			
			$shCnt=0;
			
			foreach ($all_list as $key => $proc_arr){
				
				
				$sht_title=$key;
				$title="Attrition Report From ". $start_date." To ".$end_date. $_atitle ." - ". $key;
				
								
				if($shCnt > 0) $this->excel->createSheet();
				$this->excel->setActiveSheetIndex($shCnt);
				$shCnt++;
				
				

				//name the worksheet
				$this->excel->getActiveSheet()->setTitle($sht_title);
				//set cell A1 content with some text
			
				$this->excel->getActiveSheet()->setCellValue('A1', $title);
			
				//change the font size
				$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(14);
				//make the font become bold
				$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
				//merge cell A1 until D1
				$this->excel->getActiveSheet()->mergeCells('A1:L1');
				
				$r=3;
								
				$this->excel->getActiveSheet()->setCellValue('A'.$r, 'Formula Applied');
				$this->excel->getActiveSheet()->mergeCells('A'.$r.':L'.$r);
				$this->excel->getActiveSheet()->getStyle('A'.$r.':L'.$r)->applyFromArray($style_header_left);
				$r++;
				
				$txt="Train Term Count = a count of the number of agents with a Term Date tha falls on or between the dates entered.";
				$this->excel->getActiveSheet()->setCellValue('A'.$r, $txt);
				$this->excel->getActiveSheet()->getStyle('A'.$r)->applyFromArray($style_def_left);
				$this->excel->getActiveSheet()->mergeCells('A'.$r.':L'.$r);
				$r++;
				
				$txt="Nest Term Count = a count of the number of agents with a Term Date tha falls on or between the dates entered.";
				$this->excel->getActiveSheet()->setCellValue('A'.$r, $txt);
				$this->excel->getActiveSheet()->getStyle('A'.$r)->applyFromArray($style_def_left);
				$this->excel->getActiveSheet()->mergeCells('A'.$r.':L'.$r);
				$r++;
				
				$txt="Prod Term Count= a count of the number of agents with a Term Date tha falls on or between the dates entered.";
				$this->excel->getActiveSheet()->setCellValue('A'.$r, $txt);
				$this->excel->getActiveSheet()->getStyle('A'.$r)->applyFromArray($style_def_left);
				$this->excel->getActiveSheet()->mergeCells('A'.$r.':L'.$r);
				$r++;
				
				$txt="Active Count = (Total number of Active Agents) - (Any Agent Hired after the last date entered).";
				$this->excel->getActiveSheet()->setCellValue('A'.$r, $txt);
				$this->excel->getActiveSheet()->getStyle('A'.$r)->applyFromArray($style_def_left);
				$this->excel->getActiveSheet()->mergeCells('A'.$r.':L'.$r);
				$r++;
				
				$txt="Hired Count = a count of the number of agents with a Hire Date between the 2 dates entered.";
				$this->excel->getActiveSheet()->setCellValue('A'.$r, $txt);
				$this->excel->getActiveSheet()->getStyle('A'.$r)->applyFromArray($style_def_left);
				$this->excel->getActiveSheet()->mergeCells('A'.$r.':L'.$r);
				$r++;
				
				
				$txt="Prod Term Tenure = average number of days between Hire Date and Term Date for Prod Term Agents.";
				$this->excel->getActiveSheet()->setCellValue('A'.$r, $txt);
				$this->excel->getActiveSheet()->getStyle('A'.$r)->applyFromArray($style_def_left);
				$this->excel->getActiveSheet()->mergeCells('A'.$r.':L'.$r);
				$r++;
				
				$txt="Active Tenure = average number of days between Hire Date and the LAST DATE antered  for Active Count Agents.";
				$this->excel->getActiveSheet()->setCellValue('A'.$r, $txt);
				$this->excel->getActiveSheet()->getStyle('A'.$r)->applyFromArray($style_def_left);
				$this->excel->getActiveSheet()->mergeCells('A'.$r.':L'.$r);
				$r++;
				
				$txt="Active Timeframe Attrition = (Nest Term Count + Prod Term Count) / (Active Count + Nest Term Count + Prod Term Count)";
				$this->excel->getActiveSheet()->setCellValue('A'.$r, $txt);
				$this->excel->getActiveSheet()->getStyle('A'.$r)->applyFromArray($style_def_left);
				$this->excel->getActiveSheet()->mergeCells('A'.$r.':L'.$r);
				$r++;
				
				$txt="Active Monthly Attrition = Active Timeframe Attrition * ((Days Entered Timeframe) / Days in a month)";
				$this->excel->getActiveSheet()->setCellValue('A'.$r, $txt);
				$this->excel->getActiveSheet()->getStyle('A'.$r)->applyFromArray($style_def_left);
				$this->excel->getActiveSheet()->mergeCells('A'.$r.':L'.$r);
				$r++;
				
				$txt="Active Annualized Attrition = Active Monthly Attrition * 12";
				$this->excel->getActiveSheet()->setCellValue('A'.$r, $txt);
				$this->excel->getActiveSheet()->getStyle('A'.$r)->applyFromArray($style_def_left);
				$this->excel->getActiveSheet()->mergeCells('A'.$r.':L'.$r);
				
				$r+=3;
				
				$this->excel->getActiveSheet()->setCellValue('A'.$r, 'Date Range');
				$this->excel->getActiveSheet()->getStyle('A'.$r)->applyFromArray($style_header);
				$this->excel->getActiveSheet()->setCellValue('B'.$r, 'Days Timeframe');
				$this->excel->getActiveSheet()->getStyle('B'.$r)->applyFromArray($style_header);
				$this->excel->getActiveSheet()->setCellValue('C'.$r, 'Days in a month');
				$this->excel->getActiveSheet()->getStyle('C'.$r)->applyFromArray($style_header);
				$r++;
				$this->excel->getActiveSheet()->setCellValue('A'.$r, $start_date." - " . $end_date);
				$this->excel->getActiveSheet()->setCellValue('B'.$r, $timeframe_days);
				$this->excel->getActiveSheet()->setCellValue('C'.$r, $avg_days_month);
								
				$r+=2;
				
				////////////////////////////				
				foreach ($proc_arr as $key => $week_arr){
				
					$r++;
					$cell=$letters[0].$r;
					$this->excel->getActiveSheet()->setCellValue($cell, $key);
					//$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray($style_def );
					
					$this->excel->getActiveSheet()->getStyle($cell)->getFont()->setSize(12);
					//make the font become bold
					$this->excel->getActiveSheet()->getStyle($cell)->getFont()->setBold(true);
					//merge cell A1 until D1
					$this->excel->getActiveSheet()->mergeCells('A'.$r.':J'.$r);
					
					$j=0;
					$r++;
					
					$cell=$letters[$j++].$r;
					$this->excel->getActiveSheet()->setCellValue($cell, 'Weeks');
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
					
					$cell=$letters[$j++].$r;
					$this->excel->getActiveSheet()->setCellValue($cell, 'Date Range');
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
					
					$cell=$letters[$j++].$r;
					$this->excel->getActiveSheet()->setCellValue($cell, 'Days Timeframe');
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
					
					$cell=$letters[$j++].$r;
					$this->excel->getActiveSheet()->setCellValue($cell, 'Hired Count');
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
					
					$cell=$letters[$j++].$r;
					$this->excel->getActiveSheet()->setCellValue($cell, 'Train Term');
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
					
					$cell=$letters[$j++].$r;
					$this->excel->getActiveSheet()->setCellValue($cell, 'Nest Term');
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
					
					$cell=$letters[$j++].$r;
					$this->excel->getActiveSheet()->setCellValue($cell, 'Prod Term');
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
					
					$cell=$letters[$j++].$r;
					$this->excel->getActiveSheet()->setCellValue($cell, 'Active Count');
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
					
					$cell=$letters[$j++].$r;
					$this->excel->getActiveSheet()->setCellValue($cell, 'Prod Term Tenure');
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
					
					$cell=$letters[$j++].$r;
					$this->excel->getActiveSheet()->setCellValue($cell, 'Active Tenure');
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
					
					$cell=$letters[$j++].$r;
					$this->excel->getActiveSheet()->setCellValue($cell, 'Active Timeframe Attrition');
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
					
					$cell=$letters[$j++].$r;
					$this->excel->getActiveSheet()->setCellValue($cell, 'Active Monthly Attrition');
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
					
					$cell=$letters[$j++].$r;
					$this->excel->getActiveSheet()->setCellValue($cell, 'Annualized Attrition');
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
						
						
					//foreach ($week_arr as $key => $value){
					  foreach($week_arr as $value){
					  
						$j=0;
						$r++;
						
						$bg_style=$style_def;
						$weeknm=$value['Week'];
						
						if($value['TOTAL']=='Y'){
							$bg_style=$style_sum;
							$weeknm="Overall";
						}
						
						$cell=$letters[$j++].$r;
						$this->excel->getActiveSheet()->setCellValue($cell, $weeknm);
						$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $bg_style );
						
						$cell=$letters[$j++].$r;
						$this->excel->getActiveSheet()->setCellValue($cell, $value['stdate'] .' - ' .$value['endate']);
						$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $bg_style );
						
						$cell=$letters[$j++].$r;
						$this->excel->getActiveSheet()->setCellValue($cell, $value['timeframe_days']);
						$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $bg_style );
						
						$cell=$letters[$j++].$r;
						$this->excel->getActiveSheet()->setCellValue($cell, $value['hired_count']);
						$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $bg_style );
						
						$cell=$letters[$j++].$r;
						$this->excel->getActiveSheet()->setCellValue($cell, $value['train_term_count']);
						$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $bg_style );
						
						$cell=$letters[$j++].$r;
						$this->excel->getActiveSheet()->setCellValue($cell, $value['nest_term_count']);
						$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $bg_style );
						
						$cell=$letters[$j++].$r;
						$this->excel->getActiveSheet()->setCellValue($cell, $value['prod_term_count']);
						$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $bg_style );
						
						$cell=$letters[$j++].$r;
						$this->excel->getActiveSheet()->setCellValue($cell, $value['active_count']);
						$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $bg_style );
						
						$cell=$letters[$j++].$r;
						$this->excel->getActiveSheet()->setCellValue($cell, $value['prod_term_tenure']);
						$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $bg_style );
						
						$cell=$letters[$j++].$r;
						$this->excel->getActiveSheet()->setCellValue($cell, $value['active_tenure']);
						$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $bg_style );
						
						$cell=$letters[$j++].$r;
						$this->excel->getActiveSheet()->setCellValue($cell, $value['timeframe_attrition']);
						$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $bg_style );
						$this->excel->getActiveSheet()->getStyle($cell)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_PERCENTAGE_00);
						
						$cell=$letters[$j++].$r;
						$this->excel->getActiveSheet()->setCellValue($cell, $value['active_monthly_attrition']);
						$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $bg_style );
						$this->excel->getActiveSheet()->getStyle($cell)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_PERCENTAGE_00);
						
						$cell=$letters[$j++].$r;
						$this->excel->getActiveSheet()->setCellValue($cell, $value['annualized_attrition']);
						$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $bg_style );
						$this->excel->getActiveSheet()->getStyle($cell)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_PERCENTAGE_00);
					
					}
					$r++;
				
				}
				
			}
			
			if($is_monthly!="Y"){
				header('Content-Type: application/vnd.ms-excel'); //mime type
				//header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'); //mime type
												
				header('Content-Disposition: attachment;filename="'.$fn.'"'); //tell browser what's the file name
				header('Cache-Control: max-age=0'); //no cache
			}		 
			//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
			//if you want to save it as .XLSX Excel 2007 format
			
			$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
			if($is_monthly!="Y"){
				ob_end_clean();
				//force user to download the Excel file without writing it to server's HD
				$objWriter->save('php://output');
			}else{
				$objWriter->save($filename);
				return $fn;
			}
	}
	
    
	public function tramsUsers()
	{
		
		$current_user = get_user_id();
		$user_site_id= get_user_site_id();
		
		$ses_dept_id=get_dept_id();
		$role_id= get_role_id();
		
		$user_office_id=get_user_office_id();
		
		$is_global_access=get_global_access();
		
		//////////////////////////////////
			
		//$data["aside_template"] = get_aside_template();
		$data["aside_template"] = $this->aside;
		$data["content_template"] = "reports/rep_terms.php";
		
		$start_date="";
		$end_date="";
		$office_id="";
		$dept_id="";
		
		$data['department_list'] = $this->Common_model->get_department_list();
		
		if(get_role_dir()=="super" || $is_global_access==1){
			$data['site_list'] = $this->Common_model->get_sites_for_assign();
			$data['location_list'] = $this->Common_model->get_office_location_list();
		}else{
			$sCond=" Where id = '$user_site_id'";
			$data['site_list'] = $this->Common_model->get_sites_for_assign2($sCond);
			$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
		}
		
		$data['download_link']="";
		$data['start_date']="";
		$data['end_date']="";
		$data['office_id']="";
		$data['dept_id']="";
		$data['ses_role_id']="";
		
		$data['user_list'] =array();
		
		if($this->input->get('showReports')=='Show')
		{
			$start_date = $this->input->get('start_date');
			$end_date = $this->input->get('end_date');
			
			$office_id = $this->input->get('office_id');
			if($office_id=="")  $office_id=$user_office_id;
			
			//$dept_id = $this->input->get('dept_id');
			//if($dept_id=="") $dept_id=$ses_dept_id;
			
			$filterArray = array(
					"start_date" => $start_date,
					"end_date" => $end_date,
					"office_id" => $office_id,
					"dept_id" => $dept_id
			 ); 
			 
			 
			$fullArr = $this->reports_model->get_terms_users($filterArray);
			$data['user_list'] = $fullArr;
			$data['start_date']=$start_date;
			$data['end_date']=$end_date;
			$data['dept_id']=$dept_id;
			$data['office_id']=$office_id;
			
		}else{
			
			//$data['dept_id']=$ses_dept_id;
			$data['office_id']=$user_office_id;
			
			$filterArray = array(
					"start_date" =>"",
					"end_date" => "",
					"office_id" => $user_office_id,
					"dept_id" => $dept_id
			 ); 
			$fullArr = $this->reports_model->get_terms_users($filterArray);
			$data['user_list'] = $fullArr;
		}
		$this->load->view('dashboard',$data);
		
	}
	
	
	public function cancelTramReq()
	{
		$role_id= get_role_id();
		$current_user = get_user_id();
		$user_site_id= get_user_site_id();
		$ses_dept_id=get_dept_id();
		$user_office_id=get_user_office_id();
		
		$is_global_access=get_global_access();
		
		//////////////////////////////////
			
		//$data["aside_template"] = get_aside_template();
		$data["aside_template"] = $this->aside;
		$data["content_template"] = "reports/cancel_term_req.php";
		
		$start_date="";
		$end_date="";
		$dept_id="";
		
		$data['download_link']="";
		$data['start_date']="";
		$data['end_date']="";
		$data['ses_role_id']="";
		
		$data['user_list'] =array();
		$data['department_list'] = $this->Common_model->get_department_list();
		
		if(get_role_dir()=="super" || $is_global_access==1){
			$data['site_list'] = $this->Common_model->get_sites_for_assign();
			$data['location_list'] = $this->Common_model->get_office_location_list();
		}else{
			$sCond=" Where id = '$user_site_id'";
			$data['site_list'] = $this->Common_model->get_sites_for_assign2($sCond);
			$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
		}
		
		if($this->input->get('showReports')=='Show')
		{
			$start_date = $this->input->get('start_date');
			$end_date = $this->input->get('end_date');
			
			$office_id = $this->input->get('office_id');
			if($office_id=="")  $office_id=$user_office_id;
			
			//$dept_id = $this->input->get('dept_id');
			//if($dept_id=="") $dept_id=$ses_dept_id;
			
			$filterArray = array(
					"start_date" => $start_date,
					"end_date" => $end_date,
					"office_id" => $office_id,
					"dept_id" => $dept_id
			 ); 
			 
			$fullArr = $this->reports_model->get_cancel_term_request($filterArray);
			
			$data['user_list'] = $fullArr;
			$data['start_date']=$start_date;
			$data['end_date']=$end_date;
			$data['dept_id']=$dept_id;
			$data['office_id']=$office_id;
			
		}else{
			
			//$data['dept_id']=$ses_dept_id;
			$data['office_id']=$user_office_id;
			
			$filterArray = array(
					"start_date" =>"",
					"end_date" => "",
					"office_id" => $user_office_id,
					"dept_id" => $dept_id
			 ); 
			 
			$fullArr = $this->reports_model->get_cancel_term_request($filterArray);
			$data['user_list'] = $fullArr;
			
		}
		
		$this->load->view('dashboard',$data);
		
	}
	
		
	private function check_access()
	{
		
		//$is_global_access=get_global_access();
		//if(get_role_dir()=="agent" && $is_global_access!=1 ) redirect(base_url()."home","refresh");
		
	}
	
//////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////

/*-------------------Resignation Report-----------------------------*/	
	public function resign_report(){
		if(check_logged_in()){
			
			$office_id = "";
			$user_office_id=get_user_office_id();
			$current_user = get_user_id();
			$is_global_access=get_global_access();
			$role_dir=get_role_dir();
			$data["show_download"] = false;
			$data["download_link"] = "";
			$data["show_table"] = false;
			$data["show_table"] = false;
			
			$office_id = $this->input->get('office_id');
		
			if($office_id=="")  $office_id=$user_office_id;
			
			
			$data["aside_template"] = "reports/aside.php";
			$data["content_template"] = "reports/resign_report.php";
			
			
			$data["role_dir"]=$role_dir;
			
			$date_from="";
			$date_to="";
			$action="";
			$dn_link="";
			
			$data["resign_list"]= array();
			$data['site_list'] = $this->Common_model->get_sites_for_assign();
			
			if(get_role_dir()=="super" || $is_global_access==1){
				$data['location_list'] = $this->Common_model->get_office_location_list();
			}else{
				$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
			}
			
			if($this->input->get('show')=='Show')
			{
				$date_from = mmddyy2mysql($this->input->get('date_from'));
				$date_to = mmddyy2mysql($this->input->get('date_to'));
				$office_id = $this->input->get('office_id');
				
				$field_array = array(
						"date_from"=>$date_from,
						"date_to" => $date_to,
						"office_id" => $office_id
					);
			
				$fullAray = $this->user_model->get_resign_list($field_array);
				$data["resign_list"] = $fullAray;
				
				$this->create_Resign_CSV($fullAray);
					
				$dn_link = base_url()."reports/downloadResignCsv";
					
			}
			
			$data['download_link']=$dn_link;
			$data["action"] = $action;
			$data['date_from'] = $date_from;
			$data['date_to'] = $date_to;	
			$data['office_id']=$office_id;
			
			$this->load->view('dashboard',$data);
		}
	}
	
	
	public function downloadResignCsv()
	{
		$currDate=date("Y-m-d");
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$newfile="user_resign_report_list-'".$currDate."'.csv";
		
		header('Content-Disposition: attachment;  filename="'.$newfile.'"');
		readfile($filename);
	}
	
	
	public function create_Resign_CSV($rr)
	{
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$fopen = fopen($filename,"w+");
		$header = array("Name", "Fusion ID", "XPOID", "OMUID", "Role", "Location", "Resign Date", "Released Date","User Reason", "User Remarks", "Current Resign Date/Time", "Accepted Name", "Accepted Remarks", "Current Accepted Date/Time", "Original Released Date", "Status");
		
		$row = "";
		foreach($header as $data) $row .= ''.$data.',';
		fwrite($fopen,rtrim($row,",")."\r\n");
		$searches = array("\r", "\n", "\r\n");
		
		foreach($rr as $user)
		{	
			if($user['resign_status']=="A")  $status="Done";
			else if($user['resign_status']=="P")  $status="Pending";
			else $status="Decline";
		
		
			$row = '"'.$user['name'].'",'; 
			$row .= '"'.$user['fusion_id'].'",';
			$row .= '"'.$user['xpoid'].'",';
			$row .= '"'.$user['omuid'].'",';
			$row .= '"'.$user['role'].'",';
			$row .= '"'.$user['office_id'].'",';
			$row .= '"'.$user['resigndate'].'",';
			$row .= '"'.$user['releaseddate'].'",';
			$row .= '"'.$user['user_reason'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['user_remarks'])).'",';
			$row .= '"'.$user['current_user_date'].'",';
			$row .= '"'.$user['accepted_name'].'",';
			//$row .= '"'.$user['accepted_remarks'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['accepted_remarks'])).'",';
			$row .= '"'.$user['accepted_current_date'].'",';
			$row .= '"'.$user['original_released_date'].'",';
			$row .= '"'.$status.'",';
			
			fwrite($fopen,$row."\r\n");
		}
		
		fclose($fopen);
	}	   
//////////////////////////////////////////////////////////	
	
	// CREATE USER REPORT HISTORY ADDED BY VIVEK PRASAD ON 30.11.2018
	
	
	
	public function user_history_rep(){
		
		$site_id = "";
		$office_id = "";
					
		$user_office_id=get_user_office_id();
		//////////////////////////////////
		$is_global_access=get_global_access();
		$office_id = $this->input->get('office_id');
		
		if($office_id=="")  $office_id=$user_office_id;
		
		//////////////////////////////////
		
		$role_id= get_role_id();
		$current_user = get_user_id();
		$user_site_id= get_user_site_id();
		//////////////////////////////////
			
		$data["aside_template"] = $this->aside;
		$data["content_template"] = "reports/rep_history.php";
		
		$start_date="";
		$end_date="";
		$rof="";
		$dn_link="";
		$start_date="";
		$end_date="";
		$fullArr=array();
		$dn_param="";
		$site_id="";
		
		$data['start_date']="";
		$data['end_date']="";
		$data['ses_role_id']="";
		
		$data['user_list'] =array();
		$data['site_list'] = $this->Common_model->get_sites_for_assign();
		
				
		if(get_role_dir()=="super" || $is_global_access==1){
			$data['location_list'] = $this->Common_model->get_office_location_list();
		}else{
			$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
		}

		
		if($this->input->get('showReports')=='Show')
		{
			$start_date = $this->input->get('start_date');
			$end_date = $this->input->get('end_date');
			$office_id = $this->input->get('office_id');
			
			$filterArray = array(
					"start_date" => $start_date,
					"end_date" => $end_date,
					"office_id" => $office_id
					
			 ); 
			
			$fullArr = $this->reports_model->gethistoryusernData($filterArray);
			
			$data['user_list'] = $fullArr;
			$data['start_date']=$start_date;
			$data['end_date']=$end_date;
			
			
			$filename=$this->create_csv_2($fullArr);
			$dn_param='sd='.$start_date.'&ed='.$end_date; 
			$dn_link = base_url()."reports/downloadCsv_2";
								
		}
		
		$data['office_id']=$office_id;
				
		$data['dn_param']=$dn_param;
		$data['download_link']=$dn_link;
		$this->load->view('dashboard',$data);
		
	}
	
	public function downloadCsv_2()
	{		
		
		$s_date = $this->input->get('sd');
		$e_date = $this->input->get('ed');
		
		//////////LOG////////
		$Lfull_name=get_username();
		$LOMid=get_user_omuid();
		$LogMSG="Download User History report";
		log_message('error', $LOMid.' - ' . $Lfull_name . ' | '.$LogMSG );
		//////////
		$filename="./assets/reports/userhistory-".get_user_id()."-".CurrDate().".csv";

		if($s_date!="" && $e_date!="") $newfile="userhistory-".$s_date." to ".$e_date. ".csv";
		else $newfile="userhistory-".CurrDate().".csv";
		
		header('Content-Disposition: attachment;  filename="'.$newfile.'"');
		readfile($filename);
	} 
	
	
	public function create_csv_2($rr)
	{
		
		$filename="userhistory-".get_user_id()."-".CurrDate().".csv";
		$filePath = "./assets/reports/".$filename;
		
		$fopen = fopen($filePath,"w+");
										
		$header = array("SL","Fusion ID", "XPOID", "OM ID", "First Name","Last Name","Site", "DOJ", "DOH", "Migration Date", "Migration Type","Migrated To", "Migrated From", "Remarks");
		
		$row = "";
		
		foreach($header as $data) $row .= ''.$data.',';
		
		fwrite($fopen,rtrim($row,",")."\r\n");
		
		$cnt=1;
		
		foreach($rr as $user)
		{	
			//if($user['event_master_id']!=9) continue;
			
			$row = '"'.$cnt++.'",';
			$row .= '"'.$user['fusion_id'].'",';
			$row .= '"'.$user['xpoid'].'",'; 
			$row .= '"'.$user['omuid'].'",'; 
			$row .= '"' . $user['fname'] . '",';
			$row .= '"' . $user['lname'] . '",';
			$row .= '"' . $user['site_name'] . '",';  
			$row .= '"' . $user['doj'] . '",';
			$row .= '"' . $user['doj'] . '",';
			$row .= '"' . $user['affected_date'] . '",';
			$row .= '"' . $user['m_type_name'] . '",';
			$row .= '"' . $user['m_to_name'] . '",';
			$row .= '"' . $user['m_from_name'] . '",';
			$row .= '"' . $user['comments'] . '"';
			fwrite($fopen,$row."\r\n");
		}
		
		fclose($fopen);
		
	} 
	
	
 
	private function is_access_reports($_role_id) 
	{
		$_role_arr = array("super"=>0,"admin"=>1,"tl"=>2,"manager"=>4,"trainer"=>5,"support"=>6,"trainee"=>7,"nesting"=>8,"supervisor"=>9);
		
		return true;
		
		//if(in_array($_role_id,$_role_arr ))
		//{
			//return true;
		//}else{
			//return false;
		//}
	}
	
	private function redirectors()
	{
		$role = get_role_id();
		if($role==1) return "admin";
		else return "tl";
	}
    
	
//////////////////////////////////////////////////////////////
///////////////////DFR Report section/////////////////////////
//////////////////////////////////////////////////////////////

/*-------------------Requisition Report-----------------------------*/	
	public function requisition_report(){
		if(check_logged_in()){
			$office_id = "";
			$user_office_id=get_user_office_id();
			$current_user = get_user_id();
			$is_global_access=get_global_access();
			$role_dir=get_role_dir();
			$data["show_download"] = false;
			$data["download_link"] = "";
			$data["show_table"] = false;
			$data["show_table"] = false;
			
			$office_id = $this->input->get('office_id');
		
			if($office_id=="")  $office_id=$user_office_id;
			
			
			$data["aside_template"] = "reports/aside.php";
			$data["content_template"] = "reports/requisition_report.php";
			
			
			$data["role_dir"]=$role_dir;
			
			$date_from="";
			$date_to="";
			$requisition_id="";
			$action="";
			$dn_link="";
			
			
			/* if($office_id=="ALL"){
				$data["req_code"]=$this->Dfr_model->get_requisition_id();
			}else{
				$data["req_code"]=$this->Dfr_model->get_requisition_id_list($user_office_id);
			} */
			
			$cValue = trim($this->input->post('client_id'));
			if($cValue=="") $cValue = trim($this->input->get('client_id'));
			
			$pValue = trim($this->input->post('process_id'));
			if($pValue=="") $pValue = trim($this->input->get('process_id'));
			
			$data['cValue']=$cValue;
			$data['pValue']=$pValue;
			
			
			$data["req_code"]=$this->Dfr_model->get_requisition_id();
			
			$data["requisition_list"] = array();
			
			
			if(get_role_dir()=="super" || $is_global_access==1){
				$data['location_list'] = $this->Common_model->get_office_location_list();
			}else{
				$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
			}
			
			$data['client_list'] = $this->Common_model->get_client_list();
			if($cValue=="" || $cValue=="ALL") $data['process_list'] = array();
				else $data['process_list'] = $this->Common_model->get_process_list($cValue);
				
			
			if($this->input->get('show')=='Show')
			{
				$date_from = mmddyy2mysql($this->input->get('date_from'));
				$date_to = mmddyy2mysql($this->input->get('date_to'));
				$office_id = $this->input->get('office_id');
				$requisition_id = $this->input->get('requisition_id');
				
				$field_array = array(
						"date_from"=>$date_from,
						"date_to" => $date_to,
						"office_id" => $office_id,
						"requisition_id" => $requisition_id,
						"client_id" => $cValue,
						"process_id" => $pValue
					);
			
				$fullAray = $this->Dfr_model->get_requisition_report($field_array);
				$data["requisition_list"] = $fullAray;
				
				$this->create_Requisition_CSV($fullAray);
					
				$dn_link = base_url()."reports/downloadRequisitionCsv";
					
			}
			
			$data['download_link']=$dn_link;
			$data["action"] = $action;
			$data['date_from'] = $date_from;
			$data['date_to'] = $date_to;	
			$data['office_id']=$office_id;
			$data['requisition_id']=$requisition_id;
			
			$this->load->view('dashboard',$data);
		}
	}
	
	
	public function downloadRequisitionCsv()
	{
		$currDate=date("Y-m-d");
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$newfile="requisition_report_list-'".$currDate."'.csv";
		
		header('Content-Disposition: attachment;  filename="'.$newfile.'"');
		readfile($filename);
	}
	
	
	public function create_Requisition_CSV($rr)
	{
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$fopen = fopen($filename,"w+");
		$header = array("Requisition_id", "Location", "Due Date", "Department", "Client", "Process", "Role", "Req Qualification", "Req Exp Range", "Position Required", "Position Filled", "Total Applied", "Total Shortlisted", "Batch Code", "Job Desc", "Additional Info", "Raised By", "Raised Date/Time", "Status", "Approved/Decline By", "Approved/Decline Date/Time", "Approved/Decline Comment", "Updated By", "Updated Date/Time");
		
		$row = "";
		foreach($header as $data) $row .= ''.$data.',';
		fwrite($fopen,rtrim($row,",")."\r\n");
		$searches = array("\r", "\n", "\r\n");
		
		foreach($rr as $user)
		{	
			if($user['requisition_status']=="A")  $status="Approved";
			else if($user['requisition_status']=="C")  $status="Cancel";
			else if($user['requisition_status']=="P")  $status="Pending";
			else $status="Decline";
		
			$row = '"'.$user['requisition_id'].'",'; 
			$row .= '"'.$user['off_location'].'",';
			$row .= '"'.$user['due_date'].'",';
			$row .= '"'.$user['dept_name'].'",';
			$row .= '"'.$user['client_name'].'",';
			$row .= '"'.$user['process_name'].'",';
			$row .= '"'.$user['role_name'].'",';
			$row .= '"'.$user['req_qualification'].'",';
			$row .= '"'.$user['req_exp_range'].'",';
			$row .= '"'.$user['req_no_position'].'",';
			$row .= '"'.$user['filled_no_position'].'",';
			$row .= '"'.$user['candidate_applied'].'",';
			$row .= '"'.$user['shortlisted_candidate'].'",';
			$row .= '"'.$user['job_title'].'",';
			$row .= '"'.$user['job_desc'].'",';
			$row .= '"'.$user['additional_info'].'",';
			$row .= '"'.$user['raised_name'].'",';
			$row .= '"'.$user['raised_date'].'",';
			$row .= '"'.$status.'",';
			$row .= '"'.$user['approved_name'].'",';
			$row .= '"'.$user['approved_date'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['approved_comment'])).'",';
			$row .= '"'.$user['updated_name'].'",';
			$row .= '"'.$user['updated_date'].'",';
						
			fwrite($fopen,$row."\r\n");
		}
		
		fclose($fopen);
	}


	/* public function select_reqcode(){
		$set_array = array ();
		if(check_logged_in())
		{
			$office_id = $this->input->get('office_id');

			$SQLtxt = "SELECT requisition_id FROM dfr_requisition where location='$office_id' ";
			$fields = $this->db->query($SQLtxt);
			
			$process_data =  $fields->result_array();
			  
			echo  json_encode($process_data);
			 
		}
	} */
	
	public function getreqList()
	{
		if(check_logged_in())
		{
			$office_id = trim($this->input->get('office_id'));
			echo json_encode($this->Dfr_model->get_requisition_list($office_id));
		}
	}
	
///////////////////////////////////////////////////////////////////////////////////////////////	
	/*-------------------Candidate Report-----------------------------*/	
	public function candidate_report(){
		if(check_logged_in()){
			$office_id = "";
			$user_office_id=get_user_office_id();
			$current_user = get_user_id();
			$is_global_access=get_global_access();
			$role_dir=get_role_dir();
			$data["show_download"] = false;
			$data["download_link"] = "";
			$data["show_table"] = false;
			$data["show_table"] = false;
			
			$office_id = $this->input->get('office_id');
		
			if($office_id=="")  $office_id=$user_office_id;
			
			
			$data["aside_template"] = "reports/aside.php";
			$data["content_template"] = "reports/candidate_report.php";
			
			
			$data["role_dir"]=$role_dir;
			
			$date_from="";
			$date_to="";
			$requisition_id="";
			$action="";
			$dn_link="";
			
			
			$cValue = trim($this->input->post('client_id'));
			if($cValue=="") $cValue = trim($this->input->get('client_id'));
			
			$pValue = trim($this->input->post('process_id'));
			if($pValue=="") $pValue = trim($this->input->get('process_id'));
			
			$data['cValue']=$cValue;
			$data['pValue']=$pValue;
			
			
			$data["req_code"]=$this->Dfr_model->get_requisition_id();
			
			$data["candidate_list"] = array();
			
			
			if(get_role_dir()=="super" || $is_global_access==1){
				$data['location_list'] = $this->Common_model->get_office_location_list();
			}else{
				$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
			}
			
			$data['client_list'] = $this->Common_model->get_client_list();
			if($cValue=="" || $cValue=="ALL") $data['process_list'] = array();
				else $data['process_list'] = $this->Common_model->get_process_list($cValue);
				
			
			if($this->input->get('show')=='Show')
			{
				$date_from = mmddyy2mysql($this->input->get('date_from'));
				$date_to = mmddyy2mysql($this->input->get('date_to'));
				$office_id = $this->input->get('office_id');
				$requisition_id = $this->input->get('requisition_id');
				
				$field_array = array(
						"date_from"=>$date_from,
						"date_to" => $date_to,
						"office_id" => $office_id,
						"requisition_id" => $requisition_id,
						"client_id" => $cValue,
						"process_id" => $pValue
					);
			
				$fullAray = $this->Dfr_model->get_candidate_report($field_array);
				$data["candidate_list"] = $fullAray;
				
				$this->create_Candidate_CSV($fullAray);
					
				$dn_link = base_url()."reports/downloadCandidateCsv";
					
			}
			
			$data['download_link']=$dn_link;
			$data["action"] = $action;
			$data['date_from'] = $date_from;
			$data['date_to'] = $date_to;	
			$data['office_id']=$office_id;
			$data['requisition_id']=$requisition_id;
			
			$this->load->view('dashboard',$data);
		}
	}
	
	
	public function downloadCandidateCsv()
	{
		$currDate=date("Y-m-d");
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$newfile="candidate_report_list-'".$currDate."'.csv";
		
		header('Content-Disposition: attachment;  filename="'.$newfile.'"');
		readfile($filename);
	}
	
	
	public function create_Candidate_CSV($rr)
	{
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$fopen = fopen($filename,"w+");
		$header = array("Requisition ID", "Batch Code", "Client", "Process", "Location", "Due Date", "Position Applied For", "Hiring Source", "Source Name", "Candidate Name", "DOB", "Email", "Gender", "Phone", "Qualification", "Skill", "Total Exp", "Address", "Country", "State", "City", "Postcode", "Attachment", "Summary", "Added By", "Candidate Status", "Added Date", "Approved By", "Approved Comment", "DOJ");
		
		$row = "";
		foreach($header as $data) $row .= ''.$data.',';
		fwrite($fopen,rtrim($row,",")."\r\n");
		$searches = array("\r", "\n", "\r\n");
		
		foreach($rr as $user)
		{	
			$c_status=$user['candidate_status'];
			//$a_status=$user['approved_status'];
			
			if($c_status=='CS') $cstatus="Selected";
			else if($c_status=='SL') $cstatus="Shortlisted";
			else if($c_status=='IP') $cstatus="In Progress";
			else if($c_status=='P') $cstatus="Pending";
			else if($c_status=='E') $cstatus="Add as an Employee";
			else $cstatus="Rejected";
			
			/* if($a_status=="C") $astatus="Confirm";
			else $astatus="Decline"; */
			$ref_name = $user['ref_name'];
			
			if($user['ref_id'] !="" ) $ref_name = $ref_name .", " . $user['ref_id'];
			
			$row = '"'.$user['requisition_id'].'",'; 
			$row .= '"'.$user['batchCode'].'",'; 
			$row .= '"'.$user['client_name'].'",'; 
			$row .= '"'.$user['process_name'].'",'; 
			$row .= '"'.$user['off_loc'].'",'; 
			$row .= '"'.$user['due_date'].'",'; 
			$row .= '"'.$user['role_name'].'",'; 
			$row .= '"'.$user['hiring_source'].'",'; 
			$row .= '"'.$ref_name.'",'; 
			$row .= '"'.$user['fname'] . " ". $user['lname'].'",';
			$row .= '"'.$user['dob'].'",';
			$row .= '"'.$user['email'].'",';
			$row .= '"'.$user['gender'].'",';
			$row .= '"'.$user['phone'].'",';
			$row .= '"'.$user['last_qualification'].'",';
			$row .= '"'.$user['skill_set'].'",';
			$row .= '"'.$user['total_work_exp'].'",';
			$row .= '"'.$user['address'].'",';
			$row .= '"'.$user['country'].'",';
			$row .= '"'.$user['state'].'",';
			$row .= '"'.$user['city'].'",';
			$row .= '"'.$user['postcode'].'",';
			$row .= '"'.$user['attachment'].'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['summary'])).'",';
			$row .= '"'.$user['added_name'].'",';
			$row .= '"'.$cstatus.'",';
			$row .= '"'.$user['added_date'].'",';
			$row .= '"'.$user['approved_name'].'",';
			//$row .= '"'.$astatus.'",';
			$row .= '"'. str_replace('"',"'",str_replace($searches, "", $user['approved_comment'])).'",';
			$row .= '"'.$user['doj'].'",';
			
			fwrite($fopen,$row."\r\n");
		}
		
		fclose($fopen);
	}
	
	
///////////////////////////////////////////////////////////////////////////////////////////////	
	/*-------------------Candidate Report-----------------------------*/	
	public function candidate_interview_report(){
		if(check_logged_in()){
			$office_id = "";
			$user_office_id=get_user_office_id();
			$current_user = get_user_id();
			$is_global_access=get_global_access();
			$role_dir=get_role_dir();
			$data["show_download"] = false;
			$data["download_link"] = "";
			$data["show_table"] = false;
			$data["show_table"] = false;
			
			$office_id = $this->input->get('office_id');
		
			if($office_id=="")  $office_id=$user_office_id;
			
			
			$data["aside_template"] = "reports/aside.php";
			$data["content_template"] = "reports/candidate_interview_report.php";
			
			
			$data["role_dir"]=$role_dir;
			
			$date_from="";
			$date_to="";
			$status="";
			$candidate_status="";
			$action="";
			$dn_link="";
			
			
			/* $cValue = trim($this->input->post('client_id'));
			if($cValue=="") $cValue = trim($this->input->get('client_id'));
			
			$pValue = trim($this->input->post('process_id'));
			if($pValue=="") $pValue = trim($this->input->get('process_id'));
			
			$data['cValue']=$cValue;
			$data['pValue']=$pValue;
			
			
			$data["req_code"]=$this->Dfr_model->get_requisition_id(); */
			
			$data["candidate_interview_list"] = array();
			
			
			if(get_role_dir()=="super" || $is_global_access==1){
				$data['location_list'] = $this->Common_model->get_office_location_list();
			}else{
				$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
			}
			
			/* $data['client_list'] = $this->Common_model->get_client_list();
			if($cValue=="" || $cValue=="ALL") $data['process_list'] = array();
				else $data['process_list'] = $this->Common_model->get_process_list($cValue); */
			
			
			if($this->input->get('show')=='Show')
			{
				$date_from = mmddyy2mysql($this->input->get('date_from'));
				$date_to = mmddyy2mysql($this->input->get('date_to'));
				$office_id = $this->input->get('office_id');
				$status = $this->input->get('status');
				$candidate_status = $this->input->get('candidate_status');
				
				$field_array = array(
						"date_from"=>$date_from,
						"date_to" => $date_to,
						"office_id" => $office_id,
						"status" => $status,
						"candidate_status" => $candidate_status
					);
			
				$fullAray = $this->Dfr_model->candidate_interview_report($field_array);
				$data["candidate_interview_list"] = $fullAray;
				
				$this->create_Candidate_interview_CSV($fullAray);
					
				$dn_link = base_url()."reports/downloadCandidateInterviewCsv";
					
			}
			
			$data['download_link']=$dn_link;
			$data["action"] = $action;
			$data['date_from'] = $date_from;
			$data['date_to'] = $date_to;	
			$data['office_id']=$office_id;
			$data['status']=$status;
			$data['candidate_status']=$candidate_status;
			
			$this->load->view('dashboard',$data);
		}
	}
	
	
	public function downloadCandidateInterviewCsv()
	{
		$currDate=date("Y-m-d");
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$newfile="candidate_interview_report_list-'".$currDate."'.csv";
		
		header('Content-Disposition: attachment;  filename="'.$newfile.'"');
		readfile($filename);
	}
	
	
	public function create_Candidate_interview_CSV($rr)
	{
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$fopen = fopen($filename,"w+");
		$header = array("Requisition ID", "Candidate Name", "DOB", "Contact Number", "Client", "Process", "Interviewer Name", "Scheduled By", "Scheduled Date", "Scheduled Time", "Interview Type", "Interview Status", "Interview Date", "Interview Time", "Final Status");
		
		$row = "";
		foreach($header as $data) $row .= ''.$data.',';
		fwrite($fopen,rtrim($row,",")."\r\n");
		$searches = array("\r", "\n", "\r\n");
		
		foreach($rr as $user)
		{	
			
			$scheduledDate=$user['scheduled_on'];																		
			$phpdate = strtotime($scheduledDate);
			$scheduled_date = date( 'Y-m-d', $phpdate );
			$scheduled_time = date( 'H:i:s', $phpdate );
			
			$interviewDate=$user['interview_date'];
			$phpdate_inter = strtotime($interviewDate);
			$interview_date = date( 'Y-m-d', $phpdate_inter );
			$interview_time = date( 'H:i:s', $phpdate_inter );
			
			if($user['sh_status']=='C'){
				$status='Cleared';
			}else if($user['sh_status']=='N'){
				$status='Not Cleared';
			}else if($user['sh_status']=='R'){
				$status='Cancel';
			}else{
				$status='Pending';
			}
			
			if($user['sh_status']=='P' || $user['sh_status']=='R'){
				$interview_date="";
				$interview_time="";
			}
			
			if($user['candidate_status']=='P'){
				$candidate_status='Pending';
			}else if($user['candidate_status']=='IP'){
				$candidate_status='In Progress';
			}else if($user['candidate_status']=='SL'){
				$candidate_status='Shortlisted';
			}else if($user['candidate_status']=='CS'){
				$candidate_status='Selected';
			}else if($user['candidate_status']=='E'){
				$candidate_status='Selected as Employee';
			}else{
				$candidate_status='Rejected';
			}
			
			
			$row = '"'.$user['requisition_id'].'",'; 
			$row .= '"'.$user['fname']." ".$user['lname'].'",'; 
			$row .= '"'.$user['dob'].'",'; 
			$row .= '"'.$user['phone'].'",'; 
			$row .= '"'.$user['client'].'",'; 
			$row .= '"'.$user['process'].'",'; 
			$row .= '"'.$user['interviewer'].'",'; 
			$row .= '"'.$user['schedule_by'].'",'; 
			$row .= '"'.$scheduled_date.'",'; 
			$row .= '"'.$scheduled_time.'",';
			$row .= '"'.$user['interviewType'].'",'; 
			$row .= '"'.$status.'",'; 
			$row .= '"'.$interview_date.'",'; 
			$row .= '"'.$interview_time.'",'; 
			$row .= '"'.$candidate_status.'",'; 
			
			fwrite($fopen,$row."\r\n");
		}
		
		fclose($fopen);
	}
	
/*------------------------------------------------*/	
/*-------------------User Referral Report (19.07.2019)--------------------*/	
	public function user_referral_report(){
		if(check_logged_in()){
			$user_office_id=get_user_office_id();
			$current_user = get_user_id();
			$is_global_access=get_global_access();
			$role_dir=get_role_dir();
			
			$data["aside_template"] = "reports/aside.php";
			$data["content_template"] = "reports/user_referral_report.php";
			
			$data["user_referral_list"] = $this->Dfr_model->user_referral_report();
			
			
			$this->load->view('dashboard',$data);
		}
	}	
	
	
///////////////////////////////////////////////////////////////////////////////////////////////	
/*-------------------Policy Acceptance-----------------------------*/	
	
	public function policy_acceptance_report_list(){
		if(check_logged_in()){
			$user_office_id=get_user_office_id();
			$current_user = get_user_id();
			$is_global_access=get_global_access();
			$role_dir=get_role_dir();
			$data["show_download"] = false;
			$data["download_link"] = "";
			$data["show_table"] = false;
			$data["show_table"] = false;
			
			$data["aside_template"] = "reports/aside.php";
			$data["content_template"] = "reports/policy_acceptance_report.php";
			
			$policy_id="";
			$action="";
			$dn_link="";
			
			if(get_role_dir()=="super" || $is_global_access==1){
				$qSql="Select id, title from policy_list where is_active=1 order by office_id ";
				$data['get_title'] = $this->Common_model->get_query_result_array($qSql);
			}else{
				$qSql="Select id, title from policy_list where office_id in ('ALL','$user_office_id') and is_active=1 order by office_id ";
				$data['get_title'] = $this->Common_model->get_query_result_array($qSql);
			}
			
			$data["policy_acceptance_list"] = array();
			
			$policy_id = $this->input->get('policy_id');
			
			$qSql="Select title from policy_list where id='$policy_id'";
			$data['policy_title'] = $this->Common_model->get_query_result_array($qSql);
			
			
			if($this->input->get('show')=='Show')
			{
				
				$field_array = array(
						"policy_id" => $policy_id,
					);
			
				$fullAray = $this->reports_model->get_policy_acceptance_report($field_array);
				$data["policy_acceptance_list"] = $fullAray;
				
				$this->create_policyAcceptance_CSV($fullAray);
					
				$dn_link = base_url()."reports/downloadpolicyAcceptance";
					
			}
			
			$data['download_link']=$dn_link;
			$data["action"] = $action;
			$data['policy_id'] = $policy_id;
			
			$this->load->view('dashboard',$data);
		}
	}
	
	
	public function downloadpolicyAcceptance()
	{
		$currDate=date("Y-m-d");
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$newfile="policy_acceptance_report-'".$currDate."'.csv";
		
		header('Content-Disposition: attachment;  filename="'.$newfile.'"');
		readfile($filename);
	}
	
	
	public function create_policyAcceptance_CSV($rr)
	{
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$fopen = fopen($filename,"w+");
		$header = array("Title", "Accepted By", "Fusion ID", "XPOID", "OMUID", "Location", "Designation", "Acceptance Date");
		
		$row = "";
		foreach($header as $data) $row .= ''.$data.',';
		fwrite($fopen,rtrim($row,",")."\r\n");
		$searches = array("\r", "\n", "\r\n");
		
		foreach($rr as $user)
		{	
			$row = '"'.$user['policy_titile'].'",'; 
			$row .= '"'.$user['fname'] . " ". $user['lname']. '",'; 
			$row .= '"'.$user['fusion_id'].'",'; 
			$row .= '"'.$user['xpoid'].'",'; 
			$row .= '"'.$user['omuid'].'",'; 
			$row .= '"'.$user['office_id'].'",'; 
			$row .= '"'.$user['userRoleName'].'",'; 
			$row .= '"'.$user['accptdate'].'",'; 
			
			fwrite($fopen,$row."\r\n");
		}
		
		fclose($fopen);
	}
	
/////////////////////////////////////////////////////////////////////
	/*-------------------Process Updates Acceptance-----------------------------*/	
	
	public function process_update_acceptance_report_list(){
		if(check_logged_in()){
			$user_office_id=get_user_office_id();
			$current_user = get_user_id();
			$is_global_access=get_global_access();
			$role_dir=get_role_dir();
			
			$data["show_download"] = false;
			$data["download_link"] = "";
			$data["show_table"] = false;
			$data["show_table"] = false;
			
			$data["aside_template"] = "reports/aside.php";
			$data["content_template"] = "reports/process_update_acceptance_report.php";
			
			$process_update_id="";
			$action="";
			$dn_link="";
			$cValue="";
			
			$office_id = $this->input->get('office_id');
			$is_update = $this->input->get('is_update');
		
			if($office_id=="")  $office_id=$user_office_id;
			
			
			/* if(get_role_dir()=="super" || $is_global_access==1 ){
				$qSql="Select *, (select location from office_location ol where ol.abbr=process_updates.office_id) as off_loc, (select shname from client c where c.id=process_updates.client_id) as client from process_updates ";
				$data['get_process_update_title'] = $this->Common_model->get_query_result_array($qSql);
			}else{
								
				$qSql="Select *, (select location from office_location ol where ol.abbr=process_updates.office_id) as off_loc, (select shname from client c where c.id=process_updates.client_id) as client from process_updates where office_id in ('ALL','$user_office_id') order by office_id ";
				$data['get_process_update_title'] = $this->Common_model->get_query_result_array($qSql);
			} */
			
			
			$data["process_update_acceptance_list"] = array();
			
			$process_update_id = $this->input->get('process_update_id');
			$user_id = $this->input->get('user_id');
			
			$qSql="Select title from process_updates where id='$process_update_id'";
			$data['pu_title'] = $this->Common_model->get_query_result_array($qSql);
			
			if(get_role_dir()=="super" || $is_global_access==1){
				$data['location_list'] = $this->Common_model->get_office_location_list();
			}else{
				$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
			}
			
			
			$qSql="Select client_id as id, (select shname from client c where c.id=process_updates.client_id) as shname from process_updates group by shname asc";
			$data['client_list'] = $this->Common_model->get_query_result_array($qSql);
			
			//$data['client_list'] = $this->Common_model->get_client_list();
			
			
			
			if($this->input->get('show')=='Show')
			{
				$office_id = $this->input->get('office_id');
				$cValue = trim($this->input->get('client_id'));
				if($cValue=="") $cValue = trim($this->input->get('client_id'));
				
				$field_array = array(
						"office_id" => $office_id,
						"client_id" => $cValue,
						"user_id" => $user_id,
						"process_update_id" => $process_update_id,
					);
			
				$fullAray = $this->reports_model->get_process_update_acceptance_report($field_array);
				$data["process_update_acceptance_list"] = $fullAray;
				
				$this->create_processUpdateAcceptance_CSV($fullAray);
					
				$dn_link = base_url()."reports/downloadprocessUpdateAcceptance";
					
			}
			
			
			$data['download_link']=$dn_link;
			$data["action"] = $action;
			$data['cValue']=$cValue;
			$data['office_id']=$office_id;
			$data['process_update_id'] = $process_update_id;
			
			$this->load->view('dashboard',$data);
		}
	}
	
	
	public function getProcessTitle(){
		if(check_logged_in()){
			$cid=$this->input->post('cid');
			$office_id=$this->input->post('office_id');
			
			if($cid!='ALL' && $office_id!=''){
				$qSql="Select *, (select location from office_location ol where ol.abbr=process_updates.office_id) as off_loc, (select shname from client c where c.id=process_updates.client_id) as client from process_updates where office_id='$office_id' and client_id='$cid'";
			}else if($cid=='ALL' && $office_id!=''){
				$qSql="Select *, (select location from office_location ol where ol.abbr=process_updates.office_id) as off_loc, (select shname from client c where c.id=process_updates.client_id) as client from process_updates where office_id='$office_id' ";
			}else{
				$qSql="Select *, (select location from office_location ol where ol.abbr=process_updates.office_id) as off_loc, (select shname from client c where c.id=process_updates.client_id) as client from process_updates ";
			}
			
			echo json_encode($this->Common_model->get_query_result_array($qSql));
			
		}
	}
	
	
	public function downloadprocessUpdateAcceptance()
	{
		$currDate=date("Y-m-d");
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$newfile="process_update_acceptance_report-'".$currDate."'.csv";
		
		header('Content-Disposition: attachment;  filename="'.$newfile.'"');
		readfile($filename);
	}
	
	
	public function create_processUpdateAcceptance_CSV($rr)
	{
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$fopen = fopen($filename,"w+");
		$header = array("Title", "Accepted By", "Fusion ID", "XPOID", "OMUID", "Location", "Client", "Process", "Acceptance Date");
		
		$row = "";
		foreach($header as $data) $row .= ''.$data.',';
		fwrite($fopen,rtrim($row,",")."\r\n");
		$searches = array("\r", "\n", "\r\n");
		
		foreach($rr as $user)
		{	
			$row = '"'.$user['pu_titile'].'",'; 
			$row .= '"'.$user['fname'] . " ". $user['lname']. '",';
			$row .= '"'.$user['fusion_id'].'",';  
			$row .= '"'.$user['xpoid'].'",';  
			$row .= '"'.$user['omuid'].'",';  
			$row .= '"'.$user['office_id'].'",'; 
			$row .= '"'.$user['client_name'].'",'; 
			$row .= '"'.$user['process_name'].'",'; 
			$row .= '"'.$user['accptdate'].'",'; 
			
			fwrite($fopen,$row."\r\n");
		}
		
		fclose($fopen);
	}
	
	
//////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////

/*-------------------Is Update Password Report-----------------------------*/	
	public function change_user_password(){
		if(check_logged_in()){
			
			$office_id = "";
			$user_office_id=get_user_office_id();
			$current_user = get_user_id();
			$is_global_access=get_global_access();
			$role_dir=get_role_dir();
			$data["show_download"] = false;
			$data["download_link"] = "";
			$data["show_table"] = false;
			$data["show_table"] = false;
			
			$office_id = $this->input->get('office_id');
			$is_update = $this->input->get('is_update');
		
			if($office_id=="")  $office_id=$user_office_id;
			
			
			$data["aside_template"] = "reports/aside.php";
			$data["content_template"] = "reports/change_user_password_report.php";
			
			
			$data["role_dir"]=$role_dir;
			$is_update="";
			$cValue="";
			$action="";
			$dn_link="";
			
			$data["is_update_password_list"]= array();
			$data['site_list'] = $this->Common_model->get_sites_for_assign();
			
			if(get_role_dir()=="super" || $is_global_access==1){
				$data['location_list'] = $this->Common_model->get_office_location_list();
			}else{
				$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
			}
			
			$data['client_list'] = $this->Common_model->get_client_list();
			
			if($this->input->get('show')=='Show')
			{
				$office_id = $this->input->get('office_id');
				$is_update = $this->input->get('is_update');
				$cValue = trim($this->input->get('client_id'));
				if($cValue=="") $cValue = trim($this->input->get('client_id'));
				
				$field_array = array(
						"office_id" => $office_id,
						"is_update" => $is_update,
						"client_id" => $cValue
					);
			
				$fullAray = $this->user_model->get_is_update_psw($field_array);
				$data["is_update_password_list"] = $fullAray;
				
				$this->create_Update_password_CSV($fullAray);
					
				$dn_link = base_url()."reports/download_is_updateCsv";
					
			}
			
			$data['download_link']=$dn_link;
			$data["action"] = $action;	
			$data['office_id']=$office_id;
			$data['is_update']=$is_update;
			$data['cValue']=$cValue;
			
			$this->load->view('dashboard',$data);
		}
	}
	
	
	public function download_is_updateCsv()
	{
		$currDate=date("Y-m-d");
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$newfile="change_user_password_list-'".$currDate."'.csv";
		
		header('Content-Disposition: attachment;  filename="'.$newfile.'"');
		readfile($filename);
	}
	
	
	public function create_Update_password_CSV($rr)
	{
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$fopen = fopen($filename,"w+");
		$header = array("Fusion ID", "XPOID", "OMUID", "First Name", "Last Name", "Location", "Designation", "Client", "Process", "Assigned To", "Update Password");
		
		$row = "";
		foreach($header as $data) $row .= ''.$data.',';
		fwrite($fopen,rtrim($row,",")."\r\n");
		$searches = array("\r", "\n", "\r\n");
		
		foreach($rr as $user)
		{	

			if($user['is_update_pswd']=="Y") $updatePassword="Yes";
			else $updatePassword="No";
		
			$row = '"'.$user['fusion_id'].'",'; 
			$row .= '"'.$user['xpoid'].'",'; 
			$row .= '"'.$user['omuid'].'",'; 
			$row .= '"'.$user['fname'].'",'; 
			$row .= '"'.$user['lname'].'",'; 
			$row .= '"'.$user['office_id'].'",'; 
			$row .= '"'.$user['role_name'].'",'; 
			$row .= '"'.$user['client_name'].'",'; 
			$row .= '"'.$user['process_name'].'",'; 
			$row .= '"'.$user['assigned_name'].'",';
			$row .= '"'.$updatePassword.'",'; 
			
			
			fwrite($fopen,$row."\r\n");
		}
		
		fclose($fopen);
	}	 
    
	
//////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////

/*-------------------Generate Bank Details-----------------------------*/	
	public function generate_bank_details(){
		if(check_logged_in()){
			
			$office_id = "";
			$user_office_id=get_user_office_id();
			$current_user = get_user_id();
			$is_global_access=get_global_access();
			$role_dir=get_role_dir();
			$data["show_download"] = false;
			$data["download_link"] = "";
			$data["show_table"] = false;
			$data["show_table"] = false;
			
			$office_id = $this->input->get('office_id');
			$is_update = $this->input->get('is_update');
		
			if($office_id=="")  $office_id=$user_office_id;
			
			
			$data["aside_template"] = "reports/aside.php";
			$data["content_template"] = "reports/generate_bank_details.php";
			
			
			$data["role_dir"]=$role_dir;
			$is_update="";
			$cValue="";
			$action="";
			$dn_link="";
			
			$data["get_bank_detail_list"]= array();
			$data['site_list'] = $this->Common_model->get_sites_for_assign();
			
			if(get_role_dir()=="super" || $is_global_access==1){
				$data['location_list'] = $this->Common_model->get_office_location_list();
			}else{
				$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
			}
			
			$data['client_list'] = $this->Common_model->get_client_list();
			
			if($this->input->get('show')=='Show' || $this->input->get('download')=='download')
			{
				$office_id = $this->input->get('office_id');
				$is_dowloadable = $this->input->get('download');
				
				$field_array = array(
						"office_id" => $office_id
					);
			
				$fullAray = $this->user_model->get_bank_details($field_array);
				
				$data["get_bank_detail_list"] = $fullAray;
				
				if($is_dowloadable != '' || $is_dowloadable=='download'){
					$this->generate_bank_details_xls($fullAray);
				}
				
				//$this->generate_bank_details_csv($fullAray);
				$dn_link = base_url()."reports/download_bank_csv/".$office_id;
					
			} 
			
			$data['download_link']=$dn_link;
			$data["action"] = $action;	
			$data['office_id']=$office_id;
			$data['is_update']=$is_update;
			$data['cValue']=$cValue;
			
			$this->load->view('dashboard',$data);
		}
	}
	public function generate_bank_details_csv($rr)
	{
		$filename = "./assets/reports/Bank-Details.csv";
		$fopen = fopen($filename,"w+");
		$header = array("Fusion ID", "XPOID","First Name", "Last Name", "Designation", "Client", "Department", "Bank Name", "Branch", "Account No", "IFSC Code");
		
		$row = "";
		foreach($header as $data) $row .= ''.$data.',';
		fwrite($fopen,rtrim($row,",")."\r\n");
		$searches = array("\r", "\n", "\r\n");
		
		foreach($rr as $user)
		{	
		
			$row = '"'.$user['fusion_id'].'",'; 
			$row .= '"'.$user['xpoid'].'",'; 
			$row .= '"'.$user['fname'].'",'; 
			$row .= '"'.$user['lname'].'",'; 
			$row .= '"'.$user['role_name'].'",'; 
			$row .= '"'.$user['client_name'].'",'; 
			$row .= '"'.$user['shname'].'",'; 
			$row .= '"'.$user['bank_name'].'",'; 
			$row .= '"'.$user['branch'].'",'; 
			$row .= '"'.$user['acc_no'].'",'; 
			$row .= '"'.$user['ifsc_code'].'",';
			
			
			fwrite($fopen,$row."\r\n");
		}
		
		fclose($fopen);
	}
	
	public function download_bank_csv($office_id='All')
	{
		$currDate=date("Y-m-d");
		$filename = "./assets/reports/Bank-Details.csv";
		$newfile="Bank Details of ".$office_id.".csv";
		
		header('Content-Disposition: attachment;  filename="'.$newfile.'"');
		readfile($filename);
	}
	
	
	
	public function generate_bank_details_xls($rr)
	{
			$this->objPHPExcel->createSheet();
			$this->objPHPExcel->setActiveSheetIndex();
			$objWorksheet = $this->objPHPExcel->getActiveSheet();
			$objWorksheet->setTitle('Bank Details ');
			 
			// START GRIDLINES HIDE AND SHOW//
			$objWorksheet->setShowGridlines(true);
			// END GRIDLINES HIDE AND SHOW//
			$this->objPHPExcel->getDefaultStyle()->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			
			 $this->objPHPExcel->getActiveSheet()->getStyle('A1:K1'.$this->objPHPExcel->getActiveSheet()->getHighestRow())
       ->getAlignment()->setWrapText(true);
			
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
			
			$style = array(
				'alignment' => array(
					'horizontal' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
				)
			);
			
			$objWorksheet->getStyle("A1:L1")->applyFromArray($style);
			$sheet = $this->objPHPExcel->getActiveSheet();

			unset($style);
	 
			// CELL BACKGROUNG COLOR
			$this->objPHPExcel->getActiveSheet()->getStyle("A2:L2")->getFill()->applyFromArray(
                $styleArray =array(
								'type' => PHPExcel_Style_Fill::FILL_SOLID,
								'startcolor' => array(
									 'rgb' => "F28A8C"
								)
							)
                );
       
			// CELL FONT AND FONT COLOR 
			$styleArray = array(
			'font'  => array(
				'bold'  => true,
				'color' => array('rgb' => '000000'),
				'size'  => 16,
				'name'  => 'Algerian'
			));

			$this->objPHPExcel->getActiveSheet()->getStyle('E1')->applyFromArray($styleArray);
			$this->objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($styleArray);
			
			$sheet = $this->objPHPExcel->getActiveSheet();
			$sheet->setCellValueByColumnAndRow(0, 1, "BANKING REPORT DETAILS");
			$sheet->mergeCells('A1:J1');
					
			
			
          $header = array("Fusion ID", "XPOID","OM ID", "First Name", "Last Name", "Designation", "Client", "Department", "Bank Name", "Branch", "Account No", "IFSC Code");

			$col=0;
			$row=2;
		
			foreach($header as  $excel_header){
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col,$row, $excel_header);	
					$col++; 
			}
			
			$row=3;
			foreach($rr as $user){ 
				$this->objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(0, $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0,$row, $user['fusion_id']);
				
				$this->objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(1, $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1,$row, $user['xpoid']);
				
				
				$this->objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(2, $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2,$row, $user['omuid']); 
				
				
				
				$this->objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(3, $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3,$row, $user['fname']);
				$this->objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(4, $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4,$row, $user['lname']);
				$this->objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(5, $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5,$row, $user['role_name']);
				$this->objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(6, $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6,$row, $user['client_name']);
				$this->objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(7, $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7,$row, $user['shname'] );
				$this->objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(8, $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8,$row, $user['bank_name']);
				$this->objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(9, $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9,$row, $user['branch']);
 
				$this->objPHPExcel->getActiveSheet()->getCellByColumnAndRow(10, $row)->setValueExplicit($user['acc_no'], PHPExcel_Cell_DataType::TYPE_STRING);

				$this->objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(11, $row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(11,$row, $user['ifsc_code']);
				
					
				$row ++;
			
			}
		 
 
            ob_end_clean();
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="bank_details.xlsx"');
            header('Cache-Control: max-age=0');
            $objWriter = PHPExcel_IOFactory::createWriter($this->objPHPExcel , 'Excel2007');
            $objWriter->setIncludeCharts(TRUE);
            $objWriter->save('php://output');
			exit();  
            
	}
	
	
	
	
	
	
	
//////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////

/*-------------------FEMS CERTIFICATION-----------------------------*/	
	public function fems_user_certification(){
		if(check_logged_in()){
			
			$office_id = "";
			$user_office_id=get_user_office_id();
			$current_user = get_user_id();
			$is_global_access=get_global_access();
			$role_dir=get_role_dir();
			$data["show_download"] = false;
			$data["download_link"] = "";
			$data["show_table"] = false;
			$data["show_table"] = false;
			
			$data["aside_template"] = "reports/aside.php";
			$data["content_template"] = "reports/fems_user_certification.php";
			
			$action="";
			$dn_link="";
			
			if(get_role_dir()=="super" || $is_global_access==1){
					//$data['site_list'] = $this->Common_model->get_sites_for_assign();
					$data['location_list'] = $this->Common_model->get_office_location_list();
				}else{
					//$sCond=" Where id = '$user_site_id'";
					
					//$data['site_list'] = $this->Common_model->get_sites_for_assign2($sCond);
					$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
				}
			
				if($this->input->post('showReports') == "Show" ){
					$action="do";
					$officeid  =  $this->input->post('office_id');
					$fems_result  =  $this->input->post('result');
					$fems_id  =  $this->input->post('fusion_id');
					
					if($fems_id == ''){
						if($fems_result == 1){
							$fems_result='PASS';
						}else{
							$fems_result='FAIL';
						}
					}else{
						$fems_result='ALL';
					}
					
					$data['oValue']  = $officeid;
					$data['fems_result'] = $fems_result;
					
					if($fems_id != ''){
						$fullAray = $this->user_model->user_certification_details('',$fems_id);
						$data["get_certification_details"] = $fullAray;	
					}else{
						
						$fullAray = $this->user_model->user_certification_details($officeid);
						$data["get_certification_details"] = $fullAray;
					}
					
					
					$this->create_user_certification_CSV($fullAray);
					$dn_link = base_url()."reports/download_user_certificationCsv";
					
					
					//echo "<pre>";
					//print_r($data["get_certification_details"]);
				
				}
				  
					$data['download_link']=$dn_link;
					$data["action"] = $action;	
				
			
			 
			
			$this->load->view('dashboard',$data);
		}
	}

	
	public function download_user_certificationCsv()
	{
		$currDate=date("Y-m-d");
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$newfile="Users_certification_list-'".$currDate."'.csv";
		
		header('Content-Disposition: attachment;  filename="'.$newfile.'"');
		readfile($filename);
	}
	
	
	public function create_user_certification_CSV($rr)
	{
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$fopen = fopen($filename,"w+");
		$header = array("User Name", "Total Questions", "Correct Answers", "Marks(%)");
		
		$row = "";
		foreach($header as $data) $row .= ''.$data.',';
		fwrite($fopen,rtrim($row,",")."\r\n");
		$searches = array("\r", "\n", "\r\n");
		
		foreach($rr as $user)
		{	
		
			$tot_corr_ans=$user['tot_corr_ans'];
			$tot_answer=$user['total_question_attempted'];
			
			$percentage=round((($tot_corr_ans/$tot_answer)*100), 2);
		
			$row = '"'.$user['user_name'].'",'; 
			$row .= '"'.$user['total_question_attempted'].'",';
			$row .= '"'.$user['tot_corr_ans'].'",';
			$row .= '"'.$percentage.'",';
			
			fwrite($fopen,$row."\r\n");
		}
		
		fclose($fopen);
	}
	///////////////////////////////Generate DFR Candidate Information//////////////////////
	
	public function dfr_candidate_info()
	{
		if(check_logged_in()){
			
			$office_id = "";
			$user_office_id=get_user_office_id();
			$current_user = get_user_id();
			$is_global_access=get_global_access();
			$role_dir=get_role_dir();
			$data["show_download"] = false;
			$data["download_link"] = "";
			$data["show_table"] = false;
			$data["show_table"] = false;
			$data['start_date']="";
			$data['end_date']="";
			$office_id = $this->input->get('office_id');
			$is_update = $this->input->get('is_update');
		
			if($office_id=="")  $office_id=$user_office_id;
			
			
			$data["aside_template"] = "reports/aside.php";
			$data["content_template"] = "reports/generate_dfr_candidate_details.php";
			
			
			$data["role_dir"]=$role_dir;
			$is_update="";
			$cValue="";
			$action="";
			$dn_link="";
			
			$data["get_candidate_list"]= array();
			$data['site_list'] = $this->Common_model->get_sites_for_assign();
			
			if(get_role_dir()=="super" || $is_global_access==1){
				$data['location_list'] = $this->Common_model->get_office_location_list();
			}else{
				$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
			}
			
			$data['client_list'] = $this->Common_model->get_client_list();
			
			if($this->input->get('showReports')=='Show')
			{
			
				$office_id = $this->input->get('office_id');
				$start_date = $this->input->get('start_date');
				$end_date = $this->input->get('end_date');
				
				$data['start_date']=$start_date;
				$data['end_date']=$end_date;
				$data['oValue']=$office_id;
				
				if($office_id == 'ALL')
				{
					$query = $this->db->query("SELECT dfr_candidate_details.*,dfr_requisition.raised_date, dfr_requisition.requisition_id FROM dfr_candidate_details LEFT JOIN dfr_requisition ON dfr_requisition.id=dfr_candidate_details.r_id WHERE (DATE_FORMAT(dfr_candidate_details.added_date,'%m/%d/%Y') BETWEEN '".$start_date."' AND '".$end_date."')");
				}
				else
				{
					$query = $this->db->query("SELECT dfr_candidate_details.*,dfr_requisition.raised_date, dfr_requisition.requisition_id FROM dfr_candidate_details LEFT JOIN dfr_requisition ON dfr_requisition.id=dfr_candidate_details.r_id WHERE dfr_requisition.location='KOL' AND (DATE_FORMAT(dfr_candidate_details.added_date,'%m/%d/%Y') BETWEEN '".$start_date."' AND '".$end_date."')");
				}
				
				
				$data["get_candidate_list"] = $query->result_array();
				
				$this->download_dfr_candidate_csv_array($data["get_candidate_list"]);
					
				$dn_link = base_url()."reports/download_dfr_candidate_csv/".$office_id;
					
			}
			
			$data['download_link']=$dn_link;
			$data["action"] = $action;	
			$data['office_id']=$office_id;
			$data['is_update']=$is_update;
			$data['cValue']=$cValue;
			
			$this->load->view('dashboard',$data);
		}
	}
	public function download_dfr_candidate_csv_array($rr)
	{
		$filename = "./assets/reports/DFR-Candidate-Details.csv";
		$fopen = fopen($filename,"w+");
		$header = array("Reference ID","Date Created","First Name","Last Name","Parmanent Address","Address for Correspondence","City","State","Zipcode","Country","Phone Number","Alternate Phone Number","Qualification","Total Exp","Email","From Where You Know About Us","Referer Info");
		
		$row = "";
		foreach($header as $data) $row .= ''.$data.',';
		fwrite($fopen,rtrim($row,",")."\r\n");
		$searches = array("\r", "\n", "\r\n");
		
		foreach($rr as $user)
		{	
		
			$row = '"'.$user['requisition_id'].'",'; 
			$row .= '"'.$user['raised_date'].'",'; 
			$row .= '"'.$user['fname'].'",'; 
			$row .= '"'.$user['lname'].'",'; 
			$row .= '"'.$user['address'].'",'; 
			$row .= '"'.$user['correspondence_address'].'",'; 
			$row .= '"'.$user['city'].'",'; 
			$row .= '"'.$user['state'].'",'; 
			$row .= '"'.$user['postcode'].'",'; 
			$row .= '"'.$user['country'].'",'; 
			$row .= '"'.$user['phone'].'",'; 
			$row .= '"'.$user['alter_phone'].'",';
			$row .= '"'.$user['last_qualification'].'",';
			$row .= '"'.$user['total_work_exp'].'",';
			$row .= '"'.$user['hiring_source'].'",';
			$rf_array = array();
			$rf_array[] = $user['ref_name'];
			$rf_array[] = $user['ref_dept'];
			$rf_array[] = $user['ref_id'];
			$c_rf_array = array_filter($rf_array);
			$row .= '"'.implode(',',$c_rf_array).'",';
			
			
			fwrite($fopen,$row."\r\n");
		}
		
		fclose($fopen);
	}
	public function download_dfr_candidate_csv($office_id='All')
	{
		$currDate=date("Y-m-d");
		$filename = "./assets/reports/DFR-Candidate-Details.csv";
		$newfile="DFR Candidate Details of ".$office_id.".csv";
		
		header('Content-Disposition: attachment;  filename="'.$newfile.'"');
		readfile($filename);
	}
	

//////////////////////////////////////////////////////////////

/*-------------------Process Update User Lists Report-----------------------------*/	
	public function user_process_update_list(){
		if(check_logged_in()){
			
			$office_id = "";
			$user_office_id=get_user_office_id();
			$current_user = get_user_id();
			$is_global_access=get_global_access();
			$role_dir=get_role_dir();
			$data["show_download"] = false;
			$data["download_link"] = "";
			$data["show_table"] = false;
			$data["show_table"] = false;
			
			$office_id = $this->input->get('office_id');
			$is_update = $this->input->get('is_update');
		
			if($office_id=="")  $office_id=$user_office_id;
			
			
			$data["aside_template"] = "reports/aside.php";
			$data["content_template"] = "reports/user_process_update_list.php";
			
			
			$data["role_dir"]=$role_dir;
			$is_update="";
			$cValue="";
			$action="";
			$dn_link="";
			
			/* $data["is_update_password_list"]= array();
			$data['site_list'] = $this->Common_model->get_sites_for_assign();
			
			if(get_role_dir()=="super" || $is_global_access==1){
				$data['location_list'] = $this->Common_model->get_office_location_list();
			}else{
				$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
			}
			
			$data['client_list'] = $this->Common_model->get_client_list();
			
			if($this->input->get('show')=='Show')
			{
				$office_id = $this->input->get('office_id');
				$is_update = $this->input->get('is_update');
				$cValue = trim($this->input->get('client_id'));
				if($cValue=="") $cValue = trim($this->input->get('client_id'));
				
				$field_array = array(
						"office_id" => $office_id,
						"is_update" => $is_update,
						"client_id" => $cValue
					);
			
				$fullAray = $this->user_model->get_is_update_psw($field_array);
				$data["is_update_password_list"] = $fullAray;
				
				$this->create_Update_password_CSV($fullAray);
					
				$dn_link = base_url()."reports/download_is_updateCsv";
					
			} */
			
			$data['download_link']=$dn_link;
			$data["action"] = $action;	
			$data['office_id']=$office_id;
			$data['is_update']=$is_update;
			$data['cValue']=$cValue;
			
			$this->load->view('dashboard',$data);
		}
	}
	
	
	/* public function download_is_updateCsv()
	{
		$currDate=date("Y-m-d");
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$newfile="change_user_password_list-'".$currDate."'.csv";
		
		header('Content-Disposition: attachment;  filename="'.$newfile.'"');
		readfile($filename);
	}
	
	
	public function create_Update_password_CSV($rr)
	{
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$fopen = fopen($filename,"w+");
		$header = array("Fusion ID", "XPOID", "OMUID", "First Name", "Last Name", "Location", "Designation", "Client", "Process", "Assigned To", "Update Password");
		
		$row = "";
		foreach($header as $data) $row .= ''.$data.',';
		fwrite($fopen,rtrim($row,",")."\r\n");
		$searches = array("\r", "\n", "\r\n");
		
		foreach($rr as $user)
		{	

			if($user['is_update_pswd']=="Y") $updatePassword="Yes";
			else $updatePassword="No";
		
			$row = '"'.$user['fusion_id'].'",'; 
			$row .= '"'.$user['xpoid'].'",'; 
			$row .= '"'.$user['omuid'].'",'; 
			$row .= '"'.$user['fname'].'",'; 
			$row .= '"'.$user['lname'].'",'; 
			$row .= '"'.$user['office_id'].'",'; 
			$row .= '"'.$user['role_name'].'",'; 
			$row .= '"'.$user['client_name'].'",'; 
			$row .= '"'.$user['process_name'].'",'; 
			$row .= '"'.$user['assigned_name'].'",';
			$row .= '"'.$updatePassword.'",'; 
			
			
			fwrite($fopen,$row."\r\n");
		}
		
		fclose($fopen);
	}	 */ 
    
	
////////////////////Master Database (19.07.2019)//////////////////////

	/*-------------------Master User Lists Report-----------------------------*/	
	public function fems_master_database(){
		if(check_logged_in()){
			$office_id = "";
			$dept_id = "";
			$user_office_id=get_user_office_id();
			$current_user = get_user_id();
			$is_global_access=get_global_access();
			$role_dir=get_role_dir();
			$data["show_download"] = false;
			$data["download_link"] = "";
			$data["show_table"] = false;
			$data["show_table"] = false;
			
			$office_id = $this->input->get('office_id');
			$is_update = $this->input->get('is_update');
		
			if($office_id=="")  $office_id=$user_office_id;
			
			
			$data["aside_template"] = "reports/aside.php";
			$data["content_template"] = "reports/fems_master_database_22_07.php";
			
			
			$data["role_dir"]=$role_dir;
			$action="";
			$dn_link="";
			
			//$data["get_master_database"] = $this->user_model->master_database_list();
			
			$data["get_master_database"]= array();
			
			
			if(get_role_dir()=="super" || $is_global_access==1){
				$data['location_list'] = $this->Common_model->get_office_location_list();
			}else{
				$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
			}
			
			$data['department_list'] = $this->Common_model->get_department_list();

			
			if($this->input->get('show')=='Show')
			{
				$office_id = $this->input->get('office_id');
				$dept_id = $this->input->get('dept_id');
				
				$field_array = array(
						"office_id" => $office_id,
						"dept_id" => $dept_id
					);
			
				$fullAray = $this->user_model->master_database_list($field_array);
				$data["get_master_database"] = $fullAray;
				
				$this->create_master_datebase_CSV($fullAray);
				
				//$this->generate_bank_details_xls($fullAray);
					
				$dn_link = base_url()."reports_22_07_2019/download_master_databaseCsv";
					
			}
			
			$data['download_link']=$dn_link;
			$data["action"] = $action;	
			$data['office_id']=$office_id;
			$data['dept_id']=$dept_id;
			
			$this->load->view('dashboard',$data);
		}
	}
	
	
	
	
	
	public function download_master_databaseCsv()
	{
		$currDate=date("Y-m-d");
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$newfile="master_database_list-'".$currDate."'.csv";
		
		header('Content-Disposition: attachment;  filename="'.$newfile.'"');
		readfile($filename);
	}
	
	
	public function create_master_datebase_CSV($rr)
	{
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$fopen = fopen($filename,"w+");
		$header = array("Fusion ID", "XPOID", "First Name", "Last Name", "Client", "Process", "Batch Code", "Role", "Organization Role", "Location", "Department", "DOJ", "Joining Month", "DOB", "Age", "Boss Name", "Official Email ID", "Personal Email ID", "Father's Name", "Gender", "Highest Qualification", "Present Address", "Permanent Address", "Mobile Number", "Blood Group", "Marital Status", "PAN Number", "UAN Number", "Aadhar Number", "Existing Bank A/C Number", "Bank IFSC CODE", "Hiring Source", "Hiring Sub Source", "Tenurity");
		
		$row = "";
		foreach($header as $data) $row .= ''.$data.',';
		fwrite($fopen,rtrim($row,",")."\r\n");
		$searches = array("\r", "\n", "\r\n");
		
		foreach($rr as $user)
		{
			
			$join_month = date('F', strtotime($user['doj']));
										
			$age_date1 = strtotime($user['dob']);
			$age_date2 = strtotime(CurrDate());
			$age = $age_date2 - $age_date1;
			$age_diff = floor($age / (60*60*24*365) );
			
			$tenu_date1 = strtotime($user['doj']);
			$tenu_date2 = strtotime(CurrDate());
			$interval = $tenu_date2 - $tenu_date1;
			$tenu_diff = floor($interval / (60*60*24) );
			
		
			$row = '"'.$user['fusion_id'].'",'; 
			$row .= '"'.$user['xpoid'].'",';
			$row .= '"'.$user['fname'].'",'; 
			$row .= '"'.$user['lname'].'",'; 
			$row .= '"'.$user['client_name'].'",'; 
			$row .= '"'.$user['process_name'].'",'; 
			$row .= '"'.$user['batch_code'].'",'; 
			$row .= '"'.$user['role_name'].'",'; 
			$row .= '"'.$user['org_role_name'].'",'; 
			$row .= '"'.$user['office_name'].'",'; 
			$row .= '"'.$user['dept_name'].'",'; 
			$row .= '"'.$user['doj'].'",'; 
			$row .= '"'.$join_month.'",'; 
			$row .= '"'.$user['dob'].'",'; 
			$row .= '"'.$age_diff." Years".'",'; 
			$row .= '"'.$user['assigned_name'].'",'; 
			$row .= '"'.$user['email_id_off'].'",'; 
			$row .= '"'.$user['email_id_per'].'",'; 
			$row .= '"'.$user['father_name'].'",'; 
			$row .= '"'.$user['sex'].'",'; 
			$row .= '"'.$user['lastQualification'].'",'; 
			$row .= '"'.$user['address_present'].'",'; 
			$row .= '"'.$user['address_parmanent'].'",'; 
			$row .= '"'.$user['phone'].'",'; 
			$row .= '"'.$user['blood_group'].'",'; 
			$row .= '"'.$user['marital_status'].'",'; 
			$row .= '"'.$user['pan_no'].'",'; 
			$row .= '="'.$user['uan_no'].'",'; 
			$row .= '"'.$user['social_secuirity_no'].'",'; 
			$row .= '="'.$user['acc_no'].'",'; 
			$row .= '"'.$user['ifsc_code'].'",'; 
			$row .= '"'.$user['hiring_source'].'",'; 
			$row .= '"'.$user['hiring_sub_source'].'",'; 
			$row .= '"'.$tenu_diff." Days".'",';
			//$user['acc_no']
		  
			fwrite($fopen,$row."\r\n");
		}
		
		fclose($fopen);
	} 
    
//////////////////////////////////////////////////////////////	
	
	public function dfr_dashboard()
    {
				
        if(check_logged_in())
        {
			$current_user = get_user_id();
			
			$data["aside_template"] = "reports/aside.php";
			$data["content_template"] = "reports/dfr_day_summ.php";
			
			$start_date=CurrDate();
			$location=get_user_office_id();
			//$dept=get_dept_id();
			
			
			//$data['department_list'] = $this->Common_model->get_department_list();	
			
			if(get_role_dir()=="super" || $is_global_access==1){
				$data['location_list'] = $this->Common_model->get_office_location_list();
			}else{
				$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
			}
			
			if($this->input->get('showReports')=='Show')
			{
				$start_date = $this->input->get('start_date');
				$location = $this->input->get('location');
				//$dept = $this->input->get('dept');
				$data['start_date'] = $start_date;
			}
			
			$query = $this->db->query('SELECT COUNT(*) AS opened_requisation FROM `dfr_requisition` WHERE requisition_status="A" AND DATE_FORMAT(due_date, "%m/%d/%Y") >= "'.$start_date.'" AND location="'.$location.'"');
			
			$result = $query->row();
			$data["opened_requisation"] = $result->opened_requisation;
			
			
			$qSql = 'SELECT COUNT(*) AS candidate_registered FROM `dfr_candidate_details` dc Left Join dfr_requisition dr on dc.r_id =dr.id WHERE DATE_FORMAT(getEstToLocalAbbr(added_date,location), "%m/%d/%Y") = "'.$start_date.'" AND dr.location="'.$location.'"';			
			$query = $this->db->query($qSql);
			
			
			$result = $query->row();
			$data["candidate_registered"] = $result->candidate_registered;
			
			$query = $this->db->query('SELECT * FROM `dfr_interview_schedules`  WHERE DATE_FORMAT( getEstToLocalAbbr(creation_date,interview_site), "%m/%d/%Y") = "'.$start_date.'" AND interview_site="'.$location.'" GROUP BY c_id');
			
			$data["total_candidate_scheduled"] = $query->num_rows();
			
			$query = $this->db->query('SELECT * FROM `dfr_interview_schedules` WHERE sh_status="P" AND  DATE_FORMAT(getEstToLocalAbbr(creation_date,interview_site), "%m/%d/%Y") = "'.$start_date.'" AND interview_site="'.$location.'" GROUP BY c_id');
			//$result = $query->row();
			
			$data["total_candidate_pending"] = $query->num_rows();
			
			$query = $this->db->query('SELECT * FROM `dfr_interview_schedules` LEFT JOIN dfr_candidate_details on dfr_candidate_details.id=dfr_interview_schedules.c_id WHERE dfr_candidate_details.candidate_status IN("IP") AND  DATE_FORMAT(getEstToLocalAbbr(creation_date,interview_site), "%m/%d/%Y") = "'.$start_date.'" AND interview_site="'.$location.'" GROUP BY c_id');
			//$result = $query->row();
			$data["candidate_inprogress"] = $query->num_rows();
			
			//$result = $query->row();
			$query = $this->db->query('SELECT * FROM `dfr_interview_schedules` LEFT JOIN dfr_candidate_details on dfr_candidate_details.id=dfr_interview_schedules.c_id WHERE dfr_candidate_details.candidate_status IN("SL") AND  DATE_FORMAT(getEstToLocalAbbr(creation_date,interview_site), "%m/%d/%Y") = "'.$start_date.'" AND interview_site="'.$location.'"  GROUP BY dfr_interview_schedules.c_id');
			$data["candidate_shortlisted"] = $query->num_rows();
			
		//$query = $this->db->query('SELECT * FROM `dfr_interview_schedules` WHERE sh_status IN("E","CS")  GROUP BY c_id');
		$query = $this->db->query('SELECT * FROM `dfr_interview_schedules`  LEFT JOIN dfr_candidate_details on dfr_candidate_details.id=dfr_interview_schedules.c_id WHERE dfr_candidate_details.candidate_status IN("CS") AND  DATE_FORMAT(getEstToLocalAbbr(creation_date,interview_site), "%m/%d/%Y") = "'.$start_date.'" AND interview_site="'.$location.'"  GROUP BY c_id');
			//$result = $query->row();
			$data["total_candidate_selected"] = $query->num_rows();
			
			$query = $this->db->query('SELECT * FROM `dfr_interview_schedules` LEFT JOIN dfr_candidate_details on dfr_candidate_details.id=dfr_interview_schedules.c_id WHERE dfr_candidate_details.candidate_status IN("E") AND  DATE_FORMAT(getEstToLocalAbbr(creation_date,interview_site), "%m/%d/%Y") = "'.$start_date.'" AND interview_site="'.$location.'" GROUP BY c_id');
			//$result = $query->row();
			$data["total_candidate_selected_employee"] = $query->num_rows();
			
			$query = $this->db->query('SELECT * FROM `dfr_interview_schedules` WHERE DATE_FORMAT(getEstToLocalAbbr(creation_date,interview_site), "%m/%d/%Y") = "'.$start_date.'" AND interview_site="'.$location.'"');
			//$result = $query->row();
			$data["total_interview_scheduled"] = $query->num_rows();
			
			$query = $this->db->query('SELECT COUNT(*) AS interview_completed FROM `dfr_interview_schedules` WHERE sh_status IN("C","N")  AND  DATE_FORMAT(getEstToLocalAbbr(creation_date,interview_site), "%m/%d/%Y") = "'.$start_date.'" AND interview_site="'.$location.'"');
			
			$result = $query->row();
			$data["interview_completed"] = $result->interview_completed;
						
			$query = $this->db->query('SELECT COUNT(*) AS interview_pending FROM `dfr_interview_schedules` WHERE sh_status IN("P")  AND  DATE_FORMAT(getEstToLocalAbbr(creation_date,interview_site), "%m/%d/%Y") = "'.$start_date.'" AND interview_site="'.$location.'"');
			
			$result = $query->row();
			$data["interview_pending"] = $result->interview_pending;
			
			
			$data["interview_cancel"] = $data["total_interview_scheduled"] - $data["interview_completed"]- $data["interview_pending"];
			
						
			$query = $this->db->query('SELECT COUNT(*) AS hr_interview_completed FROM `dfr_interview_schedules` WHERE sh_status IN("C","N") AND  DATE_FORMAT(getEstToLocalAbbr(creation_date,interview_site), "%m/%d/%Y") = "'.$start_date.'" AND interview_type="1" AND interview_site="'.$location.'"');
			$result = $query->row();
			$data["hr_interview_completed"] = $result->hr_interview_completed;
			
			$query = $this->db->query('SELECT COUNT(*) AS hr_interview_completed FROM `dfr_interview_schedules` WHERE sh_status IN("R") AND  DATE_FORMAT(getEstToLocalAbbr(creation_date,interview_site), "%m/%d/%Y") = "'.$start_date.'" AND interview_type="1" AND interview_site="'.$location.'"');
			$result = $query->row();
			$data["hr_interview_cancel"] = $result->hr_interview_completed;
			
			
			$query = $this->db->query('SELECT COUNT(*) AS hr_interview_pending FROM `dfr_interview_schedules` WHERE sh_status IN("P") AND  DATE_FORMAT(getEstToLocalAbbr(creation_date,interview_site), "%m/%d/%Y") = "'.$start_date.'" AND interview_site="'.$location.'" AND interview_type="1"');
			$result = $query->row();
			$data["hr_interview_pending"] = $result->hr_interview_pending;
			
			
			$query = $this->db->query('SELECT COUNT(*) AS ops_interview_completed FROM `dfr_interview_schedules` WHERE sh_status IN("C","N") AND  DATE_FORMAT(getEstToLocalAbbr(creation_date,interview_site), "%m/%d/%Y") = "'.$start_date.'" AND interview_site="'.$location.'" AND interview_type="2"');
			$result = $query->row();
			$data["ops_interview_completed"] = $result->ops_interview_completed;
			
			
			$query = $this->db->query('SELECT COUNT(*) AS ops_interview_completed FROM `dfr_interview_schedules` WHERE sh_status IN("R") AND  DATE_FORMAT(getEstToLocalAbbr(creation_date,interview_site), "%m/%d/%Y") = "'.$start_date.'" AND interview_site="'.$location.'" AND interview_type="2"');
			$result = $query->row();
			$data["ops_interview_cancel"] = $result->ops_interview_completed;
			
			$query = $this->db->query('SELECT COUNT(*) AS ops_interview_pending FROM `dfr_interview_schedules` WHERE sh_status IN("P") AND  DATE_FORMAT(getEstToLocalAbbr(creation_date,interview_site), "%m/%d/%Y") = "'.$start_date.'" AND interview_site="'.$location.'" AND interview_type="2"');
			$result = $query->row();
			$data["ops_interview_pending"] = $result->ops_interview_pending;
			
			
			//$query = $this->db->query('SELECT * FROM `dfr_interview_schedules` WHERE sh_status IN("C","N") AND  DATE_FORMAT(getEstToLocalAbbr(creation_date,interview_site), "%m/%d/%Y") = "'.$start_date.'"  and sh_status not in ("SL","E","CS") AND interview_site="'.$location.'" GROUP BY c_id');
								
			$query = $this->db->query('SELECT * FROM `dfr_interview_schedules` LEFT JOIN dfr_candidate_details on dfr_candidate_details.id=dfr_interview_schedules.c_id WHERE sh_status IN("C","N") AND  DATE_FORMAT(getEstToLocalAbbr(creation_date,interview_site), "%m/%d/%Y") = "'.$start_date.'"  and candidate_status not in ("SL","E","CS","R") AND interview_site="'.$location.'" GROUP BY c_id');
			
			//$result = $query->row();
			$data["candidate_undefind_status"] = $query->num_rows();
			
			$query = $this->db->query('SELECT COUNT(*) AS candidate_rejected FROM `dfr_candidate_details`  dc Left Join dfr_requisition dr on dc.r_id =dr.id WHERE DATE_FORMAT(getEstToLocalAbbr(added_date,location), "%m/%d/%Y") = "'.$start_date.'" AND candidate_status="R" AND dr.location="'.$location.'"');
			$result = $query->row();
			$data["candidate_rejected"] = $result->candidate_rejected;
						
			$query = $this->db->query('SELECT * FROM `dfr_interview_schedules`  LEFT JOIN dfr_candidate_details on dfr_candidate_details.id=dfr_interview_schedules.c_id WHERE dfr_candidate_details.candidate_status IN("SL") AND  DATE_FORMAT(getEstToLocalAbbr(creation_date,interview_site), "%m/%d/%Y") = "'.$start_date.'" AND interview_site="'.$location.'" GROUP BY c_id');
			//$result = $query->row();
			$data["pending_cand_final_stat"] = $query->num_rows();
	
			$data['start_date'] = $start_date;
			$data['location'] = $location;
			//$data['dept'] = $dept;
			
			$this->load->view('dashboard',$data);
		}
		
	}
	
}

?>