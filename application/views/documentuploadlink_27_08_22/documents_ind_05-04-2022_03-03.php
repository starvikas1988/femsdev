<!DOCTYPE html>
<html lang="en" >
<head>
<meta charset="UTF-8">
<title>Upload Documents</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="https://fonts.googleapis.com/css?family=Poppins:400,600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">  
<link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/date-picker.css">  
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/custom2.css">
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/css/select2.min.css" rel="stylesheet" />
<style>
	.saq_input{
		width:95%; height:2.5rem; border:1px solid black; outline:none; padding-left:.5rem; border-radius:3px;
		background-color:transparent;
		}
	</style>
<style>
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

		td{
			font-size: 12px;
		}
		.form-control {
			height: unset;
			font-size: unset;
    		padding: unset;
    		width: unset;
		}
		input[type=file] {
			background: skyblue;
		}
		img{
			border-radius:4px;
		}

	/*start custom table design css here*/
	.table-main {
		width:100%;
	}
	.table-main .table td, .table th {
		vertical-align:middle;
	}
	.table-main label {
		margin-bottom:0;
	}
	.table-main .table-bordered {
		text-align:left;
		margin:0;
	}	
	.white-widget {
		width:100%;
		padding:10px;
		background:#fff;
		margin:0 0 10px 0;
	}
	.table-main .form-control {
		width:100%;
		height:auto;
		padding:8px;
		transition:all 0.5s ease-in-out 0s;
	}
	.table-main .form-control:hover {
		border:1px solid #188ae2;
	}
	.table-main .form-control:focus {
		border:1px solid #188ae2;
		outline:none;
		box-shadow:none;
	}
	.table-main th {
		padding: 5px;
		font-size: 15px;
		color: #fff;
		background:#188ae2;
	}
	.widget-left {
		width:100%;
		text-align:left;
	}
	.widget-left h4 {
		font-size:20px;
		font-weight:bold;
	}
	.table-main input[type=file] {
		background:transparent;
	}
	.vaccination-widget {
		width:100%;
	}
	.vaccination-widget .row {
		text-align:left;		
	}
	.vaccination-widget label {
		font-size:12px;
	}
	.vaccination-widget .saq_input {
		width:100%;
		height:auto;
		padding:6px;
		font-size:12px;
		border:1px solid #ced4da;
		transition:all 0.5s ease-in-out 0s;
	}
	.vaccination-widget .saq_input:hover {
		border:1px solid #188ae2;
	}
	.vaccination-widget .saq_input:focus {
		border:1px solid #188ae2;
		outline:none;
		box-shadow:none;
	}
	.vaccination-widget input[type=file] {
		background:transparent;		
	}
	.submit-btn {
		width: 150px;
		padding: 10px;
		background: #10c469;
		color: #fff!important;
		font-size: 13px;
		letter-spacing: 0.5px;
		transition: all 0.5s ease-in-out 0s;
		border: none!important;
		border-radius: 5px;
	}
	.submit-btn:hover {
		background: #0b8145;
		border: none!important;
	}
	.blue-btn {
		width: 150px;
		padding: 10px;
		margin:0 10px 0 0;
		background: #188ae2;
		color: #fff!important;
		font-size: 13px;
		letter-spacing: 0.5px;
		transition: all 0.5s ease-in-out 0s;
		border: none!important;
		border-radius: 5px;
	}
	.blue-btn:hover {
		background: #1061a1;
		border: none!important;
	}
	.blue-btn:focus {
		background: #1061a1;
		border: none!important;
	}
	.required {
		
	}
	/*end custom table design css here*/
