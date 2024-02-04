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
		
	 }
	 
    public function index()
    {
	
		if(check_logged_in())
        {
			$this->check_access();
			
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
						//if($dept_id=="")  $dept_id=$ses_dept_id;
												
				
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
					
					//print_r($fullArr);
					
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

				
				if(get_role_dir()=="super" || $is_global_access==1){
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
				
				if(get_role_dir()=="super" || $is_global_access==1){			
						$data['assign_list'] = $this->Common_model->get_tls_for_assign2("");
				}else if(get_role_dir()=="admin"){
					$tl_cnd=" and dept_id='$ses_dept_id' ";
					$data['assign_list'] = $this->Common_model->get_tls_for_assign2($tl_cnd);
				}else{
					$tl_cnd=" and (site_id='$user_site_id' OR office_id='$ses_office_id') ";
					$data['assign_list'] = $this->Common_model->get_tls_for_assign2($tl_cnd);
				}	

				$data['department_list'] = $this->Common_model->get_department_list();	
				$data['sub_department_list'] = $this->Common_model->get_sub_department_list($dept_id);
				
				
							
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
		$this->excel->getActiveSheet()->setCellValue('I2', 'Process');
		if($isLoginTime=="Y"){
			$cell='I2:I3';
			$this->excel->getActiveSheet()->mergeCells($cell);
		}
		$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
		
		$cell='J2';
		$this->excel->getActiveSheet()->setCellValue('J2', 'L1 Supervisor');
		
		if($isLoginTime=="Y"){
			$cell='J2:J3';
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
					$j+=4;
					$r=3;
				}else{
					$j++;
					$r=2;
				}
			}
			
			$isFirst=false;
			
			if($allRowDone==false) $j=-1;
						
			$r++;
			
			$pevDate=$rdate;
			
			$disposition=$row['disposition'];
			$logged_in_hours = $row['logged_in_hours'];
			
			
			
			$bg_style=$style_def;
			
			$att="";
			
			$isProperLogout = 'Y';
						
			$work_time=$logged_in_hours;
			$office_id = $row['office_id'];
			$todayLoginTime = $row['todayLoginTime'] ;
			$todayLoginTime_local= ConvServerToLocalAny($todayLoginTime,$office_id);
			
			$is_logged_in = $row['is_logged_in'];
								
			$flogin_time = $row['flogin_time'];
			$flogin_time_local = $row['flogin_time_local'];
			
			$logout_time=$row['logout_time'];
			$logout_time_local=$row['logout_time_local'];
			
			$tBrkTime = $row['tBrkTime'];
			$ldBrkTime = $row['ldBrkTime'];
							
			
			if($work_time == 0){
				$tBrkTime = 0;
				$ldBrkTime = 0;
			}
			
			$total_break=$tBrkTime+$ldBrkTime;
			
			if($isLoginTime!="Y"){
			
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
					if($rdate < $row['doj']){
						$bg_style=$style_gray;
						$att = ''; 
					}else $att = 'Absent'; 
				}
				
			}else{
																			
				$net_work_time=gmdate('H:i:s',$work_time);
				$total_break = gmdate('H:i:s',$total_break);
				
				if($disposition!="" && $logout_time=="")$logout_time = $disposition;
				if($disposition!="" && $logout_time=="")$logout_time_local = $disposition;
			}
			
			
			if($is_logged_in == '1'){
				
				
				$todayLoginArray = explode(" ",$todayLoginTime_local);
				
				if($rdate == $todayLoginArray[0]){
					
					$flogin_time = $todayLoginTime;
					$flogin_time_local = $todayLoginTime_local;
					
					$ldBrkTime="";
					$tBrkTime= "";
					$total_break=="";
					$net_work_time="";
										
					$disposition="online";
					$logout_time = "online";
					$logout_time_local = "online";
					$att = "online";
										
				}
			}
			
			
			////////// For System Logout /////////////////////
			if($row['logout_by']== "0" ){
				//$work_time=0;
				//$logout_time="";
				//$logout_time_local="";
				$isProperLogout = 'N';
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
				$this->excel->getActiveSheet()->setCellValue($cell, $row['process_name']);
				$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_def_left );
				
				$cell=$letters[++$j].$r;
				//echo $cell .">>";
				$this->excel->getActiveSheet()->setCellValue($cell, $row['asign_tl']);
				$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_def_left );
				
				if($isLoginTime=="Y"){
				
					$cell=$letters[++$j]."2";
					$this->excel->getActiveSheet()->setCellValue($cell, $row['rDate']);
					$cell=$letters[$j]."2" .":". $letters[($j+3)]."2";
					$this->excel->getActiveSheet()->mergeCells($cell);
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
					
					
					$cell=$letters[$j]."3";
					$this->excel->getActiveSheet()->setCellValue($cell, "IN");
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
					
					$cell=$letters[($j+1)]."3";
					$this->excel->getActiveSheet()->setCellValue($cell, "OUT");
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
					
					$cell=$letters[($j+2)]."3";
					$this->excel->getActiveSheet()->setCellValue($cell, "Break Time");
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
										
					$cell=$letters[($j+3)]."3";
					$this->excel->getActiveSheet()->setCellValue($cell, "Work Time");
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
					
					$cell=$letters[$j].$r;
					$this->excel->getActiveSheet()->setCellValue($cell, $flogin_time_local);
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $bg_style );
										
					$cell=$letters[($j+1)].$r;
					$this->excel->getActiveSheet()->setCellValue($cell, $logout_time_local);
					
					if ($isProperLogout == 'N')
						$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray($style_syslog);
					else
						$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray($bg_style);
					
					$cell=$letters[($j+2)].$r;
					$this->excel->getActiveSheet()->setCellValue($cell, $total_break);
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $bg_style );
					
					$cell=$letters[($j+3)].$r;
					$this->excel->getActiveSheet()->setCellValue($cell, $net_work_time);
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $bg_style );
										
				}else{
					$cell=$letters[++$j]."2";
					$this->excel->getActiveSheet()->setCellValue($cell, $row['rDate']);
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
					
					$cell=$letters[$j].$r;
					//echo $cell ."<br>";
					$this->excel->getActiveSheet()->setCellValue($cell, $att);
					
					if ($isProperLogout == 'N')
						$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray($style_syslog);
					else
						$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray($bg_style);
					
					
				}
				
			}else{
								
				if($isLoginTime=="Y"){
				
					$cell=$letters[$j]."2";
					$this->excel->getActiveSheet()->setCellValue($cell, $row['rDate']);
					$cell=$letters[$j]."2" .":". $letters[($j+3)]."2";
					$this->excel->getActiveSheet()->mergeCells($cell);
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
				
					
					$cell=$letters[$j]."3";
					$this->excel->getActiveSheet()->setCellValue($cell, "IN");
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
					
					$cell=$letters[($j+1)]."3";
					$this->excel->getActiveSheet()->setCellValue($cell, "OUT");
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
					
					$cell=$letters[($j+2)]."3";
					$this->excel->getActiveSheet()->setCellValue($cell, "Break Time");
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
										
					$cell=$letters[($j+3)]."3";
					$this->excel->getActiveSheet()->setCellValue($cell, "Work Time");
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
					
					$cell=$letters[$j].$r;
					$this->excel->getActiveSheet()->setCellValue($cell, $flogin_time_local);
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $bg_style );
					
					$cell=$letters[($j+1)].$r;
					$this->excel->getActiveSheet()->setCellValue($cell, $logout_time_local);
					
					if ($isProperLogout == 'N')
						$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray($style_syslog);
					else
						$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray($bg_style);
					
					$cell=$letters[($j+2)].$r;
					$this->excel->getActiveSheet()->setCellValue($cell, $total_break);
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $bg_style );
					
					$cell=$letters[($j+3)].$r;
					$this->excel->getActiveSheet()->setCellValue($cell, $net_work_time);
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $bg_style );
					
				}else{
					
					$cell=$letters[$j]."2";
					$this->excel->getActiveSheet()->setCellValue($cell, $row['rDate']);
					$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray( $style_header );
				
					$cell=$letters[$j].$r;
					//echo $cell."<br>";
					$this->excel->getActiveSheet()->setCellValue($cell, $att);
					if ($isProperLogout == 'N')
						$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray($style_syslog);
					else
						$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray($bg_style);
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
						
			$this->check_access();
			
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
						//if($dept_id=="")  $dept_id=$ses_dept_id;
					
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
								
				if(get_role_dir()=="super" || $is_global_access==1){
					$data['site_list'] = $this->Common_model->get_sites_for_assign();
					$data['location_list'] = $this->Common_model->get_office_location_list();
				}else{
					$sCond=" Where id = '$user_site_id'";
					$data['site_list'] = $this->Common_model->get_sites_for_assign2($sCond);
					$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
				}
				
				$data['department_list'] = $this->Common_model->get_department_list();	

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
					$tl_cnd=" and (site_id='$user_site_id' OR office_id='$ses_office_id') ";
					$data['assign_list'] = $this->Common_model->get_tls_for_assign2($tl_cnd);
				}
				
				$data['department_list'] = $this->Common_model->get_department_list();	
				$data['sub_department_list'] = $this->Common_model->get_sub_department_list($dept_id);
								
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
			$this->check_access();
			
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
				
				if(get_role_dir()=="super" || $is_global_access==1){
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
					
					
					$prv_term_cond=" (Select user_id from terminate_users where cast(terms_date as date)<'$currDate'  OR rejon_date>'$currDate' ) ";
					
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
	
}

?>