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

<?php if ($hcci_id != 0) {
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
											<td colspan="10" id="theader" style="font-size:40px">HCCI [CORE V2]</td>
											<input type="hidden" name="audit_start_time" value="<?php echo CurrMySqlDate(); ?>">
										</tr>
										<?php
										if ($hcci_id == 0) {
											$auditorName = get_username();
											//$auditDate = CurrDateMDY();
											$auditDate =  CurrDateTimeMDY();
											$clDate_val = '';
										} else {
											if ($avon_data['entry_by'] != '') {
												$auditorName = $avon_data['auditor_name'];
											} else {
												$auditorName = $avon_data['client_name'];
											}
											$clDate_val = mysql2mmddyySls($avon_data['call_date']);
										}
										?>
										<tr>
											<td>Auditor Name:</td>
											<td><input type="text" class="form-control" value="<?= $auditorName; ?>" disabled></td>
											<td>Audit Date:</td>
											<td><input type="text" class="form-control" value="<?= CurrDateTimeMDY() ?>" disabled></td>
											<td>Transaction Date:<span style="font-size:24px;color:red">*</span></td>
											<td>
												<input type="text" id="call_date" name="call_date"  onkeydown="return false;" value="<?php echo $clDate_val; ?>" max="<?php echo date("Y-m-d"); ?>" class="form-control" required>
											</td>
										</tr>
										<tr>
											<td>Agent Name:<span style="font-size:24px;color:red">*</span></td>
											<td>
												<select class="form-control" id="agent_id" name="data[agent_id]" required>
													<option value="<?php echo $avon_data['agent_id'] ?>"><?php echo $avon_data['fname'] . " " . $avon_data['lname'] ?></option>
													
													<?php foreach ($agentName as $row) :  ?>
														<option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
													<?php endforeach; ?>
												</select>
											</td>
											<td>Employee ID:</td>
											<td><input type="text" class="form-control" id="fusion_id" required value="<?php echo $avon_data['fusion_id'] ?>" readonly></td>
											<td> TL Name:<span style="font-size:24px;color:red">*</span></td>
											<td>
												<!--<select class="form-control" id="tl_id" name="data[tl_id]" readonly>
													<?php 
													if($avon_data['tl_id']!=''){
														?>
														<option value="<?php echo $avon_data['tl_id'] ?>"><?php echo $avon_data['tl_name'] ?></option>
														<?php 

													}else{
														?>
														<option value="">--Select--</option>
														<?php foreach ($tlname as $tl) : ?>
														<option value="<?php echo $tl['id']; ?>"><?php echo $tl['fname'] . " " . $tl['lname']; ?></option>
													<?php endforeach; ?>
														<?php
													}
													?>
												</select>-->
								
												<input type="text" class="form-control" id="tl_name" required value="<?php echo $avon_data['tl_name'] ?>" readonly>
												<input type="hidden" class="form-control" id="tl_id" name="data[tl_id]" value="<?php echo $avon_data['tl_id'] ?>" required>
											</td>
										</tr>
										<tr>
											<td>LOB/Channel:<span style="font-size:24px;color:red">*</span></td>
											<td>
												<select class="form-control" name="data[lob]" required>
													<option value="">-Select-</option>
													<option value="Inbound" <?= ($avon_data['lob']=="Inbound")?"selected":"" ?>>Inbound</option>
													<option value="Outbound" <?= ($avon_data['lob']=="Outbound")?"selected":"" ?>>Outbound</option>
													<option value="Email" <?= ($avon_data['lob']=="Email")?"selected":"" ?>>Email</option>
													<option value="Chat" <?= ($avon_data['lob']=="Chat")?"selected":"" ?>>Chat</option>
													<option value="CRM" <?= ($avon_data['lob']=="CRM")?"selected":"" ?>>CRM</option>
													<option value="SMS" <?= ($avon_data['lob']=="SMS")?"selected":"" ?>>SMS</option>
												</select>
											</td>
											<td>AHT:<span style="font-size:24px;color:red">*</span></td>
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
											<!--<td>Digital/Non Digital <span style="font-size:24px;color:red">*</span></td>
											<td>
												<select class="form-control" name="data[digital_non_digital]" required>
													<option value="">-Select-</option>
                                                    <option value="Digital" <?= ($avon_data['digital_non_digital']=="Digital")?"selected":""?>>Digital</option>
                                                    <option value="Non Digital" <?= ($avon_data['digital_non_digital']=="Non Digital")?"selected":""?>>Non Digital</option>
                                                    <option value="NA" <?= ($avon_data['digital_non_digital']=="NA")?"selected":""?>>NA</option>
                                                </select>
											</td>-->
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
											<td>VOC:<span style="font-size:24px;color:red">*</span></td>
											<td>
												<select class="form-control" id="voc" name="data[voc]" required>
													
													<option value="">-Select-</option>
													<option value="1"  <?= ($avon_data['voc']=="1")?"selected":"" ?>>1</option>
													<option value="2"  <?= ($avon_data['voc']=="2")?"selected":"" ?>>2</option>
													<option value="3"  <?= ($avon_data['voc']=="3")?"selected":"" ?>>3</option>
													<option value="4"  <?= ($avon_data['voc']=="4")?"selected":"" ?>>4</option>
													<option value="5"  <?= ($avon_data['voc']=="5")?"selected":"" ?>>5</option>
													<option value="6"  <?= ($avon_data['voc']=="6")?"selected":"" ?>>6</option>
													<option value="7"  <?= ($avon_data['voc']=="7")?"selected":"" ?>>7</option>
													<option value="8"  <?= ($avon_data['voc']=="8")?"selected":"" ?>>8</option>
													<option value="9"  <?= ($avon_data['voc']=="9")?"selected":"" ?>>9</option>
													<option value="10"  <?= ($avon_data['voc']=="10")?"selected":"" ?>>10</option>
												</select>
											</td>
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
										</tr>
										<tr>
											<td class="auType">Auditor Type<span style="font-size:24px;color:red">*</span></td>
											<td class="auType">
												<select class="form-control" id="auditor_type" name="data[auditor_type]">
                                                    
                                                    <option value="Master" <?= ($avon_data['auditor_type']=="Master")?"selected":"" ?>>Master</option>
                                                    <option value="Regular" <?= ($avon_data['auditor_type']=="Regular")?"selected":"" ?>>Regular</option>
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
											
											<td>CATEGORY</td>
											<td>SUB CATEGORY</td>
											<td colspan=2>PARAMETER</td>
											<td>WEIGHTAGE</td>
											<td>STATUS</td>
											<td colspan=2>REMARKS</td>
											<td>Critical Accuracy</td>
										</tr>

										<tr>
											
											<td class="eml" rowspan=3>Issue Identification</td>
											<td>Brand</td>
											<td colspan=2>Did the agent use the correct brand? The agent correctly identified as Angi, and if applicable, the partnership the customer booked through.</td>
											<td>5</td>
											<td>
												<select class="form-control avon_point business" name="data[brand]" required>
													
													<option hcci_val=5 <?php echo $avon_data['brand'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option hcci_val=0 <?php echo $avon_data['brand'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt1]" class="form-control" value="<?php echo $avon_data['cmt1'] ?>"></td>
											<td style="font-weight:bold; background-color:#D7BDE2">Business Citical</td>
										</tr>
										<tr>
											
											<td>Issue Identification</td>
											<td colspan=2>Did the agent correctly identify the issue(s) or, if unclear, did they ask the right kind of clarifying question? "Yes" here means the agent completely understood every part of the issue(s), including the root cause of the issue(s), and identified when multiple issues were raised by the customer. If the agent misunderstood some of the issue(s) or all of the issue(s) they should be scored "No."</td>
											<td>25</td>
											<td>
												<select class="form-control avon_point customer" name="data[brand]" required>
													
													<option hcci_val=25 <?php echo $avon_data['brand'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option hcci_val=0 <?php echo $avon_data['brand'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt1]" class="form-control" value="<?php echo $avon_data['cmt2'] ?>"></td>
											<td style="font-weight:bold; background-color:#D7BDE2">Customer Citical</td>
										</tr>
										<tr>
											
											<td>Issue Resolution</td>
											<td colspan=2>Did the agent resolve the issue(s) in a manner that does not require additional outreach from the customer? (One Call Resolution) "Yes" here means all of the customer's issues were addressed and don't require any additional assistance from our team.</td>
											<td>25</td>
											<td>
												<select class="form-control avon_point customer" name="data[brand]" required>
													
													<option hcci_val=25 <?php echo $avon_data['brand'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option hcci_val=0 <?php echo $avon_data['brand'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt1]" class="form-control" value="<?php echo $avon_data['cmt3'] ?>"></td>
											<td style="font-weight:bold; background-color:#D7BDE2">Customer Citical</td>
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
											<td colspan=2>Upload Files (avi|mp4|3gp|mpeg|mpg|mov|mp3|flv|wmv|mkv|wav)</td>
											<?php if ($hcci_id == 0) { ?>
												<td colspan=4><input type="file" multiple class="form-control" data-file_types="audio/*,video/*" id="attach_file" name="attach_file[]"></td>
												<?php } else {
												if ($avon_data['attach_file'] != '') { ?>
													<td colspan=4>
														<input type="file" multiple class="form-control" data-file_types="audio/*,video/*" id="attach_file" name="attach_file[]">
														<?php $attach_file = explode(",", $avon_data['attach_file']);
														foreach ($attach_file as $mp) { ?>
															<audio controls='' style="background-color:#607F93">
																<source src="<?php echo base_url(); ?>qa_files/qa_avon/<?php echo $mp; ?>" type="audio/ogg">
																<source src="<?php echo base_url(); ?>qa_files/qa_avon/<?php echo $mp; ?>" type="audio/mpeg">
															</audio> </br>
														<?php } ?>
													</td>
											<?php } else {
													echo '<td colspan=6>
													<input type="file" multiple class="form-control" data-file_types="audio/*,video/*" id="attach_file" name="attach_file[]">
													<b>No Files</b></td>';
												}
											} ?>
										</tr>

										<?php if ($hcci_id != 0) { ?>
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
												<td colspan=2 style="font-size:16px">Your Review<span style="font-size:24px;color:red">*</span></td>
												<td colspan=4><textarea class="form-control1" style="width:100%" id="note" name="note" required></textarea></td>
											</tr>
										<?php } ?>

										<?php
										if ($hcci_id == 0) {
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