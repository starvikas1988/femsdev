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
	.eml1{
		font-size:20px;
		font-weight:bold;
		background-color:#CCD1D1;
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
<?php // .ui-datepicker .ui-datepicker-buttonpane button.ui-datepicker-current {
	 //float: left;
	// display: none;
	//used for call_duration to disable now button.
	//} ?>

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
											<td colspan="8" id="theader" style="font-size:40px; text-align:center!important; ">SQUAD STACK QA FORM</td>
											<input type="hidden" name="audit_start_time" value="<?php echo CurrMySqlDate(); ?>">
										</tr>
										<?php
										$rand_id = 0;
										
											if ($squad_stack_data['entry_by'] != '') {
												$auditorName = $squad_stack_data['auditor_name'];
											} else {
												$auditorName = $squad_stack_data['client_name'];
											}
										
											$auditDate = mysql2mmddyy($squad_stack_data['audit_date']);
										 
											$clDate_val = mysqlDt2mmddyy($squad_stack_data['call_date']);
										

										if ($rand_id != 0) {
											$agent_id = $rand_data['sid'];
											$fusion_id = $rand_data['fusion_id'];
											$agent_name = $rand_data['fname'] . " " . $rand_data['lname'];
											$tl_id = $rand_data['assigned_to'];
											$tl_name = $rand_data['tl_name'];
											$call_duration = $rand_data['call_duration'];
											
										} else {
											$agent_id = $squad_stack_data['agent_id'];
											$fusion_id = $squad_stack_data['fusion_id'];
											$agent_name = $squad_stack_data['fname'] . " " . $squad_stack_data['lname'] ;
											$tl_id = $squad_stack_data['tl_id'];
											$tl_name = $squad_stack_data['tl_name'];
											$call_duration = $squad_stack_data['call_duration'];
										}
										?>
										
										<tr>
											<td>Auditor Name: <span style="font-size:24px;color:red">*</span></td>
											<td colspan="2"><input type="text" class="form-control" value="<?= $auditorName; ?>" disabled></td>
											<td>Audit Date:<span style="font-size:24px;color:red">*</span></td>
											<td><input type="text" class="form-control" value="<?= $auditDate; ?>" disabled></td>
											<td>Call Date/Time:<span style="font-size:24px;color:red">*</span></td>
											<td>
												<input type="text" id="call_date_time" name="call_date"  onkeydown="return false;" value="<?php echo $clDate_val; ?>" max="<?php echo date("Y-m-d"); ?>" class="form-control" disabled>
											</td>
										</tr>
										<tr>
											<td>Agent Name:<span style="font-size:24px;color:red">*</span></td>
											<td colspan="2">
												<select class="form-control" id="agent_id" name="data[agent_id]" disabled>
													<option value="">-Select-</option>
													<?php foreach($agentName as $row){
														$sCss='';
														if($row['id']==$agent_id) $sCss='selected';
													?>
														<option value="<?php echo $row['id']; ?>" <?php echo $sCss; ?>><?php echo $row['name']; ?></option>
													<?php } ?>
												</select>
											</td>
											<td>Employee ID:<span style="font-size:24px;color:red">*</span></td>
											<td><input type="text" class="form-control" id="fusion_id" disabled value="<?php echo $fusion_id; ?>" readonly></td>
											<td> L1 <br>Supervisor:<span style="font-size:24px;color:red">*</span></td>
											<td>
												<input type="text" class="form-control" id="tl_name"  value="<?php echo $tl_name; ?>" readonly>
												<input type="hidden" class="form-control" id="tl_id" name="data[tl_id]" value="<?php echo $tl_id; ?>" disabled>
											</td>
										</tr>
										
										<tr>
											<td>Call Duration:<span style="font-size:24px;color:red">*</span></td>
											<td colspan="2"><input type="text" class="form-control" onkeydown="return false;" id="call_duration" name="data[call_duration]" value="<?php echo $call_duration; ?>" disabled></td>
											<td>VOC:<span style="font-size:24px;color:red">*</span></td>
											<td>
												<select class="form-control" id="voc" name="data[voc]" disabled>
													
													<option value="">-Select-</option>
													<option value="1"  <?= ($squad_stack_data['voc']=="1")?"selected":"" ?>>1</option>
													<option value="2"  <?= ($squad_stack_data['voc']=="2")?"selected":"" ?>>2</option>
													<option value="3"  <?= ($squad_stack_data['voc']=="3")?"selected":"" ?>>3</option>
													<option value="4"  <?= ($squad_stack_data['voc']=="4")?"selected":"" ?>>4</option>
													<option value="5"  <?= ($squad_stack_data['voc']=="5")?"selected":"" ?>>5</option>
													<option value="6"  <?= ($squad_stack_data['voc']=="6")?"selected":"" ?>>6</option>
													<option value="7"  <?= ($squad_stack_data['voc']=="7")?"selected":"" ?>>7</option>
													<option value="8"  <?= ($squad_stack_data['voc']=="8")?"selected":"" ?>>8</option>
													<option value="9"  <?= ($squad_stack_data['voc']=="9")?"selected":"" ?>>9</option>
													<option value="10"  <?= ($squad_stack_data['voc']=="10")?"selected":"" ?>>10</option>
												</select>
											</td>
											<td>Call Id:<span style="font-size:24px;color:red">*</span></td>
											<td>
												<input type="text" class="form-control" id="" name="data[call_id]" value="<?php echo $squad_stack_data['call_id'] ?>" disabled>
											</td>
										</tr>
										<tr>
											<td>KPI - ACPT:<span style="font-size:24px;color:red">*</span></td>
											<td colspan="2">
												<select class="form-control" id="" name="data[kpi_acpt]" disabled>
													<option value="">-Select-</option>
													<option value="Agent"  <?= ($squad_stack_data['kpi_acpt']=="Agent")?"selected":"" ?>>Agent</option>
													<option value="Process"  <?= ($squad_stack_data['kpi_acpt']=="Process")?"selected":"" ?>>Process</option>
													<option value="Customer"  <?= ($squad_stack_data['kpi_acpt']=="Customer")?"selected":"" ?>>Customer</option>
													<option value="Technology"  <?= ($squad_stack_data['kpi_acpt']=="Technology")?"selected":"" ?>>Technology</option>
													<option value="NA"  <?= ($squad_stack_data['kpi_acpt']=="NA")?"selected":"" ?>>NA</option>
												</select>
											</td>
											<td>Auditor's BP Id:<span style="font-size:24px;color:red">*</span></td>
											<td>
												<input type="text" class="form-control" name="data[bp_id]" value="<?php echo $squad_stack_data['bp_id'] ?>" disabled>
											</td>
											<td>Audit Type:<span style="font-size:24px;color:red">*</span></td>
											<td>
												<select class="form-control" id="audit_type" name="data[audit_type]" disabled>
                                                    <option value="">-Select-</option>
                                                    <option value="CQ Audit" <?= ($squad_stack_data['audit_type']=="CQ Audit")?"selected":"" ?>>CQ Audit</option>
                                                    <option value="BQ Audit" <?= ($squad_stack_data['audit_type']=="BQ Audit")?"selected":"" ?>>BQ Audit</option>
                                                    <option value="Calibration" <?= ($squad_stack_data['audit_type']=="Calibration")?"selected":"" ?>>Calibration</option>
                                                    <option value="Pre-Certificate Mock Call" <?= ($squad_stack_data['audit_type']=="Pre-Certificate Mock Call")?"selected":"" ?>>Pre-Certificate Mock Call</option>
                                                    <option value="Certification Audit" <?= ($squad_stack_data['audit_type']=="Certification Audit")?"selected":"" ?>>Certification Audit</option>
                                                    <option value="WoW Call"  <?= ($squad_stack_data['audit_type']=="WoW Call")?"selected":"" ?>>WoW Call</option>
                                                    <option value="Hygiene Audit"  <?= ($squad_stack_data['audit_type']=="Hygiene Audit")?"selected":"" ?>>Hygiene Audit</option>
                                                    <option value="Operation Audit"  <?= ($squad_stack_data['audit_type']=="Operation Audit")?"selected":"" ?>>Operation Audit</option>
                                                    <option value="Trainer Audit"  <?= ($squad_stack_data['audit_type']=="Trainer Audit")?"selected":"" ?>>Trainer Audit</option> 
                                                    <option value="QA Supervisor Audit"  <?= ($squad_stack_data['audit_type']=="QA Supervisor Audit")?"selected":"" ?>>QA Supervisor Audit</option> 
                                                </select>
											</td>
										</tr>
										<tr>
											
											<td class="auType_epi">Auditor Type<span style="font-size:24px;color:red">*</span></td>
											<td colspan="2"  class="auType_epi">
												<select class="form-control" id="auditor_type" name="data[auditor_type]">
                                                    <option value="">Select</option>
                                                    <option value="Master" <?= ($squad_stack_data['auditor_type']=="Master")?"selected":"" ?>>Master</option>
                                                    <option value="Regular" <?= ($squad_stack_data['auditor_type']=="Regular")?"selected":"" ?>>Regular</option>
                                                </select>
											</td>
										</tr>
										<tr>
											<td style="font-weight:bold; font-size:16px; text-align:left">Earned<br>Score</td>
											<td colspan="2"><input type="text" readonly id="squad_stack_earned_score" name="data[earned_score]" class="form-control" value="<?php echo $squad_stack_data['earned_score'] ?>" /></td>
											<td style="font-weight:bold; font-size:16px; text-align:left">Possible Score</td>
											<td><input type="text" readonly id="squad_stack_possible_score" name="data[possible_score]" class="form-control" value="<?php echo $squad_stack_data['possible_score'] ?>" /></td>
											<td style="font-weight:bold; font-size:16px; text-align:right">Overall<br>Score:</td>
											<td colspan="2"><input type="text" class="form-control squad_stackFatal" readonly id="squad_stack_overall_score" name="data[overall_score]"  style="font-weight:bold" value="<?php echo $squad_stack_data['overall_score'] ?>"></td>
										</tr>
										<tr class="eml" style="height:25px; font-weight:bold">
											<td>Criticality</td>
											<td>Customer or Business?</td>
											<td colspan=2>Parameter</td>
											<td>Weightage</td>
											<td>Status</td>
											<td colspan=2>Remarks</td>
										</tr>

										<tr>
											<td style="color:red; font-weight:bold">Critical</td>
											<td style="color:green; font-weight:bold">Business</td>
											<td colspan=2 style="color:red">Did the Sales Expert use correct disposition on call?</td>
											<td>4</td>
											<td>
												<select class="form-control squad_stack_point" id ="squadstackAF1" name="data[correct_disposition]" disabled>
													<option squad_stack_val=4 squad_stack_max="4"<?php echo $squad_stack_data['correct_disposition'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option squad_stack_val=0 squad_stack_max="4" <?php echo $squad_stack_data['correct_disposition'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													<option squad_stack_val=4 squad_stack_max="4" <?php echo $squad_stack_data['correct_disposition'] == "NA" ? "selected" : ""; ?> value="NA">NA</option>
												</select>
											</td>
											
											<td colspan=2><input type="text" disabled name="data[cmt1]" class="form-control" value="<?php echo $squad_stack_data['cmt1'] ?>"></td>
										</tr>
										<tr>
											<td style="color:red; font-weight:bold">Critical</td>
											<td style="color:green; font-weight:bold">Business</td>
											<td colspan=2>Was the call free from noise at SE's side?</td>
											<td>4</td>
											<td>
												<select class="form-control squad_stack_point" id ="" name="data[call_noise_free]" disabled>
													<option squad_stack_val=4 squad_stack_max="4"<?php echo $squad_stack_data['call_noise_free'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option squad_stack_val=0 squad_stack_max="4" <?php echo $squad_stack_data['call_noise_free'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													<option squad_stack_val=4 squad_stack_max="4" <?php echo $squad_stack_data['call_noise_free'] == "NA" ? "selected" : ""; ?> value="NA">NA</option>
												</select>
											</td>
											
											<td colspan=2><input type="text" disabled name="data[cmt2]" class="form-control" value="<?php echo $squad_stack_data['cmt2'] ?>"></td>
										</tr>
										<tr>
											<td style="color:red; font-weight:bold">Critical</td>
											<td style="color:green; font-weight:bold">Business</td>
											<td colspan=2>Did the Sales Expert modulate the rate of speech and tone when talking to the lead?</td>
											<td>4</td>
											<td>
												<select class="form-control squad_stack_point" id ="" name="data[rate_of_speech]" disabled>
													<option squad_stack_val=4 squad_stack_max="4"<?php echo $squad_stack_data['rate_of_speech'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option squad_stack_val=0 squad_stack_max="4" <?php echo $squad_stack_data['rate_of_speech'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													<option squad_stack_val=4 squad_stack_max="4" <?php echo $squad_stack_data['rate_of_speech'] == "NA" ? "selected" : ""; ?> value="NA">NA</option>
												</select>
											</td>
											
											<td colspan=2><input type="text" disabled name="data[cmt3]" class="form-control" value="<?php echo $squad_stack_data['cmt3'] ?>"></td>
										</tr>
										<tr>
											<td style="color:red; font-weight:bold">Critical</td>
											<td style="color:green; font-weight:bold">Business</td>
											<td colspan=2>Was the Sales Expert able to build rapport with the lead?</td>
											<td>4</td>
											<td>
												<select class="form-control squad_stack_point" id ="" name="data[build_rapport]" disabled>
													<option squad_stack_val=4 squad_stack_max="4"<?php echo $squad_stack_data['build_rapport'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option squad_stack_val=0 squad_stack_max="4" <?php echo $squad_stack_data['rate_of_speech'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													<option squad_stack_val=4 squad_stack_max="4" <?php echo $squad_stack_data['build_rapport'] == "NA" ? "selected" : ""; ?> value="NA">NA</option>
												</select>
											</td>
											
											<td colspan=2><input type="text" disabled name="data[cmt4]" class="form-control" value="<?php echo $squad_stack_data['cmt4'] ?>"></td>
										</tr>
										<tr>
											<td style="color:red; font-weight:bold">Critical</td>
											<td style="color:green; font-weight:bold">Business</td>
											<td colspan=2>Did the sales expert write additional notes for future reference?</td>
											<td>4</td>
											<td>
												<select class="form-control squad_stack_point" id ="" name="data[additional_notes]" disabled>
													<option squad_stack_val=4 squad_stack_max="4"<?php echo $squad_stack_data['additional_notes'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option squad_stack_val=0 squad_stack_max="4" <?php echo $squad_stack_data['additional_notes'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													<option squad_stack_val=4 squad_stack_max="4" <?php echo $squad_stack_data['additional_notes'] == "NA" ? "selected" : ""; ?> value="NA">NA</option>
												</select>
											</td>
											
											<td colspan=2><input type="text" disabled name="data[cmt5]" class="form-control" value="<?php echo $squad_stack_data['cmt5'] ?>"></td>
										</tr>
										<tr>
											<td style="color:red; font-weight:bold">Critical</td>
											<td style="color:Navy; font-weight:bold">Customer</td>
											<td colspan=2>Did sales expert follow the mandatory part of scripts?</td>
											<td>6</td>
											<td>
												<select class="form-control squad_stack_point" id ="" name="data[mandatory_part_of_scripts]" disabled>
													<option squad_stack_val=6 squad_stack_max="6"<?php echo $squad_stack_data['mandatory_part_of_scripts'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option squad_stack_val=0 squad_stack_max="6" <?php echo $squad_stack_data['mandatory_part_of_scripts'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													<option squad_stack_val=6 squad_stack_max="6" <?php echo $squad_stack_data['mandatory_part_of_scripts'] == "NA" ? "selected" : ""; ?> value="NA">NA</option>
												</select>
											</td>
											
											<td colspan=2><input type="text" disabled name="data[cmt6]" class="form-control" value="<?php echo $squad_stack_data['cmt6'] ?>"></td>
										</tr>
										<tr>
											<td style="color:red; font-weight:bold">Critical</td>
											<td style="color:Navy; font-weight:bold">Customer</td>
											<td colspan=2>Did the SE write/record correct answers to the questions provided?</td>
											<td>6</td>
											<td>
												<select class="form-control squad_stack_point" id ="" name="data[record_correct_answers]" disabled>
													<option squad_stack_val=6 squad_stack_max="6"<?php echo $squad_stack_data['record_correct_answers'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option squad_stack_val=0 squad_stack_max="6" <?php echo $squad_stack_data['record_correct_answers'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													<option squad_stack_val=6 squad_stack_max="6" <?php echo $squad_stack_data['record_correct_answers'] == "NA" ? "selected" : ""; ?> value="NA">NA</option>
												</select>
											</td>
											
											<td colspan=2><input type="text" disabled name="data[cmt7]" class="form-control" value="<?php echo $squad_stack_data['cmt7'] ?>"></td>
										</tr>
										<tr>
											<td style="color:red; font-weight:bold">Critical</td>
											<td style="color:Navy; font-weight:bold">Customer</td>
											<td colspan=2 style="color:red;">Did the Sales Expert conduct the call without using abusive words or heated words?</td>
											<td>6</td>
											<td>
												<select class="form-control squad_stack_point" id ="squadstackAF2" name="data[conduct_call_without_abusive]" disabled>
													<option squad_stack_val=6 squad_stack_max="6"<?php echo $squad_stack_data['conduct_call_without_abusive'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option squad_stack_val=0 squad_stack_max="6" <?php echo $squad_stack_data['conduct_call_without_abusive'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													<option squad_stack_val=6 squad_stack_max="6" <?php echo $squad_stack_data['conduct_call_without_abusive'] == "NA" ? "selected" : ""; ?> value="NA">NA</option>
												</select>
											</td>
											
											<td colspan=2><input type="text" disabled name="data[cmt8]" class="form-control" value="<?php echo $squad_stack_data['cmt8'] ?>"></td>
										</tr>
										<tr>
											<td style="color:red; font-weight:bold">Critical</td>
											<td style="color:Navy; font-weight:bold">Customer</td>
											<td colspan=2 style="color:red;">Did the SE do correct brand pronunciation?</td>
											<td>6</td>
											<td>
												<select class="form-control squad_stack_point" id ="squadstackAF3" name="data[correct_brand_pronunciation]" disabled>
													<option squad_stack_val=6 squad_stack_max="6"<?php echo $squad_stack_data['correct_brand_pronunciation'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option squad_stack_val=0 squad_stack_max="6" <?php echo $squad_stack_data['correct_brand_pronunciation'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													<option squad_stack_val=6 squad_stack_max="6" <?php echo $squad_stack_data['correct_brand_pronunciation'] == "NA" ? "selected" : ""; ?> value="NA">NA</option>
												</select>
											</td>
											
											<td colspan=2><input type="text" disabled name="data[cmt9]" class="form-control" value="<?php echo $squad_stack_data['cmt9'] ?>"></td>
										</tr>
										<tr>
											<td style="color:red; font-weight:bold">Critical</td>
											<td style="color:Navy; font-weight:bold">Customer</td>
											<td colspan=2 style="color:red;">Was correct information provided by SE on Price, Product & scheme?</td>
											<td>6</td>
											<td>
												<select class="form-control squad_stack_point" id ="squadstackAF4" name="data[correct_information_by_SE]" disabled>
													<option squad_stack_val=6 squad_stack_max="6"<?php echo $squad_stack_data['correct_information_by_SE'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option squad_stack_val=0 squad_stack_max="6" <?php echo $squad_stack_data['correct_information_by_SE'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													<option squad_stack_val=6 squad_stack_max="6" <?php echo $squad_stack_data['correct_information_by_SE'] == "NA" ? "selected" : ""; ?> value="NA">NA</option>
												</select>
											</td>
											
											<td colspan=2><input type="text" disabled name="data[cmt10]" class="form-control" value="<?php echo $squad_stack_data['cmt10'] ?>"></td>
										</tr>
										<tr>
											<td style="color:red; font-weight:bold">Critical</td>
											<td style="color:Navy; font-weight:bold">Customer</td>
											<td colspan=2>Was the sales expert able to probe the lead? (Define Probe and Guidelines)</td>
											<td>13</td>
											<td>
												<select class="form-control squad_stack_point" id ="" name="data[probe_lead]" disabled>
													<option squad_stack_val=13 squad_stack_max="13"<?php echo $squad_stack_data['probe_lead'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option squad_stack_val=0 squad_stack_max="13" <?php echo $squad_stack_data['probe_lead'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													<option squad_stack_val=13 squad_stack_max="13" <?php echo $squad_stack_data['probe_lead'] == "NA" ? "selected" : ""; ?> value="NA">NA</option>
												</select>
											</td>
											
											<td colspan=2><input type="text" disabled name="data[cmt11]" class="form-control" value="<?php echo $squad_stack_data['cmt11'] ?>"></td>
										</tr>
										<tr>
											<td style="color:red; font-weight:bold">Critical</td>
											<td style="color:Navy; font-weight:bold">Customer</td>
											<td colspan=2 style="color:red;">Did the agent give accurate information to the lead on the call?
(Without Misselling/misleading)</td>
											<td>6</td>
											<td>
												<select class="form-control squad_stack_point" id ="squadstackAF5" name="data[accurate_information]" disabled>
													<option squad_stack_val=6 squad_stack_max="6"<?php echo $squad_stack_data['accurate_information'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option squad_stack_val=0 squad_stack_max="6" <?php echo $squad_stack_data['accurate_information'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													<option squad_stack_val=6 squad_stack_max="6" <?php echo $squad_stack_data['accurate_information'] == "NA" ? "selected" : ""; ?> value="NA">NA</option>
												</select>
											</td>
											
											<td colspan=2><input type="text" disabled ame="data[cmt12]" class="form-control" value="<?php echo $squad_stack_data['cmt12'] ?>"></td>
										</tr>
										<tr>
											<td style="color:red; font-weight:bold">Critical</td>
											<td style="color:Navy; font-weight:bold">Customer</td>
											<td colspan=2>Did the sales expert explain all the product's benefits and solutions to the lead?</td>
											<td>13</td>
											<td>
												<select class="form-control squad_stack_point" id ="" name="data[products_benefits]" disabled>
													<option squad_stack_val=13 squad_stack_max="13"<?php echo $squad_stack_data['products_benefits'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option squad_stack_val=0 squad_stack_max="13" <?php echo $squad_stack_data['products_benefits'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													<option squad_stack_val=13 squad_stack_max="13" <?php echo $squad_stack_data['products_benefits'] == "NA" ? "selected" : ""; ?> value="NA">NA</option>
												</select>
											</td>
											
											<td colspan=2><input type="text" disabled name="data[cmt13]" class="form-control" value="<?php echo $squad_stack_data['cmt13'] ?>"></td>
										</tr>
										<tr>
											<td style="color:red; font-weight:bold">Critical</td>
											<td style="color:Navy; font-weight:bold">Customer</td>
											<td colspan=2 style="color:red;">Did the sales expert do enough to create an urgency for the deal or try to convince them? </td>
											<td>19</td>
											<td>
												<select class="form-control squad_stack_point" id ="squadstackAF6" name="data[urgency_for_deal]" disabled>
													<option squad_stack_val=19 squad_stack_max="19"<?php echo $squad_stack_data['urgency_for_deal'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option squad_stack_val=0 squad_stack_max="19" <?php echo $squad_stack_data['urgency_for_deal'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													<option squad_stack_val=19 squad_stack_max="19" <?php echo $squad_stack_data['urgency_for_deal'] == "NA" ? "selected" : ""; ?> value="NA">NA</option>
												</select>
											</td>
											
											<td colspan=2><input type="text" disabled name="data[cmt14]" class="form-control" value="<?php echo $squad_stack_data['cmt14'] ?>"></td>
										</tr>
										<tr>
											<td style="color:red; font-weight:bold">Critical</td>
											<td style="color:Navy; font-weight:bold">Customer</td>
											<td colspan=2 style="color:red;">Did the Sales Expert Handle Objections and rebuttals on calls? </td>
											<td>19</td>
											<td>
												<select class="form-control squad_stack_point" id ="squadstackAF7" name="data[handle_objections]" disabled>
													<option squad_stack_val=19 squad_stack_max="19"<?php echo $squad_stack_data['handle_objections'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option squad_stack_val=0 squad_stack_max="19" <?php echo $squad_stack_data['handle_objections'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													<option squad_stack_val=19 squad_stack_max="19" <?php echo $squad_stack_data['handle_objections'] == "NA" ? "selected" : ""; ?> value="NA">NA</option>
												</select>
											</td>
											
											<td colspan=2><input type="text" disabled name="data[cmt15]" class="form-control" value="<?php echo $squad_stack_data['cmt15'] ?>"></td>
										</tr>
										<tr>
											<td style="font-weight:bold">Not Critical</td>
											<td style="color:green; font-weight:bold">Business</td>
											<td colspan=2>Did the SE use jargons and slangs during the call? </td>
											<td>1</td>
											<td>
												<select class="form-control squad_stack_point" id ="" name="data[use_jargons]" disabled>
													<option squad_stack_val=1 squad_stack_max="1"<?php echo $squad_stack_data['use_jargons'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option squad_stack_val=0 squad_stack_max="1" <?php echo $squad_stack_data['use_jargons'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													<option squad_stack_val=1 squad_stack_max="1" <?php echo $squad_stack_data['use_jargons'] == "NA" ? "selected" : ""; ?> value="NA">NA</option>
												</select>
											</td>
											
											<td colspan=2><input type="text" disabled name="data[cmt16]" class="form-control" value="<?php echo $squad_stack_data['cmt16'] ?>"></td>
										</tr>
										<tr>
											<td style="font-weight:bold">Not Critical</td>
											<td style="color:green; font-weight:bold">Business</td>
											<td colspan=2>Did the agent actively listen to the customer without interruption?</td>
											<td>1</td>
											<td>
												<select class="form-control squad_stack_point" id ="" name="data[active_listening]" disabled>
													<option squad_stack_val=1 squad_stack_max="1"<?php echo $squad_stack_data['use_jargons'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option squad_stack_val=0 squad_stack_max="1" <?php echo $squad_stack_data['active_listening'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													<option squad_stack_val=1 squad_stack_max="1" <?php echo $squad_stack_data['active_listening'] == "NA" ? "selected" : ""; ?> value="NA">NA</option>
												</select>
											</td>
											
											<td colspan=2><input type="text" disabled name="data[cmt17]" class="form-control" value="<?php echo $squad_stack_data['cmt17'] ?>"></td>
										</tr>
										<tr>
											<td style="font-weight:bold">Not Critical</td>
											<td style="color:green; font-weight:bold">Business</td>
											<td colspan=2>Did the Sales Expert discuss the purpose of the call with the lead?</td>
											<td>1</td>
											<td>
												<select class="form-control squad_stack_point" id ="" name="data[purpose_of_call]" disabled>
													<option squad_stack_val=1 squad_stack_max="1"<?php echo $squad_stack_data['purpose_of_call'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option squad_stack_val=0 squad_stack_max="1" <?php echo $squad_stack_data['purpose_of_call'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													<option squad_stack_val=1 squad_stack_max="1" <?php echo $squad_stack_data['purpose_of_call'] == "NA" ? "selected" : ""; ?> value="NA">NA</option>
												</select>
											</td>
											
											<td colspan=2><input type="text" disabled name="data[cmt18]" class="form-control" value="<?php echo $squad_stack_data['cmt18'] ?>"></td>
										</tr>
										<tr>
											<td style="font-weight:bold">Not Critical</td>
											<td style="color:green; font-weight:bold">Business</td>
											<td colspan=2>Did the Sales Expert Greet the lead with good energy?</td>
											<td>1</td>
											<td>
												<select class="form-control squad_stack_point" id ="" name="data[greet_lead]" disabled>
													<option squad_stack_val=1 squad_stack_max="1"<?php echo $squad_stack_data['greet_lead'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option squad_stack_val=0 squad_stack_max="1" <?php echo $squad_stack_data['greet_lead'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													<option squad_stack_val=1 squad_stack_max="1" <?php echo $squad_stack_data['greet_lead'] == "NA" ? "selected" : ""; ?> value="NA">NA</option>
												</select>
											</td>
											
											<td colspan=2><input type="text" disabled name="data[cmt19]" class="form-control" value="<?php echo $squad_stack_data['cmt19'] ?>"></td>
										</tr>
										<tr>
											<td style="font-weight:bold">Not Critical</td>
											<td style="color:green; font-weight:bold">Business</td>
											<td colspan=2>Did the sales expert use correct language in conversation?</td>
											<td>1</td>
											<td>
												<select class="form-control squad_stack_point" id ="" name="data[correct_language]" disabled>
													<option squad_stack_val=1 squad_stack_max="1"<?php echo $squad_stack_data['correct_language'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option squad_stack_val=0 squad_stack_max="1" <?php echo $squad_stack_data['correct_language'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													<option squad_stack_val=1 squad_stack_max="1" <?php echo $squad_stack_data['correct_language'] == "NA" ? "selected" : ""; ?> value="NA">NA</option>
												</select>
											</td>
											
											<td colspan=2><input type="text" disabled name="data[cmt20]" class="form-control" value="<?php echo $squad_stack_data['cmt20'] ?>"></td>
										</tr>
										<tr>
											<td style="font-weight:bold">Not Critical</td>
											<td style="color:green; font-weight:bold">Business</td>
											<td colspan=2>Did the SE make the call without dead air, fumbling or using filler words?</td>
											<td>1</td>
											<td>
												<select class="form-control squad_stack_point" id ="" name="data[dead_air]" disabled>
													<option squad_stack_val=1 squad_stack_max="1"<?php echo $squad_stack_data['dead_air'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option squad_stack_val=0 squad_stack_max="1" <?php echo $squad_stack_data['dead_air'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													<option squad_stack_val=1 squad_stack_max="1" <?php echo $squad_stack_data['dead_air'] == "NA" ? "selected" : ""; ?> value="NA">NA</option>
												</select>
											</td>
											
											<td colspan=2><input type="text" disabled name="data[cmt21]" class="form-control" value="<?php echo $squad_stack_data['cmt21'] ?>"></td>
										</tr>
										<tr>
											<td style="font-weight:bold">Not Critical</td>
											<td style="color:green; font-weight:bold">Business</td>
											<td colspan=2>Was the Sales Expert empathetic towards the lead during the call?</td>
											<td>1</td>
											<td>
												<select class="form-control squad_stack_point" id ="" name="data[empathetic_towards_lead]" disabled>
													<option squad_stack_val=1 squad_stack_max="1"<?php echo $squad_stack_data['empathetic_towards_lead'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option squad_stack_val=0 squad_stack_max="1" <?php echo $squad_stack_data['empathetic_towards_lead'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													<option squad_stack_val=1 squad_stack_max="1" <?php echo $squad_stack_data['empathetic_towards_lead'] == "NA" ? "selected" : ""; ?> value="NA">NA</option>
												</select>
											</td>
											
											<td colspan=2><input type="text" disabled name="data[cmt22]" class="form-control" value="<?php echo $squad_stack_data['cmt22'] ?>"></td>
										</tr>
										<tr>
											<td style="font-weight:bold">Not Critical</td>
											<td style="color:green; font-weight:bold">Business</td>
											<td colspan=2>Did the agent follow the proper closing verbiage? (Thanked the customer for the time)</td>
											<td>1</td>
											<td>
												<select class="form-control squad_stack_point" id ="" name="data[proper_closing]" disabled>
													<option squad_stack_val=1 squad_stack_max="1"<?php echo $squad_stack_data['proper_closing'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option squad_stack_val=0 squad_stack_max="1" <?php echo $squad_stack_data['proper_closing'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													<option squad_stack_val=1 squad_stack_max="1" <?php echo $squad_stack_data['proper_closing'] == "NA" ? "selected" : ""; ?> value="NA">NA</option>
												</select>
											</td>
											
											<td colspan=2><input type="text" disabled name="data[cmt23]" class="form-control" value="<?php echo $squad_stack_data['cmt23'] ?>"></td>
										</tr>
										<tr>
											<td style="font-weight:bold">Not Critical</td>
											<td style="color:Navy; font-weight:bold">Customer</td>
											<td colspan=2>Did the sales expert close the discussion with a summarization?</td>
											<td>1</td>
											<td>
												<select class="form-control squad_stack_point" id ="" name="data[summarization]" disabled>
													<option squad_stack_val=1 squad_stack_max="1"<?php echo $squad_stack_data['summarization'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option squad_stack_val=0 squad_stack_max="1" <?php echo $squad_stack_data['summarization'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													<option squad_stack_val=1 squad_stack_max="1" <?php echo $squad_stack_data['summarization'] == "NA" ? "selected" : ""; ?> value="NA">NA</option>
												</select>
											</td>
											
											<td colspan=2><input type="text" disabled name="data[cmt24]" class="form-control" value="<?php echo $squad_stack_data['cmt24'] ?>"></td>
										</tr>

										<tr>
											<td>Call Summary:</td>
											<td colspan=3><textarea class="form-control" disabled name="data[call_summary]"><?php echo $squad_stack_data['call_summary'] ?></textarea></td>
											<td>Feedback:</td>
											<td colspan=4><textarea class="form-control" disabled name="data[feedback]"><?php echo $squad_stack_data['feedback'] ?></textarea></td>
										</tr>

										<?php if($squad_stack_data['attach_file']!=''){ ?>
									<tr oncontextmenu="return false;">
										<td colspan="2">Audio Files (Mp4/Mp3/M4a/Wav)</td>
										<td colspan="4">
											<?php $attach_file = explode(",",$squad_stack_data['attach_file']);
											 foreach($attach_file as $af){ ?>
												<audio oncontextmenu="return false;" controls controlslist="nodownload" style="background-color:#607F93">
													  <source src="<?php echo base_url(); ?>qa_files/qa_stack/inbound/<?php echo $af; ?>" type="audio/ogg">
													  <source src="<?php echo base_url(); ?>qa_files/qa_stack/inbound/<?php echo $af; ?>" type="audio/mpeg">
												</audio> </br>
											 <?php } ?>
										</td>
									</tr>
									<?php } ?>

									<tr>
										<td style="font-size:12px">Manager Review:</td>
										<td colspan="8" style="text-align:left"><?php echo $squad_stack_data['mgnt_rvw_note'] ?></td>
									</tr>
									<tr>
										<td style="font-size:12px">Client Review:</td>
										<td colspan="8" style="text-align:left"><?php echo $squad_stack_data['client_rvw_note'] ?></td>
									</tr>

									<tr><td colspan="10" style="background-color:#C5C8C8"></td></tr>
									
									 <form id="form_agent_user" method="POST" action="">
										<input type="hidden" name="squad_stack_id" class="form-control" value="<?php echo $squad_stack_id; ?>">
										
										<tr>
											<td colspan=2 style="font-size:16px">Feedback Acceptance<span style="font-size:24px;color:red">*</span></td>
											<td colspan=6>
												<select class="form-control" id="" name="agnt_fd_acpt" required="">
													<option value="">--Select--</option>
													<option <?php echo $squad_stack_data['agnt_fd_acpt']=='Acceptance'?"selected":""; ?> value="Acceptance">Acceptance</option>	
													<option <?php echo $squad_stack_data['agnt_fd_acpt']=='Not Acceptance'?"selected":""; ?> value="Not Acceptance">Not Acceptance</option>	
												</select>
											</td>
										</tr>
										<tr>
											<td colspan=2 style="font-size:16px">Your Review<span style="font-size:24px;color:red">*</span></td>
											<td colspan=6><textarea class="form-control" name="note" required><?php echo $squad_stack_data['agent_rvw_note'] ?></textarea></td>
										</tr>
										
										<?php if(is_access_qa_agent_module()==true){
										if(is_available_qa_feedback($squad_stack_data['entry_date'],72) == true){ ?>
											<tr>
												<?php if($squad_stack_data['agent_rvw_note']==''){ ?>
													<td colspan="10"><button class="btn btn-success waves-effect" type="submit" id='btnagentSave' name='btnSave' value="SAVE" style="width:500px;margin:auto;display:block;">SAVE</button></td>
												<?php } ?>
											</tr>
										<?php } 
										} ?>
									
									  </form>

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