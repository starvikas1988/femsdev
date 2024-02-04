<link href="<?= base_url() ?>assets/css/search-filter/assets/css/simple-datatables-latest.css" rel="stylesheet" />
<link href="<?= base_url() ?>assets/css/search-filter/assets/css/custom.css" rel="stylesheet" />
<script src="<?= base_url() ?>assets/css/search-filter/assets/js/all.min.js"></script>
<style>
	.green {
		color: green;
	}

	.red {
		color: red;
	}

	textarea {
		height: 120px !important;
	}

	.heading-title {
		padding: 15px 0 5px 0;
	}

	.welcome-area {
		background: rgba(0, 111, 255, 0.10);
	}

	.modal {
		background: rgba(0, 0, 0, 0.5) !important;
	}

	.fresh-design {
		width: 100%;
	}

	.fresh-design .modal-dialog {
		width: 950px;
	}

	.repeat-area {
		width: 100%;
		margin: 0 0 10px 0;
		border-bottom: 1px solid #eee;
		padding: 0 0 10px 0;
	}

	.fresh-design .dropdown-menu {
		width: 100%;
	}

	.fresh-design .dropdown-toggle {
		padding: 10px;
		margin: -10px 0 0 0;
		background: transparent !important;
	}

	.fresh-design .dropdown-toggle:focus {
		outline: none !important;
		box-shadow: none !important;
	}

	.fresh-design .form-label {
		margin: 12px 0 0 0;
	}

	.popup-title {
		font-size: 18px;
		padding: 0 0 10px 0;
		margin: 0;
		font-weight: bold;
		color: #000;
	}

	select.selectpicker {
		display: block !important;
	}

	.new-view {
		border-radius: 1px !important;
	}

	.new-view .dashboard-title1,
	.new-view .dashboard-title {
		font-size: 16px !important;
	}

	.welcome-area,
	.card {
		border-radius: 1px !important;
	}

	.new-card {
		margin-bottom: 0.5rem;
	}
