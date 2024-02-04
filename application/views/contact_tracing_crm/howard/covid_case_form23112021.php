<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.15.4/css/fontawesome.min.css" integrity="sha384-jLKHWM3JRmfMU0A5x5AkjWkw/EYfGUAGagvnfryNV3F9VqM98XiIH7VBGVoxVSc7" crossorigin="anonymous">
<style>
p.chatquote{
	background-color: #fbfbfb;
    font-size: 12px;
    padding: 5px 14px;
    line-height: 1.3em;
}
p.chatimp{
	background-color:#f3e8e8;
}
.caller-widget select {
	width:100%;
	padding:5px;
	border:1px solid #ddd;
	height:35px;
	border-radius:5px;
	transition:all 0.5s ease-in-out 0s;
}
.caller-widget select:hover {
	border:1px solid #188ae2;
}
.caller-widget select:focus {
	border:1px solid #188ae2;
	outline:none;
	box-shadow:none;
}
.caller-widget .form-control {
	width:100%;
	height:35px;
	font-size:14px;
	transition:all 0.5s ease-in-out 0s;
}
.caller-widget .form-control:hover {
	border:1px solid #188ae2;
}
.caller-widget .form-control:focus {
	border:1px solid #188ae2;
	outline:none;
	box-shadow:none;
}
.common-top {
	width:100%;	
}
.btn-widget {
	width:100%;
	margin:10px 0 0 0;
}
.submit-btn {
	width:200px;
	padding:10px;
	background:#188ae2;
	color:#fff;
	border:none;
	border-radius:5px;
	transition:all 0.5s ease-in-out 0s;
}
.submit-btn:hover {
	background:#0e6cb5;
}
.submit-btn:focus {
	outline:none;
	box-shadow:none;
} 
.caller-widget ::-webkit-input-placeholder { /* Chrome/Opera/Safari */
  color:rgba(0,0,0,0.5);
  font-size:14px;
}
.caller-widget ::-moz-placeholder { /* Firefox 19+ */
  color:rgba(0,0,0,0.5);
  font-size:14px;
}
.caller-widget :-ms-input-placeholder { /* IE 10+ */
  color:rgba(0,0,0,0.5);
  font-size:14px;
}
.caller-widget :-moz-placeholder { /* Firefox 18- */
  color:rgba(0,0,0,0.5);
  font-size:14px;
}
.case-detail {
	width:100%;
	display:none;
}
.contact-tracing-new {
	width:100%;
	display:none;
}
.final-call {
	width:100%;
	display:none;
}
.common-all {
	width:100%;
	padding:15px 25px;
}
.table-widget {
	width:100%;
	margin:10px 0 0 0;
}
.table-widget td {
	padding:8px 10px!important;
}
.table-widget textarea {
	padding:10px;
}
.remarks-bg {
	width:100%;
	padding:10px;
	background:#e3e3e3;
	border-radius:5px;
	font-size:14px;
	font-weight:bold;
	margin:0 0 15px 0;
}
.email-link a {
	display:inline-block;
	margin:0 15px 10px 0;
}
.email-link a:hover {
	text-decoration:underline;
}
.map-area {
	width:100%;
	display:none;
}
#map-area iframe {
	width:100%;
	height:450px;
	border:none;
}
h4 {
	font-weight:bold;
}
</style>

