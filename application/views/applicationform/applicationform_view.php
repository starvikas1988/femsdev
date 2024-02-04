<!doctype html>
<html lang="en">
	<head>
		<!-- Required meta tags -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

		<!-- Bootstrap CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
		<title>Application From</title>
	</head>
	<body style="background: #f0f0f0;">
		<div class="container" style="background: white;border: 3px solid #b4b4b4;border-radius: 4px;">
			<div class="row" style="border-bottom: 2px solid #b4b4b4;margin-bottom: 20px;">
				<div class="col-md-4">
					<img src="<?php echo base_url('main_img/logo.png'); ?>" style="width: 100px;">
				</div>
				<div class="col-md-8">
					<h4 class="text-right" style="padding-top:32px;">Applying For <?php echo str_replace('%20',' ',$job_title); ?></h4>
				</div>
			</div>
			<div class="row">
				<div class="col-12">
					<form action="<?php echo base_url('applicationform/process_form'); ?>" method="POST">
						<div class="form-group">
							<div class="form-row">
								<div class="col">
									<label>First name</label>
									<input type="text" name="first_name" class="form-control" placeholder="First name" required="">
									<input type="hidden" name="rq_id" id="rq_id" class="form-control" value="<?php echo $rq_id; ?>" required="">
									<input type="hidden" name="r_id" id="r_id" class="form-control" value="<?php echo $r_id; ?>" required="">
								</div>
								<div class="col">
									<label>Last name</label>
									<input type="text" name="last_name" class="form-control" placeholder="Last name" required="">
								</div>
								<div class="col">
									<label>DOB</label>
									<input type="date" name="dob" class="form-control" placeholder="DOB" required="">
								</div>
								<div class="col">
									<label>Gender</label>
									<select class="form-control" id="gender" name="gender" required="">
										<option value="">--Select--</option>
										<option value="Male">Male</option>
										<option value="Female">Female</option>
										<option value="Other">Other</option>
									</select>
								</div>
							</div>
						</div>
						<div class="form-group">
							<label for="exampleInputEmail1">Do you know anyone in Xplore-Tech / Are you applying through any Xplore-Tech Employee?</label>
							<div class="form-check form-check-inline">
								<input type="checkbox" class="form-check-input" id="referal" name="referal" value="Existing Employee">
								<label class="form-check-label" for="referal">Check Me If Yes</label>
							</div>
						</div>
						<div class="form-group d-none" id="ref_by_comp_emplo">
							<div class="form-row">
								<div class="col">
								  <input type="text" class="form-control" name="comp_employee_name" placeholder="Employee Name" value="">
								</div>
								<div class="col">
								  <input type="text" class="form-control" name="comp_employee_dept" placeholder="Employee Dept" value="">
								</div>
								<div class="col">
								  <input type="text" class="form-control" name="comp_employee_id" placeholder="Employee ID" value="">
								</div>
							</div>
						</div>
						<div class="form-group" id="ref_job_vacancy">
							<label for="exampleInputEmail1">How you come to know about the vacancy: </label>
							<div class="form-check form-check-inline">
								<input class="form-check-input" type="radio" name="referal" id="job_source_portal" value="Job Portal">
								<label class="form-check-label" for="job_source_portal">Job Portal</label>
							</div>
							<div class="form-check form-check-inline">
								<input class="form-check-input" type="radio" name="referal" id="job_source_friend" value="Friends">
								<label class="form-check-label" for="job_source_friend">Friends</label>
							</div>
							<div class="form-check form-check-inline">
								<input class="form-check-input" type="radio" name="referal" id="job_source_consult" value="Consultancy">
								<label class="form-check-label" for="job_source_consult">Consultancy</label>
							</div>
						</div>
						<div class="form-group">
							<div class="form-row">
								<div class="col">
									<label>Country</label>
									<input type="text" name="country" class="form-control" placeholder="Country">
								</div>
								<div class="col">
									<label>State</label>
									<input type="text" name="state" class="form-control" placeholder="State">
								</div>
								<div class="col">
									<label>City</label>
									<input type="text" name="city" class="form-control" placeholder="City">
								</div>
								<div class="col">
									<label>Postcode</label>
									<input type="text" name="postcode" class="form-control" placeholder="Postcode">
								</div>
							</div>
						</div>
						<div class="form-group">
							<label for="parmanent_address">Parmanent Address</label>
							<textarea class="form-control" id="parmanent_address" name="parmanent_address" placeholder="Parmanent Address"></textarea>
						</div>
						<div class="form-group">
							<label for="correspondence_address">Address for Correspondence</label>
							<textarea class="form-control" id="correspondence_address" name="correspondence_address" placeholder="Address for Correspondence"></textarea>
						</div>
						<div class="form-group">
							<div class="form-row">
								<div class="col">
									<input type="text" class="form-control" id="mobile_no" name="mobile_no" placeholder="Mobile No">
								</div>
								<div class="col">
									<input type="text" class="form-control" id="alternate_no" name="alternate_no" placeholder="Alternate No">
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="form-row">
								<div class="col">
									<input type="email" id="email" name="email" class="form-control" placeholder="Email">
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="form-row">
								<div class="col-md-5">
									<label>Own Conveyance</label>
									<div class="form-check form-check-inline">
										<input class="form-check-input" type="radio" name="conveyance" id="conveyance_yes" value="Yes">
										<label class="form-check-label" for="conveyance_yes">Yes</label>
									</div>
									<div class="form-check form-check-inline">
										<input class="form-check-input" type="radio" name="conveyance" id="conveyance_no" value="No">
										<label class="form-check-label" for="conveyance_no">No</label>
									</div>
								</div>
								<div class="col-md-7">
									<input type="text" class="form-control" name="d_licence" id="d_licence" placeholder="Driving Licence">
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="form-row">
								<div class="col-md-5">
									<label>Experience Level</label>
									<div class="form-check form-check-inline">
										<input class="form-check-input" type="radio" name="experience" id="experience_fresh" value="Fresher" required="">
										<label class="form-check-label" for="experience_fresh">Fresher</label>
									</div>
									<div class="form-check form-check-inline">
										<input class="form-check-input" type="radio" name="experience" id="experience_exp" value="Experienced" required="">
										<label class="form-check-label" for="experience_exp">Experienced</label>
									</div>
								</div>
								<div class="col-md-7">
									
								</div>
								
							</div>
						</div>
						<div class="form-group">
							<div class="form-row">
								<div class="col-md-5">
									<label>Field of Interest</label>
									<div class="form-check form-check-inline">
										<input class="form-check-input" type="radio" name="interest" id="interest_voice" value="Voice" required="">
										<label class="form-check-label" for="interest_voice">Voice</label>
									</div>
									<div class="form-check form-check-inline">
										<input class="form-check-input" type="radio" name="interest" id="interest_back" value="Back Office" required="">
										<label class="form-check-label" for="interest_back">Back Office</label>
									</div>
									<div class="form-check form-check-inline">
										<input class="form-check-input" type="radio" name="interest" id="interest_other" value="Other" required="">
										<label class="form-check-label" for="interest_other">Other</label>
									</div>
								</div>
								<div class="col-md-7">
									<input type="text" class="form-control" id="interest_desc" name="interest_desc" placeholder="Describe">
								</div>
								
							</div>
						</div>
						<div class="form-group">
							<label for="past_employee">Have you worked with Xplore-Tech / Fusion BPO before? if yes please specify L.W.D & Dept.</label>
							<input type="text" class="form-control" id="past_employee" name="past_employee" placeholder="L.W.D & Dept">
						</div>
						<div class="form-group">
							<div class="form-row">
								<div class="col-md-7">
									<label for="past_inter_date">Have you appeared for interview before? If Yes, please specify when?</label>
									
								</div>
								<div class="col-md-5">
									<input type="date" id="past_inter_date" name="past_inter_date" class="form-control">
								</div>
							</div>
						</div>
						<div class="form-group">
							<label>Are you willing to work in 24x7 service standard? </label>
							<div class="form-check form-check-inline">
								<input class="form-check-input" type="radio" name="service_standard" id="service_standard_yes" value="Yes" required="">
								<label class="form-check-label" for="service_standard_yes">Yes</label>
							</div>
							<div class="form-check form-check-inline">
								<input class="form-check-input" type="radio" name="service_standard" id="service_standard_no" value="No" required="">
								<label class="form-check-label" for="service_standard_no">No</label>
							</div>
						</div>
						<div class="form-group">
							<div class="form-row">
								<div class="col-md-3">
									<label for="skills">Skill Set Areas:</label>
								</div>
								<div class="col-md-9">
									<input type="text" class="form-control" id="skills" name="skills" placeholder="separate by ','">
								</div>
							</div>	
						</div>
						<div class="form-group">
							<label for="last_qualification">Last Qualification:</label>
							<input type="text" class="form-control" id="last_qualification" name="last_qualification" placeholder="Last Qualification">
						</div>
						<div class="form-group">
							<label for="skills" class="font-weight-bold">Educational Details:</label>
							<table class="table table-bordered">
								<thead class="thead-light">
									<tr>
										<th scope="col"></th>
										<th scope="col">Course Name</th>
										<th scope="col">Board / University</th>
										<th scope="col">School / University</th>
										<th scope="col">%</th>
										<th scope="col"></th>
									</tr>
								</thead>
								<tbody>
									<tr class="education_detail_container">
										<td>
											<select name="deg_type[]" class="form-control" required>
												<option value="X th">X th</option>
												<option value="XII th">XII th</option>
												<option value="Graduation">Graduation</option>
												<option value="Professional Qualification">Professional Qualification</option>
												<option value="Any Other Qualification">Any Other Qualification</option>
												<option value="Any Course Being Pursued">Any Course Being Pursued</option>
											</select>
										</td>
										<td>
											<input type="text" name="course_name[]" class="form-control" placeholder="Course Name" required>
										</td>
										<td>
											<input type="text" name="board_name[]" class="form-control" placeholder="Board/University" required>
										</td>
										<td>
											<input type="text" name="school_name[]" class="form-control" placeholder="School/University" required>
										</td>
										<td>
											<input type="text" name="marks[]" class="form-control" placeholder="Marks %" required>
										</td>
										<td>
											<button type="button" class="btn btn-success rounded-circle add"><i class="fas fa-plus"></i></button>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
						<div class="form-group">
							<div class="form-row">
								<div class="col-md-4">
									<label for="exampleInputEmail1">Married:</label>
									<div class="form-check form-check-inline">
										<input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="Yes" required="">
										<label class="form-check-label" for="inlineRadio1">Yes</label>
									</div>
									<div class="form-check form-check-inline">
										<input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="No" required="">
										<label class="form-check-label" for="inlineRadio2">No</label>
									</div>
								</div>
								<div class="col-md-8">
									<input type="text" class="form-control" name="home_town" id="home_town" placeholder="Home Town">
								</div>
							</div>
						</div>
						<div class="form-group">
							<label for="skills" class="font-weight-bold">Family Details:</label>
							<table class="table table-bordered">
								<thead class="thead-light">
									<tr>
										<th scope="col"></th>
										<th scope="col">Name</th>
										<th scope="col">Occupation</th>
										<th scope="col"></th>
									</tr>
								</thead>
								<tbody>
									<tr class="family_detail_container">
										<td>
											<select name="relation_type[]" class="form-control">
												<option value="Father">Father</option>
												<option value="Mother">Mother</option>
												<option value="Spouse">Spouse</option>
												<option value="Child">Child</option>
												<option value="Siblings">Siblings</option>
												<option value="Other Family Members">Other Family Members</option>
											</select>
										</td>
										<td>
											<input type="text" name="relative_name[]" class="form-control" placeholder="Name">
										</td>
										<td>
											<input type="text" name="relative_occupation[]" class="form-control" placeholder="Occupation">
										</td>
										<td>
											<button type="button" class="btn btn-success rounded-circle add_family"><i class="fas fa-plus"></i></button>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
						<div class="form-group">
							<div class="form-row">
								<div class="col">
									<label for="total_exp">Total Experience</label>
									<input type="text" id="total_exp" name="total_exp" class="form-control" placeholder="">
								</div>
								<div class="col">
									<label for="notice_period">Notice Period For Joining</label>
									<input type="text" id="notice_period" name="notice_period" class="form-control" placeholder="">
								</div>
							</div>
						</div>
						<div class="form-group">
							<label for="skills" class="font-weight-bold">Last 3 Organization:</label>
							<table class="table table-bordered">
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
											<input type="text" name="org_name[]" class="form-control" placeholder="Name">
										</td>
										<td>
											<input type="text" name="designation[]" class="form-control" placeholder="Designation">
										</td>
										<td>
											<input type="text" name="tenure[]" class="form-control" placeholder="Tenure of Work">
										</td>
										<td>
											<input type="text" name="references[]" class="form-control" placeholder="References">
										</td>
									</tr>
									<tr>
										<td>
											<input type="text" name="org_name[]" class="form-control" placeholder="Name">
										</td>
										<td>
											<input type="text" name="designation[]" class="form-control" placeholder="Designation">
										</td>
										<td>
											<input type="text" name="tenure[]" class="form-control" placeholder="Tenure of Work">
										</td>
										<td>
											<input type="text" name="references[]" class="form-control" placeholder="References">
										</td>
									</tr>
									<tr>
										<td>
											<input type="text" name="org_name[]" class="form-control" placeholder="Name">
										</td>
										<td>
											<input type="text" name="designation[]" class="form-control" placeholder="Designation">
										</td>
										<td>
											<input type="text" name="tenure[]" class="form-control" placeholder="Tenure of Work">
										</td>
										<td>
											<input type="text" name="references[]" class="form-control" placeholder="References">
										</td>
									</tr>
								</tbody>
							</table>
						</div>
						<div class="form-group">
							<div class="form-row">
								<div class="col-md-4">
									<label>Reason for Leaving Job (Present/Last)</label>
									
								</div>
								<div class="col-md-8">
									<input type="text" name="job_leav_reason" id="job_leav_reason" class="form-control" placeholder="">
								</div>
							</div>
						</div>
						<div class="form-group">
							<table class="table table-bordered">
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
						<div class="form-group">
							<label for="skills" class="font-weight-bold">References:</label>
							<table class="table table-bordered">
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
						<div class="form-group">
							<div class="form-row">
								<div class="col-md-4">
									<label>Any Known Medical Illness:</label>
									
								</div>
								<div class="col-md-8">
									<input type="text" class="form-control" name="madical" placeholder="">
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="form-row">
								<div class="col-md-4">
									<label>Any Accidents in Past:</label>
									
								</div>
								<div class="col-md-8">
									<input type="text" class="form-control" name="accidents" placeholder="">
								</div>
							</div>
						</div>
						<hr>
						<div class="form-group">
							<div class="form-row">
								<div class="col-md-8 font-weight-bold">
									<label>CONFIRMATION REGARDING LEGAL ASSOCIATION</label>
								</div>
							</div>
							<div class="form-row">
								<div class="col-md-5">
									<label>Any judicial proceeding against you in the court of law?</label>
								</div>
								<div class="col-md-7">
									<input type="text" class="form-control" name="legal" placeholder="If Yes Give Details">
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="form-row">
								<div class="col-md-12">
									<label>I declare that abovementioned information is true to the best of my knowledge. Any action which the management deems fit may be taken if discrepancy is found in the same.</label>
									<div class="form-check form-check-inline">
										<input type="checkbox" class="form-check-input" id="declare" name="declare">
										<label class="form-check-label" for="declare">Check Me If Yes</label>
									</div>
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="form-row">
								<div class="col">
									<button type="submit" class="btn btn-block btn-success" disabled>Submit</button>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
		

		<!-- Optional JavaScript -->
		<!-- jQuery first, then Popper.js, then Bootstrap JS -->
		<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
		<script>
			$(document).on('click','#referal',function()
			{
				if($(this).prop('checked'))
				{
					$('#ref_by_comp_emplo').removeClass('d-none');
					$('#ref_job_vacancy').addClass('d-none');
					$('#ref_job_vacancy input').prop('checked',false);
				}
				else
				{
					$('#ref_by_comp_emplo').addClass('d-none');
					$('#ref_job_vacancy').removeClass('d-none');
					$('#ref_by_comp_emplo input').val('');
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
			$(document).on('focusout','#mobile_no',function()
			{
				var mobile_no = $(this).val();
				var rq_id = $('#rq_id').val();
				var datas = {'mobile_no':mobile_no,'rq_id':rq_id};
				console.log(datas);
				$.ajax({
					type	:	'POST',
					url		:	'<?php echo base_url('applicationform/check_mobile_exist'); ?>',
					data	:	datas,
					success	:	function(msg){
								if(msg == true)
								{
									alert('You Have Already Applied For This Job');
									window.location.href = '<?php echo base_url('applicationform'); ?>';
								}
							}
				});
			});
		</script>
		
		<script>
			$(document).on('focusout','#email',function()
			{
				var email = $(this).val();
				var rq_id = $('#rq_id').val();
				var datas = {'email':email,'rq_id':rq_id};
				console.log(datas);
				$.ajax({
					type	:	'POST',
					url		:	'<?php echo base_url('applicationform/check_email_exist'); ?>',
					data	:	datas,
					success	:	function(msg){
								if(msg == true)
								{
									alert('You Have Already Applied For This Job');
									window.location.href = '<?php echo base_url('applicationform'); ?>';
								}
							}
				});
			});
		</script>
	</body>
</html>