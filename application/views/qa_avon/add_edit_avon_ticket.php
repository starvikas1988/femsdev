<style>
	.table>tbody>tr>td {
		text-align: center;
		font-size: 13px;
	}

	#theader {
		font-size: 20px;
		font-weight: bold;
		background-color: #95A5A6;
	}

	.eml {
		background-color: #85C1E9;
	}
	.fatal .eml{
		background-color: red;
		color: white;
	}
</style>

<?php if ($avon_id != 0) {
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
											<td colspan="6" id="theader" style="font-size:40px">Avon</td>
											<input type="hidden" name="audit_start_time" value="<?php echo CurrMySqlDate(); ?>">
										</tr>
										<?php
										if ($avon_id == 0) {
											$auditorName = get_username();
											$auditDate = CurrDateMDY();
											$clDate_val = '';
										} else {
											if ($avon_ticket['entry_by'] != '') {
												$auditorName = $avon_ticket['auditor_name'];
											} else {
												$auditorName = $avon_ticket['client_name'];
											}
											$auditDate = mysql2mmddyy($avon_ticket['audit_date']);
											$clDate_val = mysql2mmddyy($avon_ticket['call_date']);
										}
										?>
										<tr>
											<td>Auditor Name:</td>
											<td><input type="text" class="form-control" value="<?= $auditorName; ?>" disabled></td>
											<td>Audit Date:</td>
											<td><input type="text" class="form-control" value="<?= $auditDate; ?>" disabled></td>
											<td>Date of Ticket:</td>
											<td><input type="text" class="form-control" id="call_date" name="call_date" value="<?= $clDate_val; ?>" required></td>
										</tr>
										<tr>
											<td>Employee Name:</td>
											<td>
												<select class="form-control" id="agent_id" name="data[agent_id]" required>
													<option value="<?php echo $avon_ticket['agent_id'] ?>"><?php echo $avon_ticket['fname'] . " " . $avon_ticket['lname'] ?></option>
													<option value="">-Select-</option>
													<?php foreach ($agentName as $row) :  ?>
														<option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
													<?php endforeach; ?>
												</select>
											</td>
											<td>Employee ID:</td>
											<td><input type="text" class="form-control" id="fusion_id" value="<?php echo $avon_ticket['fusion_id'] ?>" readonly></td>
											<td>L1 Supervisor:</td>
											<td>
												<select class="form-control" id="tl_id" name="data[tl_id]" readonly>
													<option value="<?php echo $avon_ticket['tl_id'] ?>"><?php echo $avon_ticket['tl_name'] ?></option>
													<option value="">--Select--</option>
													<?php foreach ($tlname as $tl) : ?>
														<option value="<?php echo $tl['id']; ?>"><?php echo $tl['fname'] . " " . $tl['lname']; ?></option>
													<?php endforeach; ?>
												</select>
											</td>
										</tr>
										<tr>
											<td colspan="2">SLA:</td>
											<td colspan="2"><input type="text" class="form-control" id="sla" name="data[sla]" value="<?php echo $avon_ticket['sla'] ?>" required></td>
											<td>Ticket Type:</td>
											<td><input type="text" class="form-control" name="data[ticket_type]" value="<?php echo $avon_ticket['ticket_type'] ?>" required></td>
										</tr>
										<tr>
											<td colspan="2">Digital/Non Digital</td>
											<td colspan="2">
												<select class="form-control" name="data[digital_non_digital]" required>
													<option value="<?php echo $avon_ticket['digital_non_digital'] ?>"><?php echo $avon_ticket['digital_non_digital'] ?></option>
													<option value="1">Yes</option>
													<option value="0">No</option>
												</select>
											</td>
											<td>Week</td>
											<td>
												<select class="form-control" name="data[week]" required>
													<option value="<?php echo $avon_ticket['week'] ?>"><?php echo $avon_ticket['week'] ?></option>
													<option value="1">Week 1</option>
													<option value="2">Week 2</option>
													<option value="3">Week 3</option>
													<option value="4">Week 4</option>
													<option value="5">Week 5</option>
												</select>
											</td>
										</tr>
										<tr>
											<td>Audit Type:</td>
											<td>
												<select class="form-control" id="audit_type" name="data[audit_type]" required>
													<option value="<?php echo $avon_ticket['audit_type'] ?>"><?php echo $avon_ticket['audit_type'] ?></option>
													<option value="">-Select-</option>
													<option value="CQ Audit">CQ Audit</option>
													<option value="BQ Audit">BQ Audit</option>
													<option value="Calibration">Calibration</option>
													<option value="Pre-Certificate Mock Call">Pre-Certificate Mock Call</option>
													<option value="Certification Audit">Certification Audit</option>
													<option value="Operation Audit">Operation Audit</option>
													<option value="Trainer Audit">Trainer Audit</option>
												</select>
											</td>
											<td class="auType">Auditor Type</td>
											<td class="auType">
												<select class="form-control" id="auditor_type" name="data[auditor_type]">
													<option value="<?php echo $avon_ticket['auditor_type'] ?>"><?php echo $avon_ticket['auditor_type'] ?></option>
													<option value="">-Select-</option>
													<option value="Master">Master</option>
													<option value="Regular">Regular</option>
												</select>
											</td>
											<td>VOC:</td>
											<td>
												<select class="form-control" id="voc" name="data[voc]" required>
													<option value="<?php echo $avon_ticket['voc'] ?>"><?php echo $avon_ticket['voc'] ?></option>
													<option value="">-Select-</option>
													<option value="1">1</option>
													<option value="2">2</option>
													<option value="3">3</option>
													<option value="4">4</option>
													<option value="5">5</option>
													<option value="6">6</option>
													<option value="7">7</option>
													<option value="8">8</option>
													<option value="9">9</option>
													<option value="10">10</option>
												</select>
											</td>
										</tr>
										<tr>
											<td style="font-weight:bold; font-size:16px; text-align:left">Earned Score</td>
											<td><input type="text" readonly id="avon_earned_score" name="data[earned_score]" class="form-control" value="<?php echo $avon_ticket['earned_score'] ?>" /></td>
											<td style="font-weight:bold; font-size:16px; text-align:left">Possible Score</td>
											<td><input type="text" readonly id="avon_possible_score" name="data[possible_score]" class="form-control" value="<?php echo $avon_ticket['possible_score'] ?>" /></td>
											<td style="font-weight:bold; font-size:16px; text-align:right">Overall Score:</td>
											<td><input type="text" readonly id="avon_overall_score" name="data[overall_score]" class="form-control avonFatal" style="font-weight:bold" value="<?php echo $avon_ticket['overall_score'] ?>"></td>
										</tr>
										<tr class="eml" style="height:25px; font-weight:bold">
											<td>PARAMETER</td>
											<td colspan=2>SUB PARAMETER</td>
											<td>STATUS</td>
											<td colspan=2>REMARKS</td>
										</tr>
										<tr>
											<td class="eml" colspan="3">Identifying Ticket</td>
											<td>
												<select class="form-control avon_point" name="data[identifying_ticket]" required>
													<option value="">-Select-</option>
													<option avon_val=5 <?= $avon_ticket['identifying_ticket'] == "Yes" ? "selected" : ""; ?> value="Yes">Yes</option>
													<option avon_val=0 <?= $avon_ticket['identifying_ticket'] == "No" ? "selected" : ""; ?> value="No">No</option>
													<option avon_val=0 <?= $avon_ticket['identifying_ticket'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt1]" class="form-control" value="<?php echo $avon_ticket['cmt1'] ?>"></td>
										</tr>
										<tr>
											<td class="eml" colspan="3">SLA Achieved</td>
											<td>
												<select class="form-control avon_point" name="data[sla_achieved]" required>
													<option value="">-Select-</option>
													<option avon_val=5 <?= $avon_ticket["sla_achieved"] == "Yes" ? "selected" : "" ?> value="Yes">Yes</option>
													<option avon_val=0 <?= $avon_ticket["sla_achieved"] == "No" ? "selected" : "" ?> value="No">No</option>
													<option avon_val=0 <?= $avon_ticket["sla_achieved"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt2]" class="form-control" value="<?php echo $avon_ticket['cmt2'] ?>"></td>
										</tr>
										<tr>
											<td class="eml" colspan="3">Sent to Right Approver</td>
											<td>
												<select class="form-control avon_point" name="data[sent_right_approver]" required>
													<option value="">-Select-</option>
													<option avon_val=5 <?= $avon_ticket["sent_right_approver"] == "Yes" ? "selected" : "" ?> value="Yes">Yes</option>
													<option avon_val=0 <?= $avon_ticket["sent_right_approver"] == "No" ? "selected" : "" ?> value="No">No</option>
													<option avon_val=0 <?= $avon_ticket["sent_right_approver"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt3]" class="form-control" value="<?php echo $avon_ticket['cmt3'] ?>"></td>
										</tr>
										<tr>
											<td class="eml" colspan="3">Followed Request</td>
											<td>
												<select class="form-control avon_point" name="data[followed_request]" required>
													<option value="">-Select-</option>
													<option avon_val=3 <?= $avon_ticket["followed_request"] == "Yes" ? "selected" : "" ?> value="Yes">Yes</option>
													<option avon_val=0 <?= $avon_ticket["followed_request"] == "No" ? "selected" : "" ?> value="No">No</option>
													<option avon_val=0 <?= $avon_ticket["followed_request"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt4]" class="form-control" value="<?php echo $avon_ticket['cmt4'] ?>"></td>
										</tr>
										<tr>
											<td colspan="3" class="eml">Efficiency Of Action</td>
											<td>
												<select class="form-control avon_point" name="data[efficiency_of_action]" required>
													<option value="">-Select-</option>
													<option avon_val=5 <?= $avon_ticket["efficiency_of_action"] == "Yes" ? "selected" : "" ?> value="Yes">Yes</option>
													<option avon_val=0 <?= $avon_ticket["efficiency_of_action"] == "No" ? "selected" : "" ?> value="No">No</option>
													<option avon_val=0 <?= $avon_ticket["efficiency_of_action"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt5]" class="form-control" value="<?php echo $avon_ticket['cmt5'] ?>"></td>
										</tr>
										<tr>
											<td colspan="3" class="eml">Correct Information Shared</td>
											<td>
												<select class="form-control avon_point" name="data[correct_info_shared]" required>
													<option value="">-Select-</option>
													<option avon_val=5 <?= $avon_ticket["correct_info_shared"] == "Yes" ? "selected" : "" ?> value="Yes">Yes</option>
													<option avon_val=0 <?= $avon_ticket["correct_info_shared"] == "No" ? "selected" : "" ?> value="No">No</option>
													<option avon_val=0 <?= $avon_ticket["correct_info_shared"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt6]" class="form-control" value="<?php echo $avon_ticket['cmt6'] ?>"></td>
										</tr>
										<tr>
											<td class="eml" colspan="3">Documentation</td>
											<td>
												<select class="form-control avon_point" name="data[documentation]" required>
													<option value="">-Select-</option>
													<option avon_val=5 <?= $avon_ticket["documentation"] == "Yes" ? "selected" : "" ?> value="Yes">Yes</option>
													<option avon_val=0 <?= $avon_ticket["documentation"] == "No" ? "selected" : "" ?> value="No">No</option>
													<option avon_val=0 <?= $avon_ticket["documentation"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt7]" class="form-control" value="<?php echo $avon_ticket['cmt7'] ?>"></td>
										</tr>
										<tr>
											<td class="eml" rowspan="2">Information Shared</td>
											<td colspan="2">Incomplete Information</td>
											<td>
												<select class="form-control avon_point" name="data[information_shared_incomplete]" required>
													<option value="">-Select-</option>
													<option avon_val=10 <?= $avon_ticket["information_shared_incomplete"] == "Yes" ? "selected" : "" ?> value="Yes">Yes</option>
													<option avon_val=0 <?= $avon_ticket["information_shared_incomplete"] == "No" ? "selected" : "" ?> value="No">No</option>
													<option avon_val=0 <?= $avon_ticket["information_shared_incomplete"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt8]" class="form-control" value="<?php echo $avon_ticket['cmt8'] ?>"></td>
										</tr>
										<tr>
											<td colspan="2">Inaccurate Information</td>
											<td>
												<select class="form-control avon_point" name="data[information_shared_inaccurate]" required>
													<option value="">-Select-</option>
													<option avon_val=10 <?= $avon_ticket["information_shared_inaccurate"] == "Yes" ? "selected" : "" ?> value="Yes">Yes</option>
													<option avon_val=0 <?= $avon_ticket["information_shared_inaccurate"] == "No" ? "selected" : "" ?> value="No">No</option>
													<option avon_val=0 <?= $avon_ticket["information_shared_inaccurate"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt9]" class="form-control" value="<?php echo $avon_ticket['cmt9'] ?>"></td>
										</tr>
										<tr>
											<td colspan="3" class="eml">Correct Tagging</td>
											<td>
												<select class="form-control avon_point" name="data[correct_tagging]" required>
													<option value="">-Select-</option>
													<option avon_val=10 <?= $avon_ticket["correct_tagging"] == "Yes" ? "selected" : "" ?> value="Yes">Yes</option>
													<option avon_val=0 <?= $avon_ticket["correct_tagging"] == "No" ? "selected" : "" ?> value="No">No</option>
													<option avon_val=0 <?= $avon_ticket["correct_tagging"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt10]" class="form-control" value="<?php echo $avon_ticket['cmt10'] ?>"></td>
										</tr>
										<tr>
											<td colspan="3" class="eml">Avon Security</td>
											<td>
												<select class="form-control avon_point" name="data[avon_security]" required>
													<option value="">-Select-</option>
													<option avon_val=10 <?= $avon_ticket["avon_security"] == "Yes" ? "selected" : "" ?> value="Yes">Yes</option>
													<option avon_val=0 <?= $avon_ticket["avon_security"] == "No" ? "selected" : "" ?> value="No">No</option>
													<option avon_val=0 <?= $avon_ticket["avon_security"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt11]" class="form-control" value="<?php echo $avon_ticket['cmt11'] ?>"></td>
										</tr>
										<tr>
											<td>Call Summary:</td>
											<td colspan=2><textarea class="form-control" name="data[call_summary]"><?php echo $avon_ticket['call_summary'] ?></textarea></td>
											<td>Feedback:</td>
											<td colspan=2><textarea class="form-control" name="data[feedback]"><?php echo $avon_ticket['feedback'] ?></textarea></td>
										</tr>
										<tr>
											<td colspan=2>Upload Files</td>
											<?php if ($avon_id == 0) { ?>
												<td colspan=4><input type="file" multiple class="form-control" id="attach_file" name="attach_file[]"></td>
												<?php } else {
												if ($avon_ticket['attach_file'] != '') { ?>
													<td colspan=4>
														<?php $attach_file = explode(",", $avon_ticket['attach_file']);
														foreach ($attach_file as $mp) { ?>
															<audio controls='' style="background-color:#607F93">
																<source src="<?php echo base_url(); ?>qa_files/qa_avon/<?php echo $mp; ?>" type="audio/ogg">
																<source src="<?php echo base_url(); ?>qa_files/qa_avon/<?php echo $mp; ?>" type="audio/mpeg">
															</audio> </br>
														<?php } ?>
													</td>
											<?php } else {
													echo '<td colspan=6><b>No Files</b></td>';
												}
											} ?>
										</tr>

										<?php if ($avon_id != 0) { ?>
											<tr>
												<td colspan=2 style="font-size:16px; font-weight:bold">Agent Feedback Acceptance:</td>
												<td colspan=4><?php echo $avon_ticket['agnt_fd_acpt'] ?></td>
											</tr>
											<tr>
												<td colspan=2 style="font-size:16px; font-weight:bold">Agent Review:</td>
												<td colspan=4><?php echo $avon_ticket['agent_rvw_note'] ?></td>
											</tr>
											<tr>
												<td colspan=2 style="font-size:16px; font-weight:bold">Management Review:</td>
												<td colspan=4><?php echo $avon_ticket['mgnt_rvw_note'] ?></td>
											</tr>
											<tr>
												<td colspan=2 style="font-size:16px; font-weight:bold">Client Review:</td>
												<td colspan=4><?php echo $avon_ticket['client_rvw_note'] ?></td>
											</tr>

											<tr>
												<td colspan=2 style="font-size:16px">Your Review</td>
												<td colspan=4><textarea class="form-control1" style="width:100%" id="note" name="note"></textarea></td>
											</tr>
										<?php } ?>

										<?php
										if ($avon_id == 0) {
											if (is_access_qa_module() == true || is_access_qa_operations_module() == true) { ?>
												<tr>
													<td colspan=6><button class="btn btn-success waves-effect" type="submit" id="qaformsubmit" style="width:500px">SAVE</button></td>
												</tr>
												<?php
											}
										} else {
											if (is_access_qa_module() == true || is_access_qa_operations_module() == true) {
												if (is_available_qa_feedback($avon_ticket['entry_date'], 72) == true) { ?>
													<tr>
														<td colspan="6"><button class="btn btn-success waves-effect" type="submit" id='qaformsubmit' name='btnSave' value="SAVE" style="width:500px">SAVE</button></td>
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