<script src="<?php echo base_url() ?>assets/css/search-filter/js/selectize.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>assets/css/search-filter/js/bootstrap-multiselect.js"></script>
<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/search-filter/css/selectize.bootstrap3.min.css" />
<style>
	td {
		font-size: 11px;
	}

	#default-datatable th {
		font-size: 11px;
	}

	#default-datatable th {
		font-size: 11px;
	}

	.table>thead>tr>th,
	.table>thead>tr>td,
	.table>tbody>tr>th,
	.table>tbody>tr>td,
	.table>tfoot>tr>th,
	.table>tfoot>tr>td {
		padding: 3px;
	}

	.modal .close {
		color: #fff;
		text-shadow: none;
		opacity: 1;
		position: absolute;
		top: -15px;
		right: -14px;
		width: 35px;
		height: 35px;
		background: #0c6bb5;
		border-radius: 50%;
		transition: all 0.5s ease-in-out 0s;
	}

	.modal textarea {
		width: 100%;
		max-width: 100%;
		min-height: 40px;
	}

	.modal-footer .btn {
		width: 100px;
		padding: 10px;
		font-size: 13px;
		letter-spacing: 0.5px;
		transition: all 0.5s ease-in-out 0s;
		border: none;
		border-radius: 5px;
	}
</style>
<?php 

// echo '<pre>';
// print_r($_SESSION); 
// echo '</pre>';
?>
<div class="wrap">
	<section class="app-content">
		<div class="row">

			<!-- DataTable -->
			<div class="col-md-12">
				<div class="widget">
					<header class="widget-header">
						<h4 class="widget-title">Selected Candidate List</h4>
					</header><!-- .widget-header -->
					<hr class="widget-separator">

					<div class="widget-body">

						<?php echo form_open('', array('method' => 'get','id' => 'dynamic_search_form')) ?>

						<input type="hidden" id="req_status" name="req_status" value=''>

						<div class="filter-widget">
							<div class="row">
								<div class="col-sm-3">
									<div class="form-group">
										<label>Start Date</label>
										<input type="text" class="form-control" id="from_date" name="from_date" value="<?=date('Y-m-01')?>" autocomplete="off">
									</div>
								</div>
								<div class="col-sm-3">
									<div class="form-group">
										<label>End Date</label>
										<input type="text" class="form-control" id="to_date" name="to_date" value="<?=date('Y-m-d', strtotime('last day of this month'))?>" autocomplete="off">
									</div>
								</div>
								<div class="col-sm-3">
									<div class="form-group">
										<label>Brand</label>
										<select id="select-brand" name="brand[]" class="form-control" autocomplete="off" placeholder="Select Brand" multiple>

											<?php foreach ($company_list as $key => $value) {
											?>
												<option value="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></option>
											<?php  } ?>
										</select>
									</div>
								</div>
								<div class="col-sm-3">
									<div class="form-group">
										<label>Location</label>
										<select id="fdoffice_ids" name="office_id[]" autocomplete="off" placeholder="Select Location" multiple>
											<?php foreach ($location_list as $loc) { ?>
												<option value="<?php echo $loc['abbr']; ?>"><?php echo $loc['office_name']; ?></option>
											<?php } ?>
										</select>
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-sm-3">
									<div class="form-group">
										<label>Select Department</label>
										<select id="select-department" class="form-control" name="department_id[]" autocomplete="off" placeholder="Select Department" multiple>
											<?php
											foreach ($department_list as $k => $dep) {
											?>
												<option value="<?php echo $dep['id']; ?>"><?php echo $dep['shname']; ?></option>
											<?php
											}
											?>
										</select>
									</div>
								</div>

								<div class="col-sm-3">
									<div class="form-group">
										<label>Select Client</label>
										<select id="fclient_id" name="client_id[]" autocomplete="off" placeholder="Select Client" multiple>
											<?php foreach ($client_list as $client) {
											?>
												<option value="<?php echo $client->id; ?>"><?php echo $client->shname; ?></option>
											<?php } ?>
										</select>
									</div>
								</div>
								<div class="col-sm-3">
									<div class="form-group">
										<label>Select Process</label>
										<select id="fprocess_id" name="process_id" autocomplete="off" placeholder="Select Process" class="select-box">
											<option value="">-- Select Process--</option>
											<?php foreach ($process_list as $process) {
											?>
												<option value="<?php echo $process->id; ?>"><?php echo $process->name; ?></option>
											<?php } ?>
										</select>
									</div>
								</div>
								<div class="col-sm-3" id="requisation_div" style="display:none;">
									<div class="form-group">
										<label>Requisition</label>
										<select autocomplete="off" name="requisition_id[]" id="edurequisition_id" placeholder="Select Requisition" class="select-box">
											<option="">ALL</option>												
										</select>
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-sm-12">
									<div class="form-group">
										<button type="submit" name="search" id="search" value="Search" class="submit-btn">
											<i class="fa fa-search" aria-hidden="true"></i>
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
					<div class="widget">
						<input type="hidden" name="search_click" id="search_click" value="0">
                        <input type="hidden" name="button_search_value" id="button_search_value" value="0">
                        <input type="hidden" name="data_url" id="data_url" value="<?php echo base_url('dfr_new/getSelectedCandidateAjaxResponse'); ?>">
                            <div class="tbl-container1">
                                <div id="bg_table" class="table-responsive1 new-table tbl-fixed1">
                                    <table id="dynamic-datatable" data-plugin="DataTable" class="table table-striped skt-table" cellspacing="0" width="100%">
								<thead>
									<tr class='bg-info'>
										<th>SL</th>
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
										<?php //if (is_access_dfr_module() == 1) { 	////ACCESS PART 
										?>
											<th>Action</th>
										<?php //} ?>
									</tr>
								</thead>
								<tbody>
							</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

	</section>

