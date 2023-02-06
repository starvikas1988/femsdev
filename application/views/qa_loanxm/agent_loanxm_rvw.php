
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
	background-color:#85C1E9;
}

</style>


<div class="wrap">
	<section class="app-content">


		<div class="row">
			<div class="col-12">
				<div class="widget">
				
					<div class="widget-body">
						<div class="table-responsive">
							<table class="table  skt-table" width="100%">
								<tbody>
									<tr><td colspan="6" id="theader" style="font-size:40px;text-align: center;background-color: #16A5CB ;">Loanxm</td></tr>
									
									<tr>
										<td>Auditor Name:</td>
										<?php if($loanxm['entry_by']!=''){
												$auditorName = $loanxm['auditor_name'];
											}else{
												$auditorName = $loanxm['client_name'];
										} ?>
										<td><input type="text" class="form-control" value="<?php echo $auditorName; ?>" disabled></td>
										<td>Audit Date:</td>
										<td><input type="text" class="form-control" value="<?php echo mysql2mmddyy($loanxm['audit_date']); ?>" disabled></td>
										<td>Call Date:</td>
										<td><input type="text" class="form-control" value="<?php echo mysql2mmddyy($loanxm['call_date']); ?>" disabled></td>
									</tr>
									<tr>
										<td>Agent:</td>
										<td><select class="form-control" disabled><option><?php echo $loanxm['fname']." ".$loanxm['lname'] ?></option></select></td>
										<td>Fusion ID:</td>
										<td><input type="text" class="form-control" value="<?php echo $loanxm['fusion_id'] ?>" disabled></td>
										<td>L1 Supervisor:</td>
										<td><select class="form-control" disabled><option><?php echo $loanxm['tl_name'] ?></option></select></td>
									</tr>
									<tr>
										<td>Call Duration:</td>
										<td><input type="text" class="form-control" value="<?php echo $loanxm['call_duration'] ?>" disabled ></td>
										<td>Type of Call:</td>
										<td><select class="form-control" disabled><option><?php echo $loanxm['call_type'] ?></option></select></td>
										<td>Call ID:</td>
										<td><input type="text" class="form-control" value="<?php echo $loanxm['five9_id'] ?>" disabled ></td>
									</tr>
									<tr>
										<td>Customer Name:</td>
										<td><input type="text" class="form-control" value="<?php echo $loanxm['customer_name'] ?>" disabled ></td>
										<td>Customer Contact number:</td>
										<td><input type="text" class="form-control" value="<?php echo $loanxm['customer_contact'] ?>" disabled ></td>
										<td>Disposition</td>
										<td><input type="text" class="form-control" value="<?php echo $loanxm['disposition'] ?>"disabled></td>
									</tr>
									<tr>
										<td>Audit Type:</td>
										<td><select class="form-control" disabled><option><?php echo $loanxm['audit_type'] ?></option></select></td>
										<td>VOC:</td>
										<td><select class="form-control" disabled><option><?php echo $loanxm['voc'] ?></option></select></td>
										<td style="font-weight:bold; font-size:16px">Overall Score:</td>
										<td ><input type="text" disabled class="form-control" style="font-weight:bold" value="<?php echo $loanxm['overall_score'] ?>"></td>
									</tr>
									<tr style=" font-weight:bold;background-color: #D3E32D ;">
										<td>#</td><td colspan="2">Question</td><td>Points</td><td>Criticalities</td><td>Score</td>
									</tr>
									<tr><td colspan=6 style="background-color:skyblue; text-align:left;">SECTION 1 - Adherence to Script</td></tr>
									<!-- <tr><td colspan=6 style="background-color:skyblue; text-align:left;">SECTION 1 - Adherence to Script</td></tr> -->
									<tr>
										<td>a</td>
										<td colspan=2>Opening/Introduction (Almost identical for inbound vs outbound)</td>
										<td>8</td>
										<td class="eml">Business</td>
										<td>
											<select class="form-control loanxm_point" name="data[opening_introduction]" disabled>
												<option value="">-Select-</option>
												<option loanxm_val=8 <?php echo $loanxm['opening_introduction'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option loanxm_val=0 <?php echo $loanxm['opening_introduction'] == "No"?"selected":"";?> value="No">No</option>
												<option loanxm_val=8 <?php echo $loanxm['opening_introduction'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
									</tr>
									<tr>
										<td>b</td>
										<td colspan=2>Qualifying Questions</td>
										<td>6</td>
										<td class="eml">Business</td>
										<td>
											<select class="form-control loanxm_point" name="data[qualifying_questions]" disabled>
												<option value="">-Select-</option>
												<option loanxm_val=6 <?php echo $loanxm['qualifying_questions'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option loanxm_val=0 <?php echo $loanxm['qualifying_questions'] == "No"?"selected":"";?> value="No">No</option>
												<option loanxm_val=6 <?php echo $loanxm['qualifying_questions'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
									</tr>
									<tr>
										<td>c</td>
										<td colspan=2 >Conclusion - varies for a LT vs Post vs Call Backs</td>
										<td >6</td>
										<td class="eml">Business</td>
										<td>
											<select class="form-control loanxm_point" name="data[conclusion]" disabled>
												<option value="">-Select-</option>
												<option loanxm_val=6 <?php echo $loanxm['conclusion'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option loanxm_val=0 <?php echo $loanxm['conclusion'] == "No"?"selected":"";?> value="No">No</option>
												<option loanxm_val=6 <?php echo $loanxm['conclusion'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>  
										</td>
									</tr>
									<tr>
										<td>d</td>
										<td colspan=2>Questions and Rebuttals</td>
										<td>6</td>
										<td class="eml">Business</td>
										<td>
											<select class="form-control loanxm_point" name="data[questions_rebuttals]" disabled>
												<option value="">-Select-</option>
												<option loanxm_val=6 <?php echo $loanxm['questions_rebuttals'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option loanxm_val=0 <?php echo $loanxm['questions_rebuttals'] == "No"?"selected":"";?> value="No">No</option>
												<option loanxm_val=6 <?php echo $loanxm['questions_rebuttals'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
									</tr>
									<tr><td colspan=6 style="background-color:skyblue; text-align: left;">SECTION 2 - Communication Skills</td></tr>
									<tr>
										<td>a</td>
										<td colspan=2>Uses appropriate tone, pace, and voice inflection.</td>
										<td>8</td>
										<td class="eml">Customer</td>
										<td>
											<select class="form-control loanxm_point" name="data[voice_quality]" disabled>
												<option value="">-Select-</option>
												<option loanxm_val=8 <?php echo $loanxm['voice_quality'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option loanxm_val=0 <?php echo $loanxm['voice_quality'] == "No"?"selected":"";?> value="No">No</option>
												<option loanxm_val=8 <?php echo $loanxm['voice_quality'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
									</tr>
									<tr>
										<td>b</td>
										<td colspan=2>Did the agent use proper word choice, pronunciation, and enunciation?.</td>
										<td>8</td>
										<td class="eml">Customer</td>
										<td>
											<select class="form-control loanxm_point" name="data[pronunciation]" disabled>
												<option value="">-Select-</option>
												<option loanxm_val=8 <?php echo $loanxm['pronunciation'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option loanxm_val=0 <?php echo $loanxm['pronunciation'] == "No"?"selected":"";?> value="No">No</option>
												<option loanxm_val=8 <?php echo $loanxm['pronunciation'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
									</tr>
									<tr>
										<td>c</td>
										<td colspan=2>Listen actively and respond appropriately without interrupting customer?</td>
										<td>10</td>
										<td class="eml">Customer</td>
										<td>
											<select class="form-control loanxm_point" name="data[listen_actively]" disabled>
												<option value="">-Select-</option>
												<option loanxm_val=10 <?php echo $loanxm['listen_actively'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option loanxm_val=0 <?php echo $loanxm['listen_actively'] == "No"?"selected":"";?> value="No">No</option>
												<option loanxm_val=10 <?php echo $loanxm['listen_actively'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
									</tr>
									<tr><td colspan=6 style="background-color:skyblue; text-align: left;">SECTION 3 - Technical and Procedural</td></tr>
									<!-- <tr>
										<td>a</td>
										<td colspan=2>Used manual connector to pull up lead in Portal</td>
										<td>5</td>
										<td class="eml">Business</td>
										<td>
											<select class="form-control loanxm_point business" name="data[lead_portal]" required>
												<option value="">-Select-</option>
												<option loanxm_val=5 <?php //echo $loanxm['lead_portal'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option loanxm_val=5 <?php //echo $loanxm['lead_portal'] == "No"?"selected":"";?> value="No">No</option>
												<option loanxm_val=0 <?php //echo $loanxm['lead_portal'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
									</tr> -->
									<tr>
										<td>a</td>
										<td colspan=2>Properly Identified client is the person on the call.</td>
										<td>5</td>
										<td class="eml">Business</td>
										<td>
											<select class="form-control loanxm_point business" name="data[identified]" disabled>
												<option value="">-Select-</option>
												<option loanxm_val=5 <?php echo $loanxm['identified'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option loanxm_val=5 <?php echo $loanxm['identified'] == "No"?"selected":"";?> value="No">No</option>
												<option loanxm_val=0 <?php echo $loanxm['identified'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
									</tr>
									<tr>
										<td>b</td>
										<td colspan=2>All Portal Fields filled out correctly</td>
										<td>5</td>
										<td class="eml">Business</td>
										<td>
											<select class="form-control loanxm_point business" name="data[all_portal_fields]" disabled>
												<option value="">-Select-</option>
												<option loanxm_val=5 <?php echo $loanxm['all_portal_fields'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option loanxm_val=5 <?php echo $loanxm['all_portal_fields'] == "No"?"selected":"";?> value="No">No</option>
												<option loanxm_val=0 <?php echo $loanxm['all_portal_fields'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
									</tr>
									<!-- <tr>
										<td>c</td>
										<td colspan=2>Dispostioned properly in Portal (Green Light, Yellow light with time of day, Dispo for Red Light)</td>
										<td>10</td>
										<td class="eml">Business</td>
										<td>
											<select class="form-control loanxm_point business" name="data[disposition_in_portal]" required>
												<option value="">-Select-</option>
												<option loanxm_val=10 <?php //echo $loanxm['disposition_in_portal'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option loanxm_val=10 <?php //echo $loanxm['disposition_in_portal'] == "No"?"selected":"";?> value="No">No</option>
												<option loanxm_val=0 <?php //echo $loanxm['disposition_in_portal'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
									</tr>-->
									<tr>
										<td>c</td>
										<td colspan=2>Process lead properly with the portal.</td>
										<td>10</td>
										<td class="eml">Business</td>
										<td>
											<select class="form-control loanxm_point business" name="data[process_lead]" disabled>
												<option value="">-Select-</option>
												<option loanxm_val=10 <?php echo $loanxm['process_lead'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option loanxm_val=10 <?php echo $loanxm['process_lead'] == "No"?"selected":"";?> value="No">No</option>
												<option loanxm_val=0 <?php echo $loanxm['process_lead'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
									</tr>Process lead properly with the portal. 
									<tr>
										<td>d</td>
										<td colspan=2>If Red Light - Did agent proceed to Credit Card page in Portal?</td>
										<td>5</td>
										<td class="eml">Business</td>
										<td>
											<select class="form-control loanxm_point business" name="data[red_creditcard_portal]" disabled>
												<option value="">-Select-</option>
												<option loanxm_val=5 <?php echo $loanxm['red_creditcard_portal'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option loanxm_val=5 <?php echo $loanxm['red_creditcard_portal'] == "No"?"selected":"";?> value="No">No</option>
												<option loanxm_val=0 <?php echo $loanxm['red_creditcard_portal'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
									</tr>
									<!-- <tr>
										<td>e</td>
										<td colspan=2>Dispositioned properly in Five9</td>
										<td>10</td>
										<td class="eml">Business</td>
										<td>
											<select class="form-control loanxm_point business" name="data[dispositioned_five9]" required>
												<option value="">-Select-</option>
												<option loanxm_val=10 <?php //echo $loanxm['dispositioned_five9'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option loanxm_val=10 <?php //echo $loanxm['dispositioned_five9'] == "No"?"selected":"";?> value="No">No</option>
												<option loanxm_val=0 <?php //echo $loanxm['dispositioned_five9'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
									</tr> -->
									<tr>
										<td>e</td>
										<td colspan=2>Term Coded properly in Livebox and Dispositioned correctly in TMI</td>
										<td>10</td>
										<td class="eml">Business</td>
										<td>
											<select class="form-control loanxm_point business" name="data[dispositioned_livebox]" disabled>
												<option value="">-Select-</option>
												<option loanxm_val=10 <?php echo $loanxm['dispositioned_livebox'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option loanxm_val=10 <?php echo $loanxm['dispositioned_livebox'] == "No"?"selected":"";?> value="No">No</option>
												<option loanxm_val=0 <?php echo $loanxm['dispositioned_livebox'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
									</tr>
									
									<tr>
										<td>f</td>
										<td colspan=2>Proper phone system procedure to complete Live Transfer</td>
										<td>5</td>
										<td class="eml">Business</td>
										<td>
											<select class="form-control loanxm_point business" name="data[live_transfer_phone]" disabled>
												<option value="">-Select-</option>
												<option loanxm_val=5 <?php echo $loanxm['live_transfer_phone'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option loanxm_val=5 <?php echo $loanxm['live_transfer_phone'] == "No"?"selected":"";?> value="No">No</option>
												<option loanxm_val=0 <?php echo $loanxm['live_transfer_phone'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
									</tr>
									<tr><td colspan=6 style="background-color:skyblue; text-align: left;">SECTION 4 - Misc</td></tr>
									<tr>
										<td>a</td>
										<td colspan=2>Did the agent use the prospects name at least twice?</td>
										<td>4</td>
										<td class="eml">Business</td>
										<td>
											<select class="form-control loanxm_point business" name="data[agent_use_prospect_name]" disabled>
												<option value="">-Select-</option>
												<option loanxm_val=4 <?php echo $loanxm['agent_use_prospect_name'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option loanxm_val=4 <?php echo $loanxm['agent_use_prospect_name'] == "No"?"selected":"";?> value="No">No</option>
												<option loanxm_val=0 <?php echo $loanxm['agent_use_prospect_name'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
									</tr>
									<tr>
										<td>b</td>
										<td colspan=2>Did the agent reference to our Texas Office when applicable?</td>
										<td>4</td>
										<td class="eml">Business</td>
										<td>
											<select class="form-control loanxm_point business" name="data[agent_houston_office]" disabled>
												<option value="">-Select-</option>
												<option loanxm_val=4 <?php echo $loanxm['agent_houston_office'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option loanxm_val=4 <?php echo $loanxm['agent_houston_office'] == "No"?"selected":"";?> value="No">No</option>
												<option loanxm_val=0 <?php echo $loanxm['agent_houston_office'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
									</tr>

									<tr>
										<td>c</td>
										<td colspan=2>Background sound quality</td>
										<td>0</td>
										<td class="eml">Business</td>
										<td>
											<select class="form-control loanxm_point" name="data[quality]" disabled>
												<option value="">-Select-</option>
												<option loanxm_val=0 <?php echo $loanxm['quality'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option loanxm_val=0 <?php echo $loanxm['quality'] == "No"?"selected":"";?> value="No">No</option>
												<!-- <option loanxm_val=0 <?php echo $loanxm['quality'] == "N/A"?"selected":"";?> value="N/A">N/A</option> -->
											</select> 
										</td>
									</tr>
									
									<tr><td colspan=6 style="background-color:skyblue; text-align: left;">SECTION 5-  INBOUND EXISTING CUSTOMER</td></tr>
									<tr>
										<td>a</td>
										<td colspan=2>Proper script was used. It was made abundantly clear Debt Solutions 123 is a strategic partner of SOD and CSF?</td>
										<td>20</td>
										<td class="eml">Compliance</td>
										<td>
											<select class="form-control loanxm_point compliance section5" id="idfc_new_AF1" name="data[proper_script_use]" disabled>
												<option value="">-Select-</option>
												<option loanxm_val=0 <?php echo $loanxm['proper_script_use'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option loanxm_val=0 <?php echo $loanxm['proper_script_use'] == "No"?"selected":"";?> value="No">No</option>
												<option loanxm_val=0 <?php echo $loanxm['proper_script_use'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
									</tr>
									<!-- <tr>
										<td>b</td>
										<td colspan=2>Call Acknowledgement</td>
										<td>20</td>
										<td class="eml">Business</td>
										<td>
											<select class="form-control loanxm_point business section5" id="idfc_new_AF2" name="data[call_acknowledge]" required>
												<option value="">-Select-</option>
												<option loanxm_val=0 <?php //echo $loanxm['call_acknowledge'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option loanxm_val=0 <?php //echo $loanxm['call_acknowledge'] == "No"?"selected":"";?> value="No">No</option>
												<option loanxm_val=0 <?php //echo $loanxm['call_acknowledge'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
									</tr> -->
									<tr>
										<td>b</td>
										<td colspan=2>Timely Response</td>
										<td>20</td>
										<td class="eml">Business</td>
										<td>
											<select class="form-control loanxm_point business section5" id="idfc_new_AF2" name="data[timely_response]" disabled>
												<option value="">-Select-</option>
												<option loanxm_val=0 <?php echo $loanxm['timely_response'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option loanxm_val=0 <?php echo $loanxm['timely_response'] == "No"?"selected":"";?> value="No">No</option>
												<option loanxm_val=0 <?php echo $loanxm['timely_response'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
									</tr>
									<tr>
										<td>c</td>
										<td colspan=2>Failure to Disposition TMI</td>
										<td>20</td>
										<td class="eml">Business</td>
										<td>
											<select class="form-control loanxm_point business section5" id="idfc_new_AF2" name="data[TMI]" disabled="">
												<option value="">-Select-</option>
												<option loanxm_val=0 <?php echo $loanxm['TMI'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option loanxm_val=0 <?php echo $loanxm['TMI'] == "No"?"selected":"";?> value="No">No</option>
												<option loanxm_val=0 <?php echo $loanxm['TMI'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
									</tr>




									<tr>
										<td>Call Summary:</td>
										<td colspan="2"><textarea class="form-control" disabled><?php echo $loanxm['call_summary'] ?></textarea></td>
										<td>Feedback:</td>
										<td colspan="2"><textarea class="form-control" disabled><?php echo $loanxm['feedback'] ?></textarea></td>
									</tr>
									
									<?php if($loanxm['attach_file']!=''){ ?>
										<tr oncontextmenu="return false;">
											<td colspan="2">Audio Files</td>
											<td colspan="4">
												<?php $attach_file = explode(",",$loanxm['attach_file']);
												 foreach($attach_file as $mp){ ?>
													<audio controls='' style="background-color:#607F93"> 
													  <source src="<?php echo base_url(); ?>qa_files/qa_loanxm/<?php echo $mp; ?>" type="audio/ogg">
													  <source src="<?php echo base_url(); ?>qa_files/qa_loanxm/<?php echo $mp; ?>" type="audio/mpeg">
													</audio> </br>
												 <?php } ?>
											</td>
										</tr>
									<?php } ?>
									
									<tr><td colspan="6" style="background-color:#C5C8C8"></td></tr>
									
									<tr><td style="font-size:16px">Manager Review:</td> <td colspan="5" style="text-align:left"><?php echo $loanxm['mgnt_rvw_note'] ?></td></tr>
									<tr><td style="font-size:16px">Client Review:</td> <td colspan="5" style="text-align:left"><?php echo $loanxm['client_rvw_note'] ?></td></tr>
									
									<tr><td colspan="6" style="background-color:#C5C8C8"></td></tr>
									
									<form id="form_agent_user" method="POST" action="">
									 <input type="hidden" name="pnid" class="form-control" value="<?php echo $pnid; ?>">
										
										<tr>
											<td colspan=2 style="font-size:16px">Feedback Acceptance</td>
											<td colspan=2>
												<select class="form-control" id="" name="agnt_fd_acpt" required>
													<option value="">--Select--</option>
													<option <?php echo $loanxm['agnt_fd_acpt']=='Acceptance'?"selected":""; ?> value="Acceptance">Acceptance</option>	
													<option <?php echo $loanxm['agnt_fd_acpt']=='Not Acceptance'?"selected":""; ?> value="Not Acceptance">Not Acceptance</option>	
												</select>
											</td>
										</tr>
										<tr>
											<td colspan=2 style="font-size:16px">Your Review</td>
											<td colspan=4><textarea class="form-control" name="note" required><?php echo $loanxm['agent_rvw_note'] ?></textarea></td>
										</tr>
										
										<?php if(is_access_qa_agent_module()==true){
										if(is_available_qa_feedback($loanxm['entry_date'],72) == true){ ?>
											<tr>
												<?php if($loanxm['agent_rvw_note']==''){ ?>
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
