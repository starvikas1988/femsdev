<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Qa_one_view_dashboard extends CI_Controller {

	function __construct() {

		parent::__construct();
		$this->load->model('Common_model');
		$this->load->model('Profile_model');
		$this->load->library('excel');
	}
	
	/**
	* ================================================
	* 		Created By: SOURAV SARKAR
	* 		Created On: 29-12-2022
	* ================================================
	**/

	public function one_view_dashboard()
	{
		if(check_logged_in()){

			$current_user     = get_user_id();
			$user_site_id     = get_user_site_id();
			$user_oth_office  = get_user_oth_office();
			$is_global_access = get_global_access();
			$role_dir         = get_role_dir();
			$role_id          = get_role_id();
			$get_dept_id      = get_dept_id();
			
			$data["aside_template"]   = "qa/aside.php";
			$data["content_template"] = "qa_one_view_dashboard/qa_one_view_dashboard.php";
			$data["content_js"] = "qa_one_view_dashboard/qa_one_view_dashboard_js.php";

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

			/*Client List*/
			$sql = "SELECT c.id AS client_id,c.fullname AS client_name FROM client c WHERE c.id <> 0 AND c.is_active = 1";
			$data['client_list'] = $all_client =  $this->db->query($sql)->result_array();

			$data['selected_client_id'] = $client_id = !empty($this->input->get('select_client')) ? $this->input->get('select_client') : 133;

			$campaign_id = !empty($this->input->get('select_campaign')) ? $this->input->get('select_campaign') : array('ALL');

			$selected_process = !empty($this->input->get('select_process')) ? $this->input->get('select_process') : 259;
			
			$campaign_condition = "";
			if(!in_array('ALL',$campaign_id)){
				$campaign_id = implode(',',$campaign_id);
				$campaign_condition = "AND qd.id IN ($campaign_id)";
			}
			/*Date condition*/
			$dateCondition = "";
			if(in_array($rep_type,['daily','weekly'])){

				$data['select_from_date'] = $start_date = date('Y-m-d',strtotime($this->input->get('select_from_date')));
				$data['select_to_date'] = $end_date = date('Y-m-d',strtotime($this->input->get('select_to_date')));

				$dateCondition = " AND DATE(qa.audit_date) >= '$start_date' AND DATE(qa.audit_date) <= '$end_date'";
			}
			elseif($rep_type =='monthly'){

				$data['selected_month'] = $month = !empty($this->input->get('select_month')) ? $this->input->get('select_month') : array(date('m'));
				$mnth_strng = implode(',',$month);

				$data['selected_year'] = $year = !empty($this->input->get('select_year')) ? $this->input->get('select_year') : date('Y');
				$s_mnth = min($month);
				$e_mnth = max($month);
				$start_date = date('Y-m-01',strtotime($year.'-'.$s_mnth.'-1'));
				$end_date = date('Y-m-t',strtotime($year.'-'.$e_mnth.'-1'));

				$dateCondition = " AND MONTH(qa.audit_date) in($mnth_strng) AND YEAR(qa.audit_date) = $year";
			}
			else
			{
				$start_date = date('Y-m-d');
				$end_date = date('Y-m-d');
				$dateCondition = " AND DATE(qa.audit_date) >= '$start_date' AND DATE(qa.audit_date) <= '$end_date'";
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

			$sql = "SELECT table_name,params_columns,fatal_param FROM qa_defect qd WHERE qd.id <> 0 AND qd.is_active = 1 AND qd.client_id = $client_id AND FLOOR(process_id) = $selected_process $campaign_condition";
			$qa_defects = $this->db->query($sql)->result_array();

			$week_wise_data = array();
			$date_wise_audit_data = array();
			$location_wise_audit_data = array();
			$evaluator_wise_audit_data = array();
			$tl_wise_audit_data = array();
			$agent_wise_audit_data = array();

			$month_wise_sql = "";
			$date_wise_sql = "";
			$location_wise_sql = "";
			$evalutaor_wise_sql = "";
			$tl_wise_sql = "";
			$agent_wise_sql = "";
			$union_condtion = "";

			if(!empty($qa_defects)){

				foreach($qa_defects as $qa_defect){

					$qa_defect_table = $qa_defect['table_name'];

					/*Month Wise Data*/
					$month_wise_sql .= $union_condtion."SELECT COUNT(qa.id) as total_audit,MONTH(audit_date) as audit_month, SUM(qa.overall_score) as total_cq_score,SUM(CASE WHEN qa.overall_score = 0 THEN 1 ELSE 0 END) as audit_fatal FROM $qa_defect_table qa LEFT JOIN signin s ON s.id = qa.agent_id LEFT JOIN office_location l ON l.abbr = s.office_id WHERE 1 $office_condition $dateCondition GROUP BY audit_month";
					/*Month Wise Data*/
					

					/*Week wise data*/
					foreach($weeks as $key => $week){

						$weekCondition = " AND WEEK(audit_date) = $week";

						$weekly_total_audit = 0;
						$weekly_total_cq_score = 0;
						$weekly_fatal_count = 0;

						$totalWeeklyDefect = 0;
						$weeklyFatalCounter = 0;

						/*Weeky Trend*/
						$weeklyData = $this->db->query("SELECT COUNT(qa.id) as total_audit, SUM(qa.overall_score) as total_cq_score,SUM(CASE WHEN qa.overall_score = 0 THEN 1 ELSE 0 END) as audit_fatal FROM $qa_defect_table qa LEFT JOIN signin s ON s.id = qa.agent_id LEFT JOIN office_location l ON l.abbr = s.office_id WHERE 1 $office_condition $dateCondition $weekCondition")->row_array();
						$weekly_total_audit = $weeklyData['total_audit'];
						$weekly_total_cq_score = $weeklyData['total_cq_score'];
						$weekly_fatal_count = $weeklyData['audit_fatal'];

						$week_wise_data = array_merge($week_wise_data,array(array(
																	'week_number'=>$week,
																	'total_audit' => $weekly_total_audit,
																	'cq_score' => $weekly_total_cq_score,
																	'weekly_fatal_count' => $weekly_fatal_count
																	)));
					}
					/*Week wise data*/

					/*Date Wise Audit*/
					$date_wise_sql .= $union_condtion."SELECT audit_date,COUNT(qa.id) as audit_count, COALESCE(ROUND(SUM(qa.overall_score),2),0) AS cq_score_sum, SUM(CASE WHEN qa.overall_score = 0 THEN 1 ELSE 0 END) as audit_fatal FROM $qa_defect_table qa LEFT JOIN signin s ON s.id = qa.agent_id LEFT JOIN office_location l ON l.abbr = s.office_id WHERE 1 $office_condition $dateCondition GROUP BY audit_date";
					/*Date Wise Audit*/

					/*Location Wise*/
					$location_wise_sql .= $union_condtion."SELECT s.office_id,l.office_name,COUNT(qa.id) as audit_count, COALESCE(ROUND(SUM(qa.overall_score),2),0) AS cq_score_sum, SUM(CASE WHEN qa.overall_score = 0 THEN 1 ELSE 0 END) as fatal_count FROM $qa_defect_table qa LEFT JOIN signin s ON s.id = qa.agent_id LEFT JOIN office_location l ON l.abbr = s.office_id WHERE 1 $office_condition $dateCondition GROUP BY office_name";
					/*Location Wise*/

					/*Evaluator wise data*/
					$evalutaor_wise_sql .= $union_condtion."SELECT qa.entry_by,CONCAT(s.fname,' ',s.lname,IF(s.xpoid IS NULL or s.xpoid = '', '', CONCAT(' ( ',s.xpoid,' )'))) as auditor_name,COUNT(qa.id) as audit_count, COALESCE(ROUND(SUM(qa.overall_score),2),0) AS cq_score_sum, SUM(CASE WHEN qa.overall_score = 0 THEN 1 ELSE 0 END) as audit_fatal FROM $qa_defect_table qa LEFT JOIN signin s ON s.id = qa.entry_by LEFT JOIN office_location l ON l.abbr = s.office_id WHERE 1 $office_condition $dateCondition GROUP BY qa.entry_by";
					/*Evaluator wise data*/

					/*TL wise data*/
					$tl_wise_sql .= $union_condtion."SELECT qa.tl_id, CONCAT(s.fname,' ',s.lname,IF(s.xpoid IS NULL or s.xpoid = '', '', CONCAT(' ( ',s.xpoid,' )'))) as tl_name,COUNT(qa.id) as audit_count, COALESCE(ROUND(SUM(qa.overall_score),2),0) AS cq_score_sum, SUM(CASE WHEN qa.overall_score = 0 THEN 1 ELSE 0 END) as audit_fatal FROM $qa_defect_table qa LEFT JOIN signin s ON s.id = qa.tl_id LEFT JOIN office_location l ON l.abbr = s.office_id WHERE 1 $office_condition $dateCondition GROUP BY qa.tl_id";
					/*TL wise data*/
					
					/*Agent wise data*/

					$agent_wise_sql .= $union_condtion."SELECT qa.agent_id, CONCAT(s.fname,' ',s.lname,IF(s.xpoid IS NULL or s.xpoid = '', '', CONCAT(' ( ',s.xpoid,' )'))) as agent_name,COUNT(qa.id) as audit_count, COALESCE(ROUND(SUM(qa.overall_score),2),0) AS cq_score_sum,SUM(CASE WHEN qa.overall_score = 0 THEN 1 ELSE 0 END) as audit_fatal,COALESCE(SUM(CASE WHEN qa.agnt_fd_acpt = 'Accepted' THEN 1 ELSE 0 END),0) AS accepted,COALESCE(SUM(CASE WHEN qa.agnt_fd_acpt = 'Not Accepted' THEN 1 ELSE 0 END),0) AS rejected,COALESCE(SUM(CASE WHEN qa.agnt_fd_acpt = '' OR qa.agnt_fd_acpt IS NULL THEN 1 ELSE 0 END),0) AS pending FROM $qa_defect_table qa INNER JOIN signin s ON s.id = qa.agent_id LEFT JOIN office_location l ON l.abbr = s.office_id WHERE 1 $office_condition $dateCondition  GROUP BY qa.agent_id";

					/*Agent wise data*/

					$union_condtion = " UNION ALL ";
				}
				
				/*Month Wise Data*/
				$sql = "SELECT MONTHNAME(STR_TO_DATE(audit_month, '%m')) as audit_month,COALESCE(SUM(total_audit),0) as total_audit,COALESCE(SUM(audit_fatal),0) as audit_fatal,COALESCE(ROUND(SUM(total_cq_score) / SUM(total_audit),2),0) as cq_score FROM ($month_wise_sql) as tmp GROUP BY audit_month";

				$month_wise_data = $this->db->query($sql)->result_array();
				/*Month Wise Data*/

				/*addition of all week wise data*/
				$final_week_wise_data = array_reduce(
	                    $week_wise_data,
	                    function (array $carry, array $item) {
	                        $week_number = $item['week_number'];
	                        if (array_key_exists($week_number, $carry)) {
	                            
	                            $carry[$week_number]['total_audit'] += $item['total_audit'];
	                            $carry[$week_number]['cq_score'] += $item['cq_score'];
	                            $carry[$week_number]['weekly_fatal_count'] += $item['weekly_fatal_count'];


	                        } else {
	                            $carry[$week_number] = $item;
	                        }
	                        return $carry;
	                    },
	                    array()
	                );

				/*sort data weeknumber wise*/
				array_multisort( array_column($final_week_wise_data, "week_number"), SORT_ASC, $final_week_wise_data );

				/*Date Wise Data*/
				$sql = "SELECT audit_date,COALESCE(SUM(audit_count),0) as audit_count,COALESCE(SUM(audit_fatal),0) as audit_fatal,COALESCE(ROUND(SUM(cq_score_sum) / SUM(audit_count),2),0) as cq_score FROM ($date_wise_sql) as tmp GROUP BY audit_date";
				$date_wise_audit_data = $this->db->query($sql)->result_array();
				/*Date Wise Data*/

				/*Location Wise Data*/
				$sql = "SELECT office_id,office_name,COALESCE(SUM(audit_count),0) as audit_count,COALESCE(SUM(fatal_count),0) as fatal_count,COALESCE(ROUND(SUM(cq_score_sum) / SUM(audit_count),2),0) as cq_score FROM ($location_wise_sql) as tmp GROUP BY office_name";
				$location_wise_audit_data = $this->db->query($sql)->result_array();
				/*Location Wise Data*/

				/*Evaluator Wise Data*/
				$sql = "SELECT entry_by,auditor_name,COALESCE(SUM(audit_count),0) as audit_count,COALESCE(SUM(audit_fatal),0) as audit_fatal,COALESCE(ROUND(SUM(cq_score_sum) / SUM(audit_count),2),0) as cq_score FROM ($evalutaor_wise_sql) as tmp GROUP BY entry_by";
				$evaluator_wise_audit_data = $this->db->query($sql)->result_array();
				/*Evaluator Wise Data*/

				/*TL wise data*/
				$sql = "SELECT tl_id,tl_name,COALESCE(SUM(audit_count),0) as audit_count,COALESCE(SUM(audit_fatal),0) as audit_fatal,COALESCE(ROUND(SUM(cq_score_sum) / SUM(audit_count),2),0) as cq_score FROM ($tl_wise_sql) as tmp GROUP BY tl_id";
				$tl_wise_audit_data = $this->db->query($sql)->result_array();
				/*TL wise data*/

				/*Agent Wise Data*/
				$sql = "SELECT agent_id,agent_name,COALESCE(SUM(audit_count),0) as audit_count,COALESCE(SUM(audit_fatal),0) as audit_fatal,COALESCE(ROUND(SUM(cq_score_sum) / SUM(audit_count),2),0) as cq_score,COALESCE(SUM(accepted),0) as accepted,COALESCE(SUM(rejected),0) as rejected,COALESCE(SUM(pending),0) as pending FROM ($agent_wise_sql) as tmp GROUP BY agent_id";
				$agent_wise_audit_data = $this->db->query($sql)->result_array();
				/*Agent Wise Data*/
			}

			/*For Excel report*/
			$excel_report = $this->input->get('excel_report');
			if(!empty($excel_report) && $excel_report==true){
				$params = array("weekly_data" => $final_week_wise_data,"month_wise_data" =>$month_wise_data,'date_wise_audit_data'=>$date_wise_audit_data,'location_wise_audit_data'=>$location_wise_audit_data,'evaluator_wise_audit_data'=>$evaluator_wise_audit_data,'tl_wise_audit_data'=>$tl_wise_audit_data,'agent_wise_audit_data'=>$agent_wise_audit_data);

				$this->generate_excel_report($params);
				die;
			}

			$data['weekly_data'] = $final_week_wise_data;
			$data['month_wise_data'] = $month_wise_data;
			$data['date_wise_audit_data'] = $date_wise_audit_data;
			$data['location_wise_audit_data'] = $location_wise_audit_data;
			$data['evaluator_wise_audit_data'] = $evaluator_wise_audit_data;
			$data['tl_wise_audit_data'] = $tl_wise_audit_data;
			$data['agent_wise_audit_data'] = $agent_wise_audit_data;
			$this->load->view('dashboard',$data);
		}
	}

	/**
	* ================================================
	* 		Created By: SOURAV SARKAR
	* 		Created On: 29-12-2022
	* ================================================
	**/

	public function generate_excel_report($params){

		if(check_logged_in()){

			extract($params);

			$objPHPExcel = new PHPExcel();
    		$objWorksheet = $objPHPExcel->getActiveSheet();
    		$startingCol = 'B';
	    	$startingRow = 2;

			/**
			* ==========================
			* 		Weekly Trend
			* ==========================
			**/

    		$header = array("WEEK","NO OF AUDIT","NO OF FATAL","QUALITY SCORE");
    		$excel_data = array(
							array("Weekly Trend"),
							$header
						);
    		foreach($weekly_data as $week){

    			$avg_cq = !empty($week['total_audit']) ? number_format((float)($week['cq_score'] / $week['total_audit']), 2) : 0;

    			$sub = array();
            	$sub = array(
            					'Week-'.$week['week_number'],
            					$week['total_audit'],
            					$week['weekly_fatal_count'],
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

			/*Weekly Trend Graph*/

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

			/**
			* ==========================
			* 		Monthly Trend
			* ==========================
			**/

			$startingRow = $graph_ending_row + 2;
			unset($header);
			unset($excel_data);
			$header = array("MONTH","NO OF AUDIT","NO OF FATAL","QUALITY SCORE");
    		$excel_data = array(
							array("Monthly Trend"),
							$header,
						);
    		foreach($month_wise_data as $item){

    			$sub = array();
            	$sub = array(
            					$item['audit_month'],
            					$item['total_audit'],
            					$item['audit_fatal'],
            					$item['cq_score']
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
    		/*Monthly Trend Graph*/
			
    		/**
			* ==========================
			* 		Date Wise Audit
			* ==========================
			**/

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
								$item['cq_score'],
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

	        /*$xAxisLabel = new PHPExcel_Chart_Title($objPHPExcel->getActiveSheet()->getCell('C'.($startingRow+1))->getValue());
	        $yAxisLabel = new PHPExcel_Chart_Title($objPHPExcel->getActiveSheet()->getCell('D'.($startingRow+1))->getValue());*/

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

			/**
			* ==========================
			* 		Location Wise Audit
			* ==========================
			**/

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
								$item['cq_score'],
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

			// $xAxisLabel = new PHPExcel_Chart_Title($objPHPExcel->getActiveSheet()->getCell('C'.($startingRow+1))->getValue());
			// $yAxisLabel = new PHPExcel_Chart_Title($objPHPExcel->getActiveSheet()->getCell('D'.($startingRow+1))->getValue());

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

			/**
			* ==================================
			* 		Evaluator Wise Audit
			* ==================================
			**/

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
								$item['cq_score'],
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

			// $xAxisLabel = new PHPExcel_Chart_Title($objPHPExcel->getActiveSheet()->getCell('C'.($startingRow+1))->getValue());
			// $yAxisLabel = new PHPExcel_Chart_Title($objPHPExcel->getActiveSheet()->getCell('D'.($startingRow+1))->getValue());

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

			/**
			* ==================================
			* 		TL Wise Audit
			* ==================================
			**/

			$startingRow = $graph_ending_row + 2;

			unset($header);
			unset($excel_data);

			$header = array("TL Name","Audit Count","Quality Score","Fatal Count");
			$excel_data = array(
						array("TL Wise Audit"),
						$header
					);
			foreach($tl_wise_audit_data as $item){

				$sub = array();
				$sub = array(
								$item['tl_name'],
								$item['audit_count'],
								$item['cq_score'],
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

			// $xAxisLabel = new PHPExcel_Chart_Title($objPHPExcel->getActiveSheet()->getCell('C'.($startingRow+1))->getValue());
			// $yAxisLabel = new PHPExcel_Chart_Title($objPHPExcel->getActiveSheet()->getCell('D'.($startingRow+1))->getValue());

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
			

			/**
			* ==================================
			* 		Agent Wise Data
			* ==================================
			**/

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
								$item['cq_score'],
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

			/*Location Wise Audit*/
			foreach (range('B', 'Z') as $column){
				$objPHPExcel->getActiveSheet()->getColumnDimension($column)->setAutoSize(true);
			}

			ob_end_clean();
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename=all-in-one-report.xlsx');
			header('Cache-Control: max-age=0');
			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel , 'Excel2007');
			$objWriter->setIncludeCharts(TRUE);
			$objWriter->save('php://output');
		}
	}

	public function get_process_by_client(){

		if(check_logged_in()){
			$client_id = $this->input->post('clientId');

			$sql = "SELECT p.id as process_id,p.name as process_name FROM process p WHERE p.id <> 0 AND p.is_active = 1 AND p.client_id = $client_id";
			$process_list = $this->db->query($sql)->result_array();

			echo json_encode(array('success'=>true,'processList'=>$process_list));
		}
	}

	public function get_campaign_by_process(){

		if(check_logged_in()){
			$client_id = $this->input->post('clientId');
			$process_id = $this->input->post('processId');

			$sql = "SELECT qd.id as campaign_id,REPLACE(REPLACE(REPLACE(qd.table_name,'qa_',''),'_feedback',''),'_',' ') as campaign_name FROM qa_defect qd WHERE qd.id <> 0 AND qd.is_active = 1 AND qd.client_id = $client_id AND FLOOR(qd.process_id) = $process_id";
			$campaign_list = $this->db->query($sql)->result_array();

			echo json_encode(array('success'=>true,'campaignList'=>$campaign_list));
		}
	}
}