</style>
</head>
<body>
<div class="container">
	<div class="top-main">
		<div class="row" style="border-bottom: 2px solid #b4b4b4;margin-bottom: 20px;">
			<div class="col-sm-4">
				<div class="body-widget">
					<img src="<?php echo base_url(); ?>assets/css/images/fusion-logo.png" class="logo" alt="">
				</div>
			</div>
		</div>	
	</div>
	<div class="row wide">
		<!-- <?php print_r($get_person); ?> -->
		<!--  action="<?php echo base_url()."document/process_upload" ?>" -->
		<div class="col-sm-12" id="form_container">
			<h3 class="text-center">Upload Your Documents (<?php echo $get_person[0]['fname'] ." ". $get_person[0]['lname']; ?>)</h3>
			<form id="msform" method="post" enctype="multipart/form-data">
				<div class="table-main">
					<div class="white-widget">
					<div class="widget-left">
						<h4>Personal Info <sup style="color:red;">*</sup></h4>
					</div>
				<table class="table table-striped table-bordered">
					<thead style="
					    background: skyblue;
					    color: #495057;
					    vertical-align: middle!important;
					">
					  <tr>
						<th>Description</th>
						<th>Uploaded File</th>
						<th>Action</th>
					  </tr>
					</thead>
					<tbody>

						<tr>
							<td>
								<label>Photograph</label>
							</td>
							<td>
							<input type="hidden" name="c_id" class="c_id" value="<?php echo $c_id;?>" required >
								<input type="hidden" name="user_office_id" class="exam" value="<?php echo $user_office_id; ?>" >
							<?php if(!empty($get_person[0]['photo'])) { ?>
							<img src="<?php echo base_url()."uploads/photo/".$get_person[0]['photo'] ?>" style="height: 80px; width: 80px;">
							<?php } 
							else{
								echo "No File Uploaded";
							} ?>
							</td>
							<td>
								<input type="file" value="<?= $get_person[0]['photo'] ?>" name="photo" class="form-control1" placeholder="" id="photofile"  accept=".pdf,image/*" required>
							</td>
					  	</tr>
					  	<tr>
					  		<td>
								<label>Aadhar Card / Social Security No <b>(Front Side)</b></label>
							</td>

							<td>
								<?php if (!empty($get_person[0]['attachment_adhar'])) {
								$directory_check = "candidate_aadhar";
								$file_url = base_url() ."/uploads/candidate_aadhar/" .$get_person[0]['attachment_adhar'];
								$icon_url = getIconUrl($get_person[0]['attachment_adhar'], $directory_check);  ?>
								 
								<a href="<?php echo base_url()."uploads/candidate_aadhar/".$get_person[0]['attachment_adhar'] ?>" target="_blank">
								<img width="35" style="height:30px!important;" src="<?php echo base_url() .$icon_url; ?>"/>  <?php echo $get_person[0]['attachment_adhar']; ?> </a>
							<?php  } else{
								echo "No File Uploaded";
							} ?>
							</td>
							<td>
								<input type="file" value="<?= $get_person[0]['attachment_adhar'] ?>" name="adhar" class="form-control1" placeholder="" id="adharfile" required="required" accept=".pdf,image/*">
							</td>
						
					 	</tr>
					  	<tr>
					  		<td>
								<label>Aadhar Card / Social Security No <b>(Back Side)</b></label>
							</td>

							<td>
								<?php if (!empty($get_person[0]['attachment_adhar_back'])) {
								$directory_check = "candidate_aadhar_back";
								$file_url = base_url() ."/uploads/candidate_aadhar_back/" .$get_person[0]['attachment_adhar_back'];
								$icon_url = getIconUrl($get_person[0]['attachment_adhar_back'], $directory_check);  ?>
								 
								<a href="<?php echo base_url()."uploads/candidate_aadhar_back/".$get_person[0]['attachment_adhar_back'] ?>" target="_blank">
								<img width="35" style="height:30px!important;" src="<?php echo base_url() .$icon_url; ?>"/>  <?php echo $get_person[0]['attachment_adhar_back']; ?> </a>
							<?php  } else{
								echo "No File Uploaded";
							} ?>
							</td>
							<td>
								<input type="file" value="<?= $get_person[0]['attachment_adhar_back'] ?>" name="adhar_back" class="form-control1" placeholder="" id="adharfileback" required="required" accept=".pdf,image/*">
							</td>
						
					 	</tr>

						  <tr>
							<td>
								<label class="pan">PAN Card</label>
								
							</td>
							<td>
								<?php if(!empty($get_person[0]['attachment_pan'])) { ?>
							<img src="<?php echo base_url()."uploads/pan/".$get_person[0]['attachment_pan'] ?>" style="height: 80px; width: 80px;">
							<?php } 
							else{
								echo "No File Uploaded";
							} ?>
						</td>
							<td>
								<input type="file" value="<?= $get_person[0]['attachment_pan'] ?>" name="pan" class="form-control1" placeholder="" id="panfile" accept=".pdf,image/*" required>
							</td>
						  </tr>

						  
						  <tr class="ten_pass">
							<td>
								<label class="pan">10th Pass <span style="color: red">*</span></label>
								
							</td>
							<td>
								Passing Year: 
						  		<input style="margin: auto;
    display: block;" type="text" value="" name="ten_passing_year" onkeypress="return isNumber(event)" class="form-control" placeholder="Passing Year" id="ten_passing_year"  required>
							</td>
							<td>
								Marks/Grade/CGPA/Result: 
						  		<input style="margin: auto;
    display: block;" type="text" value="" name="ten_percentage" onkeypress="return isNumber(event)" class="form-control" placeholder="Marks/Grade/CGPA/Result" id="ten_percentage"  required>
							</td>
							
						  </tr>	

						  	  <tr class="ten_pass">
							<td>
								<label class="pan">10th Pass Document</label>
								
							</td>
							<td>
								<?php if(!empty($get_edu[0]['education_doc'])) { ?>
							<img src="<?php echo base_url()."uploads/education_doc/".$get_edu[0]['education_doc'] ?>" style="height: 80px; width: 80px;">
							<?php } 
							else{
								echo "No File Uploaded";
							} ?>
							</td>
							<td>
								<input type="file" value="<?=(!empty($get_edu))?$get_edu[0]['education_doc']:''; ?>" name="ten_edu[]" class="form-control1" placeholder="" id="education_doc_ten" required accept=".doc,.docx,.pdf,image/*" >
								
							</td>
						  </tr>

						  
						  <?php 
						//   echo $onboarding_type;
						//   echo'<pre>';print_r($get_edu);
						  ?>
						  
						  <!------------------ Educational Doc--------------------------->
						  <?php 
						  //echo $onboarding_type;
						  if($onboarding_type == "NAPS"){
							// echo $onboarding_type;
						  //if(!empty($get_edu)){
							
						  ?>
						  <tr>
						  	<td align="text-center">
								Last Qualification: 
								<div style="margin:auto;display:block">
						  		<select class="form-control required" onchange="locations_checked(this.select)" id="last_qualification" name="last_qualification" required style="margin: auto;
    display: block;" >
								<option value="">--Select Last Qualification--</option>
								<?php
									foreach($qualification_list as $key=>$value)
									{
										echo '<option value="'.$value->qualification.'">'.$value->qualification.'</option>';
									}
								?>
								
							</select>
								</div>
						  	</td>
						  	<td>
								Passing Year: 
						  		<input style="margin: auto;
    display: block;" type="text" value="" name="passing_year" onkeypress="return isNumber(event)" class="form-control" placeholder="Passing Year" id="passing_year"  required>
						  	</td>
						  	<td>
								Marks/Grade/CGPA/Result: 
						  		<input style="margin: auto;
    display: block;" type="text" value="" name="percentage" onkeypress="return isNumber(event)" class="form-control" placeholder="Marks/Grade/CGPA/Result" id="percentage"  required>
						  	</td>
						  </tr>	

						  	 <tr>
							<td>
								<label class="pan">Last Qualification Document</label>
								
							</td>
							<td>
								<?php if(!empty($get_edu[0]['education_doc'])) { ?>
							<img src="<?php echo base_url()."uploads/education_doc/".$get_edu[0]['education_doc'] ?>" style="height: 80px; width: 80px;">
							<?php } 
							else{
								echo "No File Uploaded";
							} ?>
							</td>
							<td>
								<input type="file" value="<?=(!empty($get_edu))?$get_edu[0]['education_doc']:''; ?>" name="edu[]" class="form-control1" placeholder="" id="education_doc" required accept=".doc,.docx,.pdf,image/*" >
								
							</td>
						  </tr>


						  <?php
						  
						   //if ($location_current == "CHA") { 

						   	//echo 111;exit;
						   	?>
						   	
						  
						  <?php } ?>



						  <?php
						  
						   if ($location_current == "CHA") { 

						   	//echo 111;exit;
						   	?>

					
						  
					  <?php //} ?>
					  <tr>
							<td>
								<label class="pan">Signature</label>
								
							</td>
							<td>
								<?php if(!empty($get_person[0]['attachment_signature'])) { ?>
							<img src="<?php echo base_url()."uploads/candidate_sign/".$get_person[0]['attachment_signature'] ?>" style="height: 80px; width: 80px;">
							<?php } 
							else{
								echo "No File Uploaded";
							} ?>
							</td>
							<td>
								<input type="file" value="<?= $get_person[0]['attachment_signature'] ?>" name="attachment_signature" class="form-control1" placeholder="" id="attachment_signature" required accept=".pdf,image/*" >
								
							</td>
					 </tr>
										
					
					<!-- bank -->
						  
						  <!------------------ Signature--------------------------->
						  
						  
						  
						 <?php 
						  }
						 ?>
						  
						  
					</tbody>
				  </table>
				  </div>
				  </div>
				
				<div class="white-widget vaccination-widget">
				  <div class="saq">
					<div class="widget-left">
						<h4>Enter Your Covid Vaccination Information</h4>
					</div>
											
						<input type="hidden" name="" id="counter" value="1">
						
						<div class="Vaccination_information" style="display:flex; flex-wrap:wrap;">
							
							<input type="hidden" class="form-control" id="prof_uid" value='<?php echo $prof_uid; ?>' name="prof_uid" >
							<input type="hidden" class="form-control" id="prof_fid" value='<?php echo $prof_fid; ?>' name="prof_fid" >
								
						<div class="row vendor">
								
								
							<div class="col-md-3" style="">
								<div class="form-group">
								<label for="pno">1st Vaccine Dose Done?</label>
								<select class="saq_input" id="is_done_vac" name="is_done_vac"  required>
									<option value="">-- Select --</option>
									<option value="Yes">Yes</option>
									<option value="No">No</option>
								</select>
								</div>
								<input type="hidden" class="saq_input"  class="form-control" id="vac_dose" name="vac_dose" value='1st'>
							</div>
							
							<div class="col-md-3 vac_yes b_i" style="" >
								<div class="form-group">
								<label>Vaccine Name</label>
								<select class="saq_input" id="vac_name" name="vac_name" required>
									<option value="">-- Select --</option>
									<option value="Covaxin">Covaxin</option>
									<option value="Covishield">Covishield</option>
									<option value="Sputnik V">Sputnik V</option>
								</select>
								</div>
							</div>
							<div class="col-md-3 vac_yes b_i" style="" >
								<div class="form-group">
								<label>Vaccination Date</label>
								<input type="date" class="saq_input" id="vac_date" name="vac_date" autocomplete="off" required >
								</div>
							</div>
							<div class="col-md-3 vac_yes" style="">
								<div class="form-group">
								<label>Upload Document</label>
								<input type="file" class="saq_input" id="vac_file" name="vaccine" accept=".pdf,image/*" required="">
								</div>
							</div>
						</div>
						
						<div class="row">

							<div class="col-md-3 vac_yes2" style="display: none;">
								<div class="form-group">
								<label for="pno">2nd Vaccine Dose Done?</label>
								<select class="saq_input" id="is_done_vac2" name="is_done_vac2"  required>
									<option value="">-- Select --</option>
									<option value="Yes">Yes</option>
									<option value="No">No</option>
								</select>
								</div>
								<input type="hidden" class="saq_input"  id="vac_dose2" name="vac_dose2" value='2nd'>
							</div>

							
							<div class="col-md-3 b_i vac_yes2" style="display: none">
								<div class="form-group">
								<label>Vaccine Name</label>
								<select class="saq_input" id="vac_name2" name="vac_name2">
									<option value="">-- Select --</option>
									<option value="Covaxin">Covaxin</option>
									<option value="Covishield">Covishield</option>
									<option value="Sputnik V">Sputnik V</option>
								</select>
								</div>
							</div>
							<div class="col-md-3 b_i vac_yes2" style="display: none">
								<div class="form-group">
								<label>Vaccination Date</label>
								<input type="date" class="saq_input" id="vac_date2" name="vac_date2" autocomplete="off" >
								</div>
							</div>
							
							<div class="col-md-3 vac_yes2" style="display: none">
								<div class="form-group">
								<label>Upload Document</label>
								<input type="file" class="saq_input" id="vac_file2" name="vaccine2" accept=".pdf,image/*">
								</div>
							</div>
							
							
						</div>



						</div>
					</div>
					</div>
					
					<div class="white-widget">
					<div class="saq">
					<div class="widget-left">
						<h4>Enter Your Bank Information</h4>
					</div>
						<div class="table-main">
						
							<table class="table table-striped table-bordered">
								<tr>
							<td>
								<label class="">Bank Cancel Cheque / Passbook</label>
								
							</td>
							<td>
								<?php if(!empty($get_person[0]['attachment_bank'])) { ?>
							<img src="<?php echo base_url()."uploads/dfr_bank/".$get_person[0]['attachment_bank'] ?>" style="height: 80px; width: 80px;">
							<?php } 
							else{
								echo "No File Uploaded";
							} ?>
							</td>
							<td>
								<input type="file" value="<?= $get_person[0]['attachment_bank'] ?>" name="bank" class="form-control1" placeholder="" id="bankfile" accept=".pdf,image/*">
								
							</td>
						  </tr>
							</table>
							
						</div>
						
						<div id="bank_info" style="display:none">
							<div class="bank_information" style="display:flex; padding: .21rem; margin: 2rem 0; flex-wrap:wrap;">
								<div class="b_i" style="width:33%; margin-top: .5rem;">
									<div class="label"><label>Bank Name</label><sup style="color:red;">*</sup></div>
									<div class="label"><input type="text" value="<?= isset($get_person[0]['bank_name']) ? $get_person[0]['bank_name'] : '' ?>" name="bank_name" id="bank_name" class="saq_input"  placeholder="Bank name"/></div>
								</div>
								<div class="b_i" style="width:33%; margin-top: .5rem;">
									<div class="label"><label>Branch Name</label><sup style="color:red;">*</sup></div>
									<div class="label"><input type="text" value="<?= isset($get_person[0]['branch_name']) ? $get_person[0]['branch_name'] : '' ?>" name="branch_name" id="branch_name" class="saq_input"  placeholder="Branch name"/></div>
								</div>
								<div class="b_i" style="width:33%; margin-top: .5rem;">
									<div class="label"><label>Account Type</label><sup style="color:red;">*</sup></div>
									<div class="label"><select name="acc_type" class="saq_input" id="acc_type"><option value="Savings">Saving</option><option value="Checking">Checking</option></select></div>
								</div>
								<div class="b_i" style="width:50%; margin-top: .5rem;">
									<div class="label"><label>Accound Number</label><sup style="color:red;">*</sup></div>
									<div class="label"><input type="text" value="<?= isset($get_person[0]['bank_acc_no']) ? $get_person[0]['bank_acc_no'] : '' ?>" name="bank_acc_no" id="bank_acc_no" class="saq_input"  placeholder="Account Number"/></div>
								</div>
								<div class="b_i" style="width:50%; margin-top: .5rem;">
									<div class="label"><label>IFSC Code</label><sup style="color:red;">*</sup></div>
									<div class="label"><input type="text"  value="<?= isset($get_person[0]['ifsc_code']) ? $get_person[0]['ifsc_code'] : '' ?>" name="ifsc_code" id="ifsc_code" class="saq_input"  placeholder="IFSC CODE"  pattern="^[A-Z]{4}[0][A-Z0-9]{6}$" /></div>
								</div>
							</div>
						</div>
					</div>
					</div>
					
					<div class="white-widget">
				 <?php if(!empty($get_edu)) { ?>

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
							  	<td>Action</td>
							  </tr>
							  <?php foreach ($get_edu as $key => $value): ?>
							  	<tr>
							  	<th scope="row"><?php echo $key+1; ?></th>
							  	<td><?php echo $value['exam']; ?></td>
							  	<input type="hidden" name="exam[]" class="exam" value="<?php echo $value['exam']; ?>" >
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
							  		<a href="<?php echo base_url()."uploads/education_doc/".$value['education_doc']?>" target="_blank">
							  	 	<img width="35" style="height:30px!important;" src="<?php echo base_url() .$icon_url; ?>"/>  <?php echo $value['education_doc']; ?> </a>
							  	<?php }
							  	else{
									  		echo "No File Uploaded";
									  	} ?></td>
							  	<td class="file_uploader_education" data-id="1">
									Upload Your Document PDF &amp; Image Files Only
									
									<?php 
									if($onboarding_type == "NAPS"){
							  		?>
									<input type="file" value="<?= $get_edu[0]['education_doc'] ?>" name="edu[]" accept=".doc,.docx,.pdf,image/*"  required class="edufile">
									
									<?php 
									}else{
							  		?>
									
									<input type="file" value="<?= $get_edu[0]['education_doc'] ?>" name="edu[]" accept=".doc,.docx,.pdf,image/*"  class="edufile">
									<?php 
									}
							  		?>
									
								</td>
						</tr>
							  <?php endforeach ?>
							  
				  </tbody>
			</table>
		<?php } ?>

		<?php if(!empty($get_exp)) { ?>

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
							  	<td>Action</td>
							  </tr>
							  <?php foreach ($get_exp as $key => $value): ?>
							  		<tr>
									  	<th scope="row"><?php echo $key+1; ?></th>
									  	<td><?php echo $value['company_name']; ?></td>
									  	<input type="hidden" name="company_name[]" class="company_name" value="<?php echo $value['company_name']; ?>" >
									  	<td>
									  		<?php
									  		if(!empty($value['experience_doc'])) {
											$directory_check = "experience_doc";
											$file_url = base_url() ."/uploads/" .$directory_check ."/" .$value['experience_doc'];
											$icon_url = getIconUrl($value['experience_doc'], $directory_check); 
											?>
									  		<a href="<?php echo base_url()."uploads/experience_doc/".$value['experience_doc']?>" target="_blank"> 
									  		<img width="35" style="height:30px!important;" src="<?php echo base_url() .$icon_url; ?>"/>  <?php echo $value['experience_doc']; ?></a>
									  	<?php  }  else{
									  		echo "No File Uploaded";
									  	} ?></td>
									  	<td class="file_uploader" data-id="1">
								  			<div class="form-group">
												Upload Your Document PDF &amp; Image Files Only
													
												<input type="file" value="<?= $get_exp[0]['experience_doc'] ?>" name="exp[]" accept=".doc,.docx,.pdf,image/*" class="expfile">
											</div>
										</td>
									</tr>
							  <?php endforeach ?>
							  							  

						</tbody>
					</table>
				<?php } ?>
				</div>
										
					<div class="form-group">
						<div class="widget-left">
							<h4>Type The Below Text (Case Sensitive):</h4>
					</div>						
						<div class="input-group mb-3">
							<div class="input-group-prepend">
								<span class="input-group-text" id="captcha_image"><?php echo $captcha['image']?></span>
							</div>
							<input type="text" class="form-control required" id="basic-url" name="captcha" aria-describedby="basic-addon3" style="border-radius: .25rem;">
							
						</div>
					</div>
					
					<button type="button" id="reload_captcha" style="float:left;" class="btn btn-primary blue-btn">Reload</button>
					
					<button type="submit" class="btn btn-success submit-btn" style="float:left;">Submit</button>
					
				  <br><br><br><br><br>
			</form>			
		</div>
	</div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>


		<script>
			$(document).ready(function(){
				var phfile = $("#photofile").attr('value');
				if(phfile!==""){
					$("#photofile").removeAttr('required');
				}

				var vaccine = $("#vaccinefile").attr('value');
				if(phfile!==""){
					$("#vaccinefile").removeAttr('required');
				}

				var phfile = $("#adharfile").attr('value');
				if(phfile!==""){
					$("#adharfile").removeAttr('required');
				}
				
				var phfile = $("#adharfileback").attr('value');
				if(phfile!==""){
					$("#adharfileback").removeAttr('required');
				}
				
				var phfile = $("#bankfile").attr('value');
				if(phfile!==""){
					$("#bankfile").removeAttr('required');
				}
				var phfile = $(".edufile").attr('value');
				if(phfile!==""){
					$(".edufile").removeAttr('required');
				}
				var phfile = $(".expfile").attr('value');
				if(phfile!==""){
					$(".expfile").removeAttr('required');
				}
				
				var phfile = $("#attachment_signature").attr('value');
				if(phfile!==""){
					$("#attachment_signature").removeAttr('required');
				}
				
				var phfile = $("#education_doc").attr('value');
				if(phfile!==""){
					$("#education_doc").removeAttr('required');
				}

				
			});

			$(document).on('submit','#msform',function(e)
			{ 

				showPleaseWait();
				e.preventDefault();
				
					var datas = $(this).serializeArray();
					//console.log(datas);
					$.ajax({
						type	:	'POST',
						url		:	'<?php echo base_url('Documentuploadlink/process_upload'); ?>',
						data:  new FormData(this),
						contentType: false,
						cache: false,
						processData:false,
						success	:	function(msg){
									hidePleaseWait();
									var msg = JSON.parse(msg);
									if(msg.error == 'false')
									{
										$('#form_container').addClass('text-center card');
										$('#form_container').attr("style", "border: 1px solid; padding-top: 32px; padding-bottom: 32px;");
										$('.wide').attr("style", "width: 100%;margin-left: 0%;");
										$('#form_container').html('<h4>Thank You, You Have Successfully Uploaded your Documents</h4>');
										// window.location.reload();	
									}
									else if(msg.error == 'file_error')
									{
										alert('Unable to Upload File. Plase Re-Upload It.');
									}
									else if(msg.error == 'cap_error')
									{
										alert('Wrong Captcha Entered');
									}
									
								}
					});
				
			});
