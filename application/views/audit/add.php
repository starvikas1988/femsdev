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
						<h4 class="widget-title">Add Audit</h4>
					</header>
					<hr class="widget-separator"/>
					<div class="widget-body clearfix">
						<?php 
							if($error!='') echo $error;
						?>
						
						<?php echo form_open('',array('data-toggle'=>'validator')) ?>
							
							
						<div class = "panel panel-info">
						   <div class = "panel-heading">
							  <h3 class = "panel-title">Audit Information</h3>
						   </div>
						   <div class = "panel-body">
							 
							<div class="row">
								
								<div class="col-md-4">
								<div class="form-group">
								<label for="client">Select a Client</label>
										<select class="form-control" name="client_id" id="client_id" required>
											<option value=''>-- Select a Client --</option>
											<?php foreach($client_list as $client): ?>
												<option value="<?php echo $client->id ?>"><?php echo $client->shname ?></option>
											<?php endforeach; ?>
										</select>
								</div>
								</div>
																
								<div class="col-md-4">
									<div class="form-group" id="process_div" style="display:none1;">
									<label for="process_id">Select a Process</label>
											<select class="form-control" name="process_id" id="process_id" required>
												<option value=''>-- Select a Process --</option>
												<?php foreach($process_list as $process): ?>
													<option value="<?php echo $process->id ?>"><?php echo $process->name ?></option>
												<?php endforeach; ?>
																						
											</select>
									</div>
								</div>
								
								
								<div class="col-md-4">
									<div class="form-group" id="sub_process_div" style="display:none1;">
									<label for="sub_process_id">Select a Sub Process</label>
											<select class="form-control" name="sub_process_id" id="sub_process_id" >
												<option value=''>-- Select a Sub Process --</option>
												<?php foreach($sub_process_list as $sub_process): ?>
													<option value="<?php echo $sub_process->id ?>"><?php echo $sub_process->name ?></option>
												<?php endforeach; ?>							
											</select>
									</div>
								</div>
								
								
							</div>
					
							
							<div class="row">
								
								
								<div class="col-md-4">	
									<div class="input-group">
									
										<label for="agent_fusion_id">Agent ID (Fusion ID)</label>
										<input type="text" class="form-control" id="agent_fusion_id" placeholder="Agent Fusion ID" name="agent_fusion_id" required>										
										<div class="input-group-btn">
										<button id='btn_search_agent' style="margin-top:25px;" type="button" class="btn btn-primary">...</button>
										</div>
									</div>
								</div>
								
								<div class="col-md-4">
									<div class="form-group">
										<label for="agent_name">Agent Name</label>
										<input type="text" class="form-control" id="agent_name" placeholder="" name="agent_name" readonly required>
									</div>
								</div>
							
								<div class="col-md-4">
									<div class="form-group">
										<label for="call_date">Call Date</label>
										<input type="text" class="form-control" id="call_date" placeholder="Call Date" name="call_date" required >
									</div>
								</div>
							</div> 
							
							
							<div class="row">
								<div class="col-md-4">
									<div class="form-group" id="call_type_div" >
									<label for="call_type">Select Call Type</label>
											<select class="form-control" name="call_type" id="call_type" required >
												<option value=''>-- Select Call Type --</option>
												<?php foreach($call_type as $call): ?>
													<option value="<?php echo $call['name'] ?>"><?php echo $call['name'] ?></option>
												<?php endforeach; ?>							
											</select>
									</div>
								</div>
								
								<div class="col-md-4">
									<div class="form-group">
										<label for="recording_id">Recording ID</label>
										<input type="text" class="form-control" id="recording_id" placeholder="Recording ID" name="recording_id" required >
									</div>
								</div>
								
								<div class="col-md-4">
									<div class="form-group">
										<label for="aht">AHT</label>
										<input type="text" class="form-control" id="aht" placeholder="AHT" name="aht" required >
									</div>
								</div>
								
							</div> 
									
							<div class="row">
							
								<div class="col-md-4">
								<div class="form-group">
									<label for="audit_date">Audit Date</label>
									<input type="text" class="form-control" id="audit_date" placeholder="Audit Date" name="audit_date" required>
								</div>
								</div>
								
								<div class="col-md-4">
									<div class="form-group" id="audit_by_div" >
									<label for="audit_by">Audit By </label>
											<select class="form-control" name="audit_by" id="audit_by" required>
												<option value=''>-- Select Auditor --</option>
												<option value='Self'>Self</option>
												<option value='Client'>Client</option>
											</select>
									</div>
								</div>

								<div class="col-md-4">
								<div class="form-group">
									<label for="auditor_name">Auditor Name</label>
									<input type="text" class="form-control" id="auditor_name" placeholder="Auditor Name" name="auditor_name" required>
								</div>
								</div> 
								
							</div>
							
							
						   </div>
						</div>
						
						
						<div class = "panel panel-info">
						   <div class = "panel-heading">
							  <h3 class = "panel-title">Score</h3>
						   </div>
						   <div class = "panel-body">
							
							<div class="row">
								<div class="col-md-4">
									<div class="form-group"  >
									<label for="opening">Opening</label>
											<select class="form-control" name="opening" id="opening" required >
												<option value=''>-- Select Opening --</option>
												<?php foreach($audit_score as $srow): ?>
													<option value="<?php echo $srow['name'] ?>"><?php echo $srow['name'] ?></option>
												<?php endforeach; ?>							
											</select>
									</div>
								</div>
								
								<div class="col-md-4">
									<div class="form-group" >
									<label for="compliance">Compliance</label>
											<select class="form-control" name="compliance" id="compliance" required >
												<option value=''>-- Select Compliance --</option>
												<?php foreach($audit_score as $srow): ?>
													<option value="<?php echo $srow['name'] ?>"><?php echo $srow['name'] ?></option>
												<?php endforeach; ?>							
											</select>
									</div>
								</div>
								
								<div class="col-md-4">
									<div class="form-group"  >
									<label for="efficiency">Efficiency</label>
											<select class="form-control" name="efficiency" id="efficiency" required >
												<option value=''>-- Select Efficiency --</option>
												<?php foreach($audit_score as $srow): ?>
													<option value="<?php echo $srow['name'] ?>"><?php echo $srow['name'] ?></option>
												<?php endforeach; ?>							
											</select>
									</div>
								</div>
							</div>
							
							<div class="row">
								<div class="col-md-4">
									<div class="form-group"  >
									<label for="rapport">Rapport</label>
											<select class="form-control" name="rapport" id="rapport" required >
												<option value=''>-- Select Rapport --</option>
												<?php foreach($audit_score as $srow): ?>
													<option value="<?php echo $srow['name'] ?>"><?php echo $srow['name'] ?></option>
												<?php endforeach; ?>							
											</select>
									</div>
								</div>
								
								<div class="col-md-4">
									<div class="form-group"  >
									<label for="sales">Sales</label>
											<select class="form-control" name="sales" id="sales" required >
												<option value=''>-- Select Sales --</option>
												<?php foreach($audit_score as $srow): ?>
													<option value="<?php echo $srow['name'] ?>"><?php echo $srow['name'] ?></option>
												<?php endforeach; ?>							
											</select>
									</div>
								</div>
								
								<div class="col-md-4">
									<div class="form-group"  >
									<label for="etiquette">Etiquette</label>
											<select class="form-control" name="etiquette" id="etiquette" required >
												<option value=''>-- Select Etiquette --</option>
												<?php foreach($audit_score as $srow): ?>
													<option value="<?php echo $srow['name'] ?>"><?php echo $srow['name'] ?></option>
												<?php endforeach; ?>							
											</select>
									</div>
								</div>
							</div>
							
							
							<div class="row">
								<div class="col-md-4">
									<div class="form-group"  >
									<label for="closing">Closing</label>
											<select class="form-control" name="closing" id="closing" required >
												<option value=''>-- Select Closing --</option>
												<?php foreach($audit_score as $srow): ?>
													<option value="<?php echo $srow['name'] ?>"><?php echo $srow['name'] ?></option>
												<?php endforeach; ?>							
											</select>
									</div>
								</div>
								
								<div class="col-md-4">
									<div class="form-group"  >
									<label for="overall_score">Overall Score </label>
											<input type="text" class="form-control" id="overall_score" placeholder="Overall Score" name="overall_score" required>
									</div>
								</div>
								
								<div class="col-md-4">
									<div class="form-group"  >
									<label for="compliant_recording">Compliant Recording</label>
											<select class="form-control" name="compliant_recording" id="compliant_recording" required >
												<option value=''>-- Select Compliant Recording --</option>
												<?php foreach($compliant_score as $srow): ?>
													<option value="<?php echo $srow['name'] ?>"><?php echo $srow['name'] ?></option>
												<?php endforeach; ?>							
											</select>
									</div>
								</div>
								
							</div>
							
							<div class="row">
								
								<div class="col-md-12">
									<div class="form-group"  >
									<label for="comments">Comments</label>
										<input type="text" class="form-control" id="comments" placeholder="Comments" name="comments">
									</div>
								</div>
								
							</div>							
						   </div>
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
					<label for="aomuid">Agent OM-ID</label>
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
