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
		color:white;
	}
	.ui-datepicker .ui-datepicker-buttonpane button.ui-datepicker-current {
	 float: left;
	 display: none;
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
											if ($avon_data['entry_by'] != '') {
												$auditorName = $avon_data['auditor_name'];
											} else {
												$auditorName = $avon_data['client_name'];
											}
											$auditDate = mysql2mmddyy($avon_data['audit_date']);
											$clDate_val = mysql2mmddyy($avon_data['call_date']);
										}
										?>
										<tr>
											<td>Auditor Name: <span style="font-size:24px;color:red">*</span></td>
											<td><input type="text" class="form-control" value="<?= $auditorName; ?>" disabled></td>
											<td>Audit Date:<span style="font-size:24px;color:red">*</span></td>
											<td><input type="text" class="form-control" value="<?= $auditDate; ?>" disabled></td>
											<td>Call Date: <span style="font-size:24px;color:red">*</span></td>
											<td><input type="text" class="form-control" id="call_date" name="call_date" onkeydown="return false;" value="<?= $clDate_val; ?>" required></td>
										</tr>
										<tr>
											<td>Employee Name:<span style="font-size:24px;color:red">*</span></td>
											<td>
												<select class="form-control" id="agent_id" name="data[agent_id]" required>
													<option value="<?php echo $avon_data['agent_id'] ?>"><?php echo $avon_data['fname'] . " " . $avon_data['lname'] ?></option>
													
													<?php foreach ($agentName as $row) :  ?>
														<option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
													<?php endforeach; ?>
												</select>
											</td>
											<td>Employee ID:<span style="font-size:24px;color:red">*</span></td>
											<td><input type="text" class="form-control" id="fusion_id" value="<?php echo $avon_data['fusion_id'] ?>" readonly></td>
											<td>L1 Supervisor:<span style="font-size:24px;color:red">*</span></td>
											<td>
												<select class="form-control" id="tl_id" name="data[tl_id]" readonly>
													<option value="<?php echo $avon_data['tl_id'] ?>"><?php echo $avon_data['tl_name'] ?></option>
													<option value="">--Select--</option>
													<?php foreach ($tlname as $tl) : ?>
														<option value="<?php echo $tl['id']; ?>"><?php echo $tl['fname'] . " " . $tl['lname']; ?></option>
													<?php endforeach; ?>
												</select>
											</td>
										</tr>
										<tr>
											<td>LOB:<span style="font-size:24px;color:red">*</span></td>
											<td>
												<select class="form-control" id="" name="data[lob]" >
											
											<?php 
												if($avon_data['lob']!=''){
													?>
													<option value="<?php echo $avon_data['lob']; ?>"><?php echo $avon_data['lob']; ?></option>
													<?php
												}
											?>
											    <option value="">-Select-</option>
												<option value="Inbound">Inbound</option>
												<option value="Outbound">Outbound</option>
												<option value="Email">Email</option>
												<option value="Chat">Chat</option>
												<option value="CRM">CRM</option>
												<option value="SMS">SMS</option>
											
										</select>
											</td>
											<td>Call Duration:<span style="font-size:24px;color:red">*</span></td>
											<td><input type="text" class="form-control" onkeydown="return false;" id="call_duration" name="data[call_duration]" value="<?php echo $avon_data['call_duration']?>" required></td>

											<!-- <td><input type="text" class="form-control" onkeydown="return false;" id="call_duration" name="data[call_duration]" value="<?php echo $avon_data['call_duration'] ?>" required></td> -->
											<td>Call Type:<span style="font-size:24px;color:red">*</span></td>
											<td>
												<select class="form-control" name="data[call_type]" required>
													<option value="">-Select-</option>
													<option value="Available CL" <?= ($avon_data['call_type']=="Available CL")?"selected":""?>>Available CL</option>
													<option value="Avon Grow App issue" <?= ($avon_data['call_type']=="Avon Grow App issue")?"selected":""?>>Avon Grow App issue</option>
													<option value="Cannot Login" <?= ($avon_data['call_type']=="Cannot Login")?"selected":""?>>Cannot Login</option>
													<option value="Avon Shop related Concern" <?= ($avon_data['call_type']=="Avon Shop related Concern")?"selected":""?>>Avon Shop related Concern</option>
													<!-- <option value="Avon Shop related Concern">Avon Shop related Concern</option> -->
													<option value="Branch Contact Details" <?= ($avon_data['call_type']=="Branch Contact Details")?"selected":""?>>Branch Contact Details</option>
													<option value="Branch Contact Number" <?= ($avon_data['call_type']=="Branch Contact Number")?"selected":""?>>Branch Contact Number</option>
													<option value="Branch Store Hours" <?= ($avon_data['call_type']=="Branch Store Hours")?"selected":""?>>Branch Store Hours</option>
													<option value="Branch Transfer" <?= ($avon_data['call_type']=="Branch Transfer")?"selected":""?>>Branch Transfer</option>
													<option value="Cancel Order" <?= ($avon_data['call_type']=="Cancel Order")?"selected":""?>>Cancel Order</option>
													<option value="Cannot Access AE Link" <?= ($avon_data['call_type']=="Cannot Access AE Link")?"selected":""?>>Cannot Access AE Link</option>
													<option value="Cannot Order - 24 Hour rule" <?= ($avon_data['call_type']=="Cannot Order - 24 Hour rule")?"selected":""?>>Cannot Order - 24 Hour rule</option>
													<option value="Credit Line Increase" <?= ($avon_data['call_type']=="Credit Line Increase")?"selected":""?>>Credit Line Increase</option>
													<option value="Credit Line Initial Granting" <?= ($avon_data['call_type']=="Credit Line Initial Granting")?"selected":""?>>Credit Line Initial Granting</option>
													<option value="Defective Item for Return or Exchange" <?= ($avon_data['call_type']=="Defective Item for Return or Exchange")?"selected":""?>>Defective Item for Return or Exchange</option>
													<option value="Delivery Coverage" <?= ($avon_data['call_type']=="Delivery Coverage")?"selected":""?>>Delivery Coverage</option>
													<option value="Discontinued/Removed FD for Resign" <?= ($avon_data['call_type']=="Discontinued/Removed FD for Resign")?"selected":""?>>Discontinued/Removed FD for Resign</option>
													<option value="Discount not reflected in the Invoice" <?= ($avon_data['call_type']=="Discount not reflected in the Invoice")?"selected":""?>>Discount not reflected in the Invoice</option>
													<option value="Due Date" <?= ($avon_data['call_type']=="Due Date")?"selected":""?>>Due Date</option>
													<option value="Feedback" <?= ($avon_data['call_type']=="Feedback")?"selected":""?>>Feedback</option>
													<option value="Follow Up CRM" <?= ($avon_data['call_type']=="Follow Up CRM")?"selected":""?>>Follow Up CRM</option>
													<option value="How it works" <?= ($avon_data['call_type']=="How it works")?"selected":""?>>How it works</option>
													<option value="How to pay due amount" <?= ($avon_data['call_type']=="How to pay due amount")?"selected":""?>>How to pay due amount</option>
													<option value="How to purchase" <?= ($avon_data['call_type']=="How to purchase")?"selected":""?>>How to purchase</option>
													<option value="Incomplete Delivery" <?= ($avon_data['call_type']=="Incomplete Delivery")?"selected":""?>>Incomplete Delivery</option>
													<option value="Incorrect Delivery" <?= ($avon_data['call_type']=="Incorrect Delivery")?"selected":""?>>Incorrect Delivery</option>
													<option value="Inquiry Ticket" <?= ($avon_data['call_type']=="Inquiry Ticket")?"selected":""?>>Inquiry Ticket</option>
													<option value="No Delivery Yet" <?= ($avon_data['call_type']=="No Delivery Yet")?"selected":""?>>No Delivery Yet</option>
													<option value="Online Order Status" <?= ($avon_data['call_type']=="Online Order Status")?"selected":""?>>Online Order Status</option>
													<option value="Order Impersonation" <?= ($avon_data['call_type']=="Order Impersonation")?"selected":""?>>Order Impersonation</option>
													<option value="PDA" <?= ($avon_data['call_type']=="PDA")?"selected":""?>>PDA</option>
													<option value="POP Payment not posted" <?= ($avon_data['call_type']=="POP Payment not posted")?"selected":""?>>POP Payment not posted</option>
													<option value="Product Quality Feedback" <?= ($avon_data['call_type']=="Product Quality Feedback")?"selected":""?>>Product Quality Feedback</option>
													<option value="Proof of Payment Submitted" <?= ($avon_data['call_type']=="Proof of Payment Submitted")?"selected":""?>>Proof of Payment Submitted</option>
													<option value="Registration" <?= ($avon_data['call_type']=="Registration")?"selected":""?>>Registration</option>
													<option value="Registration Status" <?= ($avon_data['call_type']=="Registration Status")?"selected":""?>>Registration Status</option>
													<option value="Rep Account Inquiry - AREP" <?= ($avon_data['call_type']=="Rep Account Inquiry - AREP")?"selected":""?>>Rep Account Inquiry - AREP</option>
													<option value="REP Account Status" <?= ($avon_data['call_type']=="REP Account Status")?"selected":""?>>REP Account Status</option>
													<option value="REP Reinstatement" <?= ($avon_data['call_type']=="REP Reinstatement")?"selected":""?>>REP Reinstatement</option>
													<option value="Request for RA for Current SF payout" <?= ($avon_data['call_type']=="Request for RA for Current SF payout")?"selected":""?>>Request for RA for Current SF payout</option>
													<option value="Request for RA for Previous SF payout" <?= ($avon_data['call_type']=="Request for RA for Previous SF payout")?"selected":""?>>Request for RA for Previous SF payout</option>
													<option value="Request Ticket" <?= ($avon_data['call_type']=="Request Ticket")?"selected":""?>>Request Ticket</option>
													<option value="Request to Change or Update Info" <?= ($avon_data['call_type']=="Request to Change or Update Info")?"selected":""?>>Request to Change or Update Info</option>
													<option value="Request to Update or Change Info" <?= ($avon_data['call_type']=="Request to Update or Change Info")?"selected":""?>>Request to Update or Change Info</option>
													<option value="Solicitation or Marketing Offer" <?= ($avon_data['call_type']=="Solicitation or Marketing Offer")?"selected":""?>>Solicitation or Marketing Offer</option>
													<option value="Stock Availability" <?= ($avon_data['call_type']=="Stock Availability")?"selected":""?>>Stock Availability</option>
													<option value="Undelivered Order reflected on FD due" <?= ($avon_data['call_type']=="Undelivered Order reflected on FD due")?"selected":""?>>Undelivered Order reflected on FD due</option>
												</select>
											</td>
										</tr>
										<tr>
											<td>Digital/Non Digital <span style="font-size:24px;color:red">*</span></td>
											<td>
												<select class="form-control" name="data[digital_non_digital]" required>
													<option value="">-Select-</option>
                                                    <option value="Digital" <?= ($avon_data['digital_non_digital']=="Digital")?"selected":""?>>Digital</option>
                                                    <option value="Non Digital" <?= ($avon_data['digital_non_digital']=="Non Digital")?"selected":""?>>Non Digital</option>
                                                    <option value="NA" <?= ($avon_data['digital_non_digital']=="NA")?"selected":""?>>NA</option>
                                                </select>
											</td>
											<td>Week<span style="font-size:24px;color:red">*</span></td>
											<td>
												<select class="form-control" name="data[week]" required>
													<option value="">-Select-</option>
                                                    <option value="1" <?= ($avon_data['week']=="1")?"selected":""?>>Week 1</option>
                                                    <option value="2" <?= ($avon_data['week']=="2")?"selected":""?>>Week 2</option>
                                                    <option value="3" <?= ($avon_data['week']=="3")?"selected":""?>>Week 3</option>
                                                    <option value="4" <?= ($avon_data['week']=="4")?"selected":""?>>Week 4</option>
                                                    <option value="5" <?= ($avon_data['week']=="5")?"selected":""?>>Week 5</option>
                                                </select>
											</td>
										</tr>
										<tr>
											<td>Audit Type:<span style="font-size:24px;color:red">*</span></td>
											<td>
												<select class="form-control" id="audit_type" name="data[audit_type]" required>
                                                    <option value="">-Select-</option>
                                                    <option value="CQ Audit" <?= ($avon_data['audit_type']=="CQ Audit")?"selected":"" ?>>CQ Audit</option>
                                                    <option value="BQ Audit" <?= ($avon_data['audit_type']=="BQ Audit")?"selected":"" ?>>BQ Audit</option>
                                                    <option value="Calibration" <?= ($avon_data['audit_type']=="Calibration")?"selected":"" ?>>Calibration</option>
                                                    <option value="Pre-Certificate Mock Call" <?= ($avon_data['audit_type']=="Pre-Certificate Mock Call")?"selected":"" ?>>Pre-Certificate Mock Call</option>
                                                    <option value="Certification Audit" <?= ($avon_data['audit_type']=="Certification Audit")?"selected":"" ?>>Certification Audit</option>
                                                    <option value="Operation Audit" <?= ($avon_data['audit_type']=="Operation Audit")?"selected":"" ?>>Operation Audit</option>
                                                    <option value="Trainer Audit"  <?= ($avon_data['audit_type']=="Trainer Audit")?"selected":"" ?>>Trainer Audit</option>
                                                </select>
											</td>
											<td class="auType">Auditor Type</td>
											<td class="auType">
												<select class="form-control" id="auditor_type" name="data[auditor_type]">
                                                    
                                                    <option value="Master" <?= ($avon_data['auditor_type']=="Master")?"selected":"" ?>>Master</option>
                                                    <option value="Regular" <?= ($avon_data['auditor_type']=="Regular")?"selected":"" ?>>Regular</option>
                                                </select>
											</td>
											<td>VOC:<span style="font-size:24px;color:red">*</span></td>
											<td>
												<select class="form-control" id="voc" name="data[voc]" required>
													<?php 
													if($avon_data['voc']!=''){
														?>
														<option value="<?php echo $avon_data['voc'] ?>"><?php echo $avon_data['voc'] ?></option>
														<?php
													}
													?>
													
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
											<td><input type="text" readonly id="avon_earned_score" name="data[earned_score]" class="form-control" value="<?php echo $avon_data['earned_score'] ?>" /></td>
											<td style="font-weight:bold; font-size:16px; text-align:left">Possible Score</td>
											<td><input type="text" readonly id="avon_possible_score" name="data[possible_score]" class="form-control" value="<?php echo $avon_data['possible_score'] ?>" /></td>
											<td style="font-weight:bold; font-size:16px; text-align:right">Overall Score:</td>
											<td><input type="text" readonly id="avon_overall_score" name="data[overall_score]" class="form-control avonFatal" style="font-weight:bold" value="<?php echo $avon_data['overall_score'] ?>"></td>
										</tr>
										<tr class="eml" style="height:25px; font-weight:bold">
											<td>Critical Accuracy</td>
											<td>PARAMETER</td>
											<td colspan=2>SUB PARAMETER</td>
											<td>STATUS</td>
											<td colspan=2>REMARKS</td>
										</tr>

										<tr>
											<td class="eml" rowspan=6 style="font-weight:bold; background-color:#D7BDE2">Compliance Citical</td>
											<td class="eml" rowspan=2>Opening</td>
											<td colspan=2>Used Suggested Opening Spiel</td>
											<td>
												<select class="form-control avon_point compliance" name="data[suggested_opening_spiel]" required>
													
													<option avon_val=1 <?php echo $avon_data['suggested_opening_spiel'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option avon_val=0 <?php echo $avon_data['suggested_opening_spiel'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													<option avon_val=0 <?php echo $avon_data['suggested_opening_spiel'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt1]" class="form-control" value="<?php echo $avon_data['cmt1'] ?>"></td>
										</tr>
										<tr>
											<td colspan=2>SLA</td>
											<td>
												<select class="form-control avon_point compliance" name="data[sla]" required>
													
													<option avon_val=1 <?php echo $avon_data['sla'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option avon_val=0 <?php echo $avon_data['sla'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													<option avon_val=0 <?php echo $avon_data['sla'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt2]" class="form-control" value="<?php echo $avon_data['cmt2'] ?>"></td>
										</tr>

										<tr>
											<td class="eml" rowspan=3>Closing</td>
											<td colspan="2">Used Suggested Closing Spiel</td>
											<td>
												<select class="form-control avon_point compliance" name="data[suggested_closing_spiel]" required>
													
													<option avon_val=1 <?= $avon_data["suggested_closing_spiel"] == "Pass" ? "selected" : "" ?> value="Pass">Pass</option>
													<option avon_val=0 <?= $avon_data["suggested_closing_spiel"] == "Fail" ? "selected" : "" ?> value="Fail">Fail</option>
													<option avon_val=0 <?= $avon_data["suggested_closing_spiel"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt3]" class="form-control" value="<?php echo $avon_data['cmt3'] ?>"></td>
										</tr>

										<tr>
											<td colspan=2>Additional Assistance</td>
											<td>
												<select class="form-control avon_point compliance" name="data[additional_assistance]" required>
													
													<option avon_val=1 <?php echo $avon_data['additional_assistance'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option avon_val=0 <?php echo $avon_data['additional_assistance'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													<option avon_val=0 <?php echo $avon_data['additional_assistance'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt4]" class="form-control" value="<?php echo $avon_data['cmt4'] ?>"></td>
										</tr>

										<tr>
											<td colspan=2>Spiel Adherance</td>
											<td>
												<select class="form-control avon_point compliance" name="data[spiel_adherance]" required>
													
													<option avon_val=1 <?php echo $avon_data['spiel_adherance'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option avon_val=0 <?php echo $avon_data['spiel_adherance'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													<option avon_val=0 <?php echo $avon_data['spiel_adherance'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt5]" class="form-control" value="<?php echo $avon_data['cmt5'] ?>"></td>
										</tr>

										<tr>
											<td class="eml" rowspan=1>Disclaimer and Concent</td>
											<td  colspan="2">Did the agent use proper script</td>
											<td>
												<select class="form-control avon_point compliance" name="data[use_proper_script]" required>
													
													<option avon_val=2 <?= $avon_data["use_proper_script"] == "Pass" ? "selected" : "" ?> value="Pass">Pass</option>
													<option avon_val=0 <?= $avon_data["use_proper_script"] == "Fail" ? "selected" : "" ?> value="Fail">Fail</option>
													<option avon_val=0 <?= $avon_data["use_proper_script"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt6]" class="form-control" value="<?php echo $avon_data['cmt6'] ?>"></td>
										</tr>
										<tr>
											<td class="eml" rowspan=15 style="font-weight:bold; background-color:pink">Customer Critical</td>
											<td class="eml" rowspan=3>Acknowledgement, Empathy and Assurance</td>
											<td colspan="2">Did the agent acknowledge the issue of the customer?</td>
											<td>
												<select class="form-control avon_point customer" name="data[acknowledge_issue]" required>
												
													<option avon_val=1 <?= $avon_data["acknowledge_issue"] == "Pass" ? "selected" : "" ?> value="Pass">Pass</option>
													<option avon_val=0 <?= $avon_data["acknowledge_issue"] == "Fail" ? "selected" : "" ?> value="Fail">Fail</option>
													<option avon_val=0 <?= $avon_data["acknowledge_issue"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt7]" class="form-control" value="<?php echo $avon_data['cmt7'] ?>"></td>
										</tr>
										<tr>
											<td colspan="2">Did the agent provide empathy statement?(when necessary)</td>
											<td>
												<select class="form-control avon_point customer" name="data[empathy_statement]" required>
												
													<option avon_val=1 <?= $avon_data["empathy_statement"] == "Pass" ? "selected" : "" ?> value="Pass">Pass</option>
													<option avon_val=0 <?= $avon_data["empathy_statement"] == "Fail" ? "selected" : "" ?> value="Fail">Fail</option>
													<option avon_val=0 <?= $avon_data["empathy_statement"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt8]" class="form-control" value="<?php echo $avon_data['cmt8'] ?>"></td>
										</tr>
										<tr>
											<td colspan="2">Did the agent provide assurance to help the customer?</td>
											<td>
												<select class="form-control avon_point customer" name="data[provide_assurance]" required>
												
													<option avon_val=1 <?= $avon_data["provide_assurance"] == "Pass" ? "selected" : "" ?> value="Pass">Pass</option>
													<option avon_val=0 <?= $avon_data["provide_assurance"] == "Fail" ? "selected" : "" ?> value="Fail">Fail</option>
													<option avon_val=0 <?= $avon_data["provide_assurance"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt9]" class="form-control" value="<?php echo $avon_data['cmt9'] ?>"></td>
										</tr>

										<tr>
											<td class="eml" rowspan=3>First Time Resolution</td>
											<td colspan="2">Information Shared</td>
											<td>
												<select class="form-control avon_point customer" name="data[information_shared]" required>
												
													<option avon_val=1 <?= $avon_data["information_shared"] == "Pass" ? "selected" : "" ?> value="Pass">Pass</option>
													<option avon_val=0 <?= $avon_data["information_shared"] == "Fail" ? "selected" : "" ?> value="Fail">Fail</option>
													<option avon_val=0 <?= $avon_data["information_shared"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt10]" class="form-control" value="<?php echo $avon_data['cmt10'] ?>"></td>
										</tr>
										<tr>
											<td colspan="2">Probing question</td>
											<td>
												<select class="form-control avon_point customer" name="data[probing_question]" required>
												
													<option avon_val=1 <?= $avon_data["probing_question"] == "Pass" ? "selected" : "" ?> value="Pass">Pass</option>
													<option avon_val=0 <?= $avon_data["probing_question"] == "Fail" ? "selected" : "" ?> value="Fail">Fail</option>
													<option avon_val=0 <?= $avon_data["probing_question"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt11]" class="form-control" value="<?php echo $avon_data['cmt11'] ?>"></td>
										</tr>
										<tr>
											<td colspan="2">Failed to Escalate/Call back</td>
											<td>
												<select class="form-control avon_point customer" name="data[call_back]" required>
												
													<option avon_val=1 <?= $avon_data["call_back"] == "Pass" ? "selected" : "" ?> value="Pass">Pass</option>
													<option avon_val=0 <?= $avon_data["call_back"] == "Fail" ? "selected" : "" ?> value="Fail">Fail</option>
													<option avon_val=0 <?= $avon_data["call_back"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt12]" class="form-control" value="<?php echo $avon_data['cmt12'] ?>"></td>
										</tr>

										<tr>
											<td class="eml" rowspan=4>Communication Skills</td>
											<td colspan="2">Active Listening/Reading</td>
											<td>
												<select class="form-control avon_point customer" name="data[active_listening]" required>
											
													<option avon_val=1 <?= $avon_data["active_listening"] == "Pass" ? "selected" : "" ?> value="Pass">Pass</option>
													<option avon_val=0 <?= $avon_data["active_listening"] == "Fail" ? "selected" : "" ?> value="Fail">Fail</option>
													<option avon_val=0 <?= $avon_data["active_listening"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt13]" class="form-control" value="<?php echo $avon_data['cmt13'] ?>"></td>
										</tr>
										<tr>
											<td colspan="2">Interruption</td>
											<td>
												<select class="form-control avon_point customer" name="data[interruption]" required>
										
													<option avon_val=1 <?= $avon_data["interruption"] == "Pass" ? "selected" : "" ?> value="Pass">Pass</option>
													<option avon_val=0 <?= $avon_data["interruption"] == "Fail" ? "selected" : "" ?> value="Fail">Fail</option>
													<option avon_val=0 <?= $avon_data["interruption"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt14]" class="form-control" value="<?php echo $avon_data['cmt14'] ?>"></td>
										</tr>
										<tr>
											<td colspan="2">Dead Air and Proper Hold Technique</td>
											<td>
												<select class="form-control avon_point customer" name="data[dead_air]" required>
													<option avon_val=1 <?= $avon_data["dead_air"] == "Pass" ? "selected" : "" ?> value="Pass">Pass</option>
													<option avon_val=0 <?= $avon_data["dead_air"] == "Fail" ? "selected" : "" ?> value="Fail">Fail</option>
													<option avon_val=0 <?= $avon_data["dead_air"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt15]" class="form-control" value="<?php echo $avon_data['cmt15'] ?>"></td>
										</tr>
										<tr>
											<td colspan="2">Grammar usage/Technical Writing and Pronunciation/branding</td>
											<td>
												<select class="form-control avon_point customer" name="data[grammar_usage]" required>
													<option avon_val=1 <?= $avon_data["grammar_usage"] == "Pass" ? "selected" : "" ?> value="Pass">Pass</option>
													<option avon_val=0 <?= $avon_data["grammar_usage"] == "Fail" ? "selected" : "" ?> value="Fail">Fail</option>
													<option avon_val=0 <?= $avon_data["grammar_usage"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt16]" class="form-control" value="<?php echo $avon_data['cmt16'] ?>"></td>
										</tr>

										<tr>
											<td class="eml" rowspan=5>TOV</td>
											<td colspan="2">Professionalism (ZTP)</td>
											<td>
												<select class="form-control avon_point customer" name="data[professionalism]" required>
													<option avon_val=1 <?= $avon_data["professionalism"] == "Pass" ? "selected" : "" ?> value="Pass">Pass</option>
													<option avon_val=0 <?= $avon_data["professionalism"] == "Fail" ? "selected" : "" ?> value="Fail">Fail</option>
													<option avon_val=0 <?= $avon_data["professionalism"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt17]" class="form-control" value="<?php echo $avon_data['cmt17'] ?>"></td>
										</tr>
										<tr>
											<td colspan="2">Interact with intention</td>
											<td>
												<select class="form-control avon_point customer" name="data[interact_with_intention]" required>
													<option avon_val=1 <?= $avon_data["interact_with_intention"] == "Pass" ? "selected" : "" ?> value="Pass">Pass</option>
													<option avon_val=0 <?= $avon_data["interact_with_intention"] == "Fail" ? "selected" : "" ?> value="Fail">Fail</option>
													<option avon_val=0 <?= $avon_data["interact_with_intention"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt18]" class="form-control" value="<?php echo $avon_data['cmt18'] ?>"></td>
										</tr>
										<tr>
											<td colspan="2">Strong Ownership</td>
											<td>
												<select class="form-control avon_point customer" name="data[strong_ownership]" required>
													<option avon_val=1 <?= $avon_data["strong_ownership"] == "Pass" ? "selected" : "" ?> value="Pass">Pass</option>
													<option avon_val=0 <?= $avon_data["strong_ownership"] == "Fail" ? "selected" : "" ?> value="Fail">Fail</option>
													<option avon_val=0 <?= $avon_data["strong_ownership"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt19]" class="form-control" value="<?php echo $avon_data['cmt19'] ?>"></td>
										</tr>
										<tr>
											<td colspan="2">Enthusiasm</td>
											<td>
												<select class="form-control avon_point customer" name="data[enthusiasm]" required>
													<option avon_val=1 <?= $avon_data["enthusiasm"] == "Pass" ? "selected" : "" ?> value="Pass">Pass</option>
													<option avon_val=0 <?= $avon_data["enthusiasm"] == "Fail" ? "selected" : "" ?> value="Fail">Fail</option>
													<option avon_val=0 <?= $avon_data["enthusiasm"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt20]" class="form-control" value="<?php echo $avon_data['cmt20'] ?>"></td>
										</tr>
										<tr>
											<td colspan="2">Tailored Contact</td>
											<td>
												<select class="form-control avon_point customer" name="data[tailored_contact]" required>
													<option avon_val=1 <?= $avon_data["tailored_contact"] == "Pass" ? "selected" : "" ?> value="Pass">Pass</option>
													<option avon_val=0 <?= $avon_data["tailored_contact"] == "Fail" ? "selected" : "" ?> value="Fail">Fail</option>
													<option avon_val=0 <?= $avon_data["tailored_contact"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt21]" class="form-control" value="<?php echo $avon_data['cmt21'] ?>"></td>
										</tr>

										<tr>
											<td class="eml" rowspan=5 style="font-weight:bold; background-color:#d6bf91">Business Critical</td>
											<td class="eml" rowspan=1>Avon Security </td>
											<td  colspan="2">Avon Security </td>
											<td>
												<select class="form-control avon_point business" name="data[avon_security]" required>
													<option avon_val=4 <?= $avon_data["avon_security"] == "Pass" ? "selected" : "" ?> value="Pass">Pass</option>
													<option avon_val=0 <?= $avon_data["avon_security"] == "Fail" ? "selected" : "" ?> value="Fail">Fail</option>
													<option avon_val=0 <?= $avon_data["avon_security"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt22]" class="form-control" value="<?php echo $avon_data['cmt22'] ?>"></td>
										</tr>
										<tr>
											<td class="eml" rowspan=3>Ticket/Email Handling (if Applicable)</td>
											<td colspan="2">Send to the right approver </td>
											<td>
												<select class="form-control avon_point business" name="data[send_right_approver]" required>
													<option avon_val=1 <?= $avon_data["send_right_approver"] == "Pass" ? "selected" : "" ?> value="Pass">Pass</option>
													<option avon_val=0 <?= $avon_data["send_right_approver"] == "Fail" ? "selected" : "" ?> value="Fail">Fail</option>
													<option avon_val=0 <?= $avon_data["send_right_approver"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt23]" class="form-control" value="<?php echo $avon_data['cmt23'] ?>"></td>
										</tr>
										<tr>
											<td colspan="2">Efficiency of Action</td>
											<td>
												<select class="form-control avon_point business" name="data[efficiency_of_action]" required>
													<option avon_val=1 <?= $avon_data["efficiency_of_action"] == "Pass" ? "selected" : "" ?> value="Pass">Pass</option>
													<option avon_val=0 <?= $avon_data["efficiency_of_action"] == "Fail" ? "selected" : "" ?> value="Fail">Fail</option>
													<option avon_val=0 <?= $avon_data["efficiency_of_action"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt24]" class="form-control" value="<?php echo $avon_data['cmt24'] ?>"></td>
										</tr>
										<tr>
											<td colspan="2">Documentation</td>
											<td>
												<select class="form-control avon_point business" name="data[documentation]" required>
													<option avon_val=1 <?= $avon_data["documentation"] == "Pass" ? "selected" : "" ?> value="Pass">Pass</option>
													<option avon_val=0 <?= $avon_data["documentation"] == "Fail" ? "selected" : "" ?> value="Fail">Fail</option>
													<option avon_val=0 <?= $avon_data["documentation"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt25]" class="form-control" value="<?php echo $avon_data['cmt25'] ?>"></td>
										</tr>


										<tr>
											<td class="eml" rowspan=1>Disposition / Correct Tagging</td>
											<td colspan="2">Use proper disposition and tagging</td>
											<td>
												<select class="form-control avon_point business" name="data[proper_disposition_tagging]" required>
													<option avon_val=4 <?= $avon_data["proper_disposition_tagging"] == "Pass" ? "selected" : "" ?> value="Pass">Pass</option>
													<option avon_val=0 <?= $avon_data["proper_disposition_tagging"] == "Fail" ? "selected" : "" ?> value="Fail">Fail</option>
													<option avon_val=0 <?= $avon_data["proper_disposition_tagging"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt26]" class="form-control" value="<?php echo $avon_data['cmt26'] ?>"></td>
										</tr>
										<tr class="fatal">
											<td class="eml" rowspan=2 style="font-weight:bold; background-color:red">FATAL ERROR</td>
											<td class="eml" rowspan=1>CALL/EMAIL/SMS/CHAT/CRM AVOIDANCE</td>
											<td colspan="2">Did the agent resolved the concerns within the interactions?</td>
											<td>
												<select class="form-control avon_point avon_fatal" name="data[resolved_the_concerns]" required>
													<option avon_val=0 <?= $avon_data["resolved_the_concerns"] == "Pass" ? "selected" : "" ?> value="Pass">Pass</option>
													<option avon_val=0 <?= $avon_data["resolved_the_concerns"] == "Fail" ? "selected" : "" ?> value="Fail">Fail</option>
													<option avon_val=0 <?= $avon_data["resolved_the_concerns"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt27]" class="form-control" value="<?php echo $avon_data['cmt27'] ?>"></td>
										</tr>
										<tr class="fatal">
											<td class="eml" rowspan=1>Email/SMS/ First response/acknowledge</td>
											<td colspan="2">Did the agent used first response?</td>
											<td>
												<select class="form-control avon_point avon_fatal" name="data[first_response]" required>
													<option avon_val=0 <?= $avon_data["first_response"] == "Pass" ? "selected" : "" ?> value="Pass">Pass</option>
													<option avon_val=0 <?= $avon_data["first_response"] == "Fail" ? "selected" : "" ?> value="Fail">Fail</option>
													<option avon_val=0 <?= $avon_data["first_response"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt28]" class="form-control" value="<?php echo $avon_data['cmt28'] ?>"></td>
										</tr>

									<tr style="font-weight:bold; background-color:#D7BDE2"><td colspan=2>Customer Score</td><td colspan=2>Business Score</td><td colspan=2>Compliance Score</td></tr>
									<tr style="font-weight:bold; background-color:#D7BDE2">
										<td>Earned Point:</td><td ><input type="text" readonly class="form-control" id="customer_earned_score" name="data[customer_earned_score]" value="<?php echo $avon_data['customer_earned_score'] ?>"></td>
										<td>Earned Point:</td><td ><input type="text" readonly class="form-control" id="business_earned_score" name="data[business_earned_score]" value="<?php echo $avon_data['business_earned_score'] ?>"></td>
										<td>Earned Point:</td><td ><input type="text" readonly class="form-control" id="compliance_earned_score" name="data[compliance_earned_score]" value="<?php echo $avon_data['compliance_earned_score'] ?>"></td>
									</tr>
									<tr style="font-weight:bold; background-color:#D7BDE2">
										<td>Possible Point:</td><td ><input type="text" readonly class="form-control" id="customer_possible_score" name="data[customer_possible_score]" value="<?php echo $avon_data['customer_possible_score'] ?>"></td>
										<td>Possible Point:</td><td ><input type="text" readonly class="form-control" id="business_possible_score" name="data[business_possible_score]" value="<?php echo $avon_data['business_possible_score'] ?>"></td>
										<td>Possible Point:</td><td ><input type="text" readonly class="form-control" id="compliance_possible_score" name="data[compliance_possible_score]" value="<?php echo $avon_data['compliance_possible_score'] ?>"></td>
									</tr>
									<tr style="font-weight:bold; background-color:#D7BDE2">
										<td>Overall Percentage:</td><td ><input type="text" readonly class="form-control" id="customer_overall_score" name="data[customer_overall_score]" value="<?php echo $avon_data['customer_overall_score'] ?>"></td>
										<td>Overall Percentage:</td><td ><input type="text" readonly class="form-control" id="business_overall_score" name="data[business_overall_score]" value="<?php echo $avon_data['business_overall_score'] ?>"></td>
										<td>Overall Percentage:</td><td ><input type="text" readonly class="form-control" id="compliance_overall_score" name="data[compliance_overall_score]" value="<?php echo $avon_data['compliance_overall_score'] ?>"></td>
									</tr>
										<tr>
											<td>Call Summary:</td>
											<td colspan=2><textarea class="form-control" name="data[call_summary]"><?php echo $avon_data['call_summary'] ?></textarea></td>
											<td>Feedback:</td>
											<td colspan=2><textarea class="form-control" name="data[feedback]"><?php echo $avon_data['feedback'] ?></textarea></td>
										</tr>
										<tr>
											<td colspan=2>Upload Files (mp3|avi|mp4|wmv|wav)</td>
											<?php if ($avon_id == 0) { ?>
												<td colspan=4><input type="file" multiple class="form-control" data-file_types="audio/*,video/*" id="attach_file" name="attach_file[]"></td>
												<?php } else {
												if ($avon_data['attach_file'] != '') { ?>
													<td colspan=4>
														<?php $attach_file = explode(",", $avon_data['attach_file']);
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
												<td colspan=4><?php echo $avon_data['agnt_fd_acpt'] ?></td>
											</tr>
											<tr>
												<td colspan=2 style="font-size:16px; font-weight:bold">Agent Review:</td>
												<td colspan=4><?php echo $avon_data['agent_rvw_note'] ?></td>
											</tr>
											<tr>
												<td colspan=2 style="font-size:16px; font-weight:bold">Management Review:</td>
												<td colspan=4><?php echo $avon_data['mgnt_rvw_note'] ?></td>
											</tr>
											<tr>
												<td colspan=2 style="font-size:16px; font-weight:bold">Client Review:</td>
												<td colspan=4><?php echo $avon_data['client_rvw_note'] ?></td>
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
												if (is_available_qa_feedback($avon_data['entry_date'], 72) == true) { ?>
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