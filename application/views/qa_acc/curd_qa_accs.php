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
											<td colspan="8" id="theader" style="background-color:#E9967A; font-size:40px;color:white"> ACC QA Form </td>
											<input type="hidden" name="audit_start_time" value="<?php echo CurrMySqlDate(); ?>">
										</tr>
										<?php if ($ajio_id == 0) {
											$auditorName = get_username();
											$auditDate = CurrDateMDY();
											$clDate_val = CurrDateMDY();
										} else {
											if ($qa_accs_curd["entry_by"] != "") {
												$auditorName = $qa_accs_curd["auditor_name"];
											} else {
												$auditorName = $qa_accs_curd["client_name"];
											}
											$auditDate = mysql2mmddyy($qa_accs_curd["audit_date"]);
											$clDate_val = mysql2mmddyy($qa_accs_curd["audit_date"]);
										} ?>


										<tr>
											<td> </td>
										</tr>

										<tr>
											<td style="width:100px;">Auditor Name:<span style="font-size:24px;color:red">*</span></td>
											<td style="width:200px;"><input type="text" class="form-control" value="<?php echo $auditorName; ?>" disabled></td>
											<td>Audit Date:</td>
											<td style="width:200px;"><input type="text" class="form-control" value="<?php echo $auditDate; ?>" disabled></td>
											<td>Call Date :<span style="font-size:24px;color:red">*</span></td>

											<td ><input type="text" onkeypress="return false;" class="form-control" id="call_date" name="call_date" autocomplete="off"  required></td>


										</tr>
										<tr>
											<td>Agent Name:<span style="font-size:24px;color:red">*</span></td>
											<td >
												<select class="form-control" id="agent_id" name="data[agent_id]" required>

													<option value="">-Select-</option>
													<?php foreach ($agentName as $row) : ?>
														<option value="<?php echo $row["id"]; ?>"><?php echo $row["name"]; ?></option>
													<?php
													endforeach; ?>
												</select>
											</td>
											<td>Employee ID:<span style="font-size:24px;color:red">*</span></td>
											<td ><input type="text" class="form-control" id="fusion_id" value="" readonly></td>
											<td>L1 Supervisor:<span style="font-size:24px;color:red">*</span></td>
											<td >
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
											<td ><input type="text" class="form-control" name="data[call_id]" autocomplete="off" value="" required></td>

											<td>VOC: <span style="font-size:24px;color:red">*</span></td>
											<td >
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
											<td >
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

											<td>Interaction: Initial Call:<span style="font-size:24px;color:red">*</span></td>
											<td >
												<select class="form-control" id="Initial" name="data[Initial]" required>
														<option value="">-Select-</option>
													<option accs_max=0 accs_val=0<?php echo $qa_accs_curd['Initial'] == "Yes" ? "selected" : ""; ?> value="Yes">Yes </option>
													<option accs_max=0 accs_val=0<?php echo $qa_accs_curd['Initial'] == "No" ? "selected" : ""; ?> value="No">No </option>

												</select>
											</td>


											<td> Interaction: Follow Up 1<span style="font-size:24px;color:red">*</span></td>
											<td>
												<select class="form-control" id="up1" name="data[up1]" required>
														<option value="">-Select-</option>
													<option accs_max=0 accs_val=0<?php echo $qa_accs_curd['up1'] == "Yes" ? "selected" : ""; ?> value="Yes">Yes </option>
													<option accs_max=0 accs_val=0<?php echo $qa_accs_curd['up1'] == "No" ? "selected" : ""; ?> value="No">No </option>

												</select>
											</td>

											<td> Interaction: Follow Up 2:<span style="font-size:24px;color:red">*</span></td>
											<td>
												<select class="form-control" id="up2" name="data[up2]" required>
														<option value="">-Select-</option>
													<option accs_max=0 accs_val=0<?php echo $qa_accs_curd['up2'] == "Yes" ? "selected" : ""; ?> value="Yes">Yes </option>
													<option accs_max=0 accs_val=0<?php echo $qa_accs_curd['up2'] == "No" ? "selected" : ""; ?> value="No">No </option>

												</select>
											</td>





										</tr>



