<div class="wrap">
	<section class="app-content">
		<div class="row">
			<div class="col-md-12">
				<div class="white_widget padding_3">
					<div class="row">
						<div class="col-md-10">
							<div class="avail_widget_br">
								<h2 class="avail_title_heading">Employee Referral List </h2>
							</div>
						</div>
					</div>
					<hr class="sepration_border">

					<div class="body_widget">
						<form method="GET" action="">
							<!--start old backup php code-->
							<div class="row">
								<div class="col-md-3">
									<div class="form-group">
										<label>Date From</label>
										<input type="text" id="date_from" name="date_from" value="<?php echo date('m/d/Y', strtotime(($date_from))); ?>" class="form-control due_date-cal" autocomplete="off" required>
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<label>Date To</label>
										<input type="text" id="date_to" name="date_to" value="<?php echo date('m/d/Y', strtotime(($date_to))); ?>" class="form-control due_date-cal" autocomplete="off" required>
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group" id="foffice_div" <?php //echo $oHid;
																				?>>
										<label>Location</label>
										<select class="form-control" name="office_id" id="office_id">
											<?php
											if (get_global_access() == 1) echo "<option value=''>ALL</option>";
											?>
											<?php foreach ($location_list as $loc) : ?>
												<?php
												$sCss = "";
												if ($loc['abbr'] == $office_id) $sCss = "selected";
												?>
												<option value="<?php echo $loc['abbr']; ?>" <?php echo $sCss; ?>><?php echo $loc['office_name']; ?></option>

											<?php endforeach; ?>

										</select>
									</div>
								</div>

								<div class="col-md-3">
									<div class="form-group" id="foffice_div" <?php //echo $oHid;
																				?>>
										<label>Status</label>
										<select class="form-control" name="ref_status">
											<option value=''>All</option>
											<?php foreach (_ref_show_status_name() as $key => $tokenop) { ?>
												<?php
												$sCss = "";
												if ($key == $s_ref_status) $sCss = "selected";
												?>
												<option value='<?php echo $key; ?>'><?php echo $tokenop; ?></option>
											<?php } ?>
										</select>
									</div>
								</div>
								<!--<div class="col-md-2">
									<div class="form-group margin_all" id="download" <?php //echo $oHid;
																			?>>
										<label>Download</label><br />
										<input type="checkbox" id="download" name="download" value="download"> Download Excel
									</div>
								</div>-->

								<div class="col-md-4">
									<div class="form-group margin_all">										
										<button class="btn btn_padding filter_btn_blue waves-effect save_common_btn" a href="<?php echo base_url() ?>reports_hr/add_referrals_lists" type="submit" id='show' name='show' value="Show">Search</button>
										<button class="btn btn_padding filter_btn waves-effect save_common_btn" type="submit" id='export' name='export' value="Export">Download</button>
									</div>
								</div>

							</div>
							<!--end old backup php code-->

						</form>
					</div>
				</div>
			</div>
		</div>

		<div class="common-top">
			<div class="row">
				<div class="col-sm-12">
					<div class="white_widget padding_3">
						<div class="common_table_widget report_hirarchy_new table_export new_fixed_widget">
							<table id="default-datatable" data-plugin="DataTable" class="table table-bordered table-striped skt-table">
								<thead>
									<tr>
										<th>SL. No.</th>
										<th>Name</th>
										<th>Location</th>
										<th>Site</th>
										<th>Phone</th>
										<th>Email</th>
										<th>CV</th>
										<th>Added By</th>
										<th>Fusion ID</th>
										<th>Department</th>
										<th>Client</th>
										<th>Process</th>
										<th>Added Date</th>
										<th>Status</th>
										<th class="table_width">Action</th>
									</tr>
								</thead>
								<tbody>
									<?php $i = 1;

									// FOR STATUS
									function _ref_show_status_name($check = "")
									{
										$resultArray = array(
											"P" => "Pending",
											"A" => "Shortlisted",
											"R" => "Rejected",
											"C" => "Moved to Requisiton",
											"X" => "Call Back",
										);
										$finalResult = $resultArray;
										if (!empty($check)) {
											$finalResult = $resultArray[$check];
										}
										return $finalResult;
									}
									function _ref_show_status_color($check = "")
									{
										$resultArray = array(
											"P" => "",
											"A" => "",
											"R" => "",
											"C" => "",
											"X" => "",
										);
										$finalResult = $resultArray;
										if (!empty($check)) {
											$finalResult = $resultArray[$check];
										}
										return $finalResult;
									}


									foreach ($add_referrals_list as $row) :
									?>
										<tr>
											<td><?php echo $i++; ?></td>
											<td><?php echo $row['name']; ?></td>
											<td><?php echo $row['off_loc']; ?></td>
											<td><?php echo $row['site_name']; ?></td>
											<td><?php echo $row['phone']; ?></td>
											<td><?php echo $row['email']; ?></td>
											<td>
												<?php if (!empty($row['attachment_cv'])) { ?>
													<a title="<?php echo $row['attachment_cv']; ?>" style="cursor:pointer" onclick="window.open('<?php echo base_url() . "dfr/employee_referral_attachment_view?filedir=" . base64_encode($row['attachment_cv']); ?>','popUpWindow','height=500,width=400,left=100,top=100,resizable=no,scrollbars=no,toolbar=no,menubar=no,location=no,directories=no, status=yes');"><b><i class="fa fa-download"></i> <?php echo substr($row['attachment_cv'], 0, 15);
																																																																																																														if (strlen($row['attachment_cv']) > 15) {
																																																																																																															echo "..";
																																																																																																														} ?></b></a>
												<?php } ?>
											</td>
											<td><?php echo $row['added_name']; ?></td>
											<td><?php echo $row['referral_fusionid']; ?></td>
											<td><?php echo $row['department']; ?></td>
											<td><?php echo $row['client_name']; ?></td>
											<td><?php echo $row['process_name']; ?></td>
											<td><?php echo $row['added_date']; ?></td>
											<td><span class="text text-<?php echo _ref_show_status_color($row['ref_status']); ?>"><?php echo _ref_show_status_name($row['ref_status']); ?></span></td>
											<td width="100px;">
												<a title="View" eid="<?php echo $row['id']; ?>" class="btn btn-xs btnInfoReferral"><img src="<?php echo base_url().'assets_home_v3/images/view.svg'?>" alt=""></a>
												<?php if (!empty($row['ref_requisition_id'])) { ?>
													<a title="View Requisiton" target="_blank" href="<?php echo base_url('dfr/view_requisition/' . $row['ref_requisition_id']); ?>" class="btn btn-xs"><img src="<?php echo base_url().'assets_home_v3/images/view_requisition.svg'?>" alt=""></a>
												<?php } ?>
											</td>
										</tr>
									<?php endforeach; ?>
								</tbody>								
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>

	</section>
