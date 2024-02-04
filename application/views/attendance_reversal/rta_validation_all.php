<!DOCTYPE html>
<html lang="en">

<head>
	<title>RTA Validation</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/attendance_reversal/css/custom.css">
	<link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap.min.css">
	<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.bootstrap.min.css">
	<!--start automatic table th adjust css library-->
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/attendance_reversal/css/app.min.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/attendance_reversal/css/dataTables.bootstrap4.min.css">
	<!--end automatic table th adjust css library-->
</head>
<style>
	#ui-datepicker-div {
		z-index: 1000 !important;
	}
</style>

<body>
	<div class="main">
		<div class="wrap">
			<div class="gimini-main">
				<div class="white_widget padding_3">
					<div class="menu_widget">
						<div class="row">
							<div class="col-sm-8">
								<?php include_once('aside_menu.php'); ?>
							</div>
							<div class="col-sm-4">
								<div class="right_side">
									<div class="select_top minus_new_top">
										<div class="information_icon">
											<a href="javascript:void(0);" data-toggle="modal" data-target="#myModal_info" title="Information">
												<i class="fa fa-info" aria-hidden="true"></i>
											</a>
										</div>	
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="select_top top_2">
						<form action="<?php echo base_url('attendance_reversal/rta_validation_all'); ?>" method="post">
							<div class="row">
								<div class="col-md-3">
									<div class="dropdown_widget form-group">
										<input type="text" name="date_for" id="date_for" class="form-control datepicker due_date-cal" value="<?php echo $date_for_selected; ?>" readonly require>
									</div>
								</div>
								<div class="col-md-3">
									<div class="dropdown_widget form-group">
										<input type="text" name="date_for_to" id="date_for_to" class="form-control datepicker due_date-cal" value="<?php echo $date_for_to_selected; ?>" readonly require>
									</div>
								</div>
								
								<div class="col-md-3">
									<div class="dropdown_widget form-group">
										<select class="form-control" name="office_location" id="office_location" require>
											<option value="">--Select Location--</option>
											<?php foreach ($location_list as $loc) : ?>
												<?php
												$sCss = "";
												if ($loc['abbr'] == $office_location) $sCss = "selected";
												?>
												<option value="<?php echo $loc['abbr']; ?>" <?php echo $sCss; ?>><?php echo $loc['office_name']; ?></option>
											<?php endforeach; ?>
										</select>
									</div>
								</div>
								<div class="col-md-3">
									<div class="dropdown_widget form-group">
										<select class="form-control" name="dept_id" id="fdept_id">
											<option value=''> Select a department</option>
											<?php foreach ($department_list as $dept) : ?>
												<?php
												$sCss = "";
												if ($dept['id'] == $dept_data) $sCss = "selected";
												?>
												<option value="<?php echo $dept['id']; ?>" <?php echo $sCss; ?>><?php echo $dept['description']; ?></option>
											<?php endforeach; ?>
										</select>
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group margin_all">
										<select class="form-control" name="client_id" id="fclient_id">
											<option value=''>Select Client</option>
											<?php foreach ($client_list as $client) : ?>
												<?php
												$sCss = "";
												if ($client->id == $cValue) $sCss = "selected";
												?>
												<option value="<?php echo $client->id; ?>" <?php echo $sCss; ?>><?php echo $client->shname; ?></option>
											<?php endforeach; ?>
										</select>
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group margin_all">
										<select class="form-control" name="status_rta" id="status_rta">
											<?php
											$sts = array(0 => 'Select Status', 1 => 'Pending', 2 => 'Approved L1', 3 => 'L2 Approve', 4 => 'Reject');
											foreach ($sts as $key => $st) : ?>
												<?php
												$sCss = "";
												if ($key == $status_rta) $sCss = "selected";
												?>
												<option value="<?php echo $key; ?>" <?php echo $sCss; ?>><?php echo $st; ?></option>
											<?php endforeach; ?>
										</select>
									</div>
								</div>
								<div class="col-md-3">
									<div class="dropdown_widget">
										<input type="submit" name="search" id="search" value="Search" class="btn-sm btn_padding filter_btn_blue save_common_btn">
									</div>
								</div>
							</div>
						</form>
					</div>
				</div>
				<div class="white_widget padding_3 approval_widget approval_widget_new common_table_widget">
					<div class="table-widget report_hirarchy">
						<div class="right-hr margin_3">
							<table id="example" class="table table-bordered table-striped">
								<thead>
									<tr>
										<th class="table_width_sr">Date</th>
										<th style="display:none">Date('Y/m/d')</th>
										<th class="employee_td">Name</th>
										<th class="table_width">MWP ID</th>
										<th class="table_width">Status</th>
										<th class="table_width1">L1/L2</th>
										<th class="table_width1">Loc/Dept</th>
										<th class="table_width1">Cli/Pro</th>
										<th class="table_width">Shift</th>
										<th class="table_width">MWP</th>
										<th class="table_width">Dialer</th>
										<th class="table_width">Final</th>
										<!-- <th>Action</th> -->
									</tr>
								</thead>
								<tbody>
									<?php foreach ($attendance_data_list as $attendance_key => $attendance_value) {
										$rdate = $attendance_value['rDate'];
										//echo'<pre>';print_r($attendance_value);
									?>
										<tr>
											<td>
												<span class="blue-title">
													<?php echo date('d', strtotime($rdate)); ?><br>
													<span><?php echo date('D', strtotime($rdate)); ?></span>
													<?php //echo $date_for_selected;
													?>
												</span>
											</td>
											<td style="display:none;"><?php echo date('Y/m/d', strtotime($rdate)); ?></td>
											<td>
												<?php echo $attendance_value['fname']; ?> <?php echo $attendance_value['lname']; ?><br>
											</td>
											<td><?php echo $attendance_value['fusion_id']; ?></td>
											<td>
													<?php //echo $attendance_value['disposition_local'];
													?>
													<?php
													$type_name = ($attendance_value['ar_type_name'] != '') ? '/' . $attendance_value['ar_type_name'] : '';

													if ($attendance_value['rq_status'] != '' && $attendance_value['is_approve_l1'] == 0 && $attendance_value['is_approve_rta'] == 0) {
														echo $attendance_value['disposition_local'] . $type_name . ' - Pending For Approval';
													} elseif ($attendance_value['is_approve_l1'] == '1' && $attendance_value['is_approve_rta'] == 0) {
														echo $attendance_value['disposition_local'] . $type_name . ' - ' . ' Approved';
													} elseif ($attendance_value['is_approve_rta'] == '1') {
														echo $attendance_value['disposition_local'] . $type_name . ' - ' . ' Approved';
													} elseif ($attendance_value['leave_status'] == '0') {
														$th = ($attendance_value['applied_type'] == 'Half') ? 'HD' : '';
														echo $attendance_value['disposition_local'] . '/' . $th . ' ' . $attendance_value['leave_type'] . ' Applied';
													} elseif ($attendance_value['leave_status'] == '1') {
														$th = ($attendance_value['applied_type'] == 'Half') ? 'HD' : '';
														echo $attendance_value['disposition_local'] . '/' . $th . ' ' . $attendance_value['leave_type'] . ' Approved';
													} else {
														echo $attendance_value['disposition_local'] . $type_name;
													}
													if ($status_rta == 4) {
														echo '<br>Rejected ' . $attendance_value['rq_reason'];
													}
													?><br>
												<br>
											</td>
											<td>
												<?php echo $attendance_value['asign_tl']; ?><br>
												<?php echo $attendance_value['l2_name']; ?>
											</td>
											<td>
												<?php echo $attendance_value['office_id']; ?><br>
												<?php echo $attendance_value['dept_name']; ?>
											</td>
											<td>
												<?php echo $attendance_value['process_name']; ?><br>
												<?php echo $attendance_value['client_name']; ?>
											</td>
											<td>
												<span class="small_green_color"><?php if (!empty($attendance_value['sch_in'])) {
																					echo date('H:i:s', strtotime($attendance_value['sch_in']));
																				} ?> - <?php if (!empty($attendance_value['sch_out'])) {
																												echo date('H:i:s', strtotime($attendance_value['sch_out']));
																											} ?></span><br>
												<span class="total_hrs">
													<span class="small_green_color"><?php if (!empty($attendance_value['sch_total'])) {
																						echo date('H:i:s', strtotime($attendance_value['sch_total']));
																					} ?></span>
												</span>
											</td>
											<td>
												<span class="small_red_color"><?php if (!empty($attendance_value['login_time_local_min'])) {
																					echo date('H:i:s', strtotime($attendance_value['login_time_local_min']));
																				} ?> - <?php if (!empty($attendance_value['logout_time_local_max'])) {
																												echo date('H:i:s', strtotime($attendance_value['logout_time_local_max']));
																											} ?></span><br>
												<span class="total_hrs">
													<span class="small_red_color"><?php if (!empty($attendance_value['logged_in_hours'])) {
																						echo date('H:i:s', strtotime($attendance_value['logged_in_hours']));
																					} ?></span>
												</span>
											</td>
											<td>
												<span class="small_red_color"><?php if (!empty($attendance_value['dailer_login_time'])) {
																					echo date('H:i:s', strtotime($attendance_value['dailer_login_time']));
																				} ?> - <?php if (!empty($attendance_value['dailer_logout_time'])) {
																												echo date('H:i:s', strtotime($attendance_value['dailer_logout_time']));
																											} ?></span><br>
												<span class="total_hrs">
													<span class="small_red_color"><?php if (!empty($attendance_value['dailer_staffed_time'])) {
																						echo date('H:i:s', strtotime($attendance_value['dailer_staffed_time']));
																					} ?> </span>
												</span>
											</td>
											<?php
											$rq_start_date = ($attendance_value['rq_start_date'] != '') ? date('H:i', strtotime($attendance_value['rq_start_date'])) : '';
											$rq_end_date = ($attendance_value['rq_end_date'] != '') ? date('H:i', strtotime($attendance_value['rq_end_date'])) : '';
											if ($attendance_value['apr_start_date'] != '') {
												$rq_start_date = ($attendance_value['apr_start_date'] != '') ? date('H:i', strtotime($attendance_value['apr_start_date'])) : '';
												$rq_end_date = ($attendance_value['apr_end_date'] != '') ? date('H:i', strtotime($attendance_value['apr_end_date'])) : '';
											}
											?>
											<td>
												<?php if ($rq_start_date != "") { ?>
													<?php echo $rq_start_date . ' - ' . $rq_end_date; ?><br>
													<?php echo get_time_diff($rq_start_date, $rq_end_date); ?>
												<?php } else { ?>
													<?php if (!empty($attendance_value['dailer_login_time'])) {
																echo date('H:i:s', strtotime($attendance_value['dailer_login_time']));
															} ?> - <?php if (!empty($attendance_value['dailer_logout_time'])) {
																							echo date('H:i:s', strtotime($attendance_value['dailer_logout_time']));
																						} ?><br>
													<?php if (!empty($attendance_value['dailer_staffed_time'])) {
																echo date('H:i:s', strtotime($attendance_value['dailer_staffed_time']));
															} ?>
												<?php } ?>
											</td>
										</tr>
									<?php } ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!--Start Information Popup design  dialer #C-zentrix -->
	<div class="modal fade model_new" id="myModal_info" role="dialog">
		<div class="modal-dialog info_widget">
			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close close_new" data-dismiss="modal"></button>
					<h4 class="modal-title">Information</h4>
				</div>
				<div class="modal-body">
					<div class="information_scroll">
						<div class="table-widget common_table_widget">
							<table class="table table-bordered table-striped">
								<thead>
									<tr>
										<th class="table_width1">Status</th>
										<th class="table_width1">Validation</th>
										<th>Definition</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td>Present</td>
										<td>p</td>
										<td>
											When Agent is scheduled and logged in to dialer (Staff time 7:30hrs)
										</td>
									</tr>
									<tr>
										<td>Absent</td>
										<td>AB</td>
										<td>
											When Agent is scheduled but did not turn up to Office
										</td>
									</tr>
									<tr>
										<td>Week Off</td>
										<td>WO</td>
										<td>
											Scheduled Week Off
										</td>
									</tr>
									<tr>
										<td>Week Off OT</td>
										<td>WOT</td>
										<td>
											Approval for Week off OT
										</td>
									</tr>
									<tr>
										<td>Week Off Present</td>
										<td>WOP</td>
										<td>
											Agent Present on WO with Manager Approval, then we mark as a Week off Present with 7:30 staff time less then 7:30hrs it's WO.
										</td>
									</tr>
									<tr>
										<td>Leave</td>
										<td>Leave</td>
										<td>
											Agent scheduled for a Leave
										</td>
									</tr>
									<tr>
										<td>Absconding</td>
										<td>ABS</td>
										<td>
											Agent is absent for more than 5 days
										</td>
									</tr>
									<tr>
										<td>Transferred Out</td>
										<td>Trans Out</td>
										<td>
											Agent Transferred out from any other Process
										</td>
									</tr>
									<tr>
										<td>Attrition</td>
										<td>ATT</td>
										<td>
											Confirmation received agent is attired
										</td>
									</tr>
									<tr>
										<td>X</td>
										<td>X</td>
										<td>
											Once Attired mark X for remaining days of the month
										</td>
									</tr>
									<tr>
										<td>Half Day</td>
										<td>HD</td>
										<td>
											Logged in for more than or equal to 4 hours and lesser than 7.5 hours, agent will be mark as "Half Day", will be consider under average login for the day.
										</td>
									</tr>
									<tr>
										<td>Absent-Login Defaulter</td>
										<td>A_LD</td>
										<td>
											Below 4 hours login will be considered as Absent login defaulter (A_LD).
										</td>
									</tr>
									<tr>
										<td>Late Present</td>
										<td>Tardy</td>
										<td>
											Adherence Late
										</td>
									</tr>
									<tr>
										<td>Absent</td>
										<td>ADH</td>
										<td>
											4 days of Adherence Late(Tardy) / LOP
										</td>
									</tr>
									<tr>
										<td>Furlough</td>
										<td>Furl</td>
										<td>
											Not active in production but still part of the process or company ( OB ma'am approval required )
										</td>
									</tr>
									<tr>
										<td>Production</td>
										<td>-</td>
										<td>
											After 3 days of FHD, production will begin.
										</td>
									</tr>
									<tr>
										<td>Attendance rectification</td>
										<td>-</td>
										<td>
											Attendance rectification TAT is 48 hrs. for Normal days and 24 hrs. is for the last day of pay cycle.
										</td>
									</tr>
									<tr>
										<td>SME Oyo IBD</td>
										<td>-</td>
										<td>
											70% as support and 30% logged in
										</td>
									</tr>
									<tr>
										<td>Unplan leave</td>
										<td>-</td>
										<td>
											No Week off changes will be expected in the middle of the week once the roster is released, any unplanned leave in the middle of the week will be considered as absent in attendance however they could apply for leave in MWP if the manager approved and this will be taken directly by payroll.
										</td>
									</tr>
									<tr>
										<td>Production</td>
										<td>-</td>
										<td>
											RTA attendance is applicable only for Production agents.
										</td>
									</tr>
									<tr>
										<td>Attendance marking Metrix</td>
										<td>-</td>
										<td>
											RTA will consider dialer report to mark the attendance on daily basis for Non Dialer considered MWP and OPS attendance only.
										</td>
									</tr>
									<tr>
										<td>Exception/BOD</td>
										<td>-</td>
										<td>
											Any employees unable to complete the production hours for any reason (genuine issue) (technical/system issue/client-side issue and etc.) must be notified at the end of the day to RTA with respective team's ( E.g. IT / Training / Quality ) approval to incorporate those hours in attendance.
										</td>
									</tr>
									<tr>
										<td>emergency swap</td>
										<td>-</td>
										<td>
											Only 10% week off swap or shift swap will be entertained in a week based on the emergency situation.
										</td>
									</tr>
									<tr>
										<td>SPOC</td>
										<td>-</td>
										<td>
											We will only entertain SPOC mail communication.
										</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!--end Information Popup design-->
	<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
	<script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap.min.js"></script>
	<script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
	<script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>
	<script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.print.min.js"></script>
	<script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.colVis.min.js"></script>
	<script>
		$(document).ready(function() {
			$("#date_for").datepicker();
			$("#date_for_to").datepicker();
			var table = $('#example').DataTable({
				lengthChange: false,
				exportOptions: {
					columns: [2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12]
				},
				buttons: ['', 'excel', '', 'colvis']
			});
			table.buttons().container()
				.appendTo('#example_wrapper .col-sm-6:eq(0)');
		});
	</script>
	
</body>

</html>