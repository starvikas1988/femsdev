<?php 

 class Qa_agent_categorisation_vikas extends CI_Controller{
		private $objPHPExcel;		
	public function __construct(){
		parent::__construct();
		$this->load->model('user_model');
		$this->load->model('Common_model');
		$this->load->model('Qa_agentcat_model');
		
		$this->load->library('excel'); // Added excel library
		$this->objPHPExcel = new PHPExcel(); // created excel object
	}
	
	
/////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////// VOICE //////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////
	
	public function sample_agent_cat_download(){
		if(check_logged_in()){ 
			$file_name = base_url()."course_uploads/sample/Sample_Agent_Categorization.xlsx";
			header("location:".$file_name);	
			exit();
		}
	}
	
	
	function import_excel_agent_categorisation(){
		
		$this->load->library('excel');
		if(isset($_FILES["file"]["name"])){
			$path = $_FILES["file"]["tmp_name"];
			$object = PHPExcel_IOFactory::load($path);
			$clmarr = array("agent_id","cq_score","bucket_name","audit_target");
			
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
						$user_list[$row][$key] = $worksheet->getCell($d.$row )->getValue();
					}	
				}
				
				foreach($user_list as $u_list){
					$usql = "select id from signin where xpoid = '".$u_list['agent_id']."'";
					$u_data = $this->Common_model->get_query_row_array($usql);
					$u_list['agent_id'] = $u_data['id'];
					$new_user_list[] = $u_list;
				}
				$log=get_logs();
				foreach($new_user_list as $new_list){
					$this->target_insert($new_list['agent_id'],$new_list['cq_score'],$new_list['bucket_name'],$new_list['audit_target'],$log);
				}
				// echo "<pre>";
				// print_r($new_user_list);
				// echo "</pre>";die;
				//$this->Qa_meesho_model->insert_excel_agent_categorisation($user_list);
				//$this->Qa_meesho_model->insert_excel_data('qa_agent_categorisation',$new_user_list);
				
				redirect('Qa_agent_categorisation_vikas');
			}
		}
	}
	
	
	public function index(){
		if(check_logged_in()){
			$current_user = get_user_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_agent_categorisation/agent_categorisation_data_vikas.php";
			$data["content_js"] = "qa_agent_categorisation_js.php";
			$current_date = CurrDate();
			$from_date = $this->input->get('from_date');
			$cond="";
			//$cqTbl='qa_digit_sales_feedback';
			$data['client_id'] = $client_id = $this->uri->segment(3);
			$data['pro_id'] = $pro_id = $this->uri->segment(4);
			
			//echo "<br> <br><br>";
			
			$bucketSQL = "SELECT * FROM qa_agent_categorisation_bucket WHERE client_id=$client_id and process_id=$pro_id";
			$data['bucket_list'] = $this->Common_model->get_query_result_array($bucketSQL);
			
			// QA list
			$qaSQL = "SELECT id,concat(fname,' ', lname) as qa_name FROM signin WHERE dept_id=5 AND status in (1,4)";
			$data['qa_list'] = $this->Common_model->get_query_result_array($qaSQL);
			//echo "<pre>"; print_r($data['qa_list']); echo "</pre>";
			
			if($from_date==""){ 
				//$from_date=CurrDate();
				$from_date = date('Y-m-d', strtotime(date('Y-m-d'). ' -1 MONTH'));
			}else{
				$from_date = date('Y-m-d', strtotime(date('Y-m-d'). ' -1 MONTH'));
			}
			
			if($from_date!="")  $cond= "MONTH(qac.audit_date)=MONTH('$from_date') AND YEAR(qac.audit_date)=YEAR('$from_date') ";
			
			$clientProCond = 'and ip.process_id='.$pro_id.' and ic.client_id='.$client_id;
			// If client is Cars24 all agent from that client
			if($client_id ==246){
				$clientProCond = 'and ic.client_id='.$client_id;
			}if($client_id ==153){
				$clientProCond = 'and ic.client_id='.$client_id;
			}
			
			$agentCatSQL ='Select S.id, S.fusion_id ,S.xpoid, concat(S.fname," " ,S.lname) as name, get_process_names(S.id),
			(SELECT agc.audit_target FROM qa_agent_categorisation agc WHERE agc.agent_id=S.id AND MONTH(upload_date)=MONTH("'.$current_date.'") AND YEAR(upload_date)=YEAR("'.$current_date.'")) as a_target,
			(SELECT agc.bucket_name FROM qa_agent_categorisation agc WHERE agc.agent_id=S.id AND MONTH(upload_date)=MONTH("'.$current_date.'") AND YEAR(upload_date)=YEAR("'.$current_date.'")) as a_bucket,
			(SELECT concat(s.fname," ",s.lname) FROM qa_agent_categorisation a LEFT JOIN signin s ON s.id=a.assigned_qa_id WHERE S.id=a.agent_id '.$clientProCond.') as qa_name,
			get_process_names(S.id) as process_name, DATEDIFF(CURDATE(), S.doj) as tenure from signin S 
			LEFT JOIN info_assign_client ic ON S.id=ic.user_id
			LEFT JOIN info_assign_process ip ON S.id=ip.user_id
			where S.status=1 and S.role_id in (Select id from role where folder="agent") '.$clientProCond.' and S.dept_id=6'; 
			
			$agent_cat_list = $this->Common_model->get_query_result_array($agentCatSQL);
			foreach($agent_cat_list as $acl){
				//$acl['cq_score'] = $this->getCQscore($acl['id']);
				$acl['cq_score'] = $this->getCQscore($acl['id'],$client_id, $pro_id);
				$acl['bucket_name'] = $this->getBucketName($acl['cq_score'],$client_id, $pro_id, $acl['id']);
				$acl['target'] = $this->getBucketTarget($acl['cq_score'],$client_id, $pro_id, $acl['id']);
				$agent_cat_lists[] = $acl;
			}
			
			$data['agent_cat_list'] = $agent_cat_lists;
			
			/* echo "<pre>";
			print_r($agent_cat_lists);
			echo "</pre>"; */
			//First day of the month
			$monthFirstDate = date('Y-m-01', strtotime('today'));
			//Current of the month.
			$monthCurrentDate = date('Y-m-d', strtotime('today'));
			//Last date of the month.
			$monthLastDate = date('Y-m-t', strtotime('today'));
			
			//Calculate Date Diff
			$date1 = new DateTime($monthCurrentDate);
			$date2 = new DateTime($monthLastDate);
			$interval = $date1->diff($date2);
			$days_left_for_the_month = $interval->d;
			
			
			/******* No of Sunday Calculation ******/
			/* $months=date('m', strtotime('today'));  
			$years=date('Y', strtotime('today'));   
			$d=cal_days_in_month(CAL_GREGORIAN,$months,$years);
			
			$start = new DateTime($monthFirstDate);
			$end = new DateTime($monthLastDate);
			$days = $start->diff($end, true)->days;

			$sundays = intval($days / 7) + ($start->format('N') + $days % 7 >= 7);
			$workingDays = ($d-$sundays); */
			
			
			/**************/
			
			$data["from_date"] = $from_date;
			$data["days_left_for_the_month"] = $days_left_for_the_month;
			$this->load->view("dashboard",$data);
		}
	}

	//VIKAS STARTS//
	function import_cdr_agent_excel_data(){ /*-- For BSNL --*/
		
		$this->load->library('excel');
		if(isset($_FILES["file"]["name"])){
			$path = $_FILES["file"]["tmp_name"];
			$object = PHPExcel_IOFactory::load($path);
			
			$client_id = $this->input->post('client_id');
			$pro_id = $this->input->post('pro_id');
			
			$localDateTime = GetLocalTime();

			$clmarr = array("agent_fusion_id","qa_fusion_id");
			$rand_table = "qa_agent_categorisation";
			
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
				for($row=2; $row<=$highestRow; $row++){
					//print_r($dd);
					foreach($dd as $key=>$d){
					
						if($key=="agent_fusion_id"){
							$agent_fusion_id = $worksheet->getCell($d.$row )->getValue();
							$sql_agentId = "SELECT id FROM signin WHERE fusion_id = '".$agent_fusion_id."' ";
							$row_agentId = $this->Common_model->get_query_row_array($sql_agentId);
							//print_r($row_agentId);
							//exit;
							
						}
						else if($key=="qa_fusion_id"){
							$qa_fusion_id = $worksheet->getCell($d.$row )->getValue();
							$sql_qaId = "SELECT id FROM signin WHERE fusion_id = '".$qa_fusion_id."' ";
							$row_qaId = $this->Common_model->get_query_row_array($sql_qaId);
						}

						$randArr = array('assigned_qa_id'=>$row_qaId['id']);
							$this->db->where('agent_id', $row_agentId['id']);
						    $this->db->update($rand_table,$randArr);
					}	
				}
				//exit;
				// echo "<pre>"; print_r($user_list); echo "</pre>";exit;
				 $client_id = $this->input->post('client_id');
				 $pro_id = $this->input->post('pro_id');
				 redirect('Qa_agent_categorisation_vikas/index/'.$client_id.'/'.$pro_id);

				//vikas ends//
			}
		}
	}

	//VIKAS ENDS//

	function getCQscore($agent_id, $client_id, $pro_id){
		$from_date = date('Y-m-d', strtotime(date('Y-m-d'). ' -1 MONTH'));
		if($from_date!="")  $cond= "MONTH(audit_date)=MONTH('$from_date') AND YEAR(audit_date)=YEAR('$from_date') ";
		$defect_sql = "select table_name from qa_defect WHERE is_active=1 AND client_id=".$client_id." and process_id=".$pro_id;
		$defect_data = $this->Common_model->get_query_result_array($defect_sql);
		
		$total_score = 0;
		$total_audit = 0;
		foreach($defect_data as $d_data){
			$qsql = 'select count(id) as total_audit,sum(overall_score) as total_score from '.$d_data['table_name'].' where agent_id = '.$agent_id.' and '.$cond;
			$audit_data = $this->Common_model->get_query_row_array($qsql);
			$total_score = $total_score + $audit_data['total_score'];
			$total_audit = $total_audit + $audit_data['total_audit'];
		}
		if($total_score != 0 || $total_audit != 0){
		$overall_score = number_format($total_score/$total_audit,2);
		}else{
			$overall_score = 0;
		}
		return $overall_score;
	}
	// Return the bucket Name as per CQ Score and client process selected

		function getBucketName($cqScore, $client_id,$pro_id, $agent_id){
			$selS = "SELECT DATEDIFF(CURDATE(), doj) as tenure from signin WHERE id=".$agent_id;
			$agent = $this->Common_model->get_query_row_array($selS);
			
			$sql = "SELECT bucket_name FROM qa_agent_categorisation_bucket WHERE client_id=".$client_id." and process_id=".$pro_id." and (bucket_criteria_min <=".$cqScore." and bucket_criteria_max>=".$cqScore.")";
			$bucketName =  $this->Common_model->get_query_row_array($sql);
			return $bucketName['bucket_name'];
		}
	// Return the bucket target as per CQ Score and client process selected

		function getBucketTarget($cqScore, $client_id,$pro_id){
			$sql = "SELECT bucket_target FROM qa_agent_categorisation_bucket WHERE client_id=".$client_id." and process_id=".$pro_id." and (bucket_criteria_min <=".$cqScore." and bucket_criteria_max>=".$cqScore.")";
			$bucketTarget =  $this->Common_model->get_query_row_array($sql);
			return $bucketTarget['bucket_target'];
		}
	
	// Return the target for the selected bucket 
	
	function getTarget(){
		$id = $this->input->post("bucketID");
		$sql = "SELECT bucket_name,bucket_target FROM qa_agent_categorisation_bucket WHERE id=$id";
		$target =  $this->Common_model->get_query_row_array($sql);
		echo json_encode($target);
	}
	function getTargetOJT(){
		$id = $this->input->post("bucketID");
		$agentTenure = $this->input->post("tenure");
		$sql = "SELECT bucket_name,bucket_target FROM qa_agent_categorisation_bucket WHERE id=$id";
		$target =  $this->Common_model->get_query_row_array($sql);
		
		//First day of the month
		$monthFirstDate = date('Y-m-01', strtotime('today'));
		//Current of the month.
		$monthCurrentDate = date('Y-m-d', strtotime('today'));
		//Last date of the month.
		$monthLastDate = date('Y-m-t', strtotime('today'));
		//Calculate Date Diff
		$date1 = new DateTime($monthCurrentDate);
		$date2 = new DateTime($monthLastDate);
		$interval = $date1->diff($date2);
		$days_left_for_the_month = $interval->d;
		
		/* Total Sunday for the month */
		$months=date('m', strtotime('today'));  
		$years=date('Y', strtotime('today'));   
		$d=cal_days_in_month(CAL_GREGORIAN,$months,$years);
			
		$start = new DateTime($monthFirstDate);
		$end = new DateTime($monthLastDate);
		$days = $start->diff($end, true)->days;

		$sundays = intval($days / 7) + ($start->format('N') + $days % 7 >= 7);
	    $workingDays = ($d-$sundays);
		
		
		/*Remaining Sunday Calulation */
		$start = new DateTime($monthCurrentDate);
		$end = new DateTime($monthLastDate);
		$days = $start->diff($end, true)->days;
		$remaining_sundays = intval($days / 7) + ($start->format('N') + $days % 7 >= 7);
		$excludingSundayDaysLeft = $days_left_for_the_month-$remaining_sundays;
		
		$calTarget=10;
		if($agentTenure>=13 && $agentTenure<30){
			$calTarget=ROUND(($target['bucket_target']/$workingDays)*$excludingSundayDaysLeft);
		}
		$target['calTarget'] = $calTarget;
		echo json_encode($target);
	}
	public function new_agent(){
		if(check_logged_in()){
			$current_user = get_user_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_agent_categorisation/new_agent_categorisation_data.php";
			$data["content_js"] = "qa_agent_categorisation_js.php";
			$current_date = CurrDate();
			$from_date = $this->input->get('from_date');
			$cond="";
			$cqTbl='qa_digit_sales_feedback';
			
			$bucketSQL = "SELECT * FROM qa_agent_categorisation_bucket";
			$data['bucket_list'] = $this->Common_model->get_query_result_array($bucketSQL);
			
			if($from_date==""){ 
				//$from_date=CurrDate();
				$from_date = date('Y-m-d', strtotime(date('Y-m-d'). ' -1 MONTH'));
			}else{
				$from_date = date('Y-m-d', strtotime(date('Y-m-d'). ' -1 MONTH'));
			}
			
			if($from_date!="")  $cond= " MONTH(audit_date)=MONTH('$from_date') AND YEAR(audit_date)=YEAR('$from_date')";
			
			$sqlNewAgents = "SELECT s.id,s.xpoid, s.fusion_id, concat(s.fname,' ',s.lname) as name, DATEDIFF(CURDATE(), s.doj) as tenure FROM signin s 
			LEFT JOIN qa_agent_categorisation a ON a.agent_id=s.id
			where MONTH(s.doj)=MONTH('$current_date') AND YEAR(s.doj)=YEAR('$current_date') AND s.id NOT IN (SELECT agent_id FROM qa_agent_categorisation)";
			$data['new_agent_list'] =  $this->Common_model->get_query_result_array($sqlNewAgents);
			//print_r($data['new_agent_list']);
			
			
			$data["from_date"] = $from_date;
			$this->load->view("dashboard",$data);
		}
	}
	public function view_agent_target(){
		if(check_logged_in()){
			$current_user = get_user_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_agent_categorisation/view_agent_target.php";
			$data["content_js"] = "qa_agent_categorisation_js.php";
			$current_date = CurrDate();
			$from_date = $this->input->get('from_date');
			$cond="";
			$cqTbl='qa_digit_sales_feedback';
			
			$bucketSQL = "SELECT * FROM qa_agent_categorisation_bucket";
			$data['bucket_list'] = $this->Common_model->get_query_result_array($bucketSQL);
			
			if($from_date==""){ 
				//$from_date=CurrDate();
				$from_date = date('Y-m-d', strtotime(date('Y-m-d'). ' -1 MONTH'));
			}else{
				$from_date = date('Y-m-d', strtotime(date('Y-m-d'). ' -1 MONTH'));
			}
			
			if($from_date!="")  $cond= " MONTH(audit_date)=MONTH('$from_date') AND YEAR(audit_date)=YEAR('$from_date')";
			
		
			// New User from the tool
		
			$agentCatSQL = "Select qac.agent_id, qac.cq_score as uplScore, qac.bucket_name as uplBucket, qac.audit_target, date(qac.upload_date) as uplDate, S.id, S.xpoid, S.fusion_id, concat(S.fname,' ',S.lname) as name,
				(select AVG(cq.overall_score) from $cqTbl cq where cq.agent_id=S.id) as cq_score
				from qa_agent_categorisation qac 
				Left Join signin S On qac.agent_id=S.id
				Group By qac.agent_id";
			$data['agent_list'] =  $this->Common_model->get_query_result_array($agentCatSQL);
			
			
			$data["from_date"] = $from_date;
			$this->load->view("dashboard",$data);
		}
	}
