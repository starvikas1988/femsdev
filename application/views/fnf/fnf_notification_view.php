<style>
	.simple-page-form {
		padding: 10px 24px 20px 24px;
	}
</style>

<div class="wrap">
	<section class="app-content">

		<div class="simple-page-wrap" style="width:80%;">
			<div class="simple-page-form animated flipInY" style="margin-bottom: 60px;">
				<h4 class="form-title text-center"><?php echo $showup; ?> FNF Notifications</h4>

				<hr />

				<div style="padding:0 10px;text-align:center">
					<p><b>Total FNF Pending : </b><?php echo $total; ?></p>

					<?php if (!empty($last3Days)) { ?>
						<?php if ($total >= $last3Days[0]['fnf_count']) { ?>
							<span class="text-danger"><b>** NOTE : Please complete your pending FNF</b></span><br />
							3 Days Ago : <b><?php echo $last3Days[0]['fnf_count']; ?> FNF</b> was pending | Today : <b><?php echo $total; ?></b> Pending <br /><br />
						<?php } ?>
					<?php } ?>

					<center>
						<div class="common_table_widget report_hirarchy_new table_export new_fixed_widget">
							<table class="table table-bordered table-striped">
								<thead>
									<?php if ($showup == "IT") { ?>
										<tr>
											<th class="text-center">Office</th>
											<th class="text-center">Department</th>
											<th class="text-center">FNF Pending</th>
										</tr>
									<?php } else { ?>
										<tr>
											<th class="text-center">Office</th>
											<th class="text-center">FNF Pending</th>
										</tr>
									<?php } ?>

								</thead>
								<tbody>
									<?php if ($showup == "IT") {
										foreach ($fnf_list_it_global as $fToken) {
											if (isIndiaLocation($fToken['office_id'])) { ?>
												<tr>
													<td class="text-center"><b><?php echo $fToken['office_id']; ?></b></td>
													<td class="text-center">IT Global Helpdesk</td>
													<td class="text-center"><?php echo $fToken['value']; ?></td>
												</tr>
											<?php }
										}
										foreach ($fnf_list_it_local as $fToken) {
											if (isIndiaLocation($fToken['office_id'])) { ?>
												<tr>
													<td class="text-center"><b><?php echo $fToken['office_id']; ?></b></td>
													<td class="text-center">IT Local</td>
													<td class="text-center"><?php echo $fToken['value']; ?></td>
												</tr>
											<?php }
										}
										/*foreach($fnf_list_it_network as $fToken){ 
			if(isIndiaLocation($fToken['office_id'])){ ?> 
				<tr>
				    <td class="text-center"><b><?php echo $fToken['office_id']; ?></b></td>
					<td class="text-center">IT Network</td>
					<td class="text-center"><?php echo $fToken['value']; ?></td>
				</tr>
			<?php } }*/
									} else {
										foreach ($fnf_list as $fToken) {
											if (isIndiaLocation($fToken['office_id'])) {
											?>
												<tr>
													<td class="text-center"><b><?php echo $fToken['office_id']; ?></b></td>
													<td class="text-center"><?php echo $fToken['value']; ?></td>
												</tr>
									<?php }
										}
									} ?>
								</tbody>
							</table>
						</div>
					</center>
				</div>

				<form action="<?php echo base_url('fnf/fnf_submission_info'); ?>" data-toggle="validator" autocomplete="off" method='POST'>
					<div class="form-group text-center">
						<strong>Date & Time :</strong> <?php echo date('d M, Y h:i A', strtotime(GetLocalTime())); ?> <br />
					</div>
					<div class="text-center">
						<a href="<?php echo base_url('fnf/fnf_submission_info/fnf/' . $total); ?>" class="btn btn_padding filter_btn" style="width:220px;">Go To FNF</a>
						<a href="<?php echo base_url('fnf/fnf_submission_info/skip/' . $total); ?>" class="btn btn_padding filter_btn pull-right" style="display:inline;width:120px;">Skip Now</a>
					</div>

				</form>
			</div>
		</div>

	</section>
</div>

<br>