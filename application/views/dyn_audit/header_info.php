<link rel="stylesheet" href="<?php echo base_url('libs/bower/font-awesome/css/font-awesome-all.css')?>">
<link rel="stylesheet" href="<?php echo base_url('/libs/bower/jquery-toast-plugin/css/jquery.toast.css');?>">
<style>

.rebuttal {
  font-weight:bold;
  text-decoration: none;
  color: rgba(255, 255, 255, 0.8);
  background: rgb(145, 92, 182);
  padding: 15px 40px;
  border-radius: 4px;
  font-weight: normal;
  text-transform: uppercase;
  transition: all 0.2s ease-in-out;
}

.rebuttal_body:hover {
  color: rgba(255, 255, 255, 1);
  box-shadow: 0 5px 15px rgba(145, 92, 182, .4);
}

.bootstrap-tagsinput{
          width:100%!important;
    }
	.bootstrap-tagsinput input{
		width:100%!important;
		border: 1px solid #ccc!important;
		height: 32px!important;
	}
	.bootstrap-tagsinput input:focus{
		outline:none!important;
	}
</style>

<div class="wrap">
	<section class="app-content">

		<div class="row">
			<div class="col-12">
				<div class="widget">
					<div class="row">
						<div class="col-md-9">
							<header class="widget-header">
								<h2 class="widget-title">Header Information</h2>
							</header>
						</div>
						<!-- <div class="col-md-3">
							<header class="widget-header">
								<h4 class="widget-title">
									
								</h4>
							</header>
						</div> -->
						<hr class="widget-separator">
					</div>
					<div class="widget-body">
						
					</div>
				</div>
			</div>		
		</div>
		
		
		<div class="row">
			<div class="col-12">
				<div class="widget">
					<div class="row">
						<div class="col-md-12">
							<header class="widget-header">
								<h4 class="widget-title">
									
									<?php if(get_global_access()==1){ ?>
										<div class="pull-right">											
											<!-- <a class="btn btn-primary" href="<?php echo base_url(); ?>qa_audit_dyn/add_header">Add Header</a> -->
											<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addheaderModel">Add Header</button>
										</div>	
									<?php } ?>
								</h4>
							</header>
						</div>
						
						<hr class="widget-separator">
					</div>
					<div class="widget-body">
						<div class="table-responsive">
							<table id="default-datatable" data-plugin="DataTable" class="table table-striped skt-table" cellspacing="0" width="100%">
								<thead>
									<tr class="bg-info">
										
										<!-- <th>--</th> -->
										<th>SL</th>
										<th>Header Name</th>
										<th>Field Type</th>
										<th>Input Type</th>
										<th>Dropdown Values</th>
										<th>ID string</th>
										<th>Value Variable</th>
										<!-- <th>Mandatory Field</th> -->
										<th>Input Disabled</th>
										<th>Required Field</th>
										<th>Create Column in Database</th>
										<th>Database Column Name</th>
										<th>Database Column Type</th>
										<th>Status</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody id="header_data_list">
									<?php $i=1;
										foreach($header_data as $row): ?>
										
										<tr>
												<!-- <td>
													<?php
													$sid=$row['id'];
													//echo "<button title='Delete header' pid='$sid' type='button' class='headerDelete btn btn-danger btn-xs'><i class='fa fa-trash' aria-hidden='true'></i></button>"; ?>
												</td> -->
											
											<td>
											<?php echo $i++; ?>
											</td>
											<td><?php echo $row['name']; ?></td>
											<td><?php echo $row['field_type']; ?></td>
											<td><?php echo $row['input_type']; ?></td>
											<td><?php echo $row['dropdown_values'] ?></td>
											<td><?php echo $row['id_string']; ?></td>
											<td><?php echo $row['value_variable']; ?></td>
											<!-- <td><?php $sid=$row['id'];
											$mand_stat=$row['is_mandatory'];
											if($row['is_mandatory'] == 1){ echo "<span style='margin-left:5px; font-size:10px;' pid='$sid' mand_stat='$mand_stat' class='btn btn-success is_mandatory'>Mandatory</span>";
												}else{
												echo "<span style='margin-left:5px; font-size:10px;' pid='$sid' mand_stat='$mand_stat' class='btn btn-dark is_mandatory'>Not Mandatory</span>";
												} ?></td> -->
											<td><?php if($row['is_disabled'] == 1){ echo "<span style='margin-left:5px; font-size:10px;' class='btn btn-success'>Yes</span>";
											}else{
											echo "<span style='margin-left:5px; font-size:10px;' class='btn btn-danger'>No</span>";
											} ?></td>
											<td><?php $sid=$row['id'];
											$req_stat=$row['is_required_field'];
											if($row['is_required_field'] == 1){ echo "<span style='margin-left:5px; font-size:10px;' pid='$sid' req_stat='$req_stat' class='btn btn-warning is_required'>Required</span>";
												}else{
												echo "<span style='margin-left:5px; font-size:10px;' pid='$sid' req_stat='$req_stat' class='btn btn-info is_required'>Not Required</span>";
												} ?></td>
											<td><?php if($row['is_create_header_column'] == 1){ echo "<span style='margin-left:5px; font-size:10px;' class='btn btn-success'>Yes</span>";
											}else{
											echo "<span style='margin-left:5px; font-size:10px;' class='btn btn-danger'>No</span>";
											} ?></td>
											<td><?php echo $row['column_name']; ?></td>
											<td><?php echo $row['column_type']; ?></td>
											<td><?php $sid=$row['id'];
											$current_stat=$row['is_active'];
											if($row['is_active'] == 1){ echo "<span style='margin-left:5px; font-size:10px;' title='Inactive' pid='$sid' current_stat='$current_stat' class='btn btn-success active_inactive'>Active</span>";
												}else{
												echo "<span style='margin-left:5px; font-size:10px;' title='Active' pid='$sid' current_stat='$current_stat' class='btn btn-danger active_inactive'>Inactive</span>";
												} ?></td>
											 <td width="100px">
											 <span style='margin-left:5px; font-size:10px;' pid='<?php echo $row['id']?>' class='btn btn-info edit_header'>Edit Header</span>
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
		
	</section>