</style>
<div id="layoutSidenav_content">
	<main>
		<div class="wrap">
			<h2 class="avail_title_heading">Dashboard</h2>
			<hr class="sepration_border" />
			<div class="row">
				<div class="col-md-12">
					<div class="welcome-area">
						<div class="row d_flex">
							<div class="col-md-8">
								<div class="row align-item-center">
									<div class="col-md-2"> <img src="<?= base_url() ?>assets/css/search-filter/assets/img/email.svg" alt=""> </div>
									<div class="col-md-10">
										<h2 class="heading-title">
											<strong>Welcome back!</strong>
											<span><?= $current_user_name ?></span>
										</h2>
										<p>DFR(Onboarding) IT Assets Management | Recruitment Section</p>
									</div>
								</div>
							</div>
							<div class="col-md-4">
								<div class="right_side">
									<?php $download_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . $export_link; ?>
									<a type="button" href="<?= $download_link ?>" class="btn-sm btn btn_padding filter_btn">Export to excel</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row flex_wrap">
				<?php foreach ($assets_mst as $key => $value) {
					$assets_id = $value['id'];  ?>
					<div class="col-md-3 form-group assests_widget">
						<div class="white_widget padding_3 column_height text-black new-card new-view">
							<div class="text-center">
								<h2 class="dashboard-title">
									<?= $value['name'] ?>
								</h2>
								<p>
									<?php
									if (isset($assets_count_name[$assets_id])) {
										if ($assets_count_name[$assets_id] != 0) echo $assets_count_name[$assets_id];
										else echo $assets_count_name[$assets_id];
									} else {
										echo "0";
									}
									?>
								</p>
							</div>
						</div>
					</div>
				<?php } ?>
			</div>
			<!--<div class="row">
						<div class="col-sm-6">
							<div class="widget">
								<div class="widget-body text-center">
									<canvas id="bar-chart" width="400" height="400"></canvas>
								</div>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="widget">
								<div class="widget-body text-center">
									<canvas id="bar-doughnut" width="400" height="400"></canvas>
								</div>
							</div>
						</div>
					</div>-->
			<div class="common-top">
				<div class="white_widget padding_3">
					<h2 class="avail_title_heading">Search</h2>
					<hr class="sepration_border" />
					<form method="post">
						<div class="row">
							<div class="form-group  col-sm-4">
								<div class="filter-widget">
									<label>Start Date</label>
									<input type="date" name="start_date[]" value="<?php if(isset($filter_data["start_date"][0])) echo $filter_data["start_date"][0] ?>" class="form-control" autocomplete="off">
								</div>
							</div>
							<div class="form-group  col-sm-4">
								<div class="filter-widget">
									<label>End Date</label>
									<input type="date" name="end_date[]" value="<?php if(isset($filter_data["end_date"][0])) echo $filter_data["end_date"][0] ?>" class="form-control" autocomplete="off">
								</div>
							</div>
							<div class="form-group col-sm-4">
								<div class="filter-widget">
									<label>Company Brand</label>
									<select name="com_brand[]" class="form-control common_multiselect" autocomplete="off" multiple>
										<?php foreach ($company_brands as $key => $value) {
											$sel = "";
											if(isset($filter_data["com_brand"])){
												if(in_array($value['id'], $filter_data["com_brand"])) $sel = "selected";
											}
										?>
											<option value="<?php echo $value['id'] ?>" <?= $sel ?>><?php echo $value['name'] ?></option>
										<?php } ?>
									</select>
								</div>
							</div>
							<div class="form-group col-sm-4">
								<div class="filter-widget">
									<label>Department</label>
									<select name="dpt_id[]" class="form-control common_multiselect" autocomplete="off" multiple>
										<?php foreach ($department_data as $key => $value) {
											$sel = "";
											if(isset($filter_data["dpt_id"])){
												if(in_array($value['id'], $filter_data["dpt_id"])) $sel = "selected";
											}
										?>
											<option value="<?php echo $value['id'] ?>" <?=$sel?>><?php echo $value['shname'] ?></option>
										<?php } ?>
									</select>
								</div>
							</div>
							<div class="form-group col-sm-4">
								<div class="filter-widget">
									<label>Location</label>
									<select id="location_id" name="location_id[]" class="form-control common_multiselect" placeholder="Select Location" autocomplete="off" multiple>
										<?php foreach ($location_list as $key => $value) {
											$sel = "";
											if(isset($filter_data["location_id"])){
												if(in_array($value['abbr'], $filter_data["location_id"])) $sel = "selected";
											}
										?>
											<option value="<?=$value['abbr']?>" <?=$sel?>><?php echo $value['office_name'] ?></option>
										<?php } ?>
									</select>
								</div>
							</div>
							<div class="form-group col-sm-4">
								<div class="filter-widget">
									<label>Requirement Status</label>
									<select name="req_status[]" class="form-control common_multiselect" placeholder="Select Status" autocomplete="off" multiple>
										<option value="A" <?php if(isset($filter_data["req_status"])) { if(in_array("A", $filter_data["req_status"])) echo "selected"; } ?>>Active</option>
										<option value="CL" <?php if(isset($filter_data["req_status"])) { if(in_array("CL", $filter_data["req_status"])) echo "selected"; } ?>>Closed</option>
									</select>
								</div>
							</div>
							<div class="form-group col-sm-4">
								<div class="margin_all filter-widget">
									<label>Requisition ID</label>
									<input placeholder="For Multiple search using comma seperator" type="text" name="req_id[]" value="<?php if(isset($filter_data["req_id"][0])) echo $filter_data["req_id"][0] ?>" class="form-control" autocomplete="off">
								</div>
							</div>

							<div class="form-group col-sm-4">
								<div class="margin_all">
									<label class="visiblity_hidden d_block">Search</label>
									<button type="submit" class="btn btn_padding filter_btn_blue save_common_btn">Search</button>
								</div>
							</div>

						</div>
					</form>
				</div>
			</div>
			<div class="common-top">
				<div class="white_widget padding_3">
					<div class="common_table_widget report_hirarchy">
						<table id="datatablesSimple" class="table table-bordered skt-table table-striped sampleTable new-table">
							<thead>
								<tr>
									<th>Expand</th>
									<th class="table_width_sr">SL No</th>
									<th class="table_width">Requisition ID</th>
									<th class="table_width">Raised Date</th>
									<th class="table_width">Due Date</th>
									<th class="table_width1">Request By</th>
									<th class="table_width1">Approved By</th>
									<th class="table_width">Location</th>
									<th class="table_width1">Department</th>
									<th class="table_width1">Company Brand</th>
									<th class="table_width">Position</th>
									<th class="table_width1">Remarks</th>
									<th class="employee_td1">Requirement Status</th>
									<th class="table_width leave_columns_fixed">Status</th>
									<th class="table_width leave_columns_fixed">Action</th>
								</tr>
							</thead>
							<?php
							$c = 1;
							foreach ($dfr_data as $value) {
								$dfr_id = $value['id'];
							?>
								<tbody>
									<tr>
										<td>
											<div class="tooltip_fresh">
												<button type="button" id="dfr_can_it_details" dfr_id="<?= $value['id'] ?>" class="btn plus_icon filter_btn btn-xs" data-toggle="collapse" data-target="#dfr_tb<?= $value['id'] ?>"><i class="fa fa-plus"></i></button>
											</div>
										</td>
										<td><?= $c ?></td>
										<td><?= $value['requisition_id'] ?></td>
										<td><?= $value['approved_date'] ?></td>
										<td><?= $value['due_date'] ?></td>
										<td><?= $value['raised_by'] ?></td>
										<td><?= $value['approved_by'] ?></td>
										<td><?= $value['office_name'] ?></td>
										<td><?= $value['department_name'] ?></td>
										<td><?= $value['company_brand'] ?></td>
										<td><?= $value['req_no_position'] ?></td>
										<td><?= $value['approved_comment'] ?></td>
										<td><?php
											if ($value['requisition_status'] == "A") echo "Active";
											elseif ($value['requisition_status'] == "CL") echo "Closed";
											else echo "-";
											?></td>
										<td class="leave_columns_fixed action_column_right">
											<?php
											if ($dfr_status_count[$dfr_id] > 0) echo '<span class="status_btn2 pb-1" >Active</span> ';
											else echo '<span class="status_btn2 pb-1" >Onboarding</span>';
											?>
										</td>
										<td class="text-align-class leave_columns_fixed action_column_right"><button type="button" title="View" location="<?= $value['location'] ?>" dfr_id="<?= $value['id'] ?>" req_id="<?= $value['requisition_id'] ?>" class="btn btn-xs dfr_assets_details_dashboard"><img src="<?php echo base_url(); ?>assets_home_v3/images/view.svg" alt=""></button></td>
									</tr>
									<tr class="collapse" id="dfr_tb<?= $value['id'] ?>">
										<td colspan="20">
											<table class="table">
												<tr>
													<td class="it_assets_reponse_<?= $value['id'] ?>">
														<table class="table skt-table table-striped table-bordered" cellspacing="0" width="100%" style="margin-bottom:0px;">
															<thead>
																<tr>
																	<th class="table_width_sr">SL No</th>
																	<th class="employee_td">Name</th>
																	<th class="table_width">Fusion ID</th>
																	<th class="table_width1">Location</th>
																	<th class="table_width1">Department</th>
																	<th class="table_width1">Role</th>
																	<th class="table_width">DOJ</th>
																	<th class="table_width">Status</th>
																	<th class="table_width">Action</th>
																</tr>
															</thead>
															<tbody id="dfr_request_user_<?= $value['id'] ?>">
															</tbody>
														</table>
													</td>
												</tr>
											</table>
										</td>
									</tr>
								</tbody>
							<?php
								$c++;
							}
							?>
						</table>
					</div>
				</div>
			</div>
		</div>
	</main>
	<!-- Modal start Assets Update-->
	<div id="model_users_assets" class="modal fade fresh-design" role="dialog">
		<div class="modal-dialog">
			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close close_new" data-dismiss="modal"></button>
					<h4 class="modal-title">Assets Details</h4>
				</div>
				<form method="post" action="<?= base_url() ?>dfr_it_assets/dfr_user_assets_submit">
					<div class="modal-body">
						<div class="filter-widget">
							<div class="user_assets_result">
								<p>No assets are approve!</p>
							</div>
						</div>
						<!--start assets details in table-->
