

<div class="wrap">
	<section class="app-content">
		
		<div class="row">
			<div class="col-md-12">
				<div class="widget">
					<div class="row">
						<div class="col-md-10">
							<header class="widget-header">
								<h4 class="widget-title">Requisition List</h4>
							</header>
						</div>	
						<hr class="widget-separator">
					</div>
					
					<div class="widget-body">
						
					<form id="form_new_user" method="GET" action="<?php echo base_url('client_dfr/requisition_report'); ?>">	
					 <?php echo form_open('',array('method' => 'get')) ?>
						
						<div class="row">
							<div class="col-md-2">
								<div class="form-group">
									<label>Due Date From</label>
									<input type="text" id="date_from" name="date_from" value="<?php echo mysql2mmddyy($date_from); ?>" class="form-control reqFilter" autocomplete="off" required>
								</div>
							</div>
							<div class="col-md-2">
								<div class="form-group">
									<label>Due Date To</label>
									<input type="text" id="date_to" name="date_to" value="<?php echo mysql2mmddyy($date_to); ?>" class="form-control reqFilter" autocomplete="off" required>
								</div>
							</div>
							
							<div class="col-md-2" >
								<div class="form-group" id="foffice_div">
									<label for="office_id">Select a Location</label>
									<select class="form-control reqFilter" name="office_id" id="fdoffice_id" >
										<?php foreach($location_list as $loc): ?>
											<?php
											$sCss="";
											if($loc['abbr']==$office_id) $sCss="selected";
											?>
										<option value="<?php echo $loc['abbr']; ?>" <?php echo $sCss;?>><?php echo $loc['office_name']; ?></option>
											
										<?php endforeach; ?>
																				
									</select>
								</div>
							</div>
																					
						</div>
						<div class="row">
													
							<div class="col-md-3">
								<div class="form-group">
									<label>Select Process</label>
																		
								<?php
									echo '<select name="process" class="form-control">';
									
									foreach($process_list as $key=>$value)
									{
										$sCss="";
										if($value['id']==$process) $sCss="selected";
									
										echo '<option value="'.$value['id'].'" '.$sCss.'>'.$value['name'].'</option>';
									}
									echo '</select>';
								?>
								
								</div>
							</div>
							<div class="col-md-1" style='margin-top:2px;'>
								<div class="form-group">
									</br>
									<button class="btn btn-primary waves-effect" a href="<?php echo base_url()?>reports/requisition_report" type="submit" id='show' name='show' value="Show">SHOW</button>
								</div>
							</div>
							
							<?php if($download_link!=""){ ?>
								<div style='float:right; margin-top:25px;' class="col-md-2">
									<div class="form-group" style='float:right;'>
										<a href='<?php echo $download_link; ?>' <span style="padding:12px;" class="label label-success">Export Report</span> </a>		
									</div>
								</div>
							<?php } ?>
							
						</div>
						
					</form>	
						
						<div class="table-responsive">
							<table id="default-datatable" data-plugin="DataTable" class="table table-striped skt-table" cellspacing="0" width="100%">
								<thead>
									<tr class='bg-info'>
										<th>SL</th>
										<th>Requisition ID</th>
										<th>Location</th>
										<th>Due Date</th>
										<th>Req Type</th>
										<th>Department</th>
										<th>Client</th>
										<th>Process</th>
										<th>Role</th>
										<th>Req. Qualification</th>
										<th>Req. Exp. Range</th>
										<th>Position Required</th>
										<th>Total Applied</th>
										<th>Total Shortlisted</th>
										<th>Position Filled</th>
										<th>Batch Code</th>
										<th>Req. Skill</th>
										<th>Raised By</th>
										<th>Status</th>
										<th>Approved/Decline By</th>
									</tr>
								</thead>
								<tbody>
									<?php  
										$i=1;
										foreach($requisition_list as $rl):
										
										if($rl['requisition_status']=='A') $status='Approved';
										else if($rl['requisition_status']=='C') $status='Cancel';
										else if($rl['requisition_status']=='P') $status='Pending';
										else $status='Decline';
									?>
									<tr>
										<td><?php echo $i++; ?></td>
										<td><?php echo $rl['requisition_id']; ?></td>
										<td><?php echo $rl['off_location']; ?></td>
										<td><?php echo $rl['due_date']; ?></td>
										<td><?php echo $rl['req_type']; ?></td>
										<td><?php echo $rl['dept_name']; ?></td>
										<td><?php echo $rl['client_name']; ?></td>
										<td><?php echo $rl['process_name']; ?></td>
										<td><?php echo $rl['role_name']; ?></td>
										<td><?php echo $rl['req_qualification']; ?></td>
										<td><?php echo $rl['req_exp_range']; ?></td>
										<td><?php echo $rl['req_no_position']; ?></td>
										<td><?php echo $rl['candidate_applied']; ?></td>
										<td><?php echo $rl['shortlisted_candidate']; ?></td>
										<td><?php echo $rl['count_canasempl']; ?></td>
										<td><?php echo $rl['job_title']; ?></td>
										<td><?php echo $rl['req_skill']; ?></td>
										<td><?php echo $rl['raised_name']; ?></td>
										<td><?php echo $status; ?></td>
										<td><?php echo $rl['approved_name']; ?></td>
									</tr>
									<?php endforeach; ?>
								</tbody>
								<tfoot>
									<tr class='bg-info'>
										<th>SL</th>
										<th>Requisition ID</th>
										<th>Location</th>
										<th>Due Date</th>
										<th>Req Type</th>
										<th>Department</th>
										<th>Client</th>
										<th>Process</th>
										<th>Role</th>
										<th>Req. Qualification</th>
										<th>Req. Exp. Range</th>
										<th>Position Required</th>
										<th>Total Applied</th>
										<th>Total Shortlisted</th>
										<th>Position Filled</th>
										<th>Batch Code</th>
										<th>Req. Skill</th>
										<th>Raised By</th>
										<th>Status</th>
										<th>Updated By</th>
									</tr>
								</tfoot>
							</table>
						</div>
						
						
					</div>
					
				</div>
			</div>
		</div>
	
	</section>
</div>

