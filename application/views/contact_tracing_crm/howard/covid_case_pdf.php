<style>
	body {
		background: #ffffff;
		font-family: "apercu", sans-serif, "Helvetica Neue", Helvetica, Arial;
		font-size: 13px;
		line-height: 1.4;
		color: #67686a;
		/*#6a6c6f*/
	}

	.text-center {
		text-align: center;
	}

	.form-title {
		font-size: 16px;
	}

	th {
		font-size: 12px;
	}

	td {
		font-size: 10px;
	}
</style>
<?php
$close_contact=array("1"=>"Yes", "2"=>"No", "3"=>"Other");
$type_of_case=array(
	"1" => "Confirmed Positive",
	"2" => "Presumed Positive",
	"3" => "Close Contact",
	"4" => "Proximity",
	"5" => "Illness (Non-COVID with no close contact to positive Case)"
);
$diagnosed_as_positive=array(
	"1"=>"Yes",
	"0"=>"No"
);
$class_name=array(
	"0" => "None",
	"1" => "Art Room",
	"2" => "Basement",
	"3" => "Basketball Court",
	"4" => "Board Office",
	"5" => "Bus",
	"6" => "Cafeteria",
	"7" => "Classroom",
	"8" => "Football Field",
	"9" => "Gym",
	"10" => "Hallway",
	"11" => "Home",
	"12" => "Janitor's Closet",
	"13" => "Lounge Area",
	"14" => "Music Room",
	"15" => "Nurse's Office",
	"16" => "Office",
	"17" => "Playground",
	"18" => "Woodshop",
	"19" => "Other"
);
$entrance_exit=array("1"=>"Front Door", "2"=>"Back Door", "3"=>"Side Intrance");

