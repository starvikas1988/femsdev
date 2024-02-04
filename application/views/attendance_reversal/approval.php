<!DOCTYPE html>
<html lang="en">

<head>
	<title>HR Attendance</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/attendance_reversal/css/custom.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/attendance_reversal/slick/slick.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/attendance_reversal/slick/slick-theme.css">
</head>

<body>
	<style>
		.common-left-new {
			display: flex;
		}

		.excel-btn {
			margin-left: 10px;
			background: #011dedb5;
			padding: 5px 8px 5px 8px;
			color: #fff;
			border-radius: 50%;

		}

		.excel-btn:focus,
		.excel-btn:hover {
			color: #fff !important;
			background: #0f28e3;
			text-decoration: none !important;
		}
	</style>
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
				</div>
				<div class="common-top3">
					<div class="row align-items-center">
						<div class="col-sm-4">
						</div>
					</div>
				</div>

				<div class="common-main">
					<div class="row">
						<div class="col-sm-12">
							<div class="common-repeat">
								<div class="white_widget padding_3 approval_widget">
									<div class="metrix-widget all-gap all_new">
										<div class="common-left-new">
											<h2 class="heading-title2">
												<input type="Checkbox" name="checkAll" id="checkAll"> Checked ALL Approval
											</h2>
										</div>
									</div>
									<form name="frm" id="frm" method="post" action="<?php echo base_url(); ?>/attendance_reversal/multi_approve_l1">
										<div class="slider responsive">
											<!--start slider loop here-->
											<div>
												<div class="table-widget common_table_widget">
													<div class="right-hr">
														<table class="table table-bordered table-striped">
															<tbody>
																<?php foreach ($attan_dtl as $k => $rows) {
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
																			if ($diffhr <= (24 * 30)) {
																				if ($rows['is_approve_l1'] != '1') {	?>
																					<input type="Checkbox" name="app_ids[]" id="app_ids_<?php echo $applied_id; ?>" value="<?php echo $applied_id . '@' . $rows['user_id'] . '@' . $rows['rq_start_date'] . '@' . $rows['rq_end_date']; ?>" class="chk" onchange="multi_approve(this);">
																			<?php }
																			} ?>
																		</td>
																		<td>
																			<div class="blue-title">
																				<?php echo date('d', strtotime($rows['rDate'])); ?><br>
																				<span><?php echo date('D', strtotime($rows['rDate'])); ?></span>
																			</div>
																		</td>
																		<td>
																			<small>Name:</small>
																			<span class="small_blue_color"><?php echo $rows['fname'] . ' ' . $rows['lname']; ?></span><br>
																			<div class="total_hrs">
																				<span class="actual_new">Type -</span>
																				<span class="small_blue_color"><?php echo $rows['ar_type_name']; ?></span>
																			</div>
																		</td>
																		<td>
																			<small>From:</small>
																			<span class="small_blue_color"><?php echo ($rows['ar_type'] == 6 || $rows['rq_start_date'] == 4) ? '' : $rows['rq_start_date']; ?></span><br>
																			<div class="total_hrs">
																				<span class="actual_new">To -</span>
																				<span class="small_blue_color"><?php echo ($rows['ar_type'] == 6 || $rows['rq_start_date'] == 4) ? '' : $rows['rq_end_date']; ?></span>
																			</div>
																		</td>
																		<td>
																			<small>Applied:</small>
																			<span class="small_blue_color"><?php echo $rows['rDate']; ?></span><br>
																			<div class="total_hrs">
																				<span class="actual_new">Contact -</span>
																				<span class="small_blue_color"><?php echo $rows['rq_contact']; ?></span>
																			</div>
																		</td>
																		<td>
																			<small>Shift:</small>
																			<span class="small_blue_color"><?php echo $rows['sch_in'] . ' - ' . $rows['sch_out']; ?></span><br>
																			<div class="total_hrs">
																				<span class="actual_new">Expected -</span>
																				<span class="small_blue_color"><?php echo get_time_diff($rows['sch_in'], $rows['sch_out']); ?></span>
																			</div>
																		</td>
																		<?php
																		$mwpmin = ($rows['login_time_local_min'] != '') ? date('H:i', strtotime($rows['login_time_local_min'])) : '';
																		$mwpmax = ($rows['logout_time_local_max'] != '') ? date('H:i', strtotime($rows['logout_time_local_max'])) : '';
																		$din = ($rows['dailer_login_time'] != '') ? date('H:i', strtotime($rows['dailer_login_time'])) : '';
																		$dout = ($rows['dailer_logout_time'] != '') ? date('H:i', strtotime($rows['dailer_logout_time'])) : '';
																		$actualtime = ($din != '') ? $rows['dailer_staffed_time'] : $mwpmin . ' - ' . $mwpmax;

																		$user_id = $rows['user_id'];
																		?>
																		<td>
																			<small>MWP:</small>
																			<span class="small_green_color"><?php echo $mwpmin . ' - ' . $mwpmax; ?></span><br>
																			<div class="total_hrs">
																				<span class="actual_new">Actual -</span>
																				<span class="small_green_color"><?php echo get_time_diff($mwpmin, $mwpmax); ?></span>
																			</div>
																		</td>
																		<td>
																			<small>Dialer:</small>
																			<span class="small_red_color"><?php echo $din . ' - ' . $dout; ?></span><br>
																			<div class="total_hrs">
																				<span class="actual_new">Actual -</span>
																				<span class="small_red_color"><?php echo $rows['dailer_total_time']; ?></span>
																			</div>
																		</td>
																		<td>
																			<?php if ($rows['is_approve_l1'] != '1') {

																		$rq_start_time = $rows['rq_start_date'];
																		$rq_end_time = $rows['rq_end_date'];
																		$timestamp_start = strtotime($rq_start_time);
																		$rq_start_time_date = date('H:i', $timestamp_start);

																		$timestamp_end = strtotime($rq_end_time);
																		$rq_end_time_date = date('H:i', $timestamp_end);

											//echo $timeOnly; // This will output: 06:47:00
																				//if($diffhr<=48){
																			?>
																				<a class="btn no_padding" title="Approve Reversal" onclick="set_entry_id('<?php echo $applied_id; ?>','<?php echo $user_id; ?>','<?php echo $rq_start_time_date; ?>','<?php echo$rq_end_time_date; ?>','<?php echo $rows['fname'] ?>','<?php echo $rows['ar_type'] ?>','<?php echo $revasal_applied_date; ?>');" data-toggle="modal" data-target="#myModal">
																					<img src="<?php echo base_url();?>assets_home_v3/images/approved.svg" alt="">
																				</a>
																				<a class="btn no_padding btn_left" title="Cancel Reversal" onclick="set_entry_id('<?php echo $applied_id; ?>','<?php echo $user_id; ?>','<?php echo $rows['rq_start_date']; ?>','<?php echo $rows['rq_end_date']; ?>','<?php echo $rows['fname'] ?>','<?php echo $rows['ar_type'] ?>','<?php echo $revasal_applied_date; ?>');" data-toggle="modal" data-target="#myModal1">
																					<img src="<?php echo base_url();?>assets_home_v3/images/cancel_big.svg" alt="">																					
																				</a>
																			<?php //}
																			}
																			$comment = "";
																			foreach ($rows['rq_workflow'] as $key => $rwc) { ?>
																				<?php $comment .= '<p>' . $rwc['comment'] . '</p>'; ?>
																			<?php } ?>
																			<a class="btn no_padding btn_left" title="Information" onclick="open_infobox('<?php echo $comment; ?>');" class="icon-big flip" data-toggle="modal" data-target="#manager_information">																				
																				<img src="<?php echo base_url();?>assets_home_v3/images/global_info_big.svg" alt="">																					
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
															<button id="aprrove_btn" name="approve" value="approve" type="submit" class="btn btn_padding filter_btn_blue save_common_btn btn-sm">Approve</button>
															<button id="Cancel_btn" name="reject" value="reject" type="submit" class="btn btn_padding filter_btn save_common_btn btn-sm">Reject</button>
														</div>
													</div>
												</div>
											</div>

										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div id="myModal" class="modal fade" role="dialog" style="font-size:90%; ">
		<div class="modal-dialog">
			<div class="modal-content">
				<div id="type1_from">
					<form method="post" action="<?php echo base_url(); ?>attendance_reversal/approve_l1" id="ar_form" enctype="multipart/form-data">
						<div class="modal-header">
							<button type="button" class="close close_new" data-dismiss="modal"></button>
							<h4 class="modal-title">Attendance Reversal Approval </h4>
						</div>
						<div class="modal-body filter-widget">
							<div class="row" style="padding:3px 0px;">
								<div class="form-group">
									<input type="hidden" name="applied_person_name" id="fname">
									<input type="hidden" id="apply_agent_id" name="apply_agent_id" value="<?php echo $agent_id; ?>">
									<input type="hidden" name="aprovid" id="aprovid" value="">
									<input type="hidden" name="revasal_applied_date" id="revasal_applied_date">
								</div>
							</div>
							<input type="hidden" name="ar_data" id="ar_data" value="">
							<div id="start_tm" class="row" style="padding:3px 0px;">
								<div class="form-group">
									<label class="col-md-4" style="line-height:37px;">Start Time(Local Time Zone)</label>
									<div class="col-md-8">
										<!-- <input type="datetime-local" name="ar_start_time" class="form-control" id="rq_start_date"> -->
										<input type="time" name="ar_start_time" class="form-control" id="rq_start_date">
									</div>
								</div>
							</div>
							<div id="end_tm" class="row" style="padding:3px 0px;">
								<div class="form-group">
									<label class="col-md-4" style="line-height:37px;">End Time(Local Time Zone)</label>
									<div class="col-md-8">
										<!-- <input type="datetime-local" name="ar_end_time" class="form-control" id="rq_end_date"> -->
										<input type="time" name="ar_end_time" class="form-control" id="rq_end_date">
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
	<div id="myModal1" class="modal fade" role="dialog" style="font-size:90%; ">
		<div class="modal-dialog small_modal_new">
			<div class="modal-content">
				<div id="type1_from">
					<form method="post" action="<?php echo base_url(); ?>attendance_reversal/cancel_l1" id="ar_form" enctype="multipart/form-data">
						<div class="modal-header">
							<button type="button" class="close close_new" data-dismiss="modal"></button>
							<h4 class="modal-title">Attendance Reversal Cancel </h4>
						</div>

						<div class="modal-body filter-widget">
							<input type="hidden" name="aprovid" id="aprovids" value="">
							<input type="hidden" id="cancel_agent_id" name="cancel_agent_id" value="<?php echo $agent_id; ?>">
							<p>Are You Sure You Want To Cancel Attendance Reversal</p>
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
	<!--start Information Popup design-->
	<div class="modal fade model_new" id="manager_information" role="dialog">
		<div class="modal-dialog small_modal_new">
			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close close_new" data-dismiss="modal"></button>
					<h4 class="modal-title">Information</h4>
				</div>
				<div class="modal-body">
					<div id="msg_body" class="content_widget">
						<p>
						</p>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn_padding filter_btn save_common_btn" data-dismiss="modal">Close</button>
				</div>
			</div>

		</div>
	</div>
	<!--end Information Popup design-->
	<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/attendance_reversal/slick/slick.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/attendance_reversal/js/progresscircle.js"></script>
	<script src="<?php echo base_url(); ?>assets/attendance_reversal/js/custom.js"></script> -->
	<!--<script src="<?php echo base_url(); ?>assets/attendance_reversal/js/chart-bar.js"></script>-->
	<script>
		$(document).ready(function() {
			$("#flip").click(function() {
				$("#panel").slideToggle("slow");
			});
		});
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

		function set_entry_id(apid, uid, rq_start_time_date, rq_end_time_date, fname, type , revasal_applied_date) {
			//alert(revasal_applied_date+"********"+rq_end_date);
			$('#aprovid').val(apid);
			$('#aprovids').val(apid);
			$('#apply_agent_id').val(uid);
			$('#cancel_agent_id').val(uid);
			$('#rq_start_date').val(rq_start_time_date);
			$('#rq_end_date').val(rq_end_time_date);
			$('#revasal_applied_date').val(revasal_applied_date);
			$('#fname').val(fname);
			if (type == 4 || type == 6) {
				$('#start_tm').css('display', 'none');
				$('#end_tm').css('display', 'none');
			} else {
				$('#start_tm').css('display', 'block');
				$('#end_tm').css('display', 'block');
			}
		}
	</script>
	<script>
		function open_comment(id) {
			$(".down_arrow" + id).hide();
			$(".up_arrow" + id).show();
			$("#panel" + id).slideToggle("slow");
		}

		function close_comment(id) {
			$(".down_arrow" + id).show();
			$(".up_arrow" + id).hide();
			$("#panel" + id).hide();
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
		function open_infobox(id) {
			$('#msg_body').html(id);
		}
	</script>
</body>

</html>