</div><!-- .wrap -->
<!---------------------------------Letter of Intent---------------------------------->

<div class="modal fade" id="letter_of_intent" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<!--<div class="modal-dialog" style="width:1000px;">
		<div class="modal-content">

			<form class="frmLetterOfIntent" action="<?php echo base_url(); ?>dfr/loi_send" onsubmit="return finalselection()" method='POST'>

				<div class="modal-header bg-primary">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel">Letter of Intent</h4>
				</div>
				<div class="modal-body">
					<input type="hidden" id="r_id" name="r_id">
					<input type="hidden" id="c_id" name="c_id">	

					<div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Onboarding Type <i class="fa fa-asterisk" style="font-size:6px; color:red"></i></label>
                                <select id="onboarding_typ" name="onboarding_typ" class="form-control">
                                    <option value="">-- Select type --</option>
                                    <option value="Regular">Regular</option>
                                    <option value="NAPS">NAPS</option>
                                    <option value="Stipend">Stipend</option>
                                </select>
                            </div>
                        </div>
                    </div>

					<div class="row">
						<div class="col-md-4">
							<div class="form-group">
								<label>First Name</label>								
								<input type="text" name="fname" id="fname" class="form-control" value="" readonly>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label>Last Name</label>								
								<input type="text" name="lname" id="lname" class="form-control" value="" readonly>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label>Email</label>								
								<input type="text" name="email" id="email" class="form-control" value="" readonly>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-md-4">
							<div class="form-group">
								<label>Training Start Date</label>
								<input type="text" name="training_start_date" id="training_start_date" class="form-control" readonly>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label>Stipend Amount</label>
									<input type="text" name="stipend_amount" id="stipend_amount" class="form-control number-only-no-minus-also">
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label>CTC Amount</label>
									<input type="text" name="ctc_amount" id="ctc_amount" class="form-control number-only-no-minus-also">
								</div>
							</div>
						</div>

					</div>


					<div class="modal-footer">

						<span style="float: left;">
                            <label>Candidate History: </label>
                            <span id="user_history">
                            
                            </span>
                        </span>

						<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
						<input type="submit" name="submit" id='send_loi_button' class="btn btn-primary" value="Save & Send">
					</div>

			</form>

		</div>
	</div>-->