<!-- 						<div class="common_table_widget report_hirarchy_new">
							<table class="table table-bordered table-striped">
								<thead>
									<tr>
										<th>Assets Name</th>
										<th>Brand Name</th>
										<th>Configuration/Details</th>
										<th>Serial Number</th>
										<th>Reference ID</th>
										<th>Remarks</th>
										<th>Status</th>
									</tr>
								</thead>
								<tbody class="user_assets_result">
									<tr>
										<td>Desktop</td>
										<td>Dell</td>
										<td>asdsadsad</td>
										<td>23213213TEST</td>
										<td>ITKOL202300023</td>
										<td>tse</td>
										<td>Provided</td>
									</tr>
								</tbody>
							</table>
						</div> -->
						<!--end assets details in table-->

					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn_padding filter_btn save_common_btn" data-dismiss="modal">Close</button>
						<button type="submit" class="btn btn_padding filter_btn_blue save_common_btn">Save</button>
					</div>
				</form>
			</div>
		</div>
	</div>
	<!-- modal end -->
	<!-- Modal start Assets details-->
	<div id="model_users_assets_details" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close close_new" data-dismiss="modal"></button>
					<h4 class="modal-title">Requisition Details</h4>
				</div>
				<div class="modal-body">
					<div class="filter-widget">
						<!--<div class="row dfr_assets_result">
							<h4>No assets are approve!</h4>
					</div>-->
						<p class="req_id_assets avail_title_heading no_padding no_margin"></p>
						<p class="total_can_assets avail_title_heading no_padding no_margin"></p>
						<div class="common_table_widget leave_table top_1">
							<table id="datatablesSimple" class="table skt-table table-striped sampleTable">
								<thead>
									<tr>
										<th>#</th>
										<th>Asset Name</th>
										<th>Total Asset Required</th>
										<th>Provided</th>
										<th>In Stock</th>
									</tr>
								</thead>
								<tbody id="dfr_assets_result">
								</tbody>
							</table>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn_padding filter_btn save_common_btn" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>
	<!-- modal end -->
