
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
				
				<form method="POST" autocomplete="off" action= "harhithpopupapi/submit_ticket" enctype="multipart/form-data">
					<div class="row newTicketEnquiry">
					
						<div class="col-sm-6">
							<div class="card">
								<div class="card-body">
									<h2 class="heading-title">
										Call Information
									</h2>
									<div class="row">
									
									<input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>"  />
									
									<input type="hidden" class="form-control" value="<?php echo $current_user_id; ?>" name="c_ticket_uid" required readonly>
									
									<input type="hidden" class="form-control" value="<?php echo $duniqueid; ?>" name="duniqueid" required readonly>
									
									<input type="hidden" class="form-control" value="<?php echo $dcphone; ?>" name="dcphone" required readonly>
									
									<input type="hidden" class="form-control" value="<?php echo $dcallstime; ?>" name="dcallstime" required readonly>
									
									<input type="hidden" class="form-control" value="<?php echo $dpcall; ?>" name="dpcall" required readonly>
									
										<div class="col-md-4">
											<div class="form-group">
											  <label>Date</label>
											  <input type="date" class="form-control" value="<?php echo $current_date; ?>" name="c_date" required readonly>
											</div>
										</div>
										
										<div class="col-md-4">
											<div class="form-group">
											  <label>Dialer ID</label>
											  <input type="text" class="form-control" value="<?php echo $duserid; ?>" name="duserid" required readonly>
											</div>
										</div>
										
																																						
										<div class="col-md-4">
											<div class="form-group">
											  <label>Call Type <span class="text-danger font-weight-bold">*</span></label>
											  <select class="form-control" name="c_call_type" required>
												<?php echo hth_dropdown_3d_options($call_type,'id','name',$dpcall); ?>	
											  </select>
											</div>											
										</div>
										
										<div class="col-md-6">
											<div class="form-group">
											  <label>Phone No <span class="text-danger">*</span></label>
											  <input type="text" maxlength="11" placeholder="Starting No (0-5) Not Allowed"  data-inputmask="'mask': ['99999-99999']" data-mask="" inputmode="text" oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*?)\..*/g, '$1');" class="form-control numberCheckPhone" name="c_phone" value="<?php echo $dcphone; ?>" required>
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
												<?php echo hth_dropdown_3d_options($disposition_type,'id','name','1'); ?>	
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
		
	