</div>

<!---------------------------------Select candidate as employee---------------------------------->

<div class="modal fade" id="finalSelectionModel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<!--<div class="modal-dialog" style="width:1000px;">
		<div class="modal-content">

			<form class="frmfinalSelection" action="<?php echo base_url(); ?>dfr/candidate_select_employee" onsubmit="return finalselection()" method='POST'>

				<div class="modal-header bg-primary">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel">Add Candidate as Employee</h4>
				</div>
				<div class="modal-body">

					<input type="hidden" id="r_id" name="r_id">
					<input type="hidden" id="c_id" name="c_id">
					<input type="hidden" id="hiring_source" name="hiring_source">
					<input type="hidden" id="address" name="address">
					<input type="hidden" id="country" name="country">
					<input type="hidden" id="state" name="state">
					<input type="hidden" id="city" name="city">
					<input type="hidden" id="postcode" name="postcode">

					<div class="row">
						<div class="col-md-4">
							<div class="form-group">
								<label>Location</label>
								<input type="text" readonly class="form-control" id="location" name="office_id">
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label>Department</label>
								<select class="form-control" id="department_id" name="dept_id" required>
									<option>--select--</option>
									<?php foreach ($get_department_data as $dept) : ?>
										<option value="<?php echo $dept['id']; ?>"><?php echo $dept['shname']; ?></option>
									<?php endforeach; ?>
								</select>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label>Sub Department</label>
								<select class="form-control" id="sub_dept_id" name="sub_dept_id">
									<option value="">--select--</option>
									<?php foreach ($sub_department_list as $sub_dept) : ?>
										<option value="<?php echo $sub_dept['id']; ?>"><?php echo $sub_dept['name']; ?></option>
									<?php endforeach; ?>
								</select>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-4">
							<div class="form-group">
								<label>Emp ID/XPO ID</label>
								<input type="text" id="xpoid" name="xpoid" class="form-control" autocomplete="off">
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">

								<?php

								if (isIndiaLocation(get_user_office_id()) == true) {
									echo "<label>Joining Date (dd/mm/yyyy)</label>";
								} else {
									echo "<label>Joining Date (mm/dd/yyyy)</label>";
								}

								?>

								<input type="text" id="d_o_j" name="doj" class="form-control" required>
							</div>
						</div>
						<div class="col-md-4">

							<div class="form-group">
								<?php

								if (isIndiaLocation(get_user_office_id()) == true) {
									echo "<label>Date of Birth (dd/mm/yyyy)</label>";
								} else {
									echo "<label>Date of Birth (mm/dd/yyyy)</label>";
								}

								?>

								<input type="text" id="d_o_b" name="dob" class="form-control" required>
							</div>

						</div>
					</div>
					<div class="row">
						<div class="col-md-4">
							<div class="form-group">
								<label>First Name</label>
								<input type="text" id="fname" name="fname" class="form-control" required>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label>Last Name</label>
								<input type="text" id="lname" name="lname" class="form-control">
							</div>
						</div>
						<div class="col-md-2">
							<div class="form-group">
								<label>Gender</label>
								<select id="gender" name="sex" class="form-control" required>
									<option value="">--Select--</option>
									<option value="Male">Male</option>
									<option value="Female">Female</option>
									<option value="Transgender">Transgender</option>
								</select>
							</div>
						</div>
						<div class="col-md-2">
							<div class="form-group">
								<label>Class/Batch Code</label>
								<input type="text" id="batch_code" name="batch_code" class="form-control">
							</div>

						</div>
					</div>
					<div class="row">
						<div class="col-md-2">
							<div class="form-group">
								<label>Father's/Husband's Name</label>
								<?php

								if (isIndiaLocation(get_user_office_id()) == true) {
									echo "<input type='text' class='form-control' minlength='3' id='father_husband_name' name='father_husband_name' required>";
								} else if (get_user_office_id() == 'ELS') {
									echo "<input type='text' class='form-control' id='father_husband_name' name='father_husband_name'>";
								} else {
									echo "<input type='text' class='form-control' id='father_husband_name' name='father_husband_name'>";
								}
								?>
							</div>
						</div>




						<div class="col-md-2">
							<div class="form-group">
								<label>Relation</label>
								<?php
								if (isIndiaLocation(get_user_office_id()) == true) {
									echo "<select id='relation' name='relation' class='form-control' required>";
								} else if (get_user_office_id() == 'ELS') {
									echo "<select id='relation' name='relation' class='form-control'>";
								} else {
									echo "<select id='relation' name='relation' class='form-control' >";
								}
								?>
								<option value="">--Select--</option>
								<option value="Father">Father</option>
								<option value="Husband">Husband</option>
								<option value="Mother">Mother</option>
								<option value="Wife">Wife</option>
								</select>
							</div>
						</div>

						<div class="col-md-2" id="mother_name_div" style="display:none;">
							<div class="form-group">
								<label>Mother name:</label>
								<input type="text" id="mother_name" name="mother_name" class="form-control character-only" value="" placeholder="Enter your mother name">
								<span id="mother_name_status" style="color:red;font-size:10px;"></span>
							</div>
						</div>




						<div class="col-md-2">
							<div class="form-group">
								<label>Marital Status</label>
								<?php
								if (get_user_office_id() == 'ELS') {
									echo "<select id='marital_status' name='marital_status' class='form-control'>";
								} else {
									echo "<select id='marital_status' name='marital_status' class='form-control' required>";
								}
								?>
								<option value="">--Select--</option>
								<option value="Married">Married</option>
								<option value="UnMarried">Un-Married</option>
								<option value="Widow">Widow</option>
								<option value="Widower">Widower</option>
								<option value="Divorcee">Divorcee</option>
								</select>
							</div>
						</div>
						<div class="col-md-2">
							<div class="form-group">
								<label>Nationality</label>
								<select id="nationality" name="nationality" class="form-control" required>
									<option value="">--Select--</option>
									<?php foreach ($get_countries as $country) : ?>
										<option value="<?php echo $country['name']; ?>"><?php echo $country['name']; ?></option>
									<?php endforeach; ?>
								</select>
							</div>
						</div>
						<div class="col-md-2" id="caste_main">
							<div class="form-group">
								<label for="caste">Caste : </label>
								<select class="form-control" id="caste" name="caste">
									<option value="">--select--</option>
									<option value="General">General</option>
									<option value="SC">SC</option>
									<option value="ST">ST</option>
									<option value="OBC">OBC</option>
								</select>

							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-4">
							<div class="form-group">
								<label>Select a Designation</label>
								<select id="role_id" name="role_id" class="form-control" required>
									<option>--Select--</option>
									<?php foreach ($role_list as $role) : ?>
										<option value="<?php echo $role->id ?>" param="<?php echo $role->org_role;  ?>"><?php echo $role->name ?></option>
									<?php endforeach; ?>
								</select>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label>Select Role Organization</label>
								<select id="org_role_id" name="org_role_id" class="form-control">
									<option>--Select--</option>
									<?php foreach ($organization_role as $org_role) : ?>
										<option value="<?php echo $org_role->id ?>"><?php echo $org_role->name ?></option>
									<?php endforeach; ?>
								</select>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label>Assign Level-1 Supervisor</label>
								<select id="assigned_to" name="assigned_to" class="form-control" required>
									<option value="">--Select--</option>
									<?php foreach ($tl_list as $tl) : ?>
										<option value="<?php echo $tl->id ?>"><?php echo $tl->tl_name ?></option>
									<?php endforeach; ?>
								</select>
							</div>
						</div>
					</div>


					<div class="row" id="check_payroll">
						<div class="col-md-4">
							<div class="form-group">
								<label for="client">Select Payroll Type</label>
								<select class="form-control" name="payroll_type" id="payroll_type">
									<option value=''>-- Select Payroll Type --</option>
									<?php foreach ($payroll_type_list as $payroll_type) : ?>
										<option value="<?php echo $payroll_type['id'] ?>"><?php echo $payroll_type['name'] ?></option>
									<?php endforeach; ?>
								</select>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label for="client">Select Payroll Status</label>
								<select class="form-control" name="payroll_status" id="payroll_status">
									<option value=''>-- Select Payroll Status --</option>
									<?php foreach ($payroll_status_list as $payroll_status) : ?>
										<option value="<?php echo $payroll_status['id'] ?>"><?php echo $payroll_status['name'] ?></option>
									<?php endforeach; ?>
								</select>
							</div>
						</div>
						<div class="col-md-2">
							<div class="form-group">
								<label for="grosspay">Gross Pay</label>
								<input type="text" class="form-control" id="grosspay" placeholder="Gross Pay" name="grosspay" readonly>
							</div>
						</div>
						<div class="col-md-2">
							<div class="form-group">
								<label for="currency">Currency</label>
								<input type="text" class="form-control" id="currency" placeholder="Currency" name="currency" readonly>
							</div>
						</div>

					</div>

					<div class="row" id="stop_payroll" style="display:none;">
						<input name="payroll_type" value="0" type="hidden">
						<input name="payroll_status" value="0" type="hidden">
						<input name="currency" value="" type="hidden">
						<input name="grosspay" value="0" type="hidden">
					</div>



					<div class="row">
						<div class="col-md-6">
							<div class="form-group" id="client_div">
								<label for="client_id">Select Client(s)</label>
								<select class="form-control" style="width:100%; height:100px" name="client_id[]" id="client_id" multiple="multiple">
									<?php foreach ($client_list as $client) : ?>
										<option value="<?php echo $client->id ?>"><?php echo $client->shname ?></option>
									<?php endforeach; ?>
								</select>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group" id="process_div">
								<label for="process_id">Select Process(s)</label>
								<select class="form-control" style="width:100%; height:100px" name="process_id[]" id="process_id" multiple="multiple">
									<?php foreach ($process_list as $process) : ?>
										<option value="<?php echo $process->id ?>"><?php echo $process->name ?></option>
									<?php endforeach; ?>
								</select>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-3">
							<div class="form-group">
								<label for="name">Email ID (Personal)</label>
								<input type="email" pattern="[A-z0-9._%+-]+@[A-z0-9.-]+\.[A-z]{2,}$" data-error="Invalid email address" class="form-control email" id="email" placeholder="Email ID Personal" name="email_id_per" required>
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								<label for="name">Email ID (Office)</label>
								<input type="email" data-error="Invalid email address" class="form-control" id="email_id_off" placeholder="Email ID Office" name="email_id_off" pattern="[A-z0-9._%+-]+@[A-z0-9.-]+\.[A-z]{2,}$">
							</div>
						</div>

						<?php
						// GET PHONE PATTERNS

						$phone_patern = "9,10";

						if ((get_user_office_id() == 'CEB') && (get_user_office_id() == 'MAN')) {
							$phone_patern = "9,10"; // for 10 11 digits
						}
						if (get_user_office_id() == 'ALB') {
							$phone_patern = "8";  // for 8 digits
						}
						if (get_user_office_id() == 'UKL') {
							$phone_patern = "9,10";  // for 10 11 digits
						}

						?>


						<div class="col-md-3">
							<div class="form-group">
								<label for="phone">Phone No</label>
								<input type="text" pattern="[0-9]{1}[0-9]{<?php echo $phone_patern; ?>}" class="form-control" id="phone" placeholder="Phone No" name="phone" required>
							</div>
						</div>

						<div class="col-md-3">
							<div class="form-group">
								<label for="phone_emar">Phone No (Emergency)</label>
								<input type="text" pattern="[0-9]{1}[0-9]{<?php echo $phone_patern; ?>}" class="form-control" id="phone_emar" placeholder="Phone No" name="phone_emar">
							</div>
						</div>
					</div>

					<div class="row">
						<?php if ((get_user_office_id() != 'ALB') && (get_user_office_id() != 'UKL')) { ?>
							<div class="col-md-3">
								<div class="form-group">
									<?php
									if (isIndiaLocation(get_user_office_id()) == true) $reqCss = "required";
									else $reqCss = "";

									if (get_user_office_id() == 'ELS') {
										echo "<label for='pan_no'>DUI</label>";
									} else if (get_user_office_id() == 'JAM') {
										echo "<label >TRN No.</label>";
									} else {
										echo "<label for='pan_no'>TAX/PAN Number</label>";
									}
									?>
									<input type="text" class="form-control" id="pan_no" name="pan_no" <?php echo $reqCss; ?>>
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<?php
									if (get_user_office_id() == 'ELS') {
										echo "<label for='uan_no'>NIT</label>";
										// }else if(get_user_office_id() == 'JAM'){
									} else if (get_user_office_id() == 'JAM') {
										echo "<label for='uan_no'>NIT</label>";
									} else {
										echo "<label for='uan_no'>UAN(EPF) Number</label>";
									}
									?>
									<input type="text" class="form-control" id="uan_no" name="uan_no">
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<?php
									if (get_user_office_id() == 'ELS') {
										echo "<label>ISSS</label>";
									} else if (get_user_office_id() == 'JAM') {
										// }else if(get_user_office_id() == 'JAM'){
										echo "<label>NIS</label>";
									} else {
										echo "<label>Existing ESI No</label>";
									}
									?>
									<input type="text" class="form-control" id="esi_no" name="esi_no">
								</div>
							</div>
						<?php } ?>


						<div class="col-md-3">
							<div class="form-group">
								<?php
								if (get_user_office_id() == 'ELS') {
									echo "<label  style='font-size:12px'>AFP</label>";
									$required = '';
									$length = '';
								} else if (get_user_office_id() == 'JAM') {
									echo "<label  style='font-size:12px'>National ID</label>";
									$required = '';
									$length = '';
								} else if (isIndiaLocation(get_user_office_id()) == true) {
									echo "<label  style='font-size:12px'>Social Security No / Aadhaar No</label>";
									$required = 'required';
									$length = 'minlength="12"';
								} else if (get_user_office_id() == 'UKL') {
									echo "<label  style='font-size:12px'>National Insurance Number</label>";
									$required = 'required';
									$length = '';
								} else {
									echo "<label  style='font-size:12px'>Social Security No / Aadhaar No</label>";
									$required = 'required';
									$length = '';
								}

								?>
								<input type="text" class="form-control" id="social_security_no" name="social_security_no" <?php echo $required . " " . $length ?>>
							</div>
						</div>
					</div>
					
					<?php if (isIndiaLocation(get_user_office_id()) == true) {

					?>

						<div class="row">
							<div class="col-md-4">
								<div class="form-group">
									<label for="bank_name">Bank Name</label>

									<input type="text" class="form-control email" id="bank_name" placeholder="Bank Name" name="bank_name">
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label for="branch_name">Branch</label>
									<input type="text" class="form-control" id="branch_name" placeholder="Branch Name" name="branch_name">
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label for="acc_type">Account Type</label>
									
									<select class="form-control" id="acc_type" name="acc_type">
										<option value="Savings">Savings</option>
										<option value="Checking">Checking</option>
									</select>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="bank_acc_no">Account Number</label>
									<input type="text" class="form-control" id="bank_acc_no" placeholder="Account No" name="bank_acc_no">
								</div>
							</div>

							<div class="col-md-6">
								<div class="form-group">
									<label for="ifsc_code">IFSC Code</label>
									<input type="text" class="form-control" id="ifsc_code" placeholder="IFSC CODE" name="ifsc_code" pattern="^[A-Z]{4}[0][A-Z0-9]{6}$">
								</div>
							</div>

						</div>
					<?php } ?>
				</div>


				<div class="modal-footer">
					<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
					<input type="submit" name="submit" id='candidateFinalSelection' class="btn btn-primary" value="Save">
				</div>

			</form>

		</div>
	</div>-->
