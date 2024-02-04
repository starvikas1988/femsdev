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
											if ($avon_outbound['entry_by'] != '') {
												$auditorName = $avon_outbound['auditor_name'];
											} else {
												$auditorName = $avon_outbound['client_name'];
											}
											$auditDate = mysql2mmddyy($avon_outbound['audit_date']);
											$clDate_val = mysql2mmddyy($avon_outbound['call_date']);
										}
										?>
										<tr>
											<td>Auditor Name:</td>
											<td><input type="text" class="form-control" value="<?= $auditorName; ?>" disabled></td>
											<td>Audit Date:</td>
											<td><input type="text" class="form-control" value="<?= $auditDate; ?>" disabled></td>
											<td>Call Date:</td>
											<td><input type="text" class="form-control" id="call_date" name="call_date" value="<?= $clDate_val; ?>" required></td>
										</tr>
										<tr>
											<td>Employee Name:</td>
											<td>
												<select class="form-control" id="agent_id" name="data[agent_id]" required>
													<option value="<?php echo $avon_outbound['agent_id'] ?>"><?php echo $avon_outbound['fname'] . " " . $avon_outbound['lname'] ?></option>
													<option value="">-Select-</option>
													<?php foreach ($agentName as $row) :  ?>
														<option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
													<?php endforeach; ?>
												</select>
											</td>
											<td>Employee ID:</td>
											<td><input type="text" class="form-control" id="fusion_id" value="<?php echo $avon_outbound['fusion_id'] ?>" readonly></td>
											<td>L1 Supervisor:</td>
											<td>
												<select class="form-control" id="tl_id" name="data[tl_id]" readonly>
													<option value="<?php echo $avon_outbound['tl_id'] ?>"><?php echo $avon_outbound['tl_name'] ?></option>
													<option value="">--Select--</option>
													<?php foreach ($tlname as $tl) : ?>
														<option value="<?php echo $tl['id']; ?>"><?php echo $tl['fname'] . " " . $tl['lname']; ?></option>
													<?php endforeach; ?>
												</select>
											</td>
										</tr>
										<tr>
											<td colspan="2">Call Duration:</td>
											<td colspan="2"><input type="text" class="form-control" id="call_duration" name="data[call_duration]" value="<?php echo $avon_outbound['call_duration'] ?>" required></td>
											<td>Type of Call:</td>
											<td>
												<select class="form-control" name="data[call_type]" required>
													<option value="">-SELECT-</option>
													<option value="Available CL" <?= ($avon_outbound['call_type']=="Available CL")?"selected":""?>>Available CL</option>
													<option value="Avon Grow App issue" <?= ($avon_outbound['call_type']=="Avon Grow App issue")?"selected":""?>>Avon Grow App issue</option>
													<option value="Cannot Login" <?= ($avon_outbound['call_type']=="Cannot Login")?"selected":""?>>Cannot Login</option>
													<option value="Avon Shop related Concern" <?= ($avon_outbound['call_type']=="Avon Shop related Concern")?"selected":""?>>Avon Shop related Concern</option>
													<!-- <option value="Avon Shop related Concern">Avon Shop related Concern</option> -->
													<option value="Branch Contact Details" <?= ($avon_outbound['call_type']=="Branch Contact Details")?"selected":""?>>Branch Contact Details</option>
													<option value="Branch Contact Number" <?= ($avon_outbound['call_type']=="Branch Contact Number")?"selected":""?>>Branch Contact Number</option>
													<option value="Branch Store Hours" <?= ($avon_outbound['call_type']=="Branch Store Hours")?"selected":""?>>Branch Store Hours</option>
													<option value="Branch Transfer" <?= ($avon_outbound['call_type']=="Branch Transfer")?"selected":""?>>Branch Transfer</option>
													<option value="Cancel Order" <?= ($avon_outbound['call_type']=="Cancel Order")?"selected":""?>>Cancel Order</option>
													<option value="Cannot Access AE Link" <?= ($avon_outbound['call_type']=="Cannot Access AE Link")?"selected":""?>>Cannot Access AE Link</option>
													<option value="Cannot Order - 24 Hour rule" <?= ($avon_outbound['call_type']=="Cannot Order - 24 Hour rule")?"selected":""?>>Cannot Order - 24 Hour rule</option>
													<option value="Credit Line Increase" <?= ($avon_outbound['call_type']=="Credit Line Increase")?"selected":""?>>Credit Line Increase</option>
													<option value="Credit Line Initial Granting" <?= ($avon_outbound['call_type']=="Credit Line Initial Granting")?"selected":""?>>Credit Line Initial Granting</option>
													<option value="Defective Item for Return or Exchange" <?= ($avon_outbound['call_type']=="Defective Item for Return or Exchange")?"selected":""?>>Defective Item for Return or Exchange</option>
													<option value="Delivery Coverage" <?= ($avon_outbound['call_type']=="Delivery Coverage")?"selected":""?>>Delivery Coverage</option>
													<option value="Discontinued/Removed FD for Resign" <?= ($avon_outbound['call_type']=="Discontinued/Removed FD for Resign")?"selected":""?>>Discontinued/Removed FD for Resign</option>
													<option value="Discount not reflected in the Invoice" <?= ($avon_outbound['call_type']=="Discount not reflected in the Invoice")?"selected":""?>>Discount not reflected in the Invoice</option>
													<option value="Due Date" <?= ($avon_outbound['call_type']=="Due Date")?"selected":""?>>Due Date</option>
													<option value="Feedback" <?= ($avon_outbound['call_type']=="Feedback")?"selected":""?>>Feedback</option>
													<option value="Follow Up CRM" <?= ($avon_outbound['call_type']=="Follow Up CRM")?"selected":""?>>Follow Up CRM</option>
													<option value="How it works" <?= ($avon_outbound['call_type']=="How it works")?"selected":""?>>How it works</option>
													<option value="How to pay due amount" <?= ($avon_outbound['call_type']=="How to pay due amount")?"selected":""?>>How to pay due amount</option>
													<option value="How to purchase" <?= ($avon_outbound['call_type']=="How to purchase")?"selected":""?>>How to purchase</option>
													<option value="Incomplete Delivery" <?= ($avon_outbound['call_type']=="Incomplete Delivery")?"selected":""?>>Incomplete Delivery</option>
													<option value="Incorrect Delivery" <?= ($avon_outbound['call_type']=="Incorrect Delivery")?"selected":""?>>Incorrect Delivery</option>
													<option value="Inquiry Ticket" <?= ($avon_outbound['call_type']=="Inquiry Ticket")?"selected":""?>>Inquiry Ticket</option>
													<option value="No Delivery Yet" <?= ($avon_outbound['call_type']=="No Delivery Yet")?"selected":""?>>No Delivery Yet</option>
													<option value="Online Order Status" <?= ($avon_outbound['call_type']=="Online Order Status")?"selected":""?>>Online Order Status</option>
													<option value="Order Impersonation" <?= ($avon_outbound['call_type']=="Order Impersonation")?"selected":""?>>Order Impersonation</option>
													<option value="PDA" <?= ($avon_outbound['call_type']=="PDA")?"selected":""?>>PDA</option>
													<option value="POP Payment not posted" <?= ($avon_outbound['call_type']=="POP Payment not posted")?"selected":""?>>POP Payment not posted</option>
													<option value="Product Quality Feedback" <?= ($avon_outbound['call_type']=="Product Quality Feedback")?"selected":""?>>Product Quality Feedback</option>
													<option value="Proof of Payment Submitted" <?= ($avon_outbound['call_type']=="Proof of Payment Submitted")?"selected":""?>>Proof of Payment Submitted</option>
													<option value="Registration" <?= ($avon_outbound['call_type']=="Registration")?"selected":""?>>Registration</option>
													<option value="Registration Status" <?= ($avon_outbound['call_type']=="Registration Status")?"selected":""?>>Registration Status</option>
													<option value="Rep Account Inquiry - AREP" <?= ($avon_outbound['call_type']=="Rep Account Inquiry - AREP")?"selected":""?>>Rep Account Inquiry - AREP</option>
													<option value="REP Account Status" <?= ($avon_outbound['call_type']=="REP Account Status")?"selected":""?>>REP Account Status</option>
													<option value="REP Reinstatement" <?= ($avon_outbound['call_type']=="REP Reinstatement")?"selected":""?>>REP Reinstatement</option>
													<option value="Request for RA for Current SF payout" <?= ($avon_outbound['call_type']=="Request for RA for Current SF payout")?"selected":""?>>Request for RA for Current SF payout</option>
													<option value="Request for RA for Previous SF payout" <?= ($avon_outbound['call_type']=="Request for RA for Previous SF payout")?"selected":""?>>Request for RA for Previous SF payout</option>
													<option value="Request Ticket" <?= ($avon_outbound['call_type']=="Request Ticket")?"selected":""?>>Request Ticket</option>
													<option value="Request to Change or Update Info" <?= ($avon_outbound['call_type']=="Request to Change or Update Info")?"selected":""?>>Request to Change or Update Info</option>
													<option value="Request to Update or Change Info" <?= ($avon_outbound['call_type']=="Request to Update or Change Info")?"selected":""?>>Request to Update or Change Info</option>
													<option value="Solicitation or Marketing Offer" <?= ($avon_outbound['call_type']=="Solicitation or Marketing Offer")?"selected":""?>>Solicitation or Marketing Offer</option>
													<option value="Stock Availability" <?= ($avon_outbound['call_type']=="Stock Availability")?"selected":""?>>Stock Availability</option>
													<option value="Undelivered Order reflected on FD due" <?= ($avon_outbound['call_type']=="Undelivered Order reflected on FD due")?"selected":""?>>Undelivered Order reflected on FD due</option>
												</select>
											</td>
										</tr>
										<tr>
											<td colspan="2">Digital/Non Digital</td>
											<td colspan="2">
												<select class="form-control" name="data[digital_non_digital]" required>
                                                    <option value="Yes" <?= ($avon_outbound['digital_non_digital']=="Yes")?"selected":""?>>Yes</option>
                                                    <option value="No" <?= ($avon_outbound['digital_non_digital']=="No")?"selected":""?>>No</option>
                                                </select>
											</td>
											<td>Week</td>
											<td>
												<select class="form-control" name="data[week]" required>
                                                    <option value="1" <?= ($avon_outbound['week']=="1")?"selected":""?>>Week 1</option>
                                                    <option value="2" <?= ($avon_outbound['week']=="2")?"selected":""?>>Week 2</option>
                                                    <option value="3" <?= ($avon_outbound['week']=="3")?"selected":""?>>Week 3</option>
                                                    <option value="4" <?= ($avon_outbound['week']=="4")?"selected":""?>>Week 4</option>
                                                    <option value="5" <?= ($avon_outbound['week']=="5")?"selected":""?>>Week 5</option>
                                                </select>
											</td>
										</tr>
										<tr>
											<td>Audit Type:</td>
											<td>
												<select class="form-control" id="audit_type" name="data[audit_type]" required>
                                                    <option value="">-Select-</option>
                                                    <option value="CQ Audit" <?= ($avon_outbound['audit_type']=="CQ Audit")?"selected":"" ?>>CQ Audit</option>
                                                    <option value="BQ Audit" <?= ($avon_outbound['audit_type']=="BQ Audit")?"selected":"" ?>>BQ Audit</option>
                                                    <option value="Calibration" <?= ($avon_outbound['audit_type']=="Calibration")?"selected":"" ?>>Calibration</option>
                                                    <option value="Pre-Certificate Mock Call" <?= ($avon_outbound['audit_type']=="Pre-Certificate Mock Call")?"selected":"" ?>>Pre-Certificate Mock Call</option>
                                                    <option value="Certification Audit" <?= ($avon_outbound['audit_type']=="Certification Audit")?"selected":"" ?>>Certification Audit</option>
                                                    <option value="Operation Audit" <?= ($avon_outbound['audit_type']=="Operation Audit")?"selected":"" ?>>Operation Audit</option>
                                                    <option value="Trainer Audit"  <?= ($avon_outbound['audit_type']=="Trainer Audit")?"selected":"" ?>>Trainer Audit</option>
                                                </select>
											</td>
											<td class="auType">Auditor Type</td>
											<td class="auType">
												<select class="form-control" id="auditor_type" name="data[auditor_type]">
													<option value="<?= $avon_outbound['auditor_type']?>"><?= $avon_outbound['auditor_type']?></option>
													<option value="">-Select-</option>
													<option value="Master">Master</option>
													<option value="Regular">Regular</option>
												</select>
											</td>
											<td>VOC:</td>
											<td>
												<select class="form-control" id="voc" name="data[voc]" required>
													<option value="<?php echo $avon_outbound['voc'] ?>"><?php echo $avon_outbound['voc'] ?></option>
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
											<td><input type="text" readonly id="avon_earned_score" name="data[earned_score]" class="form-control" value="<?php echo $avon_outbound['earned_score'] ?>" /></td>
											<td style="font-weight:bold; font-size:16px; text-align:left">Possible Score</td>
											<td><input type="text" readonly id="avon_possible_score" name="data[possible_score]" class="form-control" value="<?php echo $avon_outbound['possible_score'] ?>" /></td>
											<td style="font-weight:bold; font-size:16px; text-align:right">Overall Score:</td>
											<td><input type="text" readonly id="avon_overall_score" name="data[overall_score]" class="form-control avonFatal" style="font-weight:bold" value="<?php echo $avon_outbound['overall_score'] ?>"></td>
										</tr>
										<tr class="eml" style="height:25px; font-weight:bold">
											<td>PARAMETER</td>
											<td colspan=2>SUB PARAMETER</td>
											<td>STATUS</td>
											<td colspan=2>REMARKS</td>
										</tr>
										<tr>
											<td class="eml" colspan="3">Opening Spiel</td>
											<td>
												<select class="form-control avon_point" name="data[opening_spiel]" required>
													<option value="">-Select-</option>
													<option avon_val=1 <?php echo $avon_outbound['opening_spiel'] == "Yes" ? "selected" : ""; ?> value="Yes">Yes</option>
													<option avon_val=0 <?php echo $avon_outbound['opening_spiel'] == "No" ? "selected" : ""; ?> value="No">No</option>
													<option avon_val=0 <?php echo $avon_outbound['opening_spiel'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt1]" class="form-control" value="<?php echo $avon_outbound['cmt1'] ?>"></td>
										</tr>
										<tr>
											<td class="eml" colspan="3">Disclaimer Spiel</td>
											<td>
												<select class="form-control avon_point" name="data[disclaimer_spiel]" required>
													<option value="">-Select-</option>
													<option avon_val=5 <?= $avon_outbound["disclaimer_spiel"] == "Yes" ? "selected" : "" ?> value="Yes">Yes</option>
													<option avon_val=0 <?= $avon_outbound["disclaimer_spiel"] == "No" ? "selected" : "" ?> value="No">No</option>
													<option avon_val=0 <?= $avon_outbound["disclaimer_spiel"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt2]" class="form-control" value="<?php echo $avon_outbound['cmt2'] ?>"></td>
										</tr>
										<tr>
											<td class="eml" colspan="3">Avon Security</td>
											<td>
												<select class="form-control avon_point" name="data[avon_security]" required>
													<option value="">-Select-</option>
													<option avon_val=5 <?= $avon_outbound["avon_security"] == "Yes" ? "selected" : "" ?> value="Yes">Yes</option>
													<option avon_val=0 <?= $avon_outbound["avon_security"] == "No" ? "selected" : "" ?> value="No">No</option>
													<option avon_val=0 <?= $avon_outbound["avon_security"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt3]" class="form-control" value="<?php echo $avon_outbound['cmt3'] ?>"></td>
										</tr>
										<tr>
											<td class="eml" colspan="3">Consent (If Applicable)</td>
											<td>
												<select class="form-control avon_point" name="data[consent_if_applicable]" required>
													<option value="">-Select-</option>
													<option avon_val=5 <?= $avon_outbound["consent_if_applicable"] == "Yes" ? "selected" : "" ?> value="Yes">Yes</option>
													<option avon_val=0 <?= $avon_outbound["consent_if_applicable"] == "No" ? "selected" : "" ?> value="No">No</option>
													<option avon_val=0 <?= $avon_outbound["consent_if_applicable"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt4]" class="form-control" value="<?php echo $avon_outbound['cmt4'] ?>"></td>
										</tr>
										<tr>
											<td colspan="3" class="eml">Enthusiasm</td>
											<td>
												<select class="form-control avon_point" name="data[enthusiasm]" required>
													<option value="">-Select-</option>
													<option avon_val=3 <?= $avon_outbound["enthusiasm"] == "Yes" ? "selected" : "" ?> value="Yes">Yes</option>
													<option avon_val=0 <?= $avon_outbound["enthusiasm"] == "No" ? "selected" : "" ?> value="No">No</option>
													<option avon_val=0 <?= $avon_outbound["enthusiasm"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt5]" class="form-control" value="<?php echo $avon_outbound['cmt5'] ?>"></td>
										</tr>
										<tr>
											<td colspan="3" class="eml">Listening Skills</td>
											<td>
												<select class="form-control avon_point" name="data[listening_skills]" required>
													<option value="">-Select-</option>
													<option avon_val=3 <?= $avon_outbound["listening_skills"] == "Yes" ? "selected" : "" ?> value="Yes">Yes</option>
													<option avon_val=0 <?= $avon_outbound["listening_skills"] == "No" ? "selected" : "" ?> value="No">No</option>
													<option avon_val=0 <?= $avon_outbound["listening_skills"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt6]" class="form-control" value="<?php echo $avon_outbound['cmt6'] ?>"></td>
										</tr>
										<tr>
											<td rowspan="5" class="eml">Customer Service</td>
											<td colspan="2">Interruption</td>
											<td>
												<select class="form-control avon_point" name="data[customer_service_interruption]" required>
													<option value="">-Select-</option>
													<option avon_val=3 <?= $avon_outbound["customer_service_interruption"] == "Yes" ? "selected" : "" ?> value="Yes">Yes</option>
													<option avon_val=0 <?= $avon_outbound["customer_service_interruption"] == "No" ? "selected" : "" ?> value="No">No</option>
													<option avon_val=0 <?= $avon_outbound["customer_service_interruption"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt7]" class="form-control" value="<?php echo $avon_outbound['cmt7'] ?>"></td>
										</tr>
										<tr>
											<td colspan="2">Polite Words/Professionalism</td>
											<td>
												<select class="form-control avon_point" name="data[customer_service_polite_words]" required>
													<option value="">-Select-</option>
													<option avon_val=3 <?= $avon_outbound["customer_service_polite_words"] == "Yes" ? "selected" : "" ?> value="Yes">Yes</option>
													<option avon_val=0 <?= $avon_outbound["customer_service_polite_words"] == "No" ? "selected" : "" ?> value="No">No</option>
													<option avon_val=0 <?= $avon_outbound["customer_service_polite_words"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt8]" class="form-control" value="<?php echo $avon_outbound['cmt8'] ?>"></td>
										</tr>
										<tr>
											<td colspan="2">Empathy</td>
											<td>
												<select class="form-control avon_point" name="data[customer_service_empathy]" required>
													<option value="">-Select-</option>
													<option avon_val=3 <?= $avon_outbound["customer_service_empathy"] == "Yes" ? "selected" : "" ?> value="Yes">Yes</option>
													<option avon_val=0 <?= $avon_outbound["customer_service_empathy"] == "No" ? "selected" : "" ?> value="No">No</option>
													<option avon_val=0 <?= $avon_outbound["customer_service_empathy"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt9]" class="form-control" value="<?php echo $avon_outbound['cmt9'] ?>"></td>
										</tr>
										<tr>
											<td colspan="2">Assurance</td>
											<td>
												<select class="form-control avon_point" name="data[customer_service_assurance]" required>
													<option value="">-Select-</option>
													<option avon_val=0 <?= $avon_outbound["customer_service_assurance"] == "Yes" ? "selected" : "" ?> value="Yes">Yes</option>
													<option avon_val=0 <?= $avon_outbound["customer_service_assurance"] == "No" ? "selected" : "" ?> value="No">No</option>
													<option avon_val=0 <?= $avon_outbound["customer_service_assurance"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt10]" class="form-control" value="<?php echo $avon_outbound['cmt10'] ?>"></td>
										</tr>
										<tr>
											<td colspan="2">Personalization</td>
											<td>
												<select class="form-control avon_point" name="data[customer_service_personalization]" required>
													<option value="">-Select-</option>
													<option avon_val=3 <?= $avon_outbound["customer_service_personalization"] == "Yes" ? "selected" : "" ?> value="Yes">Yes</option>
													<option avon_val=0 <?= $avon_outbound["customer_service_personalization"] == "No" ? "selected" : "" ?> value="No">No</option>
													<option avon_val=0 <?= $avon_outbound["customer_service_personalization"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt11]" class="form-control" value="<?php echo $avon_outbound['cmt11'] ?>"></td>
										</tr>
										<tr>
											<td class="eml" colspan="3">Hold Procedure</td>
											<td>
												<select class="form-control avon_point" name="data[hold_procedure]" required>
													<option value="">-Select-</option>
													<option avon_val=1 <?= $avon_outbound["hold_procedure"] == "Yes" ? "selected" : "" ?> value="Yes">Yes</option>
													<option avon_val=0 <?= $avon_outbound["hold_procedure"] == "No" ? "selected" : "" ?> value="No">No</option>
													<option avon_val=0 <?= $avon_outbound["hold_procedure"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt12]" class="form-control" value="<?php echo $avon_outbound['cmt12'] ?>"></td>
										</tr>
										<tr>
											<td colspan="3" class="eml">Dead Air</td>
											<td>
												<select class="form-control avon_point" name="data[dead_air]" required>
													<option value="">-Select-</option>
													<option avon_val=1 <?= $avon_outbound["dead_air"] == "Yes" ? "selected" : "" ?> value="Yes">Yes</option>
													<option avon_val=0 <?= $avon_outbound["dead_air"] == "No" ? "selected" : "" ?> value="No">No</option>
													<option avon_val=0 <?= $avon_outbound["dead_air"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt13]" class="form-control" value="<?php echo $avon_outbound['cmt13'] ?>"></td>
										</tr>
										<tr>
											<td rowspan="4" class="eml">Adherance to Recommended Spiels</td>
											<td colspan="2">Ghost Spiel</td>
											<td>
												<select class="form-control avon_point" name="data[ghost_spiel]" required>
													<option value="">-Select-</option>
													<option avon_val=0 <?= $avon_outbound["ghost_spiel"] == "Yes" ? "selected" : "" ?> value="Yes">Yes</option>
													<option avon_val=0 <?= $avon_outbound["ghost_spiel"] == "No" ? "selected" : "" ?> value="No">No</option>
													<option avon_val=0 <?= $avon_outbound["ghost_spiel"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt14]" class="form-control" value="<?php echo $avon_outbound['cmt14'] ?>"></td>
										</tr>
										<tr>
											<td colspan="2">Bad Line Spiel</td>
											<td>
												<select class="form-control avon_point" name="data[bad_line_spiel]" required>
													<option value="">-Select-</option>
													<option avon_val=0 <?= $avon_outbound["bad_line_spiel"] == "Yes" ? "selected" : "" ?> value="Yes">Yes</option>
													<option avon_val=0 <?= $avon_outbound["bad_line_spiel"] == "No" ? "selected" : "" ?> value="No">No</option>
													<option avon_val=0 <?= $avon_outbound["bad_line_spiel"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt15]" class="form-control" value="<?php echo $avon_outbound['cmt15'] ?>"></td>
										</tr>
										<tr>
											<td colspan="2">Profanity Spiel</td>
											<td>
												<select class="form-control avon_point" name="data[profanity_spiel]" required>
													<option value="">-Select-</option>
													<option avon_val=0 <?= $avon_outbound["profanity_spiel"] == "Yes" ? "selected" : "" ?> value="Yes">Yes</option>
													<option avon_val=0 <?= $avon_outbound["profanity_spiel"] == "No" ? "selected" : "" ?> value="No">No</option>
													<option avon_val=0 <?= $avon_outbound["profanity_spiel"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt16]" class="form-control" value="<?php echo $avon_outbound['cmt16'] ?>"></td>
										</tr>
										<tr>
											<td colspan="2">Others</td>
											<td>
												<select class="form-control avon_point" name="data[others]" required>
													<option value="">-Select-</option>
													<option avon_val=0 <?= $avon_outbound["others"] == "Yes" ? "selected" : "" ?> value="Yes">Yes</option>
													<option avon_val=0 <?= $avon_outbound["others"] == "No" ? "selected" : "" ?> value="No">No</option>
													<option avon_val=0 <?= $avon_outbound["others"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt17]" class="form-control" value="<?php echo $avon_outbound['cmt17'] ?>"></td>
										</tr>
										<tr>
											<td class="eml" rowspan="2">Information Shared</td>
											<td colspan="2">Incomplete Information</td>
											<td>
												<select class="form-control avon_point" name="data[information_shared_incomplete]" required>
													<option value="">-Select-</option>
													<option avon_val=5 <?= $avon_outbound["information_shared_incomplete"] == "Yes" ? "selected" : "" ?> value="Yes">Yes</option>
													<option avon_val=0 <?= $avon_outbound["information_shared_incomplete"] == "No" ? "selected" : "" ?> value="No">No</option>
													<option avon_val=0 <?= $avon_outbound["information_shared_incomplete"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt18]" class="form-control" value="<?php echo $avon_outbound['cmt18'] ?>"></td>
										</tr>
										<tr>
											<td colspan="2">Inaccurate Information</td>
											<td>
												<select class="form-control avon_point" name="data[information_shared_inaccurate]" required>
													<option value="">-Select-</option>
													<option avon_val=0 <?= $avon_outbound["information_shared_inaccurate"] == "Yes" ? "selected" : "" ?> value="Yes">Yes</option>
													<option avon_val=0 <?= $avon_outbound["information_shared_inaccurate"] == "No" ? "selected" : "" ?> value="No">No</option>
													<option avon_val=0 <?= $avon_outbound["information_shared_inaccurate"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt19]" class="form-control" value="<?php echo $avon_outbound['cmt19'] ?>"></td>
										</tr>
										<tr>
											<td class="eml" colspan="3">Ticket/Email Handling (If Applicable)</td>
											<td>
												<select class="form-control avon_point" name="data[ticket_email_handling_if_applicable]" required>
													<option value="">-Select-</option>
													<option avon_val=5 <?= $avon_outbound["ticket_email_handling_if_applicable"] == "Yes" ? "selected" : "" ?> value="Yes">Yes</option>
													<option avon_val=0 <?= $avon_outbound["ticket_email_handling_if_applicable"] == "No" ? "selected" : "" ?> value="No">No</option>
													<option avon_val=0 <?= $avon_outbound["ticket_email_handling_if_applicable"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt20]" class="form-control" value="<?php echo $avon_outbound['cmt20'] ?>"></td>
										</tr>
										<tr>
											<td colspan="3" class="eml">Disposition</td>
											<td>
												<select class="form-control avon_point" name="data[disposition]" required>
													<option value="">-Select-</option>
													<option avon_val=3 <?= $avon_outbound["disposition"] == "Yes" ? "selected" : "" ?> value="Yes">Yes</option>
													<option avon_val=0 <?= $avon_outbound["disposition"] == "No" ? "selected" : "" ?> value="No">No</option>
													<option avon_val=0 <?= $avon_outbound["disposition"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt21]" class="form-control" value="<?php echo $avon_outbound['cmt21'] ?>"></td>
										</tr>
										<tr>
											<td rowspan="4" class="eml">First Call Resolution</td>
											<td colspan="2">Information Shared</td>
											<td rowspan="4">
												<select class="form-control avon_point" name="data[first_call_resolution]" required>
													<option value="">-Select-</option>
													<option avon_val=5 <?= $avon_outbound["first_call_resolution"] == "Yes" ? "selected" : "" ?> value="Yes">Yes</option>
													<option avon_val=0 <?= $avon_outbound["first_call_resolution"] == "No" ? "selected" : "" ?> value="No">No</option>
													<option avon_val=0 <?= $avon_outbound["first_call_resolution"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
												</select>
											</td>
											<td rowspan="4" colspan="2">
												<input type="text" name="data[cmt22]" class="form-control" value="<?php echo $avon_outbound['cmt22'] ?>">
											</td>
										</tr>
										<tr>
											<td colspan="2">Failed to Escalate</td>
										</tr>
										<tr>
											<td colspan="2">Wrong Action</td>
										</tr>
										<tr>
											<td colspan="2">Agent Call Handling</td>
										</tr>
										<tr>
											<td colspan="3" class="eml">Closing Spiel</td>
											<td>
												<select class="form-control avon_point" name="data[closing_spiel]" required>
													<option value="">-Select-</option>
													<option avon_val=1 <?= $avon_outbound["closing_spiel"] == "Yes" ? "selected" : "" ?> value="Yes">Yes</option>
													<option avon_val=0 <?= $avon_outbound["closing_spiel"] == "No" ? "selected" : "" ?> value="No">No</option>
													<option avon_val=0 <?= $avon_outbound["closing_spiel"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt23]" class="form-control" value="<?php echo $avon_outbound['cmt23'] ?>"></td>
										</tr>
										<tr class="fatal">
											<td colspan="3" class="eml">Rudeness</td>
											<td>
												<select class="form-control avon_point avon_fatal" name="data[rudeness]" required>
													<option value="">-Select-</option>
													<option avon_val=0 <?= $avon_outbound["rudeness"] == "Yes" ? "selected" : "" ?> value="Yes">Yes</option>
													<option avon_val=0 <?= $avon_outbound["rudeness"] == "No" ? "selected" : "" ?> value="No">No</option>
													<option avon_val=0 <?= $avon_outbound["rudeness"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt24]" class="form-control" value="<?php echo $avon_outbound['cmt24'] ?>"></td>
										</tr>
										<tr>
											<td>Call Summary:</td>
											<td colspan=2><textarea class="form-control" name="data[call_summary]"><?php echo $avon_outbound['call_summary'] ?></textarea></td>
											<td>Feedback:</td>
											<td colspan=2><textarea class="form-control" name="data[feedback]"><?php echo $avon_outbound['feedback'] ?></textarea></td>
										</tr>
										<tr>
											<td colspan=2>Upload Files</td>
											<?php if ($avon_id == 0) { ?>
												<td colspan=4><input type="file" multiple class="form-control" id="attach_file" name="attach_file[]"></td>
												<?php } else {
												if ($avon_outbound['attach_file'] != '') { ?>
													<td colspan=4>
														<?php $attach_file = explode(",", $avon_outbound['attach_file']);
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
												<td colspan=4><?php echo $avon_outbound['agnt_fd_acpt'] ?></td>
											</tr>
											<tr>
												<td colspan=2 style="font-size:16px; font-weight:bold">Agent Review:</td>
												<td colspan=4><?php echo $avon_outbound['agent_rvw_note'] ?></td>
											</tr>
											<tr>
												<td colspan=2 style="font-size:16px; font-weight:bold">Management Review:</td>
												<td colspan=4><?php echo $avon_outbound['mgnt_rvw_note'] ?></td>
											</tr>
											<tr>
												<td colspan=2 style="font-size:16px; font-weight:bold">Client Review:</td>
												<td colspan=4><?php echo $avon_outbound['client_rvw_note'] ?></td>
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
												if (is_available_qa_feedback($avon_outbound['entry_date'], 72) == true) { ?>
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