<div class="wrap">
	<section class="app-content">
		<div class="row">
			<!-- DataTable -->
			<div class="col-md-12">
				<div class="white_widget padding_3">
					<div class="avail_widget_br">
						<h2 class="avail_title_heading">All Candidate List</h2>
					</div>
					<hr class="sepration_border">
					<div class="body_widget">
						<?php echo form_open('', array('method' => 'get')) ?>
						<input type="hidden" id="req_status" name="req_status" value='<?php echo $req_status; ?>'>
						<div class="body_widget">
							<div class="row">
								<div class="col-sm-3">
									<div class="form-group">
										<label>Start Date</label>
										<input type="text" class="form-control due_date-cal" id="from_date" name="from_date" value="<?php echo $from_date; ?>" autocomplete="off">
									</div>
								</div>
								<div class="col-sm-3">
									<div class="form-group">
										<label>End Date</label>
										<input type="text" class="form-control due_date-cal" id="to_date" name="to_date" value="<?php echo $to_date; ?>" autocomplete="off">
									</div>
								</div>
								<div class="col-sm-3">
									<div class="form-group filter-widget">
										<label>Brand</label>
										<select id="select-brand" name="brand[]" class="form-control" autocomplete="off" placeholder="--Select--" multiple>

											<?php foreach ($company_list as $key => $value) {
												$bss = "";
												if (in_array($value['id'], $brand)) $bss = "selected";
											?>
												<option value="<?php echo $value['id']; ?>" <?php echo $bss; ?>><?php echo $value['name']; ?></option>
											<?php  } ?>
										</select>
									</div>
								</div>
								<div class="col-sm-3">
									<div class="form-group filter-widget">
										<label>Location</label>
										<select id="fdoffice_ids" name="office_id[]" autocomplete="off" placeholder="Select Location" multiple>

											<?php
											//if(get_global_access()==1 || get_role_dir()=="super") echo "<option value='ALL'>ALL</option>";
											?>
											<?php foreach ($location_list as $loc) : ?>
												<?php
												$sCss = "";
												if (in_array($loc['abbr'], $oValue)) $sCss = "selected";
												?>
												<option value="<?php echo $loc['abbr']; ?>" <?php echo $sCss; ?>><?php echo $loc['office_name']; ?></option>

											<?php endforeach; ?>
										</select>
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-sm-3">
									<div class="form-group filter-widget">
										<label>Department</label>
										<select id="select-department" class="form-control" name="department_id[]" autocomplete="off" placeholder="--Select--" multiple>
											<?php
											foreach ($department_list as $k => $dep) {
												$sCss = "";
												if (in_array($dep['id'], $o_department_id)) $sCss = "selected";
											?>
												<option value="<?php echo $dep['id']; ?>" <?php echo $sCss; ?>><?php echo $dep['shname']; ?></option>
											<?php
											}
											?>
										</select>
									</div>
								</div>

								<div class="col-sm-3">
									<div class="form-group filter-widget">
										<label>Client</label>
										<select id="fclient_id" name="client_id[]" autocomplete="off" placeholder="--Select--" multiple>
											<?php foreach ($client_list as $client) :
												$cScc = '';
												if (in_array($client->id, $client_id)) $cScc = 'Selected';
											?>
												<option value="<?php echo $client->id; ?>" <?php echo $cScc; ?>><?php echo $client->shname; ?></option>
											<?php endforeach; ?>
										</select>
									</div>
								</div>
								<div class="col-sm-3">
									<div class="form-group filter-widget">
										<label>Process</label>
										<select id="fprocess_id" name="process_id" autocomplete="off" placeholder="--Select--" class="select-box">
											<option value="">--Select--</option>
											<?php foreach ($process_list as $process) :
												$cScc = '';
												if ($process->id == $process_id) $cScc = 'Selected';
											?>
												<option value="<?php echo $process->id; ?>" <?php echo $cScc; ?>><?php echo $process->name; ?></option>
											<?php endforeach; ?>
										</select>
									</div>
								</div>
								<div class="col-sm-3" id="requisation_div" style="display:none;">
									<div class="form-group filter-widget">
										<label>Requisition</label>
										<select autocomplete="off" name="requisition_id[]" id="edurequisition_id" placeholder="--Select--" class="select-box">
											<option="">All</option>
												<?php /*foreach($get_requisition as $gr): ?>
											<?php
												$sRss="";
												if($gr['requisition_id']==$requisition_id) $sRss="selected";
											?>
												<option value="<?php echo $gr['requisition_id']; ?>" <?php echo $sRss; ?>><?php echo $gr['requisition_id']; ?></option>
											<?php endforeach;*/ ?>
										</select>
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-sm-12">
									<div class="form-group margin_all">
										<button type="submit" name="search" id="search" value="Search" class="btn btn_padding filter_btn_blue save_common_btn">
											Search
										</button>
									</div>
								</div>
							</div>

						</div>

						</form>
					</div>
				</div><!-- .widget -->
			</div>
			<!-- END DataTable -->
		</div><!-- .row -->

		<div class="common-top">
			<div class="row">
				<div class="col-sm-12">
					<div class="white_widget padding_3">
						<div class="common_table_widget new_table_chan table_export new_fixed_widget">
							<table id="default-datatable" data-plugin="DataTable" class="table table-bordered table-striped">
								<thead>
									<tr>
										<th>SL. No.</th>
										<th>Requision Code</th>
										<th>Candidate Name</th>
										<th>Hiring Source</th>
										<th>Onboarding Type</th>
										<th>Gender</th>
										<th>Mobile</th>
										<th>DOB</th>
										<th>State</th>
										<th>City</th>
										<th>Postcode</th>
										<th>Country</th>
										<th>Status</th>
										<th>Added Date/Time</th>
									</tr>
								</thead>
								<tbody id="myTable">
									<?php $i = 1;
									foreach ($list_candidates as $row) :

										$rid = $row['rid']; //echo $rid;

										if ($row['candidate_status'] == 'P') {
											$status = "Pending";
										} else if ($row['candidate_status'] == 'IP') {
											$status = "In Progress";
										} else if ($row['candidate_status'] == 'SL') {
											$status = "Shortlisted";
										} else if ($row['candidate_status'] == 'CS') {
											$status = "Candidate Selected";
										} else if ($row['candidate_status'] == 'E') {
											$status = "Candidate Select as Employee";
										} else if ($row['candidate_status'] == 'D') {
											$status = "Dropped Candidate";
										} else {
											$status = "Rejected";
										}

										if ($row['requisition_status'] == 'CL') {
											$fcolor = "style='color:red'";
										} else {
											$fcolor = "";
										}
									?>
										<tr>
											<td><?php echo $i++; ?></td>

											<td><a href="<?php echo base_url(); ?>dfr/view_requisition/<?php echo $rid; ?>" target="_blank" <?= $fcolor; ?>><?php echo $row['req_id']; ?></a></td>

											<td><?php echo $row['fname'] . " " . $row['lname']; ?></td>
											<td><?php echo $row['hiring_source']; ?></td>
											<td><?php echo $row['onboarding_type']; ?></td>
											<td><?php echo $row['gender']; ?></td>
											<td><?php echo $row['phone']; ?></td>
											<td><?php echo $row['d_o_b']; ?></td>
											<td><?php echo $row['state']; ?></td>
											<td><?php echo $row['city']; ?></td>
											<td><?php echo $row['postcode']; ?></td>
											<td><?php echo $row['country']; ?></td>
											<td><?php echo $status; ?></td>
											<td><?php echo $row['added_date']; ?></td>
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

