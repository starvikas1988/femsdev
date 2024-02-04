
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
					$formula = $kpi_infos[3];
					$sum_product_with = $kpi_infos[4];
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
	
	function generate_indiv_date_table_row($pmAllArray,$mpid,$mdid_type)
	{
		$table_row = array();
							
		foreach($pmAllArray[$mpid.'user'] as $key=>$user_list_array)
		{
			$table_row[$mpid][$user_list_array['fusion_id']] = array();
		}
		foreach($table_row[$mpid] as $key=>$value)
		{
			foreach($pmAllArray[$mpid.'data'][$key.'date'] as $k=>$v)
			{
				
				if($mdid_type > 1) $table_row[$mpid][$key][$v['start_date'].' To '.$v['end_date']] = array();
				else $table_row[$mpid][$key][$v['start_date']] = array();
			}
		}
		
		foreach($table_row[$mpid] as $key=>$value)
		{
			foreach($value as $ke=>$va)
			{
				
				//$table_row[$mpid][$key][$ke]['end_date'] = '';
				
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
					$date_array = explode(' To ',$date_array_ke);
					
					foreach($pmAllArray[$mpid.'data'][$key.'value'][$key.$date_array[0]] as $ke=>$va)
					{
						$array = explode(' ## ',$k);
						$kpi_id = $array[0];
						if($kpi_id == $va['kpi_id'])
						{
							$table_row[$mpid][$key][$date_array_ke][$k] = $va['kpi_value'];
						}
						
						//if($kpi_id == $va['end_date']) 
							//$table_row[$mpid][$key][$date_array_ke]['end_date'] = $va['end_date'];
						
					}
				}
			}
		}
		//echo 'echo fdf d<br>';
		//print_r($table_row);
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
	$total = array();
	/* echo '<pre>';
	print_r($all_data);
	echo '</pre>'; */
	/* foreach($all_data as $key=>$value)
	{
		if(!isset($best_values[$value['kpi_name'].' ## '.$value['kpi_type']]))
		{
			$best_values[$value['kpi_name'].' ## '.$value['kpi_type']] = 0;
		}
		if($best_values[$value['kpi_name'].' ## '.$value['kpi_type']] < $value['kpi_value'])
		{
			$best_values[$value['kpi_name'].' ## '.$value['kpi_type']] = $value['kpi_value'];
		}
	} */
	function col_hide($pmAllArray,$mpid)
	{
		$hide_col_array =array();
		foreach($pmAllArray[$mpid.'kpi'] as $key=>$value)
		{
			$hide_col_array[$value['kpi_name']]['agent_view']= $value['agent_view'];
			$hide_col_array[$value['kpi_name']]['tl_view']= $value['tl_view'];
		}
		return $hide_col_array;
	}
	foreach($pm_design as $drow){
		
		$mpid = $drow['mp_id'];
		$desc = $drow['description'];
		//echo '<pre>';
		$best_value = 'best_value'.$mpid;
			//print_r($$best_value);
		//echo '</pre>';
		
?>


<!-- Schedule -->

	<div class="row">
		
		<!-- DataTable -->
		<div class="col-md-12">
				<div class="widget">
					<header class="widget-header">
						<h4 style="margin-top:5px;" class="widget-title">Performance Metrix of <table id="default-datatable" data-plugin="DataTable" class="table table-striped skt-table" cellspacing="0" style="width:50%; text-align:center; font-weight:bold">
							<thead>
								<tr class='bg-info'>
									<th>Fusion ID</th> 
									<th>Agent Name</th>
									<th>Client</th>
									<th>Process</th>
									<th>Rank</th>
								</tr>
							</thead>
							<tbody>
							<?php
								//echo "<pre>";
								//print_r($pmAllArray);
								//echo "</pre>";
								$table_row = generate_indiv_date_table_row($pmAllArray,$mpid,$mdid_type);
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
							//print_r($final_score);
							//print_r($final_score);
							$rank = find_score($final_score,$mpid);
							$hide_col = col_hide($pmAllArray,$mpid);
							//echo '<pre>';
							//print_r($pmAllArray[$mpid.'kpi']);
							//echo '</pre>';
							?>
							
							<?php
								$userArray1=$pmAllArray[$mpid."user"];
								foreach($userArray1 as $row): 
								if($row['fusion_id'] == get_user_fusion_id())
								{
							?>
								
								<tr>
									<td><?php echo $row['fusion_id']; ?></td>
									<td><?php echo $row['fname']." ".$row['lname']; ?></td>
									<td><?php echo $row['client_name']; ?></td>
									<td><?php echo $row['process_name']; ?></td>
									<td><?php echo $rank; ?></td>
								</tr>
								<?php
								}
								?>
							<?php endforeach; ?>
							</tbody>
						</table></h4>
												
					</header><!-- .widget-header -->
					<hr class="widget-separator">
						
					<div class="widget-body" >
						<div class="table-responsive" >
						
						
						
						
						<table id="default-datatable" data-plugin="DataTable" class="table table-striped skt-table" cellspacing="0" width="100%">
							<thead>
								
								<tr class='bg-info'>
									<td></td>
									<?php
										foreach($pmAllArray[$mpid.'kpi'] as $key=>$value)
										{
											if($hide_col[trim($value['kpi_name'])]['tl_view'] == 1)
											{
												echo '<td>'.$value['kpi_name'].'</td>';
											}
										}
									?>
								</tr>
							</thead>
							<tbody>
								<tr>
									<?php
										echo '<td>Your Targets</td>';
										foreach($pmAllArray[$mpid.'kpi'] as $key=>$value)
										{
											if($hide_col[trim($value['kpi_name'])]['tl_view'] == 1)
											{
												echo '<td>'.value_calculation($value['kpi_type'],$value['target']).'</td>';
											}
										}
									?>
								</tr>
							</tbody>
						</table>
						<!--best performance-->
						<table id="default-datatable" data-plugin="DataTable" class="table table-striped skt-table" cellspacing="0" width="100%">
							<thead>
								
								<tr class='bg-info'>
									<td></td>
									<?php
										foreach($$best_value as $key=>$value)
										{
											if($hide_col[trim($value['kpi_name'])]['tl_view'] == 1)
											{
												echo '<td>'.$value['kpi_name'].'</td>';
											}
										}
									?>
								</tr>
							</thead>
							<tbody>
								<tr>
									<?php
										echo '<td>Best Scores</td>';
										foreach($$best_value as $key=>$value)
										{
											
											if($value['weightage_comp'] == 1)
											{
												//echo $value['max_value'].'<br>';
												if($value['max_value'] < 0)
												{
													$max_value = '-';
													echo '<td>'.$max_value.'</td>';
												}
												else
												{
													$max_value = $value['max_value'];
													
													echo '<td>'.value_calculation($value['kpi_type'],$max_value).'</td>';
													
												}
												
											}
											else
											{
												if($value['min_value'] == '99999.00')
												{
													$min_value = '-';
													
													echo '<td>'.$min_value.'</td>';
													
												}
												else
												{
													$min_value = $value['min_value'];
													
													echo '<td>'.value_calculation($value['kpi_type'],$min_value).'</td>';
													
												}
												
											}
										}
									?>
								</tr>
							</tbody>
						</table>
						<table id="default-datatable" data-plugin="DataTable" class="table table-striped skt-table" cellspacing="0" width="100%">
							<thead>
								<tr class='bg-info'>
									<!--<td>Fusion ID</td>-->
									<td>Date</td>
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
														if($hide_col[trim($kpi_name[1])]['tl_view'] == 1)
														{
															echo '<td>'.$kpi_name[1].'</td>';
														}
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
									foreach($final_table_row[$mpid] as $key=>$value)
									{
										if($key == get_user_fusion_id())
										{
											foreach($value as $ke=>$valu)
											{
												echo '<tr>';
												foreach($valu as $k=>$va)
												{
													
													if(!is_array($va))
													{
														if($k != 'fusion_id')
														{
															echo '<td>'.$va.'</td>';
														}
													}
													else
													{
														foreach($va as $k=>$v)
														{
															$kpi_type = explode('##',$k);
															if($hide_col[trim($kpi_type[1])]['tl_view'] == 1)
															{
																echo '<td>'.value_calculation($kpi_type[2],$v,true).'</td>';
															}
														}
													}
													
												}
												echo '</tr>';
											}
										}
									}
								?>
								<?php
									
									foreach($summary[$mpid] as $key=>$value)
									{
										if($key == get_user_fusion_id())
										{
											echo '<tr>';
												echo '<td colspan="1">Summary</td>';
											foreach($value as $ke=>$va)
											{
												if($ke !== 'fusion_id')
												{
													$kpi_type = explode('##',$ke);
													if($hide_col[trim($kpi_type[1])]['tl_view'] == 1)
													{
														echo '<td>'.value_calculation($kpi_type[2],$va,true).'</td>';
													}
												}
											}
											echo '</tr>';
										}
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
	
	
<div class="modal fade" id="sktShModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
	 
	  
	<form class="frmEditSchedule" data-toggle="validator" onsubmit="return false" method='POST'>
		
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Update Schedule</h4>
      </div>
      <div class="modal-body">
								
			<input type="hidden" class="form-control" id="shid" name="shid" required>
			<input type="hidden" class="form-control" id="user_id" name="user_id" required>
			
			<div class="row">
				<div class="col-md-6">
				<div class="form-group">
					
					<table class='inputTable'>
						<tr>
							<td>Name</td> 
							<td>OM-ID</td>
						</tr>
						<tr>
							<td>
								<input type="text" class="form-control" id="agent_name" name="agent_name" placeholder="" required readonly>
							</td> 
							<td>
								<input type="text" class="form-control" id="omuid" name="omuid" placeholder="" required readonly>
							</td>
						</tr>
					</table>
					
				</div>
				</div>
				<div class="col-md-6">
				<div class="form-group">
					
					<table>
						<tr>
							<td>Strat Date</td> 
							<td>End Date</td>
						</tr>
						<tr>
							<td>
								<input type="text" class="form-control" id="start_date" name="start_date" placeholder="" required readonly>
							</td> 
							<td>
								<input type="text" class="form-control" id="end_date" name="end_date" placeholder="" required readonly>
							</td>
						</tr>
					</table>
					
				</div>
				</div>
			</div>
						
			<div class="row">
				<div class="col-md-6">
				<div class="form-group">
					<label for="name">Monday</label>
					<table class='inputTable'>
						<tr>
							<td>IN</td> 
							<td>OUT</td>
						</tr>
						<tr>
							<td>
								<input type="text" class="form-control" id="mon_in" name="mon_in" placeholder="IN" required>
							</td> 
							<td>
								<input type="text" class="form-control" id="mon_out" name="mon_out" placeholder="OUT" required>
							</td>
						</tr>
					</table>
					
				</div>
				</div>
				<div class="col-md-6">
				<div class="form-group">
					<label for="name">Tuesday</label>
					<table>
						<tr>
							<td>IN</td> 
							<td>OUT</td>
						</tr>
						<tr>
							<td>
								<input type="text" class="form-control" id="tue_in" name="tue_in" placeholder="IN" required>
							</td> 
							<td>
								<input type="text" class="form-control" id="tue_out" name="tue_out" placeholder="OUT" required>
							</td>
						</tr>
					</table>
					
				</div>
				</div>
			</div>
			
			<div class="row">
				<div class="col-md-6">
				<div class="form-group">
					<label for="name">Wednesday</label>
					<table class='inputTable'>
						<tr>
							<td>IN</td> 
							<td>OUT</td>
						</tr>
						<tr>
							<td>
								<input type="text" class="form-control" id="wed_in" name="wed_in" placeholder="IN" required>
							</td> 
							<td>
								<input type="text" class="form-control" id="wed_out" name="wed_out" placeholder="OUT" required>
							</td>
						</tr>
					</table>
					
				</div>
				</div>
				<div class="col-md-6">
				<div class="form-group">
					<label for="name">Thursday</label>
					<table>
						<tr>
							<td>IN</td> 
							<td>OUT</td>
						</tr>
						<tr>
							<td>
								<input type="text" class="form-control" id="thu_in" name="thu_in" placeholder="IN" required>
							</td> 
							<td>
								<input type="text" class="form-control" id="thu_out" name="thu_out" placeholder="OUT" required>
							</td>
						</tr>
					</table>
					
				</div>
				</div>
			</div>
			
			<div class="row">
				<div class="col-md-6">
				<div class="form-group">
					<label for="name">Friday</label>
					<table class='inputTable'>
						<tr>
							<td>IN</td> 
							<td>OUT</td>
						</tr>
						<tr>
							<td>
								<input type="text" class="form-control" id="fri_in" name="fri_in" placeholder="IN" required>
							</td> 
							<td>
								<input type="text" class="form-control" id="fri_out" name="fri_out" placeholder="OUT" required>
							</td>
						</tr>
					</table>
					
				</div>
				</div>
				<div class="col-md-6">
				<div class="form-group">
					<label for="name">Saturday</label>
					<table>
						<tr>
							<td>IN</td> 
							<td>OUT</td>
						</tr>
						<tr>
							<td>
								<input type="text" class="form-control" id="sat_in" name="sat_in" placeholder="IN" required>
							</td> 
							<td>
								<input type="text" class="form-control" id="sat_out" name="sat_out" placeholder="OUT" required>
							</td>
						</tr>
					</table>
					
				</div>
				</div>
			</div>
			
			<div class="row">
				<div class="col-md-6">
				<div class="form-group">
					<label for="name">Sunday</label>
					<table class='inputTable'>
						<tr>
							<td>IN</td> 
							<td>OUT</td>
						</tr>
						<tr>
							<td>
								<input type="text" class="form-control" id="sun_in" name="sun_in" placeholder="IN" required>
							</td> 
							<td>
								<input type="text" class="form-control" id="sun_out" name="sun_out" placeholder="OUT" required>
							</td>
						</tr>
					</table>
					
				</div>
				</div>
				
				<div class="col-md-6">
				
				
				</div>
			</div>
			
			
			
	
	
      </div>
	  
	   
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" id='updateSchedule' class="btn btn-primary">Save changes</button>
      </div>
	  
	 </form>
	  
    </div>
  </div>
</div>


	
</div><!-- .wrap -->





