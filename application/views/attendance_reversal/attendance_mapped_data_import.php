<div class="wrap import_data">
	<section class="app-content">
		<div class="row">
			<div class="col-md-12">
				<?php if (!empty($this->input->get('elog')) && $this->input->get('elog') == "error") { ?>
					<div class="alert alert-danger" role="alert">
						<i class="fa fa-warning"></i> Record Already Exist!
					</div>
				<?php } ?>
			</div>
		</div>
		<?php
		$msg = '';
		if ($this->session->flashdata('msg')) {
			$msg = $this->session->flashdata('msg');
		?>
			<div class="alert alert-<?php echo $msg['class']; ?>" role="alert">
				<?php echo $msg['message']; ?>
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
		<?php
			$this->session->unset_userdata('msg');
		}
		?>
		<div class="row">
			<div class="col-md-12">
				<div class="white_widget padding_3">
					<h2 class="avail_title_heading">Upload Data <?php echo !empty($office_location) ? " | <span class='text-primary'>" . $office_location_indexed[$office_location]['office_name'] : "</span>"; ?></h2>
					<hr class="sepration_border" />
					<div class="body-widget clearfix">
						<form autocomplete="off" method="POST" enctype="multipart/form-data">
							<div class="row">
								<!-- <div class="col-md-4">
									<div class="form-group">
										<label>Office Location</label>
										<select name="office_location" id="office_location" class="form-control">
											<option value="">Select Office Location</option>
											<?php //foreach ($office_location_list as $key_location_list => $value_location_list) { 
											?>
												<option value="<?php //echo $value_location_list['abbr']; 
																?>" <?php echo (($value_location_list['abbr'] == $office_location) ? 'selected' : ''); ?>><?php echo $value_location_list['office_name']; ?></option>
											<?php //} 
											?>
										</select>
									</div>
								</div> -->
								<div class="col-md-4">
									<div class="form-group">
										<label>Time Zone</label>
										<select class="form-control" id="time_zone" name="time_zone" required>
											<option value="">--Select--</option>
											<option value="LOC" <?php echo (($time_zone == 'LOC') ? 'selected' : ''); ?>>Local</option>
											<option value="EST" <?php echo (($time_zone == 'EST') ? 'selected' : ''); ?>>EST</option>
										</select>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label>Client</label>
										<select class="form-control" id="fdclient_id" name="client_id" required>
											<option value="">--Select--</option>
											<?php foreach ($client_list as $client) : ?>
												<option value="<?php echo $client->id; ?>" <?php echo (($client_id == $client->id) ? 'selected' : ''); ?>><?php echo $client->shname; ?></option>
											<?php endforeach; ?>
										</select>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label>Source</label>
										<select class="form-control" id="source" name="source" required onchange="getSubSourceOptions($(this).val());">
											<option value="">--Select--</option>
											<?php foreach ($source_list as $sourceL) : ?>
												<option value="<?php echo $sourceL->id; ?>" <?php echo (($source == $sourceL->id) ? 'selected' : ''); ?>><?php echo $sourceL->source_name; ?></option>
											<?php endforeach; ?>
											<!-- <option value="DIALER" <?php echo (($time_zone == 'DIALER') ? 'selected' : ''); ?>>Dialer</option>
											<option value="CRM" <?php echo (($time_zone == 'CRM') ? 'selected' : ''); ?>>CRM</option>
											<option value="BOIMETRIC" <?php echo (($time_zone == 'BOIMETRIC') ? 'selected' : ''); ?>>Biometric</option> -->
										</select>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-4">
									<div class="form-group margin_all">
										<label>Sub Source</label>
										<select class="form-control" id="sub_source" name="sub_source" required>
											<option value="">--Select--</option>
											<?php foreach ($sub_source_list as $sub_sourceL) : ?>
												<option value="<?php echo $sub_sourceL->id; ?>" <?php echo (($sub_source == $sub_sourceL->id) ? 'selected' : ''); ?>><?php echo $sub_sourceL->sub_source; ?></option>
											<?php endforeach; ?>
										</select>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group margin_all file-upload">
										<label class="visiblity_hidden d_block">File Upload</label>
										<div class="file_upload_style">
											<input type="file" class="form-control input-file" name="upload_file" accept=".xlsx,.xls,.csv" required onchange="checkUploadedFile($(this));">
										</div>
										<small>File type allow .xlsx,.xls,.csv</small>
									</div>
								</div>
								<div class="col-md-4">
									<label class="visiblity_hidden d_block">Upload & Verify</label>
									<button type="submit" class="btn btn_padding filter_btn_blue btn-new">Upload & Verify</button>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
		<?php if ($show_addition != true) { ?>
			<div class="white_widget padding_3">
				<h4 class="avail_title_heading">Rules for Data Upload</h4>
				<hr class="sepration_border" />
				<div class="body-widget clearfix">
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<ul>
									<!-- <li class="li_class">Please convert xls sheet in CSV by using save as option in excel before upload.</li> -->
									<li class="li_class">We are accepting only well formated xlsx, xls, csv files.</li>
									<li class="li_class">Please keep single header for all columns in excel sheet.</li>
									<li class="li_class">Please remove blank rows from excel sheet before upload.</li>
									<li class="li_class"><a href="javascript:void(0);" onclick="DownloadFile('Dialer_data_sample_upload_format.xlsx')">Please click here download the xlsx format if you don't have a proper format.</a></li>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="or"> OR </div>
			<div class="white_widget padding_3">
				<h4 class="avail_title_heading">Upload Fixed format Excel (xlsx) file</h4>
				<hr class="sepration_border" />
				<div class="body-widget clearfix">
					<form autocomplete="off" action="<?php echo attendance_url('upload_fixed_header_data'); ?>" method="POST" enctype="multipart/form-data">
						<div class="row">
							<div class="col-md-4">
								<div class="form-group margin_all">
									<label>Time Zone</label>
									<select class="form-control" id="time_zone2" name="time_zone2" required>
										<option value="">--Select--</option>
										<option value="LOC" <?php echo (($time_zone2 == 'LOC') ? 'selected' : ''); ?>>Local</option>
										<option value="EST" <?php echo (($time_zone2 == 'EST') ? 'selected' : ''); ?>>EST</option>
									</select>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group margin_all file-upload">
									<label class="visiblity_hidden d_block">File Upload</label>
									<div class="file_upload_style">
										<input type="file" class="form-control input-file" name="upload_file" accept=".xlsx" required onchange="checkUploadedFileFixed($(this));">
									</div>
									<small>File type allow .xlsx</small>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group margin_all">
									<label class="visiblity_hidden d_block">Upload</label>
									<button type="submit" class="btn btn_padding filter_btn_blue save_common_btn btn-new">Upload</button>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		<?php } ?>
		<div class="common-top">
			<?php if ($show_addition == true) { ?>
				<div class="row">
					<div class="col-md-12">
						<div class="widget">
							<header class="widget-header">
								<h4 class="widget-title"><i class="fa fa-gear"></i> Verify Header Mapping</h4>
							</header>
							<hr class="widget-separator" />
							<div class="widget-body clearfix">
								<form autocomplete="off" action="<?php echo attendance_url('upload_file_data'); ?>" method="POST" enctype="multipart/form-data" id="upload_form">
									<input type="hidden" name="time_zone" value="<?php echo $time_zone; ?>" required>
									<input type="hidden" name="client_id" value="<?php echo $client_id; ?>" required>
									<input type="hidden" name="source" value="<?php echo $source; ?>" required>
									<input type="hidden" name="sub_source" value="<?php echo $sub_source; ?>" required>
									<input type="hidden" name="upload_id" value="<?php echo $upload_id; ?>" required>
									<input type="hidden" name="data_action_value" id="data_action_value" value="" required>
									<div class="row">
										<div class="col-md-1">
											<div class="form-group">
												<div class="panelQ">
												</div>
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group">
												<label>Header Name</label>
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group">
												<label>Select Existing Column</label>
											</div>
										</div>
										<div class="col-md-3" style="display: none;">
											<div class="form-group">
												<label>New Column Name</label>
											</div>
										</div>
									</div>
									<?php
									$cn = 0;
									// echo '<pre>';
									// print_r($result_columns); 
									// echo '</pre>';
									foreach ($result_columns as $token) {
										$cn++;
									?>
										<div class="row div_agentColumnAddition">
											<div class="col-md-1">
												<div class="form-group">
													<div class="panelQ">
														<span class="qCircle"><?php echo $token['cell']; ?></span>
														<input type="checkbox" name="checkbox_<?php echo $token['name']; ?>" value="1" style="display:none;">
													</div>
												</div>
											</div>
											<div class="col-md-4">
												<div class="form-group">
													<input class="form-control" type="hidden" name="header_cell[]" value="<?php echo $token['cell']; ?>" readonly required>
													<input class="form-control" name="header_name[]" value="<?php echo $token['name']; ?>" readonly required>
												</div>
											</div>
											<div class="col-md-4">
												<div class="form-group">
													<select class="form-control" name="header_map[]" required>
														<option value="">--Select--</option>
														<?php
														//print_r($token);
														$dropdown_options = $attendance_upload_header;
														$headerVal = '';
														foreach ($dropdown_options as $Headerkey => $Headervalue) {
															$headerVal = $Headervalue['header_name'];
															echo "<option value='" . $Headervalue['id'] . "' " . (($token['name'] == $Headervalue['header_name']) ? 'selected' : '') . ">" . $Headervalue['column_header'] . "</option>";
														}
														// echo $headerVal;
														// if(!empty($headerVal))
														// {
														// 	echo "<option value='_add_column' ".(($token['name'] != $headerVal)? 'selected' : '').">Not Required</option>";
														// }
														if (!in_array($token['name'], array_column($dropdown_options, 'header_name'))) {
															$is_new = true;
															echo "<option value='_add_column' selected>Not Required</option>";
														} else {
															echo "<option value='_add_column'>Not Required</option>";
														}
														// echo attendance_dropdown_3d_options_du($dropdown_options, 'column_header', 'header_name', $token['column']);
														// $is_new = false;
														// if (!in_array('du_' . $token['column'], array_column($dropdown_options, 'column_header'))) {
														// 	$is_new = true;
														// 	echo "<option value='_add_column' selected>Add New Column</option>";
														// }
														?>
													</select>
												</div>
											</div>
											<div class="col-md-3 div_newColumnEntry" <?php //if ($is_new == false) { echo 'style="display:none;"'; } 
																						?> style="display:none;">
												<div class="form-group">
													<input class="form-control" name="header_new[]" value="<?php echo $token['column']; ?>" readonly <?php if ($is_new == true) {
																																							echo 'required';
																																						} ?>>
												</div>
											</div>
										</div>
									<?php } ?>
									<div class="row">
										<div class="col-md-12">
											<div class="form-group">
												<!-- data-toggle="modal" data-target="#upload_rules" -->
												<button style="margin-top:20px" type="submit" class="btn btn-primary"><i class="fa fa-upload"></i> Map & Upload Data</button>
											</div>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
		</div>
	<?php } ?>
	<br /><br />
	</section>
