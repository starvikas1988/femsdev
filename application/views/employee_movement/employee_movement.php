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
						<h4 class="widget-title">Requisition Details for Handover</h4>
					</header><!-- .widget-header -->
					<hr class="widget-separator">
							
					<div class="widget-body">
					
						<div class="row">
							<div class="table-responsive">							
								<table id="default-datatable" data-plugin="DataTable" class="table table-striped" cellspacing="0" width="100%">
									<thead>
										<tr class='bg-info'>
											<th>SL</th>
											<th>Requisition Code</th>
											<th>Due Date</th>
											<th>Position</th>
											<th>Client</th>
											<th>Process</th>
											<th>Required Position</th>
											<th>Filled Position</th>
											<th>Batch Code</th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody>
										<?php  $i=1;
											foreach($get_closed_requisition as $row):
										?>
										<tr>
											<td><?php echo $i++; ?></td>
											<td><?php echo $row['requisition_id']; ?></td>
											<td><?php echo $row['due_date']; ?></td>
											<td><?php echo $row['role']; ?></td>
											<td><?php echo $row['client']; ?></td>
											<td><?php echo $row['process']; ?></td>
											<td><?php echo $row['req_no_position']; ?></td>
											<td><?php echo $row['count_canasempl']; ?></td>
											<td><?php echo $row['job_title']; ?></td>
											<td>
											<?php
												$r_id=$row['id'];
												
												echo "<button title='Requisition Handover' type='button' r_id='$r_id' class='btn btn-success btn-xs employeeMovement' style='font-size:12px'><i class='fa fa-users' aria-hidden='true'></i></button>";
											?>
											</td>
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


<!---------------------------------------Model Page Start------------------------------------------------->

<!-------------------- Handover Requisition model ----------------------------->
<div class="modal fade" id="employeeMovementModel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
	  
	<form class="frmEmployeeMovement" action="<?php echo base_url(); ?>" data-toggle="validator" method='POST'>
		
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Requisition Handover</h4>
      </div>
      <div class="modal-body">
	  
			<input type="hidden" id="r_id" name="r_id" >
			
			<div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<label>Select User to Handover</label>
						<select class="form-control" id="" name="" required>
							<option value=""></option>
						</select>
					</div>	
				</div>
			</div>
			
			<div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<label>Comment</label>
						<textarea class="form-control" id="" name=""></textarea>
					</div>	
				</div>
			</div>
					
      </div>
	  
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		<button type="submit" id='' class="btn btn-primary">Save</button>
      </div>
	  
	 </form>
	 
    </div>
  </div>
</div>
