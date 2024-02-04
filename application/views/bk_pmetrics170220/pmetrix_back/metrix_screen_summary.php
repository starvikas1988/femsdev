
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
	if(get_role_dir()!="agent"){
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
					<option value='ALL'>ALL</option>
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
						
					<?php endforeach; ?>
															
				</select>
			</div>
		</div>
	
		<div class="col-md-2" id="process_div" >
			<div class="form-group">
			<label for="process_id">Select a process</label>
			<select class="form-control" name="process_id" id="fprocess_id" >
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
			<div class="form-group">
			<label for="sch_range">Select a Metrix Week</label>
			<select class="form-control" name="sch_range" id="sch_range" >
				<?php foreach($all_sch_date_range as $shDtRange): ?>
					<?php
						$sCss="";
						if($shDtRange['shrange']==$sch_date_range) $sCss="selected";
					?>
					<option value="<?php echo $shDtRange['start_date']."#".$shDtRange['end_date']; ?>" <?php echo $sCss;?> ><?php echo $shDtRange['shrange']; ?></option>
					
				<?php endforeach; ?>
														
			</select>
			</div>
		<!-- .form-group -->
		</div>

		
		<div class="col-md-2">
				<input type="submit" class="btn btn-primary btn-md" style="margin-top:24px;" id='showReports' name='showReports' value="Show">
				<input type="submit" class="btn btn-primary btn-md" style="margin-top:24px;width: 94px;" id='showsummary' name='showReports' value="Summary">
		</div>
		</form>
		
</div><!-- .row -->



</div>
</div>
</div>
</div><!-- .row -->


<?php 
	}
	foreach($pm_design as $drow){
		
		$mpid = $drow['mp_id'];
		$desc = $drow['description'];
		
		
?>


<!-- Schedule -->

	<div class="row">
		
		<!-- DataTable -->
		<div class="col-md-12">
				<div class="widget">
					<header class="widget-header">
						
					<h4 class="widget-title">Performance Metrix of <?php echo $desc; ?>, For <?php echo date('M') ?></h4>
						
					</header><!-- .widget-header -->
					<hr class="widget-separator">
						
					<div class="widget-body" >
						<div class="table-responsive" >
						<?php
						?>
						<table id="default-datatable" data-plugin="DataTable" class="table table-striped skt-table" cellspacing="0" width="100%">
								<thead>
									<tr class='bg-info'>
									
										<th >SL</th>
										<th >Fusion ID</th> 
										<th >Agent Name</th>
										<th >Process</th>
										<th >Designation</th>
										<?php 
										
										$kpiHeaderArr = $pmAllArray[$mpid."kpi"];
										$kpiSummArry = array();
										$kpiTypeArry = array();
										
										foreach($kpiHeaderArr as $hrow){
											
											$hid = $hrow['id'];
											
											$kpi_name = $hrow['kpi_name'];
											$kpi_type = $hrow['kpi_type'];
											
											$summ_type = $hrow['summ_type'];
											$summ_formula = $hrow['summ_formula'];
											
											$kpiSummArry[$hid] = $summ_type."##".$summ_formula.'##'.$kpi_name;
											$kpiTypeArry[$hid] = $kpi_type;
											
											echo "<th >$kpi_name</th>";
																						
										}
										?>
								</tr>
								
								</thead>
									
								<tbody>
								
								<?php
									$i=1;
									$pDate=0;
									$week_num="-";
									//echo '<pre>';
									//print_r($pmAllArray);
									//echo '</pre>';
									$userArray[$mpid]=$pmAllArray[$mpid."user"];
									
									$mpValueArray=$pmAllArray[$mpid."data"];
									
									//print_r($userArray);
									foreach($userArray[$mpid] as $user){
										
									$fusion_id=$user['fusion_id'];
									$fname= $user['fname'];
									$lname = $user['lname'];
									$process_name= $user['process_name'];
									$role_name= $user['role_name'];
									
									$user_info[$user['id']]['fusion_id'] = $fusion_id;
									$user_info[$user['id']]['name'] = $fname.' '.$lname;
									$user_info[$user['id']]['process_name'] = $process_name;
									$user_info[$user['id']]['role_name'] = $role_name;
									
									$userDateArray = $mpValueArray[$fusion_id."date"];
									
									$userValueArray = $mpValueArray[$fusion_id."value"];
									//echo 'fdfd'.count($userValueArray);
									
									foreach($userDateArray as $dtRow){
										
										$start_date = $dtRow['start_date'];
										//echo 'fdfd'.$start_date.'<br>';
										
										//echo '<pre>';
										//print_r($userValueArray[$fusion_id.$start_date]);
										//echo '</pre>';
										$userDataArray[$mpid][$fusion_id.$start_date] = $userValueArray[$fusion_id.$start_date];
										$week_num=date("W", strtotime($start_date));
										
										
									
									}
									
								?>
								<?php } ?>
								<?php
									foreach($userDataArray[$mpid] as $key=>$value)
									{
										foreach($value as $k=>$v)
										{
											//print_r($kpiSummArry[$mpid]);
											/* if(!isset($kpiSummArry[$mpid]))
											{
												print_r($kpiSummArry[$mpid]);
											} */
											$summDtls=$kpiSummArry[$v['kpi_id']];
											$kpi_type=$kpiTypeArry[$v['kpi_id']];
											
											$summDtlsArray = explode("##",$summDtls);
										
											if($kpi_type == 1 ) $kpiDispVal = $v['kpi_value'];
											else if($kpi_type == 7 ) $kpiDispVal = round($v['kpi_value']);
											else if($kpi_type == 8 ) $kpiDispVal = sprintf("%1.2f",round(($v['kpi_value']),2));
											else $kpiDispVal = sprintf("%1.2f",round(($v['kpi_value']*100.0),2));
											
											//echo '<td>'.$kpiDispVal.'</td>';
											
											if($kpiDispVal == '') $kpiDispVal = 0;
											
											$total[$v['user_id']][$summDtlsArray[2]]['value'][] = $kpiDispVal;
											$total[$v['user_id']][$summDtlsArray[2]]['sum_type'] = $summDtlsArray[0];
											$total[$v['user_id']][$summDtlsArray[2]]['formula'] = $summDtlsArray[1];
											$total[$v['user_id']][$summDtlsArray[2]]['kpi_type'] = $kpi_type;
											/* if(count($userValueArray) == ($i-1))
											{
												$total[$v['user_id'].$summDtlsArray[2]]['summary'] = array_sum($total[$v['user_id'].$summDtlsArray[2]]);
												$total[$v['user_id'].$summDtlsArray[2]]['type'] = $kpi_type;
											} */
										}
										
										foreach($total as $total_key=>$ind_user_array)
										{
											foreach($ind_user_array as $key=>$kpi_array_value)
											{
												//$removed_blank_array = array_filter($kpi_array_value['value']);
												if($kpi_array_value['sum_type'] == 3)
												{
													if($kpi_array_value['kpi_type'] == 1 ) $kpiDispVal = array_sum($kpi_array_value['value'])/count($kpi_array_value['value']);
													else if($kpi_array_value['kpi_type'] == 7 ) $kpiDispVal = round(array_sum($kpi_array_value['value'])/count($kpi_array_value['value']));
													else if($kpi_array_value['kpi_type'] == 8 ) $kpiDispVal = sprintf("%1.2f",round((array_sum($kpi_array_value['value'])/count($kpi_array_value['value'])),2));
													else $kpiDispVal = sprintf("%1.2f",round((array_sum($kpi_array_value['value'])/count($kpi_array_value['value'])),2));
											
													$ind_user_summary[$total_key][$key]['value'] = $kpiDispVal;
													$ind_user_summary[$total_key][$key]['sum_type'] = $kpi_array_value['sum_type'];
													$ind_user_summary[$total_key][$key]['formula'] = $kpi_array_value['formula'];
													$ind_user_summary[$total_key][$key]['kpi_type'] = $kpi_array_value['kpi_type'];
												}
												else if($kpi_array_value['sum_type'] == 5)
												{
													$sum = 0;
													$formula_sum = 0;
													foreach($total[$total_key][$kpi_array_value['formula']]['value'] as $k=>$v)
													{
														$sum = $sum + $v*$kpi_array_value['value'][$k];
														$formula_sum = $formula_sum + $v;
													}
													
													if(($formula_sum) != 0)
													{
														if($kpi_array_value['kpi_type'] == 1 ) $kpiDispVal = $sum/$formula_sum;
														else if($kpi_array_value['kpi_type'] == 7 ) $kpiDispVal = round($sum/$formula_sum);
														else if($kpi_array_value['kpi_type'] == 8 ) $kpiDispVal = sprintf("%1.2f",round((($sum/$formula_sum)),2));
														else $kpiDispVal = sprintf("%1.2f",round((($sum/$formula_sum)),2));
													}
													else
													{
														if($kpi_array_value['kpi_type'] == 1 ) $kpiDispVal = 0;
														else if($kpi_array_value['kpi_type'] == 7 ) $kpiDispVal = round(0);
														else if($kpi_array_value['kpi_type'] == 8 ) $kpiDispVal = sprintf("%1.2f",round(((0)),2));
														else $kpiDispVal = sprintf("%1.2f",round(((0)),2));
													}
											
													$ind_user_summary[$total_key][$key]['value'] = $kpiDispVal;
													$ind_user_summary[$total_key][$key]['sum_type'] = $kpi_array_value['sum_type'];
													$ind_user_summary[$total_key][$key]['formula'] = $kpi_array_value['formula'];
													$ind_user_summary[$total_key][$key]['kpi_type'] = $kpi_array_value['kpi_type'];
												}
												else
												{
													$ind_user_summary[$total_key][$key]['value'] = array_sum($kpi_array_value['value']);
													$ind_user_summary[$total_key][$key]['sum_type'] = $kpi_array_value['sum_type'];
													$ind_user_summary[$total_key][$key]['formula'] = $kpi_array_value['formula'];
													$ind_user_summary[$total_key][$key]['kpi_type'] = $kpi_array_value['kpi_type'];
												}
											}
										}
									}
									//echo '<pre>';
									//print_r($ind_user_summary);
									$summary_start = 1;
									$sum = array();
									$formula_sum = array();
									foreach($ind_user_summary as $total_key=>$ind_user_array)
									{
										foreach($ind_user_array as $key=>$kpi_array_value)
										{
											//$removed_blank_array = array_filter($kpi_array_value['value']);
											if(!isset($overall_summary[$key]['value']))
											{
												$overall_summary[$key]['value'] = 0;
											}
											
											if($kpi_array_value['sum_type'] == 3)
											{
												$avg[$key][] = $kpi_array_value['value'];
												
												if(count($ind_user_summary) == $summary_start)
												{
													$overall_summary[$key]['value'] = array_sum($avg[$key])/count($avg[$key]);
												}
												
												$overall_summary[$key]['sum_type'] = $kpi_array_value['sum_type'];
												$overall_summary[$key]['formula'] = $kpi_array_value['formula'];
												$overall_summary[$key]['kpi_type'] = $kpi_array_value['kpi_type'];
											}
											else if($kpi_array_value['sum_type'] == 5)
											{
												
													//$sum = $sum + $ind_user_array[$total_key][$kpi_array_value['formula']]['value']*$kpi_array_value['value'];
													//$formula_sum = $formula_sum + $ind_user_array[$total_key][$kpi_array_value['formula']]['value'];
												
												if(!isset($sum[$key]))
												{
													$sum[$key] = 0;
												}
												if(!isset($formula_sum[$key]))
												{
													$formula_sum[$key] = 0;
												}
												
												$sum[$key] = $sum[$key] + $ind_user_array[$kpi_array_value['formula']]['value'] * $kpi_array_value['value'];
												
												//echo $key.'*'.$kpi_array_value['formula'].'---'.$ind_user_array[$kpi_array_value['formula']]['value'] .'*'. $kpi_array_value['value'].'-'.$sum[$key].'<br>';
												
												$formula_sum[$key] = $formula_sum[$key] + $ind_user_array[$kpi_array_value['formula']]['value'];
												
												if($formula_sum != 0)
												{
													$overall_summary[$key]['value'] = $sum[$key]/$formula_sum[$key];
													$overall_summary[$key]['sum_type'] = $kpi_array_value['sum_type'];
													$overall_summary[$key]['formula'] = $kpi_array_value['formula'];
													$overall_summary[$key]['kpi_type'] = $kpi_array_value['kpi_type'];
												}
												else
												{
													$overall_summary[$key]['value'] = 0;
													$overall_summary[$key]['sum_type'] = $kpi_array_value['sum_type'];
													$overall_summary[$key]['formula'] = $kpi_array_value['formula'];
													$overall_summary[$key]['kpi_type'] = $kpi_array_value['kpi_type'];
												}
											}
											else
											{
												$overall_summary[$key]['value'] = $overall_summary[$key]['value'] + $kpi_array_value['value'];
												$overall_summary[$key]['sum_type'] = $kpi_array_value['sum_type'];
												$overall_summary[$key]['formula'] = $kpi_array_value['formula'];
												$overall_summary[$key]['kpi_type'] = $kpi_array_value['kpi_type'];
											}
										}
										$summary_start++;
									}
								
									$sl_no = 1;
									foreach($ind_user_summary as $key=>$value)
									{
										echo '<tr>';
											echo '<td>';
												echo $sl_no;
											echo '</td>';
											echo '<td>';
												echo $user_info[$key]['fusion_id'];
											echo '</td>';
											echo '<td>';
												echo $user_info[$key]['name'];
											echo '</td>';
											echo '<td>';
												echo $user_info[$key]['process_name'];
											echo '</td>';
											echo '<td>';
												echo $user_info[$key]['role_name'];
											echo '</td>';
										foreach($value as $k=>$v)
										{
											
											
											if($v['kpi_type'] == 1 ) $value = $v['value'];
											else if($v['kpi_type'] == 7 ) $value = round($v['value']);
											else if($v['kpi_type'] == 8 ) $value = sprintf("%1.2f",round(($v['value']),2));
											else $value = sprintf("%1.2f",round(($v['value']),2)) . "%";
											
												
											echo '<td>';
												echo $value;
											echo '</td>';
										}
										echo '</tr>';
										$sl_no++;
									}
									//calculate summary of a particular user
									
								//echo '<pre>';
									//print_r($overall_summary);
									//echo array_sum($total['Chats']);
								?>
									<tr id="last_row">
										<td colspan="5" style="text-align:center;">Summary</td>
										<?php
											foreach($overall_summary as $key=>$value_array){
												
												if($value_array['kpi_type'] == 1 ) $value = $value_array['value'];
												else if($value_array['kpi_type'] == 7 ) $value = round($value_array['value']);
												else if($value_array['kpi_type'] == 8 ) $value = sprintf("%1.2f",round(($value_array['value']),2));
												else $value = sprintf("%1.2f",round(($value_array['value']),2)) . "%";
												
												echo '<td>';
													echo $value;
												echo '</td>';
											}
										?>
										
									</tr>
								</tbody>
								
							</table>
							<?php
							//echo '<pre>';
							//print_r($userDataArray);
							?>
						</div>
					</div><!-- .widget-body -->
				</div><!-- .widget -->
			</div>
			<!-- END DataTable -->	
						
		</div><!-- .row -->
		


<?php
	$user_info = array();
	$total = array();
		$ind_user_summary = array();
		$overall_summary = array();
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





