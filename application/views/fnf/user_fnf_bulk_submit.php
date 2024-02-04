<div class="common_table_widget report_popup_new_1 leave_table shorting_none">
	<table id="bulk_fnf_area" data-plugin="DataTable" class="table table-bordered table-striped skt-table" cellspacing="0" width="100%">

		<thead>
			<tr>
				<th><input type="checkbox" class="check_bulk_all" name="check_bulk"></th>
				<th>SL. No.</th>
				<th>Name</th>
				<th>Fusion ID</th>
				<th>Office</th>
				<th>Resign/Term Date</th>
				<th>Release Date/LWD</th>
				<th>IT Local</th>
				<!-- <th>IT Network</th> -->
				<th>IT Helpdesk</th>
				<!-- <th>IT Security</th> -->
				<?php /*
				<th>Payroll</th>									
				<th>Accounts Status</th> 
				*/ ?>
				<th>FNF Status</th>
			</tr>
		</thead>
		<tbody>
			<?php
			$cn = 0;
			$confirmFNF = array();
			$checker = 0;
			foreach ($hr_checklist as $token) {
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
				// $network_status = "<span class='text-danger font-weight-bold'><i class='fa fa-circle'></i> Pending</span>"; 
				// if($token['it_network_status'] == 'C'){ $network_status = "<span class='text-success font-weight-bold'><i class='fa fa-circle'></i> Complete</span>"; }
				// else $isOpenFNFBtn=false;

				// IT HELPDESK
				$helpdesk_status = "Pending";
				if ($token['it_global_helpdesk_status'] == 'C') {
					$helpdesk_status = "Complete";
				} else $isOpenFNFBtn = false;

				// IT SECURITY
				// $security_status = "<span class='text-danger font-weight-bold'><i class='fa fa-circle'></i> Pending</span>"; 
				// if($token['it_security_status'] == 'C'){ $security_status = "<span class='text-success font-weight-bold'><i class='fa fa-circle'></i> Complete</span>"; }
				// else $isOpenFNFBtn=false;

				// PAYROLL STATUS
				//$payroll_status = "<span class='text-danger font-weight-bold'><i class='fa fa-circle'></i> Pending</span>"; 
				//if($token['payroll_status'] == 'C'){ $payroll_status = "<span class='text-success font-weight-bold'><i class='fa fa-circle'></i> Complete</span>"; }
				//else $isOpenFNFBtn=false;

				// ACCOUNTS STATUS
				//$account_status = "<span class='text-danger font-weight-bold'><i class='fa fa-circle'></i> Pending</span>"; 
				//if($token['account_status'] == 'C'){ $account_status = "<span class='text-success font-weight-bold'><i class='fa fa-circle'></i> Complete</span>"; }
				//else $isOpenFNFBtn=false;

				//$isOpenFNFBtn=true;
				$rnt_date = $token['resign_date'];
				if ($rnt_date == "") $rnt_date = $token['terms_date'];

				$lwd_date = $token['dol'];
				if ($lwd_date == "") $lwd_date = $token['accepted_released_date'];
				if ($lwd_date == "") $lwd_date = $token['lwd'];

				$holdStatus = $token['is_hold'];
				$holdName = "Hold";
				$classbtn7 = "primary";
				if ($holdStatus == 1) {
					$holdName = "Unhold";
					$classbtn7 = "danger";
				}
				if ($isOpenFNFBtn == true) {
					$checker++;

			?>
					<tr>
						<td><input type="checkbox" class="checkBulkFNF" name="check_bulk_box[]" value="<?php echo $fnfid; ?>"></td>
						<td><?php echo $checker; ?></td>
						<td><?php echo $token['fullname']; ?></td>
						<td><?php echo $token['fusion_id']; ?></td>
						<td><?php echo $token['office_id']; ?></td>
						<td><?php echo $rnt_date; ?></td>
						<td><?php echo $lwd_date; ?></td>
						<td><?php echo $local_status; ?></td>
						<!-- <td><?php echo $network_status; ?></td> -->
						<td><?php echo $helpdesk_status; ?></td>
						<!-- <td><?php echo $security_status; ?></td> -->
						<?php /*
			<td><?php echo $payroll_status; ?></td>								
			<td><?php echo $account_status; ?></td>
			*/ ?>
						<td><?php echo $token['fnf_status']; ?></td>
					</tr>
			<?php }
			} ?>
		</tbody>

	</table>
	<?php if ($checker > 0) { ?>
		<div class="form-group">
			<label for="name">Comments <span class="red_bg">**</span></label>
			<textarea class="form-control" row='6' id="final_comments_bulk" name="final_comments_bulk" required></textarea>
		</div>
		<div class="form-group">
			<button type="submit" class="btn btn_padding filter_btn_blue save_common_btn">Complete FNF</button>
		<?php } else {  ?>
			<span class="text-danger">- No Pending Complete FNF Found -</span>
		<?php } ?>
		</div>
</div>


<script>
	var table = $('#bulk_fnf_area').DataTable({
		lengthChange: false,
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