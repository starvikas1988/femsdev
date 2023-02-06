<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Qa_repeat_dashboard_boomsourcing extends CI_Controller {
	private $objPHPExcel;
	function __construct() {
		parent::__construct();
		$this->load->library('excel'); // Added excel library
		$this->load->helper(array('form', 'url'));
		$this->load->model('user_model');
		$this->load->model('Common_model');
		$this->load->model('Email_model'); // Added Email model 
		
		$this->objPHPExcel = new PHPExcel();
	}
	public function index()
	{
		if(check_logged_in()){
			$current_user=get_user_id();
			$ses_client_id=get_client_ids();
			$ses_process_id=get_process_ids();

			$data["aside_template"] = "qa_boomsourcing_aside/aside.php";
			$data["content_template"] = "qa_acpt_dashboard_boom/qa_repeat_dashboard_boomsourcing.php";
			$data["content_js"] = "qa_dashboard_productivity_boom/qa_repeat_dashboard_boomsourcing_js.php";

			$cond="";
			$from_date = $this->input->get('from_date');
			$to_date = $this->input->get('to_date');
			$process_id = $this->input->get('process_id');
			$ofc_id = $this->input->get('office_id');

			

			if($ofc_id!=""){
				$value = array_search('ALL', $ofc_id);

				if(in_array('ALL',$ofc_id)){
					$cond .='';

				}else{
					$office_id=implode('","', $ofc_id);
					$cond .=' AND office_id in ("'.$office_id.'")';

				}
			}
			
			if($process_id==""){
				$data['location_list'] = $this->Common_model->get_office_location_list();
			}else{
				$qSql="Select qd.process_id, qd.client_id, iac.user_id, iac.client_id, s.id, concat(s.fname, ' ', s.lname) as m_name, s.office_id, o.abbr, o.office_name as location from qa_boomsourcing_defect qd Left Join info_assign_client iac ON qd.client_id=iac.client_id Left Join signin s ON iac.user_id=s.id Left Join office_location o On s.office_id=o.abbr where qd.process_id='$process_id' and s.status=1 group by o.abbr";
				$data['location_list'] = $this->Common_model->get_query_result_array($qSql);
			}


		/////////////////////////////
			$data['process_list'] = array();

			if(is_access_qa_module()==true || $ses_client_id==0){
				$qaCond='';
			}else{
				$qaCond = "WHERE p.client_id in ( $ses_client_id ) AND p.id in ( $ses_process_id )";
			}

			$qSql = "SELECT p.id AS pro_id,p.name AS process_name FROM qa_boomsourcing_defect AS q
			INNER JOIN process AS p ON p.id=q.process_id $qaCond";
			$process_arr1 = $this->Common_model->get_query_result_array($qSql);

			$NotINnqSql = "( SELECT p.id FROM qa_boomsourcing_defect AS q
			INNER JOIN process AS p ON p.id=q.process_id $qaCond )";

			$qSql = "SELECT q.process_id AS pro_id,q.table_name AS process_name from qa_boomsourcing_defect AS q
			INNER JOIN process AS p ON p.id = FLOOR(q.process_id) $qaCond and q.process_id not in $NotINnqSql ";
			$process_arr2 = $this->Common_model->get_query_result_array($qSql);

			$marge_array=array_merge($process_arr1,$process_arr2);
			$data['process_list'] = $marge_array;
		////////////////////////////

			if($from_date=="") $from_date=CurrDate();
			else $from_date = mmddyy2mysql($from_date);

			if($to_date=="") $to_date=CurrDate();
			else $to_date = mmddyy2mysql($to_date);


			$data['tot_param'] = array();
			$data['tot_audit'] = array();
			$data['ovr95_100'] = array();
			$data['ovr90_95'] = array();
			$data['ovr85_90'] = array();
			$data['ovr84'] = array();

			if($this->input->get('btnView')=='View')
			{
				$query = $this->db->query('SELECT table_name, process_id, params_columns, process.name as process_name FROM qa_boomsourcing_defect LEFT JOIN process ON process.id='.$process_id.' Where FIND_IN_SET('.$process_id.',process_id)');
				$row = $query->row();

			/////////////////////////////////////////////
				$data['tot_param']=$row->params_columns;

				$table=$row->table_name;
				// $cond='';
				$ops_cond='';

				// if($office_id!="All") $cond .=' and office_id in ("'.$office_id.'")';
				// else $cond='';
				// if($office_id!='') $cond .=" AND office_id='$office_id'";

				$ops_cond .=" (date(audit_date) >= '$from_date' and date(audit_date) <= '$to_date') and audit_type in ('CQ Audit') $cond ";

				$qSql="Select count(DISTINCT agent_id) as value from $table left join signin on signin.id=agent_id where (overall_score<=100 and overall_score>=95) and $ops_cond";
				$data['ovr95_100'] = $this->Common_model->get_query_row_array($qSql);

				$qSql="Select count(DISTINCT agent_id) as value from $table left join signin on signin.id=agent_id where (overall_score<=94 and overall_score>=90) and $ops_cond";
				$data['ovr90_95'] = $this->Common_model->get_query_row_array($qSql);

				$qSql="Select count(DISTINCT agent_id) as value from $table left join signin on signin.id=agent_id where (overall_score<=89 and overall_score>=85) and $ops_cond";
				$data['ovr85_90'] = $this->Common_model->get_query_row_array($qSql);

				$qSql="Select count(DISTINCT agent_id) as value from $table left join signin on signin.id=agent_id where overall_score<=84 and $ops_cond";
				$data['ovr84'] = $this->Common_model->get_query_row_array($qSql);
				
				/*parameter wise code */
				$subQuery = "";
				if(!empty($row->params_columns))
				{
					$paramArr = explode(",",$row->params_columns);
					$numParam = count($paramArr);
					$i=1;
					foreach($paramArr as $param){
						if($i!=$numParam){
							$subQuery .= "(select count(*) from $table ss where ss.agent_id=$table.agent_id and ($param='No' or $param='Fail') and $ops_cond) as $param,";
						}else{
							$subQuery .= "(select count(*) from $table ss where ss.agent_id=$table.agent_id and ($param='No' or $param='Fail') and $ops_cond) as $param";
						}
						$i++;
					}
				}
				/* $qSql="Select agent_id, concat(signin.fname, ' ', signin.lname) as name, signin.office_id, count(*) as tot_adt,
						$subQuery
						from $table Left Join signin on $table.agent_id=signin.id where signin.status=1 AND overall_score<=84 and $ops_cond group by agent_id"; */
						
				$qSql="Select agent_id, concat(signin.fname, ' ', signin.lname) as name, signin.office_id, count(*) as tot_adt,
						$subQuery
						from $table Left Join signin on $table.agent_id=signin.id where signin.status=1 and $ops_cond group by agent_id";
				
				/* End */

				
				$data["tot_audit"] =  $this->Common_model->get_query_result_array($qSql);

			}
			$data["process_id"] = $process_id;
			// $data["office_id"] = $office_id;
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			$data["office_id"]=$ofc_id;

			$this->load->view("dashboard",$data);
		}
	}

