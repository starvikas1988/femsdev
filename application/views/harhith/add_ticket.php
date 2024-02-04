
			<div class="row mb-4">
                <div class="col-md-12 grid-margin">
                    <div class="d-flex justify-content-between flex-wrap">
                        <div class="d-flex align-items-center dashboard-header flex-wrap mb-3 mb-sm-0">
                            <h5 class="mr-4 mb-0 font-weight-bold">Add Ticket</h5>                           
                        </div>                        
                    </div>
                </div>
            </div>
						
						
			<div class="common-top">
				<div class="middle-content">
				
				<form method="POST" autocomplete="off" enctype="multipart/form-data">
					<div class="row newTicketEnquiry">
					
						<div class="col-sm-6">
							<div class="card">
								<div class="card-body">
									<h2 class="heading-title">
										Call Information
									</h2>
									<div class="row">
									
										<div class="col-md-6">
											<div class="form-group">
											  <label>Date</label>
											  <input type="date" class="form-control" value="<?php echo $current_date; ?>" name="c_date" required readonly>
											</div>
										</div>
										<div class="col-md-6" style="display:none">
											<div class="form-group">
											  <label>Ticket No</label>
											  <input type="text" class="form-control" name="c_ticket" value="<?php echo $ticket_no; ?>" required readonly>
											  <input type="hidden" class="form-control" value="<?php echo $current_user_id; ?>" name="c_ticket_uid" required readonly>
											</div>
											
										</div>
										<div class="col-md-6">
											<div class="form-group">
											  <label>Call Type <span class="text-danger font-weight-bold">*</span></label>
											  <select class="form-control" name="c_call_type" required>
												<?php echo hth_dropdown_3d_options($call_type); ?>	
											  </select>
											</div>											
										</div>
										
										<div class="col-md-6">
											<div class="form-group">
											  <label>Phone No <span class="text-danger">*</span></label>
											  <input type="text" maxlength="11" placeholder="Starting No (0-5) Not Allowed"  data-inputmask="'mask': ['99999-99999']" data-mask="" inputmode="text" oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*?)\..*/g, '$1');" class="form-control numberCheckPhone" name="c_phone" required>
											</div>
										</div>
										
										<div class="col-md-6">
											<div class="form-group">
											  <label>Email ID</label>
											  <input type="email" class="form-control" name="c_email_id" value="">
											</div>											
										</div>
										
										<div class="col-md-6">
											<div class="form-group">
											  <label>District <span class="text-danger font-weight-bold">*</span></label>
											  <select class="form-control singleSelect" name="c_district"  style="width:100%" required>
												<?php echo hth_dropdown_options_val($district_list); ?>	
											  </select>
											</div>
										</div>
										
										<div class="col-md-6" style="display:none">
											<div class="form-group">
											  <label>Village</label>
											  <select class="form-control singleSelect" name="c_village" style="width:100%">
												<option value="">-- Select Village --</option>
												<?php //echo hth_dropdown_options_val($village_list); ?>	
											  </select>
											</div>									
										</div>
										
																														
										<div class="col-md-6">
											<div class="form-group">
										    <label>City/Taluk <span class="text-danger font-weight-bold">*</span></label>
											<select class="form-control singleSelect" name="c_city"  style="width:100%" required>
												<?php echo hth_dropdown_options_val($taluk_list); ?>	
											 </select>
										     </div>
										</div>
										
										<div class="col-md-6">
											<div class="form-group">
											  <label>Post Office</label>
											  <select class="form-control singleSelect" name="c_postoffice" style="width:100%">
												<?php echo hth_dropdown_options_val($postoffice_list); ?>	
											  </select>
											</div>
										</div>
										
										<div class="col-md-6">
											<div class="form-group">
											  <label>Pin Code</label>
											  <input type="text" class="form-control" name="c_pincode" maxlength="6" oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*?)\..*/g, '$1');" required>
											</div>
										</div>
										
										<div class="col-md-12">
											<div class="form-group">
											  <label>Address Details</label>
											  <textarea class="form-control capitalCheckText" name="c_fulladdress"></textarea>
											</div>
										</div>
										
									</div>								
								</div>
							</div>
						</div>
						
						
						<div class="col-sm-6">
							<div class="card">
								<div class="card-body">
									<h2 class="heading-title">
										Call Status
									</h2>
									
									<div class="row">
										
										
										
										<div class="col-md-6">
											<div class="form-group">
											  <label>Franchisee Type <span class="text-danger font-weight-bold">*</span></label>
											  <select class="form-control" name="c_franchisee_type" required>
												<?php echo hth_dropdown_options($franchisee_type); ?>	
											  </select>
											</div>											
										</div>
										
										<div class="col-md-6">
											<div class="form-group">
											  <label>Alt. Phone No</label>
											  <input type="text" maxlength="11" placeholder="Starting No (0-5) Not Allowed"  data-inputmask="'mask': ['99999-99999']" data-mask="" inputmode="text" oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*?)\..*/g, '$1');" class="form-control numberCheckPhone" name="c_phone_alt">
											</div>
										</div>
										
										<div class="col-md-6">
											<div class="form-group">
										    <label>First Name <span class="text-danger font-weight-bold">*</span></label>
										    <input type="text" class="form-control nameCheckPhone capitalCheckText" onkeypress="return /[a-z ]/i.test(event.key)" name="c_firstname" required>
										</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
											  <label>Last Name <span class="text-danger font-weight-bold">*</span></label>
											  <input type="text" class="form-control nameCheckPhone capitalCheckText" onkeypress="return /[a-z ]/i.test(event.key)" name="c_lastname">
											</div>											
										</div>
										
										<div class="col-md-6">
											<div class="form-group">
											  <label>Contact Reason</label>
											  <select class="form-control singleSelect" name="c_reason">												
													<?php echo hth_dropdown_3d_options($callreason_list); ?>
											  </select>
											</div>											
										</div>
										
										<div class="col-md-6">
											<div class="form-group">
											  <label>Sub Reason</label>
											  <select class="form-control singleSelect" name="c_sub_reason" style="width:100%">
													<?php echo hth_dropdown_3d_options($callsubreason_list); ?>
											  </select>
											</div>
										</div>
										
										<div class="col-md-6">
											<div class="form-group">
											  <label>Call Back</label>
											  <input type="radio" class="" name="c_call_back" value="Yes" required>	 <span style="font-size:12px">Yes</span> &nbsp;&nbsp;		
											  <input type="radio" class="" name="c_call_back" value="No" required> <span style="font-size:12px">No</span>
											</div>											
										</div>
										
										
										<div class="col-md-6">
											<div class="form-group">
											  <label>Disposition Type <span class="text-danger font-weight-bold">*</span></label>
											  <select class="form-control" name="c_disposition_type" required>
												<?php echo hth_dropdown_3d_options($disposition_type); ?>	
											  </select>
											</div>											
										</div>
										
										
										<div class="col-md-12">
											<div class="form-group">
											  <label>Comments <span class="text-danger font-weight-bold">*</span></label>
											  <textarea class="form-control capitalCheckText" name="c_comments" required></textarea>
											</div>									
										</div>
										
									</div>								
								</div>
						    </div>
					</div>
					
					<div class="col-sm-12">						
						<div class="body-widget text-center">
							<button type="submit" name="data_submission" class="submit-btn">Submit</button>
						</div>
					</div>
					
				</div>
			</form>	
			</div>
		</div>
		
		

