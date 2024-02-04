<style>
	.modal-open {
		overflow:inherit;
		padding-right:0!important;
	}
</style>
<div class="main-content page-content">
        <div class="main-content-inner">
			<div class="row mb-4">
                <div class="col-md-12 grid-margin">
                    <div class="d-flex justify-content-between flex-wrap">
                        <div class="d-flex align-items-center dashboard-header flex-wrap mb-3 mb-sm-0">
                            <h5 class="mr-4 mb-0 font-weight-bold">Update Transaction Details</h5>                           
                        </div>                        
                    </div>
                </div>
            </div>
			<form id="jurryInnForm" action="<?php echo base_url(); ?>emat_new/submit_update_transaction" method="POST" autocomplete="off">
				
			<div class="common-top">
				<div class="middle-content">
					<div class="white-dash">
						<div class="row">
								<div class="col-md-6">
									<h5 class="mr-4 mb-0 font-weight-bold">Edit Transaction : <?php echo $crm_details['trans_unique_id']; ?></h5> 
									<!--  <button type="button" style="display:none" class="btn btn-warning" id="holdCallModalButton" data-toggle="modal" data-target="#holdCallModal"><i class="fa fa-pause"></i> Hold</button>
									<button type="button" style="display:none" class="btn btn-primary" id="unholdCallModalButton" data-toggle="modal" data-target="#unholdCallModal"><i class="fa fa-play"></i> Unhold</button>
									<button type="submit" style="display:none" onclick="return confirm('Do you want to end this call?')" id="endCallModalButton" class="btn btn-danger"><i class="fa fa-stop"></i> End</button>  -->
								</div> 
							<div class="col-sm-6">
								<div class="top-right">
									<div class="timer-bg">
										<div class="inWait">
											<i class="fa fa-clock-o" aria-hidden="true"></i> <?php echo $crm_details['total_time']; ?>
										</div>		
										<!-- <div style="display:none;" class="text-success inCall">In Call - &nbsp;&nbsp; <i class="fa fa-clock-o"></i> <span></span></div>		
										<div style="display:none;" class="text-warning inHold">In Hold - &nbsp;&nbsp; <i class="fa fa-clock-o"></i> <span></span></div>		
									
										<input type="hidden" name="timer_start_status" id="timer_start_status" value="S">
										<input type="hidden" name="timer_hold_status" id="timer_hold_status" value="H">
									
										<input type="hidden" name="timer_start" id="timer_start">
										<input type="hidden" name="timer_hold" id="timer_hold">
										<div id="timeHolder"></div> -->
									</div>
								</div>
							</div>  
						</div>
					</div>
				</div>
			</div>
			
			<div class="common-top">
				<div class="middle-content">
					<div class="white-dash">
						<div class="filter-widget form-widget">
							<div class="row" id="formInfoJurysInn" >
								<div class="col-sm-3">
									<div class="form-group">
										<label>Unique Id</label>
										<input type="text" class="form-control" id="crm_id" placeholder="" value="<?php echo $crm_details['trans_unique_id']; ?>" name="crm_id"  readonly>
									</div>
								</div>
								<div class="col-sm-3">
									<div class="form-group">
										<label>Date and Time</label>
										<input type="text" class="form-control" id="c_date" placeholder="" value="<?php echo $crm_details['trans_date']; ?>" name="c_date" readonly >
									</div>
								</div>
								<div class="col-sm-3">
									<div class="form-group">
										<label>Ticket ID</label>
										<input type="text" class="form-control" id="ticket_id" name="ticket_id" value="<?php echo $crm_details['trans_ticket_id']; ?>" pattern="([^\s][A-z0-9À-ž\s]+)" readonly>
									</div>
								</div>
								<div class="col-sm-3">
									<div class="form-group">
										<label>Flight Id</label>
										<input type="text" class="form-control" id="flight_id" name="flight_id" value="<?php echo $crm_details['trans_flight_id']; ?>"  pattern="([^\s][A-z0-9À-ž\s]+)" readonly>
									</div>
								</div>
								<div class="col-sm-3">
									<div class="form-group">
										<label>Date of Flight</label>
										<input type="Date" class="form-control" id="flight_date" name="flight_date" value="<?php echo strftime('%Y-%m-%d',
  strtotime($crm_details['trans_flight_date'])); ?>" placeholder="">
									</div>
								</div>
								<div class="col-sm-3">
									<div class="form-group">
										<label>Type - Email or Ticket</label>
										<select class="form-control" name="type" value="" >
											<option <?php if ($crm_details['transaction_type'] == 0 ) echo 'selected' ; ?>value="0">Email</option>
											<option  <?php if ($crm_details['transaction_type'] == 1 ) echo 'selected' ; ?> value="1">Ticket</option>
											
										</select>
										
									</div>
								</div>
								<div class="col-sm-3">
									<div class="form-group">
										<label>Source</label>
										<select class="form-control" name="source"  >
											<option <?php if ($crm_details['source'] == 'Zendesk' ) echo 'selected' ; ?> value="Zendesk">Zendesk</option>
											<option <?php if ($crm_details['source'] == 'Flight' ) echo 'selected' ; ?> value="Flight">Flight APP</option>
											<option <?php if ($crm_details['source'] == 'Onshore' ) echo 'selected' ; ?> value="Onshore">Onshore Team</option>
											<option <?php if ($crm_details['source'] == 'Endorsed' ) echo 'selected' ; ?> value="Endorsed">Endorsed Tasks</option>
										</select>
									</div>
								</div>
								<div class="col-sm-3">
									<div class="form-group">
										<label>Transaction Type</label>
										<select id="transaction_types" class="form-control" name="transaction_types" autocomplete="off" placeholder="Transaction Type" >
										<?php 
											echo "<option value=''>-- Select Transaction Type</option>";

							
											foreach($transaction_type as $token){

											$selection = "";
											if($crm_details['trans_type_id'] == $token['id'] ){ $selection = "selected"; }
											
										?>
										<option value="<?php echo $token['id']; ?>" <?php echo $selection; ?>><?php echo $token['trans_type_name']; ?></option>
										<?php } ?>	
										</select>
									</div>
								</div>
								
								<div class="col-sm-3">
									<div class="form-group">
										<label>Agent Name</label>
				
										<input type="text" class="form-control"  value="<?php echo $crm_details['added_by_name']; ?>" name="agent_full_name"  readonly>
									</div>
								</div>
								<div class="col-sm-3">
									<div class="form-group">
										<label>Dispostion List for Resolved</label>
										<select class="form-control" name="is_resolved" autocomplete="off" placeholder="Dispostion List for Resolved" required>
											<option <?php if ($crm_details['is_resolved'] == '1' ) echo 'selected' ; ?>value="1">Closed</option>
											<option  <?php if ($crm_details['is_resolved'] == '0' ) echo 'selected' ; ?> value="0">No Action Required</option>
											<option <?php if ($crm_details['is_resolved'] == '2' ) echo 'selected' ; ?> value="2">Pending</option>
										</select>
									</div>
								</div>
								<div class="col-sm-3">
									<div class="form-group">
										<label>Remarks</label>
										<input type="text" class="form-control" id="" name="remarks" value="<?php echo $crm_details['remarks']; ?>" >
									</div>
								</div>
								<div class="col-sm-3">
									<div class="form-group">
										<label>Notes</label>
										<input type="text" class="form-control"  name="notes" value="<?php echo $crm_details['notes']; ?>" >
									</div>
								</div>
								<div class="col-sm-4">
									<div class="form-group">
										<label>Outbound Call</label>
										<select class="form-control" id="outbond_call" name="outbond_call" disabled>
											<option <?php if ($crm_details['outbond_call'] == '2' ) echo 'selected' ; ?> value="2">No</option>
											<option <?php if ($crm_details['outbond_call'] == '1' ) echo 'selected' ; ?> value="1">Yes</option>
										</select>
									</div>
								</div>
								 <div class="col-md-4">
									<div class="form-group">
									  <label for="case">No. Of Hold : **</label>
									  <div class="input-group">										
										<input type="number" class="form-control" id="c_hold" placeholder="" name="c_hold" value="<?php echo $crm_details['c_hold']; ?>" readonly >
									   </div>		  
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
									  <label for="case">Hold Time</label>
									  <div class="input-group">										
										<input type="text" class="form-control" id="c_holdtime" placeholder="" value="<?php echo $crm_details['c_hold_time']; ?>" name="c_holdtime"  readonly>
									   </div>		  
									</div>
								</div> 
								<div class="col-sm-12">
									<div class="form-group">
										<button type="submit" class="submit-btn" name="submit">
											<i class="fa fa-paper-plane" aria-hidden="true"></i>
											Submit
										</button>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			</form>	

			<div class="common-top">
				<div class="middle-content">
					<div class="white-dash">
						<div class="table-widget">
						<div class="table-white">
							<table id="example" class="table common-data table-striped table-bordered">
								<thead>
								  <tr>
								  	<th>SL.no</th>
									<th>Transaction ID</th>
									<th>Ticket ID</th>
									<th>Flight Id</th>
									<th>Agent Name</th>
									<th>Current Status</th>
									<th>Notes</th>
									<th>Update Date</th>
									<th>logs</th>
					
								  </tr>
								</thead>
								<tbody>
								<?php 
								//print_r($log_details);die;
								$cn = 1;
								foreach($log_details as $token){ 								
								?>
								<tr>
									<td><?php echo $cn++; ?></td>
									<td><?php echo $token['new_transation_id']; ?></td>
									<td><?php echo $token['ticket_id']; ?></td>
									<td><?php echo $token['flight_id']; ?></td>
									<td><?php echo $token['added_by_name']; ?></td>
									<td><?php if ($token['ticket_status'] == 1) {
										echo "Closed";
										
									}elseif ($token['ticket_status'] == 2) {
										echo "Pending";
									}else{
										echo "No Action Required";
									}  ?>
										
									</td>
									<td><?php echo $token['notes']; ?></td>
									<td><?php echo $token['added_date']; ?></td>
									<td><?php echo $token['logs']; ?></td>
									
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
    
<div class="modal fade modal-design modal-close" id="startCallModal" tabindex="-1" role="dialog" aria-labelledby="startCallModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
		<div class="modal-header">
          <h4 class="modal-title" id="startCallModalLabel">
			<i class="fa fa-play"></i> Start Call
		  </h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
      <div class="modal-body">
		<div class="body-widget">
			<b>Do you want to start New Transaction Form ?</b>
		</div>	
      </div>	  
      <div class="modal-footer">
	    <button type="button" btype="start" onclick="callActionButton('start')" class="hold-btn new-hold-btn">Yes, Start</button>
        <button type="button" class="cancel-btn" data-dismiss="modal">No</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade modal-design" id="holdCallModal" tabindex="-1" role="dialog" aria-labelledby="holdCallModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
		
		<div class="modal-header">
          <h4 class="modal-title" id="holdCallModalLabel">
			<i class="fa fa-play"></i> Hold Call
		  </h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
	
      
      <div class="modal-body">
		<div class="body-widget">
			<b>Do you want to hold this Transaction form ?</b>
		</div>			
      </div>	  
      <div class="modal-footer">
	    <button type="button" btype="hold" onclick="callActionButton('hold')" class="hold-btn">Yes, Hold</button>
        <button type="button" class="cancel-btn" data-dismiss="modal">No</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade modal-design" id="unholdCallModal" tabindex="-1" role="dialog" aria-labelledby="unholdCallModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
	
	<div class="modal-header">
          <h4 class="modal-title" id="unholdCallModalLabel">
			<i class="fa fa-play"></i> Unhold Call
		  </h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
	      
      <div class="modal-body">
		<p class="text-primary"><b>Do you want to unhold this Transaction ?</b></p>	
      </div>	  
      <div class="modal-footer">
	    <button type="button" btype="unhold" onclick="callActionButton('unhold')"  class="hold-btn">Yes, Unhold</button>
        <button type="button" class="cancel-btn" data-dismiss="modal">No</button>
      </div>
    </div>
  </div>
</div>

    	