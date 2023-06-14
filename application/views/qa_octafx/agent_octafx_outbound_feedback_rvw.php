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
									<tr style="background-color:#AEB6BF">
										<td colspan=6 id="theader" style="font-size:30px"> OCTA FX - OUTBOUND AGENT FORM</td>
										
										<input type="hidden" name="audit_start_time" value="<?php echo CurrMySqlDate(); ?>">
									</tr>
									<tr>
										<td>Agent Name:</td>
										<?php if($octafx_outbound['entry_by']!=''){
												$auditorName = $octafx_outbound['auditor_name'];
											}else{
												$auditorName = $octafx_outbound['client_name'];
										} ?>
										<td><input type="text" class="form-control" value="<?php echo $auditorName; ?>" disabled></td>
										<td>Audit Date:</td>
										<td><input type="text" class="form-control" value="<?php echo mysql2mmddyy($octafx_outbound['audit_date']); ?>" disabled></td>
										
										<td>Call Date:</td>
										<td><input type="text" class="form-control" id="call_date" name="call_date" value="<?php echo $octafx_outbound['call_date']; ?>" disabled></td>
									</tr>
									<tr>
										<td>Agent:</td>
										<td>
											<select class="form-control agentName" id="agent_id" name="data[agent_id]" disabled>
												<option value="<?php echo $octafx_outbound['agent_id'] ?>"><?php echo $octafx_outbound['fname']." ".$octafx_outbound['lname'] ?></option>
												<option value="">-Select-</option>
												<?php foreach($agentName as $row):  ?>
													<option value="<?php echo $row['id']; ?>"><?php echo $row['name'].' ('.$row['fusion_id'].')'; ?></option>
												<?php endforeach; ?>
											</select>
										</td>
										<td>Fusion ID:</td>
										<td><input type="text" readonly class="form-control" id="fusion_id" name="" value="<?php echo $octafx_outbound['fusion_id'] ?>"></td>
										<td>Supervisor:</td>
										<td>
										<input type="text" class="form-control" id="tl_names"  value="<?php echo $octafx_outbound['tl_name']; ?>" readonly>
												<input type="hidden" class="form-control" id="tl_id" name="data[tl_id]" value="<?php echo $octafx_outbound['tl_id'] ?>" disabled>
										</td>
									</tr>
									<tr>
										<td>Customer Id:</td>
										<td><input type="text" class="form-control" name="data[customer_id]" value="<?php echo $octafx_outbound['customer_id'] ?>" disabled></td>
										<td>Call Duration:</td>
										<td><input type="text" class="form-control" id="call_duration" name="data[call_duration]" value="<?php echo $octafx_outbound['call_duration'] ?>" disabled></td>
										<td>AON:</td>
										<td><input type="text" class="form-control" id="tenuarity" name="data[tenuarity]" value="<?php echo $octafx_outbound['tenuarity'] ?>" readonly></td>
									</tr>
									<tr>
										<td>Call Week:</td>
										<td>
											<input type="text" class="form-control" id="call_week" name="data[call_week]" value="<?php echo $octafx_outbound['call_week'] ?>" readonly>
										</td>
										
										<td>Audit Week:</td>
										<td>
											<input type="text" class="form-control" id="audit_week" name="data[audit_week]" value="<?php echo $octafx_outbound['audit_week'] ?>" readonly>
										</td>
										<td>Call type:</td>
										<td>
											<select class="form-control" name="data[call_type2]" disabled>
												<option value="">-Select-</option>
												<option <?php echo $octafx_outbound['call_type2']=='Fresh Call'?"selected":""; ?> value="Fresh Lead">Fresh Call</option>
												<option <?php echo $octafx_outbound['call_type2']=='Follow up'?"selected":""; ?> value="Follow up">Follow up</option>
											</select>
										</td>
									</tr>
									
									<tr>
										<td>VOC:</td>
										<td>
											<select class="form-control" id="voc" name="data[voc]" disabled>
												<option value="<?php echo $octafx_outbound['voc'] ?>"><?php echo $octafx_outbound['voc'] ?></option>
												<option value="">-Select-</option>
												<option value="1">1</option>
												<option value="2">2</option>
												<option value="3">3</option>
												<option value="4">4</option>
												<option value="5">5</option>
											</select>
										</td>
										<td>Call Id:</td>
										<td><input type="text" class="form-control" name="data[call_id]" value="<?php echo $octafx_outbound['call_id'] ?>" disabled></td>
										<td>Audit Type:</td>
										<td>
											<select class="form-control" id="audit_type" name="data[audit_type]" disabled>
												<option value="CQ Audit" <?= ($octafx_outbound['audit_type']=="CQ Audit")?"selected":"" ?>>CQ Audit</option>
                                                    <!--<option value="BQ Audit" <?= ($octafx_outbound['audit_type']=="BQ Audit")?"selected":"" ?>>BQ Audit</option>
                                                    <option value="Calibration" <?= ($octafx_outbound['audit_type']=="Calibration")?"selected":"" ?>>Calibration</option>
                                                    <option value="Pre-Certificate Mock Call" <?= ($octafx_outbound['audit_type']=="Pre-Certificate Mock Call")?"selected":"" ?>>Pre-Certificate Mock Call</option>
                                                    <option value="Certification Audit" <?= ($octafx_outbound['audit_type']=="Certification Audit")?"selected":"" ?>>Certification Audit</option>
                                                    <option value="WoW Call"  <?= ($octafx_outbound['audit_type']=="WoW Call")?"selected":"" ?>>WoW Call</option>
                                                    <option value="Hygiene Audit"  <?= ($octafx_outbound['audit_type']=="Hygiene Audit")?"selected":"" ?>>Hygiene Audit</option>
                                                    <option value="Operation Audit"  <?= ($octafx_outbound['audit_type']=="Operation Audit")?"selected":"" ?>>Operation Audit</option>
                                                    <option value="Trainer Audit"  <?= ($octafx_outbound['audit_type']=="Trainer Audit")?"selected":"" ?>>Trainer Audit</option>--> 
											</select>
										</td>
									</tr>
									<tr>
										<td class="auType">Auditor Type</td>
										<td class="auType">
											<select class="form-control" id="auditor_type" name="data[auditor_type]">
												<option value="<?php echo $octafx_outbound['auditor_type'] ?>"><?php echo $octafx_outbound['auditor_type'] ?></option>
												<option value="">-Select-</option>
												<option value="Master">Master</option>
												<option value="Regular">Regular</option>
											</select>
										</td>
										
									</tr>
									<tr class="eml" style="height:25px; font-weight:bold">
											<td colspan=2 class="eml"><p style="text-align:center">Conversion ACPT</p></td>
											<td colspan=2 class="eml"><p style="text-align:center">High AHT ACPT</p></td>
											<td colspan=2 class="eml"><p style="text-align:center">Call Reschedule ACPT</p></td>
									</tr>
									<tr>
										<td>
											<select class="form-control" name="data[conversion_acpt]" disabled>
												<option value="">-Select-</option>
												<option <?php echo $octafx_outbound['conversion_acpt']=='Agent'?"selected":""; ?> value="Agent">Agent</option>
												<option <?php echo $octafx_outbound['conversion_acpt']=='Client'?"selected":""; ?> value="Client">Client</option>
												<option <?php echo $octafx_outbound['conversion_acpt']=='Process'?"selected":""; ?> value="Process">Process</option>
												<option <?php echo $octafx_outbound['conversion_acpt']=='Technology'?"selected":""; ?> value="Technology">Technology</option>
												<option <?php echo $octafx_outbound['conversion_acpt']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
										<td><input type="text" name="data[conversion_acpt_remarks]" class="form-control" disabled value="<?php echo $octafx_outbound['conversion_acpt_remarks'] ?>"></td>
									
										<td>
											<select class="form-control" name="data[high_aht_acpt]" disabled>
												<option value="">-Select-</option>
												<option <?php echo $octafx_outbound['high_aht_acpt']=='Agent'?"selected":""; ?> value="Agent">Agent</option>
												<option <?php echo $octafx_outbound['high_aht_acpt']=='Client'?"selected":""; ?> value="Client">Client</option>
												<option <?php echo $octafx_outbound['high_aht_acpt']=='Process'?"selected":""; ?> value="Process">Process</option>
												<option <?php echo $octafx_outbound['high_aht_acpt']=='Technology'?"selected":""; ?> value="Technology">Technology</option>
												<option <?php echo $octafx_outbound['high_aht_acpt']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
										<td><input type="text" name="data[high_aht_acpt_remarks]" class="form-control" disabled value="<?php echo $octafx_outbound['high_aht_acpt_remarks'] ?>"></td>
									
										<td>
											<select class="form-control" name="data[call_reschedule_acpt]" disabled>
												<option value="">-Select-</option>
												<option <?php echo $octafx_outbound['call_reschedule_acpt']=='Agent'?"selected":""; ?> value="Agent">Agent</option>
												<option <?php echo $octafx_outbound['call_reschedule_acpt']=='Client'?"selected":""; ?> value="Client">Client</option>
												<option <?php echo $octafx_outbound['call_reschedule_acpt']=='Process'?"selected":""; ?> value="Process">Process</option>
												<option <?php echo $octafx_outbound['call_reschedule_acpt']=='Technology'?"selected":""; ?> value="Technology">Technology</option>
												<option <?php echo $octafx_outbound['call_reschedule_acpt']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
										<td><input type="text" disabled name="data[call_reschedule_remarks]" class="form-control" value="<?php echo $octafx_outbound['call_reschedule_remarks'] ?>"></td>
									</tr>
									<tr>
										<td style="font-weight:bold; font-size:16px">Earned Score:</td>
										<td><input type="text" readonly id="octa_earned" name="data[earned_score]" class="form-control" style="font-weight:bold" value="<?php echo $octafx_outbound['earned_score'] ?>"></td>
										<td style="font-weight:bold; font-size:16px">Possible Score:</td>
										<td><input type="text" readonly id="octa_possible" name="data[possible_score]" class="form-control" style="font-weight:bold" value="<?php echo $octafx_outbound['possible_score'] ?>"></td>
										<td style="font-weight:bold; font-size:16px; text-align:right">Overall Score:</td>
										<td><input type="text" readonly id="octa_overall" name="data[overall_score]" class="form-control octafx_outbound_Fatal" style="font-weight:bold" value="<?php echo $octafx_outbound['overall_score'] ?>"></td>
									</tr>
									
									<tr class="eml" style="height:25px; font-weight:bold">
											<td>PARAMETER</td>
											<td colspan=2>SUB PARAMETER</td>
											<td>WEIGHTAGE</td>
											<td>STATUS</td>
											<td colspan=2>REMARKS</td>
									</tr>

										<tr>
											<td class="eml1" rowspan=12>Call Handling</td>
												<td colspan=2>Preparation and Profile check on CRM</td>
												<td>5</td>
												<td>
													<select class="form-control octafx_outbound_point" name="data[preparation_profile_check]" disabled>
														
														<option octafx_val=5 octafx_max="5"<?php echo $octafx_outbound['preparation_profile_check'] == "Yes" ? "selected" : ""; ?> value="Yes">Yes</option>
														<option octafx_val=0 octafx_max="5" <?php echo $octafx_outbound['preparation_profile_check'] == "No" ? "selected" : ""; ?> value="No">No</option>
														<option octafx_val=5 octafx_max="5" <?php echo $octafx_outbound['preparation_profile_check'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
													</select>
												</td>
												<td colspan=2><input type="text" name="data[preparation_profile_check_reason]" class="form-control" value="<?php echo $octafx_outbound['preparation_profile_check_reason'] ?>"></td>
										</tr>
										<tr>
											<td colspan=2>Complete Introduction</td>
											<td>5</td>
											<td>
												<select class="form-control octafx_outbound_point" name="data[complete_introduction]" disabled>
													
													<option octafx_val=5 octafx_max="5"<?php echo $octafx_outbound['complete_introduction'] == "Yes" ? "selected" : ""; ?> value="Yes">Yes</option>
													<option octafx_val=0 octafx_max="5" <?php echo $octafx_outbound['complete_introduction'] == "No" ? "selected" : ""; ?> value="No">No</option>
													<!-- <option octafx_val=0 octafx_max="5" <?php //echo $octafx_outbound['complete_introduction'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option> -->
												</select>
											</td>
											<td colspan=2><input type="text" name="data[complete_introduction_reason]" class="form-control" value="<?php echo $octafx_outbound['complete_introduction_reason'] ?>"></td>
										</tr>
										<tr>
											<td colspan=2>Profiling to understand the client's background</td>
											<td>5</td>
											<td>
												<select class="form-control octafx_outbound_point" name="data[profiling_background]" disabled>
													
													<option octafx_val=5 octafx_max="5"<?php echo $octafx_outbound['profiling_background'] == "Yes" ? "selected" : ""; ?> value="Yes">Yes</option>
													<option octafx_val=0 octafx_max="5" <?php echo $octafx_outbound['profiling_background'] == "No" ? "selected" : ""; ?> value="No">No</option>
													<option octafx_val=5 octafx_max="5" <?php echo $octafx_outbound['profiling_background'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[profiling_background_reason]" class="form-control" value="<?php echo $octafx_outbound['profiling_background_reason'] ?>"></td>
										</tr>

										<tr>
											<td colspan=2>Proper explanation of product and offer, as per client's requirement</td>
											<td>5</td>
											<td>
												<select class="form-control octafx_outbound_point" name="data[proper_explation]" disabled>
													
													<option octafx_val=5 octafx_max="5"<?php echo $octafx_outbound['proper_explation'] == "Yes" ? "selected" : ""; ?> value="Yes">Yes</option>
													<option octafx_val=0 octafx_max="5" <?php echo $octafx_outbound['proper_explation'] == "No" ? "selected" : ""; ?> value="No">No</option>
													<option octafx_val=5 octafx_max="5" <?php echo $octafx_outbound['proper_explation'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[proper_explation_reason]" class="form-control" value="<?php echo $octafx_outbound['proper_explation_reason'] ?>"></td>
										</tr>
										<tr>
											<td colspan=2>Skillfully driving the call towards deposit</td>
											<td>5</td>
											<td>
												<select class="form-control octafx_outbound_point" name="data[skillfully_driving]" disabled>
													
													<option octafx_val=5 octafx_max="5"<?php echo $octafx_outbound['skillfully_driving'] == "Yes" ? "selected" : ""; ?> value="Yes">Yes</option>
													<option octafx_val=0 octafx_max="5" <?php echo $octafx_outbound['skillfully_driving'] == "No" ? "selected" : ""; ?> value="No">No</option>
													<option octafx_val=5 octafx_max="5" <?php echo $octafx_outbound['skillfully_driving'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[skillfully_driving_reason]" class="form-control" value="<?php echo $octafx_outbound['skillfully_driving_reason'] ?>"></td>
										</tr>
										<tr>
											<td colspan=2>Effective objection handling</td>
											<td>5</td>
											<td>
												<select class="form-control octafx_outbound_point" name="data[objection_handle]" disabled>
													
													<option octafx_val=5 octafx_max="5"<?php echo $octafx_outbound['objection_handle'] == "Yes" ? "selected" : ""; ?> value="Yes">Yes</option>
													<option octafx_val=0 octafx_max="5" <?php echo $octafx_outbound['objection_handle'] == "No" ? "selected" : ""; ?> value="No">No</option>
													<option octafx_val=5 octafx_max="5" <?php echo $octafx_outbound['objection_handle'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[objection_handle_reason]" class="form-control" value="<?php echo $octafx_outbound['objection_handle_reason'] ?>"></td>
										</tr>
										<tr>
											<td colspan=2>Proper probing if client doesn't show interest or raises any concern</td>
											<td>5</td>
											<td>
												<select class="form-control octafx_outbound_point" name="data[proper_probing]" disabled>
													
													<option octafx_val=5 octafx_max="5"<?php echo $octafx_outbound['proper_probing'] == "Yes" ? "selected" : ""; ?> value="Yes">Yes</option>
													<option octafx_val=0 octafx_max="5" <?php echo $octafx_outbound['proper_probing'] == "No" ? "selected" : ""; ?> value="No">No</option>
													<option octafx_val=5 octafx_max="5" <?php echo $octafx_outbound['proper_probing'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[proper_probing_reason]" class="form-control" value="<?php echo $octafx_outbound['proper_probing_reason'] ?>"></td>
										</tr>
										<tr>
											<td colspan=2>Building a two way communication to get client's engagement on call properly </td>
											<td>5</td>
											<td>
												<select class="form-control octafx_outbound_point" name="data[build_two_way_communication]" disabled>
													
													<option octafx_val=5 octafx_max="5"<?php echo $octafx_outbound['build_two_way_communication'] == "Yes" ? "selected" : ""; ?> value="Yes">Yes</option>
													<option octafx_val=0 octafx_max="5" <?php echo $octafx_outbound['build_two_way_communication'] == "No" ? "selected" : ""; ?> value="No">No</option>
													<option octafx_val=5 octafx_max="5" <?php echo $octafx_outbound['build_two_way_communication'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[build_two_way_communication_reason]" class="form-control" value="<?php echo $octafx_outbound['build_two_way_communication_reason'] ?>"></td>
										</tr>
										<tr>
											<td colspan=2>Urgency creation for deposit, if client asks for time</td>
											<td>5</td>
											<td>
												<select class="form-control octafx_outbound_point" name="data[urgency_creation]" disabled>
													
													<option octafx_val=5 octafx_max="5"<?php echo $octafx_outbound['urgency_creation'] == "Yes" ? "selected" : ""; ?> value="Yes">Yes</option>
													<option octafx_val=0 octafx_max="5" <?php echo $octafx_outbound['urgency_creation'] == "No" ? "selected" : ""; ?> value="No">No</option>
													<option octafx_val=5 octafx_max="5" <?php echo $octafx_outbound['urgency_creation'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[urgency_creation_reason]" class="form-control" value="<?php echo $octafx_outbound['urgency_creation_reason'] ?>"></td>
										</tr>
										<tr>
											<td colspan=2>Rebuttal used for higher amount of deposit, if client is looking to start with low</td>
											<td>5</td>
											<td>
												<select class="form-control octafx_outbound_point" name="data[rebuttal_used]" disabled>
													
													<option octafx_val=5 octafx_max="5"<?php echo $octafx_outbound['rebuttal_used'] == "Yes" ? "selected" : ""; ?> value="Yes">Yes</option>
													<option octafx_val=0 octafx_max="5" <?php echo $octafx_outbound['rebuttal_used'] == "No" ? "selected" : ""; ?> value="No">No</option>
													<option octafx_val=5 octafx_max="5" <?php echo $octafx_outbound['rebuttal_used'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[rebuttal_used_reason]" class="form-control" value="<?php echo $octafx_outbound['rebuttal_used_reason'] ?>"></td>
										</tr>
										<tr>
											<td colspan=2>Proper guidance about payment process and modes</td>
											<td>5</td>
											<td>
												<select class="form-control octafx_outbound_point" name="data[proper_guidance]" disabled>
													
													<option octafx_val=5 octafx_max="5"<?php echo $octafx_outbound['proper_guidance'] == "Yes" ? "selected" : ""; ?> value="Yes">Yes</option>
													<option octafx_val=0 octafx_max="5" <?php echo $octafx_outbound['proper_guidance'] == "No" ? "selected" : ""; ?> value="No">No</option>
													<option octafx_val=5 octafx_max="5" <?php echo $octafx_outbound['proper_guidance'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[proper_guidance_reason]" class="form-control" value="<?php echo $octafx_outbound['proper_guidance_reason'] ?>"></td>
										</tr>
										<tr>
											<td colspan=2>Taking call back request (if disabled)</td>
											<td>5</td>
											<td>
												<select class="form-control octafx_outbound_point" name="data[call_back]" disabled>
													
													<option octafx_val=5 octafx_max="5"<?php echo $octafx_outbound['call_back'] == "Yes" ? "selected" : ""; ?> value="Yes">Yes</option>
													<option octafx_val=0 octafx_max="5" <?php echo $octafx_outbound['call_back'] == "No" ? "selected" : ""; ?> value="No">No</option>
													<option octafx_val=5 octafx_max="5" <?php echo $octafx_outbound['call_back'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[call_back_reason]" class="form-control" value="<?php echo $octafx_outbound['call_back_reason'] ?>"></td>
										</tr>
									<tr>
										<td class="eml" rowspan=3>CRM action</td>
											<td colspan=2>Call was tagged properly</td>
											<td>4</td>
											<td>
												<select class="form-control octafx_outbound_point" name="data[tagged_properly]" disabled>
													
													<option octafx_val=4 octafx_max="4"<?php echo $octafx_outbound['tagged_properly'] == "Yes" ? "selected" : ""; ?> value="Yes">Yes</option>
													<option octafx_val=0 octafx_max="4" <?php echo $octafx_outbound['tagged_properly'] == "No" ? "selected" : ""; ?> value="No">No</option>
													<!-- <option octafx_val=0 octafx_max="4" <?php //echo $octafx_outbound['preparation_profile_check'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option> -->
												</select>
											</td>
											<td colspan=2><input type="text" name="data[tagged_properly_reason]" class="form-control" value="<?php echo $octafx_outbound['tagged_properly_reason'] ?>"></td>
										</tr>
										<tr>
											<td colspan=2>Email was send as per call scenario</td>
											<td>3</td>
											<td>
												<select class="form-control octafx_outbound_point" name="data[email_call_scenario]" disabled>
													
													<option octafx_val=3 octafx_max="3"<?php echo $octafx_outbound['email_call_scenario'] == "Yes" ? "selected" : ""; ?> value="Yes">Yes</option>
													<option octafx_val=0 octafx_max="3" <?php echo $octafx_outbound['email_call_scenario'] == "No" ? "selected" : ""; ?> value="No">No</option>
													 <option octafx_val=3 octafx_max="3" <?php echo $octafx_outbound['email_call_scenario'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option> 
												</select>
											</td>
											<td colspan=2><input type="text" name="data[email_call_scenario_reason]" class="form-control" value="<?php echo $octafx_outbound['email_call_scenario_reason'] ?>"></td>
										</tr>
										<tr>
											<td colspan=2>Call was rescheduled in CRM (if disabled)</td>
											<td>3</td>
											<td>
												<select class="form-control octafx_outbound_point" name="data[call_rescheduled]" disabled>
													
													<option octafx_val=3 octafx_max="3"<?php echo $octafx_outbound['call_rescheduled'] == "Yes" ? "selected" : ""; ?> value="Yes">Yes</option>
													<option octafx_val=0 octafx_max="3" <?php echo $octafx_outbound['call_rescheduled'] == "No" ? "selected" : ""; ?> value="No">No</option>
													 <option octafx_val=3 octafx_max="3" <?php echo $octafx_outbound['call_rescheduled'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option> 
												</select>
											</td>
											<td colspan=2><input type="text" name="data[call_rescheduled_reason]" class="form-control" value="<?php echo $octafx_outbound['call_rescheduled_reason'] ?>"></td>
										</tr>	
										<tr>
										<td class="eml2" rowspan=6>Softskills</td>
											<td colspan=2>Attentiveness (inactive or silent on call)</td>
											<td>5</td>
											<td>
												<select class="form-control octafx_outbound_point" name="data[attentiveness]" disabled>
													
													<option octafx_val=5 octafx_max="5"<?php echo $octafx_outbound['attentiveness'] == "Yes" ? "selected" : ""; ?> value="Yes">Yes</option>
													<option octafx_val=0 octafx_max="5" <?php echo $octafx_outbound['attentiveness'] == "No" ? "selected" : ""; ?> value="No">No</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[attentiveness_reason]" class="form-control" value="<?php echo $octafx_outbound['attentiveness_reason'] ?>"></td>
										</tr>
										<tr>
											<td colspan=2>Energetic and enthusiastic</td>
											<td>5</td>
											<td>
												<select class="form-control octafx_outbound_point" name="data[energetic_enthusiastic]" disabled>
													
													<option octafx_val=5 octafx_max="5"<?php echo $octafx_outbound['energetic_enthusiastic'] == "Yes" ? "selected" : ""; ?> value="Yes">Yes</option>
													<option octafx_val=0 octafx_max="5" <?php echo $octafx_outbound['energetic_enthusiastic'] == "No" ? "selected" : ""; ?> value="No">No</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[energetic_enthusiastic_reason]" class="form-control" value="<?php echo $octafx_outbound['energetic_enthusiastic_reason'] ?>"></td>
										</tr>
										<tr>
											<td colspan=2>Clarity and proper pace of speech</td>
											<td>5</td>
											<td>
												<select class="form-control octafx_outbound_point" name="data[pace_of_speech]" disabled>
													
													<option octafx_val=5 octafx_max="5"<?php echo $octafx_outbound['pace_of_speech'] == "Yes" ? "selected" : ""; ?> value="Yes">Yes</option>
													<option octafx_val=0 octafx_max="5" <?php echo $octafx_outbound['pace_of_speech'] == "No" ? "selected" : ""; ?> value="No">No</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[pace_of_speech_reason]" class="form-control" value="<?php echo $octafx_outbound['pace_of_speech_reason'] ?>"></td>
										</tr>
										<tr>
											<td colspan=2>Confident on call</td>
											<td>5</td>
											<td>
												<select class="form-control octafx_outbound_point" name="data[confident_call]" disabled>
													
													<option octafx_val=5 octafx_max="5"<?php echo $octafx_outbound['confident_call'] == "Yes" ? "selected" : ""; ?> value="Yes">Yes</option>
													<option octafx_val=0 octafx_max="5" <?php echo $octafx_outbound['confident_call'] == "No" ? "selected" : ""; ?> value="No">No</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[confident_call_reason]" class="form-control" value="<?php echo $octafx_outbound['confident_call_reason'] ?>"></td>
										</tr>
										<tr>
											<td colspan=2>Polite and friendly</td>
											<td>5</td>
											<td>
												<select class="form-control octafx_outbound_point" name="data[polite_friendly]" disabled>
													
													<option octafx_val=5 octafx_max="5"<?php echo $octafx_outbound['polite_friendly'] == "Yes" ? "selected" : ""; ?> value="Yes">Yes</option>
													<option octafx_val=0 octafx_max="5" <?php echo $octafx_outbound['polite_friendly'] == "No" ? "selected" : ""; ?> value="No">No</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[polite_friendly_reason]" class="form-control" value="<?php echo $octafx_outbound['polite_friendly_reason'] ?>"></td>
										</tr>
										<tr>
											<td colspan=2>No Interruption or Parallel talk</td>
											<td>5</td>
											<td>
												<select class="form-control octafx_outbound_point" name="data[parallel_talk]" disabled>
													
													<option octafx_val=5 octafx_max="5"<?php echo $octafx_outbound['parallel_talk'] == "Yes" ? "selected" : ""; ?> value="Yes">Yes</option>
													<option octafx_val=0 octafx_max="5" <?php echo $octafx_outbound['parallel_talk'] == "No" ? "selected" : ""; ?> value="No">No</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[parallel_talk_reason]" class="form-control" value="<?php echo $octafx_outbound['parallel_talk_reason'] ?>"></td>
										</tr>
										<tr>
										<td class="eml3" rowspan=4>Fatal parameter</td>
											<td colspan=2 class="text-danger">Misleading client for deposit/account verification</td>
											<td>0</td>
											<td>
												<select class="form-control octafx_outbound_point octafxAF1" name="data[account_verification]" disabled>
													
													<option octafx_val=0 octafx_max="0"<?php echo $octafx_outbound['account_verification'] == "Not-Fatal" ? "selected" : ""; ?> value="Not-Fatal">Not-Fatal</option>
													<option octafx_val=0 octafx_max="0" <?php echo $octafx_outbound['account_verification'] == "Fatal" ? "selected" : ""; ?> value="Fatal">Fatal</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[account_verification_reason]" class="form-control" value="<?php echo $octafx_outbound['account_verification_reason'] ?>"></td>
										</tr>
										<tr>
											<td colspan=2 class="text-danger">Asking for client's personal details (i.e account /payment mode details)</td>
											<td>0</td>
											<td>
												<select class="form-control octafx_outbound_point octafxAF2" name="data[clients_personal_details]" disabled>
													
													<option octafx_val=0 octafx_max="0"<?php echo $octafx_outbound['clients_personal_details'] == "Not-Fatal" ? "selected" : ""; ?> value="Not-Fatal">Not-Fatal</option>
													<option octafx_val=0 octafx_max="0" <?php echo $octafx_outbound['clients_personal_details'] == "Fatal" ? "selected" : ""; ?> value="Fatal">Fatal</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[clients_personal_details_reason]" class="form-control" value="<?php echo $octafx_outbound['clients_personal_details_reason'] ?>"></td>
										</tr>
										<tr>
											<td colspan=2 class="text-danger">Using sarcastice/commanding/impolite tone</td>
											<td>0</td>
											<td>
												<select class="form-control octafx_outbound_point octafxAF3" name="data[impolite_tone]" disabled>
													
													<option octafx_val=0 octafx_max="0"<?php echo $octafx_outbound['impolite_tone'] == "Not-Fatal" ? "selected" : ""; ?> value="Not-Fatal">Not-Fatal</option>
													<option octafx_val=0 octafx_max="0" <?php echo $octafx_outbound['impolite_tone'] == "Fatal" ? "selected" : ""; ?> value="Fatal">Fatal</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[impolite_tone_reason]" class="form-control" value="<?php echo $octafx_outbound['impolite_tone_reason'] ?>"></td>
										</tr>
										<tr>
											<td colspan=2 class="text-danger">Using profranity or having unprofessional discussion</td>
											<td>0</td>
											<td>
												<select class="form-control octafx_outbound_point octafxAF4" name="data[unprofessional_discussion]" disabled>
													
													<option octafx_val=0 octafx_max="0"<?php echo $octafx_outbound['unprofessional_discussion'] == "Not-Fatal" ? "selected" : ""; ?> value="Not-Fatal">Not-Fatal</option>
													<option octafx_val=0 octafx_max="0" <?php echo $octafx_outbound['unprofessional_discussion'] == "Fatal" ? "selected" : ""; ?> value="Fatal">Fatal</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[unprofessional_discussion_reason]" class="form-control" value="<?php echo $octafx_outbound['unprofessional_discussion_reason'] ?>"></td>
										</tr>
										<tr>
										<td class="eml4" rowspan=3>Reward scores</td>
											<td colspan=2>Client has verified the account on agent's request</td>
											<td>10</td>
											<td>
												<select class="form-control octafx_outbound_point" name="data[verified_account]" disabled>
													<option value="">Select</option>
													<option octafx_val=10 octafx_max="10"<?php echo $octafx_outbound['verified_account'] == "Yes" ? "selected" : ""; ?> value="Yes">Yes</option>
													<option octafx_val=0 octafx_max="0" <?php echo $octafx_outbound['verified_account'] == "No" ? "selected" : ""; ?> value="No">No</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[verified_account_reason]" class="form-control" value="<?php echo $octafx_outbound['verified_account_reason'] ?>"></td>
										</tr>
										<tr>
											<td colspan=2>Client has deposited on agent's request</td>
											<td>10</td>
											<td>
												<select class="form-control octafx_outbound_point" name="data[deposited_request]" disabled>
													<option value="">Select</option>
													<option octafx_val=10 octafx_max="10"<?php echo $octafx_outbound['deposited_request'] == "Yes" ? "selected" : ""; ?> value="Yes">Yes</option>
													<option octafx_val=0 octafx_max="0" <?php echo $octafx_outbound['deposited_request'] == "No" ? "selected" : ""; ?> value="No">No</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[deposited_request_reason]" class="form-control" value="<?php echo $octafx_outbound['deposited_request_reason'] ?>"></td>
										</tr>
										<tr>
											<td colspan=2>Client has deposited above KPI on agent's request</td>
											<td>10</td>
											<td>
												<select class="form-control octafx_outbound_point" name="data[deposited_KPI]" disabled>
													<option value="">Select</option>
													<option octafx_val=10 octafx_max="10"<?php echo $octafx_outbound['deposited_KPI'] == "Yes" ? "selected" : ""; ?> value="Yes">Yes</option>
													<option octafx_val=0 octafx_max="0" <?php echo $octafx_outbound['deposited_KPI'] == "No" ? "selected" : ""; ?> value="No">No</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[deposited_KPI_reason]" class="form-control" value="<?php echo $octafx_outbound['deposited_KPI_reason'] ?>"></td>
										</tr>
									<tr>
										<td>Audit Summary:</td>
										<td colspan=3><textarea class="form-control" id="" name="data[call_summary]"><?php echo $octafx_outbound['call_summary'] ?></textarea></td>
										<td>Audit Feedback:</td>
										<td colspan=3><textarea class="form-control" id="" name="data[feedback]"><?php echo $octafx_outbound['feedback'] ?></textarea></td>
									</tr>

									<?php if($octafx_outbound['attach_file']!=''){ ?>
									<tr oncontextmenu="return false;">
										<td colspan="2">Audio Files (Mp4/Mp3/M4a/Wav)</td>
										<td colspan="4">
											<?php $attach_file = explode(",",$octafx_outbound['attach_file']);
											 foreach($attach_file as $af){ ?>
												<audio oncontextmenu="return false;" controls controlslist="nodownload" style="background-color:#607F93">
													  <source src="<?php echo base_url(); ?>qa_files/octafx/<?php echo $af; ?>" type="audio/ogg">
													  <source src="<?php echo base_url(); ?>qa_files/octafx/<?php echo $af; ?>" type="audio/mpeg">
												</audio> </br>
											 <?php } ?>
										</td>
									</tr>
									<?php } ?>

									<tr>
										<td style="font-size:12px">Manager Review:</td>
										<td colspan="8" style="text-align:left"><?php echo $octafx_outbound['mgnt_rvw_note'] ?></td>
									</tr>
									<tr>
										<td style="font-size:12px">Client Review:</td>
										<td colspan="8" style="text-align:left"><?php echo $octafx_outbound['client_rvw_note'] ?></td>
									</tr>

									<tr><td colspan="10" style="background-color:#C5C8C8"></td></tr>
									
									 <form id="form_agent_user" method="POST" action="">
										<input type="hidden" name="octafx_id" class="form-control" value="<?php echo $octafx_id; ?>">
										
										<tr>
											<td colspan=2 style="font-size:16px">Feedback Acceptance<span style="font-size:24px;color:red">*</span></td>
											<td colspan=6>
												<select class="form-control" id="" name="agnt_fd_acpt" required="">
													<option value="">--Select--</option>
													<option <?php echo $octafx_outbound['agnt_fd_acpt']=='Acceptance'?"selected":""; ?> value="Acceptance">Acceptance</option>	
													<option <?php echo $octafx_outbound['agnt_fd_acpt']=='Not Acceptance'?"selected":""; ?> value="Not Acceptance">Not Acceptance</option>	
												</select>
											</td>
										</tr>
										<tr>
											<td colspan=2 style="font-size:16px">Your Review<span style="font-size:24px;color:red">*</span></td>
											<td colspan=6><textarea class="form-control" name="note" required><?php echo $octafx_outbound['agent_rvw_note'] ?></textarea></td>
										</tr>
										
										<?php if(is_access_qa_agent_module()==true){
										if(is_available_qa_feedback($octafx_outbound['entry_date'],72) == true){ ?>
											<tr>
												<?php if($octafx_outbound['agent_rvw_note']==''){ ?>
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
