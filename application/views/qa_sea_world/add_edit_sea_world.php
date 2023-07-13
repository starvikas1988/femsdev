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

<?php if ($sea_world_id != 0) {
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
											<td colspan="8" id="theader" style="font-size:40px; text-align:center!important; ">SEA WORLD QA FORM</td>
											<input type="hidden" name="audit_start_time" value="<?php echo CurrMySqlDate(); ?>">
										</tr>
										<?php
										if ($sea_world_id == 0) {
											$auditorName = get_username();
											$auditDate = CurrDateMDY();
											//$auditDate =  CurrDateTimeMDY();
											$clDate_val = '';
										} else {
											if ($sea_world_data['entry_by'] != '') {
												$auditorName = $sea_world_data['auditor_name'];
											} else {
												$auditorName = $sea_world_data['client_name'];
											}
										
											$auditDate = mysql2mmddyy($sea_world_data['audit_date']);
										 
											$clDate_val = mysql2mmddyy($sea_world_data['call_date']);
										}

										if ($rand_id != 0) {
											$agent_id = $rand_data['sid'];
											$fusion_id = $rand_data['fusion_id'];
											$agent_name = $rand_data['fname'] . " " . $rand_data['lname'];
											$tl_id = $rand_data['assigned_to'];
											$tl_name = $rand_data['tl_name'];
											$call_duration = $rand_data['call_duration'];
											
										} else {
											$agent_id = $sea_world_data['agent_id'];
											$fusion_id = $sea_world_data['fusion_id'];
											$agent_name = $sea_world_data['fname'] . " " . $sea_world_data['lname'] ;
											$tl_id = $sea_world_data['tl_id'];
											$tl_name = $sea_world_data['tl_name'];
											$call_duration = $sea_world_data['call_duration'];
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
											<td>ACPT:<span style="font-size:24px;color:red">*</span></td>
											<td colspan="2">
												<select class="form-control" id="" name="data[acpt]" required>
											
											    <option value="">-Select-</option>
											    <option value="Agent" <?= ($sea_world_data['acpt']=="Agent")?"selected":"" ?>>Agent</option>
												<option value="Customer" <?= ($sea_world_data['acpt']=="Customer")?"selected":"" ?>>Customer</option>
												<option value="Process" <?= ($sea_world_data['acpt']=="Process")?"selected":"" ?>>Process</option>
												<option value="Technology" <?= ($sea_world_data['acpt']=="Technology")?"selected":"" ?>>Technology</option>
												
											
										</select>
											</td>
											<td>Phone Number:<span style="font-size:24px;color:red">*</span></td>
											<td><input type="text" class="form-control" name="data[customer_phone]" value="<?php echo $sea_world_data['customer_phone'] ?>" onkeyup="checkDec(this);" required>
												<span id="start_phone" style="color:red"></span></td>

											<td>File/Call ID:<span style="font-size:24px;color:red">*</span></td>
											<td colspan="2">
												<input type="text" class="form-control" name="data[call_id]" value="<?php echo $sea_world_data['call_id'] ?>" required>
											</td>
										</tr>
										
										<tr>
											<td>Call Duration:<span style="font-size:24px;color:red">*</span></td>
											<td colspan="2"><input type="text" class="form-control" onkeydown="return false;" id="call_duration" name="data[call_duration]" value="<?php echo $call_duration; ?>" required></td>
											<td>Reason of the Call:<span style="font-size:24px;color:red">*</span></td>
											<td>
												<select class="form-control" id="call_reason" name="data[call_reason]" required>
													
													<option value="">-Select-</option>
													<option value="Inbound"  <?= ($sea_world_data['call_reason']=="Inbound")?"selected":"" ?>>Inbound</option>
													<option value="Outbound"  <?= ($sea_world_data['call_reason']=="Outbound")?"selected":"" ?>>Outbound</option>
												</select>
											</td>
											<td>VOC:<span style="font-size:24px;color:red">*</span></td>
											<td>
												<select class="form-control" id="voc" name="data[voc]" required>
													
													<option value="">-Select-</option>
													<option value="1"  <?= ($sea_world_data['voc']=="1")?"selected":"" ?>>1</option>
													<option value="2"  <?= ($sea_world_data['voc']=="2")?"selected":"" ?>>2</option>
													<option value="3"  <?= ($sea_world_data['voc']=="3")?"selected":"" ?>>3</option>
													<option value="4"  <?= ($sea_world_data['voc']=="4")?"selected":"" ?>>4</option>
													<option value="5"  <?= ($sea_world_data['voc']=="5")?"selected":"" ?>>5</option>
													<option value="6"  <?= ($sea_world_data['voc']=="6")?"selected":"" ?>>6</option>
													<option value="7"  <?= ($sea_world_data['voc']=="7")?"selected":"" ?>>7</option>
													<option value="8"  <?= ($sea_world_data['voc']=="8")?"selected":"" ?>>8</option>
													<option value="9"  <?= ($sea_world_data['voc']=="9")?"selected":"" ?>>9</option>
													<option value="10"  <?= ($sea_world_data['voc']=="10")?"selected":"" ?>>10</option>
												</select>
											</td>
										</tr>
										<tr>
											<td>Site:<span style="font-size:24px;color:red">*</span></td>
											<td colspan="2">
												<input type="text" class="form-control" id="site" name="data[site]" value="<?php echo $sea_world_data['site'] ?>" readonly>
											</td>
											<td>Audit Type:<span style="font-size:24px;color:red">*</span></td>
											<td>
												<select class="form-control" id="audit_type" name="data[audit_type]" required>
                                                    <option value="">-Select-</option>
                                                    <option value="CQ Audit" <?= ($sea_world_data['audit_type']=="CQ Audit")?"selected":"" ?>>CQ Audit</option>
                                                    <option value="BQ Audit" <?= ($sea_world_data['audit_type']=="BQ Audit")?"selected":"" ?>>BQ Audit</option>
                                                    <option value="Calibration" <?= ($sea_world_data['audit_type']=="Calibration")?"selected":"" ?>>Calibration</option>
                                                    <option value="Pre-Certificate Mock Call" <?= ($sea_world_data['audit_type']=="Pre-Certificate Mock Call")?"selected":"" ?>>Pre-Certificate Mock Call</option>
                                                    <option value="Certification Audit" <?= ($sea_world_data['audit_type']=="Certification Audit")?"selected":"" ?>>Certification Audit</option>
                                                    <option value="WoW Call"  <?= ($sea_world_data['audit_type']=="WoW Call")?"selected":"" ?>>WoW Call</option>
                                                    <option value="Hygiene Audit"  <?= ($sea_world_data['audit_type']=="Hygiene Audit")?"selected":"" ?>>Hygiene Audit</option>
                                                    <option value="Operation Audit"  <?= ($sea_world_data['audit_type']=="Operation Audit")?"selected":"" ?>>Operation Audit</option>
                                                    <option value="Trainer Audit"  <?= ($sea_world_data['audit_type']=="Trainer Audit")?"selected":"" ?>>Trainer Audit</option> 
                                                    <option value="QA Supervisor Audit"  <?= ($sea_world_data['audit_type']=="QA Supervisor Audit")?"selected":"" ?>>QA Supervisor Audit</option> 
                                                </select>
											</td>
											
											<td class="auType_epi">Auditor Type<span style="font-size:24px;color:red">*</span></td>
											<td class="auType_epi">
												<select class="form-control" id="auditor_type" name="data[auditor_type]">
                                                    <option value="">Select</option>
                                                    <option value="Master" <?= ($sea_world_data['auditor_type']=="Master")?"selected":"" ?>>Master</option>
                                                    <option value="Regular" <?= ($sea_world_data['auditor_type']=="Regular")?"selected":"" ?>>Regular</option>
                                                </select>
											</td>
										</tr>
										<tr>
											<td style="font-weight:bold; font-size:16px; text-align:left">Earned Score</td>
											<td colspan="2"><input type="text" readonly id="sea_world_earned_score" name="data[earned_score]" class="form-control" value="<?php echo $sea_world_data['earned_score'] ?>" /></td>
											<td style="font-weight:bold; font-size:16px; text-align:left">Possible Score</td>
											<td><input type="text" readonly id="sea_world_possible_score" name="data[possible_score]" class="form-control" value="<?php echo $sea_world_data['possible_score'] ?>" /></td>
											<td style="font-weight:bold; font-size:16px; text-align:right">Overall Score:</td>
											<td colspan="2"><input type="text" class="form-control" readonly id="sea_world_overall_score" name="data[overall_score]"  style="font-weight:bold" value="<?php echo $sea_world_data['overall_score'] ?>"></td>
										</tr>
										<tr class="eml" style="height:25px; font-weight:bold">
											<td>SECTION</td>
											<td>PARAMETER</td>
											<td colspan=2>SUB PARAMETER</td>
											<td>WEIGHTAGE/PARAMETER</td>
											<td>STATUS</td>
											<td colspan=2>REMARKS</td>
										</tr>

										<tr>
											<td class="eml" rowspan=2>Section 1 - Greeting/Closing</td>
											<td class="eml1" rowspan=1>1a. Uses Proper Greeting</td>
											<td colspan=2> Thanks guest for calling SW & BG (or DCO, or SPL)
											 - States name
											 - Offers assistance
											 - Mentions Survey 
											 - Agent addresses guest by name if available on contacts when the call comes in</td>
											<td>3</td>
											<td>
												<select class="form-control sea_world_point" id ="" name="data[use_proper_greeting]" required>
													
													<option sea_world_val=3 sea_world_max="3"<?php echo $sea_world_data['use_proper_greeting'] == "Yes" ? "selected" : ""; ?> value="Yes">Yes</option>
													<option sea_world_val=0 sea_world_max="3" <?php echo $sea_world_data['use_proper_greeting'] == "No" ? "selected" : ""; ?> value="No">No</option>
													<option sea_world_val=3 sea_world_max="3" <?php echo $sea_world_data['use_proper_greeting'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt1]" class="form-control" value="<?php echo $sea_world_data['cmt1'] ?>"></td>
										</tr>
										<tr>
											<td class="eml1" rowspan=1>1b. Uses Proper Closing</td>
											<td colspan=2> Agent offers additional assistance
											 - Thanks the guest for calling SW & BG (or park discussed in the call)
											 - Mentions Survey</td>
											<td>3</td>
											<td>
												<select class="form-control sea_world_point" id ="" name="data[use_proper_closing]" required>
													
													<option sea_world_val=3 sea_world_max="3"<?php echo $sea_world_data['use_proper_closing'] == "Yes" ? "selected" : ""; ?> value="Yes">Yes</option>
													<option sea_world_val=0 sea_world_max="3" <?php echo $sea_world_data['use_proper_closing'] == "No" ? "selected" : ""; ?> value="No">No</option>
													<option sea_world_val=3 sea_world_max="3" <?php echo $sea_world_data['use_proper_closing'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt2]" class="form-control" value="<?php echo $sea_world_data['cmt2'] ?>"></td>
										</tr>
										<tr>
											<td class="eml" rowspan=4>Section 2 - Ambassador Etiquette</td>
											<td class="eml1" rowspan=1 colspan=3>2a. Agent maintained proper tone, pitch, volume, clarity, and pace throughout the call</td>
											<td>8</td>
											<td>
												<select class="form-control sea_world_point" id ="" name="data[proper_tone]" required>
													
													<option sea_world_val=8 sea_world_max="8"<?php echo $sea_world_data['proper_tone'] == "Yes" ? "selected" : ""; ?> value="Yes">Yes</option>
													<option sea_world_val=0 sea_world_max="8" <?php echo $sea_world_data['proper_tone'] == "No" ? "selected" : ""; ?> value="No">No</option>
													<option sea_world_val=8 sea_world_max="8" <?php echo $sea_world_data['proper_tone'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt3]" class="form-control" value="<?php echo $sea_world_data['cmt3'] ?>"></td>
										</tr>
										<tr>
											<td class="eml1" rowspan=1 colspan=3>2b. Agent used courteous words and phrases. Also was friendly, polite, and professional</td>
											<td>6</td>
											<td>
												<select class="form-control sea_world_point" id ="" name="data[courteous_words]" required>
													
													<option sea_world_val=6 sea_world_max="6"<?php echo $sea_world_data['courteous_words'] == "Yes" ? "selected" : ""; ?> value="Yes">Yes</option>
													<option sea_world_val=0 sea_world_max="6" <?php echo $sea_world_data['courteous_words'] == "No" ? "selected" : ""; ?> value="No">No</option>
													<option sea_world_val=6 sea_world_max="6" <?php echo $sea_world_data['courteous_words'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt4]" class="form-control" value="<?php echo $sea_world_data['cmt4'] ?>"></td>
										</tr>
										<tr>
											<td class="eml1" rowspan=1 colspan=3>2c.The agent adapted their approach to the customer based on the customer’s unique needs, personality and issues</td>
											<td>6</td>
											<td>
												<select class="form-control sea_world_point" id ="" name="data[agent_adapted_approach]" required>
													
													<option sea_world_val=6 sea_world_max="6"<?php echo $sea_world_data['agent_adapted_approach'] == "Yes" ? "selected" : ""; ?> value="Yes">Yes</option>
													<option sea_world_val=0 sea_world_max="6" <?php echo $sea_world_data['agent_adapted_approach'] == "No" ? "selected" : ""; ?> value="No">No</option>
													<option sea_world_val=6 sea_world_max="6" <?php echo $sea_world_data['agent_adapted_approach'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt5]" class="form-control" value="<?php echo $sea_world_data['cmt5'] ?>"></td>
										</tr>
										<tr>
											<td class="eml1" rowspan=1>2d. Active Listening</td>
											<td colspan=2> Agent provides undivided attention
											 - Agent does not interrupt or speak over the guest
											 - Captures all concerns effectively 
											 - Does not ask guest to repeat themselves.  
											 - Properly assists guests needs</td>
											<td>6</td>
											<td>
												<select class="form-control sea_world_point" id ="" name="data[active_listening]" required>
													
													<option sea_world_val=6 sea_world_max="6"<?php echo $sea_world_data['active_listening'] == "Yes" ? "selected" : ""; ?> value="Yes">Yes</option>
													<option sea_world_val=0 sea_world_max="6" <?php echo $sea_world_data['active_listening'] == "No" ? "selected" : ""; ?> value="No">No</option>
													<option sea_world_val=6 sea_world_max="6" <?php echo $sea_world_data['active_listening'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt6]" class="form-control" value="<?php echo $sea_world_data['cmt6'] ?>"></td>
										</tr>
										<tr>
											<td class="eml" rowspan=11>Section 3 - Call Handling and Problem Solving</td>
											<td class="eml1" rowspan=5>3.1 Owns the Call</td>
											<td colspan=2>3.1.a. Agent takes ownership of the call and resolves all issues that arise throughout the call. </td>
											<td>11</td>
											<td>
												<select class="form-control sea_world_point" id ="" name="data[agent_takes_ownership]" required>
													
													<option sea_world_val=11 sea_world_max="11"<?php echo $sea_world_data['agent_takes_ownership'] == "Yes" ? "selected" : ""; ?> value="Yes">Yes</option>
													<option sea_world_val=0 sea_world_max="11" <?php echo $sea_world_data['agent_takes_ownership'] == "No" ? "selected" : ""; ?> value="No">No</option>
													<option sea_world_val=11 sea_world_max="11" <?php echo $sea_world_data['agent_takes_ownership'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt7]" class="form-control" value="<?php echo $sea_world_data['cmt7'] ?>"></td>
										</tr>
										<tr>
											<td rowspan=1 colspan=2>3.1.b. Agent follows all SOP/Policies as stated in SharePoint. </td>
											<td>7</td>
											<td>
												<select class="form-control sea_world_point" id ="" name="data[follows_all_SOP]" required>
													
													<option sea_world_val=7 sea_world_max="7"<?php echo $sea_world_data['follows_all_SOP'] == "Yes" ? "selected" : ""; ?> value="Yes">Yes</option>
													<option sea_world_val=0 sea_world_max="7" <?php echo $sea_world_data['follows_all_SOP'] == "No" ? "selected" : ""; ?> value="No">No</option>
													<option sea_world_val=7 sea_world_max="7" <?php echo $sea_world_data['follows_all_SOP'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt8]" class="form-control" value="<?php echo $sea_world_data['cmt8'] ?>"></td>
										</tr>
										<tr>
											<td rowspan=1 colspan=2>3.1.c. Agent does not blame parks or other departments for problem guest is calling about.</td>
											<td>4</td>
											<td>
												<select class="form-control sea_world_point" id ="" name="data[blame_parks]" required>
													
													<option sea_world_val=4 sea_world_max="4"<?php echo $sea_world_data['blame_parks'] == "Yes" ? "selected" : ""; ?> value="Yes">Yes</option>
													<option sea_world_val=0 sea_world_max="4" <?php echo $sea_world_data['blame_parks'] == "No" ? "selected" : ""; ?> value="No">No</option>
													<option sea_world_val=4 sea_world_max="4" <?php echo $sea_world_data['blame_parks'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt9]" class="form-control" value="<?php echo $sea_world_data['cmt9'] ?>"></td>
										</tr>
										<tr>
											<td rowspan=1 colspan=2>3.1.d.The agent asked pertinent questions to accurately diagnose the guest's need or problem.</td>
											<td>6</td>
											<td>
												<select class="form-control sea_world_point" id ="" name="data[asked_pertinent_questions]" required>
													
													<option sea_world_val=6 sea_world_max="6"<?php echo $sea_world_data['asked_pertinent_questions'] == "Yes" ? "selected" : ""; ?> value="Yes">Yes</option>
													<option sea_world_val=0 sea_world_max="6" <?php echo $sea_world_data['asked_pertinent_questions'] == "No" ? "selected" : ""; ?> value="No">No</option>
													<option sea_world_val=6 sea_world_max="6" <?php echo $sea_world_data['asked_pertinent_questions'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt10]" class="form-control" value="<?php echo $sea_world_data['cmt10'] ?>"></td>
										</tr>
										<tr>
											<td rowspan=1 colspan=2>3.1.e. Agent used appropropriate resources to address the issue.</td>
											<td>4</td>
											<td>
												<select class="form-control sea_world_point" id ="" name="data[used_appropropriate_resources]" required>
													
													<option sea_world_val=4 sea_world_max="4"<?php echo $sea_world_data['used_appropropriate_resources'] == "Yes" ? "selected" : ""; ?> value="Yes">Yes</option>
													<option sea_world_val=0 sea_world_max="4" <?php echo $sea_world_data['used_appropropriate_resources'] == "No" ? "selected" : ""; ?> value="No">No</option>
													<option sea_world_val=4 sea_world_max="4" <?php echo $sea_world_data['used_appropropriate_resources'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt11]" class="form-control" value="<?php echo $sea_world_data['cmt11'] ?>"></td>
										</tr>
										<tr>
											<td class="eml1" rowspan=3>3.2 Product Knowledge</td>
											<td colspan=2>3.2.a. Agent is familiar with our products and provides accurate information.</td>
											<td>8</td>
											<td>
												<select class="form-control sea_world_point" id ="" name="data[accurate_information]" required>
													
													<option sea_world_val=8 sea_world_max="8"<?php echo $sea_world_data['accurate_information'] == "Yes" ? "selected" : ""; ?> value="Yes">Yes</option>
													<option sea_world_val=0 sea_world_max="8" <?php echo $sea_world_data['accurate_information'] == "No" ? "selected" : ""; ?> value="No">No</option>
													<option sea_world_val=8 sea_world_max="8" <?php echo $sea_world_data['accurate_information'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt12]" class="form-control" value="<?php echo $sea_world_data['cmt12'] ?>"></td>
										</tr>
										<tr>
											<td rowspan=1 colspan=2>3.2.b. Agent sounds confident and knowledgeable</td>
											<td>6</td>
											<td>
												<select class="form-control sea_world_point" id ="" name="data[sounds_confident]" required>
													
													<option sea_world_val=6 sea_world_max="6"<?php echo $sea_world_data['sounds_confident'] == "Yes" ? "selected" : ""; ?> value="Yes">Yes</option>
													<option sea_world_val=0 sea_world_max="6" <?php echo $sea_world_data['sounds_confident'] == "No" ? "selected" : ""; ?> value="No">No</option>
													<option sea_world_val=6 sea_world_max="6" <?php echo $sea_world_data['sounds_confident'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt13]" class="form-control" value="<?php echo $sea_world_data['cmt13'] ?>"></td>
										</tr>
										<tr>
											<td rowspan=1 colspan=2>3.2.c. Agent presents a sense of urgency whenever applicable</td>
											<td>4</td>
											<td>
												<select class="form-control sea_world_point" id ="" name="data[sense_of_urgency]" required>
													
													<option sea_world_val=4 sea_world_max="4"<?php echo $sea_world_data['sense_of_urgency'] == "Yes" ? "selected" : ""; ?> value="Yes">Yes</option>
													<option sea_world_val=0 sea_world_max="4" <?php echo $sea_world_data['sense_of_urgency'] == "No" ? "selected" : ""; ?> value="No">No</option>
													<option sea_world_val=4 sea_world_max="4" <?php echo $sea_world_data['sense_of_urgency'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt14]" class="form-control" value="<?php echo $sea_world_data['cmt14'] ?>"></td>
										</tr>
										<tr>
											<td class="eml1" rowspan=3>3.3 Call Efficiency</td>
											<td colspan=2>3.3.a Agent handles call efficiently through effective navigation and by not going over irrelevant products/information</td>
											<td>6</td>
											<td>
												<select class="form-control sea_world_point" id ="" name="data[effective_navigation]" required>
													
													<option sea_world_val=6 sea_world_max="6"<?php echo $sea_world_data['effective_navigation'] == "Yes" ? "selected" : ""; ?> value="Yes">Yes</option>
													<option sea_world_val=0 sea_world_max="6" <?php echo $sea_world_data['effective_navigation'] == "No" ? "selected" : ""; ?> value="No">No</option>
													<option sea_world_val=6 sea_world_max="6" <?php echo $sea_world_data['effective_navigation'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt15]" class="form-control" value="<?php echo $sea_world_data['cmt15'] ?>"></td>
										</tr>
										<tr>
											<td rowspan=1 colspan=2>3.3.b. Uses proper hold procedure 
											 - Agent asks guest permission to place them on hold 
											 - Agent checks back in on guest every 2 minutes while on hold
											 - Agent does not place guest on any unnecessary holds</td>
											<td>8</td>
											<td>
												<select class="form-control sea_world_point" id ="" name="data[proper_hold_procedure]" required>
													
													<option sea_world_val=8 sea_world_max="8"<?php echo $sea_world_data['proper_hold_procedure'] == "Yes" ? "selected" : ""; ?> value="Yes">Yes</option>
													<option sea_world_val=0 sea_world_max="8" <?php echo $sea_world_data['proper_hold_procedure'] == "No" ? "selected" : ""; ?> value="No">No</option>
													<option sea_world_val=8 sea_world_max="8" <?php echo $sea_world_data['proper_hold_procedure'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt16]" class="form-control" value="<?php echo $sea_world_data['cmt16'] ?>"></td>
										</tr>
										<tr>
											<td rowspan=1 colspan=2>3.3.c. Agent minimized or eliminated dead air</td>
											<td>4</td>
											<td>
												<select class="form-control sea_world_point" id ="" name="data[eliminated_dead_air]" required>
													
													<option sea_world_val=4 sea_world_max="4"<?php echo $sea_world_data['eliminated_dead_air'] == "Yes" ? "selected" : ""; ?> value="Yes">Yes</option>
													<option sea_world_val=0 sea_world_max="4" <?php echo $sea_world_data['eliminated_dead_air'] == "No" ? "selected" : ""; ?> value="No">No</option>
													<option sea_world_val=4 sea_world_max="4" <?php echo $sea_world_data['eliminated_dead_air'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt17]" class="form-control" value="<?php echo $sea_world_data['cmt17'] ?>"></td>
										</tr>
										<tr class="eml" style="height:25px; font-weight:bold">
											<td colspan="4">Compliance Items</td>
											<td colspan="4">Additional Notes</td>
										</tr>
										<tr>
											<td rowspan=1 colspan=4>Asked if guest wants to use AMEX</td>
											<td colspan=4><input type="text" name="data[use_AMEX_cmt]" class="form-control" value="<?php echo $sea_world_data['use_AMEX_cmt'] ?>"></td>
										</tr>
										
										<tr>
											<td rowspan=1 colspan=4>Explains Ezpay Contract / Cxl Policies</td>
											<td colspan=4><input type="text" name="data[Cxl_Policies_cmt]" class="form-control" value="<?php echo $sea_world_data['Cxl_Policies_cmt'] ?>"></td>
										</tr>
										<tr>
											<td rowspan=1 colspan=4>Never rude to a guest</td>
											<td colspan=4><input type="text" name="data[rude_to_guest_cmt]" class="form-control" value="<?php echo $sea_world_data['rude_to_guest_cmt'] ?>"></td>
										</tr>
										<tr>
											<td rowspan=1 colspan=4>Leaves COMPLETE notes in all accounts/orders</td>
											<td colspan=4><input type="text" name="data[leave_complete_notes_cmt]" class="form-control" value="<?php echo $sea_world_data['leave_complete_notes_cmt'] ?>"></td>
										</tr>
										<tr>
											<td rowspan=1 colspan=4>Qualifies Park by city/state</td>
											<td colspan=4><input type="text" name="data[qualifies_Park_cmt]" class="form-control" value="<?php echo $sea_world_data['qualifies_Park_cmt'] ?>"></td>
										</tr>
										<tr>
											<td rowspan=1 colspan=4>Uses the correct disposition codes</td>
											<td colspan=4><input type="text" name="data[correct_disposition_codes_cmt]" class="form-control" value="<?php echo $sea_world_data['correct_disposition_codes_cmt'] ?>"></td>
										</tr>
										<tr>
											<td>Call Summary:</td>
											<td colspan=3><textarea class="form-control" name="data[call_summary]"><?php echo $sea_world_data['call_summary'] ?></textarea></td>
											<td>Feedback:</td>
											<td colspan=4><textarea class="form-control" name="data[feedback]"><?php echo $sea_world_data['feedback'] ?></textarea></td>
										</tr>
										<tr>
											<td colspan=2>Upload Files [m4a,mp4,mp3,wav]</td>
											<?php if ($sea_world_id == 0) { ?>
												<td colspan=6>
													<input type="file" name="attach_file[]" id="attach_file" accept=".m4a,.mp4,.mp3,.wav,audio/*" />
												</td>
												<?php } else {
												if ($sea_world_data['attach_file'] != '') { ?>
													<td colspan=6>
														<input type="file" multiple class="form-control"  id="attach_file" name="attach_file[]" accept=".m4a,.mp4,.mp3,.wav,audio/*"> 
														<?php $attach_file = explode(",", $sea_world_data['attach_file']);
														foreach ($attach_file as $mp) { ?>
															<audio controls='' style="background-color:#607F93">
																<source src="<?php echo base_url(); ?>qa_files/sea_world/<?php echo $mp; ?>" type="audio/ogg">
																<source src="<?php echo base_url(); ?>qa_files/sea_world/<?php echo $mp; ?>" type="audio/mpeg">
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

										<?php if ($sea_world_id != 0) { ?>
											<tr>
												<td colspan=2 style="font-size:16px; font-weight:bold">Agent Feedback Acceptance:</td>
												<td colspan=6><?php echo $sea_world_data['agnt_fd_acpt'] ?></td>
											</tr>
											<tr>
												<td colspan=2 style="font-size:16px; font-weight:bold">Agent Review:</td>
												<td colspan=6><?php echo $sea_world_data['agent_rvw_note'] ?></td>
											</tr>
											<tr>
												<td colspan=2 style="font-size:16px; font-weight:bold">Management Review:</td>
												<td colspan=6><?php echo $sea_world_data['mgnt_rvw_note'] ?></td>
											</tr>
											<tr>
												<td colspan=2 style="font-size:16px; font-weight:bold">Client Review:</td>
												<td colspan=6><?php echo $sea_world_data['client_rvw_note'] ?></td>
											</tr>

											<tr>
												<td colspan=2 style="font-size:16px">Your Review<span style="font-size:24px;color:red">*</span></td>
												<td colspan=6><textarea class="form-control1" style="width:100%" id="note" name="note" required></textarea></td>
											</tr>
										<?php } ?>

										<?php
										if ($sea_world_id == 0) {
											if (is_access_qa_module() == true || is_access_qa_operations_module() == true) { ?>
												<tr>
													<td colspan=8><button class="btn btn-success blains-effect" type="submit" id="qaformsubmit" style="width:500px;margin:auto;display:block;">SAVE</button></td>
												</tr>
												<?php
											}
										} else {
											if (is_access_qa_module() == true || is_access_qa_operations_module() == true) {
												if (is_available_qa_feedback($sea_world_data['entry_date'], 72) == true) { ?>
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