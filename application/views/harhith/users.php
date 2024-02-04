<div class="common-top">
<div class="middle-content">
				
<div class="card">
<div class="card-body">
	<h2 class="heading-title">Add Moderator / Stakeholder</h2>
	
	<form method="POST" action="<?php echo hth_url('users_add'); ?>" autocomplete="off" enctype="multipart/form-data">
	<div class="row formRow">
		<div class="col-sm-4">
			<div class="form-group">
			  <label>First Name</label>
			  <input type="text" class="form-control" name="d_first_name" required>
			</div>
		</div>
		<div class="col-sm-4">
			<div class="form-group">
			  <label>Last Name</label>
			  <input type="text" class="form-control" name="d_last_name" required>
			</div>
		</div>
		<div class="col-sm-4">
			<div class="form-group">
			  <label>Gender</label>
			 <select class="form-control" name="d_sex" required>
					<option value="">-- Select --</option>
					<option value="Male">Male</option>
					<option value="Female">Female</option>
					<option value="Others">Others</option>
			 </select>
			</div>
		</div>
		<div class="col-sm-4">
			<div class="form-group">
			  <label>Email ID **(Login ID)</label>
			  <input type="email" class="form-control" name="d_email_id" required>
			</div>
		</div>
		<div class="col-sm-4">
			<div class="form-group">
			  <label>Phone No</label>
			  <input type="text" class="form-control" name="d_phone_no" maxlength="10" oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*?)\..*/g, '$1');">
			</div>
		</div>		
		<div class="col-sm-4" style="display:none">
			<div class="form-group">
			  <label>Dialer ID</label>
			  <input type="text" class="form-control" name="d_dialer_id">
			</div>
		</div>
		<div class="col-sm-4" style="display:none">
			<div class="form-group">
			  <label>Office ID</label>
			  <select class="form-control singleSelect" name="office_id[]" id="office_id" multiple>
					<?php echo hth_dropdown_3d_options($location_list, 'abbr', 'office_name'); ?>								
			  </select>
			</div>
		</div>
		<div class="col-sm-4" style="display:none">
			<div class="form-group">
			  <label>Client ID</label>
			  <select class="form-control singleSelect" name="client_id" id="client_id">
					<option>-Select-</option>
					<?php foreach($client_list as $client): ?>
						<option value="<?php echo $client->id ?>"><?php echo $client->shname ?></option>
					<?php endforeach; ?>							
			  </select>
			</div>
		</div>
		<div class="col-sm-4" style="display:none">
			<div class="form-group">
			  <label>Process ID</label>
			  <select class="form-control singleSelect" name="process_id[]" id="process_id" multiple>
					<option>-Select-</option>
					<?php foreach($process_list as $process): ?>
						<option value="<?php echo $process->id ?>"><?php echo $process->name ?></option>
					<?php endforeach; ?>							
			  </select>
			</div>
		</div>
		<div class="col-sm-4">
			<div class="form-group">
			  <label>Role</label>
			  <select class="form-control singleSelect" name="d_role_id" required>
					<?php echo hth_dropdown_options($role_list); ?>
			  </select>
			</div>
		</div>
		<div class="col-sm-4 departmentSelect">
			<div class="form-group">
			  <label>Department</label>
			  <select class="form-control singleSelect" name="d_department_id" required>
					<?php echo hth_dropdown_3d_options($department_list); ?>
			  </select>
			</div>
		</div>
	</div>
	<div class="row">	
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
		<h2 class="heading-title">Users List</h2>
		<div class="table-widget">
			<table class="table table-bordered table-striped table-hover">
				<thead>
				  <tr>
					<th>#</th>
					<th>Full Name</th>
					<th>Email ID</th>	
					<th>Role</th>	
					<th>Department</th>	
					<th>Phone</th>	
					<th>Action</th>	
				  </tr>
				</thead>
				<tbody>
				<?php $cn=0; foreach($users_list as $token){ $cn++; ?>
				<tr>
					<td><?php echo $cn; ?></td>
					<td><?php echo $token['fname'] ." " .$token['lname']; ?></td>
					<td><?php echo $token['email_id']; ?></td>		
					<td><?php echo strtoupper($token['role']); ?></td>		
					<td><?php echo $token['department_name']; ?></td>		
					<td><?php echo $token['phno']; ?></td>		
					<td>
					<?php if(hth_access_add_client_user()){ ?>
						<a class="btn btn-primary editMasterClientUser" sid="<?php echo $token['id']; ?>"><i class="fa fa-edit"></i></a>					
						<button title='Reset Password' c_id='<?php echo $token['id']; ?>' type='button' class='resetPasswordClient btn btn-warning btn-xs'><i class='fa fa-key' aria-hidden='true'></i></button>
					<?php } ?>
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
			







<div class="modal fade" id="editModal_user" tabindex="-1" role="dialog" aria-labelledby="editModal_user" aria-hidden="true">
  <div class="modal-dialog  modal-lg" style="width:100%">
  	<form method="POST" action="<?php echo hth_url('users_update'); ?>" autocomplete="off" enctype="multipart/form-data">
    <div class="modal-content">
      <div class="modal-header">        
        <h4 class="modal-title">Update User</h4>
		<button type="button" class="close" data-dismiss="modal" data-toggle="validator" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">	  
	  
	<div class="row formRow">
		<div class="col-sm-4">
			<div class="form-group">
			  <label>First Name</label>
			  <input type="hidden" class="form-control" name="edit_id" required>
			  <input type="text" class="form-control" name="d_first_name" required>
			</div>
		</div>
		<div class="col-sm-4">
			<div class="form-group">
			  <label>Last Name</label>
			  <input type="text" class="form-control" name="d_last_name" required>
			</div>
		</div>
		<div class="col-sm-4">
			<div class="form-group">
			  <label>Gender</label>
			 <select class="form-control" name="d_sex" required>
					<option value="">-- Select --</option>
					<option value="Male">Male</option>
					<option value="Female">Female</option>
					<option value="Others">Others</option>
			 </select>
			</div>
		</div>
		<div class="col-sm-4">
			<div class="form-group">
			  <label>Email ID **(Login ID)</label>
			  <input type="email" class="form-control" name="d_email_id" readonly required>
			</div>
		</div>
		<div class="col-sm-4">
			<div class="form-group">
			  <label>Phone No</label>
			  <input type="text" class="form-control" name="d_phone_no" maxlength="10" oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*?)\..*/g, '$1');">
			</div>
		</div>
		<div class="col-sm-4">
			<div class="form-group">
			  <label>Role</label>
			  <select class="form-control singleSelect" name="d_role_id" style="width:100%"  required>
					<?php echo hth_dropdown_options($role_list); ?>
			  </select>
			</div>
		</div>
		<div class="col-sm-4 departmentSelect">
			<div class="form-group">
			  <label>Department</label>
			  <select class="form-control singleSelect" name="d_department_id" style="width:100%">
					<?php echo hth_dropdown_3d_options($department_list); ?>
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
			
			
			

<!--------------- RESET PASSWORD -------------------->
<div class="modal fade" id="resetPassowrdClientModal" tabindex="-1" role="dialog" aria-labelledby="resetPassowrdClientModal" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
	
      <div class="modal-header">        
        <h4 class="modal-title">Reset Password</h4>
		<button type="button" class="close" data-dismiss="modal" data-toggle="validator" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
		  <input type="hidden" name="r_cid" class="form-control">		  
		  <div class="row">
			<div class="col-md-12">
				<div class="form-group">
					<label for="name">Enter New Password</label>
					<input type="text" class="form-control" placeholder="Enter New Password" value="fusion@123" name="r_new_passwd" required>
				</div>
			</div>			
			<div class="col-md-12">
				<div class="form-group">
					<label for="name">Confirm Password</label>
					<input type="text" class="form-control" placeholder="Re-Enter New Password" value="fusion@123" name="r_confirm_passwd" required>
				</div>
			</div>
		 </div>				
	  </div>
      <div class="modal-footer">
		<button type="button" style="width:100px" name="data_updation" class="btn search-btn bg-success resetPasswordClientSubmit">Update</button>		 
        <button type="button" style="width:100px" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
	   
    </div>
  </div>
</div>