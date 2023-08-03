<style>

.table > tbody > tr > td{
	text-align: center;
	font-size:13px;
}

#theader{
	font-size:20px;
	font-weight:bold;
	background-color:#CA6F1E;
}

input[type='checkbox']{
	width: 20px;
}

#fatalspan1{

	background-color: transparent;
	border: none;
	outline: none;
	color: white;
}
.ui-datepicker .ui-datepicker-buttonpane button.ui-datepicker-current {
	 float: left;
	 display: none;
	}

</style>


<div class="wrap">
	<section class="app-content">
		<?php if($campaign=='call'){ ?>
			
			<div class="row">
			<div class="col-12">
				<div class="widget">

				  <form id="form_audit_user" method="POST" action="" enctype="multipart/form-data">
					
					<div class="widget-body">
					 	<div class="table-responsive">
							<table class="table table-striped skt-table" width="100%">
								<tbody>
									<tr style="background-color:#AEB6BF">
										<td colspan="6" id="theader">VFS Call Monitoring Form </td>
										<span type="hidden" name="audit_start_time" value="<?php echo CurrMySqlDate(); ?>">
									</tr>
									<tr>
									<?php
										
											if($agent_vfs['entry_by']!=''){
												$auditorName = $agent_vfs['auditor_name'];
											}else{
												$auditorName = $agent_vfs['client_name'];
											}
											$auditDate = mysql2mmddyy($agent_vfs['audit_date']);
											$clDate_val=mysql2mmddyy($agent_vfs['call_date']);
										
									?>
										<td>QA Name:<span style="font-size:24px;color:red">*</span></td>
										<td style="width:300px"><input type="text" class="form-control" value="<?php echo $auditorName; ?>" disabled></td>
										<td style="width:150px">Audit Date:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control" value="<?php echo $auditDate; ?>" disabled></td>
										<td>Call Date:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control" id="call_date" name="call_date" onkeydown="return false;" value="<?php echo $clDate_val; ?>" disabled></td>
									</tr>
									<tr>
										<td>Agent Name:<span style="font-size:24px;color:red">*</span></td>
										<td>
											<select class="form-control" id="agent_id" name="agent_id" disabled>
												<option value="<?php echo $agent_vfs['agent_id'] ?>"><?php echo $agent_vfs['fname']." ".$agent_vfs['lname'] ?></option>
												<option value="">-Select-</option>
												<?php foreach($agentName as $row):  ?>
													<option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
												<?php endforeach; ?>
											</select>
										</td>
										<td>Fusion ID:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control" id="fusion_id" name="" value="<?php echo $agent_vfs['fusion_id']; ?>" readonly></td>
										<td>L1 Supervisor:<span style="font-size:24px;color:red">*</span></td>
										<td style="width:250px">
											<input type="text" class="form-control" id="tl_name"  value="<?php echo $agent_vfs['tl_name']; ?>" readonly>
												<input type="hidden" class="form-control" id="tl_id" name="tl_id" value="<?php echo $agent_vfs['tl_id'] ?>" disabled>
										</td>
									</tr>
									<tr>
										<td>Call Duration:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control" id="call_duration" name="call_duration" onkeydown="return false;" value="<?php echo $agent_vfs['call_duration']; ?>" disabled></td>
										<td>Mission:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control"  name="mission" value="<?php echo $agent_vfs['mission']; ?>" disabled></td>
										<td>Recording ID:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control"  name="recording_id" value="<?php echo $agent_vfs['recording_id']; ?>" disabled></td>
									</tr>
									<tr>
										<td>Week:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control"  name="week" value="<?php echo $agent_vfs['week']; ?>" disabled></td>
										
										<td>Fatal Error?:<span style="font-size:24px;color:red">*</span></td>
										<td>
											<select class="form-control" id="" name="autofail_status" disabled>
												<option value="">-Select-</option>
												<option <?php echo $agent_vfs['autofail_status']=='Fatal'?"selected":""; ?> value="Fatal">Fatal</option>
												<option <?php echo $agent_vfs['autofail_status']=='Non Fatal'?"selected":""; ?> value="Non Fatal">Non Fatal</option>
											</select>
										</td>
										
										<td>Host/Country:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control" name="host_country" value="<?php echo $agent_vfs['host_country']; ?>" disabled></td>
									</tr>
									<tr>
										<td>Agent Tenurity:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control" name="tenurity" id="tenure" value="<?php echo $agent_vfs['tenurity']; ?>" readonly></td>
										<td>VOC:<span style="font-size:24px;color:red">*</span></td>
										<td>
											<select class="form-control" id="voc" name="voc" disabled>
												<option value="">-Select-</option>
												<option <?php echo $agent_vfs['voc']=='1'?"selected":""; ?> value="1">1</option>
												<option <?php echo $agent_vfs['voc']=='2'?"selected":""; ?> value="2">2</option>
												<option <?php echo $agent_vfs['voc']=='3'?"selected":""; ?> value="3">3</option>
												<option <?php echo $agent_vfs['voc']=='4'?"selected":""; ?> value="4">4</option>
												<option <?php echo $agent_vfs['voc']=='5'?"selected":""; ?> value="5">5</option>
											</select>
										</td>
										<td>ACPT:<span style="font-size:24px;color:red">*</span></td>
										<td>
												<select class="form-control" id="" name="acpt" disabled>
													<option value="">-Select-</option>
													<option value="Agent"  <?= ($agent_vfs['acpt']=="Agent")?"selected":"" ?>>Agent</option>
													<option value="Process"  <?= ($agent_vfs['acpt']=="Process")?"selected":"" ?>>Process</option>
													<option value="Customer"  <?= ($agent_vfs['acpt']=="Customer")?"selected":"" ?>>Customer</option>
													<option value="Technology"  <?= ($agent_vfs['acpt']=="Technology")?"selected":"" ?>>Technology</option>
													<option value="NA"  <?= ($agent_vfs['acpt']=="NA")?"selected":"" ?>>NA</option>
												</select>
											</td>
									</tr>
									<tr>
										<td>Audit Type:<span style="font-size:24px;color:red">*</span></td>
										<td>
											<select class="form-control" id="audit_type" name="audit_type" disabled>
                                                    <option value="">-Select-</option>
                                                    <option value="CQ Audit" <?= ($agent_vfs['audit_type']=="CQ Audit")?"selected":"" ?>>CQ Audit</option>
                                                    <option value="BQ Audit" <?= ($agent_vfs['audit_type']=="BQ Audit")?"selected":"" ?>>BQ Audit</option>
                                                    <option value="Calibration" <?= ($agent_vfs['audit_type']=="Calibration")?"selected":"" ?>>Calibration</option>
                                                    <option value="Pre-Certificate Mock Call" <?= ($agent_vfs['audit_type']=="Pre-Certificate Mock Call")?"selected":"" ?>>Pre-Certificate Mock Call</option>
                                                    <option value="Certification Audit" <?= ($agent_vfs['audit_type']=="Certification Audit")?"selected":"" ?>>Certification Audit</option>
                                                    <option value="WoW Call"  <?= ($agent_vfs['audit_type']=="WoW Call")?"selected":"" ?>>WoW Call</option>
                                                    <option value="Hygiene Audit"  <?= ($agent_vfs['audit_type']=="Hygiene Audit")?"selected":"" ?>>Hygiene Audit</option>
                                                    <option value="Operation Audit"  <?= ($agent_vfs['audit_type']=="Operation Audit")?"selected":"" ?>>Operation Audit</option>
                                                    <option value="Trainer Audit"  <?= ($agent_vfs['audit_type']=="Trainer Audit")?"selected":"" ?>>Trainer Audit</option> 
                                                    <option value="QA Supervisor Audit"  <?= ($agent_vfs['audit_type']=="QA Supervisor Audit")?"selected":"" ?>>QA Supervisor Audit</option> 
                                                </select>
										</td>
										<td class="auType">Auditor Type<span style="font-size:24px;color:red">*</span></td>
										<td class="auType">
											<select class="form-control" id="auditor_type" name="auditor_type">
												<option value="Master" <?= ($agent_vfs['auditor_type']=="Master")?"selected":"" ?>>Master</option> 
												 <option value="Regular" <?= ($agent_vfs['auditor_type']=="Regular")?"selected":"" ?>>Regular</option> 
											</select>
										</td>
									</tr>
									<tr>
										<td style="font-weight:bold">Earned Score:</td>
										<td><input type="text" readonly id="vfsEarned" name="earned_score" class="form-control" style="font-weight:bold" value="<?php echo $agent_vfs['overall_score'] ?>"></td>
										<td style="font-weight:bold">Possible Score:</td>
										<td><input type="text" readonly id="vfsPossible" name="possible_score" class="form-control" style="font-weight:bold" value="<?php echo $agent_vfs['overall_score'] ?>"></td>
										<td style="font-weight:bold">Overall Score Percentage:</td>
										<td><input type="text" readonly id="vfsOverallScore" name="overall_score" class="form-control vfsCallFatal" style="font-weight:bold" value="<?php echo $agent_vfs['overall_score'] ?>"></td>
									</tr>	
																	
									<tr style="font-weight:bold; background-color:#2471A3; color:white">
										<td colspan=2>Parameters</td>
										<td>Weightage</td>
										<td>Rating</td>
										<td>Final Score</td>
										<td>Remarks</td>
									</tr>
									<tr>
										<td style="background-color:#BFC9CA"><b>1</b></td>
										<td colspan=1 style="background-color:#BFC9CA">Opening</td>
										<td style="background-color:#BFC9CA">5</td>
										<td style="background-color:#BFC9CA"></td>
										<td style="background-color:#BFC9CA" id="score_opening">5</td>
										<td style="background-color:#BFC9CA"></td>
									</tr>
									<tr>
										<td></td>
										<td colspan=1>a.Appropriate greeting - as per script & Clear and Crisp opening</td>
										<td>5</td>
										<td>
											<select class="form-control vfsVal" data-id="opening"  name="appropiate_greeting" disabled>
												<option vfs_val=5 vfs_max='5' <?php echo $agent_vfs['appropiate_greeting']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option vfs_val=0 vfs_max='5' <?php echo $agent_vfs['appropiate_greeting']=='No'?"selected":""; ?> value="No">No</option>
												<option vfs_val=5 vfs_max='5' <?php echo $agent_vfs['appropiate_greeting']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td id="score_appropiate_greeting">5</td>
										<td><textarea class="form-control" disabled name="comm0"><?php echo $agent_vfs['comm0'] ?></textarea></td>
									</tr>
									<tr>
										<td style="background-color:#BFC9CA"><b>2</b></td>
										<td colspan=1 style="background-color:#BFC9CA">Communication</td>
										<td style="background-color:#BFC9CA">30</td>
										<td style="background-color:#BFC9CA"></td>
										<td style="background-color:#BFC9CA" id="score_communication">30</td>
										<td style="background-color:#BFC9CA"></td>
									</tr>
									<tr>
										<td></td>
										<td colspan=1>a. Voice modulation (Maintained proper tone, pitch, & volume throughout the call) & Appropriate pace & clarity of speech</td>
										<td>5</td>
										<td>
											<select class="form-control vfsVal" data-id="communication"  name="voice_modulation" disabled>
												<option vfs_val=5 vfs_max='5' <?php echo $agent_vfs['voice_modulation']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option vfs_val=0 vfs_max='5' <?php echo $agent_vfs['voice_modulation']=='No'?"selected":""; ?> value="No">No</option>
												<option vfs_val=5 vfs_max='5' <?php echo $agent_vfs['voice_modulation']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td id="score_voice_modulation">5</td>
										<td><textarea class="form-control" disabled name="comm1"><?php echo $agent_vfs['comm1'] ?></textarea></td>
									</tr>
									<tr>
										<td></td>
										<td colspan=1>b. Empathy on call & Personalization / Power words</td>
										<td>5</td>
										<td>
											<select class="form-control vfsVal" data-id="communication"  name="call_empathy" disabled>
												<option vfs_val=5 vfs_max='5' <?php echo $agent_vfs['call_empathy']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option vfs_val=0 vfs_max='5' <?php echo $agent_vfs['call_empathy']=='No'?"selected":""; ?> value="No">No</option>
												<option vfs_val=5 vfs_max='5' <?php echo $agent_vfs['call_empathy']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td id="score_call_empathy">5</td>
										<td><textarea class="form-control" disabled name="comm2"><?php echo $agent_vfs['comm2'] ?></textarea></td>
									</tr>
									<tr>
										<td></td>
										<td colspan=1>c. Adjusted to customer language & Courteous & Professional</td>
										<td>5</td>
										<td>
											<select class="form-control vfsVal" data-id="communication"  name="adjust_customer_language" disabled>
												<option vfs_val=5 vfs_max='5' <?php echo $agent_vfs['adjust_customer_language']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option vfs_val=0 vfs_max='5' <?php echo $agent_vfs['adjust_customer_language']=='No'?"selected":""; ?> value="No">No</option>
												<option vfs_val=5 vfs_max='5' <?php echo $agent_vfs['adjust_customer_language']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td id="score_adjust_customer_language">5</td>
										<td><textarea class="form-control" disabled name="comm3"><?php echo $agent_vfs['comm3'] ?></textarea></td>
									</tr>
									<tr>
										<td></td>
										<td colspan=1>d. No jargons - simple words used & Avoid fumbling & fillers</td>
										<td>5</td>
										<td>
											<select class="form-control vfsVal" data-id="communication"  name="simple_word_used" disabled>
												<option vfs_val=5 vfs_max='5' <?php echo $agent_vfs['simple_word_used']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option vfs_val=0 vfs_max='5' <?php echo $agent_vfs['simple_word_used']=='No'?"selected":""; ?> value="No">No</option>
												<option vfs_val=5 vfs_max='5' <?php echo $agent_vfs['simple_word_used']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td id="score_simple_word_used">5</td>
										<td><textarea class="form-control" disabled name="comm4"><?php echo $agent_vfs['comm4'] ?></textarea></td>
									</tr>
									<tr>
										<td></td>
										<td colspan=1>e. Active listening / Attentiveness & Paraphrasing & Acknowledgment</td>
										<td>5</td>
										<td>
											<select class="form-control vfsVal" data-id="communication"  name="active_listening" disabled>
												<option vfs_val=5 vfs_max='5' <?php echo $agent_vfs['active_listening']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option vfs_val=0 vfs_max='5' <?php echo $agent_vfs['active_listening']=='No'?"selected":""; ?> value="No">No</option>
												<option vfs_val=5 vfs_max='5' <?php echo $agent_vfs['active_listening']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td id="score_active_listening">5</td>
										<td><textarea class="form-control" disabled name="comm5"><?php echo $agent_vfs['comm5'] ?></textarea></td>
									</tr>
									<tr>
										<td></td>
										<td colspan=1>f. Grammatically correct sentences & Comprehension</td>
										<td>5</td>
										<td>
											<select class="form-control vfsVal" data-id="communication"  name="avoid_fumbling" disabled>
												<option vfs_val=5 vfs_max='5' <?php echo $agent_vfs['avoid_fumbling']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option vfs_val=0 vfs_max='5' <?php echo $agent_vfs['avoid_fumbling']=='No'?"selected":""; ?> value="No">No</option>
												<option vfs_val=5 vfs_max='5' <?php echo $agent_vfs['avoid_fumbling']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td id="score_avoid_fumbling">5</td>
										<td><textarea class="form-control" disabled name="comm6"><?php echo $agent_vfs['comm6'] ?></textarea></td>
									</tr>
									<tr>
										<td style="background-color:#BFC9CA"><b>3</b></td>
										<td colspan=1 style="background-color:#BFC9CA">Technical aspects</td>
										<td style="background-color:#BFC9CA">30</td>
										<td style="background-color:#BFC9CA"></td>
										<td style="background-color:#BFC9CA" id="score_technical_aspects">30</td>
										<td style="background-color:#BFC9CA"></td>
									</tr>
									<tr>
										<td></td>										
										<td colspan=1>a. Appropriate Probing</td>
										<td>5</td>
										<td>
											<select class="form-control vfsVal" data-id="technical_aspects" name="appropiate_probing" disabled>
												<option vfs_val=5 vfs_max='5' <?php echo $agent_vfs['appropiate_probing']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option vfs_val=0 vfs_max='5' <?php echo $agent_vfs['appropiate_probing']=='No'?"selected":""; ?> value="No">No</option>
												<option vfs_val=5 vfs_max='5' <?php echo $agent_vfs['appropiate_probing']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td id="score_appropiate_probing">5</td>
										<td><textarea class="form-control" disabled name="comm7"><?php echo $agent_vfs['comm7'] ?></textarea></td>
									</tr>
									<tr>
										<td></td>										
										<td colspan=1>b. Took ownership to resolve customer's concern</td>
										<td>5</td>
										<td>
											<select class="form-control vfsVal" data-id="technical_aspects" name="ownership_resolve" disabled>
												<option vfs_val=5 vfs_max='5' <?php echo $agent_vfs['ownership_resolve']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option vfs_val=0 vfs_max='5' <?php echo $agent_vfs['ownership_resolve']=='No'?"selected":""; ?> value="No">No</option>
												<option vfs_val=5 vfs_max='5' <?php echo $agent_vfs['ownership_resolve']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td id="score_ownership_resolve">5</td>
										<td><textarea class="form-control" disabled name="comm8"><?php echo $agent_vfs['comm8'] ?></textarea></td>
									</tr>
									<tr><td></td>
										<td colspan=1>c. Escalate the issue wherever disabled</td>
										<td>5</td>
										<td>
											<select class="form-control vfsVal" data-id="technical_aspects"  name="escalate_issue" disabled>
												<option vfs_val=5 vfs_max='5' <?php echo $agent_vfs['escalate_issue']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option vfs_val=0 vfs_max='5' <?php echo $agent_vfs['escalate_issue']=='No'?"selected":""; ?> value="No">No</option>
												<option vfs_val=5 vfs_max='5' <?php echo $agent_vfs['escalate_issue']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td id="score_escalate_issue">5</td>
										<td><textarea class="form-control" disabled name="comm9"><?php echo $agent_vfs['comm9'] ?></textarea></td>
									</tr>
									<tr><td></td>
										<td colspan=1>d. Call control</td>
										<td>5</td>
										<td>
											<select class="form-control vfsVal" data-id="technical_aspects"  name="call_control" disabled>
												<option vfs_val=5 vfs_max='5' <?php echo $agent_vfs['call_control']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option vfs_val=0 vfs_max='5' <?php echo $agent_vfs['call_control']=='No'?"selected":""; ?> value="No">No</option>
												<option vfs_val=5 vfs_max='5' <?php echo $agent_vfs['call_control']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td id="score_call_control">5</td>
										<td><textarea class="form-control" disabled name="comm10"><?php echo $agent_vfs['comm10'] ?></textarea></td>
									</tr>
									<tr><td></td>
										<td colspan=1>e. Query resolved on call - FTR</td>
										<td>5</td>
										<td>
											<select class="form-control vfsVal" data-id="technical_aspects"  name="query_resolved" disabled>
												<option vfs_val=5 vfs_max='5' <?php echo $agent_vfs['query_resolved']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option vfs_val=0 vfs_max='5' <?php echo $agent_vfs['query_resolved']=='No'?"selected":""; ?> value="No">No</option>
												<option vfs_val=5 vfs_max='5' <?php echo $agent_vfs['query_resolved']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td id="score_query_resolved">5</td>
										<td><textarea class="form-control" disabled name="comm11"><?php echo $agent_vfs['comm11'] ?></textarea></td>
									</tr>
									<tr><td></td>
										<td colspan=1>f. Step by step procuedure to resolve the QRC(Query/Request/Complaint)</td>
										<td>5</td>
										<td>
											<select class="form-control vfsVal" data-id="technical_aspects"  name="procuedure_request" disabled>
												<option vfs_val=5 vfs_max='5' <?php echo $agent_vfs['procuedure_request']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option vfs_val=0 vfs_max='5' <?php echo $agent_vfs['procuedure_request']=='No'?"selected":""; ?> value="No">No</option>
												<option vfs_val=5 vfs_max='5' <?php echo $agent_vfs['procuedure_request']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td id="score_procuedure_request">5</td>
										<td><textarea class="form-control" disabled name="comm12"><?php echo $agent_vfs['comm12'] ?></textarea></td>
									</tr>
									<tr>
										<td style="background-color:#BFC9CA"><b>4</b></td>
										<td colspan=1 style="background-color:#BFC9CA">Value Additons</td>
										<td style="background-color:#BFC9CA">10</td>
										<td style="background-color:#BFC9CA"></td>
										<td style="background-color:#BFC9CA" id="score_additons">10</td>
										<td style="background-color:#BFC9CA"></td>
									</tr>
									<tr>
										<td></td>										
										<td colspan=1>a. Offers VAS options wherever applicable</td>
										<td>5</td>
										<td>
											<select class="form-control vfsVal" data-id="additons"  name="offers_VAS" disabled>
												<option vfs_val=5 vfs_max='5' <?php echo $agent_vfs['offers_VAS']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option vfs_val=0 vfs_max='5' <?php echo $agent_vfs['offers_VAS']=='No'?"selected":""; ?> value="No">No</option>
												<option vfs_val=5 vfs_max='5' <?php echo $agent_vfs['offers_VAS']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td id="score_offers_VAS">5</td>
										<td><textarea class="form-control" disabled name="comm13"><?php echo $agent_vfs['comm13'] ?></textarea></td>
									</tr>
									<tr>
										<td></td>
										<td colspan=1>b. Awareness created with regards to VFS website (wherever applicable)</td>
										<td>5</td>
										<td>
											<select class="form-control vfsVal" data-id="additons"  name="awareness_created" disabled>
												<option vfs_val=5 vfs_max='5' <?php echo $agent_vfs['awareness_created']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option vfs_val=0 vfs_max='5' <?php echo $agent_vfs['awareness_created']=='No'?"selected":""; ?> value="No">No</option>
												<option vfs_val=5 vfs_max='5' <?php echo $agent_vfs['awareness_created']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td id="score_awareness_created">5</td>
										<td><textarea class="form-control" disabled name="comm14"><?php echo $agent_vfs['comm14'] ?></textarea></td>
									</tr>
									<tr>
										<td style="background-color:#BFC9CA"><b>5</b></td>
										<td colspan=1 style="background-color:#BFC9CA">Documentation</td>
										<td style="background-color:#BFC9CA">10</td>
										<td style="background-color:#BFC9CA"></td>
										<td style="background-color:#BFC9CA" id="score_documentation">10</td>
										<td style="background-color:#BFC9CA"></td>
									</tr>
									<tr>
										<td></td>										
										<td colspan=1>a. Correct dispostion</td>
										<td>5</td>
										<td>
											<select class="form-control vfsVal" data-id="documentation"  name="correct_disposition" disabled>
												<option vfs_val=5 vfs_max='5' <?php echo $agent_vfs['correct_disposition']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option vfs_val=0 vfs_max='5' <?php echo $agent_vfs['correct_disposition']=='No'?"selected":""; ?> value="No">No</option>
												<option vfs_val=5 vfs_max='5' <?php echo $agent_vfs['correct_disposition']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td id="score_correct_disposition">5</td>
										<td><textarea class="form-control" disabled name="comm15"><?php echo $agent_vfs['comm15'] ?></textarea></td>
									</tr>
									<tr>
										<td></td>
										<td colspan=1>b. Update ASM/V2</td>
										<td>5</td>
										<td>
											<select class="form-control vfsVal" data-id="documentation"  name="update_ASM" disabled>
												<option vfs_val=5 vfs_max='5' <?php echo $agent_vfs['update_ASM']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option vfs_val=0 vfs_max='5' <?php echo $agent_vfs['update_ASM']=='No'?"selected":""; ?> value="No">No</option>
												<option vfs_val=5 vfs_max='5' <?php echo $agent_vfs['update_ASM']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td id="score_update_ASM">5</td>
										<td><textarea class="form-control" disabled name="comm16"><?php echo $agent_vfs['comm16'] ?></textarea></td>
									</tr>
									<tr>
										<td style="background-color:#BFC9CA"><b>6</b></td>
										<td colspan=1 style="background-color:#BFC9CA">Hold Protocol</td>
										<td style="background-color:#BFC9CA">5</td>
										<td style="background-color:#BFC9CA"></td>
										<td style="background-color:#BFC9CA" id="score_hold_protocol">5</td>
										<td style="background-color:#BFC9CA"></td>
									</tr>
									<tr>
										<td></td>
										<td colspan=1>a. Hold Guidelines followed</td>
										<td>5</td>
										<td>
											<select class="form-control vfsVal" data-id="hold_protocol"  name="hold_disabled" disabled>
												<option vfs_val=5 vfs_max='5' <?php echo $agent_vfs['hold_disabled']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option vfs_val=0 vfs_max='5' <?php echo $agent_vfs['hold_disabled']=='No'?"selected":""; ?> value="No">No</option>
												<option vfs_val=5 vfs_max='5' <?php echo $agent_vfs['hold_disabled']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td id="score_hold_disabled">5</td>
										<td><textarea class="form-control" disabled name="comm17"><?php echo $agent_vfs['comm17'] ?></textarea></td>
									</tr>
									<tr>
										<td style="background-color:#BFC9CA"><b>7</b></td>
										<td colspan=1 style="background-color:#BFC9CA">Call Closing</td>
										<td style="background-color:#BFC9CA">10</td>
										<td style="background-color:#BFC9CA"></td>
										<td style="background-color:#BFC9CA" id="score_call_closing">10</td>
										<td style="background-color:#BFC9CA"></td>
									</tr>
									<tr>
										<td></td>
										<td colspan=1>a. Further assistance & Adherence to call closing script</td>
										<td>5</td>
										<td>
											<select class="form-control vfsVal" data-id="call_closing"  name="further_assistance" disabled>
												<option vfs_val=5 vfs_max='5' <?php echo $agent_vfs['further_assistance']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option vfs_val=0 vfs_max='5' <?php echo $agent_vfs['further_assistance']=='No'?"selected":""; ?> value="No">No</option>
												<option vfs_val=5 vfs_max='5' <?php echo $agent_vfs['further_assistance']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td id="score_further_assistance">5</td>
										<td><textarea class="form-control" disabled name="comm18"><?php echo $agent_vfs['comm18'] ?></textarea></td>
									</tr>
									<tr>
										<td></td>
										<td colspan=1>b. Attempt to take feedback on experience  - CSAT</td>
										<td>5</td>
										<td>
											<select class="form-control vfsVal" data-id="call_closing"  name="CSAT_experience_feedback" disabled>
												<option vfs_val=5 vfs_max='5' <?php echo $agent_vfs['CSAT_experience_feedback']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option vfs_val=0 vfs_max='5' <?php echo $agent_vfs['CSAT_experience_feedback']=='No'?"selected":""; ?> value="No">No</option>
												<option vfs_val=5 vfs_max='5' <?php echo $agent_vfs['CSAT_experience_feedback']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td id="score_CSAT_experience_feedback">5</td>
										<td><textarea class="form-control" disabled name="comm19"><?php echo $agent_vfs['comm19'] ?></textarea></td>
									</tr>
									<tr>
										<td style="background-color:#BFC9CA"><b>8</b></td>
										<td colspan=1 style="background-color:#BFC9CA">Fatal Parameter</td>
										<td style="background-color:#BFC9CA"></td>
										<td style="background-color:#BFC9CA"></td>
										<td style="background-color:#BFC9CA"></td>
										<td style="background-color:#BFC9CA"></td>
									</tr>
									<tr>
										<td></td>
										<td colspan=1 style="background-color:#D98880">a. Delayed opening</td>
										<td></td>
										<td>
											<select class="form-control vfsVal fatal_epi" id="callAutof1" name="delayed_opening" disabled>
												<option vfs_val=0 vfs_max=0 <?php echo $agent_vfs['delayed_opening']=='No'?"selected":""; ?> value="No">No</option>
												<option vfs_val=0 vfs_max=0  <?php echo $agent_vfs['delayed_opening']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
											</select>
										</td>
										<td></td>
										<td><textarea class="form-control" disabled name="comm20"><?php echo $agent_vfs['comm20'] ?></textarea></td>
									</tr>
									<tr>
										<td></td>
										<td colspan=1 style="background-color:#D98880">b. Rude on chat</td>
										<td></td>
										<td>
											<select class="form-control vfsVal fatal_epi" id="callAutof2" name="rude_on_call" disabled>
												<option vfs_val=0 vfs_max=0  <?php echo $agent_vfs['rude_on_call']=='No'?"selected":""; ?> value="No">No</option>
												<option vfs_val=0 vfs_max=0  <?php echo $agent_vfs['rude_on_call']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
											</select>
										</td>
										<td></td>
										<td><textarea class="form-control" disabled name="comm21"><?php echo $agent_vfs['comm21'] ?></textarea></td>
									</tr>
									<tr>
										<td></td>
										<td colspan=1 style="background-color:#D98880">c. Incomplete/Inaccurate Information shared</td>
										<td></td>
										<td>
											<select class="form-control vfsVal fatal_epi" id="callAutof3" name="incomplete_information" disabled>
												<option vfs_val=0 vfs_max=0  <?php echo $agent_vfs['incomplete_information']=='No'?"selected":""; ?> value="No">No</option>
												<option vfs_val=0 vfs_max=0  <?php echo $agent_vfs['incomplete_information']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
											</select>
										</td>
										<td></td>
										<td><textarea class="form-control" disabled name="comm22"><?php echo $agent_vfs['comm22'] ?></textarea></td>
									</tr>
									<tr>
										<td></td>
										<td colspan=1 style="background-color:#D98880">d. Complaint Avoidance</td>
										<td></td>
										<td>
											<select class="form-control vfsVal fatal_epi" id="callAutof4" name="complaint_avoidance" disabled>
												<option vfs_val=0 vfs_max=0  <?php echo $agent_vfs['complaint_avoidance']=='No'?"selected":""; ?> value="No">No</option>
												<option vfs_val=0 vfs_max=0  <?php echo $agent_vfs['complaint_avoidance']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
											</select>
										</td>
										<td></td>
										<td><textarea class="form-control" disabled name="comm23"><?php echo $agent_vfs['comm23'] ?></textarea></td>
									</tr>
									
									<tr>
										<td style="background-color:#BFC9CA"><b>9</b></td>
										<td colspan=1 style="background-color:#BFC9CA">First Time Resolution (FTR)</td>
										<td style="background-color:#BFC9CA"></td>
										<td style="background-color:#BFC9CA"></td>
										<td style="background-color:#BFC9CA"></td>
										<td style="background-color:#BFC9CA"></td>
									</tr>
									<tr>
										<td></td>
										<td colspan=1>a. Disposition</td>
										<td></td>
										<td>
											<input type="text" class="form-control" id="disposition" disabled name="disposition" value="<?php echo $agent_vfs['disposition']; ?>">
										</td>
										<td></td>
										<td><!-- <textarea class="form-control" name="comm19"><?php //echo $agent_vfs['comm19'] ?></textarea> --></td>
									</tr>
									<tr>
										<td></td>
										<td colspan=1>b. Communication mode through which customer contacted previously</td>
										<td></td>
										<td>
											<input type="text" class="form-control" id="contacted_previously" disabled name="contacted_previously" value="<?php echo $agent_vfs['contacted_previously']; ?>">
										</td>
										<td id=""></td>
										<td></td>
									</tr>
									<tr>
										<td></td>
										<td colspan=1>c. Description of Disposition selected</td>
										<td></td>
										<td>
											<input type="text" class="form-control" id="disposition_selected" disabled name="disposition_selected" value="<?php echo $agent_vfs['disposition_selected']; ?>">
										</td>
										<td id=""></td>
										<td></td>
									</tr>
									<tr>
										<td></td>
										<td colspan=1>d. Was this the first time customer called us ?</td>
										<td></td>
										<td>
											<select class="form-control" id="customer_called_first" name="customer_called_first" disabled>
												<option value="">-Select-</option>
												<option <?php echo $agent_vfs['customer_called_first']=='No'?"selected":""; ?> value="No">No</option>
												<option <?php echo $agent_vfs['customer_called_first']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
											</select>
										</td>
										<td id=""></td>
										<td><textarea class="form-control" disabled name="comm24"><?php echo $agent_vfs['comm24'] ?></textarea></td>
									</tr>
									<tr>
										<td></td>
										<td colspan=1>e. Did the customer call us more than once but less than 3 times ?</td>
										<td></td>
										<td>
											<select class="form-control" id="customer_called_less_three" name="customer_called_less_three" disabled>
												<option value="">-Select-</option>
												<option <?php echo $agent_vfs['customer_called_less_three']=='No'?"selected":""; ?> value="No">No</option>
												<option <?php echo $agent_vfs['customer_called_less_three']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
											</select>
										</td>
										<td id=""></td>
										<td><textarea class="form-control" disabled name="comm25"><?php echo $agent_vfs['comm25'] ?></textarea></td>
									</tr>
									<tr>
										<td></td>
										<td colspan=1>f. Did the customer call us more than 3 times ?</td>
										<td></td>
										<td>
											<select class="form-control" id="customer_called_more_three" name="customer_called_more_three" disabled>
												<option value="">-Select-</option>
												<option <?php echo $agent_vfs['customer_called_more_three']=='No'?"selected":""; ?> value="No">No</option>
												<option <?php echo $agent_vfs['customer_called_more_three']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
											</select>
										</td>
										<td id=""></td>
										<td><textarea class="form-control" disabled name="comm26"><?php echo $agent_vfs['comm26'] ?></textarea></td>
									</tr>
									
									<tr>
										<td>Call Summary:</td>
										<td colspan=2><textarea class="form-control"  disabled name="call_summary"><?php echo $agent_vfs['call_summary'] ?></textarea></td>
										<td>Feedback:</td>
										<td colspan=2><textarea class="form-control"  disabled name="feedback"><?php echo $agent_vfs['feedback'] ?></textarea></td>
									</tr>
									<?php if($agent_vfs['attach_file']!=''){ ?>
									<tr oncontextmenu="return false;">
										<td colspan="2">Audio Files (Mp4/Mp3/M4a/Wav)</td>
										<td colspan="4">
											<?php $attach_file = explode(",",$agent_vfs['attach_file']);
											 foreach($attach_file as $af){ ?>
												<audio oncontextmenu="return false;" controls controlslist="nodownload" style="background-color:#607F93">
													  <source src="<?php echo base_url(); ?>qa_files/qa_vfs/call/<?php echo $af; ?>" type="audio/ogg">
													  <source src="<?php echo base_url(); ?>qa_files/qa_vfs/call/<?php echo $af; ?>" type="audio/mpeg">
												</audio> </br>
											 <?php } ?>
										</td>
									</tr>
									<?php } ?>

									<tr>
										<td style="font-size:12px">Manager Review:</td>
										<td colspan="8" style="text-align:left"><?php echo $agent_vfs['mgnt_rvw_note'] ?></td>
									</tr>
									<tr>
										<td style="font-size:12px">Client Review:</td>
										<td colspan="8" style="text-align:left"><?php echo $agent_vfs['client_rvw_note'] ?></td>
									</tr>

									<tr><td colspan="10" style="background-color:#C5C8C8"></td></tr>
									
									 <form id="form_agent_user" method="POST" action="">
										<input type="hidden" name="pnid" class="form-control" value="<?php echo $pnid; ?>">
										
										<tr>
											<td colspan=2 style="font-size:16px">Feedback Acceptance<span style="font-size:24px;color:red">*</span></td>
											<td colspan=6>
												<select class="form-control" id="" name="agnt_fd_acpt" required="">
													<option value="">--Select--</option>
													<option <?php echo $agent_vfs['agnt_fd_acpt']=='Acceptance'?"selected":""; ?> value="Acceptance">Acceptance</option>	
													<option <?php echo $agent_vfs['agnt_fd_acpt']=='Not Acceptance'?"selected":""; ?> value="Not Acceptance">Not Acceptance</option>	
												</select>
											</td>
										</tr>
										<tr>
											<td colspan=2 style="font-size:16px">Your Review<span style="font-size:24px;color:red">*</span></td>
											<td colspan=6><textarea class="form-control" name="note" required><?php echo $agent_vfs['agent_rvw_note'] ?></textarea></td>
										</tr>
										
										<?php if(is_access_qa_agent_module()==true){
										if(is_available_qa_feedback($agent_vfs['entry_date'],72) == true){ ?>
											<tr>
												<?php if($agent_vfs['agent_rvw_note']==''){ ?>
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
		<?php } ?>

		<?php if($campaign=='chat'){ ?>
		<div class="row">
			<div class="col-12">
				<div class="widget">

				  <form id="form_audit_user" method="POST" action="" enctype="multipart/form-data">
					
					<div class="widget-body">
					 	<div class="table-responsive">
							<table class="table table-striped skt-table" width="100%">
								<tbody>
									<tr style="background-color:#AEB6BF">
										<td colspan="6" id="theader">VFS Chat Monitoring Form  </td>
										<input type="hidden" name="audit_start_time" value="<?php echo CurrMySqlDate(); ?>">
									</tr>
									<tr>
									<?php
										
											if($agent_vfs['entry_by']!=''){
												$auditorName = $agent_vfs['auditor_name'];
											}else{
												$auditorName = $agent_vfs['client_name'];
											}
											$auditDate = mysql2mmddyy($agent_vfs['audit_date']);
											$clDate_val=mysql2mmddyy($agent_vfs['call_date']);
										
									?>
										<td>QA Name:<span style="font-size:24px;color:red">*</span></td>
										<td style="width:300px"><input type="text" class="form-control" value="<?php echo $auditorName; ?>" disabled></td>
										<td style="width:150px">Audit Date:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control" value="<?php echo $auditDate; ?>" disabled></td>
										<td>Date and time Of Chat:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control" id="call_date" name="call_date" onkeydown="return false;"  value="<?php echo $clDate_val; ?>" disabled></td>
									</tr>
									<tr>
										<td>Agent Name:<span style="font-size:24px;color:red">*</span></td>
										<td>
											<select class="form-control" id="agent_id" name="agent_id" disabled>
												<option value="<?php echo $agent_vfs['agent_id'] ?>"><?php echo $agent_vfs['fname']." ".$agent_vfs['lname'] ?></option>
												<option value="">-Select-</option>
												<?php foreach($agentName as $row):  ?>
													<option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
												<?php endforeach; ?>
											</select>
										</td>
										<td>Fusion ID:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control" id="fusion_id" name="" value="<?php echo $agent_vfs['fusion_id']; ?>" readonly></td>
										<td>L1 Supervisor:<span style="font-size:24px;color:red">*</span></td>
										<td style="width:250px">
											<!-- <select class="form-control" id="tl_id" name="tl_id" readonly>
												<option value="<?php echo $agent_vfs['tl_id'] ?>"><?php echo $agent_vfs['tl_name'] ?></option>
												<option value="">--Select--</option>
												<?php foreach($tlname as $tl): ?>
													<option value="<?php echo $tl['id']; ?>"><?php echo $tl['fname']." ".$tl['lname']; ?></option>
												<?php endforeach; ?>	
											</select> -->

											<input type="text" class="form-control" id="tl_name"  value="<?php echo $agent_vfs['tl_name']; ?>" readonly>
												<input type="hidden" class="form-control" id="tl_id" name="tl_id" value="<?php echo $agent_vfs['tl_id'] ?>" disabled>
										</td>
									</tr>
									<tr>
										<td>Call Duration:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control" id="call_duration" onkeydown="return false;" name="call_duration" value="<?php echo $agent_vfs['call_duration']; ?>" disabled></td>
										<td>Mission:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control"  name="mission" value="<?php echo $agent_vfs['mission']; ?>" disabled></td>
										<td>Recording ID:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control"  name="recording_id" value="<?php echo $agent_vfs['recording_id']; ?>" disabled></td>
									</tr>
									<tr>
										<td>Week:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control"  name="week" value="<?php echo $agent_vfs['week']; ?>" disabled></td>
										<td>Fatal Error?:<span style="font-size:24px;color:red">*</span></td>
										<td>
											<select class="form-control" id="" name="autofail_status" disabled>
												<option value="">-Select-</option>
												<option <?php echo $agent_vfs['autofail_status']=='Fatal'?"selected":""; ?> value="Fatal">Fatal</option>
												<option <?php echo $agent_vfs['autofail_status']=='Non Fatal'?"selected":""; ?> value="Non Fatal">Non Fatal</option>
											</select>
										</td>
										<td>Host/Country:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control" name="host_country" value="<?php echo $agent_vfs['host_country']; ?>" disabled></td>
									</tr>
									<tr>
										<td>Agent Tenurity:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control" name="tenurity" id="tenure" value="<?php echo $agent_vfs['tenurity']; ?>" readonly></td>
										<td>VOC:<span style="font-size:24px;color:red">*</span></td>
										<td>
											<select class="form-control" id="voc" name="voc" disabled>
												<option value="">-Select-</option>
												<option <?php echo $agent_vfs['voc']=='1'?"selected":""; ?> value="1">1</option>
												<option <?php echo $agent_vfs['voc']=='2'?"selected":""; ?> value="2">2</option>
												<option <?php echo $agent_vfs['voc']=='3'?"selected":""; ?> value="3">3</option>
												<option <?php echo $agent_vfs['voc']=='4'?"selected":""; ?> value="4">4</option>
												<option <?php echo $agent_vfs['voc']=='5'?"selected":""; ?> value="5">5</option>
											</select>
										</td>
										<td>ACPT:<span style="font-size:24px;color:red">*</span></td>
										<td>
												<select class="form-control" id="" name="acpt" disabled>
													<option value="">-Select-</option>
													<option value="Agent"  <?= ($agent_vfs['acpt']=="Agent")?"selected":"" ?>>Agent</option>
													<option value="Process"  <?= ($agent_vfs['acpt']=="Process")?"selected":"" ?>>Process</option>
													<option value="Customer"  <?= ($agent_vfs['acpt']=="Customer")?"selected":"" ?>>Customer</option>
													<option value="Technology"  <?= ($agent_vfs['acpt']=="Technology")?"selected":"" ?>>Technology</option>
													<option value="NA"  <?= ($agent_vfs['acpt']=="NA")?"selected":"" ?>>NA</option>
												</select>
											</td>
										</tr>
										<tr>
										<td>Audit Type:<span style="font-size:24px;color:red">*</span></td>
										<td>
											<select class="form-control" id="audit_type" name="audit_type" disabled>
                                                    <option value="">-Select-</option>
                                                    <option value="CQ Audit" <?= ($agent_vfs['audit_type']=="CQ Audit")?"selected":"" ?>>CQ Audit</option>
                                                    <option value="BQ Audit" <?= ($agent_vfs['audit_type']=="BQ Audit")?"selected":"" ?>>BQ Audit</option>
                                                    <option value="Calibration" <?= ($agent_vfs['audit_type']=="Calibration")?"selected":"" ?>>Calibration</option>
                                                    <option value="Pre-Certificate Mock Call" <?= ($agent_vfs['audit_type']=="Pre-Certificate Mock Call")?"selected":"" ?>>Pre-Certificate Mock Call</option>
                                                    <option value="Certification Audit" <?= ($agent_vfs['audit_type']=="Certification Audit")?"selected":"" ?>>Certification Audit</option>
                                                    <option value="WoW Call"  <?= ($agent_vfs['audit_type']=="WoW Call")?"selected":"" ?>>WoW Call</option>
                                                    <option value="Hygiene Audit"  <?= ($agent_vfs['audit_type']=="Hygiene Audit")?"selected":"" ?>>Hygiene Audit</option>
                                                    <option value="Operation Audit"  <?= ($agent_vfs['audit_type']=="Operation Audit")?"selected":"" ?>>Operation Audit</option>
                                                    <option value="Trainer Audit"  <?= ($agent_vfs['audit_type']=="Trainer Audit")?"selected":"" ?>>Trainer Audit</option> 
                                                    <option value="QA Supervisor Audit"  <?= ($agent_vfs['audit_type']=="QA Supervisor Audit")?"selected":"" ?>>QA Supervisor Audit</option> 
                                                </select>
										</td>
									</tr>
									<tr>
										<td class="auType">Auditor Type<span style="font-size:24px;color:red">*</span></td>
										<td class="auType">
											<select class="form-control" id="auditor_type" name="auditor_type">
												<option value="">-Select-</option>
												 <option value="Master" <?= ($agent_vfs['auditor_type']=="Master")?"selected":"" ?>>Master</option> 
												 <option value="Regular" <?= ($agent_vfs['auditor_type']=="Regular")?"selected":"" ?>>Regular</option> 
											</select>
										</td>
									</tr>
									<tr>
										<td style="font-weight:bold">Earned Score:</td>
										<td><input type="text" readonly id="vfsEarned" name="earned_score" class="form-control" style="font-weight:bold" value="<?php echo $agent_vfs['overall_score'] ?>"></td>
										<td style="font-weight:bold">Possible Score:</td>
										<td><input type="text" readonly id="vfsPossible" name="possible_score" class="form-control" style="font-weight:bold" value="<?php echo $agent_vfs['overall_score'] ?>"></td>
										<td style="font-weight:bold">Overall Score Percentage:</td>
										<td><input type="text" readonly id="vfsOverallScore" name="overall_score" class="form-control vfsChatFatal" style="font-weight:bold" value="<?php echo $agent_vfs['overall_score'] ?>"></td>
									</tr>
									<tr style="font-weight:bold; background-color:#2471A3; color:white">
										<td colspan=2>Parameters</td>
										<td>Weightage</td>
										<td>Rating</td>
										<td>Final Score</td>
										<td>Remarks</td>
									</tr>
									<tr>
										<td style="background-color:#BFC9CA"><b>1</b></td>
										<td colspan=1 style="background-color:#BFC9CA">Opening</td>
										<td style="background-color:#BFC9CA">4</td>
										<td style="background-color:#BFC9CA"></td>
										<td style="background-color:#BFC9CA" id="score_opening">4</td>
										<td style="background-color:#BFC9CA"></td>
									</tr>
									<tr>
										<td></td>
										<td colspan=1>a. Appropriate greeting - as per script</td>
										<td>4</td>
										<td>
											<select class="form-control vfsVal" data-id="opening" name="appropiate_greeting" disabled><!-- <option value="">-Select-</option> -->
												<option vfs_val=4 vfs_max="4" <?php echo $agent_vfs['appropiate_greeting']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option vfs_val=0 vfs_max="4" <?php echo $agent_vfs['appropiate_greeting']=='No'?"selected":""; ?> value="No">No</option>
												<option vfs_val=4 vfs_max="4" <?php echo $agent_vfs['appropiate_greeting']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td id="score_appropiate_greeting">4</td>
										<td><textarea class="form-control" disabled name="comm0"><?php echo $agent_vfs['comm0'] ?></textarea></td>
									</tr>
									<tr>
										<td style="background-color:#BFC9CA"><b>2</b></td>
										<td colspan=1 style="background-color:#BFC9CA">Technical aspects</td>
										<td style="background-color:#BFC9CA">38</td>
										<td style="background-color:#BFC9CA"></td>
										<td style="background-color:#BFC9CA" id="score_technical_aspects">38</td>
										<td style="background-color:#BFC9CA"></td>

									</tr>
									<tr>
										<td></td>
										<td colspan=1>a. Response Time</td>
										<td>5</td>
										<td>
											<select class="form-control vfsVal"  data-id="technical_aspects" name="response_time" disabled>
												<!-- <option value="">-Select-</option> -->
												<option vfs_val=5 vfs_max="5" <?php echo $agent_vfs['response_time']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option vfs_val=0 vfs_max="5" <?php echo $agent_vfs['response_time']=='No'?"selected":""; ?> value="No">No</option>
												<option vfs_val=5 vfs_max="5" <?php echo $agent_vfs['response_time']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td id="score_response_time">5</td>
										<td><textarea class="form-control" disabled name="comm1"><?php echo $agent_vfs['comm1'] ?></textarea></td>
									</tr>
									<tr>
										<td></td>
										<td colspan=1>b. FCR achieved</td>
										<td>5</td>
										<td>
											<select class="form-control vfsVal"  data-id="technical_aspects" name="FCR_achieved" disabled>
												<!-- <option value="">-Select-</option> -->
												<option vfs_val=5 vfs_max="5" <?php echo $agent_vfs['FCR_achieved']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option vfs_val=0 vfs_max="5" <?php echo $agent_vfs['FCR_achieved']=='No'?"selected":""; ?> value="No">No</option>
												<option vfs_val=5 vfs_max="5" <?php echo $agent_vfs['FCR_achieved']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td id="score_FCR_achieved">5</td>
										<td><textarea class="form-control" disabled name="comm2"><?php echo $agent_vfs['comm2'] ?></textarea></td>
									</tr>
									<tr>
										<td></td>
										<td colspan=1>c. Complete and accurate information</td>
										<td>4</td>
										<td>
											<select class="form-control vfsVal"  data-id="technical_aspects" name="accurate_information" disabled>
												<!-- <option value="">-Select-</option> -->
												<option vfs_val=4 vfs_max="4" <?php echo $agent_vfs['accurate_information']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option vfs_val=0 vfs_max="4" <?php echo $agent_vfs['accurate_information']=='No'?"selected":""; ?> value="No">No</option>
												<option vfs_val=4 vfs_max="4" <?php echo $agent_vfs['accurate_information']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td id="score_accurate_information">4</td>
										<td><textarea class="form-control" disabled name="comm3"><?php echo $agent_vfs['comm3'] ?></textarea></td>
									</tr>
									<tr>
										<td></td>
										<td colspan=1>d. Understand the issue of the applicant & Attentiveness displayed</td>
										<td>9</td>
										<td>
											<select class="form-control vfsVal"  data-id="technical_aspects" name="understand_issue" disabled>
												<!-- <option value="">-Select-</option> -->
												<option vfs_val=9 vfs_max="9" <?php echo $agent_vfs['understand_issue']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option vfs_val=0 vfs_max="9" <?php echo $agent_vfs['understand_issue']=='No'?"selected":""; ?> value="No">No</option>
												<option vfs_val=9 vfs_max="9" <?php echo $agent_vfs['understand_issue']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td id="score_understand_issue">9</td>
										<td><textarea class="form-control" disabled name="comm4"><?php echo $agent_vfs['comm4'] ?></textarea></td>
									</tr>
								
									<tr>
										<td></td>
										<td colspan=1>e.Paraphrasing</td>
										<td>5</td>
										<td>
											<select class="form-control vfsVal"  data-id="technical_aspects" name="paraphrasing" disabled>
												<!-- <option value="">-Select-</option> -->
												<option vfs_val=5 vfs_max="5" <?php echo $agent_vfs['paraphrasing']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option vfs_val=0 vfs_max="5" <?php echo $agent_vfs['paraphrasing']=='No'?"selected":""; ?> value="No">No</option>
												<option vfs_val=5 vfs_max="5" <?php echo $agent_vfs['paraphrasing']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td id="score_paraphrasing">5</td>
										<td><textarea class="form-control" disabled name="comm6"><?php echo $agent_vfs['comm6'] ?></textarea></td>
									</tr>
									<tr>
										<td></td>
										<td colspan=1>f. Used all the available resources for providing resolution</td>
										<td>5</td>
										<td>
											<select class="form-control vfsVal"  data-id="technical_aspects" name="use_available_resource" disabled>
												<!-- <option value="">-Select-</option> -->
												<option vfs_val=5 vfs_max="5" <?php echo $agent_vfs['use_available_resource']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option vfs_val=0 vfs_max="5" <?php echo $agent_vfs['use_available_resource']=='No'?"selected":""; ?> value="No">No</option>
												<option vfs_val=5 vfs_max="5" <?php echo $agent_vfs['use_available_resource']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td id="score_use_available_resource">5</td>
										<td><textarea class="form-control" disabled name="comm7"><?php echo $agent_vfs['comm7'] ?></textarea></td>
									</tr>
									<tr>
										<td></td>
										<td colspan=1>g. Appropriate Probing</td>
										<td>5</td>
										<td>
											<select class="form-control vfsVal"  data-id="technical_aspects" name="appropiate_probing" disabled>
												<!-- <option value="">-Select-</option> -->
												<option vfs_val=5 vfs_max="5" <?php echo $agent_vfs['appropiate_probing']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option vfs_val=0 vfs_max="5" <?php echo $agent_vfs['appropiate_probing']=='No'?"selected":""; ?> value="No">No</option>
												<option vfs_val=5 vfs_max="5" <?php echo $agent_vfs['appropiate_probing']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td id="score_appropiate_probing">5</td>
										<td><textarea class="form-control" disabled name="comm8"><?php echo $agent_vfs['comm8'] ?></textarea></td>
									</tr>
									<tr>
										<td style="background-color:#BFC9CA"><b>3</b></td>
										<td colspan=1 style="background-color:#BFC9CA">Additions</td>
										<td style="background-color:#BFC9CA">17</td>
										<td style="background-color:#BFC9CA"></td>
										<td style="background-color:#BFC9CA" id="score_additions">17</td>
										<td style="background-color:#BFC9CA"></td>
									</tr>
									<tr>
										<td></td>
										<td colspan=1>a. Offers VAS options wherever applicable</td>
										<td>10</td>
										<td>
											<select class="form-control vfsVal"  data-id="additions" name="VAS_options" disabled>
												<option vfs_val=10 vfs_max="10" <?php echo $agent_vfs['VAS_options']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option vfs_val=0 vfs_max="10" <?php echo $agent_vfs['VAS_options']=='No'?"selected":""; ?> value="No">No</option>
												<option vfs_val=10 vfs_max="10" <?php echo $agent_vfs['VAS_options']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td id="score_VAS_options">10</td>
										<td><textarea class="form-control" disabled name="comm9"><?php echo $agent_vfs['comm9'] ?></textarea></td>
									</tr>
									<tr>
										<td></td>
										<td colspan=1>b. Awareness created with regards to VFS website (wherever applicable)</td>
										<td>7</td>
										<td>
											<select class="form-control vfsVal"  data-id="additions" name="awareness_created" disabled>
												<option vfs_val=7 vfs_max="7" <?php echo $agent_vfs['awareness_created']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option vfs_val=0 vfs_max="7" <?php echo $agent_vfs['awareness_created']=='No'?"selected":""; ?> value="No">No</option>
												<option vfs_val=7 vfs_max="7" <?php echo $agent_vfs['awareness_created']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td id="score_awareness_created">7</td>
										<td><textarea class="form-control" disabled name="comm10"><?php echo $agent_vfs['comm10'] ?></textarea></td>
									</tr>
									
									<tr>
										<td style="background-color:#BFC9CA"><b>4</b></td>
										<td colspan=1 style="background-color:#BFC9CA">Documentation</td>
										<td style="background-color:#BFC9CA">5</td>
										<td style="background-color:#BFC9CA"></td>
										<td style="background-color:#BFC9CA" id="score_documentation">5</td>
										<td style="background-color:#BFC9CA"></td>
									</tr>
									<tr>
										<td></td>
										<td colspan=1>a. Correct dispostion</td>
										<td>5</td>
										<td>
											<select class="form-control vfsVal"  data-id="documentation" name="correct_disposition" disabled>
												<option vfs_val=5 vfs_max="5" <?php echo $agent_vfs['correct_disposition']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option vfs_val=0 vfs_max="5" <?php echo $agent_vfs['correct_disposition']=='No'?"selected":""; ?> value="No">No</option>
												<option vfs_val=5 vfs_max="5" <?php echo $agent_vfs['correct_disposition']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td id="score_correct_disposition">5</td>
										<td><textarea class="form-control" disabled name="comm11"><?php echo $agent_vfs['comm11'] ?></textarea></td>
									</tr>
									
									<tr>
										<td style="background-color:#BFC9CA"><b>5</b></td>
										<td colspan=1 style="background-color:#BFC9CA">Hold Protocol</td>
										<td style="background-color:#BFC9CA">3</td>
										<td style="background-color:#BFC9CA"></td>
										<td style="background-color:#BFC9CA" id="score_hold_protocol">5</td>
										<td style="background-color:#BFC9CA"></td>

									</tr>
									<tr>
										<td></td>
										<td colspan=1>a. Was Hold disabled & Hold guidelines following</td>
										<td>5</td>
										<td>
											<select class="form-control vfsVal"  data-id="hold_required" name="hold_required" disabled>
												<option vfs_val=5 vfs_max="5" <?php echo $agent_vfs['hold_required']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option vfs_val=0 vfs_max="5" <?php echo $agent_vfs['hold_required']=='No'?"selected":""; ?> value="No">No</option>
												<option vfs_val=5 vfs_max="5" <?php echo $agent_vfs['hold_required']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td id="score_hold_required">5</td>
										<td><textarea class="form-control" disabled name="comm13"><?php echo $agent_vfs['comm13'] ?></textarea></td>
									</tr>
									
									<tr>
										<td style="background-color:#BFC9CA"><b>6</b></td>
										<td colspan=1 style="background-color:#BFC9CA">Communication</td>
										<td style="background-color:#BFC9CA">29</td>
										<td style="background-color:#BFC9CA"></td>
										<td style="background-color:#BFC9CA" id="score_communication">29</td>
										<td style="background-color:#BFC9CA"></td>

									</tr>
									<tr>
										<td></td>
										<td colspan=1>a. Formatting</td>
										<td>5</td>
										<td>
											<select class="form-control vfsVal"  data-id="communication" name="formatting" disabled>
												<option vfs_val=5 vfs_max="5" <?php echo $agent_vfs['formatting']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option vfs_val=0 vfs_max="5" <?php echo $agent_vfs['formatting']=='No'?"selected":""; ?> value="No">No</option>
												<option vfs_val=5 vfs_max="5" <?php echo $agent_vfs['formatting']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td id="score_formatting">5</td>
										<td><textarea class="form-control" disabled name="comm15"><?php echo $agent_vfs['comm15'] ?></textarea></td>
									</tr>
									<tr>
										<td></td>
										<td colspan=1>b. Avoid Negative statements</td>
										<td>5</td>
										<td>
											<select class="form-control vfsVal"  data-id="communication" name="avoid_negative_statement" disabled>
												<option vfs_val=5 vfs_max="5" <?php echo $agent_vfs['avoid_negative_statement']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option vfs_val=0 vfs_max="5" <?php echo $agent_vfs['avoid_negative_statement']=='No'?"selected":""; ?> value="No">No</option>
												<option vfs_val=5 vfs_max="5" <?php echo $agent_vfs['avoid_negative_statement']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td id="score_avoid_negative_statement">5</td>
										<td><textarea class="form-control" disabled name="comm16"><?php echo $agent_vfs['comm16'] ?></textarea></td>
									</tr>
									<tr>
										<td></td>
										<td colspan=1>c. Telling the customer what to do next, Step by step procedure guide</td>
										<td>5</td>
										<td>
											<select class="form-control vfsVal"  data-id="communication" name="procedure_guide_step" disabled>
												<option vfs_val=5 vfs_max="5" <?php echo $agent_vfs['procedure_guide_step']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option vfs_val=0 vfs_max="5" <?php echo $agent_vfs['procedure_guide_step']=='No'?"selected":""; ?> value="No">No</option>
												<option vfs_val=5 vfs_max="5" <?php echo $agent_vfs['procedure_guide_step']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td id="score_procedure_guide_step">5</td>
										<td><textarea class="form-control" disabled name="comm17"><?php echo $agent_vfs['comm17'] ?></textarea></td>
									</tr>
									<tr>
										<td></td>
										<td colspan=1>d. Avoid Slangs & Jargons</td>
										<td>5</td>
										<td>
											<select class="form-control vfsVal"  data-id="communication" name="avoid_slangs" disabled>
												<option vfs_val=5 vfs_max="5" <?php echo $agent_vfs['avoid_slangs']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option vfs_val=0 vfs_max="5" <?php echo $agent_vfs['avoid_slangs']=='No'?"selected":""; ?> value="No">No</option>
												<option vfs_val=5 vfs_max="5" <?php echo $agent_vfs['avoid_slangs']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td id="score_avoid_slangs">5</td>
										<td><textarea class="form-control" disabled name="comm18"><?php echo $agent_vfs['comm18'] ?></textarea></td>
									</tr>
									<tr>
										<td></td>
										<td colspan=1>e. Correct and accurate grammar usage / Avoid spelling mistakes</td>
										<td>6</td>
										<td>
											<select class="form-control vfsVal"  data-id="communication" name="correct_grammar_use" disabled>
												<option vfs_val=6 vfs_max="6" <?php echo $agent_vfs['correct_grammar_use']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option vfs_val=0 vfs_max="6" <?php echo $agent_vfs['correct_grammar_use']=='No'?"selected":""; ?> value="No">No</option>
												<option vfs_val=6 vfs_max="6" <?php echo $agent_vfs['correct_grammar_use']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td id="score_correct_grammar_use">6</td>
										<td><textarea class="form-control" disabled name="comm19"><?php echo $agent_vfs['comm19'] ?></textarea></td>
									</tr>
									<tr>
										<td></td>
										<td colspan=1>f. Further assistance</td>
										<td>3</td>
										<td>
											<select class="form-control vfsVal"  data-id="communication" name="further_assistance" disabled>
												<option vfs_val=3 vfs_max="3" <?php echo $agent_vfs['further_assistance']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option vfs_val=0 vfs_max="3" <?php echo $agent_vfs['further_assistance']=='No'?"selected":""; ?> value="No">No</option>
												<option vfs_val=3 vfs_max="3" <?php echo $agent_vfs['further_assistance']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td id="score_further_assistance">3</td>
										<td><textarea class="form-control" disabled name="comm20"><?php echo $agent_vfs['comm20'] ?></textarea></td>
									</tr>
									<tr>
										<td style="background-color:#BFC9CA"><b>7</b></td>
										<td colspan=1 style="background-color:#BFC9CA">Chat Closing</td>
										<td style="background-color:#BFC9CA">2</td>
										<td style="background-color:#BFC9CA"></td>
										<td style="background-color:#BFC9CA" id="score_closing">2</td>
										<td style="background-color:#BFC9CA"></td>

									</tr>
									<tr>
										<td></td>
										<td colspan=1>a. Adherence to chat closing script</td>
										<td>2</td>
										<td>
											<select class="form-control vfsVal" data-id="closing" name="chat_adherence" disabled>
												<option vfs_val=2 vfs_max="2" <?php echo $agent_vfs['chat_adherence']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option vfs_val=0 vfs_max="2" <?php echo $agent_vfs['chat_adherence']=='No'?"selected":""; ?> value="No">No</option>
												<option vfs_val=2 vfs_max="2"<?php echo $agent_vfs['chat_adherence']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td id="score_chat_adherence">2</td>
										<td><textarea class="form-control" disabled name="comm21"><?php echo $agent_vfs['comm21'] ?></textarea></td>
									</tr>
								
									<tr>
										<td style="background-color:#BFC9CA"><b>8</b></td>
										<td colspan=1 style="background-color:#BFC9CA">Fatal Parameters</td>
										<td style="background-color:#BFC9CA"></td>
										<td style="background-color:#BFC9CA"></td>
										<td style="background-color:#BFC9CA"></td>
										<td style="background-color:#BFC9CA"></td>
										
									</tr>
									<tr>
										<td></td>
										<td colspan=1 style="background-color:#D98880">a. Delayed opening</td>
										<td></td>
										<td>
											<select class="form-control vfsVal fatal_epi" id="chatAutof1" name="delayed_opening" disabled>
												<option vfs_val=0 vfs_max=0 <?php echo $agent_vfs['delayed_opening']=='No'?"selected":""; ?> value="No">No</option>
												<option vfs_val=0 vfs_max=0 <?php echo $agent_vfs['delayed_opening']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
											</select>
										</td>
										<td></td>
										<td><textarea class="form-control" disabled name="comm22"><?php echo $agent_vfs['comm22'] ?></textarea></td>
									</tr>
									<tr>
										<td></td>
										<td colspan=1 style="background-color:#D98880">b. Rude on chat</td>
										<td></td>
										<td>
											<select class="form-control vfsVal fatal_epi" id="chatAutof2" name="rude_on_chat" disabled>
												<option vfs_val=0 vfs_max=0 <?php echo $agent_vfs['rude_on_chat']=='No'?"selected":""; ?> value="No">No</option>
												<option vfs_val=0 vfs_max=0 <?php echo $agent_vfs['rude_on_chat']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
											</select>
										</td>
										<td></td>
										<td><textarea class="form-control" disabled name="comm23"><?php echo $agent_vfs['comm23'] ?></textarea></td>
									</tr>
									<tr>
										<td></td>
										<td colspan=1 style="background-color:#D98880">c. Incomplete/Inaccurate Information shared</td>
										<td></td>
										<td>
											<select class="form-control vfsVal fatal_epi" id="chatAutof3" name="inacurate_information" disabled>
												<option vfs_val=0 vfs_max=0 <?php echo $agent_vfs['inacurate_information']=='No'?"selected":""; ?> value="No">No</option>
												<option vfs_val=0 vfs_max=0 <?php echo $agent_vfs['inacurate_information']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
											</select>
										</td>
										<td></td>
										<td><textarea class="form-control" disabled name="comm24"><?php echo $agent_vfs['comm24'] ?></textarea></td>
									</tr>
									<tr>
										<td></td>
										<td colspan=1 style="background-color:#D98880">d. Complaint Avoidance</td>
										<td></td>
										<td>
											<select class="form-control vfsVal fatal_epi" id="chatAutof4" name="complaint_avoidance" disabled>
												<option vfs_val=0 vfs_max=0 <?php echo $agent_vfs['complaint_avoidance']=='No'?"selected":""; ?> value="No">No</option>
												<option vfs_val=0 vfs_max=0 <?php echo $agent_vfs['complaint_avoidance']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
											</select>
										</td>
										<td></td>
										<td><textarea class="form-control" disabled name="comm25"><?php echo $agent_vfs['comm25'] ?></textarea></td>
									</tr>
									<tr>
										<td style="background-color:#BFC9CA"><b>9</b></td>
										<td colspan=1 style="background-color:#BFC9CA">First Time Resolution (FTR)</td>
										<td style="background-color:#BFC9CA"></td>
										<td style="background-color:#BFC9CA"></td>
										<td style="background-color:#BFC9CA"></td>
										<td style="background-color:#BFC9CA"></td>
										
									</tr>
									<tr>
										<td></td>
										<td colspan=1>a. Disposition</td>
										<td></td>
										<td><textarea class="form-control" disabled name="comm32"><?php echo $agent_vfs['comm32'] ?></textarea></td>
										<td></td>
										<td><textarea class="form-control" disabled name="comm26"><?php echo $agent_vfs['comm26'] ?></textarea></td>
									</tr>
									<tr>
										<td></td>
										<td colspan=1>b. Communication mode through which customer contacted previously</td>
										<td></td>
										<td><textarea class="form-control" disabled name="comm33"><?php echo $agent_vfs['comm33'] ?></textarea></td>
										<td></td>
										<td><textarea class="form-control" disabled name="comm27"><?php echo $agent_vfs['comm27'] ?></textarea></td>
									</tr>
									<tr>
										<td></td>
										<td colspan=1>c. Description of Disposition selected</td>
										<td></td>
										<td><textarea class="form-control" disabled name="comm34"><?php echo $agent_vfs['comm34'] ?></textarea></td>
										<td></td>
										<td><textarea class="form-control" disabled name="comm28"><?php echo $agent_vfs['comm28'] ?></textarea></td>
									</tr>
									<tr>
										<td></td>
										<td colspan=1>d. Was this the first time customer called us ?</td>
										<td></td>
										<td>
											 <select class="form-control vfsVal" id="" disabled name="customer_called_first">
												<option value="">Select</option>
												<option vfs_val=0 vfs_max=0 <?php echo $agent_vfs['customer_called_first']=='No'?"selected":""; ?> value="No">No</option>
												<option vfs_val=0 <?php echo $agent_vfs['customer_called_first']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
											</select>
										</td>
										<td></td>
										<td><textarea class="form-control" disabled name="comm29"><?php echo $agent_vfs['comm29'] ?></textarea></td>
									</tr>
									<tr>
										<td></td>
										<td colspan=1>e. Did the customer contact us more than once but less than 3 times ?</td>
										<td></td>
										<td>
											 <select class="form-control vfsVal" disabled id="" name="customer_contact_more_one_less_three">
												<option value="">Select</option>
												<option vfs_val=0 vfs_max=0 <?php echo $agent_vfs['customer_contact_more_one_less_three']=='No'?"selected":""; ?> value="No">No</option>
												<option vfs_val=0 vfs_max=0 <?php echo $agent_vfs['customer_contact_more_one_less_three']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
											</select>
										</td>
										<td></td>
										<td><textarea class="form-control" disabled name="comm30"><?php echo $agent_vfs['comm30'] ?></textarea></td>
									</tr>
									<tr>
										<td></td>
										<td colspan=1>f. Did the customer contact us more than 3 times ?</td>
										<td></td>
										<td>
											 <select class="form-control vfsVal" disabled id="" name="customer_contact_more_three">
												<option value="">Select</option>
												<option vfs_val=0 vfs_max=0 <?php echo $agent_vfs['customer_contact_more_three']=='No'?"selected":""; ?> value="No">No</option>
												<option vfs_val=0 vfs_max=0 <?php echo $agent_vfs['customer_contact_more_three']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
											</select>
										</td>
										<td></td>
										<td><textarea class="form-control" disabled name="comm31"><?php echo $agent_vfs['comm31'] ?></textarea></td>
									</tr>
									<tr>
										<td>Call Summary:</td>
										<td colspan=2><textarea class="form-control"  name="call_summary"><?php echo $agent_vfs['call_summary'] ?></textarea></td>
										<td>Feedback:</td>
										<td colspan=2><textarea class="form-control"  name="feedback"><?php echo $agent_vfs['feedback'] ?></textarea></td>
									</tr>
									<?php if($agent_vfs['attach_file']!=''){ ?>
									<tr oncontextmenu="return false;">
										<td colspan="2">Audio Files (Mp4/Mp3/M4a/Wav)</td>
										<td colspan="4">
											<?php $attach_file = explode(",",$agent_vfs['attach_file']);
											 foreach($attach_file as $af){ ?>
												<audio oncontextmenu="return false;" controls controlslist="nodownload" style="background-color:#607F93">
													  <source src="<?php echo base_url(); ?>qa_files/qa_vfs/chat/<?php echo $af; ?>" type="audio/ogg">
													  <source src="<?php echo base_url(); ?>qa_files/qa_vfs/chat/<?php echo $af; ?>" type="audio/mpeg">
												</audio> </br>
											 <?php } ?>
										</td>
									</tr>
									<?php } ?>

									<tr>
										<td style="font-size:12px">Manager Review:</td>
										<td colspan="8" style="text-align:left"><?php echo $agent_vfs['mgnt_rvw_note'] ?></td>
									</tr>
									<tr>
										<td style="font-size:12px">Client Review:</td>
										<td colspan="8" style="text-align:left"><?php echo $agent_vfs['client_rvw_note'] ?></td>
									</tr>

									<tr><td colspan="10" style="background-color:#C5C8C8"></td></tr>
									
									 <form id="form_agent_user" method="POST" action="">
										<input type="hidden" name="pnid" class="form-control" value="<?php echo $pnid; ?>">
										
										<tr>
											<td colspan=2 style="font-size:16px">Feedback Acceptance<span style="font-size:24px;color:red">*</span></td>
											<td colspan=6>
												<select class="form-control" id="" name="agnt_fd_acpt" required="">
													<option value="">--Select--</option>
													<option <?php echo $agent_vfs['agnt_fd_acpt']=='Acceptance'?"selected":""; ?> value="Acceptance">Acceptance</option>	
													<option <?php echo $agent_vfs['agnt_fd_acpt']=='Not Acceptance'?"selected":""; ?> value="Not Acceptance">Not Acceptance</option>	
												</select>
											</td>
										</tr>
										<tr>
											<td colspan=2 style="font-size:16px">Your Review<span style="font-size:24px;color:red">*</span></td>
											<td colspan=6><textarea class="form-control" name="note" required><?php echo $agent_vfs['agent_rvw_note'] ?></textarea></td>
										</tr>
										
										<?php if(is_access_qa_agent_module()==true){
										if(is_available_qa_feedback($agent_vfs['entry_date'],72) == true){ ?>
											<tr>
												<?php if($agent_vfs['agent_rvw_note']==''){ ?>
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
		<?php } ?>	
	<?php if($campaign=='email'){ ?>	
		<div class="row">
			<div class="col-12">
				<div class="widget">

				  <form id="form_audit_user" method="POST" action="" enctype="multipart/form-data">
					
					<div class="widget-body">
					 	<div class="table-responsive">
							<table class="table table-striped skt-table" width="100%">
								<tbody>
									<tr style="background-color:#AEB6BF">
										<td colspan="6" id="theader">VFS Email Monitoring Form 
										<input type="hidden" name="audit_start_time" value="<?php echo CurrMySqlDate(); ?>">
									</tr>
									<tr>
									<?php
									
										if($agent_vfs['entry_by']!=''){
											$auditorName = $agent_vfs['auditor_name'];
										}else{
											$auditorName = $agent_vfs['client_name'];
										}
										$auditDate = mysql2mmddyy($agent_vfs['audit_date']);
										$clDate_val=mysql2mmddyy($agent_vfs['call_date']);
										
									?>
										<td>QA Name:<span style="font-size:24px;color:red">*</span></td>
										<td style="width:300px"><input type="text" class="form-control" value="<?php echo $auditorName; ?>" disabled></td>
										<td style="width:150px">Audit Date:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control" value="<?php echo $auditDate; ?>" disabled></td>
										<td>Email Date:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control" id="call_date" name="call_date" onkeydown="return false;" value="<?php echo $clDate_val; ?>" disabled></td>
									</tr>
									<tr>
										<td>Agent Name:<span style="font-size:24px;color:red">*</span></td>
										<td>
											<select class="form-control" id="agent_id" name="agent_id" disabled>
												<option value="<?php echo $agent_vfs['agent_id'] ?>"><?php echo $agent_vfs['fname']." ".$agent_vfs['lname'] ?></option>
												<option value="">-Select-</option>
												<?php foreach($agentName as $row):  ?>
													<option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
												<?php endforeach; ?>
											</select>
										</td>
										<td>Employee ID:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control" id="fusion_id" name="" value="<?php echo $agent_vfs['fusion_id']; ?>" readonly></td>
										<td>L1 Supervisor:<span style="font-size:24px;color:red">*</span></td>
										<td style="width:250px">
											<input type="text" class="form-control" id="tl_name"  value="<?php echo $agent_vfs['tl_name']; ?>" readonly>
												<input type="hidden" class="form-control" id="tl_id" name="tl_id" value="<?php echo $agent_vfs['tl_id'] ?>" disabled>
										</td>
									</tr>
									<tr>
										<td>Email Responded Within:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control" id="call_duration" name="call_duration" onkeydown="return false;" value="<?php echo $agent_vfs['call_duration']; ?>" disabled></td>
										<td>Mission:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control"  name="mission" value="<?php echo $agent_vfs['mission']; ?>" disabled></td>
										<td>Recording ID:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control"  name="recording_id" value="<?php echo $agent_vfs['recording_id']; ?>" disabled></td>
									</tr>
									<tr>
										<td>Week:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control"  name="week" value="<?php echo $agent_vfs['week']; ?>" disabled></td>
										
										<td>Fatal Error?:<span style="font-size:24px;color:red">*</span></td>
										<td>
											<select class="form-control" id="" name="autofail_status" disabled>
												<option value="">-Select-</option>
												<option <?php echo $agent_vfs['autofail_status']=='Fatal'?"selected":""; ?> value="Fatal">Fatal</option>
												<option <?php echo $agent_vfs['autofail_status']=='Non Fatal'?"selected":""; ?> value="Non Fatal">Non Fatal</option>
											</select>
										</td>
										<td>Host/Country:</td>
										<td><input type="text" class="form-control" name="host_country" value="<?php echo $agent_vfs['host_country']; ?>" disabled></td>
									</tr>
									<tr>
										<td>Agent Tenurity:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control" name="tenurity" id="tenure" value="<?php echo $agent_vfs['tenurity']; ?>" readonly></td>
										<td>VOC:<span style="font-size:24px;color:red">*</span></td>
										<td>
											<select class="form-control" id="voc" name="voc" disabled>
												<option value="">-Select-</option>
												<option <?php echo $agent_vfs['voc']=='1'?"selected":""; ?> value="1">1</option>
												<option <?php echo $agent_vfs['voc']=='2'?"selected":""; ?> value="2">2</option>
												<option <?php echo $agent_vfs['voc']=='3'?"selected":""; ?> value="3">3</option>
												<option <?php echo $agent_vfs['voc']=='4'?"selected":""; ?> value="4">4</option>
												<option <?php echo $agent_vfs['voc']=='5'?"selected":""; ?> value="5">5</option>
											</select>
										</td>
										<td>ACPT:<span style="font-size:24px;color:red">*</span></td>
										<td>
												<select class="form-control" id="" name="acpt" disabled>
													<option value="">-Select-</option>
													<option value="Agent"  <?= ($agent_vfs['acpt']=="Agent")?"selected":"" ?>>Agent</option>
													<option value="Process"  <?= ($agent_vfs['acpt']=="Process")?"selected":"" ?>>Process</option>
													<option value="Customer"  <?= ($agent_vfs['acpt']=="Customer")?"selected":"" ?>>Customer</option>
													<option value="Technology"  <?= ($agent_vfs['acpt']=="Technology")?"selected":"" ?>>Technology</option>
													<option value="NA"  <?= ($agent_vfs['acpt']=="NA")?"selected":"" ?>>NA</option>
												</select>
											</td>
									</tr>
									<tr>
										<td>Audit Type:<span style="font-size:24px;color:red">*</span></td>
										<td>
											<select class="form-control" id="audit_type" name="audit_type" disabled>
                                                    <option value="">-Select-</option>
                                                    <option value="CQ Audit" <?= ($agent_vfs['audit_type']=="CQ Audit")?"selected":"" ?>>CQ Audit</option>
                                                    <option value="BQ Audit" <?= ($agent_vfs['audit_type']=="BQ Audit")?"selected":"" ?>>BQ Audit</option>
                                                    <option value="Calibration" <?= ($agent_vfs['audit_type']=="Calibration")?"selected":"" ?>>Calibration</option>
                                                    <option value="Pre-Certificate Mock Call" <?= ($agent_vfs['audit_type']=="Pre-Certificate Mock Call")?"selected":"" ?>>Pre-Certificate Mock Call</option>
                                                    <option value="Certification Audit" <?= ($agent_vfs['audit_type']=="Certification Audit")?"selected":"" ?>>Certification Audit</option>
                                                    <option value="WoW Call"  <?= ($agent_vfs['audit_type']=="WoW Call")?"selected":"" ?>>WoW Call</option>
                                                    <option value="Hygiene Audit"  <?= ($agent_vfs['audit_type']=="Hygiene Audit")?"selected":"" ?>>Hygiene Audit</option>
                                                    <option value="Operation Audit"  <?= ($agent_vfs['audit_type']=="Operation Audit")?"selected":"" ?>>Operation Audit</option>
                                                    <option value="Trainer Audit"  <?= ($agent_vfs['audit_type']=="Trainer Audit")?"selected":"" ?>>Trainer Audit</option> 
                                                    <option value="QA Supervisor Audit"  <?= ($agent_vfs['audit_type']=="QA Supervisor Audit")?"selected":"" ?>>QA Supervisor Audit</option> 
                                                </select>
										</td>
									
										<td class="auType">Auditor Type:<span style="font-size:24px;color:red">*</span></td>
										<td class="auType">
											<select class="form-control" id="auditor_type" name="auditor_type">
												<option value="">-Select-</option>
												 <option value="Master" <?= ($agent_vfs['auditor_type']=="Master")?"selected":"" ?>>Master</option> 
												 <option value="Regular" <?= ($agent_vfs['auditor_type']=="Regular")?"selected":"" ?>>Regular</option> 
											</select>
										</td>
										
									</tr>
									<tr>
										<td style="font-weight:bold">Earned Score:</td>
										<td><input type="text" readonly id="vfsEarned" name="earned_score" class="form-control" style="font-weight:bold" value="<?php echo $agent_vfs['overall_score'] ?>"></td>
										<td style="font-weight:bold">Possible Score:</td>
										<td><input type="text" readonly id="vfsPossible" name="possible_score" class="form-control" style="font-weight:bold" value="<?php echo $agent_vfs['overall_score'] ?>"></td>
										<td style="font-weight:bold">Overall Score Percentage:</td>
										<td><input type="text" readonly id="vfsOverallScore" name="overall_score" class="form-control vfsEmailFatal" style="font-weight:bold" value="<?php echo $agent_vfs['overall_score'] ?>"></td>
									</tr>
									<tr style="font-weight:bold; background-color:#2471A3; color:white">
										<td colspan=2>Parameters</td>
										<td>Weightage</td>
										<td>Rating</td>
										<td>Final Score</td>
										<td>Remarks</td>
									</tr>
									<tr>
										<td style="background-color:#BFC9CA"><b>1</b></td>
										<td colspan=1 style="background-color:#BFC9CA">Content Writing (Look and feel)</td>
										<td style="background-color:#BFC9CA">11</td>
										<td style="background-color:#BFC9CA"></td>
										<td style="background-color:#BFC9CA" id="score_content_writing">11</td>
										<td style="background-color:#BFC9CA" ></td>
									</tr>
									
									<tr>
										<td></td>
										<td colspan=1>a. Greeting & Salutation used correctly</td>
										<td>3</td>
										<td>
											<select class="form-control vfsVal"  data-id="content_writing" name="salutation" disabled>
												<option vfs_val=3 vfs_max='3' <?php echo $agent_vfs['salutation']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option vfs_val=0 vfs_max='3' <?php echo $agent_vfs['salutation']=='No'?"selected":""; ?> value="No">No</option>
												<option vfs_val=3 vfs_max='3' <?php echo $agent_vfs['salutation']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td id="score_salutation">3</td>
										<td><textarea class="form-control" disabled name="comm1"><?php echo $agent_vfs['comm1'] ?></textarea></td>
									</tr>
									<tr>
										<td></td>
										<td colspan=1>b. Used bullet points where appropriate</td>
										<td>3</td>
										<td>
											<select class="form-control vfsVal"  data-id="content_writing" name="use_bullet_point" disabled>
												<option vfs_val=3 vfs_max='3' <?php echo $agent_vfs['use_bullet_point']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option vfs_val=0 vfs_max='3' <?php echo $agent_vfs['use_bullet_point']=='No'?"selected":""; ?> value="No">No</option>
												<option vfs_val=3 vfs_max='3' <?php echo $agent_vfs['use_bullet_point']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td id="score_use_bullet_point">3</td>
										<td><textarea class="form-control" disabled name="comm2"><?php echo $agent_vfs['comm2'] ?></textarea></td>
									</tr>
									
									<tr>
										<td></td>
										<td colspan=1>c. Used one idea per paragraph & Simple & definite statements</td>
										<td>2</td>
										<td>
											<select class="form-control vfsVal"  data-id="content_writing" name="definite_statements" disabled>
												<option vfs_val=2 vfs_max='2' <?php echo $agent_vfs['definite_statements']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option vfs_val=0 vfs_max='2'  <?php echo $agent_vfs['definite_statements']=='No'?"selected":""; ?> value="No">No</option>
												<option vfs_val=2 vfs_max='2' <?php echo $agent_vfs['definite_statements']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td id="score_definite_statements">2</td>
										<td><textarea class="form-control" disabled name="comm3"><?php echo $agent_vfs['comm3'] ?></textarea></td>
									</tr>
									<tr>
										<td></td>
										<td colspan=1>d. Template Adherence where applicable</td>
										<td>3</td>
										<td>
											<select class="form-control vfsVal"  data-id="content_writing" name="template_adherence" disabled>
												<option vfs_val=3 vfs_max='3' <?php echo $agent_vfs['template_adherence']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option vfs_val=0 vfs_max='3' <?php echo $agent_vfs['template_adherence']=='No'?"selected":""; ?> value="No">No</option>
												<option vfs_val=3 vfs_max='3' <?php echo $agent_vfs['template_adherence']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td id="score_template_adherence">3</td>
										<td><textarea class="form-control" disabled name="comm4"><?php echo $agent_vfs['comm4'] ?></textarea></td>
									</tr>
									<tr>
										<td style="background-color:#BFC9CA"><b>2</b></td>
										<td colspan=1 style="background-color:#BFC9CA">Accuracy / follow up </td>
										<td style="background-color:#BFC9CA">42</td>
										<td style="background-color:#BFC9CA"></td>
										<td style="background-color:#BFC9CA" id="score_accuracy">42</td>
										<td style="background-color:#BFC9CA" ></td>
									</tr>
									<tr>
										<td></td>
										<td colspan=1>a. Interim response provided (if applicable) & trail answered as per TAT provided</td>
										<td>3</td>
										<td>
											<select class="form-control vfsVal" data-id="accuracy" name="interim_responce" disabled>
												<option vfs_val=3 vfs_max='3' <?php echo $agent_vfs['interim_responce']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option vfs_val=0 vfs_max='3' <?php echo $agent_vfs['interim_responce']=='No'?"selected":""; ?> value="No">No</option>
												<option vfs_val=3 vfs_max='3' <?php echo $agent_vfs['interim_responce']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td id="score_interim_responce">3</td>
										<td><textarea class="form-control" disabled name="comm5"><?php echo $agent_vfs['comm5'] ?></textarea></td>
									</tr>
									<tr>
										<td></td>
										<td colspan=1>b. FCR achieved</td>
										<td>11</td>
										<td>
											<select class="form-control vfsVal"  data-id="accuracy" name="FCR_achieved" disabled>
												<option vfs_val=11 vfs_max='11' <?php echo $agent_vfs['FCR_achieved']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option vfs_val=0 vfs_max='11' <?php echo $agent_vfs['FCR_achieved']=='No'?"selected":""; ?> value="No">No</option>
												<option vfs_val=11 vfs_max='11' <?php echo $agent_vfs['FCR_achieved']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td id="score_FCR_achieved">11</td>
										<td><textarea class="form-control" disabled name="comm6"><?php echo $agent_vfs['comm6'] ?></textarea></td>
									</tr>
									<tr>
										<td></td>
										<td colspan=1>c. Complete and accurate information</td>
										<td>11</td>
										<td>
											<select class="form-control vfsVal"  data-id="accuracy" name="complete_information" disabled>
												<option vfs_val=11 vfs_max='11' <?php echo $agent_vfs['complete_information']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option vfs_val=0 vfs_max='11' <?php echo $agent_vfs['complete_information']=='No'?"selected":""; ?> value="No">No</option>
												<option vfs_val=11 vfs_max='11' <?php echo $agent_vfs['complete_information']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td id="score_complete_information">11</td>
										<td><textarea class="form-control" disabled name="comm7"><?php echo $agent_vfs['comm7'] ?></textarea></td>
									</tr>
									
									<tr>
										<td></td>
										<td colspan=1>d. Understand the issue of the customer & Attentiveness displayed</td>
										<td>9</td>
										<td>
											<select class="form-control vfsVal"  data-id="accuracy" name="customer_attentiveness" disabled>
												<option vfs_val=9 vfs_max='9' <?php echo $agent_vfs['customer_attentiveness']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option vfs_val=0 vfs_max='9' <?php echo $agent_vfs['customer_attentiveness']=='No'?"selected":""; ?> value="No">No</option>
												<option vfs_val=9 vfs_max='9' <?php echo $agent_vfs['customer_attentiveness']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td id="score_customer_attentiveness">9</td>
										<td><textarea class="form-control" disabled name="comm8"><?php echo $agent_vfs['comm8'] ?></textarea></td>
									</tr>
									
									<tr>
										<td></td>
										<td colspan=1>e. Used all the available resources for providing resolution</td>
										<td>4</td>
										<td>
											<select class="form-control vfsVal"  data-id="accuracy" name="use_available_resource" disabled>
												<option vfs_val=4 vfs_max='4' <?php echo $agent_vfs['use_available_resource']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option vfs_val=0 vfs_max='4' <?php echo $agent_vfs['use_available_resource']=='No'?"selected":""; ?> value="No">No</option>
												<option vfs_val=4 vfs_max='4' <?php echo $agent_vfs['use_available_resource']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td id="score_use_available_resource">4</td>
										<td><textarea class="form-control" disabled name="comm9"><?php echo $agent_vfs['comm9'] ?></textarea></td>
									</tr>
									<tr>
										<td></td>
										<td colspan=1>f. Standardized subject line on trail mails</td>
										<td>4</td>
										<td>
											<select class="form-control vfsVal"  data-id="accuracy" name="standardized_subject" disabled>
												<option vfs_val=4 vfs_max='4' <?php echo $agent_vfs['standardized_subject']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option vfs_val=0 vfs_max='4' <?php echo $agent_vfs['standardized_subject']=='No'?"selected":""; ?> value="No">No</option>
												<option vfs_val=4 vfs_max='4' <?php echo $agent_vfs['standardized_subject']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td id="score_standardized_subject">4</td>
										<td><textarea class="form-control" disabled name="comm10"><?php echo $agent_vfs['comm10'] ?></textarea></td>
									</tr>
									<tr>
										<td style="background-color:#BFC9CA"><b>3</b></td>
										<td colspan=1 style="background-color:#BFC9CA">Additions</td>
										<td style="background-color:#BFC9CA">20</td>
										<td style="background-color:#BFC9CA"></td>
										<td style="background-color:#BFC9CA" id="score_additions">20</td>
										<td style="background-color:#BFC9CA" ></td>
									</tr>
									<tr>
										<td></td>
										<td colspan=1>a. Offers VAS options wherever applicable</td>
										<td>10</td>
										<td>
											<select class="form-control vfsVal"  data-id="additions" name="VAS_option" disabled>
												<option vfs_val=10 vfs_max='10' <?php echo $agent_vfs['VAS_option']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option vfs_val=0 vfs_max='10' <?php echo $agent_vfs['VAS_option']=='No'?"selected":""; ?> value="No">No</option>
												<option vfs_val=10 vfs_max='10' <?php echo $agent_vfs['VAS_option']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td id="score_VAS_option">10</td>
										<td><textarea class="form-control" disabled name="comm11"><?php echo $agent_vfs['comm11'] ?></textarea></td>
									</tr>
									<tr>
										<td></td>
										<td colspan=1>b. Awareness created with regards to VFS website (wherever applicable)</td>
										<td>10</td>
										<td>
											<select class="form-control vfsVal"  data-id="additions" name="awarreness_created" disabled>
												<option vfs_val=10 vfs_max='10' <?php echo $agent_vfs['awarreness_created']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option vfs_val=0 vfs_max='10' <?php echo $agent_vfs['awarreness_created']=='No'?"selected":""; ?> value="No">No</option>
												<option vfs_val=10 vfs_max='10' <?php echo $agent_vfs['awarreness_created']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td id="score_awarreness_created">10</td>
										<td><textarea class="form-control" disabled name="comm12"><?php echo $agent_vfs['comm12'] ?></textarea></td>
									</tr>
									<tr>
										<td style="background-color:#BFC9CA"><b>4</b></td>
										<td colspan=1 style="background-color:#BFC9CA">Tool/Application Documentation</td>
										<td style="background-color:#BFC9CA">5</td>
										<td style="background-color:#BFC9CA"></td>
										<td style="background-color:#BFC9CA" id="score_Documentation">5</td>
										<td style="background-color:#BFC9CA" ></td>
									</tr>
									<tr>
										<td></td>
										<td colspan=1>a. Correct dispostion</td>
										<td>5</td>
										<td>
											<select class="form-control vfsVal"  data-id="Documentation" name="correct_disposition" disabled>
												<option vfs_val=5 vfs_max='5' <?php echo $agent_vfs['correct_disposition']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option vfs_val=0 vfs_max='5' <?php echo $agent_vfs['correct_disposition']=='No'?"selected":""; ?> value="No">No</option>
												<option vfs_val=5 vfs_max='5' <?php echo $agent_vfs['correct_disposition']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td id="score_correct_disposition">5</td>
										<td><textarea class="form-control" disabled name="comm13"><?php echo $agent_vfs['comm13'] ?></textarea></td>
									</tr>
									
									<tr>
										<td style="background-color:#BFC9CA"><b>5</b></td>
										<td colspan=1 style="background-color:#BFC9CA">Composition</td>
										<td style="background-color:#BFC9CA">22</td>
										<td style="background-color:#BFC9CA"></td>
										<td style="background-color:#BFC9CA" id="score_Composition">22</td>
										<td style="background-color:#BFC9CA" ></td>
									</tr>
									<tr>
										<td></td>
										<td colspan=1>a. Formatting</td>
										<td>3</td>
										<td>
											<select class="form-control vfsVal" data-id="Composition" name="formatting" disabled>
												<option vfs_val=3 vfs_max='3' <?php echo $agent_vfs['formatting']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option vfs_val=0 vfs_max='3' <?php echo $agent_vfs['formatting']=='No'?"selected":""; ?> value="No">No</option>
												<option vfs_val=3 vfs_max='3' <?php echo $agent_vfs['formatting']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td id="score_formatting">3</td>
										<td><textarea class="form-control" disabled name="comm14"><?php echo $agent_vfs['comm14'] ?></textarea></td>
									</tr>
									<tr>
										<td></td>
										<td colspan=1>b. Telling the customer what to do next, Step by step procedure guide</td>
										<td>3</td>
										<td>
											<select class="form-control vfsVal" data-id="Composition" name="procedure_guide_step" disabled>
												<option vfs_val=3 vfs_max='3' <?php echo $agent_vfs['procedure_guide_step']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option vfs_val=0 vfs_max='3' <?php echo $agent_vfs['procedure_guide_step']=='No'?"selected":""; ?> value="No">No</option>
												<option vfs_val=3 vfs_max='3' <?php echo $agent_vfs['procedure_guide_step']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td id="score_procedure_guide_step">3</td>
										<td><textarea class="form-control" disabled name="comm15"><?php echo $agent_vfs['comm15'] ?></textarea></td>
									</tr>
									<tr>
										<td></td>
										<td colspan=1>c. Avoid Slangs  & Jargons</td>
										<td>3</td>
										<td>
											<select class="form-control vfsVal"  data-id="Composition" name="avoid_slangs" disabled>
												<option vfs_val=3 vfs_max='3' <?php echo $agent_vfs['avoid_slangs']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option vfs_val=0 vfs_max='3' <?php echo $agent_vfs['avoid_slangs']=='No'?"selected":""; ?> value="No">No</option>
												<option vfs_val=3 vfs_max='3' <?php echo $agent_vfs['avoid_slangs']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td id="score_avoid_slangs">3</td>
										<td><textarea class="form-control" disabled name="comm16"><?php echo $agent_vfs['comm16'] ?></textarea></td>
									</tr>
									<tr>
										<td></td>
										<td colspan=1>d. Correct and accurate grammar usage</td>
										<td>6</td>
										<td>
											<select class="form-control vfsVal"  data-id="Composition" name="correct_grammar_use" disabled>
												<option vfs_val=6 vfs_max='6' <?php echo $agent_vfs['correct_grammar_use']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option vfs_val=0 vfs_max='6' <?php echo $agent_vfs['correct_grammar_use']=='No'?"selected":""; ?> value="No">No</option>
												<option vfs_val=6 vfs_max='6' <?php echo $agent_vfs['correct_grammar_use']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td id="score_correct_grammar_use">6</td>
										<td><textarea class="form-control" disabled name="comm17"><?php echo $agent_vfs['comm17'] ?></textarea></td>
									</tr>
									
									<tr>
										<td></td>
										<td colspan=1>e. Further assistance & Correct closing</td>
										<td>7</td>
										<td>
											<select class="form-control vfsVal"  data-id="Composition" name="correct_assistance" disabled>
												<option vfs_val=7 vfs_max='7' <?php echo $agent_vfs['correct_assistance']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option vfs_val=0  vfs_max='7' <?php echo $agent_vfs['correct_assistance']=='No'?"selected":""; ?> value="No">No</option>
												<option vfs_val=7 vfs_max='7' <?php echo $agent_vfs['correct_assistance']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td id="score_correct_closing">7</td>
										<td><textarea class="form-control" disabled name="comm18"><?php echo $agent_vfs['comm18'] ?></textarea></td>
									</tr>
									<tr>
										<td style="background-color:#BFC9CA"><b>6</b></td>
										<td colspan=1 style="background-color:#BFC9CA">Fatal Parameter</td>
										<td style="background-color:#BFC9CA"></td>
										<td style="background-color:#BFC9CA"></td>
										<td style="background-color:#BFC9CA"></td>
										<td style="background-color:#BFC9CA" ></td>
									</tr>
									<tr>	
										<td></td>									
										<td colspan=1 style="background-color:#D98880">a. Rude or unprofessional on email</td>
										<td></td>
										<td>
											<select class="form-control vfsVal fatal_epi" id="emailAutof1" name="rude_on_email" disabled>
												<option vfs_val=0 vfs_max=0 <?php echo $agent_vfs['rude_on_email']=='No'?"selected":""; ?> value="No">No</option>
												<option vfs_val=0 vfs_max=0 <?php echo $agent_vfs['rude_on_email']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
											</select>
										</td>
										<td></td>
										<td><textarea class="form-control" disabled name="comm19"><?php echo $agent_vfs['comm19'] ?></textarea></td>
									</tr>
									<tr>	
										<td></td>									
										<td colspan=1 style="background-color:#D98880">b. Incomplete / Inaccurate Information shared</td>
										<td></td>
										<td>
											<select class="form-control vfsVal fatal_epi" id="emailAutof2" name="inacurate_information" disabled>
												<option vfs_val=0 vfs_max=0 <?php echo $agent_vfs['inacurate_information']=='No'?"selected":""; ?> value="No">No</option>
												<option vfs_val=0 vfs_max=0 <?php echo $agent_vfs['inacurate_information']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
											</select>
										</td>
										<td></td>
										<td><textarea class="form-control" disabled name="comm20"><?php echo $agent_vfs['comm20'] ?></textarea></td>
									</tr>
									<tr>	
										<td></td>									
										<td colspan=1 style="background-color:#D98880">c. Email hygiene</td>
										<td></td>
										<td>
											<select class="form-control vfsVal fatal_epi" id="emailAutof3" name="email_hygiene" disabled>
												<option vfs_val=0 vfs_max=0 <?php echo $agent_vfs['email_hygiene']=='No'?"selected":""; ?> value="No">No</option>
												<option vfs_val=0 vfs_max=0 <?php echo $agent_vfs['email_hygiene']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
											</select>
										</td>
										<td></td>
										<td><textarea class="form-control" disabled name="comm21"><?php echo $agent_vfs['comm21'] ?></textarea></td>
									</tr>
									<tr>	
										<td></td>									
										<td colspan=1 style="background-color:#D98880">d. Complaint Avoidance</td>
										<td></td>
										<td>
											<select class="form-control vfsVal fatal_epi" id="emailAutof4" name="complaint_avoidance" disabled>
												<option vfs_val=0 vfs_max=0 <?php echo $agent_vfs['complaint_avoidance']=='No'?"selected":""; ?> value="No">No</option>
												<option vfs_val=0 vfs_max=0 <?php echo $agent_vfs['complaint_avoidance']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
											</select>
										</td>
										<td></td>
										<td><textarea class="form-control" disabled name="comm22"><?php echo $agent_vfs['comm22'] ?></textarea></td>
									</tr>
											<tr>
										<td style="background-color:#BFC9CA"><b>7</b></td>
										<td colspan=1 style="background-color:#BFC9CA">First Time Resolution (FTR)</td>
										<td style="background-color:#BFC9CA"></td>
										<td style="background-color:#BFC9CA"></td>
										<td style="background-color:#BFC9CA"></td>
										<td style="background-color:#BFC9CA"></td>
									</tr>
									<tr>
										<td></td>
										<td colspan=1>a. Disposition</td>
										<td></td>
										<td>
											<input type="text" class="form-control" id="disposition" name="disposition" disabled value="<?php echo $agent_vfs['disposition']; ?>">
										</td>
										<td></td>
										<td></td>
									</tr>
									<tr>
										<td></td>
										<td colspan=1>b. Communication mode through which customer contacted previously</td>
										<td></td>
										<td>
											<input type="text" class="form-control" id="contacted_previously" disabled name="contacted_previously" value="<?php echo $agent_vfs['contacted_previously']; ?>">
										</td>
										<td id=""></td>
										<td></td>
									</tr>
									<tr>
										<td></td>
										<td colspan=1>c. Description of Disposition selected</td>
										<td></td>
										<td>
											<input type="text" class="form-control" id="disposition_selected" disabled name="disposition_selected" value="<?php echo $agent_vfs['disposition_selected']; ?>">
										</td>
										<td id=""></td>
										<td></td>
									</tr>
									<tr>
										<td></td>
										<td colspan=1>d. Was this the first time customer called us ?</td>
										<td></td>
										<td>
											<select class="form-control" id="customer_called_first" name="customer_called_first" disabled>
												<option value="">Select</option>
												<option <?php echo $agent_vfs['customer_called_first']=='No'?"selected":""; ?> value="No">No</option>
												<option <?php echo $agent_vfs['customer_called_first']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
											</select>
										</td>
										<td id=""></td>
										<td><textarea class="form-control" disabled name="comm23"><?php echo $agent_vfs['comm23'] ?></textarea></td>
									</tr>
									<tr>
										<td></td>
										<td colspan=1>e. Did the customer call us more than once but less than 3 times ?</td>
										<td></td>
										<td>
											<select class="form-control" id="customer_called_less_three" disabled name="customer_called_less_three">
												<option value="">Select</option>
												<option <?php echo $agent_vfs['customer_called_less_three']=='No'?"selected":""; ?> value="No">No</option>
												<option <?php echo $agent_vfs['customer_called_less_three']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
											</select>
										</td>
										<td id=""></td>
										<td><textarea class="form-control" disabled name="comm24"><?php echo $agent_vfs['comm24'] ?></textarea></td>
									</tr>
									<tr>
										<td></td>
										<td colspan=1>f. Did the customer call us more than 3 times ?</td>
										<td></td>
										<td>
											<select class="form-control" id="customer_called_more_three" name="customer_called_more_three" disabled>
												<option value="">Select</option>
												<option <?php echo $agent_vfs['customer_called_more_three']=='No'?"selected":""; ?> value="No">No</option>
												<option <?php echo $agent_vfs['customer_called_more_three']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
											</select>
										</td>
										<td id=""></td>
										<td><textarea class="form-control" disabled name="comm25"><?php echo $agent_vfs['comm25'] ?></textarea></td>
									</tr>	
									
									<tr>
										<td>Email Summary:</td>
										<td colspan=2><textarea class="form-control"  disabled name="call_summary"><?php echo $agent_vfs['call_summary'] ?></textarea></td>
										<td>Feedback:</td>
										<td colspan=2><textarea class="form-control"  disabled name="feedback"><?php echo $agent_vfs['feedback'] ?></textarea></td>
									</tr>
									
									<?php if($agent_vfs['attach_file']!=''){ ?>
									<tr oncontextmenu="return false;">
										<td colspan="2">Audio Files (Mp4/Mp3/M4a/Wav)</td>
										<td colspan="4">
											<?php $attach_file = explode(",",$agent_vfs['attach_file']);
											 foreach($attach_file as $af){ ?>
												<audio oncontextmenu="return false;" controls controlslist="nodownload" style="background-color:#607F93">
													  <source src="<?php echo base_url(); ?>qa_files/qa_vfs/email/<?php echo $af; ?>" type="audio/ogg">
													  <source src="<?php echo base_url(); ?>qa_files/qa_vfs/email/<?php echo $af; ?>" type="audio/mpeg">
												</audio> </br>
											 <?php } ?>
										</td>
									</tr>
									<?php } ?>

									<tr>
										<td style="font-size:12px">Manager Review:</td>
										<td colspan="8" style="text-align:left"><?php echo $agent_vfs['mgnt_rvw_note'] ?></td>
									</tr>
									<tr>
										<td style="font-size:12px">Client Review:</td>
										<td colspan="8" style="text-align:left"><?php echo $agent_vfs['client_rvw_note'] ?></td>
									</tr>

									<tr><td colspan="10" style="background-color:#C5C8C8"></td></tr>
									
									 <form id="form_agent_user" method="POST" action="">
										<input type="hidden" name="pnid" class="form-control" value="<?php echo $pnid; ?>">
										
										<tr>
											<td colspan=2 style="font-size:16px">Feedback Acceptance<span style="font-size:24px;color:red">*</span></td>
											<td colspan=6>
												<select class="form-control" id="" name="agnt_fd_acpt" required="">
													<option value="">--Select--</option>
													<option <?php echo $agent_vfs['agnt_fd_acpt']=='Acceptance'?"selected":""; ?> value="Acceptance">Acceptance</option>	
													<option <?php echo $agent_vfs['agnt_fd_acpt']=='Not Acceptance'?"selected":""; ?> value="Not Acceptance">Not Acceptance</option>	
												</select>
											</td>
										</tr>
										<tr>
											<td colspan=2 style="font-size:16px">Your Review<span style="font-size:24px;color:red">*</span></td>
											<td colspan=6><textarea class="form-control" name="note" required><?php echo $agent_vfs['agent_rvw_note'] ?></textarea></td>
										</tr>
										
										<?php if(is_access_qa_agent_module()==true){
										if(is_available_qa_feedback($agent_vfs['entry_date'],72) == true){ ?>
											<tr>
												<?php if($agent_vfs['agent_rvw_note']==''){ ?>
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
	<?php } ?>		
	</section>
</div>
