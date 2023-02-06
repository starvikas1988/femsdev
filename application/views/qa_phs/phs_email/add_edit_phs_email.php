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

<?php if($email_id!=0){
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
										<td colspan="6" id="theader" style="font-size:40px">Premier Health Solutions [Email]</td>
										<input type="hidden" name="audit_start_time" value="<?php echo CurrMySqlDate(); ?>">
									</tr>
									<?php
										if($email_id==0){
											$auditorName = get_username();
											$auditDate = CurrDateMDY();
											$clDate_val='';
										}else{
											if($phs_email['entry_by']!=''){
												$auditorName = $phs_email['auditor_name'];
											}else{
												$auditorName = $phs_email['client_name'];
											}
											$auditDate = mysql2mmddyy($phs_email['audit_date']);
											$clDate_val = mysql2mmddyy($phs_email['call_date']);
										}
									?>
									<tr>
										<td>Auditor Name:</td>
										<td><input type="text" class="form-control" value="<?php echo $auditorName; ?>" disabled></td>
										<td>Audit Date:</td>
										<td><input type="text" class="form-control" value="<?php echo $auditDate; ?>" disabled></td>
										<td>Email Date:</td>
										<td><input type="text" class="form-control" id="call_date" name="call_date" value="<?php echo $clDate_val; ?>" required></td>
									</tr>
									<tr>
										<td>Agent:</td>
										<td>
											<select class="form-control" id="agent_id" name="data[agent_id]" required >
												<option value="<?php echo $phs_email['agent_id'] ?>"><?php echo $phs_email['fname']." ".$phs_email['lname'] ?></option>
												<option value="">-Select-</option>
												<?php foreach($agentName as $row):  ?>
													<option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
												<?php endforeach; ?>
											</select>
										</td>
										<td>Fusion ID:</td>
										<td><input type="text" class="form-control" id="fusion_id" value="<?php echo $phs_email['fusion_id'] ?>" readonly ></td>
										<td>L1 Supervisor:</td>
										<td>
											<select class="form-control" id="tl_id" name="data[tl_id]" readonly>
												<option value="<?php echo $phs_email['tl_id'] ?>"><?php echo $phs_email['tl_name'] ?></option>
												<option value="">--Select--</option>
												<?php foreach($tlname as $tl): ?>
													<option value="<?php echo $tl['id']; ?>"><?php echo $tl['fname']." ".$tl['lname']; ?></option>
												<?php endforeach; ?>	
											</select>
										</td>
									</tr>
									<tr>
										<td>Channel:</td>
										<td><input type="text" class="form-control" name="data[channel]" value="<?php echo $phs_email['channel'] ?>" required ></td>
										<td>Case Number:</td>
										<td><input type="text" class="form-control" name="data[file_no]" value="<?php echo $phs_email['file_no'] ?>" required ></td>
										<td>Time stamp/ Link:</td>
										<td><input type="text" class="form-control" name="data[link]" value="<?php echo $phs_email['link'] ?>" required ></td>
									</tr>
									<tr>
										<td>ACPT:</td>
										<td>
											<select class="form-control" name="data[acpt]" required>
												<option value="<?php echo $phs_email['acpt'] ?>"><?php echo $phs_email['acpt'] ?></option>
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
												<option value="<?php echo $phs_email['ztp'] ?>"><?php echo $phs_email['ztp'] ?></option>
												<option value="">-Select-</option>
												<option value="Yes">Yes</option>
												<option value="No">No</option>
											</select>
										</td>
										<td>Member ID:</td>
										<td><input type="text" class="form-control" name="data[member_id]" value="<?php echo $phs_email['member_id'] ?>" required ></td>
									</tr>
									<tr>
										<td>Call Type:</td>
										<td>
											<select class="form-control" name="data[call_type]" required>
												<option value="<?php echo $phs_email['call_type'] ?>"><?php echo $phs_email['call_type'] ?></option>
												<option value="">-Select-</option>
												<option value="Cancellation">Cancellation</option>
												<option value="Refund">Refund</option>
												<option value="Benefits and Eligibility">Benefits and Eligibility</option>
												<option value="Billing">Billing</option>
												<option value="Member Portal">Member Portal</option>
												<option value="Claims">Claims</option>
												<option value="Member Portal">Member Portal</option>
												<option value="General Inquiry">General Inquiry</option>
												<option value="Plan Upgrade">Plan Upgrade</option>
											</select>
										</td>
										<td>Caller Type:</td>
										<td>
											<select class="form-control" name="data[caller_type]" required>
												<option value="<?php echo $phs_email['caller_type'] ?>"><?php echo $phs_email['caller_type'] ?></option>
												<option value="">-Select-</option>
												<option value="Member">Member</option>
												<option value="Provider">Provider</option>
											</select>
										</td>
										<td>PHS Product/Agency:</td>
										<td>
											<select class="form-control" name="data[product_agency]" required>
												<option value="<?php echo $phs_email['product_agency'] ?>"><?php echo $phs_email['product_agency'] ?></option>
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
												<option value="<?php echo $phs_email['audit_type'] ?>"><?php echo $phs_email['audit_type'] ?></option>
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
												<option value="<?php echo $phs_email['voc'] ?>"><?php echo $phs_email['voc'] ?></option>
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
												<option <?php echo $phs_email['language'] == "English"?"selected":"";?> value="English">English</option>
												<option <?php echo $phs_email['language'] == "Spanish"?"selected":"";?> value="Spanish">Spanish</option>
											</select>
										</td>
									</tr>
									<tr>
										<td style="font-weight:bold; font-size:16px">Possible Score:</td>
										<td><input type="text" readonly id="phs_chatemail_v_possible" name="data[possible_score]" class="form-control" style="font-weight:bold" value="<?php echo $phs_email['possible_score'] ?>"></td>
										<td style="font-weight:bold; font-size:16px">Earned Score:</td>
										<td><input type="text" readonly id="phs_chatemail_v_earned" name="data[earned_score]" class="form-control" style="font-weight:bold" value="<?php echo $phs_email['earned_score'] ?>"></td>
										<td style="font-weight:bold; font-size:16px; text-align:right">Overall Score:</td>
										<td><input type="text" readonly id="phs_chatemail_v_overall" name="data[overall_score]" class="form-control" style="font-weight:bold" value="<?php echo $phs_email['overall_score'] ?>"></td>
									</tr>
									<tr style="height:18px; font-weight:bold"><td colspan=6 class="prm1">Customer Critical</td></tr>
									<tr>
										<td class="prm1">1</td>
										<td class="eml1" colspan=2>Does the email have the proper greeting?</td>
										<td>
											<select class="form-control chatemail_pnt customer" name="data[have_proper_greeting]" required>
												<option value="">-Select-</option>
												<option phs_val=5 <?php echo $phs_email['have_proper_greeting'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option phs_val=5 <?php echo $phs_email['have_proper_greeting'] == "No"?"selected":"";?> value="No">No</option>
												<option phs_val=0 <?php echo $phs_email['have_proper_greeting'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt1]" value="<?php echo $phs_email['cmt1'] ?>"></td>
									</tr>
									<tr>
										<td class="prm1">2</td>
										<td class="eml1" colspan=2>Does the email contain probing questions  or initial information gathered from the original email of member/provider?</td>
										<td>
											<select class="form-control chatemail_pnt customer" name="data[contain_proving_question]" required>
												<option value="">-Select-</option>
												<option phs_val=5 <?php echo $phs_email['contain_proving_question'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option phs_val=5 <?php echo $phs_email['contain_proving_question'] == "No"?"selected":"";?> value="No">No</option>
												<option phs_val=0 <?php echo $phs_email['contain_proving_question'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt2]" value="<?php echo $phs_email['cmt2'] ?>"></td>
									</tr>
									<tr>
										<td class="prm1">3</td>
										<td class="eml1" colspan=2>Does the email provide relevant self-service option that can resolve the issue?</td>
										<td>
											<select class="form-control chatemail_pnt customer" name="data[provide_relavent_selfservice]" required>
												<option value="">-Select-</option>
												<option phs_val=5 <?php echo $phs_email['provide_relavent_selfservice'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option phs_val=5 <?php echo $phs_email['provide_relavent_selfservice'] == "No"?"selected":"";?> value="No">No</option>
												<option phs_val=0 <?php echo $phs_email['provide_relavent_selfservice'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt3]" value="<?php echo $phs_email['cmt3'] ?>"></td>
									</tr>
									<tr>
										<td class="prm1">4</td>
										<td class="eml1" colspan=2>Does the email have the best resolution which is to contact customer service via chat or call?</td>
										<td>
											<select class="form-control chatemail_pnt customer" name="data[have_best_resolution]" required>
												<option value="">-Select-</option>
												<option phs_val=5 <?php echo $phs_email['have_best_resolution'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option phs_val=5 <?php echo $phs_email['have_best_resolution'] == "No"?"selected":"";?> value="No">No</option>
												<option phs_val=0 <?php echo $phs_email['have_best_resolution'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt4]" value="<?php echo $phs_email['cmt4'] ?>"></td>
									</tr>
									<tr>
										<td class="prm1">5</td>
										<td class="eml1" colspan=2>Does the email show setting clear expectation on when the service will be completed?</td>
										<td>
											<select class="form-control chatemail_pnt customer" name="data[show_setting_clear_expectation]" required>
												<option value="">-Select-</option>
												<option phs_val=5 <?php echo $phs_email['show_setting_clear_expectation'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option phs_val=5 <?php echo $phs_email['show_setting_clear_expectation'] == "No"?"selected":"";?> value="No">No</option>
												<option phs_val=0 <?php echo $phs_email['show_setting_clear_expectation'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt5]" value="<?php echo $phs_email['cmt5'] ?>"></td>
									</tr>
									<tr>
										<td class="prm1">6</td>
										<td class="eml1" colspan=2>Does the email sound professional and courteous?</td>
										<td>
											<select class="form-control chatemail_pnt customer" name="data[sound_professional]" required>
												<option value="">-Select-</option>
												<option phs_val=5 <?php echo $phs_email['sound_professional'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option phs_val=5 <?php echo $phs_email['sound_professional'] == "No"?"selected":"";?> value="No">No</option>
												<option phs_val=0 <?php echo $phs_email['sound_professional'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt6]" value="<?php echo $phs_email['cmt6'] ?>"></td>
									</tr>
									<tr>
										<td class="prm1">7</td>
										<td class="eml1" colspan=2>Does the email have proper spelling, grammar and formatting for all written customer-facing communication?</td>
										<td>
											<select class="form-control chatemail_pnt customer" name="data[proper_spelling_grammer]" required>
												<option value="">-Select-</option>
												<option phs_val=5 <?php echo $phs_email['proper_spelling_grammer'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option phs_val=5 <?php echo $phs_email['proper_spelling_grammer'] == "No"?"selected":"";?> value="No">No</option>
												<option phs_val=0 <?php echo $phs_email['proper_spelling_grammer'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt7]" value="<?php echo $phs_email['cmt7'] ?>"></td>
									</tr>
									<tr>
										<td class="prm1">8</td>
										<td class="eml1" colspan=2>Was the email showing the proper closing statement?</td>
										<td>
											<select class="form-control chatemail_pnt customer" name="data[show_proper_cloing_statement]" required>
												<option value="">-Select-</option>
												<option phs_val=5 <?php echo $phs_email['show_proper_cloing_statement'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option phs_val=5 <?php echo $phs_email['show_proper_cloing_statement'] == "No"?"selected":"";?> value="No">No</option>
												<option phs_val=0 <?php echo $phs_email['show_proper_cloing_statement'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt8]" value="<?php echo $phs_email['cmt8'] ?>"></td>
									</tr>
									<tr>
										<td class="prm1">9</td>
										<td class="eml1" colspan=2>Did the agent use the proper template provided?</td>
										<td>
											<select class="form-control chatemail_pnt customer" name="data[use_proper_template_]" required>
												<option value="">-Select-</option>
												<option phs_val=5 <?php echo $phs_email['use_proper_template_'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option phs_val=5 <?php echo $phs_email['use_proper_template_'] == "No"?"selected":"";?> value="No">No</option>
												<option phs_val=0 <?php echo $phs_email['use_proper_template_'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt9]" value="<?php echo $phs_email['cmt9'] ?>"></td>
									</tr>
									<tr>
										<td class="prm1">10</td>
										<td class="eml1" colspan=2>Did the agent resolve the issue and addressed the member's needs on this email?</td>
										<td>
											<select class="form-control chatemail_pnt customer" name="data[did_the_agent_resolve]" required>
												<option value="">-Select-</option>
												<option phs_val=5 <?php echo $phs_email['did_the_agent_resolve'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option phs_val=5 <?php echo $phs_email['did_the_agent_resolve'] == "No"?"selected":"";?> value="No">No</option>
												<option phs_val=0 <?php echo $phs_email['did_the_agent_resolve'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt19]" value="<?php echo $phs_email['cmt19'] ?>"></td>
									</tr>
									<tr style="height:18px; font-weight:bold"><td colspan=6 class="prm1">Compliance Critical</td></tr>
									<tr>
										<td class="prm1">11</td>
										<td class="eml1" colspan=2>Did the agent adhere to all email policy and standards?</td>
										<td>
											<select class="form-control chatemail_pnt compliance" name="data[agnet_adhere_email_policy]" required>
												<option value="">-Select-</option>
												<option phs_val=5 <?php echo $phs_email['agnet_adhere_email_policy'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option phs_val=5 <?php echo $phs_email['agnet_adhere_email_policy'] == "No"?"selected":"";?> value="No">No</option>
												<option phs_val=0 <?php echo $phs_email['agnet_adhere_email_policy'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt10]" value="<?php echo $phs_email['cmt10'] ?>"></td>
									</tr>
									<tr>
										<td class="prm1">12</td>
										<td class="eml1" colspan=2>Did the agent handle the information on the email correctly?</td>
										<td>
											<select class="form-control chatemail_pnt compliance" name="data[agent_handle_information]" required>
												<option value="">-Select-</option>
												<option phs_val=5 <?php echo $phs_email['agent_handle_information'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option phs_val=5 <?php echo $phs_email['agent_handle_information'] == "No"?"selected":"";?> value="No">No</option>
												<option phs_val=0 <?php echo $phs_email['agent_handle_information'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt11]" value="<?php echo $phs_email['cmt11'] ?>"></td>
									</tr>
									<tr style="height:18px; font-weight:bold"><td colspan=6 class="prm1">Business Critical</td></tr>
									<tr>
										<td class="prm1">13</td>
										<td class="eml1" colspan=2>For account closure, did the agent follow cancellation and refund process?</td>
										<td>
											<select class="form-control chatemail_pnt business" name="data[agent_follow_cancellation_process]" required>
												<option value="">-Select-</option>
												<option phs_val=5 <?php echo $phs_email['agent_follow_cancellation_process'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option phs_val=5 <?php echo $phs_email['agent_follow_cancellation_process'] == "No"?"selected":"";?> value="No">No</option>
												<option phs_val=0 <?php echo $phs_email['agent_follow_cancellation_process'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt12]" value="<?php echo $phs_email['cmt12'] ?>"></td>
									</tr>
									
									<tr>
										<td class="prm1">14</td>
										<td class="eml1" colspan=2>Did the agent execute properly any of the Escalation?</td>
										<td>
											<select class="form-control chatemail_pnt business" name="data[agent_execute_properly]" required>
												<option value="">-Select-</option>
												<option phs_val=5 <?php echo $phs_email['agent_execute_properly'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option phs_val=5 <?php echo $phs_email['agent_execute_properly'] == "No"?"selected":"";?> value="No">No</option>
												<option phs_val=0 <?php echo $phs_email['agent_execute_properly'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt13]" value="<?php echo $phs_email['cmt13'] ?>"></td>
									</tr>
									<tr>
										<td class="prm1">15</td>
										<td class="eml1" colspan=2>Did the agent provide the accurate information needed by the member on the email?</td>
										<td>
											<select class="form-control chatemail_pnt business" name="data[provide_information_on_email]" required>
												<option value="">-Select-</option>
												<option phs_val=5 <?php echo $phs_email['provide_information_on_email'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option phs_val=5 <?php echo $phs_email['provide_information_on_email'] == "No"?"selected":"";?> value="No">No</option>
												<option phs_val=0 <?php echo $phs_email['provide_information_on_email'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt18]" value="<?php echo $phs_email['cmt18'] ?>"></td>
									</tr>
									<tr>
										<td class="prm1">16</td>
										<td class="eml1" colspan=2>Did the agent include the ticket number in the email and on the email subject?</td>
										<td>
											<select class="form-control chatemail_pnt business" name="data[agent_include_ticket_number]" required>
												<option value="">-Select-</option>
												<option phs_val=5 <?php echo $phs_email['agent_include_ticket_number'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option phs_val=5 <?php echo $phs_email['agent_include_ticket_number'] == "No"?"selected":"";?> value="No">No</option>
												<option phs_val=0 <?php echo $phs_email['agent_include_ticket_number'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt14]" value="<?php echo $phs_email['cmt14'] ?>"></td>
									</tr>
									<tr>
										<td class="prm1">17</td>
										<td class="eml1" colspan=2>Did the agent put email signature on the email?</td>
										<td>
											<select class="form-control chatemail_pnt business" name="data[agent_email_signature]" required>
												<option value="">-Select-</option>
												<option phs_val=5 <?php echo $phs_email['agent_email_signature'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option phs_val=5 <?php echo $phs_email['agent_email_signature'] == "No"?"selected":"";?> value="No">No</option>
												<option phs_val=0 <?php echo $phs_email['agent_email_signature'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt15]" value="<?php echo $phs_email['cmt15'] ?>"></td>
									</tr>
									<tr>
										<td class="prm1">18</td>
										<td class="eml1" colspan=2>Did the agent reply to the email/case within 1 business day?</td>
										<td>
											<select class="form-control chatemail_pnt business" name="data[agent_reply_email_case]" required>
												<option value="">-Select-</option>
												<option phs_val=5 <?php echo $phs_email['agent_reply_email_case'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option phs_val=5 <?php echo $phs_email['agent_reply_email_case'] == "No"?"selected":"";?> value="No">No</option>
												<option phs_val=0 <?php echo $phs_email['agent_reply_email_case'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt16]" value="<?php echo $phs_email['cmt16'] ?>"></td>
									</tr>
									<tr>
										<td class="prm1">19</td>
										<td class="eml1" colspan=2>Did the agent properly execute any of the process for DOCUMENTATION: Were Case Comments Complete and Accurate?</td>
										<td>
											<select class="form-control chatemail_pnt business" name="data[agent_execute_documentation]" required>
												<option value="">-Select-</option>
												<option phs_val=5 <?php echo $phs_email['agent_execute_documentation'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option phs_val=5 <?php echo $phs_email['agent_execute_documentation'] == "No"?"selected":"";?> value="No">No</option>
												<option phs_val=0 <?php echo $phs_email['agent_execute_documentation'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt17]" value="<?php echo $phs_email['cmt17'] ?>"></td>
									</tr>
									<tr style="background-color:#D2B4DE"><td colspan=2>Customer Score</td><td colspan=2>Business Score</td><td colspan=2>Compliance Score</td></tr>
									<tr style="background-color:#D2B4DE">
										<td>Earned:</td><td id="custJiCisEarned"></td><td>Earned:</td><td id="busiJiCisEarned"></td><td>Earned:</td><td id="complJiCisEarned"></td>
									</tr>
									<tr style="background-color:#D2B4DE">
										<td>Possible:</td><td id="custJiCisPossible"></td><td>Possible:</td><td id="busiJiCisPossible"></td><td>Possible:</td><td id="complJiCisPossible"></td>
									</tr>
									<tr style="background-color:#D2B4DE">
										<td>Percentage:</td><td><input type="text" readonly style="background-color:#D2B4DE; text-align:center" class="form-control" id="custJiCisScore" name="data[customer_score]" value="<?php echo $phs_email['customer_score'] ?>"></td>
										<td>Percentage:</td><td><input type="text" readonly style="background-color:#D2B4DE; text-align:center" class="form-control" id="busiJiCisScore" name="data[business_score]" value="<?php echo $phs_email['business_score'] ?>"></td>
										<td>Percentage:</td><td><input type="text" readonly style="background-color:#D2B4DE; text-align:center" class="form-control" id="complJiCisScore" name="data[compliance_score]" value="<?php echo $phs_email['compliance_score'] ?>"></td>
									</tr>
									<tr>
										<td>Call Summary:</td>
										<td colspan="2"><textarea class="form-control"   name="data[call_summary]"><?php echo $phs_email['call_summary'] ?></textarea></td>
										<td>Feedback:</td>
										<td colspan="2"><textarea class="form-control"   name="data[feedback]"><?php echo $phs_email['feedback'] ?></textarea></td>
									</tr>
									
									<tr>
										<td colspan=2>Upload Files</td>
										<?php if($email_id==0){ ?>
											<td colspan=4><input type="file" multiple class="form-control" id="attach_file" name="attach_file[]"></td>
										<?php }else{
											if($phs_email['attach_file']!=''){ ?>
												<td colspan=4>
													<?php $attach_file = explode(",",$phs_email['attach_file']);
													 foreach($attach_file as $mp){ ?>
														<audio controls='' style="background-color:#607F93"> 
														  <source src="<?php echo base_url(); ?>qa_files/qa_phs/email/<?php echo $mp; ?>" type="audio/ogg">
														  <source src="<?php echo base_url(); ?>qa_files/qa_phs/email/<?php echo $mp; ?>" type="audio/mpeg">
														</audio> </br>
													 <?php } ?>
												</td>
										<?php }else{
												echo '<td colspan=6><b>No Files</b></td>';
											  }
										} ?>
									</tr>
									<?php  if($email_id!=0){
										if($phs_email['entry_by']==get_user_id()){ ?>
											<tr><td colspan=2>Edit Upload</td><td colspan=4><input type="file" multiple class="form-control1" id="fileuploadbasic" name="attach_file[]"></td></tr>
									<?php } 
									} ?>
									
									<?php if($email_id!=0){ ?>
										<tr><td colspan=2 style="font-size:16px; font-weight:bold">Agent Feedback Acceptance:</td><td colspan=4><?php echo $phs_email['agnt_fd_acpt'] ?></td></tr>
										<tr><td colspan=2 style="font-size:16px; font-weight:bold">Agent Review:</td><td colspan=4><?php echo $phs_email['agent_rvw_note'] ?></td></tr>
										<tr><td colspan=2 style="font-size:16px; font-weight:bold">Management Review:</td><td colspan=4><?php echo $phs_email['mgnt_rvw_note'] ?></td></tr>
										<tr><td colspan=2 style="font-size:16px; font-weight:bold">Client Review:</td><td colspan=4><?php echo $phs_email['client_rvw_note'] ?></td></tr>
										
										<tr><td colspan=2  style="font-size:16px">Your Review</td><td colspan=4><textarea class="form-control1" style="width:100%" id="note" name="note"  ></textarea></td></tr>
									<?php } ?>
									
									<?php 
									if($email_id==0){
										if(is_access_qa_module()==true || is_access_qa_operations_module()==true){ ?>
											<tr><td colspan=6><button class="btn btn-success waves-effect" type="submit" id="qaformsubmit" style="width:500px">SAVE</button></td></tr>
									<?php 
										} 
									}else{ 
										if(is_access_qa_module()==true || is_access_qa_operations_module()==true){
											if(is_available_qa_feedback($phs_email['entry_date'],72) == true){ ?>
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
