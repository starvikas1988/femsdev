
<style>

.table > tbody > tr > td{
	text-align: center;
	font-size:13px;
}

#theader{
	font-size:20px;
	font-weight:bold;
}

.eml{
	font-weight:bold;
	background-color:#85C1E9;
}

.eml1{
	font-weight:bold;
	background-color:#76D7C4;
}

.prm1{
	font-weight:bold;
	background-color:#5DADE2;
}

</style>


<div class="wrap">
	<section class="app-content">


		<div class="row">
			<div class="col-12">
				<div class="widget">
				
					<div class="widget-body">
						<div class="table-responsive">
							<table class="table table-striped skt-table" width="100%">
								<tbody>
									<tr style="background-color:#AEB6BF"><td colspan="6" id="theader" style="font-size:30px">Premier Health Solutions [Email]</td></tr>
									
									<tr>
										<td>QA Name:</td>
										<?php if($phs_email['entry_by']!=''){
												$auditorName = $phs_email['auditor_name'];
											}else{
												$auditorName = $phs_email['client_name'];
										} ?>
										<td><input type="text" class="form-control" value="<?php echo $auditorName; ?>" disabled></td>
										<td>Audit Date:</td>
										<td><input type="text" class="form-control" value="<?php echo mysql2mmddyy($phs_email['audit_date']); ?>" disabled></td>
										<td>Email Date:</td>
										<td><input type="text" class="form-control" value="<?php echo mysql2mmddyy($phs_email['call_date']); ?>" disabled></td>
									</tr>
									<tr>
										<td>Agent:</td>
										<td>
											<select class="form-control" disabled>
												<option><?php echo $phs_email['fname']." ".$phs_email['lname'] ?></option>
											</select>
										</td>
										<td>Fusion ID:</td>
										<td><input type="text" class="form-control" value="<?php echo $phs_email['fusion_id'] ?>" disabled></td>
										<td>L1 Supervisor:</td>
										<td>
											<select class="form-control" disabled>
												<option><?php echo $phs_email['tl_name'] ?></option>	
											</select>
										</td>
									</tr>
									<tr>
										<td>Channel:</td>
										<td><input type="text" class="form-control" value="<?php echo $phs_email['channel'] ?>" disabled ></td>
										<td>Case Number:</td>
										<td><input type="text" class="form-control" value="<?php echo $phs_email['file_no'] ?>" disabled ></td>
										<td>Time stamp/ Link:</td>
										<td><input type="text" class="form-control" value="<?php echo $phs_email['link'] ?>" disabled ></td>
									</tr>
									<tr>
										<td>ACPT:</td>
										<td><select class="form-control" disabled><option><?php echo $phs_email['acpt'] ?></option></select></td>
										<td>ZTP:</td>
										<td><select class="form-control" disabled><option><?php echo $phs_email['ztp'] ?></option></select></td>
										<td>Member ID:</td>
										<td><input type="text" class="form-control" value="<?php echo $phs_email['member_id'] ?>" disabled></td>
									</tr>
									<tr>
										<td>Call Type:</td>
										<td><select class="form-control" disabled><option><?php echo $phs_email['call_type'] ?></option></select></td>
										<td>Caller Type:</td>
										<td><select class="form-control" disabled><option><?php echo $phs_email['caller_type'] ?></option></select></td>
										<td>PHS Product/Agency:</td>
										<td><select class="form-control" disabled><option><?php echo $phs_email['product_agency'] ?></option></select></td>
									</tr>
									<tr>
										<td>Audit Type:</td>
										<td><select class="form-control" disabled><option><?php echo $phs_email['audit_type'] ?></option></select></td>
										<td>VOC:</td>
										<td><select class="form-control" disabled><option><?php echo $phs_email['voc'] ?></option></select></td>
										<td>Language:</td>
										<td><select class="form-control" disabled><option><?php echo $phs_email['language'] ?></option></select></td>
									</tr>
									<tr>
										<td style="font-weight:bold; font-size:16px; text-align:right">Overall Score:</td>
										<td><input type="text" class="form-control" style="font-weight:bold" value="<?php echo $phs_email['overall_score'] ?>" disabled></td>
									</tr>
									<tr style="height:18px; font-weight:bold"><td colspan=6 class="prm1">Customer Critical</td></tr>
									<tr>
										<td class="prm1">1</td>
										<td class="eml1" colspan=2>Does the email have the proper greeting?</td>
										<td>
											<select class="form-control chatemail_pnt customer" name="data[have_proper_greeting]" disabled>
												<option value="">-Select-</option>
												<option phs_val=5 <?php echo $phs_email['have_proper_greeting'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option phs_val=5 <?php echo $phs_email['have_proper_greeting'] == "No"?"selected":"";?> value="No">No</option>
												<option phs_val=0 <?php echo $phs_email['have_proper_greeting'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt1]" value="<?php echo $phs_email['cmt1'] ?>" disabled></td>
									</tr>
									<tr>
										<td class="prm1">2</td>
										<td class="eml1" colspan=2>Does the email contain probing questions  or initial information gathered from the original email of member/provider?</td>
										<td>
											<select class="form-control chatemail_pnt customer" name="data[contain_proving_question]" disabled>
												<option value="">-Select-</option>
												<option phs_val=5 <?php echo $phs_email['contain_proving_question'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option phs_val=5 <?php echo $phs_email['contain_proving_question'] == "No"?"selected":"";?> value="No">No</option>
												<option phs_val=0 <?php echo $phs_email['contain_proving_question'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt2]" value="<?php echo $phs_email['cmt2'] ?>" disabled></td>
									</tr>
									<tr>
										<td class="prm1">3</td>
										<td class="eml1" colspan=2>Does the email provide relevant self-service option that can resolve the issue?</td>
										<td>
											<select class="form-control chatemail_pnt customer" name="data[provide_relavent_selfservice]" disabled>
												<option value="">-Select-</option>
												<option phs_val=5 <?php echo $phs_email['provide_relavent_selfservice'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option phs_val=5 <?php echo $phs_email['provide_relavent_selfservice'] == "No"?"selected":"";?> value="No">No</option>
												<option phs_val=0 <?php echo $phs_email['provide_relavent_selfservice'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt3]" value="<?php echo $phs_email['cmt3'] ?>" disabled></td>
									</tr>
									<tr>
										<td class="prm1">4</td>
										<td class="eml1" colspan=2>Does the email have the best resolution which is to contact customer service via chat or call?</td>
										<td>
											<select class="form-control chatemail_pnt customer" name="data[have_best_resolution]" disabled>
												<option value="">-Select-</option>
												<option phs_val=5 <?php echo $phs_email['have_best_resolution'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option phs_val=5 <?php echo $phs_email['have_best_resolution'] == "No"?"selected":"";?> value="No">No</option>
												<option phs_val=0 <?php echo $phs_email['have_best_resolution'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt4]" value="<?php echo $phs_email['cmt4'] ?>" disabled></td>
									</tr>
									<tr>
										<td class="prm1">5</td>
										<td class="eml1" colspan=2>Does the email show setting clear expectation on when the service will be completed?</td>
										<td>
											<select class="form-control chatemail_pnt customer" name="data[show_setting_clear_expectation]" disabled>
												<option value="">-Select-</option>
												<option phs_val=5 <?php echo $phs_email['show_setting_clear_expectation'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option phs_val=5 <?php echo $phs_email['show_setting_clear_expectation'] == "No"?"selected":"";?> value="No">No</option>
												<option phs_val=0 <?php echo $phs_email['show_setting_clear_expectation'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt5]" value="<?php echo $phs_email['cmt5'] ?>" disabled></td>
									</tr>
									<tr>
										<td class="prm1">6</td>
										<td class="eml1" colspan=2>Does the email sound professional and courteous?</td>
										<td>
											<select class="form-control chatemail_pnt customer" name="data[sound_professional]" disabled>
												<option value="">-Select-</option>
												<option phs_val=5 <?php echo $phs_email['sound_professional'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option phs_val=5 <?php echo $phs_email['sound_professional'] == "No"?"selected":"";?> value="No">No</option>
												<option phs_val=0 <?php echo $phs_email['sound_professional'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt6]" value="<?php echo $phs_email['cmt6'] ?>" disabled></td>
									</tr>
									<tr>
										<td class="prm1">7</td>
										<td class="eml1" colspan=2>Does the email have proper spelling, grammar and formatting for all written customer-facing communication?</td>
										<td>
											<select class="form-control chatemail_pnt customer" name="data[proper_spelling_grammer]" disabled>
												<option value="">-Select-</option>
												<option phs_val=5 <?php echo $phs_email['proper_spelling_grammer'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option phs_val=5 <?php echo $phs_email['proper_spelling_grammer'] == "No"?"selected":"";?> value="No">No</option>
												<option phs_val=0 <?php echo $phs_email['proper_spelling_grammer'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt7]" value="<?php echo $phs_email['cmt7'] ?>" disabled></td>
									</tr>
									<tr>
										<td class="prm1">8</td>
										<td class="eml1" colspan=2>Was the email showing the proper closing statement?</td>
										<td>
											<select class="form-control chatemail_pnt customer" name="data[show_proper_cloing_statement]" disabled>
												<option value="">-Select-</option>
												<option phs_val=5 <?php echo $phs_email['show_proper_cloing_statement'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option phs_val=5 <?php echo $phs_email['show_proper_cloing_statement'] == "No"?"selected":"";?> value="No">No</option>
												<option phs_val=0 <?php echo $phs_email['show_proper_cloing_statement'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt8]" value="<?php echo $phs_email['cmt8'] ?>" disabled></td>
									</tr>
									<tr>
										<td class="prm1">9</td>
										<td class="eml1" colspan=2>Did the agent use the proper template provided?</td>
										<td>
											<select class="form-control chatemail_pnt customer" name="data[use_proper_template_]" disabled>
												<option value="">-Select-</option>
												<option phs_val=5 <?php echo $phs_email['use_proper_template_'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option phs_val=5 <?php echo $phs_email['use_proper_template_'] == "No"?"selected":"";?> value="No">No</option>
												<option phs_val=0 <?php echo $phs_email['use_proper_template_'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt9]" value="<?php echo $phs_email['cmt9'] ?>" disabled></td>
									</tr>
									<tr>
										<td class="prm1">9</td>
										<td class="eml1" colspan=2>Did the agent use the proper template provided?</td>
										<td>
											<select class="form-control chatemail_pnt customer" name="data[use_proper_template_]" disabled>
												<option value="">-Select-</option>
												<option phs_val=5 <?php echo $phs_email['use_proper_template_'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option phs_val=5 <?php echo $phs_email['use_proper_template_'] == "No"?"selected":"";?> value="No">No</option>
												<option phs_val=0 <?php echo $phs_email['use_proper_template_'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt9]" value="<?php echo $phs_email['cmt9'] ?>" disabled></td>
									</tr>
									<tr>
										<td class="prm1">10</td>
										<td class="eml1" colspan=2>Did the agent resolve the issue and addressed the member's needs on this email?</td>
										<td>
											<select class="form-control chatemail_pnt customer" name="data[did_the_agent_resolve]" disabled>
												<option value="">-Select-</option>
												<option phs_val=5 <?php echo $phs_email['did_the_agent_resolve'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option phs_val=5 <?php echo $phs_email['did_the_agent_resolve'] == "No"?"selected":"";?> value="No">No</option>
												<option phs_val=0 <?php echo $phs_email['did_the_agent_resolve'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt19]" value="<?php echo $phs_email['cmt19'] ?>" disabled></td>
									</tr>
									<tr style="height:18px; font-weight:bold"><td colspan=6 class="prm1">Compliance Critical</td></tr>
									<tr>
										<td class="prm1">11</td>
										<td class="eml1" colspan=2>Did the agent adhere to all email policy and standards?</td>
										<td>
											<select class="form-control chatemail_pnt compliance" name="data[agnet_adhere_email_policy]" disabled>
												<option value="">-Select-</option>
												<option phs_val=5 <?php echo $phs_email['agnet_adhere_email_policy'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option phs_val=5 <?php echo $phs_email['agnet_adhere_email_policy'] == "No"?"selected":"";?> value="No">No</option>
												<option phs_val=0 <?php echo $phs_email['agnet_adhere_email_policy'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt10]" value="<?php echo $phs_email['cmt10'] ?>" disabled></td>
									</tr>
									<tr>
										<td class="prm1">12</td>
										<td class="eml1" colspan=2>Did the agent handle the information on the email correctly?</td>
										<td>
											<select class="form-control chatemail_pnt compliance" name="data[agent_handle_information]" disabled>
												<option value="">-Select-</option>
												<option phs_val=5 <?php echo $phs_email['agent_handle_information'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option phs_val=5 <?php echo $phs_email['agent_handle_information'] == "No"?"selected":"";?> value="No">No</option>
												<option phs_val=0 <?php echo $phs_email['agent_handle_information'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt11]" value="<?php echo $phs_email['cmt11'] ?>" disabled></td>
									</tr>
									<tr style="height:18px; font-weight:bold"><td colspan=6 class="prm1">Business Critical</td></tr>
									<tr>
										<td class="prm1">13</td>
										<td class="eml1" colspan=2>For account closure, did the agent follow cancellation and refund process?</td>
										<td>
											<select class="form-control chatemail_pnt business" name="data[agent_follow_cancellation_process]" disabled>
												<option value="">-Select-</option>
												<option phs_val=5 <?php echo $phs_email['agent_follow_cancellation_process'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option phs_val=5 <?php echo $phs_email['agent_follow_cancellation_process'] == "No"?"selected":"";?> value="No">No</option>
												<option phs_val=0 <?php echo $phs_email['agent_follow_cancellation_process'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt12]" value="<?php echo $phs_email['cmt12'] ?>" disabled></td>
									</tr>
									
									<tr>
										<td class="prm1">14</td>
										<td class="eml1" colspan=2>Did the agent execute properly any of the Escalation?</td>
										<td>
											<select class="form-control chatemail_pnt business" name="data[agent_execute_properly]" disabled>
												<option value="">-Select-</option>
												<option phs_val=5 <?php echo $phs_email['agent_execute_properly'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option phs_val=5 <?php echo $phs_email['agent_execute_properly'] == "No"?"selected":"";?> value="No">No</option>
												<option phs_val=0 <?php echo $phs_email['agent_execute_properly'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt13]" value="<?php echo $phs_email['cmt13'] ?>" disabled></td>
									</tr>
									<tr>
										<td class="prm1">15</td>
										<td class="eml1" colspan=2>Did the agent provide the accurate information needed by the member on the email?</td>
										<td>
											<select class="form-control chatemail_pnt business" name="data[provide_information_on_email]" disabled>
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
											<select class="form-control chatemail_pnt business" name="data[agent_include_ticket_number]" disabled>
												<option value="">-Select-</option>
												<option phs_val=5 <?php echo $phs_email['agent_include_ticket_number'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option phs_val=5 <?php echo $phs_email['agent_include_ticket_number'] == "No"?"selected":"";?> value="No">No</option>
												<option phs_val=0 <?php echo $phs_email['agent_include_ticket_number'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt14]" value="<?php echo $phs_email['cmt14'] ?>" disabled></td>
									</tr>
									<tr>
										<td class="prm1">17</td>
										<td class="eml1" colspan=2>Did the agent put email signature on the email?</td>
										<td>
											<select class="form-control chatemail_pnt business" name="data[agent_email_signature]" disabled>
												<option value="">-Select-</option>
												<option phs_val=5 <?php echo $phs_email['agent_email_signature'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option phs_val=5 <?php echo $phs_email['agent_email_signature'] == "No"?"selected":"";?> value="No">No</option>
												<option phs_val=0 <?php echo $phs_email['agent_email_signature'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt15]" value="<?php echo $phs_email['cmt15'] ?>" disabled></td>
									</tr>
									<tr>
										<td class="prm1">18</td>
										<td class="eml1" colspan=2>Did the agent reply to the email/case within 1 business day?</td>
										<td>
											<select class="form-control chatemail_pnt business" name="data[agent_reply_email_case]" disabled>
												<option value="">-Select-</option>
												<option phs_val=5 <?php echo $phs_email['agent_reply_email_case'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option phs_val=5 <?php echo $phs_email['agent_reply_email_case'] == "No"?"selected":"";?> value="No">No</option>
												<option phs_val=0 <?php echo $phs_email['agent_reply_email_case'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt16]" value="<?php echo $phs_email['cmt16'] ?>" disabled></td>
									</tr>
									<tr>
										<td class="prm1">19</td>
										<td class="eml1" colspan=2>Did the agent properly execute any of the process for DOCUMENTATION: Were Case Comments Complete and Accurate?</td>
										<td>
											<select class="form-control chatemail_pnt business" name="data[agent_execute_documentation]" disabled>
												<option value="">-Select-</option>
												<option phs_val=5 <?php echo $phs_email['agent_execute_documentation'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option phs_val=5 <?php echo $phs_email['agent_execute_documentation'] == "No"?"selected":"";?> value="No">No</option>
												<option phs_val=0 <?php echo $phs_email['agent_execute_documentation'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt17]" value="<?php echo $phs_email['cmt17'] ?>" disabled></td>
									</tr>
									<tr>
										<td>Call Summary:</td>
										<td colspan="2"><textarea class="form-control" disabled><?php echo $phs_email['call_summary'] ?></textarea></td>
										<td>Feedback:</td>
										<td colspan="2"><textarea class="form-control" disabled><?php echo $phs_email['feedback'] ?></textarea></td>
									</tr>
									
									<?php if($phs_email['attach_file']!=''){ ?>
									<tr oncontextmenu="return false;">
										<td colspan="2">Audio Files</td>
										<td colspan="4">
											<?php $attach_file = explode(",",$phs_email['attach_file']);
											 foreach($attach_file as $mp){ ?>
												<audio controls='' controlsList="nodownload" style="background-color:#607F93"> 
												  <source src="<?php echo base_url(); ?>qa_files/qa_phs/email/<?php echo $mp; ?>" type="audio/ogg">
												  <source src="<?php echo base_url(); ?>qa_files/qa_phs/email/<?php echo $mp; ?>" type="audio/mpeg">
												</audio> </br>
											 <?php } ?>
										</td>
									</tr>
									<?php } ?>
									
									<tr><td colspan="6" style="background-color:#C5C8C8"></td></tr>
									
									<tr><td style="font-size:16px">Manager Review:</td> <td colspan="5" style="text-align:left"><?php echo $phs_email['mgnt_rvw_note'] ?></td></tr>
									<tr><td style="font-size:16px">Client Review:</td> <td colspan="5" style="text-align:left"><?php echo $phs_email['client_rvw_note'] ?></td></tr>
									
									<tr><td colspan="6" style="background-color:#C5C8C8"></td></tr>
									
									<form id="form_agent_user" method="POST" action="">
									 <input type="hidden" name="pnid" class="form-control" value="<?php echo $pnid; ?>">
										
										<tr>
											<td colspan=2 style="font-size:16px">Feedback Acceptance</td>
											<td colspan=2>
												<select class="form-control" id="" name="agnt_fd_acpt" required>
													<option value="">--Select--</option>
													<option <?php echo $phs_email['agnt_fd_acpt']=='Acceptance'?"selected":""; ?> value="Acceptance">Acceptance</option>	
													<option <?php echo $phs_email['agnt_fd_acpt']=='Not Acceptance'?"selected":""; ?> value="Not Acceptance">Not Acceptance</option>	
												</select>
											</td>
										</tr>
										<tr>
											<td colspan=2 style="font-size:16px">Your Review</td>
											<td colspan=4><textarea class="form-control" name="note" required><?php echo $phs_email['agent_rvw_note'] ?></textarea></td>
										</tr>
										
										<?php if(is_access_qa_agent_module()==true){
										if(is_available_qa_feedback($phs_email['entry_date'],72) == true){ ?>
											<tr>
												<?php if($phs_email['agent_rvw_note']==''){ ?>
													<td colspan="6"><button class="btn btn-success waves-effect" type="submit" id='btnagentSave' name='btnSave' value="SAVE" style="width:500px">SAVE</button></td>
												<?php } ?>
											</tr>
										<?php } 
										} ?>
									
									  </form>
									
								</tbody>
							</table>
						</div>
					</div>
				</div>	
			</div>

		</form>	
		</div>

	</section>
</div>
