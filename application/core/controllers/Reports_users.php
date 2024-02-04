<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reports_users extends CI_Controller {

    private $aside = "reports/aside.php";
	private $objPHPExcel;
    /////////////////////////////////////////////////////////////////////////////////////////////
    // INDEX PAGE
    /////////////////////////////////////////////////////////////////////////////////////////////
    
	 function __construct() {
		parent::__construct();
		
		$this->load->library('excel');
		$this->load->model('Reports_sp_model');
		$this->load->model('Common_model');
		$this->load->model('user_model');
		$this->load->model('Dfr_model');
		$this->Reports_sp_model->set_report_database("report");
		
		$this->objPHPExcel = new PHPExcel();
		
	 }
	 
    public function index()
    {
				
        if(check_logged_in())
        {
						
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
				$client_id = "";
				$office_id = "";
				$dept_id = "";
				
								
				if($office_id=="")  $office_id=$user_office_id;
				
				if($this->input->get('downloadReport')=='Download CSV')
				{
					$start_date = $this->input->get('start_date');
					$end_date = $this->input->get('end_date');
										
					$filterArray = array(
                            "start_date" => $start_date,
							"end_date" => $end_date,
							"client_id" => $client_id,
							"office_id" => $office_id,
							"dept_id"=> $dept_id
                     ); 
											
									
				
				
					$rr = $fullArr = $this->Reports_sp_model->get_user_list_daywise($filterArray,"","Y");
										
					$Lfull_name=get_username();
					$LOMid=get_user_omuid();
					$all_params=str_replace('%2F','/',http_build_query($filterArray));
					
					$LogMSG="View OR Download Main Report with ". $all_params;
					
					log_message('FEMS', $LOMid.' - ' . $Lfull_name . ' | '.$LogMSG );
					
					$this->create_CSV($fullArr,$filterArray,true);	
											
				}
				
				
					
				$data['start_date']=$start_date;
				$data['end_date']=$end_date;
								
				$data['cValue']=$client_id;
				
				$data['oValue']=$office_id;
				$data['dept_id']=$dept_id;
				
				$data["aside_template"] = $this->aside;
				
				$data["content_template"] = "reports/user_list_daywise.php";
			    
				$data['client_list'] = $this->Common_model->get_client_list();
				
				if(get_role_dir()=="super" || $is_global_access==1 || get_dept_folder()=="rta"){
					$data['site_list'] = $this->Common_model->get_sites_for_assign();
					$data['location_list'] = $this->Common_model->get_office_location_list();
				}else{
					$sCond=" Where id = '$user_site_id'";
					
					$data['site_list'] = $this->Common_model->get_sites_for_assign2($sCond);
					$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
				}
					
					
				if($client_id=="" || $client_id=="ALL") $data['process_list'] = array(); 
				else $data['process_list'] = $this->Common_model->get_process_list($client_id);
				
				$data['process_list'] = array();
								
				$data['department_list'] = $this->Common_model->get_department_list();	
				
				if($is_global_access=='1' ||  get_role_dir()=="admin" || get_dept_folder()=="hr" || get_dept_folder()=="wfm" || get_dept_folder()=="rta" || get_dept_folder()=="mis" || is_all_dept_access()){
				
					$data['department_list'] = $this->Common_model->get_department_list();
					
				
				}else{
					$data['department_list'] = $this->Common_model->get_department_session($ses_dept_id);
					
				}
				
				$this->load->view('dashboard',$data);
			
        }
    }
	
		
	public function create_CSV($rr,$fArray,$isDownload=false)
	{
		
						
		$filename = "./assets/reports/Active_user_Count_Day_Wise: ".get_user_id().".csv";
		
		$fopen = fopen($filename,"w+");
	
		$header = array("Date", "Location","Total Users","Term Count","Suspended Count", "Furlough Count", "Active User Count");
		
		$row = "";
		
		foreach($header as $data) $row .= ''.$data.',';
		
		fwrite($fopen,rtrim($row,",")."\r\n");
		
		//echo "<pre>";
		//print_r($rr);
		//echo "</pre>";
		
		foreach($rr as $user)
		{	
		
			$rdate = $user['cDate'];
			
			$row = '"'.$rdate.'",'; 
			$row .= '"'.$user['office_id'].'",'; 
			$row .= '"'.$user['totalCount'].'",'; 
			$row .= '"'.$user['termCount'].'",'; 
			$row .= '"'.$user['susCount'].'",'; 
			$row .= '"'.$user['furCount'].'",'; 										
			$row .= '"'.$user['activeCount'].'"'; 
						
			fwrite($fopen,$row."\r\n");
			
		}
		
		fclose($fopen);
									
		if($isDownload==true){
			
			ob_end_clean();
			$s_date = $fArray["start_date"]; 
			$e_date = $fArray["end_date"]; 
			$newfile="Active_user_Count_Day_Wise-".$s_date."to".$e_date.".csv";
			header('Content-Disposition: attachment;  filename="'.$newfile.'"');
			readfile($filename);
			exit();
		}
		
	}
	
}

?>