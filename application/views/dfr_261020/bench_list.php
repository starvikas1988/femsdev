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
						<h4 class="widget-title">Bench User List</h4>
					</header><!-- .widget-header -->
					<hr class="widget-separator">
							
					<div class="widget-body">
					
						<div class="table-responsive">
							<table id="default-datatable" data-plugin="DataTable" class="table skt-table" cellspacing="0" width="100%">
								<thead>
									<tr class='bg-info'>
										<th>SL</th>
										<th>Fusion ID</th>
										<th>XPOID</th>
										<th>Name</th>
										<th>Gender</th>
										<th>Office</th>
										<th>Dept</th>
										<th>Client</th>
										<th>DoJ</th>
										<th>DoB</th>
										<th>Designation</th>
										<th>Org Role</th>
										<th>Level-1 Supervisor</th>
										<th>Process</th>
										<th>Status</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									<?php 
										$i=1;
										foreach($benchlist as $row):
											
									?>
									<tr>
										<td><?php echo $i++; ?></td>
										<td><?php echo $row['fusion_id']; ?></td>
										<td><?php echo $row['xpoid']; ?></td>
										<td><?php echo $row['fname'] ." " .$row['lname']; ?></td>
										<td><?php echo $row['sex']; ?></td>
										<td><?php echo $row['office_name']; ?></td>
										<td><?php echo $row['d_fullname']; ?></td>
										<td><?php echo $row['c_fullname']; ?></td>
										<td><?php echo $row['doj']; ?></td>
										<td><?php echo $row['dob']; ?></td>
										<td><?php echo $row['rolename']; ?></td>
										<td><?php echo $row['roleorgname']; ?></td>
										<td><?php echo $row['lpname']; ?></td>
										<td><?php echo $row['p_fullname']; ?></td>
										<td><?php if($row['is_on_bench'] == "Y"){ ?>
										<span class="label label-danger">Unpaid</span>
										<?php } else { ?><span class="label label-success">Paid</span><?php } ?></td>
										<td style="text-align:center">
										<?php 
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
	  
	<form class="frmclosedRequisition" action="<?php echo base_url(); ?>dfr/handover_closed_requisition" data-toggle="validator" method='POST'>
		
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Closed & Handover Requisition</h4>
      </div>
      <div class="modal-body">
			<input type="hidden" id="rid" name="rid" >
			<input type="hidden" id="handoverid" name="handoverid" >
			<input type="hidden" id="dept_id" name="dept_id" >
			<input type="hidden" id="role_folder" name="role_folder" >
			<input type="hidden" id="raised_by" name="raised_by" >
			
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label>Assign TL</label>
						<input type="text" readonly id="handoverName" name="handoverName" class="form-control">
					</div>	
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label>Phase Type</label>
						<select id="" name="phase_type" class="form-control">
							<option value="2">Training</option>
						</select>
					</div>	
				</div>
			</div>
			
			<div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<label>Comment</label>
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


<div class="modal fade" id="closedRequisitionModel1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
	  
	<form class="frmclosedRequisition1" action="<?php echo base_url(); ?>dfr/handover_closed_requisition" data-toggle="validator" method='POST'>
		
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Closed & Handover Requisition</h4>
      </div>
      <div class="modal-body">
			<input type="hidden" id="rid" name="rid" >
			<input type="hidden" id="handoverid" name="handoverid" >
			<input type="hidden" id="dept_id" name="dept_id" >
			<input type="hidden" id="role_folder" name="role_folder" >
			<input type="hidden" id="raised_by" name="raised_by" >
			
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label>Assign TL</label>
						<input type="text" readonly id="handoverName" name="handoverName" class="form-control">
					</div>	
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label>Phase Type</label>
						<select id="" name="phase_type" class="form-control">
							<option value="4">Production</option>
							<option value="2">Training</option>
						</select>
					</div>	
				</div>
			</div>
			
			<div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<label>Comment</label>
						<textarea class="form-control" id="closed_comment" name="closed_comment" required></textarea>
					</div>	
				</div>
			</div>
					
      </div>
	  
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		<button type="submit" id='closedRequisition1' class="btn btn-primary">Save</button>
      </div>
	  
	 </form>
	 
    </div>
  </div>
</div>