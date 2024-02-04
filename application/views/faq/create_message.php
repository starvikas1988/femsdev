<div class="widget">
	<header class="widget-header">
		<h4 class="widget-title">Messages</h4>
		<button class="btn btn-sm btn-success create_category pull-right">Create Message</button>
	</header><!-- .widget-header -->
	<hr class="widget-separator">
	<div class="widget-body">
		<div class="table-responsive">
			<table id="default-datatable" data-plugin="DataTable" class="table table-striped" width="100%" cellspacing="0">
				<thead>
					<tr>
						<td>SL</td>
						<td>Location</td>
						<td>Department</td>
						<td>Client</td>
						<td>Process</td>
						<td>Subject</td>
						<td>Attachment</td>
						<td>Upload Image</td>
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
								<td class="location" data-location="<?php echo $value->office_location; ?>"><?php echo $value->office_location; ?></td>
								<td class="department" data-department="<?php echo $value->department_id; ?>"><?php echo $value->department_name; ?></td>
								<td class="client" data-client="<?php echo $value->client_id; ?>"><?php echo $value->client_name; ?></td>
								<td class="process" data-process="<?php echo $value->process_id; ?>"><?php echo $value->process_name; ?></td>
								<td class="subject"><?php echo $value->subject; ?></td>
								<?php
									$img_array = explode(',',$value->attached_img_name);
									$img_id = explode(',',$value->attached_img_id);
								?>
								<td class="message" data-message="<?php echo htmlentities($value->message_body); ?>">
									<?php
										foreach($img_array as $ke=>$val)
										{
											$array = explode('.', $val);
											$extension = end($array);
											if($extension=='jpg' || $extension=='png' || $extension=='jpeg')
											{
												echo '<div style="position:relative"><button data-id="'.$img_id[$ke].'" class="delte_attach btn btn-sm btn-danger" style="position:absolute;">X</button><a href="../../femsdev/uploads/'.$val.'" target="_blank"><img src="../../femsdev/uploads/'.$val.'" width="100px"></a></div>';
												echo '<br>';
											}
											else if($extension=='doc' || $extension=='docx')
											{
												echo '<div style="position:relative"><button data-id="'.$img_id[$ke].'" class="delte_attach btn btn-sm btn-danger" style="position:absolute;">X</button><a href="../../femsdev/uploads/'.$val.'"  target="_blank"><img src="../assets/images/doc.png" width="100px"></a></div>';
												echo '<br>';
												
											}
											else if($extension=='xlx' || $extension=='xlsx')
											{
												echo '<div style="position:relative"><button data-id="'.$img_id[$ke].'" class="delte_attach btn btn-sm btn-danger" style="position:absolute;">X</button><a href="../../femsdev/uploads/'.$val.'"  target="_blank"><img src="../assets/images/excel.png" width="100px"></a></div>';
												echo '<br>';
												
											}
										}
									?>
								</td>
								<td><form class="upload_image" data-id="<?php echo $value->id; ?>" method='POST'>
									<input type="hidden" name="exp_id" value="<?php echo $value->id; ?>">
									<div class="form-group">
										Attach File
										<div id="mulitplefileuploader<?php echo $i; ?>">Upload</div>
										<div id="status"></div>
										<div id="OutputDiv"></div>
									</div>
								</form></td>
								<td><button class="btn btn-sm btn-success edit_category" data-id="<?php echo $value->id; ?>">Edit</button></td>
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

<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
		
		<form id="create_category" method='POST'>
			
			<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="myModalLabel">Create Message</h4>
			</div>
			
			<div class="modal-body">
								
												
				<div class="form-group">
					<label for="name">Title:</label>
					<input type="text" class="form-control" id="name" placeholder="Enter Title" name="name" required>
					<input type="hidden" name="faq_messageboard_id" value="">
				</div>
				
				<div class="form-group">
					<label for="name">Text:</label>
                    <textarea name="text" id="summernote" required></textarea>                                                        
				</div>
				
				<div class="form-group">
					<label for="location">Location:</label>
					<select class="form-control" name="location" id="location" required>
						<option value="">--Select a Location--</option>
						<?php
							foreach($location_list as $key=>$value)
							{
								echo '<option value="'.$value['abbr'].'">'.$value['office_name'].'</option>';
								
							}
						?>
					</select>
				</div>
				<div class="form-group">
					<label for="department">Department:</label>
					<select class="form-control" name="department" id="department" required>
						<option value="">--Select a Department--</option>
						<?php
							foreach($department as $key=>$value)
							{
								echo '<option value="'.$value->id.'">'.$value->shname.'</option>';
								
							}
						?>
					</select>
				</div>
				
				<div class="form-group">
					<label for="client">Client:</label>
					<select class="form-control" name="client" id="client" required>
						<option value="">--Select a Client--</option>
						<?php
							foreach($client_list as $key=>$value)
							{
								echo '<option value="'.$value->id.'">'.$value->fullname.'</option>';
								
							}
						?>
					</select>
				</div>
				<div class="form-group">
					<label for="process">Process:</label>
					<select class="form-control" name="process" id="process" required>
						<option value="">--Select a Process--</option>
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

<div class="modal fade" id="modal_upload" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			
			
		</div>
	</div>
</div>