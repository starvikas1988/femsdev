<style>
	.table-widget td {
		padding:10px!important;
	}
	.common-top {
		margin:20px 0 0 0;
	}
	.table-widget strong {
		margin:0 5px 0 0;
	}
	.submit-btn {
		width: 200px;
		padding: 10px;
		background: #188ae2;
		color: #fff;
		border: none;
		border-radius: 5px;
		margin:15px 0 0 0;
		font-size:16px;
		letter-spacing:0.5px;
		transition: all 0.5s ease-in-out 0s;
	}
	.submit-btn:hover {
		background: #0e6cb5;
	}
	.submit-btn:focus {
		outline: none;
		box-shadow: none;
	}
	.caller-widget .form-control {
		width: 100%;
		height: 35px;
		font-size: 14px;
		transition: all 0.5s ease-in-out 0s;
	}
	.caller-widget .form-control:hover {
		border: 1px solid #188ae2;
	}
	.caller-widget .form-control:focus {
		border: 1px solid #188ae2;
		outline: none;
		box-shadow: none;
	}
</style>
<div class="wrap">
	<section class="app-content">
		<div class="widget">
			<header class="widget-header">
				<h4 class="widget-title">Howard Case Search</h4>
			</header>
			<div class="widget-body">
				<form method="GET" enctype="multipart/form-data" action="" autocomplete="off">
					<div class="caller-widget">
						<div class="row">
							<div class="col-md-4">
								<div class="form-group">
									<label for="search_keyword">Enter Case ID / Name / Phone No</label>
									<input type="text" class="form-control" id="search_keyword" value="<?= $search_keyword; ?>" name="search_keyword" required />
								</div>
							</div>

							<div class="col-md-4">
								<div class="form-group">
									<label for="type">Select Type</label>
									<select class="form-control" name="main_type" id="type">
										<option value="" selected>ALL</option>
										<?php
										foreach ($caseTypes as $key => $val) {
											$selected = "";
											if ($key == $currReportType) {
												$selected = "selected";
											}
										?>
											<option value="<?= $key; ?>" <?= $selected; ?>><?= $val; ?></option>
										<?php } ?>
									</select>
								</div>
							</div>

							<div class="col-md-4">
								<div class="form-group">
									<button name="reportSubmission" type="submit" class="submit-btn"><i class="fa fa-search"></i> Filter</button>
								</div>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
		<?php if ((!empty($totaldata)) && ($totaldata > 0)) { ?>
			<div class="common-top">
				<div class="row">
					<div class="col-md-12">
						<div class="widget">
							<header class="widget-header">
								<h4 class="widget-title">Howard Case Found</h4>
							</header>
							<hr class="widget-separator">
							<div class="widget-body">
								<?php
								//array("1"=>"Bushy Park Elementary", "2"=>"Centennial High", "3"=>"Centennial Lane Elementary", "4"=>"Clarksville Elementary", "5"=>"Clarksville Middle", "6"=>"Clemens Crossing Elementary", "7"=>"Dayton Oaks", "8"=>"Dunloggin Middle");
								$inital_case=array("1"=>"Confirmed Positive", "2"=>"Presumed Positive", "3"=>"Close Contact", "4"=>"Proximity", "5"=>"Illness (Non-COVID with no close contact to positive Case)");
								$school_name=$school_name2="";
								$city=$city2="";
								$county=$county2="";
								$address=$address2="";
								$grades=$grades2="";
								$class_name=array(
									"0"=>"None",
									"1"=>"Art Room",
									"2"=>"Basement",
									"3"=>"Basketball Court",
									"4"=>"Board Office",
									"5"=>"Bus",
									"6"=>"Cafeteria",
									"7"=>"Classroom",
									"8"=>"Football Field",
									"9"=>"Gym",
									"10"=>"Hallway",
									"11"=>"Home",
									"12"=>"Janitor's Closet",
									"13"=>"Lounge Area",
									"14"=>"Music Room",
									"15"=>"Nurse's Office",
									"16"=>"Office",
									"17"=>"Playground",
									"18"=>"Woodshop",
									"19"=>"Other"
								);
								$type_of_case=array(
									"1"=>"A. Confirmed COVID-19 diagnosis",
									"2"=>"B. Proximate exposure to someone diagnosis with COVID-19",
									"3"=>"C. Second hand exposure to someone diagnosis with COVID-19",
									"4"=>"D. Caller illness",
									"5"=>"E. Third party exposure"
								);
								$diagnosed_as_pos=array(
									"1"=>"Yes",
									"2"=>"No",
									"3"=>"Awaiting Results"
								);
								$entrance_exit=array("1"=>"Front Door", "2"=>"Back Door", "3"=>"Side Intrance", "4"=>"Others");
								$close_contact=array("1"=>"Yes", "2"=>"No", "3"=>"Other");
								foreach($case_list as $case){
									foreach($school_list as $key=>$school){
										if($school['id']==$case['schools']){
											$school_name=$school['name'];
											$city=$school['city'];
											$county=$school['county'];
											$address=$school['address'];
											$grades=$school['grades'];
										}
										if($school['id']==$case['school2']){
											$school_name2=$school['name'];
											$city2=$school['city'];
											$county2=$school['county'];
											$address2=$school['address'];
											$grades2=$school['grades'];
										}
									}?>
								<div class="table-widget">
									<table class="table table-responsive table-bordered table-striped">
										<tbody>
											<tr>
												<td style="width:50%;"><strong>Case ID:</strong><span class="item_span_value"><?= $case['incident_id']?></span></td>
												<td><strong>Call Date:</strong><span class="item_span_value"><?= $case['date_of_call']?></span></td>
											</tr>
											<tr>
												<td><strong>Caller Information:</strong><span class="item_span_value"><?= $case['caller_info']?></span></td>
												<td><strong>Initial Case Type:</strong><span class="item_span_value"><?= $inital_case[$case['initial_case']]?></span></td>
											</tr>
											<tr>
												<td><strong>Caller Name: </strong><span class="item_span_value"><?= $case['caller_fname']." ".$case['caller_lname']?></span></td>
												<td><strong>Student Name: </strong><span class="item_span_value"><?= $case['student_fname']." ".$case['student_lname']?></span></td>
											</tr>
											<tr>
											<td><strong>Title: </strong><span class="item_span_value"><?= $case['title']?></span></td>
												<td><strong>Diagnosed as Positive: </strong><span class="item_span_value"><?= $diagnosed_as_pos[$case['diagnosed_as_positive']]?></span></td>
											</tr>
											<tr>
												<td><strong>Caller Phone: </strong><span class="item_span_value"><?= $case['caller_phone']?></span></td>
												<td><strong>Secondary Phone: </strong><span class="item_span_value"><?= $case['secondary_phone']?></span></td>
											</tr>
											<tr>
												<td><strong>School: </strong><span class="item_span_value"><?= $school_name?></span></td>
												<?php if($school_name2!=""){?><td><strong>School 2: </strong><span class="item_span_value"><?= $school_name2?></span></td><?php }?>
											</tr>
											<tr>
												<td><strong>Grades: </strong><span class="item_span_value"><?= $grades?></span></td>
												<?php if($grades2!=""){?><td><strong>Grades 2: </strong><span class="item_span_value"><?= $grades2?></span></td><?php }?>
											</tr>
											<tr>
												<td><strong>Address: </strong><span class="item_span_value"><?= $address?></span></td>
												<?php if($address2!=""){?><td><strong>Address 2: </strong><span class="item_span_value"><?= $address2?></span></td><?php }?>
											</tr>
											<tr>
												<td><strong>County: </strong><span class="item_span_value"><?= $county?></span></td>
												<?php if($county2!=""){?><td><strong>County 2: </strong><span class="item_span_value"><?= $county2?></span></td><?php }?>
											</tr>
											<tr>
												<td><strong>City: </strong><span class="item_span_value"><?= $city?></span></td>
												<?php if($city2!=""){?><td><strong>City 2: </strong><span class="item_span_value"><?= $city2?></span></td><?php }?>
											</tr>
											<tr>
												<td><strong>Teacher: </strong><span class="item_span_value"><?= $case['teacher']?></span></td>
												<td><strong>Assigned Room: </strong><span class="item_span_value"><?= $case['assigned_room']?></span></td>
											</tr>
											<tr>
												<td><strong>Class 1: </strong><span class="item_span_value"><?= $class_name[$case['class_1']]?></span></td>
												<td><strong>Class 2: </strong><span class="item_span_value"><?= $class_name[$case['class_2']]?></span></td>
											</tr>
											<tr>
												<td><strong>Class 3: </strong><span class="item_span_value"><?= $class_name[$case['class_3']]?></span></td>
												<td><strong>Class 4: </strong><span class="item_span_value"><?= $class_name[$case['class_4']]?></span></td>
											</tr>
											<tr>
												<td><strong>Class 5: </strong><span class="item_span_value"><?= $class_name[$case['class_5']]?></span></td>
												<td><strong>Class 6: </strong><span class="item_span_value"><?= $class_name[$case['class_6']]?></span></td>
											</tr>
											<tr>
												<td><strong>Class 7: </strong><span class="item_span_value"><?= $class_name[$case['class_7']]?></span></td>
												<td><strong>Class 8: </strong><span class="item_span_value"><?= $class_name[$case['class_8']]?></span></td>
											</tr>
											<tr>
												<td><strong>Class 9: </strong><span class="item_span_value"><?= $class_name[$case['class_9']]?></span></td>
												<td><strong>Class 10: <strong><span class="item_span_value"><?= $class_name[$case['class_10']]?></span></td>
											</tr>
											<tr>
												<td><strong>Caller's School: </strong><span class="item_span_value"><?= $case['callers_school']?></span></td>
												<td><strong>Caller's Work Location: </strong><span class="item_span_value"><?= $case['callers_work_location']?></span></td>
											</tr>
											<tr>
												<td><strong>Manager Name: </strong><span class="item_span_value"><?= $case['manager_name']?></span></td>
												<td><strong>Entrance and Exit: </strong><span class="item_span_value"><?= $entrance_exit[$case['entrance_and_exit']]?></span>
													<?php if($entrance_exit[$case['entrance_and_exit']]=="Others"){?>
														<p class="item_span_value"><?= $case['doors_other']?></p>
													<?php }?>
												</td>
											</tr>
											<tr>
												<td><strong>Any Close Contact: </strong><span class="item_span_value"><?= $close_contact[$case['any_close_contact']]?></span>
													<?php if($close_contact[$case['any_close_contact']]=="Other"){?>
														<p class="item_span_value"><?= $case['connect_others']?></p>
													<?php }?>
												</td>
												<td><strong>More information about contact: </strong><span class="item_span_value"><?= $case['more_information_about_contact']?></span></td>
											</tr>
											<tr>
												<td><strong>Last Date in Building: </strong><span class="item_span_value"><?= $case['last_date_in_building']?></span></td>
											</tr>
										</tbody>
									</table>
								</div>
								<?php }
								?>
							</div>
						</div>
					</div>
				</div>
			</div>

		<?php } else {  ?>
			<div class="row">
				<div class="col-md-12">
					<div class="widget">
						<div class="widget-body">
							<span class="text-danger font-weight-bold">
							<?php if (!empty($search_keyword))
								echo "No Cases Found!";
							else
								echo "Please Enter Keyword to Search!";
							?>
							</span>
						</div>
					</div>
				</div>
			</div>
		<?php } ?>
	</section>
</div>


<div id="myEmailSendModal" class="largeModal modal fade" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">

			<!--<form action="<?php echo base_url(); ?>contact_tracing_crm/send_email" method="POST" autocomplete="off">-->

			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Send Case Details - ZOVIO</h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<strong for="case">CRM ID</strong>
							<input type="text" class="form-control" id="form_crm_id" placeholder="" value="<?php echo $crmid; ?>" name="form_crm_id" required readonly>
							<input type="hidden" class="form-control" id="form_send_type" placeholder="" value="1" name="form_send_type" required readonly>
						</div>
					</div>

					<div class="col-md-6">
						<div class="form-group">
							<strong for="case">Case Name</strong>
							<input type="text" class="form-control" id="form_case_name" placeholder="" value="<?php echo $form_case_name; ?>" name="form_case_name" required readonly>
						</div>
					</div>

					<div class="col-md-6">
						<div class="form-group">
							<strong for="case">E-Mail ID</strong>
							<input type="text" class="form-control" id="form_email_id" placeholder="" value="" name="form_email_id" required>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-success sendMailSubmission" onclick="return confirm('Are you sure you want send this case details to mail?');" name="crmFormSubmission">Send</button>
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>

			<!--</form> -->
		</div>

	</div>
</div>