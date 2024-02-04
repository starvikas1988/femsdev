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
			<h4 style="padding-left:10px"><i class="fa fa-bar-chart"></i>Health Dept. -  Individual Report </h4>
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
										/*foreach ($caseLocation as $keyt) {
											$selected = "";
											if ($keyt['callers_work_location'] == $main_location) {
												$selected = "selected";
											}
											if ($keyt['callers_work_location'] != "") {
										?>
												<option value="<?php echo $keyt['callers_work_location']; ?>" <?php echo $selected; ?>><?php echo $keyt['callers_work_location']; ?></option>
										<?php }*/
										foreach ($school_list as $kt=> $keyt) {
											$selected = "";
											if ($keyt['id'] == $main_location) {
												$selected = "selected";
											}
											if ($keyt['id'] != "") {
										?>
												<option value="<?php echo $keyt['id']; ?>" <?php echo $selected; ?>><?php echo $keyt['name']; ?></option>
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
											if($key==1||$key==2||$key==3){
											$selected = "";
											if ($key == $main_type) {
												$selected = "selected";
											}
										?>
											<option value="<?php echo $key; ?>" <?php echo $selected; ?>><?php echo $val; ?></option>
										<?php }} ?>
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
									<button name="reportSubmission" type="submit" style="margin-top:20px" class="submit-btn">Filter</button>
								</div>
							</div>
						</div>
					</div>

				</form>
			</div>
		</div>

		<div class="common-top">
			<div class="row">
				<div class="col-md-12">
					<div class="widget">
						<header class="widget-header">
							<h4 class="widget-title">Howard Case List</h4>
						</header>
						<hr class="widget-separator">

						<div class="widget-body">
							<div class="table-responsive">
								<table style="margin-top: 10px;" id="default-datatable" data-plugin="DataTable" class="table table-striped skt-table" cellspacing="0" width="100%">

									<thead>
										<tr class='bg-info'>
											<th>SL</th>
											<th>Case ID</th>
											<th>Student Name</th>
											<th>Case Type</th>
											<th>Case Location</th>
											<th>Location Adress</th>
											<th>Case Status</th>
											<th>Opened By</th>
											<th>Date Added</th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody>
										<?php
										$cn = 1;
										foreach ($case_list as $token) {
										?>
											<tr>
												<td><?php echo $cn++; ?></td>
												<td><?php echo $token['incident_id']; ?></td>
												<td><?php echo $token['caller_fname'] . " " . $token['caller_lname']; ?></td>
												<td><?php
													echo !empty($caseTypes[$token['initial_case']]) ? $caseTypes[$token['initial_case']] : "-";
													?>
												</td>
												<td><?php
													echo $token['school_name'];
													?>
												</td>
												<td><a href="#" style="text-decoration:none" title="<?php echo $token['callers_work_location']; ?>"><?php echo substr($token['callers_work_location'], 0, 30); ?>..</a></td>
												<td>
													<?php
													if (isset($token['case_status'])) {
														if ($token['case_status'] == '0') {
															echo "<span class='text-success'><b>Closed</b></span>";
														}
														if ($token['case_status'] == '1') {
															echo "<span class='text-danger'><b>Open</b></span>";
														}
													} else {
														echo "<span class='text-warning'><b>Open</b></span>";
													}
													?></td>
												<td><?php echo $token['added_by_name']; //ucwords($token['case_source']); 
													?></td>
												<td><?php echo date('d M, Y', strtotime($token['date_of_call'])); ?></td>
												<td>
													<a title='Download Case' target="_blank" href="<?= base_url()?>howard_training/download_single_excel_report/<?= $token['incident_id']?>" class='btn btn-primary btn-xs' style='font-size:12px'>Download</a>&nbsp;&nbsp;
													<!--<a onclick="sendMail();" class="btn btn-info btn-xs "><i class="fa fa-envelope" aria-hidden="true"></i></a>-->
												</td>
											</tr>
										<?php } ?>
									</tbody>
									<tfoot>
										<tr class='bg-info'>
											<th>SL</th>
											<th>Case ID</th>
											<th>Student Name</th>
											<th>Case Type</th>
											<th>Case Location</th>
											<th>Location Adress</th>
											<th>Case Status</th>
											<th>Opened By</th>
											<th>Date Added</th>
											<th>Action</th>
										</tr>
									</tfoot>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

	</section>
</div>


<div id="myEmailSendModal" class="largeModal modal fade" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">

			<!--<form action="<?php echo base_url(); ?>contact_tracing_crm/send_email" method="POST" autocomplete="off">-->

			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Send Case Details - HOWARD</h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<strong for="case">CRM ID</strong>
							<input type="text" class="form-control" id="form_crm_id" placeholder="" value="<?php echo $crmid; ?>" name="form_crm_id" required readonly>
							<input type="hidden" class="form-control" id="form_send_type" placeholder="" value="1" name="form_send_type" required readonly>
						</div>
					</div>

					<div class="col-md-6">
						<div class="form-group">
							<strong for="case">Case Name</strong>
							<input type="text" class="form-control" id="form_case_name" placeholder="" value="<?php echo $form_case_name; ?>" name="form_case_name" required readonly>
						</div>
					</div>

					<div class="col-md-6">
						<div class="form-group">
							<strong for="case">E-Mail ID</strong>
							<input type="text" class="form-control" id="form_email_id" placeholder="" value="" name="form_email_id" required>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-success sendMailSubmission" onclick="return confirm('Are you sure you want send this case details to mail?');" name="crmFormSubmission">Send</button>
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>

			<!--</form> -->
		</div>

	</div>
</div>
<div id="EmailSendModal" class="largeModal modal fade" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">

			<!--<form action="<?php echo base_url(); ?>contact_tracing_crm/send_email" method="POST" autocomplete="off">-->

			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Send Case Details - HOWARD</h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-md-12">
						<div class="form-group">
							<strong for="case">E-Mail ID</strong>
							<input type="text" class="form-control" id="form_email_id" placeholder="" value="" name="form_email_id" required>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-success sendMailSubmission" onclick="return confirm('Are you sure you want send this case details to mail?');" name="crmFormSubmission">Send</button>
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>

			<!--</form> -->
		</div>

	</div>
</div>
<script>
  function sendMail(){
    $('#EmailSendModal').modal('show');
  }
</script>