<div class="wrap">
<section class="app-content">
  <div class="widget">
	<div class="main-zovio" id="contact-tracing">
		<div class="widget-body">
		  <h4><i class="fa fa-wpforms"></i> Contact Tracing Form
			<p class="timerClock pull-right"><i class="fa fa-clock-o"></i> <span id="timeWatch"></span></p>
		  </h4>
		  <hr/>
		  <?php if(isset($case_details)){
			//   var_dump($case_details);
		  } ?>
		  <?php 
		  if(isset($case_daywise_details)){
			//   var_dump($case_daywise_details);
		  } 
		  ?>
			<div class="panel panel-default">
				<div class="panel-body">
					<form id="formone" method="POST" autocomplete="off">
						<div class="caller-widget">
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
									<label><i class="fa fa-university"></i> Institute</label>
									<input class="form-control" placeholder="" value="Howard County Public School System" readonly>
									<input type="hidden" class="form-control" id="time_interval" placeholder="" value="" name="time_interval" readonly>
									</div>
								</div>
							
								<div class="col-md-6">
									<div class="form-group">
									<label><i class="fa fa-calendar-alt"></i> Date of Call</label>
									<!-- <input type="text" class="form-control oldDatePick"  placeholder="" value="<?php echo !empty($crmdetails['cid']) ? date('m/d/Y', strtotime($crmdetails['date_of_call'])) : date('m/d/Y', strtotime($currentDate)); ?>"  name="date_of_call"> -->
									<input type="text" class="form-control oldDatePick"  placeholder="" value="<?php echo !empty($case_details['cid']) ? date('m/d/Y', strtotime($case_details['date_of_call'])) : date('m/d/Y', strtotime($date_of_call)); ?>"  readonly>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
									<label>Incident #</label>
									<input type="text" class="form-control" name="incident_id" value="<?php echo isset($case_details['incident_id']) ? $case_details['incident_id'] : $incident_id; ?>" readonly>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label>Initial Case Type<span style="color:red">*</span></label>
										<?php 
										$val='';
										if(isset($case_details['initial_case'])){
											if(!empty($case_details['initial_case'])){
												$val = $case_details['initial_case'];
											}
										}
										// echo $val;
										?>
										<select name="initial_case" id="initial_case_type" required>
											<option value="">--Select Case Type--</option>
											<option value="1" <?php echo ($val==1)  ? 'selected="selected"' : '' ?>>Confirmed Positive</option>
											<option value="2" <?php echo ($val==2)  ? 'selected="selected"' : '' ?>>Presumed Positive</option>
											<option value="3" <?php echo ($val==3)  ? 'selected="selected"' : '' ?>>Close Contact</option>
											<option value="4" <?php echo ($val==4)  ? 'selected="selected"' : '' ?>>Proximity</option>
											<option value="5" <?php echo ($val==5)  ? 'selected="selected"' : '' ?>>Illness (Non-COVID with no close contact to positive Case)</option>
										</select>
									</div>
								</div>
											
							</div>
							<div class="common-top">
								<div class="row">
								<div class="col-md-12">
									<div class="form-group">
									<label><i class="fa fa-info-circle"></i> Caller Information & Reason for Call</label>
									<textarea type="text" class="form-control" name="caller_info" placeholder=""><?php echo isset($case_details['caller_info']) ? $case_details['caller_info'] : ''; ?></textarea>
									</div>
								</div>
								</div>
							</div>
							<div class="row">	
								<div class="col-md-6">
									<div class="form-group">
									<label><i class="fa fa-user"></i> Caller's First Name<span style="color:red">*</span></label>
									<input type="text" name="caller_fname" class="form-control" id="c_fname" value="<?php echo isset($case_details['caller_fname']) ? $case_details['caller_fname'] : ''; ?>" required>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
									<label>Caller's Last Name</label>
									<input type="text" name="caller_lname" class="form-control" id="c_lname" value="<?php echo isset($case_details['caller_lname']) ? $case_details['caller_lname'] : ''; ?>">
									</div>
								</div>
							</div>
							<div class="row">	
								<div class="col-md-6">
									<div class="form-group">
									<label><i class="fa fa-graduation-cap"></i> Student's First Name</label>
									<input type="text" name="student_fname" class="form-control" id=""
									value="<?php echo isset($case_details['student_fname']) ? $case_details['student_fname'] : ''; ?>">
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
									<label>Student Last Name</label>
									<input type="text" name="student_lname" class="form-control" id=""
									value="<?php echo isset($case_details['student_lname']) ? $case_details['student_lname'] : ''; ?>">
									</div>
								</div>
							</div>
							<div class="row">	
								<div class="col-md-6">
									<div class="form-group">
									<label><i class="fa fa-phone"></i> Caller's Phone<span style="color:red">*</span></label>
									<input type="text" name="callers_phone" pattern="^\d{9,10}$" onkeypress="return isNumber(event)" 
									class="form-control" id="" value="<?php echo isset($case_details['caller_phone']) ? $case_details['caller_phone'] : ''; ?>" required>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
									<label>Student Phone</label>
									<input type="text" name="secondary_phone"  pattern="^\d{9,10}$" onkeypress="return isNumber(event)" 
									class="form-control" value="<?php echo isset($case_details['secondary_phone']) ? $case_details['secondary_phone'] : ''; ?>" id="">
									</div>
								</div>
							</div>
							<div class="row">	
								<div class="col-md-6">
									<div class="form-group">
									<label>Title:</label>
									<input type="text" name="title" class="form-control" id="" value="<?php echo isset($case_details['title']) ? $case_details['title'] : ''; ?>">
									</div>
								</div>			
							</div>
							<div class="row">	
								<div class="col-md-4">
									<div class="form-group">
									<label>Schools 1 <span style="color:red">*</span></label>
									<select name="schools" id="school" required>
										<option value="">--Select School--</option>
										<?php
										foreach ($school_list as $key => $value) {
											$selected = '';
											if(isset($case_details['schools'])){
												if($value['id'] == $case_details['schools'] && !empty($case_details['schools'])){
													$selected = 'selected';
												}
											}
											?>
											<option value=<?php echo $value['id']; ?> <?php echo ($selected)  ? 'selected="'.$selected.'"' : '' ?>><?php echo $value['name']; ?></option>
										<?php } ?>
									</select>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
									<label>Grades</label>
									<input type="text" name="grades" class="form-control" id="grades" value="<?php echo isset($case_details['grades']) ? $case_details['grades'] : ''; ?>">
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
									<label>Address</label>
									<input type="text" name="address" class="form-control" id="address" value="<?php echo isset($case_details['address']) ? $case_details['address'] : ''; ?>">
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
									<label>Schools 2</label>
									<select name="schools2" id="school2">
										<option value="">--Select School--</option>
										<?php
										foreach ($school_list as $key => $value) {
											$selected = '';
											if(isset($case_details['school2'])){
												if($value['id'] == $case_details['school2'] && !empty($case_details['school2'])){
													$selected = 'selected';
													// $selected = $case_details['initial_case'];
												}
											}
											?>
											<option value=<?php echo $value['id']; ?> <?php echo ($selected)  ? 'selected="'.$selected.'"' : '' ?>><?php echo $value['name']; ?></option>
										<?php } ?>
									</select>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
									<label>Grades</label>
									<input type="text" name="grades2" class="form-control" id="grades2" value="<?php echo isset($case_details['grades2']) ? $case_details['grades2'] : ''; ?>">
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
									<label>Address</label>
									<input type="text" name="address2" class="form-control" id="address2" value="<?php echo isset($case_details['address2']) ? $case_details['address2'] : ''; ?>">
									</div>
								</div>

							</div>
							<div class="row">	
								<div class="col-md-6">
									<div class="form-group">
									<label>Teacher <span style="color:gray;font-size:13px">(Confirm Spelling)</span></label>
									<input type="text" name="teacher" class="form-control" id="" value="<?php echo isset($case_details['teacher']) ? $case_details['teacher'] : ''; ?>">
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
									<label>Assigned Room # <span style="color:gray;font-size:13px">(If Applicable)</span></label>
									<input type="text" name="assigned_room" class="form-control" id="" value="<?php echo isset($case_details['assigned_room']) ? $case_details['assigned_room'] : ''; ?>">
									</div>
								</div>
							</div>
							<div class="row">	
								<div class="col-md-12">
									<div class="form-group">
									<label>Other Classes/Locations Attended</label>				  
									</div>
								</div>			
							</div>
							<div class="row">	
								<?php 
								for($i=1;$i<11;$i++){ 
									$className = 'class_'.$i;
									?>
								<div class="col-md-6">
									<div class="form-group">
										<select <?php echo "name='".$className."'"?> class="location_attended">
										<?php
											foreach ($other_location_list as $key => $value) { 
												$selected = '';
												if(isset($case_details[$className])){
													if($key == $case_details[$className] && !empty($case_details[$className])){
														$selected = 'selected';
													}
												}
												?>
												<option value="<?php echo $key; ?>" <?php echo ($selected)  ? 'selected="'.$selected.'"' : '' ?>><?php echo $value; ?></option>
											<?php
											 
											}
										?>
										</select>
									</div>
								</div>
								<?php } ?>

							</div>
							<?php
							$ds_other = 'display:none';
							if(isset($case_details['other_location'])){
								if(!empty($case_details['other_location'])){

									$ds_other = 'display:block';
								}
							}?>
							<div class="row" <?php echo "style='".$ds_other."'"?> id="others_expose">	
								<div class="col-md-6">
									<div class="form-group">
									<label>Others</label>
									<textarea type="text" class="form-control" name="others_location" id="others_val"><?php echo isset($case_details['other_location']) ? $case_details['other_location'] : ''; ?></textarea>
									</div>
								</div>
							</div>
						</div>
						<div class="btn-widget">
							<button type="submit" class="submit-btn" id="contact-trace">Save & Continue</button>
						</div>
					</form>
				</div>
		    </div>
	    </div>
	</div>
	
	<!--start case detials elements here-->
	<div class="case-detail" id="case-detail">
		<div class="common-all">
			<div class="caller-widget">
				<div class="body-widget">
					<span class="btn btn-primary btn-sm" id="back_one"><i class="fa fa-arrow-left"></i> Back</span>
					<h4>Case Details
						<p class="timerClock pull-right"><i class="fa fa-clock-o"></i> <span id="timeWatch"></span></p>
					</h4>
					<hr/>
				</div>
				<form id="formtwo" method="POST" autocomplete="off">
					<div class="row">	
						<div class="col-md-6">
							<div class="form-group">
							<label>Incident #</label>
							<input type="text" class="form-control" name="incident_id" value="<?php echo isset($case_details['incident_id']) ? $case_details['incident_id'] : $incident_id; ?>" readonly>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>Initial Case Type</label>
								<?php
								foreach ($initial_case_type as $key => $value) {
									$val = '';
									if(isset($case_details['initial_case'])){
										if($key == $case_details['initial_case'] && !empty($case_details['initial_case'])){
											$val = $value;
										}
									}
								}
								?>
								<input type="text" class="form-control" 
								value="<?php echo isset($val) ? $val : ''; ?>"
								id="r_initial_case_type" readonly />
							</div>
						</div>
					</div>
					<div class="row">	
						<div class="col-md-6">
							<div class="form-group">
								<label>Has Caller Been Diagnosed as Positive?</label>
								<?php 
								$val='';
								if(isset($case_details['diagnosed_as_positive'])){
									if(!empty($case_details['diagnosed_as_positive'])){
										$val = $case_details['diagnosed_as_positive'];
									}
								}
								?>

								<select name="diagnosed_as_positive" id="diagnosed_yes">
									<option value="1" <?php echo ($val==1)  ? 'selected="selected"' : '' ?>>Yes</option>
									<option value="2" <?php echo ($val==2)  ? 'selected="selected"' : '' ?>>No</option>
									<option value="3" <?php echo ($val==3)  ? 'selected="selected"' : '' ?>>Awaiting Results</option>
								</select>
							</div>
						</div>
						<div class="col-md-6" id="diagnosed_date" style="diaplay:block">
							<div class="form-group">
							<label>Date Tested</label>
							<input type="date" class="form-control" name="diagnosed_date" id="" value="<?php echo isset($case_details['diagnosed_date']) ? $case_details['diagnosed_date'] : ''; ?>">
							</div>
						</div>
					</div>
				    <div class="row">
						<div class="col-md-6">
							<div class="form-group">
							<label>Child's School 1</label>
							<input type="text" class="form-control" name="callers_school" id="childs_school" value="<?php echo isset($case_details['callers_school']) ? $case_details['callers_school'] : ''; ?>" readonly>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
							<label>Caller's Work Location or Child's School Location </label>
							<input type="text" class="form-control" name="callers_work_location" id="school_location"  value="<?php echo isset($case_details['callers_work_location']) ? $case_details['callers_work_location'] : ''; ?>" readonly>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
							<label>Child's School 2</label>
							<input type="text" class="form-control" name="callers_school2" id="childs_school2" value="<?php echo isset($case_details['callers_school2']) ? $case_details['callers_school2'] : ''; ?>" readonly>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
							<label>Caller's Work Location or Child's School Location </label>
							<input type="text" class="form-control" name="callers_work_location2" id="school_location2" value="<?php echo isset($case_details['callers_work_location2']) ? $case_details['callers_work_location2'] : ''; ?>" readonly>
							</div>
						</div>
					</div>
					<div class="row">	
						<div class="col-md-12">
							<div class="form-group">
							<label>May I please have the name of your Manager so that we can include him/her on all communciations regarding any absence? (Staff only)</label>
							</div>
						</div>					
					</div>
					<div class="row">	
						<div class="col-md-6">
							<div class="form-group">
							<label>						  
								Manager First and Last Name: 
							</label>
							<input type="text" name="manager_name" class="form-control" value="<?php echo isset($case_details['manager_name']) ? $case_details['manager_name'] : ''; ?>" id="">
							</div>
						</div>					
					</div>
					<div class="row">	
						<div class="col-md-12">
							<div class="form-group">
							<?php 
								$val='';
								if(isset($case_details['entrance_and_exit'])){
									if(!empty($case_details['entrance_and_exit'])){
										$val = $case_details['entrance_and_exit'];
									}
								}
								?>
							<label>May I please ask for the details of where you entered and exited the building for cleaning protocol? (Add notes in documtentation for more than one entrance/exit)</label>						  
								<select name="entrance_and_exit" id="front_door">
									<option value="1" <?php echo ($val==1)  ? 'selected="selected"' : '' ?>>Front Door</option>
									<option value="2" <?php echo ($val==2)  ? 'selected="selected"' : '' ?>>Back Door</option>
									<option value="3" <?php echo ($val==3)  ? 'selected="selected"' : '' ?>>Side Entrance</option>
									<option value="4" <?php echo ($val==4)  ? 'selected="selected"' : '' ?>>Others</option>
								</select>
							</div>
						</div>
					</div>
					<?php
						$do_other = 'display:none';
						if(isset($case_details['doors_other'])){
							if(!empty($case_details['doors_other'])){
								$do_other = 'display:block';
							}
						}?>
					<div class="row" <?php echo "style='".$do_other."'"?> id="others_door">
						<div class="col-md-6">
							<div class="form-group">
							<label>Others Entrance/Exit</label>
							<textarea type="text" class="form-control" name="doors_other" id="doors_other"><?php echo isset($case_details['doors_other']) ? $case_details['doors_other'] : ''; ?></textarea>
							</div>
						</div>
					</div>			
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
							<?php 
								$val='';
								if(isset($case_details['any_close_contact'])){
									if(!empty($case_details['any_close_contact'])){
										$val = $case_details['any_close_contact'];
									}
								}
								?>
							<label>Did you have Close Contact with any other members of the staff or students?  What I mean by this is were you within 6 feet, for a period of 15 minutes or more over a 24 hour period of time?</label>					  
								<select name="any_close_contact" id="close_connect">
									<option value="1" <?php echo ($val==1)  ? 'selected="selected"' : '' ?>>Yes</option>
									<option value="2" <?php echo ($val==2)  ? 'selected="selected"' : '' ?>>No</option>
									<option value="3" <?php echo ($val==3)  ? 'selected="selected"' : '' ?>>Others</option>
								</select>
							</div>
						</div>
					</div>
					<?php
						$doc_other = 'display:none';
						if(isset($case_details['connect_others'])){
							if(!empty($case_details['connect_others'])){
								$doc_other = 'display:block';
							}
						}?>
					<div class="row" <?php echo "style='".$doc_other."'"?> id="others_connect">	
						<div class="col-md-6">
							<div class="form-group">
							<label>Others Contact</label>
							<textarea type="text" class="form-control" name="connect_others" id="connect_others"><?php echo isset($case_details['connect_others']) ? $case_details['connect_others'] : ''; ?></textarea>
							</div>
						</div>
					</div>
					<div class="row">	
						<div class="col-md-6">
							<div class="form-group">
								<?php 
								$val='';
								if(isset($case_details['fully_vaccinated'])){
									if(!empty($case_details['fully_vaccinated'])){
										$val = $case_details['fully_vaccinated'];
									}
								}
								?>
								<label>Have You been fully vaccinated</label>
								<select name="fully_vaccinated" id="fully_vaccinated">
									<option value="1" <?php echo ($val==1)  ? 'selected="selected"' : '' ?>>Yes</option>
									<option value="2" <?php echo ($val==2)  ? 'selected="selected"' : '' ?>>No</option>
								</select>
							</div>
						</div>
						<?php 
							$isfirstdis='';
							if($val==2){
									$dis='display:none';
									$isfirstdis='display:block';
								}
								else
								{
									$dis='display:block';
									$isfirstdis='display:none';
								}
							
						?>
						<div class="col-md-6" id="fully_vaccinated_date" style="<?php echo $dis;?>">
							<div class="form-group">
							<label>Mark a Date</label>
							<input type="date" name="fully_vaccinated_date" class="form-control" id="fully_vaccinated_date_val" 
							value="<?php echo isset($case_details['fully_vaccinated_date']) ? $case_details['fully_vaccinated_date'] : ''; ?>">
							</div>
						</div>					
					</div>
					<div class="row fdose" style="<?php echo $isfirstdis;?>">	
						<div class="col-md-6">
							<div class="form-group">
								<?php 
								$val='';
								if(isset($case_details['is_first_dose_taken'])){
									if(!empty($case_details['is_first_dose_taken'])){
										$val = $case_details['is_first_dose_taken'];
									}
								}
								?>
								<label>Have you been vaccinated with 1st dose</label>
								<select name="first_dose" id="first_dose">
									<option value="1" <?php echo ($val==1)  ? 'selected="selected"' : '' ?>>Yes</option>
									<option value="2" <?php echo ($val==2)  ? 'selected="selected"' : '' ?>>No</option>
								</select>
							</div>
						</div>
						<?php
							$disp="";
							if($val==2){
								$disp='display:none';
							}
							else
							{
								$disp='display:block';
							}
						?>
						<div class="col-md-6" id="first_vaccinated_date" style="<?php echo $disp;?>">
							<div class="form-group">
							<label>First Vaccinatd  Date</label>
							<input type="date" name="first_vaccinated_date" class="form-control" id="first_vaccinated_date_val" 
							value="<?php echo isset($case_details['first_dose_date']) ? $case_details['first_dose_date'] : ''; ?>">
							</div>
						</div>					
					</div>
					<div class="row">	
						<div class="col-md-6 final_shot">
							<div class="form-group">
								<label>Has it been 2 weeks since your Final shot</label>
								<input type="date" name="final_shot" class="form-control" id=""
									value="<?php echo isset($case_details['final_shot']) ? $case_details['final_shot'] : ''; ?>"
								>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group"><!--<span style="color:red">*</span>-->
								<label>Date of 1st Symptom</label>
								<input type="text" name="date_first_sym" class="form-control" id="date_first_sym" placeholder="yyyy-mm-dd"
								value="<?php echo isset($case_details['date_first_sym']) ? $case_details['date_first_sym'] : ''; ?>">
							</div>
						</div>					
					</div>
					<div class="row">	
						<div class="col-md-6">
							<div class="form-group">
							<label>Document all information below:</label>
							<textarea type="text" name="more_information_about_contact" class="form-control" id=""><?php echo isset($case_details['more_information_about_contact']) ? $case_details['more_information_about_contact'] : ''; ?></textarea>
							</div>
						</div>	
						<div class="col-md-6">
							<div class="form-group">
								<label>And what was the date you were last at the buliding please Or on The Bus ?</label>
								<input type="date" name="last_date_in_building" class="form-control" id=""
								value="<?php echo isset($case_details['last_date_in_building']) ? $case_details['last_date_in_building'] : ''; ?>"
								>
							</div>
						</div>				
					</div>
					<div class="btn-widget">
						<button type="submit" class="submit-btn" id="case-inner">Save & Continue</button>
					</div>
				</form>
			</div>
		</div>
	</div>
	<!--end case detials elements here-->
	
	<!--start contact tracing elements here-->
	<div class="contact-tracing-new" id="contact-tracing-new">
		<div class="common-all">
			<div class="caller-widget">
				<div class="body-widget">
				<span class="btn btn-primary btn-sm" id="back_two"><i class="fa fa-arrow-left"></i> Back</span>
					<h4>
						Contact Tracing
						<p class="timerClock pull-right"><i class="fa fa-clock-o"></i> <span id="timeWatch"></span></p>
					</h4>
					<hr/>
				</div>
				<form id="formthree" method="POST" autocomplete="off">
					<div class="row">	
						<div class="col-md-12">
							<div class="form-group">
							<label>Please include the form as in Contact Tracing format now </label>						  
							</div>
							<div class="row">
								<div class="col-sm-6">
									<div class="form-group">
									<label>Incident #</label>
									<input type="text" class="form-control" name="incident_id" value="<?php echo isset($case_details['incident_id']) ? $case_details['incident_id'] : $incident_id; ?>" readonly>
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group">
										<label>Name</label>
										<input type="text" class="form-control" id="effect_name" 
										value="<?php echo isset($case_details['caller_fname']) ? $case_details['caller_fname'] : ''; ?>" readonly>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-12">
									<div class="table-widget">
										<div class="row">
											<h5><b>Identifying Exposed Contacts and Sites of Transmission</b></h5>
											<br/>
											<div class="col-md-8">
												<div class="card" style="border: 1px solid #000;padding: 10px 30px;border-radius:5px;">
												<div class="card-body">
													<h5 class="card-title"><b>Collect locations of potential exposure and transmission for each date below:</b></h5>		
													<ul style="list-style-type: disc;">
													<li>Addresses and phone numbers of work & high risk settings</li>
													<li>Dates and times visited (if available, time of arrival and length of stay)</li>
													<li>Remember to ask about stops at healthcare facilities, schools and child care centers</li>
													</ul>
												</div>
												</div>
											</div>
											<div class="col-md-4">
												<div class="card" style="border: 1px solid #000;padding: 10px 30px;border-radius:5px;">
												<div class="card-body">
													<h5 class="card-title"><b>Information about Contacts</b></h5>		
													<ul style="list-style-type: disc;">
													<li>Names and phone numbers of contacts</li>
													<li>Relation to case</li>
													<li>Are contacts symptomatic?</li>
													</ul>
												</div>
												</div>
											</div>
										</div>
										<br/>
									<p>* Need to add previous peoples info for the same location</p>
										<table class="table">
											<thead>
												<tr>
													<th width="5%">#</th>
													<th width="20%">Date</th>
													<th width="5%">Day</th>
													<th width="35%">Locations (With Times)</th>
													<th width="35%">Contacts</th>
												</tr>
											</thead>
											<tbody>
											<?php
											// SYMPTOM DATE
											$symptomDate = '';
											$startCheckDate = !empty($symptomDate) && $symptomDate != '0000-00-00' ?  date('Y-m-d', strtotime('-2 day', strtotime($symptomDate))) : "";
											
											for($i=0; $i<5; $i++){
												$j = $i-2;
												$currentExposureDate = "";
												if(!empty($crmexposure[0]['e_date'])){ $currentExposureDate = $crmexposure[0]['e_date']; } else {
													$currentExposureDate = $startCheckDate;
												}
											?>
											<tr>
												<td class="">

												</td>
												<td>
												<input class="form-control" type="text" value="<?php echo $currentExposureDate; ?>" name="e_date_<?php echo $i; ?>" id="e_date_<?php echo $i; ?>" <?php echo "readonly"; ?>></input>
												</td>
												<td><?php echo $j; ?></td>
												<td><textarea class="form-control" id="e_location_<?php echo $i;?>" name="e_location_<?php echo $i; ?>"><?php echo isset($case_daywise_details[$i]['location_info']) ? $case_daywise_details[$i]['location_info'] : '';?></textarea></td>
												<td><textarea class="form-control" id="e_contacts_<?php echo $i;?>" name="e_contacts_<?php echo $i; ?>"><?php echo isset($case_daywise_details[$i]['contacts']) ? $case_daywise_details[$i]['contacts'] : '';?></textarea></td>
											</tr>
											<?php 
												} ?>
											</tbody>
										</table>	
									</div>
								</div>							
							</div>
							<div class="row">
								<div class="col-sm-12">
									<div class="remarks-bg">
										Remarks
									</div>
								</div>							
							</div>
							<div class="row">
								<div class="col-sm-6">
									<div class="form-group">
										<label>Initial Case Type</label>
										<?php
											foreach ($initial_case_type as $key => $value) {
												$val = '';
												if(isset($case_details['initial_case'])){
													if($key == $case_details['initial_case'] && !empty($case_details['initial_case'])){
														$val = $value;
													}
												}
											}
											?>
											<input type="text" class="form-control" 
											value="<?php echo isset($val) ? $val : ''; ?>"
											id="r2_initial_case_type" readonly />
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group">
										<label>Comments</label>
										<textarea id="" class="form-control" name="comments"><?php echo isset($case_details['comments']) ? $case_details['comments'] : ''; ?></textarea>
									</div>
								</div>
							</div>
						</div>					
					</div>
					<div class="btn-widget">
						<button type="submit" class="submit-btn" id="tracing-save">Save & Continue</button>
					</div>
				</form>
			</div>
		</div>
	</div>
	<!--end contact tracing elements here-->
	
	<!--start contact tracing elements here-->
	<div class="final-call" id="final-call">
		<div class="common-all">
			<div class="caller-widget">
				<div class="body-widget">
				<span class="btn btn-primary btn-sm" id="back_three"><i class="fa fa-arrow-left"></i> Back</span>
					<h4>
						Finalization of Call 
						<p class="timerClock pull-right"><i class="fa fa-clock-o"></i> <span id="timeWatch"></span></p>
					</h4>
					<hr/>
				</div>	
				<form id="formfour" method="POST" autocomplete="off">		
					<div class="row">
						<div class="col-sm-6">
							<div class="form-group">
							<label>Incident #</label>
							<input type="text" class="form-control" name="incident_id" value="<?php echo isset($case_details['incident_id']) ? $case_details['incident_id'] : $incident_id; ?>" readonly>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<label>Initial Case Type</label>
								<?php
								foreach ($initial_case_type as $key => $value) {
									$val = '';
									if(isset($case_details['initial_case'])){
										if($key == $case_details['initial_case'] && !empty($case_details['initial_case'])){
											$val = $value;
										}
									}
								}
								?>
								<input type="text" class="form-control" 
								value="<?php echo isset($val) ? $val : ''; ?>"
								id="r3_initial_case_type" readonly />
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label>Disposition<span style="color:red">*</span></label>
								<?php 
								$extraop="display:none";
								$val='';
								if(isset($case_details['disposition'])){
									if(!empty($case_details['disposition'])){
										$val = $case_details['disposition'];
									}
								}
								if($val==1||$val==2||$val==3){
									$extraop="display:block";
								}
								?>
								<select name="disposition" id="disposition" required>
									<option value="">--Select Option--</option>
									<option value="1" <?php echo ($val==1)  ? 'selected="selected"' : '' ?>>Close-Confirmed Positive(Isolation)</option>
									<option value="2" <?php echo ($val==2)  ? 'selected="selected"' : '' ?>>Open-Getting Tested will callback with results</option>
									<option value="3" <?php echo ($val==3)  ? 'selected="selected"' : '' ?>>Open-Not Testing(Quarantine)</option>
									<option value="4" <?php echo ($val==4)  ? 'selected="selected"' : '' ?>>Close-Illness(Not Covid Related)</option>
									<option value="5" <?php echo ($val==5)  ? 'selected="selected"' : '' ?>>Others</option>
								</select>
							</div>
						</div>
						<div class="col-sm-6">
							
						<!-- </div>
					</div>
					<div class="row">
						<div class="col-sm-12"> -->
							<div class="form-group">
								<label>Please Choose the Correct Letter Type Below:</label>
								<?php 
								$val='';
								if(isset($case_details['correct_letter'])){
									if(!empty($case_details['correct_letter'])){
										$val = $case_details['correct_letter'];
									}
								}
								?>
								<select class="form-control" style="width:100%; height:100px" id="correct_letter" name="correct_letter" required="">
									<option value="1" <?php echo ($val==1)  ? 'selected="selected"' : '' ?>>PreK Close Contact of CLI</option>
									<option value="2" <?php echo ($val==2)  ? 'selected="selected"' : '' ?>>PreK Close Contact with Positive Case</option>
									<option value="3" <?php echo ($val==3)  ? 'selected="selected"' : '' ?>>Staff CLI County Letterhead_BB</option>
									<option value="4" <?php echo ($val==4)  ? 'selected="selected"' : '' ?>>Staff Close Contact with Positive Case</option>
									<option value="5" <?php echo ($val==5)  ? 'selected="selected"' : '' ?>>Staff Positive Case</option>
									<option value="6" <?php echo ($val==6)  ? 'selected="selected"' : '' ?>>Student CLI County Letterhead_BB</option>
									<option value="7" <?php echo ($val==7)  ? 'selected="selected"' : '' ?>>Student CLI County Letterhead_BB_Spanish</option>
									<option value="8" <?php echo ($val==8)  ? 'selected="selected"' : '' ?>>Student Close Contact with Positive Case County Letterhead_BB_Spanish</option>
									<option value="9" <?php echo ($val==9)  ? 'selected="selected"' : '' ?>>Student Close Contact with Positive Case_HH Contacts included County Letterhead_BB</option>
									<option value="10" <?php echo ($val==10)  ? 'selected="selected"' : '' ?>>Student Positive Case</option>
									<option value="11" <?php echo ($val==11)  ? 'selected="selected"' : '' ?>>Vaccinated Close Contact Letter Student</option>
									<option value="12" <?php echo ($val==12)  ? 'selected="selected"' : '' ?>>Vaccinated Close Contact Letter Student_Spanish</option>
									<option value="13" <?php echo ($val==13)  ? 'selected="selected"' : '' ?>>Vaccinated Close Contact Ltr Staff</option>
								</select>
							</div>
						</div>
					</div>
					<?php
						$od_other = 'display:none';
						if(isset($case_details['others_disposition'])){
							if(!empty($case_details['others_disposition'])){
								$od_other = 'display:block';
							}
						}?>
					<div class="row" <?php echo "style='".$od_other."'"?> id="disposition_expose">	
					<!-- <div class="row" style="display:none" id="disposition_expose">	 -->
						<div class="col-md-6">
							<div class="form-group">
							<label>Other Disposition</label>
							<textarea type="text" class="form-control" name="others_disposition" id="others_disposition"><?php echo isset($case_details['others_disposition']) ? $case_details['others_disposition'] : ''; ?></textarea>
							</div>
						</div>
					</div>
					<!-- <div class="row">
						<div class="col-sm-12">
							<div class="form-group">
								<label>Attach Correct Letter to Email:</label>
								<div class="email-link">
									<a href="#">
										PreK Close Contact of CLI
									</a>
									<a href="#">
										PreK Close Contact with Positive Case
									</a>
									<a href="#">
										Staff CLI County Letterhead with Instuctions (When sent home)
									</a>
									<a href="#">
										Staff Close Contact with Positive Case
									</a>
									<a href="#">
										Staff Positive Case
									</a>
									<a href="#">
										Student CLI County Letterhead for Parent (When sent home)
									</a>
									<a href="#">
										Spanish Student CLI County Letterhead for Parent (When sent home)
									</a>
									<a href="#">
										Spanish Student Close Contact with a Positve Case
									</a>
									<a href="#">
										Student Close Contact with a Positive Case
									</a>
									<a href="#">
										Student Positive Case
									</a>
									<a href="#">
										Vaccinated Student Close Contact with a Positive Case
									</a>
									<a href="#">
										Vaccinated Staff Close Contact with Positive Case
									</a>
								</div>
							</div>
						</div>				
					</div> -->
					<div class="row">
						<div class="col-sm-6">
							<div class="form-group">
								<label>Caller's Final Case Type:</label>
								<?php 
								$val='';
								if(isset($case_details['final_case_type'])){
									if(!empty($case_details['final_case_type'])){
										$val = $case_details['final_case_type'];
									}
								}
								?>
								<select name="final_case_type" id="final_case_type">
									<option value="">--Select Final Case Type--</option>
									<option value="1" <?php echo ($val==1)  ? 'selected="selected"' : '' ?>>Quarantine Illness ( Close Contact )</option>
									<option value="2" <?php echo ($val==2)  ? 'selected="selected"' : '' ?>>Confirm Positive ( Isolation )</option>
									<option value="3" <?php echo ($val==3)  ? 'selected="selected"' : '' ?>>Getting Tested ( Will Callback with Results )</option>
									<option value="4" <?php echo ($val==4)  ? 'selected="selected"' : '' ?>>Not Testing - ( Quarantine )</option>
									<option value="5" <?php echo ($val==5)  ? 'selected="selected"' : '' ?>>Closed Case</option>
									<option value="6" <?php echo ($val==6)  ? 'selected="selected"' : '' ?>>Others</option>							
								</select>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<label>Staff/Student May Return to Work/School On:</label>
								<input type="date" class="form-control" name="return_date" value="<?php echo isset($case_details['return_date']) ? $case_details['return_date'] : ''; ?>">
							</div>
						</div>
					</div>
					<?php
						$fd_other = 'display:none';
						if(isset($case_details['others_final_case_type'])){
							if(!empty($case_details['others_final_case_type'])){
								$fd_other = 'display:block';
							}
						}?>
					<div class="row" <?php echo "style='".$fd_other."'"?> id="final_case_type_expose">
						<div class="col-md-6">
							<div class="form-group">
							<label>Other Final Case Type</label>
							<textarea type="text" class="form-control" name="others_final_case_type" id="others_final_case_type"><?php echo isset($case_details['others_final_case_type']) ? $case_details['others_final_case_type'] : ''; ?></textarea>
							</div>
						</div>
					</div>
					<div class="row " id="extra_data_field" style="<?php echo $extraop;?>">
						<div class="col-sm-6">
							<div class="form-group">
								<label>Student Date Of Birth:</label>
								<input type="date" class="form-control" name="date_of_birth" value="<?php echo isset($case_details['dob']) ? $case_details['dob'] : ''; ?>">
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<label>Parent Name</label>
								<input type="text" class="form-control" name="parent_name" value="<?php echo isset($case_details['parent_name']) ? $case_details['parent_name'] : ''; ?>">
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<label>Address</label>
								<input type="textarea" class="form-control" name="user_address" value="<?php echo isset($case_details['user_address']) ? $case_details['user_address'] : ''; ?>">
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<label>Please Specify Symptoms:</label>
								<?php 
								$val='';
								if(isset($case_details['specify_symtoms'])){
									if(!empty($case_details['specify_symtoms'])){
										$val = $case_details['specify_symtoms'];
									}
								}
								?>
								<textarea id="specify_symptoms" name="specify_symptoms" class="form-control"><?php echo $case_details['specify_symtoms'];?></textarea>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<label>Date Last at School/Childcare :</label>
								<input type="date" class="form-control" name="last_date_school" value="<?php echo isset($case_details['last_date_of_school']) ? $case_details['last_date_of_school'] : ''; ?>">
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<label>Name of Facility:</label>
								<input type="text" class="form-control" name="name_of_facility" value="<?php echo isset($case_details['name_of_facility']) ? $case_details['name_of_facility'] : ''; ?>">
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<label>Contact Person:</label>
								<input type="text" class="form-control" name="contact_person" value="<?php echo isset($case_details['facility_contact_person']) ? $case_details['facility_contact_person'] : ''; ?>">
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<label>Facility Contact Number:</label>
								<input type="text" class="form-control" pattern="^\d{9,10}$" onkeypress="return isNumber(event)"  name="facility_contact_no" value="<?php echo isset($case_details['facility_contact_no']) ? $case_details['facility_contact_no'] : ''; ?>">
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<label>Facility Contact Email:</label>
								<input type="email" class="form-control" name="facility_contact_email" value="<?php echo isset($case_details['facility_contact_mail']) ? $case_details['facility_contact_mail'] : ''; ?>">
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<label>Facility Address:</label>
								<input type="textarea" class="form-control" name="facility_address" value="<?php echo isset($case_details['facility_address']) ? $case_details['facility_address'] : ''; ?>">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-12">
							<div class="form-group">
								<small>
									*Local and State Health Dept. Contacts and Instructions to Follow
								</small>
							</div>
						</div>
					</div>
					<div class="btn-widget">
						<button type="submit" class="submit-btn" id="map-next">Submit</button>
					</div>
				</form>
			</div>
		</div>
	</div>
	<!--end contact tracing elements here-->
	
	<!--start contact tracing elements here-->
	<!-- <div class="map-area" id="map-area">
		<div class="common-all">
			<div class="caller-widget">
				<div class="body-widget">
					<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d471218.38560188503!2d88.04952746944407!3d22.676385755547642!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x39f882db4908f667%3A0x43e330e68f6c2cbc!2sKolkata%2C%20West%20Bengal!5e0!3m2!1sen!2sin!4v1634659303086!5m2!1sen!2sin" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
				</div>
			</div>
		</div>
	</div> -->
	
</div>
<section>
</div>


