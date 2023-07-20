<style>
.table > tbody > tr > td{
	text-align: center;
	font-size:12px;
}

#theader{
	font-size:20px;
	font-weight:bold;
	background-color:#95A5A6;
}

.eml{
	font-weight:bold;
	background-color:#F4D03F;
}
.eml1{
	font-weight:bold;
	background-color:#add8e6;
}
.eml2{
	font-weight:bold;
	background-color:#90ee90;
}
.eml3{
	font-weight:bold;
	background-color:#C4A484;
}
.eml4{
	font-weight:bold;
	background-color:#969d54;
}
.eml5{
	font-weight:bold;
	background-color:#ee9090;
}
.ui-datepicker .ui-datepicker-buttonpane button.ui-datepicker-current {
	 float: left;
	 display: none;
	}

</style>

<?php if ($hcco_srv3_id != 0) {
	if (is_access_qa_edit_feedback() == false) { ?>
		<style>
			.form-control {
				pointer-events: none;
				background-color: #D5DBDB;
			}
		</style>
<?php }
} ?>

<div class="wrap">
	<section class="app-content">

		<div class="row">
			<div class="col-12">
				<div class="widget">
					<form id="form_audit_user" method="POST" action="" enctype="multipart/form-data">

						<div class="widget-body">
							<div class="table-responsive">
								<table class="table table-striped skt-table" width="100%">
									<tbody>
										<tr>
											<td colspan="8" id="theader" style="font-size:40px">HCCO SR V3</td>
											<input type="hidden" name="audit_start_time" value="<?php echo CurrMySqlDate(); ?>">
										</tr>
										<?php
										if ($hcco_srv3_id == 0) {
											$auditorName = get_username();
											//$auditDate = CurrDateMDY();
											$auditDate =  CurrDateTimeMDY();
											$clDate_val = '';
										} else {
											if ($hcco_sr_v3_data['entry_by'] != '') {
												$auditorName = $hcco_sr_v3_data['auditor_name'];
											} else {
												$auditorName = $hcco_sr_v3_data['client_name'];
											}
											$clDate_val = mysql2mmddyySls($hcco_sr_v3_data['call_date']);
										}
										if ($rand_id != 0) {
											$agent_id = $rand_data['sid'];
											$fusion_id = $rand_data['fusion_id'];
											$agent_name = $rand_data['fname'] . " " . $rand_data['lname'];
											$tl_id = $rand_data['assigned_to'];
											$tl_name = $rand_data['tl_name'];
											$call_duration = $rand_data['call_duration'];
											
										} else {
											$agent_id = $hcco_sr_v3_data['agent_id'];
											$fusion_id = $hcco_sr_v3_data['fusion_id'];
											$agent_name = $hcco_sr_v3_data['fname'] . " " . $hcco_sr_v3_data['lname'] ;
											$tl_id = $hcco_sr_v3_data['tl_id'];
											$tl_name = $hcco_sr_v3_data['tl_name'];
											$call_duration = $hcco_sr_v3_data['call_duration'];
										}
										?>
										<tr>
											<td>Auditor Name:</td>
											<td><input type="text" class="form-control" value="<?= $auditorName; ?>" disabled></td>
											<td>Audit Date:</td>
											<td colspan="2"><input type="text" class="form-control" value="<?= CurrDateMDY() ?>" disabled></td>
											<td>Call Date:<span style="font-size:24px;color:red">*</span></td>
											<td colspan="2">
												<input type="text" id="call_date" name="call_date"  onkeydown="return false;" value="<?php echo $clDate_val; ?>" max="<?php echo date("Y-m-d"); ?>" class="form-control" required>
											</td>
										</tr>
										<tr>
											<td>Agent Name:<span style="font-size:24px;color:red">*</span></td>
											<td>
												<select class="form-control" id="agent_id" name="data[agent_id]" required>
											<option value="">-Select-</option>
											<?php foreach($agentName as $row){
												$sCss='';
												if($row['id']==$agent_id) $sCss='selected';
											?>
												<option value="<?php echo $row['id']; ?>" <?php echo $sCss; ?>><?php echo $row['name']; ?></option>
											<?php } ?>
										</select>
											</td>
											<td>Employee ID:</td>
											<td colspan="2"><input type="text" class="form-control" id="fusion_id" required value="<?php echo $fusion_id; ?>" readonly></td>
											<td> L1 Supervisor:<span style="font-size:24px;color:red">*</span></td>
											<td colspan="2">
												<input type="text" class="form-control" id="tl_names"  value="<?php echo $tl_name; ?>" readonly>
												<input type="hidden" class="form-control" id="tl_id" name="data[tl_id]" value="<?php echo $tl_id; ?>" required>
											</td>
										</tr>
										<tr>
											<td>Week No:<span style="font-size:24px;color:red">*</span></td>
											<td>
												<input type="text" id="week_no" name="data[week_no]"  value="<?php echo $hcco_sr_v3_data['week_no']; ?>" class="form-control" required>
											</td>
											<td>SR/Contact ID:<span style="font-size:24px;color:red">*</span></td>
											<td colspan="2">
												<input type="text" id="consumer_no" name="data[SR_contact_id]"  onkeyup="checkDec(this);" value="<?php echo $hcco_sr_v3_data['SR_contact_id']; ?>" class="form-control" required>
												<span id="start_phone" style="color:red"></span>
											</td>
											<td>Call Duration:<span style="font-size:24px;color:red">*</span></td>
											<td colspan="2"><input type="text" class="form-control" onkeydown="return false;" id="call_duration" name="data[call_duration]" value="<?php echo $call_duration; ?>" required></td>
										</tr>
										<tr>
											<td>KPI:<span style="font-size:24px;color:red">*</span></td>
											<td>
												<select class="form-control" id="KPI" name="data[KPI]" required>
													<option value="">-Select-</option>
													<option value="AHT"  <?= ($hcco_sr_v3_data['KPI']=="AHT")?"selected":"" ?>>AHT</option>
													<option value="Conversion"  <?= ($hcco_sr_v3_data['KPI']=="Conversion")?"selected":"" ?>>Conversion</option>
													<option value="SR/Hr"  <?= ($hcco_sr_v3_data['KPI']=="SR/Hr")?"selected":"" ?>>SR/Hr</option>
													<option value="Stella"  <?= ($hcco_sr_v3_data['KPI']=="Stella")?"selected":"" ?>>Stella</option>
													<option value="NA"  <?= ($hcco_sr_v3_data['KPI']=="NA")?"selected":"" ?>>NA</option>
												</select>
											</td>
											<td>KPI - ACPT:<span style="font-size:24px;color:red">*</span></td>
											<td colspan="2">
												<select class="form-control" id="KPI_ACPT" name="data[KPI_ACPT]" required>
													<option value="">-Select-</option>
													<option value="Agent"  <?= ($hcco_sr_v3_data['KPI_ACPT']=="Agent")?"selected":"" ?>>Agent</option>
													<option value="Process"  <?= ($hcco_sr_v3_data['KPI_ACPT']=="Process")?"selected":"" ?>>Process</option>
													<option value="Customer"  <?= ($hcco_sr_v3_data['KPI_ACPT']=="Customer")?"selected":"" ?>>Customer</option>
													<option value="Technology"  <?= ($hcco_sr_v3_data['KPI_ACPT']=="Technology")?"selected":"" ?>>Technology</option>
													<option value="NA"  <?= ($hcco_sr_v3_data['KPI_ACPT']=="NA")?"selected":"" ?>>NA</option>
												</select>
											</td>
											<td>Was this a first SR or a XS?:<span style="font-size:24px;color:red">*</span></td>
											<td>
												<select class="form-control" id="first_SR_XR" name="data[first_SR_XR]" required>
													
													<option value="">-Select-</option>
													<option value="SR"  <?= ($hcco_sr_v3_data['first_SR_XR']=="SR")?"selected":"" ?>>SR</option>
													<option value="XS"  <?= ($hcco_sr_v3_data['first_SR_XR']=="XS")?"selected":"" ?>>XS</option>
												</select>
											</td>
										</tr>
										<tr>
											<td>LOB:<span style="font-size:24px;color:red">*</span></td>
											<td>
												<select class="form-control" id="lob" name="data[lob]" required>
													
													<option value="">-Select-</option>
													<option value="Core"  <?= ($hcco_sr_v3_data['lob']=="Core")?"selected":"" ?>>Core</option>
													<option value="Cx"  <?= ($hcco_sr_v3_data['lob']=="Cx")?"selected":"" ?>>Cx</option>
												</select>
											</td>
											<td>VOC:<span style="font-size:24px;color:red">*</span></td>
											<td>
												<select class="form-control" id="voc" name="data[voc]" required>
													
													<option value="">-Select-</option>
													<option value="1"  <?= ($hcco_sr_v3_data['voc']=="1")?"selected":"" ?>>1</option>
													<option value="2"  <?= ($hcco_sr_v3_data['voc']=="2")?"selected":"" ?>>2</option>
													<option value="3"  <?= ($hcco_sr_v3_data['voc']=="3")?"selected":"" ?>>3</option>
													<option value="4"  <?= ($hcco_sr_v3_data['voc']=="4")?"selected":"" ?>>4</option>
													<option value="5"  <?= ($hcco_sr_v3_data['voc']=="5")?"selected":"" ?>>5</option>
													<option value="6"  <?= ($hcco_sr_v3_data['voc']=="6")?"selected":"" ?>>6</option>
													<option value="7"  <?= ($hcco_sr_v3_data['voc']=="7")?"selected":"" ?>>7</option>
													<option value="8"  <?= ($hcco_sr_v3_data['voc']=="8")?"selected":"" ?>>8</option>
													<option value="9"  <?= ($hcco_sr_v3_data['voc']=="9")?"selected":"" ?>>9</option>
													<option value="10"  <?= ($hcco_sr_v3_data['voc']=="10")?"selected":"" ?>>10</option>
												</select>
											</td>
												
											<td>Audit Type:<span style="font-size:24px;color:red">*</span></td>
											<td colspan="2">
												<select class="form-control" id="audit_type" name="data[audit_type]" required>
                                                    <option value="">-Select-</option>
                                                    <option value="CQ Audit" <?= ($hcco_sr_v3_data['audit_type']=="CQ Audit")?"selected":"" ?>>CQ Audit</option>
                                                    <option value="BQ Audit" <?= ($hcco_sr_v3_data['audit_type']=="BQ Audit")?"selected":"" ?>>BQ Audit</option>
                                                    <option value="Calibration" <?= ($hcco_sr_v3_data['audit_type']=="Calibration")?"selected":"" ?>>Calibration</option>
                                                    <option value="Pre-Certificate Mock Call" <?= ($hcco_sr_v3_data['audit_type']=="Pre-Certificate Mock Call")?"selected":"" ?>>Pre-Certificate Mock Call</option>
                                                    <option value="Certification Audit" <?= ($hcco_sr_v3_data['audit_type']=="Certification Audit")?"selected":"" ?>>Certification Audit</option>
                                                    <option value="Operation Audit" <?= ($hcco_sr_v3_data['audit_type']=="Operation Audit")?"selected":"" ?>>Operation Audit</option>
                                                    <option value="Trainer Audit"  <?= ($hcco_sr_v3_data['audit_type']=="Trainer Audit")?"selected":"" ?>>Trainer Audit</option>
                                                    <option value="Hygiene Audit"  <?= ($hcco_sr_v3_data['audit_type']=="Hygiene Audit")?"selected":"" ?>>Hygiene Audit</option>
                                                    <option value="WOW Call" <?= ($hcco_sr_v3_data['audit_type']=="WOW Call")?"selected":"" ?>>Wow Call</option>
                                                    <option value="QA Supervisor Audit" <?= ($hcco_sr_v3_data['audit_type']=="QA Supervisor Audit")?"selected":"" ?>>QA Supervisor Audit</option>
                                                </select>
											</td>
										</tr>
										<tr>
											<td class="auType">Auditor Type<span style="font-size:24px;color:red">*</span></td>
											<td colspan="2" class="auType">
												<select class="form-control" id="auditor_type" name="data[auditor_type]">
                                                    <option>Select</option>
                                                    <option value="Master" <?= ($hcco_sr_v3_data['auditor_type']=="Master")?"selected":"" ?>>Master</option>
                                                    <option value="Regular" <?= ($hcco_sr_v3_data['auditor_type']=="Regular")?"selected":"" ?>>Regular</option>
                                                </select>
											</td>
										</tr>
										
										<tr class="eml" style="height:25px; font-weight:bold">
											<td colspan=4>SR Audit Details</td>
											<td>STATUS</td>
											<td colspan=2>REMARKS</td>
										</tr>

										<tr>
											<td colspan=4>Was there a credit applied to this SR?</td>
											<td>
												<select class="form-control" name="data[credit_applied_SR]" required>
													<option <?php echo $hcco_sr_v3_data['credit_applied_SR'] == "Yes" ? "selected" : ""; ?> value="Yes">Yes</option>
													<option <?php echo $hcco_sr_v3_data['credit_applied_SR'] == "No" ? "selected" : ""; ?> value="No">No</option>	
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt1]" class="form-control" value="<?php echo $hcco_sr_v3_data['cmt1'] ?>"></td>
										</tr>
										<tr>
											<td colspan=4>Was there a complete detailed description?</td>
											<td>
												<select class="form-control" name="data[complete_detailed_description]" required>
													<option <?php echo $hcco_sr_v3_data['complete_detailed_description'] == "Yes" ? "selected" : ""; ?> value="Yes">Yes</option>
													<option <?php echo $hcco_sr_v3_data['complete_detailed_description'] == "No" ? "selected" : ""; ?> value="No">No</option>	
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt2]" class="form-control" value="<?php echo $hcco_sr_v3_data['cmt2'] ?>"></td>
										</tr>
										<tr>
											<td colspan=4>Was the phone number, address, first and last name, and email correct? (NO DUMMY EMAIL)</td>
											<td>
												<select class="form-control" name="data[address_email_correct]" required>
													<option <?php echo $hcco_sr_v3_data['address_email_correct'] == "Yes" ? "selected" : ""; ?> value="Yes">Yes</option>
													<option <?php echo $hcco_sr_v3_data['address_email_correct'] == "No" ? "selected" : ""; ?> value="No">No</option>	
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt3]" class="form-control" value="<?php echo $hcco_sr_v3_data['cmt3'] ?>"></td>
										</tr>
										<tr>
											<td colspan=4>Did we submit the correct and appropriate CTT? </td>
											<td>
												<select class="form-control" name="data[correct_CTT]" required>
													<option <?php echo $hcco_sr_v3_data['correct_CTT'] == "Yes" ? "selected" : ""; ?> value="Yes">Yes</option>
													<option <?php echo $hcco_sr_v3_data['correct_CTT'] == "No" ? "selected" : ""; ?> value="No">No</option>	
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt4]" class="form-control" value="<?php echo $hcco_sr_v3_data['cmt4'] ?>"></td>
										</tr>
										<tr>
											<td colspan=4>Did we follow all appropriate SR Guidelines? (no duplicate requests, was the XS appropriate) </td>
											<td>
												<select class="form-control" name="data[SR_guidelines]" required>
													<option <?php echo $hcco_sr_v3_data['SR_guidelines'] == "Yes" ? "selected" : ""; ?> value="Yes">Yes</option>
													<option <?php echo $hcco_sr_v3_data['SR_guidelines'] == "No" ? "selected" : ""; ?> value="No">No</option>	
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt5]" class="form-control" value="<?php echo $hcco_sr_v3_data['cmt5'] ?>"></td>
										</tr>
										<tr>
											<td colspan=4>Was there more than one request submitted for the original project?</td>
											<td>
												<select class="form-control" name="data[original_project]" required>
													<option <?php echo $hcco_sr_v3_data['original_project'] == "NA" ? "selected" : ""; ?> value="NA">NA</option>
													<option <?php echo $hcco_sr_v3_data['original_project'] == "Yes" ? "selected" : ""; ?> value="Yes">Yes</option>
													<option <?php echo $hcco_sr_v3_data['original_project'] == "No" ? "selected" : ""; ?> value="No">No</option>	
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt6]" class="form-control" value="<?php echo $hcco_sr_v3_data['cmt6'] ?>"></td>
										</tr>
										<tr>
											<td colspan=4>If you answered No to any of these questions, please describe what you observed</td>
											<td>
											</td>
											<td colspan=2><input type="text" name="data[cmt7]" class="form-control" value="<?php echo $hcco_sr_v3_data['cmt7'] ?>"></td>
										</tr>
										<tr>
											<td colspan=4>Possible Knowledged Gap</td>
											<td>
												<select class="form-control" name="data[knowledged_gap]" required>
													<option <?php echo $hcco_sr_v3_data['knowledged_gap'] == "Yes" ? "selected" : ""; ?> value="Yes">Yes</option>
													<option <?php echo $hcco_sr_v3_data['knowledged_gap'] == "No" ? "selected" : ""; ?> value="No">No</option>	
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt8]" class="form-control" value="<?php echo $hcco_sr_v3_data['cmt8'] ?>"></td>
										</tr>
										<tr>
											<td colspan=4>Possible Fraud / Manipulation</td>
											<td>
												<select class="form-control" name="data[fraud_manipulation]" required>
													<option <?php echo $hcco_sr_v3_data['fraud_manipulation'] == "Yes" ? "selected" : ""; ?> value="Yes">Yes</option>
													<option <?php echo $hcco_sr_v3_data['fraud_manipulation'] == "No" ? "selected" : ""; ?> value="No">No</option>	
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt9]" class="form-control" value="<?php echo $hcco_sr_v3_data['cmt9'] ?>"></td>
										</tr>
										<tr>
											<td colspan=4>COACHED</td>
											<td>
												<select class="form-control" name="data[coached]" required>
													<option <?php echo $hcco_sr_v3_data['coached'] == "Yes" ? "selected" : ""; ?> value="Yes">Yes</option>
													<option <?php echo $hcco_sr_v3_data['coached'] == "No" ? "selected" : ""; ?> value="No">No</option>	
													<option <?php echo $hcco_sr_v3_data['coached'] == "Pending" ? "selected" : ""; ?> value="Pending">Pending</option>	
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt10]" class="form-control" value="<?php echo $hcco_sr_v3_data['cmt10'] ?>"></td>
										</tr>
										<tr>
											<td>Call Summary:</td>
											<td colspan=2><textarea class="form-control" name="data[call_summary]"><?php echo $hcco_sr_v3_data['call_summary'] ?></textarea></td>
											<td>Feedback:</td>
											<td colspan=4><textarea class="form-control" name="data[feedback]"><?php echo $hcco_sr_v3_data['feedback'] ?></textarea></td>
										</tr>
										<tr>
											<td colspan=2>Upload Files [m4a,mp4,mp3,wav]</td>
											<?php if ($hcco_srv3_id == 0) { ?>
												<td colspan=6>
													<input type="file" name="attach_file[]" id="attach_file" accept=".m4a,.mp4,.mp3,.wav,audio/*" />
												</td>
												<?php } else {
												if ($hcco_sr_v3_data['attach_file'] != '') { ?>
													<td colspan=6>
														<input type="file" multiple class="form-control"  id="attach_file" name="attach_file[]" accept=".m4a,.mp4,.mp3,.wav,audio/*"> 
														<?php $attach_file = explode(",", $hcco_sr_v3_data['attach_file']);
														foreach ($attach_file as $mp) { ?>
															<audio controls='' style="background-color:#607F93">
																<source src="<?php echo base_url(); ?>qa_files/qa_homeadvisor/hcco_sr/<?php echo $mp; ?>" type="audio/ogg">
																<source src="<?php echo base_url(); ?>qa_files/qa_homeadvisor/hcco_sr/<?php echo $mp; ?>" type="audio/mpeg">
															</audio> </br>
														<?php } ?>
													</td>
											<?php } else {
													echo '<td colspan=6>
													<input type="file" multiple class="form-control" id="attach_file" name="attach_file[]" accept=".m4a,.mp4,.mp3,.wav,audio/*">
													<b>No Files</b></td>';
												}
											} ?>
										</tr>

										<?php if ($hcco_srv3_id != 0) { ?>
											<tr>
												<td colspan=2 style="font-size:16px; font-weight:bold">Agent Feedback Acceptance:</td>
												<td colspan=4><?php echo $hcco_sr_v3_data['agnt_fd_acpt'] ?></td>
											</tr>
											<tr>
												<td colspan=2 style="font-size:16px; font-weight:bold">Agent Review:</td>
												<td colspan=4><?php echo $hcco_sr_v3_data['agent_rvw_note'] ?></td>
											</tr>
											<tr>
												<td colspan=2 style="font-size:16px; font-weight:bold">Management Review:</td>
												<td colspan=4><?php echo $hcco_sr_v3_data['mgnt_rvw_note'] ?></td>
											</tr>
											<tr>
												<td colspan=2 style="font-size:16px; font-weight:bold">Client Review:</td>
												<td colspan=4><?php echo $hcco_sr_v3_data['client_rvw_note'] ?></td>
											</tr>

											<tr>
												<td colspan=2 style="font-size:16px">Your Review<span style="font-size:24px;color:red">*</span></td>
												<td colspan=4><textarea class="form-control1" style="width:100%" id="note" name="note" required></textarea></td>
											</tr>
										<?php } ?>

										<?php
										if ($hcco_srv3_id == 0) {
											if (is_access_qa_module() == true || is_access_qa_operations_module() == true) { ?>
												<tr>
													<td colspan=8><button class="btn btn-success waves-effect" type="submit" id="qaformsubmit" style="width:500px">SAVE</button></td>
												</tr>
												<?php
											}
										} else {
											if (is_access_qa_module() == true || is_access_qa_operations_module() == true) {
												if (is_available_qa_feedback($hcco_sr_v3_data['entry_date'], 72) == true) { ?>
													<tr>
														<td colspan="8"><button class="btn btn-success waves-effect" type="submit" id='qaformsubmit' name='btnSave' value="SAVE" style="width:500px">SAVE</button></td>
													</tr>
										<?php
												}
											}
										}
										?>

									</tbody>
								</table>
							</div>
						</div>

					</form>

				</div>
			</div>
		</div>

	</section>
</div>