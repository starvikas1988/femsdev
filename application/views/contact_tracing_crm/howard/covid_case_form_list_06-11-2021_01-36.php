<style>
	.table-widget td {
		padding:10px!important;
		font-size:14px;
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
		font-size:14px;
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
	.modal-header {
		background:#188ae2;
		color:#fff;
	}
	.modal-header .close {
		opacity: 1;
		color: #fff;
	}
</style>
<?php
$type_of_case=array(
	"1"=>"A. Confirmed COVID-19 diagnosis",
	"2"=>"B. Proximate exposure to someone diagnosis with COVID-19",
	"3"=>"C. Second hand exposure to someone diagnosis with COVID-19",
	"4"=>"D. Caller illness",
	"5"=>"E. Third party exposure"
);
?>
<div class="wrap">
	<section class="app-content">
		<div class="widget">
			<header class="widget-header">
				<h4 class="widget-title">Howard Case Filter</h4>
			</header>
			<div class="widget-body">
				<form method="GET" enctype="multipart/form-data" action="" autocomplete="off">
					<div class="caller-widget">
						<div class="row">
							<div class="col-md-4">
								<div class="form-group">
									<label for="startdate">Start Date</label>
									<input type="text" class="form-control newDatePick" id="start_date" value="<?php echo $start_date; ?>" name="start_date" required>
								</div>
							</div>

							<div class="col-md-4">
								<div class="form-group">
									<label for="enddate">End date</label>
									<input type="text" class="form-control newDatePick" id="end_date" value="<?php echo $end_date; ?>" name="end_date" required>
								</div>
							</div>

							<div class="col-md-4">
								<div class="form-group">
									<label for="type">Select Location</label>
									<select class="form-control" name="main_location">
										<option value="">ALL</option>
										<?php
										/*foreach ($caseLocation as $keyt) {
											$selected = "";
											if ($keyt['callers_work_location'] == $main_location) {
												$selected = "selected";
											}
											if ($keyt['callers_work_location'] != "") {
										?>
												<option value="<?php echo $keyt['callers_work_location']; ?>" <?php echo $selected; ?>><?php echo $keyt['callers_work_location']; ?></option>
										<?php }*/
										foreach ($school_list as $kt=> $keyt) {
											$selected = "";
											if ($keyt['id'] == $main_location) {
												$selected = "selected";
											}
											if ($keyt['id'] != "") {
										?>
												<option value="<?php echo $keyt['id']; ?>" <?php echo $selected; ?>><?php echo $keyt['name']; ?></option>
										<?php }
										} ?>
									</select>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-4">
								<div class="form-group">
									<label for="type">Select Agent</label>
									<select class="form-control" name="main_agent">
										<option value="">ALL</option>
										<?php
										foreach ($caseAgents as $keyt) {
											$selected = "";
											if ($keyt['agent_id'] == $main_agent) {
												$selected = "selected";
											}
											if ($keyt['agent_id'] != "") {
										?>
												<option value="<?php echo $keyt['agent_id']; ?>" <?php echo $selected; ?>><?php echo $keyt['fullname']; ?></option>
										<?php }
										} ?>
									</select>
								</div>
							</div>

							<div class="col-md-4">
								<div class="form-group">
									<label for="type">Select Type</label>
									<select class="form-control" name="main_type">
										<option value="">ALL</option>
										<?php
										foreach ($caseTypes as $key => $val) {
											$selected = "";
											if ($key == $main_type) {
												$selected = "selected";
											}
										?>
											<option value="<?php echo $key; ?>" <?php echo $selected; ?>><?php echo $val; ?></option>
										<?php } ?>
									</select>
								</div>
							</div>

							<div class="col-md-4">
								<div class="form-group">
									<label for="type">Case Status</label>
									<select class="form-control" name="case_status">
										<option value="" <?= (isset($_GET['case_status']) && $_GET['case_status']=="")?"selected":""?>>ALL</option>
										<option value="Y" <?= (isset($_GET['case_status']) && $_GET['case_status']=="Y")?"selected":""?>>Open</option>
										<option value="N" <?= (isset($_GET['case_status']) && $_GET['case_status']=="N")?"selected":""?>>Closed</option>
									</select>
								</div>
							</div>
						</div>
						
						<div class="row">
							<div class="col-md-4">
								<div class="form-group">
									<button name="reportSubmission" type="submit" style="margin-top:20px" class="submit-btn">Filter</button>
								</div>
							</div>
						</div>
					</div>

				</form>
			</div>
		</div>

		<div class="common-top">
			<div class="row">
				<div class="col-md-12">
					<div class="widget">
						<header class="widget-header">
							<h4 class="widget-title">Howard Case List</h4>
						</header>
						<hr class="widget-separator">

						<div class="widget-body">
							<div class="table-responsive">
								<table style="margin-top: 10px;" id="default-datatable" data-plugin="DataTable" class="table table-striped skt-table" cellspacing="0" width="100%">

									<thead>
										<tr class='bg-info'>
											<th>SL</th>
											<th>Case ID</th>
											<th>Caller Name</th>
											<th>Case Type</th>
											<th>Case Location</th>
											<th>Location Adress</th>
											<th>Case Status</th>
											<th>Opened By</th>
											<th>Date Added</th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody>
										<?php
										$cn = 1;
										foreach ($case_list as $token) {
										?>
											<tr>
												<td><?php echo $cn++; ?></td>
												<td><?php echo $token['incident_id']; ?></td>
												<td><?php echo $token['caller_fname'] . " " . $token['caller_lname']; ?></td>
												<td><?php
													echo !empty($caseTypes[$token['initial_case']]) ? $caseTypes[$token['initial_case']] : "-";
													?>
												</td>
												<td><?php
													echo $token['school_name'];
													?>
												</td>
												<td><a href="#" style="text-decoration:none" title="<?php echo $token['callers_work_location']; ?>"><?php echo substr($token['callers_work_location'], 0, 10); ?>..</a></td>
												<td>
													<?php
													if (isset($token['case_status'])) {
														if ($token['case_status'] == '0') {
															echo "<span class='text-success'><b>Closed</b></span>";
														}
														if ($token['case_status'] == '1') {
															echo "<span class='text-danger'><b>Open</b></span>";
														}
													} else {
														echo "<span class='text-warning'><b>Open</b></span>";
													}
													?></td>
												<td><?php echo $token['added_by_name']; //ucwords($token['case_source']); 
													?></td>
												<td><?php echo date('d M, Y', strtotime($token['date_of_call'])); ?></td>
												<td>
													<a title='Open Case' target="_blank" href="<?= base_url()?>howard_training/form/<?= $token['incident_id']?>" class='btn btn-primary btn-xs' style='font-size:12px'>Open Case</a>
													<a title='View Case' href="#" data-toggle="modal" data-target="#view_case<?= $cn?>" class='btn btn-success btn-xs' style='font-size:12px'>
														<i class='fa fa-eye'></i> View</a>
													<?php if (get_login_type() != "client" || (get_login_type() != "client" && !is_access_howard_report())) { ?>
														<?php if ($token['case_status'] != '0') { ?>
															<a title='Close Case' onclick="return confirm('Are you sure, you want to close this case ?')" href="update_case_status/<?= $token['incident_id'];?>" class='btn btn-danger btn-xs' style='font-size:12px'>
																<i class='fa fa-clock-o'></i></a>
														<?php } ?>
													<?php } ?>
													<div class="modal fade" id="view_case<?= $cn?>" role="dialog">
														<div class="modal-dialog modal-lg" role="document">
															<div class="modal-content">
																<div class="modal-header">
																	<button type="button" class="close" data-dismiss="modal">&times;</button>
																	<h4 class="modal-title">View Case Details - HOWARD</h4>
																</div>
																<div class="modal-body">
																<?php
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
																$diagnosed_as_pos=array(
																	"1"=>"Yes",
																	"2"=>"No",
																	"3"=>"Awaiting Results"
																);
																$entrance_exit=array("1"=>"Front Door", "2"=>"Back Door", "3"=>"Side Intrance", "4"=>"Others");
																$close_contact=array("1"=>"Yes", "2"=>"No", "3"=>"Other");
																foreach($school_list as $key=>$school){
																	if($school['id']==$token['schools']){
																		$school_name=$school['name'];
																		$city=$school['city'];
																		$county=$school['county'];
																		$address=$school['address'];
																		$grades=$school['grades'];
																	}
																	if($school['id']==$token['school2']){
																		$school_name2=$school['name'];
																		$city2=$school['city'];
																		$county2=$school['county'];
																		$address2=$school['address'];
																		$grades2=$school['grades'];
																	}
																}?>
																<div class="table-widget">
																	<table style="width:100%" class="table table-responsive table-bordered table-striped">
																		<tbody>
																			<tr>
																				<td style="width:50%;"><strong class="">Case ID:</strong><span class="item_span_value"><?= $token['incident_id']?></span></td>
																				<td><strong class="">Call Date:</strong><span class="item_span_value"><?= $token['date_of_call']?></span></td>
																			</tr>
																			<tr>
																				<td><strong class="">Caller Information:</strong><span class="item_span_value"><?= $token['caller_info']?></span></td>
																				<td><strong class="">Initial Case Type:</strong><span class="item_span_value"><?= $inital_case[$token['initial_case']]?></span></td>
																			</tr>
																			<tr>
																				<td><strong class="">Caller Name: </strong><span class="item_span_value"><?= $token['caller_fname']." ".$token['caller_lname']?></span></td>
																				<td><strong class="">Student Name: </strong><span class="item_span_value"><?= $token['student_fname']." ".$token['student_lname']?></span></td>
																			</tr>
																			<tr>
																				<td><strong class="">Title: </strong><span class="item_span_value"><?= $token['title']?></span></td>
																				<td><strong class="">Diagnosed as Positive: </strong><span class="item_span_value"><?= $diagnosed_as_pos[$token['diagnosed_as_positive']]?></span></td>
																			</tr>
																			<tr>
																				<td><strong class="">Caller Phone: </strong><span class="item_span_value"><?= $token['caller_phone']?></span></td>
																				<td><strong class="">Secondary Phone: </strong><span class="item_span_value"><?= $token['secondary_phone']?></span></td>
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
																				<td><strong class="">Teacher: </strong><span class="item_span_value"><?= $token['teacher']?></span></td>
																				<td><strong class="">Assigned Room: </strong><span class="item_span_value"><?= $token['assigned_room']?></span></td>
																			</tr>
																			<tr>
																				<td><strong class="">Class 1: </strong><span class="item_span_value"><?= $class_name[$token['class_1']]?></span></td>
																				<td><strong class="">Class 2: </strong><span class="item_span_value"><?= $class_name[$token['class_2']]?></span></td>
																			</tr>
																			<tr>
																				<td><strong class="">Class 3: </strong><span class="item_span_value"><?= $class_name[$token['class_3']]?></span></td>
																				<td><strong class="">Class 4: </strong><span class="item_span_value"><?= $class_name[$token['class_4']]?></span></td>
																			</tr>
																			<tr>
																				<td><strong class="">Class 5: </strong><span class="item_span_value"><?= $class_name[$token['class_5']]?></span></td>
																				<td><strong class="">Class 6: </strong><span class="item_span_value"><?= $class_name[$token['class_6']]?></span></td>
																			</tr>
																			<tr>
																				<td><strong class="">Class 7: </strong><span class="item_span_value"><?= $class_name[$token['class_7']]?></span></td>
																				<td><strong class="">Class 8: </strong><span class="item_span_value"><?= $class_name[$token['class_8']]?></span></td>
																			</tr>
																			<tr>
																				<td><strong class="">Class 9: </strong><span class="item_span_value"><?= $class_name[$token['class_9']]?></span></td>
																				<td><strong class="">Class 10: </strong><span class="item_span_value"><?= $class_name[$token['class_10']]?></span></td>
																			</tr>
																			<tr>
																				<td><strong class="">Caller's School: </strong><span class="item_span_value"><?= $token['callers_school']?></span></td>
																				<td><strong class="">Caller's Work Location: </strong><span class="item_span_value"><?= $token['callers_work_location']?></span></td>
																			</tr>
																			<tr>
																				<td><strong>Manager Name: </strong><span class="item_span_value"><?= $token['manager_name']?></span></td>
																				<td><strong>Entrance and Exit: </strong><span class="item_span_value"><?= $entrance_exit[$token['entrance_and_exit']]?></span>
																					<?php if($entrance_exit[$token['entrance_and_exit']]=="Others"){?>
																						<p class="item_span_value"><?= $token['doors_other']?></p>
																					<?php }?>
																				</td>
																			</tr>
																			<tr>
																				<td><strong>Any Close Contact: </strong><span class="item_span_value"><?= $close_contact[$token['any_close_contact']]?></span>
																					<?php if($close_contact[$token['any_close_contact']]=="Other"){?>
																						<p class="item_span_value"><?= $token['connect_others']?></p>
																					<?php }?>
																				</td>
																				<td><strong>More information about contact: </strong><span class="item_span_value"><?= $token['more_information_about_contact']?></span></td>
																			</tr>
																			<tr>
																				<td><strong class="">Last Date in Building: </strong><span class="item_span_value"><?= $token['last_date_in_building']?></span></td>
																			</tr>
																		</tbody>
																	</table>
																</div>
																</div>
															</div>
														</div>
													</div>
													<a title='View Logs' target="_blank" href="check_logs/<?= $token['incident_id']?>" class='btn btn-primary btn-xs' style='font-size:12px'><i class='fa fa-calendar'></i></a>

													<a title='Download Case' target="_blank" href="generate_crm_report_pdf/<?= $token['incident_id']?>/download" class='btn btn-primary btn-xs' style='font-size:12px'><i class='fa fa-download'></i></a>

													<a title="Send Mail" c_name="<?php echo $token['caller_fname'] . " " . $token['caller_lname']; ?>" c_crmid="<?php echo $token['incident_id']; ?>" c_mail="" class="btn btn-primary btn-xs sendMailCase" style="font-size:12px"><i class='fa fa-envelope'></i></a>
												</td>
											</tr>
										<?php } ?>
									</tbody>
									<tfoot>
										<tr class='bg-info'>
											<th>SL</th>
											<th>Case ID</th>
											<th>Caller Name</th>
											<th>Case Type</th>
											<th>Case Location</th>
											<th>Location Adress</th>
											<th>Case Status</th>
											<th>Opened By</th>
											<th>Date Added</th>
											<th>Action</th>
										</tr>
									</tfoot>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

	</section>
</div>



<div id="myEmailSendModal" class="largeModal modal fade" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">

			<!--<form action="<?php echo base_url(); ?>contact_tracing_crm/send_email" method="POST" autocomplete="off">-->

			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Send Case Details - HOWARD</h4>
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