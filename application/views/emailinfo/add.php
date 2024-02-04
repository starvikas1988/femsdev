<div class="wrap">
	<section class="app-content">
		<div class="row">
			<div class="col-md-12">
				<div class="widget">
					<header class="widget-header">
						<h4 class="widget-title">Add a Email Notification</h4>
					</header>
					<hr class="widget-separator"/>
					<div class="widget-body clearfix">
						
						<?php 
							if($error!='') echo $error;
						?>
						
						<?php echo form_open('') ?>
														
							<div class="form-group">
								<label for="client_id">Select a Client</label>
								<select class="form-control" name="client_id" id="client_id" required >
									<option value=''>-Select a Client-</option>
									<?php foreach($client_list as $client): ?>
										<?php
										$sCss="";
										if($client->id==$cValue) $sCss="selected";
										?>
										<option value="<?php echo $client->id; ?>" <?php echo $sCss;?>><?php echo $client->shname; ?></option>
										
									<?php endforeach; ?>
																			
								</select>
							</div>
	
	
							<div class="form-group">
								<label for="sch_for">Notify For:</label>
								<!--<input type="text" class="form-control" id="sch_for" placeholder="Notify For" name="sch_for" required>-->
								<select required name="sch_for" class="form-control" id="sch_for" required>
									<option value=''>-Select Notification-</option>
									<option value='TREMRTICKET'>Request for Term Ticket</option>
									<option value='5DAYOFFLINE'>5 DAY OFFLINE</option>
									<option value='LOA'>Leave of Absence</option>
									<option value='NCNS'>No Call No Show</option>
									<option value='LTLOGIN'>Late Login</option>
									<option value='TERMSUSER'>Termination User</option>
									<option value='TERMSUSERPRE'>Pre Termination User</option>
									<option value='ATTRITION'>Attrition</option>
									<option value='ABSENTEEISM'>Absenteeism</option>
									
								</select>
							</div>
							
							<div class="form-group">
								<label for="email_id">Email ID</label>
								<input type="text" class="form-control" id="email_id" placeholder="Email ID" name="email_id" required>
							</div>
							
							<div class="form-group">
								<label for="email_subject">Email Subject</label>
								<input type="text" class="form-control" id="email_subject" placeholder="Email Subject" name="email_subject" required>
							</div>
							
							<div class="form-group">
								<label for="email_body">Email Body:</label>
								<textarea  class="form-control" rows="2" id="email_body" name="email_body" ></textarea> 
							</div>
							
							<div class="col-md-12 text-center">
								<input type="submit" name="submit" class="btn btn-primary btn-md" value="Add">
								<button type="submit" class="btn btn-success btn-md" style="display:none">Edit</button>
								<button type="reset" class="btn btn-danger btn-md" id="reset">Reset</button>	
							</div>
							
						</form>
			
			        </div>
		</div><!-- .row -->

	</section>
	
</div><!-- .wrap -->