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

<?php if ($conduent_id != 0) {
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
											<td colspan="8" id="theader" style="font-size:40px; text-align:center!important; ">Conduent- Direct Express QA FORM</td>
											<input type="hidden" name="audit_start_time" value="<?php echo CurrMySqlDate(); ?>">
										</tr>
										<?php
										if ($conduent_id == 0) {
											$auditorName = get_username();
											$auditDate = CurrDateMDY();
											//$auditDate =  CurrDateTimeMDY();
											$clDate_val = '';
										} else {
											if ($conduent_direct_express_data['entry_by'] != '') {
												$auditorName = $conduent_direct_express_data['auditor_name'];
											} else {
												$auditorName = $conduent_direct_express_data['client_name'];
											}
										
											$auditDate = mysql2mmddyy($conduent_direct_express_data['audit_date']);
										 
											$clDate_val = mysql2mmddyy($conduent_direct_express_data['call_date']);
										}

										if ($rand_id != 0) {
											$agent_id = $rand_data['sid'];
											$fusion_id = $rand_data['fusion_id'];
											$agent_name = $rand_data['fname'] . " " . $rand_data['lname'];
											$tl_id = $rand_data['assigned_to'];
											$tl_name = $rand_data['tl_name'];
											$call_duration = $rand_data['call_duration'];
											
										} else {
											$agent_id = $conduent_direct_express_data['agent_id'];
											$fusion_id = $conduent_direct_express_data['fusion_id'];
											$agent_name = $conduent_direct_express_data['fname'] . " " . $conduent_direct_express_data['lname'] ;
											$tl_id = $conduent_direct_express_data['tl_id'];
											$tl_name = $conduent_direct_express_data['tl_name'];
											$call_duration = $conduent_direct_express_data['call_duration'];
										}
										?>
										<tr>
											<td>Auditor Name: <span style="font-size:24px;color:red">*</span></td>
											<td><input type="text" class="form-control" value="<?= $auditorName; ?>" disabled></td>
											<td>Audit Date:<span style="font-size:24px;color:red">*</span></td>
											<td><input type="text" class="form-control" value="<?= $auditDate; ?>" disabled></td>
											<td>Call Date:<span style="font-size:24px;color:red">*</span></td>
											<td colspan="2">
												<input type="text" id="call_date" name="call_date"  onkeydown="return false;" value="<?php echo $clDate_val; ?>" max="<?php echo date("Y-m-d"); ?>" class="form-control" required>
											</td>
										</tr>
										<tr>
											<td>Agent Name:<span style="font-size:24px;color:red">*</span></td>
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
											<td>Fusion ID:<span style="font-size:24px;color:red">*</span></td>
											<td><input type="text" class="form-control" id="fusion_id" required value="<?php echo $fusion_id; ?>" readonly></td>
											<td> L1 Supervisor:<span style="font-size:24px;color:red">*</span></td>
											<td colspan="2">
												<input type="text" class="form-control" id="tl_name"  value="<?php echo $tl_name; ?>" readonly>
												<input type="hidden" class="form-control" id="tl_id" name="data[tl_id]" value="<?php echo $tl_id; ?>" required>
											</td>
										</tr>
										<tr>
											<td>Call Duration:<span style="font-size:24px;color:red">*</span></td>
											<td><input type="text" class="form-control" onkeydown="return false;" id="call_duration" name="data[call_duration]" value="<?php echo $call_duration; ?>" required></td>
											<td>Phone Number:<span style="font-size:24px;color:red">*</span></td>
											<td><input type="text" class="form-control" name="data[phone_no]" value="<?php echo $conduent_direct_express_data['phone_no'] ?>" onkeyup="checkDec(this);" required>
												<span id="start_phone" style="color:red"></span></td>

											<td>Ticket id/File no:<span style="font-size:24px;color:red">*</span></td>
											<td colspan="2">
												<input type="text" class="form-control" name="data[ticket_id]" value="<?php echo $conduent_direct_express_data['ticket_id'] ?>" required>
											</td>
										</tr>
										
										<tr>
											
											
											<td>VOC:<span style="font-size:24px;color:red">*</span></td>
											<td>
												<select class="form-control" id="voc" name="data[voc]" required>
													
													<option value="">-Select-</option>
													<option value="1"  <?= ($conduent_direct_express_data['voc']=="1")?"selected":"" ?>>1</option>
													<option value="2"  <?= ($conduent_direct_express_data['voc']=="2")?"selected":"" ?>>2</option>
													<option value="3"  <?= ($conduent_direct_express_data['voc']=="3")?"selected":"" ?>>3</option>
													<option value="4"  <?= ($conduent_direct_express_data['voc']=="4")?"selected":"" ?>>4</option>
													<option value="5"  <?= ($conduent_direct_express_data['voc']=="5")?"selected":"" ?>>5</option>
												
												</select>
											</td>
											<td>Audit Type:<span style="font-size:24px;color:red">*</span></td>
											<td>
												<select class="form-control" id="audit_type" name="data[audit_type]" required>
                                                    <option value="">-Select-</option>
                                                    <option value="CQ Audit" <?= ($conduent_direct_express_data['audit_type']=="CQ Audit")?"selected":"" ?>>CQ Audit</option>
                                                    <option value="BQ Audit" <?= ($conduent_direct_express_data['audit_type']=="BQ Audit")?"selected":"" ?>>BQ Audit</option>
                                                    <option value="Calibration" <?= ($conduent_direct_express_data['audit_type']=="Calibration")?"selected":"" ?>>Calibration</option>
                                                    <option value="Pre-Certificate Mock Call" <?= ($conduent_direct_express_data['audit_type']=="Pre-Certificate Mock Call")?"selected":"" ?>>Pre-Certificate Mock Call</option>
                                                    <option value="Certification Audit" <?= ($conduent_direct_express_data['audit_type']=="Certification Audit")?"selected":"" ?>>Certification Audit</option>
                                                    <option value="WoW Call"  <?= ($conduent_direct_express_data['audit_type']=="WoW Call")?"selected":"" ?>>WoW Call</option>
                                                    <option value="Hygiene Audit"  <?= ($conduent_direct_express_data['audit_type']=="Hygiene Audit")?"selected":"" ?>>Hygiene Audit</option>
                                                    <option value="Operation Audit"  <?= ($conduent_direct_express_data['audit_type']=="Operation Audit")?"selected":"" ?>>Operation Audit</option>
                                                    <option value="Trainer Audit"  <?= ($conduent_direct_express_data['audit_type']=="Trainer Audit")?"selected":"" ?>>Trainer Audit</option> 
                                                    <option value="QA Supervisor Audit"  <?= ($conduent_direct_express_data['audit_type']=="QA Supervisor Audit")?"selected":"" ?>>QA Supervisor Audit</option> 
                                                </select>
											</td>

											<td>Auditor Type<span style="font-size:24px;color:red">*</span></td>
											<td colspan="2">
												<select class="form-control" id="" name="data[auditor_type]" required>
                                                    <option value="">Select</option>
                                                    <option value="Master" <?= ($conduent_direct_express_data['auditor_type']=="Master")?"selected":"" ?>>Master</option>
                                                    <option value="Regular" <?= ($conduent_direct_express_data['auditor_type']=="Regular")?"selected":"" ?>>Regular</option>
                                                </select>
											</td>
										</tr>
									
										<tr>
											<td style="font-weight:bold; font-size:16px; text-align:left">Earned Score</td>
											<td colspan="2"><input type="text" readonly id="conduent_direct_express_earned_score" name="data[earned_score]" class="form-control" value="<?php echo $conduent_direct_express_data['earned_score'] ?>" /></td>
											<td style="font-weight:bold; font-size:16px; text-align:left">Possible Score</td>
											<td><input type="text" readonly id="conduent_direct_express_possible_score" name="data[possible_score]" class="form-control" value="<?php echo $conduent_direct_express_data['possible_score'] ?>" /></td>
											<td style="font-weight:bold; font-size:16px; text-align:right">Overall Score:</td>
											<td colspan="2"><input type="text" class="form-control conduentFatal" readonly id="conduent_direct_express_overall_score" name="data[overall_score]"  style="font-weight:bold" value="<?php echo $conduent_direct_express_data['overall_score'] ?>"></td>
										</tr>
										<tr class="eml" style="height:25px; font-weight:bold">
											<td colspan=2>PARAMETER</td>
											<td colspan=2>SUB PARAMETER</td>
											<td>WEIGHTAGE</td>
											<td>STATUS</td>
											<td colspan=2>REMARKS</td>
										</tr>

										<tr>
											<td colspan=2 class="eml" rowspan=4>Greeting</td>
											<td colspan=2>1.1 - Clearly gave name and Branded</td>
											<td>10</td>
											<td>
												<select class="form-control conduent_direct_express_point" id ="" name="data[branded]" required>
													
													<option conduent_direct_express_val=10 conduent_direct_express_max="10"<?php echo $conduent_direct_express_data['branded'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option conduent_direct_express_val=0 conduent_direct_express_max="10" <?php echo $conduent_direct_express_data['branded'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													<option conduent_direct_express_val=6 conduent_direct_express_max="10" <?php echo $conduent_direct_express_data['branded'] == "Opportunity" ? "selected" : ""; ?> value="Opportunity">Opportunity</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt1]" class="form-control" value="<?php echo $conduent_direct_express_data['cmt1'] ?>"></td>
										</tr>
										<tr>
											<td colspan=2>1.2 - Did CSP demonstrate a good tone of voice throughout the call?</td>
											<td>10</td>
											<td>
												<select class="form-control conduent_direct_express_point" id ="" name="data[good_tone]" required>
													
													<option conduent_direct_express_val=10 conduent_direct_express_max="10"<?php echo $conduent_direct_express_data['good_tone'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option conduent_direct_express_val=0 conduent_direct_express_max="10" <?php echo $conduent_direct_express_data['good_tone'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													<option conduent_direct_express_val=6 conduent_direct_express_max="10" <?php echo $conduent_direct_express_data['good_tone'] == "Opportunity" ? "selected" : ""; ?> value="Opportunity">Opportunity</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt2]" class="form-control" value="<?php echo $conduent_direct_express_data['cmt2'] ?>"></td>
										</tr>
										<tr>
											<td colspan=2>1.3 - Did CSP properly verifiy account & make appropriate updates if necessary?</td>
											<td>10</td>
											<td>
												<select class="form-control conduent_direct_express_point" id ="" name="data[verify_account]" required>
													
													<option conduent_direct_express_val=10 conduent_direct_express_max="10"<?php echo $conduent_direct_express_data['verify_account'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option conduent_direct_express_val=0 conduent_direct_express_max="10" <?php echo $conduent_direct_express_data['verify_account'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													<option conduent_direct_express_val=6 conduent_direct_express_max="10" <?php echo $conduent_direct_express_data['verify_account'] == "Opportunity" ? "selected" : ""; ?> value="Opportunity">Opportunity</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt3]" class="form-control" value="<?php echo $conduent_direct_express_data['cmt3'] ?>"></td>
										</tr>
										<tr>
											<td colspan=2>1.4 - Did CSP deliver assurance statement after purpose?</td>
											<td>10</td>
											<td>
												<select class="form-control conduent_direct_express_point" id ="" name="data[deliver_assurance]" required>
													
													<option conduent_direct_express_val=10 conduent_direct_express_max="10"<?php echo $conduent_direct_express_data['deliver_assurance'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option conduent_direct_express_val=0 conduent_direct_express_max="10" <?php echo $conduent_direct_express_data['deliver_assurance'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													<option conduent_direct_express_val=6 conduent_direct_express_max="10" <?php echo $conduent_direct_express_data['deliver_assurance'] == "Opportunity" ? "selected" : ""; ?> value="Opportunity">Opportunity</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt4]" class="form-control" value="<?php echo $conduent_direct_express_data['cmt4'] ?>"></td>
										</tr>
										<tr>
											<td colspan=2 class="eml" rowspan=5>Call Processes</td>
											<td colspan=2>2.1 - Did CSP refers to customer by last name at least once through the call? (Created Rapport.)</td>
											<td>10</td>
											<td>
												<select class="form-control conduent_direct_express_point" id ="" name="data[created_rapport]" required>
													
													<option conduent_direct_express_val=10 conduent_direct_express_max="10"<?php echo $conduent_direct_express_data['created_rapport'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option conduent_direct_express_val=0 conduent_direct_express_max="10" <?php echo $conduent_direct_express_data['created_rapport'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													<option conduent_direct_express_val=6 conduent_direct_express_max="10" <?php echo $conduent_direct_express_data['created_rapport'] == "Opportunity" ? "selected" : ""; ?> value="Opportunity">Opportunity</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt5]" class="form-control" value="<?php echo $conduent_direct_express_data['cmt5'] ?>"></td>
										</tr>
										<tr>
											<td colspan=2>2.2 - Did CSP maintain control of call?</td>
											<td>10</td>
											<td>
												<select class="form-control conduent_direct_express_point" id ="" name="data[control_call]" required>
													
													<option conduent_direct_express_val=10 conduent_direct_express_max="10"<?php echo $conduent_direct_express_data['control_call'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option conduent_direct_express_val=0 conduent_direct_express_max="10" <?php echo $conduent_direct_express_data['control_call'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													<option conduent_direct_express_val=6 conduent_direct_express_max="10" <?php echo $conduent_direct_express_data['control_call'] == "Opportunity" ? "selected" : ""; ?> value="Opportunity">Opportunity</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt6]" class="form-control" value="<?php echo $conduent_direct_express_data['cmt6'] ?>"></td>
										</tr>
										<tr>
											<td colspan=2>2.3 - Did CSP follow appropriate Hold/Wait process & avoid DEAD AIR?</td>
											<td>10</td>
											<td>
												<select class="form-control conduent_direct_express_point" id ="" name="data[hold_process]" required>
													
													<option conduent_direct_express_val=10 conduent_direct_express_max="10"<?php echo $conduent_direct_express_data['hold_process'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option conduent_direct_express_val=0 conduent_direct_express_max="10" <?php echo $conduent_direct_express_data['hold_process'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													<option conduent_direct_express_val=6 conduent_direct_express_max="10" <?php echo $conduent_direct_express_data['hold_process'] == "Opportunity" ? "selected" : ""; ?> value="Opportunity">Opportunity</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt7]" class="form-control" value="<?php echo $conduent_direct_express_data['cmt7'] ?>"></td>
										</tr>
										<tr>
											<td colspan=2>2.4 - Did CSP use soft skills?</td>
											<td>10</td>
											<td>
												<select class="form-control conduent_direct_express_point" id ="" name="data[use_soft_skills]" required>
													
													<option conduent_direct_express_val=10 conduent_direct_express_max="10"<?php echo $conduent_direct_express_data['use_soft_skills'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option conduent_direct_express_val=0 conduent_direct_express_max="10" <?php echo $conduent_direct_express_data['use_soft_skills'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													<option conduent_direct_express_val=6 conduent_direct_express_max="10" <?php echo $conduent_direct_express_data['use_soft_skills'] == "Opportunity" ? "selected" : ""; ?> value="Opportunity">Opportunity</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt8]" class="form-control" value="<?php echo $conduent_direct_express_data['cmt8'] ?>"></td>
										</tr>
										<tr>
											<td colspan=2>2.5 - Did CSP demonstrate active listening skills?</td>
											<td>10</td>
											<td>
												<select class="form-control conduent_direct_express_point" id ="" name="data[active_listening]" required>
													
													<option conduent_direct_express_val=10 conduent_direct_express_max="10"<?php echo $conduent_direct_express_data['active_listening'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option conduent_direct_express_val=0 conduent_direct_express_max="10" <?php echo $conduent_direct_express_data['active_listening'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													<option conduent_direct_express_val=6 conduent_direct_express_max="10" <?php echo $conduent_direct_express_data['active_listening'] == "Opportunity" ? "selected" : ""; ?> value="Opportunity">Opportunity</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt9]" class="form-control" value="<?php echo $conduent_direct_express_data['cmt9'] ?>"></td>
										</tr>
										<tr>
											<td colspan=2 class="eml" rowspan=3>One Call Resolution</td>
											<td colspan=2>3.1 - Proper use of probing questions?</td>
											<td>10</td>
											<td>
												<select class="form-control conduent_direct_express_point" id ="" name="data[probing_questions]" required>
													
													<option conduent_direct_express_val=10 conduent_direct_express_max="10"<?php echo $conduent_direct_express_data['probing_questions'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option conduent_direct_express_val=0 conduent_direct_express_max="10" <?php echo $conduent_direct_express_data['probing_questions'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													<option conduent_direct_express_val=6 conduent_direct_express_max="10" <?php echo $conduent_direct_express_data['probing_questions'] == "Opportunity" ? "selected" : ""; ?> value="Opportunity">Opportunity</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt10]" class="form-control" value="<?php echo $conduent_direct_express_data['cmt10'] ?>"></td>
										</tr>
										<tr>
											<td colspan=2>3.2 - Did CSP use all available systems and tools towards a One Call Resolution?</td>
											<td>10</td>
											<td>
												<select class="form-control conduent_direct_express_point" id ="" name="data[one_call_resolution]" required>
													
													<option conduent_direct_express_val=10 conduent_direct_express_max="10"<?php echo $conduent_direct_express_data['one_call_resolution'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option conduent_direct_express_val=0 conduent_direct_express_max="10" <?php echo $conduent_direct_express_data['one_call_resolution'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													<option conduent_direct_express_val=6 conduent_direct_express_max="10" <?php echo $conduent_direct_express_data['one_call_resolution'] == "Opportunity" ? "selected" : ""; ?> value="Opportunity">Opportunity</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt11]" class="form-control" value="<?php echo $conduent_direct_express_data['cmt11'] ?>"></td>
										</tr>
										<tr>
											<td colspan=2>3.3 - Did CSP provide complete and accurate information?</td>
											<td>10</td>
											<td>
												<select class="form-control conduent_direct_express_point" id ="" name="data[accurate_information]" required>
													
													<option conduent_direct_express_val=10 conduent_direct_express_max="10"<?php echo $conduent_direct_express_data['accurate_information'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option conduent_direct_express_val=0 conduent_direct_express_max="10" <?php echo $conduent_direct_express_data['accurate_information'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													<option conduent_direct_express_val=6 conduent_direct_express_max="10" <?php echo $conduent_direct_express_data['accurate_information'] == "Opportunity" ? "selected" : ""; ?> value="Opportunity">Opportunity</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt12]" class="form-control" value="<?php echo $conduent_direct_express_data['cmt12'] ?>"></td>
										</tr>
										<tr>
											<td colspan=2 class="eml" rowspan=3>Closing</td>
											<td colspan=2>4.1 - Did CSP meet documentation expectations?</td>
											<td>10</td>
											<td>
												<select class="form-control conduent_direct_express_point" id ="" name="data[meet_documentation]" required>
													
													<option conduent_direct_express_val=10 conduent_direct_express_max="10"<?php echo $conduent_direct_express_data['meet_documentation'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option conduent_direct_express_val=0 conduent_direct_express_max="10" <?php echo $conduent_direct_express_data['meet_documentation'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													<option conduent_direct_express_val=6 conduent_direct_express_max="10" <?php echo $conduent_direct_express_data['meet_documentation'] == "Opportunity" ? "selected" : ""; ?> value="Opportunity">Opportunity</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt13]" class="form-control" value="<?php echo $conduent_direct_express_data['cmt13'] ?>"></td>
										</tr>
										<tr>
											<td colspan=2>4.2 - Did CSP select the proper disposition?</td>
											<td>10</td>
											<td>
												<select class="form-control conduent_direct_express_point" id ="" name="data[proper_disposition]" required>
													
													<option conduent_direct_express_val=10 conduent_direct_express_max="10"<?php echo $conduent_direct_express_data['proper_disposition'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option conduent_direct_express_val=0 conduent_direct_express_max="10" <?php echo $conduent_direct_express_data['proper_disposition'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													<option conduent_direct_express_val=6 conduent_direct_express_max="10" <?php echo $conduent_direct_express_data['proper_disposition'] == "Opportunity" ? "selected" : ""; ?> value="Opportunity">Opportunity</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt14]" class="form-control" value="<?php echo $conduent_direct_express_data['cmt14'] ?>"></td>
										</tr>
										<tr>
											<td colspan=2>4.3 - Did CSP close the call properly?</td>
											<td>10</td>
											<td>
												<select class="form-control conduent_direct_express_point" id ="" name="data[call_properly]" required>
													
													<option conduent_direct_express_val=10 conduent_direct_express_max="10"<?php echo $conduent_direct_express_data['call_properly'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option conduent_direct_express_val=0 conduent_direct_express_max="10" <?php echo $conduent_direct_express_data['call_properly'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													<option conduent_direct_express_val=6 conduent_direct_express_max="10" <?php echo $conduent_direct_express_data['call_properly'] == "Opportunity" ? "selected" : ""; ?> value="Opportunity">Opportunity</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt15]" class="form-control" value="<?php echo $conduent_direct_express_data['cmt15'] ?>"></td>
										</tr>
										<tr>
											<td colspan=2 class="eml" rowspan=8>Auto-Fail</td>
											<td colspan=2 style="color:red">5.1 - CSP released account information or made changes to an unverified Cardholder.</td>
											<td>0</td>
											<td>
												<select class="form-control conduent_direct_express_point" id ="conduentAF1" name="data[unverified_cardholder]" required>
													
													<option conduent_direct_express_val=0 conduent_direct_express_max="0"<?php echo $conduent_direct_express_data['unverified_cardholder'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option conduent_direct_express_val=0 conduent_direct_express_max="0" <?php echo $conduent_direct_express_data['unverified_cardholder'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt16]" class="form-control" value="<?php echo $conduent_direct_express_data['cmt16'] ?>"></td>
										</tr>
										<tr>
											<td colspan=2 style="color:red">5.2 - CSP did not resolve the Customer's issue and did not demonstrate willingness to assist.</td>
											<td>0</td>
											<td>
												<select class="form-control conduent_direct_express_point" id ="conduentAF2" name="data[demonstrate_willingness]" required>
													
													<option conduent_direct_express_val=0 conduent_direct_express_max="0"<?php echo $conduent_direct_express_data['demonstrate_willingness'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option conduent_direct_express_val=0 conduent_direct_express_max="0" <?php echo $conduent_direct_express_data['demonstrate_willingness'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt17]" class="form-control" value="<?php echo $conduent_direct_express_data['cmt17'] ?>"></td>
										</tr>
										<tr>
											<td colspan=2 style="color:red">5.3 - CSP hung up on customer.</td>
											<td>0</td>
											<td>
												<select class="form-control conduent_direct_express_point" id ="conduentAF3" name="data[hung_up]" required>
													
													<option conduent_direct_express_val=0 conduent_direct_express_max="0"<?php echo $conduent_direct_express_data['hung_up'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option conduent_direct_express_val=0 conduent_direct_express_max="0" <?php echo $conduent_direct_express_data['hung_up'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt18]" class="form-control" value="<?php echo $conduent_direct_express_data['cmt18'] ?>"></td>
										</tr>
										<tr>
											<td colspan=2 style="color:red">5.4 - CSP gives blatant incorrect information to Cardholder.</td>
											<td>0</td>
											<td>
												<select class="form-control conduent_direct_express_point" id ="conduentAF4" name="data[incorrect_information]" required>
													
													<option conduent_direct_express_val=0 conduent_direct_express_max="0"<?php echo $conduent_direct_express_data['incorrect_information'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option conduent_direct_express_val=0 conduent_direct_express_max="0" <?php echo $conduent_direct_express_data['incorrect_information'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt19]" class="form-control" value="<?php echo $conduent_direct_express_data['cmt19'] ?>"></td>
										</tr>
										<tr>
											<td colspan=2 style="color:red">5.5 - CSP used inappropriate condescending/argumentative language or tone during the call.</td>
											<td>0</td>
											<td>
												<select class="form-control conduent_direct_express_point" id ="conduentAF5" name="data[argumentative_language]" required>
													
													<option conduent_direct_express_val=0 conduent_direct_express_max="0"<?php echo $conduent_direct_express_data['argumentative_language'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option conduent_direct_express_val=0 conduent_direct_express_max="0" <?php echo $conduent_direct_express_data['argumentative_language'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt20]" class="form-control" value="<?php echo $conduent_direct_express_data['cmt20'] ?>"></td>
										</tr>
										<tr>
											<td colspan=2 style="color:red">5.6 - CSP did not successfully complete transaction/process.</td>
											<td>0</td>
											<td>
												<select class="form-control conduent_direct_express_point" id ="conduentAF6" name="data[complete_transaction]" required>
													
													<option conduent_direct_express_val=0 conduent_direct_express_max="0"<?php echo $conduent_direct_express_data['complete_transaction'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option conduent_direct_express_val=0 conduent_direct_express_max="0" <?php echo $conduent_direct_express_data['complete_transaction'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt21]" class="form-control" value="<?php echo $conduent_direct_express_data['cmt21'] ?>"></td>
										</tr>
										<tr>
											<td colspan=2 style="color:red">5.7 - CSP did not leave any memos on accessed account.</td>
											<td>0</td>
											<td>
												<select class="form-control conduent_direct_express_point" id ="conduentAF7" name="data[leave_memos]" required>
													
													<option conduent_direct_express_val=0 conduent_direct_express_max="0"<?php echo $conduent_direct_express_data['leave_memos'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option conduent_direct_express_val=0 conduent_direct_express_max="0" <?php echo $conduent_direct_express_data['leave_memos'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt22]" class="form-control" value="<?php echo $conduent_direct_express_data['cmt22'] ?>"></td>
										</tr>
										<tr>
											<td colspan=2 style="color:red">5.8 - Call Avoidance/Unjustified Transfer.</td>
											<td>0</td>
											<td>
												<select class="form-control conduent_direct_express_point" id ="conduentAF8" name="data[call_avoidance]" required>
													
													<option conduent_direct_express_val=0 conduent_direct_express_max="0"<?php echo $conduent_direct_express_data['call_avoidance'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option conduent_direct_express_val=0 conduent_direct_express_max="0" <?php echo $conduent_direct_express_data['call_avoidance'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt23]" class="form-control" value="<?php echo $conduent_direct_express_data['cmt23'] ?>"></td>
										</tr>
										<tr>
											<td>Call Summary:</td>
											<td colspan=3><textarea class="form-control" name="data[call_summary]"><?php echo $conduent_direct_express_data['call_summary'] ?></textarea></td>
											<td>Feedback:</td>
											<td colspan=4><textarea class="form-control" name="data[feedback]"><?php echo $conduent_direct_express_data['feedback'] ?></textarea></td>
										</tr>
										<tr>
											<td colspan=2>Upload Files [m4a,mp4,mp3,wav]</td>
											<?php if ($conduent_id == 0) { ?>
												<td colspan=6>
													<input type="file" name="attach_file[]" id="attach_file" accept=".m4a,.mp4,.mp3,.wav,audio/*" />
												</td>
												<?php } else {
												if ($conduent_direct_express_data['attach_file'] != '') { ?>
													<td colspan=6>
														<input type="file" multiple class="form-control"  id="attach_file" name="attach_file[]" accept=".m4a,.mp4,.mp3,.wav,audio/*"> 
														<?php $attach_file = explode(",", $conduent_direct_express_data['attach_file']);
														foreach ($attach_file as $mp) { ?>
															<audio controls='' style="background-color:#607F93">
																<source src="<?php echo base_url(); ?>qa_files/conduent_direct_express/<?php echo $mp; ?>" type="audio/ogg">
																<source src="<?php echo base_url(); ?>qa_files/conduent_direct_express/<?php echo $mp; ?>" type="audio/mpeg">
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

										<?php if ($conduent_id != 0) { ?>
											<tr>
												<td colspan=2 style="font-size:16px; font-weight:bold">Agent Feedback Acceptance:</td>
												<td colspan=6><?php echo $conduent_direct_express_data['agnt_fd_acpt'] ?></td>
											</tr>
											<tr>
												<td colspan=2 style="font-size:16px; font-weight:bold">Agent Review:</td>
												<td colspan=6><?php echo $conduent_direct_express_data['agent_rvw_note'] ?></td>
											</tr>
											<tr>
												<td colspan=2 style="font-size:16px; font-weight:bold">Management Review:</td>
												<td colspan=6><?php echo $conduent_direct_express_data['mgnt_rvw_note'] ?></td>
											</tr>
											<tr>
												<td colspan=2 style="font-size:16px; font-weight:bold">Client Review:</td>
												<td colspan=6><?php echo $conduent_direct_express_data['client_rvw_note'] ?></td>
											</tr>

											<tr>
												<td colspan=2 style="font-size:16px">Your Review<span style="font-size:24px;color:red">*</span></td>
												<td colspan=6><textarea class="form-control1" style="width:100%" id="note" name="note" required></textarea></td>
											</tr>
										<?php } ?>

										<?php
										if ($conduent_id == 0) {
											if (is_access_qa_module() == true || is_access_qa_operations_module() == true) { ?>
												<tr>
													<td colspan=8><button class="btn btn-success blains-effect" type="submit" id="qaformsubmit" style="width:500px;margin:auto;display:block;">SAVE</button></td>
												</tr>
												<?php
											}
										} else {
											if (is_access_qa_module() == true || is_access_qa_operations_module() == true) {
												if (is_available_qa_feedback($conduent_direct_express_data['entry_date'], 72) == true) { ?>
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