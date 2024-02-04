<style>
.agent_list
{
	display:none;
}
</style>
<?php
	function calculate_rank($everyone_indv_user_summary,$target)
	{
		
		$rank = array();
		$rank1 = array();
		$final_score = array();
		/* echo '<pre>';
		print_r($everyone_indv_user_summary);
		echo '</pre>'; */
		foreach($everyone_indv_user_summary as $fusion_id=>$row)
		{
			foreach($row as $col_name=>$value)
			{
				if($value['weightage'] != 0)
				{
					foreach($target as $k=>$v)
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
		print_r($final_score);
		echo '</pre>'; */
		//print_r($final_score['FKOL002547']);
		return $final_score;
	}
	
	function get_rank($final_score)
	{
		$rank = array();
		foreach($final_score as $fusion_id=>$value)
		{
			$rank[$fusion_id] = $value['total_score'];
		}
		arsort($rank);
		return $rank;
	}
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
	function prepare_data_row($design_id,$kpi_col,$kpi_data,$tl_id=false,$processs_qa_data)
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
		/* echo '<pre>';
		print_r($kpi_data[$design_id]);
		echo '</pre>'; */
		foreach($kpi_data[$design_id] as $k=>$v)
		{
			if(in_array($v->kpi_name, $available_kpi_name))
			{
				if($tl_id == true)
				{
					$fusion_id = $v->tl_fusion_id;
				}
				else
				{
					$fusion_id = $v->fusion_id;
				}
				
				if(trim($available_kpi_name[0]) == trim($v->kpi_name))
				{
					$row_no++;
					$col_counter=1;
				}
				
				
				$indv_user_data[$fusion_id]['row'.$row_no]['col'.$col_counter]['kpi_name'] = 'CQ_SCORE';
				$indv_user_data[$fusion_id]['row'.$row_no]['col'.$col_counter]['kpi_value'] = '';
				$indv_user_data[$fusion_id]['row'.$row_no]['col'.$col_counter]['kpi_type'] = 2;
				$indv_user_data[$fusion_id]['row'.$row_no]['col'.$col_counter]['summ_type'] = 3;
				$indv_user_data[$fusion_id]['row'.$row_no]['col'.$col_counter]['summ_formula'] = '';
				$indv_user_data[$fusion_id]['row'.$row_no]['col'.$col_counter]['agent_view'] = $v->agent_view;
				$indv_user_data[$fusion_id]['row'.$row_no]['col'.$col_counter]['tl_view'] = $v->tl_view;
				$indv_user_data[$fusion_id]['row'.$row_no]['col'.$col_counter]['management_view'] = $v->management_view;
				$indv_user_data[$fusion_id]['row'.$row_no]['col'.$col_counter]['start_date'] = $v->start_date;
				$indv_user_data[$fusion_id]['row'.$row_no]['col'.$col_counter]['weightage'] = $v->weightage;
				$indv_user_data[$fusion_id]['row'.$row_no]['col'.$col_counter]['tl_name'] = $v->tl_fname.' '.$v->tl_lname;
				$indv_user_data[$fusion_id]['row'.$row_no]['col'.$col_counter]['agent_name'] = $v->agent_fname.' '.$v->agent_lname;
				$indv_user_data[$fusion_id]['row'.$row_no]['col'.$col_counter]['tl_fusion_id'] = $v->tl_fusion_id;
				$indv_user_data[$fusion_id]['row'.$row_no]['col'.$col_counter]['weightage_comp'] = 1;
				
				if(!isset($indv_user_data[$fusion_id]['row'.$row_no]['col'.$col_counter]['kpi_name']))
				{
					$indv_user_data[$fusion_id]['row'.$row_no]['col'.$col_counter]['kpi_name'] = 0;
				}
				$indv_user_data[$fusion_id]['row'.$row_no]['col'.$col_counter]['kpi_name'] = $v->kpi_name;
				$indv_user_data[$fusion_id]['row'.$row_no]['col'.$col_counter]['kpi_value'] = $v->kpi_value;
				$indv_user_data[$fusion_id]['row'.$row_no]['col'.$col_counter]['kpi_type'] = $v->kpi_type;
				$indv_user_data[$fusion_id]['row'.$row_no]['col'.$col_counter]['summ_type'] = $v->summ_type;
				$indv_user_data[$fusion_id]['row'.$row_no]['col'.$col_counter]['summ_formula'] = $v->summ_formula;
				$indv_user_data[$fusion_id]['row'.$row_no]['col'.$col_counter]['agent_view'] = $v->agent_view;
				$indv_user_data[$fusion_id]['row'.$row_no]['col'.$col_counter]['tl_view'] = $v->tl_view;
				$indv_user_data[$fusion_id]['row'.$row_no]['col'.$col_counter]['management_view'] = $v->management_view;
				$indv_user_data[$fusion_id]['row'.$row_no]['col'.$col_counter]['start_date'] = $v->start_date;
				$indv_user_data[$fusion_id]['row'.$row_no]['col'.$col_counter]['weightage'] = $v->weightage;
				$indv_user_data[$fusion_id]['row'.$row_no]['col'.$col_counter]['tl_name'] = $v->tl_fname.' '.$v->tl_lname;
				$indv_user_data[$fusion_id]['row'.$row_no]['col'.$col_counter]['agent_name'] = $v->agent_fname.' '.$v->agent_lname;
				$indv_user_data[$fusion_id]['row'.$row_no]['col'.$col_counter]['tl_fusion_id'] = $v->tl_fusion_id;
				$indv_user_data[$fusion_id]['row'.$row_no]['col'.$col_counter]['weightage_comp'] = $v->weightage_comp;
			
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
						foreach($processs_qa_data[$design_id] as $key=>$value)
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
		
		return $indv_user_data;
	}
	function prepare_summary($indv_user_raw_data_row,$tl=false)
	{
		$summary_array = array();
		$avg_counter = array();
		$CI = & get_instance();
		$CI->load->library('f_parser');
		foreach($indv_user_raw_data_row as $tl_fusion_id=>$user_data)
		{
			$row_counter = 1;
			foreach($user_data as $row_key=>$row)
			{
				
				foreach($row as $col_key=>$col)
				{
					if($tl != false)
					{
						$tl_fusion_id = $col['tl_fusion_id'];
					}
					if(!isset($summary_array[$tl_fusion_id][$col['kpi_name']]['value']))
					{
						$summary_array[$tl_fusion_id][$col['kpi_name']]['value'] = 0;
					}
					
					if($col['kpi_type'] == 1 || $col['kpi_type'] == 10)
					{
						$summary_array[$tl_fusion_id][$col['kpi_name']]['value'] = $col['kpi_value'];
						$summary_array[$tl_fusion_id][$col['kpi_name']]['agent_view'] = $col['agent_view'];
						$summary_array[$tl_fusion_id][$col['kpi_name']]['tl_view'] = $col['tl_view'];
						$summary_array[$tl_fusion_id][$col['kpi_name']]['management_view'] = $col['management_view'];
						$summary_array[$tl_fusion_id][$col['kpi_name']]['kpi_type'] = $col['kpi_type'];
						$summary_array[$tl_fusion_id][$col['kpi_name']]['weightage'] = $col['weightage'];
						$summary_array[$tl_fusion_id][$col['kpi_name']]['summ_type'] = $col['summ_type'];
						$summary_array[$tl_fusion_id][$col['kpi_name']]['summ_formula'] = $col['summ_formula'];
						$summary_array[$tl_fusion_id][$col['kpi_name']]['tl_name'] = $col['tl_name'];
						$summary_array[$tl_fusion_id][$col['kpi_name']]['agent_name'] = $col['agent_name'];
						$summary_array[$tl_fusion_id][$col['kpi_name']]['tl_fusion_id'] = $col['tl_fusion_id'];
						$summary_array[$tl_fusion_id][$col['kpi_name']]['weightage_comp'] = $col['weightage_comp'];
						
					}
					else
					{
						if($col['summ_type'] == 4)
						{
							if(trim($col['summ_formula']) == '')
							{
								$summary_array[$tl_fusion_id][$col['kpi_name']]['value'] = $summary_array[$tl_fusion_id][$col['kpi_name']]['value'] + $col['kpi_value'];
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
											$summary_array[$tl_fusion_id][$col['kpi_name']]['value'] = $summary_array[$tl_fusion_id][$col['kpi_name']]['value'] + $col['kpi_value'];
										}
									}
								}
							}
						}
						else if($col['summ_type'] == 11)
						{
							$summary_array[$tl_fusion_id][$col['kpi_name']]['value'] = '-';
						}
						else if($col['summ_type'] == 3)
						{
							if(!isset($avg_counter[$tl_fusion_id][$col['kpi_name']]['avg_count']))
							{
								$avg_counter[$tl_fusion_id][$col['kpi_name']]['avg_count'] = 0;
							}
							if(trim($col['summ_formula']) == '')
							{
								$summary_array[$tl_fusion_id][$col['kpi_name']]['value_cal'] = $summary_array[$tl_fusion_id][$col['kpi_name']]['value_cal'] + $col['kpi_value'];
								if(trim($col['kpi_value']) != '')
								{
									$avg_counter[$tl_fusion_id][$col['kpi_name']]['avg_count']++;
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
											$summary_array[$tl_fusion_id][$col['kpi_name']]['value_cal'] = $summary_array[$tl_fusion_id][$col['kpi_name']]['value_cal'] + $col['kpi_value'];
											if(trim($col['kpi_value']) != '')
											{
												$avg_counter[$tl_fusion_id][$col['kpi_name']]['avg_count']++;
											}
										}
									}
								}
							}
							//echo $row_counter.'<br>';
							//echo count($user_data).'<br>';
							$summary_array[$tl_fusion_id][$col['kpi_name']]['value'] = $summary_array[$tl_fusion_id][$col['kpi_name']]['value_cal']/$avg_counter[$tl_fusion_id][$col['kpi_name']]['avg_count'];
								//$row_counter=0;
							
						}
						$summary_array[$tl_fusion_id][$col['kpi_name']]['agent_view'] = $col['agent_view'];
						$summary_array[$tl_fusion_id][$col['kpi_name']]['tl_view'] = $col['tl_view'];
						$summary_array[$tl_fusion_id][$col['kpi_name']]['management_view'] = $col['management_view'];
						$summary_array[$tl_fusion_id][$col['kpi_name']]['kpi_type'] = $col['kpi_type'];
						$summary_array[$tl_fusion_id][$col['kpi_name']]['weightage'] = $col['weightage'];
						$summary_array[$tl_fusion_id][$col['kpi_name']]['summ_type'] = $col['summ_type'];
						$summary_array[$tl_fusion_id][$col['kpi_name']]['summ_formula'] = $col['summ_formula'];
						$summary_array[$tl_fusion_id][$col['kpi_name']]['tl_name'] = $col['tl_name'];
						$summary_array[$tl_fusion_id][$col['kpi_name']]['agent_name'] = $col['agent_name'];
						$summary_array[$tl_fusion_id][$col['kpi_name']]['tl_fusion_id'] = $col['tl_fusion_id'];
						$summary_array[$tl_fusion_id][$col['kpi_name']]['weightage_comp'] = $col['weightage_comp'];
					}
					
				}
				$row_counter++;
			}
		}
		$col_name_array = array();
		$col_val_array = array();
		foreach($summary_array as $tl_fusion_id=>$col_array)
		{
			foreach($col_array as $col_name=>$col_info)
			{
				$col_name_array[$tl_fusion_id][] = $col_name;
				$col_val_array[$tl_fusion_id][] = $col_info['value'];
			}
		}
		foreach($summary_array as $tl_fusion_id=>$col_array)
		{
			foreach($col_array as $col_name=>$col_info)
			{
				if($col_info['summ_type'] == 12)
				{
					$CI->f_parser->SetFormula(str_replace($col_name_array[$tl_fusion_id],$col_val_array[$tl_fusion_id],$col_info['summ_formula']));
					$p = $CI->f_parser->parser->getResult();
					$summary_array[$tl_fusion_id][$col_name]['value'] = $p[1];
				}
			}
		}
		return $summary_array;
	}
	
	
	function prepare_summary_overall($indv_user_raw_data_row)
	{
		$summary_array = array();
		$avg_counter = array();
		$CI = & get_instance();
		$CI->load->library('f_parser');
		$login_counter = array();
		foreach($indv_user_raw_data_row as $tl_fusion_id=>$user_data)
		{
			$row_counter = 1;
			foreach($user_data as $row_key=>$row)
			{
				
				foreach($row as $col_key=>$col)
				{
					if(!isset($summary_array[$col['kpi_name']]['value']))
					{
						$summary_array[$col['kpi_name']]['value'] = 0;
					}
					$login_counter[$tl_fusion_id] = 0;
					$summary_array['Login HC']['value'] = count($login_counter);
					$summary_array['Login HC']['agent_view'] = 1;
					$summary_array['Login HC']['tl_view'] = 1;
					$summary_array['Login HC']['management_view'] = 1;
					$summary_array['Login HC']['kpi_type'] = 7;
					$summary_array['Login HC']['weightage'] = 0;
					$summary_array['Login HC']['summ_type'] = 1;
					$summary_array['Login HC']['summ_formula'] = '';
					$summary_array['Login HC']['tl_name'] = $col['tl_name'];
					$summary_array['Login HC']['agent_name'] = $col['agent_name'];
					$summary_array['Login HC']['tl_fusion_id'] = $col['tl_fusion_id'];
					
					if($col['kpi_type'] == 1 || $col['kpi_type'] == 10)
					{
						$summary_array[$col['kpi_name']]['value'] = $col['kpi_value'];
						$summary_array[$col['kpi_name']]['agent_view'] = $col['agent_view'];
						$summary_array[$col['kpi_name']]['tl_view'] = $col['tl_view'];
						$summary_array[$col['kpi_name']]['management_view'] = $col['management_view'];
						$summary_array[$col['kpi_name']]['kpi_type'] = $col['kpi_type'];
						$summary_array[$col['kpi_name']]['weightage'] = $col['weightage'];
						$summary_array[$col['kpi_name']]['summ_type'] = $col['summ_type'];
						$summary_array[$col['kpi_name']]['summ_formula'] = $col['summ_formula'];
						$summary_array[$col['kpi_name']]['tl_name'] = $col['tl_name'];
						$summary_array[$col['kpi_name']]['agent_name'] = $col['agent_name'];
						$summary_array[$col['kpi_name']]['tl_fusion_id'] = $col['tl_fusion_id'];
						$summary_array[$col['kpi_name']]['weightage_comp'] = $col['weightage_comp'];
						
					}
					else
					{
						if($col['summ_type'] == 4)
						{
							if(trim($col['summ_formula']) == '')
							{
								$summary_array[$col['kpi_name']]['value'] = $summary_array[$col['kpi_name']]['value'] + $col['kpi_value'];
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
											$summary_array[$col['kpi_name']]['value'] = $summary_array[$col['kpi_name']]['value'] + $col['kpi_value'];
										}
									}
								}
							}
						}
						else if($col['summ_type'] == 11)
						{
							$summary_array[$col['kpi_name']]['value'] = '-';
						}
						else if($col['summ_type'] == 3)
						{
							if(!isset($avg_counter[$col['kpi_name']]['avg_count']))
							{
								$avg_counter[$col['kpi_name']]['avg_count'] = 0;
							}
							if(trim($col['summ_formula']) == '')
							{
								$summary_array[$col['kpi_name']]['value_cal'] = $summary_array[$col['kpi_name']]['value_cal'] + $col['kpi_value'];
								if(trim($col['kpi_value']) != '')
								{
									$avg_counter[$col['kpi_name']]['avg_count']++;
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
											$summary_array[$col['kpi_name']]['value_cal'] = $summary_array[$col['kpi_name']]['value_cal'] + $col['kpi_value'];
											if(trim($col['kpi_value']) != '')
											{
												$avg_counter[$col['kpi_name']]['avg_count']++;
											}
										}
									}
								}
							}
							//echo $row_counter.'<br>';
							//echo count($user_data).'<br>';
							
								$summary_array[$col['kpi_name']]['value'] = $summary_array[$col['kpi_name']]['value_cal']/$avg_counter[$col['kpi_name']]['avg_count'];
								//$row_counter=1;
							
						}
						$summary_array[$col['kpi_name']]['agent_view'] = $col['agent_view'];
						$summary_array[$col['kpi_name']]['tl_view'] = $col['tl_view'];
						$summary_array[$col['kpi_name']]['management_view'] = $col['management_view'];
						$summary_array[$col['kpi_name']]['kpi_type'] = $col['kpi_type'];
						$summary_array[$col['kpi_name']]['weightage'] = $col['weightage'];
						$summary_array[$col['kpi_name']]['summ_type'] = $col['summ_type'];
						$summary_array[$col['kpi_name']]['summ_formula'] = $col['summ_formula'];
						$summary_array[$col['kpi_name']]['tl_name'] = $col['tl_name'];
						$summary_array[$col['kpi_name']]['agent_name'] = $col['agent_name'];
						$summary_array[$col['kpi_name']]['tl_fusion_id'] = $col['tl_fusion_id'];
						$summary_array[$col['kpi_name']]['weightage_comp'] = $col['weightage_comp'];
					}
					
				}
				$row_counter++;
			}
		}
		$col_name_array = array();
		$col_val_array = array();
		foreach($summary_array as $col_name=>$col_info)
		{
			
				$col_name_array[] = $col_name;
				$col_val_array[] = $col_info['value'];
			
		}
		foreach($summary_array as $col_name=>$col_info)
		{
			
				if($col_info['summ_type'] == 12)
				{
					$CI->f_parser->SetFormula(str_replace($col_name_array,$col_val_array,$col_info['summ_formula']));
					$p = $CI->f_parser->parser->getResult();
					$summary_array[$col_name]['value'] = $p[1];
				}
			
		}
		return $summary_array;
	}
	
	function prepare_agent_name($design_id,$agents)
	{
		$agent_array = array();
		foreach($agents[$design_id] as $key=>$value)
		{
			$agent_array[$value->tl_fusion_id] = $value->tl_fname.' '.$value->tl_lname;
		}
		return $agent_array;
	}
