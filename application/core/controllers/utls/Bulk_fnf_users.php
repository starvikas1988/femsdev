<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bulk_fnf_users extends CI_Controller {
    
    /////////////////////////////////////////////////////////////////////////////////////////////
    // INDEX PAGE
    /////////////////////////////////////////////////////////////////////////////////////////////
    
	 function __construct() {
		parent::__construct();
		
		$this->load->model('Common_model');
		$this->load->model('user_model');
		$this->load->model('Email_model');
		
	 }
	 
    public function index()
    {
        if(check_logged_in())
        {
			$user_site_id= get_user_site_id();
			$role_id= get_role_id();
						
            $data["aside_template"] = get_aside_template();
			
            $data["content_template"] = "utils/bulk_fnf.php";
						
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
			
			$remarks = "Manual upload on ".CurrDate();
			
			$ret = array();
			$output_dir = "uploads/";
			$error =$_FILES["myfile"]["error"];
			//You need to handle  both cases
			//If Any browser does not support serializing of multiple files using FormData() 
			if(!is_array($_FILES["myfile"]["name"])) //single file
			{
				$fileName = time().str_replace(' ','',$_FILES["myfile"]["name"]);
				move_uploaded_file($_FILES["myfile"]["tmp_name"],$output_dir.$fileName);
				
				$ret[]= $this->Import_excel_file($fileName, $remarks);
					
					
			}else  //Multiple files, file[]
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
			
			$evt_date=CurrMySqlDate();
			$log = "Bulk FNF Upload on " . $evt_date;
			
			
				try{
				
					
					$filename = "./temp_files/bulk_fnf_not_process_".get_user_id().".csv";
					$fopen = fopen($filename,"w+");
					$header = array( "fusion_id", "lname");
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
						
						$fusionid_index=0;
						$doldate_index=0;
						
						log_message('FEMS',  'Bulk Upload:: highestColumnIndex ::  ' . $highestColumnIndex, "  "  );
						
						for ($col = 0; $col <= $highestColumnIndex; $col++) {
						
							$cell = $worksheet->getCellByColumnAndRow($col, $row);
							$val = $cell->getValue();
							$val=trim($val);	
							
							//log_message('FEMS',  'Bulk Upload:: col : "'. $col .  '" | ' . $val. " >> " .strtolower($val) , " ");
							
							if(strtolower($val) =="xpoid" || strtolower($val) =="fusion_id"){
								
								$col_indexs .=",".$col;
								$fusionid_index=$col;
								
							}else if(strtolower($val) =="dol"){
								$col_indexs .=",".$col;
								$doldate_index=$col;
							}
							
						}
						
						if($fusionid_index >=0 ){
						
							$col_indexs=substr($col_indexs,1);
							log_message('FEMS',  'FNF Bulk Upload:: col_indexs ::  '. $col_indexs, "");				
							$col_ind_arry=explode(",",$col_indexs);
							
							$jj=0;
							
							
						
							for ($row = 2; $row <= $highestRow; $row++) {
								//$html .= '<tr>';
								$jj++;
												
								$fusion_id="";
								$dol_date="";
														
								for ($col = 0; $col <= $highestColumnIndex; $col++) {
								
									$cell = $worksheet->getCellByColumnAndRow($col, $row);
									if (in_array($col, $col_ind_arry)){
										
										$val = $cell->getValue();
										$val=trim($val);
										
										if($col==$fusionid_index ){
											$fusion_id=$val;
										}else if($col==$doldate_index){
											$val = PHPExcel_Style_NumberFormat::toFormattedString($cell->getCalculatedValue(), 'yyyy-mm-dd');
											$dol_date=trim($val);
										}					
									}else{
										//log_message('FEMS',  ' Not In Array Data col : '.$col);
									}
								}
								
								try{
									
									//log_message('FEMS',  ' fusion_id >> dol_date : '.$fusion_id . " >> " .$dol_date);
																		
									
									if($fusion_id!="" ){
									$qSql="SELECT id as value FROM signin where (fusion_id='$fusion_id' OR xpoid='$fusion_id')";
									
									//log_message('FEMS',  ' qSql : '.$qSql);
									
									$user_id = $this->Common_model->get_single_value($qSql);
										
									//log_message('FEMS',  'User ID : ' . $user_id);
									
									//log_message('FEMS',  ' fusion_id >> dol_date : '.$fusion_id . " >> " .$dol_date. " >> ". $user_id);
									
									if($user_id>1){
										
										$_field_array = array(
											"dol" => $dol_date,
											"user_id" => $user_id,
											"it_helpdesk_status" => 'P',
											"it_security_status" => 'P',
											"payroll_status" => 'P',
											"fnf_status" => 'P',
											"updated" => $evt_date,
											"date_added" => $evt_date,
											"log" => $log
										);
										
										//$this->db->trans_start();
										
										data_inserter('user_fnf',$_field_array);
										
										//$this->db->trans_complete();
										
										$this->Email_model->send_fnf_email($user_id,"Resign", $dol_date);
										
									}else{
										log_message('FEMS',  ' User_id not found:  fusion_id >> dol_date : '.$fusion_id . " >> " .$dol_date. " >> ". $user_id);
									}
									
								}else{
									log_message('FEMS',  ' Fusion_id Blank : '.$row);
								}
							
							}catch(Exception $EX){
								$lastError = error_get_last();
								$msg=$lastError ? "Error: ".$lastError["message"]." on line ".$lastError["line"] : "";
								log_message('FEMS',  'Caught exception: ',  $msg);
							}
															
						}//end row
						
						log_message('FEMS',  ' INFO Total Record :  '.$jj );
						
					}else{
						
						log_message('FEMS',  ' Fusion id/XPOID column not found ');
						
					}
						
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