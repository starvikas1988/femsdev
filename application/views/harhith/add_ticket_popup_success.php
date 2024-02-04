
			<div class="row mb-4">
                <div class="col-md-12 grid-margin">
                    <div class="d-flex justify-content-between flex-wrap">
                        <div class="d-flex align-items-center dashboard-header flex-wrap mb-3 mb-sm-0">
                            <h5 class="mr-4 mb-0 font-weight-bold">Success Ticket Submission</h5>                           
                        </div>                        
                    </div>
                </div>
            </div>
						
						
			<div class="common-top">
				<div class="middle-content">
								
					<div class="row ">
					
						<div class="col-sm-12">
							<div class="card">
								<div class="card-body">
									
									<div class="row">
									
										<div class="col-md-12 text-center">
											<br>
											<h2 class="heading-title">
												Successfully created the ticket
											</h2>
											<br>
																			
											<h3>Welcome to Harhith Retail Expansion Project of HAICL.</h3><br/>
											<h3>Your Ticket No is : </h3> <h2><i class="fa fa-ticket"></i> <span class="text-success font-weight-bold"> <?php echo $ticket_no; ?></span></h2>
											<br/><h3>You can reach us @ 9517951711</h3>
		
											<br>
										</div>
																				
									</div>								
								</div>
							</div>
						</div>
						
						<div class="col-sm-12">						
							<div class="body-widget text-center">
								<!-- <button type="submit" name="close_browser" onclick='window.close();'class="submit-btn">Done</button> -->
							</div>
						</div>
					
				</div>
			
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