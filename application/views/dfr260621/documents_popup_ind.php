<style>
		.show 
		{
			padding-right: 21%!important;
		}
		.color_link 
		{
			color: #007bff!important;
		}
		.correct_file
		{
			border: 2px solid #23e123 !important;
		}
		.wrong_file
		{
			border: 2px solid #e12323 !important;
		}
		#other_source_ref_container
		{
			display:none;
		}
		
		input[type=file] {
			background: skyblue;
		}
		
		.tableModel > thead > tr > th, .tableModel > thead > tr > td, .tableModel > tbody > tr > th, .tableModel > tbody > tr > td, .tableModel > tfoot > tr > th, .tableModel > tfoot > tr > td {
			padding:2px;
			font-size:11px;
		}
		
		.tableModel > tr > td{
			padding:2px;
			font-size:11px;
		}
	
</style>


<div class="" >
	<div class="row">		
		<div class="col-sm-12">
				<table id="default-datatable" data-plugin="DataTable" class="tableModel table-bordered" cellspacing="0" width="100%">
					<thead>
					 <tr class='bg-info'>
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
								<?php if(!empty($get_person[0]['photo'])) { 
								$directory_check = "photo";
								$file_url = base_url() ."/uploads/" .$directory_check ."/" .$get_person[0]['photo'];
								$icon_url = getIconUrl($get_person[0]['photo'], $directory_check);  ?>
								<a href="<?php echo base_url()."uploads/photo/".$get_person[0]['photo'] ?>" target="_blank">
								<img width="35" style="height:30px!important;" src="<?php echo base_url() .$icon_url; ?>"/>  <?php echo $get_person[0]['photo']; ?> </a>
							<?php  } else{
								echo "No File Uploaded";
							} ?>
							</td>
							
					  	</tr>
					  	<tr>
					  		<td>
								<label>Aadhar Card / Social Security No <b>(Front Side)</b> </label>
							</td>

							<td>
								<?php if (!empty($get_person[0]['attachment_adhar'])) {
								$directory_check = "candidate_aadhar";
								$file_url = base_url() ."/uploads/" .$directory_check ."/" .$get_person[0]['attachment_adhar'];
								$icon_url = getIconUrl($get_person[0]['attachment_adhar'], $directory_check); ?>
								<a href="<?php echo base_url()."uploads/candidate_aadhar/".$get_person[0]['attachment_adhar'] ?>" target="_blank">
								<img width="35" style="height:30px!important;" src="<?php echo base_url() .$icon_url; ?>"/>  <?php echo $get_person[0]['attachment_adhar']; ?> </a>
							<?php  } else{
								echo "No File Uploaded";
							} ?></td>
							
						
					 	</tr>
					  	<tr>
					  		<td>
								<label>Aadhar Card / Social Security No <b>(Back Side)</b> </label>
							</td>

							<td>
								<?php if (!empty($get_person[0]['attachment_adhar_back'])) {
								$directory_check = "candidate_aadhar_back";
								$file_url = base_url() ."/uploads/" .$directory_check ."/" .$get_person[0]['attachment_adhar_back'];
								$icon_url = getIconUrl($get_person[0]['attachment_adhar_back'], $directory_check); ?>
								<a href="<?php echo base_url()."uploads/candidate_aadhar_back/".$get_person[0]['attachment_adhar_back'] ?>" target="_blank">
								<img width="35" style="height:30px!important;" src="<?php echo base_url() .$icon_url; ?>"/>  <?php echo $get_person[0]['attachment_adhar_back']; ?> </a>
							<?php  } else{
								echo "No File Uploaded";
							} ?></td>
							
						
					 	</tr>

						  <tr>
							<td>
								<label class="pan">PAN Card(optional)</label>
								
							</td>
							<td>
								<?php if(!empty($get_person[0]['attachment_pan'])) { ?>
							<img src="<?php echo base_url()."uploads/pan/".$get_person[0]['attachment_pan'] ?>" style="height: 80px; width: 80px;">
							<?php } 
							else{
								echo "No File Uploaded";
							} ?>
						</td>
						  </tr>

						  <tr>
					  		<td>
								<label>Bank Cancel Cheque / Passbook</label>
							</td>

							<td>
								<?php if (!empty($get_person[0]['attachment_bank'])) {
								$directory_check = "dfr_bank";
								$file_url = base_url() ."/uploads/" .$directory_check ."/" .$get_person[0]['attachment_bank'];
								$icon_url = getIconUrl($get_person[0]['attachment_bank'], $directory_check); ?>
								<a href="<?php echo base_url()."uploads/dfr_bank/".$get_person[0]['attachment_bank'] ?>" target="_blank">
								<img width="35" style="height:30px!important;" src="<?php echo base_url() .$icon_url; ?>"/>  <?php echo $get_person[0]['attachment_bank']; ?> </a>
							<?php  } else{
								echo "No File Uploaded";
							} ?></td>
							
						
					 	</tr>

					</tbody>
				  </table>
				 <?php
				 // print_r($get_edu);
				  if(!empty($get_edu)) { ?>

				  <table class="table table-bordered">
							  <thead>
								<tr>
								  <th scope="col" colspan="8" class="text-center">Education Info <sup style="color:red;">*</sup></th>
								</tr>
							  </thead>
							  <tbody>
							  <tr style="background-color:#81CAF1">
							  	<td>SL</td>
							  	<td>Exam Name</td>
							  	<td>Passing Year</td>
							  	<td>Board/UV</td>
							  	<td>Specialization</td>
							  	<td>Grade/CGPA</td>
							  	<td>Uploaded File</td>
							  	<!-- <td>Action</td> -->
							  </tr>
							  <?php foreach ($get_edu as $key => $value): ?>
							  	<tr>
							  	<th scope="row"><?php echo $key+1; ?></th>
							  	<td><?php echo $value['exam']; ?></td>
							  	<td><?php echo $value['passing_year']; ?></td>
							  	<td><?php echo $value['board_uv']; ?></td>
							  	<td><?php echo $value['specialization']; ?></td>
							  	<td><?php echo $value['grade_cgpa']; ?></td>
							  	<td>
							  		<?php if(!empty($value['education_doc'])) {
									$directory_check = "education_doc";
									$file_url = base_url() ."/uploads/" .$directory_check ."/" .$value['education_doc'];
									$icon_url = getIconUrl($value['education_doc'], $directory_check); 
									 ?>
							  		<a href="<?php echo base_url()."uploads/education_doc/".$value['education_doc'] ?>" target="_blank">
									<img width="35" style="height:30px!important;" src="<?php echo base_url() .$icon_url; ?>"/>  <?php echo $value['education_doc']; ?> </a>
							  	<?php }
							  	else{
									  		echo "No File Uploaded";
									  	} ?></td>
							  	<!-- <td class="file_uploader_education" data-id="1">
									Upload Your Document PDF &amp; Image Files Only
									<input type="file" name="edu[]" accept=".doc,.docx,.pdf,image/*" required id="edufile">
								</td> -->
						</tr>
							  <?php endforeach ?>
							  
				  </tbody>
			</table>
		<?php } ?>

		<?php
		// print_r($get_exp);
		 if(!empty($get_exp)) { ?>

			<table class="table table-bordered">
							  <thead>
								<tr>
								  <th scope="col" colspan="4" class="text-center">Experience 
								  	<sup style="color:red;">*</sup>
								  </th>
								</tr>
							  </thead>
							  <tbody>
							  <tr style="background-color:#81CAF1">
							  	<td>SL</td>
							  	<td>Organization</td>
							  	<td>Uploaded File</td>
							  	<!-- <td>Action</td> -->
							  </tr>
							  <?php foreach ($get_exp as $key => $value): ?>
							  		<tr>
									  	<th scope="row"><?php echo $key+1; ?></th>
									  	<td><?php echo $value['company_name']; ?></td>
									  	<td>
									  		<?php
									  		if(!empty($value['experience_doc'])) {
											$directory_check = "experience_doc";
											$file_url = base_url() ."/uploads/" .$directory_check ."/" .$value['experience_doc'];
											$icon_url = getIconUrl($value['experience_doc'], $directory_check); 
											?>
									  		<a href="<?php echo base_url()."uploads/experience_doc/".$value['experience_doc'] ?>" target="_blank">
											<img width="35" style="height:30px!important;" src="<?php echo base_url() .$icon_url; ?>"/>  <?php echo $value['experience_doc'] ?> </a>
									  	<?php  }  else{
									  		echo "No File Uploaded";
									  	} ?></td>
									  	
									</tr>
							  <?php endforeach ?>
							  							  

						</tbody>
					</table>
				<?php } ?>
		</div>
	</div>
</div>