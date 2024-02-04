<style>
	input[type="text"] {
		border: 1px solid var(--bs-form-control)!important;
		height: auto!important;
		width: 100%!important;
		padding: 5px;
	}
	input[type="email"] {
		border: 1px solid var(--bs-form-control)!important;
		height: auto!important;
		width: 100%!important;
		padding: 5px;
	}
	.input_br {
		border: 1px solid var(--bs-form-control)!important;
		height: auto!important;
		width: 100%!important;
		padding: 5px;
	}
	input[type="radio"] {
		width: 18px;
		height: 18px!important;
		vertical-align: sub;
	}
</style>
<div class="wrap">
	<section class="app-content">
		<?php
		//============== PRE APPROVAL BACKGROUND VERIFICATION ==============================//
		if ($pre_approval == 0) {
		?>
			<div class="simple-page-wrap" style="width:100%;">
				<div class="simple-page-form white_widget animated flipInY">
					<h4 class="form-title m-b-xl text-center"><b><u>Applicant’s Approval For Pre-Employment Back Ground Verification</u></b></h4>
					<div style="padding:10px 10px">
						<p style="text-align: left;">I, <u>&nbsp;<?php echo get_username(); ?>&nbsp;</u>, hereby give my approval to Xplore-Tech Services Pvt. Ltd.(A Fusion BPO Services Group Company) and authorize its appointed agency to do following pre-employment verifications for me :</p>
						<form action="<?php echo base_url('bg_verification/submit_background_verification'); ?>" autocomplete="off" method='POST' autocomplete="off">
							<p style="text-align:left;margin:15px 0px 15px 0px"><strong>1. Service record background check with my previous worked companies:</strong></p>
							<div class="row">
								<div class="col-md-12 common_table_widget report_hirarchy_new table_export new_fixed_widget
">
									<table id="recordsTable" class="table table-bordered table-striped">
										<tr>
											<th rowspan="2" style="text-align: center;">
												Company Name <br /><span style="font-size:9px">(in reverse chronological order)</span></th>
											<th colspan="2" style="text-align: center;">Work Period</th>
											<th colspan="4" style="text-align: center;">Contact Person’s</th>
											<th rowspan="2"></th>
										</tr>
										<tr>
											<th>From Date</th>
											<th>To Date</th>
											<th>Name</th>
											<th>Designation</th>
											<th>Phone No</th>
											<th>Email</th>
										</tr>
										<?php $counter = 0;
										foreach ($experience_row as $token) {
											$counter++; ?>
											<tr>
												<td>
													<input type="text" style="width:100%" placeholder="" name="e_company[]" value="<?php echo $token['org_name']; ?>" required>
												</td>
												<td style="width: 150px;">
													<input type="date" class="input_br" style="width:100%" placeholder="" value="<?php echo $token['from_date']; ?>" name="e_from_date[]" required>
												</td>
												<td style="width: 150px;">
													<input type="date" class="input_br" style="width:100%" placeholder="" name="e_to_date[]" value="<?php echo $token['to_date']; ?>" required>
												</td>
												<td>
													<input type="text" style="width:100%" placeholder="" name="e_contact_name[]" value="<?php echo $token['contact_name']; ?>" required>
												</td>
												<td>
													<input type="text" style="width:100%" placeholder="" name="e_contact_designation[]" value="<?php echo $token['contact_designation']; ?>">
												</td>
												<td>
													<input type="text" style="width:100%" placeholder="" name="e_contact_phone[]" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" value="<?php echo $token['contact']; ?>" required>
												</td>
												<td>
													<input type="email" style="width:100%" placeholder="" name="e_contact_email[]" value="<?php echo $token['contact_email']; ?>">
												</td>
												<td style="width: 50px;display:block;height:47px;">
													<input type="hidden" name="e_experience_id[]" value="<?php echo $token['id']; ?>">
													<input type="hidden" name="e_user_id[]" value="<?php echo $token['user_id']; ?>">
													<?php if ($counter > 1) { ?>
														<a onclick="return confirm('Are you sure, you want to delete this record?')" href="<?php echo base_url('qa_contact_tracing/del_user_info_experience/' . $token['user_id'] . '/' . $token['id']); ?>" class="btn btn-xs"><img src="<?php echo base_url(); ?>assets_home_v3/images/delete_action.svg" alt=""></a>
													<?php } ?>
												</td>
											</tr>
										<?php } ?>
										<?php if ($counter == 0) { ?>
											<tr>
												<td>
													<input type="text" style="width:100%" placeholder="" name="e_company[]" value="" required>
												</td>
												<td style="width: 150px;">
													<input type="date" class="input_br" style="width:100%" placeholder="" value="" name="e_from_date[]" required>
												</td>
												<td style="width: 150px;">
													<input type="date" class="input_br" style="width:100%" placeholder="" name="e_to_date[]" value="" required>
												</td>
												<td>
													<input type="text" style="width:100%" placeholder="" name="e_contact_name[]" value="" required>
												</td>
												<td>
													<input type="text" style="width:100%" placeholder="" name="e_contact_designation[]" value="">
												</td>
												<td>
													<input type="text" style="width:100%" placeholder="" name="e_contact_phone[]" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" value="" required>
												</td>
												<td>
													<input type="email" style="width:100%" placeholder="" name="e_contact_email[]" value="">
												</td>
												<td style="width: 50px;display:block;height:48px;">
													<input type="hidden" name="e_experience_id[]" value="">
													<input type="hidden" name="e_user_id[]" value="<?php echo $personal_row['user_id']; ?>">
													<button type="button" onclick="$(this).closest('tr').remove();" class="btn btn-xs"><img src="<?php echo base_url(); ?>assets_home_v3/images/delete_action.svg" alt=""></button>
												</td>
											</tr>
										<?php } ?>
									</table>
									<button type="button" style="width:100px;margin:10px 0px" onclick="$('#recordsTable').append($('#sampleTableDiv').html())" class="btn btn-primary filter_btn btn-sm">Add More</button>
								</div>
							</div>
							<p style="text-align:left;margin:25px 0px 15px 0px"><strong>2. Third party background verification check which includes :</strong></p>
							<div class="row">
								<div class="col-md-6">
									I. Educational Qualification Verification
								</div>
								<div class="col-md-6">
									<div style="display:inline-block;">
										<input type="radio" value="1" name="is_educational" style="height:15px;margin-right:6px" required> Yes
									</div>
									<div style="display:inline-block;margin-left:15px">
										<input type="radio" value="0" name="is_educational" style="height:15px;margin-right:6px"> No
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-6">
									II. Residential Address Verification
								</div>
								<div class="col-md-6">
									<div style="display:inline-block;">
										<input type="radio" value="1" name="is_residential" style="height:15px;margin-right:6px" required> Yes
									</div>
									<div style="display:inline-block;margin-left:15px">
										<input type="radio" value="0" name="is_residential" style="height:15px;margin-right:6px"> No
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-6">
									III. Criminal Verification
								</div>
								<div class="col-md-6">
									<div style="display:inline-block;">
										<input type="radio" value="1" name="is_criminal" style="height:15px;margin-right:6px" required> Yes
									</div>
									<div style="display:inline-block;margin-left:15px">
										<input type="radio" value="0" name="is_criminal" style="height:15px;margin-right:6px"> No
									</div>
								</div>
							</div>
							<br /><br />
							<div class="row">
								<div class="form-group text-cener">
									<input type="checkbox" value="1" name="employee_consent" id="employee_consent" style="height:auto; margin-right:6px" required>
									<b>I understand that if my background verification report results negative my application will not be processed further.</b>
								</div>
							</div>
							<div class="row">
								<div class="col-md-3">Full Signature of Applicant with date: </div>
								<div class="col-md-9">
									<input type="text" style="width:100%;height:20px" id="employee_name" placeholder="" name="employee_name" value="<?php echo get_username(); ?>" readonly required>
								</div>
							</div>
							<br />
							<?php
							// GET ADDRESS
							$permanent_address = $personal_row['address_permanent'];
							$flag = "";
							if (!empty($permanent_address)) {
								$flag = ", ";
							}
							if (!empty($personal_row['city'])) {
								$permanent_address .= $flag . $personal_row['city'];
								$flag = ", ";
							}
							if (!empty($personal_row['state'])) {
								$permanent_address .= $flag . $personal_row['state'];
								$flag = ", ";
							}
							if (!empty($personal_row['pin'])) {
								$permanent_address .= $flag . "PIN - " . $personal_row['pin'];
								$flag = ", ";
							}
							if (!empty($personal_row['country'])) {
								$permanent_address .= $flag . $personal_row['country'];
								$flag = ", ";
							}
							?>
							<div class="row">
								<div class="col-md-3">Permanent Address of Applicant: <?php //echo "<pre>" .print_r($personal_row, 1)."</pre>"; 
																						?></div>
								<div class="col-md-9">
									<input type="text" style="width:100%;height:20px" id="employee_address" placeholder="" name="employee_address" value="<?php echo $permanent_address; ?>" readonly>
								</div>
							</div>
							<br />
							<input type="hidden" value="1" name="pre_submission_type">
							<input type="hidden" value="<?php echo $personal_row['user_id']; ?>" name="pre_user_id">
							<input type="submit" class="btn btn-success" style="width:150px;height:34px;background: var(--bs-blue);font-size:14px;" value="Submit" name="submit">
						</form>
						<?php if ($personal_row['is_bgv'] != 3) { ?>
							<form action="<?php echo base_url('bg_verification/submit_background_verification'); ?>" autocomplete="off" method='POST' autocomplete="off">
								<input type="hidden" value="1" name="pre_submission_type">
								<input type="hidden" value="<?php echo $personal_row['user_id']; ?>" name="pre_user_id">
								<input type="hidden" value="<?php echo empty($personal_row['is_bgv']) ? '2' : '3'; ?>" name="pre_user_skip">
								<div class="row">
									<div class="col-md-12" style="text-align:right">
										<input type="submit" class="btn btn_padding filter_btn" style="width:100px;height:30px" value="Skip Now" name="submit">
									</div>
									<div class="col-md-12" style="text-align:right;margin-top:10px">
										<span><b>NOTE : <?php echo $personal_row['is_bgv'] == 0 ? "2 Skips Remaining" : "1 Skip Remaining"; ?></b></span>
									</div>
								</div>
							</form>
						<?php } ?>
					</div>
					<!--- PRE TABLE ADD MORE --->
					<table id="sampleTableDiv" class="table table-bordered table-striped" style="display:none">
						<tr>
							<td>
								<input type="text" style="width:100%" placeholder="" name="e_company[]" value="" required>
							</td>
							<td style="width: 150px;">
								<input type="date" class="input_br" style="width:100%" placeholder="" value="" name="e_from_date[]" required>
							</td>
							<td style="width: 150px;">
								<input type="date" class="input_br" style="width:100%" placeholder="" name="e_to_date[]" value="" required>
							</td>
							<td>
								<input type="text" style="width:100%" placeholder="" name="e_contact_name[]" value="" required>
							</td>
							<td>
								<input type="text" style="width:100%" placeholder="" name="e_contact_designation[]" value="">
							</td>
							<td>
								<input type="text" style="width:100%" placeholder="" name="e_contact_phone[]" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" value="" required>
							</td>
							<td>
								<input type="email" style="width:100%" placeholder="" name="e_contact_email[]" value="">
							</td>
							<td style="width: 50px;display:block;height:48px;">
								<input type="hidden" name="e_experience_id[]" value="">
								<input type="hidden" name="e_user_id[]" value="<?php echo $personal_row['user_id']; ?>">
								<button type="button" onclick="$(this).closest('tr').remove();" class="btn btn-xs"><img src="<?php echo base_url(); ?>assets_home_v3/images/delete_action.svg" alt=""></button>
							</td>
						</tr>
					</table>
				</div>
			</div>
		<?php } else {
		?>
			<div class="simple-page-wrap" style="width:80%;">
				<div class="simple-page-form white_widget animated flipInY">
					<h4 class="form-title m-b-xl text-center"><b><u>Aadhaar Card Acknowledgement Verification</u></b></h4>
					<div style="padding:10px 10px">
						<p style="text-align: left;">Hi, <u>&nbsp;<?php echo get_username(); ?>&nbsp;</u>, please verify the below details as per you aadhaar card. If not, then please update the data as per you aadhaar card and acknowledge the form further.</p>
						<!--<p style="text-align: left;"><b>Adhaar Card Upload Status  :</b>
		<?php if (empty($adhaar_row['aadhar_doc'])) { ?>
		<span class="text-danger"><i class="fa fa-circle"></i> Not Uploaded</span>
		<?php } else { ?>
		<span class="text-success"><i class="fa fa-circle"></i> Uploaded</span>
		<?php } ?>
		</p>-->
						<hr />
						<form action="<?php echo base_url('bg_verification/submit_background_verification'); ?>" autocomplete="off" method='POST' autocomplete="off">
							<div class="row" style="margin-bottom:15px">
								<div class="col-md-3"><b>AADHAAR CARD NO : </b></div>
								<div class="col-md-9">
									<input type="text" style="width:100%;height:20px" id="adhaar_no" placeholder="" name="adhaar_no" value="<?php echo $personal_row['social_security_no']; ?>" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" required>
								</div>
							</div>
							<div class="row" style="margin-bottom:15px">
								<div class="col-md-3">Name : </div>
								<div class="col-md-9">
									<input type="text" style="width:100%;height:20px;background-color: #eee;" id="adhaar_name" placeholder="" name="adhaar_name" value="<?php echo get_username(); ?>" readonly required>
								</div>
							</div>
							<div class="row" style="margin-bottom:15px">
								<div class="col-md-3">Father's Name : </div>
								<div class="col-md-9">
									<input type="text" style="width:100%;height:20px" id="adhaar_fathers_name" placeholder="" value="<?php echo $personal_row['father_name']; ?>" name="adhaar_fathers_name" required>
								</div>
							</div>
							<div class="row" style="margin-bottom:15px">
								<div class="col-md-3">Date of Birth : </div>
								<div class="col-md-9">
									<input type="date" style="width:150px;height:20px" id="adhaar_dob" placeholder="" value="<?php echo $adhaar_row['dob']; ?>" name="adhaar_dob" required>
								</div>
							</div>
							<div class="row" style="margin-bottom:15px">
								<div class="col-md-3">Address : </div>
								<div class="col-md-9">
									<input type="text" style="width:100%;height:20px" id="adhaar_address" placeholder="" value="<?php echo $personal_row['address_permanent']; ?>" name="adhaar_address" required>
								</div>
							</div>
							<div class="row" style="margin-bottom:15px">
								<div class="col-md-3">PIN : </div>
								<div class="col-md-9">
									<input type="text" style="width:100%;height:20px" id="adhaar_pin" placeholder="" value="<?php echo $personal_row['pin']; ?>" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" name="adhaar_pin" required>
								</div>
							</div>
							<div class="row" style="margin-bottom:15px">
								<div class="col-md-3">City : </div>
								<div class="col-md-9">
									<input type="text" style="width:100%;height:20px" id="adhaar_city" placeholder="" value="<?php echo $personal_row['city']; ?>" name="adhaar_city" required>
								</div>
							</div>
							<div class="row" style="margin-bottom:15px">
								<div class="col-md-3">State : </div>
								<div class="col-md-9">
									<select class="form-control" style="width:100%" id="adhaar_state" placeholder="" name="adhaar_state" required>
										<?php
										foreach ($get_per_states as $per_state) {
											$per_state_selected = "";
											if ($personal_row['state'] == $per_state['name']) {
												$per_state_selected = "selected";
											}
										?>
											<option sid="<?php echo $per_state['id']; ?>" value="<?php echo $per_state['name']; ?>" <?php echo $per_state_selected; ?>><?php echo $per_state['name']; ?></option>
										<?php } ?>
									</select>
								</div>
							</div>
							<br />
							<div class="row">
								<div class="col-md-12">
									<div class="form-group" style="margin-bottom: 20px;">
										<b>NOTE : Please update the above details as per your aadhaar card before you acknowledge. For incorrect name, please contact respective supervisor/tl.</b>
									</div>
								</div>
								<div class="col-md-12">
									<input type="hidden" value="2" name="pre_submission_type">
									<input type="hidden" value="<?php echo $personal_row['user_id']; ?>" name="pre_user_id">
									<input type="submit" class="btn btn-primary filter_btn" style="height:30px;width:100px" value="Update" name="submit">
								</div>
							</div>
						</form>
						<hr />
						<?php if ($personal_row['social_security_no'] != "") { ?>
							<form action="<?php echo base_url('bg_verification/submit_background_verification'); ?>" autocomplete="off" method='POST' autocomplete="off">
								<div class="row">
									<div class="form-group text-center">
										<input type="checkbox" value="1" name="acknowledge_adhaar" id="acknowledge_adhaar" style="height:auto; margin-right:6px" required>
										<b>I acknowledge that all the above details are as per my Aadhaar Card.</b>
									</div>
								</div>
								<div class="row">
									<div class="form-group text-center">
										<input type="hidden" value="3" name="pre_submission_type">
										<input type="hidden" value="<?php echo $personal_row['user_id']; ?>" name="pre_user_id">
										<input type="submit" class="btn btn-success" style="width:150px;height:34px;background: var(--bs-blue);font-size:14px;" value="Submit" name="submit">
									</div>
								</div>
							</form>
							<?php if ($personal_row['is_bgv_adhaar'] != 3) { ?>
								<form action="<?php echo base_url('bg_verification/submit_background_verification'); ?>" autocomplete="off" method='POST' autocomplete="off">
									<input type="hidden" value="3" name="pre_submission_type">
									<input type="hidden" value="<?php echo $personal_row['user_id']; ?>" name="pre_user_id">
									<input type="hidden" value="<?php echo empty($personal_row['is_bgv_adhaar']) ? '2' : '3'; ?>" name="pre_user_skip">
									<div class="row">
										<div class="col-md-12" style="text-align:right">
											<input type="submit" class="btn btn_padding filter_btn" style="width:100px;height:30px" value="Skip Now" name="submit">
										</div>
										<div class="col-md-12" style="text-align:right;margin-top:10px">
											<span><b>NOTE : <?php echo $personal_row['is_bgv_adhaar'] == 0 ? "2 Skips Remaining" : "1 Skip Remaining"; ?></b></span>
										</div>
									</div>
								</form>
						<?php }
						} ?>
					</div>
				</div>
			</div>
		<?php } ?>
	</section>
</div>