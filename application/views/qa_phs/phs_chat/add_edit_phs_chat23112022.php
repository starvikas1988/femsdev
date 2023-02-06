<style>
.table > tbody > tr > td{
	text-align: center;
	font-size:13px;
}

#theader{
	font-size:20px;
	font-weight:bold;
	background-color:#95A5A6;
}

.eml1{
	font-weight:bold;
	background-color:#F8C471;
}

.prm1{
	font-weight:bold;
	background-color:#5DADE2;
}
</style>

<?php if($chat_id!=0){
if(is_access_qa_edit_feedback()==false){ ?>
	<style>
		.form-control{
			pointer-events:none;
			background-color:#D5DBDB;
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
										<td colspan="6" id="theader" style="font-size:40px">Premier Health Solutions [Chat]</td>
										<input type="hidden" name="audit_start_time" value="<?php echo CurrMySqlDate(); ?>">
									</tr>
									<?php
										if($chat_id==0){
											$auditorName = get_username();
											$auditDate = CurrDateMDY();
											$clDate_val='';
										}else{
											if($phs_chat['entry_by']!=''){
												$auditorName = $phs_chat['auditor_name'];
											}else{
												$auditorName = $phs_chat['client_name'];
											}
											$auditDate = mysql2mmddyy($phs_chat['audit_date']);
											$clDate_val = mysql2mmddyy($phs_chat['call_date']);
										}
									?>
									<tr>
										<td>Auditor Name:</td>
										<td><input type="text" class="form-control" value="<?php echo $auditorName; ?>" disabled></td>
										<td>Audit Date:</td>
										<td><input type="text" class="form-control" value="<?php echo $auditDate; ?>" disabled></td>
										<td>Chat Date:</td>
										<td><input type="text" class="form-control" id="call_date" name="call_date" value="<?php echo $clDate_val; ?>" required></td>
									</tr>
									<tr>
										<td>Agent:</td>
										<td>
											<select class="form-control" id="agent_id" name="data[agent_id]" required >
												<option value="<?php echo $phs_chat['agent_id'] ?>"><?php echo $phs_chat['fname']." ".$phs_chat['lname'] ?></option>
												<option value="">-Select-</option>
												<?php foreach($agentName as $row):  ?>
													<option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
												<?php endforeach; ?>
											</select>
										</td>
										<td>Fusion ID:</td>
										<td><input type="text" class="form-control" id="fusion_id" value="<?php echo $phs_chat['fusion_id'] ?>" readonly ></td>
										<td>L1 Supervisor:</td>
										<td>
											<select class="form-control" id="tl_id" name="data[tl_id]" readonly>
												<option value="<?php echo $phs_chat['tl_id'] ?>"><?php echo $phs_chat['tl_name'] ?></option>
												<option value="">--Select--</option>
												<?php foreach($tlname as $tl): ?>
													<option value="<?php echo $tl['id']; ?>"><?php echo $tl['fname']." ".$tl['lname']; ?></option>
												<?php endforeach; ?>	
											</select>
										</td>
									</tr>
									<tr>
										<td>Channel:</td>
										<td><input type="text" class="form-control" name="data[channel]" value="<?php echo $phs_chat['channel'] ?>" required ></td>
										<td>File Number:</td>
										<td><input type="text" class="form-control" name="data[file_no]" value="<?php echo $phs_chat['file_no'] ?>" required ></td>
										<td>Time stamp/ Link:</td>
										<td><input type="text" class="form-control" name="data[link]" value="<?php echo $phs_chat['link'] ?>" required ></td>
									</tr>
									<tr>
										<td>ACPT:</td>
										<td>
											<select class="form-control" name="data[acpt]" required>
												<option value="<?php echo $phs_chat['acpt'] ?>"><?php echo $phs_chat['acpt'] ?></option>
												<option value="">-Select-</option>
												<option value="Agent">Agent</option>
												<option value="Customer">Customer</option>
												<option value="Process">Process</option>
												<option value="Technology">Technology</option>
											</select>
										</td>
										<td>ZTP:</td>
										<td>
											<select class="form-control" name="data[ztp]" required>
												<option value="<?php echo $phs_chat['ztp'] ?>"><?php echo $phs_chat['ztp'] ?></option>
												<option value="">-Select-</option>
												<option value="Yes">Yes</option>
												<option value="No">No</option>
											</select>
										</td>
										<td>Member ID:</td>
										<td><input type="text" class="form-control" name="data[member_id]" value="<?php echo $phs_chat['member_id'] ?>" required ></td>
									</tr>
									<tr>
										<td>Call Type:</td>
										<td>
											<select class="form-control" name="data[call_type]" required>
												<option value="<?php echo $phs_chat['call_type'] ?>"><?php echo $phs_chat['call_type'] ?></option>
												<option value="">-Select-</option>
												<option value="Cancellation">Cancellation</option>
												<option value="Refund">Refund</option>
												<option value="Benefits and Eligibility">Benefits and Eligibility</option>
												<option value="Billing">Billing</option>
												<option value="Member Portal">Member Portal</option>
												<option value="Claims">Claims</option>
												<option value="Member Portal">Member Portal</option>
												<option value="General Inquiry">General Inquiry</option>
											</select>
										</td>
										<td>Caller Type:</td>
										<td>
											<select class="form-control" name="data[caller_type]" required>
												<option value="<?php echo $phs_chat['caller_type'] ?>"><?php echo $phs_chat['caller_type'] ?></option>
												<option value="">-Select-</option>
												<option value="Member">Member</option>
												<option value="Provider">Provider</option>
											</select>
										</td>
										<td>PHS Product/Agency:</td>
										<td>
											<select class="form-control" name="data[product_agency]" required>
												<option value="<?php echo $phs_chat['product_agency'] ?>"><?php echo $phs_chat['product_agency'] ?></option>
												<option value="">-Select-</option>
												<option value="Health Depot">Health Depot</option>
												<option value="AWA">AWA</option>
												<option value="IMG">IMG</option>
												<option value="SafeGuard Health">SafeGuard Health</option>
											</select>
										</td>
									</tr>
									<tr>
										<td>Audit Type:</td>
										<td>
											<select class="form-control" id="audit_type" name="data[audit_type]" required>
												<option value="<?php echo $phs_chat['audit_type'] ?>"><?php echo $phs_chat['audit_type'] ?></option>
												<option value="">-Select-</option>
												<option value="CQ Audit">CQ Audit</option>
												<option value="BQ Audit">BQ Audit</option>
												<option value="Calibration">Calibration</option>
												<option value="Pre-Certificate Mock Call">Pre-Certificate Mock Call</option>
												<option value="Certification Audit">Certification Audit</option>
												<option value="Operation Audit">Operation Audit</option>
												<option value="Trainer Audit">Trainer Audit</option>
												<option value="Normal">Normal</option>
												<option value="Escalation">Escalation</option>
												<option value="WOW Call">WOW Call</option>
											</select>
										</td>
										<td class="auType">Auditor Type</td>
										<td class="auType">
											<select class="form-control" id="auditor_type" name="data[auditor_type]">
												<option value="">-Select-</option>
												<option value="Master">Master</option>
												<option value="Regular">Regular</option>
											</select>
										</td>
										<td>VOC:</td>
										<td>
											<select class="form-control" id="voc" name="data[voc]" required>
												<option value="<?php echo $phs_chat['voc'] ?>"><?php echo $phs_chat['voc'] ?></option>
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
										<td>Language:</td>
										<td>
											<select class="form-control" name="data[language]" required>
												<option value="">-Select-</option>
												<option <?php echo $phs_chat['language'] == "English"?"selected":"";?> value="English">English</option>
												<option <?php echo $phs_chat['language'] == "Spanish"?"selected":"";?> value="Spanish">Spanish</option>
											</select>
										</td>
									</tr>
									<tr>
										<td style="font-weight:bold; font-size:16px">Possible Score:</td>
										<td><input type="text" readonly id="phs_chatemail_possible" name="data[possible_score]" class="form-control" style="font-weight:bold" value="<?php echo $phs_chat['possible_score'] ?>"></td>
										<td style="font-weight:bold; font-size:16px">Earned Score:</td>
										<td><input type="text" readonly id="phs_chatemail_earned" name="data[earned_score]" class="form-control" style="font-weight:bold" value="<?php echo $phs_chat['earned_score'] ?>"></td>
										<td style="font-weight:bold; font-size:16px; text-align:right">Overall Score:</td>
										<td><input type="text" readonly id="phs_chatemail_overall" name="data[overall_score]" class="form-control" style="font-weight:bold" value="<?php echo $phs_chat['overall_score'] ?>"></td>
									</tr>
									<tr style="height:18px; font-weight:bold"><td colspan=6 class="prm1">Compliance Critical</td></tr>
									<tr>
										<td class="prm1">1</td>
										<td class="eml1" colspan=2>Did the CSR adhere to all Authentication and Security Policies of the account member?</td>
										<td>
											<select class="form-control chatemail_pnt compliance" name="data[cr_adhere_authentication]" required>
												<option value="">-Select-</option>
												<option phs_val=5 <?php echo $phs_chat['cr_adhere_authentication'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option phs_val=5 <?php echo $phs_chat['cr_adhere_authentication'] == "No"?"selected":"";?> value="No">No</option>
												<option phs_val=0 <?php echo $phs_chat['cr_adhere_authentication'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt1]" value="<?php echo $phs_chat['cmt1'] ?>"></td>
									</tr>
									<tr>
										<td class="prm1">2</td>
										<td class="eml1" colspan=2>Did the agent  provide information to a provider about the status of the member’s account?</td>
										<td>
											<select class="form-control chatemail_pnt compliance" name="data[agent_provide_information]" required>
												<option value="">-Select-</option>
												<option phs_val=5 <?php echo $phs_chat['agent_provide_information'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option phs_val=5 <?php echo $phs_chat['agent_provide_information'] == "No"?"selected":"";?> value="No">No</option>
												<option phs_val=0 <?php echo $phs_chat['agent_provide_information'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt2]" value="<?php echo $phs_chat['cmt2'] ?>"></td>
									</tr>
									<tr>
										<td class="prm1">3</td>
										<td class="eml1" colspan=2>Did the agent able to handle a credit card information correctly?</td>
										<td>
											<select class="form-control chatemail_pnt compliance" name="data[agent_able_handle_creditcard]" required>
												<option value="">-Select-</option>
												<option phs_val=5 <?php echo $phs_chat['agent_able_handle_creditcard'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option phs_val=5 <?php echo $phs_chat['agent_able_handle_creditcard'] == "No"?"selected":"";?> value="No">No</option>
												<option phs_val=0 <?php echo $phs_chat['agent_able_handle_creditcard'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt3]" value="<?php echo $phs_chat['cmt3'] ?>"></td>
									</tr>
									<tr style="height:18px; font-weight:bold"><td colspan=6 class="prm1">Business Critical</td></tr>
									<tr>
										<td class="prm1">4</td>
										<td class="eml1" colspan=2>For account closure, did the agent follow cancellation process?</td>
										<td>
											<select class="form-control chatemail_pnt business" name="data[agent_follow_cancellation]" required>
												<option value="">-Select-</option>
												<option phs_val=5 <?php echo $phs_chat['agent_follow_cancellation'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option phs_val=5 <?php echo $phs_chat['agent_follow_cancellation'] == "No"?"selected":"";?> value="No">No</option>
												<option phs_val=0 <?php echo $phs_chat['agent_follow_cancellation'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt4]" value="<?php echo $phs_chat['cmt4'] ?>"></td>
									</tr>
									<tr>
										<td class="prm1">5</td>
										<td class="eml1" colspan=2>Did the agent submit/process all eligible refund requests in accordance with the Refund Policy</td>
										<td>
											<select class="form-control chatemail_pnt business" name="data[agent_submit_elighible_refund]" required>
												<option value="">-Select-</option>
												<option phs_val=5 <?php echo $phs_chat['agent_submit_elighible_refund'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option phs_val=5 <?php echo $phs_chat['agent_submit_elighible_refund'] == "No"?"selected":"";?> value="No">No</option>
												<option phs_val=0 <?php echo $phs_chat['agent_submit_elighible_refund'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt5]" value="<?php echo $phs_chat['cmt5'] ?>"></td>
									</tr>
									<tr>
										<td class="prm1">6</td>
										<td class="eml1" colspan=2>Did the agent properly change the payment method?</td>
										<td>
											<select class="form-control chatemail_pnt business" name="data[agent_change_payment_method]" required>
												<option value="">-Select-</option>
												<option phs_val=5 <?php echo $phs_chat['agent_change_payment_method'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option phs_val=5 <?php echo $phs_chat['agent_change_payment_method'] == "No"?"selected":"";?> value="No">No</option>
												<option phs_val=0 <?php echo $phs_chat['agent_change_payment_method'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt6]" value="<?php echo $phs_chat['cmt6'] ?>"></td>
									</tr>
									<tr>
										<td class="prm1">7</td>
										<td class="eml1" colspan=2>Did the agent properly discussed member benefits?</td>
										<td>
											<select class="form-control chatemail_pnt business" name="data[agent_dicuss_member_benefit]" required>
												<option value="">-Select-</option>
												<option phs_val=5 <?php echo $phs_chat['agent_dicuss_member_benefit'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option phs_val=5 <?php echo $phs_chat['agent_dicuss_member_benefit'] == "No"?"selected":"";?> value="No">No</option>
												<option phs_val=0 <?php echo $phs_chat['agent_dicuss_member_benefit'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt7]" value="<?php echo $phs_chat['cmt7'] ?>"></td>
									</tr>
									<tr>
										<td class="prm1">8</td>
										<td class="eml1" colspan=2>Did the agent able to properly provide the claims phone number and PO box?</td>
										<td>
											<select class="form-control chatemail_pnt business" name="data[provide_claim_phone_no]" required>
												<option value="">-Select-</option>
												<option phs_val=5 <?php echo $phs_chat['provide_claim_phone_no'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option phs_val=5 <?php echo $phs_chat['provide_claim_phone_no'] == "No"?"selected":"";?> value="No">No</option>
												<option phs_val=0 <?php echo $phs_chat['provide_claim_phone_no'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt8]" value="<?php echo $phs_chat['cmt8'] ?>"></td>
									</tr>
									<tr>
										<td class="prm1">9</td>
										<td class="eml1" colspan=2>Was all product information provided accurately?</td>
										<td>
											<select class="form-control chatemail_pnt business" name="data[product_information_provide]" required>
												<option value="">-Select-</option>
												<option phs_val=5 <?php echo $phs_chat['product_information_provide'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option phs_val=5 <?php echo $phs_chat['product_information_provide'] == "No"?"selected":"";?> value="No">No</option>
												<option phs_val=0 <?php echo $phs_chat['product_information_provide'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt9]" value="<?php echo $phs_chat['cmt9'] ?>"></td>
									</tr>
									<tr>
										<td class="prm1">10</td>
										<td class="eml1" colspan=2>Did the agent locate the information in a timely manner?</td>
										<td>
											<select class="form-control chatemail_pnt business" name="data[locate_information_timely_manner]" required>
												<option value="">-Select-</option>
												<option phs_val=5 <?php echo $phs_chat['locate_information_timely_manner'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option phs_val=5 <?php echo $phs_chat['locate_information_timely_manner'] == "No"?"selected":"";?> value="No">No</option>
												<option phs_val=0 <?php echo $phs_chat['locate_information_timely_manner'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt10]" value="<?php echo $phs_chat['cmt10'] ?>"></td>
									</tr>
									<tr>
										<td class="prm1">11</td>
										<td class="eml1" colspan=2>Did the agent execute properly any of the Escalation?</td>
										<td>
											<select class="form-control chatemail_pnt business" name="data[execute_properly_escalation]" required>
												<option value="">-Select-</option>
												<option phs_val=5 <?php echo $phs_chat['execute_properly_escalation'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option phs_val=5 <?php echo $phs_chat['execute_properly_escalation'] == "No"?"selected":"";?> value="No">No</option>
												<option phs_val=0 <?php echo $phs_chat['execute_properly_escalation'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt11]" value="<?php echo $phs_chat['cmt11'] ?>"></td>
									</tr>
									<tr>
										<td class="prm1">12</td>
										<td class="eml1" colspan=2>Did the agent properly execute any of the process for DOCUMENTATION: Were Case Comments Complete and Accurate?</td>
										<td>
											<select class="form-control chatemail_pnt business" name="data[execute_process_documentation]" required>
												<option value="">-Select-</option>
												<option phs_val=5 <?php echo $phs_chat['execute_process_documentation'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option phs_val=5 <?php echo $phs_chat['execute_process_documentation'] == "No"?"selected":"";?> value="No">No</option>
												<option phs_val=0 <?php echo $phs_chat['execute_process_documentation'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt12]" value="<?php echo $phs_chat['cmt12'] ?>"></td>
									</tr>
									<tr style="height:18px; font-weight:bold"><td colspan=6 class="prm1">Cutomer Critical</td></tr>
									<tr>
										<td class="prm1">13</td>
										<td class="eml1" colspan=2>Did the agent followed proper chat handling?</td>
										<td>
											<select class="form-control chatemail_pnt customer" name="data[agent_follo_chat_handling]" required>
												<option value="">-Select-</option>
												<option phs_val=5 <?php echo $phs_chat['agent_follo_chat_handling'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option phs_val=5 <?php echo $phs_chat['agent_follo_chat_handling'] == "No"?"selected":"";?> value="No">No</option>
												<option phs_val=0 <?php echo $phs_chat['agent_follo_chat_handling'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt13]" value="<?php echo $phs_chat['cmt13'] ?>"></td>
									</tr>
									<tr>
										<td class="prm1">14</td>
										<td class="eml1" colspan=2>Maintains a friendly, confident and professionalism throughout chat interaction</td>
										<td>
											<select class="form-control chatemail_pnt customer" name="data[profeionally_through_interaction]" required>
												<option value="">-Select-</option>
												<option phs_val=5 <?php echo $phs_chat['profeionally_through_interaction'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option phs_val=5 <?php echo $phs_chat['profeionally_through_interaction'] == "No"?"selected":"";?> value="No">No</option>
												<option phs_val=0 <?php echo $phs_chat['profeionally_through_interaction'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt14]" value="<?php echo $phs_chat['cmt14'] ?>"></td>
									</tr>
									<tr>
										<td class="prm1">15</td>
										<td class="eml1" colspan=2>Accurately communicate during the interaction?</td>
										<td>
											<select class="form-control chatemail_pnt customer" name="data[accurate_communicate_th]" required>
												<option value="">-Select-</option>
												<option phs_val=5 <?php echo $phs_chat['accurate_communicate_th'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option phs_val=5 <?php echo $phs_chat['accurate_communicate_th'] == "No"?"selected":"";?> value="No">No</option>
												<option phs_val=0 <?php echo $phs_chat['accurate_communicate_th'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt15]" value="<?php echo $phs_chat['cmt15'] ?>"></td>
									</tr>
									<tr>
										<td class="prm1">16</td>
										<td class="eml1" colspan=2>Did the agent meet the expectations they set during the chat interaction? </td>
										<td>
											<select class="form-control chatemail_pnt customer" name="data[agnet_meet_expectation]" required>
												<option value="">-Select-</option>
												<option phs_val=5 <?php echo $phs_chat['agnet_meet_expectation'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option phs_val=5 <?php echo $phs_chat['agnet_meet_expectation'] == "No"?"selected":"";?> value="No">No</option>
												<option phs_val=0 <?php echo $phs_chat['agnet_meet_expectation'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt16]" value="<?php echo $phs_chat['cmt16'] ?>"></td>
									</tr>
									<tr>
										<td class="prm1">17</td>
										<td class="eml1" colspan=2>Going above and beyond or doing the extra mile</td>
										<td>
											<select class="form-control chatemail_pnt customer" name="data[going_beyond_doing_extra_mile]" required>
												<option value="">-Select-</option>
												<option phs_val=5 <?php echo $phs_chat['going_beyond_doing_extra_mile'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option phs_val=5 <?php echo $phs_chat['going_beyond_doing_extra_mile'] == "No"?"selected":"";?> value="No">No</option>
												<option phs_val=0 <?php echo $phs_chat['going_beyond_doing_extra_mile'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt17]" value="<?php echo $phs_chat['cmt17'] ?>"></td>
									</tr>
									<tr>
										<td class="prm1">18</td>
										<td class="eml1" colspan=2>Did the agent resolve the issue and addressed the caller's needs on this call?</td>
										<td>
											<select class="form-control chatemail_pnt customer" name="data[did_the_agent_resolve]" required>
												<option value="">-Select-</option>
												<option phs_val=5 <?php echo $phs_chat['did_the_agent_resolve'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option phs_val=5 <?php echo $phs_chat['did_the_agent_resolve'] == "No"?"selected":"";?> value="No">No</option>
												<option phs_val=0 <?php echo $phs_chat['did_the_agent_resolve'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt18]" value="<?php echo $phs_chat['cmt18'] ?>"></td>
									</tr>
									<tr style="background-color:#D2B4DE"><td colspan=2>Customer Score</td><td colspan=2>Business Score</td><td colspan=2>Compliance Score</td></tr>
									<tr style="background-color:#D2B4DE">
										<td>Earned:</td><td id="custJiCisEarned"></td><td>Earned:</td><td id="busiJiCisEarned"></td><td>Earned:</td><td id="complJiCisEarned"></td>
									</tr>
									<tr style="background-color:#D2B4DE">
										<td>Possible:</td><td id="custJiCisPossible"></td><td>Possible:</td><td id="busiJiCisPossible"></td><td>Possible:</td><td id="complJiCisPossible"></td>
									</tr>
									<tr style="background-color:#D2B4DE">
										<td>Percentage:</td><td><input type="text" readonly style="background-color:#D2B4DE; text-align:center" class="form-control" id="custJiCisScore" name="data[customer_score]" value="<?php echo $phs_chat['customer_score'] ?>"></td>
										<td>Percentage:</td><td><input type="text" readonly style="background-color:#D2B4DE; text-align:center" class="form-control" id="busiJiCisScore" name="data[business_score]" value="<?php echo $phs_chat['business_score'] ?>"></td>
										<td>Percentage:</td><td><input type="text" readonly style="background-color:#D2B4DE; text-align:center" class="form-control" id="complJiCisScore" name="data[compliance_score]" value="<?php echo $phs_chat['compliance_score'] ?>"></td>
									</tr>
									<tr>
										<td>Call Summary:</td>
										<td colspan="2"><textarea class="form-control"   name="data[call_summary]"><?php echo $phs_chat['call_summary'] ?></textarea></td>
										<td>Feedback:</td>
										<td colspan="2"><textarea class="form-control"   name="data[feedback]"><?php echo $phs_chat['feedback'] ?></textarea></td>
									</tr>
									
									<tr>
										<td colspan=2>Upload Files</td>
										<?php if($chat_id==0){ ?>
											<td colspan=4><input type="file" multiple class="form-control" id="attach_file" name="attach_file[]"></td>
										<?php }else{
											if($phs_chat['attach_file']!=''){ ?>
												<td colspan=4>
													<?php $attach_file = explode(",",$phs_chat['attach_file']);
													 foreach($attach_file as $mp){ ?>
														<audio controls='' style="background-color:#607F93"> 
														  <source src="<?php echo base_url(); ?>qa_files/qa_phs/chat/<?php echo $mp; ?>" type="audio/ogg">
														  <source src="<?php echo base_url(); ?>qa_files/qa_phs/chat/<?php echo $mp; ?>" type="audio/mpeg">
														</audio> </br>
													 <?php } ?>
												</td>
										<?php }else{
												echo '<td colspan=6><b>No Files</b></td>';
											  }
										} ?>
									</tr>
									<?php  if($chat_id!=0){
										if($phs_chat['entry_by']==get_user_id()){ ?>
											<tr><td colspan=2>Edit Upload</td><td colspan=4><input type="file" multiple class="form-control1" id="fileuploadbasic" name="attach_file[]"></td></tr>
									<?php } 
									} ?>
									
									<?php if($chat_id!=0){ ?>
										<tr><td colspan=2 style="font-size:16px; font-weight:bold">Agent Feedback Acceptance:</td><td colspan=4><?php echo $phs_chat['agnt_fd_acpt'] ?></td></tr>
										<tr><td colspan=2 style="font-size:16px; font-weight:bold">Agent Review:</td><td colspan=4><?php echo $phs_chat['agent_rvw_note'] ?></td></tr>
										<tr><td colspan=2 style="font-size:16px; font-weight:bold">Management Review:</td><td colspan=4><?php echo $phs_chat['mgnt_rvw_note'] ?></td></tr>
										<tr><td colspan=2 style="font-size:16px; font-weight:bold">Client Review:</td><td colspan=4><?php echo $phs_chat['client_rvw_note'] ?></td></tr>
										
										<tr><td colspan=2  style="font-size:16px">Your Review</td><td colspan=4><textarea class="form-control1" style="width:100%" id="note" name="note"  ></textarea></td></tr>
									<?php } ?>
									
									<?php 
									if($chat_id==0){
										if(is_access_qa_module()==true || is_access_qa_operations_module()==true){ ?>
											<tr><td colspan=6><button class="btn btn-success waves-effect" type="submit" id="qaformsubmit" style="width:500px">SAVE</button></td></tr>
									<?php 
										} 
									}else{ 
										if(is_access_qa_module()==true || is_access_qa_operations_module()==true){
											if(is_available_qa_feedback($phs_chat['entry_date'],72) == true){ ?>
												<tr><td colspan="6"><button class="btn btn-success waves-effect" type="submit" id='qaformsubmit' name='btnSave' value="SAVE" style="width:500px">SAVE</button></td></tr>
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