</div>


<!---------------Candidate Transfer-------------------->
<div class="modal fade" id="transferSelectedCandidateModel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<!--<div class="modal-dialog">
		<div class="modal-content">

			<form class="frmTransferSelectedCandidate" action="<?php echo base_url(); ?>dfr/CandidateTransfer" data-toggle="validator" method='POST'>

				<div class="modal-header bg-primary">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
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
								<input type="text" name="search_req" id="search_req" class="form-control" placeholder="Type Requisition Number">
								<div id="searchList"></div>
							</div>
						</div>
					</div>
					<div class="row" style="margin-left:8px" id="req_details">

					</div>

					</br></br>

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
					<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
					<input type="submit" name="submit" class="btn btn-primary" value="Save">
				</div>

			</form>

		</div>
	</div>-->
</div>



<!--------------- DROP CANDIDATE -------------------->
<div class="modal fade" id="dropCandidateModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<!--<div class="modal-dialog">
		<div class="modal-content">

			<form class="frmdropCandidate" action="<?php echo base_url(); ?>dfr/CandidateDrop" data-toggle="validator" method='POST'>

				<div class="modal-header bg-primary">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel">Drop Candidate</h4>
				</div>
				<div class="modal-body">
					<input type="hidden" id="r_id" name="r_id" class="form-control" required>
					<input type="hidden" id="c_id" name="c_id" class="form-control" required>

					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label>Are you sure you want to drop this candidate ?</label>
								<select class="form-control" id="is_drop" name="is_drop" required>
									<option value="">-Select-</option>
									<option value="Y">Yes</option>
								</select>
							</div>
						</div>
					</div>

				</div>

				<div class="modal-footer">
					<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
					<input type="submit" name="submit" class="btn btn-primary" value="Save">
				</div>

			</form>

		</div>
	</div>-->
