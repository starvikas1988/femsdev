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
						
						<?php //echo form_open('') ?>
						<?php echo form_open('',array('method' => 'get')) ?>
						
						<div class="row">

							<div class="col-md-2">
								<div class="form-group">
								<label for="start_date">Start Date</label>
								<input type="text" class="form-control" id="start_date" value='<?php echo $start_date; ?>' name="start_date" >
								</div>
							</div>

							<div class="col-md-2">
								<div class="form-group">
								<label for="end_date">End Date</label>
								<input type="text" class="form-control" id="end_date" value='<?php echo $end_date; ?>' name="end_date" >
								</div>
							</div>
						</div>
						
						<div class="row">
						
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
								<br>
								<input type="submit" class="btn btn-primary btn-md" id='showReports' name='showReports' value="Show">
								</div>
							</div>
							
							
					</div><!-- .row -->
					
				</form>
				
				
				<?php 
									
					$audit_list=$all_array[0];
					$all_coach_list=$all_array[1];
					if(!empty($audit_list)){
					
				?>
						
		
						<div class="table-responsive">
							<table id="default-datatable" data-plugin="DataTable" class="table table-striped" cellspacing="0" width="100%">
								<thead>
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
										<th> </th>
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
										<th> </th>
									</tr>
								</tfoot>
	
								<tbody>
								
								<?php 
									
									$cnt=1;
									foreach($audit_list as $user): 
									
									$audit_id=$user['audit_id'];
									$rowcnt=0;
									$coach_list=$all_coach_list[$audit_id];
									
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
										<td><?php echo $user['process_name']; ?></td>
										
										<td><?php echo $user['call_date']; ?></td>
										<td><?php echo $user['call_type']; ?></td>										
										<td><?php echo $user['recording_id']; ?></td>
										<td><?php echo $user['aht']; ?></td>
										<td><?php echo $user['audit_date']; ?></td>
										<td><?php echo $user['audit_by']; ?></td>
										<td><?php echo $user['auditor_name']; ?></td>
										<td>
										<!--
											<a href="#"><button title='' type='button' class='btn btn-primary btn-xs'>Edit</button></a>
										-->
										</td>
										
										
									</tr>
									
									
									<?php
										if($user['score_id']!=""){
									?>
									<tr style='display:none'>
										<td colspan=15 style="padding-left:50px;">
											<?php
											if($user['score_id']!=""){
											?>
											<table  class='tableScore table table-striped skt-table' cellspacing="0" width="100%">
												<thead>
												<tr>
													<th>Opening</th>
													<th>Compliance</th>
													<th>Efficiency</th>
													<th>Rapport</th>
													<th>Sales</th>										
													<th>Etiquette</th>
													<th>Closing</th>
													<th>Overall Score</th>
													<th>Comments</th>
													<th>Compliant Recording</th>												
												</tr>	
												</thead>
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
												if(!empty($coach_list)){
											?>
											
											<table class='tableCoach table table-striped skt-table' cellspacing="0" width="100%">
												<thead>
												<tr>
													<th>Coach Name</th>
													<th>Coaching Date</th>
													<th>Review Type</th>
													<th>Best part of call</th>
													<th>Focus Area</th>										
													<th>Time Spent</th>
													<th>next_coaching_date</th>
													<th>Overall Score</th>
													<th>Comments</th>
												</tr>	
												</thead>
												<?php
													foreach($coach_list as $coach): 
												?>
													<tr>
													
													<td><?php echo $coach['coach_name']; ?></td>
													<td><?php echo $coach['coaching_date']; ?></td>
													<td><?php echo $coach['review_type']; ?></td>
													<td><?php echo $coach['best_part']; ?></td>
													<td><?php echo $coach['focus_area']; ?></td>										
													<td><?php echo $coach['time_spent']; ?></td>
													<td><?php echo $coach['next_coaching_date']; ?></td>
													<td><?php echo $coach['next_coaching_poa']; ?></td>
													<td><?php echo $coach['comment']; ?></td>
													
													
												</tr>
												<?php endforeach; ?>
												
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
						
						
						<?php 
							}else{
							
								echo "Please select the date range";
							
							}
							
						?>
						
					</div><!-- .widget-body -->
				</div><!-- .widget -->
			</div>
			<!-- END DataTable -->	
			
		</div><!-- .row -->
	</section>
	
<!-- Default bootstrap-->


</div><!-- .wrap -->
