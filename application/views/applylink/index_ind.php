<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
  <title>Fusion Application Form</title>
  


  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://fonts.googleapis.com/css?family=Poppins:400,600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <!-- <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous"> -->
  <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/date-picker.css">  
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/linkcustom.css">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/css/select2.min.css" rel="stylesheet">

<style>
	   .require{
		   color:red;
	   }
			#resume_container
			{
				height: 120px;text-align: center;line-height: 120px;border: 2px dashed #666;font-size: 25px;border-radius: 4px;cursor: pointer;width:100%;
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
			.input-error {
			    border-color: red !important;
			}

			.input-file2 {
			    position: absolute;
			    top: 0;
			    left: 0;
			    width: 225px;
			    padding: 14px 0;
			    opacity: 0;
			    cursor: pointer;
			}
			.input-file-trigger2 {
			    display: block;
			    padding: 25px 45px;
			    background: transparent;
			    color: #000;
			    font-size: 1em !important;
			    transition: all .4s;
			    cursor: pointer;
			    border-radius: 0;
			    border: 2px dotted #000;
			}

			.input-file3 {
			    position: absolute;
			    top: 0;
			    left: 0;
			    width: 225px;
			    padding: 14px 0;
			    opacity: 0;
			    cursor: pointer;
			}
			.input-file-trigger3 {
			    display: block;
			    padding: 25px 45px;
			    background: transparent;
			    color: #000;
			    font-size: 1em !important;
			    transition: all .4s;
			    cursor: pointer;
			    border-radius: 0;
			    border: 2px dotted #000;
			}

			select{
				background: url(<?php echo base_url(); ?>assets/css/images/select-bg.png) no-repeat right #fff !important;	
			}
			#progressbar li {
			    width: 14.28%;
			}
			#progressbar #additional:before {
			    font-family: FontAwesome;
			    content: "\f21d";
			}
			body {
			    font-size: 12px;
			}
			.fa-plus:before{
			    font-family: FontAwesome;
			}
			.fa-minus:before{
			    font-family: FontAwesome;
			}
			i {
			    font-style: unset;
			}
			@media (min-width: 1200px){
				.container, .container-lg, .container-md, .container-sm, .container-xl{
			    max-width: 95% !important;
			}
			}
			
			
			.err{
				color:red;
			}
	</style>

</head>
<body>

