<?php
	
	

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
								$rank[$fusion_id][$v->kpi_name]['score'] = (($value['value']/$v->target)*$value['weightage']);
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
				if($value['score'] > $value['weightage'])
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
			else if($kpi_type == 7 ) $kpiDispVal = round($kpi_value,2);
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
	function prepare_row_indv_user_data($design_id,$kpi_col,$kpi_data,$qa_data)
	{
		$available_col_count = count($kpi_col[$design_id]);
		$indv_user_data = array();
		$row_no = 1;
		$col_counter = 1;
		
		$available_kpi_name = array();
		foreach($kpi_col[$design_id] as $key=>$info)
		{
			$available_kpi_name[] = $info->kpi_name;
		}
		
		foreach($kpi_data[$design_id] as $k=>$v)
		{
			$indv_user_data[$v->fusion_id]['row'.$row_no]['col'.$col_counter]['kpi_name'] = 'CQ_SCORE';
			$indv_user_data[$v->fusion_id]['row'.$row_no]['col'.$col_counter]['kpi_value'] = '';
			$indv_user_data[$v->fusion_id]['row'.$row_no]['col'.$col_counter]['kpi_type'] = 2;
			$indv_user_data[$v->fusion_id]['row'.$row_no]['col'.$col_counter]['summ_type'] = 3;
			$indv_user_data[$v->fusion_id]['row'.$row_no]['col'.$col_counter]['summ_formula'] = '';
			$indv_user_data[$v->fusion_id]['row'.$row_no]['col'.$col_counter]['agent_view'] = $kpi_col[$design_id][$col_counter-1]->agent_view;
			$indv_user_data[$v->fusion_id]['row'.$row_no]['col'.$col_counter]['tl_view'] = $kpi_col[$design_id][$col_counter-1]->tl_view;
			$indv_user_data[$v->fusion_id]['row'.$row_no]['col'.$col_counter]['start_date'] = $v->start_date;
			$indv_user_data[$v->fusion_id]['row'.$row_no]['col'.$col_counter]['weightage'] = $v->weightage;
			
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
			}
			
			if($available_col_count == $col_counter)
			{
				$row_no++;
				$col_counter = 1;
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
		return $indv_user_data;
	}
	function prepare_row_every_indv_user_data($design_id,$kpi_col,$kpi_data,$everyone_qa_data)
	{
		$available_col_count = count($kpi_col[$design_id]);
		$indv_user_data = array();
		$row_no = 1;
		$col_counter = 1;
		
		$available_kpi_name = array();
		foreach($kpi_col[$design_id] as $key=>$info)
		{
			$available_kpi_name[] = $info->kpi_name;
		}
		
		foreach($kpi_data[$design_id] as $k=>$v)
		{
			$indv_user_data[$v->fusion_id]['row'.$row_no]['col'.$col_counter]['kpi_name'] = 'CQ_SCORE';
			$indv_user_data[$v->fusion_id]['row'.$row_no]['col'.$col_counter]['kpi_value'] = '';
			$indv_user_data[$v->fusion_id]['row'.$row_no]['col'.$col_counter]['kpi_type'] = 2;
			$indv_user_data[$v->fusion_id]['row'.$row_no]['col'.$col_counter]['summ_type'] = 3;
			$indv_user_data[$v->fusion_id]['row'.$row_no]['col'.$col_counter]['summ_formula'] = '';
			$indv_user_data[$v->fusion_id]['row'.$row_no]['col'.$col_counter]['agent_view'] = $kpi_col[$design_id][$col_counter-1]->agent_view;
			$indv_user_data[$v->fusion_id]['row'.$row_no]['col'.$col_counter]['tl_view'] = $kpi_col[$design_id][$col_counter-1]->tl_view;
			$indv_user_data[$v->fusion_id]['row'.$row_no]['col'.$col_counter]['start_date'] = $v->start_date;
			$indv_user_data[$v->fusion_id]['row'.$row_no]['col'.$col_counter]['weightage'] = $v->weightage;
			
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
			}
			
			if($available_col_count == $col_counter)
			{
				$row_no++;
				$col_counter = 1;
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
						foreach($everyone_qa_data[$design_id] as $key=>$value)
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
	
	
	function prepare_indv_user_summary($indv_user_raw_data_row)
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
					}
					else
					{
						if($col['summ_type'] == 4 || $col['summ_type'] == 12)
						{
							if(trim($col['summ_formula']) == '')
							{
								$summary_array[$fusion_id][$col['kpi_name']]['value'] = $summary_array[$fusion_id][$col['kpi_name']]['value'] + $col['kpi_value'];
							}
							else
							{
								if($col['summ_type'] == 12)
								{
									if(count($user_data) == $row_counter)
									{
										$summary_array[$fusion_id][$col['kpi_name']]['value'] = 0;
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
												$summary_array[$fusion_id][$col['kpi_name']]['value'] = $summary_array[$fusion_id][$col['kpi_name']]['value'] + $col['kpi_value'];
											}
										}
									}
								}
							}
							$summary_array[$fusion_id][$col['kpi_name']]['weightage'] = $col['weightage'];
							$summary_array[$fusion_id][$col['kpi_name']]['summ_formula'] = $col['summ_formula'];
							$summary_array[$fusion_id][$col['kpi_name']]['summ_type'] = $col['summ_type'];
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
								$summary_array[$fusion_id][$col['kpi_name']]['value'] = $summary_array[$fusion_id][$col['kpi_name']]['value'] + $col['kpi_value'];
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
											$summary_array[$fusion_id][$col['kpi_name']]['value'] = $summary_array[$fusion_id][$col['kpi_name']]['value'] + $col['kpi_value'];
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
							if(count($user_data) == $row_counter)
							{
								$summary_array[$fusion_id][$col['kpi_name']]['value'] = $summary_array[$fusion_id][$col['kpi_name']]['value']/$avg_counter[$fusion_id][$col['kpi_name']]['avg_count'];
								//$row_counter=1;
							}
						}
						$summary_array[$fusion_id][$col['kpi_name']]['agent_view'] = $col['agent_view'];
						$summary_array[$fusion_id][$col['kpi_name']]['tl_view'] = $col['tl_view'];
						$summary_array[$fusion_id][$col['kpi_name']]['kpi_type'] = $col['kpi_type'];
						$summary_array[$fusion_id][$col['kpi_name']]['weightage'] = $col['weightage'];
						$summary_array[$fusion_id][$col['kpi_name']]['summ_formula'] = $col['summ_formula'];
						$summary_array[$fusion_id][$col['kpi_name']]['summ_type'] = $col['summ_type'];
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
				$col_name_array[] = $col_name;
				$col_val_array[] = $col_info['value'];
			}
		}
		foreach($summary_array as $fusion_id=>$col_array)
		{
			foreach($col_array as $col_name=>$col_info)
			{
				if($col_info['summ_type'] == 12)
				{
					
					$CI->f_parser->SetFormula(str_replace($col_name_array,$col_val_array,$col_info['summ_formula']));
					$p = $CI->f_parser->parser->getResult();
					$summary_array[$fusion_id][$col_name]['value'] = $p[1];
				}
			}
		}
		/* echo '<pre>';
		print_r($summary_array);
		echo '</pre>'; */
		return $summary_array;
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
					}
					else
					{
						if($col['summ_type'] == 4 || $col['summ_type'] == 12)
						{
							if(trim($col['summ_formula']) == '')
							{
								$summary_array[$fusion_id][$col['kpi_name']]['value'] = $summary_array[$fusion_id][$col['kpi_name']]['value'] + $col['kpi_value'];
							}
							else
							{
								if($col['summ_type'] == 12)
								{
									if(count($user_data) == $row_counter)
									{
										$summary_array[$fusion_id][$col['kpi_name']]['value'] = 0;
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
												$summary_array[$fusion_id][$col['kpi_name']]['value'] = $summary_array[$fusion_id][$col['kpi_name']]['value'] + $col['kpi_value'];
											}
										}
									}
								}
							}
							$summary_array[$fusion_id][$col['kpi_name']]['weightage'] = $col['weightage'];
							$summary_array[$fusion_id][$col['kpi_name']]['summ_type'] = $col['summ_type'];
							$summary_array[$fusion_id][$col['kpi_name']]['summ_formula'] = $col['summ_formula'];
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
								$summary_array[$fusion_id][$col['kpi_name']]['value'] = $summary_array[$fusion_id][$col['kpi_name']]['value'] + $col['kpi_value'];
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
											$summary_array[$fusion_id][$col['kpi_name']]['value'] = $summary_array[$fusion_id][$col['kpi_name']]['value'] + $col['kpi_value'];
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
							if(count($user_data) == $row_counter)
							{
								$summary_array[$fusion_id][$col['kpi_name']]['value'] = $summary_array[$fusion_id][$col['kpi_name']]['value']/$avg_counter[$fusion_id][$col['kpi_name']]['avg_count'];
								//$row_counter=1;
							}
						}
						$summary_array[$fusion_id][$col['kpi_name']]['agent_view'] = $col['agent_view'];
						$summary_array[$fusion_id][$col['kpi_name']]['tl_view'] = $col['tl_view'];
						$summary_array[$fusion_id][$col['kpi_name']]['kpi_type'] = $col['kpi_type'];
						$summary_array[$fusion_id][$col['kpi_name']]['weightage'] = $col['weightage'];
						$summary_array[$fusion_id][$col['kpi_name']]['summ_type'] = $col['summ_type'];
						$summary_array[$fusion_id][$col['kpi_name']]['summ_formula'] = $col['summ_formula'];
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
				$col_name_array[] = $col_name;
				$col_val_array[] = $col_info['value'];
			}
		}
		foreach($summary_array as $fusion_id=>$col_array)
		{
			foreach($col_array as $col_name=>$col_info)
			{
				if($col_info['summ_type'] == 12)
				{
					$CI->f_parser->SetFormula(str_replace($col_name_array,$col_val_array,$col_info['summ_formula']));
					$p = $CI->f_parser->parser->getResult();
					$summary_array[$fusion_id][$col_name]['value'] = $p[1];
				}
			}
		}
		return $summary_array;
	}
	
	
