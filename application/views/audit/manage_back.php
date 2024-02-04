<style>
	td{
		font-size:11px;
	}
	
	#default-datatable th{
		font-size:12px;
	}
	#default-datatable th{
		font-size:12px;
	}
	
	.table > thead > tr > th, .table > thead > tr > td, .table > tbody > tr > th, .table > tbody > tr > td, .table > tfoot > tr > th, .table > tfoot > tr > td {
		padding:6px;
	}
	
	.modal-dialog{
		width:750px;
	}
	
	td.details-control {
	background: url('<?php echo base_url()?>assets/images/details_open.png') no-repeat center center;
	cursor: pointer;
}
	
tr.shown td.details-control {
	background: url('<?php echo base_url()?>assets/images/details_close.png') no-repeat center center;
	cursor: pointer;
}
	
</style>

<div class="wrap">
	<section class="app-content">
		<div class="row">
		
		<!-- DataTable -->
		<div class="col-md-12">
				<div class="widget">
					<header class="widget-header">
						<h4 class="widget-title">Audit </h4>
					</header><!-- .widget-header -->
					<hr class="widget-separator">
					<div class="widget-body">
					
						<div class="row">
						
						<?php //echo form_open('') ?>
						<?php echo form_open('',array('method' => 'get')) ?>
							
							<div class="col-md-2">
								<div class="form-group">
									<label for="client_id">Select a Client</label>
									<select class="form-control" name="client_id" id="fclient_id" >
										<option value='ALL'>ALL</option>
										<?php foreach($client_list as $client): ?>
											<?php
											$sCss="";
											if($client->id==$cValue) $sCss="selected";
											?>
											<option value="<?php echo $client->id; ?>" <?php echo $sCss;?>><?php echo $client->shname; ?></option>
											
										<?php endforeach; ?>
																				
									</select>
								</div>
							<!-- .form-group -->
							</div>
							
	<?php
	if($cValue==1){
		$sHid="";
		$oHid='style="display:none;"';
	}else{
		$oHid="";
		$sHid='style="display:none;"';
	}
	?>						
							
							<div class="col-md-2">
								<div class="form-group" id="fsite_div" <?php echo $sHid;?> >
									<label for="site_id">Select a Site</label>
									<select class="form-control" name="site_id" id="fsite_id" >
										<option value='ALL'>ALL</option>
										<?php foreach($site_list as $site): ?>
											<?php
											$sCss="";
											if($site->id==$sValue) $sCss="selected";
											?>
											<option value="<?php echo $site->id; ?>" <?php echo $sCss;?>><?php echo $site->name; ?></option>
											
										<?php endforeach; ?>
																				
									</select>
								</div>
									
								<div class="form-group" id="foffice_div" <?php echo $oHid;?>>
									<label for="office_id">Select a Location</label>
									<select class="form-control" name="office_id" id="foffice_id" >
										<option value='ALL'>ALL</option>
										<?php foreach($location_list as $loc): ?>
											<?php
											$sCss="";
											if($loc['abbr']==$oValue) $sCss="selected";
											?>
										<option value="<?php echo $loc['abbr']; ?>" <?php echo $sCss;?>><?php echo $loc['office_name']; ?></option>
											
										<?php endforeach; ?>
																				
									</select>
								</div>
								
							<!-- .form-group -->
							</div>

							<div class="col-md-2">
								<div class="form-group">
								<label for="process_id">Select a process</label>
								<select class="form-control" name="process_id" id="fprocess_id" >
									<option value='ALL'>ALL</option>
									<?php foreach($process_list as $process): ?>
										<?php
											$sCss="";
											if($process->id==$pValue) $sCss="selected";
										?>
										<option value="<?php echo $process->id; ?>" <?php echo $sCss;?> ><?php echo $process->name; ?></option>
										
									<?php endforeach; ?>
																			
								</select>
								</div>
							<!-- .form-group -->
							</div>
							
							
							<div class="col-md-2">
								<div class="form-group">
								<label for="sub_process_id">Select a sub process</label>
								<select class="form-control" name="sub_process_id" id="fsub_process_id" >
									<option value='ALL'>ALL</option>
									<?php foreach($sub_process_list as $sub_process): ?>
										<?php
											$sCss="";
											if($sub_process->id==$pValue) $sCss="selected";
										?>
										<option value="<?php echo $sub_process->id; ?>" <?php echo $sCss;?> ><?php echo $sub_process->name; ?></option>
										
									<?php endforeach; ?>
									
								</select>
								</div>
							<!-- .form-group -->
							</div>
							
							<!-- 
							<div class="col-md-2">
								<div class="form-group">
								<label for="role">Select a Designation</label>
										<select class="form-control" name="role_id" required>
											<option value='ALL'>ALL</option>
											<?php foreach($roll_list as $roll): ?>
												<?php
													$sCss="";
													if($roll->id==$rValue) $sCss="selected";
												?>
												<option value="<?php echo $roll->id; ?>" <?php echo $sCss;?> ><?php echo $roll->name; ?></option>
												
											<?php endforeach; ?>
											
										</select>
								</div>
							</div>
							-->
							
								<div class="col-md-2">
								<div class="form-group">
								<br>
								<input type="submit" class="btn btn-primary btn-md" id='showReports' name='showReports' value="Show">
								</div>
							</div>
							</form>
							
							</div><!-- .row -->
					
					
						<div class="table-responsive">
							<table id="default-datatable" data-plugin="DataTable" class="table table-striped" cellspacing="0" width="100%">
								<thead>
									<tr>
										<th></th>
										<th></th>
										<th>Fusion ID</th>
										<th>Name</th>
										<th>Office</th>
										<th>Client</th>
										<th>Process</th>										
										<th>Call Date</th>
										<th>Call type</th>
										<th>Recording ID</th>
										<th>aht</th>
										<th>Audit Date</th>
										<th>Audit By</th>
										<th>Auditor Name</th>
									</tr>
								</thead>
								
								<tfoot>
									<tr>
										<th></th>
										<th>SL</th>
										<th>Fusion ID</th>
										<th>Name</th>
										<th>Office</th>
										<th>Client</th>
										<th>Process</th>										
										<th>Call Date</th>
										<th>Call type</th>
										<th>Recording ID</th>
										<th>aht</th>
										<th>Audit Date</th>
										<th>Audit By</th>
										<th>Auditor Name</th>
									</tr>
								</tfoot>
	
								<tbody>
								
								<?php 
									$cnt=1;
									foreach($audit_list as $user): 
									$rowcnt=0;
									if($user['score_id']!="") $rowcnt +=2;
								?>
									<tr>
									
										
									
										<?php
																						
											if($rowcnt>0) echo "<td class='details-control'>&nbsp;&nbsp;</td>";
											else echo "<td>&nbsp;&nbsp;</td>";
											
											echo "<td>".$cnt++."</td>";
											
										?>
										
										<td><?php echo $user['fusion_id']; ?></td>
										<td><?php echo $user['fname'] . " ". $user['lname']; ?></td>
										<td><?php echo $user['office_name']; ?></td>
										<td><?php echo $user['client_name']; ?></td>
										<td><?php echo $user['process_name']." ".$user['sub_process_name']; ?></td>
										
										<td><?php echo $user['call_date']; ?></td>
										<td><?php echo $user['call_type']; ?></td>										
										<td><?php echo $user['recording_id']; ?></td>
										<td><?php echo $user['aht']; ?></td>
										<td><?php echo $user['audit_date']; ?></td>
										<td><?php echo $user['audit_by']; ?></td>
										<td><?php echo $user['score_id']; ?></td>
										
									</tr>
									<?php
										if($user['score_id']!=""){
									?>
									<tr style='display:none'>
										<td colspan=14 style="padding-left:50px;">
											<?php
											if($user['score_id']!=""){
											?>
											<table  class='tableScore' cellspacing="0" width="100%" >
												<tr>
													<td>Opening</td>
													<td>Compliance</td>
													<td>Efficiency</td>
													<td>Rapport</td>
													<td>Sales</td>										
													<td>Etiquette</td>
													<td>Closing</td>
													<td>Overall Score</td>
													<td>Comments</td>
													<td>Compliant Recording</td>												
												</tr>	
												<tr>
													
													<td><?php echo $user['opening']; ?></td>
													<td><?php echo $user['compliance']; ?></td>
													<td><?php echo $user['efficiency']; ?></td>
													<td><?php echo $user['rapport']; ?></td>
													<td><?php echo $user['sales']; ?></td>										
													<td><?php echo $user['etiquette']; ?></td>
													<td><?php echo $user['closing']; ?></td>
													<td><?php echo $user['overall_score']; ?></td>
													<td><?php echo $user['comments']; ?></td>
													<td><?php echo $user['compliant_recording']; ?></td>
													
												</tr>									
											</table>
											<?php
											}
											?>
											
											<?php
												if($user['coaching_id']!=""){
											?>
											
											<table class='tableCoach' cellspacing="0" width="100%">
												<tr>
													<td>Coach Name</td>
													<td>Coaching Date</td>
													<td>Review Type</td>
													<td>Best part of call</td>
													<td>Focus Area</td>										
													<td>Time Spent</td>
													<td>next_coaching_date</td>
													<td>Overall Score</td>
													<td>Comments</td>																							
												</tr>	
												<tr>
													
													<td><?php echo $user['coach_name']; ?></td>
													<td><?php echo $user['coaching_date']; ?></td>
													<td><?php echo $user['review_type']; ?></td>
													<td><?php echo $user['best_part']; ?></td>
													<td><?php echo $user['focus_area']; ?></td>										
													<td><?php echo $user['time_spent']; ?></td>
													<td><?php echo $user['next_coaching_date']; ?></td>
													<td><?php echo $user['next_coaching_poa']; ?></td>
													<td><?php echo $user['comment']; ?></td>
													
													
												</tr>									
											</table>
											
											<?php
												}
											?>
									
											
											</td>
										</tr>
									
									<?php
										}
									?>
									
											
								<?php endforeach; ?>
										
								</tbody>
							</table>
						</div>
					</div><!-- .widget-body -->
				</div><!-- .widget -->
			</div>
			<!-- END DataTable -->	
			
		</div><!-- .row -->
	</section>
	