////////////// Create Bucket //////////////////
	public function create_bucket(){
		if(check_logged_in()){
			$current_user = get_user_id();
			if($this->input->post('btnCreate')=='Create'){
				$bucket_name = $this->input->post('bucket_name');
				$bucket_target = $this->input->post('target_per_month');
				$bucket_min = $this->input->post('bucket_criteria_min');
				$bucket_max = $this->input->post('bucket_criteria_max');
				$client_id = $this->input->post('client_id');
				$process_id = $this->input->post('process_id');
				
				if(!empty($this->input->post('bucket_id'))){
					$bucket_id = $this->input->post('bucket_id');
					$modified_on = CurrDate();
					$qSql = "UPDATE qa_agent_categorisation_bucket SET bucket_target=$bucket_target,bucket_criteria_min=$bucket_min,bucket_criteria_max=$bucket_max, modified_by=$current_user, modified_on='$modified_on' WHERE id=".$bucket_id;
					$this->db->query($qSql);
				}else{
					$chk_sql = "select bucket_name,bucket_target from qa_agent_categorisation_bucket where bucket_name = '$bucket_name' and client_id= $client_id and process_id=$process_id";
					$no_of_bucket = $this->db->query($chk_sql)->num_rows();
					if ($no_of_bucket > 0) {
						echo "<script>alert('Sorry! You can not create another bucket with same name');
						window.location.href='" . base_url() . "qa_agent_categorisation/index/".$client_id."/".$process_id."';
						</script>";exit;
					}else{
					$qSql = "INSERT INTO qa_agent_categorisation_bucket SET bucket_name = '$bucket_name', client_id='$client_id', process_id='$process_id', bucket_target=$bucket_target,bucket_criteria_min=$bucket_min,bucket_criteria_max=$bucket_max, created_by=$current_user";
					$this->db->query($qSql);
					}
				}
			}
			$rediectCond = 'index/'.$client_id.'/'.$process_id;
			redirect('Qa_agent_categorisation_vikas/'.$rediectCond);
		}
	}
	
