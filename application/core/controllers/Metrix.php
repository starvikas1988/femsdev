<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Metrix extends CI_Controller {
    
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
			
			$role_id= get_role_id();
			$current_user = get_user_id();
			$role_dir=get_role_dir();
			$ses_dept_id=get_dept_id();
			
			
			$is_global_access=get_global_access();
			
			$data["user_site_id"]=$user_site_id;
			$data["user_role_id"]=$role_id;
			
			$data["aside_template"] = "metrix/aside.php"; //get_aside_template();
			
			$data["content_template"] = "metrix/metrix_screen.php";
			
			$dValue = trim($this->input->post('dept_id'));
			if($dValue=="") $dValue = trim($this->input->get('dept_id'));
			
			$sValue = trim($this->input->post('site_id'));
			if($sValue=="") $sValue = trim($this->input->get('site_id'));
			
            $pValue = trim($this->input->post('process_id'));
			if($pValue=="") $pValue = trim($this->input->get('process_id'));
			
			$sch_range = trim($this->input->post('sch_range'));
			if($sch_range=="") $sch_range = trim($this->input->get('sch_range'));
			$sch_range_arr=explode("#",$sch_range);
			
			if($dValue=="")$dValue=$ses_dept_id;
			
			$data['dValue']=$dValue;
			$data['sValue']=$sValue;
			$data['pValue']=$pValue;
			
			//$data['aValue']=$aValue;
			
			$_filterCond="";
			
			if($dValue!="ALL" && $dValue!="") $_filterCond = " And dept_id='".$dValue."'";
			if($sValue!="ALL" && $sValue!="") $_filterCond .= " And site_id='".$sValue."'";
			if($pValue!="ALL" && $pValue!="" && $pValue!="0") $_filterCond .= " And process_id='".$pValue."'";
			
			
			//$data['site_list'] = $this->Common_model->get_sites_for_assign();
			$data['process_list'] = $this->Common_model->get_process_for_assign();
			
			if(get_role_dir()=="super" || $is_global_access==1){
				$data['site_list'] = $this->Common_model->get_sites_for_assign();
				$data['location_list'] = $this->Common_model->get_office_location_list();
			}else{
				$sCond=" Where id = '$user_site_id'";
				$data['site_list'] = $this->Common_model->get_sites_for_assign2($sCond);
				$data['location_list'] = $this->Common_model->get_office_location_session_all($current_user);
			}
		
			/*
			if($role_id=="super" || $role_dir=="support" || get_dept_folder()=="hr" || get_dept_folder()=="rta" || get_dept_folder()=="wmf")	$cond="";
			else if($role_dir=="admin" || $role_dir=="head" ) $cond=" and dept_id='$ses_dept_id'";
			else if($role_dir=="manager")	$cond=" and office_id='$user_office_id'";
			else if($role_dir=="trainer" || $role_dir=="tl")	$cond=" and ( assigned_to='".$current_user."' OR user_id='".$current_user."')";
			else $cond=" and user_id='".$current_user."'";
			*/
			
			if($role_dir=="super" || $is_global_access==1) $cond="";
			else if($role_dir=="admin") $cond=" and office_id='$user_office_id' ";
			else if($role_dir=="manager") $cond=" and dept_id='$ses_dept_id'";
			else if($role_dir=="trainer" || $role_dir=="tl") $cond=" and ( assigned_to='".$current_user."' OR user_id='".$current_user."')";
			else $cond=" and user_id='".$current_user."'";
				
			
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
			
			if (get_role_dir() == "agent")
				$qSql="Select a.*,b.fusion_id,fname,lname,dept_id,office_id,site_id,role_id,process_id,status,(Select name from process y where y.id=b.process_id) as process_name,(Select name from site z  where z.id=b.site_id) as site_name,(Select name from role x  where x.id=b.role_id) as role_name from metrix_od a, signin b where a.user_id=b.id and status=1 $cond $_filterCond order by fname";
			else
				$qSql="Select a.*,b.fusion_id,fname,lname,dept_id,office_id,site_id,role_id,process_id,status,(Select name from process y where y.id=b.process_id) as process_name,(Select name from site z  where z.id=b.site_id) as site_name,(Select name from role x  where x.id=b.role_id) as role_name from metrix_od a, signin b where start_date='$shMonDate' and end_date='$shSunDate' and a.user_id=b.id and status=1 $cond $_filterCond order by fname";
			
			
			$data["sch_list"]= $this->Common_model->get_query_result_array($qSql);
			
			//$qSql="Select CONCAT(DATE_FORMAT(start_date,'%m-%d-%Y'),' To ' ,DATE_FORMAT(end_date,'%m-%d-%Y')) as value from user_shift_schedule limit 1";
			//$data["sch_date_range"]= $this->Common_model->get_single_value($qSql);
			
			$data["sch_date_range"]= mysql2mmddyy($shMonDate) . " To " . mysql2mmddyy($shSunDate);
			
			$qSql="Select start_date,end_date,CONCAT(DATE_FORMAT(start_date,'%m-%d-%Y'),' To ' ,DATE_FORMAT(end_date,'%m-%d-%Y')) as shrange from metrix_od  group by start_date order by start_date desc";
			
			$data["all_sch_date_range"]= $this->Common_model->get_query_result_array($qSql);
			
			$data['department_list'] = $this->Common_model->get_department_list();
			
			$qSql=" Select * from client where is_metrix='Y' ";			
			$data['client_list'] = $this->Common_model->get_query_result_array($qSql);
			
			$this->load->view('dashboard',$data);
			
		}
    }
	
	public function uploadMetrix()
    {
        if(check_logged_in())
        {
			$user_site_id= get_user_site_id();
			$role_id= get_role_id();
			
			$qSql=" Select * from client where is_metrix='Y' ";			
			$data['client_list'] = $this->Common_model->get_query_result_array($qSql);
			
            $data["aside_template"] = "metrix/aside.php"; //get_aside_template();
			
            $data["content_template"] = "metrix/upload.php";
			
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
			
			$sdate = "";//trim($this->input->post('sdate'));
			$edate = "";//trim($this->input->post('edate'));
			 
			$ret = array();
			
			//if($sdate!="" && $edate!=""){
			
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
			//}else{
			//		$ret[]="error";
					
			//}
			
			echo json_encode($ret);
			
		}
   }
   
   private function Import_excel_file($fn,$sdate,$edate)
   {
		
		$retval="";
		
		if(check_logged_in())
        {
			$current_user = get_user_id();
			
			try{
			
			//$sdate=mmddyy2mysql($sdate);
			//$edate=mmddyy2mysql($edate);
			
			$file_name = "./uploads/".$fn;
			
			$this->load->library('excel');
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
				
				log_message('FEMS',  ' INFO:  '.$text );
				
				////////////////////////////////////////////////////////
				$sheetData = $worksheet->toArray(null,true,true,true);
				//$html .= "<pre>";
				//$html .= json_encode($sheetData);
				//$html .="</pre>";
				
				/////////////////////////////////////////
								
				//$html .= '<br><table border="1"><tr>';
				
				$row = 1;
				$col_indexs="";
				$wc_index=0;
				$fusion_index=0;
				
				for ($col = 0; $col <= $highestColumnIndex; $col++) {
				
					$cell = $worksheet->getCellByColumnAndRow($col, $row);
					$val = $cell->getValue();
					$val=trim($val);	
			
					if(strtoupper($val) =="FUSION ID" || strtoupper($val) =="FUSIONID"){
						
						$col_indexs .=",".$col;
						$fusion_index=$col;
						
					}else if(strtoupper($val) =="WEEKSTART" || strtoupper($val) =="WEEK START"){
						
						$col_indexs .=",".$col;
						$wc_index=$col;
						
					}else if (strtolower($val)=="attendance" || strtolower($val)=="qa" || strtolower($val)=="crm average" || strtolower($val)=="# of calls" || strtolower($val)=="aht" ){
						$col_indexs .=",".$col;
					}
										
				}
				
				$col_indexs=substr($col_indexs,1);
				
				log_message('FEMS',  ' col_indexs:  '.$col_indexs );
				
				$col_ind_arry=explode(",",$col_indexs);
								
				$jj=0;
				
				for ($row = 3; $row <= $highestRow; $row++) {
					//$html .= '<tr>';
					$jj++;
					
					$iData1st="";
					$iData="";
					
					$found_uid=false;
					$found_week=false;
					
					$omid="";
					$fusion_id="";
					$w_start="";
					$w_end="";
					$user_id="";
					
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
										$user_id=$this->Common_model->get_single_value($qSql);
										if($user_id!=""){
											
											$found_uid=true;
										}
									}
								}
								
							}else if($col==$wc_index ){
									
									$val = PHPExcel_Style_NumberFormat::toFormattedString($cell->getCalculatedValue(), 'dd/mm/yyyy');
									$w_start=trim($val);
									$w_start=ddmmyy2mysql($w_start);
									$w_end = date('Y-m-d', strtotime(date($w_start) .' +7 day'));
									
									log_message('FEMS',  $w_start. ' >> '.$w_end);
									$found_week=true;
									
							}else{
								
								$val = $cell->getFormattedValue();
																				
								$iData .= ",'".$val."'";
								
							}
							
							
						log_message('FEMS',  ' Coll data iData : '.$jj." -> " . " $col >> " .$val );
							
							
						}else{
							log_message('FEMS',  ' metrix_od Not In Array Data col : '.$col);
						}
					}
					
					//$iData=substr($iData,1);
					
					
					
					if($found_uid==true && $user_id!="" && $found_week=true){
						
						$iSql="";
						$found_uid=false;
						$found_week=false;
						
						try{
																												
							$iSql="REPLACE INTO metrix_od (user_id,upload_by,start_date,end_date,attendance, qa, crm_avg, calls, aht) Values($user_id,'$current_user','$w_start', '$w_end' ". $iData.");";
							
							log_message('FEMS',  ' INSERT:  '.$jj." -> ".$iSql );
							
							$this->db->query($iSql);
							
						}catch(Exception $ex){
						
							log_message('FEMS',  'Caught exception: ',  $ex->getMessage());
							log_message('FEMS',  'Error:  '.$jj." -> ".$fusion_id. " >> " . " $user_id >> " .$iSql );
							
						}
						
					}else $iSql="";
					
				}//end row
				
				log_message('FEMS',  ' metrix_od INFO Total Record :  '.$jj );
				
				//$html .= '</table>';
			} //worksheet
			
				
				
				unlink($file_name);
				
				$retval= $fn."=>done";
			
			}catch(Exception $e){
				
				log_message('FEMS',  'Caught exception: ',  $e->getMessage());
				
				$newfn="error.".$fn;
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
   
   
    
      
}

?>