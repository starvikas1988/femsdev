<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
  <title>Multi Form Design</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://fonts.googleapis.com/css?family=Poppins:400,600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">  
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/date-picker.css">  
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/custom.css">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/css/select2.min.css" rel="stylesheet" />
  <style>

  			.input-error {
			    border-color: red !important;
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

			.checkbox input[type="checkbox"], .checkbox-inline input[type="checkbox"], .radio input[type="radio"], .radio-inline input[type="radio"] {
			    position: unset;
			    margin-top: 0px;
			    margin-left: 0px;
			}

</style>
</head>
<body>

<section id="form-category" class="form-category">	
	<div class="container">
		<div class="top-main">
			<div class="row" style="border-bottom: 2px solid #b4b4b4;margin-bottom: 20px;">
				<div class="col-sm-4">
					<div class="body-widget">
						<img src="<?php echo base_url(); ?>assets/css/images/fusion-logo.png" class="logo" alt="">
					</div>
				</div>
				<div class="col-sm-8">
					<div class="top-right">
						<div class="body-widget">
							<h2 class="top-title">
								Applying For <?php echo str_replace('%20',' ',$job_title); ?>
							</h2>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="float-right col-sm-12">
			  		<span>
			  			<strong>Please Fill all the * marked fields</strong>
			  		</span>
			  	</div>
			</div>	
		</div>
		<div class="row">
        <div class="col-sm-12">
            <div class="card px-0 pb-0">                
                <div class="row">
                    <div class="col-md-12 mx-0" id="form_container">
                        <form id="msform" method="POST" enctype="multipart/form-data">
                            <!-- progressbar -->
                            <ul id="progressbar">
                                <li class="active" id="personal">
									<strong>Personal Info</strong>
								</li>
                                <li id="education">
									<strong>
										Educational Details
									</strong>
								</li>
                                <li id="family">
									<strong>
									Family Details
									</strong>
								</li>
                                <li id="organization">
									<strong>
										Last 3 Organization
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
														<strong>First name*</strong>
													  </label>
													  <input name="first_name" type="text" class="form-control required" placeholder="First name"  id="first_name">

													  <input type="hidden" name="rq_id" id="rq_id" class="form-control" value="<?php echo $rq_id; ?>" >
													  <input type="hidden" name="r_id" id="r_id" class="form-control" value="<?php echo $r_id; ?>" >

													</div>
												</div>
											</div>
											<div class="col-sm-3">
												<div class="body-widget">
													<div class="form-group">
													  <label>
														<strong>Last name*</strong>
													  </label>
													  <input name="last_name" type="text" class="form-control required" placeholder="Last name" id="last_name">
													</div>
												</div>
											</div>
											<div class="col-sm-3">
												<div class="body-widget">
													<div class="form-group">
													  <label>
														<strong>DOB*</strong>
													  </label>	  
													  <input name="dob" type="date" placeholder="DOB"  id="dob" class="form-control required" />
													</div>
												</div>
											</div>
											<div class="col-sm-3">
												<div class="body-widget">
													<div class="form-group">
													  <label>
														<strong>Gender*</strong>
													  </label>
													  <select class="form-control required" id="gender" name="gender" >
															<option value="">--Select--</option>
															<option value="Male">Male</option>
															<option value="Female">Female</option>
															<option value="Other">Other</option>
														</select>
													</div>
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
											<input type="checkbox" class="custom-control-input" id="customCheck" name="referal" value="Existing Employee">
											<label class="custom-control-label" for="customCheck">Check Me If Yes</label>
										</div>
									  </div>

									<div class="form-group d-none" id="ref_by_comp_emplo">
										<div class="form-row">
											<div class="col" id="ref_employee_name_container">
												
												<select class="form-control required" name="comp_employee_name" id="employee_id_xpo" style="width:100%;" disabled >
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
											  <input type="text" class="form-control" name="comp_employee_id" placeholder="Employee Name" value="">
											</div>
											<div class="col">
											  <input type="text" class="form-control" name="comp_employee_dept" placeholder="Employee Dept" value="">
											</div>
										</div>
									</div>

									  <div class="form-repeat"  id="ref_job_vacancy">
										<p>
											<strong>
												How you come to know about the vacancy:
											</strong>
										</p>
										<div class="radio">
										  <label class="radio-inline">
											<input type="radio" name="referal" id="job_source_portal" value="Job Portal"> 
											Job Portal
										  </label>
										  <label class="radio-inline">
											<input type="radio" name="referal" id="job_source_consult" value="Consultancy">
											Consultancy
										  </label>
										  <label class="radio-inline">
											<input type="radio" name="referal" id="news_paper" value="News Paper">
											News Paper
										  </label>
										  <label class="radio-inline">
											<input type="radio" name="referal" id="call_hr" value="Call By HR">
											Call By HR
										  </label>
										  <label class="radio-inline">
											<input type="radio" name="referal" id="walkin" value="Walkin">
											Walkin
										  </label>
										</div>
									  </div>

									<div class="form-group" id="other_source_ref_container">
										<label></label>
										<select class="js-example-basic-single form-control" name="comp_employee_name" style="width:100%; display: none;" >
											<option></option>

										</select>
									</div>

									  <div class="form-repeat">
										  <div class="row">
											<div class="col-sm-2">
												<div class="body-widget">
													<div class="form-group">
													  <label>
														<strong>Country*</strong>
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
														<strong>State*</strong>
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
														<strong>City*</strong>
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
													  <input type="text" class="form-control" placeholder="City" name="city" id="others"  disabled>
													</div>
												</div>
											</div>
											<div class="col-sm-2">
												<div class="body-widget">
													<div class="form-group">
													  <label>
														<strong>Postcode*</strong>
													  </label>
													  <input name="postcode" type="text" class="form-control required" placeholder="Postcode" id="postcode" >
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
														<strong>Permanent Address*</strong>
													 </label>
													 <textarea class="form-control required" id="parmanent_address" name="parmanent_address" placeholder="Permanent Address" ></textarea>
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
														<strong>Mobile No*</strong>
													</label>
													 <input type="text" class="form-control required" id="mobile_no" name="mobile_no" placeholder="Mobile No" >
												</div>
											</div>
											<div class="col-sm-4">
												<div class="form-group">
													 <label>
														<strong>Alternative No</strong>
													 </label>
													 <input type="text" class="form-control" id="alternate_no" name="alternate_no" placeholder="Alternate No">
												</div>
											</div>
											<div class="col-sm-4">
												<div class="form-group">
													 <label>
														<strong>Email*</strong>
													 </label>
													 <input type="text" id="email" name="email" class="form-control required" placeholder="Email" >
												</div>
											</div>
											<div class="col-sm-4">
												<div class="form-group">
													 <label>
														<strong>Adhar No*</strong>
													 </label>
													 <input type="text" class="form-control required" placeholder="Adhar No" id="adhar" name="adhar" >
												</div>
											</div>
											<div class="col-sm-4">
												<div class="form-group">
													 <label>
														<strong>Pan No*</strong>
													 </label>
													 <input type="text" class="form-control required" placeholder="Pan No" id="pan" name="pan" >
												</div>
											</div>
											<div class="col-sm-4">
												<div class="form-group">
													 <label>
														<strong>Caste*</strong>
													 </label>
													 <!-- <input type="text" class="form-control" placeholder="Caste" id="caste" name="caste"> -->

													 <select class="form-control required" id="caste" name="caste" >
															<option value="">--Select--</option>
															<option value="SC">SC</option>
															<option value="ST">ST</option>
															<option value="General">General</option>
															<option value="OBC">OBC</option>
															<option value="Other">Other</option>
														</select>
												</div>
											</div>
										</div>
									  </div>
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
													<input type="radio" name="conveyance" id="conveyance_yes" value="Yes"> 
													Yes
												  </label>
												  <label class="radio-inline">
													<input type="radio" name="conveyance" id="conveyance_no" value="No">
													No
												  </label>
												</div>
												<!-- <div class="custom-control custom-radio custom-control-inline">
													<input type="radio" class="custom-control-input" id="customRadio" name="example" value="customEx">
													
													<label class="custom-control-label" for="customRadio">Yes</label>
												</div>
												<div class="custom-control custom-radio custom-control-inline">
													<input type="radio" class="custom-control-input" id="customRadio" name="example" value="customEx">
													
													<label class="custom-control-label" for="customRadio">No</label>
												</div> -->
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
															Experience Level*
														</strong>
													</p>
													<div cio required">
													  <label class="radio-inline">
													  <input type="radio" name="experience" id="experience_fresh" value="Fresher"> 
													
														Fresher</label>
													  <label class="radio-inline">
														<input type="radio" name="experience" id="experience_exp" value="Experienced">
														Experienced
													  </label>
													</div>
												</div>
											</div>
											<div class="col-sm-6">
												<div class="form-group">
													<p>
														<strong>
															Field of Interest*
														</strong>
													</p>
													<div class="radio">
													  <label class="radio-inline">
														<input type="radio" name="interest" id="interest_voice" value="Voice"> 
														Voice
													  </label>
													  <label class="radio-inline">
														<input type="radio" name="interest" id="interest_back" value="Back Office">
														Back Office
													  </label>
													  <label class="radio-inline">
														<input type="radio" name="interest" id="interest_other" value="Other">
														Other
													  </label>
													</div>
												</div>
											</div>
											<div class="col-sm-12">
												<div class="form-group">
													<input type="text" class="form-control" id="interest_desc" name="interest_desc" placeholder="Describe">
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
													<!-- <input type="date" id="datepicker" class="form-control" /> -->
													<input type="date" name="past_inter_date" class="form-control">
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
											<input type="radio" name="service_standard" id="service_standard_yes" value="Yes"> 
											Yes
										  </label>
										  <label class="radio-inline">
											<input type="radio" name="service_standard" id="service_standard_no" value="No">
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
														Last Qualification*
													</strong>
												</p>
												<div class="form-group">
													<select class="form-control required" id="last_qualification" name="last_qualification">
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
									  <button type="button" name="next" class="next action-button" />Next Step</button>
								</fieldset>
								<fieldset>
									<div class="education-table">
										<div class="form-repeat">
										  <table class="table table-bordered table-striped">
											<thead>
											  <tr>
												<th></th>
												<th>Course Name</th>
												<th>Board / University</th>
												<th>School / University</th>
												<th>Passing Year</th>
												<th>%</th>
											  </tr>
											</thead>
											<tbody>
											  <tr class="education_detail_container">
												<td>
													<select name="deg_type[]" class="form-control required" id="deg_type">
														<option value="X th">X th</option>
														<option value="XII th">XII th</option>
														<option value="Graduation">Graduation</option>
														<option value="Professional Qualification">Professional Qualification</option>
														<option value="Any Other Qualification">Any Other Qualification</option>
														<option value="Any Course Being Pursued">Any Course Being Pursued</option>
													</select>
												</td>
												<td>
													<input type="text" name="course_name[]" class="form-control required" placeholder="Course Name" id="course_name">
												</td>
												<td>
													<input type="text" name="board_name[]" class="form-control required" placeholder="Board/University" id="board_name">
												</td>
												<td>
													<input type="text" name="school_name[]" class="form-control required" placeholder="School/University" id="school_name">
												</td>
												<td>
													<input type="number" name="pass_year[]" class="form-control required" placeholder="Passing Year"  value="" id="pass_year">
												</td>
												<td>
													<input type="text" name="marks[]" class="form-control required" placeholder="Marks %" value="" id="marks">
												</td>
												<td>
													<button type="button" class="btn btn-success rounded-circle add"><i class="fas fa-plus"></i></button>
												</td>
											  </tr>
											  <!-- <tr>
												<td>
													<select name="deg_type2" class="form-control">
														<option value="X th">X th</option>
														<option value="XII th">XII th</option>
														<option value="Graduation">Graduation</option>
														<option value="Professional Qualification">Professional Qualification</option>
														<option value="Any Other Qualification">Any Other Qualification</option>
														<option value="Any Course Being Pursued">Any Course Being Pursued</option>
													</select>
												</td>
												<td>
													<input type="text" name="course_name2" class="form-control" placeholder="Course Name">
												</td>
												<td>
													<input type="text" name="board_name2" class="form-control" placeholder="Board/University">
												</td>
												<td>
													<input type="text" name="school_name2" class="form-control" placeholder="School/University">
												</td>
												<td>
													<input type="number" name="pass_year2" min="1970" step="1" class="form-control" placeholder="Passing Year"  value="">
												</td>
												<td>
													<input type="text" name="marks2" class="form-control" placeholder="Marks %" value="">
												</td>
											  </tr>
											  <tr>
												<td>
													<select name="deg_type3" class="form-control">
														<option value="X th">X th</option>
														<option value="XII th">XII th</option>
														<option value="Graduation">Graduation</option>
														<option value="Professional Qualification">Professional Qualification</option>
														<option value="Any Other Qualification">Any Other Qualification</option>
														<option value="Any Course Being Pursued">Any Course Being Pursued</option>
													</select>
												</td>
												<td>
													<input type="text" name="course_name3" class="form-control" placeholder="Course Name">
												</td>
												<td>
													<input type="text" name="board_name3" class="form-control" placeholder="Board/University">
												</td>
												<td>
													<input type="text" name="school_name3" class="form-control" placeholder="School/University">
												</td>
												<td>
													<input type="number" name="pass_year3" min="1970" step="1" class="form-control" placeholder="Passing Year"  value="">
												</td>
												<td>
													<input type="text" name="marks3" class="form-control" placeholder="Marks %" value="">
												</td>
											  </tr>
											  <tr>
												<td>
													<select name="deg_type4" class="form-control">
														<option value="X th">X th</option>
														<option value="XII th">XII th</option>
														<option value="Graduation">Graduation</option>
														<option value="Professional Qualification">Professional Qualification</option>
														<option value="Any Other Qualification">Any Other Qualification</option>
														<option value="Any Course Being Pursued">Any Course Being Pursued</option>
													</select>
												</td>
												<td>
													<input type="text" name="course_name4" class="form-control" placeholder="Course Name">
												</td>
												<td>
													<input type="text" name="board_name4" class="form-control" placeholder="Board/University">
												</td>
												<td>
													<input type="text" name="school_name4" class="form-control" placeholder="School/University">
												</td>
												<td>
													<input type="number" name="pass_year4" min="1970" step="1" class="form-control" placeholder="Passing Year"  value="">
												</td>
												<td>
													<input type="text" name="marks4" class="form-control" placeholder="Marks %" value="">
												</td>
											  </tr>
											  <tr>
												<td>
													<select name="deg_type5" class="form-control">
														<option value="X th">X th</option>
														<option value="XII th">XII th</option>
														<option value="Graduation">Graduation</option>
														<option value="Professional Qualification">Professional Qualification</option>
														<option value="Any Other Qualification">Any Other Qualification</option>
														<option value="Any Course Being Pursued">Any Course Being Pursued</option>
													</select>
												</td>
												<td>
													<input type="text" name="course_name5" class="form-control" placeholder="Course Name">
												</td>
												<td>
													<input type="text" name="board_name5" class="form-control" placeholder="Board/University">
												</td>
												<td>
													<input type="text" name="school_name5" class="form-control" placeholder="School/University">
												</td>
												<td>
													<input type="number" name="pass_year5" min="1970" step="1" class="form-control" placeholder="Passing Year"  value="">
												</td>
												<td>
													<input type="text" name="marks5" class="form-control" placeholder="Marks %" value="">
												</td>
											  </tr>
											  <tr>
												<td>
													<select name="deg_type6" class="form-control">
														<option value="X th">X th</option>
														<option value="XII th">XII th</option>
														<option value="Graduation">Graduation</option>
														<option value="Professional Qualification">Professional Qualification</option>
														<option value="Any Other Qualification">Any Other Qualification</option>
														<option value="Any Course Being Pursued">Any Course Being Pursued</option>
													</select>
												</td>
												<td>
													<input type="text" name="course_name6" class="form-control" placeholder="Course Name">
												</td>
												<td>
													<input type="text" name="board_name6" class="form-control" placeholder="Board/University">
												</td>
												<td>
													<input type="text" name="school_name6" class="form-control" placeholder="School/University">
												</td>
												<td>
													<input type="number" name="pass_year6" min="1970" step="1" class="form-control" placeholder="Passing Year"  value="">
												</td>
												<td>
													<input type="text" name="marks6" class="form-control" placeholder="Marks %" value="">
												</td>
											  </tr> -->
											</tbody>
										  </table>
										</div>
										<div class="form-repeat">
											<p>
												<strong>
													Married*
												</strong>
											</p>
											<div class="radio">
											  <label class="radio-inline">
												<input type="radio" name="married" id="inlineRadio1" value="Yes"> 
												Yes
											  </label>
											  <label class="radio-inline">
												<input type="radio" name="married" id="inlineRadio2" value="No">
												No
											  </label>
											</div>
										</div>
										<div class="form-repeat">
											<input type="text" class="form-control" name="home_town" id="home_town" placeholder="Home Town">
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
										<table class="table table-striped">
											<thead>
											  <tr>
												<th></th>
												<th>Name</th>
												<th>Occupation</th>
											  </tr>
											</thead>
											<tbody>
											  <tr class="family_detail_container">
												<td>
													<select name="relation_type[]" class="form-control required" id="relation_type">
														<option value="">..Select..</option>
														<option value="Father">Father</option>
														<option value="Mother">Mother</option>
														<option value="Spouse">Spouse</option>
														<option value="Child">Child</option>
														<option value="Siblings">Siblings</option>
														<option value="Other Family Members">Other Family Members</option>
													</select>
												</td>
												<td>
													<input type="text" name="relative_name required" class="form-control" placeholder="Name" id="relative_name">
												</td>
												<td>
													<input type="text" name="relative_occupation" class="form-control required" placeholder="Occupation" id="relative_occupation">
												</td>
												<td>
													<button type="button" class="btn btn-success rounded-circle add_family"><i class="fas fa-plus"></i></button>
												</td>
											  </tr>
											  <!-- <tr>
												<td>
													<select name="relation_type2" class="form-control">
														<option value="">..Select..</option>
														<option value="Father">Father</option>
														<option value="Mother">Mother</option>
														<option value="Spouse">Spouse</option>
														<option value="Child">Child</option>
														<option value="Siblings">Siblings</option>
														<option value="Other Family Members">Other Family Members</option>
													</select>
												</td>
												<td>
													<input type="text" name="relative_name2" class="form-control" placeholder="Name">
												</td>
												<td>
													<input type="text" name="relative_occupation2" class="form-control" placeholder="Occupation">
												</td>
											  </tr>
											  <tr>
												<td>
													<select name="relation_type3" class="form-control">
														<option value="">..Select..</option>
														<option value="Father">Father</option>
														<option value="Mother">Mother</option>
														<option value="Spouse">Spouse</option>
														<option value="Child">Child</option>
														<option value="Siblings">Siblings</option>
														<option value="Other Family Members">Other Family Members</option>
													</select>
												</td>
												<td>
													<input type="text" name="relative_name3" class="form-control" placeholder="Name">
												</td>
												<td>
													<input type="text" name="relative_occupation3" class="form-control" placeholder="Occupation">
												</td>
											  </tr> -->  
											</tbody>
										  </table>
									</div>
									<div class="form-repeat">
										<div class="row">
											<div class="col-sm-6">
												<div class="form-group">
													<label><strong>Total Experience</str