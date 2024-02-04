<style>
	.indv_user_daily_data_container
	{
		display:none;
	}
</style>
<?php
	function prepare_row_indv_user_data($design_id,$kpi_col,$kpi_data,$qa_data)
	{
		$available_col_count = count($kpi_col[$design_id]);
		$indv_user_data = array();
		$row_no = 0;
		$col_counter = 1;
		$i=0;
		
		$available_kpi_name = array();
		foreach($kpi_col[$design_id] as $key=>$info)
		{
			$available_kpi_name[] = $info->kpi_name;
		}
		
		foreach($kpi_data[$design_id] as $k=>$v)
		{
			if(trim($available_kpi_name[0]) == trim($v->kpi_name))
			{
				$row_no++;
				$col_counter=1;
			}
			
			$indv_user_data[$v->fusion_id]['row'.$row_no]['col'.$col_counter]['kpi_name'] = 'CQ_SCORE';
			$indv_user_data[$v->fusion_id]['row'.$row_no]['col'.$col_counter]['kpi_value'] = '';
			$indv_user_data[$v->fusion_id]['row'.$row_no]['col'.$col_counter]['kpi_type'] = 2;
			$indv_user_data[$v->fusion_id]['row'.$row_no]['col'.$col_counter]['summ_type'] = 3;
			$indv_user_data[$v->fusion_id]['row'.$row_no]['col'.$col_counter]['summ_formula'] = '';
			$indv_user_data[$v->fusion_id]['row'.$row_no]['col'.$col_counter]['agent_view'] = $v->agent_view;
			$indv_user_data[$v->fusion_id]['row'.$row_no]['col'.$col_counter]['tl_view'] = $v->tl_view;
			$indv_user_data[$v->fusion_id]['row'.$row_no]['col'.$col_counter]['start_date'] = $v->start_date;
			$indv_user_data[$v->fusion_id]['row'.$row_no]['col'.$col_counter]['weightage'] = $v->weightage;
			$indv_user_data[$v->fusion_id]['row'.$row_no]['col'.$col_counter]['agent_name'] = $v->fname.' '.$v->lname;
			$indv_user_data[$v->fusion_id]['row'.$row_no]['col'.$col_counter]['weightage_comp'] = 1;
			if(in_array($info->kpi_name, $available_kpi_name))
			{
				$indv_user_data[$v->fusion_id]['row'.$row_no]['col'.$col_counter]['kpi_name'] = $v->kpi_name;
				$indv_user_data[$v->fusion_id]['row'.$row_no]['col'.$col_counter]['kpi_value'] = $v->kpi_value;
				$indv_user_data[$v->fusion_id]['row'.$row_no]['col'.$col_counter]['kpi_type'] = $v->kpi_type;
				$indv_user_data[$v->fusion_id]['row'.$row_no]['col'.$col_counter]['summ_type'] = $v->summ_type;
				$indv_user_data[$v->fusion_id]['row'.$row_no]['col'.$col_counter]['summ_formula'] = $v->summ_formula;
				$indv_user_data[$v->fusion_id]['row'.$row_no]['col'.$col_counter]['agent_view'] = $v->agent_view;
				$indv_user_data[$v->fusion_id]['row'.$row_no]['col'.$col_counter]['tl_view'] = $v->tl_view;
				$indv_user_data[$v->fusion_id]['row'.$row_no]['col'.$col_counter]['start_date'] = $v->start_date;
				$indv_user_data[$v->fusion_id]['row'.$row_no]['col'.$col_counter]['weightage'] = $v->weightage;
				$indv_user_data[$v->fusion_id]['row'.$row_no]['col'.$col_counter]['agent_name'] = $v->fname.' '.$v->lname;
				$indv_user_data[$v->fusion_id]['row'.$row_no]['col'.$col_counter]['weightage_comp'] = $v->weightage_comp;
			}
			$col_counter++;
		}
		
		foreach($indv_user_data as $fusion_id=>$rows)
		{
			foreach($rows as $row_key=>$cols)
			{
				foreach($cols as $col_key=>$c)
				{
					if($c['kpi_name'] == 'CQ_SCORE')
					{
						foreach($qa_data[$design_id] as $key=>$value)
						{
							if($value->fusion_id == $fusion_id && $c['start_date'] == $value->audit_date)
							{
								$indv_user_data[$fusion_id][$row_key][$col_key]['kpi_value'] = ($value->overall_score/100);
							}
						}
					}
				}
			}
		}
		/* echo '<pre>';
		print_r($indv_user_data);
		echo '</pre>'; */
		return $indv_user_data;
	}
	function prepare_everyone_indv_user_summary($indv_user_raw_data_row)
	{
		$summary_array = array();
		$avg_counter = array();
		$CI = & get_instance();
		$CI->load->library('f_parser');
		foreach($indv_user_raw_data_row as $fusion_id=>$user_data)
		{
			$row_counter = 1;
			foreach($user_data as $row_key=>$row)
			{
				
				foreach($row as $col_key=>$col)
				{
					if(!isset($summary_array[$fusion_id][$col['kpi_name']]['value']))
					{
						$summary_array[$fusion_id][$col['kpi_name']]['value'] = 0;
					}
					if(!isset($summary_array[$fusion_id][$col['kpi_name']]['agent_view']))
					{
						$summary_array[$fusion_id][$col['kpi_name']]['agent_view'] = 0;
					}
					if(!isset($summary_array[$fusion_id][$col['kpi_name']]['tl_view']))
					{
						$summary_array[$fusion_id][$col['kpi_name']]['tl_view'] = 0;
					}
					if(!isset($summary_array[$fusion_id][$col['kpi_name']]['kpi_type']))
					{
						$summary_array[$fusion_id][$col['kpi_name']]['kpi_type'] = 0;
					}
					if(!isset($summary_array[$fusion_id][$col['kpi_name']]['weightage']))
					{
						$summary_array[$fusion_id][$col['kpi_name']]['weightage'] = 0;
					}
					if(!isset($summary_array[$fusion_id][$col['kpi_name']]['summ_type']))
					{
						$summary_array[$fusion_id][$col['kpi_name']]['summ_type'] = 0;
					}
					if(!isset($summary_array[$fusion_id][$col['kpi_name']]['summ_formula']))
					{
						$summary_array[$fusion_id][$col['kpi_name']]['summ_formula'] = 0;
					}
					
					if($col['kpi_type'] == 1 || $col['kpi_type'] == 10)
					{
						$summary_array[$fusion_id][$col['kpi_name']]['value'] = $col['kpi_value'];
						$summary_array[$fusion_id][$col['kpi_name']]['agent_view'] = $col['agent_view'];
						$summary_array[$fusion_id][$col['kpi_name']]['tl_view'] = $col['tl_view'];
						$summary_array[$fusion_id][$col['kpi_name']]['kpi_type'] = $col['kpi_type'];
						$summary_array[$fusion_id][$col['kpi_name']]['weightage'] = $col['weightage'];
						$summary_array[$fusion_id][$col['kpi_name']]['summ_type'] = $col['summ_type'];
						$summary_array[$fusion_id][$col['kpi_name']]['summ_formula'] = $col['summ_formula'];
						$summary_array[$fusion_id][$col['kpi_name']]['weightage_comp'] = $col['weightage_comp'];
						
					}
					else
					{
						if($col['summ_type'] == 4)
						{
							if(trim($col['summ_formula']) == '')
							{
								$summary_array[$fusion_id][$col['kpi_name']]['value'] = $summary_array[$fusion_id][$col['kpi_name']]['value'] + $col['kpi_value'];
							}
							else
							{
								$cond_array = explode('=',$col['summ_formula']);
								$condition = $cond_array[0];
								$condition_value = $cond_array[1];
								foreach($row as $k=>$v)
								{
									if($v['kpi_name']==$condition)
									{
										if($v['kpi_value']==$condition_value)
										{
											$summary_array[$fusion_id][$col['kpi_name']]['value'] = $summary_array[$fusion_id][$col['kpi_name']]['value'] + $col['kpi_value'];
										}
									}
								}
							}
						}
						else if($col['summ_type'] == 11)
						{
							$summary_array[$fusion_id][$col['kpi_name']]['value'] = '-';
						}
						else if($col['summ_type'] == 3)
						{
							if(!isset($avg_counter[$fusion_id][$col['kpi_name']]['avg_count']))
							{
								$avg_counter[$fusion_id][$col['kpi_name']]['avg_count'] = 0;
							}
							if(trim($col['summ_formula']) == '')
							{
								$summary_array[$fusion_id][$col['kpi_name']]['value_cal'] = $summary_array[$fusion_id][$col['kpi_name']]['value_cal'] + $col['kpi_value'];
								if(trim($col['kpi_value']) != '')
								{
									$avg_counter[$fusion_id][$col['kpi_name']]['avg_count']++;
								}
							}
							else
							{
								$cond_array = explode('=',$col['summ_formula']);
								$condition = $cond_array[0];
								$condition_value = $cond_array[1];
								foreach($row as $k=>$v)
								{
									if($v['kpi_name']==$condition)
									{
										if($v['kpi_value']==$condition_value)
										{
											$summary_array[$fusion_id][$col['kpi_name']]['value_cal'] = $summary_array[$fusion_id][$col['kpi_name']]['value_cal'] + $col['kpi_value'];
											if(trim($col['kpi_value']) != '')
											{
												$avg_counter[$fusion_id][$col['kpi_name']]['avg_count']++;
											}
										}
									}
								}
							}
							//echo $row_counter.'<br>';
							//echo count($user_data).'<br>';
							
								$summary_array[$fusion_id][$col['kpi_name']]['value'] = $summary_array[$fusion_id][$col['kpi_name']]['value_cal']/$avg_counter[$fusion_id][$col['kpi_name']]['avg_count'];
								//$row_counter=1;
							
						}
						$summary_array[$fusion_id][$col['kpi_name']]['agent_view'] = $col['agent_view'];
						$summary_array[$fusion_id][$col['kpi_name']]['tl_view'] = $col['tl_view'];
						$summary_array[$fusion_id][$col['kpi_name']]['kpi_type'] = $col['kpi_type'];
						$summary_array[$fusion_id][$col['kpi_name']]['weightage'] = $col['weightage'];
						$summary_array[$fusion_id][$col['kpi_name']]['summ_type'] = $col['summ_type'];
						$summary_array[$fusion_id][$col['kpi_name']]['summ_formula'] = $col['summ_formula'];
						$summary_array[$fusion_id][$col['kpi_name']]['weightage_comp'] = $col['weightage_comp'];
					}
					
				}
				$row_counter++;
			}
		}
		$col_name_array = array();
		$col_val_array = array();
		foreach($summary_array as $fusion_id=>$col_array)
		{
			foreach($col_array as $col_name=>$col_info)
			{
				$col_name_array[$fusion_id][] = $col_name;
				$col_val_array[$fusion_id][] = $col_info['value'];
			}
		}
		foreach($summary_array as $fusion_id=>$col_array)
		{
			foreach($col_array as $col_name=>$col_info)
			{
				if($col_info['summ_type'] == 12)
				{
					$CI->f_parser->SetFormula(str_replace($col_name_array[$fusion_id],$col_val_array[$fusion_id],$col_info['summ_formula']));
					$p = $CI->f_parser->parser->getResult();
					$summary_array[$fusion_id][$col_name]['value'] = $p[1];
				}
			}
		}
		/* echo '<pre>';
		print_r($summary_array);
		echo '<pre>'; */
		return $summary_array;
	}
	function calculate_rank($everyone_indv_user_summary,$target)
	{
		$rank = array();
		$rank1 = array();
		$final_score = array();
		foreach($everyone_indv_user_summary as $fusion_id=>$row)
		{
			foreach($row as $col_name=>$value)
			{
				if($value['weightage'] != 0)
				{
					foreach($target[$fusion_id] as $k=>$v)
					{
						if($v->kpi_name == $col_name)
						{
							if($v->target != '')
							{
								if(is_nan($value['value']))
								{
									$value['value'] = 0;
								}
								
								$rank[$fusion_id][$v->kpi_name]['score1'] = $value['value'].'/'.$v->target.'*'.$value['weightage'];
								$rank[$fusion_id][$v->kpi_name]['value'] = $value['value'];
								$rank[$fusion_id][$v->kpi_name]['target'] = $v->target;
								$rank[$fusion_id][$v->kpi_name]['weightage_comp'] = $value['weightage_comp'];
								//$rank[$fusion_id][$v->kpi_name]['score'] = (($value['value']/$v->target)*$value['weightage']);
								$rank[$fusion_id][$v->kpi_name]['weightage'] = $value['weightage'];
							}
						}
					}
				}
			}
		}
		/* echo '<pre>';
		print_r($rank);
		echo '</pre>'; */
		foreach($rank as $fusion_id=>$cols)
		{
			foreach($cols as $key=>$value)
			{
				if($value['weightage_comp'] == 0)
				{
					if($value['value'] <= $value['target'])
					{
						$rank1[$fusion_id][$key]['score'] = $value['weightage'];
					}
					else
					{
						$rank1[$fusion_id][$key]['score'] = (($value['target']/$value['value'])*$value['weightage']);
					}
				}
				else
				{
					$value['score'] = (($value['value']/$value['target'])*$value['weightage']);
					if($value['score'] >= $value['weightage'])
					{
						$rank1[$fusion_id][$key]['score'] = $value['weightage'];
						//$rank1[$fusion_id][$key]['weightage'] = $value['weightage'];
					}
					else
					{
						$rank1[$fusion_id][$key]['score'] = $value['score'];
						//$rank1[$fusion_id][$key]['weightage'] = $value['weightage'];
					}
				}
			}
		}
		foreach($rank1 as $fusion_id=>$cols)
		{
			foreach($cols as $key=>$value)
			{
				if(!isset($final_score[$fusion_id]['total_score']))
				{
					$final_score[$fusion_id]['total_score'] = 0;
				}
				$final_score[$fusion_id][$key] = $final_score[$fusion_id][$key] + $value['score'];
				$final_score[$fusion_id]['total_score'] = $final_score[$fusion_id]['total_score'] + $value['score'];
			}
		}
		/* echo '<pre>';
		print_r($rank);
		echo '</pre>'; */
		return $final_score;
	}
	function get_rank($final_score,$grade)
	{
		$rank = array();
		foreach($final_score as $fusion_id=>$value)
		{
			foreach($grade as $key=>$value)
			{
				if($value->grade_start <= $final_score[$fusion_id]['total_score'] && $value->grade_end >= $final_score[$fusion_id]['total_score'])
				{
					$rank[$fusion_id][$value->grade] = $final_score[$fusion_id];
				}
				
			}
		}
		
		return $rank;
	}
	
	function prepare_agent_name($design_id,$agents)
	{
		$agent_array = array();
		foreach($agents[$design_id] as $key=>$value)
		{
			$agent_array[$value->fusion_id] = $value->fname.' '.$value->lname;
		}
		return $agent_array;
	}