</div>


<!----------------------------------------------------------------------------------------------------------------------------->
<div class="modal fade modal-design" id="addheaderModel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
	  
	<form class="frmaddheaderModel" id="headerform" action="<?php echo base_url(); ?>qa_audit_dyn/add_header" method='POST'>
	<!-- data-toggle="validator" -->
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<h4 class="modal-title" id="myModalLabel">Add/Edit Header</h4>
      </div>
      <div class="modal-body">
	  <input type="hidden" name="header_id" id="header_id" value="0">
	  <?php $prev_url = $_SERVER['HTTP_REFERER']; ?>
	  <input type="hidden" name="prev_url" id="prev_url" value="<?php echo $prev_url ?>">
	  <div class="row">
		<div class="col-md-12">
			<div class="form-group">
			<label>Choose Client :</label>
			<select class="form-control" id="client_id" name="data[client_id]" required>
			<option value="" >Select Client</option>
				<?php foreach($client_data as $client){ ?>
					<option value="<?php echo $client['id'] ?>" ><?php echo $client['fullname'] ?></option>
					<?php } ?>
			</select>
			</div>
		</div>
	  </div>
	  <div class="row">
		<div class="col-md-12">
			<div class="form-group">
			<label>Header Name :</label>
			<input type="text" id="header_name" name="data[name]"  class="form-control" value="" onkeypress="return blockSpecialChar(event)" required>
			</div>
		</div>
	  </div>
	  <div class="row">
		<div class="col-md-12">
			<div class="form-group">
			<label>Field Type :</label>
			<select class="form-control" id="field_type" name="data[field_type]" required>
				<option value="" >Select Field Type</option>
				<option value="input" >Input</option>
				<option value="dropdown" >Dropdown</option>
			</select>
			</div>
		</div>
	  </div>
	  <div class="row">
		<div class="col-md-12">
			<div class="form-group">
			<label>Input Type :</label>
			<select class="form-control" id="input_type" name="data[input_type]" required>
				<option value="" >Select Input Type</option>
				<option value="text" >Text</option>
				<option value="hidden" >Hidden</option>
				<option value="select" >Select</option>
			</select>
			</div>
		</div>
	  </div>
	  <div class="row">
		<div class="col-md-12">
			<div class="form-group dr_value">
			<label>Dropdown Values :</label>
			<input type="text" id="dropdown_values" name="data[dropdown_values]"  class="form-control" value="" placeholder="Enter values by comma separeted eg:abc,def" data-role="tagsinput">
			</div>
		</div>
	  </div>
	  <div class="row">
		<div class="col-md-12" style="display: none;">
			<div class="form-group">
			<label>ID string :</label>
			<input type="text" id="id_string" name="data[id_string]"  class="form-control" value="" required>
			</div>
		</div>
	  </div>
	  <div class="row">
		<div class="col-md-12" style="display: none;">
			<div class="form-group">
			<label>Value Variable :</label>
			<input type="text" id="value_variable" name="data[value_variable]"  class="form-control" value="" required>
			</div>
		</div>
	  </div>
	  <div class="row">
		<div class="col-md-12" style="display: none;">
			<div class="form-group">
			<label>Is it a Mandatory Field ?</label>
			<select class="form-control" id="is_mandatory" name="data[is_mandatory]" required>
				<option value="" >--Select--</option>
				<option value="1" >Yes</option>
				<option value="0" >No</option>
			</select>
			</div>
		</div>
	  </div>
	  <div class="row">
		<div class="col-md-12">
			<div class="form-group">
			<label>Is it a Required Field ?</label>
			<select class="form-control" id="is_required_field" name="data[is_required_field]" required>
				<option value="" >--Select--</option>
				<option value="1" >Yes</option>
				<option value="0" >No</option>
			</select>
			</div>
		</div>
	  </div>
	  <div class="row">
		<div class="col-md-12" style="display: none;">
			<div class="form-group">
			<label>Is input will Disabled?</label>
			<select class="form-control" id="is_disabled" name="data[is_disabled]" required>
				<option value="" >--Select--</option>
				<option value="1" >Yes</option>
				<option value="0" >No</option>
			</select>
			</div>
		</div>
	  </div>
	  <div class="row">
		<div class="col-md-12" style="display: none;">
			<div class="form-group">
			<label>Is it create column in Database ?</label>
			<select class="form-control" id="is_create_header_column" name="data[is_create_header_column]" required>
				<option value="" >--Select--</option>
				<option value="1" >Yes</option>
				<option value="0" >No</option>
			</select>
			</div>
		</div>
	  </div>
	  <div class="row">
		<div class="col-md-12" style="display: none;">
			<div class="form-group db_column_name">
			<label>Database Column Name :</label>
			<input type="text" id="column_name" name="data[column_name]"  class="form-control" value="">
			</div>
		</div>
	  </div>
	  <div class="row">
		<div class="col-md-12" style="display: none;">
			<div class="form-group db_column_type">
			<label>Database Column Type :</label>
			<input type="text" id="column_type" name="data[column_type]"  class="form-control" value="">
			</div>
		</div>
	  </div>
	  <div class="row">
		<div class="col-md-12">
			<div class="form-group">
			<label>Status :</label>
			<select class="form-control" id="is_active" name="data[is_active]" required>
				<option value="" >--Select--</option>
				<option value="1" >Active</option>
				<option value="0" >Inactive</option>
			</select>
			</div>
		</div>
	  </div>
			
			
      </div>
	  
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		<button type="submit" id='submit_header' class="btn btn-primary">Save</button>
      </div>
	  
	 </form>
	 
    </div>
  </div>
</div>