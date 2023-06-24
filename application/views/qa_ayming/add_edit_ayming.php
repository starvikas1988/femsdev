<style>
.table > tbody > tr > td{
	text-align: center;
	font-size:12px;
}

#theader{
	font-size:20px;
	font-weight:bold;
	background-color:#95A5A6;
}

.eml{
	font-weight:bold;
	background-color:#F4D03F;
}
.eml1{
	font-weight:bold;
	background-color:#add8e6;
}
.eml2{
	font-weight:bold;
	background-color:#90ee90;
}
.eml3{
	font-weight:bold;
	background-color:#C4A484;
}
.eml4{
	font-weight:bold;
	background-color:#969d54;
}
.ui-datepicker .ui-datepicker-buttonpane button.ui-datepicker-current {
	 float: left;
	 display: none;
	}

</style>

<?php if ($ayming_id != 0) {
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
											<td colspan="8" id="theader" style="font-size:40px">AYMING</td>
											<input type="hidden" name="audit_start_time" value="<?php echo CurrMySqlDate(); ?>">
										</tr>
										<?php
										if ($ayming_id == 0) {
											$auditorName = get_username();
											//$auditDate = CurrDateMDY();
											$auditDate =  CurrDateTimeMDY();
											$clDate_val = '';
										} else {
											if ($ayming_data['entry_by'] != '') {
												$auditorName = $ayming_data['auditor_name'];
											} else {
												$auditorName = $ayming_data['client_name'];
											}
											$clDate_val = mysql2mmddyySls($ayming_data['call_date']);
										}
										?>
										<tr>
											<td>Auditor Name:</td>
											<td><input type="text" class="form-control" value="<?= $auditorName; ?>" disabled></td>
											<td>Audit Date:</td>
											<td colspan="2"><input type="text" class="form-control" value="<?= CurrDateMDY() ?>" disabled></td>
											<td>Call Date:<span style="font-size:24px;color:red">*</span></td>
											<td>
												<input type="text" id="call_date" name="call_date"  onkeydown="return false;" value="<?php echo $clDate_val; ?>" max="<?php echo date("Y-m-d"); ?>" class="form-control" required>
											</td>
										</tr>
										<tr>
											<td>Agent Name:<span style="font-size:24px;color:red">*</span></td>
											<td>
												<select class="form-control" id="agent_id" name="data[agent_id]" required>
													<?php 
													if($ayming_data['agent_id']!=''){
														?>
														<option value="<?php echo $ayming_data['agent_id'] ?>"><?php echo $ayming_data['fname'] . " " . $ayming_data['lname'] ?></option>
														<?php
													}else{
														?>
														<option value="">Select</option>
														<?php
													}
													?>
													
													<?php foreach ($agentName as $row) :  ?>
														<option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
													<?php endforeach; ?>
												</select>
											</td>
											<td>Employee ID:</td>
											<td colspan="2"><input type="text" class="form-control" id="fusion_id" required value="<?php echo $ayming_data['fusion_id'] ?>" readonly></td>
											<td> L1 Supervisor:<span style="font-size:24px;color:red">*</span></td>
											<td>
												<input type="text" class="form-control" id="tl_name" required value="<?php echo $ayming_data['tl_name'] ?>" readonly>
												<input type="hidden" class="form-control" id="tl_id" name="data[tl_id]" value="<?php echo $ayming_data['tl_id'] ?>" required>
											</td>
										</tr>
										<tr>
											<td>File Number:<span style="font-size:24px;color:red">*</span></td>
											<td>
												<input type="text" id="file_number" name="data[file_number]"  value="<?php echo $ayming_data['file_number']; ?>" class="form-control" required>
											</td>
											<td>Call Duration:<span style="font-size:24px;color:red">*</span></td>
											<td colspan="2"><input type="text" class="form-control" onkeydown="return false;" id="call_duration" name="data[call_duration]" value="<?php echo $ayming_data['call_duration']?>" required></td>
											<td>ACPT<span style="font-size:24px;color:red">*</span></td>
											<td>
												<select class="form-control" name="data[acpt]" required>
													<option value="">-Select-</option>
                                                    <option value="Agent"  <?= ($ayming_data['acpt']=="Agent")?"selected":"" ?>>Agent</option>
                                                    <option value="Process"  <?= ($ayming_data['acpt']=="Process")?"selected":"" ?>>Process</option>
                                                    <option value="Customer"  <?= ($ayming_data['acpt']=="Customer")?"selected":"" ?>>Customer</option>
                                                    <option value="Technology"  <?= ($ayming_data['acpt']=="Technology")?"selected":"" ?>>Technology</option>
                                                    <option value="NA"  <?= ($ayming_data['acpt']=="NA")?"selected":"" ?>>NA</option>
                                                </select>
											</td>
										</tr>
										<tr>
											<td>VOC:<span style="font-size:24px;color:red">*</span></td>
											<td colspan="2">
												<select class="form-control" id="voc" name="data[voc]" required>
													
													<option value="">-Select-</option>
													<option value="1"  <?= ($ayming_data['voc']=="1")?"selected":"" ?>>1</option>
													<option value="2"  <?= ($ayming_data['voc']=="2")?"selected":"" ?>>2</option>
													<option value="3"  <?= ($ayming_data['voc']=="3")?"selected":"" ?>>3</option>
													<option value="4"  <?= ($ayming_data['voc']=="4")?"selected":"" ?>>4</option>
													<option value="5"  <?= ($ayming_data['voc']=="5")?"selected":"" ?>>5</option>
													<option value="6"  <?= ($ayming_data['voc']=="6")?"selected":"" ?>>6</option>
													<option value="7"  <?= ($ayming_data['voc']=="7")?"selected":"" ?>>7</option>
													<option value="8"  <?= ($ayming_data['voc']=="8")?"selected":"" ?>>8</option>
													<option value="9"  <?= ($ayming_data['voc']=="9")?"selected":"" ?>>9</option>
													<option value="10"  <?= ($ayming_data['voc']=="10")?"selected":"" ?>>10</option>
												</select>
											</td>
											<td>Site/Location:<span style="font-size:24px;color:red">*</span></td>
											<td><input type="text" class="form-control" id="" name="data[site]" value="<?php echo $ayming_data['site'] ?>" ></td>
											<td>Audit Type:<span style="font-size:24px;color:red">*</span></td>
											<td>
												<select class="form-control" id="audit_type" name="data[audit_type]" required>
                                                    <option value="">-Select-</option>
                                                    <option value="CQ Audit" <?= ($ayming_data['audit_type']=="CQ Audit")?"selected":"" ?>>CQ Audit</option>
                                                    <option value="BQ Audit" <?= ($ayming_data['audit_type']=="BQ Audit")?"selected":"" ?>>BQ Audit</option>
                                                    <option value="Calibration" <?= ($ayming_data['audit_type']=="Calibration")?"selected":"" ?>>Calibration</option>
                                                    <option value="Pre-Certificate Mock Call" <?= ($ayming_data['audit_type']=="Pre-Certificate Mock Call")?"selected":"" ?>>Pre-Certificate Mock Call</option>
                                                    <option value="Certification Audit" <?= ($ayming_data['audit_type']=="Certification Audit")?"selected":"" ?>>Certification Audit</option>
                                                    <option value="Operation Audit" <?= ($ayming_data['audit_type']=="Operation Audit")?"selected":"" ?>>Operation Audit</option>
                                                    <option value="Trainer Audit"  <?= ($ayming_data['audit_type']=="Trainer Audit")?"selected":"" ?>>Trainer Audit</option>
                                                    <option value="WOW Call" <?= ($ayming_data['audit_type']=="WOW Call")?"selected":"" ?>>WOW Call</option>
                                                    <option value="Hygiene Audit" <?= ($ayming_data['audit_type']=="Hygiene Audit")?"selected":"" ?>>Hygiene Audit</option>
                                                    <option value="QA Supervisor Audit" <?= ($ayming_data['audit_type']=="QA Supervisor Audit")?"selected":"" ?>>QA Supervisor Audit</option>
                                                </select>
											</td>
										</tr>
										<tr>
											<td class="auType">Auditor Type<span style="font-size:24px;color:red">*</span></td>
											<td class="auType">
												<select class="form-control" id="auditor_type" name="data[auditor_type]">
                                                    
                                                    <option value="Master" <?= ($ayming_data['auditor_type']=="Master")?"selected":"" ?>>Master</option>
                                                    <option value="Regular" <?= ($ayming_data['auditor_type']=="Regular")?"selected":"" ?>>Regular</option>
                                                </select>
											</td>
											
											<!-- <td>Phone Number:<span style="font-size:24px;color:red">*</span></td>
											<td><input type="text" class="form-control" id="phone" name="data[phone]" onkeyup="checkDec(this);" value="<?php echo $ayming_data['phone'] ?>" required>
											<span id="start_phone" style="color:red"></span></td> -->
											
										</tr>
										
										<tr>
											<td style="font-weight:bold; font-size:16px; text-align:left">Earned Score</td>
											<td><input type="text" readonly id="ayming_earned_score" name="data[earned_score]" class="form-control" value="<?php echo $ayming_data['earned_score'] ?>" /></td>
											<td style="font-weight:bold; font-size:16px; text-align:left">Possible Score</td>
											<td><input type="text" readonly id="ayming_possible_score" name="data[possible_score]" class="form-control" value="<?php echo $ayming_data['possible_score'] ?>" /></td>
											<td style="font-weight:bold; font-size:16px; text-align:right">Overall Score:</td>
											<td><input type="text" readonly id="ayming_overall_score" name="data[overall_score]" class="form-control aymingFatal" style="font-weight:bold" value="<?php echo $ayming_data['overall_score'] ?>"></td>
										</tr>
										<tr class="eml" style="height:25px; font-weight:bold">
											<td>Critical Accuracy</td>
											<td colspan=2>PARAMETER</td>
											<td>Weightage</td>
											<td>STATUS</td>
											<td colspan=2>REMARKS</td>
										</tr>

										<tr>
											<td class="eml" rowspan=1 style="font-weight:bold; background-color:#d6bf91">Business Critical</td>
											<td colspan=2>Greeting</td>
											<td>10</td>
											<td>
												<select class="form-control ayming_point business" name="data[appropriate_greeting]" required>
													
													<option ayming_val=10 ayming_max=10 <?php echo $ayming_data['appropriate_greeting'] == "Yes" ? "selected" : ""; ?> value="Yes">Yes</option>
													<option ayming_val=0 ayming_max=10 <?php echo $ayming_data['appropriate_greeting'] == "No" ? "selected" : ""; ?> value="No">No</option>
													<option ayming_val=10 ayming_max=10 <?php echo $ayming_data['appropriate_greeting'] == "NA" ? "selected" : ""; ?> value="NA">NA</option>
												</select>
											</td>
											
											<td colspan=2><input type="text" name="data[cmt1]" class="form-control" value="<?php echo $ayming_data['cmt1'] ?>"></td>
										</tr>
										<tr>
											<td class="eml" rowspan=4 style="font-weight:bold; background-color:pink">Customer Critical</td>
											<td colspan=2>Did the agent intentionally interrupt the prospect? Did the agent overtalk the prospect?</td>
											<td>7</td>
											<td>
												<select class="form-control ayming_point customer" name="data[overtalk_prospect]" required>
													
													<option ayming_val=7 ayming_max=7 <?php echo $ayming_data['overtalk_prospect'] == "Yes" ? "selected" : ""; ?> value="Yes">Yes</option>
													<option ayming_val=0 ayming_max=7 <?php echo $ayming_data['overtalk_prospect'] == "No" ? "selected" : ""; ?> value="No">No</option>
													<option ayming_val=7 ayming_max=7 <?php echo $ayming_data['overtalk_prospect'] == "NA" ? "selected" : ""; ?> value="NA">NA</option>
												</select>
											</td>
										
											<td colspan=2><input type="text" name="data[cmt2]" class="form-control" value="<?php echo $ayming_data['cmt2'] ?>"></td>
										</tr>
										<tr>
											<td colspan="2">Professionalism</td>
											<td>10</td>
											<td>
												<select class="form-control ayming_point customer" name="data[professionalism]" required>
													<option ayming_val=10 ayming_max=10 <?php echo $ayming_data['professionalism'] == "Yes" ? "selected" : ""; ?> value="Yes">Yes</option>
													<option ayming_val=0 ayming_max=10 <?php echo $ayming_data['professionalism'] == "No" ? "selected" : ""; ?> value="No">No</option>
													<option ayming_val=10 ayming_max=10 <?php echo $ayming_data['professionalism'] == "NA" ? "selected" : ""; ?> value="NA">NA</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt3]" class="form-control" value="<?php echo $ayming_data['cmt3'] ?>"></td>
										</tr>
										<tr>
											<td colspan="2">Communication Skills</td>
											<td>10</td>
											<td>
												<select class="form-control ayming_point customer" name="data[communication_skill]" required>
													<option ayming_val=10 ayming_max=10 <?php echo $ayming_data['communication_skill'] == "Yes" ? "selected" : ""; ?> value="Yes">Yes</option>
													<option ayming_val=0 ayming_max=10 <?php echo $ayming_data['communication_skill'] == "No" ? "selected" : ""; ?> value="No">No</option>
													<option ayming_val=10 ayming_max=10 <?php echo $ayming_data['communication_skill'] == "NA" ? "selected" : ""; ?> value="NA">NA</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt4]" class="form-control" value="<?php echo $ayming_data['cmt4'] ?>"></td>
										</tr>
										<tr>
											<td colspan="2">Tone</td>
											<td>10</td>
											<td>
												<select class="form-control ayming_point customer" name="data[tone]" required>
													<option ayming_val=10 ayming_max=10 <?php echo $ayming_data['tone'] == "Yes" ? "selected" : ""; ?> value="Yes">Yes</option>
													<option ayming_val=0 ayming_max=10 <?php echo $ayming_data['tone'] == "No" ? "selected" : ""; ?> value="No">No</option>
													<option ayming_val=10 ayming_max=10 <?php echo $ayming_data['tone'] == "NA" ? "selected" : ""; ?> value="NA">NA</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt5]" class="form-control" value="<?php echo $ayming_data['cmt5'] ?>"></td>
										</tr>
										<tr>
											<td class="eml" rowspan=3 style="font-weight:bold; background-color:#d6bf91">Business Critical</td>
											<td colspan="2">Agent informed the concerned person regarding the Grants</td>
											<td>10</td>
											<td>
												<select class="form-control ayming_point business" name="data[concerned_person_grants]" required>
													<option ayming_val=10 ayming_max=10 <?php echo $ayming_data['concerned_person_grants'] == "Yes" ? "selected" : ""; ?> value="Yes">Yes</option>
													<option ayming_val=0 ayming_max=10 <?php echo $ayming_data['concerned_person_grants'] == "No" ? "selected" : ""; ?> value="No">No</option>
													<option ayming_val=10 ayming_max=10 <?php echo $ayming_data['concerned_person_grants'] == "NA" ? "selected" : ""; ?> value="NA">NA</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt6]" class="form-control" value="<?php echo $ayming_data['cmt6'] ?>"></td>
										</tr>
										<tr>
											<td colspan="2">Appropriate use of rebuttals</td>
											<td>15</td>
											<td>
												<select class="form-control ayming_point business" name="data[use_rebuttals]" required>
													<option ayming_val=15 ayming_max=15 <?php echo $ayming_data['use_rebuttals'] == "Yes" ? "selected" : ""; ?> value="Yes">Yes</option>
													<option ayming_val=0 ayming_max=15 <?php echo $ayming_data['use_rebuttals'] == "No" ? "selected" : ""; ?> value="No">No</option>
													<option ayming_val=15 ayming_max=15 <?php echo $ayming_data['use_rebuttals'] == "NA" ? "selected" : ""; ?> value="NA">NA</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt7]" class="form-control" value="<?php echo $ayming_data['cmt7'] ?>"></td>
										</tr>
										<tr>
											<td colspan="2">Agent scheduled the call with the concerned person</td>
											<td>10</td>
											<td>
												<select class="form-control ayming_point business" name="data[concerned_person]" required>
													<option ayming_val=10 ayming_max=10 <?php echo $ayming_data['concerned_person'] == "Yes" ? "selected" : ""; ?> value="Yes">Yes</option>
													<option ayming_val=0 ayming_max=10 <?php echo $ayming_data['concerned_person'] == "No" ? "selected" : ""; ?> value="No">No</option>
													<option ayming_val=10 ayming_max=10 <?php echo $ayming_data['concerned_person'] == "NA" ? "selected" : ""; ?> value="NA">NA</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt8]" class="form-control" value="<?php echo $ayming_data['cmt8'] ?>"></td>
										</tr>
										<tr>
											<td class="eml" rowspan=5 style="font-weight:bold; background-color:#D7BDE2">Compliance Critical</td>
											<td colspan="2" style="color: red;">Agent informed the concerned person that he/she can cancel the invite</td>
											<td>2</td>
											<td>
												<select class="form-control ayming_point compliance" id="ayming_Fatal1" name="data[cancel_invite]" required>
													<option ayming_val=2 ayming_max=2 <?php echo $ayming_data['cancel_invite'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option ayming_val=0 ayming_max=2 <?php echo $ayming_data['cancel_invite'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt9]" class="form-control" value="<?php echo $ayming_data['cmt9'] ?>"></td>
										</tr>
										<tr>
											<td colspan="2" style="color: red;">Agent verified that he/she is talking to the concerned person</td>
											<td>2</td>
											<td>
												<select class="form-control ayming_point compliance" id="ayming_Fatal2" name="data[agent_talking]" required>
													<option ayming_val=2 ayming_max=2 <?php echo $ayming_data['agent_talking'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option ayming_val=0 ayming_max=2 <?php echo $ayming_data['agent_talking'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt10]" class="form-control" value="<?php echo $ayming_data['cmt10'] ?>"></td>
										</tr>
										<tr>
											<td colspan="2">Did the agent confirm the initials "First Name, Last Name and email address", using proper phonetics?</td>
											<td>2</td>
											<td>
												<select class="form-control ayming_point compliance" name="data[proper_phonetics]" required>
													<option ayming_val=2 ayming_max=2 <?php echo $ayming_data['proper_phonetics'] == "Yes" ? "selected" : ""; ?> value="Yes">Yes</option>
													<option ayming_val=0 ayming_max=2 <?php echo $ayming_data['proper_phonetics'] == "No" ? "selected" : ""; ?> value="No">No</option>
													<option ayming_val=2 ayming_max=2 <?php echo $ayming_data['proper_phonetics'] == "NA" ? "selected" : ""; ?> value="NA">NA</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt11]" class="form-control" value="<?php echo $ayming_data['cmt11'] ?>"></td>
										</tr>
										<tr>
											<td colspan="2" style="color: red;">Rude Remarks</td>
											<td>2</td>
											<td>
												<select class="form-control ayming_point compliance" id="ayming_Fatal3"name="data[rude_remarks]" required>
													<option ayming_val=2 ayming_max=2 <?php echo $ayming_data['rude_remarks'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option ayming_val=0 ayming_max=2 <?php echo $ayming_data['rude_remarks'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt12]" class="form-control" value="<?php echo $ayming_data['cmt12'] ?>"></td>
										</tr>
										<tr>
											<td colspan="2" style="color: red;">Did the agent intentionally hang up the call</td>
											<td>2</td>
											<td>
												<select class="form-control ayming_point compliance" id="ayming_Fatal4"name="data[hang_up_call]" required>
													<option ayming_val=2 ayming_max=2 <?php echo $ayming_data['hang_up_call'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option ayming_val=0 ayming_max=2 <?php echo $ayming_data['hang_up_call'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt13]" class="form-control" value="<?php echo $ayming_data['cmt13'] ?>"></td>
										</tr>
										<tr>
											<td class="eml" rowspan=1 style="font-weight:bold; background-color:#d6bf91">Business Critical</td>
											<td colspan="2">Call Closing</td>
											<td>8</td>
											<td>
												<select class="form-control ayming_point business" name="data[call_closing]" required>
													<option ayming_val=8 ayming_max=8 <?php echo $ayming_data['call_closing'] == "Yes" ? "selected" : ""; ?> value="Yes">Yes</option>
													<option ayming_val=0 ayming_max=8 <?php echo $ayming_data['call_closing'] == "No" ? "selected" : ""; ?> value="No">No</option>
													<option ayming_val=8 ayming_max=8 <?php echo $ayming_data['call_closing'] == "NA" ? "selected" : ""; ?> value="NA">NA</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt14]" class="form-control" value="<?php echo $ayming_data['cmt14'] ?>"></td>
										</tr>

									<tr style="font-weight:bold; background-color:#D7BDE2"><td colspan=2>Customer Score</td><td colspan=2>Business Score</td><td colspan=4>Compliance Score</td></tr>

									<tr style="font-weight:bold; background-color:#D7BDE2">
										<td>Earned Point:</td><td ><input type="text" readonly class="form-control" id="customer_earned_score" name="data[customer_earned_score]" value="<?php echo $ayming_data['customer_earned_score'] ?>"></td>
										<td>Earned Point:</td><td ><input type="text" readonly class="form-control" id="business_earned_score" name="data[business_earned_score]" value="<?php echo $ayming_data['business_earned_score'] ?>"></td>
										<td>Earned Point:</td><td colspan=2><input type="text" readonly class="form-control" id="compliance_earned_score" name="data[compliance_earned_score]" value="<?php echo $ayming_data['compliance_earned_score'] ?>"></td>
									</tr>
									<tr style="font-weight:bold; background-color:#D7BDE2">
										<td>Possible Point:</td><td ><input type="text" readonly class="form-control" id="customer_possible_score" name="data[customer_possible_score]" value="<?php echo $ayming_data['customer_possible_score'] ?>"></td>
										<td>Possible Point:</td><td ><input type="text" readonly class="form-control" id="business_possible_score" name="data[business_possible_score]" value="<?php echo $ayming_data['business_possible_score'] ?>"></td>
										<td>Possible Point:</td><td colspan=2><input type="text" readonly class="form-control" id="compliance_possible_score" name="data[compliance_possible_score]" value="<?php echo $ayming_data['compliance_possible_score'] ?>"></td>
									</tr>
									<tr style="font-weight:bold; background-color:#D7BDE2">
										<td>Overall Percentage:</td><td ><input type="text" readonly class="form-control" id="customer_overall_score" name="data[customer_overall_score]" value="<?php echo $ayming_data['customer_overall_score'] ?>"></td>
										<td>Overall Percentage:</td><td ><input type="text" readonly class="form-control" id="business_overall_score" name="data[business_overall_score]" value="<?php echo $ayming_data['business_overall_score'] ?>"></td>
										<td>Overall Percentage:</td><td colspan=2><input type="text" readonly class="form-control" id="compliance_overall_score" name="data[compliance_overall_score]" value="<?php echo $ayming_data['compliance_overall_score'] ?>"></td>
									</tr>
										<tr>
											<td>Call Summary:</td>
											<td colspan=2><textarea class="form-control" name="data[call_summary]"><?php echo $ayming_data['call_summary'] ?></textarea></td>
											<td>Feedback:</td>
											<td colspan=4><textarea class="form-control" name="data[feedback]"><?php echo $ayming_data['feedback'] ?></textarea></td>
										</tr>
										<tr>
											<td colspan=2>Upload Files [m4a,mp4,mp3,wav]</td>
											<?php if ($ayming_id == 0) { ?>
												<td colspan=6>
													<input type="file" name="attach_file[]" id="attach_file" accept=".m4a,.mp4,.mp3,.wav,audio/*" />
												</td>
												<?php } else {
												if ($ayming_data['attach_file'] != '') { ?>
													<td colspan=6>
														<input type="file" multiple class="form-control"  id="attach_file" name="attach_file[]" accept=".m4a,.mp4,.mp3,.wav,audio/*"> 
														<?php $attach_file = explode(",", $ayming_data['attach_file']);
														foreach ($attach_file as $mp) { ?>
															<audio controls='' style="background-color:#607F93">
																<source src="<?php echo base_url(); ?>qa_files/qa_ayming/<?php echo $mp; ?>" type="audio/ogg">
																<source src="<?php echo base_url(); ?>qa_files/qa_ayming/<?php echo $mp; ?>" type="audio/mpeg">
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

										<?php if ($ayming_id != 0) { ?>
											<tr>
												<td colspan=2 style="font-size:16px; font-weight:bold">Agent Feedback Acceptance:</td>
												<td colspan=4><?php echo $ayming_data['agnt_fd_acpt'] ?></td>
											</tr>
											<tr>
												<td colspan=2 style="font-size:16px; font-weight:bold">Agent Review:</td>
												<td colspan=4><?php echo $ayming_data['agent_rvw_note'] ?></td>
											</tr>
											<tr>
												<td colspan=2 style="font-size:16px; font-weight:bold">Management Review:</td>
												<td colspan=4><?php echo $ayming_data['mgnt_rvw_note'] ?></td>
											</tr>
											<tr>
												<td colspan=2 style="font-size:16px; font-weight:bold">Client Review:</td>
												<td colspan=4><?php echo $ayming_data['client_rvw_note'] ?></td>
											</tr>

											<tr>
												<td colspan=2 style="font-size:16px">Your Review<span style="font-size:24px;color:red">*</span></td>
												<td colspan=4><textarea class="form-control1" style="width:100%" id="note" name="note" required></textarea></td>
											</tr>
										<?php } ?>

										<?php
										if ($ayming_id == 0) {
											if (is_access_qa_module() == true || is_access_qa_operations_module() == true) { ?>
												<tr>
													<td colspan=8><button class="btn btn-success waves-effect" type="submit" id="qaformsubmit" style="width:500px">SAVE</button></td>
												</tr>
												<?php
											}
										} else {
											if (is_access_qa_module() == true || is_access_qa_operations_module() == true) {
												if (is_available_qa_feedback($ayming_data['entry_date'], 72) == true) { ?>
													<tr>
														<td colspan="8"><button class="btn btn-success waves-effect" type="submit" id='qaformsubmit' name='btnSave' value="SAVE" style="width:500px">SAVE</button></td>
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