<?php

 class Qa_defect extends CI_Controller{

	public function __construct(){
		parent::__construct();
		$this->load->model('user_model');
		$this->load->model('Common_model');
	}


	


/////////////////Home  vikas//////////////////

	public function index(){
		if(check_logged_in())
		{
			$current_user = get_user_id();
			$data["aside_template"] = "qa/aside.php";
			$data["content_template"] = "qa_defect/qa_defect_feedback.php";
			$data["content_js"] = "qa_sea_world_js.php";
			

					$qSql = "SELECT qa.*,p.name as processName,cl.fullname as clientName from qa_defect qa LEFT JOIN process p ON p.id=qa.process_id LEFT JOIN client cl ON cl.id=qa.client_id where qa.is_active=1 order by qa.id ASC";

					$tabledata= $this->Common_model->get_query_result_array($qSql);

					//print_r($tabledata);
					
					foreach($tabledata as  $tablevalue){
						//echo $tablevalue['tablename'];

						$sql_last_auditdate = "SELECT ta.entry_date from ".$tablevalue['table_name']." ta  order by ta.id DESC LIMIT 0,1";
						
						 $last_auditdate[] = $this->Common_model->get_query_row_array($sql_last_auditdate);
					}


        $data["qa_defect_data"] = $tabledata;
        $data["qa_last_audit_date"] = $last_auditdate;
		$this->create_qa_defect_CSV($tabledata,$last_auditdate);

		$dn_link = base_url()."Qa_defect/download_qa_defect_CSV";
		$data['download_link']=$dn_link;
			$this->load->view("dashboard",$data);
		}
	}

	///////////////////vikas/////////////////////////////


	//////////////////////vikas ends///////////////////////
	

//////////////////////////////////////////////////////////////////////////////
	public function getTLname(){
		if(check_logged_in()){
			$aid=$this->input->post('aid');
			$qSql = "Select id, assigned_to, fusion_id, get_process_names(id) as process_name, office_id FROM signin where id = '$aid'";
				//echo $qSql;
			echo json_encode($this->Common_model->get_query_result_array($qSql));
		}
	}


///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

///////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////// QA Defect REPORT ////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////

	public function download_qa_defect_CSV()
	{
		$currDate=date("Y-m-d");
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$newfile="Qa Defect Audit List-'".$currDate."'.csv";

		header('Content-Disposition: attachment;  filename="'.$newfile.'"');
		readfile($filename);
	}

	public function create_qa_defect_CSV($rr,$ss)
	{
		$clientName = '';
		$filename = "./assets/reports/Report".get_user_id().".csv";
		$fopen = fopen($filename,"w+");
	
		 $header = array("Client", "Last Audit Date", "Process","Table Name/Campaign");

		$row = "";
		foreach($header as $data) $row .= ''.$data.',';
		fwrite($fopen,rtrim($row,",")."\r\n");
		$searches = array("\r", "\n", "\r\n");

			foreach($rr as $key=> $user){
				if($user['clientName'] == '' && $user['processName'] == 'ITEL'){
					$clientName = 'ITEL';

				}else{
					$clientName = $user['clientName'];
				}

				$row = '"'.$clientName.'",';
				$row .= '"'.$ss[$key]['entry_date'].'",';
				$row .= '"'.$user['processName'].'",';
				$row .= '"'.$user['table_name'].'",';

				fwrite($fopen,$row."\r\n");
			}
			fclose($fopen);
	}
}