?>
<?php
foreach($kpi_design as $key=>$kpi_design_value)
{
	
	//echo 'fdfdfd';
	$indv_user_raw_data_row = prepare_row_indv_user_data($kpi_design_value->design_id,$kpi_col,$kpi_data,$qa_data);
	$everyone_indv_user_summary = prepare_everyone_indv_user_summary($indv_user_raw_data_row);
	$final_score = calculate_rank($everyone_indv_user_summary,$target[$kpi_design_value->design_id]);
	$grade = $grade_bucket[$kpi_design_value->design_id];
	$marks_wise_shorting = get_rank($final_score,$grade);
	$agent_array = prepare_agent_name($kpi_design_value->design_id,$agents);
	//echo 'fdfd';
	/* echo '<pre>';
	print_r($final_score);
	echo '</pre>'; */
?>
	<div class="row">
		<div class="col-md-12">
			<div class="widget">
				<div class="row">
					<div class="col-md-12">
						<div class="row">
							<div class="col-md-5">
								<header class="widget-header">
									<h4 class="widget-title">Performance Metrix <?php echo $report_of; ?> <a onclick="exportF(this)"><button class="btn btn-xs btn-info"><i class="fa fa-file-excel-o" aria-hidden="true"></i></button></a></h4>
								</header>
							</div>
							
						</div>
					</div>
							
				</div>
				<hr class="widget-separator">
						
				<div class="widget-body">
					<div class="table-responsive">
						<table id="default-datatable" data-plugin="DataTable" class="table table-striped skt-table" width="100%" cellspacing="0" style="text-align:center;">
							<thead id="thead">
								<tr style="background-color: #35b8e0;color: #fff; border:1px solid black;">
									<th style="text-align:center;border: 1px solid black;">Action</th>
									<th style="text-align:center;border: 1px solid black;">Name</th>
									<th style="text-align:center;border: 1px solid black;">Fusion ID</th>
									<th style="text-align:center;border: 1px solid black;">Grade</th>
									<?php
										$i = 1;
										foreach($marks_wise_shorting as $fusion_id=>$grade_array)
										{
											if($i > 1)
											{
												break;
											}
											foreach($grade_array as $grade=>$values_array)
											{
												foreach($values_array as $key=>$value)
												{
													echo '<th style="text-align:center;border: 1px solid black;">'.$key.'</th>';
												}
											}
											$i++;
										}
									?>
								</tr>
							</thead>
							<tbody>
								<?php
									foreach($marks_wise_shorting as $fusion_id=>$grade_array)
									{
										foreach($grade_array as $grade=>$values_array)
										{
											echo '<tr class="data_row">';
												echo '<td style="text-align:center;border: 1px solid black;"><button class="btn btn-primary btn-xs get_indv_user_daily_data" data-fusion_id="'.$fusion_id.'"><i class="fa fa-plus" aria-hidden="true"></i></button></td>';
												echo '<td style="text-align:center;border: 1px solid black;">'.$agent_array[$fusion_id].'</td>';
												echo '<td style="text-align:center;border: 1px solid black;" data-fusion_id="'.$fusion_id.'">'.$fusion_id.'</td>';
												echo '<td style="text-align:center;border: 1px solid black;">'.$grade.'</td>';
											foreach($values_array as $key=>$value)
											{
												echo '<td style="text-align:center;border: 1px solid black;">'.number_format($value,2).'%</td>';
											}
											echo '</tr>';
											echo '<tr class="indv_user_daily_data_container">';
												echo '<td colspan="'.(count($values_array)+4).'"><div class="table-responsive"></div></td>';
											echo '</tr>';
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