</div>
<div class="modal fade" id="upload_rules" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header bg-primary">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel"><i class="fa fa-exclamation-triangle" aria-hidden="true" style="color:yellow;"></i> Data Action</h4>
			</div>
			<div class="modal-body">
				<div class="row" style="text-align: center;">
					<div class="col-md-12 form-group">
						<h3>What do you want with duplicate data ?</h3>
					</div>
				</div>
				<div class="row" style="text-align: center;">
					<div class="col-md-4">
						<div class="form-group">
							<input type="radio" name="data_action" id="replace" class="data_action" value="1">
							<label for="replace">Replace</label>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label for="overwrite">- OR -</label>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<input type="radio" name="data_action" id="overwrite" class="data_action" value="2">
							<label for="overwrite">Overwrite</label>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" id="start_upload_btn" class="btn btn-success" data-dismiss="modal">Close & Start Upload</button>
			</div>
			</form>
		</div>
	</div>
</div>
<?php
if ($show_addition != true) { ?>
	<!-- <script type="text/javascript">
		$(window).on('load', function() {
			setTimeout(function() {
				$('#upload_rules').modal('show');
			}, 5000);
		});
	</script> -->
<?php } ?>
<script>
	$(document).on('click', '#start_upload_btn', function() {
		var data_action = $('.data_action').val();
		$('#data_action_value').val(data_action);
		$('#upload_form').submit();
	});
	function DownloadFile(fileName) {
		//Set the File URL.
		var url = "<?php echo base_url('uploads'); ?>/" + fileName;
		$.ajax({
			url: url,
			cache: false,
			xhr: function() {
				var xhr = new XMLHttpRequest();
				xhr.onreadystatechange = function() {
					if (xhr.readyState == 2) {
						if (xhr.status == 200) {
							xhr.responseType = "blob";
						} else {
							xhr.responseType = "text";
						}
					}
				};
				return xhr;
			},
			success: function(data) {
				//Convert the Byte Data to BLOB object.
				var blob = new Blob([data], {
					type: "application/octetstream"
				});
				//Check the Browser type and download the File.
				var isIE = false || !!document.documentMode;
				if (isIE) {
					window.navigator.msSaveBlob(blob, fileName);
				} else {
					var url = window.URL || window.webkitURL;
					link = url.createObjectURL(blob);
					var a = $("<a />");
					a.attr("download", fileName);
					a.attr("href", link);
					$("body").append(a);
					a[0].click();
					$("body").remove(a);
				}
			}
		});
	};
</script>