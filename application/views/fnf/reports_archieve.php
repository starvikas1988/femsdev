<div class="wrap">
	<section class="app-content">
		<div class="white_widget padding_3">
			<h2 class="avail_title_heading">Download Reports Archive</h2>
			<hr class="sepration_border">
			<div class="body_widget clearfix">
				<form method="POST">
					<div class="row">
						<div class="col-md-3">
							<div class="form-group margin_all">
								<label>Office</label>
								<select class="form-control" name="office_id" id="office_id" required>
									<?php if (get_global_access() == '1') {
										echo "<option value='ALL'>All</option>";
									} ?>
									<?php
									foreach ($location_list as $token) {
										if ($token['is_active'] == 1) {
											$varso = "";
											if ($token['abbr'] == $office_now) {
												$varso = "selected";
											}
											echo '<option value="' . $token['abbr'] . '" ' . $varso . '>' . $token['office_name'] . '</option>';
										}
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
								<button class="btn btn_padding filter_btn save_common_btn" type="submit">Download</button>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
</div>
</section>
</div>