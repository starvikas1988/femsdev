<style>

td{
		font-size:12px;
	}
	
	#default-datatable th{
		font-size:12px;
	}
	#default-datatable th{
		font-size:12px;
	}
	
	.table > thead > tr > th, .table > thead > tr > td, .table > tbody > tr > th, .table > tbody > tr > td, .table > tfoot > tr > th, .table > tfoot > tr > td {
		padding:3px;
	}
	
	.modal-dialog{
		width:750px;
	}
	
</style>


<div class="wrap">
	<section class="app-content">
	
		<div class="row">
			<div class="col-md-12">
				<div class="widget">
					<header class="widget-header">
						<h4 class="widget-title">Quarterly Job  Performance Evaluation Form</h4>
					</header>
					<hr class="widget-separator"/>
					
						<div style='float:right; margin-top:-45px;' class="col-md-6">
							<div class="form-group" style='float:right;'>
								<a href='<?php echo base_url()?>evaluation/evaluation_self'> <button type='button' class='btn btn-primary btn-sx'>Add Your Job Performance Evaluation </button></a>
							</div>
						</div>
						<br>
					<div class="widget-body clearfix">
						<div class="row">
												
						<div class="table-responsive">
							<table id="default-datatable" data-plugin="DataTable" class="table table-striped" cellspacing="0" width="100%">
								<thead>
									<tr>
										<th>Date</th>
										<th>Period</th>
										<th>Fusion ID</th>
										<th>Name</th>
										<th>Office</th>
										<th>Site</th>
										<th>Dept</th>
										<th>Sub Dept</th>
										<th>Role</th>
										<th>Process</th>
										<th>Status</th>
										<th>Action</th>
									</tr>
								</thead>
								
								<tfoot>
									<tr>
										<th>Date</th>
										<th>Period</th>
										<th>Fusion ID</th>
										<th>Name</th>
										<th>Office</th>
										<th>Site</th>
										<th>Dept</th>
										<th>Sub Dept</th>
										<th>Role</th>
										<th>Process</th>
										<th>Status</th>
										<th>Action</th>
									</tr>
								</tfoot>
								<tbody>
								
								<?php 
									foreach($perform_list as $row): 
									
									$user_id=$row['user_id'];
									$eid=base64_encode($row['id']);
									
									$evaluated_by=$row['evaluated_by'];
									$review_by=$row['review_by'];
									$evaluation_period=$row['evaluation_period'];
									
								?>
									<tr>
										<td><?php echo $row['evaluation_date']; ?></td>
										<td><?php echo $row['evaluation_period']; ?></td>
										<td><?php echo $row['fusion_id']; ?></td>
										<td><?php echo $row['fname'] . " ". $row['lname']; ?></td>
										<td><?php echo $row['office_id']; ?></td>
										<td><?php echo $row['site_name']; ?></td>
										<td><?php echo $row['dept_name']; ?></td>
										<td><?php echo $row['sub_dept_name']; ?></td>
										<td><?php echo $row['role_name']; ?></td>
										<td><?php echo $row['process_name']." ".$row['sub_process_name']; ?></td>
										
										<td>
										<?php
											
											if($review_by!="") echo '<span class="label label-success">Reviewed</span>'; 
											else if($evaluated_by!="") echo '<span class="label label-primary">Evaluated</span>';
											else echo '<span class="label label-danger">Not Evaluated</span>';
											
										?>
										</td>
										<td width='100px;'>
											<button title="View Evaluation Form" eid="<?php echo $eid;?>" type='button' class='viewEvaluation btn btn-info btn-xs'><i class='fa fa-th-list' aria-hidden='true'></i></button>&nbsp;
											
											<?php
												if($evaluated_by=="" || $review_by=="" )
													//echo "<button title='Edit Evaluation Form' eid='$eid' type='button' class='editEvaluation btn btn-primary btn-xs'><i class='fa fa-pencil-square-o' aria-hidden='true'></i></button>&nbsp;";
											?>
											
										</td>
									</tr>
									
											
								<?php endforeach; ?>
										
								</tbody>
							</table>
						</div>
							
							
							

						
						</div>
						
					</div>
				</div>
			</div>
		</div><!-- .row -->
	</section>

</div><!-- .wrap -->
