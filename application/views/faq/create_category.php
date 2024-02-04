<style>
	.table > tbody > tr > td
	{
		padding: 4px !important;
	}
</style>
<div class="wrap">
	<section class="app-content">
	
	<div class="row">
		<div class="col-md-12">
			<div class="widget">
				<header class="widget-header">
					<h4 class="widget-title">FAQ Category</h4>
					<button class="btn btn-sm btn-success create_category pull-right">Create Category</button>
				</header><!-- .widget-header -->
				<hr class="widget-separator">
				<div class="widget-body">
					<div class="table-responsive">
						<table id="default-datatable" data-plugin="DataTable" class="table table-striped" width="100%" cellspacing="0">
							<thead>
								<tr>
									<td>SL</td>
									<td>Title</td>
									<td>Client</td>
									<td>Process</td>
									<td>Site</td>
									<td>Action</td>
								</tr>
							</thead>
							<tbody>
								<?php
									$i=1;
									foreach($faq_categories as $key=>$value)
									{
								?>
										<tr>
											<td class="sl"><?php echo $i; ?></td>
											<td class="category"><?php echo $value->name; ?></td>
											<td class="client" data-client_id="<?php echo $value->assign_client; ?>"><?php echo $value->shname; ?></td>
											<td class="process" data-process_id="<?php echo $value->assign_process; ?>"><?php echo $value->process_name; ?></td>
											<td class="location"><?php echo $value->location; ?></td>
											<td><button class="btn btn-xs btn-success edit_category" data-category_id="<?php echo $value->id; ?>">Edit</button></td>
										</tr>
								<?php
										$i++;
									}
								?>
								
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
	</section>
</div>
<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
		
		<form id="create_category" method='POST'>
			
			<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="myModalLabel">Create Category</h4>
			</div>
			
			<div class="modal-body">
								
												
				<div class="form-group">
					<label for="name">Title:</label>
					<input type="text" class="form-control" id="name" placeholder="Enter Title" name="name" required>
					<input type="hidden" name="faq_types_id" value="">
				</div>
				
				<div class="form-group">
					<label for="assign_site">Site:</label>
					<?php //print_r($location_list); ?>
					<select class="form-control" name="assign_site" id="assign_site" required>
						<option value="">Select a Site</option>
						<?php
							foreach($location_list as $key=>$value)
							{
								if($value['is_active'] == 1)
								{
									echo '<option value="'.$value['abbr'].'">'.$value['location'].'</option>';
								}
							}
						?>
					</select>
				</div>
				
				<div class="form-group">
					<label for="assign_client">Client:</label>
					<select class="form-control" name="assign_client" id="assign_client" required>
						<option value="">Select a Client</option>
						<?php
							foreach($client_list as $key=>$value)
							{
								if($value->is_active == 1)
								{
									echo '<option value="'.$value->id.'">'.$value->shname.'</option>';
								}
							}
						?>
					</select>
				</div>
				
				<div class="form-group">
					<label for="assign_process">Process:</label>
					<select class="form-control" name="assign_process" id="assign_process" required>
						<option value="">Select a Process</option>
					</select>
				</div>
				
			
			
				<!--<div class="form-group">
					<label for="status">Status:</label>
					<select class="form-control" name="status" id="status">
						<option value="">Select a Status</option>
						<option value="1">Active</option>
						<option value="0">In-Active</option>
					</select>
				</div>-->
				
			</div>
	  
	   
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save Category</button>
      </div>
	  
		</form>
	
	</div>
   </div>
</div>