<tr>
	<td style="color:red"> Infraction :<span style="font-size:24px;color:red">*</span></td>
	<td >
		<select class="form-control accs" id="form_submits" name="data[form_submits]" required>
				<option value="">-Select-</option>
			<option accs_max=0 accs_val=0<?php echo $qa_accs_curd['form_submits'] == "Yes" ? "selected" : ""; ?> value="Yes">Yes </option>
			<option accs_max=0 accs_val=0<?php echo $qa_accs_curd['form_submits'] == "No" ? "selected" : ""; ?> value="No">No </option>

		</select>
	</td>

	<td>Phone Number::<span style="font-size:24px;color:red">*</span></td>
	<td ><input type="Number" min="10000" max="10000000000000"class="form-control" name="data[phone_no]" autocomplete="off" value="" required></td>

	<td class="auType_epis">	Reason </td>
	<td class="auType_epis">
<input type="text" class="form-control" id="extra" name="data[extra]" autocomplete="off" value="">
	</td>

</tr>

<!--tr>
	<td class="auType_epis">	Reason </td>
	<td class="auType_epis">
<input type="text" class="form-control" id="extra" name="data[extra]" autocomplete="off" value="">
	</td>

</tr-->


<tr>

											<td>Sale :<span style="font-size:24px;color:red">*</span></td>
											<td>
												<select class="form-control" id="sales" name="data[sales]" required>
														<option value="">-Select-</option>
													<option accs_max=0 accs_val=0<?php echo $qa_accs_curd['sales'] == "Yes" ? "selected" : ""; ?> value="Yes">Yes </option>
													<option accs_max=0 accs_val=0<?php echo $qa_accs_curd['sales'] == "No" ? "selected" : ""; ?> value="No">No </option>

												</select>
											</td>
	<td> UCID :<span style="font-size:24px;color:red">*</span></td>
	<td ><input type="text" class="form-control" name="data[UCID]" autocomplete="off" value="" required></td>



	<td> Disposition :<span style="font-size:24px;color:red">*</span></td>
	<td >
		<select class="form-control" id="form_submits" name="data[Disposition]" required>
				<option value="">-Select-</option>
			<option accs_max=0 accs_val=0<?php echo $qa_accs_curd['Disposition'] == "Yes" ? "selected" : ""; ?> value="Yes">Yes </option>
			<option accs_max=0 accs_val=0<?php echo $qa_accs_curd['Disposition'] == "No" ? "selected" : ""; ?> value="No">No </option>

		</select>
	</td>



