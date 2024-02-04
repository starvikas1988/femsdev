<?php
	function value_calculation($kpi_type,$kpi_value,$return=false)
	{
		if($kpi_value != '')
		{
			$kpi_value = $kpi_value;
			if($kpi_type == 1 ) 
			{
				if($return == false)
				{
					$kpiDispVal = '-';
				}
				else
				{
					$kpiDispVal = $kpi_value;
				}
			}
			else if($kpi_type == 7 ) $kpiDispVal = round($kpi_value);
			else if($kpi_type == 8 ) $kpiDispVal = sprintf("%1.2f",round(($kpi_value),2));
			else if($kpi_type == 9 ) $kpiDispVal = gmdate("H:i:s", ($kpi_value * 24 * 60 * 60 ));
			else if($kpi_type == 10 )
			{
				$UNIX_DATE = ($kpi_value - 25569) * 86400;
				if($return == false)
				{
					$kpiDispVal = '-';
				}
				else
				{
					$kpiDispVal = gmdate("Y-m-d", $UNIX_DATE);
				}
			}
			else $kpiDispVal = sprintf("%1.2f",round(($kpi_value*100.0),2)) . "%";
		}
		else
		{
				$kpiDispVal = '-';
		}
		return $kpiDispVal;
	}
	function prepare_row($design_id,$kpi_col,$kpi_data,$qa_data,$target)
	{
		foreach($kpi_col[$design_id] as $key=>$info)
		{
			$available_kpi_name[] = $info->kpi_name;
		}
		$available_kpi_name[] = 'CQ_SCORE';
		$available_kpi_name[] = 'Total Score';
		$available_kpi_name[] = 'Grade';
		
		$agent_target = array();
		$col_name_array = array();
		$col_val_array = array();
		foreach($kpi_data[$design_id] as $k=>$v)
		{
			foreach($available_kpi_name as $key=>$value)
			{
				if(!isset($array[$design_id][$v->tl_fusion_id][$v->fusion_id][$v->start_date.'#'.$v->end_date][$value]))
				{
					
					if($value=='Total Score' || $value=='Grade')
					{
						
						if($value == 'Grade')
						{
							$array[$design_id][$v->tl_fusion_id][$v->fusion_id][$v->start_date.'#'.$v->end_date][$value]['kpi_value'] = 'C';
							$array[$design_id][$v->tl_fusion_id][$v->fusion_id][$v->start_date.'#'.$v->end_date][$value]['kpi_type'] = 1;
						}
						else
						{
							$array[$design_id][$v->tl_fusion_id][$v->fusion_id][$v->start_date.'#'.$v->end_date][$value]['kpi_value'] = 0;
							$array[$design_id][$v->tl_fusion_id][$v->fusion_id][$v->start_date.'#'.$v->end_date][$value]['kpi_type'] = 8;
						}
						$array[$design_id][$v->tl_fusion_id][$v->fusion_id][$v->start_date.'#'.$v->end_date][$value]['summ_type'] = 3;
						$array[$design_id][$v->tl_fusion_id][$v->fusion_id][$v->start_date.'#'.$v->end_date][$value]['summ_formula'] = '';
						$array[$design_id][$v->tl_fusion_id][$v->fusion_id][$v->start_date.'#'.$v->end_date][$value]['agent_view'] = 1;
						$array[$design_id][$v->tl_fusion_id][$v->fusion_id][$v->start_date.'#'.$v->end_date][$value]['tl_view'] = 1;
						$array[$design_id][$v->tl_fusion_id][$v->fusion_id][$v->start_date.'#'.$v->end_date][$value]['management_view'] = 1;
						$array[$design_id][$v->tl_fusion_id][$v->fusion_id][$v->start_date.'#'.$v->end_date][$value]['weightage'] = 0;
						$array[$design_id][$v->tl_fusion_id][$v->fusion_id][$v->start_date.'#'.$v->end_date][$value]['target'] = '';
						$array[$design_id][$v->tl_fusion_id][$v->fusion_id][$v->start_date.'#'.$v->end_date][$value]['score'] = 0;
						$array[$design_id][$v->tl_fusion_id][$v->fusion_id][$v->start_date.'#'.$v->end_date][$value]['weightage_comp'] = 0;
					}
					else
					{
						$array[$design_id][$v->tl_fusion_id][$v->fusion_id][$v->start_date.'#'.$v->end_date][$value]['kpi_value'] = '';
						$array[$design_id][$v->tl_fusion_id][$v->fusion_id][$v->start_date.'#'.$v->end_date][$value]['kpi_type'] = 2;
						$array[$design_id][$v->tl_fusion_id][$v->fusion_id][$v->start_date.'#'.$v->end_date][$value]['summ_type'] = 3;
						$array[$design_id][$v->tl_fusion_id][$v->fusion_id][$v->start_date.'#'.$v->end_date][$value]['summ_formula'] = '';
						$array[$design_id][$v->tl_fusion_id][$v->fusion_id][$v->start_date.'#'.$v->end_date][$value]['agent_view'] = 0;
						$array[$design_id][$v->tl_fusion_id][$v->fusion_id][$v->start_date.'#'.$v->end_date][$value]['tl_view'] = 0;
						$array[$design_id][$v->tl_fusion_id][$v->fusion_id][$v->start_date.'#'.$v->end_date][$value]['management_view'] = 0;
						$array[$design_id][$v->tl_fusion_id][$v->fusion_id][$v->start_date.'#'.$v->end_date][$value]['weightage'] = 0;
						$array[$design_id][$v->tl_fusion_id][$v->fusion_id][$v->start_date.'#'.$v->end_date][$value]['target'] = '';
						$array[$design_id][$v->tl_fusion_id][$v->fusion_id][$v->start_date.'#'.$v->end_date][$value]['score'] = 0;
						$array[$design_id][$v->tl_fusion_id][$v->fusion_id][$v->start_date.'#'.$v->end_date][$value]['weightage_comp'] = 0;
					}
					
				}
			}
			
		
			if(in_array($v->kpi_name,$available_kpi_name))
			{
				$array[$design_id][$v->tl_fusion_id][$v->fusion_id][$v->start_date.'#'.$v->end_date][$v->kpi_name]['kpi_value'] = $v->kpi_value;
				$array[$design_id][$v->tl_fusion_id][$v->fusion_id][$v->start_date.'#'.$v->end_date][$v->kpi_name]['kpi_type'] = $v->kpi_type;
				$array[$design_id][$v->tl_fusion_id][$v->fusion_id][$v->start_date.'#'.$v->end_date][$v->kpi_name]['summ_type'] = $v->summ_type;
				$array[$design_id][$v->tl_fusion_id][$v->fusion_id][$v->start_date.'#'.$v->end_date][$v->kpi_name]['summ_formula'] = $v->summ_formula;
				$array[$design_id][$v->tl_fusion_id][$v->fusion_id][$v->start_date.'#'.$v->end_date][$v->kpi_name]['agent_view'] = $v->agent_view;
				$array[$design_id][$v->tl_fusion_id][$v->fusion_id][$v->start_date.'#'.$v->end_date][$v->kpi_name]['tl_view'] = $v->tl_view;
				$array[$design_id][$v->tl_fusion_id][$v->fusion_id][$v->start_date.'#'.$v->end_date][$v->kpi_name]['management_view'] = $v->management_view;
				$array[$design_id][$v->tl_fusion_id][$v->fusion_id][$v->start_date.'#'.$v->end_date][$v->kpi_name]['weightage'] = $v->weightage;
				$array[$design_id][$v->tl_fusion_id][$v->fusion_id][$v->start_date.'#'.$v->end_date][$v->kpi_name]['weightage_comp'] = $v->weightage_comp;
				
				$col_name_array[$v->start_date.'#'.$v->end_date][] = $v->kpi_name;
				$col_val_array[$v->start_date.'#'.$v->end_date][] = $v->kpi_value;
				
				if(!isset($agent_target[$v->fusion_id][$v->kpi_name]))
				{
			//print_r($target_info);
					$target_info = target_array($target[$design_id],$v->start_date,$v->kpi_name,$design_id,$v->tenure,$v->fusion_id);
					$array[$design_id][$v->tl_fusion_id][$v->fusion_id][$v->start_date.'#'.$v->end_date][$v->kpi_name]['target'] = $target_info[1];
					$agent_target[$target_info[0]][$target_info[2]] = $target_info[1];
				}
				else
				{
					$array[$design_id][$v->tl_fusion_id][$v->fusion_id][$v->start_date.'#'.$v->end_date][$v->kpi_name]['target'] = $agent_target[$v->fusion_id][$v->kpi_name];
				}
				
				$array[$design_id][$v->tl_fusion_id][$v->fusion_id][$v->start_date.'#'.$v->end_date][$v->kpi_name]['score'] = 0;
			}
		}
		foreach($array as $did=>$tl_info)
		{
			foreach($tl_info as $tl_id=>$agent_info)
			{
				foreach($agent_info as $agent_id=>$date_info)
				{
					foreach($date_info as $date=>$kpi_info)
					{
						foreach($kpi_info as $kpi_name=>$infos)
						{
							if($kpi_name == 'CQ_SCORE')
							{
								foreach($qa_data[$design_id] as $key=>$value)
								{
									$start_date = explode('#',$date);
									if($value->fusion_id == $agent_id && $start_date[0] == $value->audit_date)
									{
										$array[$did][$tl_id][$agent_id][$date][$kpi_name]['kpi_value'] = ($value->overall_score/100);
									}
								}
							}
						}
					}
				}
			}
		}
	return $array;
	}
	function target_array($target,$date='',$kpi_name='',$did='',$tenure='',$agent_fusion_id)
	{
		$time=strtotime($date);
		$month=date("m",$time);
		$year=date("Y",$time);
		/* echo '<pre>';
		print_r($target);
		echo '</pre>'; */
		
		/* echo $did.'<br>';
		echo $date.'<br>';
		echo $kpi_name.'<br>';
		echo $tenure.'<br>';
		echo $agent_fusion_id.'<br>'; */
		
		foreach($target as $key=>$value)
		{
			//echo $value->did.'<br>';
			if($value->did == $did && $value->kpi_name == $kpi_name && $value->year == $year && $value->month == $month && ($tenure >= $value->tenure_bucket_start) && ($tenure >= $value->tenure_bucket_end))
			{
				return array($agent_fusion_id,$value->target,$kpi_name);
				break;
			}
		}
	}
	
	function prepare_summary($array,$grade)
	{
		$CI = & get_instance();
		$CI->load->library('f_parser');
		foreach($array as $did=>$tl_info)
		{
			$row_counter = 1;
			foreach($tl_info as $tl_id=>$agent_info)
			{
				foreach($agent_info as $agent_id=>$date_info)
				{
					foreach($date_info as $date_start_end=>$kpi_info)
					{
						foreach($kpi_info as $col_name=>$col_info)
						{
							$date_array = explode('#',$date_start_end);
							$time=strtotime($date_array[0]);
							$month=date("F",$time);
							
							if($col_info['kpi_type'] == 1 || $col_info['kpi_type'] == 10)
							{
								$agent_level_final_monthly_summary[$did][$tl_id][$agent_id]['MTD of '.$month][$col_name]['kpi_value'] = $col_info['kpi_value'];
							}
							else if($col_info['summ_type'] == 11)
							{
								$agent_level_final_monthly_summary[$did][$tl_id][$agent_id]['MTD of '.$month][$col_name]['kpi_value'] = '-';
							}
							else if($col_info['summ_type'] == 12)
							{
								$agent_level_final_monthly_summary[$did][$tl_id][$agent_id]['MTD of '.$month][$col_name]['kpi_value'] = 0;
							}
							else if($col_info['summ_type'] == 3)
							{
								if(!isset($avg_counter[$did][$tl_id][$agent_id]['MTD of '.$month][$col_name]['avg_count']))
								{
									$avg_counter[$did][$tl_id][$agent_id]['MTD of '.$month][$col_name]['avg_count'] = 0;
								}
								if(trim($col_info['summ_formula']) == '')
								{
									$agent_level_final_monthly_summary[$did][$tl_id][$agent_id]['MTD of '.$month][$col_name]['value_cal'] = $agent_level_final_monthly_summary[$did][$tl_id][$agent_id]['MTD of '.$month][$col_name]['value_cal'] + $col_info['kpi_value'];
									if(trim($col_info['kpi_value']) != '')
									{
										$avg_counter[$did][$tl_id][$agent_id]['MTD of '.$month][$col_name]['avg_count']++;
									}
								}
								else
								{
									$cond_array = explode('=',$col_info['summ_formula']);
									$condition = $cond_array[0];
									$condition_value = $cond_array[1];
									if($array[$did][$tl_id][$agent_id][$date_start_end][$condition]['kpi_value'] == $condition_value)
									{
										$agent_level_final_monthly_summary[$did][$tl_id][$agent_id]['MTD of '.$month][$col_name]['value_cal'] = $agent_level_final_monthly_summary[$did][$tl_id][$agent_id]['MTD of '.$month][$col_name]['value_cal'] + $col_info['kpi_value'];
										if(trim($col_info['kpi_value']) != '')
										{
											$avg_counter[$did][$tl_id][$agent_id]['MTD of '.$month][$col_name]['avg_count']++;
										}
									}
								}
								
									$agent_level_final_monthly_summary[$did][$tl_id][$agent_id]['MTD of '.$month][$col_name]['kpi_value']=$agent_level_final_monthly_summary[$did][$tl_id][$agent_id]['MTD of '.$month][$col_name]['value_cal']/$avg_counter[$did][$tl_id][$agent_id]['MTD of '.$month][$col_name]['avg_count'];
									//$row_counter=1;
								
							}
							else if($col_info['summ_type'] == 4)
							{
								if(trim($col_info['summ_formula']) == '')
								{
									$agent_level_final_monthly_summary[$did][$tl_id][$agent_id]['MTD of '.$month][$col_name]['kpi_value'] = $agent_level_final_monthly_summary[$did][$tl_id][$agent_id]['MTD of '.$month][$col_name]['kpi_value'] + $col_info['kpi_value'];
								}
								else
								{
									$cond_array = explode('=',$col_info['summ_formula']);
									$condition = $cond_array[0];
									$condition_value = $cond_array[1];
									if($array[$did][$tl_id][$agent_id][$date_start_end][$condition]['kpi_value'] == $condition_value)
									{
										$agent_level_final_monthly_summary[$did][$tl_id][$agent_id]['MTD of '.$month][$col_name]['kpi_value'] = $agent_level_final_monthly_summary[$did][$tl_id][$agent_id]['MTD of '.$month][$col_name]['kpi_value'] + $col_info['kpi_value'];
									}
								}
							}
							
							$agent_level_final_monthly_summary[$did][$tl_id][$agent_id]['MTD of '.$month][$col_name]['kpi_type'] = $col_info['kpi_type'];
							$agent_level_final_monthly_summary[$did][$tl_id][$agent_id]['MTD of '.$month][$col_name]['summ_type'] = $col_info['summ_type'];
							$agent_level_final_monthly_summary[$did][$tl_id][$agent_id]['MTD of '.$month][$col_name]['summ_formula'] = $col_info['summ_formula'];
							$agent_level_final_monthly_summary[$did][$tl_id][$agent_id]['MTD of '.$month][$col_name]['agent_view'] = $col_info['agent_view'];
							$agent_level_final_monthly_summary[$did][$tl_id][$agent_id]['MTD of '.$month][$col_name]['tl_view'] = $col_info['tl_view'];
							$agent_level_final_monthly_summary[$did][$tl_id][$agent_id]['MTD of '.$month][$col_name]['management_view'] = $col_info['management_view'];
							$agent_level_final_monthly_summary[$did][$tl_id][$agent_id]['MTD of '.$month][$col_name]['weightage'] = $col_info['weightage'];
							$agent_level_final_monthly_summary[$did][$tl_id][$agent_id]['MTD of '.$month][$col_name]['target'] = $col_info['target'];
							$agent_level_final_monthly_summary[$did][$tl_id][$agent_id]['MTD of '.$month][$col_name]['score'] = $col_info['score'];
							$agent_level_final_monthly_summary[$did][$tl_id][$agent_id]['MTD of '.$month][$col_name]['weightage_comp'] = $col_info['weightage_comp'];
							
						}
						$row_counter++;
					}
				}
			}
		}
		
		$col_name_array = array();
		$col_val_array = array();
		foreach($agent_level_final_monthly_summary as $did=>$tl_info)
		{
			foreach($tl_info as $tl_id=>$agent_info)
			{
				foreach($agent_info as $agent_id=>$date_info)
				{
					foreach($date_info as $date_start_end=>$kpi_info)
					{
						foreach($kpi_info as $col_name=>$col_info)
						{
							$col_name_array[] = $col_name;
							$col_val_array[] = $col_info['kpi_value'];
						}
						
					}
					
				}
				
			}
			
		}
		
		$row_counter = 1;
		foreach($agent_level_final_monthly_summary as $did=>$tl_info)
		{
			
			foreach($tl_info as $tl_id=>$agent_info)
			{
				foreach($agent_info as $agent_id=>$date_info)
				{
					foreach($date_info as $month=>$kpi_info)
					{
						foreach($kpi_info as $col_name=>$col_info)
						{
							if($col_info['summ_type'] == 12)
							{
								$CI->f_parser->SetFormula(str_replace($col_name_array,$col_val_array,$col_info['summ_formula']));
								$p = $CI->f_parser->parser->getResult();
								$agent_level_final_monthly_summary[$did][$tl_id][$agent_id][$month][$col_name]['kpi_value'] = $p[1];
							}
							
							if($agent_level_final_monthly_summary[$did][$tl_id][$agent_id][$month][$col_name]['target'] != '')
							{
								if($agent_level_final_monthly_summary[$did][$tl_id][$agent_id][$month][$col_name]['weightage_comp'] == 0)
								{
									if($agent_level_final_monthly_summary[$did][$tl_id][$agent_id][$month][$col_name]['kpi_value'] <= $agent_level_final_monthly_summary[$did][$tl_id][$agent_id][$month][$col_name]['target'])
									{
										$agent_level_final_monthly_summary[$did][$tl_id][$agent_id][$month][$col_name]['score'] = $agent_level_final_monthly_summary[$did][$tl_id][$agent_id][$month][$col_name]['weightage'];
									}
									else
									{
										$agent_level_final_monthly_summary[$did][$tl_id][$agent_id][$month][$col_name]['score']= (($agent_level_final_monthly_summary[$did][$tl_id][$agent_id][$month][$col_name]['target']/$agent_level_final_monthly_summary[$did][$tl_id][$agent_id][$month][$col_name]['kpi_value'])*$agent_level_final_monthly_summary[$did][$tl_id][$agent_id][$month][$col_name]['weightage']);
									}
								}
								else
								{
									$agent_level_final_monthly_summary[$did][$tl_id][$agent_id][$month][$col_name]['score'] = (($agent_level_final_monthly_summary[$did][$tl_id][$agent_id][$month][$col_name]['kpi_value']/$agent_level_final_monthly_summary[$did][$tl_id][$agent_id][$month][$col_name]['target'])*$agent_level_final_monthly_summary[$did][$tl_id][$agent_id][$month][$col_name]['weightage']);
									$agent_level_final_monthly_summary[$did][$tl_id][$agent_id][$month][$col_name]['score1'] = $agent_level_final_monthly_summary[$did][$tl_id][$agent_id][$month][$col_name]['kpi_value'].'/'.$agent_level_final_monthly_summary[$did][$tl_id][$agent_id][$month][$col_name]['target'].'*'.$agent_level_final_monthly_summary[$did][$tl_id][$agent_id][$month][$col_name]['weightage'];
									/* if(!is_numeric($agent_level_final_monthly_summary[$did][$tl_id][$agent_id][$month][$col_name]['score']))
									{
										$agent_level_final_monthly_summary[$did][$tl_id][$agent_id][$month][$col_name]['score'] = 0;
									} */
									
									if($agent_level_final_monthly_summary[$did][$tl_id][$agent_id][$month][$col_name]['score'] >= $agent_level_final_monthly_summary[$did][$tl_id][$agent_id][$month][$col_name]['weightage'])
									{
										$agent_level_final_monthly_summary[$did][$tl_id][$agent_id][$month][$col_name]['score'] = $agent_level_final_monthly_summary[$did][$tl_id][$agent_id][$month][$col_name]['weightage'];
									}
									else
									{
										$agent_level_final_monthly_summary[$did][$tl_id][$agent_id][$month][$col_name]['score']= $agent_level_final_monthly_summary[$did][$tl_id][$agent_id][$month][$col_name]['score'];
									}
								}
							}
							else
							{
								$agent_level_final_monthly_summary[$did][$tl_id][$agent_id][$month][$col_name]['score'] = 0;
							}
							if(is_nan($agent_level_final_monthly_summary[$did][$tl_id][$agent_id][$month][$col_name]['score']))
							{
								$agent_level_final_monthly_summary[$did][$tl_id][$agent_id][$month]['Total Score']['kpi_value'] = $agent_level_final_monthly_summary[$did][$tl_id][$agent_id][$month]['Total Score']['kpi_value'] + 0;
							}
							else
							{
								$agent_level_final_monthly_summary[$did][$tl_id][$agent_id][$month]['Total Score']['kpi_value'] = $agent_level_final_monthly_summary[$did][$tl_id][$agent_id][$month]['Total Score']['kpi_value'] + $agent_level_final_monthly_summary[$did][$tl_id][$agent_id][$month][$col_name]['score'];
							}
							
							if((count($kpi_info)-2) == $row_counter)
							{
								foreach($grade as $key=>$value)
								{
									
									if($value->grade_start <= $agent_level_final_monthly_summary[$did][$tl_id][$agent_id][$month]['Total Score']['kpi_value'] && $value->grade_end >=  $agent_level_final_monthly_summary[$did][$tl_id][$agent_id][$month]['Total Score']['kpi_value'])
									{
										$agent_level_final_monthly_summary[$did][$tl_id][$agent_id][$month]['Grade']['kpi_value'] = $value->grade;
									}
								}
							}
							$row_counter++;
						}
						
						
					}
					
				}
				
			}
			
		}
		/* echo '<pre>';
		print_r($agent_level_final_monthly_summary);
		echo '</pre>'; */
		return $agent_level_final_monthly_summary;
		
	}
	