////////////////////// Set Target /////////////////////////
	public function set_agent_target(){
		if(check_logged_in()){
			$from_date=CurrDate();
			$dataArr =$this->input->post('data');
			//print_r($_POST);
			$client_id = $_POST['client_id'];
			$pro_id = $_POST['process_id'];
			$qa_id = $_POST['qa_id'];
			/*  echo "<pre>";
			  print_r($_POST);
			 print_r($dataArr);
			 echo "</pre>";die;  */
			
			$log=get_logs();
			foreach($dataArr as $data){
				$agent_id = $data['agentID'];
				$cq_score = $data['cq_score'];
				$bucket_name = $data['bucket_name'];
				$bucket_target = $data['bucket_target'];
				
				if(!empty($_POST['qa_id'])){ // update QA
					$this->update_qa($client_id,$pro_id,$agent_id,$qa_id);
				}else{
					$this->target_insert($client_id,$pro_id,$agent_id,$cq_score,$bucket_name,$bucket_target,$log);
				}
			}
			$redURL = "/index/".$client_id."/".$pro_id;
			redirect('Qa_agent_categorisation_vikas'.$redURL);
		}			
	}
	function target_insert($client_id,$pro_id,$agent_id,$cq_score=null,$bucket_name,$bucket_target,$log=null){
		$current_date = CurrMySqlDate();
		if($agent_id!=""){
		$sqlCheck = "SELECT count(id) as cnt FROM qa_agent_categorisation WHERE agent_id='$agent_id'";
		$record = $this->Common_model->get_query_row_array($sqlCheck);
		if($record['cnt']>0){
			
			$qSql = "UPDATE qa_agent_categorisation SET cq_score='$cq_score', bucket_name='$bucket_name', audit_target='$bucket_target', upload_date='$current_date', log='$log' WHERE agent_id='$agent_id' and client_id='$client_id' and process_id='$pro_id'";
			$this->db->query($qSql);
		}else{
			if($bucket_target!=""){
				$qSql = "INSERT INTO qa_agent_categorisation SET client_id='$client_id',process_id='$pro_id', agent_id='$agent_id', cq_score='$cq_score', bucket_name='$bucket_name', audit_target='$bucket_target', log='$log'";
				$this->db->query($qSql);
			}
		}
	}
	}
	function update_qa($client_id,$pro_id,$agent_id,$qa_id){
		$qSql = "UPDATE qa_agent_categorisation SET assigned_qa_id='$qa_id' WHERE agent_id='$agent_id' and client_id='$client_id' and process_id='$pro_id'";
		$this->db->query($qSql);
	}

