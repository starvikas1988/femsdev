<style>
	.modal-open {
		overflow:inherit;
		padding-right:0!important;
	}
	.selectpicker {
	border:none!important;
	}
	.selectpicker:hover {
		border:none!important;
		background:transparent!important;
	}
</style>
<div class="main-content page-content">
        <div class="main-content-inner">
			<div class="row mb-4">
                <div class="col-md-12 grid-margin">
                    <div class="d-flex justify-content-between flex-wrap">
                        <div class="d-flex align-items-center dashboard-header flex-wrap mb-3 mb-sm-0">
                            <h5 class="mr-4 mb-0 font-weight-bold">New Transaction For Tech issue Tracker</h5>                           
                        </div>  
					                    
                    </div>
                </div>
            </div>
			<!-- <div class="row mb-4">
                <div class="col-md-12 grid-margin">
                    <div class="d-flex justify-content-between flex-wrap">
                      
						<div id="infoMessage">hii<?php //echo $message;?></div>                      
                    </div>
                </div>
            </div> -->
			<form id="jurryInnForm" action="<?php echo base_url(); ?>aifi/submit_new_transaction_for_tech" method="POST" autocomplete="off">
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
								<div class="col-sm-2">
									<div class="form-group">
										<label>Stores :<span style="color:red;">*</span></label>
										<select class="form-control selectpicker" name="source" value="" data-hide-disabled="true" data-live-search="true" required>
										<?php  
										echo "<option value=''>-- Select Stores</option>";
										foreach($stores_details as $token){
											$selection = "";
											if($userSelected == $token['id']){ $selection = "selected"; }
										?>
										<option value="<?php echo $token['id']; ?>" <?php echo $selection; ?>><?php echo $token['stores_name']; ?></option>
										<?php } ?>
										</select>
									</div>
								</div>
								<div class="col-sm-1" id="myDropdown">
									<div class="form-group">
										<label>Number :<span style="color:red;">*</span></label>
										<input type="text" class="form-control number-only-no-minus-also" name="store_number" required >
									</div>
								</div>
								<div class="col-sm-3">
									<div class="form-group">
										<label>Type of Tech Issue :<span style="color:red;">*</span></label>
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
								
								<div class="col-sm-3">
									<div class="form-group">
										<label>Agent Name</label>
				
										<input type="text" class="form-control"  value="<?php echo get_username(); ?>" name="agent_full_name" required readonly>
									</div>
								</div>
								<div class="col-sm-3">
									<div class="form-group">
										<label>Dispostion List for Resolved</label>
										<select class="form-control" name="is_resolved" autocomplete="off" placeholder="Dispostion List for Resolved" required>
											<option value="1">Closed</option>
											<option value="0">No Action Required</option>
											<option value="2">Pending</option>
										</select>
									</div>
								</div>
								<div class="col-sm-3">
									<div class="form-group">
										<label>Hat Link :<span style="color:red;">*</span></label>
										<input type="text" class="form-control character_numeric_space_only" id="" name="hat_link" required >
										<span id="character_numeric_space_only_span" style="color:red;font-size:10px;"></span>

									</div>
								</div>
								<div class="col-sm-3">
									<div class="form-group">
										<label>Remarks :<span style="color:red;">*</span></label>
										<input type="text" class="form-control character-as-well-as-number-only" id="" name="reason" required >
										<span id="reason_for_leaving" style="color:red;font-size:10px;"></span>

									</div>
								</div>
								
								<div class="col-sm-4">
									<div class="form-group">
										<label>Outbound Call</label>
										<select class="form-control" id="outbond_call" name="outbond_call" >
											<option value="2">No</option>
											<option value="1">Yes</option>
										</select>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
									  <label for="case">No. Of Hold : *</label>
									  <div class="input-group">										
										<input type="number" class="form-control" id="c_hold" placeholder="" name="c_hold" value="0" readonly required>
									   </div>		  
									</div>
								</div>
								<div class="col-md-4">
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
			<b>Do you want to start Tech Issue Tracker form ?</b>
		</div>	
      </div>	  
      <div class="modal-footer">
	    <button type="button" style="
    background-color: green;" btype="start" onclick="callActionButtontech('start')" class="hold-btn new-hold-btn">Yes</button>
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
	    <button type="button" btype="hold" onclick="callActionButtontech('hold')" class="hold-btn">Yes, Hold</button>
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
	    <button type="button" btype="unhold" onclick="callActionButtontech('unhold')"  class="hold-btn">Yes, Unhold</button>
        <button type="button" class="cancel-btn" data-dismiss="modal">No</button>
      </div>
    </div>
  </div>
	</div>

    	