</div>



<div class="modal fade" id="modalInfoReferral" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="modalInfoReferral" aria-hidden="true">
	<div class="modal-dialog modal_common refrral_widget">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close close_new" data-dismiss="modal" aria-label="Close"></button>
				<h4 class="modal-title">Referral Info</h4>
			</div>
			<div class="modal-body">
				<span class="text-danger">-- No Info Found --</span>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn_padding filter_btn save_common_btn" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>

<script>
	$(document).ready(function() {
		$('.select-box').selectize({
			sortField: 'text'
		});
	});
</script>
<script>
	$(function() {
		$('#multiselect').multiselect();

		$('#multiselectwithsearch').multiselect({
			includeSelectAllOption: true,
			enableFiltering: true,
			enableCaseInsensitiveFiltering: true,
			filterPlaceholder: 'Search for something...'
		});
	});

	$(document).ready(function(){
	///////////////////////
	var d = new Date();
	var monthNames = ["January", "February", "March", "April", "May", "June",
		"July", "August", "September", "October", "November", "December"];
	today = monthNames[d.getMonth()] + ' ' + d.getDate() + ' ' + d.getFullYear();


	$('#date_from').datepicker({
		defaultDate: "+1d",
		//minDate: 1,
		maxDate: new Date(), // Set maxDate to the current date
		dateFormat: 'mm/dd/yy',
		showOtherMonths: true,
		changeMonth: true,
		selectOtherMonths: true,
		required: true,
		showOn: "focus",
		numberOfMonths: 1,
	});

	$('#date_to').datepicker({
		defaultDate: "+1d",
		minDate: "<?php echo date('m/d/Y', strtotime(($date_from))); ?>",
		maxDate: new Date(), // Set maxDate to the current date
		dateFormat: 'mm/dd/yy',
		showOtherMonths: true,
		changeMonth: true,
		selectOtherMonths: true,
		required: true,
		showOn: "focus",
		numberOfMonths: 1,
	});

	$('#date_from').change(function () {
		var from = $('#date_from').datepicker('getDate');
		var date_diff = Math.ceil((from.getTime() - Date.parse(today)) / 86400000);
		
		var maxDate_d = date_diff+6+'d';
		date_diff = date_diff + 'd';
		$('#date_to').val('').removeClass('hasDatepicker').datepicker({
			dateFormat: 'mm/dd/yy',
			minDate: date_diff,
			maxDate: new Date(), // Set maxDate to the current date
		});
	});

	$('#date_to').keyup(function () {
		$(this).val('');
		alert('Please select date from Calendar');
	});
	$('#date_from').keyup(function () {
		$('#date_from,#date_to').val('');	
		alert('Please select date from Calendar');
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
    var table = $('#default-datatable').DataTable({
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
        },]
    });
    table.buttons().container()
        .appendTo($('.col-sm-6:eq(0)', table.table().container()))
</script>
<!--end datatable-->