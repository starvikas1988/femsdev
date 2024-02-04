<style>
.btn-sm{
	padding: 2px 5px;
}
.scrollheightdiv{
	max-height:600px;
	overflow-y:scroll;
}
.fa{
padding-right: 5px;
}

.btn-new {
		width: 150px;
    padding: 8px;
}
.pd {
  padding-left: 2px;
  margin-top: 5px;
}
textarea{
width: 100% !important;
max-width: 100%;
max-height: 40px;
min-height: 40px;
border-radius: 3px;
}
.form-control{
border-radius: 3px;
}
</style>

<div class="wrap">
<section class="app-content">

<div class="row">
<div class="col-md-12">
<?php if(!empty($this->input->get('elog')) && $this->input->get('elog') == "error"){ ?>
<div class="alert alert-danger" role="alert">
  <i class="fa fa-warning"></i> Record Already Exist!
</div>
<?php } ?>
</div>
</div>

<div class="row">

<div class="col-md-12">
<div class="widget">
<header class="widget-header">
<h4 class="widget-title"><i class="fa fa-users"></i> Master Client</h4>
</header>
<hr class="widget-separator"/>
<div class="widget-body clearfix">
<form autocomplete="off" action="<?php echo duns_url('add_master_client'); ?>" method="POST" enctype="multipart/form-data">				
	<div class="row">	
	<div class="col-md-12">
	<div class="form-group">
		<label>Name</label>
		<input class="form-control" name="client_name" required>
	</div>
	</div>
	
	<div class="col-md-12">
	<div class="form-group">
		<label>Description</label>
		<textarea class="form-control" name="client_description" required></textarea>
	</div>
	</div>			
	</div>		

	<div class="row">
	<div class="col-md-12">
	<div class="form-group pd">
		<button type="submit" class="btn btn-primary btn-new">Submit</button>
	</div>
	</div>
	</div>
</form>
</div>
</div>
</div>


<div class="col-md-12">
<div class="widget">
<header class="widget-header">
<h4 class="widget-title"><i class="fa fa-users"></i> Clients List</h4>
</header>
<hr class="widget-separator"/>
<div class="widget-body clearfix">					
<div class="table-responsive">
	
  <table id="default-datatable" class="table table-bordered mb-0 table table-striped skt-table" data-plugin="DataTable">  
    <thead>
      <tr class="bg-primary text-white">
	    <th scope="col" class="text-center">#</th>
        <th scope="col" class="text-center">Name</th>
        <th scope="col" class="text-center">Description</th>
		<th scope="col" class="text-center">Status</th>
		<th scope="col" class="text-center">Action</th>
      </tr>
    </thead>
	
    <tbody>	
	<?php
	$countc = 0;
	foreach($duns_clients_list as $token){ 
		$countc++;
	?>	
      <tr>
        <td scope="row" class="text-center"><?php echo $countc; ?></td>
        <td scope="row" class="text-center"><b><?php echo $token['name']; ?></b></td>
        <td scope="row" class="text-center"><b><?php echo $token['description']; ?></b></td>
		<td scope="row" class="text-center">
		<b><?php echo !empty($token['is_active']) ? "<span class='text-success'>Active</span>" : "<span class='text-danger'>Inactive</span>"; ?></b>
		</td>
		<td scope="row" class="text-center">
		<a class="btn btn-primary  btn-sm editMasterClient" sid="<?php echo $token['id']; ?>"><i class="fa fa-edit"></i></a>
		<a onclick="return confirm('Do you really want to delete?')" href="<?php echo base_url() ."duns_crm/delete_master_client?did=" .$token['id']; ?>" class="btn btn-danger btn-sm"><i class="fa fa-times"></i></a>
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

<br/><br/><br/><br/><br/><br/><br/>

</section>
</div>



<div class="modal fade" id="editModal_record" tabindex="-1" role="dialog" aria-labelledby="editModal_record" aria-hidden="true">
  <div class="modal-dialog  modal-lg">
  <form method="POST" action="<?php echo duns_url('update_master_client'); ?>" autocomplete="off" enctype="multipart/form-data">
    <div class="modal-content">
      <div class="modal-header">        
        <h4 class="modal-title">Update Client</h4>
		<button type="button" class="close" data-dismiss="modal" data-toggle="validator" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">	  
	  
			<div class="row">
				<div class="col-sm-12">
					<div class="form-group">
					  <label>Name</label>
					  <input type="text" class="form-control" name="client_name" required>
					</div>
				</div>
				<div class="col-sm-12">
					<div class="form-group">
					  <label>Description</label>
					  <textarea type="text" class="form-control" name="client_description" required></textarea>
					</div>
				</div>
				<div class="col-sm-12">
					<div class="form-group">
					  <label>Status</label>
					  <input type="hidden" class="form-control" name="edit_id">						
					  <select class="form-control" name="client_status">						
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
		