
<style>

.table > tbody > tr > td{
	text-align: center;
	font-size:13px;
}

#theader{
	font-size:20px;
	font-weight:bold;
}

.eml{
	background-color:#85C1E9;
}

</style>

<div class="wrap">
	<section class="app-content">

		<div class="row">
			<div class="col-12">
				<div class="widget">
				
					<div class="widget-body">
						<div class="table-responsive">
							<table class="table table-striped skt-table" width="100%">
								<tbody>
									<tr style="background-color:#AEB6BF"><td colspan="8" id="theader" style="font-size:30px">AJIO <?php
								if($campaign == 'email_v2'){
									echo "Email [Version 2]";
									
								}else{
									echo $campaign;
								}
								  ?></td></tr>
									
									
									<?php if($campaign=="inbound"){ ?>
										
										<tr>
											<td>QA Name:</td>
											<?php if($ajio['entry_by']!=''){
													$auditorName = $ajio['auditor_name'];
												}else{
													$auditorName = $ajio['client_name'];
											} ?>
											<td><input type="text" class="form-control" value="<?php echo $auditorName; ?>" disabled></td>
											<td>Audit Date:</td>
											<td><input type="text" class="form-control" value="<?php echo mysql2mmddyy($ajio['audit_date']); ?>" disabled></td>
											<td>Call Date/Time:</td>
											<td ><input type="text" class="form-control" value="<?php echo mysql2mmddyy($ajio['call_date']); ?>" disabled></td>
										</tr>
										<tr>
											<td>Champ Name:</td>
											<td>
												<select class="form-control" id="agent_id" name="data[agent_id]" disabled >
													<option value="<?php echo $ajio['agent_id'] ?>"><?php echo $ajio['fname']." ".$ajio['lname'] ?></option>
													<option value="">-Select-</option>
													<?php foreach($agentName as $row):  ?>
														<option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
													<?php endforeach; ?>
												</select>
											</td>
											<td>Fusion ID:</td>
											<td><input type="text" class="form-control" id="fusion_id" value="<?php echo $ajio['fusion_id'] ?>" readonly ></td>
											<td>L1 Supervisor:</td>
											<td>
												<select class="form-control" id="tl_id" name="data[tl_id]" readonly>
													<option value="<?php echo $ajio['tl_id'] ?>"><?php echo $ajio['tl_name'] ?></option>
													<option value="">--Select--</option>
													<?php foreach($tlname as $tl): ?>
														<option value="<?php echo $tl['id']; ?>"><?php echo $tl['fname']." ".$tl['lname']; ?></option>
													<?php endforeach; ?>	
												</select>
											</td>
										</tr>
										<tr>
											<td>Champ BP ID:</td>
											<td><input type="text" class="form-control" name="data[agent_bp_id]" value="<?php echo $ajio['agent_bp_id'] ?>" disabled ></td>
											<td>Call Duration:</td>
											<td><input type="text" class="form-control" id="call_duration" name="data[call_duration]" value="<?php echo $ajio['call_duration'] ?>" disabled ></td>
											<td>Complete ID:</td>
											<td><input type="text" class="form-control" name="data[complete_id]" value="<?php echo $ajio['complete_id'] ?>" disabled ></td>
										</tr>
										<tr>
											<td>Nature of Call/ Dispositions:</td>
											<td>
												<select class="form-control" name="data[call_nature]" disabled>
													<option value="<?php echo $ajio['call_nature'] ?>"><?php echo $ajio['call_nature'] ?></option>
													<option value="">-Select-</option>
													<option value="Return/Refund Related Query">Return/Refund Related Query</option>
													<option value="Where is my stuff?">Where is my stuff?</option>
													<option value="Pickup related Query">Pickup related Query</option>
													<option value="Replacement/ Exchange related Query">Replacement/ Exchange related Query</option>
													<option value="Amount debited order not placed">Amount debited order not placed</option>
													<option value="Pre Order Query">Pre Order Query</option>
													<option value="Order cancellation">Order cancellation</option>
													<option value="AJIO money/ Points related Query">AJIO money/ Points related Query</option>
													<option value="Order not delivered but marked as delivered">Order not delivered but marked as delivered</option>
													<option value="Account login/ Profile update related issue">Account login/ Profile update related issue</option>
													<option value="Empty box received">Empty box received</option>
													<option value="Call back">Call back</option>
													<option value="Wrong item received">Wrong item received</option>
													<option value="Order delivered but marked as not delivered">Order delivered but marked as not delivered</option>
													<option value="Policy related query">Policy related query</option>
												</select>
											</td>
											<td>Opening</td>
											<td>
												<select class="form-control" name="data[opening]" disabled>
													<option value="">-Select-</option>
													<option <?php echo $ajio['opening'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
													<option <?php echo $ajio['opening'] == "No"?"selected":"";?> value="No">No</option>
												</select> 
											</td>
											<td>Probing</td>
											<td>
												<select class="form-control" name="data[probing]" disabled>
													<option value="">-Select-</option>
													<option <?php echo $ajio['probing'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
													<option <?php echo $ajio['probing'] == "No"?"selected":"";?> value="No">No</option>
												</select> 
											</td>
										</tr>
										<tr>
											<td>System Navigation</td>
											<td>
												<select class="form-control" name="data[system_navigation]" disabled>
													<option value="">-Select-</option>
													<option <?php echo $ajio['system_navigation'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
													<option <?php echo $ajio['system_navigation'] == "No"?"selected":"";?> value="No">No</option>
												</select> 
											</td>
											<td>Tagging:</td>
											<td>
												<select class="form-control" name="data[tagging]" disabled>
													<option value="<?php echo $ajio['tagging'] ?>"><?php echo $ajio['tagging'] ?></option>
													<option value="">-Select-</option>
													<option value="Correct">Correct</option>
													<option value="Incorrect">Incorrect</option>
													<option value="Multiple tagging not done when disabled">Multiple tagging not done when disabled</option>
													<option value="No Tagging">No Tagging</option>
												</select>
											</td>
											<td>Tagging L1:</td>
											<td>
												<select class="form-control" name="data[tagging_l1]" disabled>
													<option value="<?php echo $ajio['tagging_l1'] ?>"><?php echo $ajio['tagging_l1'] ?></option>
													<option value="">-Select-</option>
													<option value="Query understanding issue">Query understanding issue</option>
													<option value="Probing leading incorrect resolution/tagging">Probing leading incorrect resolution/tagging</option>
													<option value="Incorrect KM article referred">Incorrect KM article referred</option>
													<option value="Incorrect KM leg selection">Incorrect KM leg selection</option>
													<option value="Under No tagging : only KM referred no tagging">Under No tagging : only KM referred no tagging</option>
													<option value="Under No tagging : Only follow Cockpit no tagging">Under No tagging : Only follow Cockpit no tagging</option>
													<option value="Under No tagging :  No Resolution given with No">Under No tagging :  No Resolution given with No</option>
													<option value="Incorrect Intervention type">Incorrect Intervention type</option>
												</select>
											</td>
										</tr>
										<tr>
											<td>KM Navigation</td>
											<td>
												<select class="form-control" name="data[km_navigation]" disabled>
													<option value="">-Select-</option>
													<option <?php echo $ajio['km_navigation'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
													<option <?php echo $ajio['km_navigation'] == "No"?"selected":"";?> value="No">No</option>
													<option <?php echo $ajio['km_navigation'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
												</select> 
											</td>
											<td>Article Number:</td>
											<td><input type="text" class="form-control" name="data[article_no]" value="<?php echo $ajio['article_no'] ?>" disabled></td>
											<td>Fatal/Non Fatal:</td>
											<td>
												<select class="form-control" name="data[fatal_nonfatal]" disabled>
													<option value="<?php echo $ajio['fatal_nonfatal'] ?>"><?php echo $ajio['fatal_nonfatal'] ?></option>
													<option value="">-Select-</option>
													<option value="Fatal">Fatal</option>
													<option value="Non Fatal">Non Fatal</option>
												</select>
											</td>
										</tr>
										<tr>
											<td>Resolution Validation:</td>
											<td>
												<select class="form-control" name="data[resolution_validation]" disabled>
													<option value="<?php echo $ajio['resolution_validation'] ?>"><?php echo $ajio['resolution_validation'] ?></option>
													<option value="">-Select-</option>
													<option value="Correct Resolution">Correct Resolution</option>
													<option value="Incorrect Resolution">Incorrect Resolution</option>
													<option value="Incomplete Resolution">Incomplete Resolution</option>
													<option value="Inappropriate action taken">Inappropriate action taken</option>
													<option value="False Assurance">False Assurance</option>
												</select>
											</td>
											<td>L1 Drill Down:</td>
											<td><input type="text" class="form-control" name="data[l1_drill_down]" value="<?php echo $ajio['l1_drill_down'] ?>" disabled></td>
											<td>L2 Drill Down:</td>
											<td><input type="text" class="form-control" name="data[l2_drill_down]" value="<?php echo $ajio['l2_drill_down'] ?>" disabled></td>
										</tr>
										<tr>
											<td>Call/Chat Disconnection</td>
											<td>
												<select class="form-control" name="data[call_chat_disconnection]" disabled>
													<option value="">-Select-</option>
													<option <?php echo $ajio['call_chat_disconnection'] == "Compliance"?"selected":"";?> value="Compliance">Compliance</option>
													<option <?php echo $ajio['call_chat_disconnection'] == "Non Compliance"?"selected":"";?> value="Non Compliance">Non Compliance</option>
												</select> 
											</td>
											<td>Call/Chat/Email Avoidance</td>
											<td>
												<select class="form-control" name="data[call_chat_email_avoidance]" disabled>
													<option value="">-Select-</option>
													<option <?php echo $ajio['call_chat_email_avoidance'] == "Compliance"?"selected":"";?> value="Compliance">Compliance</option>
													<option <?php echo $ajio['call_chat_email_avoidance'] == "Non Compliance"?"selected":"";?> value="Non Compliance">Non Compliance</option>
												</select> 
											</td>
											<td>Flirting/Seeking personal details</td>
											<td>
												<select class="form-control" name="data[seeking_personal_details]" disabled>
													<option value="">-Select-</option>
													<option <?php echo $ajio['seeking_personal_details'] == "Compliance"?"selected":"";?> value="Compliance">Compliance</option>
													<option <?php echo $ajio['seeking_personal_details'] == "Non Compliance"?"selected":"";?> value="Non Compliance">Non Compliance</option>
												</select> 
											</td>
										</tr>
										<tr>
											<td>Rude Behavior/Mocking the customer</td>
											<td>
												<select class="form-control" name="data[rude_behavior]" disabled>
													<option value="">-Select-</option>
													<option <?php echo $ajio['rude_behavior'] == "Compliance"?"selected":"";?> value="Compliance">Compliance</option>
													<option <?php echo $ajio['rude_behavior'] == "Non Compliance"?"selected":"";?> value="Non Compliance">Non Compliance</option>
												</select> 
											</td>
											<td>Abusive Behavior</td>
											<td>
												<select class="form-control" name="data[abuse_behavior]" disabled>
													<option value="">-Select-</option>
													<option <?php echo $ajio['abuse_behavior'] == "Compliance"?"selected":"";?> value="Compliance">Compliance</option>
													<option <?php echo $ajio['abuse_behavior'] == "Non Compliance"?"selected":"";?> value="Non Compliance">Non Compliance</option>
												</select> 
											</td>
											<td>Making Changes to customer’s account without permission or seeking confidential information such as password, OTP etc. or data privacy breach</td>
											<td>
												<select class="form-control" name="data[change_customer_account_without_permission]" disabled>
													<option value="">-Select-</option>
													<option <?php echo $ajio['change_customer_account_without_permission'] == "Compliance"?"selected":"";?> value="Compliance">Compliance</option>
													<option <?php echo $ajio['change_customer_account_without_permission'] == "Non Compliance"?"selected":"";?> value="Non Compliance">Non Compliance</option>
												</select> 
											</td>
										</tr>
										<tr>
											<td>Incident ID:</td>
											<td><input type="text" class="form-control" name="data[incident_id]" value="<?php echo $ajio['incident_id'] ?>" disabled ></td>
											<td>TNPS Given:</td>
											<td>
												<select class="form-control" name="data[tnps_given]" disabled>
													<option value="<?php echo $ajio['tnps_given'] ?>"><?php echo $ajio['tnps_given'] ?></option>
													<option value="">-Select-</option>
													<option value="TNPS pitched">TNPS pitched</option>
													<option value="Didnot pitch TNPS">Didnot pitch TNPS</option>
													<option value="Incorrect TNPS Verbiages pitched">Incorrect TNPS Verbiages pitched</option>
													<option value="Survey Solicitation">Survey Solicitation</option>
													<option value="N/A">N/A</option>
												</select>
											</td>
											<td>Previous Interaction:</td>
											<td>
												<select class="form-control" name="data[previous_interaction]" disabled>
													<option value="">-Select-</option>
													<option <?php echo $ajio['previous_interaction'] == "Compliance"?"selected":"";?> value="Compliance">Compliance</option>
													<option <?php echo $ajio['previous_interaction'] == "Non Compliance"?"selected":"";?> value="Non Compliance">Non Compliance</option>
													<option <?php echo $ajio['previous_interaction'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
												</select>
											</td>
										</tr>
										<tr>
											<td>Audit Type:</td>
											<td>
												<select class="form-control" id="audit_type" name="data[audit_type]" disabled>
													<option value="<?php echo $ajio['audit_type'] ?>"><?php echo $ajio['audit_type'] ?></option>
													<option value="">-Select-</option>
													<option value="CQ Audit">CQ Audit</option>
													<option value="BQ Audit">BQ Audit</option>
													<option value="Calibration">Calibration</option>
													<option value="Pre-Certificate Mock Call">Pre-Certificate Mock Call</option>
													<option value="Certification Audit">Certification Audit</option>
													<option value="Operation Audit">Operation Audit</option>
													<option value="Trainer Audit">Trainer Audit</option>
													<option value="Hygiene Audit">Hygiene Audit</option>
												</select>
											</td>
											<td class="auType">Auditor Type</td>
											<td class="auType">
												<select class="form-control" id="auditor_type" name="data[auditor_type]">
													<option value="">-Select-</option>
													<option value="Master">Master</option>
													<option value="Regular">Regular</option>
												</select>
											</td>
											<td>VOC:</td>
											<td>
												<select class="form-control" id="voc" name="data[voc]" disabled>
													<option value="<?php echo $ajio['voc'] ?>"><?php echo $ajio['voc'] ?></option>
													<option value="">-Select-</option>
													<option value="1">1</option>
													<option value="2">2</option>
													<option value="3">3</option>
													<option value="4">4</option>
													<option value="5">5</option>
													<option value="6">6</option>
													<option value="7">7</option>
													<option value="8">8</option>
													<option value="9">9</option>
													<option value="10">10</option>
												</select>
											</td>
										</tr>
										
										<!--<tr>
											<td colspan=5 style="font-weight:bold; font-size:16px; text-align:right">Overall Score:</td>
											<td><input type="text" readonly id="ajio_overall_score" name="data[overall_score]" class="form-control ajioFatal" style="font-weight:bold" value="<?php //echo $ajio['overall_score'] ?>"></td>
										</tr>-->
										
										<tr>
											<td>Call Observation:</td>
											<td colspan=2><textarea class="form-control" name="data[call_summary]"><?php echo $ajio['call_summary'] ?></textarea></td>
											<td>Feedback:</td>
											<td colspan=2><textarea class="form-control" name="data[feedback]"><?php echo $ajio['feedback'] ?></textarea></td>
										</tr>
										<tr>
											<td colspan=2>Upload Files</td>
											<?php if($ajio['attach_file']!=''){ ?>
												<td colspan=4>
													<?php $attach_file = explode(",",$ajio['attach_file']);
													 foreach($attach_file as $mp){ ?>
														<audio controls='' style="background-color:#607F93"> 
														  <source src="<?php echo base_url(); ?>qa_files/qa_ajio/inbound/<?php echo $mp; ?>" type="audio/ogg">
														  <source src="<?php echo base_url(); ?>qa_files/qa_ajio/inbound/<?php echo $mp; ?>" type="audio/mpeg">
														</audio> </br>
													 <?php } ?>
												</td>
											<?php }else{
													echo '<td colspan=6><b>No Files</b></td>';
											} ?>
										</tr>
										
									<?php }

									else if($campaign=="inbound_v2"){ ?>
										
										<tr>
											<td>QA Name:</td>
											<?php if($ajio['entry_by']!=''){
													$auditorName = $ajio['auditor_name'];
												}else{
													$auditorName = $ajio['client_name'];
											} ?>
											<td><input type="text" class="form-control" value="<?php echo $auditorName; ?>" disabled></td>
											<td>Audit Date:<span style="font-size:24px;color:red">*</span></td>
											<td><input type="text" class="form-control" value="<?php echo mysql2mmddyy($ajio['audit_date']); ?>" disabled></td>
											<td >Call Date/Time:<span style="font-size:24px;color:red">*</span></td>
											<td colspan="2"><input type="text" class="form-control" value="<?php echo mysql2mmddyy($ajio['call_date']); ?>" disabled></td>
										</tr>
										<tr>
											<td>Champ Name:<span style="font-size:24px;color:red">*</span></td>
											<td>
												<select class="form-control" id="agent_id" name="data[agent_id]" disabled >
													<option value="<?php echo $ajio['agent_id'] ?>"><?php echo $ajio['fname']." ".$ajio['lname'] ?></option>
												</select>
											</td>
											<td>Fusion ID:<span style="font-size:24px;color:red">*</span></td>
											<td><input type="text" class="form-control" id="fusion_id" value="<?php echo $ajio['fusion_id'] ?>" readonly ></td>
											<td >L1 Supervisor:<span style="font-size:24px;color:red">*</span></td>
											<td>
												<select class="form-control" id="tl_id" name="data[tl_id]" readonly>
													<option value="<?php echo $ajio['tl_id'] ?>"><?php echo $ajio['tl_name'] ?></option>	
												</select>
											</td>
										</tr>
										<tr>
											<td>Type of Audit:<span style="font-size:24px;color:red">*</span></td>
											<td>
												<select class="form-control" name="data[type_of_audit]" disabled>
													<option value="<?php echo $ajio['type_of_audit'] ?>"><?php echo $ajio['type_of_audit'] ?></option>
												</select>
											</td>
											<td>Call ID:<span style="font-size:24px;color:red">*</span></td>
											<td><input type="text" class="form-control" name="data[call_id]" value="<?php echo $ajio['call_id'] ?>" disabled></td>
											<td >Predactive CSAT:<span style="font-size:24px;color:red">*</span></td>
											<td >
												<select class="form-control" id="audit_type" name="data[audit_type]" disabled>
													<option value="<?php echo $ajio['audit_type'] ?>"><?php echo $ajio['audit_type'] ?></option>
												</select>
											</td>
										</tr>
										<tr>
											<td>VOC:<span style="font-size:24px;color:red">*</span></td>
											<td>
												<select class="form-control" id="voc" name="data[voc]" disabled>
													<option value="<?php echo $ajio['voc'] ?>"><?php echo $ajio['voc'] ?></option>
												</select>
											</td>
											<td>Earned Score:</td>
											<td><input type="text" readonly id="earnedScore" name="data[earned_score]" class="form-control" style="font-weight:bold" value="<?php echo $ajio['earned_score'] ?>"></td>
											<td >Possible Score:</td>
											<td colspan="2"><input type="text" readonly id="possibleScore" name="data[possible_score]" class="form-control" style="font-weight:bold" value="<?php echo $ajio['possible_score'] ?>"></td>
										</tr>
										<tr>
											<td style="font-weight:bold; font-size:16px; text-align:right">Overall Score:</td>
											<td><input type="text" readonly id="overallScore" name="data[overall_score]" class="form-control ajioFatal" style="font-weight:bold" value="<?php echo $ajio['overall_score'] ?>"></td>
										</tr>
										<tr style="background-color:#85C1E9; font-weight:bold">
											<td>Parameter</td>
											<td colspan=2>Sub Parameter</td>
											<td>Defect</td>
											<td>L1 Reason</td>
											<td>L2 Reason</td>
										</tr>
										<tr>
											<td rowspan=4 style="background-color:#85C1E9; font-weight:bold">Call Quality & Ettiquettes</td>
											<td colspan=2 style="color:red">Did the champ open the call within 4 seconds and introduce himself properly</td>
											<td>
												<select class="form-control ajio fatal" id="ajioAF1" name="data[open_call_within_4sec]" disabled>
													<option ajio_val=5 ajio_max=5 <?php echo $ajio['open_call_within_4sec'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
													<option ajio_val=0 ajio_max=5 <?php echo $ajio['open_call_within_4sec'] == "No"?"selected":"";?> value="No">No</option>
													<option ajio_val=0 ajio_max=5 <?php echo $ajio['open_call_within_4sec'] == "Autofail"?"selected":"";?> value="Autofail">Autofail</option>
												</select>
											</td>
											<td><textarea class="form-control" name="data[l1_reason1]"><?php echo $ajio['l1_reason1'] ?></textarea></td>
											<td><textarea class="form-control" name="data[l2_reason1]"><?php echo $ajio['l2_reason1'] ?></textarea></td>
										</tr>
										<tr>
											<td colspan=2>Did the champ address the customer by name</td>
											<td>
												<select class="form-control ajio" name="data[address_customer_by_name]" disabled>
													<option ajio_val=5 ajio_max=5 <?php echo $ajio['address_customer_by_name'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
													<option ajio_val=0 ajio_max=5 <?php echo $ajio['address_customer_by_name'] == "No"?"selected":"";?> value="No">No</option>
												</select>
											</td>
											<td><textarea class="form-control" name="data[l1_reason2]"><?php echo $ajio['l1_reason2'] ?></textarea></td>
											<td><textarea class="form-control" name="data[l2_reason2]"><?php echo $ajio['l2_reason2'] ?></textarea></td>
										</tr>
										<tr>
											<td colspan=2 style="color:red">Champ followed the hold procedure as per the SOP</td>
											<td>
												<select class="form-control ajio fatal" id="ajioAF2" name="data[follow_hold_procedure]" disabled>
													<option ajio_val=5 ajio_max=5 <?php echo $ajio['follow_hold_procedure'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
													<option ajio_val=0 ajio_max=5 <?php echo $ajio['follow_hold_procedure'] == "Unwarranted Hold"?"selected":"";?> value="Unwarranted Hold">Unwarranted Hold</option>
													<option ajio_val=0 ajio_max=5 <?php echo $ajio['follow_hold_procedure'] == "Dead Air"?"selected":"";?> value="Dead Air">Dead Air</option>
													<option ajio_val=0 ajio_max=5 <?php echo $ajio['follow_hold_procedure'] == "Uninformed Hold"?"selected":"";?> value="Uninformed Hold">Uninformed Hold</option>
													<option ajio_val=0 ajio_max=5 <?php echo $ajio['follow_hold_procedure'] == "Uninformed Absence/mute"?"selected":"";?> value="Uninformed Absence/mute">Uninformed Absence/mute</option>
													<option ajio_val=0 ajio_max=5 <?php echo $ajio['follow_hold_procedure'] == "Hold not refreshed withinh stipulated time"?"selected":"";?> value="Hold not refreshed withinh stipulated time">Hold not refreshed withinh stipulated time</option>
													<option ajio_val=0 ajio_max=5 <?php echo $ajio['follow_hold_procedure'] == "Hold script/procedure not adhered"?"selected":"";?> value="Hold script/procedure not adhered">Hold script/procedure not adhered</option>
													<option ajio_val=0 ajio_max=5 <?php echo $ajio['follow_hold_procedure'] == "Autofail"?"selected":"";?> value="Autofail">Autofail</option>
												</select>
											</td>
											<td><textarea class="form-control" name="data[l1_reason3]"><?php echo $ajio['l1_reason3'] ?></textarea></td>
											<td><textarea class="form-control" name="data[l2_reason3]"><?php echo $ajio['l2_reason3'] ?></textarea></td>
										</tr>
										<tr>
											<td colspan=2 style="color:red">Did the champ offer further assistance and follow appropriate call closure/supervisor transfer process</td>
											<td>
												<select class="form-control ajio fatal" id="ajioAF3" name="data[follow_appropiate_call_closure]" disabled>
													<option ajio_val=5 ajio_max=5 <?php echo $ajio['follow_appropiate_call_closure'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
													<option ajio_val=0 ajio_max=5 <?php echo $ajio['follow_appropiate_call_closure'] == "Failed to offer further assistance"?"selected":"";?> value="Failed to offer further assistance">Failed to offer further assistance</option>
													<option ajio_val=0 ajio_max=5 <?php echo $ajio['follow_appropiate_call_closure'] == "Did not pitch for TNPs"?"selected":"";?> value="Did not pitch for TNPs">Did not pitch for TNPs</option>
													<option ajio_val=0 ajio_max=5 <?php echo $ajio['follow_appropiate_call_closure'] == "Did not follow call closing script"?"selected":"";?> value="Did not follow call closing script">Did not follow call closing script</option>
													<option ajio_val=0 ajio_max=5 <?php echo $ajio['follow_appropiate_call_closure'] == "Did not follow call transfer guidelines"?"selected":"";?> value="Did not follow call transfer guidelines">Did not follow call transfer guidelines</option>
													<option ajio_val=0 ajio_max=5 <?php echo $ajio['follow_appropiate_call_closure'] == "TNPS script not adhered/Influenced TNPS"?"selected":"";?> value="TNPS script not adhered/Influenced TNPS">TNPS script not adhered/Influenced TNPS</option>
													<option ajio_val=0 ajio_max=5 <?php echo $ajio['follow_appropiate_call_closure'] == "Did not use Genesys end call option"?"selected":"";?> value="Did not use Genesys end call option">Did not use Genesys end call option</option>
													<option ajio_val=0 ajio_max=5 <?php echo $ajio['follow_appropiate_call_closure'] == "Autofail"?"selected":"";?> value="Autofail">Autofail</option>
												</select>
											</td>
											<td><textarea class="form-control" name="data[l1_reason4]"><?php echo $ajio['l1_reason4'] ?></textarea></td>
											<td><textarea class="form-control" name="data[l2_reason4]"><?php echo $ajio['l2_reason4'] ?></textarea></td>
										</tr>
										<tr>
											<td rowspan=5 style="background-color:#85C1E9; font-weight:bold">Communication Skills</td>
											<td colspan=2>Was the champ polite and used apology and assurance wherever disabled</td>
											<td>
												<select class="form-control ajio" name="data[polite_use_appology]" disabled>
													<option ajio_val=5 ajio_max=5 <?php echo $ajio['polite_use_appology'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
													<option ajio_val=0 ajio_max=5 <?php echo $ajio['polite_use_appology'] == "Apology used but misplaced"?"selected":"";?> value="Apology used but misplaced">Apology used but misplaced</option>
													<option ajio_val=0 ajio_max=5 <?php echo $ajio['polite_use_appology'] == "Did not provide effective assurance"?"selected":"";?> value="Did not provide effective assurance">Did not provide effective assurance</option>
													<option ajio_val=0 ajio_max=5 <?php echo $ajio['polite_use_appology'] == "Did not acknowledge/apologize when disabled"?"selected":"";?> value="Did not acknowledge/apologize when disabled">Did not acknowledge/apologize when disabled</option>
													<option ajio_val=0 ajio_max=5 <?php echo $ajio['polite_use_appology'] == "Lack of pleasantries"?"selected":"";?> value="Lack of pleasantries">Lack of pleasantries</option>
												</select>
											</td>
											<td><textarea class="form-control" name="data[l1_reason5]"><?php echo $ajio['l1_reason5'] ?></textarea></td>
											<td><textarea class="form-control" name="data[l2_reason5]"><?php echo $ajio['l2_reason5'] ?></textarea></td>
										</tr>
										<tr>
											<td colspan=2>Was the champ able to comprehend and paraphrase the customer's concern</td>
											<td>
												<select class="form-control ajio" name="data[comprehend_customer_concern]" disabled>
													<option ajio_val=10 ajio_max=10 <?php echo $ajio['comprehend_customer_concern'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
													<option ajio_val=0 ajio_max=10 <?php echo $ajio['comprehend_customer_concern'] == "Asked unnecessary/irrelevant questions"?"selected":"";?> value="Asked unnecessary/irrelevant questions">Asked unnecessary/irrelevant questions</option>
													<option ajio_val=0 ajio_max=10 <?php echo $ajio['comprehend_customer_concern'] == "Asked details already available"?"selected":"";?> value="Asked details already available">Asked details already available</option>
													<option ajio_val=0 ajio_max=10 <?php echo $ajio['comprehend_customer_concern'] == "Unable to comprehend"?"selected":"";?> value="Unable to comprehend">Unable to comprehend</option>
													<option ajio_val=0 ajio_max=10 <?php echo $ajio['comprehend_customer_concern'] == "Failed to paraphrase to ensure understanding"?"selected":"";?> value="Failed to paraphrase to ensure understanding">Failed to paraphrase to ensure understanding</option>
												</select>
											</td>
											<td><textarea class="form-control" name="data[l1_reason6]"><?php echo $ajio['l1_reason6'] ?></textarea></td>
											<td><textarea class="form-control" name="data[l2_reason6]"><?php echo $ajio['l2_reason6'] ?></textarea></td>
										</tr>
										<tr>
											<td colspan=2>Did the champ display active listening skills without making the customer repeat</td>
											<td>
												<select class="form-control ajio" name="data[display_active_listening_skill]" disabled>
													<option ajio_val=5 ajio_max=5 <?php echo $ajio['display_active_listening_skill'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
													<option ajio_val=0 ajio_max=5 <?php echo $ajio['display_active_listening_skill'] == "Champ made the customer repeat"?"selected":"";?> value="Champ made the customer repeat">Champ made the customer repeat</option>
													<option ajio_val=0 ajio_max=5 <?php echo $ajio['display_active_listening_skill'] == "Did not listen actively impacting the call"?"selected":"";?> value="Did not listen actively impacting the call">Did not listen actively impacting the call</option>
												</select>
											</td>
											<td><textarea class="form-control" name="data[l1_reason7]"><?php echo $ajio['l1_reason7'] ?></textarea></td>
											<td><textarea class="form-control" name="data[l2_reason7]"><?php echo $ajio['l2_reason7'] ?></textarea></td>
										</tr>
										<tr>
											<td colspan=2>Was the champ able to handle objections effectively and offer rebuttals wherever disabled</td>
											<td>
												<select class="form-control ajio" name="data[handle_objection_effectively]" disabled>
													<option ajio_val=10 ajio_max=10 <?php echo $ajio['handle_objection_effectively'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
													<option ajio_val=0 ajio_max=10 <?php echo $ajio['handle_objection_effectively'] == "No"?"selected":"";?> value="No">No</option>
													<option ajio_val=10 ajio_max=10 <?php echo $ajio['handle_objection_effectively'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
												</select>
											</td>
											<td><textarea class="form-control" name="data[l1_reason8]"><?php echo $ajio['l1_reason8'] ?></textarea></td>
											<td><textarea class="form-control" name="data[l2_reason8]"><?php echo $ajio['l2_reason8'] ?></textarea></td>
										</tr>
										<tr>
											<td colspan=2>Was champ able to express/articulate himself and seamlessly converse with the customer</td>
											<td>
												<select class="form-control ajio" name="data[express_himself_with_customer]" disabled>
													<option ajio_val=10 ajio_max=10 <?php echo $ajio['express_himself_with_customer'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
													<option ajio_val=0 ajio_max=10 <?php echo $ajio['express_himself_with_customer'] == "Champ was struggling to express himself"?"selected":"";?> value="Champ was struggling to express himself">Champ was struggling to express himself</option>
													<option ajio_val=0 ajio_max=10 <?php echo $ajio['express_himself_with_customer'] == "Champ swtiched language to express himself"?"selected":"";?> value="Champ swtiched language to express himself">Champ swtiched language to express himself</option>
													<option ajio_val=0 ajio_max=10 <?php echo $ajio['express_himself_with_customer'] == "Customer expressed difficulty in understanding the champ"?"selected":"";?> value="Customer expressed difficulty in understanding the champ">Customer expressed difficulty in understanding the champ</option>
												</select>
											</td>
											<td><textarea class="form-control" name="data[l1_reason9]"><?php echo $ajio['l1_reason9'] ?></textarea></td>
											<td><textarea class="form-control" name="data[l2_reason9]"><?php echo $ajio['l2_reason9'] ?></textarea></td>
										</tr>
										<tr>
											<td rowspan=4 style="background-color:#85C1E9; font-weight:bold">Effective System Navigation & KM Usage</td>
											<td colspan=2>Did the champ refer to all releavnt articles/T2Rs correctly</td>
											<td>
												<select class="form-control ajio" name="data[refer_all_releavnt_article]" disabled>
													<option ajio_val=5 ajio_max=5 <?php echo $ajio['refer_all_releavnt_article'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
													<option ajio_val=0 ajio_max=5 <?php echo $ajio['refer_all_releavnt_article'] == "No"?"selected":"";?> value="No">No</option>
												</select>
											</td>
											<td><textarea class="form-control" name="data[l1_reason10]"><?php echo $ajio['l1_reason10'] ?></textarea></td>
											<td><textarea class="form-control" name="data[l2_reason10]"><?php echo $ajio['l2_reason10'] ?></textarea></td>
										</tr>
										<tr>
											<td colspan=2>Did the champ refer to different applications/portals/tools to identify the root cause of customer issue and enable resolution</td>
											<td>
												<select class="form-control ajio" name="data[refer_different_application]" disabled>
													<option ajio_val=5 ajio_max=5 <?php echo $ajio['refer_different_application'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
													<option ajio_val=0 ajio_max=5 <?php echo $ajio['refer_different_application'] == "No"?"selected":"";?> value="No">No</option>
												</select>
											</td>
											<td><textarea class="form-control" name="data[l1_reason11]"><?php echo $ajio['l1_reason11'] ?></textarea></td>
											<td><textarea class="form-control" name="data[l2_reason11]"><?php echo $ajio['l2_reason11'] ?></textarea></td>
										</tr>
										<tr>
											<td colspan=2 style="color:red">Call/Interaction was authenticated wherever disabled</td>
											<td>
												<select class="form-control ajio fatal" id="ajioAF4" name="data[call_was_authenticated]" disabled>
													<option ajio_val=5 ajio_max=5 <?php echo $ajio['call_was_authenticated'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
													<option ajio_val=0 ajio_max=5 <?php echo $ajio['call_was_authenticated'] == "No"?"selected":"";?> value="No">No</option>
													<option ajio_val=5 ajio_max=5 <?php echo $ajio['call_was_authenticated'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
													<option ajio_val=0 ajio_max=5 <?php echo $ajio['call_was_authenticated'] == "Autofail"?"selected":"";?> value="Autofail">Autofail</option>
												</select>
											</td>
											<td><textarea class="form-control" name="data[l1_reason12]"><?php echo $ajio['l1_reason12'] ?></textarea></td>
											<td><textarea class="form-control" name="data[l2_reason12]"><?php echo $ajio['l2_reason12'] ?></textarea></td>
										</tr>
										<tr>
											<td colspan=2>Was the champ able to effectively navigate through and toggle between different tools/aids to wrap up the call in a timely manner</td>
											<td>
												<select class="form-control ajio" name="data[effectively_navigate_through]" disabled>
													<option ajio_val=5 ajio_max=5 <?php echo $ajio['effectively_navigate_through'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
													<option ajio_val=0 ajio_max=5 <?php echo $ajio['effectively_navigate_through'] == "No"?"selected":"";?> value="No">No</option>
												</select>
											</td>
											<td><textarea class="form-control" name="data[l1_reason13]"><?php echo $ajio['l1_reason13'] ?></textarea></td>
											<td><textarea class="form-control" name="data[l2_reason13]"><?php echo $ajio['l2_reason13'] ?></textarea></td>
										</tr>
										<tr>
											<td rowspan=3 style="background-color:#85C1E9; font-weight:bold">Issue Resolution</td>
											<td colspan=2 style="color:red">Champ executed all necessary actions to ensure issue resolution</td>
											<td>
												<select class="form-control ajio fatal" id="ajioAF5" name="data[executed_all_necessary]" disabled>
													<option ajio_val=5 ajio_max=5 <?php echo $ajio['executed_all_necessary'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
													<option ajio_val=0 ajio_max=5 <?php echo $ajio['executed_all_necessary'] == "Autofail"?"selected":"";?> value="Autofail">Autofail</option>
												</select>
											</td>
											<td>
												<select class="form-control" name="data[l1_reason14]" disabled>
												<option value=""></option>
												<option <?php echo $ajio['l1_reason14'] == "C&R raised when not required"?"selected":"";?> value="C&R raised when not required">C&R raised when not required</option>
												<option <?php echo $ajio['l1_reason14'] == "C&R not raised when required"?"selected":"";?> value="C&R not raised when required">C&R not raised when required</option>
												<option <?php echo $ajio['l1_reason14'] == "Wrong C&R raised"?"selected":"";?> value="Wrong C&R raised">Wrong C&R raised</option>
												<option <?php echo $ajio['l1_reason14'] == "C&R raised without images/appropriate details"?"selected":"";?> value="C&R raised without images/appropriate details">C&R raised without images/appropriate details</option>
												<option <?php echo $ajio['l1_reason14'] == "Action not taken & Unnecessary redirection"?"selected":"";?> value="Action not taken & Unnecessary redirection">Action not taken & Unnecessary redirection</option>
											</select>
											</td>
											<td><textarea class="form-control" name="data[l2_reason14]"><?php echo $ajio['l2_reason14'] ?></textarea></td>
										</tr>
										<tr>
											<td colspan=2 style="color:red">All the queries were answered properly and in an informative way to avoid repeat call. Champ provided a clear understanding of action taken and the way forward to the customer</td>
											<td>
												<select class="form-control ajio" name="data[queries_answered_properly]" disabled>
													<option ajio_val=10 ajio_max=10 <?php echo $ajio['queries_answered_properly'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ajio_val=0 ajio_max=10 <?php echo $ajio['queries_answered_properly'] == "Autofail"?"selected":"";?> value="Autofail">Autofail</option>
												</select>
											</td>
											<td>
												<!-- <textarea class="form-control" name="data[l1_reason15]"><?php //echo $ajio['l1_reason15'] ?></textarea> -->
												<select class="form-control" name="data[l1_reason15]" disabled>
												<option value=""></option>
												<option <?php echo $ajio['l1_reason15'] == "Incorrect information Shared"?"selected":"";?> value="Incorrect information Shared">Incorrect information Shared</option>
												<option <?php echo $ajio['l1_reason15'] == "Incomplete information Shared"?"selected":"";?> value="Incomplete information Shared">Incomplete information Shared</option>
												<option <?php echo $ajio['l1_reason15'] == "Wrong action taken & No action taken"?"selected":"";?> value="Wrong action taken & No action taken">Wrong action taken & No action taken</option>
											</select>
											</td>
											<td><textarea class="form-control" name="data[l2_reason15]"><?php echo $ajio['l2_reason15'] ?></textarea></td>
										</tr>
										<tr>
											<td colspan=2 style="color:red">Did the champ document the case correctly and adhered to tagging guidelines</td>
											<td>
												<select class="form-control ajio fatal" id="ajioAF6" name="data[document_the_case_correctly]" disabled>
													<option ajio_val=5 ajio_max=5 <?php echo $ajio['document_the_case_correctly'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
													<option ajio_val=0 ajio_max=5 <?php echo $ajio['document_the_case_correctly'] == "CAM rule not adhered to"?"selected":"";?> value="CAM rule not adhered to">CAM rule not adhered to</option>
													<option ajio_val=0 ajio_max=5 <?php echo $ajio['document_the_case_correctly'] == "Documented on incorrect account"?"selected":"";?> value="Documented on incorrect account">Documented on incorrect account</option>
													<option ajio_val=0 ajio_max=5 <?php echo $ajio['document_the_case_correctly'] == "All queries not documented"?"selected":"";?> value="All queries not documented">All queries not documented</option>
													<option ajio_val=0 ajio_max=5 <?php echo $ajio['document_the_case_correctly'] == "Autofail"?"selected":"";?> value="Autofail">Autofail</option>
												</select>
											</td>
											<td><textarea class="form-control" name="data[l1_reason16]"><?php echo $ajio['l1_reason16'] ?></textarea></td>
											<td><textarea class="form-control" name="data[l2_reason16]"><?php echo $ajio['l2_reason16'] ?></textarea></td>
										</tr>
										<tr>
											<td style="background-color:#F1948A; font-weight:bold">ZTP</td>
											<td colspan=2 style="color:red">As per AJIO ZTP guidelines</td>
											<td>
												<select class="form-control ajio fatal" id="ajioAF7" name="data[ztp_guidelines]" disabled>
													<option ajio_val=0 ajio_max=0 <?php echo $ajio['ztp_guidelines'] == "No"?"selected":"";?> value="No">No</option>
													<option ajio_val=0 ajio_max=0 <?php echo $ajio['ztp_guidelines'] == "Autofail"?"selected":"";?> value="Autofail">Autofail</option>
												</select>
											</td>
											<td><textarea class="form-control" name="data[l1_reason14]"><?php echo $ajio['l1_reason14'] ?></textarea></td>
											<td><textarea class="form-control" name="data[l2_reason14]"><?php echo $ajio['l2_reason14'] ?></textarea></td>
										</tr>
										<tr>
											<td>Call Synopsis:</td>
											<td colspan=3><textarea class="form-control" readonly name="data[call_synopsis]"><?php echo $ajio['call_synopsis'] ?></textarea></td>
										</tr>
										<tr>
											<td>Call Observation:</td>
											<td colspan=2><textarea class="form-control" readonly name="data[call_summary]"><?php echo $ajio['call_summary'] ?></textarea></td>
											<td>Feedback:</td>
											<td colspan=2><textarea class="form-control" readonly name="data[feedback]"><?php echo $ajio['feedback'] ?></textarea></td>
										</tr>
										<tr>
											<td colspan=2>Upload Files</td>
											<?php if($ajio['attach_file']!=''){ ?>
												<td colspan=4>
													<?php $attach_file = explode(",",$ajio['attach_file']);
													 foreach($attach_file as $mp){ ?>
														<audio controls='' style="background-color:#607F93"> 
														  <source src="<?php echo base_url(); ?>qa_files/qa_ajio/inbound/<?php echo $mp; ?>" type="audio/ogg">
														  <source src="<?php echo base_url(); ?>qa_files/qa_ajio/inbound/<?php echo $mp; ?>" type="audio/mpeg">
														</audio> </br>
													 <?php } ?>
												</td>
											<?php }else{
													echo '<td colspan=6><b>No Files</b></td>';
											} ?>
										</tr>
									
									<?php }else if($campaign=="email_v2"){ ?>
										
										<tr>
											<td>QA Name:</td>
											<?php if($ajio['entry_by']!=''){
													$auditorName = $ajio['auditor_name'];
												}else{
													$auditorName = $ajio['client_name'];
											} ?>
											<td><input type="text" class="form-control" value="<?php echo $auditorName; ?>" disabled></td>
											<td>Audit Date:</td>
											<td><input type="text" class="form-control" value="<?php echo mysql2mmddyy($ajio['audit_date']); ?>" disabled></td>
											<td colspan="2">Call Date/Time:</td>
											<td><input type="text" class="form-control" value="<?php echo mysql2mmddyy($ajio['call_date']); ?>" disabled></td>
										</tr>
										<tr>
											<td>Champ Name:</td>
											<td>
												<select class="form-control" id="agent_id" name="data[agent_id]" disabled >
													<option value="<?php echo $ajio['agent_id'] ?>"><?php echo $ajio['fname']." ".$ajio['lname'] ?></option>
												</select>
											</td>
											<td>Fusion ID:</td>
											<td><input type="text" class="form-control" id="fusion_id" value="<?php echo $ajio['fusion_id'] ?>" readonly ></td>
											<td colspan="2">L1 Supervisor:</td>
											<td>
												<select class="form-control" id="tl_id" name="data[tl_id]" readonly>
													<option value="<?php echo $ajio['tl_id'] ?>"><?php echo $ajio['tl_name'] ?></option>	
												</select>
											</td>
										</tr>
										<tr>
											<td>Type of Audit:</td>
											<td>
												<select class="form-control" name="data[type_of_audit]" disabled>
													<option value="<?php echo $ajio['type_of_audit'] ?>"><?php echo $ajio['type_of_audit'] ?></option>
												</select>
											</td>
											<td>Interaction ID:</td>
											<td><input type="text" class="form-control" name="data[call_id]" value="<?php echo $ajio['call_id'] ?>" disabled></td>
											<td colspan="2">Predactive CSAT:</td>
											<td>
												<select class="form-control" id="audit_type" name="data[audit_type]" disabled>
													<option value="<?php echo $ajio['audit_type'] ?>"><?php echo $ajio['audit_type'] ?></option>
												</select>
											</td>
										</tr>
										<tr>
											<td>VOC:</td>
											<td>
												<select class="form-control" id="voc" name="data[voc]" disabled>
													<option value="<?php echo $ajio['voc'] ?>"><?php echo $ajio['voc'] ?></option>
												</select>
											</td>
											<td>Earned Score:</td>
											<td><input type="text" readonly id="earnedScore" name="data[earned_score]" class="form-control" style="font-weight:bold" value="<?php echo $ajio['earned_score'] ?>"></td>
											<td colspan="2">Possible Score:</td>
											<td><input type="text" readonly id="possibleScore" name="data[possible_score]" class="form-control" style="font-weight:bold" value="<?php echo $ajio['possible_score'] ?>"></td>
										</tr>
										<tr>
											<td style="font-weight:bold; font-size:16px; text-align:right">Overall Score:</td>
											<td><input type="text" readonly id="overallScore" name="data[overall_score]" class="form-control ajioFatal" style="font-weight:bold" value="<?php echo $ajio['overall_score'] ?>"></td>
										</tr>
										<tr style="background-color:#85C1E9; font-weight:bold">
											<td>Parameter</td>
											<td colspan=2>Sub Parameter</td>
											<td>Defect</td>
											<td>Weightage</td>
											<td>L1 Reason</td>
											<td>L2 Reason</td>
										</tr>
									<tr>
										<td rowspan=7 style="background-color:#85C1E9; font-weight:bold">Comprehension & Email Ettiquettes</td>
										<td colspan=2>Did the champ use appropriate acknowledgements, re-assurance and apology wherever required</td>
										<td>
											<select class="form-control ajio" id="" name="data[appropriate_acknowledgements]" disabled>
												<option ajio_val=10 ajio_max=10 <?php echo $ajio['appropriate_acknowledgements'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ajio_val=0 ajio_max=10 <?php echo $ajio['appropriate_acknowledgements'] == "Failed to assure the customer when needed"?"selected":"";?> value="Failed to assure the customer when needed">Failed to assure the customer when needed</option>
												<option ajio_val=0 ajio_max=10 <?php echo $ajio['appropriate_acknowledgements'] == "Did not empathize when needed"?"selected":"";?> value="Did not empathize when needed">Did not empathize when needed</option>
												<option ajio_val=0 ajio_max=10 <?php echo $ajio['appropriate_acknowledgements'] == "Incorrect acknowledgement used"?"selected":"";?> value="Incorrect acknowledgement used">Incorrect acknowledgement used</option>
											</select>
										</td>
										<td>10</td>
										<td><textarea class="form-control" disabled name="data[l1_reason1]"><?php echo $ajio['l1_reason1'] ?></textarea></td>
										<td><textarea class="form-control" disabled name="data[l2_reason1]"><?php echo $ajio['l2_reason1'] ?></textarea></td>
									</tr>
									<tr>
										<td colspan=2>Did the champ use font, font size, and formatting  as per AJIO's brand guidelines</td>
										<td>
											<select class="form-control ajio" name="data[font_size_formatting]" disabled>
												<option ajio_val=5 ajio_max=5 <?php echo $ajio['font_size_formatting'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ajio_val=0 ajio_max=5 <?php echo $ajio['font_size_formatting'] == "Incorrect font size/color"?"selected":"";?> value="Incorrect font size/color">Incorrect font size/color</option>
												<option ajio_val=0 ajio_max=5 <?php echo $ajio['font_size_formatting'] == "Email was not formatted appropriately"?"selected":"";?> value="Email was not formatted appropriately">Email was not formatted appropriately</option>
												<option ajio_val=0 ajio_max=5 <?php echo $ajio['font_size_formatting'] == "Incorrect date structure"?"selected":"";?> value="Incorrect date structure">Incorrect date structure</option>
												<option ajio_val=0 ajio_max=5 <?php echo $ajio['font_size_formatting'] == "Incorrect subject line"?"selected":"";?> value="Incorrect subject line">Incorrect subject line</option>
												<option ajio_val=0 ajio_max=5 <?php echo $ajio['font_size_formatting'] == "Responded without trail"?"selected":"";?> value="Responded without trail">Responded without trail</option>
											</select>
										</td>
										<td>5</td>
										<td><textarea class="form-control" disabled name="data[l1_reason2]"><?php echo $ajio['l1_reason2'] ?></textarea></td>
										<td><textarea class="form-control" disabled name="data[l2_reason2]"><?php echo $ajio['l2_reason2'] ?></textarea></td>
									</tr>
									<tr>
										<td colspan=2>Was the email response in line with AJIO's approved template/format</td>
										<td>
											<select class="form-control ajio" id="" name="data[email_response]" disabled>
												<option ajio_val=5 ajio_max=5 <?php echo $ajio['email_response'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ajio_val=0 ajio_max=5 <?php echo $ajio['email_response'] == "No"?"selected":"";?> value="No">No</option>
											</select>
										</td>
										<td>5</td>
										<td><textarea class="form-control" disabled name="data[l1_reason3]"><?php echo $ajio['l1_reason3'] ?></textarea></td>
										<td><textarea class="form-control" disabled name="data[l2_reason3]"><?php echo $ajio['l2_reason3'] ?></textarea></td>
									</tr>
									<tr>
										<td colspan=2 style="color:red">Did the champ use appropriate template(s) and customized it to ensure all concerns raised were answered appropriately</td>
										<td>
											<select class="form-control ajio fatal" id="ajioAF1" name="data[use_appropriate_template]" disabled>
												<option ajio_val=10 ajio_max=10 <?php echo $ajio['use_appropriate_template'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ajio_val=0 ajio_max=10 <?php echo $ajio['use_appropriate_template'] == "Autofail"?"selected":"";?> value="Autofail">Autofail</option>
											</select>
										</td>
										<td>10</td>
										<td><textarea class="form-control" disabled name="data[l1_reason4]"><?php echo $ajio['l1_reason4'] ?></textarea></td>
										<td><textarea class="form-control" disabled name="data[l2_reason4]"><?php echo $ajio['l2_reason4'] ?></textarea></td>
									</tr>
									<tr>
										<td colspan=2>Did the champ maintain accuracy of written communication ensuring no grammatical errors, SVAs, Punctuation and sentence construction errors.</td>
										<td>
											<select class="form-control ajio" id="" name="data[written_communication]" disabled>
												<option ajio_val=10 ajio_max=10 <?php echo $ajio['written_communication'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ajio_val=0 ajio_max=10 <?php echo $ajio['written_communication'] == "Incorrect sentence Structure"?"selected":"";?> value="Incorrect sentence Structure">Incorrect sentence Structure</option>
												<option ajio_val=0 ajio_max=10 <?php echo $ajio['written_communication'] == "incorrect spacing"?"selected":"";?> value="incorrect spacing">incorrect spacing</option>
												<option ajio_val=0 ajio_max=10 <?php echo $ajio['written_communication'] == "Grammatical error"?"selected":"";?> value="Grammatical error">Grammatical error</option>
												<option ajio_val=0 ajio_max=10 <?php echo $ajio['written_communication'] == "Incorrect punctuation"?"selected":"";?> value="Incorrect punctuation">Incorrect punctuation</option>
											</select>
										</td>
										<td>10</td>
										<td><textarea class="form-control" disabled name="data[l1_reason5]"><?php echo $ajio['l1_reason5'] ?></textarea></td>
										<td><textarea class="form-control" disabled name="data[l2_reason5]"><?php echo $ajio['l2_reason5'] ?></textarea></td>
									</tr>
									<tr>
										<td colspan=2 style="color:red">Did the champ refer to all relevant previous interactions when required to gather information about customer's account and issue end to end</td>
										<td>
											<select class="form-control ajio fatal" id="ajioAF2" name="data[relevant_previous_interactions]" disabled>
												<option ajio_val=10 ajio_max=10 <?php echo $ajio['use_appropriate_template'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ajio_val=0 ajio_max=10 <?php echo $ajio['relevant_previous_interactions'] == "Autofail"?"selected":"";?> value="Autofail">Autofail</option>
											</select>
										</td>
										<td>10</td>
										<td><textarea class="form-control" disabled name="data[l1_reason6]"><?php echo $ajio['l1_reason6'] ?></textarea></td>
										<td><textarea class="form-control" disabled name="data[l2_reason6]"><?php echo $ajio['l2_reason6'] ?></textarea></td>
									</tr>
									<tr>
										<td colspan=2>Was the champ able to identify and handle objections effectively and offer rebuttals wherever required</td>
										<td>
											<select class="form-control ajio" id="" name="data[handle_objections]" disabled>
												<option ajio_val=10 ajio_max=10 <?php echo $ajio['handle_objections'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ajio_val=0 ajio_max=10 <?php echo $ajio['handle_objections'] == "Failed to address customer's objection(s)/emotion(s)"?"selected":"";?> value="Failed to address customer's objection(s)/emotion(s)">Failed to address customer's objection(s)/emotion(s)</option>
												<option ajio_val=0 ajio_max=10 <?php echo $ajio['handle_objections'] == "Did not use objection handling script/statement"?"selected":"";?> value="Did not use objection handling script/statement">Did not use objection handling script/statement</option>
												<option ajio_val=0 ajio_max=10 <?php echo $ajio['handle_objections'] == "Inappropriate/Incorrect rebuttals provided"?"selected":"";?> value="Inappropriate/Incorrect rebuttals provided">Inappropriate/Incorrect rebuttals provided</option>
											</select>
										</td>
										<td>10</td>
										<td><textarea class="form-control" disabled name="data[l1_reason7]"><?php echo $ajio['l1_reason7'] ?></textarea></td>
										<td><textarea class="form-control" disabled name="data[l2_reason7]"><?php echo $ajio['l2_reason7'] ?></textarea></td>
									</tr>
									<tr>
										<td rowspan=4 style="background-color:#85C1E9; font-weight:bold">Effective System Navigation & KM Usage</td>
										<td colspan=2>Did the champ refer to all releavnt articles/T2Rs correctly</td>
										<td>
											<select class="form-control ajio" name="data[all_relevant_articles]" disabled>
												<option ajio_val=5 ajio_max=5 <?php echo $ajio['all_relevant_articles'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ajio_val=0 ajio_max=5 <?php echo $ajio['all_relevant_articles'] == "No"?"selected":"";?> value="No">No</option>
												<option ajio_val=0 ajio_max=0 <?php echo $ajio['all_relevant_articles'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td>5</td>
										<td><textarea class="form-control" disabled name="data[l1_reason8]"><?php echo $ajio['l1_reason8'] ?></textarea></td>
										<td><textarea class="form-control" disabled name="data[l2_reason8]"><?php echo $ajio['l2_reason8'] ?></textarea></td>
									</tr>
									<tr>
										<td colspan=2>Did the champ refer to different applications/portals/tools to identify the root cause of customer issue and enable resolution.</td>
										<td>
											<select class="form-control ajio" name="data[applications_portals]" disabled>
												<option ajio_val=5 ajio_max=5 <?php echo $ajio['applications_portals'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ajio_val=0 ajio_max=5 <?php echo $ajio['applications_portals'] == "Asked for information that was already available"?"selected":"";?> value="Asked for information that was already available">Asked for information that was already available</option>
												<option ajio_val=0 ajio_max=5 <?php echo $ajio['applications_portals'] == "Did not use all means to enable resolution"?"selected":"";?> value="Did not use all means to enable resolution">Did not use all means to enable resolution</option>
											</select>
										</td>
										<td>5</td>
										<td><textarea class="form-control" disabled name="data[l1_reason9]"><?php echo $ajio['l1_reason9'] ?></textarea></td>
										<td><textarea class="form-control" disabled name="data[l2_reason9]"><?php echo $ajio['l2_reason9'] ?></textarea></td>
									</tr>
									<tr>
										<td colspan=2 style="color:red">Email/Interaction was authenticated wherever required</td>
										<td>
											<select class="form-control ajio fatal" id="ajioAF3" name="data[email_interaction]" disabled>
												<option ajio_val=5 ajio_max=5 <?php echo $ajio['email_interaction'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ajio_val=0 ajio_max=5 <?php echo $ajio['email_interaction'] == "Autofail"?"selected":"";?> value="Autofail">Autofail</option>
												<option ajio_val=0 ajio_max=0 <?php echo $ajio['email_interaction'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td>5</td>
										<td><textarea class="form-control" disabled name="data[l1_reason10]"><?php echo $ajio['l1_reason10'] ?></textarea></td>
										<td><textarea class="form-control" disabled name="data[l2_reason10]"><?php echo $ajio['l2_reason10'] ?></textarea></td>
									</tr>
									<tr>
										<td colspan=2>Did the champ take ownership and request for outcall/call back was addressed wherever required</td>
										<td>
											<select class="form-control ajio" name="data[outcall_call_back]" disabled>
												<option ajio_val=5 ajio_max=5 <?php echo $ajio['outcall_call_back'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ajio_val=0 ajio_max=5 <?php echo $ajio['outcall_call_back'] == "No"?"selected":"";?> value="No">No</option>
												<option ajio_val=0 ajio_max=0 <?php echo $ajio['outcall_call_back'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td>5</td>
										<td><textarea class="form-control" disabled name="data[l1_reason11]"><?php echo $ajio['l1_reason11'] ?></textarea></td>
										<td><textarea class="form-control" disabled name="data[l2_reason11]"><?php echo $ajio['l2_reason11'] ?></textarea></td>
									</tr>
									<tr>
										<td rowspan=3 style="background-color:#85C1E9; font-weight:bold">Issue Resolution</td>
										<td colspan=2 style="color:red">Champ executed all necessary actions to ensure issue resolution</td>
										<td>
											<select class="form-control ajio fatal" id="ajioAF4" name="data[ensure_issue_resolution]" disabled>
												<option ajio_val=5 ajio_max=5 <?php echo $ajio['ensure_issue_resolution'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ajio_val=0 ajio_max=5 <?php echo $ajio['ensure_issue_resolution'] == "Autofail"?"selected":"";?> value="Autofail">Autofail</option>
											</select>
										</td>
										<td>5</td>
										<td>
											<!-- <textarea class="form-control" name="data[l1_reason10]"><?php //echo $ajio['l1_reason10'] ?></textarea> -->
											<select class="form-control" name="data[l1_reason12]" disabled >
												<option value=""></option>
												<option <?php echo $ajio['l1_reason12'] == "C&R raised when not required"?"selected":"";?> value="C&R raised when not required">C&R raised when not required</option>
												<option <?php echo $ajio['l1_reason12'] == "C&R not raised when required"?"selected":"";?> value="C&R not raised when required">C&R not raised when required</option>
												<option <?php echo $ajio['l1_reason12'] == "Wrong C&R raised"?"selected":"";?> value="Wrong C&R raised">Wrong C&R raised</option>
												<option <?php echo $ajio['l1_reason12'] == "C&R raised without images/appropriate details"?"selected":"";?> value="C&R raised without images/appropriate details">C&R raised without images/appropriate details</option>
												<option <?php echo $ajio['l1_reason12'] == "Action not taken"?"selected":"";?> value="Action not taken">Action not taken</option>
												<option <?php echo $ajio['l1_reason12'] == "Unnecessary redirection"?"selected":"";?> value="Unnecessary redirection">Unnecessary redirection</option>
												<option <?php echo $ajio['l1_reason12'] == "Autofail & Yes"?"selected":"";?> value="Autofail & Yes">Autofail & Yes</option>
											</select>
										</td>
										<td><textarea class="form-control" disabled name="data[l2_reason12]"><?php echo $ajio['l2_reason12'] ?></textarea></td>
									</tr>
									<tr>
										<td colspan=2 style="color:red">All the queries were answered properly and in an informative way to avoid repeat call. Champ provided a clear understanding of action taken and the way forward to the customer.</td>
										<td>
											<select class="form-control ajio fatal" id="ajioAF5" name="data[avoid_repeat_call]" disabled>
												<option ajio_val=10 ajio_max=10 <?php echo $ajio['avoid_repeat_call'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ajio_val=0 ajio_max=10 <?php echo $ajio['avoid_repeat_call'] == "Autofail"?"selected":"";?> value="Autofail">Autofail</option>
											</select>
										</td>
										<td>10</td>
										<td>
											<!-- <textarea class="form-control" name="data[l1_reason13]"><?php //echo $ajio['l1_reason13'] ?></textarea> -->
											<select class="form-control" name="data[l1_reason13]" disabled >
												<option value=""></option>
												<option <?php echo $ajio['l1_reason13'] == "Incorrect information Shared"?"selected":"";?> value="Incorrect information Shared">Incorrect information Shared</option>
												<option <?php echo $ajio['l1_reason13'] == "Incomplete information Shared"?"selected":"";?> value="Incomplete information Shared">Incomplete information Shared</option>
												<option <?php echo $ajio['l1_reason13'] == "False assurance"?"selected":"";?> value="False assurance">False assurance</option>
											</select>
										</td>
										<td><textarea class="form-control" disabled name="data[l2_reason13]"><?php echo $ajio['l2_reason13'] ?></textarea></td>
									</tr>
									<tr>
										<td colspan=2 style="color:red">Did the champ document the case correctly and adhered to tagging guidelines.</td>
										<td>
											<select class="form-control ajio fatal" id="ajioAF6" name="data[tagging_guidelines]" disabled>
												<option ajio_val=5 ajio_max=5 <?php echo $ajio['tagging_guidelines'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ajio_val=0 ajio_max=5 <?php echo $ajio['tagging_guidelines'] == "Autofail"?"selected":"";?> value="Autofail">Autofail</option>
												<option ajio_val=0 ajio_max=5 <?php echo $ajio['tagging_guidelines'] == "CAM rule not adhered to."?"selected":"";?> value="CAM rule not adhered to.">CAM rule not adhered to.</option>
												<option ajio_val=5 ajio_max=5 <?php echo $ajio['tagging_guidelines'] == "Documented on incorrect account"?"selected":"";?> value="Documented on incorrect account">Documented on incorrect account</option>
												<option ajio_val=0 ajio_max=5 <?php echo $ajio['tagging_guidelines'] == "All queries not documented"?"selected":"";?> value="All queries not documented">All queries not documented</option>
											</select>
										</td>
										<td>5</td>
										<td><textarea class="form-control" disabled name="data[l1_reason14]"><?php echo $ajio['l1_reason14'] ?></textarea></td>
										<td><textarea class="form-control" disabled name="data[l2_reason14]"><?php echo $ajio['l2_reason14'] ?></textarea></td>
									</tr>
									<tr>
										<td style="background-color:#F1948A; font-weight:bold">ZTP</td>
										<td colspan=2 style="color:red">As per AJIO ZTP guidelines</td>
										<td>
											<select class="form-control ajio fatal" id="ajioAF7" name="data[ztp_guidelines]" disabled>
												<option ajio_val=0 ajio_max=0 <?php echo $ajio['ztp_guidelines'] == "No"?"selected":"";?> value="No">No</option>
												<option ajio_val=0 ajio_max=0 <?php echo $ajio['ztp_guidelines'] == "Autofail"?"selected":"";?> value="Autofail">Autofail</option>
											</select>
										</td>
										<td>0</td>
										<td><textarea class="form-control" disabled name="data[l1_reason15]"><?php echo $ajio['l1_reason15'] ?></textarea></td>
										<td><textarea class="form-control" disabled name="data[l2_reason15]"><?php echo $ajio['l2_reason15'] ?></textarea></td>
									</tr>
										<tr>
											<td>Call Synopsis:</td>
											<td colspan=3><textarea class="form-control" readonly name="data[call_synopsis]"><?php echo $ajio['call_synopsis'] ?></textarea></td>
										</tr>
										<tr>
											<td>Call Observation:</td>
											<td colspan=2><textarea class="form-control" readonly name="data[call_summary]"><?php echo $ajio['call_summary'] ?></textarea></td>
											<td>Feedback:</td>
											<td colspan=3><textarea class="form-control" readonly name="data[feedback]"><?php echo $ajio['feedback'] ?></textarea></td>
										</tr>
										<tr>
											<td colspan=2>Upload Files</td>
											<?php if($ajio['attach_file']!=''){ ?>
												<td colspan=4>
													<?php $attach_file = explode(",",$ajio['attach_file']);
													 foreach($attach_file as $mp){ ?>
														<audio controls='' style="background-color:#607F93"> 
														  <source src="<?php echo base_url(); ?>qa_files/qa_ajio/email/<?php echo $mp; ?>" type="audio/ogg">
														  <source src="<?php echo base_url(); ?>qa_files/qa_ajio/email/<?php echo $mp; ?>" type="audio/mpeg">
														</audio> </br>
													 <?php } ?>
												</td>
											<?php }else{
													echo '<td colspan=6><b>No Files</b></td>';
											} ?>
										</tr>
									
									<?php }
									else if($campaign=="email"){ ?>
									
										<tr>
											<td>QA Name:</td>
											<?php if($ajio['entry_by']!=''){
													$auditorName = $ajio['auditor_name'];
												}else{
													$auditorName = $ajio['client_name'];
											} ?>
											<td><input type="text" class="form-control" value="<?php echo $auditorName; ?>" disabled></td>
											<td>Audit Date:</td>
											<td><input type="text" class="form-control" value="<?php echo mysql2mmddyy($ajio['audit_date']); ?>" disabled></td>
											<td>Call Date/Time:</td>
											<td><input type="text" class="form-control" value="<?php echo mysql2mmddyy($ajio['call_date']); ?>" disabled></td>
										</tr>
										<tr>
											<td>Champ Name:</td>
											<td>
												<select class="form-control" id="agent_id" name="data[agent_id]" disabled >
													<option value="<?php echo $ajio['agent_id'] ?>"><?php echo $ajio['fname']." ".$ajio['lname'] ?></option>
													<option value="">-Select-</option>
													<?php foreach($agentName as $row):  ?>
														<option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
													<?php endforeach; ?>
												</select>
											</td>
											<td>Fusion ID:</td>
											<td><input type="text" class="form-control" id="fusion_id" value="<?php echo $ajio['fusion_id'] ?>" readonly ></td>
											<td>L1 Supervisor:</td>
											<td>
												<select class="form-control" id="tl_id" name="data[tl_id]" readonly>
													<option value="<?php echo $ajio['tl_id'] ?>"><?php echo $ajio['tl_name'] ?></option>
													<option value="">--Select--</option>
													<?php foreach($tlname as $tl): ?>
														<option value="<?php echo $tl['id']; ?>"><?php echo $tl['fname']." ".$tl['lname']; ?></option>
													<?php endforeach; ?>	
												</select>
											</td>
										</tr>
										<tr>
											<td>Champ BP ID:</td>
											<td><input type="text" class="form-control" name="data[agent_bp_id]" value="<?php echo $ajio['agent_bp_id'] ?>" disabled ></td>
											<td>Call Duration:</td>
											<td><input type="text" class="form-control" id="call_duration" name="data[call_duration]" value="<?php echo $ajio['call_duration'] ?>" disabled ></td>
											<td>Complete ID:</td>
											<td><input type="text" class="form-control" name="data[complete_id]" value="<?php echo $ajio['complete_id'] ?>" disabled ></td>
										</tr>
										<tr>
											<td>Nature of Call/ Dispositions:</td>
											<td>
												<select class="form-control" name="data[call_nature]" disabled>
													<option value="<?php echo $ajio['call_nature'] ?>"><?php echo $ajio['call_nature'] ?></option>
													<option value="">-Select-</option>
													<option value="Return/Refund Related Query">Return/Refund Related Query</option>
													<option value="Where is my stuff?">Where is my stuff?</option>
													<option value="Pickup related Query">Pickup related Query</option>
													<option value="Replacement/ Exchange related Query">Replacement/ Exchange related Query</option>
													<option value="Amount debited order not placed">Amount debited order not placed</option>
													<option value="Pre Order Query">Pre Order Query</option>
													<option value="Order cancellation">Order cancellation</option>
													<option value="AJIO money/ Points related Query">AJIO money/ Points related Query</option>
													<option value="Order not delivered but marked as delivered">Order not delivered but marked as delivered</option>
													<option value="Account login/ Profile update related issue">Account login/ Profile update related issue</option>
													<option value="Empty box received">Empty box received</option>
													<option value="Call back">Call back</option>
													<option value="Wrong item received">Wrong item received</option>
													<option value="Order delivered but marked as not delivered">Order delivered but marked as not delivered</option>
													<option value="Policy related query">Policy related query</option>
												</select>
											</td>
											<td>Opening</td>
											<td>
												<select class="form-control" name="data[opening]" disabled>
													<option value="">-Select-</option>
													<option <?php echo $ajio['opening'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
													<option <?php echo $ajio['opening'] == "No"?"selected":"";?> value="No">No</option>
												</select> 
											</td>
											<td>Closing</td>
											<td>
												<select class="form-control" name="data[closing]" disabled>
													<option value="">-Select-</option>
													<option <?php echo $ajio['closing'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
													<option <?php echo $ajio['closing'] == "No"?"selected":"";?> value="No">No</option>
												</select> 
											</td>
										</tr>
										<tr>
											<td>Previous Interaction Checking:</td>
											<td>
												<select class="form-control" name="data[previous_interaction]" disabled>
													<option value="">-Select-</option>
													<option <?php echo $ajio['previous_interaction'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
													<option <?php echo $ajio['previous_interaction'] == "No"?"selected":"";?> value="No">No</option>
												</select>
											</td>
											<td>Probing</td>
											<td>
												<select class="form-control" name="data[probing]" disabled>
													<option value="">-Select-</option>
													<option <?php echo $ajio['probing'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
													<option <?php echo $ajio['probing'] == "No"?"selected":"";?> value="No">No</option>
												</select> 
											</td>
											<td>Communication (Grammar):</td>
											<td>
												<select class="form-control" name="data[communication]" disabled>
													<option value="<?php echo $ajio['communication'] ?>"><?php echo $ajio['communication'] ?></option>
													<option value="">-Select-</option>
													<option value="Grammar & punchuation">Grammar & punchuation</option>
													<option value="Irrelevant Response">Irrelevant Response</option>
													<option value="Repetition of same canned">Repetition of same canned</option>
													<option value="Incorrect sentence formation">Incorrect sentence formation</option>
													<option value="Robotic response">Robotic response</option>
													<option value="Others">Others</option>
												</select>
											</td>
										</tr>
										<tr>
											<td>Apology/ Empathy/ Assurance Given:</td>
											<td>
												<select class="form-control" name="data[apology_empathy]" disabled>
													<option value="<?php echo $ajio['apology_empathy'] ?>"><?php echo $ajio['apology_empathy'] ?></option>
													<option value="">-Select-</option>
													<option value="Grammar & punchuation">Grammar & punchuation</option>
													<option value="Irrelevant Response">Irrelevant Response</option>
													<option value="Repetition of same canned">Repetition of same canned</option>
													<option value="Incorrect sentence formation">Incorrect sentence formation</option>
													<option value="Robotic response">Robotic response</option>
													<option value="Others">Others</option>
												</select>
											</td>
											<td>System Navigation</td>
											<td>
												<select class="form-control" name="data[system_navigation]" disabled>
													<option value="">-Select-</option>
													<option <?php echo $ajio['system_navigation'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
													<option <?php echo $ajio['system_navigation'] == "No"?"selected":"";?> value="No">No</option>
												</select> 
											</td>
											<td>Tagging:</td>
											<td>
												<select class="form-control" name="data[tagging]" disabled>
													<option value="<?php echo $ajio['tagging'] ?>"><?php echo $ajio['tagging'] ?></option>
													<option value="">-Select-</option>
													<option value="Correct">Correct</option>
													<option value="Incorrect">Incorrect</option>
													<option value="Multiple tagging not done when disabled">Multiple tagging not done when disabled</option>
													<option value="No Tagging">No Tagging</option>
												</select>
											</td>
										</tr>
										<tr>
											<td>Tagging L1:</td>
											<td>
												<select class="form-control" name="data[tagging_l1]" disabled>
													<option value="<?php echo $ajio['tagging_l1'] ?>"><?php echo $ajio['tagging_l1'] ?></option>
													<option value="">-Select-</option>
													<option value="Query understanding issue">Query understanding issue</option>
													<option value="Probing leading incorrect resolution/tagging">Probing leading incorrect resolution/tagging</option>
													<option value="Incorrect KM article referred">Incorrect KM article referred</option>
													<option value="Incorrect KM leg selection">Incorrect KM leg selection</option>
													<option value="Under No tagging : only KM referred no tagging">Under No tagging : only KM referred no tagging</option>
													<option value="Under No tagging : Only follow Cockpit no tagging">Under No tagging : Only follow Cockpit no tagging</option>
													<option value="Under No tagging :  No Resolution given with No">Under No tagging :  No Resolution given with No</option>
													<option value="Incorrect Intervention type">Incorrect Intervention type</option>
												</select>
											</td>
											<td>KM Navigation</td>
											<td>
												<select class="form-control" name="data[km_navigation]" disabled>
													<option value="">-Select-</option>
													<option <?php echo $ajio['km_navigation'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
													<option <?php echo $ajio['km_navigation'] == "No"?"selected":"";?> value="No">No</option>
													<option <?php echo $ajio['km_navigation'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
												</select> 
											</td>
											<td>Article Number:</td>
											<td><input type="text" class="form-control" name="data[article_no]" value="<?php echo $ajio['article_no'] ?>" disabled></td>
										</tr>
										<tr>
											<td>TNPS Given:</td>
											<td>
												<select class="form-control" name="data[tnps_given]" disabled>
													<option value="<?php echo $ajio['tnps_given'] ?>"><?php echo $ajio['tnps_given'] ?></option>
													<option value="">-Select-</option>
													<option value="TNPS pitched">TNPS pitched</option>
													<option value="Didnot pitch TNPS">Didnot pitch TNPS</option>
													<option value="Incorrect TNPS Verbiages pitched">Incorrect TNPS Verbiages pitched</option>
													<option value="Survey Solicitation">Survey Solicitation</option>
													<option value="N/A">N/A</option>
												</select>
											</td>
											<td>Fatal/Non Fatal:</td>
											<td>
												<select class="form-control" name="data[fatal_nonfatal]" disabled>
													<option value="<?php echo $ajio['fatal_nonfatal'] ?>"><?php echo $ajio['fatal_nonfatal'] ?></option>
													<option value="">-Select-</option>
													<option value="Fatal">Fatal</option>
													<option value="Non Fatal">Non Fatal</option>
												</select>
											</td>
										</tr>
										<tr>
											<td>Resolution Validation:</td>
											<td>
												<select class="form-control" name="data[resolution_validation]" disabled>
													<option value="<?php echo $ajio['resolution_validation'] ?>"><?php echo $ajio['resolution_validation'] ?></option>
													<option value="">-Select-</option>
													<option value="Correct Resolution">Correct Resolution</option>
													<option value="Incorrect Resolution">Incorrect Resolution</option>
													<option value="Incomplete Resolution">Incomplete Resolution</option>
													<option value="Inappropriate action taken">Inappropriate action taken</option>
													<option value="False Assurance">False Assurance</option>
												</select>
											</td>
											<td>L1 Drill Down:</td>
											<td><input type="text" class="form-control" name="data[l1_drill_down]" value="<?php echo $ajio['l1_drill_down'] ?>" disabled></td>
											<td>L2 Drill Down:</td>
											<td><input type="text" class="form-control" name="data[l2_drill_down]" value="<?php echo $ajio['l2_drill_down'] ?>" disabled></td>
										</tr>
										<tr>
											<td>Call/Chat Disconnection</td>
											<td>
												<select class="form-control" name="data[call_chat_disconnection]" disabled>
													<option value="">-Select-</option>
													<option <?php echo $ajio['call_chat_disconnection'] == "Compliance"?"selected":"";?> value="Compliance">Compliance</option>
													<option <?php echo $ajio['call_chat_disconnection'] == "Non Compliance"?"selected":"";?> value="Non Compliance">Non Compliance</option>
												</select> 
											</td>
											<td>Call/Chat/Email Avoidance</td>
											<td>
												<select class="form-control" name="data[call_chat_email_avoidance]" disabled>
													<option value="">-Select-</option>
													<option <?php echo $ajio['call_chat_email_avoidance'] == "Compliance"?"selected":"";?> value="Compliance">Compliance</option>
													<option <?php echo $ajio['call_chat_email_avoidance'] == "Non Compliance"?"selected":"";?> value="Non Compliance">Non Compliance</option>
												</select> 
											</td>
											<td>Flirting/Seeking personal details</td>
											<td>
												<select class="form-control" name="data[seeking_personal_details]" disabled>
													<option value="">-Select-</option>
													<option <?php echo $ajio['seeking_personal_details'] == "Compliance"?"selected":"";?> value="Compliance">Compliance</option>
													<option <?php echo $ajio['seeking_personal_details'] == "Non Compliance"?"selected":"";?> value="Non Compliance">Non Compliance</option>
												</select> 
											</td>
										</tr>
										<tr>
											<td>Rude Behavior/Mocking the customer</td>
											<td>
												<select class="form-control" name="data[rude_behavior]" disabled>
													<option value="">-Select-</option>
													<option <?php echo $ajio['rude_behavior'] == "Compliance"?"selected":"";?> value="Compliance">Compliance</option>
													<option <?php echo $ajio['rude_behavior'] == "Non Compliance"?"selected":"";?> value="Non Compliance">Non Compliance</option>
												</select> 
											</td>
											<td>Abusive Behavior</td>
											<td>
												<select class="form-control" name="data[abuse_behavior]" disabled>
													<option value="">-Select-</option>
													<option <?php echo $ajio['abuse_behavior'] == "Compliance"?"selected":"";?> value="Compliance">Compliance</option>
													<option <?php echo $ajio['abuse_behavior'] == "Non Compliance"?"selected":"";?> value="Non Compliance">Non Compliance</option>
												</select> 
											</td>
											<td>Making Changes to customer’s account without permission or seeking confidential information such as password, OTP etc. or data privacy breach</td>
											<td>
												<select class="form-control" name="data[change_customer_account_without_permission]" disabled>
													<option value="">-Select-</option>
													<option <?php echo $ajio['change_customer_account_without_permission'] == "Compliance"?"selected":"";?> value="Compliance">Compliance</option>
													<option <?php echo $ajio['change_customer_account_without_permission'] == "Non Compliance"?"selected":"";?> value="Non Compliance">Non Compliance</option>
												</select> 
											</td>
										</tr>
										<tr>
											<td>Audit Type:</td>
											<td>
												<select class="form-control" id="audit_type" name="data[audit_type]" disabled>
													<option value="<?php echo $ajio['audit_type'] ?>"><?php echo $ajio['audit_type'] ?></option>
													<option value="">-Select-</option>
													<option value="CQ Audit">CQ Audit</option>
													<option value="BQ Audit">BQ Audit</option>
													<option value="Calibration">Calibration</option>
													<option value="Pre-Certificate Mock Call">Pre-Certificate Mock Call</option>
													<option value="Certification Audit">Certification Audit</option>
													<option value="Operation Audit">Operation Audit</option>
													<option value="Trainer Audit">Trainer Audit</option>
													<option value="Hygiene Audit">Hygiene Audit</option>
												</select>
											</td>
											<td class="auType">Auditor Type</td>
											<td class="auType">
												<select class="form-control" id="auditor_type" name="data[auditor_type]">
													<option value="">-Select-</option>
													<option value="Master">Master</option>
													<option value="Regular">Regular</option>
												</select>
											</td>
											<td>VOC:</td>
											<td>
												<select class="form-control" id="voc" name="data[voc]" disabled>
													<option value="<?php echo $ajio['voc'] ?>"><?php echo $ajio['voc'] ?></option>
													<option value="">-Select-</option>
													<option value="1">1</option>
													<option value="2">2</option>
													<option value="3">3</option>
													<option value="4">4</option>
													<option value="5">5</option>
													<option value="6">6</option>
													<option value="7">7</option>
													<option value="8">8</option>
													<option value="9">9</option>
													<option value="10">10</option>
												</select>
											</td>
										</tr>
										
										<!--<tr>
											<td colspan=5 style="font-weight:bold; font-size:16px; text-align:right">Overall Score:</td>
											<td><input type="text" readonly id="ajio_overall_score" name="data[overall_score]" class="form-control ajioFatal" style="font-weight:bold" value="<?php //echo $ajio['overall_score'] ?>"></td>
										</tr>-->
										
										<tr>
											<td>Call Observation:</td>
											<td colspan=2><textarea class="form-control" name="data[call_summary]"><?php echo $ajio['call_summary'] ?></textarea></td>
											<td>Feedback:</td>
											<td colspan=2><textarea class="form-control" name="data[feedback]"><?php echo $ajio['feedback'] ?></textarea></td>
										</tr>
										<tr>
											<td colspan=2>Upload Files</td>
											<?php if($ajio['attach_file']!=''){ ?>
												<td colspan=4>
													<?php $attach_file = explode(",",$ajio['attach_file']);
													 foreach($attach_file as $mp){ ?>
														<audio controls='' style="background-color:#607F93"> 
														  <source src="<?php echo base_url(); ?>qa_files/qa_ajio/inbound/<?php echo $mp; ?>" type="audio/ogg">
														  <source src="<?php echo base_url(); ?>qa_files/qa_ajio/inbound/<?php echo $mp; ?>" type="audio/mpeg">
														</audio> </br>
													 <?php } ?>
												</td>
											<?php }else{
													echo '<td colspan=6><b>No Files</b></td>';
											} ?>
										</tr>
										
									<?php }else if($campaign=="chat"){ ?>
									
										<tr>
											<td>QA Name:</td>
											<?php if($ajio['entry_by']!=''){
													$auditorName = $ajio['auditor_name'];
												}else{
													$auditorName = $ajio['client_name'];
											} ?>
											<td><input type="text" class="form-control" value="<?php echo $auditorName; ?>" disabled></td>
											<td>Audit Date:</td>
											<td><input type="text" class="form-control" value="<?php echo mysql2mmddyy($ajio['audit_date']); ?>" disabled></td>
											<td>Call Date/Time:</td>
											<td><input type="text" class="form-control" value="<?php echo mysql2mmddyy($ajio['call_date']); ?>" disabled></td>
										</tr>
										<tr>
											<td>Champ Name:</td>
											<td>
												<select class="form-control" id="agent_id" name="data[agent_id]" disabled >
													<option value="<?php echo $ajio['agent_id'] ?>"><?php echo $ajio['fname']." ".$ajio['lname'] ?></option>
													<option value="">-Select-</option>
													<?php foreach($agentName as $row):  ?>
														<option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
													<?php endforeach; ?>
												</select>
											</td>
											<td>Fusion ID:</td>
											<td><input type="text" class="form-control" id="fusion_id" value="<?php echo $ajio['fusion_id'] ?>" readonly ></td>
											<td>L1 Supervisor:</td>
											<td>
												<select class="form-control" id="tl_id" name="data[tl_id]" readonly>
													<option value="<?php echo $ajio['tl_id'] ?>"><?php echo $ajio['tl_name'] ?></option>
													<option value="">--Select--</option>
													<?php foreach($tlname as $tl): ?>
														<option value="<?php echo $tl['id']; ?>"><?php echo $tl['fname']." ".$tl['lname']; ?></option>
													<?php endforeach; ?>	
												</select>
											</td>
										</tr>
										<tr>
											<td>Champ BP ID:</td>
											<td><input type="text" class="form-control" name="data[agent_bp_id]" value="<?php echo $ajio['agent_bp_id'] ?>" disabled ></td>
											<td>Call Duration:</td>
											<td><input type="text" class="form-control" id="call_duration" name="data[call_duration]" value="<?php echo $ajio['call_duration'] ?>" disabled ></td>
											<td>Chat Link:</td>
											<td><input type="text" class="form-control" name="data[chat_link]" value="<?php echo $ajio['chat_link'] ?>" disabled ></td>
										</tr>
										<tr>
											<td>Nature of Call/ Dispositions:</td>
											<td>
												<select class="form-control" name="data[call_nature]" disabled>
													<option value="<?php echo $ajio['call_nature'] ?>"><?php echo $ajio['call_nature'] ?></option>
													<option value="">-Select-</option>
													<option value="Return/Refund Related Query">Return/Refund Related Query</option>
													<option value="Where is my stuff?">Where is my stuff?</option>
													<option value="Pickup related Query">Pickup related Query</option>
													<option value="Replacement/ Exchange related Query">Replacement/ Exchange related Query</option>
													<option value="Amount debited order not placed">Amount debited order not placed</option>
													<option value="Pre Order Query">Pre Order Query</option>
													<option value="Order cancellation">Order cancellation</option>
													<option value="AJIO money/ Points related Query">AJIO money/ Points related Query</option>
													<option value="Order not delivered but marked as delivered">Order not delivered but marked as delivered</option>
													<option value="Account login/ Profile update related issue">Account login/ Profile update related issue</option>
													<option value="Empty box received">Empty box received</option>
													<option value="Call back">Call back</option>
													<option value="Wrong item received">Wrong item received</option>
													<option value="Order delivered but marked as not delivered">Order delivered but marked as not delivered</option>
													<option value="Policy related query">Policy related query</option>
												</select>
											</td>
											<td>Opening</td>
											<td>
												<select class="form-control" name="data[opening]" disabled>
													<option value="">-Select-</option>
													<option <?php echo $ajio['opening'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
													<option <?php echo $ajio['opening'] == "No"?"selected":"";?> value="No">No</option>
												</select> 
											</td>
											<td>Closing</td>
											<td>
												<select class="form-control" name="data[closing]" disabled>
													<option value="">-Select-</option>
													<option <?php echo $ajio['closing'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
													<option <?php echo $ajio['closing'] == "No"?"selected":"";?> value="No">No</option>
												</select> 
											</td>
										</tr>
										<tr>
											<td>Previous Interaction Checking:</td>
											<td>
												<select class="form-control" name="data[previous_interaction]" disabled>
													<option value="">-Select-</option>
													<option <?php echo $ajio['previous_interaction'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
													<option <?php echo $ajio['previous_interaction'] == "No"?"selected":"";?> value="No">No</option>
												</select>
											</td>
											<td>Probing</td>
											<td>
												<select class="form-control" name="data[probing]" disabled>
													<option value="">-Select-</option>
													<option <?php echo $ajio['probing'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
													<option <?php echo $ajio['probing'] == "No"?"selected":"";?> value="No">No</option>
												</select> 
											</td>
											<td>Hold</td>
											<td>
												<select class="form-control" name="data[hold]" disabled>
													<option value="">-Select-</option>
													<option <?php echo $ajio['hold'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
													<option <?php echo $ajio['hold'] == "No"?"selected":"";?> value="No">No</option>
												</select> 
											</td>
										</tr>
										<tr>
											<td>Communication (Grammar):</td>
											<td>
												<select class="form-control" name="data[communication]" disabled>
													<option value="<?php echo $ajio['communication'] ?>"><?php echo $ajio['communication'] ?></option>
													<option value="">-Select-</option>
													<option value="Grammar & punchuation">Grammar & punchuation</option>
													<option value="Irrelevant Response">Irrelevant Response</option>
													<option value="Repetition of same canned">Repetition of same canned</option>
													<option value="Incorrect sentence formation">Incorrect sentence formation</option>
													<option value="Robotic response">Robotic response</option>
													<option value="Others">Others</option>
												</select>
											</td>
											<td>Response Time:</td>
											<td><input type="text" class="form-control" name="data[response_time]" value="<?php echo $ajio['response_time'] ?>" disabled></td>
											<td>System Navigation</td>
											<td>
												<select class="form-control" name="data[system_navigation]" disabled>
													<option value="">-Select-</option>
													<option <?php echo $ajio['system_navigation'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
													<option <?php echo $ajio['system_navigation'] == "No"?"selected":"";?> value="No">No</option>
												</select> 
											</td>
										</tr>
										<tr>
											<td>Disposition:</td>
											<td>
												<select class="form-control" name="data[disposition]" disabled>
													<option value="<?php echo $ajio['disposition'] ?>"><?php echo $ajio['disposition'] ?></option>
													<option value="">-Select-</option>
													<option value="Correct">Correct</option>
													<option value="Incorrect">Incorrect</option>
													<option value="Multiple tagging not done when disabled">Multiple tagging not done when disabled</option>
													<option value="No Tagging">No Tagging</option>
												</select>
											</td>
											<td>Disposition L1:</td>
											<td>
												<select class="form-control" name="data[disposition_l1]" disabled>
													<option value="<?php echo $ajio['disposition_l1'] ?>"><?php echo $ajio['disposition_l1'] ?></option>
													<option value="">-Select-</option>
													<option value="Query understanding issue">Query understanding issue</option>
													<option value="Probing leading incorrect resolution/tagging">Probing leading incorrect resolution/tagging</option>
													<option value="Incorrect KM article referred">Incorrect KM article referred</option>
													<option value="Incorrect KM leg selection">Incorrect KM leg selection</option>
													<option value="Under No tagging : only KM referred no tagging">Under No tagging : only KM referred no tagging</option>
													<option value="Under No tagging : Only follow Cockpit no tagging">Under No tagging : Only follow Cockpit no tagging</option>
													<option value="Under No tagging :  No Resolution given with No">Under No tagging :  No Resolution given with No</option>
													<option value="Incorrect Intervention type">Incorrect Intervention type</option>
												</select>
											</td>
											<td>KM Navigation</td>
											<td>
												<select class="form-control" name="data[km_navigation]" disabled>
													<option value="">-Select-</option>
													<option <?php echo $ajio['km_navigation'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
													<option <?php echo $ajio['km_navigation'] == "No"?"selected":"";?> value="No">No</option>
													<option <?php echo $ajio['km_navigation'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
												</select> 
											</td>
										</tr>
										<tr>
											<td>Article Number:</td>
											<td><input type="text" class="form-control" name="data[article_no]" value="<?php echo $ajio['article_no'] ?>" disabled></td>
											<td>TNPS Given:</td>
											<td>
												<select class="form-control" name="data[tnps_given]" disabled>
													<option value="<?php echo $ajio['tnps_given'] ?>"><?php echo $ajio['tnps_given'] ?></option>
													<option value="">-Select-</option>
													<option value="TNPS pitched">TNPS pitched</option>
													<option value="Didnot pitch TNPS">Didnot pitch TNPS</option>
													<option value="Incorrect TNPS Verbiages pitched">Incorrect TNPS Verbiages pitched</option>
													<option value="Survey Solicitation">Survey Solicitation</option>
													<option value="N/A">N/A</option>
												</select>
											</td>
											<td>Fatal/Non Fatal:</td>
											<td>
												<select class="form-control" name="data[fatal_nonfatal]" disabled>
													<option value="<?php echo $ajio['fatal_nonfatal'] ?>"><?php echo $ajio['fatal_nonfatal'] ?></option>
													<option value="">-Select-</option>
													<option value="Fatal">Fatal</option>
													<option value="Non Fatal">Non Fatal</option>
												</select>
											</td>
										</tr>
										<tr>
											<td>Resolution Validation:</td>
											<td>
												<select class="form-control" name="data[resolution_validation]" disabled>
													<option value="<?php echo $ajio['resolution_validation'] ?>"><?php echo $ajio['resolution_validation'] ?></option>
													<option value="">-Select-</option>
													<option value="Correct Resolution">Correct Resolution</option>
													<option value="Incorrect Resolution">Incorrect Resolution</option>
													<option value="Incomplete Resolution">Incomplete Resolution</option>
													<option value="Inappropriate action taken">Inappropriate action taken</option>
													<option value="False Assurance">False Assurance</option>
												</select>
											</td>
											<td>L1 Drill Down:</td>
											<td><input type="text" class="form-control" name="data[l1_drill_down]" value="<?php echo $ajio['l1_drill_down'] ?>" disabled></td>
											<td>L2 Drill Down:</td>
											<td><input type="text" class="form-control" name="data[l2_drill_down]" value="<?php echo $ajio['l2_drill_down'] ?>" disabled></td>
										</tr>
										<tr>
											<td>Call/Chat Disconnection</td>
											<td>
												<select class="form-control" name="data[call_chat_disconnection]" disabled>
													<option value="">-Select-</option>
													<option <?php echo $ajio['call_chat_disconnection'] == "Compliance"?"selected":"";?> value="Compliance">Compliance</option>
													<option <?php echo $ajio['call_chat_disconnection'] == "Non Compliance"?"selected":"";?> value="Non Compliance">Non Compliance</option>
												</select> 
											</td>
											<td>Call/Chat/Email Avoidance</td>
											<td>
												<select class="form-control" name="data[call_chat_email_avoidance]" disabled>
													<option value="">-Select-</option>
													<option <?php echo $ajio['call_chat_email_avoidance'] == "Compliance"?"selected":"";?> value="Compliance">Compliance</option>
													<option <?php echo $ajio['call_chat_email_avoidance'] == "Non Compliance"?"selected":"";?> value="Non Compliance">Non Compliance</option>
												</select> 
											</td>
											<td>Flirting/Seeking personal details</td>
											<td>
												<select class="form-control" name="data[seeking_personal_details]" disabled>
													<option value="">-Select-</option>
													<option <?php echo $ajio['seeking_personal_details'] == "Compliance"?"selected":"";?> value="Compliance">Compliance</option>
													<option <?php echo $ajio['seeking_personal_details'] == "Non Compliance"?"selected":"";?> value="Non Compliance">Non Compliance</option>
												</select> 
											</td>
										</tr>
										<tr>
											<td>Rude Behavior/Mocking the customer</td>
											<td>
												<select class="form-control" name="data[rude_behavior]" disabled>
													<option value="">-Select-</option>
													<option <?php echo $ajio['rude_behavior'] == "Compliance"?"selected":"";?> value="Compliance">Compliance</option>
													<option <?php echo $ajio['rude_behavior'] == "Non Compliance"?"selected":"";?> value="Non Compliance">Non Compliance</option>
												</select> 
											</td>
											<td>Abusive Behavior</td>
											<td>
												<select class="form-control" name="data[abuse_behavior]" disabled>
													<option value="">-Select-</option>
													<option <?php echo $ajio['abuse_behavior'] == "Compliance"?"selected":"";?> value="Compliance">Compliance</option>
													<option <?php echo $ajio['abuse_behavior'] == "Non Compliance"?"selected":"";?> value="Non Compliance">Non Compliance</option>
												</select> 
											</td>
											<td>Making Changes to customer’s account without permission or seeking confidential information such as password, OTP etc. or data privacy breach</td>
											<td>
												<select class="form-control" name="data[change_customer_account_without_permission]" disabled>
													<option value="">-Select-</option>
													<option <?php echo $ajio['change_customer_account_without_permission'] == "Compliance"?"selected":"";?> value="Compliance">Compliance</option>
													<option <?php echo $ajio['change_customer_account_without_permission'] == "Non Compliance"?"selected":"";?> value="Non Compliance">Non Compliance</option>
												</select> 
											</td>
										</tr>
										<tr>
											<td>Audit Type:</td>
											<td>
												<select class="form-control" id="audit_type" name="data[audit_type]" disabled>
													<option value="<?php echo $ajio['audit_type'] ?>"><?php echo $ajio['audit_type'] ?></option>
													<option value="">-Select-</option>
													<option value="CQ Audit">CQ Audit</option>
													<option value="BQ Audit">BQ Audit</option>
													<option value="Calibration">Calibration</option>
													<option value="Pre-Certificate Mock Call">Pre-Certificate Mock Call</option>
													<option value="Certification Audit">Certification Audit</option>
													<option value="Operation Audit">Operation Audit</option>
													<option value="Trainer Audit">Trainer Audit</option>
													<option value="Hygiene Audit">Hygiene Audit</option>
												</select>
											</td>
											<td class="auType">Auditor Type</td>
											<td class="auType">
												<select class="form-control" id="auditor_type" name="data[auditor_type]">
													<option value="">-Select-</option>
													<option value="Master">Master</option>
													<option value="Regular">Regular</option>
												</select>
											</td>
											<td>VOC:</td>
											<td>
												<select class="form-control" id="voc" name="data[voc]" disabled>
													<option value="<?php echo $ajio['voc'] ?>"><?php echo $ajio['voc'] ?></option>
													<option value="">-Select-</option>
													<option value="1">1</option>
													<option value="2">2</option>
													<option value="3">3</option>
													<option value="4">4</option>
													<option value="5">5</option>
													<option value="6">6</option>
													<option value="7">7</option>
													<option value="8">8</option>
													<option value="9">9</option>
													<option value="10">10</option>
												</select>
											</td>
										</tr>
										
										<!--<tr>
											<td colspan=5 style="font-weight:bold; font-size:16px; text-align:right">Overall Score:</td>
											<td><input type="text" readonly id="ajio_overall_score" name="data[overall_score]" class="form-control ajioFatal" style="font-weight:bold" value="<?php //echo $ajio['overall_score'] ?>"></td>
										</tr>-->
										
										<tr>
											<td>Call Observation:</td>
											<td colspan=2><textarea class="form-control" name="data[call_summary]"><?php echo $ajio['call_summary'] ?></textarea></td>
											<td>Feedback:</td>
											<td colspan=2><textarea class="form-control" name="data[feedback]"><?php echo $ajio['feedback'] ?></textarea></td>
										</tr>
										<tr>
											<td colspan=2>Upload Files</td>
											<?php if($ajio['attach_file']!=''){ ?>
												<td colspan=4>
													<?php $attach_file = explode(",",$ajio['attach_file']);
													 foreach($attach_file as $mp){ ?>
														<audio controls='' style="background-color:#607F93"> 
														  <source src="<?php echo base_url(); ?>qa_files/qa_ajio/inbound/<?php echo $mp; ?>" type="audio/ogg">
														  <source src="<?php echo base_url(); ?>qa_files/qa_ajio/inbound/<?php echo $mp; ?>" type="audio/mpeg">
														</audio> </br>
													 <?php } ?>
												</td>
											<?php }else{
													echo '<td colspan=6><b>No Files</b></td>';
											} ?>
										</tr>
									
									<?php }else if($campaign=="inb_hygiene"){ ?>
									
										<tr>
											<td>QA Name:</td>
											<?php if($ajio['entry_by']!=''){
													$auditorName = $ajio['auditor_name'];
												}else{
													$auditorName = $ajio['client_name'];
											} ?>
											<td><input type="text" class="form-control" value="<?php echo $auditorName; ?>" disabled></td>
											<td>Audit Date:</td>
											<td><input type="text" class="form-control" value="<?php echo mysql2mmddyy($ajio['audit_date']); ?>" disabled></td>
											<td>Call Date/Time:</td>
											<td><input type="text" class="form-control" value="<?php echo mysql2mmddyy($ajio['call_date']); ?>" disabled></td>
										</tr>
										<tr>
											<td>Agent Name:</td>
											<td>
												<select class="form-control" id="agent_id" name="data[agent_id]" disabled >
													<option value="<?php echo $ajio_inb['agent_id'] ?>"><?php echo $ajio_inb['fname']." ".$ajio_inb['lname'] ?></option>
													<option value="">-Select-</option>
													<?php foreach($agentName as $row):  ?>
														<option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
													<?php endforeach; ?>
												</select>
											</td>
											<td>Fusion ID:</td>
											<td><input type="text" class="form-control" id="fusion_id" value="<?php echo $ajio_inb['fusion_id'] ?>" readonly ></td>
											<td>L1 Supervisor:</td>
											<td>
												<select class="form-control" id="tl_id" name="data[tl_id]" readonly>
													<option value="<?php echo $ajio_inb['tl_id'] ?>"><?php echo $ajio_inb['tl_name'] ?></option>
													<option value="">--Select--</option>
													<?php foreach($tlname as $tl): ?>
														<option value="<?php echo $tl['id']; ?>"><?php echo $tl['fname']." ".$tl['lname']; ?></option>
													<?php endforeach; ?>	
												</select>
											</td>
										</tr>
										<tr>
											<td>BP ID:</td>
											<td><input type="text" class="form-control" name="data[agent_bp_id]" value="<?php echo $ajio_inb['agent_bp_id'] ?>" disabled ></td>
											<td>Call Duration:</td>
											<td><input type="text" class="form-control" id="call_duration" name="data[call_duration]" value="<?php echo $ajio_inb['call_duration'] ?>" disabled ></td>
											<td>Complete ID:</td>
											<td><input type="text" class="form-control" name="data[complete_id]" value="<?php echo $ajio_inb['complete_id'] ?>" disabled ></td>
										</tr>
										<tr>
											<td>Valid/Invalid:</td>
											<td>
												<select class="form-control" name="data[valid_invalid]" disabled>
													<option value="<?php echo $ajio_inb['valid_invalid'] ?>"><?php echo $ajio_inb['valid_invalid'] ?></option>
													<option value="">-Select-</option>
													<option value="Valid">Valid</option>
													<option value="Invalid">Invalid</option>
												</select>
											</td>
											<td>Reason For Invalid:</td>
											<td colspan=2><textarea class="form-control" name="data[reason_for_invalid]"><?php echo $ajio_inb['reason_for_invalid'] ?></textarea></td>
										</tr>
										<tr>
											<td>Downtime Tracker Status:</td>
											<td><input type="text" class="form-control" name="data[downtime_tracker_status]" value="<?php echo $ajio_inb['downtime_tracker_status'] ?>" disabled ></td>
											<td>Mentioned Reson in Downtime:</td>
											<td><input type="text" class="form-control" name="data[downtime_mension_reason]" value="<?php echo $ajio_inb['downtime_mension_reason'] ?>" disabled ></td>
											<td>Hold /response Duration (mins):</td>
											<td><input type="text" class="form-control" name="data[hold_responce_duration]" value="<?php echo $ajio_inb['hold_responce_duration'] ?>" disabled ></td>
										</tr>
										<tr>
											<td>Audit Type:</td>
											<td><input type="text" class="form-control" name="data[hygiene_audit_type]" value="<?php echo $ajio_inb['hygiene_audit_type'] ?>" disabled ></td>
										</tr>
										<tr>
											<td colspan=2>Upload Files</td>
											<?php if($ajio_inb['attach_file']!=''){ ?>
												<td colspan=4>
													<?php $attach_file = explode(",",$ajio_inb['attach_file']);
													 foreach($attach_file as $mp){ ?>
														<audio controls='' style="background-color:#607F93"> 
														  <source src="<?php echo base_url(); ?>qa_files/qa_ajio/inbound/<?php echo $mp; ?>" type="audio/ogg">
														  <source src="<?php echo base_url(); ?>qa_files/qa_ajio/inbound/<?php echo $mp; ?>" type="audio/mpeg">
														</audio> </br>
													 <?php } ?>
												</td>
											<?php }else{
													echo '<td colspan=6><b>No Files</b></td>';
											} ?>
										</tr>
									
									<?php } ?>
									
									<tr><td colspan="8" style="background-color:#C5C8C8"></td></tr>
									
									<tr><td style="font-size:16px">Manager Review:</td> <td colspan="8" style="text-align:left"><?php echo $ajio['mgnt_rvw_note'] ?></td></tr>
									<tr><td style="font-size:16px">Client Review:</td> <td colspan="7" style="text-align:left"><?php echo $ajio['client_rvw_note'] ?></td></tr>
									
									<tr><td colspan="7" style="background-color:#C5C8C8"></td></tr>
									
									<form id="form_agent_user" method="POST" action="">
									 <input type="hidden" name="pnid" class="form-control" value="<?php echo $pnid; ?>">
										
										<tr>
											<td colspan=2 style="font-size:16px">Feedback Acceptance</td>
											<td colspan=5>
												<select class="form-control" id="" name="agnt_fd_acpt" required>
													<option value="">--Select--</option>
													<option <?php echo $ajio['agnt_fd_acpt']=='Acceptance'?"selected":""; ?> value="Acceptance">Acceptance</option>	
													<option <?php echo $ajio['agnt_fd_acpt']=='Not Acceptance'?"selected":""; ?> value="Not Acceptance">Not Acceptance</option>	
												</select>
											</td>
										</tr>
										<tr>
											<td colspan=2 style="font-size:16px">Your Review</td>
											<td colspan=5><textarea class="form-control" name="note" required><?php echo $ajio['agent_rvw_note'] ?></textarea></td>
										</tr>
										
										<?php if(is_access_qa_agent_module()==true){
										if(is_available_qa_feedback($ajio['entry_date'],72) == true){ ?>
											<tr>
												<?php if($ajio['agent_rvw_note']==''){ ?>
													<td colspan="8"><button class="btn btn-success waves-effect" type="submit" id='btnagentSave' name='btnSave' value="SAVE" style="width:500px">SAVE</button></td>
												<?php } ?>
											</tr>
										<?php } 
										} ?>
									
									</form>
									
								</tbody>
							</table>
						</div>
					</div>
				</div>	
			</div>
		</div>

	</section>
</div>
