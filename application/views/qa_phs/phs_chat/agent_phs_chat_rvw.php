
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
									<tr style="background-color:#AEB6BF"><td colspan="6" id="theader" style="font-size:30px">JURY'S INN [Reservation CIS Evaluation]</td></tr>
									
									<tr>
										<td>QA Name:</td>
										<?php if($phs_chat['entry_by']!=''){
												$auditorName = $phs_chat['auditor_name'];
											}else{
												$auditorName = $phs_chat['client_name'];
										} ?>
										<td><input type="text" class="form-control" value="<?php echo $auditorName; ?>" disabled></td>
										<td>Audit Date:</td>
										<td><input type="text" class="form-control" value="<?php echo mysql2mmddyy($phs_chat['audit_date']); ?>" disabled></td>
										<td>Call Date:</td>
										<td><input type="text" class="form-control" value="<?php echo mysql2mmddyy($phs_chat['call_date']); ?>" disabled></td>
									</tr>
									<tr>
										<td>Agent:</td>
										<td>
											<select class="form-control" disabled>
												<option><?php echo $phs_chat['fname']." ".$phs_chat['lname'] ?></option>
											</select>
										</td>
										<td>Fusion ID:</td>
										<td><input type="text" class="form-control" value="<?php echo $phs_chat['fusion_id'] ?>" disabled></td>
										<td>L1 Supervisor:</td>
										<td>
											<select class="form-control" disabled>
												<option><?php echo $phs_chat['tl_name'] ?></option>	
											</select>
										</td>
									</tr>
									<tr>
										<td>Channel:</td>
										<td><input type="text" class="form-control" value="<?php echo $phs_chat['channel'] ?>" disabled></td>
										<td>File Number:</td>
										<td><input type="text" class="form-control" value="<?php echo $phs_chat['file_no'] ?>" disabled></td>
										<td>Time stamp/ Link:</td>
										<td><input type="text" class="form-control" value="<?php echo $phs_chat['link'] ?>" disabled></td>
									</tr>
									<tr>
										<td>ACPT:</td>
										<td><select class="form-control" disabled><option><?php echo $phs_chat['acpt'] ?></option></select></td>
										<td>ZTP:</td>
										<td><select class="form-control" disabled><option><?php echo $phs_chat['ztp'] ?></option></select></td>
										<td>Member ID:</td>
										<td><input type="text" class="form-control" value="<?php echo $phs_chat['member_id'] ?>" disabled></td>
									</tr>
									<tr>
										<td>Call Type:</td>
										<td><select class="form-control" disabled><option><?php echo $phs_chat['call_type'] ?></option></select></td>
										<td>Caller Type:</td>
										<td><select class="form-control" disabled><option><?php echo $phs_chat['caller_type'] ?></option></select></td>
										<td>PHS Product/Agency:</td>
										<td><select class="form-control" disabled><option><?php echo $phs_chat['product_agency'] ?></option></select></td>
									</tr>
									<tr>
										<td>Audit Type:</td>
										<td><select class="form-control" disabled><option><?php echo $phs_chat['audit_type'] ?></option></select></td>
										<td>VOC:</td>
										<td><select class="form-control" disabled><option><?php echo $phs_chat['voc'] ?></option></select></td>
										<td>Language:</td>
										<td><select class="form-control" disabled><option><?php echo $phs_chat['language'] ?></option></select></td>
									</tr>
									<tr>
										<td style="font-weight:bold; font-size:16px; text-align:right">Overall Score:</td>
										<td><input type="text" class="form-control" style="font-weight:bold" value="<?php echo $phs_chat['overall_score'] ?>" disabled></td>
									</tr>
									<tr style="height:18px; font-weight:bold"><td colspan=6 class="prm1">Compliance Critical</td></tr>
									<tr>
										<td class="prm1">1</td>
										<td class="eml1" colspan=2>Did the CSR adhere to all Authentication and Security Policies of the account member?</td>
										<td>
											<select class="form-control chatemail_pnt compliance" name="data[cr_adhere_authentication]" disabled>
												<option value="">-Select-</option>
												<option phs_val=5 <?php echo $phs_chat['cr_adhere_authentication'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option phs_val=5 <?php echo $phs_chat['cr_adhere_authentication'] == "No"?"selected":"";?> value="No">No</option>
												<option phs_val=0 <?php echo $phs_chat['cr_adhere_authentication'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt1]" value="<?php echo $phs_chat['cmt1'] ?>" disabled></td>
									</tr>
									<tr>
										<td class="prm1">2</td>
										<td class="eml1" colspan=2>Did the agent  provide information to a provider about the status of the member’s account?</td>
										<td>
											<select class="form-control chatemail_pnt compliance" name="data[agent_provide_information]" disabled>
												<option value="">-Select-</option>
												<option phs_val=5 <?php echo $phs_chat['agent_provide_information'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option phs_val=5 <?php echo $phs_chat['agent_provide_information'] == "No"?"selected":"";?> value="No">No</option>
												<option phs_val=0 <?php echo $phs_chat['agent_provide_information'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt2]" value="<?php echo $phs_chat['cmt2'] ?>" disabled></td>
									</tr>
									<tr>
										<td class="prm1">3</td>
										<td class="eml1" colspan=2>Did the agent able to handle a credit card information correctly?</td>
										<td>
											<select class="form-control chatemail_pnt compliance" name="data[agent_able_handle_creditcard]" disabled>
												<option value="">-Select-</option>
												<option phs_val=5 <?php echo $phs_chat['agent_able_handle_creditcard'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option phs_val=5 <?php echo $phs_chat['agent_able_handle_creditcard'] == "No"?"selected":"";?> value="No">No</option>
												<option phs_val=0 <?php echo $phs_chat['agent_able_handle_creditcard'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt3]" value="<?php echo $phs_chat['cmt3'] ?>" disabled></td>
									</tr>
									<tr style="height:18px; font-weight:bold"><td colspan=6 class="prm1">Business Critical</td></tr>
									<tr>
										<td class="prm1">4</td>
										<td class="eml1" colspan=2>For account closure, did the agent follow cancellation process?</td>
										<td>
											<select class="form-control chatemail_pnt business" name="data[agent_follow_cancellation]" disabled>
												<option value="">-Select-</option>
												<option phs_val=5 <?php echo $phs_chat['agent_follow_cancellation'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option phs_val=5 <?php echo $phs_chat['agent_follow_cancellation'] == "No"?"selected":"";?> value="No">No</option>
												<option phs_val=0 <?php echo $phs_chat['agent_follow_cancellation'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt4]" value="<?php echo $phs_chat['cmt4'] ?>" disabled></td>
									</tr>
									<tr>
										<td class="prm1">5</td>
										<td class="eml1" colspan=2>Did the agent submit/process all eligible refund requests in accordance with the Refund Policy</td>
										<td>
											<select class="form-control chatemail_pnt business" name="data[agent_submit_elighible_refund]" disabled>
												<option value="">-Select-</option>
												<option phs_val=5 <?php echo $phs_chat['agent_submit_elighible_refund'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option phs_val=5 <?php echo $phs_chat['agent_submit_elighible_refund'] == "No"?"selected":"";?> value="No">No</option>
												<option phs_val=0 <?php echo $phs_chat['agent_submit_elighible_refund'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt5]" value="<?php echo $phs_chat['cmt5'] ?>" disabled></td>
									</tr>
									<tr>
										<td class="prm1">6</td>
										<td class="eml1" colspan=2>Did the agent properly change the payment method?</td>
										<td>
											<select class="form-control chatemail_pnt business" name="data[agent_change_payment_method]" disabled>
												<option value="">-Select-</option>
												<option phs_val=5 <?php echo $phs_chat['agent_change_payment_method'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option phs_val=5 <?php echo $phs_chat['agent_change_payment_method'] == "No"?"selected":"";?> value="No">No</option>
												<option phs_val=0 <?php echo $phs_chat['agent_change_payment_method'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt6]" value="<?php echo $phs_chat['cmt6'] ?>" disabled></td>
									</tr>
									<tr>
										<td class="prm1">7</td>
										<td class="eml1" colspan=2>Did the agent properly discussed member benefits?</td>
										<td>
											<select class="form-control chatemail_pnt business" name="data[agent_dicuss_member_benefit]" disabled>
												<option value="">-Select-</option>
												<option phs_val=5 <?php echo $phs_chat['agent_dicuss_member_benefit'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option phs_val=5 <?php echo $phs_chat['agent_dicuss_member_benefit'] == "No"?"selected":"";?> value="No">No</option>
												<option phs_val=0 <?php echo $phs_chat['agent_dicuss_member_benefit'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt7]" value="<?php echo $phs_chat['cmt7'] ?>" disabled></td>
									</tr>
									<tr>
										<td class="prm1">8</td>
										<td class="eml1" colspan=2>Did the agent able to properly provide the claims phone number and PO box?</td>
										<td>
											<select class="form-control chatemail_pnt business" name="data[provide_claim_phone_no]" disabled>
												<option value="">-Select-</option>
												<option phs_val=5 <?php echo $phs_chat['provide_claim_phone_no'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option phs_val=5 <?php echo $phs_chat['provide_claim_phone_no'] == "No"?"selected":"";?> value="No">No</option>
												<option phs_val=0 <?php echo $phs_chat['provide_claim_phone_no'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt8]" value="<?php echo $phs_chat['cmt8'] ?>" disabled></td>
									</tr>
									<tr>
										<td class="prm1">9</td>
										<td class="eml1" colspan=2>Was all product information provided accurately?</td>
										<td>
											<select class="form-control chatemail_pnt business" name="data[product_information_provide]" disabled>
												<option value="">-Select-</option>
												<option phs_val=5 <?php echo $phs_chat['product_information_provide'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option phs_val=5 <?php echo $phs_chat['product_information_provide'] == "No"?"selected":"";?> value="No">No</option>
												<option phs_val=0 <?php echo $phs_chat['product_information_provide'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt9]" value="<?php echo $phs_chat['cmt9'] ?>" disabled></td>
									</tr>
									<tr>
										<td class="prm1">10</td>
										<td class="eml1" colspan=2>Did the agent locate the information in a timely manner?</td>
										<td>
											<select class="form-control chatemail_pnt business" name="data[locate_information_timely_manner]" disabled>
												<option value="">-Select-</option>
												<option phs_val=5 <?php echo $phs_chat['locate_information_timely_manner'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option phs_val=5 <?php echo $phs_chat['locate_information_timely_manner'] == "No"?"selected":"";?> value="No">No</option>
												<option phs_val=0 <?php echo $phs_chat['locate_information_timely_manner'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt10]" value="<?php echo $phs_chat['cmt10'] ?>" disabled></td>
									</tr>
									<tr>
										<td class="prm1">11</td>
										<td class="eml1" colspan=2>Did the agent execute properly any of the Escalation?</td>
										<td>
											<select class="form-control chatemail_pnt business" name="data[execute_properly_escalation]" disabled>
												<option value="">-Select-</option>
												<option phs_val=5 <?php echo $phs_chat['execute_properly_escalation'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option phs_val=5 <?php echo $phs_chat['execute_properly_escalation'] == "No"?"selected":"";?> value="No">No</option>
												<option phs_val=0 <?php echo $phs_chat['execute_properly_escalation'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt11]" value="<?php echo $phs_chat['cmt11'] ?>" disabled></td>
									</tr>
									<tr>
										<td class="prm1">12</td>
										<td class="eml1" colspan=2>Did the agent properly execute any of the process for DOCUMENTATION: Were Case Comments Complete and Accurate?</td>
										<td>
											<select class="form-control chatemail_pnt business" name="data[execute_process_documentation]" disabled>
												<option value="">-Select-</option>
												<option phs_val=5 <?php echo $phs_chat['execute_process_documentation'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option phs_val=5 <?php echo $phs_chat['execute_process_documentation'] == "No"?"selected":"";?> value="No">No</option>
												<option phs_val=0 <?php echo $phs_chat['execute_process_documentation'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt12]" value="<?php echo $phs_chat['cmt12'] ?>" disabled></td>
									</tr>
									<tr style="height:18px; font-weight:bold"><td colspan=6 class="prm1">Cutomer Critical</td></tr>
									<tr>
										<td class="prm1">13</td>
										<td class="eml1" colspan=2>Did the agent followed proper chat handling?</td>
										<td>
											<select class="form-control chatemail_pnt customer" name="data[agent_follo_chat_handling]" disabled>
												<option value="">-Select-</option>
												<option phs_val=5 <?php echo $phs_chat['agent_follo_chat_handling'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option phs_val=5 <?php echo $phs_chat['agent_follo_chat_handling'] == "No"?"selected":"";?> value="No">No</option>
												<option phs_val=0 <?php echo $phs_chat['agent_follo_chat_handling'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt13]" value="<?php echo $phs_chat['cmt13'] ?>" disabled></td>
									</tr>
									<tr>
										<td class="prm1">14</td>
										<td class="eml1" colspan=2>Maintains a friendly, confident and professionalism throughout chat interaction</td>
										<td>
											<select class="form-control chatemail_pnt customer" name="data[profeionally_through_interaction]" disabled>
												<option value="">-Select-</option>
												<option phs_val=5 <?php echo $phs_chat['profeionally_through_interaction'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option phs_val=5 <?php echo $phs_chat['profeionally_through_interaction'] == "No"?"selected":"";?> value="No">No</option>
												<option phs_val=0 <?php echo $phs_chat['profeionally_through_interaction'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt14]" value="<?php echo $phs_chat['cmt14'] ?>" disabled></td>
									</tr>
									<tr>
										<td class="prm1">15</td>
										<td class="eml1" colspan=2>Accurately communicate during the interaction?</td>
										<td>
											<select class="form-control chatemail_pnt customer" name="data[accurate_communicate_th]" disabled>
												<option value="">-Select-</option>
												<option phs_val=5 <?php echo $phs_chat['accurate_communicate_th'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option phs_val=5 <?php echo $phs_chat['accurate_communicate_th'] == "No"?"selected":"";?> value="No">No</option>
												<option phs_val=0 <?php echo $phs_chat['accurate_communicate_th'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt15]" value="<?php echo $phs_chat['cmt15'] ?>" disabled></td>
									</tr>
									<tr>
										<td class="prm1">16</td>
										<td class="eml1" colspan=2>Did the agent meet the expectations they set during the chat interaction? </td>
										<td>
											<select class="form-control chatemail_pnt customer" name="data[agnet_meet_expectation]" disabled>
												<option value="">-Select-</option>
												<option phs_val=5 <?php echo $phs_chat['agnet_meet_expectation'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option phs_val=5 <?php echo $phs_chat['agnet_meet_expectation'] == "No"?"selected":"";?> value="No">No</option>
												<option phs_val=0 <?php echo $phs_chat['agnet_meet_expectation'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt16]" value="<?php echo $phs_chat['cmt16'] ?>" disabled>Yes</option>
												<option phs_val=5 <?php echo $phs_chat['going_beyond_doing_extra_mile'] == "No"?"selected":"";?> value="No">No</option>
												<option phs_val=0 <?php echo $phs_chat['going_beyond_doing_extra_mile'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt17]" value="<?php echo $phs_chat['cmt17'] ?>"></td>
									</tr>
									<tr>
										<td class="prm1">17</td>
										<td class="eml1" colspan=2>Did the agent resolve the issue and addressed the caller's needs on this call?</td>
										<td>
											<select class="form-control chatemail_pnt customer" name="data[did_the_agent_resolve]" disabled>
												<option value="">-Select-</option>
												<option phs_val=5 <?php echo $phs_chat['did_the_agent_resolve'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option phs_val=5 <?php echo $phs_chat['did_the_agent_resolve'] == "No"?"selected":"";?> value="No">No</option>
												<option phs_val=0 <?php echo $phs_chat['did_the_agent_resolve'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt18]" value="<?php echo $phs_chat['cmt18'] ?>" disabled></td>
									</tr>
									<tr>
										<td>Call Summary:</td>
										<td colspan="2"><textarea class="form-control" disabled><?php echo $phs_chat['call_summary'] ?></textarea></td>
										<td>Feedback:</td>
										<td colspan="2"><textarea class="form-control" disabled><?php echo $phs_chat['feedback'] ?></textarea></td>
									</tr>
									
									<?php if($phs_chat['attach_file']!=''){ ?>
									<tr oncontextmenu="return false;">
										<td colspan="2">Audio Files</td>
										<td colspan="4">
											<?php $attach_file = explode(",",$phs_chat['attach_file']);
											 foreach($attach_file as $mp){ ?>
												<audio controls='' controlsList="nodownload" style="background-color:#607F93"> 
												  <source src="<?php echo base_url(); ?>qa_files/qa_phs/chat/<?php echo $mp; ?>" type="audio/ogg">
												  <source src="<?php echo base_url(); ?>qa_files/qa_phs/chat/<?php echo $mp; ?>" type="audio/mpeg">
												</audio> </br>
											 <?php } ?>
										</td>
									</tr>
									<?php } ?>
									
									<tr><td colspan="6" style="background-color:#C5C8C8"></td></tr>
									
									<tr><td style="font-size:16px">Manager Review:</td> <td colspan="5" style="text-align:left"><?php echo $phs_chat['mgnt_rvw_note'] ?></td></tr>
									<tr><td style="font-size:16px">Client Review:</td> <td colspan="5" style="text-align:left"><?php echo $phs_chat['client_rvw_note'] ?></td></tr>
									
									<tr><td colspan="6" style="background-color:#C5C8C8"></td></tr>
									
									<form id="form_agent_user" method="POST" action="">
									 <input type="hidden" name="pnid" class="form-control" value="<?php echo $pnid; ?>">
										
										<tr>
											<td colspan=2 style="font-size:16px">Feedback Acceptance</td>
											<td colspan=2>
												<select class="form-control" id="" name="agnt_fd_acpt" required>
													<option value="">--Select--</option>
													<option <?php echo $phs_chat['agnt_fd_acpt']=='Acceptance'?"selected":""; ?> value="Acceptance">Acceptance</option>	
													<option <?php echo $phs_chat['agnt_fd_acpt']=='Not Acceptance'?"selected":""; ?> value="Not Acceptance">Not Acceptance</option>	
												</select>
											</td>
										</tr>
										<tr>
											<td colspan=2 style="font-size:16px">Your Review</td>
											<td colspan=4><textarea class="form-control" name="note" required><?php echo $phs_chat['agent_rvw_note'] ?></textarea></td>
										</tr>
										
										<?php if(is_access_qa_agent_module()==true){
										if(is_available_qa_feedback($phs_chat['entry_date'],72) == true){ ?>
											<tr>
												<?php if($phs_chat['agent_rvw_note']==''){ ?>
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