<div class="modal fade" id="successTicketsModal" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="successTicketsModal" aria-hidden="true">
  <div class="modal-dialog modal-lg" style="width:60%">
    <div class="modal-content">
      <div class="modal-header">        
        <h4 class="modal-title">Ticket Details</h4>
		<button type="button" class="close" data-dismiss="modal" data-toggle="validator" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">	  
	  <div class="row">
	  <div class="col-md-12">
		<h3>Welcome to Harhith Retail Expansion Project of HAICL.</h3><br/>
		<h3>Your Ticket No for <u>Call Type - <span id="finalTicketCall" class="text-primray font-weight-bold"></span></u> is,</h3> 
		<br/><h2><i class="fa fa-ticket"></i> <span id="finalTicketNo" class="text-success font-weight-bold"></span></h2>
		<br/><h3>You can reach us @ 9517951711</h3>
		<br/><br/>
	  </div>	  
	  </div>	  
      <div class="modal-footer">	 
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
</div>


<div class="modal fade" id="errorTicketsModal" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="errorTicketsModal" aria-hidden="true">
  <div class="modal-dialog modal-lg" style="width:60%">
    <div class="modal-content">
      <div class="modal-header">        
        <h4 class="modal-title">Ticket Details</h4>
		<button type="button" class="close" data-dismiss="modal" data-toggle="validator" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">	  
	  <div class="row">
	  <div class="col-md-12">
		<h3>Oops Something Went Wrong, </h3><br/>
		<h2>We we unable to add the ticket <i class="fa fa-warning"></i></h2>
		<br/><br/>
	  </div>	  
	  </div>	  
      <div class="modal-footer">	 
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
</div>