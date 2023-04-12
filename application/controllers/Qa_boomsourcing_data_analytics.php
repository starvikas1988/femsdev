<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Qa_boomsourcing_data_analytics extends CI_Controller {

	function __construct() {

		parent::__construct();
		$this->load->model('Common_model');
		$this->load->library('excel');
		$this->objPHPExcel = new PHPExcel();
	}

	/**
	* ===========================
	* Created By: SOURAV SARKAR
	* Created On: 15-12-2022
	* ===========================
	**/

	public function acceptance_dashboard(){

		if(check_logged_in()){

			$current_user     = get_user_id();
			$user_office_id   = get_user_office_id();
			$is_global_access = get_global_access();
						
			$data["aside_template"]   = "qa_boomsourcing_aside/aside.php";
			$data["content_template"] = "qa_boomsourcing/qa_acceptance_dashboard.php";
			$data["content_js"] = "qa_boomsourcing/qa_acceptance_dashboard_js.php";
			$data['location_list'] = $this->Common_model->get_office_location_list();

			$qaSql="SELECT id, fusion_id, xpoid, concat(fname,' ',lname) as qa_name from signin where status = 1 and dept_id = 5";
			$data['qa_list'] = $this->Common_model->get_query_result_array($qaSql);
			
			$tl_sql = "SELECT DISTINCT s.id, concat(s.fname,' ',s.lname) as tl_name FROM signin s join signin si on s.id = si.assigned_to where si.status = 1 and s.dept_id = 6";
			$data['tl_details'] = $this->Common_model->get_query_result_array($tl_sql);
			

			$qSql = "SELECT p.id AS pro_id,p.name AS process_name FROM qa_boomsourcing_defect AS q INNER JOIN process AS p ON p.id = q.process_id";
			$data['process_list'] = $this->Common_model->get_query_result_array($qSql);

			$ofc_id = $this->input->get('select_office') ? $this->input->get('select_office') : array("ALL");
			$process_id = $this->input->get('select_process') ? $this->input->get('select_process') : 578;
			$tl_id = $this->input->get('l1_super') ? $this->input->get('l1_super') : array("ALL");
			$qa_id = $this->input->get('select_qa') ? $this->input->get('select_qa') : array("ALL");	
			$from_date = $this->input->get('from_date') ? $this->input->get('from_date') : date('Y-m-01');	
			$to_date = $this->input->get('to_date') ? $this->input->get('to_date') : date('Y-m-d');	
			
			/*vertical List*/
			$qSql = "SELECT * FROM boomsourcing_vertical bv WHERE bv.is_active = 1";
			$data['vertical_list'] = $this->Common_model->get_query_result_array($qSql);

			/*campaign / process List*/
			$qSql = "SELECT * FROM boomsourcing_campaign bc WHERE bc.is_active = 1";
			$data['campaign_process_list'] = $this->Common_model->get_query_result_array($qSql);

			$data['selected_office'] = $ofc_id;
			$data['selected_process'] = $process_id;
			$data['selected_lob'] = $lob_id;
			$data['selected_tl'] = $tl_id;
			$data['selected_qa'] = $qa_id;
			$data['selected_from_date'] = $from_date;
			$data['selected_to_date'] = $to_date;

			$data['selected_vertical'] = $vertical = !empty($this->input->get("vertical")) ? $this->input->get("vertical") : '';
			$data['selected_campaign_process'] = $campaign_process = !empty($this->input->get("campaign_process")) ? $this->input->get("campaign_process") : '';

			$verticalCondition = "";
			if(!empty($vertical)){

				$verticalCondition = " AND vertical = $vertical";
			}

			$campaignProcessCondition = "";
			if(!empty($campaign_process)){

				$campaignProcessCondition = " AND campaign_process = $campaign_process";
			}

			$off_cond ='';

			if($ofc_id != ""){
				if(!in_array("ALL",$ofc_id, TRUE)){
					$off_id = implode('","', $ofc_id);
					$off_cond = ' AND s.office_id IN ("'.$off_id.'")';
				}
			}
			
			$tl_cond = "";

			if($tl_id != ""){
				if (!in_array("ALL",$tl_id, TRUE)){
					$l1_id=implode('","', $tl_id);
					$tl_cond =' AND s.assigned_to IN ("'.$l1_id.'")';
				}
			}

			$qa_cond = "";

			if($qa_id!=""){
				if (!in_array("ALL",$qa_id, TRUE)){
					$assigned_qa = implode('","', $qa_id);
					$qa_cond =' AND s.assigned_qa IN ("'.$assigned_qa.'")';
				}
			}
			
			$dateCondition = " (DATE(getEstToLocal(entry_date,$current_user)) >= '$from_date' and DATE(getEstToLocal(entry_date,$current_user)) <= '$to_date' )";

			$defect_data = $this->db->query("SELECT table_name, process_id, params_columns, process.name as process_name FROM qa_boomsourcing_defect LEFT JOIN process ON process.id = $process_id")->row_array();

			$table_name = $defect_data['table_name'];
			$pros_name = $defect_data['process_name'];
			$defect_process_id = $defect_data['process_id'];

			$sql = "SELECT COUNT(t.id) AS total_feedback,t.tl_id, (SELECT CONCAT(fname,' ',lname) AS tl_name FROM signin WHERE signin.id = t.tl_id) AS tl_name, SUM(CASE WHEN t.agnt_fd_acpt = 'Accepted' THEN 1 ELSE 0 END) AS accept_count, SUM(CASE WHEN t.agnt_fd_acpt = 'Not Accepted' THEN 1 ELSE 0 END) AS rebuttal_count,
				SUM(CASE WHEN t.audit_status = 1 THEN 1 ELSE 0 END) AS approved_audit,
				SUM(CASE WHEN t.agnt_fd_acpt IS null THEN 1 ELSE 0 END) AS not_accepted_count,
				SUM(CASE WHEN t.agnt_fd_acpt = 'Accepted' AND (TIME_TO_SEC(TIMEDIFF(t.agent_rvw_date, t.entry_date))/3600) <=24 THEN 1 ELSE 0 END) AS tntfr_hr_acpt FROM $table_name t LEFT JOIN signin s ON t.agent_id = s.id WHERE 1 AND $dateCondition $off_cond $tl_cond $qa_cond $verticalCondition $campaignProcessCondition GROUP BY t.tl_id";
				
			$data['tlwise_data'] = $tlwise_data = $this->Common_model->get_query_result_array($sql);

			$sql = "SELECT COUNT(t.id) AS total_feedback,t.entry_by, (SELECT CONCAT(fname,' ',lname) AS qa_name FROM signin WHERE signin.id = t.entry_by) AS qa_name, (SELECT d.description FROM signin si JOIN department d ON si.dept_id = d.id WHERE si.id = t.entry_by) AS department,SUM(CASE WHEN t.audit_status = 1 THEN 1 ELSE 0 END) AS approved_audit,SUM(CASE WHEN t.agnt_fd_acpt = 'Accepted' THEN 1 ELSE 0 END) AS accept_count, SUM(CASE WHEN t.agnt_fd_acpt = 'Not Accepted' THEN 1 ELSE 0 END) AS rebuttal_count,SUM(CASE WHEN t.agnt_fd_acpt IS null THEN 1 ELSE 0 END) AS not_accepted_count,SUM(CASE WHEN t.agnt_fd_acpt = 'Accepted' AND (TIME_TO_SEC(TIMEDIFF(t.agent_rvw_date, t.entry_date))/3600) <=24 THEN 1 ELSE 0 END) AS tntfr_hr_acpt FROM $table_name t LEFT JOIN signin s ON t.agent_id = s.id
				WHERE 1 AND $dateCondition $off_cond $tl_cond $qa_cond $verticalCondition $campaignProcessCondition GROUP BY t.entry_by";

			$data['qawise_data'] = $qawise_data = $this->Common_model->get_query_result_array($sql);

			$sql = "SELECT t.agent_id,COUNT(t.id) AS total_feedback,concat(s.fname,' ',s.lname) AS agent_name,s.xpoid,t.tl_id, (select concat(fname,' ',lname) AS tl_name FROM signin WHERE signin.id = t.tl_id) AS tl_name,SUM(CASE WHEN t.audit_status = 1 THEN 1 ELSE 0 END) AS approved_audit,SUM(CASE WHEN t.agnt_fd_acpt = 'Accepted' THEN 1 ELSE 0 END) AS accept_count, SUM(CASE WHEN t.agnt_fd_acpt = 'Not Accepted' THEN 1 ELSE 0 END) AS rebuttal_count,SUM(CASE WHEN t.agnt_fd_acpt IS null THEN 1 ELSE 0 END) AS not_accepted_count,SUM(CASE WHEN t.agnt_fd_acpt = 'Accepted' AND (TIME_TO_SEC(TIMEDIFF(t.agent_rvw_date, t.entry_date))/3600) <=24 THEN 1 ELSE 0 END) AS tntfr_hr_acpt FROM $table_name t LEFT JOIN signin s ON t.agent_id = s.id
				WHERE 1 AND $dateCondition $off_cond $tl_cond $qa_cond $verticalCondition $campaignProcessCondition GROUP BY t.agent_id";

			$data['agentwise_data'] = $agentwise_data =  $this->Common_model->get_query_result_array($sql);
			
			$sql = "SELECT '$pros_name' AS process_name,COUNT(t.id) AS total_feedback,SUM(CASE WHEN t.audit_status = 1 THEN 1 ELSE 0 END) AS approved_audit,SUM(CASE WHEN t.agnt_fd_acpt = 'Accepted' THEN 1 ELSE 0 END) AS accept_count,SUM(CASE WHEN t.agnt_fd_acpt = 'Not Accepted' THEN 1 ELSE 0 END) AS rebuttal_count,SUM(CASE WHEN t.agnt_fd_acpt is null THEN 1 ELSE 0 END) AS not_accepted_count,SUM(CASE WHEN t.agnt_fd_acpt = 'Accepted' and (TIME_TO_SEC(TIMEDIFF(t.agent_rvw_date, t.entry_date))/3600) <= 24 THEN 1 ELSE 0 END) AS tntfr_hr_acpt
				FROM $table_name t LEFT JOIN signin s ON t.agent_id = s.id WHERE 1 AND $dateCondition $off_cond $tl_cond $qa_cond $verticalCondition $campaignProcessCondition";
				$query = $this->db->query($sql);
				$data['overall_data'] = $ovrl_data = $query->row_array();
				$data['pro_wise_data'] = $pro_wise_data = $query->result_array();
				
			
			/*For Excel report*/
			$excel_report = $this->input->get('excel_report');
			if(!empty($excel_report) && $excel_report == true){

				$params = array("overall_data" => $ovrl_data,"pro_wise_data"=>$pro_wise_data,"tlwise_data" => $tlwise_data,"qawise_data" => $qawise_data,"agentwise_data" => $agentwise_data);
				$this->generate_acceptance_dashboard_excel_report($params);
				die;
			}

			$this->load->view('dashboard',$data);
		}
	}

	/**
	* ===========================
	* Created By: SOURAV SARKAR
	* Created On: 15-12-2022
	* ===========================
	**/

	public function get_audit_details(){

		if(check_logged_in()){

			$current_user     = get_user_id();

			$agent_id = $this->input->get('agentId');

			$ofc_id = $this->input->get('select_office') ? $this->input->get('select_office') : array("ALL");
			$process_id = $this->input->get('select_process') ? $this->input->get('select_process') : 578;
			$tl_id = $this->input->get('l1_super') ? $this->input->get('l1_super') : array("ALL");
			$qa_id = $this->input->get('select_qa') ? $this->input->get('select_qa') : array("ALL");	
			$from_date = $this->input->get('from_date') ? $this->input->get('from_date') : date('Y-m-01');	
			$to_date = $this->input->get('to_date') ? $this->input->get('to_date') : date('Y-m-d');	
			$vertical = !empty($this->input->get("vertical")) ? $this->input->get("vertical") : '';
			$campaign_process = !empty($this->input->get("campaign_process")) ? $this->input->get("campaign_process") : '';
			
			$verticalCondition = "";
			if(!empty($vertical)){

				$verticalCondition = " AND vertical = $vertical";
			}

			$campaignProcessCondition = "";
			if(!empty($campaign_process)){

				$campaignProcessCondition = " AND campaign_process = $campaign_process";
			}

			$off_cond = "";
			if($ofc_id != ""){
				if (!in_array("ALL",$ofc_id, TRUE)){
					$off_id = implode('","', $ofc_id);
					$off_cond = ' AND s.office_id IN ("'.$off_id.'")';
				}
			}
			
			$tl_cond = "";
			if($tl_id != ""){
				if (!in_array("ALL",$tl_id, TRUE)){
					$l1_id = implode('","', $tl_id);
					$tl_cond =' AND s.assigned_to IN ("'.$l1_id.'")';
				}
			}

			$qa_cond = "";
			if($qa_id != ""){
				if (!in_array("ALL",$qa_id, TRUE)){
					$assigned_qa = implode('","', $qa_id);
					$qa_cond =' AND s.assigned_qa IN ("'.$assigned_qa.'")';
				}
			}

			$dateCondition = " (DATE(getEstToLocal(entry_date,$current_user)) >= '$from_date' and DATE(getEstToLocal(entry_date,$current_user)) <= '$to_date' )";

			$defect_data = $this->db->query("SELECT table_name, process_id, params_columns, process.name as process_name FROM qa_boomsourcing_defect LEFT JOIN process ON process.id = $process_id")->row_array();

			$table_name = $defect_data['table_name'];
			$pros_name = $defect_data['process_name'];
			$defect_process_id = $defect_data['process_id'];

			$sql ="SELECT audit_date,call_date,audit_type,overall_score,call_duration,agent_rvw_date,mgnt_rvw_date,'$pros_name' AS process_name,ticket_id, (SELECT CONCAT(fname, ' ', lname) AS name FROM signin s WHERE s.id=qa.entry_by) AS auditor_name, (SELECT concat(fname, ' ', lname) AS name FROM signin s WHERE s.id=qa.agent_id) AS agent_name, (SELECT concat(fname, ' ', lname) AS name FROM signin s WHERE s.id=qa.tl_id) AS tl_name, (SELECT concat(fname, ' ', lname) AS name FROM signin sx WHERE sx.id=qa.mgnt_rvw_by) AS mgnt_rvw_name FROM $table_name qa LEFT JOIN signin s ON qa.agent_id = s.id WHERE 1 AND $dateCondition $off_cond $tl_cond $qa_cond AND qa.agent_id = $agent_id $verticalCondition $campaignProcessCondition";
			$agnt_data = $this->Common_model->get_query_result_array($sql);
			
			echo json_encode(array('data'=>$agnt_data));
		}
	}

	/**
	* ===========================
	* Created By: SOURAV SARKAR
	* Created On: 15-12-2022
	* ===========================
	**/

	private function generate_acceptance_dashboard_excel_report($params){

		if(check_logged_in()){

			extract($params);
			
			/*Acceptance Analytics*/

			$header = array('Feedback Raised','Accepted within 24 hour','Accepted post 24 hour','Feedback Not Accepted','Feedback Rebuttal Raised');
			$data = array(
							array('Acceptance Analytics'),
							$header,
							array($overall_data['total_feedback'],$overall_data['tntfr_hr_acpt'],($overall_data['accept_count'] - $overall_data['tntfr_hr_acpt']),$overall_data['not_accepted_count'],$overall_data['rebuttal_count'])
						);
			
			$objPHPExcel = new PHPExcel();
	    	$objWorksheet = $objPHPExcel->getActiveSheet();
			$objWorksheet->fromArray($data,NULL,'B2',true);

			$adjustment = (count($header)-1);
	        $currentColumn = 'B';
	        $columnIndex = PHPExcel_Cell::columnIndexFromString($currentColumn);
	        $adjustedColumnIndex = $columnIndex + $adjustment;
	        $adjustedColumn = PHPExcel_Cell::stringFromColumnIndex($adjustedColumnIndex - 1);

	        $objPHPExcel->getActiveSheet()->mergeCells('B2:'.$adjustedColumn.'2');

	        $titleStyleArray = array(
				'fill' => array(
					'type' => PHPExcel_Style_Fill::FILL_SOLID,
					'color' => array('rgb' => '188ae2')
				)
			);
	        $objWorksheet->getStyle('B2:'.$adjustedColumn.'3')->applyFromArray($titleStyleArray);

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
	        
	        $endingRow = (count($data)+1);
	        $objWorksheet->getStyle('B2:'.$adjustedColumn.$endingRow)->applyFromArray($style);

	        	/*Graph*/
	        	/*Bar Graph*/
	        	$dataSeriesLabels = array(
		            new PHPExcel_Chart_DataSeriesValues('String','Worksheet!$B$3:$F$3', NULL, 5)
		        );

		        $xAxisTickValues = array(
		            new PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$B$3:$F$3', NULL, 5)
		        );
		        
		        $dataSeriesValues = array(
		            new PHPExcel_Chart_DataSeriesValues('Number', 'Worksheet!$B$4:$F$4', NULL, 5)
		        );

		        /*Build the dataseries*/
		        $series = new PHPExcel_Chart_DataSeries(
		            PHPExcel_Chart_DataSeries::TYPE_BARCHART,       // plotType
		            PHPExcel_Chart_DataSeries::GROUPING_CLUSTERED,  // plotGrouping //GROUPING_STACKED
		            range(0, count($dataSeriesValues)-1),           // plotOrder
		            // $dataSeriesLabels,                              // plotLabel
		            null,
		            $xAxisTickValues,                               // plotCategory
		            $dataSeriesValues                               // plotValues
		        );
		        /*Set additional dataseries parameters*/
		        /*Make it a vertical column rather than a horizontal bar graph*/
		        $series->setPlotDirection(PHPExcel_Chart_DataSeries::DIRECTION_COL);
		        $layout = new PHPExcel_Chart_Layout();
				$layout->setShowVal(true);
		        /*Set the series in the plot area*/
		        $plotArea = new PHPExcel_Chart_PlotArea($layout, array($series));
		        /*Set the chart legend*/
		        $legend = new PHPExcel_Chart_Legend(PHPExcel_Chart_Legend::POSITION_BOTTOM, NULL, false);

		        $title = new PHPExcel_Chart_Title('');
		        $xAxisLabel = new PHPExcel_Chart_Title('');
		        $yAxisLabel = new PHPExcel_Chart_Title('');


		        /*Create the chart*/
		        $chart = new PHPExcel_Chart(
		            'chart1',       // name
		            $title,         // title
		            // $legend,     // legend
		            null,
		            $plotArea,      // plotArea
		            true,           // plotVisibleOnly
		            0,              // displayBlanksAs
		            $xAxisLabel,    // xAxisLabel
		            $yAxisLabel     // yAxisLabel
		        );

		        /*table start row 2 , total data array count , adding extra 2 column*/
		        $chartStartingRow = (2+count($data)+2); 
		        $chartEndingRow = ($chartStartingRow + 21);
		        $chart->setTopLeftPosition('B'.$chartStartingRow);
		        $chart->setBottomRightPosition('F'.$chartEndingRow);

		        /*Add the chart to the worksheet*/
		        $objWorksheet->addChart($chart);
		        /*Bar Graph*/

		        /*Pie Graph*/
	        	$dataseriesLabels = array(
					new PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$C$3:$F$3', null, 4),
				);
				
				$xAxisTickValues = array(
					new PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$C$3:$F$3', null, 4)
				);

				$dataSeriesValues = array(
					new PHPExcel_Chart_DataSeriesValues('Number', 'Worksheet!$C$4:$F$4', null, 4),
				);

				/*Build the dataseries*/
				$series = new PHPExcel_Chart_DataSeries(
					PHPExcel_Chart_DataSeries::TYPE_PIECHART,				// plotType
					// PHPExcel_Chart_DataSeries::GROUPING_STANDARD,		// plotGrouping
					null,
					range(0, count($dataSeriesValues)-1),					// plotOrder
					$dataseriesLabels,										// plotLabel
					$xAxisTickValues,										// plotCategory
					$dataSeriesValues										// plotValues
				);
				$series->setPlotDirection(PHPExcel_Chart_DataSeries::DIRECTION_COL);
				/*	Set up a layout object for the Pie chart*/
				$layout = new PHPExcel_Chart_Layout();
				$layout->setShowVal(TRUE);
				// $layout->setShowPercent(TRUE);

				/*	Set the series in the plot area*/
				$plotarea = new PHPExcel_Chart_PlotArea($layout, array($series));
				/*	Set the chart legend*/
				$legend = new PHPExcel_Chart_Legend(PHPExcel_Chart_Legend::POSITION_BOTTOM, null, false);
				
				$title = new PHPExcel_Chart_Title('Acceptance Analytics');


				//	Create the chart
				$chart = new PHPExcel_Chart(
					'chart1',		// name
					$title,		// title
					$legend,		// legend
					$plotarea,		// plotArea
					true,			// plotVisibleOnly
					0,				// displayBlanksAs
					null,			// xAxisLabel
					null			// yAxisLabel		- Pie charts don't have a Y-Axis
				);

		        $chart->setTopLeftPosition('F'.$chartStartingRow);
		        $chart->setBottomRightPosition('H'.$chartEndingRow);

		        /*Add the chart to the worksheet*/
		        $objWorksheet->addChart($chart);
		        /*Pie Chart*/

	        	/*Graph*/
	        	$endingRow = $chartEndingRow;
	        /*Acceptance Analytics*/

	        /*Process Wise Acceptance Analytics*/

	        unset($data);
		   $header = array('Process','Feedback Raised','Feedback Accepted within 24 hour','Feedback Accepted within 24 hour %','Feedback Accepted Post 24 hrs','Feedback Accepted Post 24 hrs %','Feedback Not Accepted','Feedback Not Accepted %','Rebuttal Raised','Rebuttal Raised %');
			$data = array(
							array('Process Wise Acceptance Analytics'),
							$header
						);

			foreach($pro_wise_data as $pro_data){

				$sub = array();

				if($pro_data['total_feedback']!=0||$pro_data['tntfr_hr_acpt']!=0){
					$accept_per = number_format(($pro_data['tntfr_hr_acpt']/$pro_data['total_feedback'])*100,2);
				}else{
					$accept_per = 0;
				}

				$post_24_acpt = $pro_data['accept_count'] - $pro_data['tntfr_hr_acpt'];

				if($pro_data['total_feedback']!=0||$post_24_acpt!=0){

				$post_24_accept_per = number_format(($post_24_acpt/$pro_data['total_feedback'])*100,2);

				}else{
					$post_24_accept_per = 0;
				}

				if($pro_data['total_feedback']!=0||$pro_data['accept_count']!=0){

					$overall_accept_per = number_format(($pro_data['accept_count']/$pro_data['total_feedback'])*100,2);
				}else{
					$overall_accept_per = 0;
				}

				if($pro_data['total_feedback']!=0||$pro_data['not_accepted_count']!=0){

					$not_accept_per = number_format(($pro_data['not_accepted_count']/$pro_data['total_feedback'])*100,2);
				}else{

					$not_accept_per = 0;
				}

				if($pro_data['total_feedback']!=0||$pro_data['rebuttal_count']!=0){

					$rebuttal_per = number_format(($pro_data['rebuttal_count']/$pro_data['total_feedback'])*100,2);
				}else{
					$rebuttal_per = 0;
				}

				$sub = array(
								$pro_data['process_name'],
								$pro_data['total_feedback'],
								$pro_data['tntfr_hr_acpt'],
								$accept_per.' %',
								$post_24_acpt,
								$post_24_accept_per.' %',
								$pro_data['not_accepted_count'],
								$not_accept_per.' %',
								$pro_data['rebuttal_count'],
								$rebuttal_per.' %'
							);

				$data[] = $sub;
			}
			if(!empty($overall_data)){

				$od = $overall_data;

				if($od['tntfr_hr_acpt']!= 0 || $od['total_feedback']!=0){

					$accept_per = number_format(($od['tntfr_hr_acpt']/$od['total_feedback'])*100,2);

				}else{
					$accept_per = 0;
				}

				$post_24_acpt = $od['accept_count'] - $od['tntfr_hr_acpt'];

				if($post_24_accept_per!= 0 || $od['total_feedback']!=0){

					$post_24_accept_per = number_format(($post_24_acpt/$od['total_feedback'])*100,2);

				}else{
					$post_24_accept_per = 0;
				}

				if($od['accept_count']!= 0 || $od['total_feedback']!=0){

					$overall_accept_per = number_format(($od['accept_count']/$od['total_feedback'])*100,2);

				}else{
					$overall_accept_per = 0;
				}

				if($od['not_accepted_count']!= 0 || $od['total_feedback']!=0){

					$not_accept_per = number_format(($od['not_accepted_count']/$od['total_feedback'])*100,2);

				}else{
					$not_accept_per = 0;
				}

				if($od['rebuttal_count']!= 0 || $od['total_feedback']!=0){

					$rebuttal_per = number_format(($od['rebuttal_count']/$od['total_feedback'])*100,2);

				}else{
					$rebuttal_per = 0;
				}

				$data[] = array("Grand Total",$od['total_feedback'],$od['tntfr_hr_acpt'],$accept_per.'%',$post_24_acpt,$post_24_accept_per.'%',$od['not_accepted_count'],$not_accept_per.'%',$od['rebuttal_count'],$rebuttal_per.'%');
			}
			

			$starting_row = ($endingRow+2);
			$objWorksheet->fromArray($data,NULL,'B'.$starting_row,true);

			$adjustment = (count($header)-1);
	        $currentColumn = 'B';
	        $columnIndex = PHPExcel_Cell::columnIndexFromString($currentColumn);
	        $adjustedColumnIndex = $columnIndex + $adjustment;
	        $adjustedColumn = PHPExcel_Cell::stringFromColumnIndex($adjustedColumnIndex - 1);

	        $objPHPExcel->getActiveSheet()->mergeCells('B'.$starting_row.':'.$adjustedColumn.$starting_row);

	        $objWorksheet->getStyle('B'.$starting_row.':'.$adjustedColumn.($starting_row + 1))->applyFromArray($titleStyleArray);

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
	        
	        $endingRow = ($starting_row + (count($data) - 1));
	        $objWorksheet->getStyle('B'.$starting_row.':'.$adjustedColumn.$endingRow)->applyFromArray($style);

	        /*Graph*/
	        $dataSeriesLabels = array(
	            new PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$C$'.($starting_row+1), NULL, 1),   //  'Forecast'
	            new PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$D$'.($starting_row+1), NULL, 1),
	            new PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$F$'.($starting_row+1), NULL, 1),
	            new PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$H$'.($starting_row+1), NULL, 1),
	            new PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$J$'.($starting_row+1), NULL, 1),
	        );

	        $xAxisTickValues = array(
	            new PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$B$'.($starting_row+2).':$B$'.($endingRow -1 ), NULL),    //  Q1 to Q4
	            new PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$B$'.($starting_row+2).':$B$'.($endingRow -1 ), NULL),
	            new PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$B$'.($starting_row+2).':$B$'.($endingRow -1 ), NULL),
	            new PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$B$'.($starting_row+2).':$B$'.($endingRow -1 ), NULL),
	            new PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$B$'.($starting_row+2).':$B$'.($endingRow -1 ), NULL),
	        );
	        
	        $dataSeriesValues = array(
	            new PHPExcel_Chart_DataSeriesValues('Number', 'Worksheet!$C$'.($starting_row+2).':$C$'.($endingRow -1 ), NULL),
	            new PHPExcel_Chart_DataSeriesValues('Number', 'Worksheet!$D$'.($starting_row+2).':$D$'.($endingRow -1 ), NULL),
	            new PHPExcel_Chart_DataSeriesValues('Number', 'Worksheet!$F$'.($starting_row+2).':$F$'.($endingRow -1 ), NULL),
	            new PHPExcel_Chart_DataSeriesValues('Number', 'Worksheet!$H$'.($starting_row+2).':$H$'.($endingRow -1 ), NULL),
	            new PHPExcel_Chart_DataSeriesValues('Number', 'Worksheet!$J$'.($starting_row+2).':$J$'.($endingRow -1 ), NULL)
	        );

	        /*Build the dataseries*/
	        $series = new PHPExcel_Chart_DataSeries(
	            PHPExcel_Chart_DataSeries::TYPE_BARCHART,       // plotType
	            PHPExcel_Chart_DataSeries::GROUPING_CLUSTERED,  // plotGrouping //GROUPING_STACKED
	            range(0, count($dataSeriesValues)-1),           // plotOrder
	            $dataSeriesLabels,                              // plotLabel
	            $xAxisTickValues,                               // plotCategory
	            $dataSeriesValues                               // plotValues
	        );
	        /*Set additional dataseries parameters*/
	        /*Make it a vertical column rather than a horizontal bar graph*/
	        $series->setPlotDirection(PHPExcel_Chart_DataSeries::DIRECTION_COL);

	        $layout = new PHPExcel_Chart_Layout();
			$layout->setShowVal(true);

	        /*Set the series in the plot area*/
	        $plotArea = new PHPExcel_Chart_PlotArea($layout, array($series));
	        /*Set the chart legend*/
	        $legend = new PHPExcel_Chart_Legend(PHPExcel_Chart_Legend::POSITION_BOTTOM, NULL, false);

	        $title = new PHPExcel_Chart_Title($objPHPExcel->getActiveSheet()->getCell('B'.$starting_row)->getValue());
	        $xAxisLabel = new PHPExcel_Chart_Title($objPHPExcel->getActiveSheet()->getCell('B'.($starting_row + 1))->getValue());
	        $yAxisLabel = new PHPExcel_Chart_Title('Feedback Count');


	        /*Create the chart*/
	        $chart = new PHPExcel_Chart(
	            'chart1',       // name
	            $title,         // title
	            $legend,        // legend
	            $plotArea,      // plotArea
	            true,           // plotVisibleOnly
	            0,              // displayBlanksAs
	            $xAxisLabel,    // xAxisLabel
	            $yAxisLabel     // yAxisLabel
	        );

	        /*table start row 2 , total data array count , adding extra 2 column*/
	        $chartStartingRow = ($endingRow + 2); 
	        $chartEndingRow = ($chartStartingRow + 33);
	        $chart->setTopLeftPosition('B'.$chartStartingRow);
	        $chart->setBottomRightPosition('L'.$chartEndingRow);

	        /*Add the chart to the worksheet*/
	        $objWorksheet->addChart($chart);
	        /*Graph*/

	        $endingRow = $chartEndingRow;

			/*Process Wise Acceptance Analytics*/

			/*TL Wise Acceptance Analytics*/

			unset($data);
		   $header = array('TL Name','Feedback Raised','Feedback Accepted within 24 hour','Feedback Accepted within 24 hour %','Feedback Accepted Post 24 hrs','Feedback Accepted Post 24 hrs %','Feedback Not Accepted','Feedback Not Accepted %','Rebuttal Raised','Rebuttal Raised %');
			$data = array(
							array('TL Wise Acceptance Analytics'),
							$header
						);
			
			foreach($tlwise_data as $tl_data){

				$sub = array();

				if($tl_data['total_feedback']!=0||$tl_data['tntfr_hr_acpt']!=0){

					$accept_per = number_format(($tl_data['tntfr_hr_acpt']/$tl_data['total_feedback'])*100,2);

				}else{
					$accept_per = 0;
				}

				$post_24_acpt = $tl_data['accept_count'] - $tl_data['tntfr_hr_acpt'];

				if($tl_data['total_feedback']!=0||$post_24_acpt!=0){

					$post_24_accept_per = number_format(($post_24_acpt/$tl_data['total_feedback'])*100,2);

				}else{
					$post_24_accept_per = 0;
				}

				if($tl_data['total_feedback']!=0||$tl_data['accept_count']!=0){

					$overall_accept_per = number_format(($tl_data['accept_count']/$tl_data['total_feedback'])*100,2);

				}else{
					$overall_accept_per = 0;
				}

				if($tl_data['total_feedback']!=0||$tl_data['not_accepted_count']!=0){

					$not_accept_per = number_format(($tl_data['not_accepted_count']/$tl_data['total_feedback'])*100,2);

				}else{
					$not_accept_per = 0;
				}

				if($tl_data['total_feedback']!=0||$tl_data['rebuttal_count']!=0){

					$rebuttal_per = number_format(($tl_data['rebuttal_count']/$tl_data['total_feedback'])*100,2);

				}else{
					$rebuttal_per = 0;
				}

				$sub = array(
								$tl_data['tl_name'],
								$tl_data['total_feedback'],
								$tl_data['tntfr_hr_acpt'],
								$accept_per.' %',
								$post_24_acpt,
								$post_24_accept_per.' %',
								$tl_data['not_accepted_count'],
								$not_accept_per.' %',
								$tl_data['rebuttal_count'],
								$rebuttal_per.' %'
							);

				$data[] = $sub;
			}

			$starting_row = ($endingRow+2);
			$objWorksheet->fromArray($data,NULL,'B'.$starting_row,true);

			$adjustment = (count($header)-1);
	        $currentColumn = 'B';
	        $columnIndex = PHPExcel_Cell::columnIndexFromString($currentColumn);
	        $adjustedColumnIndex = $columnIndex + $adjustment;
	        $adjustedColumn = PHPExcel_Cell::stringFromColumnIndex($adjustedColumnIndex - 1);

	        $objPHPExcel->getActiveSheet()->mergeCells('B'.$starting_row.':'.$adjustedColumn.$starting_row);

	        $objWorksheet->getStyle('B'.$starting_row.':'.$adjustedColumn.($starting_row + 1))->applyFromArray($titleStyleArray);

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
	        
	        $endingRow = ($starting_row + (count($data) - 1));
	        $objWorksheet->getStyle('B'.$starting_row.':'.$adjustedColumn.$endingRow)->applyFromArray($style);

	        /*Graph*/
	        $dataSeriesLabels = array(
	            new PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$C$'.($starting_row+1), NULL, 1),   //  'Forecast'
	            new PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$D$'.($starting_row+1), NULL, 1),
	            new PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$F$'.($starting_row+1), NULL, 1),
	            new PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$H$'.($starting_row+1), NULL, 1),
	            new PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$J$'.($starting_row+1), NULL, 1),
	        );

	        $xAxisTickValues = array(
	            new PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$B$'.($starting_row+2).':$B$'.$endingRow, NULL),    //  Q1 to Q4
	            new PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$B$'.($starting_row+2).':$B$'.$endingRow, NULL),
	            new PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$B$'.($starting_row+2).':$B$'.$endingRow, NULL),
	            new PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$B$'.($starting_row+2).':$B$'.$endingRow, NULL),
	            new PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$B$'.($starting_row+2).':$B$'.$endingRow, NULL),
	        );
	        
	        $dataSeriesValues = array(
	            new PHPExcel_Chart_DataSeriesValues('Number', 'Worksheet!$C$'.($starting_row+2).':$C$'.$endingRow, NULL),
	            new PHPExcel_Chart_DataSeriesValues('Number', 'Worksheet!$D$'.($starting_row+2).':$D$'.$endingRow, NULL),
	            new PHPExcel_Chart_DataSeriesValues('Number', 'Worksheet!$F$'.($starting_row+2).':$F$'.$endingRow, NULL),
	            new PHPExcel_Chart_DataSeriesValues('Number', 'Worksheet!$H$'.($starting_row+2).':$H$'.$endingRow, NULL),
	            new PHPExcel_Chart_DataSeriesValues('Number', 'Worksheet!$J$'.($starting_row+2).':$J$'.$endingRow, NULL)
	        );

	        /*Build the dataseries*/
	        $series = new PHPExcel_Chart_DataSeries(
	            PHPExcel_Chart_DataSeries::TYPE_BARCHART,       // plotType
	            PHPExcel_Chart_DataSeries::GROUPING_CLUSTERED,  // plotGrouping //GROUPING_STACKED
	            range(0, count($dataSeriesValues)-1),           // plotOrder
	            $dataSeriesLabels,                              // plotLabel
	            $xAxisTickValues,                               // plotCategory
	            $dataSeriesValues                               // plotValues
	        );
	        /*Set additional dataseries parameters*/
	        /*Make it a vertical column rather than a horizontal bar graph*/
	        $series->setPlotDirection(PHPExcel_Chart_DataSeries::DIRECTION_COL);

	        $layout = new PHPExcel_Chart_Layout();
			$layout->setShowVal(true);

	        /*Set the series in the plot area*/
	        $plotArea = new PHPExcel_Chart_PlotArea($layout, array($series));
	        /*Set the chart legend*/
	        $legend = new PHPExcel_Chart_Legend(PHPExcel_Chart_Legend::POSITION_BOTTOM, NULL, false);

	        $title = new PHPExcel_Chart_Title($objPHPExcel->getActiveSheet()->getCell('B'.$starting_row)->getValue());
	        $xAxisLabel = new PHPExcel_Chart_Title($objPHPExcel->getActiveSheet()->getCell('B'.($starting_row + 1))->getValue());
	        $yAxisLabel = new PHPExcel_Chart_Title('Feedback Count');


	        /*Create the chart*/
	        $chart = new PHPExcel_Chart(
	            'chart1',       // name
	            $title,         // title
	            $legend,        // legend
	            $plotArea,      // plotArea
	            true,           // plotVisibleOnly
	            0,              // displayBlanksAs
	            $xAxisLabel,    // xAxisLabel
	            $yAxisLabel     // yAxisLabel
	        );

	        /*table start row 2 , total data array count , adding extra 2 column*/
	        $chartStartingRow = ($endingRow + 2); 
	        $chartEndingRow = ($chartStartingRow + 33);
	        $chart->setTopLeftPosition('B'.$chartStartingRow);
	        $chart->setBottomRightPosition('L'.$chartEndingRow);

	        /*Add the chart to the worksheet*/
	        $objWorksheet->addChart($chart);
	        /*Graph*/

	        $endingRow = $chartEndingRow;

			/*TL Wise Acceptance Analytics*/

			/*QA Wise Acceptance Analytics*/

			unset($data);
			$header = array('QA Name','Department','Feedback Raised','Feedback Accepted within 24 hour','Feedback Accepted within 24 hour %','Feedback Accepted Post 24 hrs','Feedback Accepted Post 24 hrs %','Feedback Not Accepted','Feedback Not Accepted %','Rebuttal Raised','Rebuttal Raised %');
			$data = array(
							array('QA Wise Acceptance Analytics'),
							$header
						);
			
			foreach($qawise_data as $qa_data){

				$sub = array();

				if($qa_data['total_feedback']!=0||$qa_data['tntfr_hr_acpt']!=0){

					$accept_per = number_format(($qa_data['tntfr_hr_acpt']/$qa_data['total_feedback'])*100,2);

				}else{
					$accept_per = 0;
				}

				$post_24_acpt = $qa_data['accept_count'] - $qa_data['tntfr_hr_acpt'];

				if($qa_data['total_feedback']!=0||$post_24_acpt!=0){

					$post_24_accept_per = number_format(($post_24_acpt/$qa_data['total_feedback'])*100,2);

				}else{
					$post_24_accept_per = 0;
				}

				if($qa_data['total_feedback']!=0||$qa_data['accept_count']!=0){

					$overall_accept_per = number_format(($qa_data['accept_count']/$qa_data['total_feedback'])*100,2);

				}else{
					$overall_accept_per = 0;
				}

				if($qa_data['total_feedback']!=0||$qa_data['not_accepted_count']!=0){

					$not_accept_per = number_format(($qa_data['not_accepted_count']/$qa_data['total_feedback'])*100,2);

				}else{
					$not_accept_per = 0;
				}

				if($qa_data['total_feedback']!=0||$qa_data['rebuttal_count']!=0){

					$rebuttal_per = number_format(($qa_data['rebuttal_count']/$qa_data['total_feedback'])*100,2);

				}else{
					$rebuttal_per = 0;
				}

				$sub = array(
								$qa_data['qa_name'],
								$qa_data['department'],
								$qa_data['total_feedback'],
								$qa_data['tntfr_hr_acpt'],
								$accept_per.' %',
								$post_24_acpt,
								$post_24_accept_per.' %',
								$qa_data['not_accepted_count'],
								$not_accept_per.' %',
								$qa_data['rebuttal_count'],
								$rebuttal_per.' %'
							);

				$data[] = $sub;
			}

			$starting_row = ($endingRow+2);
			$objWorksheet->fromArray($data,NULL,'B'.$starting_row,true);

			$adjustment = (count($header)-1);
	        $currentColumn = 'B';
	        $columnIndex = PHPExcel_Cell::columnIndexFromString($currentColumn);
	        $adjustedColumnIndex = $columnIndex + $adjustment;
	        $adjustedColumn = PHPExcel_Cell::stringFromColumnIndex($adjustedColumnIndex - 1);

	        $objPHPExcel->getActiveSheet()->mergeCells('B'.$starting_row.':'.$adjustedColumn.$starting_row);

	        $objWorksheet->getStyle('B'.$starting_row.':'.$adjustedColumn.($starting_row + 1))->applyFromArray($titleStyleArray);

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
	        
	        $endingRow = ($starting_row + (count($data) - 1));
	        $objWorksheet->getStyle('B'.$starting_row.':'.$adjustedColumn.$endingRow)->applyFromArray($style);

	        /*Graph*/
	        $dataSeriesLabels = array(
	            new PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$D$'.($starting_row+1), NULL, 1),   //  'Forecast'
	            new PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$E$'.($starting_row+1), NULL, 1),
	            new PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$G$'.($starting_row+1), NULL, 1),
	            new PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$I$'.($starting_row+1), NULL, 1),
	            new PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$K$'.($starting_row+1), NULL, 1),
	        );

	        $xAxisTickValues = array(
	            new PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$B$'.($starting_row+2).':$B$'.$endingRow, NULL),    //  Q1 to Q4
	            new PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$B$'.($starting_row+2).':$B$'.$endingRow, NULL),
	            new PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$B$'.($starting_row+2).':$B$'.$endingRow, NULL),
	            new PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$B$'.($starting_row+2).':$B$'.$endingRow, NULL),
	            new PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$B$'.($starting_row+2).':$B$'.$endingRow, NULL),
	        );
	        
	        $dataSeriesValues = array(
	            new PHPExcel_Chart_DataSeriesValues('Number', 'Worksheet!$D$'.($starting_row+2).':$D$'.$endingRow, NULL),
	            new PHPExcel_Chart_DataSeriesValues('Number', 'Worksheet!$E$'.($starting_row+2).':$E$'.$endingRow, NULL),
	            new PHPExcel_Chart_DataSeriesValues('Number', 'Worksheet!$G$'.($starting_row+2).':$G$'.$endingRow, NULL),
	            new PHPExcel_Chart_DataSeriesValues('Number', 'Worksheet!$I$'.($starting_row+2).':$I$'.$endingRow, NULL),
	            new PHPExcel_Chart_DataSeriesValues('Number', 'Worksheet!$K$'.($starting_row+2).':$K$'.$endingRow, NULL)
	        );

	        /*Build the dataseries*/
	        $series = new PHPExcel_Chart_DataSeries(
	            PHPExcel_Chart_DataSeries::TYPE_BARCHART,       // plotType
	            PHPExcel_Chart_DataSeries::GROUPING_CLUSTERED,  // plotGrouping //GROUPING_STACKED
	            range(0, count($dataSeriesValues)-1),           // plotOrder
	            $dataSeriesLabels,                              // plotLabel
	            $xAxisTickValues,                               // plotCategory
	            $dataSeriesValues                               // plotValues
	        );
	        /*Set additional dataseries parameters*/
	        /*Make it a vertical column rather than a horizontal bar graph*/
	        $series->setPlotDirection(PHPExcel_Chart_DataSeries::DIRECTION_COL);

	        $layout = new PHPExcel_Chart_Layout();
			$layout->setShowVal(true);

	        /*Set the series in the plot area*/
	        $plotArea = new PHPExcel_Chart_PlotArea($layout, array($series));
	        /*Set the chart legend*/
	        $legend = new PHPExcel_Chart_Legend(PHPExcel_Chart_Legend::POSITION_BOTTOM, NULL, false);

	        $title = new PHPExcel_Chart_Title($objPHPExcel->getActiveSheet()->getCell('B'.$starting_row)->getValue());
	        $xAxisLabel = new PHPExcel_Chart_Title($objPHPExcel->getActiveSheet()->getCell('B'.($starting_row + 1))->getValue());
	        $yAxisLabel = new PHPExcel_Chart_Title('Feedback Count');


	        /*Create the chart*/
	        $chart = new PHPExcel_Chart(
	            'chart1',       // name
	            $title,         // title
	            $legend,        // legend
	            $plotArea,      // plotArea
	            true,           // plotVisibleOnly
	            0,              // displayBlanksAs
	            $xAxisLabel,    // xAxisLabel
	            $yAxisLabel     // yAxisLabel
	        );

	        /*table start row 2 , total data array count , adding extra 2 column*/
	        $chartStartingRow = ($endingRow + 2); 
	        $chartEndingRow = ($chartStartingRow + 33);
	        $chart->setTopLeftPosition('B'.$chartStartingRow);
	        $chart->setBottomRightPosition('L'.$chartEndingRow);

	        /*Add the chart to the worksheet*/
	        $objWorksheet->addChart($chart);
	        /*Graph*/

	        $endingRow = $chartEndingRow;

			/*QA Wise Acceptance Analytics*/

			/*Agent Wise Acceptance Analytics*/
			unset($data);

			$header = array('Agent Name','Feedback Raised','Feedback Accepted within 24 hour','Feedback Accepted within 24 hour %','Feedback Accepted Post 24 hrs','Feedback Accepted Post 24 hrs %','Feedback Not Accepted','Feedback Not Accepted %','Rebuttal Raised','Rebuttal Raised %');
			$data = array(
							array('Agent Wise Acceptance Analytics'),
							$header
						);
			$i = 1;
			foreach($agentwise_data as $agent_data){

				$sub = array();

				if($agent_data['total_feedback']!=0||$agent_data['tntfr_hr_acpt']!=0){

					$accept_per = number_format(($agent_data['tntfr_hr_acpt']/$agent_data['total_feedback'])*100,2);

				}else{
					$accept_per = 0;
				}

				$post_24_acpt = $agent_data['accept_count'] - $agent_data['tntfr_hr_acpt'];

				if($post_24_acpt!=0||$agent_data['total_feedback']!=0){

					$post_24_accept_per = number_format(($post_24_acpt/$agent_data['total_feedback'])*100,2);

				}else{
					$post_24_accept_per = 0;
				}

				if($agent_data['accept_count']!=0||$agent_data['total_feedback']!=0){

					$overall_accept_per = number_format(($agent_data['accept_count']/$agent_data['total_feedback'])*100,2);

				}else{
					$overall_accept_per = 0;
				}

				if($agent_data['not_accepted_count']!=0||$agent_data['total_feedback']!=0){

					$not_accept_per = number_format(($agent_data['not_accepted_count']/$agent_data['total_feedback'])*100,2);

				}else{
					$not_accept_per = 0;
				}

				if($agent_data['rebuttal_count']!=0||$agent_data['total_feedback']!=0){

					$rebuttal_per = number_format(($agent_data['rebuttal_count']/$agent_data['total_feedback'])*100,2);

				}else{
					$rebuttal_per = 0;
				}

				$sub = array(
								ucwords(strtolower($agent_data['agent_name'])),
								$agent_data['total_feedback'],
								$agent_data['tntfr_hr_acpt'],
								$accept_per.' %',
								$post_24_acpt,
								$post_24_accept_per.' %',
								//$agent_data['accept_count'],
								//$overall_accept_per.' %',
								$agent_data['not_accepted_count'],
								$not_accept_per.' %',
								$agent_data['rebuttal_count'],
								$rebuttal_per.' %'
							);

				$data[] = $sub;
			}

			$starting_row = ($endingRow+2);
			$objWorksheet->fromArray($data,NULL,'B'.$starting_row,true);

			$adjustment = (count($header)-1);
	        $currentColumn = 'B';
	        $columnIndex = PHPExcel_Cell::columnIndexFromString($currentColumn);
	        $adjustedColumnIndex = $columnIndex + $adjustment;
	        $adjustedColumn = PHPExcel_Cell::stringFromColumnIndex($adjustedColumnIndex - 1);

	        $objPHPExcel->getActiveSheet()->mergeCells('B'.$starting_row.':'.$adjustedColumn.$starting_row);

	        $objWorksheet->getStyle('B'.$starting_row.':'.$adjustedColumn.($starting_row + 1))->applyFromArray($titleStyleArray);

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
	        
	        $endingRow = ($starting_row + (count($data) - 1));
	        $objWorksheet->getStyle('B'.$starting_row.':'.$adjustedColumn.$endingRow)->applyFromArray($style);

			/*Agent Wise Acceptance Analytics*/

			$objPHPExcel->getActiveSheet()->getStyle('A1')
					    ->getNumberFormat()->applyFromArray( 
					        array( 
					            'code' => PHPExcel_Style_NumberFormat::FORMAT_PERCENTAGE_00
					        )
					    );
	        foreach (range('B', 'Z') as $column){
			   $objPHPExcel->getActiveSheet()->getColumnDimension($column)->setAutoSize(true);
			}

	        ob_end_clean();
	        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	        header('Content-Disposition: attachment;filename="acceptance-dashboard-report.xlsx' );
	        header('Cache-Control: max-age=0');
	        $writer = PHPExcel_IOFactory::createWriter($objPHPExcel , 'Excel2007');
	        $writer->setIncludeCharts(TRUE);
	        $writer->save('php://output');
		}
	}


	/**
	* ===========================
	* Created By: SOURAV SARKAR
	* Created On: 15-12-2022
	* ===========================
	**/

	public function parameter_wise_dashboard(){

		if(check_logged_in()){

			$current_user     = get_user_id();

			$data = array();
			$data['aside_template'] = "qa_boomsourcing_aside/aside.php";
			$data['content_template'] = "qa_boomsourcing/parameter_wise_dashboard.php";
			$data['content_js'] = "qa_boomsourcing/parameter_wise_dashboard_js.php";

			/*QA List*/
			$sql = "SELECT s.id as qa_id,CONCAT(s.fname,' ',s.lname) as qa_name,r.folder,d.folder FROM `signin` s LEFT JOIN role r ON s.role_id=r.id LEFT JOIN department d ON s.dept_id = d.id WHERE d.folder='qa' AND r.folder='agent'";
			$data['qa_list'] = $this->Common_model->get_query_result_array($sql);

			/*L1 List*/
			$sql = "SELECT s.id as l1_id,CONCAT(s.fname,' ',s.lname) as l1_name,r.folder,d.folder FROM `signin` s LEFT JOIN role r ON s.role_id=r.id LEFT JOIN department d ON s.dept_id = d.id WHERE d.folder='operations' AND r.folder='tl'";
			$data['l1_list'] = $this->Common_model->get_query_result_array($sql);

			$qSql="SELECT id AS agent_id, concat(fname, ' ', lname) AS agent_name, assigned_to, fusion_id, xpoid FROM signin WHERE role_id IN (SELECT id FROM role WHERE folder ='agent') AND dept_id IN(6,14) AND is_assign_client(id,275) AND status=1 ORDER BY agent_name";
			$data['agent_list'] = $this->Common_model->get_query_result_array($qSql);

			$qSql = "SELECT p.id AS process_id,p.name AS process_name FROM qa_boomsourcing_defect AS q INNER JOIN process AS p ON p.id = q.process_id";
			$data['process_list'] = $this->Common_model->get_query_result_array($qSql);

			/*vertical List*/
			$qSql = "SELECT * FROM boomsourcing_vertical bv WHERE bv.is_active = 1";
			$data['vertical_list'] = $this->Common_model->get_query_result_array($qSql);

			/*campaign / process List*/
			$qSql = "SELECT * FROM boomsourcing_campaign bc WHERE bc.is_active = 1";
			$data['campaign_process_list'] = $this->Common_model->get_query_result_array($qSql);

			/*Filter*/
			$data['selected_parameter_type'] = $parameter_type = !empty($this->input->get('parameter_type')) ? $this->input->get('parameter_type') : 'normal';

			$data['selected_qa'] = $select_qa = !empty($this->input->get('select_qa')) ? $this->input->get('select_qa') : '';
			$data['selected_l1'] = $select_l1 = !empty($this->input->get('select_l1')) ? $this->input->get('select_l1') : '';
			$data['selected_agent'] = $select_agent = !empty($this->input->get('select_agent')) ? $this->input->get('select_agent') : '';
			$data['selected_find_by'] = $find_by = !empty($this->input->get("find_by")) ? $this->input->get("find_by") : '';

			$data['selected_vertical'] = $vertical = !empty($this->input->get("vertical")) ? $this->input->get("vertical") : '';
			$data['selected_campaign_process'] = $campaign_process = !empty($this->input->get("campaign_process")) ? $this->input->get("campaign_process") : '';

			$verticalCondition = "";
			if(!empty($vertical)){

				$verticalCondition = " AND vertical = $vertical";
			}

			$campaignProcessCondition = "";
			if(!empty($campaign_process)){

				$campaignProcessCondition = " AND campaign_process = $campaign_process";
			}

			$qa_l1_agent_condition = "";
			if(!empty($find_by)){

				switch ($find_by) {
					case 'QA':
						$qa_l1_agent_condition = " AND qa.entry_by = $select_qa";
						break;
					case 'L1':
						$qa_l1_agent_condition = " AND qa.tl_id = $select_l1";
						break;
					case 'Agent':
						$qa_l1_agent_condition = " AND qa.agent_id = $select_agent";
						break;
					default:
						
						break;
				}
			}

			$data['selected_process'] = $process_id = !empty($this->input->get('select_process')) ? $this->input->get('select_process') : 578;
			$data['data_show_type'] = $rep_type = !empty($this->input->get('rep_type')) ? $this->input->get('rep_type') : 'monthly';

			$dateCondition = "";
			if(in_array($rep_type,['daily','weekly'])){

				$data['select_from_date'] = $start_date = date('Y-m-d',strtotime($this->input->get('select_from_date')));
				$data['select_to_date'] = $end_date = date('Y-m-d',strtotime($this->input->get('select_to_date')));

				/*$dateCondition = "AND DATE(qa.audit_date) >= '$start_date' AND DATE(qa.audit_date) <= '$end_date'";*/

				$dateCondition = "AND (DATE(getEstToLocal(entry_date,$current_user)) >= '$start_date' and DATE(getEstToLocal(entry_date,$current_user)) <= '$end_date' )";
			}
			elseif($rep_type =='monthly'){

				$data['selected_month'] = $month = !empty($this->input->get('select_month')) ? $this->input->get('select_month') : date('m');
				$data['selected_year'] = $year = !empty($this->input->get('select_year')) ? $this->input->get('select_year') : date('Y');

				/*$dateCondition = "AND MONTH(qa.audit_date) = $month AND YEAR(qa.audit_date) = $year";*/

				$dateCondition = "AND (MONTH(getEstToLocal(entry_date,$current_user)) = $month AND YEAR(getEstToLocal(entry_date,$current_user)) = $year )";
			}
			else
			{
				$start_date = date('Y-m-d');
				$end_date = date('Y-m-d');
				/*$dateCondition = "AND DATE(qa.audit_date) >= '$start_date' AND DATE(qa.audit_date) <= '$end_date'";*/
				$dateCondition = "AND (DATE(getEstToLocal(entry_date,$current_user)) >= '$start_date' and DATE(getEstToLocal(entry_date,$current_user)) <= '$end_date' )";
			}	

			$sql = "SELECT qd.table_name,qd.params_columns,qd.fatal_param,qd.process_id FROM qa_boomsourcing_defect qd LEFT JOIN process p ON p.id = $process_id WHERE qd.is_active = 1";
			$qa_defects = $this->Common_model->get_query_result_array($sql);

			$final_data = array();
			$lob_wise_parameters = array();
			foreach($qa_defects as $qa_defect){

				$table = $qa_defect['table_name'];
				$all_param_columns = explode(',',$qa_defect['params_columns']);
				$fatal_param = explode(',',$qa_defect['fatal_param']);

				if($parameter_type == 'normal'){
					/*For normal parameters*/
					$params_columns = array_diff($all_param_columns,$fatal_param);
				}
				else
				{
					/*For fatal parameters*/
					$params_columns = $fatal_param;
				}

				$pqr_qr = "";
				$comma ="";
				foreach ($params_columns as $key => $param) {
					$pqr_qr .= $comma."sum(CASE WHEN $param = 'Yes' THEN 1 ELSE 0
					END) as ".$param."_yes,sum(CASE WHEN $param = 'No' THEN 1 ELSE 0
					END) as ".$param."_no,sum(CASE WHEN $param = 'N/A' THEN 1 ELSE 0
					END) as ".$param."_na";
					$comma =",";
				}

				$sql = "SELECT $pqr_qr FROM $table qa WHERE 1 $dateCondition $qa_l1_agent_condition $verticalCondition $campaignProcessCondition";
				$final_data[$table] = !empty(array_filter($this->db->query($sql)->row_array())) ? $this->db->query($sql)->row_array() : '';

				$lob_wise_parameters[$table] = $params_columns;
			}

			/*For Excel report*/
			$excel_report = $this->input->get('excel_report');
			if(!empty($excel_report) && $excel_report==true){

				$params = array('parameter_details' =>array_filter($final_data),"lob_wise_parameters" => $lob_wise_parameters,"parameter_type" => $parameter_type);
				$this->generate_parameter_wise_dashboard_excel_report($params);
				die;
			}

			$data['parameter_details'] = array_filter($final_data);
			$data['lob_wise_parameters'] = $lob_wise_parameters;

			$this->load->view("dashboard", $data);
		}
	}

	/**
	* ===========================
	* Created By: SOURAV SARKAR
	* Created On: 15-12-2022
	* ===========================
	**/

	private function generate_parameter_wise_dashboard_excel_report($params){
		
		if(check_logged_in()){

			extract($params);

			$objPHPExcel = new PHPExcel();
    		$objWorksheet = $objPHPExcel->getActiveSheet();

    		$header = array("Parameters","Audit Count","Yes","No","NA","Score (%)","Defect (%)");

    		$startingCol = 'B';
	    	$startingRow = 2;

	    	foreach($parameter_details as $defect_table_key => $data){

	    		$excel_data = array(
							array(strtoupper(str_replace('qa_', '', str_replace('_feedback', '', $defect_table_key)))),
							$header
						);
	    		foreach($lob_wise_parameters[$defect_table_key] as $parameter){

	    			$total_audit = ($data[$parameter."_yes"] + $data[$parameter."_no"] + $data[$parameter."_na"]);

                    if($parameter_type == 'normal'){
                        $score = number_format((float)(($data[$parameter."_yes"] / $total_audit) * 100),2);
                    }
                    else
                    {
                        $score = number_format((float)(($data[$parameter."_no"] / $total_audit) * 100),2);
                    }
                    $defect = number_format((float)(100 - $score),2);

                    $sub = array();
                	/*prepare single lob wise data*/
                	$sub = array(
                					ucwords(str_replace('_', ' ', $parameter)),
                					$total_audit,
                					$data[$parameter."_yes"],
                					$data[$parameter."_no"],
                					$data[$parameter."_na"],
                					($score / 100),
                					($defect / 100)
                				);
                	$excel_data[] = $sub;
	    		}

	    		 /*starting position*/
				$objWorksheet->fromArray($excel_data,NULL,$startingCol.$startingRow,true);
				$adjustment = (count($header)-1);
		        $currentColumn = $startingCol;
		        $columnIndex = PHPExcel_Cell::columnIndexFromString($currentColumn);
		        $adjustedColumnIndex = $columnIndex + $adjustment;
		        $adjustedColumn = PHPExcel_Cell::stringFromColumnIndex($adjustedColumnIndex - 1);
				$objPHPExcel->getActiveSheet()->mergeCells($startingCol.$startingRow.':'.$adjustedColumn.$startingRow);
		        $titleStyleArray = array(
					'fill' => array(
						'type' => PHPExcel_Style_Fill::FILL_SOLID,
						'color' => array('rgb' => '188ae2')
					)
				);
		        $objWorksheet->getStyle($startingCol.$startingRow.':'.$adjustedColumn.($startingRow+1))->applyFromArray($titleStyleArray);

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
		        
		        $endingRow += (count($excel_data) + 1 );

		        $objWorksheet->getStyle($startingCol.$startingRow.':'.$adjustedColumn.$endingRow)->applyFromArray($style);
		        /*Number format into Percentage*/
		        $objPHPExcel->getActiveSheet()->getStyle('G'.($startingRow+2).':G'.$endingRow)
			    ->getNumberFormat()->applyFromArray( 
			        array( 
			            'code' => PHPExcel_Style_NumberFormat::FORMAT_PERCENTAGE_00
			        )
			    );
		        $objPHPExcel->getActiveSheet()->getStyle('H'.($startingRow+2).':H'.$endingRow)
			    ->getNumberFormat()->applyFromArray( 
			        array( 
			            'code' => PHPExcel_Style_NumberFormat::FORMAT_PERCENTAGE_00
			        )
			    );

			    /*Graph*/

			    /*Line Chart for Audit Count*/
		        $dataSeriesLabels = array(
		            new PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$G$'.($startingRow + 1), NULL, 1),   //  'Budget'
		        );
		        $xAxisTickValues = array(
		            new PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$A$'.($startingRow + 2).':$B$'.$endingRow, NULL),    //  Q1 to Q4 
		        );
		        $dataSeriesValues = array(
		            new PHPExcel_Chart_DataSeriesValues('Number', 'Worksheet!$G$'.($startingRow + 2).':$G$'.$endingRow, NULL),
		        );
		        $series = new PHPExcel_Chart_DataSeries(
		            PHPExcel_Chart_DataSeries::TYPE_LINECHART,       // plotType
		            PHPExcel_Chart_DataSeries::GROUPING_STACKED,  // plotGrouping //GROUPING_STACKED
		            range(0, count($dataSeriesValues)-1),           // plotOrder
		            $dataSeriesLabels,                              // plotLabel
		            $xAxisTickValues,                               // plotCategory
		            $dataSeriesValues                               // plotValues
		        );
		        $series->setPlotDirection(PHPExcel_Chart_DataSeries::DIRECTION_COL);
		        /*Line Chart for Audit Count*/

		        /*Bar Chart for Quality Score*/
		        
		        $dataSeriesLabels1 = array(   
			    	//'Yes,No,Na'
		            new PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$D$'.($startingRow + 1), NULL, 1),
		            new PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$E$'.($startingRow + 1), NULL, 1),
		            new PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$F$'.($startingRow + 1), NULL, 1)
		        );
		        $xAxisTickValues1 = array(
		            new PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$A$'.($startingRow + 2).':$B$'.$endingRow, NULL),    //  Q1 to Q4 for 2010 to 2012
		            new PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$A$'.($startingRow + 2).':$B$'.$endingRow, NULL),
		            new PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$A$'.($startingRow + 2).':$B$'.$endingRow, NULL),
		        );

		        $dataSeriesValues1 = array(
		            new PHPExcel_Chart_DataSeriesValues('Number', 'Worksheet!$D$'.($startingRow + 2).':$D$'.$endingRow, NULL),
		            new PHPExcel_Chart_DataSeriesValues('Number', 'Worksheet!$E$'.($startingRow + 2).':$E$'.$endingRow, NULL),
		            new PHPExcel_Chart_DataSeriesValues('Number', 'Worksheet!$F$'.($startingRow + 2).':$F$'.$endingRow, NULL)
		        );

		        $series1 = new PHPExcel_Chart_DataSeries(
		            PHPExcel_Chart_DataSeries::TYPE_BARCHART,       // plotType
		            PHPExcel_Chart_DataSeries::GROUPING_CLUSTERED,  // plotGrouping //GROUPING_STACKED
		            range(0, count($dataSeriesValues1)-1),           // plotOrder
		            $dataSeriesLabels1,                              // plotLabel
		            $xAxisTickValues1,                               // plotCategory
		            $dataSeriesValues1                               // plotValues
		        );
		        $series1->setPlotDirection(PHPExcel_Chart_DataSeries::DIRECTION_COL);
		        /*Bar Chart for Quality Score*/

		        $plotArea = new PHPExcel_Chart_PlotArea(NULL, array($series1,$series));

		        $legend = new PHPExcel_Chart_Legend(PHPExcel_Chart_Legend::POSITION_BOTTOM, NULL, false);

		        $title = new PHPExcel_Chart_Title($objPHPExcel->getActiveSheet()->getCell('B'.$startingRow)->getValue());
		        $xAxisLabel = new PHPExcel_Chart_Title('Parameters');
		        $yAxisLabel = new PHPExcel_Chart_Title('Count');

		        $chart = new PHPExcel_Chart(
		            'chart'.rand(9999,99999),       // name
		            $title,         // title
		            $legend,        // legend
		            $plotArea,      // plotArea
		            true,           // plotVisibleOnly
		            0,              // displayBlanksAs
		            $xAxisLabel,    // xAxisLabel
		            $yAxisLabel     // yAxisLabel
		        );
		        $chart->setTopLeftPosition('J'.$startingRow);
	    		$chart->setBottomRightPosition('Z'.$endingRow);
	    		$objWorksheet->addChart($chart);
	        	/*Graph*/

		        $startingCol = 'B';
		        $endingRow += 2;
	    		$startingRow += (count($excel_data) + 1 + 2);

	    	}

	    	foreach (range('B', 'Z') as $column){
			   $objPHPExcel->getActiveSheet()->getColumnDimension($column)->setAutoSize(true);
			}


			ob_end_clean();
	        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	        header('Content-Disposition: attachment;filename="Parameter-wise-report.xlsx' );
	        header('Cache-Control: max-age=0');
	        $writer = PHPExcel_IOFactory::createWriter($objPHPExcel , 'Excel2007');
	        $writer->setIncludeCharts(TRUE);
	        $writer->save('php://output');
		}
	}	

	/**
	* ==========================
	* Created By: SOURAV SARKAR
	* Created On: 15-12-2022
	* ==========================
	**/

	public function one_view_dashboard(){

		if(check_logged_in()){

			$current_user     = get_user_id();
			$user_site_id     = get_user_site_id();
			$user_oth_office  = get_user_oth_office();
			$is_global_access = get_global_access();
			$role_dir         = get_role_dir();
			$role_id          = get_role_id();
			$get_dept_id      = get_dept_id();
			
			$data["aside_template"]   = "qa_boomsourcing_aside/aside.php";
			$data["content_template"] = "qa_boomsourcing/qa_one_view_dashboard.php";
			$data["content_js"] = "qa_boomsourcing/qa_one_view_dashboard_js.php";

			/*QA List*/
			$sql = "SELECT s.id as qa_id,CONCAT(s.fname,' ',s.lname) as qa_name,r.folder,d.folder FROM `signin` s LEFT JOIN role r ON s.role_id=r.id LEFT JOIN department d ON s.dept_id = d.id WHERE d.folder='qa' AND r.folder='agent'";
			$data['qa_list'] = $this->Common_model->get_query_result_array($sql);

			/*L1 List*/
			$sql = "SELECT s.id as l1_id,CONCAT(s.fname,' ',s.lname) as l1_name,r.folder,d.folder FROM `signin` s LEFT JOIN role r ON s.role_id=r.id LEFT JOIN department d ON s.dept_id = d.id WHERE d.folder='operations' AND r.folder='tl'";
			$data['l1_list'] = $this->Common_model->get_query_result_array($sql);

			/*Agent List*/
			$qSql="SELECT id AS agent_id, concat(fname, ' ', lname) AS agent_name, assigned_to, fusion_id, xpoid FROM signin WHERE role_id IN (SELECT id FROM role WHERE folder ='agent') AND dept_id IN(6,14) AND is_assign_client(id,275) AND status=1 ORDER BY agent_name";
			$data['agent_list'] = $this->Common_model->get_query_result_array($qSql);

			$data['selected_month'] = $month = $this->input->get('select_month') ? $this->input->get('select_month') : array(date('m'));
			$data['selected_year'] = $year = $this->input->get('select_year') ? $this->input->get('select_year') : date('Y');

			$data['data_show_type'] = $rep_type = !empty($this->input->get('rep_type')) ? $this->input->get('rep_type') : 'monthly';

			$data['location_list'] = $this->Common_model->get_office_location_list();

			$data['selected_location'] = $office_location = !empty($this->input->get('select_office')) ? $this->input->get('select_office') : array('ALL');

			$office_condition = "";
			if(!empty($office_location)){ 					
				if(!in_array('ALL',$office_location)){
					$extracted_office_location = implode("','",$office_location);
					$office_condition = " AND l.abbr IN('".$extracted_office_location."')";
				}
			}

			$data['selected_vertical'] = $vertical = !empty($this->input->get("vertical")) ? $this->input->get("vertical") : '';
			$data['selected_campaign_process'] = $campaign_process = !empty($this->input->get("campaign_process")) ? $this->input->get("campaign_process") : '';

			$verticalCondition = "";
			if(!empty($vertical)){

				$verticalCondition = " AND vertical = $vertical";
			}

			$campaignProcessCondition = "";
			if(!empty($campaign_process)){

				$campaignProcessCondition = " AND campaign_process = $campaign_process";
			}

			$qSql = "SELECT p.id AS process_id,p.name AS process_name FROM qa_boomsourcing_defect AS q INNER JOIN process AS p ON p.id = q.process_id";
			$data['process_list'] = $this->Common_model->get_query_result_array($qSql);

			/*vertical List*/
			$qSql = "SELECT * FROM boomsourcing_vertical bv WHERE bv.is_active = 1";
			$data['vertical_list'] = $this->Common_model->get_query_result_array($qSql);

			/*campaign / process List*/
			$qSql = "SELECT * FROM boomsourcing_campaign bc WHERE bc.is_active = 1";
			$data['campaign_process_list'] = $this->Common_model->get_query_result_array($qSql);

			/*Process list*/
			$data['selected_process_id'] = $process_id = !empty($this->input->get('select_process')) ? $this->input->get('select_process') : 578;

			$data['selected_qa'] = $select_qa = !empty($this->input->get('select_qa')) ? $this->input->get('select_qa') : '';
			$data['selected_l1'] = $select_l1 = !empty($this->input->get('select_l1')) ? $this->input->get('select_l1') : '';
			$data['selected_agent'] = $select_agent = !empty($this->input->get('select_agent')) ? $this->input->get('select_agent') : '';
			$data['selected_find_by'] = $find_by = !empty($this->input->get("find_by")) ? $this->input->get("find_by") : '';

			$qa_l1_agent_condition = "";
			if(!empty($find_by)){

				switch ($find_by) {
					case 'QA':
						$qa_l1_agent_condition = " AND qa.entry_by = $select_qa";
						break;
					case 'L1':
						$qa_l1_agent_condition = " AND qa.tl_id = $select_l1";
						break;
					case 'Agent':
						$qa_l1_agent_condition = " AND qa.agent_id = $select_agent";
						break;
					default:
						
						break;
				}
			}

			/*Date condition*/
			$dateCondition = "";
			if(in_array($rep_type,['daily','weekly'])){

				$data['select_from_date'] = $start_date = date('Y-m-d',strtotime($this->input->get('select_from_date')));
				$data['select_to_date'] = $end_date = date('Y-m-d',strtotime($this->input->get('select_to_date')));

				/*$dateCondition = " AND DATE(qa.audit_date) >= '$start_date' AND DATE(qa.audit_date) <= '$end_date'";*/
				$dateCondition = " AND (DATE(getEstToLocal(entry_date,$current_user)) >= '$start_date' AND DATE(getEstToLocal(entry_date,$current_user)) <= '$end_date' )";
			}
			elseif($rep_type =='monthly'){

				$data['selected_month'] = $month = !empty($this->input->get('select_month')) ? $this->input->get('select_month') : array(date('m'));
				$mnth_strng = implode(",",$month);

				$data['selected_year'] = $year = !empty($this->input->get('select_year')) ? $this->input->get('select_year') : date('Y');
				$s_mnth = min($month);
				$e_mnth = max($month);
				$start_date = date('Y-m-01',strtotime($year.'-'.$s_mnth.'-1'));
				$end_date = date('Y-m-t',strtotime($year.'-'.$e_mnth.'-1'));

				/*$dateCondition = " AND MONTH(qa.audit_date) in('$mnth_strng') AND YEAR(qa.audit_date) = $year";*/
				$dateCondition = " AND (MONTH(getEstToLocal(entry_date,$current_user)) IN ($mnth_strng) AND YEAR(getEstToLocal(entry_date,$current_user)) = $year )";
			}
			else
			{
				$start_date = date('Y-m-d');
				$end_date = date('Y-m-d');
				/*$dateCondition = " AND DATE(qa.audit_date) >= '$start_date' AND DATE(qa.audit_date) <= '$end_date'";*/

				$dateCondition = " AND (DATE(getEstToLocal(entry_date,$current_user)) >= '$start_date' AND DATE(getEstToLocal(entry_date,$current_user)) <= '$end_date' )";
			}	
			/*Date condition*/

			/*How many weeks in a date range*/
			$start_date = date('Y-m-d',strtotime($start_date));
			$end_date = date('Y-m-d',strtotime($end_date));
			$startTime = strtotime($start_date);
			$endTime = strtotime($end_date);

			$weeks = array();

			while ($startTime <= $endTime) {  

			    $objDT      = new DateTime(date('Y-m-d',$startTime));
		        $weeks[]    = $objDT->format('W');
		        $startTime += strtotime('+1 day', 0);
			}
			$weeks = array_unique($weeks);

			$defect_data = $this->db->query("SELECT qd.id AS qa_defect_id,qd.table_name, qd.process_id, qd.params_columns, p.name as process_name FROM qa_boomsourcing_defect qd LEFT JOIN process p ON p.id = $process_id")->result_array();

			$monthly_total_data = array();
			$monthly_total_audit = 0;
			$monthly_total_cq_score = 0;
			$monthly_total_fata_count = 0;

			$totalMonthlyDefect = 0;
			$MonthlyfatalCounter = 0;

			$total_month_wise_data = array();
			$week_wise_data = array();

			$date_wise_audit_data = array();
			$location_wise_audit_data = array();
			$evaluator_wise_audit_data = array();
			$tl_wise_audit_data = array();
			$agent_wise_audit_data = array();

			$all_defect_table_overall_params = array();
			
			foreach($defect_data as $defect){

				$query = 'SELECT table_name,params_columns,fatal_param FROM qa_boomsourcing_defect Where id='.$defect['qa_defect_id'];
				$qa_defect = $this->Common_model->get_query_row_array($query);

				$qa_defect_table = $qa_defect['table_name'];

				/*Weeky Trend*/
				$monthlyData = $this->db->query("SELECT COUNT(qa.id) as total_audit,MONTH(qa.audit_date) as audit_month, SUM(qa.overall_score) as total_cq_score,SUM(CASE WHEN qa.overall_score = 0 THEN 1 ELSE 0 END) as audit_fatal FROM $qa_defect_table qa LEFT JOIN signin s ON s.id = qa.agent_id LEFT JOIN office_location l ON l.abbr = s.office_id WHERE 1 $office_condition $dateCondition $qa_l1_agent_condition $verticalCondition $campaignProcessCondition group by audit_month")->result_array();

				$tot_mnth[] = $monthlyData;

				foreach($monthlyData as $m_data){
					if(!empty($m_data)){

							$total_month_wise_data[] = $m_data;
						
							$monthly_total_audit += $m_data['total_audit'];
							$monthly_total_cq_score += $m_data['total_cq_score'];
							$monthly_total_fata_count += $m_data['audit_fatal'];
						}
				}

				$paramsArray = explode(',', $qa_defect['params_columns']);
				foreach($paramsArray as $parameter){

					$defect_sql = "SELECT COUNT(qa.id) as def_count FROM $qa_defect_table qa LEFT JOIN signin s ON s.id = qa.agent_id LEFT JOIN office_location l ON l.abbr = s.office_id WHERE (qa.$parameter IN ('No')) $office_condition $dateCondition $qa_l1_agent_condition $verticalCondition $campaignProcessCondition";
					$totalMonthlyDefect += $this->db->query($defect_sql)->row_array()['def_count'];
				}

				$fatal_params = explode(',', $qa_defect['fatal_param']);

				foreach($fatal_params as $fatal_param){
					
					$defect_sql = "SELECT COUNT(qa.id) as fatal_count FROM $qa_defect_table qa LEFT JOIN signin s ON s.id = qa.agent_id LEFT JOIN office_location l ON l.abbr = s.office_id WHERE 1 $office_condition $dateCondition $qa_l1_agent_condition $verticalCondition $campaignProcessCondition AND (qa.$fatal_param IN ('No'))";
					$MonthlyfatalCounter += $this->db->query($defect_sql)->row_array()['fatal_count'];
				}

				/*Week wise data*/
				foreach($weeks as $key => $week){

					$weekly_total_audit = 0;
					$weekly_total_cq_score = 0;
					$weekly_fatal_count = 0;

					$totalWeeklyDefect = 0;
					$weeklyFatalCounter = 0;

					/*Weeky Trend*/ //need to change date time and condition
					$weeklyData = $this->db->query("SELECT COUNT(qa.id) as total_audit, SUM(qa.overall_score) as total_cq_score,SUM(CASE WHEN qa.overall_score = 0 THEN 1 ELSE 0 END) as audit_fatal FROM $qa_defect_table qa LEFT JOIN signin s ON s.id = qa.agent_id LEFT JOIN office_location l ON l.abbr = s.office_id WHERE 1 $office_condition $dateCondition $qa_l1_agent_condition $verticalCondition $campaignProcessCondition AND WEEK(qa.audit_date) = $week")->row_array();
					$weekly_total_audit = $weeklyData['total_audit'];
					$weekly_total_cq_score = $weeklyData['total_cq_score'];
					$weekly_fatal_count = $weeklyData['audit_fatal'];

					foreach($paramsArray as $parameter){

						$defect_sql = "SELECT COUNT(qa.id) as def_count FROM $qa_defect_table qa LEFT JOIN signin s ON s.id = qa.agent_id LEFT JOIN office_location l ON l.abbr = s.office_id WHERE (qa.$parameter IN ('No')) $office_condition $dateCondition $qa_l1_agent_condition $verticalCondition $campaignProcessCondition AND WEEK(qa.audit_date) = $week";
						$totalWeeklyDefect += $this->db->query($defect_sql)->row_array()['def_count'];
					}

					foreach($fatal_params as $fatal_param){
					
						$defect_sql = "SELECT COUNT(qa.id) as fatal_count FROM $qa_defect_table qa LEFT JOIN signin s ON s.id = qa.agent_id LEFT JOIN office_location l ON l.abbr = s.office_id WHERE 1 $office_condition $dateCondition $qa_l1_agent_condition $verticalCondition $campaignProcessCondition AND (qa.$fatal_param IN ('No')) AND WEEK(qa.audit_date) = $week";
						$weeklyFatalCounter += $this->db->query($defect_sql)->row_array()['fatal_count'];
					}

					$week_wise_data = array_merge($week_wise_data,array(array(
																'week_name'=>'Week-'.$week,
																'total_audit' => $weekly_total_audit,
																'total_defect' => $totalWeeklyDefect,
																'total_fatal' => $weeklyFatalCounter,
																'cq_score' => $weekly_total_cq_score,
																'weekly_fatal_count' => $weekly_fatal_count
																)));
				}
				/*Week wise data*/

				/*Bucket Data*/
				$monthly_total_agents += $this->db->query("SELECT COUNT(DISTINCT qa.agent_id) as total_agents FROM $qa_defect_table qa LEFT JOIN signin s ON s.id = qa.agent_id LEFT JOIN office_location l ON l.abbr = s.office_id WHERE 1 $office_condition $dateCondition $qa_l1_agent_condition $verticalCondition $campaignProcessCondition")->row_array()['total_agents'];

			    /*Date Wise Audit*/
				$sql = "SELECT COUNT(qa.id) as audit_count,
					qa.audit_date,
					COALESCE(ROUND(SUM(qa.overall_score),2),0) AS cq_score_sum,
					SUM(CASE WHEN qa.overall_score = 0 THEN 1 ELSE 0 END) as audit_fatal
				FROM $qa_defect_table qa
				LEFT JOIN signin s ON s.id = qa.agent_id
				LEFT JOIN office_location l ON l.abbr = s.office_id
				WHERE 1 $office_condition $dateCondition $qa_l1_agent_condition $verticalCondition $campaignProcessCondition 
				GROUP BY qa.audit_date";
				$date_wise_audit_data = array_merge($date_wise_audit_data, $this->Common_model->get_query_result_array($sql));
				/*Date Wise Audit*/

				/*Location Wise*/
				$sql = "SELECT COUNT(qa.id) as audit_count, s.office_id, l.office_name, ROUND(SUM(qa.overall_score), 2) as cq_score_sum,SUM(CASE WHEN qa.overall_score = 0 THEN 1 ELSE 0 END) as fatal_count FROM $qa_defect_table qa INNER JOIN signin s ON s.id = qa.agent_id LEFT JOIN office_location l ON l.abbr = s.office_id WHERE 1 $office_condition $dateCondition $qa_l1_agent_condition $verticalCondition $campaignProcessCondition GROUP BY office_name";
				$location_wise_audit_data = array_merge($location_wise_audit_data, $this->Common_model->get_query_result_array($sql));
				/*Location Wise*/

				/*Evaluator wise data*/
				$sql = "SELECT COUNT(qa.id) as audit_count, (SELECT COUNT(qa_sub.id) FROM $qa_defect_table qa_sub INNER JOIN signin s ON s.id = qa_sub.entry_by LEFT JOIN office_location l ON l.abbr = s.office_id WHERE DATE(qa_sub.audit_date) = DATE(NOW()) AND qa_sub.entry_by = qa.entry_by) as ftd_count, qa.entry_by, CONCAT(s.fname,' ',s.lname,IF(s.xpoid IS NULL or s.xpoid = '', '', CONCAT(' ( ',s.xpoid,' )'))) as auditor_name, COALESCE(ROUND(SUM(qa.overall_score),2),0) AS cq_score_sum,SUM(CASE WHEN qa.overall_score = 0 THEN 1 ELSE 0 END) as audit_fatal FROM $qa_defect_table qa INNER JOIN signin s ON s.id = qa.entry_by LEFT JOIN office_location l ON l.abbr = s.office_id WHERE 1 $office_condition $dateCondition $qa_l1_agent_condition $verticalCondition $campaignProcessCondition GROUP BY qa.entry_by ";
				$evaluator_wise_audit_data = array_merge($evaluator_wise_audit_data, $this->Common_model->get_query_result_array($sql));
				/*Evaluator wise data*/

				/*TL wise data*/
				$sql = "SELECT COUNT(qa.id) as audit_count, qa.tl_id, CONCAT(s.fname,' ',s.lname,IF(s.xpoid IS NULL or s.xpoid = '', '', CONCAT(' ( ',s.xpoid,' )'))) as tl_name, COALESCE(ROUND(SUM(qa.overall_score),2),0) AS cq_score_sum,SUM(CASE WHEN qa.overall_score = 0 THEN 1 ELSE 0 END) as audit_fatal FROM $qa_defect_table qa INNER JOIN signin s ON s.id = qa.tl_id LEFT JOIN office_location l ON l.abbr = s.office_id WHERE 1 $office_condition $dateCondition $qa_l1_agent_condition $verticalCondition $campaignProcessCondition GROUP BY qa.tl_id";
				$tl_wise_audit_data = array_merge($tl_wise_audit_data, $this->Common_model->get_query_result_array($sql));
				/*TL wise data*/
				
				/*Agent wise data*/
				$sql = "SELECT COUNT(qa.id) as audit_count,qa.agent_id, CONCAT(s.fname,' ',s.lname,IF(s.xpoid IS NULL or s.xpoid = '', '', CONCAT(' ( ',s.xpoid,' )'))) as agent_name, COALESCE(ROUND(SUM(qa.overall_score),2),0) AS cq_score_sum,SUM(CASE WHEN qa.overall_score = 0 THEN 1 ELSE 0 END) as audit_fatal,COALESCE(SUM(CASE WHEN qa.agnt_fd_acpt = 'Accepted' THEN 1 ELSE 0 END),0) AS accepted,COALESCE(SUM(CASE WHEN qa.agnt_fd_acpt = 'Not Accepted' THEN 1 ELSE 0 END),0) AS rejected,COALESCE(SUM(CASE WHEN qa.agnt_fd_acpt = '' OR qa.agnt_fd_acpt IS NULL THEN 1 ELSE 0 END),0) AS pending FROM $qa_defect_table qa INNER JOIN signin s ON s.id = qa.agent_id LEFT JOIN office_location l ON l.abbr = s.office_id WHERE 1 $office_condition $dateCondition $qa_l1_agent_condition $verticalCondition $campaignProcessCondition GROUP BY qa.agent_id";
				$agent_wise_audit_data = array_merge($agent_wise_audit_data, $this->Common_model->get_query_result_array($sql));
				/*Agent wise data*/

				/*Parameter wise score*/

				$params_columns = $qa_defect['params_columns'];

				$sql = "SELECT $params_columns FROM $qa_defect_table qa LEFT JOIN signin s ON s.id = qa.agent_id LEFT JOIN office_location l ON l.abbr = s.office_id WHERE 1 $office_condition $dateCondition $qa_l1_agent_condition $verticalCondition $campaignProcessCondition";
		        $paramData= $this->db->query($sql)->result_array();
		        
		        $param_wise_data = array();

		        foreach($paramsArray as $param){

		            $score_count = array_count_values(array_column($paramData, $param));

		            $param_wise_data[$param]['Total'] = count($paramData);
		            $param_wise_data[$param]['Yes'] = !empty($score_count['Yes']) ? $score_count['Yes'] : 0;
		            $param_wise_data[$param]['No'] = !empty($score_count['No']) ? $score_count['No'] : 0;
		            $param_wise_data[$param]['NA'] = !empty($score_count['N/A']) ? $score_count['N/A'] : 0;
		        }

		        $all_defect_table_overall_params = array_merge($all_defect_table_overall_params,array($qa_defect_table => $param_wise_data));

			}

			foreach($month as $monthNum){
				$dateObj   = DateTime::createFromFormat('!m', $monthNum);
				$monthNamearr[] = $dateObj->format('F');
			}

			$mnth_name = implode(",",$monthNamearr);
			if($rep_type =='monthly'){
				$mnth_names = $mnth_name;
			}else{
				$mnth_names = date('F');
			}
			
			/*addition of all week wise data*/
			$final_week_wise_data = array_reduce(
                    $week_wise_data,
                    /*Add each $item from $input to $carry (partial results)*/
                    function (array $carry, array $item) {
                        $week_name = $item['week_name'];
                        /*Check if this week_name already exists in the partial results list*/
                        if (array_key_exists($week_name, $carry)) {
                           /* Update the existing item*/
                            
                            $carry[$week_name]['total_audit'] += $item['total_audit'];
                            $carry[$week_name]['total_defect'] += $item['total_defect'];
                            $carry[$week_name]['total_fatal'] += $item['total_fatal'];
                            $carry[$week_name]['cq_score'] += $item['cq_score'];
                            $carry[$week_name]['weekly_fatal_count'] += $item['weekly_fatal_count'];


                        } else {
                            /*Create a new item, index by week_name*/
                            $carry[$week_name] = $item;
                        }
                        /*Always return the updated partial result*/
                        return $carry;
                    },
                    /*Start with an empty list*/
                    array()
                );

			/*addition of date wise data*/
			$date_wise_audit_data = array_reduce(
                    $date_wise_audit_data,
                    function (array $carry, array $item) {
                        $audit_date = $item['audit_date'];
                        if (array_key_exists($audit_date, $carry)) {
                            
                            $carry[$audit_date]['audit_count'] += $item['audit_count'];
                            $carry[$audit_date]['cq_score_sum'] += $item['cq_score_sum'];
                            $carry[$audit_date]['audit_fatal'] += $item['audit_fatal'];

                        } else {
                            $carry[$audit_date] = $item;
                        }
                        return $carry;
                    },
                    array()
                );
			/*Date key wise sort*/
			ksort($date_wise_audit_data);

			/*addition of location wise data*/

			$location_wise_audit_data = array_reduce(
                    $location_wise_audit_data,
                    function (array $carry, array $item) {
                        $office_id = $item['office_id'];
                        if (array_key_exists($office_id, $carry)) {
                            
                            $carry[$office_id]['audit_count'] += $item['audit_count'];
                            $carry[$office_id]['cq_score_sum'] += $item['cq_score_sum'];
                            $carry[$office_id]['fatal_count'] += $item['fatal_count'];

                        } else {
                            $carry[$office_id] = $item;
                        }
                        return $carry;
                    },
                    array()
                );

			/*addition of Evaluator wise data*/

			$evaluator_wise_audit_data = array_reduce(
                    $evaluator_wise_audit_data,
                    function (array $carry, array $item) {
                        $entry_by = $item['entry_by'];
                        if (array_key_exists($entry_by, $carry)) {
                            
                            $carry[$entry_by]['audit_count'] += $item['audit_count'];
                            $carry[$entry_by]['cq_score_sum'] += $item['cq_score_sum'];
                            $carry[$entry_by]['ftd_count'] += $item['ftd_count'];
                            $carry[$entry_by]['audit_fatal'] += $item['audit_fatal'];

                        } else {
                            $carry[$entry_by] = $item;
                        }
                        return $carry;
                    },
                    array()
                );

			/*addition of TL wise data*/

			$tl_wise_audit_data = array_reduce(
                    $tl_wise_audit_data,
                    function (array $carry, array $item) {
                        $tl_id = $item['tl_id'];
                        if (array_key_exists($tl_id, $carry)) {
                            
                            $carry[$tl_id]['audit_count'] += $item['audit_count'];
                            $carry[$tl_id]['cq_score_sum'] += $item['cq_score_sum'];
                            $carry[$tl_id]['audit_fatal'] += $item['audit_fatal'];

                        } else {
                            $carry[$tl_id] = $item;
                        }
                        return $carry;
                    },
                    array()
                );

			/*addition of Agent wise data*/

			$agent_wise_audit_data = array_reduce(
                    $agent_wise_audit_data,
                    function (array $carry, array $item) {
                        $agent_id = $item['agent_id'];
                        if (array_key_exists($agent_id, $carry)) {
                            
                            $carry[$agent_id]['audit_count'] += $item['audit_count'];
                            $carry[$agent_id]['cq_score_sum'] += $item['cq_score_sum'];
                            $carry[$agent_id]['audit_fatal'] += $item['audit_fatal'];
                            $carry[$agent_id]['accepted'] += $item['accepted'];
                            $carry[$agent_id]['rejected'] += $item['rejected'];
                            $carry[$agent_id]['pending'] += $item['pending'];

                        } else {
                            $carry[$agent_id] = $item;
                        }
                        return $carry;
                    },
                    array()
                );

			$total_month_wise_data = array_reduce(
                    $total_month_wise_data,
                    function (array $carry, array $item) {
                        $audit_month = $item['audit_month'];
                        if (array_key_exists($audit_month, $carry)) {
                            
                            $carry[$audit_month]['total_audit'] += $item['total_audit'];
                            $carry[$audit_month]['total_cq_score'] += $item['total_cq_score'];
                            $carry[$audit_month]['audit_fatal'] += $item['audit_fatal'];

                        } else {
                            $carry[$audit_month] = $item;
                        }
                        return $carry;
                    },
                    array()
                );

			$data['total_month_wise_data'] = $total_month_wise_data;

			/*For Excel report*/
			$excel_report = $this->input->get('excel_report');
			if(!empty($excel_report) && $excel_report==true){
				$params = array("weekly_data" => $final_week_wise_data,"total_month_data" =>$total_month_wise_data,"monthly_total_agents"=>$monthly_total_agents,'date_wise_audit_data'=>$date_wise_audit_data,'location_wise_audit_data'=>$location_wise_audit_data,'evaluator_wise_audit_data'=>$evaluator_wise_audit_data,'tl_wise_audit_data'=>$tl_wise_audit_data,'agent_wise_audit_data'=>$agent_wise_audit_data,'all_defect_table_overall_params' => $all_defect_table_overall_params);

				$this->generate_one_view_dashboard_excel_report($params);
				die;
			}
			
			$data['weekly_data'] = $final_week_wise_data;
			$data['monthly_total_agents'] = $monthly_total_agents;
			$data['date_wise_audit_data'] = $date_wise_audit_data;
			$data['location_wise_audit_data'] = $location_wise_audit_data;
			$data['evaluator_wise_audit_data'] = $evaluator_wise_audit_data;
			$data['tl_wise_audit_data'] = $tl_wise_audit_data;
			$data['agent_wise_audit_data'] = $agent_wise_audit_data;
			$data['all_defect_table_overall_params'] = $all_defect_table_overall_params;
			
			$this->load->view('dashboard',$data);
		}
	}
	
	/**
	* ==========================
	* Created By: SOURAV SARKAR
	* Created On: 15-12-2022
	* ==========================
	**/
	public function generate_one_view_dashboard_excel_report($params){

		if(check_logged_in()){

			extract($params);


			$objPHPExcel = new PHPExcel();
    		$objWorksheet = $objPHPExcel->getActiveSheet();
    		$startingCol = 'B';
	    	$startingRow = 2;

    		$header = array("WEEK","NO OF AUDIT","NO OF FATAL","QUALITY SCORE");
    		$excel_data = array(
							array("Weekly Trend"),
							$header
						);

    		foreach($weekly_data as $week){

    			$avg_cq = !empty($week['total_audit']) ? number_format((float)($week['cq_score'] / $week['total_audit']), 2) : 0;

    			$sub = array();
            	$sub = array(
            					$week['week_name'],
            					$week['total_audit'],
            					!empty($week['weekly_fatal_count']) ? $week['weekly_fatal_count'] : 0,
            					$avg_cq
            				);
            	$excel_data[] = $sub;
    		}

			$objWorksheet->fromArray($excel_data,NULL,$startingCol.$startingRow,true);
			$adjustment = (count($header)-1);
			$currentColumn = $startingCol;
			$columnIndex = PHPExcel_Cell::columnIndexFromString($currentColumn);
			$adjustedColumnIndex = $columnIndex + $adjustment;
			$adjustedColumn = PHPExcel_Cell::stringFromColumnIndex($adjustedColumnIndex - 1);
			$objPHPExcel->getActiveSheet()->mergeCells('B2:'.$adjustedColumn.'2');

			$titleStyleArray = array(
			'fill' => array(
				'type' => PHPExcel_Style_Fill::FILL_SOLID,
				'color' => array('rgb' => '188ae2')
			),
			'alignment' => array(
			       'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
			   )
			);

			$objWorksheet->getStyle('B2:'.$adjustedColumn.'2')->applyFromArray($titleStyleArray);
			$objWorksheet->getStyle('B3:'.$adjustedColumn.'3')->applyFromArray($titleStyleArray);
			$tableBorderStyle = array(
			   'borders' => array(
			       'allborders' => array(
			         'style' => PHPExcel_Style_Border::BORDER_THIN
			       )
			   ),
			   'alignment' => array(
			       'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
			   )
			);

			$endingRow += (count($excel_data) + 1 );
			$objWorksheet->getStyle('B2:'.$adjustedColumn.$endingRow)->applyFromArray($tableBorderStyle);


			/*Line Chart for CQ score*/
			$dataSeriesLabels = array(
			   new PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$E$3', NULL, 1)
			);

			$xAxisTickValues = array(
			   new PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$A$5:$B$'.$endingRow, NULL)
			);

			$dataSeriesValues = array(
			   new PHPExcel_Chart_DataSeriesValues('Number', 'Worksheet!$E$5:$E$'.$endingRow, NULL),
			);

			$series = new PHPExcel_Chart_DataSeries(
			   PHPExcel_Chart_DataSeries::TYPE_LINECHART,      // plotType
			   PHPExcel_Chart_DataSeries::GROUPING_STACKED,    // plotGrouping //GROUPING_STACKED
			   range(0, count($dataSeriesValues)-1),           // plotOrder
			   $dataSeriesLabels,                              // plotLabel
			   $xAxisTickValues,                               // plotCategory
			   $dataSeriesValues                               // plotValues
			);
			$series->setPlotDirection(PHPExcel_Chart_DataSeries::DIRECTION_COL);
			/*Line Chart for CQ score*/

			/*Bar Chart for count*/

			$dataSeriesLabels1 = array(   
			   new PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$C$3', NULL, 1),
			   new PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$D$3', NULL, 1)
			);

			$xAxisTickValues1 = array(
			   new PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$A$5:$B$'.$endingRow, NULL), 
			   new PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$A$5:$B$'.$endingRow, NULL), 
			);

			$dataSeriesValues1 = array(
			   new PHPExcel_Chart_DataSeriesValues('Number', 'Worksheet!$C$5:$C$'.$endingRow, NULL),
			   new PHPExcel_Chart_DataSeriesValues('Number', 'Worksheet!$D$5:$D$'.$endingRow, NULL)
			);

			$series1 = new PHPExcel_Chart_DataSeries(
			   PHPExcel_Chart_DataSeries::TYPE_BARCHART,       // plotType
			   PHPExcel_Chart_DataSeries::GROUPING_CLUSTERED,  // plotGrouping //GROUPING_STACKED
			   range(0, count($dataSeriesValues1)-1),           // plotOrder
			   $dataSeriesLabels1,                              // plotLabel
			   $xAxisTickValues1,                               // plotCategory
			   $dataSeriesValues1                               // plotValues
			);
			$series1->setPlotDirection(PHPExcel_Chart_DataSeries::DIRECTION_COL);
			/*Bar Chart for count*/
			$layout = new PHPExcel_Chart_Layout();
			$layout->setShowVal(true);
			$plotArea = new PHPExcel_Chart_PlotArea($layout, array($series1,$series));

			$legend = new PHPExcel_Chart_Legend(PHPExcel_Chart_Legend::POSITION_BOTTOM, NULL, false);

			$title = new PHPExcel_Chart_Title($objPHPExcel->getActiveSheet()->getCell('B'.$startingRow)->getValue());
			$xAxisLabel = new PHPExcel_Chart_Title('Week');
			$yAxisLabel = new PHPExcel_Chart_Title('Count');

			$chart = new PHPExcel_Chart(
			   'chart'.rand(9999,99999),
			   $title,         // title
			   $legend,        // legend
			   $plotArea,      // plotArea
			   true,           // plotVisibleOnly
			   0,              // displayBlanksAs
			   $xAxisLabel,    // xAxisLabel
			   $yAxisLabel     // yAxisLabel
			);

			$graph_starting_row = ($endingRow + 2);
			$endingRow = $graph_ending_row = ($graph_starting_row + 20);
			$chart->setTopLeftPosition('B'.$graph_starting_row);
			$chart->setBottomRightPosition('I'.$graph_ending_row);
			$objWorksheet->addChart($chart);
    		/*Weekly Trend Graph*/

			/* Monthly Trend */
			$startingRow = $graph_ending_row + 2;
			unset($header);
			unset($excel_data);
			$header = array("MONTH","NO OF AUDIT","NO OF FATAL","QUALITY SCORE");
    		$excel_data = array(
							array("Monthly Trend"),
							$header,
						);
    		foreach($total_month_data as $mnth){

    			$avg_cq = !empty($mnth['total_audit']) ? number_format((float)($mnth['total_cq_score'] / $mnth['total_audit']), 2) : 0;
				$dateObj   = DateTime::createFromFormat('!m', $mnth['audit_month']);
				$mnth_name = $dateObj->format('F');

    			$sub = array();
            	$sub = array(
            					$mnth_name,
            					$mnth['total_audit'],
            					$mnth['audit_fatal'],
            					$avg_cq
            				);
            	$excel_data[] = $sub;
    		}

			$objWorksheet->fromArray($excel_data,NULL,$startingCol.$startingRow,true);
    		$adjustment = (count($header)-1);
			$currentColumn = $startingCol;
			$columnIndex = PHPExcel_Cell::columnIndexFromString($currentColumn);
			$adjustedColumnIndex = $columnIndex + $adjustment;
			$adjustedColumn = PHPExcel_Cell::stringFromColumnIndex($adjustedColumnIndex - 1);
			$objPHPExcel->getActiveSheet()->mergeCells($startingCol.$startingRow.':'.$adjustedColumn.$startingRow);
			$objWorksheet->getStyle($startingCol.$startingRow.':'.$adjustedColumn.($startingRow+1))->applyFromArray($titleStyleArray);

			$endingRow += (count($excel_data) + 1 );

			$objWorksheet->getStyle($startingCol.$startingRow.':'.$adjustedColumn.$endingRow)->applyFromArray($tableBorderStyle);


			/*Monthly Trend Graph*/

			/*Line Chart for CQ score*/
			$dataSeriesLabels = array(
			   new PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$E$'.($startingRow+1), NULL, 1)
			);
			$xAxisTickValues = array(
			   new PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$A$'.($startingRow+2).':$B$'.$endingRow, NULL)
			);

			$dataSeriesValues = array(
			   new PHPExcel_Chart_DataSeriesValues('Number', 'Worksheet!$E$'.($startingRow+2).':$E$'.$endingRow, NULL),
			);

			$series = new PHPExcel_Chart_DataSeries(
			   PHPExcel_Chart_DataSeries::TYPE_LINECHART,      // plotType
			   PHPExcel_Chart_DataSeries::GROUPING_STACKED,    // plotGrouping //GROUPING_STACKED
			   range(0, count($dataSeriesValues)-1),           // plotOrder
			   $dataSeriesLabels,                              // plotLabel
			   $xAxisTickValues,                               // plotCategory
			   $dataSeriesValues                               // plotValues
			);

			$series->setPlotDirection(PHPExcel_Chart_DataSeries::DIRECTION_COL);
			/*Line Chart for CQ score*/

			/*Bar Chart for count*/

			$dataSeriesLabels1 = array(   
			   new PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$C$'.($startingRow+1), NULL, 1),
			   new PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$D$'.($startingRow+1), NULL, 1)
			);

			$xAxisTickValues1 = array(
			   new PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$A$'.($startingRow+2).':$B$'.$endingRow, NULL), 
			   new PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$A$'.($startingRow+2).':$B$'.$endingRow, NULL), 
			);

			$dataSeriesValues1 = array(
			   new PHPExcel_Chart_DataSeriesValues('Number', 'Worksheet!$C$'.($startingRow+2).':$C$'.$endingRow, NULL),
			   new PHPExcel_Chart_DataSeriesValues('Number', 'Worksheet!$D$'.($startingRow+2).':$D$'.$endingRow, NULL)
			);

			$series1 = new PHPExcel_Chart_DataSeries(
			   PHPExcel_Chart_DataSeries::TYPE_BARCHART,       // plotType
			   PHPExcel_Chart_DataSeries::GROUPING_CLUSTERED,  // plotGrouping //GROUPING_STACKED
			   range(0, count($dataSeriesValues1)-1),           // plotOrder
			   $dataSeriesLabels1,                              // plotLabel
			   $xAxisTickValues1,                               // plotCategory
			   $dataSeriesValues1                               // plotValues
			);

			$series1->setPlotDirection(PHPExcel_Chart_DataSeries::DIRECTION_COL);
			/*Bar Chart for count*/
			$layout = new PHPExcel_Chart_Layout();
			$layout->setShowVal(true);
			$plotArea = new PHPExcel_Chart_PlotArea($layout, array($series1,$series));

			$legend = new PHPExcel_Chart_Legend(PHPExcel_Chart_Legend::POSITION_BOTTOM, NULL, false);

			$title = new PHPExcel_Chart_Title($objPHPExcel->getActiveSheet()->getCell('B'.$startingRow)->getValue());
			$xAxisLabel = new PHPExcel_Chart_Title('Month');
			$yAxisLabel = new PHPExcel_Chart_Title('Count');

			$chart = new PHPExcel_Chart(
			   'chart'.rand(9999,99999),
			   $title,         // title
			   $legend,        // legend
			   $plotArea,      // plotArea
			   true,           // plotVisibleOnly
			   0,              // displayBlanksAs
			   $xAxisLabel,    // xAxisLabel
			   $yAxisLabel     // yAxisLabel
			);

			$graph_starting_row = $endingRow + 2;
	        $endingRow = $graph_ending_row = ($graph_starting_row + 20);
	        $chart->setTopLeftPosition('B'.$graph_starting_row);
			$chart->setBottomRightPosition('I'.$graph_ending_row);
			$objWorksheet->addChart($chart);
    		/*Weekly Trend Graph*/

    		/*Date Wise Audit*/
    		/*next starting row*/
			$startingRow = $graph_ending_row + 2;

			unset($header);
			unset($excel_data);

			$header = array("Date","Audit Count","Quality Score","Fatal Count");
			$excel_data = array(
						array("Date Wise Audit"),
						$header
					);
			foreach($date_wise_audit_data as $item){

				$sub = array();
				$sub = array(
								$item['audit_date'],
								$item['audit_count'],
								number_format((float)($item['cq_score_sum'] / $item['audit_count']), 2),
								$item['audit_fatal']
							);
				$excel_data[] = $sub;
			}
			$objWorksheet->fromArray($excel_data,NULL,$startingCol.$startingRow,true);

			$adjustment = (count($header)-1);
			$currentColumn = $startingCol;
			$columnIndex = PHPExcel_Cell::columnIndexFromString($currentColumn);
			$adjustedColumnIndex = $columnIndex + $adjustment;
			$adjustedColumn = PHPExcel_Cell::stringFromColumnIndex($adjustedColumnIndex - 1);
			$objPHPExcel->getActiveSheet()->mergeCells($startingCol.$startingRow.':'.$adjustedColumn.$startingRow);
			$objWorksheet->getStyle($startingCol.$startingRow.':'.$adjustedColumn.($startingRow+1))->applyFromArray($titleStyleArray);

			$endingRow += (count($excel_data) + 1 );

			$objWorksheet->getStyle($startingCol.$startingRow.':'.$adjustedColumn.$endingRow)->applyFromArray($tableBorderStyle);

			/*Line Chart for CQ score*/
	        $dataSeriesLabels = array(
	            new PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$D$'.($startingRow + 1), NULL, 1)
	        );
	        $xAxisTickValues = array(
	            new PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$A$'.($startingRow + 2).':$B$'.$endingRow, NULL)
	        );
	        $dataSeriesValues = array(
	            new PHPExcel_Chart_DataSeriesValues('Number', 'Worksheet!$D$'.($startingRow + 2).':$D$'.$endingRow, NULL),
	        );
	        $series = new PHPExcel_Chart_DataSeries(
	            PHPExcel_Chart_DataSeries::TYPE_LINECHART,      // plotType
	            PHPExcel_Chart_DataSeries::GROUPING_STACKED,    // plotGrouping //GROUPING_STACKED
	            range(0, count($dataSeriesValues)-1),           // plotOrder
	            $dataSeriesLabels,                              // plotLabel
	            $xAxisTickValues,                               // plotCategory
	            $dataSeriesValues                               // plotValues
	        );
	        $series->setPlotDirection(PHPExcel_Chart_DataSeries::DIRECTION_COL);
	        /*Line Chart for CQ score*/

	        /*Line Chart for audit count*/
	        
	        $dataSeriesLabels1 = array(   
	            new PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$C$'.($startingRow + 1), NULL, 1)
	        );
	        $xAxisTickValues1 = array(
	           new PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$A$'.($startingRow + 2).':$B$'.$endingRow, NULL)
	        );

	        $dataSeriesValues1 = array(
	            new PHPExcel_Chart_DataSeriesValues('Number', 'Worksheet!$C$'.($startingRow + 2).':$C$'.$endingRow, NULL)
	        );

	        $series1 = new PHPExcel_Chart_DataSeries(
	            PHPExcel_Chart_DataSeries::TYPE_BARCHART,       // plotType
	            PHPExcel_Chart_DataSeries::GROUPING_CLUSTERED,  // plotGrouping //GROUPING_STACKED
	            range(0, count($dataSeriesValues1)-1),           // plotOrder
	            $dataSeriesLabels1,                              // plotLabel
	            $xAxisTickValues1,                               // plotCategory
	            $dataSeriesValues1                               // plotValues
	        );
	        $series1->setPlotDirection(PHPExcel_Chart_DataSeries::DIRECTION_COL);
	        $layout = new PHPExcel_Chart_Layout();
			  $layout->setShowVal(true);
	        $plotArea = new PHPExcel_Chart_PlotArea($layout, array($series1,$series));

	        $legend = new PHPExcel_Chart_Legend(PHPExcel_Chart_Legend::POSITION_BOTTOM, NULL, false);

	        $title = new PHPExcel_Chart_Title($objPHPExcel->getActiveSheet()->getCell('B'.$startingRow)->getValue());

	        $chart = new PHPExcel_Chart(
	            'chart'.rand(9999,99999),
	            $title,         // title
	            $legend,        // legend
	            $plotArea,      // plotArea
	            true,           // plotVisibleOnly
	            0,              // displayBlanksAs
	            // $xAxisLabel,    // xAxisLabel
	            // $yAxisLabel     // yAxisLabel
	        );

	        $graph_starting_row = $endingRow + 2;
	        $endingRow = $graph_ending_row = ($graph_starting_row + 20);
	        $chart->setTopLeftPosition('B'.$graph_starting_row);
			$chart->setBottomRightPosition('I'.$graph_ending_row);
			$objWorksheet->addChart($chart);

			/*Date Wise Audit*/

			/*Location Wise Audit*/

			$startingRow = $graph_ending_row + 2;

			unset($header);
			unset($excel_data);

			$header = array("Location","No of Audit","Quality Score","Fatal Count");
			$excel_data = array(
						array("Location Wise Audit"),
						$header
					);
			foreach($location_wise_audit_data as $item){

				$sub = array();
				$sub = array(
								$item['office_name'],
								$item['audit_count'],
								number_format((float)($item['cq_score_sum'] / $item['audit_count']), 2),
								$item['fatal_count']
							);
				$excel_data[] = $sub;
			}

			$objWorksheet->fromArray($excel_data,NULL,$startingCol.$startingRow,true);
			$adjustment = (count($header)-1);
			$currentColumn = $startingCol;
			$columnIndex = PHPExcel_Cell::columnIndexFromString($currentColumn);
			$adjustedColumnIndex = $columnIndex + $adjustment;
			$adjustedColumn = PHPExcel_Cell::stringFromColumnIndex($adjustedColumnIndex - 1);
			$objPHPExcel->getActiveSheet()->mergeCells($startingCol.$startingRow.':'.$adjustedColumn.$startingRow);
			$objWorksheet->getStyle($startingCol.$startingRow.':'.$adjustedColumn.($startingRow+1))->applyFromArray($titleStyleArray);

			$endingRow += (count($excel_data) + 1 );

			$objWorksheet->getStyle($startingCol.$startingRow.':'.$adjustedColumn.$endingRow)->applyFromArray($tableBorderStyle);

			/*Line Chart for CQ score*/
			$dataSeriesLabels = array(
				new PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$D$'.($startingRow + 1), NULL, 1)
			);
			$xAxisTickValues = array(
				new PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$A$'.($startingRow + 2).':$B$'.$endingRow, NULL)
			);
			$dataSeriesValues = array(
				new PHPExcel_Chart_DataSeriesValues('Number', 'Worksheet!$D$'.($startingRow + 2).':$D$'.$endingRow, NULL),
			);
			$series = new PHPExcel_Chart_DataSeries(
				PHPExcel_Chart_DataSeries::TYPE_LINECHART,      // plotType
				PHPExcel_Chart_DataSeries::GROUPING_STACKED,    // plotGrouping //GROUPING_STACKED
				range(0, count($dataSeriesValues)-1),           // plotOrder
				$dataSeriesLabels,                              // plotLabel
				$xAxisTickValues,                               // plotCategory
				$dataSeriesValues                               // plotValues
			);
			$series->setPlotDirection(PHPExcel_Chart_DataSeries::DIRECTION_COL);
			/*Line Chart for CQ score*/

			/*Line Chart for audit count*/

			$dataSeriesLabels1 = array(   
				new PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$C$'.($startingRow + 1), NULL, 1)
			);
			$xAxisTickValues1 = array(
				new PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$A$'.($startingRow + 2).':$B$'.$endingRow, NULL)
			);

			$dataSeriesValues1 = array(
				new PHPExcel_Chart_DataSeriesValues('Number', 'Worksheet!$C$'.($startingRow + 2).':$C$'.$endingRow, NULL)
			);

			$series1 = new PHPExcel_Chart_DataSeries(
				PHPExcel_Chart_DataSeries::TYPE_BARCHART,       // plotType
				PHPExcel_Chart_DataSeries::GROUPING_CLUSTERED,  // plotGrouping //GROUPING_STACKED
				range(0, count($dataSeriesValues1)-1),           // plotOrder
				$dataSeriesLabels1,                              // plotLabel
				$xAxisTickValues1,                               // plotCategory
				$dataSeriesValues1                               // plotValues
			);
			$series1->setPlotDirection(PHPExcel_Chart_DataSeries::DIRECTION_COL);
			$layout = new PHPExcel_Chart_Layout();
			$layout->setShowVal(true);
			$plotArea = new PHPExcel_Chart_PlotArea($layout, array($series1,$series));

			$legend = new PHPExcel_Chart_Legend(PHPExcel_Chart_Legend::POSITION_BOTTOM, NULL, false);

			$title = new PHPExcel_Chart_Title($objPHPExcel->getActiveSheet()->getCell('B'.$startingRow)->getValue());

			$chart = new PHPExcel_Chart(
				'chart'.rand(9999,99999),
				$title,         // title
				$legend,        // legend
				$plotArea,      // plotArea
				true,           // plotVisibleOnly
				0,              // displayBlanksAs
				// $xAxisLabel,    // xAxisLabel
				// $yAxisLabel     // yAxisLabel
			);

			$graph_starting_row = $endingRow + 2;
			$endingRow = $graph_ending_row = ($graph_starting_row + 20);
			$chart->setTopLeftPosition('B'.$graph_starting_row);
			$chart->setBottomRightPosition('I'.$graph_ending_row);
			$objWorksheet->addChart($chart);

			/*Evaluator Wise Audit*/
			$startingRow = $graph_ending_row + 2;

			unset($header);
			unset($excel_data);

			$header = array("Evaluator Name","Audit Count","Quality Score","Fatal Count");
			$excel_data = array(
						array("Evaluator Wise Audit"),
						$header
					);
			foreach($evaluator_wise_audit_data as $item){

				$sub = array();
				$sub = array(
								$item['auditor_name'],
								$item['audit_count'],
								number_format((float)($item['cq_score_sum'] / $item['audit_count']), 2),
								$item['audit_fatal']
							);
				$excel_data[] = $sub;
			}

			$objWorksheet->fromArray($excel_data,NULL,$startingCol.$startingRow,true);
			$adjustment = (count($header)-1);
			$currentColumn = $startingCol;
			$columnIndex = PHPExcel_Cell::columnIndexFromString($currentColumn);
			$adjustedColumnIndex = $columnIndex + $adjustment;
			$adjustedColumn = PHPExcel_Cell::stringFromColumnIndex($adjustedColumnIndex - 1);
			$objPHPExcel->getActiveSheet()->mergeCells($startingCol.$startingRow.':'.$adjustedColumn.$startingRow);
			$objWorksheet->getStyle($startingCol.$startingRow.':'.$adjustedColumn.($startingRow+1))->applyFromArray($titleStyleArray);

			$endingRow += (count($excel_data) + 1 );

			$objWorksheet->getStyle($startingCol.$startingRow.':'.$adjustedColumn.$endingRow)->applyFromArray($tableBorderStyle);

			/*Line Chart for CQ score*/
			$dataSeriesLabels = array(
				new PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$D$'.($startingRow + 1), NULL, 1)
			);
			$xAxisTickValues = array(
				new PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$A$'.($startingRow + 2).':$B$'.$endingRow, NULL)
			);
			$dataSeriesValues = array(
				new PHPExcel_Chart_DataSeriesValues('Number', 'Worksheet!$D$'.($startingRow + 2).':$D$'.$endingRow, NULL),
			);
			$series = new PHPExcel_Chart_DataSeries(
				PHPExcel_Chart_DataSeries::TYPE_LINECHART,      // plotType
				PHPExcel_Chart_DataSeries::GROUPING_STACKED,    // plotGrouping //GROUPING_STACKED
				range(0, count($dataSeriesValues)-1),           // plotOrder
				$dataSeriesLabels,                              // plotLabel
				$xAxisTickValues,                               // plotCategory
				$dataSeriesValues                               // plotValues
			);
			$series->setPlotDirection(PHPExcel_Chart_DataSeries::DIRECTION_COL);
			/*Line Chart for CQ score*/

			/*Line Chart for audit count*/

			$dataSeriesLabels1 = array(   
				new PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$C$'.($startingRow + 1), NULL, 1)
			);
			$xAxisTickValues1 = array(
				new PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$A$'.($startingRow + 2).':$B$'.$endingRow, NULL)
			);

			$dataSeriesValues1 = array(
				new PHPExcel_Chart_DataSeriesValues('Number', 'Worksheet!$C$'.($startingRow + 2).':$C$'.$endingRow, NULL)
			);

			$series1 = new PHPExcel_Chart_DataSeries(
				PHPExcel_Chart_DataSeries::TYPE_BARCHART,       // plotType
				PHPExcel_Chart_DataSeries::GROUPING_CLUSTERED,  // plotGrouping //GROUPING_STACKED
				range(0, count($dataSeriesValues1)-1),           // plotOrder
				$dataSeriesLabels1,                              // plotLabel
				$xAxisTickValues1,                               // plotCategory
				$dataSeriesValues1                               // plotValues
			);
			$series1->setPlotDirection(PHPExcel_Chart_DataSeries::DIRECTION_COL);
			$layout = new PHPExcel_Chart_Layout();
			$layout->setShowVal(true);
			$plotArea = new PHPExcel_Chart_PlotArea($layout, array($series1,$series));

			$legend = new PHPExcel_Chart_Legend(PHPExcel_Chart_Legend::POSITION_BOTTOM, NULL, false);

			$title = new PHPExcel_Chart_Title($objPHPExcel->getActiveSheet()->getCell('B'.$startingRow)->getValue());

			$chart = new PHPExcel_Chart(
				'chart'.rand(9999,99999),
				$title,         // title
				$legend,        // legend
				$plotArea,      // plotArea
				true,           // plotVisibleOnly
				0,              // displayBlanksAs
				// $xAxisLabel,    // xAxisLabel
				// $yAxisLabel     // yAxisLabel
			);

			$graph_starting_row = $endingRow + 2;
			$endingRow = $graph_ending_row = ($graph_starting_row + 20);
			$chart->setTopLeftPosition('B'.$graph_starting_row);
			$chart->setBottomRightPosition('I'.$graph_ending_row);
			$objWorksheet->addChart($chart);

			/*Evaluator Wise Audit*/

			/*Supervisor Wise Audit*/
			$startingRow = $graph_ending_row + 2;

			unset($header);
			unset($excel_data);

			$header = array("Supervisor Name","Audit Count","Quality Score","Fatal Count");
			$excel_data = array(
						array("Supervisor Wise Audit"),
						$header
					);
			foreach($tl_wise_audit_data as $item){

				$sub = array();
				$sub = array(
								$item['tl_name'],
								$item['audit_count'],
								number_format((float)($item['cq_score_sum'] / $item['audit_count']), 2),
								$item['audit_fatal']
							);
				$excel_data[] = $sub;
			}

			$objWorksheet->fromArray($excel_data,NULL,$startingCol.$startingRow,true);
			$adjustment = (count($header)-1);
			$currentColumn = $startingCol;
			$columnIndex = PHPExcel_Cell::columnIndexFromString($currentColumn);
			$adjustedColumnIndex = $columnIndex + $adjustment;
			$adjustedColumn = PHPExcel_Cell::stringFromColumnIndex($adjustedColumnIndex - 1);
			$objPHPExcel->getActiveSheet()->mergeCells($startingCol.$startingRow.':'.$adjustedColumn.$startingRow);
			$objWorksheet->getStyle($startingCol.$startingRow.':'.$adjustedColumn.($startingRow+1))->applyFromArray($titleStyleArray);

			$endingRow += (count($excel_data) + 1 );

			$objWorksheet->getStyle($startingCol.$startingRow.':'.$adjustedColumn.$endingRow)->applyFromArray($tableBorderStyle);

			/*Line Chart for CQ score*/
			$dataSeriesLabels = array(
				new PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$D$'.($startingRow + 1), NULL, 1)
			);
			$xAxisTickValues = array(
				new PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$A$'.($startingRow + 2).':$B$'.$endingRow, NULL)
			);
			$dataSeriesValues = array(
				new PHPExcel_Chart_DataSeriesValues('Number', 'Worksheet!$D$'.($startingRow + 2).':$D$'.$endingRow, NULL),
			);
			$series = new PHPExcel_Chart_DataSeries(
				PHPExcel_Chart_DataSeries::TYPE_LINECHART,      // plotType
				PHPExcel_Chart_DataSeries::GROUPING_STACKED,    // plotGrouping //GROUPING_STACKED
				range(0, count($dataSeriesValues)-1),           // plotOrder
				$dataSeriesLabels,                              // plotLabel
				$xAxisTickValues,                               // plotCategory
				$dataSeriesValues                               // plotValues
			);
			$series->setPlotDirection(PHPExcel_Chart_DataSeries::DIRECTION_COL);
			/*Line Chart for CQ score*/

			/*Line Chart for audit count*/

			$dataSeriesLabels1 = array(   
				new PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$C$'.($startingRow + 1), NULL, 1)
			);
			$xAxisTickValues1 = array(
				new PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$A$'.($startingRow + 2).':$B$'.$endingRow, NULL)
			);

			$dataSeriesValues1 = array(
				new PHPExcel_Chart_DataSeriesValues('Number', 'Worksheet!$C$'.($startingRow + 2).':$C$'.$endingRow, NULL)
			);

			$series1 = new PHPExcel_Chart_DataSeries(
				PHPExcel_Chart_DataSeries::TYPE_BARCHART,       // plotType
				PHPExcel_Chart_DataSeries::GROUPING_CLUSTERED,  // plotGrouping //GROUPING_STACKED
				range(0, count($dataSeriesValues1)-1),           // plotOrder
				$dataSeriesLabels1,                              // plotLabel
				$xAxisTickValues1,                               // plotCategory
				$dataSeriesValues1                               // plotValues
			);
			$series1->setPlotDirection(PHPExcel_Chart_DataSeries::DIRECTION_COL);
			$layout = new PHPExcel_Chart_Layout();
			$layout->setShowVal(true);
			$plotArea = new PHPExcel_Chart_PlotArea($layout, array($series1,$series));

			$legend = new PHPExcel_Chart_Legend(PHPExcel_Chart_Legend::POSITION_BOTTOM, NULL, false);

			$title = new PHPExcel_Chart_Title($objPHPExcel->getActiveSheet()->getCell('B'.$startingRow)->getValue());

			$chart = new PHPExcel_Chart(
				'chart'.rand(9999,99999),
				$title,         // title
				$legend,        // legend
				$plotArea,      // plotArea
				true,           // plotVisibleOnly
				0,              // displayBlanksAs
				// $xAxisLabel,    // xAxisLabel
				// $yAxisLabel     // yAxisLabel
			);

			$graph_starting_row = $endingRow + 2;
			$endingRow = $graph_ending_row = ($graph_starting_row + 20);
			$chart->setTopLeftPosition('B'.$graph_starting_row);
			$chart->setBottomRightPosition('I'.$graph_ending_row);
			$objWorksheet->addChart($chart);
			/*Supervisor Wise Audit*/

			/*Agent Wise Data*/
			$startingRow = $graph_ending_row + 2;

			unset($header);
			unset($excel_data);

			$header = array("Agent Name","Audit Count","Accepted","Quality Score","Fatal Count","Rejected","Pending");
			$excel_data = array(
						array("Agent Wise Data"),
						$header
					);
			foreach($agent_wise_audit_data as $item){

				$sub = array();
				$sub = array(
								$item['agent_name'],
								$item['audit_count'],
								$item['accepted'],
								number_format((float)($item['cq_score_sum'] / $item['audit_count']), 2),
								$item['audit_fatal'],
								$item['rejected'],
								$item['pending']
							);
				$excel_data[] = $sub;
			}

			$objWorksheet->fromArray($excel_data,NULL,$startingCol.$startingRow,true);
			$adjustment = (count($header)-1);
			$currentColumn = $startingCol;
			$columnIndex = PHPExcel_Cell::columnIndexFromString($currentColumn);
			$adjustedColumnIndex = $columnIndex + $adjustment;
			$adjustedColumn = PHPExcel_Cell::stringFromColumnIndex($adjustedColumnIndex - 1);
			$objPHPExcel->getActiveSheet()->mergeCells($startingCol.$startingRow.':'.$adjustedColumn.$startingRow);
			$objWorksheet->getStyle($startingCol.$startingRow.':'.$adjustedColumn.($startingRow+1))->applyFromArray($titleStyleArray);

			$endingRow += (count($excel_data) + 1 );

			$objWorksheet->getStyle($startingCol.$startingRow.':'.$adjustedColumn.$endingRow)->applyFromArray($tableBorderStyle);
			
			/*Line Chart for CQ score*/
			$dataSeriesLabels = array(
			   new PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$E$'.($startingRow+1), NULL, 1)
			);
			$xAxisTickValues = array(
			   new PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$A$'.($startingRow+2).':$B$'.$endingRow, NULL)
			);
			$dataSeriesValues = array(
			   new PHPExcel_Chart_DataSeriesValues('Number', 'Worksheet!$E$'.($startingRow+2).':$E$'.$endingRow, NULL),
			);
			$series = new PHPExcel_Chart_DataSeries(
			   PHPExcel_Chart_DataSeries::TYPE_LINECHART,      // plotType
			   PHPExcel_Chart_DataSeries::GROUPING_STACKED,    // plotGrouping //GROUPING_STACKED
			   range(0, count($dataSeriesValues)-1),           // plotOrder
			   $dataSeriesLabels,                              // plotLabel
			   $xAxisTickValues,                               // plotCategory
			   $dataSeriesValues                               // plotValues
			);
			$series->setPlotDirection(PHPExcel_Chart_DataSeries::DIRECTION_COL);
			/*Line Chart for CQ score*/

			/*Bar Chart for count*/

			$dataSeriesLabels1 = array(   
			   new PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$C$'.($startingRow+1), NULL, 1),
			   new PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$D$'.($startingRow+1), NULL, 1)
			);
			$xAxisTickValues1 = array(
			   new PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$A$'.($startingRow+2).':$B$'.$endingRow, NULL), 
			   new PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$A$'.($startingRow+2).':$B$'.$endingRow, NULL), 
			);

			$dataSeriesValues1 = array(
			   new PHPExcel_Chart_DataSeriesValues('Number', 'Worksheet!$C$'.($startingRow+2).':$C$'.$endingRow, NULL),
			   new PHPExcel_Chart_DataSeriesValues('Number', 'Worksheet!$D$'.($startingRow+2).':$D$'.$endingRow, NULL)
			);

			$series1 = new PHPExcel_Chart_DataSeries(
			   PHPExcel_Chart_DataSeries::TYPE_BARCHART,       // plotType
			   PHPExcel_Chart_DataSeries::GROUPING_CLUSTERED,  // plotGrouping //GROUPING_STACKED
			   range(0, count($dataSeriesValues1)-1),           // plotOrder
			   $dataSeriesLabels1,                              // plotLabel
			   $xAxisTickValues1,                               // plotCategory
			   $dataSeriesValues1                               // plotValues
			);
			$series1->setPlotDirection(PHPExcel_Chart_DataSeries::DIRECTION_COL);
			/*Bar Chart for count*/
			$layout = new PHPExcel_Chart_Layout();
			$layout->setShowVal(true);
			$plotArea = new PHPExcel_Chart_PlotArea($layout, array($series1,$series));

			$legend = new PHPExcel_Chart_Legend(PHPExcel_Chart_Legend::POSITION_BOTTOM, NULL, false);

			$title = new PHPExcel_Chart_Title($objPHPExcel->getActiveSheet()->getCell('B'.$startingRow)->getValue());
			$xAxisLabel = new PHPExcel_Chart_Title('Agent Name');
			$yAxisLabel = new PHPExcel_Chart_Title('');

			$chart = new PHPExcel_Chart(
			   'chart'.rand(9999,99999),
			   $title,         // title
			   $legend,        // legend
			   $plotArea,      // plotArea
			   true,           // plotVisibleOnly
			   0,              // displayBlanksAs
			   $xAxisLabel,    // xAxisLabel
			   $yAxisLabel     // yAxisLabel
			);

			$graph_starting_row = $endingRow + 2;
			$endingRow = $graph_ending_row = ($graph_starting_row + 35);
			$chart->setTopLeftPosition('B'.$graph_starting_row);
			$chart->setBottomRightPosition('M'.$graph_ending_row);
			$objWorksheet->addChart($chart);

			/*Agent Wise Data*/

			/*parameter wise data*/
			$startingRow = $endingRow + 2;

			foreach($all_defect_table_overall_params as $defect_table_key => $defect_table){

				$header = array("Overall Parameters","Yes","No","NA","Grand Total","Score%","Error Count%");

				$excel_data = array(
							array(strtoupper(str_replace('qa_', '', str_replace('_feedback', '', $defect_table_key)))),
							$header
						);
				$params = array_keys($all_defect_table_overall_params[$defect_table_key]);

		        $total_no_count = 0;
		        foreach($params as $key => $param){

					$grand_total = $defect_table[$param]['Yes'] + $defect_table[$param]['No'] + $defect_table[$param]['NA'];

					$score = ($defect_table[$param]['Yes'] / $grand_total) * 100;
					$error_count = ($defect_table[$param]['No'] / $grand_total) * 100;

					$sub = array();
		         	/*prepare single lob wise data*/
		         	$sub = array(
		         					ucwords(str_replace('_',' ',$param)),
		         					$defect_table[$param]['Yes'],
		         					$defect_table[$param]['No'],
		         					$defect_table[$param]['NA'],
		         					$grand_total,
		         					is_nan($score) ? 0 : sprintf('%.2f',$score),
		         					is_nan($error_count) ? 0 : sprintf('%.2f',$error_count)
		         				);

		         	$total_no_count += $defect_table[$param]['No'];

		         	$excel_data[] = $sub;
		        }

             	/*starting position*/
				$objWorksheet->fromArray($excel_data,NULL,$startingCol.$startingRow,true);
				$adjustment = (count($header)-1);
				$currentColumn = $startingCol;
				$columnIndex = PHPExcel_Cell::columnIndexFromString($currentColumn);
				$adjustedColumnIndex = $columnIndex + $adjustment;
				$adjustedColumn = PHPExcel_Cell::stringFromColumnIndex($adjustedColumnIndex - 1);
				$objPHPExcel->getActiveSheet()->mergeCells($startingCol.$startingRow.':'.$adjustedColumn.$startingRow);
				$titleStyleArray = array(
				'fill' => array(
					'type' => PHPExcel_Style_Fill::FILL_SOLID,
					'color' => array('rgb' => '188ae2')
				)
				);
				$objWorksheet->getStyle($startingCol.$startingRow.':'.$adjustedColumn.($startingRow+1))->applyFromArray($titleStyleArray);

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
				$endingRow += (count($excel_data) + 1 );
				$objWorksheet->getStyle($startingCol.$startingRow.':'.$adjustedColumn.$endingRow)->applyFromArray($style);

				/*second part*/

				$header = array("Overall Parameters","No","Error Count%","CF%");

				$excel_data = array(
							array(strtoupper(str_replace('qa_cashify_', '', str_replace('_feedback', '', $defect_table_key)))),
							$header
						);
				$params = array_keys($all_defect_table_overall_params[$defect_table_key]);

				$totalpercent = 0;
	            foreach($params as $key => $param){

	            	$errorpercent = 0;
	               $errorpercent = ( $defect_table[$param]['No'] / $total_no_count) * 100;
	               $totalpercent = $totalpercent + $errorpercent;

	               $sub = array();
	             	/*prepare single lob wise data*/
	             	$sub = array(
	             					ucwords(str_replace('_',' ',$param)),
	             					$defect_table[$param]['No'],
	             					(!is_nan($errorpercent) ? sprintf('%.2f', $errorpercent) : 0),
	             					(!is_nan($totalpercent) ? sprintf('%.2f', $totalpercent) : 0)
	             				);
	             	$excel_data[] = $sub;
	            }

             	/*starting position*/
				$objWorksheet->fromArray($excel_data,NULL,'J'.$startingRow,true);
				$adjustment = (count($header)-1);
				$currentColumn = 'J';
				$columnIndex = PHPExcel_Cell::columnIndexFromString($currentColumn);
				$adjustedColumnIndex = $columnIndex + $adjustment;
				$adjustedColumn = PHPExcel_Cell::stringFromColumnIndex($adjustedColumnIndex - 1);
				$objPHPExcel->getActiveSheet()->mergeCells('J'.$startingRow.':'.$adjustedColumn.$startingRow);
				$titleStyleArray = array(
					'fill' => array(
						'type' => PHPExcel_Style_Fill::FILL_SOLID,
						'color' => array('rgb' => '188ae2')
					)
				);
				$objWorksheet->getStyle('J'.$startingRow.':'.$adjustedColumn.($startingRow+1))->applyFromArray($titleStyleArray);

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

				$objWorksheet->getStyle('J'.$startingRow.':'.$adjustedColumn.$endingRow)->applyFromArray($style);

				/*Graph*/

			    /*Line Chart for Audit Count*/
		        $dataSeriesLabels = array(
		            new PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$L$'.($startingRow + 1), NULL, 1),   //  'Budget'
		        );
		        $xAxisTickValues = array(
		            new PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$I$'.($startingRow + 2).':$J$'.$endingRow, NULL),    //  Q1 to Q4 
		        );
		        $dataSeriesValues = array(
		            new PHPExcel_Chart_DataSeriesValues('Number', 'Worksheet!$L$'.($startingRow + 2).':$L$'.$endingRow, NULL),
		        );
		        $series = new PHPExcel_Chart_DataSeries(
		            PHPExcel_Chart_DataSeries::TYPE_LINECHART,       // plotType
		            PHPExcel_Chart_DataSeries::GROUPING_STACKED,  // plotGrouping //GROUPING_STACKED
		            range(0, count($dataSeriesValues)-1),           // plotOrder
		            $dataSeriesLabels,                              // plotLabel
		            $xAxisTickValues,                               // plotCategory
		            $dataSeriesValues                               // plotValues
		        );
		        $series->setPlotDirection(PHPExcel_Chart_DataSeries::DIRECTION_COL);
		        /*Line Chart for Audit Count*/

		        /*Bar Chart for Quality Score*/
		        
		        $dataSeriesLabels1 = array(   
			    	//'Yes,No,Na'
		            new PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$M$'.($startingRow + 1), NULL, 1)
		        );
		        $xAxisTickValues1 = array(
		            new PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$I$'.($startingRow + 2).':$J$'.$endingRow, NULL),    //  Q1 to Q4 for 2010 to 2012
		        );

		        $dataSeriesValues1 = array(
		            new PHPExcel_Chart_DataSeriesValues('Number', 'Worksheet!$M$'.($startingRow + 2).':$M$'.$endingRow, NULL)
		        );

		        $series1 = new PHPExcel_Chart_DataSeries(
		            PHPExcel_Chart_DataSeries::TYPE_BARCHART,       // plotType
		            PHPExcel_Chart_DataSeries::GROUPING_CLUSTERED,  // plotGrouping //GROUPING_STACKED
		            range(0, count($dataSeriesValues1)-1),           // plotOrder
		            $dataSeriesLabels1,                              // plotLabel
		            $xAxisTickValues1,                               // plotCategory
		            $dataSeriesValues1                               // plotValues
		        );
		        $series1->setPlotDirection(PHPExcel_Chart_DataSeries::DIRECTION_COL);
		        /*Bar Chart for Quality Score*/

		        $layout = new PHPExcel_Chart_Layout();
			  	  $layout->setShowVal(true);

		        $plotArea = new PHPExcel_Chart_PlotArea($layout, array($series,$series1));

		        $legend = new PHPExcel_Chart_Legend(PHPExcel_Chart_Legend::POSITION_BOTTOM, NULL, false);

		        $title = new PHPExcel_Chart_Title($objPHPExcel->getActiveSheet()->getCell('B'.$startingRow)->getValue());
		        $xAxisLabel = new PHPExcel_Chart_Title('Parameters');
		        $yAxisLabel = new PHPExcel_Chart_Title('');

		        $chart = new PHPExcel_Chart(
		            'chart'.rand(9999,99999),       // name
		            $title,         // title
		            $legend,        // legend
		            $plotArea,      // plotArea
		            true,           // plotVisibleOnly
		            0,              // displayBlanksAs
		            $xAxisLabel,    // xAxisLabel
		            $yAxisLabel     // yAxisLabel
		        );
		     
		      	$graph_starting_row = 0;
				$graph_ending_row = 0;

	    		$graph_starting_row = $endingRow + 2;
				$graph_ending_row = ($graph_starting_row + 35);
				$chart->setTopLeftPosition('B'.$graph_starting_row);
				$chart->setBottomRightPosition('N'.$graph_ending_row);
				$objWorksheet->addChart($chart);
	        	/*Graph*/

	        	foreach (range('B', 'Z') as $column){
					$objPHPExcel->getActiveSheet()->getColumnDimension($column)->setAutoSize(true);
				}

				/*second part*/
				$endingRow = $graph_ending_row;
	    		$startingRow = ($graph_ending_row + 2);
			}

			/*parameter wise data*/

			foreach (range('B', 'Z') as $column){
				$objPHPExcel->getActiveSheet()->getColumnDimension($column)->setAutoSize(true);
			}

			ob_end_clean();
	        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	        header('Content-Disposition: attachment;filename="one-view-dashboard-report.xlsx' );
	        header('Cache-Control: max-age=0');
	        $writer = PHPExcel_IOFactory::createWriter($objPHPExcel , 'Excel2007');
	        $writer->setIncludeCharts(TRUE);
	        $writer->save('php://output');
		}
	}

	public function qa_calibration(){
		
		if(check_logged_in())
		{
			$current_user = get_user_id();
			$ses_client_id = get_client_ids();
			
			$ses_process_id = get_process_ids();

			$data["aside_template"] = "qa_boomsourcing_aside/aside.php";
			$data["content_template"] = "qa_boomsourcing/qa_calibration_dashboard.php";
			$data["content_js"] = "qa_boomsourcing/qa_calibration_dashboard_js.php";

			$cond="";
			$ticket_cond="";
			
			$from_date = $this->input->get('from_date') ? $this->input->get('from_date') : date('Y-m-01');	
			$to_date = $this->input->get('to_date') ? $this->input->get('to_date') : date('Y-m-d');
			$process_id = $this->input->get('process_id') ? $this->input->get('process_id') : 578;
			
			$dateCondition = " AND (DATE(getEstToLocal(entry_date,$current_user)) >= '$from_date' and DATE(getEstToLocal(entry_date,$current_user)) <= '$to_date' )";
			
			$data['ticket'] = $ticket_id = !empty($this->input->get('ticket_id')) ? $this->input->get('ticket_id') : array("ALL");

			if($ticket_id != ""){
				if(!in_array("ALL",$ticket_id)){
					$ticket = implode('","', $ticket_id);
				}
			}

			$qSql = "SELECT p.id AS pro_id,p.name AS process_name FROM qa_boomsourcing_defect AS q INNER JOIN process AS p ON p.id = q.process_id";
			$data['process_list'] = $this->Common_model->get_query_result_array($qSql);
			


			$data['master_auditor'] = array();
			$data['regular_auditor'] = array();
			$data['params_columns'] = array();
			$data['parameter_score'] = array();

			if($this->input->get('btnView') != ''){

				$query = "SELECT table_name, params_columns FROM qa_boomsourcing_defect WHERE is_active = 1";
				$row = $this->Common_model->get_query_result_array($query);

				$ticket_n = array();
				foreach($row as $defect_data){
					$ticketSql="SELECT ticket_id FROM ".$defect_data['table_name']." WHERE audit_type = 'Calibration' AND auditor_type = 'Master' $dateCondition GROUP BY ticket_id";
					$ticket_data = $this->Common_model->get_query_result_array($ticketSql);
					
					$ticket_n = array_merge($ticket_n,$ticket_data);

			
					$master_auditors = $this->master_auditor(array("table"=>$defect_data['table_name'],"from_date"=>$from_date,"to_date"=>$to_date,"ticket"=>$ticket));

					foreach($master_auditors as $m_data){
						$master_auditor_data[] = $m_data;
					}
					
					$data['params_columns'] = $defect_data['params_columns'];
					$parameter_scores = $this->parameter_score(array("table"=>$defect_data['table_name'],"from_date"=>$from_date,"to_date"=>$to_date,"ticket"=>$ticket,"params_columns" => $defect_data['params_columns']));

					foreach($parameter_scores as $p_data){
						$parameter_score_data[] = $p_data;
					}
					$regular_auditors = $this->regular_auditor(array("table"=>$defect_data['table_name'],"from_date"=>$from_date,"to_date"=>$to_date,"ticket"=>$ticket,"params_columns" => $defect_data['params_columns']));

					if(!empty($regular_auditors)){

						$params_columns = $defect_data['params_columns'];
						$param_col = explode(",",$params_columns);
						$param_col_count = count($param_col);
						
						$prefix = 'ms_';
						foreach ($param_col as $key => $item) {
							$regular_param_col[$key] = $prefix.$item;
						}

						foreach($regular_auditors as $r_data){

							if(!empty($r_data)){

								$r_data['original_param'] = $param_col;
								$r_data['regular_param_col'] = $regular_param_col;
								$r_data['param_col_count'] = $param_col_count;
								$r_data['tableName'] = $defect_data['table_name'];
								$regular_auditor_data[] = $r_data;
							}
						}
					}
				}
				
				/*End*/
				if($this->input->get("excel_report")){

					$from_date = $this->input->get('from_date');
					$to_date = $this->input->get('to_date');
					$process_id = $this->input->get('process_id');
					$ticket_id = $this->input->get('ticket_id');
					$this->generate_Calib_xls($process_id, $master_auditor_data, $regular_auditor_data);
				}
			}

			$data['master_auditor'] = $master_auditor_data;
			$data['regular_auditor']  = $regular_auditor_data;
			$data['parameter_score']  = $parameter_score_data;
			$data['ticket'] = $ticket_n;
			$data["from_date"] = $from_date;
			$data["to_date"] = $to_date;
			$data["process_id"] = $process_id;

			$this->load->view("dashboard",$data);
		}
	}

	private function master_auditor($params){

		extract($params);

		$current_user = get_user_id();
		$dateCondition = " AND (DATE(getEstToLocal(entry_date,$current_user)) >= '$from_date' and DATE(getEstToLocal(entry_date,$current_user)) <= '$to_date' )";

		$pros_cond = '';
		$ticket_cond = '';
		
		if($ticket != ""){
			$ticket_cond =' AND ticket_id IN ("'.$ticket.'")';
		}

		$qSql="SELECT entry_by, ticket_id,(SELECT concat(fname, ' ', lname) AS name FROM signin s WHERE s.id = entry_by) AS entry_name, (SELECT location FROM office_location WHERE abbr = (SELECT office_id FROM signin os WHERE os.id = entry_by)) AS qa_location,DATE(audit_date) AS audit_date, overall_score FROM $table LEFT JOIN signin ON $table.entry_by = signin.id WHERE 1 $dateCondition AND audit_type = 'Calibration' AND auditor_type = 'Master' $ticket_cond ORDER BY audit_date, ticket_id";

		$query = $this->db->query($qSql);
        return $query->result_array();
	}

	private function regular_auditor($params){
		
		extract($params);

		$current_user = get_user_id();
		$ticket_cond = '';
		$user_cond = '';
		
		$dateCondition = " AND (DATE(getEstToLocal(entry_date,$current_user)) >= '$from_date' and DATE(getEstToLocal(entry_date,$current_user)) <= '$to_date' )";

		if($ticket!=""){
			$ticket_cond =' AND ticket_id IN ("'.$ticket.'")';
		}
		
		if(!get_global_access()==1){
			$user_cond = ' AND entry_by = "'.$current_user.'"';
		}
		
		$array = explode(',', $params_columns);
		$prefix = ' as ms_';
		foreach ($array as $key => $item) {
			$array[$key] = $item.$prefix.$item;
		}
		$ms_param = implode (',', $array);

		$qSql = "SELECT * FROM (SELECT entry_by, ticket_id AS regular_ticket, (SELECT concat(fname, ' ', lname) AS name FROM signin s WHERE s.id = entry_by) AS entry_name, (SELECT location FROM office_location WHERE abbr = (SELECT office_id FROM signin os WHERE os.id = entry_by)) AS qa_location, DATE(audit_date) AS audit_date, overall_score, $params_columns FROM $table LEFT JOIN signin ON $table.entry_by = signin.id WHERE 1 $dateCondition AND audit_type = 'Calibration' AND auditor_type = 'Regular' $ticket_cond $user_cond) xx LEFT JOIN (SELECT DATE(audit_date) AS auditDate, ticket_id AS master_ticket, overall_score AS ms_overScr, $ms_param FROM $table WHERE 1 $dateCondition AND audit_type = 'Calibration' AND auditor_type = 'Master') yy On (xx.regular_ticket=yy.master_ticket) WHERE yy.auditDate IS NOT NULL ORDER BY audit_date, regular_ticket";
		$query = $this->db->query($qSql);
        return $query->result_array();
	}

	private function parameter_score($params){

		extract($params);
		
		$current_user = get_user_id();
		$dateCondition = " AND (DATE(getEstToLocal(entry_date,$current_user)) >= '$from_date' and DATE(getEstToLocal(entry_date,$current_user)) <= '$to_date' )";

		$qSql="SELECT (SELECT concat(fname, ' ', lname) AS name FROM signin s WHERE s.id = entry_by) AS entry_name, (SELECT location FROM office_location WHERE abbr = (SELECT office_id FROM signin os WHERE os.id = entry_by)) AS qa_location, ticket_id, DATE(audit_date) AS audit_date, auditor_type, $params_columns, overall_score FROM $table LEFT JOIN signin ON $table.entry_by = signin.id WHERE 1 $dateCondition AND audit_type = 'Calibration' ORDER BY ticket_id,auditor_type ASC";
		$query = $this->db->query($qSql);
		return $query->result_array();
	}

	private function generate_Calib_xls($process_id, $master_data, $regular_data){

		if(check_logged_in()){

			$objPHPExcel = new PHPExcel();

			/*Master Auditor Score*/
			
    		$objWorksheet = $objPHPExcel->getActiveSheet(0);
    		$objWorksheet = $objPHPExcel->createSheet(0);
    		$objWorksheet->setTitle("Master Auditor Score");
    		$startingCol = 'B';
	    	$startingRow = 2;

	    	// $objWorksheet->setCellValueByColumnAndRow(0, 1, "Calibration Dashboard");

	    	$header = array("SL. No.","Auditor","Location","Audit Date","Ticket ID","Overall Score (%)");
    		$excel_data = array(
							array("Master Auditor Score"),
							$header,
							
						);

    		foreach ($master_data as $key => $data) {
				
    			$sub = array();
            	$sub = array(	
            					($key + 1),
            					$data['entry_name'],
            					$data['qa_location'],
            					$data['audit_date'],
            					$data['ticket_id'],
            					$data['overall_score']
            				);
            	$excel_data[] = $sub;
			}

			$objWorksheet->fromArray($excel_data,NULL,$startingCol.$startingRow,true);
			$adjustment = (count($header)-1);
			$currentColumn = $startingCol;
			$columnIndex = PHPExcel_Cell::columnIndexFromString($currentColumn);
			$adjustedColumnIndex = $columnIndex + $adjustment;
			$adjustedColumn = PHPExcel_Cell::stringFromColumnIndex($adjustedColumnIndex - 1);
			// $objPHPExcel->getActiveSheet(0)->mergeCells('B2:'.$adjustedColumn.'2');
			$objWorksheet->mergeCells('B2:'.$adjustedColumn.'2');

			$titleStyleArray = array(
									'fill' => array(
										'type' => PHPExcel_Style_Fill::FILL_SOLID,
										'color' => array('rgb' => '188ae2')
									),
									'alignment' => array(
									       'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
									   )
									);

			$objWorksheet->getStyle('B2:'.$adjustedColumn.'2')->applyFromArray($titleStyleArray);
			$objWorksheet->getStyle('B3:'.$adjustedColumn.'3')->applyFromArray($titleStyleArray);
			$tableBorderStyle = array(
									   'borders' => array(
									       'allborders' => array(
									         'style' => PHPExcel_Style_Border::BORDER_THIN
									       )
									   ),
									   'alignment' => array(
									       'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
									   )
									);

			$endingRow = (count($excel_data) + 1 );
			$objWorksheet->getStyle('B2:'.$adjustedColumn.$endingRow)->applyFromArray($tableBorderStyle);
			
			foreach (range('B', 'Z') as $column){
				$objPHPExcel->getActiveSheet()->getColumnDimension($column)->setAutoSize(true);
			}

			/*Regular Auditor Score*/

			$startingCol = 'B';
	    	$startingRow = 2;

			unset($header);
			unset($excel_data);

			$objWorksheet = $objPHPExcel->getActiveSheet(1);
			$objWorksheet = $objPHPExcel->createSheet(1);
    		$objWorksheet->setTitle("Regular Auditor Score");

    		$header = array("SL. No.","Auditor","Location","Audit Date","Ticket ID","Overall Score (%)","Variance","Parameter Variance","Parameter Variance (%)");
    		$excel_data = array(
							array("Regular Auditor Score"),
							$header,
							
						);

    		
			foreach ($regular_data as $key => $data) {

				$regular_param_col = $data['regular_param_col'];
				$original_param = $data['original_param'];
				$param_col_count = $data['param_col_count'];
				$variance = ( floatval($data['ms_overScr']) - floatval($data['overall_score']) );
				for($i=0; $i<count($regular_param_col); $i++){
					if($data[$regular_param_col[$i]] != $data[$original_param[$i]]){
						$col[$i]=1;
					}
					else{
						$col[$i]=0;
					}
				}
				$calibration_variance = array_sum($col);

				$sub = array();
            	$sub = array(	
            					($key + 1),
            					$data['entry_name'],
            					$data['qa_location'],
            					$data['audit_date'],
            					$data['regular_ticket'],
            					$data['overall_score'],
            					$variance,
            					$calibration_variance.'/'.$param_col_count,
            					Round(($calibration_variance/$param_col_count)*100,2)	
            				);
            	$excel_data[] = $sub;
			}

			$objWorksheet->fromArray($excel_data,NULL,$startingCol.$startingRow,true);

			$adjustment = (count($header)-1);
			$currentColumn = $startingCol;
			$columnIndex = PHPExcel_Cell::columnIndexFromString($currentColumn);
			$adjustedColumnIndex = $columnIndex + $adjustment;
			$adjustedColumn = PHPExcel_Cell::stringFromColumnIndex($adjustedColumnIndex - 1);
			// $objPHPExcel->getActiveSheet(1)->mergeCells('B2:'.$adjustedColumn.'2');
			$objWorksheet->mergeCells('B2:'.$adjustedColumn.'2');

			$titleStyleArray = array(
									'fill' => array(
										'type' => PHPExcel_Style_Fill::FILL_SOLID,
										'color' => array('rgb' => '188ae2')
									),
									'alignment' => array(
									       'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
									   )
									);

			$objWorksheet->getStyle('B2:'.$adjustedColumn.'2')->applyFromArray($titleStyleArray);
			$objWorksheet->getStyle('B3:'.$adjustedColumn.'3')->applyFromArray($titleStyleArray);
			$tableBorderStyle = array(
									   'borders' => array(
									       'allborders' => array(
									         'style' => PHPExcel_Style_Border::BORDER_THIN
									       )
									   ),
									   'alignment' => array(
									       'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
									   )
									);

			$endingRow = (count($excel_data) + 1 );
			$objWorksheet->getStyle('B2:'.$adjustedColumn.$endingRow)->applyFromArray($tableBorderStyle);

			foreach (range('B', 'Z') as $column){
				$objPHPExcel->getActiveSheet(1)->getColumnDimension($column)->setAutoSize(true);
			}

			ob_end_clean();
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename="calibration_data.xlsx"');
			header('Cache-Control: max-age=0');
			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel , 'Excel2007');
			$objWriter->setIncludeCharts(TRUE);
			$objWriter->save('php://output');
			exit();	
		}
	}

	public function view_calibration_variance($auditor_id,$ticket_id,$table_name){

		if(check_logged_in()){

			$data["aside_template"] = "qa_boomsourcing_aside/aside.php";
			$data["content_template"] = "qa_boomsourcing/view_calibration_variance.php";
			$data["content_js"] = "qa_boomsourcing/qa_calibration_dashboard_js.php";

			/*Using process id find out table name */
			$sqlD = "SELECT table_name,params_columns FROM qa_boomsourcing_defect WHERE table_name= '".$table_name."'";
			$result = $this->db->query($sqlD);
			$defect_result = $result->row();
			$table = $defect_result->table_name;
			$parameter = $defect_result->params_columns;
			$paramArr = explode(',',$defect_result->params_columns);
			$data['paramArr']=$paramArr;
			/* End */
			
			$masterSql = "SELECT *,".$parameter." FROM (SELECT *, (SELECT concat(fname, ' ', lname) AS name FROM signin s WHERE s.id=entry_by) AS auditor_name FROM ".$table." WHERE ticket_id = $ticket_id and audit_type = 'Calibration' and auditor_type = 'Master') xx LEFT JOIN (SELECT id AS sid, concat(fname, ' ', lname) AS agent_name, xpoid, fusion_id, office_id, assigned_to, get_process_names(id) AS process FROM signin) yy ON (xx.agent_id = yy.sid)";

			$data["ata_audit"] = $this->Common_model->get_query_row_array($masterSql);
			
			$regularSql = "SELECT *,$parameter FROM (SELECT *, (SELECT concat(fname, ' ', lname) AS name FROM signin s WHERE s.id=entry_by) AS auditor_name FROM $table WHERE entry_by= $auditor_id and ticket_id = $ticket_id) xx LEFT JOIN (SELECT id AS sid, concat(fname, ' ', lname) AS agent_name, xpoid, fusion_id, office_id, assigned_to, get_process_names(id) AS process FROM signin) yy on (xx.agent_id = yy.sid)";

			$data["qa_audit"] = $this->Common_model->get_query_row_array($regularSql);
			
			$this->load->view("dashboard",$data);
		}
	}
}