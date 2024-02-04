<div class="wrap">
	<section class="app-content">
		<div class="white_widget padding_3">
			<h2 class="avail_title_heading">FNF Complete</h2>
			<hr class="sepration_border">
			<div class="body_widget">
				<form method="GET" action="">
					<div class="row">
						<div class="col-md-3">
							<div class="filter-widget">
								<label>Location</label>
								<select class="form-control" name="office_id" id="foffice_id">
									<?php
									//if(get_global_access()==1 || get_role_dir()=="super") echo "<option value='ALL'>ALL</option>";
									?>
									<?php foreach ($location_list as $loc) : ?>
										<?php
										$sCss = "";
										if ($loc['abbr'] == $office_now) $sCss = "selected";
										?>
										<option value="<?php echo $loc['abbr']; ?>" <?php echo $sCss; ?>><?php echo $loc['office_name']; ?></option>
									<?php endforeach; ?>
								</select>
							</div>
						</div>
						<div class="col-md-3">
							<div class="filter-widget">
								<label>Start Date</label>
								<div class="selectdatepick" style="cursor:pointer">
									<input type="text" class="form-control due_date-cal" value="<?php echo $start_date; ?>" name="start_date" id="start_date" placeholder="Start Date" required>
								</div>
							</div>
						</div>
						<div class="col-md-3">
							<div class="filter-widget">
								<label>End Date</label>
								<div class="selectdatepick" style="cursor:pointer">
									<input type="text" class="form-control due_date-cal" value="<?php echo $end_date; ?>" name="end_date" id="end_date" placeholder="End Date" required>
								</div>
							</div>
						</div>
						<div class="col-md-3">
							<label class="visiblity_hidden d_block">View</label>
							<button class="btn btn_padding filter_btn_blue save_common_btn waves-effect" a href="<?php echo base_url() ?>fnf" type="submit" id='btnView' name='btnView' value="View">View</button>
						</div>
					</div>
				</form>
			</div>
		</div>
		<div class="white_widget padding_3">
			<h2 class="avail_title_heading"><?php if (!$search) {
												echo 'Recent FNF Completed List';
											} else {
												echo "FNF Completed";
											} ?>
			</h2>
			<hr class="sepration_border">
			<div class="body_widget">
				<div class="common_table_widget report_hirarchy_new table_export new_fixed_widget">
					<table id="default-datatable" data-plugin="DataTable" class="table table-bordered table-striped skt-table" cellspacing="0" width="100%">
						<thead>
							<tr>
								<th>SL. No.</th>
								<th>Name</th>
								<th>Fusion ID</th>
								<th>Office</th>
								<th>Resign/Term Date</th>
								<th>Release Date/LWD</th>
								<th>IT Local</th>
								<?php if ($office_now != "CAS") { ?>
									<th>IT Network</th>
									<th>IT Helpdesk</th>
									<th>Payroll</th>
									<th>IT Security</th>
									<th>Accounts Status</th>
								<?php } ?>
								<th>FNF Completed</th>
								<th>FNF Status</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$cn = 0;
							foreach ($fnf_complete as $token) {
								$cn++;
								$isOpenFNFBtn = true;
								$fnfid = $token['id'];
								$user_id = $token['user_id'];
								// IT LOCAL
								$local_status = "Pending";
								if ($token['it_local_status'] == 'C') {
									$local_status = "Complete";
								} else $isOpenFNFBtn = false;
								// IT NETWORK
								$network_status = "Pending";
								if ($token['it_network_status'] == 'C') {
									$network_status = "Complete";
								}
								//else $isOpenFNFBtn=false;
								// IT HELPDESK
								$helpdesk_status = "Pending";
								if ($token['it_global_helpdesk_status'] == 'C') {
									$helpdesk_status = "Complete";
								}
								//else $isOpenFNFBtn=false;
								// IT SECURITY
								$security_status = "Pending";
								if ($token['it_security_status'] == 'C') {
									$security_status = "Complete";
								}
								//else $isOpenFNFBtn=false;
								// PAYROLL STATUS
								$payroll_status = "Pending";
								if ($token['payroll_status'] == 'C') {
									$payroll_status = "Complete";
								}
								//else $isOpenFNFBtn=false;
								// ACCOUNTS STATUS
								$account_status = "Pending";
								if ($token['account_status'] == 'C') {
									$account_status = "Complete";
								}
								//else $isOpenFNFBtn=false;
								//$isOpenFNFBtn=true;
								$rnt_date = $token['resign_date'];
								if ($rnt_date == "") $rnt_date = $token['terms_date'];
								$lwd_date = $token['dol'];
								if ($lwd_date == "") $lwd_date = $token['accepted_released_date'];
								if ($lwd_date == "") $lwd_date = $token['lwd'];
							?>
								<tr>
									<td><?php echo $cn; ?></td>
									<td><?php echo $token['fullname']; ?></td>
									<td><?php echo $token['fusion_id']; ?></td>
									<td><?php echo $token['office_id']; ?></td>
									<td><?php echo $rnt_date; ?></td>
									<td><?php echo $lwd_date; ?></td>
									<td><?php echo $local_status; ?></td>
									<?php if ($office_now != "CAS") { ?>
										<td><?php echo $network_status; ?></td>
										<td><?php echo $helpdesk_status; ?></td>
										<td><?php echo $payroll_status; ?></td>
										<td><?php echo $security_status; ?></td>
										<td><?php echo $account_status; ?></td>
									<?php } ?>
									<td><?php echo $token['final_update_date']; ?></td>
									<td><?php echo $token['fnf_status']; ?></td>
									<td class="table_width1">
										<button title='View Details' type='button' fnfid='<?php echo $fnfid; ?>' class='btn btn-xs viewDetailsFNF'>
											<img src="<?php echo base_url(); ?>assets_home_v3/images/view.svg" alt="">
										</button>
										<?php if (isIndiaLocation(get_user_office_id()) == true && (isAccessFNFHr() == true || get_global_access()) && $office_now != "CAS") { ?>
											<a class="btn btn-xs" href="<?php echo base_url(); ?>fnf/send_release_letter/<?php echo $fnfid; ?>/D" target="_blank" title="Download Release_letter "><img src="<?php echo base_url(); ?>assets_home_v3/images/download_action.svg" alt=""></a>
											<a class="btn btn-xs" onclick="return confirm('Are you sure you want to resend the release letter?')" href="<?php echo base_url(); ?>fnf/send_release_letter/<?php echo $fnfid; ?>/Y/Y" title="Click to Resend Release_letter"><img src="<?php echo base_url(); ?>assets_home_v3/images/resend_action.svg" alt=""></a>
										<?php } ?>
									</td>
								</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</section>
</div>
<div class="modal fade" id="fnfDetailsModal" tabindex="-1" role="dialog" aria-labelledby="fnfDetailsModal" aria-hidden="true">
	<div class="modal-dialog modal_common">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close close_new" data-dismiss="modal" data-toggle="validator" aria-label="Close"></button>
				<h4 class="modal-title" id="fnfDetailsModalLabel">FNF Info</h4>
			</div>
			<div class="modal-body">
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn_padding filter_btn save_common_btn" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>

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
		}, ]
	});
	table.buttons().container()
		.appendTo($('.col-sm-6:eq(0)', table.table().container()))
</script>
<!--end datatable-->