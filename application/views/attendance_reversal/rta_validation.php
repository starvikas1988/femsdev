<!DOCTYPE html>
<html lang="en">

<head>
	<title>RTA Validation</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/attendance_reversal/css/custom.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/attendance_reversal/css/app.min.css">
	<link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap.min.css">
	<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.bootstrap.min.css">
</head>

<body>
	<div class="main">
		<div class="wrap">
			<div class="gimini-main">
				<div class="common-top3">
					<div class="white_widget padding_3">
						<div class="menu_widget avail_widget_br">
							<div class="row">
								<div class="col-sm-8">
									<?php include_once('aside_menu.php'); ?>
								</div>
								<div class="col-sm-4">
									<div class="right_side">
										<div class="select_top minus_new_top">
											<div class="approval_new">
												<a href="#" onclick="Download_file('<?php echo base_url('attendance_reversal/rta_approve_list_download'); ?>')" class="btn btn_padding filter_btn">
													Download
												</a>
											</div>
											<div class="approval_new btn_left">
												<a href="<?php echo base_url('attendance_reversal/approval_excel_upload') ?>" class="btn btn_padding filter_btn">
													Upload
												</a>
											</div>
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
						<div class="top_2">
							<form id="frm_dwn" action="<?php echo base_url('attendance_reversal/l2_approval'); ?>" method="post">
								<div class="row">
									<div class="col-md-2">
										<div class="dropdown_widget">
											<input type="text" name="date_for" id="date_for" class="form-control datepicker due_date-cal" value="<?php echo $date_for_selected; ?>" readonly require>
										</div>
									</div>
									<div class="col-md-2">
										<div class="dropdown_widget">
											<input type="text" name="date_for_to" id="date_for_to" class="form-control datepicker due_date-cal" value="<?php echo $date_for_to_selected; ?>" readonly require>
										</div>
									</div>
									<div class="col-md-3">
										<div class="dropdown_widget">
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
									<!-- <div class="col-md-3">
									<div class="dropdown_widget">
										<select class="form-control" name="dept_id" id="fdept_id" >
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
								</div> -->
									<div class="col-md-2">
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
									<div class="col-md-2">
										<div class="dropdown_widget">
											<input type="button" onclick="search_data('<?php echo base_url('attendance_reversal/l2_approval'); ?>')" name="search" id="search" value="Search" class="btn-sm btn_padding filter_btn_blue save_common_btn">
										</div>
									</div>
								</div>
							</form>
						</div>
					</div>

					<form name="frm" id="frm" method="post" action="<?php echo base_url(); ?>/attendance_reversal/multi_approve_rta">
						<div class="top_2">
							<div class="common-main">
								<div class="row">
									<div class="col-sm-12">
										<div class="common-repeat">
											<div class="white_widget padding_3 approval_widget approval_widget_new">
												<div class="table-widget report_hirarchy">
													<div class="right-hr margin_3 common_table_widget">
														<table id="example" class="table table-bordered table-striped">
															<thead>
																<tr>
																	<th class="table_width_srt"><input type="Checkbox" name="checkAll" id="checkAll"></th>
																	<th class="table_width_sr">Date</th>
																	<th class="employee_td">Name</th>
																	<th class="table_width1">Status</th>
																	<th class="table_width1">L1/L2</th>
																	<th class="table_width1">Loc/Dept</th>
																	<th class="table_width1">Cli/Pro</th>
																	<th class="table_width">Shift</th>
																	<th class="table_width">MWP</th>
																	<th class="table_width">Dialer</th>
																	<th class="table_width">Final</th>
																	<th class="table_width leave_columns_fixed">Action</th>
																</tr>
															</thead>
															<tbody>
																<?php foreach ($attan_dtl as $k => $rows) {
																	$p = $k + 1;
																	$applied_id = $rows['applied_id'];
																	$revasal_applied_date = $rows['rDate'];
																	//echo $revasal_applied_date;

																	$date1 = $rows['rDate'] . " 00:00:00";
																	$date2 = date('Y-m-d H:i:s');
																	$timestamp1 = strtotime($date1);
																	$timestamp2 = strtotime($date2);
																	$diffhr = ceil(($timestamp2 - $timestamp1) / (60 * 60));
																?>
																	<tr>
																		<td class="check_one">
																			<?php
																			//if($diffhr<=48){
																			if ($rows['is_approve_rta'] != '1') { ?>
																				<input type="Checkbox" name="app_ids[]" id="app_ids_<?php echo $applied_id; ?>" value="<?php echo $applied_id . '@' . $rows['user_id'] . '@' . $rows['rq_start_date'] . '@' . $rows['rq_end_date']; ?>" class="chk" onchange="multi_approve(this);">
																			<?php // }
																			} ?>
																		</td>
																		<td>
																			<span class="blue-title">
																				<?php echo date('d', strtotime($rows['rDate'])); ?><br>
																				<span><?php echo date('D', strtotime($rows['rDate'])); ?></span>
																			</span>
																		</td>
																		<td>
																			<?php echo $rows['fname'] . ' ' . $rows['lname']; ?><br>
																			<?php echo $rows['fusion_id']; ?>
																		</td>
																		<?php
																		$mwpmin = ($rows['login_time_local_min'] != '') ? date('H:i', strtotime($rows['login_time_local_min'])) : '';
																		$mwpmax = ($rows['logout_time_local_max'] != '') ? date('H:i', strtotime($rows['logout_time_local_max'])) : '';
																		$schin = $rows['sch_in'];
																		$schout = $rows['sch_out'];
																		$din = ($rows['dailer_login_time'] != '') ? date('H:i', strtotime($rows['dailer_login_time'])) : '';
																		$dout = ($rows['dailer_logout_time'] != '') ? date('H:i', strtotime($rows['dailer_logout_time'])) : '';
																		$actualtime = ($din != '') ? $rows['dailer_staffed_time'] : $mwpmin . ' - ' . $mwpmax;
																		$applied_id = $rows['applied_id'];
																		$user_id = $rows['user_id'];
																		$finst = ($rows['apr_start_date'] != '') ? date('H:i', strtotime($rows['apr_start_date'])) : '';
																		$finend = ($rows['apr_end_date'] != '') ? date('H:i', strtotime($rows['apr_end_date'])) : '';
																		$cl = set_color_condition($rows['disposition_local']);
																		if (($rows['rq_status'] != '') && ($rows['rq_status'] >= '1')) {
																			$cl = 'dark-yellow-left';
																		}
																		?>
																		<td><span class="small_blue_color">
																				<?php
																				$type_name = ($rows['ar_type_name'] != '') ? '/' . $rows['ar_type_name'] : '';
																				if ($rows['rq_status'] != '' && $rows['is_approve_l1'] == 0 && $rows['is_approve_rta'] == 0) {
																					echo $rows['disposition_local'] . $type_name . ' - Pending For Approval';
																				} elseif ($rows['is_approve_l1'] == '1' && $rows['is_approve_rta'] == 0) {
																					echo $rows['disposition_local'] . $type_name . ' - ' . 'L1 Approved';
																				} elseif ($rows['is_approve_rta'] == '1') {
																					echo $rows['disposition_local'] . $type_name . ' - ' . 'RTA Approved';
																				} elseif ($rows['leave_status'] == '0') {
																					echo $rows['disposition_local'] . '/' . $rows['leave_type'] . ' Applied';
																				} elseif ($rows['leave_status'] == '1') {
																					echo $rows['disposition_local'] . '/' . $rows['leave_type'] . ' Approved';
																				} else {
																					echo $rows['disposition_local'] . $type_name;
																				}
																				?><br>
																			</span><br>
																		</td>
																		<td>
																			<small><?php echo $rows['asign_tl']; ?></small><br>
																			<small><?php echo $rows['l2_name']; ?></small>
																		</td>
																		<td>
																			<small><?php echo $rows['office_id']; ?></small><br>
																			<small><?php echo $rows['dept_name']; ?></small>
																		</td>
																		<td>
																			<small><?php echo $rows['client_name']; ?></small><br>
																			<small><?php echo $rows['process_name']; ?></small>
																		</td>
																		<td>
																			<span class="small_green_color"><?php echo $rows['sch_in'] . ' - ' . $rows['sch_out']; ?></span><br>
																			<span class="total_hrs">
																				<span class="small_green_color"><?php echo get_time_diff($rows['sch_in'], $rows['sch_out']); ?></span>
																			</span>
																		</td>
																		<td>
																			<span class="small_red_color"><?php echo $mwpmin . ' - ' . $mwpmax; ?></span><br>
																			<span class="total_hrs">
																				<span class="small_red_color"><?php echo get_time_diff($mwpmin, $mwpmax); ?></span>
																			</span>
																		</td>
																		<td>
																			<span class="small_red_color"><?php echo $din . ' - ' . $dout; ?></span><br>
																			<span class="total_hrs">
																				<span class="small_red_color"><?php echo $rows['dailer_staffed_time']; ?></span>
																			</span>
																		</td>
																		<td>
																			<strong><?php echo $finst . ' - ' . $finend; ?></strong><br>
																			<strong><?php echo get_time_diff($finst, $finend); ?></strong>
																		</td>
																		<td class="leave_columns_fixed action_column_right">
																			<?php
																			//if($diffh<=48){
																			if ($rows['is_approve_rta'] != '1' && $rows['dept_name'] == 'Operations') {
																				$inst = $rows['apr_start_date'];
																				$enst = $rows['apr_end_date'];
																				$type = $rows['ar_type'];

																				$rq_start_time = $rows['rq_start_date'];
																		$rq_end_time = $rows['rq_end_date'];
																		$timestamp_start = strtotime($rq_start_time);
																		$rq_start_time_date = date('H:i', $timestamp_start);

																		$timestamp_end = strtotime($rq_end_time);
																		$rq_end_time_date = date('H:i', $timestamp_end);

																			?>
																				<a class="btn no_padding" title="Approve Reversal" onclick="set_entry_id('<?php echo $applied_id; ?>','<?php echo $user_id; ?>','<?php echo $inst; ?>','<?php echo $enst; ?>','<?php echo $type; ?>','<?php echo $rq_start_time_date; ?>','<?php echo$rq_end_time_date; ?>','<?php echo $revasal_applied_date; ?>');" data-toggle="modal" data-target="#myModal">
																					<img src="<?php echo base_url(); ?>assets_home_v3/images/approved.svg" alt="">
																				</a>
																				<a class="btn no_padding btn_left" title="Reject Reversal" onclick="set_entry_id('<?php echo $applied_id; ?>','<?php echo $user_id; ?>','<?php echo $inst; ?>','<?php echo $enst; ?>','<?php echo $type; ?>');" data-toggle="modal" data-target="#myModal1">
																					<img src="<?php echo base_url(); ?>assets_home_v3/images/cancel_big.svg" alt="">
																				</a>
																			<?php //}
																			}
																			$comment = "";
																			foreach ($rows['rq_workflow'] as $key => $rwc) { ?>
																				<?php $comment .= '<p>' . $rwc['comment'] . '</p>'; ?>
																			<?php } ?>
																			<a class="btn no_padding btn_left" title="Information" onclick="open_infobox('<?php echo $comment; ?>');" class="icon-big flip" data-toggle="modal" data-target="#manager_information">
																				<img src="<?php echo base_url(); ?>assets_home_v3/images/global_info_big.svg" alt="">
																			</a>
																		</td>
																	</tr>
																<?php } ?>
															</tbody>
														</table>
														<div id="Display_butt" class="all_aprove" style="display:none;">
															<div class="comment_widget">
																<labe>Comments</label>
																	<textarea type="text" name="multi_approval_comment" id="multi_approval_comment" class="form-control"></textarea>
															</div>
															<button id="aprrove_btn" type="submit" name="approve" value="approve" class="btn btn_padding filter_btn_blue save_common_btn btn-sm">Approve</button>
															<button id="Cancel_btn" type="submit" name="reject" value="reject" class="btn btn_padding filter_btn save_common_btn btn-sm">Reject</button>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
		<div id="myModal" class="modal fade model_new" role="dialog">
			<div class="modal-dialog">
				<div class="modal-content">
					<div id="type1_from">
						<form method="post" action="<?php echo base_url(); ?>attendance_reversal/approve_rta" id="ar_form" enctype="multipart/form-data">
							<div class="modal-header">
								<button type="button" class="close close_new" data-dismiss="modal">
								</button>
								<h4 class="modal-title">L2 Approval</h4>
							</div>
							<div class="modal-body filter-widget">
								<input type="hidden" id="apply_agent_id" name="apply_agent_id" value="<?php echo $agent_id; ?>">
								<input type="hidden" name="aprovid" id="aprovid" value="">
								<input type="hidden" name="revasal_applied_date" id="revasal_applied_date">
								<div id="start_tm" class="row" style="padding:3px 0px;">
									<div class="form-group">
										<label class="col-md-4" style="line-height:37px;">Start Time(Local Time Zone)</label>
										<div class="col-md-8">
											<!-- <input type="datetime-local" id="ar_start_time" name="ar_start_time" class="form-control"> -->
											<input type="time" id="ar_start_time" name="ar_start_time" class="form-control">
										</div>
									</div>
								</div>
								<div id="end_tm" class="row" style="padding:3px 0px;">
									<div class="form-group">
										<label class="col-md-4" style="line-height:37px;">End Time(Local Time Zone)</label>
										<div class="col-md-8">
											<!-- <input type="datetime-local" id="ar_end_time" name="ar_end_time" class="form-control"> -->
											<input type="time" id="ar_end_time" name="ar_end_time" class="form-control">
										</div>
									</div>
								</div>
								<div class="row" style="padding:3px 0px;">
									<div class="form-group">
										<label class="col-md-4">Reason</label>
										<div class="col-md-8">
											<textarea class="form-control" name="reason" required></textarea>
										</div>
									</div>
								</div>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn_padding filter_btn save_common_btn btn-sm" data-dismiss="modal">Cancel</button>
								<button id="sub_but" type="submit" class="btn btn_padding filter_btn_blue save_common_btn btn-sm">Save</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
		<div id="myModal1" class="modal fade model_new" role="dialog" style="font-size:90%; ">
			<div class="modal-dialog">
				<div class="modal-content">
					<div id="type1_from">
						<form method="post" action="<?php echo base_url(); ?>attendance_reversal/cancel_rta" id="ar_form" enctype="multipart/form-data">
							<div class="modal-header">
								<button type="button" class="close close_new" data-dismiss="modal">
								</button>
								<h4 class="modal-title">RTA Reject</h4>
							</div>
							<div class="modal-body filter-widget">
								<div class="row" style="padding:3px 0px;">
									<!-- <div class="form-group">
                            <label class="col-md-4">
								Employee Name
							</label>
                            <div class="col-md-8">
								<label>
									<?php echo get_username(); ?>
								</label>
								<input type="hidden" name="applied_person_name" class="form-control" id="applied_person_name" value="<?php echo get_username(); ?>">
							</div>
							
                        </div>-->
								</div>
								<input type="hidden" name="aprovid" id="aprovid1" value="">
								<input type="hidden" id="cancel_agent_id" name="cancel_agent_id" value="<?php echo $agent_id; ?>">
								<div class="row" style="padding:3px 0px;">
									<div class="form-group">
										<div class="col-md-12">
											<div class="form-group">
												<label>Reason</label>
												<textarea name="reason" id="reason" class="form-control"></textarea>
											</div>
										</div>
									</div>
								</div>
								<div class="row" style="padding:3px 0px;">
									<div class="form-group">
										<div class="col-md-12">
											<div class="alert alert-primary padding_1" role="alert">
												<p>Are You Sure You Want To Reject Attendance Reversal</p>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn_padding filter_btn save_common_btn btn-sm" data-dismiss="modal">No</button>
								<button id="sub_but" type="submit" class="btn btn_padding filter_btn_blue save_common_btn btn-sm">Yes</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
		<!--Start Information Popup design    dialer #C-zentrix -->
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
											<th>Status</th>
											<th>Validation</th>
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
		<!--start Information Popup design-->
		<div class="modal fade model_new" id="manager_information" role="dialog">
			<div class="modal-dialog">
				<!-- Modal content-->
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close close_new" data-dismiss="modal"></button>
						<h4 class="modal-title">Information </h4>
					</div>
					<div class="modal-body">
						<div id="msg_body" class="content_widget">
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn_padding filter_btn save_common_btn" data-dismiss="modal">Close</button>
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
					iDisplayLength: 20,
					stateSave: true,

					 buttons: [
        {
            extend: 'excel',
            exportOptions: {
                columns: ':not(:last-child)' // Exclude the last column
            }
        },
        'colvis'
    ]
				});
				table.buttons().container()
					.appendTo('#example_wrapper .col-sm-6:eq(0)');
			});

			function Download_file(url) {
				$('#frm_dwn').attr('action', url);
				$('#frm_dwn').submit();
			}

			function search_data(url) {
				$('#frm_dwn').attr('action', url);
				$('#frm_dwn').submit();
			}
		</script>
		<script>
			$(document).ready(function() {
				$("#flip").click(function() {
					$(".down_arrow").hide();
					$(".up_arrow").show();
				});
				$("#up_flip").click(function() {
					$(".down_arrow").show();
					$(".up_arrow").hide();
				});
				$("#up_flip").click(function() {
					$("#panel").hide();
				});
				$("#checkAll").click(function() {
					$('input:checkbox').not(this).prop('checked', this.checked);
					sz = $('.chk:checked').length;
					if (sz > 0) {
						$('#Display_butt').css('display', 'block');
					} else {
						$('#Display_butt').css('display', 'none');
					}
					//
				});
			});

			function multi_approve(obj) {
				if ($(obj).is(':checked')) {} else {
					$('#checkAll').prop('checked', false);
				}
				sz = $('.chk:checked').length;
				if (sz > 0) {
					$('#Display_butt').css('display', 'block');
				} else {
					$('#Display_butt').css('display', 'none');
				}
			}
		</script>
		<script>
		</script>
		<script>
			function set_entry_id(apid, uid, fdate, edate, typ, rq_start_time_date, rq_end_time_date,revasal_applied_date) {
				//alert(fdate+"********"+edate);
				$('#aprovid').val(apid);
				$('#aprovid1').val(apid);
				$('#apply_agent_id').val(uid);
				$('#cancel_agent_id').val(uid);
				$('#ar_start_time').val(rq_start_time_date);
				$('#ar_end_time').val(rq_end_time_date);
				$('#revasal_applied_date').val(revasal_applied_date);
				if (typ == 4 || typ == 6) {
					$('#start_tm').css('display', 'none');
					$('#end_tm').css('display', 'none');
				} else {
					$('#start_tm').css('display', 'block');
					$('#end_tm').css('display', 'block');
				}
			}
		</script>
		<script>
			$('.responsive').slick({
				dots: false,
				infinite: false,
				speed: 300,
				slidesToShow: 1,
				slidesToScroll: 1,
				responsive: [{
						breakpoint: 1024,
						settings: {
							slidesToShow: 1,
							slidesToScroll: 1,
							infinite: true,
							dots: false
						}
					},
					{
						breakpoint: 600,
						settings: {
							slidesToShow: 1,
							slidesToScroll: 1
						}
					},
					{
						breakpoint: 480,
						settings: {
							slidesToShow: 1,
							slidesToScroll: 1
						}
					}
				]
			});
		</script>
		<script>
			/*var ctxBAR = document.getElementById("bar-chart5");
			var myBarChart_dailyVisitor = new Chart(ctxBAR, {
				type: 'line',
				stack: 'combined',
				data: {
					labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
					datasets: [{
						label: "Visitors",
						data: [12, 19, 15, 20, 20, 10],
						backgroundColor: [
							'rgba(55, 74, 216, 0.9)'
						],
						borderColor: [
							'rgba(55, 74, 216, 0.9)'
						],
						borderWidth: 3
					}]
				},
				options: {
					legend: {
						display: false,
						position: 'right'
					},
					title: {
						display: true,
						lineHeight: 2,
						text: ""
					},
					tooltips: {
						callbacks: {
							label: function(tooltipItem) {
								return tooltipItem.yLabel + '';
							}
						}
					},
					maintainAspectRatio: false,
					responsive: true,
					scales: {
						xAxes: [{}],
						yAxes: [{
							display: true,
							ticks: {
								callback: function(value, index, values) {
									return value + '';
								},
								beginAtZero: true,
							}
						}]
					},
					plugins: {
						datalabels: {
							anchor: 'end',
							align: 'top',
							formatter: (value, ctx) => {
								return value + '';
							},
							font: {
								size: 9,
								weight: 'bold'
							}
						}
					}
				},
			});*/
		</script>
		<script>
			$('.responsive').slick({
				dots: false,
				infinite: false,
				speed: 300,
				slidesToShow: 1,
				slidesToScroll: 1,
				responsive: [{
						breakpoint: 1024,
						settings: {
							slidesToShow: 1,
							slidesToScroll: 1,
							infinite: true,
							dots: false
						}
					},
					{
						breakpoint: 600,
						settings: {
							slidesToShow: 1,
							slidesToScroll: 1
						}
					},
					{
						breakpoint: 480,
						settings: {
							slidesToShow: 1,
							slidesToScroll: 1
						}
					}
				]
			});
		</script>
		<script>
			/*var ctxBAR = document.getElementById("bar-chart5");
			var myBarChart_dailyVisitor = new Chart(ctxBAR, {
				type: 'line',
				stack: 'combined',
				data: {
					labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
					datasets: [{
						label: "Visitors",
						data: [12, 19, 15, 20, 20, 10],
						backgroundColor: [
							'rgba(55, 74, 216, 0.9)'
						],
						borderColor: [
							'rgba(55, 74, 216, 0.9)'
						],
						borderWidth: 3
					}]
				},
				options: {
					legend: {
						display: false,
						position: 'right'
					},
					title: {
						display: true,
						lineHeight: 2,
						text: ""
					},
					tooltips: {
						callbacks: {
							label: function(tooltipItem) {
								return tooltipItem.yLabel + '';
							}
						}
					},
					maintainAspectRatio: false,
					responsive: true,
					scales: {
						xAxes: [{}],
						yAxes: [{
							display: true,
							ticks: {
								callback: function(value, index, values) {
									return value + '';
								},
								beginAtZero: true,
							}
						}]
					},
					plugins: {
						datalabels: {
							anchor: 'end',
							align: 'top',
							formatter: (value, ctx) => {
								return value + '';
							},
							font: {
								size: 9,
								weight: 'bold'
							}
						}
					}
				},
			});*/
			function open_infobox(id) {
				$('#msg_body').html(id);
			}
		</script>
</body>

</html>