<div class="wrap">
	<section class="app-content">	
	
	
		<div class="simple-page-wrap" style="width:80%;">
		<div class="simple-page-form animated flipInY">
		<!--<h4 class="form-title m-b-xl text-center">Schedule Check</h4>-->
					
			
		
			<div class="row">
					
				<div class="col-md-12">
					<div class="widget stats-widget">
							
							<header class="widget-header">
								<h4 class="widget-title">Schedule Checkup</h4>
							</header>
							
							<hr class="widget-separator">
					
						<div class="widget-body clearfix">
						<form id="scheduleCheckSubmission" method="POST" action="<?php echo base_url(); ?>schedule/schedule_accept_submit" autocomplete="off" enctype="multipart/form-data">	
								
							<div class="table-responsive">
								<table id="default-datatable" data-plugin="DataTable" class="table table-striped skt-table" cellspacing="0" width="100%" style='margin-bottom:0px;'>
									<thead>
										<tr class='bg-info'>
											<th class="text-center"><input style="height: 15px;" type="checkbox" name="schedule_id_chekbox_all" id="schedule_id_chekbox_all" value=""></th>
											<th class="text-center">Date</th>
											<th class="text-center">Day</th>
											<th class="text-center">In Time</th>
											<th class="text-center">Break 1</th>
											<th class="text-center">Lunch</th>
											<th class="text-center">Break 2</th>
											<th class="text-center">End Time</th>
											<th class="text-center"></th>
										</tr>
									</thead>
								
									<tbody>
								
									<?php
									foreach($pending_schedules as $scheduleToken){
										$params = $scheduleToken['shdate'] ."{#}" .$scheduleToken['in_time'] ."{#}" .$scheduleToken['out_time'] ."{#}" .$scheduleToken['shday'];
									?>
										
										<tr>
											<td class="text-center"><input style="height: 15px;" type="checkbox" name="schedule_id_chekbox[]" value="<?php echo $scheduleToken['id']; ?>"></td>
											<td class="text-center"><?php echo $scheduleToken['shdate']; ?></td>
											<td class="text-center"><?php echo $scheduleToken['shday']; ?></td>
											<td class="text-center"><?php echo $scheduleToken['in_time']; ?></td>
											<td class="text-center"><?php echo $scheduleToken['break1']; ?></td>
											<td class="text-center"><?php echo $scheduleToken['lunch']; ?></td>
											<td class="text-center"><?php echo $scheduleToken['break2']; ?></td>
											<td class="text-center"><?php echo $scheduleToken['out_time']; ?></td>
											<td class="text-center">
											<button type="button" name="btnApprove[]" style='width:60px;padding: 2px 5px;' class="btn btn-primary acceptEach">Accept</button>
											<button type="button" name='btnReview[]' params="<?php echo $params; ?>" style='width:100px;padding: 2px 5px;' class="btn btn-warning reviewEach">Review</button>
											</td>										
										</tr>
									
									<?php } ?>
									
									</tbody>
								</table>
								
								<br/><br/>
								<p style="text-align: left;"><strong>NOTE :</strong> Click on Review button, only if you find your schedule as incorrect.</p>
								
								<div class="text-center" id="checkSelection" style="display:none">
								    <hr/>
									<button type="button" name='btnApproveSelection' style='width:120px;padding: 5px 5px;' class="btn btn-success">
									<i class="fa fa-check"></i> Accept Selected</button>
									<!--<button type="button" name='btnReviewSelection' style='width:120px;padding: 5px 5px;' class="btn btn-danger">
									<i class="fa fa-sign-in"></i> Review Selected</button>-->
									<input type="hidden" name="schedule_submission_type" value="1">
									<br/>
								</div>
							</div>
							
							<br/>
							
							
						</form>						
						</div>
					</div>
				</div>
			</div>
				
		

		</div>
		</div>
		
		
		
</section> 
</div>



<div class="modal fade" id="modalReviewSchedule" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Send to Review</h4>
			</div>
			
			<form id="frmReviewShedule" method='POST' action="<?php echo base_url(); ?>schedule/schedule_agent_review_submit">			
				<div class="modal-body">
				
					<p><b>Current Schedule</b></p>
					<input type="hidden" id="schedule_id" name="schedule_id" required>				
					<input type="hidden" id="schedule_submission_type" name="schedule_submission_type" value="2" required>
					<input type="hidden" id="schedule_agent_status" name="schedule_agent_status" value="R" required>
					
					<input type="text" id="schedule_day" name="schedule_day" value="" style="width:60px;background-color:#ededed;border: 1px solid #000;padding: 2px 0px 2px 5px;border-radius:3px" readonly required>
					<input type="text" id="schedule_date" name="schedule_date" value="" style="width:150px;background-color:#ededed;border: 1px solid #000;padding: 2px 0px 2px 5px;border-radius:3px" readonly required>
					<input type="time" id="schedule_in" name="schedule_in" value="" style="background-color:#ededed;border: 1px solid #000;padding: 2px 0px 2px 5px;border-radius:3px" readonly required>
					<input type="time" id="schedule_out" name="schedule_out" value="" style="background-color:#ededed;border: 1px solid #000;padding: 2px 0px 2px 5px;border-radius:3px" readonly required>
					
					<hr/>
					
					<div class="row">
						<div class="col-md-6">
							<label>Request Type</label>
							<select class="form-control" name="request_type" id="request_type">
								<option value="TIME">Time</option>
								<option value="OFF">OFF</option>
							</select>
						</div>
					</div>
					
					<hr/>
					
					<div class="row">
						<div class="col-md-6">
							<label>Request In Time</label>
							<input type="time" class="form-control scheduleInTrigger" id="request_schedule_in" name="request_schedule_in" value="" required>
						</div>
						
						<div class="col-md-6">
							<label>Request Out Time</label>
							<input type="time" class="form-control" id="request_schedule_out" name="request_schedule_out" value="" style="background-color:#ededed;border: 1px solid #000;padding: 2px 0px 2px 5px;" readonly required>
						</div>
					</div>
					
					<br/>
					
					
					
					<div class="row">
						<div class="col-md-12">
							<label>Remarks</label>
							<textarea class="form-control" type="text" id="schedule_review_remarks" name="schedule_review_remarks" required></textarea>
							<br/>
						</div>
					</div>
					
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary">Submit</button>
				</div>
			</form>
		</div>
	</div>
</div>
