<style>
	td{
		font-size:10px;
	}
	
	#default-datatable th{
		font-size:11px;
	}
	#default-datatable th{
		font-size:11px;
	}
	
	.table > thead > tr > th, .table > thead > tr > td, .table > tbody > tr > th, .table > tbody > tr > td, .table > tfoot > tr > th, .table > tfoot > tr > td {
		padding:3px;
	}
	
</style>

<div class="wrap">
	<section class="app-content">
		<div class="row">
		
		<!-- DataTable -->
		<div class="col-md-12">
				<div class="widget">
					<header class="widget-header">
						<h4 class="widget-title">All Candidate List</h4>
					</header><!-- .widget-header -->
					<hr class="widget-separator">
							
					<div class="widget-body">
					
						<!--<form id="form_new_user" method="GET" action="<?php //echo base_url('dfr'); ?>">-->
						<?php echo form_open('',array('method' => 'get')) ?>
						
							<div class="row">
								<div class="col-md-3">
									<div class="form-group">
										<label>Added Candidates - Date From</label>
										<input type="text" id="date_from" name="date_from" value="<?php echo mysql2mmddyy($date_from); ?>" class="form-control" autocomplete="off" >
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<label>Added Candidates - Date To</label>
										<input type="text" id="date_to" name="date_to" value="<?php echo mysql2mmddyy($date_to); ?>" class="form-control" autocomplete="off" >
									</div>
								</div>
								
								<div class="col-md-2">
									<div class="form-group">
										<label>Location</label>
										<select class="form-control" name="office_id" id="foffice_id" >
											<?php
												//if(get_global_access()==1 || get_role_dir()=="super") echo "<option value='ALL'>ALL</option>";
											?>
											<?php foreach($location_list as $loc): ?>
												<?php
												$sCss="";
												if($loc['abbr']==$oValue) $sCss="selected";
												?>
											<option value="<?php echo $loc['abbr']; ?>" <?php echo $sCss;?>><?php echo $loc['office_name']; ?></option>
												
											<?php endforeach; ?>
																					
										</select>
									</div>
								</div>
									
								<div class="col-md-1" style="margin-top:25px">
									<div class="form-group">
										<button class="btn btn-success waves-effect" a href="<?php echo base_url()?>dfr/all_candidate_lists" type="submit" id='btnView' name='btnView' value="View">Search</button>
									</div>
								</div>
							</div>
							
						</form>	
						</br>
						
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<input type="text" id="myInput" class="form-control" autocomplete="off" placeholder="Search Here...">
							</div>
						</div>
					</div>
					
					<div class="row">
						<div class="table-responsive">							
							<table id="default-datatable" data-plugin="DataTable" class="table table-striped" cellspacing="0" width="100%">
								<thead>
									<tr class='bg-info'>
										<th>SL</th>
										<th>Requision Code</th>
										<th><b>Candidate Name</b></th>
										<th>Hiring Source</th>
										<th>Gender</th>
										<th>Mobile</th>
										<th>DOB</th>
										<th>State</th>
										<th>City</th>
										<th>Postcode</th>
										<th>Country</th>
										<th><b>Status</b></th>
										<th>Added Date/Time</th>
									</tr>
								</thead>
								<tbody id="myTable">
									<?php $i=1;
										foreach($list_candidates as $row): 
										
										$rid=$row['rid']; //echo $rid;
										
										if($row['candidate_status']=='P'){
											$status="Pending";
										}else if($row['candidate_status']=='IP'){
											$status="In Progress";
										}else if($row['candidate_status']=='SL'){
											$status="Shortlisted";
										}else if($row['candidate_status']=='CS'){
											$status="Candidate Selected";
										}else if($row['candidate_status']=='E'){
											$status="Candidate Select as Employee";
										}else if($row['candidate_status']=='D'){
											$status="Dropped Candidate";
										}else{
											$status="Rejected";
										}
										
										if($row['requisition_status']=='CL'){
											$fcolor="style='color:red'";
										}else{
											$fcolor="";
										}
										?>
									<tr>
										<td><?php echo $i++; ?></td>
										
										<td style='font-weight:bold'><a href="<?php echo base_url(); ?>dfr/view_requisition/<?php echo $rid; ?>" target="_blank" <?=$fcolor;?> ><?php echo $row['req_id']; ?></a></td>
										
										<td><b><?php echo $row['fname']." ".$row['lname']; ?></b></td>
										<td><?php echo $row['hiring_source']; ?></td>
										<td><?php echo $row['gender']; ?></td>
										<td><?php echo $row['phone']; ?></td>
										<td><?php echo $row['d_o_b']; ?></td>
										<td><?php echo $row['state']; ?></td>
										<td><?php echo $row['city']; ?></td>
										<td><?php echo $row['postcode']; ?></td>
										<td><?php echo $row['country']; ?></td>
										<td><b><?php echo $status; ?></b></td>
										<td><?php echo $row['added_date']; ?></td>
									</tr>
									<?php endforeach; ?>
								</tbody>
								
							</table>
							
						</div>
						
					</div>	
					
					</div>
			
			
				</div><!-- .widget -->
			</div>
			<!-- END DataTable -->	
		</div><!-- .row -->
	</section>
	
</div><!-- .wrap -->
