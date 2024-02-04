<div class="common-top">
<div class="middle-content">
				
<div class="card">
<div class="card-body">
	<h2 class="heading-title">Call Type</h2>
	
	<form method="POST" autocomplete="off">
	<div class="row">
		<div class="col-sm-4">
			<div class="form-group">
			  <label>Call Type</label>
			  <input type="text" class="form-control" name="d_name" required>
			</div>
		</div>
		<div class="col-sm-4">
			<div class="form-group">
				<div class="common-top1">
					<button type="submit" name="data_submission" class="submit-btn1">Submit</button>
				</div>
			</div>
		</div>
	</div>
	</form>
	
	
	<div class="common-top">
		<h2 class="heading-title">Call Type List</h2>
		<div class="table-widget">
			<table class="table table-bordered table-striped table-hover">
				<thead>
				  <tr>
					<th>#</th>
					<th>Name</th>	
					<th>Status</th>	
					<th>Action</th>	
				  </tr>
				</thead>
				<tbody>
				<?php $cn=0; foreach($calltype_list as $token){ $cn++; ?>
				<tr>
					<td><?php echo $cn; ?></td>
					<td><?php echo $token['name']; ?></td>
					<td><?php echo $token['is_active'] == 1 ? '<span class="text-success font-weight-bold">Active</span>' : '<span class="text-danger font-weight-bold">Inactive</span>'; ?></td>		
					<td>
					<a class="btn btn-primary editMasterCallType" sid="<?php echo $token['id']; ?>"><i class="fa fa-edit"></i></a>
					</td>		
				 </tr>
				<?php } ?>
				  
				</tbody>
			</table>
		</div>
	</div>
	
</div>
</div>
					
					
					
					
					
	</div>
</div>




<div class="modal fade" id="editModal_record" tabindex="-1" role="dialog" aria-labelledby="editModal_record" aria-hidden="true">
  <div class="modal-dialog  modal-lg" style="width:100%">
  <form method="POST" autocomplete="off" enctype="multipart/form-data">
    <div class="modal-content">
      <div class="modal-header">        
        <h4 class="modal-title">Update Department</h4>
		<button type="button" class="close" data-dismiss="modal" data-toggle="validator" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">	  
	  
			<div class="row">
				<div class="col-sm-12">
					<div class="form-group">
					  <label>Name</label>
					  <input type="text" class="form-control" name="d_name" required>
					</div>
				</div>
				<div class="col-sm-12">
					<div class="form-group">
					  <label>Status</label>
					  <input type="hidden" class="form-control" name="edit_id">						
					  <select class="form-control" name="d_status">						
						<option value="1">Active</option>
						<option value="0">Inactive</option>
					  </select>
					</div>
				</div>
			</div>		
      </div>	  
      <div class="modal-footer">
	     <button type="submit" style="width:100px" name="data_updation" class="btn search-btn bg-success">Update</button>		 
         <button type="button" style="width:100px" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
 </form>
  </div>
</div>
			