</script>

<script type="text/javascript">


function showPleaseWait() {
    
    if (document.querySelector("#pleaseWaitDialog") == null) {
        var modalLoading = '<div class="modal" id="pleaseWaitDialog" data-backdrop="static" data-keyboard="false" role="dialog">\
            <div class="modal-dialog">\
                <div class="modal-content">\
                    <div class="modal-header">\
                        <h4 class="modal-title">Please wait...</h4>\
                    </div>\
                    <div class="modal-body">\
                        <div class="progress">\
                          <div class="progress-bar progress-bar-success progress-bar-striped active" role="progressbar"\
                          aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width:100%; height: 40px">\
                          </div>\
                        </div>\
                    </div>\
                </div>\
            </div>\
        </div>';
        $(document.body).append(modalLoading);
    }
  
    $("#pleaseWaitDialog").modal("show");
}

/**
 * Hides "Please wait" overlay. See function showPleaseWait().
 */
function hidePleaseWait() {
    $("#pleaseWaitDialog").modal("hide");
}

</script>

<script type="text/javascript">
	
$('#panfile').change(function () {
    	var uploadpath = $('#panfile').val();
	    var fileExtension = uploadpath.substring(uploadpath.lastIndexOf(".") + 1, uploadpath.length);
		fileExtension = fileExtension.toLowerCase();
	    if (fileExtension == "doc" || fileExtension == "docx" || fileExtension == "pdf" || fileExtension == "jpg" || fileExtension == "jpeg" || fileExtension == "png") {
	        
	    }
	    else {
	    	alert("File type not supported please upload jpg,jpeg,png or pdf files");
	        $('#panfile').val('');
	        return false;
	    }
});

