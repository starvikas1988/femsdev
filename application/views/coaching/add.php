<style>
#search_agent_rec tr:hover td {
	background: #EAEDCA;
	cursor:pointer;
}

</style>

<div class="wrap">
	<section class="app-content">
		<div class="row">
			<div class="col-md-12">
				<div class="widget">
					<header class="widget-header">
						<h4 class="widget-title">Add Coaching</h4>
					</header>
					<hr class="widget-separator"/>
					<div class="widget-body clearfix">
						<?php 
							if($error!='') echo $error;
						?>
						
						<?php echo form_open('',array('data-toggle'=>'validator')) ?>
							
							
						<div class = "panel panel-info">
						   <div class = "panel-heading">
							  <h3 class = "panel-title">Coaching Information</h3>
						   </div>
						   <div class = "panel-body">
							 

							<div class="row">
								<input type="hidden" class="form-control" id="audit_id" value="<?php echo $audit_id;?>" name="audit_id" required >
								<input type="hidden" class="form-control" id="reDirectUrl" value="<?php echo $reDirectUrl;?>" name="reDirectUrl" required >
								
								<div class="col-md-4">
								<div class="form-group">
								<label for="coach_id">Select a Coach </label>
										<select class="form-control" name="coach_id" id="coach_id" required>
											<option value=''>-- Select a Coach --</option>
											<?php foreach($coach_list as $coach): ?>
												<option value="<?php echo $coach['id'] ?>"><?php echo $coach['name'] ?></option>
											<?php endforeach; ?>
										</select>
								</div>
								</div>
																
								<div class="col-md-4">
									<div class="form-group">
										<label for="coaching_date">Coaching Date</label>
										<input type="text" class="form-control" id="coaching_date" placeholder="Coaching Date" name="coaching_date" required >
									</div>
								</div>
								
								<div class="col-md-4">
									<div class="form-group" id="review_type_div" style="display:none1;">
									<label for="review_type">Select a Review Type</label>
											<select class="form-control" name="review_type" id="review_type" required>
												<option value=''>-- Select a Review Type --</option>
												<option value="Positive">Positive</option>
												<option value="Negative">Negative</option>
												<option value="Both">Both</option>
																			
											</select>
									</div>
								</div>
								
								
								
							</div>
					
							
							<div class="row">
								
								
								<div class="col-md-5">	
									<div class="form-group">
										<label for="best_part">Best Part of call</label>
										<input type="text" class="form-control" id="best_part" placeholder="Best Part of call" name="best_part" required>										
									</div>
								</div>
								
								
							
								<div class="col-md-7">
									<div class="form-group" id="focus_area_div">
									<label for="focus_area">Select a Focus Area</label>
											<select class="form-control" name="focus_area[]" id="focus_area" multiple="multiple">
												<option value=''>-- Select a Focus Area --</option>
												<?php foreach($focus_area_list as $focus_area): ?>
													<option value="<?php echo $focus_area['name'] ?>"><?php echo $focus_area['name'] ?></option>
												<?php endforeach; ?>							
											</select>
									</div>
								</div>
								
								
								
							</div> 
							
							
							<div class="row">
								
								<div class="col-md-4">
									<div class="form-group">
										<label for="next_coaching_date">Next Coaching Date</label>
										<input type="text" class="form-control" id="next_coaching_date" placeholder="Next Coaching Date" name="next_coaching_date" required >
									</div>
								</div>
								
								<div class="col-md-8">
									<div class="form-group">
										<label for="next_coaching_poa">Next Coaching POA</label>
										<input type="text" class="form-control" id="next_coaching_poa" placeholder="Next Coaching POA" name="next_coaching_poa" required >
									</div>
								</div>
								
								
								
							</div> 
							
							<div class="row">
								
								<div class="col-md-4">
									<div class="form-group">
										<label for="time_spent">Time spent coaching (in minutes.)</label>
										<input type="text" class="form-control" id="time_spent" placeholder="" name="time_spent" required> 
									</div>
								</div>
								
																
								<div class="col-md-8">
									<div class="form-group">
										<label for="comment">Comment if any</label>
										<input type="text" class="form-control" id="comment" placeholder="Comment" name="comment">
									</div>
								</div>
								
							</div> 
									
													
						
						<div class="col-md-12 text-center">
							<input type="submit" name="submit" class="btn btn-primary btn-md" value="Add">
							<button type="reset" class="btn btn-danger btn-md" id="reset">Reset</button>	
						</div>
						
					</form>
			   </div>
		</div><!-- .row -->
	</section>
	

<div class="modal fade" id="agentSearchModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
	
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Search Agent by Name</h4>
      </div>
      <div class="modal-body">
			
			<div class="row">
				<div class="col-md-4">
				<div class="form-group">
					<label for="aname">First Name / Last Name</label>
					<input type="text" class="form-control" id="aname" placeholder="First/Last Name" name="aname" required>
				</div>
				</div>
				
				<div class="col-md-1">
				<div class="form-group">
					<center><label for="">OR</label></center>
				</div>
				</div>
				
				<div class="col-md-4">
				<div class="form-group">
					<label for="omuid">Agent OM-ID</label>
					<input type="text" class="form-control" id="aomuid" placeholder="OM ID" name="aomuid" required>
				</div>
				</div> 
				
				<div class="col-md-2">
					<div class="form-group">
						<button  id='fetch_agents' style='margin-top:25px;' type="button" class="btn btn-info">
						  <i class="fa fa-search" aria-hidden="true"></i> Search
						</button>
					</div>
				</div> 
				
			</div>
			
			<div class="row">
				<div class="col-md-12" style='height-min:20px;'>
					<div id='search_agent_rec'>
					
					</div>
				</div>
			</div>
			
	   
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
	  
    </div>
  </div>
</div>
</div>

</div><!-- .wrap -->
