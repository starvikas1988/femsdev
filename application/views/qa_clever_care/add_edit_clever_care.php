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

<?php if ($clever_care_id!= 0) {
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
											<td colspan="10" id="theader" style="font-size:40px">Clever Care Quality Form</td>
											<input type="hidden" name="audit_start_time" value="<?php echo CurrMySqlDate(); ?>">
										</tr>
										<?php
										if ($clever_care_id == 0) {
											$auditorName = get_username();
											$auditDate = CurrDateMDY();
											//$auditDate =  CurrDateTimeMDY();
											$clDate_val = '';
										} else {
											if ($clever_care_data['entry_by'] != '') {
												$auditorName = $clever_care_data['auditor_name'];
											} else {
												$auditorName = $clever_care_data['client_name'];
											}
											$clDate_val = mysql2mmddyySls($clever_care_data['call_date']);
											$auditDate = mysql2mmddyy($clever_care_data['audit_date']);
										}

										if ($rand_id != 0) {
											$agent_id = $rand_data['sid'];
											$fusion_id = $rand_data['fusion_id'];
											$agent_name = $rand_data['fname'] . " " . $rand_data['lname'];
											$tl_id = $rand_data['assigned_to'];
											$tl_name = $rand_data['tl_name'];
											$call_duration = $rand_data['call_duration'];
											
										} else {
											$agent_id = $clever_care_data['agent_id'];
											$fusion_id = $clever_care_data['fusion_id'];
											$agent_name = $clever_care_data['fname'] . " " . $clever_care_data['lname'] ;
											$tl_id = $clever_care_data['tl_id'];
											$tl_name = $clever_care_data['tl_name'];
											$call_duration = $clever_care_data['call_duration'];
										}
										?>
										<tr>
											<td colspan="2">Auditor Name:</td>
											<td><input type="text" class="form-control" value="<?= $auditorName; ?>" disabled></td>
											<td>Audit Date:</td>
											<td><input type="text" class="form-control" value="<?= $auditDate; ?>" disabled></td>
											<td colspan="3">Call Date:<span style="font-size:24px;color:red">*</span></td>
											<td colspan="2">
												<input type="text" id="call_date" name="call_date"  onkeydown="return false;" value="<?php echo $clDate_val; ?>" max="<?php echo date("Y-m-d"); ?>" class="form-control" required>
											</td>
										</tr>
										<tr>
											<td colspan="2">Agent Name:<span style="font-size:24px;color:red">*</span></td>
											<td>
												<select class="form-control" id="agent_id" name="data[agent_id]" required>
													<option value="">-Select-</option>
													<?php foreach($agentName as $row){
														$sCss='';
														if($row['id']==$agent_id) $sCss='selected';
													?>
														<option value="<?php echo $row['id']; ?>" <?php echo $sCss; ?>><?php echo $row['name']; ?></option>
													<?php } ?>
												</select>
											</td>
											<td>Employee ID:</td>
											<td><input type="text" class="form-control" id="fusion_id" required value="<?php echo $fusion_id; ?>" readonly></td>
											<td colspan="3">L1 supervisor:<span style="font-size:24px;color:red">*</span></td>
											<td colspan="2">
												<input type="text" class="form-control" id="tl_name" required value="<?php echo $tl_name;?>" readonly>
												<input type="hidden" class="form-control" id="tl_id" name="data[tl_id]" value="<?php echo $tl_id; ?>" required>
											</td>
										</tr>
										<tr>
											<td colspan="2">Call Link:<span style="font-size:24px;color:red">*</span></td>
											<td>
												<input type="text" id="call_link" name="data[call_link]"  value="<?php echo $clever_care_data['call_link']; ?>" class="form-control" required>
											</td>
											<td>Call Duration:<span style="font-size:24px;color:red">*</span></td>
											<td><input type="text" class="form-control" onkeydown="return false;" id="call_duration" name="data[call_duration]" value="<?php echo $call_duration; ?>" required></td>
											<td colspan="3">Account:<span style="font-size:24px;color:red">*</span></td>
											<td colspan="2">
												<input type="text" id="" name="data[account]"  value="<?php echo $clever_care_data['account']; ?>" class="form-control" required>
											</td>
										</tr>
										<tr>
											<td colspan="2">KPI - ACPT:<span style="font-size:24px;color:red">*</span></td>
											<td>
												<select class="form-control" name="data[acpt]" required>
													<option value="">-Select-</option>
                                                    <option value="Agent"  <?= ($clever_care_data['acpt']=="Agent")?"selected":"" ?>>Agent</option>
                                                    <option value="Process"  <?= ($clever_care_data['acpt']=="Process")?"selected":"" ?>>Process</option>
                                                    <option value="Customer"  <?= ($clever_care_data['acpt']=="Customer")?"selected":"" ?>>Customer</option>
                                                    <option value="Technology"  <?= ($clever_care_data['acpt']=="Technology")?"selected":"" ?>>Technology</option>
                                                    <option value="NA"  <?= ($clever_care_data['acpt']=="NA")?"selected":"" ?>>NA</option>
                                                </select>
											</td>
											<td>VOC:<span style="font-size:24px;color:red">*</span></td>
											<td>
												<select class="form-control" id="voc" name="data[voc]" required>
													
													<option value="">-Select-</option>
													<option value="1"  <?= ($clever_care_data['voc']=="1")?"selected":"" ?>>1</option>
													<option value="2"  <?= ($clever_care_data['voc']=="2")?"selected":"" ?>>2</option>
													<option value="3"  <?= ($clever_care_data['voc']=="3")?"selected":"" ?>>3</option>
													<option value="4"  <?= ($clever_care_data['voc']=="4")?"selected":"" ?>>4</option>
													<option value="5"  <?= ($clever_care_data['voc']=="5")?"selected":"" ?>>5</option>
													<option value="6"  <?= ($clever_care_data['voc']=="6")?"selected":"" ?>>6</option>
													<option value="7"  <?= ($clever_care_data['voc']=="7")?"selected":"" ?>>7</option>
													<option value="8"  <?= ($clever_care_data['voc']=="8")?"selected":"" ?>>8</option>
													<option value="9"  <?= ($clever_care_data['voc']=="9")?"selected":"" ?>>9</option>
													<option value="10"  <?= ($clever_care_data['voc']=="10")?"selected":"" ?>>10</option>
												</select>
											</td>
											<td colspan="3">Record Id:<span style="font-size:24px;color:red">*</span></td>
											<td colspan="2"><input type="text" class="form-control" id="" name="data[record_id]" value="<?php echo $clever_care_data['record_id'] ?>" required></td>
										</tr>
										<tr>
											<td colspan="2">Disposition:<span style="font-size:24px;color:red">*</span></td>
											<td><input type="text" class="form-control" id="" name="data[disposition]" value="<?php echo $clever_care_data['disposition'] ?>" required></td>
											<td>Audit Type:<span style="font-size:24px;color:red">*</span></td>
											<td>
												<select class="form-control" id="audit_type" name="data[audit_type]" required>
                                                    <option value="">-Select-</option>
                                                    <option value="CQ Audit" <?= ($clever_care_data['audit_type']=="CQ Audit")?"selected":"" ?>>CQ Audit</option>
                                                    <option value="BQ Audit" <?= ($clever_care_data['audit_type']=="BQ Audit")?"selected":"" ?>>BQ Audit</option>
                                                    <option value="Calibration" <?= ($clever_care_data['audit_type']=="Calibration")?"selected":"" ?>>Calibration</option>
                                                    <option value="Pre-Certificate Mock Call" <?= ($clever_care_data['audit_type']=="Pre-Certificate Mock Call")?"selected":"" ?>>Pre-Certificate Mock Call</option>
                                                    <option value="Certification Audit" <?= ($clever_care_data['audit_type']=="Certification Audit")?"selected":"" ?>>Certification Audit</option>
                                                    <option value="Operation Audit" <?= ($clever_care_data['audit_type']=="Operation Audit")?"selected":"" ?>>Operation Audit</option>
                                                    <option value="Trainer Audit"  <?= ($clever_care_data['audit_type']=="Trainer Audit")?"selected":"" ?>>Trainer Audit</option>
                                                    <option value="WoW Call" <?= ($clever_care_data['audit_type']=="WoW Call")?"selected":"" ?>>WoW Call</option>
                                                    <option value="Hygiene Audit"  <?= ($clever_care_data['audit_type']=="Hygiene Audit")?"selected":"" ?>>Hygiene Audit</option>
                                                    <option value="QA Supervisor Audit"  <?= ($clever_care_data['audit_type']=="QA Supervisor Audit")?"selected":"" ?>>QA Supervisor Audit</option> 
                                                </select>
											</td>
										
											<td colspan="3" class="auType">Auditor Type<span style="font-size:24px;color:red">*</span></td>
											<td colspan="2" class="auType">
												<select class="form-control" id="auditor_type" name="data[auditor_type]">
                                                    
                                                    <option value="Master" <?= ($clever_care_data['auditor_type']=="Master")?"selected":"" ?>>Master</option>
                                                    <option value="Regular" <?= ($clever_care_data['auditor_type']=="Regular")?"selected":"" ?>>Regular</option>
                                                </select>
											</td>
											
										</tr>
										
										<tr>
											<td colspan="2" style="font-weight:bold; font-size:16px; text-align:left">Earned Score</td>
											<td><input type="text" readonly id="clever_care_earned_score" name="data[earned_score]" class="form-control" value="<?php echo $clever_care_data['earned_score'] ?>" /></td>
											<td style="font-weight:bold; font-size:16px; text-align:left">Possible Score</td>
											<td><input type="text" readonly id="clever_care_possible_score" name="data[possible_score]" class="form-control" value="<?php echo $clever_care_data['possible_score'] ?>" /></td>
											<td colspan="2" style="font-weight:bold; font-size:16px; text-align:right">Overall Score:</td>
											<td colspan="2"><input type="text" readonly id="clever_care_overall_score" name="data[overall_score]" class="form-control" style="font-weight:bold" value="<?php echo $clever_care_data['overall_score'] ?>"></td>
										</tr>
										<tr class="eml" style="height:25px; font-weight:bold">
											
											<td colspan=2>PARAMETER</td>
											<td>Criticality</td>
											<td>SUB PARAMETER</td>
											<td>Weightage</td>
											<td colspan="3">Evaluation</td>
											<td colspan="2">REMARKS</td>
										</tr>

										<tr>
											<td colspan=2 class="eml" rowspan=3>Opening</td>
											<td style="color: green;">Customer</td>
											<td>Q1.Agent mentioned his/her name, trading name and determined speaking to the correct person.</td>
											<td>2</td>
											<td colspan="3">
												<select class="form-control clever_care_point customer" name="data[trading_name]" required>
													
													<option clever_care_val=2 clever_care_max="2"<?php echo $clever_care_data['trading_name'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option clever_care_val=0 clever_care_max="2"<?php echo $clever_care_data['trading_name'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													<option clever_care_val=2 clever_care_max="2"<?php echo $clever_care_data['trading_name'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											
											<td colspan="2"><input type="text" name="data[cmt1]" class="form-control" value="<?php echo $clever_care_data['cmt1'] ?>"></td>
										</tr>
										<tr>
											<td style="color: green;">Customer</td>
											<td>Q2.Agent mentioned the reason of the call through paraphrasing.</td>
											<td>2</td>
											<td colspan="3">
												<select class="form-control clever_care_point customer" name="data[reason_of_call]" required>
													
													<option clever_care_val=2 clever_care_max="2"<?php echo $clever_care_data['reason_of_call'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option clever_care_val=0 clever_care_max="2"<?php echo $clever_care_data['reason_of_call'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													<option clever_care_val=2 clever_care_max="2"<?php echo $clever_care_data['reason_of_call'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											
											<td colspan="2"><input type="text" name="data[cmt2]" class="form-control" value="<?php echo $clever_care_data['cmt2'] ?>"></td>
										</tr>
										<tr>
											<td style="color: green;">Customer</td>
											<td>Q3.Demonstrated call control effectively throughout the call by listening and acknowledging the customers needs - explicit and implicit.</td>
											<td>2</td>
											<td colspan="3">
												<select class="form-control clever_care_point customer" name="data[acknowledging_customer]" required>
													
													<option clever_care_val=2 clever_care_max="2"<?php echo $clever_care_data['acknowledging_customer'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option clever_care_val=0 clever_care_max="2"<?php echo $clever_care_data['acknowledging_customer'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													<option clever_care_val=2 clever_care_max="2"<?php echo $clever_care_data['acknowledging_customer'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											
											<td colspan="2"><input type="text" name="data[cmt3]" class="form-control" value="<?php echo $clever_care_data['cmt3'] ?>"></td>
										</tr>
										
										<tr>
											<td colspan="2" class="eml" rowspan=7>Customer Experience</td>
											<td style="color: green;">Customer</td>
											<td>Q4.Maintained friendly demeanor, built rapport and connected with the customer.</td>
											<td>2</td>
											<td colspan="3">
												<select class="form-control clever_care_point customer" name="data[built_rapport]" required>
													
													<option clever_care_val=2 clever_care_max="2"<?php echo $clever_care_data['built_rapport'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option clever_care_val=0 clever_care_max="2"<?php echo $clever_care_data['built_rapport'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													<option clever_care_val=2 clever_care_max="2"<?php echo $clever_care_data['built_rapport'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											
											<td colspan="2"><input type="text" name="data[cmt4]" class="form-control" value="<?php echo $clever_care_data['cmt4'] ?>"></td>
										</tr>
										<tr>
											<td style="color: green;">Customer</td>
											<td>Q5.Agent communicates effectively and does not have a negative effect to overall customer experience.</td>
											<td>2</td>
											<td colspan="3">
												<select class="form-control clever_care_point customer" name="data[negative_effect]" required>
													
													<option clever_care_val=2 clever_care_max="2"<?php echo $clever_care_data['negative_effect'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option clever_care_val=0 clever_care_max="2"<?php echo $clever_care_data['negative_effect'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													<option clever_care_val=2 clever_care_max="2"<?php echo $clever_care_data['negative_effect'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											
											<td colspan="2"><input type="text" name="data[cmt5]" class="form-control" value="<?php echo $clever_care_data['cmt5'] ?>"></td>
										</tr>
										<tr>
											<td style="color: green;">Customer</td>
											<td>Q6.The agent's voice is clear and can be understood throughout the call.</td>
											<td>2</td>
											<td colspan="3">
												<select class="form-control clever_care_point customer" name="data[voice_clear]" required>
													
													<option clever_care_val=2 clever_care_max="2"<?php echo $clever_care_data['voice_clear'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option clever_care_val=0 clever_care_max="2"<?php echo $clever_care_data['voice_clear'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													<option clever_care_val=2 clever_care_max="2"<?php echo $clever_care_data['voice_clear'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											
											<td colspan="2"><input type="text" name="data[cmt6]" class="form-control" value="<?php echo $clever_care_data['cmt6'] ?>"></td>
										</tr>
										<tr>
											<td style="color: green;">Customer</td>
											<td>Q7.The agent speaks with consistent speed or pace matching the customers?</td>
											<td>5</td>
											<td colspan="3">
												<select class="form-control clever_care_point customer" name="data[pace_matching]" required>
													
													<option clever_care_val=5 clever_care_max="5"<?php echo $clever_care_data['pace_matching'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option clever_care_val=0 clever_care_max="5"<?php echo $clever_care_data['pace_matching'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													<option clever_care_val=5 clever_care_max="5"<?php echo $clever_care_data['pace_matching'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											
											<td colspan="2"><input type="text" name="data[cmt7]" class="form-control" value="<?php echo $clever_care_data['cmt7'] ?>"></td>
										</tr>
										<tr>
											<td style="color: green;">Customer</td>
											<td>Q8.Actively engaged with the customer.</td>
											<td>5</td>
											<td colspan="3">
												<select class="form-control clever_care_point customer" name="data[actively_engaged]" required>
													
													<option clever_care_val=5 clever_care_max="5"<?php echo $clever_care_data['actively_engaged'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option clever_care_val=0 clever_care_max="5"<?php echo $clever_care_data['actively_engaged'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													<option clever_care_val=5 clever_care_max="5"<?php echo $clever_care_data['actively_engaged'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											
											<td colspan="2"><input type="text" name="data[cmt8]" class="form-control" value="<?php echo $clever_care_data['cmt8'] ?>"></td>
										</tr>
										<tr>
											<td style="color: green;">Customer</td>
											<td>Q9.Displayed knowledge of the product tied features to benefits/ demonstrates working knowledge of procedures and health.</td>
											<td>10</td>
											<td colspan="3">
												<select class="form-control clever_care_point customer" name="data[features_to_benefits]" required>
													
													<option clever_care_val=10 clever_care_max="10"<?php echo $clever_care_data['features_to_benefits'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option clever_care_val=0 clever_care_max="10"<?php echo $clever_care_data['features_to_benefits'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													<option clever_care_val=10 clever_care_max="10"<?php echo $clever_care_data['features_to_benefits'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											
											<td colspan="2"><input type="text" name="data[cmt9]" class="form-control" value="<?php echo $clever_care_data['cmt9'] ?>"></td>
										</tr>
										<tr>
											<td style="color: blue;">Business</td>
											<td>Q10.Did the agent listen to the customer and addressed all concerns/questions?</td>
											<td>3</td>
											<td colspan="3">
												<select class="form-control clever_care_point business" name="data[addressed_concerns]" required>
													
													<option clever_care_val=3 clever_care_max="3"<?php echo $clever_care_data['addressed_concerns'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option clever_care_val=0 clever_care_max="3"<?php echo $clever_care_data['addressed_concerns'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													<option clever_care_val=3 clever_care_max="3"<?php echo $clever_care_data['addressed_concerns'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											
											<td colspan="2"><input type="text" name="data[cmt10]" class="form-control" value="<?php echo $clever_care_data['cmt10'] ?>"></td>
										</tr>
										<tr>
											<td colspan=2 class="eml" rowspan=7>Resolution</td>
											<td style="color: blue;">Business</td>
											<td>Q11.Appropriately managed and handled objections - the agent used appropriate rebuttals and provides a solution removing obstacles in the wat to guide a purchase decision at the time.</td>
											<td>10</td>
											<td colspan="3">
												<select class="form-control clever_care_point business" name="data[handled_objections]" required>
													
													<option clever_care_val=10 clever_care_max="10"<?php echo $clever_care_data['handled_objections'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option clever_care_val=0 clever_care_max="10"<?php echo $clever_care_data['handled_objections'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													<option clever_care_val=10 clever_care_max="10"<?php echo $clever_care_data['handled_objections'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											
											<td colspan="2"><input type="text" name="data[cmt11]" class="form-control" value="<?php echo $clever_care_data['cmt11'] ?>"></td>
										</tr>
										<tr>
											<td style="color: blue;">Business</td>
											<td>Q12. Did the agent investigate the account properly?</td>
											<td>10</td>
											<td colspan="3">
												<select class="form-control clever_care_point business" name="data[investigate_account]" required>
													
													<option clever_care_val=10 clever_care_max="10"<?php echo $clever_care_data['investigate_account'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option clever_care_val=0 clever_care_max="10"<?php echo $clever_care_data['investigate_account'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													<option clever_care_val=10 clever_care_max="10"<?php echo $clever_care_data['investigate_account'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											
											<td colspan="2"><input type="text" name="data[cmt12]" class="form-control" value="<?php echo $clever_care_data['cmt12'] ?>"></td>
										</tr>
										<tr>
											<td style="color: blue;">Business</td>
											<td>Q13.Identified customer needs, getting the facts on the table.</td>
											<td>10</td>
											<td colspan="3">
												<select class="form-control clever_care_point business" name="data[getting_facts]" required>
													
													<option clever_care_val=10 clever_care_max="10"<?php echo $clever_care_data['getting_facts'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option clever_care_val=0 clever_care_max="10"<?php echo $clever_care_data['getting_facts'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													<option clever_care_val=10 clever_care_max="10"<?php echo $clever_care_data['getting_facts'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											
											<td colspan="2"><input type="text" name="data[cmt13]" class="form-control" value="<?php echo $clever_care_data['cmt13'] ?>"></td>
										</tr>
										<tr>
											<td style="color: blue;">Business</td>
											<td>Q14. Did the agent understand the customer's priorities?</td>
											<td>10</td>
											<td colspan="3">
												<select class="form-control clever_care_point business" name="data[customers_priorities]" required>
													
													<option clever_care_val=10 clever_care_max="10"<?php echo $clever_care_data['customers_priorities'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option clever_care_val=0 clever_care_max="10"<?php echo $clever_care_data['customers_priorities'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													<option clever_care_val=10 clever_care_max="10"<?php echo $clever_care_data['customers_priorities'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											
											<td colspan="2"><input type="text" name="data[cmt14]" class="form-control" value="<?php echo $clever_care_data['cmt14'] ?>"></td>
										</tr>
										<tr>
											<td style="color: blue;">Business</td>
											<td>Q15. Did the agent check the customer's availabilty?</td>
											<td>5</td>
											<td colspan="3">
												<select class="form-control clever_care_point business" name="data[customers_availabilty]" required>
													
													<option clever_care_val=5 clever_care_max="5"<?php echo $clever_care_data['customers_availabilty'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option clever_care_val=0 clever_care_max="5"<?php echo $clever_care_data['customers_availabilty'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													<option clever_care_val=5 clever_care_max="5"<?php echo $clever_care_data['customers_availabilty'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											
											<td colspan="2"><input type="text" name="data[cmt15]" class="form-control" value="<?php echo $clever_care_data['cmt15'] ?>"></td>
										</tr>
										<tr>
											<td style="color: blue;">Business</td>
											<td>Q16.Did the agent check the customer's readiness?</td>
											<td>7</td>
											<td colspan="3">
												<select class="form-control clever_care_point business" name="data[customers_readiness]" required>
													
													<option clever_care_val=7 clever_care_max="7"<?php echo $clever_care_data['customers_readiness'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option clever_care_val=0 clever_care_max="7"<?php echo $clever_care_data['customers_readiness'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													<option clever_care_val=7 clever_care_max="7"<?php echo $clever_care_data['customers_readiness'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											
											<td colspan="2"><input type="text" name="data[cmt16]" class="form-control" value="<?php echo $clever_care_data['cmt16'] ?>"></td>
										</tr>
										<tr>
											<td style="color: blue;">Business</td>
											<td>Q17.Did the agent check the customer's ability to make decisions?</td>
											<td>5</td>
											<td colspan="3">
												<select class="form-control clever_care_point business" name="data[make_decisions]" required>
													
													<option clever_care_val=5 clever_care_max="5"<?php echo $clever_care_data['make_decisions'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option clever_care_val=0 clever_care_max="5"<?php echo $clever_care_data['make_decisions'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													<option clever_care_val=5 clever_care_max="5"<?php echo $clever_care_data['make_decisions'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											
											<td colspan="2"><input type="text" name="data[cmt17]" class="form-control" value="<?php echo $clever_care_data['cmt17'] ?>"></td>
										</tr>
										<tr>
											<td colspan=2 class="eml" rowspan=2>Documentation</td>
											<td style="color: red;">Compliance</td>
											<td>Q18.Did the agent dispose the call properly?</td>
											<td>2</td>
											<td colspan="3">
												<select class="form-control clever_care_point compliance" name="data[dispose_call_properly]" required>
													
													<option clever_care_val=2 clever_care_max="2"<?php echo $clever_care_data['dispose_call_properly'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option clever_care_val=0 clever_care_max="2"<?php echo $clever_care_data['dispose_call_properly'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													<option clever_care_val=2 clever_care_max="2"<?php echo $clever_care_data['dispose_call_properly'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											
											<td colspan="2"><input type="text" name="data[cmt18]" class="form-control" value="<?php echo $clever_care_data['cmt18'] ?>"></td>
										</tr>
										<tr>
											<td style="color: red;">Compliance</td>
											<td>Q19.Did the agent document the call properly? (Interaction).</td>
											<td>2</td>
											<td colspan="3">
												<select class="form-control clever_care_point compliance" name="data[document_call_properly]" required>
													
													<option clever_care_val=2 clever_care_max="2"<?php echo $clever_care_data['document_call_properly'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option clever_care_val=0 clever_care_max="2"<?php echo $clever_care_data['document_call_properly'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													<option clever_care_val=2 clever_care_max="2"<?php echo $clever_care_data['document_call_properly'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											
											<td colspan="2"><input type="text" name="data[cmt19]" class="form-control" value="<?php echo $clever_care_data['cmt19'] ?>"></td>
										</tr>
										<tr>
											<td colspan="2" class="eml" rowspan=2>Compliance</td>
											<td style="color: red;">Compliance</td>
											<td>Q20.Did the agent verify all the information (HIPAA Compliance).</td>
											<td>2</td>
											<td colspan="3">
												<select class="form-control clever_care_point compliance" name="data[verify_information]" required>
													
													<option clever_care_val=2 clever_care_max="2"<?php echo $clever_care_data['verify_information'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option clever_care_val=0 clever_care_max="2"<?php echo $clever_care_data['verify_information'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													<option clever_care_val=2 clever_care_max="2"<?php echo $clever_care_data['verify_information'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											
											<td colspan="2"><input type="text" name="data[cmt20]" class="form-control" value="<?php echo $clever_care_data['cmt20'] ?>"></td>
										</tr>
										<tr>
											<td style="color: red;">Compliance</td>
											<td>Q21.Did the agent manipulate client/s information?</td>
											<td>2</td>
											<td colspan="3">
												<select class="form-control clever_care_point compliance" name="data[manipulate_information]" required>
													
													<option clever_care_val=2 clever_care_max="2"<?php echo $clever_care_data['manipulate_information'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option clever_care_val=0 clever_care_max="2"<?php echo $clever_care_data['manipulate_information'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													<option clever_care_val=2 clever_care_max="2"<?php echo $clever_care_data['manipulate_information'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											
											<td colspan="2"><input type="text" name="data[cmt21]" class="form-control" value="<?php echo $clever_care_data['cmt21'] ?>"></td>
										</tr>

									<tr style="font-weight:bold; background-color:#D7BDE2"><td colspan=3>Customer Score</td><td colspan=4>Business Score</td><td colspan=3>Compliance Score</td></tr>

									<tr style="font-weight:bold; background-color:#D7BDE2">
										<td>Earned Point:</td><td colspan="2"><input type="text" readonly class="form-control" id="customer_earned_score" name="data[customer_earned_score]" value="<?php echo $clever_care_data['customer_earned_score'] ?>"></td>
										<td>Earned Point:</td><td colspan="3"><input type="text" readonly class="form-control" id="business_earned_score" name="data[business_earned_score]" value="<?php echo $clever_care_data['business_earned_score'] ?>"></td>
										<td>Earned Point:</td><td colspan=2><input type="text" readonly class="form-control" id="compliance_earned_score" name="data[compliance_earned_score]" value="<?php echo $clever_care_data['compliance_earned_score'] ?>"></td>
									</tr>
									<tr style="font-weight:bold; background-color:#D7BDE2">
										<td>Possible Point:</td><td colspan="2"><input type="text" readonly class="form-control" id="customer_possible_score" name="data[customer_possible_score]" value="<?php echo $clever_care_data['customer_possible_score'] ?>"></td>
										<td>Possible Point:</td><td colspan="3"><input type="text" readonly class="form-control" id="business_possible_score" name="data[business_possible_score]" value="<?php echo $clever_care_data['business_possible_score'] ?>"></td>
										<td>Possible Point:</td><td colspan=2><input type="text" readonly class="form-control" id="compliance_possible_score" name="data[compliance_possible_score]" value="<?php echo $clever_care_data['compliance_possible_score'] ?>"></td>
									</tr>
									<tr style="font-weight:bold; background-color:#D7BDE2">
										<td>Overall Percentage:</td><td colspan="2"><input type="text" readonly class="form-control" id="customer_overall_score" name="data[customer_overall_score]" value="<?php echo $clever_care_data['customer_overall_score'] ?>"></td>
										<td>Overall Percentage:</td><td colspan="3"><input type="text" readonly class="form-control" id="business_overall_score" name="data[business_overall_score]" value="<?php echo $clever_care_data['business_overall_score'] ?>"></td>
										<td>Overall Percentage:</td><td colspan=2><input type="text" readonly class="form-control" id="compliance_overall_score" name="data[compliance_overall_score]" value="<?php echo $clever_care_data['compliance_overall_score'] ?>"></td>
									</tr>
										<tr>
											<td>Call Summary:</td>
											<td colspan=3><textarea class="form-control" name="data[call_summary]"><?php echo $clever_care_data['call_summary'] ?></textarea></td>
											<td>Feedback:</td>
											<td colspan=4><textarea class="form-control" name="data[feedback]"><?php echo $clever_care_data['feedback'] ?></textarea></td>
										</tr>
										<tr>
											<td colspan=2>Upload Files [m4a,mp4,mp3,wav]</td>
											<?php if ($clever_care_id == 0) { ?>
												<td colspan=8>
													<input type="file" name="attach_file[]" id="attach_file" accept=".m4a,.mp4,.mp3,.wav,audio/*" />
												</td>
												<?php } else {
												if ($clever_care_data['attach_file'] != '') { ?>
													<td colspan=8>
														<input type="file" multiple class="form-control"  id="attach_file" name="attach_file[]" accept=".m4a,.mp4,.mp3,.wav,audio/*"> 
														<?php $attach_file = explode(",", $clever_care_data['attach_file']);
														foreach ($attach_file as $mp) { ?>
															<audio controls='' style="background-color:#607F93">
																<source src="<?php echo base_url(); ?>qa_files/clever_care/<?php echo $mp; ?>" type="audio/ogg">
																<source src="<?php echo base_url(); ?>qa_files/clever_care/<?php echo $mp; ?>" type="audio/mpeg">
															</audio> </br>
														<?php } ?>
													</td>
											<?php } else {
													echo '<td colspan=8>
													<input type="file" multiple class="form-control" id="attach_file" name="attach_file[]" accept=".m4a,.mp4,.mp3,.wav,audio/*">
													<b>No Files</b></td>';
												}
											} ?>
										</tr>

										<?php if ($clever_care_id != 0) { ?>
											<tr>
												<td colspan=4 style="font-size:16px; font-weight:bold">Agent Feedback Acceptance:</td>
												<td colspan=4><?php echo $clever_care_data['agnt_fd_acpt'] ?></td>
											</tr>
											<tr>
												<td colspan=4 style="font-size:16px; font-weight:bold">Agent Review:</td>
												<td colspan=4><?php echo $clever_care_data['agent_rvw_note'] ?></td>
											</tr>
											<tr>
												<td colspan=4 style="font-size:16px; font-weight:bold">Management Review:</td>
												<td colspan=4><?php echo $clever_care_data['mgnt_rvw_note'] ?></td>
											</tr>
											<tr>
												<td colspan=4 style="font-size:16px; font-weight:bold">Client Review:</td>
												<td colspan=4><?php echo $clever_care_data['client_rvw_note'] ?></td>
											</tr>

											<tr>
												<td colspan=4 style="font-size:16px">Your Review<span style="font-size:24px;color:red">*</span></td>
												<td colspan=4><textarea class="form-control1" style="width:100%" id="note" name="note" required></textarea></td>
											</tr>
										<?php } ?>

										<?php
										if ($clever_care_id == 0) {
											if (is_access_qa_module() == true || is_access_qa_operations_module() == true) { ?>
												<tr>
													<td colspan=10><button class="btn btn-success waves-effect" type="submit" id="qaformsubmit" style="width:500px">SAVE</button></td>
												</tr>
												<?php
											}
										} else {
											if (is_access_qa_module() == true || is_access_qa_operations_module() == true) {
												if (is_available_qa_feedback($clever_care_data['entry_date'], 72) == true) { ?>
													<tr>
														<td colspan="10"><button class="btn btn-success waves-effect" type="submit" id='qaformsubmit' name='btnSave' value="SAVE" style="width:500px">SAVE</button></td>
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