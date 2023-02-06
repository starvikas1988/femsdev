<?php 

 class Qa_randamiser extends CI_Controller{
				
	public function __construct(){
		parent::__construct();
		$this->load->library('excel');
		$this->load->model('user_model');
		$this->load->model('Common_model');
		
		$this->load->model('Qa_randamiser_model');
		
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
			if($client_id == 288 &&  $pro_id == 614){
				$clmarr = array("recording_track_id","sap_id_extension","call_date","aht","fusion_id");
			}
			if($client_id == 202 &&  $pro_id == 411){
				$clmarr = array("offer_id","contact_date","aht","fusion_id");
			}
			
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
						
					
						if($key=="call_date"){
							$user_list[$row][$key] = date('Y-m-d H:i:s',strtotime($worksheet->getCell($d.$row )->getFormattedValue()));
						}
						else if($key=="contact_date"){
							$user_list[$row][$key] = date('Y-m-d H:i:s',strtotime($worksheet->getCell($d.$row )->getFormattedValue()));
						}
						else if($key=="aht"){
							$user_list[$row][$key] = date('H:i:s',strtotime($worksheet->getCell($d.$row )->getFormattedValue()));
						}
						else{
							$user_list[$row][$key] = $worksheet->getCell($d.$row )->getValue();
						}
					}	
				}
				
				 //echo "<pre>"; print_r($user_list); echo "</pre>";
				 $client_id = $this->input->post('client_id');
				 $pro_id = $this->input->post('pro_id');
				 if($client_id == 288 &&  $pro_id == 614){
				
					$this->Qa_randamiser_model->bsnl_insert_excel($user_list);
					redirect('qa_randamiser/data_upload_freshdesk/'.$client_id.'/'.$pro_id);
				 }
				 if($client_id == 202 &&  $pro_id == 411){
					$table_name = "qa_randamiser_indiamart_data";
					$this->Qa_randamiser_model->insert_excel_upload($table_name,$user_list);
					redirect('qa_randamiser/data_upload_freshdesk/'.$client_id.'/'.$pro_id);
				 }
				//redirect('qa_randamiser/data_upload_freshdesk/'.$client_id.'/'.$pro_id);
			}
		}
	}
	
	
	
	

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////	
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////	
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////	

/*******************************************************************/
/*                        UPLOAD DATA                              */
/*******************************************************************/
	
	public function sample_cdr_download(){ /*-- For BSNL --*/
		if(check_logged_in()){ 
			$file_name = base_url()."course_uploads/randamiser/cdr_updated_file.xlsx";
			header("location:".$file_name);	
			exit();
		}
	}
	
	
	
	public function data_upload_freshdesk(){ /*-- For BSNL--*/
		if(check_logged_in()){
			$current_user = get_user_id(); 
			$user_office = get_user_office_id(); 
			$data["aside_template"] = "qa_randamiser/aside.php";
			$data["content_template"] = "qa_randamiser/randamiser/data_cdr_upload_freshdesk.php";
			$data["content_js"] = "qa_randamiser_js.php";
			
			$data['client_id'] = $client_id = $this->uri->segment(3);
			$data['pro_id'] = $pro_id = $this->uri->segment(4);
			
			if($client_id == 288 && $pro_id== 614){
				$rand_table = "qa_randamiser_bsnl_data";
			}
			if($client_id == 202 && $pro_id== 411){
				$rand_table = "qa_randamiser_indiamart_data";
			}
			
			$qSql = "Select count(*) as count, date(upload_date) as uplDate from $rand_table group by date(upload_date)";
			$data["sampling"] = $this->Common_model->get_query_result_array($qSql);
			
			$this->load->view("dashboard",$data);
		}
	}
	
	
	