?>
<?php
foreach($kpi_design as $key=>$kpi_design_value)
{
	
	$indv_user_raw_data_row = prepare_row_indv_user_data($kpi_design_value->design_id,$kpi_col,$kpi_data,$qa_data);
	$everyone_indv_user_raw_data_row = prepare_row_every_indv_user_data($kpi_design_value->design_id,$kpi_col,$everyone_kpi_data,$everyone_qa_data);
	
	$everyone_indv_user_summary = prepare_everyone_indv_user_summary($everyone_indv_user_raw_data_row);
	$final_score = calculate_rank($everyone_indv_user_summary,$target[$kpi_design_value->design_id]);
	//echo '<pre>';
	//print_r($final_score);
	//print_r(prepare_indv_user_summary($indv_user_raw_data_row));
	//echo '</pre>';
	//echo '<pre>';
	//print_r($target[$kpi_design_value->design_id]);
	//echo '<pre>';
	$rank = get_rank($final_score);
	$grade = $grade_bucket[$kpi_design_value->design_id];
	//echo '</pre>';
	
	$indv_user_summary = prepare_indv_user_summary($indv_user_raw_data_row);
	/* echo '<pre>';
	print_r($indv_user_summary);
	echo '</pre>'; */
?>
<table id="default-datatable" data-plugin="DataTable" class="table table1 table-striped skt-table" width="100%" cellspacing="0">
								<thead>
									<tr style="background-color: #35b8e0;color: #fff; border:1px solid black;">
										<td>Export</td>
										<td>Date</td>
									<?php
									//print_r($kpi_col);
									foreach($kpi_col as $key=>$value)
									{
										foreach($value as $ke=>$val)
										{
											if($val->agent_view == 1)
											{
												echo '<th>'.$val->kpi_name.'</th>';
											}
										}
									}
									?>
									</tr>
								</thead>
								<tbody>
									<?php
										foreach($indv_user_summary as $key=>$row)
										{
											echo '<tr style="background:orange;">';
												echo '<td style="text-align:center;border: 1px solid black;"><a onclick="exportF1(this)"><button class="btn btn-xs btn-info"><i class="fa fa-file-excel-o" aria-hidden="true"></i></button></a></td>';
												echo '<td style="text-align:center;border: 1px solid black;">MTD of '.$report_of.'</td>';
											foreach($row as $row_key=>$col)
											{
													if($col['agent_view'] == 1)
													{
														echo '<td style="text-align:center;border: 1px solid black;">'.value_calculation($col['kpi_type'],$col['value'],false).'</td>';
													}
												
											}
											echo '</tr>';
										}
									?>
									<?php
										foreach($indv_user_raw_data_row as $key=>$row)
										{
											foreach($row as $row_key=>$col)
											{
												echo '<tr>';
													$start_data = 0;
													
													foreach($col as $col_key=>$value)
													{
														if($start_data == 0)
														{
															echo '<td style="text-align:center;border: 1px solid black;"></td>';
															echo '<td style="text-align:center;border: 1px solid black;">'.$value['start_date'].'</td>';
															$start_data = 1;
														}
														if($value['agent_view'] == 1)
														{
															echo '<td style="text-align:center;border: 1px solid black;">'.value_calculation($value['kpi_type'],$value['kpi_value'],true).'</td>';
														}
														
														
													}
												echo '</tr>';
											}
										}
									?>
									
								</tbody>
							</table>

<?php
}
?>