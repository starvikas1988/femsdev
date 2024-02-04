
 <style>

	.table > thead > tr > th, .table > thead > tr > td, .table > tbody > tr > th, .table > tbody > tr > td, .table > tfoot > tr > th, .table > tfoot > tr > td {
		vertical-align:middle;
		padding:4px;
		font-size:11px;
	}
	
	.table > thead > tr > th,.table > tfoot > tr > th{
			text-align:center;
	}

	.inputTable > tr > td{
		font-size:12px;
		padding:4px;
	}
	
</style>



<!-- Metrix -->



<div class="wrap">
<section class="app-content">

<?php 
	if(get_role_dir()!="agent" || get_dept_folder() =="wfm" || get_dept_folder() =="rta" || get_dept_folder()=="mis"){
?>
	
<div class="row">
<div class="col-md-12">
<div class="widget">
<header class="widget-header">
<h4 class="widget-title">Performance Metrix Screen</h4>
</header>
<hr class="widget-separator"/>
<div class="widget-body clearfix">

<div class="row">
	
	<?php echo form_open('',array('method' => 'get')) ?>
	
		<div class="col-md-2" >
			
			<div class="form-group" id="foffice_div">
				<label for="office_id">Select a Location</label>
				<select class="form-control" name="office_id" id="foffice_id" >
					<option value='XXX'>-Select-</option>
					<?php foreach($location_list as $loc): ?>
						<?php
						$sCss="";
						if($loc['abbr']==$oValue) $sCss="selected";
						?>
					<option value="<?php echo $loc['abbr']; ?>" <?php echo $sCss;?>><?php echo $loc['office_name']; ?></option>
						
					<?php endforeach; ?>
				</select>
			</div>
		</div>
				
		<div class="col-md-3">
			<div class="form-group">
				<label for="client_id">Select a Client</label>
				<select class="form-control" name="client_id" id="fclient_id" >
				
					<?php foreach($client_list as $client): ?>
						
						<?php
						
								$sCss="";
								if($client['id']==$cValue) $sCss="selected";
								
							?>
								<option value="<?php echo $client['id']; ?>" <?php echo $sCss;?>><?php echo $client['shname']; ?></option>
							<?php
						
						?>
						
						<?php endforeach; ?>
															
				</select>
			</div>
		</div>
	
		<div class="col-md-2" id="process_div" >
			<div class="form-group">
			<label for="process_id">Select a process</label>
			<select class="form-control onProcessAction" name="process_id" id="fprocess_id" >
				<option value='0'>ALL Process</option>
				<?php foreach($process_list as $process): ?>
					<?php
						if($process->id ==0 ) continue;
						$sCss="";
						if($process->id==$pValue) $sCss="selected";
					?>
					<option value="<?php echo $process->id; ?>" <?php echo $sCss;?> ><?php echo $process->name; ?></option>
					
				<?php endforeach; ?>
				
			</select>
			</div>
		</div>
		
		
		<div class='col-md-3' >
			<div class="form-group" id="week_range_container">
				<?php
					if(isset($all_sch_date_range))
					{
				?>
				<label for="sch_range">Select a Metrix Week</label>
				<select class="form-control" name="sch_range" id="sch_range" required>
					  <option value="">--Select--</option>
					<?php foreach($all_sch_date_range as $shDtRange): ?>
						<?php
							$sCss="";
							if($shDtRange['shrange']==$sch_date_range) $sCss="selected";
						?>
						<option value="<?php echo $shDtRange['start_date']."#".$shDtRange['end_date']; ?>" data-mdid="<?php echo $mdid_type; ?>" <?php echo $sCss;?> ><?php echo $shDtRange['shrange']; ?></option>
						
					<?php endforeach; ?>
															
				</select>
				<?php
					}
				?>
			</div>
		<!-- .form-group -->
		</div>

		
		<div class="col-md-2">
				<input type="submit" class="btn btn-primary btn-md" style="margin-top:24px;" id='showReports' name='showReports' value="Show">
				<?php
					if($mdid_type == 1)
					{
						echo '<input type="submit" class="btn btn-primary btn-md" style="margin-top:24px;width: 94px;" id="showsummary" name="showReports" value="Summary">';
					}
				?>
		</div>
		</form>
		
</div><!-- .row -->



</div>
</div>
</div>
</div><!-- .row -->


<?php 
	}
	function cal_overall_summary($summary,$mpid)
	{
		
		foreach($summary as $key=>$value)
		{
			$last_row_counter = 1;
			//echo count($value);
			foreach($value as $ke=>$valu)
			{
				foreach($valu as $k=>$val)
				{
					if($k != 'fusion_id')
					{
						if(!isset($overall_summary[$mpid][$k]))
						{
							$overall_summary[$mpid][$k] = '';
						}
						$kpi_infos = explode(' ## ',$k);
						$kpi_name = $kpi_infos[1];
						$formula = $kpi_infos[3];
						$sum_product_with = $kpi_infos[4];
						if(!isset($avg_counter[$mpid][$k]))
						{
							$avg_counter[$mpid][$k] = 0;
						}
						if($formula == 3)
						{
							if($val != '')
							{
								$avg_counter[$mpid][$k]++;
							}
							$overall_summary[$mpid][$k] = $overall_summary[$mpid][$k] + $val;
							
							if(count($value) == $last_row_counter)
							{
								if(!isset($avg_counter[$mpid][$k]) || $avg_counter[$mpid][$k] == 0)
								{
									$overall_summary[$mpid][$k] = 0;
								}
								else
								{
									$overall_summary[$mpid][$k] = $overall_summary[$mpid][$k] / $avg_counter[$mpid][$k];
								}
							}
						}
						else if($formula == 5)
						{
							foreach($valu as $keeey=>$valueee)
							{
								if($keeey != 'fusion_id')
								{
									$kpi_info = explode(' ## ',$keeey);
								
									if($kpi_info[1] == $sum_product_with)
									{
										$product_with = $valueee;
										$sum_product_key = $keeey;
									}
								}
							}
							$overall_summary[$mpid][$k] = $overall_summary[$mpid][$k] + ($val * $product_with);
							if(count($value) == $last_row_counter)
							{
								if(!isset($overall_summary[$mpid][$sum_product_key]) || $overall_summary[$mpid][$sum_product_key] == 0)
								{
									$overall_summary[$mpid][$k] = 0;
								}
								else
								{
									$overall_summary[$mpid][$k] = $overall_summary[$mpid][$k] / $overall_summary[$mpid][$sum_product_key];
								}
							}
						}
						else
						{
							$overall_summary[$mpid][$k] = $overall_summary[$mpid][$k] + $val;
						}
						
					}
					
				}
				$last_row_counter++;
			}
		}
		return $overall_summary;
		/* echo '<pre>';
		print_r($overall_summary);
		echo '</pre>'; */
	}
	
	function cal_weightage($summary,$mpid)
	{
		foreach($summary[$mpid] as $key=>$value)
		{
			foreach($value as $ke=>$valu)
			{
				if($ke != 'fusion_id')
				{
					$kpi_info = explode(' ## ',$ke);
					$weightage = $kpi_info[5];
					$total_score[$mpid][$key][] = (($valu * $weightage)/100);
				}
			}
		}
		foreach($total_score[$mpid] as $key=>$value)
		{
			$final_score[$mpid][$key] = array_sum($value);
		}
		arsort($final_score[$mpid]);
		/* echo '<pre>';
		//print_r($total_score[$mpid]);
		print_r($final_score[$mpid]);
		echo '</pre>'; */
		return $final_score;
	}
	
	function find_score($final_score,$mpid)
	{
		$i=1;
		foreach($final_score[$mpid] as $key=>$value)
		{
			if($key == get_user_fusion_id())
			{
				$rank = $i;
			}
			$i++;
		}
		return $rank;
	}
	
	function generate_indv_user_summary($final_table_row,$mpid)
	{
		
		foreach($final_table_row[$mpid] as $key=>$valu)
		{
			$last_row_counter = 1;
			foreach($valu as $keyy=>$value)
			{
				foreach($value['data'] as $ke=>$va)
				{
					//echo $ke.'<br>';
					$summary[$mpid][$value['fusion_id']]['fusion_id'] = $value['fusion_id'];
					$kpi_infos = explode(' ## ',$ke);
					
					$kpi_name = $kpi_infos[1];
					$kpi_type = $kpi_infos[2];
					$formula = $kpi_infos[3];
					$sum_product_with = $kpi_infos[4];
					
					if ($kpi_type != 1){
							
						if(!isset($avg_counter[$mpid][$value['fusion_id']][$ke]))
						{
							$avg_counter[$mpid][$value['fusion_id']][$ke] = 0;
						}
						
						if(!isset($summary[$mpid][$value['fusion_id']][$ke]))
						{
							$summary[$mpid][$value['fusion_id']][$ke] = '';
						}
						
						if($formula == 3)
						{
							if($va != '')
							{
								$avg_counter[$mpid][$value['fusion_id']][$ke]++;
							}
							$summary[$mpid][$value['fusion_id']][$ke] = $summary[$mpid][$value['fusion_id']][$ke] + $va;
							if(count($valu) == $last_row_counter)
							{
								if(!isset($avg_counter[$mpid][$value['fusion_id']][$ke]) || $avg_counter[$mpid][$value['fusion_id']][$ke] == 0)
								{
									$summary[$mpid][$value['fusion_id']][$ke] = 0;
								}
								else
								{
									$summary[$mpid][$value['fusion_id']][$ke] = $summary[$mpid][$value['fusion_id']][$ke] / $avg_counter[$mpid][$value['fusion_id']][$ke];
								}
							}
						}
						else if($formula == 5)
						{
							
							$avg_counter[$mpid][$value['fusion_id']][$ke]++;
							//find multiplication key
							foreach($value['data'] as $k=>$v)
							{
							//echo $k.'<br>';
								$kpi_info = explode(' ## ',$k);
								
								if($kpi_info[1] == $sum_product_with)
								{
									$product_with = $v;
									$sum_product_key = $k;
								}
							}
							$summary[$mpid][$value['fusion_id']][$ke] = $summary[$mpid][$value['fusion_id']][$ke] + ($va * $product_with);
							if(count($valu) == $last_row_counter)
							{
								if(!isset($summary[$mpid][$value['fusion_id']][$sum_product_key]) || $summary[$mpid][$value['fusion_id']][$sum_product_key] == 0)
								{
									$summary[$mpid][$value['fusion_id']][$ke] = 0;
								}
								else
								{
									$summary[$mpid][$value['fusion_id']][$ke] = $summary[$mpid][$value['fusion_id']][$ke] / $summary[$mpid][$value['fusion_id']][$sum_product_key];
								}
							}
						}
						else
						{
							$summary[$mpid][$value['fusion_id']][$ke] = $summary[$mpid][$value['fusion_id']][$ke] + $va;
						}
					}else{
						
						$summary[$mpid][$value['fusion_id']][$ke] =  $va;
					}
					
				}
				$last_row_counter++;
			}
		}
		
		return $summary;
	}
	
	function generate_final_table_row($table_row,$mpid)
	{
		foreach($table_row[$mpid] as $key=>$value)
		{
			foreach($value as $ke=>$va)
			{
				$final_table_row[$mpid][$key][$ke]['fusion_id'] = $key;
				$final_table_row[$mpid][$key][$ke]['date'] = $ke;
				$final_table_row[$mpid][$key][$ke]['data'] = $va;
			}
		}
		
		return $final_table_row;
	}
	
	function generate_indiv_date_table_row($pmAllArray,$mpid)
	{
		
		if(!isset($table_row))
		{
			$table_row = array();
		}
							
		foreach($pmAllArray[$mpid.'user'] as $key=>$user_list_array)
		{
			$table_row[$mpid][$user_list_array['fusion_id']] = array();
		}
		foreach($table_row[$mpid] as $key=>$value)
		{
			foreach($pmAllArray[$mpid.'data'][$key.'date'] as $k=>$v)
			{
				$table_row[$mpid][$key][$v['start_date']] = array();
			}
		}
		
		foreach($table_row[$mpid] as $key=>$value)
		{
			foreach($value as $ke=>$va)
			{
				foreach($pmAllArray[$mpid.'kpi'] as $k=>$v)
				{
					$table_row[$mpid][$key][$ke][$v['id'].' ## '.$v['kpi_name'].' ## '.$v['kpi_type'].' ## '.$v['summ_type'].' ## '.$v['summ_formula'].' ## '.$v['weightage']] = '';
				}
			}
		}
		
		foreach($table_row[$mpid] as $key=>$date_array)
		{
			foreach($date_array as $date_array_ke=>$kpi_array)
			{
				foreach($kpi_array as $k=>$v)
				{
					foreach($pmAllArray[$mpid.'data'][$key.'value'][$key.$date_array_ke] as $ke=>$va)
					{
						$array = explode(' ## ',$k);
						$kpi_id = $array[0];
						if($kpi_id == $va['kpi_id'])
						{
							$table_row[$mpid][$key][$date_array_ke][$k] = $va['kpi_value'];
						}
					}
				}
			}
		}
		return $table_row;
	}
	
	function value_calculation($kpi_type,$kpi_value,$return=false)
	{
		if($kpi_value != '')
		{
			$kpi_value = $kpi_value;
			if($kpi_type == 1 ) $kpiDispVal = $kpi_value;
			else if($kpi_type == 7 ) $kpiDispVal = round($kpi_value,2);
			else if($kpi_type == 8 ) $kpiDispVal = sprintf("%1.2f",round(($kpi_value),2));
			else if($kpi_type == 9 ) $kpiDispVal = gmdate("H:i:s", ($kpi_value * 24 * 60 * 60 ));
			else $kpiDispVal = sprintf("%1.2f",round(($kpi_value*100.0),2)) . "%";
		}
		else
		{
				$kpiDispVal = '-';
		}
		return $kpiDispVal;
	}
	
	function get_name_by_f_id($pmAllArray,$mpid,$f_id)
	{
		foreach($pmAllArray[$mpid.'user'] as $key=>$value)
		{
			if($value['fusion_id'] == $f_id)
			{
				$name = $value['fname'].' '.$value['lname'];
			}
		}
		return $name;
	}
	$total = array();
	foreach($pm_design as $drow){
		
		$mpid = $drow['mp_id'];
		$desc = $drow['description'];
		$best_value = 'best_value'.$mpid;
		
?>


<!-- Schedule -->

	<div class="row">
		
		<!-- DataTable -->
		<div class="col-md-12">
				<div class="widget">
					<header class="widget-header">
						
							<?php
							if($report_type == 'Show')
							{
							?>
								<h4 class="widget-title">Performance Metrix of <?php echo $desc; ?>, From <?php echo $sch_date_range; ?></h4>
							<?php
							}
							?>
						
					</header><!-- .widget-header -->
					<hr class="widget-separator">
						
					<div class="widget-body" >
						<div class="table-responsive" >
						<?php
							//echo "<pre>";
							//print_r($pmAllArray);
							//echo "</pre>";
							$table_row = generate_indiv_date_table_row($pmAllArray,$mpid);
						?>
						
						<?php
						//echo '<pre>';
						//print_r($table_row);
						//echo '</pre>';
							$final_table_row = generate_final_table_row($table_row,$mpid);
						//echo '<pre>';
						//print_r($final_table_row);
						//echo '</pre>';
							$summary = generate_indv_user_summary($final_table_row,$mpid);
						//echo '<pre>';
						//print_r($summary);
						//echo '</pre>';
						$final_score = cal_weightage($summary,$mpid);
						$overall_summary = cal_overall_summary($summary,$mpid);
						//print_r($overall_summary);
						//print_r($final_score);
						//$rank = find_score($final_score,$mpid);
						//echo '<pre>';
						//print_r($pmAllArray[$mpid.'kpi']);
						//echo '</pre>';
						?>
						
						<table id="default-datatable" data-plugin="DataTable" class="table table-striped skt-table" cellspacing="0" width="100%">
								<thead>
									<tr class='bg-info'>
										<!--<td>Fusion ID</td>-->
										<?php
										if($mdid_type == 1)
										{
											echo '<td>Rank</td>';
										}
										?>
										<td>Week</td>
										<td>Name</td>
										<td>Fusion ID</td>
										
										<?php
											$print_head = 0;
											foreach($table_row[$mpid] as $key=>$date_value)
											{
												foreach($date_value as $ke=>$value_array)
												{
													if($print_head < 1)
													{
														foreach($value_array as $k=>$v)
														{
															$kpi_name = explode('##',$k);
															
															echo '<td>'.$kpi_name[1].'</td>';
														}
													}
													$print_head++;
												}
											}
										?>
									</tr>
								
								</thead>
									
								<tbody>
									<?php
										$rank = 1;
										foreach($final_score[$mpid] as $k=>$v)
										{
											foreach($summary[$mpid] as $key=>$value)
											{
												$date_array = explode('To',$sch_date_range);
												$d_array = explode('-',$date_array[0]);
												if($k==$key)
												{
													echo '<tr>';
														if($mdid_type == 1)
														{
															echo '<td>'.$rank.'</td>';
														}
														echo '<td colspan="1">'.date('W',strtotime($d_array[2].'-'.$d_array[0].'-'.$d_array[1])).'</td>';
														echo '<td colspan="1">'.get_name_by_f_id($pmAllArray,$mpid,$key).'</td>';
													foreach($value as $ke=>$va)
													{
														
															if($ke !== 'fusion_id')
															{
																$kpi_type = explode('##',$ke);
																echo '<td>'.value_calculation($kpi_type[2],$va,true).'</td>';
															}
															else
															{
																echo '<td>'.$va.'</td>';
															}
														
													}
													echo '</tr>';
													$rank++;
												}
											}
										}
									?>
									<?php
										
										if($mdid_type == 1)
										{	echo '<tr>';
												echo '<td colspan="4"></td>';
											foreach($overall_summary[$mpid] as $key=>$value)
											{
												$kpi_info = explode(' ## ',$key);
												echo '<td>'.value_calculation($kpi_info[2],$value).'</td>';
											}
											echo '<tr>';
										}
										
									?>
								</tbody>
								
							</table>
						</div>
					</div><!-- .widget-body -->
				</div><!-- .widget -->
			</div>
			<!-- END DataTable -->	
						
		</div><!-- .row -->
		


<?php
	}
?>
		
		
</section>
	


	
</div><!-- .wrap -->