<section id="form-category" class="form-category">	
	<div class="container">
		<div class="top-main" style="border-bottom: 2px solid #b4b4b4;">
			<div class="row">
				<div class="col-sm-4">
					<div class="body-widget">
						<img src="<?php echo base_url(); ?>assets/css/images/fusion-logo.png" class="logo" alt="">
					</div>
				</div>
				<div class="col-sm-8">
					<div class="top-right">
						<div class="body-widget">
							<h2 class="top-title">
								Applying For <?php echo $role_name; //echo str_replace('%20',' ',$job_title); ?>
							</h2>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
        <div class="col-sm-12" id="form_container">
            <div class="card px-0 pb-0">                
                <div class="row">
                    <div class="col-md-12 mx-0">
                        <form id="msform" method="POST" enctype="multipart/form-data">
                            <!-- progressbar -->
                            <ul id="progressbar">
                                <li class="active" id="personal">
									<strong>Personal Info</strong>
								</li>
								<li id="additional">
									<strong>
										Additional Info
									</strong>
								</li>
                                <li id="education">
									<strong>
										Educational
									</strong>
								</li>
                                <li id="family">
									<strong>
									Family
									</strong>
								</li>
                                <li id="organization">
									<strong>
										Experience
									</strong>
								</li>
								<li id="references">
									<strong>
										References
									</strong>
								</li>
								<li id="confirm">
									<strong>
										Confirmation
									</strong>
								</li>
                            </ul>
							<div class="common-top">
								<div class="form-widget">
									<fieldset>
										<div class="form-repeat">
										  <div class="row">
										  
											<div class="col-sm-3">
												<div class="body-widget">
													<div class="form-group">
													  <label>
														<strong>First name <span class="require">*</span></strong>
													  </label>
											         <input type="text" name="first_name" class="form-control required" value='<?php echo $canrow['fname']; ?>' placeholder="First name" readonly>
													  <input type="hidden" name="rq_id" id="rq_id" class="form-control" value="<?php echo $rq_id; ?>">
													  <input type="hidden" name="r_id" id="r_id" class="form-control" value="<?php echo $r_id; ?>">
													  <input type="hidden" name="cid" id="cid" class="form-control required" value="<?php echo $cid; ?>">
									                  <input type="hidden" name="link_token" id="link_token" class="form-control required" value='<?php echo $canrow['link_token']; ?>' >
													  
													</div>
												</div>
											</div>
											<div class="col-sm-3">
												<div class="body-widget">
													<div class="form-group">
													  <label>
														<strong>Last name</strong>
													  </label>
													  <input type="text" name="last_name" class="form-control " value='<?php echo $canrow['lname']; ?>' placeholder="Last name" readonly>
													</div>
												</div>
											</div>
											<div class="col-sm-3">
												<div class="body-widget">
													<div class="form-group">
													  <label>
														<strong>DOB <span class="require">*</span></strong>
													  </label>	  
													  <input type="date" name="dob" class="form-control required" placeholder="DOB" >
													</div>
												</div>
											</div>
											<div class="col-sm-3">
												<div class="body-widget">
													<div class="form-group">
													  <label>
														<strong>Gender <span class="require">*</span></strong>
													  </label>
													  <select class="form-control required" id="gender" name="gender">
														<option value="">--Select--</option>
														<option value="Male">Male</option>
														<option value="Female">Female</option>
														<option value="Other">Other</option>
													</select>
												</div>
											</div>
										  </div>
										</div>
										<div class="row">
											<div class="col-sm-6">
											<div class="form-group">
													  <label>
														<strong>Guardian's Name(Father/Mother/Husband) <span class="require">*</span></strong>
													  </label>
													  <input type="text" name="guardian_name" class="form-control required" placeholder="Guardian's Name">
													</div>
												</div>

											<div class="col-sm-6">
												<div class="form-group">
												<label>
														<strong>Relation With Guardian <span class="require">*</span></strong>
												</label>
												<select name="relation_guardian" class="form-control required">
													<option value="">--Select--</option>
													<option value="Father">Father</option>
													<option value="Mother">Mother</option>
													<option value="Husband">Husband</option>
													<option value="Wife">Wife</option>
												</select>
												</div>	
											</div>
										</div>
											
									</div>
									  <div class="form-repeat">
										<p>
											<strong>
												Do you know anyone in Fusion / Are you applying through any Fusion / Xplore-Tech Employee?
											</strong>
										</p>
										<div class="custom-control custom-checkbox">
											<input type="checkbox" class="custom-control-input" id="referal" name="referal" value="Existing Employee">
											<label class="custom-control-label" for="referal">Check Me If Yes</label>
										</div>
									  </div>
									  <div class="form-group d-none" id="ref_by_comp_emplo">
											<div class="form-row">
												<div class="col" id="ref_employee_name_container">
													
													<select class="form-control" name="comp_employee_name" id="employee_id_xpo" style="width:100%;" disabled >
														<option value="">--Select--</option>
													<?php
														foreach($user_list_ref as $key=>$value)
														{
															echo '<option data-dept="'.$value['dept_name'].'" data-name="'.$value['fname'].' '.$value['lname'].'" value="'.$value['fusion_id'].'">'.$value['fname'].' '.$value['lname'] .', '.$value['fusion_id'] .', '.$value['xpoid'].' ('.$value['office_id'].')</option>';
														}
													?>
													</select>
												</div>
												<div class="col">
												<input type="text" class="form-control" name="comp_employee_id" placeholder="Employee Name" value="" readonly>
												</div>
												<div class="col">
												<input type="text" class="form-control" name="comp_employee_dept" placeholder="Employee Dept" value="" readonly>
												</div>
											</div>
										</div>
									  <div class="form-repeat" id="ref_job_vacancy">
										<p>
											<strong>
												How you come to know about the vacancy:
											</strong>
										</p>
										<div class="radio">
										  <label class="radio-inline">
											<input class="" type="radio" name="referal" id="job_source_portal" value="Job Portal"> 
											Job Portal
										  </label>
										  <label class="radio-inline">
											<input class="" type="radio" name="referal" id="job_source_consult" value="Consultancy">
											Consultancy
										  </label>
										  <label class="radio-inline">
											<input class="" type="radio" name="referal" id="news_paper" value="News Paper">
											News Paper
										  </label>
										  <label class="radio-inline">
											<input class="" type="radio" name="referal" id="call_hr" value="Call By HR">
											Call By HR
										  </label>
										  <label class="radio-inline">
											<input class="" type="radio" name="referal" id="walkin" value="Walkin">
											Walkin
										  </label>
										</div>
									  </div>

									  <div class="form-group" id="other_source_ref_container">
										<label></label>
										<select class="js-example-basic-single form-control" name="comp_employee_name" style="width:100%;">
											<option></option>
										</select>
									</div>

									  <div class="form-repeat">
										  <div class="row">
											<div class="col-sm-2">
												<div class="body-widget">
													<div class="form-group">
													  <label>
														<strong>Country <span class="require">*</span></strong>
													  </label>
													  <select name="country" class="form-control required" id="country" >
														<option value="">--Select Country--</option>
														<?php
														foreach($get_countries as $key=>$value)
														{
															echo '<option data-id="'.$value['id'].'" value="'.$value['name'].'">'.$value['name'].'</option>';
														}
														?>
														</select>
													</div>
												</div>
											</div>
											<div class="col-sm-2">
												<div class="body-widget">
													<div class="form-group">
													  <label>
														<strong>State<span class="require">*</span></strong>
													  </label>
													  <select name="state" class="form-control required" id="state" >
													  </select>
													</div>
												</div>
											</div>
											<div class="col-sm-2">
												<div class="body-widget">
													<div class="form-group">
													  <label>
														<strong>City <span class="require">*</span></strong>
													  </label>
													  <select name="city" class="form-control required" id="city" >
									
														</select>
													</div>
												</div>
											</div>
											<div class="col-sm-2">
												<div class="body-widget">
													<div class="form-group">
													  <label>
														<strong>Other</strong>
													  </label>
													  <input type="text" name="city" id="others" class="form-control" placeholder="City"  disabled>
													</div>
												</div>
											</div>
											<div class="col-sm-2">
												<div class="body-widget">
													<div class="form-group">
													  <label>
														<strong>Postcode <span class="require">*</span></strong>
													  </label>
													  <input type="text" name="postcode" class="form-control checkNumber required" id="postcode" placeholder="Postcode" onblur="checkPostCode()">
													  <span class="err" id="postcode_err"></span>
													</div>
												</div>
											</div>
										  </div>
									  </div>
									  <div class="form-repeat">
										<div class="row">
											<div class="col-sm-6">
												<div class="form-group">
													 <label>
														<strong>Permanent Address <span class="require">*</span></strong>
													 </label>
													 <textarea class="form-control required" id="parmanent_address" name="parmanent_address" placeholder="Permanent Address"></textarea>
												</div>
											</div>
											<div class="col-sm-6">
												<div class="form-group">
													 <label>
														<strong>Address for Correspondence</strong>
													</label>
													 <textarea class="form-control" id="correspondence_address" name="correspondence_address" placeholder="Address for Correspondence"></textarea>
												</div>
											</div>
										</div>
									  </div>
									  <div class="form-repeat">
										<div class="row">
											<div class="col-sm-4">
												<div class="form-group">
													<label>
														<strong>Mobile No </strong><span>(Aadhaar linked mobile number)</span> <span class="require">*</span>
													</label>
													 <input type="text"  class="form-control checkNumber required" id="mobile_no" name="mobile_no" placeholder="Mobile No" onblur="checkMobile()">
													 <span class="err" id="mobile_err"></span>
													</div>
											</div>
											<div class="col-sm-4">
												<div class="form-group">
													 <label>
														<strong>Alternative No</strong>
													 </label>
													 <input type="text" class="form-control checkNumber" id="alternate_no" name="alternate_no" placeholder="Alternate No">
							
													</div>
											</div>
											<div class="col-sm-4">
												<div class="form-group">
													 <label>
														<strong>Email <span class="require">*</span></strong>
													 </label>
													 <input type="email" id="email" name="email" value='<?php echo $canrow['email']; ?>' class="form-control required" placeholder="Email">
												     <span class="err" id="email_err"></span>
													</div>
											</div>
											
											
											<div class="col-sm-4">
												<div class="form-group">
													 <label>
													 	<strong>Aadhaar No <span class="require">*</span></strong>
													 </label>
													 <input type="text" class="form-control checkNumber required" placeholder="Aadhaar No" id="adhar" name="adhar" onblur="checkAadhar()">
													 <span class="err" id="adhar_err"></span>
													</div>
											</div>
										
										
											<div class="col-sm-4">
												<div class="form-group">
													 <label>
														<strong>Pan No</strong>
													 </label>
													 <input type="text" class="form-control" placeholder="Pan No" id="pan" name="pan" onblur="checkPan()">
													 <span class="err" id="pan_err"></span>
												</div>
											</div>

											<div class="col-sm-4">
												<div class="form-group">
													 <label>
														<strong>Caste <span class="require">*</span></strong>
													 </label>
													 <select class="form-control required" id="caste" name="caste">
														<option value="">--Select--</option>
														<option value="SC">SC</option>
														<option value="ST">ST</option>
														<option value="General">General</option>
														<option value="Other">Other</option>
													</select>
													
												</div>
											</div>
										</div>

									  </div>
								
									  <div class="row">
									  	<div class="col-sm-4">
									  <div class="form-repeat">
											<p>
												<strong>
													Married
												</strong>
											</p>
											<div class="radio">
											  <label class="radio-inline">
												<input class="" type="radio" name="married" id="inlineRadio1" value="Yes"> 
												Yes
											  </label>
											  <label class="radio-inline">
												<input class="" type="radio" name="married" id="inlineRadio2" value="No">
												No
											  </label>
											</div>
										</div>
									</div>
										<div class="col-sm-4" id="marriage_date" style="display:block">
												<div class="body-widget">
													<div class="form-group">
													  <label>
														<strong>Marriage Date</strong>
													  </label>	  
													  <input type="date" name="dom" class="form-control" placeholder="DOM">
													</div>
												</div>
											</div>
											<div class="col-sm-4">
												<label>
														<strong>Home Town</strong>
													  </label>
											<div class="form-repeat">
											<input type="text" class="form-control" name="home_town" id="home_town" placeholder="Home Town">
										</div>
									</div>
										</div>
										<button type="button" name="next" class="next action-button" id="first_btn">Next Step</button>

									</fieldset>
									<fieldset>
									  <div class="form-repeat">
										<div class="row">
											<div class="col-sm-6">
												<p>
													<strong>
													Own Conveyance
													</strong>
												</p>
												<div class="radio">
													  <label class="radio-inline">
														<input class="" type="radio" name="conveyance" id="conveyance_yes" value="Yes">
														Yes
													  </label>
													  <label class="radio-inline">
														<input class="" type="radio" name="conveyance" id="conveyance_no" value="No">
														No
													  </label>
												</div>
											</div>
											<div class="col-sm-6">
												<div class="form-group">
													 <label>Driving Licence</label>
													 <input type="text" class="form-control" name="d_licence" id="d_licence" placeholder="Driving Licence">
												</div>
											</div>
										</div>
									  </div>
									  <div class="form-repeat">
										<div class="row">
											
											<div class="col-sm-6">
												<div class="form-group">
													<p>
														<strong>
															Field of Interest
														</strong>
													</p>
													<div class="radio">
													  <label class="radio-inline">
														<input class="" type="radio" name="interest" id="interest_voice" value="Voice">
														Voice
													  </label>
													  <label class="radio-inline">
														<input class="" type="radio" name="interest" id="interest_back" value="Back Office">
														Back Office
													  </label>
													  <label class="radio-inline">
														<input class="" type="radio" name="interest" id="interest_other" value="Other">
														Other
													  </label>
													</div>
												</div>
											</div>
											<div class="col-sm-6" id="interest_type" style="display:none">
												<p>		
													<strong>
														If Other, Please Describe
													</strong>
												</p>
												<div class="form-group">
													<input type="text" class="form-control" id="interest_desc" name="interest_desc" placeholder="Describe Other Field Interest">
												</div>
											</div>
										</div>
									  </div>
									  <div class="form-repeat">
										<div class="row">
											<div class="col-sm-6">	
												<p>		
													<strong>
														Have you worked with Xplore-Tech / Fusion BPO before? if yes please specify L.W.D & Dept.
													</strong>
												</p>
												<div class="form-group">
													<input type="text" class="form-control" id="past_employee" name="past_employee" placeholder="L.W.D & Dept">
												</div>
											</div>
											<div class="col-sm-6">
												<p>	
													<strong>
														Have you appeared for interview before? If Yes,<br> please specify when?
													</strong>
												</p>
												<div class="form-group">
													<input type="date" id="past_inter_date" name="past_inter_date" class="form-control">
												</div>
											</div>
										</div>
									  </div>
									  <div class="form-repeat">
										<p>
											<strong>
												Are you willing to work in 24x7 service standard?*
											</strong>
										</p>
										<div class="radio">
										  <label class="radio-inline">
											<input class="" type="radio" name="service_standard" id="service_standard_yes" value="Yes"> 
											Yes
										  </label>
										  <label class="radio-inline">
											<input class="" type="radio" name="service_standard" id="service_standard_no" value="No">
											No
										  </label>
										</div>
									  </div>
									  <div class="form-repeat">
										<div class="row">
											<div class="col-sm-6">
												<p>
													<strong>
														Skill Set Areas:
													</strong>
												</p>
												<div class="form-group">
													<input type="text" class="form-control" id="skills" name="skills" placeholder="separate by ','">
												</div>
											</div>
											<div class="col-sm-6">
												<p>
													<strong>
														Last Qualification <span class="require">*</span>
													</strong>
												</p>
												<div class="form-group">
													<select class="form-control required" id="last_qualification" name="last_qualification" >
														<option value="">--Select Last Qualification--</option>
														<?php
															foreach($qualification_list as $key=>$value)
															{
																echo '<option value="'.$value->qualification.'">'.$value->qualification.'</option>';
															}
														?>
														
													</select>
												</div>
											</div>
										</div>
									  </div>
									  <div class="form-repeat">
										<div class="row">
											<div class="col-sm-6">
												<div class="form-group">
													<p>
														<strong>
															Experience Level
														</strong>
													</p>
													<div class="radio">
													  <label class="radio-inline">
														<input class="" type="radio" name="experience" id="experience_fresh" value="Fresher">
														Fresher
													  </label>
													  <label class="radio-inline">
														<input class="" type="radio" name="experience" id="experience_exp" value="Experienced">
										               <label class="form-check-label" for="experience_exp">
														Experienced
													   </label>
													</div>
												</div>
											</div>
											<div class="col-sm-6" id="total_experience" style="display:none">
												<div class="form-group" >
													<label><strong>Total Experience</strong></label>
													<input type="number" id="total_exp" min="0" step=".1" name="total_exp" class="form-control" placeholder="">
												</div>
											</div>
											<div class="col-sm-6" id="notice_period_block" style="display:none">
												<div class="form-group">
													<label><strong>Notice Period For Joining</strong></label>
													<input type="text" id="notice_period" name="notice_period" class="form-control" placeholder="">
												</div>
											</div>
											<div class="col-sm-6" id="reason_for_block" style="display:none">
												<div class="form-group">
													<label><strong>Reason for Leaving Job (Present/Last)</strong></label>
													<input type="text" name="job_leav_reason" id="job_leav_reason" class="form-control" placeholder="">
												</div>
											</div>

										</div>
									</div>

									
									<div class="form-repeat">
										<table class="table table-bordered table-striped">
											<thead class="thead-light">
									<tr>
										<th scope="col">Present Gross</th>
										<th scope="col">Present Take Home</th>
										<th scope="col">Expected Take Home</th>
									</tr>
							    	</thead>
											<tbody>
											  <tr>
										<td><input type="text" class="form-control" name="gross" placeholder=""></td>
										<td><input type="text" class="form-control" name="take_home" placeholder=""></td>
										<td><input type="text" class="form-control" name="expected" placeholder=""></td>
									</tr>								  
											</tbody>
										  </table>
									</div>
									<div class="form-repeat">
										<div class="row">
											<div class="col-sm-12">
												<div class="form-group">
													<div id='divHabilitSelectors' class="input-file-container">
														<input  class="input-file required"  type="file" name="file_upload" id="file_upload" accept=".doc,.docx,.pdf,image/*"> 
														<label for="file_upload" class="input-file-trigger" id='labelFU' tabindex="0">Upload Your Resume <span class="require">*</span></label>
													</div>
												</div>
											</div>									
										</div>
									</div>

									<div class="form-repeat">
										<div class="row">
											<div class="col-sm-12">
												<div class="form-group">
													<div id='divHabilitSelectors' class="input-file-container">
														<input  class="input-file2"  type="file" name="adhar_file_upload" id="adhar_file_upload" accept=".doc,.docx,.pdf,image/*"> 
														<label for="adhar_file_upload" class="input-file-trigger2" id='labelFU2' tabindex="0">Upload Your Aadhaar <span class="require">*</span></label>
													</div>
												
												</div>
											</div>									
										</div>
									</div>

									<?php if($canrow['onboarding_type'] == "NAPS") { ?>
									<div class="form-repeat">
										<div class="row">
											<div class="col-sm-12">
												<div class="form-group">
													<div id='divHabilitSelectors' class="input-file-container">
														<input  class="input-file3"  type="file" name="sign_file_upload" id="sign_file_upload" accept=".doc,.docx,.pdf,image/*"> 
														<label for="sign_file_upload" class="input-file-trigger3" id='labelFU3' tabindex="0">Upload Your Signature</label>
													</div>
												
												</div>
											</div>									
										</div>
									</div>

								<?php } ?>

									<div class="form-repeat">
										<div class="row">
											<div class="col-sm-6">
												<div class="form-group">
													<label><strong>Any Known Medical Illness</strong></label>
													<input type="text" class="form-control" name="madical" placeholder="">
												</div>
											</div>
											<div class="col-sm-6">
												<div class="form-group">
													<label><strong>Any Accidents in Past:</strong></label>
													<input type="text" class="form-control" name="accidents" placeholder="">
												</div>
											</div>
										</div>
									</div>
									  <button type="button" class="previous action-button-previous" />
										Previous
									</button>
									  <button type="button" name="next" class="next action-button" />Next Step</button>
								</fieldset>
								
								<fieldset>
								  <?php
								     $str="required";
									if($location == 'CHA'){
										$str="";
								  ?>
								
								<div class="education-table">
										<div class="form-repeat">
										  <table class="table table-bordered table-striped">
											<thead class="thead-light">
												<tr>
													<th scope="col">Degree <span class="require">*</span></th>
													<th scope="col">Course Name <span class="require">*</span></th>
													<th scope="col">Board / University <span class="require">*</span></th>
													<th scope="col">School / University</th>
													<th scope="col">Passing Year <span class="require">*</span></th>
													<th scope="col">% <span class="require">*</span></th>
													<th scope="col"></th>
												</tr>
											</thead>
											<tbody>
											  <tr class="education_detail_container_x">
												<td>
													<select name="deg_type_x" class="form-control required" >
														<option value="X th">X th</option>
														<!--<option value="XII th">XII th</option>
														<option value="Graduation">Graduation</option>
														<option value="Professional Qualification">Professional Qualification</option>
														<option value="Any Other Qualification">Any Other Qualification</option>
														<option value="Any Course Being Pursued">Any Course Being Pursued</option>-->
													</select>
												</td>
												<?php
												$passing_year = date("Y");
												$passing_year = $passing_year + 4;  
												?>
												<td>
													<input type="text" name="course_name_x" class="form-control required" placeholder="Course Name" >
												</td>
												<td>
													<input type="text" name="board_name_x" class="form-control required" placeholder="Board/University" >
												</td>
												<td>
													<input type="text" name="school_name_x" class="form-control" placeholder="School/University" >
												</td>
												<td>
													<input type="number" name="pass_year_x" min="1970" max="<?php echo $passing_year; ?>" step="1" class="form-control checkNumber pass_year required" placeholder="Passing Year"  value="">
												</td>
												<td>
													<input type="text" name="marks_x" min="30" max="100" class="form-control checkNumber marks_percentage required" placeholder="Marks %" value="">
												</td>
												<td>
													<div id="divHabilitSelectors" class="input-file-container">
														<input class="input-file required" type="file" name="xth_file_upload" id="xth_file_upload" accept=".doc,.docx,.pdf,image/*" required="required"> 
														<label for="xth_file_upload" class="input-file-trigger" id="labelFU4" tabindex="0">Upload Your Xth Certificate <span class="require">*</span></label>
													</div>
												</td>
											</tr>
											  
											</tbody>
										  </table>
										</div>
									  </div>
									<?php } ?>
									<div class="education-table">
										<div class="form-repeat">
										  <table class="table table-bordered table-striped">
											<thead class="thead-light">
												<tr>
													<th scope="col">Degree <span class="require"><?php echo ($str!="")?'*':'';?></span></th>
													<th scope="col">Course Name <span class="require"><?php echo ($str!="")?'*':'';?></span></th>
													<th scope="col">Board / University <span class="require"><?php echo ($str!="")?'*':'';?></span></th>
													<th scope="col">School / University</th>
													<th scope="col">Passing Year <span class="require"><?php echo ($str!="")?'*':'';?></span></th>
													<th scope="col">% <span class="require"><?php echo ($str!="")?'*':'';?></span></th>
													<th scope="col"></th>
												</tr>
											</thead>
											<tbody>
											  <tr class="education_detail_container">
												<td>
													<select name="deg_type[]" class="form-control <?php echo $str;?>" >
														<?php
															if($location != 'CHA'){
														?>
														<option value="X th">X th</option>
														<?php } ?>
														<option value="XII th">XII th</option>
														<option value="Graduation">Graduation</option>
														<option value="Professional Qualification">Professional Qualification</option>
														<option value="Any Other Qualification">Any Other Qualification</option>
														<option value="Any Course Being Pursued">Any Course Being Pursued</option>
													</select>
												</td>
												<?php
												$passing_year = date("Y");
												$passing_year = $passing_year + 4;  
												?>
												<td>
													<input type="text" name="course_name[]" class="form-control <?php echo $str;?>" placeholder="Course Name" >
												</td>
												<td>
													<input type="text" name="board_name[]" class="form-control <?php echo $str;?>" placeholder="Board/University" >
												</td>
												<td>
													<input type="text" name="school_name[]" class="form-control" placeholder="School/University" >
												</td>
												<td>
													<input type="number" name="pass_year[]" min="1970" max="<?php echo $passing_year; ?>" step="1" class="form-control checkNumber pass_year <?php echo $str;?>" placeholder="Passing Year"  value="">
												</td>
												<td>
													<input type="text" name="marks[]" min="30" max="100" class="form-control checkNumber marks_percentage <?php echo $str;?>" placeholder="Marks %" value="">
												</td>
												<td>
													<button type="button" class="btn btn-success rounded-circle add"><i class="fas fa-plus"></i></button>
												</td>
											</tr>
											  
											</tbody>
										  </table>
										</div>
								  </div>
									<button type="button" class="previous action-button-previous" />
										Previous
									</button>
									<button type="button" class="next action-button" />
										Next Step
									</button>
								</fieldset>
								<fieldset>
									<div class="education-table">
									<div class="form-repeat">
										<table class="table table-bordered table-striped">
											<thead class="thead-light">
									<tr>
										<th scope="col">Family Member <span class="require">*</span></th>
										<th scope="col">Name <span class="require">*</span></th>
										<th scope="col">Occupation <span class="require">*</span></th>
										<th scope="col"></th>
									</tr>
								</thead>
											<tbody>
											  <tr class="family_detail_container">
										<td>
											<select name="relation_type[]" class="form-control required">
												<option value="Father">Father</option>
												<option value="Mother">Mother</option>
												<option value="Spouse">Spouse</option>
												<option value="Child">Child</option>
												<option value="Siblings">Siblings</option>
												<option value="Other Family Members">Other Family Members</option>
											</select>
										</td>
										<td>
											<input type="text" name="relative_name[]" class="form-control required" placeholder="Name">
										</td>
										<td>
											<input type="text" name="relative_occupation[]" class="form-control required" placeholder="Occupation">
										</td>
										<td>
											<button type="button" class="btn btn-success rounded-circle add_family"><i class="fas fa-plus"></i></button>
										</td>
									</tr>
											  
											</tbody>
										  </table>
									</div>
									
								  </div>
									<button type="button" class="previous action-button-previous" />
										Previous
									</button>
									<button type="button" class="next action-button" />
										Next Step
									</button>
								</fieldset>
								<fieldset>
									<div class="education-table">
									<div class="form-repeat">
										<table class="table table-bordered table-striped">
											<thead class="thead-light">
									<tr>
										<th scope="col">Name</th>
										<th scope="col">Designation</th>
										<th scope="col">Tenure of Work</th>
										<th scope="col">References from Each Organization</th>
									</tr>
								</thead>
											<tbody>
											  <tr>
										<td>
											<input type="text" name="org_name" class="form-control" placeholder="Name">
										</td>
										<td>
											<input type="text" name="designation" class="form-control" placeholder="Designation">
										</td>
										<td>
											<input type="text" name="tenure" class="form-control" placeholder="Tenure of Work">
										</td>
										<td>
											<input type="text" name="references" class="form-control" placeholder="References">
										</td>
									</tr>
									<tr>
										<td>
											<input type="text" name="org_name2" class="form-control" placeholder="Name">
										</td>
										<td>
											<input type="text" name="designation2" class="form-control" placeholder="Designation">
										</td>
										<td>
											<input type="text" name="tenure2" class="form-control" placeholder="Tenure of Work">
										</td>
										<td>
											<input type="text" name="references2" class="form-control" placeholder="References">
										</td>
									</tr>
									<tr>
										<td>
											<input type="text" name="org_name3" class="form-control" placeholder="Name">
										</td>
										<td>
											<input type="text" name="designation3" class="form-control" placeholder="Designation">
										</td>
										<td>
											<input type="text" name="tenure3" class="form-control" placeholder="Tenure of Work">
										</td>
										<td>
											<input type="text" name="references3" class="form-control" placeholder="References">
										</td>
									</tr>
											</tbody>
										  </table>
									</div>

								  </div>
								  <button type="button" class="previous action-button-previous" />
									Previous
								  </button>
								  <button type="button" class="next action-button" />
									Next Step
								  </button>
								</fieldset>
								<fieldset>
									 <div class="education-table">
									<div class="form-repeat">
										<table class="table table-bordered table-striped">
											<thead class="thead-light">
									<tr>
										<th scope="col">(1) Name & Relationship Address & Phone No</th>
										<th scope="col">(2) Name & Relationship Address & Phone No</th>
										<th scope="col">(3) Name & Relationship Address & Phone No</th>
									</tr>
								</thead>
											<tbody>
											  <tr>
										<td>
											<textarea name="references_1" class="form-control" placeholder=""></textarea>
										</td>
										<td>
											<textarea type="text" name="references_2" class="form-control" placeholder=""></textarea>
										</td>
										<td>
											<textarea type="text" name="references_3" class="form-control" placeholder=""></textarea>
										</td>
									</tr>								  
											</tbody>
										  </table>
									</div>
									


									
									
								  </div>
								  
								  <button type="button" class="previous action-button-previous" /> 
									Previous
								  </button>
								  <button type="button" class="next action-button" />
									Next Step
								  </button>
								</fieldset>
								<fieldset>
									<div class="education-table">
										<div class="form-repeat">
											<div class="form-group">
												<label><strong>Any judicial proceeding against you in the court of law?</strong></label>
												<input type="text" class="form-control" name="legal" placeholder="If Yes Give Details">
											</div>
										</div>

										<div class="form-group">
												<label for="basic-url">Type The Below Text (Case Sensitive):<span style="color:red">*</span></label>
												<div class="input-group mb-3">
													<div class="input-group-prepend">
														<span class="input-group-text" id="captcha_image"><?php echo $captcha['image']?></span>
													</div>
													<input type="text" class="form-control required" id="basic-url" name="captcha" aria-describedby="basic-addon3" style="border-radius: .25rem;">
													<div class="input-group-append">
														<span class="input-group-text" style="cursor:pointer;" id="reload_captcha">Reload</span>
													</div>
												</div>
										</div>

										<div class="form-repeat">
											<p>
												I declare that abovementioned information is true to the best of my knowledge. Any action which the management deems fit may be taken if discrepancy is found in the same.
												<span style="color:red">*</span></p>
											<div class="checkbox">
												<label><input type="checkbox" class="" id="declare" name="declare"> Check Me If Yes</label>
												<br/>
												<span style="color:red">Please check this to submit your application</span>
											</div>
										</div>
									</div>
									<button type="button" class="previous action-button-previous" /> 
												Previous
									</button>
									<button type="Submit" class="submit-btn" disabled>
											Submit
											</button>
								</fieldset>
								</div>
							</div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</section>

