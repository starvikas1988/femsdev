<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Attendance extends CI_Controller {

   private $aside = "reports/aside.php";

    /////////////////////////////////////////////////////////////////////////////////////////////
    // INDEX PAGE
    /////////////////////////////////////////////////////////////////////////////////////////////
    
	 function __construct() {
		parent::__construct();
		
		$this->load->library('excel');
		
		$this->load->model('reports_model');
		$this->load->model('Common_model');
		//$this->reports_model->set_report_database("report");
		
	 }
	 
    public function index()
    {
	
		if(check_logged_in())
        {
			//$this->check_access();
			
			$role_id= get_role_id();
			$current_user = get_user_id();
			//echo $current_user;
			//////////////////////////////////
			$user_site_id= get_user_site_id();
			$ses_dept_id=get_dept_id();
			$ses_office_id=get_user_office_id();
			
			$is_global_access=get_global_access();
			
			//////////////////////////////////
						
				//$data["aside_template"] = get_aside_template();
				$data["aside_template"] = $this->aside;
				
				$data["content_template"] = "attendance/att_main.php";
			    
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
				$data['error']="";
					
				
				if($office_id=="")  $office_id=$ses_office_id;
				
				if($this->input->post('exportReports')=='Export As Excel')
				{
				
						$start_date = $this->input->post('start_date');
						$end_date = $this->input->post('end_date');
						$filter_key = $this->input->post('filter_key');
						
						$client_id = $this->input->post('client_id');
						$site_id = $this->input->post('site_id');
						
						$office_id = $this->input->post('office_id');
						if($office_id=="")  $office_id=$ses_office_id;
						
						$dept_id = $this->input->post('dept_id');
						if($dept_id=="")  $dept_id=$ses_dept_id;
						
						$sdValue = $this->input->post('sub_dept_id');
											
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
								 
						if($filter_key!="" ){
								
							switch($filter_key){
								case 'Site':
									$filter_value = $this->input->post('site_id');
									break;
								case 'Agent':
									$filter_value = $this->input->post('agent_id');
									break;
								case 'Process':
									$filter_value = $this->input->post('process_id');
									
									break;
								case 'Disposition':
									$filter_value = $this->input->post('disp_id');
									break;
								case 'Role':
									$filter_value = $this->input->post('role_id');
									break;
									
								case 'AOF':
									$filter_value = $this->input->post('assign_id');
									
								break;
						
							}
							if($filter_value=="") $filter_value = $this->input->post('filter_value');
						}
						
						$filterArray["filter_value"]=$filter_value;
						
					  
					  
					  //if($role_id =='2' || $role_id=='5' || $role_id=='9') $filterArray["assigned_to"]=$current_user;	
					  if(get_dept_folder()=="hr" || get_dept_folder()=="rta" || get_dept_folder()=="wfm" || get_dept_folder()=="mis") $filterArray["assigned_to"]="";	 
					  else if(get_role_dir()=="trainer" || get_role_dir()=="tl") $filterArray["assigned_to"] = $current_user;
					  else $filterArray["assigned_to"]="";	
								 
					 $fullArr = $this->reports_model->get_user_list_report($filterArray);
					
					 //echo "<pre>" .print_r($fullArr, 1) ."</pre>"; die();
					
					if($fullArr!=null){
					
						//////////LOG////////
					
						$Lfull_name=get_username();
						$LOMid=get_user_omuid();
						
						$all_params=str_replace('%2F','/',http_build_query($filterArray));
						$LogMSG="Download Attendance Report with ". $all_params;
						
						log_message('FEMS', $LOMid.' - ' . $Lfull_name . ' | '.$LogMSG );
							
						//////////
						$this->createExcelFile($fullArr,$filterArray);
					
					}else{
						$data['error']="Not found any records";
					}
					
				}
				
				
				$data['client_list'] = $this->Common_model->get_client_list();			

				
				if($is_global_access==1 || get_dept_folder()=="rta"){
					$data['site_list'] = $this->Common_model->get_sites_for_assign();
					$data['location_list'] = $this->Common_model->get_office_location_list();
				}else{
					$sCond=" Where id = '$user_site_id'";
					$data['site_list'] = $this->Common_model->get_sites_for_assign2($sCond);
					$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
				}
				
				
				$data['process_list'] = array(); // $this->Common_model->get_process_for_assign();
				
				if(get_role_dir()=="tl" || get_role_dir()=="trainer"){
					$qSql="SELECT id,name FROM role where is_active=1 and folder not in('super','admin','manager') ORDER BY name";
					$data['role_list'] = $this->Common_model->get_rolls_for_assignment2($qSql); 
				}else{
					//$data['roll_list'] = $this->Common_model->get_rolls_for_assignment();
					$qSql="SELECT id,name FROM role where is_active=1 and folder not in('super','admin') ORDER BY name";
					$data['role_list'] = $this->Common_model->get_rolls_for_assignment2($qSql);	
				}
				
				if($is_global_access==1 || get_dept_folder()=="rta"){			
						$data['assign_list'] = $this->Common_model->get_tls_for_assign2("");
				}else if(get_role_dir()=="admin"){
					$tl_cnd=" and dept_id='$ses_dept_id' ";
					$data['assign_list'] = $this->Common_model->get_tls_for_assign2($tl_cnd);
				}else{
					$tl_cnd=" and (site_id='$user_site_id' OR office_id='$ses_office_id') ";
					$data['assign_list'] = $this->Common_model->get_tls_for_assign2($tl_cnd);
				}	

				if($is_global_access=='1' ||  get_role_dir()=="admin" || get_dept_folder()=="hr" || get_dept_folder()=="wfm" || get_dept_folder()=="rta" || get_dept_folder()=="mis" || is_all_dept_access()){
				
					$data['department_list'] = $this->Common_model->get_department_list();
					if($dept_id=="ALL" || $dept_id=="") $data['sub_department_list'] = array();
					else $data['sub_department_list'] = $this->Common_model->get_sub_department_list($dept_id);
				
				}else{
					$data['department_list'] = $this->Common_model->get_department_session($ses_dept_id);
					$data['sub_department_list'] = $this->Common_model->get_sub_department_list($ses_dept_id);
				}
				
				
				
				
							
				$data['cValue']=$client_id;
				$data['sValue']=$site_id;
				$data['oValue']=$office_id;
				$data['dept_id']=$dept_id;
				$data['sdValue']=$sdValue;
				
				$data['start_date']=$start_date;
				$data['end_date']=$end_date;
				$data['filter_key']=$filter_key;
				$data['filter_value']=$filter_value;
				$data['ses_role_id']=$role_id;
				
				$this->load->view('dashboard',$data);
				
			
			
	   }
	   
    }
		
	private function createExcelFile($data,$fArray,$isLoginTime='N')
	{
		
		
		$filter_key =$fArray['filter_key'];
		
		$_atitle="";
		
		if($filter_key!="" && $filter_key!="OfflineList"){
		
			$filter_value =$fArray['filter_value'];
			
			switch($filter_key){
				case 'Site':
					
					$qSql="Select name as value from  site where id='$filter_value'";
					$_atitle = " - ".$this->Common_model->get_single_value($qSql);
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
		
				
		$start_date =$fArray['start_date'];
		$end_date =$fArray['end_date'];
		
		$title="Attendance From ".$start_date." To ".$end_date.$_atitle. " (All Time is in 'User Local Time')";
		
		$start_date =str_replace("/","-",$start_date);
		$end_date =str_replace("/","-",$end_date);
		
		//$process =$fArray['process'];	
		
		$fn="attendance-".$start_date."-".$end_date."".$_atitle.".xls";
		$filename = "./assets/reports/".$fn;
		
		$sht_title=$start_date." To ".$end_date." ";
		
		$default_border = array(
			'style' => PHPExcel_Style_Border::BORDER_THIN,
			'color' => array('rgb'=>'000000')
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
				'color' => array('rgb'=>'FFBCB2'),
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
		
		$style_trm = array(
			'borders' => array(
				'bottom' => $default_border,
				'left' => $default_border,
				'top' => $default_border,
				'right' => $default_border,
			),
			'fill' => array(
				'type' => PHPExcel_Style_Fill::FILL_SOLID,
				'color' => array('rgb'=>'FF0000'),
			),
			'font' => array(
				'size' => 10,
			),
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
				'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
			)
		);
		
		$style_ptrm = array(
			'borders' => array(
				'bottom' => $default_border,
				'left' => $default_border,
				'top' => $default_border,
				'right' => $default_border,
			),
			'fill' => array(
				'type' => PHPExcel_Style_Fill::FILL_SOLID,
				'color' => array('rgb'=>'FF817F'),
			),
			'font' => array(
				'size' => 10,
			),
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
				'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
			)
		);
		
		
		$style_syslog = array(
			'borders' => array(
				'bottom' => $default_border,
				'left' => $default_border,
				'top' => $default_border,
				'right' => $default_border,
			),
			'fill' => array(
				'type' => PHPExcel_Style_Fill::FILL_SOLID,
				'color' => array('rgb'=>'9ec2ff'),
			),
			'font' => array(
				'size' => 10,
			),
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
				'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
			)
		);
		
		$style_gray = array(
			'borders' => array(
				'bottom' => $default_border,
				'left' => $default_border,
				'top' => $default_border,
				'right' => $default_border,
			),
			'fill' => array(
				'type' => PHPExcel_Style_Fill::FILL_SOLID,
				'color' => array('rgb'=>'808080'),
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
		
		
		//activate worksheet number 1
		$this->excel->setActiveSheetIndex(0);
		//name the worksheet
		$this->excel->getActiveSheet()->setTitle($sht_title);
		//set cell A1 content with some text
	
		$this->excel->getActiveSheet()->setCellValue('A1', $title);
	
		//change the font size
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(14);
		//make the font become bold
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
						
		//$letters = range('A', 'Z');
		
		$letters = array(); 
		$k=0;
		 for ($i = 'A'; $i !== 'ZZ'; $i++){
			$letters[$k++]=$i;
		}

		//print_r($letters);
		// start and end are seconds, so I convert it to days 
		
					
		$this->excel->getActiveSheet()->setCellValue('A2', 'SLNo');
		$cell='A2';
		if($isLoginTime=="Y"){
			$cell='A2:A3';
			$this->excel->getActiveSheet()->mergeCells($cell);
		}
		$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
		
		
		$this->excel->getActiveSheet()->setCellValue('B2', 'Fusion Id');
		$cell='B2';
		if($isLoginTime=="Y"){
			$cell='B2:B3';
			$this->excel->getActiveSheet()->mergeCells($cell);
		}
		$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
		
		$this->excel->getActiveSheet()->setCellValue('C2', 'OM ID/XPOID');
		$cell='C2';
		if($isLoginTime=="Y"){
			$cell='C2:C3';
			$this->excel->getActiveSheet()->mergeCells($cell);
		}
		$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
		
		$this->excel->getActiveSheet()->setCellValue('D2', 'NAME');
		$cell='D2';
		if($isLoginTime=="Y"){
			$cell='D2:D3';
			$this->excel->getActiveSheet()->mergeCells($cell);
		}
		$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
		
		
		$this->excel->getActiveSheet()->setCellValue('E2', 'Dept');
		$cell='E2';
		if($isLoginTime=="Y"){
			$cell='E2:E3';
			$this->excel->getActiveSheet()->mergeCells($cell);
		}
		$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
		
		
		$this->excel->getActiveSheet()->setCellValue('F2', 'Designation');
		$cell='F2';
		if($isLoginTime=="Y"){
			$cell='F2:F3';
			$this->excel->getActiveSheet()->mergeCells($cell);
		}
		$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
		
		
		
		$this->excel->getActiveSheet()->setCellValue('G2', 'DOJ');
		$cell='G2';
		if($isLoginTime=="Y"){
			$cell='G2:G3';
			$this->excel->getActiveSheet()->mergeCells($cell);
		}
		$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
		
		
		
		$cell='H2';
		$this->excel->getActiveSheet()->setCellValue('H2', 'Location');
		if($isLoginTime=="Y"){
			$cell='H2:H3';
			$this->excel->getActiveSheet()->mergeCells($cell);
		}
		$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
		
		
		$cell='I2';
		$this->excel->getActiveSheet()->setCellValue('I2', 'Client');
		if($isLoginTime=="Y"){
			$cell='I2:I3';
			$this->excel->getActiveSheet()->mergeCells($cell);
		}
		$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
		
		
		$cell='J2';
		$this->excel->getActiveSheet()->setCellValue('J2', 'Process');
		if($isLoginTime=="Y"){
			$cell='J2:J3';
			$this->excel->getActiveSheet()->mergeCells($cell);
		}
		$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
		
		$cell='K2';
		$this->excel->getActiveSheet()->setCellValue('K2', 'L1 Supervisor');
		
		if($isLoginTime=="Y"){
			$cell='K2:K3';
			$this->excel->getActiveSheet()->mergeCells($cell);
		}
		$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
		
		
		$cell='L2';
		$this->excel->getActiveSheet()->setCellValue('L2', 'Status');
		
		if($isLoginTime=="Y"){
			$cell='L2:L3';
			$this->excel->getActiveSheet()->mergeCells($cell);
		}
		$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
		
		$cell='M2';
		$this->excel->getActiveSheet()->setCellValue('M2', 'Phase');
		
		if($isLoginTime=="Y"){
			$cell='M2:M3';
			$this->excel->getActiveSheet()->mergeCells($cell);
		}
		$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
		
		
		/*
		
		$start = strtotime($start_date);
		$end = strtotime($end_date);
		$diff = ($end - $start) / 86400; 
		$j=4;
		
		for ($i = 0; $i <= $diff; $i++) {
			$date = $start + ($i * 86400);
			$cDate= date('Y-m-d', $date);
			$cell=$letters[$j++]."2";
			$this->excel->getActiveSheet()->setCellValue($cell, $cDate);
		}
		*/
		//$this->excel->getActiveSheet()->getStyle('C2:'.$cell)->applyFromArray( $default_border ); // give style to header
 				
		if($isLoginTime=="Y") $r=3;
		else $r=2;
				
		$j=-1;
		$k=0;
		
		
		$allRowDone=false;
		$isFirst=true;
		
		$pevDate="";
		
		$cnt=1;
		
		foreach($data as $row)
		{
			$rdate=$row['rDate'];
			
			if($isFirst==false && $rdate!=$pevDate) $allRowDone=true;
			
			if($rdate!=$pevDate){
				
				if($isLoginTime=="Y"){ 
					$j+=8;
					$r=3;
				}else{
					//$j++;
					$j+=2;
					$r=3;
				}
			}
			
			$isFirst=false;
			
			if($allRowDone==false) $j = -1;
						
			$r++;
			
			$pevDate=$rdate;
			
			$disposition=$row['disposition'];
			$office_id = $row['office_id'];
			$role_id=$row['role_id'];
			
			$logged_in_hours = $row['logged_in_hours'];
			$logged_in_hours_local = $row['logged_in_hours_local'];
			
			$work_time=$row['logged_in_sec'];
			$work_time_local=$row['logged_in_sec_local'];
			
			$bg_style=$style_def;
			$bg_style_est=$style_def;
			$bg_style_local=$style_def;
			
			$att="";
			
			$isProperLogout = 'Y';
			
			$todayLoginTime = $row['todayLoginTime'] ;
			$todayLoginTime_local= ConvServerToLocalAny($todayLoginTime,$office_id);
			
			$is_logged_in = $row['is_logged_in'];
								
			$flogin_time = $row['flogin_time'];
			$flogin_time_local = $row['flogin_time_local'];
			
			$logout_time=$row['logout_time'];
			$logout_time_local=$row['logout_time_local'];
			
			$tBrkTime=$row['tBrkTime'];
			$tBrkTimeLocal=$row['tBrkTimeLocal'];
			
			$ldBrkTime=$row['ldBrkTime'];
			$ldBrkTimeLocal=$row['ldBrkTimeLocal'];
			
			$total_break=$tBrkTime+$ldBrkTime;
			$total_break_local=$tBrkTimeLocal+$ldBrkTimeLocal;
				
			$comments = $row['comments'];
			
						
			$omuid= $row['omuid'];
			$xpoid= $row['xpoid'];
			if($xpoid!="") $omuid = $xpoid;
			
			
			$leave_dtl = "";
			$leave_status = $row['leave_status'];
			if($row['leave_type'] !=""){
				if( $leave_status == '0') $leave_dtl = $row['leave_type'] . " Applied";
				else if( $leave_status == '1') $leave_dtl = $row['leave_type'] . " Approved";
				else if( $leave_status == '2') $leave_dtl = $row['leave_type'] . " Reject";
			}
			
			if($work_time == 0){
				$net_work_time="";
				$total_break = "";
				$tBrkTime = "";
				$ldBrkTime = "";
			}else{
				
				$net_work_time=gmdate('H:i:s',$work_time);
				$total_break = gmdate('H:i:s',$total_break);
				$tBrkTime = gmdate('H:i:s',$tBrkTime);
				$ldBrkTime = gmdate('H:i:s',$ldBrkTime);
				
			}
			
			if($work_time_local==0){
				$net_work_time_local="";
				$total_break_local="";
				$tBrkTimeLocal = "";
				$ldBrkTimeLocal = "";
			
			}else{
				
				$net_work_time_local=gmdate('H:i:s',$work_time_local);
								
				$total_break_local = gmdate('H:i:s',$total_break_local);
				$tBrkTimeLocal = gmdate('H:i:s',$tBrkTimeLocal);
				$ldBrkTimeLocal = gmdate('H:i:s',$ldBrkTimeLocal);
			}
			
			
			/*
			
			if($is_logged_in == '1'){
				
				$todayLoginArray = explode(" ",$todayLoginTime_local);
				
				if($rdate == $todayLoginArray[0]){
					
					$flogin_time = $todayLoginTime;
					$flogin_time_local = $todayLoginTime_local;
					
					$disposition="online";
					
					$net_work_time="";
					$net_work_time_local="";
					
					$total_break = "";
					$total_break_local="";
					$tBrkTime = "";
					$tBrkTimeLocal = "";
					$ldBrkTime = "";
					$ldBrkTimeLocal = "";
					$logout_time="";
					$logout_time_local="";
				}
			}
			
			*/
			
					
			if($is_logged_in == '1'){
				$todayLoginArray = explode(" ",$todayLoginTime);
				$todayLoginTime_local = ConvServerToLocalAny($todayLoginTime,$office_id);
				$todayLoginArray_local = explode(" ",$todayLoginTime_local);
				
				if($rdate == $todayLoginArray[0]){
					
					$flogin_time = $todayLoginTime;
					$disposition="online";
					$net_work_time="";
					$total_break = "";
					$tBrkTime = "";
					$ldBrkTime = "";
					$logout_time="";
				}
				
				if($rdate == $todayLoginArray_local[0]){
						$flogin_time_local=$todayLoginTime_local;
						$disposition="online";
						$net_work_time_local="";
						$total_break_local="";
						$tBrkTimeLocal = "";
						$ldBrkTimeLocal = "";
						$logout_time_local="";
				}
			}

			$disposition_est =  $disposition;
			$disposition_local =  $disposition;
			
			if($logged_in_hours!="0"){
					if($row['user_disp_id']=="8"){ 
						$disposition_est =  $disposition . " &  P";
						$bg_style_est=$style_p;
					}else if($row['user_disp_id']=="7"){
						$disposition_est =  "P & ". $disposition;
						$bg_style_est=$style_ptrm;
					}else{
						$disposition_est =  "P";
						$bg_style_est=$style_p;
					}
			}else if($disposition!=""){
				
				if($disposition_est=="LI")$bg_style_est=$style_p;
				else if($disposition_est=="TERM" || $disposition_est=="X")$bg_style_est=$style_trm;
				else if($disposition_est!="Absent") $bg_style_est=$style_l;
				
			}else{
				if($rdate < $row['doj']){
					$disposition_est = ""; 
					$bg_style_est=$style_gray;
				}else $disposition_est =  "Absent"; 
			}
			
			if($leave_dtl!="") $disposition_est = $leave_dtl;
			
			
			if($logged_in_hours_local!="0"){
					if($row['user_disp_id']=="8"){ 
						$disposition_local =  $disposition . " &  P";
						$bg_style_local=$style_p;
					}else if($row['user_disp_id']=="7"){
						$disposition_local =  "P & ". $disposition;
						$bg_style_local=$style_ptrm;
					}else{
						$disposition_local =  "P";
						$bg_style_local=$style_p;
					}
			}else if($disposition!=""){
				
				if($disposition_local=="LI")$bg_style_local=$style_p;
				else if($disposition_local=="TERM" || $disposition_local=="X")$bg_style_local=$style_trm;
				else if($disposition_local!="Absent") $bg_style_local=$style_l;
				
			}else{
				if($rdate < $row['doj']){
					$disposition_local = ""; 
					$bg_style_local=$style_gray;
				}else $disposition_local =  "Absent"; 
			}
			
			if($leave_dtl!="") $disposition_local = $leave_dtl;
			
			/////////////////////////////////////////
			$SkipRole="-#82#112#221#";
			$SkipLocation="-#ELS#JAM#";
			if( strpos($SkipRole,"#".$role_id."#") != false && strpos($SkipLocation,"#".$office_id."#") !=false){
				if($disposition_local=="Absent") $disposition_local = "LI";
				if($disposition_est=="Absent") $disposition_est = "LI";
			}
			
			if($isLoginTime=="Y"){
				
				if($disposition_est!="" && $flogin_time=="") $flogin_time = $disposition_est;
				if($disposition_local!="" && $flogin_time_local=="") $flogin_time_local = $disposition_local;
				
				if($disposition_est!="" && $logout_time=="") $logout_time = $disposition_est;
				if($disposition_local!="" && $logout_time_local=="") $logout_time_local = $disposition_local;
				
			}
			
			
			
			////////// For System Logout /////////////////////
			if($row['logout_by']== "0" && $logged_in_hours!="0" ){
				
				//$net_work_time=0;
				//$net_work_time_local = 0;
				//$logout_time="";
				//$logout_time_local="";
				$isProperLogout = 'N';
				
				$comments = "System Logout";
				$bg_style_est =  $style_syslog;
			    $bg_style_local = $style_syslog;
			}
			
			
			
			if($allRowDone==false){
			
				$cell=$letters[++$j].$r;
				//echo $cell .">>";
				$this->excel->getActiveSheet()->setCellValue($cell, $cnt++);
				$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_def );
				
				$cell=$letters[++$j].$r;
				//echo $cell .">>";
				$this->excel->getActiveSheet()->setCellValue($cell, $row['fusion_id']);
				$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_def_left );
				
				$cell=$letters[++$j].$r;
				//echo $cell .">>";
				$this->excel->getActiveSheet()->setCellValue($cell, $row['omuid']);
				$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_def_left );
				
				$cell=$letters[++$j].$r;
				//echo $cell .">>";
				$fullname=$row['fname'] . " ". $row['lname'];
				$this->excel->getActiveSheet()->setCellValue($cell, $fullname);
				$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_def_left );
				
				$cell=$letters[++$j].$r;
				//echo $cell .">>";
				$this->excel->getActiveSheet()->setCellValue($cell, $row['dept_name']);
				$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_def_left );
				
				$cell=$letters[++$j].$r;
				//echo $cell .">>";
				$this->excel->getActiveSheet()->setCellValue($cell, $row['role_name']);
				$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_def_left );
								
				$doj=$row['doj'];
				if($doj=="") $doj="NA";
				$cell=$letters[++$j].$r;
				//echo $cell .">>";
				$this->excel->getActiveSheet()->setCellValue($cell, $doj);
				$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_def );
				
				$cell=$letters[++$j].$r;
				//echo $cell .">>";
				$this->excel->getActiveSheet()->setCellValue($cell, $row['office_id']);
				$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_def_left );
				
				$cell=$letters[++$j].$r;
				//echo $cell .">>";
				$this->excel->getActiveSheet()->setCellValue($cell, $row['client_name']);
				$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_def_left );
				
				$cell=$letters[++$j].$r;
				//echo $cell .">>";
				$this->excel->getActiveSheet()->setCellValue($cell, $row['process_name']);
				$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_def_left );
				
				$cell=$letters[++$j].$r;
				//echo $cell .">>";
				$this->excel->getActiveSheet()->setCellValue($cell, $row['asign_tl']);
				$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_def_left );
				
				$cell=$letters[++$j].$r;
				//echo $cell .">>";
				$this->excel->getActiveSheet()->setCellValue($cell, $this->display_user_status($row['status']));
				$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_def );
				
				$cell=$letters[++$j].$r;
				//echo $cell .">>";
				$this->excel->getActiveSheet()->setCellValue($cell, $this->display_user_phase($row['phase']));
				$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_def );
				
				if($isLoginTime=="Y"){
				
					$cell=$letters[++$j]."2";
					$this->excel->getActiveSheet()->setCellValue($cell, $row['rDate']);
					$cell=$letters[$j]."2" .":". $letters[($j+7)]."2";
					$this->excel->getActiveSheet()->mergeCells($cell);
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
										
					$cell=$letters[$j]."3";
					$this->excel->getActiveSheet()->setCellValue($cell, "IN (EST)");
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
					
					$cell=$letters[($j+1)]."3";
					$this->excel->getActiveSheet()->setCellValue($cell, "IN (Local)");
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
					
					
					$cell=$letters[($j+2)]."3";
					$this->excel->getActiveSheet()->setCellValue($cell, "OUT (EST)");
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
					
					$cell=$letters[($j+3)]."3";
					$this->excel->getActiveSheet()->setCellValue($cell, "OUT (Local)");
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
					
					$cell=$letters[($j+4)]."3";
					$this->excel->getActiveSheet()->setCellValue($cell, "Break Time (EST)");
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
					
					$cell=$letters[($j+5)]."3";
					$this->excel->getActiveSheet()->setCellValue($cell, "Break Time (Local)");
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
										
					$cell=$letters[($j+6)]."3";
					$this->excel->getActiveSheet()->setCellValue($cell, "Work Time (EST)");
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
					
					$cell=$letters[($j+7)]."3";
					$this->excel->getActiveSheet()->setCellValue($cell, "Work Time (Local)");
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
					
					$cell=$letters[$j].$r;
					$this->excel->getActiveSheet()->setCellValue($cell, $flogin_time);
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $bg_style_est);
										
					$cell=$letters[($j+1)].$r;
					$this->excel->getActiveSheet()->setCellValue($cell, $flogin_time_local);
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $bg_style_local );
					
					$cell=$letters[($j+2)].$r;
					$this->excel->getActiveSheet()->setCellValue($cell, $logout_time);
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray($bg_style_est);
					
					$cell=$letters[($j+3)].$r;
					$this->excel->getActiveSheet()->setCellValue($cell, $logout_time_local);
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray($bg_style_local);
					
					$cell=$letters[($j+4)].$r;
					$this->excel->getActiveSheet()->setCellValue($cell, $total_break);
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $bg_style_est );
					
					$cell=$letters[($j+5)].$r;
					$this->excel->getActiveSheet()->setCellValue($cell, $total_break_local);
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $bg_style_local );
					
					
					$cell=$letters[($j+6)].$r;
					$this->excel->getActiveSheet()->setCellValue($cell, $net_work_time);
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $bg_style_est );
					
					$cell=$letters[($j+7)].$r;
					$this->excel->getActiveSheet()->setCellValue($cell, $net_work_time_local);
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $bg_style_local );
					
										
				}else{
					
					$cell=$letters[++$j]."2";
					$this->excel->getActiveSheet()->setCellValue($cell, $row['rDate']);
					$cell=$letters[$j]."2" .":". $letters[($j+1)]."2";
					$this->excel->getActiveSheet()->mergeCells($cell);
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
										
					$cell=$letters[$j]."3";
					$this->excel->getActiveSheet()->setCellValue($cell, "EST");
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
					
					$cell=$letters[($j+1)]."3";
					$this->excel->getActiveSheet()->setCellValue($cell, "Local");
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
												
					
					$cell=$letters[$j].$r;
					$this->excel->getActiveSheet()->setCellValue($cell, $disposition_est);
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray($bg_style_est);
					
					$cell=$letters[$j+1].$r;
					//echo $cell ."<br>";
					$this->excel->getActiveSheet()->setCellValue($cell, $disposition_local);
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray($bg_style_local);
					
				}
				
			}else{
								
				
				if($isLoginTime=="Y"){
				
					$cell=$letters[$j]."2";
					$this->excel->getActiveSheet()->setCellValue($cell, $row['rDate']);
					$cell=$letters[$j]."2" .":". $letters[($j+7)]."2";
					$this->excel->getActiveSheet()->mergeCells($cell);
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
										
					$cell=$letters[$j]."3";
					$this->excel->getActiveSheet()->setCellValue($cell, "IN (EST)");
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
					
					$cell=$letters[($j+1)]."3";
					$this->excel->getActiveSheet()->setCellValue($cell, "IN (Local)");
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
					
					
					$cell=$letters[($j+2)]."3";
					$this->excel->getActiveSheet()->setCellValue($cell, "OUT (EST)");
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
					
					$cell=$letters[($j+3)]."3";
					$this->excel->getActiveSheet()->setCellValue($cell, "OUT (Local)");
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
					
					$cell=$letters[($j+4)]."3";
					$this->excel->getActiveSheet()->setCellValue($cell, "Break Time (EST)");
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
					
					$cell=$letters[($j+5)]."3";
					$this->excel->getActiveSheet()->setCellValue($cell, "Break Time (Local)");
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
										
					$cell=$letters[($j+6)]."3";
					$this->excel->getActiveSheet()->setCellValue($cell, "Work Time (EST)");
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
					
					$cell=$letters[($j+7)]."3";
					$this->excel->getActiveSheet()->setCellValue($cell, "Work Time (Local)");
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
					
					$cell=$letters[$j].$r;
					$this->excel->getActiveSheet()->setCellValue($cell, $flogin_time);
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $bg_style_est);
										
					$cell=$letters[($j+1)].$r;
					$this->excel->getActiveSheet()->setCellValue($cell, $flogin_time_local);
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $bg_style_local );
					
					$cell=$letters[($j+2)].$r;
					$this->excel->getActiveSheet()->setCellValue($cell, $logout_time);
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray($bg_style_est);
					
					$cell=$letters[($j+3)].$r;
					$this->excel->getActiveSheet()->setCellValue($cell, $logout_time_local);
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray($bg_style_local);
					
					$cell=$letters[($j+4)].$r;
					$this->excel->getActiveSheet()->setCellValue($cell, $total_break);
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $bg_style_est );
					
					$cell=$letters[($j+5)].$r;
					$this->excel->getActiveSheet()->setCellValue($cell, $total_break_local);
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $bg_style_local );
					
					
					$cell=$letters[($j+6)].$r;
					$this->excel->getActiveSheet()->setCellValue($cell, $net_work_time);
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $bg_style_est );
					
					$cell=$letters[($j+7)].$r;
					$this->excel->getActiveSheet()->setCellValue($cell, $net_work_time_local);
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $bg_style_local );
					
										
				}else{
					
					$cell=$letters[$j]."2";
					$this->excel->getActiveSheet()->setCellValue($cell, $row['rDate']);
					$cell=$letters[$j]."2" .":". $letters[($j+1)]."2";
					
					$this->excel->getActiveSheet()->mergeCells($cell);
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
										
					$cell=$letters[$j]."3";
					$this->excel->getActiveSheet()->setCellValue($cell, "EST");
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
					
					$cell=$letters[($j+1)]."3";
					$this->excel->getActiveSheet()->setCellValue($cell, "Local");
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
					
					$cell=$letters[$j].$r;
					$this->excel->getActiveSheet()->setCellValue($cell, $disposition_est);
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray($bg_style_est);
					
					$cell=$letters[$j+1].$r;
					//echo $cell ."<br>";
					$this->excel->getActiveSheet()->setCellValue($cell, $disposition_local);
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray($bg_style_local);
					
				}
				
			
			}
	
		}
		
		
		$cell=$letters[$j]."1";
		$this->excel->getActiveSheet()->mergeCells('A1:'.$cell);
		//set aligment to center for that merged cell (A1 to N1)
		//$this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
						
		header('Content-Type: application/vnd.ms-excel'); //mime type
		header('Content-Disposition: attachment;filename="'.$fn.'"'); //tell browser what's the file name
		header('Cache-Control: max-age=0'); //no cache
					 
		//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
		//if you want to save it as .XLSX Excel 2007 format
		
		$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5'); 
		ob_end_clean();
		//force user to download the Excel file without writing it to server's HD
		$objWriter->save('php://output');

		//$objWriter->save($filename);
	}
	
	
	public function attn_logintime()
	{
		
		if(check_logged_in())
        {
						
			//$this->check_access();
			
			$role_id= get_role_id();
			$current_user = get_user_id();
			//echo $current_user;
			//////////////////////////////////
			$user_site_id= get_user_site_id();
			//////////////////////////////////
			$ses_dept_id=get_dept_id();
			$ses_office_id=get_user_office_id();
			
			$is_global_access=get_global_access();
			
			
				//$data["aside_template"] = get_aside_template();
				$data["aside_template"] = $this->aside;
				
				$data["content_template"] = "attendance/att_logintime.php";
			    
				$data['user_list'] =array();
				
				
				$start_date="";
				$end_date="";
				$filter_key="";
				$filter_value="";
				
				$client_id="";
				$site_id="";
				$office_id="";
				$dept_id = "";
				if($dept_id=="")  $dept_id=$ses_dept_id;
				
				$sdValue="";
				
				$data['error']="";
				if($office_id=="")  $office_id=$ses_office_id;
				
				if($this->input->post('exportReports')=='Export As Excel')
				{
				
						$start_date = $this->input->post('start_date');
						$end_date = $this->input->post('end_date');
						$filter_key = $this->input->post('filter_key');
						
						$client_id = $this->input->post('client_id');
						$site_id = $this->input->post('site_id');
						
						$office_id = $this->input->post('office_id');
						if($office_id=="")  $office_id=$ses_office_id;
						
						$dept_id = $this->input->post('dept_id');
						if($dept_id=="")  $dept_id=$ses_dept_id;
					
						$sdValue = $this->input->post('sub_dept_id');
					
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
								 
						if($filter_key!="" ){
								
							switch($filter_key){
								case 'Site':
									$filter_value = $this->input->post('site_id');
									break;
								case 'Agent':
									$filter_value = $this->input->post('agent_id');
									break;
								case 'Process':
									$filter_value = $this->input->post('process_id');
									
									break;
								case 'Disposition':
									$filter_value = $this->input->post('disp_id');
									break;
								case 'Role':
									$filter_value = $this->input->post('role_id');
									break;
									
								case 'AOF':
									$filter_value = $this->input->post('assign_id');
									
								break;
						
							}							
							
							if($filter_value=="") $filter_value = $this->input->post('filter_value');
							
						}
						
						$filterArray["filter_value"]=$filter_value;	
						
					  
					  //if($role_id =='2' || $role_id=='5' || $role_id=='9') $filterArray["assigned_to"]=$current_user;
					  if(get_dept_folder()=="hr" || get_dept_folder()=="rta" || get_dept_folder()=="wfm" || get_dept_folder()=="mis") $filterArray["assigned_to"]="";	 
					  else if(get_role_dir()=="trainer" || get_role_dir()=="tl") $filterArray["assigned_to"]=$current_user;
					  else $filterArray["assigned_to"]="";	
								 
					 $fullArr = $this->reports_model->get_user_list_report($filterArray);
					
					//print_r($fullArr);
					
					if($fullArr!=null){
					
						//////////LOG////////
					
						$Lfull_name=get_username();
						$LOMid=get_user_omuid();
						
						$all_params=str_replace('%2F','/',http_build_query($filterArray));
						$LogMSG="Download Attendance & logged-in time Report with ". $all_params;
						
						log_message('FEMS', $LOMid.' - ' . $Lfull_name . ' | '.$LogMSG );
							
						//////////
			
						$this->createExcelFile($fullArr,$filterArray,'Y');
						
					}else{
						$data['error']="Not found any records";
					}
				}
								
				$data['client_list'] = $this->Common_model->get_client_list();
								
				if($is_global_access==1 || get_dept_folder()=="rta"){
					$data['site_list'] = $this->Common_model->get_sites_for_assign();
					$data['location_list'] = $this->Common_model->get_office_location_list();
				}else{
					$sCond=" Where id = '$user_site_id'";
					$data['site_list'] = $this->Common_model->get_sites_for_assign2($sCond);
					$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
				}
				
				
				$data['process_list'] = array(); // $this->Common_model->get_process_for_assign();
				
				if(get_role_dir()=="tl" || get_role_dir()=="trainer"){
					$qSql="SELECT id,name FROM role where is_active=1 and folder not in('super','admin','manager') ORDER BY name";
					$data['role_list'] = $this->Common_model->get_rolls_for_assignment2($qSql); 
				}else{
					//$data['roll_list'] = $this->Common_model->get_rolls_for_assignment();
					$qSql="SELECT id,name FROM role where is_active=1 and folder not in('super','admin') ORDER BY name";
					$data['role_list'] = $this->Common_model->get_rolls_for_assignment2($qSql);	
				}
				
				if($is_global_access==1 || get_dept_folder()=="rta"){			
						$data['assign_list'] = $this->Common_model->get_tls_for_assign2("");
				}else if(get_role_dir()=="admin"){
					$tl_cnd=" and dept_id='$ses_dept_id' ";
					$data['assign_list'] = $this->Common_model->get_tls_for_assign2($tl_cnd);
				}else{
					$tl_cnd=" and (site_id='$user_site_id' OR office_id='$ses_office_id') ";
					$data['assign_list'] = $this->Common_model->get_tls_for_assign2($tl_cnd);
				}
				
				if($is_global_access=='1' ||  get_role_dir()=="admin" || get_dept_folder()=="hr" || get_dept_folder()=="wfm" || get_dept_folder()=="rta" || get_dept_folder()=="mis" || is_all_dept_access()){
				
					$data['department_list'] = $this->Common_model->get_department_list();
					if($dept_id=="ALL" || $dept_id=="") $data['sub_department_list'] = array();
					else $data['sub_department_list'] = $this->Common_model->get_sub_department_list($dept_id);
				
				}else{
					$data['department_list'] = $this->Common_model->get_department_session($ses_dept_id);
					$data['sub_department_list'] = $this->Common_model->get_sub_department_list($ses_dept_id);
				}
								
				$data['cValue']=$client_id;
				$data['sValue']=$site_id;
				$data['oValue']=$office_id;
				$data['dept_id']=$dept_id;
				$data['sdValue']=$sdValue;
				
				$data['start_date']=$start_date;
				$data['end_date']=$end_date;
				$data['filter_key']=$filter_key;
				$data['filter_value']=$filter_value;
				$data['ses_role_id']=$role_id;
				
				$this->load->view('dashboard',$data);
				
			
			
	   }
	   
	
	}
		
	public function summary()
	{
	
		if(check_logged_in())
        {
			//$this->check_access();
			
			$role_id= get_role_id();
			$current_user = get_user_id();
			//echo $current_user;
			//////////////////////////////////
			$user_site_id= get_user_site_id();
			//////////////////////////////////
			$ses_dept_id=get_dept_id();
			$user_office_id=get_user_office_id();
			
			$is_global_access=get_global_access();
			
				//$data["aside_template"] = get_aside_template();
				$data["aside_template"] = $this->aside;
				
				$data["content_template"] = "attendance/att_summary.php";
			    
				$data['department_list'] = $this->Common_model->get_department_list();	
				
				$data['client_list'] = $this->Common_model->get_client_list();
				
				if($is_global_access==1 || get_dept_folder()=="rta"){
					$data['site_list'] = $this->Common_model->get_sites_for_assign();
					$data['location_list'] = $this->Common_model->get_office_location_list();
				}else{
					$sCond=" Where id = '$user_site_id'";
					$data['site_list'] = $this->Common_model->get_sites_for_assign2($sCond);
					$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
				}
				
				$data['process_list'] = array(); // $this->Common_model->get_process_for_assign();
				
				//$cond=" and id in(2,3,4,5,7,8)";
				$qSql="SELECT id,name FROM role where is_active=1 and folder not in('super','admin') ORDER BY name";
				$data['role_list'] = $this->Common_model->get_rolls_for_assignment2($qSql);
				
				//$data['assign_list'] = $this->Common_model->get_tls_for_assign2("");
				if($is_global_access==1 || get_dept_folder()=="rta"){			
					$data['assign_list'] = $this->Common_model->get_tls_for_assign2("");
				}else if(get_role_dir()=="admin"){
					$tl_cnd=" and dept_id='$ses_dept_id' ";
					$data['assign_list'] = $this->Common_model->get_tls_for_assign2($tl_cnd);
				}else{
					$tl_cnd=" and (site_id='$user_site_id' OR office_id='$user_office_id') ";
					$data['assign_list'] = $this->Common_model->get_tls_for_assign2($tl_cnd);
				}
			
				
				$data['user_list'] =array();
				
					
				$start_date="";
				$end_date="";
				$filter_key="";
				$filter_value="";
				
				$client_id="";
				$site_id="";
				$office_id="";
				$dept_id = "";
				
				$data['cValue']=$client_id;
				$data['sValue']=$site_id;
				$data['oValue']=$office_id;
				$data['dept_id']=$dept_id;
				
				$data['start_date']=$start_date;
				$data['end_date']=$end_date;
				$data['filter_key']=$filter_key;
				$data['filter_value']=$filter_value;
				$data['ses_role_id']=$role_id;
				
				$this->load->view('dashboard',$data);
								
			
	   }
	   	
	}
	
	
	public function createAttnSummary()
	{
	
		$role_id= get_role_id();
		$current_user = get_user_id();
		$ses_dept_id=get_dept_id();
		
		//echo " xxxxx :: ". $current_user;
		//////////////////////////////////
		$user_site_id= get_user_site_id();
		//////////////////////////////////
		$user_office_id=get_user_office_id();
		
		$is_global_access=get_global_access();
		
		
		if($this->is_access_reports($role_id)){

			$start_date = $this->input->post('start_date');
			$end_date = $this->input->post('end_date');
			
			$client_id = $this->input->post('client_id');
			$site_id = $this->input->post('site_id');
			
			$office_id = $this->input->post('office_id');
			if($office_id=="")  $office_id=$user_office_id;
			
			//$dept_id = $this->input->post('dept_id');
			//if($dept_id=="")  $dept_id=$ses_dept_id;
					
			$filter_key = $this->input->post('filter_key');
			$filter_value="";
			
			$filterArray = array(
						"start_date" => $start_date,
						"end_date" => $end_date,
						"client_id" => $client_id,
						"office_id" => $office_id,
						"site_id" => $site_id,
						"filter_key" => $filter_key,
						"user_site_id"=> $user_site_id,
				 ); 
					 
			if($filter_key!="" ){
					
				switch($filter_key){
					case 'Site':
						$filter_value = $this->input->post('site_id');
						break;
					case 'Agent':
						$filter_value = $this->input->post('agent_id');
						break;
					case 'Process':
						$filter_value = $this->input->post('process_id');
						
						break;
					case 'Role':
						$filter_value = $this->input->post('role_id');
						break;	
					case 'AOF':
						$filter_value = $this->input->post('assign_id');
						break;	
				}
								
				if($filter_value=="") $filter_value = $this->input->post('filter_value');
						
			}
			
			$filterArray["filter_value"]=$filter_value;	
			
			//print_r($filterArray);
			
			if($filter_key!="" && $filter_value==""){
				echo "ERROR";
			}else{
			
				//if($role_id =='2' || $role_id=='5' || $role_id=='9') $filterArray["assigned_to"]=$current_user;
				if(get_dept_folder()=="hr" || get_dept_folder()=="rta" || get_dept_folder()=="wfm" || get_dept_folder()=="mis") $filterArray["assigned_to"]="";	 
				else if(get_role_dir()=="trainer" || get_role_dir()=="tl") $filterArray["assigned_to"]=$current_user;
				else $filterArray["assigned_to"]="";
		
				//print_r($filterArray);
							
				$file_path=$this->createExcelSummary($filterArray);
								
				//echo $file_path;
				
				if($file_path !="ERROR"){
					//////////LOG////////
			
					$Lfull_name=get_username();
					$LOMid=get_user_omuid();
				
					$all_params=str_replace('%2F','/',http_build_query($filterArray));
					$LogMSG="Download Attendance Summary Report with ". $all_params;	
					log_message('FEMS', $LOMid.' - ' . $Lfull_name . ' | '.$LogMSG );
					//////////
					
					echo $file_path;
					
				}else{
					echo "ERROR";
				}
			}
		}else{
				echo "SESSIONOUT";
		}
		
	}
	
	
	
	public function sendMonthlyAttnSummary()
	{
								
				$cDateYmd=CurrDate();
				$start_date=date('m-01-Y', strtotime($cDateYmd));
				//$end_date =date("m-d-Y",time());
				$end_date=date('m-d-Y',strtotime($cDateYmd.' -1 day'));	
				
				//echo $start_date . " >> ".$end_date ."<br>";
				/*
					$filterArray = array(
						"start_date" => $start_date,
						"end_date" => $end_date,
						"client_id" => $client_id,
						"office_id" => $office_id,
						"site_id" => $site_id,
						"filter_key" => $filter_key,
						"user_site_id"=> $user_site_id,
				 ); 
				 
				*/
				
				$filterArray = array(
						"start_date" => $start_date,
						"end_date" => $end_date,
						"client_id" => '1',
						"filter_key" => "",
						"assigned_to" => "",
						"user_site_id" => "",
						"filter_value" => "",
				 ); 
				 
				$file_month=strtolower(date('F-Y', strtotime($cDateYmd)));
				$file_name=$this->createExcelSummary($filterArray,'Y');
				
				//echo "\r\n". $file_name ."\r\n";
				
				if($file_name!="ERROR"){
				
					$file_path =FCPATH."temp_files/summary/".$file_name;
					
					//echo $file_path;
					
					$uid="";
					$eto="arif.anam@fusionbposervices.com, saikat.ray@fusionbposervices.com,kunal.bose@fusionbposervices.com, rabi.dhar@fusionbposervices.com";
					
					$from_email="noreply.sox@fusionbposervices.com";
					$from_name="Fusion SOX";
					
					$ecc="";
					$ebody="Hi<br>Please check the attachment files.";
					$esubject="Test Email to Auto Send Attendance Summary Report.";
					
					$email_resp=false;
					
					// $email_resp=$this->Common_model->send_email_sox($uid,$eto,$ecc,$ebody,$esubject,$file_path,$from_email,$from_name);
					
					if($email_resp==true){
						unlink($file_path);
						
						//$LogMSG="successfully Sent Attendance Summary Report of ".$file_month;	
						//log_message('FEMS', ' | '.$LogMSG );
						
					}else{
					
						$uid="";
						$eto="arif.anam@fusionbposervices.com, saikat.ray@fusionbposervices.com,kunal.bose@fusionbposervices.com, rabi.dhar@fusionbposervices.com";
						$ecc="";
						$ebody="Hi<br>Failure to send Attendance Summary Report.";
						$esubject="Failure to Send Attendance Summary Report.";
						
						// $email_resp=$this->Common_model->send_email_sox($uid,$eto,$ecc,$ebody,$esubject);
					
						//$LogMSG="successfully Sent Attendance Summary Report of ".$file_month;	
						//log_message('FEMS', ' | '.$LogMSG );
					}
					
				}else{
										
					//$LogMSG="Error To Sent Attendance Summary Report of ".$file_month;	
					//log_message('FEMS', ' | '.$LogMSG );
					
					$uid="";
					$eto="arif.anam@fusionbposervices.com, saikat.ray@fusionbposervices.com,kunal.bose@fusionbposervices.com, rabi.dhar@fusionbposervices.com";
					$ecc="";
					$ebody="Hi<br>Failure to Export Attendance Summary Report.";
					$esubject="Failure to Export Attendance Summary Report.";
					// $email_resp=$this->Common_model->send_email_sox($uid,$eto,$ecc,$ebody,$esubject);
					
				}
	}
	
	
	public function createExcelSummary($filterArr,$is_monthly='N')
	{
	
		try {
			$start_date =$filterArr['start_date'];
			$end_date =$filterArr['end_date'];
			//echo " >>>> " . $start_date . ">" . $end_date ."\r\n";			
			$filter_key="";
			$assigned_to="";
			$user_site_id="";
			$client_id="";
			
			if($is_monthly!="Y"){
						
				$filter_key =$filterArr['filter_key'];
				$assigned_to=$filterArr['assigned_to'];
				$user_site_id =$filterArr['user_site_id'];
				
			}
			
			$client_id=$filterArr['client_id'];
			
			//echo "<br>1." . $start_date . " > " .$end_date . " > ". $filter_key . " > ". $assigned_to ."<br>";

			$filter_value="";
			$_cnd="";
			$_atitle="";
			$site_cond="";
			
			if($filter_key!=""){
			
				$filter_value =$filterArr['filter_value'];
				
				switch($filter_key){
					case 'Site':
						$_cnd = " and site_id = '".$filter_value."'";
						$site_cond = " and id = '".$filter_value."'";
						
						$qSql="Select name as value from  site where id='$filter_value'";
						$_atitle = " - All Agents in ".$this->Common_model->get_single_value($qSql);
					
						break;
					case 'Agent':
						$_cnd = " and  (omuid = '".$filter_value."' OR fusion_id='".$filter_value."') ";
						$_atitle = " - Agent-'".$filter_value."'";
						
						break;
					case 'Process':
						if($filter_value !="0") $_cnd = " and 	process_id = '".$filter_value."'";
						
						$qSql="Select name as value from  process where id='$filter_value'";
						$_atitle = " - ".$this->Common_model->get_single_value($qSql);
					
						break;
						
					/*
					case 'Role':
						$_cnd = " and 	role_id = '".$filter_value."'";
						
						$qSql="Select name as value from  role where id='$filter_value'";
						$_atitle = " - ".$this->Common_model->get_single_value($qSql);
						break;	
					*/
					
					case 'AOF':
						$_cnd = " and assigned_to = '".$filter_value."'";
						$qSql="Select CONCAT(fname,' ' ,lname) as value from  signin where id='$filter_value'";
						$_atitle = " - All Agents of ".$this->Common_model->get_single_value($qSql);
						break;	
				}	
			}
			
			$client_name="";
			if($client_id!=="" && $client_id!="ALL"){
				$_cnd .= " and client_id = '".$client_id."'";
				$client_name="-".$this->Common_model->get_single_value("Select shname as value from  client where id='$client_id'");
				
			}
						
			$_roleCnd="";
			
			if($filter_key=="Role") $_roleCnd = " and role_id = '".$filter_value."'";
			else $_roleCnd = " and role_id = '3'";
			
			if($is_monthly!="Y"){
				if(get_role_id()>1 && get_role_id()!=6){
					if($user_site_id!="" && $user_site_id!="0" && $user_site_id!="ALL" ) $_cnd .= " and site_id = '".$user_site_id."'";
				}
			}
			
			if($assigned_to!="" && $assigned_to!="ALL" ) $_cnd .= " and assigned_to = '".$assigned_to."'";
			
			//////////////////////
			
			//echo $_cnd ."<br>" .$_roleCnd ."<br>";
			
			$stDate=mmddyy2mysql($start_date);
			$enDate=mmddyy2mysql($end_date);
			
			if($is_monthly!="Y") $fn="absenteeism_summary".$client_name.'-'.$stDate."-".$enDate.$_atitle.".xlsx";
			else{
				$file_name="absenteeism_summary".$client_name.'_'.strtolower(date('F', strtotime($stDate)));
				$fn=$file_name."_".$stDate."_".$enDate.".xlsx";
			}
			
			//echo $fn ."<br>";

			//$filename =APPPATH."temp_files/summary/".$fn;
			$filename =FCPATH."temp_files/summary/".$fn;
			//echo $filename;
			 
			
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
			
			$style_trm = array(
			'borders' => array(
				'bottom' => $default_border,
				'left' => $default_border,
				'top' => $default_border,
				'right' => $default_border,
			),
			'fill' => array(
				'type' => PHPExcel_Style_Fill::FILL_SOLID,
				'color' => array('rgb'=>'FF0000'),
			),
			'font' => array(
				'size' => 10,
			),
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
				'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
			)
		);
		
			
		
		$style_syslog = array(
			'borders' => array(
				'bottom' => $default_border,
				'left' => $default_border,
				'top' => $default_border,
				'right' => $default_border,
			),
			'fill' => array(
				'type' => PHPExcel_Style_Fill::FILL_SOLID,
				'color' => array('rgb'=>'FFBCB2'),
			),
			'font' => array(
				'size' => 10,
			),
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
				'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
			)
		);
				
		$style_ptrm = array(
			'borders' => array(
				'bottom' => $default_border,
				'left' => $default_border,
				'top' => $default_border,
				'right' => $default_border,
			),
			'fill' => array(
				'type' => PHPExcel_Style_Fill::FILL_SOLID,
				'color' => array('rgb'=>'FFB3B2'),
			),
			'font' => array(
				'size' => 10,
			),
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
				'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
			)
		);
		
		$style_gray = array(
			'borders' => array(
				'bottom' => $default_border,
				'left' => $default_border,
				'top' => $default_border,
				'right' => $default_border,
			),
			'fill' => array(
				'type' => PHPExcel_Style_Fill::FILL_SOLID,
				'color' => array('rgb'=>'808080'),
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
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
					'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
				)
			);
				
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
		
		$todayDate=CurrDate();
		
		$stDate=mmddyy2mysql($start_date);
		$enDate=mmddyy2mysql($end_date);
		
		//echo "<br>2. ".$stDate . ">" . $enDate ."\r\n";
		
		$dayDiff=dateDiffCount($stDate,$enDate);
				
		//$qSql="SELECT * FROM site where is_active=1 $site_cond order by name";
		
		if($_cnd=="" ) $qSql="SELECT * FROM site where is_active=1 order by name";
		else $qSql="SELECT * FROM site where id in (SELECT DISTINCT site_id from signin where status=1 $_cnd) order by name";
					
		$site_list=$this->Common_model->get_query_result_array($qSql);
		
		$shCnt=0;
		
		foreach($site_list as $sRow){
			
			$site_id=$sRow['id'];	
			$site_name=$sRow['name'];		
				
			//$qSql="SELECT * FROM process  where is_active=1 order by name";
			
			$qSql="SELECT * from process where id in (SELECT DISTINCT process_id FROM `signin` where site_id='$site_id') order by name";			
			$process_list=$this->Common_model->get_query_result_array($qSql);
			
			//$count_arr = array();
			//$att_arr = array();
						
			foreach($process_list as $row){
				
			//	$pro_arr = array();
				
				$process_id=$row['id'];	
				$process_name=$row['name'];								
				
				//echo $process_name. " (". $process_id .")\r\n";
				//////////
				
				$sht_title=$site_name . " - " .$process_name;
				
				if($filter_key=="Site") $title=$process_name."".$_atitle;
				else $title=$site_name." - ".$process_name ."".$_atitle;
												
				if($shCnt > 0) $this->excel->createSheet();
				$this->excel->setActiveSheetIndex($shCnt);
				
				//echo $shCnt;
				
				//activate worksheet number 1
				
				//name the worksheet
				$this->excel->getActiveSheet()->setTitle($sht_title);
				//set cell A1 content with some text
			
				$this->excel->getActiveSheet()->setCellValue('A1', $title);
			
				//change the font size
				$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(14);
				//make the font become bold
				$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
				//merge cell A1 until D1
				$this->excel->getActiveSheet()->mergeCells('A1:E1');
				
				$this->excel->getActiveSheet()->setCellValue('A2', 'Date');
				$this->excel->getActiveSheet()->getStyle('A2')->applyFromArray($style_header);
				$this->excel->getActiveSheet()->setCellValue('B2', 'Schdld Agents');
				$this->excel->getActiveSheet()->getStyle('B2')->applyFromArray($style_header);
				$this->excel->getActiveSheet()->setCellValue('C2', 'Present');
				$this->excel->getActiveSheet()->getStyle('C2')->applyFromArray($style_header);
				$this->excel->getActiveSheet()->setCellValue('D2', 'Absent');
				$this->excel->getActiveSheet()->getStyle('D2')->applyFromArray($style_header);
				$this->excel->getActiveSheet()->setCellValue('E2', 'Absenteeism%');
				$this->excel->getActiveSheet()->getStyle('E2')->applyFromArray($style_header);
				
				////////////////////////////
				
				$stTime=strtotime($stDate);
				
				$currDate= date('Y-m-d', $stTime);
				
				//echo "<br>3. ".$dayDiff." >> ".$stTime . ">" . $currDate ."\r\n";
								
				$r=3;
				
				$sch_total=0;
				$prsnt_total=0;
				$abs_total=0;
				
				for ($i = 1; $i <= $dayDiff; $i++){
					
					$j=-1;
					
				//	$arr = array();
					
					$currDate= date('Y-m-d', $stTime);
					
					if($currDate>=$todayDate) break;
					
					//echo $currDate  ." == " . $enDate . "\r\n";
					$stTime = strtotime($currDate .' +1 day');
					$currDay=strtolower(date('D', strtotime($currDate)));
					
					$fielsIn=$currDay."_in";
					$fielsOut=$currDay."_out";
					
					if(date('D', strtotime($currDate)) == "Mon") $shMonDate=$currDate;
					else $shMonDate=date('Y-m-d',strtotime($currDate.' -1 Monday'));
					if(date('D', strtotime($currDate)) == "Sun") $shSunDate=$currDate;
					else $shSunDate=date('Y-m-d',strtotime($currDate.' +1 Sunday'));
					
					
					$prv_term_cond=" (Select user_id from terminate_users where cast(terms_date as date)<'$currDate'  OR rejon_date>='$currDate'  ) and is_term_complete = 'Y' ";
					
					//Schedule
					//$qSql="Select count(a.id) as value from user_shift_schedule a, signin b where start_date='$shMonDate' and end_date='$shSunDate' and a.user_id=b.id and status=1 and process_id='$process_id' and $fielsIn not in ('OFF','RO','LOA','PL') and $fielsOut not in ('OFF','RO','LOA','PL') ";
					
					$qSql="Select count(a.id) as value from user_shift_schedule a, signin b where start_date='$shMonDate' and end_date='$shSunDate' and a.user_id=b.id and user_id not in $prv_term_cond and process_id='$process_id' and site_id='$site_id' and TIME($fielsIn)>0 and TIME($fielsOut)>0 $_roleCnd $_cnd";
					
					//echo $qSql ."\r\n";
					
					$sch_count=$this->Common_model->get_single_value($qSql);
					
										
					//$qSql="Select count(a.id) as value from logged_in_details a, signin b where cast(login_time as date) = '$currDate' and cast(logout_time as date) >= '$currDate' and a.user_id=b.id and status=1 and process_id='$process_id' and role_id >1";
					
					//$qSql="Select count(user_id) as value from (select distinct user_id from logged_in_details where cast(login_time as date) = '$currDate' and cast(logout_time as date) >= '$currDate') a, signin b where a.user_id=b.id and status=1 and process_id='$process_id' and site_id='$site_id' $_roleCnd $_cnd";
					
					$qSql="Select count(user_id) as value from (select distinct user_id from logged_in_details where cast(login_time as date) = '$currDate' and cast(logout_time as date) >= '$currDate') a, signin b where a.user_id=b.id and user_id not in $prv_term_cond and process_id='$process_id' and site_id='$site_id' $_roleCnd $_cnd";
										
					//echo $qSql ."\r\n";
					
					$prsnt_count=$this->Common_model->get_single_value($qSql);
					
					//$qSql="Select count(user_id) as value from (select distinct user_id from event_disposition where start_date <= '$currDate' and end_date >= '$currDate' and event_master_id in (6)) a, signin b where a.user_id=b.id and status=1 and process_id='$process_id'  and site_id='$site_id' $_roleCnd $_cnd";
					
					$qSql="Select count(user_id) as value from (select distinct user_id from event_disposition where start_date <= '$currDate' and end_date >= '$currDate' and event_master_id in (6)) a, signin b where a.user_id=b.id and user_id not in $prv_term_cond  and process_id='$process_id'  and site_id='$site_id' $_roleCnd $_cnd";
					
					$li_count=$this->Common_model->get_single_value($qSql);
					$prsnt_count= $prsnt_count+$li_count;
					
					
					
					//$qSql="Select count(user_id) as value from (select distinct user_id from event_disposition where start_date <='$currDate' and end_date >='$currDate' and event_master_id in (2,3)) a, signin b where a.user_id=b.id and status=1 and process_id='$process_id' and site_id='$site_id' and user_id not in (Select distinct user_id from logged_in_details where (cast(login_time as date) = '".$currDate."' and cast(login_time as date) >= '".$currDate."')) $_roleCnd $_cnd";
					
					$qSql="Select count(user_id) as value from (select distinct user_id from event_disposition where start_date <='$currDate' and end_date >='$currDate' and event_master_id in (2,3)) a, signin b where a.user_id=b.id and user_id not in $prv_term_cond and process_id='$process_id' and site_id='$site_id' and user_id not in (Select distinct user_id from logged_in_details where (cast(login_time as date) = '".$currDate."' and cast(login_time as date) >= '".$currDate."')) $_roleCnd $_cnd";
					
					//echo $qSql ."\r\n";
					
					$abs_count=$this->Common_model->get_single_value($qSql);
					
					if($sch_count==0)$abs_per=0;
					else $abs_per=($abs_count/$sch_count);
					
					//echo "Schdld Agents : ".$sch_count ."\r\n";
					//echo "Present Agents : ".$prsnt_count ."\r\n";
					//echo "Absent Agents : ".$abs_count ."\r\n";
					//echo "Absenteeism% : ".$abs_per ."%\r\n\r\n";
					
					//$arr["rDate"] = $currDate;
					//$arr["sch_count"] = $sch_count;
					//$arr["prsnt_count"] = $prsnt_count;
					//$arr["abs_count"] = $abs_count;
					//$arr["abs_per"] = $abs_per;
					//$pro_arr[] = $arr;
					
					////////
					
						$sch_total +=$sch_count;
						$prsnt_total +=$prsnt_count;
						$abs_total +=$abs_count;
				
						
						$cell=$letters[++$j].$r;
						//echo $cell .">>";
						$this->excel->getActiveSheet()->setCellValue($cell, $currDate);
						$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_def );
						
						$cell=$letters[++$j].$r;
						
						$this->excel->getActiveSheet()->setCellValue($cell, $sch_count);
						$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_def );
						
						$cell=$letters[++$j].$r;
						//echo $cell .">>";
						
						$this->excel->getActiveSheet()->setCellValue($cell, $prsnt_count);
						$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_def );
						
						$cell=$letters[++$j].$r;
						//echo $cell .">>";
						
						$this->excel->getActiveSheet()->setCellValue($cell, $abs_count);
						$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_def );
						
						$cell=$letters[++$j].$r;
						//echo $cell .">>";
						
						$this->excel->getActiveSheet()->setCellValue($cell, $abs_per);
						$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_def );
						$this->excel->getActiveSheet()->getStyle($cell)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_PERCENTAGE_00);
						
						$r++;
					
					////////
					
					} //i date

						
						$abs_per_total=0;
						if($sch_total==0)$abs_per_total=0;
						else $abs_per_total=($abs_total/$sch_total);
					
						$j=-1;
						$cell=$letters[++$j].$r;
						//echo $cell .">>";
						$this->excel->getActiveSheet()->setCellValue($cell, "MTD");
						$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_sum );
						
						$cell=$letters[++$j].$r;
						
						$this->excel->getActiveSheet()->setCellValue($cell, $sch_total);
						$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_sum );
						
						$cell=$letters[++$j].$r;
						//echo $cell .">>";
						
						$this->excel->getActiveSheet()->setCellValue($cell, $prsnt_total);
						$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_sum );
						
						$cell=$letters[++$j].$r;
						//echo $cell .">>";
						
						$this->excel->getActiveSheet()->setCellValue($cell, $abs_total);
						$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_sum );
						
						$cell=$letters[++$j].$r;
						//echo $cell .">>";
						
						$this->excel->getActiveSheet()->setCellValue($cell, $abs_per_total);
						$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_sum );
						$this->excel->getActiveSheet()->getStyle($cell)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_PERCENTAGE_00);
						
						$r++;
						
					
					//$count_arr[$process_name] = $pro_arr;
					$_cond= " and process_id='$process_id' and site_id='$site_id' $_roleCnd ";
					//echo $_cond ." \r\n";
					
					$all_att=array();
					
					//$att_arr[$process_name] = $this->reports_model->get_user_list_report($filterArr, $_cond);
					$all_att= $this->reports_model->get_user_list_report($filterArr, $_cond,'Y');
					
					//print_r($all_att);
					
					//////////// ATT////
						
						$r++;
						
						//$cell=$letters[++$j].$r;
						//$this->excel->getActiveSheet()->setCellValue($cell, $cnt++);
									
						$this->excel->getActiveSheet()->setCellValue('A'.$r, 'SLNo');
						$cell='A'.$r.":".'A'.($r+1);
						$this->excel->getActiveSheet()->mergeCells($cell);
						$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
						
						$this->excel->getActiveSheet()->setCellValue('B'.$r, 'OM ID/XPOID');
						$cell='B'.$r.":".'B'.($r+1);
						$this->excel->getActiveSheet()->mergeCells($cell);
						$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
											
						$this->excel->getActiveSheet()->setCellValue('C'.$r, 'NAME');
						$cell='C'.$r.":".'C'.($r+1);
						$this->excel->getActiveSheet()->mergeCells($cell);
						$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
						
						$this->excel->getActiveSheet()->setCellValue('D'.$r, 'Role');
						$cell='D'.$r.":".'D'.($r+1);
						$this->excel->getActiveSheet()->mergeCells($cell);
						$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
						
						$this->excel->getActiveSheet()->setCellValue('E'.$r, 'DOJ');
						$cell='E'.$r.":".'E'.($r+1);
						$this->excel->getActiveSheet()->mergeCells($cell);
						$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
						
						/*
						$this->excel->getActiveSheet()->setCellValue('F'.$r, 'Site');
						$cell='F'.$r.":".'F'.($r+1);
						$this->excel->getActiveSheet()->mergeCells($cell);
						$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
											
						$this->excel->getActiveSheet()->setCellValue('G'.$r, 'Process');
						$cell='G'.$r.":".'G'.($r+1);
						$this->excel->getActiveSheet()->mergeCells($cell);
						$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
						*/
						
						$r++;
						$stR=$r;
						
						$j=-1;
						$k=0;
												
						$allRowDone=false;
						$isFirst=true;
						
						$pevDate="";
						
						$cnt=1;
						
						$has_data=false;
						
							foreach($all_att as $row)
							{
								$has_data=true;
								$rdate=$row['rDate'];
								
								if($isFirst==false && $rdate!=$pevDate) $allRowDone=true;
								
								if($rdate!=$pevDate){
									$r=$stR;
									$j+=2;
								}
								
								$r++;
								
								
								$isFirst=false;
								
								if($allRowDone==false){
									$j=-1;
								}
															
								$pevDate=$rdate;
								
								$doj=$row['doj'];
								if($doj=="") $doj="NA";
									
								$disposition=$row['disposition'];
								$logged_in_hours = $row['logged_in_hours'];
								$bg_style=$style_def;
								
								$att="";
								if($logged_in_hours!="0"){
									$att = 'P'; 
									if($disposition=="TERM"){
										$att .=" & TERM";
										$bg_style=$style_ptrm;
									}else $bg_style=$style_p;
									
								}else if($disposition!=""){
									$att = $disposition;
									if($att=="LI")$bg_style=$style_p;
									else if($att=="TERM" || $att=="X")$bg_style=$style_trm;
									else if($att!="Absent") $bg_style=$style_l;
									
								}else{
									////else if($att=="-")$bg_style=$style_p;
									if($row['rDate']<$row['doj']){
										$bg_style=$style_gray;
										$att = ''; 
									}else $att = 'Absent'; 
								}
								
								
								$ac_sch="-";
								$sch_in=trim($row['sch_in']);
								$sch_out=trim($row['sch_out']);
								
								if($sch_in =="") $ac_sch="-";
								else if (($timestamp = strtotime($sch_in)) !== false) $ac_sch=$sch_in ." - ".$sch_out;
								else $ac_sch=$sch_in;
								
								if($allRowDone==false){
								
									$cell=$letters[++$j].$r;
									
									$this->excel->getActiveSheet()->setCellValue($cell, $cnt++);
									$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_def );
									
									$cell=$letters[++$j].$r;
									//echo $cell .">>";
									$this->excel->getActiveSheet()->setCellValue($cell, $row['omuid']);
									$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_def_left );
									
									$cell=$letters[++$j].$r;
									//echo $cell .">>";
									$fullname=$row['fname'] . " ". $row['lname'];
									$this->excel->getActiveSheet()->setCellValue($cell, $fullname);
									$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_def_left );
									
									$cell=$letters[++$j].$r;
									//echo $cell .">>";
									$this->excel->getActiveSheet()->setCellValue($cell, $row['role_name']);
									$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_def_left );
										
									
									$cell=$letters[++$j].$r;
									//echo $cell .">>";
									$this->excel->getActiveSheet()->setCellValue($cell, $doj);
									$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_def );
									
									/*
									$cell=$letters[++$j].$r;
									$this->excel->getActiveSheet()->setCellValue($cell, $row['site_name']);
									$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_def_left );
																	
									$cell=$letters[++$j].$r;
									$this->excel->getActiveSheet()->setCellValue($cell, $row['process_name']);
									$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_def_left );
									*/
									
									$cell=$letters[++$j].($stR-1);
									$this->excel->getActiveSheet()->setCellValue($cell, $row['rDate']);
									$cell=$letters[$j].($stR-1) .":". $letters[($j+1)].($stR-1);
									$this->excel->getActiveSheet()->mergeCells($cell);
									$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
									
									$cell=$letters[$j].($stR);
									$this->excel->getActiveSheet()->setCellValue($cell, "Schedule");
									$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
									
									$cell=$letters[$j+1].($stR);
									$this->excel->getActiveSheet()->setCellValue($cell, "Status");
									$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
									
									
									$cell=$letters[$j].$r;
									$this->excel->getActiveSheet()->setCellValue($cell, $ac_sch);
									$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $bg_style );
									
									$cell=$letters[($j+1)].$r;
									//echo $cell ." >> ";
									$this->excel->getActiveSheet()->setCellValue($cell, $att);
									$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $bg_style );
									
								}else{
																
									$cell=$letters[$j].($stR-1);
									$this->excel->getActiveSheet()->setCellValue($cell, $row['rDate']);
									$cell=$letters[$j].($stR-1) .":". $letters[($j+1)].($stR-1);						
									$this->excel->getActiveSheet()->mergeCells($cell);
									$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
									
									$cell=$letters[$j].($stR);
									$this->excel->getActiveSheet()->setCellValue($cell, "Schedule");
									$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
									
									$cell=$letters[$j+1].($stR);
									$this->excel->getActiveSheet()->setCellValue($cell, "Status");
									$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
																	
									$cell=$letters[$j].$r;
									//echo $cell ." - ";								
									$this->excel->getActiveSheet()->setCellValue($cell, $ac_sch);
									$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $bg_style );
									
									$cell=$letters[($j+1)].$r;
									//echo $cell." >> ";
									$this->excel->getActiveSheet()->setCellValue($cell, $att);
									$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $bg_style );
									
								}
						
							}
							
							if($has_data==false){
								$this->excel->removeSheetByIndex($shCnt);
								if($shCnt==0) $this->excel->createSheet();
							}else{
								$shCnt++;
							}
							
						//////////////////ATT//
					
					
					
					
										
				} // process
				
			} // site
			
			
			//echo "<br>\r\n\r\n <br>";
											
			//	header('Content-Type: application/vnd.ms-excel'); //mime type
			//	header('Content-Disposition: attachment;filename="'.$fn.'"'); //tell browser what's the file name
			//	header('Cache-Control: max-age=0'); //no cache
						 
			//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
			//if you want to save it as .XLSX Excel 2007 format
			
			//$objWriter = new PHPExcel_Writer_Excel5($this->excel);
			$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel2007');
			$objWriter->save($filename);
			
			//ob_end_clean();
			//force user to download the Excel file without writing it to server's HD
			//$objWriter->save('php://output');
			
			return $fn;
			
		}catch (Exception $e){
			//echo 'Caught exception: ',  $e->getMessage(), "<br/><br/>";
			return "ERROR";
			
		}
	
	}
	
	
	public function downloadFile()
	{		
		$this->load->helper('download');
		
		$fn = $this->input->get('fn');
		$filename =FCPATH."temp_files/summary/".$fn;
		$data = file_get_contents($filename); 
		force_download($fn, $data); 
		
	}

	private function is_access_reports($_role_id)
	{
		//if(get_role_dir()=="agent" ) return false;
		//else return true;
		
		return true;
		
	}
	
	private function check_access()
	{
		$is_global_access=get_global_access();
		if(get_role_dir()=="agent" && $is_global_access!=1 ) redirect(base_url()."home","refresh");
	}
	
	
	
	
	/*================================ ATTENDANCE ROASTER ===============================================================================*/
	
	
	public function attn_roaster()
    {
	
		if(check_logged_in())
        {
			//$this->check_access();
			
			$role_id= get_role_id();
			$current_user = get_user_id();
			//echo $current_user;
			//////////////////////////////////
			$user_site_id= get_user_site_id();
			$ses_dept_id=get_dept_id();
			$ses_office_id=get_user_office_id();
			
			$is_global_access=get_global_access();
			
			//////////////////////////////////
						
				//$data["aside_template"] = get_aside_template();
				$data["aside_template"] = $this->aside;
				
				$data["content_template"] = "attendance/att_main.php";
			    
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
				$data['error']="";
					
				
				if($office_id=="")  $office_id=$ses_office_id;
				
				if($this->input->post('exportReports')=='Export As Excel')
				{
				
						$start_date = $this->input->post('start_date');
						$end_date = $this->input->post('end_date');
						$filter_key = $this->input->post('filter_key');
						
						$client_id = $this->input->post('client_id');
						$site_id = $this->input->post('site_id');
						
						$office_id = $this->input->post('office_id');
						if($office_id=="")  $office_id=$ses_office_id;
						
						$dept_id = $this->input->post('dept_id');
						if($dept_id=="")  $dept_id=$ses_dept_id;
						
						$sdValue = $this->input->post('sub_dept_id');
											
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
								 
						if($filter_key!="" ){
								
							switch($filter_key){
								case 'Site':
									$filter_value = $this->input->post('site_id');
									break;
								case 'Agent':
									$filter_value = $this->input->post('agent_id');
									break;
								case 'Process':
									$filter_value = $this->input->post('process_id');
									
									break;
								case 'Disposition':
									$filter_value = $this->input->post('disp_id');
									break;
								case 'Role':
									$filter_value = $this->input->post('role_id');
									break;
									
								case 'AOF':
									$filter_value = $this->input->post('assign_id');
									
								break;
						
							}
							if($filter_value=="") $filter_value = $this->input->post('filter_value');
						}
						
						$filterArray["filter_value"]=$filter_value;
						
					  
					  
					  //if($role_id =='2' || $role_id=='5' || $role_id=='9') $filterArray["assigned_to"]=$current_user;	
					  if(get_dept_folder()=="hr" || get_dept_folder()=="rta" || get_dept_folder()=="wfm" || get_dept_folder()=="mis") $filterArray["assigned_to"]="";	 
					  else if(get_role_dir()=="trainer" || get_role_dir()=="tl") $filterArray["assigned_to"] = $current_user;
					  else $filterArray["assigned_to"]="";	
								 
					 $fullArr = $this->reports_model->get_user_list_report($filterArray, "", "Y","N");
					
					//print_r($fullArr);
					
					if($fullArr!=null){
					
						//////////LOG////////
					
						$Lfull_name=get_username();
						$LOMid=get_user_omuid();
						
						$all_params=str_replace('%2F','/',http_build_query($filterArray));
						$LogMSG="Download Attendance Report with ". $all_params;
						
						log_message('FEMS', $LOMid.' - ' . $Lfull_name . ' | '.$LogMSG );
							
						//////////
						//echo "<pre>" .print_r($fullArr,true) ."<pre>"; die();
						
						$this->createExcelFileRoaster($fullArr,$filterArray);
					
					}else{
						$data['error']="Not found any records";
					}
					
				}
				
				
				$data['client_list'] = $this->Common_model->get_client_list();			

				
				if($is_global_access==1 || get_dept_folder()=="rta"){
					$data['site_list'] = $this->Common_model->get_sites_for_assign();
					$data['location_list'] = $this->Common_model->get_office_location_list();
				}else{
					$sCond=" Where id = '$user_site_id'";
					$data['site_list'] = $this->Common_model->get_sites_for_assign2($sCond);
					$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
				}
				
				
				$data['process_list'] = array(); // $this->Common_model->get_process_for_assign();
				
				if(get_role_dir()=="tl" || get_role_dir()=="trainer"){
					$qSql="SELECT id,name FROM role where is_active=1 and folder not in('super','admin','manager') ORDER BY name";
					$data['role_list'] = $this->Common_model->get_rolls_for_assignment2($qSql); 
				}else{
					//$data['roll_list'] = $this->Common_model->get_rolls_for_assignment();
					$qSql="SELECT id,name FROM role where is_active=1 and folder not in('super','admin') ORDER BY name";
					$data['role_list'] = $this->Common_model->get_rolls_for_assignment2($qSql);	
				}
				
				if($is_global_access==1 || get_dept_folder()=="rta"){			
						$data['assign_list'] = $this->Common_model->get_tls_for_assign2("");
				}else if(get_role_dir()=="admin"){
					$tl_cnd=" and dept_id='$ses_dept_id' ";
					$data['assign_list'] = $this->Common_model->get_tls_for_assign2($tl_cnd);
				}else{
					$tl_cnd=" and (site_id='$user_site_id' OR office_id='$ses_office_id') ";
					$data['assign_list'] = $this->Common_model->get_tls_for_assign2($tl_cnd);
				}	

				if($is_global_access=='1' ||  get_role_dir()=="admin" || get_dept_folder()=="hr" || get_dept_folder()=="wfm" || get_dept_folder()=="rta" || get_dept_folder()=="mis" || is_all_dept_access()){
				
					$data['department_list'] = $this->Common_model->get_department_list();
					if($dept_id=="ALL" || $dept_id=="") $data['sub_department_list'] = array();
					else $data['sub_department_list'] = $this->Common_model->get_sub_department_list($dept_id);
				
				}else{
					$data['department_list'] = $this->Common_model->get_department_session($ses_dept_id);
					$data['sub_department_list'] = $this->Common_model->get_sub_department_list($ses_dept_id);
				}
				
				
				
				
							
				$data['cValue']=$client_id;
				$data['sValue']=$site_id;
				$data['oValue']=$office_id;
				$data['dept_id']=$dept_id;
				$data['sdValue']=$sdValue;
				
				$data['start_date']=$start_date;
				$data['end_date']=$end_date;
				$data['filter_key']=$filter_key;
				$data['filter_value']=$filter_value;
				$data['ses_role_id']=$role_id;
				
				$this->load->view('dashboard',$data);
				
			
			
	   }
	   
    }
		
	private function createExcelFileRoaster($data,$fArray,$isLoginTime='N')
	{
		
		//echo "<pre>" .print_r($data,true) ."<pre>"; die();
		$filter_key =$fArray['filter_key'];
		
		$_atitle="";
		
		if($filter_key!="" && $filter_key!="OfflineList"){
		
			$filter_value =$fArray['filter_value'];
			
			switch($filter_key){
				case 'Site':
					
					$qSql="Select name as value from  site where id='$filter_value'";
					$_atitle = " - ".$this->Common_model->get_single_value($qSql);
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
		
				
		$start_date =$fArray['start_date'];
		$end_date =$fArray['end_date'];
		
		$title="Attendance From ".$start_date." To ".$end_date.$_atitle. " (All Time is in 'User Local Time')";
		
		$start_date =str_replace("/","-",$start_date);
		$end_date =str_replace("/","-",$end_date);
		
		//$process =$fArray['process'];	
		
		$fn="attendance-".$start_date."-".$end_date."".$_atitle.".xls";
		$filename = "./assets/reports/".$fn;
		
		$sht_title=$start_date." To ".$end_date." ";
		
		$default_border = array(
			'style' => PHPExcel_Style_Border::BORDER_THIN,
			'color' => array('rgb'=>'000000')
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
				'color' => array('rgb'=>'FFBCB2'),
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
		
		$style_trm = array(
			'borders' => array(
				'bottom' => $default_border,
				'left' => $default_border,
				'top' => $default_border,
				'right' => $default_border,
			),
			'fill' => array(
				'type' => PHPExcel_Style_Fill::FILL_SOLID,
				'color' => array('rgb'=>'FF0000'),
			),
			'font' => array(
				'size' => 10,
			),
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
				'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
			)
		);
		
		$style_ptrm = array(
			'borders' => array(
				'bottom' => $default_border,
				'left' => $default_border,
				'top' => $default_border,
				'right' => $default_border,
			),
			'fill' => array(
				'type' => PHPExcel_Style_Fill::FILL_SOLID,
				'color' => array('rgb'=>'FF817F'),
			),
			'font' => array(
				'size' => 10,
			),
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
				'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
			)
		);
		
		
		$style_syslog = array(
			'borders' => array(
				'bottom' => $default_border,
				'left' => $default_border,
				'top' => $default_border,
				'right' => $default_border,
			),
			'fill' => array(
				'type' => PHPExcel_Style_Fill::FILL_SOLID,
				'color' => array('rgb'=>'9ec2ff'),
			),
			'font' => array(
				'size' => 10,
			),
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
				'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
			)
		);
		
		$style_gray = array(
			'borders' => array(
				'bottom' => $default_border,
				'left' => $default_border,
				'top' => $default_border,
				'right' => $default_border,
			),
			'fill' => array(
				'type' => PHPExcel_Style_Fill::FILL_SOLID,
				'color' => array('rgb'=>'808080'),
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
		
		
		//activate worksheet number 1
		$this->excel->setActiveSheetIndex(0);
		//name the worksheet
		$this->excel->getActiveSheet()->setTitle($sht_title);
		//set cell A1 content with some text
	
		$this->excel->getActiveSheet()->setCellValue('A1', $title);
	
		//change the font size
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(14);
		//make the font become bold
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
						
		//$letters = range('A', 'Z');
		
		$letters = array(); 
		$k=0;
		 for ($i = 'A'; $i !== 'ZZ'; $i++){
			$letters[$k++]=$i;
		}

		//print_r($letters);
		// start and end are seconds, so I convert it to days 
		
					
		$this->excel->getActiveSheet()->setCellValue('A2', 'SLNo');
		$cell='A2';
		if($isLoginTime=="Y"){
			$cell='A2:A3';
			$this->excel->getActiveSheet()->mergeCells($cell);
		}
		$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
		
		
		$this->excel->getActiveSheet()->setCellValue('B2', 'Fusion Id');
		$cell='B2';
		if($isLoginTime=="Y"){
			$cell='B2:B3';
			$this->excel->getActiveSheet()->mergeCells($cell);
		}
		$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
		
		$this->excel->getActiveSheet()->setCellValue('C2', 'OM ID/XPOID');
		$cell='C2';
		if($isLoginTime=="Y"){
			$cell='C2:C3';
			$this->excel->getActiveSheet()->mergeCells($cell);
		}
		$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
		
		$this->excel->getActiveSheet()->setCellValue('D2', 'NAME');
		$cell='D2';
		if($isLoginTime=="Y"){
			$cell='D2:D3';
			$this->excel->getActiveSheet()->mergeCells($cell);
		}
		$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
		
		
		$this->excel->getActiveSheet()->setCellValue('E2', 'Dept');
		$cell='E2';
		if($isLoginTime=="Y"){
			$cell='E2:E3';
			$this->excel->getActiveSheet()->mergeCells($cell);
		}
		$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
		
		
		$this->excel->getActiveSheet()->setCellValue('F2', 'Designation');
		$cell='F2';
		if($isLoginTime=="Y"){
			$cell='F2:F3';
			$this->excel->getActiveSheet()->mergeCells($cell);
		}
		$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
		
		
		
		$this->excel->getActiveSheet()->setCellValue('G2', 'DOJ');
		$cell='G2';
		if($isLoginTime=="Y"){
			$cell='G2:G3';
			$this->excel->getActiveSheet()->mergeCells($cell);
		}
		$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
		
		
		
		$cell='H2';
		$this->excel->getActiveSheet()->setCellValue('H2', 'Location');
		if($isLoginTime=="Y"){
			$cell='H2:H3';
			$this->excel->getActiveSheet()->mergeCells($cell);
		}
		$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
		
		
		$cell='I2';
		$this->excel->getActiveSheet()->setCellValue('I2', 'Client');
		if($isLoginTime=="Y"){
			$cell='I2:I3';
			$this->excel->getActiveSheet()->mergeCells($cell);
		}
		$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
		
		
		$cell='J2';
		$this->excel->getActiveSheet()->setCellValue('J2', 'Process');
		if($isLoginTime=="Y"){
			$cell='J2:J3';
			$this->excel->getActiveSheet()->mergeCells($cell);
		}
		$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
		
		$cell='K2';
		$this->excel->getActiveSheet()->setCellValue('K2', 'L1 Supervisor');
		
		if($isLoginTime=="Y"){
			$cell='K2:K3';
			$this->excel->getActiveSheet()->mergeCells($cell);
		}
		$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
		
		
		$cell='L2';
		$this->excel->getActiveSheet()->setCellValue('L2', 'Status');
		
		if($isLoginTime=="Y"){
			$cell='L2:L3';
			$this->excel->getActiveSheet()->mergeCells($cell);
		}
		$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
		
		$cell='M2';
		$this->excel->getActiveSheet()->setCellValue('M2', 'Phase');
		
		if($isLoginTime=="Y"){
			$cell='M2:M3';
			$this->excel->getActiveSheet()->mergeCells($cell);
		}
		$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
		
		
		/*
		
		$start = strtotime($start_date);
		$end = strtotime($end_date);
		$diff = ($end - $start) / 86400; 
		$j=4;
		
		for ($i = 0; $i <= $diff; $i++) {
			$date = $start + ($i * 86400);
			$cDate= date('Y-m-d', $date);
			$cell=$letters[$j++]."2";
			$this->excel->getActiveSheet()->setCellValue($cell, $cDate);
		}
		*/
		//$this->excel->getActiveSheet()->getStyle('C2:'.$cell)->applyFromArray( $default_border ); // give style to header
 				
		if($isLoginTime=="Y") $r=3;
		else $r=2;
				
		$j=-1;
		$k=0;
		
		
		$allRowDone=false;
		$isFirst=true;
		
		$pevDate="";
		
		$cnt=1;
		
		foreach($data as $row)
		{
			$rdate=$row['rDate'];
			
			if($isFirst==false && $rdate!=$pevDate) $allRowDone=true;
			
			if($rdate!=$pevDate){
				
				if($isLoginTime=="Y"){ 
					$j+=10;
					$r=3;
				}else{
					//$j++;
					$j+=4;
					$r=3;
				}
			}
			
			$isFirst=false;
			
			if($allRowDone==false) $j = -1;
						
			$r++;
			
			$pevDate=$rdate;
			
			$disposition=$row['disposition'];
			$office_id = $row['office_id'];
			$role_id=$row['role_id'];
			
			$logged_in_hours = $row['logged_in_hours'];
			$logged_in_hours_local = $row['logged_in_hours_local'];
			
			$work_time=$row['logged_in_sec'];
			$work_time_local=$row['logged_in_sec_local'];
			
			$bg_style=$style_def;
			$bg_style_est=$style_def;
			$bg_style_local=$style_def;
			
			$att="";
			
			$isProperLogout = 'Y';
			
			$todayLoginTime = $row['todayLoginTime'] ;
			$todayLoginTime_local= ConvServerToLocalAny($todayLoginTime,$office_id);
			
			$is_logged_in = $row['is_logged_in'];
								
			$flogin_time = $row['flogin_time'];
			$flogin_time_local = $row['flogin_time_local'];
			
			$logout_time=$row['logout_time'];
			$logout_time_local=$row['logout_time_local'];
			
			$tBrkTime=$row['tBrkTime'];
			$tBrkTimeLocal=$row['tBrkTimeLocal'];
			
			$ldBrkTime=$row['ldBrkTime'];
			$ldBrkTimeLocal=$row['ldBrkTimeLocal'];
			
			$total_break=$tBrkTime+$ldBrkTime;
			$total_break_local=$tBrkTimeLocal+$ldBrkTimeLocal;
				
			$comments = $row['comments'];
			
			
			$omuid= $row['omuid'];
			$xpoid= $row['xpoid'];
			
			if($xpoid!="") $omuid = $xpoid;
			
			
			$leave_dtl = "";
			$leave_status = $row['leave_status'];
			if($row['leave_type'] !=""){
				if( $leave_status == '0') $leave_dtl = $row['leave_type'] . " Applied";
				else if( $leave_status == '1') $leave_dtl = $row['leave_type'] . " Approved";
				else if( $leave_status == '2') $leave_dtl = $row['leave_type'] . " Reject";
			}
			
			if($work_time == 0){
				$net_work_time="";
				$total_break = "";
				$tBrkTime = "";
				$ldBrkTime = "";
			}else{
				
				$net_work_time=gmdate('H:i:s',$work_time);
				$total_break = gmdate('H:i:s',$total_break);
				$tBrkTime = gmdate('H:i:s',$tBrkTime);
				$ldBrkTime = gmdate('H:i:s',$ldBrkTime);
				
			}
			
			if($work_time_local==0){
				$net_work_time_local="";
				$total_break_local="";
				$tBrkTimeLocal = "";
				$ldBrkTimeLocal = "";
			
			}else{
				
				$net_work_time_local=gmdate('H:i:s',$work_time_local);
								
				$total_break_local = gmdate('H:i:s',$total_break_local);
				$tBrkTimeLocal = gmdate('H:i:s',$tBrkTimeLocal);
				$ldBrkTimeLocal = gmdate('H:i:s',$ldBrkTimeLocal);
			}
			
			
			
			/*
			if($is_logged_in == '1'){
				
				$todayLoginArray = explode(" ",$todayLoginTime_local);
				
				if($rdate == $todayLoginArray[0]){
					
					$flogin_time = $todayLoginTime;
					$flogin_time_local = $todayLoginTime_local;
					
					$disposition="online";
					
					$net_work_time="";
					$net_work_time_local="";
					
					$total_break = "";
					$total_break_local="";
					$tBrkTime = "";
					$tBrkTimeLocal = "";
					$ldBrkTime = "";
					$ldBrkTimeLocal = "";
					$logout_time="";
					$logout_time_local="";
				}
			}
			*/
			
					
			if($is_logged_in == '1'){
				$todayLoginArray = explode(" ",$todayLoginTime);
				$todayLoginTime_local = ConvServerToLocalAny($todayLoginTime,$office_id);
				$todayLoginArray_local = explode(" ",$todayLoginTime_local);
				
				if($rdate == $todayLoginArray[0]){
					
					$flogin_time = $todayLoginTime;
					$disposition="online";
					$net_work_time="";
					$total_break = "";
					$tBrkTime = "";
					$ldBrkTime = "";
					$logout_time="";
				}
				
				if($rdate == $todayLoginArray_local[0]){
						$flogin_time_local=$todayLoginTime_local;
						$disposition="online";
						$net_work_time_local="";
						$total_break_local="";
						$tBrkTimeLocal = "";
						$ldBrkTimeLocal = "";
						$logout_time_local="";
				}
			}
			
			
			
			$disposition_est =  $disposition;
			$disposition_local =  $disposition;
			
			if($logged_in_hours!="0"){
					if($row['user_disp_id']=="8"){ 
						$disposition_est =  $disposition . " &  P";
						$bg_style_est=$style_p;
					}else if($row['user_disp_id']=="7"){
						$disposition_est =  "P & ". $disposition;
						$bg_style_est=$style_ptrm;
					}else{
						$disposition_est =  "P";
						$bg_style_est=$style_p;
					}
			}else if($disposition!=""){
				
				if($disposition_est=="LI")$bg_style_est=$style_p;
				else if($disposition_est=="TERM" || $disposition_est=="X")$bg_style_est=$style_trm;
				else if($disposition_est!="Absent") $bg_style_est=$style_l;
				
			}else{
				if($rdate < $row['doj']){
					$disposition_est = ""; 
					$bg_style_est=$style_gray;
				}else $disposition_est =  "Absent"; 
			}
			
			if($leave_dtl!="") $disposition_est = $leave_dtl;
			
			
			if($logged_in_hours_local!="0"){
					if($row['user_disp_id']=="8"){ 
						$disposition_local =  $disposition . " &  P";
						$bg_style_local=$style_p;
					}else if($row['user_disp_id']=="7"){
						$disposition_local =  "P & ". $disposition;
						$bg_style_local=$style_ptrm;
					}else{
						$disposition_local =  "P";
						$bg_style_local=$style_p;
					}
			}else if($disposition!=""){
				
				if($disposition_local=="LI")$bg_style_local=$style_p;
				else if($disposition_local=="TERM" || $disposition_local=="X")$bg_style_local=$style_trm;
				else if($disposition_local!="Absent") $bg_style_local=$style_l;
				
			}else{
				if($rdate < $row['doj']){
					$disposition_local = ""; 
					$bg_style_local=$style_gray;
				}else $disposition_local =  "Absent"; 
			}
			
			if($leave_dtl!="") $disposition_local = $leave_dtl;
			
			/////////////////
			$SkipRole="-#82#112#221#";
			$SkipLocation="-#ELS#JAM#";
			
			if( strpos($SkipRole,"#".$role_id."#") != false && strpos($SkipLocation,"#".$office_id."#") !=false){
				if($disposition_local=="Absent") $disposition_local = "LI";
				if($disposition_est=="Absent") $disposition_est = "LI";
			}
			
			if($isLoginTime=="Y"){
				
				if($disposition_est!="" && $flogin_time=="") $flogin_time = $disposition_est;
				if($disposition_local!="" && $flogin_time_local=="") $flogin_time_local = $disposition_local;
				
				if($disposition_est!="" && $logout_time=="") $logout_time = $disposition_est;
				if($disposition_local!="" && $logout_time_local=="") $logout_time_local = $disposition_local;
				
			}
			
			
			
			////////// For System Logout /////////////////////
			if($row['logout_by']== "0" && $logged_in_hours!="0" ){
				
				//$net_work_time=0;
				//$net_work_time_local = 0;
				//$logout_time="";
				//$logout_time_local="";
				$isProperLogout = 'N';
				
				$comments = "System Logout";
				$bg_style_est =  $style_syslog;
			    $bg_style_local = $style_syslog;
			}
			
			
			
			if($allRowDone==false){
			
				$cell=$letters[++$j].$r;
				//echo $cell .">>";
				$this->excel->getActiveSheet()->setCellValue($cell, $cnt++);
				$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_def );
				
				$cell=$letters[++$j].$r;
				//echo $cell .">>";
				$this->excel->getActiveSheet()->setCellValue($cell, $row['fusion_id']);
				$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_def_left );
				
				$cell=$letters[++$j].$r;
				//echo $cell .">>";
				$this->excel->getActiveSheet()->setCellValue($cell, $row['omuid']);
				$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_def_left );
				
				$cell=$letters[++$j].$r;
				//echo $cell .">>";
				$fullname=$row['fname'] . " ". $row['lname'];
				$this->excel->getActiveSheet()->setCellValue($cell, $fullname);
				$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_def_left );
				
				$cell=$letters[++$j].$r;
				//echo $cell .">>";
				$this->excel->getActiveSheet()->setCellValue($cell, $row['dept_name']);
				$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_def_left );
				
				$cell=$letters[++$j].$r;
				//echo $cell .">>";
				$this->excel->getActiveSheet()->setCellValue($cell, $row['role_name']);
				$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_def_left );
								
				$doj=$row['doj'];
				if($doj=="") $doj="NA";
				$cell=$letters[++$j].$r;
				//echo $cell .">>";
				$this->excel->getActiveSheet()->setCellValue($cell, $doj);
				$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_def );
				
				$cell=$letters[++$j].$r;
				//echo $cell .">>";
				$this->excel->getActiveSheet()->setCellValue($cell, $row['office_id']);
				$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_def_left );
				
				$cell=$letters[++$j].$r;
				//echo $cell .">>";
				$this->excel->getActiveSheet()->setCellValue($cell, $row['client_name']);
				$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_def_left );
				
				$cell=$letters[++$j].$r;
				//echo $cell .">>";
				$this->excel->getActiveSheet()->setCellValue($cell, $row['process_name']);
				$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_def_left );
				
				$cell=$letters[++$j].$r;
				//echo $cell .">>";
				$this->excel->getActiveSheet()->setCellValue($cell, $row['asign_tl']);
				$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_def_left );
				
				
				$cell=$letters[++$j].$r;
				//echo $cell .">>";
				$this->excel->getActiveSheet()->setCellValue($cell, $this->display_user_status($row['status']));
				$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_def );
				
				$cell=$letters[++$j].$r;
				//echo $cell .">>";
				$this->excel->getActiveSheet()->setCellValue($cell, $this->display_user_phase($row['phase']));
				$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_def );
				
				if($isLoginTime=="Y"){
				
					$cell=$letters[++$j]."2";
					$this->excel->getActiveSheet()->setCellValue($cell, $row['rDate']);
					$cell=$letters[$j]."2" .":". $letters[($j+9)]."2";
					$this->excel->getActiveSheet()->mergeCells($cell);
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
					
					$cell=$letters[$j]."3";
					$this->excel->getActiveSheet()->setCellValue($cell, "Schedule IN");
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
					
					$cell=$letters[($j+1)]."3";
					$this->excel->getActiveSheet()->setCellValue($cell, "Schedule Out");
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
										
					$cell=$letters[$j+2]."3";
					$this->excel->getActiveSheet()->setCellValue($cell, "IN (EST)");
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
					
					$cell=$letters[($j+3)]."3";
					$this->excel->getActiveSheet()->setCellValue($cell, "IN (Local)");
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
					
					
					$cell=$letters[($j+4)]."3";
					$this->excel->getActiveSheet()->setCellValue($cell, "OUT (EST)");
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
					
					$cell=$letters[($j+5)]."3";
					$this->excel->getActiveSheet()->setCellValue($cell, "OUT (Local)");
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
					
					$cell=$letters[($j+6)]."3";
					$this->excel->getActiveSheet()->setCellValue($cell, "Break Time (EST)");
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
					
					$cell=$letters[($j+7)]."3";
					$this->excel->getActiveSheet()->setCellValue($cell, "Break Time (Local)");
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
										
					$cell=$letters[($j+8)]."3";
					$this->excel->getActiveSheet()->setCellValue($cell, "Work Time (EST)");
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
					
					$cell=$letters[($j+9)]."3";
					$this->excel->getActiveSheet()->setCellValue($cell, "Work Time (Local)");
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
					
					
					$cell=$letters[$j].$r;
					$this->excel->getActiveSheet()->setCellValue($cell, $row['sch_in']);
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $bg_style_est);
										
					$cell=$letters[($j+1)].$r;
					$this->excel->getActiveSheet()->setCellValue($cell, $row['sch_out']);
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $bg_style_local );
					
					
					
					$cell=$letters[$j+2].$r;
					$this->excel->getActiveSheet()->setCellValue($cell, $flogin_time);
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $bg_style_est);
										
					$cell=$letters[($j+3)].$r;
					$this->excel->getActiveSheet()->setCellValue($cell, $flogin_time_local);
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $bg_style_local );
					
					$cell=$letters[($j+4)].$r;
					$this->excel->getActiveSheet()->setCellValue($cell, $logout_time);
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray($bg_style_est);
					
					$cell=$letters[($j+5)].$r;
					$this->excel->getActiveSheet()->setCellValue($cell, $logout_time_local);
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray($bg_style_local);
					
					$cell=$letters[($j+6)].$r;
					$this->excel->getActiveSheet()->setCellValue($cell, $total_break);
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $bg_style_est );
					
					$cell=$letters[($j+7)].$r;
					$this->excel->getActiveSheet()->setCellValue($cell, $total_break_local);
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $bg_style_local );
					
					
					$cell=$letters[($j+8)].$r;
					$this->excel->getActiveSheet()->setCellValue($cell, $net_work_time);
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $bg_style_est );
					
					$cell=$letters[($j+9)].$r;
					$this->excel->getActiveSheet()->setCellValue($cell, $net_work_time_local);
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $bg_style_local );
					
										
				}else{
					
					$cell=$letters[++$j]."2";
					$this->excel->getActiveSheet()->setCellValue($cell, $row['rDate']);
					$cell=$letters[$j]."2" .":". $letters[($j+3)]."2";
					$this->excel->getActiveSheet()->mergeCells($cell);
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
										
					
					$cell=$letters[$j]."3";
					$this->excel->getActiveSheet()->setCellValue($cell, "Schedule IN");
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
					
					$cell=$letters[$j+1]."3";
					$this->excel->getActiveSheet()->setCellValue($cell, "Schedule Out");
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
					
					$cell=$letters[$j+2]."3";
					$this->excel->getActiveSheet()->setCellValue($cell, "EST");
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
					
					$cell=$letters[($j+3)]."3";
					$this->excel->getActiveSheet()->setCellValue($cell, "Local");
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
												
												
					$cell=$letters[$j].$r;
					$this->excel->getActiveSheet()->setCellValue($cell, $row['sch_in']);
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray($bg_style_est);
					
					$cell=$letters[$j+1].$r;
					$this->excel->getActiveSheet()->setCellValue($cell, $row['sch_out']);
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray($bg_style_local);
					
					
					
					$cell=$letters[$j+2].$r;
					$this->excel->getActiveSheet()->setCellValue($cell, $disposition_est);
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray($bg_style_est);
					
					$cell=$letters[$j+3].$r;
					//echo $cell ."<br>";
					$this->excel->getActiveSheet()->setCellValue($cell, $disposition_local);
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray($bg_style_local);
					
				}
				
			}else{
								
				
				if($isLoginTime=="Y"){
				
					$cell=$letters[$j]."2";
					$this->excel->getActiveSheet()->setCellValue($cell, $row['rDate']);
					$cell=$letters[$j]."2" .":". $letters[($j+9)]."2";
					$this->excel->getActiveSheet()->mergeCells($cell);
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
					
					$cell=$letters[$j]."3";
					$this->excel->getActiveSheet()->setCellValue($cell, "Schedule IN");
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
					
					$cell=$letters[($j+1)]."3";
					$this->excel->getActiveSheet()->setCellValue($cell, "Schedule Out");
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );

					
					$cell=$letters[$j+2]."3";
					$this->excel->getActiveSheet()->setCellValue($cell, "IN (EST)");
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
					
					$cell=$letters[($j+3)]."3";
					$this->excel->getActiveSheet()->setCellValue($cell, "IN (Local)");
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
					
					
					$cell=$letters[($j+4)]."3";
					$this->excel->getActiveSheet()->setCellValue($cell, "OUT (EST)");
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
					
					$cell=$letters[($j+5)]."3";
					$this->excel->getActiveSheet()->setCellValue($cell, "OUT (Local)");
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
					
					$cell=$letters[($j+6)]."3";
					$this->excel->getActiveSheet()->setCellValue($cell, "Break Time (EST)");
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
					
					$cell=$letters[($j+7)]."3";
					$this->excel->getActiveSheet()->setCellValue($cell, "Break Time (Local)");
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
										
					$cell=$letters[($j+8)]."3";
					$this->excel->getActiveSheet()->setCellValue($cell, "Work Time (EST)");
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
					
					$cell=$letters[($j+9)]."3";
					$this->excel->getActiveSheet()->setCellValue($cell, "Work Time (Local)");
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
					
					
					$cell=$letters[$j].$r;
					$this->excel->getActiveSheet()->setCellValue($cell, $row['sch_in']);
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $bg_style_est);
										
					$cell=$letters[($j+1)].$r;
					$this->excel->getActiveSheet()->setCellValue($cell, $row['sch_out']);
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $bg_style_local );

					$cell=$letters[$j+2].$r;
					$this->excel->getActiveSheet()->setCellValue($cell, $flogin_time);
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $bg_style_est);
										
					$cell=$letters[($j+3)].$r;
					$this->excel->getActiveSheet()->setCellValue($cell, $flogin_time_local);
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $bg_style_local );
					
					$cell=$letters[($j+4)].$r;
					$this->excel->getActiveSheet()->setCellValue($cell, $logout_time);
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray($bg_style_est);
					
					$cell=$letters[($j+5)].$r;
					$this->excel->getActiveSheet()->setCellValue($cell, $logout_time_local);
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray($bg_style_local);
					
					$cell=$letters[($j+6)].$r;
					$this->excel->getActiveSheet()->setCellValue($cell, $total_break);
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $bg_style_est );
					
					$cell=$letters[($j+7)].$r;
					$this->excel->getActiveSheet()->setCellValue($cell, $total_break_local);
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $bg_style_local );
					
					
					$cell=$letters[($j+8)].$r;
					$this->excel->getActiveSheet()->setCellValue($cell, $net_work_time);
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $bg_style_est );
					
					$cell=$letters[($j+9)].$r;
					$this->excel->getActiveSheet()->setCellValue($cell, $net_work_time_local);
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $bg_style_local );
					
										
				}else{
					
					$cell=$letters[$j]."2";
					$this->excel->getActiveSheet()->setCellValue($cell, $row['rDate']);
					$cell=$letters[$j]."2" .":". $letters[($j+3)]."2";
					
					$this->excel->getActiveSheet()->mergeCells($cell);
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
					
					$cell=$letters[$j]."3";
					$this->excel->getActiveSheet()->setCellValue($cell, "Schedule IN");
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
					
					$cell=$letters[$j+1]."3";
					$this->excel->getActiveSheet()->setCellValue($cell, "Schedule Out");
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
										
					$cell=$letters[$j+2]."3";
					$this->excel->getActiveSheet()->setCellValue($cell, "EST");
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
					
					$cell=$letters[($j+3)]."3";
					$this->excel->getActiveSheet()->setCellValue($cell, "Local");
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
					
					$cell=$letters[$j].$r;
					$this->excel->getActiveSheet()->setCellValue($cell, $row['sch_in']);
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray($bg_style_est);
					
					$cell=$letters[$j+1].$r;
					$this->excel->getActiveSheet()->setCellValue($cell, $row['sch_out']);
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray($bg_style_local);
					
					
					$cell=$letters[$j+2].$r;
					$this->excel->getActiveSheet()->setCellValue($cell, $disposition_est);
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray($bg_style_est);
					
					$cell=$letters[$j+3].$r;
					//echo $cell ."<br>";
					$this->excel->getActiveSheet()->setCellValue($cell, $disposition_local);
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray($bg_style_local);
					 
				}
				
			
			}
	
		}
		
		
		$cell=$letters[$j]."1";
		$this->excel->getActiveSheet()->mergeCells('A1:'.$cell);
		
		//set aligment to center for that merged cell (A1 to N1)
		//$this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
						
		header('Content-Type: application/vnd.ms-excel'); //mime type
		header('Content-Disposition: attachment;filename="'.$fn.'"'); //tell browser what's the file name
		header('Cache-Control: max-age=0'); //no cache
					 
		//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
		//if you want to save it as .XLSX Excel 2007 format
		
		$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5'); 
		ob_end_clean();
		//force user to download the Excel file without writing it to server's HD
		$objWriter->save('php://output');

		//$objWriter->save($filename);
	}
	
	
	
	
	
	
	
	
	
	
