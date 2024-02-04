<div class="wrap">
	<section class="app-content">
	
	<div class="row">
		<div class="col-md-12">
			<div class="widget">
				<header class="widget-header">
					<h4 class="widget-title">FAQ Messages</h4>
					<button class="btn btn-sm btn-success create_category pull-right">Create Message</button>
				</header><!-- .widget-header -->
				<hr class="widget-separator">
				<div class="widget-body">
					<div class="table-responsive">
						<table id="default-datatable" data-plugin="DataTable" class="table table-striped" width="100%" cellspacing="0">
							<thead>
								<tr>
									<td>SL</td>
									<td>Category</td>
									<td>Site</td>
									<td>Title</td>
									<td style="width:50%;">Text</td>
									<td>Action</td>
								</tr>
							</thead>
							<tbody>
								<?php
									$i=1;
									foreach($messages as $key=>$value)
									{
								?>
										<tr>
											<td class="sl"><?php echo $i; ?></td>
											<td class="category" data-category_id="<?php echo $value->category_id; ?>"><?php echo $value->category; ?></td>
											<td class="location" data-location="<?php echo $value->location; ?>"><?php echo $value->location; ?></td>
											<td class="title"><?php echo $value->title; ?></td>
											
											<td class="text"><?php echo $value->text; ?></td>
											<td><button class="btn btn-xs btn-success edit_category" data-id="<?php echo $value->id; ?>">Edit</button></td>
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
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
		
		<form id="create_category" method='POST'>
			
			<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="myModalLabel">Create FAQ Message</h4>
			</div>
			
			<div class="modal-body">
								
												
				<div class="form-group">
					<label for="name">Title:</label>
					<input type="text" class="form-control" id="name" placeholder="Enter Title" name="name" required>
					<input type="hidden" name="faq_id" value="">
				</div>
				
				<div class="form-group">
					<label for="name">Text:</label>					
                    <textarea name="text" id="summernote" required></textarea> 
				</div>
				
				<div class="form-group">
					<label for="faq_category">Category:</label>
					<select class="form-control" name="faq_category" id="faq_category" required>
						<option value="">--Select a FAQ Category--</option>
						<?php
							foreach($faq_categories as $key=>$value)
							{
								echo '<option value="'.$value->id.'">'.$value->category.' ('.$value->location.') ('.$value->client_name.') ('.$value->process_name.')</option>';
								
							}
						?>
					</select>
				</div>
				<!--<div class="form-group">
					<label for="department">Department:</label>
					<select class="form-control" name="department" id="department" required>
						<option value="">--Select a FAQ Category--</option>
						<?php
							foreach($department as $key=>$value)
							{
								echo '<option value="'.$value->id.'">'.$value->shname.'</option>';
								
							}
						?>
					</select>
				</div>-->
				
			
			
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