?>
<div class="wrap">
	<section class="app-content">
		<div class="simple-page-wrap" style="width:100%;">
			<div class="simple-page-form">
				<h4 class="form-title m-b-xl text-center"><b><u>CONTACT TRACING - HOWARD</u></b></h4>


				<h6 class="form-title m-b-xl text-left">
					<b><?php echo $crm_details['incident_id']; ?> - <?php echo $crm_details['caller_fname'] . " " . $crm_details['caller_lname']; ?>
						<br />Case Status : <?php echo $crm_details['case_status'] == '0' ? '<span style="color:green">Closed</span>' : '<span style="color:red">Open</span>'; ?>
					</b><br />
				</h6>
				<div style="padding:0px 2px">

					<div class="row">
						<div class="col-md-12">
							<table id="recordsTable" style="width:100%;border:1px solid #68696b;border-collapse: collapse;">
								<tr>
									<th style="background-color:#f3f3f3;border: 1px solid #68696b;padding:2px 10px;text-align:left;width:20%">CASE ID</th>
									<th style="border: 1px solid #68696b;padding:2px 10px;text-align:left;font-size:11px;"><?php echo $crm_details['incident_id']; ?></th>
								</tr>
								<tr>
									<th style="background-color:#f3f3f3;border: 1px solid #68696b;padding:2px 10px;text-align:left;width:20%">Name</th>
									<th style="border: 1px solid #68696b;padding:2px 10px;text-align:left;font-size:11px;"><?php echo $crm_details['caller_fname'] . " " . $crm_details['caller_lname']; ?></th>
								</tr>
								<tr>
									<th style="background-color:#f3f3f3;border: 1px solid #68696b;padding:2px 10px;text-align:left;width:20%">Call Date</th>
									<th style="border: 1px solid #68696b;padding:2px 10px;text-align:left;font-size:11px;">
										<?php echo !empty($crm_details['date_of_call']) ? $crm_details['date_of_call'] : "-"; ?></th>
								</tr>
								<tr>
									<th style="background-color:#f3f3f3;border: 1px solid #68696b;padding:2px 10px;text-align:left;width:20%">Phone</th>
									<th style="border: 1px solid #68696b;padding:2px 10px;text-align:left;font-size:11px;">
										<?php echo !empty($crm_details['caller_phone']) ? $crm_details['caller_phone'] : "-"; ?></th>
								</tr>
								<tr>
									<th style="background-color:#f3f3f3;border: 1px solid #68696b;padding:2px 10px;text-align:left;width:20%">Secondary Phone</th>
									<th style="border: 1px solid #68696b;padding:2px 10px;text-align:left;font-size:11px;">
										<?php echo !empty($crm_details['secondary_phone']) ? $crm_details['secondary_phone'] : "-"; ?></th>
								</tr>
								<tr>
									<th style="background-color:#f3f3f3;border: 1px solid #68696b;padding:2px 10px;text-align:left;width:20%">Work Location/Dept</th>
									<th style="border: 1px solid #68696b;padding:2px 10px;text-align:left;font-size:11px;">
										<?php echo !empty($crm_details['callers_work_location']) ? $crm_details['callers_work_location'] : "-"; ?></th>
								</tr>
								<tr>
									<th style="background-color:#f3f3f3;border: 1px solid #68696b;padding:2px 10px;text-align:left;width:20%">Teacher</th>
									<th style="border: 1px solid #68696b;padding:2px 10px;text-align:left;font-size:11px;">
										<?php echo !empty($crm_details['teacher']) ? $crm_details['teacher'] : "-"; ?></th>
								</tr>
								<tr>
									<th style="background-color:#f3f3f3;border: 1px solid #68696b;padding:2px 10px;text-align:left;width:20%">Assigned Room</th>
									<th style="border: 1px solid #68696b;padding:2px 10px;text-align:left;font-size:11px;">
										<?php echo !empty($crm_details['assigned_room']) ? $crm_details['assigned_room'] : "-"; ?></th>
								</tr>
							</table>
						</div>
					</div>

					<h4 class="form-title m-b-xl text-left"><b><u></u></b></h4>
					<?php if($crm_details['schools']!=""){
						//$school_list = $this->Common_model->get_query_result_array($qSql);
						?>
						<div class="row">
							<div class="col-md-12">
								<table id="recordsTable" style="width:100%;border:1px solid #68696b;border-collapse: collapse;">
									<tr style="background-color:#ccc">
										<th style="border: 1px solid #68696b;padding:5px 10px;text-align:center;width:100%;font-size:15px" colspan="2">School 1</th>
									</tr>
									<tr>
										<th style="background-color:#f3f3f3;border: 1px solid #68696b;padding:2px 10px;text-align:left;">Name</th>
										<th style="border: 1px solid #68696b;padding:2px 10px;text-align:left;font-size:11px;">
										<?php
										foreach($school_list as $key=>$school_name){
											if($school_name['id']===$crm_details['schools']){
												echo $school_name['name'];
											}
										}
										?>
										</th>
									</tr>
									<tr>
										<th style="background-color:#f3f3f3;border: 1px solid #68696b;padding:2px 10px;text-align:left;">Grades</th>
										<th style="border: 1px solid #68696b;padding:2px 10px;text-align:left;font-size:11px;">
											<?php echo !empty($crm_details['grades']) ? $crm_details['grades'] : "-"; ?></th>
									</tr>
									<tr>
										<th style="background-color:#f3f3f3;border: 1px solid #68696b;padding:2px 10px;text-align:left;">Address</th>
										<th style="border: 1px solid #68696b;padding:2px 10px;text-align:left;font-size:11px;">
											<?php echo !empty($crm_details['address']) ? $crm_details['address'] : "-"; ?></th>
									</tr>
								</table>
							</div>
						</div>
					<?php }?>

					<h4 class="form-title m-b-xl text-left"><b><u></u></b></h4>

					<?php if($crm_details['school2']!=""){
						//var_dump($school_list);
						// $school2=$crm_details['school2'];
						// $qSql1="SELECT * FROM contact_tracing_howard_schools WHERE id=$school2";
						// $school_list2 = $this->Common_model->get_query_result_array($qSql1);
						?>
						<div class="row">
							<div class="col-md-12">
								<table id="recordsTable" style="width:100%;border:1px solid #68696b;border-collapse: collapse;">
									<tr style="background-color:#ccc">
										<th style="border: 1px solid #68696b;padding:5px 10px;text-align:center;width:100%;font-size:15px" colspan="2">School 2</th>
									</tr>
									<tr>
										<th style="background-color:#f3f3f3;border: 1px solid #68696b;padding:2px 10px;text-align:left;">Name</th>
										<th style="border: 1px solid #68696b;padding:2px 10px;text-align:left;font-size:11px;">
										<?php
										foreach($school_list as $key=>$school_name){
											//var_dump($school_name['name']);
											if($school_name['id']===$crm_details['school2']){
												echo $school_name['name'];
											}
										}
										?>
											</th>
									</tr>
									<tr>
										<th style="background-color:#f3f3f3;border: 1px solid #68696b;padding:2px 10px;text-align:left;">Grades</th>
										<th style="border: 1px solid #68696b;padding:2px 10px;text-align:left;font-size:11px;">
											<?php echo !empty($crm_details['grades2']) ? $crm_details['grades2'] : "-"; ?></th>
									</tr>
									<tr>
										<th style="background-color:#f3f3f3;border: 1px solid #68696b;padding:2px 10px;text-align:left;">Address</th>
										<th style="border: 1px solid #68696b;padding:2px 10px;text-align:left;font-size:11px;">
											<?php echo !empty($crm_details['address2']) ? $crm_details['address2'] : "-"; ?></th>
									</tr>
								</table>
							</div>
						</div>
					<?php }?>

					<h4 class="form-title m-b-xl text-left"><b><u></u></b></h4>

					<?php if($crm_details['class_1']!="" || $crm_details['class_2']!="" || $crm_details['class_3']!="" || $crm_details['class_4']!="" || $crm_details['class_5']!="" || $crm_details['class_6']!=""
					|| $crm_details['class_7']!="" || $crm_details['class_8']!="" || $crm_details['class_9']!="" || $crm_details['class_10']!=""){?>
					<div class="row">
						<div class="col-md-12">
							<table id="recordsTable" style="width:100%;border:1px solid #68696b;border-collapse: collapse;">
								<tr style="background-color:#ccc">
									<th style="border: 1px solid #68696b;padding:5px 10px;text-align:center;width:100%;font-size:15px" colspan="2">Other Classes/Locations Attended</th>
								</tr>
								<?php if($crm_details['class_1']!=""){?>
									<tr>
										<th style="background-color:#f3f3f3;border: 1px solid #68696b;padding:2px 10px;text-align:left;">Area 1</th>
										<th style="border: 1px solid #68696b;padding:2px 10px;text-align:left;font-size:11px;">
										<?php echo !empty($crm_details['class_1']) ? $class_name[$crm_details['class_1']] : "-"; ?></th>
									</tr>
								<?php }
								if($crm_details['class_2']!=""){?>
									<tr>
										<th style="background-color:#f3f3f3;border: 1px solid #68696b;padding:2px 10px;text-align:left;">Area 2</th>
										<th style="border: 1px solid #68696b;padding:2px 10px;text-align:left;font-size:11px;">
											<?php echo !empty($crm_details['class_2']) ? $class_name[$crm_details['class_2']] : "-"; ?></th>
									</tr>
								<?php }
								if($crm_details['class_3']!=""){?>
									<tr>
										<th style="background-color:#f3f3f3;border: 1px solid #68696b;padding:2px 10px;text-align:left;">Area 3</th>
										<th style="border: 1px solid #68696b;padding:2px 10px;text-align:left;font-size:11px;">
											<?php echo !empty($crm_details['class_3']) ? $class_name[$crm_details['class_3']] : "-"; ?></th>
									</tr>
								<?php }
								if($crm_details['class_4']!=""){?>
									<tr>
										<th style="background-color:#f3f3f3;border: 1px solid #68696b;padding:2px 10px;text-align:left;">Area 4</th>
										<th style="border: 1px solid #68696b;padding:2px 10px;text-align:left;font-size:11px;">
											<?php echo !empty($crm_details['class_4']) ? $class_name[$crm_details['class_4']] : "-"; ?></th>
									</tr>
								<?php }
								if($crm_details['class_5']!=""){?>
									<tr>
										<th style="background-color:#f3f3f3;border: 1px solid #68696b;padding:2px 10px;text-align:left;">Area 5</th>
										<th style="border: 1px solid #68696b;padding:2px 10px;text-align:left;font-size:11px;">
											<?php echo !empty($crm_details['class_5']) ? $class_name[$crm_details['class_5']] : "-"; ?></th>
									</tr>
								<?php }
								if($crm_details['class_6']!=""){?>
									<tr>
										<th style="background-color:#f3f3f3;border: 1px solid #68696b;padding:2px 10px;text-align:left;">Area 6</th>
										<th style="border: 1px solid #68696b;padding:2px 10px;text-align:left;font-size:11px;">
											<?php echo !empty($crm_details['class_6']) ? $class_name[$crm_details['class_6']] : "-"; ?></th>
									</tr>
								<?php }
								if($crm_details['class_7']!=""){?>
									<tr>
										<th style="background-color:#f3f3f3;border: 1px solid #68696b;padding:2px 10px;text-align:left;">Area 7</th>
										<th style="border: 1px solid #68696b;padding:2px 10px;text-align:left;font-size:11px;">
											<?php echo !empty($crm_details['class_7']) ? $class_name[$crm_details['class_7']] : "-"; ?></th>
									</tr>
								<?php }
								if($crm_details['class_8']!=""){?>
									<tr>
										<th style="background-color:#f3f3f3;border: 1px solid #68696b;padding:2px 10px;text-align:left;">Area 8</th>
										<th style="border: 1px solid #68696b;padding:2px 10px;text-align:left;font-size:11px;">
											<?php echo !empty($crm_details['class_8']) ? $class_name[$crm_details['class_8']] : "-"; ?></th>
									</tr>
								<?php }
								if($crm_details['class_9']!=""){?>
									<tr>
										<th style="background-color:#f3f3f3;border: 1px solid #68696b;padding:2px 10px;text-align:left;">Area 9</th>
										<th style="border: 1px solid #68696b;padding:2px 10px;text-align:left;font-size:11px;">
											<?php echo !empty($crm_details['class_9']) ? $class_name[$crm_details['class_9']] : "-"; ?></th>
									</tr>
								<?php }
								if($crm_details['class_10']!=""){?>
									<tr>
										<th style="background-color:#f3f3f3;border: 1px solid #68696b;padding:2px 10px;text-align:left;">Area 10</th>
										<th style="border: 1px solid #68696b;padding:2px 10px;text-align:left;font-size:11px;">
											<?php echo !empty($crm_details['class_10']) ? $class_name[$crm_details['class_10']] : "-"; ?></th>
									</tr>
								<?php }?>
							</table>
						</div>
					</div>
					<?php }?>

					<!-- <h4 class="form-title m-b-xl text-left"><b><u></u></b></h4>

					<div class="row">
						<div class="col-md-12">
							<table id="recordsTable" style="width:100%;border:1px solid #68696b;border-collapse: collapse;">
								<tr style="background-color:#ccc">
									<th style="border: 1px solid #68696b;padding:5px 10px;text-align:center;width:100%;font-size:15px" colspan="2">CASE DETAILS</th>
								</tr>
								<tr>
									<th style="background-color:#f3f3f3;border: 1px solid #68696b;padding:2px 10px;text-align:left;">Type of Case</th>
									<th style="border: 1px solid #68696b;padding:2px 10px;text-align:left;font-size:11px;">
										<?php echo !empty($type_of_case[$crm_details['initial_case']]) ? $type_of_case[$crm_details['initial_case']] : "-"; ?></th>
								</tr>
								<tr>
									<th style="background-color:#f3f3f3;border: 1px solid #68696b;padding:2px 10px;text-align:left;">Is Diagnosed as Positive?</th>
									<th style="border: 1px solid #68696b;padding:2px 10px;text-align:left;font-size:11px;">
										<?php echo !empty($crm_details['diagnosed_as_positive']) ? $diagnosed_as_positive[$crm_details['diagnosed_as_positive']] : "-"; ?></th>
								</tr>
								<tr>
									<th style="background-color:#f3f3f3;border: 1px solid #68696b;padding:2px 10px;text-align:left;">Date of Test</th>
									<th style="border: 1px solid #68696b;padding:2px 10px;text-align:left;font-size:11px;">
										<?php echo !empty($crm_details['diagnosed_date']) ? $crm_details['diagnosed_date'] : "-"; ?></th>
								</tr>
								<tr>
									<th style="background-color:#f3f3f3;border: 1px solid #68696b;padding:2px 10px;text-align:left;">Manager Name</th>
									<th style="border: 1px solid #68696b;padding:2px 10px;text-align:left;font-size:11px;">
										<?php echo !empty($crm_details['manager_name']) ? $crm_details['manager_name'] : "-"; ?></th>
								</tr>
								<tr>
									<th style="background-color:#f3f3f3;border: 1px solid #68696b;padding:2px 10px;text-align:left;">May I please ask for the details of where you entered and exited the building for cleaning protocol?</th>
									<th style="border: 1px solid #68696b;padding:2px 10px;text-align:left;font-size:11px;">
										<?php echo !empty($crm_details['entrance_and_exit']) ? $entrance_exit[$crm_details['entrance_and_exit']] : "-"; ?></th>
								</tr>
								<tr>
									<th style="background-color:#f3f3f3;border: 1px solid #68696b;padding:2px 10px;text-align:left;">Did you have Close Contact with any other members of the staff or students? What I mean by this is were you within 6 feet, for a period of 15 minutes or more over a 24 hour period of time?</th>
									<th style="border: 1px solid #68696b;padding:2px 10px;text-align:left;font-size:11px;">
										<?php echo !empty($crm_details['any_close_contact']) ? $close_contact[$crm_details['any_close_contact']] : "-"; ?></th>
								</tr>
								<tr>
									<th style="background-color:#f3f3f3;border: 1px solid #68696b;padding:2px 10px;text-align:left;">More Information about contact</th>
									<th style="border: 1px solid #68696b;padding:2px 10px;text-align:left;font-size:11px;">
										<?php echo !empty($crm_details['more_information_about_contact']) ? $crm_details['more_information_about_contact'] : "-"; ?></th>
								</tr>
								<tr>
									<th style="background-color:#f3f3f3;border: 1px solid #68696b;padding:2px 10px;text-align:left;">And what was the date you were last at the buliding please Or on The Bus ?</th>
									<th style="border: 1px solid #68696b;padding:2px 10px;text-align:left;font-size:11px;">
										<?php echo !empty($crm_details['last_date_in_building']) ? $crm_details['last_date_in_building'] : "-"; ?></th>
								</tr>
							</table>
						</div>
					</div> -->

					<!-- <h4 class="form-title m-b-xl text-left"><b><u></u></b></h4>

					<div class="row">
						<div class="col-md-12">
							<table id="recordsTable" style="width:100%;border:1px solid #68696b;border-collapse: collapse;">
								<thead>
									<tr style="background-color:#ccc">
										<th style="border: 1px solid #68696b;padding:5px 10px;text-align:center;width:100%;font-size:15px" colspan="3">Contact Tracing</th>
									</tr>
									<tr>
										<th style="border: 1px solid #68696b;padding:5px 10px;text-align:center;width:100%;font-size:15px">Date</th>
										<th style="border: 1px solid #68696b;padding:5px 10px;text-align:center;width:100%;font-size:15px">Locations(With Time)</th>
										<th style="border: 1px solid #68696b;padding:5px 10px;text-align:center;width:100%;font-size:15px">Contacts</th>
									</tr>
								</thead>
								<tbody>
									<?php
									if(count($day_wise_data)>0){
										foreach($day_wise_data as $day_data){?>
										<tr>
											<th style="border: 1px solid #68696b;padding:2px 10px;text-align:left;font-size:11px;">
												<?php echo !empty($day_data['date_on']) ? $day_data['date_on'] : "-"; ?>
											</th>
											<th style="border: 1px solid #68696b;padding:2px 10px;text-align:left;font-size:11px;">
												<?php echo !empty($day_data['location_info']) ? $day_data['location_info'] : "-"; ?>
											</th>
											<th style="border: 1px solid #68696b;padding:2px 10px;text-align:left;font-size:11px;">
												<?php echo !empty($day_data['contacts']) ? $day_data['contacts'] : "-"; ?>
											</th>
										</tr>
										<?php }
									}
									?>
								</tbody>
							</table>
						</div>
					</div> -->

					<h4 class="form-title m-b-xl text-left"><b><u></u></b></h4>

					<div class="row">
						<div class="col-md-12">
							<table id="recordsTable" style="width:100%;border:1px solid #68696b;border-collapse: collapse;">
								<tr style="background-color:#ccc">
									<th style="border: 1px solid #68696b;padding:5px 10px;text-align:center;width:100%;font-size:15px" colspan="2">FINAL SECTION</th>
								</tr>
								<?php
								$caseResultType = $crm_details['initial_case'];
								$styleColor = "background-color:#ccc;color:#000";
								if ($caseResultType == 'C' || $caseResultType == 'D') {
									$styleColor = "background-color:#fffb8b;color:#000";
								}
								if ($caseResultType == 'A' || $caseResultType == 'B' || $caseResultType == 'E') {
									$styleColor = "background-color:#ff8b8b;color:#fff";
								}
								?>
								<tr>
									<th style="background-color:#f3f3f3;border: 1px solid #68696b;padding:2px 10px;text-align:left;">Caller Test Result</th>
									<th style="border: 1px solid #68696b;padding:2px 10px;text-align:left;font-size:11px;">
										<?php echo !empty($type_of_case[$caseResultType]) ? $type_of_case[$caseResultType] : "N/A"; ?></th>
								</tr>
								<!-- <tr>
									<th style="background-color:#f3f3f3;border: 1px solid #68696b;padding:2px 10px;text-align:left;">Have you been in contact with anyone who has tested Positive within the last 14 days?  </th>
									<th style="border: 1px solid #68696b;padding:2px 10px;text-align:left;font-size:11px;">
										<?php echo !empty($crm_details['f_individuals']) ? $crm_details['f_individuals'] : "-"; ?></th>
								</tr>
								<tr>
									<th style="background-color:#f3f3f3;border: 1px solid #68696b;padding:2px 10px;text-align:left;">Are there other individuals who have tested positive that you aware of from the same location within the last 14 days?</th>
									<th style="border: 1px solid #68696b;padding:2px 10px;text-align:left;font-size:11px;">
										<?php echo !empty($crm_details['f_other_individual']) ? $crm_details['f_other_individual'] : "-"; ?></th>
								</tr>
								<tr>
									<th style="background-color:#f3f3f3;border: 1px solid #68696b;padding:2px 10px;text-align:left;">Are you still actively working onsite?</th>
									<th style="border: 1px solid #68696b;padding:2px 10px;text-align:left;font-size:11px;">
										<?php echo !empty($crm_details['f_is_positive_working']) ? $crm_details['f_is_positive_working'] : "-"; ?></th>
								</tr>
								<tr>
									<th style="background-color:#f3f3f3;border: 1px solid #68696b;padding:2px 10px;text-align:left;">Is the caller a 3rd party (trash collector, police officer, someone who came in contact at the location but does not work there)? Or is the call about a 3rd Party?</th>
									<th style="border: 1px solid #68696b;padding:2px 10px;text-align:left;font-size:11px;">
										<?php echo !empty($crm_details['f_is_third_party']) ? $crm_details['f_is_third_party'] : "-"; ?></th>
								</tr>
								<tr>
									<th style="background-color:#f3f3f3;border: 1px solid #68696b;padding:2px 10px;text-align:left;">Notes</th>
									<th style="border: 1px solid #68696b;padding:2px 10px;text-align:left;font-size:11px;">
										<?php echo !empty($crm_details['f_notes']) ? $crm_details['f_notes'] : "-"; ?></th>
								</tr> -->
							</table>
						</div>
					</div>

				</div>

				<h4 class="form-title m-b-xl text-left"><b><u></u></b></h4>

				<hr />
				<p style="text-align:left;margin:0px 0px 0px 0px;font-size:10px">** Added On <?php echo $crm_details['date_added']; ?> | <?php echo $crm_details['added_by_name']; ?></p>

			</div>
		</div>


	</section>
</div>