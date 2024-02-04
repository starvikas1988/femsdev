<style>
	.modal-open {
		overflow:inherit;
		padding-right:0!important;
	}

	textarea.form-control {
		height: 100px!important;
	}
	.dis_none
	{
		display: none;
	}
	.new .multiselect-container{
		height: 300px;
	}
	.red
	{
		color: red;
	}
</style>
<div class="main-content page-content">
        <div class="main-content-inner">
			<div class="row mb-4">
                <div class="col-md-12 grid-margin">
                    <div class="d-flex justify-content-between flex-wrap">
                        <div class="d-flex align-items-center dashboard-header flex-wrap mb-3 mb-sm-0">
                            <h5 class="mr-4 mb-0 font-weight-bold">New Transaction</h5>                           
                        </div>                        
                    </div>
                </div>
            </div>
			<form id="jurryInnForm" action="<?php echo base_url(); ?>emat_new/submit_new_transaction" method="POST" autocomplete="off">
			<div class="common-top">
				<div class="middle-content">
					<div class="white-dash">
						<div class="row">
								<div class="col-md-6">
									<button type="button" class="hold-btn" id="startCallModalButton" data-toggle="modal" data-target="#startCallModal"><i class="fa fa-play"></i> Start</button>
									 <button type="button" style="display:none" class="btn btn-warning" id="holdCallModalButton" data-toggle="modal" data-target="#holdCallModal"><i class="fa fa-pause"></i> Hold</button>
									<button type="button" style="display:none" class="btn btn-primary" id="unholdCallModalButton" data-toggle="modal" data-target="#unholdCallModal"><i class="fa fa-play"></i> Unhold</button>
									<button type="submit" style="display:none" onclick="return confirm('Do you want to end this call?')" id="endCallModalButton" class="btn btn-danger"><i class="fa fa-stop"></i> End</button> 
								</div>
							<div class="col-sm-6">
								<div class="top-right">
									<div class="timer-bg">
										<div class="inWait">
											<i class="fa fa-clock-o" aria-hidden="true"></i> 00:00:00
										</div>		
										<div style="display:none;" class="text-success inCall">In Call - &nbsp;&nbsp; <i class="fa fa-clock-o"></i> <span></span></div>		
										<div style="display:none;" class="text-warning inHold">In Hold - &nbsp;&nbsp; <i class="fa fa-clock-o"></i> <span></span></div>		
									
										<input type="hidden" name="timer_start_status" id="timer_start_status" value="S">
										<input type="hidden" name="timer_hold_status" id="timer_hold_status" value="H">
									
										<input type="hidden" name="timer_start" id="timer_start">
										<input type="hidden" name="timer_hold" id="timer_hold">
										<div id="timeHolder"></div>
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
							<div class="row" id="formInfoJurysInn" style="display:none">
								<div class="col-sm-3">
									<div class="form-group">
										<label>Unique Id</label>
										<input type="text" class="form-control" id="crm_id" placeholder="" value="<?php echo $crmid; ?>" name="crm_id" required readonly>
									</div>
								</div>
								<div class="col-sm-3">
									<div class="form-group">
										<label>Date and Time</label>
										<input type="text" class="form-control" id="c_date" placeholder="" value="<?php echo date('m/d/Y H:i:s', strtotime($currentDate)); ?>" name="c_date" readonly >
									</div>
								</div>
								<div class="col-sm-3">
									<div class="form-group">
										<label>Ticket ID <span class="red">*</span></label>
										<input type="text" class="form-control" id="ticket_id" name="ticket_id" value="<?php echo $ticket_id; ?>" pattern="([^\s][A-z0-9À-ž\s]+)" required>
									</div>
								</div>
								<div class="col-sm-3">
									<div class="form-group">
										<label>Flight Id <span class="red">*</span></label>
										<input type="text" class="form-control" id="flight_id" name="flight_id" value="<?php echo $flight_id; ?>"  pattern="([^\s][A-z0-9À-ž\s]+)" required>
									</div>
								</div>
								<div class="col-sm-3">
									<div class="form-group">
										<label>Date of Flight <span class="red">*</span></label>
										<input type="date" class="form-control" id="flight_date" name="flight_date" value="<?php echo $flight_date; ?>" required>
									</div>
								</div>
								<div class="col-sm-3">
									<div class="form-group">
										<label>Type - Email or Ticket <span class="red">*</span></label>
										<select class="form-control" name="type" value="" required>
										<option value="">--Select Type</option>
											<option value="0">Email</option>
											<option value="1">Ticket</option>
											
										</select>
										
									</div>
								</div>
								<div class="col-sm-3">
									<div class="form-group">
										<label>Source <span class="red">*</span></label>
										<select class="form-control" name="source" value="" required>
										<option value="" >-- Select Source</option>
											<option value="Zendesk">Zendesk</option> 
											<option value="Flight">Flight APP</option>
											<!--<option value="Onshore">Onshore Team</option>-->
											<option value="Endorsed">Endorsed Tasks</option>
										</select>
									</div>
								</div>
								<div class="col-sm-3">
									<div class="form-group">
										<label>Transaction Type <span class="red">*</span></label>
										<select id="transaction_types" class="form-control" name="transaction_types" autocomplete="off" placeholder="Transaction Type" required>
										<?php 
											echo "<option value=''>-- Select Transaction Type</option>";
							
											foreach($transaction_type as $token){
											$selection = "";
											if($userSelected == $token['id']){ $selection = "selected"; }
										?>
										<option value="<?php echo $token['id']; ?>" <?php echo $selection; ?>><?php echo $token['trans_type_name']; ?></option>
										<?php } ?>	
										</select>
									</div>
								</div>
								<div class="col-sm-6 new" >
									<div class="form-group">
										<label>Actions Taken</label>
										<select id="actions_takens" class="form-control multi_select" name="actions_takens[]" autocomplete="off" placeholder="Actions Taken" multiple >
										<option value=''>-- Select Actions Taken</option>
										</select> 
									</div>
								</div>
								<div class="col-sm-6 new">
									<div class="form-group">
										<label>Pending Items</label>
										<select id="pending_items" class="form-control multi_select" name="pending_items[]" autocomplete="off" placeholder="Pending Items" multiple>
										<option value=''>-- Select Pending Items</option>
										</select>
									</div>
								</div>	
								<div class="col-sm-6">
									<div class="form-group">
										<label>Agent Name</label>
				
										<input type="text" class="form-control"  value="<?php echo get_username(); ?>" name="agent_full_name" required readonly>
									</div>
								</div>
								<div class="col-sm-3">
									<div class="form-group">
										<label>Dispostion List for Resolved <span class="red">*</span></label>
										<select class="form-control" name="is_resolved" autocomplete="off" placeholder="Dispostion List for Resolved" required>
											<option value="">-Select Disposition List-</option>
											<option value="1">Closed</option>
											<option value="0">No Action Required</option>
											<option value="2">Pending</option>
										</select>
									</div>
								</div>
								<div class="col-sm-3">
									<div class="form-group">
										<label>Outbound Call <span class="red">*</span></label>
										<select class="form-control" id="outbond_call" name="outbond_call" required>
										<option value="">--Select Yes or No</option>
											<option value="2">No</option>
											<option value="1">Yes</option>
										</select>
									</div>
								</div>
								<div class="col-sm-12">
									<div class="form-group">
										<label>Remarks <span class="red">*</span></label>
										<textarea class="form-control" id="" name="remarks" required rows="8"></textarea>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
									  <label for="case">No. Of Hold : **</label>
									  <div class="input-group">										
										<input type="number" class="form-control" id="c_hold" placeholder="" name="c_hold" value="0" readonly required>
									   </div>		  
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
									  <label for="case">Hold Time</label>
									  <div class="input-group">										
										<input type="text" class="form-control" id="c_holdtime" placeholder="" value="00:00:00" name="c_holdtime" required readonly>
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

    	