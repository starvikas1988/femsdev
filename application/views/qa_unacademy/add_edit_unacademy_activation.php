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

<?php if($unacademy_activation_id!=0){
if(is_access_qa_edit_feedback()==false){ ?>
	<style>
		.form_unacademy{
			pointer-events:none;
			background-color:#D5DBDB;
		}
		.select.unacademy_response {
		  width: 200px !important;
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
										<td colspan="6" id="theader" style="font-size:40px">Unacademy Activation Quality Form</td>
										<input type="hidden" name="audit_start_time" value="<?php echo CurrMySqlDate(); ?>">
									</tr>
									<?php
										if($unacademy_activation_id==0){
											$auditorName = get_username();
											$auditDate = CurrDateMDY();
											$clDate_val='';
											$clEndDate_val='';
										}else{
											if($unacademy_activation_data['entry_by']!=''){
												$auditorName = $unacademy_activation_data['auditor_name'];
											}else{
												$auditorName = $unacademy_activation_data['client_name'];
											}
											$auditDate = mysql2mmddyy($unacademy_activation_data['audit_date']);
											$clDate_val = mysql2mmddyy($unacademy_activation_data['call_date']);
											$clEndDate_val = mysql2mmddyy($unacademy_activation_data['call_end_date']);
										}
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
										<td><input type="text" class="form-control form_unacademy" name="data[email]" value="<?php echo $unacademy_activation_data['email'] ?>" required ></td>
										
									</tr>
									<tr>
										<td>Agent Name:<span style="font-size:24px;color:red">*</span></td>
										<td>
											<select class="form-control form_unacademy" id="agent_id" name="data[agent_id]" required>
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
												<input type="hidden" class="form-control form_unacademy" id="tl_id" name="data[tl_id]" value="<?php echo $tl_id; ?>" required>
										</td>
									</tr>
									<tr>
										<td>Call Start Date:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control form_unacademy"  id="call_date" name="call_date" value="<?php echo $clDate_val; ?>" required ></td>
										<td>Call End Date:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control form_unacademy" id="call_end_date" name="call_end_date" value="<?php echo $clEndDate_val; ?>" required></td>
										<td>Duration:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control" onkeydown="return false;" id="call_duration" name="data[call_duration]" value="<?php echo $call_duration; ?>" required></td>
									</tr>
									
									<tr>
										<td>Ticket/Audit ID:<span style="font-size:24px;color:red">*</span></td>
										<td>
											<input type="text" class="form-control form_unacademy" id="" name="data[ticket_id]" value="<?php echo $unacademy_activation_data['ticket_id'] ?>" required>
										</td>
										<td>VOC:<span style="font-size:24px;color:red">*</span></td>
											<td>
												<select class="form-control form_unacademy" id="voc" name="data[voc]" required>
													
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
											<input type="text" class="form-control form_unacademy" id="" name="data[bde_email]"  value="<?php echo $unacademy_activation_data['bde_email'] ?>" required>
										</td>
										
									</tr>
									<tr>
										<td>Time of Call:<span style="font-size:24px;color:red">*</span></td>
										<td>
											<input type="text" class="form-control form_unacademy" id="time_call_duration" onkeydown="return false;" name="data[time_of_call]" value="<?php echo $unacademy_activation_data['time_of_call'] ?>" required>
										</td>
										<td>Category:<span style="font-size:24px;color:red">*</span></td>
										<td>
											<input type="text" class="form-control form_unacademy" id="" name="data[category]" value="<?php echo $unacademy_activation_data['category'] ?>" required>
										</td>
										<td>KPI - ACPT:<span style="font-size:24px;color:red">*</span></td>
										<td>
											<select class="form-control form_unacademy" name="data[kpi_acpt]" required>
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
											<input type="text" class="form-control form_unacademy" id="" name="data[calls_audited_count]" value="<?php echo $unacademy_activation_data['calls_audited_count'] ?>" required>
										</td>
										<td>Lead URL:<span style="font-size:24px;color:red">*</span></td>
										<td>
											<input type="text" class="form-control form_unacademy" id="" name="data[lead_url]" value="<?php echo $unacademy_activation_data['lead_url'] ?>" required>
										</td>
										<td>Audit Type:<span style="font-size:24px;color:red">*</span></td>
										<td>
											<select class="form-control form_unacademy" id="audit_type" name="data[audit_type]" required>
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
											<select class="form-control form_unacademy unacademy" id="call_openning" name="data[call_openning]" required>
												<option unacademy_val=5 unacademy_max=5 <?php echo $unacademy_activation_data['call_openning'] == "Pass"?"selected":"";?> value="Pass">Pass</option>
												<option unacademy_val=0 unacademy_max=5 <?php echo $unacademy_activation_data['call_openning'] == "Fail"?"selected":"";?> value="Fail">Fail</option>
												<option unacademy_val=5 unacademy_max=5 <?php echo $unacademy_activation_data['call_openning'] == "NA"?"selected":"";?> value="NA">NA</option>
											</select>
										</td>
										
										<td>
											<select class="form-control form_unacademy unacademy_response" style="width: 200px;" id="call_openning_reason" name="data[cmt1]" required>
												<?php 
												if($unacademy_activation_data['cmt1']!='' && $unacademy_activation_data['cmt1']!='N/A'){
													?>
													<option  <?php echo $unacademy_activation_data['cmt1'] == "Greetings"?"selected":"";?> value="Greetings">Greetings</option>
													<option <?php echo $unacademy_activation_data['cmt1'] == "BDE Name"?"selected":"";?> value="BDE Name">BDE Name</option>
													<option <?php echo $unacademy_activation_data['cmt1'] == "Brand Name"?"selected":"";?> value="Brand Name">Brand Name</option>
													<option <?php echo $unacademy_activation_data['cmt1'] == "Confirmed Learners name"?"selected":"";?> value="Confirmed Learners name">Confirmed Learners name</option>
													<option <?php echo $unacademy_activation_data['cmt1'] == "Asked for RPC (Right party contact, Incase learners name was not clear on leadsquared)"?"selected":"";?> value="Asked for RPC (Right party contact, Incase learners name was not clear on leadsquared)">Asked for RPC (Right party contact, Incase learners name was not clear on leadsquared)</option>
													<option <?php echo $unacademy_activation_data['cmt1'] == "Informed right designation when asked by learner/parent"?"selected":"";?> value="Informed right designation when asked by learner/parent">Informed right designation when asked by learner/parent</option>
													<option <?php echo $unacademy_activation_data['cmt1'] == "Stated Purpose of the call"?"selected":"";?> value="Stated Purpose of the call">Stated Purpose of the call</option>
													<option <?php echo $unacademy_activation_data['cmt1'] == "Open the call within <3sec"?"selected":"";?> value="Open the call within <3sec">Open the call within <3sec</option>
													<?php
												}else{
													?>
													<option  <?php echo $unacademy_activation_data['cmt1'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
													<?php
												}
												?>
												
												
											</select>
										</td>
										<td><textarea class="form-control form_unacademy" name="data[remarks1]"><?php echo $unacademy_activation_data['remarks1'] ?></textarea></td>
									</tr>
									<tr>
										<td rowspan=1 style="background-color:#85C1E9; font-weight:bold">Profiling and Eligibility</td>
										<td>Effective Probing/Probed to profile<br>the learner/Check learners eligibility</td>
										<td>15</td>
										<td>
											<select class="form-control form_unacademy unacademy" id="effective_probing" name="data[effective_probing]" required>
												<option unacademy_val=15 unacademy_max=15 <?php echo $unacademy_activation_data['effective_probing'] == "Pass"?"selected":"";?> value="Pass">Pass</option>
												<option unacademy_val=0 unacademy_max=15 <?php echo $unacademy_activation_data['effective_probing'] == "Fail"?"selected":"";?> value="Fail">Fail</option>
												<option unacademy_val=15 unacademy_max=15 <?php echo $unacademy_activation_data['effective_probing'] == "NA"?"selected":"";?> value="NA">NA</option>
											</select>
										</td>
										
										<td>
											<select class="form-control form_unacademy unacademy_response" style="width: 200px;" id="effective_probing_reason" name="data[cmt2]" required>
												<?php 
												if($unacademy_activation_data['cmt2']!='' && $unacademy_activation_data['cmt2']!='N/A'){
													?>
													<option <?php echo $unacademy_activation_data['cmt2'] == "Effectively probed on Goal, Preparation status, Year of examination etc…"?"selected":"";?> value="Effectively probed on Goal, Preparation status, Year of examination etc…">Effectively probed on Goal, Preparation status, Year of examination etc…</option>
													<option <?php echo $unacademy_activation_data['cmt2'] == "Avoid unnecessary and incorrect probing. If the information goes wrong due to incorrect probing it should be a mark down."?"selected":"";?> value="Avoid unnecessary and incorrect probing. If the information goes wrong due to incorrect probing it should be a mark down.">Avoid unnecessary and incorrect probing. If the information goes wrong due to incorrect probing it should be a mark down.</option>

													<?php
												}else{
													?>
													<option  <?php echo $unacademy_activation_data['cmt2'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
													<?php
												}
												?>
												
												
											</select>
										</td>
										<td><textarea class="form-control form_unacademy" name="data[remarks2]"><?php echo $unacademy_activation_data['remarks2'] ?></textarea></td>
									</tr>
									<tr>
										<td rowspan=3 style="background-color:#85C1E9; font-weight:bold">Activation Pitch</td>
										<td>Explain Features and Benefits</td>
										<td>15</td>
										<td>
											<select class="form-control form_unacademy unacademy" id="features_benefits" name="data[features_benefits]" required>
												<option unacademy_val=15 unacademy_max=15 <?php echo $unacademy_activation_data['features_benefits'] == "Pass"?"selected":"";?> value="Pass">Pass</option>
												<option unacademy_val=0 unacademy_max=15 <?php echo $unacademy_activation_data['features_benefits'] == "Fail"?"selected":"";?> value="Fail">Fail</option>
												<option unacademy_val=15 unacademy_max=15 <?php echo $unacademy_activation_data['features_benefits'] == "NA"?"selected":"";?> value="NA">NA</option>
											</select>
										</td>
										
										<td>
											<select class="form-control form_unacademy unacademy_response" style="width: 200px;" id="features_benefits_reason" name="data[cmt3]" required>
												<?php 
												if($unacademy_activation_data['cmt3']!='' && $unacademy_activation_data['cmt3']!='N/A'){
													?>
													<option <?php echo $unacademy_activation_data['cmt3'] == "Effective Probing"?"selected":"";?> value="Effective Probing">Effective Probing</option>
													<option <?php echo $unacademy_activation_data['cmt3'] == "Probed to profile the learner"?"selected":"";?> value="Probed to profile the learner">Probed to profile the learner</option>
													<option <?php echo $unacademy_activation_data['cmt3'] == "Check learners eligibility"?"selected":"";?> value="Check learners eligibility">Check learners eligibility</option>
													<?php
												}else{
													?>
													<option  <?php echo $unacademy_activation_data['cmt3'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
													<?php
												}
												?>
												
												
											</select>
										</td>
										<td><textarea class="form-control form_unacademy" name="data[remarks3]"><?php echo $unacademy_activation_data['remarks3'] ?></textarea></td>
									</tr>
									<tr>
										<td style="color:red">Explain Educators Credibility</td>
										<td></td>
										<td>
											<select class="form-control form_unacademy unacademy fatal" id="unacademyAF1" name="data[educators_credibility]" required>
												<option unacademy_val=0 unacademy_max=0 <?php echo $unacademy_activation_data['educators_credibility'] == "Pass"?"selected":"";?> value="Pass">Pass</option>
												<option unacademy_val=0 unacademy_max=0 <?php echo $unacademy_activation_data['educators_credibility'] == "Fail"?"selected":"";?> value="Fail">Fail</option>
												<option unacademy_val=0 unacademy_max=0 <?php echo $unacademy_activation_data['educators_credibility'] == "NA"?"selected":"";?> value="NA">NA</option>
											</select>
										</td>
										
										<td>
											<select class="form-control form_unacademy unacademy_response" style="width: 200px;" id="educators_credibility_reason" name="data[cmt4]" required>
												<?php 
												if($unacademy_activation_data['cmt4']!='' && $unacademy_activation_data['cmt4']!='N/A'){
													?>
													<option <?php echo $unacademy_activation_data['cmt4'] == "Educator name with Subject"?"selected":"";?> value="Educator name with Subject">Educator name with Subject</option>
													<option <?php echo $unacademy_activation_data['cmt4'] == "Brief introduction-Accomplishment and milestones achieved"?"selected":"";?> value="Brief introduction-Accomplishment and milestones achieved">Brief introduction-Accomplishment and milestones achieved</option>
													<option <?php echo $unacademy_activation_data['cmt4'] == "Suggestion:-Refer Pitch Assist PAV2"?"selected":"";?> value="Suggestion:-Refer Pitch Assist PAV2">Suggestion:-Refer Pitch Assist PAV2</option>

													<?php
												}else{
													?>
													<option  <?php echo $unacademy_activation_data['cmt4'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
													<?php
												}
												?>
												
												
											</select>
										</td>
										<td><textarea class="form-control form_unacademy" name="data[remarks4]"><?php echo $unacademy_activation_data['remarks4'] ?></textarea></td>
									</tr>
									<tr>
										<td>Objection Handling/ Learner's Query</td>
										<td>5</td>
										<td>
											<select class="form-control form_unacademy unacademy" id="objection_handling" name="data[objection_handling]" required>
												<option unacademy_val=5 unacademy_max=5 <?php echo $unacademy_activation_data['objection_handling'] == "Pass"?"selected":"";?> value="Pass">Pass</option>
												<option unacademy_val=0 unacademy_max=5 <?php echo $unacademy_activation_data['objection_handling'] == "Fail"?"selected":"";?> value="Fail">Fail</option>
												<option unacademy_val=5 unacademy_max=5 <?php echo $unacademy_activation_data['objection_handling'] == "NA"?"selected":"";?> value="NA">NA</option>
											</select>
										</td>
										
										<td>
											<select class="form-control form_unacademy unacademy_response" style="width: 200px;" id="objection_handling_reason" name="data[cmt5]" required>
												<?php 
												if($unacademy_activation_data['cmt5']!='' && $unacademy_activation_data['cmt5']!='N/A'){
													?>
													<option <?php echo $unacademy_activation_data['cmt5'] == "Any questions raised by the learner should be answered by BD"?"selected":"";?> value="Any questions raised by the learner should be answered by BD">Any questions raised by the learner should be answered by BD</option>
													<option <?php echo $unacademy_activation_data['cmt5'] == "Accurate & complete info"?"selected":"";?> value="Accurate & complete info">Accurate & complete info</option>

													<?php
												}else{
													?>
													<option  <?php echo $unacademy_activation_data['cmt5'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
													<?php
												}
												?>
												
												
											</select>
										</td>
										<td><textarea class="form-control form_unacademy" name="data[remarks5]"><?php echo $unacademy_activation_data['remarks5'] ?></textarea></td>
									</tr>
									<tr>
										<td rowspan=7 style="background-color:#85C1E9; font-weight:bold">Communication skills</td>
										<td>PRCA - Pronunciation, Rate of Speech,<br> Clarity, Articulation, Grammar, Sentence<br> construction, Fumbling, Stammering, Casual words, Slang,<br> Fillers, Interruption</td>
										<td>5</td>
										<td>
											<select class="form-control form_unacademy unacademy" id="rate_of_speech" name="data[rate_of_speech]" required>
												<option unacademy_val=5 unacademy_max=5 <?php echo $unacademy_activation_data['rate_of_speech'] == "Pass"?"selected":"";?> value="Pass">Pass</option>
												<option unacademy_val=0 unacademy_max=5 <?php echo $unacademy_activation_data['rate_of_speech'] == "Fail"?"selected":"";?> value="Fail">Fail</option>
												<option unacademy_val=5 unacademy_max=5 <?php echo $unacademy_activation_data['rate_of_speech'] == "NA"?"selected":"";?> value="NA">NA</option>
											</select>
										</td>
										
										<td>
											<select class="form-control form_unacademy unacademy_response" style="width: 200px;" id="rate_of_speech_reason" name="data[cmt6]" required>
												<?php 
												if($unacademy_activation_data['cmt6']!='' && $unacademy_activation_data['cmt6']!='N/A'){
													?>
													<option <?php echo $unacademy_activation_data['cmt6'] == "1.Maintain proper tone"?"selected":"";?> value="1.Maintain proper tone">1.Maintain proper tone</option>
													<option <?php echo $unacademy_activation_data['cmt6'] == "2.pitch, volume and pace throughout the call."?"selected":"";?> value="2.pitch, volume and pace throughout the call.">2.pitch, volume and pace throughout the call.</option>

													<?php
												}else{
													?>
													<option  <?php echo $unacademy_activation_data['cmt6'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
													<?php
												}
												?>
												
												
											</select>
										</td>
										<td><textarea class="form-control form_unacademy" name="data[remarks6]"><?php echo $unacademy_activation_data['remarks6'] ?></textarea></td>
									</tr>
									<tr>
										<td>Used empathy/Apology statements/Appreciate<br> when required as per call flow</td>
										<td>3</td>
										<td>
											<select class="form-control form_unacademy unacademy" id="empathy" name="data[empathy]" required>
												<option unacademy_val=3 unacademy_max=3 <?php echo $unacademy_activation_data['empathy'] == "Pass"?"selected":"";?> value="Pass">Pass</option>
												<option unacademy_val=0 unacademy_max=3 <?php echo $unacademy_activation_data['empathy'] == "Fail"?"selected":"";?> value="Fail">Fail</option>
												<option unacademy_val=3 unacademy_max=3 <?php echo $unacademy_activation_data['empathy'] == "NA"?"selected":"";?> value="NA">NA</option>
											</select>
										</td>
										
										<td>
											<select class="form-control form_unacademy unacademy_response" style="width: 200px;" id="empathy_reason" name="data[cmt7]" required>
												<?php 
												if($unacademy_activation_data['cmt7']!='' && $unacademy_activation_data['cmt7']!='N/A'){
													?>
													<option <?php echo $unacademy_activation_data['cmt7'] == "Empathize, apologies & or appreciate as per call scenario."?"selected":"";?> value="Empathize, apologies & or appreciate as per call scenario.">Empathize, apologies & or appreciate as per call scenario.</option>
													
													<?php
												}else{
													?>
													<option  <?php echo $unacademy_activation_data['cmt7'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
													<?php
												}
												?>
												
												
											</select>
										</td>
										<td><textarea class="form-control form_unacademy" name="data[remarks7]"><?php echo $unacademy_activation_data['remarks7'] ?></textarea></td>
									</tr>
									<tr>
										<td>Hold/Dead air.</td>
										<td>2</td>
										<td>
											<select class="form-control form_unacademy unacademy" id="dead_air" name="data[dead_air]" required>
												<option unacademy_val=2 unacademy_max=2 <?php echo $unacademy_activation_data['dead_air'] == "Pass"?"selected":"";?> value="Pass">Pass</option>
												<option unacademy_val=0 unacademy_max=2 <?php echo $unacademy_activation_data['dead_air'] == "Fail"?"selected":"";?> value="Fail">Fail</option>
												<option unacademy_val=2 unacademy_max=2 <?php echo $unacademy_activation_data['dead_air'] == "NA"?"selected":"";?> value="NA">NA</option>
											</select>
										</td>
										
										<td>
											<select class="form-control form_unacademy unacademy_response" style="width: 200px;" id="dead_air_reason" name="data[cmt8]" required>
												<?php 
												if($unacademy_activation_data['cmt8']!='' && $unacademy_activation_data['cmt8']!='N/A'){
													?>
													<option <?php echo $unacademy_activation_data['cmt8'] == "BDE needs to seek permission before placing on hold & thank after releasing the hold. Dead air to be considered as if there is no voice more than 10 Sec"?"selected":"";?> value="BDE needs to seek permission before placing on hold & thank after releasing the hold. Dead air to be considered as if there is no voice more than 10 Sec">BDE needs to seek permission before placing on hold & thank after releasing the hold. Dead air to be considered as if there is no voice more than 10 Sec</option>
													
													<?php
												}else{
													?>
													<option  <?php echo $unacademy_activation_data['cmt8'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
													<?php
												}
												?>
												
												
											</select>
										</td>
										<td><textarea class="form-control form_unacademy" name="data[remarks8]"><?php echo $unacademy_activation_data['remarks8'] ?></textarea></td>
									</tr>
									<tr>
										<td>Customer connect/building rapport/Enthusiastic</td>
										<td>10</td>
										<td>
											<select class="form-control form_unacademy unacademy" id="rapport" name="data[rapport]" required>
												<option unacademy_val=10 unacademy_max=10 <?php echo $unacademy_activation_data['rapport'] == "Pass"?"selected":"";?> value="Pass">Pass</option>
												<option unacademy_val=0 unacademy_max=10 <?php echo $unacademy_activation_data['rapport'] == "Fail"?"selected":"";?> value="Fail">Fail</option>
												<option unacademy_val=10 unacademy_max=10 <?php echo $unacademy_activation_data['rapport'] == "NA"?"selected":"";?> value="NA">NA</option>
											</select>
										</td>
										
										<td>
											<select class="form-control form_unacademy unacademy_response" style="width: 200px;" id="rapport_reason" name="data[cmt9]" required>
												<?php 
												if($unacademy_activation_data['cmt9']!='' && $unacademy_activation_data['cmt9']!='N/A'){
													?>
													<option <?php echo $unacademy_activation_data['cmt9'] == "BDE needs to build rapport & sound enthusiastic throughout the call."?"selected":"";?> value="BDE needs to build rapport & sound enthusiastic throughout the call.">BDE needs to build rapport & sound enthusiastic throughout the call.</option>
													<option <?php echo $unacademy_activation_data['cmt9'] == "Did the BDE showcase the benefits to suit the learner"?"selected":"";?> value="Did the BDE showcase the benefits to suit the learner">Did the BDE showcase the benefits to suit the learner</option>

													<?php
												}else{
													?>
													<option  <?php echo $unacademy_activation_data['cmt9'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
													<?php
												}
												?>
												
												
											</select>
										</td>
										<td><textarea class="form-control form_unacademy" name="data[remarks9]"><?php echo $unacademy_activation_data['remarks9'] ?></textarea></td>
									</tr>
									<tr>
										<td>Active listening /Understanding/Comprehension</td>
										<td>6</td>
										<td>
											<select class="form-control form_unacademy unacademy" id="active_listening" name="data[active_listening]" required>
												<option unacademy_val=6 unacademy_max=6 <?php echo $unacademy_activation_data['active_listening'] == "Pass"?"selected":"";?> value="Pass">Pass</option>
												<option unacademy_val=0 unacademy_max=6 <?php echo $unacademy_activation_data['active_listening'] == "Fail"?"selected":"";?> value="Fail">Fail</option>
												<option unacademy_val=6 unacademy_max=6 <?php echo $unacademy_activation_data['active_listening'] == "NA"?"selected":"";?> value="NA">NA</option>
											</select>
										</td>
										
										<td>
											<select class="form-control form_unacademy unacademy_response" style="width: 200px;" id="active_listening_reason" name="data[cmt10]" required>
												<?php 
												if($unacademy_activation_data['cmt10']!='' && $unacademy_activation_data['cmt10']!='N/A'){
													?>
													<option <?php echo $unacademy_activation_data['cmt10'] == "Need active listening & understanding of learners requirement"?"selected":"";?> value="Need active listening & understanding of learners requirement">Need active listening & understanding of learners requirement</option>
													
													<?php
												}else{
													?>
													<option  <?php echo $unacademy_activation_data['cmt10'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
													<?php
												}
												?>
												
												
											</select>
										</td>
										<td><textarea class="form-control form_unacademy" name="data[remarks10]"><?php echo $unacademy_activation_data['remarks10'] ?></textarea></td>
									</tr>
									<tr>
										<td>Switch Language as per the Learner convenience</td>
										<td>2</td>
										<td>
											<select class="form-control form_unacademy unacademy" id="switch_language" name="data[switch_language]" required>
												<option unacademy_val=2 unacademy_max=2 <?php echo $unacademy_activation_data['switch_language'] == "Pass"?"selected":"";?> value="Pass">Pass</option>
												<option unacademy_val=0 unacademy_max=2 <?php echo $unacademy_activation_data['switch_language'] == "Fail"?"selected":"";?> value="Fail">Fail</option>
												<option unacademy_val=2 unacademy_max=2 <?php echo $unacademy_activation_data['switch_language'] == "NA"?"selected":"";?> value="NA">NA</option>
											</select>
										</td>
										
										<td>
											<select class="form-control form_unacademy unacademy_response" style="width: 200px;" id="switch_language_reason" name="data[cmt11]" required>
												<?php 
												if($unacademy_activation_data['cmt11']!='' && $unacademy_activation_data['cmt11']!='N/A'){
													?>
													<option <?php echo $unacademy_activation_data['cmt11'] == "Switch language as per the Learner convenience"?"selected":"";?> value="Switch language as per the Learner convenience">Switch language as per the Learner convenience</option>
													
													<?php
												}else{
													?>
													<option  <?php echo $unacademy_activation_data['cmt11'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
													<?php
												}
												?>
												
												
											</select>
										</td>
										<td><textarea class="form-control form_unacademy" name="data[remarks11]"><?php echo $unacademy_activation_data['remarks11'] ?></textarea></td>
									</tr>
									<tr>
										<td>Usage of Jargons</td>
										<td>2</td>
										<td>
											<select class="form-control form_unacademy unacademy" id="used_Jargons" name="data[used_Jargons]" required>
												<option unacademy_val=2 unacademy_max=2 <?php echo $unacademy_activation_data['used_Jargons'] == "Pass"?"selected":"";?> value="Pass">Pass</option>
												<option unacademy_val=0 unacademy_max=2 <?php echo $unacademy_activation_data['used_Jargons'] == "Fail"?"selected":"";?> value="Fail">Fail</option>
												<option unacademy_val=2 unacademy_max=2 <?php echo $unacademy_activation_data['used_Jargons'] == "NA"?"selected":"";?> value="NA">NA</option>
											</select>
										</td>
										
										<td>
											<select class="form-control form_unacademy unacademy_response" style="width: 200px;" id="used_Jargons_reason" name="data[cmt12]" required>
												<?php 
												if($unacademy_activation_data['cmt12']!='' && $unacademy_activation_data['cmt12']!='N/A'){
													?>
													<option <?php echo $unacademy_activation_data['cmt12'] == "Avoid LS"?"selected":"";?> value="Avoid LS">Avoid LS</option>
													<option <?php echo $unacademy_activation_data['cmt12'] == "Avoid sales pitch"?"selected":"";?> value="Avoid sales pitch">Avoid sales pitch</option>
													<option <?php echo $unacademy_activation_data['cmt12'] == "Avoid Feedback,PA-V2"?"selected":"";?> value="Avoid Feedback,PA-V2">Avoid Feedback,PA-V2</option>

													<?php
												}else{
													?>
													<option  <?php echo $unacademy_activation_data['cmt12'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
													<?php
												}
												?>
												
												
											</select>
										</td>
										<td><textarea class="form-control form_unacademy" name="data[remarks12]"><?php echo $unacademy_activation_data['remarks12'] ?></textarea></td>
									</tr>
									<tr>
										<td rowspan=4 style="background-color:#85C1E9; font-weight:bold">Documentation</td>
										<td>Captured correct notes in LS</td>
										<td>5</td>
										<td>
											<select class="form-control form_unacademy unacademy" id="correct_notes" name="data[correct_notes]" required>
												<option unacademy_val=5 unacademy_max=5 <?php echo $unacademy_activation_data['correct_notes'] == "Pass"?"selected":"";?> value="Pass">Pass</option>
												<option unacademy_val=0 unacademy_max=5 <?php echo $unacademy_activation_data['correct_notes'] == "Fail"?"selected":"";?> value="Fail">Fail</option>
												<option unacademy_val=5 unacademy_max=5 <?php echo $unacademy_activation_data['correct_notes'] == "NA"?"selected":"";?> value="NA">NA</option>
											</select>
										</td>
										
										<td>
											<select class="form-control form_unacademy unacademy_response" style="width: 200px;" id="correct_notes_reason" name="data[cmt13]" required>
												<?php 
												if($unacademy_activation_data['cmt13']!='' && $unacademy_activation_data['cmt13']!='N/A'){
													?>
													<option <?php echo $unacademy_activation_data['cmt13'] == "Complete & accurate notes to be captured in notes"?"selected":"";?> value="Complete & accurate notes to be captured in notes">Complete & accurate notes to be captured in notes</option>
													<?php
												}else{
													?>
													<option  <?php echo $unacademy_activation_data['cmt13'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
													<?php
												}
												?>
												
												
											</select>
										</td>
										<td><textarea class="form-control form_unacademy" name="data[remarks13]"><?php echo $unacademy_activation_data['remarks13'] ?></textarea></td>
									</tr>
									<tr>
										<td>Send relevant Email as per templates</td>
										<td>5</td>
										<td>
											<select class="form-control form_unacademy unacademy" id="relevant_email" name="data[relevant_email]" required>
												<option unacademy_val=5 unacademy_max=5 <?php echo $unacademy_activation_data['relevant_email'] == "Pass"?"selected":"";?> value="Pass">Pass</option>
												<option unacademy_val=0 unacademy_max=5 <?php echo $unacademy_activation_data['relevant_email'] == "Fail"?"selected":"";?> value="Fail">Fail</option>
												<option unacademy_val=5 unacademy_max=5 <?php echo $unacademy_activation_data['relevant_email'] == "NA"?"selected":"";?> value="NA">NA</option>
											</select>
										</td>
										
										<td>
											<select class="form-control form_unacademy unacademy_response" style="width: 200px;" id="relevant_email_reason" name="data[cmt14]" required>
												<?php 
												if($unacademy_activation_data['cmt14']!='' && $unacademy_activation_data['cmt14']!='N/A'){
													?>
													<option <?php echo $unacademy_activation_data['cmt14'] == "Confirm email ID of learner before sending email"?"selected":"";?> value="Confirm email ID of learner before sending email">Confirm email ID of learner before sending email</option>
													
													<?php
												}else{
													?>
													<option  <?php echo $unacademy_activation_data['cmt14'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
													<?php
												}
												?>
												
												
											</select>
										</td>
										<td><textarea class="form-control form_unacademy" name="data[remarks14]"><?php echo $unacademy_activation_data['remarks14'] ?></textarea></td>
									</tr>
									<tr>
										<td>Follow up - Created/completed</td>
										<td>5</td>
										<td>
											<select class="form-control form_unacademy unacademy" id="follow_up" name="data[follow_up]" required>
												<option unacademy_val=5 unacademy_max=5 <?php echo $unacademy_activation_data['follow_up'] == "Pass"?"selected":"";?> value="Pass">Pass</option>
												<option unacademy_val=0 unacademy_max=5 <?php echo $unacademy_activation_data['follow_up'] == "Fail"?"selected":"";?> value="Fail">Fail</option>
												<option unacademy_val=5 unacademy_max=5 <?php echo $unacademy_activation_data['follow_up'] == "NA"?"selected":"";?> value="NA">NA</option>
											</select>
										</td>
										
										<td>
											<select class="form-control form_unacademy unacademy_response" style="width: 200px;" id="follow_up_reason" name="data[cmt15]" required>
												<?php 
												if($unacademy_activation_data['cmt15']!='' && $unacademy_activation_data['cmt15']!='N/A'){
													?>
													<option <?php echo $unacademy_activation_data['cmt15'] == "While creating follow up in activity tab, select date (Call Back Date)"?"selected":"";?> value="While creating follow up in activity tab, select date (Call Back Date)">While creating follow up in activity tab, select date (Call Back Date)</option>
													
													<?php
												}else{
													?>
													<option  <?php echo $unacademy_activation_data['cmt15'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
													<?php
												}
												?>
												
												
											</select>
										</td>
										<td><textarea class="form-control form_unacademy" name="data[remarks15]"><?php echo $unacademy_activation_data['remarks15'] ?></textarea></td>
									</tr>
									<tr>
										<td>Correct lead stage selected as per call scenario</td>
										<td>5</td>
										<td>
											<select class="form-control form_unacademy unacademy" id="lead_stage" name="data[lead_stage]" required>
												<option unacademy_val=5 unacademy_max=5 <?php echo $unacademy_activation_data['lead_stage'] == "Pass"?"selected":"";?> value="Pass">Pass</option>
												<option unacademy_val=0 unacademy_max=5 <?php echo $unacademy_activation_data['lead_stage'] == "Fail"?"selected":"";?> value="Fail">Fail</option>
												<option unacademy_val=5 unacademy_max=5 <?php echo $unacademy_activation_data['lead_stage'] == "NA"?"selected":"";?> value="NA">NA</option>
											</select>
										</td>
										
										<td>
											<select class="form-control form_unacademy unacademy_response" style="width: 200px;" id="lead_stage_reason" name="data[cmt16]" required>
												<?php 
												if($unacademy_activation_data['cmt16']!='' && $unacademy_activation_data['cmt16']!='N/A'){
													?>
													<option <?php echo $unacademy_activation_data['cmt16'] == "Lead stage selection must be accurate basis call conversation"?"selected":"";?> value="Lead stage selection must be accurate basis call conversation">Lead stage selection must be accurate basis call conversation</option>
													
													<?php
												}else{
													?>
													<option  <?php echo $unacademy_activation_data['cmt16'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
													<?php
												}
												?>
											</select>
										</td>
										<td><textarea class="form-control form_unacademy" name="data[remarks16]"><?php echo $unacademy_activation_data['remarks16'] ?></textarea></td>
									</tr>
									<tr>
										<td rowspan=8 style="background-color:#85C1E9; font-weight:bold">Compliance</td>
										<td style="color:red">Forcing/Begging about Website Navigation</td>
										<td></td>
										<td>
											<select class="form-control form_unacademy unacademy fatal" id="unacademyAF2" name="data[forcing_website_navigation]" required>
												<option unacademy_val=0 unacademy_max=0 <?php echo $unacademy_activation_data['forcing_website_navigation'] == "Pass"?"selected":"";?> value="Pass">Pass</option>
												<option unacademy_val=0 unacademy_max=0 <?php echo $unacademy_activation_data['forcing_website_navigation'] == "Fail"?"selected":"";?> value="Fail">Fail</option>
												<option unacademy_val=0 unacademy_max=0 <?php echo $unacademy_activation_data['forcing_website_navigation'] == "NA"?"selected":"";?> value="NA">NA</option>
											</select>
										</td>
										
										<td>
											<select class="form-control form_unacademy unacademy_response" style="width: 200px;" id="forcing_website_navigation_reason" name="data[cmt17]" required>
												<?php 
												if($unacademy_activation_data['cmt17']!='' && $unacademy_activation_data['cmt17']!='N/A'){
													?>
													<option <?php echo $unacademy_activation_data['cmt17'] == "BDE forcing/begging on the call"?"selected":"";?> value="BDE forcing/begging on the call">BDE forcing/begging on the call</option>
													
													<?php
												}else{
													?>
													<option  <?php echo $unacademy_activation_data['cmt17'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
													<?php
												}
												?>
												
												
											</select>
										</td>
										<td><textarea class="form-control form_unacademy" name="data[remarks17]"><?php echo $unacademy_activation_data['remarks17'] ?></textarea></td>
									</tr>
									<tr>
										<td style="color:red">Abrupt call closing/Hangup on<br> learner/Inappropriate call closure/Mocking/<br>Scarstic/Abssive on the call/Rude</td>
										<td></td>
										<td>
											<select class="form-control form_unacademy unacademy fatal" id="unacademyAF3" name="data[call_hangup]" required>
												<option unacademy_val=0 unacademy_max=0 <?php echo $unacademy_activation_data['call_hangup'] == "Pass"?"selected":"";?> value="Pass">Pass</option>
												<option unacademy_val=0 unacademy_max=0 <?php echo $unacademy_activation_data['call_hangup'] == "Fail"?"selected":"";?> value="Fail">Fail</option>
												<option unacademy_val=0 unacademy_max=0 <?php echo $unacademy_activation_data['call_hangup'] == "NA"?"selected":"";?> value="NA">NA</option>
											</select>
										</td>
										
										<td>
											<select class="form-control form_unacademy unacademy_response" style="width: 200px;" id="call_hangup_reason" name="data[cmt18]" required>
												<?php 
												if($unacademy_activation_data['cmt18']!='' && $unacademy_activation_data['cmt18']!='N/A'){
													?>
													<option <?php echo $unacademy_activation_data['cmt18'] == "BDE should not hang the call between the conversation. Appropriate call closure to be done.BD should not sound rude, sarcastic or be abusive on call"?"selected":"";?> value="BDE should not hang the call between the conversation. Appropriate call closure to be done.BD should not sound rude, sarcastic or be abusive on call">BDE should not hang the call between the conversation. Appropriate call closure to be done.BD should not sound rude, sarcastic or be abusive on call</option>
													
													<?php
												}else{
													?>
													<option  <?php echo $unacademy_activation_data['cmt18'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
													<?php
												}
												?>
												
												
											</select>
										</td>
										<td><textarea class="form-control form_unacademy" name="data[remarks18]"><?php echo $unacademy_activation_data['remarks18'] ?></textarea></td>
									</tr>
									<tr>
										<td style="color:red">Asking/Sharing personal number</td>
										<td></td>
										<td>
											<select class="form-control form_unacademy unacademy fatal" id="unacademyAF4" name="data[sharing_personal_number]" required>
												<option unacademy_val=0 unacademy_max=0 <?php echo $unacademy_activation_data['sharing_personal_number'] == "Pass"?"selected":"";?> value="Pass">Pass</option>
												<option unacademy_val=0 unacademy_max=0 <?php echo $unacademy_activation_data['sharing_personal_number'] == "Fail"?"selected":"";?> value="Fail">Fail</option>
												<option unacademy_val=0 unacademy_max=0 <?php echo $unacademy_activation_data['sharing_personal_number'] == "NA"?"selected":"";?> value="NA">NA</option>
											</select>
										</td>
										
										<td>
											<select class="form-control form_unacademy unacademy_response" style="width: 200px;" id="sharing_personal_number_reason" name="data[cmt19]" required>
												<?php 
												if($unacademy_activation_data['cmt19']!='' && $unacademy_activation_data['cmt19']!='N/A'){
													?>
													<option <?php echo $unacademy_activation_data['cmt19'] == "No personal numbers to be shared or asked"?"selected":"";?> value="No personal numbers to be shared or asked">No personal numbers to be shared or asked</option>
													
													<?php
												}else{
													?>
													<option  <?php echo $unacademy_activation_data['cmt19'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
													<?php
												}
												?>
												
												
											</select>
										</td>
										<td><textarea class="form-control form_unacademy" name="data[remarks19]"><?php echo $unacademy_activation_data['remarks19'] ?></textarea></td>
									</tr>
									<tr>
										<td style="color:red">Profiling Form</td>
										<td></td>
										<td>
											<select class="form-control form_unacademy unacademy fatal" id="unacademyAF5" name="data[profiling_form]" required>
												<option unacademy_val=0 unacademy_max=0 <?php echo $unacademy_activation_data['profiling_form'] == "Pass"?"selected":"";?> value="Pass">Pass</option>
												<option unacademy_val=0 unacademy_max=0 <?php echo $unacademy_activation_data['profiling_form'] == "Fail"?"selected":"";?> value="Fail">Fail</option>
												<option unacademy_val=0 unacademy_max=0 <?php echo $unacademy_activation_data['profiling_form'] == "NA"?"selected":"";?> value="NA">NA</option>
											</select>
										</td>
										
										<td>
											<select class="form-control form_unacademy unacademy_response" style="width: 200px;" id="profiling_form_reason" name="data[cmt20]" required>
												<?php 
												if($unacademy_activation_data['cmt20']!='' && $unacademy_activation_data['cmt20']!='N/A'){
													?>
													<option <?php echo $unacademy_activation_data['cmt20'] == "Filling up the profiling Form"?"selected":"";?> value="Filling up the profiling Form">Filling up the profiling Form</option>
													
													<?php
												}else{
													?>
													<option  <?php echo $unacademy_activation_data['cmt20'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
													<?php
												}
												?>
												
												
											</select>
										</td>
										<td><textarea class="form-control form_unacademy" name="data[remarks20]"><?php echo $unacademy_activation_data['remarks20'] ?></textarea></td>
									</tr>
									<tr>
										<td style="color:red">Email etiquette - Upper case, Bold,<br> Highlighted Colors etc..</td>
										<td></td>
										<td>
											<select class="form-control form_unacademy unacademy fatal" id="unacademyAF6" name="data[email_etiquette]" required>
												<option unacademy_val=0 unacademy_max=0 <?php echo $unacademy_activation_data['email_etiquette'] == "Pass"?"selected":"";?> value="Pass">Pass</option>
												<option unacademy_val=0 unacademy_max=0 <?php echo $unacademy_activation_data['email_etiquette'] == "Fail"?"selected":"";?> value="Fail">Fail</option>
												<option unacademy_val=0 unacademy_max=0 <?php echo $unacademy_activation_data['email_etiquette'] == "NA"?"selected":"";?> value="NA">NA</option>
											</select>
										</td>
										
										<td>
											<select class="form-control form_unacademy unacademy_response" style="width: 200px;" id="email_etiquette_reason" name="data[cmt21]" required>
												<?php 
												if($unacademy_activation_data['cmt21']!='' && $unacademy_activation_data['cmt21']!='N/A'){
													?>
													<option <?php echo $unacademy_activation_data['cmt21'] == "Approved email templates only to be used. Batch details only can be edited. Highlighted colors, bold nothing to be used."?"selected":"";?> value="Approved email templates only to be used. Batch details only can be edited. Highlighted colors, bold nothing to be used.">Approved email templates only to be used. Batch details only can be edited. Highlighted colors, bold nothing to be used.</option>
													
													<?php
												}else{
													?>
													<option  <?php echo $unacademy_activation_data['cmt21'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
													<?php
												}
												?>
												
												
											</select>
										</td>
										<td><textarea class="form-control form_unacademy" name="data[remarks21]"><?php echo $unacademy_activation_data['remarks21'] ?></textarea></td>
									</tr>
									<tr>
										<td style="color:red">Talking ill about Unacademy &<br> its employees or policies that<br> impact either the learner or BDE</td>
										<td></td>
										<td>
											<select class="form-control form_unacademy unacademy fatal" id="unacademyAF7" name="data[talking_ill]" required>
												<option unacademy_val=0 unacademy_max=0 <?php echo $unacademy_activation_data['talking_ill'] == "Pass"?"selected":"";?> value="Pass">Pass</option>
												<option unacademy_val=0 unacademy_max=0 <?php echo $unacademy_activation_data['talking_ill'] == "Fail"?"selected":"";?> value="Fail">Fail</option>
												<option unacademy_val=0 unacademy_max=0 <?php echo $unacademy_activation_data['talking_ill'] == "NA"?"selected":"";?> value="NA">NA</option>
											</select>
										</td>
										
										<td>
											<select class="form-control form_unacademy unacademy_response" style="width: 200px;" id="talking_ill_reason" name="data[cmt22]" required>
												<?php 
												if($unacademy_activation_data['cmt22']!='' && $unacademy_activation_data['cmt22']!='N/A'){
													?>
													<option <?php echo $unacademy_activation_data['cmt22'] == "Talking bad about the Unacademy"?"selected":"";?> value="Talking bad about the Unacademy">Talking bad about the Unacademy</option>
													
													<?php
												}else{
													?>
													<option  <?php echo $unacademy_activation_data['cmt22'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
													<?php
												}
												?>
												
												
											</select>
										</td>
										<td><textarea class="form-control form_unacademy" name="data[remarks22]"><?php echo $unacademy_activation_data['remarks22'] ?></textarea></td>
									</tr>
									<tr>
										<td style="color:red">Deliberate - Malpractice to increase<br>Productivity/Metrics - (Talktime, Total dials,<br> MIs activations etc..)</td>
										<td></td>
										<td>
											<select class="form-control form_unacademy unacademy fatal" id="unacademyAF8" name="data[deliberate_malpractice]" required>
												<option unacademy_val=0 unacademy_max=0 <?php echo $unacademy_activation_data['deliberate_malpractice'] == "Pass"?"selected":"";?> value="Pass">Pass</option>
												<option unacademy_val=0 unacademy_max=0 <?php echo $unacademy_activation_data['deliberate_malpractice'] == "Fail"?"selected":"";?> value="Fail">Fail</option>
												<option unacademy_val=0 unacademy_max=0 <?php echo $unacademy_activation_data['deliberate_malpractice'] == "NA"?"selected":"";?> value="NA">NA</option>
											</select>
										</td>
										
										<td>
											<select class="form-control form_unacademy unacademy_response" style="width: 200px;" id="deliberate_malpractice_reason" name="data[cmt23]" required>
												<?php 
												if($unacademy_activation_data['cmt23']!='' && $unacademy_activation_data['cmt23']!='N/A'){
													?>
													<option <?php echo $unacademy_activation_data['cmt23'] == "Not responding to the learner once the call is connected, resulted in call drop by learner / side-talking or speaking to someone while the learner is on the line."?"selected":"";?> value="Not responding to the learner once the call is connected, resulted in call drop by learner / side-talking or speaking to someone while the learner is on the line.">Not responding to the learner once the call is connected, resulted in call drop by learner / side-talking or speaking to someone while the learner is on the line.</option>
													
													<?php
												}else{
													?>
													<option  <?php echo $unacademy_activation_data['cmt23'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
													<?php
												}
												?>
												
												
											</select>
										</td>
										<td><textarea class="form-control form_unacademy" name="data[remarks23]"><?php echo $unacademy_activation_data['remarks23'] ?></textarea></td>
									</tr>
									<tr>
										<td style="color:red">Not responding to the learner<br> once the call is connected,<br> resulted in call drop by <br>learner / "side-talking" or speaking<br> to someone while the learner<br> is on the line.</td>
										<td></td>
										<td>
											<select class="form-control form_unacademy unacademy fatal" id="unacademyAF9" name="data[not_responding]" required>
												<option unacademy_val=0 unacademy_max=0 <?php echo $unacademy_activation_data['not_responding'] == "Pass"?"selected":"";?> value="Pass">Pass</option>
												<option unacademy_val=0 unacademy_max=0 <?php echo $unacademy_activation_data['not_responding'] == "Fail"?"selected":"";?> value="Fail">Fail</option>
												<option unacademy_val=0 unacademy_max=0 <?php echo $unacademy_activation_data['not_responding'] == "NA"?"selected":"";?> value="NA">NA</option>
											</select>
										</td>
										
										<td>
											<select class="form-control form_unacademy unacademy_response" style="width: 200px;" id="not_responding_reason" name="data[cmt24]" required>
												<?php 
												if($unacademy_activation_data['cmt24']!='' && $unacademy_activation_data['cmt24']!='N/A'){
													?>
													<option <?php echo $unacademy_activation_data['cmt24'] == "If the call connected and the BDE is not responding to the learner having side talk and resluted to call drop/ waiting of learner on call"?"selected":"";?> value="If the call connected and the BDE is not responding to the learner having side talk and resluted to call drop/ waiting of learner on call">If the call connected and the BDE is not responding to the learner having side talk and resluted to call drop/ waiting of learner on call</option>
													
													<?php
												}else{
													?>
													<option  <?php echo $unacademy_activation_data['cmt24'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
													<?php
												}
												?>
												
												
											</select>
										</td>
										<td><textarea class="form-control form_unacademy" name="data[remarks24]"><?php echo $unacademy_activation_data['remarks24'] ?></textarea></td>
									</tr>
									<tr>
										<td rowspan=2 style="background-color:#85C1E9; font-weight:bold">Website Navgation</td>
										<td>Website Navigation</td>
										<td>5</td>
										<td>
											<select class="form-control form_unacademy unacademy" id="website_navigation" name="data[website_navigation]" required>
												<option unacademy_val=5 unacademy_max=5 <?php echo $unacademy_activation_data['website_navigation'] == "Pass"?"selected":"";?> value="Pass">Pass</option>
												<option unacademy_val=0 unacademy_max=5 <?php echo $unacademy_activation_data['website_navigation'] == "Fail"?"selected":"";?> value="Fail">Fail</option>
												<option unacademy_val=5 unacademy_max=5 <?php echo $unacademy_activation_data['website_navigation'] == "NA"?"selected":"";?> value="NA">NA</option>
											</select>
										</td>
										
										<td>
											<select class="form-control form_unacademy unacademy_response" style="width: 200px;" id="website_navigation_reason" name="data[cmt25]" required>
												<?php 
												if($unacademy_activation_data['cmt25']!='' && $unacademy_activation_data['cmt25']!='N/A'){
													?>
													<option <?php echo $unacademy_activation_data['cmt25'] == "Asking learners to come on the website/app to take through for navigations.1.Free classes 2.Mock and test Series 3.Combat"?"selected":"";?> value="Asking learners to come on the website/app to take through for navigations.1.Free classes 2.Mock and test Series 3.Combat">Asking learners to come on the website/app to take through for navigations.1.Free classes 2.Mock and test Series 3.Combat</option>
													
													<?php
												}else{
													?>
													<option  <?php echo $unacademy_activation_data['cmt25'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
													<?php
												}
												?>
												
												
											</select>
										</td>
										<td><textarea class="form-control form_unacademy" name="data[remarks25]"><?php echo $unacademy_activation_data['remarks25'] ?></textarea></td>
									</tr>
									<tr>
										<td style="color:red">Explianing the Wrong Website navagation<br> Information</td>
										<td></td>
										<td>
											<select class="form-control form_unacademy unacademy fatal" id="unacademyAF10" name="data[wrong_website_navagation]" required>
												<option unacademy_val=0 unacademy_max=0 <?php echo $unacademy_activation_data['wrong_website_navagation'] == "Pass"?"selected":"";?> value="Pass">Pass</option>
												<option unacademy_val=0 unacademy_max=0 <?php echo $unacademy_activation_data['wrong_website_navagation'] == "Fail"?"selected":"";?> value="Fail">Fail</option>
												<option unacademy_val=0 unacademy_max=0 <?php echo $unacademy_activation_data['wrong_website_navagation'] == "NA"?"selected":"";?> value="NA">NA</option>
											</select>
										</td>
										
										<td>
											<select class="form-control form_unacademy unacademy_response" style="width: 200px;" id="wrong_website_navagation_reason" name="data[cmt26]" required>
												<?php 
												if($unacademy_activation_data['cmt26']!='' && $unacademy_activation_data['cmt26']!='N/A'){
													?>
													<option <?php echo $unacademy_activation_data['cmt26'] == "Wrong Website navagation"?"selected":"";?> value="Wrong Website navagation">Wrong Website navagation</option>
													
													<?php
												}else{
													?>
													<option  <?php echo $unacademy_activation_data['cmt26'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
													<?php
												}
												?>
												
												
											</select>
										</td>
										<td><textarea class="form-control form_unacademy" name="data[remarks26]"><?php echo $unacademy_activation_data['remarks26'] ?></textarea></td>
									</tr>
									<tr>
										<td rowspan=1 style="background-color:#85C1E9; font-weight:bold">Call Basics</td>
										<td>Call Closing</td>
										<td>5</td>
										<td>
											<select class="form-control form_unacademy unacademy" id="call_closing" name="data[call_closing]" required>
												<option unacademy_val=5 unacademy_max=5 <?php echo $unacademy_activation_data['call_closing'] == "Pass"?"selected":"";?> value="Pass">Pass</option>
												<option unacademy_val=0 unacademy_max=5 <?php echo $unacademy_activation_data['call_closing'] == "Fail"?"selected":"";?> value="Fail">Fail</option>
												<option unacademy_val=5 unacademy_max=5 <?php echo $unacademy_activation_data['call_closing'] == "NA"?"selected":"";?> value="NA">NA</option>
											</select>
										</td>
										
										<td>
											<select class="form-control form_unacademy unacademy_response" style="width: 200px;" id="call_closing_reason" name="data[cmt27]" required>
												<?php 
												if($unacademy_activation_data['cmt27']!='' && $unacademy_activation_data['cmt27']!='N/A'){
													?>
													<option <?php echo $unacademy_activation_data['cmt27'] == "Thanking and Greeting the leanrer BDE Name Brand Name Note- It is expected that the BDE has already sumarrized on the call, if its not done in this scenario Call Closing will be a merk down despte of having a Thanking and Greeting"?"selected":"";?> value="Thanking and Greeting the leanrer BDE Name Brand Name Note- It is expected that the BDE has already sumarrized on the call, if its not done in this scenario Call Closing will be a merk down despte of having a Thanking and Greeting">Thanking and Greeting the leanrer BDE Name Brand Name Note- It is expected that the BDE has already sumarrized on the call, if its not done in this scenario Call Closing will be a merk down despte of having a Thanking and Greeting</option>
													
													<?php
												}else{
													?>
													<option  <?php echo $unacademy_activation_data['cmt27'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
													<?php
												}
												?>
												
												
											</select>
										</td>
										<td><textarea class="form-control form_unacademy" name="data[remarks27]"><?php echo $unacademy_activation_data['remarks27'] ?></textarea></td>
									</tr>
									<tr>
										<td>Call Summary:</td>
										<td colspan=2><textarea class="form-control form_unacademy" name="data[call_summary]"><?php echo $unacademy_activation_data['call_summary'] ?></textarea></td>
										<td>Feedback:</td>
										<td colspan=2><textarea class="form-control form_unacademy" name="data[feedback]"><?php echo $unacademy_activation_data['feedback'] ?></textarea></td>
									</tr>
									<tr>
										<td colspan=2>Upload Files [m4a,mp4,mp3,wav]</td>
											<?php if ($unacademy_activation_id == 0) { ?>
												<td colspan=6>
													<input type="file" name="attach_file[]" id="attach_file" accept=".m4a,.mp4,.mp3,.wav,audio/*" />
												</td>
												<?php } else {
												if ($unacademy_activation_data['attach_file'] != '') { ?>
													<td colspan=6>
														<input type="file" multiple class="form-control form_unacademy"  id="attach_file" name="attach_file[]" accept=".m4a,.mp4,.mp3,.wav,audio/*"> 
														<?php $attach_file = explode(",", $unacademy_activation_data['attach_file']);
														foreach ($attach_file as $mp) { ?>
															<audio controls='' style="background-color:#607F93">
																<source src="<?php echo base_url(); ?>qa_files/qa_unacademy/<?php echo $mp; ?>" type="audio/ogg">
																<source src="<?php echo base_url(); ?>qa_files/qa_unacademy/<?php echo $mp; ?>" type="audio/mpeg">
															</audio> </br>
														<?php } ?>
													</td>
											<?php } else {
													echo '<td colspan=6>
													<input type="file" multiple class="form-control form_unacademy" id="attach_file" name="attach_file[]" accept=".m4a,.mp4,.mp3,.wav,audio/*">
													<b>No Files</b></td>';
												}
											} ?>
										</tr>
									
									<?php if($unacademy_activation_id!=0){ ?>
										<tr><td colspan=2 style="font-size:16px; font-weight:bold">Agent Feedback Acceptance:</td><td colspan=4><?php echo $unacademy_activation_data['agnt_fd_acpt'] ?></td></tr>
										<tr><td colspan=2 style="font-size:16px; font-weight:bold">Agent Review:</td><td colspan=4><?php echo $unacademy_activation_data['agent_rvw_note'] ?></td></tr>
										<tr><td colspan=2 style="font-size:16px; font-weight:bold">Management Review:</td><td colspan=4><?php echo $unacademy_activation_data['mgnt_rvw_note'] ?></td></tr>
										<tr><td colspan=2 style="font-size:16px; font-weight:bold">Client Review:</td><td colspan=4><?php echo $unacademy_activation_data['client_rvw_note'] ?></td></tr>
										
										<tr><td colspan=2  style="font-size:16px">Your Review <span style="font-size:24px;color:red">*</span></td><td colspan=4><textarea class="form-control form_unacademy1" style="width:100%" id="note" required name="note"  ></textarea></td></tr>
									<?php } ?>
									
									<?php 
									if($unacademy_activation_id==0){
										if(is_access_qa_module()==true || is_access_qa_operations_module()==true){ ?>
											<tr><td colspan=6><button class="btn btn-success waves-effect" type="submit" id="qaformsubmit" style="width:500px">SAVE</button></td></tr>
									<?php 
										} 
									}else{ 
										if(is_access_qa_module()==true || is_access_qa_operations_module()==true){
											if(is_available_qa_feedback($unacademy_activation_data['entry_date'],72) == true){ ?>
												<tr><td colspan="6"><button class="btn btn-success waves-effect" type="submit" id='qaformsubmit' name='btnSave' value="SAVE" style="width:500px">SAVE</button></td></tr>
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