/////////////////////// Bucket Update //////////////////////
	public function bucket_list(){
		if(check_logged_in()){
			$current_user = get_user_id();
			$current_user = get_user_id();
			//$data["aside_template"] = "qa/aside.php";
			//$data["content_template"] = "qa_agent_categorisation/bucket_list.php";
			//$data["content_js"] = "qa_agent_categorisation_js.php";
			
			$qSql = "SELECT * FROM qa_agent_categorisation_bucket";
			$data["bucket_list"] = $this->Common_model->get_query_result_array($qSql);
			$this->load->view("dashboard",$data);
		}
	}
	
//////////////////// Bucket Delete //////////////////////
	public function delete_record(){
		if(check_logged_in()){
			$current_user = get_user_id();
			$id = $this->input->post('id');
			$client_id = $this->input->post('cid');
			$pro_id = $this->input->post('pid');
			$qSql = "DELETE FROM qa_agent_categorisation_bucket WHERE id=".$id." AND client_id=".$client_id." AND process_id=".$pro_id;
			$this->db->query($qSql);
			//redirect('qa_agent_categorisation');
			return true;
		}
	}
	
///////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
	
	public function agent_csat_aht(){
		if(check_logged_in()){
			$current_user = get_user_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_agent_categorisation/agent_csat_aht.php";
			$data["content_js"] = "qa_agent_categorisation_js.php";
			
			$from_date = $this->input->get('from_date');
			$cond="";
			
			if($from_date==""){ 
				$from_date=CurrDate();
			}else{
				$from_date = mmddyy2mysql($from_date);
			}
			
			if($from_date!="")  $cond= " and MONTH(upload_date)=MONTH('$from_date') AND YEAR(upload_date)=YEAR('$from_date')";
			
			$qSql = "SELECT a.*,
						  (select count(*) from qa_agent_csat_aht_data ss where ss.agent_id=a.agent_id and status='Satisfied' $cond) as satisfied_count,
						  (select count(*) from qa_agent_csat_aht_data ss where ss.agent_id=a.agent_id and status='Not_Satisfied' $cond) as not_satisfied_count
						  FROM qa_agent_csat_aht_data a 
						  WHERE (a.status='Satisfied' OR a.status='Not_Satisfied') AND is_active=1 $cond 
						  GROUP BY agent_id";
			$data["uploaded_data"] = $this->Common_model->get_query_result_array($qSql);
			
			$data["from_date"] = $from_date;
			$this->load->view("dashboard",$data);
		}
	}
	// AHT Target set
	public function set_target(){
		if(check_logged_in()){
			$current_user = get_user_id();
			if(!empty($this->input->post('target')) && $this->input->post('btnSet')=='Set'){
				$target = $this->input->post('target');
				$from_date=CurrDate();
				$qSql = "UPDATE qa_agent_csat_aht_data SET aht_target=$target WHERE MONTH(upload_date)=MONTH('$from_date') AND YEAR(upload_date)=YEAR('$from_date')";
				$this->db->query($qSql);
			}
			redirect('Qa_agent_categorisation_vikas');
		}
	}
	
	
	// Get bucket details 
	public function get_bucket_details(){
		if(check_logged_in()){
			$bucket_id = $this->input->get('bid');//03552
			$data['client_id']=$client_id = $this->input->get('cid');
			$data['pro_id'] = $pro_id = $this->input->get('pid');
			$data['bucket_id'] = $bucket_id;
			$qSql = "SELECT * FROM qa_agent_categorisation_bucket WHERE id=".$bucket_id." and client_id=".$client_id." and process_id=".$pro_id;
			$data['bucket_data'] = $this->Common_model->get_query_row_array($qSql);
		
			$this->load->view('qa_agent_categorisation/get_bucket_details',$data);
		}
	}
	// Update the table
	public function update_list(){
		if(check_logged_in()){
			$dataArr =$this->input->post('data');
			$from_date=CurrDate();
			foreach($dataArr as $data){
				$agent_id = $data['agentID'];
				$q_score = $data['quality_score'];
				$csat_score = $data['csat_score'];
				$aht_score = $data['aht_score'];
				$total_score = $data['total_score'];
				$bucket_name = $data['bucket_name'];
				$qSql = "UPDATE qa_agent_csat_aht_data SET q_score=$q_score, csat_score=$csat_score, aht_score=$aht_score,total_score=$total_score,bucket_name='$bucket_name' WHERE MONTH(upload_date)=MONTH('$from_date') AND YEAR(upload_date)=YEAR('$from_date') AND agent_id='$agent_id'";
				$this->db->query($qSql);
			}
			redirect('Qa_agent_categorisation_vikas');
		}			
	}
	
	// Download Export Report
	public function download_rep(){
		if(check_logged_in()){
			 if($_GET['btnDownload'] == "Download"){
				 //print_r($_GET);
				 $this->generate_xls($_GET['from_date']);
			 }else{
				redirect('Qa_agent_categorisation_vikas','refresh');
			}
			
		}
	}
	// Generate Excel file
	private function generate_xls($from_date=null){
		if(check_logged_in()){
			$this->objPHPExcel->createSheet();
			$this->objPHPExcel->setActiveSheetIndex();
			$objWorksheet = $this->objPHPExcel->getActiveSheet();
			$objWorksheet->setTitle("Agen Categorisation");
			 
			// START GRIDLINES HIDE AND SHOW//
			$objWorksheet->setShowGridlines(true);
			// END GRIDLINES HIDE AND SHOW//
			
			
		$this->objPHPExcel->getDefaultStyle()->getAlignment()->setWrapText(true);	
			
	   
			$objWorksheet->getColumnDimension('A')->setWidth(15);
			$objWorksheet->getColumnDimension('B')->setWidth(15);
			$objWorksheet->getColumnDimension('C')->setWidth(15);
			$objWorksheet->getColumnDimension('D')->setWidth(15);
			$objWorksheet->getColumnDimension('E')->setWidth(15);
			$objWorksheet->getColumnDimension('F')->setWidth(15);
			$objWorksheet->getColumnDimension('G')->setWidth(15);
			$objWorksheet->getColumnDimension('H')->setWidth(15);
			$objWorksheet->getColumnDimension('I')->setWidth(15);
			$objWorksheet->getColumnDimension('J')->setWidth(15);
			$objWorksheet->getColumnDimension('K')->setWidth(15);
			$objWorksheet->getColumnDimension('L')->setWidth(15);
			$objWorksheet->getColumnDimension('M')->setWidth(15);
			$objWorksheet->getColumnDimension('N')->setWidth(15);
			$objWorksheet->getColumnDimension('O')->setWidth(15);
			$objWorksheet->getColumnDimension('P')->setWidth(15);
			$objWorksheet->getColumnDimension('Q')->setWidth(15);
			$objWorksheet->getColumnDimension('R')->setWidth(15);
			$objWorksheet->getColumnDimension('S')->setWidth(15);
			$objWorksheet->getColumnDimension('T')->setWidth(15);
			$objWorksheet->getColumnDimension('U')->setWidth(15);
			$objWorksheet->getColumnDimension('V')->setWidth(15);
			
			$style = array(
				'alignment' => array(
					'horizontal' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
				)
			);
			
			$objWorksheet->getStyle("A1:P1")->applyFromArray($style);
			$sheet = $this->objPHPExcel->getActiveSheet();

			unset($style);
	 
			// CELL BACKGROUNG COLOR
			$this->objPHPExcel->getActiveSheet()->getStyle("A2:I2")->getFill()->applyFromArray(
                $styleArray =array(
								'type' => PHPExcel_Style_Fill::FILL_SOLID,
								'startcolor' => array(
									 'rgb' => "35B8E0"
								),
								'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
							)
                );
       
			// CELL FONT AND FONT COLOR 
			$styleArray = array(
			'font'  => array(
				'bold'  => true,
				'color' => array('rgb' => '000000'),
				'size'  => 14,
				'name'  => 'Algerian',
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
			));
			
			$style = array(
				'alignment' => array(
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
				)
			);

			$this->objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($styleArray);
			
			
			$sheet = $this->objPHPExcel->getActiveSheet();
			$sheet->getDefaultStyle()->applyFromArray($style);
			$sheet->setCellValueByColumnAndRow(0, 1, "Agent Categorisation");
			$sheet->mergeCells('A1:J1');
			    
				$col1=0;
				$row1=3; 
				
				// Agent Count % List
				$header_column = array("##","Agent ID","Call AHT","Quality %","C-SAT %","AHT %", "Total Score %","Bucket","Uploaded Date");
						
				foreach($header_column as $val){
						$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col1,2,$val);	
						$col1++;
				}
				
			
				// Query 
				
				if($from_date!="")  $cond= " and MONTH(upload_date)=MONTH('$from_date') AND YEAR(upload_date)=YEAR('$from_date')";
				// Quality Table Array	
				$qualityTableArr = array('qa_meesho_cmb_feedback','qa_meesho_inbound_feedback','qa_meesho_email_feedback','qa_meesho_chat_feedback');
			
				$qualityCondi = "";
				foreach($qualityTableArr as $qualityTable){
					$qualityCondi.="(SELECT AVG(qt.overall_score) FROM $qualityTable qt LEFT JOIN signin s ON qt.agent_id=s.id 
									LEFT JOIN qa_agent_csat_aht_data q ON s.xpoid=q.agent_id
									WHERE MONTH(qt.audit_date)=MONTH('$from_date') 
											AND YEAR(qt.audit_date)=YEAR('$from_date') 
											AND (q.status='Satisfied' OR q.status='Not_Satisfied')
											AND q.agent_id=a.agent_id
									GROUP BY a.agent_id) as $qualityTable,";
				}
			
				$qSql = "SELECT a.*,$qualityCondi
						  (select count(*) from qa_agent_csat_aht_data ss where ss.agent_id=a.agent_id and status='Satisfied' $cond) as satisfied_count,
						  (select count(*) from qa_agent_csat_aht_data ss where ss.agent_id=a.agent_id and status='Not_Satisfied' $cond) as not_satisfied_count
						  FROM qa_agent_csat_aht_data a 
						  WHERE (a.status='Satisfied' OR a.status='Not_Satisfied') AND is_active=1 $cond 
						  GROUP BY agent_id";
			
			
				$result_arr = $this->Common_model->get_query_result_array($qSql);
				
				$row3 = 3;
				$sl = 1;
				foreach($result_arr as $row){
					
					$col3 = 0;
					$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col3,$row3,$sl);
					$col3++;
					$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col3,$row3,$row['agent_id']);
					$col3++;
					$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col3,$row3,$row['call_aht']);
					$col3++;
					$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col3,$row3,$row['q_score']);
					$col3++;
					$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col3,$row3,$row['csat_score']);
					$col3++;
					$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col3,$row3,$row['aht_score']);
					$col3++;
					$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col3,$row3,$row['total_score']);
					$col3++;
					$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col3,$row3,$row['bucket_name']);
					$col3++;
					$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col3,$row3,mysql2mmddyy($row['upload_date']));
					
					$row3++;
					$sl++;
				}
			
			
			
			
  
				ob_end_clean();
				header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
				header('Content-Disposition: attachment;filename="agent_categorisation.xlsx"');
				header('Cache-Control: max-age=0');
				$objWriter = PHPExcel_IOFactory::createWriter($this->objPHPExcel , 'Excel2007');
				$objWriter->setIncludeCharts(TRUE);
				$objWriter->save('php://output');
			
			exit();  
            	
		}
	}
	
	
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
	// 										SX ANGENT CATEGORISATION                                                          //
	
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
	function sx_agent_categorisation(){
		if(check_logged_in()){
			$current_user = get_user_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_agent_categorisation/sx_agent_categorisation.php";
			$data["content_js"] = "qa_agent_categorisation_js.php";
			
			$from_date = $this->input->get('from_date');
			$cond="";
			
			if($from_date==""){ 
				$from_date=CurrDate();
			}else{
				$from_date = mmddyy2mysql($from_date);
			}
			
			if($from_date!="")  $cond= " and MONTH(upload_date)=MONTH('$from_date') AND YEAR(upload_date)=YEAR('$from_date')";
			
			/* $qualityCodi = "(SELECT AVG(qt.overall_score) FROM qa_meesho_supplier_support_new_feedback qt LEFT JOIN signin s ON qt.agent_id=s.id 
								LEFT JOIN qa_ss_ssat_data q ON s.xpoid=q.agent_id
								WHERE MONTH(qt.audit_date)=MONTH('$from_date') 
										AND YEAR(qt.audit_date)=YEAR('$from_date') 
										AND (q.feedback_rating='5' OR q.feedback_rating='1')
										AND q.agent_id=a.agent_id
								GROUP BY a.agent_id) as quality_score,"; */
			$qualityCodi = "(SELECT AVG(qt.overall_score) FROM qa_meesho_supplier_support_new_feedback qt LEFT JOIN signin s ON qt.agent_id=s.id 
								LEFT JOIN qa_ss_ssat_data q ON q.agent_id=s.xpoid
								WHERE MONTH(qt.audit_date)=MONTH('$from_date') 
										AND YEAR(qt.audit_date)=YEAR('$from_date') 
										AND (q.feedback_rating='5' OR q.feedback_rating='1')
										AND q.agent_id=a.agent_id
								GROUP BY a.agent_id) as quality_score,";
			
			$qSql = "SELECT a.*,$qualityCodi
						  (select count(*) from qa_ss_ssat_data ss where ss.agent_id=a.agent_id and feedback_rating='5' $cond) as feedback_rate_5,
						  (select count(*) from qa_ss_ssat_data ss where ss.agent_id=a.agent_id and feedback_rating='1' $cond) as feedback_rate_1
						  FROM qa_ss_ssat_data a 
						  WHERE (a.feedback_rating='5' OR a.feedback_rating='1') AND is_active=1 $cond 
						  GROUP BY agent_id";
			//echo $qSql;
			//exit;
			$data["sx_list"] = $this->Common_model->get_query_result_array($qSql); 
			
			// Getting the Bucket list
			$current_date = CurrDate();
			$bucketSQL = "SELECT * FROM sx_agent_categorisation_bucket WHERE MONTH(created_on)=MONTH('$current_date') AND YEAR(created_on)=YEAR('$current_date')";
			$data['bucket_list'] = $this->Common_model->get_query_result_array($bucketSQL);
			
			//$data['qualityTableArr'] = $qualityTableArr;
			$data["from_date"] = $from_date;
			$this->load->view("dashboard",$data);
		}
	}
	
	// SX Bucket Creation
	
	public function sx_create_bucket(){
		if(check_logged_in()){
			$current_user = get_user_id();
			if($this->input->post('btnCreate')=='Create'){
				$bucket_name = $this->input->post('bucket_name');
				$bucket_criteria_max = $this->input->post('bucket_criteria_max');
				$bucket_criteria_min = $this->input->post('bucket_criteria_min');
				$bucket_target = $this->input->post('target_per_month');
				if(!empty($this->input->post('bucket_id')))
				{
					$bucket_id = $this->input->post('bucket_id');
					$modified_on = CurrDate();
					$qSql = "UPDATE sx_agent_categorisation_bucket SET bucket_criteria_max=$bucket_criteria_max, bucket_criteria_min=$bucket_criteria_min, bucket_target=$bucket_target, modified_by=$current_user, modified_on='$modified_on' WHERE id=".$bucket_id;
					$this->db->query($qSql);
					//exit;
				}else{
				$qSql = "INSERT INTO sx_agent_categorisation_bucket SET bucket_name = '$bucket_name', bucket_criteria_max=$bucket_criteria_max, bucket_criteria_min=$bucket_criteria_min, bucket_target=$bucket_target, created_by=$current_user";
				$this->db->query($qSql);
				}
			}
			
			redirect('Qa_agent_categorisation_vikas/sx_bucket_list');
		}
	}
	
	// SX Bucket List
	public function sx_bucket_list(){
		if(check_logged_in()){
			$current_user = get_user_id();
			$current_user = get_user_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_agent_categorisation/sx_bucket_list.php";
			$data["content_js"] = "qa_agent_categorisation_js.php";
			
			$qSql = "SELECT * FROM sx_agent_categorisation_bucket";
			$data["bucket_list"] = $this->Common_model->get_query_result_array($qSql);
			$this->load->view("dashboard",$data);
		}
	}
	// SX Get bucket details 
	public function sx_get_bucket_details(){
		if(check_logged_in()){
			$bucket_id = $this->input->get('bid');
			$data['bucket_id'] = $bucket_id;
			$qSql = "SELECT * FROM sx_agent_categorisation_bucket WHERE id=".$bucket_id;
			$data['bucket_data'] = $this->Common_model->get_query_row_array($qSql);
		
			$this->load->view('qa_agent_categorisation/sx_get_bucket_details',$data);
		}
	}
	// SX Update the table
	
	
	//SX Delete Record
	public function delete_record_sx($id){
		if(check_logged_in()){
			$current_user = get_user_id();
			$qSql = "DELETE FROM qa_ss_ssat_data WHERE id=".$id;
			$this->db->query($qSql);
			
			redirect('Qa_agent_categorisation_vikas/sx_agent_categorisation');
		}
	}
	
	// Download Export Report for SX
	public function sx_download_rep(){
		if(check_logged_in()){
			 if($_GET['btnDownload'] == "Download"){
				 //print_r($_GET);
				 $this->generate_xls_sx($_GET['from_date']);
			 }else{
				redirect('Qa_agent_categorisation_vikas/sx_agent_categorisation','refresh');
			}
			
		}
	}
	// Generate Excel file for SX
	private function generate_xls_sx($from_date=null){
		if(check_logged_in()){
			$this->objPHPExcel->createSheet();
			$this->objPHPExcel->setActiveSheetIndex();
			$objWorksheet = $this->objPHPExcel->getActiveSheet();
			$objWorksheet->setTitle("Agen Categorisation");
			 
			// START GRIDLINES HIDE AND SHOW//
			$objWorksheet->setShowGridlines(true);
			// END GRIDLINES HIDE AND SHOW//
			
			
		$this->objPHPExcel->getDefaultStyle()->getAlignment()->setWrapText(true);	
			
	   
			$objWorksheet->getColumnDimension('A')->setWidth(15);
			$objWorksheet->getColumnDimension('B')->setWidth(15);
			$objWorksheet->getColumnDimension('C')->setWidth(15);
			$objWorksheet->getColumnDimension('D')->setWidth(15);
			$objWorksheet->getColumnDimension('E')->setWidth(15);
			$objWorksheet->getColumnDimension('F')->setWidth(15);
			$objWorksheet->getColumnDimension('G')->setWidth(15);
			$objWorksheet->getColumnDimension('H')->setWidth(15);
			$objWorksheet->getColumnDimension('I')->setWidth(15);
			$objWorksheet->getColumnDimension('J')->setWidth(15);
			$objWorksheet->getColumnDimension('K')->setWidth(15);
			$objWorksheet->getColumnDimension('L')->setWidth(15);
			$objWorksheet->getColumnDimension('M')->setWidth(15);
			$objWorksheet->getColumnDimension('N')->setWidth(15);
			$objWorksheet->getColumnDimension('O')->setWidth(15);
			$objWorksheet->getColumnDimension('P')->setWidth(15);
			$objWorksheet->getColumnDimension('Q')->setWidth(15);
			$objWorksheet->getColumnDimension('R')->setWidth(15);
			$objWorksheet->getColumnDimension('S')->setWidth(15);
			$objWorksheet->getColumnDimension('T')->setWidth(15);
			$objWorksheet->getColumnDimension('U')->setWidth(15);
			$objWorksheet->getColumnDimension('V')->setWidth(15);
			
			$style = array(
				'alignment' => array(
					'horizontal' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
				)
			);
			
			$objWorksheet->getStyle("A1:P1")->applyFromArray($style);
			$sheet = $this->objPHPExcel->getActiveSheet();

			unset($style);
	 
			// CELL BACKGROUNG COLOR
			$this->objPHPExcel->getActiveSheet()->getStyle("A2:I2")->getFill()->applyFromArray(
                $styleArray =array(
								'type' => PHPExcel_Style_Fill::FILL_SOLID,
								'startcolor' => array(
									 'rgb' => "35B8E0"
								),
								'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
							)
                );
       
			// CELL FONT AND FONT COLOR 
			$styleArray = array(
			'font'  => array(
				'bold'  => true,
				'color' => array('rgb' => '000000'),
				'size'  => 14,
				'name'  => 'Algerian',
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
			));
			
			$style = array(
				'alignment' => array(
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
				)
			);

			$this->objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($styleArray);
			
			
			$sheet = $this->objPHPExcel->getActiveSheet();
			$sheet->getDefaultStyle()->applyFromArray($style);
			$sheet->setCellValueByColumnAndRow(0, 1, "Agent Categorisation");
			$sheet->mergeCells('A1:J1');
			    
				$col1=0;
				$row1=3; 
				
				// Agent Count % List
				$header_column = array("##","Agent ID","Quality %","C-SAT %", "Total Score %","Bucket","Uploaded Date");
						
				foreach($header_column as $val){
						$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col1,2,$val);	
						$col1++;
				}
				
			
				// Query 
				
				if($from_date!="")  $cond= " and MONTH(upload_date)=MONTH('$from_date') AND YEAR(upload_date)=YEAR('$from_date')";
				// Quality Table Array	
				$qualityCodi = "(SELECT AVG(qt.overall_score) FROM qa_meesho_supplier_support_new_feedback qt LEFT JOIN signin s ON qt.agent_id=s.id 
								LEFT JOIN qa_ss_ssat_data q ON s.xpoid=q.agent_id
								WHERE MONTH(qt.audit_date)=MONTH('$from_date') 
										AND YEAR(qt.audit_date)=YEAR('$from_date') 
										AND (q.feedback_rating='5' OR q.feedback_rating='1')
										AND q.agent_id=a.agent_id
								GROUP BY a.agent_id) as quality_score,";
			
			    $qSql = "SELECT a.*,$qualityCodi
						  (select count(*) from qa_ss_ssat_data ss where ss.agent_id=a.agent_id and feedback_rating='5' $cond) as feedback_rate_5,
						  (select count(*) from qa_ss_ssat_data ss where ss.agent_id=a.agent_id and feedback_rating='1' $cond) as feedback_rate_1
						  FROM qa_ss_ssat_data a 
						  WHERE (a.feedback_rating='5' OR a.feedback_rating='1') AND is_active=1 $cond 
						  GROUP BY agent_id";
			
			
				$result_arr = $this->Common_model->get_query_result_array($qSql);
				
				$row3 = 3;
				$sl = 1;
				foreach($result_arr as $row){
					
					$col3 = 0;
					$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col3,$row3,$sl);
					$col3++;
					$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col3,$row3,$row['agent_id']);
					$col3++;
					$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col3,$row3,$row['q_score']);
					$col3++;
					$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col3,$row3,$row['ssat_score']);
					$col3++;
					$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col3,$row3,$row['total_score']);
					$col3++;
					$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col3,$row3,$row['bucket_name']);
					$col3++;
					$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col3,$row3,mysql2mmddyy($row['upload_date']));
					
					$row3++;
					$sl++;
				}
			
			
			
			
  
				ob_end_clean();
				header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
				header('Content-Disposition: attachment;filename="sx_agent_categorisation.xlsx"');
				header('Cache-Control: max-age=0');
				$objWriter = PHPExcel_IOFactory::createWriter($this->objPHPExcel , 'Excel2007');
				$objWriter->setIncludeCharts(TRUE);
				$objWriter->save('php://output');
			
			exit();  
            	
		}
	}
	
 }
 
 ?>