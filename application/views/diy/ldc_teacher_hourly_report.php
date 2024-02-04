<div class="wrap">
	<section class="app-content">
		
		<div class="row">
			<div class="col-md-12">
				<div class="widget">
				
				
					<div class="row">
						<div class="col-md-10">
							<header class="widget-header"><h4 class="widget-title">Teacher Daywise Hourly Report</h4></header>
						</div>	
						<hr class="widget-separator">
					</div>
					
					<div class="widget-body">
					
						<div class="row">
						  <form id="form_new_user" method="GET">
						  
							<div class="col-md-4">
								<div class="form-group">
									<label>Select Teacher</label>
									<select class="form-control" name="teacher_id" id="teacher_id">
										<?php 
										foreach($teachersData as $key=>$val){ 
											$setSelection = "";
											if($val['id'] == $gotTeacher){ $setSelection = "selected"; }
										?>
										<option value="<?php echo $val['id'];?>"  <?php echo $setSelection; ?>><?php echo $val['fname'].' '. $val['lname'];?></option>
										<?php } ?>
									</select>
								</div>
							</div>
							
							<div class="col-md-3">								
								<label>Select Month</label>
								<select class="form-control" name="monthSelect" id="monthSelect">
									<?php
									for($i=1; $i<=12; $i++){
										$setSelection = "";
										$currDate = date('Y')."-".sprintf('%02d', $i)."-01";
										if($i == $gotMonth){ $setSelection = "selected"; }
									?>
										<option value="<?php echo date('m', strtotime($currDate)); ?>" <?php echo $setSelection; ?>><?php echo date('F', strtotime($currDate)); ?></option>
									<?php } ?>
								</select>
							</div>
							
							<div class="col-md-3">
								<label>Select Year</label>
								<select class="form-control" name="yearSelect" id="yearSelect">
									<?php
									$current_y = date('Y');
									$last_y = $current_y - 5;
									for($j=$current_y;$j>=$last_y;$j--){
										$selectiny = "";
										if($gotYear == $j){ $selectiny = "selected"; }
									?>
									<option value="<?php echo $j; ?>" <?php echo $selectiny; ?>>
									<?php echo $j; ?>
									</option>
									<?php } ?>
								</select>
							</div>
																
							
							<div class="col-md-1" style='margin-top:22px;'>
								<div class="form-group">
									<button class="btn btn-primary waves-effect" type="submit" id='show' name='show' value="Show">Search</button>
								</div>
							</div>
							
						  </form>
						</div>
						
						
						<br/><br/>
						
						<div class="panel panel-default">
						  <div class="panel-heading"><b>Daywise Utilization Report</b></div>
						  <div class="panel-body">	  
							<div style="width:100%;height:400px; padding:10px 10px">
								<canvas id="team_2dpie_daywise_adherence"></canvas>
							</div>  
						  </div>
						</div>


						
						<div class="row">
						<div class="table-responsive">
							<table class="table table-striped skt-table" cellspacing="0" width="100%">
								<thead>
									<tr class='bg-info'>
										<th class="text-center">SL</th>
										<th class="text-center">Date</th>
										<th class="text-center">Available</th>
										<th class="text-center">Scheduled</th>
										<th class="text-center">Utilisation</th>
									</tr>
								</thead>
								<tbody>
									<?php 
									
									
									function display_time_view($seconds)
									{
										$diff = $seconds;
										$hours = floor($diff / (60*60));
										$minutes = floor(($diff - $hours*60*60)/ 60);
										$seconds = floor(($diff - $hours*60*60 - $minutes*60));
										
										$times = "";
										if($hours > 0){ $times .= $hours ." hr "; } 
										if($minutes > 0){ $times .= $minutes ." min "; } 
										if($seconds > 0){ if($minutes <= 0) { $times .= $seconds ." sec "; } } 
										return $times;
									}
									
									$counter=0;	 							
									foreach($reporting as $key=>$token){ 
										$counter++;
										
										$totalSeconds = array_sum($reporting[$key][$gotTeacher]['all']);
										$scheduleSeconds = array_sum($reporting[$key][$gotTeacher]['schedule']);
										
										$unutilisedSeconds = $totalSeconds - $scheduleSeconds;
										$untilisation = 0;
										if($unutilisedSeconds > 0){
											$untilisation = ($scheduleSeconds/$totalSeconds) * 100;
										}
										
										$hoursAvailable = 	"0";
										$hoursScheduled = 	"0";
										if($totalSeconds > 0){
											$hoursAvailable = 	display_time_view($totalSeconds);
											$hoursScheduled = 	display_time_view($scheduleSeconds);
										}

										
										
									?>
									<tr>
										<td class="text-center"><?php echo $counter; ?> </td>
										<td class="text-center"><?php echo date('d F, Y', strtotime($key)); ?></td>
										<td class="text-center"><?php echo $hoursAvailable; ?></td>
										<td class="text-center"><?php echo !empty($hoursScheduled) ? $hoursScheduled : 0; ?></td>
										<td class="text-center"><?php echo sprintf('%02d', $untilisation); ?>%</td>
										
									</tr>
									<?php } ?>
									
									<tr>
										<td class="text-center" colspan='2'><b>TOTAL</b></td>
										<td class="text-center"><b><?php echo display_time_view($overall[$gotTeacher]['available']); ?></b></td>
										<td class="text-center"><b><?php echo display_time_view($overall[$gotTeacher]['schedule']); ?></b></td>
										<td class="text-center"><b><?php echo sprintf('%.2f', $overall[$gotTeacher]['utilise']); ?>%</b></td>
										
									</tr>
								</tbody>

							</table>
						</div>
						
						</div>
						
					</div>
					
				</div>
			</div>
		</div>
	
	</section>
</div>	