<!-- partial -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/date-picker.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/js/select2.min.js"></script>

<script>
	function checkPostCode(){
		var postcode = $("#postcode").val();

		$("#postcode_err").text("");
		if (postcode.length != 6) {
			$("#postcode_err").text("Please Enter 6 Digit Number");
			$('#first_btn').attr('disabled','disabled');
			return false;
		}else{
			$('#first_btn').removeAttr('disabled');
		}
		
	}
	function checkAadhar(){
		var adhar_no = $("#adhar").val();

		$("#adhar_err").text("");
		if (adhar_no.length != 12) {
			$("#adhar_err").text("Please Enter 12 Digit adhar Number");
			$('#first_btn').attr('disabled','disabled');
			return false;
		}else{
			$('#first_btn').removeAttr('disabled');
		}
		
	}
	function checkPan(){
		var pan_no = $("#pan").val();

		$("#pan_err").text("");
		if (pan_no.length != 10) {
			$("#pan_err").text("Please Enter 10 Digit PAN Number");
			$('#first_btn').attr('disabled','disabled');
			return false;
		}else{
			$('#first_btn').removeAttr('disabled');
		}
		
	}
	function checkMobile(){
		var mobile_no = $("#mobile_no").val();

		$("#mobile_err").text("");
		if (mobile_no.length != 10) {
			
		var res = parseInt(mobile_no);
			if(isNaN(res)){ 
				$("#mobile_err").text("Please Enter Only Number");
				$('#first_btn').attr('disabled','disabled');
				return false;
			}
			$("#mobile_err").text("Please Enter 10 Digit Mobile Number");
			$('#first_btn').attr('disabled','disabled');
			return false;
		}else{
			if(mobile_no.length == 10)
			{
				var res = parseInt(mobile_no);
				if(isNaN(res)){ 
					$("#mobile_err").text("Please Enter Only Number");
					$('#first_btn').attr('disabled','disabled');
					return false;
				}
				$('#first_btn').removeAttr('disabled');
				var r_id = $('#r_id').val();
				var datas = {'mobile_no':mobile_no,'rq_id':r_id};
				// console.log(datas);
				$.ajax({
					type	:	'POST',
					url		:	'<?php echo base_url('applyjoblink/check_mobile_exist'); ?>',
					data	:	datas,
					success	:	function(msg){
								if(msg == true)
								{
									$("#mobile_err").text("You Have Already Applied For This Job");
									// alert('You Have Already Applied For This Job');
									window.location.href = '<?php echo base_url('applyjoblink'); ?>';
								}
							}
				});
			}	
		}
		
	}
		$(document).ready(function(){

		var current_fs, next_fs, previous_fs; //fieldsets
		var opacity;
		$(".next").click(function(){

		var referal = $('[name="referal"]').is(':checked');
		if(referal==false){
			alert('Select Your Referal Source');
			window.scrollTo(0, 200);
		}

		if ($('#referal').prop('checked')) {
			var id = $('#ref_employee_name_container select').val();
			if(id != ""){
			$('#ref_employee_name_container .select2-selection--single').removeClass('required');
			$('#ref_employee_name_container .select2-selection--single').removeClass('input-error');
			}	
		} 
		else{
				if($('#walkin').prop('checked')){
					$('#other_source_ref_container .select2-selection--single').removeClass('required');
					$('#other_source_ref_container .select2-selection--single').removeClass('input-error');
				}else{
					var id = $('#other_source_ref_container select').val();
					if(id != ""){
					$('#other_source_ref_container .select2-selection--single').removeClass('required');
					$('#other_source_ref_container .select2-selection--single').removeClass('input-error');
					}
					else{
						$('#other_source_ref_container .select2-selection--single').addClass('required');
					}
				}
				
			}


		var parent_fieldset = $(this).parents('fieldset');
		var next_step = true;

		

		if(document.getElementById('additional').className == "active")
		{
		var file = $("#file_upload").val();
			if(file==""){
			$("#labelFU").addClass('input-error');
			next_step = false;
			}
			else{
				$("#labelFU").removeClass('input-error');
			}


		var file = $("#adhar_file_upload").val();
			if(file==""){
			$("#labelFU2").addClass('input-error');
			next_step = false;
			}
			else{
				$("#labelFU2").removeClass('input-error');
			}
			
		

		var file = $("#sign_file_upload").val();
			if(file==""){
			$("#labelFU3").addClass('input-error');
			next_step = false;
			}
			else{
				$("#labelFU3").removeClass('input-error');
			}		

		}

		parent_fieldset.find('.required').each(function() {
				if( $(this).val() == "" ) {
					$(this).addClass('input-error');
					next_step = false;
				}
				else {
					$(this).removeClass('input-error');
				}
				});


			if( next_step == true ) {																

						current_fs = $(this).parent();
						next_fs = $(this).parent().next();
						$("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");
						next_fs.show();
						current_fs.animate({opacity: 0}, {
						step: function(now) {
						opacity = 1 - now;
						current_fs.css({
						'display': 'none',
						'position': 'relative'
						});
						next_fs.css({'opacity': opacity});
						},
						duration: 600
						});
			}
		
});



	$(".previous").click(function(){
	current_fs = $(this).parent();
	previous_fs = $(this).parent().prev();
	$("#progressbar li").eq($("fieldset").index(current_fs)).removeClass("active");
	previous_fs.show();
	current_fs.animate({opacity: 0}, {
	step: function(now) {
	opacity = 1 - now;
	current_fs.css({'display': 'none','position': 'relative'
	});
	previous_fs.css({'opacity': opacity});
	},duration: 600
	});
});
	$('.radio-group .radio').click(function(){
	$(this).parent().find('.radio').removeClass('selected');
	$(this).addClass('selected');
});

// 	$(".submit").click(function(){
// 	return false;
// })
});
</script>