</div><!-- .wrap -->

<script type="text/javascript">
	document.querySelector("#req_no_position").addEventListener("keypress", function(evt) {
		if (evt.which != 8 && evt.which != 0 && evt.which < 48 || evt.which > 57) {
			evt.preventDefault();
		}
	});
</script>
<script>
	/*$(function() {  
 $('#multiselect').multiselect();

 $('#edurequisition_id').multiselect({
            includeSelectAllOption: true,
            enableFiltering: true,
            enableCaseInsensitiveFiltering: true,
            filterPlaceholder: 'Search for something...'
        }); 
}); */
</script>
<script>
	$(function() {
		$('#multiselect').multiselect();

		$('#fdoffice_ids').multiselect({
			includeSelectAllOption: true,
			enableFiltering: true,
			numberDisplayed: 2,
			enableCaseInsensitiveFiltering: true,
			filterPlaceholder: 'Search for something...'
		});
	});
</script>
<script>
	$(function() {
		$('#multiselect').multiselect();

		$('#select-brand').multiselect({
			includeSelectAllOption: true,
			enableFiltering: true,
			numberDisplayed: 2,
			enableCaseInsensitiveFiltering: true,
			filterPlaceholder: 'Search for something...'
		});
	});
</script>

<script>
	$(function() {
		$('#multiselect').multiselect();

		$('#fclient_id').multiselect({
			includeSelectAllOption: true,
			enableFiltering: true,
			numberDisplayed: 2,
			enableCaseInsensitiveFiltering: true,
			filterPlaceholder: 'Search for something...'
		});
	});