$('#photofile').change(function () {
    	var uploadpath = $('#photofile').val();
	    var fileExtension = uploadpath.substring(uploadpath.lastIndexOf(".") + 1, uploadpath.length);
		fileExtension = fileExtension.toLowerCase();
	    if (fileExtension == "doc" || fileExtension == "docx" || fileExtension == "pdf" || fileExtension == "jpg" || fileExtension == "jpeg" || fileExtension == "png") {
	        
	    }
	    else {
	    	alert("File type not supported please upload jpg,jpeg,png or pdf files");
	        $('#photofile').val('');
	        return false;
	    }
});

$('#bankfile').change(function () {
    	var uploadpath = $('#bankfile').val();
	    var fileExtension = uploadpath.substring(uploadpath.lastIndexOf(".") + 1, uploadpath.length);
		fileExtension = fileExtension.toLowerCase();
	    if (fileExtension == "doc" || fileExtension == "docx" || fileExtension == "pdf" || fileExtension == "jpg" || fileExtension == "jpeg" || fileExtension == "png") {
	        $("#bank_info").css("display", "block");
			$('#bank_name, #branch_name, #acc_type, #bank_acc_no, #ifsc_code').prop('required',true)
	    }
	    else {
	    	alert("File type not supported please upload jpg,jpeg,png or pdf files");
	        $('#bankfile').val('');
	        return false;
	    }
});

