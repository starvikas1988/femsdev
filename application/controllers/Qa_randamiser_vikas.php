<?php 

 class Qa_randamiser_vikas extends CI_Controller{
				
	public function __construct(){
		parent::__construct();
		
		$this->load->model('user_model');
		$this->load->model('Common_model');
		$this->load->model('reports_model');
		$this->reports_model->set_report_database("report");
		
		$this->load->helper(array('form', 'url'));
		
		$this->load->model('Qa_randamiser_model');
		$this->load->library('excel');
		$this->objPHPExcel = new PHPExcel();
	}
	

/*---------------------------------------------------------------------------------------------------*/	
/*-------------------------------- RANDOMISER (03-01-2023) BSNL------------------------------------------*/	
/*---------------------------------------------------------------------------------------------------*/	

	function import_cdr_excel_data(){ /*-- For BSNL --*/
		
		$this->load->library('excel');
		if(isset($_FILES["file"]["name"])){
			$path = $_FILES["file"]["tmp_name"];
			$object = PHPExcel_IOFactory::load($path);
			
			$client_id = $this->input->post('client_id');
			$pro_id = $this->input->post('pro_id');
			
			$localDateTime = GetLocalTime();
			//BSNL
			if($client_id == 288 &&  $pro_id == 614){
				$clmarr = array("recording_track_id","sap_id_extension","call_date","aht","fusion_id","customer_number","campaign","first_disposed","disconnected_by","audit_sheet");
			}
			if($client_id == 202 &&  $pro_id == 411){
				$clmarr = array("offer_id","contact_date","aht","fusion_id");
			}
			//Nurture Farm
			if($client_id == 314 && $pro_id== 663){
				$clmarr = array("call_id","call_type","call_date","csat","aht","fusion_id","customer_number","ivr_name","call_disposition","disconnection_party","service_name","ivr_language");
			}
			// Cras 24 Pre-booking
			if($client_id == 246 && $pro_id== 529){
				$clmarr = array("call_id","call_date","process_name","campaign","customer_number","system_disposition","hangup_details","aht","fusion_id","disposition_code","disposition_class");
			}
			// Touch Fuse New
			if($client_id == 134 && $pro_id== 753){
				$rand_table = "qa_randamiser_touchfuse_data";
				$clmarr = array("campaign","call_date","customer_number","aht","fusion_id","customer_disconnection_source");
			}
			//Blains
			if($client_id == 134 && $pro_id== 271){
				$rand_table = "qa_randamiser_blains_data";
				$clmarr = array("campaign","call_date","customer_number","aht","fusion_id","customer_disconnection_source");
			}
			///VIKAS STARTS///

			//Mobikwik

			if($client_id == 345 && $pro_id== 719){
				$rand_table = "qa_randamiser_mobikwik_data";
				$clmarr = array("campaign","call_date","caller_no","aht","fusion_id","call_id","skill","status","dial_status","disposition","hangup_by");
			}

			//Cholamandlam

			if($client_id == 266 && $pro_id== 554){
				$rand_table = "qa_randamiser_cholamandlam_data";
				$clmarr = array("agreement_no","call_date","called_no","fusion_id","call_status","attempts","paymode","branch","bucket","region","last_date_time","aht");
			}

			//Debt Solution 123

			if($client_id == 37 && $pro_id== 49){
				$rand_table = "qa_randamiser_debt_solution_123_data";
				$clmarr = array("call_date","phone_no","fusion_id","call_type","rpc","aht");
			}

			///VIKAS ENDS///
			
			foreach($object->getWorksheetIterator() as $worksheet){
				$highestRow = $worksheet->getHighestRow();
				$highestColumn = $worksheet->getHighestColumn();
				
				$columnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
				$adjustedColumnIndex = $columnIndex + $adjustment;
				$adjustedColumn = PHPExcel_Cell::stringFromColumnIndex($adjustedColumnIndex - 1);
			
				$dd = array();
				$user_list = array();
				
				for($col=0; $col<$adjustedColumnIndex; $col++){
					$colindex = $worksheet->getCellByColumnAndRow($col, 1)->getValue();
					$adjustedColumn = PHPExcel_Cell::stringFromColumnIndex($col);
					//print_r($clmarr);
					foreach($clmarr as $name){
						if($name == $colindex){
							 $dd[$colindex]  = $adjustedColumn;
						}
					}
				}
				//exit;
			
				//$random_row = round(($highestRow * (20/100)));				
				for($row=2; $row<=$highestRow; $row++){
					//print_r($dd);
					foreach($dd as $key=>$d){
					
						if($key=="call_date"){
							$user_list[$row][$key] = date('Y-m-d H:i:s',strtotime($worksheet->getCell($d.$row )->getFormattedValue()));
						}
						else if($key=="contact_date"){
							$user_list[$row][$key] = date('Y-m-d H:i:s',strtotime($worksheet->getCell($d.$row )->getFormattedValue()));
						}
						else if(($key=="last_date_time")){

							 $last_date_time=date('Y-m-d H:i:s',strtotime($worksheet->getCell($d.$row )->getFormattedValue()));
							 //$last_date_time_str = strtotime($last_date_time);

							$user_list[$row][$key] = date('Y-m-d H:i:s',strtotime($worksheet->getCell($d.$row )->getFormattedValue()));
							
						}
						else if(($key=="end_date_time")){

							
							 $end_date_time=date('Y-m-d H:i:s',strtotime($worksheet->getCell($d.$row )->getFormattedValue()));
							 //$end_date_time_str = strtotime($end_date_time);

							$user_list[$row][$key] = date('Y-m-d H:i:s',strtotime($worksheet->getCell($d.$row )->getFormattedValue()));
							
							
						}
						else if($key=="aht"){
							if(($client_id == 134 && $pro_id== 753) || ($client_id == 134 && $pro_id== 271) || ($client_id == 266 && $pro_id== 554) ){
								$user_list[$row][$key] = $this->secToHR($worksheet->getCell($d.$row )->getValue());
							}
							else
							{
								$user_list[$row][$key] = date('H:i:s',strtotime($worksheet->getCell($d.$row )->getFormattedValue()));
							}
							
						}
						else{
							$user_list[$row][$key] = $worksheet->getCell($d.$row )->getValue();
						}

						// if(($client_id == 266 && $pro_id== 554)){
						// 	//echo "ok ----------- here<br>";
						// 	$diff= ($last_date_time) - ($end_date_time);
						// 	$user_list[$row]['aht'] = date('H:i:s',$diff);
						// }
						
						$user_list[$row]['upload_date'] = $localDateTime;
					}	
				}
				//exit;
				// echo "<pre>"; print_r($user_list); echo "</pre>";exit;
				 $client_id = $this->input->post('client_id');
				 $pro_id = $this->input->post('pro_id');
				 if($client_id == 288 &&  $pro_id == 614){
				
					//$this->Qa_randamiser_model->bsnl_insert_excel($user_list);
					$table_name = "qa_randamiser_bsnl_data";
					$this->Qa_randamiser_model->insert_excel_upload($table_name,$user_list);
					redirect('qa_randamiser/data_upload_freshdesk/'.$client_id.'/'.$pro_id);
				 }
				 if($client_id == 202 &&  $pro_id == 411){
					$table_name = "qa_randamiser_indiamart_data";
					$this->Qa_randamiser_model->insert_excel_upload($table_name,$user_list);
					redirect('qa_randamiser/data_upload_freshdesk/'.$client_id.'/'.$pro_id);
				 }
				 if($client_id == 314 && $pro_id== 663){
					 $table_name = "qa_randamiser_nurture_farm_data";
					 $this->Qa_randamiser_model->insert_excel_upload($table_name,$user_list);
					 redirect('qa_randamiser/data_upload_freshdesk/'.$client_id.'/'.$pro_id);
				 }
				// Cras 24 Pre-booking
				if($client_id == 246 && $pro_id== 529){
					 $table_name = "qa_randamiser_cars24_data";
					 $this->Qa_randamiser_model->insert_excel_upload($table_name,$user_list);
					 redirect('qa_randamiser/data_upload_freshdesk/'.$client_id.'/'.$pro_id);
				 }
				 // Touchfuse
				if($client_id == 134 && $pro_id== 753){
					$table_name = "qa_randamiser_touchfuse_data";
					 $this->Qa_randamiser_model->insert_excel_upload($table_name,$user_list);
					 redirect('qa_randamiser/data_upload_freshdesk/'.$client_id.'/'.$pro_id);
				}
				//Blains
				if($client_id == 134 && $pro_id== 271){
					 $table_name = "qa_randamiser_blains_data";
					 $this->Qa_randamiser_model->insert_excel_upload($table_name,$user_list);
					 redirect('qa_randamiser/data_upload_freshdesk/'.$client_id.'/'.$pro_id);
				}
				//vikas start//
				//Mobikwik
				if($client_id == 345 && $pro_id== 719){
					 $table_name = "qa_randamiser_mobikwik_data";
					 $this->Qa_randamiser_model->insert_excel_upload($table_name,$user_list);
					 redirect('qa_randamiser_vikas/data_upload_freshdesk/'.$client_id.'/'.$pro_id);
				}

				//Cholamandlam
				if($client_id == 266 && $pro_id== 554){
					 $table_name = "qa_randamiser_cholamandlam_data";

					 $this->Qa_randamiser_model->insert_excel_upload($table_name,$user_list);
					// exit("okk");
					 redirect('qa_randamiser_vikas/data_upload_freshdesk/'.$client_id.'/'.$pro_id);
				}

				//Debt Solution 123
				if($client_id == 37 && $pro_id== 49){
					 $table_name = "qa_randamiser_debt_solution_123_data";

					 $this->Qa_randamiser_model->insert_excel_upload($table_name,$user_list);
					// exit("okk");
					 redirect('qa_randamiser_vikas/data_upload_freshdesk/'.$client_id.'/'.$pro_id);
				}

				//vikas ends//

				//redirect('qa_randamiser/data_upload_freshdesk/'.$client_id.'/'.$pro_id);
			}
		}
	}
	// function to convert Hrs Min and Sec
	function secToHR($seconds) {
		$hours = floor($seconds / 3600);
		$minutes = floor(($seconds / 60) % 60);
		$seconds = $seconds % 60;
		return "$hours:$minutes:$seconds";
	}
	
	
	

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////	
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////	
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////	

/*******************************************************************/
/*                        UPLOAD DATA                              */
/*******************************************************************/
	
	public function sample_cdr_download(){ /*-- For BSNL --*/
		if(check_logged_in()){ 
			$data['client_id'] = $client_id = $this->uri->segment(3);
			$data['pro_id'] = $pro_id = $this->uri->segment(4);
			
			if($client_id == 288 && $pro_id== 614){
				$file_name = base_url()."qa_files/sampling_randamiser/BSNL_randamiser_file.xlsx";
			}
			if($client_id == 314 && $pro_id== 663){
				$file_name = base_url()."qa_files/sampling_randamiser/Nurture_farms_randamiser_data.xlsx";
			}
			// Cras 24 Pre-booking
			if($client_id == 246 && $pro_id== 529){
				$file_name = base_url()."qa_files/sampling_randamiser/cars24_randamiser_data.xlsx";
			}
			// Touchfuse
			if($client_id == 134 && $pro_id== 753){
				$file_name = base_url()."qa_files/sampling_randamiser/touchfuse_randamiser_data.xlsx";
			}
			// Blains
			if($client_id == 134 && $pro_id== 271){
				$file_name = base_url()."qa_files/sampling_randamiser/blains_randamiser_data.xlsx";
			}

			//vikas start//
			//mobikwik

			if($client_id == 345 && $pro_id== 719){
				$file_name = base_url()."qa_files/sampling_randamiser/mobikwik_sample.xlsx";
			}

			//Cholamandlam

			if($client_id == 266 && $pro_id== 554){
				$file_name = base_url()."qa_files/sampling_randamiser/cholamandalam_randamiser_data.xlsx";
			}

			//Debt Solution 123
			if($client_id == 37 && $pro_id== 49){
				$file_name = base_url()."qa_files/sampling_randamiser/debt_solution_123_inbound_outbound_randamiser_data.xlsx";
			}
			//vikas ends//
		
			//$file_name = base_url()."qa_files/sampling_randamiser/BSNL_randamiser_file.xlsx";
			header("location:".$file_name);	
			exit();
		}
	}
	
	
	
	public function data_upload_freshdesk(){ /*-- Upload CDR File --*/
		if(check_logged_in()){
			$current_user = get_user_id(); 
			$user_office = get_user_office_id(); 
			$data["aside_template"] = "qa_randamiser/aside.php";
			$data["content_template"] = "qa_randamiser/randamiser/data_cdr_upload_freshdesk_vikas.php";
			$data["content_js"] = "qa_randamiser_vikas_js.php";
			//$dn_link ='';
			
			
			
			// $client_id = $this->uri->segment(3);
			// $pro_id = $this->uri->segment(4);
			// $up_date = $this->uri->segment(5);
			// if($client_id ==''){
			// 	$client_id = $this->input->get('client_id');
			// }

			// if($pro_id ==''){
			// 	$pro_id = $this->input->get('pro_id');
			// }

			// if($up_date ==''){
			// 	$up_date = $this->input->get('up_date');
			// }

			$data['client_id'] = $client_id = $this->uri->segment(3);
			$data['pro_id'] = $pro_id = $this->uri->segment(4);

			//vikas start
			$data['up_date'] = $up_date = $this->uri->segment(5);
			// vikas ends
			
			if($client_id == 288 && $pro_id== 614){
				$rand_table = "qa_randamiser_bsnl_data";
			}
			if($client_id == 202 && $pro_id== 411){
				$rand_table = "qa_randamiser_indiamart_data";
			}if($client_id == 314 && $pro_id== 663){
				$rand_table = "qa_randamiser_nurture_farm_data";
			}
			// Cras 24 Pre-booking
			if($client_id == 246 && $pro_id== 529){
				$rand_table = "qa_randamiser_cars24_data";
			}
			// Touch Fuse New
			if($client_id == 134 && $pro_id== 753){
				$rand_table = "qa_randamiser_touchfuse_data";
			}
			// Blains
			if($client_id == 134 && $pro_id== 271){
				$rand_table = "qa_randamiser_blains_data";
			}

			//vikas start//
			//Mobikwik
			if($client_id == 345 && $pro_id== 719){
				 $rand_table = "qa_randamiser_mobikwik_data";
			}


			//Cholamandlam

			if($client_id == 266 && $pro_id== 554){
				 $rand_table = "qa_randamiser_cholamandlam_data";
			}

			//Debt Solution 123

			if($client_id == 37 && $pro_id== 49){
				 $rand_table = "qa_randamiser_debt_solution_123_data";
			}

			//vikas end//
			$qSql = "Select count(*) as count, date(upload_date) as uplDate from $rand_table group by date(upload_date)";
			$data["sampling"] = $this->Common_model->get_query_result_array($qSql);

			$this->load->view("dashboard",$data);
		}
	}
	
	//vikas start
	public function download_qa_randamiser_CSV($client_id,$pro_id,$up_date)
	{
		
		$client_sql = "Select fullname from client where is_active=1 and id='".$client_id."' ";
		$client_res = $this->Common_model->get_query_row_array($client_sql);
		//print_r($client_res);
		//exit();

		if($client_id == 288 && $pro_id== 614){
				$rand_table = "qa_randamiser_bsnl_data";
			}
			if($client_id == 202 && $pro_id== 411){
				$rand_table = "qa_randamiser_indiamart_data";
			}if($client_id == 314 && $pro_id== 663){
				$rand_table = "qa_randamiser_nurture_farm_data";
			}
			// Cras 24 Pre-booking
			if($client_id == 246 && $pro_id== 529){
				$rand_table = "qa_randamiser_cars24_data";
			}
			// Touch Fuse New
			if($client_id == 134 && $pro_id== 753){
				$rand_table = "qa_randamiser_touchfuse_data";
			}
			// Blains
			if($client_id == 134 && $pro_id== 271){
				$rand_table = "qa_randamiser_blains_data";
			}

			//vikas start//
			//Mobikwik
			if($client_id == 345 && $pro_id== 719){
				 $rand_table = "qa_randamiser_mobikwik_data";
			}


			//Cholamandlam

			if($client_id == 266 && $pro_id== 554){
				 $rand_table = "qa_randamiser_cholamandlam_data";
			}

			//Debt Solution 123

			if($client_id == 37 && $pro_id== 49){
				 $rand_table = "qa_randamiser_debt_solution_123_data";
			}


		$sqlR="SELECT xx.*,(select concat(fname, ' ', lname) as name from signin s where s.fusion_id=xx.fusion_id) as agent_name,
		(select concat(fname, ' ', lname) as name from signin s where s.id=(select assigned_to from signin si where si.fusion_id=xx.fusion_id)) as tl_name
				from $rand_table xx WHERE date(xx.upload_date)='".$up_date."'
				 "; 				
				//echo $sqlR;

		$fullAray = $this->Common_model->get_query_result_array($sqlR);

				// echo"<pre>";
				// print_r($fullAray);
				// echo"</pre>";
				// exit();

		//$data["sampling_data"] = $fullAray;
		$this->create_qa_randamiser_CSV($fullAray,$client_id,$pro_id);


		$currDate=date("Y-m-d");
		$filename = "./qa_files/qa_reports_data/Report_".$client_res['fullname'].get_user_id().$client_id.".csv";
		$newfile="QA randamiser ".$client_res['fullname']." Audit List-'".$currDate."'.csv";
		header('Content-Disposition: attachment;  filename="'.$newfile.'"');
		readfile($filename);
	}

	public function create_qa_randamiser_CSV($rr,$client_id,$pro_id)
	{
		// echo $client_id;
		// echo"<br>";
		// echo $pro_id;
		// echo"<br>";
		// print_r($rr);
		// exit;
		$currDate=date("Y-m-d");

		$client_sql = "Select fullname from client where is_active=1 and id='".$client_id."' ";
		$client_res = $this->Common_model->get_query_row_array($client_sql);

		$filename = "./qa_files/qa_reports_data/Report_".$client_res['fullname'].get_user_id().$client_id.".csv";
		$fopen = fopen($filename,"w+");

		if($client_id==37 && $pro_id==49){
			$header = array("fusion_id","agent_name","tl_name","call_date", "aht",
			 "phone_no", "call_type", "rpc", "upload_date");

			$row = "";
			foreach($header as $data) $row .= ''.$data.',';
			fwrite($fopen,rtrim($row,",")."\r\n");
			$searches = array("\r", "\n", "\r\n");

			foreach($rr as $user){
				$row  = '"'.$user['fusion_id'].'",';
				$row .= '"'.$user['agent_name'].'",';
				$row .= '"'.$user['tl_name'].'",';
				$row .= '"'.$user['call_date'].'",';
				$row .= '"'.$user['aht'].'",';
				$row .= '"'.$user['phone_no'].'",';
				$row .= '"'.$user['call_type'].'",';
				$row .= '"'.$user['rpc'].'",';
				$row .= '"'.$user['upload_date'].'",';
				fwrite($fopen,$row."\r\n");
			}
			//exit;
			fclose($fopen);
		} 
		else if($client_id == 288 && $pro_id== 614){
			//  print_r($rr);
			// exit;
			$header = array("fusion_id","agent_name","tl_name","call_date", "aht",
			 "customer_number", "recording_track_id", "sap_id_extension","campaign","first_disposed","disconnected_by", "upload_date");
			$row = "";
			foreach($header as $data) $row .= ''.$data.',';
			fwrite($fopen,rtrim($row,",")."\r\n");
			$searches = array("\r", "\n", "\r\n");

			foreach($rr as $user){
				$row  = '"'.$user['fusion_id'].'",';
				$row .= '"'.$user['agent_name'].'",';
				$row .= '"'.$user['tl_name'].'",';
				$row .= '"'.$user['call_date'].'",';
				$row .= '"'.$user['aht'].'",';
				$row .= '"'.$user['customer_number'].'",';
				$row .= '"'.$user['recording_track_id'].'",';
				$row .= '"'.$user['sap_id_extension'].'",';
				$row .= '"'.$user['campaign'].'",';
				$row .= '"'.$user['first_disposed'].'",';
				$row .= '"'.$user['disconnected_by'].'",';
				$row .= '"'.$user['upload_date'].'",';
				fwrite($fopen,$row."\r\n");
			}
			//exit;
			fclose($fopen);
		}else if($client_id == 202 && $pro_id== 411){
			//  print_r($rr);
			// exit;
			$header = array("fusion_id","agent_name","tl_name","call_date", "aht",
			 "called_no", "out_in", "call_type", "upload_date");
			$row = "";
			foreach($header as $data) $row .= ''.$data.',';
			fwrite($fopen,rtrim($row,",")."\r\n");
			$searches = array("\r", "\n", "\r\n");

			foreach($rr as $user){
				$row  = '"'.$user['fusion_id'].'",';
				$row .= '"'.$user['agent_name'].'",';
				$row .= '"'.$user['tl_name'].'",';
				$row .= '"'.$user['call_date'].'",';
				$row .= '"'.$user['aht'].'",';
				$row .= '"'.$user['called_no'].'",';
				$row .= '"'.$user['out_in'].'",';
				$row .= '"'.$user['call_type'].'",';
				$row .= '"'.$user['upload_date'].'",';
				fwrite($fopen,$row."\r\n");
			}
			//exit;
			fclose($fopen);
		}else if($client_id == 246 && $pro_id== 529){
			//  print_r($rr);
			// exit;
			$header = array("fusion_id","agent_name","tl_name","call_date", "aht",
			 "call_id", "process_name", "customer_number","campaign","system_disposition","hangup_details","disposition_code","disposition_class", "upload_date");
			$row = "";
			foreach($header as $data) $row .= ''.$data.',';
			fwrite($fopen,rtrim($row,",")."\r\n");
			$searches = array("\r", "\n", "\r\n");

			foreach($rr as $user){
				$row  = '"'.$user['fusion_id'].'",';
				$row .= '"'.$user['agent_name'].'",';
				$row .= '"'.$user['tl_name'].'",';
				$row .= '"'.$user['call_date'].'",';
				$row .= '"'.$user['aht'].'",';
				$row .= '"'.$user['call_id'].'",';
				$row .= '"'.$user['process_name'].'",';
				$row .= '"'.$user['customer_number'].'",';
				$row .= '"'.$user['campaign'].'",';
				$row .= '"'.$user['system_disposition'].'",';
				$row .= '"'.$user['hangup_details'].'",';
				$row .= '"'.$user['disposition_code'].'",';
				$row .= '"'.$user['disposition_class'].'",';
				$row .= '"'.$user['upload_date'].'",';
				fwrite($fopen,$row."\r\n");
			}
			//exit;
			fclose($fopen);
		}else if($client_id == 134 && $pro_id== 753){
			//  print_r($rr);
			// exit;
			$header = array("fusion_id","agent_name","tl_name","call_date", "aht",
			 "customer_disconnection_source", "customer_number","campaign", "upload_date");
			$row = "";
			foreach($header as $data) $row .= ''.$data.',';
			fwrite($fopen,rtrim($row,",")."\r\n");
			$searches = array("\r", "\n", "\r\n");

			foreach($rr as $user){
				$row  = '"'.$user['fusion_id'].'",';
				$row .= '"'.$user['agent_name'].'",';
				$row .= '"'.$user['tl_name'].'",';
				$row .= '"'.$user['call_date'].'",';
				$row .= '"'.$user['aht'].'",';
				$row .= '"'.$user['customer_disconnection_source'].'",';
				$row .= '"'.$user['customer_number'].'",';
				$row .= '"'.$user['campaign'].'",';
				$row .= '"'.$user['upload_date'].'",';
				fwrite($fopen,$row."\r\n");
			}
			//exit;
			fclose($fopen);
		}else if($client_id == 134 && $pro_id== 271){
			//  print_r($rr);
			// exit;
			$header = array("fusion_id","agent_name","tl_name","call_date", "aht",
			 "customer_disconnection_source", "customer_number","campaign", "upload_date");
			$row = "";
			foreach($header as $data) $row .= ''.$data.',';
			fwrite($fopen,rtrim($row,",")."\r\n");
			$searches = array("\r", "\n", "\r\n");

			foreach($rr as $user){
				$row  = '"'.$user['fusion_id'].'",';
				$row .= '"'.$user['agent_name'].'",';
				$row .= '"'.$user['tl_name'].'",';
				$row .= '"'.$user['call_date'].'",';
				$row .= '"'.$user['aht'].'",';
				$row .= '"'.$user['customer_disconnection_source'].'",';
				$row .= '"'.$user['customer_number'].'",';
				$row .= '"'.$user['campaign'].'",';
				$row .= '"'.$user['upload_date'].'",';
				fwrite($fopen,$row."\r\n");
			}
			//exit;
			fclose($fopen);
		}else if($client_id == 345 && $pro_id== 719){
			//  print_r($rr);
			// exit;
			$header = array("fusion_id","agent_name","tl_name","call_date", "aht",
			 "caller_no", "call_id","skill","status","dial_status","disposition","hangup_by","campaign", "upload_date");
			$row = "";
			foreach($header as $data) $row .= ''.$data.',';
			fwrite($fopen,rtrim($row,",")."\r\n");
			$searches = array("\r", "\n", "\r\n");

			foreach($rr as $user){
				$row  = '"'.$user['fusion_id'].'",';
				$row .= '"'.$user['agent_name'].'",';
				$row .= '"'.$user['tl_name'].'",';
				$row .= '"'.$user['call_date'].'",';
				$row .= '"'.$user['aht'].'",';
				$row .= '"'.$user['caller_no'].'",';
				$row .= '"'.$user['call_id'].'",';
				$row .= '"'.$user['skill'].'",';
				$row .= '"'.$user['status'].'",';
				$row .= '"'.$user['dial_status'].'",';
				$row .= '"'.$user['disposition'].'",';
				$row .= '"'.$user['hangup_by'].'",';
				$row .= '"'.$user['campaign'].'",';
				$row .= '"'.$user['upload_date'].'",';
				fwrite($fopen,$row."\r\n");
			}
			//exit;
			fclose($fopen);
		}else if($client_id == 266 && $pro_id== 554){
			//  print_r($rr);
			// exit;
			$header = array("fusion_id","agent_name","tl_name","call_date", "aht",
			 "called_no", "agreement_no","call_status","attempts","paymode","branch","bucket","region", "upload_date");
			$row = "";
			foreach($header as $data) $row .= ''.$data.',';
			fwrite($fopen,rtrim($row,",")."\r\n");
			$searches = array("\r", "\n", "\r\n");

			foreach($rr as $user){
				$row  = '"'.$user['fusion_id'].'",';
				$row .= '"'.$user['agent_name'].'",';
				$row .= '"'.$user['tl_name'].'",';
				$row .= '"'.$user['call_date'].'",';
				$row .= '"'.$user['aht'].'",';
				$row .= '"'.$user['called_no'].'",';
				$row .= '"'.$user['agreement_no'].'",';
				$row .= '"'.$user['call_status'].'",';
				$row .= '"'.$user['attempts'].'",';
				$row .= '"'.$user['paymode'].'",';
				$row .= '"'.$user['branch'].'",';
				$row .= '"'.$user['bucket'].'",';
				$row .= '"'.$user['region'].'",';
				$row .= '"'.$user['upload_date'].'",';
				fwrite($fopen,$row."\r\n");
			}
			//exit;
			fclose($fopen);
		}
	}

	//vikas ends
	
/*******************************************************************/
/*                      COMPUTE SAMPLING                           */
/*******************************************************************/
	public function data_randamise_compute_freshdesk(){ /*-- For Compute --*/
		if(check_logged_in()){
			$current_user = get_user_id(); 
			$user_office = get_user_office_id(); 
			
			if(!empty($this->uri->segment(3))){
				$data['client_id'] = $client_id = $this->uri->segment(3);
			}else{
				$data['client_id'] = $client_id = $this->input->post('client_id');
			}
			if(!empty($this->uri->segment(4))){
				$data['pro_id'] = $pro_id = $this->uri->segment(4);
			}else{
				$data['pro_id'] = $pro_id = $this->input->post('pro_id');
			}
			
			$data["aside_template"] = "qa_randamiser/aside.php";
			$pro_cond = "";
			// BSNL
			if($client_id == 288 && $pro_id == 614){
				$data["content_template"] = "qa_randamiser/randamiser/bsnl/data_randamise_compute_freshdesk.php";
				$table = "qa_randamiser_bsnl_data";
				$pro_cond .= " and is_assign_process(S.id,614)";
			}
			// Indiamart
			if($client_id == 202 && $pro_id == 411){
				$data["content_template"] = "qa_randamiser/randamiser/indiamart/data_randamise_compute_freshdesk.php";
				$table = "qa_randamiser_indiamart_data";
				$pro_cond .= " and is_assign_process(S.id,411)";
			}
			// Nurture Farm
			if($client_id == 314 && $pro_id == 663){
				$data["content_template"] = "qa_randamiser/randamiser/nurture_farm/data_randamise_compute_freshdesk.php";
				$table = "qa_randamiser_nurture_farm_data";
				$pro_cond .= " and is_assign_process(S.id,663)";
			}
			// Cras 24 Pre-booking
			if($client_id == 246 && $pro_id== 529){
				$data["content_template"] = "qa_randamiser/randamiser/cars24/data_randamise_compute_freshdesk.php";
				$table = "qa_randamiser_cars24_data";
				$pro_cond .= " and is_assign_process(S.id,497)";
			}
			// Touchfuse
			if($client_id == 134 && $pro_id== 753){
				$data["content_template"] = "qa_randamiser/randamiser/touchfuse/data_randamise_compute_freshdesk.php";
				$table = "qa_randamiser_touchfuse_data";
				$pro_cond .= " and is_assign_process(S.id,753)";
			}
			// Blains
			if($client_id == 134 && $pro_id== 271){
				$data["content_template"] = "qa_randamiser/randamiser/blains/data_randamise_compute_freshdesk.php";
				$table = "qa_randamiser_blains_data";
				$pro_cond .= " and is_assign_process(S.id,271)";
			}

			//VIKAS START//
			//Mobikwik

			if($client_id == 345 && $pro_id== 719){
				$data["content_template"] = "qa_randamiser/randamiser/mobikwik/data_randamise_compute_freshdesk.php";
				$table = "qa_randamiser_mobikwik_data";
				$pro_cond .= " and is_assign_process(S.id,719)";
			}
			//cholamandlam

			if($client_id == 266 && $pro_id== 554){
				$data["content_template"] = "qa_randamiser/randamiser/cholamandlam/data_randamise_compute_freshdesk.php";
				$table = "qa_randamiser_cholamandlam_data";
				$pro_cond .= " and is_assign_process(S.id,554)";
			}

			//Debt Solution 123
			
			if($client_id == 37 && $pro_id== 49){
				$data["content_template"] = "qa_randamiser/randamiser/debt_solution_123/data_randamise_compute_freshdesk.php";
				$table = "qa_randamiser_debt_solution_123_data";
				$pro_cond .= " and is_assign_process(S.id,49)";
			}

			$data["content_js"] = "qa_randamiser_vikas_js.php";
			//VIKAS ENDS//

			
			
			
			
			
		/////////////// Filter Part Start //////////////
			$loc_sql="Select * from office_location where is_active=1";
			$data["location"]=$this->Common_model->get_query_result_array($loc_sql);
			
			$qa_sql="Select s.id, s.fusion_id, s.office_id, concat(s.fname, ' ', s.lname) as name from qa_agent_categorisation a LEFT JOIN signin s on s.id=a.assigned_qa_id where s.status=1 and s.dept_id=5 and a.client_id=$client_id and a.process_id=$pro_id group by a.assigned_qa_id order by name";
			$data["qa"]=$this->Common_model->get_query_result_array($qa_sql);
			//print_r($data["qa"]);
			
			$agnt_sql="Select RCD.fusion_id, concat(S.fname, ' ', S.lname) as agnt_name, S.xpoid, S.fusion_id, S.office_id from $table RCD Left Join signin S On RCD.fusion_id=S.fusion_id where S.status=1 and S.dept_id=6 $pro_cond group by agnt_name";
			$data["agent"]=$this->Common_model->get_query_result_array($agnt_sql);
			
			//print_r($data["agent"]);
			
			//BSNL
			if($table == 'qa_randamiser_bsnl_data'){
				$campaign_sql="Select campaign from $table where campaign is not Null and campaign!='' and compute_status=1 group by campaign";
				$data["campaign"]=$this->Common_model->get_query_result_array($campaign_sql);
				
				$first_disposed_sql="Select first_disposed from $table where first_disposed is not Null and first_disposed!='' and compute_status=1 group by first_disposed";
				$data["first_disposed"]=$this->Common_model->get_query_result_array($first_disposed_sql);
				
				
			}
			//Nurture Farm
			if($table == 'qa_randamiser_nurture_farm_data'){
				$csat_sql="Select csat from $table where csat is not Null and csat!='' and compute_status=1 group by csat";
				$data["csat"]=$this->Common_model->get_query_result_array($csat_sql);
				
				$ivr_name_sql="Select ivr_name from $table where ivr_name is not Null and ivr_name!='' and compute_status=1 group by ivr_name";
				$data["ivr_name"]=$this->Common_model->get_query_result_array($ivr_name_sql);
				
				$call_disposition_sql="Select call_disposition from $table where call_disposition is not Null and call_disposition!='' and compute_status=1 group by call_disposition";
				$data["call_disposition"]=$this->Common_model->get_query_result_array($call_disposition_sql);
				
				$disconnection_party_sql="Select disconnection_party from $table where disconnection_party is not Null and disconnection_party!='' and compute_status=1 group by disconnection_party";
				$data["disconnection_party"]=$this->Common_model->get_query_result_array($disconnection_party_sql);
				
				$service_name_sql="Select service_name from $table where service_name is not Null and service_name!='' and compute_status=1 group by service_name";
				$data["service_name"]=$this->Common_model->get_query_result_array($service_name_sql);
				
				$ivr_language_sql="Select ivr_language from $table where ivr_language is not Null and ivr_language!='' and compute_status=1 group by ivr_language";
				$data["ivr_language"]=$this->Common_model->get_query_result_array($ivr_language_sql);
			}
			//Cars 24
			if($table == 'qa_randamiser_cars24_data'){
				$campaign_sql="Select campaign from $table where campaign is not Null and campaign!='' and compute_status=1 group by campaign";
				$data["campaign"]=$this->Common_model->get_query_result_array($campaign_sql);
				
				$system_disposition_sql="Select system_disposition from $table where system_disposition is not Null and system_disposition!='' and compute_status=1 group by system_disposition";
				$data["system_disposition"]=$this->Common_model->get_query_result_array($system_disposition_sql);
				
				$hangup_details_sql="Select hangup_details from $table where hangup_details is not Null and hangup_details!='' and compute_status=1 group by hangup_details";
				$data["hangup_details"]=$this->Common_model->get_query_result_array($hangup_details_sql);
				
				$disposition_code_sql="Select disposition_code from $table where disposition_code is not Null and disposition_code!='' and compute_status=1 group by disposition_code";
				$data["disposition_code"]=$this->Common_model->get_query_result_array($disposition_code_sql);
				
				$disposition_class_sql="Select disposition_class from $table where disposition_class is not Null and disposition_class!='' and compute_status=1 group by disposition_class";
				$data["disposition_class"]=$this->Common_model->get_query_result_array($disposition_class_sql);
			}
			//Touchfuse
			if($table == 'qa_randamiser_touchfuse_data'){
				$campaign_sql="Select campaign from $table where campaign is not Null and campaign!='' and compute_status=1 group by campaign";
				$data["campaign"]=$this->Common_model->get_query_result_array($campaign_sql);
				
				$customer_disconnection_source_sql="Select customer_disconnection_source from $table where customer_disconnection_source is not Null and customer_disconnection_source!='' and compute_status=1 group by customer_disconnection_source";
				$data["customer_disconnection_source"]=$this->Common_model->get_query_result_array($customer_disconnection_source_sql);
				
			}
			//Blains
			if($table == 'qa_randamiser_blains_data'){
				$campaign_sql="Select campaign from $table where campaign is not Null and campaign!='' and compute_status=1 group by campaign";
				$data["campaign"]=$this->Common_model->get_query_result_array($campaign_sql);
				
				$customer_disconnection_source_sql="Select customer_disconnection_source from $table where customer_disconnection_source is not Null and customer_disconnection_source!='' and compute_status=1 group by customer_disconnection_source";
				$data["customer_disconnection_source"]=$this->Common_model->get_query_result_array($customer_disconnection_source_sql);
				
			}

			//VIKAS START//
			//Mobikwik
			if($table == 'qa_randamiser_mobikwik_data'){
				$campaign_sql="Select campaign from $table where campaign is not Null and campaign!='' and compute_status=1 group by campaign";
				$data["campaign"]=$this->Common_model->get_query_result_array($campaign_sql);
				
				$dial_status_sql="Select dial_status from $table where dial_status is not Null and dial_status!='' and compute_status=1 group by dial_status";
				$data["dial_status_source"]=$this->Common_model->get_query_result_array($dial_status_sql);

				$disposition_sql="Select disposition from $table where disposition is not Null and disposition!='' and compute_status=1 group by disposition";
				$data["disposition_source"]=$this->Common_model->get_query_result_array($disposition_sql);

				$hangup_by_sql="Select hangup_by from $table where hangup_by is not Null and hangup_by!='' and compute_status=1 group by hangup_by";
				$data["hangup_by_source"]=$this->Common_model->get_query_result_array($hangup_by_sql);
				
			}

			//Cholamandlam

			if($table == 'qa_randamiser_cholamandlam_data'){
				$call_status_sql="Select call_status from $table where call_status is not Null and call_status!='' and compute_status=1 group by call_status";
				$data["call_status"]=$this->Common_model->get_query_result_array($call_status_sql);
				
				$attempts_sql="Select attempts from $table where attempts is not Null and attempts!='' and compute_status=1 group by attempts";
				$data["attempts_status"]=$this->Common_model->get_query_result_array($attempts_sql);

				$paymode_sql="Select paymode from $table where paymode is not Null and paymode!='' and compute_status=1 group by paymode";
				$data["paymode_source"]=$this->Common_model->get_query_result_array($paymode_sql);

				$branch_sql="Select branch from $table where branch is not Null and branch!='' and compute_status=1 group by branch";
				$data["branch_source"]=$this->Common_model->get_query_result_array($branch_sql);

				$bucket_sql="Select bucket from $table where bucket is not Null and bucket!='' and compute_status=1 group by bucket";
				$data["bucket_source"]=$this->Common_model->get_query_result_array($bucket_sql);

				$region_sql="Select region from $table where region is not Null and region!='' and compute_status=1 group by region";
				$data["region_source"]=$this->Common_model->get_query_result_array($region_sql);
				
			}

			//Debt Solution 123

			if($table == 'qa_randamiser_debt_solution_123_data'){
				$call_type_sql="Select call_type from $table where call_type is not Null and call_type!='' and compute_status=1 group by call_type";
				$data["call_type"]=$this->Common_model->get_query_result_array($call_type_sql);
				
				$rpc_sql="Select rpc from $table where rpc is not Null and rpc!='' and compute_status=1 group by rpc";
				$data["rpc_source"]=$this->Common_model->get_query_result_array($rpc_sql);
			}

			//VIKAS ENDS//
			
			$off_cond="";
			$agent_cond="";
			$call_queue_cond="";
			$aht_cond="";
			$qa_id_cond="";
			
			$from_date="";
			$fusion_id="";
			$call_queue="";
			$aht="";
			$qa_id="";
			
			// for BSNL
			$campaign = "";
			$first_disposed = "";
				
			$campaign_cond = "";
			$first_disposed_cond = "";
			
			// for Nurture Farm
			$csat="";
			$ivr_name="";
			$call_disposition="";
			$disconnection_party="";
			$service_name="";
			$ivr_language="";
			
			$csat_cond="";
			$ivr_name_cond="";
			$call_disposition_cond="";
			$disconnection_party_cond="";
			$service_name_cond="";
			$ivr_language_cond="";
			
			// for Cars24 pre booking
			$campaign="";
			$system_disposition="";
			$hangup_details="";
			$disposition_code="";
			$disposition_class="";			
			
			$campaign_cond="";
			$system_disposition_cond="";
			$hangup_details_cond="";
			$disposition_code_cond="";
			$disposition_class_cond="";
			
			// for Touchfuse & Blains
			
			$customer_disconnection_source ="";
			$customer_disconnection_source_cond ="";
			
			
		/////////////// Filter Part End //////////////
			
			$sampling_data = array();
			if($this->input->post('submit')=='Submit')
			{
				$from_date = $this->input->post('from_date');
				$fusion_id = $this->input->post('fusion_id');
				$qa_id = $this->input->post('qa_id');
				$aht = $this->input->post('call_duration');
				$client_id = $this->input->post('client_id');
				$pro_id = $this->input->post('pro_id');
				$campaign = $this->input->post('campaign');
				$first_disposed = $this->input->post('first_disposed');
				
				//Nurture Farm
				$csat=$this->input->post('csat');
				$ivr_name=$this->input->post('ivr_name');
				$call_disposition=$this->input->post('call_disposition');
				$disconnection_party=$this->input->post('disconnection_party');
				$service_name=$this->input->post('service_name');
				$ivr_language=$this->input->post('ivr_language');
				
				//Cars24 Pre Bookings
				$system_disposition=$this->input->post('system_disposition');
				$hangup_details=$this->input->post('hangup_details');
				$disposition_code=$this->input->post('disposition_code');
				$disposition_class=$this->input->post('disposition_class');
				
				// TouchFuse & Blains
				$customer_disconnection_source=$this->input->post('customer_disconnection_source');
				//VIKAS START//
				//Mobikwik
				$disposition_mobi = "";
				$status_details ="";
				$hangup_by = "";
				$disposition_mobi = "";
				//$mobikwik_disposition=$this->input->post('disposition');
				$status_details = $this->input->post('dial_status');
				$hangup_by = $this->input->post('hangup_by');
				$disposition_mobi=$this->input->post('disposition');
				
				//Cholamandlam///

				$call_status_chola = "";
				$attempts_chola ="";
				$paymode_chola = "";
				$branch_chola = "";
				$bucket_chola = "";
				$region_chola = "";

				$call_status_chola 	=	$this->input->post('call_status');
				$attempts_chola 	=	$this->input->post('attempts');
				$paymode_chola 		=	$this->input->post('paymode');
				$branch_chola		=	$this->input->post('branch');
				$bucket_chola		=	$this->input->post('bucket');
				$region_chola		=	$this->input->post('region');

				//Debt Solution 123

				$call_type_debit = "";
				$rpc_debit       = "";
				$call_type_debit 	=	$this->input->post('call_type');
				$rpc_debit 			=	$this->input->post('rpc');

				//VIKAS ENDS//
				
				
				
			//////////////////////// Add Compute Logic /////////////////////////
				$log=get_logs();
			
				if(!empty($fusion_id)) $agent_id_sel = implode(',',$fusion_id);
				else $agent_id_sel = "";				

				if(!empty($aht)) $aht_sel = implode(',',$aht);
				else $aht_sel = "";
				
				if(!empty($qa_id)) $qa_id_sel = implode(',',$qa_id);
				else $qa_id_sel = "";
				
				if(!empty($campaign)) $campaign_sel = implode(',',$campaign);
				else $campaign_sel = "";
				
				if(!empty($first_disposed)) $first_disposed_sel = implode(',',$first_disposed);
				else $first_disposed_sel = "";
				
				// Nurture Farm
				
				if(!empty($csat)) $csat_sel = implode(',',$csat);
				else $csat_sel = "";
				
				if(!empty($ivr_name)) $ivr_name_sel = implode(',',$ivr_name);
				else $ivr_name_sel = "";
				
				if(!empty($call_disposition)) $call_disposition_sel = implode(',',$call_disposition);
				else $call_disposition_sel = "";
				
				if(!empty($disconnection_party)) $disconnection_party_sel = implode(',',$disconnection_party);
				else $disconnection_party_sel = "";
				
				if(!empty($service_name)) $service_name_sel = implode(',',$service_name);
				else $service_name_sel = "";
				
				if(!empty($ivr_language)) $ivr_language_sel = implode(',',$ivr_language);
				else $ivr_language_sel = "";
				
				// Cars24 Pre Booking
				
				if(!empty($system_disposition)) $system_disposition_sel = implode(',',$system_disposition);
				else $system_disposition_sel = "";
				
				if(!empty($hangup_details)) $hangup_details_sel = implode(',',$hangup_details);
				else $hangup_details_sel = "";
				
				if(!empty($disposition_code)) $disposition_code_sel = implode(',',$disposition_code);
				else $disposition_code_sel = "";
				
				if(!empty($disposition_class)) $disposition_class_sel = implode(',',$disposition_class);
				else $disposition_class_sel = "";
				
				// Touchfuse & Blains
				if(!empty($customer_disconnection_source)) $customer_disconnection_source_sel = implode(',',$customer_disconnection_source);
				else $customer_disconnection_source_sel = "";

				//VIKAS START//
				//Mobikwik
				if(!empty($hangup_by)) $hangup_by_con = implode(',',$hangup_by);
				else $hangup_by_con = "";

				if(!empty($status_details)) $status_details_con = implode(',',$status_details);
				else $status_details_con = "";

				if(!empty($disposition_mobi)) $mobikwik_disposition = implode(',',$disposition_mobi);
				else $mobikwik_disposition = "";

				//Cholamandlam
				if(!empty($call_status_chola)) $call_status_chola_con = implode(',',$call_status_chola);
				else $call_status_chola_con = "";

				if(!empty($attempts_chola)) $attempts_chola_con = implode(',',$attempts_chola);
				else $attempts_chola_con = "";

				if(!empty($paymode_chola)) $paymode_chola_con = implode(',',$paymode_chola);
				else $paymode_chola_con = "";

				if(!empty($branch_chola)) $branch_chola_con = implode(',',$branch_chola);
				else $branch_chola_con = "";

				if(!empty($bucket_chola)) $bucket_chola_con = implode(',',$bucket_chola);
				else $bucket_chola_con = "";

				if(!empty($region_chola)) $region_chola_con = implode(',',$region_chola);
				else $region_chola_con = "";

				//Debt Solution 123

				if(!empty($call_type_debit)) $call_type_debit_con = implode(',',$call_type_debit);
				else $call_type_debit_con = "";

				if(!empty($rpc_debit)) $rpc_debit_con = implode(',',$rpc_debit);
				else $rpc_debit_con = "";

				//VIKAS ENDS//
				
				
				$ext_cond ="";
				$sel_field="";
				
				//////////////////////////
				$sqlAgentTar = "SELECT s.fusion_id, audit_target as monthly_target, (audit_target/4) as weekly_target FROM qa_agent_categorisation a LEFT JOIN signin s ON a.agent_id=s.id WHERE a.client_id=$client_id AND a.process_id=$pro_id";
				$target_data = $this->Common_model->get_query_result_array($sqlAgentTar);
				//print_r($target_data);exit;
				//////////////////////////
				
				//BSNL		
				if($client_id ==288 && $pro_id==614){
					$_field_array = array(
						"from_date" => $from_date,
						"office_id" => $office_id,
						"agent_id" => $agent_id_sel,
						"qa_id" => $qa_id_sel,
						"aht" => $aht_sel,
						"campaign" => $campaign_sel,
						"first_disposed" => $first_disposed_sel,
						"log" => $log
					);	
					$comp_table = "qa_randamiser_compute_logic";
					$rand_table = "qa_randamiser_bsnl_data";
					$sel_field = "RCD.id as rand_id,RCD.fusion_id, RCD.aht,RCD.campaign,RCD.first_disposed,
									TIME_TO_SEC(aht) as aht_sec,
									RCD.compute_status, RCD.audit_status, 
									S.xpoid, S.fusion_id, DATEDIFF(CURDATE(), S.doj) as tenure";
					$ext_cond = "";
				}
				//Indiamart
				if($client_id ==202 && $pro_id==411){
					$_field_array = array(
						"from_date" => $from_date,
						"office_id" => $office_id,
						"agent_id" => $agent_id_sel,
						"aht" => $aht_sel,
						"log" => $log
					);	
					$comp_table = "qa_randamiser_compute_logic_indiamart";
					$rand_table = "qa_randamiser_indiamart_data";
					$sel_field = "RCD.id as rand_id, RCD.fusion_id, RCD.aht,
									TIME_TO_SEC(aht) as aht_sec,
									RCD.compute_status, RCD.audit_status, 
									S.xpoid, S.fusion_id, DATEDIFF(CURDATE(), S.doj) as tenure";
				}
				//Nurture Farm 
				if($client_id == 314 && $pro_id == 663){
					$_field_array = array(
						"from_date" => $from_date,
						"office_id" => $office_id,
						"agent_id" => $agent_id_sel,
						"aht" => $aht_sel,
						"csat" => $csat_sel,
						"ivr_name" => $ivr_name_sel,
						"call_disposition" => $call_disposition_sel,
						"disconnection_party" => $disconnection_party_sel,
						"service_name" => $service_name_sel,
						"ivr_language" => $ivr_language_sel,
						"log" => $log
					);	
					$comp_table = "qa_randamiser_compute_logic_nurture_farm";
					$rand_table = "qa_randamiser_nurture_farm_data";
					$sel_field = "RCD.id as rand_id, RCD.fusion_id, RCD.aht,
									TIME_TO_SEC(aht) as aht_sec,
									RCD.compute_status, RCD.audit_status, 
									S.xpoid, S.fusion_id, DATEDIFF(CURDATE(), S.doj) as tenure";
				}
				// Cras 24 Pre-booking
				if($client_id == 246 && $pro_id== 529){
					$_field_array = array(
						"from_date" => $from_date,
						"office_id" => $office_id,
						"agent_id" => $agent_id_sel,
						"aht" => $aht_sel,
						"campaign" => $campaign_sel,
						"system_disposition" => $system_disposition_sel,
						"hangup_details" => $hangup_details_sel,
						"disposition_code" => $disposition_code_sel,
						"disposition_class" => $disposition_class_sel,
						"log" => $log
					);	
					$comp_table = "qa_randamiser_compute_logic_cars24";
					$rand_table = "qa_randamiser_cars24_data";
					$sel_field = "RCD.id as rand_id, RCD.fusion_id, RCD.aht,
									TIME_TO_SEC(aht) as aht_sec,
									RCD.compute_status, RCD.audit_status, 
									S.xpoid, S.fusion_id, DATEDIFF(CURDATE(), S.doj) as tenure";
				}
				// Touchfuse
				if($client_id == 134 && $pro_id== 753){
					$_field_array = array(
						"from_date" => $from_date,
						"agent_id" => $agent_id_sel,
						"qa_id" => $qa_id_sel,
						"aht" => $aht_sel,
						"campaign" => $campaign_sel,
						"customer_disconnection_source" => $customer_disconnection_source_sel,
						"log" => $log
					);	
					$comp_table = "qa_randamiser_compute_logic_touchfuse";
					$rand_table = "qa_randamiser_touchfuse_data";
					$sel_field = "RCD.id as rand_id, RCD.fusion_id, RCD.aht,
									TIME_TO_SEC(aht) as aht_sec,
									RCD.compute_status, RCD.audit_status, 
									S.xpoid, S.fusion_id, DATEDIFF(CURDATE(), S.doj) as tenure";
				}
				
				// Blains
				if($client_id == 134 && $pro_id== 271){
					$_field_array = array(
						"from_date" => $from_date,
						"agent_id" => $agent_id_sel,
						"qa_id" => $qa_id_sel,
						"aht" => $aht_sel,
						"campaign" => $campaign_sel,
						"customer_disconnection_source" => $customer_disconnection_source_sel,
						"log" => $log
					);	
					$comp_table = "qa_randamiser_compute_logic_blains";
					$rand_table = "qa_randamiser_blains_data";
					$sel_field = "RCD.id as rand_id, RCD.fusion_id, RCD.aht,
									TIME_TO_SEC(aht) as aht_sec,
									RCD.compute_status, RCD.audit_status, 
									S.xpoid, S.fusion_id, DATEDIFF(CURDATE(), S.doj) as tenure";
				}

				//VIKAS START//
				//Mobikwik
				if($client_id == 345 && $pro_id== 719){
					$_field_array = array(
						"from_date" => $from_date,
						"agent_id" => $agent_id_sel,
						"qa_id" => $qa_id_sel,
						"aht" => $aht_sel,
						"campaign" => $campaign_sel,
						"hangup_by" => $hangup_by_con,
						"dial_status" => $status_details_con,
						"disposition" => $mobikwik_disposition,
						"log" => $log
					);	
					$comp_table = "qa_randamiser_compute_logic_mobikwik";
					//$comp_table = "qa_randamiser_compute_logic_blains";
					$rand_table = "qa_randamiser_mobikwik_data";
					$sel_field = "RCD.id as rand_id, RCD.fusion_id, RCD.aht,
									TIME_TO_SEC(aht) as aht_sec,
									RCD.compute_status, RCD.audit_status, 
									S.xpoid, S.fusion_id, DATEDIFF(CURDATE(), S.doj) as tenure";
				}

				//Cholamandlam
				if($client_id == 266 && $pro_id== 554){
					$_field_array = array(
						"from_date" => $from_date,
						"agent_id" => $agent_id_sel,
						"qa_id" => $qa_id_sel,
						"aht" => $aht_sel,
						"call_status" => $call_status_chola_con,
						"attempts" => $attempts_chola_con,
						"paymode" => $paymode_chola_con,
						"branch" => $branch_chola_con,
						"bucket" => $bucket_chola_con,
						"region" => $region_chola_con,
						"log" => $log
					);	
					$comp_table = "qa_randamiser_compute_logic_cholamandlam";
					//$comp_table = "qa_randamiser_compute_logic_blains";
					$rand_table = "qa_randamiser_cholamandlam_data";
					$sel_field = "RCD.id as rand_id, RCD.fusion_id, RCD.aht,
									TIME_TO_SEC(aht) as aht_sec,
									RCD.compute_status, RCD.audit_status, 
									S.xpoid, S.fusion_id, DATEDIFF(CURDATE(), S.doj) as tenure";
				}

				//Debt Solution 123

				if($client_id == 37 && $pro_id== 49){
					$_field_array = array(
						"from_date" => $from_date,
						"agent_id" => $agent_id_sel,
						"qa_id" => $qa_id_sel,
						"aht" => $aht_sel,
						"call_type" => $call_type_debit_con,
						"rpc" => $rpc_debit_con,
						"log" => $log
					);	
					$comp_table = "qa_randamiser_compute_logic_debt_solution_123";
					//$comp_table = "qa_randamiser_compute_logic_blains";
					$rand_table = "qa_randamiser_debt_solution_123_data";
					$sel_field = "RCD.id as rand_id, RCD.fusion_id, RCD.aht,
									TIME_TO_SEC(aht) as aht_sec,
									RCD.compute_status, RCD.audit_status, 
									S.xpoid, S.fusion_id, DATEDIFF(CURDATE(), S.doj) as tenure";
				}

				//VIKAS ENDS//
				
				$compute_id = data_inserter($comp_table,$_field_array);
			
				
			///////// SQL Condition Start ////////////
				$month_search=date('F Y', strtotime($from_date));
				if($month_search!=""){
					$monthwise_array=explode(" ",$month_search);
					$mw_month=$monthwise_array[0];
					$mw_year=$monthwise_array[1];
				}
				
				if($fusion_id!=""){
					$fusion_id=implode("','", $fusion_id);
					$agent_cond .=" and S.fusion_id in ('$fusion_id')";
				}
				if($qa_id!=""){
					$qa_id=implode("','", $qa_id);
					$qa_id_cond .=" and a.assigned_qa_id in ('$qa_id')";
				}
				if($campaign!=""){
					$campaign=implode("','", $campaign);
					$campaign_cond .=" and RCD.campaign in ('$campaign')";
				}
				
				if($first_disposed!=""){
					$first_disposed=implode("','", $first_disposed);
					$first_disposed_cond .=" and RCD.first_disposed in ('$first_disposed')";
				}
				if($aht!=""){
					$aht=implode(" OR ", $aht);
					$aht_cond .=" and ($aht)";
				}
				// Nurture Farm 
				
				if($csat!=""){
					$csat=implode("','", $csat);
					$csat_cond .=" and RCD.csat in ('$csat')";
				}
				
				if($ivr_name!=""){
					$ivr_name=implode("','", $ivr_name);
					$ivr_name_cond .=" and RCD.ivr_name in ('$ivr_name')";
				}
				if($call_disposition!=""){
					$call_disposition=implode("','", $call_disposition);
					$call_disposition_cond .=" and RCD.call_disposition in ('$call_disposition')";
				}
				
				if($disconnection_party!=""){
					$disconnection_party=implode("','", $disconnection_party);
					$disconnection_party_cond .=" and RCD.disconnection_party in ('$disconnection_party')";
				}
				
				if($service_name!=""){
					$service_name=implode("','", $service_name);
					$service_name_cond .=" and RCD.service_name in ('$service_name')";
				}
				
				if($ivr_language!=""){
					$ivr_language=implode("','", $ivr_language);
					$ivr_language_cond .=" and RCD.ivr_language in ('$ivr_language')";
				}
				if($client_id==314 && $pro_id==663){
					$ext_cond .= $csat_cond. $ivr_name_cond.$call_disposition_cond.$disconnection_party_cond.$service_name_cond.$ivr_language_cond;
				}
				
				// Cars 24 Pre Booking
								
				if($system_disposition!=""){
					$system_disposition=implode("','", $system_disposition);
					$system_disposition_cond .=" and RCD.system_disposition in ('$system_disposition')";
				}
				if($hangup_details!=""){
					$hangup_details=implode("','", $hangup_details);
					$hangup_details_cond .=" and RCD.hangup_details in ('$hangup_details')";
				}
				if($disposition_code!=""){
					$disposition_code=implode("','", $disposition_code);
					$disposition_code_cond .=" and RCD.disposition_code in ('$disposition_code')";
				}
				if($disposition_class!=""){
					$disposition_class=implode("','", $disposition_class);
					$disposition_class_cond .=" and RCD.disposition_class in ('$disposition_class')";
				}
				
				if($client_id == 246 && $pro_id== 529){
					$ext_cond .= $system_disposition_cond. $hangup_details_cond.$disposition_code_cond.$disposition_class_cond;
				}
				
				// Touchfuse & Blains
				if($customer_disconnection_source!=""){
					$customer_disconnection_source=implode("','", $customer_disconnection_source);
					$customer_disconnection_source_cond .=" and RCD.customer_disconnection_source in ('$customer_disconnection_source')";
				}
				if($client_id == 134 && $pro_id== 753){
					$ext_cond .= $customer_disconnection_source_cond;
				}
				// Blains ext cond
				if($client_id == 134 && $pro_id== 271){
					$ext_cond .= $customer_disconnection_source_cond;
				}

				//vikas start//
				$hangup_bys=$this->input->post('hangup_by');
				$dial_status_details=$this->input->post('dial_status');
				if($hangup_bys!=""){
					$hangup_details=implode("','", $hangup_bys);
					$hangup_details_cond .=" and RCD.hangup_by in ('$hangup_details')";
				}
				if($dial_status_details!=""){
					$status_details=implode("','", $dial_status_details);
					$status_details_cond .=" and RCD.dial_status in ('$status_details')";
				}
				if($disposition_mobi!=""){
					$disposition_class=implode("','", $disposition_mobi);
					$disposition_class_cond .=" and RCD.disposition in ('$disposition_class')";
				}

				if($client_id == 345 && $pro_id== 719){
					$ext_cond .= $hangup_details_cond. $status_details_cond.$disposition_class_cond;
				}

				//Cholamandlam

				//$call_status_cholas 	=	$this->input->post('call_status');
				// $attempts_cholas 		=	$this->input->post('attempts');
				// $paymode_cholas 		=	$this->input->post('paymode');
				// $branch_cholas			=	$this->input->post('branch');
				// $bucket_cholas			=	$this->input->post('bucket');
				// $region_cholas			=	$this->input->post('region');

				if($call_status_chola!=""){
					$call_statusCholas=implode("','", $call_status_chola);
					$call_statusCholas_cond .=" and RCD.call_status in ('$call_statusCholas')";
				}
				if($attempts_chola!=""){
					$attemptsCholas=implode("','", $attempts_chola);
					$attemptsCholas_cond .=" and RCD.attempts in ('$attemptsCholas')";
				}
				if($paymode_chola!=""){
					$paymodeCholas=implode("','", $paymode_chola);
					$paymodeCholas_cond .=" and RCD.paymode in ('$paymodeCholas')";
				}

				if($branch_chola!=""){
					$branchCholas=implode("','", $branch_chola);
					$branchCholas_cond .=" and RCD.branch in ('$branchCholas')";
				}

				if($bucket_chola!=""){
					$bucketCholas=implode("','", $bucket_chola);
					$bucketCholas_cond .=" and RCD.bucket in ('$bucketCholas')";
				}

				if($region_chola!=""){
					$regionCholas=implode("','", $region_chola);
					$regionCholas_cond .=" and RCD.region in ('$regionCholas')";
				}

				if($client_id == 266 && $pro_id== 554){
					$ext_cond .= $call_statusCholas_cond. $attemptsCholas_cond.$paymodeCholas_cond.$branchCholas_cond.$bucketCholas_cond.$regionCholas_cond;
				}

				//Debt Solution 123

				//$call_type_debit 	=	$this->input->post('call_type');
				//$rpc_debit 			=	$this->input->post('rpc');

				if($call_type_debit!=""){
					$call_type_debit=implode("','", $call_type_debit);
					$call_type_debit_cond .=" and RCD.call_type in ('$call_type_debit')";
				}
				if($rpc_debit!=""){
					$rpc_debit=implode("','", $rpc_debit);
					$rpc_debit_cond .=" and RCD.rpc in ('$rpc_debit')";
				}

				if($client_id == 37 && $pro_id== 49){
					$ext_cond .= $call_type_debit_cond. $rpc_debit_cond;
				}

				//vikas ends//
				
			///////// SQL Condition End ////////////
			
				
				
				/* $randSql="Select $sel_field
				from $rand_table RCD Left Join signin S On RCD.fusion_id=S.fusion_id
				where S.status=1 $pro_cond and RCD.compute_status=1 and RCD.audit_status=0
				and date(RCD.upload_date)='$from_date' $agent_cond $ext_cond $campaign_cond $first_disposed_cond
				having 1 $aht_cond"; */
				
				$randSql="Select $sel_field
				from $rand_table RCD LEFT JOIN signin S On RCD.fusion_id=S.fusion_id
				LEFT JOIN qa_agent_categorisation a ON a.agent_id = S.id
				where S.status=1 $pro_cond and RCD.compute_status=1 and RCD.audit_status=0
				and date(RCD.upload_date)='$from_date' $agent_cond $ext_cond $campaign_cond $first_disposed_cond $qa_id_cond
				having 1 $aht_cond";
				
				//exit;
				
				$sampling_data = $this->Common_model->get_query_result_array($randSql);
				
			//	print_r($sampling_data); exit;
				foreach($sampling_data as $row){
					$fusion_id=$row["fusion_id"];
					$rand_id = $row["rand_id"];
					//$this->db->query("Update $rand_table set compute_status=2, compute_by='$current_user' where fusion_id='$fusion_id' and date(upload_date)='$from_date'");
					$this->db->query("Update $rand_table set compute_status=2, compute_by='$current_user' where id='$rand_id' and date(upload_date)='$from_date'");
				}
				
				$url = "qa_randamiser_vikas/data_distribute_freshdesk/".$client_id."/".$pro_id;
				redirect($url);
			}
			$this->load->view('dashboard',$data);
		}
	}
	
	
	

	
/*******************************************************************/
/*                     DATA DISTRIBUTION                           */
/*******************************************************************/
	public function data_distribute_freshdesk(){ /*-- For BSNL --*/
		if(check_logged_in()){
			$current_user = get_user_id(); 
			//$user_office = get_user_office_id(); 
			
			if(!empty($this->uri->segment(3))){
				$data['client_id'] = $client_id = $this->uri->segment(3);
			}else{
				$data['client_id'] = $client_id = $this->input->get('client_id');
			}
			if(!empty($this->uri->segment(4))){
				$data['pro_id'] = $pro_id = $this->uri->segment(4);
			}else{
				$data['pro_id'] = $pro_id = $this->input->get('pro_id');
			}
			$data["aside_template"] = "qa_randamiser/aside.php";
			$data["content_template"] = "qa_randamiser/randamiser/data_distribute_freshdesk_vikas.php";
			$data["content_js"] = "qa_randamiser_vikas_js.php";
			
			
			
			$from_date="";
			$cond="";
			$randCond="";
			$rand_tbl="";
			
			
			
			$loc_sql="Select * from office_location where is_active=1";
			$data["location"]=$this->Common_model->get_query_result_array($loc_sql);
			
			$qa_sql="Select id, fusion_id, office_id, concat(fname, ' ', lname) as name from signin where status=1 and dept_id=5 order by name";
			$data["qa"]=$this->Common_model->get_query_result_array($qa_sql);
			
			$data["sampling_data"] = array();
			
			if($this->input->get('submit')=='Submit')
			{
				$sel_fields="";
				$sel_distribute_fields="";
				$from_date = $this->input->get('from_date');
				if($client_id==202 && $pro_id==411){
					$rand_tbl='qa_randamiser_indiamart_data';
					$sel_fields = "RCD.id as rand_id, RCD.fusion_id, RCD.aht, RCD.compute_status,RCD.audit_sheet, RCD.audit_status, date(RCD.upload_date) as upl_date,RCD.offer_id, S.fusion_id";
					
					$sel_distribute_fields=", SA.offer_id as recording_track_id";
				}
				//BSNL
				if($client_id==288 && $pro_id==614){
					$rand_tbl='qa_randamiser_bsnl_data';
					$sel_fields = "RCD.fusion_id,RCD.id as rand_id, RCD.aht, RCD.compute_status,RCD.call_date, RCD.audit_status, date(RCD.upload_date) as upl_date,RCD.recording_track_id, S.id as agent_id";
					$sel_distribute_fields=", SA.recording_track_id,SA.audit_sheet";
					$compCondTable = "qa_randamiser_compute_logic";
				}
				//Nurture Farm
				if($client_id==314 && $pro_id==663){
					$rand_tbl='qa_randamiser_nurture_farm_data';
					$sel_fields = "RCD.id as rand_id, RCD.fusion_id, RCD.aht,RCD.customer_number, RCD.compute_status,RCD.call_date, RCD.audit_status, date(RCD.upload_date) as upl_date, S.fusion_id, S.id as agent_id";
					$sel_distribute_fields=", SA.call_id as recording_track_id";
					$compCondTable = "qa_randamiser_compute_logic_nurture_farm";
				}
				// Cras 24 Pre-booking
				if($client_id == 246 && $pro_id== 529){
					$rand_tbl='qa_randamiser_cars24_data';
					$sel_fields = "RCD.id as rand_id, RCD.fusion_id, RCD.aht,RCD.customer_number, RCD.compute_status,RCD.call_date, RCD.audit_status, date(RCD.upload_date) as upl_date, S.fusion_id, S.id as agent_id";
					$sel_distribute_fields=", SA.call_id as recording_track_id";
					$compCondTable = "qa_randamiser_compute_logic_cars24";
				}
				// Touchfuse
				if($client_id == 134 && $pro_id== 753){
					$rand_tbl='qa_randamiser_touchfuse_data';
					$sel_fields = "RCD.id as rand_id, RCD.fusion_id, RCD.aht,RCD.customer_number, RCD.compute_status,RCD.call_date, RCD.audit_status, date(RCD.upload_date) as upl_date, S.fusion_id, S.id as agent_id";
					$sel_distribute_fields="";
					$compCondTable = "qa_randamiser_compute_logic_touchfuse";
				}
				// Blains
				if($client_id == 134 && $pro_id== 271){
					$rand_tbl='qa_randamiser_blains_data';
					$sel_fields = "RCD.id as rand_id, RCD.fusion_id, RCD.aht,RCD.customer_number, RCD.compute_status,RCD.call_date, RCD.audit_status, date(RCD.upload_date) as upl_date, S.fusion_id, S.id as agent_id";
					$sel_distribute_fields="";
					$compCondTable = "qa_randamiser_compute_logic_blains";
				}

				//VIKAS START//
				//Mobikwik
				if($client_id == 345 && $pro_id== 719){
					$rand_tbl='qa_randamiser_mobikwik_data';
					$sel_fields = "RCD.id as rand_id, RCD.fusion_id, RCD.aht,RCD.caller_no, RCD.compute_status,RCD.call_date, RCD.audit_status, date(RCD.upload_date) as upl_date, S.fusion_id, S.id as agent_id";
					$sel_distribute_fields="";
					$compCondTable = "qa_randamiser_compute_logic_mobikwik";
				}

				//Cholamandlam
				if($client_id == 266 && $pro_id== 554){
					$rand_tbl='qa_randamiser_cholamandlam_data';
					$sel_fields = "RCD.id as rand_id, RCD.fusion_id, RCD.aht,RCD.called_no, RCD.compute_status,RCD.call_date, RCD.audit_status, date(RCD.upload_date) as upl_date, S.fusion_id, S.id as agent_id";
					$sel_distribute_fields="";
					$compCondTable = "qa_randamiser_compute_logic_cholamandlam";
				}

				//Debt Solution 123

				if($client_id == 37 && $pro_id== 49){
					$rand_tbl='qa_randamiser_debt_solution_123_data';
					$sel_fields = "RCD.id as rand_id, RCD.fusion_id, RCD.aht,RCD.phone_no, RCD.compute_status,RCD.call_date, RCD.audit_status, date(RCD.upload_date) as upl_date, S.fusion_id, S.id as agent_id";
					$sel_distribute_fields="";
					$compCondTable = "qa_randamiser_compute_logic_debt_solution_123";
				}

				//VIKAS ENDS//
				
				if(get_global_access()==1 || get_user_fusion_id()=='FDUR000199' || is_access_randamiser()){
					//$cond="";
					$cond .=" and S.status IN (1,4)";
					$randCond .="";
				}else{
					//$cond .=" and S.status IN (1,4) and assigned_qa=$current_user";
					$cond .=" and S.status IN (1,4)";
					$randCond .="and qac.assigned_qa_id=$current_user";
				}
				
				$sqlQA = "SELECT qa_id FROM $compCondTable WHERE from_date='$from_date' ORDER BY id DESC LIMIT 1";
				$qaR=$this->Common_model->get_query_row_array($sqlQA);
				
				//print_r($qaR);
				$qaTCond = "";
				$selectedQa = $qaR['qa_id'];
				if(!empty($selectedQa)){
					$qaTCond .= "and AC.assigned_qa_id in ($selectedQa)";
				}
				
				/* $rand_sql="Select DISTINCT(RCD.fusion_id),
					(select audit_target from qa_agent_categorisation a where a.agent_id=S.id) as audit_target,
					(select assigned_qa_id from qa_agent_categorisation a where a.agent_id=S.id) as assigned_qa
					FROM $rand_tbl RCD Left Join signin S On RCD.fusion_id=S.fusion_id
					where RCD.compute_status=2 and RCD.audit_status=0 and date(RCD.upload_date)='$from_date' $cond"; */
					
				
					
					$rand_sql = "SELECT AC.client_id, AC.process_id, AC.assigned_qa_id, 
					(select SUM(audit_target) from qa_agent_categorisation qac where qac.assigned_qa_id=AC.assigned_qa_id and qac.client_id=$client_id and qac.process_id=$pro_id) as total_qa_target, 
					(select SUM(audit_target/26) from qa_agent_categorisation qac where qac.assigned_qa_id=AC.assigned_qa_id and qac.client_id=$client_id and qac.process_id=$pro_id) as daily_qa_target 
					FROM qa_agent_categorisation AC where AC.is_active=1 and AC.client_id=$client_id and AC.process_id=$pro_id $qaTCond group by AC.assigned_qa_id";
				$random_data=$this->Common_model->get_query_result_array($rand_sql);
				
				$audit_target = 0;
				foreach($random_data as $sample){
					
					$audit_target += $sample['daily_qa_target'];	
				}
				
				$qa_target = ceil($audit_target);
				echo $qa_target;
				
					// select from randamiser table for same date if any distribution happened or not
					$sqlDisSameDate= "SELECT count(*) as record FROM $rand_tbl where date(upload_date)='".$from_date."' and is_distributed=1 and compute_status=2 and non_auditable=0";
					$countDisSameDate = $this->Common_model->get_query_row_array($sqlDisSameDate);
					//print_r($countDisSameDate);
					//exit;
					//end
					//print_r($_GET);
				
				if($countDisSameDate['record'] == 0 || $this->input->get('non_dis')=='non_dis'){
					$limCond ="LIMIT 400";
					/* if($this->input->get('non_dis')=='non_dis')	{
						$limCond = "LIMIT 1";
					} */
					/* $rand_sql="Select $sel_fields,
					(select audit_target from qa_agent_categorisation a where a.agent_id=S.id) as audit_target
					FROM $rand_tbl RCD Left Join signin S On RCD.fusion_id=S.fusion_id
					where RCD.compute_status=2 and RCD.audit_status=0 and date(RCD.upload_date)='$from_date' and RCD.non_auditable=0 $cond ORDER BY RAND()
					LIMIT $qa_target"; */
					
					$rand_sql="Select $sel_fields,
					(select audit_target from qa_agent_categorisation a where a.agent_id=S.id and a.client_id=$client_id and a.process_id=$pro_id) as audit_target
					FROM $rand_tbl RCD Left Join signin S On RCD.fusion_id=S.fusion_id
					where RCD.compute_status=2 and RCD.audit_status=0 and date(RCD.upload_date)='$from_date' and RCD.non_auditable=0 $cond ORDER BY RAND() $limCond";
					//exit;
					$random_data_set=$this->Common_model->get_query_result_array($rand_sql);
					//echo "<pre>";print_r($random_data_set); echo "</pre>"; exit;
					foreach($random_data_set as $sr){
						$rand_id = $sr['rand_id'];
						$fusion_id = $sr['fusion_id'];
						$upload_date=$sr["upl_date"];
						
						$sqlLimit= "SELECT count(*) as record FROM $rand_tbl where date(upload_date)='".$upload_date."' and is_distributed=1 and compute_status=2 and non_auditable=0";
						$limit = $this->Common_model->get_query_row_array($sqlLimit);
						
						if($limit['record'] < $qa_target){
							
								 $sql= "SELECT count(*) as record FROM $rand_tbl where fusion_id='".$fusion_id ."' and date(upload_date)='".$upload_date."' and is_distributed=1 and compute_status=2 and non_auditable=0";
								$count = $this->Common_model->get_query_row_array($sql);
								if($count['record']<1){
									$this->db->query("UPDATE $rand_tbl SET is_distributed=1 WHERE fusion_id='".$fusion_id ."' and date(upload_date)='".$upload_date."' and is_distributed=0 and id=$rand_id" );
								}
								//exit;
						}
					}
				}
				
				/*------  ------*/
				
	
				
				$sqlR = "SELECT SA.id as id,SA.fusion_id,SA.upload_date,
							concat(S.fname, ' ', S.lname) as agent_name,
							(select concat(s.fname,' ',s.lname) from qa_agent_categorisation a LEFT JOIN signin s ON s.id=a.assigned_qa_id where a.agent_id=S.id and a.client_id=$client_id and a.process_id=$pro_id) as qa_name $sel_distribute_fields
							FROM $rand_tbl SA 
							LEFT JOIN signin S ON (SA.fusion_id=S.fusion_id)
							LEFT JOIN qa_agent_categorisation qac ON S.id= qac.agent_id
							WHERE date(SA.upload_date)='".$from_date."' AND SA.audit_status=0 AND is_distributed=1 and compute_status=2 and non_auditable=0 $cond $randCond ORDER BY agent_name"; 
				//echo $sqlR;
				$data['sampling_data']=$this->Common_model->get_query_result_array($sqlR);
				//print_r($data['sampling_data']);
			}
			
			$data['from_date'] = $from_date;
			$data['cdr_nps'] = $cdr_nps;
			$this->load->view("dashboard",$data);
		}
	}
	
	
	
/*******************************************************************/
/*                 LOGISTIC and Compute Again                      */
/*******************************************************************/
	public function data_randamise_logiclist_freshdesk(){ /*-- For BSNL --*/
		if(check_logged_in()){
			$current_user = get_user_id(); 
			$user_office = get_user_office_id(); 
			
			if(!empty($this->uri->segment(3))){
				$data['client_id'] = $client_id = $this->uri->segment(3);
			}else{
				$data['client_id'] = $client_id = $this->input->get('client_id');
			}
			if(!empty($this->uri->segment(4))){
				$data['pro_id'] = $pro_id = $this->uri->segment(4);
			}else{
				$data['pro_id'] = $pro_id = $this->input->get('pro_id');
			}
			if($client_id==288 && $pro_id==614){
				$computeLogicTable = "qa_randamiser_compute_logic";
			}
			$data["aside_template"] = "qa_randamiser/aside.php";
			$data["content_template"] = "qa_randamiser/randamiser/data_randamise_logiclist_freshdesk_vikas.php";
			$data["content_js"] = "qa_randamiser_vikas_js.php";
			
			$cond ="";
			$from_date="";
			$to_date="";
			
			if(!empty($this->input->get('from_date'))){
				$from_date=date('Y-m-d',strtotime($this->input->get('from_date')));
			}
			if(!empty($this->input->get('to_date'))){
				$to_date=date('Y-m-d',strtotime($this->input->get('to_date')));
			}
			
			if($from_date!="" && $to_date!=""){
				$cond .= " and from_date >='$from_date' AND from_date<='$to_date'";
			}
			
			$sql = "SELECT cl.* FROM $computeLogicTable cl where cl.status=1 $cond";
			$data['logicList']=$this->Common_model->get_query_result_array($sql);
		
			$data['from_date']=$from_date;
			$data['to_date']=$to_date;
			$this->load->view("dashboard",$data);
		}
	}
	public function compute_logiclist_delete($id,$client_id,$pro_id){ /*-- For BSNL --*/
		if(check_logged_in()){
			$current_user = get_user_id(); 
			$user_office = get_user_office_id(); 
			if($client_id==288 && $pro_id==$pro_id){
				$logicTable= "qa_randamiser_compute_logic";
			}
			$this->db->query("Update $logicTable set status=0 WHERE id='$id'");
			$redURL = $client_id."/".$pro_id;
			redirect("Qa_randamiser/data_randamise_logiclist_freshdesk/".$redURL);
		}
	}
	
	
	function sx_get_compute_details(){
		if(check_logged_in()){
			$compute_logic_id = $this->input->post('bid');
			$data['compute_id'] = $compute_logic_id;
		
			
			$this->load->view('qa_randamiser/randamiser/sx_get_compute_details',$data);
		}
	}
	function compute_details_condition(){
		if(check_logged_in()){
			$compute_logic_id = $this->input->post('bid');
			$client_id = $this->input->post('cid');
			$pro_id = $this->input->post('pid');
			$data['compute_id'] = $compute_logic_id;
			
			if($client_id==288 && $pro_id=614){
				$computeTable = "qa_randamiser_compute_logic";
			}
			
			$sql = "SELECT * FROM $computeTable WHERE id=".$compute_logic_id;
			$compute_logic = $this->Common_model->get_query_row_array($sql);
			$empString = $compute_logic['agent_id'];
			$empArr = explode(',',$empString);
			$empStrImp = implode("','",$empArr);
			$sqlUser = "SELECT concat(fname,' ',lname) as name FROM signin WHERE xpoid IN ('".$empStrImp."')";
			$agent_list = $this->Common_model->get_query_result_array($sqlUser);
			$data['compute_logic']=$compute_logic;
			$data['agent_list']=$agent_list;
			$data['sqlUser'] = $sqlUser;
			if($client_id==288 && $pro_id=614){
				$detailViewUrl = 'qa_randamiser/randamiser/bsnl/compute_details_condition';
			}
			$this->load->view($detailViewUrl,$data);
		}
	}
	function compute_again_logiclist(){ /*-- For BSNL --*/
		if($this->input->post('btnCompute')=="Create"){
			$logic_id = $this->input->post('compute_id');
			$from_date = $this->input->post('select_date');
			$sql = "SELECT * FROM qa_randamiser_compute_logic WHERE id=".$logic_id;
			$compute_logic = $this->Common_model->get_query_row_array($sql);
			$current_user = get_user_id(); 
			
			$month_search=date('F Y', strtotime($from_date));
			if($month_search!=""){
				$monthwise_array=explode(" ",$month_search);
				$mw_month=$monthwise_array[0];
				$mw_year=$monthwise_array[1];
			}
			
			/* initialisation */
			
			
			$agent_cond="";
			$call_queue_cond="";
			$aht_cond="";
			$agent="";
			$call_queue="";
			$aht="";
			
			
			/* end of initialisation */
			
			if($compute_logic['agent_id']!=""){
					$agent = explode(",",$compute_logic['agent_id']);
					$agent_id=implode("','", $agent);
					$agent_cond .=" and xpoid in ('$agent_id')";
			}
			if($compute_logic['call_queue']!=""){
					$call_queue = explode(",",$compute_logic['call_queue']);
					$call_queue_str=implode("','", $queue_name);
					$call_queue_cond .=" and call_queue in ('$call_queue_str')";
			}
			if($compute_logic['aht']!=""){
					$aht=explode(",",$compute_logic['aht']);
					$aht_str=implode(" OR ", $aht);
					$aht_cond .=" and ($aht_str)";
				}
			
			
			$rand_sql="Select RCD.fusion_id, RCD.call_queue, RCD.aht,
				TIME_TO_SEC(aht) as aht_sec,
				RCD.compute_status, RCD.audit_status
			from qa_randamiser_bsnl_data RCD Left Join signin S On RCD.fusion_id=S.fusion_id where compute_status=1 and audit_status=0 and date(upload_date)='$from_date' $agent_cond
			$call_queue_cond having 1
			$aht_cond";
			
			//echo $rand_sql;exit;
			$sampling_data = $this->Common_model->get_query_result_array($rand_sql);
				
			foreach($sampling_data as $row){
				$fusion_id=$row["fusion_id"];
				$this->db->query("Update qa_randamiser_bsnl_data set compute_status=2, compute_by='$current_user' where fusion_id='$fusion_id' and date(upload_date)='$from_date'");
			}
			redirect("qa_randamiser/data_distribute_freshdesk");
		}
	
	}
	

	/**********************************************************************************/
	
	
	
	public function remove_data_cdr_upload_freshdesk(){ /*-- For BSNL --*/
		if(check_logged_in()){
			$up_date = $this->input->get('up_date');
			$client_id = $this->input->get('client_id');
			$pro_id = $this->input->get('pro_id');
			//BSNL
			if($client_id==288 && $pro_id==614){
				$tableName = "qa_randamiser_bsnl_data";
				$redURL = 'qa_randamiser/data_upload_freshdesk/'.$client_id.'/'.$pro_id;
			}
			// Nurture Farm
			if($client_id==314 && $pro_id==663){
				$tableName = "qa_randamiser_nurture_farm_data";
				$redURL = 'qa_randamiser/data_upload_freshdesk/'.$client_id.'/'.$pro_id;
			}
			// Cars24
			if($client_id == 246 && $pro_id== 529){
				$tableName = "qa_randamiser_cars24_data";
				$redURL = 'qa_randamiser/data_upload_freshdesk/'.$client_id.'/'.$pro_id;
			}
			// Touchfuse
			if($client_id == 134 && $pro_id== 753){
				$tableName = "qa_randamiser_touchfuse_data";
				$redURL = 'qa_randamiser/data_upload_freshdesk/'.$client_id.'/'.$pro_id;
			}
			// Blains
			if($client_id == 134 && $pro_id== 271){
				$tableName = "qa_randamiser_blains_data";
				$redURL = 'qa_randamiser/data_upload_freshdesk/'.$client_id.'/'.$pro_id;
			}

			//VIKAS START//
			// Mobikwik
			if($client_id == 345 && $pro_id== 719){
				$tableName = "qa_randamiser_mobikwik_data";
				$redURL = 'qa_randamiser_vikas/data_upload_freshdesk/'.$client_id.'/'.$pro_id;
			}

			//Cholamandlam
			if($client_id == 266 && $pro_id== 554){
				$tableName = "qa_randamiser_cholamandlam_data";
				$redURL = 'qa_randamiser_vikas/data_upload_freshdesk/'.$client_id.'/'.$pro_id;
			}

			//Debt Solution 123

			if($client_id == 37 && $pro_id== 49){
				$tableName = "qa_randamiser_debt_solution_123_data";
				$redURL = 'qa_randamiser_vikas/data_upload_freshdesk/'.$client_id.'/'.$pro_id;
			}

			//VIKAS ENDS//
			$sql  = "DELETE FROM $tableName WHERE DATE(upload_date)='".$up_date."'";
			//echo $sql;exit;
			$this->db->query($sql);
			
			redirect($redURL);
		}
	}
	
	
	
	
	public function download_distributed_data(){

		if($this->input->get('submit')=='Submit' || $this->input->get('assign')=='Assign To')
		{
			$from_date = $this->input->get('from_date');
			$client_id = $this->input->get('client_id');
			$pro_id = $this->input->get('pro_id');
			
			$params = array(
								"from_date"	 => $from_date,
								"client_id"=>$client_id,
								"pro_id"=>$pro_id
							);
			
			$header = array('SL No','Agent Name','Fusion ID','Location','Date of Creation','Recording Track ID','Assigned QA','Distributed Data Opened By','Distributed Data Opened Date Time');
			

			$data = array(
							array('Distribution Report'),
							$header
						);
			/*Common function for view and excel export*/
			$all_data = $this->get_data($params);
			
			//print_r($all_data);exit;
			$i=1;
			foreach($all_data as $row => $value){
				$datetime = "";
				if(!empty($value['distribution_opened_datetime'])) $datetime = ConvServerToLocal($value['distribution_opened_datetime']);
				$sub = array();
				$sub = array(
								$i++,
								$value['agent_name'],
								$value['fusion_id'],
								$value['office_id'],
								$value['upload_date'],
								$value['recording_track_id'],
								$value['assigned_qa'],
								$value['distributed_by'],
								$datetime
							);
				$data[] = $sub;
			}
			
			
			
			$objPHPExcel = new PHPExcel();
	    	$objWorksheet = $objPHPExcel->getActiveSheet();
			$objWorksheet->fromArray($data,NULL,'B2');

			/*cell merge for heading*/
			$adjustment = (count($header)-1);
	        $currentColumn = 'B';
	        $columnIndex = PHPExcel_Cell::columnIndexFromString($currentColumn);
	        $adjustedColumnIndex = $columnIndex + $adjustment;
	        $adjustedColumn = PHPExcel_Cell::stringFromColumnIndex($adjustedColumnIndex - 1);
	        $objPHPExcel->getActiveSheet()->mergeCells('B2:'.$adjustedColumn.'2');
	        $titleStyleArray = array(
				'fill' => array(
					'type' => PHPExcel_Style_Fill::FILL_SOLID,
					'color' => array('rgb' => '35b8e0')
				)
			);
	        $objWorksheet->getStyle('B2:'.$adjustedColumn.'3')->applyFromArray($titleStyleArray);
	        /*cell merge for heading*/

	        

	        

	        $style = array(
	            'borders' => array(
	                'allborders' => array(
	                  'style' => PHPExcel_Style_Border::BORDER_THIN
	                )
	            ),
	            'alignment' => array(
	                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
	            )
	        );

	      

	        /*+1 first row*/
	        $endingRow = (count($data)+1);
	        $objWorksheet->getStyle('B2:'.$adjustedColumn.$endingRow)->applyFromArray($style);

	       
			ob_clean();
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	        header('Content-Disposition: attachment;filename="distribution-report.xlsx"');
	        header('Cache-Control: max-age=0');
	        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel , 'Excel2007');
	        $objWriter->setIncludeCharts(TRUE);
	        $objWriter->save('php://output');
		}
	}
	
	private function get_data($params){
		$current_user = get_user_id();
		extract($params);
		$data = array();
		$randCond="";
		if(get_global_access()==1 || is_access_randamiser()){
			$randCond .="";
		}else{
			$randCond .=" AND qac.assigned_qa_id=$current_user";
		}
		//BSNL
		if($client_id==288 && $pro_id==614){
			$tableName = "qa_randamiser_bsnl_data";
			$selField = ", SA.recording_track_id";
		}
		//Nurture farm
		if($client_id==314 && $pro_id==663 ){
			$tableName = "qa_randamiser_nurture_farm_data";
			$selField = ", SA.call_id as recording_track_id";
		}
		// Cras 24 Pre-booking
		if($client_id == 246 && $pro_id== 529){
			$tableName = "qa_randamiser_cars24_data";
			$selField = ", SA.call_id as recording_track_id";
		}
		// Touchfuse
		if($client_id == 134 && $pro_id== 753){
			$tableName = "qa_randamiser_touchfuse_data";
			$selField = "";
		}
		// Blains
		if($client_id == 134 && $pro_id== 271){
			$tableName = "qa_randamiser_blains_data";
			$selField = "";
		}
		//VIKAS START//
		//Mobikwik
		if($client_id==345 && $pro_id==719 ){
			$tableName = "qa_randamiser_mobikwik_data";
			$selField = ", SA.call_id as recording_track_id";
		}

		//Cholamandlam
		if($client_id==266 && $pro_id==554 ){
			$tableName = "qa_randamiser_cholamandlam_data";
			$selField = "";
		}

		//Debt Solution 123

		if($client_id==37 && $pro_id==49 ){
			$tableName = "qa_randamiser_debt_solution_123_data";
			$selField = "";
		}

		//VIKAS ENDS//
		$sqlR = "SELECT SA.id as id,SA.fusion_id,SA.upload_date,
							concat(S.fname, ' ', S.lname) as agent_name, S.office_id, 
							SA.distribution_opened_datetime,
							(SELECT concat(fname,' ',lname) FROM signin s WHERE s.id=qac.assigned_qa_id) as assigned_qa,
							(SELECT concat(fname,' ',lname) FROM signin s WHERE s.id=SA.distribution_opend_by) as distributed_by $selField
							FROM $tableName SA 
							LEFT JOIN signin S ON (SA.fusion_id=S.fusion_id)
							LEFT JOIN qa_agent_categorisation qac ON S.id= qac.agent_id
							WHERE date(SA.upload_date)='".$from_date."' AND SA.audit_status=0 and SA.non_auditable=0 and is_distributed=1 $randCond";		
				
		$data=$this->Common_model->get_query_result_array($sqlR);
		return $data;
	}
	
	function update_non_auditable(){
		if(check_logged_in()){
			$data['randID'] = $randID = $this->input->get('randID');//03552
			$data['client_id']=$client_id = $this->input->get('cid');
			$data['pro_id'] = $pro_id = $this->input->get('pid');
			$data['disDate'] = $disDate = $this->input->get('disDate');
			
			
		
			$this->load->view('qa_randamiser/randamiser/update_non_auditable_vikas',$data);
		}
	}
	function update_distribution(){
		if(check_logged_in()){
			$randID = $this->input->post('randID');
			$client_id = $this->input->post('client_id');
			$pro_id = $this->input->post('process_id');
			$disDate = $this->input->post('distribute_date');
			$non_auditable_comment = $this->input->post('non_auditable_comment');
			$current_user = get_user_id();
			$currentDateTime = date("Y-m-d H:i:s");
			//BSNL
			if($client_id==288 && $pro_id==614){
				$tableName = "qa_randamiser_bsnl_data";
			}
			// Nurture Farms
			if($client_id==314 && $pro_id==663 ){
				$tableName = "qa_randamiser_nurture_farm_data";
			}
			// Cras 24 Pre-booking
			if($client_id == 246 && $pro_id== 529){
				$tableName = "qa_randamiser_cars24_data";
			}
			// Touchfuse
			if($client_id == 134 && $pro_id== 753){
				$tableName = "qa_randamiser_touchfuse_data";
			}
			// Blains
			if($client_id == 134 && $pro_id== 271){
				$tableName = "qa_randamiser_blains_data";
			}

			//VIKAS START//
			//Mobikwik

			if($client_id == 345 && $pro_id== 719){
				$tableName = "qa_randamiser_mobikwik_data";
			}

			//Cholamandlam

			if($client_id == 266 && $pro_id== 554){
				$tableName = "qa_randamiser_cholamandlam_data";
			}

			//Debt Solution 123

			if($client_id == 37 && $pro_id== 49){
				$tableName = "qa_randamiser_debt_solution_123_data";
			}

			//VIKAS ENDS//
			$randArr = array('non_auditable'=>1,'non_auditable_comment'=>$non_auditable_comment, 'non_auditable_by'=>$current_user,'non_auditable_date'=>$currentDateTime);
			$this->db->where('id', $randID);
		    $this->db->update($tableName,$randArr);
		
			$redURL = '?from_date='.$disDate.'&client_id='.$client_id.'&pro_id='.$pro_id.'&submit=Submit&non_dis=non_dis';
			redirect('Qa_randamiser_vikas/data_distribute_freshdesk'.$redURL);
		}
	}

	/********************************vikas start*****************************************/
	// public function download_data_cdr_upload_freshdesk(){
	// 	if(check_logged_in()){
	// 		$up_date = $this->input->get('up_date');
	// 		$client_id = $this->input->get('client_id');
	// 		$pro_id = $this->input->get('pro_id');

	// 		$from_date="";
	// 		$cond="";
	// 		$randCond="";
	// 		$rand_tbl="";
			
			
			
	// 		$loc_sql="Select * from office_location where is_active=1";
	// 		$data["location"]=$this->Common_model->get_query_result_array($loc_sql);
			
	// 		$qa_sql="Select id, fusion_id, office_id, concat(fname, ' ', lname) as name from signin where status=1 and dept_id=5 order by name";
	// 		$data["qa"]=$this->Common_model->get_query_result_array($qa_sql);

			
	// 		$data["sampling_data"] = array();
	// 		$sel_fields="";
	// 		$sel_distribute_fields="";
	// 		if($client_id==202 && $pro_id==411)
	// 		{
	// 			$tableName = "qa_randamiser_indiamart_data";

	// 		}
	// 		//BSNL
	// 		if($client_id==288 && $pro_id==614){
	// 			$tableName = "qa_randamiser_bsnl_data";
	// 			$redURL = 'qa_randamiser/data_upload_freshdesk/'.$client_id.'/'.$pro_id;

	// 		}
	// 		// Nurture Farm
	// 		if($client_id==314 && $pro_id==663){
	// 			$tableName = "qa_randamiser_nurture_farm_data";
	// 			$redURL = 'qa_randamiser/data_upload_freshdesk/'.$client_id.'/'.$pro_id;

	// 		}
	// 		// Cars24
	// 		if($client_id == 246 && $pro_id== 529){
	// 			$tableName = "qa_randamiser_cars24_data";
	// 			$redURL = 'qa_randamiser/data_upload_freshdesk/'.$client_id.'/'.$pro_id;
	// 		}
	// 		// Touchfuse
	// 		if($client_id == 134 && $pro_id== 753){
	// 			$tableName = "qa_randamiser_touchfuse_data";
	// 			$redURL = 'qa_randamiser/data_upload_freshdesk/'.$client_id.'/'.$pro_id;
				
	// 		}
	// 		// Blains
	// 		if($client_id == 134 && $pro_id== 271){
	// 			$tableName = "qa_randamiser_blains_data";
	// 			$redURL = 'qa_randamiser/data_upload_freshdesk/'.$client_id.'/'.$pro_id;
				
	// 		}

	// 		//VIKAS START//
	// 		// Mobikwik
	// 		if($client_id == 345 && $pro_id== 719){
	// 			$tableName = "qa_randamiser_mobikwik_data";
	// 			$redURL = 'qa_randamiser_vikas/data_upload_freshdesk/'.$client_id.'/'.$pro_id;

	// 		}

	// 		//Cholamandlam
	// 		if($client_id == 266 && $pro_id== 554){
	// 			$tableName = "qa_randamiser_cholamandlam_data";
	// 			$redURL = 'qa_randamiser_vikas/data_upload_freshdesk/'.$client_id.'/'.$pro_id;
	// 		}

	// 		//Debt Solution 123

	// 		if($client_id == 37 && $pro_id== 49){
	// 			$tableName = "qa_randamiser_debt_solution_123_data";
	// 			$redURL = 'qa_randamiser_vikas/data_upload_freshdesk/'.$client_id.'/'.$pro_id;
	// 		}

	// 		$sqlR="SELECT xx.*,(select concat(fname, ' ', lname) as name from signin s where s.fusion_id=xx.fusion_id) as agent_name
	// 			from $tableName xx WHERE date(xx.upload_date)='".$up_date."'
	// 			 "; 				
	// 			//echo $sqlR;

	// 			$fullAray = $this->Common_model->get_query_result_array($sqlR);

	// 			// echo"<pre>";
	// 			// print_r($fullAray);
	// 			// echo"</pre>";
	// 			// exit();

	// 			$data["sampling_data"] = $fullAray;
	// 			$this->create_qa_randamiser_CSV($fullAray,$client_id,$pro_id);
	// 			$dn_link = base_url()."Qa_randamiser_vikas/download_qa_randamiser_CSV/".$client_id.$pro_id;

	// 		//VIKAS ENDS//
	// 	}
	// }


	/********************************vikas ends*****************************************/
 }
 
 ?>