<script>
	$('#datepicker').datepicker({
		uiLibrary: 'bootstrap4'
	});
</script>

	
<script>
			$(document).ready(function() {
				$('.js-example-basic-single').select2({
					placeholder: "Type Your Source",
					allowClear: true,
					tags: true
				});
			});
		</script>
		<script>
			$(document).ready(function() {
				$('#employee_id_xpo').select2({
					placeholder: "Type Referal XPO ID",
					allowClear: true,
					createTag: function (tag) {

						// Check if the option is already there
						var found = false;
						$("#timezones option").each(function() {
							if ($.trim(tag.term).toUpperCase() === $.trim($(this).text()).toUpperCase()) {
								found = true;
							}
						});

						// Show the suggestion only if a match was not found
						if (!found) {
							return {
								id: tag.term,
								text: tag.term + " (new)",
								isNew: true
							};
						}
					}
				});
			});
		</script>
		
		<script>
			$('#employee_id_xpo').on('select2:select', function (evt)
			{
				
				var employee_name = $(this).find('option:selected').attr('data-name');
				var employee_dept = $(this).find('option:selected').attr('data-dept');
				/* console.log(employee_name);
				console.log(employee_dept); */
				$('[name="comp_employee_id"]').val(employee_name);
				$('[name="comp_employee_dept"]').val(employee_dept);
			});
			/* $('#employee_id_xpo').on('change',function()
			{
				var employee_name = $(this).find('option:selected').attr('data-name');
				var employee_dept = $(this).find('option:selected').attr('data-dept');
				
				$('[name="comp_employee_id"]').val(employee_name);
				$('[name="comp_employee_dept"]').val(employee_dept);
				
				
			}); */
		</script>
		
		<script>
			$(document).on('click','#job_source_portal,#job_source_consult,#news_paper,#call_hr',function()
			{
				
				var val = $(this).val();
				var datas = {'data_type':val};
				$('#other_source_ref_container label').text(''+val+' Name');
				$('#other_source_ref_container').hide();
				$('.js-example-basic-single').html('<option></option>');
				$('#other_source_ref_container select').removeAttr('disabled');
				$('#other_source_ref_container .select2-selection--single').addClass('required');

				$('#ref_employee_name_container .select2-selection--single').removeClass('required');
				$('#ref_employee_name_container .select2-selection--single').removeClass('input-error');
				$.ajax({
					type	:	'POST',
					url		:	'<?php echo base_url('applyjoblink/get_consultancy_info'); ?>',
					data	:	datas,
					success	:	function(msg)
					{
						$('#other_source_ref_container').hide();
						var res = JSON.parse(msg);
						console.log(res);
						var list = '<option></option>';
						if(res.stat == true)
						{
							
							$.each(res.data,function(index,element)
							{
								console.log(element);
								if(element.job_portal)
								{
									list += '<option value="'+element.job_portal+'">'+element.job_portal+'</option>';
								}
								else if(element.hr_name)
								{
									list += '<option value="'+element.hr_name+'">'+element.hr_name+'</option>';
								}
								else
								{
									list += '<option value="'+element.consultancy+'">'+element.consultancy+'</option>';
								}
							});
						}
						list += '';
						$('#other_source_ref_container .js-example-basic-single').html(list);
						$('#other_source_ref_container').show();
					},
					fail: function(xhr, textStatus, errorThrown){
					   $('#other_source_ref_container').show();
					}
				});
				
			});
			$(document).on('click','#walkin',function()
			{
				//$('#other_source_ref_container').html('');
				$('#other_source_ref_container').hide();
				$('#other_source_ref_container select').attr('disabled','disabled');
				$('#other_source_ref_container select').removeAttr('required');
			});
			
		</script>
		<script>
			$(document).on('click','#referal',function()
			{
				$('#other_source_ref_container .select2-selection--single').removeClass('required');
				$('#other_source_ref_container .select2-selection--single').removeClass('input-error');
				$('#ref_employee_name_container .select2-selection--single').addClass('required');
				if($(this).prop('checked'))
				{
					
					// $('[name="comp_employee_name"]').addClass('required');
					$('#ref_employee_name_container select').removeAttr('disabled');
					// $("#ref_employee_name_container select").select2().prop('required', true).trigger('change');
					
					$('#ref_by_comp_emplo').removeClass('d-none');
					$('#ref_job_vacancy').addClass('d-none');
					$('#ref_job_vacancy input').prop('checked',false);
					$('#other_source_ref_container select').attr('disabled','disabled');
					$('#other_source_ref_container').hide();
				}
				else
				{	
					
					$('#ref_by_comp_emplo').addClass('d-none');
					$('#ref_job_vacancy').removeClass('d-none');
					$('#ref_by_comp_emplo select,#ref_by_comp_emplo input').val('');
					
					$('#ref_employee_name_container select').attr('disabled','disabled');
					$("#ref_employee_name_container select").select2().prop('required', false).trigger('change');
					
					$('[name="comp_employee_name"]').removeAttr('required');
					//$('#other_source_ref_container select').removeAttr('disabled');
					//$('#other_source_ref_container').show();
				}
			});
		</script>
		<script>
			$(document).on('click','#declare',function()
			{
				if($(this).prop('checked'))
				{
					$('button[type="submit"]').removeAttr('disabled');
				}
				else
				{
					$('button[type="submit"]').attr('disabled','disabled');
				}
			});
		</script>
		
		<script>
			$(document).on('click','.add',function()
			{
				var container = $('.education_detail_container:last-of-type').clone();
				$('.education_detail_container:last-of-type').after('<tr class="education_detail_container">'+container[0].innerHTML+'</tr>');
				$('.education_detail_container:first-of-type td:last-of-type').html('<button type="button" class="btn btn-success rounded-circle add"><i class="fas fa-plus"></i></button>');
				$('.education_detail_container:last-of-type td:last-of-type').html('<button type="button" class="btn btn-danger rounded-circle remove"><i class="fas fa-minus"></i></button>');
				
				$(this).remove();
			});
			$(document).on('click','.remove',function()
			{
				$(this).parent().parent().remove();
			});
		</script>
		
		<script>
			$(document).on('click','.add_family',function()
			{
				var container = $('.family_detail_container:last-of-type').clone();
				$('.family_detail_container:last-of-type').after('<tr class="family_detail_container">'+container[0].innerHTML+'</tr>');
				$('.family_detail_container:first-of-type td:last-of-type').html('<button type="button" class="btn btn-success rounded-circle add_family"><i class="fas fa-plus"></i></button>');
				$('.family_detail_container:last-of-type td:last-of-type').html('<button type="button" class="btn btn-danger rounded-circle remove"><i class="fas fa-minus"></i></button>');
				
				$(this).remove();
			});
			$(document).on('click','.remove',function()
			{
				$(this).parent().parent().remove();
			});
		</script>
		 
		<script>
			
			// $(document).on('focusout','#mobile_no',function()
			// {
			// 	var mobile_no = $(this).val();
			// 	alert(mobile_no);
			// 	$("#mobile_err").text("");
			// 	if (mobile_no.length < 10) {
					
			// 		let m = Number(mobile_no);
			// 		let t = typeof m;
			// 		if(t !== 'number')){ 
			// 			$("#mobile_err").text("Please Enter Only Number");
			// 			return false;
			// 		}
			// 		$("#mobile_err").text("Please Enter 10 Digit Mobile Number");
			// 		// alert('Please Enter 10 Digit Mobile Number');
			// 		return false;
			// 	}else{
			// 		if(mobile_no.length > 0)
			// 		{
			// 			let m = Number(mobile_no);
			// 			let t = typeof m;
			// 			if(t !== 'number')){ 
			// 				$("#mobile_err").text("Please Enter Only Number");
			// 				return false;
			// 			}
			// 			var r_id = $('#r_id').val();
			// 			var datas = {'mobile_no':mobile_no,'rq_id':r_id};
			// 			console.log(datas);
			// 			$.ajax({
			// 				type	:	'POST',
			// 				url		:	'<?php echo base_url('applyjoblink/check_mobile_exist'); ?>',
			// 				data	:	datas,
			// 				success	:	function(msg){
			// 							if(msg == true)
			// 							{
			// 								$("#mobile_err").text("You Have Already Applied For This Job");
			// 								// alert('You Have Already Applied For This Job');
			// 								window.location.href = '<?php echo base_url('applyjoblink'); ?>';
			// 							}
			// 						}
			// 			});
			// 		}	
			// 	}
				
			// });
		</script>
		
		
		<script>
			$(document).on('focusout','#email',function()
			{
				var email = $(this).val();
				$("#email_err").text("");
				var reEmail = /^(?:[\w\!\#\$\%\&\'\*\+\-\/\=\?\^\`\{\|\}\~]+\.)*[\w\!\#\$\%\&\'\*\+\-\/\=\?\^\`\{\|\}\~]+@(?:(?:(?:[a-zA-Z0-9](?:[a-zA-Z0-9\-](?!\.)){0,61}[a-zA-Z0-9]?\.)+[a-zA-Z0-9](?:[a-zA-Z0-9\-](?!$)){0,61}[a-zA-Z0-9]?)|(?:\[(?:(?:[01]?\d{1,2}|2[0-4]\d|25[0-5])\.){3}(?:[01]?\d{1,2}|2[0-4]\d|25[0-5])\]))$/;
				  if(!email.match(reEmail)) {
					  $("#email_err").text("Invalid email address");
					  $('#first_btn').attr('disabled','disabled');
				    // alert("Invalid email address");
				    return false;
				  }else{
				  	if(email.length > 0)
					{
						
						var r_id = $('#r_id').val();
						var datas = {'email':email,'rq_id':r_id};
						// console.log(datas);
						$('#first_btn').removeAttr('disabled');
						$.ajax({
							type	:	'POST',
							url		:	'<?php echo base_url('applyjoblink/check_email_exist'); ?>',
							data	:	datas,
							success	:	function(msg){
										if(msg == true)
										{
											// alert('You Have Already Applied For This Job');
											$("#email_err").text("You Have Already Applied For This Job");
											window.location.href = '<?php echo base_url('applyjoblink'); ?>';
										}
									}
						});
					}
				  }

				//alert(email.length);
				
			});
		</script>
		<script>
			$(document).on('submit','#msform',function(e)
			{
								
				e.preventDefault();
				
				var referal = $('[name="referal"]').is(':checked');
				var declare = $('[name="declare"]').is(':checked');
				// var cap_input = $("#basic-url").val();
				// if(!cap_input == $this->session->userdata('cap_word'))
				if(!declare){
					$('#declare_err').text("Please check this to proceed");
					$('button[type="submit"]').attr('disabled','disabled');
					return false;
				}
				if(referal==true && declare==true)
				{
					$('button[type="submit"]').attr('disabled','disabled');
					var datas = $(this).serializeArray();
					//console.log(datas);
										
					$.ajax({
						type	:	'POST',
						url		:	'<?php echo base_url("applyjoblink/process_form"); ?>',
						data:  new FormData(this),
						contentType: false,
						cache: false,
						processData:false,
						success	:	function(msg){
									var msg = JSON.parse(msg);
									if(msg.error == 'false')
									{
										alert('You Have Successfully Applied For This Job');
										$('#form_container').addClass('text-center card');
										$('#form_container').attr("style", "border: 1px solid; padding-top: 32px;");
										$('#form_container').html('<h4>Thank You, For Your Interest in Fusion BPO</h4><a href="<?php echo base_url('applyjoblink/download_pdf/');?>/'+msg.c_id+'" target="_blank"><button class="btn btn-success my-5">Download PDF  <sub>(Optional)</sub></button></a>');
										
									}
									else if(msg.error == 'file_error')
									{
										alert('Unable to Upload File. Plase Re-Upload It.');
									}
									else if(msg.error == 'query_error')
									{
										alert('Please Apply After Sometime.');
									}
									else if(msg.error == 'cap_error')
									{
										alert('Wrong Captcha Entered');
									}
									$('button[type="submit"]').removeAttr('disabled');
								}
					});
				}
				else
				{
					alert('Select Your Referal Source');
					window.scrollTo(0, 200);
				}
			});
		</script>
		<script>
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
		</script>
		<script>
			$(document).on('change','#country',function()
			{
				var datas = {'country':$('#country option:selected').attr('data-id')};
				$.ajax({
					type	:	'POST',
					url		:	'<?php echo base_url('applyjoblink/stateList'); ?>',
					data	:	datas,
					success	:	function(msg){
							var msg_json = JSON.parse(msg);
							var option = '<option value="">--Select State--</option>';
							$.each(msg_json,function(index,element)
							{
								option += '<option data-state_id="'+element.id+'" value="'+element.name+'">'+element.name+'</option>';
							})
							$('#state').html(option);
						}
				});
			});
		</script>
		<script>
			$(document).on('change','#state',function()
			{
				var datas = {'state':$('#state option:selected').attr('data-state_id')};
				$.ajax({
					type	:	'POST',
					url		:	'<?php echo base_url('applyjoblink/cityList'); ?>',
					data	:	datas,
					success	:	function(msg){
							var msg_json = JSON.parse(msg);
							var option = '<option value="">--Select City--</option>';
							$.each(msg_json,function(index,element)
							{
								option += '<option data-state_id="'+element.id+'" value="'+element.name+'">'+element.name+'</option>';
							});
							option += '<option value="others">Others</option>';
							$('#city').html(option);
						}
				});
			});
		</script>
		<script>
			$(document).ready(function() {
				$("input[name$='married']").click(function() {
					var m = $(this).val();
					if(m=='Yes'){
						$("#marriage_date").css("display","Block");
					}else if(m=='No'){
						$("#marriage_date").css("display","none");
					}else{
						$("#marriage_date").css("display","Block");
					}
					
				});
				$("input[name$='interest']").click(function() {
					var m = $(this).val();
					if(m=='Other'){
						$("#interest_type").css("display","Block");
					}else{
						$("#interest_type").css("display","none");
					}
					
				});
				$("input[name$='experience']").click(function() {
					var m = $(this).val();
					if(m=='Experienced'){
						$("#total_experience").css("display","Block");
						$("#notice_period_block").css("display","Block");
						$("#reason_for_block").css("display","Block");
					}else{
						$("#total_experience").css("display","none");
						$("#notice_period_block").css("display","none");
						$("#reason_for_block").css("display","none");
					}
					
				});

				$('.checkNumber').keypress(function (e) {    
    
                var charCode = (e.which) ? e.which : event.keyCode    
    
                if (String.fromCharCode(charCode).match(/[^0-9]/g))    
    
                    return false;                        
    
            	});   
			});
		</script>
		<script>
			$(document).on('change','#city',function()
			{
				if($(this).val() == 'others')
				{
					$('#others').removeAttr('disabled');
				}
				else
				{
					$('#others').attr('disabled','disabled');
				}
			});
		</script>
		<script>
			$(document).on('change','#others',function()
			{
				if($(this).val().length > 0)
				{
					$('#city').attr('disabled','disabled');
					
				}
				else
				{
					$('#city').removeAttr('disabled');
				}
			});
			$(document).on('blur','.pass_year ',function()
			{
				var max;
				var min;
				var pass = $(this).val();
				max = $(this).attr('max');
				max = parseInt(max);
				min = $(this).attr('min');
				min = parseInt(min);
			
				if (parseInt(pass) > max || parseInt(pass) < min) {
					$(this).val(max); 
				}
			});
			$(document).on('blur','.marks_percentage',function()
			{
				var max;
				var min;
				var pass = $(this).val();
				max = $(this).attr('max');
				max = parseInt(max);
				min = $(this).attr('min');
				min = parseInt(min);
			    var a = '30';
				if (parseInt(pass) > max || parseInt(pass) < min) {

					$(this).val(a); 
				}
			});
		</script>


<script>
document.querySelector("html").classList.add('js');
var fileInput  = document.querySelector( ".input-file" ),  
    button     = document.querySelector( ".input-file-trigger" ),
    the_return = document.querySelector(".file-return");
button.addEventListener( "keydown", function( event ) {
    if ( event.keyCode == 13 || event.keyCode == 32 ) {
        fileInput.focus();
    }
});
button.addEventListener( "click", function( event ) {
   fileInput.focus();
   return false;
});
fileInput.addEventListener( "change", function( event ) {  
    $('#labelFU').text("Choosen file : " + this.value);
});

</script>

<script>

var fileInput  = document.querySelector( ".input-file2" ),  
    button     = document.querySelector( ".input-file-trigger2" ),
    the_return = document.querySelector(".file-return");
button.addEventListener( "keydown", function( event ) {
    if ( event.keyCode == 13 || event.keyCode == 32 ) {
        fileInput.focus();
    }
});
button.addEventListener( "click", function( event ) {
   fileInput.focus();
   return false;
});
fileInput.addEventListener( "change", function( event ) {  
    $('#labelFU2').text("Choosen file : " + this.value);
});

</script>

<script>

var fileInput  = document.querySelector( ".input-file3" ),  
    button     = document.querySelector( ".input-file-trigger3" ),
    the_return = document.querySelector(".file-return");
button.addEventListener( "keydown", function( event ) {
    if ( event.keyCode == 13 || event.keyCode == 32 ) {
        fileInput.focus();
    }
});
button.addEventListener( "click", function( event ) {
   fileInput.focus();
   return false;
});
fileInput.addEventListener( "change", function( event ) {  
    $('#labelFU3').text("Choosen file : " + this.value);
});

</script>


<script type="text/javascript">
	$('#adhar_file_upload').change(function () {
    	var uploadpath = $('#adhar_file_upload').val();
	    var fileExtension = uploadpath.substring(uploadpath.lastIndexOf(".") + 1, uploadpath.length);

	    if (fileExtension == "doc" || fileExtension == "docx" || fileExtension == "pdf" || fileExtension == "jpg" || fileExtension == "jpeg" || fileExtension == "png") {
	        
	    }
	    else {
	    	alert("File type not supported");
	        $('#adhar_file_upload').value = "";
	        $('#labelFU2').text("Choose a pdf,doc,docx or image file please");
	        return false;
	    }
});
</script>

<script type="text/javascript">
	$('#sign_file_upload').change(function () {
    	var uploadpath = $('#sign_file_upload').val();
	    var fileExtension = uploadpath.substring(uploadpath.lastIndexOf(".") + 1, uploadpath.length);

	    if (fileExtension == "doc" || fileExtension == "docx" || fileExtension == "pdf" || fileExtension == "jpg" || fileExtension == "jpeg" || fileExtension == "png") {
	        
	    }
	    else {
	    	alert("File type not supported");
	        $('#sign_file_upload').value = "";
	        $('#labelFU3').text("Choose a pdf,doc,docx or image file please");
	        return false;
	    }
});
</script>

<script type="text/javascript">
	$('#file_upload').change(function () {
    	var uploadpath = $('#file_upload').val();
	    var fileExtension = uploadpath.substring(uploadpath.lastIndexOf(".") + 1, uploadpath.length);

	    if (fileExtension == "doc" || fileExtension == "docx" || fileExtension == "pdf" || fileExtension == "jpg" || fileExtension == "jpeg" || fileExtension == "png") {
	        
	    }
	    else {
	    	alert("File type not supported");
	        $('#file_upload').value = "";
	        $('#labelFU').text("Choose a pdf,doc,docx or image file please");
	        return false;
	    }
	});

	// $("input .pass_year").focusout(function(){
	// 	alert('pass');
		// var max;
		// var min;
		// var pass = $(this).val();
		// alert('pass');
		// max = $(this).max();
		// max = parseInt(max);
		// min = $(this).min();
		// min = parseInt(min);
	
		// if (parseInt(pass) > max || parseInt(pass) < min) {
		// 	$(this).val(max); 
		// }
	
	// }


			
    //  document.getElementsByClassName('pass_year')[0].onblur = function () {
    //     var max = parseInt(this.max);
    //     var min = parseInt(this.min);

    //     if (parseInt(this.value) > max || parseInt(this.value) < min) {
    //         this.value = max; 
    //     }
    // }
	// document.getElementsByClassName('marks_percentage')[0].onblur = function () {
    //     var max = parseInt(this.max);

    //     if (parseInt(this.value) > max) {
    //         this.value = 40; 
    //     }

    // }
</script>

</body>
</html>