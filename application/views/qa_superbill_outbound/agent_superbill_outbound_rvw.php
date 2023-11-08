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
										<td colspan="6" id="theader" style="font-size:40px">Superbill-Outbound Agent Form</td>
										<input type="hidden" name="audit_start_time" value="<?php echo CurrMySqlDate(); ?>">
									</tr>
									<?php
										
											if($superbill_outbound_data['entry_by']!=''){
												$auditorName = $superbill_outbound_data['auditor_name'];
											}else{
												$auditorName = $superbill_outbound_data['client_name'];
											}
											$auditDate = mysql2mmddyy($superbill_outbound_data['audit_date']);
											$clDate_val = mysqlDt2mmddyy($superbill_outbound_data['call_date']);
										
										if ($rand_id != 0) {
											$agent_id = $rand_data['sid'];
											$fusion_id = $rand_data['fusion_id'];
											$agent_name = $rand_data['fname'] . " " . $rand_data['lname'];
											$tl_id = $rand_data['assigned_to'];
											$tl_name = $rand_data['tl_name'];
											$call_duration = $rand_data['call_duration'];
											
										} else {
											$agent_id = $superbill_outbound_data['agent_id'];
											$fusion_id = $superbill_outbound_data['fusion_id'];
											$agent_name = $superbill_outbound_data['fname'] . " " . $superbill_outbound_data['lname'] ;
											$tl_id = $superbill_outbound_data['tl_id'];
											$tl_name = $superbill_outbound_data['tl_name'];
											$call_duration = $superbill_outbound_data['call_duration'];
										}
									?>
									<tr>
										<td>Auditor Name:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control form_superbill" value="<?php echo $auditorName; ?>" disabled></td>
										<td>Audit Date:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control form_superbill" value="<?php echo $auditDate; ?>" disabled></td>
										<td>Interaction ID:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control form_superbill" name="data[interaction_id]" pattern="^[a-zA-Z0-9_]*$" title="Only alphanumeric allowed" value="<?php echo $superbill_outbound_data['interaction_id'] ?>" disabled ></td>
										
									</tr>
									<tr>
										<td>Agent Name:<span style="font-size:24px;color:red">*</span></td>
										<td>
											<select class="form-control form_superbill" id="agent_id" name="data[agent_id]" disabled>
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
										<td><input type="text" class="form-control form_superbill" id="fusion_id" value="<?php echo $superbill_outbound_data['fusion_id'] ?>" readonly ></td>
										<td>L1 <br>Supervisor:<span style="font-size:24px;color:red">*</span></td>
										<td>
											<input type="text" class="form-control form_superbill" id="tl_name"  value="<?php echo $tl_name; ?>" readonly>
												<input type="hidden" class="form-control form_superbill" id="tl_id" name="data[tl_id]" value="<?php echo $tl_id; ?>" disabled>
										</td>
									</tr>
									<tr>
										<td>Disposition:<span style="font-size:24px;color:red">*</span></td>
										<td>
											<select class="form-control form_superbill" id="" name="data[disposition]" disabled>
												<option value="">-Select-</option>
													<option value="Connected"  <?= ($superbill_outbound_data['disposition']=="Connected")?"selected":"" ?>>Connected
													</option>
													<option value="Not Connected"  <?= ($superbill_outbound_data['disposition']=="Not Connected")?"selected":"" ?>>Not Connected
													</option>
													<option value="Call back later"  <?= ($superbill_outbound_data['disposition']=="Call back later")?"selected":"" ?>>Call back later
													</option>
											</select>
										</td>
										<td>Call Date/<br>Time:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control form_superbill" id="call_date_time" name="call_date" value="<?php echo $clDate_val; ?>" disabled></td>
										<td>Call <br>Duration:<span style="font-size:24px;color:red">*</span></td>
										<td>
											<input type="text" class="form-control form_superbill"  id="" name="data[call_duration]" value="<?php echo $call_duration; ?>" disabled>
										</td>
									</tr>
									
									<tr>
										<td>Record ID:<span style="font-size:24px;color:red">*</span></td>
										<td>
											<input type="text" class="form-control form_superbill" id="" name="data[record_id]" value="<?php echo $superbill_outbound_data['record_id'] ?>" disabled>
										</td>
										<td>VOC:<span style="font-size:24px;color:red">*</span></td>
											<td>
												<select class="form-control form_superbill" id="voc" name="data[voc]" disabled>
													
													<option value="">-Select-</option>
													<option value="1"  <?= ($superbill_outbound_data['voc']=="1")?"selected":"" ?>>1</option>
													<option value="2"  <?= ($superbill_outbound_data['voc']=="2")?"selected":"" ?>>2</option>
													<option value="3"  <?= ($superbill_outbound_data['voc']=="3")?"selected":"" ?>>3</option>
													<option value="4"  <?= ($superbill_outbound_data['voc']=="4")?"selected":"" ?>>4</option>
													<option value="5"  <?= ($superbill_outbound_data['voc']=="5")?"selected":"" ?>>5</option>
													<option value="6"  <?= ($superbill_outbound_data['voc']=="6")?"selected":"" ?>>6</option>
													<option value="7"  <?= ($superbill_outbound_data['voc']=="7")?"selected":"" ?>>7</option>
													<option value="8"  <?= ($superbill_outbound_data['voc']=="8")?"selected":"" ?>>8</option>
													<option value="9"  <?= ($superbill_outbound_data['voc']=="9")?"selected":"" ?>>9</option>
													<option value="10"  <?= ($superbill_outbound_data['voc']=="10")?"selected":"" ?>>10</option>
												</select>
											</td>
										<td>KPI - ACPT:<span style="font-size:24px;color:red">*</span></td>
										<td>
											<select class="form-control form_superbill" name="data[KPI_ACPT]" disabled>
												<option value="">-Select-</option>
												<option <?php echo $superbill_outbound_data['KPI_ACPT'] == "Agent"?"selected":"";?> value="Agent">Agent</option>
												<option <?php echo $superbill_outbound_data['KPI_ACPT'] == "Process"?"selected":"";?> value="Process">Process</option>
												<option <?php echo $superbill_outbound_data['KPI_ACPT'] == "Customer"?"selected":"";?> value="Customer">Customer</option>
												<option <?php echo $superbill_outbound_data['KPI_ACPT'] == "Technology"?"selected":"";?> value="Technology">Technology</option>
												<option <?php echo $superbill_outbound_data['KPI_ACPT'] == "NA"?"selected":"";?> value="NA">NA</option>
											</select> 
										</td>
										
									</tr>
									<tr>
										
										<td>Audit Type:<span style="font-size:24px;color:red">*</span></td>
										<td>
											<select class="form-control form_superbill" id="audit_type" name="data[audit_type]" disabled>
                                                    <option value="">-Select-</option>
                                                    <option value="CQ Audit" <?= ($superbill_outbound_data['audit_type']=="CQ Audit")?"selected":"" ?>>CQ Audit</option>
                                                    <option value="BQ Audit" <?= ($superbill_outbound_data['audit_type']=="BQ Audit")?"selected":"" ?>>BQ Audit</option>
                                                    <option value="Calibration" <?= ($superbill_outbound_data['audit_type']=="Calibration")?"selected":"" ?>>Calibration</option>
                                                    <option value="Pre-Certificate Mock Call" <?= ($superbill_outbound_data['audit_type']=="Pre-Certificate Mock Call")?"selected":"" ?>>Pre-Certificate Mock Call</option>
                                                    <option value="Certification Audit" <?= ($superbill_outbound_data['audit_type']=="Certification Audit")?"selected":"" ?>>Certification Audit</option>
                                                    <option value="WoW Call"  <?= ($superbill_outbound_data['audit_type']=="WoW Call")?"selected":"" ?>>WoW Call</option>
                                                    <option value="Hygiene Audit"  <?= ($superbill_outbound_data['audit_type']=="Hygiene Audit")?"selected":"" ?>>Hygiene Audit</option>
                                                    <option value="Operation Audit"  <?= ($superbill_outbound_data['audit_type']=="Operation Audit")?"selected":"" ?>>Operation Audit</option>
                                                    <option value="Trainer Audit"  <?= ($superbill_outbound_data['audit_type']=="Trainer Audit")?"selected":"" ?>>Trainer Audit</option> 
                                                    <option value="QA Supervisor Audit"  <?= ($superbill_outbound_data['audit_type']=="QA Supervisor Audit")?"selected":"" ?>>QA Supervisor Audit</option> 
                                                </select>
										</td>
										<td class="auType_epi">Auditor Type<span style="font-size:24px;color:red">*</span></td>
											<td class="auType_epi">
												<select class="form-control form_superbill" id="auditor_type" name="data[auditor_type]">
                                                    <option value="">Select</option>
                                                    <option value="Master" <?= ($superbill_outbound_data['auditor_type']=="Master")?"selected":"" ?>>Master</option>
                                                    <option value="Regular" <?= ($superbill_outbound_data['auditor_type']=="Regular")?"selected":"" ?>>Regular</option>
                                                </select>
											</td>
									</tr>
									<tr>
										<td style="font-weight:bold; font-size:14px; text-align:right">Earned Score:</td>
										<td><input type="text" readonly id="superbill_ob_earned_score" name="data[earned_score]" class="form-control form_superbill" style="font-weight:bold" value="<?php echo $superbill_outbound_data['earned_score'] ?>"></td>
										<td style="font-weight:bold; font-size:14px; text-align:right">Possible<br>Score:</td>
										<td><input type="text" readonly id="superbill_ob_possible_score" name="data[possible_score]" class="form-control form_superbill" style="font-weight:bold" value="<?php echo $superbill_outbound_data['possible_score'] ?>"></td>
										<td style="font-weight:bold; font-size:14px; text-align:right">Overall <br>Score:</td>
										<td><input type="text" readonly id="superbill_ob_overall_score" name="data[overall_score]" class="form-control form_superbill superFatal" style="font-weight:bold" value="<?php echo $superbill_outbound_data['overall_score'] ?>"></td>
									</tr>
									
									<tr style="background-color:#85C1E9; font-weight:bold">
										<td>Criticality</td>
										<td>Parameter</td>
										<td>Sub Parameter</td>
										<td>Weightage</td>
										<td>Rating</td>
										<td>Comments</td>
									</tr>
									<tr>
										<td>Non Fatal</td>
										<td rowspan=1 style="background-color:#85C1E9; font-weight:bold">Greetings</td>
										<td>Branding and Self Intro</td>
										<td>5</td>
										<td>
											<select class="form-control form_superbill superbill_ob_points" id="greetings" name="data[greetings]" disabled>
												<option superbill_ob_val=5 superbill_ob_max=5 <?php echo $superbill_outbound_data['greetings'] == "Pass"?"selected":"";?> value="Pass">Pass</option>
												<option superbill_ob_val=0 superbill_ob_max=5 <?php echo $superbill_outbound_data['greetings'] == "Fail"?"selected":"";?> value="Fail">Fail</option>
												<option superbill_ob_val=5 superbill_ob_max=5 <?php echo $superbill_outbound_data['greetings'] == "NA"?"selected":"";?> value="NA">NA</option>
											</select>
										</td>
										
										<td><textarea class="form-control form_superbill" disabled name="data[cmt1]"><?php echo $superbill_outbound_data['cmt1'] ?></textarea>
										</td>
									</tr>
									<tr>
										<td>Non Fatal</td>
										<td rowspan=3 style="background-color:#85C1E9; font-weight:bold">Communication</td>
										<td>Polite and professionalism</td>
										<td>8</td>
										<td>
											<select class="form-control form_superbill superbill_ob_points" id="polite" name="data[polite]" disabled>
												<option superbill_ob_val=8 superbill_ob_max=8 <?php echo $superbill_outbound_data['polite'] == "Pass"?"selected":"";?> value="Pass">Pass</option>
												<option superbill_ob_val=0 superbill_ob_max=8 <?php echo $superbill_outbound_data['polite'] == "Fail"?"selected":"";?> value="Fail">Fail</option>
												<option superbill_ob_val=8 superbill_ob_max=8 <?php echo $superbill_outbound_data['polite'] == "NA"?"selected":"";?> value="NA">NA</option>
											</select>
										</td>
										
										<td><textarea class="form-control form_superbill" disabled name="data[cmt2]"><?php echo $superbill_outbound_data['cmt2'] ?></textarea>
										</td>
									</tr>
									<tr>
										<td>Non Fatal</td>
										<td>Attentiveness and acknowledgement (Understanding on the concern)</td>
										<td>8</td>
										<td>
											<select class="form-control form_superbill superbill_ob_points" id="understanding_concern" name="data[understanding_concern]" disabled>
												<option superbill_ob_val=8 superbill_ob_max=8 <?php echo $superbill_outbound_data['understanding_concern'] == "Pass"?"selected":"";?> value="Pass">Pass</option>
												<option superbill_ob_val=0 superbill_ob_max=8 <?php echo $superbill_outbound_data['understanding_concern'] == "Fail"?"selected":"";?> value="Fail">Fail</option>
												<option superbill_ob_val=8 superbill_ob_max=8 <?php echo $superbill_outbound_data['understanding_concern'] == "NA"?"selected":"";?> value="NA">NA</option>
											</select>
										</td>
										
										<td><textarea class="form-control form_superbill" disabled name="data[cmt3]"><?php echo $superbill_outbound_data['cmt3'] ?></textarea>
										</td>
									</tr>
									<tr>
										<td>Non Fatal</td>
										<td>Voice Modulation & Rate of speech</td>
										<td>8</td>
										<td>
											<select class="form-control form_superbill superbill_ob_points" id="rate_of_speech" name="data[rate_of_speech]" disabled>
												<option superbill_ob_val=8 superbill_ob_max=8 <?php echo $superbill_outbound_data['rate_of_speech'] == "Pass"?"selected":"";?> value="Pass">Pass</option>
												<option superbill_ob_val=0 superbill_ob_max=8 <?php echo $superbill_outbound_data['rate_of_speech'] == "Fail"?"selected":"";?> value="Fail">Fail</option>
												<option superbill_ob_val=8 superbill_ob_max=8 <?php echo $superbill_outbound_data['rate_of_speech'] == "NA"?"selected":"";?> value="NA">NA</option>
											</select>
										</td>
										
										<td><textarea class="form-control form_superbill" disabled name="data[cmt4]"><?php echo $superbill_outbound_data['cmt4'] ?></textarea>
										</td>
									</tr>
									<tr>
										<td style="color:red;">Fatal</td>
										<td rowspan=1 style="background-color:red; font-weight:bold">Verification</td>
										<td>Tax ID authentication (Address & Expiry)</td>
										<td>14</td>
										<td>
											<select class="form-control form_superbill superbill_ob_points superbillAF_Fatal" id="superbillAF1" name="data[verification]" disabled>
												<option superbill_ob_val=14 superbill_ob_max=14 <?php echo $superbill_outbound_data['verification'] == "Pass"?"selected":"";?> value="Pass">Pass</option>
												<option superbill_ob_val=0 superbill_ob_max=14 <?php echo $superbill_outbound_data['verification'] == "Fail"?"selected":"";?> value="Fail">Fail</option>
												<option superbill_ob_val=14 superbill_ob_max=14 <?php echo $superbill_outbound_data['verification'] == "NA"?"selected":"";?> value="NA">NA</option>
											</select>
										</td>
										
										<td><textarea class="form-control form_superbill" disabled name="data[cmt5]"><?php echo $superbill_outbound_data['cmt5'] ?></textarea>
										</td>
									</tr>
									<tr>
										<td style="color:red;">Fatal</td>
										<td rowspan=2 style="background-color:red; font-weight:bold">Check points</td>
										<td>Registration and addition of Tax process (Incl. Website link / Contact details)</td>
										<td>14</td>
										<td>
											<select class="form-control form_superbill superbill_ob_points superbillAF_Fatal" id="superbillAF2" name="data[tax_process]" disabled>
												<option superbill_ob_val=14 superbill_ob_max=14 <?php echo $superbill_outbound_data['tax_process'] == "Pass"?"selected":"";?> value="Pass">Pass</option>
												<option superbill_ob_val=0 superbill_ob_max=14 <?php echo $superbill_outbound_data['tax_process'] == "Fail"?"selected":"";?> value="Fail">Fail</option>
												<option superbill_ob_val=14 superbill_ob_max=14 <?php echo $superbill_outbound_data['tax_process'] == "NA"?"selected":"";?> value="NA">NA</option>
											</select>
										</td>
										
										<td><textarea class="form-control form_superbill" disabled name="data[cmt6]"><?php echo $superbill_outbound_data['cmt6'] ?></textarea>
										</td>
									</tr>
									<tr>
										<td style="color:red;">Fatal</td>
										<td>Location and provided contact references</td>
										<td>14</td>
										<td>
											<select class="form-control form_superbill superbill_ob_points superbillAF_Fatal" id="superbillAF3" name="data[contact_references]" disabled>
												<option superbill_ob_val=14 superbill_ob_max=14 <?php echo $superbill_outbound_data['contact_references'] == "Pass"?"selected":"";?> value="Pass">Pass</option>
												<option superbill_ob_val=0 superbill_ob_max=14 <?php echo $superbill_outbound_data['contact_references'] == "Fail"?"selected":"";?> value="Fail">Fail</option>
												<option superbill_ob_val=14 superbill_ob_max=14 <?php echo $superbill_outbound_data['contact_references'] == "NA"?"selected":"";?> value="NA">NA</option>
											</select>
										</td>
										
										<td><textarea class="form-control form_superbill" disabled name="data[cmt7]"><?php echo $superbill_outbound_data['cmt7'] ?></textarea>
										</td>
									</tr>
									<tr>
										<td>Non Fatal</td>
										<td rowspan=2 style="background-color:#85C1E9; font-weight:bold">Documentation</td>
										<td>Escalated in slack (If loading issue)</td>
										<td>12</td>
										<td>
											<select class="form-control form_superbill superbill_ob_points" id="escalated_slack" name="data[escalated_slack]" disabled>
												<option superbill_ob_val=12 superbill_ob_max=12 <?php echo $superbill_outbound_data['escalated_slack'] == "Pass"?"selected":"";?> value="Pass">Pass</option>
												<option superbill_ob_val=0 superbill_ob_max=12 <?php echo $superbill_outbound_data['escalated_slack'] == "Fail"?"selected":"";?> value="Fail">Fail</option>
												<option superbill_ob_val=12 superbill_ob_max=12 <?php echo $superbill_outbound_data['escalated_slack'] == "NA"?"selected":"";?> value="NA">NA</option>
											</select>
										</td>
										
										<td><textarea class="form-control form_superbill" disabled name="data[cmt8]"><?php echo $superbill_outbound_data['cmt8'] ?></textarea>
										</td>
									</tr>
									<tr>
										<td>Non Fatal</td>
										<td>Additional comments</td>
										<td>12</td>
										<td>
											<select class="form-control form_superbill superbill_ob_points" id="additional_comments" name="data[additional_comments]" disabled>
												<option superbill_ob_val=12 superbill_ob_max=12 <?php echo $superbill_outbound_data['additional_comments'] == "Pass"?"selected":"";?> value="Pass">Pass</option>
												<option superbill_ob_val=0 superbill_ob_max=12 <?php echo $superbill_outbound_data['additional_comments'] == "Fail"?"selected":"";?> value="Fail">Fail</option>
												<option superbill_ob_val=12 superbill_ob_max=12 <?php echo $superbill_outbound_data['additional_comments'] == "NA"?"selected":"";?> value="NA">NA</option>
											</select>
										</td>
										
										<td><textarea class="form-control form_superbill" disabled name="data[cmt9]"><?php echo $superbill_outbound_data['cmt9'] ?></textarea>
										</td>
									</tr>
									<tr>
										<td>Non Fatal</td>
										<td rowspan=1 style="background-color:#85C1E9; font-weight:bold">Call Control & Closing</td>
										<td>Call closure in positive way</td>
										<td>5</td>
										<td>
											<select class="form-control form_superbill superbill_ob_points" id="call_control" name="data[call_control]" disabled>
												<option superbill_ob_val=5 superbill_ob_max=5 <?php echo $superbill_outbound_data['call_control'] == "Pass"?"selected":"";?> value="Pass">Pass</option>
												<option superbill_ob_val=0 superbill_ob_max=5 <?php echo $superbill_outbound_data['call_control'] == "Fail"?"selected":"";?> value="Fail">Fail</option>
												<option superbill_ob_val=5 superbill_ob_max=5 <?php echo $superbill_outbound_data['call_control'] == "NA"?"selected":"";?> value="NA">NA</option>
											</select>
										</td>
										
										<td><textarea class="form-control form_superbill" disabled name="data[cmt10]"><?php echo $superbill_outbound_data['cmt10'] ?></textarea>
										</td>
									</tr>
									<tr>
										<td>Call Summary:</td>
										<td colspan=2><textarea class="form-control form_superbill" disabled name="data[call_summary]"><?php echo $superbill_outbound_data['call_summary'] ?></textarea></td>
										<td>Feedback:</td>
										<td colspan=2><textarea class="form-control form_superbill" disabled name="data[feedback]"><?php echo $superbill_outbound_data['feedback'] ?></textarea></td>
									</tr>
									<?php if($superbill_outbound_data['attach_file']!=''){ ?>
									<tr oncontextmenu="return false;">
										<td colspan="2">Audio Files (Mp4/Mp3/M4a/Wav)</td>
										<td colspan="4">
											<?php $attach_file = explode(",",$superbill_outbound_data['attach_file']);
											 foreach($attach_file as $af){ ?>
												<audio oncontextmenu="return false;" controls controlslist="nodownload" style="background-color:#607F93">
													  <source src="<?php echo base_url(); ?>qa_files/superbill_outbound/<?php echo $af; ?>" type="audio/ogg">
													  <source src="<?php echo base_url(); ?>qa_files/superbill_outbound/<?php echo $af; ?>" type="audio/mpeg">
												</audio> </br>
											 <?php } ?>
										</td>
									</tr>
									<?php } ?>

									<tr>
										<td style="font-size:12px">Manager Review:</td>
										<td colspan="8" style="text-align:left"><?php echo $superbill_outbound_data['mgnt_rvw_note'] ?></td>
									</tr>
									<tr>
										<td style="font-size:12px">Client Review:</td>
										<td colspan="8" style="text-align:left"><?php echo $superbill_outbound_data['client_rvw_note'] ?></td>
									</tr>

									<tr><td colspan="10" style="background-color:#C5C8C8"></td></tr>
									
									 <form id="form_agent_user" method="POST" action="">
										<input type="hidden" name="superbill_outbound_id" class="form-control" value="<?php echo $superbill_outbound_id; ?>">
										
										<tr>
											<td colspan=2 style="font-size:16px">Feedback Acceptance<span style="font-size:24px;color:red">*</span></td>
											<td colspan=6>
												<select class="form-control" id="" name="agnt_fd_acpt" required="">
													<option value="">--Select--</option>
													<option <?php echo $superbill_outbound_data['agnt_fd_acpt']=='Acceptance'?"selected":""; ?> value="Acceptance">Acceptance</option>	
													<option <?php echo $superbill_outbound_data['agnt_fd_acpt']=='Not Acceptance'?"selected":""; ?> value="Not Acceptance">Not Acceptance</option>	
												</select>
											</td>
										</tr>
										<tr>
											<td colspan=2 style="font-size:16px">Your Review<span style="font-size:24px;color:red">*</span></td>
											<td colspan=6><textarea class="form-control" name="note" required><?php echo $superbill_outbound_data['agent_rvw_note'] ?></textarea></td>
										</tr>
										
										<?php if(is_access_qa_agent_module()==true){
										if(is_available_qa_feedback($superbill_outbound_data['entry_date'],72) == true){ ?>
											<tr>
												<?php if($superbill_outbound_data['agent_rvw_note']==''){ ?>
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