?>
<?php
foreach($kpi_design as $key=>$kpi_design_value)
{
	/*  */
	//$tl_agent_final_score = calculate_rank($tl_agent_summary,$target[$kpi_design_value->design_id]);
	
	//$process_data_row = prepare_data_row($kpi_design_value->design_id,$kpi_col,$processs_kpi_data,false,$processs_qa_data);
	$process_agent_data_row = prepare_data_row($kpi_design_value->design_id,$kpi_col,$processs_kpi_data,false,$processs_qa_data);
	
	$proces_summary = prepare_summary($process_agent_data_row,true);
	$proces_summary_overall = prepare_summary_overall($process_agent_data_row);
	$proces_agent_summary = prepare_summary($process_agent_data_row);
	
	
	$agent_array = prepare_agent_name($kpi_design_value->design_id,$agents);
	
	$grade = $grade_bucket[$kpi_design_value->design_id];
	
	/* echo '<pre>';
	print_r($process_agent_data_row);
	echo '</pre>'; */
	
	foreach($proces_agent_summary as $agent_fusion_id=>$col_array)
	{
		$processs_agent_final_score = calculate_rank($proces_agent_summary,$target[$kpi_design_value->design_id][$agent_fusion_id]);
		foreach($grade as $key=>$value)
		{
			if($value->grade_start <= round($processs_agent_final_score[$agent_fusion_id]['total_score']) && $value->grade_end >= round($processs_agent_final_score[$agent_fusion_id]['total_score']))
			{
				$proces_agent_summary[$agent_fusion_id]['grade']['value'] = $value->grade;
				$proces_agent_summary[$agent_fusion_id]['grade']['management_view'] = 1;
				$proces_agent_summary[$agent_fusion_id]['grade']['agent_name'] = $col_array[array_key_first($col_array)]['agent_name'];
				$proces_agent_summary[$agent_fusion_id]['grade']['tl_fusion_id'] = $col_array[array_key_first($col_array)]['tl_fusion_id'];
				$proces_agent_summary[$agent_fusion_id]['grade']['kpi_type'] = 1;
				$proces_agent_summary[$agent_fusion_id]['grade']['summ_type'] = 11;
			}
		}
	}
	$ovarall_process_grade = array();
	foreach($proces_agent_summary as $agent_fusion_id=>$col_array)
	{
		if(!isset($proces_summary[$proces_agent_summary[$agent_fusion_id]['grade']['tl_fusion_id']]['grade']['A']))
		{
			$proces_summary[$proces_agent_summary[$agent_fusion_id]['grade']['tl_fusion_id']]['grade']['A'] = 0;
		}
		if(!isset($proces_summary[$proces_agent_summary[$agent_fusion_id]['grade']['tl_fusion_id']]['grade']['B']))
		{
			$proces_summary[$proces_agent_summary[$agent_fusion_id]['grade']['tl_fusion_id']]['grade']['B'] = 0;
		}
		if(!isset($proces_summary[$proces_agent_summary[$agent_fusion_id]['grade']['tl_fusion_id']]['grade']['C']))
		{
			$proces_summary[$proces_agent_summary[$agent_fusion_id]['grade']['tl_fusion_id']]['grade']['C'] = 0;
		}
		$proces_summary[$proces_agent_summary[$agent_fusion_id]['grade']['tl_fusion_id']]['grade'][$proces_agent_summary[$agent_fusion_id]['grade']['value']] = $proces_summary[$proces_agent_summary[$agent_fusion_id]['grade']['tl_fusion_id']]['grade'][$proces_agent_summary[$agent_fusion_id]['grade']['value']] + 1;
		
		if(!isset($ovarall_process_grade['grade']['A']))
		{
			$ovarall_process_grade['grade']['A'] = 0;
		}
		if(!isset($ovarall_process_grade['grade']['B']))
		{
			$ovarall_process_grade['grade']['B'] = 0;
		}
		if(!isset($ovarall_process_grade['grade']['C']))
		{
			$ovarall_process_grade['grade']['C'] = 0;
		}
		$ovarall_process_grade['grade'][$proces_agent_summary[$agent_fusion_id]['grade']['value']] = $ovarall_process_grade['grade'][$proces_agent_summary[$agent_fusion_id]['grade']['value']] + 1;
	}
?>
	<div class="row">
		<div class="col-md-4">
			<table id="default-datatable" data-plugin="DataTable" class="table table-striped skt-table" width="100%" cellspacing="0" style="text-align:center;">
				<thead>
					<tr style="background-color: #35b8e0;color: #fff; border:1px solid black;">
						<td colspan="2" style="text-align:center;border: 1px solid black;">Overall Grade</td>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td style="text-align:center;border: 1px solid black;">A</td>
						<td style="text-align:center;border: 1px solid black;"><?php echo number_format((($ovarall_process_grade['grade']['A']/($ovarall_process_grade['grade']['A']+$ovarall_process_grade['grade']['B']+$ovarall_process_grade['grade']['C']))*100),2).'%'; ?></td>
						
					</tr>
					<tr>
						<td style="text-align:center;border: 1px solid black;">B</td>
						<td style="text-align:center;border: 1px solid black;"><?php echo number_format((($ovarall_process_grade['grade']['B']/($ovarall_process_grade['grade']['A']+$ovarall_process_grade['grade']['B']+$ovarall_process_grade['grade']['C']))*100),2).'%'; ?></td>
						
					</tr>
					<tr>
						<td style="text-align:center;border: 1px solid black;">C</td>
						<td style="text-align:center;border: 1px solid black;"><?php echo number_format((($ovarall_process_grade['grade']['C']/($ovarall_process_grade['grade']['A']+$ovarall_process_grade['grade']['B']+$ovarall_process_grade['grade']['C']))*100),2).'%'; ?></td>
						
					</tr>
				</tbody>
			</table>
		</div>
		<div class="col-md-8">
			<table id="default-datatable" data-plugin="DataTable" class="table table-striped skt-table" width="100%" cellspacing="0" style="text-align:center;">
				<thead>
					<tr style="background-color: #35b8e0;color: #fff; border:1px solid black;">
						<td colspan="4" style="text-align:center;border: 1px solid black;">Overall Score</td>
					</tr>
				</thead>
				<tbody>
					<?php
						$i = 0;
						$end = 1;
						foreach($proces_summary_overall as $col_name=>$col_info)
						{
							if($col_info['management_view'] == 1)
							{
								if($i==0)
								{
									echo '<tr>';
									
								}
								echo '<td style="text-align:center;border: 1px solid black;">'.$col_name.'</td>';
								echo '<td style="text-align:center;border: 1px solid black;">'.value_calculation($col_info['kpi_type'],$col_info['value'],false).'</td>';
								$i = $i + 2;
								$end++;
								if($i == 4 || count($proces_summary_overall) == $end)
								{
									echo '</tr>';
									$i = 0;
								}
							}
						}
					?>
				</tbody>
			</table>
		</div>
	</div>
	<table id="default-datatable" data-plugin="DataTable" class="table table-striped skt-table" width="100%" cellspacing="0" style="text-align:center;">
		<thead id="thead">
			<tr style="background-color: #35b8e0;color: #fff; border:1px solid black;">
				<th style="text-align:center;border: 1px solid black;">Action</th>
				<th style="text-align:center;border: 1px solid black;">Name</th>
				<th style="text-align:center;border: 1px solid black;">Fusion ID</th>
				<th style="text-align:center;border: 1px solid black;">A</th>
				<th style="text-align:center;border: 1px solid black;">B</th>
				<th style="text-align:center;border: 1px solid black;">C</th>
				<th style="text-align:center;border: 1px solid black;">Login HC</th>
				
				<?php
					$i = 1;
					foreach($proces_summary as $fusion_id=>$col_array)
					{
						if($i==1)
						{
							foreach($col_array as $col_name=>$col_info)
							{
								if($col_info['management_view']==1)
								{
									echo '<th style="text-align:center;border: 1px solid black;">'.$col_name.'</th>';
								}
							}
						}
						else
						{
							break;
						}
						$i++;
					}
				?>
			</tr>
		</thead>
		<tbody>
			<?php
			foreach($proces_summary as $fusion_id=>$col_array)
			{
				$agent_row = array();
				echo '<tr style="background:white;" class="data_row">';
					$first_col_name = array_key_first($col_array);
					echo '<td style="text-align:center;border: 1px solid black;"><button class="btn btn-primary btn-xs open_agent_list"><i class="fa fa-plus-square" aria-hidden="true"></i></button></td>';
					echo '<td style="text-align:center;border: 1px solid black;">'.$col_array[$first_col_name]['tl_name'].'</td>';
					echo '<td style="text-align:center;border: 1px solid black;" data-fusion_id="'.$fusion_id.'">'.$fusion_id.'</td>';
					echo '<td style="text-align:center;border: 1px solid black;">'.number_format((($col_array['grade']['A']/($col_array['grade']['A']+$col_array['grade']['B']+$col_array['grade']['C']))*100),2).'%</td>';
					echo '<td style="text-align:center;border: 1px solid black;">'.number_format((($col_array['grade']['B']/($col_array['grade']['A']+$col_array['grade']['B']+$col_array['grade']['C']))*100),2).'%</td>';
					echo '<td style="text-align:center;border: 1px solid black;">'.number_format((($col_array['grade']['C']/($col_array['grade']['A']+$col_array['grade']['B']+$col_array['grade']['C']))*100),2).'%</td>';
					$tl_counter = 1;
					foreach($col_array as $col_name=>$col_info)
					{
						foreach($proces_agent_summary as $agent_fusion_id=>$col_array)
						{
							foreach($col_array as $col_name=>$col_infos)
							{
								if($col_infos['tl_fusion_id'] == $fusion_id)
								{
									$agent_row[$agent_fusion_id] = $col_array;
								}
							}
						}
						if($tl_counter == 1)
						{
							echo '<td style="text-align:center;border: 1px solid black;">'.count($agent_row).'</td>';
						}
						if($col_info['management_view'] == 1)
						{
							
							echo '<td style="text-align:center;border: 1px solid black;">'.value_calculation($col_info['kpi_type'],$col_info['value'],false).'</td>';
						}
						$tl_counter ++;
					}
				echo '</tr>';
				echo '<tr class="agent_list">';
					echo '<td colspan="'.(count($col_array)+4).'">';
						echo '<div>';
						echo '<table data-plugin="DataTable" class="table table-striped skt-table" width="100%" cellspacing="0" style="text-align:center;">';
						?>

					<thead>
						<tr style="background-color: #35b8e0;color: #fff; border:1px solid black;">
							<th style="border-right: 1px solid black;"><a onclick="exportF1(this)"><button class="btn btn-xs btn-warning"><i class="fa fa-file-excel-o" aria-hidden="true"></i></button></a></th>
							<th style="text-align:center;border: 1px solid black;">Name</th>
							<th style="text-align:center;border: 1px solid black;">Fusion ID</th>
							<th style="text-align:center;border: 1px solid black;">A</th>
							<th style="text-align:center;border: 1px solid black;">B</th>
							<th style="text-align:center;border: 1px solid black;">C</th>
							<th style="text-align:center;border: 1px solid black;">Login HC</th>
							<?php
								$i = 1;
								foreach($proces_summary as $fusion_id=>$col_array)
								{
									if($i==1)
									{
										foreach($col_array as $col_name=>$col_info)
										{
											if($col_info['management_view']==1)
											{
												echo '<th style="text-align:center;border: 1px solid black;">'.$col_name.'</th>';
											}
										}
									}
									else
									{
										break;
									}
									$i++;
								}
							?>
						</tr>
					</thead>
					
<?php
					echo '<tbody>';
						foreach($agent_row as $agent_fusion_id=>$col_array)
						{
							echo '<tr style="background:#a0f2a0;">';
								$first_col_name = array_key_first($col_array);
								echo '<td style="border-right: 1px solid black;"></td>';
								echo '<td style="text-align:center;border: 1px solid black;">'.$col_array[$first_col_name]['agent_name'].'</td>';
								echo '<td style="text-align:center;border: 1px solid black;">'.$agent_fusion_id.'</td>';
								if($col_array['grade']['value'] == 'A')
								{
									echo '<td style="text-align:center;border: 1px solid black;">A</td>';
								}
								else
								{
									echo '<td style="text-align:center;border: 1px solid black;"></td>';
								}
								if($col_array['grade']['value'] == 'B')
								{
									echo '<td style="text-align:center;border: 1px solid black;">B</td>';
								}
								else
								{
									echo '<td style="text-align:center;border: 1px solid black;"></td>';
								}
								if($col_array['grade']['value'] == 'C')
								{
									echo '<td style="text-align:center;border: 1px solid black;">C</td>';
								}
								else
								{
									echo '<td style="text-align:center;border: 1px solid black;"></td>';
								}
								echo '<td style="text-align:center;border: 1px solid black;">P</td>';
								foreach($col_array as $col_name=>$col_info)
								{
									if($col_info['management_view'] == 1)
									{
										if($col_name != 'grade')
										{
											echo '<td style="text-align:center;border: 1px solid black;">'.value_calculation($col_info['kpi_type'],$col_info['value'],false).'</td>';
										}
									}
									
								}
							echo '</tr>';
						}
					echo '</tbody>';
					echo '</table>';
					echo '</div>';
				echo '</td>';
				echo '</tr>';
			}
?>
		</tbody>
	</table>
<?php
}
?>

