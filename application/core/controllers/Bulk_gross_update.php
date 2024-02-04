<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Bulk_gross_update extends CI_Controller {
    
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
			
            $data["content_template"] = "utils/update_gross.php";
			
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
					$header = array("fusion_id","gross");
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
						$gross_index=-1;
						$type_index=-1;
												
						log_message('FEMS',  'Bulk Upload:: highestColumnIndex ::  ' . $highestColumnIndex, "  "  );
						
						for ($col = 0; $col <= $highestColumnIndex; $col++) {
						
							$cell = $worksheet->getCellByColumnAndRow($col, $row);
							$val = $cell->getValue();
							$val=trim($val);	
							
							//log_message('FEMS',  'Bulk Upload:: col : "'. $col .  '" | ' . $val. " >> " .strtolower($val) , " ");
							
							if(strtolower($val) == "fusion_id" || strtolower($val) == "fusion id" ){
								
								$col_indexs .=",".$col;
								$fusionid_index = $col;
								log_message('FEMS',  ' Fusionid index col INDEX :  '.$col );
								
							}else if(strtolower($val) =="gross"){
								$col_indexs .=",".$col;
								$gross_index = $col;
							}else if(strtolower($val) =="payroll_type"){
								$col_indexs .=",".$col;
								$type_index = $col;
							}
						}
						
						if($fusionid_index >=0 ){
							
							$col_indexs=substr($col_indexs,1);
							
							log_message('FEMS',  'Bulk Upload for gross:: col_indexs ::  '. $col_indexs, "");				
							
							$col_ind_arry=explode(",",$col_indexs);
											
							$jj=0;
							
							$log="Bulk Upload for gross";
							
							for ($row = 2; $row <= $highestRow; $row++) {
								//$html .= '<tr>';
								$jj++;
								
								$fusion_id="";
								$gross=0;
								$payroll_type=1;
								
								$field_array = array(); 
								
								for ($col = 0; $col <= $highestColumnIndex; $col++) {
								
									$cell = $worksheet->getCellByColumnAndRow($col, $row);
									
									if (in_array($col, $col_ind_arry)){
										
										$val = $cell->getValue();
										$val=trim($val);
										
										if($col==$fusionid_index ){
											$fusion_id=$val;
										}
										else if($col==$gross_index ){
											$gross=$val;
											
										}
										else if($col==$type_index ){
											$payroll_type=$val;
											
										}
																			
									}else{
										//log_message('FEMS',  ' Not In Array Data col : '.$col);
									}
								}
								
								$field_array['log']=$log;
								
																		
										log_message('FEMS',  ' Fusion ID : '. $fusion_id);
										log_message('FEMS',  ' gross  : '. $gross);
																				
										if($fusion_id!=""  && $gross > 0 ){
												
												$_user_id = $this->Common_model->get_single_value("SELECT id as value FROM signin where fusion_id='$fusion_id'");
												
												log_message('FEMS',  'User ID : ' . $_user_id);
												
												if($_user_id != ""){
														
														/*
														$info_arr = array(
															"gross_pay" => $gross
														);
														
														$this->db->where('user_id', $_user_id);
														$this->db->update('info_payroll', $info_arr);	
														*/
														
						$iSql="REPLACE INTO info_payroll (user_id, gross_pay, payroll_type, currency, log) Values ('$_user_id','$gross','$payroll_type' ,'INR','bulk update on 13-10-2020 req by sudeepta') ";
														
														$this->db->query($iSql);
														

														
													
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