</div>

<!--------------------Update BGV--------------------------------->
<div class="modal fade" id="updateCandidateBGVModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<!--<div class="modal-dialog">
		<div class="modal-content">

			<form class="frmBGVCandidate" action="<?php echo base_url(); ?>dfr/updateBGV" data-toggle="validator" method='POST' enctype="mulipart/form-data">

				<div class="modal-header bg-primary">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel">Update Candidate BGV</h4>
				</div>
				<div class="modal-body">
					<input type="hidden" id="r_id" name="r_id" class="form-control" required>
					<input type="hidden" id="c_id" name="c_id" class="form-control" required>

					<div class="row" id="bgvdat">
						<div class="col-md-6">
							<div class="form-group">
								<label>Is BGV?</label>
								<select class="form-control" id="is_bgv_verify" name="is_bgv_verify">
									<option value="">-Select-</option>
									<option value="1">Yes</option>
									<option value="2">No</option>
								</select>
							</div>
						</div>						
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
					<input type="submit" name="submit" class="btn btn-primary frmSaveButton" value="Save">
				</div>
			</form>
		</div>
	</div>-->
</div>

<!--------------- Verify  CANDIDATE Documents-------------------->
<div class="modal fade" id="VerifyDocumentsModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">

			<form class="frmVerifyDocuments" action="<?php echo base_url(); ?>dfr/verifyDocuments" data-toggle="validator" method='POST'>

				<div class="modal-header bg-primary">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel">Verify Document</h4>
				</div>
				<div class="modal-body">

					<div class="row">
						<div id='VerifyDocumentsContent' class="col-md-12">



						</div>
					</div>
					<div id="certify_documents_div" class="row">
						<div class="col-md-12" style="color:darkgreen;font-weight:bold;">
							<input type="hidden" id="r_id" name="r_id" class="form-control" required>
							<input type="hidden" id="c_id" name="c_id" class="form-control" required>

							<input type="checkbox" id="is_verify_doc" name="is_verify_doc" value='1' required>
							I certify that the documents uploaded by candidate are valid and verified by me. .
						</div>

					</div>


				</div>

				<div class="modal-footer">
					<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
					<input id="verify_submit_btn" type="submit" name="submit" class="btn btn-primary" value="Save">
				</div>

			</form>

		</div>
	</div>
