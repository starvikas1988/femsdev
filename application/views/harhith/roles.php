<div class="common-top">
<div class="middle-content">
				
<div class="card">
<div class="card-body">
	<h2 class="heading-title">Roles</h2>
	
	<form method="POST" autocomplete="off" style="display:none">
	<div class="row">
		<div class="col-sm-4">
			<div class="form-group">
			  <label>Short Name</label>
			  <input type="text" class="form-control" name="d_short_name" required>
			</div>
		</div>
		<div class="col-sm-4">
			<div class="form-group">
			  <label>Assign</label>
			  <input type="text" class="form-control" name="d_full_name" required>
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
		<h2 class="heading-title">Roles List</h2>
		<div class="table-widget">
			<table class="table table-bordered table-striped table-hover">
				<thead>
				  <tr>
					<th>#</th>
					<th>Role</th>
				  </tr>
				</thead>
				<tbody>
				<?php $cn=0; $roles = hth_dropdown_role('', 'all'); foreach($roles as $key=>$token){ $cn++; ?>
				<tr>
					<td><?php echo $cn; ?></td>
					<td><?php echo $token; ?></td>
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
			
