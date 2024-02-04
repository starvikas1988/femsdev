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
	<div class="main">
		<div class="wrap">
			<div class="gimini-main">
				<div class="white_widget padding_3">
					<div class="menu_widget avail_widget_br">
						<?php include_once('aside_menu.php');?>
					</div>
					<div class="approval_widget top_2">
						<form method="POST" action="<?php echo base_url('attendance_reversal/approval_excel_import'); ?>" enctype="multipart/form-data">
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<h2 class="avail_title_heading">Please Select the File to Upload <span class="small_font">(accepted file type xlsx and max file size 5 mb)</span></h2>
										<span><?php echo $status_message; ?></span>
									</div>
								</div>
							</div>
							<div class="top_1">
								<div class="row">
									<div class="col-md-1">
										<div class="form-group margin_all">
											<label for="sedate">Upload File</label>
										</div>
									</div>
									<div class="col-md-3">
										<div class="form-group margin_all file_upload_style">
											<input type="file" class="form-control" name="userfile" id="userfile" onchange="upload_check()" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" required>
											<input type="hidden" name="upload_file" value="1">
										</div>
									</div>
									<div class="col-md-3">
										<button type="submit" name="uploadSchedule" class="btn btn-danger1 upload btn_padding filter_btn_blue save_common_btn">Upload</button>
									</div>
								</div>
							</div>
						</form>
					</div>
				</div>

				<?php if (!empty($uploadData)) { ?>
					<div class="body-widget">
						<div class="white_widget padding_3">
							<h2 class="avail_title_heading">Upload Logs
								<!--<a class="btn btn-primary btn-sm pull-right" target="_blank" href='<?php echo base_url('cns/download_upload_log'); ?>'><i class="fa fa-download"></i> Export Log</a>--->
							</h2>
							<hr class="sepration_border" />
							<div class="body-widget clearfix">
								<div class="table-responsive common_table_widget">
									<table id="example" class="table table-bordered table-striped skt-table" cellspacing="0" width="100%">
										<thead>
											<tr>
												<th>SL</th>
												<th>MWP ID</th>
												<th>Location</th>
												<th>Client</th>
												<th>Department</th>
												<th>Date</th>
												<th>Name</th>
												<th>Type</th>
												<th>From</th>
												<th>To</th>
												<th>Applied On</th>
												<th>Contact No</th>
												<th>Shift Time</th>
												<th>Expected Time</th>
												<th>MWP Time</th>
												<th>Actual Time</th>
												<th>dailer Time</th>
												<th>Actual Time</th>
												<th>Change Start Time</th>
												<th>Change End Time</th>
												<th>Reason</th>
												<th>Change Status</th>
												<th>Result</th>
											</tr>
										</thead>
										<tbody>
											<?php
											$counter = 0;
											foreach ($uploadData['csv'] as $row) {
												$counter++;
												$classCheck = "";
												if ($row['status'] == 'error') {
													$classCheck = "style='background-color:#fbd1d1'";
												}
												if ($row['status'] == 'success') {
													$classCheck = "style='background-color:#d2ffd3'";
												}
												if ($row['status'] == 'Duplicate Entry') {
													$classCheck = "style='background-color:#eba134'";
												}
											?>
												<tr <?php echo $classCheck; ?>>
													<td><?php echo $counter; ?></td>
													<td><?php echo $row['mwp_id']; ?></td>
													<td><?php echo $row['location']; ?></td>
													<td><?php echo $row['client']; ?></td>
													<td><?php echo $row['department']; ?></td>
													<td><?php echo $row['Date']; ?></td>
													<td><?php echo $row['name']; ?></td>
													<td><?php echo $row['type']; ?></td>
													<td><?php echo $row['from']; ?></td>
													<td><?php echo $row['to']; ?></td>
													<td><?php echo $row['applied_on']; ?></td>
													<td><?php echo $row['contact_no']; ?></td>
													<td><?php echo $row['shift_time']; ?></td>
													<td><?php echo $row['expected']; ?></td>
													<td><?php echo $row['MWP']; ?></td>
													<td><?php echo $row['actual']; ?></td>
													<td><?php echo $row['dailer']; ?></td>
													<td><?php echo $row['dailer_actual']; ?></td>
													<td><?php echo $row['change_start_time']; ?></td>
													<td><?php echo $row['change_end_time']; ?></td>
													<td><?php echo $row['reason']; ?></td>
													<td><?php echo $row['change_status']; ?></td>
													<td><?php echo $row['status']; ?></td>
												</tr>
											<?php } ?>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				<?php } ?>
			</div>
		</div>
	</div>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/attendance_reversal/slick/slick.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/attendance_reversal/js/progresscircle.js"></script>
	<script src="<?php echo base_url(); ?>assets/attendance_reversal/js/custom.js"></script>
	<script src="<?php echo base_url(); ?>assets/attendance_reversal/js/chart-bar.js"></script>
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

		function set_entry_id(apid, uid, rq_start_date, rq_end_date, fname, type) {
			//alert(apid+"********"+uid);
			$('#aprovid').val(apid);
			$('#aprovids').val(apid);
			$('#apply_agent_id').val(uid);
			$('#cancel_agent_id').val(uid);
			$('#rq_start_date').val(rq_start_date);
			$('#rq_end_date').val(rq_end_date);
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
		3

		function upload_check() {
			var upl = document.getElementById("userfile");
			fl = upl.files[0].name;
			fileExt = fl.substring(fl.lastIndexOf('.'));
			if (fileExt != '.xlsx') {
				alert('invalid file type');
				$('#userfile').val('');
			}
			var MAX_FILE_SIZE = 5 * 1024 * 1024;
			if (upl.files[0].size > MAX_FILE_SIZE) {
				alert("File too big!");
				upl.value = "";
			}
			//
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
		var ctxBAR = document.getElementById("bar-chart5");
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
		});

		function open_infobox(id) {
			$('#msg_body').html(id);
		}
	</script>
</body>

</html>