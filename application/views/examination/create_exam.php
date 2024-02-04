<style>
	#req_qualification_container {
		display: none;
	}
	#client_container,
	#dept_container,
	.application_container,
	#upload_file,
	.exam_set_container {
		display: none;
	}
	.upload_label {
		display: block;
		padding: 10px 0px;
		border: 1px dashed #666;
		border-radius: 5px;
		text-align: center;
		cursor: pointer;
	}
	.form-new #upload_file {
		display: block;
		margin: 0 0 15px 0;
	}
	.form-new #upload_support_file {
		margin: 15px 0 0 0;
		display: block !important;
	}
</style>
<div class="wrap">
	<?php if ($set_nav['nav'] == true) {  ?>
		<section class="app-content">
			<div class="row">
				<!-- DataTable -->
				<div class="col-md-12">
					<div class="widget">
						<header class="widget-header">
							<div class="row">
								<div class="col-sm-1 col-1 pull-right">
									<a href="<?php echo base_url(); ?>course/view_courses/<?php echo $set_nav['cat_id']; ?>/<?php echo $set_nav['cid']; ?>" class="btn  btn-success" title="Navigate Back"><i class="glyphicon glyphicon-arrow-left"></i> Back </a>
								</div>
								<div class="col-sm-1 col-1">
									<a href="<?php echo base_url(); ?>course/sample_download" class="btn  btn-danger" title="Download Examination Sample Upload Excel"><i class="glyphicon glyphicon-download"></i> Sample Examination</a>
								</div>
							</div>
						</header><!-- .widget-header -->
					</div><!-- .widget-body -->
				</div><!-- .widget -->
			</div>
			<!-- END DataTable -->
</div><!-- .row -->
</section>
<?php } ?>
<section class="app-content">
	<div class="row">
		<div class="col-md-12">
			<div class="white_widget padding_3">
				<div class="row d_flex">
					<div class="col-md-6">
						<h2 class="avail_title_heading">Examinations</h2>
					</div>
					<div class="col-md-6">
						<div class="right_side">
							<form method="GET" action="" class="d_inline">
								<div id="search_assmnt_batch">
									<select class="form-control" name="lt_type" id="lt_type">
										<option value="">-- Select Type --</option>
										<?php //print_r($loc); 
										?>
										<?php if ($set_nav['nav'] == false) { ?>
											<?php foreach ($examination_lt_type as $tokene) :
												$sel = "";
												//if($oValue== $loc['abbr'] ) $sel="selecteds" 	
											?>
												<option value="<?php echo $tokene['type']; ?>" <?php //echo $sel; 
																								?>><?php echo $tokene['type']; ?></option>
											<?php endforeach; ?>
										<?php } else { ?>
											<option value="CM" <?php //echo $sel; 
																?>>Course Module</option>
										<?php } ?>
									</select>
								</div>
							</form>
							<span class="btn btn_padding filter_btn cursor_pointer slight_minus" id="create_examination_btn">Create Examination</span>
							<a href="<?php echo base_url(); ?>course/sample_download" class="btn btn_padding filter_btn slight_minus" title="Download Sample Examination Excel">Sample Excel</a>
						</div>
					</div>
				</div>
				<hr class="sepration_border" />
				<div class="body-widget">
					<div class="table-responsive common_table_widget">
						<table id="default-datatable" data-plugin="DataTable" class="table table-bordered table-striped skt-table" width="100%" cellspacing="0">
							<thead>
								<tr>
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
	<div class="modal-dialog small_modal_new">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close close_new" data-dismiss="modal" aria-label="Close"></button>
				<h4 class="modal-title" id="myModalLabel">Create Examination</h4>
			</div>
			<form id="create_examination_form" method='POST'>
				<div class="modal-body">
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<input type="text" class="form-control" name="title" id="title" placeholder="Examination Name" required>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<select class="form-control" name="location_id" id="location_id" required>
									<?php
									if (get_global_access() == 1) echo "<option value=''>--Select a Location--</option>";
									if (get_global_access() == 1 || get_role_dir() == 'manager' || get_role_dir() == 'trainer') echo "<option value='ALL'>ALL</option>";
									?>
									<?php foreach ($location_list as $loc) : ?>
										<option value="<?php echo $loc['abbr']; ?>"><?php echo $loc['office_name']; ?></option>
									<?php endforeach; ?>
								</select>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<select class="form-control" name="type" id="type" required>
									<?php if ($set_nav['nav'] == false) { ?>
										<option value="">--Select an Examination Type--</option>
										<option value="IJP">Progression</option>
										<option value="QA">QA Dip Check</option>
										<option value="HR">HR/ER Online</option>
										<option value="TR">Training</option>
										<option value="CM">Course Module</option>
										<option value="KAT">KAT Module</option>
									<?php } else { ?>
										<option value="CM">Course Module</option>
									<?php }      ?>
								</select>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn_padding filter_btn_blue save_common_btn">Save</button>
				</div>
			</form>
		</div>
	</div>
</div>
<!--Final Selection-->
<div class="modal fade" id="exam_set_modal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog small_modal_new">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close close_new" data-dismiss="modal" aria-label="Close"></button>
				<h4 class="modal-title" id="myModalLabel">Upload Exam Set</h4>
			</div>
			<form id="exam_set_form" method='POST' enctype="multipart/form-data">
				<div class="modal-body">
					<div class="row">
						<div class="col-md-12">
							<div class="form-new file_upload_style">
								<!--
							<label for="upload_file" class="upload_label">Select File</label>
							-->
								<input type="hidden" name="set_id" class="form-control" id="set_id">
								<!--
								<input type="file" name="upload_file" id="upload_file" data-allowed_file_type="xlsx" data-max_size="1024" required>
								-->
								<input type="file" id="upload_file" class="form-control" name="upload_file" data-allowed_file_type="xlsx" data-max_size="1024" required>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<input type="checkbox" id="s_check" value="s_check">
							<label for="s_check"> I want to add support file for Agents</label><br>
						</div>
					</div>
					<div class="row" id="s_box" style="display:none">
						<div class="col-md-12">
							<div class="form-new">
								<!--
								<label for="upload_support_file" class="upload_label">Select Support File</label>
								-->
								<input type="hidden" name="support_file_id" class="form-control" id="support_file_id">
								<input type="file" name="upload_support_file" id="upload_support_file" data-allowed_file_type="xlsx" data-max_size="1024" style="display:none;">
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn_padding filter_btn_blue save_common_btn">Upload</button>
				</div>
			</form>
		</div>
	</div>
</div>
<!--Final Selection-->
<div class="modal fade" id="create_set_modal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog small_modal_new">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close close_new" data-dismiss="modal" aria-label="Close"></button>
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
					<button type="submit" class="btn btn_padding filter_btn_blue save_common_btn">Create</button>
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
				<button type="button" class="close close_new" data-dismiss="modal" aria-label="Close"></button>
				<h4 class="modal-title" id="myModalLabel">View Questions</h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-md-12">
						<div class="table-responsive common_table_widget">
							<table id="default-datatable" data-plugin="DataTable" class="table table-bordered table-striped skt-table" width="100%" cellspacing="0">
								<thead>
									<tr>
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