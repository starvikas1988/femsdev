<style>
.table > tbody > tr > td{
	text-align: center;
	font-size:13px;
}

#theader{
	font-size:20px;
	font-weight:bold;
	background-color:#95A5A6;
}
.ui-datepicker .ui-datepicker-buttonpane button.ui-datepicker-current {
	 float: left;
	 display: none;
	}

</style>


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
										<td colspan="6" id="theader" style="font-size:40px">Unacademy Activation Agent Form</td>
										<input type="hidden" name="audit_start_time" value="<?php echo CurrMySqlDate(); ?>">
									</tr>
									<?php
										 $rand_id = 0;
											if($unacademy_activation_data['entry_by']!=''){
												$auditorName = $unacademy_activation_data['auditor_name'];
											}else{
												$auditorName = $unacademy_activation_data['client_name'];
											}
											$auditDate = mysql2mmddyy($unacademy_activation_data['audit_date']);
											$clDate_val = mysql2mmddyy($unacademy_activation_data['call_date']);
											$clEndDate_val = mysql2mmddyy($unacademy_activation_data['call_end_date']);
										
										if ($rand_id != 0) {
											$agent_id = $rand_data['sid'];
											$fusion_id = $rand_data['fusion_id'];
											$agent_name = $rand_data['fname'] . " " . $rand_data['lname'];
											$tl_id = $rand_data['assigned_to'];
											$tl_name = $rand_data['tl_name'];
											$call_duration = $rand_data['call_duration'];
											
										} else {
											$agent_id = $unacademy_activation_data['agent_id'];
											$fusion_id = $unacademy_activation_data['fusion_id'];
											$agent_name = $unacademy_activation_data['fname'] . " " . $unacademy_activation_data['lname'] ;
											$tl_id = $unacademy_activation_data['tl_id'];
											$tl_name = $unacademy_activation_data['tl_name'];
											$call_duration = $unacademy_activation_data['call_duration'];
										}
									?>
									<tr>
										<td>Auditor Name:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control form_unacademy" value="<?php echo $auditorName; ?>" disabled></td>
										<td>Audit Date:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control form_unacademy" value="<?php echo $auditDate; ?>" disabled></td>
										<td>Email:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control form_unacademy" name="data[email]" value="<?php echo $unacademy_activation_data['email'] ?>" disabled ></td>
										
									</tr>
									<tr>
										<td>Agent Name:<span style="font-size:24px;color:red">*</span></td>
										<td>
											<select class="form-control form_unacademy" id="agent_id" name="data[agent_id]" disabled>
											<option value="">-Select-</option>
											<?php foreach($agentName as $row){
												$sCss='';
												if($row['id']==$agent_id) $sCss='selected';
											?>
												<option value="<?php echo $row['id']; ?>" <?php echo $sCss; ?>><?php echo $row['name']; ?></option>
											<?php } ?>
										</select>
										</td>
										<td>Employee <br>ID:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control form_unacademy" id="fusion_id" value="<?php echo $unacademy_activation_data['fusion_id'] ?>" readonly ></td>
										<td>L1 <br>Supervisor:<span style="font-size:24px;color:red">*</span></td>
										<td>
											<input type="text" class="form-control form_unacademy" id="tl_name"  value="<?php echo $tl_name; ?>" readonly>
												<input type="hidden" class="form-control form_unacademy" id="tl_id" name="data[tl_id]" value="<?php echo $tl_id; ?>" disabled>
										</td>
									</tr>
									<tr>
										<td>Call Start Date:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control form_unacademy"  id="call_date" name="call_date" value="<?php echo $clDate_val; ?>" disabled ></td>
										<td>Call End Date:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control form_unacademy" id="call_end_date" name="call_end_date" value="<?php echo $clEndDate_val; ?>" disabled></td>
										<td>Duration:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control" onkeydown="return false;" id="call_duration" name="data[call_duration]" value="<?php echo $call_duration; ?>" disabled></td>
									</tr>
									
									<tr>
										<td>Ticket/Audit ID:<span style="font-size:24px;color:red">*</span></td>
										<td>
											<input type="text" class="form-control form_unacademy" id="" name="data[ticket_id]" value="<?php echo $unacademy_activation_data['ticket_id'] ?>" disabled>
										</td>
										<td>VOC:<span style="font-size:24px;color:red">*</span></td>
											<td>
												<select class="form-control form_unacademy" id="voc" name="data[voc]" disabled>
													
													<option value="">-Select-</option>
													<option value="1"  <?= ($unacademy_activation_data['voc']=="1")?"selected":"" ?>>1</option>
													<option value="2"  <?= ($unacademy_activation_data['voc']=="2")?"selected":"" ?>>2</option>
													<option value="3"  <?= ($unacademy_activation_data['voc']=="3")?"selected":"" ?>>3</option>
													<option value="4"  <?= ($unacademy_activation_data['voc']=="4")?"selected":"" ?>>4</option>
													<option value="5"  <?= ($unacademy_activation_data['voc']=="5")?"selected":"" ?>>5</option>
													<option value="6"  <?= ($unacademy_activation_data['voc']=="6")?"selected":"" ?>>6</option>
													<option value="7"  <?= ($unacademy_activation_data['voc']=="7")?"selected":"" ?>>7</option>
													<option value="8"  <?= ($unacademy_activation_data['voc']=="8")?"selected":"" ?>>8</option>
													<option value="9"  <?= ($unacademy_activation_data['voc']=="9")?"selected":"" ?>>9</option>
													<option value="10"  <?= ($unacademy_activation_data['voc']=="10")?"selected":"" ?>>10</option>
												</select>
											</td>
										<td>BDE Email ID:<span style="font-size:24px;color:red">*</span></td>
										<td>
											<input type="text" class="form-control form_unacademy" id="" name="data[bde_email]"  value="<?php echo $unacademy_activation_data['bde_email'] ?>" disabled>
										</td>
										
									</tr>
									<tr>
										<td>Time of Call:<span style="font-size:24px;color:red">*</span></td>
										<td>
											<input type="text" class="form-control form_unacademy" id="time_call_duration" onkeydown="return false;" name="data[time_of_call]" value="<?php echo $unacademy_activation_data['time_of_call'] ?>" disabled>
										</td>
										<td>Category:<span style="font-size:24px;color:red">*</span></td>
										<td>
											<input type="text" class="form-control form_unacademy" id="" name="data[category]" value="<?php echo $unacademy_activation_data['category'] ?>" disabled>
										</td>
										<td>KPI - ACPT:<span style="font-size:24px;color:red">*</span></td>
										<td>
											<select class="form-control form_unacademy" name="data[kpi_acpt]" disabled>
												<option value="">-Select-</option>
												<option <?php echo $unacademy_activation_data['kpi_acpt'] == "Agent"?"selected":"";?> value="Agent">Agent</option>
												<option <?php echo $unacademy_activation_data['kpi_acpt'] == "Process"?"selected":"";?> value="Process">Process</option>
												<option <?php echo $unacademy_activation_data['kpi_acpt'] == "Customer"?"selected":"";?> value="Customer">Customer</option>
												<option <?php echo $unacademy_activation_data['kpi_acpt'] == "Technology"?"selected":"";?> value="Technology">Technology</option>
												<option <?php echo $unacademy_activation_data['kpi_acpt'] == "NA"?"selected":"";?> value="NA">NA</option>
											</select> 
										</td>
									</tr>
									
									<tr>
										<td>No of calls audited:<span style="font-size:24px;color:red">*</span></td>
										<td>
											<input type="text" class="form-control form_unacademy" id="" name="data[calls_audited_count]" value="<?php echo $unacademy_activation_data['calls_audited_count'] ?>" disabled>
										</td>
										<td>Lead URL:<span style="font-size:24px;color:red">*</span></td>
										<td>
											<input type="text" class="form-control form_unacademy" id="" name="data[lead_url]" value="<?php echo $unacademy_activation_data['lead_url'] ?>" disabled>
										</td>
										<td>Audit Type:<span style="font-size:24px;color:red">*</span></td>
										<td>
											<select class="form-control form_unacademy" id="audit_type" name="data[audit_type]" disabled>
                                                    <option value="">-Select-</option>
                                                    <option value="CQ Audit" <?= ($unacademy_activation_data['audit_type']=="CQ Audit")?"selected":"" ?>>CQ Audit</option>
                                                    <option value="BQ Audit" <?= ($unacademy_activation_data['audit_type']=="BQ Audit")?"selected":"" ?>>BQ Audit</option>
                                                    <option value="Calibration" <?= ($unacademy_activation_data['audit_type']=="Calibration")?"selected":"" ?>>Calibration</option>
                                                    <option value="Pre-Certificate Mock Call" <?= ($unacademy_activation_data['audit_type']=="Pre-Certificate Mock Call")?"selected":"" ?>>Pre-Certificate Mock Call</option>
                                                    <option value="Certification Audit" <?= ($unacademy_activation_data['audit_type']=="Certification Audit")?"selected":"" ?>>Certification Audit</option>
                                                    <option value="WoW Call"  <?= ($unacademy_activation_data['audit_type']=="WoW Call")?"selected":"" ?>>WoW Call</option>
                                                    <option value="Hygiene Audit"  <?= ($unacademy_activation_data['audit_type']=="Hygiene Audit")?"selected":"" ?>>Hygiene Audit</option>
                                                    <option value="Operation Audit"  <?= ($unacademy_activation_data['audit_type']=="Operation Audit")?"selected":"" ?>>Operation Audit</option>
                                                    <option value="Trainer Audit"  <?= ($unacademy_activation_data['audit_type']=="Trainer Audit")?"selected":"" ?>>Trainer Audit</option> 
                                                    <option value="QA Supervisor Audit"  <?= ($unacademy_activation_data['audit_type']=="QA Supervisor Audit")?"selected":"" ?>>QA Supervisor Audit</option> 
                                                </select>
										</td>
									</tr>
									<tr>
										<td class="auType_epi">Auditor Type<span style="font-size:24px;color:red">*</span></td>
											<td class="auType_epi">
												<select class="form-control form_unacademy" id="auditor_type" name="data[auditor_type]">
                                                    <option value="">Select</option>
                                                    <option value="Master" <?= ($unacademy_activation_data['auditor_type']=="Master")?"selected":"" ?>>Master</option>
                                                    <option value="Regular" <?= ($unacademy_activation_data['auditor_type']=="Regular")?"selected":"" ?>>Regular</option>
                                                </select>
											</td>
									</tr>

									<tr>
										<td style="font-weight:bold; font-size:14px; text-align:right">Earned Score:</td>
										<td><input type="text" readonly id="earnedScore" name="data[earned_score]" class="form-control form_unacademy" style="font-weight:bold" value="<?php echo $unacademy_activation_data['earned_score'] ?>"></td>
										<td style="font-weight:bold; font-size:14px; text-align:right">Possible<br>Score:</td>
										<td><input type="text" readonly id="possibleScore" name="data[possible_score]" class="form-control form_unacademy" style="font-weight:bold" value="<?php echo $unacademy_activation_data['possible_score'] ?>"></td>
										<td style="font-weight:bold; font-size:14px; text-align:right">Overall <br>Score:</td>
										<td><input type="text" readonly id="overallScore" name="data[overall_score]" class="form-control form_unacademy unacademy_Fatal" style="font-weight:bold" value="<?php echo $unacademy_activation_data['overall_score'] ?>"></td>
									</tr>
									
									<tr style="background-color:#85C1E9; font-weight:bold">
										<td>Parameter</td>
										<td>Sub Parameter</td>
										<td>Weightage</td>
										<td>Score</td>
										<td>Reason</td>
										<td>Remarks</td>
									</tr>
									<tr>
										<td rowspan=1 style="background-color:#85C1E9; font-weight:bold">Call Basics</td>
										<td>Call Opening</td>
										<td>5</td>
										<td>
											<select class="form-control form_unacademy unacademy" id="call_openning" name="data[call_openning]" disabled>
												<option unacademy_val=5 unacademy_max=5 <?php echo $unacademy_activation_data['call_openning'] == "Pass"?"selected":"";?> value="Pass">Pass</option>
												<option unacademy_val=0 unacademy_max=5 <?php echo $unacademy_activation_data['call_openning'] == "Fail"?"selected":"";?> value="Fail">Fail</option>
												<option unacademy_val=5 unacademy_max=5 <?php echo $unacademy_activation_data['call_openning'] == "NA"?"selected":"";?> value="NA">NA</option>
											</select>
										</td>
										
										<td>
											<select class="form-control form_unacademy unacademy_response" style="width: 200px;" id="call_openning_reason" name="data[cmt1]" disabled>
												<?php 
												if($unacademy_activation_data['cmt1']!=''){
													?>
													<option value="<?php echo $unacademy_activation_data['cmt1'] ?>"><?php echo $unacademy_activation_data['cmt1'] ?></option>
													<?php
												}
												?>
												<option  <?php echo $unacademy_activation_data['cmt1'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
												
											</select>
										</td>
										<td><textarea class="form-control form_unacademy" disabled name="data[remarks1]"><?php echo $unacademy_activation_data['remarks1'] ?></textarea></td>
									</tr>
									<tr>
										<td rowspan=1 style="background-color:#85C1E9; font-weight:bold">Profiling and Eligibility</td>
										<td>Effective Probing/Probed to profile<br>the learner/Check learners eligibility</td>
										<td>15</td>
										<td>
											<select class="form-control form_unacademy unacademy" id="effective_probing" name="data[effective_probing]" disabled>
												<option unacademy_val=15 unacademy_max=15 <?php echo $unacademy_activation_data['effective_probing'] == "Pass"?"selected":"";?> value="Pass">Pass</option>
												<option unacademy_val=0 unacademy_max=15 <?php echo $unacademy_activation_data['effective_probing'] == "Fail"?"selected":"";?> value="Fail">Fail</option>
												<option unacademy_val=15 unacademy_max=15 <?php echo $unacademy_activation_data['effective_probing'] == "NA"?"selected":"";?> value="NA">NA</option>
											</select>
										</td>
										
										<td>
											<select class="form-control form_unacademy unacademy_response" style="width: 200px;" id="effective_probing_reason" name="data[cmt2]" disabled>
												<?php 
												if($unacademy_activation_data['cmt2']!=''){
													?>
													<option value="<?php echo $unacademy_activation_data['cmt2'] ?>"><?php echo $unacademy_activation_data['cmt2'] ?></option>
													<?php
												}
												?>
												<option  <?php echo $unacademy_activation_data['cmt2'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
												
											</select>
										</td>
										<td><textarea class="form-control form_unacademy" disabled name="data[remarks2]"><?php echo $unacademy_activation_data['remarks2'] ?></textarea></td>
									</tr>
									<tr>
										<td rowspan=3 style="background-color:#85C1E9; font-weight:bold">Activation Pitch</td>
										<td>Explain Features and Benefits</td>
										<td>15</td>
										<td>
											<select class="form-control form_unacademy unacademy" id="features_benefits" name="data[features_benefits]" disabled>
												<option unacademy_val=15 unacademy_max=15 <?php echo $unacademy_activation_data['features_benefits'] == "Pass"?"selected":"";?> value="Pass">Pass</option>
												<option unacademy_val=0 unacademy_max=15 <?php echo $unacademy_activation_data['features_benefits'] == "Fail"?"selected":"";?> value="Fail">Fail</option>
												<option unacademy_val=15 unacademy_max=15 <?php echo $unacademy_activation_data['features_benefits'] == "NA"?"selected":"";?> value="NA">NA</option>
											</select>
										</td>
										
										<td>
											<select class="form-control form_unacademy unacademy_response" style="width: 200px;" id="features_benefits_reason" name="data[cmt3]" disabled>
												<?php 
												if($unacademy_activation_data['cmt3']!=''){
													?>
													<option value="<?php echo $unacademy_activation_data['cmt3'] ?>"><?php echo $unacademy_activation_data['cmt3'] ?></option>
													<?php
												}
												?>
												<option  <?php echo $unacademy_activation_data['cmt3'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
												
											</select>
										</td>
										<td><textarea class="form-control form_unacademy" disabled name="data[remarks3]"><?php echo $unacademy_activation_data['remarks3'] ?></textarea></td>
									</tr>
									<tr>
										<td style="color:red">Explain Educators Credibility</td>
										<td></td>
										<td>
											<select class="form-control form_unacademy unacademy fatal" id="unacademyAF1" name="data[educators_credibility]" disabled>
												<option unacademy_val=0 unacademy_max=0 <?php echo $unacademy_activation_data['educators_credibility'] == "Pass"?"selected":"";?> value="Pass">Pass</option>
												<option unacademy_val=0 unacademy_max=0 <?php echo $unacademy_activation_data['educators_credibility'] == "Fail"?"selected":"";?> value="Fail">Fail</option>
												<option unacademy_val=0 unacademy_max=0 <?php echo $unacademy_activation_data['educators_credibility'] == "NA"?"selected":"";?> value="NA">NA</option>
											</select>
										</td>
										
										<td>
											<select class="form-control form_unacademy unacademy_response" style="width: 200px;" id="educators_credibility_reason" name="data[cmt4]" disabled>
												<?php 
												if($unacademy_activation_data['cmt4']!=''){
													?>
													<option value="<?php echo $unacademy_activation_data['cmt4'] ?>"><?php echo $unacademy_activation_data['cmt4'] ?></option>
													<?php
												}
												?>
												<option  <?php echo $unacademy_activation_data['cmt4'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
												
											</select>
										</td>
										<td><textarea class="form-control form_unacademy" disabled name="data[remarks4]"><?php echo $unacademy_activation_data['remarks4'] ?></textarea></td>
									</tr>
									<tr>
										<td>Objection Handling/ Learner's Query</td>
										<td>5</td>
										<td>
											<select class="form-control form_unacademy unacademy" id="objection_handling" name="data[objection_handling]" disabled>
												<option unacademy_val=5 unacademy_max=5 <?php echo $unacademy_activation_data['objection_handling'] == "Pass"?"selected":"";?> value="Pass">Pass</option>
												<option unacademy_val=0 unacademy_max=5 <?php echo $unacademy_activation_data['objection_handling'] == "Fail"?"selected":"";?> value="Fail">Fail</option>
												<option unacademy_val=5 unacademy_max=5 <?php echo $unacademy_activation_data['objection_handling'] == "NA"?"selected":"";?> value="NA">NA</option>
											</select>
										</td>
										
										<td>
											<select class="form-control form_unacademy unacademy_response" style="width: 200px;" id="objection_handling_reason" name="data[cmt5]" disabled>
												<?php 
												if($unacademy_activation_data['cmt5']!=''){
													?>
													<option value="<?php echo $unacademy_activation_data['cmt5'] ?>"><?php echo $unacademy_activation_data['cmt5'] ?></option>
													<?php
												}
												?>
												<option  <?php echo $unacademy_activation_data['cmt5'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
												
											</select>
										</td>
										<td><textarea class="form-control form_unacademy" disabled name="data[remarks5]"><?php echo $unacademy_activation_data['remarks5'] ?></textarea></td>
									</tr>
									<tr>
										<td rowspan=7 style="background-color:#85C1E9; font-weight:bold">Communication skills</td>
										<td>PRCA - Pronunciation, Rate of Speech,<br> Clarity, Articulation, Grammar, Sentence<br> construction, Fumbling, Stammering, Casual words, Slang,<br> Fillers, Interruption</td>
										<td>5</td>
										<td>
											<select class="form-control form_unacademy unacademy" id="rate_of_speech" name="data[rate_of_speech]" disabled>
												<option unacademy_val=5 unacademy_max=5 <?php echo $unacademy_activation_data['rate_of_speech'] == "Pass"?"selected":"";?> value="Pass">Pass</option>
												<option unacademy_val=0 unacademy_max=5 <?php echo $unacademy_activation_data['rate_of_speech'] == "Fail"?"selected":"";?> value="Fail">Fail</option>
												<option unacademy_val=5 unacademy_max=5 <?php echo $unacademy_activation_data['rate_of_speech'] == "NA"?"selected":"";?> value="NA">NA</option>
											</select>
										</td>
										
										<td>
											<select class="form-control form_unacademy unacademy_response" style="width: 200px;" id="rate_of_speech_reason" name="data[cmt6]" disabled>
												<?php 
												if($unacademy_activation_data['cmt6']!=''){
													?>
													<option value="<?php echo $unacademy_activation_data['cmt6'] ?>"><?php echo $unacademy_activation_data['cmt6'] ?></option>
													<?php
												}
												?>
												<option  <?php echo $unacademy_activation_data['cmt6'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
												
											</select>
										</td>
										<td><textarea class="form-control form_unacademy" disabled name="data[remarks6]"><?php echo $unacademy_activation_data['remarks6'] ?></textarea></td>
									</tr>
									<tr>
										<td>Used empathy/Apology statements/Appreciate<br> when required as per call flow</td>
										<td>3</td>
										<td>
											<select class="form-control form_unacademy unacademy" id="empathy" name="data[empathy]" disabled>
												<option unacademy_val=3 unacademy_max=3 <?php echo $unacademy_activation_data['empathy'] == "Pass"?"selected":"";?> value="Pass">Pass</option>
												<option unacademy_val=0 unacademy_max=3 <?php echo $unacademy_activation_data['empathy'] == "Fail"?"selected":"";?> value="Fail">Fail</option>
												<option unacademy_val=3 unacademy_max=3 <?php echo $unacademy_activation_data['empathy'] == "NA"?"selected":"";?> value="NA">NA</option>
											</select>
										</td>
										
										<td>
											<select class="form-control form_unacademy unacademy_response" style="width: 200px;" id="empathy_reason" name="data[cmt7]" disabled>
												<?php 
												if($unacademy_activation_data['cmt7']!=''){
													?>
													<option value="<?php echo $unacademy_activation_data['cmt7'] ?>"><?php echo $unacademy_activation_data['cmt7'] ?></option>
													<?php
												}
												?>
												<option  <?php echo $unacademy_activation_data['cmt7'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
												
											</select>
										</td>
										<td><textarea class="form-control form_unacademy" disabled name="data[remarks7]"><?php echo $unacademy_activation_data['remarks7'] ?></textarea></td>
									</tr>
									<tr>
										<td>Hold/Dead air.</td>
										<td>2</td>
										<td>
											<select class="form-control form_unacademy unacademy" id="dead_air" name="data[dead_air]" disabled>
												<option unacademy_val=2 unacademy_max=2 <?php echo $unacademy_activation_data['dead_air'] == "Pass"?"selected":"";?> value="Pass">Pass</option>
												<option unacademy_val=0 unacademy_max=2 <?php echo $unacademy_activation_data['dead_air'] == "Fail"?"selected":"";?> value="Fail">Fail</option>
												<option unacademy_val=2 unacademy_max=2 <?php echo $unacademy_activation_data['dead_air'] == "NA"?"selected":"";?> value="NA">NA</option>
											</select>
										</td>
										
										<td>
											<select class="form-control form_unacademy unacademy_response" style="width: 200px;" id="dead_air_reason" name="data[cmt8]" disabled>
												<?php 
												if($unacademy_activation_data['cmt8']!=''){
													?>
													<option value="<?php echo $unacademy_activation_data['cmt8'] ?>"><?php echo $unacademy_activation_data['cmt8'] ?></option>
													<?php
												}
												?>
												<option  <?php echo $unacademy_activation_data['cmt8'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
												
											</select>
										</td>
										<td><textarea class="form-control form_unacademy" disabled name="data[remarks8]"><?php echo $unacademy_activation_data['remarks8'] ?></textarea></td>
									</tr>
									<tr>
										<td>Customer connect/building rapport/Enthusiastic</td>
										<td>10</td>
										<td>
											<select class="form-control form_unacademy unacademy" id="rapport" name="data[rapport]" disabled>
												<option unacademy_val=10 unacademy_max=10 <?php echo $unacademy_activation_data['rapport'] == "Pass"?"selected":"";?> value="Pass">Pass</option>
												<option unacademy_val=0 unacademy_max=10 <?php echo $unacademy_activation_data['rapport'] == "Fail"?"selected":"";?> value="Fail">Fail</option>
												<option unacademy_val=10 unacademy_max=10 <?php echo $unacademy_activation_data['rapport'] == "NA"?"selected":"";?> value="NA">NA</option>
											</select>
										</td>
										
										<td>
											<select class="form-control form_unacademy unacademy_response" style="width: 200px;" id="rapport_reason" name="data[cmt9]" disabled>
												<?php 
												if($unacademy_activation_data['cmt9']!=''){
													?>
													<option value="<?php echo $unacademy_activation_data['cmt9'] ?>"><?php echo $unacademy_activation_data['cmt9'] ?></option>
													<?php
												}
												?>
												<option  <?php echo $unacademy_activation_data['cmt9'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
												
											</select>
										</td>
										<td><textarea class="form-control form_unacademy" disabled name="data[remarks9]"><?php echo $unacademy_activation_data['remarks9'] ?></textarea></td>
									</tr>
									<tr>
										<td>Active listening /Understanding/Comprehension</td>
										<td>6</td>
										<td>
											<select class="form-control form_unacademy unacademy" id="active_listening" name="data[active_listening]" disabled>
												<option unacademy_val=6 unacademy_max=6 <?php echo $unacademy_activation_data['active_listening'] == "Pass"?"selected":"";?> value="Pass">Pass</option>
												<option unacademy_val=0 unacademy_max=6 <?php echo $unacademy_activation_data['active_listening'] == "Fail"?"selected":"";?> value="Fail">Fail</option>
												<option unacademy_val=6 unacademy_max=6 <?php echo $unacademy_activation_data['active_listening'] == "NA"?"selected":"";?> value="NA">NA</option>
											</select>
										</td>
										
										<td>
											<select class="form-control form_unacademy unacademy_response" style="width: 200px;" id="active_listening_reason" name="data[cmt10]" disabled>
												<?php 
												if($unacademy_activation_data['cmt10']!=''){
													?>
													<option value="<?php echo $unacademy_activation_data['cmt10'] ?>"><?php echo $unacademy_activation_data['cmt10'] ?></option>
													<?php
												}
												?>
												<option  <?php echo $unacademy_activation_data['cmt10'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
												
											</select>
										</td>
										<td><textarea class="form-control form_unacademy" disabled name="data[remarks10]"><?php echo $unacademy_activation_data['remarks10'] ?></textarea></td>
									</tr>
									<tr>
										<td>Switch Language as per the Learner convenience</td>
										<td>2</td>
										<td>
											<select class="form-control form_unacademy unacademy" id="switch_language" name="data[switch_language]" disabled>
												<option unacademy_val=2 unacademy_max=2 <?php echo $unacademy_activation_data['switch_language'] == "Pass"?"selected":"";?> value="Pass">Pass</option>
												<option unacademy_val=0 unacademy_max=2 <?php echo $unacademy_activation_data['switch_language'] == "Fail"?"selected":"";?> value="Fail">Fail</option>
												<option unacademy_val=2 unacademy_max=2 <?php echo $unacademy_activation_data['switch_language'] == "NA"?"selected":"";?> value="NA">NA</option>
											</select>
										</td>
										
										<td>
											<select class="form-control form_unacademy unacademy_response" style="width: 200px;" id="switch_language_reason" name="data[cmt11]" disabled>
												<?php 
												if($unacademy_activation_data['cmt11']!=''){
													?>
													<option value="<?php echo $unacademy_activation_data['cmt11'] ?>"><?php echo $unacademy_activation_data['cmt11'] ?></option>
													<?php
												}
												?>
												<option  <?php echo $unacademy_activation_data['cmt11'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
												
											</select>
										</td>
										<td><textarea class="form-control form_unacademy" disabled name="data[remarks11]"><?php echo $unacademy_activation_data['remarks11'] ?></textarea></td>
									</tr>
									<tr>
										<td>Usage of Jargons</td>
										<td>2</td>
										<td>
											<select class="form-control form_unacademy unacademy" id="used_Jargons" name="data[used_Jargons]" disabled>
												<option unacademy_val=2 unacademy_max=2 <?php echo $unacademy_activation_data['used_Jargons'] == "Pass"?"selected":"";?> value="Pass">Pass</option>
												<option unacademy_val=0 unacademy_max=2 <?php echo $unacademy_activation_data['used_Jargons'] == "Fail"?"selected":"";?> value="Fail">Fail</option>
												<option unacademy_val=2 unacademy_max=2 <?php echo $unacademy_activation_data['used_Jargons'] == "NA"?"selected":"";?> value="NA">NA</option>
											</select>
										</td>
										
										<td>
											<select class="form-control form_unacademy unacademy_response" style="width: 200px;" id="used_Jargons_reason" name="data[cmt12]" disabled>
												<?php 
												if($unacademy_activation_data['cmt12']!=''){
													?>
													<option value="<?php echo $unacademy_activation_data['cmt12'] ?>"><?php echo $unacademy_activation_data['cmt12'] ?></option>
													<?php
												}
												?>
												<option  <?php echo $unacademy_activation_data['cmt12'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
												
											</select>
										</td>
										<td><textarea class="form-control form_unacademy" disabled name="data[remarks12]"><?php echo $unacademy_activation_data['remarks12'] ?></textarea></td>
									</tr>
									<tr>
										<td rowspan=4 style="background-color:#85C1E9; font-weight:bold">Documentation</td>
										<td>Captured correct notes in LS</td>
										<td>5</td>
										<td>
											<select class="form-control form_unacademy unacademy" id="correct_notes" name="data[correct_notes]" disabled>
												<option unacademy_val=5 unacademy_max=5 <?php echo $unacademy_activation_data['correct_notes'] == "Pass"?"selected":"";?> value="Pass">Pass</option>
												<option unacademy_val=0 unacademy_max=5 <?php echo $unacademy_activation_data['correct_notes'] == "Fail"?"selected":"";?> value="Fail">Fail</option>
												<option unacademy_val=5 unacademy_max=5 <?php echo $unacademy_activation_data['correct_notes'] == "NA"?"selected":"";?> value="NA">NA</option>
											</select>
										</td>
										
										<td>
											<select class="form-control form_unacademy unacademy_response" style="width: 200px;" id="correct_notes_reason" name="data[cmt13]" disabled>
												<?php 
												if($unacademy_activation_data['cmt13']!=''){
													?>
													<option value="<?php echo $unacademy_activation_data['cmt13'] ?>"><?php echo $unacademy_activation_data['cmt13'] ?></option>
													<?php
												}
												?>
												<option  <?php echo $unacademy_activation_data['cmt13'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
												
											</select>
										</td>
										<td><textarea class="form-control form_unacademy" disabled name="data[remarks13]"><?php echo $unacademy_activation_data['remarks13'] ?></textarea></td>
									</tr>
									<tr>
										<td>Send relevant Email as per templates</td>
										<td>5</td>
										<td>
											<select class="form-control form_unacademy unacademy" id="relevant_email" name="data[relevant_email]" disabled>
												<option unacademy_val=5 unacademy_max=5 <?php echo $unacademy_activation_data['relevant_email'] == "Pass"?"selected":"";?> value="Pass">Pass</option>
												<option unacademy_val=0 unacademy_max=5 <?php echo $unacademy_activation_data['relevant_email'] == "Fail"?"selected":"";?> value="Fail">Fail</option>
												<option unacademy_val=5 unacademy_max=5 <?php echo $unacademy_activation_data['relevant_email'] == "NA"?"selected":"";?> value="NA">NA</option>
											</select>
										</td>
										
										<td>
											<select class="form-control form_unacademy unacademy_response" style="width: 200px;" id="relevant_email_reason" name="data[cmt14]" disabled>
												<?php 
												if($unacademy_activation_data['cmt14']!=''){
													?>
													<option value="<?php echo $unacademy_activation_data['cmt14'] ?>"><?php echo $unacademy_activation_data['cmt14'] ?></option>
													<?php
												}
												?>
												<option  <?php echo $unacademy_activation_data['cmt14'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
												
											</select>
										</td>
										<td><textarea class="form-control form_unacademy" disabled name="data[remarks14]"><?php echo $unacademy_activation_data['remarks14'] ?></textarea></td>
									</tr>
									<tr>
										<td>Follow up - Created/completed</td>
										<td>5</td>
										<td>
											<select class="form-control form_unacademy unacademy" id="follow_up" name="data[follow_up]" disabled>
												<option unacademy_val=5 unacademy_max=5 <?php echo $unacademy_activation_data['follow_up'] == "Pass"?"selected":"";?> value="Pass">Pass</option>
												<option unacademy_val=0 unacademy_max=5 <?php echo $unacademy_activation_data['follow_up'] == "Fail"?"selected":"";?> value="Fail">Fail</option>
												<option unacademy_val=5 unacademy_max=5 <?php echo $unacademy_activation_data['follow_up'] == "NA"?"selected":"";?> value="NA">NA</option>
											</select>
										</td>
										
										<td>
											<select class="form-control form_unacademy unacademy_response" style="width: 200px;" id="follow_up_reason" name="data[cmt15]" disabled>
												<?php 
												if($unacademy_activation_data['cmt15']!=''){
													?>
													<option value="<?php echo $unacademy_activation_data['cmt15'] ?>"><?php echo $unacademy_activation_data['cmt15'] ?></option>
													<?php
												}
												?>
												<option  <?php echo $unacademy_activation_data['cmt15'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
												
											</select>
										</td>
										<td><textarea class="form-control form_unacademy" disabled name="data[remarks15]"><?php echo $unacademy_activation_data['remarks15'] ?></textarea></td>
									</tr>
									<tr>
										<td>Correct lead stage selected as per call scenario</td>
										<td>5</td>
										<td>
											<select class="form-control form_unacademy unacademy" id="lead_stage" name="data[lead_stage]" disabled>
												<option unacademy_val=5 unacademy_max=5 <?php echo $unacademy_activation_data['lead_stage'] == "Pass"?"selected":"";?> value="Pass">Pass</option>
												<option unacademy_val=0 unacademy_max=5 <?php echo $unacademy_activation_data['lead_stage'] == "Fail"?"selected":"";?> value="Fail">Fail</option>
												<option unacademy_val=5 unacademy_max=5 <?php echo $unacademy_activation_data['lead_stage'] == "NA"?"selected":"";?> value="NA">NA</option>
											</select>
										</td>
										
										<td>
											<select class="form-control form_unacademy unacademy_response" style="width: 200px;" id="lead_stage_reason" name="data[cmt16]" disabled>
												<?php 
												if($unacademy_activation_data['cmt16']!=''){
													?>
													<option value="<?php echo $unacademy_activation_data['cmt16'] ?>"><?php echo $unacademy_activation_data['cmt16'] ?></option>
													<?php
												}
												?>
												<option  <?php echo $unacademy_activation_data['cmt16'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
												
											</select>
										</td>
										<td><textarea class="form-control form_unacademy" disabled name="data[remarks16]"><?php echo $unacademy_activation_data['remarks16'] ?></textarea></td>
									</tr>
									<tr>
										<td rowspan=8 style="background-color:#85C1E9; font-weight:bold">Compliance</td>
										<td style="color:red">Forcing/Begging about Website Navigation</td>
										<td></td>
										<td>
											<select class="form-control form_unacademy unacademy fatal" id="unacademyAF2" name="data[forcing_website_navigation]" disabled>
												<option unacademy_val=0 unacademy_max=0 <?php echo $unacademy_activation_data['forcing_website_navigation'] == "Pass"?"selected":"";?> value="Pass">Pass</option>
												<option unacademy_val=0 unacademy_max=0 <?php echo $unacademy_activation_data['forcing_website_navigation'] == "Fail"?"selected":"";?> value="Fail">Fail</option>
												<option unacademy_val=0 unacademy_max=0 <?php echo $unacademy_activation_data['forcing_website_navigation'] == "NA"?"selected":"";?> value="NA">NA</option>
											</select>
										</td>
										
										<td>
											<select class="form-control form_unacademy unacademy_response" style="width: 200px;" id="forcing_website_navigation_reason" name="data[cmt17]" disabled>
												<?php 
												if($unacademy_activation_data['cmt17']!=''){
													?>
													<option value="<?php echo $unacademy_activation_data['cmt17'] ?>"><?php echo $unacademy_activation_data['cmt17'] ?></option>
													<?php
												}
												?>
												<option  <?php echo $unacademy_activation_data['cmt17'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
												
											</select>
										</td>
										<td><textarea class="form-control form_unacademy" disabled name="data[remarks17]"><?php echo $unacademy_activation_data['remarks17'] ?></textarea></td>
									</tr>
									<tr>
										<td style="color:red">Abrupt call closing/Hangup on<br> learner/Inappropriate call closure/Mocking/<br>Scarstic/Abssive on the call/Rude</td>
										<td></td>
										<td>
											<select class="form-control form_unacademy unacademy fatal" id="unacademyAF3" name="data[call_hangup]" disabled>
												<option unacademy_val=0 unacademy_max=0 <?php echo $unacademy_activation_data['call_hangup'] == "Pass"?"selected":"";?> value="Pass">Pass</option>
												<option unacademy_val=0 unacademy_max=0 <?php echo $unacademy_activation_data['call_hangup'] == "Fail"?"selected":"";?> value="Fail">Fail</option>
												<option unacademy_val=0 unacademy_max=0 <?php echo $unacademy_activation_data['call_hangup'] == "NA"?"selected":"";?> value="NA">NA</option>
											</select>
										</td>
										
										<td>
											<select class="form-control form_unacademy unacademy_response" style="width: 200px;" id="call_hangup_reason" name="data[cmt18]" disabled>
												<?php 
												if($unacademy_activation_data['cmt18']!=''){
													?>
													<option value="<?php echo $unacademy_activation_data['cmt18'] ?>"><?php echo $unacademy_activation_data['cmt18'] ?></option>
													<?php
												}
												?>
												<option  <?php echo $unacademy_activation_data['cmt18'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
												
											</select>
										</td>
										<td><textarea class="form-control form_unacademy" disabled name="data[remarks18]"><?php echo $unacademy_activation_data['remarks18'] ?></textarea></td>
									</tr>
									<tr>
										<td style="color:red">Asking/Sharing personal number</td>
										<td></td>
										<td>
											<select class="form-control form_unacademy unacademy fatal" id="unacademyAF4" name="data[sharing_personal_number]" disabled>
												<option unacademy_val=0 unacademy_max=0 <?php echo $unacademy_activation_data['sharing_personal_number'] == "Pass"?"selected":"";?> value="Pass">Pass</option>
												<option unacademy_val=0 unacademy_max=0 <?php echo $unacademy_activation_data['sharing_personal_number'] == "Fail"?"selected":"";?> value="Fail">Fail</option>
												<option unacademy_val=0 unacademy_max=0 <?php echo $unacademy_activation_data['sharing_personal_number'] == "NA"?"selected":"";?> value="NA">NA</option>
											</select>
										</td>
										
										<td>
											<select class="form-control form_unacademy unacademy_response" style="width: 200px;" id="sharing_personal_number_reason" name="data[cmt19]" disabled>
												<?php 
												if($unacademy_activation_data['cmt19']!=''){
													?>
													<option value="<?php echo $unacademy_activation_data['cmt19'] ?>"><?php echo $unacademy_activation_data['cmt19'] ?></option>
													<?php
												}
												?>
												<option  <?php echo $unacademy_activation_data['cmt19'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
												
											</select>
										</td>
										<td><textarea class="form-control form_unacademy" disabled name="data[remarks19]"><?php echo $unacademy_activation_data['remarks19'] ?></textarea></td>
									</tr>
									<tr>
										<td style="color:red">Profiling Form</td>
										<td></td>
										<td>
											<select class="form-control form_unacademy unacademy fatal" id="unacademyAF5" name="data[profiling_form]" disabled>
												<option unacademy_val=0 unacademy_max=0 <?php echo $unacademy_activation_data['profiling_form'] == "Pass"?"selected":"";?> value="Pass">Pass</option>
												<option unacademy_val=0 unacademy_max=0 <?php echo $unacademy_activation_data['profiling_form'] == "Fail"?"selected":"";?> value="Fail">Fail</option>
												<option unacademy_val=0 unacademy_max=0 <?php echo $unacademy_activation_data['profiling_form'] == "NA"?"selected":"";?> value="NA">NA</option>
											</select>
										</td>
										
										<td>
											<select class="form-control form_unacademy unacademy_response" style="width: 200px;" id="profiling_form_reason" name="data[cmt20]" disabled>
												<?php 
												if($unacademy_activation_data['cmt20']!=''){
													?>
													<option value="<?php echo $unacademy_activation_data['cmt20'] ?>"><?php echo $unacademy_activation_data['cmt20'] ?></option>
													<?php
												}
												?>
												<option  <?php echo $unacademy_activation_data['cmt20'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
												
											</select>
										</td>
										<td><textarea class="form-control form_unacademy" disabled name="data[remarks20]"><?php echo $unacademy_activation_data['remarks20'] ?></textarea></td>
									</tr>
									<tr>
										<td style="color:red">Email etiquette - Upper case, Bold,<br> Highlighted Colors etc..</td>
										<td></td>
										<td>
											<select class="form-control form_unacademy unacademy fatal" id="unacademyAF6" name="data[email_etiquette]" disabled>
												<option unacademy_val=0 unacademy_max=0 <?php echo $unacademy_activation_data['email_etiquette'] == "Pass"?"selected":"";?> value="Pass">Pass</option>
												<option unacademy_val=0 unacademy_max=0 <?php echo $unacademy_activation_data['email_etiquette'] == "Fail"?"selected":"";?> value="Fail">Fail</option>
												<option unacademy_val=0 unacademy_max=0 <?php echo $unacademy_activation_data['email_etiquette'] == "NA"?"selected":"";?> value="NA">NA</option>
											</select>
										</td>
										
										<td>
											<select class="form-control form_unacademy unacademy_response" style="width: 200px;" id="email_etiquette_reason" name="data[cmt21]" disabled>
												<?php 
												if($unacademy_activation_data['cmt21']!=''){
													?>
													<option value="<?php echo $unacademy_activation_data['cmt21'] ?>"><?php echo $unacademy_activation_data['cmt21'] ?></option>
													<?php
												}
												?>
												<option  <?php echo $unacademy_activation_data['cmt21'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
												
											</select>
										</td>
										<td><textarea class="form-control form_unacademy" disabled name="data[remarks21]"><?php echo $unacademy_activation_data['remarks21'] ?></textarea></td>
									</tr>
									<tr>
										<td style="color:red">Talking ill about Unacademy &<br> its employees or policies that<br> impact either the learner or BDE</td>
										<td></td>
										<td>
											<select class="form-control form_unacademy unacademy fatal" id="unacademyAF7" name="data[talking_ill]" disabled>
												<option unacademy_val=0 unacademy_max=0 <?php echo $unacademy_activation_data['talking_ill'] == "Pass"?"selected":"";?> value="Pass">Pass</option>
												<option unacademy_val=0 unacademy_max=0 <?php echo $unacademy_activation_data['talking_ill'] == "Fail"?"selected":"";?> value="Fail">Fail</option>
												<option unacademy_val=0 unacademy_max=0 <?php echo $unacademy_activation_data['talking_ill'] == "NA"?"selected":"";?> value="NA">NA</option>
											</select>
										</td>
										
										<td>
											<select class="form-control form_unacademy unacademy_response" style="width: 200px;" id="talking_ill_reason" name="data[cmt22]" disabled>
												<?php 
												if($unacademy_activation_data['cmt22']!=''){
													?>
													<option value="<?php echo $unacademy_activation_data['cmt22'] ?>"><?php echo $unacademy_activation_data['cmt22'] ?></option>
													<?php
												}
												?>
												<option  <?php echo $unacademy_activation_data['cmt22'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
												
											</select>
										</td>
										<td><textarea class="form-control form_unacademy" disabled name="data[remarks22]"><?php echo $unacademy_activation_data['remarks22'] ?></textarea></td>
									</tr>
									<tr>
										<td style="color:red">Deliberate - Malpractice to increase<br>Productivity/Metrics - (Talktime, Total dials,<br> MIs activations etc..)</td>
										<td></td>
										<td>
											<select class="form-control form_unacademy unacademy fatal" id="unacademyAF8" name="data[deliberate_malpractice]" disabled>
												<option unacademy_val=0 unacademy_max=0 <?php echo $unacademy_activation_data['deliberate_malpractice'] == "Pass"?"selected":"";?> value="Pass">Pass</option>
												<option unacademy_val=0 unacademy_max=0 <?php echo $unacademy_activation_data['deliberate_malpractice'] == "Fail"?"selected":"";?> value="Fail">Fail</option>
												<option unacademy_val=0 unacademy_max=0 <?php echo $unacademy_activation_data['deliberate_malpractice'] == "NA"?"selected":"";?> value="NA">NA</option>
											</select>
										</td>
										
										<td>
											<select class="form-control form_unacademy unacademy_response" style="width: 200px;" id="deliberate_malpractice_reason" name="data[cmt23]" disabled>
												<?php 
												if($unacademy_activation_data['cmt23']!=''){
													?>
													<option value="<?php echo $unacademy_activation_data['cmt23'] ?>"><?php echo $unacademy_activation_data['cmt23'] ?></option>
													<?php
												}
												?>
												<option  <?php echo $unacademy_activation_data['cmt23'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
												
											</select>
										</td>
										<td><textarea class="form-control form_unacademy" disabled name="data[remarks23]"><?php echo $unacademy_activation_data['remarks23'] ?></textarea></td>
									</tr>
									<tr>
										<td style="color:red">Not responding to the learner<br> once the call is connected,<br> resulted in call drop by <br>learner / "side-talking" or speaking<br> to someone while the learner<br> is on the line.</td>
										<td></td>
										<td>
											<select class="form-control form_unacademy unacademy fatal" id="unacademyAF9" name="data[not_responding]" disabled>
												<option unacademy_val=0 unacademy_max=0 <?php echo $unacademy_activation_data['not_responding'] == "Pass"?"selected":"";?> value="Pass">Pass</option>
												<option unacademy_val=0 unacademy_max=0 <?php echo $unacademy_activation_data['not_responding'] == "Fail"?"selected":"";?> value="Fail">Fail</option>
												<option unacademy_val=0 unacademy_max=0 <?php echo $unacademy_activation_data['not_responding'] == "NA"?"selected":"";?> value="NA">NA</option>
											</select>
										</td>
										
										<td>
											<select class="form-control form_unacademy unacademy_response" style="width: 200px;" id="not_responding_reason" name="data[cmt24]" disabled>
												<?php 
												if($unacademy_activation_data['cmt24']!=''){
													?>
													<option value="<?php echo $unacademy_activation_data['cmt24'] ?>"><?php echo $unacademy_activation_data['cmt24'] ?></option>
													<?php
												}
												?>
												<option  <?php echo $unacademy_activation_data['cmt24'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
												
											</select>
										</td>
										<td><textarea class="form-control form_unacademy" disabled name="data[remarks24]"><?php echo $unacademy_activation_data['remarks24'] ?></textarea></td>
									</tr>
									<tr>
										<td rowspan=2 style="background-color:#85C1E9; font-weight:bold">Website Navgation</td>
										<td>Website Navigation</td>
										<td>5</td>
										<td>
											<select class="form-control form_unacademy unacademy" id="website_navigation" name="data[website_navigation]" disabled>
												<option unacademy_val=5 unacademy_max=5 <?php echo $unacademy_activation_data['website_navigation'] == "Pass"?"selected":"";?> value="Pass">Pass</option>
												<option unacademy_val=0 unacademy_max=5 <?php echo $unacademy_activation_data['website_navigation'] == "Fail"?"selected":"";?> value="Fail">Fail</option>
												<option unacademy_val=5 unacademy_max=5 <?php echo $unacademy_activation_data['website_navigation'] == "NA"?"selected":"";?> value="NA">NA</option>
											</select>
										</td>
										
										<td>
											<select class="form-control form_unacademy unacademy_response" style="width: 200px;" id="website_navigation_reason" name="data[cmt25]" disabled>
												<?php 
												if($unacademy_activation_data['cmt25']!=''){
													?>
													<option value="<?php echo $unacademy_activation_data['cmt25'] ?>"><?php echo $unacademy_activation_data['cmt25'] ?></option>
													<?php
												}
												?>
												<option  <?php echo $unacademy_activation_data['cmt25'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
												
											</select>
										</td>
										<td><textarea class="form-control form_unacademy" disabled name="data[remarks25]"><?php echo $unacademy_activation_data['remarks25'] ?></textarea></td>
									</tr>
									<tr>
										<td style="color:red">Explianing the Wrong Website navagation<br> Information</td>
										<td></td>
										<td>
											<select class="form-control form_unacademy unacademy fatal" id="unacademyAF10" name="data[wrong_website_navagation]" disabled>
												<option unacademy_val=0 unacademy_max=0 <?php echo $unacademy_activation_data['wrong_website_navagation'] == "Pass"?"selected":"";?> value="Pass">Pass</option>
												<option unacademy_val=0 unacademy_max=0 <?php echo $unacademy_activation_data['wrong_website_navagation'] == "Fail"?"selected":"";?> value="Fail">Fail</option>
												<option unacademy_val=0 unacademy_max=0 <?php echo $unacademy_activation_data['wrong_website_navagation'] == "NA"?"selected":"";?> value="NA">NA</option>
											</select>
										</td>
										
										<td>
											<select class="form-control form_unacademy unacademy_response" style="width: 200px;" id="wrong_website_navagation_reason" name="data[cmt26]" disabled>
												<?php 
												if($unacademy_activation_data['cmt26']!=''){
													?>
													<option value="<?php echo $unacademy_activation_data['cmt26'] ?>"><?php echo $unacademy_activation_data['cmt26'] ?></option>
													<?php
												}
												?>
												<option  <?php echo $unacademy_activation_data['cmt26'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
												
											</select>
										</td>
										<td><textarea class="form-control form_unacademy" disabled name="data[remarks26]"><?php echo $unacademy_activation_data['remarks26'] ?></textarea></td>
									</tr>
									<tr>
										<td rowspan=1 style="background-color:#85C1E9; font-weight:bold">Call Basics</td>
										<td>Call Closing</td>
										<td>5</td>
										<td>
											<select class="form-control form_unacademy unacademy" id="call_closing" name="data[call_closing]" disabled>
												<option unacademy_val=5 unacademy_max=5 <?php echo $unacademy_activation_data['call_closing'] == "Pass"?"selected":"";?> value="Pass">Pass</option>
												<option unacademy_val=0 unacademy_max=5 <?php echo $unacademy_activation_data['call_closing'] == "Fail"?"selected":"";?> value="Fail">Fail</option>
												<option unacademy_val=5 unacademy_max=5 <?php echo $unacademy_activation_data['call_closing'] == "NA"?"selected":"";?> value="NA">NA</option>
											</select>
										</td>
										
										<td>
											<select class="form-control form_unacademy unacademy_response" style="width: 200px;" id="call_closing_reason" name="data[cmt27]" disabled>
												<?php 
												if($unacademy_activation_data['cmt27']!=''){
													?>
													<option value="<?php echo $unacademy_activation_data['cmt27'] ?>"><?php echo $unacademy_activation_data['cmt27'] ?></option>
													<?php
												}
												?>
												<option  <?php echo $unacademy_activation_data['cmt27'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
												
											</select>
										</td>
										<td><textarea class="form-control form_unacademy" disabled name="data[remarks27]"><?php echo $unacademy_activation_data['remarks27'] ?></textarea></td>
									</tr>
									<tr>
										<td>Call Summary:</td>
										<td colspan=2><textarea class="form-control form_unacademy" disabled name="data[call_summary]"><?php echo $unacademy_activation_data['call_summary'] ?></textarea></td>
										<td>Feedback:</td>
										<td colspan=2><textarea class="form-control form_unacademy" disabled name="data[feedback]"><?php echo $unacademy_activation_data['feedback'] ?></textarea></td>
									</tr>
									<?php if($unacademy_activation_data['attach_file']!=''){ ?>
									<tr oncontextmenu="return false;">
										<td colspan="2">Audio Files (Mp4/Mp3/M4a/Wav)</td>
										<td colspan="4">
											<?php $attach_file = explode(",",$unacademy_activation_data['attach_file']);
											 foreach($attach_file as $af){ ?>
												<audio oncontextmenu="return false;" controls controlslist="nodownload" style="background-color:#607F93">
													  <source src="<?php echo base_url(); ?>qa_files/qa_unacademy/<?php echo $af; ?>" type="audio/ogg">
													  <source src="<?php echo base_url(); ?>qa_files/qa_unacademy/<?php echo $af; ?>" type="audio/mpeg">
												</audio> </br>
											 <?php } ?>
										</td>
									</tr>
									<?php } ?>

									<tr>
										<td style="font-size:12px">Manager Review:</td>
										<td colspan="8" style="text-align:left"><?php echo $unacademy_activation_data['mgnt_rvw_note'] ?></td>
									</tr>
									<tr>
										<td style="font-size:12px">Client Review:</td>
										<td colspan="8" style="text-align:left"><?php echo $unacademy_activation_data['client_rvw_note'] ?></td>
									</tr>

									<tr><td colspan="10" style="background-color:#C5C8C8"></td></tr>
									
									 <form id="form_agent_user" method="POST" action="">
										<input type="hidden" name="pnid" class="form-control" value="<?php echo $pnid; ?>">
										
										<tr>
											<td colspan=2 style="font-size:16px">Feedback Acceptance<span style="font-size:24px;color:red">*</span></td>
											<td colspan=6>
												<select class="form-control" id="" name="agnt_fd_acpt" required="">
													<option value="">--Select--</option>
													<option <?php echo $unacademy_activation_data['agnt_fd_acpt']=='Acceptance'?"selected":""; ?> value="Acceptance">Acceptance</option>	
													<option <?php echo $unacademy_activation_data['agnt_fd_acpt']=='Not Acceptance'?"selected":""; ?> value="Not Acceptance">Not Acceptance</option>	
												</select>
											</td>
										</tr>
										<tr>
											<td colspan=2 style="font-size:16px">Your Review <span style="font-size:24px;color:red">*</span></td>
											<td colspan=6><textarea class="form-control" name="note" required><?php echo $unacademy_activation_data['agent_rvw_note'] ?></textarea></td>
										</tr>
										
										<?php if(is_access_qa_agent_module()==true){
										if(is_available_qa_feedback($unacademy_activation_data['entry_date'],72) == true){ ?>
											<tr>
												<?php if($unacademy_activation_data['agent_rvw_note']==''){ ?>
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