/*******************************************************************/
/*                      COMPUTE SAMPLING                           */
/*******************************************************************/
	public function data_randamise_compute_freshdesk(){ /*-- For BSNL --*/
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
			$data["content_js"] = "qa_randamiser_js.php";
			
			
			
			
		/////////////// Filter Part Start //////////////
			$loc_sql="Select * from office_location where is_active=1";
			$data["location"]=$this->Common_model->get_query_result_array($loc_sql);
			
			$qa_sql="Select id, fusion_id, office_id, concat(fname, ' ', lname) as name from signin where status=1 and dept_id=5 order by name";
			$data["qa"]=$this->Common_model->get_query_result_array($qa_sql);
	
			
			$agnt_sql="Select RCD.fusion_id, concat(S.fname, ' ', S.lname) as agnt_name, S.xpoid, S.fusion_id, S.office_id from $table RCD Left Join signin S On RCD.fusion_id=S.fusion_id where S.status=1 and S.dept_id=6 $pro_cond group by agnt_name";
			$data["agent"]=$this->Common_model->get_query_result_array($agnt_sql);
			
			//print_r($data["agent"]);
			
			if($table == 'qa_randamiser_bsnl_data'){
				//$queue_name_sql="Select call_queue from $table where call_queue is not Null and call_queue!='' and compute_status=1 group by call_queue";
				//$data["queue_name"]=$this->Common_model->get_query_result_array($queue_name_sql);
			}

			
			$off_cond="";
			$agent_cond="";
			$call_queue_cond="";
			$aht_cond="";
			
			$from_date="";
			$fusion_id="";
			$call_queue="";
			$aht="";
		/////////////// Filter Part End //////////////
			
			$sampling_data = array();
			if($this->input->post('submit')=='Submit')
			{
				$from_date = $this->input->post('from_date');
				$fusion_id = $this->input->post('fusion_id');
				$aht = $this->input->post('call_duration');
				$client_id = $this->input->post('client_id');
				$pro_id = $this->input->post('pro_id');
			//////////////////////// Add Compute Logic /////////////////////////
				$log=get_logs();
			
				if(!empty($fusion_id)) $agent_id_sel = implode(',',$fusion_id);
				else $agent_id_sel = "";				

				if(!empty($aht)) $aht_sel = implode(',',$aht);
				else $aht_sel = "";
				
				$ext_cond ="";
				$sel_field="";
				
				//BSNL		
				if($client_id ==288 && $pro_id==614){
					$_field_array = array(
						"from_date" => $from_date,
						"office_id" => $office_id,
						"agent_id" => $agent_id_sel,
						"aht" => $aht_sel,
						"log" => $log
					);	
					$comp_table = "qa_randamiser_compute_logic";
					$rand_table = "qa_randamiser_bsnl_data";
					$sel_field = "RCD.fusion_id, RCD.aht,
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
					$sel_field = "RCD.fusion_id, RCD.aht,
									TIME_TO_SEC(aht) as aht_sec,
									RCD.compute_status, RCD.audit_status, 
									S.xpoid, S.fusion_id, DATEDIFF(CURDATE(), S.doj) as tenure";
				}
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
				if($aht!=""){
					$aht=implode(" OR ", $aht);
					$aht_cond .=" and ($aht)";
				}
			///////// SQL Condition End ////////////
			
				
				
				$randSql="Select $sel_field
				from $rand_table RCD Left Join signin S On RCD.fusion_id=S.fusion_id
				where S.status=1 $pro_cond and RCD.compute_status=1 and RCD.audit_status=0
				and date(RCD.upload_date)='$from_date' $agent_cond $ext_cond 
				having 1 $aht_cond";
				
				$sampling_data = $this->Common_model->get_query_result_array($randSql);
				
				//print_r($sampling_data); exit;
				foreach($sampling_data as $row){
					$fusion_id=$row["fusion_id"];
					$this->db->query("Update $rand_table set compute_status=2, compute_by='$current_user' where fusion_id='$fusion_id' and date(upload_date)='$from_date'");
				}
				
				$url = "qa_randamiser/data_distribute_freshdesk/".$client_id."/".$pro_id;
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
			$data["content_template"] = "qa_randamiser/randamiser/data_distribute_freshdesk.php";
			$data["content_js"] = "qa_randamiser_js.php";
			
			
			
			$from_date="";
			$cond="";
			$randCond="";
			$rand_tbl="";
			
			
			
			//$rand_tbl='qa_randamiser_bsnl_data';
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
					
					$sel_distribute_fields="SA.offer_id as recording_track_id";
				}
				if($client_id==288 && $pro_id==614){
					$rand_tbl='qa_randamiser_bsnl_data';
					$sel_fields = "RCD.id as rand_id, RCD.fusion_id, RCD.aht, RCD.compute_status,RCD.call_date, RCD.audit_status, date(RCD.upload_date) as upl_date,RCD.recording_track_id, S.fusion_id, S.id as agent_id";
					$sel_distribute_fields="SA.recording_track_id";
				}
				
				if(get_global_access()==1){
					//$cond="";
					$cond .=" and S.status IN (1,4)";
					$randCond .="";
				}else{
					//$cond .=" and S.status IN (1,4) and assigned_qa=$current_user";
					$cond .=" and S.status IN (1,4)";
					$randCond .="and SA.assigned_qa_id=$current_user";
				}
				
				/* LIMIT $qa_target */
				
				$rand_sql="Select $sel_fields,
					(select audit_target from qa_agent_categorisation a where a.agent_id=S.id) as audit_target
					FROM $rand_tbl RCD Left Join signin S On RCD.fusion_id=S.fusion_id
					where RCD.compute_status=2 and RCD.audit_status=0 and date(RCD.upload_date)='$from_date' $cond ORDER BY RAND()";
				$random_data=$this->Common_model->get_query_result_array($rand_sql);
				
				$agent_id = array();
				foreach($random_data as $sample){
					
					$agent_id[] = $sample['agent_id'];	
				}
				$agent_id = implode("','",$agent_id);
				$sqlBucket="SELECT sum(sxd.audit_target) as bucket_target FROM qa_agent_categorisation sxd WHERE MONTH(sxd.upload_date)=MONTH('$from_date') AND  
					YEAR(sxd.upload_date)=YEAR('$from_date') AND (agent_id IN ('".$agent_id."'))";
				$bucket = $this->Common_model->get_query_row_array($sqlBucket);
				//$qa_target = ceil($bucket['bucket_target']/26); 
				
				$qa_target = 20; 
				$rand_sql="Select $sel_fields,
					(select audit_target from qa_agent_categorisation a where a.agent_id=S.id) as audit_target
					FROM $rand_tbl RCD Left Join signin S On RCD.fusion_id=S.fusion_id
					where RCD.compute_status=2 and RCD.audit_status=0 and date(RCD.upload_date)='$from_date' $cond ORDER BY RAND() LIMIT $qa_target";
				$random_data_set=$this->Common_model->get_query_result_array($rand_sql);
				//echo "<pre>";print_r($random_data_set); echo "</pre>"; exit;
				foreach($random_data_set as $sr){
							$rand_id = $sr['rand_id'];
							$fusion_id = $sr['fusion_id'];
							$upload_date=$sr["upl_date"];
							$sql= "SELECT count(*) as record FROM $rand_tbl where fusion_id='".$fusion_id ."' and date(upload_date)='".$upload_date."' and is_distributed=1 and compute_status=2";
							$count = $this->Common_model->get_query_row_array($sql);
							
							if($count['record']<5){
								
								$this->db->query("UPDATE $rand_tbl SET is_distributed=1 WHERE fusion_id='".$fusion_id ."' and date(upload_date)='".$upload_date."' and is_distributed=0 and id=$rand_id" );
							}
							//exit;
				}
				
				/*------ INSERT into qa_ss_sampling_restore TABLE ------*/
				
	
				
				$sqlR = "SELECT SA.id as id,SA.fusion_id,SA.upload_date,
							concat(S.fname, ' ', S.lname) as agent_name, $sel_distribute_fields
							FROM $rand_tbl SA 
							LEFT JOIN signin S ON (SA.fusion_id=S.fusion_id)
							WHERE date(SA.upload_date)='".$from_date."' AND SA.audit_status=0 AND is_distributed=1 and compute_status=2 $cond $randCond"; 
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
			$data["aside_template"] = "qa_randamiser/aside.php";
			$data["content_template"] = "qa_randamiser/randamiser/data_randamise_logiclist_freshdesk.php";
			$data["content_js"] = "qa_randamiser_js.php";
			
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
			
			$sql = "SELECT cl.* FROM qa_randamiser_compute_logic cl where cl.status=1 $cond";
			$data['logicList']=$this->Common_model->get_query_result_array($sql);
		
			$data['from_date']=$from_date;
			$data['to_date']=$to_date;
			$this->load->view("dashboard",$data);
		}
	}
	public function compute_logiclist_delete($id){ /*-- For BSNL --*/
		if(check_logged_in()){
			$current_user = get_user_id(); 
			$user_office = get_user_office_id(); 
			$this->db->query("Update qa_randamiser_compute_logic set status=0 WHERE id='$id'");
			redirect("Qa_randamiser/data_randamise_logiclist_freshdesk");
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
			$data['compute_id'] = $compute_logic_id;
			
			$sql = "SELECT * FROM qa_randamiser_compute_logic WHERE id=".$compute_logic_id;
			$compute_logic = $this->Common_model->get_query_row_array($sql);
			$empString = $compute_logic['agent_id'];
			$empArr = explode(',',$empString);
			$empStrImp = implode("','",$empArr);
			$sqlUser = "SELECT concat(fname,' ',lname) as name FROM signin WHERE xpoid IN ('".$empStrImp."')";
			$agent_list = $this->Common_model->get_query_result_array($sqlUser);
			$data['compute_logic']=$compute_logic;
			$data['agent_list']=$agent_list;
			$data['sqlUser'] = $sqlUser;
			$this->load->view('qa_randamiser/randamiser/compute_details_condition',$data);
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
			$sql  = "DELETE FROM qa_randamiser_bsnl_data WHERE DATE(upload_date)='".$up_date."'";
			//echo $sql;exit;
			$this->db->query($sql);
			redirect('qa_sop_library/data_cdr_upload_freshdesk');
		}
	}
	
	
	
	
	public function download_distributed_data(){

		if($this->input->get('submit')=='Submit' || $this->input->get('assign')=='Assign To')
		{
			$from_date = $this->input->get('from_date');
			
			$params = array(
								"from_date"	 => $from_date
							);
			
			$header = array('SL No','Agent Name','Fusion ID','Location','Date of Creation','Recording Track ID');
			$data = array(
							array('Distribution Report'),
							$header
						);
			/*Common function for view and excel export*/
			$all_data = $this->get_data($params);
			
			//print_r($all_data);exit;
			$i=1;
			foreach($all_data as $row => $value){

				$sub = array();
				$sub = array(
								$i++,
								$value['agent_name'],
								$value['fusion_id'],
								$value['office_id'],
								$value['upload_date'],
								$value['recording_track_id']
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
		if(get_global_access()==1){
			$randCond .="";
		}else{
			$randCond .="and SA.assigned_qa_id=$current_user";
		}
		$sqlR = "SELECT SA.randomiser_id as id,SA.fusion_id,SA.upload_date,SA.mobile_number,SA.audit_sheet,SA.recording_track_id,
							concat(S.fname, ' ', S.lname) as agent_name, S.office_id,
							(select concat(fname, ' ', lname) as name from signin s where s.id=SA.assigned_qa_id) as qa_name
							FROM qa_sampling_restore_data SA 
							LEFT JOIN signin S ON (SA.fusion_id=S.fusion_id)
							WHERE SA.upload_date='".$from_date."' AND SA.audit_status=0 $randCond";		
				
		$data=$this->Common_model->get_query_result_array($sqlR);
		return $data;
	}
 }
 
 ?>