/*================================ LOGIN ADHERENCE ===============================================================================*/


	public function adherence()
    {
		if(check_logged_in())
        {
			//$this->check_access();
			
			$role_id       = get_role_id();
			$current_user  = get_user_id();
			$user_site_id  = get_user_site_id();
			$ses_dept_id   = get_dept_id();
			$ses_office_id = get_user_office_id();
			$is_global_access = get_global_access();
            
			$data['showtype'] = $show_type = 1;
			$data["aside_template"] = $this->aside;
			$data["content_template"] = "attendance/att_adherence.php";
			    
			$data['user_list'] =array();
			$office_id = "";  $start_date = "";	$end_date = ""; $dept_id = "";
			
			$start_date = $this->input->get('start_date');
			$end_date   = $this->input->get('end_date');
			$office_id = $this->input->get('office_id');
			$dept_id = $this->input->get('dept_id');
			$showtype = $this->input->get('showtype');
					
			if($office_id=="")  $office_id = $ses_office_id;
			if($dept_id=="")  $dept_id = $ses_dept_id;
			
			//------ LOCATION LIST
			if($is_global_access==1 || get_dept_folder()=="rta"){
				$data['site_list'] = $this->Common_model->get_sites_for_assign();
				$data['location_list'] = $this->Common_model->get_office_location_list();
			}else{
				$sCond=" Where id = '$user_site_id'";
				$data['site_list'] = $this->Common_model->get_sites_for_assign2($sCond);
				$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
			}
			
			//------ DEPARTMENT LIST
			if($is_global_access=='1' ||  get_role_dir()=="admin" || get_dept_folder()=="hr" || get_dept_folder()=="wfm" || get_dept_folder()=="rta" || get_dept_folder()=="mis" || is_all_dept_access()){
				$data['department_list'] = $this->Common_model->get_department_list();
			}else{
				$data['department_list'] = $this->Common_model->get_department_session($ses_dept_id);
			}
							
			$data['cValue']  = $client_id;
			$data['sValue']  = $site_id;
			$data['oValue']  = $office_id;
			$data['dept_id'] = $dept_id;
			
			$data['start_date'] = $start_date;
			$data['end_date']   = $end_date;
			
			
			//-- FILTER SEARCH
			if($office_id == "ALL") $extraoffice = "";
			else $extraoffice = " AND s.office_id = '$office_id'";
			
			if($dept_id == "ALL") $extradepartment = "";
			else $extradepartment = " AND s.dept_id = '$dept_id'";
			
			//--------- USER LIST
			/*$sqlusers = "SELECT s.id as user_id, s.fusion_id, concat(s.fname, ' ', s.lname) as fullname, 
			s.office_id, d.shname as department_name from signin s 
			LEFT JOIN department d on s.dept_id = d.id
			WHERE 1 $extraoffice $extradepartment";
			$data['myusers'] = $query_users = $this->Common_model->get_query_result_array($sqlusers);		
			*/	
			
			//-- DAY WISE DATA ARRAY
			$date1 = new DateTime($start_date);
			$date2 = new DateTime($end_date);
			$days  = $date2->diff($date1)->format('%a');
			$hdate = new DateTime($start_date);
			for($i=1; $i<=$days+1; $i++){
				$data['dayreport'][$hdate->format('Y-m-d')] = $this->get_login_data_inday_all($hdate->format('Y-m-d'), $dept_id, $office_id);
				$hdate->modify('+1 day');
			}
			
			if($showtype != ""){ $data['showtype'] = $showtype; }
			$data['urlform'] = "start_date=".$start_date ."&end_date=".$end_date."&office_id=".$office_id."&dept_id=".$dept_id;
			//echo "<pre>" .print_r($data, true) ."</pre>"; die();
			
			$data['dataViewType'] = "on";
			$this->load->view('dashboard',$data);
				
	   }
	
    }
	
	
	private function get_login_data_inday($getdate, $dept_id)
	{
		if($dept_id == "ALL"){ 
		
		$sqllogin = "SELECT d.user_id, d.logout_by, min(getEstToLocal(d.login_time,d.user_id)) as login_time_local, max(getEstToLocal(d.logout_time,d.user_id)) as logout_time_local,  SEC_TO_TIME(SUM(TIMESTAMPDIFF(SECOND,getEstToLocal(d.login_time,d.user_id), getEstToLocal(d.logout_time,d.user_id)))) as totaltime,
		s.shdate as scheduledate, s.scheduled_login, s.scheduled_logout, s.in_time as scheduled_in_time, s.out_time as scheduled_out_time from logged_in_details as d
		LEFT JOIN (SELECT user_id, shdate, in_time, out_time, CONCAT(shdate, ' ', in_time,':00') as scheduled_login, CONCAT(shdate, ' ', out_time,':00') as scheduled_logout FROM user_shift_schedule) as s ON s.user_id = d.user_id AND s.shdate = '$getdate'
		WHERE (date(getEstToLocal(d.login_time,d.user_id)) = '$getdate') GROUP BY d.user_id";
		$querylogin = $this->Common_model->get_query_result_array($sqllogin);
		
		} else {
			
		$sqllogin = "SELECT d.user_id, d.logout_by, min(getEstToLocal(d.login_time,d.user_id)) as login_time_local, max(getEstToLocal(d.logout_time,d.user_id)) as logout_time_local ,  SEC_TO_TIME(SUM(TIMESTAMPDIFF(SECOND,getEstToLocal(d.login_time,d.user_id), getEstToLocal(d.logout_time,d.user_id)))) as totaltime, s.shdate as scheduledate, s.scheduled_login, s.scheduled_logout, s.in_time as scheduled_in_time, s.out_time as scheduled_out_time from logged_in_details as d
		LEFT JOIN (SELECT user_id, shdate, in_time, out_time, CONCAT(shdate, ' ', in_time,':00') as scheduled_login, CONCAT(shdate, ' ', out_time,':00') as scheduled_logout FROM user_shift_schedule) as s ON s.user_id = d.user_id AND s.shdate = '$getdate'
		WHERE (date(getEstToLocal(d.login_time,d.user_id)) = '$getdate') AND d.user_id IN (SELECT id from signin WHERE dept_id = '$dept_id') GROUP BY d.user_id";
		$querylogin = $this->Common_model->get_query_result_array($sqllogin);
	
		}
		
		return $querylogin;
		
	}
	
	
	//----- FUNCTION FOR DAY WISE DATA RECORDS
	private function get_login_data_inday_all($getdate, $dept_id, $office_id)
	{
		if($dept_id == "ALL"){ $addextradep = ""; } else { $addextradep = " AND sg.dept_id = '$dept_id'"; }
		if($office_id == "ALL"){ $addextraoffice = ""; } else { $addextraoffice = " AND sg.office_id = '$office_id'"; }
		
		$sqllogin = "SELECT 
					sg.fusion_id, sg.status, sg.phase,
					concat(sg.fname, ' ', sg.lname) as fullname,
					concat(lsg.fname, ' ', lsg.lname) as l1_supervisor,
					get_client_names(sg.id) as client_name,
					get_process_names(sg.id) as process_name,
					r.name as designation,
					sg.role_id, 					
					sg.office_id,
					dp.shname as department_name, 
					d.user_id, 
					d.logout_by, 
					min(d.login_time_local) as login_time_local, 
					max(d.logout_time_local) as logout_time_local,  
					SEC_TO_TIME(SUM(TIMESTAMPDIFF(SECOND,d.login_time_local, d.logout_time_local))) as totaltime, 
					s.shdate as scheduledate, 
					s.scheduled_login, s.scheduled_logout, s.in_time as scheduled_in_time, 
					s.out_time as scheduled_out_time, 
					TIMEDIFF(s.scheduled_logout, s.scheduled_login) as myinterval,
					CASE 
					WHEN (min(d.login_time_local) > s.scheduled_login) 
					THEN CONCAT('-', TIMEDIFF(min(d.login_time_local), s.scheduled_login))
					ELSE TIMEDIFF(s.scheduled_login, min(d.login_time_local))
					END as myloginadherence			
					from signin as sg
					LEFT JOIN (SELECT dg.user_id, dg.logout_by, dg.login_time_local, dg.logout_time_local from logged_in_details as dg WHERE date(dg.login_time_local) = '$getdate') as d on sg.id = d.user_id
					LEFT JOIN department dp on sg.dept_id = dp.id
					LEFT JOIN role r on r.id = sg.role_id
					LEFT JOIN signin lsg on lsg.id = sg.assigned_to
					LEFT JOIN (SELECT user_id, shdate, in_time, out_time, 
					CASE WHEN in_time LIKE '%:%'
					THEN CONCAT(shdate, ' ', in_time,':00')
					ELSE in_time
					END as scheduled_login,
					CASE WHEN (in_time > out_time)
					THEN CONCAT(DATE_ADD(shdate, INTERVAL 1 DAY), ' ', out_time,':00')
					ELSE CONCAT(shdate, ' ', out_time,':00') 
					END as scheduled_logout FROM user_shift_schedule) as s ON s.user_id = sg.id AND s.shdate = '$getdate'
					WHERE sg.status IN (1,4) and sg.id > 1 $addextradep $addextraoffice GROUP BY sg.id";
				
		$querylogin = $this->Common_model->get_query_result_array($sqllogin);
		array_multisort(array_column($querylogin, 'office_id'), SORT_ASC, array_column($querylogin, 'fullname'), SORT_ASC, $querylogin);	
			
		return $querylogin;
		
	}
	
	
	private function get_roaster_inday($getdate, $user_id)
	{
		$sqllogin = "SELECT s.shdate, s.in_time, s.out_time, CONCAT(s.shdate, ' ', s.in_time) as scheduled_login, CONCAT(s.shdate, ' ', s.out_time) as scheduled_logout FROM user_shift_schedule as s WHERE s.user_id = '$user_id' AND s.shdate = '$getdate'";
		
		$querylogin = $this->Common_model->get_query_result_array($sqllogin);
		return $querylogin;
		
	}
	
	
	//`````````````````````````````````````````````````````````````````````````````````````````````````````````````````
	//-------------- EXCEL VIEW -----------------------------------------------------------------------------------------
	
	public function adherence_check()
    {
		if(check_logged_in())
        {
			//$this->check_access();
			
			$role_id       = get_role_id();
			$current_user  = get_user_id();
			$user_site_id  = get_user_site_id();
			$ses_dept_id   = get_dept_id();
			$ses_office_id = get_user_office_id();
			$is_global_access = get_global_access();
            
			$data['showtype'] = $show_type = 1;
			$data["aside_template"] = $this->aside;
			$data["content_template"] = "attendance/att_adherence.php";
			    
			$data['user_list'] =array();
			$office_id = "";  $start_date = "";	$end_date = ""; $dept_id = "";
			
			$start_date = $this->input->get('start_date');
			$end_date   = $this->input->get('end_date');
			$office_id = $this->input->get('office_id');
			$dept_id = $this->input->get('dept_id');
			$showtype = $this->input->get('showtype');
			$showreport = $this->input->get('showReports');
					
			if($office_id=="")  $office_id = $ses_office_id;
			if($dept_id=="")  $dept_id = $ses_dept_id;
			
			//------ LOCATION LIST
			if($is_global_access==1 || get_dept_folder()=="rta"){
				$data['site_list'] = $this->Common_model->get_sites_for_assign();
				$data['location_list'] = $this->Common_model->get_office_location_list();
			}else{
				$sCond=" Where id = '$user_site_id'";
				$data['site_list'] = $this->Common_model->get_sites_for_assign2($sCond);
				$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
			}
			
			//------ DEPARTMENT LIST
			if($is_global_access=='1' ||  get_role_dir()=="admin" || get_dept_folder()=="hr" || get_dept_folder()=="wfm" || get_dept_folder()=="rta" || get_dept_folder()=="mis" || is_all_dept_access()){
				$data['department_list'] = $this->Common_model->get_department_list();
			}else{
				$data['department_list'] = $this->Common_model->get_department_session($ses_dept_id);
			}
							
			$data['cValue']  = $client_id;
			$data['sValue']  = $site_id;
			$data['oValue']  = $office_id;
			$data['dept_id'] = $dept_id;
			
			$data['start_date'] = $start_date;
			$data['end_date']   = $end_date;
			
			$data['dataViewType'] = "off";
			
			if($showreport == "View"){
				$this->gen_excel_adherence_report($start_date, $end_date, $dept_id, $office_id);
			} else {
				$this->load->view('dashboard',$data);
			}				
	   }
	
    }
	
	
	//--------- EXCEL GENERATE ADHERENCE -------------------------------------//
	
	private function gen_excel_adherence_report($start_date, $end_date, $dept_id, $office_id)
    {
        
        //error_reporting(E_ALL);
        //ini_set('display_errors', TRUE);
        //ini_set('display_startup_errors', TRUE);
        require_once APPPATH . 'third_party/PHPExcel.php';
		
		
		//---------- SET DATA
		if($office_id == "ALL") $extraoffice = "";
		else $extraoffice = " AND office_id = '$office_id'";
		
		if($dept_id == "ALL") $extradepartment = "";
		else $extradepartment = " AND dept_id = '$dept_id'";
		
		//--------- USER LIST
		/*$sqlusers = "SELECT s.id as user_id, s.fusion_id, concat(s.fname, ' ', s.lname) as fullname, 
		s.office_id, d.shname as department_name from signin s 
		LEFT JOIN department d on s.dept_id = d.id
		WHERE 1 $extraoffice $extradepartment";
		$myusers = $query_users = $this->Common_model->get_query_result_array($sqlusers);*/
			
		//-- DAY WISE DATA ARRAY
		$date1 = new DateTime($start_date);
		$date2 = new DateTime($end_date);
		$days  = $date2->diff($date1)->format('%a');
		$hdate = new DateTime($start_date);
		for($i=1; $i<=$days+1; $i++){
			$dayreport[$hdate->format('Y-m-d')] = $this->get_login_data_inday_all($hdate->format('Y-m-d'), $dept_id, $office_id);
			$hdate->modify('+1 day');
		}
		
		//echo "<pre>" .print_r($myusers, true) ."</pre>";
		//echo "<pre>" .print_r($dayreport, true) ."</pre>"; die();
		
		
		/*-----------### CREATE EXCEL ####------------------*/
		
        $objPHPExcel = new PHPExcel();
		
		//---------> CREATE WORKSHEETS
		$titles = array('Login Adherence', 'Auto Logout Count', 'Staffed Time');
		$sheet = 0;
		foreach($titles as $value){
			if($sheet > 0){
				$objPHPExcel->createSheet();
				$objPHPExcel->setActiveSheetIndex($sheet)->setTitle($value);
			}else{
				$objPHPExcel->setActiveSheetIndex(0)->setTitle("$value");
			}
			$sheet++;
		} 
		
		

		for($sh=0;$sh<3;$sh++){
		
        $objPHPExcel->setActiveSheetIndex($sh);
        $objPHPExcel->getActiveSheet()->freezePane('D2');
        $rowCount = 3;
        $style = array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            )
        );
				
		$c_col = "0";
		$c_row = "1";
		
		
		// COLUMNS SET
		$c_row++; $current_column = PHPExcel_Cell::stringFromColumnIndex($c_col); $current_cell = $current_column.$c_row; 
		$objPHPExcel->getActiveSheet()->getColumnDimension($current_column)->setWidth(6);
        $objPHPExcel->getActiveSheet()->SetCellValue($current_cell, '#');
		
		$c_col++; $current_column = PHPExcel_Cell::stringFromColumnIndex($c_col); $current_cell = $current_column.$c_row; 		
		$objPHPExcel->getActiveSheet()->getColumnDimension($current_column)->setWidth(14);
        $objPHPExcel->getActiveSheet()->SetCellValue($current_cell, 'Fusion ID');
		
		$c_col++; $current_column = PHPExcel_Cell::stringFromColumnIndex($c_col); $current_cell = $current_column.$c_row; 
        $objPHPExcel->getActiveSheet()->getColumnDimension($current_column)->setWidth(30);
        $objPHPExcel->getActiveSheet()->SetCellValue($current_cell, 'Name');
		
		$c_col++; $current_column = PHPExcel_Cell::stringFromColumnIndex($c_col); $current_cell = $current_column.$c_row; 
		$objPHPExcel->getActiveSheet()->getColumnDimension($current_column)->setWidth(8);
        $objPHPExcel->getActiveSheet()->SetCellValue($current_cell, 'Site');
		
		$c_col++; $current_column = PHPExcel_Cell::stringFromColumnIndex($c_col); $current_cell = $current_column.$c_row; 
		$objPHPExcel->getActiveSheet()->getColumnDimension($current_column)->setWidth(20);
        $objPHPExcel->getActiveSheet()->SetCellValue($current_cell, 'Department');
		
		$c_col++; $current_column = PHPExcel_Cell::stringFromColumnIndex($c_col); $current_cell = $current_column.$c_row; 
		$objPHPExcel->getActiveSheet()->getColumnDimension($current_column)->setWidth(30);
        $objPHPExcel->getActiveSheet()->SetCellValue($current_cell, 'Designation');
		
		$c_col++; $current_column = PHPExcel_Cell::stringFromColumnIndex($c_col); $current_cell = $current_column.$c_row; 
		$objPHPExcel->getActiveSheet()->getColumnDimension($current_column)->setWidth(25);
        $objPHPExcel->getActiveSheet()->SetCellValue($current_cell, 'Client');
		
		$c_col++; $current_column = PHPExcel_Cell::stringFromColumnIndex($c_col); $current_cell = $current_column.$c_row; 
		$objPHPExcel->getActiveSheet()->getColumnDimension($current_column)->setWidth(25);
        $objPHPExcel->getActiveSheet()->SetCellValue($current_cell, 'Process');
		
		$c_col++; $current_column = PHPExcel_Cell::stringFromColumnIndex($c_col); $current_cell = $current_column.$c_row; 
		$objPHPExcel->getActiveSheet()->getColumnDimension($current_column)->setWidth(30);
        $objPHPExcel->getActiveSheet()->SetCellValue($current_cell, 'L1 Supervisor');
		
		$c_col++; $current_column = PHPExcel_Cell::stringFromColumnIndex($c_col); $current_cell = $current_column.$c_row; 
		$objPHPExcel->getActiveSheet()->getColumnDimension($current_column)->setWidth(30);
        $objPHPExcel->getActiveSheet()->SetCellValue($current_cell, 'Status');
		
		$c_col++; $current_column = PHPExcel_Cell::stringFromColumnIndex($c_col); $current_cell = $current_column.$c_row; 
		$objPHPExcel->getActiveSheet()->getColumnDimension($current_column)->setWidth(30);
        $objPHPExcel->getActiveSheet()->SetCellValue($current_cell, 'Phase');
		//$objPHPExcel->getActiveSheet()->getStyle($current_cell)->getAlignment()->setIndent(2);
		
		
		$date1 = new DateTime($start_date);
		$date2 = new DateTime($end_date);
		$days  = $date2->diff($date1)->format('%a');
		$hdate = new DateTime($start_date);
		for($i=1; $i<=$days+1; $i++){
		
		
		//--- FOR WORKSHEEET 1
		if($sh == 0){
			$c_col++; $current_column = PHPExcel_Cell::stringFromColumnIndex($c_col); $current_cell = $current_column.$c_row; 
			$objPHPExcel->getActiveSheet()->getColumnDimension($current_column)->setWidth(22);
			$objPHPExcel->getActiveSheet()->SetCellValue($current_cell, 'Rostered Login Time');
			
			$c_col++; $current_column = PHPExcel_Cell::stringFromColumnIndex($c_col); $current_cell = $current_column.$c_row; 
			$objPHPExcel->getActiveSheet()->getColumnDimension($current_column)->setWidth(20);
			$objPHPExcel->getActiveSheet()->SetCellValue($current_cell, 'Actual Login Time');
		}
		
			$c_col++; $current_column = PHPExcel_Cell::stringFromColumnIndex($c_col); $current_cell = $current_column.$c_row; 
			$objPHPExcel->getActiveSheet()->getColumnDimension($current_column)->setWidth(20);
			$objPHPExcel->getActiveSheet()->SetCellValue($current_cell, $hdate->format('d-M-Y'));
			
			$hdate->modify('+1 day');
		}
		
		$lastColName = "Late Login Count";
		if($sh == 1){ $lastColName = "System Logout Count"; }
		if($sh == 2){ $lastColName = "Shortage Count"; }
		
		$c_col++; $current_column = PHPExcel_Cell::stringFromColumnIndex($c_col); $current_cell = $current_column.$c_row; 
		$objPHPExcel->getActiveSheet()->getColumnDimension($current_column)->setWidth(20);
        $objPHPExcel->getActiveSheet()->SetCellValue($current_cell, $lastColName);
				
		// HEADER SET
        $objPHPExcel->getActiveSheet()->getStyle("A1:".$current_column."1")->applyFromArray($style);
        $objPHPExcel->getActiveSheet()->mergeCells("A1:D1");
        $objPHPExcel->getActiveSheet()->getStyle("A1")->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->SetCellValue('A1', $titles[$sh]);
        $objPHPExcel->getActiveSheet()->getStyle("A2:".$current_column."2")->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle("A2:".$current_column."2")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('000000');
		
		$colorArrayWhite = array('font'  => array('color' => array('rgb' => 'FFFFFF')));
		$objPHPExcel->getActiveSheet()->getStyle("A2:".$current_column."2")->applyFromArray($colorArrayWhite);
		$objPHPExcel->getActiveSheet()->getStyle("C2")->getAlignment()->setIndent(2);
		
		$endingcol = $c_col;
		
		// -- SET EXCEL DATA
		$sl = 0;
		$ir = 0;
		$startdate = date('Y-m-d', strtotime($start_date));
        foreach($dayreport[$startdate] as $token)
        {
			$sl++;
			$c_row++;
			$fusion_id 			= $token['fusion_id'];
			$fullname 			= $token['fullname'];
			$office_id 			= $token['office_id'];
			$department_name 	= $token['department_name'];
			$designation 		= $token['designation'];
			$client_name 		= $token['client_name'];
			$process_name 		= $token['process_name'];
			$l1_supervisor 		= $token['l1_supervisor'];
			$user_status 		= $this->display_user_status($token['status']);
			$user_phase 		= $this->display_user_phase($token['phase']);
			
			$c_col = 0;
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($c_col, $c_row, $sl);
			
			$c_col++;
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($c_col, $c_row, $fusion_id);
			
			$c_col++;
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($c_col, $c_row, $fullname);
			$objPHPExcel->getActiveSheet()->getStyle("C".$c_row)->getAlignment()->setIndent(2);
			
			$c_col++;
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($c_col, $c_row, $office_id);
			
			$c_col++;
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($c_col, $c_row, $department_name);
			
			$c_col++;
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($c_col, $c_row, $designation);
			
			$c_col++;
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($c_col, $c_row, $client_name);
			
			$c_col++;
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($c_col, $c_row, $process_name);
			
			$c_col++; $current_column = PHPExcel_Cell::stringFromColumnIndex($c_col); $current_cell = $current_column.$c_row; 
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($c_col, $c_row, $l1_supervisor);
			
			$c_col++; $current_column = PHPExcel_Cell::stringFromColumnIndex($c_col); $current_cell = $current_column.$c_row; 
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($c_col, $c_row, $user_status);
			
			$c_col++; $current_column = PHPExcel_Cell::stringFromColumnIndex($c_col); $current_cell = $current_column.$c_row; 
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($c_col, $c_row, $user_phase);
			//$objPHPExcel->getActiveSheet()->getStyle($current_cell)->getAlignment()->setIndent(2);
			
			$nextendingcol = $c_col;
			
			//------ SET DATEWISE DATA
			$latecount = 0;
			$bdate = new DateTime($start_date);	
			$nextendingcol = $c_col;
			$h = $m = $s = 0;
			for($i=1; $i<=$days+1; $i++){
				
				$scheduled_login  = "";
				$login_time_local = "";
				$interval = ""; $extrasign = ""; $colorclass = "";
				
				//$search_row = array_search($token['user_id'], array_column($dayreport[$bdate->format('Y-m-d')],'user_id'));
				//if($search_row != ""){
				//$set_user_array = $dayreport[$bdate->format('Y-m-d')][$search_row];
				
				$set_user_array = $dayreport[$bdate->format('Y-m-d')][$ir];
				$scheduled_login  = $set_user_array['scheduled_login'];
				$login_time_local = $set_user_array['login_time_local'];
				
				
				//--- FOR WORKSHEEET 1
				if($sh == 0){
				/*	
				if(strlen($set_user_array['scheduled_login']) > 5)
				{
					$t1 = strtotime( $set_user_array['scheduled_login'] );
					$t2 = strtotime( $set_user_array['login_time_local'] );
					
					if($t2 > $t1){
						$diff = abs($t2 - $t1);  
						$hours = floor($diff / (60*60));
						$minutes = floor(($diff - $hours*60*60)/ 60);
						$seconds = floor(($diff - $hours*60*60 - $minutes*60));
						$colorclass = "red"; $extrasign = "-";
						$latecount++;
					}
					if($t1 > $t2){
						$diff = abs($t1 - $t2);  
						$hours = floor($diff / (60*60));
						$minutes = floor(($diff - $hours*60*60)/ 60);
						$seconds = floor(($diff - $hours*60*60 - $minutes*60));
					}
					
					if($hours > 0){ $s_Hour =  floor($hours); } else { $s_Hour =  "00"; }
					if($minutes > 0){ $s_Minutes =  floor($minutes); } else { $s_Minutes =  "00"; }
					if($seconds > 0){ $s_Seconds =  floor($seconds); } else { $s_Seconds =  "00"; }
					
					$interval = $extrasign .sprintf('%02d', $s_Hour) .":" .sprintf('%02d', $s_Minutes) .":" .sprintf('%02d',$s_Seconds);
			
				}*/
				
				$interval = $set_user_array['myloginadherence'];
				if(strpos($interval, '.') != ""){ $interval = strstr($interval, '.', true); } 
				else { 
					if((empty($login_time_local)) && ($scheduled_login != "") && (!preg_match('/[0-9]/', $scheduled_login))){ 
						$interval = $scheduled_login; 
					} 
				}
				$fistletter = substr($interval,0,1);
				if($fistletter == "-"){ $colorclass = "red"; $latecount++; }
				
				
				}
				
				
				//--- FOR WORKSHEEET 2
				if($sh == 1){
					if(($set_user_array['logout_by'] == 0) && (!is_null($set_user_array['logout_by']))){ 
						$latecount++; $interval = "System Logout"; 
					}
				}
				
				
				//--- FOR WORKSHEEET 3
				if($sh == 2){
					$interval = $set_user_array['totaltime'];
					if((strlen($set_user_array['scheduled_login']) > 5) && (!empty($interval)))
					{
						if($set_user_array['myinterval'] > $set_user_array['totaltime']){ $latecount++; $colorclass = "red"; }
					}
				}
				
				//}
				
				
				if($sh == 0){
					$c_col++;
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($c_col, $c_row, $scheduled_login);
					
					$c_col++;
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($c_col, $c_row, $login_time_local);
				}
				
				$c_col++;
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($c_col, $c_row, $interval);
				
				if($colorclass != ""){
					$colorArray = array('font'  => array('color' => array('rgb' => 'FF0000')));
					$colorColumn = PHPExcel_Cell::stringFromColumnIndex($c_col);
					$objPHPExcel->getActiveSheet()->getStyle($colorColumn.$c_row)->applyFromArray($colorArray);
				}
				
				$bdate->modify('+1 day');		
			}
			
			$c_col++;
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($c_col, $c_row, $latecount);
			
			$ir++;
			
		}
		
		$lastcolumn = PHPExcel_Cell::stringFromColumnIndex($c_col);
		$objPHPExcel->getActiveSheet()->getStyle("A1:B".$c_row)->applyFromArray($style);
		$objPHPExcel->getActiveSheet()->getStyle("C1:C".$c_row)->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle("D1:".$lastcolumn.$c_row)->applyFromArray($style);
		
		}
        
		$objPHPExcel->setActiveSheetIndex(0);
		
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="adherence_report.xlsx"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->setIncludeCharts(TRUE);

        $objWriter->save('php://output');
		
    }
	
	
	
	
	
	
	
	
	
	
	
	//`````````````````````````````````````````````````````````````````````````````````````````````````````````````````
	//-------------- EXCEL VIEW 2 -----------------------------------------------------------------------------------------
	
	public function adherence_check_2()
    {
		if(check_logged_in())
        {
			//$this->check_access();
			
			$role_id       = get_role_id();
			$current_user  = get_user_id();
			$user_site_id  = get_user_site_id();
			$ses_dept_id   = get_dept_id();
			$ses_office_id = get_user_office_id();
			$is_global_access = get_global_access();
            
			$data['showtype'] = $show_type = 1;
			$data["aside_template"] = $this->aside;
			$data["content_template"] = "attendance/att_adherence.php";
			    
			$data['user_list'] =array();
			$office_id = "";  $start_date = "";	$end_date = ""; $dept_id = "";
			
			$start_date = $this->input->get('start_date');
			$end_date   = $this->input->get('end_date');
			$office_id = $this->input->get('office_id');
			$dept_id = $this->input->get('dept_id');
			$showtype = $this->input->get('showtype');
			$showreport = $this->input->get('showReports');
					
			if($office_id=="")  $office_id = $ses_office_id;
			if($dept_id=="")  $dept_id = $ses_dept_id;
			
			//------ LOCATION LIST
			if($is_global_access==1 || get_dept_folder()=="rta"){
				$data['site_list'] = $this->Common_model->get_sites_for_assign();
				$data['location_list'] = $this->Common_model->get_office_location_list();
			}else{
				$sCond=" Where id = '$user_site_id'";
				$data['site_list'] = $this->Common_model->get_sites_for_assign2($sCond);
				$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
			}
			
			//------ DEPARTMENT LIST
			if($is_global_access=='1' ||  get_role_dir()=="admin" || get_dept_folder()=="hr" || get_dept_folder()=="wfm" || get_dept_folder()=="rta" || get_dept_folder()=="mis" || is_all_dept_access()){
				$data['department_list'] = $this->Common_model->get_department_list();
			}else{
				$data['department_list'] = $this->Common_model->get_department_session($ses_dept_id);
			}
							
			$data['cValue']  = $client_id;
			$data['sValue']  = $site_id;
			$data['oValue']  = $office_id;
			$data['dept_id'] = $dept_id;
			
			$data['start_date'] = $start_date;
			$data['end_date']   = $end_date;
			
			$data['dataViewType'] = "off";
			
			if($showreport == "View"){
				$this->gen_excel_adherence_report_2($start_date, $end_date, $dept_id, $office_id);
			} else {
				$this->load->view('dashboard',$data);
			}				
	   }
	
    }
	
	
	
	
	
	
	
	//----- FUNCTION FOR DAY WISE DATA RECORDS
	private function get_login_data_inday_all_2($getdate, $dept_id, $office_id)
	{
		if($dept_id == "ALL"){ $addextradep = ""; } else { $addextradep = " AND dept_id = '$dept_id'"; }
		if($office_id == "ALL"){ $addextraoffice = ""; } else { $addextraoffice = " AND office_id = '$office_id'"; }
		
		$sqllogin = "SELECT 
					d.user_id, 
					d.logout_by, 
					min(d.login_time_local) as login_time_local,  
					SEC_TO_TIME(SUM(TIMESTAMPDIFF(SECOND,d.login_time_local, d.logout_time_local))) as totaltime, 
					s.shdate as scheduledate, 
					s.scheduled_login, 
					s.scheduled_logout, 
					s.in_time as scheduled_in_time, 
					s.out_time as scheduled_out_time, 
					TIMEDIFF(s.scheduled_logout, s.scheduled_login) as myinterval, 
					CASE 
					WHEN (min(d.login_time_local) > s.scheduled_login) 
					THEN CONCAT('-', TIMEDIFF(min(d.login_time_local), s.scheduled_login))
					ELSE TIMEDIFF(s.scheduled_login, min(d.login_time_local))
					END as myloginadherence
					from logged_in_details as d 
					LEFT JOIN 
					(SELECT user_id, shdate, in_time, out_time, 
					CASE WHEN in_time LIKE '%:%'
					THEN CONCAT(shdate, ' ', in_time,':00')
					ELSE in_time
					END as scheduled_login,
					CASE WHEN (in_time > out_time)
					THEN CONCAT(DATE_ADD(shdate, INTERVAL 1 DAY), ' ', out_time,':00')
					ELSE CONCAT(shdate, ' ', out_time,':00') 
					END as scheduled_logout FROM user_shift_schedule) 
					as s ON 
					s.user_id = d.user_id 
					AND s.shdate = '$getdate'
					WHERE date(d.login_time_local) = '$getdate' 
					AND d.user_id IN (SELECT id from signin WHERE 1 AND status IN (1,4) $addextradep $addextraoffice)
					GROUP BY d.user_id";
		$querylogin = $this->Common_model->get_query_result_array($sqllogin);
		
		
		return $querylogin;
		
	}
	
	
	
	
	
	//--------- EXCEL GENERATE ADHERENCE -------------------------------------//
	
	private function gen_excel_adherence_report_2($start_date, $end_date, $dept_id, $office_id)
    {
        
        //error_reporting(E_ALL);
        //ini_set('display_errors', TRUE);
        //ini_set('display_startup_errors', TRUE);
        require_once APPPATH . 'third_party/PHPExcel.php';
		
		
		//---------- SET DATA
		if($office_id == "ALL") $extraoffice = "";
		else $extraoffice = " AND office_id = '$office_id'";
		
		if($dept_id == "ALL") $extradepartment = "";
		else $extradepartment = " AND dept_id = '$dept_id'";
		
		//--------- USER LIST
		$sqlusers = "SELECT s.id as user_id, s.fusion_id, concat(s.fname, ' ', s.lname) as fullname, 
		s.office_id, d.shname as department_name from signin s 
		LEFT JOIN department d on s.dept_id = d.id
		WHERE 1 AND status IN (1,4) $extraoffice $extradepartment ORDER by s.office_id, fullname";
		$myusers = $query_users = $this->Common_model->get_query_result_array($sqlusers);
			
		//-- DAY WISE DATA ARRAY
		$date1 = new DateTime($start_date);
		$date2 = new DateTime($end_date);
		$days  = $date2->diff($date1)->format('%a');
		$hdate = new DateTime($start_date);
		for($i=1; $i<=$days+1; $i++){
			$dayreport[$hdate->format('Y-m-d')] = $this->get_login_data_inday_all_2($hdate->format('Y-m-d'), $dept_id, $office_id);
			$hdate->modify('+1 day');
		}
		
		//echo "<pre>" .print_r($myusers, true) ."</pre>";
		//echo "<pre>" .print_r($dayreport, true) ."</pre>"; die();
		
		
		/*-----------### CREATE EXCEL ####------------------*/
		
        $objPHPExcel = new PHPExcel();
		
		//---------> CREATE WORKSHEETS
		$titles = array('Login Adherence', 'Auto Logout Count', 'Staffed Time');
		$sheet = 0;
		foreach($titles as $value){
			if($sheet > 0){
				$objPHPExcel->createSheet();
				$objPHPExcel->setActiveSheetIndex($sheet)->setTitle($value);
			}else{
				$objPHPExcel->setActiveSheetIndex(0)->setTitle("$value");
			}
			$sheet++;
		} 
		
		

		for($sh=0;$sh<3;$sh++){
		
        $objPHPExcel->setActiveSheetIndex($sh);
        $objPHPExcel->getActiveSheet()->freezePane('D2');
        $rowCount = 3;
        $style = array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            )
        );
				
		$c_col = "0";
		$c_row = "1";
		
		
		// COLUMNS SET
		$c_row++; $current_column = PHPExcel_Cell::stringFromColumnIndex($c_col); $current_cell = $current_column.$c_row; 
		$objPHPExcel->getActiveSheet()->getColumnDimension($current_column)->setWidth(6);
        $objPHPExcel->getActiveSheet()->SetCellValue($current_cell, '#');
		
		$c_col++; $current_column = PHPExcel_Cell::stringFromColumnIndex($c_col); $current_cell = $current_column.$c_row; 		
		$objPHPExcel->getActiveSheet()->getColumnDimension($current_column)->setWidth(14);
        $objPHPExcel->getActiveSheet()->SetCellValue($current_cell, 'Fusion ID');
		
		$c_col++; $current_column = PHPExcel_Cell::stringFromColumnIndex($c_col); $current_cell = $current_column.$c_row; 
        $objPHPExcel->getActiveSheet()->getColumnDimension($current_column)->setWidth(30);
        $objPHPExcel->getActiveSheet()->SetCellValue($current_cell, 'Name');
		
		$c_col++; $current_column = PHPExcel_Cell::stringFromColumnIndex($c_col); $current_cell = $current_column.$c_row; 
		$objPHPExcel->getActiveSheet()->getColumnDimension($current_column)->setWidth(8);
        $objPHPExcel->getActiveSheet()->SetCellValue($current_cell, 'Site');
		
		$c_col++; $current_column = PHPExcel_Cell::stringFromColumnIndex($c_col); $current_cell = $current_column.$c_row; 
		$objPHPExcel->getActiveSheet()->getColumnDimension($current_column)->setWidth(20);
        $objPHPExcel->getActiveSheet()->SetCellValue($current_cell, 'Department');
		
		$date1 = new DateTime($start_date);
		$date2 = new DateTime($end_date);
		$days  = $date2->diff($date1)->format('%a');
		$hdate = new DateTime($start_date);
		for($i=1; $i<=$days+1; $i++){
		
		
		//--- FOR WORKSHEEET 1
		if($sh == 0){
			$c_col++; $current_column = PHPExcel_Cell::stringFromColumnIndex($c_col); $current_cell = $current_column.$c_row; 
			$objPHPExcel->getActiveSheet()->getColumnDimension($current_column)->setWidth(22);
			$objPHPExcel->getActiveSheet()->SetCellValue($current_cell, 'Rostered Login Time');
			
			$c_col++; $current_column = PHPExcel_Cell::stringFromColumnIndex($c_col); $current_cell = $current_column.$c_row; 
			$objPHPExcel->getActiveSheet()->getColumnDimension($current_column)->setWidth(20);
			$objPHPExcel->getActiveSheet()->SetCellValue($current_cell, 'Actual Login Time');
		}
		
			$c_col++; $current_column = PHPExcel_Cell::stringFromColumnIndex($c_col); $current_cell = $current_column.$c_row; 
			$objPHPExcel->getActiveSheet()->getColumnDimension($current_column)->setWidth(20);
			$objPHPExcel->getActiveSheet()->SetCellValue($current_cell, $hdate->format('d-M-Y'));
			
			$hdate->modify('+1 day');
		}
		
		$lastColName = "Late Login Count";
		if($sh == 1){ $lastColName = "System Logout Count"; }
		if($sh == 2){ $lastColName = "Shortage Count"; }
		
		$c_col++; $current_column = PHPExcel_Cell::stringFromColumnIndex($c_col); $current_cell = $current_column.$c_row; 
		$objPHPExcel->getActiveSheet()->getColumnDimension($current_column)->setWidth(20);
        $objPHPExcel->getActiveSheet()->SetCellValue($current_cell, $lastColName);
				
		// HEADER SET
        $objPHPExcel->getActiveSheet()->getStyle("A1:".$current_column."1")->applyFromArray($style);
        $objPHPExcel->getActiveSheet()->mergeCells("A1:D1");
        $objPHPExcel->getActiveSheet()->getStyle("A1")->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->SetCellValue('A1', $titles[$sh]);
        $objPHPExcel->getActiveSheet()->getStyle("A2:".$current_column."2")->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle("A2:".$current_column."2")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('000000');
		
		$colorArrayWhite = array('font'  => array('color' => array('rgb' => 'FFFFFF')));
		$objPHPExcel->getActiveSheet()->getStyle("A2:".$current_column."2")->applyFromArray($colorArrayWhite);
		$objPHPExcel->getActiveSheet()->getStyle("C2")->getAlignment()->setIndent(2);
		
		$endingcol = $c_col;
		
		// -- SET EXCEL DATA
		$sl = 0;
		$ir = 0;
		$startdate = date('Y-m-d', strtotime($start_date));
        foreach($myusers as $token)
        {
			$sl++;
			$c_row++;
			$fusion_id = $token['fusion_id'];
			$fullname = $token['fullname'];
			$office_id = $token['office_id'];
			$department_name = $token['department_name'];
			
			$c_col = 0;
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($c_col, $c_row, $sl);
			
			$c_col++;
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($c_col, $c_row, $fusion_id);
			
			$c_col++;
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($c_col, $c_row, $fullname);
			$objPHPExcel->getActiveSheet()->getStyle("C".$c_row)->getAlignment()->setIndent(2);
			
			$c_col++;
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($c_col, $c_row, $office_id);
			
			$c_col++;
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($c_col, $c_row, $department_name);
			
			$nextendingcol = $c_col;
			
			//------ SET DATEWISE DATA
			$latecount = 0;
			$bdate = new DateTime($start_date);	
			$nextendingcol = $c_col;
			$h = $m = $s = 0;
			for($i=1; $i<=$days+1; $i++){
				
				$scheduled_login  = "";
				$login_time_local = "";
				$interval = ""; $extrasign = ""; $colorclass = "";$fistletter= "";
				
				$search_row = array_search($token['user_id'], array_column($dayreport[$bdate->format('Y-m-d')],'user_id'));
				if($search_row != ""){
				$set_user_array = $dayreport[$bdate->format('Y-m-d')][$search_row];
				
				//$set_user_array = $dayreport[$bdate->format('Y-m-d')][$ir];
				$scheduled_login  = $set_user_array['scheduled_login'];
				$login_time_local = $set_user_array['login_time_local'];
				
				
				//--- FOR WORKSHEEET 1
				if($sh == 0){
				/*if(strlen($set_user_array['scheduled_login']) > 5)
				{
					$t1 = strtotime( $set_user_array['scheduled_login'] );
					$t2 = strtotime( $set_user_array['login_time_local'] );
					
					if($t2 > $t1){
						$diff = abs($t2 - $t1);  
						$hours = floor($diff / (60*60));
						$minutes = floor(($diff - $hours*60*60)/ 60);
						$seconds = floor(($diff - $hours*60*60 - $minutes*60));
						$colorclass = "red"; $extrasign = "-";
						$latecount++;
					}
					if($t1 > $t2){
						$diff = abs($t1 - $t2);  
						$hours = floor($diff / (60*60));
						$minutes = floor(($diff - $hours*60*60)/ 60);
						$seconds = floor(($diff - $hours*60*60 - $minutes*60));
					}
					
					if($hours > 0){ $s_Hour =  floor($hours); } else { $s_Hour =  "00"; }
					if($minutes > 0){ $s_Minutes =  floor($minutes); } else { $s_Minutes =  "00"; }
					if($seconds > 0){ $s_Seconds =  floor($seconds); } else { $s_Seconds =  "00"; }
					
					$interval = $extrasign .sprintf('%02d', $s_Hour) .":" .sprintf('%02d', $s_Minutes) .":" .sprintf('%02d',$s_Seconds);
			
				}*/
				
				$interval = $set_user_array['myloginadherence'];
				if(strpos($interval, '.') != ""){ $interval = strstr($interval, '.', true); } 
				else { 
					if((empty($login_time_local)) && ($scheduled_login != "") && (!preg_match('/[0-9]/', $scheduled_login))){ 
						$interval = $scheduled_login; 
					} 
				}
				$fistletter = substr($interval,0,1);
				if($fistletter == "-"){ $colorclass = "red"; $latecount++; }
				
				}
				
				
				//--- FOR WORKSHEEET 2
				if($sh == 1){
					if($set_user_array['logout_by'] == 0){ $latecount++; $interval = "System Logout"; }
				}
				
				
				//--- FOR WORKSHEEET 3
				if($sh == 2){
					$interval = $set_user_array['totaltime'];
					if((strlen($set_user_array['scheduled_login']) > 5) && (!empty($interval)))
					{
						if($set_user_array['myinterval'] > $set_user_array['totaltime']){ $colorclass = "red"; $latecount++; }
					}					
				}
				
				}
				
				
				if($sh == 0){
					$c_col++;
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($c_col, $c_row, $scheduled_login);
					
					$c_col++;
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($c_col, $c_row, $login_time_local);
				}
				
				$c_col++;
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($c_col, $c_row, $interval);
				
				if($colorclass != ""){
					$colorArray = array('font'  => array('color' => array('rgb' => 'FF0000')));
					$colorColumn = PHPExcel_Cell::stringFromColumnIndex($c_col);
					$objPHPExcel->getActiveSheet()->getStyle($colorColumn.$c_row)->applyFromArray($colorArray);
				}
				
				$bdate->modify('+1 day');		
			}
			
			$c_col++;
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($c_col, $c_row, $latecount);
			
			$ir++;
			
		}
		
		$lastcolumn = PHPExcel_Cell::stringFromColumnIndex($c_col);
		$objPHPExcel->getActiveSheet()->getStyle("A1:B".$c_row)->applyFromArray($style);
		$objPHPExcel->getActiveSheet()->getStyle("C1:C".$c_row)->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle("D1:".$lastcolumn.$c_row)->applyFromArray($style);
		
		}
        
		$objPHPExcel->setActiveSheetIndex(0);
		
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="adherence_report.xlsx"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->setIncludeCharts(TRUE);

        $objWriter->save('php://output');
		
    }
	
	
/*================================ LOGIN ADHERENCE ENDS ===============================================================================*/


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
	
	
	//===== SIGNIN USER PHASE =======================//
	public function display_user_status($status="", $type="")
	{
		$phaseName = ""; 
		$phaseArr = array(
			'0' => "Term",
			'1' => "Active",
			'2' => "Pre Term",
			'3' => "Suspended",
			'4' => "New",
			'5' => "BENCH-PAID",
			'6' => "BENCH-UNPAID",
			'7' => "Furlough Leave",
			'8' => "Deactivate (Term MANUAL)",
			'9' => "Deactivate",
		);
		foreach($phaseArr as $key => $value){
		  if($key == $status){  $phaseName = $value; }
		}
		if($type == 'array'){ 
			return $phaseArr; 
		} else {
			return $phaseName;
		}		
	}
		
}

?>