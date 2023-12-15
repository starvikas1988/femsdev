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
									<tr style="background-color:Purple; font-size:40px;color:yellow">
										<td colspan="8" id="theader" style="font-size:30px"> Wireless DNA QA Form Edit </td>
									</tr>

									<?php foreach ($dna_list as $dna) {         ?>




										<tr>
											<td>QA Name:<span style="font-size:24px;color:red">*</span></td>
											<?php if ($dna['entry_by'] != '') {
												$auditorName = $dna['auditor_name'];
											} else {
												$auditorName = $dna['client_name'];
											} ?>
											<td style="width: 230px;"><input type="text" class="form-control" value="<?php echo $auditorName; ?>" disabled></td>
											<td>Audit Date:<span style="font-size:24px;color:red">*</span></td>
											<td style="width: 230px;"><input type="text" class="form-control" value="<?php echo mysql2mmddyy($dna['audit_date']); ?>" disabled></td>
											<td>Call Date:<span style="font-size:24px;color:red">*</span></td>
											<td colspan="2"><input type="text" class="form-control" value="<?php echo mysql2mmddyy($dna['call_date']); ?>" disabled></td>
										</tr>
										<tr>
											<td>Agent Name:<span style="font-size:24px;color:red">*</span></td>
											<td>
												<select class="form-control" id="agent_id" name="data[agent_id]" disabled>
													<option value="<?php echo $dna['agent_id'] ?>"><?php echo $dna['fname'] . " " . $dna['lname'] ?></option>
												</select>
											</td>
											<td>Fusion ID:<span style="font-size:24px;color:red">*</span></td>
											<td><input type="text" class="form-control" id="fusion_id" value="<?php echo $dna['fusion_id'] ?>" readonly></td>
											<td>L1 Supervisor:<span style="font-size:24px;color:red">*</span></td>
											<td colspan="2">
												<select class="form-control" id="tl_id" name="data[tl_id]" readonly>
													<option value="<?php echo $dna['tl_id'] ?>"><?php echo $dna['tl_name'] ?></option>
												</select>
											</td>
										</tr>
										<tr>

											<td>Call ID:<span style="font-size:24px;color:red">*</span></td>
											<td><input type="text" class="form-control" name="data[call_id]" value="<?php echo $dna['call_id'] ?>" disabled></td>
											<td>VOC:<span style="font-size:24px;color:red">*</span></td>
											<td>
												<select class="form-control" id="voc" name="data[voc]" disabled>
													<option value="<?php echo $dna['voc'] ?>"><?php echo $dna['voc'] ?></option>
												</select>
											</td>
											<td> Type of Audit:<span style="font-size:24px;color:red">*</span></td>
											<td colspan="2">
												<select class="form-control" id="audit_type" name="data[audit_type]" disabled>
													<option value="<?php echo $dna['audit_type'] ?>"><?php echo $dna['audit_type'] ?></option>
												</select>
											</td>

										</tr>
										<?php $auditor_type = $dna['audit_type'];
										if ($auditor_type == 'Calibration') { ?>
											<td class="auType_epi">Auditor Type <span style="font-size:24px;color:red">*</span></td>
											<td>

												<select class="form-control" id="auditor_type" name="data[auditor_type]" disabled>
													<option value="<?php echo $dna['auditor_type'] ?>"><?php echo $dna['auditor_type'] ?></option>
												</select>
											</td>

										<?php  } ?>
										
										
										<tr>
											<td> Form Submitted :<span style="font-size:24px;color:red">*</span></td>
											<td>
												<select class="form-control"  disabled id="form_submits" name="data[form_submits]">
													<option  <?php echo $dna['form_submits'] == "Yes" ? "selected" : ""; ?> value="Yes">Yes </option>
													<option  <?php echo $dna['form_submits'] == "No" ? "selected" : ""; ?> value="No">No </option>
													
												</select>
											</td>
										</tr>
										
										
										<tr>

											<td>Earned Score:<span style="font-size:24px;color:red">*</span></td>
											<td><input type="text" readonly name="data[earned_score]" class="form-control wireless" style="font-weight:bold" value="<?php echo $dna['earned_score']  ?>"></td>
											<td>Possible Score:<span style="font-size:24px;color:red">*</span></td>
											<td><input type="text" readonly name="data[possible_score]" class="form-control wireless" style="font-weight:bold" value="<?php echo $dna['possible_score'] ?>"></td>
											<td style="font-weight:bold; font-size:16px; text-align:right">Overall Score:</td>
											<td colspan="2"><input type="text" readonly id="overall_score" name="data[overall_score]" class="form-control" style="font-weight:bold" value="<?php $percentage = $dna['overall_score'];
																																															echo       round($percentage, 2) . "% ";  ?>"></td>

										</tr>
										
										<!--tr style="background-color:#85C1E9; font-weight:bold"-->
										<tr style="background-color:#008080; font-size:40px;color:yellow;font-weight:bold">
										<td>Parameter</td>
										<!--td> Overall Weight</td-->
										<td colspan=2>Sub Parameter</td>
										<td> Weight</td>
										<td>Criticality </td>
										<td style="width:200px;">Defect</td>


										<td style="width:250px;display:inline-block;border:none;"> Reason</td>
									</tr>
										<!-- start--->

										<tr>
											<!--td rowspan=4 style="background-color:#85C1E9; font-weight:bold">Opening </td-->
											<td rowspan=4 style="background-color:#123456;color:white; font-weight:bold">Opening </td>
											<td colspan=2 style="color:black"> Used suggestede opening spiel </td>
											<!--td> The agent uses suggested opening spiel. <br> The opening spiel was delivered clearly and enthusiastically; not rushed or clipped. </td-->
											<td> 7.5 </td>
											<td style="color:green;font-weight:bold">Customer </td>
											<td>
												<select class="form-control " id="used_suggested_opening_spiel" name="data[used_suggested_opening_spiel]" disabled>

													<option <?php echo $dna['used_suggested_opening_spiel'] == "Yes" ? "selected" : ""; ?> value="Yes">Yes </option>
													<option <?php echo $dna['used_suggested_opening_spiel'] == "No" ? "selected" : ""; ?> value="No">No </option>
													<option <?php echo $dna['used_suggested_opening_spiel'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A </option>
												</select>
											</td>
											<td><input type="text" class="form-control" name="data[used_suggested_opening_spiel_reason]" value="<?php echo $dna['used_suggested_opening_spiel_reason']; ?>" disabled></td>
										</tr>
										<tr>
											<td colspan=2> Obtained Customer's Consent</td>
											<!---td> Agent must read and ask the customer's understanding about the terms and condition when applying for a SIMCARD. </td--->
											<td> 7.5</td>
											<td style="color:green;font-weight:bold">Customer </td>
											<td>
												<select class="form-control " id="obtained_customer_consent" name="data[obtained_customer_consent]" disabled>

													<option <?php echo $dna['obtained_customer_consent'] == "Yes" ? "selected" : ""; ?> value="Yes">Yes</option>
													<option <?php echo $dna['obtained_customer_consent'] == "No" ? "selected" : ""; ?> value="No">No</option>
													<option <?php echo $dna['obtained_customer_consent'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>

												</select>
											</td>
											<td><input type="text" class="form-control" name="data[obtained_customer_consent_reason]" value="<?php echo $dna['obtained_customer_consent_reason']; ?>" disabled></td>
										</tr>

										<tr>

											<!-- start--->


										</tr>
										<tr>



											<!---end---->
										</tr>
										<tr>
											<td rowspan=5 style="background-color:#123456;color:white; font-weight:bold">Call Control </td>
											<!-- start-->

											<td colspan=2 style="color:black">Active Listening/Reading </td>
											<!--td> The agent should ablle to identify and understand the issue of the customer / Good comprehension skill</td-->
											<td> 4</td>
											<td style="color:green;font-weight:bold">Customer </td>
											<td>
												<select class="form-control " id="active_listening_or_reading" name="data[active_listening_or_reading]" disabled>


													<option <?php echo $dna['active_listening_or_reading'] == "Yes" ? "selected" : "";
															?> value="Yes">Yes</option>
													<option <?php echo $dna['active_listening_or_reading'] == "No" ? "selected" : "";
															?> value="No">No</option>
													<option <?php echo $dna['active_listening_or_reading'] == "N/A" ? "selected" : "";
															?> value="N/A">N/A</option>

												</select>
											</td>
											<td><input type="text" class="form-control" name="data[active_listening_or_reading_reason]" value="<?php echo $dna['active_listening_or_reading_reason']; ?>" disabled></td>

										</tr>
										<tr>
											<td colspan=2 style="color:black"> Proper Hold Procedure</td>
											<!--td> Agent should follow the hold procedures like "May I place this line on hold for 2 minutes? I will just check my resources"</td-->
											<td> 4</td>
											<td style="color:green;font-weight:bold">Customer </td>
											<td>
												<select class="form-control " id="proper_hold_procedure" name="data[proper_hold_procedure]" disabled>


													<option <?php echo $dna['proper_hold_procedure'] == "Yes" ? "selected" : "";
															?> value="Yes">Yes</option>
													<option <?php echo $dna['proper_hold_procedure'] == "No" ? "selected" : "";
															?> value="No">No</option>
													<option <?php echo $dna['proper_hold_procedure'] == "N/A" ? "selected" : "";
															?> value="N/A">N/A</option>

												</select>
											</td>
											<td><input type="text" class="form-control" name="data[proper_hold_procedure_reason]" value="<?php echo $dna['proper_hold_procedure_reason']; ?>" disabled></td>
										</tr>
										<tr>
											<!--end-->
											<td colspan=2>Dead Air</td>
											<!--td> Dead air should not be more than 10 seconds.</td-->
											<td> 4</td>
											<td style="color:green;font-weight:bold">Customer </td>
											<td>
												<select class="form-control " id="dead_air" name="data[dead_air]" disabled>


													<option <?php echo $dna['dead_air'] == "Yes" ? "selected" : "";
															?> value="Yes">Yes</option>
													<option <?php echo $dna['dead_air'] == "No" ? "selected" : "";
															?> value="No">No</option>
													<option <?php echo $dna['dead_air'] == "N/A" ? "selected" : "";
															?> value="N/A">N/A</option>


												</select>
											</td>
											<td><input type="text" class="form-control" name="data[dead_air_reason]" value="<?php echo $dna['dead_air_reason']; ?>" disabled></td>
										</tr>
										<tr>
											<td colspan=2>Interruption </td>
											<!--td> The agent should pause whenever there's an interruption / apologize if necessary</td-->
											<td> 4</td>
											<td style="color:green;font-weight:bold">Customer </td>
											<td>
												<select class="form-control " id="interruption" name="data[interruption]" disabled>

													<option <?php echo $dna['interruption'] == "Yes" ? "selected" : "";
															?> value="Yes">Yes</option>
													<option <?php echo $dna['interruption'] == "No" ? "selected" : "";
															?> value="No">No</option>
													<option <?php echo $dna['interruption'] == "N/A" ? "selected" : "";
															?> value="N/A">N/A</option>
												</select>
											</td>
											<td><input type="text" class="form-control" name="data[interruption_reason]" value="<?php echo $dna['interruption_reason']; ?>" disabled></td>
										</tr>
										<tr>
											<td colspan=2>Customer Experience</td>
											<!--td>It is important that the agent engaes with the customer to build a more personalized conversation. Agent should find an opportunity to start a conversation based on the information provided by the customer.</td-->
											<td> 4</td>
											<td style="color:Olive; font-weight:bold"> Business </td>
											<td>
												<select class="form-control " id="customer_experience" name="data[customer_experience]" disabled>


													<option <?php echo $dna['customer_experience'] == "Yes" ? "selected" : "";
															?> value="Yes">Yes</option>
													<option <?php echo $dna['customer_experience'] == "No" ? "selected" : "";
															?> value="No">No</option>
													<option <?php echo $dna['customer_experience'] == "N/A" ? "selected" : "";
															?> value="N/A">N/A</option>

												</select>
											</td>
											<td><input type="text" class="form-control" name="data[customer_experience_reason]" value="<?php echo $dna['customer_experience_reason']; ?>" disabled></td>
										</tr>
										<tr>


										</tr>
										<tr>


										</tr>
										<tr>
											<!--td rowspan=4 style="background-color:#85C1E9; font-weight:bold">Resolution </td-->
											<td rowspan=4 style="background-color:#123456;color:white; font-weight:bold">Resolution </td>
											<td colspan=2>Complete And Accuracy Information </td>


											<td> 25</td>
											<td style="color:Orange; font-weight:bold"> Compliance </td>
											<td>
												<select class="form-control " id="complete_accurate_information" name="data[complete_accurate_information]" disabled>


													<option <?php echo $dna['complete_accurate_information'] == "Excellent" ? "selected" : "";
															?> value="Excellent">Excellent</option>
													<option <?php echo $dna['complete_accurate_information'] == "Good" ? "selected" : "";
															?> value="Good">Good</option>

													<option <?php echo $dna['complete_accurate_information'] == "Poor" ? "selected" : "";
															?> value="Poor">Poor</option>
												</select>
											</td>
											<td><input type="text" class="form-control" name="data[complete_accurate_information_reason]" value="<?php echo $dna['complete_accurate_information_reason']; ?>" disabled></td>
										</tr>
										<tr>
											<td colspan=2>Probing Question </td>
											<!--td> Agent must ask only necessary questions that will lead to the customer concerns. <br> Agent must ask the travel dates,passport name,email address,billing address and the serial number of the SIMCARD.</td-->
											<td>5</td>
											<td style="color:Olive; font-weight:bold"> Business </td>
											<td>
												<select class="form-control " id="probing_question" name="data[probing_question]" disabled>

													<option <?php echo $dna['probing_question'] == "Yes" ? "selected" : "";
															?> value="Yes">Yes</option>
													<option <?php echo $dna['probing_question'] == "No" ? "selected" : "";
															?> value="No">No</option>
													<option <?php echo $dna['probing_question'] == "N/A" ? "selected" : "";
															?> value="N/A">N/A</option>

												</select>
											</td>
											<td><input type="text" class="form-control" name="data[probing_question_reason]" value="<?php echo $dna['probing_question_reason']; ?>" disabled></td>
										</tr>
										<tr>


										</tr>
										<tr>

										</tr>
										<tr>
											<!-- start -->
										<tr>
											<td rowspan=4 style="background-color:#123456;color:white; font-weight:bold">Documentation </td>
											<td colspan=2>Complete and Accurate Notes</td>
											<!--td> Agent must document key points in the conversation</td-->
											<td> 10</td>
											<td style="color:Orange; font-weight:bold"> Compliance </td>
											<td>
												<select class="form-control" id="complete_accurate_notes" name="data[complete_accurate_notes]" disabled>
													<option <?php echo $dna['complete_accurate_notes'] == "Yes" ? "selected" : "";
															?> value="Yes">Yes</option>
													<option <?php echo $dna['complete_accurate_notes'] == "No" ? "selected" : "";
															?> value="No">No</option>
													<option <?php echo $dna['complete_accurate_notes'] == "N/A" ? "selected" : "";
															?> value="N/A">N/A</option>




												</select>
											</td>
											<td><input type="text" class="form-control" name="data[complete_accurate_notes_reason]" value="<?php echo $dna['complete_accurate_notes_reason']; ?>" disabled></td>
										</tr>
										<tr>
											<td colspan=2>Use Proper Deposition and Tagging </td>
											<!--td> The agent must choose the correct/most appropriate disposition based on the main reason for calling.</td--->
											<td> 10</td>
											<td style="color:Orange; font-weight:bold"> Compliance </td>
											<td>
												<select class="form-control" id="use_proper_disposition_tagging" name="data[use_proper_disposition_tagging]" disabled>

													<option <?php echo $dna['use_proper_disposition_tagging'] == "Yes" ? "selected" : "";
															?> value="Yes">Yes</option>
													<option <?php echo $dna['use_proper_disposition_tagging'] == "No" ? "selected" : "";
															?> value="No">No</option>
													<option <?php echo $dna['use_proper_disposition_tagging'] == "N/A" ? "selected" : "";
															?> value="N/A">N/A</option>

												</select>
											</td>
											<td><input type="text" class="form-control" name="data[use_proper_disposition_tagging_reason]" value="<?php echo $dna['use_proper_disposition_tagging_reason']; ?>" disabled></td>
										</tr>
										<tr>


										</tr>
										<tr>

										</tr>
										<tr>


											<!---end--->






											<td rowspan=3 style="background-color:#123456;color:white; font-weight:bold">Closing </td>
											<td colspan=2 style="color:black">Additional Assistance</td>
											<!--td> The agent asks additional assistance before ending the call.</td-->
											<td> 7.5</td>
											<td style="color:green;font-weight:bold">Customer </td>
											<td>
												<select class="form-control" id="additional_assistance" name="data[additional_assistance]" disabled>


													<option <?php echo $dna['additional_assistance'] == "Yes" ? "selected" : "";
															?> value="Yes">Yes</option>

													<option <?php echo $dna['additional_assistance'] == "No" ? "selected" : "";
															?> value="No">No</option>
													<option <?php echo $dna['additional_assistance'] == "N/A" ? "selected" : "";
															?> value="N/A">N/A</option>


												</select>
											</td>
											<td><input type="text" class="form-control" name="data[additional_assistance_reason]" value="<?php echo $dna['additional_assistance_reason']; ?>" disabled></td>
										</tr>
										<tr>
											<td colspan=2 style="color:black">Used Suggested closing spiel </td>
											<!--td> The agent uses suggested closing spiel based on channel</td-->
											<td> 7.5</td>
											<td style="color:green;font-weight:bold">Customer </td>
											<td>
												<select class="form-control" id="used_Suggested_Closing_Spiel" name="data[used_Suggested_Closing_Spiel]" disabled>


													<option <?php echo $dna['used_Suggested_Closing_Spiel'] == "Yes" ? "selected" : "";
															?> value="Yes">Yes</option>

													<option <?php echo $dna['used_Suggested_Closing_Spiel'] == "No" ? "selected" : "";
															?> value="No">No</option>
													<option <?php echo $dna['used_Suggested_Closing_Spiel'] == "N/A" ? "selected" : "";
															?> value="N/A">N/A</option>





												</select>
											</td>
											<td><input type="text" class="form-control" name="data[used_Suggested_Closing_Spiel_reason]" value="<?php echo $dna['used_Suggested_Closing_Spiel_reason']; ?>" disabled></td>

										</tr>
										<tr>

										</tr>

										<!--- added -->


										<tr>
											<td rowspan=6 style="background-color:Maroon;color:white; font-weight:bold">Red Flag </td>
											<td colspan=2 style="color:red">Rudeness </td>
											<td></td>
											<td style="color:Orange; font-weight:bold"> Compliance </td>
											<!--td> The agent asks additional assistance before ending the call.</td-->

											<td>
												<select class="form-control" id="rudeness" name="data[rudeness]" disabled>


													<option <?php echo $dna['rudeness'] == "Pass" ? "selected" : "";
															?> value="Pass">Pass</option>

													<option <?php echo $dna['rudeness'] == "Fail" ? "selected" : "";
															?> value="Fail">Fail</option>
													<option <?php echo $dna['rudeness'] == "N/A" ? "selected" : "";
															?> value="N/A">N/A</option>


												</select>
											</td>
											<!--td><input type="text" class="form-control" name="data[additional_assistance_comment]" value="<?php //echo $dna['additional_assistance_comment'];
																																				?>"></td-->
											<td><input type="text" class="form-control" name="data[rudeness_reason]" disabled value="<?php echo $dna['rudeness_reason']; ?>"></td>
										</tr>
										<tr>
											<td colspan=2 style="color:red">Call Aviodance </td>
											<td></td>
											<td style="color:Orange; font-weight:bold"> Compliance </td>
											<!--td> The agent uses suggested closing spiel based on channel</td-->

											<td>
												<select class="form-control" id="call_aviodance" name="data[call_aviodance]" disabled>


													<option <?php echo $dna['call_aviodance'] == "Pass" ? "selected" : "";
															?> value="Pass">Pass</option>

													<option <?php echo $dna['call_aviodance'] == "Fail" ? "selected" : "";
															?> value="Fail">Fail</option>
													<option <?php echo $dna['call_aviodance'] == "N/A" ? "selected" : "";
															?> value="N/A">N/A</option>





												</select>
											</td>

											<!--td><input type="text" class="form-control" name="data[used_Suggested_Closing_Spiel_comment]" value="<?php // echo $dna['used_Suggested_Closing_Spiel_comment'];
																																					?>"></td-->
											<td><input type="text" class="form-control" name="data[call_aviodance_reason]" disabled value="<?php echo $dna['call_aviodance_reason']; ?>"></td>
										</tr>
										<tr>

										</tr>
										<td colspan=2 style="color:red">Improper Won Tagging </td>
										<td></td>
										<td style="color:Orange; font-weight:bold"> Compliance </td>

										<!--td> The agent asks additional assistance before ending the call.</td-->

										<td>
											<select class="form-control" id="improper_won_tagging" name="data[improper_won_tagging]" disabled>


												<option <?php echo $dna['improper_won_tagging'] == "Pass" ? "selected" : "";
														?> value="Pass">Pass</option>

												<option <?php echo $dna['improper_won_tagging'] == "Fail" ? "selected" : "";
														?> value="Fail">Fail</option>
												<option <?php echo $dna['improper_won_tagging'] == "N/A" ? "selected" : "";
														?> value="N/A">N/A</option>


											</select>
										</td>
										<!--td><input type="text" class="form-control" name="data[additional_assistance_comment]" value="<?php //echo $dna['additional_assistance_comment'];
																																			?>"></td-->
										<td><input type="text" class="form-control" name="data[improper_won_tagging_reason]" disabled value="<?php echo $dna['improper_won_tagging_reason']; ?>"></td>
										</tr>
										<tr>
											<td colspan=2 style="color:red">Infosec Violation </td>
											<td></td>
											<td style="color:Orange; font-weight:bold"> Compliance </td>
											<!--td> The agent uses suggested closing spiel based on channel</td-->

											<td>
												<select class="form-control" id="infosec_violation" name="data[infosec_violation]" disabled>


													<option <?php echo $dna['infosec_violation'] == "Pass" ? "selected" : "";
															?> value="Pass">Pass</option>

													<option <?php echo $dna['infosec_violation'] == "Fail" ? "selected" : "";
															?> value="Fail">Fail</option>
													<option <?php echo $dna['infosec_violation'] == "N/A" ? "selected" : "";
															?> value="N/A">N/A</option>





												</select>
											</td>

											<!--td><input type="text" class="form-control" name="data[used_Suggested_Closing_Spiel_comment]" value="<?php // echo $dna['used_Suggested_Closing_Spiel_comment'];
																																					?>"></td-->
											<td><input type="text" class="form-control" name="data[infosec_violation_reason]" disabled value="<?php echo $dna['infosec_violation_reason']; ?>"></td>
										</tr>
										<tr>

										</tr>



										<tr>


											<!--- added ---->
										<tr style="background-color:#123456;color:yellow; font-weight:bold">
											<td colspan=2>Customer Score</td>
											<td colspan=2>Business Score</td>
											<td colspan="3">Compliance Score</td>
										</tr>
										<tr style="background-color:#123456;color:white; font-weight:bold">
											<td>Earned:</td>
											<td><input type="text" style="background-color:#000000;color:white; font-weight:bold;text-align:center" disabled class="form-control"  name="data[custAcmEarned]" value="<?php echo $dna['custAcmEarned'] ?>"></td>
											<td>Earned:</td>
											<td><input type="text" style="background-color:#000000;color:white; font-weight:bold;text-align:center"   class="form-control" disabled  name="data[busiAcmEarned]" value="<?php echo $dna['busiAcmEarned'] ?>"></td>
											<td>Earned:</td>
											<td colspan="2"><input type="text" disabled class="form-control"  name="data[complAcmEarned]" style="background-color:#000000;color:white; font-weight:bold;text-align:center"  value="<?php echo $dna['complAcmEarned']; ?>"></td>
										</tr>
										<tr style="background-color:#123456;color:white; font-weight:bold">
											<td>Possible:</td>
											<td><input type="text" style="background-color:#000000;color:white; font-weight:bold;text-align:center"  class="form-control" disabled  name="data[custAcmPossible]" value="<?php echo $dna['custAcmPossible'] ?>"></td>
											<td>Possible:</td>
											<td><input type="text" style="background-color:#000000;color:white; font-weight:bold;text-align:center"   class="form-control" disabled name="data[busiAcmPossible]" value="<?php echo $dna['busiAcmPossible'] ?>"></td>
											<td>Possible:</td>
											<td colspan="2"><input type="text"  style="background-color:#000000;color:white; font-weight:bold;text-align:center"  disabled class="form-control"  name="data[complAcmPossible]" value="<?php echo $dna['complAcmPossible']; //echo $dna['custAcmEarned'] 
																																								?>"></td>
										</tr>
										<tr style="background-color:#123456;color:white; font-weight:bold">
											<td>Percentage:</td>
											<td><input type="text" readonly style="background-color:Purple;color:white; font-weight:bold;text-align:center" class="form-control" id="custAcmScore" name="data[custAcmScore]" value="<?php echo $dna['custAcmScore'] ?>"></td>
											<td>Percentage:</td>
											<td><input type="text" readonly style="background-color:Purple;color:white; font-weight:bold;text-align:center" class="form-control" id="busiAcmScore" name="data[busiAcmScore]" value="<?php echo $dna['busiAcmScore'] ?>"></td>
											<td>Percentage:</td>
											<td colspan="2"><input type="text" readonly style="background-color:Purple;color:white; font-weight:bold;text-align:center" class="form-control" id="complAcmScore" name="data[complAcmScore]" value="<?php echo $dna['complAcmScore'] ?>"></td>
										</tr>


										<!-- end--->











										<tr>
											<td>Call Observation:<span style="font-size:24px;color:red">*</span></td>
											<td colspan=2><textarea class="form-control" readonly name="data[call_summary]"><?php echo $dna['call_summary'] ?></textarea></td>
											<td>Feedback:<span style="font-size:24px;color:red">*</span></td>
											<td colspan=3><textarea class="form-control" readonly name="data[feedback]"><?php echo $dna['feedback'] ?></textarea></td>
										</tr>


										<tr>

											<td> Attached File </td>
											<td colspan="7">
												<?php
												if ($dna['attach_file'] != '') {
													$attach_file = explode(",", $dna['attach_file']);
													foreach ($attach_file as $mp) {
												?>
														<audio controls='' style="width:120px; height:25px; background-color:#607F93">
															<source src="<?php echo base_url(); ?>qa_files/qa_wireless_dna/inbound/<?php echo $mp; ?>" type="audio/ogg">
															<source src="<?php echo base_url(); ?>qa_files/qa_wireless_dna/inbound/<?php echo $mp; ?>" type="audio/mpeg">
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
											<td colspan="8" style="text-align:left"><?php echo $dna['mgnt_rvw_note'] ?></td>
										</tr>
										<tr>
											<td style="font-size:12px">Agent Review:</td>
											<td colspan="7" style="text-align:left"><?php echo $dna['agent_rvw_note'] ?></td>
										</tr>

										<tr>
											<td colspan="8" style="background-color:#9FE2BF"></td>
										</tr>

										<form id="form_mgnt_user" method="POST" action="<?php $id = $_SESSION['id'];
																							echo base_url('qa_wireless_dna/edit_qa_wireless_dna/' . $id); ?>">
											<input type="hidden" name="mgnt_rvw_by" class="form-control" value="<?php $pnid = get_user_id();
																												echo $pnid; ?>">


											<tr>
												<td colspan=2 style="font-size:12px">Your Review<span style="font-size:24px;color:red">*</span></td>
												<td colspan=5><textarea class="form-control" name="note"><?php echo $dna['mgnt_rvw_note'] ?></textarea></td>
											</tr>




											<tr>
												<td colspan="8"><button class="btn btn-success waves-effect" type="submit" id='btnmgntSave' name='btnmgntSave' value="SAVE" style="width:500px">SAVE</button></td>
											</tr>






										</form>
									<?php
									} ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>

	</section>
</div>