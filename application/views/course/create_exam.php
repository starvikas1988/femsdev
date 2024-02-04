
<style>
	.table > thead > tr > th, .table > thead > tr > td, .table > tbody > tr > th, .table > tbody > tr > td, .table > tfoot > tr > th, .table > tfoot > tr > td {
		padding:2px;
		text-align: center;
	}
	.btn{
		/*min-width:105px;*/
	}
	.label {
		/*padding: .7em .6em;*/
	}
	#req_qualification_container
	{
		display:none;
	}
	#client_container,#dept_container,.application_container,#upload_file,.exam_set_container
	{
		display:none;
	}
	.upload_label
	{
		display: block;
		padding: 10px 0px;
		border: 1px dashed #666;
		border-radius: 5px;
		text-align: center;
		cursor: pointer;
	}
	
</style>

<div class="wrap">
	<section class="app-content">
		<div class="row">
			<div class="col-md-12">
				<div class="widget">
					
					<div class="row">
						<div class="col-md-4">
							<header class="widget-header">
								<h4 class="widget-title">Examinations</h4>
							</header>
						</div>
						
						<div class="col-md-4">
						<div class="row" style="margin-top:10px;margin-bottom:10px">
						<form method="GET" action="">
						<div id="search_assmnt_batch" class="col-md-8">
							
								<select class="form-control" name="lt_type" id="lt_type">
									<option value="">-- Select Type --</option>
									<?php foreach($examination_lt_type as $tokene):
										$sel="";
										if($oValue== $loc['abbr'] ) $sel="selecteds"
																						
									?>
									
										<option value="<?php echo $tokene['type'];?>"  <?php echo $sel; ?> ><?php echo $tokene['type'];?></option>
										
									<?php endforeach; ?>
																			
								</select>
						</div>
						
						</form>
						</div>
						</div>
						
						<div class="col-md-3" style="float:right; margin-top:10px;margin-bottom:10px">
							<div class="form-group" style="float:right; padding-right:10px;">
								<span style="padding:10px;" class="label label-primary cursor_pointer" id="create_examination_btn">Create Examination</span>
							</div>
						</div>
					</div>
					<hr class="widget-separator">
					<div class="widget-body">
						<div class="table-responsive">
							<table id="default-datatable" data-plugin="DataTable" class="table table-striped skt-table" width="100%" cellspacing="0">
								<thead>
									<tr class="bg-info">
										<th>SL</th>
										<th>Title</th>
										<th>Location</th>
										<th>Type</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody id="examination_container">
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>

<!--Final Selection-->
<div class="modal fade" id="create_examination_modal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Create Examination</h4>
			</div>
			<form id="create_examination_form" method='POST'>
				<div class="modal-body">
					<div class="row">
						<div class="col-md-12">
							<input type="text" class="form-control" name="title" id="title" placeholder="Examination Name" required>
						</div>
					</div>
					<br>
					<div class="row">
						<div class="col-md-12">
							<select class="form-control" name="location_id" id="location_id" required>
								<?php
									if(get_global_access()==1) echo "<option value=''>--Select a Location--</option>";
								?>
								<?php foreach($location_list as $loc): ?>
									
									<option value="<?php echo $loc['abbr']; ?>"><?php echo $loc['office_name']; ?></option>
									
								<?php endforeach; ?>
																		
							</select>
						</div>
					</div>
					<br>
					<div class="row">
						<div class="col-md-12">
							<select class="form-control" name="type" id="type" required>
								<option value="">--Select an Examination Type--</option>
								<option value="IJP">Progression</option>
								<option value="QA">QA Dip Check</option>
								<option value="HR">HR/ER Online</option>
								<option value="TR">Training</option>
								<option value="CM">Course Module</option>
							</select>
						</div> 
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-primary">Save</button>
				</div>
			</form>
		</div>
	</div>
</div>

<!--Final Selection-->
<div class="modal fade" id="exam_set_modal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Upload Exam Set</h4>
			</div>
			<form id="exam_set_form" method='POST'>
				<div class="modal-body">
					<div class="row">
						<div class="col-md-12">
							<label for="upload_file" class="upload_label">Select File</label>
							<input type="hidden" name="set_id" class="form-control" id="set_id">
							<input type="file" name="upload_file" id="upload_file" data-allowed_file_type="xlsx" data-max_size="1024" required>
						</div>
					</div>
					
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-primary">Upload</button>
				</div>
			</form>
		</div>
	</div>
</div>

<!--Final Selection-->
<div class="modal fade" id="create_set_modal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Create Set</h4>
			</div>
			<form id="create_set_form" method='POST'>
				<div class="modal-body">
					<div class="row">
						<div class="col-md-12">
							<input type="hidden" name="exam_id" class="form-control" id="exam_id">
							<input type="text" name="set_name" class="form-control" id="set_name" placeholder="Set Name">
						</div>
					</div>
					
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-primary">Create</button>
				</div>
			</form>
		</div>
	</div>
</div>

<!--Final Selection-->
<div class="modal fade" id="view_question_modal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog" style="width:800px;">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">View Questions</h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-md-12">
						<div class="table-responsive">
							<table id="default-datatable" data-plugin="DataTable" class="table table-striped skt-table" width="100%" cellspacing="0">
								<thead>
									<tr class="bg-info">
										<th>SL</th>
										<th>Question</th>
										<th>Option 1</th>
										<th>Option 2</th>
										<th>Option 3</th>
										<th>Option 4</th>
									</tr>
								</thead>
								<tbody id="question_container">
								</tbody>
							</table>
						</div>
					</div>
				</div>
				
			</div>
			<div class="modal-footer">
				
			</div>
		</div>
	</div>
</div>