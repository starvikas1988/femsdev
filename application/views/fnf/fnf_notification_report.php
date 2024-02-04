<div class="wrap">
	<section class="app-content">
		<div class="white_widget padding_3">
			<h2 class="avail_title_heading">FNF Notification Report</h2>
			<hr class="sepration_border">
			<div class="body_widget clearfix">
				<form method="POST">
					<div class="row">
						<div class="col-md-3">
							<div class="form-group margin_all">
								<label>User</label>
								<select class="form-control" name="user_id" id="user_id" required>
									<?php if (get_global_access() == '1') {
										echo "<option value='ALL'>All</option>";
									} ?>
									<?php
									$past_token = '';
									foreach ($queryReportnotification as $token)
										if ($token['user_name'] != $past_token) {
											echo '<option value="' . $token['user_id'] . '" ' . $varso . '>' . $token['user_name'] . ' (' . $token['fusion_id'] . ')' . '</option>';
											$past_token = $token['user_name'];
										}
									?>
								</select>
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group margin_all">
								<label>Start Date</label>
								<div class="selectdatepick" style="cursor:pointer">									
									<input type="text" class="form-control due_date-cal" value="<?php echo $start_date; ?>" name="start_date" id="start_date" placeholder="Start Date" required>
								</div>
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group margin_all">
								<label>End Date</label>
								<div class="selectdatepick" style="cursor:pointer">									
									<input type="text" class="form-control due_date-cal" value="<?php echo $end_date; ?>" name="end_date" id="end_date" placeholder="End Date" required>
								</div>
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group margin_all">
								<label class="visiblity_hidden d_block">Download</label>
								<button class="btn btn_padding filter_btn save_common_btn save_common_btn" name="fnf_download" value="fnf_download" type="submit">Download</button>
							</div>
						</div>
					</div>					
				</form>
			</div>
		</div>
</div>
</section>
</div>