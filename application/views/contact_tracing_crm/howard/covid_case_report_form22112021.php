<style>
	.table-widget td {
		padding:10px!important;
		font-size:14px;
	}
	.common-top {
		margin:20px 0 0 0;
	}
	.table-widget strong {
		margin:0 5px 0 0;
	}
	.submit-btn {
		width: 200px;
		padding: 10px;
		background: #188ae2;
		color: #fff;
		border: none;
		border-radius: 5px;		
		font-size:14px;
		letter-spacing:0.5px;
		transition: all 0.5s ease-in-out 0s;
	}
	.submit-btn:hover {
		background: #0e6cb5;
	}
	.submit-btn:focus {
		outline: none;
		box-shadow: none;
	}
	.caller-widget .form-control {
		width: 100%;
		height: 35px;
		font-size: 14px;
		transition: all 0.5s ease-in-out 0s;
	}
	.caller-widget .form-control:hover {
		border: 1px solid #188ae2;
	}
	.caller-widget .form-control:focus {
		border: 1px solid #188ae2;
		outline: none;
		box-shadow: none;
	}
	.modal-header {
		background:#188ae2;
		color:#fff;
	}
	.modal-header .close {
		opacity: 1;
		color: #fff;
	}
</style>
<?php
$type_of_case=array(
	"1"=>"A. Confirmed COVID-19 diagnosis",
	"2"=>"B. Proximate exposure to someone diagnosis with COVID-19",
	"3"=>"C. Second hand exposure to someone diagnosis with COVID-19",
	"4"=>"D. Caller illness",
	"5"=>"E. Third party exposure"
);
?>
<div class="wrap">
	<section class="app-content">
		<div class="widget">
			<header class="widget-header">
				<h4 style="padding-left:10px"><i class="fa fa-bar-chart"></i> Health Dept Report</h4>
			</header>
			<div class="widget-body">
				<form method="GET" enctype="multipart/form-data" action="" autocomplete="off">
					<div class="caller-widget">
						<div class="row">
							<div class="col-md-4">
								<div class="form-group">
									<label for="startdate">Start Date</label>
									<input type="text" class="form-control newDatePick" id="start_date" value="<?php echo $start_date; ?>" name="start_date" required>
								</div>
							</div>

							<div class="col-md-4">
								<div class="form-group">
									<label for="enddate">End date</label>
									<input type="text" class="form-control newDatePick" id="end_date" value="<?php echo $end_date; ?>" name="end_date" required>
								</div>
							</div>

							<div class="col-md-4">
								<div class="form-group">
									<label for="type">Select Location</label>
									<select class="form-control" name="main_location">
										<option value="">ALL</option>
										<?php
										foreach ($caseLocation as $keyt) {
											$selected = "";
											if ($keyt['callers_work_location'] == $main_location) {
												$selected = "selected";
											}
											if ($keyt['callers_work_location'] != "") {
										?>
												<option value="<?php echo $keyt['callers_work_location']; ?>" <?php echo $selected; ?>><?php echo $keyt['callers_work_location']; ?></option>
										<?php }
										} ?>
									</select>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-4">
								<div class="form-group">
									<label for="type">Select Agent</label>
									<select class="form-control" name="main_agent">
										<option value="">ALL</option>
										<?php
										foreach ($caseAgents as $keyt) {
											$selected = "";
											if ($keyt['agent_id'] == $main_agent) {
												$selected = "selected";
											}
											if ($keyt['agent_id'] != "") {
										?>
												<option value="<?php echo $keyt['agent_id']; ?>" <?php echo $selected; ?>><?php echo $keyt['fullname']; ?></option>
										<?php }
										} ?>
									</select>
								</div>
							</div>

							<div class="col-md-4">
								<div class="form-group">
									<label for="type">Select Type</label>
									<select class="form-control" name="main_type">
										<option value="">ALL</option>
										<?php
										foreach ($caseTypes as $key => $val) {
											$selected = "";
											if ($key == $main_type) {
												$selected = "selected";
											}
										?>
											<option value="<?php echo $key; ?>" <?php echo $selected; ?>><?php echo $val; ?></option>
										<?php } ?>
									</select>
								</div>
							</div>

							<div class="col-md-4">
								<div class="form-group">
									<label for="type">Case Status</label>
									<select class="form-control" name="case_status">
										<option value="" <?= (isset($_GET['case_status']) && $_GET['case_status']=="")?"selected":""?>>ALL</option>
										<option value="Y" <?= (isset($_GET['case_status']) && $_GET['case_status']=="Y")?"selected":""?>>Open</option>
										<option value="N" <?= (isset($_GET['case_status']) && $_GET['case_status']=="N")?"selected":""?>>Closed</option>
									</select>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-4">
								<div class="form-group">
									<input type="hidden" name="download_report" id="download_report" value="1">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-4">
								<div class="form-group">
									<button name="reportSubmission" type="submit" style="margin-top:20px" class="submit-btn" >Download Report</button>
								</div>
							</div>
						</div>
					</div>

				</form>
			</div>
		</div>

	</section>
</div>