$('#adharfile').change(function () {
    	var uploadpath = $('#adharfile').val();
	    var fileExtension = uploadpath.substring(uploadpath.lastIndexOf(".") + 1, uploadpath.length);
		fileExtension = fileExtension.toLowerCase();
	    if (fileExtension == "doc" || fileExtension == "docx" || fileExtension == "pdf" || fileExtension == "jpg" || fileExtension == "jpeg" || fileExtension == "png") {
	        
	    }
	    else {
	    	alert("File type not supported please upload jpg,jpeg,png or pdf files");
	        $('#adharfile').val('');
	        return false;
	    }
});

$('#adharfileback').change(function () {
    	var uploadpath = $('#adharfileback').val();
	    var fileExtension = uploadpath.substring(uploadpath.lastIndexOf(".") + 1, uploadpath.length);
		fileExtension = fileExtension.toLowerCase();
	    if (fileExtension == "doc" || fileExtension == "docx" || fileExtension == "pdf" || fileExtension == "jpg" || fileExtension == "jpeg" || fileExtension == "png") {
	        
	    }
	    else {
	    	alert("File type not supported please upload jpg,jpeg,png or pdf files");
	        $('#adharfileback').val('');
	        return false;
	    }
});

$('.expfile').change(function () {
    	var uploadpath = $(this).val();
	    var fileExtension = uploadpath.substring(uploadpath.lastIndexOf(".") + 1, uploadpath.length);
		fileExtension = fileExtension.toLowerCase();
	    if (fileExtension == "doc" || fileExtension == "docx" || fileExtension == "pdf" || fileExtension == "jpg" || fileExtension == "jpeg" || fileExtension == "png") {
	        
	    }
	    else {
	    	alert("File type not supported please upload jpg,jpeg,png or pdf files");
	        //$('#expfile').val('');
			$(this).val('');
	        return false;
	    }
});





