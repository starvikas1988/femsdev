<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bulk_term_withoutdate extends CI_Controller {
    
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
			
            $data["content_template"] = "utils/bulk_term.php";
			
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
			
			$term_type = trim($this->input->post('term_type'));
			$remarks = trim($this->input->post('remarks'));
			
			$ret = array();
			$output_dir = "uploads/";
			$error =$_FILES["myfile"]["error"];
			//You need to handle  both cases
			//If Any browser does not support serializing of multiple files using FormData() 
			if(!is_array($_FILES["myfile"]["name"])) //single file
			{
				$fileName = time().str_replace(' ','',$_FILES["myfile"]["name"]);
				move_uploaded_file($_FILES["myfile"]["tmp_name"],$output_dir.$fileName);
				$ret[]= $this->Import_excel_file($fileName, $term_type,$remarks);
					
					
			}else  //Multiple files, file[]
			{
				  $fileCount = count($_FILES["myfile"]["name"]);
				  for($i=0; $i < $fileCount; $i++)
				  {
					
					$fileName = time().str_replace(' ','',$_FILES["myfile"]["name"]);
					
					move_uploaded_file($_FILES["myfile"]["tmp_name"][$i],$output_dir.$fileName);
					
					$ret[]= $this->Import_excel_file($fileName, $term_type,$remarks);
					
				  }	
			}
			
			 echo json_encode($ret);
			
		}
   }
   
   
   private function Import_excel_file($fn, $term_type,$remarks)
   {
		$retval="";
		if(check_logged_in())
        {
			$current_user = get_user_id();
			
			$event_master_id = 7;
			$evt_date=CurrMySqlDate();
			$log = "Bulk Term on " . $evt_date;
			
			
				try{
				
					
					$filename = "./temp_files/bulk_term_not_process_".get_user_id().".csv";
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
						
						$fusionid_index=0;
						$termdate_index=0;
						
						log_message('FEMS',  'Bulk Upload:: highestColumnIndex ::  ' . $highestColumnIndex, "  "  );
						
						for ($col = 0; $col <= $highestColumnIndex; $col++) {
						
							$cell = $worksheet->getCellByColumnAndRow($col, $row);
							$val = $cell->getValue();
							$val=trim($val);	
							
							//log_message('FEMS',  'Bulk Upload:: col : "'. $col .  '" | ' . $val. " >> " .strtolower($val) , " ");
							
							if(strtolower($val) =="fusion_id"){
								
								$col_indexs .=",".$col;
								$fusionid_index=$col;	
							}
							
						}
						
						if($fusionid_index >=0 ){
						
							$col_indexs=substr($col_indexs,1);
							log_message('FEMS',  'Candidate Bulk Upload:: col_indexs ::  '. $col_indexs, "");				
							$col_ind_arry=explode(",",$col_indexs);
										
							$jj=0;
							
							
						
							for ($row = 2; $row <= $highestRow; $row++) {
								//$html .= '<tr>';
								$jj++;
												
								$fusion_id="";
								$term_date="";
														
								for ($col = 0; $col <= $highestColumnIndex; $col++) {
								
									$cell = $worksheet->getCellByColumnAndRow($col, $row);
									if (in_array($col, $col_ind_arry)){
										
										$val = $cell->getValue();
										$val=trim($val);
										
										if($col==$fusionid_index ){
											$fusion_id=$val;
										}					
									}else{
										//log_message('FEMS',  ' Not In Array Data col : '.$col);
									}
								}
								
								try{
									
									if($fusion_id!="" && ($term_type =="P" || $term_type=="C") ){
										
										
									$user_id = $this->Common_model->get_single_value("SELECT id as value FROM signin where fusion_id='$fusion_id'");
									$status = $this->Common_model->get_single_value("SELECT status as value FROM signin where fusion_id='$fusion_id'");
									
									if($status==1){
										
									$doj = $this->Common_model->get_single_value("SELECT doj as value FROM signin where fusion_id='$fusion_id'");
									
									$llogout = $this->Common_model->get_single_value("SELECT max(logout_time) as value FROM logged_in_details  WHERE user_id ='$user_id'");
									
									
									log_message('FEMS',  'User ID : ' . $user_id . ' | doj : ' . $doj . ' | llogout : ' . $llogout );
									$term_date="";
									
									if($llogout!="") $term_date = $llogout;
									log_message('FEMS',  ' fusion_id >> term_date : '.$fusion_id . " >> " .$term_date);
									
									if($term_date==""){
										$term_date = date('Y-m-d', strtotime(date($doj) .' +3 day'));
										
										$start_date = mysqlDt2yymmddDate($term_date);
										$end_date = $start_date;
										$lwd = "";
									
									}else{
										
										$start_date = mysqlDt2yymmddDate($term_date);
										$end_date = $start_date;
										$lwd = $start_date;
									
									}
									
									
									
									log_message('FEMS',  ' fusion_id >> term_date : '. $fusion_id . " >> " .$term_date);
									log_message('FEMS',  ' fusion_id >> start_date : '. $fusion_id . " >> " .$start_date);
									
									$_field_array = array(
										"user_id" => $user_id,
										"event_time" => $evt_date,
										"event_by" => $current_user,
										"event_master_id" => $event_master_id,
										"start_date" => $start_date,
										"end_date" => $end_date,
										"remarks" => $remarks,
										"log" => $log
									);
									
									$this->db->trans_start();
										/////////////////////////////
									$this->db->where('id', $user_id);
									$this->db->update('signin', array('disposition_id' => $event_master_id));
									
									$this->db->delete('event_disposition', array('user_id' => $user_id,'event_master_id'=>'7', 'start_date'=>$start_date));
									$event_id = data_inserter('event_disposition',$_field_array);
										
									$qSql="Select count(id) as value from suspended_users where user_id='".$user_id."' and is_complete='N'";
									$rowcount=$this->Common_model->get_single_value($qSql);
									
									if($rowcount>0){
										$this->updateSuspensionWhenTerm($user_id,$start_date,"Update by Term Process");
									}
									
									if($term_type=="P"){
										$this->db->where('id', $user_id);
										$this->db->update('signin', array('status' =>'2'));
									}else if($term_type=="C"){
										$this->db->where('id', $user_id);
										$this->db->update('signin', array('status' =>'0'));
									}
								
									$_field_array = array(
										"user_id" => $user_id,
										"terms_date" => $term_date,
										"comments" => $remarks,
										"t_type" => '8',
										"sub_t_type" => '2',
										"terms_by" => $current_user,
										"evt_date" => $evt_date,
										"lwd" => $lwd,
										"log" => $log
									);
								
									if($term_type=="P") $_field_array['is_term_complete']="N";
									else if($term_type=="C"){
										$_field_array['is_term_complete']="Y";
										$_field_array['update_by']=$current_user;
										$_field_array['update_date']=$evt_date;
									}
									
									$this->db->delete('terminate_users', array('user_id' => $user_id, 'terms_date'=>$term_date));
									
									data_inserter('terminate_users',$_field_array);
									
									$this->db->trans_complete();
									///////////////////
									$this->Email_model->send_email_submit_ticket($user_id,$term_date,$remarks);
									
									}//status
									
								}// fusion_id
							
							}catch(Exception $EX){
								$lastError = error_get_last();
								$msg=$lastError ? "Error: ".$lastError["message"]." on line ".$lastError["line"] : "";
								log_message('FEMS',  'Caught exception: ',  $msg);
							}
							
								
						}//end row
						
						log_message('FEMS',  ' INFO Total Record :  '.$jj );
						
					}else{
						
						log_message('FEMS',  ' Fusion id column not found ' );
						
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
   
   
   
private function updateSuspensionWhenTerm($csuid,$final_return_date,$update_comments)
{
	if(check_logged_in())
    {
		
		$evt_date = CurrMySqlDate();
		$current_user = get_user_id();
		
		if($csuid!="" && $final_return_date!=""){
			
			//$this->db->update("signin",array("status"=>'1',"disposition_id"=>'1'),array("id"=>$csuid));
			//$final_return_date=mmddyy2mysql($final_return_date);
			
			$update_array = array(
						"final_return_date" => $final_return_date,
						"update_date" => $evt_date,
						"update_by" => $current_user,
						"update_comments" => $update_comments,
						"is_complete" => "Y"
					);
					
			$this->db->where('user_id', $csuid);
			$this->db->where('is_complete', "N");
			$this->db->update('suspended_users',$update_array );
			
			$qSql="select id as value from event_disposition where user_id='$csuid' and event_master_id=9 order by id desc limit 1";
			$disp_row_id=$this->Common_model->get_single_value($qSql);
			
			$update_array = array(
				"end_date" => $final_return_date
			);
			
			$this->db->where('user_id', $csuid);
			$this->db->where('id', $disp_row_id);
			$this->db->update('event_disposition',$update_array );
			
						
			//////////LOG////////
						
			$qSql="select fusion_id,omuid,CONCAT(fname,' ' ,lname) as full_name from signin where id='$csuid'";
			$query = $this->db->query($qSql);
			$uRow=$query->row_array();			
			$omuid=$uRow["omuid"];
			$full_name=$uRow["full_name"];
			
			$Lfull_name=get_username();
			$LOMid=get_user_omuid();
					
			$LogMSG="Cancel Suspension(WhenTerm) of $full_name ($omuid) ";
			log_message('SOX', $LOMid.' - ' . $Lfull_name . ' | '.$LogMSG );
						
			//////////
						
			$ans="done";
		}else{
			$ans="error";
		}
		echo $ans;
	}
	
}

      
      
}

?>