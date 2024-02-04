<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bulk_user extends CI_Controller {
    
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
        if(check_logged_in())
        {
			$user_site_id= get_user_site_id();
			$role_id= get_role_id();
			
            $data["aside_template"] = get_aside_template();
			
            $data["content_template"] = "user/upload.php";
			
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
			
			$ret = array();
			
						
				$output_dir = "uploads/";
				$error =$_FILES["myfile"]["error"];
				
				//You need to handle  both cases
				//If Any browser does not support serializing of multiple files using FormData() 
				
				if(!is_array($_FILES["myfile"]["name"])) //single file
				{
					
					$fileName = time().str_replace(' ','',$_FILES["myfile"]["name"]);
					
					move_uploaded_file($_FILES["myfile"]["tmp_name"],$output_dir.$fileName);
					
					$ret[]= $this->Import_excel_file($fileName);
					
					
				}
				else  //Multiple files, file[]
				{
				  $fileCount = count($_FILES["myfile"]["name"]);
				  for($i=0; $i < $fileCount; $i++)
				  {
					
					$fileName = time().str_replace(' ','',$_FILES["myfile"]["name"]);
					
					move_uploaded_file($_FILES["myfile"]["tmp_name"][$i],$output_dir.$fileName);
					
					$ret[]= $this->Import_excel_file($fileName);
					
				  }
				
				}
			
			    echo json_encode($ret);
			
		}
   }
   
   
   private function Import_excel_file($fn)
   {
		$retval="";
		if(check_logged_in())
        {
			$current_user = get_user_id();
			
				try{
				
					
					$filename = "./temp_files/bulk_not_insert_list_".get_user_id().".csv";
					$fopen = fopen($filename,"w+");
					$header = array("xpoid", "fname", "lname", "location", "dept_id", "doj", "dob", "role_id", "email_id");
					$rowstr = "";
					foreach($header as $data) $rowstr .= ''.$data.',';
					fwrite($fopen,rtrim($rowstr,",")."\r\n");
					
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
						
						log_message('FEMS',  'Bulk Upload:: highestColumnIndex ::  '.$highestColumnIndex, "  "  );
						
						////////////////////////////////////////////////////////
						$sheetData = $worksheet->toArray(null,true,true,true);
						
						//$html = "<pre>";
						//$html .= json_encode($sheetData);
						//$html .="</pre>";
						
						/////////////////////////////////////////
										
						//log_message('FEMS',  'Bulk Upload:: html ::  '. $html , " " );
						
						
						$row = 1;
						$col_indexs="";
						
						$fname_index=0;
						$lname_index=0;
						$dept_index=0;
						$sub_dept_index=0;
						$hire_index=0;
						$dob_index=0;
						$desig_index=0;
						$office_index=0;
						$email_index=0;
						$xpoid_index=0;
						$client_index=0;
						$process_index=0;
						$assigned_index=0;
						$site_index=0;
						$sex_index=0;
						
						$hiring_index=0;
						$hiring_sub_index=0;
												
						log_message('FEMS',  'Bulk Upload:: highestColumnIndex ::  ' . $highestColumnIndex, "  "  );
						
						for ($col = 0; $col <= $highestColumnIndex; $col++) {
						
							$cell = $worksheet->getCellByColumnAndRow($col, $row);
							$val = $cell->getValue();
							$val=trim($val);	
							
							//log_message('FEMS',  'Bulk Upload:: col : "'. $col .  '" | ' . $val. " >> " .strtolower($val) , " ");
							
							if(strtolower($val) =="fname"){
								
								$col_indexs .=",".$col;
								$fname_index=$col;
								
							}else if(strtolower($val) =="lname"){
								
								$col_indexs .=",".$col;
								$lname_index=$col;
							
							}else if(strtolower($val) =="office_id"){
								
								$col_indexs .=",".$col;
								$office_index=$col;
							
							}else if(strtolower($val) =="dept_id"){
								
								$col_indexs .=",".$col;
								$dept_index=$col;
								
							}else if(strtolower($val) =="sub_dept_id"){
								
								$col_indexs .=",".$col;
								$sub_dept_index=$col;
								
							}else if(strtolower($val) =="doj"){
								
								$col_indexs .=",".$col;
								$hire_index=$col;
							
							}else if(strtolower($val) =="dob"){
								
								$col_indexs .=",".$col;
								$dob_index=$col;
								
							}else if(strtolower($val) =="role_id"){
								
								$col_indexs .=",".$col;
								$desig_index=$col;
							
							}else if(strtolower($val) =="email_id"){
								
								$col_indexs .=",".$col;
								$email_index=$col;
														
							}else if (strtolower($val)=="xpoid"){
								
								$col_indexs .=",".$col;
								$xpoid_index=$col;
								
							}else if (strtolower($val)=="client_id"){
								
								$col_indexs .=",".$col;
								$client_index=$col;
								
							}else if (strtolower($val)=="process_id"){
								
								$col_indexs .=",".$col;
								$process_index=$col;
							}else if (strtolower($val)=="assigned_to"){
								
								$col_indexs .=",".$col;
								$assigned_index=$col;
								
							}else if (strtolower($val)=="site_id"){
								
								$col_indexs .=",".$col;
								$site_index=$col;
								
							}else if (strtolower($val)=="gender"){
								
								$col_indexs .=",".$col;
								$sex_index=$col;
								
							}else if (strtolower($val)=="hiring_source"){
								
								$col_indexs .=",".$col;
								$hiring_index = $col;
								
							}else if (strtolower($val)=="hiring_sub_source"){
								
								$col_indexs .=",".$col;
								$hiring_sub_index = $col;
							}
						}
						
						
						
						$col_indexs=substr($col_indexs,1);
						
						log_message('FEMS',  'Bulk Upload:: col_indexs ::  '. $col_indexs, "");				
						
						$col_ind_arry=explode(",",$col_indexs);
										
						$jj=0;
						
						$log="Bulk Upload";
						
						for ($row = 2; $row <= $highestRow; $row++) {
							//$html .= '<tr>';
							$jj++;
											
							$fname="";
							$lname="";
							$dept="";
							$sub_dept="";
							$hire="";
							$dob="";
							$desig="";
							$office_id="";
							$email="";
							$xpoid="";
							$client="";
							$process_id="";
							$assigned_to="";
							$site_id="";
							$sex="";
							$hiring = "";
							$hiring_sub="";
								
							$isNewEntry=true;
							
							$field_array = array(
								"status" => "1",
								"disposition_id" =>"1"
							); 
							
							for ($col = 0; $col <= $highestColumnIndex; $col++) {
							
								$cell = $worksheet->getCellByColumnAndRow($col, $row);
								
								if (in_array($col, $col_ind_arry)){
									
									$val = $cell->getValue();
									$val=trim($val);
									
									if($col==$fname_index ){
										$fname=$val;
										$field_array['fname']=$fname;
									}
									else if($col==$lname_index){
										$lname=$val;
										$field_array['lname']=$lname;
										
									}else if($col==$office_index){
										$office_id=$val;
										$field_array['office_id']=$office_id;
									}else if($col==$dept_index){
										
										$dept=$val;
										$field_array['dept_id']=$dept;
									
									}else if($col==$sub_dept_index){
										$sub_dept=$val;
										$field_array['sub_dept_id']=$sub_dept;											
									}else if($col==$hire_index){
										//$val = PHPExcel_Style_NumberFormat::toFormattedString($cell->getCalculatedValue(), 'mm/dd/yyyy');
										$val = PHPExcel_Style_NumberFormat::toFormattedString($cell->getCalculatedValue(), 'dd/mm/yyyy');
										$hire=trim($val);
										//if($hire!="") $hire=mmddyy2mysql($hire);
										if($hire!="") $hire=ddmmyy2mysql($hire);
										$field_array['doj']=$hire;
									
									}else if($col==$dob_index){
										//$val = PHPExcel_Style_NumberFormat::toFormattedString($cell->getCalculatedValue(), 'mm/dd/yyyy');
										$val = PHPExcel_Style_NumberFormat::toFormattedString($cell->getCalculatedValue(), 'dd/mm/yyyy');
										$dob=trim($val);
										//if($dob!="") $dob=mmddyy2mysql($dob);
										if($dob!="") $dob=ddmmyy2mysql($dob);
										$field_array['dob']=$dob;
																				
									}else if($col==$desig_index){
										$desig=$val;
										$field_array['role_id']=$desig;
									}else if($col==$email_index){
										$email=$val;
										$field_array['email_id']=$email;
									}else if($col==$xpoid_index){
										$xpoid=$val;
										$field_array['xpoid']=$xpoid;
									}else if($col==$client_index){
										$client=$val;
										//$field_array['client_id']=$client;
									}else if($col==$process_index){
										$process_id=$val;
										//$field_array['process_id']=$process_id;
									}else if($col==$assigned_index){
										$assigned_to=$val;
										$field_array['assigned_to']=$assigned_to;
									}else if($col==$site_index){
										$site_id=$val;
										$field_array['site_id']=$site_id;
									}else if($col==$sex_index){
										$sex=$val;
										$field_array['sex']=$sex;
									}else if($col==$hiring_index){
										$hiring=$val;
										$field_array['hiring_source']=$hiring;
									}else if($col==$hiring_sub_index){
										$hiring_sub=$val;
										$field_array['hiring_sub_source']=$hiring_sub;
									}
																	
								}else{
									//log_message('FEMS',  ' Not In Array Data col : '.$col);
								}
							}
							
							$field_array['log']=$log;
							
							log_message('FEMS',  'Validation =>'. $fname. ">". $lname. ">". $dept. ">". $hire. ">". $desig. ">".$office_id);
							
							if($fname!="" && $lname!="" && $dept!="" && $hire!="" && $desig!="" && $office_id!=""){
									
									$fname = preg_replace('/\s+/','',$fname);
									$lname = preg_replace('/\s+/','',$lname);
									
									$field_array['omuid']=$fname.".".$lname;
									$field_array['passwd']=$fname.".".$lname;
									
									$qSql='select *,(Select name from role k  where k.id=b.role_id) as role_name  from signin b where fname like "%'.$fname.'%" and lname like "%'.$lname.'%" and office_id="'.$office_id.'" and b.status in (1,4,9) ';
									
									log_message('FEMS',  ' Search qSql :: ' . $qSql);
									
									$res=$this->Common_model->get_query_result_array($qSql);
									if(!empty($res)) $isNewEntry=false;
																	
									log_message('FEMS',  ' isNewEntry ::  ', $isNewEntry);
									
									if($isNewEntry==true){
										
										log_message('FEMS',  ' isNewEntry Bulk Upload:: DATA::  '. http_build_query($field_array));
										
										$this->db->trans_begin();
										
										$_user_id = data_inserter('signin',$field_array);
										
										$lastError = error_get_last();
										$msg=$lastError ? "Error: ".$lastError["message"]." on line ".$lastError["line"] : "";
										log_message('FEMS',  'Bulk Upload:: Caught exception: ', $msg);
										
										$evt_date = CurrMySqlDate();
										
										$role_his_array = array(
											"user_id" => $_user_id,
											"role_id" => $desig,
											"stdate" => $hire,
											"change_date" => $evt_date,
											"change_by" => '1',
											"log" => $log
										);
										
										$rowid= data_inserter('role_history',$role_his_array);
										
										$info_arr = array(
											"user_id" => $_user_id,
											"email_id_off" => $email,
											"log" => $log
										);
										$rowid= data_inserter('info_personal',$info_arr);
										
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
										
										
										log_message('FEMS',  ' isNewEntry fusion_id ::  '. $fusion_id);
										
										$iClientArr = array(
												"user_id" => $_user_id,
												"client_id" => $client,
												"log" => $log,
										); 
											
										$rowid= data_inserter('info_assign_client',$iClientArr);
									
										$iProcessArr = array(
											"user_id" => $_user_id,
											"process_id" => $process_id,
											"log" => $log,
										);
										
										$rowid= data_inserter('info_assign_process',$iProcessArr);
										
										log_message('FEMS',  ' trans_complete done ::  '. $fusion_id);
										
									    $this->db->trans_complete();						
										
										////////////////////////////
										
										if($fusion_id=="" || $_user_id===FALSE || $this->db->trans_status() === FALSE){
											$this->db->trans_rollback();

											$lastError = error_get_last();
											$msg=$lastError ? "Error: ".$lastError["message"]." on line ".$lastError["line"] : "";
											
											log_message('FEMS',  'Bulk Upload:: Caught exception: ', $msg);
											
											//print_r(error_get_last());
											
										}else{
												//////////LOG////////
												$this->db->trans_commit();
												log_message('FEMS',  'Bulk Upload:: INSERT:  '.$jj );
												//////////
										}
										
									}else{
										
										$rowstr = '"'.$xpoid.'",'; 
										$rowstr .= '"'.$fname.'",'; 
										$rowstr .= '"'.$lname.'",'; 
										$rowstr .= '"'.$office_id.'",'; 
										$rowstr .= '"'.$dept.'",';
										$rowstr .= '"'.$hire.'",'; 
										$rowstr .= '"'.$dob.'",';
										$rowstr .= '"'.$desig.'",';
										$rowstr .= '"'.$email.'"'; 
										
										fwrite($fopen,$rowstr."\r\n");
										
										
									}
								
								
							}else{
								
								
								log_message('FEMS',  ' Blank fname  lname ..... ::  '. http_build_query($field_array));
								
							}
							
							
						}//end row
						
						log_message('FEMS',  ' INFO Total Record :  '.$jj );
						
					} 	//worksheet
				
					unlink($file_name);
					
					$retval= $fn."=>done";
				
				}catch(Exception $e){
					
					$lastError = error_get_last();
					$msg=$lastError ? "Error: ".$lastError["message"]." on line ".$lastError["line"] : "";
					log_message('FEMS',  'Caught exception: ',  $msg);
					
					$newfn="error.".$fn;
					$new_file_name = "./uploads/".$newfn;
					rename($file_name , $new_file_name);
					$retval= $fn."=>error";	
				}
				
				
				fclose($fopen);
				
			
			/////////////
			return $retval;
			
		}else{
			return "SessionError";
		}
   }
      
      
}

?>