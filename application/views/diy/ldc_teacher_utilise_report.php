<div class="wrap">
	<section class="app-content">
		
		<div class="row">
			<div class="col-md-12">
				<div class="widget">
				
				
					<div class="row">
						<div class="col-md-10">
							<header class="widget-header"><h4 class="widget-title">Teacher Utilisation Report</h4></header>
						</div>	
						<hr class="widget-separator">
					</div>
					
					<div class="widget-body">
					
						<div class="row">
						  <form id="form_new_user" autocomplete="off" method="GET">
						  
							
							<div class="col-md-3">								
								<label>From Date</label>
								<input type="text" id="start_date" name="start_date" value="<?php if(!empty($gotStart)){ echo date('m/d/Y', strtotime($gotStart)); } ?>" class="form-control diy_datePicker" required readonly>
							</div>
							
							<div class="col-md-3">
								<label>To Date</label>
								<input type="text" id="end_date" name="end_date" value="<?php if(!empty($gotEnd)){ echo date('m/d/Y', strtotime($gotEnd)); } ?>" class="form-control diy_datePicker" required readonly>
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
						  <div class="panel-heading"><b>Teacher Utilization</b></div>
						  <div class="panel-body">	  
							<div style="width:100%;height:400px; padding:10px 10px">
								<canvas id="team_2dpie_daywise"></canvas>
							</div>  
						  </div>
						</div>
						
						
						<div class="row">
						<div class="table-responsive">
							<table class="table table-striped skt-table" cellspacing="0" width="100%">
								<thead>
									<tr class='bg-info'>
										<th class="text-center">SL</th>
										<th class="text-center">Teachers Name</th>
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
									foreach($teacherArray as $key=>$token){ 
										$counter++;
										$teacherID = $token['id'];
										$totalSeconds = array_sum($overview[$teacherID]['all']);
										$scheduleSeconds = array_sum($overview[$teacherID]['schedule']);
										
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
										<td class="text-center"><?php echo $token['fname'] ." " .$token['lname']; ?></td>
										<td class="text-center"><?php echo $hoursAvailable; ?></td>
										<td class="text-center"><?php echo !empty($hoursScheduled) ? $hoursScheduled : 0; ?></td>
										<td class="text-center"><?php echo sprintf('%02d', $untilisation); ?>%</td>
										
									</tr>
									<?php } ?>
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