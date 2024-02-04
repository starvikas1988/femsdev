<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bulk_dfr_candidate extends CI_Controller {
    
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
			
            $data["content_template"] = "dfr/upload.php";
			
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
				
					
					$filename = "./temp_files/dfr_bulk_not_insert_list_".get_user_id().".csv";
					$fopen = fopen($filename,"w+");
					$header = array( "fname", "lname");
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
						$added_date_index=0;
						$log_index=0;
						$address_index=0;
						$address2_index=0;
						$city_index=0;
						$state_index=0;
						$postcode_index=0;
						$country_index=0;
						$phone_index=0;
						$email_index=0;
						$hiring_source_index=0;
						$alter_phone_index=0;
						$ref_name_index=0;
						$ref_id_index=0;
						$last_qualification_index=0;
												
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
							
							}else if(strtolower($val) =="added_date"){
								
								$col_indexs .=",".$col;
								$added_date_index=$col;
							
							}else if(strtolower($val) =="log"){
								
								$col_indexs .=",".$col;
								$log_index=$col;
								
							}else if(strtolower($val) =="address"){
								
								$col_indexs .=",".$col;
								$address_index=$col;
								
							}else if(strtolower($val) =="address2"){
								
								$col_indexs .=",".$col;
								$address2_index=$col;
							
							}else if(strtolower($val) =="city"){
								
								$col_indexs .=",".$col;
								$city_index=$col;
								
							}else if(strtolower($val) =="state"){
								
								$col_indexs .=",".$col;
								$state_index=$col;
							
							}else if(strtolower($val) =="postcode"){
								
								$col_indexs .=",".$col;
								$postcode_index=$col;
														
							}else if (strtolower($val)=="country"){
								
								$col_indexs .=",".$col;
								$country_index=$col;
								
							}else if (strtolower($val)=="phone"){
								
								$col_indexs .=",".$col;
								$phone_index=$col;
								
							}else if (strtolower($val)=="email"){
								
								$col_indexs .=",".$col;
								$email_index=$col;
							}else if (strtolower($val)=="hiring_source"){
								
								$col_indexs .=",".$col;
								$hiring_source_index=$col;
								
							}else if (strtolower($val)=="alter_phone"){
								
								$col_indexs .=",".$col;
								$alter_phone_index=$col;
								
							}else if (strtolower($val)=="ref_name"){
								
								$col_indexs .=",".$col;
								$ref_name_index=$col;
								
							}else if (strtolower($val)=="ref_id"){
								
								$col_indexs .=",".$col;
								$ref_id_index = $col;
								
							}else if (strtolower($val)=="last_qualification"){
								
								$col_indexs .=",".$col;
								$last_qualification_index = $col;
								
							}
							
						}
						
						
						
						$col_indexs=substr($col_indexs,1);
						
						log_message('FEMS',  'Candidate Bulk Upload:: col_indexs ::  '. $col_indexs, "");				
						
						$col_ind_arry=explode(",",$col_indexs);
										
						$jj=0;
						
						$log="Bulk Upload";
						
						for ($row = 2; $row <= $highestRow; $row++) {
							//$html .= '<tr>';
							$jj++;
									

											
							$fname="";
							$lname="";
							$added_date="";
							$log="";
							$address="";
							$address2="";
							$city="";
							$state="";
							$postcode="";
							$country="";
							$phone="";
							$email="";
							$hiring_source="";
							$alter_phone="";
							$ref_name="";
							$ref_id="";
							$last_qualification = "";
							
								
							$isNewEntry=true;
							
							$field_array = array(
								"candidate_status" => "P",
								"r_id" => "17",
								"added_by" =>"0"
							); 
							
						
							for ($col = 0; $col <= $highestColumnIndex; $col++) {
							
								$cell = $worksheet->getCellByColumnAndRow($col, $row);
								
								if (in_array($col, $col_ind_arry)){
									
									$val = $cell->getValue();
									$val=trim($val);
									
									if($col==$fname_index ){
										$fname=$val;
										//$field_array['fname']=$fname;
									}
									else if($col==$lname_index){
										$lname=$val;
										//$field_array['lname']=$lname;
										
									}else if($col==$added_date_index){
										$val = PHPExcel_Style_NumberFormat::toFormattedString($cell->getCalculatedValue(), 'mm/dd/yyyy');
										$added_date=trim($val);
										if($added_date!="") $added_date=mmddyy2mysql($added_date);
										$field_array['added_date']=$added_date;
										
									}else if($col==$log_index){
										
										$log=$val;
										//$field_array['log']=$log;
									
									}else if($col==$address_index){
										$address=$val;
										//$field_array['address']=$address;	
										
									}else if($col==$address2_index){
										$address2=$val;
										//$field_array['address']=$address;	
																
									}else if($col==$city_index){
										$city=$val;
										$field_array['city']=$city;
									}else if($col==$state_index){
										$state=$val;
										$field_array['state']=$state;
									}else if($col==$postcode_index){
										$postcode=$val;
										$field_array['postcode']=$postcode;
									}else if($col==$country_index){
										$country=$val;
										$field_array['country']=$country;
									}else if($col==$phone_index){
										$phone=$val;
										$field_array['phone']=$phone;
									}else if($col==$email_index){
										$email=$val;
										$field_array['email']=$email;
									}else if($col==$hiring_source_index){
										$hiring_source=$val;
										$field_array['hiring_source']=$hiring_source;
									}else if($col==$alter_phone_index){
										$alter_phone=$val;
										$field_array['alter_phone']=$alter_phone;
									}else if($col==$ref_name_index){
										$ref_name=$val;
										$field_array['ref_name']=$ref_name;
									}else if($col==$ref_id_index){
										$ref_id=$val;
										$field_array['ref_id']=$ref_id;
									}else if($col==$last_qualification_index){
										$last_qualification=$val;
										$field_array['last_qualification']=$last_qualification;
									}
																	
								}else{
									//log_message('FEMS',  ' Not In Array Data col : '.$col);
								}
							}
							
								$field_array['log'] = "Bulk Upload::  ". $log;
								$field_array['address']=$address . " " . $address2;	
									
								log_message('FEMS',  'Validation =>'. $fname. ">". $lname);
							
								if($fname!="" && $lname!="" ){
										
										$fname = preg_replace('/\s+/','',$fname);
										$lname = preg_replace('/\s+/','',$lname);
										
										$field_array['fname']=$fname;
										$field_array['lname']=$lname;
										log_message('FEMS',  ' isNewEntry Bulk Upload:: DATA::  '. http_build_query($field_array));
										
										$_user_id = data_inserter('dfr_candidate_details',$field_array);
										
											
								}else{
									
									
									$rowstr = '"'.$fname.'",'; 
									$rowstr .= '"'.$lname.'",'; 
																	
									fwrite($fopen,$rowstr."\r\n");
									
									log_message('FEMS',  ' Blank fname  lname ..... ::  '. http_build_query($field_array));
									
								}
														
							
						}//end row
						
						log_message('FEMS',  ' INFO Total Record :  '.$jj );
						
					}	//worksheet
				
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