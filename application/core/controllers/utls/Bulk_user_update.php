<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bulk_user_update extends CI_Controller {
    
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
			
            $data["content_template"] = "user/upload_update.php";
			
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
				
					
					$filename = "./temp_files/bulk_not_updated_list_".get_user_id().".csv";
					$fopen = fopen($filename,"w+");
					$header = array("fusion_id","xpoid", "fname", "lname", "location", "dept_id", "doj", "dob", "role_id", "email_id");
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
						
						$fusionid_index = -1;
						$fname_index=0;
						$lname_index=0;
						$dept_index=0;
						$sub_dept_index = 0;
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
						$pan_no_index=0;
						$social_security_no_index=0;
						$payroll_type_index=0;
						
						log_message('FEMS',  'Bulk Upload:: highestColumnIndex ::  ' . $highestColumnIndex, "  "  );
						
						for ($col = 0; $col <= $highestColumnIndex; $col++) {
						
							$cell = $worksheet->getCellByColumnAndRow($col, $row);
							$val = $cell->getValue();
							$val=trim($val);	
							
							//log_message('FEMS',  'Bulk Upload:: col : "'. $col .  '" | ' . $val. " >> " .strtolower($val) , " ");
							
							if(strtolower($val) =="fusion_id"){
								
								$col_indexs .=",".$col;
								$fusionid_index = $col;
								log_message('FEMS',  ' Fusionid index col INDEX :  '.$col );
								
							}else if(strtolower($val) =="fname"){
								
								$col_indexs .=",".$col;
								$fname_index = $col;
								
							}else if(strtolower($val) =="lname"){
								
								$col_indexs .=",".$col;
								$lname_index = $col;
							
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
								
							}else if (strtolower($val)=="pan_no"){
								
								$col_indexs .=",".$col;
								$pan_no_index = $col;
								
							}else if (strtolower($val)=="social_security_no"){
								
								$col_indexs .=",".$col;
								$social_security_no_index = $col;
								
							}else if (strtolower($val)=="payroll_type"){
								
								$col_indexs .=",".$col;
								$payroll_type_index = $col;
								
							}
							
							
							
							
						}
						
						if($fusionid_index >=0 ){
							
							$col_indexs=substr($col_indexs,1);
							
							log_message('FEMS',  'Bulk Upload for Upload:: col_indexs ::  '. $col_indexs, "");				
							
							$col_ind_arry=explode(",",$col_indexs);
											
							$jj=0;
							
							$log="Bulk Upload for update";
							
							for ($row = 2; $row <= $highestRow; $row++) {
								//$html .= '<tr>';
								$jj++;
								
								$fusion_id="";
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
								$pan_no="";
								$social_security_no="";
								$payroll_type="";
								
								$field_array = array(); 
								
								for ($col = 0; $col <= $highestColumnIndex; $col++) {
								
									$cell = $worksheet->getCellByColumnAndRow($col, $row);
									
									if (in_array($col, $col_ind_arry)){
										
										$val = $cell->getValue();
										$val=trim($val);
										
										if($col==$fusionid_index ){
											$fusion_id=$val;
										}
										else if($col==$fname_index ){
											$fname=$val;
											if($fname!="") $field_array['fname']=$fname;
										}
										else if($col==$lname_index){
											$lname=$val;
											if($lname!="") $field_array['lname']=$lname;
											
										}else if($col==$office_index){
											
											$office_id=$val;
											
										}else if($col==$dept_index){
											
											$dept=$val;
											if($dept!="") $field_array['dept_id']=$dept;
											
										}else if($col==$sub_dept_index){
											
											$sub_dept=$val;
											if($sub_dept!="") $field_array['sub_dept_id']=$sub_dept;
											
											
										}else if($col==$hire_index){
											//$val = PHPExcel_Style_NumberFormat::toFormattedString($cell->getCalculatedValue(), 'mm/dd/yyyy');
											$val = PHPExcel_Style_NumberFormat::toFormattedString($cell->getCalculatedValue(), 'dd/mm/yyyy');
											
											$hire=trim($val);
											//if($hire!="") $hire=mmddyy2mysql($hire);
											if($hire!="") $hire=ddmmyy2mysql($hire);
											
											if($hire!="") $field_array['doj']=$hire;
											
										
										}else if($col==$dob_index){

											//$val = PHPExcel_Style_NumberFormat::toFormattedString($cell->getCalculatedValue(), 'mm/dd/yyyy');
											$val = PHPExcel_Style_NumberFormat::toFormattedString($cell->getCalculatedValue(), 'dd/mm/yyyy');
											
											$dob=trim($val);
											//if($dob!="") $dob=mmddyy2mysql($dob);
											if($dob!="") $dob=ddmmyy2mysql($dob);
											
											if($dob!="") $field_array['dob']=$dob;
											
										}else if($col==$desig_index){
											$desig=$val;
											if($desig!="")$field_array['role_id']=$desig;
										}else if($col==$email_index){
											$email=$val;
											
										}else if($col==$xpoid_index){
											$xpoid=$val;
											if($xpoid!="") $field_array['xpoid']=$xpoid;
											
										}else if($col==$client_index){
											$client=$val;
											//$field_array['client_id']=$client;
										}else if($col==$process_index){
											$process_id=$val;
											//$field_array['process_id']=$process_id;
										}else if($col==$assigned_index){
											$assigned_to=$val;
											if($assigned_to!="") $field_array['assigned_to']=$assigned_to;
										}else if($col==$site_index){
											$site_id=$val;
											if($site_id!="") $field_array['site_id']=$site_id;
										}else if($col==$sex_index){
											
											$sex=$val;
											if($sex!="") $field_array['sex']=$sex;
											
										}else if($col==$hiring_index){
											$hiring=$val;
											if($hiring!="") $field_array['hiring_source']=$hiring;
											
										}else if($col==$hiring_sub_index){
											$hiring_sub=$val;
											if($hiring_sub!="") $field_array['hiring_sub_source']=$hiring_sub;
											
										}else if($col==$pan_no_index){
											$pan_no=$val;
										}else if($col==$social_security_no_index){
											$social_security_no=$val;
										}else if($col==$payroll_type_index){
											$payroll_type=$val;
										}
																			
									}else{
										//log_message('FEMS',  ' Not In Array Data col : '.$col);
									}
								}
								
								$field_array['log']=$log;
								
																		
										log_message('FEMS',  ' Fusion ID : '. $fusion_id);
																				
										if($fusion_id!=""){
												
												$_user_id = $this->Common_model->get_single_value("SELECT id as value FROM signin where fusion_id='$fusion_id'");
												
												log_message('FEMS',  'User ID : ' . $_user_id);
												
												log_message('FEMS',  ' Bulk Upload:: DATA::  '. http_build_query($field_array));
												
												if($_user_id != ""){
													
													$this->db->where('fusion_id', $fusion_id);
													$this->db->update('signin', $field_array);	
													
													if($email != "") {
														$info_arr = array(
															"email_id_per" => $email,
															"pan_no" => $pan_no,
															"social_security_no" => $social_security_no,
															"log" => $log
														);
																
														$this->db->where('user_id', $_user_id);
														$this->db->update('info_personal', $info_arr);	
													}
													
													if ($client !=""){
														
														$clientArr = explode(",",$client);
														if(count($clientArr) > 0 ){
															$this->db->query('DELETE FROM info_assign_client WHERE user_id = "'.$_user_id.'"');
															
															foreach ($clientArr as $key => $client_value){	
																$field_array2 = array(
																	"user_id" => $_user_id,
																	"client_id" => $client_value,
																	"log" => $log
																);
																$rowid= data_inserter('info_assign_client',$field_array2);
															}
														}
													}
													
													//////
													
													if ($process_id !=""){
														
														$processArr = explode(",",$process_id);
														if(count($processArr) > 0 ){
															
														$this->db->query('DELETE FROM info_assign_process WHERE user_id = "'.$_user_id.'"');
														
														foreach ($processArr as $key => $process_value){	
															$field_array3 = array(
																"user_id" => $_user_id,
																"process_id" => $process_value,
																"log" => $log
															);
															$rowid= data_inserter('info_assign_process',$field_array3);
														}
													  }
													
													}////
													
													if ($payroll_type !=""){
														
														$this->db->query('DELETE FROM info_payroll WHERE user_id = "'.$_user_id.'"');
														$payroll_status=1;
														$gross_pay=0;
																													
														$field_array4 = array(
															"user_id" => $_user_id,
															"payroll_type" => $payroll_type,
															"payroll_status" => $payroll_status,
															"gross_pay" => $gross_pay,
															"log" => $log
														);
														$rowid= data_inserter('info_payroll',$field_array4);
														
														
													}
													///////
													
													
													
												}//user id
																						
										}else{
											
											log_message('FEMS',  ' Blank fusion ID ..... ::  '. http_build_query($field_array));
											
										}
								
							}//end row
							
							log_message('FEMS',  ' INFO Total Record :  '.$jj );
							
						}else{
							/// end fusionid_index
							log_message('FEMS',  ' fusionid index IS ZERO :  '.$fusionid_index );
						}
						
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