foreach($kpi_design as $key=>$kpi_design_value)
{
	$array = prepare_row($kpi_design_value->design_id,$kpi_col,$kpi_data,$qa_data,$target);
	$grade = $grade_bucket[$kpi_design_value->design_id];
	
	$summary = prepare_summary($array,$grade);
	
?>
		<div class="row">
			<div class="col-md-12">
				<div class="widget">
					
					<div class="row">
						<div class="col-md-12">
							<div class="row">
								<div class="col-md-5">
									<header class="widget-header">
										<h4 class="widget-title">Performance Metrix <?php echo $report_of; ?> <a onclick="exportF3(this);"><button class="btn btn-xs btn-info"><i class="fa fa-file-excel-o" aria-hidden="true"></i></button></a></h4>
									</header>
								</div>
								
							</div>
						</div>
						
					</div>
					<hr class="widget-separator">
					
					<div class="widget-body">
						<div class="table-responsive">
							<table id="score_table" data-plugin="DataTable" class="table table-striped skt-table" width="100%" cellspacing="0" style="text-align:center;">
								<thead>
									<tr style="background-color: #35b8e0;color: #fff; border:1px solid black;">
													<th style="text-align:center;border: 1px solid black;">Type</th>
										<?php
											foreach($summary as $did=>$tl_info)
											{
												foreach($tl_info as $tl_id=>$agent_info)
												{
													foreach($agent_info as $agent_id=>$month_info)
													{
														foreach($month_info as $month=>$col_info)
														{
															foreach($col_info as $col_name=>$col_data)
															{
																if(trim($col_data['target']) != '' && $col_data['agent_view']==1)
																{
																	echo '<th style="text-align:center;border: 1px solid black;">'.$col_name.'</th>';
																}
																
															}
															echo '<th style="text-align:center;border: 1px solid black;">Total Score</th>';
															echo '<th style="text-align:center;border: 1px solid black;">Grade</th>';
														}
													}
												}
												
											}
										?>
									</tr>
								</thead>
								<tbody>
									<?php
										foreach($summary as $did=>$tl_info)
										{
											foreach($tl_info as $tl_id=>$agent_info)
											{
												foreach($agent_info as $agent_id=>$month_info)
												{
													foreach($month_info as $month=>$col_info)
													{
														echo '<tr>';
															echo '<th style="text-align:center;border: 1px solid black;">Target</th>';
														foreach($col_info as $col_name=>$col_data)
														{
															if(trim($col_data['target']) != '' && $col_data['agent_view']==1)
															{
																echo '<th style="text-align:center;border: 1px solid black;">'.value_calculation($col_data['kpi_type'],$col_data['target']).'</th>';
															}
															
														}
														echo '<th style="text-align:center;border: 1px solid black;"></th>';
														echo '<th style="text-align:center;border: 1px solid black;" rowspan="3">'.$col_info['Grade']['kpi_value'].'</th>';
														echo '</tr>';
													
														echo '<tr>';
															echo '<th style="text-align:center;border: 1px solid black;">Weightage</th>';
														foreach($col_info as $col_name=>$col_data)
														{
															if(trim($col_data['target']) != '' && $col_data['agent_view']==1)
															{
																echo '<th style="text-align:center;border: 1px solid black;">'.number_format($col_data['weightage'],2).'%</th>';
															}
															
														}
														echo '<th style="text-align:center;border: 1px solid black;">100%</th>';
														echo '</tr>';
													
														echo '<tr>';
															echo '<th style="text-align:center;border: 1px solid black;">Score</th>';
														foreach($col_info as $col_name=>$col_data)
														{
															if(trim($col_data['target']) != '' && $col_data['agent_view']==1)
															{
																echo '<th style="text-align:center;border: 1px solid black;">'.number_format($col_data['score'],2).'%</th>';
															}
															
														}
														echo '<th style="text-align:center;border: 1px solid black;">'.number_format($col_info['Total Score']['kpi_value'],2).'%</th>';
														echo '</tr>';
													}
												}
											}
											
										}
									?>
								</tbody>
							</table>
						</div>
					</div>
					<hr class="widget-separator">
					
					<div class="widget-body">
						<div class="table-responsive">
							<table id="default-datatable" data-plugin="DataTable" class="table table-striped skt-table" width="100%" cellspacing="0" style="text-align:center;">
								<thead>
									<tr style="background-color: #35b8e0;color: #fff; border:1px solid black;">
										<?php
											foreach($summary as $did=>$tl_info)
											{
												foreach($tl_info as $tl_id=>$agent_info)
												{
													foreach($agent_info as $agent_id=>$month_info)
													{
														foreach($month_info as $month=>$col_info)
														{
															echo '<th style="text-align:center;border: 1px solid black;">Date</th>';
															foreach($col_info as $col_name=>$col_data)
															{
																if($col_name != 'Total Score' && $col_name != 'Grade' && $col_data['agent_view'] == 1)
																{
																	echo '<th style="text-align:center;border: 1px solid black;">'.$col_name.'</th>';
																}
																
															}
														}
													}
												}
												
											}
										?>
									</tr>
								</thead>
								<tbody>
									<?php
										foreach($summary as $did=>$tl_info)
										{
											foreach($tl_info as $tl_id=>$agent_info)
											{
												foreach($agent_info as $agent_id=>$month_info)
												{
													foreach($month_info as $month=>$col_info)
													{
														echo '<tr style="background:orange;">';
														echo '<th style="text-align:center;border: 1px solid black;">'.$month.'</th>';
														foreach($col_info as $col_name=>$col_data)
														{
															if($col_name != 'Total Score' && $col_name != 'Grade' && $col_data['agent_view'] == 1)
															{
																echo '<th style="text-align:center;border: 1px solid black;">'.value_calculation($col_data['kpi_type'],$col_data['kpi_value']).'</th>';
															}
															
														}
														echo '</tr>';
													}
												}
											}
											
										}
										
										foreach($array as $did=>$tl_info)
										{
											foreach($tl_info as $tl_id=>$agent_info)
											{
												foreach($agent_info as $agent_id=>$date_info)
												{
													foreach($date_info as $date=>$col_info)
													{
														$date = explode('#',$date);
														echo '<tr>';
															echo '<td style="text-align:center;border: 1px solid black;">'.$date[0].'</td>';
															foreach($col_info as $col_name=>$col_data)
															{
																if($col_name != 'Total Score' && $col_name != 'Grade' && $col_data['agent_view'] == 1)
																{
																	echo '<td style="text-align:center;border: 1px solid black;">'.value_calculation($col_data['kpi_type'],$col_data['kpi_value'],true).'</td>';
																}
															}
														echo '</tr>';
													}
												}
											}
											
										}
									?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
<?php
}
?>