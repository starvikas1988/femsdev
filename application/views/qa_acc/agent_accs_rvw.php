<style>
	.table>tbody>tr>td {
		text-align: center;
		font-size: 13px;
	}

	#theader {
		font-size: 20px;
		font-weight: bold;
	}

	.eml {
		background-color: #85C1E9;
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
									<!--tr style="background-color:#AEB6BF"-->
									<tr style="background-color:#008080; font-size:40px;color:yellow">
										<td colspan="8" id="theader" style="font-size:30px">ACC  QA Form  Agent </td>
									</tr>





									<tr>
										<td>QA Name:</td>
										<?php if ($agent_accs_rvw['entry_by'] != '') {
											$auditorName = $agent_accs_rvw['auditor_name'];
										} else {
											$auditorName = $agent_accs_rvw['client_name'];
										} ?>
										<td style="width: 230px;"><input type="text" class="form-control" value="<?php echo $auditorName; ?>" disabled></td>
										<td>Audit Date:.</td>
										<td style="width:230px;"><input type="text" class="form-control" value="<?php echo mysql2mmddyy($agent_accs_rvw['audit_date']); ?>" disabled></td>
										<td>Call Date:.</td>
										<td colspan="2"><input type="text" class="form-control" value="<?php echo mysql2mmddyy($agent_accs_rvw['call_date']); ?>" disabled></td>
									</tr>
									<tr>
										<td>Agent Name:.</td>
										<td>
											<select class="form-control" id="agent_id" name="data[agent_id]" disabled>
												<option value="<?php echo $agent_accs_rvw['agent_id'] ?>"><?php echo $agent_accs_rvw['fname'] . " " . $agent_accs_rvw['lname'] ?></option>
											</select>
										</td>
										<td>Fusion ID:.</td>
										<td><input type="text" class="form-control" id="fusion_id" value="<?php echo $agent_accs_rvw['fusion_id'] ?>" readonly></td>
										<td>L1 Supervisor:.</td>
										<td colspan="2">
											<select class="form-control" id="tl_id" name="data[tl_id]" readonly>
												<option value="<?php echo $agent_accs_rvw['tl_id'] ?>"><?php echo $agent_accs_rvw['tl_name'] ?></option>
											</select>
										</td>
									</tr>
									<tr>

										<td>Call ID:.</td>
										<td><input type="text" class="form-control" name="data[call_id]" value="<?php echo $agent_accs_rvw['call_id'] ?>" disabled></td>
										<td>VOC:.</td>
										<td>
											<select class="form-control" id="voc" name="data[voc]" disabled>
												<option value="<?php echo $agent_accs_rvw['voc'] ?>"><?php echo $agent_accs_rvw['voc'] ?></option>
											</select>
										</td>
										<td> Type of Audit:.</td>
										<td colspan="2">
											<select class="form-control" id="audit_type" name="data[audit_type]" disabled>
												<option value="<?php echo $agent_accs_rvw['audit_type'] ?>"><?php echo $agent_accs_rvw['audit_type'] ?></option>
											</select>
										</td>

									</tr>
									<tr>
									</tr>
									<?php $auditor_type = $agent_accs_rvw['audit_type'];
									if ($auditor_type == 'Calibration') { ?>
										<td class="auType_epi">Auditor Type</td>
										<td>

											<select class="form-control" id="auditor_type" name="data[auditor_type]" disabled>
												<option value="<?php echo $agent_accs_rvw['auditor_type'] ?>"><?php echo $agent_accs_rvw['auditor_type'] ?></option>
											</select>
										</td>

									<?php  } ?>

									<tr>
										<td> Interaction: Initial Call :<span style="font-size:24px;color:red">*</span></td>
										<td>
											<select class="form-control"  disabled id="Initial" name="data[Initial]">
												<option  <?php echo$agent_accs_rvw['Initial'] == "Yes" ? "selected" : ""; ?> value="Yes">Yes </option>
												<option  <?php echo$agent_accs_rvw['Initial'] == "No" ? "selected" : ""; ?> value="No">No </option>

											</select>
										</td>
										<td>Interaction: Follow Up 1 :<span style="font-size:24px;color:red">*</span></td>
										<td>
											<select class="form-control"  disabled id="up1" name="data[up1]">
												<option  <?php echo$agent_accs_rvw['up1'] == "Yes" ? "selected" : ""; ?> value="Yes">Yes </option>
												<option  <?php echo$agent_accs_rvw['up1'] == "No" ? "selected" : ""; ?> value="No">No </option>

											</select>
										</td>
										<td> Interaction: Follow Up 2:<span style="font-size:24px;color:red">*</span></td>
										<td>
											<select class="form-control"  disabled id="up2" name="data[up2]">
												<option  <?php echo$agent_accs_rvw['up2'] == "Yes" ? "selected" : ""; ?> value="Yes">Yes </option>
												<option  <?php echo$agent_accs_rvw['up2'] == "No" ? "selected" : ""; ?> value="No">No </option>

											</select>
										</td>
									</tr>


									<tr>
											<td> Infraction  :<span style="font-size:24px;color:black">*</span></td>
											<td>
												<select class="form-control"  disabled id="form_submits" name="data[form_submits]">
													<option dna_max=0 dna_val=0<?php echo $agent_accs_rvw['form_submits'] == "Yes" ? "selected" : ""; ?> value="Yes">Yes </option>
													<option dna_max=0 dna_val=0<?php echo $agent_accs_rvw['form_submits'] == "No" ? "selected" : ""; ?> value="No">No </option>

												</select>
											</td>
											<td>Phone Number::<span style="font-size:24px;color:red">*</span></td>
											<td><input type="text" class="form-control" name="data[phone_no]" value="<?php echo$agent_accs_rvw['phone_no'] ?>" disabled></td>
											<td> Sale:<span style="font-size:24px;color:red">*</span></td>
											<td>
												<select class="form-control"  disabled id="sales" name="data[sales]">
													<option  <?php echo$agent_accs_rvw['sales'] == "Yes" ? "selected" : ""; ?> value="Yes">Yes </option>
													<option  <?php echo$agent_accs_rvw['sales'] == "No" ? "selected" : ""; ?> value="No">No </option>

												</select>
											</td>
										</tr>
									</tr>
									<?php $form_submits =$agent_accs_rvw['form_submits'];
									if ($form_submits == 'Yes') { ?>
										<td class="auType_epis">Reason <span style="font-size:24px;color:red">*</span></td>
										<td>
									<input type="text" class="form-control" name="data[extra]" value="<?php echo $agent_accs_rvw['extra'] ?>" disabled>

										</td>

									<?php  } ?>
										<tr>
											<td>  Disposition :<span style="font-size:24px;color:red">*</span></td>
											<td>
												<select class="form-control"  disabled id="Disposition" name="data[Disposition]">
													<option  <?php echo$agent_accs_rvw['Disposition'] == "Yes" ? "selected" : ""; ?> value="Yes">Yes </option>
													<option  <?php echo$agent_accs_rvw['Disposition'] == "No" ? "selected" : ""; ?> value="No">No </option>

												</select>
											</td>
										  <td>UCID:<span style="font-size:24px;color:red">*</span></td>
										  <td><input type="text" class="form-control" name="data[UCID]" value="<?php echo$agent_accs_rvw['UCID'] ?>" disabled></td>
										</tr>







									<tr>

										<td>Earned Score:</td>
										<td><input type="text" readonly name="data[earned_score]" class="form-control" style="font-weight:bold" value="<?php echo $agent_accs_rvw['earned_score'] ?>"></td>
										<td>Possible Score:</td>
										<td><input type="text" readonly name="data[possible_score]" class="form-control" style="font-weight:bold" value="<?php echo $agent_accs_rvw['possible_score'] ?>"></td>
										<td style="font-weight:bold; font-size:12px; text-align:right">Overall Score:</td>
										<td colspan="2"><input type="text" readonly name="data[overall_score]" class="form-control agent_wireless_dnaFatal" style="font-weight:bold" value="<?php $percentage = $agent_accs_rvw['overall_score'];
																																															echo       round($percentage, 2) . "% ";  ?>"></td>

									</tr>
									<tr>

									</tr>
									<!--tr style="background-color:#85C1E9; font-weight:bold"-->
									<tr style="background-color:#008080; font-size:40px;color:yellow;font-weight:bold">
									<td>Parameter</td>
									<!--td> Overall Weight</td-->
									<td colspan=2>Sub Parameter</td>
									<td> Weight</td>

									<td style="width:200px;">Defect</td>


									<td style="width:250px;display:inline-block;border:none;"> Reason</td>
								</tr>
										<!-- start--->

										<tr>
											<!--td rowspan=4 style="background-color:#85C1E9; font-weight:bold">Opening </td-->
											<td rowspan=3 style="background-color:#123456;color:white; font-weight:bold">Initial </td>
											<td colspan=2 style="color:black"> Opening </td>
											<!--td> The agent uses suggested opening spiel. <br> The opening spiel was delivered clearly and enthusiastically; not rushed or clipped. </td-->
											<td> 3</td>

											<td>
												<select class="form-control " id="Opening" name="data[Opening]" disabled>

													<option <?php echo$agent_accs_rvw['Opening'] == "Yes" ? "selected" : ""; ?> value="Yes">Yes </option>
													<option <?php echo$agent_accs_rvw['Opening'] == "No" ? "selected" : ""; ?> value="No">No </option>
													<option <?php echo$agent_accs_rvw['Opening'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A </option>
												</select>
											</td>
											<td><input type="text" class="form-control" name="data[Opening_reason]" value="<?php echo$agent_accs_rvw['Opening_reason']; ?>" disabled></td>
										</tr>
										<tr>
											<td colspan=2> Greeting</td>
											<!---td> Agent must read and ask the customer's understanding about the terms and condition when applying for a SIMCARD. </td--->
											<td> 3</td>

											<td>
												<select class="form-control " id="Greeting" name="data[Greeting]" disabled>

													<option <?php echo$agent_accs_rvw['Greeting'] == "Yes" ? "selected" : ""; ?> value="Yes">Yes</option>
													<option <?php echo$agent_accs_rvw['Greeting'] == "No" ? "selected" : ""; ?> value="No">No</option>
													<option <?php echo$agent_accs_rvw['Greeting'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>

												</select>
											</td>
											<td><input type="text" class="form-control" name="data[Greeting_reason]" value="<?php echo$agent_accs_rvw['Greeting_reason']; ?>" disabled></td>
										</tr>


										<tr>

											<!-- start-->

											<td colspan=2 style="color:black">Owner Discovery </td>
											<!--td> The agent should ablle to identify and understand the issue of the customer / Good comprehension skill</td-->
											<td> 7</td>

											<td>
												<select class="form-control " id="Discovery" name="data[Discovery]" disabled>


													<option <?php echo$agent_accs_rvw['Discovery'] == "Yes" ? "selected" : "";
															?> value="Yes">Yes</option>
													<option <?php echo$agent_accs_rvw['Discovery'] == "No" ? "selected" : "";
															?> value="No">No</option>
													<option <?php echo$agent_accs_rvw['Discovery'] == "N/A" ? "selected" : "";
															?> value="N/A">N/A</option>

												</select>
											</td>
											<td><input type="text" class="form-control" name="data[Discovery_reason]" value="<?php echo$agent_accs_rvw['Discovery_reason']; ?>" disabled></td>

										</tr>
										<tr>

											<td  style="background-color:#123456;color:white; font-weight:bold">Soft Skill </td>
											<td colspan=2 style="color:black"> Professionalism</td>
											<!--td> Agent should follow the hold procedures like "May I place this line on hold for 2 minutes? I will just check my resources"</td-->
											<td> 5</td>

											<td>
												<select class="form-control " id="Professionalism" name="data[Professionalism]" disabled>


													<option <?php echo$agent_accs_rvw['Professionalism'] == "Yes" ? "selected" : "";
															?> value="Yes">Yes</option>
													<option <?php echo$agent_accs_rvw['Professionalism'] == "No" ? "selected" : "";
															?> value="No">No</option>
													<option <?php echo$agent_accs_rvw['Professionalism'] == "N/A" ? "selected" : "";
															?> value="N/A">N/A</option>

												</select>
											</td>
											<td><input type="text" class="form-control" name="data[Professionalism_reason]" value="<?php echo$agent_accs_rvw['Professionalism_reason']; ?>" disabled></td>
										</tr>
										<tr>
												<td rowspan=6 style="background-color:#123456;color:white; font-weight:bold">Call handling </td>
											<!--end-->
											<td colspan=2>Rebuttals</td>
											<!--td> Dead air should not be more than 10 seconds.</td-->
											<td> 10</td>

											<td>
												<select class="form-control " id="Rebuttals" name="data[Rebuttals]" disabled>


													<option <?php echo$agent_accs_rvw['Rebuttals'] == "Yes" ? "selected" : "";
															?> value="Yes">Yes</option>
													<option <?php echo$agent_accs_rvw['Rebuttals'] == "No" ? "selected" : "";
															?> value="No">No</option>
													<option <?php echo$agent_accs_rvw['Rebuttals'] == "N/A" ? "selected" : "";
															?> value="N/A">N/A</option>


												</select>
											</td>
											<td><input type="text" class="form-control" name="data[Rebuttals_reason]" value="<?php echo$agent_accs_rvw['Rebuttals_reason']; ?>" disabled></td>
										</tr>
										<tr>
											<td colspan=2>Urgency </td>
											<!--td> The agent should pause whenever there's an Urgency / apologize if necessary</td-->
											<td> 8</td>

											<td>
												<select class="form-control " id="Urgency" name="data[Urgency]" disabled>

													<option <?php echo$agent_accs_rvw['Urgency'] == "Yes" ? "selected" : "";
															?> value="Yes">Yes</option>
													<option <?php echo$agent_accs_rvw['Urgency'] == "No" ? "selected" : "";
															?> value="No">No</option>
													<option <?php echo$agent_accs_rvw['Urgency'] == "N/A" ? "selected" : "";
															?> value="N/A">N/A</option>
												</select>
											</td>
											<td><input type="text" class="form-control" name="data[Urgency_reason]" value="<?php echo$agent_accs_rvw['Urgency_reason']; ?>" disabled></td>
										</tr>
										<tr>
											<td colspan=2>Education regarding Change and improvement customer would get</td>
											<!--td>It is important that the agent engaes with the customer to build a more personalized conversation. Agent should find an opportunity to start a conversation based on the information provided by the customer.</td-->
											<td> 10</td>

											<td>
												<select class="form-control " id="Education" name="data[Education]" disabled>


													<option <?php echo$agent_accs_rvw['Education'] == "Yes" ? "selected" : "";
															?> value="Yes">Yes</option>
													<option <?php echo$agent_accs_rvw['Education'] == "No" ? "selected" : "";
															?> value="No">No</option>
													<option <?php echo$agent_accs_rvw['Education'] == "N/A" ? "selected" : "";
															?> value="N/A">N/A</option>

												</select>
											</td>
											<td><input type="text" class="form-control" name="data[Education_reason]" value="<?php echo$agent_accs_rvw['Education_reason']; ?>" disabled></td>
										</tr>

										<tr>
											<!--td rowspan=4 style="background-color:#85C1E9; font-weight:bold">Resolution </td-->

											<td colspan=2>Resolution/Assistance if customer use any other provider </td>


											<td> 5</td>

											<td>
												<select class="form-control " id="Resolution" name="data[Resolution]" disabled>


													<option <?php echo$agent_accs_rvw['Resolution'] == "Yes" ? "selected" : "";
															?> value="Yes">Yes</option>
													<option <?php echo$agent_accs_rvw['Resolution'] == "No" ? "selected" : "";
															?> value="No">No</option>

													<option <?php echo$agent_accs_rvw['Resolution'] == "N/A" ? "selected" : "";
															?> value="N/A">N/A</option>
												</select>
											</td>
											<td><input type="text" class="form-control" name="data[Resolution_reason]" value="<?php echo$agent_accs_rvw['Resolution_reason']; ?>" disabled></td>
										</tr>
										<tr>
											<td colspan=2>Adequate Probing </td>
											<!--td> Agent must ask only necessary questions that will lead to the customer concerns. <br> Agent must ask the travel dates,passport name,email address,billing address and the serial number of the SIMCARD.</td-->
											<td>7</td>

											<td>
												<select class="form-control " id="Probing" name="data[Probing]" disabled>

													<option <?php echo$agent_accs_rvw['Probing'] == "Yes" ? "selected" : "";
															?> value="Yes">Yes</option>
													<option <?php echo$agent_accs_rvw['Probing'] == "No" ? "selected" : "";
															?> value="No">No</option>
													<option <?php echo$agent_accs_rvw['Probing'] == "N/A" ? "selected" : "";
															?> value="N/A">N/A</option>

												</select>
											</td>
											<td><input type="text" class="form-control" name="data[Probing_reason]" value="<?php echo$agent_accs_rvw['Probing_reason']; ?>" disabled></td>
										</tr>

											<!-- start -->
										<tr>

											<td colspan=2>Product Knowledge</td>
											<!--td> Agent must document key points in the conversation</td-->
											<td> 10</td>

											<td>
												<select class="form-control" id="Knowledge" name="data[Knowledge]" disabled>
													<option <?php echo$agent_accs_rvw['Knowledge'] == "Yes" ? "selected" : "";
															?> value="Yes">Yes</option>
													<option <?php echo$agent_accs_rvw['Knowledge'] == "No" ? "selected" : "";
															?> value="No">No</option>
													<option <?php echo$agent_accs_rvw['Knowledge'] == "N/A" ? "selected" : "";
															?> value="N/A">N/A</option>




												</select>
											</td>
											<td><input type="text" class="form-control" name="data[Knowledge_reason]" value="<?php echo$agent_accs_rvw['Knowledge_reason']; ?>" disabled></td>
										</tr>


										<tr>
											<td rowspan=4 style="background-color:#123456;color:white; font-weight:bold">Sales </td>
											<td colspan=2>Correct Information</td>
											<!--td> The agent must choose the correct/most appropriate disposition based on the main reason for calling.</td--->
											<td> 10</td>

											<td>
												<select class="form-control" id="Information" name="data[Information]" disabled>

													<option <?php echo$agent_accs_rvw['Information'] == "Yes" ? "selected" : "";
															?> value="Yes">Yes</option>
													<option <?php echo$agent_accs_rvw['Information'] == "No" ? "selected" : "";
															?> value="No">No</option>
													<option <?php echo$agent_accs_rvw['Information'] == "N/A" ? "selected" : "";
															?> value="N/A">N/A</option>

												</select>
											</td>
											<td><input type="text" class="form-control" name="data[Information_reason]" value="<?php echo$agent_accs_rvw['Information_reason']; ?>" disabled></td>
										</tr>













										<tr>
											<td colspan=2>On call resolution</td>
											<!--td> The agent must choose the correct/most appropriate disposition based on the main reason for calling.</td--->
											<td> 5</td>

											<td>
												<select class="form-control" id="assistance" name="data[assistance]" disabled>

													<option <?php echo$agent_accs_rvw['assistance'] == "Yes" ? "selected" : "";
															?> value="Yes">Yes</option>
													<option <?php echo$agent_accs_rvw['assistance'] == "No" ? "selected" : "";
															?> value="No">No</option>
													<option <?php echo$agent_accs_rvw['assistance'] == "N/A" ? "selected" : "";
															?> value="N/A">N/A</option>

												</select>
											</td>
											<td><input type="text" class="form-control" name="data[assistance_reason]" value="<?php echo$agent_accs_rvw['assistance_reason']; ?>" disabled></td>
										</tr>

										<tr>


											<!---end--->







											<td colspan=2 style="color:red">Contract Prompt</td>
											<!--td> The agent asks additional assistance before ending the call.</td-->
											<td> 12</td>

											<td>
												<select class="form-control" id="prompt" name="data[prompt]" disabled>


													<option <?php echo$agent_accs_rvw['prompt'] == "Yes" ? "selected" : "";
															?> value="Yes">Yes</option>

													<option <?php echo$agent_accs_rvw['prompt'] == "No" ? "selected" : "";
															?> value="No">No</option>
													<option <?php echo$agent_accs_rvw['prompt'] == "N/A" ? "selected" : "";
															?> value="N/A">N/A</option>


												</select>
											</td>
											<td><input type="text" class="form-control" name="data[prompt_reason]" value="<?php echo$agent_accs_rvw['prompt_reason']; ?>" disabled></td>
										</tr>
										<tr>
											<td colspan=2 style="color:black">Closing</td>
											<!--td> The agent uses suggested closing spiel based on channel</td-->
											<td> 5</td>

											<td>
												<select class="form-control" id="Closing" name="data[Closing]" disabled>


													<option <?php echo$agent_accs_rvw['Closing'] == "Yes" ? "selected" : "";
															?> value="Yes">Yes</option>

													<option <?php echo$agent_accs_rvw['Closing'] == "No" ? "selected" : "";
															?> value="No">No</option>
													<option <?php echo$agent_accs_rvw['Closing'] == "N/A" ? "selected" : "";
															?> value="N/A">N/A</option>





												</select>
											</td>
											<td><input type="text" class="form-control" name="data[Closing_reason]" value="<?php echo$agent_accs_rvw['Closing_reason']; ?>" disabled></td>

										</tr>
										<tr>

										</tr>











									<tr>
										<td>Call Observation:</td>
										<td colspan=2><textarea class="form-control" readonly name="data[call_summary]"><?php echo $agent_accs_rvw['call_summary'] ?></textarea></td>
										<td>Feedback:</td>
										<td colspan="4"><textarea class="form-control" readonly name="data[feedback]"><?php echo $agent_accs_rvw['feedback'] ?></textarea></td>
									</tr>


									<tr>

										<td> Attached File </td>
										<td colspan="7">
											<?php
											if ($agent_accs_rvw['attach_file'] != '') {
												$attach_file = explode(",", $agent_accs_rvw['attach_file']);
												foreach ($attach_file as $mp) {
											?>
													<audio controls='' style="width:120px; height:25px; background-color:#607F93">
														<source src="<?php echo base_url(); ?>qa_files/qa_accs/inbound/<?php echo $mp; ?>" type="audio/ogg">
														<source src="<?php echo base_url(); ?>qa_files/qa_accs/inbound/<?php echo $mp; ?>" type="audio/mpeg">
													</audio>
											<?php }
											} else {
												echo "Not Avaliable ";
											}	?>
										</td>
									</tr>


									<tr>
										<td colspan="8" style="background-color:#9FE2BF"></td>
									</tr>

									<tr>
										<td style="font-size:12px">Manager Review:</td>
										<td colspan="8" style="text-align:left"><?php echo $agent_accs_rvw['mgnt_rvw_note'] ?></td>
									</tr>


									<tr>
										<td colspan="8" style="background-color:#9FE2BF"></td>
									</tr>

									<form id="form_agent_user" method="POST" action="">
										<input type="hidden" name="pnid" class="form-control" value="<?php echo $pnid; ?>">

										<!--  had--->



										<!---end-- had-->

										<?php if (is_access_qa_agent_module() == true) {
											if (is_available_qa_feedback($agent_accs_rvw['entry_date'], 72) == true) { ?>




												<tr>
													<?php if ($agent_accs_rvw['agent_rvw_note'] == '') { ?>

														<!-- add--->
												<tr>
													<td colspan=2 style="font-size:12px">Feedback Status</td>
													<td colspan=5>
														<select class="form-control" id="" name="agnt_fd_acpt" required>
															<option value="">--Select--</option>
															<option <?php echo $agent_accs_rvw['agnt_fd_acpt'] == 'Accepted' ? "selected" : ""; ?> value="Accepted">Acceptaned</option>
															<option <?php echo $agent_accs_rvw['agnt_fd_acpt'] == 'Not Accepted' ? "selected" : ""; ?> value="Not Accepted">Not Accepted</option>
														</select>
													</td>
												</tr>
												<tr>
													<td colspan=2 style="font-size:12px">Agent Review</td>
													<td colspan=5><textarea class="form-control" name="note"><?php echo $agent_accs_rvw['agent_rvw_note'] ?></textarea></td>
												</tr>

												<!--end--->




												<td colspan="8"><button class="btn btn-success waves-effect" type="submit" id='btnagentSave' name='btnSave' value="SAVE" style="width:500px">SAVE</button></td>
											<?php } else if ($agent_accs_rvw['agent_rvw_note'] != '') { ?>
												<tr>
													<td style="font-size:12px">Agent Review:</td>
													<td colspan="7" style="text-align:left"><?php echo $agent_accs_rvw['agent_rvw_note'] ?></td>
												</tr><?php
													}






														?>
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
		</div>

	</section>
</div>
