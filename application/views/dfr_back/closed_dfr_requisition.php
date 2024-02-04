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
						<h4 class="widget-title">Closed Requisition</h4>
					</header><!-- .widget-header -->
					<hr class="widget-separator">
							
					<div class="widget-body">
					
						<div class="table-responsive">
							<table id="default-datatable" data-plugin="DataTable" class="table skt-table" cellspacing="0" width="100%">
								<thead>
									<tr class='bg-info'>
										<th>SL</th>
										<th>Requision Code</th>
										<th>Location</th>
										<th>Department</th>
										<th>Due Date</th>
										<th>Position</th>
										<th>Client</th>
										<th>Process</th>
										<th>Batch No</th>
										<th>Required Position</th>
										<th>Filled Position</th>
										<th>Raised By</th>
										<th>Status</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									<?php 
										$i=1;
										foreach($closed_requisition_list as $row):
										
										$rid=$row['id'];
										
										if($row['requisition_status']=='P'){
											$r_status='Pending';
										}else if($row['requisition_status']=='A'){
											$r_status='Approved';
										}else if($row['requisition_status']=='R'){
											$r_status='Reject';
										}else if($row['requisition_status']=='C'){
											$r_status='Cancel';
										}else{
											$r_status='Closed';
										}
									?>
									<tr>
										<td><?php echo $i++; ?></td>
										<td><?php echo $row['requisition_id']; ?></td>
										<td><?php echo $row['off_loc']; ?></td>
										<td><?php echo $row['department_name']; ?></td>
										<td><?php echo $row['dueDate']; ?></td>
										<td><?php echo $row['role_name']; ?></td>
										<td><?php echo $row['client_name']; ?></td>
										<td><?php echo $row['process_name']; ?></td>
										<td><?php echo $row['job_title']; ?></td>
										<td><?php echo $row['req_no_position']; ?></td>
										<td><?php echo $row['filled_no_position']; ?></td>
										<td><?php echo $row['raised_name']; ?></td>
										<td><?php echo $r_status; ?></td>
										<td>
											<?php 											
												
												$params=$row['requisition_id']."#".$row['location']."#".$row['dueDate']."#".$row['department_id']."#".$row['role_id']."#".$row['client_id']."#".$row['process_id']."#".$row['employee_status']."#".$row['req_qualification']."#".$row['req_exp_range']."#".$row['req_no_position']."#".$row['filled_no_position']."#".$row['job_title']."#".$row['job_desc']."#".$row['req_skill']."#".$row['additional_info']."#".$row['raised_name']."#".$row['raised_date']."#".$row['requisition_status'];
												
												echo "<button title='Closed Requisition' type='button' rid='$rid' params='$params' class='btn btn-danger btn-xs closedRequisition' style='font-size:12px'><i class='fa fa-pencil-square-o' aria-hidden='true'></i></button>";
													
											
											?>
										</td>
									</tr>
									<?php endforeach; ?>
								</tbody>
								
							</table>
							
						</div>
					</div>
			
			
				</div><!-- .widget -->
			</div>
			<!-- END DataTable -->	
		</div><!-- .row -->
	</section>
	
</div><!-- .wrap -->

<!----------------------------------------------------------------->

<!-------------------- closed Requisition model ----------------------------->
<div class="modal fade" id="closedRequisitionModel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
	  
	<form class="frmclosedRequisition" action="<?php echo base_url(); ?>dfr/" data-toggle="validator" method='POST'>
		
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Closed Requisition</h4>
      </div>
      <div class="modal-body">
			<input type="text" id="r_id" name="r_id" >
			
			<div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<label>Reason</label>
						<textarea class="form-control" id="closed_comment" name="closed_comment" required></textarea>
					</div>	
				</div>
			</div>
					
      </div>
	  
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		<button type="submit" id='closedRequisition' class="btn btn-primary">Save</button>
      </div>
	  
	 </form>
	 
    </div>
  </div>
</div>