</tr>


										<tr>
											<td style="font-weight:bold; font-size:12px; text-align:right">Earned Score:</td>
											<td><input type="text" readonly id="earned_score" name="data[earned_score]" class="form-control" style="font-weight:bold" value="<?php echo $qa_accs_curd['earned_score'] ?>"></td>
											<td style="font-weight:bold; font-size:12px; text-align:right">Possible Score:</td>
											<td ><input type="text" readonly id="possible_score" name="data[possible_score]" class="form-control" style="font-weight:bold" value="<?php echo $qa_accs_curd['possible_score'] ?>"></td>
											<td style="font-weight:bold; font-size:12px; text-align:right">Overall Score:</td>
											<td colspan="2"><input type="text" readonly id="overall_score" name="data[overall_score]" class="form-control" style="font-weight:bold" value="<?php echo $qa_accs_curd['overall_score'] ?>"></td>
										</tr>

										<!--tr style="background-color:#85C1E9; font-weight:bold"-->
										<tr style="background-color:#E9967A; font-size:40px;color:white;font-weight:bold">
										<td>Parameter</td>
										<!--td> Overall Weight</td-->
										<td colspan=2>Sub Parameter</td>
										<td> Weight</td>

										<td style="width:200px;">Defect</td>


										<td style="width:250px;display:inline-block;border:none;"> Reason</td>
									</tr>
										<tr>
											<td rowspan=5 style="background-color:#123456;color:white; font-weight:bold">Initial </td>

		<td colspan=2 style="color:black"> Opening </td>
											<td> 3 </td>

											<td>
												<select class="form-control accs" id="Opening" name="data[Opening]" required>
													<option accs_max=3 accs_val=3<?php echo $qa_accs_curd['Opening'] == "Yes" ? "selected" : ""; ?> value="Yes">Yes </option>
													<option accs_max=3 accs_val=0<?php echo $qa_accs_curd['Opening'] == "No" ? "selected" : ""; ?> value="No">No </option>
													<option accs_max=3 accs_val=3<?php echo $qa_accs_curd['Opening'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A </option>
												</select>
											</td>
											<td><input type="text" class="form-control" name="data[Opening_reason]" value=""></td>
										</tr>
										<tr>
											<td colspan=2> Greeting</td>
											<!--td> Agent must read and ask the 's understanding about the terms and condition when applying for a SIMCARD. </td-->
											<td> 3</td>

											<td>
												<select class="form-control accs " id="Greeting" name="data[Greeting]" required>
													<option accs_max=3 accs_val=3<?php echo $qa_accs_curd['Greeting'] == "Yes" ? "selected" : ""; ?> value="Yes">Yes </option>
													<option accs_max=3 accs_val=0<?php echo $qa_accs_curd['Greeting'] == "No" ? "selected" : ""; ?> value="No">No </option>
													<option accs_max=3 accs_val=3<?php echo $qa_accs_curd['Greeting'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A </option>
												</select>
											</td>
											<!--td><input type="text" class="form-control" name="data[Greeting_comment]"  value="<?php //echo $qa_accs_curd['Greeting_comment'];
																																					?>"></td--->
											<td><input type="text" class="form-control" name="data[Greeting_reason]" value=""></td>
										</tr>

										<tr>

											<!-- start--->


										</tr>
										<tr>



											<!---end---->
										</tr>
										<tr>

											<!-- start-->
											<!--td rowspan=5> 20%</td--->
											<td colspan=2 style="color:black">Owner Discovery </td>
											<!--td> The agent should ablle to identify and understand the issue of the  / Good comprehension skill</td-->
											<td> 7</td>

											<td>
												<select class="form-control accs " id="Discovery" name="data[Discovery]" required>



													<option accs_max=7 accs_val=7<?php echo $qa_accs_curd['Discovery'] == "Yes" ? "selected" : "";
																				?> value="Yes">Yes</option>
													<option accs_max=7 accs_val=0<?php echo $qa_accs_curd['Discovery'] == "No" ? "selected" : "";
																				?> value="No">No</option>
													<option accs_max=7 accs_val=7<?php echo $qa_accs_curd['Discovery'] == "N/A" ? "selected" : "";
																				?> value="N/A">N/A</option>

												</select>
											</td>
											<!--td><input type="text" class="form-control" name="data[	Discovery_comment]"  value="<?php //echo $qa_accs_curd['	Discovery_comment'];
																																					?>"></td-->
											<td><input type="text" class="form-control" name="data[Discovery_reason]" value=""></td>

										</tr>
										<tr>
											<td style="background-color:#123456;color:white; font-weight:bold">Soft Skill </td>
											<td colspan=2 style="color:black"> Professionalism</td>
											<!--td> Agent should follow the hold procedures like "May I place this line on hold for 2 minutes? I will just check my resources"</td-->
											<td> 5</td>

											<td>
												<select class="form-control accs " id="Professionalism" name="data[Professionalism]" required>


													<option accs_max=5 accs_val=5<?php echo $qa_accs_curd['Professionalism'] == "Yes" ? "selected" : "";
																				?> value="Yes">Yes</option>
													<option accs_max=5 accs_val=0<?php echo $qa_accs_curd['Professionalism'] == "No" ? "selected" : "";
																				?> value="No">No</option>
													<option accs_max=5 accs_val=5<?php echo $qa_accs_curd['Professionalism'] == "N/A" ? "selected" : "";
																				?> value="N/A">N/A</option>

												</select>
											</td>
											<!--td><input type="text" class="form-control" name="data[Professionalism_comment]"  value="<?php //echo $qa_accs_curd['Professionalism_comment'];
																																				?>"></td-->
											<td><input type="text" class="form-control" name="data[Professionalism_reason]" value=""></td>
										</tr>
										<tr>
											<!--end-->
											<td rowspan="6" style="background-color:#123456;color:white; font-weight:bold">Call handling
 </td>
											<td colspan=2>Rebuttals</td>
											<!--td> Dead air should not be more than 10 seconds.</td-->
											<td> 10</td>

											<td>
												<select class="form-control accs " id="Rebuttals" name="data[Rebuttals]" required>


													<option accs_max=10 accs_val=10<?php echo $qa_accs_curd['Rebuttals'] == "Yes" ? "selected" : "";
																				?> value="Yes">Yes</option>
													<option accs_max=10 accs_val=0<?php echo $qa_accs_curd['Rebuttals'] == "No" ? "selected" : "";
																				?> value="No">No</option>
													<option accs_max=10 accs_val=10<?php echo $qa_accs_curd['Rebuttals'] == "N/A" ? "selected" : "";
																				?> value="N/A">N/A</option>


												</select>
											</td>
											<!--td><input type="text" class="form-control" name="data[Rebuttals_comment]"  value="<?php // echo $qa_accs_curd['Rebuttals_comment'];
																																	?>"></td-->
											<td><input type="text" class="form-control" name="data[Rebuttals_reason]" value=""></td>
										</tr>
										<tr>
											<td colspan=2>Urgency </td>
											<!--td> The agent should pause whenever there's an Urgency / apologize if necessary</td-->
											<td> 8</td>

											<td>
												<select class="form-control accs " id="Urgency" name="data[Urgency]" required>


													<option accs_max=8 accs_val=8<?php echo $qa_accs_curd['Urgency'] == "Yes" ? "selected" : "";
																				?> value="Yes">Yes</option>
													<option accs_max=8 accs_val=0<?php echo $qa_accs_curd['Urgency'] == "No" ? "selected" : "";
																				?> value="No">No</option>
													<option accs_max=8 accs_val=8<?php echo $qa_accs_curd['Urgency'] == "N/A" ? "selected" : "";
																				?> value="N/A">N/A</option>
												</select>
											</td>
											<!--td><input type="text" class="form-control" name="data[Urgency_comment]"  value="<?php //echo $qa_accs_curd['Urgency_comment'];
																																		?>"></td-->
											<td><input type="text" class="form-control" name="data[Urgency_reason]" value=""></td>
										</tr>
										<tr>
											<td colspan=2>Education regarding Change and improvement  would get</td>
											<!--td>It is important that the agent engaes with the  to build a more personalized conversation. Agent should find an opportunity to start a conversation based on the information provided by the .</td--->
											<td> 10</td>

											<td>
												<select class="form-control accs " id="Education" name="data[Education]" required>


													<option accs_max=10 accs_val=10<?php echo $qa_accs_curd['Education'] == "Yes" ? "selected" : "";
																				?> value="Yes">Yes</option>
													<option accs_max=10 accs_val=0<?php echo $qa_accs_curd['Education'] == "No" ? "selected" : "";
																				?> value="No">No</option>
													<option accs_max=10 accs_val=10<?php echo $qa_accs_curd['Education'] == "N/A" ? "selected" : "";
																				?> value="N/A">N/A</option>

												</select>
											</td>
											<!--td><input type="text" class="form-control" name="data[Education_comment]" value="<?php //echo $qa_accs_curd['Education_comment'];
																																			?>"></td-->
											<td><input type="text" class="form-control" name="data[Education_reason]" value=""></td>
										</tr>

										<tr>

											<!--td rowspan=4 style="font-weight:bold">30 </td-->
											<td colspan=2>Resolution/assistance if customer use any other provider </td>


											<td> 5</td>

											<td>
												<select class="form-control accs" id="Resolution" name="data[Resolution]" required>


													<option accs_max=5 accs_val=5<?php echo $qa_accs_curd['Resolution'] == "Yes" ? "selected" : "";
																					?> value="Yes">Yes</option>
													<option accs_max=5 accs_val=0<?php echo $qa_accs_curd['Resolution'] == "No" ? "selected" : "";
																					?> value="No">No</option>

													<option accs_max=5 accs_val=5<?php echo $qa_accs_curd['Resolution'] == "N/A" ? "selected" : "";
																					?> value="N/A">N/A</option>
												</select>
											</td>
											<!--td><input type="text" class="form-control" name="data[Resolution_comment]" value="<?php echo $qa_accs_curd['Resolution_comment']; ?>"></td-->
											<td><input type="text" class="form-control" name="data[Resolution_reason]" value=""></td>
										</tr>
										<tr>
											<td colspan=2>Adequate Probing</td>
											<!--td> Agent must ask only necessary questions that will lead to the  concerns. <br> Agent must ask the travel dates,passport name,email address,billing address and the serial number of the SIMCARD.</td--->
											<td>7</td>

											<td>
												<select class="form-control accs " id="Probing" name="data[Probing]" required>


													<option accs_max=7 accs_val=7<?php echo $qa_accs_curd['Probing'] == "Yes" ? "selected" : "";
																				?> value="Yes">Yes</option>
													<option accs_max=7 accs_val=0<?php echo $qa_accs_curd['Probing'] == "No" ? "selected" : "";
																				?> value="No">No</option>
													<option accs_max=7 accs_val=7<?php echo $qa_accs_curd['Probing'] == "N/A" ? "selected" : "";
																				?> value="N/A">N/A</option>

												</select>
											</td>
											<!--td><input type="text" class="form-control" name="data[Probing_comment]" value="<?php // echo $qa_accs_curd['Probing_comment'];
																																		?>"></td-->
											<td><input type="text" class="form-control" name="data[Probing_reason]" value=""></td>
										</tr>

											<!-- start -->
										<tr>


											<td colspan=2>Product Knowledge</td>

											<td> 10</td>

											<td>
												<select class="form-control accs " id="Knowledge" name="data[Knowledge]" required>

													<option accs_max=10 accs_val=10<?php echo $qa_accs_curd['Knowledge'] == "Yes" ? "selected" : "";
																					?> value="Yes">Yes</option>
													<option accs_max=10 accs_val=0<?php echo $qa_accs_curd['Knowledge'] == "No" ? "selected" : "";
																					?> value="No">No</option>
													<option accs_max=10 accs_val=10<?php echo $qa_accs_curd['Knowledge'] == "N/A" ? "selected" : "";
																					?> value="N/A">N/A</option>




												</select>
											</td>
											<!--td><input type="text" class="form-control" name="data[Knowledge_comment]" value="<?php //echo $qa_accs_curd['Knowledge_comment'];
																																				?>"></td-->
											<td><input type="text" class="form-control" name="data[Knowledge_reason]" value=""></td>

										</tr>



											<!-- start -->
										<tr>
											<td rowspan=4 style="background-color:#123456;color:white; font-weight:bold">Sales </td>

											<td colspan=2>Correct Information</td>

											<td> 10</td>

											<td>
												<select class="form-control accs " id="Information" name="data[Information]" required>

													<option accs_max=10 accs_val=10<?php echo $qa_accs_curd['Information'] == "Yes" ? "selected" : "";
																					?> value="Yes">Yes</option>
													<option accs_max=10 accs_val=0<?php echo $qa_accs_curd['Information'] == "No" ? "selected" : "";
																					?> value="No">No</option>
													<option accs_max=10 accs_val=10<?php echo $qa_accs_curd['Information'] == "N/A" ? "selected" : "";
																					?> value="N/A">N/A</option>




												</select>
											</td>
											<!--td><input type="text" class="form-control" name="data[Knowledge_comment]" value="<?php //echo $qa_accs_curd['Knowledge_comment'];
																																				?>"></td-->
											<td><input type="text" class="form-control" name="data[Information_reason]" value=""></td>

										</tr>
										<tr>
											<td colspan=2>On call resolution (addressed all query of customer)
  </td>

											<td> 5</td>

											<td>

												<select class="form-control accs " id="assistance" name="data[assistance]" required>


													<option accs_max=5 accs_val=5<?php echo $qa_accs_curd['assistance'] == "Yes" ? "selected" : "";
																					?> value="Yes">Yes</option>
													<option accs_max=5 accs_val=0<?php echo $qa_accs_curd['assistance'] == "No" ? "selected" : "";
																					?> value="No">No</option>
													<option accs_max=5 accs_val=5<?php echo $qa_accs_curd['assistance'] == "N/A" ? "selected" : "";
																					?> value="N/A">N/A</option>

												</select>
											</td>
											<!--td><input type="text" class="form-control" name="data[assistance_comment]" value="<?php //echo $qa_accs_curd['assistance_comment'];
																																						?>"></td-->
											<td><input type="text" class="form-control" name="data[assistance_reason]" value=""></td>
										</tr>
										<tr>

												<td colspan=2 style="color:red;">Contract prompt

  </td>

											<td> 12</td>

											<td>

												<select class="form-control accs " id="prompt" name="data[prompt]" required>


													<option accs_max=12 accs_val=12<?php echo $qa_accs_curd['prompt'] == "Pass" ? "selected" : "";
																					?> value="Pass">Pass</option>
													<option accs_max=12 accs_val=0<?php echo $qa_accs_curd['prompt'] == "Fail" ? "selected" : "";
																					?> value="Fail">Fail</option>
													<option accs_max=12 accs_val=12<?php echo $qa_accs_curd['prompt'] == "N/A" ? "selected" : "";
																					?> value="N/A">N/A</option>

												</select>
											</td>
											<!--td><input type="text" class="form-control" name="data[assistance_comment]" value="<?php //echo $qa_accs_curd['assistance_comment'];
																																						?>"></td-->
											<td><input type="text" class="form-control" name="data[prompt_reason]" value=""></td>
										</tr>
										<tr>
<td colspan=2 >Closing


  </td>

											<td> 5</td>

											<td>

												<select class="form-control accs " id="Closing" name="data[Closing]" required>


													<option accs_max=5 accs_val=5<?php echo $qa_accs_curd['Closing'] == "Yes" ? "selected" : "";
																					?> value="Yes">Yes</option>
													<option accs_max=5 accs_val=0 <?php echo $qa_accs_curd['Closing'] == "No" ? "selected" : "";
																					?> value="No">No</option>
													<option accs_max=5 accs_val=5 <?php echo $qa_accs_curd['Closing'] == "N/A" ? "selected" : "";
																					?> value="N/A">N/A</option>

												</select>
											</td>
											<!--td><input type="text" class="form-control" name="data[assistance_comment]" value="<?php //echo $qa_accs_curd['assistance_comment'];
																																						?>"></td-->
											<td><input type="text" class="form-control" name="data[Closing_reason]" value=""></td>
										</tr>
										<tr>


											<!---end--->






											<td  style="background-color:#123456;color:white; font-weight:bold">Total </td>

											<td colspan=2 style="color:black"></td>

											<td> </td>

											<td>

											</td>

											<td></td>
										</tr>

										<tr>

										</tr>






										<!--tr>


										<tr style="background-color:#123456;color:yellow; font-weight:bold">
											<td colspan=2> Score</td>
											<td colspan=2> Score</td>
											<td colspan="3"> Score</td>
										</tr>
										<tr style="background-color:#123456;color:white; font-weight:bold">
											<td>Earned:</td>
											<td><input type="text" readonly class="form-control" style="background-color:#000000;color:white; font-weight:bold;text-align:center" id="custAcmEarned" name="data[custAcmEarned]" value="<?php echo $qa_accs_curd['custAcmEarned'] ?>"></td>
											<td>Earned:</td>
											<td><input type="text" readonly class="form-control" style="background-color:#000000;color:white; font-weight:bold;text-align:center" id="busiAcmEarned" name="data[busiAcmEarned]" value="<?php echo $qa_accs_curd['busiAcmEarned'] ?>"></td>
											<td>Earned:</td>
											<td colspan="2"><input type="text" readonly class="form-control" style="background-color:#000000;color:white; font-weight:bold;text-align:center"  id="complAcmEarned" name="data[complAcmEarned]" value="<?php echo $qa_accs_curd['complAcmScore']; ?>"></td>
										</tr>
										<tr style="background-color:#123456;color:white; font-weight:bold">
											<td>Possible:</td>
											<td><input type="text" readonly class="form-control" style="background-color:#000000;color:white; font-weight:bold;text-align:center" id="custAcmPossible" name="data[custAcmPossible]" value="<?php echo $qa_accs_curd['custAcmPossible'] ?>"></td>
											<td>Possible:</td>
											<td><input type="text" readonly class="form-control" style="background-color:#000000;color:white; font-weight:bold;text-align:center" id="busiAcmPossible" name="data[busiAcmPossible]" value="<?php echo $qa_accs_curd['busiAcmPossible'] ?>"></td>
											<td>Possible:</td>
											<td colspan="2"><input type="text" readonly style="background-color:#000000;color:white; font-weight:bold;text-align:center" class="form-control" id="complAcmPossible" name="data[complAcmPossible]" value="<?php echo $qa_accs_curd['complAcmScore']; //echo $qa_accs_curd['custAcmEarned']
																																								?>"></td>
										</tr>
										<tr style="background-color:#123456;color:white; font-weight:bold">
											<td>Percentage:</td>
											<td><input type="text" readonly style="background-color:Purple;color:white; font-weight:bold;text-align:center" class="form-control" id="custAcmScore" name="data[custAcmScore]" value="<?php echo $qa_accs_curd['custAcmScore'] ?>"></td>
											<td>Percentage:</td>
											<td><input type="text" readonly style="background-color:Purple;color:white; font-weight:bold;text-align:center" class="form-control" id="busiAcmScore" name="data[busiAcmScore]" value="<?php echo $qa_accs_curd['busiAcmScore'] ?>"></td>
											<td>Percentage:</td>
											<td colspan="2"><input type="text" readonly style="background-color:Purple;color:white; font-weight:bold;text-align:center" class="form-control" id="complAcmScore" name="data[complAcmScore]" value="<?php echo $qa_accs_curd['complAcmScore'] ?>"></td>
										</tr>




										<!-- end--->




										<!-- tobe added-->
										<tr>
											<td>Call Observation:</td>
											<td colspan=2><textarea class="form-control" name="data[call_summary]"><?php  $qa_accs_curd['call_summary'] ?></textarea></td>
											<td>Feedback:</td>
											<td colspan="4"><textarea class="form-control" name="data[feedback]"><?php  $qa_accs_curd['feedback'] ?></textarea></td>
										</tr>

										<tr>
											<td colspan=2>Upload Files :- </td>
											<td colspan=2> [avi,mp4,3gp,mpeg,mpg,mov,mp3,flv,wmv,mkv] </td>
											<?php if ($ajio_id == 0) { ?>
												<!--td colspan="5"><input type="file"  accept="audio/*,video/*"      multiple class="form-control" id="attach_file" name="attach_file[]" style="padding: 10px 0 0 10px;"></td-->
												<td colspan="5"><input type="file"    data-file_types="audio/*,video/*"    multiple class="form-control" id="attach_file" name="attach_file[]" style="padding: 10px 0 0 10px;"></td>




												<?php
											} else {
												if ($$qa_accs_curd['attach_file'] != '') { ?>
													<td colspan=4>
														<?php $attach_file = explode(",", $qa_accs_curd['attach_file']);
														foreach ($attach_file as $mp) { ?>
															<audio controls='' style="background-color:#607F93">
																<source src="<?php echo base_url(); ?>qa_files/qa_accs/inbound/<?php echo $mp; ?>" type="audio/ogg">
																<source src="<?php echo base_url(); ?>qa_files/qa_accs/inbound/<?php echo $mp; ?>" type="audio/mpeg">
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
												<td colspan=4><?php echo $qa_accs_curd['agnt_fd_acpt'] ?></td>
											</tr>
											<tr>
												<td colspan=2 style="font-size:12px; font-weight:bold">Agent Review:<span style="font-size:12px;color:red">*</span></td>
												<td colspan=4><?php echo $qa_accs_curd['agent_rvw_note'] ?></td>
											</tr>
											<tr>
												<td colspan=2 style="font-size:12px; font-weight:bold">Management Review:<span style="font-size:12px;color:red">*</span></td>
												<td colspan=4><?php echo $qa_accs_curd['mgnt_rvw_note'] ?></td>
											</tr>
											<tr>
												<td colspan=2 style="font-size:12px; font-weight:bold">Client Review:<span style="font-size:12px;color:red">*</span></td>
												<td colspan=4><?php echo $qa_accs_curd['client_rvw_note'] ?></td>
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
												if (is_available_qa_feedback($qa_accs_curd['entry_date'], 72) == true) { ?>
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
