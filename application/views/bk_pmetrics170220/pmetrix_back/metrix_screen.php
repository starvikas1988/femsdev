
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
	$total = array();
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
						
							<?php
							if($report_type == 'Show')
							{
							?>
								<h4 class="widget-title">Performance Metrix of <?php echo $desc; ?>, From <?php echo $sch_date_range; ?></h4>
							<?php
							}
							else
							{
							?>
								<h4 class="widget-title">Performance Metrix of <?php echo $desc; ?>, For <?php echo date('M') ?></h4>
							<?php
							}
							?>
						
					</header><!-- .widget-header -->
					<hr class="widget-separator">
						
					<div class="widget-body" >
						<div class="table-responsive" >
						<?php
						?>
						<table id="default-datatable" data-plugin="DataTable" class="table table-striped skt-table" cellspacing="0" width="100%">
								<thead>
									<tr class='bg-info'>
									
										<th ><?php echo $report_type; ?></th>
										<th >WEEK</th> 
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
									
									$userArray=$pmAllArray[$mpid."user"];
									
									$mpValueArray=$pmAllArray[$mpid."data"];
									
									foreach($userArray as $user){
										
									$fusion_id=$user['fusion_id'];
									$fname= $user['fname'];
									$lname = $user['lname'];
									$process_name= $user['process_name'];
									$role_name= $user['role_name'];
									
									$userDateArray = $mpValueArray[$fusion_id."date"];
									
									$userValueArray = $mpValueArray[$fusion_id."value"];
									//echo 'fdfd'.count($userValueArray);
									
									foreach($userDateArray as $dtRow){
										
										$start_date = $dtRow['start_date'];
										
										$userDataArray = $userValueArray[$fusion_id.$start_date];
										$week_num=date("W", strtotime($start_date));
									}
									
								?>
									
									<tr id="value_start">
										
										<td><?php echo $i++; ?></td>
										<td><?php echo $week_num; ?></td>
										
										<td><?php echo $user['fusion_id']; ?></td>
										<td><?php echo $user['fname'] . " ". $user['lname']; ?></td>
										<td><?php echo $user['process_name']; ?></td>
										<td><?php echo $user['role_name']; ?></td>
										
										<?php
										//echo '<pre>';
										//print_r($userDataArray);
										//count($userDataArray);
										
											foreach($userDataArray as $udrow){
											
												$kpi_id = $udrow['kpi_id'];
												$kpi_value = $udrow['kpi_value'];
												
												$summDtls=$kpiSummArry[$kpi_id];
												
												
												
												$kpi_type=$kpiTypeArry[$kpi_id];
												
												$summDtlsArray = explode("##",$summDtls);
												
												
												$kpiDispVal="";
												
												if($kpi_value != ""){
													if($kpi_type == 1 ) $kpiDispVal = $kpi_value;
													else if($kpi_type == 7 ) $kpiDispVal = round($kpi_value);
													else if($kpi_type == 8 ) $kpiDispVal = sprintf("%1.2f",round(($kpi_value),2));
													else $kpiDispVal = sprintf("%1.2f",round(($kpi_value*100.0),2)) . "%";
												}
												
												if(!isset($total[$mpid][$summDtlsArray[2]][$i]))
												{
													$total[$mpid][$summDtlsArray[2]][$i] = '';
												}
												
												if($summDtlsArray[0] == 4)
												{
													if($kpiDispVal != '')
													{
														$total[$mpid][$summDtlsArray[2]][$i] = $kpiDispVal;
													}
													if(count($userArray) == ($i-1))
													{
														$total[$mpid][$summDtlsArray[2]]['summary'] = array_sum($total[$mpid][$summDtlsArray[2]]);
														$total[$mpid][$summDtlsArray[2]]['type'] = $kpi_type;
													}
												}
												else if($summDtlsArray[0] == 3)
												{
													if(trim($kpiDispVal) != '')
													{
														$total[$mpid][$summDtlsArray[2]][$i] = $kpiDispVal;
													}
													if(count($userArray) == ($i-1))
													{
														if(count(array_filter($total[$mpid][$summDtlsArray[2]])) != 0)
														{
															$total[$mpid][$summDtlsArray[2]]['summary'] = array_sum($total[$mpid][$summDtlsArray[2]])/count(array_filter($total[$mpid][$summDtlsArray[2]]));
															$total[$mpid][$summDtlsArray[2]]['type'] = $kpi_type;
														}
														else
														{
															$total[$mpid][$summDtlsArray[2]]['summary'] = 0;
															$total[$mpid][$summDtlsArray[2]]['type'] = $kpi_type;
														}
													}
												}
												else if($summDtlsArray[0] == 5)
												{
													if($kpiDispVal != '')
													{
														if(isset($total[$mpid][$summDtlsArray[1]][$i]) && $total[$mpid][$summDtlsArray[1]][$i] != '')
														{
															//$total[$summDtlsArray[2]][$i] = $kpiDispVal.'-'.$total[$summDtlsArray[1]][$i].')'.$kpiDispVal * $total[$summDtlsArray[1]][$i];
															$total[$mpid][$summDtlsArray[2]][$i] = $kpiDispVal * $total[$mpid][$summDtlsArray[1]][$i];
														}
													
													}
													if(count($userArray) == ($i-1))
													{
														if(array_sum($total[$mpid][$summDtlsArray[1]]) != 0)
														{
															if($total[$mpid][$summDtlsArray[1]]['summary'] != 0)
															{
																
																$total[$mpid][$summDtlsArray[2]]['summary'] = array_sum($total[$mpid][$summDtlsArray[2]])/($total[$mpid][$summDtlsArray[1]]['summary']);
																//echo $summDtlsArray[2].'*'.$summDtlsArray[1].'-'.array_sum($total[$mpid][$summDtlsArray[2]]).'/'.$total[$mpid][$summDtlsArray[1]]['summary'].''.$total[$mpid][$summDtlsArray[2]]['summary'].'<br>';
															}
															else 
															{
																$total[$mpid][$summDtlsArray[2]]['summary'] = 0;
															}
															$total[$mpid][$summDtlsArray[2]]['type'] = $kpi_type;
														}
														else
														{
															$total[$mpid][$summDtlsArray[2]]['summary'] = 0;
															$total[$mpid][$summDtlsArray[2]]['type'] = $kpi_type;
														}
													}
												}
										?>
												<td><?php echo $kpiDispVal ; ?></td>
												
												
										<?php } ?>
										
									</tr>
																				
								<?php } ?>
								<?php
								//echo '<pre>';
									//print_r($total);
									//echo array_sum($total['Chats']);
								?>
									<tr id="last_row">
										<td colspan="6" style="text-align:center;">Summary</td>
										<?php
											foreach($total[$mpid] as $key=>$v){
												if($v['type'] == 1 ) $value = $v['summary'];
												else if($v['type'] == 7 ) $value = round($v['summary']);
												else if($v['type'] == 8 ) $value = sprintf("%1.2f",round(($v['summary']),2));
												else $value = sprintf("%1.2f",round(($v['summary']),2)) . "%";
												
												echo '<td>'.$value.'</td>';
											}
										?>
										
									</tr>
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





