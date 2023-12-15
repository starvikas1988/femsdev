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
</style>

<?php if ($ajio_id != 0) {
	if (is_access_qa_edit_feedback() == false) { ?>
		<style>
			.form-control {
				pointer-events: none;
				background-color: #D5DBDB;
			}
		</style>
<?php
	}
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
											<td colspan="8" id="theader" style="background-color:Purple; font-size:40px;color:yellow"> Wireless DNA QA Form </td>
											<input type="hidden" name="audit_start_time" value="<?php echo CurrMySqlDate(); ?>">
										</tr>
										<?php if ($ajio_id == 0) {
											$auditorName = get_username();
											$auditDate = CurrDateMDY();
											$clDate_val = CurrDateMDY();
										} else {
											if ($qa_wireless_dna_curd["entry_by"] != "") {
												$auditorName = $qa_wireless_dna_curd["auditor_name"];
											} else {
												$auditorName = $qa_wireless_dna_curd["client_name"];
											}
											$auditDate = mysql2mmddyy($qa_wireless_dna_curd["audit_date"]);
											$clDate_val = mysql2mmddyy($qa_wireless_dna_curd["audit_date"]);
										} ?>


										<tr>
											<td> </td>
										</tr>

										<tr>
											<td>Auditor Name:<span style="font-size:24px;color:red">*</span></td>
											<td style="width:250px"><input type="text" class="form-control" value="<?php echo $auditorName; ?>" disabled></td>
											<td>Audit Date:</td>
											<td style="width:250px"><input type="text" class="form-control" value="<?php echo $auditDate; ?>" disabled></td>
											<td>Call Date :<span style="font-size:24px;color:red">*</span></td>

											<td colspan="2"><input type="text" readonly class="form-control" id="call_date_time" name="call_date" value="<?php echo $clDate_val; ?>" autocomplete="off" required></td>


										</tr>
										<tr>
											<td>Agent Name:<span style="font-size:24px;color:red">*</span></td>
											<td>
												<select class="form-control" id="agent_id" name="data[agent_id]" required>

													<option value="">-Select-</option>
													<?php foreach ($agentName as $row) : ?>
														<option value="<?php echo $row["id"]; ?>"><?php echo $row["name"]; ?></option>
													<?php
													endforeach; ?>
												</select>
											</td>
											<td>Fusion ID:<span style="font-size:24px;color:red">*</span></td>
											<td><input type="text" class="form-control" id="fusion_id" value="<?php echo $qa_wireless_dna_curd['fusion_id'] ?>" readonly></td>
											<td>L1 Supervisor:<span style="font-size:24px;color:red">*</span></td>
											<td colspan="2">
												<select class="form-control" id="tl_id" name="data[tl_id]" required>

													<option value="">--Select--</option>
													<?php foreach ($tlname as $tl) : ?>
														<option value="<?php echo $tl["id"]; ?>"><?php echo $tl["fname"] . " " . $tl["lname"]; ?></option>
													<?php
													endforeach; ?>
												</select>
											</td>
										</tr>
										<tr>
											<td>Call ID:<span style="font-size:24px;color:red">*</span></td>
											<td><input type="text" class="form-control" name="data[call_id]" autocomplete="off" value="" required></td>

											<td>VOC: <span style="font-size:24px;color:red">*</span></td>
											<td>
												<select class="form-control" id="voc" name="data[voc]" autocomplete="off" required>

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
											<td> Type of Audit:<span style="font-size:24px;color:red">*</span></td>
											<td colspan="2">
												<select class="form-control" id="audit_type" name="data[audit_type]" autocomplete="off" required>

													<option value="">-Select-</option>
													<option value="CQ Audit">CQ Audit</option>
													<option value="BQ Audit">BQ Audit</option>
													<option value="Calibration">Calibration</option>
													<option value="Pre-Certificate Mock Call">Pre-Certificate Mock Call</option>
													<option value="Certification Audit">Certification Audit</option>
													<option value="Operation Audit">Operation Audit</option>
													<option value="Trainer Audit">Trainer Audit</option>
													<option value="Hygiene Audit">Hygiene Audit</option>
												</select>
											</td>









										</tr>



										<tr>
											<td class="auType_epi">Auditor Type</td>
											<td class="auType_epi">
												<select class="form-control" id="auditor_type" autocomplete="off" name="data[auditor_type]">

													<option value="">-Select-</option>
													<option value="Master">Master</option>
													<option value="Regular">Regular</option>
												</select>
											</td>
										</tr>

<tr>
											<td> Form Submitted :<span style="font-size:24px;color:red">*</span></td>
											<td>
												<select class="form-control" id="form_submits" name="data[form_submits]" required>
													<option dna_max=0 dna_val=0 <?php echo $qa_wireless_dna_curd['form_submits'] == "Yes" ? "selected" : ""; ?> value="Yes">Yes </option>
													<option dna_max=0 dna_val=0 <?php echo $qa_wireless_dna_curd['form_submits'] == "No" ? "selected" : ""; ?> value="No">No </option>
													
												</select>
											</td>
										</tr>




										<tr>
											<td style="font-weight:bold; font-size:12px; text-align:right">Earned Score:</td>
											<td><input type="text" readonly id="earned_score" name="data[earned_score]" class="form-control" style="font-weight:bold" value="<?php echo $qa_wireless_dna_curd['earned_score'] ?>"></td>
											<td style="font-weight:bold; font-size:12px; text-align:right">Possible Score:</td>
											<td><input type="text" readonly id="possible_score" name="data[possible_score]" class="form-control" style="font-weight:bold" value="<?php echo $qa_wireless_dna_curd['possible_score'] ?>"></td>
											<td style="font-weight:bold; font-size:12px; text-align:right">Overall Score:</td>
											<td colspan="2"><input type="text" readonly id="overall_score" name="data[overall_score]" class="form-control" style="font-weight:bold" value="<?php echo $qa_wireless_dna_curd['overall_score'] ?>"></td>
										</tr>

										<!--tr style="background-color:#85C1E9; font-weight:bold"-->
										<tr style="background-color:purple; font-size:40px;color:yellow;font-weight:bold">
										<td>Parameter</td>
										<!--td> Overall Weight</td-->
										<td colspan=2>Sub Parameter</td>
										<td> Weight</td>
										<td>Criticality </td>
										<td style="width:200px;">Defect</td>


										<td style="width:250px;display:inline-block;border:none;"> Reason</td>
									</tr>
										<tr>
											<td rowspan=4 style="background-color:#123456;color:white; font-weight:bold">Opening </td>
											<!--td rowspan=4> 15%</td-->
											<td colspan=2 style="color:black"> Used suggested opening spiel </td>
											<td> 7.5 </td>
											<td style="color:green;font-weight:bold">Customer </td>
											<td>
												<select class="form-control wireless customer" id="used_suggested_opening_spiel" name="data[used_suggested_opening_spiel]" required>
													<option dna_max=7.5 dna_val=7.5 <?php echo $qa_wireless_dna_curd['used_suggested_opening_spiel'] == "Yes" ? "selected" : ""; ?> value="Yes">Yes </option>
													<option dna_max=7.5 dna_val=0 <?php echo $qa_wireless_dna_curd['used_suggested_opening_spiel'] == "No" ? "selected" : ""; ?> value="No">No </option>
													<option dna_max=7.5 dna_val=7.5 <?php echo $qa_wireless_dna_curd['used_suggested_opening_spiel'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A </option>
												</select>
											</td>
											<td><input type="text" class="form-control" name="data[used_suggested_opening_spiel_reason]" value=""></td>
										</tr>
										<tr>
											<td colspan=2> Obtained Customer's Consent</td>
											<!--td> Agent must read and ask the customer's understanding about the terms and condition when applying for a SIMCARD. </td-->
											<td> 7.5</td>
											<td style="color:green;font-weight:bold">Customer </td>
											<td>
												<select class="form-control wireless customer" id="obtained_customer_consent" name="data[obtained_customer_consent]" required>
													<option dna_max=7.5 dna_val=7.5 <?php echo $qa_wireless_dna_curd['obtained_customer_consent'] == "Yes" ? "selected" : ""; ?> value="Yes">Yes </option>
													<option dna_max=7.5 dna_val=0 <?php echo $qa_wireless_dna_curd['obtained_customer_consent'] == "No" ? "selected" : ""; ?> value="No">No </option>
													<option dna_max=7.5 dna_val=7.5 <?php echo $qa_wireless_dna_curd['obtained_customer_consent'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A </option>
												</select>
											</td>
											<!--td><input type="text" class="form-control" name="data[obtained_customer_consent_comment]"  value="<?php //echo $qa_wireless_dna_curd['obtained_customer_consent_comment'];
																																					?>"></td--->
											<td><input type="text" class="form-control" name="data[obtained_customer_consent_reason]" value=""></td>
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
											<!--td rowspan=5> 20%</td--->
											<td colspan=2 style="color:black">Active Listening/Reading </td>
											<!--td> The agent should ablle to identify and understand the issue of the customer / Good comprehension skill</td-->
											<td> 4</td>
											<td style="color:green;font-weight:bold">Customer </td>
											<td>
												<select class="form-control wireless customer" id="active_listening_or_reading" name="data[active_listening_or_reading]" required>



													<option dna_max=4 dna_val=4 <?php echo $qa_wireless_dna_curd['active_listening_or_reading'] == "Yes" ? "selected" : "";
																				?> value="Yes">Yes</option>
													<option dna_max=4 dna_val=0 <?php echo $qa_wireless_dna_curd['active_listening_or_reading'] == "No" ? "selected" : "";
																				?> value="No">No</option>
													<option dna_max=4 dna_val=4 <?php echo $qa_wireless_dna_curd['active_listening_or_reading'] == "N/A" ? "selected" : "";
																				?> value="N/A">N/A</option>

												</select>
											</td>
											<!--td><input type="text" class="form-control" name="data[active_listening_or_reading_comment]"  value="<?php //echo $qa_wireless_dna_curd['active_listening_or_reading_comment'];
																																					?>"></td-->
											<td><input type="text" class="form-control" name="data[active_listening_or_reading_reason]" value=""></td>

										</tr>
										<tr>
											<td colspan=2 style="color:black"> Proper Hold Procedure</td>
											<!--td> Agent should follow the hold procedures like "May I place this line on hold for 2 minutes? I will just check my resources"</td-->
											<td> 4</td>
											<td style="color:green;font-weight:bold">Customer </td>
											<td>
												<select class="form-control wireless customer" id="proper_hold_procedure" name="data[proper_hold_procedure]" required>


													<option dna_max=4 dna_val=4 <?php echo $qa_wireless_dna_curd['proper_hold_procedure'] == "Yes" ? "selected" : "";
																				?> value="Yes">Yes</option>
													<option dna_max=4 dna_val=0 <?php echo $qa_wireless_dna_curd['proper_hold_procedure'] == "No" ? "selected" : "";
																				?> value="No">No</option>
													<option dna_max=4 dna_val=4 <?php echo $qa_wireless_dna_curd['proper_hold_procedure'] == "N/A" ? "selected" : "";
																				?> value="N/A">N/A</option>

												</select>
											</td>
											<!--td><input type="text" class="form-control" name="data[proper_hold_procedure_comment]"  value="<?php //echo $qa_wireless_dna_curd['proper_hold_procedure_comment'];
																																				?>"></td-->
											<td><input type="text" class="form-control" name="data[proper_hold_procedure_reason]" value=""></td>
										</tr>
										<tr>
											<!--end-->
											<td colspan=2>Dead Air</td>
											<!--td> Dead air should not be more than 10 seconds.</td-->
											<td> 4</td>
											<td style="color:green;font-weight:bold">Customer </td>
											<td>
												<select class="form-control wireless customer" id="dead_air" name="data[dead_air]" required>


													<option dna_max=4 dna_val=4 <?php echo $qa_wireless_dna_curd['dead_air'] == "Yes" ? "selected" : "";
																				?> value="Yes">Yes</option>
													<option dna_max=4 dna_val=0 <?php echo $qa_wireless_dna_curd['dead_air'] == "No" ? "selected" : "";
																				?> value="No">No</option>
													<option dna_max=4 dna_val=4 <?php echo $qa_wireless_dna_curd['dead_air'] == "N/A" ? "selected" : "";
																				?> value="N/A">N/A</option>


												</select>
											</td>
											<!--td><input type="text" class="form-control" name="data[dead_air_comment]"  value="<?php // echo $qa_wireless_dna_curd['dead_air_comment'];
																																	?>"></td-->
											<td><input type="text" class="form-control" name="data[dead_air_reason]" value=""></td>
										</tr>
										<tr>
											<td colspan=2>Interruption </td>
											<!--td> The agent should pause whenever there's an interruption / apologize if necessary</td-->
											<td> 4</td>
											<td style="color:green;font-weight:bold">Customer </td>
											<td>
												<select class="form-control wireless customer" id="interruption" name="data[interruption]" required>


													<option dna_max=4 dna_val=4 <?php echo $qa_wireless_dna_curd['interruption'] == "Yes" ? "selected" : "";
																				?> value="Yes">Yes</option>
													<option dna_max=4 dna_val=0 <?php echo $qa_wireless_dna_curd['interruption'] == "No" ? "selected" : "";
																				?> value="No">No</option>
													<option dna_max=4 dna_val=4 <?php echo $qa_wireless_dna_curd['interruption'] == "N/A" ? "selected" : "";
																				?> value="N/A">N/A</option>
												</select>
											</td>
											<!--td><input type="text" class="form-control" name="data[interruption_comment]"  value="<?php //echo $qa_wireless_dna_curd['interruption_comment'];
																																		?>"></td-->
											<td><input type="text" class="form-control" name="data[interruption_reason]" value=""></td>
										</tr>
										<tr>
											<td colspan=2>Customer Experience</td>
											<!--td>It is important that the agent engaes with the customer to build a more personalized conversation. Agent should find an opportunity to start a conversation based on the information provided by the customer.</td--->
											<td> 4</td>
											<td style="color:Olive; font-weight:bold"> Business </td>
											<td>
												<select class="form-control wireless business" id="customer_experience" name="data[customer_experience]" required>


													<option dna_max=4 dna_val=4 <?php echo $qa_wireless_dna_curd['customer_experience'] == "Yes" ? "selected" : "";
																				?> value="Yes">Yes</option>
													<option dna_max=4 dna_val=0 <?php echo $qa_wireless_dna_curd['customer_experience'] == "No" ? "selected" : "";
																				?> value="No">No</option>
													<option dna_max=4 dna_val=4 <?php echo $qa_wireless_dna_curd['customer_experience'] == "N/A" ? "selected" : "";
																				?> value="N/A">N/A</option>

												</select>
											</td>
											<!--td><input type="text" class="form-control" name="data[customer_experience_comment]" value="<?php //echo $qa_wireless_dna_curd['customer_experience_comment'];
																																			?>"></td-->
											<td><input type="text" class="form-control" name="data[customer_experience_reason]" value=""></td>
										</tr>
										<tr>


										</tr>
										<tr>


										</tr>
										<tr>
											<td rowspan=4 style="background-color:#123456;color:white; font-weight:bold">Resolution </td>
											<!--td rowspan=4 style="font-weight:bold">30 </td-->
											<td colspan=2>Complete And Accuracy Information </td>


											<td> 25</td>
											<td style="color:Orange; font-weight:bold"> Compliance </td>
											<td>
												<select class="form-control wireless compliance" id="complete_accurate_information" name="data[complete_accurate_information]" required>


													<option dna_max=25 dna_val=25 <?php echo $qa_wireless_dna_curd['complete_accurate_information'] == "Excellent" ? "selected" : "";
																					?> value="Excellent">Excellent</option>
													<option dna_max=25 dna_val=10 <?php echo $qa_wireless_dna_curd['complete_accurate_information'] == "Good" ? "selected" : "";
																					?> value="Good">Good</option>

													<option dna_max=25 dna_val=0 <?php echo $qa_wireless_dna_curd['complete_accurate_information'] == "Poor" ? "selected" : "";
																					?> value="Poor">Poor</option>
												</select>
											</td>
											<!--td><input type="text" class="form-control" name="data[complete_accurate_information_comment]" value="<?php echo $qa_wireless_dna_curd['complete_accurate_information_comment']; ?>"></td-->
											<td><input type="text" class="form-control" name="data[complete_accurate_information_reason]" value=""></td>
										</tr>
										<tr>
											<td colspan=2>Probing Question </td>
											<!--td> Agent must ask only necessary questions that will lead to the customer concerns. <br> Agent must ask the travel dates,passport name,email address,billing address and the serial number of the SIMCARD.</td--->
											<td>5</td>
											<td style="color:Olive; font-weight:bold"> Business </td>
											<td>
												<select class="form-control wireless business" id="probing_question" name="data[probing_question]" required>


													<option dna_max=5 dna_val=5 <?php echo $qa_wireless_dna_curd['probing_question'] == "Yes" ? "selected" : "";
																				?> value="Yes">Yes</option>
													<option dna_max=5 dna_val=0 <?php echo $qa_wireless_dna_curd['probing_question'] == "No" ? "selected" : "";
																				?> value="No">No</option>
													<option dna_max=5 dna_val=5 <?php echo $qa_wireless_dna_curd['probing_question'] == "N/A" ? "selected" : "";
																				?> value="N/A">N/A</option>

												</select>
											</td>
											<!--td><input type="text" class="form-control" name="data[probing_question_comment]" value="<?php // echo $qa_wireless_dna_curd['probing_question_comment'];
																																		?>"></td-->
											<td><input type="text" class="form-control" name="data[probing_question_reason]" value=""></td>
										</tr>
										<tr>


										</tr>
										<tr>

										</tr>
										<tr>
											<!-- start -->
										<tr>
											<td rowspan=4 style="background-color:#123456;color:white; font-weight:bold">Documentation </td>
											<!---td rowspan=4 style=" font-weight:bold">20 </td-->
											<td colspan=2>Complete and Accurate Notes</td>
											<!--td> Agent must document key points in the conversation</td--->
											<td> 10</td>
											<td style="color:Orange; font-weight:bold"> Compliance </td>
											<td>
												<select class="form-control wireless compliance" id="complete_accurate_notes" name="data[complete_accurate_notes]" required>

													<option dna_max=10 dna_val=10 <?php echo $qa_wireless_dna_curd['complete_accurate_notes'] == "Yes" ? "selected" : "";
																					?> value="Yes">Yes</option>
													<option dna_max=10 dna_val=0 <?php echo $qa_wireless_dna_curd['complete_accurate_notes'] == "No" ? "selected" : "";
																					?> value="No">No</option>
													<option dna_max=10 dna_val=10 <?php echo $qa_wireless_dna_curd['complete_accurate_notes'] == "N/A" ? "selected" : "";
																					?> value="N/A">N/A</option>




												</select>
											</td>
											<!--td><input type="text" class="form-control" name="data[complete_accurate_notes_comment]" value="<?php //echo $qa_wireless_dna_curd['complete_accurate_notes_comment'];
																																				?>"></td-->
											<td><input type="text" class="form-control" name="data[complete_accurate_notes_reason]" value=""></td>

										</tr>
										<tr>
											<td colspan=2>Use Proper Deposition and Tagging </td>
											<!--td> The agent must choose the correct/most appropriate disposition based on the main reason for calling.</td-->
											<td> 10</td>
											<td style="color:Orange; font-weight:bold"> Compliance </td>
											<td>

												<select class="form-control wireless compliance" id="use_proper_disposition_tagging" name="data[use_proper_disposition_tagging]" required>


													<option dna_max=10 dna_val=10 <?php echo $qa_wireless_dna_curd['use_proper_disposition_tagging'] == "Yes" ? "selected" : "";
																					?> value="Yes">Yes</option>
													<option dna_max=10 dna_val=0 <?php echo $qa_wireless_dna_curd['use_proper_disposition_tagging'] == "No" ? "selected" : "";
																					?> value="No">No</option>
													<option dna_max=10 dna_val=10 <?php echo $qa_wireless_dna_curd['use_proper_disposition_tagging'] == "N/A" ? "selected" : "";
																					?> value="N/A">N/A</option>

												</select>
											</td>
											<!--td><input type="text" class="form-control" name="data[use_proper_disposition_tagging_comment]" value="<?php //echo $qa_wireless_dna_curd['use_proper_disposition_tagging_comment'];
																																						?>"></td-->
											<td><input type="text" class="form-control" name="data[use_proper_disposition_tagging_reason]" value=""></td>
										</tr>
										<tr>


										</tr>
										<tr>

										</tr>
										<tr>


											<!---end--->






											<td rowspan=3 style="background-color:#123456;color:white; font-weight:bold">Closing </td>
											<!--td rowspan=3 style=" font-weight:bold">15 </td-->
											<td colspan=2 style="color:black">Additional Assistance</td>
											<!--td> The agent asks additional assistance before ending the call.</td-->
											<td> 7.5</td>
											<td style="color:green;font-weight:bold">Customer </td>
											<td>
												<select class="form-control wireless customer" id="additional_assistance" name="data[additional_assistance]" required>


													<option dna_max=7.5 dna_val=7.5 <?php echo $qa_wireless_dna_curd['additional_assistance'] == "Yes" ? "selected" : "";
																					?> value="Yes">Yes</option>

													<option dna_max=7.5 dna_val=0 <?php echo $qa_wireless_dna_curd['additional_assistance'] == "No" ? "selected" : "";
																					?> value="No">No</option>
													<option dna_max=7.5 dna_val=7.5 <?php echo $qa_wireless_dna_curd['additional_assistance'] == "N/A" ? "selected" : "";
																					?> value="N/A">N/A</option>


												</select>
											</td>
											<!--td><input type="text" class="form-control" name="data[additional_assistance_comment]" value="<?php //echo $qa_wireless_dna_curd['additional_assistance_comment'];
																																				?>"></td-->
											<td><input type="text" class="form-control" name="data[additional_assistance_reason]" value=""></td>
										</tr>
										<tr>
											<td colspan=2 style="color:black">Used Suggested closing spiel </td>
											<!--td> The agent uses suggested closing spiel based on channel</td-->
											<td> 7.5</td>
											<td style="color:green;font-weight:bold">Customer </td>
											<td>
												<select class="form-control wireless customer" id="used_Suggested_Closing_Spiel" name="data[used_Suggested_Closing_Spiel]" required>


													<option dna_max=7.5 dna_val=7.5 <?php echo $qa_wireless_dna_curd['used_Suggested_Closing_Spiel'] == "Yes" ? "selected" : "";
																					?> value="Yes">Yes</option>

													<option dna_max=7.5 dna_val=0 <?php echo $qa_wireless_dna_curd['used_Suggested_Closing_Spiel'] == "No" ? "selected" : "";
																					?> value="No">No</option>
													<option dna_max=7.5 dna_val=7.5 <?php echo $qa_wireless_dna_curd['used_Suggested_Closing_Spiel'] == "N/A" ? "selected" : "";
																					?> value="N/A">N/A</option>





												</select>
											</td>

											<!--td><input type="text" class="form-control" name="data[used_Suggested_Closing_Spiel_comment]" value="<?php // echo $qa_wireless_dna_curd['used_Suggested_Closing_Spiel_comment'];
																																					?>"></td-->
											<td><input type="text" class="form-control" name="data[used_Suggested_Closing_Spiel_reason]" value=""></td>
										</tr>
										<tr>

										</tr>

										<!--- started-->
										<tr>
											<td rowspan=6 style="background-color:Maroon;color:white; font-weight:bold">Red Flag </td>
											<td colspan=2 style="color:red">Rudeness </td>
											<td></td>
											<td style="color:Orange; font-weight:bold"> Compliance </td>
											<!--td> The agent asks additional assistance before ending the call.</td-->

											<td>
												<select class="form-control wireless" id="rudeness" name="data[rudeness]" required>


													<option dna_max=0 dna_val=0<?php echo $qa_wireless_dna_curd['rudeness'] == "Pass" ? "selected" : "";
																				?> value="Pass">Pass</option>

													<option dna_max=0 dna_val=0<?php echo $qa_wireless_dna_curd['rudeness'] == "Fail" ? "selected" : "";
																				?> value="Fail">Fail</option>
													<option dna_max=0 dna_val=0<?php echo $qa_wireless_dna_curd['rudeness'] == "N/A" ? "selected" : "";
																				?> value="N/A">N/A</option>


												</select>
											</td>
											<!--td><input type="text" class="form-control" name="data[additional_assistance_comment]" value="<?php //echo $qa_wireless_dna_curd['additional_assistance_comment'];
																																				?>"></td-->
											<td><input type="text" class="form-control" name="data[rudeness_reason]" value=""></td>
										</tr>
										<tr>
											<td colspan=2 style="color:red">Call Aviodance </td>
											<td></td>
											<td style="color:Orange; font-weight:bold"> Compliance </td>
											<!--td> The agent uses suggested closing spiel based on channel</td-->

											<td>
												<select class="form-control  wireless" id="call_aviodance" name="data[call_aviodance]" required>


													<option dna_max=0 dna_val=0<?php echo $qa_wireless_dna_curd['call_aviodance'] == "Pass" ? "selected" : "";
																				?> value="Pass">Pass</option>

													<option dna_max=0 dna_val=0<?php echo $qa_wireless_dna_curd['call_aviodance'] == "Fail" ? "selected" : "";
																				?> value="Fail">Fail</option>
													<option dna_max=0 dna_val=0<?php echo $qa_wireless_dna_curd['call_aviodance'] == "N/A" ? "selected" : "";
																				?> value="N/A">N/A</option>





												</select>
											</td>

											<!--td><input type="text" class="form-control" name="data[used_Suggested_Closing_Spiel_comment]" value="<?php // echo $qa_wireless_dna_curd['used_Suggested_Closing_Spiel_comment'];
																																					?>"></td-->
											<td><input type="text" class="form-control" name="data[call_aviodance_reason]" value=""></td>
										</tr>
										<tr>

										</tr>

										<td colspan=2 style="color:red">Improper Won Tagging </td>
										<td></td>
										<td style="color:Orange; font-weight:bold"> Compliance </td>
										<!--td> The agent asks additional assistance before ending the call.</td-->

										<td>
											<select class="form-control  wireless" id="improper_won_tagging" name="data[improper_won_tagging]" required>

												<option dna_max=0 dna_val=0<?php echo $qa_wireless_dna_curd['improper_won_tagging'] == "Pass" ? "selected" : "";
																			?> value="Pass">Pass</option>

												<option dna_max=0 dna_val=0<?php echo $qa_wireless_dna_curd['improper_won_tagging'] == "Fail" ? "selected" : "";
																			?> value="Fail">Fail</option>
												<option dna_max=0 dna_val=0<?php echo $qa_wireless_dna_curd['improper_won_tagging'] == "N/A" ? "selected" : "";
																			?> value="N/A">N/A</option>


											</select>
										</td>
										<!--td><input type="text" class="form-control" name="data[additional_assistance_comment]" value="<?php //echo $qa_wireless_dna_curd['additional_assistance_comment'];
																																			?>"></td-->
										<td><input type="text" class="form-control" name="data[improper_won_tagging_reason]" value=""></td>
										</tr>
										<tr>
											<td colspan=2 style="color:red">Infosec Violation </td>
											<td></td>
											<td style="color:Orange; font-weight:bold"> Compliance </td>
											<!--td> The agent uses suggested closing spiel based on channel</td-->

											<td>
												<select class="form-control  wireless" id="infosec_violation" name="data[infosec_violation]" required>


													<option dna_max=0 dna_val=0<?php echo $qa_wireless_dna_curd['infosec_violation'] == "Pass" ? "selected" : "";
																				?> value="Pass">Pass</option>

													<option dna_max=0 dna_val=0<?php echo $qa_wireless_dna_curd['infosec_violation'] == "Fail" ? "selected" : "";
																				?> value="Fail">Fail</option>
													<option dna_max=0 dna_val=0<?php echo $qa_wireless_dna_curd['infosec_violation'] == "N/A" ? "selected" : "";
																				?> value="N/A">N/A</option>





												</select>
											</td>

											<!--td><input type="text" class="form-control" name="data[used_Suggested_Closing_Spiel_comment]" value="<?php // echo $qa_wireless_dna_curd['used_Suggested_Closing_Spiel_comment'];
																																					?>"></td-->
											<td><input type="text" class="form-control" name="data[infosec_violation_reason]" value=""></td>
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
											<td><input type="text" readonly class="form-control" style="background-color:#000000;color:white; font-weight:bold;text-align:center" id="custAcmEarned" name="data[custAcmEarned]" value="<?php echo $qa_wireless_dna_curd['custAcmEarned'] ?>"></td>
											<td>Earned:</td>
											<td><input type="text" readonly class="form-control" style="background-color:#000000;color:white; font-weight:bold;text-align:center" id="busiAcmEarned" name="data[busiAcmEarned]" value="<?php echo $qa_wireless_dna_curd['busiAcmEarned'] ?>"></td>
											<td>Earned:</td>
											<td colspan="2"><input type="text" readonly class="form-control" style="background-color:#000000;color:white; font-weight:bold;text-align:center"  id="complAcmEarned" name="data[complAcmEarned]" value="<?php echo $qa_wireless_dna_curd['complAcmScore']; ?>"></td>
										</tr>
										<tr style="background-color:#123456;color:white; font-weight:bold">
											<td>Possible:</td>
											<td><input type="text" readonly class="form-control" style="background-color:#000000;color:white; font-weight:bold;text-align:center" id="custAcmPossible" name="data[custAcmPossible]" value="<?php echo $qa_wireless_dna_curd['custAcmPossible'] ?>"></td>
											<td>Possible:</td>
											<td><input type="text" readonly class="form-control" style="background-color:#000000;color:white; font-weight:bold;text-align:center" id="busiAcmPossible" name="data[busiAcmPossible]" value="<?php echo $qa_wireless_dna_curd['busiAcmPossible'] ?>"></td>
											<td>Possible:</td>
											<td colspan="2"><input type="text" readonly style="background-color:#000000;color:white; font-weight:bold;text-align:center" class="form-control" id="complAcmPossible" name="data[complAcmPossible]" value="<?php echo $qa_wireless_dna_curd['complAcmScore']; //echo $qa_wireless_dna_curd['custAcmEarned'] 
																																								?>"></td>
										</tr>
										<tr style="background-color:#123456;color:white; font-weight:bold">
											<td>Percentage:</td>
											<td><input type="text" readonly style="background-color:Purple;color:white; font-weight:bold;text-align:center" class="form-control" id="custAcmScore" name="data[custAcmScore]" value="<?php echo $qa_wireless_dna_curd['custAcmScore'] ?>"></td>
											<td>Percentage:</td>
											<td><input type="text" readonly style="background-color:Purple;color:white; font-weight:bold;text-align:center" class="form-control" id="busiAcmScore" name="data[busiAcmScore]" value="<?php echo $qa_wireless_dna_curd['busiAcmScore'] ?>"></td>
											<td>Percentage:</td>
											<td colspan="2"><input type="text" readonly style="background-color:Purple;color:white; font-weight:bold;text-align:center" class="form-control" id="complAcmScore" name="data[complAcmScore]" value="<?php echo $qa_wireless_dna_curd['complAcmScore'] ?>"></td>
										</tr>




										<!-- end--->




										<!-- tobe added-->
										<tr>
											<td>Call Observation:</td>
											<td colspan=2><textarea class="form-control" name="data[call_summary]"><?php  $qa_wireless_dna_curd['call_summary'] ?></textarea></td>
											<td>Feedback:</td>
											<td colspan="4"><textarea class="form-control" name="data[feedback]"><?php  $qa_wireless_dna_curd['feedback'] ?></textarea></td>
										</tr>

										<tr>
											<td colspan=2>Upload Files :- </td>
											<td colspan=2> [avi,mp4,3gp,mpeg,mpg,mov,mp3,flv,wmv,mkv] </td>
											<?php if ($ajio_id == 0) { ?>
												<!--td colspan="5"><input type="file"  accept="audio/*,video/*"      multiple class="form-control" id="attach_file" name="attach_file[]" style="padding: 10px 0 0 10px;"></td-->
												<td colspan="5"><input type="file"    data-file_types="audio/*,video/*"    multiple class="form-control" id="attach_file" name="attach_file[]" style="padding: 10px 0 0 10px;"></td>
												
													
												
												
												<?php
											} else {
												if ($$qa_wireless_dna_curd['attach_file'] != '') { ?>
													<td colspan=4>
														<?php $attach_file = explode(",", $qa_wireless_dna_curd['attach_file']);
														foreach ($attach_file as $mp) { ?>
															<audio controls='' style="background-color:#607F93">
																<source src="<?php echo base_url(); ?>qa_files/qa_wireless_dna/inbound/<?php echo $mp; ?>" type="audio/ogg">
																<source src="<?php echo base_url(); ?>qa_files/qa_wireless_dna/inbound/<?php echo $mp; ?>" type="audio/mpeg">
															</audio> </br>
														<?php
														} ?>
													</td>
											<?php
												} else {
													echo '<td colspan=6><b> No Files</b></td>';
												}
											} ?>
													

										</tr>









										<?php if ($ajio_id != 0) { ?>
											<tr>
												<td colspan=2 style="font-size:12px; font-weight:bold">Agent Feedback Status: <span style="font-size:12px;color:red">*</span></td>
												<td colspan=4><?php echo $qa_wireless_dna_curd['agnt_fd_acpt'] ?></td>
											</tr>
											<tr>
												<td colspan=2 style="font-size:12px; font-weight:bold">Agent Review:<span style="font-size:12px;color:red">*</span></td>
												<td colspan=4><?php echo $qa_wireless_dna_curd['agent_rvw_note'] ?></td>
											</tr>
											<tr>
												<td colspan=2 style="font-size:12px; font-weight:bold">Management Review:<span style="font-size:12px;color:red">*</span></td>
												<td colspan=4><?php echo $qa_wireless_dna_curd['mgnt_rvw_note'] ?></td>
											</tr>
											<tr>
												<td colspan=2 style="font-size:12px; font-weight:bold">Client Review:<span style="font-size:12px;color:red">*</span></td>
												<td colspan=4><?php echo $qa_wireless_dna_curd['client_rvw_note'] ?></td>
											</tr>

											<tr>
												<td colspan=2 style="font-size:12px">Your Review<span style="font-size:24px;color:red">*</span></td>
												<td colspan=4><textarea class="form-control1" style="width:100%" id="note" name="note"></textarea></td>
											</tr>
										<?php
										} ?>


										<?php
										if ($ajio_id == 0) {
											if (is_access_qa_module() == true || is_access_qa_operations_module() == true) { ?>
												<tr>
													<td colspan=9><button class="btn btn-success waves-effect" type="submit" id="qaformsubmit"  name='btnSave'  style="width:500px">SAVE</button></td>
												</tr>
												<?php
											}
										} else {
											if (is_access_qa_module() == true || is_access_qa_operations_module() == true) {
												if (is_available_qa_feedback($qa_wireless_dna_curd['entry_date'], 72) == true) { ?>
													<tr>
														<td colspan="9"><button class="btn btn-success waves-effect" type="submit" id='qaformsubmit' name='btnSave' value="SAVE" style="width:500px">SAVE</button></td>
													</tr>
										<?php
												}
											}
										}
										?>

										<!-- end --->
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