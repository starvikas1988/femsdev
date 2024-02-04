<div class="row">
	<div class="col-md-12">
		<div class="widget">
			<header class="widget-header">
				<h4 class="widget-title">PMetrix Report</h4>
			</header>
			<hr class="widget-separator">

			<div class="widget-body clearfix">
				<form action="<?php echo base_url('Pm_report/generate_bank_status_xls') ?>" method="POST">
					<div class="row">
						<div class="col-md-4">
							<div class="form-group" id="search_for_container">
								<label for="search_for">Search For</label>
								<select class="form-control" name="search_for" id="search_for" required>
									<option value="">--Select--</option>
									<option value="pm">PMetrix</option>
								</select>
							</div>
						</div>
						<div class="col-md-2">
							<div class="form-group">
								<br>
								<input type="submit" style="margin-top:2px;" class="btn btn-primary btn-md" id="showReports" name="showReports" value="Download Excel">
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>