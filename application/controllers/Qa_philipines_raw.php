<?php
class Qa_philipines_raw extends CI_Controller{

	public function __construct(){
		parent::__construct();
		$this->load->model('user_model');
		$this->load->model('Common_model');
		$this->load->model('Qa_philip_model');
	}

	function import_stratus_excel_data(){
		
		$current_user = '';
		$audit_time = time();
		//$audit_start_time = date("Y-m-d h:i:s", $audit_time);
		//print_r($this->input->post());
		 $audit_start_time = $this->input->post('star_time');
		$this->load->library('excel');
		if(isset($_FILES["file"]["name"])){
		if(check_logged_in())
		{
			$current_user = get_user_id(); 
		}
			
			$path = $_FILES["file"]["tmp_name"];
			$object = PHPExcel_IOFactory::load($path);
			$clmarr = array("audit_date","fusion_id","auditor_mwp_id","call_date","customer_name","order_number","audit_type","auditor_type","voc","overall_score","possible_score","earned_score","auto_fail","patient_information","patient_name","patient_dob","patient_physical_address","patient_phone_number","agent_added_email","agent_select_branch_facility","clinical","patient_gender","ordering_provider","marketing_rep","diagnosis_code","insurance","info_order","insurance_eligibility","eligibility_date","policy_holder_info","sales_order","delete_scheduled","branch_office","order_reference","wip_state","eeg_length","order_entry","work_fax","eeg_today","missing_info","attachment","hippa","duplicate_order","fax_file","major_errors","account_properly","ordered_items","market_represent","doctor_office","cmt1","cmt2","cmt3","cmt4","cmt5","cmt6","cmt7","cmt8","cmt9","cmt10","cmt11","cmt12","cmt13","cmt14","cmt15","cmt16","cmt17","cmt18","cmt19","cmt20","cmt21","cmt22","cmt23","cmt24","cmt25","cmt26","cmt27","cmt28","cmt29","cmt30","cmt31","cmt32","cmt33","cmt34","cmt35","cmt36","call_summary","feedback");
			
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
				
					foreach($clmarr as $name){
						if($name == $colindex){
							 $dd[$colindex]  = $adjustedColumn;
						}
					}
				}
				
				//$random_row = round(($highestRow * (20/100)));				
				for($row=2; $row<=$highestRow; $row++){
					foreach($dd as $key=>$d){
						$audit_time1 = time();
		                $audit_time_each = date("Y-m-d h:i:s", $audit_time1);
						
						if($key=="audit_date"){
							$user_list[$row][$key] = date('Y-m-d',strtotime($worksheet->getCell($d.$row )->getFormattedValue()));
						}else if($key=="call_date"){
							$user_list[$row][$key] = date('Y-m-d',strtotime($worksheet->getCell($d.$row )->getFormattedValue()));
						}else if($key=="call_duration"){
							$user_list[$row][$key] = intval(86400 * $worksheet->getCell($d.$row )->getValue());
						}else if($key=="auditor_mwp_id"){
							$user_list[$row]['entry_by'] =  $worksheet->getCell($d.$row )->getValue();
						}
						else if($key=="fusion_id"){
							$fusion_id = $worksheet->getCell($d.$row )->getValue();
							 $qSql = "Select id as agent_id, assigned_to as tl_id, fusion_id, get_process_names(id) as process_name, office_id, (select concat(fname, ' ', lname) from signin tl where tl.id=signin.assigned_to) as tl_name FROM signin where fusion_id = '$fusion_id'";
							
							$tl_agent_ids = $this->Common_model->get_query_row_array($qSql);

							// $sql_qa_name = "select concat(fname, ' ', lname) as auditor_name from signin qa where qa.id='$current_user'";
							// $qa_name = $this->Common_model->get_query_row_array($sql_qa_name);

							$user_list[$row]['agent_id'] 			=  $tl_agent_ids['agent_id'];
							$user_list[$row]['tl_id']    			=  $tl_agent_ids['tl_id'];
							//$user_list[$row]['entry_by']   			=  $current_user;
							//$user_list[$row]['auditor_name']   		=  $qa_name['auditor_name'];
							$user_list[$row]['entry_date']   		=  $audit_time_each;
							$user_list[$row]['audit_start_time']   	=  $audit_start_time;
							

						}
						else{
							$user_list[$row][$key] =  $worksheet->getCell($d.$row )->getValue();
						}
					}	
				}

				// echo"<pre>";
				// print_r($user_list);
				// echo"</pre>";
				 //die();
			
				$this->Qa_philip_model->stratus_data($user_list);
				redirect('Qa_stratus');
			}
		}
	}

	function import_stratus_csr_excel_data(){
		
		$current_user = '';
		$audit_time = time();
		//$audit_start_time = date("Y-m-d h:i:s", $audit_time);
		//print_r($this->input->post());
		 $audit_start_time = $this->input->post('star_time');
		$this->load->library('excel');
		if(isset($_FILES["file"]["name"])){
		if(check_logged_in())
		{
			$current_user = get_user_id(); 
		}
			
			$path = $_FILES["file"]["tmp_name"];
			$object = PHPExcel_IOFactory::load($path);
			$clmarr = array("audit_date","fusion_id","auditor_mwp_id","call_date","customer_name","order_number","audit_type","auditor_type","voc","overall_score","possible_score","earned_score","auto_fail","patient_information","patient_name","patient_dob","patient_physical_address","patient_phone_number","agent_added_email","agent_select_branch_facility","clinical","patient_gender","ordering_provider","marketing_rep","diagnosis_code","insurance","info_order","insurance_eligibility","eligibility_date","policy_holder_info","sales_order","delete_scheduled","branch_office","order_reference","wip_state","eeg_length","order_entry","work_fax","eeg_today","missing_info","attachment","hippa","duplicate_order","fax_file","major_errors","account_properly","ordered_items","market_represent","doctor_office","cmt1","cmt2","cmt3","cmt4","cmt5","cmt6","cmt7","cmt8","cmt9","cmt10","cmt11","cmt12","cmt13","cmt14","cmt15","cmt16","cmt17","cmt18","cmt19","cmt20","cmt21","cmt22","cmt23","cmt24","cmt25","cmt26","cmt27","cmt28","cmt29","cmt30","cmt31","cmt32","cmt33","cmt34","cmt35","cmt36","call_summary","feedback");
			
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
				
					foreach($clmarr as $name){
						if($name == $colindex){
							 $dd[$colindex]  = $adjustedColumn;
						}
					}
				}
				
				//$random_row = round(($highestRow * (20/100)));				
				for($row=2; $row<=$highestRow; $row++){
					foreach($dd as $key=>$d){
						$audit_time1 = time();
		                $audit_time_each = date("Y-m-d h:i:s", $audit_time1);
						
						if($key=="audit_date"){
							$user_list[$row][$key] = date('Y-m-d',strtotime($worksheet->getCell($d.$row )->getFormattedValue()));
						}else if($key=="call_date"){
							$user_list[$row][$key] = date('Y-m-d',strtotime($worksheet->getCell($d.$row )->getFormattedValue()));
						}else if($key=="call_duration"){
							$user_list[$row][$key] = intval(86400 * $worksheet->getCell($d.$row )->getValue());
						}else if($key=="auditor_mwp_id"){
							$user_list[$row]['entry_by'] =  $worksheet->getCell($d.$row )->getValue();
						}
						else if($key=="fusion_id"){
							$fusion_id = $worksheet->getCell($d.$row )->getValue();
							 $qSql = "Select id as agent_id, assigned_to as tl_id, fusion_id, get_process_names(id) as process_name, office_id, (select concat(fname, ' ', lname) from signin tl where tl.id=signin.assigned_to) as tl_name FROM signin where fusion_id = '$fusion_id'";
							
							$tl_agent_ids = $this->Common_model->get_query_row_array($qSql);

							// $sql_qa_name = "select concat(fname, ' ', lname) as auditor_name from signin qa where qa.id='$current_user'";
							// $qa_name = $this->Common_model->get_query_row_array($sql_qa_name);

							$user_list[$row]['agent_id'] 			=  $tl_agent_ids['agent_id'];
							$user_list[$row]['tl_id']    			=  $tl_agent_ids['tl_id'];
							//$user_list[$row]['entry_by']   			=  $current_user;
							//$user_list[$row]['auditor_name']   		=  $qa_name['auditor_name'];
							$user_list[$row]['entry_date']   		=  $audit_time_each;
							$user_list[$row]['audit_start_time']   	=  $audit_start_time;
							

						}
						else{
							$user_list[$row][$key] =  $worksheet->getCell($d.$row )->getValue();
						}
					}	
				}

				// echo"<pre>";
				// print_r($user_list);
				// echo"</pre>";
				 //die();
			
				$this->Qa_philip_model->stratus_csr_data($user_list);
				redirect('Qa_stratus');
			}
		}
	}
	function import_stratus_outbound_excel_data(){
		
		$current_user = '';
		$audit_time = time();
		//$audit_start_time = date("Y-m-d h:i:s", $audit_time);
		//print_r($this->input->post());
		 $audit_start_time = $this->input->post('star_time');
		$this->load->library('excel');
		if(isset($_FILES["file"]["name"])){
		if(check_logged_in())
		{
			$current_user = get_user_id(); 
		}
			
			$path = $_FILES["file"]["tmp_name"];
			$object = PHPExcel_IOFactory::load($path);
			$clmarr = array("audit_date","fusion_id","auditor_mwp_id","call_date","customer_name","order_number","audit_type","auditor_type","voc","overall_score","possible_score","earned_score","compliance_score_percent","customer_score_percent","business_score_percent","compliancescore","customerscore","businessscore","compliancescoreable","customerscoreable","businessscoreable","auto_fail","outbound_spiel","correct_time","acknowledge","active_listening","tone_speed","missing_items","proper_notation","color_coding","cmt1","cmt2","cmt3","cmt4","cmt5","cmt6","cmt7","cmt8","call_summary","feedback");
			
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
				
					foreach($clmarr as $name){
						if($name == $colindex){
							 $dd[$colindex]  = $adjustedColumn;
						}
					}
				}
				
				//$random_row = round(($highestRow * (20/100)));				
				for($row=2; $row<=$highestRow; $row++){
					foreach($dd as $key=>$d){
						$audit_time1 = time();
		                $audit_time_each = date("Y-m-d h:i:s", $audit_time1);
						
						if($key=="audit_date"){
							$user_list[$row][$key] = date('Y-m-d',strtotime($worksheet->getCell($d.$row )->getFormattedValue()));
						}else if($key=="call_date"){
							$user_list[$row][$key] = date('Y-m-d',strtotime($worksheet->getCell($d.$row )->getFormattedValue()));
						}else if($key=="call_duration"){
							$user_list[$row][$key] = intval(86400 * $worksheet->getCell($d.$row )->getValue());
						}else if($key=="auditor_mwp_id"){
							$user_list[$row]['entry_by'] =  $worksheet->getCell($d.$row )->getValue();
						}
						else if($key=="fusion_id"){
							$fusion_id = $worksheet->getCell($d.$row )->getValue();
							 $qSql = "Select id as agent_id, assigned_to as tl_id, fusion_id, get_process_names(id) as process_name, office_id, (select concat(fname, ' ', lname) from signin tl where tl.id=signin.assigned_to) as tl_name FROM signin where fusion_id = '$fusion_id'";
							
							$tl_agent_ids = $this->Common_model->get_query_row_array($qSql);

							// $sql_qa_name = "select concat(fname, ' ', lname) as auditor_name from signin qa where qa.id='$current_user'";
							// $qa_name = $this->Common_model->get_query_row_array($sql_qa_name);

							$user_list[$row]['agent_id'] 			=  $tl_agent_ids['agent_id'];
							$user_list[$row]['tl_id']    			=  $tl_agent_ids['tl_id'];
							//$user_list[$row]['entry_by']   			=  $current_user;
							//$user_list[$row]['auditor_name']   		=  $qa_name['auditor_name'];
							$user_list[$row]['entry_date']   		=  $audit_time_each;
							$user_list[$row]['audit_start_time']   	=  $audit_start_time;
							

						}
						else{
							$user_list[$row][$key] =  $worksheet->getCell($d.$row )->getValue();
						}
					}	
				}

				// echo"<pre>";
				// print_r($user_list);
				// echo"</pre>";
				 //die();
			
				$this->Qa_philip_model->stratus_outbound_data($user_list);
				redirect('Qa_stratus');
			}
		}
	}

	function import_stratus_call_tech_excel_data(){
		
		$current_user = '';
		$audit_time = time();
		//$audit_start_time = date("Y-m-d h:i:s", $audit_time);
		//print_r($this->input->post());
		 $audit_start_time = $this->input->post('star_time');
		$this->load->library('excel');
		if(isset($_FILES["file"]["name"])){
		if(check_logged_in())
		{
			$current_user = get_user_id(); 
		}
			
			$path = $_FILES["file"]["tmp_name"];
			$object = PHPExcel_IOFactory::load($path);
			$clmarr = array("audit_date","fusion_id","auditor_mwp_id","call_date","customer_name","order_number","audit_type","auditor_type","voc","overall_score","possible_score","earned_score","compliance_score_percent","customer_score_percent","business_score_percent","compliancescore","customerscore","businessscore","compliancescoreable","customerscoreable","businessscoreable","agent_deliver","identifiers","courtesy_call","active_listening","tone_speed","silences","call_transfer","patient","documentation","cmt1","cmt2","cmt3","cmt4","cmt5","cmt6","cmt7","cmt8","cmt9","call_summary","feedback");
			
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
				
					foreach($clmarr as $name){
						if($name == $colindex){
							 $dd[$colindex]  = $adjustedColumn;
						}
					}
				}
				
				//$random_row = round(($highestRow * (20/100)));				
				for($row=2; $row<=$highestRow; $row++){
					foreach($dd as $key=>$d){
						$audit_time1 = time();
		                $audit_time_each = date("Y-m-d h:i:s", $audit_time1);
						
						if($key=="audit_date"){
							$user_list[$row][$key] = date('Y-m-d',strtotime($worksheet->getCell($d.$row )->getFormattedValue()));
						}else if($key=="call_date"){
							$user_list[$row][$key] = date('Y-m-d',strtotime($worksheet->getCell($d.$row )->getFormattedValue()));
						}else if($key=="call_duration"){
							$user_list[$row][$key] = intval(86400 * $worksheet->getCell($d.$row )->getValue());
						}else if($key=="auditor_mwp_id"){
							$user_list[$row]['entry_by'] =  $worksheet->getCell($d.$row )->getValue();
						}
						else if($key=="fusion_id"){
							$fusion_id = $worksheet->getCell($d.$row )->getValue();
							 $qSql = "Select id as agent_id, assigned_to as tl_id, fusion_id, get_process_names(id) as process_name, office_id, (select concat(fname, ' ', lname) from signin tl where tl.id=signin.assigned_to) as tl_name FROM signin where fusion_id = '$fusion_id'";
							
							$tl_agent_ids = $this->Common_model->get_query_row_array($qSql);

							// $sql_qa_name = "select concat(fname, ' ', lname) as auditor_name from signin qa where qa.id='$current_user'";
							// $qa_name = $this->Common_model->get_query_row_array($sql_qa_name);

							$user_list[$row]['agent_id'] 			=  $tl_agent_ids['agent_id'];
							$user_list[$row]['tl_id']    			=  $tl_agent_ids['tl_id'];
							//$user_list[$row]['entry_by']   			=  $current_user;
							//$user_list[$row]['auditor_name']   		=  $qa_name['auditor_name'];
							$user_list[$row]['entry_date']   		=  $audit_time_each;
							$user_list[$row]['audit_start_time']   	=  $audit_start_time;
							

						}
						else{
							$user_list[$row][$key] =  $worksheet->getCell($d.$row )->getValue();
						}
					}	
				}

				// echo"<pre>";
				// print_r($user_list);
				// echo"</pre>";
				 //die();
			
				$this->Qa_philip_model->stratus_call_tech_data($user_list);
				redirect('Qa_stratus');
			}
		}
	}

	function import_stratus_monitoring_tech_excel_data(){
		
		$current_user = '';
		$audit_time = time();
		//$audit_start_time = date("Y-m-d h:i:s", $audit_time);
		//print_r($this->input->post());
		 $audit_start_time = $this->input->post('star_time');
		$this->load->library('excel');
		if(isset($_FILES["file"]["name"])){
		if(check_logged_in())
		{
			$current_user = get_user_id(); 
		}
			
			$path = $_FILES["file"]["tmp_name"];
			$object = PHPExcel_IOFactory::load($path);
			$clmarr = array("audit_date","fusion_id","auditor_mwp_id","call_date","customer_name","order_number","auto_fail","audit_type","auditor_type","voc","overall_score","possible_score","earned_score","compliance_score_percent","customer_score_percent","business_score_percent","compliancescore","customerscore","businessscore","compliancescoreable","customerscoreable","businessscoreable","routine_checks","documentation","accurate_reminders","patient_report","amplifier","cameras","highlighting","contacting","initials","patient_call","patient_rept","patient_id","patient_phone","start_time","patient_cameras","patient_location","bright_tree","incorrect_time","data_card","configured","cmt1","cmt2","cmt3","cmt4","cmt5","cmt6","cmt7","cmt8","cmt9","cmt10","cmt11","cmt12","cmt13","cmt14","cmt15","cmt16","cmt17","cmt18","call_summary","feedback");
			
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
				
					foreach($clmarr as $name){
						if($name == $colindex){
							 $dd[$colindex]  = $adjustedColumn;
						}
					}
				}
				
				//$random_row = round(($highestRow * (20/100)));				
				for($row=2; $row<=$highestRow; $row++){
					foreach($dd as $key=>$d){
						$audit_time1 = time();
		                $audit_time_each = date("Y-m-d h:i:s", $audit_time1);
						
						if($key=="audit_date"){
							$user_list[$row][$key] = date('Y-m-d',strtotime($worksheet->getCell($d.$row )->getFormattedValue()));
						}else if($key=="call_date"){
							$user_list[$row][$key] = date('Y-m-d',strtotime($worksheet->getCell($d.$row )->getFormattedValue()));
						}else if($key=="call_duration"){
							$user_list[$row][$key] = intval(86400 * $worksheet->getCell($d.$row )->getValue());
						}else if($key=="auditor_mwp_id"){
							$user_list[$row]['entry_by'] =  $worksheet->getCell($d.$row )->getValue();
						}
						else if($key=="fusion_id"){
							$fusion_id = $worksheet->getCell($d.$row )->getValue();
							 $qSql = "Select id as agent_id, assigned_to as tl_id, fusion_id, get_process_names(id) as process_name, office_id, (select concat(fname, ' ', lname) from signin tl where tl.id=signin.assigned_to) as tl_name FROM signin where fusion_id = '$fusion_id'";
							
							$tl_agent_ids = $this->Common_model->get_query_row_array($qSql);

							// $sql_qa_name = "select concat(fname, ' ', lname) as auditor_name from signin qa where qa.id='$current_user'";
							// $qa_name = $this->Common_model->get_query_row_array($sql_qa_name);

							$user_list[$row]['agent_id'] 			=  $tl_agent_ids['agent_id'];
							$user_list[$row]['tl_id']    			=  $tl_agent_ids['tl_id'];
							//$user_list[$row]['entry_by']   			=  $current_user;
							//$user_list[$row]['auditor_name']   		=  $qa_name['auditor_name'];
							$user_list[$row]['entry_date']   		=  $audit_time_each;
							$user_list[$row]['audit_start_time']   	=  $audit_start_time;
							

						}
						else{
							$user_list[$row][$key] =  $worksheet->getCell($d.$row )->getValue();
						}
					}	
				}

				// echo"<pre>";
				// print_r($user_list);
				// echo"</pre>";
				 //die();
			
				$this->Qa_philip_model->stratus_monitoring_tech_data($user_list);
				redirect('Qa_stratus');
			}
		}
	}

	function import_biomet_call_excel_data(){
		
		$current_user = '';
		$audit_time = time();
		//$audit_start_time = date("Y-m-d h:i:s", $audit_time);
		//print_r($this->input->post());
		 $audit_start_time = $this->input->post('star_time');
		$this->load->library('excel');
		if(isset($_FILES["file"]["name"])){
		if(check_logged_in())
		{
			$current_user = get_user_id(); 
		}
			
			$path = $_FILES["file"]["tmp_name"];
			$object = PHPExcel_IOFactory::load($path);
			$clmarr = array("audit_date","fusion_id","auditor_mwp_id","call_date","call_duration","mission","recording_id","week","audit_type","auditor_type","voc","overall_score","earned_score","possible_score","appropiate_greeting","clear_opening","voice_modulation","appropiate_pace","professional_courteous","call_empathy","adjust_customer_language","simple_word_used","active_listening","paraprasing","avoid_fumbling","appropiate_probing","escalate_issue","call_control","query_resolved","offers_VAS","awareness_created","correct_disposition","update_ASM","capture_query","hold_required","hold_guidelines","dead_air_8sec","further_assistance","CSAT_experience_feedback","call_adherence","used_applicant","delayed_opening","rude_on_call","incomplete_information","complaint_avoidance","reason_for_fatal","improvement_area","call_summary","feedback");
			
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
				
					foreach($clmarr as $name){
						if($name == $colindex){
							 $dd[$colindex]  = $adjustedColumn;
						}
					}
				}
				
				//$random_row = round(($highestRow * (20/100)));				
				for($row=2; $row<=$highestRow; $row++){
					foreach($dd as $key=>$d){
						$audit_time1 = time();
		                $audit_time_each = date("Y-m-d h:i:s", $audit_time1);
						
						if($key=="audit_date"){
							$user_list[$row][$key] = date('Y-m-d',strtotime($worksheet->getCell($d.$row )->getFormattedValue()));
						}else if($key=="call_date"){
							$user_list[$row][$key] = date('Y-m-d',strtotime($worksheet->getCell($d.$row )->getFormattedValue()));
						}else if($key=="call_duration"){
							$user_list[$row][$key] = intval(86400 * $worksheet->getCell($d.$row )->getValue());
						}else if($key=="auditor_mwp_id"){
							$user_list[$row]['entry_by'] =  $worksheet->getCell($d.$row )->getValue();
						}
						else if($key=="fusion_id"){
							$fusion_id = $worksheet->getCell($d.$row )->getValue();
							 $qSql = "Select id as agent_id, assigned_to as tl_id, fusion_id, get_process_names(id) as process_name, office_id, (select concat(fname, ' ', lname) from signin tl where tl.id=signin.assigned_to) as tl_name FROM signin where fusion_id = '$fusion_id'";
							
							$tl_agent_ids = $this->Common_model->get_query_row_array($qSql);

							// $sql_qa_name = "select concat(fname, ' ', lname) as auditor_name from signin qa where qa.id='$current_user'";
							// $qa_name = $this->Common_model->get_query_row_array($sql_qa_name);

							$user_list[$row]['agent_id'] 			=  $tl_agent_ids['agent_id'];
							$user_list[$row]['tl_id']    			=  $tl_agent_ids['tl_id'];
							//$user_list[$row]['entry_by']   			=  $current_user;
							//$user_list[$row]['auditor_name']   		=  $qa_name['auditor_name'];
							$user_list[$row]['entry_date']   		=  $audit_time_each;
							$user_list[$row]['audit_start_time']   	=  $audit_start_time;
							

						}
						else{
							$user_list[$row][$key] =  $worksheet->getCell($d.$row )->getValue();
						}
					}	
				}

				// echo"<pre>";
				// print_r($user_list);
				// echo"</pre>";
				 //die();
			
				$this->Qa_philip_model->biomet_call_data($user_list);
				redirect('Qa_biomet');
			}
		}
	}

	function import_biomet_chat_excel_data(){
		
		$current_user = '';
		$audit_time = time();
		//$audit_start_time = date("Y-m-d h:i:s", $audit_time);
		//print_r($this->input->post());
		 $audit_start_time = $this->input->post('star_time');
		$this->load->library('excel');
		if(isset($_FILES["file"]["name"])){
		if(check_logged_in())
		{
			$current_user = get_user_id(); 
		}
			
			$path = $_FILES["file"]["tmp_name"];
			$object = PHPExcel_IOFactory::load($path);
			$clmarr = array("audit_date","fusion_id","auditor_mwp_id","call_date","call_duration","mission","recording_id","week","audit_type","auditor_type","voc","overall_score","earned_score","possible_score","appropiate_greeting","response_time","FCR_achieved","understand_issue","attentiveness_display","paraphrasing","use_available_resource","appropiate_probing","VAS_options","awareness_created","correct_disposition","update_ASM","capture_query","hold_required","hold_guidelines","formatting","avoid_negative_statement","procedure_guide_step","avoid_slangs","correct_grammar_use","further_assistance","chat_adherence","used_applicant","delayed_opening","rude_on_chat","inacurate_information","complaint_avoidance","reason_for_fatal","improvement_area","call_summary","feedback");
			
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
				
					foreach($clmarr as $name){
						if($name == $colindex){
							 $dd[$colindex]  = $adjustedColumn;
						}
					}
				}
				
				//$random_row = round(($highestRow * (20/100)));				
				for($row=2; $row<=$highestRow; $row++){
					foreach($dd as $key=>$d){
						$audit_time1 = time();
		                $audit_time_each = date("Y-m-d h:i:s", $audit_time1);
						
						if($key=="audit_date"){
							$user_list[$row][$key] = date('Y-m-d',strtotime($worksheet->getCell($d.$row )->getFormattedValue()));
						}else if($key=="call_date"){
							$user_list[$row][$key] = date('Y-m-d',strtotime($worksheet->getCell($d.$row )->getFormattedValue()));
						}else if($key=="call_duration"){
							$user_list[$row][$key] = intval(86400 * $worksheet->getCell($d.$row )->getValue());
						}else if($key=="auditor_mwp_id"){
							$user_list[$row]['entry_by'] =  $worksheet->getCell($d.$row )->getValue();
						}
						else if($key=="fusion_id"){
							$fusion_id = $worksheet->getCell($d.$row )->getValue();
							 $qSql = "Select id as agent_id, assigned_to as tl_id, fusion_id, get_process_names(id) as process_name, office_id, (select concat(fname, ' ', lname) from signin tl where tl.id=signin.assigned_to) as tl_name FROM signin where fusion_id = '$fusion_id'";
							
							$tl_agent_ids = $this->Common_model->get_query_row_array($qSql);

							// $sql_qa_name = "select concat(fname, ' ', lname) as auditor_name from signin qa where qa.id='$current_user'";
							// $qa_name = $this->Common_model->get_query_row_array($sql_qa_name);

							$user_list[$row]['agent_id'] 			=  $tl_agent_ids['agent_id'];
							$user_list[$row]['tl_id']    			=  $tl_agent_ids['tl_id'];
							//$user_list[$row]['entry_by']   			=  $current_user;
							//$user_list[$row]['auditor_name']   		=  $qa_name['auditor_name'];
							$user_list[$row]['entry_date']   		=  $audit_time_each;
							$user_list[$row]['audit_start_time']   	=  $audit_start_time;
							

						}
						else{
							$user_list[$row][$key] =  $worksheet->getCell($d.$row )->getValue();
						}
					}	
				}

				// echo"<pre>";
				// print_r($user_list);
				// echo"</pre>";
				 //die();
			
				$this->Qa_philip_model->biomet_chat_data($user_list);
				redirect('Qa_biomet');
			}
		}
	}

	function import_biomet_email_excel_data(){
		
		$current_user = '';
		$audit_time = time();
		//$audit_start_time = date("Y-m-d h:i:s", $audit_time);
		//print_r($this->input->post());
		 $audit_start_time = $this->input->post('star_time');
		$this->load->library('excel');
		if(isset($_FILES["file"]["name"])){
		if(check_logged_in())
		{
			$current_user = get_user_id(); 
		}
			
			$path = $_FILES["file"]["tmp_name"];
			$object = PHPExcel_IOFactory::load($path);
			$clmarr = array("audit_date","fusion_id","auditor_mwp_id","call_date","call_duration","mission","recording_id","week","audit_type","auditor_type","voc","overall_score","earned_score","possible_score","use_paragraph_idea","use_bullet_point","adhered_word_limit","template_adherence","interim_responce","FCR_achieved","understand_issue","attentiveness_display","use_available_resource","standardized_subject","VAS_option","awarreness_created","correct_disposition","update_ASM","capture_query","formatting","show_customer_feel_value","procedure_guide_step","avoid_slangs","correct_grammar_use","correct_closing","further_assistance","used_applicant","rude_on_email","inacurate_information","email_hygiene","complaint_avoidance","reason_for_fatal","improvement_area","call_summary","feedback");
			
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
				
					foreach($clmarr as $name){
						if($name == $colindex){
							 $dd[$colindex]  = $adjustedColumn;
						}
					}
				}
				
				//$random_row = round(($highestRow * (20/100)));				
				for($row=2; $row<=$highestRow; $row++){
					foreach($dd as $key=>$d){
						$audit_time1 = time();
		                $audit_time_each = date("Y-m-d h:i:s", $audit_time1);
						
						if($key=="audit_date"){
							$user_list[$row][$key] = date('Y-m-d',strtotime($worksheet->getCell($d.$row )->getFormattedValue()));
						}else if($key=="call_date"){
							$user_list[$row][$key] = date('Y-m-d',strtotime($worksheet->getCell($d.$row )->getFormattedValue()));
						}else if($key=="call_duration"){
							$user_list[$row][$key] = intval(86400 * $worksheet->getCell($d.$row )->getValue());
						}else if($key=="auditor_mwp_id"){
							$user_list[$row]['entry_by'] =  $worksheet->getCell($d.$row )->getValue();
						}
						else if($key=="fusion_id"){
							$fusion_id = $worksheet->getCell($d.$row )->getValue();
							 $qSql = "Select id as agent_id, assigned_to as tl_id, fusion_id, get_process_names(id) as process_name, office_id, (select concat(fname, ' ', lname) from signin tl where tl.id=signin.assigned_to) as tl_name FROM signin where fusion_id = '$fusion_id'";
							
							$tl_agent_ids = $this->Common_model->get_query_row_array($qSql);

							// $sql_qa_name = "select concat(fname, ' ', lname) as auditor_name from signin qa where qa.id='$current_user'";
							// $qa_name = $this->Common_model->get_query_row_array($sql_qa_name);

							$user_list[$row]['agent_id'] 			=  $tl_agent_ids['agent_id'];
							$user_list[$row]['tl_id']    			=  $tl_agent_ids['tl_id'];
							//$user_list[$row]['entry_by']   			=  $current_user;
							//$user_list[$row]['auditor_name']   		=  $qa_name['auditor_name'];
							$user_list[$row]['entry_date']   		=  $audit_time_each;
							$user_list[$row]['audit_start_time']   	=  $audit_start_time;
							

						}
						else{
							$user_list[$row][$key] =  $worksheet->getCell($d.$row )->getValue();
						}
					}	
				}

				// echo"<pre>";
				// print_r($user_list);
				// echo"</pre>";
				 //die();
			
				$this->Qa_philip_model->biomet_email_data($user_list);
				redirect('Qa_biomet');
			}
		}
	}

	function import_premium_excel_data(){
		
		$current_user = '';
		$audit_time = time();
		//$audit_start_time = date("Y-m-d h:i:s", $audit_time);
		//print_r($this->input->post());
		 $audit_start_time = $this->input->post('star_time');
		$this->load->library('excel');
		if(isset($_FILES["file"]["name"])){
		if(check_logged_in())
		{
			$current_user = get_user_id(); 
		}
			
			$path = $_FILES["file"]["tmp_name"];
			$object = PHPExcel_IOFactory::load($path);
			$clmarr = array("audit_date","fusion_id","auditor_mwp_id","call_date","call_duration","call_type","customer_name","customer_contact","five9_id","pass_fail","objection","campaign","customer_voc","phone","agent_disposition","qa_disposition","audit_type","auditor_type","voc","overall_score","possible_score","earned_score","customer_score","business_score","compliance_score","call_id","ticket_id","Product","script","professional","pace","questions","information","program","accurately","Confirmation","cmt1","cmt2","cmt3","cmt4","cmt5","cmt6","cmt7","cmt8","cmt9","cmt10","cmt11","cmt12","cmt13","cmt14","cmt15","cmt16","cmt17","cmt18","cmt19","cmt20","cmt21","cmt22","cmt23","call_summary","feedback");
			
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
				
					foreach($clmarr as $name){
						if($name == $colindex){
							 $dd[$colindex]  = $adjustedColumn;
						}
					}
				}
				
				//$random_row = round(($highestRow * (20/100)));				
				for($row=2; $row<=$highestRow; $row++){
					foreach($dd as $key=>$d){
						$audit_time1 = time();
		                $audit_time_each = date("Y-m-d h:i:s", $audit_time1);
						
						if($key=="audit_date"){
							$user_list[$row][$key] = date('Y-m-d',strtotime($worksheet->getCell($d.$row )->getFormattedValue()));
						}else if($key=="call_date"){
							$user_list[$row][$key] = date('Y-m-d',strtotime($worksheet->getCell($d.$row )->getFormattedValue()));
						}else if($key=="call_duration"){
							$user_list[$row][$key] = intval(86400 * $worksheet->getCell($d.$row )->getValue());
						}else if($key=="auditor_mwp_id"){
							$user_list[$row]['entry_by'] =  $worksheet->getCell($d.$row )->getValue();
						}
						else if($key=="fusion_id"){
							$fusion_id = $worksheet->getCell($d.$row )->getValue();
							 $qSql = "Select id as agent_id, assigned_to as tl_id, fusion_id, get_process_names(id) as process_name, office_id, (select concat(fname, ' ', lname) from signin tl where tl.id=signin.assigned_to) as tl_name FROM signin where fusion_id = '$fusion_id'";
							
							$tl_agent_ids = $this->Common_model->get_query_row_array($qSql);

							// $sql_qa_name = "select concat(fname, ' ', lname) as auditor_name from signin qa where qa.id='$current_user'";
							// $qa_name = $this->Common_model->get_query_row_array($sql_qa_name);

							$user_list[$row]['agent_id'] 			=  $tl_agent_ids['agent_id'];
							$user_list[$row]['tl_id']    			=  $tl_agent_ids['tl_id'];
							//$user_list[$row]['entry_by']   			=  $current_user;
							//$user_list[$row]['auditor_name']   		=  $qa_name['auditor_name'];
							$user_list[$row]['entry_date']   		=  $audit_time_each;
							$user_list[$row]['audit_start_time']   	=  $audit_start_time;
							

						}
						else{
							$user_list[$row][$key] =  $worksheet->getCell($d.$row )->getValue();
						}
					}	
				}

				// echo"<pre>";
				// print_r($user_list);
				// echo"</pre>";
				 //die();
			
				$this->Qa_philip_model->premium_data($user_list);
				redirect('Qa_premium');
			}
		}
	}

	function import_premium_sq_excel_data(){
		
		$current_user = '';
		$audit_time = time();
		//$audit_start_time = date("Y-m-d h:i:s", $audit_time);
		//print_r($this->input->post());
		 $audit_start_time = $this->input->post('star_time');
		$this->load->library('excel');
		if(isset($_FILES["file"]["name"])){
		if(check_logged_in())
		{
			$current_user = get_user_id(); 
		}
			
			$path = $_FILES["file"]["tmp_name"];
			$object = PHPExcel_IOFactory::load($path);
			$clmarr = array("audit_date","fusion_id","auditor_mwp_id","call_date","call_duration","audit_type","auditor_type","voc","overall_score","possible_score","earned_score","customer_score_percent","business_score_percent","compliance_score_percent","call_id","ticket_id","script","professional","sympathy","pace","questions","information","throughout_call","transitional","program","accurately","retiree_plan","Confirmation","verbatim","rebuttals","outcomes_call","cmt1","cmt2","cmt3","cmt4","cmt5","cmt6","cmt7","cmt8","cmt9","cmt10","cmt11","cmt12","cmt13","cmt14","cmt15","call_summary","feedback");
			
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
				
					foreach($clmarr as $name){
						if($name == $colindex){
							 $dd[$colindex]  = $adjustedColumn;
						}
					}
				}
				
				//$random_row = round(($highestRow * (20/100)));				
				for($row=2; $row<=$highestRow; $row++){
					foreach($dd as $key=>$d){
						$audit_time1 = time();
		                $audit_time_each = date("Y-m-d h:i:s", $audit_time1);
						
						if($key=="audit_date"){
							$user_list[$row][$key] = date('Y-m-d',strtotime($worksheet->getCell($d.$row )->getFormattedValue()));
						}else if($key=="call_date"){
							$user_list[$row][$key] = date('Y-m-d',strtotime($worksheet->getCell($d.$row )->getFormattedValue()));
						}else if($key=="call_duration"){
							$user_list[$row][$key] = intval(86400 * $worksheet->getCell($d.$row )->getValue());
						}else if($key=="auditor_mwp_id"){
							$user_list[$row]['entry_by'] =  $worksheet->getCell($d.$row )->getValue();
						}
						else if($key=="fusion_id"){
							$fusion_id = $worksheet->getCell($d.$row )->getValue();
							 $qSql = "Select id as agent_id, assigned_to as tl_id, fusion_id, get_process_names(id) as process_name, office_id, (select concat(fname, ' ', lname) from signin tl where tl.id=signin.assigned_to) as tl_name FROM signin where fusion_id = '$fusion_id'";
							
							$tl_agent_ids = $this->Common_model->get_query_row_array($qSql);

							// $sql_qa_name = "select concat(fname, ' ', lname) as auditor_name from signin qa where qa.id='$current_user'";
							// $qa_name = $this->Common_model->get_query_row_array($sql_qa_name);

							$user_list[$row]['agent_id'] 			=  $tl_agent_ids['agent_id'];
							$user_list[$row]['tl_id']    			=  $tl_agent_ids['tl_id'];
							//$user_list[$row]['entry_by']   			=  $current_user;
							//$user_list[$row]['auditor_name']   		=  $qa_name['auditor_name'];
							$user_list[$row]['entry_date']   		=  $audit_time_each;
							$user_list[$row]['audit_start_time']   	=  $audit_start_time;
							

						}
						else{
							$user_list[$row][$key] =  $worksheet->getCell($d.$row )->getValue();
						}
					}	
				}

				// echo"<pre>";
				// print_r($user_list);
				// echo"</pre>";
				 //die();
			
				$this->Qa_philip_model->premium_sq_data($user_list);
				redirect('Qa_premium');
			}
		}
	}

	function import_premium_mc_excel_data(){
		
		$current_user = '';
		$audit_time = time();
		//$audit_start_time = date("Y-m-d h:i:s", $audit_time);
		//print_r($this->input->post());
		 $audit_start_time = $this->input->post('star_time');
		$this->load->library('excel');
		if(isset($_FILES["file"]["name"])){
		if(check_logged_in())
		{
			$current_user = get_user_id(); 
		}
			
			$path = $_FILES["file"]["tmp_name"];
			$object = PHPExcel_IOFactory::load($path);
			$clmarr = array("audit_date","fusion_id","auditor_mwp_id","call_date","call_duration","audit_type","auditor_type","voc","overall_score","possible_score","earned_score","customer_score_percent","business_score_percent","compliance_score_percent","call_id","ticket_id","script","professional","sympathy","pace","questions","information","throughout_call","transitional","program","accurately","retiree_plan","Confirmation","rebuttals","verbatim","outcomes_call","cmt1","cmt2","cmt3","cmt4","cmt5","cmt6","cmt7","cmt8","cmt9","cmt10","cmt11","cmt12","cmt13","cmt14","cmt15","call_summary","feedback");
			
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
				
					foreach($clmarr as $name){
						if($name == $colindex){
							 $dd[$colindex]  = $adjustedColumn;
						}
					}
				}
				
				//$random_row = round(($highestRow * (20/100)));				
				for($row=2; $row<=$highestRow; $row++){
					foreach($dd as $key=>$d){
						$audit_time1 = time();
		                $audit_time_each = date("Y-m-d h:i:s", $audit_time1);
						
						if($key=="audit_date"){
							$user_list[$row][$key] = date('Y-m-d',strtotime($worksheet->getCell($d.$row )->getFormattedValue()));
						}else if($key=="call_date"){
							$user_list[$row][$key] = date('Y-m-d',strtotime($worksheet->getCell($d.$row )->getFormattedValue()));
						}else if($key=="call_duration"){
							$user_list[$row][$key] = intval(86400 * $worksheet->getCell($d.$row )->getValue());
						}else if($key=="auditor_mwp_id"){
							$user_list[$row]['entry_by'] =  $worksheet->getCell($d.$row )->getValue();
						}
						else if($key=="fusion_id"){
							$fusion_id = $worksheet->getCell($d.$row )->getValue();
							 $qSql = "Select id as agent_id, assigned_to as tl_id, fusion_id, get_process_names(id) as process_name, office_id, (select concat(fname, ' ', lname) from signin tl where tl.id=signin.assigned_to) as tl_name FROM signin where fusion_id = '$fusion_id'";
							
							$tl_agent_ids = $this->Common_model->get_query_row_array($qSql);

							// $sql_qa_name = "select concat(fname, ' ', lname) as auditor_name from signin qa where qa.id='$current_user'";
							// $qa_name = $this->Common_model->get_query_row_array($sql_qa_name);

							$user_list[$row]['agent_id'] 			=  $tl_agent_ids['agent_id'];
							$user_list[$row]['tl_id']    			=  $tl_agent_ids['tl_id'];
							//$user_list[$row]['entry_by']   			=  $current_user;
							//$user_list[$row]['auditor_name']   		=  $qa_name['auditor_name'];
							$user_list[$row]['entry_date']   		=  $audit_time_each;
							$user_list[$row]['audit_start_time']   	=  $audit_start_time;
							

						}
						else{
							$user_list[$row][$key] =  $worksheet->getCell($d.$row )->getValue();
						}
					}	
				}

				// echo"<pre>";
				// print_r($user_list);
				// echo"</pre>";
				 //die();
			
				$this->Qa_philip_model->premium_mc_data($user_list);
				redirect('Qa_premium');
			}
		}
	}

	function import_premium_vbc_excel_data(){
		
		$current_user = '';
		$audit_time = time();
		//$audit_start_time = date("Y-m-d h:i:s", $audit_time);
		//print_r($this->input->post());
		 $audit_start_time = $this->input->post('star_time');
		$this->load->library('excel');
		if(isset($_FILES["file"]["name"])){
		if(check_logged_in())
		{
			$current_user = get_user_id(); 
		}
			
			$path = $_FILES["file"]["tmp_name"];
			$object = PHPExcel_IOFactory::load($path);
			$clmarr = array("audit_date","fusion_id","auditor_mwp_id","fusion_id","call_date","call_duration","audit_type","auditor_type","voc","overall_score","possible_score","earned_score","customer_score_percent","business_score_percent","compliance_score_percent","call_id","ticket_id","script","professional","pace","questions","information","program","accurately","retiree_plan","Confirmation","verbatim","sympathy","rebuttals","outcomes_call","cmt1","cmt2","cmt3","cmt4","cmt5","cmt6","cmt7","cmt8","cmt9","cmt10","cmt11","cmt12","cmt13","call_summary","feedback");
			
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
				
					foreach($clmarr as $name){
						if($name == $colindex){
							 $dd[$colindex]  = $adjustedColumn;
						}
					}
				}
				
				//$random_row = round(($highestRow * (20/100)));				
				for($row=2; $row<=$highestRow; $row++){
					foreach($dd as $key=>$d){
						$audit_time1 = time();
		                $audit_time_each = date("Y-m-d h:i:s", $audit_time1);
						
						if($key=="audit_date"){
							$user_list[$row][$key] = date('Y-m-d',strtotime($worksheet->getCell($d.$row )->getFormattedValue()));
						}else if($key=="call_date"){
							$user_list[$row][$key] = date('Y-m-d',strtotime($worksheet->getCell($d.$row )->getFormattedValue()));
						}else if($key=="call_duration"){
							$user_list[$row][$key] = intval(86400 * $worksheet->getCell($d.$row )->getValue());
						}else if($key=="auditor_mwp_id"){
							$user_list[$row]['entry_by'] =  $worksheet->getCell($d.$row )->getValue();
						}
						else if($key=="fusion_id"){
							$fusion_id = $worksheet->getCell($d.$row )->getValue();
							 $qSql = "Select id as agent_id, assigned_to as tl_id, fusion_id, get_process_names(id) as process_name, office_id, (select concat(fname, ' ', lname) from signin tl where tl.id=signin.assigned_to) as tl_name FROM signin where fusion_id = '$fusion_id'";
							
							$tl_agent_ids = $this->Common_model->get_query_row_array($qSql);

							// $sql_qa_name = "select concat(fname, ' ', lname) as auditor_name from signin qa where qa.id='$current_user'";
							// $qa_name = $this->Common_model->get_query_row_array($sql_qa_name);

							$user_list[$row]['agent_id'] 			=  $tl_agent_ids['agent_id'];
							$user_list[$row]['tl_id']    			=  $tl_agent_ids['tl_id'];
							//$user_list[$row]['entry_by']   			=  $current_user;
							//$user_list[$row]['auditor_name']   		=  $qa_name['auditor_name'];
							$user_list[$row]['entry_date']   		=  $audit_time_each;
							$user_list[$row]['audit_start_time']   	=  $audit_start_time;
							

						}
						else{
							$user_list[$row][$key] =  $worksheet->getCell($d.$row )->getValue();
						}
					}	
				}

				// echo"<pre>";
				// print_r($user_list);
				// echo"</pre>";
				 //die();
			
				$this->Qa_philip_model->premium_vbc_data($user_list);
				redirect('Qa_premium');
			}
		}
	}

	function import_telaidsaob_excel_data(){
		
		$current_user = '';
		$audit_time = time();
		//$audit_start_time = date("Y-m-d h:i:s", $audit_time);
		//print_r($this->input->post());
		 $audit_start_time = $this->input->post('star_time');
		$this->load->library('excel');
		if(isset($_FILES["file"]["name"])){
		if(check_logged_in())
		{
			$current_user = get_user_id(); 
		}
			
			$path = $_FILES["file"]["tmp_name"];
			$object = PHPExcel_IOFactory::load($path);
			$clmarr = array("audit_date","fusion_id","auditor_mwp_id","call_date","audit_type","auditor_type","call_duration","week","voc","case_number","case_topic","acpt","qa_score","complete_documentation","refrain_negative","notes_visible","call_assoc_ticket","notes_posted_labor","verify_amp_volte","offers_resend_email","discuss_detail","reach_out_pm","accur_prov_info","additional_assistance","mention_brand","recommended_scripts","redial_number","ghost_call_spiel","attempt_3rd","match_style_pace","recap_details","immediate_acknowledge","maintain_friendly","active_listening","advise_ticket_status","task_correct_stage","avoid_jargons","complete_documentation_remarks","refrain_negative_remarks","notes_visible_remarks","call_assoc_ticket_remarks","notes_posted_labor_remarks","verify_amp_volte_remarks","offers_resend_email_remarks","discuss_detail_remarks","reach_out_pm_remarks","accur_prov_info_remarks","additional_assistance_remarks","mention_brand_remarks","recommended_scripts_remarks","redial_number_remarks","ghost_call_spiel_remarks","attempt_3rd_remarks","match_style_pace_remarks","recap_details_remarks","immediate_acknowledge_remarks","maintain_friendly_remarks","active_listening_remarks","advise_ticket_status_remarks","task_correct_stage_remarks","avoid_jargons_remarks","call_summary","feedback");
			
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
				
					foreach($clmarr as $name){
						if($name == $colindex){
							 $dd[$colindex]  = $adjustedColumn;
						}
					}
				}
				
				//$random_row = round(($highestRow * (20/100)));				
				for($row=2; $row<=$highestRow; $row++){
					foreach($dd as $key=>$d){
						$audit_time1 = time();
		                $audit_time_each = date("Y-m-d h:i:s", $audit_time1);
						
						if($key=="audit_date"){
							$user_list[$row][$key] = date('Y-m-d',strtotime($worksheet->getCell($d.$row )->getFormattedValue()));
						}else if($key=="call_date"){
							$user_list[$row][$key] = date('Y-m-d',strtotime($worksheet->getCell($d.$row )->getFormattedValue()));
						}else if($key=="call_duration"){
							$user_list[$row][$key] = intval(86400 * $worksheet->getCell($d.$row )->getValue());
						}else if($key=="auditor_mwp_id"){
							$user_list[$row]['entry_by'] =  $worksheet->getCell($d.$row )->getValue();
						}
						else if($key=="fusion_id"){
							$fusion_id = $worksheet->getCell($d.$row )->getValue();
							 $qSql = "Select id as agent_id, assigned_to as tl_id, fusion_id, get_process_names(id) as process_name, office_id, (select concat(fname, ' ', lname) from signin tl where tl.id=signin.assigned_to) as tl_name FROM signin where fusion_id = '$fusion_id'";
							
							$tl_agent_ids = $this->Common_model->get_query_row_array($qSql);

							// $sql_qa_name = "select concat(fname, ' ', lname) as auditor_name from signin qa where qa.id='$current_user'";
							// $qa_name = $this->Common_model->get_query_row_array($sql_qa_name);

							$user_list[$row]['agent_id'] 			=  $tl_agent_ids['agent_id'];
							$user_list[$row]['tl_id']    			=  $tl_agent_ids['tl_id'];
							//$user_list[$row]['entry_by']   			=  $current_user;
							//$user_list[$row]['auditor_name']   		=  $qa_name['auditor_name'];
							$user_list[$row]['entry_date']   		=  $audit_time_each;
							$user_list[$row]['audit_start_time']   	=  $audit_start_time;
							

						}
						else{
							$user_list[$row][$key] =  $worksheet->getCell($d.$row )->getValue();
						}
					}	
				}

				// echo"<pre>";
				// print_r($user_list);
				// echo"</pre>";
				 //die();
			
				$this->Qa_philip_model->telaidsaob_data($user_list);
				redirect('Qa_telaid');
			}
		}
	}

	//////////////////////////////////////////////////////////////////////////////

	public function sample_stratus_download(){
		if(check_logged_in()){ 
			$file_name = base_url()."qa_files/qa_stratus/sample_stratus_file.xlsx";
			header("location:".$file_name);	
			exit();
		}
	}

	public function sample_stratus_csr_download(){
		if(check_logged_in()){ 
			$file_name = base_url()."qa_files/qa_stratus/sample_stratus_csr_file.xlsx";
			header("location:".$file_name);	
			exit();
		}
	}

	public function sample_stratus_outbound_download(){
		if(check_logged_in()){ 
			$file_name = base_url()."qa_files/qa_stratus/sample_stratus_outbound_file.xlsx";
			header("location:".$file_name);	
			exit();
		}
	}

	public function sample_stratus_call_tech_download(){
		if(check_logged_in()){ 
			$file_name = base_url()."qa_files/qa_stratus/sample_stratus_call_tech_file.xlsx";
			header("location:".$file_name);	
			exit();
		}
	}

	public function sample_stratus_monitoring_tech_download(){
		if(check_logged_in()){ 
			$file_name = base_url()."qa_files/qa_stratus/sample_stratus_monitoring_tech_file.xlsx";
			header("location:".$file_name);	
			exit();
		}
	}

	public function sample_biomet_call_download(){
		if(check_logged_in()){ 
			$file_name = base_url()."qa_files/qa_stratus/sample_biomet_call_file.xlsx";
			header("location:".$file_name);	
			exit();
		}
	}

	public function sample_biomet_chat_download(){
		if(check_logged_in()){ 
			$file_name = base_url()."qa_files/qa_stratus/sample_biomet_chat_file.xlsx";
			header("location:".$file_name);	
			exit();
		}
	}

	public function sample_biomet_email_download(){
		if(check_logged_in()){ 
			$file_name = base_url()."qa_files/qa_stratus/sample_biomet_email_file.xlsx";
			header("location:".$file_name);	
			exit();
		}
	}

	public function sample_premium_download(){
		if(check_logged_in()){ 
			$file_name = base_url()."qa_files/qa_premium/sample_premium_file.xlsx";
			header("location:".$file_name);	
			exit();
		}
	}

	public function sample_premium_sq_download(){
		if(check_logged_in()){ 
			$file_name = base_url()."qa_files/qa_premium/sample_premium_sq_file.xlsx";
			header("location:".$file_name);	
			exit();
		}
	}

	public function sample_premium_mc_download(){
		if(check_logged_in()){ 
			$file_name = base_url()."qa_files/qa_premium/sample_premium_mc_file.xlsx";
			header("location:".$file_name);	
			exit();
		}
	}

	public function sample_premium_vbc_download(){
		if(check_logged_in()){ 
			$file_name = base_url()."qa_files/qa_premium/sample_premium_vbc_file.xlsx";
			header("location:".$file_name);	
			exit();
		}
	}

	public function sample_telaidsaob_download(){
		if(check_logged_in()){ 
			$file_name = base_url()."qa_files/qa_telaid/sample_telaidsaob_file.xlsx";
			header("location:".$file_name);	
			exit();
		}
	}

	//////////////////////////////////////////////////////////////////////////////////////

	function import_ameriflex_excel_data(){
		
		$current_user = '';
		$audit_time = time();
		//$audit_start_time = date("Y-m-d h:i:s", $audit_time);
		//print_r($this->input->post());
		 $audit_start_time = $this->input->post('star_time');
		$this->load->library('excel');
		if(isset($_FILES["file"]["name"])){
		if(check_logged_in())
		{
			$current_user = get_user_id(); 
		}
			
			$path = $_FILES["file"]["tmp_name"];
			$object = PHPExcel_IOFactory::load($path);
			$clmarr = array("audit_date","fusion_id","auditor_mwp_id","call_date","type","interaction_id","audit_type","auditor_type","voc","call_duration","earned_score","possible_score","overall_score","caller_properly_greed","show_empathy_sympathy","adjust_caller_pace","use_caller_name_two_times","sound_though_assist_caller","avoid_interruption_caller_speaking","use_thatnk_you_appologies","own_the_issue","avoid_dead_air","confirm_caller_contact","communicate_timelines","repeat_caller_question_issue","provide_professional_accurate","take_appropiate_actiona","demonstrate_appropiate_hold_process","avoid_internal_jargon","validate_issue_was_resolved","ask_any_additional_assistance","properly_close_the_call","cmt1","cmt2","cmt3","cmt4","cmt5","cmt6","cmt7","cmt8","cmt9","cmt10","cmt11","cmt12","cmt13","cmt14","cmt15","cmt16","cmt17","cmt18","cmt19","call_summary","feedback");
			
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
				
					foreach($clmarr as $name){
						if($name == $colindex){
							 $dd[$colindex]  = $adjustedColumn;
						}
					}
				}
				
				//$random_row = round(($highestRow * (20/100)));				
				for($row=2; $row<=$highestRow; $row++){
					foreach($dd as $key=>$d){
						$audit_time1 = time();
		                $audit_time_each = date("Y-m-d h:i:s", $audit_time1);
						
						if($key=="audit_date"){
							$user_list[$row][$key] = date('Y-m-d',strtotime($worksheet->getCell($d.$row )->getFormattedValue()));
						}else if($key=="call_date"){
							$user_list[$row][$key] = date('Y-m-d',strtotime($worksheet->getCell($d.$row )->getFormattedValue()));
						}else if($key=="call_duration"){
							$user_list[$row][$key] = intval(86400 * $worksheet->getCell($d.$row )->getValue());
						}else if($key=="auditor_mwp_id"){
							$user_list[$row]['entry_by'] =  $worksheet->getCell($d.$row )->getValue();
						}
						else if($key=="fusion_id"){
							$fusion_id = $worksheet->getCell($d.$row )->getValue();
							 $qSql = "Select id as agent_id, assigned_to as tl_id, fusion_id, get_process_names(id) as process_name, office_id, (select concat(fname, ' ', lname) from signin tl where tl.id=signin.assigned_to) as tl_name FROM signin where fusion_id = '$fusion_id'";
							
							$tl_agent_ids = $this->Common_model->get_query_row_array($qSql);

							// $sql_qa_name = "select concat(fname, ' ', lname) as auditor_name from signin qa where qa.id='$current_user'";
							// $qa_name = $this->Common_model->get_query_row_array($sql_qa_name);

							$user_list[$row]['agent_id'] 			=  $tl_agent_ids['agent_id'];
							$user_list[$row]['tl_id']    			=  $tl_agent_ids['tl_id'];
							//$user_list[$row]['entry_by']   			=  $current_user;
							//$user_list[$row]['auditor_name']   		=  $qa_name['auditor_name'];
							$user_list[$row]['entry_date']   		=  $audit_time_each;
							$user_list[$row]['audit_start_time']   	=  $audit_start_time;
							

						}
						else{
							$user_list[$row][$key] =  $worksheet->getCell($d.$row )->getValue();
						}
					}	
				}

				// echo"<pre>";
				// print_r($user_list);
				// echo"</pre>";
				 //die();
			
				$this->Qa_philip_model->ameriflex_data($user_list);
				redirect('Qa_ameriflex');
			}
		}
	}

	function import_carparts_service_excel_data(){
		
		$current_user = '';
		$audit_time = time();
		//$audit_start_time = date("Y-m-d h:i:s", $audit_time);
		//print_r($this->input->post());
		 $audit_start_time = $this->input->post('star_time');
		$this->load->library('excel');
		if(isset($_FILES["file"]["name"])){
		if(check_logged_in())
		{
			$current_user = get_user_id(); 
		}
			
			$path = $_FILES["file"]["tmp_name"];
			$object = PHPExcel_IOFactory::load($path);
			$clmarr = array("audit_date","fusion_id","auditor_mwp_id","call_id","call_date","call_duration","call_type","audit_type","auditor_type","voc","disposition","qa_sampling","mc_disposition","order_no","sub_category","nps","csat","overall_score","possible_score","earned_score","cust_score","busi_score","comp_score","auto_fail","call_opening","account_verification","concern_assurance","tone_energyPace","rapport_empathy","probing","conveyance_resolution","proper_procedure","recap_statement","objections_handling","returns_tagging","documentation","actions_taken","action_self_service","cmt1","cmt2","cmt3","cmt4","cmt5","cmt6","cmt7","cmt8","cmt9","cmt10","cmt11","cmt12","cmt13","cmt14","call_summary","feedback");
			
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
				
					foreach($clmarr as $name){
						if($name == $colindex){
							 $dd[$colindex]  = $adjustedColumn;
						}
					}
				}
				
				//$random_row = round(($highestRow * (20/100)));				
				for($row=2; $row<=$highestRow; $row++){
					foreach($dd as $key=>$d){
						$audit_time1 = time();
		                $audit_time_each = date("Y-m-d h:i:s", $audit_time1);
						
						if($key=="audit_date"){
							$user_list[$row][$key] = date('Y-m-d',strtotime($worksheet->getCell($d.$row )->getFormattedValue()));
						}else if($key=="call_date"){
							$user_list[$row][$key] = date('Y-m-d',strtotime($worksheet->getCell($d.$row )->getFormattedValue()));
						}else if($key=="call_duration"){
							$user_list[$row][$key] = intval(86400 * $worksheet->getCell($d.$row )->getValue());
						}else if($key=="auditor_mwp_id"){
							$user_list[$row]['entry_by'] =  $worksheet->getCell($d.$row )->getValue();
						}
						else if($key=="fusion_id"){
							$fusion_id = $worksheet->getCell($d.$row )->getValue();
							 $qSql = "Select id as agent_id, assigned_to as tl_id, fusion_id, get_process_names(id) as process_name, office_id, (select concat(fname, ' ', lname) from signin tl where tl.id=signin.assigned_to) as tl_name FROM signin where fusion_id = '$fusion_id'";
							
							$tl_agent_ids = $this->Common_model->get_query_row_array($qSql);

							// $sql_qa_name = "select concat(fname, ' ', lname) as auditor_name from signin qa where qa.id='$current_user'";
							// $qa_name = $this->Common_model->get_query_row_array($sql_qa_name);

							$user_list[$row]['agent_id'] 			=  $tl_agent_ids['agent_id'];
							$user_list[$row]['tl_id']    			=  $tl_agent_ids['tl_id'];
							//$user_list[$row]['entry_by']   			=  $current_user;
							//$user_list[$row]['auditor_name']   		=  $qa_name['auditor_name'];
							$user_list[$row]['entry_date']   		=  $audit_time_each;
							$user_list[$row]['audit_start_time']   	=  $audit_start_time;
							

						}
						else{
							$user_list[$row][$key] =  $worksheet->getCell($d.$row )->getValue();
						}
					}	
				}

				// echo"<pre>";
				// print_r($user_list);
				// echo"</pre>";
				 //die();
			
				$this->Qa_philip_model->carparts_service_data($user_list);
				redirect('Qa_service');
			}
		}
	}

	public function sample_ameriflex_download(){
		if(check_logged_in()){ 
			$file_name = base_url()."qa_files/qa_telaid/sample_ameriflex_file.xlsx";
			header("location:".$file_name);	
			exit();
		}
	}

	public function sample_carparts_service_download(){
		if(check_logged_in()){ 
			$file_name = base_url()."qa_files/qa_service/sample_carparts_service_file.xlsx";
			header("location:".$file_name);	
			exit();
		}
	}

	function import_sales_carpart_inbound2_excel_data(){
		
		$current_user = '';
		$audit_time = time();
		//$audit_start_time = date("Y-m-d h:i:s", $audit_time);
		//print_r($this->input->post());
		 $audit_start_time = $this->input->post('star_time');
		$this->load->library('excel');
		if(isset($_FILES["file"]["name"])){
		if(check_logged_in())
		{
			$current_user = get_user_id(); 
		}
			
			$path = $_FILES["file"]["tmp_name"];
			$object = PHPExcel_IOFactory::load($path);
			$clmarr = array("audit_date","fusion_id","auditor_mwp_id","call_id","call_date","call_duration","call_type","audit_type","auditor_type","voc","disposition","qa_sampling","mc_disposition","order_no","sub_category","nps","csat","overall_score","possible_score","earned_score","cust_score","busi_score","comp_score","auto_fail","call_opening","account_verification","concern_assurance","tone_energyPace","rapport_empathy","probing","conveyance_resolution","proper_procedure","recap_statement","objections_handling","returns_tagging","documentation","actions_taken","action_self_service","cmt1","cmt2","cmt3","cmt4","cmt5","cmt6","cmt7","cmt8","cmt9","cmt10","cmt11","cmt12","cmt13","cmt14","call_summary","feedback");
			
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
				
					foreach($clmarr as $name){
						if($name == $colindex){
							 $dd[$colindex]  = $adjustedColumn;
						}
					}
				}
				
				//$random_row = round(($highestRow * (20/100)));				
				for($row=2; $row<=$highestRow; $row++){
					foreach($dd as $key=>$d){
						$audit_time1 = time();
		                $audit_time_each = date("Y-m-d h:i:s", $audit_time1);
						
						if($key=="audit_date"){
							$user_list[$row][$key] = date('Y-m-d',strtotime($worksheet->getCell($d.$row )->getFormattedValue()));
						}else if($key=="call_date"){
							$user_list[$row][$key] = date('Y-m-d',strtotime($worksheet->getCell($d.$row )->getFormattedValue()));
						}else if($key=="call_duration"){
							$user_list[$row][$key] = intval(86400 * $worksheet->getCell($d.$row )->getValue());
						}else if($key=="auditor_mwp_id"){
							$user_list[$row]['entry_by'] =  $worksheet->getCell($d.$row )->getValue();
						}
						else if($key=="fusion_id"){
							$fusion_id = $worksheet->getCell($d.$row )->getValue();
							 $qSql = "Select id as agent_id, assigned_to as tl_id, fusion_id, get_process_names(id) as process_name, office_id, (select concat(fname, ' ', lname) from signin tl where tl.id=signin.assigned_to) as tl_name FROM signin where fusion_id = '$fusion_id'";
							
							$tl_agent_ids = $this->Common_model->get_query_row_array($qSql);

							// $sql_qa_name = "select concat(fname, ' ', lname) as auditor_name from signin qa where qa.id='$current_user'";
							// $qa_name = $this->Common_model->get_query_row_array($sql_qa_name);

							$user_list[$row]['agent_id'] 			=  $tl_agent_ids['agent_id'];
							$user_list[$row]['tl_id']    			=  $tl_agent_ids['tl_id'];
							//$user_list[$row]['entry_by']   			=  $current_user;
							//$user_list[$row]['auditor_name']   		=  $qa_name['auditor_name'];
							$user_list[$row]['entry_date']   		=  $audit_time_each;
							$user_list[$row]['audit_start_time']   	=  $audit_start_time;
							

						}
						else{
							$user_list[$row][$key] =  $worksheet->getCell($d.$row )->getValue();
						}
					}	
				}

				// echo"<pre>";
				// print_r($user_list);
				// echo"</pre>";
				 //die();
			
				$this->Qa_philip_model->sales_carpart_inbound2_data($user_list);
				redirect('Qa_sales_carpart');
			}
		}
	}

	public function sample_sales_carpart_inbound2_download(){
		if(check_logged_in()){ 
			$file_name = base_url()."qa_files/qa_service/sample_sales_carpart_inbound2_file.xlsx";
			header("location:".$file_name);	
			exit();
		}
	}

	function import_jurys_inn_excel_data(){
		
		$current_user = '';
		$audit_time = time();
		//$audit_start_time = date("Y-m-d h:i:s", $audit_time);
		//print_r($this->input->post());
		 $audit_start_time = $this->input->post('star_time');
		$this->load->library('excel');
		if(isset($_FILES["file"]["name"])){
		if(check_logged_in())
		{
			$current_user = get_user_id(); 
		}
			
			$path = $_FILES["file"]["tmp_name"];
			$object = PHPExcel_IOFactory::load($path);
			$clmarr = array("audit_date","fusion_id","auditor_mwp_id","reservation_no","call_date","call_duration","audit_type","auditor_type","voc","pass_count","fail_count","na_count","overall_score","possible_score","earned_score","customer_score","business_score","compliance_score","greet_customer","greet_name","greet_conversation","greet_question","greet_utilise","qualifi_determine","qualifi_reconfirm","qualifi_customer","qualifi_guest","recognise_agent","recognise_caller","recognise_gdpr","recomend_guest","recomend_benefit","recomend_offer","recomend_upsell","recomend_room","overcome_positive","overcome_terms","sale_business","closure_booking","closure_email","closure_advise","closure_ask","ss_avoid","ss_display","ss_volunteer","ss_sound","ss_refrain","ss_welcome","ss_question","ss_demonstrate","greet1_comm","greet2_comm","greet3_comm","greet4_comm","greet5_comm","qualifi1_comm","qualifi2_comm","qualifi3_comm","qualifi4_comm","recognise1_comm","recognise2_comm","recognise3_comm","recomend1_comm","recomend2_comm","recomend3_comm","recomend4_comm","recomend5_comm","overcome1_comm","overcome2_comm","sale1_comm","closure1_comm","closure2_comm","closure3_comm","closure4_comm","ss1_comm","ss2_comm","ss3_comm","ss4_comm","ss5_comm","ss6_comm","ss7_comm","ss8_comm","follow_SOP","closure5_comm","correct_reason","correct_reason_comm","call_summary","feedback");
			
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
				
					foreach($clmarr as $name){
						if($name == $colindex){
							 $dd[$colindex]  = $adjustedColumn;
						}
					}
				}
				
				//$random_row = round(($highestRow * (20/100)));				
				for($row=2; $row<=$highestRow; $row++){
					foreach($dd as $key=>$d){
						$audit_time1 = time();
		                $audit_time_each = date("Y-m-d h:i:s", $audit_time1);
						
						if($key=="audit_date"){
							$user_list[$row][$key] = date('Y-m-d',strtotime($worksheet->getCell($d.$row )->getFormattedValue()));
						}else if($key=="call_date"){
							$user_list[$row][$key] = date('Y-m-d',strtotime($worksheet->getCell($d.$row )->getFormattedValue()));
						}else if($key=="call_duration"){
							$user_list[$row][$key] = intval(86400 * $worksheet->getCell($d.$row )->getValue());
						}else if($key=="auditor_mwp_id"){
							$user_list[$row]['entry_by'] =  $worksheet->getCell($d.$row )->getValue();
						}
						else if($key=="fusion_id"){
							$fusion_id = $worksheet->getCell($d.$row )->getValue();
							 $qSql = "Select id as agent_id, assigned_to as tl_id, fusion_id, get_process_names(id) as process_name, office_id, (select concat(fname, ' ', lname) from signin tl where tl.id=signin.assigned_to) as tl_name FROM signin where fusion_id = '$fusion_id'";
							
							$tl_agent_ids = $this->Common_model->get_query_row_array($qSql);

							// $sql_qa_name = "select concat(fname, ' ', lname) as auditor_name from signin qa where qa.id='$current_user'";
							// $qa_name = $this->Common_model->get_query_row_array($sql_qa_name);

							$user_list[$row]['agent_id'] 			=  $tl_agent_ids['agent_id'];
							$user_list[$row]['tl_id']    			=  $tl_agent_ids['tl_id'];
							//$user_list[$row]['entry_by']   			=  $current_user;
							//$user_list[$row]['auditor_name']   		=  $qa_name['auditor_name'];
							$user_list[$row]['entry_date']   		=  $audit_time_each;
							//$user_list[$row]['audit_start_time']   	=  $audit_start_time;
							

						}
						else{
							$user_list[$row][$key] =  $worksheet->getCell($d.$row )->getValue();
						}
					}	
				}

				// echo"<pre>";
				// print_r($user_list);
				// echo"</pre>";
				 //die();
			
				$this->Qa_philip_model->jurys_inn_data($user_list);
				redirect('Qa_jurys_inn');
			}
		}
	}

	public function sample_jurys_inn_download(){
		if(check_logged_in()){ 
			$file_name = base_url()."qa_files/qa_jurys_inn/sample_jurys_inn_file.xlsx";
			header("location:".$file_name);	
			exit();
		}
	}

	function import_jurys_inn_email_excel_data(){
		
		$current_user = '';
		$audit_time = time();
		//$audit_start_time = date("Y-m-d h:i:s", $audit_time);
		//print_r($this->input->post());
		 $audit_start_time = $this->input->post('star_time');
		$this->load->library('excel');
		if(isset($_FILES["file"]["name"])){
		if(check_logged_in())
		{
			$current_user = get_user_id(); 
		}
			
			$path = $_FILES["file"]["tmp_name"];
			$object = PHPExcel_IOFactory::load($path);
			$clmarr = array("audit_date","fusion_id","auditor_mwp_id","call_date","ref_id","query_type","query_sub_type","asmnt_type","tran_status","audit_type","auditor_type","voc","possible_score","earned_score","overall_score","agentuseopening","agentuseguestname","agentusetemplate","emailformatedcorrectly","agentusesignature","agentofferrevenue","agentcloseemail","agentuseinformation","agentreconfirmterms","agentstateguesthelp","agentofferalternative","agentanswerguestquestion","agentamendedsubjectline","agentcheckprefererate","agentsendemailcluster","agentGDPRconfirm","agentfollowSOPcorrect","cmt1","cmt2","cmt3","cmt4","cmt5","cmt6","cmt7","cmt8","cmt9","cmt10","cmt11","cmt12","cmt13","cmt14","cmt15","cmt16","cmt17","agentensurespelling","agnetselectcorrectproperty","agentselectcorrectdate","agentselectcorrectroombook","agentuseproperratecode","agentusepropergurantee","agentusecorrectpayment","agentmadeduplicatereservation","bookingmadeoverbusiness","agentmarkemailcorrectly","incorrectbookingchange","escalationagainstemail","customer_score","business_score","compliance_score","cmt18","cmt19","cmt20","cmt21","cmt22","cmt23","cmt24","cmt25","cmt26","cmt27","cmt28","cmt29","call_summary","feedback");
			
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
				
					foreach($clmarr as $name){
						if($name == $colindex){
							 $dd[$colindex]  = $adjustedColumn;
						}
					}
				}
				
				//$random_row = round(($highestRow * (20/100)));				
				for($row=2; $row<=$highestRow; $row++){
					foreach($dd as $key=>$d){
						$audit_time1 = time();
		                $audit_time_each = date("Y-m-d h:i:s", $audit_time1);
						
						if($key=="audit_date"){
							$user_list[$row][$key] = date('Y-m-d',strtotime($worksheet->getCell($d.$row )->getFormattedValue()));
						}else if($key=="call_date"){
							$user_list[$row][$key] = date('Y-m-d',strtotime($worksheet->getCell($d.$row )->getFormattedValue()));
						}else if($key=="call_duration"){
							$user_list[$row][$key] = intval(86400 * $worksheet->getCell($d.$row )->getValue());
						}else if($key=="auditor_mwp_id"){
							$user_list[$row]['entry_by'] =  $worksheet->getCell($d.$row )->getValue();
						}
						else if($key=="fusion_id"){
							$fusion_id = $worksheet->getCell($d.$row )->getValue();
							 $qSql = "Select id as agent_id, assigned_to as tl_id, fusion_id, get_process_names(id) as process_name, office_id, (select concat(fname, ' ', lname) from signin tl where tl.id=signin.assigned_to) as tl_name FROM signin where fusion_id = '$fusion_id'";
							
							$tl_agent_ids = $this->Common_model->get_query_row_array($qSql);

							// $sql_qa_name = "select concat(fname, ' ', lname) as auditor_name from signin qa where qa.id='$current_user'";
							// $qa_name = $this->Common_model->get_query_row_array($sql_qa_name);

							$user_list[$row]['agent_id'] 			=  $tl_agent_ids['agent_id'];
							$user_list[$row]['tl_id']    			=  $tl_agent_ids['tl_id'];
							//$user_list[$row]['entry_by']   			=  $current_user;
							//$user_list[$row]['auditor_name']   		=  $qa_name['auditor_name'];
							$user_list[$row]['entry_date']   		=  $audit_time_each;
							$user_list[$row]['audit_start_time']   	=  $audit_start_time;
							

						}
						else{
							$user_list[$row][$key] =  $worksheet->getCell($d.$row )->getValue();
						}
					}	
				}

				// echo"<pre>";
				// print_r($user_list);
				// echo"</pre>";
				 //die();
			
				$this->Qa_philip_model->jurys_inn_email_data($user_list);
				redirect('Qa_jurys_inn');
			}
		}
	}

	public function sample_jurys_inn_email_download(){
		if(check_logged_in()){ 
			$file_name = base_url()."qa_files/qa_jurys_inn/sample_jurys_inn_email_file.xlsx";
			header("location:".$file_name);	
			exit();
		}
	}

	function import_od_voice_excel_data(){
		
		$current_user = '';
		$audit_time = time();
		//$audit_start_time = date("Y-m-d h:i:s", $audit_time);
		//print_r($this->input->post());
		 $audit_start_time = $this->input->post('star_time');
		$this->load->library('excel');
		if(isset($_FILES["file"]["name"])){
		if(check_logged_in())
		{
			$current_user = get_user_id(); 
		}
			
			$path = $_FILES["file"]["tmp_name"];
			$object = PHPExcel_IOFactory::load($path);
			$clmarr = array("audit_date","call_date","fusion_id","auditor_mwp_id","ani","reviewed","review_date","customer_id","session_id","call_duration","lob","disposition_cate","disposition_sub_cate","audit_type","auditor_type","workgroup","voc","customer_voc","possible_score","earned_score","overall_score","division_status","acknowledge_the_caller","check_list1","made_the_customer","appropriate_and_sincere","check_list2","customer_clearly_understood","recognized_customer_contacted","verified_line_item","idepot_article_and","check_list3","noted_appropriately","check_list4","listened_and_paraphrased","verified_information","submit_the_proper_forms","proper_dispostion_code","check_list5","please_provide_type","compliancescore","customerscore","businessscore","compliancescoreable","customerscoreable","businessscoreable","compliance_score_percent","customer_score_percent","business_score_percent","acknowledge_rcal1","acknowledge_rcal2","acknowledge_rcal3","acknowledge_rcal_cmt","customer_rcal1","customer_rcal2","customer_rcal3","customer_rcal_cmt","appropriate_rcal1","appropriate_rcal2","appropriate_rcal3","appropriate_rcal_cmt","understood_rcal1","understood_rcal2","understood_rcal3","understood_rcal_cmt","recognized_rcal1","recognized_rcal2","recognized_rcal3","recognized_rcal_cmt","verified_rcal1","verified_rcal2","verified_rcal3","verified_rcal_cmt","idepot_rcal1","idepot_rcal2","idepot_rcal3","idepot_rcal_cmt","appropriately_rcal1","appropriately_rcal2","appropriately_rcal3","appropriately_rcal_cmt","paraphrased_rcal1","paraphrased_rcal2","paraphrased_rcal3","paraphrased_rcal_cmt","information_rcal1","information_rcal2","information_rcal3","information_rcal_cmt","submit_rcal1","submit_rcal2","submit_rcal3","submit_rcal_cmt","dispostion_rcal1","dispostion_rcal2","dispostion_rcal3","dispostion_rcal_cmt","please_rcal1","please_rcal2","please_rcal3","please_rcal_cmt","cmt1","cmt2","cmt3","cmt4","cmt5","cmt6","cmt7","cmt8","cmt9","cmt10","cmt11","cmt12","cmt13","call_summary","feedback");
			
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
				
					foreach($clmarr as $name){
						if($name == $colindex){
							 $dd[$colindex]  = $adjustedColumn;
						}
					}
				}
				
				//$random_row = round(($highestRow * (20/100)));				
				for($row=2; $row<=$highestRow; $row++){
					foreach($dd as $key=>$d){
						$audit_time1 = time();
		                $audit_time_each = date("Y-m-d h:i:s", $audit_time1);
						
						if($key=="audit_date"){
							$user_list[$row][$key] = date('Y-m-d',strtotime($worksheet->getCell($d.$row )->getFormattedValue()));
						}else if($key=="call_date"){
							$user_list[$row][$key] = date('Y-m-d',strtotime($worksheet->getCell($d.$row )->getFormattedValue()));
						}else if($key=="call_duration"){
							$user_list[$row][$key] = intval(86400 * $worksheet->getCell($d.$row )->getValue());
						}else if($key=="auditor_mwp_id"){
							$user_list[$row]['entry_by'] =  $worksheet->getCell($d.$row )->getValue();
						}
						else if($key=="fusion_id"){
							$fusion_id = $worksheet->getCell($d.$row )->getValue();
							 $qSql = "Select id as agent_id, assigned_to as tl_id, fusion_id, get_process_names(id) as process_name, office_id, (select concat(fname, ' ', lname) from signin tl where tl.id=signin.assigned_to) as tl_name FROM signin where fusion_id = '$fusion_id'";
							
							$tl_agent_ids = $this->Common_model->get_query_row_array($qSql);

							// $sql_qa_name = "select concat(fname, ' ', lname) as auditor_name from signin qa where qa.id='$current_user'";
							// $qa_name = $this->Common_model->get_query_row_array($sql_qa_name);

							$user_list[$row]['agent_id'] 			=  $tl_agent_ids['agent_id'];
							$user_list[$row]['tl_id']    			=  $tl_agent_ids['tl_id'];
							//$user_list[$row]['entry_by']   			=  $current_user;
							//$user_list[$row]['auditor_name']   		=  $qa_name['auditor_name'];
							$user_list[$row]['entry_date']   		=  $audit_time_each;
							$user_list[$row]['audit_start_time']   	=  $audit_start_time;
							

						}
						else{
							$user_list[$row][$key] =  $worksheet->getCell($d.$row )->getValue();
						}
					}	
				}

				// echo"<pre>";
				// print_r($user_list);
				// echo"</pre>";
				 //die();
			
				$this->Qa_philip_model->od_voice_data($user_list);
				redirect('Qa_od/qaod_management_sorting_feedback');
			}
		}
	}

	public function sample_od_voice_download(){
		if(check_logged_in()){ 
			$file_name = base_url()."qa_files/qa_od/sample_od_voice_file.xlsx";
			header("location:".$file_name);	
			exit();
		}
	}

	function import_bioserenity_excel_data(){
		
		$current_user = '';
		$audit_time = time();
		//$audit_start_time = date("Y-m-d h:i:s", $audit_time);
		//print_r($this->input->post());
		 $audit_start_time = $this->input->post('star_time');
		$this->load->library('excel');
		if(isset($_FILES["file"]["name"])){
		if(check_logged_in())
		{
			$current_user = get_user_id(); 
		}
			
			$path = $_FILES["file"]["tmp_name"];
			$object = PHPExcel_IOFactory::load($path);
			$clmarr = array("audit_date","fusion_id","auditor_mwp_id","customer_name","order_number","call_date","audit_type","auditor_type","voc","overall_score","earned_score","possible_score","customerErnd","businessErnd","complianceErnd","customerPsbl","businessPsbl","compliancePsbl","customerTotal","businessTotal","complianceTotal","patient_information","physician","order_information","diagnostic","insurance","order_history","attachment","order_creation","major_errors","cmt1","cmt2","cmt3","cmt4","cmt5","cmt6","cmt7","cmt8","cmt9","cmt10","cmt11","cmt12","cmt13","cmt14","cmt15","cmt16","cmt17","cmt18","cmt19","cmt20","cmt21","cmt22","cmt23","cmt24","cmt25","cmt26","cmt27","cmt28","cmt29","cmt30","cmt31","cmt32","cmt33","cmt34","cmt35","cmt36","cmt37","cmt38","cmt39","cmt40","cmt41","cmt42","cmt43","cmt44","cmt45","cmt46","cmt47","cmt48","cmt49","cmt50","call_summary","feedback");
			
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
				
					foreach($clmarr as $name){
						if($name == $colindex){
							 $dd[$colindex]  = $adjustedColumn;
						}
					}
				}
				
				//$random_row = round(($highestRow * (20/100)));				
				for($row=2; $row<=$highestRow; $row++){
					foreach($dd as $key=>$d){
						$audit_time1 = time();
		                $audit_time_each = date("Y-m-d h:i:s", $audit_time1);
						
						if($key=="audit_date"){
							$user_list[$row][$key] = date('Y-m-d',strtotime($worksheet->getCell($d.$row )->getFormattedValue()));
						}else if($key=="call_date"){
							$user_list[$row][$key] = date('Y-m-d',strtotime($worksheet->getCell($d.$row )->getFormattedValue()));
						}else if($key=="call_duration"){
							$user_list[$row][$key] = intval(86400 * $worksheet->getCell($d.$row )->getValue());
						}else if($key=="auditor_mwp_id"){
							$user_list[$row]['entry_by'] =  $worksheet->getCell($d.$row )->getValue();
						}
						else if($key=="fusion_id"){
							$fusion_id = $worksheet->getCell($d.$row )->getValue();
							 $qSql = "Select id as agent_id, assigned_to as tl_id, fusion_id, get_process_names(id) as process_name, office_id, (select concat(fname, ' ', lname) from signin tl where tl.id=signin.assigned_to) as tl_name FROM signin where fusion_id = '$fusion_id'";
							
							$tl_agent_ids = $this->Common_model->get_query_row_array($qSql);

							// $sql_qa_name = "select concat(fname, ' ', lname) as auditor_name from signin qa where qa.id='$current_user'";
							// $qa_name = $this->Common_model->get_query_row_array($sql_qa_name);

							$user_list[$row]['agent_id'] 			=  $tl_agent_ids['agent_id'];
							$user_list[$row]['tl_id']    			=  $tl_agent_ids['tl_id'];
							//$user_list[$row]['entry_by']   			=  $current_user;
							//$user_list[$row]['auditor_name']   		=  $qa_name['auditor_name'];
							$user_list[$row]['entry_date']   		=  $audit_time_each;
							$user_list[$row]['audit_start_time']   	=  $audit_start_time;
							

						}
						else{
							$user_list[$row][$key] =  $worksheet->getCell($d.$row )->getValue();
						}
					}	
				}

				// echo"<pre>";
				// print_r($user_list);
				// echo"</pre>";
				 //die();
			
				$this->Qa_philip_model->bioserenity_data($user_list);
				redirect('Qa_novasom');
			}
		}
	}
	
	public function sample_bioserenity_download(){
		if(check_logged_in()){ 
			$file_name = base_url()."qa_files/qa_od/sample_bioserenity_file.xlsx";
			header("location:".$file_name);	
			exit();
		}
	}

	function import_rugdoctor_excel_data(){
		
		$current_user = '';
		$audit_time = time();
		//$audit_start_time = date("Y-m-d h:i:s", $audit_time);
		//print_r($this->input->post());
		 $audit_start_time = $this->input->post('star_time');
		$this->load->library('excel');
		if(isset($_FILES["file"]["name"])){
		if(check_logged_in())
		{
			$current_user = get_user_id(); 
		}
			
			$path = $_FILES["file"]["tmp_name"];
			$object = PHPExcel_IOFactory::load($path);
			$clmarr = array("audit_date","fusion_id","auditor_mwp_id","phone","call_duration","customer_name","issue","audit_type","auditor_type","voc","overall_score","point_earned","rdCustomerErnd","rdBusinessErnd","rdComplianceErnd","rdCustomerPsbl","rdBusinessPsbl","rdCompliancePsbl","rdCustomerTotal","rdBusinessTotal","rdComplianceTotal","greeting_caller","greeting_caller_comment","verification_confirm","verification_confirm_comment","verification_request","verification_request_comment","discovery_identity","discovery_identity_comment","discovery_demo","discovery_demo_comment","customer_maintain","customer_maintain_comment","customer_word","customer_word_comment","customer_treat","customer_treat_comment","customer_avoid","customer_avoid_comment","customer_follow","customer_follow_comment","customer_accurate","customer_accurate_comment","skill_demo","skill_demo_comment","resolution_provide","resolution_provide_comment","resolution_accurate","resolution_accurate_comment","resolution_resolve","resolution_resolve_comment","closing_offer","closing_offer_comment","closing_summarize","closing_summarize_comment","closing_educate","closing_educate_comment","closing_thank","closing_thank_comment","call_summary","feedback");
			
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
				
					foreach($clmarr as $name){
						if($name == $colindex){
							 $dd[$colindex]  = $adjustedColumn;
						}
					}
				}
				
				//$random_row = round(($highestRow * (20/100)));				
				for($row=2; $row<=$highestRow; $row++){
					foreach($dd as $key=>$d){
						$audit_time1 = time();
		                $audit_time_each = date("Y-m-d h:i:s", $audit_time1);
						
						if($key=="audit_date"){
							$user_list[$row][$key] = date('Y-m-d',strtotime($worksheet->getCell($d.$row )->getFormattedValue()));
						}else if($key=="call_date"){
							$user_list[$row][$key] = date('Y-m-d',strtotime($worksheet->getCell($d.$row )->getFormattedValue()));
						}else if($key=="call_duration"){
							$user_list[$row][$key] = intval(86400 * $worksheet->getCell($d.$row )->getValue());
						}else if($key=="auditor_mwp_id"){
							$user_list[$row]['entry_by'] =  $worksheet->getCell($d.$row )->getValue();
						}
						else if($key=="fusion_id"){
							$fusion_id = $worksheet->getCell($d.$row )->getValue();
							 $qSql = "Select id as agent_id, assigned_to as tl_id, fusion_id, get_process_names(id) as process_name, office_id, (select concat(fname, ' ', lname) from signin tl where tl.id=signin.assigned_to) as tl_name FROM signin where fusion_id = '$fusion_id'";
							
							$tl_agent_ids = $this->Common_model->get_query_row_array($qSql);

							// $sql_qa_name = "select concat(fname, ' ', lname) as auditor_name from signin qa where qa.id='$current_user'";
							// $qa_name = $this->Common_model->get_query_row_array($sql_qa_name);

							$user_list[$row]['agent_id'] 			=  $tl_agent_ids['agent_id'];
							$user_list[$row]['tl_id']    			=  $tl_agent_ids['tl_id'];
							//$user_list[$row]['entry_by']   			=  $current_user;
							//$user_list[$row]['auditor_name']   		=  $qa_name['auditor_name'];
							$user_list[$row]['entry_date']   		=  $audit_time_each;
							$user_list[$row]['audit_start_time']   	=  $audit_start_time;
							

						}
						else{
							$user_list[$row][$key] =  $worksheet->getCell($d.$row )->getValue();
						}
					}	
				}

				// echo"<pre>";
				// print_r($user_list);
				// echo"</pre>";
				 //die();
			
				$this->Qa_philip_model->rugdoctor_data($user_list);
				redirect('Qa_rugdoctor');
			}
		}
	}

	public function sample_rugdoctor_download(){
		if(check_logged_in()){ 
			$file_name = base_url()."qa_files/qa_rugdoctor/sample_rugdoctor_file.xlsx";
			header("location:".$file_name);	
			exit();
		}
	}

	function import_sentient_jet_excel_data(){
		
		$current_user = '';
		$audit_time = time();
		//$audit_start_time = date("Y-m-d h:i:s", $audit_time);
		//print_r($this->input->post());
		 $audit_start_time = $this->input->post('star_time');
		$this->load->library('excel');
		if(isset($_FILES["file"]["name"])){
		if(check_logged_in())
		{
			$current_user = get_user_id(); 
		}
			
			$path = $_FILES["file"]["tmp_name"];
			$object = PHPExcel_IOFactory::load($path);
			$clmarr = array("audit_date","fusion_id","auditor_mwp_id","phone","call_duration","customer_name","issue","audit_type","auditor_type","voc","overall_score","point_earned","rdCustomerErnd","rdBusinessErnd","rdComplianceErnd","rdCustomerPsbl","rdBusinessPsbl","rdCompliancePsbl","rdCustomerTotal","rdBusinessTotal","rdComplianceTotal","greeting_caller","greeting_caller_comment","verification_confirm","verification_confirm_comment","verification_request","verification_request_comment","discovery_identity","discovery_identity_comment","discovery_demo","discovery_demo_comment","customer_maintain","customer_maintain_comment","customer_word","customer_word_comment","customer_treat","customer_treat_comment","customer_avoid","customer_avoid_comment","customer_follow","customer_follow_comment","customer_accurate","customer_accurate_comment","skill_demo","skill_demo_comment","resolution_provide","resolution_provide_comment","resolution_accurate","resolution_accurate_comment","resolution_resolve","resolution_resolve_comment","closing_offer","closing_offer_comment","closing_summarize","closing_summarize_comment","closing_educate","closing_educate_comment","closing_thank","closing_thank_comment","call_summary","feedback");
			
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
				
					foreach($clmarr as $name){
						if($name == $colindex){
							 $dd[$colindex]  = $adjustedColumn;
						}
					}
				}
				
				//$random_row = round(($highestRow * (20/100)));				
				for($row=2; $row<=$highestRow; $row++){
					foreach($dd as $key=>$d){
						$audit_time1 = time();
		                $audit_time_each = date("Y-m-d h:i:s", $audit_time1);
						
						if($key=="audit_date"){
							$user_list[$row][$key] = date('Y-m-d',strtotime($worksheet->getCell($d.$row )->getFormattedValue()));
						}else if($key=="call_date"){
							$user_list[$row][$key] = date('Y-m-d',strtotime($worksheet->getCell($d.$row )->getFormattedValue()));
						}else if($key=="call_duration"){
							$user_list[$row][$key] = intval(86400 * $worksheet->getCell($d.$row )->getValue());
						}else if($key=="auditor_mwp_id"){
							$user_list[$row]['entry_by'] =  $worksheet->getCell($d.$row )->getValue();
						}
						else if($key=="fusion_id"){
							$fusion_id = $worksheet->getCell($d.$row )->getValue();
							 $qSql = "Select id as agent_id, assigned_to as tl_id, fusion_id, get_process_names(id) as process_name, office_id, (select concat(fname, ' ', lname) from signin tl where tl.id=signin.assigned_to) as tl_name FROM signin where fusion_id = '$fusion_id'";
							
							$tl_agent_ids = $this->Common_model->get_query_row_array($qSql);

							// $sql_qa_name = "select concat(fname, ' ', lname) as auditor_name from signin qa where qa.id='$current_user'";
							// $qa_name = $this->Common_model->get_query_row_array($sql_qa_name);

							$user_list[$row]['agent_id'] 			=  $tl_agent_ids['agent_id'];
							$user_list[$row]['tl_id']    			=  $tl_agent_ids['tl_id'];
							//$user_list[$row]['entry_by']   			=  $current_user;
							//$user_list[$row]['auditor_name']   		=  $qa_name['auditor_name'];
							$user_list[$row]['entry_date']   		=  $audit_time_each;
							$user_list[$row]['audit_start_time']   	=  $audit_start_time;
							

						}
						else{
							$user_list[$row][$key] =  $worksheet->getCell($d.$row )->getValue();
						}
					}	
				}

				// echo"<pre>";
				// print_r($user_list);
				// echo"</pre>";
				 //die();
			
				$this->Qa_philip_model->sentient_jet_data($user_list);
				redirect('Qa_sentient_jet');
			}
		}
	}

	public function sample_sentient_jet_download(){
		if(check_logged_in()){ 
			$file_name = base_url()."qa_files/qa_sentient_jet/sample_sentient_jet_file.xlsx";
			header("location:".$file_name);	
			exit();
		}
	}

	function import_craftjack_cebu_excel_data(){
		
		$current_user = '';
		$audit_time = time();
		//$audit_start_time = date("Y-m-d h:i:s", $audit_time);
		//print_r($this->input->post());
		 $audit_start_time = $this->input->post('star_time');
		$this->load->library('excel');
		if(isset($_FILES["file"]["name"])){
		if(check_logged_in())
		{
			$current_user = get_user_id(); 
		}
			
			$path = $_FILES["file"]["tmp_name"];
			$object = PHPExcel_IOFactory::load($path);
			$clmarr = array("audit_date","fusion_id","auditor_mwp_id","customer","customer_phone","call_date","call_duration","call_type","service_request","factor","analysis","audit_type","auditor_type","voc","pass_fail","possible_score","earned_score","overall_score","did_agent_enthusiastically","did_agent_mention","did_agent_ask","did_agent_understand","did_agent_ask_probing","did_agent_select","did_agent_follow","did_agent_brief_description","did_agent_get_all","did_agent_mention_statement","active_listening","did_agent_sound_conversational","did_agent_use_propertone","did_agent_deadair","was_the_agent_polite","did_agent_ended_call","cmt1","cmt2","cmt3","cmt4","cmt5","cmt6","cmt7","cmt8","cmt9","cmt10","cmt11","cmt12","cmt13","cmt14","cmt15","cmt16","call_summary","feedback");
			
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
				
					foreach($clmarr as $name){
						if($name == $colindex){
							 $dd[$colindex]  = $adjustedColumn;
						}
					}
				}
				
				//$random_row = round(($highestRow * (20/100)));				
				for($row=2; $row<=$highestRow; $row++){
					foreach($dd as $key=>$d){
						$audit_time1 = time();
		                $audit_time_each = date("Y-m-d h:i:s", $audit_time1);
						
						if($key=="audit_date"){
							$user_list[$row][$key] = date('Y-m-d',strtotime($worksheet->getCell($d.$row )->getFormattedValue()));
						}else if($key=="call_date"){
							$user_list[$row][$key] = date('Y-m-d',strtotime($worksheet->getCell($d.$row )->getFormattedValue()));
						}else if($key=="call_duration"){
							$user_list[$row][$key] = intval(86400 * $worksheet->getCell($d.$row )->getValue());
						}else if($key=="auditor_mwp_id"){
							$user_list[$row]['entry_by'] =  $worksheet->getCell($d.$row )->getValue();
						}
						else if($key=="fusion_id"){
							$fusion_id = $worksheet->getCell($d.$row )->getValue();
							 $qSql = "Select id as agent_id, assigned_to as tl_id, fusion_id, get_process_names(id) as process_name, office_id, (select concat(fname, ' ', lname) from signin tl where tl.id=signin.assigned_to) as tl_name FROM signin where fusion_id = '$fusion_id'";
							
							$tl_agent_ids = $this->Common_model->get_query_row_array($qSql);

							// $sql_qa_name = "select concat(fname, ' ', lname) as auditor_name from signin qa where qa.id='$current_user'";
							// $qa_name = $this->Common_model->get_query_row_array($sql_qa_name);

							$user_list[$row]['agent_id'] 			=  $tl_agent_ids['agent_id'];
							$user_list[$row]['tl_id']    			=  $tl_agent_ids['tl_id'];
							//$user_list[$row]['entry_by']   			=  $current_user;
							//$user_list[$row]['auditor_name']   		=  $qa_name['auditor_name'];
							$user_list[$row]['entry_date']   		=  $audit_time_each;
							$user_list[$row]['audit_start_time']   	=  $audit_start_time;
							

						}
						else{
							$user_list[$row][$key] =  $worksheet->getCell($d.$row )->getValue();
						}
					}	
				}

				// echo"<pre>";
				// print_r($user_list);
				// echo"</pre>";
				 //die();
			
				$this->Qa_philip_model->craftjack_cebu_data($user_list);
				redirect('Qa_craftjack');
			}
		}
	}

	public function sample_craftjack_cebu_download(){
		if(check_logged_in()){ 
			$file_name = base_url()."qa_files/craftjack/sample_craftjack_cebu_file.xlsx";
			header("location:".$file_name);	
			exit();
		}
	}

	function import_usda_excel_data(){
		
		$current_user = '';
		$audit_time = time();
		//$audit_start_time = date("Y-m-d h:i:s", $audit_time);
		//print_r($this->input->post());
		 $audit_start_time = $this->input->post('star_time');
		$this->load->library('excel');
		if(isset($_FILES["file"]["name"])){
		if(check_logged_in())
		{
			$current_user = get_user_id(); 
		}
			
			$path = $_FILES["file"]["tmp_name"];
			$object = PHPExcel_IOFactory::load($path);
			$clmarr = array("audit_date","fusion_id","auditor_mwp_id","call_date","call_duration","audit_type","auditor_type","voc","overall_score","earned_score","possible_score","opening","listening","search","fulfillment","closing","attitude","professionalism","call_summary","feedback");
			
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
				
					foreach($clmarr as $name){
						if($name == $colindex){
							 $dd[$colindex]  = $adjustedColumn;
						}
					}
				}
				
				//$random_row = round(($highestRow * (20/100)));				
				for($row=2; $row<=$highestRow; $row++){
					foreach($dd as $key=>$d){
						$audit_time1 = time();
		                $audit_time_each = date("Y-m-d h:i:s", $audit_time1);
						
						if($key=="audit_date"){
							$user_list[$row][$key] = date('Y-m-d',strtotime($worksheet->getCell($d.$row )->getFormattedValue()));
						}else if($key=="call_date"){
							$user_list[$row][$key] = date('Y-m-d',strtotime($worksheet->getCell($d.$row )->getFormattedValue()));
						}else if($key=="call_duration"){
							$user_list[$row][$key] = intval(86400 * $worksheet->getCell($d.$row )->getValue());
						}else if($key=="auditor_mwp_id"){
							$user_list[$row]['entry_by'] =  $worksheet->getCell($d.$row )->getValue();
						}
						else if($key=="fusion_id"){
							$fusion_id = $worksheet->getCell($d.$row )->getValue();
							 $qSql = "Select id as agent_id, assigned_to as tl_id, fusion_id, get_process_names(id) as process_name, office_id, (select concat(fname, ' ', lname) from signin tl where tl.id=signin.assigned_to) as tl_name FROM signin where fusion_id = '$fusion_id'";
							
							$tl_agent_ids = $this->Common_model->get_query_row_array($qSql);

							// $sql_qa_name = "select concat(fname, ' ', lname) as auditor_name from signin qa where qa.id='$current_user'";
							// $qa_name = $this->Common_model->get_query_row_array($sql_qa_name);

							$user_list[$row]['agent_id'] 			=  $tl_agent_ids['agent_id'];
							$user_list[$row]['tl_id']    			=  $tl_agent_ids['tl_id'];
							//$user_list[$row]['entry_by']   			=  $current_user;
							//$user_list[$row]['auditor_name']   		=  $qa_name['auditor_name'];
							$user_list[$row]['entry_date']   		=  $audit_time_each;
							$user_list[$row]['audit_start_time']   	=  $audit_start_time;
							

						}
						else{
							$user_list[$row][$key] =  $worksheet->getCell($d.$row )->getValue();
						}
					}	
				}

				// echo"<pre>";
				// print_r($user_list);
				// echo"</pre>";
				 //die();
			
				$this->Qa_philip_model->usda_data($user_list);
				redirect('Qa_us_da');
			}
		}
	}

	public function sample_usda_download(){
		if(check_logged_in()){ 
			$file_name = base_url()."qa_files/qa_us_da/sample_usda_file.xlsx";
			header("location:".$file_name);	
			exit();
		}
	}

	function import_mba_voice_excel_data(){
		
		$current_user = '';
		$audit_time = time();
		//$audit_start_time = date("Y-m-d h:i:s", $audit_time);
		//print_r($this->input->post());
		 $audit_start_time = $this->input->post('star_time');
		$this->load->library('excel');
		if(isset($_FILES["file"]["name"])){
		if(check_logged_in())
		{
			$current_user = get_user_id(); 
		}
			
			$path = $_FILES["file"]["tmp_name"];
			$object = PHPExcel_IOFactory::load($path);
			$clmarr = array("audit_date","fusion_id","auditor_mwp_id","call_date","audit_type","voc","call_duration","possible_score","earned_score","overall_score","call_type","member_id","mba_queue","file_number","verify_information","interaction_entered_closed","csr_follow","payment_information_handled","call_acording_policy","appropriate_greeting","ask_provider_info","obtain_call_back","csr_meet_expectations","polite_tone","express","active_listening","unexplained_dead_air","hold_transfer_etiquette","demonstrate_control","interrupt","previous_interactions","csr_understanding","probing_questions","recap_call","additional_assistance","xeos_data","aht_goal","offered_help","cmt1","cmt2","cmt3","cmt4","cmt5","cmt6","cmt7","cmt8","cmt9","cmt10","cmt11","cmt12","cmt13","cmt14","cmt15","cmt16","cmt17","cmt18","cmt19","cmt20","cmt21","cmt22","cmt23","cmt24","call_summary","feedback");
			
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
				
					foreach($clmarr as $name){
						if($name == $colindex){
							 $dd[$colindex]  = $adjustedColumn;
						}
					}
				}
				
				//$random_row = round(($highestRow * (20/100)));				
				for($row=2; $row<=$highestRow; $row++){
					foreach($dd as $key=>$d){
						$audit_time1 = time();
		                $audit_time_each = date("Y-m-d h:i:s", $audit_time1);
						
						if($key=="audit_date"){
							$user_list[$row][$key] = date('Y-m-d',strtotime($worksheet->getCell($d.$row )->getFormattedValue()));
						}else if($key=="call_date"){
							$user_list[$row][$key] = date('Y-m-d',strtotime($worksheet->getCell($d.$row )->getFormattedValue()));
						}else if($key=="call_duration"){
							$user_list[$row][$key] = intval(86400 * $worksheet->getCell($d.$row )->getValue());
						}else if($key=="auditor_mwp_id"){
							$user_list[$row]['entry_by'] =  $worksheet->getCell($d.$row )->getValue();
						}
						else if($key=="fusion_id"){
							$fusion_id = $worksheet->getCell($d.$row )->getValue();
							 $qSql = "Select id as agent_id, assigned_to as tl_id, fusion_id, get_process_names(id) as process_name, office_id, (select concat(fname, ' ', lname) from signin tl where tl.id=signin.assigned_to) as tl_name FROM signin where fusion_id = '$fusion_id'";
							
							$tl_agent_ids = $this->Common_model->get_query_row_array($qSql);

							// $sql_qa_name = "select concat(fname, ' ', lname) as auditor_name from signin qa where qa.id='$current_user'";
							// $qa_name = $this->Common_model->get_query_row_array($sql_qa_name);

							$user_list[$row]['agent_id'] 			=  $tl_agent_ids['agent_id'];
							$user_list[$row]['tl_id']    			=  $tl_agent_ids['tl_id'];
							//$user_list[$row]['entry_by']   			=  $current_user;
							//$user_list[$row]['auditor_name']   		=  $qa_name['auditor_name'];
							$user_list[$row]['entry_date']   		=  $audit_time_each;
							$user_list[$row]['audit_start_time']   	=  $audit_start_time;
							

						}
						else{
							$user_list[$row][$key] =  $worksheet->getCell($d.$row )->getValue();
						}
					}	
				}

				// echo"<pre>";
				// print_r($user_list);
				// echo"</pre>";
				 //die();
			
				$this->Qa_philip_model->mba_voice_data($user_list);
				redirect('Qa_mba_voice');
			}
		}
	}

	public function sample_mba_voice_download(){
		if(check_logged_in()){ 
			$file_name = base_url()."qa_files/qa_us_da/sample_mba_voice_file.xlsx";
			header("location:".$file_name);	
			exit();
		}
	}

	function import_k2_claims_excel_data(){
		
		$current_user = '';
		$audit_time = time();
		//$audit_start_time = date("Y-m-d h:i:s", $audit_time);
		//print_r($this->input->post());
		 $audit_start_time = $this->input->post('star_time');
		$this->load->library('excel');
		if(isset($_FILES["file"]["name"])){
		if(check_logged_in())
		{
			$current_user = get_user_id(); 
		}
			
			$path = $_FILES["file"]["tmp_name"];
			$object = PHPExcel_IOFactory::load($path);
			$clmarr = array("audit_date","fusion_id","auditor_mwp_id","call_date","call_id","claim_policy","call_duration","audit_type","auditor_type","voc","overall_score","opening","listening_skill","communication_skill","voice_delivary","closing","FNOL_from","customer_service","process_procedure","call_summary","feedback");
			
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
				
					foreach($clmarr as $name){
						if($name == $colindex){
							 $dd[$colindex]  = $adjustedColumn;
						}
					}
				}
				
				//$random_row = round(($highestRow * (20/100)));				
				for($row=2; $row<=$highestRow; $row++){
					foreach($dd as $key=>$d){
						$audit_time1 = time();
		                $audit_time_each = date("Y-m-d h:i:s", $audit_time1);
						
						if($key=="audit_date"){
							$user_list[$row][$key] = date('Y-m-d',strtotime($worksheet->getCell($d.$row )->getFormattedValue()));
						}else if($key=="call_date"){
							$user_list[$row][$key] = date('Y-m-d',strtotime($worksheet->getCell($d.$row )->getFormattedValue()));
						}else if($key=="call_duration"){
							$user_list[$row][$key] = intval(86400 * $worksheet->getCell($d.$row )->getValue());
						}else if($key=="auditor_mwp_id"){
							$user_list[$row]['entry_by'] =  $worksheet->getCell($d.$row )->getValue();
						}
						else if($key=="fusion_id"){
							$fusion_id = $worksheet->getCell($d.$row )->getValue();
							 $qSql = "Select id as agent_id, assigned_to as tl_id, fusion_id, get_process_names(id) as process_name, office_id, (select concat(fname, ' ', lname) from signin tl where tl.id=signin.assigned_to) as tl_name FROM signin where fusion_id = '$fusion_id'";
							
							$tl_agent_ids = $this->Common_model->get_query_row_array($qSql);

							// $sql_qa_name = "select concat(fname, ' ', lname) as auditor_name from signin qa where qa.id='$current_user'";
							// $qa_name = $this->Common_model->get_query_row_array($sql_qa_name);

							$user_list[$row]['agent_id'] 			=  $tl_agent_ids['agent_id'];
							$user_list[$row]['tl_id']    			=  $tl_agent_ids['tl_id'];
							//$user_list[$row]['entry_by']   			=  $current_user;
							//$user_list[$row]['auditor_name']   		=  $qa_name['auditor_name'];
							$user_list[$row]['entry_date']   		=  $audit_time_each;
							$user_list[$row]['audit_start_time']   	=  $audit_start_time;
							

						}
						else{
							$user_list[$row][$key] =  $worksheet->getCell($d.$row )->getValue();
						}
					}	
				}

				// echo"<pre>";
				// print_r($user_list);
				// echo"</pre>";
				 //die();
			
				$this->Qa_philip_model->qa_k2_claims_data($user_list);
				redirect('Qa_k2_claims');
			}
		}
	}

	public function sample_k2_claims_download(){
		if(check_logged_in()){ 
			$file_name = base_url()."qa_files/qa_k2_claims/sample_k2_claims_file.xlsx";
			header("location:".$file_name);	
			exit();
		}
	}

	function import_clio_excel_data(){
		
		$current_user = '';
		$audit_time = time();
		//$audit_start_time = date("Y-m-d h:i:s", $audit_time);
		//print_r($this->input->post());
		 $audit_start_time = $this->input->post('star_time');
		$this->load->library('excel');
		if(isset($_FILES["file"]["name"])){
		if(check_logged_in())
		{
			$current_user = get_user_id(); 
		}
			
			$path = $_FILES["file"]["tmp_name"];
			$object = PHPExcel_IOFactory::load($path);
			$clmarr = array("audit_date","agent_id","fusion_id","call_date","property","auditor_mwp_id","stat","reference_id","query_type","query_sub_type","total_opportunity","auto_fail","audit_type","auditor_type","voc","in_out","overall_score","possible_score","earned_score","customer_score","business_score","compliance_score","do_csr_adhere","properly_verifies_account_holder","is_authorized_account","obtain_verbal_permission","do_agent_check","do_show_empathy","do_agent_utilize_information","check_list1","do_proper_hold_procedure","do_maintain_positive_interaction","do_ask_covid_question","do_provide_accurate_reminders","do_select_correct_order_status","do_check_cpt_diagnosis","do_update_patient_demographic","do_check_insurance_auth","do_check_demog_prescription","do_check_expire_date_order","do_verify_need_sent_correction","do_make_setup_correct_modality","cmt1","cmt2","cmt3","cmt4","cmt5","cmt6","cmt7","cmt8","cmt9","cmt10","cmt11","cmt12","cmt13","cmt14","cmt15","cmt16","cmt17","cmt18","cmt19","call_summary","feedback","call_duration","call_type","ask_relevant_probing","cmt20","sampling","lob");
			
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
				
					foreach($clmarr as $name){
						if($name == $colindex){
							 $dd[$colindex]  = $adjustedColumn;
						}
					}
				}
				
				//$random_row = round(($highestRow * (20/100)));				
				for($row=2; $row<=$highestRow; $row++){
					foreach($dd as $key=>$d){
						$audit_time1 = time();
		                $audit_time_each = date("Y-m-d h:i:s", $audit_time1);
						
						if($key=="audit_date"){
							$user_list[$row][$key] = date('Y-m-d',strtotime($worksheet->getCell($d.$row )->getFormattedValue()));
						}else if($key=="call_date"){
							$user_list[$row][$key] = date('Y-m-d',strtotime($worksheet->getCell($d.$row )->getFormattedValue()));
						}else if($key=="call_duration"){
							$user_list[$row][$key] = intval(86400 * $worksheet->getCell($d.$row )->getValue());
						}else if($key=="auditor_mwp_id"){
							$user_list[$row]['entry_by'] =  $worksheet->getCell($d.$row )->getValue();
						}
						else if($key=="fusion_id"){
							$fusion_id = $worksheet->getCell($d.$row )->getValue();
							 $qSql = "Select id as agent_id, assigned_to as tl_id, fusion_id, get_process_names(id) as process_name, office_id, (select concat(fname, ' ', lname) from signin tl where tl.id=signin.assigned_to) as tl_name FROM signin where fusion_id = '$fusion_id'";
							
							$tl_agent_ids = $this->Common_model->get_query_row_array($qSql);

							// $sql_qa_name = "select concat(fname, ' ', lname) as auditor_name from signin qa where qa.id='$current_user'";
							// $qa_name = $this->Common_model->get_query_row_array($sql_qa_name);

							$user_list[$row]['agent_id'] 			=  $tl_agent_ids['agent_id'];
							$user_list[$row]['tl_id']    			=  $tl_agent_ids['tl_id'];
							//$user_list[$row]['entry_by']   			=  $current_user;
							//$user_list[$row]['auditor_name']   		=  $qa_name['auditor_name'];
							$user_list[$row]['entry_date']   		=  $audit_time_each;
							$user_list[$row]['audit_start_time']   	=  $audit_start_time;
							

						}
						else{
							$user_list[$row][$key] =  $worksheet->getCell($d.$row )->getValue();
						}
					}	
				}

				// echo"<pre>";
				// print_r($user_list);
				// echo"</pre>";
				 //die();
			
				$this->Qa_philip_model->qa_clio_data($user_list);
				redirect('Qa_clio');
			}
		}
	}

	public function sample_clio_download(){
		if(check_logged_in()){ 
			$file_name = base_url()."qa_files/qa_clio/sample_clio_file.xlsx";
			header("location:".$file_name);	
			exit();
		}
	}

	function import_rpm_form_excel_data(){
		
		$current_user = '';
		$audit_time = time();
		//$audit_start_time = date("Y-m-d h:i:s", $audit_time);
		//print_r($this->input->post());
		 $audit_start_time = $this->input->post('star_time');
		$this->load->library('excel');
		if(isset($_FILES["file"]["name"])){
		if(check_logged_in())
		{
			$current_user = get_user_id(); 
		}
			
			$path = $_FILES["file"]["tmp_name"];
			$object = PHPExcel_IOFactory::load($path);
			$clmarr = array("auditor_name","audit_date","audit_time","fusion_id","auditor_mwp_id","audit_type","auditor_type","voc","caller_title","caller_name","caller_phone","call_type","disposition_type","overall_score","total_score_count","customer_information","voice_delivery","communication_skills","customer_service","disposition","transfer","protocol","call_summary","feedback");
			
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
				
					foreach($clmarr as $name){
						if($name == $colindex){
							 $dd[$colindex]  = $adjustedColumn;
						}
					}
				}
				
				//$random_row = round(($highestRow * (20/100)));				
				for($row=2; $row<=$highestRow; $row++){
					foreach($dd as $key=>$d){
						$audit_time1 = time();
		                $audit_time_each = date("Y-m-d h:i:s", $audit_time1);
						
						if($key=="audit_date"){
							$user_list[$row][$key] = date('Y-m-d',strtotime($worksheet->getCell($d.$row )->getFormattedValue()));
						}else if($key=="call_date"){
							$user_list[$row][$key] = date('Y-m-d',strtotime($worksheet->getCell($d.$row )->getFormattedValue()));
						}else if($key=="call_duration"){
							$user_list[$row][$key] = intval(86400 * $worksheet->getCell($d.$row )->getValue());
						}else if($key=="auditor_mwp_id"){
							$user_list[$row]['entry_by'] =  $worksheet->getCell($d.$row )->getValue();
						}
						else if($key=="fusion_id"){
							$fusion_id = $worksheet->getCell($d.$row )->getValue();
							 $qSql = "Select id as agent_id, assigned_to as tl_id, fusion_id, get_process_names(id) as process_name, office_id, (select concat(fname, ' ', lname) from signin tl where tl.id=signin.assigned_to) as tl_name FROM signin where fusion_id = '$fusion_id'";
							
							$tl_agent_ids = $this->Common_model->get_query_row_array($qSql);

							$sql_qa_name = "select concat(fname, ' ', lname) as auditor_name from signin qa where qa.id='$current_user'";
							$qa_name = $this->Common_model->get_query_row_array($sql_qa_name);

							$user_list[$row]['agent_id'] 			=  $tl_agent_ids['agent_id'];
							//$user_list[$row]['tl_id']    			=  $tl_agent_ids['tl_id'];
							//$user_list[$row]['entry_by']   			=  $current_user;
							$user_list[$row]['auditor_name']   		=  $qa_name['auditor_name'];
							$user_list[$row]['entry_date']   		=  $audit_time_each;
							$user_list[$row]['updated_date']   	=  $audit_start_time;
							

						}
						else{
							$user_list[$row][$key] =  $worksheet->getCell($d.$row )->getValue();
						}
					}	
				}

				// echo"<pre>";
				// print_r($user_list);
				// echo"</pre>";
				 //die();
			
				$this->Qa_philip_model->qa_rpm_form_data($user_list);
				redirect('Qa_RPM_Sentry/rpm');
			}
		}
	}

	public function sample_rpm_form_download(){
		if(check_logged_in()){ 
			$file_name = base_url()."qa_files/qa_rpm/sample_rpm_form_file.xlsx";
			header("location:".$file_name);	
			exit();
		}
	}

	function import_virtuox_excel_data(){
		
		$current_user = '';
		$audit_time = time();
		//$audit_start_time = date("Y-m-d h:i:s", $audit_time);
		//print_r($this->input->post());
		 $audit_start_time = $this->input->post('star_time');
		$this->load->library('excel');
		if(isset($_FILES["file"]["name"])){
		if(check_logged_in())
		{
			$current_user = get_user_id(); 
		}
			
			$path = $_FILES["file"]["tmp_name"];
			$object = PHPExcel_IOFactory::load($path);
			$clmarr = array("audit_date","fusion_id","auditor_mwp_id","call_date","call_duration","recording_id","Issue_type","Issue","audit_type","auditor_type","voc","busi_score","cust_score","comp_score","overall_score","possible_score","earned_score","greetthecustom","confirmthec","askConfirmthe","confirmthecu","listenactively","askthoughtfu","identifyingth","maintainc","wordsa","treatt","followthecor","accuratelycommunicat","provide","accurately","resolvethe","settingc","cmt1","cmt2","cmt3","cmt4","cmt5","cmt6","cmt7","cmt8","cmt9","cmt10","cmt11","cmt12","cmt13","cmt14","cmt15","cmt16","call_summary","feedback");
			
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
				
					foreach($clmarr as $name){
						if($name == $colindex){
							 $dd[$colindex]  = $adjustedColumn;
						}
					}
				}
				
				//$random_row = round(($highestRow * (20/100)));				
				for($row=2; $row<=$highestRow; $row++){
					foreach($dd as $key=>$d){
						$audit_time1 = time();
		                $audit_time_each = date("Y-m-d h:i:s", $audit_time1);
						
						if($key=="audit_date"){
							$user_list[$row][$key] = date('Y-m-d',strtotime($worksheet->getCell($d.$row )->getFormattedValue()));
						}else if($key=="call_date"){
							$user_list[$row][$key] = date('Y-m-d',strtotime($worksheet->getCell($d.$row )->getFormattedValue()));
						}else if($key=="call_duration"){
							$user_list[$row][$key] = intval(86400 * $worksheet->getCell($d.$row )->getValue());
						}else if($key=="auditor_mwp_id"){
							$user_list[$row]['entry_by'] =  $worksheet->getCell($d.$row )->getValue();
						}
						else if($key=="fusion_id"){
							$fusion_id = $worksheet->getCell($d.$row )->getValue();
							 $qSql = "Select id as agent_id, assigned_to as tl_id, fusion_id, get_process_names(id) as process_name, office_id, (select concat(fname, ' ', lname) from signin tl where tl.id=signin.assigned_to) as tl_name FROM signin where fusion_id = '$fusion_id'";
							
							$tl_agent_ids = $this->Common_model->get_query_row_array($qSql);

							$sql_qa_name = "select concat(fname, ' ', lname) as auditor_name from signin qa where qa.id='$current_user'";
							$qa_name = $this->Common_model->get_query_row_array($sql_qa_name);

							$user_list[$row]['agent_id'] 			=  $tl_agent_ids['agent_id'];
							$user_list[$row]['tl_id']    			=  $tl_agent_ids['tl_id'];
							//$user_list[$row]['entry_by']   			=  $current_user;
							//$user_list[$row]['auditor_name']   		=  $qa_name['auditor_name'];
							$user_list[$row]['entry_date']   		=  $audit_time_each;
							$user_list[$row]['audit_start_time']   	=  $audit_start_time;
							

						}
						else{
							$user_list[$row][$key] =  $worksheet->getCell($d.$row )->getValue();
						}
					}	
				}

				// echo"<pre>";
				// print_r($user_list);
				// echo"</pre>";
				 //die();
			
				$this->Qa_philip_model->qa_virtuox_data($user_list);
				redirect('Qa_virtuox');
			}
		}
	}

	public function sample_virtuox_download(){
		if(check_logged_in()){ 
			$file_name = base_url()."qa_files/qa_rpm/sample_virtuox_file.xlsx";
			header("location:".$file_name);	
			exit();
		}
	}

	function import_keeper_excel_data(){
		
		$current_user = '';
		$audit_time = time();
		//$audit_start_time = date("Y-m-d h:i:s", $audit_time);
		//print_r($this->input->post());
		 $audit_start_time = $this->input->post('star_time');
		$this->load->library('excel');
		if(isset($_FILES["file"]["name"])){
		if(check_logged_in())
		{
			$current_user = get_user_id(); 
		}
			
			$path = $_FILES["file"]["tmp_name"];
			$object = PHPExcel_IOFactory::load($path);
			$clmarr = array("audit_date","fusion_id","auditor_mwp_id","call_date","call_duration","recording_id","Issue_type","Issue","audit_type","auditor_type","voc","busi_score","cust_score","comp_score","overall_score","possible_score","earned_score","greetthecustom","confirmthec","askConfirmthe","confirmthecu","listenactively","askthoughtfu","identifyingth","maintainc","wordsa","treatt","followthecor","accuratelycommunicat","provide","accurately","resolvethe","settingc","cmt1","cmt2","cmt3","cmt4","cmt5","cmt6","cmt7","cmt8","cmt9","cmt10","cmt11","cmt12","cmt13","cmt14","cmt15","cmt16","call_summary","feedback");
			
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
				
					foreach($clmarr as $name){
						if($name == $colindex){
							 $dd[$colindex]  = $adjustedColumn;
						}
					}
				}
				
				//$random_row = round(($highestRow * (20/100)));				
				for($row=2; $row<=$highestRow; $row++){
					foreach($dd as $key=>$d){
						$audit_time1 = time();
		                $audit_time_each = date("Y-m-d h:i:s", $audit_time1);
						
						if($key=="audit_date"){
							$user_list[$row][$key] = date('Y-m-d',strtotime($worksheet->getCell($d.$row )->getFormattedValue()));
						}else if($key=="call_date"){
							$user_list[$row][$key] = date('Y-m-d',strtotime($worksheet->getCell($d.$row )->getFormattedValue()));
						}else if($key=="call_duration"){
							$user_list[$row][$key] = intval(86400 * $worksheet->getCell($d.$row )->getValue());
						}else if($key=="auditor_mwp_id"){
							$user_list[$row]['entry_by'] =  $worksheet->getCell($d.$row )->getValue();
						}
						else if($key=="fusion_id"){
							$fusion_id = $worksheet->getCell($d.$row )->getValue();
							 $qSql = "Select id as agent_id, assigned_to as tl_id, fusion_id, get_process_names(id) as process_name, office_id, (select concat(fname, ' ', lname) from signin tl where tl.id=signin.assigned_to) as tl_name FROM signin where fusion_id = '$fusion_id'";
							
							$tl_agent_ids = $this->Common_model->get_query_row_array($qSql);

							$sql_qa_name = "select concat(fname, ' ', lname) as auditor_name from signin qa where qa.id='$current_user'";
							$qa_name = $this->Common_model->get_query_row_array($sql_qa_name);

							$user_list[$row]['agent_id'] 			=  $tl_agent_ids['agent_id'];
							$user_list[$row]['tl_id']    			=  $tl_agent_ids['tl_id'];
							//$user_list[$row]['entry_by']   			=  $current_user;
							//$user_list[$row]['auditor_name']   		=  $qa_name['auditor_name'];
							$user_list[$row]['entry_date']   		=  $audit_time_each;
							$user_list[$row]['audit_start_time']   	=  $audit_start_time;
							

						}
						else{
							$user_list[$row][$key] =  $worksheet->getCell($d.$row )->getValue();
						}
					}	
				}

				// echo"<pre>";
				// print_r($user_list);
				// echo"</pre>";
				 //die();
			
				$this->Qa_philip_model->qa_keeper_data($user_list);
				redirect('Qa_keeper');
			}
		}
	}

	public function sample_keeper_download(){
		if(check_logged_in()){ 
			$file_name = base_url()."qa_files/qa_rpm/sample_keeper_file.xlsx";
			header("location:".$file_name);	
			exit();
		}
	}

	function import_alpha_excel_data(){
		
		$current_user = '';
		$audit_time = time();
		//$audit_start_time = date("Y-m-d h:i:s", $audit_time);
		//print_r($this->input->post());
		 $audit_start_time = $this->input->post('star_time');
		$this->load->library('excel');
		if(isset($_FILES["file"]["name"])){
		if(check_logged_in())
		{
			$current_user = get_user_id(); 
		}
			
			$path = $_FILES["file"]["tmp_name"];
			$object = PHPExcel_IOFactory::load($path);
			$clmarr = array("audit_date","fusion_id","auditor_mwp_id","call_date","call_duration","recording","TPV","LOB","Issue","audit_type","auditor_type","voc","busi_score","cust_score","comp_score","overall_score","possible_score","earned_score","openingCall","enthusiastically","ageBrandName","verificationProcess","custInformation","authorizedPerson","interactCust","skillProbTelephoneCallerRapport","customerwithCare","alphaGasElec","resolutionCall","accomplishmentsConversation","policiesProcedures","dispositionedProperly","agentEndedCall","statementOvercome","CustomerConcern","PreventCancellation","agentAbleConsent","understandsSignals","appropriateQuestions","relevantFeatures","customerIsEighteen","agentGivingCall","followedCorrectScript","captureUSrep","AgentREPID","agentCRM","agentCapturedInfo","agentCapturedAddress","agentCorrectPhone","agentCorrectUtility","agentCorrectFirstLastName","agentCorrectAccountNumber","agentCapturedCorrectLanguage","customerUnderstandsTPV","agentAskComplete","agentCorrectCallSource","cmt1","cmt2","cmt3","cmt4","cmt5","cmt6","cmt7","cmt8","cmt9","cmt10","cmt11","cmt12","cmt13","cmt14","cmt15","cmt16","cmt17","cmt18","cmt19","cmt20","cmt21","cmt22","cmt23","cmt24","cmt25","cmt26","cmt27","cmt28","cmt29","cmt30","cmt31","cmt32","cmt33","cmt34","cmt35","cmt36","cmt37","cmt38","call_summary","feedback");
			
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
				
					foreach($clmarr as $name){
						if($name == $colindex){
							 $dd[$colindex]  = $adjustedColumn;
						}
					}
				}
				
				//$random_row = round(($highestRow * (20/100)));				
				for($row=2; $row<=$highestRow; $row++){
					foreach($dd as $key=>$d){
						$audit_time1 = time();
		                $audit_time_each = date("Y-m-d h:i:s", $audit_time1);
						
						if($key=="audit_date"){
							$user_list[$row][$key] = date('Y-m-d',strtotime($worksheet->getCell($d.$row )->getFormattedValue()));
						}else if($key=="call_date"){
							$user_list[$row][$key] = date('Y-m-d',strtotime($worksheet->getCell($d.$row )->getFormattedValue()));
						}else if($key=="call_duration"){
							$user_list[$row][$key] = intval(86400 * $worksheet->getCell($d.$row )->getValue());
						}else if($key=="auditor_mwp_id"){
							$user_list[$row]['entry_by'] =  $worksheet->getCell($d.$row )->getValue();
						}
						else if($key=="fusion_id"){
							$fusion_id = $worksheet->getCell($d.$row )->getValue();
							 $qSql = "Select id as agent_id, assigned_to as tl_id, fusion_id, get_process_names(id) as process_name, office_id, (select concat(fname, ' ', lname) from signin tl where tl.id=signin.assigned_to) as tl_name FROM signin where fusion_id = '$fusion_id'";
							
							$tl_agent_ids = $this->Common_model->get_query_row_array($qSql);

							$sql_qa_name = "select concat(fname, ' ', lname) as auditor_name from signin qa where qa.id='$current_user'";
							$qa_name = $this->Common_model->get_query_row_array($sql_qa_name);

							$user_list[$row]['agent_id'] 			=  $tl_agent_ids['agent_id'];
							$user_list[$row]['tl_id']    			=  $tl_agent_ids['tl_id'];
							//$user_list[$row]['entry_by']   			=  $current_user;
							//$user_list[$row]['auditor_name']   		=  $qa_name['auditor_name'];
							$user_list[$row]['entry_date']   		=  $audit_time_each;
							$user_list[$row]['audit_start_time']   	=  $audit_start_time;
							

						}
						else{
							$user_list[$row][$key] =  $worksheet->getCell($d.$row )->getValue();
						}
					}	
				}

				// echo"<pre>";
				// print_r($user_list);
				// echo"</pre>";
				 //die();
			
				$this->Qa_philip_model->qa_alpha_data($user_list);
				redirect('Qa_alpha');
			}
		}
	}

	public function sample_alpha_download(){
		if(check_logged_in()){ 
			$file_name = base_url()."qa_files/qa_rpm/sample_alpha_file.xlsx";
			header("location:".$file_name);	
			exit();
		}
	}

	function import_hcco_excel_data(){
		
		$current_user = '';
		$audit_time = time();
		//$audit_start_time = date("Y-m-d h:i:s", $audit_time);
		//print_r($this->input->post());
		 $audit_start_time = $this->input->post('star_time');
		$this->load->library('excel');
		if(isset($_FILES["file"]["name"])){
		if(check_logged_in())
		{
			$current_user = get_user_id(); 
		}
			
			$path = $_FILES["file"]["tmp_name"];
			$object = PHPExcel_IOFactory::load($path);
			$clmarr = array("audit_date","call_time","fusion_id","auditor_mwp_id","call_date","call_duration","consumer1","consumer2","consumer3","original_sr_id","new_sr_id1","new_sr_id2","ext_no","call_type","can_automated","audit_type","auditor_type","voc","call_pass_fail","overall_score","Introduction","Business_expectations","Solution","Location_email","Proper_presentation","Customer_expectations","Cross_sell","Correct_CTT","Branding","Transfer","prob","educate","professionalism","account_accuracy","recorded_line","acknowledgement","stella_survey","cmt1","cmt2","cmt3","cmt4","cmt5","cmt6","cmt7","cmt8","cmt9","cmt10","cmt11","cmt12","cmt13","cmt14","cmt15","cmt16","cmt17","call_summary","feedback","compliancescore","customerscore","businessscore","compliancescoreable","customerscoreable","businessscoreable","compliance_score_percent","customer_score_percent","business_score_percent","fd_id","note");
			
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
				
					foreach($clmarr as $name){
						if($name == $colindex){
							 $dd[$colindex]  = $adjustedColumn;
						}
					}
				}
				
				//$random_row = round(($highestRow * (20/100)));				
				for($row=2; $row<=$highestRow; $row++){
					foreach($dd as $key=>$d){
						$audit_time1 = time();
		                $audit_time_each = date("Y-m-d h:i:s", $audit_time1);
						
						if($key=="audit_date"){
							$user_list[$row][$key] = date('Y-m-d',strtotime($worksheet->getCell($d.$row )->getFormattedValue()));
						}else if($key=="call_date"){
							$user_list[$row][$key] = date('Y-m-d',strtotime($worksheet->getCell($d.$row )->getFormattedValue()));
						}else if($key=="call_duration"){
							$user_list[$row][$key] = intval(86400 * $worksheet->getCell($d.$row )->getValue());
						}else if($key=="auditor_mwp_id"){
							$user_list[$row]['entry_by'] =  $worksheet->getCell($d.$row )->getValue();
						}
						else if($key=="fusion_id"){
							$fusion_id = $worksheet->getCell($d.$row )->getValue();
							 $qSql = "Select id as agent_id, assigned_to as tl_id, fusion_id, get_process_names(id) as process_name, office_id, (select concat(fname, ' ', lname) from signin tl where tl.id=signin.assigned_to) as tl_name FROM signin where fusion_id = '$fusion_id'";
							
							$tl_agent_ids = $this->Common_model->get_query_row_array($qSql);

							$sql_qa_name = "select concat(fname, ' ', lname) as auditor_name from signin qa where qa.id='$current_user'";
							$qa_name = $this->Common_model->get_query_row_array($sql_qa_name);

							$user_list[$row]['agent_id'] 			=  $tl_agent_ids['agent_id'];
							$user_list[$row]['tl_id']    			=  $tl_agent_ids['tl_id'];
							//$user_list[$row]['entry_by']   			=  $current_user;
							//$user_list[$row]['auditor_name']   		=  $qa_name['auditor_name'];
							$user_list[$row]['entry_date']   		=  $audit_time_each;
							$user_list[$row]['audit_start_time']   	=  $audit_start_time;
							

						}
						else{
							$user_list[$row][$key] =  $worksheet->getCell($d.$row )->getValue();
						}
					}	
				}

				// echo"<pre>";
				// print_r($user_list);
				// echo"</pre>";
				 //die();
			
				$this->Qa_philip_model->qa_hcco_data($user_list);
				redirect('Qa_homeadvisor/qa_hcco_feedback');
			}
		}
	}

	public function sample_hcco_download(){
		if(check_logged_in()){ 
			$file_name = base_url()."qa_files/qa_homeadvisor/sample_hcco_file.xlsx";
			header("location:".$file_name);	
			exit();
		}
	}

	function import_hcco_flex_excel_data(){
		
		$current_user = '';
		$audit_time = time();
		//$audit_start_time = date("Y-m-d h:i:s", $audit_time);
		//print_r($this->input->post());
		 $audit_start_time = $this->input->post('star_time');
		$this->load->library('excel');
		if(isset($_FILES["file"]["name"])){
		if(check_logged_in())
		{
			$current_user = get_user_id(); 
		}
			
			$path = $_FILES["file"]["tmp_name"];
			$object = PHPExcel_IOFactory::load($path);
			$clmarr = array("audit_date","fusion_id","auditor_mwp_id","call_date","call_duration","sr_number","flex_lob","audit_type","auditor_type","voc","overall_score","earned_score","possible_score","include_ha_branding","correct_contact_information","consumer_expect_call","call_introduction_recorded","mmr_submitted","filter_call_disposition","appropiate_CTT_consumer","call_purposr","cross_cell_site","educate_HA_work","details_ensure_accuracy","credit_call_appropiately","credit_ticket_information","cross_cell_project","credit_HA_work","credit_call_purpose","cmt1","cmt2","cmt3","cmt4","cmt5","cmt6","cmt7","cmt8","cmt9","cmt10","cmt11","cmt12","cmt13","cmt14","cmt15","cmt16","compliancescore","customerscore","businessscore","compliancescoreable","customerscoreable","businessscoreable","compliance_score_percent","customer_score_percent","business_score_percent","call_summary","feedback");
			
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
				
					foreach($clmarr as $name){
						if($name == $colindex){
							 $dd[$colindex]  = $adjustedColumn;
						}
					}
				}
				
				//$random_row = round(($highestRow * (20/100)));				
				for($row=2; $row<=$highestRow; $row++){
					foreach($dd as $key=>$d){
						$audit_time1 = time();
		                $audit_time_each = date("Y-m-d h:i:s", $audit_time1);
						
						if($key=="audit_date"){
							$user_list[$row][$key] = date('Y-m-d',strtotime($worksheet->getCell($d.$row )->getFormattedValue()));
						}else if($key=="call_date"){
							$user_list[$row][$key] = date('Y-m-d',strtotime($worksheet->getCell($d.$row )->getFormattedValue()));
						}else if($key=="call_duration"){
							$user_list[$row][$key] = intval(86400 * $worksheet->getCell($d.$row )->getValue());
						}else if($key=="auditor_mwp_id"){
							$user_list[$row]['entry_by'] =  $worksheet->getCell($d.$row )->getValue();
						}
						else if($key=="fusion_id"){
							$fusion_id = $worksheet->getCell($d.$row )->getValue();
							 $qSql = "Select id as agent_id, assigned_to as tl_id, fusion_id, get_process_names(id) as process_name, office_id, (select concat(fname, ' ', lname) from signin tl where tl.id=signin.assigned_to) as tl_name FROM signin where fusion_id = '$fusion_id'";
							
							$tl_agent_ids = $this->Common_model->get_query_row_array($qSql);

							$sql_qa_name = "select concat(fname, ' ', lname) as auditor_name from signin qa where qa.id='$current_user'";
							$qa_name = $this->Common_model->get_query_row_array($sql_qa_name);

							$user_list[$row]['agent_id'] 			=  $tl_agent_ids['agent_id'];
							$user_list[$row]['tl_id']    			=  $tl_agent_ids['tl_id'];
							//$user_list[$row]['entry_by']   			=  $current_user;
							//$user_list[$row]['auditor_name']   		=  $qa_name['auditor_name'];
							$user_list[$row]['entry_date']   		=  $audit_time_each;
							$user_list[$row]['audit_start_time']   	=  $audit_start_time;
							

						}
						else{
							$user_list[$row][$key] =  $worksheet->getCell($d.$row )->getValue();
						}
					}	
				}

				// echo"<pre>";
				// print_r($user_list);
				// echo"</pre>";
				 //die();
			
				$this->Qa_philip_model->qa_hcco_flex_data($user_list);
				redirect('Qa_homeadvisor/qa_hcco_feedback');
			}
		}
	}

	public function sample_hcco_flex_download(){
		if(check_logged_in()){ 
			$file_name = base_url()."qa_files/qa_homeadvisor/sample_hcco_flex_file.xlsx";
			header("location:".$file_name);	
			exit();
		}
	}

	function import_hcci_excel_data(){
		
		$current_user = '';
		$audit_time = time();
		//$audit_start_time = date("Y-m-d h:i:s", $audit_time);
		//print_r($this->input->post());
		 $audit_start_time = $this->input->post('star_time');
		$this->load->library('excel');
		if(isset($_FILES["file"]["name"])){
		if(check_logged_in())
		{
			$current_user = get_user_id(); 
		}
			
			$path = $_FILES["file"]["tmp_name"];
			$object = PHPExcel_IOFactory::load($path);
			$clmarr = array("audit_date","fusion_id","auditor_mwp_id","call_date","call_duration","sr_no","consumer_no","call_file","audit_type","auditor_type","voc","overall_score","intorductionIncludeCoName","overcomeAllHomeowner","keptCallSimpleBrief","homeOwnerRequestSubmit","submitAllSRinfo","homeAdvisorTerms","homeAdvisorPertners","noteBETTI","crossSellOfferd","OfferContactInfo","compliancescore","customerscore","businessscore","compliancescoreable","customerscoreable","businessscoreable","compliance_score_percent","customer_score_percent","business_score_percent","call_summary","feedback");
			
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
				
					foreach($clmarr as $name){
						if($name == $colindex){
							 $dd[$colindex]  = $adjustedColumn;
						}
					}
				}
				
				//$random_row = round(($highestRow * (20/100)));				
				for($row=2; $row<=$highestRow; $row++){
					foreach($dd as $key=>$d){
						$audit_time1 = time();
		                $audit_time_each = date("Y-m-d h:i:s", $audit_time1);
						
						if($key=="audit_date"){
							$user_list[$row][$key] = date('Y-m-d',strtotime($worksheet->getCell($d.$row )->getFormattedValue()));
						}else if($key=="call_date"){
							$user_list[$row][$key] = date('Y-m-d',strtotime($worksheet->getCell($d.$row )->getFormattedValue()));
						}else if($key=="call_duration"){
							$user_list[$row][$key] = intval(86400 * $worksheet->getCell($d.$row )->getValue());
						}else if($key=="auditor_mwp_id"){
							$user_list[$row]['entry_by'] =  $worksheet->getCell($d.$row )->getValue();
						}
						else if($key=="fusion_id"){
							$fusion_id = $worksheet->getCell($d.$row )->getValue();
							 $qSql = "Select id as agent_id, assigned_to as tl_id, fusion_id, get_process_names(id) as process_name, office_id, (select concat(fname, ' ', lname) from signin tl where tl.id=signin.assigned_to) as tl_name FROM signin where fusion_id = '$fusion_id'";
							
							$tl_agent_ids = $this->Common_model->get_query_row_array($qSql);

							$sql_qa_name = "select concat(fname, ' ', lname) as auditor_name from signin qa where qa.id='$current_user'";
							$qa_name = $this->Common_model->get_query_row_array($sql_qa_name);

							$user_list[$row]['agent_id'] 			=  $tl_agent_ids['agent_id'];
							$user_list[$row]['tl_id']    			=  $tl_agent_ids['tl_id'];
							//$user_list[$row]['entry_by']   			=  $current_user;
							//$user_list[$row]['auditor_name']   		=  $qa_name['auditor_name'];
							$user_list[$row]['entry_date']   		=  $audit_time_each;
							//$user_list[$row]['audit_start_time']   	=  $audit_start_time;
							

						}
						else{
							$user_list[$row][$key] =  $worksheet->getCell($d.$row )->getValue();
						}
					}	
				}

				// echo"<pre>";
				// print_r($user_list);
				// echo"</pre>";
				 //die();
			
				$this->Qa_philip_model->qa_hcci_data($user_list);
				redirect('Qa_homeadvisor/hcci');
			}
		}
	}

	public function sample_hcci_download(){
		if(check_logged_in()){ 
			$file_name = base_url()."qa_files/qa_homeadvisor/sample_hcci_file.xlsx";
			header("location:".$file_name);	
			exit();
		}
	}

	function import_hcci_cx_excel_data(){
		
		$current_user = '';
		$audit_time = time();
		//$audit_start_time = date("Y-m-d h:i:s", $audit_time);
		//print_r($this->input->post());
		 $audit_start_time = $this->input->post('star_time');
		$this->load->library('excel');
		if(isset($_FILES["file"]["name"])){
		if(check_logged_in())
		{
			$current_user = get_user_id(); 
		}
			
			$path = $_FILES["file"]["tmp_name"];
			$object = PHPExcel_IOFactory::load($path);
			$clmarr = array("audit_date","fusion_id","auditor_mwp_id","call_date","call_duration","sr_no","consumer_no","call_file","call_scenario","audit_type","auditor_type","voc","overall_score","HCCI_introduction","throughout_the_call","Use_RRA","word_choices","felt_found","customer_needs","issues_presented","next_steps","now_acronyms","when_required","brand_the_call","communicated_to_customer","out_of_policy","action_in_Dash","SR_in_BETTI","SR_question","Clear_Insults","CX_Agents","main_issue","tone_of_Voice","Dead_Air","option_available","compliancescore","customerscore","businessscore","compliancescoreable","customerscoreable","businessscoreable","compliance_score_percent","customer_score_percent","business_score_percent","call_summary","feedback");
			
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
				
					foreach($clmarr as $name){
						if($name == $colindex){
							 $dd[$colindex]  = $adjustedColumn;
						}
					}
				}
				
				//$random_row = round(($highestRow * (20/100)));				
				for($row=2; $row<=$highestRow; $row++){
					foreach($dd as $key=>$d){
						$audit_time1 = time();
		                $audit_time_each = date("Y-m-d h:i:s", $audit_time1);
						
						if($key=="audit_date"){
							$user_list[$row][$key] = date('Y-m-d',strtotime($worksheet->getCell($d.$row )->getFormattedValue()));
						}else if($key=="call_date"){
							$user_list[$row][$key] = date('Y-m-d',strtotime($worksheet->getCell($d.$row )->getFormattedValue()));
						}else if($key=="call_duration"){
							$user_list[$row][$key] = intval(86400 * $worksheet->getCell($d.$row )->getValue());
						}else if($key=="auditor_mwp_id"){
							$user_list[$row]['entry_by'] =  $worksheet->getCell($d.$row )->getValue();
						}
						else if($key=="fusion_id"){
							$fusion_id = $worksheet->getCell($d.$row )->getValue();
							 $qSql = "Select id as agent_id, assigned_to as tl_id, fusion_id, get_process_names(id) as process_name, office_id, (select concat(fname, ' ', lname) from signin tl where tl.id=signin.assigned_to) as tl_name FROM signin where fusion_id = '$fusion_id'";
							
							$tl_agent_ids = $this->Common_model->get_query_row_array($qSql);

							$sql_qa_name = "select concat(fname, ' ', lname) as auditor_name from signin qa where qa.id='$current_user'";
							$qa_name = $this->Common_model->get_query_row_array($sql_qa_name);

							$user_list[$row]['agent_id'] 			=  $tl_agent_ids['agent_id'];
							$user_list[$row]['tl_id']    			=  $tl_agent_ids['tl_id'];
							//$user_list[$row]['entry_by']   			=  $current_user;
							//$user_list[$row]['auditor_name']   		=  $qa_name['auditor_name'];
							$user_list[$row]['entry_date']   		=  $audit_time_each;
							//$user_list[$row]['audit_start_time']   	=  $audit_start_time;
							

						}
						else{
							$user_list[$row][$key] =  $worksheet->getCell($d.$row )->getValue();
						}
					}	
				}

				// echo"<pre>";
				// print_r($user_list);
				// echo"</pre>";
				 //die();
			
				$this->Qa_philip_model->qa_hcci_cx_data($user_list);
				redirect('Qa_homeadvisor/hcci');
			}
		}
	}

	public function sample_hcci_cx_download(){
		if(check_logged_in()){ 
			$file_name = base_url()."qa_files/qa_homeadvisor/sample_hcci_cx_file.xlsx";
			header("location:".$file_name);	
			exit();
		}
	}
}
?>