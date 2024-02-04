<style>
	.show {
		padding-right: 21% !important;
	}

	.color_link {
		color: #007bff !important;
	}

	.correct_file {
		border: 2px solid #23e123 !important;
	}

	.wrong_file {
		border: 2px solid #e12323 !important;
	}

	#other_source_ref_container {
		display: none;
	}

	input[type=file] {
		background: skyblue;
	}

	/* 		
		.tableModel > thead > tr > th, .tableModel > thead > tr > td, .tableModel > tbody > tr > th, .tableModel > tbody > tr > td, .tableModel > tfoot > tr > th, .tableModel > tfoot > tr > td {
			padding:2px;
			font-size:11px;
		}
		
		.tableModel > tr > td{
			padding:2px;
			font-size:11px;
		} */
</style>


<div class="">
	<div class="row">
		<div class="col-sm-12">
			<div class="table_widget common_table_widget">
				<div class="form-group">
					<table id="default-datatable" data-plugin="DataTable" class="tableModel table-striped table-bordered" cellspacing="0" width="100%">
						<thead>
							<tr>
								<th>Description</th>
								<th>Uploaded File</th>
								<!-- <th>Action</th> -->
							</tr>
						</thead>
						<tbody>

							<tr>
								<td>
									<label>Photograph</label>
								</td>
								<td>
									<?php if (!empty($get_person[0]['photo'])) {
										$directory_check = "photo";
										$file_url = base_url() . "/uploads/" . $directory_check . "/" . $get_person[0]['photo'];
										$icon_url = getIconUrl($get_person[0]['photo'], $directory_check);  ?>
										<a href="<?php echo base_url() . "uploads/photo/" . $get_person[0]['photo'] ?>" target="_blank">
											<img width="35" style="height:30px!important;" src="<?php echo base_url() . $icon_url; ?>" /> <?php echo $get_person[0]['photo']; ?> </a>
									<?php  } else {
										echo "No File Uploaded";
									} ?>
								</td>

							</tr>

							<tr>
								<td>
									<label>National ID/Passport</label>
								</td>

								<td>
									<!-- <?php if (!empty($get_person[0]['attachment_adhar'])) {
												$directory_check = "candidate_national_id";
												$file_url = base_url() . "/uploads/candidate_national_id/" . $get_person[0]['attachment_adhar'];
												$icon_url = getIconUrl($get_person[0]['attachment_adhar'], $directory_check);  ?>
								 
								<a href="<?php echo base_url() . "uploads/candidate_national_id/" . $get_person[0]['attachment_adhar'] ?>" target="_blank">
								<img width="35" style="height:30px!important;" src="<?php echo base_url() . $icon_url; ?>"/>  <?php echo $get_person[0]['attachment_adhar']; ?> </a>
							<?php  } else {
												echo "No File Uploaded";
											} ?> -->

									<?php if (!empty($get_person[0]['attachment_adhar'])) {
										$reqCss = "";
										$directory_check = "candidate_aadhar";
										$file_url = base_url() . "/uploads/" . $directory_check . "/" . $get_person[0]['attachment_adhar'];
										$icon_url = getIconUrl($get_person[0]['attachment_adhar'], $directory_check);  ?>

										<a href="<?php echo base_url() . "uploads/" . $directory_check . "/" . $get_person[0]['attachment_adhar'] ?>" target="_blank">
											<img width="35" style="height:30px!important;" src="<?php echo base_url() . $icon_url; ?>" /> <?php echo $get_person[0]['attachment_adhar']; ?> </a>
									<?php  } else {
										$reqCss = "required";
										echo "No File Uploaded";
									} ?>
								</td>

							</tr>

							<!-- <tr>
					  		<td>
								<label>AFP Information</label>
							</td>

							<td>
								<?php if (!empty($get_person[0]['attachment_adhar'])) {
									$directory_check = "candidate_aadhar";
									$file_url = base_url() . "/uploads/" . $directory_check . "/" . $get_person[0]['attachment_adhar'];
									$icon_url = getIconUrl($get_person[0]['attachment_adhar'], $directory_check); ?>
								<a href="<?php echo base_url() . "uploads/candidate_aadhar/" . $get_person[0]['attachment_adhar'] ?>" target="_blank">
								<img width="35" style="height:30px!important;" src="<?php echo base_url() . $icon_url; ?>"/>  <?php echo $get_person[0]['attachment_adhar']; ?> </a>
							<?php  } else {
									echo "No File Uploaded";
								} ?></td>
							
						
					 	</tr> -->

							<tr>
								<td>
									<label>NIT</label>
								</td>
								<td>
									<?php if (!empty($get_person[0]['attachment_pan'])) {
										$directory_check = "pan";
										$file_url = base_url() . "/uploads/" . $directory_check . "/" . $get_person[0]['attachment_pan'];
										$icon_url = getIconUrl($get_person[0]['attachment_pan'], $directory_check);
									?>

										<a href="<?php echo base_url() . "uploads/pan/" . $get_person[0]['attachment_pan'] ?>" target="_blank">
											<img width="35" style="height:30px!important;" src="<?php echo base_url() . $icon_url; ?>" /> <?php echo $get_person[0]['attachment_pan']; ?></a>

										<!-- <img src="<?php echo base_url() . "uploads/pan/" . $get_person[0]['attachment_pan'] ?>" style="height: 80px; width: 80px;"> -->
									<?php } else {
										echo "No File Uploaded";
									} ?>
								</td>

							</tr>



							<tr>
								<td>
									<label>ISSS Information</label>
								</td>
								<td>

									<?php if (!empty($get_person[0]['attachment_health_insurence'])) {
										$directory_check = "candidate_insurence";
										$file_url = base_url() . "/uploads/" . $directory_check . "/" . $get_person[0]['attachment_health_insurence'];
										$icon_url = getIconUrl($get_person[0]['attachment_health_insurence'], $directory_check); ?>
										<a href="<?php echo base_url() . "uploads/candidate_insurence/" . $get_person[0]['attachment_health_insurence'] ?>" target="_blank">
											<img width="35" style="height:30px!important;" src="<?php echo base_url() . $icon_url; ?>" /> <?php echo $get_person[0]['attachment_health_insurence']; ?> </a>
									<?php  } else {
										echo "No File Uploaded";
									} ?>
								</td>

							</tr>

							<tr>
								<td>
									<label>Local background (30 days)</label>
								</td>

								<td>
									<?php if (!empty($get_person[0]['attachment_local_background'])) {
										$directory_check = "candidate_local_background";
										$file_url = base_url() . "/uploads/candidate_local_background/" . $get_person[0]['attachment_local_background'];
										$icon_url = getIconUrl($get_person[0]['attachment_local_background'], $directory_check);  ?>

										<a href="<?php echo base_url() . "uploads/candidate_local_background/" . $get_person[0]['attachment_local_background'] ?>" target="_blank">
											<img width="35" style="height:30px!important;" src="<?php echo base_url() . $icon_url; ?>" /> <?php echo $get_person[0]['attachment_local_background']; ?> </a>
									<?php  } else {
										echo "No File Uploaded";
									} ?>
								</td>

							</tr>

							<tr>
								<td>
									<label>Resume</label>
								</td>

								<td>
									<?php if (!empty($get_person[0]['attachment'])) {
										$directory_check = "candidate_resume";
										$file_url = base_url() . "/uploads/candidate_resume/" . $get_person[0]['attachment'];
										$icon_url = getIconUrl($get_person[0]['attachment'], $directory_check);  ?>

										<a href="<?php echo base_url() . "uploads/candidate_resume/" . $get_person[0]['attachment'] ?>" target="_blank">
											<img width="35" style="height:30px!important;" src="<?php echo base_url() . $icon_url; ?>" /> <?php echo $get_person[0]['attachment']; ?> </a>
									<?php  } else {
										echo "No File Uploaded";
									} ?>
								</td>

							</tr>
							<tr>
								<td>
									<label class="pan">Signature(optional)</label>

								</td>
								<td>
									<?php if (!empty($get_person[0]['attachment_signature'])) {
										$directory_check = "candidate_sign";
										$file_url = base_url() . "/uploads/" . $directory_check . "/" . $get_person[0]['attachment_signature'];
										$icon_url = getIconUrl($get_person[0]['attachment_signature'], $directory_check);
									?>

										<a href="<?php echo base_url() . "uploads/candidate_sign/" . $get_person[0]['attachment_signature'] ?>" target="_blank">
											<img width="35" style="height:30px!important;" src="<?php echo base_url() . $icon_url; ?>" /> <?php echo $get_person[0]['attachment_signature']; ?></a>
									<?php } else {
										echo "No File Uploaded";
									} ?>
								</td>
							</tr>





							<!--<tr>
						<td>
						<label>Covid-19 Declaration</label>
						</td>
						<td>
						<input type="file" name="covid" class="form-control" placeholder="" id="covid">
						</td>
					</tr>-->


						</tbody>
					</table>
				</div>
				<?php if (!empty($get_edu)) { ?>
					<div class="form-group">
						<table class="table table-bordered">
							<thead>
								<tr>
									<th scope="col" colspan="8" class="heading_common">Education Info <span class="red_bg">*</span></th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<th>SL</th>
									<th>Exam Name</th>
									<th>Passing Year</th>
									<th>Board/UV</th>
									<th>Specialization</th>
									<th>Grade/CGPA</th>
									<th>Uploaded File</th>
									<!-- <td>Action</td> -->
								</tr>
								<?php foreach ($get_edu as $key => $value) : ?>
									<tr>
										<th scope="row"><?php echo $key + 1; ?></th>
										<td><?php echo $value['exam']; ?></td>
										<td><?php echo $value['passing_year']; ?></td>
										<td><?php echo $value['board_uv']; ?></td>
										<td><?php echo $value['specialization']; ?></td>
										<td><?php echo $value['grade_cgpa']; ?></td>
										<td>
											<?php if (!empty($value['education_doc'])) {
												$directory_check = "education_doc";
												$file_url = base_url() . "/uploads/" . $directory_check . "/" . $value['education_doc'];
												$icon_url = getIconUrl($value['education_doc'], $directory_check);
											?>
												<a href="<?php echo base_url() . "uploads/education_doc/" . $value['education_doc'] ?>" target="_blank">
													<img width="35" style="height:30px!important;" src="<?php echo base_url() . $icon_url; ?>" /> <?php echo $value['education_doc']; ?> </a>
											<?php } else {
												echo "No File Uploaded";
											} ?>
										</td>
										<!-- <td class="file_uploader_education" data-id="1">
									Upload Your Document PDF &amp; Image Files Only
									<input type="file" name="edu[]" accept=".doc,.docx,.pdf,image/*" required id="edufile">
								</td> -->
									</tr>
								<?php endforeach ?>

							</tbody>
						</table>
					</div>
				<?php } ?>

				<?php if (!empty($get_exp)) { ?>
					<div class="form-group">
						<table class="table table-bordered">
							<thead>
								<tr>
									<th scope="col" colspan="4" class="heading_common">Experience
										<span class="red_bg">*</span>
									</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<th>SL</th>
									<th>Organization</th>
									<th>Uploaded File</th>
									<!-- <td>Action</td> -->
								</tr>
								<?php foreach ($get_exp as $key => $value) : ?>
									<tr>
										<th scope="row"><?php echo $key + 1; ?></th>
										<td><?php echo $value['company_name']; ?></td>
										<td>
											<?php
											if (!empty($value['experience_doc'])) {
												$directory_check = "experience_doc";
												$file_url = base_url() . "/uploads/" . $directory_check . "/" . $value['experience_doc'];
												$icon_url = getIconUrl($value['experience_doc'], $directory_check);
											?>
												<a href="<?php echo base_url() . "uploads/experience_doc/" . $value['experience_doc'] ?>" target="_blank">
													<img width="35" style="height:30px!important;" src="<?php echo base_url() . $icon_url; ?>" /> <?php echo $value['experience_doc'] ?> </a>
											<?php  } else {
												echo "No File Uploaded";
											} ?>
										</td>

									</tr>
								<?php endforeach ?>


							</tbody>
						</table>
					</div>
			</div>
		<?php } ?>


		</div>
	</div>
</div>