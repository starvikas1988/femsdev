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

<?php if ($norther_id != 0) {
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
											<td colspan="10" id="theader" style="font-size:40px; text-align:center!important; ">Norther Tools & Equipment QA FORM</td>
											<input type="hidden" name="audit_start_time" value="<?php echo CurrMySqlDate(); ?>">
										</tr>
										<?php
										if ($norther_id == 0) {
											$auditorName = get_username();
											$auditDate = CurrDateMDY();
											//$auditDate =  CurrDateTimeMDY();
											$clDate_val = '';
										} else {
											if ($norther_data['entry_by'] != '') {
												$auditorName = $norther_data['auditor_name'];
											} else {
												$auditorName = $norther_data['client_name'];
											}
											//$new = explode("-", $norther_data['audit_date']);
											//$new1 = explode(" ", $new[2]);
											//print_r($new);
											$auditDate = mysql2mmddyy($norther_data['audit_date']);
										 //    $at = array($new[1], $new1[0], $new[0]);
										 //    $n_date = implode("/", $at);
											// $auditDate = ($n_date)." ".$new1[1];
											$clDate_val = mysql2mmddyy($norther_data['call_date']);
										}
										?>
										<tr>
											<td>Auditor Name: <span style="font-size:24px;color:red">*</span></td>
											<td><input type="text" class="form-control" value="<?= $auditorName; ?>" disabled></td>
											<td>Audit Date:<span style="font-size:24px;color:red">*</span></td>
											<td><input type="text" class="form-control" value="<?= $auditDate; ?>" disabled></td>
											<td>Call Date:<span style="font-size:24px;color:red">*</span></td>
											<td>
												<input type="text" id="call_date" name="call_date"  onkeydown="return false;" value="<?php echo $clDate_val; ?>" max="<?php echo date("Y-m-d"); ?>" class="form-control" required>
											</td>
											<td>Agent Name:<span style="font-size:24px;color:red">*</span></td>
											<td colspan="2">
												<select class="form-control" id="agent_ids" name="data[agent_id]" required>
													<?php 
													if($norther_data['agent_id']!=''){
														?>
														<option value="<?php echo $norther_data['agent_id'] ?>"><?php echo $norther_data['fname'] . " " . $norther_data['lname'] ?></option>
														<?php
													}else{
														?>
														<option value="">Select</option>
														<?php
													}
													?>
													
													
													<?php foreach ($agentName as $row) :  ?>
													<?php 
													if($row['id'] == $norther_data['agent_id']){
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
										</tr>
										<tr>
											<td>Fusion ID:<span style="font-size:24px;color:red">*</span></td>
											<td><input type="text" class="form-control" id="fusion_id" required value="<?php echo $norther_data['fusion_id'] ?>" readonly></td>
											<td> L1 Supervisor:<span style="font-size:24px;color:red">*</span></td>
											<td>
												<input type="text" class="form-control" id="tl_names"  value="<?php echo $norther_data['tl_name'] ?>" readonly>
												<input type="hidden" class="form-control" id="tl_id" name="data[tl_id]" value="<?php echo $norther_data['tl_id'] ?>" required>
											</td>
											<td>Interaction ID:<span style="font-size:24px;color:red">*</span></td>
											<td>
												<input type="text" class="form-control" name="data[interaction_id]" value="<?php echo $norther_data['interaction_id'] ?>" required>
											</td>
											<td>Call Number:<span style="font-size:24px;color:red">*</span></td>
											<td colspan="2"><input type="text" class="form-control" name="data[call_number]" value="<?php echo $norther_data['call_number'] ?>" onkeyup="checkDec(this);" required>
												<span id="start_phone" style="color:red"></span></td>
										</tr>
										<tr>
										<td>Manager:<span style="font-size:24px;color:red">*</span></td>
											<td>
												<input type="text" class="form-control" name="data[manager]" value="<?php echo $norther_data['manager'] ?>" required>
											</td>
											<td>Call Duration:<span style="font-size:24px;color:red">*</span></td>
											<td><input type="text" class="form-control" onkeydown="return false;" id="call_duration" name="data[call_duration]" value="<?php echo $norther_data['call_duration']?>" required></td>
											<td>VOC:<span style="font-size:24px;color:red">*</span></td>
											<td>
												<select class="form-control" id="voc" name="data[voc]" required>
													
													<option value="">-Select-</option>
													<option value="1"  <?= ($norther_data['voc']=="1")?"selected":"" ?>>1</option>
													<option value="2"  <?= ($norther_data['voc']=="2")?"selected":"" ?>>2</option>
													<option value="3"  <?= ($norther_data['voc']=="3")?"selected":"" ?>>3</option>
													<option value="4"  <?= ($norther_data['voc']=="4")?"selected":"" ?>>4</option>
													<option value="5"  <?= ($norther_data['voc']=="5")?"selected":"" ?>>5</option>
													<option value="6"  <?= ($norther_data['voc']=="6")?"selected":"" ?>>6</option>
													<option value="7"  <?= ($norther_data['voc']=="7")?"selected":"" ?>>7</option>
													<option value="8"  <?= ($norther_data['voc']=="8")?"selected":"" ?>>8</option>
													<option value="9"  <?= ($norther_data['voc']=="9")?"selected":"" ?>>9</option>
													<option value="10"  <?= ($norther_data['voc']=="10")?"selected":"" ?>>10</option>
												</select>
											</td>
											<td>Audit Type:<span style="font-size:24px;color:red">*</span></td>
											<td colspan="2">
												<select class="form-control" id="audit_type" name="data[audit_type]" required>
                                                    <option value="">-Select-</option>
                                                    <option value="CQ Audit" <?= ($norther_data['audit_type']=="CQ Audit")?"selected":"" ?>>CQ Audit</option>
                                                    <option value="BQ Audit" <?= ($norther_data['audit_type']=="BQ Audit")?"selected":"" ?>>BQ Audit</option>
                                                    <option value="Calibration" <?= ($norther_data['audit_type']=="Calibration")?"selected":"" ?>>Calibration</option>
                                                    <option value="Pre-Certificate Mock Call" <?= ($norther_data['audit_type']=="Pre-Certificate Mock Call")?"selected":"" ?>>Pre-Certificate Mock Call</option>
                                                    <option value="Certification Audit" <?= ($norther_data['audit_type']=="Certification Audit")?"selected":"" ?>>Certification Audit</option>
                                                    <option value="WoW Call Audit"  <?= ($norther_data['audit_type']=="WoW Call Audit")?"selected":"" ?>>WoW Call Audit</option>
                                                   
                                                    
                                                </select>
											</td>
										</tr>
										
										<tr>
											<td class="auType_epi">Auditor Type<span style="font-size:24px;color:red">*</span></td>
											<td class="auType_epi">
												<select class="form-control" id="auditor_type" name="data[auditor_type]">
                                                    <option value="">Select</option>
                                                    <option value="Master" <?= ($norther_data['auditor_type']=="Master")?"selected":"" ?>>Master</option>
                                                    <option value="Regular" <?= ($norther_data['auditor_type']=="Regular")?"selected":"" ?>>Regular</option>
                                                </select>
											</td>
										</tr>
										<tr>
											<td style="font-weight:bold; font-size:16px; text-align:left">Earned Score</td>
											<td><input type="text" readonly id="mtl_earned_score" name="data[earned_score]" class="form-control" value="<?php echo $norther_data['earned_score'] ?>" /></td>
											<td style="font-weight:bold; font-size:16px; text-align:left">Possible Score</td>
											<td><input type="text" readonly id="mtl_possible_score" name="data[possible_score]" class="form-control" value="<?php echo $norther_data['possible_score'] ?>" /></td>
											<td style="font-weight:bold; font-size:16px; text-align:right">Overall Score:</td>
											<td><input type="text" readonly id="mtl_overall_score" name="data[overall_score]" class="form-control acgFatal" style="font-weight:bold" value="<?php echo $norther_data['overall_score'] ?>"></td>
										</tr>
										<tr class="eml" style="height:25px; font-weight:bold">
											<td>PARAMETER</td>
											<td colspan=2>SUB PARAMETER</td>
											<td>WEIGHTAGE</td>
											<td>SCORE</td>
											<td>STATUS</td>
											<td colspan=2>REMARKS</td>
											<td>Critical Accuracy</td>
										</tr>

										<tr>
											<td class="eml" rowspan=1>Opening</td>
											<td colspan=2>Did the agent greeted the customer and mentioned the brand name in the opening of the call?</td>
											<td>5</td>
											<td>5</td>
											<td>
												<select class="form-control mtl_point business" name="data[opening_call]" required>
													
													<option mtl_val=5 mtl_max="5"<?php echo $norther_data['opening_call'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option mtl_val=0 mtl_max="5" <?php echo $norther_data['opening_call'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													<option mtl_val=0 mtl_max="5" <?php echo $norther_data['opening_call'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt1]" class="form-control" value="<?php echo $norther_data['cmt1'] ?>"></td>
											<td style="font-weight:bold; background-color:#D7BDE2">Business Citical</td>
										</tr>
										<tr>
											<td class="eml" rowspan=6>Opening</td>
											<td colspan=2>Serving with Empathy - Active Listening </td>
											<td rowspan=6>26</td>
											<td>5</td>
											<td>
												<select class="form-control mtl_point customer" name="data[active_listening]" required>
													
													<option mtl_val=5 mtl_max="5" <?php echo $norther_data['active_listening'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option mtl_val=0 mtl_max="5" <?php echo $norther_data['active_listening'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													<option mtl_val=0 mtl_max="5" <?php echo $norther_data['active_listening'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt2]" class="form-control" value="<?php echo $norther_data['cmt2'] ?>"></td>
											<td style="font-weight:bold; background-color:#D7BDE2">Customer Citical</td>
										</tr>

										<tr>
											<td colspan="2">Serving with Empathy - Positive Tone</td>
											<td>4</td>
											<td>
												<select class="form-control mtl_point customer" id ="" name="data[positive_tone]" required>
													
													<option mtl_val=4 mtl_max="4" <?= $norther_data["positive_tone"] == "Pass" ? "selected" : "" ?> value="Pass">Pass</option>
													<option mtl_val=0 mtl_max="4" <?= $norther_data["positive_tone"] == "Fail" ? "selected" : "" ?> value="Fail">Fail</option>
													<option mtl_val=0 mtl_max="4" <?= $norther_data["positive_tone"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt3]" class="form-control" value="<?php echo $norther_data['cmt3'] ?>"></td>
											<td style="font-weight:bold; background-color:#D7BDE2">Customer Citical</td>
										</tr>
										<tr>
											<td colspan="2">Serving with Empathy - Positive Language/ Plesantaries (Please, thank you, Excuse me, You're Welcome, & May I)</td>
											<td>5</td>
											<td>
												<select class="form-control mtl_point customer"  name="data[positive_language]" required>
													
													<option mtl_val=5 mtl_max="5" <?= $norther_data["positive_language"] == "Pass" ? "selected" : "" ?> value="Pass">Pass</option>
													<option mtl_val=0 mtl_max="5" <?= $norther_data["positive_language"] == "Fail" ? "selected" : "" ?> value="Fail">Fail</option>
													<option mtl_val=0 mtl_max="5" <?= $norther_data["positive_language"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt4]" class="form-control" value="<?php echo $norther_data['cmt4'] ?>"></td>
											<td style="font-weight:bold; background-color:#D7BDE2">Customer Citical</td>
										</tr>

										<tr>
											<td colspan=2>Acknowledgements timely and effectively</td>
											<td>4</td>
											<td>
												<select class="form-control mtl_point customer" name="data[acknowledgements_timely]" required>
													
													<option mtl_val=4 mtl_max="4" <?php echo $norther_data['acknowledgements_timely'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option mtl_val=0 mtl_max="4" <?php echo $norther_data['acknowledgements_timely'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													<option mtl_val=0 mtl_max="4" <?php echo $norther_data['acknowledgements_timely'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt5]" class="form-control" value="<?php echo $norther_data['cmt5'] ?>"></td>
											<td style="font-weight:bold; background-color:#D7BDE2">Customer Citical</td>
										</tr>

										<tr>
											<td colspan=2>Rate of Speech</td>
											<td>4</td>
											<td>
												<select class="form-control mtl_point customer" name="data[rate_of_speech]" required>
													
													<option mtl_val=4 mtl_max="4" <?php echo $norther_data['rate_of_speech'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option mtl_val=0 mtl_max="4" <?php echo $norther_data['rate_of_speech'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													<option mtl_val=0 mtl_max="4" <?php echo $norther_data['rate_of_speech'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt6]" class="form-control" value="<?php echo $norther_data['cmt6'] ?>"></td>
											<td style="font-weight:bold; background-color:#D7BDE2">Customer Citical</td>
										</tr>

										<tr>
											<td  colspan="2">Did the agent used effective engagement</td>
											<td>4</td>
											<td>
												<select class="form-control mtl_point compliance" id =""name="data[effective_engagement]" required>
													
													<option mtl_val=4 mtl_max="4" <?= $norther_data["effective_engagement"] == "Pass" ? "selected" : "" ?> value="Pass">Pass</option>
													<option mtl_val=0 mtl_max="4" <?= $norther_data["effective_engagement"] == "Fail" ? "selected" : "" ?> value="Fail">Fail</option>
													<option mtl_val=0 <?= $norther_data["effective_engagement"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt7]" class="form-control" value="<?php echo $norther_data['cmt7'] ?>"></td>
											<td style="font-weight:bold; background-color:#D7BDE2">Compliance Citical</td>
										</tr>
										
										<tr>
											<td class="eml" rowspan=5>Call Handling</td>
											<td  colspan="2">Was the agent confident enough to handle the call?</td>
											<td rowspan=5>45</td>
											<td>10</td>
											<td>
												<select class="form-control mtl_point customer" id =""name="data[handle_call]" required>
													
													<option mtl_val=10 mtl_max="10" <?= $norther_data["handle_call"] == "Pass" ? "selected" : "" ?> value="Pass">Pass</option>
													<option mtl_val=0 mtl_max="10" <?= $norther_data["handle_call"] == "Fail" ? "selected" : "" ?> value="Fail">Fail</option>
													<option mtl_val=0 <?= $norther_data["handle_call"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt8]" class="form-control" value="<?php echo $norther_data['cmt8'] ?>"></td>
											<td style="font-weight:bold; background-color:#D7BDE2">Customer Citical</td>
										</tr>
										<tr>
											<td  colspan="2">Did the agent acknowledged all the queries of the customer?</td>
											<td>10</td>
											<td>
												<select class="form-control mtl_point customer" id ="" name="data[acknowledged_queries]" required>
													
													<option mtl_val=10 mtl_max="10" <?= $norther_data["acknowledged_queries"] == "Pass" ? "selected" : "" ?> value="Pass">Pass</option>
													<option mtl_val=0 mtl_max="10" <?= $norther_data["acknowledged_queries"] == "Fail" ? "selected" : "" ?> value="Fail">Fail</option>
													<option mtl_val=0 <?= $norther_data["acknowledged_queries"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt9]" class="form-control" value="<?php echo $norther_data['cmt9'] ?>"></td>
											<td style="font-weight:bold; background-color:#D7BDE2">Customer Citical</td>
										</tr>
										<tr>
											<td  colspan="2">Ensure all internal processes are followed throughout the call.</td>
											<td>10</td>
											<td>
												<select class="form-control mtl_point business" id =""name="data[internal_processes]" required>
													
													<option mtl_val=10 mtl_max="10" <?= $norther_data["internal_processes"] == "Pass" ? "selected" : "" ?> value="Pass">Pass</option>
													<option mtl_val=0 mtl_max="10" <?= $norther_data["internal_processes"] == "Fail" ? "selected" : "" ?> value="Fail">Fail</option>
													<option mtl_val=0 <?= $norther_data["internal_processes"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt10]" class="form-control" value="<?php echo $norther_data['cmt10'] ?>"></td>
											<td style="font-weight:bold; background-color:#D7BDE2">Business Citical</td>
										</tr>
										<tr>
											<td  colspan="2">Agent avoided overlapping the customer at any time</td>
											<td>10</td>
											<td>
												<select class="form-control mtl_point customer" id ="" name="data[avoided_overlapping]" required>
													
													<option mtl_val=10 mtl_max="10" <?= $norther_data["avoided_overlapping"] == "Pass" ? "selected" : "" ?> value="Pass">Pass</option>
													<option mtl_val=0 mtl_max="10" <?= $norther_data["avoided_overlapping"] == "Fail" ? "selected" : "" ?> value="Fail">Fail</option>
													<option mtl_val=0 <?= $norther_data["avoided_overlapping"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt11]" class="form-control" value="<?php echo $norther_data['cmt11'] ?>"></td>
											<td style="font-weight:bold; background-color:#D7BDE2">Customer Citical</td>
										</tr>
										<tr>
											<td colspan="2">Provide clear follow-up instructions (If applicable)</td>
											<td>5</td>
											<td>
												<select class="form-control mtl_point customer" name="data[follow_up_instructions]" required>
												
													<option mtl_val=5 mtl_max="5"<?= $norther_data["follow_up_instructions"] == "Pass" ? "selected" : "" ?> value="Pass">Pass</option>
													<option mtl_val=0 mtl_max="5"<?= $norther_data["follow_up_instructions"] == "Fail" ? "selected" : "" ?> value="Fail">Fail</option>
													<option mtl_val=0 mtl_max="5"<?= $norther_data["follow_up_instructions"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt12]" class="form-control" value="<?php echo $norther_data['cmt12'] ?>"></td>
											<td style="font-weight:bold; background-color:#D7BDE2">Customer Citical</td>
										</tr>
										<tr>
											<td class="eml" rowspan=3>Hold Policy</td>
											<td colspan="2">Hold Policy</td>
											<td rowspan=3>9</td>
											<td>3</td>
											<td>
												<select class="form-control mtl_point customer" name="data[hold_policy]" required>
												
													<option mtl_val=3 mtl_max="3" <?= $norther_data["hold_policy"] == "Pass" ? "selected" : "" ?> value="Pass">Pass</option>
													<option mtl_val=0 mtl_max="3" <?= $norther_data["hold_policy"] == "Fail" ? "selected" : "" ?> value="Fail">Fail</option>
													<option mtl_val=0 mtl_max="3" <?= $norther_data["hold_policy"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt13]" class="form-control" value="<?php echo $norther_data['cmt13'] ?>"></td>
											<td style="font-weight:bold; background-color:#D7BDE2">Customer Citical</td>
										</tr>
										<tr>
											<td colspan="2">Dead Air</td>
											<td>3</td>
											<td>
												<select class="form-control mtl_point customer" id ="" name="data[dead_air]" required>
												
													<option mtl_val=3 mtl_max="3" <?= $norther_data["dead_air"] == "Pass" ? "selected" : "" ?> value="Pass">Pass</option>
													<option mtl_val=0 mtl_max="3" <?= $norther_data["dead_air"] == "Fail" ? "selected" : "" ?> value="Fail">Fail</option>
													<option mtl_val=0 mtl_max="3" <?= $norther_data["dead_air"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt14]" class="form-control" value="<?php echo $norther_data['cmt14'] ?>"></td>
											<td style="font-weight:bold; background-color:#D7BDE2">Customer Citical</td>
										</tr>

										<tr>
											<td colspan="2">Hold Verbiage</td>
											<td>3</td>
											<td>
												<select class="form-control mtl_point customer" name="data[hold_verbiage]" required>
												
													<option mtl_val=3 mtl_max="3" <?= $norther_data["hold_verbiage"] == "Pass" ? "selected" : "" ?> value="Pass">Pass</option>
													<option mtl_val=0 mtl_max="3" <?= $norther_data["hold_verbiage"] == "Fail" ? "selected" : "" ?> value="Fail">Fail</option>
													<option mtl_val=0 mtl_max="3" <?= $norther_data["hold_verbiage"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt15]" class="form-control" value="<?php echo $norther_data['cmt15'] ?>"></td>
											<td style="font-weight:bold; background-color:#D7BDE2">Customer Citical</td>
										</tr>

										<tr>
											<td class="eml" rowspan=1>Professionalism</td>
											<td colspan="2" class="text-danger">If any one of these applies: 
											- Agent deliberately interrupted the caller
											- Agent used condescending tone
											- Agent used foul or unprofessional language
											- Agent exhibited impatience in the interaction 
											- Agent engaged in a verbal altercation</td>
											<td>5</td>
											<td>5</td>
											<td>
												<select class="form-control mtl_point compliance" id="ajioAF1" name="data[professionalism]" required>
												
													<option mtl_val=5 mtl_max="5" <?= $norther_data["professionalism"] == "Pass" ? "selected" : "" ?> value="Pass">Pass</option>
													<option mtl_val=0 mtl_max="5" <?= $norther_data["professionalism"] == "Fail" ? "selected" : "" ?> value="Fail">Fail</option>
													<option mtl_val=0 mtl_max="5" <?= $norther_data["professionalism"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt16]" class="form-control" value="<?php echo $norther_data['cmt16'] ?>"></td>
											<td style="font-weight:bold; background-color:#D7BDE2">Compliance Citical</td>
										</tr>

										<tr>
											<td class="eml" rowspan=2>Closing</td>
											<td colspan="2">Verify if the patinet had any other areas of feedback they wanted to provide or any further queries?</td>
											<td rowspan=2>10</td>
											<td>5</td>
											<td>
												<select class="form-control mtl_point business" id ="" name="data[further_queries]" required>
												
													<option mtl_val=5 mtl_max="5" <?= $norther_data["further_queries"] == "Pass" ? "selected" : "" ?> value="Pass">Pass</option>
													<option mtl_val=0 mtl_max="5" <?= $norther_data["further_queries"] == "Fail" ? "selected" : "" ?> value="Fail">Fail</option>
													<option mtl_val=0 mtl_max="5" <?= $norther_data["further_queries"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt17]" class="form-control" value="<?php echo $norther_data['cmt17'] ?>"></td>
											<td style="font-weight:bold; background-color:#D7BDE2">Business Citical</td>
										</tr>
										<tr>
											<td colspan="2">Thanking the customer before closing or transfering the call (Thank you for contacting ROMTech customer service department)</td>
											<td>5</td>
											<td>
												<select class="form-control mtl_point business" name="data[close_call]" required>
												
													<option mtl_val=5 mtl_max="5" <?= $norther_data["close_call"] == "Pass" ? "selected" : "" ?> value="Pass">Pass</option>
													<option mtl_val=0 mtl_max="5"<?= $norther_data["close_call"] == "Fail" ? "selected" : "" ?> value="Fail">Fail</option>
													<option mtl_val=0 mtl_max="5"<?= $norther_data["close_call"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt18]" class="form-control" value="<?php echo $norther_data['cmt18'] ?>"></td>
											<td style="font-weight:bold; background-color:#D7BDE2">Business Citical</td>
										</tr>

									<tr style="font-weight:bold; background-color:#D7BDE2">
										<td colspan=3>Customer Score</td>
										<td colspan=3>Business Score</td>
										<td colspan=3>Compliance Score</td>
									</tr>

									<tr style="font-weight:bold; background-color:#D7BDE2">
										<td>Earned Point:</td><td colspan=2><input type="text" readonly class="form-control" id="customer_earned_score" name="data[customer_earned_score]" value="<?php echo $norther_data['customer_earned_score'] ?>"></td>
										<td>Earned Point:</td><td colspan=2><input type="text" readonly class="form-control" id="business_earned_score" name="data[business_earned_score]" value="<?php echo $norther_data['business_earned_score'] ?>"></td>
										<td>Earned Point:</td><td colspan=2><input type="text" readonly class="form-control" id="compliance_earned_score" name="data[compliance_earned_score]" value="<?php echo $norther_data['compliance_earned_score'] ?>"></td>
									</tr>
									<tr style="font-weight:bold; background-color:#D7BDE2">
										<td>Possible Point:</td><td colspan=2><input type="text" readonly class="form-control" id="customer_possible_score" name="data[customer_possible_score]" value="<?php echo $norther_data['customer_possible_score'] ?>"></td>
										<td>Possible Point:</td><td colspan=2><input type="text" readonly class="form-control" id="business_possible_score" name="data[business_possible_score]" value="<?php echo $norther_data['business_possible_score'] ?>"></td>
										<td>Possible Point:</td><td colspan=2><input type="text" readonly class="form-control" id="compliance_possible_score" name="data[compliance_possible_score]" value="<?php echo $norther_data['compliance_possible_score'] ?>"></td>
									</tr>
									<tr style="font-weight:bold; background-color:#D7BDE2">
										<td>Overall Percentage:</td><td colspan=2><input type="text" readonly class="form-control" id="customer_overall_score" name="data[customer_overall_score]" value="<?php echo $norther_data['customer_overall_score'] ?>"></td>
										<td>Overall Percentage:</td><td colspan=2><input type="text" readonly class="form-control" id="business_overall_score" name="data[business_overall_score]" value="<?php echo $norther_data['business_overall_score'] ?>"></td>
										<td>Overall Percentage:</td><td colspan=2><input type="text" readonly class="form-control" id="compliance_overall_score" name="data[compliance_overall_score]" value="<?php echo $norther_data['compliance_overall_score'] ?>"></td>
									</tr>

										<tr>
											<td>Call Summary:</td>
											<td colspan=4><textarea class="form-control" name="data[call_summary]"><?php echo $norther_data['call_summary'] ?></textarea></td>
											<td>Feedback:</td>
											<td colspan=6><textarea class="form-control" name="data[feedback]"><?php echo $norther_data['feedback'] ?></textarea></td>
										</tr>
										<tr>
											<td colspan=2>Upload Files [m4a,mp4,mp3,wav]</td>
											<?php if ($norther_id == 0) { ?>
												<td colspan=8>
													<!-- <input type="file" multiple class="form-control"  id="attach_file" name="attach_file[]"> -->
													<input type="file" name="attach_file[]" id="attach_file" accept=".m4a,.mp4,.mp3,.wav,audio/*" />
												</td>
												<?php } else {
												if ($norther_data['attach_file'] != '') { ?>
													<td colspan=8>
														<input type="file" multiple class="form-control"  id="attach_file" name="attach_file[]" accept=".m4a,.mp4,.mp3,.wav,audio/*"> 
														<?php $attach_file = explode(",", $norther_data['attach_file']);
														foreach ($attach_file as $mp) { ?>
															<audio controls='' style="background-color:#607F93">
																<source src="<?php echo base_url(); ?>qa_files/norther/qa_audio_files/<?php echo $mp; ?>" type="audio/ogg">
																<source src="<?php echo base_url(); ?>qa_files/norther/qa_audio_files/<?php echo $mp; ?>" type="audio/mpeg">
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

										<?php if ($norther_id != 0) { ?>
											<tr>
												<td colspan=2 style="font-size:16px; font-weight:bold">Agent Feedback Acceptance:</td>
												<td colspan=6><?php echo $norther_data['agnt_fd_acpt'] ?></td>
											</tr>
											<tr>
												<td colspan=2 style="font-size:16px; font-weight:bold">Agent Review:</td>
												<td colspan=6><?php echo $norther_data['agent_rvw_note'] ?></td>
											</tr>
											<tr>
												<td colspan=2 style="font-size:16px; font-weight:bold">Management Review:</td>
												<td colspan=6><?php echo $norther_data['mgnt_rvw_note'] ?></td>
											</tr>
											<tr>
												<td colspan=2 style="font-size:16px; font-weight:bold">Client Review:</td>
												<td colspan=6><?php echo $norther_data['client_rvw_note'] ?></td>
											</tr>

											<tr>
												<td colspan=2 style="font-size:16px">Your Review<span style="font-size:24px;color:red">*</span></td>
												<td colspan=6><textarea class="form-control1" style="width:100%" id="note" name="note" required></textarea></td>
											</tr>
										<?php } ?>

										<?php
										if ($norther_id == 0) {
											if (is_access_qa_module() == true || is_access_qa_operations_module() == true) { ?>
												<tr>
													<td colspan=10><button class="btn btn-success blains-effect" type="submit" id="qaformsubmit" style="width:500px;margin:auto;display:block;">SAVE</button></td>
												</tr>
												<?php
											}
										} else {
											if (is_access_qa_module() == true || is_access_qa_operations_module() == true) {
												if (is_available_qa_feedback($norther_data['entry_date'], 72) == true) { ?>
													<tr>
														<td colspan="10"><button class="btn btn-success blains-effect" type="submit" id='qaformsubmit' name='btnSave' value="SAVE" style="width:500px;margin:auto;display:block;">SAVE</button></td>
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