</script>
<script>
	/*$(function() {  
 $('#multiselect').multiselect();

 $('#fprocess_id').multiselect({
            includeSelectAllOption: true,
            enableFiltering: true,
            enableCaseInsensitiveFiltering: true,
            filterPlaceholder: 'Search for something...'
        }); 
}); */
</script>
<script>
	$(function() {
		$('#multiselect').multiselect();

		$('#select-department').multiselect({
			includeSelectAllOption: true,
			enableFiltering: true,
			numberDisplayed: 2,
			enableCaseInsensitiveFiltering: true,
			filterPlaceholder: 'Search for something...'
		});
	});
</script>
<script>
	$(document).ready(function() {
		$('.select-box').selectize({
			sortField: 'text'
		});
	});

	//From date , to date restriction//
	$(document).ready(function(){
	///////////////////////
	var d = new Date();
	var monthNames = ["January", "February", "March", "April", "May", "June",
		"July", "August", "September", "October", "November", "December"];
	today = monthNames[d.getMonth()] + ' ' + d.getDate() + ' ' + d.getFullYear();


	$('#from_date').datepicker({
		defaultDate: "+1d",
		//minDate: 1,
		maxDate: new Date(), // Set maxDate to the current date
		dateFormat: 'yy-mm-dd',
		showOtherMonths: true,
		changeMonth: true,
		selectOtherMonths: true,
		required: true,
		showOn: "focus",
		numberOfMonths: 1,
	});

	$('#to_date').datepicker({
		defaultDate: "+1d",
		minDate: "<?php echo date('Y-m-d', strtotime(($from_date))); ?>", // Set maxDate to the current date
		maxDate: new Date(), // Set maxDate to the current date
		dateFormat: 'yy-mm-dd',
		showOtherMonths: true,
		changeMonth: true,
		selectOtherMonths: true,
		required: true,
		showOn: "focus",
		numberOfMonths: 1,
	});

	$('#from_date').change(function () {
		var from = $('#from_date').datepicker('getDate');
		var date_diff = Math.ceil((from.getTime() - Date.parse(today)) / 86400000);
		
		var maxDate_d = date_diff+6+'d';
		date_diff = date_diff + 'd';
		$('#to_date').val('').removeClass('hasDatepicker').datepicker({
			dateFormat: 'yy-mm-dd',
			minDate: date_diff,
			maxDate: new Date(), // Set maxDate to the current date
		});
	});

	$('#to_date').keyup(function () {
		$(this).val('');
		alert('Please select date from Calendar');
	});
	$('#from_date').keyup(function () {
		$('#from_date,#to_date').val('');	
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
		scrollX: true,
      scrollCollapse: true,
      fixedHeader: true,
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