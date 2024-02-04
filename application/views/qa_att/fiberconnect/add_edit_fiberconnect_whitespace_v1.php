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
											<td colspan="8" id="theader" style="font-size:40px; text-align:center!important; ">Fiberconnect Whitespace V1 QA FORM</td>
											<input type="hidden" name="audit_start_time" value="<?php echo CurrMySqlDate(); ?>">
										</tr>
										<?php
										if ($att_id == 0) {
											$auditorName = get_username();
											$auditDate = CurrDateMDY();
											//$auditDate =  CurrDateTimeMDY();
											$clDate_val = '';
										} else {
											if ($whitespace_v1_data['entry_by'] != '') {
												$auditorName = $whitespace_v1_data['auditor_name'];
											} else {
												$auditorName = $whitespace_v1_data['client_name'];
											}
											//$new = explode("-", $whitespace_v1_data['audit_date']);
											//$new1 = explode(" ", $new[2]);
											//print_r($new);
											$auditDate = mysql2mmddyy($whitespace_v1_data['audit_date']);
										 //    $at = array($new[1], $new1[0], $new[0]);
										 //    $n_date = implode("/", $at);
											// $auditDate = ($n_date)." ".$new1[1];
											$clDate_val = mysql2mmddyy($whitespace_v1_data['call_date']);
										}

										if ($rand_id != 0) {
											$agent_id = $rand_data['sid'];
											$fusion_id = $rand_data['fusion_id'];
											$agent_name = $rand_data['fname'] . " " . $rand_data['lname'];
											$tl_id = $rand_data['assigned_to'];
											$tl_name = $rand_data['tl_name'];
											$call_duration = $rand_data['call_duration'];
											
										} else {
											$agent_id = $whitespace_v1_data['agent_id'];
											$fusion_id = $whitespace_v1_data['fusion_id'];
											$agent_name = $whitespace_v1_data['fname'] . " " . $whitespace_v1_data['lname'] ;
											$tl_id = $whitespace_v1_data['tl_id'];
											$tl_name = $whitespace_v1_data['tl_name'];
											$call_duration = $whitespace_v1_data['call_duration'];
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
													if($whitespace_v1_data['agent_id']!=''){
														?>
														<option value="<?php echo $whitespace_v1_data['agent_id'] ?>"><?php echo $whitespace_v1_data['fname'] . " " . $whitespace_v1_data['lname'] ?></option>
														<?php
													}else{
														?>
														<option value="">Select</option>
														<?php
													}
													?>
													
													
													<?php foreach ($agentName as $row) :  ?>
													<?php 
													if($row['id'] == $whitespace_v1_data['agent_id']){
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
											<td colspan="2"><input type="text" class="form-control" id="fusion_id" required value="<?php echo $whitespace_v1_data['fusion_id'] ?>" readonly></td>
											<td> L1 Supervisor:<span style="font-size:24px;color:red">*</span></td>
											<td colspan="2">

												<input type="text" class="form-control" id="tl_names"  value="<?php echo $tl_name ?>" readonly>
												<input type="hidden" class="form-control" id="tl_id" name="data[tl_id]" value="<?php echo $tl_id ?>" required>
											</td>
										</tr>
										<tr>
											<td>KPI - ACPT:<span style="font-size:24px;color:red">*</span></td>
											<td colspan="2">
												<select class="form-control" id="" name="data[acpt]" required>
											
											    <option value="">-Select-</option>
											    <option value="Agent" <?= ($whitespace_v1_data['acpt']=="Agent")?"selected":"" ?>>Agent</option>
												<option value="Customer" <?= ($whitespace_v1_data['acpt']=="Customer")?"selected":"" ?>>Customer</option>
												<option value="Process" <?= ($whitespace_v1_data['acpt']=="Process")?"selected":"" ?>>Process</option>
												<option value="Technology" <?= ($whitespace_v1_data['acpt']=="Technology")?"selected":"" ?>>Technology</option>
												<option value="NA" <?= ($whitespace_v1_data['acpt']=="NA")?"selected":"" ?>>NA</option>
											
										</select>
											</td>
											<td>L1:<span style="font-size:24px;color:red">*</span></td>
											<td colspan="2">
												<input type="text" class="form-control" name="data[L1]" value="<?php echo $whitespace_v1_data['L1'] ?>" required>
											</td>
											<td>L2:<span style="font-size:24px;color:red">*</span></td>
											<td colspan="2">
												<input type="text" class="form-control" name="data[L2]" value="<?php echo $whitespace_v1_data['L2'] ?>" required>
											</td>
										</tr>
								
										<tr>
											<td>Call Duration:<span style="font-size:24px;color:red">*</span></td>
											<td colspan="2"><input type="text" class="form-control" onkeydown="return false;" id="call_duration" name="data[call_duration]" value="<?php echo $call_duration; ?>" required></td>
											<td>Phone No.:<span style="font-size:24px;color:red">*</span></td>
											<td colspan=2>
												<input type="text" autocomplete="off" name="data[phone]" class="form-control" id="phone_no" value="<?php echo $whitespace_v1_data['phone']; ?>" required>
											</td>
											<td>VOC:<span style="font-size:24px;color:red">*</span></td>
											<td colspan="2">
												<select class="form-control" id="voc" name="data[voc]" required>
													
													<option value="">-Select-</option>
													<option value="1"  <?= ($whitespace_v1_data['voc']=="1")?"selected":"" ?>>1</option>
													<option value="2"  <?= ($whitespace_v1_data['voc']=="2")?"selected":"" ?>>2</option>
													<option value="3"  <?= ($whitespace_v1_data['voc']=="3")?"selected":"" ?>>3</option>
													<option value="4"  <?= ($whitespace_v1_data['voc']=="4")?"selected":"" ?>>4</option>
													<option value="5"  <?= ($whitespace_v1_data['voc']=="5")?"selected":"" ?>>5</option>
												</select>
											</td>
										</tr>
										<tr>
											<td>Probable cancel:<span style="font-size:24px;color:red">*</span></td>
											<td colspan="2">
												<input type="text" class="form-control" name="data[probable_cancel]" value="<?php echo $whitespace_v1_data['probable_cancel'] ?>" required>
											</td>
											<td>Cancel Reason:<span style="font-size:24px;color:red">*</span></td>
											<td colspan="2">
												<input type="text" class="form-control" name="data[cancel_reason]" value="<?php echo $whitespace_v1_data['cancel_reason'] ?>" required>
											</td>
											<td>Audit Type:<span style="font-size:24px;color:red">*</span></td>
											<td colspan="2">
												<select class="form-control" id="audit_type" name="data[audit_type]" required>
                                                    <option value="">-Select-</option>
                                                    <option value="CQ Audit" <?= ($whitespace_v1_data['audit_type']=="CQ Audit")?"selected":"" ?>>CQ Audit</option>
                                                    <option value="BQ Audit" <?= ($whitespace_v1_data['audit_type']=="BQ Audit")?"selected":"" ?>>BQ Audit</option>
                                                    <option value="Calibration" <?= ($whitespace_v1_data['audit_type']=="Calibration")?"selected":"" ?>>Calibration</option>
                                                    <option value="Pre-Certificate Mock Call" <?= ($whitespace_v1_data['audit_type']=="Pre-Certificate Mock Call")?"selected":"" ?>>Pre-Certificate Mock Call</option>
                                                    <option value="Certification Audit" <?= ($whitespace_v1_data['audit_type']=="Certification Audit")?"selected":"" ?>>Certification Audit</option>
                                                    <option value="WoW Call"  <?= ($whitespace_v1_data['audit_type']=="WoW Call")?"selected":"" ?>>WoW Call</option>
                                                    <option value="Hygiene Audit"  <?= ($whitespace_v1_data['audit_type']=="Hygiene Audit")?"selected":"" ?>>Hygiene Audit</option>
                                                    <option value="Operation Audit"  <?= ($whitespace_v1_data['audit_type']=="Operation Audit")?"selected":"" ?>>Operation Audit</option>
                                                    <option value="Trainer Audit"  <?= ($whitespace_v1_data['audit_type']=="Trainer Audit")?"selected":"" ?>>Trainer Audit</option> 
                                                    <option value="QA Supervisor Audit"  <?= ($whitespace_v1_data['audit_type']=="QA Supervisor Audit")?"selected":"" ?>>QA Supervisor Audit</option>   
                                                </select>
											</td>
										</tr>
										<tr>
											<td class="auType_epi">Auditor Type<span style="font-size:24px;color:red">*</span></td>
											<td class="auType_epi">
												<select class="form-control" id="auditor_type" name="data[auditor_type]">
                                                    <option value="">Select</option>
                                                    <option value="Master" <?= ($whitespace_v1_data['auditor_type']=="Master")?"selected":"" ?>>Master</option>
                                                    <option value="Regular" <?= ($whitespace_v1_data['auditor_type']=="Regular")?"selected":"" ?>>Regular</option>
                                                </select>
											</td>
										</tr>
										<tr>
											<td style="font-weight:bold; font-size:16px; text-align:left">Earned Score</td>
											<td colspan="2"><input type="text" readonly id="fiber_connect_whitespace_v1_earned_score" name="data[earned_score]" class="form-control" value="<?php echo $whitespace_v1_data['earned_score'] ?>" /></td>
											<td style="font-weight:bold; font-size:16px; text-align:left">Possible<br> Score</td>
											<td colspan="2"><input type="text" readonly id="fiber_connect_whitespace_v1_possible_score" name="data[possible_score]" class="form-control" value="<?php echo $whitespace_v1_data['possible_score'] ?>" /></td>
											<td style="font-weight:bold; font-size:16px; text-align:right">Overall Score:</td>
											<td colspan="2"><input type="text" readonly id="fiber_connect_whitespace_v1_overallscore" name="data[overall_score]" class="form-control fiber_connect_whitespaceFatal" style="font-weight:bold" value="<?php echo $whitespace_v1_data['overall_score'] ?>"></td>
										</tr>
										<tr class="eml" style="height:25px; font-weight:bold">
											<td>PARAMETER</td>
											<td colspan=2>SUB PARAMETER</td>
											<td>MARKS</td>
											<td>REMARKS</td>
											<td colspan=2>COMMENT</td>
											<td>Criticality</td>
										</tr>
										<tr>
											<td class="text-danger">Opening</td>
											<td colspan=2 class="text-danger">Did the agent mentioned "on behalf of AT&T"</td>
											<td>5</td>
											<td>
												<select class="form-control fiber_connect_whitespace_v1_point compliance" id="whitespace_v1AF1" name="data[opening]" required>
													<option fiber_connect_val=5 fiber_connect_max="5"<?php echo $whitespace_v1_data['opening'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option fiber_connect_val=0 fiber_connect_max="5" <?php echo $whitespace_v1_data['opening'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													<option fiber_connect_val=5 fiber_connect_max="5" <?php echo $whitespace_v1_data['opening'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt1]" class="form-control" value="<?php echo $whitespace_v1_data['cmt1'] ?>"></td>
											<td style="font-weight:bold; background-color:#D7BDE2">Compliance</td>
										</tr>
										<tr>
											<td>Greeting</td>
											<td colspan=2>Did the agent greeted on call and also<br> introduced the brand as well as himself/herself on call?</td>
											<td>5</td>
											<td>
												<select class="form-control fiber_connect_whitespace_v1_point business" id="" name="data[greeting]" required>
													<option fiber_connect_val=5 fiber_connect_max="5"<?php echo $whitespace_v1_data['greeting'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option fiber_connect_val=0 fiber_connect_max="5" <?php echo $whitespace_v1_data['greeting'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													<option fiber_connect_val=5 fiber_connect_max="5" <?php echo $whitespace_v1_data['greeting'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt2]" class="form-control" value="<?php echo $whitespace_v1_data['cmt2'] ?>"></td>
											<td style="font-weight:bold; background-color:#D7BDE2">Business</td>
										</tr>
										<tr>
											<td>Change Purpose</td>
											<td colspan=2>Did the agent mentioned the actual purpose of<br> the call and what changes are taking place before<br> fixing the appaointment?</td>
											<td>20</td>
											<td>
												<select class="form-control fiber_connect_whitespace_v1_point business" id="" name="data[change_purpose]" required>
													<option fiber_connect_val=20 fiber_connect_max="20"<?php echo $whitespace_v1_data['change_purpose'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option fiber_connect_val=0 fiber_connect_max="20" <?php echo $whitespace_v1_data['change_purpose'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													<option fiber_connect_val=20 fiber_connect_max="20" <?php echo $whitespace_v1_data['change_purpose'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt3]" class="form-control" value="<?php echo $whitespace_v1_data['cmt3'] ?>"></td>
											<td style="font-weight:bold; background-color:#D7BDE2">Business</td>
										</tr>
										<tr>
											<td class="text-danger">Recorded Line</td>
											<td colspan=2 class="text-danger">Did the agent informed the customer that the<br> call is getting recorded?</td>
											<td>5</td>
											<td>
												<select class="form-control fiber_connect_whitespace_v1_point compliance" id="whitespace_v1AF2" name="data[recorded_line]" required>
													<option fiber_connect_val=5 fiber_connect_max="5"<?php echo $whitespace_v1_data['recorded_line'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option fiber_connect_val=0 fiber_connect_max="5" <?php echo $whitespace_v1_data['recorded_line'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													<option fiber_connect_val=5 fiber_connect_max="5" <?php echo $whitespace_v1_data['recorded_line'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt4]" class="form-control" value="<?php echo $whitespace_v1_data['cmt4'] ?>"></td>
											<td style="font-weight:bold; background-color:#D7BDE2">Compliance</td>
										</tr>
										<tr>
											<td>Sound Energetic</td>
											<td colspan=2>Did the agent sound energetic and was attentive<br> on call?</td>
											<td>5</td>
											<td>
												<select class="form-control fiber_connect_whitespace_v1_point customer" id="" name="data[sound_energetic]" required>
													<option fiber_connect_val=5 fiber_connect_max="5"<?php echo $whitespace_v1_data['sound_energetic'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option fiber_connect_val=0 fiber_connect_max="5" <?php echo $whitespace_v1_data['sound_energetic'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													<option fiber_connect_val=5 fiber_connect_max="5" <?php echo $whitespace_v1_data['sound_energetic'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt5]" class="form-control" value="<?php echo $whitespace_v1_data['cmt5'] ?>"></td>
											<td style="font-weight:bold; background-color:#D7BDE2">Customer</td>
										</tr>
										<tr>
											<td rowspan="3">Communication</td>
											<td colspan=2>Did the agent used any fillers or fumbled<br> during the call?</td>
											<td>5</td>
											<td>
												<select class="form-control fiber_connect_whitespace_v1_point customer" id="" name="data[communication]" required>
													<option fiber_connect_val=5 fiber_connect_max="5"<?php echo $whitespace_v1_data['communication'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option fiber_connect_val=0 fiber_connect_max="5" <?php echo $whitespace_v1_data['communication'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													<option fiber_connect_val=5 fiber_connect_max="5" <?php echo $whitespace_v1_data['communication'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt6]" class="form-control" value="<?php echo $whitespace_v1_data['cmt6'] ?>"></td>
											<td style="font-weight:bold; background-color:#D7BDE2">Customer</td>
										</tr>
										<tr>
											<td colspan=2>Did the agent used any jargons or improper<br> words during his/her conversation?</td>
											<td>5</td>
											<td>
												<select class="form-control fiber_connect_whitespace_v1_point customer" id="" name="data[used_jargons]" required>
													<option fiber_connect_val=5 fiber_connect_max="5"<?php echo $whitespace_v1_data['used_jargons'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option fiber_connect_val=0 fiber_connect_max="5" <?php echo $whitespace_v1_data['used_jargons'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													<option fiber_connect_val=5 fiber_connect_max="5" <?php echo $whitespace_v1_data['used_jargons'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt7]" class="form-control" value="<?php echo $whitespace_v1_data['cmt7'] ?>"></td>
											<td style="font-weight:bold; background-color:#D7BDE2">Customer</td>
										</tr>
										<tr>
											<td colspan=2>Did the agent had any issue regarding pronunciation?</td>
											<td>5</td>
											<td>
												<select class="form-control fiber_connect_whitespace_v1_point customer" id="" name="data[issue_with_pronunciation]" required>
													<option fiber_connect_val=5 fiber_connect_max="5"<?php echo $whitespace_v1_data['issue_with_pronunciation'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option fiber_connect_val=0 fiber_connect_max="5" <?php echo $whitespace_v1_data['issue_with_pronunciation'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													<option fiber_connect_val=5 fiber_connect_max="5" <?php echo $whitespace_v1_data['issue_with_pronunciation'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt8]" class="form-control" value="<?php echo $whitespace_v1_data['cmt8'] ?>"></td>
											<td style="font-weight:bold; background-color:#D7BDE2">Customer</td>
										</tr>
										<tr>
											<td>Decision Maker</td>
											<td colspan=2>Did the agent verified that person he is<br> speaking to is the decision maker regarding phone line?</td>
											<td>5</td>
											<td>
												<select class="form-control fiber_connect_whitespace_v1_point business" id="" name="data[decision_maker]" required>
													<option fiber_connect_val=5 fiber_connect_max="5"<?php echo $whitespace_v1_data['decision_maker'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option fiber_connect_val=0 fiber_connect_max="5" <?php echo $whitespace_v1_data['decision_maker'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													<option fiber_connect_val=5 fiber_connect_max="5" <?php echo $whitespace_v1_data['decision_maker'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt9]" class="form-control" value="<?php echo $whitespace_v1_data['cmt9'] ?>"></td>
											<td style="font-weight:bold; background-color:#D7BDE2">Business</td>
										</tr>
										<tr>
											<td>Features & Benefits</td>
											<td colspan=2>Did the agent explained the benefits of the offer?</td>
											<td>8</td>
											<td>
												<select class="form-control fiber_connect_whitespace_v1_point business" id="" name="data[features_benefits]" required>
													<option fiber_connect_val=8 fiber_connect_max="8"<?php echo $whitespace_v1_data['features_benefits'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option fiber_connect_val=0 fiber_connect_max="8" <?php echo $whitespace_v1_data['features_benefits'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													<option fiber_connect_val=8 fiber_connect_max="8" <?php echo $whitespace_v1_data['features_benefits'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt10]" class="form-control" value="<?php echo $whitespace_v1_data['cmt10'] ?>"></td>
											<td style="font-weight:bold; background-color:#D7BDE2">Business</td>
										</tr>
										<tr>
											<td>Rapport Building</td>
											<td colspan=2>Did the agent used the chances of building<br> rapport on call?</td>
											<td>5</td>
											<td>
												<select class="form-control fiber_connect_whitespace_v1_point customer" id="" name="data[rapport_building]" required>
													<option fiber_connect_val=5 fiber_connect_max="5"<?php echo $whitespace_v1_data['rapport_building'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option fiber_connect_val=0 fiber_connect_max="5" <?php echo $whitespace_v1_data['rapport_building'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													<option fiber_connect_val=5 fiber_connect_max="5" <?php echo $whitespace_v1_data['rapport_building'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt11]" class="form-control" value="<?php echo $whitespace_v1_data['cmt11'] ?>"></td>
											<td style="font-weight:bold; background-color:#D7BDE2">Customer</td>
										</tr>
										<tr>
											<td rowspan="5">Hold Verbiage</td>
											<td colspan=2>Did the agent used hold during the call?</td>
											<td>5</td>
											<td>
												<select class="form-control fiber_connect_whitespace_v1_point customer" id="" name="data[hold_call]" required>
													<option fiber_connect_val=5 fiber_connect_max="5"<?php echo $whitespace_v1_data['hold_call'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option fiber_connect_val=0 fiber_connect_max="5" <?php echo $whitespace_v1_data['hold_call'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													<option fiber_connect_val=5 fiber_connect_max="5" <?php echo $whitespace_v1_data['hold_call'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt12]" class="form-control" value="<?php echo $whitespace_v1_data['cmt12'] ?>"></td>
											<td style="font-weight:bold; background-color:#D7BDE2">Customer</td>
										</tr>
										<tr>
											<td colspan=2>Was the hold appropriate as per call scenario?</td>
											<td>10</td>
											<td>
												<select class="form-control fiber_connect_whitespace_v1_point customer" id="" name="data[call_scenario]" required>
													<option fiber_connect_val=10 fiber_connect_max="10"<?php echo $whitespace_v1_data['call_scenario'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option fiber_connect_val=0 fiber_connect_max="10" <?php echo $whitespace_v1_data['call_scenario'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													<option fiber_connect_val=10 fiber_connect_max="10" <?php echo $whitespace_v1_data['call_scenario'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt13]" class="form-control" value="<?php echo $whitespace_v1_data['cmt13'] ?>"></td>
											<td style="font-weight:bold; background-color:#D7BDE2">Customer</td>
										</tr>
										<tr>
											<td colspan=2>Did the agent asked permission before putting the call on hold?</td>
											<td>3</td>
											<td>
												<select class="form-control fiber_connect_whitespace_v1_point customer" id="" name="data[call_on_hold]" required>
													<option fiber_connect_val=3 fiber_connect_max="3"<?php echo $whitespace_v1_data['call_on_hold'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option fiber_connect_val=0 fiber_connect_max="3" <?php echo $whitespace_v1_data['call_on_hold'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													<option fiber_connect_val=3 fiber_connect_max="3" <?php echo $whitespace_v1_data['call_on_hold'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt14]" class="form-control" value="<?php echo $whitespace_v1_data['cmt14'] ?>"></td>
											<td style="font-weight:bold; background-color:#D7BDE2">Customer</td>
										</tr>
										<tr>
											<td colspan=2>Did the agent made sure that the hold time<br> doesn’t exceed 2 minutes & refreshed whenever needed?</td>
											<td>10</td>
											<td>
												<select class="form-control fiber_connect_whitespace_v1_point customer" id="" name="data[hold_time_exceed_2_min]" required>
													<option fiber_connect_val=10 fiber_connect_max="10"<?php echo $whitespace_v1_data['hold_time_exceed_2_min'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option fiber_connect_val=0 fiber_connect_max="10" <?php echo $whitespace_v1_data['hold_time_exceed_2_min'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													<option fiber_connect_val=10 fiber_connect_max="10" <?php echo $whitespace_v1_data['hold_time_exceed_2_min'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt15]" class="form-control" value="<?php echo $whitespace_v1_data['cmt15'] ?>"></td>
											<td style="font-weight:bold; background-color:#D7BDE2">Customer</td>
										</tr>
										<tr>
											<td colspan=2>Did the agent thanked the customer after resuming the call?</td>
											<td>3</td>
											<td>
												<select class="form-control fiber_connect_whitespace_v1_point customer" id="" name="data[resume_call]" required>
													<option fiber_connect_val=3 fiber_connect_max="3"<?php echo $whitespace_v1_data['resume_call'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option fiber_connect_val=0 fiber_connect_max="3" <?php echo $whitespace_v1_data['resume_call'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													<option fiber_connect_val=3 fiber_connect_max="3" <?php echo $whitespace_v1_data['resume_call'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt16]" class="form-control" value="<?php echo $whitespace_v1_data['cmt16'] ?>"></td>
											<td style="font-weight:bold; background-color:#D7BDE2">Customer</td>
										</tr>
										<tr>
											<td>Discovery Questions</td>
											<td colspan=2>Did the agent did proper discovery question to<br> suggest the perfect plan?</td>
											<td>5</td>
											<td>
												<select class="form-control fiber_connect_whitespace_v1_point business" id="" name="data[discovery_questions]" required>
													<option fiber_connect_val=5 fiber_connect_max="5"<?php echo $whitespace_v1_data['discovery_questions'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option fiber_connect_val=0 fiber_connect_max="5" <?php echo $whitespace_v1_data['discovery_questions'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													<option fiber_connect_val=5 fiber_connect_max="5" <?php echo $whitespace_v1_data['discovery_questions'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt17]" class="form-control" value="<?php echo $whitespace_v1_data['cmt17'] ?>"></td>
											<td style="font-weight:bold; background-color:#D7BDE2">Business</td>
										</tr>
										<tr>
											<td>Plan & Tariff</td>
											<td colspan=2>Did the agent explained the plan which he/she is<br> providing?</td>
											<td>7</td>
											<td>
												<select class="form-control fiber_connect_whitespace_v1_point business" id="" name="data[plan_tariff]" required>
													<option fiber_connect_val=7 fiber_connect_max="7"<?php echo $whitespace_v1_data['plan_tariff'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option fiber_connect_val=0 fiber_connect_max="7" <?php echo $whitespace_v1_data['plan_tariff'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													<option fiber_connect_val=7 fiber_connect_max="7" <?php echo $whitespace_v1_data['plan_tariff'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt18]" class="form-control" value="<?php echo $whitespace_v1_data['cmt18'] ?>"></td>
											<td style="font-weight:bold; background-color:#D7BDE2">Business</td>
										</tr>
										<tr>
											<td class="text-danger">Appointment Setting</td>
											<td colspan=2 class="text-danger">Did the agent asked proper date and time<br> for the technician to visit?</td>
											<td>10</td>
											<td>
												<select class="form-control fiber_connect_whitespace_v1_point compliance" id="whitespace_v1AF3" name="data[appointment_setting]" required>
													<option fiber_connect_val=10 fiber_connect_max="10"<?php echo $whitespace_v1_data['appointment_setting'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option fiber_connect_val=0 fiber_connect_max="10" <?php echo $whitespace_v1_data['appointment_setting'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													<option fiber_connect_val=10 fiber_connect_max="10" <?php echo $whitespace_v1_data['appointment_setting'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt19]" class="form-control" value="<?php echo $whitespace_v1_data['cmt19'] ?>"></td>
											<td style="font-weight:bold; background-color:#D7BDE2">Compliance</td>
										</tr>
										<tr>
											<td>Process Knowledge/ Rebuttal</td>
											<td colspan=2> Agent was able to answer all customer's questions?</td>
											<td>10</td>
											<td>
												<select class="form-control fiber_connect_whitespace_v1_point customer" id="" name="data[process_knowledge]" required>
													<option fiber_connect_val=10 fiber_connect_max="10"<?php echo $whitespace_v1_data['process_knowledge'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option fiber_connect_val=0 fiber_connect_max="10" <?php echo $whitespace_v1_data['process_knowledge'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													<option fiber_connect_val=10 fiber_connect_max="10" <?php echo $whitespace_v1_data['process_knowledge'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt20]" class="form-control" value="<?php echo $whitespace_v1_data['cmt20'] ?>"></td>
											<td style="font-weight:bold; background-color:#D7BDE2">Customer</td>
										</tr>
										<tr>
											<td class="text-danger">Correct Information</td>
											<td colspan=2 class="text-danger">Agent provided all correct information on call and<br> did not passed any false information for the sake<br> of sales. Also agent didn’t skipped any inportant<br> information.</td>
											<td>5</td>
											<td>
												<select class="form-control fiber_connect_whitespace_v1_point compliance" id="whitespace_v1AF4" name="data[correct_information]" required>
													<option fiber_connect_val=5 fiber_connect_max="5"<?php echo $whitespace_v1_data['correct_information'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option fiber_connect_val=0 fiber_connect_max="5" <?php echo $whitespace_v1_data['correct_information'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													<option fiber_connect_val=5 fiber_connect_max="5" <?php echo $whitespace_v1_data['correct_information'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt21]" class="form-control" value="<?php echo $whitespace_v1_data['cmt21'] ?>"></td>
											<td style="font-weight:bold; background-color:#D7BDE2">Compliance</td>
										</tr>
										<tr>
											<td rowspan="4" class="text-danger">Documentation & Info collection</td>
											<td colspan=2 class="text-danger">Did the agent verified the address, business name,<br> email and cell phone number while processing the sales?</td>
											<td>10</td>
											<td>
												<select class="form-control fiber_connect_whitespace_v1_point compliance" id="whitespace_v1AF5" name="data[verified_address]" required>
													<option fiber_connect_val=10 fiber_connect_max="10"<?php echo $whitespace_v1_data['verified_address'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option fiber_connect_val=0 fiber_connect_max="10" <?php echo $whitespace_v1_data['verified_address'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													<option fiber_connect_val=10 fiber_connect_max="10" <?php echo $whitespace_v1_data['verified_address'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt22]" class="form-control" value="<?php echo $whitespace_v1_data['cmt22'] ?>"></td>
											<td style="font-weight:bold; background-color:#D7BDE2">Compliance</td>
										</tr>
										<tr>
											<td colspan=2 class="text-danger">Did the agent probed about special services<br> associated with the lines?</td>
											<td>10</td>
											<td>
												<select class="form-control fiber_connect_whitespace_v1_point compliance" id="whitespace_v1AF6" name="data[probed_special_services]" required>
													<option fiber_connect_val=10 fiber_connect_max="10"<?php echo $whitespace_v1_data['probed_special_services'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option fiber_connect_val=0 fiber_connect_max="10" <?php echo $whitespace_v1_data['probed_special_services'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													<option fiber_connect_val=10 fiber_connect_max="10" <?php echo $whitespace_v1_data['probed_special_services'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt23]" class="form-control" value="<?php echo $whitespace_v1_data['cmt23'] ?>"></td>
											<td style="font-weight:bold; background-color:#D7BDE2">Compliance</td>
										</tr>
										<tr>
											<td colspan=2 class="text-danger">Did the agent notified Internet is a must<br> with VOIP (they don’t have to use it),<br> Upgrade / Install of internet must be discussed</td>
											<td>10</td>
											<td>
												<select class="form-control fiber_connect_whitespace_v1_point compliance" id="whitespace_v1AF7" name="data[notified_internet]" required>
													<option fiber_connect_val=10 fiber_connect_max="10"<?php echo $whitespace_v1_data['notified_internet'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option fiber_connect_val=0 fiber_connect_max="10" <?php echo $whitespace_v1_data['notified_internet'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													<option fiber_connect_val=10 fiber_connect_max="10" <?php echo $whitespace_v1_data['notified_internet'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt24]" class="form-control" value="<?php echo $whitespace_v1_data['cmt24'] ?>"></td>
											<td style="font-weight:bold; background-color:#D7BDE2">Compliance</td>
										</tr>
										<tr>
											<td colspan=2 class="text-danger">Did the agent confirmed who will be at<br> the business on the day of installation</td>
											<td>9</td>
											<td>
												<select class="form-control fiber_connect_whitespace_v1_point compliance" id="whitespace_v1AF8" name="data[confirmed_business_installation]" required>
													<option fiber_connect_val=9 fiber_connect_max="9"<?php echo $whitespace_v1_data['confirmed_business_installation'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option fiber_connect_val=0 fiber_connect_max="9" <?php echo $whitespace_v1_data['confirmed_business_installation'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													<option fiber_connect_val=9 fiber_connect_max="9" <?php echo $whitespace_v1_data['confirmed_business_installation'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt25]" class="form-control" value="<?php echo $whitespace_v1_data['cmt25'] ?>"></td>
											<td style="font-weight:bold; background-color:#D7BDE2">Compliance</td>
										</tr>
										<tr>
											<td>Additional Assistance</td>
											<td colspan=2>Did the agent provided his/her contact number<br> just incase customer has any queries?</td>
											<td>5</td>
											<td>
												<select class="form-control fiber_connect_whitespace_v1_point customer" id="" name="data[additional_assistance]" required>
													<option fiber_connect_val=5 fiber_connect_max="5"<?php echo $whitespace_v1_data['additional_assistance'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option fiber_connect_val=0 fiber_connect_max="5" <?php echo $whitespace_v1_data['additional_assistance'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													<option fiber_connect_val=5 fiber_connect_max="5" <?php echo $whitespace_v1_data['additional_assistance'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt26]" class="form-control" value="<?php echo $whitespace_v1_data['cmt26'] ?>"></td>
											<td style="font-weight:bold; background-color:#D7BDE2">Customer</td>
										</tr>
										<tr>
											<td class="text-danger">Sales Authorization</td>
											<td colspan=2 class="text-danger">Did the agent got a proper authorization for<br> the sales on call?</td>
											<td>10</td>
											<td>
												<select class="form-control fiber_connect_whitespace_v1_point compliance" id="whitespace_v1AF9" name="data[sales_authorization]" required>
													<option fiber_connect_val=10 fiber_connect_max="10"<?php echo $whitespace_v1_data['sales_authorization'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option fiber_connect_val=0 fiber_connect_max="10" <?php echo $whitespace_v1_data['sales_authorization'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													<option fiber_connect_val=10 fiber_connect_max="10" <?php echo $whitespace_v1_data['sales_authorization'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt27]" class="form-control" value="<?php echo $whitespace_v1_data['cmt27'] ?>"></td>
											<td style="font-weight:bold; background-color:#D7BDE2">Compliance</td>
										</tr>
										<tr>
											<td>Further Assistance</td>
											<td colspan=2>Did the agent asked further assistance before<br> closing the call?</td>
											<td>5</td>
											<td>
												<select class="form-control fiber_connect_whitespace_v1_point customer" id="" name="data[further_assistance]" required>
													<option fiber_connect_val=5 fiber_connect_max="5"<?php echo $whitespace_v1_data['further_assistance'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option fiber_connect_val=0 fiber_connect_max="5" <?php echo $whitespace_v1_data['further_assistance'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													<option fiber_connect_val=5 fiber_connect_max="5" <?php echo $whitespace_v1_data['further_assistance'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt28]" class="form-control" value="<?php echo $whitespace_v1_data['cmt28'] ?>"></td>
											<td style="font-weight:bold; background-color:#D7BDE2">Customer</td>
										</tr>
										<tr>
											<td>Closing</td>
											<td colspan=2>Did the agent provided a recap of the<br> sales like Installation Fee , Features of VoIP,<br> Installation downtime, installation of internet<br> modem/gateway and also thanked the customer<br> and properly closed the call?</td>
											<td>5</td>
											<td>
												<select class="form-control fiber_connect_whitespace_v1_point customer" id="" name="data[closing]" required>
													<option fiber_connect_val=5 fiber_connect_max="5"<?php echo $whitespace_v1_data['closing'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option fiber_connect_val=0 fiber_connect_max="5" <?php echo $whitespace_v1_data['closing'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													<option fiber_connect_val=5 fiber_connect_max="5" <?php echo $whitespace_v1_data['closing'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt29]" class="form-control" value="<?php echo $whitespace_v1_data['cmt29'] ?>"></td>
											<td style="font-weight:bold; background-color:#D7BDE2">Customer</td>
										</tr>


									<tr style="font-weight:bold; background-color:#D7BDE2">
										<td colspan=3>Customer Score</td>
										<td colspan=3>Business Score</td>
										<td colspan=3>Compliance Score</td>
									</tr>

									<tr style="font-weight:bold; background-color:#D7BDE2">
										<td>Earned Point:</td><td colspan=2><input type="text" readonly class="form-control" id="customer_earned_score" name="data[customer_earned_score]" value="<?php echo $whitespace_v1_data['customer_earned_score'] ?>"></td>
										<td>Earned Point:</td><td colspan=2><input type="text" readonly class="form-control" id="business_earned_score" name="data[business_earned_score]" value="<?php echo $whitespace_v1_data['business_earned_score'] ?>"></td>
										<td>Earned Point:</td><td colspan=2><input type="text" readonly class="form-control" id="compliance_earned_score" name="data[compliance_earned_score]" value="<?php echo $whitespace_v1_data['compliance_earned_score'] ?>"></td>
									</tr>
									<tr style="font-weight:bold; background-color:#D7BDE2">
										<td>Possible Point:</td><td colspan=2><input type="text" readonly class="form-control" id="customer_possible_score" name="data[customer_possible_score]" value="<?php echo $whitespace_v1_data['customer_possible_score'] ?>"></td>
										<td>Possible Point:</td><td colspan=2><input type="text" readonly class="form-control" id="business_possible_score" name="data[business_possible_score]" value="<?php echo $whitespace_v1_data['business_possible_score'] ?>"></td>
										<td>Possible Point:</td><td colspan=2><input type="text" readonly class="form-control" id="compliance_possible_score" name="data[compliance_possible_score]" value="<?php echo $whitespace_v1_data['compliance_possible_score'] ?>"></td>
									</tr>
									<tr style="font-weight:bold; background-color:#D7BDE2">
										<td>Overall Percentage:</td><td colspan=2><input type="text" readonly class="form-control" id="customer_overall_score" name="data[customer_overall_score]" value="<?php echo $whitespace_v1_data['customer_overall_score'] ?>"></td>
										<td>Overall Percentage:</td><td colspan=2><input type="text" readonly class="form-control" id="business_overall_score" name="data[business_overall_score]" value="<?php echo $whitespace_v1_data['business_overall_score'] ?>"></td>
										<td>Overall Percentage:</td><td colspan=2><input type="text" readonly class="form-control" id="compliance_overall_score" name="data[compliance_overall_score]" value="<?php echo $whitespace_v1_data['compliance_overall_score'] ?>"></td>
									</tr>

										<tr>
											<td>Call Summary:</td>
											<td colspan=2><textarea class="form-control" name="data[call_summary]"><?php echo $whitespace_v1_data['call_summary'] ?></textarea></td>
											<td>Feedback:</td>
											<td colspan=4><textarea class="form-control" name="data[feedback]"><?php echo $whitespace_v1_data['feedback'] ?></textarea></td>
										</tr>
										<tr>
											<td colspan=2>Upload Files [m4a,mp4,mp3,wav]</td>
											<?php if ($att_id == 0) { ?>
												<td colspan=6>
													<input type="file" name="attach_file[]" id="attach_file" accept=".m4a,.mp4,.mp3,.wav,audio/*" />
												</td>
												<?php } else {
												if ($whitespace_v1_data['attach_file'] != '') { ?>
													<td colspan=6>
														<input type="file" multiple class="form-control"  id="attach_file" name="attach_file[]" accept=".m4a,.mp4,.mp3,.wav,audio/*"> 
														<?php $attach_file = explode(",", $whitespace_v1_data['attach_file']);
														foreach ($attach_file as $mp) { ?>
															<audio controls='' style="background-color:#607F93">
																<source src="<?php echo base_url(); ?>qa_files/qa_att/whitespace_v1/<?php echo $mp; ?>" type="audio/ogg">
																<source src="<?php echo base_url(); ?>qa_files/qa_att/whitespace_v1/<?php echo $mp; ?>" type="audio/mpeg">
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
												<td colspan=6><?php echo $whitespace_v1_data['agnt_fd_acpt'] ?></td>
											</tr>
											<tr>
												<td colspan=2 style="font-size:16px; font-weight:bold">Agent Review:</td>
												<td colspan=6><?php echo $whitespace_v1_data['agent_rvw_note'] ?></td>
											</tr>
											<tr>
												<td colspan=2 style="font-size:16px; font-weight:bold">Management Review:</td>
												<td colspan=6><?php echo $whitespace_v1_data['mgnt_rvw_note'] ?></td>
											</tr>
											<tr>
												<td colspan=2 style="font-size:16px; font-weight:bold">Client Review:</td>
												<td colspan=6><?php echo $whitespace_v1_data['client_rvw_note'] ?></td>
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
												if (is_available_qa_feedback($whitespace_v1_data['entry_date'], 72) == true) { ?>
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