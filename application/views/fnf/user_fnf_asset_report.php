<div class="wrap">
	<section class="app-content">
		<div class="white_widget padding_3">
			<h2 class="avail_title_heading">User FNF Assets Report</h2>
			<hr class="sepration_border">
			<form method="get">
				<div class="row flex_wrap">
					<div class="col-sm-3 form-group">
						<div class="filter-widget">
							<label>Start date </label>
							<input type="date" name="start_date" type="text" value="<?= $start_date ?>" class="form-control" id="start_date">
						</div>
					</div>
					<div class="col-sm-3 form-group">
						<div class="filter-widget">
							<label>End date </label>
							<input type="date" name="end_date" type="text" value="<?= $end_date ?>" class="form-control" id="end_date">
						</div>
					</div>
					<div class="col-sm-3 form-group">
						<div class="filter-widget new-select">
							<label>Location</label>
							<select name="office_id" id="office_id" class="form-control selectpicker" data-show-subtext="true" data-live-search="true">
								<option value="">All</option>
								<?php foreach ($location_list as $key => $value) {
									$sel = "";
									if ($value['abbr'] == $office_id) $sel = "selected";
								?>
									<option value="<?php echo $value['abbr']; ?>" <?php echo $sel; ?>><?php echo $value['office_name'] ?></option>
								<?php } ?>
							</select>
						</div>
					</div>
					<div class="col-sm-3 form-group margin_all">
						<div class="filter-widget new-select">
							<label>Department</label>
							<select name="dept_search" id="dept_search" class="form-control selectpicker" data-show-subtext="true" data-live-search="true">
								<option value="">All</option>
								<?php foreach ($department_data as $key => $value) {
									$sel = "";
									if ($value['id'] == $dept_search) $sel = "selected";												?>
									<option <?= $sel ?> value="<?php echo $value['id']; ?>"><?php echo $value['shname'] ?></option>
								<?php } ?>
							</select>
						</div>
					</div>
					<div class="col-sm-3 form-group margin_all">
						<div class="filter-widget new-select">
							<label>Assets</label>
							<select name="assets_id" id="assets_id" class="form-control selectpicker" data-show-subtext="true" data-live-search="true">
								<option value="">All</option>
								<?php
								foreach ($assets_list as $value) {
									$sel = "";
									if ($value['id'] == $assets_id) $sel = "selected";
								?>
									<option value="<?= $value['id'] ?>" <?= $sel ?>><?= $value['name'] ?></option>
								<?php } ?>
							</select>
						</div>
					</div>
					<div class="col-sm-3 form-group margin_all">
						<div class="filter-widget">
							<label>Assets Status</label>
							<select name="assign_status" id="assign_status" class="form-control selectpicker">
								<option value="">All</option>
								<option value="1" <?php if ($assign_status == 1) echo 'selected'; ?>>Active Assets</option>
								<option value="2" <?php if ($assign_status == 2) echo 'selected'; ?>>Release Assets</option>
							</select>
						</div>
					</div>
					<div class="col-sm-3 form-group margin_all">
						<div class="filter-widget">
							<label>Fusion ID </label>
							<input type="text" placeholder="Enter Fusion ID" name="fusion_id" type="text" value="<?= $fusion_id ?>" class="form-control" id="fusion_id">
						</div>
					</div>
					<div class="col-sm-3 form-group margin_all">
						<label class="visiblity_hidden d_block">Search</label>
						<button type="submit" class="btn btn_padding filter_btn_blue save_common_btn">
							Search
						</button>
					</div>
				</div>
			</form>
		</div>
		<div class="white_widget padding_3">
			<div class="common_table_widget report_hirarchy_new table_export new_fixed_widget">
				<table id="example" class="table table-bordered table-striped">
					<thead>
						<th>SL. No.</th>
						<th>Name</th>
						<th>Fusion ID</th>
						<th>Location</th>
						<th>Department</th>
						<th>Assets Name</th>
						<th>SL Number</th>
						<th>Model Number</th>
						<th>Assign Date</th>
						<th>IT Local Accepted Status</th>
						<th>IT Local Accepted Date</th>
						<th>IT Local Document</th>
						<th>IT Local Comments</th>
						<th>IT Local Accepted By</th>
						<th>Procurement Team Status</th>
						<th>Procurement Team Release Date</th>
						<th>Procurement Team Document</th>
						<th>Procurement Team Comments</th>
						<th>Procurement Team Released by</th>
						<th>HR Acceptance Status</th>
						<th>HR Acceptance Date</th>
						<th>HR Acceptance Comments</th>
						<th>HR Acceptance by</th>
					</thead>
					<tbody>
						<?php
						$c = 0;
						$it_local_return_date = '';
						$fnf_it_doc = '';
						$fnf_doc = '';
						//echo '<pre>'; print_r($fnf_assets_data); die;
						foreach ($fnf_assets_data as $value) {
							$c++;
							if ($value['fnf_it_local_return_date'] == NULL) {
								$it_local_return_date = '-';
							} else {
								$it_local_return_date = $value['fnf_it_local_return_date'];
							}
							if ($value['fnf_it_doc'] != NULL) {
								$fnf_it_doc = '<a href="' . base_url() . 'it_assets_import/fnf_doc/' . $value['fnf_it_doc'] . '" target="_blank">View</a>';
							} else {
								$fnf_it_doc = 'No Document Found';
							}
							if ($value['fnf_doc'] != NULL) {
								$fnf_doc = '<a href="' . base_url() . 'it_assets_import/fnf_doc/' . $value['fnf_doc'] . '" target="_blank">View</a>';
							} else {
								$fnf_doc = 'No Document Found';
							}
							$itLocalaccstatus = "Pending";
							if ($value['it_local_acceptance_status'] == '1') {
								$itLocalaccstatus = "Complete";
							}
							$procurementstatus = "Pending";
							if ($value['it_procurement_status'] == '1') {
								$procurementstatus = "Complete";
							}
							$hracceptancestatus = "Pending";
							$classbtn = "danger";
							if ($value['hr_acceptance_status'] == '1') {
								$hracceptancestatus = "Complete";
							}
						?>
							<tr>
								<td><?= $c ?></td>
								<td><?= $value['user_name'] ?></td>
								<td><?= $value['fusion_id'] ?></td>
								<td><?= $value['office_id'] ?></td>
								<td><?= $value['department'] ?></td>
								<td><?= $value['assets_name'] ?></td>
								<td><?= $value['serial_number'] ?></td>
								<td><?= $value['model_number'] ?></td>
								<td><?= $value['raised_date'] ?></td>
								<td><?= $itLocalaccstatus ?></td>
								<td><?= $it_local_return_date ?></td>
								<td><?= $fnf_it_doc ?></td>
								<td><?= $value['fnf_it_local_comment'] ?></td>
								<td><?= $value['fnf_it_local_return_by'] ?></td>
								<td><?= $procurementstatus ?></td>
								<td><?= $value['return_date'] ?></td>
								<td><?= $fnf_doc ?></td>
								<td><?= $value['fnf_return_comment'] ?></td>
								<td><?= $value['return_by_name'] ?></td>
								<td><?= $hracceptancestatus ?></td>
								<td><?= $value['hr_acceptance_date'] ?></td>
								<td><?= $value['hr_acceptance_comment'] ?></td>
								<td><?= $value['hr_acceptance_update_by'] ?></td>
							</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>
		</div>
	</section>
</div>
<script>
	$(document).ready(function() {
		$('.select-box').selectize({
			sortField: 'text'
		});
	});
</script>

<!--start datatable-->
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/fixedcolumns/4.3.0/css/fixedColumns.dataTables.min.css">
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/fixedcolumns/4.3.0/js/dataTables.fixedColumns.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.colVis.min.js"></script>
<script>
	var table = $('#example').DataTable({
		lengthChange: false,
		fixedColumns: {
			left: 0,
			right: 1
		},
	});
	new $.fn.dataTable.Buttons(table, {
		buttons: [{
			extend: 'excelHtml5',
			text: 'Export to Excel',
			exportOptions: {
				columns: ':not(:last-child)',
			}
		}, ]
	});
	table.buttons().container()
		.appendTo($('.col-sm-6:eq(0)', table.table().container()))
</script>
<!--end datatable-->
<!--start dropdown sticky-->
<script>
	var dropdownMenu;
	$(document).ready(function() {
		$(window).on('show.bs.dropdown', function(e) {
			dropdownMenu = $(e.target).find('#list_dropdown');
			$('body').append(dropdownMenu.detach());
			var eOffset = $(e.target).offset();
			dropdownMenu.css({
				'display': 'block',
				'top': eOffset.top + $(e.target).outerHeight(),
				'left': eOffset.left,
				'min-width': '80px'
			});
		});
		$(window).on('hide.bs.dropdown', function(e) {
			$(e.target).append(dropdownMenu.detach());
			dropdownMenu.hide();
		});
	});
</script>
<!--end dropdown sticky-->