</div>
</div>
<script>
	$(document).on('change', '#model_users_assets .select_stat_assets', function() {
		var inf_id = $(this).attr('date-inf');
		var op_value = $(this).val();
		if (op_value == 1) {
			$("#model_users_assets .select_model-" + inf_id).attr('disabled', false);
			$("#model_users_assets .select_comment-" + inf_id).attr('disabled', false);
		} else {
			$("#model_users_assets .select_model-" + inf_id).attr('disabled', true);
			$("#model_users_assets .select_comment-" + inf_id).attr('disabled', true);
			$('#model_users_assets .stock_details_serial' + inf_id).html('');
			$('#model_users_assets .stock_details_conf' + inf_id).html('');
			$('#model_users_assets .stock_details_type' + inf_id).html('');
			$("#model_users_assets .select_model-" + inf_id).val("");
			$("#model_users_assets .select_comment-" + inf_id).val();
		}
	});
</script>
<script src="<?= base_url() ?>assets/css/search-filter/assets/js/scripts.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
<!--
<script src="<?= base_url() ?>assets/css/search-filter/assets/js/simple-datatables-latest.js"></script>
<script src="<?= base_url() ?>assets/css/search-filter/assets/js/datatables-simple-demo.js"></script>
-->
<script src="<?php echo base_url() ?>assets/css/chart/js/chart.js"></script>
<script>
	var ctxBAR = document.getElementById("bar-chart");
	var myBarChart_dailyVisitor = new Chart(ctxBAR, {
		type: 'bar',
		data: {
			labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
			datasets: [{
				label: "Visitors",
				data: [12, 19, 3, 5, 2, 3],
				backgroundColor: [
					'rgba(30, 115, 174, 0.9)',
					'rgba(243, 118, 43, 0.9)',
					'rgba(38, 156, 39, 0.9)',
					'rgba(30, 115, 174, 0.9)',
					'rgba(243, 118, 43, 0.9)',
					'rgba(38, 156, 39, 0.9)',
					'rgba(243, 118, 43, 0.9)'
				],
				borderColor: [
					'rgb(30, 115, 174)',
					'rgb(243, 118, 43)',
					'rgb(38, 156, 39)',
					'rgb(30, 115, 174)',
					'rgb(243, 118, 43)',
					'rgb(38, 156, 39)',
					'rgb(243, 118, 43)'
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
</script>
<script>
	var ctxBAR = document.getElementById("bar-doughnut");
	var myBarChart_dailyVisitor = new Chart(ctxBAR, {
		type: 'doughnut',
		data: {
			labels: [
				'Red',
				'Blue',
				'Yellow'
			],
			datasets: [{
				label: "Visitors",
				data: [12, 19, 3],
				backgroundColor: [
					'rgba(255, 99, 132, 0.9)',
					'rgba(255, 159, 64, 0.9)',
					'rgba(255, 205, 86, 0.9)'
				],
				borderColor: [
					'rgb(255, 99, 132)',
					'rgb(255, 159, 64)',
					'rgb(255, 205, 86)'
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
</script>
<script>
	$(document).ready(function() {
		$('.tooltip_fresh .plus_icon').click(function() {
			$(this).toggleClass("add_plus");
		});
	});
</script>

<script>
	$(document).ready(function() {
		$('.common_multiselect').multiselect({
			enableFiltering: true,
			includeSelectAllOption: true,
			numberDisplayed: 2,
			enableCaseInsensitiveFiltering: true,
		});
	});
</script>