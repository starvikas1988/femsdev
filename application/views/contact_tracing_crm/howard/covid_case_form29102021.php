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
									<input type="date" class="form-control"  placeholder="" value="<?php echo $date_of_call ?>"  readonly>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
									<label>Incident #</label>
									<input type="text" class="form-control" name="incident_id" value="<?php echo $incident_id; ?>" readonly>
									</div>
								</div>
								<div class="col-md-6">
										<div class="form-group">
										<label>Initial Case Type:</label>
										<select name="initial_case" id="initial_case_type">
											<option value="1">Confirmed Positive</option>
											<option value="2">Presumed Positive</option>
											<option value="3">Close Contact</option>
											<option value="4">Proximity</option>
											<option value="5">Illness (Non-COVID with no close contact to positive Case)</option>
										</select>
										</div>
									</div>
											
							</div>
							<div class="common-top">
								<div class="row">
								<div class="col-md-12">
									<div class="form-group">
									<label><i class="fa fa-info-circle"></i> Caller Information & Reason for Call</label>
									<textarea type="text" class="form-control" name="caller_info" placeholder=""></textarea>
									</div>
								</div>
								</div>
							</div>
							<div class="row">	
								<div class="col-md-6">
									<div class="form-group">
									<label><i class="fa fa-user"></i> Caller's First Name<span style="color:red">*</span></label>
									<input type="text" name="caller_fname" class="form-control" id="c_fname" required>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
									<label>Caller's Last Name</label>
									<input type="text" name="caller_lname" class="form-control" id="c_lname">
									</div>
								</div>
							</div>
							<div class="row">	
								<div class="col-md-6">
									<div class="form-group">
									<label><i class="fa fa-graduation-cap"></i> Student's First Name</label>
									<input type="text" name="student_fname" class="form-control" id="">
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
									<label>Student Last Name</label>
									<input type="text" name="student_lname" class="form-control" id="">
									</div>
								</div>
							</div>
							<div class="row">	
								<div class="col-md-6">
									<div class="form-group">
									<label><i class="fa fa-phone"></i> Phone<span style="color:red">*</span></label>
									<input type="text" name="callers_phone" pattern="^\d{9,10}$" onkeypress="return isNumber(event)" class="form-control" id="" required>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
									<label>Secondary Phone</label>
									<input type="text" name="secondary_phone"  pattern="^\d{9,10}$" onkeypress="return isNumber(event)" class="form-control" id="">
									</div>
								</div>
							</div>
							<div class="row">	
								<div class="col-md-6">
									<div class="form-group">
									<label>Title:</label>
									<input type="text" name="title" class="form-control" id="">
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
										foreach ($school_list as $key => $value) { ?>
											<option value=<?php echo $value['id']; ?>><?php echo $value['name']; ?></option>
										<?php } ?>
									</select>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
									<label>Grades</label>
									<input type="text" name="grades" class="form-control" id="grades" value="">
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
									<label>Address</label>
									<input type="text" name="address" class="form-control" id="address" value="">
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
									<label>Schools 2</label>
									<select name="schools2" id="school2">
										<option value="">--Select School--</option>
										<?php
										foreach ($school_list as $key => $value) { ?>
											<option value=<?php echo $value['id']; ?>><?php echo $value['name']; ?></option>
										<?php } ?>
									</select>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
									<label>Grades</label>
									<input type="text" name="grades2" class="form-control" id="grades2" value="">
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
									<label>Address</label>
									<input type="text" name="address2" class="form-control" id="address2" value="">
									</div>
								</div>
								<!-- <div class="col-md-6">
									<div class="form-group">
									<label>County</label>
									<input type="text" name="county" class="form-control" id="county" value="">
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
									<label>City</label>
									<input type="text" name="city" class="form-control" id="city" value="">
									</div>
								</div> -->
							</div>
							<div class="row">	
								<div class="col-md-6">
									<div class="form-group">
									<label>Teacher <span style="color:gray;font-size:13px">(Confirm Spelling)</span></label>
									<input type="text" name="teacher" class="form-control" id="">
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
									<label>Assigned Room # <span style="color:gray;font-size:13px">(If Applicable)</span></label>
									<input type="text" name="assigned_room" class="form-control" id="">
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
								<div class="col-md-6">
									<div class="form-group">
										<select name="class_1" class="location_attended">
										<option value="0">None</option>
											<option value="1">Art Room</option>
											<option value="2">Basement</option>
											<option value="3">Basketball Court</option>
											<option value="4">Board Office</option>
											<option value="5">Bus</option>
											<option value="6">Cafeteria</option>
											<option value="7">Classroom</option>
											<option value="8">Football Field</option>
											<option value="9">Gym</option>
											<option value="10">Hallway</option>
											<option value="11">Home</option>
											<option value="12">Janitor's Closet</option>
											<option value="13">Lounge Area</option>
											<option value="14">Music Room</option>
											<option value="15">Nurse's Office</option>
											<option value="16">Office</option>
											<option value="17">Playground</option>
											<option value="18">Woodshop</option>
											<option value="19">Other</option>
										</select>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<select name="class_2" class="location_attended">
										<option value="0">None</option>
											<option value="1">Art Room</option>
											<option value="2">Basement</option>
											<option value="3">Basketball Court</option>
											<option value="4">Board Office</option>
											<option value="5">Bus</option>
											<option value="6">Cafeteria</option>
											<option value="7">Classroom</option>
											<option value="8">Football Field</option>
											<option value="9">Gym</option>
											<option value="10">Hallway</option>
											<option value="11">Home</option>
											<option value="12">Janitor's Closet</option>
											<option value="13">Lounge Area</option>
											<option value="14">Music Room</option>
											<option value="15">Nurse's Office</option>
											<option value="16">Office</option>
											<option value="17">Playground</option>
											<option value="18">Woodshop</option>
											<option value="19">Other</option>
										</select>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<select name="class_3" class="location_attended">
										<option value="0">None</option>
											<option value="1">Art Room</option>
											<option value="2">Basement</option>
											<option value="3">Basketball Court</option>
											<option value="4">Board Office</option>
											<option value="5">Bus</option>
											<option value="6">Cafeteria</option>
											<option value="7">Classroom</option>
											<option value="8">Football Field</option>
											<option value="9">Gym</option>
											<option value="10">Hallway</option>
											<option value="11">Home</option>
											<option value="12">Janitor's Closet</option>
											<option value="13">Lounge Area</option>
											<option value="14">Music Room</option>
											<option value="15">Nurse's Office</option>
											<option value="16">Office</option>
											<option value="17">Playground</option>
											<option value="18">Woodshop</option>
											<option value="19">Other</option>
										</select>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<select name="class_4" class="location_attended">
											<option value="0">None</option>
											<option value="1">Art Room</option>
											<option value="2">Basement</option>
											<option value="3">Basketball Court</option>
											<option value="4">Board Office</option>
											<option value="5">Bus</option>
											<option value="6">Cafeteria</option>
											<option value="7">Classroom</option>
											<option value="8">Football Field</option>
											<option value="9">Gym</option>
											<option value="10">Hallway</option>
											<option value="11">Home</option>
											<option value="12">Janitor's Closet</option>
											<option value="13">Lounge Area</option>
											<option value="14">Music Room</option>
											<option value="15">Nurse's Office</option>
											<option value="16">Office</option>
											<option value="17">Playground</option>
											<option value="18">Woodshop</option>
											<option value="19">Other</option>
										</select>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<select name="class_5" class="location_attended">
											<option value="0">None</option>
											<option value="1">Art Room</option>
											<option value="2">Basement</option>
											<option value="3">Basketball Court</option>
											<option value="4">Board Office</option>
											<option value="5">Bus</option>
											<option value="6">Cafeteria</option>
											<option value="7">Classroom</option>
											<option value="8">Football Field</option>
											<option value="9">Gym</option>
											<option value="10">Hallway</option>
											<option value="11">Home</option>
											<option value="12">Janitor's Closet</option>
											<option value="13">Lounge Area</option>
											<option value="14">Music Room</option>
											<option value="15">Nurse's Office</option>
											<option value="16">Office</option>
											<option value="17">Playground</option>
											<option value="18">Woodshop</option>
											<option value="19">Other</option>
										</select>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<select name="class_6" class="location_attended">
											<option value="0">None</option>
											<option value="1">Art Room</option>
											<option value="2">Basement</option>
											<option value="3">Basketball Court</option>
											<option value="4">Board Office</option>
											<option value="5">Bus</option>
											<option value="6">Cafeteria</option>
											<option value="7">Classroom</option>
											<option value="8">Football Field</option>
											<option value="9">Gym</option>
											<option value="10">Hallway</option>
											<option value="11">Home</option>
											<option value="12">Janitor's Closet</option>
											<option value="13">Lounge Area</option>
											<option value="14">Music Room</option>
											<option value="15">Nurse's Office</option>
											<option value="16">Office</option>
											<option value="17">Playground</option>
											<option value="18">Woodshop</option>
											<option value="19">Other</option>
										</select>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<select name="class_7" class="location_attended">
											<option value="0">None</option>
											<option value="1">Art Room</option>
											<option value="2">Basement</option>
											<option value="3">Basketball Court</option>
											<option value="4">Board Office</option>
											<option value="5">Bus</option>
											<option value="6">Cafeteria</option>
											<option value="7">Classroom</option>
											<option value="8">Football Field</option>
											<option value="9">Gym</option>
											<option value="10">Hallway</option>
											<option value="11">Home</option>
											<option value="12">Janitor's Closet</option>
											<option value="13">Lounge Area</option>
											<option value="14">Music Room</option>
											<option value="15">Nurse's Office</option>
											<option value="16">Office</option>
											<option value="17">Playground</option>
											<option value="18">Woodshop</option>
											<option value="19">Other</option>
										</select>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<select name="class_8" class="location_attended">
											<option value="0">None</option>
											<option value="1">Art Room</option>
											<option value="2">Basement</option>
											<option value="3">Basketball Court</option>
											<option value="4">Board Office</option>
											<option value="5">Bus</option>
											<option value="6">Cafeteria</option>
											<option value="7">Classroom</option>
											<option value="8">Football Field</option>
											<option value="9">Gym</option>
											<option value="10">Hallway</option>
											<option value="11">Home</option>
											<option value="12">Janitor's Closet</option>
											<option value="13">Lounge Area</option>
											<option value="14">Music Room</option>
											<option value="15">Nurse's Office</option>
											<option value="16">Office</option>
											<option value="17">Playground</option>
											<option value="18">Woodshop</option>
											<option value="19">Other</option>
										</select>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<select name="class_9" class="location_attended">
											<option value="0">None</option>
											<option value="1">Art Room</option>
											<option value="2">Basement</option>
											<option value="3">Basketball Court</option>
											<option value="4">Board Office</option>
											<option value="5">Bus</option>
											<option value="6">Cafeteria</option>
											<option value="7">Classroom</option>
											<option value="8">Football Field</option>
											<option value="9">Gym</option>
											<option value="10">Hallway</option>
											<option value="11">Home</option>
											<option value="12">Janitor's Closet</option>
											<option value="13">Lounge Area</option>
											<option value="14">Music Room</option>
											<option value="15">Nurse's Office</option>
											<option value="16">Office</option>
											<option value="17">Playground</option>
											<option value="18">Woodshop</option>
											<option value="19">Other</option>
										</select>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<select name="class_10" class="location_attended">
											<option value="0">None</option>
											<option value="1">Art Room</option>
											<option value="2">Basement</option>
											<option value="3">Basketball Court</option>
											<option value="4">Board Office</option>
											<option value="5">Bus</option>
											<option value="6">Cafeteria</option>
											<option value="7">Classroom</option>
											<option value="8">Football Field</option>
											<option value="9">Gym</option>
											<option value="10">Hallway</option>
											<option value="11">Home</option>
											<option value="12">Janitor's Closet</option>
											<option value="13">Lounge Area</option>
											<option value="14">Music Room</option>
											<option value="15">Nurse's Office</option>
											<option value="16">Office</option>
											<option value="17">Playground</option>
											<option value="18">Woodshop</option>
											<option value="19">Other</option>
										</select>
									</div>
								</div>
							</div>
							<div class="row" style="display:none" id="others_expose">	
								<div class="col-md-6">
									<div class="form-group">
									<label>Others</label>
									<textarea type="text" class="form-control" name="others_location" id="others_val"></textarea>
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
							<input type="text" class="form-control" name="incident_id" value="<?php echo $incident_id; ?>" readonly>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>Type of Case</label>
								<select name="type_of_case" id="type_of_case" required>
									<option value="1">Confirmed Positive</option>
									<option value="2">Presumed Positive</option>
									<option value="3">Close Contact</option>
									<option value="4">Proximity</option>
									<option value="5">Illness (Non-COVID with no close contact to positive Case)</option>
								</select>
							</div>
						</div>
					</div>
					<div class="row">	
						<div class="col-md-6">
							<div class="form-group">
								<label>Has Caller Been Diagnosed as Positive?</label>
								<select name="diagnosed_as_positive" id="diagnosed_yes">
									<option value="1">Yes</option>
									<option value="2">No</option>
									<option value="3">Awaiting Results</option>
								</select>
							</div>
						</div>
						<div class="col-md-6" id="diagnosed_date" style="diaplay:block">
							<div class="form-group">
							<label>Diagnosed Date</label>
							<input type="date" class="form-control" name="diagnosed_date" id="" value="">
							</div>
						</div>
					</div>
				    <div class="row">
						<div class="col-md-6">
							<div class="form-group">
							<label>Child's School 1</label>
							<input type="text" class="form-control" name="callers_school" id="childs_school" value="" readonly>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
							<label>Caller's Work Location or Child's School Location </label>
							<input type="text" class="form-control" name="callers_work_location" id="school_location" value="" readonly>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
							<label>Child's School 2</label>
							<input type="text" class="form-control" id="childs_school2" value="" readonly>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
							<label>Caller's Work Location or Child's School Location </label>
							<input type="text" class="form-control" id="school_location2" value="" readonly>
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
							<input type="text" name="manager_name" class="form-control" id="">
							</div>
						</div>					
					</div>
					<div class="row">	
						<div class="col-md-12">
							<div class="form-group">
							<label>May I please ask for the details of where you entered and exited the building for cleaning protocol? (Add notes in documtentation for more than one entrance/exit)</label>						  
								<select name="entrance_and_exit" id="front_door">
									<option value="1">Front Door</option>
									<option value="2">Back Door</option>
									<option value="3">Side Entrance</option>
									<option value="4">Others</option>
								</select>
							</div>
						</div>
					</div>
					<div class="row" style="display:none" id="others_door">	
						<div class="col-md-6">
							<div class="form-group">
							<label>Others Entrance/Exit</label>
							<textarea type="text" class="form-control" name="doors_other" id="doors_other"></textarea>
							</div>
						</div>
					</div>			
					<div class="row">	
	
						<div class="col-md-12">
							<div class="form-group">
							<label>Did you have Close Contact with any other members of the staff or students?  What I mean by this is were you within 6 feet, for a period of 15 minutes or more over a 24 hour period of time?</label>					  
								<select name="any_close_contact" id="close_connect">
									<option value="1">Yes</option>
									<option value="2">No</option>
									<option value="3">Other</option>
								</select>
							</div>
						</div>
					</div>
					<div class="row" style="display:none" id="others_connect">	
						<div class="col-md-6">
							<div class="form-group">
							<label>Others Contact</label>
							<textarea type="text" class="form-control" name="connect_others" id="connect_others"></textarea>
							</div>
						</div>
					</div>
					<div class="row">	
						<div class="col-md-6">
							<div class="form-group">
								<label>Have You been fully vaccinated</label>
								<select name="fully_vaccinated" id="fully_vaccinated">
									<option value="1">Yes</option>
									<option value="2">No</option>
								</select>
							</div>
						</div>
						<div class="col-md-6" id="fully_vaccinated_date" style="display:block">
							<div class="form-group">
							<label>Mark a Date</label>
							<input type="date" name="fully_vaccinated_date" class="form-control" id="fully_vaccinated_date_val">
							</div>
						</div>					
					</div>
					<div class="row">	
						<div class="col-md-6">
							<div class="form-group">
								<label>Has it been 2 weeks since your Final shot</label>
								<input type="date" name="final_shot" class="form-control" id="">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>Date of 1st Sypmtom</label>
								<input type="text" name="date_first_sym" class="form-control" id="date_first_sym" placeholder="yyyy-mm-dd">
							</div>
						</div>					
					</div>
					<div class="row">	
						<div class="col-md-6">
							<div class="form-group">
							<label>Document all information below:</label>
							<textarea type="text" name="more_information_about_contact" class="form-control" id=""></textarea>
							</div>
						</div>	
						<div class="col-md-6">
							<div class="form-group">
								<label>And what was the date you were last at the buliding please Or on The Bus ?</label>
								<input type="date" name="last_date_in_building" class="form-control" id="">
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
									<input type="text" class="form-control" name="incident_id" value="<?php echo $incident_id; ?>" readonly>
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group">
										<label>Name</label>
										<input type="text" class="form-control" id="effect_name" value="" readonly>
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
												<td><textarea class="form-control" id="e_location_<?php echo $i; ?>" name="e_location_<?php echo $i; ?>"></textarea></td>
												<td><textarea class="form-control" id="e_contacts_<?php echo $i; ?>" name="e_contacts_<?php echo $i; ?>"></textarea></td>
											</tr>
											<?php } ?>
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
										<label>Disposition</label>
										<select name="disposition" id="disposition">
											<option value="1">Close-Confirmed Positive(Isolation)</option>
											<option value="2">Open-Getting Tested will callback with results</option>
											<option value="3">Open-Not Testing(Quarantine)</option>
											<option value="4">Close-Illness(Not Covid Related)</option>
											<option value="5">Other</option>
										</select>
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group">
										<label>Comments</label>
										<textarea id="" class="form-control" name="comments"></textarea>
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
							<input type="text" class="form-control" name="incident_id" value="<?php echo $incident_id; ?>" readonly>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<label>Caller's Initial Case Type:</label>
									<select name="type_of_case" id="r_type_of_case">
										<option value="1">A. Confirmed COVID-19 diagnosis</option>
										<option value="2">B. Proximate exposure to someone diagnosis with COVID-19 </option>
										<option value="3">C. Second hand exposure to someone diagnosis with COVID-19</option>
										<option value="4">D. Caller illness</option>
										<option value="5">E. Third party exposure</option>
									</select>
								<!-- <select name="initial_case" id="r_initial_case_type" readonly>
									<option value="1">Confirmed Positive</option>
									<option value="2">Presumed Positive</option>
									<option value="3">Close Contact</option>
									<option value="4">Proximity</option>
									<option value="5">Illness (Non-COVID with no close contact to positive Case)</option>
								</select> -->
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label>Disposition</label>
										<select name="disposition" id="r_disposition">
											<option value="1">Close-Confirmed Positive(Isolation)</option>
											<option value="2">Open-Getting Tested will callback with results</option>
											<option value="3">Open-Not Testing(Quarantine)</option>
											<option value="4">Close-Illness(Not Covid Related)</option>
											<option value="5">Other</option>
										</select>
							</div>
							<!-- <div class="form-group">
								<label>Type of Case</label>
								<select name="type_of_case" id="r_type_of_case">
									<option value="1">A. Confirmed COVID-19 diagnosis</option>
									<option value="2">B. Proximate exposure to someone diagnosis with COVID-19 </option>
									<option value="3">C. Second hand exposure to someone diagnosis with COVID-19</option>
									<option value="4">D. Caller illness</option>
									<option value="5">E. Third party exposure</option>
								</select>
							</div> -->
						</div>
						<div class="col-sm-6">
							
						</div>
					</div>
					<div class="row">
						<div class="col-sm-12">
							<div class="form-group">
								<label>Please Choose the Correct Letter Type Below:</label>
								<select class="form-control" style="width:100%; height:100px" id="correct_letter" name="correct_letter[]" multiple required="">
									<option value="1">PreK Close Contact of CLI</option>
									<option value="2">PreK Close Contact with Positive Case</option>
									<option value="3">Staff CLI County Letterhead_BB</option>
									<option value="4">Staff Close Contact with Positive Case</option>
									<option value="5">Staff Positive Case</option>
									<option value="6">Student CLI County Letterhead_BB</option>
									<option value="7">Student CLI County Letterhead_BB_Spanish</option>
									<option value="8">Student Close Contact with Positive Case County Letterhead_BB_Spanish</option>
									<option value="9">Student Close Contact with Positive Case_HH Contacts included County Letterhead_BB</option>
									<option value="10">Student Positive Case</option>
									<option value="11">Vaccinated Close Contact Letter Student</option>
									<option value="12">Vaccinated Close Contact Letter Student_Spanish</option>
									<option value="13">Vaccinated Close Contact Ltr Staff</option>
								</select>
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
								<select name="final_case_type">
									<option value="1">Close Confirmed Positive (Isolation)</option>
									<option value="2">Open Getting Tested-Will Call Back With Results</option>
									<option value="3">Open Not Testing-(Quarantine)</option>
									<option value="4">Close Illness (Not Covid Related)</option>
									<option value="5">Pending</option>
									<option value="6">Other</option>							
								</select>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<label>Staff/Student May Return to Work/School On:</label>
								<input type="date" class="form-control" name="return_date">
							</div>
						</div>
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


