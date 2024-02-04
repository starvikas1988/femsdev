
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
	#agent_container,#tl_container
	{
		display:none;
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
	
		<div class="col-md-3" >
			
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
		
		
		<div class='col-md-2' >
			<div class="form-group" id="week_range_container">
				
				<label for="sch_range">Select Start Date</label>
				<input type="text" class="form-control" id="from" name="start_date" value="<?php echo $start_date; ?>" required>
				
			</div>
		<!-- .form-group -->
		</div>
		<div class='col-md-2' >
			<div class="form-group" id="week_range_container">
				
				<label for="sch_range">Select Start Date</label>
				<input type="text" class="form-control" id="to" name="end_date" value="<?php echo $end_date; ?>" required>
				
			</div>
		<!-- .form-group -->
		</div>
		<div class='col-md-2' >
			<div class="form-group">
				
				<label for="search_type">Search Type</label>
				<select name="search_type" id="search_type" class="form-control">
					<option value="">--Select a Type--</option>
					<?php
						if(isset($search_type))
						{
							if($search_type == 2)
							{
								echo '<option value="1">Agent</option>';
								echo '<option value="2" selected>TL</option>';
							}
							else if($search_type == 1)
							{
								echo '<option value="1" selected>Agent</option>';
								echo '<option value="2" >TL</option>';
							}
						}
						else
						{
							echo '<option value="1">Agent</option>';
							echo '<option value="2" >TL</option>';
						}
					?>
				</select>
				
			</div>
		<!-- .form-group -->
		</div>
		<?php
			if($fusion_id != null)
			{
				echo "<div class='col-md-2'  id='agent_container' style='display:block;'>";
			}
			else
			{
				echo "<div class='col-md-2' id='agent_container' >";
			}
		?>
		
			<div class="form-group">
				<label for="sch_range">Type Agent Fusion ID</label>
				<input type="text" class="form-control" id="agent_fusion_id" name="agent_fusion_id" value="<?php echo $fusion_id; ?>" required>
			</div>
		<!-- .form-group -->
		</div>
		<?php
			if($tl_fusion_id != null)
			{
				echo "<div class='col-md-2'  id='tl_container' style='display:block;'>";
			}
			else
			{
				echo "<div class='col-md-2' id='tl_container' >";
			}
		?>
			<div class="form-group">
				<label for="sch_range">Select a TL</label>
				<select name="tl_fusion_id" id="tl_fusion_id" class="form-control">
					
					<option value="">--Select a TL--</option>
					<?php
						foreach($tl_list as $key=>$value)
						{
							if($tl_fusion_id == $value['id'])
							{
								echo '<option value="'.$value['id'].'" selected>'.$value['tl_name'].'</option>';
							}
							else
							{
								echo '<option value="'.$value['id'].'">'.$value['tl_name'].'</option>';
							}
						}
					?>
				</select>
			</div>
		<!-- .form-group -->
		</div>

		
		<div class="col-md-2">
				<input type="submit" class="btn btn-primary btn-md" style="margin-top:24px;" id='showReports' name='showReports' value="Show">
				<?php
					if($mdid_type == 1)
					{
						//echo '<input type="submit" class="btn btn-primary btn-md" style="margin-top:24px;width: 94px;" id="showsummary" name="showReports" value="Summary">';
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
			if($key == $fusion_id)
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
			//else if($kpi_type == 9 ) $kpiDispVal = gmdate("H:i:s", ($kpi_value * 24 * 60 * 60 ));
			
			else if($kpi_type == 9 )
			{
				$the_value = $kpi_value;
				$total = $the_value * 24; //multiply by the 24 hours
				/* $hours = floor($total); //Gets the natural number part
				$minute_fraction = $total - $hours; //Now has only the decimal part
				$minutes = $minute_fraction * 60; //Get the number of minutes
				$display = $hours . "." . round($minutes); */
				$kpiDispVal = $total;
			}
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
						<h4 style="margin-top:5px;" class="widget-title">Performance Metrix of <?php echo $fusion_id; ?>
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
							//echo '<pre>';
							//print_r($pmAllArray[$mpid.'kpi']);
							//echo '</pre>';
							?>
							</h4>
												
					</header><!-- .widget-header -->
					<hr class="widget-separator">
						
					<div class="widget-body" >
						<div class="table-responsive" >
						
						
						
						
						
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
									foreach($final_table_row[$mpid] as $key=>$value)
									{
										if($key == $fusion_id)
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
															echo '<td>'.value_calculation($kpi_type[2],$v,true).'</td>';
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
										if($key == $fusion_id)
										{
											echo '<tr>';
												echo '<td colspan="1">Summary</td>';
											foreach($value as $ke=>$va)
											{
												if($ke !== 'fusion_id')
												{
													$kpi_type = explode('##',$ke);
													echo '<td>'.value_calculation($kpi_type[2],$va,true).'</td>';
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





