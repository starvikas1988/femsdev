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
.eml5{
	font-weight:bold;
	background-color:#ee9090;
}
.ui-datepicker .ui-datepicker-buttonpane button.ui-datepicker-current {
	 float: left;
	 display: none;
	}

</style>

<?php if ($romtech_inbound_id != 0) {
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
											<td colspan="8" id="theader" style="font-size:40px">Romtech Inbound</td>
											<input type="hidden" name="audit_start_time" value="<?php echo CurrMySqlDate(); ?>">
										</tr>
										<?php
										if ($romtech_inbound_id == 0) {
											$auditorName = get_username();
											//$auditDate = CurrDateMDY();
											$auditDate =  CurrDateTimeMDY();
											$clDate_val = '';
										} else {
											if ($romtech_inbound_data['entry_by'] != '') {
												$auditorName = $romtech_inbound_data['auditor_name'];
											} else {
												$auditorName = $romtech_inbound_data['client_name'];
											}
											$clDate_val = mysql2mmddyySls($romtech_inbound_data['call_date']);
										}
										if ($rand_id != 0) {
											$agent_id = $rand_data['sid'];
											$fusion_id = $rand_data['fusion_id'];
											$agent_name = $rand_data['fname'] . " " . $rand_data['lname'];
											$tl_id = $rand_data['assigned_to'];
											$tl_name = $rand_data['tl_name'];
											$call_duration = $rand_data['call_duration'];
											
										} else {
											$agent_id = $romtech_inbound_data['agent_id'];
											$fusion_id = $romtech_inbound_data['fusion_id'];
											$agent_name = $romtech_inbound_data['fname'] . " " . $romtech_inbound_data['lname'] ;
											$tl_id = $romtech_inbound_data['tl_id'];
											$tl_name = $romtech_inbound_data['tl_name'];
											$call_duration = $romtech_inbound_data['call_duration'];
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
												<!-- <select class="form-control" id="agent_id" name="data[agent_id]" required>
													<?php 
													if($romtech_inbound_data['agent_id']!=''){
														?>
														<option value="<?php echo $romtech_inbound_data['agent_id'] ?>"><?php echo $romtech_inbound_data['fname'] . " " . $romtech_inbound_data['lname'] ?></option>
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
												</select> -->
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
											<td>Employee ID:</td>
											<td colspan="2"><input type="text" class="form-control" id="fusion_id" required value="<?php echo $fusion_id; ?>" readonly></td>
											<td> L1 Supervisor:<span style="font-size:24px;color:red">*</span></td>
											<td>
												<input type="text" class="form-control" id="tl_name"  value="<?php echo $tl_name; ?>" readonly>
												<input type="hidden" class="form-control" id="tl_id" name="data[tl_id]" value="<?php echo $tl_id; ?>" required>
											</td>
										</tr>
										<tr>
											<td>File/Call ID:<span style="font-size:24px;color:red">*</span></td>
											<td>
												<input type="text" id="call_id" name="data[call_id]"  value="<?php echo $romtech_inbound_data['call_id']; ?>" class="form-control" required>
											</td>
											<td>Call Duration:<span style="font-size:24px;color:red">*</span></td>
											<td colspan="2"><input type="text" class="form-control" onkeydown="return false;" id="call_duration" name="data[call_duration]" value="<?php echo $call_duration; ?>" required></td>
											<td>ACPT<span style="font-size:24px;color:red">*</span></td>
											<td>
												<select class="form-control" name="data[acpt]" required>
													<option value="">-Select-</option>
                                                    <option value="Agent"  <?= ($romtech_inbound_data['acpt']=="Agent")?"selected":"" ?>>Agent</option>
                                                    <option value="Process"  <?= ($romtech_inbound_data['acpt']=="Process")?"selected":"" ?>>Process</option>
                                                    <option value="Customer"  <?= ($romtech_inbound_data['acpt']=="Customer")?"selected":"" ?>>Customer</option>
                                                    <option value="Technology"  <?= ($romtech_inbound_data['acpt']=="Technology")?"selected":"" ?>>Technology</option>
                                                    <option value="NA"  <?= ($romtech_inbound_data['acpt']=="NA")?"selected":"" ?>>NA</option>
                                                </select>
											</td>
										</tr>
										<tr>
											<td>VOC:<span style="font-size:24px;color:red">*</span></td>
											<td>
												<select class="form-control" id="voc" name="data[voc]" required>
													
													<option value="">-Select-</option>
													<option value="1"  <?= ($romtech_inbound_data['voc']=="1")?"selected":"" ?>>1</option>
													<option value="2"  <?= ($romtech_inbound_data['voc']=="2")?"selected":"" ?>>2</option>
													<option value="3"  <?= ($romtech_inbound_data['voc']=="3")?"selected":"" ?>>3</option>
													<option value="4"  <?= ($romtech_inbound_data['voc']=="4")?"selected":"" ?>>4</option>
													<option value="5"  <?= ($romtech_inbound_data['voc']=="5")?"selected":"" ?>>5</option>
													<option value="6"  <?= ($romtech_inbound_data['voc']=="6")?"selected":"" ?>>6</option>
													<option value="7"  <?= ($romtech_inbound_data['voc']=="7")?"selected":"" ?>>7</option>
													<option value="8"  <?= ($romtech_inbound_data['voc']=="8")?"selected":"" ?>>8</option>
													<option value="9"  <?= ($romtech_inbound_data['voc']=="9")?"selected":"" ?>>9</option>
													<option value="10"  <?= ($romtech_inbound_data['voc']=="10")?"selected":"" ?>>10</option>
												</select>
											</td>
											<td>Phone Number:<span style="font-size:24px;color:red">*</span></td>
											<td colspan="2"><input type="text" class="form-control" id="phone" name="data[phone]" onkeyup="checkDec(this);" value="<?php echo $romtech_inbound_data['phone'] ?>" required>
											<span id="start_phone" style="color:red"></span></td> 
											<td>L1:<span style="font-size:24px;color:red">*</span></td>
											<td>
												<input type="text" id="" name="data[L1]"  value="<?php echo $romtech_inbound_data['L1']; ?>" class="form-control" required>
											</td>
										</tr>
										<tr>
											<td>L2:<span style="font-size:24px;color:red">*</span></td>
											<td>
												<input type="text" id="" name="data[L2]"  value="<?php echo $romtech_inbound_data['L2']; ?>" class="form-control" required>
											</td>	
											<td>Audit Type:<span style="font-size:24px;color:red">*</span></td>
											<td colspan="2">
												<select class="form-control" id="audit_type" name="data[audit_type]" required>
                                                    <option value="">-Select-</option>
                                                    <option value="CQ Audit" <?= ($romtech_inbound_data['audit_type']=="CQ Audit")?"selected":"" ?>>CQ Audit</option>
                                                    <option value="BQ Audit" <?= ($romtech_inbound_data['audit_type']=="BQ Audit")?"selected":"" ?>>BQ Audit</option>
                                                    <option value="Calibration" <?= ($romtech_inbound_data['audit_type']=="Calibration")?"selected":"" ?>>Calibration</option>
                                                    <option value="Pre-Certificate Mock Call" <?= ($romtech_inbound_data['audit_type']=="Pre-Certificate Mock Call")?"selected":"" ?>>Pre-Certificate Mock Call</option>
                                                    <option value="Certification Audit" <?= ($romtech_inbound_data['audit_type']=="Certification Audit")?"selected":"" ?>>Certification Audit</option>
                                                    <option value="Operation Audit" <?= ($romtech_inbound_data['audit_type']=="Operation Audit")?"selected":"" ?>>Operation Audit</option>
                                                    <option value="Trainer Audit"  <?= ($romtech_inbound_data['audit_type']=="Trainer Audit")?"selected":"" ?>>Trainer Audit</option>
                                                    <option value="WOW Call" <?= ($romtech_inbound_data['audit_type']=="WOW Call")?"selected":"" ?>>WOW Call</option>
                                                    <option value="Hygiene Audit" <?= ($romtech_inbound_data['audit_type']=="Hygiene Audit")?"selected":"" ?>>Hygiene Audit</option>
                                                    <option value="QA Supervisor Audit" <?= ($romtech_inbound_data['audit_type']=="QA Supervisor Audit")?"selected":"" ?>>QA Supervisor Audit</option>
                                                </select>
											</td>
											<td class="auType">Auditor Type<span style="font-size:24px;color:red">*</span></td>
											<td class="auType">
												<select class="form-control" id="auditor_type" name="data[auditor_type]">
                                                    <option>Select</option>
                                                    <option value="Master" <?= ($romtech_inbound_data['auditor_type']=="Master")?"selected":"" ?>>Master</option>
                                                    <option value="Regular" <?= ($romtech_inbound_data['auditor_type']=="Regular")?"selected":"" ?>>Regular</option>
                                                </select>
											</td>
										</tr>
										
										<tr>
											<td style="font-weight:bold; font-size:16px; text-align:left">Earned Score</td>
											<td><input type="text" readonly id="romtech_inbound_earned_score" name="data[earned_score]" class="form-control" value="<?php echo $romtech_inbound_data['earned_score'] ?>" /></td>
											<td style="font-weight:bold; font-size:16px; text-align:left">Possible Score</td>
											<td colspan="2"><input type="text" readonly id="romtech_inbound_possible_score" name="data[possible_score]" class="form-control" value="<?php echo $romtech_inbound_data['possible_score'] ?>" /></td>
											<td style="font-weight:bold; font-size:16px; text-align:right">Overall Score:</td>
											<td><input type="text" readonly id="romtech_inbound_overall_score" name="data[overall_score]" class="form-control romtech_inboundFatal" style="font-weight:bold" value="<?php echo $romtech_inbound_data['overall_score'] ?>"></td>
										</tr>
										<tr class="eml" style="height:25px; font-weight:bold">
											<td>Critical Accuracy</td>
											<td colspan=2>PARAMETER</td>
											<td>Weightage</td>
											<td>STATUS</td>
											<td colspan=2>REMARKS</td>
										</tr>

										<tr>
											<td class="eml" rowspan=2 style="font-weight:bold; background-color:#d6bf91">Business Critical</td>
											<td rowspan=3 style="font-weight:bold; background-color:#ee9090">Opening</td>
											<td colspan=2>Greeting-Used standard ROMTech greeting message (Hello, Thank you for contacting ROMTech customer service department</td>
											<td>3</td>
											<td>
												<select class="form-control romtech_inbound_point business" name="data[appropriate_greeting]" required>
													
													<option romtech_inbound_val=3 romtech_inbound_max=3 <?php echo $romtech_inbound_data['appropriate_greeting'] == "Meets" ? "selected" : ""; ?> value="Meets">Meets</option>
													<option romtech_inbound_val=1.5 romtech_inbound_max=3 <?php echo $romtech_inbound_data['appropriate_greeting'] == "Needs Improvement" ? "selected" : ""; ?> value="Needs Improvement">Needs Improvement</option>
													<option romtech_inbound_val=0 romtech_inbound_max=3 <?php echo $romtech_inbound_data['appropriate_greeting'] == "Failed" ? "selected" : ""; ?> value="Failed">Failed</option>
												</select>
											</td>
											
											<td colspan=2><input type="text" name="data[cmt1]" class="form-control" value="<?php echo $romtech_inbound_data['cmt1'] ?>"></td>
										</tr>
										<tr>
											<td colspan=2>Introduction-Did the agent mention his/her name on call and also branded the call</td>
											<td>3</td>
											<td>
												<select class="form-control romtech_inbound_point business" name="data[introduction_on_call]" required>
													
													<option romtech_inbound_val=3 romtech_inbound_max=3 <?php echo $romtech_inbound_data['introduction_on_call'] == "Meets" ? "selected" : ""; ?> value="Meets">Meets</option>
													<option romtech_inbound_val=1.5 romtech_inbound_max=3 <?php echo $romtech_inbound_data['introduction_on_call'] == "Needs Improvement" ? "selected" : ""; ?> value="Needs Improvement">Needs Improvement</option>
													<option romtech_inbound_val=0 romtech_inbound_max=3 <?php echo $romtech_inbound_data['introduction_on_call'] == "Failed" ? "selected" : ""; ?> value="Failed">Failed</option>
												</select>
											</td>
											
											<td colspan=2><input type="text" name="data[cmt2]" class="form-control" value="<?php echo $romtech_inbound_data['cmt2'] ?>"></td>
										</tr>
										<tr>
											<td class="eml" rowspan=1 style="font-weight:bold; background-color:#D7BDE2">Compliance Critical</td>
											<td colspan=2 class="text-danger">Mandate details-Did the agent confirm the patient's first & last name/Physician name/DOB</td>
											<td>5</td>
											<td>
												<select class="form-control romtech_inbound_point compliance" id="romtech_inbound_Fatal1" name="data[mandate_details]" required>
													
													<option romtech_inbound_val=5 romtech_inbound_max=5 <?php echo $romtech_inbound_data['mandate_details'] == "Meets" ? "selected" : ""; ?> value="Meets">Meets</option>
													<option romtech_inbound_val=2.5 romtech_inbound_max=5 <?php echo $romtech_inbound_data['mandate_details'] == "Needs Improvement" ? "selected" : ""; ?> value="Needs Improvement">Needs Improvement</option>
													<option romtech_inbound_val=0 romtech_inbound_max=5 <?php echo $romtech_inbound_data['mandate_details'] == "Failed" ? "selected" : ""; ?> value="Failed">Failed</option>
												</select>
											</td>
											
											<td colspan=2><input type="text" name="data[cmt3]" class="form-control" value="<?php echo $romtech_inbound_data['cmt3'] ?>"></td>
										</tr>

										<tr>
											<td class="eml" rowspan=4 style="font-weight:bold; background-color:#90bfee">Customer Critical</td>
											<td rowspan=5 style="font-weight:bold; background-color:#94ffff">Soft Skills</td>
											<td colspan=2>Communication - Proper energy, proper pace,communication skill was reflecting on call while speaking to the customer.</td>
											<td>4</td>
											<td>
												<select class="form-control romtech_inbound_point customer" name="data[communication_skill]" required>
													
													<option romtech_inbound_val=4 romtech_inbound_max=4 <?php echo $romtech_inbound_data['communication_skill'] == "Meets" ? "selected" : ""; ?> value="Meets">Meets</option>
													<option romtech_inbound_val=2 romtech_inbound_max=4 <?php echo $romtech_inbound_data['communication_skill'] == "Needs Improvement" ? "selected" : ""; ?> value="Needs Improvement">Needs Improvement</option>
													<option romtech_inbound_val=0 romtech_inbound_max=4 <?php echo $romtech_inbound_data['communication_skill'] == "Failed" ? "selected" : ""; ?> value="Failed">Failed</option>
												</select>
											</td>
											
											<td colspan=2><input type="text" name="data[cmt4]" class="form-control" value="<?php echo $romtech_inbound_data['cmt4'] ?>"></td>
										</tr>
										<tr>
											<td colspan=2>Empathy- Agent shown empathy or appology when and where required. Also agent's intonation was proper on call.</td>
											<td>4</td>
											<td>
												<select class="form-control romtech_inbound_point customer" name="data[empathy]" required>
													
													<option romtech_inbound_val=4 romtech_inbound_max=4 <?php echo $romtech_inbound_data['empathy'] == "Meets" ? "selected" : ""; ?> value="Meets">Meets</option>
													<option romtech_inbound_val=2 romtech_inbound_max=4 <?php echo $romtech_inbound_data['empathy'] == "Needs Improvement" ? "selected" : ""; ?> value="Needs Improvement">Needs Improvement</option>
													<option romtech_inbound_val=0 romtech_inbound_max=4 <?php echo $romtech_inbound_data['empathy'] == "Failed" ? "selected" : ""; ?> value="Failed">Failed</option>
												</select>
											</td>
											
											<td colspan=2><input type="text" name="data[cmt5]" class="form-control" value="<?php echo $romtech_inbound_data['cmt5'] ?>"></td>
										</tr>
										<tr>
											<td colspan=2>Did the agent overlapped or interruped the customer while he/she was speaking?</td>
											<td>4</td>
											<td>
												<select class="form-control romtech_inbound_point customer" name="data[overlapped_customer]" required>
													
													<option romtech_inbound_val=4 romtech_inbound_max=4 <?php echo $romtech_inbound_data['overlapped_customer'] == "Meets" ? "selected" : ""; ?> value="Meets">Meets</option>
													<option romtech_inbound_val=2 romtech_inbound_max=4 <?php echo $romtech_inbound_data['overlapped_customer'] == "Needs Improvement" ? "selected" : ""; ?> value="Needs Improvement">Needs Improvement</option>
													<option romtech_inbound_val=0 romtech_inbound_max=4 <?php echo $romtech_inbound_data['overlapped_customer'] == "Failed" ? "selected" : ""; ?> value="Failed">Failed</option>
												</select>
											</td>
											
											<td colspan=2><input type="text" name="data[cmt6]" class="form-control" value="<?php echo $romtech_inbound_data['cmt6'] ?>"></td>
										</tr>
										<tr>
											<td colspan=2>Did the agent showed good listening skills on call ?</td>
											<td>4</td>
											<td>
												<select class="form-control romtech_inbound_point customer" name="data[listening_skills]" required>
													
													<option romtech_inbound_val=4 romtech_inbound_max=4 <?php echo $romtech_inbound_data['listening_skills'] == "Meets" ? "selected" : ""; ?> value="Meets">Meets</option>
													<option romtech_inbound_val=2 romtech_inbound_max=4 <?php echo $romtech_inbound_data['listening_skills'] == "Needs Improvement" ? "selected" : ""; ?> value="Needs Improvement">Needs Improvement</option>
													<option romtech_inbound_val=0 romtech_inbound_max=4 <?php echo $romtech_inbound_data['listening_skills'] == "Failed" ? "selected" : ""; ?> value="Failed">Failed</option>
												</select>
											</td>
											
											<td colspan=2><input type="text" name="data[cmt7]" class="form-control" value="<?php echo $romtech_inbound_data['cmt7'] ?>"></td>
										</tr>
										<tr>
											<td class="eml" rowspan=1 style="font-weight:bold; background-color:#D7BDE2">Compliance Critical</td>
											<td colspan=2 class="text-danger">Professionalism - Agent shown proper professionalism on call. Not being rude on call, abusive, call disconnection, sarcasm ,Using jargons etc.</td>
											<td>4</td>
											<td>
												<select class="form-control romtech_inbound_point compliance" id="romtech_inbound_Fatal2" name="data[professionalism]" required>
													
													<option romtech_inbound_val=4 romtech_inbound_max=4 <?php echo $romtech_inbound_data['professionalism'] == "Meets" ? "selected" : ""; ?> value="Meets">Meets</option>
													<option romtech_inbound_val=2 romtech_inbound_max=4 <?php echo $romtech_inbound_data['professionalism'] == "Needs Improvement" ? "selected" : ""; ?> value="Needs Improvement">Needs Improvement</option>
													<option romtech_inbound_val=0 romtech_inbound_max=4 <?php echo $romtech_inbound_data['professionalism'] == "Failed" ? "selected" : ""; ?> value="Failed">Failed</option>
												</select>
											</td>
											
											<td colspan=2><input type="text" name="data[cmt8]" class="form-control" value="<?php echo $romtech_inbound_data['cmt8'] ?>"></td>
										</tr>

										<tr>
											<td class="eml" rowspan=3 style="font-weight:bold; background-color:#90bfee">Customer Critical</td>
											<td rowspan=3 style="font-weight:bold; background-color:#90eebf">Call Handling</td>
											<td colspan=2>Probing - Did agent probed well to understand patient's query and provide right information.</td>
											<td>3</td>
											<td>
												<select class="form-control romtech_inbound_point customer" name="data[probing]" required>
													
													<option romtech_inbound_val=3 romtech_inbound_max=3 <?php echo $romtech_inbound_data['probing'] == "Meets" ? "selected" : ""; ?> value="Meets">Meets</option>
													<option romtech_inbound_val=1.5 romtech_inbound_max=3 <?php echo $romtech_inbound_data['probing'] == "Needs Improvement" ? "selected" : ""; ?> value="Needs Improvement">Needs Improvement</option>
													<option romtech_inbound_val=0 romtech_inbound_max=3 <?php echo $romtech_inbound_data['probing'] == "Failed" ? "selected" : ""; ?> value="Failed">Failed</option>
												</select>
											</td>
											
											<td colspan=2><input type="text" name="data[cmt9]" class="form-control" value="<?php echo $romtech_inbound_data['cmt9'] ?>"></td>
										</tr>
										<tr>
											<td colspan=2>Hold Verbiage - Did the agent asked permission to put the call on hold ? & after resuming agent should thank the patient.</td>
											<td>3</td>
											<td>
												<select class="form-control romtech_inbound_point customer" name="data[hold_verbiage]" required>
													
													<option romtech_inbound_val=3 romtech_inbound_max=3 <?php echo $romtech_inbound_data['hold_verbiage'] == "Meets" ? "selected" : ""; ?> value="Meets">Meets</option>
													<option romtech_inbound_val=1.5 romtech_inbound_max=3 <?php echo $romtech_inbound_data['hold_verbiage'] == "Needs Improvement" ? "selected" : ""; ?> value="Needs Improvement">Needs Improvement</option>
													<option romtech_inbound_val=0 romtech_inbound_max=3 <?php echo $romtech_inbound_data['hold_verbiage'] == "Failed" ? "selected" : ""; ?> value="Failed">Failed</option>
												</select>
											</td>
											
											<td colspan=2><input type="text" name="data[cmt10]" class="form-control" value="<?php echo $romtech_inbound_data['cmt10'] ?>"></td>
										</tr>
										<tr>
											<td colspan=2>Hold Refresh - Did the agent informed the patient that he/she still looking for information (if hold is more than 2 mins)- If disconnected due to long hold then it leads to infraction.</td>
											<td>3</td>
											<td>
												<select class="form-control romtech_inbound_point customer" name="data[hold_refresh]" required>
													
													<option romtech_inbound_val=3 romtech_inbound_max=3 <?php echo $romtech_inbound_data['hold_refresh'] == "Meets" ? "selected" : ""; ?> value="Meets">Meets</option>
													<option romtech_inbound_val=1.5 romtech_inbound_max=3 <?php echo $romtech_inbound_data['hold_refresh'] == "Needs Improvement" ? "selected" : ""; ?> value="Needs Improvement">Needs Improvement</option>
													<option romtech_inbound_val=0 romtech_inbound_max=3 <?php echo $romtech_inbound_data['hold_refresh'] == "Failed" ? "selected" : ""; ?> value="Failed">Failed</option>
												</select>
											</td>
											
											<td colspan=2><input type="text" name="data[cmt11]" class="form-control" value="<?php echo $romtech_inbound_data['cmt11'] ?>"></td>
										</tr>

										<tr>
											<td class="eml" rowspan=1 style="font-weight:bold; background-color:#90bfee">Customer Critical</td>
											<td rowspan=6 style="font-weight:bold; background-color:#bf90ee">Call Dialog</td>
											<td colspan=2>Consistent pleasantries used throughout the entire call  (Please, thank you, Excuse me, You're Welcome, & May I).</td>
											<td>5</td>
											<td>
												<select class="form-control romtech_inbound_point customer" name="data[consistent_pleasantries]" required>
													
													<option romtech_inbound_val=5 romtech_inbound_max=5 <?php echo $romtech_inbound_data['consistent_pleasantries'] == "Meets" ? "selected" : ""; ?> value="Meets">Meets</option>
													<option romtech_inbound_val=2.5 romtech_inbound_max=5 <?php echo $romtech_inbound_data['consistent_pleasantries'] == "Needs Improvement" ? "selected" : ""; ?> value="Needs Improvement">Needs Improvement</option>
													<option romtech_inbound_val=0 romtech_inbound_max=5 <?php echo $romtech_inbound_data['consistent_pleasantries'] == "Failed" ? "selected" : ""; ?> value="Failed">Failed</option>
												</select>
											</td>
											
											<td colspan=2><input type="text" name="data[cmt12]" class="form-control" value="<?php echo $romtech_inbound_data['cmt12'] ?>"></td>
										</tr>
										<tr>
											<td class="eml" rowspan=1 style="font-weight:bold; background-color:#D7BDE2">Compliance Critical</td>
											<td colspan=2 class="text-danger">All call notes documented in ServiceNow with the correct taxonomy.</td>
											<td>10</td>
											<td>
												<select class="form-control romtech_inbound_point compliance" id="romtech_inbound_Fatal3" name="data[correct_taxonomy]" required>
													
													<option romtech_inbound_val=10 romtech_inbound_max=10 <?php echo $romtech_inbound_data['correct_taxonomy'] == "Meets" ? "selected" : ""; ?> value="Meets">Meets</option>
													<option romtech_inbound_val=5 romtech_inbound_max=10 <?php echo $romtech_inbound_data['correct_taxonomy'] == "Needs Improvement" ? "selected" : ""; ?> value="Needs Improvement">Needs Improvement</option>
													<option romtech_inbound_val=0 romtech_inbound_max=10 <?php echo $romtech_inbound_data['correct_taxonomy'] == "Failed" ? "selected" : ""; ?> value="Failed">Failed</option>
												</select>
											</td>
											
											<td colspan=2><input type="text" name="data[cmt13]" class="form-control" value="<?php echo $romtech_inbound_data['cmt13'] ?>"></td>
										</tr>
										<tr>
											<td class="eml" rowspan=2 style="font-weight:bold; background-color:#d6bf91">Business Critical</td>
											<td colspan=2>The agent followed all company process and policies to resolve the problem.</td>
											<td>5</td>
											<td>
												<select class="form-control romtech_inbound_point business" id="" name="data[polices_resolve_problem]" required>
													
													<option romtech_inbound_val=5 romtech_inbound_max=5 <?php echo $romtech_inbound_data['polices_resolve_problem'] == "Meets" ? "selected" : ""; ?> value="Meets">Meets</option>
													<option romtech_inbound_val=2.5 romtech_inbound_max=5 <?php echo $romtech_inbound_data['polices_resolve_problem'] == "Needs Improvement" ? "selected" : ""; ?> value="Needs Improvement">Needs Improvement</option>
													<option romtech_inbound_val=0 romtech_inbound_max=5 <?php echo $romtech_inbound_data['polices_resolve_problem'] == "Failed" ? "selected" : ""; ?> value="Failed">Failed</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt14]" class="form-control" value="<?php echo $romtech_inbound_data['cmt14'] ?>"></td>
										</tr>
											<tr>
											
											<td colspan=2>All internal resources (tools & managers) used to resolve the problem.</td>
											<td>10</td>
											<td>
												<select class="form-control romtech_inbound_point business" id="" name="data[internal_resources]" required>
													
													<option romtech_inbound_val=10 romtech_inbound_max=10 <?php echo $romtech_inbound_data['internal_resources'] == "Meets" ? "selected" : ""; ?> value="Meets">Meets</option>
													<option romtech_inbound_val=5 romtech_inbound_max=10 <?php echo $romtech_inbound_data['internal_resources'] == "Needs Improvement" ? "selected" : ""; ?> value="Needs Improvement">Needs Improvement</option>
													<option romtech_inbound_val=0 romtech_inbound_max=10 <?php echo $romtech_inbound_data['internal_resources'] == "Failed" ? "selected" : ""; ?> value="Failed">Failed</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt15]" class="form-control" value="<?php echo $romtech_inbound_data['cmt15'] ?>"></td>

											<tr>
											<td class="eml" rowspan=1 style="font-weight:bold; background-color:#D7BDE2">Compliance Critical</td>
											<td colspan=2 class="text-danger">Problem was clearly determined and explained due to having ROMTech knowledge .</td>
											<td>10</td>
											<td>
												<select class="form-control romtech_inbound_point compliance" id="romtech_inbound_Fatal4" name="data[ROMTech_knowledge]" required>
													
													<option romtech_inbound_val=10 romtech_inbound_max=10 <?php echo $romtech_inbound_data['ROMTech_knowledge'] == "Meets" ? "selected" : ""; ?> value="Meets">Meets</option>
													<option romtech_inbound_val=5 romtech_inbound_max=10 <?php echo $romtech_inbound_data['ROMTech_knowledge'] == "Needs Improvement" ? "selected" : ""; ?> value="Needs Improvement">Needs Improvement</option>
													<option romtech_inbound_val=0 romtech_inbound_max=10 <?php echo $romtech_inbound_data['ROMTech_knowledge'] == "Failed" ? "selected" : ""; ?> value="Failed">Failed</option>
												</select>
											</td>
											
											<td colspan=2><input type="text" name="data[cmt16]" class="form-control" value="<?php echo $romtech_inbound_data['cmt16'] ?>"></td>
										</tr>
										<tr>
											<td class="eml" rowspan=1 style="font-weight:bold; background-color:#d6bf91">Business Critical</td>
											<td colspan=2>Provide clear follow-up instructions (If applicable).</td>
											<td>5</td>
											<td>
												<select class="form-control romtech_inbound_point business" id="" name="data[follow_up]" required>
													
													<option romtech_inbound_val=5 romtech_inbound_max=5 <?php echo $romtech_inbound_data['follow_up'] == "Meets" ? "selected" : ""; ?> value="Meets">Meets</option>
													<option romtech_inbound_val=2.5 romtech_inbound_max=5 <?php echo $romtech_inbound_data['follow_up'] == "Needs Improvement" ? "selected" : ""; ?> value="Needs Improvement">Needs Improvement</option>
													<option romtech_inbound_val=0 romtech_inbound_max=5 <?php echo $romtech_inbound_data['follow_up'] == "Failed" ? "selected" : ""; ?> value="Failed">Failed</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt17]" class="form-control" value="<?php echo $romtech_inbound_data['cmt17'] ?>"></td>
										</tr>
										<tr>
											<td class="eml" rowspan=1 style="font-weight:bold; background-color:#d6bf91">Business Critical</td>
											<td rowspan=2 style="font-weight:bold; background-color:#ffa07a">Closing</td>
											<td colspan=2>Verify if the user had any other questions.</td>
											<td>5</td>
											<td>
												<select class="form-control romtech_inbound_point business" name="data[other_questions]" required>
													
													<option romtech_inbound_val=5 romtech_inbound_max=5 <?php echo $romtech_inbound_data['other_questions'] == "Meets" ? "selected" : ""; ?> value="Meets">Meets</option>
													<option romtech_inbound_val=2.5 romtech_inbound_max=5 <?php echo $romtech_inbound_data['other_questions'] == "Needs Improvement" ? "selected" : ""; ?> value="Needs Improvement">Needs Improvement</option>
													<option romtech_inbound_val=0 romtech_inbound_max=5 <?php echo $romtech_inbound_data['other_questions'] == "Failed" ? "selected" : ""; ?> value="Failed">Failed</option>
												</select>
											</td>
											
											<td colspan=2><input type="text" name="data[cmt18]" class="form-control" value="<?php echo $romtech_inbound_data['cmt18'] ?>"></td>
										</tr>
										<tr>
											<td class="eml" rowspan=1 style="font-weight:bold; background-color:#90bfee">Customer Critical</td>
											
											<td colspan=2>Used standard ROMTech closing message (Thank you for contacting ROMTech customer service department).</td>
											<td>10</td>
											<td>
												<select class="form-control romtech_inbound_point customer" name="data[closing_message]" required>
													
													<option romtech_inbound_val=10 romtech_inbound_max=10 <?php echo $romtech_inbound_data['closing_message'] == "Meets" ? "selected" : ""; ?> value="Meets">Meets</option>
													<option romtech_inbound_val=5 romtech_inbound_max=10 <?php echo $romtech_inbound_data['closing_message'] == "Needs Improvement" ? "selected" : ""; ?> value="Needs Improvement">Needs Improvement</option>
													<option romtech_inbound_val=0 romtech_inbound_max=10 <?php echo $romtech_inbound_data['closing_message'] == "Failed" ? "selected" : ""; ?> value="Failed">Failed</option>
												</select>
											</td>
											
											<td colspan=2><input type="text" name="data[cmt19]" class="form-control" value="<?php echo $romtech_inbound_data['cmt13'] ?>"></td>
										</tr>
										</tr>
									<tr style="font-weight:bold; background-color:#D7BDE2"><td colspan=2>Customer Score</td><td colspan=2>Business Score</td><td colspan=4>Compliance Score</td></tr>

									<tr style="font-weight:bold; background-color:#D7BDE2">
										<td>Earned Point:</td><td ><input type="text" readonly class="form-control" id="customer_earned_score" name="data[customer_earned_score]" value="<?php echo $romtech_inbound_data['customer_earned_score'] ?>"></td>
										<td>Earned Point:</td><td ><input type="text" readonly class="form-control" id="business_earned_score" name="data[business_earned_score]" value="<?php echo $romtech_inbound_data['business_earned_score'] ?>"></td>
										<td>Earned Point:</td><td colspan=2><input type="text" readonly class="form-control" id="compliance_earned_score" name="data[compliance_earned_score]" value="<?php echo $romtech_inbound_data['compliance_earned_score'] ?>"></td>
									</tr>
									<tr style="font-weight:bold; background-color:#D7BDE2">
										<td>Possible Point:</td><td ><input type="text" readonly class="form-control" id="customer_possible_score" name="data[customer_possible_score]" value="<?php echo $romtech_inbound_data['customer_possible_score'] ?>"></td>
										<td>Possible Point:</td><td ><input type="text" readonly class="form-control" id="business_possible_score" name="data[business_possible_score]" value="<?php echo $romtech_inbound_data['business_possible_score'] ?>"></td>
										<td>Possible Point:</td><td colspan=2><input type="text" readonly class="form-control" id="compliance_possible_score" name="data[compliance_possible_score]" value="<?php echo $romtech_inbound_data['compliance_possible_score'] ?>"></td>
									</tr>
									<tr style="font-weight:bold; background-color:#D7BDE2">
										<td>Overall Percentage:</td><td ><input type="text" readonly class="form-control" id="customer_overall_score" name="data[customer_overall_score]" value="<?php echo $romtech_inbound_data['customer_overall_score'] ?>"></td>
										<td>Overall Percentage:</td><td ><input type="text" readonly class="form-control" id="business_overall_score" name="data[business_overall_score]" value="<?php echo $romtech_inbound_data['business_overall_score'] ?>"></td>
										<td>Overall Percentage:</td><td colspan=2><input type="text" readonly class="form-control" id="compliance_overall_score" name="data[compliance_overall_score]" value="<?php echo $romtech_inbound_data['compliance_overall_score'] ?>"></td>
									</tr>
										<tr>
											<td>Call Summary:</td>
											<td colspan=2><textarea class="form-control" name="data[call_summary]"><?php echo $romtech_inbound_data['call_summary'] ?></textarea></td>
											<td>Feedback:</td>
											<td colspan=4><textarea class="form-control" name="data[feedback]"><?php echo $romtech_inbound_data['feedback'] ?></textarea></td>
										</tr>
										<tr>
											<td colspan=2>Upload Files [m4a,mp4,mp3,wav]</td>
											<?php if ($romtech_inbound_id == 0) { ?>
												<td colspan=6>
													<input type="file" name="attach_file[]" id="attach_file" accept=".m4a,.mp4,.mp3,.wav,audio/*" />
												</td>
												<?php } else {
												if ($romtech_inbound_data['attach_file'] != '') { ?>
													<td colspan=6>
														<input type="file" multiple class="form-control"  id="attach_file" name="attach_file[]" accept=".m4a,.mp4,.mp3,.wav,audio/*"> 
														<?php $attach_file = explode(",", $romtech_inbound_data['attach_file']);
														foreach ($attach_file as $mp) { ?>
															<audio controls='' style="background-color:#607F93">
																<source src="<?php echo base_url(); ?>qa_files/romtech_inbound/<?php echo $mp; ?>" type="audio/ogg">
																<source src="<?php echo base_url(); ?>qa_files/romtech_inbound/<?php echo $mp; ?>" type="audio/mpeg">
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

										<?php if ($romtech_inbound_id != 0) { ?>
											<tr>
												<td colspan=2 style="font-size:16px; font-weight:bold">Agent Feedback Acceptance:</td>
												<td colspan=4><?php echo $romtech_inbound_data['agnt_fd_acpt'] ?></td>
											</tr>
											<tr>
												<td colspan=2 style="font-size:16px; font-weight:bold">Agent Review:</td>
												<td colspan=4><?php echo $romtech_inbound_data['agent_rvw_note'] ?></td>
											</tr>
											<tr>
												<td colspan=2 style="font-size:16px; font-weight:bold">Management Review:</td>
												<td colspan=4><?php echo $romtech_inbound_data['mgnt_rvw_note'] ?></td>
											</tr>
											<tr>
												<td colspan=2 style="font-size:16px; font-weight:bold">Client Review:</td>
												<td colspan=4><?php echo $romtech_inbound_data['client_rvw_note'] ?></td>
											</tr>

											<tr>
												<td colspan=2 style="font-size:16px">Your Review<span style="font-size:24px;color:red">*</span></td>
												<td colspan=4><textarea class="form-control1" style="width:100%" id="note" name="note" required></textarea></td>
											</tr>
										<?php } ?>

										<?php
										if ($romtech_inbound_id == 0) {
											if (is_access_qa_module() == true || is_access_qa_operations_module() == true) { ?>
												<tr>
													<td colspan=8><button class="btn btn-success waves-effect" type="submit" id="qaformsubmit" style="width:500px">SAVE</button></td>
												</tr>
												<?php
											}
										} else {
											if (is_access_qa_module() == true || is_access_qa_operations_module() == true) {
												if (is_available_qa_feedback($romtech_inbound_data['entry_date'], 72) == true) { ?>
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