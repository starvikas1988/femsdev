
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
						<h4 style="margin-top:5px;" class="widget-title">Performance Metrix of <?php echo $desc; ?></h4>
												
					</header><!-- .widget-header -->
					<hr class="widget-separator">
						
					<div class="widget-body" >
						<div class="table-responsive" >
						
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
										$KpiCount=0;
										
										foreach($kpiHeaderArr as $hrow){
											
											$hid = $hrow['id'];
											$KpiCount = count($hrow);
																						
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
									$dataArray=$pmAllArray[$mpid."date"];
									
									$dataArray=$pmAllArray[$mpid."data"];
									
									
									foreach($userArray as $user){
										
									$fusion_id=$user['fusion_id'];
									
									$userDataArray=$dataArray[$fusion_id];
									
									if( count($userDataArray) > 0 ){
										
									//echo "<pre>";
									//print_r($userDataArray);
									//echo "</pre>";

									$start_date = $userDataArray[0]['start_date'];
									$end_date = $userDataArray[0]['end_date'];
									
									$week_num=date("W", strtotime($start_date));
									
									}
									
									
									
								?>
									
									<tr id="value_start">
										
										<td><?php echo $i++; ?></td>
										<td><?php echo $start_date; ?></td>
										
										<td><?php echo $user['fusion_id']; ?></td>
										<td><?php echo $user['fname'] . " ". $user['lname']; ?></td>
										<td><?php echo $user['process_name']; ?></td>
										<td><?php echo $user['role_name']; ?></td>
										
										<?php 
										//echo '<pre>';
										//print_r($userDataArray);
										//count($userDataArray);
											$kpisl=0;
											
											foreach($userDataArray as $udrow){
												
												
												$kpi_id = $udrow['kpi_id'];
												$kpi_value = $udrow['kpi_value'];
																								
												$summDtls=$kpiSummArry[$kpi_id];
												$kpi_type=$kpiTypeArry[$kpi_id];
												
												
												$summDtlsArray = explode("##",$summDtls);
												
												
												$kpiDispVal="-";
												
												if($kpi_type == 1 ) $kpiDispVal = $kpi_value;
												else if($kpi_type == 7 ) $kpiDispVal = round($kpi_value);
												else if($kpi_type == 8 ) sprintf("%1.2f",round(($kpi_value*100.0),2));
												else $kpiDispVal = sprintf("%1.2f",round(($kpi_value*100.0),2)) . "%";
												
												if(!isset($total[$summDtlsArray[2]][$i]))
												{
													$total[$summDtlsArray[2]][$i] = '';
												}
												
												
												if($summDtlsArray[0] == 3)
												{
													if(trim($kpiDispVal) != '')
													{
														$total[$summDtlsArray[2]][$i] = $kpiDispVal;
													}
													if(count($userArray) == ($i-1))
													{
														if(count(array_filter($total[$summDtlsArray[2]])) != 0)
														{
															$total[$summDtlsArray[2]]['summary'] = array_sum($total[$summDtlsArray[2]])/count(array_filter($total[$summDtlsArray[2]]));
															$total[$summDtlsArray[2]]['type'] = $kpi_type;
														}
														else
														{
															$total[$summDtlsArray[2]]['summary'] = 0;
															$total[$summDtlsArray[2]]['type'] = $kpi_type;
														}
													}
												}
												else if($summDtlsArray[0] == 5)
												{
													if($kpiDispVal != '')
													{
														if(isset($total[$summDtlsArray[1]][$i]) && $total[$summDtlsArray[1]][$i] != '')
														{
															//$total[$summDtlsArray[2]][$i] = $kpiDispVal.'-'.$total[$summDtlsArray[1]][$i].')'.$kpiDispVal * $total[$summDtlsArray[1]][$i];
															$total[$summDtlsArray[2]][$i] = $kpiDispVal * $total[$summDtlsArray[1]][$i];
														}
													}
													
													
													if(count($userArray) == ($i-1))
													{
														if(array_sum($total[$summDtlsArray[1]]) != 0)
														{
															$total[$summDtlsArray[2]]['summary'] = array_sum($total[$summDtlsArray[2]])/($total[$summDtlsArray[1]]['summary']);
															$total[$summDtlsArray[2]]['type'] = $kpi_type;
														}
														else
														{
															$total[$summDtlsArray[2]]['summary'] = 0;
															$total[$summDtlsArray[2]]['type'] = $kpi_type;
														}
													}
												}else{
													
													if ($kpiDispVal == '' ) $kpiDispVal = 0;
													$total[$summDtlsArray[2]][$i] = $kpiDispVal;
													
													if(count($userArray) == ($i-1))
													{
														$total[$summDtlsArray[2]]['summary'] = array_sum($total[$summDtlsArray[2]]);
														$total[$summDtlsArray[2]]['type'] = $kpi_type;
													}
													
												}
										?>
												<td ><?php echo $kpiDispVal ; ?></td>
												
												
												

										<?php 
										$kpisl++;
										if($kpisl == $KpiCount){
											
											$kpisl=0;
											echo "</tr>";
										?>
											<tr id="value_start">
										
											<td><?php echo $i++; ?></td>
											<td><?php echo $week_num; ?></td>
											
											<td><?php echo $user['fusion_id']; ?></td>
											<td><?php echo $user['fname'] . " ". $user['lname']; ?></td>
											<td><?php echo $user['process_name']; ?></td>
											<td><?php echo $user['role_name']; ?></td>
											
										<?
										}
											
										
										} ?>
										
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
											foreach($total as $key=>$v){
												if($v['type'] == 1 ) $value = $v['summary'];
												else if($v['type'] == 7 ) $value = round($v['summary']);
												else if($v['type'] == 8 ) $value = sprintf("%1.2f",round(($v['summary']*100.0),2));
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





