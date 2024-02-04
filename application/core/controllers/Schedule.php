<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Schedule extends CI_Controller {
    
    /////////////////////////////////////////////////////////////////////////////////////////////
    // INDEX PAGE
    /////////////////////////////////////////////////////////////////////////////////////////////
    
	 function __construct() {
		parent::__construct();
		
		$this->load->model('Common_model');
		$this->load->model('user_model');
	 }
	 
	 
    public function index()
    {
        if(check_logged_in()){
			
			$user_site_id = get_user_site_id();
			$user_office_id=get_user_office_id();
			$ses_dept_id=get_dept_id();
					
			$ses_dept_id = strtolower($ses_dept_id);
			
			$is_global_access=get_global_access();
			
			$user_oth_office = get_user_oth_office();
			
			$role_id= get_role_id();
			$current_user = get_user_id();
			
			$data["user_site_id"]=$user_site_id;
			$data["user_role_id"]=$role_id;
			$data["user_site_id"]=$user_site_id;
			
			if( get_role_dir()!="agent") $data["aside_template"] = get_aside_template();
			else $data["aside_template"] = "schedule/aside.php";
			
			$data["content_template"] = "schedule/actual_screen.php";
						
			$oValue = trim($this->input->post('office_id'));
			if($oValue=="") $oValue = trim($this->input->get('office_id'));
			if($oValue=="")  $oValue=$user_office_id;
			
			$dValue = trim($this->input->post('dept_id'));
			if($dValue=="") $dValue = trim($this->input->get('dept_id'));
			if($dValue=="")  $dValue=$ses_dept_id;
			
			 $cValue = trim($this->input->post('client_id'));
			if($cValue=="") $cValue = trim($this->input->get('client_id'));
			
            $pValue = trim($this->input->post('process_id'));
			if($pValue=="") $pValue = trim($this->input->get('process_id'));
			
			$aValue = trim($this->input->post('agent_id'));
			if($aValue=="") $aValue = trim($this->input->get('agent_id'));
			
			$shdValue = trim($this->input->post('shDay'));
			if($shdValue=="") $shdValue = trim($this->input->get('shDay'));
			
			$start_date = trim($this->input->post('start_date'));
			if($start_date=="") $start_date = trim($this->input->get('start_date'));
			
			$end_date = trim($this->input->post('end_date'));
			if($end_date=="") $end_date = trim($this->input->get('end_date'));
			if($start_date==""){
				$start_date = GetLocalDate();
				$end_date = GetLocalDate();
			}
			/*
			$sch_range = trim($this->input->post('sch_range'));
			if($sch_range=="") $sch_range = trim($this->input->get('sch_range'));
			$sch_range_arr=explode("#",$sch_range);
			*/
			
			$data['oValue']=$oValue;
			$data['pValue']=$pValue;
			$data['cValue']=$cValue;
			$data['aValue']=$aValue;
			$data['dValue']=$dValue;
			//$data['sch_range']=$sch_range;
			$data['shdValue']=$shdValue;
			$data['start_date']=$start_date;
			$data['end_date']=$end_date;
			
			$_filterCond="";
			
			if($oValue!="ALL" && $oValue!="") $_filterCond = " And office_id='".$oValue."'";
			if($dValue!="ALL" && $dValue!="") $_filterCond .= " And dept_id='".$dValue."'";
			
			//if($pValue!="ALL" && $pValue!="") $_filterCond .= " And process_id='".$pValue."'";
			if($cValue!="ALL" && $cValue!="") $_filterCond .= " And is_assign_client (b.id,$cValue)";
			if($pValue!="ALL" && $pValue!="" && !empty($pValue)) $_filterCond .= " And is_assign_process (b.id,$pValue)";
						
			if($shdValue!="ALL" && $shdValue!="") $_filterCond .= " And shday='".$shdValue."'";
			
			if($aValue!="ALL" && $aValue!="") $_filterCond = " And (b.fusion_id='".$aValue."' OR b.omuid='".$aValue."')";
			
			$data['department_list'] = $this->Common_model->get_department_list();
			
			$data['location_list'] = $this->Common_model->get_office_location_list();
			
			$data['client_list'] = $this->Common_model->get_client_list();	
			
			if($is_global_access==1  || get_dept_folder()=="rta" || get_dept_folder()=="wfm" ){ 
			
				$data['location_list'] = $this->Common_model->get_office_location_list();
				$data['site_list'] = $this->Common_model->get_sites_for_assign();
			}else{
				$sCond=" Where id = '$user_site_id'";
				$data['site_list'] = $this->Common_model->get_sites_for_assign2($sCond);
				$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
			}
			
			$data['process_list'] = $this->Common_model->get_process_for_assign();
			
			if(!empty($cValue) && $cValue!="ALL"){
				$sql = "SELECT * from process WHERE client_id = '$cValue'";
				$query = $this->db->query($sql);
				$myProcessList = $query->result();
				$data['process_list'] = $myProcessList;
			}
			
			
			if($is_global_access=='1' || get_dept_folder()=="rta" || get_dept_folder()=="wfm" ) $cond="";
			else if( is_access_schedule_update() || is_access_schedule_upload())
				$cond=" and (office_id='$user_office_id' OR '$user_oth_office' like CONCAT('%',office_id,'%') ) ";
			else if(get_role_dir()=="tl" || get_role_dir()=="trainer"){
				
				//$cond=" and assigned_to = '".$current_user."'";
				
				$cond = " and (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where  assigned_to ='$current_user')) ";
				
			}else if(get_role_dir()=="agent")
				$cond=" and user_id='$current_user'";
			else $cond=" and (office_id='$user_office_id' OR '$user_oth_office' like CONCAT('%',office_id,'%') ) ";
			
			/*
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
			
			$data["sch_date_range"]= mysql2mmddyy($shMonDate) . " To " . mysql2mmddyy($shSunDate);
			*/
			
			$qSql="Select a.*,b.fusion_id,b.omuid,xpoid,fname,lname,dept_id,office_id,site_id,role_id,status, get_client_names(b.id) as client_name, get_process_names(b.id) as process_name, (Select shname from department s where s.id=b.dept_id) as dept_name, (Select CONCAT(fname,' ' ,lname) from signin x where x.id=b.assigned_to) as asign_tl, (Select concat(fname, ' ', lname) as name from signin s where s.id= a.update_by) as update_by_name ,(Select name from role x  where x.id=b.role_id) as role_name from user_shift_schedule a, signin b where shdate>='$start_date' and shdate<='$end_date' and a.user_id=b.id and status in (1,4) $cond $_filterCond order by user_id, a.shdate, a.id";
			
			//echo $qSql;
			
			$data["sch_list"]= $this->Common_model->get_query_result_array($qSql);
			
			//$qSql="Select CONCAT(DATE_FORMAT(start_date,'%m-%d-%Y'),' To ' ,DATE_FORMAT(end_date,'%m-%d-%Y')) as value from user_shift_schedule limit 1";
			//$data["sch_date_range"]= $this->Common_model->get_single_value($qSql);
			
			if( $oValue == "ALL") $scond = "";
			else  $scond = " where substr(fusion_id,2,3) = '$oValue'";
			$qSql="Select start_date,end_date,CONCAT(DATE_FORMAT(start_date,'%m-%d-%Y'),' To ' ,DATE_FORMAT(end_date,'%m-%d-%Y')) as shrange from user_shift_schedule  $scond group by start_date order by start_date desc";
			//echo $qSql;
			
			//$data["all_sch_date_range"]= $this->Common_model->get_query_result_array($qSql);
			
			$dn_param='sd='.$start_date.'&ed='.$end_date.'&oth='.$oValue; 
			$dn_link = "";
			if( count($data["sch_list"]) > 0 ){
			
				$this->create_CSV($data["sch_list"]);
				$dn_link = base_url()."schedule/downloadCsv";
			}
			
			$data['dn_param']=$dn_param;
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
		$LogMSG="Download schedule";
		log_message('FEMS', $LOMid.' - ' . $Lfull_name . ' | '.$LogMSG );
		//////////
		
		$filename = "./assets/reports/schedule".get_user_id().".csv";
		$newfile="schedule-".$s_date."to".$e_date. "-" .$oth.".csv";
		header('Content-Disposition: attachment;  filename="'.$newfile.'"');
		readfile($filename);
	}
	
	
	public function create_CSV($rr)
	{
			
		$filename = "./assets/reports/schedule".get_user_id().".csv";
		
		$fopen = fopen($filename,"w+");
	
			
		$header = array("Date", "Day", "Fusion ID", "Site/XPOID", "Employee Name", "Dept", "Designation", "Client Name", "Process", "L1 Supervisor", "In Time", "Break 1", "Lunch", "Break 2", "End Time");
		
		$row = "";
		
		foreach($header as $data) $row .= ''.$data.',';
		
		fwrite($fopen,rtrim($row,",")."\r\n");

		foreach($rr as $user)
		{	
					
			$omuid= $user['omuid'];
			if($user['office_id']=="KOL") $omuid = $user['xpoid'];
			
			$header = array("Date", "Day", "Fusion ID", "Site/XPOID", "Employee Name", "Dept", "Designation", "Client Name", "Process", "L1 Supervisor", "In Time", "Break 1", "Lunch", "Break 2", "End Time");
			
			
			$row = '"'.$user['shdate'].'",';
			$row .= '"'.$user['shday'].'",'; 
			$row .= '"'.$user['fusion_id'].'",'; 
			$row .= '"'.$omuid.'",'; 
			$row .= '"'.$user['fname'] . " ". $user['lname'].'",'; 
			$row .= '"'.$user['dept_name'].'",'; 
			$row .= '"'.$user['role_name'].'",'; 
			$row .= '"'.$user['client_name'].'",'; 
			$row .= '"'.$user['process_name'].'",'; 
			$row .= '"'.$user['asign_tl'].'",'; 
			
			$row .= '"'.$user['in_time'].'",'; 
			$row .= '"'.$user['break1'].'",'; 
			$row .= '"'.$user['lunch'].'",'; 
			$row .= '"'.$user['break2'].'",'; 
			$row .= '"'.$user['out_time'].'",'; 
			$row .= '"'. $user['update_by_name'] .'"'; 
			
			fwrite($fopen,$row."\r\n");
		}
		
		fclose($fopen);
		
	}
	
	
	
	
	public function upload_schedule()
    {
        if(check_logged_in())
        {
			$user_site_id= get_user_site_id();
			$role_id= get_role_id();
			
            if( get_role_dir()!="agent") $data["aside_template"] = get_aside_template();
			else $data["aside_template"] = "schedule/aside.php";
			
            $data["content_template"] = "schedule/upload.php";
			
            $data["error"] = '';  
			$this->load->view('dashboard',$data);			 
			   
		}
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
					
					$ret[]= $this->Import_excel_file($fileName,$sdate,$edate);
					
					
				}
				else  //Multiple files, file[]
				{
				  $fileCount = count($_FILES["myfile"]["name"]);
				  for($i=0; $i < $fileCount; $i++)
				  {
					//$fileName = time().$_FILES["myfile"]["name"][$i];
					$fileName = time().str_replace(' ','',$_FILES["myfile"]["name"]);
					
					move_uploaded_file($_FILES["myfile"]["tmp_name"][$i],$output_dir.$fileName);
					
					$ret[]= $this->Import_excel_file($fileName,$sdate,$edate);
					
				  }
				
				}
			}else{
					$ret[]="error";
					
			}
			
			echo json_encode($ret);
			
		}
   }
  

  private function Import_excel_file($fn,$sdate,$edate)
   {
		
		$retval="";
		
		if(check_logged_in())
        {
			//$timezoneArray = $this->get_timezone_array();
			$errorMsg = "";
			$log=get_logs();
			$current_user = get_user_id();
			
			log_message('FEMS',  ' Schedule Upload Log:  '.$log );
			
			try{
				
				$sdate=mmddyy2mysql($sdate);
				$edate=mmddyy2mysql($edate);
				
				$dayDateArray=getDayDateArray($sdate,$edate);
							
				$file_name = "./uploads/".$fn;
				
				$this->load->library('excel');
				$inputFileType = PHPExcel_IOFactory::identify($file_name);
				$objReader = PHPExcel_IOFactory::createReader($inputFileType);
				$objReader->setReadDataOnly(true);
				
				$objPHPExcel = $objReader->load($file_name);
				$html ="";
				
				$ii=1;
				
				$this->db->trans_begin();
				
				$error_message="";
				$error_sheet_title="";
				$error_row="";
				$hasErrorOnExcel=false;
				
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
					
					$errorMsg .= "<br/>".$text."<br/>";
					
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
					$omid_index=0;
					$fusion_index=0;
					$day_index=0;
					$name_index=0;
					$timezone_index=0;
					
					for ($col = 0; $col <= $highestColumnIndex; $col++) {
					
						$cell = $worksheet->getCellByColumnAndRow($col, $row);
						$val = $cell->getValue();
						$val=trim($val);	
						
						$errorMsg .= " ,".$val."";
						
						if(strtoupper($val) =="FUSION ID" || strtoupper($val) =="FUSIONID" || strtoupper($val) =="FUSION_ID" ){
							
							$col_indexs .=",".$col;
							$fusion_index=$col;
						
						}else if(strtoupper($val) =="DAYS" || strtoupper($val) =="DAY"){
							
							$col_indexs .=",".$col;
							$day_index=$col;
							
						}else if(strtoupper($val) =="NAME" || strtoupper($val) =="NAMES"){
							
							$col_indexs .=",".$col;
							$name_index=$col;
							
						}
						else if(strtoupper($val) =="START TIME" || strtoupper($val) =="IN TIME"){
							
							$col_indexs .=",".$col;
							$start_time_index=$col;
							
						}
						else if(strtoupper($val) =="END TIME" || strtoupper($val) =="OUT TIME"){
							
							$col_indexs .=",".$col;
							$end_time_index=$col;
							
						}else if(strtoupper($val) =="TIMEZONE"){
							
							$col_indexs .=",".$col;
							$timezone_index=$col;
							
						}
						else if (strtoupper($val)=="BREAK 1" || strtoupper($val)=="BREAK1" || strtoupper($val)=="BREAK-1" || strtoupper($val)=="LUNCH" || strtoupper($val)=="BREAK 2" || strtoupper($val)=="BREAK2"  || strtoupper($val)=="BREAK-2") $col_indexs .=",".$col;
						
							
					}
					
					$col_indexs=substr($col_indexs,1);
					$col_ind_arry=explode(",",$col_indexs);
					$errorMsg .= "<br/>".$timezone_index."<br/>";
									
					$jj=0;
					
					for ($row = 3; $row <= $highestRow; $row++){
						
						//$html .= '<tr>';
						
						$jj++;
						
						$iData1st="";
						$iData="";
						
						$found_uid=false;
						$found_uname=false;
						$found_startime=false;
						$found_endime=false;
						$found_timezone = false;
						
						$omid="";
						$fusion_id="";
						$user_id="";
						$user_fname = ""; $user_lname = ""; $user_fullname = ""; $fusion_name = "";
						$sh_day="";
						$user_intime="";
						$user_outtime="";						
						$user_timezone="";
											
						for ($col = 0; $col <= $highestColumnIndex; $col++) {
						
							$cell = $worksheet->getCellByColumnAndRow($col, $row);
							
							if (in_array($col, $col_ind_arry)){
								
								if($col==$fusion_index){
									
									$val = $cell->getValue();
									$val=trim($val);
									$fusion_id=$val;
									$fusion_id = preg_replace("/[^A-Za-z0-9]/", "", $fusion_id);
									
									if($found_uid==false){
																			
										if($fusion_id!="" && $fusion_id!="-"){
										
											$qSql="select * from signin where fusion_id ='$fusion_id'";
											$user_details=$this->Common_model->get_query_row_array($qSql);
											
											$user_id = $user_details['id'];
											$user_fname = $user_details['fname'];
											$user_lname = $user_details['lname'];
											$user_fullname = $user_details['fname']. " ". $user_details['lname'];
											$DisplayDbName = strtoupper($user_fullname);
											
											$user_fullname = preg_replace("/[^A-Za-z0-9]/", "", $user_fullname);
											
											$found_uid=true;
											$errorMsg .= $fusion_id ." / " .$user_fullname;
											if($user_id!=""){
												
												//$qSql="select omuid as value from signin where fusion_id ='$fusion_id'";
												//$omid_db=$this->Common_model->get_single_value($qSql);
												
												$iData1st = "'".$user_id."','".$fusion_id."','".$sdate."','".$edate."','".$current_user."'";
												$found_uid=true;
												if((strtoupper($user_fullname) == strtoupper($fusion_name)) && $fusion_name != "")
												{
													$found_uname=true;
												}
												
												
											}
										}
									}
									
								}else if($col==$day_index){
									$val = $cell->getValue();
									$val=trim($val);
									$val = preg_replace("/[^A-Za-z0-9]/", "", $val);
									$val = substr($val,0,3);
									$sh_day=$val;
									
									$iData .= ",'".$val."'";
									
								}
								else if($col==$name_index){
									$val = $cell->getValue();
									$val=trim($val);
									$DisplayExcelName=strtoupper($val);
									$val = preg_replace("/[^A-Za-z0-9]/", "", $val);
									$fusion_name = $val;
									

									if($found_uid==true){
										
										if((strtoupper($user_fullname) == strtoupper($fusion_name)) && $fusion_name != "")
										{
											$found_uname=true;
										}
									}								
								}
								else if($col==$start_time_index){
									$val = PHPExcel_Style_NumberFormat::toFormattedString($cell->getCalculatedValue(), 'hh:mm');
									
									$val=trim($val);
									$val = preg_replace("/[^A-Za-z0-9:]/", "", $val);
									if($val=="00:00") $val= "23:59";
									if($val != ""){ 
										$found_startime = true;
										$user_intime = $val;
										$iData .= ",'".$val."'";
									}
								}
								else if($col==$end_time_index){
									$val = PHPExcel_Style_NumberFormat::toFormattedString($cell->getCalculatedValue(), 'hh:mm');
									
									$val=trim($val);
									$val = preg_replace("/[^A-Za-z0-9:]/", "", $val);
									if($val=="00:00") $val= "23:59";
									if($val != ""){ 
										$found_endime = true;
										$user_outtime = $val;
										$iData .= ",'".$val."'";
									}								
								}
								else if($col==$timezone_index){
									$val = $cell->getValue();
									$val=trim($val);
									$errorMsg .= "T-".$val;
									if(!empty($val)){
										$user_timezone = 1;
										if(strtolower($val) == "est"){ $user_timezone = 0; }
										$found_timezone = true;									
									}
								}
								else{
									
									//$val = PHPExcel_Style_NumberFormat::toFormattedString($cell->getCalculatedValue(), 'hh:mm AM/PM');
									$val = PHPExcel_Style_NumberFormat::toFormattedString($cell->getCalculatedValue(), 'hh:mm');
									
									$val=trim($val);
									$val = preg_replace("/[^A-Za-z0-9:]/", "", $val);
									if($val=="00:00") $val= "23:59";
									$iData .= ",'".$val."'";
									
								}
															
							}else{
								
								//log_message('FEMS',  ' Not In Array Data col : '.$col);

							}
							
						}
						
						//$iData=substr($iData,1);
						
						log_message('FEMS',  ' iData : '.$jj." -> ".$fusion_id. " >> " . " $user_id >> " .$iData );
						
						if($found_uid==true && $user_id!="" && $found_uname==true && $found_endime == true && $found_startime == true && $found_timezone == true){
							
							$iSql="";
							$found_uid=false;
							$found_uname=false;
							$found_startime=false;
							$found_endime=false;
							$found_timezone=false;
							
							try{
															
								$shdate=$dayDateArray[strtoupper($sh_day)];
								
								$rSql="REPLACE INTO user_shift_schedule_archive (SELECT * FROM user_shift_schedule where user_id='$user_id' and shday='$sh_day')";
								
								//log_message('FEMS',  ' INSERT:  '.$jj." -> ".$rSql );
								
								$this->db->query($rSql);
								
								$iSql="REPLACE INTO user_shift_schedule (user_id,fusion_id, start_date, end_date, update_by, shday, in_time, break1, lunch, break2, out_time, shdate, log, is_local) Values(".$iData1st.$iData.",'$shdate','$log', '$user_timezone');";
								
								log_message('FEMS',  ' INSERT:  '.$jj." -> ".$iSql );
								
								$this->db->query($iSql);
								
								//$errorMsg .= "<br/>".$rSql."<br/>".$iSql."</br><br/>";
								//$hasErrorOnExcel=true;
								//$error_message .= $errorMsg;
								
								
							}catch(Exception $ex){
								
								log_message('FEMS',  'Caught exception: '. $ex->getMessage());
								log_message('FEMS',  ' Error:  '.$jj." -> ".$fusion_id. " >> " . " $user_id >> " .$iSql );
								
								$error_message=$ex->getMessage();
								$error_sheet_title=$worksheetTitle;
								$error_row=$row;
								$hasErrorOnExcel=true;
								break;
								
				
								
							}
							
						}else{
							
							$error_message="Blank Cell or Invalid Schedule Data";
							if($found_uid==true){ $error_message .= " for Fusion ID : " .$fusion_id; }
							if($found_uid==true && $user_id==""){ $error_message="Invalid Fusion ID - " .$fusion_id; }
							if($found_uid==true && $user_id!="" && $found_uname==false){
								$error_message="Invalid Name for Fusion ID " .$fusion_id ." - Correct : " .$DisplayDbName ." - In Excel : " .$DisplayExcelName;
							}
							if($found_uname==true && $found_startime == false){ $error_message="Invalid Schedule Start Time - " .$user_intime; }							
							if($found_uname==true && $found_startime == true && $found_endime == false){ $error_message="Invalid Schedule End Time - " .$user_outtime; }
							if($found_timezone==false){ $error_message="Timezone not found. You are still using the old format. Please upload using new format."; }
							//$error_message .= $errorMsg;
									
							$error_sheet_title=$worksheetTitle;
							$error_row=$row;
							$hasErrorOnExcel=true;
							break;
							
							$iSql="";
							
						}
						
						
					}//end row
					
					log_message('FEMS',  ' INFO Total Record :  '.$jj );
					
					//$html .= '</table>';
					
					if($hasErrorOnExcel==true) break;
						
				} //worksheet
				
				unlink($file_name);
				
					
					
				$this->db->trans_complete();
				
				if($this->db->trans_status() === FALSE || $hasErrorOnExcel==true){
					$this->db->trans_rollback();
				
					$ermsg="Error On  ".$error_sheet_title. " Sheet, Row No: ". $error_row. " <br>".$error_message; 		
					$retval= "error##".$ermsg;
					
				}else{
					$this->db->trans_commit();
					
					$retval= "done##".$fn;
				}
						
			}catch(Exception $e){
				
				log_message('FEMS',  'Caught exception: ',  $e->getMessage());
				
				$newfn="error##".$fn;
				$new_file_name = "./uploads/".$newfn;
				rename($file_name , $new_file_name);
				
				$retval= "error##".$fn."-".$e->getMessage();
			}
			
			
			//////////////////////	
				
			//$rSql="REPLACE INTO user_shift_schedule_archive (SELECT * FROM user_shift_schedule where start_date<='$sdate' and end_date<='$sdate' )";
			//$this->db->query($rSql);
			//$dSql="DELETE FROM user_shift_schedule where start_date<='$sdate' and end_date<='$sdate'";
			//$this->db->query($dSql);
			
			/////////////
			return $retval;
			
		}else{
			return "SessionError";
		}
		
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
			
			$update_date = CurrMySqlDate();
			$update_by = get_user_id();
			
			$shid = trim($this->input->post('shid'));
			$user_id = trim($this->input->post('user_id'));
			
			$shday = trim($this->input->post('shday'));
			$in_time = trim($this->input->post('in_time'));
			
			$break1 = trim($this->input->post('break1'));
			$lunch = trim($this->input->post('lunch'));
			
			$break2 = trim($this->input->post('break2'));
			$out_time = trim($this->input->post('out_time'));
			
			if($shid!="" && $user_id!=""){
				
				$uSql="UPDATE user_shift_schedule set in_time='$in_time', break1='$break1', lunch='$lunch', break2='$break2', out_time='$out_time', update_date='$update_date', update_by='$update_by' WHERE id='$shid' and user_id='$user_id'";
				
				$this->db->query($uSql);
				echo "done";
			}else{
				echo "error";
			}
		}
   }
   
   
   public function deleteSchedule()
	{
		if(check_logged_in())
		{
			$shid = trim($this->input->post('shid'));
			
			if($shid!=""){
				$this->db->delete('user_shift_schedule', array('id' => $shid)); 
				$ans="done";
			}else{
				$ans="error";
			}
			echo $ans;
		}
	}

   
   
   public function get_date_range_screen()
   {
		$form_data = $this->input->post();
		if($form_data['office_id'] != 'ALL')
		{
			$query = "  where substr(fusion_id,2,3) = '".$form_data['office_id']."'";
		}
		else
		{
			$query = "";
		}
		$qSql= $this->db->query("Select start_date,end_date,CONCAT(DATE_FORMAT(start_date,'%m-%d-%Y'),' To ' ,DATE_FORMAT(end_date,'%m-%d-%Y')) as shrange from user_shift_schedule ".$query." group by start_date order by start_date desc");
		if($qSql->num_rows() > 0)
		{
			$response['stat'] = true;
			$response['data'] = $qSql->result_object();
		}
		else
		{
			$response['stat'] = false;
		}
		echo json_encode($response);
   }
   
    
	
	//============== SCHEDULE ROUTINE CHECK SUBMISSION ===================================//
	public function schedule_ops_review_list(){
		if(check_logged_in())
		{
			$user_site_id 	= 	get_user_site_id();
			$user_office_id	=	get_user_office_id();
			$ses_dept_id	=	get_dept_id();		
			$is_global_access=get_global_access();			
			$user_oth_office = get_user_oth_office();
			
			$role_id= get_role_id();
			$current_user = get_user_id();
			
			$data["user_site_id"]=$user_site_id;
			$data["user_role_id"]=$role_id;
			$data["user_site_id"]=$user_site_id;
			
			if( get_role_dir()!="agent") $data["aside_template"] = get_aside_template();
			else $data["aside_template"] = "schedule/aside.php";			
			$data["content_template"] = "schedule/ops_review.php";
			
			// SET FILTER PARAMETERS
			$oValue = $user_office_id;
			$dValue = $ses_dept_id;
			$aValue = "";
			$_filterCond = "";
			
			// DROPDOWN LIST
			$data['department_list'] = $this->Common_model->get_department_list();
			$data['location_list'] = $this->Common_model->get_office_location_list();
			
			if($is_global_access==1  || get_dept_folder()=="rta" || get_dept_folder()=="wfm" ){			
				$data['location_list'] = $this->Common_model->get_office_location_list();
				$data['site_list'] = $this->Common_model->get_sites_for_assign();
				$dValue = "ALL";
			} else {
				$sCond=" Where id = '$user_site_id'";
				$data['site_list'] = $this->Common_model->get_sites_for_assign2($sCond);
				$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
			}
			
			
			// GET L1 & L2 SUPERVIOSR ACCESS ID FILTER
			//get_role_dir()=="tl" || get_role_dir()=="manager" || get_role_dir()=="trainer"
			if((get_dept_folder() == "operations") && get_global_access() == '0')
			{
				$_filterCond .= " AND (l1.id = '$current_user' || l2.id = '$current_user') ";
			}
			
			// GET SEARCH PARAMETERS
			$oGetValue = $this->input->get('office_id');
			$dGetValue = $this->input->get('dept_id');
			$aGetValue = $this->input->get('agent_id');			
			$data['oValue'] = $oValue;
			if($oGetValue != "" && $oGetValue != "ALL")
			{
				$oValue = $oGetValue;
				$_filterCond .= " AND s.office_id = '$oValue' ";
			}
			if($dGetValue != "" && $dGetValue != "ALL")
			{
				$dValue = $dGetValue;
				$_filterCond .= " AND s.dept_id = '$dValue' ";
			}
			if($aGetValue != "")
			{
				$aValue = $aGetValue;
				$_filterCond .= " AND s.fusion_id = '$aValue' ";
			}
			
			$data['oValue'] = $oValue;
			$data['dValue'] = $dValue;
			$data['aValue'] = $aValue;
			
			$sqlreviewList = "SELECT u.*, CONCAT(s.fname, ' ', s.lname) as fullname, s.office_id, d.shname as department_name, r.name as designation, sp.process_names,
							  l1.id as l1_supervisor, l2.id as l2_supervisor
			                  from user_shift_schedule as u
			                  LEFT JOIN signin as s ON s.id = u.user_id
			                  LEFT JOIN (SELECT ip.user_id, GROUP_CONCAT(p.name) as process_names from info_assign_process as ip 
										LEFT JOIN process as p ON ip.process_id = p.id
										GROUP BY ip.user_id) as sp ON sp.user_id = u.user_id 
							  LEFT JOIN role as r ON r.id = s.role_id
							  LEFT JOIN department as d ON d.id = s.dept_id
							  LEFT JOIN signin as l1 ON l1.id = s.assigned_to
							  LEFT JOIN signin as l2 ON l1.assigned_to = l2.id
							  WHERE u.is_accept = '2' AND u.agent_status = 'R' $_filterCond";
			$queryreviewList = $data['reviewList'] = $this->Common_model->get_query_result_array($sqlreviewList);
			
			$this->load->view('dashboard',$data);
		
		}
	}
	
	
	public function schedule_wfm_review_list(){
		if(check_logged_in())
		{
			$user_site_id 	= 	get_user_site_id();
			$user_office_id	=	get_user_office_id();
			$ses_dept_id	=	get_dept_id();
					
			$ses_dept_id = strtolower($ses_dept_id);			
			$is_global_access=get_global_access();			
			$user_oth_office = get_user_oth_office();
			
			$role_id= get_role_id();
			$current_user = get_user_id();
			
			$data["user_site_id"]=$user_site_id;
			$data["user_role_id"]=$role_id;
			$data["user_site_id"]=$user_site_id;
			
			if( get_role_dir()!="agent") $data["aside_template"] = get_aside_template();
			else $data["aside_template"] = "schedule/aside.php";			
			$data["content_template"] = "schedule/wfm_review.php";
			
			// SET FILTER PARAMETERS
			$oValue = $user_office_id;
			$dValue = $ses_dept_id;
			$aValue = "";
			$_filterCond = "";
			
			// DROPDOWN LIST
			$data['department_list'] = $this->Common_model->get_department_list();
			$data['location_list'] = $this->Common_model->get_office_location_list();
			
			if($is_global_access==1  || get_dept_folder()=="rta" || get_dept_folder()=="wfm" ){			
				$data['location_list'] = $this->Common_model->get_office_location_list();
				$data['site_list'] = $this->Common_model->get_sites_for_assign();
				$dValue = "ALL";
			} else {
				$sCond=" Where id = '$user_site_id'";
				$data['site_list'] = $this->Common_model->get_sites_for_assign2($sCond);
				$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
			}
			
			// GET L1 & L2 SUPERVIOSR ACCESS ID FILTER
			//get_role_dir()=="tl" || get_role_dir()=="manager" || get_role_dir()=="trainer"
			if((get_dept_folder() == "operations") && get_global_access() == '0')
			{
				$_filterCond .= " AND (l1.id = '$current_user' || l2.id = '$current_user') ";
			}
			
			// GET SEARCH PARAMETERS
			$oGetValue = $this->input->get('office_id');
			$dGetValue = $this->input->get('dept_id');
			$aGetValue = $this->input->get('agent_id');			
			$data['oValue'] = $oValue;
			if($oGetValue != "" && $oGetValue != "ALL")
			{
				$oValue = $oGetValue;
				$_filterCond .= " AND s.office_id = '$oValue' ";
			}
			if($dGetValue != "" && $dGetValue != "ALL")
			{
				$dValue = $dGetValue;
				$_filterCond .= " AND s.dept_id = '$dValue' ";
			}
			if($aGetValue != "")
			{
				$aValue = $aGetValue;
				$_filterCond .= " AND s.fusion_id = '$aValue' ";
			}
			
			$data['oValue'] = $oValue;
			$data['dValue'] = $dValue;
			$data['aValue'] = $aValue;
			
			$sqlreviewList = "SELECT u.*, CONCAT(s.fname, ' ', s.lname) as fullname, s.office_id, d.shname as department_name, r.name as designation, sp.process_names,
							  l1.id as l1_supervisor, l2.id as l2_supervisor
			                  from user_shift_schedule as u
			                  LEFT JOIN signin as s ON s.id = u.user_id
			                  LEFT JOIN (SELECT ip.user_id, GROUP_CONCAT(p.name) as process_names from info_assign_process as ip 
										LEFT JOIN process as p ON ip.process_id = p.id
										GROUP BY ip.user_id) as sp ON sp.user_id = u.user_id 
							  LEFT JOIN role as r ON r.id = s.role_id
							  LEFT JOIN department as d ON d.id = s.dept_id
							  LEFT JOIN signin as l1 ON l1.id = s.assigned_to
							  LEFT JOIN signin as l2 ON l1.assigned_to = l2.id
							  WHERE u.is_accept = '2' AND u.ops_status = 'R' $_filterCond";
			$queryreviewList = $data['reviewList'] = $this->Common_model->get_query_result_array($sqlreviewList);
			
			$this->load->view('dashboard',$data);
		
		}
	}
	
   
	//============== SCHEDULE ROUTINE CHECK SUBMISSION ===================================//
	
	public function schedule_accept_submit()
	{
		if(check_logged_in())
		{
			$current_user = get_user_id();
			
			//echo "<pre>".print_r($_POST, 1)."</pre>";			
			//$schedule_submission_type = $this->input->post('schedule_submission_type');

			$schedule_submission_type = "1";
			$schedule_id_chekbox = $this->input->post('schedule_id_chekbox');
			
			foreach($schedule_id_chekbox as $scheduleID)
			{
				$data_array = [ "is_accept" => $schedule_submission_type ];
				$this->db->where('id', $scheduleID);
				$this->db->update('user_shift_schedule', $data_array);
			}
			
			redirect($_SERVER['HTTP_REFERER']);
		
		}
	}
	
	
	public function schedule_agent_review_submit()
	{
		if(check_logged_in())
		{
			$current_user = get_user_id();
			
			//echo "<pre>".print_r($_POST, 1)."</pre>";
			//$schedule_submission_type = $this->input->post('schedule_submission_type');
			//$schedule_agent_status = $this->input->post('schedule_agent_status');
			
			$schedule_submission_type = "2";
			$schedule_agent_status = "R";
			
			$schedule_id_list = $this->input->post('schedule_id');
			$schedule_review_remarks = $this->input->post('schedule_review_remarks');
			$request_schedule_in = $this->input->post('request_schedule_in');
			$request_schedule_out = $this->input->post('request_schedule_out');
			if($request_schedule_out != "OFF"){ $request_schedule_out = substr(trim($request_schedule_out),0,5); }
			$schedule_id_array = explode(',',$schedule_id_list);
			foreach($schedule_id_array as $scheduleID)
			{
				$data_array = [ 					
					"is_accept" => $schedule_submission_type,
					"request_in_time" => $request_schedule_in,
					"request_out_time" => $request_schedule_out,
					"agent_status" => $schedule_agent_status,
					"agent_review" => $schedule_review_remarks,
				];
				$this->db->where('id', $scheduleID);
				$this->db->update('user_shift_schedule', $data_array);
			}
			
			redirect($_SERVER['HTTP_REFERER']);
		
		}
	}
	
	
	public function schedule_ops_review_submit()
	{
		if(check_logged_in())
		{
			$current_user = get_user_id();
			
			//echo "<pre>".print_r($_POST, 1)."</pre>";
			$schedule_submission_type = $this->input->post('schedule_submission_type');
			$schedule_ops_status = $this->input->post('schedule_ops_status');
			
			//$schedule_submission_type = "2";
			//$schedule_agent_status = "R";
			
			$schedule_id_list = $this->input->post('schedule_id');
			$schedule_review_remarks = $this->input->post('schedule_review_remarks');
			
			$schedule_id_array = explode(',',$schedule_id_list);
			foreach($schedule_id_array as $scheduleID)
			{
				$data_array = [ 					
					"is_accept" => $schedule_submission_type,
					"agent_status" => 'C',
					"ops_status" => $schedule_ops_status,
					"ops_review" => $schedule_review_remarks,
					"ops_by" => $current_user
				];
				$this->db->where('id', $scheduleID);
				$this->db->update('user_shift_schedule', $data_array);
			}
			
			redirect($_SERVER['HTTP_REFERER']);
		
		}
	}
	
	
	public function schedule_wfm_review_submit()
	{
		if(check_logged_in())
		{
			$current_user = get_user_id();
			
			//echo "<pre>".print_r($_POST, 1)."</pre>";
			$schedule_submission_type = $this->input->post('schedule_submission_type');
			$schedule_wfm_status = $this->input->post('schedule_wfm_status');
			$update_schedule_in = $this->input->post('update_schedule_in');
			$update_schedule_out = $this->input->post('update_schedule_out');
			
			//$schedule_submission_type = "2";
			//$schedule_agent_status = "R";
			if($schedule_submission_type == 3)
			{				
				$schedule_id_list = $this->input->post('schedule_id');
				$schedule_review_remarks = $this->input->post('schedule_review_remarks');
				
				$schedule_id_array = explode(',',$schedule_id_list);
				foreach($schedule_id_array as $scheduleID)
				{
					$data_array = [ 					
						"is_accept" => $schedule_submission_type,
						"ops_status" => 'C',
						"wfm_status" => $schedule_wfm_status,
						"wfm_review" => $schedule_review_remarks,
						"wfm_by" => $current_user
					];
					$this->db->where('id', $scheduleID);
					$this->db->update('user_shift_schedule', $data_array);
				}			
			}
			
			if($schedule_submission_type == 1)
			{				
				$schedule_id_list = $this->input->post('schedule_id');
				$schedule_review_remarks = $this->input->post('schedule_review_remarks');
				
				$schedule_id_array = explode(',',$schedule_id_list);
				foreach($schedule_id_array as $scheduleID)
				{
					$data_array = [ 					
						"is_accept" => $schedule_submission_type,
						"in_time" => $update_schedule_in,
						"out_time" => $update_schedule_out,
						"ops_status" => 'C',
						"wfm_status" => $schedule_wfm_status,
						"wfm_review" => $schedule_review_remarks,
						"wfm_by" => $current_user
					];
					$this->db->where('id', $scheduleID);
					$this->db->update('user_shift_schedule', $data_array);
				}				
				
			}
			
			redirect($_SERVER['HTTP_REFERER']);
		
		}
	}
	
	
	public function get_timezone_array()
	{
		$timezoneArray = array(
			"UST" => '-3:30',		
			"IST" => '-5:30',		
			"PST" => '+2:00',		
			"EST" => '+5:00'		
		);
		return $timezoneArray;
	}
	
	public function checkTimezone()
	{
		$date = new DateTime();
		$timeZone = $date->getTimezone();
		echo $timeZone->getName();
		echo date_default_timezone_get();
		echo $today = date('Y-m-d H:i:s');
		//echo "<br/>";
		//echo date('Y-m-d H:i:s', strtotime('+14 hours 5 minutes', strtotime($today)));
	}
   
    
	public function sample_schedule_download(){
		if(check_logged_in())
		{			
			$file = FCPATH .'uploads/schedule_sample/sampleSchedule.xlsx';
			ob_end_clean();
			header('Content-Description: File Transfer');
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment; filename='.basename($file));
			header('Content-Transfer-Encoding: binary');
			header('Expires: 0');
			header('Cache-Control: must-revalidate');
			header('Pragma: public');
			header('Content-Length: ' . filesize($file));
			readfile($file);					 
		}
	}
	
	
	public function upload_report()
	{
		$current_user = get_user_id();
		$user_site_id= get_user_site_id();
		$user_office_id= get_user_office_id();
		$user_oth_office=get_user_oth_office();
		$is_global_access=get_global_access();
		$is_role_dir=get_role_dir();
		$get_dept_id=get_dept_id();
		
		$selected_fusion = get_user_fusion_id();
				
		// INITITALIZE DATA		
		$selected_office = "";
		$selected_client = "";
		$selected_process = "";
		$selected_department = "";
		$time_start = "00:00:00";
		$time_end = "23:59:59";
		$data['todayDate'] = $currDate = CurrDate();
		$selected_month = date('m');
		$selected_year = date('Y');
		$selected_from = date('Y-m-d');
		$selected_to = date('Y-m-d');
		
		// FORM DATA FILTER
		$search = false;
		$extraFilter = "";
		$extraUserFilter = "";
		if(!empty($this->input->get('search_from_date')) && !empty($this->input->get('search_to_date')))
		{
			$search = true;
			$selected_from = date('Y-m-d', strtotime($this->input->get('search_from_date')));
			$selected_to = date('Y-m-d', strtotime($this->input->get('search_to_date')));			
		}
		
		if(!empty($this->input->get('select_office')) && $this->input->get('select_office') != 'ALL')
		{
			$search = true;
			$selected_office = $this->input->get('select_office');
			$extraUserFilter .= " AND s.office_id = '$selected_office'";
		}
		
		if(!empty($this->input->get('select_department')) && $this->input->get('select_department') != 'ALL')
		{
			$search = true;
			$selected_department = $this->input->get('select_department');
			$extraUserFilter .= " AND s.dept_id = '$selected_department'";
		}
		
		if(!empty($this->input->get('select_client')) && $this->input->get('select_client') != 'ALL')
		{
			$search = true;
			$selected_client = $this->input->get('select_client');
			$extraUserFilter .= " AND is_assign_client(s.id, $selected_client)";
			if(!empty($this->input->get('select_process')) && $this->input->get('select_process') != 'ALL')
			{
				$selected_process = $this->input->get('select_process');
				$extraUserFilter .= " AND is_assign_process(s.id, $selected_process)";
			}
		}
		
		// DATA STORE
		$data['selected_office'] = $selected_office;
		$data['selected_client'] = $selected_client;
		$data['selected_process'] = $selected_process;
		$data['selected_department'] = $selected_department;
		$data['selected_month'] = $selected_month;
		$data['selected_year'] = $selected_year;
		$data['selected_from_date'] = $selected_from;
		$data['selected_to_date'] = $selected_to;
		
		
		// DROPDOWN FILTERS
		if(get_global_access() == 1 || get_dept_folder()=="wfm" || get_dept_folder()=="rta"){
			$data['location_list'] = $location_list = $this->Common_model->get_office_location_list();			
		} else {
			$data['location_list'] = $location_list = $this->Common_model->get_office_location_session_all($current_user);
		}
		$data['client_list'] = $myClientList = $this->Common_model->get_client_list();		
		$data['process_list'] = $this->Common_model->get_process_for_assign();
		$data['department_list'] = $myDeptList = $this->Common_model->get_department_list();
		
		if(!empty($selected_department)){
			$sql = "SELECT * from department WHERE id = '$selected_department'";
			$myDeptList = $this->Common_model->get_query_result_array($sql);
		}
		if(!empty($selected_client)){
			$sql = "SELECT * from client WHERE id = '$selected_client'";
			$query = $this->db->query($sql);
			$myClientList = $query->result();
		}
		
		if(!empty($selected_client)){
			$sql = "SELECT * from process WHERE client_id = '$selected_client'";
			$query = $this->db->query($sql);
			$myProcessList = $query->result();
			$data['process_list'] = $myProcessList;
		}
		$data['myClientList'] = $myClientList;
		$data['myDeptList'] = $myDeptList;
		
		$days = 0;
		if($search == true)
		{
			
			// COUNT DAYS
			$date1 = new DateTime($selected_from);
			$date2 = new DateTime($selected_to);
			$interval = $date1->diff($date2);
			$days = $interval->days;
			$days = $days + 1;
		
			// GET USERS DATA
			$sqlReport = "SELECT s.*, d.shname as department, r.name as designation, 
			               CONCAT(sl.fname, ' ', sl.lname) as l1_supervisor, CONCAT(s.fname, ' ', s.lname) as full_name,
						   get_process_names(s.id) as process_names, get_client_names(s.id) as client_names, get_client_ids(s.id) as client_ids
						   from signin as s 
						  INNER JOIN signin as sl ON sl.id = s.assigned_to
						  LEFT JOIN department as d ON d.id = s.dept_id
						  LEFT JOIN role as r ON r.id = s.role_id	
						  WHERE s.status IN (1,4) $extraUserFilter ORDER by s.fname";
			$queryReport = $this->Common_model->get_query_result_array($sqlReport);
			$signinIDs = implode(',', array_column($queryReport, 'id'));
			if(empty($signinIDs)){ $signinIDs = 0; }			
			$userArray = $this->array_indexed($queryReport, 'id');
			$data['allUsers'] = $queryReport;
			$data['allUsersInfo'] = $userArray;
			$data['allUsersIds'] = $signinIDs;
			
			// GET SCHEDULE DATA
			$sqlSchedule = "SELECT sh.shdate, sh.user_id, sh.in_time, sh.out_time, sh.is_local, sh.fusion_id 
			                from user_shift_schedule as sh
							WHERE 
							sh.shdate >= '$selected_from' AND sh.shdate <= '$selected_to'
							AND sh.user_id IN ($signinIDs)
							GROUP BY sh.shdate, sh.user_id";
			//$querySchedule = $this->Common_model->get_query_result_array($sqlSchedule);
			//$data['scheduleUsers'] = $querySchedule;
			
			
			$schedule = array();
			$employee = array();
			
			// GET OFFICE USERS
			if(empty($selected_office))
			{
				foreach($location_list as $token)
				{
					$officeID = $token['abbr'];
					$officeName = $token['office_name'];
					$userArray = array_filter($queryReport, function ($var) use ($officeID) {
						return ($var['office_id'] == $officeID);
					});
					$employee['name']['office'][$officeID] = $officeName;
					$employee['data']['office'][$officeID] = $userArray;
					$employee['count']['office'][$officeID] = count($userArray);
					$office_signinIDs = implode(',', array_column($userArray, 'id'));
					$employee['signin']['office'][$officeID] = $office_signinIDs;
					
					$checkerDate = $selected_from;
					for($i=1; $i<= $days; $i++)
					{
						if(empty($office_signinIDs)){ $office_signinIDs = 0; }
						$sqlCount = "SELECT count(*) as value from user_shift_schedule as sh WHERE sh.user_id IN ($office_signinIDs) AND sh.shdate = '$checkerDate'";
						$usersScheduled = $this->Common_model->get_single_value($sqlCount);
						$schedule['count'][$checkerDate]['office'][$officeID] = $usersScheduled;
						$schedule['total'][$checkerDate]['office'][$officeID] = count($userArray);					
						$checkerDate = date('Y-m-d', strtotime('+1 day', strtotime($checkerDate)));
					}
				}
				
				//echo "<pre>".print_r($employee['count'], 1)."</pre>";
				//echo "<pre>".print_r($schedule['count'], 1)."</pre>";
				//echo "<pre>".print_r($schedule['total'], 1)."</pre>";
				//die();
			}
			
			
			if(!empty($selected_office))
			{
			// GET DEPARTMENT USERS
			foreach($myDeptList as $token)
			{
				$deptID = $token['id'];
				$deptName = $token['shname'];
				$userArray = array_filter($queryReport, function ($var) use ($deptID) {
					return ($var['dept_id'] == $deptID);
				});
				$employee['name']['department'][$deptID] = $deptName;
				$employee['data']['department'][$deptID] = $userArray;
				$employee['count']['department'][$deptID] = count($userArray);
				$dept_signinIDs = implode(',', array_column($userArray, 'id'));
				$employee['signin']['department'][$deptID] = $dept_signinIDs;
				
				$checkerDate = $selected_from;
				for($i=1; $i<= $days; $i++)
				{
					if(empty($dept_signinIDs)){ $dept_signinIDs = 0; }
					$sqlCount = "SELECT count(*) as value from user_shift_schedule as sh WHERE sh.user_id IN ($dept_signinIDs) AND sh.shdate = '$checkerDate'";
					$usersScheduled = $this->Common_model->get_single_value($sqlCount);
					$schedule['count'][$checkerDate]['department'][$deptID] = $usersScheduled;
					$schedule['total'][$checkerDate]['department'][$deptID] = count($userArray);
					
					/*$scheduleArray = array_filter($querySchedule, function ($var) use ($dept_signinIDs, $checkerDate) {
						$shUserID = $var['user_id'];
						if((in_array($shUserID, explode(',', $dept_signinIDs))) && ($var['shdate'] == $checkerDate)){ return $var; }
					});
					$schedule['data'][$checkerDate]['department'][$deptID] = $scheduleArray;
					$schedule['count'][$checkerDate]['department'][$deptID] = count($scheduleArray);
					$schedule_signinIDs = implode(',', array_column($scheduleArray, 'id'));
					$schedule['signin'][$checkerDate]['department'][$deptID] = $schedule_signinIDs;
					*/
					
					$checkerDate = date('Y-m-d', strtotime('+1 day', strtotime($checkerDate)));
				}
				
				// GET CLIENT USERS
				$clientArray = array();
				foreach($myClientList as $tokens)
				{
					$clientID = $tokens->id;
					$clientName = $tokens->shname;					
					$userArray = array_filter($queryReport, function ($var) use ($clientID, $deptID) {
						$clientArr = explode(',', $var['client_ids']);
						if(in_array($clientID, $clientArr) && $var['dept_id'] == $deptID){ return $var; }
					});
					$employee['name'][$deptID]['client'][$clientID] = $clientName;
					$employee['data'][$deptID]['client'][$clientID] = $userArray;
					$employee['count'][$deptID]['client'][$clientID] = count($userArray);
					$client_signinIDs = implode(',', array_column($userArray, 'id'));
					$employee['signin'][$deptID]['client'][$clientID] = $client_signinIDs;
					
					$checkerDate = $selected_from;
					for($i=0; $i<= $days; $i++)
					{
						if(empty($client_signinIDs)){ $client_signinIDs = 0; }
						$sqlCount = "SELECT count(*) as value from user_shift_schedule as sh WHERE sh.user_id IN ($client_signinIDs) AND sh.shdate = '$checkerDate'";
						$usersScheduled = $this->Common_model->get_single_value($sqlCount);
						$schedule['count'][$deptID][$checkerDate]['client'][$clientID] = $usersScheduled;
						$schedule['total'][$deptID][$checkerDate]['client'][$clientID] = count($userArray);
					
						/*$scheduleArray = array_filter($querySchedule, function ($var) use ($client_signinIDs, $checkerDate) {
							$shUserID = $var['user_id'];
							if((in_array($shUserID, explode(',', $client_signinIDs))) && ($var['shdate'] == $checkerDate)){ return $var; }
						});						
						$schedule['data'][$checkerDate]['client'][$clientID] = $scheduleArray;
						$schedule['count'][$checkerDate]['client'][$clientID] = count($scheduleArray);
						$schedule_signinIDs = implode(',', array_column($scheduleArray, 'id'));
						$schedule['signin'][$checkerDate]['client'][$clientID] = $schedule_signinIDs;
						*/
						
						$checkerDate = date('Y-m-d', strtotime('+1 day', strtotime($checkerDate)));
					}
				}
			}
			}
			
			$data['days'] = $days;
			$data['employeeData'] = $employee;
			$data['scheduleData'] = $schedule;
			
			//echo "<pre>".print_r($employee['count'], 1)."</pre>";
			//echo "<pre>".print_r($schedule['count'], 1)."</pre>";
			//die();
			
			if($this->input->get('excel') == 1)
			{
				$this->generate_report_upload_schedule($data, 1);
			}
			if($this->input->get('excel') == 2)
			{
				$this->generate_report_upload_schedule($data, 2);
			}
			if($this->input->get('excel') == 3)
			{
				$this->generate_report_upload_schedule($data, 3);
			}
		}
		
		$data['search'] = $search;
		
		$data["aside_template"] = "schedule/aside.php";
		$data["content_template"] = "schedule/schedule_report.php";
		$data["content_js"] = "schedule_adherence/schedule_upload_js.php";
		$this->load->view('dashboard',$data);
		
	}
	
	
	
	public function generate_report_upload_schedule($data, $type = 1)
	{	
		$this->load->library('excel');	
		$this->objPHPExcel = new PHPExcel();
		
		// INITITALIZE
		$selected_office = $data['selected_office'];
		$selected_client = $data['selected_client'];
		$selected_process = $data['selected_process'];
		$selected_department = $data['selected_department'];
		$selected_month = $data['selected_month'];
		$selected_year = $data['selected_year'];
		$selected_from_date = $data['selected_from_date'];
		$selected_to_date = $data['selected_to_date'];
		
		$allUsers = $data['allUsers'];
		$allUsersInfo = $data['allUsersInfo'];
		$allUsersIds = $data['allUsersIds'];
		
		$days = $data['days'];
		$employeeData = $data['employeeData'];
		$scheduleData = $data['scheduleData'];
		$myDeptList = $data['myDeptList'];
		$myClientList = $data['myClientList'];
		
		$worksheet_1 = "Schedule Upload";
		$worksheet_2 = "Userwise Upload";
		$worksheetIndex = 0;
		
		//============ WORKSHEET 1 ====================================================================//
		
		//=== START WROKSHEET
		$excel_Type = "Schedule Report";
		$this->objPHPExcel->createSheet($worksheetIndex);
		$this->objPHPExcel->setActiveSheetIndex($worksheetIndex);
		$objWorksheet = $this->objPHPExcel->getActiveSheet($worksheetIndex);
		$objWorksheet->setTitle($excel_Type);
		
		//=== SET WRAPTEXT OPTIONS
		$objWorksheet->setShowGridlines(true);
		$this->objPHPExcel->getDefaultStyle()->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->objPHPExcel->getDefaultStyle()->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		
		//=== Column Header Menu
		$r=0; $c = 2;
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Sl");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Office");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Department");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Head Count");
		$checkerDate = $selected_from_date;
		for($i=0; $i<$days; $i++){
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, date('d M, Y', strtotime($checkerDate)));
			$checkerDate = date('Y-m-d', strtotime('+1 day', strtotime($checkerDate)));
		}
		
		// STYLE ARRAYS
		$highestRow = $this->objPHPExcel->getActiveSheet()->getHighestRow();
		$highestColumn = $this->objPHPExcel->getActiveSheet()->getHighestColumn();
		$styleArray = array('font'  => array('bold'  => true,'color' => array('rgb' => 'FFFFFF'),'size'  => 10 ));
		$headerArray = array('font'  => array('bold'  => true,'color' => array('rgb' => '000000'),'size'  => 14));
		
		// SET HEADER TITLE
		$title = $selected_office ." - Schedule - ".date('d M, Y', strtotime($selected_from_date)) ." - " .date('d M, Y', strtotime($selected_to_date));
		
		// Merge Header
		$this->objPHPExcel->setActiveSheetIndex($worksheetIndex)->mergeCells('A1:'.$highestColumn.'1');
		$this->objPHPExcel->getActiveSheet()->setCellValue('A1', $title);
		$this->objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(40);
		$this->objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($headerArray);
		
		// Set Header Menu Title Style	
		$this->objPHPExcel->getActiveSheet()->getStyle('A2'.':'.$highestColumn.'2')->applyFromArray($styleArray);
		$this->objPHPExcel->getActiveSheet()->getStyle('A2'.':'.$highestColumn.'2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('000000');
		
		// Set Width of Columns
		$maxColumn = $highestColumn; $maxColumn++;
		for ($column = 'A'; $column != $maxColumn; $column++) {
			$objWorksheet->getColumnDimension($column)->setWidth(15);
		}
		$objWorksheet->getColumnDimension('A')->setWidth(5);
		$objWorksheet->getColumnDimension('B')->setWidth(10);
		$objWorksheet->getColumnDimension('C')->setWidth(30);
		
		// Monthly Data
		$counter = 0;
		foreach($myDeptList as $token)
		{
			$deptID = $token['id'];
			$deptName = $token['shname'];
			$checkerDate = $selected_from_date;
			$r=0; $c++;
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, ++$counter);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $selected_office);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $deptName);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $scheduleData['total'][$checkerDate]['department'][$deptID]);
			for($i=0; $i<$days; $i++){
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $scheduleData['count'][$checkerDate]['department'][$deptID]);
				$checkerDate = date('Y-m-d', strtotime('+1 day', strtotime($checkerDate)));
			}
		}
		
		// Wrap Text Columns
		$highestRow = $this->objPHPExcel->getActiveSheet()->getHighestRow();
		$highestColumn = $this->objPHPExcel->getActiveSheet()->getHighestColumn();
		$this->objPHPExcel->getActiveSheet()->getStyle('A3:'.$highestColumn.$highestRow)->getAlignment()->setWrapText(true);
		
		
		
		//============ DEPT WORKSHEET 2 ====================================================================//
		foreach($myDeptList as $token)
		{
		
		$worksheetIndex++;
		
		$deptID = $token['id'];
		$deptName = $token['shname'];
		
		//=== START WROKSHEET
		$excel_Type = $deptName;
		$this->objPHPExcel->createSheet($worksheetIndex);
		$this->objPHPExcel->setActiveSheetIndex($worksheetIndex);
		$objWorksheet = $this->objPHPExcel->getActiveSheet($worksheetIndex);
		$objWorksheet->setTitle($excel_Type);
		
		//=== SET WRAPTEXT OPTIONS
		$objWorksheet->setShowGridlines(true);
		$this->objPHPExcel->getDefaultStyle()->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->objPHPExcel->getDefaultStyle()->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		
		//=== Column Header Menu
		$r=0; $c = 2;
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Sl");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Office");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Department");		
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Client");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Head Count");
		$checkerDate = $selected_from_date;
		for($i=0; $i<$days; $i++){
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, date('d M, Y', strtotime($checkerDate)));
			$checkerDate = date('Y-m-d', strtotime('+1 day', strtotime($checkerDate)));
		}
		
		// STYLE ARRAYS
		$highestRow = $this->objPHPExcel->getActiveSheet()->getHighestRow();
		$highestColumn = $this->objPHPExcel->getActiveSheet()->getHighestColumn();
		$styleArray = array('font'  => array('bold'  => true,'color' => array('rgb' => 'FFFFFF'),'size'  => 10 ));
		$headerArray = array('font'  => array('bold'  => true,'color' => array('rgb' => '000000'),'size'  => 14));
		
		// SET HEADER TITLE
		$title = $selected_office ." - ".$deptName ." - " .date('d M, Y', strtotime($selected_from_date)) ." - " .date('d M, Y', strtotime($selected_to_date));;
		
		// Merge Header
		$this->objPHPExcel->setActiveSheetIndex($worksheetIndex)->mergeCells('A1:'.$highestColumn.'1');
		$this->objPHPExcel->getActiveSheet()->setCellValue('A1', $title);
		$this->objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(40);
		$this->objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($headerArray);
		
		// Set Header Menu Title Style	
		$this->objPHPExcel->getActiveSheet()->getStyle('A2'.':'.$highestColumn.'2')->applyFromArray($styleArray);
		$this->objPHPExcel->getActiveSheet()->getStyle('A2'.':'.$highestColumn.'2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('000000');
		
		// Set Width of Columns
		$maxColumn = $highestColumn; $maxColumn++;
		for ($column = 'A'; $column != $maxColumn; $column++) {
			$objWorksheet->getColumnDimension($column)->setWidth(15);
		}
		$objWorksheet->getColumnDimension('A')->setWidth(5);
		$objWorksheet->getColumnDimension('B')->setWidth(10);
		$objWorksheet->getColumnDimension('C')->setWidth(30);
		$objWorksheet->getColumnDimension('D')->setWidth(30);
		
		
		$yesArray = array('font'  => array('bold'  => true,'color' => array('rgb' => '05c605'),'size'  => 13 ));
		$noArray = array('font'  => array('bold'  => true,'color' => array('rgb' => 'ec3232'),'size'  => 13 ));
			
		// Monthly Data
		$counter = 0;
		foreach($myClientList as $token)
		{
			$clientID = $token->id;
			$clientName = $token->shname;
			$checkerDate = $selected_from_date;
			if($scheduleData['total'][$deptID][$checkerDate]['client'][$clientID] > 0){
			$r=0; $c++;
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, ++$counter);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $selected_office);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $deptName);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $clientName);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $scheduleData['total'][$deptID][$checkerDate]['client'][$clientID]);		
			for($i=0; $i<$days; $i++){
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $scheduleData['count'][$deptID][$checkerDate]['client'][$clientID]);
				$checkerDate = date('Y-m-d', strtotime('+1 day', strtotime($checkerDate)));
			}
			
			if($scheduleData['total'][$deptID][$checkerDate]['client'][$clientID] > 0)
			{					
				//$cell = \PHPExcel_Cell::stringFromColumnIndex($r-1) . $c;
				//$this->objPHPExcel->getActiveSheet()->getStyle($cell)->applyFromArray($yesArray);
				
				$styleArray = array('font'  => array('bold'  => true,'color' => array('rgb' => 'ffffff'),'size'  => 10 ));
				$this->objPHPExcel->getActiveSheet()->getStyle('A'.$c.':'.$highestColumn.$c)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('05c605');
				$this->objPHPExcel->getActiveSheet()->getStyle('A'.$c.':'.$highestColumn.$c)->applyFromArray($styleArray);
			}
			}
		}
				
		// Wrap Text Columns
		$highestRow = $this->objPHPExcel->getActiveSheet()->getHighestRow();
		$highestColumn = $this->objPHPExcel->getActiveSheet()->getHighestColumn();
		$this->objPHPExcel->getActiveSheet()->getStyle('A3:'.$highestColumn.$highestRow)->getAlignment()->setWrapText(true);
		
		}
		
		if($type > 1){
		
		$checkerDate = $selected_from_date;
		for($i=0; $i<$days; $i++){
			
		$sqlShift = "SELECT user_id from user_shift_schedule WHERE shdate = '$checkerDate' AND user_id IN ($allUsersIds)";
		$shiftSchedule = $this->Common_model->get_query_result_array($sqlShift);
		$shiftScheuduleIdArray = array_column($shiftSchedule, 'user_id');
		$shiftScheuduleIds = implode(',', $shiftScheuduleIdArray);
		
		$unscheduledArray = array_filter($allUsers, function ($var) use ($shiftScheuduleIdArray) {
			$currentUser = $var['id'];
			if(!in_array($currentUser, $shiftScheuduleIdArray)){ return $var; }
		});
		
		//============ USER WORKSHEET 3 ====================================================================//
				
		$worksheetIndex++;
				
		//=== START WROKSHEET
		$excel_Type = $checkerDate;
		$this->objPHPExcel->createSheet($worksheetIndex);
		$this->objPHPExcel->setActiveSheetIndex($worksheetIndex);
		$objWorksheet = $this->objPHPExcel->getActiveSheet($worksheetIndex);
		$objWorksheet->setTitle($excel_Type);
		
		//=== SET WRAPTEXT OPTIONS
		$objWorksheet->setShowGridlines(true);
		$this->objPHPExcel->getDefaultStyle()->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->objPHPExcel->getDefaultStyle()->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		
		//=== Column Header Menu
		$r=0; $c = 2;
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Sl");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Office");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Fusion ID");		
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Full Name");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Department");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Designation");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "L1 Supervisor");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Client");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, "Process");
		$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $checkerDate);
		
		// STYLE ARRAYS
		$highestRow = $this->objPHPExcel->getActiveSheet()->getHighestRow();
		$highestColumn = $this->objPHPExcel->getActiveSheet()->getHighestColumn();
		$styleArray = array('font'  => array('bold'  => true,'color' => array('rgb' => 'FFFFFF'),'size'  => 10 ));
		$headerArray = array('font'  => array('bold'  => true,'color' => array('rgb' => '000000'),'size'  => 14));
		
		// SET HEADER TITLE
		$title = $selected_office ." - " ."Schedule Not Uploaded - " .date('d M, Y', strtotime($checkerDate));
		if($type == 3){ $title = $selected_office ." - " ."Schedule Uploaded - " .date('d M, Y', strtotime($checkerDate)); }
		
		// Merge Header
		$this->objPHPExcel->setActiveSheetIndex($worksheetIndex)->mergeCells('A1:'.$highestColumn.'1');
		$this->objPHPExcel->getActiveSheet()->setCellValue('A1', $title);
		$this->objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(40);
		$this->objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($headerArray);
		
		// Set Header Menu Title Style	
		$this->objPHPExcel->getActiveSheet()->getStyle('A2'.':'.$highestColumn.'2')->applyFromArray($styleArray);
		$this->objPHPExcel->getActiveSheet()->getStyle('A2'.':'.$highestColumn.'2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('000000');
		
		// Set Width of Columns
		$maxColumn = $highestColumn; $maxColumn++;
		for ($column = 'A'; $column != $maxColumn; $column++) {
			$objWorksheet->getColumnDimension($column)->setWidth(15);
		}
		$objWorksheet->getColumnDimension('A')->setWidth(5);
		$objWorksheet->getColumnDimension('B')->setWidth(10);
		$objWorksheet->getColumnDimension('C')->setWidth(15);
		$objWorksheet->getColumnDimension('D')->setWidth(30);
		$objWorksheet->getColumnDimension('E')->setWidth(30);
		$objWorksheet->getColumnDimension('F')->setWidth(30);
		$objWorksheet->getColumnDimension('G')->setWidth(30);
		$objWorksheet->getColumnDimension('H')->setWidth(30);
		$objWorksheet->getColumnDimension('I')->setWidth(30);
		
		
		$yesArray = array('font'  => array('bold'  => true,'color' => array('rgb' => '05c605'),'size'  => 13 ));
		$noArray = array('font'  => array('bold'  => true,'color' => array('rgb' => 'ec3232'),'size'  => 13 ));
		
		if($type == 2){
			
		// Monthly Data
		$counter = 0;
		foreach($unscheduledArray as $token)
		{
			$currentUserId = $token['id'];
			$r=0; $c++;
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, ++$counter);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $allUsersInfo[$currentUserId]['office_id']);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $allUsersInfo[$currentUserId]['fusion_id']);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $allUsersInfo[$currentUserId]['full_name']);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $allUsersInfo[$currentUserId]['department']);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $allUsersInfo[$currentUserId]['designation']);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $allUsersInfo[$currentUserId]['l1_supervisor']);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $allUsersInfo[$currentUserId]['client_names']);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $allUsersInfo[$currentUserId]['process_names']);
			$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, 'N');
		}
		
		} else {
			
			// Monthly Data
			$counter = 0;
			foreach($shiftSchedule as $token)
			{
				$currentUserId = $token['user_id'];
				$r=0; $c++;
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, ++$counter);
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $allUsersInfo[$currentUserId]['office_id']);
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $allUsersInfo[$currentUserId]['fusion_id']);
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $allUsersInfo[$currentUserId]['full_name']);
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $allUsersInfo[$currentUserId]['department']);
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $allUsersInfo[$currentUserId]['designation']);
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $allUsersInfo[$currentUserId]['l1_supervisor']);
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $allUsersInfo[$currentUserId]['client_names']);
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, $allUsersInfo[$currentUserId]['process_names']);
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($r++,$c, 'Y');
			}
			
		}
				
		// Wrap Text Columns
		$highestRow = $this->objPHPExcel->getActiveSheet()->getHighestRow();
		$highestColumn = $this->objPHPExcel->getActiveSheet()->getHighestColumn();
		$this->objPHPExcel->getActiveSheet()->getStyle('A3:'.$highestColumn.$highestRow)->getAlignment()->setWrapText(true);
		
		$checkerDate = date('Y-m-d', strtotime('+1 day', strtotime($checkerDate)));
		
		}
		}
		
		$this->objPHPExcel->setActiveSheetIndex(0);
		$excel_Type = "Monthly_Schedule_Report";
		
		ob_end_clean();
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="'.$excel_Type.'.xlsx"');
		header('Cache-Control: max-age=0');
		$objWriter = PHPExcel_IOFactory::createWriter($this->objPHPExcel , 'Excel2007');
		$objWriter->setIncludeCharts(TRUE);
		$objWriter->save('php://output');
		exit(); 
		
	}
	
	private function array_indexed($dataArray = NULL, $column = "")
	{
		$result = array();
		if(!empty($dataArray) && !empty($column))
		{
			$arrOne = array_column($dataArray, $column);
			$arrTwo = $dataArray;
			$result = array_combine($arrOne, $arrTwo);
		}		
		return $result;
	}
	
	
	
	
	//================================ SCHEDULE UPLOAD ========================================================//
	
	public function schedule_custom()
    {
        if(check_logged_in()){
			
			$user_site_id = get_user_site_id();
			$user_office_id=get_user_office_id();
			$ses_dept_id=get_dept_id();
					
			$ses_dept_id = strtolower($ses_dept_id);
			
			$is_global_access=get_global_access();
			
			$user_oth_office = get_user_oth_office();
			
			$role_id= get_role_id();
			$current_user = get_user_id();
			
			$data["user_site_id"]=$user_site_id;
			$data["user_role_id"]=$role_id;
			$data["user_site_id"]=$user_site_id;
			
			if( get_role_dir()!="agent") $data["aside_template"] = get_aside_template();
			else $data["aside_template"] = "schedule/aside.php";
			
			$data["content_template"] = "schedule/actual_screen_custom.php";
			$data["content_js"] = "schedule_adherence/schedule_upload_custom_js.php";
			
			$oValue = trim($this->input->post('office_id'));
			if($oValue=="") $oValue = trim($this->input->get('office_id'));
			if($oValue=="")  $oValue=$user_office_id;
			
			$dValue = trim($this->input->post('dept_id'));
			if($dValue=="") $dValue = trim($this->input->get('dept_id'));
			if($dValue=="")  $dValue=$ses_dept_id;
			
			 $cValue = trim($this->input->post('client_id'));
			if($cValue=="") $cValue = trim($this->input->get('client_id'));
			
            $pValue = trim($this->input->post('process_id'));
			if($pValue=="") $pValue = trim($this->input->get('process_id'));
			
			$aValue = trim($this->input->post('agent_id'));
			if($aValue=="") $aValue = trim($this->input->get('agent_id'));
			
			$shdValue = trim($this->input->post('shDay'));
			if($shdValue=="") $shdValue = trim($this->input->get('shDay'));
			
			$start_date = trim($this->input->post('start_date'));
			if($start_date=="") $start_date = trim($this->input->get('start_date'));
			
			$end_date = trim($this->input->post('end_date'));
			if($end_date=="") $end_date = trim($this->input->get('end_date'));
			if($start_date==""){
				$start_date = GetLocalDate();
				$end_date = GetLocalDate();
			}
			/*
			$sch_range = trim($this->input->post('sch_range'));
			if($sch_range=="") $sch_range = trim($this->input->get('sch_range'));
			$sch_range_arr=explode("#",$sch_range);
			*/
			
			$data['oValue']=$oValue;
			$data['pValue']=$pValue;
			$data['cValue']=$cValue;
			$data['aValue']=$aValue;
			$data['dValue']=$dValue;
			//$data['sch_range']=$sch_range;
			$data['shdValue']=$shdValue;
			$data['start_date']=$start_date;
			$data['end_date']=$end_date;
			
			$_filterCond="";
			
			if($oValue!="ALL" && $oValue!="") $_filterCond = " And office_id='".$oValue."'";
			if($dValue!="ALL" && $dValue!="") $_filterCond .= " And dept_id='".$dValue."'";
			
			//if($pValue!="ALL" && $pValue!="") $_filterCond .= " And process_id='".$pValue."'";
			if($cValue!="ALL" && $cValue!="") $_filterCond .= " And is_assign_client (b.id,$cValue)";
			if($pValue!="ALL" && $pValue!="" && !empty($pValue)) $_filterCond .= " And is_assign_process (b.id,$pValue)";
						
			if($shdValue!="ALL" && $shdValue!="") $_filterCond .= " And shday='".$shdValue."'";
			
			if($aValue!="ALL" && $aValue!="") $_filterCond = " And (b.fusion_id='".$aValue."' OR b.omuid='".$aValue."')";
			
			$data['department_list'] = $this->Common_model->get_department_list();
			
			$data['location_list'] = $this->Common_model->get_office_location_list();
			
			$data['client_list'] = $this->Common_model->get_client_list();	
			
			if($is_global_access==1  || get_dept_folder()=="rta" || get_dept_folder()=="wfm" ){ 
			
				$data['location_list'] = $this->Common_model->get_office_location_list();
				$data['site_list'] = $this->Common_model->get_sites_for_assign();
			}else{
				$sCond=" Where id = '$user_site_id'";
				$data['site_list'] = $this->Common_model->get_sites_for_assign2($sCond);
				$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
			}
			
			$data['process_list'] = $this->Common_model->get_process_for_assign();
			
			if(!empty($cValue) && $cValue!="ALL"){
				$sql = "SELECT * from process WHERE client_id = '$cValue'";
				$query = $this->db->query($sql);
				$myProcessList = $query->result();
				$data['process_list'] = $myProcessList;
			}
			
			
			if($is_global_access=='1' || get_dept_folder()=="rta" || get_dept_folder()=="wfm" ) $cond="";
			else if( is_access_schedule_update() || is_access_schedule_upload())
				$cond=" and (office_id='$user_office_id' OR '$user_oth_office' like CONCAT('%',office_id,'%') ) ";
			else if(get_role_dir()=="tl" || get_role_dir()=="trainer"){
				
				//$cond=" and assigned_to = '".$current_user."'";
				
				$cond = " and (assigned_to='$current_user' OR assigned_to in (SELECT id FROM signin where  assigned_to ='$current_user')) ";
				
			}else if(get_role_dir()=="agent")
				$cond=" and user_id='$current_user'";
			else $cond=" and (office_id='$user_office_id' OR '$user_oth_office' like CONCAT('%',office_id,'%') ) ";
			
			/*
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
			
			$data["sch_date_range"]= mysql2mmddyy($shMonDate) . " To " . mysql2mmddyy($shSunDate);
			*/
			
			$qSql="Select a.*,b.fusion_id,b.omuid,xpoid,fname,lname,dept_id,office_id,site_id,role_id,status, get_client_names(b.id) as client_name, get_process_names(b.id) as process_name, (Select shname from department s where s.id=b.dept_id) as dept_name, (Select CONCAT(fname,' ' ,lname) from signin x where x.id=b.assigned_to) as asign_tl, (Select concat(fname, ' ', lname) as name from signin s where s.id= a.update_by) as update_by_name ,(Select name from role x  where x.id=b.role_id) as role_name from user_shift_schedule_test a, signin b where shdate>='$start_date' and shdate<='$end_date' and a.user_id=b.id and status in (1,4) $cond $_filterCond order by user_id, a.shdate, a.id";
			
			//echo $qSql;
			
			$data["sch_list"]= $this->Common_model->get_query_result_array($qSql);
			
			//$qSql="Select CONCAT(DATE_FORMAT(start_date,'%m-%d-%Y'),' To ' ,DATE_FORMAT(end_date,'%m-%d-%Y')) as value from user_shift_schedule limit 1";
			//$data["sch_date_range"]= $this->Common_model->get_single_value($qSql);
			
			if( $oValue == "ALL") $scond = "";
			else  $scond = " where substr(fusion_id,2,3) = '$oValue'";
			$qSql="Select start_date,end_date,CONCAT(DATE_FORMAT(start_date,'%m-%d-%Y'),' To ' ,DATE_FORMAT(end_date,'%m-%d-%Y')) as shrange from user_shift_schedule_test  $scond group by start_date order by start_date desc";
			//echo $qSql;
			
			//$data["all_sch_date_range"]= $this->Common_model->get_query_result_array($qSql);
			
			$dn_param='sd='.$start_date.'&ed='.$end_date.'&oth='.$oValue; 
			$dn_link = "";
			if( count($data["sch_list"]) > 0 ){
			
				$this->create_CSV($data["sch_list"]);
				$dn_link = base_url()."schedule/downloadCsv";
			}
			
			$data['dn_param']=$dn_param;
			$data['download_link']=$dn_link;
			
			
			$this->load->view('dashboard',$data);
			
		}
    }
	
	public function upload_schedule_custom()
    {
        if(check_logged_in())
        {
			$user_site_id= get_user_site_id();
			$role_id= get_role_id();
			
            if( get_role_dir()!="agent") $data["aside_template"] = get_aside_template();
			else $data["aside_template"] = "schedule/aside.php";
					
            $data["content_template"] = "schedule/upload_custom.php";
            $data["content_js"] = "schedule_adherence/schedule_upload_custom_js.php";
			
			$this->load->view('dashboard',$data);			 
			   
		}
    }
	
	public function upload_schedule_custom_file()
	{
		if(check_logged_in())
		{
			$current_user     = get_user_id();
			$user_site_id     = get_user_site_id();
			$user_office_id   = get_user_office_id();
			$logs   = get_logs();
			
			$schedule_week_start = date('Y-m-d', strtotime($this->input->post('ssdate')));
			$schedule_week_end = date('Y-m-d', strtotime($this->input->post('sedate')));
			
			
			$outputFile = FCPATH ."uploads/schedule_log_file/";
			$config = [
				'upload_path'   => $outputFile,
				'allowed_types' => 'txt',
				'max_size' => '1024000',
			];
			
			$this->load->library('upload');
			$this->upload->initialize($config);
			$this->upload->overwrite = true;
			if (!$this->upload->do_upload('userfile'))
			{
				redirect(base_url().'schedule/upload_schedule_custom/error');
			}
			
			$upload_data = $this->upload->data();
			$file_name = $outputFile .$upload_data['file_name'];
			
			
			//$file_name = "agentScheduleDetail.txt";
			//$file_name = $outputFile .$file_name;
			
			$fileLines = $this->file_getlines($file_name);
			$counter = 0; $currentUser = 0; $currentFusion = 0;
			$dataArray = array(); $dateArray = array(); $userArray = array(); $errorNames = array(); $scheduleArray = array();
			foreach($fileLines as $line) 
			{
				$counter++;
				if(!empty(trim($line)) && $counter > 2){
					
					$currentLineData = explode('|', $line);
					if(count($currentLineData) == 7 && strlen($currentLineData[0]) == 8)
					{
						$data_1 = trim($currentLineData[0]); // date
						$data_2 = trim($currentLineData[1]); // fusionid
						$data_3 = trim($currentLineData[2]); // id
						$data_4 = trim($currentLineData[3]); // name
						$data_5 = trim($currentLineData[4]); // type
						$data_6 = trim($currentLineData[5]); // starttime
						$data_7 = trim($currentLineData[6]); // end time
						
						$currentDate = substr($data_1, 0, 4) ."-" .substr($data_1, 4, 2) ."-" .substr($data_1, 6, 2);
						$currentFusion = $data_2;
						
						
						if(empty($currentFusion)){
							$currentLineData[7] = $counter;
							$errorNames[$currentDate][] = $currentLineData;
						} else {
							$dataArray[$currentDate][$currentFusion][] = $currentLineData;
							$scheduleArray[$currentFusion][$currentDate][] = $currentLineData;
							$dateArray[$currentDate] = $currentDate;
							$userArray[$currentFusion] = $currentFusion;
						}
						
						
					}					
					//echo "<pre>".print_r($currentLineData, 1)."</pre>";
					//echo $line ."<br/>";
				}				
			}
			
			//echo "<pre>".print_r($scheduleArray, 1)."</pre>"; die();
			
			$userData = array();
			$got_fusion_ids = implode("','", array_keys($userArray));
			
			if(!empty($got_fusion_ids)){
				$sql_userData = "SELECT * from signin WHERE fusion_id IN ('$got_fusion_ids')";
				$query_userData = $this->Common_model->get_query_result_array($sql_userData);
				$userData = $this->array_indexed($query_userData, 'fusion_id');
			}
			
			
			$finalSubmissionArray = array();
			
			// INSERT SCHEDULE
			foreach($userArray as $key=>$value){				
				if(!empty($userData[$key])){
				
				$currentUser_id = $userData[$key]['id'];
				$currentUser_fusion = $userData[$key]['fusion_id'];
				$current_StartDate = $schedule_week_start;
				$current_EndDate = $schedule_week_end;
				
				foreach($scheduleArray[$currentUser_fusion] as $dateKey=>$token){
					
					$search_totalV = count($token);
					
					
					/*-- for min - max ---
					
					$u_scheduleDate = $dateKey;
					$u_min_start = $u_scheduleDate. " " .$token[0][5] .":00";
					$u_max_end = $u_scheduleDate ."  " .$token[0][6] .":00";
					$u_break1 = "";
					$u_break2 = "";
					$u_lunch = "";
					
					// CHECK START DATE END DATE
					$breakFound = false;
					$break2Found = false;
					$LunchFound = false;					
					$c_start_ar[$currentUser_fusion][$dateKey] = array();
					$c_end_ar[$currentUser_fusion][$dateKey] = array();
					$c_break_ar[$currentUser_fusion][$dateKey] = array();
					$c_lunch_ar[$currentUser_fusion][$dateKey] = array();
					foreach($token as $checkup)
					{
						$u_startTime = $checkup[5];
						$u_endTime = $checkup[6];
						$u_start = $u_scheduleDate ." " .$u_startTime;
						$u_end = $u_scheduleDate ." " .$u_endTime;
						if(strtotime($u_start) < strtotime($u_min_start))
						{
							$u_min_start = $u_start;
						}
						
						if(strtotime($u_end) >= strtotime($u_max_end))
						{
							$u_max_end = $u_end;
						}
						
						$c_start_ar[$currentUser_fusion][$dateKey][] = $u_startTime;
						$c_end_ar[$currentUser_fusion][$dateKey][] = $c_end_ar;
						
						if($checkup[4] == 'Break'){
							$c_break_ar[$currentUser_fusion][$dateKey][] = $u_startTime;
						}
						
						if($checkup[4] == 'Lunch'){
							$c_lunch_ar[$currentUser_fusion][$dateKey][] = $u_startTime;
						}
					}					
					sort($c_start_ar[$currentUser_fusion][$dateKey]);
					sort($c_end_ar[$currentUser_fusion][$dateKey]);
					sort($c_break_ar[$currentUser_fusion][$dateKey]);
					sort($c_lunch_ar[$currentUser_fusion][$dateKey]);
					*/
					
					
					$u_scheduleDate = $dateKey;
					$u_startTime = $token[0][5];
					$u_endTime = $token[$search_totalV-1][6];
					$u_break1 = "";
					$u_break2 = "";
					$u_lunch = "";
					
					//echo $currentUser_fusion ." - " .$u_scheduleDate ."<br/>";
					
					$breaksArray = array_values(array_filter($token, function($uSearch){
						return $uSearch[4] == 'Break';
					}));
					if(!empty($breaksArray)){
						$breaksCount = count($breaksArray);
						if($breaksCount > 1){
							$u_break1 = $breaksArray[0][5];
							$u_break2 = $breaksArray[1][5];
						}
					}				
					//echo "<pre>" .print_r($breaksArray) ."</pre>";
									
					$LunchArray = array_values(array_filter($token, function($uSearch){
						return $uSearch[4] == 'Lunch';
					}));
					if(!empty($LunchArray)){
						$LunchCount = count($LunchArray);
						$u_lunch = $LunchArray[0][5];
					}
					
					
					
					$currentDay = date('D', strtotime($u_scheduleDate));
					$sqlSchedule = "REPLACE INTO user_shift_schedule_test (user_id,fusion_id, start_date, end_date, update_by, shday, in_time, break1, lunch, break2, out_time, shdate, log, is_local) Values('$currentUser_id','$currentUser_fusion', '$current_StartDate', '$current_EndDate', '$current_user', '$currentDay', '$u_startTime', '$u_break1', '$u_lunch', '$u_break2', '$u_endTime', '$u_scheduleDate', '$logs', '0')";
					$querySchedule = $this->db->query($sqlSchedule);
					
					
				}
				}			
			}
			
			//echo "<pre>".print_r($c_start_ar, 1)."</pre>";
			//echo "<pre>".print_r($c_end_ar, 1)."</pre>";
			//echo "<pre>".print_r($c_break_ar, 1)."</pre>";
			//echo "<pre>".print_r($c_lunch_ar, 1)."</pre>";
			//die();
			
			//echo "<pre>".print_r($scheduleArray, 1)."</pre>";
			
			//echo "<pre>".print_r($dateArray, 1)."</pre>";
			//echo "<pre>".print_r($userArray, 1)."</pre>";			
			//echo "<pre>".print_r($errorNames, 1)."</pre>";			
			//echo "<pre>".print_r($dataArray, 1)."</pre>";
			
			redirect(base_url().'schedule/upload_schedule_custom/success');
			
		}
	}
	
	
	
	function file_getlines($filename){
		$file = fopen($filename, 'r');
	 
		if (!$file)
			die('\nfile does not exist or cannot be opened\n');

		while (($line = fgets($file)) !== false) {
			yield $line;
		}

		fclose($file);
	}
      
}

?>