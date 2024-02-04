<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/data-table-export/css/dataTables.bootstrap.min.css" />
<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/data-table-export/css/buttons.bootstrap.min.css" />
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap.min.css" />
<style>
	.welcome-area {
		padding: 15px;
		background: rgba(0, 111, 255, 0.1);
		border: 1px solid rgba(0, 111, 255, 0.12);
		border-radius: 4px;
	}

	.heading-title {
		font-size: 20px;
		padding: 0 0 5px 0;
		margin: 0;
		color: #384364;
	}

	.welcome-area p {
		padding: 0;
		margin: 0;
		font-size: 13px;
	}

	.align-item-center {
		display: flex;
		align-items: center;
	}

	.welcome-area span {
		color: #188ae2;
	}

	.end-widget {
		width: 100%;
		text-align: right;
	}

	.btn-common {
		width: auto;
		padding: 10px 20px;
		background: #fd4967;
		color: #fff;
		border-radius: 5px;
		font-size: 14px;
		letter-spacing: 0.5px;
		transition: all 0.5s ease-in-out 0s;
	}

	.btn-common:hover {
		background: #d32b47;
		color: #fff;
	}

	.btn-common:focus {
		background: #d32b47;
		color: #fff;
		outline: none;
		box-shadow: none;
	}
	.dashboard-title1 {
		font-size: 20px;
		padding: 0 0 5px 0;
		margin: 0;
		color: #188ae2;
		font-weight: normal;
	}

	.dashboard-sub-title {
		font-size: 14px;
		letter-spacing: 0.4px;
	}

	/*search option*/
	.search-select label {
		display: block;
	}

	.search-select .bootstrap-select:not([class*="col-"]):not([class*="form-control"]):not(.input-group-btn) {
		width: 100%;
	}

	.bootstrap-select>.dropdown-toggle {
		height: 40px;
		border-radius: 0px !important;
	}

	.search-select ul {
		max-height: 200px !important;
	}

	.search-select .bs-placeholder:hover {
		background: #fff !important;
		box-shadow: none !important;
	}

	.search-select .dropdown-menu>.active>a,
	.search-select .dropdown-menu>.active>a:focus,
	.search-select .dropdown-menu>.active>a:hover {
		color: #fff;
		text-decoration: none;
		background-color: #3b5998 !important;
		outline: 0;
	}
