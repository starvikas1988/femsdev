<?php
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
				
				$col_name_array[$v->start_date.'#'.$v->end_date][] = $v->kpi_name;
				$col_val_array[$v->start_date.'#'.$v->end_date][] = $v->kpi_value;
				
				if(!isset($agent_target[$v->fusion_id][$v->kpi_name]))
				{
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
		$array = calculate($array,$col_name_array,$col_val_array);
	/* echo '<pre>';
		print_r($array);
	echo '</pre>'; */
	return $array;
	}
	
	function calculate($array,$col_name_array,$col_val_array)
	{
		$CI = & get_instance();
		$CI->load->library('f_parser');
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
							if($infos['summ_type'] == 12)
							{
								$CI->f_parser->SetFormula(str_replace($col_name_array[$date],$col_val_array[$date],$infos['summ_formula']));
								$p = $CI->f_parser->parser->getResult();
								if(is_nan($p[1]))
								{
									$array[$did][$tl_id][$agent_id][$date][$kpi_name]['kpi_value'] = 0;
								}
								else
								{
									$array[$did][$tl_id][$agent_id][$date][$kpi_name]['kpi_value'] = $p[1];
								}
								
								if($array[$did][$tl_id][$agent_id][$date][$kpi_name]['target'] != '')
								{
									$array[$did][$tl_id][$agent_id][$date][$kpi_name]['score'] = (($array[$did][$tl_id][$agent_id][$date][$kpi_name]['kpi_value']/$array[$did][$tl_id][$agent_id][$date][$kpi_name]['target'])*$array[$did][$tl_id][$agent_id][$date][$kpi_name]['weightage']);
									if($array[$did][$tl_id][$agent_id][$date][$kpi_name]['score'] > $array[$did][$tl_id][$agent_id][$date][$kpi_name]['weightage'])
									{
										$array[$did][$tl_id][$agent_id][$date][$kpi_name]['score'] = $array[$did][$tl_id][$agent_id][$date][$kpi_name]['weightage'];
									}
									else
									{
										$array[$did][$tl_id][$agent_id][$date][$kpi_name]['score']= $array[$did][$tl_id][$agent_id][$date][$kpi_name]['score'];
									}
								}
								else
								{
									$array[$did][$tl_id][$agent_id][$date][$kpi_name]['score'] = 0;
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
		foreach($target as $key=>$value)
		{
			if($value->did == $did && $value->kpi_name == $kpi_name && $value->year == $year && $value->month == $month && ($tenure >= $value->tenure_bucket_start) && ($tenure >= $value->tenure_bucket_end))
			{
				return array($agent_fusion_id,$value->target,$kpi_name);
				break;
			}
		}
	}
	
	function agent_level_final_monthly_summary($array)
	{
		$agent_level_final_monthly_summary = array();
		$CI = & get_instance();
		$CI->load->library('f_parser');
		foreach($array as $did=>$tl_info)
		{
			foreach($tl_info as $tl_id=>$agent_info)
			{
				$row_counter = 1;
				foreach($agent_info as $agent_id=>$date_info)
				{
					foreach($date_info as $date=>$kpi_info)
					{
						foreach($kpi_info as $kpi_name=>$infos)
						{
							$date_array = explode('#',$date);
							$time=strtotime($date_array[0]);
							$month=date("F",$time);
							
							if($infos['summ_type'] == 1 || $infos['summ_type'] == 10)
							{
								$agent_level_final_monthly_summary[$did][$tl_id][$agent_id]['MTD of '.$month][$kpi_name]['kpi_value'] = $infos['kpi_value'];
								
							}
							else if($infos['summ_type'] == 11)
							{
								$agent_level_final_monthly_summary[$did][$tl_id][$agent_id]['MTD of '.$month][$kpi_name]['kpi_value'] = '-';
							}
							else if($infos['summ_type'] == 12)
							{
								$agent_level_final_monthly_summary[$did][$tl_id][$agent_id]['MTD of '.$month][$kpi_name]['kpi_value'] = 0;
							}
							else if($infos['summ_type'] == 4)
							{
								if(trim($infos['summ_formula']) == '')
								{
									$agent_level_final_monthly_summary[$did][$tl_id][$agent_id]['MTD of '.$month][$kpi_name]['kpi_value'] = $agent_level_final_monthly_summary[$did][$tl_id][$agent_id]['MTD of '.$month][$kpi_name]['kpi_value'] + $infos['kpi_value'];
								}
								else
								{
									$cond_array = explode('=',$infos['summ_formula']);
									$condition = $cond_array[0];
									$condition_value = $cond_array[1];
									if($array[$did][$tl_id][$agent_id][$date][$condition]['kpi_value'] == $condition_value)
									{
										$agent_level_final_monthly_summary[$did][$tl_id][$agent_id]['MTD of '.$month][$kpi_name]['kpi_value'] = $agent_level_final_monthly_summary[$did][$tl_id][$agent_id]['MTD of '.$month][$kpi_name]['kpi_value'] + $infos['kpi_value'];
									}
								}
							}
							else if($infos['summ_type'] == 3)
							{
								if(!isset($avg_counter[$did][$tl_id][$agent_id]['MTD of '.$month][$kpi_name]['avg_count']))
								{
									$avg_counter[$did][$tl_id][$agent_id]['MTD of '.$month][$kpi_name]['avg_count'] = 0;
								}
								if(trim($infos['summ_formula']) == '')
								{
									$agent_level_final_monthly_summary[$did][$tl_id][$agent_id]['MTD of '.$month][$kpi_name]['kpi_value'] = $agent_level_final_monthly_summary[$did][$tl_id][$agent_id]['MTD of '.$month][$kpi_name]['kpi_value'] + $infos['kpi_value'];
									if(trim($infos['kpi_value']) != '')
									{
										$avg_counter[$did][$tl_id][$agent_id]['MTD of '.$month][$kpi_name]['avg_count']++;
									}
								}
								else
								{
									$cond_array = explode('=',$infos['summ_formula']);
									$condition = $cond_array[0];
									$condition_value = $cond_array[1];
									if($array[$did][$tl_id][$agent_id][$date][$condition]['kpi_value'] == $condition_value)
									{
										$agent_level_final_monthly_summary[$did][$tl_id][$agent_id]['MTD of '.$month][$kpi_name]['kpi_value'] = $agent_level_final_monthly_summary[$did][$tl_id][$agent_id]['MTD of '.$month][$kpi_name]['kpi_value'] + $infos['kpi_value'];
										if(trim($infos['kpi_value']) != '')
										{
											$avg_counter[$did][$tl_id][$agent_id]['MTD of '.$month][$kpi_name]['avg_count']++;
										}
									}
								}
								
								
								if(count($date_info) == $row_counter)
								{
									$agent_level_final_monthly_summary[$did][$tl_id][$agent_id]['MTD of '.$month][$kpi_name]['kpi_value']=$agent_level_final_monthly_summary[$did][$tl_id][$agent_id]['MTD of '.$month][$kpi_name]['kpi_value']/$avg_counter[$did][$tl_id][$agent_id]['MTD of '.$month][$kpi_name]['avg_count'];
									//$row_counter=1;
								}
							}
							$agent_level_final_monthly_summary[$did][$tl_id][$agent_id]['MTD of '.$month][$kpi_name]['kpi_type'] = $infos['kpi_type'];
							$agent_level_final_monthly_summary[$did][$tl_id][$agent_id]['MTD of '.$month][$kpi_name]['summ_type'] = $infos['summ_type'];
							$agent_level_final_monthly_summary[$did][$tl_id][$agent_id]['MTD of '.$month][$kpi_name]['summ_formula'] = $infos['summ_formula'];
							$agent_level_final_monthly_summary[$did][$tl_id][$agent_id]['MTD of '.$month][$kpi_name]['agent_view'] = $infos['agent_view'];
							$agent_level_final_monthly_summary[$did][$tl_id][$agent_id]['MTD of '.$month][$kpi_name]['tl_view'] = $infos['tl_view'];
							$agent_level_final_monthly_summary[$did][$tl_id][$agent_id]['MTD of '.$month][$kpi_name]['management_view'] = $infos['management_view'];
							$agent_level_final_monthly_summary[$did][$tl_id][$agent_id]['MTD of '.$month][$kpi_name]['weightage'] = $infos['weightage'];
							$agent_level_final_monthly_summary[$did][$tl_id][$agent_id]['MTD of '.$month][$kpi_name]['target'] = $infos['target'];
							$agent_level_final_monthly_summary[$did][$tl_id][$agent_id]['MTD of '.$month][$kpi_name]['score'] = $infos['score'];
						}
						$row_counter++;
					}
					
				}
			}
		}
		echo '<pre>';
		print_r($agent_level_final_monthly_summary);
		echo '</pre>';
	}
	
foreach($kpi_design as $key=>$kpi_design_value)
{
	$array = prepare_row($kpi_design_value->design_id,$kpi_col,$kpi_data,$qa_data,$target);
	agent_level_final_monthly_summary($array);
	/* target_array($target[$kpi_design_value->design_id]);
	print_r($target[$kpi_design_value->design_id]); */
}
?>