$('.edufile').change(function () {
    	var uploadpath = $(this).val();
	    var fileExtension = uploadpath.substring(uploadpath.lastIndexOf(".") + 1, uploadpath.length);
		fileExtension = fileExtension.toLowerCase();
	    if (fileExtension == "doc" || fileExtension == "docx" || fileExtension == "pdf" || fileExtension == "jpg" || fileExtension == "jpeg" || fileExtension == "png") {
	        
	    }
	    else {
	    	alert("File type not supported please upload jpg,jpeg,png or pdf files");
	        $(this).val('');
	        return false;
	    }
});


$('#vac_file,#vac_file2').change(function () {
    	var uploadpath = $(this).val();
	    var fileExtension = uploadpath.substring(uploadpath.lastIndexOf(".") + 1, uploadpath.length);
		fileExtension = fileExtension.toLowerCase();
	   if (fileExtension == "pdf" || fileExtension == "jpg" || fileExtension == "jpeg" || fileExtension == "png") {
	        
	    }
	    else {
	    	alert("File type not supported please upload jpg,jpeg,png or pdf files");
	        $(this).val('');
	        return false;
	    }
});


$(document).on('click','#reload_captcha',function()
			{
				var datas = {};
				$.ajax({
					type	:	'POST',
					url		:	'<?php echo base_url('applyjoblink/captcha/true'); ?>',
					data	:	datas,
					success	:	function(msg){
					var msg_json = JSON.parse(msg);
								$('#captcha_image').html(msg_json.image);
								
							}
				});
			});


	$("#is_done_vac").change(function(){
		
		
		var is_done_vac=$('#is_done_vac').val();
		
		if(is_done_vac == "Yes"){
			//$('.vac_yes').show();
			// $('#vac_file_div').removeAttr('style');
			$('#vac_name ,#vac_date,#vac_file,#is_done_vac2').attr('required','required');
			$('#vac_name ,#vac_date,#vac_file,#is_done_vac2').prop('disabled', false);
			$('.vac_yes2').show();
			$('#is_done_vac2').val('');
		}else{
			//$('.vac_yes').hide();
			$('#vac_name ,#vac_date,#vac_file,#is_done_vac2').val('');
			$('#vac_name ,#vac_date,#vac_file,#is_done_vac2').removeAttr('required');
			$('#vac_name ,#vac_date,#vac_file,#is_done_vac2').prop('disabled', true);
			$('.vac_yes2').hide();
			$('#vac_name2 ,#vac_date2,#vac_file2').removeAttr('required');
			
		}
	});

	$("#is_done_vac2").change(function(){
		var is_done_vac2=$('#is_done_vac2').val();
		if(is_done_vac2 == "Yes"){
			//$('.vac_yes2').show();
			$('#vac_name2 ,#vac_date2,#vac_file2').attr('required','required');
			$('#vac_name2 ,#vac_date2,#vac_file2').prop('disabled', false);
		}else{
			//$('.vac_yes2').hide();
			$('#vac_name2 ,#vac_date2,#vac_file2').val('');
			$('#vac_name2 ,#vac_date2,#vac_file2').removeAttr('required');
			$('#vac_name2 ,#vac_date2,#vac_file2').prop('disabled', true);
		}
	});
					
	
	$(document).on('click','.remove',function()
	{
		$(this).parent().parent().remove();
		$('#counter').val(1);
	});

	function locations_checked(){
		var last_qualification = $("#last_qualification").val();

		if (last_qualification == '10th Pass') {
			$('.ten_pass').hide();
			$("#education_doc_ten").removeAttr('required');
			$("#ten_passing_year").removeAttr('required');
			$("#ten_percentage").removeAttr('required');
		}else{
			$('.ten_pass').show();
			
		}
		
		
	}



</script>

</body>