</div>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap4.min.js"></script>
<script src="<?php echo base_url() ?>assets/css/search-filter/js/selectize.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>assets/css/search-filter/js/bootstrap-multiselect.js"></script>

<script type="text/javascript">
     /*var dataTable = $('#default-datatable').DataTable({
            "pageLength": '20',
            "lengthMenu": [
                [20, 50, 100, 150, 200, -1],
                [20, 50, 100, 150, 200, 'All'],
            ],
            "columnDefs": [
            { "searchable": false, "targets": [0,-1] },  // Disable search on first and last
            { "orderable": false, "targets": [0,-1] }    // Disable orderby on first and last         
            ],
            // 'scrollY': '60vh',
            'scrollCollapse': false,
            'processing': true,
            'serverSide': true,
            'serverMethod': 'post',
            'searching': false, // Remove default Search Control
            'ajax': {
                complete: function (data) {
                   
                },
                'url': '<?php echo base_url('dfr_new/getSelectedCandidateAjaxResponse'); ?>',
                'data': function (data) {
                    // Read values
                    var from_date = $('#from_date').val();
                    var to_date = $('#to_date').val();
                    var select_brand = $('#select-brand').val();
                    var office_id = $('#fdoffice_ids').val();
                    var select_department = $('#select-department').val();
                    var fclient_id = $('#fclient_id').val();
                    var fprocess_id = $('#fprocess_id').val();
                    var search_click = $('#search_click').val();
                    var req_status = $('#button_search_value').val();
                    // Append to data
                    data.from_date = from_date;
                    data.to_date = to_date;
                    data.brand = select_brand;
                    data.office_id = office_id;
                    data.department_id = select_department;
                    data.client_id = fclient_id;
                    data.process_id = fprocess_id;
                    data.searchClick = search_click;
                    data.req_status = req_status;
                }
            },
            'columns': [
                {data: 'sl'},
                {data: 'requisition_id'},
                {data: 'last_qualification'},
                {data: 'onboarding_type'},
                {data: 'fname'},
                {data: 'gender'},
                {data: 'phone'},
                {data: 'skill_set'},
                {data: 'total_work_exp'},
                {data: 'attachment'},
                {data: 'candidate_status'},
                {data: 'action'}
            ]

        });

        $('#search').click(function (e) {
            e.preventDefault();
            $('#search_click').val(1);
            dataTable.draw();
        });*/
</script>
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
			enableCaseInsensitiveFiltering: true,
			filterPlaceholder: 'Search for something...'
		});
	});
</script>
<script>
	$(function() {
		$('#mother_name').keydown(function(e) {
			$("#mother_name_status").html("");
			if (e.shiftKey && (e.which == 48 || e.which == 49 || e.which == 50 || e.which == 51 || e.which == 52 || e.which == 53 || e.which == 54 || e.which == 55 || e.which == 56 || e.which == 57)) {
				e.preventDefault();
			} else {
				var key = e.keyCode;
				if (!((key == 8) || (key == 32) || (key == 46) || (key >= 35 && key <= 40) || (key >= 65 && key <= 90))) {
					$("#mother_name_status").html("only Alphabate and space allowed");

					e.preventDefault();
				}
			}
		});
	});

	$(function() {
		$('#multiselect').multiselect();

		$('#select-brand').multiselect({
			includeSelectAllOption: true,
			enableFiltering: true,
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
		$("#training_start_date").datepicker();		
	});
	
</script>