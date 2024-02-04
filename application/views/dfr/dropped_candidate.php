<div class="wrap">
	<section class="app-content">
		<div class="row">
			<!-- DataTable -->
			<div class="col-md-12">
				<div class="white_widget padding_3">
					<div class="avail_widget_br">
						<h2 class="avail_title_heading">Dropped Candidate List</h2>
					</div>
					<hr class="sepration_border">
					<div class="body-widget">
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
										<select id="select-brand" name="brand[]" class="form-control" autocomplete="off" placeholder="Select Brand" multiple>

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
							<table id="default-datatable" data-plugin="DataTable" class="table table-bordered table-striped skt-table">
								<thead>
									<tr>
										<th>SL. No.</th>
										<th>Requision Code</th>
										<th>Last Qualification</th>
										<th>Onboarding Type</th>
										<th>Candidate Name</th>
										<th>Gender</th>
										<th>Mobile</th>
										<th>Skill Set</th>
										<th>Total Exp.</th>
										<th>Attachment</th>
										<th>Status</th>
										<?php if (is_access_dfr_module() == 1) { 	////ACCESS PART 
										?>
											<th>Action</th>
										<?php } ?>
									</tr>
								</thead>
								<tbody>
									<?php
									$k = 1;
									$m = 1;
									foreach ($candidate_rejected as $cd) :

										$r_id = $cd['r_id'];
										$c_id = $cd['can_id'];
										$c_status = $cd['candidate_status'];

										if ($c_status == 'P')	$cstatus = "Pending";
										else if ($c_status == 'IP')	$cstatus = "In Progress";
										else if ($c_status == 'SL')	$cstatus = "Shortlisted";
										else if ($c_status == 'CS')	$cstatus = "Selected";
										else if ($c_status == 'E') $cstatus = "Selected as Employee";
										else if ($c_status == 'R') $cstatus = "Rejected";
										else if ($c_status == 'D') $cstatus = "Dropped";

										if ($cd['requisition_status'] == 'CL') {
											$bold = "style='font-weight:bold; color:red'";
										} else {
											$bold = "";
										}

										if ($cd['attachment'] != '') $viewResume = 'View Resume';
										else $viewResume = '';
									?>
										<tr>

											<td><?php echo $k++; ?></td>

											<td <?= $bold ?>><?php echo $cd['requisition_id']; ?></td>
											<td><?php echo $cd['last_qualification']; ?></td>
											<td><?php echo $cd['onboarding_type']; ?></td>
											<td><?php echo $cd['fname'] . " " . $cd['lname']; ?></td>
											<td><?php echo $cd['gender']; ?></td>
											<td><?php echo $cd['phone']; ?></td>
											<td><?php echo $cd['skill_set']; ?></td>
											<td><?php echo $cd['total_work_exp']; ?></td>
											<td><a href="<?php echo base_url(); ?>uploads/candidate_resume/<?php echo $cd['attachment']; ?>"><?php echo $viewResume; ?></a></td>
											<td width="70px"><?php echo $cstatus; ?></td>

											<?php if (is_access_dfr_module() == 1) { 	////ACCESS PART 
											?>
												<td class="table_width2">
													<?php
													$sch_id = $cd['sch_id'];
													$interview_type = $cd['interview_type'];
													$interview_site = $cd['location'];	//echo $interview_site;
													$requisition_id = $cd['requisition_id'];
													$filled_no_position = $cd['filled_no_position'];
													$req_no_position = $cd['req_no_position'];
													$department_id = $cd['department_id'];
													$role_id = $cd['role_id'];
													$sh_status = $cd['sh_status'];


													if ($c_id != "") {
														echo '<a class="btn btn-xs viewCandidate" href="' . base_url() . 'dfr/view_candidate_details/' . $c_id . '" target="_blank"  c_id="' . $c_id . '" r_id="' . $r_id . '" title="Click to View Candidate Details"><img src="' . base_url() . 'assets_home_v3/images/view.svg" alt=""></a>';
														echo '<a class="btn btn-xs rejectCandidateTransfer" r_id="' . $r_id . '" c_id="' . $c_id . '" c_status="' . $c_status . '" title="Transfer Candidate"><img src="' . base_url() . 'assets_home_v3/images/transfer.svg" alt=""></a>';
													}
													?>

													<div class="dropdown action_dropdown d_inline">
														<button class="btn action_dropdown filter_btn dropdown-toggle" type="button" data-toggle="dropdown"
															aria-expanded="true">
															<img src="<?php echo base_url() ?>assets_home_v3/images/dot_menu.svg" alt="">
														</button>
														<ul class="dropdown-menu right_action_column" id="list_dropdown">
															<?php 
																if ($c_id != "") {
																	if ($c_status != 'P') {
																		echo '<li><a class="btn btn-xs candidateInterviewReport" href="' . base_url() . 'dfr/view_candidate_interview/' . $c_id . '"  target="_blank"  c_id="' . $c_id . '" r_id="' . $r_id . '" title="Click to View Candidate Interview Report"><img src="' . base_url() . 'assets_home_v3/images/report_black.svg" alt="">Candidate Interview Report</a></li>';
																	}
																}
															?>
														</ul>
													</div>

												</td>
											<?php } ?>
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


<!---------------Candidate Transfer-------------------->
<div class="modal fade" id="transferRejectCandidateModel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">

			<form class="frmTransferCandidate" action="<?php echo base_url(); ?>dfr/CandidateTransfer" data-toggle="validator" method='POST'>

				<div class="modal-header">
					<button type="button" class="close close_new" data-dismiss="modal" aria-label="Close"></button>
					<h4 class="modal-title" id="myModalLabel">Candidate Transfer</h4>
				</div>
				<div class="modal-body">
					<input type="hidden" id="r_id" name="r_id" class="form-control">
					<input type="hidden" id="c_id" name="c_id" class="form-control">
					<input type="hidden" id="c_status" name="c_status" class="form-control">
					<input type="hidden" name="req_id" id="req_id" value="">

					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label>List of Requisition</label>
								<!--<select class="form-control" id="req_id" name="req_id">
							<option value="">-Select-</option>
							<option value="0">Pool</option>
							<?php foreach ($getrequisition as $row) { ?>
								<option value="<?php echo $row['id']; ?>"><?php echo $row['req_desc']; ?></option>
							<?php } ?>
						</select>-->
								<input type="text" name="search_req" id="search_req" class="form-control" placeholder="Type Requisition Number">
								<div id="searchList"></div>
							</div>
						</div>
					</div>
					<div class="row form-group" style="margin-left:8px" id="req_details">

					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label>Transfer Comment</label>
								<textarea class="form-control" id="transfer_comment" name="transfer_comment"></textarea>
							</div>
						</div>
					</div>

				</div>

				<div class="modal-footer">
					<button type="button" class="btn btn_padding filter_btn save_common_btn" data-dismiss="modal">Close</button>
					<input type="submit" name="submit" class="btn btn_padding filter_btn_blue save_common_btn" value="Save">
				</div>

			</form>

		</div>
	</div>
</div>

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
			numberDisplayed: 1,
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
			numberDisplayed: 1,
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
			numberDisplayed: 1,
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
			numberDisplayed: 1,
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