</style>
<div class="wrap">
	<section class="app-content">
		<div class="white_widget padding_3">
			<?php $label_color = 'style="color: #10c469"'; ?>
			<h2 class="avail_title_heading">Assets report</h2>
			<hr class="sepration_border">
			<div class="body_widget">
				<form method="post">
					<div class="row">
						<div class="col-sm-4">
							<div class="form-group filter-widget">
								<?php if ($start_date != "") $label_sel = $label_color;
								else $label_sel = ""; ?>
								<label class="check_lable" content_text="Start date" <?= $label_sel ?>>Start date </label>
								<input type="date" name="start_date" type="text" value="<?= $start_date ?>" class="form-control selected_check" id="start_date">
							</div>
						</div>
						<div class="col-sm-4">
							<div class="form-group filter-widget">
								<?php if ($end_date != "") $label_sel = $label_color;
								else $label_sel = ""; ?>
								<label class="check_lable" content_text="End date" <?= $label_sel ?>>End date </label>
								<input type="date" name="end_date" type="text" value="<?= $end_date ?>" class="form-control selected_check" id="end_date">
							</div>
						</div>
						<div class="col-sm-4 form-group">
							<div class="filter-widget">
								<?php if (!empty($office_id)) $label_sel = $label_color; else $label_sel = ""; ?>
								<label class="check_lable" content_text="Location" <?= $label_sel ?>>Location</label>
								<select name="office_id[]" id="office_id" class="multiselect_options selected_check" multiple>
									<?php foreach ($location_list as $key => $value) {
										$sel = "";
										if (in_array($value['abbr'],$office_id)) $sel = "selected";
									?>
										<option value="<?php echo $value['abbr']; ?>" <?php echo $sel; ?>><?php echo $value['office_name'] ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="col-sm-4 form-group">
							<div class="filter-widget">
								<?php if (!empty($phy_location)) $label_sel = $label_color; else $label_sel = ""; ?>
								<label class="check_lable" content_text="Physical Location" <?= $label_sel ?>>Physical Location</label>
								<select name="physical_location[]" id="physical_location" class="multiselect_options selected_check" multiple>
									<?php
									foreach ($physical_location as $value) {
										$sel = "";
										if (in_array($value['id'],$phy_location)) $sel = "selected";
									?>
										<option value="<?= $value['id'] ?>" <?= $sel ?>><?= $value['location_name'] ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="col-sm-4 form-group">
							<div class="filter-widget">
								<?php if (!empty($assets_id)) $label_sel = $label_color; else $label_sel = ""; ?>
								<label class="check_lable" content_text="Assets" <?= $label_sel ?>>Assets</label>
								<select name="assets_id[]" id="assets_id" class="multiselect_options selected_check" multiple>
									<?php
									foreach ($assets_list as $value) {
										$sel = "";
										if (in_array($value['id'],$assets_id)) $sel = "selected";
									?>
										<option value="<?= $value['id'] ?>" <?= $sel ?>><?= $value['name'] ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="col-sm-4 form-group">
							<div class="filter-widget">
								<?php if (!empty($brand_id)) $label_sel = $label_color; else $label_sel = ""; ?>
								<label class="check_lable" content_text="Brand" <?= $label_sel ?>>Brand</label>
								<select name="brand_id[]" id="brand_id" class="multiselect_options selected_check" multiple>
									<?php
									foreach ($brand_list as $value) {
										$sel = "";
										if (in_array($value['id'],$brand_id)) $sel = "selected";
									?>
										<option value="<?= $value['id'] ?>" <?= $sel ?>><?= $value['name'] ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="col-sm-4 form-group">
							<div class="filter-widget">
								<?php if (!empty($vendor_id)) $label_sel = $label_color; else $label_sel = ""; ?>
								<label class="check_lable" content_text="Vendor" <?= $label_sel ?>>Vendor</label>
								<select name="vendor_id[]" id="vendor_id" class="multiselect_options selected_check" multiple>
									<?php
									foreach ($vendor_list as $value) {
										$sel = "";
										if (in_array($value['id'],$vendor_id)) $sel = "selected";
									?>
										<option value="<?= $value['id'] ?>" <?= $sel ?>><?= $value['vnd_name'] ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="col-sm-4 form-group">
							<div class="filter-widget">
								<?php if (!empty($ram_size)) $label_sel = $label_color; else $label_sel = ""; ?>
								<label class="check_lable" content_text="RAM" <?= $label_sel ?>>RAM</label>
								<select name="ram_size[]" id="ram_size" class="multiselect_options selected_check" multiple>
									<?php
									foreach ($ram_list as $value) {
										$sel = "";
										if (in_array($value['id'],$ram_size)) $sel = "selected";
									?>
										<option value="<?= $value['id'] ?>" <?= $sel ?>><?= $value['size'] . " GB" ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="col-sm-4 form-group">
							<div class="filter-widget">
								<?php if (!empty($com_brand)) $label_sel = $label_color; else $label_sel = ""; ?>
								<label class="check_lable" content_text="Company Brand" <?= $label_sel ?>>Company Brand</label>
								<select name="com_brand[]" id="com_brand" class="multiselect_options selected_check" multiple>
									<?php
									foreach ($company_brand as $value) {
										$sel = "";
										if (in_array($value['id'],$com_brand)) $sel = "selected";
									?>
										<option value="<?= $value['id'] ?>" <?= $sel ?>><?= $value['name'] ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="col-sm-4 form-group">
							<div class="filter-widget">
								<?php if (!empty($own_rental)) $label_sel = $label_color;
								else $label_sel = ""; ?>
								<label class="check_lable" content_text="Own/Rental/Client" <?= $label_sel ?>>Own/Rental/Client</label>
								<select name="own_rental[]" id="own_rental" class="multiselect_options assign_stat selected_check" multiple>
									<option value="1" <?php if (in_array(1,$own_rental)) echo 'selected'; ?>>Own</option>
									<option value="2" <?php if (in_array(2,$own_rental)) echo 'selected'; ?>>Rental</option>
									<option value="3" <?php if (in_array(3,$own_rental)) echo 'selected'; ?>>Client</option>
								</select>
							</div>
						</div>
						<div class="col-sm-4 form-group">
							<div class="filter-widget">
								<?php if (!empty($under_validity)) $label_sel = $label_color;
								else $label_sel = ""; ?>
								<label class="check_lable" content_text="Under Validity" <?= $label_sel ?>>Under Validity</label>
								<select name="under_validity[]" id="under_validity" class="multiselect_options assign_stat selected_check" multiple>
									<option value="1" <?php if (in_array(1,$under_validity)) echo 'selected'; ?>>Yes</option>
									<option value="2" <?php if (in_array(2,$under_validity)) echo 'selected'; ?>>No</option>
								</select>
							</div>
						</div>
						<div class="col-sm-4 form-group">
							<div class="filter-widget">
								<?php if (!empty($purhcase_type)) $label_sel = $label_color;
								else $label_sel = ""; ?>
								<label class="check_lable" content_text="Purchase Type" <?= $label_sel ?>>Purchase Type</label>
								<select name="purhcase_type[]" id="purhcase_type" class="multiselect_options assign_stat selected_check" multiple>
									<option value="2" <?php if (in_array(2,$purhcase_type)) echo 'selected'; ?>>Capex</option>
									<option value="1" <?php if (in_array(1,$purhcase_type)) echo 'selected'; ?>>Opex</option>
								</select>
							</div>
						</div>
						<div class="col-sm-4 form-group">
							<div class="filter-widget">
								<?php if ($status_search != "") $label_sel = $label_color;
								else $label_sel = ""; ?>
								<label class="check_lable" content_text="Status" <?= $label_sel ?>>Status</label>
								<select name="status_search[]" id="status_search" class="multiselect_options assign_stat selected_check" multiple>
									<option value="1" <?php if (in_array(1,$status_search)) echo "selected"; ?>>Un-Assigned/Released</option>
									<option value="2" <?php if (in_array(2,$status_search)) echo "selected"; ?>>Assigned</option>
									<option value="8" <?php if (in_array(8,$status_search)) echo "selected"; ?>>Live</option>
									<option value="3" <?php if (in_array(3,$status_search)) echo "selected"; ?>>Scrap</option>
									<option value="4" <?php if (in_array(4,$status_search)) echo "selected"; ?>>Defect</option>
									<option value="5" <?php if (in_array(5,$status_search)) echo "selected"; ?>>Return(Un-Assigned/Released)</option>
									<option value="6" <?php if (in_array(6,$status_search)) echo "selected"; ?>>Stock</option>
									<option value="7" <?php if (in_array(7,$status_search)) echo "selected"; ?>>Misplaced/Lost</option>
									<option value="9" <?php if (in_array(9,$status_search)) echo "selected"; ?>>In-Stock(Check Overall Stock)</option>
								</select>
							</div>
						</div>
						<div class="col-sm-12">
							<div class="form-group">
								<button type="submit" class="btn btn_padding filter_btn_blue save_common_btn">Search</button>
								<span style="padding: 10px;font-weight: bold;font-size: 17px;"> OR </span>
								<input name="submit_download" value="Export to excel" type="submit" class="btn btn_padding filter_btn save_common_btn">
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
		<div class="white_widget padding_3">
			<div class="common_table_widget report_hirarchy new-table">
				<table id="example" class="table table-bordered table-striped">
					<thead>
						<th class="table_width_sr">SL. No.</th>
						<th class="table_width1">Assets Name</th>
						<th class="table_width1">Serial Number</th>
						<th class="table_width1">Reference ID</th>
						<th class="table_width1">Current Location</th>
						<th class="table_width1">Physical Location</th>
						<th class="table_width1">Raised By</th>
						<th class="table_width1">Raised Date</th>
						<th class="employee_adrs">Jitbit ID (Floor Assign)</th>
						<th class="employee_adrs">Assigned By (Floor Assign)</th>
						<th class="employee_adrs">Assigned Date (Floor Assign)</th>
						<th class="employee_adrs">Department (Floor Assign)</th>
						<th class="employee_td">Client (Floor Assign)</th>
						<th class="employee_td">Process (Floor Assign)</th>
						<th class="employee_adrs">Assigned Comments (Floor Assign)</th>
						<th class="table_width1">Brand</th>
						<th class="table_width1">Model Number</th>
						<th class="table_width1">PO Number</th>
						<th class="table_width1">Purchase Type</th>
						<th class="table_width1">Processor</th>
						<th class="table_width1">RAM</th>
						<th class="table_width1">Storage Type</th>
						<th class="table_width1">Storage Size</th>
						<th class="table_width1">Own/rental/client</th>
						<th class="table_width1">Date Purchase</th>
						<th class="table_width1">Vendor Name</th>
						<th class="table_width1">Under Validity</th>
						<th class="table_width1">Valid till</th>
						<th class="table_width1">OS Name</th>
						<th class="table_width1">Conditons</th>
						<th class="table_width1">Company Brand</th>
						<th class="employee_td">Remarks/comments</th>
						<th class="employee_td">Status comments</th>
						<th class="table_width1">Type</th>
						<th class="table_width1">Last Update By</th>
						<th class="employee_adrs">Assigned To (User Assign)</th>
						<th class="employee_adrs">Assigned By (User Assign)</th>
						<th class="employee_adrs">Department (User Assign)</th>
						<th class="employee_adrs">Client (User Assign)</th>
						<th class="employee_td">Process (User Assign)</th>
						<th class="table_width1">Status</th>
						<th class="table_width1">Vendor Email</th>
						<th class="table_width1">Vendor Contact No</th>
						<th class="table_width1">Battery Qty</th>
						<th class="employee_td">Last Inspection date</th>
						<th class="employee_td">Next Inspection date</th>
					</thead>
					<tbody>
						<?php
						$c = 0;
						$stat = "";
						// echo "<pre>"; print_r($assets_data);
						foreach ($assets_data as $value) {
							$c++;
							if ($process_data[$value['id']] != null) {
								$client_name = $process_data[$value['id']][0]['client_name'];
								$process_name = $process_data[$value['id']][0]['process_name'];
								$department_name = $process_data[$value['id']][0]['department_name'];
								$assigned_by = $process_data[$value['id']][0]['assigned_by_floor'];
								$assigned_date = $process_data[$value['id']][0]['assign_date'];
								$assign_comments = $process_data[$value['id']][0]['comments'];
								$jitbit_id = $process_data[$value['id']][0]['jitbit_id'];
							} else {
								$client_name = "-";
								$process_name = "-";
								$department_name = "-";
								$assigned_by = "-";
								$assigned_date = "-";
								$assign_comments = "-";
								$jitbit_id = "-";
							}
							if (!is_null($value['last_inspection_date']) && !is_null($value['next_inspection_dur_days'])) $next_inspection_date = date("Y-m-d", strtotime($value['last_inspection_date'] . " + " . $value['next_inspection_dur_days'] . " days"));
							else $next_inspection_date = "NA";
							if ($value['status'] == 1) $stat = "Un-Assigned/Released";
							if ($value['status'] == 2) $stat = "Assigned";
							if ($value['status'] == 3) $stat = "Scrap";
							if ($value['status'] == 4) $stat = "Defect";
							if ($value['status'] == 5) $stat = "Return(Un-Assigned/Released)";
							if ($value['status'] == 6) $stat = "Stock";
							if ($value['status'] == 7) $stat = "Misplaced / Lost";
							if ($value['status'] == 8) $stat = "Live";
						?>
							<tr>
								<td><?= $c ?></td>
								<td><?= $value['assets_name'] ?></td>
								<td><?= $value['serial_number'] ?></td>
								<td><?= $value['reference_id'] ?></td>
								<td><?= $value['location'] ?></td>
								<td><?= $value['phy_location'] ?></td>
								<td><?= $value['raised_by_name'] ?></td>
								<td><?= $value['raised_date'] ?></td>
								<td><?= $jitbit_id ?></td>
								<td><?= $assigned_by ?></td>
								<td><?= $assigned_date ?></td>
								<td><?= $department_name == "" ? "All" : $department_name ?></td>
								<td><?= $client_name == "" ? "All" : $client_name ?></td>
								<td><?= $process_name == "" ? "All" : $process_name ?></td>
								<td><?= $assign_comments == "" ? " " : $assign_comments ?></td>
								<td><?= $value['brand_name'] ?></td>
								<td><?= $value['model_number'] ?></td>
								<td><?= $value['po_number'] ?></td>
								<td><?php
									if ($value['purchase_type'] == '1') echo "Opex";
									else echo "Capex";
									?></td>
								<td><?= $value['processor_name'] ?></td>
								<td><?= $value['ram_size'] ?></td>
								<td><?php
									if ($value['storage_device_type'] == '1') echo "SSD";
									else echo "HDD";
									?></td>
								<td><?= $value['storage_size'] ?></td>
								<td><?php
									if ($value['own_rental'] == '1') echo "Own";
									elseif ($value['own_rental'] == '2') echo "Rental";
									elseif ($value['own_rental'] == '3') echo "Client";
									else echo "-";
									?></td>
								<td><?= $value['data_purchase'] ?></td>
								<td><?= $value['vendor_name'] ?></td>
								<td><?php
									if ($value['under_validity'] == '1') echo "Yes";
									else echo "No";
									?></td>
								<td><?= $value['valid_thru'] ?></td>
								<td><?= $value['os_name'] ?></td>
								<td><?= $value['conditions'] ?></td>
								<td><?= $value['brand_company'] ?></td>
								<td><?= $value['reamrks'] ?></td>
								<td><?= $value['comments_status'] ?></td>
								<td><?php
									if ($value['type'] == '1') echo "New";
									else echo "Existing";
									?></td>
								<td><?= $value['update_by_name'] ?></td>
								<td><?= $value['assigned_to'] ?></td>
								<td><?= $value['assigned_by'] ?></td>
								<td><?= $value['user_department'] ?></td>
								<td><?= $value['user_client'] ?></td>
								<td><?= $value['user_process'] ?></td>
								<td><?= $stat ?></td>
								<td><?= $value['vendor_email'] ?></td>
								<td><?= $value['vendor_phNo'] ?></td>
								<td><?= $value['battery_qty'] ?></td>
								<td><?= $value['last_inspection_date'] ?></td>
								<td><?= $next_inspection_date; ?></td>
							</tr>
						<?php $c++;
						} ?>
					</tbody>
				</table>
			</div>
		</div>
	</section>
</div>
<script>
    $(function() {
        $('#multiselect').multiselect();
        $('.multiselect_options').multiselect({
            includeSelectAllOption: true,
            enableFiltering: true,
            enableCaseInsensitiveFiltering: true,
            filterPlaceholder: 'Search for something...'
        });
    });


	$(document).ready(function() {
		$('.select-box').selectize({
			sortField: 'text'
		});
	});
</script>
<script src="<?php echo base_url() ?>assets/css/data-table-export/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url() ?>assets/css/data-table-export/js/dataTables.bootstrap.min.js"></script>
<script src="<?php echo base_url() ?>assets/css/data-table-export/js/dataTables.buttons.min.js"></script>
<script src="<?php echo base_url() ?>assets/css/data-table-export/js/buttons.bootstrap.min.js"></script>
<script src="<?php echo base_url() ?>assets/css/data-table-export/js/jszip.min.js"></script>
<script src="<?php echo base_url() ?>assets/css/data-table-export/js/vfs_fonts.js"></script>
<script src="<?php echo base_url() ?>assets/css/data-table-export/js/buttons.html5.min.js"></script>
<script src="<?php echo base_url() ?>assets/css/data-table-export/js/buttons.print.min.js"></script>
<script src="<?php echo base_url() ?>assets/css/data-table-export/js/buttons.colVis.min.js"></script>
<script>
	$(document).ready(function() {
		var table = $('#example').DataTable({
			lengthChange: false,
			buttons: ['', '', '', '']
		});
		table.buttons().container()
			.appendTo('#example_wrapper .col-sm-6:eq(0)');
	});
</script>
<script>
	$(document).on('change', '.selected_check', function() {
		value = $(this).val();
		if (value == "") {
			$(this).closest('div').find('.check_lable').css("color", "#67686a");
			let label_text = $(this).closest('div').find('.check_lable').attr('content_text');
			$(this).closest('div').find('.check_lable').html("");
			$(this).closest('div').find('.check_lable').html(label_text);
		} else {
			let label_text = $(this).closest('div').find('.check_lable').attr('content_text');
			$(this).closest('div').find('.check_lable').html("");
			$(this).closest('div').find('.check_lable').html('<span style="color: #10c469">' + label_text + '</span>');
		}
	});
</script>