<!-- Default bootstrap-->

<div class="modal fade" id="termsModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
		
		<form class="frmTermsUser" onsubmit="return false" method='POST'>
			
			<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="myModalLabel">Terminatation User</h4>
			</div>
			
			<div class="modal-body">
								
				<input type="hidden" class="form-control" id="tuid" name="tuid" required>
				
				
				<div class="form-group">
					<label for="terms_date">Termination Date:</label>
					<input type="text" class="form-control" id="terms_date" placeholder="Enter Termination Date" name="terms_date" required>
				</div>
				
				<div class="form-group">
					<label for="ticket_no">Ticket No:</label>
					<input type="text" class="form-control" id="ticket_no" placeholder="Enter Ticket No" name="ticket_no" required>
				</div>
			
				<div class="form-group">
					<label for="name">Comments:</label>
					<textarea rows="4" cols="50" class="form-control" id="comments" placeholder="Enter Comments" name="comments" required></textarea>
				</div>
				
			</div>
	  
	   
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" id='terminateUser' class="btn btn-primary">Terminate user</button>
      </div>
	  
		</form>
	
	</div>
   </div>
</div>

</div><!-- .wrap -->



<div class="modal fade" id="sktModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
	 
	  
	<form class="editUser" data-toggle="validator" onsubmit="return false" method='POST'>
		
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Update User</h4>
      </div>
      <div class="modal-body">
								
			<input type="hidden" class="form-control" id="uid" name="uid" required>
			
			<input type="hidden" class="form-control" id="old_role_id" name="old_role_id" required>
						
			<div class="row">
							
				<div class="col-md-6">
					
					<div class="form-group">
					<label for="role">Select The Employees' Office Location</label>
							<select class="form-control" name="office_id" id="office_id" required>
								<option value=''>-- Select a Location --</option>
								<?php foreach($location_list as $loc): ?>
									<option value="<?php echo $loc['abbr'];?>"><?php echo $loc['office_name'];?></option>
								<?php endforeach; ?>
																		
							</select>
					</div>
				</div>
				
				<div class="col-md-6">
					<div class="form-group">
						<label for="fudion_id">Fusion ID:</label>
						<input type="text" class="form-control" placeholder=""  id="fusion_id" name="fusion_id" readonly required>
					</div>
				</div>
				
				
			</div>
							
			<div class="row">
				
				<div class="col-md-6">
				
					<div class="form-group">
					<label for="role">Select The Employee Department</label>
							<select class="form-control" name="dept_id" id="dept_id" required>
								
								<option value="6">Operations</option>
								
								<option value=''>-- Select a Department --</option>
								<?php foreach($department_list as $dept): ?>
									<option value="<?php echo $dept['id'];?>"><?php echo $dept['description'];?></option>
								<?php endforeach; ?>
								
																		
							</select>
					</div>
					
				</div>
								
				
				<div class="col-md-6">
					<div class="form-group">
						<label for="email">Official OM Id (For STI User Only)</label>
						<input type="text" class="form-control" id="omuid" placeholder="Enter OM Id" name="omuid" >
					</div>
				</div>
				
				
			</div>
			
			
			<div class="row">
				<div class="col-md-6">
				<div class="form-group">
					<label for="name">First Name</label>
					<input type="text" class="form-control" id="fname" placeholder="First Name" name="fname" required>
				</div>
				</div>
				
				<div class="col-md-6">
				<div class="form-group">
					<label for="name">Last Name</label>
					<input type="text" class="form-control" id="lname" placeholder="Last Name" name="lname" required>
				</div>
				</div> 
			</div>
			
			<div class="row">
				<div class="col-md-4">
				<div class="form-group">
					<label for="doj">Joining Date:</label>
					<input type="text" class="form-control" id="doj" placeholder="Joining Date" name="doj">
					
				</div>
				</div>
				<div class="col-md-4">
				<div class="form-group">
				
					<label for="name">Email ID:</label>
					<input type="email" class="form-control" id="email_id" placeholder="Email ID" name="email_id">
					
				</div>
				</div>
				<div class="col-md-4">
				<div class="form-group">
					<label for="phno">Phone No:</label>
					<input type="text" class="form-control" id="phno" placeholder="Phone No" name="phno">
				</div>
				</div>
			</div>
			
			<div class="row">
							
				<div class="col-md-4">
				<div class="form-group">
				<label for="client">Select a Client</label>
						<select class="form-control" name="client_id" id="client_id">
							<option value=''>-- Select a Client --</option>
							<?php foreach($client_list as $client): ?>
								<option value="<?php echo $client->id ?>"><?php echo $client->shname ?></option>
							<?php endforeach; ?>
						</select>
				</div>
				</div>
				
				<div class="col-md-4">
				<div class="form-group" id="site_div" style="display:none1;">
				<label for="site_id">Select a Site</label>
						<select class="form-control" name="site_id" id="site_id" >
							<option value=''>-- Select a Site --</option>
							<?php foreach($site_list as $site): ?>
								<option value="<?php echo $site->id ?>"><?php echo $site->name ?></option>
							<?php endforeach; ?>
																	
						</select>
				</div>
				</div>
											
			</div>
						
			<div class="row">
				
				<div class="col-md-4">
				<div class="form-group" id="role_div" style="display:none1;">
				<label for="role">Select a Designation</label>
						<select class="form-control" name="role_id" id="role_id" required>
							<option value=''>-- Select a Designation --</option>
							<?php foreach($roll_list as $role): ?>
								<option value="<?php echo $role->id ?>"><?php echo $role->name ?></option>
							<?php endforeach; ?>
																	
						</select>
				</div>
				</div>
				
				<div class="col-md-4">
				<div class="form-group" id="process_div" style="display:none1;">
				<label for="process_id">Select a Process</label>
						<select class="form-control" name="process_id" id="process_id" >
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
				<div class="form-group" id="assigned_to_div" style="display:none1;">
				<label for="assigned_to">Assign TL/Supervisor/Trainer</label>
						<select class="form-control" name="assigned_to" id="assigned_to">
							<option value=''>-- Select a TL/Supervisor/Trainer --</option>
							<?php foreach($tl_list as $tl): ?>
								<option value="<?php echo $tl->id ?>"><?php echo $tl->tl_name ?></option>
							<?php endforeach; ?>
																	
						</select>
				</div>
				</div>
				
			</div>
			
			
      </div>
	  
	   
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" id='updateUser' class="btn btn-primary">Save changes</button>
      </div>
	  
	 </form>
	  
    </div>
  </div>
</div>