///////////////////// AJAX Call ////////////////////////
	public function getLocation(){
		if(check_logged_in()){
			$pid=$this->input->post('pid');

			$qSql = "Select qd.process_id, qd.client_id, iac.user_id, iac.client_id, s.id, concat(s.fname, ' ', s.lname) as m_name, s.office_id, o.abbr, o.office_name from qa_boomsourcing_defect qd Left Join info_assign_client iac ON qd.client_id=iac.client_id Left Join signin s ON iac.user_id=s.id Left Join office_location o On s.office_id=o.abbr where qd.process_id='$pid' and s.dept_id=6 and s.status=1 group by o.abbr";
			echo json_encode($this->Common_model->get_query_result_array($qSql));
		}
	}

	/* public function getTarget(){
		if(check_logged_in()){
			$uid = trim($this->input->post('uid'));

			$qSql = "Select qd.process_id, qd.client_id, iac.user_id, iac.client_id, s.id, concat(s.fname, ' ', s.lname) as m_name, s.office_id, o.abbr, o.office_name from qa_boomsourcing_defect qd Left Join info_assign_client iac ON qd.client_id=iac.client_id Left Join signin s ON iac.user_id=s.id Left Join office_location o On s.office_id=o.abbr where qd.process_id='$pid' and s.dept_id=6 and s.status=1 group by o.abbr";
			echo json_encode($this->Common_model->get_query_result_array($qSql));
		}
	} */

	/* Export repeat Dashboard Report */
	public function download_repeat_rep(){
		if(check_logged_in()){
			 if($_GET['btnView'] == "View" &&  $_GET['get_process_id']!=""){
				 $this->generate_TNI_xls($_GET['get_process_id'],$_GET['get_location_id'],$_GET['from_date'],$_GET['to_date']);
			 }elseif($_GET['btnEmail'] == "Email" &&  $_GET['get_process_id']!=""){
				 $to_email = $this->input->get('send_email');
				 $this->generate_TNI_xls($_GET['get_process_id'],$_GET['get_location_id'],$_GET['from_date'],$_GET['to_date'],$_GET['btnEmail'],$to_email);
			 }else{
				redirect('Qa_repeat_dashboard_boomsourcing','refresh');
			}
			
		}
	}
	/* End */
	
	private function generate_TNI_xls($process_id, $locationArr=null, $from_date=null, $to_date=null, $email=null, $to_email=null ){
		if(check_logged_in()){
			$this->objPHPExcel->createSheet();
			$this->objPHPExcel->setActiveSheetIndex();
			$objWorksheet = $this->objPHPExcel->getActiveSheet();
			$objWorksheet->setTitle("Repeat Error Report");
			 
			// START GRIDLINES HIDE AND SHOW//
			$objWorksheet->setShowGridlines(true);
			// END GRIDLINES HIDE AND SHOW//
			//$this->objPHPExcel->getDefaultStyle()->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			
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
			$this->objPHPExcel->getActiveSheet()->getStyle("A2:B2")->getFill()->applyFromArray(
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
			$sheet->setCellValueByColumnAndRow(0, 1, "Repeat Error Dashboard");
			$sheet->mergeCells('A1:J1');
			    
				$col1=0;
				$row1=3; 
				
				// Agent Count % List
				/* $header_column = array("##","Agent Count");
						
				foreach($header_column as $val){
					if($col1 < 2){
						$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col1,2,$val);	
						$col1++;
					}
				} */
				$cond="";
				if($locationArr!=""){

					//$value = array_search('ALL', $locationArr);

					/* if($value==''){
						$office_id=implode('","', $locationArr);
						$cond .=' AND office_id in ("'.$office_id.'")';

					}else{
						$cond='';

					} */
					$locArr = explode(",",$locationArr);
					//print_r($locationArr);
					if(in_array('ALL',$locArr)){
						$cond .='';

					}else{
						$office_id=implode('","', $locArr);
						$cond .=' AND office_id in ("'.$office_id.'")';

					}
				}
				$query = $this->db->query('SELECT table_name, process_id, params_columns, process.name as process_name FROM qa_boomsourcing_defect LEFT JOIN process ON process.id='.$process_id.' Where FIND_IN_SET('.$process_id.',process_id)');
				$row = $query->row();

			
				$tot_param=$row->params_columns;

				$table=$row->table_name;
				// $cond='';
				$ops_cond='';
				$ops_cond .=" (date(audit_date) >= '$from_date' and date(audit_date) <= '$to_date') and audit_type in ('CQ Audit') $cond";

				$qSql="Select count(DISTINCT agent_id) as value from $table left join signin on signin.id=agent_id where (overall_score<=100 and overall_score>=95) and $ops_cond";
				$ovr95_100 = $this->Common_model->get_query_row_array($qSql);

				$qSql="Select count(DISTINCT agent_id) as value from $table left join signin on signin.id=agent_id where (overall_score<=94 and overall_score>=90) and $ops_cond";
				$ovr90_95 = $this->Common_model->get_query_row_array($qSql);

				$qSql="Select count(DISTINCT agent_id) as value from $table left join signin on signin.id=agent_id where (overall_score<=89 and overall_score>=85) and $ops_cond";
				$ovr85_90 = $this->Common_model->get_query_row_array($qSql);

				$qSql="Select count(DISTINCT agent_id) as value from $table left join signin on signin.id=agent_id where overall_score<=84 and $ops_cond";
				$ovr84 = $this->Common_model->get_query_row_array($qSql);
				
				
				$agent_count_array = array(array('100%-95%',$ovr95_100),array('95%-90%',$ovr90_95),array('90%-85%',$ovr85_90),array('Below 85%',$ovr84));
				
				
				/* $row1=3; 
				foreach($agent_count_array as $excel_val){
					$col1=0;
					$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col1,$row1,$excel_val[0]);	 
					$col1++;
					$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col1,$row1,$excel_val[1]['value']);
					$row1++;
				} */
				//exit;
				
				
				
				// Total Audit and Parameter percentage
				// CELL BACKGROUNG COLOR
				$countParam =explode(',',$tot_param);
				$colCount = (count($countParam)*2)+3;
				$column_index = \PHPExcel_Cell::stringFromColumnIndex($colCount);
				$this->objPHPExcel->getActiveSheet()->getStyle("A3:".$column_index."3")->getFill()->applyFromArray(
                $styleArray =array(
								'type' => PHPExcel_Style_Fill::FILL_SOLID,
								'startcolor' => array(
									 'rgb' => "35B8E0"
								),
								'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
							)
                );
				$col2=0;
				 
				$header_column2 = array("##","Agent", "Total Audit","Parameter");
				foreach($header_column2 as $val){
					if($col2 < 4){
						if($val == 'Parameter'){
							$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col2,3,$val);	
							$startcolumn_index = \PHPExcel_Cell::stringFromColumnIndex($col2);
							$endcolumn_index = \PHPExcel_Cell::stringFromColumnIndex($colCount);
							$this->objPHPExcel->getActiveSheet()->mergeCells($startcolumn_index.'3:'.$endcolumn_index.'3');
						}else{
						$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col2,4,$val);	
						}
						$col2++;
					}
				}	
				//$this->objPHPExcel->getActiveSheet()->mergeCells('E1:J1');
				$col2=3;
				$startcolumn_index = \PHPExcel_Cell::stringFromColumnIndex(0);
				$endcolumn_index = \PHPExcel_Cell::stringFromColumnIndex($colCount);
				$this->objPHPExcel->getActiveSheet()->getStyle($startcolumn_index."4:".$column_index."4")->getFill()->applyFromArray(
                $styleArray =array(
								'type' => PHPExcel_Style_Fill::FILL_SOLID,
								'startcolor' => array(
									 'rgb' => "35B8E0"
								),
								'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
							)
                );
				
				foreach($countParam as $param){
					$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col2,4,ucwords(str_replace('_', ' ', $param)));	
					$col2++;
					$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col2,4,ucwords(str_replace('_', ' ', $param))."(%)");	
					$col2++;
				}
				
			/*parameter wise code */
				$subQuery = "";
				if(!empty($row->params_columns))
				{
					$paramArr = explode(",",$row->params_columns);
					$numParam = count($paramArr);
					$i=1;
					foreach($paramArr as $param){
						if($i!=$numParam){
							$subQuery .= "(select count(*) from $table ss where ss.agent_id=$table.agent_id and ($param='No' or $param='Fail') and $ops_cond) as $param,";
						}else{
							$subQuery .= "(select count(*) from $table ss where ss.agent_id=$table.agent_id and ($param='No' or $param='Fail') and $ops_cond) as $param";
						}
						$i++;
					}
				}
				$qSql="Select agent_id, concat(signin.fname, ' ', signin.lname) as name, signin.office_id, count(*) as tot_adt,
						$subQuery
						from $table Left Join signin on $table.agent_id=signin.id where $ops_cond group by agent_id";
						
				//echo $qSql;
				//exit;
				$tot_audit_arr =  $this->Common_model->get_query_result_array($qSql);
				
			/* End */
			
			$row3 = 5;
			$sl = 1;
			foreach($tot_audit_arr as $tot_audit){
					$col3 = 0;
					$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col3,$row3,$sl);
					$col3++;
					$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col3,$row3,$tot_audit['name']);
					$col3++;
					$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col3,$row3,$tot_audit['tot_adt']);
					$col3++;
					$paramArr = explode(",",$row->params_columns);
					foreach($paramArr as $param){
						$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col3,$row3,$tot_audit[$param]);
						$col3++;
						$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col3,$row3,round(($tot_audit[$param]/$tot_audit['tot_adt'])*100,2)."%");
						$col3++;
					}
					$row3++;
					$sl++;
				}
			
			
			if(!empty($email) && $email =='Email'){
				//$this->load->library('email');
				/////////////////
					ob_end_clean();
					$path = './uploads/test_uploads/repeat_data.xlsx';
					$objWriter = PHPExcel_IOFactory::createWriter($this->objPHPExcel , 'Excel2007');
					$objWriter->setIncludeCharts(TRUE);
					$objWriter->save($path);
				//////////////////
				
					//$to = 'sumitra.bagchi@omindtech.com';
					$to = $to_email;
					$ebody = "Hi,<br>";
					$ebody .= "<p>Please find the repeat error data sheet attached.</p>";
					$ebody .= "<p>Regards,</p>";
					$ebody .= "<p>Digit Team</p>";
					$esubject = "Repeat Error Dashboard Data";
				
					$ecc="";
					$send = $this->Email_model->send_email_sox("",$to, $ecc, $ebody, $esubject, $path, $from_email, $from_name, $isBcc="Y");
					unlink($path);
					redirect('Qa_repeat_dashboard_boomsourcing/','refresh');				
			}else{
  
				ob_end_clean();
				header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
				header('Content-Disposition: attachment;filename="repeat_data.xlsx"');
				header('Cache-Control: max-age=0');
				$objWriter = PHPExcel_IOFactory::createWriter($this->objPHPExcel , 'Excel2007');
				$objWriter->setIncludeCharts(TRUE);
				$objWriter->save('php://output');
			}
			exit();  
            	
		}
	}
}
?>
