<div class="wrap">
	<section class="app-content">
		<div class="row">

			<!-- DataTable -->
			<div class="col-md-12">
				<div class="white_widget padding_3">
					<div class="avail_widget_br">
						<h2 class="avail_title_heading">Bench User List</h2>
					</div>
					<hr class="sepration_border">
					<div class="body_widget">
						<?php if (get_global_access() == 1) { ?>
							<div class="row">
								<form id="form_new_user" method="GET" action="<?php echo base_url('dfr/bench_user_list'); ?>">
									<div class="col-md-3">
										<div class="form-group margin_all">
											<label for="office_id">Location</label>
											<select class="form-control" name="off_id" id="officeLocation">
												<option value=''>--Select--</option>
												<option value='All'>All</option>
												<?php foreach ($location_list as $loc) :
													$sCss = "";
													if ($loc['abbr'] == $off_id) $sCss = "selected";
												?>
													<option value="<?php echo $loc['abbr']; ?>" <?php echo $sCss; ?>><?php echo $loc['office_name']; ?></option>
												<?php endforeach; ?>
											</select>
										</div>
									</div>
									<div class="col-md-2">
										<div class="form-group margin_all">
											<label class="visiblity_hidden d_block">View</label>
											<button class="btn btn_padding filter_btn_blue save_common_btn waves-effect" a href="<?php echo base_url() ?>dfr/handover_dfr_requisition" type="submit" id='btnView' name='btnView' value="View">View</button>
										</div>
									</div>

								</form>
							</div>
						<?php } ?>


					</div>


				</div><!-- .widget -->
			</div>
			<!-- END DataTable -->
		</div><!-- .row -->

		<div class="common-top">
			<div class="row">
				<div class="col-sm-12">
					<div class="white_widget padding_3">
						<div class="common_table_widget report_hirarchy_new table_export new_fixed_widget">
							<table id="default-datatable" data-plugin="DataTable" class="table table-bordered table-striped skt-table">
								<thead>
									<tr>
										<th>SL. No.</th>
										<th>Fusion ID</th>
										<th>XPOID</th>
										<th>Name</th>
										<th>Gender</th>
										<th>Office</th>
										<th>Location</th>
										<th>Dept</th>
										<th>Client</th>
										<th>DoJ</th>
										<th>DoB</th>
										<th>Designation</th>
										<th>Org Role</th>
										<th>Level-1 Supervisor</th>
										<th>Process</th>
										<th>Status</th>
										<!-- <th>Action</th> -->
									</tr>
								</thead>
								<tbody>
									<?php
									// print_r($benchlist); 
									$i = 1;
									foreach ($benchlist as $row) :

									?>
										<tr>
											<td><?php echo $i++; ?></td>
											<td><?php echo $row['fusion_id']; ?></td>
											<td><?php echo $row['xpoid']; ?></td>
											<td><?php echo $row['fname'] . " " . $row['lname']; ?></td>
											<td><?php echo $row['sex']; ?></td>
											<td><?php echo $row['office_name']; ?></td>
											<td><?php echo $row['location']; ?></td>
											<td><?php echo $row['d_fullname']; ?></td>
											<td><?php echo $row['c_fullname']; ?></td>
											<td><?php echo $row['doj']; ?></td>
											<td><?php echo $row['dob']; ?></td>
											<td><?php echo $row['rolename']; ?></td>
											<td><?php echo $row['roleorgname']; ?></td>
											<td><?php echo $row['lpname']; ?></td>
											<td><?php echo $row['p_fullname']; ?></td>
											<td><?php if ($row['is_on_bench'] == "Y") { ?>
													Unpaid
												<?php } else { ?>Paid<?php } ?>
											</td>
											<!-- <td>
												<?php
												?>
											</td> -->
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

<!----------------------------------------------------------------->

<!-------------------- closed Requisition model ----------------------------->
<div class="modal fade" id="closedRequisitionModel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">

			<form class="frmclosedRequisition" action="<?php echo base_url(); ?>dfr/handover_closed_requisition" data-toggle="validator" method='POST'>

				<div class="modal-header">
					<button type="button" class="close close_new" data-dismiss="modal" aria-label="Close"></button>
					<h4 class="modal-title" id="myModalLabel">Closed & Handover Requisition</h4>
				</div>
				<div class="modal-body">
					<input type="hidden" id="rid" name="rid">
					<input type="hidden" id="handoverid" name="handoverid">
					<input type="hidden" id="dept_id" name="dept_id">
					<input type="hidden" id="role_folder" name="role_folder">
					<input type="hidden" id="raised_by" name="raised_by">

					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label>Assign TL</label>
								<input type="text" readonly id="handoverName" name="handoverName" class="form-control">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>Phase Type</label>
								<select id="" name="phase_type" class="form-control">
									<option value="2">Training</option>
								</select>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label>Comment</label>
								<textarea class="form-control" id="closed_comment" name="closed_comment" required></textarea>
							</div>
						</div>
					</div>

				</div>

				<div class="modal-footer">
					<button type="button" class="btn btn_padding filter_btn save_common_btn" data-dismiss="modal">Close</button>
					<button type="submit" id='closedRequisition' class="btn btn_padding filter_btn_blue save_common_btn">Save</button>
				</div>

			</form>

		</div>
	</div>
</div>


<div class="modal fade" id="closedRequisitionModel1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">

			<form class="frmclosedRequisition1" action="<?php echo base_url(); ?>dfr/handover_closed_requisition" data-toggle="validator" method='POST'>

				<div class="modal-header">
					<button type="button" class="close close_new" data-dismiss="modal" aria-label="Close"></button>
					<h4 class="modal-title" id="myModalLabel">Closed & Handover Requisition</h4>
				</div>
				<div class="modal-body">
					<input type="hidden" id="rid" name="rid">
					<input type="hidden" id="handoverid" name="handoverid">
					<input type="hidden" id="dept_id" name="dept_id">
					<input type="hidden" id="role_folder" name="role_folder">
					<input type="hidden" id="raised_by" name="raised_by">

					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label>Assign TL</label>
								<input type="text" readonly id="handoverName" name="handoverName" class="form-control">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>Phase Type</label>
								<select id="" name="phase_type" class="form-control">
									<option value="4">Production</option>
									<option value="2">Training</option>
								</select>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label>Comment</label>
								<textarea class="form-control" id="closed_comment" name="closed_comment" required></textarea>
							</div>
						</div>
					</div>

				</div>

				<div class="modal-footer">
					<button type="button" class="btn btn_padding filter_btn save_common_btn" data-dismiss="modal">Close</button>
					<button type="submit" id='closedRequisition1' class="btn btn_padding filter_btn_blue save_common_btn">Save</button>
				</div>

			</form>

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