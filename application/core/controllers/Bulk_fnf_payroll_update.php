<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Bulk_fnf_payroll_update extends CI_Controller {
    
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
			
            $data["content_template"] = "utils/update_fnf_payroll.php";
			
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
				
					
					$filename = "./temp_files/bulk_fnf_not_updated_list_".get_user_id().".csv";
					$fopen = fopen($filename,"w+");
					$header = array("fusion_id","Net Payment");
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
					
					$current_date = CurrMySqlDate();
					
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
									
						log_message('FEMS',  'Bulk Upload for fnf_payroll:: col_indexs ::  '. $col_indexs, "");				
						$col_ind_arry=explode(",",$col_indexs);	
							$jj=0;
							$log="Bulk Upload for fnf_payroll";
							
							for ($row = 2; $row <= $highestRow; $row++) {
								//$html .= '<tr>';
								$jj++;
								
								$fusion_id="";
								$gross=0;
								$payroll_type=1;
								
								$field_array = array(); 
								
								for ($col = 0; $col <= $highestColumnIndex; $col++) {
								
									$cell = $worksheet->getCellByColumnAndRow($col, $row);
									
									if($col==0) $fusion_id= $cell->getValue();
									if($col==5) $last_month_unpaid= $cell->getValue();
									if($col==6) $leave_encashment= $cell->getValue();
									if($col==7) $notice_pay= $cell->getValue();
									if($col==8) $pf_deduction= $cell->getValue();
									if($col==9) $esic_deduction= $cell->getValue();
									
									if($col==10) $ptax_deduction= $cell->getValue();
									if($col==11) $tds_deductions= $cell->getValue();
									if($col==12) $loan_recovery= $cell->getValue();
									if($col==13) $total_deduction= $cell->getValue();
									if($col==14) $net_payment= $cell->getValue();
									if($col==15) $esic_deduction= $cell->getValue();
									
									$current_user= 1;
									
								}
								
																		
								log_message('FEMS',  ' Fusion ID : '. $fusion_id);
																												
										if($fusion_id!=""){
												
												$user_id = $this->Common_model->get_single_value("SELECT id as value FROM signin where fusion_id='$fusion_id'");
												
												log_message('FEMS',  'User ID : ' . $user_id);
												
												if($user_id != ""){
														
														$fnf_id = $this->Common_model->get_single_value("SELECT id as value FROM user_fnf where user_id='".$user_id."' order by id desc limit 1");
														
														if($fnf_id!=""){
														
														$field_array = array(
															"user_id" => $user_id,
															"fnf_id" => $fnf_id,
															"last_month_unpaid" => $last_month_unpaid,
															"leave_encashment" => $leave_encashment,
															"notice_pay" => $notice_pay,
															"pf_deduction" => $pf_deduction,
															"esic_deduction" => $esic_deduction,
															"ptax_deduction" => $ptax_deduction,
															"tds_deductions" => $tds_deductions,
															"loan_recovery" => $loan_recovery,
															"total_deduction" => $total_deduction,
															"net_payment" => $net_payment,
															"payroll_by" => $current_user,
															"payroll_status" => 'C',
															"is_active" => '1',
															"date_added" => $current_date,
															"logs" => $log
														);
														
														//print_r($field_array);
														
														data_inserter('user_fnf_payroll', $field_array);
														
														$field_arrayu = array(
															"biometric_access_revocation" => "NO",
															"payroll_by" => $current_user,
															"payroll_status" => 'C',
															"updated" =>  $current_date
														);
														
														$this->db->where('id', $fnf_id);
														$this->db->where('user_id', $user_id);
														$this->db->update('user_fnf', $field_arrayu);
														
																												
														
														$field_array2 = array(
															"it_local_by" => $current_user,
															"it_local_status" => 'C',
															"updated" => $current_date
														);
														
														$this->db->where('id', $fnf_id);
														$this->db->where('user_id', $user_id);
														$this->db->update('user_fnf', $field_array2);
														
																												
														
														
														$field_array3 = array(
															"it_network_by" => $current_user,
															"it_network_status" => 'C',
															"updated" => $current_date
														);
														
														$this->db->where('id', $fnf_id);
														$this->db->where('user_id', $user_id);
														$this->db->update('user_fnf', $field_array3);
														
														
														$field_array3 = array(
															"it_network_by" => $current_user,
															"it_network_status" => 'C',
															"updated" => $current_date
														);
														
														$this->db->where('id', $fnf_id);
														$this->db->where('user_id', $user_id);
														$this->db->update('user_fnf', $field_array3);
														
														
														$field_array4 = array(
															"it_global_helpdesk_by" => $current_user,
															"it_global_helpdesk_status" => 'C',
															"updated" => $current_date
														);
														
														$this->db->where('id', $fnf_id);
														$this->db->where('user_id', $user_id);
														$this->db->update('user_fnf', $field_array4);
														
														$field_array5 = array(
															"account_by" => $current_user,
															"account_status" => 'C',
															"updated" => $current_date
														);
														
														$this->db->where('id', $fnf_id);
														$this->db->where('user_id', $user_id);
														$this->db->update('user_fnf', $field_array5);
														
														$field_array6 = array(
															"fnf_status" => "C",
															"final_comments" => "completed",
															"final_update_by" => $current_user,
															"final_update_date" => $current_date
														);
			
														$this->db->where('id', $fnf_id);
														$this->db->where('user_id', $user_id);
														$this->db->update('user_fnf', $field_array6);
														
														
														$field_array7 = array(
															"it_security_by" => $current_user,
															"it_security_status" => 'C',				
															"it_security_remarks" => "Completed",
															"it_security_updated" => $current_date,
															"updated" => $current_date
														);
														
														$this->db->where('id', $fnf_id);
														$this->db->where('user_id', $user_id);
														$this->db->update('user_fnf', $field_array7);
														
													}
													
												}//user id
																						
										}else{
											
											log_message('FEMS',  ' Blank fusion ID ..... ::  '. http_build_query($field_array));
											
											echo ' Blank fusion ID ..... ::  '. http_build_query($field_array);
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
			
			echo $retval;
			/////////////
			//return $retval;
			
		}else{
			return "SessionError";
		}
   }
      
      
}

?>