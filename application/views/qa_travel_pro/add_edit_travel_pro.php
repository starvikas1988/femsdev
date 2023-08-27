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

<?php if ($travel_pro_id != 0) {
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
											<td colspan="8" id="theader" style="font-size:40px; text-align:center!important; ">Travel Pro QA FORM</td>
											<input type="hidden" name="audit_start_time" value="<?php echo CurrMySqlDate(); ?>">
										</tr>
										<?php
										if ($travel_pro_id == 0) {
											$auditorName = get_username();
											$auditDate = CurrDateMDY();
											//$auditDate =  CurrDateTimeMDY();
											$clDate_val = '';
										} else {
											if ($travel_pro_data['entry_by'] != '') {
												$auditorName = $travel_pro_data['auditor_name'];
											} else {
												$auditorName = $travel_pro_data['client_name'];
											}
										
											$auditDate = mysql2mmddyy($travel_pro_data['audit_date']);
										 
											$clDate_val = mysql2mmddyy($travel_pro_data['call_date']);
										}

										if ($rand_id != 0) {
											$agent_id = $rand_data['sid'];
											$fusion_id = $rand_data['fusion_id'];
											$agent_name = $rand_data['fname'] . " " . $rand_data['lname'];
											$tl_id = $rand_data['assigned_to'];
											$tl_name = $rand_data['tl_name'];
											$call_duration = $rand_data['call_duration'];
											
										} else {
											$agent_id = $travel_pro_data['agent_id'];
											$fusion_id = $travel_pro_data['fusion_id'];
											$agent_name = $travel_pro_data['fname'] . " " . $travel_pro_data['lname'] ;
											$tl_id = $travel_pro_data['tl_id'];
											$tl_name = $travel_pro_data['tl_name'];
											$call_duration = $travel_pro_data['call_duration'];
										}
										?>
										<tr>
											<td>Auditor Name: <span style="font-size:24px;color:red">*</span></td>
											<td colspan="2"><input type="text" class="form-control" value="<?= $auditorName; ?>" disabled></td>
											<td>Audit Date:<span style="font-size:24px;color:red">*</span></td>
											<td><input type="text" class="form-control" value="<?= $auditDate; ?>" disabled></td>
											<td>Call Date:<span style="font-size:24px;color:red">*</span></td>
											<td colspan="2">
												<input type="text" id="call_date" name="call_date"  onkeydown="return false;" value="<?php echo $clDate_val; ?>" max="<?php echo date("Y-m-d"); ?>" class="form-control" required>
											</td>
										</tr>
										<tr>
											<td>Agent Name:<span style="font-size:24px;color:red">*</span></td>
											<td colspan="2">
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
											<td>Fusion ID:<span style="font-size:24px;color:red">*</span></td>
											<td><input type="text" class="form-control" id="fusion_id" required value="<?php echo $fusion_id; ?>" readonly></td>
											<td> L1 Supervisor:<span style="font-size:24px;color:red">*</span></td>
											<td colspan="2">
												<input type="text" class="form-control" id="tl_name"  value="<?php echo $tl_name; ?>" readonly>
												<input type="hidden" class="form-control" id="tl_id" name="data[tl_id]" value="<?php echo $tl_id; ?>" required>
											</td>
										</tr>
										<tr>
											<td>Skill:<span style="font-size:24px;color:red">*</span></td>
											<td colspan="2">
												<input type="text" class="form-control" name="data[skill]" value="<?php echo $travel_pro_data['skill'] ?>" required>
											</td>
											<td>PO:<span style="font-size:24px;color:red">*</span></td>
											<td><input type="text" class="form-control" name="data[po]" value="<?php echo $travel_pro_data['po'] ?>" required>
											</td>

											<td>Call ID:<span style="font-size:24px;color:red">*</span></td>
											<td colspan="2">
												<input type="text" class="form-control" name="data[call_id]" value="<?php echo $travel_pro_data['call_id'] ?>" required>
											</td>
										</tr>
										
										<tr>
											<td>Call Duration:<span style="font-size:24px;color:red">*</span></td>
											<td colspan="2"><input type="text" class="form-control" onkeydown="return false;" id="call_duration" name="data[call_duration]" value="<?php echo $call_duration; ?>" required></td>
											
											<td>VOC:<span style="font-size:24px;color:red">*</span></td>
											<td>
												<select class="form-control" id="voc" name="data[voc]" required>
													
													<option value="">-Select-</option>
													<option value="1"  <?= ($travel_pro_data['voc']=="1")?"selected":"" ?>>1</option>
													<option value="2"  <?= ($travel_pro_data['voc']=="2")?"selected":"" ?>>2</option>
													<option value="3"  <?= ($travel_pro_data['voc']=="3")?"selected":"" ?>>3</option>
													<option value="4"  <?= ($travel_pro_data['voc']=="4")?"selected":"" ?>>4</option>
													<option value="5"  <?= ($travel_pro_data['voc']=="5")?"selected":"" ?>>5</option>
												</select>
											</td>
											<td>Record Id:<span style="font-size:24px;color:red">*</span></td>
											<td><input type="text" class="form-control" id="" name="data[record_id]" value="<?php echo $travel_pro_data['record_id'] ?>" required></td>
											
											</tr>
											<tr>
												<td>Audit Type:<span style="font-size:24px;color:red">*</span></td>
											<td>
												<select class="form-control" id="audit_type" name="data[audit_type]" required>
                                                    <option value="">-Select-</option>
                                                    <option value="CQ Audit" <?= ($travel_pro_data['audit_type']=="CQ Audit")?"selected":"" ?>>CQ Audit</option>
                                                    <option value="BQ Audit" <?= ($travel_pro_data['audit_type']=="BQ Audit")?"selected":"" ?>>BQ Audit</option>
                                                    <option value="Calibration" <?= ($travel_pro_data['audit_type']=="Calibration")?"selected":"" ?>>Calibration</option>
                                                    <option value="Pre-Certificate Mock Call" <?= ($travel_pro_data['audit_type']=="Pre-Certificate Mock Call")?"selected":"" ?>>Pre-Certificate Mock Call</option>
                                                    <option value="Certification Audit" <?= ($travel_pro_data['audit_type']=="Certification Audit")?"selected":"" ?>>Certification Audit</option>
                                                    <option value="WoW Call"  <?= ($travel_pro_data['audit_type']=="WoW Call")?"selected":"" ?>>WoW Call</option>
                                                    <option value="Hygiene Audit"  <?= ($travel_pro_data['audit_type']=="Hygiene Audit")?"selected":"" ?>>Hygiene Audit</option>
                                                    <option value="Operation Audit"  <?= ($travel_pro_data['audit_type']=="Operation Audit")?"selected":"" ?>>Operation Audit</option>
                                                    <option value="Trainer Audit"  <?= ($travel_pro_data['audit_type']=="Trainer Audit")?"selected":"" ?>>Trainer Audit</option> 
                                                    <option value="QA Supervisor Audit"  <?= ($travel_pro_data['audit_type']=="QA Supervisor Audit")?"selected":"" ?>>QA Supervisor Audit</option> 
                                                </select>
											</td>
											<td class="auType_epi">Auditor Type<span style="font-size:24px;color:red">*</span></td>
											<td class="auType_epi">
												<select class="form-control" id="auditor_type" name="data[auditor_type]">
                                                    <option value="">Select</option>
                                                    <option value="Master" <?= ($travel_pro_data['auditor_type']=="Master")?"selected":"" ?>>Master</option>
                                                    <option value="Regular" <?= ($travel_pro_data['auditor_type']=="Regular")?"selected":"" ?>>Regular</option>
                                                </select>
											</td>
										</tr>
										<tr>
											<td style="font-weight:bold; font-size:16px; text-align:left">Earned Score</td>
											<td colspan="2"><input type="text" readonly id="travel_pro_earned_score" name="data[earned_score]" class="form-control" value="<?php echo $travel_pro_data['earned_score'] ?>" /></td>
											<td style="font-weight:bold; font-size:16px; text-align:left">Possible Score</td>
											<td><input type="text" readonly id="travel_pro_possible_score" name="data[possible_score]" class="form-control" value="<?php echo $travel_pro_data['possible_score'] ?>" /></td>
											<td style="font-weight:bold; font-size:16px; text-align:right">Overall Score:</td>
											<td colspan="2"><input type="text" class="form-control" readonly id="travel_pro_overall_score" name="data[overall_score]"  style="font-weight:bold" value="<?php echo $travel_pro_data['overall_score'] ?>"></td>
										</tr>
										<tr class="eml" style="height:25px; font-weight:bold">
											<td>PARAMETER</td>
											<td colspan=3>SUB PARAMETER</td>
											<td>WEIGHTAGE/PARAMETER</td>
											<td>STATUS</td>
											<td colspan=2>REMARKS</td>
										</tr>

										<tr>
											<td class="eml" rowspan=1>Call Opening</td>
											<td colspan=3>Did the agent provide appropriate Opening?</td>
											<td>6</td>
											<td>
												<select class="form-control travel_pro_point" id ="" name="data[call_opening]" required>
													<option value="">Select</option>
													<option travel_pro_val=6 travel_pro_max="6"<?php echo $travel_pro_data['call_opening'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option travel_pro_val=0 travel_pro_max="6" <?php echo $travel_pro_data['call_opening'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													<option travel_pro_val=6 travel_pro_max="6" <?php echo $travel_pro_data['call_opening'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt1]" class="form-control" value="<?php echo $travel_pro_data['cmt1'] ?>"></td>
										</tr>

										<tr>
											<td class="eml" rowspan=4>Adherence</td>
											<td colspan=3>Did the agent complete the verification process?</td>
											<td>6</td>
											<td>
												<select class="form-control travel_pro_point" id ="" name="data[verification_process]" required>
													<option value="">Select</option>
													<option travel_pro_val=6 travel_pro_max="6"<?php echo $travel_pro_data['verification_process'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option travel_pro_val=0 travel_pro_max="6" <?php echo $travel_pro_data['verification_process'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													<option travel_pro_val=6 travel_pro_max="6" <?php echo $travel_pro_data['verification_process'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt2]" class="form-control" value="<?php echo $travel_pro_data['cmt2'] ?>"></td>
										</tr>
										<tr>
											<td colspan=3>Did the agent verify the customer's information?</td>
											<td>6</td>
											<td>
												<select class="form-control travel_pro_point" id ="" name="data[customers_information]" required>
													<option value="">Select</option>
													<option travel_pro_val=6 travel_pro_max="6"<?php echo $travel_pro_data['customers_information'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option travel_pro_val=0 travel_pro_max="6" <?php echo $travel_pro_data['customers_information'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													<option travel_pro_val=6 travel_pro_max="6" <?php echo $travel_pro_data['customers_information'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt3]" class="form-control" value="<?php echo $travel_pro_data['cmt3'] ?>"></td>
										</tr>
										<tr>
											<td colspan=3>Did the agent verify the product(s) type?</td>
											<td>6</td>
											<td>
												<select class="form-control travel_pro_point" id ="" name="data[products_type]" required>
													<option value="">Select</option>
													<option travel_pro_val=6 travel_pro_max="6"<?php echo $travel_pro_data['products_type'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option travel_pro_val=0 travel_pro_max="6" <?php echo $travel_pro_data['products_type'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													<option travel_pro_val=6 travel_pro_max="6" <?php echo $travel_pro_data['products_type'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt4]" class="form-control" value="<?php echo $travel_pro_data['cmt4'] ?>"></td>
										</tr>
										<tr>
											<td colspan=3>Did the agent verify the call back number?</td>
											<td>6</td>
											<td>
												<select class="form-control travel_pro_point" id ="" name="data[call_back_number]" required>
													<option value="">Select</option>
													<option travel_pro_val=6 travel_pro_max="6"<?php echo $travel_pro_data['call_back_number'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option travel_pro_val=0 travel_pro_max="6" <?php echo $travel_pro_data['call_back_number'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													<option travel_pro_val=6 travel_pro_max="6" <?php echo $travel_pro_data['call_back_number'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt5]" class="form-control" value="<?php echo $travel_pro_data['cmt5'] ?>"></td>
										</tr>
										<tr>
											<td class="eml" rowspan=8>Efficiency/Call control</td>
											<td colspan=3>Did the agent demonstrate Active Listening?</td>
											<td>6</td>
											<td>
												<select class="form-control travel_pro_point" id ="" name="data[active_listening]" required>
													<option value="">Select</option>
													<option travel_pro_val=6 travel_pro_max="6"<?php echo $travel_pro_data['active_listening'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option travel_pro_val=0 travel_pro_max="6" <?php echo $travel_pro_data['active_listening'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													<option travel_pro_val=6 travel_pro_max="6" <?php echo $travel_pro_data['active_listening'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt6]" class="form-control" value="<?php echo $travel_pro_data['cmt6'] ?>"></td>
										</tr>
										<tr>
											<td colspan=3>Did the agent display proficient knowledge of applicable products, services/discounts?</td>
											<td>6</td>
											<td>
												<select class="form-control travel_pro_point" id ="" name="data[proficient_knowledge]" required>
													<option value="">Select</option>
													<option travel_pro_val=6 travel_pro_max="6"<?php echo $travel_pro_data['proficient_knowledge'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option travel_pro_val=0 travel_pro_max="6" <?php echo $travel_pro_data['proficient_knowledge'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													<option travel_pro_val=6 travel_pro_max="6" <?php echo $travel_pro_data['proficient_knowledge'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt7]" class="form-control" value="<?php echo $travel_pro_data['cmt7'] ?>"></td>
										</tr>
										<tr>
											<td colspan=3>Did the agent ask appropriate probing questions?</td>
											<td>6</td>
											<td>
												<select class="form-control travel_pro_point" id ="" name="data[probing_questions]" required>
													<option value="">Select</option>
													<option travel_pro_val=6 travel_pro_max="6"<?php echo $travel_pro_data['probing_questions'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option travel_pro_val=0 travel_pro_max="6" <?php echo $travel_pro_data['probing_questions'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													<option travel_pro_val=6 travel_pro_max="6" <?php echo $travel_pro_data['probing_questions'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt8]" class="form-control" value="<?php echo $travel_pro_data['cmt8'] ?>"></td>
										</tr>
										<tr>
											<td colspan=3>Did the agent follow policy and procedures?</td>
											<td>6</td>
											<td>
												<select class="form-control travel_pro_point" id ="" name="data[follow_policy]" required>
													<option value="">Select</option>
													<option travel_pro_val=6 travel_pro_max="6"<?php echo $travel_pro_data['follow_policy'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option travel_pro_val=0 travel_pro_max="6" <?php echo $travel_pro_data['follow_policy'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													<option travel_pro_val=6 travel_pro_max="6" <?php echo $travel_pro_data['follow_policy'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt9]" class="form-control" value="<?php echo $travel_pro_data['cmt9'] ?>"></td>
										</tr>
										<tr>
											<td colspan=3>Did the agent miss any steps in the policy or procedure?</td>
											<td>6</td>
											<td>
												<select class="form-control travel_pro_point" id ="" name="data[miss_steps_in_policy]" required>
													<option value="">Select</option>
													<option travel_pro_val=6 travel_pro_max="6"<?php echo $travel_pro_data['miss_steps_in_policy'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option travel_pro_val=0 travel_pro_max="6" <?php echo $travel_pro_data['miss_steps_in_policy'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													<option travel_pro_val=6 travel_pro_max="6" <?php echo $travel_pro_data['miss_steps_in_policy'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt10]" class="form-control" value="<?php echo $travel_pro_data['cmt10'] ?>"></td>
										</tr>
										<tr>
											<td colspan=3>Did the agent display a sense of urgency/avoid dead air?</td>
											<td>6</td>
											<td>
												<select class="form-control travel_pro_point" id ="" name="data[avoid_dead_air]" required>
													<option value="">Select</option>
													<option travel_pro_val=6 travel_pro_max="6"<?php echo $travel_pro_data['avoid_dead_air'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option travel_pro_val=0 travel_pro_max="6" <?php echo $travel_pro_data['avoid_dead_air'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													<option travel_pro_val=6 travel_pro_max="6" <?php echo $travel_pro_data['avoid_dead_air'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt11]" class="form-control" value="<?php echo $travel_pro_data['cmt11'] ?>"></td>
										</tr>
										<tr>
											<td colspan=3>Did the agent setup the proper hold expectations?</td>
											<td>6</td>
											<td>
												<select class="form-control travel_pro_point" id ="" name="data[hold_expectations]" required>
													<option value="">Select</option>
													<option travel_pro_val=6 travel_pro_max="6"<?php echo $travel_pro_data['hold_expectations'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option travel_pro_val=0 travel_pro_max="6" <?php echo $travel_pro_data['hold_expectations'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													<option travel_pro_val=6 travel_pro_max="6" <?php echo $travel_pro_data['hold_expectations'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt12]" class="form-control" value="<?php echo $travel_pro_data['cmt12'] ?>"></td>
										</tr>
										<tr>
											<td colspan=3>Did the agent provide a One Call /Email/Chat Resolution?</td>
											<td>7</td>
											<td>
												<select class="form-control travel_pro_point" id ="" name="data[one_resolution]" required>
													<option value="">Select</option>
													<option travel_pro_val=7 travel_pro_max="7"<?php echo $travel_pro_data['one_resolution'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option travel_pro_val=0 travel_pro_max="7" <?php echo $travel_pro_data['one_resolution'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													<option travel_pro_val=7 travel_pro_max="7" <?php echo $travel_pro_data['one_resolution'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt13]" class="form-control" value="<?php echo $travel_pro_data['cmt13'] ?>"></td>
										</tr>
										<tr>
											<td class="eml" rowspan=1>Professional and courteous</td>
											<td colspan=3>Did the agent interact in a courteous and professional manner throughout the call?</td>
											<td>7</td>
											<td>
												<select class="form-control travel_pro_point" id ="" name="data[interact_professional_manner]" required>
													<option value="">Select</option>
													<option travel_pro_val=7 travel_pro_max="7"<?php echo $travel_pro_data['interact_professional_manner'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option travel_pro_val=0 travel_pro_max="7" <?php echo $travel_pro_data['interact_professional_manner'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													<option travel_pro_val=7 travel_pro_max="7" <?php echo $travel_pro_data['interact_professional_manner'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt14]" class="form-control" value="<?php echo $travel_pro_data['cmt14'] ?>"></td>
										</tr>
										<tr>
											<td class="eml" rowspan=1>Call Close</td>
											<td colspan=3>Did the agent provide the appropriate closing?</td>
											<td>7</td>
											<td>
												<select class="form-control travel_pro_point" id ="" name="data[appropriate_closing]" required>
													<option value="">Select</option>
													<option travel_pro_val=7 travel_pro_max="7"<?php echo $travel_pro_data['appropriate_closing'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option travel_pro_val=0 travel_pro_max="7" <?php echo $travel_pro_data['appropriate_closing'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													<option travel_pro_val=7 travel_pro_max="7" <?php echo $travel_pro_data['appropriate_closing'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt15]" class="form-control" value="<?php echo $travel_pro_data['cmt15'] ?>"></td>
										</tr>
										<tr>
											<td class="eml" rowspan=1>Complaince</td>
											<td colspan=3>Did the agent follow ALL applicable Compliance expectations?</td>
											<td>7</td>
											<td>
												<select class="form-control travel_pro_point" id ="" name="data[compliance_expectations]" required>
													<option value="">Select</option>
													<option travel_pro_val=7 travel_pro_max="7"<?php echo $travel_pro_data['compliance_expectations'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option travel_pro_val=0 travel_pro_max="7" <?php echo $travel_pro_data['compliance_expectations'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													<option travel_pro_val=7 travel_pro_max="7" <?php echo $travel_pro_data['compliance_expectations'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt16]" class="form-control" value="<?php echo $travel_pro_data['cmt16'] ?>"></td>
										</tr>
										<tr>
											<td>Call Summary:</td>
											<td colspan=3><textarea class="form-control" name="data[call_summary]"><?php echo $travel_pro_data['call_summary'] ?></textarea></td>
											<td>Feedback:</td>
											<td colspan=4><textarea class="form-control" name="data[feedback]"><?php echo $travel_pro_data['feedback'] ?></textarea></td>
										</tr>
										<tr>
											<td colspan=2>Upload Files [m4a,mp4,mp3,wav]</td>
											<?php if ($travel_pro_id == 0) { ?>
												<td colspan=6>
													<input type="file" name="attach_file[]" id="attach_file" accept=".m4a,.mp4,.mp3,.wav,audio/*" />
												</td>
												<?php } else {
												if ($travel_pro_data['attach_file'] != '') { ?>
													<td colspan=6>
														<input type="file" multiple class="form-control"  id="attach_file" name="attach_file[]" accept=".m4a,.mp4,.mp3,.wav,audio/*"> 
														<?php $attach_file = explode(",", $travel_pro_data['attach_file']);
														foreach ($attach_file as $mp) { ?>
															<audio controls='' style="background-color:#607F93">
																<source src="<?php echo base_url(); ?>qa_files/travel_pro/<?php echo $mp; ?>" type="audio/ogg">
																<source src="<?php echo base_url(); ?>qa_files/travel_pro/<?php echo $mp; ?>" type="audio/mpeg">
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

										<?php if ($travel_pro_id != 0) { ?>
											<tr>
												<td colspan=2 style="font-size:16px; font-weight:bold">Agent Feedback Acceptance:</td>
												<td colspan=6><?php echo $travel_pro_data['agnt_fd_acpt'] ?></td>
											</tr>
											<tr>
												<td colspan=2 style="font-size:16px; font-weight:bold">Agent Review:</td>
												<td colspan=6><?php echo $travel_pro_data['agent_rvw_note'] ?></td>
											</tr>
											<tr>
												<td colspan=2 style="font-size:16px; font-weight:bold">Management Review:</td>
												<td colspan=6><?php echo $travel_pro_data['mgnt_rvw_note'] ?></td>
											</tr>
											<tr>
												<td colspan=2 style="font-size:16px; font-weight:bold">Client Review:</td>
												<td colspan=6><?php echo $travel_pro_data['client_rvw_note'] ?></td>
											</tr>

											<tr>
												<td colspan=2 style="font-size:16px">Your Review<span style="font-size:24px;color:red">*</span></td>
												<td colspan=6><textarea class="form-control1" style="width:100%" id="note" name="note" required></textarea></td>
											</tr>
										<?php } ?>

										<?php
										if ($travel_pro_id == 0) {
											if (is_access_qa_module() == true || is_access_qa_operations_module() == true) { ?>
												<tr>
													<td colspan=8><button class="btn btn-success blains-effect" type="submit" id="qaformsubmit" style="width:500px;margin:auto;display:block;">SAVE</button></td>
												</tr>
												<?php
											}
										} else {
											if (is_access_qa_module() == true || is_access_qa_operations_module() == true) {
												if (is_available_qa_feedback($travel_pro_data['entry_date'], 72) == true) { ?>
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