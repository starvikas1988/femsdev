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

<?php if ($att_id != 0) {
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
											<td colspan="8" id="theader" style="font-size:40px; text-align:center!important; ">Fiber Connect Greenspace QA FORM</td>
											<input type="hidden" name="audit_start_time" value="<?php echo CurrMySqlDate(); ?>">
										</tr>
										<?php
										if ($att_id == 0) {
											$auditorName = get_username();
											$auditDate = CurrDateMDY();
											//$auditDate =  CurrDateTimeMDY();
											$clDate_val = '';
										} else {
											if ($greenspace_data['entry_by'] != '') {
												$auditorName = $greenspace_data['auditor_name'];
											} else {
												$auditorName = $greenspace_data['client_name'];
											}
											//$new = explode("-", $greenspace_data['audit_date']);
											//$new1 = explode(" ", $new[2]);
											//print_r($new);
											$auditDate = mysql2mmddyy($greenspace_data['audit_date']);
										 //    $at = array($new[1], $new1[0], $new[0]);
										 //    $n_date = implode("/", $at);
											// $auditDate = ($n_date)." ".$new1[1];
											$clDate_val = mysql2mmddyy($greenspace_data['call_date']);
										}

										if ($rand_id != 0) {
											$agent_id = $rand_data['sid'];
											$fusion_id = $rand_data['fusion_id'];
											$agent_name = $rand_data['fname'] . " " . $rand_data['lname'];
											$tl_id = $rand_data['assigned_to'];
											$tl_name = $rand_data['tl_name'];
											$call_duration = $rand_data['call_duration'];
											
										} else {
											$agent_id = $greenspace_data['agent_id'];
											$fusion_id = $greenspace_data['fusion_id'];
											$agent_name = $greenspace_data['fname'] . " " . $greenspace_data['lname'] ;
											$tl_id = $greenspace_data['tl_id'];
											$tl_name = $greenspace_data['tl_name'];
											$call_duration = $greenspace_data['call_duration'];
										}
										?>
										<tr>
											<td>Auditor Name: <span style="font-size:24px;color:red">*</span></td>
											<td colspan="2"><input type="text" class="form-control" value="<?= $auditorName; ?>" disabled></td>
											<td>Audit Date:<span style="font-size:24px;color:red">*</span></td>
											<td colspan="2"><input type="text" class="form-control" value="<?= $auditDate; ?>" disabled></td>
											<td>Call Date:<span style="font-size:24px;color:red">*</span></td>
											<td colspan="2">
												<input type="text" id="call_date" name="call_date"  onkeydown="return false;" value="<?php echo $clDate_val; ?>" max="<?php echo date("Y-m-d"); ?>" class="form-control" required>
											</td>
										</tr>
										<tr>
											<td>Agent Name:<span style="font-size:24px;color:red">*</span></td>
											<td colspan="2">
												<select class="form-control" id="agent_id" name="data[agent_id]" required>
													<?php 
													if($greenspace_data['agent_id']!=''){
														?>
														<option value="<?php echo $greenspace_data['agent_id'] ?>"><?php echo $greenspace_data['fname'] . " " . $greenspace_data['lname'] ?></option>
														<?php
													}else{
														?>
														<option value="">Select</option>
														<?php
													}
													?>
													
													
													<?php foreach ($agentName as $row) :  ?>
													<?php 
													if($row['id'] == $greenspace_data['agent_id']){
														continue;
													}else{
														?>
														<option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
														<?php
													}
													?>
														
													<?php endforeach; ?>
												</select>
											</td>
											<td>Fusion ID:<span style="font-size:24px;color:red">*</span></td>
											<td colspan="2"><input type="text" class="form-control" id="fusion_id" required value="<?php echo $greenspace_data['fusion_id'] ?>" readonly></td>
											<td> L1 Supervisor:<span style="font-size:24px;color:red">*</span></td>
											<td colspan="2">

												<input type="text" class="form-control" id="tl_names"  value="<?php echo $tl_name ?>" readonly>
												<input type="hidden" class="form-control" id="tl_id" name="data[tl_id]" value="<?php echo $tl_id ?>" required>
											</td>
										</tr>
										<tr>
											<td>ACPT:<span style="font-size:24px;color:red">*</span></td>
											<td colspan="2">
												<select class="form-control" id="" name="data[acpt]" required>
											
											    <option value="">-Select-</option>
											    <option value="Agent" <?= ($greenspace_data['acpt']=="Agent")?"selected":"" ?>>Agent</option>
												<option value="Customer" <?= ($greenspace_data['acpt']=="Customer")?"selected":"" ?>>Customer</option>
												<option value="Process" <?= ($greenspace_data['acpt']=="Process")?"selected":"" ?>>Process</option>
												<option value="Technology" <?= ($greenspace_data['acpt']=="Technology")?"selected":"" ?>>Technology</option>
												<option value="NA" <?= ($greenspace_data['acpt']=="NA")?"selected":"" ?>>NA</option>
											
										</select>
											</td>
											<td>L1 Analysis:<span style="font-size:24px;color:red">*</span></td>
											<td colspan="2">
												<input type="text" class="form-control" name="data[L1]" value="<?php echo $greenspace_data['L1'] ?>" required>
											</td>
											<td>L2 Analysis:<span style="font-size:24px;color:red">*</span></td>
											<td colspan="2">
												<input type="text" class="form-control" name="data[L2]" value="<?php echo $greenspace_data['L2'] ?>" required>
											</td>
										</tr>
								
										<tr>
											<td>Call Duration:<span style="font-size:24px;color:red">*</span></td>
											<td colspan="2"><input type="text" class="form-control" onkeydown="return false;" id="call_duration" name="data[call_duration]" value="<?php echo $call_duration; ?>" required></td>
											<td>Contact No.:<span style="font-size:24px;color:red">*</span></td>
											<td colspan=2>
												<input type="text" autocomplete="off" name="data[phone]" class="form-control" id="phone_no" value="<?php echo $greenspace_data['phone']; ?>" required>
											</td>
											<td>VOC:<span style="font-size:24px;color:red">*</span></td>
											<td colspan="2">
												<select class="form-control" id="voc" name="data[voc]" required>
													
													<option value="">-Select-</option>
													<option value="1"  <?= ($greenspace_data['voc']=="1")?"selected":"" ?>>1</option>
													<option value="2"  <?= ($greenspace_data['voc']=="2")?"selected":"" ?>>2</option>
													<option value="3"  <?= ($greenspace_data['voc']=="3")?"selected":"" ?>>3</option>
													<option value="4"  <?= ($greenspace_data['voc']=="4")?"selected":"" ?>>4</option>
													<option value="5"  <?= ($greenspace_data['voc']=="5")?"selected":"" ?>>5</option>
												</select>
											</td>
										</tr>
										<tr>
											<td>Audit Type:<span style="font-size:24px;color:red">*</span></td>
											<td colspan="2">
												<select class="form-control" id="audit_type" name="data[audit_type]" required>
                                                    <option value="">-Select-</option>
                                                    <option value="CQ Audit" <?= ($greenspace_data['audit_type']=="CQ Audit")?"selected":"" ?>>CQ Audit</option>
                                                    <option value="BQ Audit" <?= ($greenspace_data['audit_type']=="BQ Audit")?"selected":"" ?>>BQ Audit</option>
                                                    <option value="Calibration" <?= ($greenspace_data['audit_type']=="Calibration")?"selected":"" ?>>Calibration</option>
                                                    <option value="Pre-Certificate Mock Call" <?= ($greenspace_data['audit_type']=="Pre-Certificate Mock Call")?"selected":"" ?>>Pre-Certificate Mock Call</option>
                                                    <option value="Certification Audit" <?= ($greenspace_data['audit_type']=="Certification Audit")?"selected":"" ?>>Certification Audit</option>
                                                    <option value="WoW Call"  <?= ($greenspace_data['audit_type']=="WoW Call")?"selected":"" ?>>WoW Call</option>
                                                    <option value="Hygiene Audit"  <?= ($greenspace_data['audit_type']=="Hygiene Audit")?"selected":"" ?>>Hygiene Audit</option>
                                                    <option value="Operation Audit"  <?= ($greenspace_data['audit_type']=="Operation Audit")?"selected":"" ?>>Operation Audit</option>
                                                    <option value="Trainer Audit"  <?= ($greenspace_data['audit_type']=="Trainer Audit")?"selected":"" ?>>Trainer Audit</option> 
                                                    <option value="QA Supervisor Audit"  <?= ($greenspace_data['audit_type']=="QA Supervisor Audit")?"selected":"" ?>>QA Supervisor Audit</option>   
                                                </select>
											</td>
											<td class="auType_epi">Auditor Type<span style="font-size:24px;color:red">*</span></td>
											<td class="auType_epi">
												<select class="form-control" id="auditor_type" name="data[auditor_type]">
                                                    <option value="">Select</option>
                                                    <option value="Master" <?= ($greenspace_data['auditor_type']=="Master")?"selected":"" ?>>Master</option>
                                                    <option value="Regular" <?= ($greenspace_data['auditor_type']=="Regular")?"selected":"" ?>>Regular</option>
                                                </select>
											</td>
										</tr>
										<tr>
											<td style="font-weight:bold; font-size:16px; text-align:left">Earned Score</td>
											<td colspan="2"><input type="text" readonly id="fiber_connect_greenspace_earned_score" name="data[earned_score]" class="form-control" value="<?php echo $greenspace_data['earned_score'] ?>" /></td>
											<td style="font-weight:bold; font-size:16px; text-align:left">Possible Score</td>
											<td colspan="2"><input type="text" readonly id="fiber_connect_greenspace_possible_score" name="data[possible_score]" class="form-control" value="<?php echo $greenspace_data['possible_score'] ?>" /></td>
											<td style="font-weight:bold; font-size:16px; text-align:right">Overall Score:</td>
											<td colspan="2"><input type="text" readonly id="fiber_connect_greenspace_overallscore" name="data[overall_score]" class="form-control greenspaceFatal" style="font-weight:bold" value="<?php echo $greenspace_data['overall_score'] ?>"></td>
										</tr>
										<tr class="eml" style="height:25px; font-weight:bold">
											<td colspan=3>PARAMETER</td>
											<td>MARKS</td>
											<td>REMARKS</td>
											<td colspan=2>COMMENT</td>
											<td>Criticality</td>
										</tr>

										<tr>
											<td colspan=3>1.Opening- Did the agent greeted on call and also introduced the brand as well as himself/herself on call?</td>
											<td>5</td>
											<td>
												<select class="form-control fiber_connect_greenspace_point business" name="data[opening]" required>
													
													<option fiber_connect_val=5 fiber_connect_max="5"<?php echo $greenspace_data['opening'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option fiber_connect_val=0 fiber_connect_max="5" <?php echo $greenspace_data['opening'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													<option fiber_connect_val=5 fiber_connect_max="5" <?php echo $greenspace_data['opening'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt1]" class="form-control" value="<?php echo $greenspace_data['cmt1'] ?>"></td>
											<td style="font-weight:bold; background-color:#D7BDE2">Business</td>
										</tr>
										<tr>
											<td colspan=3>2.Decision Maker- Did the agent asked the customer about the position in the business?</td>
											<td>4</td>
											<td>
												<select class="form-control fiber_connect_greenspace_point business" name="data[decision_maker]" required>
													
													<option fiber_connect_val=4 fiber_connect_max="4"<?php echo $greenspace_data['decision_maker'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option fiber_connect_val=0 fiber_connect_max="4" <?php echo $greenspace_data['decision_maker'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													<option fiber_connect_val=4 fiber_connect_max="4" <?php echo $greenspace_data['decision_maker'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt2]" class="form-control" value="<?php echo $greenspace_data['cmt2'] ?>"></td>
											<td style="font-weight:bold; background-color:#D7BDE2">Business</td>
										</tr>
										<tr>
											<td colspan=3>3.Discovery Questions -Did the agent did proper discovery question to suggest the perfect plan?</td>
											<td>5</td>
											<td>
												<select class="form-control fiber_connect_greenspace_point business" name="data[discovery_questions]" required>
													
													<option fiber_connect_val=5 fiber_connect_max="5"<?php echo $greenspace_data['discovery_questions'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option fiber_connect_val=0 fiber_connect_max="5" <?php echo $greenspace_data['discovery_questions'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													<option fiber_connect_val=5 fiber_connect_max="5" <?php echo $greenspace_data['discovery_questions'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt3]" class="form-control" value="<?php echo $greenspace_data['cmt3'] ?>"></td>
											<td style="font-weight:bold; background-color:#D7BDE2">Business</td>
										</tr>
										<tr>
											<td colspan=3>4.Education: Did the agent educate the customer as what are the reason for the call and why the changes need to be done?</td>
											<td>5</td>
											<td>
												<select class="form-control fiber_connect_greenspace_point business" name="data[education]" required>
													
													<option fiber_connect_val=5 fiber_connect_max="5"<?php echo $greenspace_data['education'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option fiber_connect_val=0 fiber_connect_max="5" <?php echo $greenspace_data['education'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													<option fiber_connect_val=5 fiber_connect_max="5" <?php echo $greenspace_data['education'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt4]" class="form-control" value="<?php echo $greenspace_data['cmt4'] ?>"></td>
											<td style="font-weight:bold; background-color:#D7BDE2">Business</td>
										</tr>
										<tr>
											<td colspan=3>5.Plan & Tariff -Did the agent explained the plan which he/she is providing?</td>
											<td>5</td>
											<td>
												<select class="form-control fiber_connect_greenspace_point business" name="data[plan_tariff]" required>
													
													<option fiber_connect_val=5 fiber_connect_max="5"<?php echo $greenspace_data['plan_tariff'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option fiber_connect_val=0 fiber_connect_max="5" <?php echo $greenspace_data['plan_tariff'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													<option fiber_connect_val=5 fiber_connect_max="5" <?php echo $greenspace_data['plan_tariff'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt5]" class="form-control" value="<?php echo $greenspace_data['cmt5'] ?>"></td>
											<td style="font-weight:bold; background-color:#D7BDE2">Business</td>
										</tr>
										<tr>
											<td colspan=3>6.Appointment Setting - Did the agent asked proper date and time for the technician to visit?</td>
											<td>5</td>
											<td>
												<select class="form-control fiber_connect_greenspace_point business" name="data[appointment_setting]" required>
													
													<option fiber_connect_val=5 fiber_connect_max="5"<?php echo $greenspace_data['appointment_setting'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option fiber_connect_val=0 fiber_connect_max="5" <?php echo $greenspace_data['appointment_setting'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													<option fiber_connect_val=5 fiber_connect_max="5" <?php echo $greenspace_data['appointment_setting'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt6]" class="form-control" value="<?php echo $greenspace_data['cmt6'] ?>"></td>
											<td style="font-weight:bold; background-color:#D7BDE2">Business</td>
										</tr>
										<tr>
											<td colspan=3 class="text-danger">7.Agent provided correct information on call and no mal-practices were observed during processing of sales.</td>
											<td>10</td>
											<td>
												<select class="form-control fiber_connect_greenspace_point compliance" id ="greenspaceAF1" name="data[correct_information]" required>
													
													<option fiber_connect_val=10 fiber_connect_max="10" <?php echo $greenspace_data['correct_information'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option fiber_connect_val=0 fiber_connect_max="10" <?php echo $greenspace_data['correct_information'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													<option fiber_connect_val=10 fiber_connect_max="10" <?php echo $greenspace_data['correct_information'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt7]" class="form-control" value="<?php echo $greenspace_data['cmt7'] ?>"></td>
											<td style="font-weight:bold; background-color:#D7BDE2">Complaince</td>
										</tr>
										<tr>
											<td colspan=3 class="text-danger">8.Sales Authorization - Did the agent asked the authorization question on the call and took a clear customer response on it?</td>
											<td>10</td>
											<td>
												<select class="form-control fiber_connect_greenspace_point compliance" id ="greenspaceAF2" name="data[sales_authorization]" required>
													
													<option fiber_connect_val=10 fiber_connect_max="10" <?php echo $greenspace_data['sales_authorization'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option fiber_connect_val=0 fiber_connect_max="10" <?php echo $greenspace_data['sales_authorization'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													<option fiber_connect_val=10 fiber_connect_max="10" <?php echo $greenspace_data['sales_authorization'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt8]" class="form-control" value="<?php echo $greenspace_data['cmt8'] ?>"></td>
											<td style="font-weight:bold; background-color:#D7BDE2">Complaince</td>
										</tr>
										<tr>
											<td colspan=3>9.Sound Energetic- Did the agent sound energetic on call?</td>
											<td>5</td>
											<td>
												<select class="form-control fiber_connect_greenspace_point customer" name="data[sound_energetic]" required>
													
													<option fiber_connect_val=5 fiber_connect_max="5"<?php echo $greenspace_data['sound_energetic'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option fiber_connect_val=0 fiber_connect_max="5" <?php echo $greenspace_data['sound_energetic'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													<option fiber_connect_val=5 fiber_connect_max="5" <?php echo $greenspace_data['sound_energetic'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt9]" class="form-control" value="<?php echo $greenspace_data['cmt9'] ?>"></td>
											<td style="font-weight:bold; background-color:#D7BDE2">Customer</td>
										</tr>
										<tr>
											<td colspan=3>10.Communication - Did the agent showed good communication skills?</td>
											<td>5</td>
											<td>
												<select class="form-control fiber_connect_greenspace_point customer" name="data[communication]" required>
													
													<option fiber_connect_val=5 fiber_connect_max="5"<?php echo $greenspace_data['communication'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option fiber_connect_val=0 fiber_connect_max="5" <?php echo $greenspace_data['communication'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													<option fiber_connect_val=5 fiber_connect_max="5" <?php echo $greenspace_data['communication'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt10]" class="form-control" value="<?php echo $greenspace_data['cmt10'] ?>"></td>
											<td style="font-weight:bold; background-color:#D7BDE2">Customer</td>
										</tr>
										<tr>
											<td colspan=3>11.Rapport Building - Did the agent used the chances of building rapport on call?</td>
											<td>5</td>
											<td>
												<select class="form-control fiber_connect_greenspace_point customer" name="data[rapport_building]" required>
													
													<option fiber_connect_val=5 fiber_connect_max="5"<?php echo $greenspace_data['rapport_building'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option fiber_connect_val=0 fiber_connect_max="5" <?php echo $greenspace_data['rapport_building'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													<option fiber_connect_val=5 fiber_connect_max="5" <?php echo $greenspace_data['rapport_building'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt11]" class="form-control" value="<?php echo $greenspace_data['cmt11'] ?>"></td>
											<td style="font-weight:bold; background-color:#D7BDE2">Customer</td>
										</tr>
										<tr>
											<td colspan=3>12.Hold Verbiage- Did the agent used proper hold vebiages on call?</td>
											<td>6</td>
											<td>
												<select class="form-control fiber_connect_greenspace_point customer" name="data[hold_verbiage]" required>
													
													<option fiber_connect_val=6 fiber_connect_max="6"<?php echo $greenspace_data['hold_verbiage'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option fiber_connect_val=0 fiber_connect_max="6" <?php echo $greenspace_data['hold_verbiage'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													<option fiber_connect_val=6 fiber_connect_max="6" <?php echo $greenspace_data['hold_verbiage'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt12]" class="form-control" value="<?php echo $greenspace_data['cmt12'] ?>"></td>
											<td style="font-weight:bold; background-color:#D7BDE2">Customer</td>
										</tr>
										<tr>
											<td colspan=3>13.Sales Summary - Did the agent provided a sales summary before processing the order?</td>
											<td>10</td>
											<td>
												<select class="form-control fiber_connect_greenspace_point customer" name="data[sales_summary]" required>
													
													<option fiber_connect_val=10 fiber_connect_max="10"<?php echo $greenspace_data['sales_summary'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option fiber_connect_val=0 fiber_connect_max="10" <?php echo $greenspace_data['sales_summary'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													<option fiber_connect_val=10 fiber_connect_max="10" <?php echo $greenspace_data['sales_summary'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt13]" class="form-control" value="<?php echo $greenspace_data['cmt13'] ?>"></td>
											<td style="font-weight:bold; background-color:#D7BDE2">Customer</td>
										</tr>
										<tr>
											<td colspan=3>14.Process Knowledge - Agent was able to answer all customer's questions?</td>
											<td>5</td>
											<td>
												<select class="form-control fiber_connect_greenspace_point customer" name="data[process_knowledge]" required>
													
													<option fiber_connect_val=5 fiber_connect_max="5"<?php echo $greenspace_data['process_knowledge'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option fiber_connect_val=0 fiber_connect_max="5" <?php echo $greenspace_data['process_knowledge'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													<option fiber_connect_val=5 fiber_connect_max="5" <?php echo $greenspace_data['process_knowledge'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt14]" class="form-control" value="<?php echo $greenspace_data['cmt14'] ?>"></td>
											<td style="font-weight:bold; background-color:#D7BDE2">Customer</td>
										</tr>
										<tr>
											<td colspan=3>15.Did the agent mentioned the downtime and installation fee to the customer on the call?</td>
											<td>5</td>
											<td>
												<select class="form-control fiber_connect_greenspace_point customer" name="data[downtime_installation]" required>
													
													<option fiber_connect_val=5 fiber_connect_max="5"<?php echo $greenspace_data['downtime_installation'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option fiber_connect_val=0 fiber_connect_max="5" <?php echo $greenspace_data['downtime_installation'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													<option fiber_connect_val=5 fiber_connect_max="5" <?php echo $greenspace_data['downtime_installation'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt15]" class="form-control" value="<?php echo $greenspace_data['cmt15'] ?>"></td>
											<td style="font-weight:bold; background-color:#D7BDE2">Customer</td>
										</tr>
										<tr>
											<td colspan=3>16.Closing - Did the agent thanked the customer and properly closed the call?</td>
											<td>10</td>
											<td>
												<select class="form-control fiber_connect_greenspace_point customer" name="data[closing]" required>
													
													<option fiber_connect_val=10 fiber_connect_max="10"<?php echo $greenspace_data['closing'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option fiber_connect_val=0 fiber_connect_max="10" <?php echo $greenspace_data['closing'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													<option fiber_connect_val=10 fiber_connect_max="10" <?php echo $greenspace_data['closing'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt16]" class="form-control" value="<?php echo $greenspace_data['cmt16'] ?>"></td>
											<td style="font-weight:bold; background-color:#D7BDE2">Customer</td>
										</tr>

									<tr style="font-weight:bold; background-color:#D7BDE2">
										<td colspan=3>Customer Score</td>
										<td colspan=3>Business Score</td>
										<td colspan=3>Compliance Score</td>
									</tr>

									<tr style="font-weight:bold; background-color:#D7BDE2">
										<td>Earned Point:</td><td colspan=2><input type="text" readonly class="form-control" id="customer_earned_score" name="data[customer_earned_score]" value="<?php echo $greenspace_data['customer_earned_score'] ?>"></td>
										<td>Earned Point:</td><td colspan=2><input type="text" readonly class="form-control" id="business_earned_score" name="data[business_earned_score]" value="<?php echo $greenspace_data['business_earned_score'] ?>"></td>
										<td>Earned Point:</td><td colspan=2><input type="text" readonly class="form-control" id="compliance_earned_score" name="data[compliance_earned_score]" value="<?php echo $greenspace_data['compliance_earned_score'] ?>"></td>
									</tr>
									<tr style="font-weight:bold; background-color:#D7BDE2">
										<td>Possible Point:</td><td colspan=2><input type="text" readonly class="form-control" id="customer_possible_score" name="data[customer_possible_score]" value="<?php echo $greenspace_data['customer_possible_score'] ?>"></td>
										<td>Possible Point:</td><td colspan=2><input type="text" readonly class="form-control" id="business_possible_score" name="data[business_possible_score]" value="<?php echo $greenspace_data['business_possible_score'] ?>"></td>
										<td>Possible Point:</td><td colspan=2><input type="text" readonly class="form-control" id="compliance_possible_score" name="data[compliance_possible_score]" value="<?php echo $greenspace_data['compliance_possible_score'] ?>"></td>
									</tr>
									<tr style="font-weight:bold; background-color:#D7BDE2">
										<td>Overall Percentage:</td><td colspan=2><input type="text" readonly class="form-control" id="customer_overall_score" name="data[customer_overall_score]" value="<?php echo $greenspace_data['customer_overall_score'] ?>"></td>
										<td>Overall Percentage:</td><td colspan=2><input type="text" readonly class="form-control" id="business_overall_score" name="data[business_overall_score]" value="<?php echo $greenspace_data['business_overall_score'] ?>"></td>
										<td>Overall Percentage:</td><td colspan=2><input type="text" readonly class="form-control" id="compliance_overall_score" name="data[compliance_overall_score]" value="<?php echo $greenspace_data['compliance_overall_score'] ?>"></td>
									</tr>

										<tr>
											<td>Call Summary:</td>
											<td colspan=2><textarea class="form-control" name="data[call_summary]"><?php echo $greenspace_data['call_summary'] ?></textarea></td>
											<td>Feedback:</td>
											<td colspan=4><textarea class="form-control" name="data[feedback]"><?php echo $greenspace_data['feedback'] ?></textarea></td>
										</tr>
										<tr>
											<td colspan=2>Upload Files [m4a,mp4,mp3,wav]</td>
											<?php if ($att_id == 0) { ?>
												<td colspan=6>
													<input type="file" name="attach_file[]" id="attach_file" accept=".m4a,.mp4,.mp3,.wav,audio/*" />
												</td>
												<?php } else {
												if ($greenspace_data['attach_file'] != '') { ?>
													<td colspan=6>
														<input type="file" multiple class="form-control"  id="attach_file" name="attach_file[]" accept=".m4a,.mp4,.mp3,.wav,audio/*"> 
														<?php $attach_file = explode(",", $greenspace_data['attach_file']);
														foreach ($attach_file as $mp) { ?>
															<audio controls='' style="background-color:#607F93">
																<source src="<?php echo base_url(); ?>qa_files/qa_att/greenspace/<?php echo $mp; ?>" type="audio/ogg">
																<source src="<?php echo base_url(); ?>qa_files/qa_att/greenspace/<?php echo $mp; ?>" type="audio/mpeg">
															</audio> </br>
														<?php } ?>
													</td>
											<?php } else {
													echo '<td colspan=6>
													<input type="file" multiple class="form-control" id="attach_file" name="attach_file[]" accept=".m4a,.mp4,.mp3,.wav,audio/*">
													<b>No Files</b></td>';
												}
											} ?>
										</tr>

										<?php if ($att_id != 0) { ?>
											<tr>
												<td colspan=2 style="font-size:16px; font-weight:bold">Agent Feedback Acceptance:</td>
												<td colspan=6><?php echo $greenspace_data['agnt_fd_acpt'] ?></td>
											</tr>
											<tr>
												<td colspan=2 style="font-size:16px; font-weight:bold">Agent Review:</td>
												<td colspan=6><?php echo $greenspace_data['agent_rvw_note'] ?></td>
											</tr>
											<tr>
												<td colspan=2 style="font-size:16px; font-weight:bold">Management Review:</td>
												<td colspan=6><?php echo $greenspace_data['mgnt_rvw_note'] ?></td>
											</tr>
											<tr>
												<td colspan=2 style="font-size:16px; font-weight:bold">Client Review:</td>
												<td colspan=6><?php echo $greenspace_data['client_rvw_note'] ?></td>
											</tr>

											<tr>
												<td colspan=2 style="font-size:16px">Your Review<span style="font-size:24px;color:red">*</span></td>
												<td colspan=6><textarea class="form-control1" style="width:100%" id="note" name="note" required></textarea></td>
											</tr>
										<?php } ?>

										<?php
										if ($att_id == 0) {
											if (is_access_qa_module() == true || is_access_qa_operations_module() == true) { ?>
												<tr>
													<td colspan=8><button class="btn btn-success blains-effect" type="submit" id="qaformsubmit" style="width:500px;margin:auto;display:block;">SAVE</button></td>
												</tr>
												<?php
											}
										} else {
											if (is_access_qa_module() == true || is_access_qa_operations_module() == true) {
												if (is_available_qa_feedback($greenspace_data['entry_date'], 72) == true) { ?>
													<tr>
														<td colspan="8"><button class="btn btn-success blains-effect" type="submit" id='qaformsubmit' name='btnSave' value="SAVE" style="width:500px;margin:auto;display:block;">SAVE</button></td>
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