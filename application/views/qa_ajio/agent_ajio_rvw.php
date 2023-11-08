
<style>
	@import url('https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,500;1,900&display=swap');

body {
    font-family: 'Roboto', sans-serif;
}
.table > tbody > tr > td{
	text-align: center;
	font-size:13px;
}

.select2-selection.select2-selection--single{
    height: 40px!important;
    border-radius: 1px!important;
}
.select2-selection .select2-selection__arrow{
    height: 40px!important;
}
.select2-selection.select2-selection--single .select2-selection__rendered {
  line-height: 40px !important;
}
.select2-container{
	width: 100%!important;
}
.form-control{
	border-radius:1px!important;
}

#theader{
	font-size:20px;
	font-weight:bold;
}

.eml{
	font-weight:bold;
	background-color:#FAD7A0;
}

.eml1{
	font-weight:bold;
}
.heading td{
	
    padding: 10px!important;
    font-family: 'Roboto'!important;
    font-weight: 600!important;
    letter-spacing: 1px;
}
.btn-save{width: 200px!important;
    padding: 10px!important;
    border-radius: 1px!important;
    font-size: 13px!important;
	color:#fff;
	background:#5e62ecd4;
}
.btn-save:hover ,.btn-save:focus{
    
	color:#fff;
    box-shadow: 0 0 0 2px #fff, 0 0 0 4px #5e62ecd4;
}
/*////////////////*/
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
									
								}else if($campaign=="ccsr_voice_email"){
									echo "CCSR Voice & Email";
								}
								else{
									echo ucfirst($campaign);
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
												<select class="form-control agentName" id="agent_id" name="data[agent_id]" disabled >
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
												<select class="form-control agentName" id="agent_id" name="data[agent_id]" disabled >
													<option value="<?php echo $ajio['agent_id'] ?>"><?php echo $ajio['fname']." ".$ajio['lname'] ?></option>
												</select>
											</td>
											<td>Fusion ID:<span style="font-size:24px;color:red">*</span></td>
											<td><input type="text" class="form-control" id="fusion_id" value="<?php echo $ajio['fusion_id'] ?>" readonly ></td>
											<td >L1 Supervisor:<span style="font-size:24px;color:red">*</span></td>
											<td colspan="2">
												<select class="form-control" id="tl_id" name="data[tl_id]" readonly>
													<option value="<?php echo $ajio['tl_id'] ?>"><?php echo $ajio['tl_name'] ?></option>	
												</select>
											</td>
										</tr>
										<tr>
										<td>Partner:</td>
										<td><input type="text" class="form-control" name="data[partner]" value="<?php echo $ajio['partner'] ?>" disabled ></td>
										<td>Call Duration:</td>
										<td><input type="text" class="form-control" onkeydown="return false;" id="call_duration" name="data[call_duration]" value="<?php echo $ajio['call_duration'] ?>" disabled ></td>
								
										<td>Ticket Type</td>
										<td colspan="2">
											<select class="form-control" id="ticket_type" name="data[ticket_type]" disabled>
												<option value="">-Select-</option>
												<option value="Complaint" <?= ($ajio['ticket_type']=="Complaint")?"selected":"" ?>>Complaint</option>
												<option value="Query" <?= ($ajio['ticket_type']=="Query")?"selected":"" ?>>Query</option>
												<option value="Proactive SR" <?= ($ajio['ticket_type']=="Proactive SR")?"selected":"" ?>>Proactive SR</option>
											</select>
										</td>
									</tr>
										<!-- <tr>
											<td>Type of Audit:<span style="font-size:24px;color:red">*</span></td>
											<td>
												<select class="form-control" id="type_of_audit" name="data[type_of_audit]" disabled>
													<option value="<?php echo $ajio['type_of_audit'] ?>"><?php echo $ajio['type_of_audit'] ?></option>
												</select>
											</td>
											<td>Call ID:<span style="font-size:24px;color:red">*</span></td>
											<td><input type="text" class="form-control" name="data[call_id]" value="<?php echo $ajio['call_id'] ?>" disabled></td>
											<td>Call Duration:</td>
											<td><input type="text" class="form-control" id="call_duration" name="data[call_duration]" value="<?php echo $ajio['call_duration'] ?>" disabled ></td>
											
										</tr> -->

										<tr>
										<td>Auditor’s BP ID:</td>
										<td><input type="text" class="form-control" name="data[auditors_bp_id]" value="<?php echo $ajio['auditors_bp_id'] ?>" disabled ></td>
										<td>Interaction ID:</td>
										<td><input type="text" class="form-control" name="data[interaction_id]" value="<?php echo $ajio['interaction_id'] ?>" disabled ></td>
										<td>Order ID:</td>
										<td colspan="2"><input type="text" class="form-control" name="data[order_id]" value="<?php echo $ajio['order_id'] ?>" disabled ></td>
									</tr>
									<tr>
										<td>Ticket ID:</td>
										<td><input type="text" class="form-control" name="data[ticket_id]" value="<?php echo $ajio['ticket_id'] ?>" disabled ></td>
										<td>Call Synopsis:</td>
										<td><input type="text" class="form-control" name="data[call_synopsis_header]" value="<?php echo $ajio['call_synopsis_header'] ?>" disabled ></td>
										<td>Language:</td>
										<td colspan="2"><input type="text" class="form-control" name="data[language]" value="<?php echo $ajio['language'] ?>" disabled ></td>
									</tr>

										<tr>
											<td >Audit Type:<span style="font-size:24px;color:red">*</span></td>
											<td >
												<select class="form-control" id="audit_type" name="data[audit_type]" disabled>
													<option value="<?php echo $ajio['audit_type'] ?>"><?php echo $ajio['audit_type'] ?></option>
												</select>
											</td>
											<td class="auType">Auditor Type</td>
											<td class="auType">
											<select class="form-control" id="auditor_type" name="data[auditor_type]" disabled>
											<option value="<?php echo $ajio['auditor_type'] ?>"><?php echo $ajio['auditor_type'] ?></option>
												<option value="">-Select-</option>
												<option value="Master">Master</option>
												<option value="Regular">Regular</option>
											</select>
											</td>
											<td>VOC:<span style="font-size:24px;color:red">*</span></td>
											<td>
												<select class="form-control" id="voc" name="data[voc]" disabled>
													<option value="<?php echo $ajio['voc'] ?>"><?php echo $ajio['voc'] ?></option>
												</select>
											</td>
											
										</tr>
										
										<!-- <tr>
										<td class="cust_voc">Customer voc:</td>
										<td class="cust_voc"><input type="text" class="form-control" id="voice_cust" name="data[voice_cust]" value="<?php echo $ajio['voice_cust'] ?>" disabled ></td>
										<td class="utiliza">KM Utilization:</td>
										<td class="utiliza">
											<select class="form-control" id="utilization" name="data[utilization]" disabled>
												<option value="<?php echo $ajio['utilization'] ?>"><?php echo $ajio['utilization'] ?></option>
												<option value="">-Select-</option>
												<option value="Yes">Yes</option>
												<option value="No">No</option>
											</select>
										</td>
										<td class="arti">Article</td>
										<td class="arti"><input type="text" class="form-control" id="article" name="data[article]" value="<?php echo $ajio['article'] ?>" disabled ></td>
									</tr>
									<tr>
										<td class="fatal_nonfatal">Fatal/Non-Fatal:</td>
										<td class="fatal_nonfatal">
											<select class="form-control" id="fatal_non_fatal" name="data[fatal_nonfatal]" disabled>
												<option value="<?php echo $ajio['fatal_nonfatal'] ?>"><?php echo $ajio['fatal_nonfatal'] ?></option>
												<option value="">-Select-</option>
												<option value="Fatal">Fatal</option>
												<option value="Non-Fatal">Non-Fatal</option>
											</select>
										</td>				
										<td class="acpt">Detractor ACPT:</td>
										<td class="acpt">
											<select class="form-control" id="detractor_acpt" name="data[detractor_acpt]" disabled>
												<option value="<?php echo $ajio['detractor_acpt'] ?>"><?php echo $ajio['detractor_acpt'] ?></option>
												<option value="">-Select-</option>
												<option value="Agent">Agent</option>
												<option value="Process">Process</option>
												<option value="Customer">Customer</option>
												<option value="Technology">Technology</option>
											</select>
										</td>
										<td class="detrac_l1">Detractor L1:</td>
										<td class="detrac_l1"><input type="text" class="form-control" id="detractor_l1" name="data[detractor_l1]" value="<?php echo $ajio['detractor_l1'] ?>" disabled ></td>
									</tr>
									<tr>
										<td class="detrac_l2">Detractor L2:</td>
										<td class="detrac_l2"><input type="text" class="form-control" id="detractor_l2" name="data[detractor_l2]" value="<?php echo $ajio['detractor_l2'] ?>" disabled ></td>
										<td class="tcd">TCD</td>
										<td class="tcd"><input type="text" class="form-control" id="tcd" name="data[tcd]" value="<?php echo $ajio['tcd'] ?>" disabled ></td>
										<td class="modulation">Voice modulation:</td>
										<td class="modulation">
											<select class="form-control" id="voice_modulation" id="voice_modulation" name="data[voice_modulation]" disabled>
												<option value="<?php echo $ajio['voice_modulation'] ?>"><?php echo $ajio['voice_modulation'] ?></option>
												<option value="">-Select-</option>
												<option value="Yes">Yes</option>
												<option value="No">No</option>
											</select>
										</td>
									</tr>
									<tr>
										<td class="assurance">Assurance given:</td>
										<td class="assurance">
											<select class="form-control" id="assurance_given" name="data[assurance_given]" disabled>
												<option value="<?php echo $ajio['assurance_given'] ?>"><?php echo $ajio['assurance_given'] ?></option>
												<option value="">-Select-</option>
												<option value="Yes">Yes</option>
												<option value="No">No</option>
											</select>
										</td>
									</tr> -->

										<tr>
										<td>Tagging by Evaluator:<span style="font-size:24px;color:red">*</span></td>
											<td colspan="6">
												<select class="form-control agentName" name="data[tagging_evaluator]" disabled>
													<option value="<?php echo $ajio['tagging_evaluator'] ?>"><?php echo $ajio['tagging_evaluator'] ?></option>
												</select>
											</td>
										<!-- <td class="fatal_nonfatal">Fatal/Non-Fatal:</td>
										<td class="fatal_nonfatal">
											<select class="form-control" id="fatal_non_fatal" name="data[fatal_nonfatal]" disabled>
												<option value="<?php echo $ajio['fatal_nonfatal'] ?>"><?php echo $ajio['fatal_nonfatal'] ?></option>
												<option value="">-Select-</option>
												<option value="Fatal">Fatal</option>
												<option value="Non-Fatal">Non-Fatal</option>
											</select>
										</td> -->
										</tr>
										<tr>
										<td>Earned Score:</td>
											<td><input type="text" readonly id="earnedScore" name="data[earned_score]" class="form-control" style="font-weight:bold" value="<?php echo $ajio['earned_score'] ?>"></td>
										<td >Possible Score:</td>
											<td colspan="2"><input type="text" readonly id="possibleScore" name="data[possible_score]" class="form-control" style="font-weight:bold" value="<?php echo $ajio['possible_score'] ?>"></td>
										<td style="font-weight:bold; font-size:16px; text-align:right">Overall Score:</td>
											<td><input type="text" readonly id="overallScore" name="data[overall_score]" class="form-control ajioFatal" style="font-weight:bold" value="<?php echo $ajio['overall_score'] ?>"></td>
										</tr>
										<tr style="background-color:#85C1E9; font-weight:bold">
										<td>Parameter</td>
										<td colspan="2">Sub Parameter</td>
										<td>Defect</td>
										<td>Points</td>
										<td>L1 Reason</td>
										<td>L2 Reason</td>
									</tr>
									<tr>
										<td rowspan=4 style="background-color:#85C1E9; font-weight:bold">Call Quality & Etiquettes</td>
										<td  style="color:red" colspan="2">Did the champ open the call within 4 seconds and introduce himself properly</td>
										<td>
											<select class="form-control ajio fatal ajioAF1" id="ajioAF1_inb_v2" name="data[open_call_within_4sec]" disabled>
												<option ajio_val=5 ajio_max=5 <?php echo $ajio['open_call_within_4sec'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ajio_val=0 ajio_max=5 <?php echo $ajio['open_call_within_4sec'] == "No"?"selected":"";?> value="No">No</option>
												<option ajio_val=0 ajio_max=5 <?php echo $ajio['open_call_within_4sec'] == "Autofail"?"selected":"";?> value="Autofail">Autofail</option>
											</select>
										</td>
										<td>5</td>
										<!-- <td><textarea class="form-control" name="data[l1_reason1]"><?php //echo $ajio['l1_reason1'] ?></textarea></td> -->
										<td>
											
											<select class="form-control" id="AF1_inb_v2" name="data[l1_reason1]" disabled>
												<?php 
												if($ajio['l1_reason1']!=''){
													?>
													<option value="<?php echo $ajio['l1_reason1'] ?>"><?php echo $ajio['l1_reason1'] ?></option>
													<?php
												}
												?>
												<option  <?php echo $ajio['l1_reason1'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
												
											</select>
										</td>
										<td><textarea class="form-control" name="data[l2_reason1]" disabled><?php echo $ajio['l2_reason1'] ?></textarea></td>
									</tr>
									<tr>
										<td colspan="2">Did the champ address the customer by name</td>
										<td>
											<select class="form-control ajio" id="address_customer_inb_v2" name="data[address_customer_by_name]" disabled>
												<option ajio_val=5 ajio_max=5 <?php echo $ajio['address_customer_by_name'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ajio_val=0 ajio_max=5 <?php echo $ajio['address_customer_by_name'] == "No"?"selected":"";?> value="No">No</option>
											</select>
										</td>
										<td>5</td>
										<!-- <td><textarea class="form-control" name="data[l1_reason2]"><?php //echo $ajio['l1_reason2'] ?></textarea></td> -->
										<td>
											
											<select class="form-control" id="address_inb_v2" name="data[l1_reason2]" disabled>
												<?php 
												if($ajio['l1_reason2']!=''){
													?>
													<option value="<?php echo $ajio['l1_reason2'] ?>"><?php echo $ajio['l1_reason2'] ?></option>
													<?php
												}
												?>
												<option  <?php echo $ajio['l1_reason2'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
												
											</select>
										</td>
										<td><textarea class="form-control" name="data[l2_reason2]" disabled><?php echo $ajio['l2_reason2'] ?></textarea></td>
									</tr>
									<tr>
										<td  style="color:red" colspan="2">Champ followed the hold procedure as per the SOP</td>
										<td>
											<select class="form-control ajio fatal ajioAF2" id="ajioAF2_inb_v2" name="data[follow_hold_procedure]" disabled>
												<option ajio_val=5 ajio_max=5 <?php echo $ajio['follow_hold_procedure'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ajio_val=0 ajio_max=5 <?php echo $ajio['follow_hold_procedure'] == "No"?"selected":"";?> value="No">No</option>
												<!-- <option ajio_val=0 ajio_max=5 <?php //echo $ajio['follow_hold_procedure'] == "Unwarranted Hold"?"selected":"";?> value="Unwarranted Hold">Unwarranted Hold</option>
												<option ajio_val=0 ajio_max=5 <?php //echo $ajio['follow_hold_procedure'] == "Dead Air"?"selected":"";?> value="Dead Air">Dead Air</option>
												<option ajio_val=0 ajio_max=5 <?php //echo $ajio['follow_hold_procedure'] == "Uninformed Hold"?"selected":"";?> value="Uninformed Hold">Uninformed Hold</option>
												<option ajio_val=0 ajio_max=5 <?php //echo $ajio['follow_hold_procedure'] == "Uninformed Absence/mute"?"selected":"";?> value="Uninformed Absence/mute">Uninformed Absence/mute</option>
												<option ajio_val=0 ajio_max=5 <?php //echo $ajio['follow_hold_procedure'] == "Hold not refreshed withinh stipulated time"?"selected":"";?> value="Hold not refreshed withinh stipulated time">Hold not refreshed withinh stipulated time</option>
												<option ajio_val=0 ajio_max=5 <?php //echo $ajio['follow_hold_procedure'] == "Hold script/procedure not adhered"?"selected":"";?> value="Hold script/procedure not adhered">Hold script/procedure not adhered</option> -->
												<option ajio_val=0 ajio_max=5 <?php echo $ajio['follow_hold_procedure'] == "Autofail"?"selected":"";?> value="Autofail">Autofail</option>
											</select>
										</td>
										<td>5</td>
										<!-- <td><textarea class="form-control" name="data[l1_reason3]"><?php //echo $ajio['l1_reason3'] ?></textarea></td> -->
										<td>
											
											<select class="form-control" id="AF2_inb_v2" name="data[l1_reason3]" disabled>
												<?php 
												if($ajio['l1_reason3']!=''){
													?>
													<option value="<?php echo $ajio['l1_reason3'] ?>"><?php echo $ajio['l1_reason3'] ?></option>
													<?php
												}
												?>
												<option  <?php echo $ajio['l1_reason3'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
												
											</select>
										</td>
										<td><textarea class="form-control" name="data[l2_reason3]" disabled><?php echo $ajio['l2_reason3'] ?></textarea></td>
									</tr>
									<tr>
										<td colspan="2">Did the champ offer further assistance and follow appropriate call closure/supervisor transfer process</td>
										<td>
											<select class="form-control ajio fatal ajioAF3" id="ajioAF3_inb_v2" name="data[follow_appropiate_call_closure]" disabled>
												<option ajio_val=5 ajio_max=5 <?php echo $ajio['follow_appropiate_call_closure'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ajio_val=0 ajio_max=5 <?php echo $ajio['follow_appropiate_call_closure'] == "No"?"selected":"";?> value="No">No</option>
												<!-- <option ajio_val=0 ajio_max=5 <?php //echo $ajio['follow_appropiate_call_closure'] == "Failed to offer further assistance"?"selected":"";?> value="Failed to offer further assistance">Failed to offer further assistance</option>
												<option ajio_val=0 ajio_max=5 <?php //echo $ajio['follow_appropiate_call_closure'] == "Did not pitch for TNPs"?"selected":"";?> value="Did not pitch for TNPs">Did not pitch for TNPs</option>
												<option ajio_val=0 ajio_max=5 <?php //echo $ajio['follow_appropiate_call_closure'] == "Did not follow call closing script"?"selected":"";?> value="Did not follow call closing script">Did not follow call closing script</option>
												<option ajio_val=0 ajio_max=5 <?php //echo $ajio['follow_appropiate_call_closure'] == "Did not follow call transfer guidelines"?"selected":"";?> value="Did not follow call transfer guidelines">Did not follow call transfer guidelines</option>
												<option ajio_val=0 ajio_max=5 <?php //echo $ajio['follow_appropiate_call_closure'] == "TNPS script not adhered/Influenced TNPS"?"selected":"";?> value="TNPS script not adhered/Influenced TNPS">TNPS script not adhered/Influenced TNPS</option>
												<option ajio_val=0 ajio_max=5 <?php //echo $ajio['follow_appropiate_call_closure'] == "Did not use Genesys end call option"?"selected":"";?> value="Did not use Genesys end call option">Did not use Genesys end call option</option> -->
												<option ajio_val=0 ajio_max=5 <?php echo $ajio['follow_appropiate_call_closure'] == "Autofail"?"selected":"";?> value="Autofail">Autofail</option>
											</select>
										</td>
										<td>5</td>
										<!-- <td><textarea class="form-control" name="data[l1_reason4]"><?php //echo $ajio['l1_reason4'] ?></textarea></td> -->
										<td>
											
											<select class="form-control" id="AF3_inb_v2" name="data[l1_reason4]" disabled>
												<?php 
												if($ajio['l1_reason4']!=''){
													?>
													<option value="<?php echo $ajio['l1_reason4'] ?>"><?php echo $ajio['l1_reason4'] ?></option>
													<?php
												}
												?>
												<option  <?php echo $ajio['l1_reason4'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
												
											</select>
										</td>
										<td><textarea class="form-control" name="data[l2_reason4]" disabled><?php echo $ajio['l2_reason4'] ?></textarea></td>
									</tr>
									<tr>
										<td rowspan=5 style="background-color:#85C1E9; font-weight:bold">Communication Skills</td>
										<td colspan="2">Was the champ polite and used apology and assurance wherever disabled</td>
										<td>
											<select class="form-control ajio" id="polite_appology_inb_v2" name="data[polite_use_appology]" disabled>
												<option ajio_val=5 ajio_max=5 <?php echo $ajio['polite_use_appology'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<!-- <option ajio_val=0 ajio_max=5 <?php //echo $ajio['polite_use_appology'] == "Apology used but misplaced"?"selected":"";?> value="Apology used but misplaced">Apology used but misplaced</option>
												<option ajio_val=0 ajio_max=5 <?php //echo $ajio['polite_use_appology'] == "Did not provide effective assurance"?"selected":"";?> value="Did not provide effective assurance">Did not provide effective assurance</option>
												<option ajio_val=0 ajio_max=5 <?php //echo $ajio['polite_use_appology'] == "Did not acknowledge/apologize when disabled"?"selected":"";?> value="Did not acknowledge/apologize when disabled">Did not acknowledge/apologize when disabled</option>
												<option ajio_val=0 ajio_max=5 <?php //echo $ajio['polite_use_appology'] == "Lack of pleasantries"?"selected":"";?> value="Lack of pleasantries">Lack of pleasantries</option> -->
												<option ajio_val=0 ajio_max=5 <?php echo $ajio['polite_use_appology'] == "No"?"selected":"";?> value="No">No</option>
											</select>
										</td>
										<td>5</td>
										<!-- <td><textarea class="form-control" name="data[l1_reason5]"><?php echo $ajio['l1_reason5'] ?></textarea></td> -->
										<td>
											
											<select class="form-control" id="appology_inb_v2" name="data[l1_reason5]" disabled>
												<?php 
												if($ajio['l1_reason5']!=''){
													?>
													<option value="<?php echo $ajio['l1_reason5'] ?>"><?php echo $ajio['l1_reason5'] ?></option>
													<?php
												}
												?>
												<option  <?php echo $ajio['l1_reason5'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
												
											</select>
										</td>
										<td><textarea class="form-control" name="data[l2_reason5]" disabled><?php echo $ajio['l2_reason5'] ?></textarea></td>
									</tr>
									<tr>
										<td colspan="2">Was the champ able to comprehend and paraphrase the customer's concern</td>
										<td>
											<select class="form-control ajio" id="comprehend_concern_inb_v2" name="data[comprehend_customer_concern]" disabled>
												<option ajio_val=10 ajio_max=10 <?php echo $ajio['comprehend_customer_concern'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<!-- <option ajio_val=0 ajio_max=10 <?php //echo $ajio['comprehend_customer_concern'] == "Asked unnecessary/irrelevant questions"?"selected":"";?> value="Asked unnecessary/irrelevant questions">Asked unnecessary/irrelevant questions</option>
												<option ajio_val=0 ajio_max=10 <?php //echo $ajio['comprehend_customer_concern'] == "Asked details already available"?"selected":"";?> value="Asked details already available">Asked details already available</option>
												<option ajio_val=0 ajio_max=10 <?php //echo $ajio['comprehend_customer_concern'] == "Unable to comprehend"?"selected":"";?> value="Unable to comprehend">Unable to comprehend</option>
												<option ajio_val=0 ajio_max=10 <?php //echo $ajio['comprehend_customer_concern'] == "Failed to paraphrase to ensure understanding"?"selected":"";?> value="Failed to paraphrase to ensure understanding">Failed to paraphrase to ensure understanding</option> -->
												<option ajio_val=0 ajio_max=10 <?php echo $ajio['comprehend_customer_concern'] == "No"?"selected":"";?> value="No">No</option>
											</select>
										</td>
										<td>10</td>
										<!-- <td><textarea class="form-control" name="data[l1_reason6]"><?php //echo $ajio['l1_reason6'] ?></textarea></td> -->
										<td>
											
											<select class="form-control" id="comprehend_inb_v2" name="data[l1_reason6]" disabled>
												<?php 
												if($ajio['l1_reason6']!=''){
													?>
													<option value="<?php echo $ajio['l1_reason6'] ?>"><?php echo $ajio['l1_reason6'] ?></option>
													<?php
												}
												?>
												<option  <?php echo $ajio['l1_reason6'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
												
											</select>
										</td>
										<td><textarea class="form-control" name="data[l2_reason6]" disabled><?php echo $ajio['l2_reason6'] ?></textarea></td>
									</tr>
									<tr>
										<td colspan="2">Did the champ display active listening skills without making the customer repeat</td>
										<td>
											<select class="form-control ajio" id="listening_skill_inb_v2" name="data[display_active_listening_skill]" disabled>
												<option ajio_val=5 ajio_max=5 <?php echo $ajio['display_active_listening_skill'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<!-- <option ajio_val=0 ajio_max=5 <?php //echo $ajio['display_active_listening_skill'] == "Champ made the customer repeat"?"selected":"";?> value="Champ made the customer repeat">Champ made the customer repeat</option>
												<option ajio_val=0 ajio_max=5 <?php //echo $ajio['display_active_listening_skill'] == "Did not listen actively impacting the call"?"selected":"";?> value="Did not listen actively impacting the call">Did not listen actively impacting the call</option> -->
												<option ajio_val=0 ajio_max=5 <?php echo $ajio['display_active_listening_skill'] == "No"?"selected":"";?> value="No">No</option>
											</select>
										</td>
										<td>5</td>
										<!-- <td><textarea class="form-control" name="data[l1_reason7]"><?php //echo $ajio['l1_reason7'] ?></textarea></td> -->
										<td>
											
											<select class="form-control" id="skill_inb_v2" name="data[l1_reason7]" disabled>
												<?php 
												if($ajio['l1_reason7']!=''){
													?>
													<option value="<?php echo $ajio['l1_reason7'] ?>"><?php echo $ajio['l1_reason7'] ?></option>
													<?php
												}
												?>
												<option  <?php echo $ajio['l1_reason7'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
												
											</select>
										</td>
										<td><textarea class="form-control" name="data[l2_reason7]" disabled><?php echo $ajio['l2_reason7'] ?></textarea></td>
									</tr>
									<tr>
										<td colspan="2">Was the champ able to handle objections effectively and offer rebuttals wherever disabled</td>
										<td>
											<select class="form-control ajio" id="handle_objection_inb_v2" name="data[handle_objection_effectively]" disabled>
												<option ajio_val=10 ajio_max=10 <?php echo $ajio['handle_objection_effectively'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ajio_val=0 ajio_max=10 <?php echo $ajio['handle_objection_effectively'] == "No"?"selected":"";?> value="No">No</option>
												<option ajio_val=10 ajio_max=10 <?php echo $ajio['handle_objection_effectively'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td>10</td>
										<!-- <td><textarea class="form-control" name="data[l1_reason8]"><?php //echo $ajio['l1_reason8'] ?></textarea></td> -->
										<td>
											
											<select class="form-control" id="objection_inb_v2" name="data[l1_reason8]" disabled>
												<?php 
												if($ajio['l1_reason8']!=''){
													?>
													<option value="<?php echo $ajio['l1_reason8'] ?>"><?php echo $ajio['l1_reason8'] ?></option>
													<?php
												}
												?>
												<option  <?php echo $ajio['l1_reason8'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
												
											</select>
										</td>
										<td><textarea class="form-control" name="data[l2_reason8]" disabled><?php echo $ajio['l2_reason8'] ?></textarea></td>
									</tr>
									<tr>
										<td colspan="2">Was champ able to express/articulate himself and seamlessly converse with the customer</td>
										<td>
											<select class="form-control ajio" id="express_himself_inb_v2" name="data[express_himself_with_customer]" disabled>
												<option ajio_val=10 ajio_max=10 <?php echo $ajio['express_himself_with_customer'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<!-- <option ajio_val=0 ajio_max=10 <?php //echo $ajio['express_himself_with_customer'] == "Champ was struggling to express himself"?"selected":"";?> value="Champ was struggling to express himself">Champ was struggling to express himself</option>
												<option ajio_val=0 ajio_max=10 <?php //echo $ajio['express_himself_with_customer'] == "Champ swtiched language to express himself"?"selected":"";?> value="Champ swtiched language to express himself">Champ swtiched language to express himself</option>
												<option ajio_val=0 ajio_max=10 <?php //echo $ajio['express_himself_with_customer'] == "Customer expressed difficulty in understanding the champ"?"selected":"";?> value="Customer expressed difficulty in understanding the champ">Customer expressed difficulty in understanding the champ</option> -->
												<option ajio_val=0 ajio_max=10 <?php echo $ajio['express_himself_with_customer'] == "No"?"selected":"";?> value="No">No</option>
											</select>
										</td>
										<td>10</td>
										<!-- <td><textarea class="form-control" name="data[l1_reason9]"><?php //echo $ajio['l1_reason9'] ?></textarea></td> -->
										<td>
											
											<select class="form-control" id="himself_inb_v2" name="data[l1_reason9]" disabled>
												<?php 
												if($ajio['l1_reason9']!=''){
													?>
													<option value="<?php echo $ajio['l1_reason9'] ?>"><?php echo $ajio['l1_reason9'] ?></option>
													<?php
												}
												?>
												<option  <?php echo $ajio['l1_reason9'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
												
											</select>
										</td>
										<td><textarea class="form-control" name="data[l2_reason9]" disabled><?php echo $ajio['l2_reason9'] ?></textarea></td>
									</tr>
									<tr>
										<td rowspan=4 style="background-color:#85C1E9; font-weight:bold">Effective System Navigation & KM Usage</td>
										<td colspan="2">Did the champ refer to all releavnt articles/T2Rs correctly</td>
										<td>
											<select class="form-control ajio" id="releavnt_article_inb_v2" name="data[refer_all_releavnt_article]" disabled>
												<option ajio_val=5 ajio_max=5 <?php echo $ajio['refer_all_releavnt_article'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ajio_val=0 ajio_max=5 <?php echo $ajio['refer_all_releavnt_article'] == "No"?"selected":"";?> value="No">No</option>
											</select>
										</td>
										<td>5</td>
										<!-- <td><textarea class="form-control" name="data[l1_reason10]"><?php //echo $ajio['l1_reason10'] ?></textarea></td> -->
										<td>
											
											<select class="form-control" id="article_inb_v2" name="data[l1_reason10]" disabled>
												<?php 
												if($ajio['l1_reason10']!=''){
													?>
													<option value="<?php echo $ajio['l1_reason10'] ?>"><?php echo $ajio['l1_reason10'] ?></option>
													<?php
												}
												?>
												<option  <?php echo $ajio['l1_reason10'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
												
											</select>
										</td>
										<td><textarea class="form-control" name="data[l2_reason10]" disabled><?php echo $ajio['l2_reason10'] ?></textarea></td>
									</tr>
									<tr>
										<td colspan="2">Did the champ refer to different applications/portals/tools to identify the root cause of customer issue and enable resolution</td>
										<td>
											<select class="form-control ajio" id="different_application_inb_v2" name="data[refer_different_application]" disabled>
												<option ajio_val=5 ajio_max=5 <?php echo $ajio['refer_different_application'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ajio_val=0 ajio_max=5 <?php echo $ajio['refer_different_application'] == "No"?"selected":"";?> value="No">No</option>
											</select>
										</td>
										<td>5</td>
										<!-- <td><textarea class="form-control" name="data[l1_reason11]"><?php //echo $ajio['l1_reason11'] ?></textarea></td> -->
										<td>
											
											<select class="form-control" id="application_inb_v2" name="data[l1_reason11]" disabled>
												<?php 
												if($ajio['l1_reason11']!=''){
													?>
													<option value="<?php echo $ajio['l1_reason11'] ?>"><?php echo $ajio['l1_reason11'] ?></option>
													<?php
												}
												?>
												<option  <?php echo $ajio['l1_reason11'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
												
											</select>
										</td>
										<td><textarea class="form-control" name="data[l2_reason11]" disabled><?php echo $ajio['l2_reason11'] ?></textarea></td>
									</tr>
									<tr>
										<td  style="color:red" colspan="2">Call/Interaction was authenticated wherever required</td>
										<td>
											<select class="form-control ajio fatal ajioAF4" id="ajioAF4_inb_v2" name="data[call_was_authenticated]" disabled>
												<option ajio_val=5 ajio_max=5 <?php echo $ajio['call_was_authenticated'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ajio_val=0 ajio_max=5 <?php echo $ajio['call_was_authenticated'] == "No"?"selected":"";?> value="No">No</option>
												<option ajio_val=5 ajio_max=5 <?php echo $ajio['call_was_authenticated'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
												<option ajio_val=0 ajio_max=5 <?php echo $ajio['call_was_authenticated'] == "Autofail"?"selected":"";?> value="Autofail">Autofail</option>
											</select>
										</td>
										<td>5</td>
										<td><textarea class="form-control" name="data[l1_reason12]" disabled><?php echo $ajio['l1_reason12'] ?></textarea></td>
										<!-- <td>
											
											<select class="form-control" id="AF4_inb_v2" name="data[l1_reason12]" disabled>
												<?php 
												//if($ajio['l1_reason12']!=''){
													?>
													<option value="<?php //echo $ajio['l1_reason12'] ?>"><?php //echo $ajio['l1_reason12'] ?></option>
													<?php
												//}
												?>
												<option  <?php //echo $ajio['l1_reason12'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
												
											</select>
										</td> -->
										<td><textarea class="form-control" name="data[l2_reason12]" disabled><?php echo $ajio['l2_reason12'] ?></textarea></td>
									</tr>
									<tr>
										<td colspan="2">Was the champ able to effectively navigate through and toggle between different tools/aids to wrap up the call in a timely manner</td>
										<td>
											<select class="form-control ajio" id="navigate_through_inb_v2" name="data[effectively_navigate_through]" disabled>
												<option ajio_val=5 ajio_max=5 <?php echo $ajio['effectively_navigate_through'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ajio_val=0 ajio_max=5 <?php echo $ajio['effectively_navigate_through'] == "No"?"selected":"";?> value="No">No</option>
											</select>
										</td>
										<td>5</td>
										<!-- <td><textarea class="form-control" name="data[l1_reason13]"><?php //echo $ajio['l1_reason13'] ?></textarea></td> -->
										<td>
											
											<select class="form-control" id="through_inb_v2" name="data[l1_reason13]" disabled>
												<?php 
												if($ajio['l1_reason13']!=''){
													?>
													<option value="<?php echo $ajio['l1_reason13'] ?>"><?php echo $ajio['l1_reason13'] ?></option>
													<?php
												}
												?>
												<option  <?php echo $ajio['l1_reason13'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
												
											</select>
										</td>
										<td><textarea class="form-control" name="data[l2_reason13]" disabled><?php echo $ajio['l2_reason13'] ?></textarea></td>
									</tr>
									<tr>
										<td rowspan=3 style="background-color:#85C1E9; font-weight:bold">Issue Resolution</td>
										<td  style="color:red" colspan="2">Champ executed all necessary actions to ensure issue resolution</td>
										<td>
											<select class="form-control ajio fatal ajioAF5" id="ajioAF5_inb_v2" name="data[executed_all_necessary]" disabled>
												<option ajio_val=5 ajio_max=5 <?php echo $ajio['executed_all_necessary'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
										<!-- 		<option ajio_val=0 ajio_max=5 <?php //echo $ajio['executed_all_necessary'] == "C&R raised when not disabled"?"selected":"";?> value="C&R raised when not disabled">C&R raised when not disabled</option>
												<option ajio_val=0 ajio_max=5 <?php //echo $ajio['executed_all_necessary'] == "C&R not raised when disabled"?"selected":"";?> value="C&R not raised when disabled">C&R not raised when disabled</option>
												<option ajio_val=0 ajio_max=5 <?php //echo $ajio['executed_all_necessary'] == "Wrong C&R raised"?"selected":"";?> value="Wrong C&R raised">Wrong C&R raised</option>
												<option ajio_val=0 ajio_max=5 <?php //echo $ajio['executed_all_necessary'] == "C&R raised without images/appropriate details"?"selected":"";?> value="C&R raised without images/appropriate details">C&R raised without images/appropriate details</option>
												<option ajio_val=0 ajio_max=5 <?php //echo $ajio['executed_all_necessary'] == "Action not taken"?"selected":"";?> value="Action not taken">Action not taken</option>
												<option ajio_val=0 ajio_max=5 <?php //echo $ajio['executed_all_necessary'] == "Unnecessary redirection"?"selected":"";?> value="Unnecessary redirection">Unnecessary redirection</option> -->
												<option ajio_val=0 ajio_max=5 <?php echo $ajio['executed_all_necessary'] == "Autofail"?"selected":"";?> value="Autofail">Autofail</option>
											</select>
										</td>
										<td>5</td>
										<td>
											
											<select class="form-control" id="AF5_inb_v2" name="data[l1_reason14]" disabled>
												<?php 
												if($ajio['l1_reason14']!=''){
													?>
													<option value="<?php echo $ajio['l1_reason14'] ?>"><?php echo $ajio['l1_reason14'] ?></option>
													<?php
												}
												?>
												<option  <?php echo $ajio['l1_reason14'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
												
											</select>
										</td>
										<td><textarea class="form-control" name="data[l2_reason14]" disabled><?php echo $ajio['l2_reason14'] ?></textarea></td>
									</tr>
									<tr>
										<td  style="color:red" colspan="2">All the queries were answered properly and in an informative way to avoid repeat call. Champ provided a clear understanding of action taken and the way forward to the customer</td>
										<td>
											<select class="form-control ajio ajioAF6" id="ajioAF6_inb_v2" name="data[queries_answered_properly]" disabled>
												<option ajio_val=10 ajio_max=10 <?php echo $ajio['queries_answered_properly'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<!-- <option ajio_val=0 ajio_max=10 <?php //echo $ajio['queries_answered_properly'] == "Incorrect information Shared"?"selected":"";?> value="Incorrect information Shared">Incorrect information Shared</option>
												<option ajio_val=0 ajio_max=10 <?php //echo $ajio['queries_answered_properly'] == "Incomplete information Shared"?"selected":"";?> value="Incomplete information Shared">Incomplete information Shared</option> -->
												<option ajio_val=0 ajio_max=10 <?php echo $ajio['queries_answered_properly'] == "Autofail"?"selected":"";?> value="Autofail">Autofail</option>
											</select>
										</td>
										<!-- <td>
											<textarea class="form-control" name="data[l1_reason15]"><?php //echo $ajio['l1_reason15'] ?></textarea>
											<select class="form-control" name="data[l1_reason15]" >
												<option value=""></option>
												<option <?php //echo $ajio['l1_reason15'] == "Incorrect information Shared"?"selected":"";?> value="Incorrect information Shared">Incorrect information Shared</option>
												<option <?php //echo $ajio['l1_reason15'] == "Incomplete information Shared"?"selected":"";?> value="Incomplete information Shared">Incomplete information Shared</option>
												<option <?php //echo $ajio['l1_reason15'] == "Wrong action taken & No action taken"?"selected":"";?> value="Wrong action taken & No action taken">Wrong action taken & No action taken</option>
											</select>
										</td> -->
										<td>10</td>
										<td>
											
											<select class="form-control" id="AF6_inb_v2" name="data[l1_reason15]" disabled>
												<?php 
												if($ajio['l1_reason15']!=''){
													?>
													<option value="<?php echo $ajio['l1_reason15'] ?>"><?php echo $ajio['l1_reason15'] ?></option>
													<?php
												}
												?>
												<option  <?php echo $ajio['l1_reason15'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
												
											</select>
										</td>
										<td><textarea class="form-control" name="data[l2_reason15]" disabled><?php echo $ajio['l2_reason15'] ?></textarea></td>
									</tr>
									<tr>
										<td  style="color:red" colspan="2">Did the champ document the case correctly and adhered to tagging guidelines</td>
										<td>
											<select class="form-control ajio fatal ajioAF7" id="ajioAF7_inb_v2" name="data[document_the_case_correctly]" disabled>
												<option ajio_val=5 ajio_max=5 <?php echo $ajio['document_the_case_correctly'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ajio_val=0 ajio_max=5 <?php echo $ajio['document_the_case_correctly'] == "No"?"selected":"";?> value="No">No</option>
												<!-- <option ajio_val=0 ajio_max=5 <?php //echo $ajio['document_the_case_correctly'] == "CAM rule not adhered to"?"selected":"";?> value="CAM rule not adhered to">CAM rule not adhered to</option>
												<option ajio_val=0 ajio_max=5 <?php //echo $ajio['document_the_case_correctly'] == "Documented on incorrect account"?"selected":"";?> value="Documented on incorrect account">Documented on incorrect account</option>
												<option ajio_val=0 ajio_max=5 <?php//// echo $ajio['document_the_case_correctly'] == "All queries not documented"?"selected":"";?> value="All queries not documented">All queries not documented</option> -->
												<option ajio_val=0 ajio_max=5 <?php echo $ajio['document_the_case_correctly'] == "Autofail"?"selected":"";?> value="Autofail">Autofail</option>
											</select>
										</td>
										<td>5</td>
										<!-- <td><textarea class="form-control" name="data[l1_reason16]"><?php //echo $ajio['l1_reason16'] ?></textarea></td> -->
										<td>
											
											<select class="form-control" id="AF7_inb_v2" name="data[l1_reason16]" disabled>
												<?php 
												if($ajio['l1_reason16']!=''){
													?>
													<option value="<?php echo $ajio['l1_reason16'] ?>"><?php echo $ajio['l1_reason16'] ?></option>
													<?php
												}
												?>
												<option  <?php echo $ajio['l1_reason16'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
												
											</select>
										</td>
										<td><textarea class="form-control" name="data[l2_reason16]" disabled><?php echo $ajio['l2_reason16'] ?></textarea></td>
									</tr>
									<tr>
										<td style="background-color:#F1948A; font-weight:bold">ZTP</td>
										<td  style="color:red" colspan="2">As per AJIO ZTP guidelines</td>
										<td>
											<select class="form-control ajio fatal ajioAF8"  id="ajioAF8_inb_v2" name="data[ztp_guidelines]" disabled>
												<option ajio_val=0 ajio_max=0 <?php echo $ajio['ztp_guidelines'] == "No"?"selected":"";?> value="No">No</option>
												<option ajio_val=0 ajio_max=0 <?php echo $ajio['ztp_guidelines'] == "Autofail"?"selected":"";?> value="Autofail">Autofail</option>
											</select>
										</td>
										<td>0</td>
										<!-- <td><textarea class="form-control" name="data[l1_reason17]"><?php //echo $ajio['l1_reason17'] ?></textarea></td> -->
										<td>
											
											<select class="form-control" id="AF8_inb_v2" name="data[l1_reason17]" disabled>
												<?php 
												if($ajio['l1_reason17']!=''){
													?>
													<option value="<?php echo $ajio['l1_reason17'] ?>"><?php echo $ajio['l1_reason17'] ?></option>
													<?php
												}
												?>
												<option  <?php echo $ajio['l1_reason17'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
												
											</select>
										</td>
										<td><textarea class="form-control" name="data[l2_reason17]" disabled><?php echo $ajio['l2_reason17'] ?></textarea></td>
									</tr>
										<tr>
											<td>Call Synopsis:</td>
											<td colspan=6><textarea class="form-control" readonly name="data[call_synopsis]" disabled><?php echo $ajio['call_synopsis'] ?></textarea></td>
										</tr>
										<tr>
											<td>Call Observation:</td>
											<td colspan=2><textarea class="form-control" readonly name="data[call_summary]" disabled><?php echo $ajio['call_summary'] ?></textarea></td>
											<td>Feedback:</td>
											<td colspan=3><textarea class="form-control" readonly name="data[feedback]" disabled><?php echo $ajio['feedback'] ?></textarea></td>
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
											<td>QA Name:<span style="font-size:24px;color:red">*</span></td>
											<?php if($ajio['entry_by']!=''){
													$auditorName = $ajio['auditor_name'];
												}else{
													$auditorName = $ajio['client_name'];
											} ?>
											<td><input type="text" class="form-control" value="<?php echo $auditorName; ?>" disabled></td>
											<td>Audit Date:<span style="font-size:24px;color:red">*</span></td>
											<td><input type="text" class="form-control" value="<?php echo mysql2mmddyy($ajio['audit_date']); ?>" disabled></td>
											<td colspan="2">Call Date/Time:<span style="font-size:24px;color:red">*</span></td>
											<td><input type="text" class="form-control" value="<?php echo mysql2mmddyy($ajio['call_date']); ?>" disabled></td>
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
											<td colspan="2">L1 Supervisor:</td>
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
											<td>Interaction ID:<span style="font-size:24px;color:red">*</span></td>
											<td><input type="text" class="form-control" name="data[call_id]" value="<?php echo $ajio['call_id'] ?>" disabled></td>
											<td colspan="2">Predactive CSAT:<span style="font-size:24px;color:red">*</span></td>
											<td>
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
											<td colspan="2">Possible Score:</td>
											<td><input type="text" readonly id="possibleScore" name="data[possible_score]" class="form-control" style="font-weight:bold" value="<?php echo $ajio['possible_score'] ?>"></td>
										</tr>
										<tr>
											<td>Tagging by Evaluator:<span style="font-size:24px;color:red">*</span></td>
											<td colspan="4">
												<select class="form-control" name="data[tagging_evaluator]" disabled>
													<option value="<?php echo $ajio['tagging_evaluator'] ?>"><?php echo $ajio['tagging_evaluator'] ?></option>
												</select>
											</td>

											<td style="font-weight:bold; font-size:16px; text-align:right">Overall Score:</td>
											<td><input type="text" readonly id="overallScore" name="data[overall_score]" class="form-control ajioFatal" style="font-weight:bold" value="<?php echo $ajio['overall_score'] ?>"></td>
										</tr>
										<tr style="background-color:#85C1E9; font-weight:bold">
											<td>Parameter</td>
											<td colspan=2>Sub Parameter</td>
											<td>Defect</td>
											<td>Weightage</td>
											<td>L1 Reason</td>
											<td>Remarks</td>
										</tr>
									<tr>
										<td rowspan=7 style="background-color:#85C1E9; font-weight:bold">Comprehension & Email Ettiquettes</td>
										<td colspan=2>Did the champ use appropriate acknowledgements, re-assurance and apology wherever disabled</td>
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
										<td colspan=2 style="color:red">Did the champ refer to all relevant previous interactions when disabled to gather information about customer's account and issue end to end</td>
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
										<td colspan=2>Was the champ able to identify and handle objections effectively and offer rebuttals wherever disabled</td>
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
										<td colspan=2 style="color:red">Email/Interaction was authenticated wherever disabled</td>
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
										<td colspan=2>Did the champ take ownership and request for outcall/call back was addressed wherever disabled</td>
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
											<textarea class="form-control" name="data[l1_reason12]" disabled><?php echo $ajio['l1_reason12'] ?></textarea>
											<!-- <select class="form-control" name="data[l1_reason12]" disabled >
												<option value=""></option>
												<option <?php echo $ajio['l1_reason12'] == "C&R raised when not disabled"?"selected":"";?> value="C&R raised when not disabled">C&R raised when not disabled</option>
												<option <?php echo $ajio['l1_reason12'] == "C&R not raised when disabled"?"selected":"";?> value="C&R not raised when disabled">C&R not raised when disabled</option>
												<option <?php echo $ajio['l1_reason12'] == "Wrong C&R raised"?"selected":"";?> value="Wrong C&R raised">Wrong C&R raised</option>
												<option <?php echo $ajio['l1_reason12'] == "C&R raised without images/appropriate details"?"selected":"";?> value="C&R raised without images/appropriate details">C&R raised without images/appropriate details</option>
												<option <?php echo $ajio['l1_reason12'] == "Action not taken"?"selected":"";?> value="Action not taken">Action not taken</option>
												<option <?php echo $ajio['l1_reason12'] == "Unnecessary redirection"?"selected":"";?> value="Unnecessary redirection">Unnecessary redirection</option>
												<option <?php echo $ajio['l1_reason12'] == "Autofail & Yes"?"selected":"";?> value="Autofail & Yes">Autofail & Yes</option>
											</select> -->
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
											<textarea class="form-control" name="data[l1_reason13]" disabled><?php echo $ajio['l1_reason13'] ?></textarea>
											<!-- <select class="form-control" name="data[l1_reason13]" disabled >
												<option value=""></option>
												<option <?php echo $ajio['l1_reason13'] == "Incorrect information Shared"?"selected":"";?> value="Incorrect information Shared">Incorrect information Shared</option>
												<option <?php echo $ajio['l1_reason13'] == "Incomplete information Shared"?"selected":"";?> value="Incomplete information Shared">Incomplete information Shared</option>
												<option <?php echo $ajio['l1_reason13'] == "False assurance"?"selected":"";?> value="False assurance">False assurance</option>
											</select> -->
										</td>
										<td><textarea class="form-control" disabled name="data[l2_reason13]"><?php echo $ajio['l2_reason13'] ?></textarea></td>
									</tr>
									<tr>
										<td colspan=2 style="color:red">Did the champ document the case correctly and adhered to tagging guidelines.</td>
										<td>
											<select class="form-control ajio fatal" id="ajioAF6" name="data[tagging_guidelines]" disabled>
												<option ajio_val=5 ajio_max=5 <?php echo $ajio['tagging_guidelines'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ajio_val=0 ajio_max=5 <?php echo $ajio['tagging_guidelines'] == "Autofail"?"selected":"";?> value="Autofail">Autofail</option>
												<option ajio_val=0 ajio_max=5 <?php echo $ajio['tagging_guidelines'] == "No"?"selected":"";?> value="No">No</option>
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
									<?php }else if($campaign=="chat_v2"){ ?>

										<tr>
											<td>QA Name:<span style="font-size:24px;color:red">*</span></td>
											<?php if($ajio['entry_by']!=''){
													$auditorName = $ajio['auditor_name'];
												}else{
													$auditorName = $ajio['client_name'];
											} ?>
											<td><input type="text" class="form-control" value="<?php echo $auditorName; ?>" disabled></td>
											<td>Audit Date:<span style="font-size:24px;color:red">*</span></td>
											<td><input type="text" class="form-control" value="<?php echo mysql2mmddyy($ajio['audit_date']); ?>" disabled></td>
											<td colspan="2">Call Date/Time:<span style="font-size:24px;color:red">*</span></td>
											<td><input type="text" class="form-control" value="<?php echo mysql2mmddyy($ajio['call_date']); ?>" disabled></td>
										</tr>
										<tr>
											<td>Champ Name:<span style="font-size:24px;color:red">*</span></td>
											<td>
												<select class="form-control agentName" id="agent_id" name="data[agent_id]" disabled >
													<option value="<?php echo $ajio['agent_id'] ?>"><?php echo $ajio['fname']." ".$ajio['lname'] ?></option>
												</select>
											</td>
											<td>Fusion ID:<span style="font-size:24px;color:red">*</span></td>
											<td><input type="text" class="form-control" id="fusion_id" value="<?php echo $ajio['fusion_id'] ?>" readonly ></td>
											<td colspan="2">L1 Supervisor:</td>
											<td>
												<select class="form-control" id="tl_id" name="data[tl_id]" readonly>
													<option value="<?php echo $ajio['tl_id'] ?>"><?php echo $ajio['tl_name'] ?></option>	
												</select>
											</td>
										</tr>
										<tr>
										<td>Interaction ID:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control" name="data[call_id]" value="<?php echo $ajio['call_id'] ?>" disabled ></td>
										<td>Call Duration:</td>
										<td><input type="text" class="form-control" id="call_duration" name="data[call_duration]" value="<?php echo $ajio['call_duration'] ?>" disabled ></td>
										<td>Type of Audit:<span style="font-size:24px;color:red">*</span></td>
										<td>
											<select class="form-control" name="data[type_of_audit]" disabled>
												<?php 
												if($ajio_chatV2['type_of_audit']!=''){
													?>
													<option value="<?php echo $ajio['type_of_audit'] ?>"><?php echo $ajio['type_of_audit'] ?></option>
													<?php
												}
												?>
												<option value="">-Select-</option>
												<option value="GB Audit">GB Audit</option>
												<option value="High AHT Audit">High AHT Audit</option>
												<option value="Random Audit">Random Audit</option>
												<option value="A2A">A2A</option>
												<option value="Calibration">Calibration</option>
											</select>
										</td>
										
									</tr>
									 <tr>
										
										<td>Predactive CSAT:<span style="font-size:24px;color:red">*</span></td>
										<td>
											<select class="form-control" id="audit_type" name="data[audit_type]" disabled>
												<?php 
												if($ajio['audit_type']!=''){
													?>
													<option value="<?php echo $ajio['audit_type'] ?>"><?php echo $ajio['audit_type'] ?></option>
													<?php
												}
												?>
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
											<select class="form-control" id="auditor_type" name="data[auditor_type]" disabled>
												<option value="">-Select-</option>
												<option value="Master">Master</option>
												<option value="Regular">Regular</option>
											</select>
										</td>
										<td>VOC:<span style="font-size:24px;color:red">*</span></td>
										<td colspan="2">
											<select class="form-control" id="voc" name="data[voc]" disabled>
												<?php
												if($ajio['voc']!=''){
													?>
													<option value="<?php echo $ajio['voc'] ?>"><?php echo $ajio['voc'] ?></option>
													<?php
												}
												 ?> 
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
									<td>Tagging by Evaluator:<span style="font-size:24px;color:red">*</span></td>
											<td colspan="4">
												<select class="form-control agentName" name="data[tagging_evaluator]" disabled>
													<option value="<?php echo $ajio['tagging_evaluator'] ?>"><?php echo $ajio['tagging_evaluator'] ?></option>
												</select>
											</td>
									<tr>
									<td>Auditor Department:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control" value="<?php echo $department[0]['department']; ?>" disabled>
										</td>
									<td>Auditor Role:<span style="font-size:24px;color:red">*</span></td>
										<td colspan="2"><input type="text" class="form-control" value="<?php echo $role[0]['role']; ?>" disabled>
										</td>	
									</tr>	
										
										<tr>
										<td style="font-weight:bold; font-size:16px; text-align:right">Earned Score:</td>
										<td><input type="text" readonly id="earnedScore" name="data[earned_score]" class="form-control" style="font-weight:bold" value="<?php echo $ajio['earned_score'] ?>"></td>
										<td style="font-weight:bold; font-size:16px; text-align:right">Possible Score:</td>
										<td><input type="text" readonly id="possibleScore" name="data[possible_score]" class="form-control" style="font-weight:bold" value="<?php echo $ajio['possible_score'] ?>"></td>
										<td style="font-weight:bold; font-size:16px; text-align:right">Overall Score:</td>
										<td colspan="2"><input type="text" readonly id="overallScore" name="data[overall_score]" class="form-control ajio_chat_v2Fatal" style="font-weight:bold" value="<?php echo $ajio['overall_score'] ?>"></td>
									</tr>
									<tr style="font-weight:bold">
										<td><input type="hidden" class="form-control" id="prefatal" name="data[pre_fatal_score]" value="<?php echo $ajio['pre_fatal_score'] ?>"></td>
										<td><input type="hidden" class="form-control" id="fatalcount" name="data[fatal_count]" value="<?php echo $ajio['fatal_count'] ?>"></td>
									</tr>
										<tr style="background-color:#85C1E9; font-weight:bold">
										<td>Parameter</td>
										<td colspan=2>Sub Parameter</td>
										<td>Defect</td>
										<td>Weightage</td>
										<td>L1 Reason</td>
										<td>Remarks</td>
									</tr>
									<tr>
										<td rowspan=9 style="background-color:#85C1E9; font-weight:bold">Comprehension & Chat Ettiquettes</td>
										<td colspan=2>Did the champ open the chat within 10 seconds and introduce himself properly?</td>
										<td>
											<select class="form-control ajio" id="appropriate_acknowledgements_chat" name="data[appropriate_acknowledgements]" disabled>
												<option ajio_val=5 ajio_max=5 <?php echo $ajio['appropriate_acknowledgements'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ajio_val=0 ajio_max=5 <?php echo $ajio['appropriate_acknowledgements'] == "No"?"selected":"";?> value="No">No</option>
											</select>
										</td>
										<td>5</td>
										<td>
											<!-- <textarea class="form-control" name="data[l1_reason1]"><?php //echo $ajio['l1_reason1'] ?></textarea> -->
											<select class="form-control" id="appropriate" name="data[l1_reason1]" disabled>
												<?php 
												if($ajio['l1_reason1']!=''){
													?>
													<option value="<?php echo $ajio['l1_reason1'] ?>"><?php echo $ajio['l1_reason1'] ?></option>
													<?php
												}
												?>
												<option  <?php echo $ajio['l1_reason1'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
												
											</select>
										</td>
										<td><textarea class="form-control" name="data[cmt1]" disabled><?php echo $ajio['cmt1'] ?></textarea></td>
									</tr>
									<tr>
										<td colspan=2>Did the champ use appropriate acknowledgements, re-assurance and apology wherever disabled</td>
										<td>
											<select class="form-control ajio" id="font_size_formatting_chat" name="data[font_size_formatting]" disabled>
												<option ajio_val=5 ajio_max=5 <?php echo $ajio['font_size_formatting'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ajio_val=0 ajio_max=5 <?php echo $ajio['font_size_formatting'] == "No"?"selected":"";?> value="No">No</option>
											</select>
										</td>
										<td>5</td>
										<td>
											<!-- <textarea class="form-control" name="data[l1_reason2]"><?php echo $ajio['l1_reason2'] ?></textarea> -->
											<select class="form-control" id="font_size" name="data[l1_reason2]" disabled>
												<?php 
												if($ajio['l1_reason2']!=''){
													?>
													<option value="<?php echo $ajio['l1_reason2'] ?>"><?php echo $ajio['l1_reason2'] ?></option>
													<?php
												}
												?>
												<option  <?php echo $ajio['l1_reason2'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td><textarea class="form-control" name="data[cmt2]" disabled><?php echo $ajio['cmt2'] ?></textarea></td>
									</tr>
									<tr>
										<td colspan=2>Did the champ follow Hold procedure as per SOP?</td>
										<td>
											<select class="form-control ajio" id="chat_response" name="data[email_response]" disabled>
												<option ajio_val=5 ajio_max=5 <?php echo $ajio['email_response'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ajio_val=0 ajio_max=5 <?php echo $ajio['email_response'] == "No"?"selected":"";?> value="No">No</option>
											</select>
										</td>
										<td>5</td>
										<td>
											<!-- <textarea class="form-control" name="data[l1_reason3]"><?php //echo $ajio['l1_reason3'] ?></textarea> -->
											<select class="form-control" id="chat_res" name="data[l1_reason3]" disabled>
												<?php 
												if($ajio['l1_reason3']!=''){
													?>
													<option value="<?php //echo $ajio['audit_type'] ?>"><?php echo $ajio['l1_reason3'] ?></option>
													<?php
												}
												?>
												<option  <?php echo $ajio['l1_reason3'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>	
										</td>
										<td><textarea class="form-control" name="data[cmt3]" disabled><?php echo $ajio['cmt3'] ?></textarea></td>
									</tr>
									<tr>
										<td colspan=2 >Was champ able to express/articulate himself and seamlessly converse with the customer</td>
										<td>
										<select class="form-control ajio" id="seamlessly_chat" name="data[seamlessly]" disabled>
												<option ajio_val=5 ajio_max=5 <?php echo $ajio['seamlessly'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ajio_val=0 ajio_max=5 <?php echo $ajio['seamlessly'] == "No"?"selected":"";?> value="No">No</option>
											</select>
										</td>
										<td>10</td>
										<td>
											<!-- <textarea class="form-control" name="data[l1_reason4]"><?php //echo $ajio['l1_reason4'] ?></textarea> -->
											<select class="form-control" id="seam_chat" name="data[l1_reason4]" disabled>
												<?php 
												if($ajio['l1_reason4']!=''){
													?>
													<option value="<?php //echo $ajio['audit_type'] ?>"><?php echo $ajio['l1_reason4'] ?></option>
													<?php
												}
												?>
												<option  <?php echo $ajio['l1_reason4'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>	
										</td>
										<td><textarea class="form-control" name="data[cmt4]" disabled><?php echo $ajio['cmt4'] ?></textarea></td>
									</tr>
									<tr>
										<td colspan=2>Did the champ offer further assistance and follow appropriate chat closure/supervisor transfer process.</td>
										<td>
											<select class="form-control ajio" id="written_communication_chat" name="data[written_communication]" disabled>
												<option ajio_val=10 ajio_max=10 <?php echo $ajio['written_communication'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ajio_val=0 ajio_max=10 <?php echo $ajio['written_communication'] == "No"?"selected":"";?> value="No">No</option>
											</select>
										</td>
										<td>10</td>
										<td>
											<!-- <textarea class="form-control" name="data[l1_reason5]"><?php //echo $ajio['l1_reason5'] ?></textarea> -->
											<select class="form-control" id="written_comm" name="data[l1_reason5]" disabled>
												<?php 
												if($ajio['l1_reason5']!=''){
													?>
													<option value="<?php //echo $ajio['audit_type'] ?>"><?php echo $ajio['l1_reason5'] ?></option>
													<?php
												}
												?>
												<option  <?php echo $ajio['l1_reason5'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>	

										</td>
										<td><textarea class="form-control" name="data[cmt5]" disabled><?php echo $ajio['cmt5'] ?></textarea></td>
									</tr>
									<tr>
										<td colspan=2 style="color:red">Did the champ use appropriate canned response and customized it to ensure all concerns raised were answered appropriately</td>
										<td>
										<select class="form-control ajio fatal ajioAF1" id="ajioAF1_chat" name="data[use_appropriate_template]" disabled>
												<option ajio_val=10 ajio_max=10 <?php echo $ajio['use_appropriate_template'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ajio_val=0 ajio_max=10 <?php echo $ajio['use_appropriate_template'] == "Autofail"?"selected":"";?> value="Autofail">Autofail</option>
											</select>
										</td>
										<td>10</td>
										<td>
											<select class="form-control" id="relevant_previous_chat" name="data[l1_reason6]" disabled>
												<?php 
												if($ajio['l1_reason6']!=''){
													?>
													<option value="<?php //echo $ajio['audit_type'] ?>"><?php echo $ajio['l1_reason6'] ?></option>
													<?php
												}
												?>
												<option  <?php echo $ajio['l1_reason6'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td><textarea class="form-control" name="data[cmt6]" disabled><?php echo $ajio['cmt6'] ?></textarea></td>
									</tr>
									<tr>
										<td colspan=2>Did the champ maintain accuracy of written communication ensuring no grammatical errors, SVAs, Punctuation and sentence construction errors.</td>
										<td>
											<select class="form-control ajio" id="communication_chat" name="data[communication]" disabled>
												<option ajio_val=10 ajio_max=10 <?php echo $ajio['communication'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ajio_val=0 ajio_max=10 <?php echo $ajio['communication'] == "No"?"selected":"";?> value="No">No</option>
											</select>
										</td>
										<td>10</td>
										<td>
											<!-- <textarea class="form-control" name="data[l1_reason7]"><?php //echo $ajio['l1_reason7'] ?></textarea> -->
											<select class="form-control" id="commun_chat" name="data[l1_reason7]" disabled>
												<?php 
												if($ajio['l1_reason7']!=''){
													?>
													<option value="<?php //echo $ajio['audit_type'] ?>"><?php echo $ajio['l1_reason7'] ?></option>
													<?php
												}
												?>
												<option  <?php echo $ajio['l1_reason7'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td><textarea class="form-control" name="data[cmt7]" disabled><?php echo $ajio['cmt7'] ?></textarea></td>
									</tr>
								
									<tr>
										<td colspan=2 style="color:red">Did the champ refer to all relevant previous interactions when disabled to gather information about customer's account and issue end to end</td>
										<td>
										<select class="form-control ajio fatal ajioAF2" id="ajioAF2_chat" name="data[relevant_previous_interactions]" disabled>
												<option ajio_val=10 ajio_max=10 <?php echo $ajio['use_appropriate_template'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ajio_val=0 ajio_max=10 <?php echo $ajio['relevant_previous_interactions'] == "Autofail"?"selected":"";?> value="Autofail">Autofail</option>
											</select>
										</td>
										<td>10</td>
										<td>
											<!-- <textarea class="form-control" name="data[l1_reason7]"><?php //echo $ajio['l1_reason7'] ?></textarea> -->
											<select class="form-control" id="ajiochat" name="data[l1_reason8]" disabled>
												<?php 
												if($ajio['l1_reason8']!=''){
													?>
													<option value="<?php //echo $ajio['audit_type'] ?>"><?php echo $ajio['l1_reason8'] ?></option>
													<?php
												}
												?>
												<option  <?php echo $ajio['l1_reason8'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td><textarea class="form-control" name="data[cmt8]" disabled><?php echo $ajio['cmt8'] ?></textarea></td>
									</tr>
									<tr>
										<td colspan=2 >Was the champ able to identify and handle objections effectively and offer rebuttals wherever disabled</td>
										<td>
											<select class="form-control ajio" id="handle_objections_chat" name="data[handle_objections]" disabled>
												<option ajio_val=10 ajio_max=10 <?php echo $ajio['handle_objections'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ajio_val=0 ajio_max=10 <?php echo $ajio['handle_objections'] == "No"?"selected":"";?> value="No">No</option>
											</select>
										</td>
										<td>10</td>
										<td>
											<!-- <textarea class="form-control" name="data[l1_reason7]"><?php //echo $ajio['l1_reason7'] ?></textarea> -->
											<select class="form-control" id="handle_obj_chat" name="data[l1_reason9]" disabled>
												<?php 
												if($ajio['l1_reason9']!=''){
													?>
													<option value="<?php //echo $ajio['audit_type'] ?>"><?php echo $ajio['l1_reason9'] ?></option>
													<?php
												}
												?>
												<option  <?php echo $ajio['l1_reason9'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td><textarea class="form-control" name="data[cmt9]" disabled><?php echo $ajio['cmt9'] ?></textarea></td>
									</tr>
									<tr>
										<td rowspan=2 style="background-color:#85C1E9; font-weight:bold">Effective System Navigation & KM Usage </td>
										<td colspan=2>Did the champ refer to all releavnt articles/T2Rs correctly</td>
										<td>
											<select class="form-control ajio" id="releavnt_articles_chat" name="data[releavnt_articles]" disabled>
												<option ajio_val=5 ajio_max=5 <?php echo $ajio['releavnt_articles'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ajio_val=0 ajio_max=5 <?php echo $ajio['releavnt_articles'] == "No"?"selected":"";?> value="No">No</option>
												<!-- <option ajio_val=0 ajio_max=0 <?php //echo $ajio['all_relevant_articles'] == "N/A"?"selected":"";?> value="N/A">N/A</option> -->
											</select>
										</td>
										<td>5</td>
										<td>
											<!-- <textarea class="form-control" name="data[l1_reason8]"><?php //echo $ajio['l1_reason8'] ?></textarea> -->
											<select class="form-control" id="all_relevantchat" name="data[l1_reason10]" disabled>
												<?php 
												if($ajio['l1_reason10']!=''){
													?>
													<option value="<?php //echo $ajio['audit_type'] ?>"><?php echo $ajio['l1_reason10'] ?></option>
													<?php
												}
												?>
												<option  <?php echo $ajio['l1_reason10'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td><textarea class="form-control" name="data[cmt10]" disabled><?php echo $ajio['cmt10'] ?></textarea></td>
									</tr>
									<tr>
										<td colspan=2>Did the champ refer to different applications/portals/tools to identify the root cause of customer issue and enable resolution.</td>
										<td>
											<select class="form-control ajio" id="applications_portals_chat" name="data[applications_portals]" disabled>
												<option ajio_val=5 ajio_max=5 <?php echo $ajio['applications_portals'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ajio_val=0 ajio_max=5 <?php echo $ajio['applications_portals'] == "No"?"selected":"";?> value="No">No</option>
											</select>
										</td>
										<td>5</td>
										<td>
											<!-- <textarea class="form-control" name="data[l1_reason9]"><?php //echo $ajio['l1_reason9'] ?></textarea> -->
											<select class="form-control" id="applications_chat" name="data[l1_reason11]" disabled>
												<?php 
												if($ajio['l1_reason11']!=''){
													?>
													<option value="<?php //echo $ajio['audit_type'] ?>"><?php echo $ajio['l1_reason11'] ?></option>
													<?php
												}
												?>
												<option  <?php echo $ajio['l1_reason11'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td><textarea class="form-control" name="data[cmt11]" disabled><?php echo $ajio['cmt11'] ?></textarea></td>
									</tr>
									
									<tr>
										<td rowspan=3 style="background-color:#85C1E9; font-weight:bold">Issue Resolution</td>
										<td colspan=2 style="color:red">Champ executed all necessary actions to ensure issue resolution</td>
										<td>
											<select class="form-control ajio fatal ajioAF3" id="ajio_chatAF3" name="data[ensure_issue_resolution]" disabled>
												<option ajio_val=5 ajio_max=5 <?php echo $ajio['ensure_issue_resolution'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ajio_val=0 ajio_max=5 <?php echo $ajio['ensure_issue_resolution'] == "Autofail"?"selected":"";?> value="Autofail">Autofail</option>
											</select>
										</td>
										<td>5</td>
										<td>
											<!-- <textarea class="form-control" name="data[l1_reason10]"><?php //echo $ajio['l1_reason10'] ?></textarea> -->
											<select class="form-control" id="ensure_issue_chat" name="data[l1_reason12]" disabled>
												<?php 
												if($ajio['l1_reason12']!=''){
													?>
													<option value="<?php //echo $ajio['audit_type'] ?>"><?php echo $ajio['l1_reason12'] ?></option>
													<?php
												}
												?>
												<option  <?php echo $ajio['l1_reason12'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td><textarea class="form-control" name="data[cmt12]" disabled><?php echo $ajio['cmt12'] ?></textarea></td>
									</tr>
									<tr>
										<td colspan=2 style="color:red">All the queries were answered properly and in an informative way to avoid repeat call. Champ provided a clear understanding of action taken and the way forward to the customer.</td>
										<td>
											<select class="form-control ajio fatal ajioAF4" id="ajio_chatAF4" name="data[avoid_repeat_call]" disabled>
												<option ajio_val=10 ajio_max=10 <?php echo $ajio['avoid_repeat_call'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ajio_val=0 ajio_max=10 <?php echo $ajio['avoid_repeat_call'] == "Autofail"?"selected":"";?> value="Autofail">Autofail</option>
											</select>
										</td>
										<td>10</td>
										<td>
											<!-- <textarea class="form-control" name="data[l1_reason13]"><?php //echo $ajio['l1_reason13'] ?></textarea> -->
											<select class="form-control" id="avoid_repeat_chat" name="data[l1_reason13]" disabled>
												<?php 
												if($ajio['l1_reason13']!=''){
													?>
													<option value="<?php //echo $ajio['audit_type'] ?>"><?php echo $ajio['l1_reason13'] ?></option>
													<?php
												}
												?>
												<option  <?php echo $ajio['l1_reason13'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td><textarea class="form-control" name="data[cmt13]" disabled><?php echo $ajio['cmt13'] ?></textarea></td>
									</tr>
									<tr>
										<td colspan=2 style="color:red">Did the champ document the case correctly and adhered to tagging guidelines. </td>
										<td>
											<select class="form-control ajio fatal ajioAF5" id="ajio_chatAF5" name="data[tagging_guidelines]" disabled>
												<option ajio_val=5 ajio_max=5 <?php echo $ajio['tagging_guidelines'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ajio_val=0 ajio_max=5 <?php echo $ajio['tagging_guidelines'] == "No"?"selected":"";?> value="No">No</option>
												<option ajio_val=0 ajio_max=5 <?php echo $ajio['tagging_guidelines'] == "Autofail"?"selected":"";?> value="Autofail">Autofail</option>
											</select>
										</td>
										<td>5</td>
										<td>
											<!-- <textarea class="form-control" name="data[l1_reason14]"><?php //echo $ajio['l1_reason14'] ?></textarea> -->
										<select class="form-control" id="tagging_guide_chat" name="data[l1_reason14]" disabled>
											<?php 
												if($ajio['l1_reason14']!=''){
													?>
													<option value="<?php //echo $ajio['audit_type'] ?>"><?php echo $ajio['l1_reason14'] ?></option>
													<?php
												}
												?>
												<option  <?php echo $ajio['l1_reason14'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td><textarea class="form-control" name="data[cmt14]" disabled><?php echo $ajio['cmt14'] ?></textarea></td>
									</tr>

									<tr>
										<td style="background-color:#F1948A; font-weight:bold">ZTP</td>
										<td colspan=2 style="color:red">As per AJIO ZTP guidelines</td>
										<td>
											<select class="form-control ajio fatal" ajioAF6 id="ajio_chatAF6" name="data[ztp_guidelines]" disabled>
												<option ajio_val=0 ajio_max=0 <?php echo $ajio['ztp_guidelines'] == "No"?"selected":"";?> value="No">No</option>
												<option ajio_val=0 ajio_max=0 <?php echo $ajio['ztp_guidelines'] == "Autofail"?"selected":"";?> value="Autofail">Autofail</option>
											</select>
										</td>
										<td>0</td>
										<td>
											<select class="form-control" id="ztp_guide_chat" name="data[l1_reason15]" disabled>
												<?php 
												if($ajio['l1_reason15']!=''){
													?>
													<option value="<?php echo $ajio['l1_reason15'] ?>" disabled><?php echo $ajio['l1_reason15'] ?></option>
													<?php
												}
												?>
												<option  <?php echo $ajio['l1_reason15'] == "CAM rule not adhered to."?"selected":"";?> value="CAM rule not adhered to.">CAM rule not adhered to.</option>
												<option  <?php echo $ajio['l1_reason15'] == "Documented on incorrect account"?"selected":"";?> value="Documented on incorrect account">Documented on incorrect account</option>
												<option  <?php echo $ajio['l1_reason15'] == "All queries not documented"?"selected":"";?> value="All queries not documented">All queries not documented</option>
												<option  <?php echo $ajio['l1_reason15'] == "QT Not Tagget"?"selected":"";?> value="QT Not Tagget">QT Not Tagget</option>
												<option  <?php echo $ajio['l1_reason15'] == "Incorrect Tagging done"?"selected":"";?> value="Incorrect Tagging done">Incorrect Tagging done</option>
											</select>	
										</td>
										<td><textarea class="form-control" name="data[cmt15]" disabled><?php echo $ajio['cmt15'] ?></textarea></td>
									</tr>
									<tr>
										<td>Call Synopsis:</td>
										<td colspan="7"><textarea class="form-control" name="data[call_synopsis]" disabled><?php echo $ajio['call_synopsis'] ?></textarea></td>
									</tr>
									<tr>
										<td>Call Observation:</td>
										<td colspan=2><textarea class="form-control" name="data[call_summary]" disabled><?php echo $ajio['call_summary'] ?></textarea></td>
										<td>Feedback:</td>
										<td colspan="4"><textarea class="form-control" name="data[feedback]" disabled><?php echo $ajio['feedback'] ?></textarea></td>
									</tr>
										<tr>
											<td colspan=2>Upload Files</td>
											<?php if($ajio['attach_file']!=''){ ?>
												<td colspan=4>
													<?php $attach_file = explode(",",$ajio['attach_file']);
													 foreach($attach_file as $mp){ ?>
														<audio controls='' style="background-color:#607F93"> 
														  <source src="<?php echo base_url(); ?>qa_files/qa_ajio/chat/<?php echo $mp; ?>" type="audio/ogg">
														  <source src="<?php echo base_url(); ?>qa_files/qa_ajio/chat/<?php echo $mp; ?>" type="audio/mpeg">
														</audio> </br>
													 <?php } ?>
												</td>
											<?php }else{
													echo '<td colspan=6><b>No Files</b></td>';
											} ?>
										</tr>

									<?php }else if($campaign=="ccsr_voice"){ ?>	
										
										<?php
										if($ajio==0){
											$auditorName = get_username();
											$auditDate = CurrDateMDY();
											$clDate_val='';
										}else{
											if($ajio['entry_by']!=''){
												$auditorName = $ajio['auditor_name'];
											}else{
												$auditorName = $ajio['client_name'];
											}
											$auditDate = mysql2mmddyy($ajio['audit_date']);
											$clDate_val = mysqlDt2mmddyy($ajio['call_date']);
										}
										//onkeydown="return false;"
									?>
									<tr>
										<td>Auditor Name:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control" value="<?php echo $auditorName; ?>" disabled></td>
										<td>Audit Date:<span style="font-size:24px;color:red">*</span></td>
										<td style="width:200px;"><input type="text" class="form-control" value="<?php echo $auditDate; ?>" disabled></td>
										<td style="width:100px">Call Date/Time:<span style="font-size:24px;color:red">*</span></td>
										<td colspan="2"><input type="text" class="form-control" id="call_date_time" name="call_date" value="<?php echo $clDate_val; ?>" disabled></td>
									</tr>
									<tr>
										<td>Champ/Agent Name:<span style="font-size:24px;color:red">*</span></td>
										<td>
											<select class="form-control agentName" id="agent_id" name="data[agent_id]" disabled >
												<?php
												if ($ajio['agent_id']!='') {
													?>
													<option value="<?php echo $ajio['agent_id'] ?>"><?php echo $ajio['fname']." ".$ajio['lname'] ?></option>
													<?php
												}
												?>
												<option value="">-Select-</option>
												<?php foreach($agentName as $row):  ?>
													<option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
												<?php endforeach; ?>
											</select>
										</td>
										<td>Fusion ID:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control" id="fusion_id" value="<?php echo $ajio['fusion_id'] ?>" readonly ></td>
										<td>L1 Supervisor:</td>
										<td colspan="2">
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
										<td>Interaction ID:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control" name="data[call_id]" value="<?php echo $ajio['call_id'] ?>" disabled ></td>
										<td>Call Duration:</td>
										<td><input type="text" class="form-control" id="call_duration" name="data[call_duration]" value="<?php echo $ajio['call_duration'] ?>" disabled ></td>
										<td>Type of Audit:<span style="font-size:24px;color:red">*</span></td>
										<td>
											<select class="form-control" name="data[type_of_audit]" disabled>
												<?php 
												if($ajio['type_of_audit']!=''){
													?>
													<option value="<?php echo $ajio['type_of_audit'] ?>"><?php echo $ajio['type_of_audit'] ?></option>
													<?php
												}
												?>
												<option value="">-Select-</option>
												<option value="GB Audit">GB Audit</option>
												<option value="High AHT Audit">High AHT Audit</option>
												<option value="Random Audit">Random Audit</option>
												<option value="A2A">A2A</option>
												<option value="Calibration">Calibration</option>
											</select>
										</td>
										<td>VOC:<span style="font-size:24px;color:red">*</span></td>
										<td colspan="2">
											<select class="form-control" id="voc" name="data[voc]" disabled>
												<?php
												if($ajio['voc']!=''){
													?>
													<option value="<?php echo $ajio['voc'] ?>"><?php echo $ajio['voc'] ?></option>
													<?php
												}
												 ?> 
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
									 <tr>
										<td>Predactive CSAT:<span style="font-size:24px;color:red">*</span></td>
										<td>
											<select class="form-control" id="audit_type" name="data[audit_type]" disabled>
												<?php 
												if($ajio['audit_type']!=''){
													?>
													<option value="<?php echo $ajio['audit_type'] ?>"><?php echo $ajio['audit_type'] ?></option>
													<?php
												}
												?>
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
											<select class="form-control" id="auditor_type" name="data[auditor_type]" disabled>
												<option value="">-Select-</option>
												<option value="Master">Master</option>
												<option value="Regular">Regular</option>
											</select>
										</td>
								
									</tr>
								
									<tr>
										<td style="font-weight:bold; font-size:16px; text-align:right">Earned Score:</td>
										<td><input type="text" readonly id="earnedScore" name="data[earned_score]" class="form-control" style="font-weight:bold" value="<?php echo $ajio['earned_score'] ?>"></td>
										<td style="font-weight:bold; font-size:16px; text-align:right">Possible Score:</td>
										<td><input type="text" readonly id="possibleScore" name="data[possible_score]" class="form-control" style="font-weight:bold" value="<?php echo $ajio['possible_score'] ?>"></td>
										<td style="font-weight:bold; font-size:16px; text-align:right">Overall Score:</td>
										<td colspan="2"><input type="text" readonly id="overallScore" name="data[overall_score]" class="form-control ajio_ccsrvoice_Fatal" style="font-weight:bold" value="<?php echo $ajio['overall_score'] ?>"></td>
									</tr>
									<tr style="font-weight:bold">
										<td><input type="hidden" class="form-control" id="prefatal" name="data[pre_fatal_score]" value="<?php echo $ajio['pre_fatal_score'] ?>"></td>
										<td><input type="hidden" class="form-control" id="fatalcount" name="data[fatal_count]" value="<?php echo $ajio['fatal_count'] ?>"></td>
									</tr>
									<tr style="background-color:#85C1E9; font-weight:bold">
										<td>Parameter</td>
										<td colspan=2>Sub Parameter</td>
										<td>Defect</td>
										<td>Weightage</td>
										<td>L1 Reason</td>
										<td>Remarks</td>
									</tr>
									<tr>
										<td rowspan=3 style="background-color:#85C1E9; font-weight:bold">Call Quality & Ettiquettes</td>
										<td colspan=2>Did the champ follow the OB call script and introduce himself properly.</td>
										<td>
											<select class="form-control ajio" id="appropriate_acknowledgements_ccsrvoice" name="data[appropriate_acknowledgements]" disabled>
												<option ajio_val=10 ajio_max=10 <?php echo $ajio['appropriate_acknowledgements'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ajio_val=0 ajio_max=10 <?php echo $ajio['appropriate_acknowledgements'] == "No"?"selected":"";?> value="No">No</option>
											</select>
										</td>
										<td>10</td>
										<td>
											<!-- <textarea class="form-control" name="data[l1_reason1]"><?php //echo $ajio['l1_reason1'] ?></textarea> -->
											<select class="form-control" id="appropriate_ccsrvoice" name="data[l1_reason1]" disabled>
												<?php 
												if($ajio['l1_reason1']!=''){
													?>
													<option value="<?php echo $ajio['l1_reason1'] ?>"><?php echo $ajio['l1_reason1'] ?></option>
													<?php
												}
												?>
												<option  <?php echo $ajio['l1_reason1'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
												
											</select>
										</td>
										<td><textarea class="form-control" name="data[cmt1]" disabled><?php echo $ajio['cmt1'] ?></textarea></td>
									</tr>
									<tr>
										<td colspan=2 style="color:red">Champ followed the 3 strike rule of customer contact</td>
										<td>
											
											<select class="form-control ajio fatal ajioAF1" id="ajioAF1_ccsrvoice" name="data[font_size_formatting]" disabled>
												<option ajio_val=10 ajio_max=10 <?php echo $ajio['font_size_formatting'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ajio_val=0 ajio_max=10 <?php echo $ajio['font_size_formatting'] == "Autofail"?"selected":"";?> value="Autofail">Autofail</option>
											</select>
										</td>
										<td>10</td>
										<td>
											<!-- <textarea class="form-control" name="data[l1_reason2]"><?php echo $ajio['l1_reason3'] ?></textarea> -->
											<select class="form-control" id="font_size_ccsrvoice" name="data[l1_reason2]" disabled>
												<?php 
												if($ajio['l1_reason3']!=''){
													?>
													<option value="<?php echo $ajio['l1_reason3'] ?>"><?php echo $ajio['l1_reason3'] ?></option>
													<?php
												}
												?>
												<option  <?php echo $ajio['l1_reason3'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td><textarea class="form-control" name="data[cmt3]" disabled><?php echo $ajio['cmt3'] ?></textarea></td>
									</tr>
									<tr>
										<td colspan=2 style="color:red">Did the champ offer further assistance and follow appropriate call closure.</td>
										<td>
										<select class="form-control ajio fatal ajioAF6" id="use_appropriate_template_ccsrvoice" name="data[use_appropriate_template]" disabled>
												<option ajio_val=5 ajio_max=5 <?php echo $ajio['use_appropriate_template'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ajio_val=0 ajio_max=5 <?php echo $ajio['use_appropriate_template'] == "No"?"selected":"";?> value="No">No</option>
											</select>
										</td>
										<td>5</td>
										<td>
											<!-- <textarea class="form-control" name="data[l1_reason3]"><?php //echo $ajio['l1_reason3'] ?></textarea> -->
											<select class="form-control" id="ccsrvoice_res" name="data[l1_reason4]" disabled>
												<?php 
												if($ajio['l1_reason4']!=''){
													?>
													<option value="<?php //echo $ajio['audit_type'] ?>"><?php echo $ajio['l1_reason4'] ?></option>
													<?php
												}
												?>
												<option  <?php echo $ajio['l1_reason4'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>	
										</td>
										<td><textarea class="form-control" name="data[cmt4]" disabled><?php echo $ajio['cmt4'] ?></textarea></td>
									</tr>
									<tr>
									<td rowspan=4 style="background-color:#85C1E9; font-weight:bold">Communication Skills</td>
										<td colspan=2 >Was the champ polite and used apology and assurance wherever disabled</td>
										<td>
										<select class="form-control ajio" id="seamlessly_ccsrvoice" name="data[seamlessly]" disabled>
												<option ajio_val=10 ajio_max=10 <?php echo $ajio['seamlessly'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ajio_val=0 ajio_max=10 <?php echo $ajio['seamlessly'] == "No"?"selected":"";?> value="No">No</option>
											</select>
										</td>
										<td>10</td>
										<td>
											<!-- <textarea class="form-control" name="data[l1_reason4]"><?php //echo $ajio['l1_reason4'] ?></textarea> -->
											<select class="form-control" id="seam_ccsrvoice" name="data[l1_reason5]" disabled>
												<?php 
												if($ajio['l1_reason5']!=''){
													?>
													<option value="<?php //echo $ajio['audit_type'] ?>"><?php echo $ajio['l1_reason5'] ?></option>
													<?php
												}
												?>
												<option  <?php echo $ajio['l1_reason5'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>	
										</td>
										<td><textarea class="form-control" name="data[cmt5]" disabled><?php echo $ajio['cmt5'] ?></textarea></td>
									</tr>
									<tr>
										<td colspan=2>Was the champ able to comprehend and articulate the resolution to the customer in a manner which was easily understood by the customer.</td>
										<td>
											<select class="form-control ajio" id="written_communication_ccsrvoice" name="data[written_communication]" disabled>
												<option ajio_val=10 ajio_max=10 <?php echo $ajio['written_communication'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ajio_val=0 ajio_max=10 <?php echo $ajio['written_communication'] == "No"?"selected":"";?> value="No">No</option>
											</select>
										</td>
										<td>10</td>
										<td>
											<!-- <textarea class="form-control" name="data[l1_reason5]"><?php //echo $ajio['l1_reason5'] ?></textarea> -->
											<select class="form-control" id="written_comm_ccsrvoice" name="data[l1_reason6]" disabled>
												<?php 
												if($ajio['l1_reason6']!=''){
													?>
													<option value="<?php //echo $ajio['audit_type'] ?>"><?php echo $ajio['l1_reason6'] ?></option>
													<?php
												}
												?>
												<option  <?php echo $ajio['l1_reason6'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>	

										</td>
										<td><textarea class="form-control" name="data[cmt6]" disabled><?php echo $ajio['cmt6'] ?></textarea></td>
									</tr>
									<tr>
										<td colspan=2 >Did the champ display active listening skills without making the customer repeat </td>
										<td>
										<select class="form-control ajio" id="listening_skills_ccsrvoice" name="data[listening_skills]" disabled>
												<option ajio_val=5 ajio_max=5 <?php echo $ajio['listening_skills'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ajio_val=0 ajio_max=5 <?php echo $ajio['listening_skills'] == "No"?"selected":"";?> value="No">No</option>
											</select>
										</td>
										<td>5</td>
										<!-- <td>
											<select class="form-control" id="skills_ccsrvoice" name="data[l1_reason7]" disabled>
											<?php 
												if($ajio['l1_reason7']!=''){
													?>
													<option value="<?php //echo $ajio_ccsr_voice['audit_type'] ?>"><?php echo $ajio['l1_reason7'] ?></option>
													<?php
												}
												?>
												<option  <?php echo $ajio['l1_reason7'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td> -->
										<td><input type="text" class="form-control" name="data[l1_reason7]" value="<?php echo $ajio['l1_reason7']?>"></td>
										
										<td><textarea class="form-control" name="data[cmt7]" disabled><?php echo $ajio['cmt7'] ?></textarea></td>
									</tr>
									<tr>
										<td colspan=2>Was the champ able to handle objections effectively and offer rebuttals wherever disabled. (Especially in case of where the resolution is not in customer's favour)</td>
										<td>
											<select class="form-control ajio" id="communication_ccsrvoice" name="data[communication]" disabled>
												<option ajio_val=10 ajio_max=10 <?php echo $ajio['communication'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ajio_val=0 ajio_max=10 <?php echo $ajio['communication'] == "No"?"selected":"";?> value="No">No</option>
											</select>
										</td>
										<td>10</td>
										<td>
											<!-- <textarea class="form-control" name="data[l1_reason7]"><?php //echo $ajio['l1_reason7'] ?></textarea> -->
											<select class="form-control" id="commun_ccsrvoice" name="data[l1_reason8]" disabled>
												<?php 
												if($ajio['l1_reason8']!=''){
													?>
													<option value="<?php //echo $ajio['audit_type'] ?>"><?php echo $ajio['l1_reason8'] ?></option>
													<?php
												}
												?>
												<option  <?php echo $ajio['l1_reason8'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td><textarea class="form-control" name="data[cmt8]" disabled><?php echo $ajio['cmt8'] ?></textarea></td>
									</tr>
								
									<tr>
									<td rowspan=3 style="background-color:#85C1E9; font-weight:bold">Effective System Navigation & KM Usage</td>
										<td colspan=2 >Did the champ refer to different applications/portals/tools/SOP to identify the root cause of customer issue and enable resolution.</td>
										<td>
											<select class="form-control ajio" id="releavnt_articles_ccsrvoice" name="data[releavnt_articles]" disabled>
												<option ajio_val=5 ajio_max=5 <?php echo $ajio['releavnt_articles'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ajio_val=0 ajio_max=5 <?php echo $ajio['releavnt_articles'] == "No"?"selected":"";?> value="No">No</option>
												<!-- <option ajio_val=0 ajio_max=0 <?php //echo $ajio['all_relevant_articles'] == "N/A"?"selected":"";?> value="N/A">N/A</option> -->
											</select>
										</td>
										<td>5</td>
										<td>
											<!-- <textarea class="form-control" name="data[l1_reason7]"><?php //echo $ajio['l1_reason7'] ?></textarea> -->
											<select class="form-control" id="articles_ccsrvoice" name="data[l1_reason9]" disabled>
												<?php 
												if($ajio['l1_reason9']!=''){
													?>
													<option value="<?php //echo $ajio['audit_type'] ?>"><?php echo $ajio['l1_reason9'] ?></option>
													<?php
												}
												?>
												<option  <?php echo $ajio['l1_reason9'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td><textarea class="form-control" name="data[cmt9]" disabled><?php echo $ajio['cmt9'] ?></textarea></td>
									</tr>
									<tr>
										<td colspan=2 >Did the champ check the previous complaint history. (repeat complaint, resolution provided on previous complaint. Reason of reopen) and took action accordingly.</td>
										<td>
											<select class="form-control ajio" id="handle_objections_ccsrvoice" name="data[handle_objections]" disabled>
												<option ajio_val=10 ajio_max=10 <?php echo $ajio['handle_objections'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ajio_val=0 ajio_max=10 <?php echo $ajio['handle_objections'] == "No"?"selected":"";?> value="No">No</option>
											</select>
										</td>
										<td>10</td>
										<td>
											<!-- <textarea class="form-control" name="data[l1_reason7]"><?php //echo $ajio['l1_reason7'] ?></textarea> -->
											<select class="form-control" id="handle_obj_ccsrvoice" name="data[l1_reason10]" disabled>
												<?php 
												if($ajio['l1_reason10']!=''){
													?>
													<option value="<?php //echo $ajio['audit_type'] ?>"><?php echo $ajio['l1_reason10'] ?></option>
													<?php
												}
												?>
												<option  <?php echo $ajio['l1_reason10'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td><textarea class="form-control" name="data[cmt10]" disabled><?php echo $ajio['cmt10'] ?></textarea></td>
									</tr>
									<tr>
									
										<td colspan=2 style="color:red">Did the champ correctly redirect/reassign/reopen the complaint wherever disabled. Includes when the resolution provided by stakeholder is not valid</td>
										<td>
											<select class="form-control ajio fatal ajioAF2" id="ajioAF2_ccsrvoice" name="data[relevant_previous_interactions]" disabled>
												<option ajio_val=5 ajio_max=5 <?php echo $ajio['relevant_previous_interactions'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ajio_val=0 ajio_max=5 <?php echo $ajio['relevant_previous_interactions'] == "Autofail"?"selected":"";?> value="Autofail">Autofail</option>
											</select>
										</td>
										<td>5</td>
										<td>
											<!-- <textarea class="form-control" name="data[l1_reason8]"><?php //echo $ajio['l1_reason8'] ?></textarea> -->
											<select class="form-control" id="ajio_ccsrvoice" name="data[l1_reason11]" disabled>
												<?php 
												if($ajio['l1_reason11']!=''){
													?>
													<option value="<?php //echo $ajio['audit_type'] ?>"><?php echo $ajio['l1_reason11'] ?></option>
													<?php
												}
												?>
												<option  <?php echo $ajio['l1_reason11'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td><textarea class="form-control" name="data[cmt11]" disabled><?php echo $ajio['cmt11'] ?></textarea></td>
									</tr>
									<tr>
									<td rowspan=3 style="background-color:#85C1E9; font-weight:bold">Issue Resolution</td>
										<td colspan=2>Any other underlying issue on the account was also addressed proactively.</td>
										<td>
											<select class="form-control ajio" id="applications_portals_ccsrvoice" name="data[applications_portals]" disabled>
												<option ajio_val=10 ajio_max=10 <?php echo $ajio['applications_portals'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ajio_val=0 ajio_max=10 <?php echo $ajio['applications_portals'] == "No"?"selected":"";?> value="No">No</option>
											</select>
										</td>
										<td>10</td>
										<td>
											<!-- <textarea class="form-control" name="data[l1_reason9]"><?php //echo $ajio['l1_reason9'] ?></textarea> -->
											<select class="form-control" id="applications_ccsrvoice" name="data[l1_reason12]" disabled>
												<?php 
												if($ajio['l1_reason12']!=''){
													?>
													<option value="<?php //echo $ajio['audit_type'] ?>"><?php echo $ajio['l1_reason12'] ?></option>
													<?php
												}
												?>
												<option  <?php echo $ajio['l1_reason12'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td><textarea class="form-control" name="data[cmt12]" disabled><?php echo $ajio['cmt12'] ?></textarea></td>
									</tr>
									
									<tr>
										
										<td colspan=2 style="color:red">All the queries were answered properly and in an informative way to avoid repeat call. Champ provided a clear understanding of action taken and the way forward to the customer. (Any Information needed from Cx, Follow up action reuired by customer. Taking confirmation of the understanding of resolution)</td>
										<td>
											<select class="form-control ajio fatal ajioAF3" id="ajio_ccsrvoiceAF3" name="data[ensure_issue_resolution]" disabled>
												<option ajio_val=5 ajio_max=5 <?php echo $ajio['ensure_issue_resolution'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ajio_val=0 ajio_max=5 <?php echo $ajio['ensure_issue_resolution'] == "Autofail"?"selected":"";?> value="Autofail">Autofail</option>
											</select>
										</td>
										<td>5</td>
										<td>
											<!-- <textarea class="form-control" name="data[l1_reason10]"><?php //echo $ajio['l1_reason10'] ?></textarea> -->
											<select class="form-control" id="issue_ccsrvoice" name="data[l1_reason13]" disabled>
												<?php 
												if($ajio['l1_reason13']!=''){
													?>
													<option value="<?php //echo $ajio['audit_type'] ?>"><?php echo $ajio['l1_reason13'] ?></option>
													<?php
												}
												?>
												<option  <?php echo $ajio['l1_reason13'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td><textarea class="form-control" name="data[cmt13]" disabled><?php echo $ajio['cmt13'] ?></textarea></td>
									</tr>
									<tr>
										
										<td colspan=2 style="color:red">Did the champ document the case correctly and adhered to tagging guidelines. Includes closing the complaint appropriately by selecting the correct ICR reason</td>
										<td>
											<select class="form-control ajio fatal ajioAF4" id="ajio_ccsrvoiceAF4" name="data[tagging_guidelines]" disabled>
												<option ajio_val=5 ajio_max=5 <?php echo $ajio['tagging_guidelines'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ajio_val=0 ajio_max=5 <?php echo $ajio['tagging_guidelines'] == "Autofail"?"selected":"";?> value="Autofail">Autofail</option>
												<option ajio_val=0 ajio_max=5 <?php echo $ajio['tagging_guidelines'] == "No"?"selected":"";?> value="No">No</option>
											</select>
										</td>
										<td>5</td>
										<td>
											<!-- <textarea class="form-control" name="data[l1_reason10]"><?php //echo $ajio['l1_reason10'] ?></textarea> -->
											<select class="form-control" id="tagg_ccsrvoice" name="data[l1_reason13]" disabled>
												<?php 
												if($ajio['l1_reason13']!=''){
													?>
													<option value="<?php //echo $ajio['audit_type'] ?>"><?php echo $ajio['l1_reason13'] ?></option>
													<?php
												}
												?>
												<option  <?php echo $ajio['l1_reason13'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td><textarea class="form-control" name="data[cmt13]" disabled><?php echo $ajio['cmt13'] ?></textarea></td>
									</tr>
									
									<tr>
										<td style="background-color:#F1948A; font-weight:bold">ZTP</td>
										<td colspan=2 style="color:red">As per AJIO ZTP guidelines</td>
										<td>
											<select class="form-control ajio fatal ajioAF5" id="ajio_ccsrvoiceAF6" name="data[ztp_guidelines]" disabled>
												<option ajio_val=0 ajio_max=0 <?php echo $ajio['ztp_guidelines'] == "No"?"selected":"";?> value="No">No</option>
												<option ajio_val=0 ajio_max=0 <?php echo $ajio['ztp_guidelines'] == "Autofail"?"selected":"";?> value="Autofail">Autofail</option>
											</select>
										</td>
										<td>0</td>
										<!-- <td>
											<select class="form-control" id="ztp_guide_ccsrvoice" name="data[l1_reason14]" disabled>
											<?php 
												if($ajio['l1_reason14']!=''){
													?>
													<option value="<?php echo $ajio['l1_reason15'] ?>"><?php echo $ajio['l1_reason15'] ?></option>
													<?php
												}
												?>
												<option  <?php echo $ajio['l1_reason14'] == "......."?"selected":"";?> value=".......">.....</option>
												
											</select>	
										</td> -->
										<td><input type="text" class="form-control" name="data[l1_reason14]" value="<?php echo $ajio['l1_reason14']?>"></td>

										<td><textarea class="form-control" name="data[cmt14]" disabled><?php echo $ajio['cmt14'] ?></textarea></td>
									</tr>
									<tr>
										<td>Call Synopsis:</td>
										<td colspan="7"><textarea class="form-control" name="data[call_synopsis]"><?php echo $ajio['call_synopsis'] ?></textarea></td>
									</tr>
									<tr>
										<td>Call Observation:</td>
										<td colspan=2><textarea class="form-control" name="data[call_summary]" disabled><?php echo $ajio['call_summary'] ?></textarea></td>
										<td>Feedback:</td>
										<td colspan="4"><textarea class="form-control" name="data[feedback]" disabled><?php echo $ajio['feedback'] ?></textarea></td>
									</tr>
									<tr>
										<td colspan=2>Upload Files</td>
										<?php if($ajio==0){ ?>
											<td colspan="5"><input type="file" multiple class="form-control" id="attach_file" name="attach_file[]" style="padding: 10px 10px 10px 10px;"></td>
										<?php }else{
											if($ajio['attach_file']!=''){ ?>
												<td colspan=4>
													<?php $attach_file = explode(",",$ajio['attach_file']);
													 foreach($attach_file as $mp){ ?>
														<audio controls='' style="background-color:#607F93"> 
														  <source src="<?php echo base_url(); ?>qa_files/qa_ajio/ccsr/<?php echo $mp; ?>" type="audio/ogg">
														  <source src="<?php echo base_url(); ?>qa_files/qa_ajio/ccsr/<?php echo $mp; ?>" type="audio/mpeg">
														</audio> </br>
													 <?php } ?>
												</td>
										<?php }else{
												echo '<td colspan=6><b>No Files</b></td>';
											  }
										} ?>
									</tr>

									<?php }else if($campaign=="ccsr_nonvoice"){ ?>	
										
										<?php
										if($ajio==0){
											$auditorName = get_username();
											$auditDate = CurrDateMDY();
											$clDate_val='';
										}else{
											if($ajio['entry_by']!=''){
												$auditorName = $ajio['auditor_name'];
											}else{
												$auditorName = $ajio['client_name'];
											}
											$auditDate = mysql2mmddyy($ajio['audit_date']);
											$clDate_val = mysqlDt2mmddyy($ajio['call_date']);
										}
										//onkeydown="return false;"
									?>
									<tr>
										<td>Auditor Name:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control" value="<?php echo $auditorName; ?>" disabled></td>
										<td>Audit Date:<span style="font-size:24px;color:red">*</span></td>
										<td style="width:200px;"><input type="text" class="form-control" value="<?php echo $auditDate; ?>" disabled></td>
										<td style="width:100px">Call Date/Time:<span style="font-size:24px;color:red">*</span></td>
										<td colspan="2"><input type="text" class="form-control" id="call_date_time" name="call_date" value="<?php echo $clDate_val; ?>" disabled></td>
									</tr>
									<tr>
										<td>Champ/Agent Name:<span style="font-size:24px;color:red">*</span></td>
										<td>
											<select class="form-control" id="agent_id" name="data[agent_id]" disabled >
												<?php
												if ($ajio['agent_id']!='') {
													?>
													<option value="<?php echo $ajio['agent_id'] ?>"><?php echo $ajio['fname']." ".$ajio['lname'] ?></option>
													<?php
												}
												?>
												<option value="">-Select-</option>
												<?php foreach($agentName as $row):  ?>
													<option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
												<?php endforeach; ?>
											</select>
										</td>
										<td>Fusion ID:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control" id="fusion_id" value="<?php echo $ajio['fusion_id'] ?>" readonly ></td>
										<td>L1 Supervisor:</td>
										<td colspan="2">
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
										<td>Interaction ID:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control" name="data[call_id]" value="<?php echo $ajio['call_id'] ?>" disabled ></td>
										<td>Type of Audit:<span style="font-size:24px;color:red">*</span></td>
										<td>
											<select class="form-control" name="data[type_of_audit]" disabled>
												<?php 
												if($ajio['type_of_audit']!=''){
													?>
													<option value="<?php echo $ajio['type_of_audit'] ?>"><?php echo $ajio['type_of_audit'] ?></option>
													<?php
												}
												?>
												<option value="">-Select-</option>
												<option value="GB Audit">GB Audit</option>
												<option value="High AHT Audit">High AHT Audit</option>
												<option value="Random Audit">Random Audit</option>
												<option value="A2A">A2A</option>
												<option value="Calibration">Calibration</option>
											</select>
										</td>
										<td>VOC:<span style="font-size:24px;color:red">*</span></td>
										<td colspan="2">
											<select class="form-control" id="voc" name="data[voc]" disabled>
												<?php
												if($ajio['voc']!=''){
													?>
													<option value="<?php echo $ajio['voc'] ?>"><?php echo $ajio['voc'] ?></option>
													<?php
												}
												 ?> 
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
									<tr>
										<td>Order Id:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control" name="data[order_id]" value="<?php echo $ajio['order_id']; ?>" disabled>
										</td>
										<td>Ticket Id:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control" name="data[ticket_id]" value="<?php echo $ajio['ticket_id']; ?>" disabled>
										</td>
										<td>Partner:<span style="font-size:24px;color:red">*</span></td>
										<td colspan="2"><input type="text" class="form-control" name="data[partner]" value="<?php echo $ajio['partner']; ?>" disabled>
										</td>
									</tr>
									 <tr>
										<td>Predactive CSAT:<span style="font-size:24px;color:red">*</span></td>
										<td>
											<select class="form-control" id="audit_type" name="data[audit_type]" disabled>
												<?php 
												if($ajio['audit_type']!=''){
													?>
													<option value="<?php echo $ajio['audit_type'] ?>"><?php echo $ajio['audit_type'] ?></option>
													<?php
												}
												?>
												<option value="">-Select-</option>
												<option value="CQ Audit">CQ Audit</option>
												<option value="BQ Audit">BQ Audit</option>
												<option value="Calibration">Calibration</option>
												<option value="Pre-Certificate Mock Call">Pre-Certificate Mock Call</option>
												<option value="Certification Audit">Certification Audit</option>
												<option value="Operation Audit">Operation Audit</option>
												<option value="Trainer Audit">Trainer Audit</option>
												<option value="Hygiene Audit">Hygiene Audit</option>
												<option value="WoW Call">WoW Call</option>
											</select>
										</td>
										<td class="auType">Auditor Type</td>
										<td class="auType">
											<select class="form-control" id="auditor_type" name="data[auditor_type]" disabled>
												<option value="">-Select-</option>
												<option value="Master">Master</option>
												<option value="Regular">Regular</option>
											</select>
										</td>
								
									</tr>
									<tr>
									<td>Ticket Type:<span style="font-size:24px;color:red">*</span></td>
										<td>
											<select class="form-control" id="ticket_type" name="data[ticket_type]" disabled>
												<option value="">-Select-</option>
												<option <?php echo $ajio['ticket_type']=='Complaint'?"selected":""; ?> value="Complaint">Complaint</option>
												<option <?php echo $ajio['ticket_type']=='Query'?"selected":""; ?> value="Query">Query</option>
												<option <?php echo $ajio['ticket_type']=='Proactive SR'?"selected":""; ?> value="Proactive SR">Proactive SR</option>
											</select>
										</td>
									<td>Tagging By Evaluator:<span style="font-size:24px;color:red">*</span></td>
										<td colspan="2">
											<select class="form-control" id="tagging_evaluator" name="data[tagging_evaluator]" disabled>
												<option value="">-Select-</option>
												<option <?php echo $ajio['tagging_evaluator']=='Delivery-Fake Attempt-N/A'?"selected":""; ?> value="Delivery-Fake Attempt-N/A">Delivery-Fake Attempt-N/A</option>
												<option <?php echo $ajio['tagging_evaluator']=='Account-Store Credit Debited Order Not Processed-N/A'?"selected":""; ?> value="Account-Store Credit Debited Order Not Processed-N/A">Account-Store Credit Debited Order Not Processed-N/A</option>
												<option <?php echo $ajio['tagging_evaluator']=='Account-Store Credit Discrepancy-Others'?"selected":""; ?> value="Account-Store Credit Discrepancy-Others">Account-Store Credit Discrepancy-Others</option>
												<option <?php echo $ajio['tagging_evaluator']=='Account-Customer information Leak-N/A'?"selected":""; ?> value="Account-Customer information Leak-N/A">Account-Customer information Leak-N/A</option>
												<option <?php echo $ajio['tagging_evaluator']=='Callback-Others-N/A'?"selected":""; ?> value="Callback-Others-N/A">Callback-Others-N/A</option>
												<option value="Delivery-Snatch Case-N/A"  <?= ($ajio['audit_type']=="Delivery-Snatch Case-N/A")?"selected":"" ?>>Delivery-Snatch Case-N/A</option>
                                                <option value="Delivery-Order not dispatched from Warehouse-N/A"  <?= ($ajio['tagging_evaluator']=="Delivery-Order not dispatched from Warehouse-N/A")?"selected":"" ?>>Delivery-Order not dispatched from Warehouse-N/A</option>
                                                <option value="Delivery-Delayed Delivery-N/A"  <?= ($ajio['tagging_evaluator']=="Delivery-Delayed Delivery-N/A")?"selected":"" ?>>Delivery-Delayed Delivery-N/A</option>
											</select>
										</td>		
									</tr>
								
									<tr>
										<td style="font-weight:bold; font-size:16px; text-align:right">Earned Score:</td>
										<td><input type="text" readonly id="earnedScore" name="data[earned_score]" class="form-control" style="font-weight:bold" value="<?php echo $ajio['earned_score'] ?>"></td>
										<td style="font-weight:bold; font-size:16px; text-align:right">Possible Score:</td>
										<td><input type="text" readonly id="possibleScore" name="data[possible_score]" class="form-control" style="font-weight:bold" value="<?php echo $ajio['possible_score'] ?>"></td>
										<td style="font-weight:bold; font-size:16px; text-align:right">Overall Score:</td>
										<td colspan="2"><input type="text" readonly id="overallScore" name="data[overall_score]" class="form-control ajio_Fatal" style="font-weight:bold" value="<?php echo $ajio['overall_score'] ?>"></td>
									</tr>
									<tr style="font-weight:bold">
										<td><input type="hidden" class="form-control" id="prefatal" name="data[pre_fatal_score]" value="<?php echo $ajio['pre_fatal_score'] ?>"></td>
										<td><input type="hidden" class="form-control" id="fatalcount" name="data[fatal_count]" value="<?php echo $ajio['fatal_count'] ?>"></td>
									</tr>
									<tr style="background-color:#85C1E9; font-weight:bold">
										<td>Parameter</td>
										<td colspan=2>Sub Parameter</td>
										<td>Defect</td>
										<td>Weightage</td>
										<td>L1 Reason</td>
										<td>Remarks</td>
									</tr>

									<tr>
										<td rowspan=7 style="background-color:#85C1E9; font-weight:bold">Comprehension & Email Ettiquettes</td>
										<td colspan=2>Did the champ use appropriate acknowledgements, re-assurance and apology wherever required</td>
										<td>
											<select class="form-control ajio" id="appropriate_acknowledgements_ccsrnonvoice" name="data[appropriate_acknowledgements]" disabled>
												<option ajio_val=10 ajio_max=10 <?php echo $ajio['appropriate_acknowledgements'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ajio_val=0 ajio_max=10 <?php echo $ajio['appropriate_acknowledgements'] == "No"?"selected":"";?> value="No">No</option>
											</select>
										</td>
										<td>10</td>
										<td>
											<!-- <textarea class="form-control" name="data[l1_reason1]"><?php //echo $ajio['l1_reason1'] ?></textarea> -->
											<select class="form-control" id="appropriat_ccsrnonvoice" name="data[l1_reason1]" disabled>
												<?php 
												if($ajio['l1_reason1']!=''){
													?>
													<option value="<?php echo $ajio['l1_reason1'] ?>"><?php echo $ajio['l1_reason1'] ?></option>
													<?php
												}
												?>
												<option  <?php echo $ajio['l1_reason1'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
												
											</select>
										</td>
										<td><textarea class="form-control" disabled name="data[cmt1]"><?php echo $ajio['cmt1'] ?></textarea></td>
									</tr>
									<tr>
										<td colspan=2>Did the champ use font, font size, and formatting  as per AJIO's brand guidelines</td>
										<td>
											<select class="form-control ajio" id="font_size_formatting_cccsrnonvoice" name="data[font_size_formatting]" disabled>
												<option ajio_val=5 ajio_max=5 <?php echo $ajio['font_size_formatting'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ajio_val=0 ajio_max=5 <?php echo $ajio['font_size_formatting'] == "No"?"selected":"";?> value="No">No</option>
											</select>
										</td>
										<td>5</td>
										<td>
											<!-- <textarea class="form-control" name="data[l1_reason2]"><?php echo $ajio['l1_reason2'] ?></textarea> -->
											<select class="form-control" id="font_size_cccsrnonvoice" name="data[l1_reason2]" disabled>
												<?php 
												if($ajio['l1_reason2']!=''){
													?>
													<option value="<?php echo $ajio['l1_reason2'] ?>"><?php echo $ajio['l1_reason2'] ?></option>
													<?php
												}
												?>
												<option  <?php echo $ajio['l1_reason2'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td><textarea class="form-control" disabled name="data[cmt2]"><?php echo $ajio['cmt2'] ?></textarea></td>
									</tr>
									<tr>
										<td colspan=2>Was the email response in line with AJIO's approved template/format </td>
										<td>
											<select class="form-control ajio" id="approved_template_ccsrnonvoice" name="data[approved_template]" disabled>
												<option ajio_val=5 ajio_max=5 <?php echo $ajio['approved_template'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ajio_val=0 ajio_max=5 <?php echo $ajio['approved_template'] == "No"?"selected":"";?> value="No">No</option>
											</select>
										</td>
										<td>5</td>
										<td>
											<!-- <textarea class="form-control" name="data[l1_reason3]"><?php //echo $ajio['l1_reason3'] ?></textarea> -->
											<select class="form-control" id="approved_ccsrnonvoice" name="data[l1_reason3]" disabled>
												<?php 
												if($ajio['l1_reason3']!=''){
													?>
													<option value="<?php //echo $ajio['audit_type'] ?>"><?php echo $ajio['l1_reason3'] ?></option>
													<?php
												}
												?>
												<option  <?php echo $ajio['l1_reason3'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>	
										</td>
										<td><textarea class="form-control" disabled name="data[cmt3]"><?php echo $ajio['cmt3'] ?></textarea></td>
									</tr>
									<tr>
										<td colspan=2 >Was the champ able to comprehend and articulate the resolution to the customer in a manner which was easily understood by the customer.</td>
										<td>
										<select class="form-control ajio" id="seamlessly_ccsrnonvoice" name="data[seamlessly]" disabled>
												<option ajio_val=10 ajio_max=10 <?php echo $ajio['seamlessly'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ajio_val=0 ajio_max=10 <?php echo $ajio['seamlessly'] == "No"?"selected":"";?> value="No">No</option>
											</select>
										</td>
										<td>10</td>
										<td>
											<!-- <textarea class="form-control" name="data[l1_reason4]"><?php //echo $ajio['l1_reason4'] ?></textarea> -->
											<select class="form-control" id="seam_ccsrnonvoice" name="data[l1_reason4]" disabled>
												<?php 
												if($ajio['l1_reason4']!=''){
													?>
													<option value="<?php //echo $ajio['audit_type'] ?>"><?php echo $ajio['l1_reason4'] ?></option>
													<?php
												}
												?>
												<option  <?php echo $ajio['l1_reason4'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>	
										</td>
										<td><textarea class="form-control" disabled name="data[cmt4]"><?php echo $ajio['cmt4'] ?></textarea></td>
									</tr>

									<tr>
										<td colspan=2 style="color:red">Did the champ refer to all relevant previous interactions when disabled to gather information about customer's account and issue end to end</td>
										<td>
											<select class="form-control ajio fatal ajioAF7" id="ajioAF7_ccsrnonvoice" name="data[gather_information]" disabled>
												<option ajio_val=10 ajio_max=10 <?php echo $ajio['gather_information'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ajio_val=0 ajio_max=10 <?php echo $ajio['gather_information'] == "Autofail"?"selected":"";?> value="Autofail">Autofail</option>
											</select>
										</td>
										<td>10</td>
										<td>
											<!-- <textarea class="form-control" name="data[l1_reason5]"><?php //echo $ajio['l1_reason5'] ?></textarea> -->
											<select class="form-control" id="gather_information_ccsrnonvoice" name="data[l1_reason5]" disabled>
												<?php 
												if($ajio['l1_reason5']!=''){
													?>
													<option value="<?php //echo $ajio['audit_type'] ?>"><?php echo $ajio['l1_reason5'] ?></option>
													<?php
												}
												?>
												<option  <?php echo $ajio['l1_reason5'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>	

										</td>
										<td><textarea class="form-control" disabled name="data[cmt5]"><?php echo $ajio['cmt5'] ?></textarea></td>
									</tr>
									<tr>
										<td colspan=2 style="color:red">Did the champ use appropriate template(s) and customized it to ensure all concerns raised were answered appropriately</td>
										<td>
										<select class="form-control ajio fatal ajioAF1" id="ajioAF1_ccsrnonvoice" name="data[use_appropriate_template]" disabled>
												<option ajio_val=10 ajio_max=10 <?php echo $ajio['use_appropriate_template'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ajio_val=0 ajio_max=10 <?php echo $ajio['use_appropriate_template'] == "Autofail"?"selected":"";?> value="Autofail">Autofail</option>
											</select>
										</td>
										<td>10</td>
										<td>
											<select class="form-control" id="appro_ccsrnonvoice" name="data[l1_reason6]" disabled>
												<?php 
												if($ajio['l1_reason6']!=''){
													?>
													<option value="<?php //echo $ajio['audit_type'] ?>"><?php echo $ajio['l1_reason6'] ?></option>
													<?php
												}
												?>
												<option  <?php echo $ajio['l1_reason6'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td><textarea class="form-control" disabled name="data[cmt6]"><?php echo $ajio['cmt6'] ?></textarea></td>
									</tr>

									<tr>
										<td colspan=2 >Was the champ able to identify and handle objections effectively and offer rebuttals wherever disabled</td>
										<td>
										<select class="form-control ajio" id="offer_rebuttals_ccsrnonvoice" name="data[offer_rebuttals]" disabled>
												<option ajio_val=10 ajio_max=10 <?php echo $ajio['offer_rebuttals'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ajio_val=0 ajio_max=10 <?php echo $ajio['offer_rebuttals'] == "No"?"selected":"";?> value="No">No</option>
											</select>
										</td>
										<td>10</td>
										<td>
											<!-- <textarea class="form-control" name="data[l1_reason4]"><?php //echo $ajio['l1_reason4'] ?></textarea> -->
											<select class="form-control" id="offer_rebu_ccsrnonvoice" name="data[l1_reason15]" disabled>
												<?php 
												if($ajio['l1_reason15']!=''){
													?>
													<option value="<?php //echo $ajio['audit_type'] ?>"><?php echo $ajio['l1_reason15'] ?></option>
													<?php
												}
												?>
												<option  <?php echo $ajio['l1_reason15'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>	
										</td>
										<td><textarea class="form-control" disabled name="data[cmt15]"><?php echo $ajio['cmt15'] ?></textarea></td>
									</tr>
									<tr>
										<td rowspan=4 style="background-color:#85C1E9; font-weight:bold">Effective System Navigation & KM Usage </td>
										<td colspan=2>Did the champ refer to different applications/portals/tools to identify the root cause of customer issue and enable resolution.</td>
										<td>
											<select class="form-control ajio" id="application_portals_ccsrnonvoice" name="data[application_portals]" disabled>
												<option ajio_val=5 ajio_max=5 <?php echo $ajio['application_portals'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ajio_val=0 ajio_max=5 <?php echo $ajio['application_portals'] == "No"?"selected":"";?> value="No">No</option>
											</select>
										</td>
										<td>5</td>
										<td>
											<!-- <textarea class="form-control" name="data[l1_reason7]"><?php //echo $ajio['l1_reason7'] ?></textarea> -->
											<select class="form-control" id="application_port_ccsrnonvoice" name="data[l1_reason7]" disabled>
												<?php 
												if($ajio['l1_reason18']!=''){
													?>
													<option value="<?php //echo $ajio['audit_type'] ?>"><?php echo $ajio['l1_reason18'] ?></option>
													<?php
												}
												?>
												<option  <?php echo $ajio['l1_reason18'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td><textarea class="form-control" disabled name="data[cmt18]"><?php echo $ajio['cmt18'] ?></textarea></td>
									</tr>
								
									<tr>
										<td colspan=2>Did the champ refer to all releavnt articles/T2Rs correctly</td>
										<td>
										<select class="form-control ajio fatal" id="releavnt_ccsrnonvoice" name="data[relevant_previous_interactions]" disabled>
												<option ajio_val=5 ajio_max=5 <?php echo $ajio['relevant_previous_interactions'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ajio_val=0 ajio_max=5 <?php echo $ajio['relevant_previous_interactions'] == "No"?"selected":"";?> value="No">No</option>
											</select>
										</td>
										<td>5</td>
										<td>
											<!-- <textarea class="form-control" name="data[l1_reason7]"><?php //echo $ajio['l1_reason7'] ?></textarea> -->
											<select class="form-control" id="rel_ccsr_nonvoice" name="data[l1_reason8]" disabled>
												<?php 
												if($ajio['l1_reason8']!=''){
													?>
													<option value="<?php //echo $ajio['audit_type'] ?>"><?php echo $ajio['l1_reason8'] ?></option>
													<?php
												}
												?>
												<option  <?php echo $ajio['l1_reason8'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td><textarea class="form-control" disabled name="data[cmt8]"><?php echo $ajio['cmt8'] ?></textarea></td>
									</tr>
									<tr>
										<td colspan=2 style="color:red">Email/Interaction was authenticated wherever disabled</td>
										<td>
											<select class="form-control ajio fatal ajioAF8" id="email_interaction_ccsrnonvoice" name="data[email_interaction]" disabled>
												<option ajio_val=5 ajio_max=5 <?php echo $ajio['email_interaction'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ajio_val=0 ajio_max=5 <?php echo $ajio['email_interaction'] == "Autofail"?"selected":"";?> value="Autofail">Autofail</option>
												<option ajio_val=5 ajio_max=5 <?php echo $ajio['email_interaction'] == "No"?"selected":"";?> value="No">No</option>
											</select>
										</td>
										<td>5</td>
										<td>
											<!-- <textarea class="form-control" name="data[l1_reason7]"><?php //echo $ajio['l1_reason7'] ?></textarea> -->
											<select class="form-control" id="email_interact_ccsrnonvoice" name="data[l1_reason16]" disabled>
												<?php 
												if($ajio['l1_reason16']!=''){
													?>
													<option value="<?php //echo $ajio['audit_type'] ?>"><?php echo $ajio['l1_reason16'] ?></option>
													<?php
												}
												?>
												<option  <?php echo $ajio['l1_reason16'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td><textarea class="form-control" disabled name="data[cmt16]"><?php echo $ajio['cmt16'] ?></textarea></td>
									</tr>
									<tr>
										<td colspan=2>Did the champ take ownership and request for outcall/call back was addressed wherever disabled</td>
										<td>
											<select class="form-control ajio" id="call_back_ccsrnonvoice" name="data[call_back_address]" disabled>
											<option ajio_val=5 ajio_max=5 <?php echo $ajio['call_back_address'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ajio_val=0 ajio_max=5 <?php echo $ajio['call_back_address'] == "Autofail"?"selected":"";?> value="Autofail">Autofail</option>
												<option ajio_val=5 ajio_max=5 <?php echo $ajio['call_back_address'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td>5</td>
										<td>
											<!-- <textarea class="form-control" name="data[l1_reason8]"><?php //echo $ajio['l1_reason8'] ?></textarea> -->
											<select class="form-control" id="call_bac_ccsrnonvoice" name="data[l1_reason17]" disabled>
												<?php 
												if($ajio['l1_reason17']!=''){
													?>
													<option value="<?php //echo $ajio['audit_type'] ?>"><?php echo $ajio['l1_reason17'] ?></option>
													<?php
												}
												?>
												<option  <?php echo $ajio['l1_reason17'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td><textarea class="form-control" disabled name="data[cmt17]"><?php echo $ajio['cmt17'] ?></textarea></td>
									</tr>
									<tr>
									<td rowspan=3 style="background-color:#85C1E9; font-weight:bold">Issue Resolution</td>
										<td colspan=2 style="color:red">Champ executed all necessary actions to ensure issue resolution</td>
										<td>
											<select class="form-control ajio fatal ajioAF3" id="ajio_ccsrnonvoiceAF3" name="data[ensure_issue_resolution]" disabled>
												<option ajio_val=5 ajio_max=5 <?php echo $ajio['ensure_issue_resolution'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ajio_val=0 ajio_max=5 <?php echo $ajio['ensure_issue_resolution'] == "Autofail"?"selected":"";?> value="Autofail">Autofail</option>
											</select>
										</td>
										<td>5</td>
										<td>
											<!-- <textarea class="form-control" name="data[l1_reason10]"><?php //echo $ajio['l1_reason10'] ?></textarea> -->
											<select class="form-control" id="issue_ccsrnonvoice" name="data[l1_reason11]" disabled>
												<?php 
												if($ajio['l1_reason11']!=''){
													?>
													<option value="<?php //echo $ajio['audit_type'] ?>"><?php echo $ajio['l1_reason11'] ?></option>
													<?php
												}
												?>
												<option  <?php echo $ajio['l1_reason11'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td><textarea class="form-control" disabled name="data[cmt11]"><?php echo $ajio['cmt11'] ?></textarea></td>
									</tr>
									<tr>
										<td colspan=2 style="color:red">All the queries were answered properly and in an informative way to avoid repeat call. Champ provided a clear understanding of action taken and the way forward to the customer.</td>
										<td>
											<select class="form-control ajio fatal ajioAF4" id="ajio_ccsrnonvoiceAF4" name="data[avoid_repeat_call]" disabled>
												<option ajio_val=10 ajio_max=10 <?php echo $ajio['avoid_repeat_call'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ajio_val=0 ajio_max=10 <?php echo $ajio['avoid_repeat_call'] == "Autofail"?"selected":"";?> value="Autofail">Autofail</option>
											</select>
										</td>
										<td>10</td>
										<td>
											<!-- <textarea class="form-control" name="data[l1_reason13]"><?php //echo $ajio['l1_reason13'] ?></textarea> -->
											<select class="form-control" id="avoid_repeat_ccsrnonvoice" name="data[l1_reason12]" disabled>
												<?php 
												if($ajio['l1_reason12']!=''){
													?>
													<option value="<?php //echo $ajio['audit_type'] ?>"><?php echo $ajio['l1_reason12'] ?></option>
													<?php
												}
												?>
												<option  <?php echo $ajio['l1_reason12'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td><textarea class="form-control" disabled name="data[cmt12]"><?php echo $ajio['cmt12'] ?></textarea></td>
									</tr>
									<tr>
										<td colspan=2 style="color:red">Did the champ document the case correctly and adhered to tagging guidelines.</td>
										<td>
											<select class="form-control ajio fatal ajioAF5" id="ajio_ccsrnonvoiceAF5" name="data[tagging_guidelines]" disabled>
												<option ajio_val=5 ajio_max=5 <?php echo $ajio['tagging_guidelines'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ajio_val=0 ajio_max=5 <?php echo $ajio['tagging_guidelines'] == "No"?"selected":"";?> value="No">No</option>
												<option ajio_val=0 ajio_max=5 <?php echo $ajio['tagging_guidelines'] == "Autofail"?"selected":"";?> value="Autofail">Autofail</option>
											</select>
										</td>
										<td>5</td>
										<td>
											<!-- <textarea class="form-control" name="data[l1_reason14]"><?php //echo $ajio['l1_reason14'] ?></textarea> -->
										<select class="form-control" id="tagging_guide_ccsrnonvoice" name="data[l1_reason13]" disabled>
											<?php 
												if($ajio['l1_reason13']!=''){
													?>
													<option value="<?php //echo $ajio['audit_type'] ?>"><?php echo $ajio['l1_reason14'] ?></option>
													<?php
												}
												?>
												<option  <?php echo $ajio['l1_reason13'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td><textarea class="form-control" disabled name="data[cmt13]"><?php echo $ajio['cmt13'] ?></textarea></td>
									</tr>

									<tr>
										<td style="background-color:#F1948A; font-weight:bold">ZTP</td>
										<td colspan=2 style="color:red">As per AJIO ZTP guidelines</td>
										<td>
											<select class="form-control ajio fatal ajioAF6" id="ajio_ccsrnonvoiceAF6" name="data[ztp_guidelines]" disabled>
												<option ajio_val=0 ajio_max=0 <?php echo $ajio['ztp_guidelines'] == "No"?"selected":"";?> value="No">No</option>
												<option ajio_val=0 ajio_max=0 <?php echo $ajio['ztp_guidelines'] == "Autofail"?"selected":"";?> value="Autofail">Autofail</option>
											</select>
										</td>
										<td>0</td>
									    <!-- <td>
											<select class="form-control" id="ztp_guide_ccsrvoice" name="data[l1_reason14]" disabled>
											<?php 
												if($ajio['l1_reason14']!=''){
													?>
													<option value="<?php //echo $ajio['l1_reason14'] ?>"><?php //echo $ajio['l1_reason14'] ?></option>
													<?php
												}
												?>
												<option  <?php //echo $ajio['l1_reason14'] == "......."?"selected":"";?> value=".......">.....</option>
												
											</select>	
										</td> -->
										<td><input type="text" class="form-control" name="data[l1_reason14]" value="<?php echo $ajio['l1_reason14']?>"></td>

										<td><textarea class="form-control" disabled name="data[cmt14]"><?php echo $ajio['cmt14'] ?></textarea></td>
									</tr>

									<tr>
										<td>Call Synopsis:</td>
										<td colspan="7"><textarea class="form-control" name="data[call_synopsis]" disabled><?php echo $ajio['call_synopsis'] ?></textarea></td>
									</tr>
									<tr>
										<td>Call Observation:</td>
										<td colspan=2><textarea class="form-control" name="data[call_summary]" disabled><?php echo $ajio['call_summary'] ?></textarea></td>
										<td>Feedback:</td>
										<td colspan="4"><textarea class="form-control" name="data[feedback]" disabled><?php echo $ajio['feedback'] ?></textarea></td>
									</tr>
									<tr>
										<td colspan=2>Upload Files</td>
										<?php if($ajio==0){ ?>
											<td colspan="5"><input type="file" multiple class="form-control" id="attach_file" name="attach_file[]" style="padding: 10px 10px 10px 10px;"></td>
										<?php }else{
											if($ajio['attach_file']!=''){ ?>
												<td colspan=4>
													<?php $attach_file = explode(",",$ajio['attach_file']);
													 foreach($attach_file as $mp){ ?>
														<audio controls='' style="background-color:#607F93"> 
														  <source src="<?php echo base_url(); ?>qa_files/qa_ajio/ccsr/<?php echo $mp; ?>" type="audio/ogg">
														  <source src="<?php echo base_url(); ?>qa_files/qa_ajio/ccsr/<?php echo $mp; ?>" type="audio/mpeg">
														</audio> </br>
													 <?php } ?>
												</td>
										<?php }else{
												echo '<td colspan=6><b>No Files</b></td>';
											  }
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
									
									<?php }else if($campaign=="social_media"){ ?>
										<?php
										$rand_id = 0;
										
										if($ajio['entry_by']!=''){
											$auditorName = $ajio['auditor_name'];
										}else{
											$auditorName = $ajio['client_name'];
										}
										$auditDate = mysql2mmddyy($ajio['audit_date']);
										$clDate_val = mysqlDt2mmddyy($ajio['call_date']);
										
										if ($rand_id != 0) {
											$agent_id = $rand_data['sid'];
											$fusion_id = $rand_data['fusion_id'];
											$agent_name = $rand_data['fname'] . " " . $rand_data['lname'];
											$tl_id = $rand_data['assigned_to'];
											$tl_name = $rand_data['tl_name'];
											$call_duration = $rand_data['call_duration'];
											
										} else {
											$agent_id = $ajio['agent_id'];
											$fusion_id = $ajio['fusion_id'];
											$agent_name = $ajio['fname'] . " " . $ajio['lname'] ;
											$tl_id = $ajio['tl_id'];
											$tl_name = $ajio['tl_name'];
											$call_duration = $ajio['call_duration'];
										}
									?>
									<tr>
										<td>Auditor Name:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control" value="<?php echo $auditorName; ?>" disabled></td>
										<td>Audit Date:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control" value="<?php echo $auditDate; ?>" disabled></td>
										<td>Interaction ID:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control" name="data[interaction_id]" pattern="^[a-zA-Z0-9_]*$" title="Special character not allowed" value="<?php echo $ajio['interaction_id'] ?>" disabled ></td>
										
									</tr>
									<tr>
										<td>Agent Name:<span style="font-size:24px;color:red">*</span></td>
										<td>
											<select class="form-control" id="agent_id" name="data[agent_id]" disabled>
											<option value="">-Select-</option>
											<?php foreach($agentName as $row){
												$sCss='';
												if($row['id']==$agent_id) $sCss='selected';
											?>
												<option value="<?php echo $row['id']; ?>" <?php echo $sCss; ?>><?php echo $row['name']; ?></option>
											<?php } ?>
										</select>
										</td>
										<td>Employee ID:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control" id="fusion_id" value="<?php echo $ajio['fusion_id'] ?>" readonly ></td>
										<td>L1 Supervisor:<span style="font-size:24px;color:red">*</span></td>
										<td>
											<input type="text" class="form-control" id="tl_name"  value="<?php echo $tl_name; ?>" readonly>
												<input type="hidden" class="form-control" id="tl_id" name="data[tl_id]" value="<?php echo $tl_id; ?>" disabled>
										</td>
									</tr>
									<tr>
										<td>Auditor's BP Id:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control" name="data[agent_bp_id]" pattern="^[a-zA-Z0-9_]*$" title="Special character not allowed" value="<?php echo $ajio['agent_bp_id'] ?>" disabled ></td>
										<td>Call Date/Time:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control" id="call_date_time" name="call_date" value="<?php echo $clDate_val; ?>" disabled></td>
										<td>Call Duration:<span style="font-size:24px;color:red">*</span></td>
										<td>
											<input type="text" class="form-control" onkeydown="return false;" id="call_duration" name="data[call_duration]" value="<?php echo $call_duration; ?>" disabled>
										</td>
									</tr>
									
									<tr>
										<td>Order Id:<span style="font-size:24px;color:red">*</span></td>
										<td>
											<input type="text" class="form-control" id="" name="data[order_id]" pattern="^[a-zA-Z0-9_]*$" title="Special character not allowed" value="<?php echo $ajio['order_id'] ?>" disabled>
										</td>
										<td>VOC:<span style="font-size:24px;color:red">*</span></td>
											<td>
												<select class="form-control" id="voc" name="data[voc]" disabled>
													
													<option value="">-Select-</option>
													<option value="1"  <?= ($ajio['voc']=="1")?"selected":"" ?>>1</option>
													<option value="2"  <?= ($ajio['voc']=="2")?"selected":"" ?>>2</option>
													<option value="3"  <?= ($ajio['voc']=="3")?"selected":"" ?>>3</option>
													<option value="4"  <?= ($ajio['voc']=="4")?"selected":"" ?>>4</option>
													<option value="5"  <?= ($ajio['voc']=="5")?"selected":"" ?>>5</option>
													<option value="6"  <?= ($ajio['voc']=="6")?"selected":"" ?>>6</option>
													<option value="7"  <?= ($ajio['voc']=="7")?"selected":"" ?>>7</option>
													<option value="8"  <?= ($ajio['voc']=="8")?"selected":"" ?>>8</option>
													<option value="9"  <?= ($ajio['voc']=="9")?"selected":"" ?>>9</option>
													<option value="10"  <?= ($ajio['voc']=="10")?"selected":"" ?>>10</option>
												</select>
											</td>
										<td>Call Synopsis:<span style="font-size:24px;color:red">*</span></td>
										<td>
											<input type="text" class="form-control" id="" name="data[call_synopsis]" pattern="^[a-zA-Z0-9_]*$" title="Special character not allowed" value="<?php echo $ajio['call_synopsis'] ?>" disabled>
										</td>
										
									</tr>
									<tr>
										<td>Ticket ID:<span style="font-size:24px;color:red">*</span></td>
										<td>
											<input type="text" class="form-control" id="" name="data[ticket_id]" pattern="^[a-zA-Z0-9_]*$" title="Special character not allowed" value="<?php echo $ajio['ticket_id'] ?>" disabled>
										</td>
										<td>Ticket Type:<span style="font-size:24px;color:red">*</span></td>
										<td>
											<select class="form-control" name="data[ticket_type]" disabled>
											<option value="">-Select-</option>
											<option value="Complaint"  <?= ($ajio['ticket_type']=="Complaint")?"selected":"" ?>>Complaint</option>
											<option value="Query"  <?= ($ajio['ticket_type']=="Query")?"selected":"" ?>>Query</option>
											<option value="Proactive SR"  <?= ($ajio['ticket_type']=="Proactive SR")?"selected":"" ?>>Proactive SR</option>
											</select>
										</td>
										<td>KPI - ACPT:<span style="font-size:24px;color:red">*</span></td>
										<td>
											<select class="form-control" name="data[KPI_ACPT]" disabled>
												<option value="">-Select-</option>
												<option <?php echo $ajio['KPI_ACPT'] == "Agent"?"selected":"";?> value="Agent">Agent</option>
												<option <?php echo $ajio['KPI_ACPT'] == "Process"?"selected":"";?> value="Process">Process</option>
												<option <?php echo $ajio['KPI_ACPT'] == "Customer"?"selected":"";?> value="Customer">Customer</option>
												<option <?php echo $ajio['KPI_ACPT'] == "Technology"?"selected":"";?> value="Technology">Technology</option>
												<option <?php echo $ajio['KPI_ACPT'] == "NA"?"selected":"";?> value="NA">NA</option>
											</select> 
										</td>
									</tr>
									
									<tr>
										
										<td>Audit Type:<span style="font-size:24px;color:red">*</span></td>
										<td>
											<select class="form-control" id="audit_type" name="data[audit_type]" disabled>
                                                    <option value="">-Select-</option>
                                                    <option value="CQ Audit" <?= ($ajio['audit_type']=="CQ Audit")?"selected":"" ?>>CQ Audit</option>
                                                    <option value="BQ Audit" <?= ($ajio['audit_type']=="BQ Audit")?"selected":"" ?>>BQ Audit</option>
                                                    <option value="Calibration" <?= ($ajio['audit_type']=="Calibration")?"selected":"" ?>>Calibration</option>
                                                    <option value="Pre-Certificate Mock Call" <?= ($ajio['audit_type']=="Pre-Certificate Mock Call")?"selected":"" ?>>Pre-Certificate Mock Call</option>
                                                    <option value="Certification Audit" <?= ($ajio['audit_type']=="Certification Audit")?"selected":"" ?>>Certification Audit</option>
                                                    <option value="WoW Call"  <?= ($ajio['audit_type']=="WoW Call")?"selected":"" ?>>WoW Call</option>
                                                    <option value="Hygiene Audit"  <?= ($ajio['audit_type']=="Hygiene Audit")?"selected":"" ?>>Hygiene Audit</option>
                                                    <option value="Operation Audit"  <?= ($ajio['audit_type']=="Operation Audit")?"selected":"" ?>>Operation Audit</option>
                                                    <option value="Trainer Audit"  <?= ($ajio['audit_type']=="Trainer Audit")?"selected":"" ?>>Trainer Audit</option> 
                                                    <option value="QA Supervisor Audit"  <?= ($ajio['audit_type']=="QA Supervisor Audit")?"selected":"" ?>>QA Supervisor Audit</option> 
                                                </select>
										</td>
										<td class="auType">Auditor Type<span style="font-size:24px;color:red">*</span></td>
											<td class="auType">
												<select class="form-control" id="auditor_type" name="data[auditor_type]">
                                                    <option value="">Select</option>
                                                    <option value="Master" <?= ($ajio['auditor_type']=="Master")?"selected":"" ?>>Master</option>
                                                    <option value="Regular" <?= ($ajio['auditor_type']=="Regular")?"selected":"" ?>>Regular</option>
                                                </select>
											</td>
									</tr>

									<tr>
										<td>Tagging by Evaluator:<span style="font-size:24px;color:red">*</span></td>
										<td colspan="4">
											
											<select class="form-control" name="data[tagging_evaluator]" disabled>
											<option value="">-Select-</option>
											<option value='Delivery-Fake Attempt-N/A' <?= ($ajio['tagging_evaluator']=='Delivery-Fake Attempt-N/A')?'selected':'' ?> >Delivery-Fake Attempt-N/A</option>
											<option value='Account-Store Credit Debited Order Not Processed-N/A' <?= ($ajio['tagging_evaluator']=='Account-Store Credit Debited Order Not Processed-N/A')?'selected':'' ?> >Account-Store Credit Debited Order Not Processed-N/A</option>
											<option value='Account-Store Credit Discrepancy-Others' <?= ($ajio['tagging_evaluator']=='Account-Store Credit Discrepancy-Others')?'selected':'' ?> >Account-Store Credit Discrepancy-Others</option>
											<option value='Account-Customer information Leak-N/A' <?= ($ajio['tagging_evaluator']=='Account-Customer information Leak-N/A')?'selected':'' ?> >Account-Customer information Leak-N/A</option>
											<option value='Callback-Others-N/A' <?= ($ajio['tagging_evaluator']=='Callback-Others-N/A')?'selected':'' ?> >Callback-Others-N/A</option>
											<option value='Delivery-Snatch Case-N/A' <?= ($ajio['tagging_evaluator']=='Delivery-Snatch Case-N/A')?'selected':'' ?> >Delivery-Snatch Case-N/A</option>
											<option value='Delivery-Order not dispatched from Warehouse-N/A' <?= ($ajio['tagging_evaluator']=='Delivery-Order not dispatched from Warehouse-N/A')?'selected':'' ?> >Delivery-Order not dispatched from Warehouse-N/A</option>
											<option value='Delivery-Delayed Delivery-N/A' <?= ($ajio['tagging_evaluator']=='Delivery-Delayed Delivery-N/A')?'selected':'' ?> >Delivery-Delayed Delivery-N/A</option>
											<option value='Account-Stop sms/email (promotional)-N/A' <?= ($ajio['tagging_evaluator']=='Account-Stop sms/email (promotional)-N/A')?'selected':'' ?> >Account-Stop sms/email (promotional)-N/A</option>
											<option value='Delivery-Complaint against Delivery Person-Courier person asking Extra Money' <?= ($ajio['tagging_evaluator']=='Delivery-Complaint against Delivery Person-Courier person asking Extra Money')?'selected':'' ?> >Delivery-Complaint against Delivery Person-Courier person asking Extra Money</option>
											<option value='Callback-Supervisor Callback-N/A' <?= ($ajio['tagging_evaluator']=='Callback-Supervisor Callback-N/A')?'selected':'' ?> >Callback-Supervisor Callback-N/A</option>
											<option value='Account-Account Deactivation-N/A' <?= ($ajio['tagging_evaluator']=='Account-Account Deactivation-N/A')?'selected':'' ?> >Account-Account Deactivation-N/A</option>
											<option value='Delivery-RTO Refund Delayed-N/A' <?= ($ajio['tagging_evaluator']=='Delivery-RTO Refund Delayed-N/A')?'selected':'' ?> >Delivery-RTO Refund Delayed-N/A</option>
											<option value='Online Refund-Amount Debited Order not processed-N/A' <?= ($ajio['tagging_evaluator']=='Online Refund-Amount Debited Order not processed-N/A')?'selected':'' ?> >Online Refund-Amount Debited Order not processed-N/A</option>
											<option value='Delivery-Special Instructions for Contact Details Update-N/A' <?= ($ajio['tagging_evaluator']=='Delivery-Special Instructions for Contact Details Update-N/A')?'selected':'' ?> >Delivery-Special Instructions for Contact Details Update-N/A</option>
											<option value='Online Refund-Refund not done against Reference No.-N/A' <?= ($ajio['tagging_evaluator']=='Online Refund-Refund not done against Reference No.-N/A')?'selected':'' ?> >Online Refund-Refund not done against Reference No.-N/A</option>
											<option value='Delivery-Complaint against Delivery Person-Courier person took Extra Money' <?= ($ajio['tagging_evaluator']=='Delivery-Complaint against Delivery Person-Courier person took Extra Money')?'selected':'' ?> >Delivery-Complaint against Delivery Person-Courier person took Extra Money</option>
											<option value='Marketing-Promotion Related-N/A' <?= ($ajio['tagging_evaluator']=='Marketing-Promotion Related-N/A')?'selected':'' ?> >Marketing-Promotion Related-N/A</option>
											<option value='Return-Picked up - Did not reach Warehouse-N/A' <?= ($ajio['tagging_evaluator']=='Return-Picked up - Did not reach Warehouse-N/A')?'selected':'' ?> >Return-Picked up - Did not reach Warehouse-N/A</option>
											<option value='Return-Self Ship Courier Charges not credited-N/A' <?= ($ajio['tagging_evaluator']=='Return-Self Ship Courier Charges not credited-N/A')?'selected':'' ?> >Return-Self Ship Courier Charges not credited-N/A</option>
											<option value='Goodwill Request-CM insisting Compensation-N/A' <?= ($ajio['tagging_evaluator']=='Goodwill Request-CM insisting Compensation-N/A')?'selected':'' ?> >Goodwill Request-CM insisting Compensation-N/A</option>
											<option value='Return-Reached Warehouse - Refund not Initiated-N/A' <?= ($ajio['tagging_evaluator']=='Return-Reached Warehouse - Refund not Initiated-N/A')?'selected':'' ?> >Return-Reached Warehouse - Refund not Initiated-N/A</option>
											<option value='Online Refund-Refund Reference No. Needed-CC/DC/NB' <?= ($ajio['tagging_evaluator']=='Online Refund-Refund Reference No. Needed-CC/DC/NB')?'selected':'' ?> >Online Refund-Refund Reference No. Needed-CC/DC/NB</option>
											<option value='Delivery-Complaint against Delivery Person-Rude Behaviour' <?= ($ajio['tagging_evaluator']=='Delivery-Complaint against Delivery Person-Rude Behaviour')?'selected':'' ?> >Delivery-Complaint against Delivery Person-Rude Behaviour</option>
											<option value='Return-Additional Self Ship Courier Charges Required-N/A' <?= ($ajio['tagging_evaluator']=='Return-Additional Self Ship Courier Charges Required-N/A')?'selected':'' ?> >Return-Additional Self Ship Courier Charges Required-N/A</option>
											<option value='Return-Pickup delayed-N/A' <?= ($ajio['tagging_evaluator']=='Return-Pickup delayed-N/A')?'selected':'' ?> >Return-Pickup delayed-N/A</option>
											<option value='Online Refund-Refund Reference No. Needed-IMPS Transfer' <?= ($ajio['tagging_evaluator']=='Online Refund-Refund Reference No. Needed-IMPS Transfer')?'selected':'' ?> >Online Refund-Refund Reference No. Needed-IMPS Transfer</option>
											<option value='Return-Customer claiming product picked up-Customer did not have acknowledgement copy' <?= ($ajio['tagging_evaluator']=='Return-Customer claiming product picked up-Customer did not have acknowledgement copy')?'selected':'' ?> >Return-Customer claiming product picked up-Customer did not have acknowledgement copy</option>
											<option value='NEFT(Refund Request)-NEFT Transfer-N/A' <?= ($ajio['tagging_evaluator']=='NEFT(Refund Request)-NEFT Transfer-N/A')?'selected':'' ?> >NEFT(Refund Request)-NEFT Transfer-N/A</option>
											<option value='Return-Customer claiming product picked up-Shared acknowledgement copy' <?= ($ajio['tagging_evaluator']=='Return-Customer claiming product picked up-Shared acknowledgement copy')?'selected':'' ?> >Return-Customer claiming product picked up-Shared acknowledgement copy</option>
											<option value='Marketing-Gift not Received post winning contest-N/A' <?= ($ajio['tagging_evaluator']=='Marketing-Gift not Received post winning contest-N/A')?'selected':'' ?> >Marketing-Gift not Received post winning contest-N/A</option>
											<option value='Return-Non Returnable Product-Wrong Product delivered' <?= ($ajio['tagging_evaluator']=='Return-Non Returnable Product-Wrong Product delivered')?'selected':'' ?> >Return-Non Returnable Product-Wrong Product delivered</option>
											<option value='Return-Self Shipped no Update From WH-N/A' <?= ($ajio['tagging_evaluator']=='Return-Self Shipped no Update From WH-N/A')?'selected':'' ?> >Return-Self Shipped no Update From WH-N/A</option>
											<option value='Return-Damaged Product-Damaged post usage' <?= ($ajio['tagging_evaluator']=='Return-Damaged Product-Damaged post usage')?'selected':'' ?> >Return-Damaged Product-Damaged post usage</option>
											<option value='Return-Regular Courier Charges not credited-N/A' <?= ($ajio['tagging_evaluator']=='Return-Regular Courier Charges not credited-N/A')?'selected':'' ?> >Return-Regular Courier Charges not credited-N/A</option>
											<option value='Return-Complaint against Delivery Person-Rude Behaviour' <?= ($ajio['tagging_evaluator']=='Return-Complaint against Delivery Person-Rude Behaviour')?'selected':'' ?> >Return-Complaint against Delivery Person-Rude Behaviour</option>
											<option value='Return-Special Instructions for Contact Details Update-N/A' <?= ($ajio['tagging_evaluator']=='Return-Special Instructions for Contact Details Update-N/A')?'selected':'' ?> >Return-Special Instructions for Contact Details Update-N/A</option>
											<option value='Return-Complaint against Delivery Person-Excess product handed over' <?= ($ajio['tagging_evaluator']=='Return-Complaint against Delivery Person-Excess product handed over')?'selected':'' ?> >Return-Complaint against Delivery Person-Excess product handed over</option>
											<option value='Return-Complaint against Delivery Person-Didn’t have pickup receipt' <?= ($ajio['tagging_evaluator']=='Return-Complaint against Delivery Person-Didn’t have pickup receipt')?'selected':'' ?> >Return-Complaint against Delivery Person-Didn’t have pickup receipt</option>
											<option value='Return-Complaint against Delivery Person-Didn’t know which product to pickup' <?= ($ajio['tagging_evaluator']=='Return-Complaint against Delivery Person-Didn’t know which product to pickup')?'selected':'' ?> >Return-Complaint against Delivery Person-Didn’t know which product to pickup</option>
											<option value='Return-Complaint against Delivery Person-Courier person refused to pick a product' <?= ($ajio['tagging_evaluator']=='Return-Complaint against Delivery Person-Courier person refused to pick a product')?'selected':'' ?> >Return-Complaint against Delivery Person-Courier person refused to pick a product</option>
											<option value='Return-Non Ajio Product Returned-Product Picked Up' <?= ($ajio['tagging_evaluator']=='Return-Non Ajio Product Returned-Product Picked Up')?'selected':'' ?> >Return-Non Ajio Product Returned-Product Picked Up</option>
											<option value='Return-Pickup - Wrong Status Update-Product not picked up - Exchange Related' <?= ($ajio['tagging_evaluator']=='Return-Pickup - Wrong Status Update-Product not picked up - Exchange Related')?'selected':'' ?> >Return-Pickup - Wrong Status Update-Product not picked up - Exchange Related</option>
											<option value='Return-Fake Attempt-N/A' <?= ($ajio['tagging_evaluator']=='Return-Fake Attempt-N/A')?'selected':'' ?> >Return-Fake Attempt-N/A</option>
											<option value='Website-Complaint relating to Website-No confirmation received on website/email/sms' <?= ($ajio['tagging_evaluator']=='Website-Complaint relating to Website-No confirmation received on website/email/sms')?'selected':'' ?> >Website-Complaint relating to Website-No confirmation received on website/email/sms</option>
											<option value='Website-Complaint relating to Website-Unable to view/edit Profile Details' <?= ($ajio['tagging_evaluator']=='Website-Complaint relating to Website-Unable to view/edit Profile Details')?'selected':'' ?> >Website-Complaint relating to Website-Unable to view/edit Profile Details</option>
											<option value='Website-Complaint relating to Website-Issue with product page info' <?= ($ajio['tagging_evaluator']=='Website-Complaint relating to Website-Issue with product page info')?'selected':'' ?> >Website-Complaint relating to Website-Issue with product page info</option>
											<option value='Website-Complaint relating to Website-Unable to cancel' <?= ($ajio['tagging_evaluator']=='Website-Complaint relating to Website-Unable to cancel')?'selected':'' ?> >Website-Complaint relating to Website-Unable to cancel</option>
											<option value='Website-Complaint relating to Website-MRP Mismatch' <?= ($ajio['tagging_evaluator']=='Website-Complaint relating to Website-MRP Mismatch')?'selected':'' ?> >Website-Complaint relating to Website-MRP Mismatch</option>
											<option value='Website-Complaint relating to Website-Unable to place order' <?= ($ajio['tagging_evaluator']=='Website-Complaint relating to Website-Unable to place order')?'selected':'' ?> >Website-Complaint relating to Website-Unable to place order</option>
											<option value='Website-Complaint relating to Website-Unable to exchange' <?= ($ajio['tagging_evaluator']=='Website-Complaint relating to Website-Unable to exchange')?'selected':'' ?> >Website-Complaint relating to Website-Unable to exchange</option>
											<option value='Website-Complaint relating to Website-Unable to return' <?= ($ajio['tagging_evaluator']=='Website-Complaint relating to Website-Unable to return')?'selected':'' ?> >Website-Complaint relating to Website-Unable to return</option>
											<option value='Website-Complaint relating to Website-Product details required' <?= ($ajio['tagging_evaluator']=='Website-Complaint relating to Website-Product details required')?'selected':'' ?> >Website-Complaint relating to Website-Product details required</option>
											<option value='VOC-Complaint against CC Employee-N/A' <?= ($ajio['tagging_evaluator']=='VOC-Complaint against CC Employee-N/A')?'selected':'' ?> >VOC-Complaint against CC Employee-N/A</option>
											<option value='Website-Complaint relating to Website-Unable to login/signup' <?= ($ajio['tagging_evaluator']=='Website-Complaint relating to Website-Unable to login/signup')?'selected':'' ?> >Website-Complaint relating to Website-Unable to login/signup</option>
											<option value='Return-Non Ajio Product Returned-Product Reached WH' <?= ($ajio['tagging_evaluator']=='Return-Non Ajio Product Returned-Product Reached WH')?'selected':'' ?> >Return-Non Ajio Product Returned-Product Reached WH</option>
											<option value='VOC-Harassment & Integrity Issues-N/A' <?= ($ajio['tagging_evaluator']=='VOC-Harassment & Integrity Issues-N/A')?'selected':'' ?> >VOC-Harassment & Integrity Issues-N/A</option>
											<option value='Return-Pickup - Wrong Status Update-Product not picked up - Return Related' <?= ($ajio['tagging_evaluator']=='Return-Pickup - Wrong Status Update-Product not picked up - Return Related')?'selected':'' ?> >Return-Pickup - Wrong Status Update-Product not picked up - Return Related</option>
											<option value='Website-Complaint relating to Website-Slow Functioning/Unable to open feature-webpage-website' <?= ($ajio['tagging_evaluator']=='Website-Complaint relating to Website-Slow Functioning/Unable to open feature-webpage-website')?'selected':'' ?> >Website-Complaint relating to Website-Slow Functioning/Unable to open feature-webpage-website</option>
											<option value='WH - Order Related Issues-Customer Return-Product Interchange of Customer' <?= ($ajio['tagging_evaluator']=='WH - Order Related Issues-Customer Return-Product Interchange of Customer')?'selected':'' ?> >WH - Order Related Issues-Customer Return-Product Interchange of Customer</option>
											<option value='WH - Order Related Issues-RTO-Order Received Without Return ID' <?= ($ajio['tagging_evaluator']=='WH - Order Related Issues-RTO-Order Received Without Return ID')?'selected':'' ?> >WH - Order Related Issues-RTO-Order Received Without Return ID</option>
											<option value='WH - Order Related Issues-RTO-Others' <?= ($ajio['tagging_evaluator']=='WH - Order Related Issues-RTO-Others')?'selected':'' ?> >WH - Order Related Issues-RTO-Others</option>
											<option value='WH - Order Related Issues-Customer Return-No Clue Shipment' <?= ($ajio['tagging_evaluator']=='WH - Order Related Issues-Customer Return-No Clue Shipment')?'selected':'' ?> >WH - Order Related Issues-Customer Return-No Clue Shipment</option>
											<option value='WH - Order Related Issues-Customer Return-Invoice Interchange' <?= ($ajio['tagging_evaluator']=='WH - Order Related Issues-Customer Return-Invoice Interchange')?'selected':'' ?> >WH - Order Related Issues-Customer Return-Invoice Interchange</option>
											<option value='WH - Order Related Issues-RTO-Damaged Product Received' <?= ($ajio['tagging_evaluator']=='WH - Order Related Issues-RTO-Damaged Product Received')?'selected':'' ?> >WH - Order Related Issues-RTO-Damaged Product Received</option>
											<option value='WH - Order Related Issues-Customer Return-Missing Free Gift' <?= ($ajio['tagging_evaluator']=='WH - Order Related Issues-Customer Return-Missing Free Gift')?'selected':'' ?> >WH - Order Related Issues-Customer Return-Missing Free Gift</option>
											<option value='WH - Order Related Issues-Customer Return-Non-Ajio Product Return' <?= ($ajio['tagging_evaluator']=='WH - Order Related Issues-Customer Return-Non-Ajio Product Return')?'selected':'' ?> >WH - Order Related Issues-Customer Return-Non-Ajio Product Return</option>
											<option value='WH - Order Related Issues-RTO-Empty Box Received' <?= ($ajio['tagging_evaluator']=='WH - Order Related Issues-RTO-Empty Box Received')?'selected':'' ?> >WH - Order Related Issues-RTO-Empty Box Received</option>
											<option value='WH - Order Related Issues-Customer Return-Order Received Without Return ID' <?= ($ajio['tagging_evaluator']=='WH - Order Related Issues-Customer Return-Order Received Without Return ID')?'selected':'' ?> >WH - Order Related Issues-Customer Return-Order Received Without Return ID</option>
											<option value='WH - Order Related Issues-Return to be cancelled-AWB not cancelled (Pickup not required)' <?= ($ajio['tagging_evaluator']=='WH - Order Related Issues-Return to be cancelled-AWB not cancelled (Pickup not required)')?'selected':'' ?> >WH - Order Related Issues-Return to be cancelled-AWB not cancelled (Pickup not required)</option>
											<option value='WH - Order Related Issues-RTO-Missing Free Gift' <?= ($ajio['tagging_evaluator']=='WH - Order Related Issues-RTO-Missing Free Gift')?'selected':'' ?> >WH - Order Related Issues-RTO-Missing Free Gift</option>
											<option value='WH - Order Related Issues-Forward-MRP Mismatch' <?= ($ajio['tagging_evaluator']=='WH - Order Related Issues-Forward-MRP Mismatch')?'selected':'' ?> >WH - Order Related Issues-Forward-MRP Mismatch</option>
											<option value='WH - Order Related Issues-Customer Return-Excess Product Received' <?= ($ajio['tagging_evaluator']=='WH - Order Related Issues-Customer Return-Excess Product Received')?'selected':'' ?> >WH - Order Related Issues-Customer Return-Excess Product Received</option>
											<option value='WH - Order Related Issues-Customer Return-To Be Refunded – Empty Box Received' <?= ($ajio['tagging_evaluator']=='WH - Order Related Issues-Customer Return-To Be Refunded – Empty Box Received')?'selected':'' ?> >WH - Order Related Issues-Customer Return-To Be Refunded – Empty Box Received</option>
											<option value='WH - Order Related Issues-RTO-No Clue Shipment' <?= ($ajio['tagging_evaluator']=='WH - Order Related Issues-RTO-No Clue Shipment')?'selected':'' ?> >WH - Order Related Issues-RTO-No Clue Shipment</option>
											<option value='WH - Order Related Issues-RTO-Excess Product Received' <?= ($ajio['tagging_evaluator']=='WH - Order Related Issues-RTO-Excess Product Received')?'selected':'' ?> >WH - Order Related Issues-RTO-Excess Product Received</option>
											<option value='WH - Order Related Issues-Forward-Design Mismatch' <?= ($ajio['tagging_evaluator']=='WH - Order Related Issues-Forward-Design Mismatch')?'selected':'' ?> >WH - Order Related Issues-Forward-Design Mismatch</option>
											<option value='WH - Order Related Issues-RTO-Packaging / Box not Received or Damaged' <?= ($ajio['tagging_evaluator']=='WH - Order Related Issues-RTO-Packaging / Box not Received or Damaged')?'selected':'' ?> >WH - Order Related Issues-RTO-Packaging / Box not Received or Damaged</option>
											<option value='WH - Order Related Issues-Return to be cancelled-AWB cancelled (Pickup not required)' <?= ($ajio['tagging_evaluator']=='WH - Order Related Issues-Return to be cancelled-AWB cancelled (Pickup not required)')?'selected':'' ?> >WH - Order Related Issues-Return to be cancelled-AWB cancelled (Pickup not required)</option>
											<option value='WH - Order Related Issues-Return to be cancelled-AWB cancelled (Pickup required)' <?= ($ajio['tagging_evaluator']=='WH - Order Related Issues-Return to be cancelled-AWB cancelled (Pickup required)')?'selected':'' ?> >WH - Order Related Issues-Return to be cancelled-AWB cancelled (Pickup required)</option>
											<option value='WH - Order Related Issues-Forward-Tech Issues' <?= ($ajio['tagging_evaluator']=='WH - Order Related Issues-Forward-Tech Issues')?'selected':'' ?> >WH - Order Related Issues-Forward-Tech Issues</option>
											<option value='WH - Order Related Issues-Return to be cancelled-AWB not cancelled (Pickup required)' <?= ($ajio['tagging_evaluator']=='WH - Order Related Issues-Return to be cancelled-AWB not cancelled (Pickup required)')?'selected':'' ?> >WH - Order Related Issues-Return to be cancelled-AWB not cancelled (Pickup required)</option>
											<option value='WH - Order Related Issues-Customer Return-Empty Box Received' <?= ($ajio['tagging_evaluator']=='WH - Order Related Issues-Customer Return-Empty Box Received')?'selected':'' ?> >WH - Order Related Issues-Customer Return-Empty Box Received</option>
											<option value='WH - Order Related Issues-Customer Return-Non Delhivery pickup-Missing product in return packet' <?= ($ajio['tagging_evaluator']=='WH - Order Related Issues-Customer Return-Non Delhivery pickup-Missing product in return packet')?'selected':'' ?> >WH - Order Related Issues-Customer Return-Non Delhivery pickup-Missing product in return packet</option>
											<option value='WH - Order Related Issues-Customer Return-Others' <?= ($ajio['tagging_evaluator']=='WH - Order Related Issues-Customer Return-Others')?'selected':'' ?> >WH - Order Related Issues-Customer Return-Others</option>
											<option value='WH - Order Related Issues-Customer Return-Missing Product in Return Packet' <?= ($ajio['tagging_evaluator']=='WH - Order Related Issues-Customer Return-Missing Product in Return Packet')?'selected':'' ?> >WH - Order Related Issues-Customer Return-Missing Product in Return Packet</option>
											<option value='WH - Order Related Issues-RTO-Missing Product in Return Packet' <?= ($ajio['tagging_evaluator']=='WH - Order Related Issues-RTO-Missing Product in Return Packet')?'selected':'' ?> >WH - Order Related Issues-RTO-Missing Product in Return Packet</option>
											<option value='WH - Order Related Issues-RTO-Invoice Interchange' <?= ($ajio['tagging_evaluator']=='WH - Order Related Issues-RTO-Invoice Interchange')?'selected':'' ?> >WH - Order Related Issues-RTO-Invoice Interchange</option>
											<option value='WH - Order Related Issues-Customer Return-Tags Missing' <?= ($ajio['tagging_evaluator']=='WH - Order Related Issues-Customer Return-Tags Missing')?'selected':'' ?> >WH - Order Related Issues-Customer Return-Tags Missing</option>
											<option value='WH - Order Related Issues-RTO-Non-Ajio Product Return' <?= ($ajio['tagging_evaluator']=='WH - Order Related Issues-RTO-Non-Ajio Product Return')?'selected':'' ?> >WH - Order Related Issues-RTO-Non-Ajio Product Return</option>
											<option value='Mobile App-Others-Others' <?= ($ajio['tagging_evaluator']=='Mobile App-Others-Others')?'selected':'' ?> >Mobile App-Others-Others</option>
											<option value='Delivery-I want quicker Delivery-Informed about expediting policy' <?= ($ajio['tagging_evaluator']=='Delivery-I want quicker Delivery-Informed about expediting policy')?'selected':'' ?> >Delivery-I want quicker Delivery-Informed about expediting policy</option>
											<option value='Account-I need help with my account-Informed customer about account information' <?= ($ajio['tagging_evaluator']=='Account-I need help with my account-Informed customer about account information')?'selected':'' ?> >Account-I need help with my account-Informed customer about account information</option>
											<option value='Account-I need help with my account-Guided customer on My Accounts' <?= ($ajio['tagging_evaluator']=='Account-I need help with my account-Guided customer on My Accounts')?'selected':'' ?> >Account-I need help with my account-Guided customer on My Accounts</option>
											<option value='Account-How do I use JioMoney?-Guided customer on JioMoney validity' <?= ($ajio['tagging_evaluator']=='Account-How do I use JioMoney?-Guided customer on JioMoney validity')?'selected':'' ?> >Account-How do I use JioMoney?-Guided customer on JioMoney validity</option>
											<option value='Account-How do I use JioMoney?-Guided customer on loading JioMoney' <?= ($ajio['tagging_evaluator']=='Account-How do I use JioMoney?-Guided customer on loading JioMoney')?'selected':'' ?> >Account-How do I use JioMoney?-Guided customer on loading JioMoney</option>
											<option value='Account-I did not place this order-Retained the order' <?= ($ajio['tagging_evaluator']=='Account-I did not place this order-Retained the order')?'selected':'' ?> >Account-I did not place this order-Retained the order</option>
											<option value='Business-Others-Advised about the procedure' <?= ($ajio['tagging_evaluator']=='Business-Others-Advised about the procedure')?'selected':'' ?> >Business-Others-Advised about the procedure</option>
											<option value='Account-Why is my account suspended ?-Guided customer on Reason for Suspension' <?= ($ajio['tagging_evaluator']=='Account-Why is my account suspended ?-Guided customer on Reason for Suspension')?'selected':'' ?> >Account-Why is my account suspended ?-Guided customer on Reason for Suspension</option>
											<option value='NAR Calls/Emails-Incomplete Call/Email-Call dropped after knowing the query' <?= ($ajio['tagging_evaluator']=='NAR Calls/Emails-Incomplete Call/Email-Call dropped after knowing the query')?'selected':'' ?> >NAR Calls/Emails-Incomplete Call/Email-Call dropped after knowing the query</option>
											<option value='Mobile App-Help me shop on the App-Helped the customer' <?= ($ajio['tagging_evaluator']=='Mobile App-Help me shop on the App-Helped the customer')?'selected':'' ?> >Mobile App-Help me shop on the App-Helped the customer</option>
											<option value='Account-How do I use my store credits?-Informed about Store Credit policy' <?= ($ajio['tagging_evaluator']=='Account-How do I use my store credits?-Informed about Store Credit policy')?'selected':'' ?> >Account-How do I use my store credits?-Informed about Store Credit policy</option>
											<option value='Coupon-How do I use my Coupon?-Educated customer on Coupon features' <?= ($ajio['tagging_evaluator']=='Coupon-How do I use my Coupon?-Educated customer on Coupon features')?'selected':'' ?> >Coupon-How do I use my Coupon?-Educated customer on Coupon features</option>
											<option value='Cancel-I want to cancel-Cancelled order' <?= ($ajio['tagging_evaluator']=='Cancel-I want to cancel-Cancelled order')?'selected':'' ?> >Cancel-I want to cancel-Cancelled order</option>
											<option value='NAR Calls/Emails-Incomplete Call/Email-Call suddenly went blank during conversation' <?= ($ajio['tagging_evaluator']=='NAR Calls/Emails-Incomplete Call/Email-Call suddenly went blank during conversation')?'selected':'' ?> >NAR Calls/Emails-Incomplete Call/Email-Call suddenly went blank during conversation</option>
											<option value='Account-I did not place this order-Cancelled the order' <?= ($ajio['tagging_evaluator']=='Account-I did not place this order-Cancelled the order')?'selected':'' ?> >Account-I did not place this order-Cancelled the order</option>
											<option value='NAR Calls/Emails-Blank Call-Blank Call' <?= ($ajio['tagging_evaluator']=='NAR Calls/Emails-Blank Call-Blank Call')?'selected':'' ?> >NAR Calls/Emails-Blank Call-Blank Call</option>
											<option value='Cancel-Explain the Cancellation Policy-Explained the cancellation policy' <?= ($ajio['tagging_evaluator']=='Cancel-Explain the Cancellation Policy-Explained the cancellation policy')?'selected':'' ?> >Cancel-Explain the Cancellation Policy-Explained the cancellation policy</option>
											<option value='Mobile App-How do I cancel the order on the App-Explained the feature' <?= ($ajio['tagging_evaluator']=='Mobile App-How do I cancel the order on the App-Explained the feature')?'selected':'' ?> >Mobile App-How do I cancel the order on the App-Explained the feature</option>
											<option value='Account-How do I use JioMoney?-Guided customer to JioMoney Customer Care' <?= ($ajio['tagging_evaluator']=='Account-How do I use JioMoney?-Guided customer to JioMoney Customer Care')?'selected':'' ?> >Account-How do I use JioMoney?-Guided customer to JioMoney Customer Care</option>
											<option value='Account-I want to Stop SMS/Email Promotions-Informed customer of the procedure' <?= ($ajio['tagging_evaluator']=='Account-I want to Stop SMS/Email Promotions-Informed customer of the procedure')?'selected':'' ?> >Account-I want to Stop SMS/Email Promotions-Informed customer of the procedure</option>
											<option value='Cancel-I want to cancel-Educated customer on cancellation policy' <?= ($ajio['tagging_evaluator']=='Cancel-I want to cancel-Educated customer on cancellation policy')?'selected':'' ?> >Cancel-I want to cancel-Educated customer on cancellation policy</option>
											<option value='Mobile App-I have a problem using your app-Explained the App feature/Functions' <?= ($ajio['tagging_evaluator']=='Mobile App-I have a problem using your app-Explained the App feature/Functions')?'selected':'' ?> >Mobile App-I have a problem using your app-Explained the App feature/Functions</option>
											<option value='NAR Calls/Emails-Incomplete Call/Email-Call dropped before knowing the query' <?= ($ajio['tagging_evaluator']=='NAR Calls/Emails-Incomplete Call/Email-Call dropped before knowing the query')?'selected':'' ?> >NAR Calls/Emails-Incomplete Call/Email-Call dropped before knowing the query</option>
											<option value='Coupon-I did not receive a coupon after returning/cancelling-Educated customer on Coupon policy' <?= ($ajio['tagging_evaluator']=='Coupon-I did not receive a coupon after returning/cancelling-Educated customer on Coupon policy')?'selected':'' ?> >Coupon-I did not receive a coupon after returning/cancelling-Educated customer on Coupon policy</option>
											<option value='Account-How many Store Credits do I have?-Provided the amount to the customer' <?= ($ajio['tagging_evaluator']=='Account-How many Store Credits do I have?-Provided the amount to the customer')?'selected':'' ?> >Account-How many Store Credits do I have?-Provided the amount to the customer</option>
											<option value='Mobile App-The App is slow/ loading & functionality issues-Troubleshooting done' <?= ($ajio['tagging_evaluator']=='Mobile App-The App is slow/ loading & functionality issues-Troubleshooting done')?'selected':'' ?> >Mobile App-The App is slow/ loading & functionality issues-Troubleshooting done</option>
											<option value='Cancel-I want to cancel-Guided customer to cancel on Website/App' <?= ($ajio['tagging_evaluator']=='Cancel-I want to cancel-Guided customer to cancel on Website/App')?'selected':'' ?> >Cancel-I want to cancel-Guided customer to cancel on Website/App</option>
											<option value='Mobile App-I am unable to login/sign up on the App-Helped the customer login/signup' <?= ($ajio['tagging_evaluator']=='Mobile App-I am unable to login/sign up on the App-Helped the customer login/signup')?'selected':'' ?> >Mobile App-I am unable to login/sign up on the App-Helped the customer login/signup</option>
											<option value='Account-I need help with my account-Guided customer on password query' <?= ($ajio['tagging_evaluator']=='Account-I need help with my account-Guided customer on password query')?'selected':'' ?> >Account-I need help with my account-Guided customer on password query</option>
											<option value='Account-How do I use my store credits?-Explained how to use Store Credits' <?= ($ajio['tagging_evaluator']=='Account-How do I use my store credits?-Explained how to use Store Credits')?'selected':'' ?> >Account-How do I use my store credits?-Explained how to use Store Credits</option>
											<option value='Business-I want to do marketing/promotion for AJIO-Advised about the procedure' <?= ($ajio['tagging_evaluator']=='Business-I want to do marketing/promotion for AJIO-Advised about the procedure')?'selected':'' ?> >Business-I want to do marketing/promotion for AJIO-Advised about the procedure</option>
											<option value='NAR Calls/Emails-Abusive Caller-Abusive Caller' <?= ($ajio['tagging_evaluator']=='NAR Calls/Emails-Abusive Caller-Abusive Caller')?'selected':'' ?> >NAR Calls/Emails-Abusive Caller-Abusive Caller</option>
											<option value='NAR Calls/Emails-Incomplete Call/Email-Call suddenly got interrupted by static noise during conversation' <?= ($ajio['tagging_evaluator']=='NAR Calls/Emails-Incomplete Call/Email-Call suddenly got interrupted by static noise during conversation')?'selected':'' ?> >NAR Calls/Emails-Incomplete Call/Email-Call suddenly got interrupted by static noise during conversation</option>
											<option value='Cancel-Cancel my Return/Exchange-Informed Unable to cancel' <?= ($ajio['tagging_evaluator']=='Cancel-Cancel my Return/Exchange-Informed Unable to cancel')?'selected':'' ?> >Cancel-Cancel my Return/Exchange-Informed Unable to cancel</option>
											<option value='Cancel-Why was my pickup/exchange cancelled?-Explained the reason' <?= ($ajio['tagging_evaluator']=='Cancel-Why was my pickup/exchange cancelled?-Explained the reason')?'selected':'' ?> >Cancel-Why was my pickup/exchange cancelled?-Explained the reason</option>
											<option value='Mobile App-How do I create a return on the App-Explained the feature' <?= ($ajio['tagging_evaluator']=='Mobile App-How do I create a return on the App-Explained the feature')?'selected':'' ?> >Mobile App-How do I create a return on the App-Explained the feature</option>
											<option value='Business-Media Related-Enquiry/ Concern' <?= ($ajio['tagging_evaluator']=='Business-Media Related-Enquiry/ Concern')?'selected':'' ?> >Business-Media Related-Enquiry/ Concern</option>
											<option value='Cancel-Why was my order cancelled?-Explained the cancellation reason' <?= ($ajio['tagging_evaluator']=='Cancel-Why was my order cancelled?-Explained the cancellation reason')?'selected':'' ?> >Cancel-Why was my order cancelled?-Explained the cancellation reason</option>
											<option value='Business-I want to sell my merchandise on AJIO-Advised about the procedure' <?= ($ajio['tagging_evaluator']=='Business-I want to sell my merchandise on AJIO-Advised about the procedure')?'selected':'' ?> >Business-I want to sell my merchandise on AJIO-Advised about the procedure</option>
											<option value='Delivery-I want Delivery/Pickup at specific time-Informed about delivery policy' <?= ($ajio['tagging_evaluator']=='Delivery-I want Delivery/Pickup at specific time-Informed about delivery policy')?'selected':'' ?> >Delivery-I want Delivery/Pickup at specific time-Informed about delivery policy</option>
											<option value='Business-I want to apply for job at AJIO-Guided customer on process' <?= ($ajio['tagging_evaluator']=='Business-I want to apply for job at AJIO-Guided customer on process')?'selected':'' ?> >Business-I want to apply for job at AJIO-Guided customer on process</option>
											<option value='Cancel-Cancel my Return/Exchange-Cancelled the Return /Exchange request' <?= ($ajio['tagging_evaluator']=='Cancel-Cancel my Return/Exchange-Cancelled the Return /Exchange request')?'selected':'' ?> >Cancel-Cancel my Return/Exchange-Cancelled the Return /Exchange request</option>
											<option value='NAR Calls/Emails-NAR Calls-No Action Required' <?= ($ajio['tagging_evaluator']=='NAR Calls/Emails-NAR Calls-No Action Required')?'selected':'' ?> >NAR Calls/Emails-NAR Calls-No Action Required</option>
											<option value='NAR Calls/Emails-NAR Emails-No Action Required' <?= ($ajio['tagging_evaluator']=='NAR Calls/Emails-NAR Emails-No Action Required')?'selected':'' ?> >NAR Calls/Emails-NAR Emails-No Action Required</option>
											<option value='NAR Calls/Emails-NAR Emails-Spam' <?= ($ajio['tagging_evaluator']=='NAR Calls/Emails-NAR Emails-Spam')?'selected':'' ?> >NAR Calls/Emails-NAR Emails-Spam</option>
											<option value='NAR Calls/Emails-NAR Calls-Non Ajio Queries' <?= ($ajio['tagging_evaluator']=='NAR Calls/Emails-NAR Calls-Non Ajio Queries')?'selected':'' ?> >NAR Calls/Emails-NAR Calls-Non Ajio Queries</option>
											<option value='NAR Calls/Emails-Test-Test Email' <?= ($ajio['tagging_evaluator']=='NAR Calls/Emails-Test-Test Email')?'selected':'' ?> >NAR Calls/Emails-Test-Test Email</option>
											<option value='NAR Calls/Emails-NAR Emails-Duplicate email' <?= ($ajio['tagging_evaluator']=='NAR Calls/Emails-NAR Emails-Duplicate email')?'selected':'' ?> >NAR Calls/Emails-NAR Emails-Duplicate email</option>
											<option value='Cancel-I want to cancel-Informed customer to refuse the delivery' <?= ($ajio['tagging_evaluator']=='Cancel-I want to cancel-Informed customer to refuse the delivery')?'selected':'' ?> >Cancel-I want to cancel-Informed customer to refuse the delivery</option>
											<option value='NAR Calls/Emails-Prank Call-Prank Call' <?= ($ajio['tagging_evaluator']=='NAR Calls/Emails-Prank Call-Prank Call')?'selected':'' ?> >NAR Calls/Emails-Prank Call-Prank Call</option>
											<option value='Order-I want to place an order-Placed an order through CS Cockpit' <?= ($ajio['tagging_evaluator']=='Order-I want to place an order-Placed an order through CS Cockpit')?'selected':'' ?> >Order-I want to place an order-Placed an order through CS Cockpit</option>
											<option value='Order-I want to place an order-Informed customer of pin code serviceability' <?= ($ajio['tagging_evaluator']=='Order-I want to place an order-Informed customer of pin code serviceability')?'selected':'' ?> >Order-I want to place an order-Informed customer of pin code serviceability</option>
											<option value='Other-I want Compensation-Convinced the customer - No Action Required' <?= ($ajio['tagging_evaluator']=='Other-I want Compensation-Convinced the customer - No Action Required')?'selected':'' ?> >Other-I want Compensation-Convinced the customer - No Action Required</option>
											<option value='Order-Telesales-Order Placed' <?= ($ajio['tagging_evaluator']=='Order-Telesales-Order Placed')?'selected':'' ?> >Order-Telesales-Order Placed</option>
											<option value='Order-I had a problem while placing an order-Clarified that order was Not Processed' <?= ($ajio['tagging_evaluator']=='Order-I had a problem while placing an order-Clarified that order was Not Processed')?'selected':'' ?> >Order-I had a problem while placing an order-Clarified that order was Not Processed</option>
											<option value='Order-I had a problem while placing an order-Informed customer of pin code serviceability' <?= ($ajio['tagging_evaluator']=='Order-I had a problem while placing an order-Informed customer of pin code serviceability')?'selected':'' ?> >Order-I had a problem while placing an order-Informed customer of pin code serviceability</option>
											<option value='Pre Order - F&L-Explain the features of the product-Explained about product features' <?= ($ajio['tagging_evaluator']=='Pre Order - F&L-Explain the features of the product-Explained about product features')?'selected':'' ?> >Pre Order - F&L-Explain the features of the product-Explained about product features</option>
											<option value='Order-What are my delivery / payment options?-Informed customer of payment options' <?= ($ajio['tagging_evaluator']=='Order-What are my delivery / payment options?-Informed customer of payment options')?'selected':'' ?> >Order-What are my delivery / payment options?-Informed customer of payment options</option>
											<option value='Other-I want Compensation-Transferred call to supervisor' <?= ($ajio['tagging_evaluator']=='Other-I want Compensation-Transferred call to supervisor')?'selected':'' ?> >Other-I want Compensation-Transferred call to supervisor</option>
											<option value='Order-I want to modify my order (ph/addr etc)-Modified Ph. No. /Address on CS Cockpit' <?= ($ajio['tagging_evaluator']=='Order-I want to modify my order (ph/addr etc)-Modified Ph. No. /Address on CS Cockpit')?'selected':'' ?> >Order-I want to modify my order (ph/addr etc)-Modified Ph. No. /Address on CS Cockpit</option>
											<option value='Order-What are the payment modes?-Informed customer of payment options' <?= ($ajio['tagging_evaluator']=='Order-What are the payment modes?-Informed customer of payment options')?'selected':'' ?> >Order-What are the payment modes?-Informed customer of payment options</option>
											<option value='Other-I need to speak in regional language-Transferred call to other champ' <?= ($ajio['tagging_evaluator']=='Other-I need to speak in regional language-Transferred call to other champ')?'selected':'' ?> >Other-I need to speak in regional language-Transferred call to other champ</option>
											<option value='Other-I want to know more about an offer/promotion-Explained that there is no current promotion at AJIO' <?= ($ajio['tagging_evaluator']=='Other-I want to know more about an offer/promotion-Explained that there is no current promotion at AJIO')?'selected':'' ?> >Other-I want to know more about an offer/promotion-Explained that there is no current promotion at AJIO</option>
											<option value='Order-I want to modify my order (ph/addr etc)-Guided customer to modify details on website/app' <?= ($ajio['tagging_evaluator']=='Order-I want to modify my order (ph/addr etc)-Guided customer to modify details on website/app')?'selected':'' ?> >Order-I want to modify my order (ph/addr etc)-Guided customer to modify details on website/app</option>
											<option value='Other-I want to know more about an offer/promotion-Explained the promotion to customer' <?= ($ajio['tagging_evaluator']=='Other-I want to know more about an offer/promotion-Explained the promotion to customer')?'selected':'' ?> >Other-I want to know more about an offer/promotion-Explained the promotion to customer</option>
											<option value='Post Sales Service-Product not working as described after returns period-Guided customer to service Centre' <?= ($ajio['tagging_evaluator']=='Post Sales Service-Product not working as described after returns period-Guided customer to service Centre')?'selected':'' ?> >Post Sales Service-Product not working as described after returns period-Guided customer to service Centre</option>
											<option value='Other-I need to talk to a supervisor-Transferred call to supervisor' <?= ($ajio['tagging_evaluator']=='Other-I need to talk to a supervisor-Transferred call to supervisor')?'selected':'' ?> >Other-I need to talk to a supervisor-Transferred call to supervisor</option>
											<option value='Order-What are my delivery / payment options?-Informed customer of serviceability' <?= ($ajio['tagging_evaluator']=='Order-What are my delivery / payment options?-Informed customer of serviceability')?'selected':'' ?> >Order-What are my delivery / payment options?-Informed customer of serviceability</option>
											<option value='Order-I want my Invoice-Emailed Invoice to the customer' <?= ($ajio['tagging_evaluator']=='Order-I want my Invoice-Emailed Invoice to the customer')?'selected':'' ?> >Order-I want my Invoice-Emailed Invoice to the customer</option>
											<option value='Other-I need to speak in regional language-Informed about non-availability' <?= ($ajio['tagging_evaluator']=='Other-I need to speak in regional language-Informed about non-availability')?'selected':'' ?> >Other-I need to speak in regional language-Informed about non-availability</option>
											<option value='Order-I had a problem while placing an order-Placed an order through CS Cockpit' <?= ($ajio['tagging_evaluator']=='Order-I had a problem while placing an order-Placed an order through CS Cockpit')?'selected':'' ?> >Order-I had a problem while placing an order-Placed an order through CS Cockpit</option>
											<option value='Order-I had a problem while placing an order-Clarified that order was processed.' <?= ($ajio['tagging_evaluator']=='Order-I had a problem while placing an order-Clarified that order was processed.')?'selected':'' ?> >Order-I had a problem while placing an order-Clarified that order was processed.</option>
											<option value='Pre Order - F&L-Where can i find this product?-Helped customer to find the product' <?= ($ajio['tagging_evaluator']=='Pre Order - F&L-Where can i find this product?-Helped customer to find the product')?'selected':'' ?> >Pre Order - F&L-Where can i find this product?-Helped customer to find the product</option>
											<option value='Pre Order - F&L-Where can i find this product?-Informed customer that the product is not in stock' <?= ($ajio['tagging_evaluator']=='Pre Order - F&L-Where can i find this product?-Informed customer that the product is not in stock')?'selected':'' ?> >Pre Order - F&L-Where can i find this product?-Informed customer that the product is not in stock</option>
											<option value='Pre Order - Tech Related - Mobile / Iphone-Product not working as described after returns period-Guided customer to service Centre' <?= ($ajio['tagging_evaluator']=='Pre Order - Tech Related - Mobile / Iphone-Product not working as described after returns period-Guided customer to service Centre')?'selected':'' ?> >Pre Order - Tech Related - Mobile / Iphone-Product not working as described after returns period-Guided customer to service Centre</option>
											<option value='Order-I want to place an order-Guided customer on placing an order on website/app' <?= ($ajio['tagging_evaluator']=='Order-I want to place an order-Guided customer on placing an order on website/app')?'selected':'' ?> >Order-I want to place an order-Guided customer on placing an order on website/app</option>
											<option value='Order-I had a problem while placing an order-Helped the customer to place the order on website/app' <?= ($ajio['tagging_evaluator']=='Order-I had a problem while placing an order-Helped the customer to place the order on website/app')?'selected':'' ?> >Order-I had a problem while placing an order-Helped the customer to place the order on website/app</option>
											<option value='Pre Order - F&L-I need warranty information-Provided Information' <?= ($ajio['tagging_evaluator']=='Pre Order - F&L-I need warranty information-Provided Information')?'selected':'' ?> >Pre Order - F&L-I need warranty information-Provided Information</option>
											<option value='Pre Order - Tech Related - Mobile / Iphone-I need warranty information-Provided Information' <?= ($ajio['tagging_evaluator']=='Pre Order - Tech Related - Mobile / Iphone-I need warranty information-Provided Information')?'selected':'' ?> >Pre Order - Tech Related - Mobile / Iphone-I need warranty information-Provided Information</option>
											<option value='Pre Order - Tech Related - Jio Fi-Where can I buy Accessory-Provided Information' <?= ($ajio['tagging_evaluator']=='Pre Order - Tech Related - Jio Fi-Where can I buy Accessory-Provided Information')?'selected':'' ?> >Pre Order - Tech Related - Jio Fi-Where can I buy Accessory-Provided Information</option>
											<option value='Pre Order - Tech Related - Mobile / Iphone-Where can I buy Accessory-Provided Information' <?= ($ajio['tagging_evaluator']=='Pre Order - Tech Related - Mobile / Iphone-Where can I buy Accessory-Provided Information')?'selected':'' ?> >Pre Order - Tech Related - Mobile / Iphone-Where can I buy Accessory-Provided Information</option>
											<option value='Pre Order - Tech Related - Mobile / Iphone-Where can i find this product?-Informed customer that the product is not in stock' <?= ($ajio['tagging_evaluator']=='Pre Order - Tech Related - Mobile / Iphone-Where can i find this product?-Informed customer that the product is not in stock')?'selected':'' ?> >Pre Order - Tech Related - Mobile / Iphone-Where can i find this product?-Informed customer that the product is not in stock</option>
											<option value='Pre Order - Tech Related - Jio Fi-I need warranty information-Provided Information' <?= ($ajio['tagging_evaluator']=='Pre Order - Tech Related - Jio Fi-I need warranty information-Provided Information')?'selected':'' ?> >Pre Order - Tech Related - Jio Fi-I need warranty information-Provided Information</option>
											<option value='Pre Order - Tech Related - Others-Product not working as described after returns period-Guided customer to service Centre' <?= ($ajio['tagging_evaluator']=='Pre Order - Tech Related - Others-Product not working as described after returns period-Guided customer to service Centre')?'selected':'' ?> >Pre Order - Tech Related - Others-Product not working as described after returns period-Guided customer to service Centre</option>
											<option value='Pre Order - Tech Related - Others-Where can i find this product?-Helped customer to find the product' <?= ($ajio['tagging_evaluator']=='Pre Order - Tech Related - Others-Where can i find this product?-Helped customer to find the product')?'selected':'' ?> >Pre Order - Tech Related - Others-Where can i find this product?-Helped customer to find the product</option>
											<option value='Pre Order - Tech Related - Others-Where can I buy Accessory-Provided Information' <?= ($ajio['tagging_evaluator']=='Pre Order - Tech Related - Others-Where can I buy Accessory-Provided Information')?'selected':'' ?> >Pre Order - Tech Related - Others-Where can I buy Accessory-Provided Information</option>
											<option value='Price-Whats the price for this order?-Informed customer about cost split' <?= ($ajio['tagging_evaluator']=='Price-Whats the price for this order?-Informed customer about cost split')?'selected':'' ?> >Price-Whats the price for this order?-Informed customer about cost split</option>
											<option value='Price-How much does Gift Wrap cost?-Guided customer on gift wrap charges' <?= ($ajio['tagging_evaluator']=='Price-How much does Gift Wrap cost?-Guided customer on gift wrap charges')?'selected':'' ?> >Price-How much does Gift Wrap cost?-Guided customer on gift wrap charges</option>
											<option value='Refund-Where is my Refund?-Informed customer about self-ship status' <?= ($ajio['tagging_evaluator']=='Refund-Where is my Refund?-Informed customer about self-ship status')?'selected':'' ?> >Refund-Where is my Refund?-Informed customer about self-ship status</option>
											<option value='Refund-How do I get my money back?-Informed customer about COD refund' <?= ($ajio['tagging_evaluator']=='Refund-How do I get my money back?-Informed customer about COD refund')?'selected':'' ?> >Refund-How do I get my money back?-Informed customer about COD refund</option>
											<option value='Refund-How do I get my money back?-Informed Customer about IMPS procedure' <?= ($ajio['tagging_evaluator']=='Refund-How do I get my money back?-Informed Customer about IMPS procedure')?'selected':'' ?> >Refund-How do I get my money back?-Informed Customer about IMPS procedure</option>
											<option value='Refund-How long does it take to reflect in account once Refund is initiated?-Informed customer of time to refund' <?= ($ajio['tagging_evaluator']=='Refund-How long does it take to reflect in account once Refund is initiated?-Informed customer of time to refund')?'selected':'' ?> >Refund-How long does it take to reflect in account once Refund is initiated?-Informed customer of time to refund</option>
											<option value='Refund-Enable my IMPS Refund-Enabled the IMPS switch' <?= ($ajio['tagging_evaluator']=='Refund-Enable my IMPS Refund-Enabled the IMPS switch')?'selected':'' ?> >Refund-Enable my IMPS Refund-Enabled the IMPS switch</option>
											<option value='Refund-My refund hasnt reflected in source account-Provided Reference No. for CC/DC/NB' <?= ($ajio['tagging_evaluator']=='Refund-My refund hasnt reflected in source account-Provided Reference No. for CC/DC/NB')?'selected':'' ?> >Refund-My refund hasnt reflected in source account-Provided Reference No. for CC/DC/NB</option>
											<option value='Refund-Where is my Refund?-JioMoney refund is processed - informed to wait for 2 business days' <?= ($ajio['tagging_evaluator']=='Refund-Where is my Refund?-JioMoney refund is processed - informed to wait for 2 business days')?'selected':'' ?> >Refund-Where is my Refund?-JioMoney refund is processed - informed to wait for 2 business days</option>
											<option value='Refund-My refund hasnt reflected in source account-Provided Reference No. for e-wallets' <?= ($ajio['tagging_evaluator']=='Refund-My refund hasnt reflected in source account-Provided Reference No. for e-wallets')?'selected':'' ?> >Refund-My refund hasnt reflected in source account-Provided Reference No. for e-wallets</option>
											<option value='Refund-Where is my Refund?-Informed about Refund TAT' <?= ($ajio['tagging_evaluator']=='Refund-Where is my Refund?-Informed about Refund TAT')?'selected':'' ?> >Refund-Where is my Refund?-Informed about Refund TAT</option>
											<option value='Refund-Where is my Refund?-Prepaid refund is processed - informed to wait for 5-7 business days' <?= ($ajio['tagging_evaluator']=='Refund-Where is my Refund?-Prepaid refund is processed - informed to wait for 5-7 business days')?'selected':'' ?> >Refund-Where is my Refund?-Prepaid refund is processed - informed to wait for 5-7 business days</option>
											<option value='Refund-How do I get my money back?-Informed customer about Wallet Refund' <?= ($ajio['tagging_evaluator']=='Refund-How do I get my money back?-Informed customer about Wallet Refund')?'selected':'' ?> >Refund-How do I get my money back?-Informed customer about Wallet Refund</option>
											<option value='Refund-Where is my Refund?-IMPS refund is processed - informed to wait for 1 business day' <?= ($ajio['tagging_evaluator']=='Refund-Where is my Refund?-IMPS refund is processed - informed to wait for 1 business day')?'selected':'' ?> >Refund-Where is my Refund?-IMPS refund is processed - informed to wait for 1 business day</option>
											<option value='Refund-How do I get my money back?-Informed customer about Prepaid Refund' <?= ($ajio['tagging_evaluator']=='Refund-How do I get my money back?-Informed customer about Prepaid Refund')?'selected':'' ?> >Refund-How do I get my money back?-Informed customer about Prepaid Refund</option>
											<option value='Refund-There is a discrepancy with my store credits-Clarified discrepancy with customer' <?= ($ajio['tagging_evaluator']=='Refund-There is a discrepancy with my store credits-Clarified discrepancy with customer')?'selected':'' ?> >Refund-There is a discrepancy with my store credits-Clarified discrepancy with customer</option>
											<option value='Refund-My refund hasnt reflected in source account-Provided reference number for IMPS' <?= ($ajio['tagging_evaluator']=='Refund-My refund hasnt reflected in source account-Provided reference number for IMPS')?'selected':'' ?> >Refund-My refund hasnt reflected in source account-Provided reference number for IMPS</option>
											<option value='Return/Exchange-Create a return for me-Created Return - Received Damaged Product' <?= ($ajio['tagging_evaluator']=='Return/Exchange-Create a return for me-Created Return - Received Damaged Product')?'selected':'' ?> >Return/Exchange-Create a return for me-Created Return - Received Damaged Product</option>
											<option value='Return/Exchange-Create a return for me-Created Return - Different Product delivered' <?= ($ajio['tagging_evaluator']=='Return/Exchange-Create a return for me-Created Return - Different Product delivered')?'selected':'' ?> >Return/Exchange-Create a return for me-Created Return - Different Product delivered</option>
											<option value='Return/Exchange-Create a return for me-Created Return - Wrong size delivered' <?= ($ajio['tagging_evaluator']=='Return/Exchange-Create a return for me-Created Return - Wrong size delivered')?'selected':'' ?> >Return/Exchange-Create a return for me-Created Return - Wrong size delivered</option>
											<option value='Return/Exchange-Create a return for me-Created Return - Product damaged post usage' <?= ($ajio['tagging_evaluator']=='Return/Exchange-Create a return for me-Created Return - Product damaged post usage')?'selected':'' ?> >Return/Exchange-Create a return for me-Created Return - Product damaged post usage</option>
											<option value='Refund-Why is my return rejected/put on hold?-Guided customer on reason' <?= ($ajio['tagging_evaluator']=='Refund-Why is my return rejected/put on hold?-Guided customer on reason')?'selected':'' ?> >Refund-Why is my return rejected/put on hold?-Guided customer on reason</option>
											<option value='Return/Exchange-Create a return for me-Defective Product received' <?= ($ajio['tagging_evaluator']=='Return/Exchange-Create a return for me-Defective Product received')?'selected':'' ?> >Return/Exchange-Create a return for me-Defective Product received</option>
											<option value='Return/Exchange-Create a return for me-Created Return for customer' <?= ($ajio['tagging_evaluator']=='Return/Exchange-Create a return for me-Created Return for customer')?'selected':'' ?> >Return/Exchange-Create a return for me-Created Return for customer</option>
											<option value='Return/Exchange-Create a return for me-Wrong Product delivered' <?= ($ajio['tagging_evaluator']=='Return/Exchange-Create a return for me-Wrong Product delivered')?'selected':'' ?> >Return/Exchange-Create a return for me-Wrong Product delivered</option>
											<option value='Return/Exchange-Create a return for me-Created Return for Used Product' <?= ($ajio['tagging_evaluator']=='Return/Exchange-Create a return for me-Created Return for Used Product')?'selected':'' ?> >Return/Exchange-Create a return for me-Created Return for Used Product</option>
											<option value='Return/Exchange-Create a return for me-Seal tampered cases' <?= ($ajio['tagging_evaluator']=='Return/Exchange-Create a return for me-Seal tampered cases')?'selected':'' ?> >Return/Exchange-Create a return for me-Seal tampered cases</option>
											<option value='Return/Exchange-Create an Exchange for me-Created Exchange for customer' <?= ($ajio['tagging_evaluator']=='Return/Exchange-Create an Exchange for me-Created Exchange for customer')?'selected':'' ?> >Return/Exchange-Create an Exchange for me-Created Exchange for customer</option>
											<option value='Return/Exchange-Create a return for me-Created Return - Wrong colour delivered' <?= ($ajio['tagging_evaluator']=='Return/Exchange-Create a return for me-Created Return - Wrong colour delivered')?'selected':'' ?> >Return/Exchange-Create a return for me-Created Return - Wrong colour delivered</option>
											<option value='Return/Exchange-Create an Exchange for me-Created Exchange – Received Damaged Product' <?= ($ajio['tagging_evaluator']=='Return/Exchange-Create an Exchange for me-Created Exchange – Received Damaged Product')?'selected':'' ?> >Return/Exchange-Create an Exchange for me-Created Exchange – Received Damaged Product</option>
											<option value='Return/Exchange-Create an Exchange for me-Created Return due to lack of size' <?= ($ajio['tagging_evaluator']=='Return/Exchange-Create an Exchange for me-Created Return due to lack of size')?'selected':'' ?> >Return/Exchange-Create an Exchange for me-Created Return due to lack of size</option>
											<option value='Return/Exchange-Has my Self-Ship Return reached you?-Asked to check with customers courier company' <?= ($ajio['tagging_evaluator']=='Return/Exchange-Has my Self-Ship Return reached you?-Asked to check with customers courier company')?'selected':'' ?> >Return/Exchange-Has my Self-Ship Return reached you?-Asked to check with customers courier company</option>
											<option value='Return/Exchange-Has my Self-Ship Return reached you?-Informed - Reached Warehouse and Refund pending' <?= ($ajio['tagging_evaluator']=='Return/Exchange-Has my Self-Ship Return reached you?-Informed - Reached Warehouse and Refund pending')?'selected':'' ?> >Return/Exchange-Has my Self-Ship Return reached you?-Informed - Reached Warehouse and Refund pending</option>
											<option value='Return/Exchange-Exchange Related-Informed – product will get exchanged' <?= ($ajio['tagging_evaluator']=='Return/Exchange-Exchange Related-Informed – product will get exchanged')?'selected':'' ?> >Return/Exchange-Exchange Related-Informed – product will get exchanged</option>
											<option value='Return/Exchange-Create a return for me-Empty Parcel received' <?= ($ajio['tagging_evaluator']=='Return/Exchange-Create a return for me-Empty Parcel received')?'selected':'' ?> >Return/Exchange-Create a return for me-Empty Parcel received</option>
											<option value='Return/Exchange-Has my Self-Ship Return reached you?-Others' <?= ($ajio['tagging_evaluator']=='Return/Exchange-Has my Self-Ship Return reached you?-Others')?'selected':'' ?> >Return/Exchange-Has my Self-Ship Return reached you?-Others</option>
											<option value='Return/Exchange-Create a return for me-Created Return - Tags/Shoebox missing' <?= ($ajio['tagging_evaluator']=='Return/Exchange-Create a return for me-Created Return - Tags/Shoebox missing')?'selected':'' ?> >Return/Exchange-Create a return for me-Created Return - Tags/Shoebox missing</option>
											<option value='Return/Exchange-Has my Self-Ship Return reached you?-Informed - Reached Warehouse and Refund initiated' <?= ($ajio['tagging_evaluator']=='Return/Exchange-Has my Self-Ship Return reached you?-Informed - Reached Warehouse and Refund initiated')?'selected':'' ?> >Return/Exchange-Has my Self-Ship Return reached you?-Informed - Reached Warehouse and Refund initiated</option>
											<option value='Return/Exchange-Customer claiming product picked up-Asked to share acknowledgement copy' <?= ($ajio['tagging_evaluator']=='Return/Exchange-Customer claiming product picked up-Asked to share acknowledgement copy')?'selected':'' ?> >Return/Exchange-Customer claiming product picked up-Asked to share acknowledgement copy</option>
											<option value='Return/Exchange-How do I return/exchange this item?-Declined - Time Period lapsed' <?= ($ajio['tagging_evaluator']=='Return/Exchange-How do I return/exchange this item?-Declined - Time Period lapsed')?'selected':'' ?> >Return/Exchange-How do I return/exchange this item?-Declined - Time Period lapsed</option>
											<option value='Return/Exchange-How do I return/exchange this item?-Email sent to confirm policy - Fitment Issue' <?= ($ajio['tagging_evaluator']=='Return/Exchange-How do I return/exchange this item?-Email sent to confirm policy - Fitment Issue')?'selected':'' ?> >Return/Exchange-How do I return/exchange this item?-Email sent to confirm policy - Fitment Issue</option>
											<option value='Return/Exchange-How do I return/exchange this item?-Informed Return Policy - others' <?= ($ajio['tagging_evaluator']=='Return/Exchange-How do I return/exchange this item?-Informed Return Policy - others')?'selected':'' ?> >Return/Exchange-How do I return/exchange this item?-Informed Return Policy - others</option>
											<option value='Return/Exchange-Has my Self-Ship Return reached you?-Updated tracking number for the customer' <?= ($ajio['tagging_evaluator']=='Return/Exchange-Has my Self-Ship Return reached you?-Updated tracking number for the customer')?'selected':'' ?> >Return/Exchange-Has my Self-Ship Return reached you?-Updated tracking number for the customer</option>
											<option value='Return/Exchange-How do I return/exchange this item?-Educated Customer on Exchange Policy' <?= ($ajio['tagging_evaluator']=='Return/Exchange-How do I return/exchange this item?-Educated Customer on Exchange Policy')?'selected':'' ?> >Return/Exchange-How do I return/exchange this item?-Educated Customer on Exchange Policy</option>
											<option value='Return/Exchange-How do I return/exchange this item?-Declined - Product Used' <?= ($ajio['tagging_evaluator']=='Return/Exchange-How do I return/exchange this item?-Declined - Product Used')?'selected':'' ?> >Return/Exchange-How do I return/exchange this item?-Declined - Product Used</option>
											<option value='Return/Exchange-How do I return/exchange this item?-Declined - Non returnable product' <?= ($ajio['tagging_evaluator']=='Return/Exchange-How do I return/exchange this item?-Declined - Non returnable product')?'selected':'' ?> >Return/Exchange-How do I return/exchange this item?-Declined - Non returnable product</option>
											<option value='Return/Exchange-How do I return/exchange this item?-Declined – Non exchangeable product' <?= ($ajio['tagging_evaluator']=='Return/Exchange-How do I return/exchange this item?-Declined – Non exchangeable product')?'selected':'' ?> >Return/Exchange-How do I return/exchange this item?-Declined – Non exchangeable product</option>
											<option value='Return/Exchange-How do I return/exchange this item?-Declined - tags/shoebox missing' <?= ($ajio['tagging_evaluator']=='Return/Exchange-How do I return/exchange this item?-Declined - tags/shoebox missing')?'selected':'' ?> >Return/Exchange-How do I return/exchange this item?-Declined - tags/shoebox missing</option>
											<option value='Return/Exchange-How do I return/exchange this item?-Requested image for wrong product delivered' <?= ($ajio['tagging_evaluator']=='Return/Exchange-How do I return/exchange this item?-Requested image for wrong product delivered')?'selected':'' ?> >Return/Exchange-How do I return/exchange this item?-Requested image for wrong product delivered</option>
											<option value='Return/Exchange-How do I return/exchange this item?-Email sent to confirm policy - Didnt like product' <?= ($ajio['tagging_evaluator']=='Return/Exchange-How do I return/exchange this item?-Email sent to confirm policy - Didnt like product')?'selected':'' ?> >Return/Exchange-How do I return/exchange this item?-Email sent to confirm policy - Didnt like product</option>
											<option value='Return/Exchange-Unable to create return on website/mobile-Created Return for customer' <?= ($ajio['tagging_evaluator']=='Return/Exchange-Unable to create return on website/mobile-Created Return for customer')?'selected':'' ?> >Return/Exchange-Unable to create return on website/mobile-Created Return for customer</option>
											<option value='Return/Exchange-How do I return/exchange this item?-Educated customer on Self Service steps' <?= ($ajio['tagging_evaluator']=='Return/Exchange-How do I return/exchange this item?-Educated customer on Self Service steps')?'selected':'' ?> >Return/Exchange-How do I return/exchange this item?-Educated customer on Self Service steps</option>
											<option value='Return/Exchange-How do I return/exchange this item?-Informed Return Policy - products' <?= ($ajio['tagging_evaluator']=='Return/Exchange-How do I return/exchange this item?-Informed Return Policy - products')?'selected':'' ?> >Return/Exchange-How do I return/exchange this item?-Informed Return Policy - products</option>
											<option value='Return/Exchange-Pickup related-Provided shipping address' <?= ($ajio['tagging_evaluator']=='Return/Exchange-Pickup related-Provided shipping address')?'selected':'' ?> >Return/Exchange-Pickup related-Provided shipping address</option>
											<option value='Return/Exchange-Pickup related-Informed - Reached WH and Refund initiated' <?= ($ajio['tagging_evaluator']=='Return/Exchange-Pickup related-Informed - Reached WH and Refund initiated')?'selected':'' ?> >Return/Exchange-Pickup related-Informed - Reached WH and Refund initiated</option>
											<option value='Return/Exchange-Pickup related-Others' <?= ($ajio['tagging_evaluator']=='Return/Exchange-Pickup related-Others')?'selected':'' ?> >Return/Exchange-Pickup related-Others</option>
											<option value='Return/Exchange-Pickup related-Provided information on packing product' <?= ($ajio['tagging_evaluator']=='Return/Exchange-Pickup related-Provided information on packing product')?'selected':'' ?> >Return/Exchange-Pickup related-Provided information on packing product</option>
											<option value='Return/Exchange-Pickup related-Informed - product will be picked up' <?= ($ajio['tagging_evaluator']=='Return/Exchange-Pickup related-Informed - product will be picked up')?'selected':'' ?> >Return/Exchange-Pickup related-Informed - product will be picked up</option>
											<option value='Return/Exchange-Pickup related-Informed - picked up product still has to reach Warehouse' <?= ($ajio['tagging_evaluator']=='Return/Exchange-Pickup related-Informed - picked up product still has to reach Warehouse')?'selected':'' ?> >Return/Exchange-Pickup related-Informed - picked up product still has to reach Warehouse</option>
											<option value='Return/Exchange-Is my pin code serviceable for Exchange/Return?-Explained pin-code Serviceability' <?= ($ajio['tagging_evaluator']=='Return/Exchange-Is my pin code serviceable for Exchange/Return?-Explained pin-code Serviceability')?'selected':'' ?> >Return/Exchange-Is my pin code serviceable for Exchange/Return?-Explained pin-code Serviceability</option>
											<option value='Website-Access/Function-Helped in returning order' <?= ($ajio['tagging_evaluator']=='Website-Access/Function-Helped in returning order')?'selected':'' ?> >Website-Access/Function-Helped in returning order</option>
											<option value='Website-Access/Function-Helped in accessing page/site' <?= ($ajio['tagging_evaluator']=='Website-Access/Function-Helped in accessing page/site')?'selected':'' ?> >Website-Access/Function-Helped in accessing page/site</option>
											<option value='Ticket-Cx-Shared attachment-Cx-Shared attachment' <?= ($ajio['tagging_evaluator']=='Ticket-Cx-Shared attachment-Cx-Shared attachment')?'selected':'' ?> >Ticket-Cx-Shared attachment-Cx-Shared attachment</option>
											<option value='Website-Access/Function-Helped in viewing account details' <?= ($ajio['tagging_evaluator']=='Website-Access/Function-Helped in viewing account details')?'selected':'' ?> >Website-Access/Function-Helped in viewing account details</option>
											<option value='Website-Access/Function-Helped in cancelling order' <?= ($ajio['tagging_evaluator']=='Website-Access/Function-Helped in cancelling order')?'selected':'' ?> >Website-Access/Function-Helped in cancelling order</option>
											<option value='Website-Access/Function-Helped in signup/login' <?= ($ajio['tagging_evaluator']=='Website-Access/Function-Helped in signup/login')?'selected':'' ?> >Website-Access/Function-Helped in signup/login</option>
											<option value='Website-How to shop on App?-Guided customer to visit the App' <?= ($ajio['tagging_evaluator']=='Website-How to shop on App?-Guided customer to visit the App')?'selected':'' ?> >Website-How to shop on App?-Guided customer to visit the App</option>
											<option value='Website-How to shop on m-site?-Guided customer to visit the mobile site' <?= ($ajio['tagging_evaluator']=='Website-How to shop on m-site?-Guided customer to visit the mobile site')?'selected':'' ?> >Website-How to shop on m-site?-Guided customer to visit the mobile site</option>
											<option value='OB-Delayed Delivery-To Be Delivered' <?= ($ajio['tagging_evaluator']=='OB-Delayed Delivery-To Be Delivered')?'selected':'' ?> >OB-Delayed Delivery-To Be Delivered</option>
											<option value='OB-Delayed Delivery-Not Connected' <?= ($ajio['tagging_evaluator']=='OB-Delayed Delivery-Not Connected')?'selected':'' ?> >OB-Delayed Delivery-Not Connected</option>
											<option value='OB-Delayed Delivery-Delivered' <?= ($ajio['tagging_evaluator']=='OB-Delayed Delivery-Delivered')?'selected':'' ?> >OB-Delayed Delivery-Delivered</option>
											<option value='OB-Delayed Delivery-RTO' <?= ($ajio['tagging_evaluator']=='OB-Delayed Delivery-RTO')?'selected':'' ?> >OB-Delayed Delivery-RTO</option>
											<option value='Website-Please explain AJIO-Explained about website' <?= ($ajio['tagging_evaluator']=='Website-Please explain AJIO-Explained about website')?'selected':'' ?> >Website-Please explain AJIO-Explained about website</option>
											<option value='OB-Order In Progress-Not Connected' <?= ($ajio['tagging_evaluator']=='OB-Order In Progress-Not Connected')?'selected':'' ?> >OB-Order In Progress-Not Connected</option>
											<option value='OB-NDR-Delivered' <?= ($ajio['tagging_evaluator']=='OB-NDR-Delivered')?'selected':'' ?> >OB-NDR-Delivered</option>
											<option value='OB-Misc-Informed' <?= ($ajio['tagging_evaluator']=='OB-Misc-Informed')?'selected':'' ?> >OB-Misc-Informed</option>
											<option value='OB-NDR-To Be Delivered' <?= ($ajio['tagging_evaluator']=='OB-NDR-To Be Delivered')?'selected':'' ?> >OB-NDR-To Be Delivered</option>
											<option value='OB-Misc-Not Connected' <?= ($ajio['tagging_evaluator']=='OB-Misc-Not Connected')?'selected':'' ?> >OB-Misc-Not Connected</option>
											<option value='OB-Order In Progress-MRP Mismatch - Credit' <?= ($ajio['tagging_evaluator']=='OB-Order In Progress-MRP Mismatch - Credit')?'selected':'' ?> >OB-Order In Progress-MRP Mismatch - Credit</option>
											<option value='OB-Order In Progress-MRP Mismatch - Waiver' <?= ($ajio['tagging_evaluator']=='OB-Order In Progress-MRP Mismatch - Waiver')?'selected':'' ?> >OB-Order In Progress-MRP Mismatch - Waiver</option>
											<option value='OB-Order In Progress-Short Pick - Partially Cancelled' <?= ($ajio['tagging_evaluator']=='OB-Order In Progress-Short Pick - Partially Cancelled')?'selected':'' ?> >OB-Order In Progress-Short Pick - Partially Cancelled</option>
											<option value='OB-Order In Progress-MRP Mismatch - Cancelled' <?= ($ajio['tagging_evaluator']=='OB-Order In Progress-MRP Mismatch - Cancelled')?'selected':'' ?> >OB-Order In Progress-MRP Mismatch - Cancelled</option>
											<option value='OB-Order In Progress-Sales Tax - To be RTOed' <?= ($ajio['tagging_evaluator']=='OB-Order In Progress-Sales Tax - To be RTOed')?'selected':'' ?> >OB-Order In Progress-Sales Tax - To be RTOed</option>
											<option value='OB-Order In Progress-Sales Tax - To be delivered' <?= ($ajio['tagging_evaluator']=='OB-Order In Progress-Sales Tax - To be delivered')?'selected':'' ?> >OB-Order In Progress-Sales Tax - To be delivered</option>
											<option value='OB-Order In Progress-Order Lost - Informed' <?= ($ajio['tagging_evaluator']=='OB-Order In Progress-Order Lost - Informed')?'selected':'' ?> >OB-Order In Progress-Order Lost - Informed</option>
											<option value='OB-Callback-Not Connected' <?= ($ajio['tagging_evaluator']=='OB-Callback-Not Connected')?'selected':'' ?> >OB-Callback-Not Connected</option>
											<option value='OB-Ticket-Not Connected' <?= ($ajio['tagging_evaluator']=='OB-Ticket-Not Connected')?'selected':'' ?> >OB-Ticket-Not Connected</option>
											<option value='OB-Order In Progress-Telesales - Cancelled' <?= ($ajio['tagging_evaluator']=='OB-Order In Progress-Telesales - Cancelled')?'selected':'' ?> >OB-Order In Progress-Telesales - Cancelled</option>
											<option value='OB-Order In Progress-OOS - Informed' <?= ($ajio['tagging_evaluator']=='OB-Order In Progress-OOS - Informed')?'selected':'' ?> >OB-Order In Progress-OOS - Informed</option>
											<option value='OB-Order In Progress-Short Pick - Cancelled' <?= ($ajio['tagging_evaluator']=='OB-Order In Progress-Short Pick - Cancelled')?'selected':'' ?> >OB-Order In Progress-Short Pick - Cancelled</option>
											<option value='OB-Cancellation due to QC fail-Not Connected' <?= ($ajio['tagging_evaluator']=='OB-Cancellation due to QC fail-Not Connected')?'selected':'' ?> >OB-Cancellation due to QC fail-Not Connected</option>
											<option value='OB-Ticket-Ticket Created' <?= ($ajio['tagging_evaluator']=='OB-Ticket-Ticket Created')?'selected':'' ?> >OB-Ticket-Ticket Created</option>
											<option value='OB-Cancellation due to QC fail-Informed' <?= ($ajio['tagging_evaluator']=='OB-Cancellation due to QC fail-Informed')?'selected':'' ?> >OB-Cancellation due to QC fail-Informed</option>
											<option value='OB-Survey-Not Connected' <?= ($ajio['tagging_evaluator']=='OB-Survey-Not Connected')?'selected':'' ?> >OB-Survey-Not Connected</option>
											<option value='OB-Ticket-Ticket Escalation' <?= ($ajio['tagging_evaluator']=='OB-Ticket-Ticket Escalation')?'selected':'' ?> >OB-Ticket-Ticket Escalation</option>
											<option value='OB-Ticket-Ticket Closed' <?= ($ajio['tagging_evaluator']=='OB-Ticket-Ticket Closed')?'selected':'' ?> >OB-Ticket-Ticket Closed</option>
											<option value='OB-Ticket-Ticket Follow Up' <?= ($ajio['tagging_evaluator']=='OB-Ticket-Ticket Follow Up')?'selected':'' ?> >OB-Ticket-Ticket Follow Up</option>
											<option value='OB-Survey-Incomplete Survey' <?= ($ajio['tagging_evaluator']=='OB-Survey-Incomplete Survey')?'selected':'' ?> >OB-Survey-Incomplete Survey</option>
											<option value='OB-NDR-To Be Delivered - Fake Remarks' <?= ($ajio['tagging_evaluator']=='OB-NDR-To Be Delivered - Fake Remarks')?'selected':'' ?> >OB-NDR-To Be Delivered - Fake Remarks</option>
											<option value='OB-Survey-Completed' <?= ($ajio['tagging_evaluator']=='OB-Survey-Completed')?'selected':'' ?> >OB-Survey-Completed</option>
											<option value='OB-NDR-Not Contactable2' <?= ($ajio['tagging_evaluator']=='OB-NDR-Not Contactable2')?'selected':'' ?> >OB-NDR-Not Contactable2</option>
											<option value='OB-NDR-Not Contactable1' <?= ($ajio['tagging_evaluator']=='OB-NDR-Not Contactable1')?'selected':'' ?> >OB-NDR-Not Contactable1</option>
											<option value='OB-NPR-Picked Up' <?= ($ajio['tagging_evaluator']=='OB-NPR-Picked Up')?'selected':'' ?> >OB-NPR-Picked Up</option>
											<option value='OB-NPR-Not Contactable3' <?= ($ajio['tagging_evaluator']=='OB-NPR-Not Contactable3')?'selected':'' ?> >OB-NPR-Not Contactable3</option>
											<option value='OB-NPR-To Be Picked Up - Fake Remarks' <?= ($ajio['tagging_evaluator']=='OB-NPR-To Be Picked Up - Fake Remarks')?'selected':'' ?> >OB-NPR-To Be Picked Up - Fake Remarks</option>
											<option value='OB-NPR-Pickup Cancelled' <?= ($ajio['tagging_evaluator']=='OB-NPR-Pickup Cancelled')?'selected':'' ?> >OB-NPR-Pickup Cancelled</option>
											<option value='OB-NPR-Not Contactable2' <?= ($ajio['tagging_evaluator']=='OB-NPR-Not Contactable2')?'selected':'' ?> >OB-NPR-Not Contactable2</option>
											<option value='OB-NPR-To Be Picked Up' <?= ($ajio['tagging_evaluator']=='OB-NPR-To Be Picked Up')?'selected':'' ?> >OB-NPR-To Be Picked Up</option>
											<option value='OB-NDR-Not Contactable3' <?= ($ajio['tagging_evaluator']=='OB-NDR-Not Contactable3')?'selected':'' ?> >OB-NDR-Not Contactable3</option>
											<option value='OB-NPR-Not Contactable1' <?= ($ajio['tagging_evaluator']=='OB-NPR-Not Contactable1')?'selected':'' ?> >OB-NPR-Not Contactable1</option>
											<option value='OB-NDR-To Be RTO - Fake Remarks' <?= ($ajio['tagging_evaluator']=='OB-NDR-To Be RTO - Fake Remarks')?'selected':'' ?> >OB-NDR-To Be RTO - Fake Remarks</option>
											<option value='OB-NDR-To Be RTO' <?= ($ajio['tagging_evaluator']=='OB-NDR-To Be RTO')?'selected':'' ?> >OB-NDR-To Be RTO</option>
											<option value='Feedback-Others-N/A' <?= ($ajio['tagging_evaluator']=='Feedback-Others-N/A')?'selected':'' ?> >Feedback-Others-N/A</option>
											<option value='Feedback-Suggestions about Website-N/A' <?= ($ajio['tagging_evaluator']=='Feedback-Suggestions about Website-N/A')?'selected':'' ?> >Feedback-Suggestions about Website-N/A</option>
											<option value='Feedback-Suggestions about CC-N/A' <?= ($ajio['tagging_evaluator']=='Feedback-Suggestions about CC-N/A')?'selected':'' ?> >Feedback-Suggestions about CC-N/A</option>
											<option value='Feedback-Suggestions about Warehouse-N/A' <?= ($ajio['tagging_evaluator']=='Feedback-Suggestions about Warehouse-N/A')?'selected':'' ?> >Feedback-Suggestions about Warehouse-N/A</option>
											<option value='Feedback-Suggestions about Profile-N/A' <?= ($ajio['tagging_evaluator']=='Feedback-Suggestions about Profile-N/A')?'selected':'' ?> >Feedback-Suggestions about Profile-N/A</option>
											<option value='Feedback-Suggestions about Returns/Exchange-N/A' <?= ($ajio['tagging_evaluator']=='Feedback-Suggestions about Returns/Exchange-N/A')?'selected':'' ?> >Feedback-Suggestions about Returns/Exchange-N/A</option>
											<option value='Feedback-Suggestions about Delivery-N/A' <?= ($ajio['tagging_evaluator']=='Feedback-Suggestions about Delivery-N/A')?'selected':'' ?> >Feedback-Suggestions about Delivery-N/A</option>
											<option value='Feedback-Suggestions about CC-Unable to reach customer care number' <?= ($ajio['tagging_evaluator']=='Feedback-Suggestions about CC-Unable to reach customer care number')?'selected':'' ?> >Feedback-Suggestions about CC-Unable to reach customer care number</option>
											<option value='Feedback-Suggestions about Products-N/A' <?= ($ajio['tagging_evaluator']=='Feedback-Suggestions about Products-N/A')?'selected':'' ?> >Feedback-Suggestions about Products-N/A</option>
											<option value='Feedback-Suggestions about CC-Others' <?= ($ajio['tagging_evaluator']=='Feedback-Suggestions about CC-Others')?'selected':'' ?> >Feedback-Suggestions about CC-Others</option>
											<option value='Feedback-Suggestions about Refund-N/A' <?= ($ajio['tagging_evaluator']=='Feedback-Suggestions about Refund-N/A')?'selected':'' ?> >Feedback-Suggestions about Refund-N/A</option>
											<option value='Feedback-Mobile App-Feedback/Suggestion about mobile App' <?= ($ajio['tagging_evaluator']=='Feedback-Mobile App-Feedback/Suggestion about mobile App')?'selected':'' ?> >Feedback-Mobile App-Feedback/Suggestion about mobile App</option>
											<option value='Online Refund-Refund not done against Reference No. - Prepaid cancelled-N/A' <?= ($ajio['tagging_evaluator']=='Online Refund-Refund not done against Reference No. - Prepaid cancelled-N/A')?'selected':'' ?> >Online Refund-Refund not done against Reference No. - Prepaid cancelled-N/A</option>
											<option value='WH - Order Related Issues-Forward-Shipment Lost to be refunded' <?= ($ajio['tagging_evaluator']=='WH - Order Related Issues-Forward-Shipment Lost to be refunded')?'selected':'' ?> >WH - Order Related Issues-Forward-Shipment Lost to be refunded</option>
											<option value='Delivery-POD Required-Customer Disputes on POD Shared' <?= ($ajio['tagging_evaluator']=='Delivery-POD Required-Customer Disputes on POD Shared')?'selected':'' ?> >Delivery-POD Required-Customer Disputes on POD Shared</option>
											<option value='Delivery-Where is my Order?-Informed Order is RTOed' <?= ($ajio['tagging_evaluator']=='Delivery-Where is my Order?-Informed Order is RTOed')?'selected':'' ?> >Delivery-Where is my Order?-Informed Order is RTOed</option>
											<option value='Delivery-Where is my Order?-Informed Promised Delivery Date' <?= ($ajio['tagging_evaluator']=='Delivery-Where is my Order?-Informed Promised Delivery Date')?'selected':'' ?> >Delivery-Where is my Order?-Informed Promised Delivery Date</option>
											<option value='Delivery-Order not marked as Delivered-N/A' <?= ($ajio['tagging_evaluator']=='Delivery-Order not marked as Delivered-N/A')?'selected':'' ?> >Delivery-Order not marked as Delivered-N/A</option>
											<option value='Coupon-How do I use my Jio Prime Points?-Educated customer on Jio Prime points' <?= ($ajio['tagging_evaluator']=='Coupon-How do I use my Jio Prime Points?-Educated customer on Jio Prime points')?'selected':'' ?> >Coupon-How do I use my Jio Prime Points?-Educated customer on Jio Prime points</option>
											<option value='Return/Exchange-Is my pin code serviceable for Exchange/Return?-Informed about non availability of exchange at store' <?= ($ajio['tagging_evaluator']=='Return/Exchange-Is my pin code serviceable for Exchange/Return?-Informed about non availability of exchange at store')?'selected':'' ?> >Return/Exchange-Is my pin code serviceable for Exchange/Return?-Informed about non availability of exchange at store</option>
											<option value='Return/Exchange-Is my pin code serviceable for Exchange/Return?-Informed serviceability of drop at store for product/store' <?= ($ajio['tagging_evaluator']=='Return/Exchange-Is my pin code serviceable for Exchange/Return?-Informed serviceability of drop at store for product/store')?'selected':'' ?> >Return/Exchange-Is my pin code serviceable for Exchange/Return?-Informed serviceability of drop at store for product/store</option>
											<option value='Return/Exchange-How do I return/exchange this item?-Informed how drop at store option works' <?= ($ajio['tagging_evaluator']=='Return/Exchange-How do I return/exchange this item?-Informed how drop at store option works')?'selected':'' ?> >Return/Exchange-How do I return/exchange this item?-Informed how drop at store option works</option>
											<option value='Refund-How do I get my money back?-Informed customer about Drop at Store refund – Prepaid Order' <?= ($ajio['tagging_evaluator']=='Refund-How do I get my money back?-Informed customer about Drop at Store refund – Prepaid Order')?'selected':'' ?> >Refund-How do I get my money back?-Informed customer about Drop at Store refund – Prepaid Order</option>
											<option value='Refund-How do I get my money back?-Informed Cx about SC refund for Drop at Store' <?= ($ajio['tagging_evaluator']=='Refund-How do I get my money back?-Informed Cx about SC refund for Drop at Store')?'selected':'' ?> >Refund-How do I get my money back?-Informed Cx about SC refund for Drop at Store</option>
											<option value='Refund-How do I get my money back?-Informed Cx about cash refund for drop at store' <?= ($ajio['tagging_evaluator']=='Refund-How do I get my money back?-Informed Cx about cash refund for drop at store')?'selected':'' ?> >Refund-How do I get my money back?-Informed Cx about cash refund for drop at store</option>
											<option value='Refund-Where is my Refund?-Informed about drop at store refund TAT' <?= ($ajio['tagging_evaluator']=='Refund-Where is my Refund?-Informed about drop at store refund TAT')?'selected':'' ?> >Refund-Where is my Refund?-Informed about drop at store refund TAT</option>
											<option value='WH - Order Related Issues-Customer Return-Wrong Product Received – EAN Matched' <?= ($ajio['tagging_evaluator']=='WH - Order Related Issues-Customer Return-Wrong Product Received – EAN Matched')?'selected':'' ?> >WH - Order Related Issues-Customer Return-Wrong Product Received – EAN Matched</option>
											<option value='WH - Order Related Issues-Customer Return-Used Product Received' <?= ($ajio['tagging_evaluator']=='WH - Order Related Issues-Customer Return-Used Product Received')?'selected':'' ?> >WH - Order Related Issues-Customer Return-Used Product Received</option>
											<option value='Goodwill Request-CM insisting Compensation-Coupon Reactivation' <?= ($ajio['tagging_evaluator']=='Goodwill Request-CM insisting Compensation-Coupon Reactivation')?'selected':'' ?> >Goodwill Request-CM insisting Compensation-Coupon Reactivation</option>
											<option value='Return-Non Returnable Product-Wrong Product delivered' <?= ($ajio['tagging_evaluator']=='Return-Non Returnable Product-Wrong Product delivered')?'selected':'' ?> >Return-Non Returnable Product-Wrong Product delivered</option>
											<option value='Return-Customer Delight-N/A' <?= ($ajio['tagging_evaluator']=='Return-Customer Delight-N/A')?'selected':'' ?> >Return-Customer Delight-N/A</option>
											<option value='Delivery-Customer Delight-N/A' <?= ($ajio['tagging_evaluator']=='Delivery-Customer Delight-N/A')?'selected':'' ?> >Delivery-Customer Delight-N/A</option>
											<option value='Return-Non Returnable Product-Tags Detached but available' <?= ($ajio['tagging_evaluator']=='Return-Non Returnable Product-Tags Detached but available')?'selected':'' ?> >Return-Non Returnable Product-Tags Detached but available</option>
											<option value='Return-Non Returnable Product-Tags Not Available - Not Received' <?= ($ajio['tagging_evaluator']=='Return-Non Returnable Product-Tags Not Available - Not Received')?'selected':'' ?> >Return-Non Returnable Product-Tags Not Available - Not Received</option>
											<option value='Return-Non Returnable Product-Tags Not Available - Misplaced by customer' <?= ($ajio['tagging_evaluator']=='Return-Non Returnable Product-Tags Not Available - Misplaced by customer')?'selected':'' ?> >Return-Non Returnable Product-Tags Not Available - Misplaced by customer</option>
											<option value='Return-Non Returnable Product-Used Product Delivered' <?= ($ajio['tagging_evaluator']=='Return-Non Returnable Product-Used Product Delivered')?'selected':'' ?> >Return-Non Returnable Product-Used Product Delivered</option>
											<option value='Return-Non Returnable Product-Classified as non-returnable' <?= ($ajio['tagging_evaluator']=='Return-Non Returnable Product-Classified as non-returnable')?'selected':'' ?> >Return-Non Returnable Product-Classified as non-returnable</option>
											<option value='Return-Non Returnable Product-Return - Post Return Window' <?= ($ajio['tagging_evaluator']=='Return-Non Returnable Product-Return - Post Return Window')?'selected':'' ?> >Return-Non Returnable Product-Return - Post Return Window</option>
											<option value='Return/Exchange-How do I return/exchange this item?-Requested customer to share the images' <?= ($ajio['tagging_evaluator']=='Return/Exchange-How do I return/exchange this item?-Requested customer to share the images')?'selected':'' ?> >Return/Exchange-How do I return/exchange this item?-Requested customer to share the images</option>
											<option value='WH - Order Related Issues-Customer Return-Customer confirmation Required (Non-AJIO Product Received)' <?= ($ajio['tagging_evaluator']=='WH - Order Related Issues-Customer Return-Customer confirmation Required (Non-AJIO Product Received)')?'selected':'' ?> >WH - Order Related Issues-Customer Return-Customer confirmation Required (Non-AJIO Product Received)</option>
											<option value='WH - Order Related Issues-Customer Return-Other node shipment received' <?= ($ajio['tagging_evaluator']=='WH - Order Related Issues-Customer Return-Other node shipment received')?'selected':'' ?> >WH - Order Related Issues-Customer Return-Other node shipment received</option>
											<option value='Account-Store Credit Discrepancy-AJIO Cash' <?= ($ajio['tagging_evaluator']=='Account-Store Credit Discrepancy-AJIO Cash')?'selected':'' ?> >Account-Store Credit Discrepancy-AJIO Cash</option>
											<option value='Account-Store Credit Discrepancy-Bonus Points' <?= ($ajio['tagging_evaluator']=='Account-Store Credit Discrepancy-Bonus Points')?'selected':'' ?> >Account-Store Credit Discrepancy-Bonus Points</option>
											<option value='NAR Calls/Emails-NAR Emails-Replied & Asked for More Information' <?= ($ajio['tagging_evaluator']=='NAR Calls/Emails-NAR Emails-Replied & Asked for More Information')?'selected':'' ?> >NAR Calls/Emails-NAR Emails-Replied & Asked for More Information</option>
											<option value='Delivery-Where is my Order?-Guided customer to track the order online' <?= ($ajio['tagging_evaluator']=='Delivery-Where is my Order?-Guided customer to track the order online')?'selected':'' ?> >Delivery-Where is my Order?-Guided customer to track the order online</option>
											<option value='Order-I had a problem while placing an order-ADONP – within 48 hrs' <?= ($ajio['tagging_evaluator']=='Order-I had a problem while placing an order-ADONP – within 48 hrs')?'selected':'' ?> >Order-I had a problem while placing an order-ADONP – within 48 hrs</option>
											<option value='Website-Complaint relating to Website-Return ID in Approved Status' <?= ($ajio['tagging_evaluator']=='Website-Complaint relating to Website-Return ID in Approved Status')?'selected':'' ?> >Website-Complaint relating to Website-Return ID in Approved Status</option>
											<option value='Order-What are the payment modes?-Informed Cx COD Not Available' <?= ($ajio['tagging_evaluator']=='Order-What are the payment modes?-Informed Cx COD Not Available')?'selected':'' ?> >Order-What are the payment modes?-Informed Cx COD Not Available</option>
											<option value='Website-Complaint relating to Website-AWB Not Assigned' <?= ($ajio['tagging_evaluator']=='Website-Complaint relating to Website-AWB Not Assigned')?'selected':'' ?> >Website-Complaint relating to Website-AWB Not Assigned</option>
											<option value='NAR Calls/Emails-NAR Calls-Already Actioned' <?= ($ajio['tagging_evaluator']=='NAR Calls/Emails-NAR Calls-Already Actioned')?'selected':'' ?> >NAR Calls/Emails-NAR Calls-Already Actioned</option>
											<option value='NAR Calls/Emails-NAR Emails-Already Actioned' <?= ($ajio['tagging_evaluator']=='NAR Calls/Emails-NAR Emails-Already Actioned')?'selected':'' ?> >NAR Calls/Emails-NAR Emails-Already Actioned</option>
											<option value='OB-QC fail while returning-Callback Requested' <?= ($ajio['tagging_evaluator']=='OB-QC fail while returning-Callback Requested')?'selected':'' ?> >OB-QC fail while returning-Callback Requested</option>
											<option value='OB-QC fail while returning-Others' <?= ($ajio['tagging_evaluator']=='OB-QC fail while returning-Others')?'selected':'' ?> >OB-QC fail while returning-Others</option>
											<option value='OB-QC fail while returning-Asked to share images' <?= ($ajio['tagging_evaluator']=='OB-QC fail while returning-Asked to share images')?'selected':'' ?> >OB-QC fail while returning-Asked to share images</option>
											<option value='OB-QC fail while returning-Raised pick without QC' <?= ($ajio['tagging_evaluator']=='OB-QC fail while returning-Raised pick without QC')?'selected':'' ?> >OB-QC fail while returning-Raised pick without QC</option>
											<option value='OB-QC fail while returning-Declined Returns' <?= ($ajio['tagging_evaluator']=='OB-QC fail while returning-Declined Returns')?'selected':'' ?> >OB-QC fail while returning-Declined Returns</option>
											<option value='OB-QC fail while returning-Raised Fake Attempt Complaint' <?= ($ajio['tagging_evaluator']=='OB-QC fail while returning-Raised Fake Attempt Complaint')?'selected':'' ?> >OB-QC fail while returning-Raised Fake Attempt Complaint</option>
											<option value='Pre Order - RJ-What are my delivery / payment options-Informed customer of payment / delivery options' <?= ($ajio['tagging_evaluator']=='Pre Order - RJ-What are my delivery / payment options-Informed customer of payment / delivery options')?'selected':'' ?> >Pre Order - RJ-What are my delivery / payment options-Informed customer of payment / delivery options</option>
											<option value='Pre Order - RJ-I need Authenticity information-Provided Information' <?= ($ajio['tagging_evaluator']=='Pre Order - RJ-I need Authenticity information-Provided Information')?'selected':'' ?> >Pre Order - RJ-I need Authenticity information-Provided Information</option>
											<option value='Pre Order - RJ-Explain the features of the product-Explained about product features / Pricing' <?= ($ajio['tagging_evaluator']=='Pre Order - RJ-Explain the features of the product-Explained about product features / Pricing')?'selected':'' ?> >Pre Order - RJ-Explain the features of the product-Explained about product features / Pricing</option>
											<option value='Account-Query / Dispute about LR-Guided customer to LR team' <?= ($ajio['tagging_evaluator']=='Account-Query / Dispute about LR-Guided customer to LR team')?'selected':'' ?> >Account-Query / Dispute about LR-Guided customer to LR team</option>
											<option value='Account-How do I use my Loyalty Rewards-Explained how to use LR' <?= ($ajio['tagging_evaluator']=='Account-How do I use my Loyalty Rewards-Explained how to use LR')?'selected':'' ?> >Account-How do I use my Loyalty Rewards-Explained how to use LR</option>
											<option value='Delivery-Order not dispatched from Warehouse-Shipment in Packed Status' <?= ($ajio['tagging_evaluator']=='Delivery-Order not dispatched from Warehouse-Shipment in Packed Status')?'selected':'' ?> >Delivery-Order not dispatched from Warehouse-Shipment in Packed Status</option>
											<option value='Return-Reached Warehouse - Refund not Initiated-Excess product handed over' <?= ($ajio['tagging_evaluator']=='Return-Reached Warehouse - Refund not Initiated-Excess product handed over')?'selected':'' ?> >Return-Reached Warehouse - Refund not Initiated-Excess product handed over</option>
											<option value='Delivery-POD Required-Req cx to check with neighbour / security' <?= ($ajio['tagging_evaluator']=='Delivery-POD Required-Req cx to check with neighbour / security')?'selected':'' ?> >Delivery-POD Required-Req cx to check with neighbour / security</option>
											<option value='Return-Wrong item with no tag-Return form' <?= ($ajio['tagging_evaluator']=='Return-Wrong item with no tag-Return form')?'selected':'' ?> >Return-Wrong item with no tag-Return form</option>
											<option value='Return-Wrong Item-Return form' <?= ($ajio['tagging_evaluator']=='Return-Wrong Item-Return form')?'selected':'' ?> >Return-Wrong Item-Return form</option>
											<option value='OB-Misc-Not Connected - Email Sent' <?= ($ajio['tagging_evaluator']=='OB-Misc-Not Connected - Email Sent')?'selected':'' ?> >OB-Misc-Not Connected - Email Sent</option>
											<option value='Reliance Jewels-I want certification of authenticity-Certificate to be sent' <?= ($ajio['tagging_evaluator']=='Reliance Jewels-I want certification of authenticity-Certificate to be sent')?'selected':'' ?> >Reliance Jewels-I want certification of authenticity-Certificate to be sent</option>
											<option value='Reliance Jewels-Information on weight/purity-Requested customer to visit nearest RJ store' <?= ($ajio['tagging_evaluator']=='Reliance Jewels-Information on weight/purity-Requested customer to visit nearest RJ store')?'selected':'' ?> >Reliance Jewels-Information on weight/purity-Requested customer to visit nearest RJ store</option>
											<option value='Return-Package ID related-cancellation due to items exceeding the package dimension' <?= ($ajio['tagging_evaluator']=='Return-Package ID related-cancellation due to items exceeding the package dimension')?'selected':'' ?> >Return-Package ID related-cancellation due to items exceeding the package dimension</option>
											<option value='Return-Package ID related-duplicate Package ID to be sent' <?= ($ajio['tagging_evaluator']=='Return-Package ID related-duplicate Package ID to be sent')?'selected':'' ?> >Return-Package ID related-duplicate Package ID to be sent</option>
											<option value='Pre Order - AJIO LUX-Explain the features of the product-Explained about product features' <?= ($ajio['tagging_evaluator']=='Pre Order - AJIO LUX-Explain the features of the product-Explained about product features')?'selected':'' ?> >Pre Order - AJIO LUX-Explain the features of the product-Explained about product features</option>
											<option value='Pre Order - AJIO LUX-I need warranty information-Provided Information' <?= ($ajio['tagging_evaluator']=='Pre Order - AJIO LUX-I need warranty information-Provided Information')?'selected':'' ?> >Pre Order - AJIO LUX-I need warranty information-Provided Information</option>
											<option value='Pre Order - AJIO LUX-Where can i find this product?-Informed customer that the product is not in stock' <?= ($ajio['tagging_evaluator']=='Pre Order - AJIO LUX-Where can i find this product?-Informed customer that the product is not in stock')?'selected':'' ?> >Pre Order - AJIO LUX-Where can i find this product?-Informed customer that the product is not in stock</option>
											<option value='Pre Order - AJIO LUX-Where can i find this product?-Helped customer to find the product' <?= ($ajio['tagging_evaluator']=='Pre Order - AJIO LUX-Where can i find this product?-Helped customer to find the product')?'selected':'' ?> >Pre Order - AJIO LUX-Where can i find this product?-Helped customer to find the product</option>
											<option value='Delivery-Marked the order as delivered-N/A' <?= ($ajio['tagging_evaluator']=='Delivery-Marked the order as delivered-N/A')?'selected':'' ?> >Delivery-Marked the order as delivered-N/A</option>
											<option value='Refund-Where is my Refund?-Educated customer about GST refund' <?= ($ajio['tagging_evaluator']=='Refund-Where is my Refund?-Educated customer about GST refund')?'selected':'' ?> >Refund-Where is my Refund?-Educated customer about GST refund</option>
											<option value='Return/Exchange-How do I return/exchange this item?-Email sent to confirm policy - Missing Product/Component' <?= ($ajio['tagging_evaluator']=='Return/Exchange-How do I return/exchange this item?-Email sent to confirm policy - Missing Product/Component')?'selected':'' ?> >Return/Exchange-How do I return/exchange this item?-Email sent to confirm policy - Missing Product/Component</option>
											<option value='NAR Calls/Emails-NAR Emails-Non AJIO Query' <?= ($ajio['tagging_evaluator']=='NAR Calls/Emails-NAR Emails-Non AJIO Query')?'selected':'' ?> >NAR Calls/Emails-NAR Emails-Non AJIO Query</option>
											<option value='Coupon-Unable to apply coupon-Requested to share coupon details/images' <?= ($ajio['tagging_evaluator']=='Coupon-Unable to apply coupon-Requested to share coupon details/images')?'selected':'' ?> >Coupon-Unable to apply coupon-Requested to share coupon details/images</option>
											<option value='Account-Store Credit Debited Order Not Processed-R-1 Points' <?= ($ajio['tagging_evaluator']=='Account-Store Credit Debited Order Not Processed-R-1 Points')?'selected':'' ?> >Account-Store Credit Debited Order Not Processed-R-1 Points</option>
											<option value='Account-I have not received my referral bonus-Informed about referral credit' <?= ($ajio['tagging_evaluator']=='Account-I have not received my referral bonus-Informed about referral credit')?'selected':'' ?> >Account-I have not received my referral bonus-Informed about referral credit</option>
											<option value='Account-Ajio Referral Discrepancy-Referral points/code not received' <?= ($ajio['tagging_evaluator']=='Account-Ajio Referral Discrepancy-Referral points/code not received')?'selected':'' ?> >Account-Ajio Referral Discrepancy-Referral points/code not received</option>
											<option value='Website-Complaint relating to Website-Order Delivered - Consignment not visible' <?= ($ajio['tagging_evaluator']=='Website-Complaint relating to Website-Order Delivered - Consignment not visible')?'selected':'' ?> >Website-Complaint relating to Website-Order Delivered - Consignment not visible</option>
											<option value='Return-Reached Warehouse - Refund not Initiated-Partial Refund Initiated' <?= ($ajio['tagging_evaluator']=='Return-Reached Warehouse - Refund not Initiated-Partial Refund Initiated')?'selected':'' ?> >Return-Reached Warehouse - Refund not Initiated-Partial Refund Initiated</option>
											<option value='Website-Complaint relating to Website-Change in login info' <?= ($ajio['tagging_evaluator']=='Website-Complaint relating to Website-Change in login info')?'selected':'' ?> >Website-Complaint relating to Website-Change in login info</option>
											<option value='Account-Fraudulent Activity reported-Educated customer as per policy' <?= ($ajio['tagging_evaluator']=='Account-Fraudulent Activity reported-Educated customer as per policy')?'selected':'' ?> >Account-Fraudulent Activity reported-Educated customer as per policy</option>
											<option value='Return-Cancelation Request (Chatbot only)-Return to be cancelled (Chatbot only)' <?= ($ajio['tagging_evaluator']=='Return-Cancelation Request (Chatbot only)-Return to be cancelled (Chatbot only)')?'selected':'' ?> >Return-Cancelation Request (Chatbot only)-Return to be cancelled (Chatbot only)</option>
											<option value='Account-R- One related-R - One refund not credited' <?= ($ajio['tagging_evaluator']=='Account-R- One related-R - One refund not credited')?'selected':'' ?> >Account-R- One related-R - One refund not credited</option>
											<option value='Account-How do I use my R - One points-Explained how to use R - One points' <?= ($ajio['tagging_evaluator']=='Account-How do I use my R - One points-Explained how to use R - One points')?'selected':'' ?> >Account-How do I use my R - One points-Explained how to use R - One points</option>
											<option value='Account-I have not received my R - One points-Informed about R - One points' <?= ($ajio['tagging_evaluator']=='Account-I have not received my R - One points-Informed about R - One points')?'selected':'' ?> >Account-I have not received my R - One points-Informed about R - One points</option>
											<option value='Website-Complaint related to website-R - One points not visible' <?= ($ajio['tagging_evaluator']=='Website-Complaint related to website-R - One points not visible')?'selected':'' ?> >Website-Complaint related to website-R - One points not visible</option>
											<option value='Account-R- One related-R - One points not credited' <?= ($ajio['tagging_evaluator']=='Account-R- One related-R - One points not credited')?'selected':'' ?> >Account-R- One related-R - One points not credited</option>
											<option value='Delivery-Cancelation Request (Chatbot only)-Exchange to be cancelled (Chatbot only)' <?= ($ajio['tagging_evaluator']=='Delivery-Cancelation Request (Chatbot only)-Exchange to be cancelled (Chatbot only)')?'selected':'' ?> >Delivery-Cancelation Request (Chatbot only)-Exchange to be cancelled (Chatbot only)</option>
											<option value='Delivery-Marked the order as delivered-Requested customer to wait for 2 business days' <?= ($ajio['tagging_evaluator']=='Delivery-Marked the order as delivered-Requested customer to wait for 2 business days')?'selected':'' ?> >Delivery-Marked the order as delivered-Requested customer to wait for 2 business days</option>
											<option value='Return-Non Returnable Product-Damaged Product Received - Fragile' <?= ($ajio['tagging_evaluator']=='Return-Non Returnable Product-Damaged Product Received - Fragile')?'selected':'' ?> >Return-Non Returnable Product-Damaged Product Received - Fragile</option>
											<option value='Return-Non Returnable Product-Damaged Product Received' <?= ($ajio['tagging_evaluator']=='Return-Non Returnable Product-Damaged Product Received')?'selected':'' ?> >Return-Non Returnable Product-Damaged Product Received</option>
											<option value='Refund-Where is my Refund?-Imps Failed - Requested Customer to share NEFT details' <?= ($ajio['tagging_evaluator']=='Refund-Where is my Refund?-Imps Failed - Requested Customer to share NEFT details')?'selected':'' ?> >Refund-Where is my Refund?-Imps Failed - Requested Customer to share NEFT details</option>
											<option value='NEFT(Refund Request)-NEFT Followup-Request for NEFT Transfer' <?= ($ajio['tagging_evaluator']=='NEFT(Refund Request)-NEFT Followup-Request for NEFT Transfer')?'selected':'' ?> >NEFT(Refund Request)-NEFT Followup-Request for NEFT Transfer</option>
											<option value='Delivery-Empty Package Received-Outer Packaging NOT Tampered' <?= ($ajio['tagging_evaluator']=='Delivery-Empty Package Received-Outer Packaging NOT Tampered')?'selected':'' ?> >Delivery-Empty Package Received-Outer Packaging NOT Tampered</option>
											<option value='Delivery-Incomplete Order received - Product(s) missing from shipment-Outer Packaging NOT Tampered' <?= ($ajio['tagging_evaluator']=='Delivery-Incomplete Order received - Product(s) missing from shipment-Outer Packaging NOT Tampered')?'selected':'' ?> >Delivery-Incomplete Order received - Product(s) missing from shipment-Outer Packaging NOT Tampered</option>
											<option value='Delivery-Incomplete Order received - Unit(s) missing from a Set/Pack-Outer Packaging NOT Tampered' <?= ($ajio['tagging_evaluator']=='Delivery-Incomplete Order received - Unit(s) missing from a Set/Pack-Outer Packaging NOT Tampered')?'selected':'' ?> >Delivery-Incomplete Order received - Unit(s) missing from a Set/Pack-Outer Packaging NOT Tampered</option>
											<option value='Return-Reached Warehouse - Refund not Initiated-Excess product handed over' <?= ($ajio['tagging_evaluator']=='Return-Reached Warehouse - Refund not Initiated-Excess product handed over')?'selected':'' ?> >Return-Reached Warehouse - Refund not Initiated-Excess product handed over</option>
											<option value='Delivery-Empty Package Received-Outer Packaging NOT Tampered' <?= ($ajio['tagging_evaluator']=='Delivery-Empty Package Received-Outer Packaging NOT Tampered')?'selected':'' ?> >Delivery-Empty Package Received-Outer Packaging NOT Tampered</option>
											<option value='Delivery-Empty Package Received-Outer Packaging Tampered' <?= ($ajio['tagging_evaluator']=='Delivery-Empty Package Received-Outer Packaging Tampered')?'selected':'' ?> >Delivery-Empty Package Received-Outer Packaging Tampered</option>
											<option value='Delivery-Empty Package Received – RJ(Jewels)-Outer Packaging NOT Tampered' <?= ($ajio['tagging_evaluator']=='Delivery-Empty Package Received – RJ(Jewels)-Outer Packaging NOT Tampered')?'selected':'' ?> >Delivery-Empty Package Received – RJ(Jewels)-Outer Packaging NOT Tampered</option>
											<option value='Delivery-Empty Package Received – RJ(Jewels)-Outer Packaging Tampered' <?= ($ajio['tagging_evaluator']=='Delivery-Empty Package Received – RJ(Jewels)-Outer Packaging Tampered')?'selected':'' ?> >Delivery-Empty Package Received – RJ(Jewels)-Outer Packaging Tampered</option>
											<option value='Delivery-Incomplete Order received - Unit(s) missing from a Set/Pack-Outer Package Tampered' <?= ($ajio['tagging_evaluator']=='Delivery-Incomplete Order received - Unit(s) missing from a Set/Pack-Outer Package Tampered')?'selected':'' ?> >Delivery-Incomplete Order received - Unit(s) missing from a Set/Pack-Outer Package Tampered</option>
											<option value='Delivery-Incomplete Order received - Product(s) missing from shipment-Outer Package Tampered' <?= ($ajio['tagging_evaluator']=='Delivery-Incomplete Order received - Product(s) missing from shipment-Outer Package Tampered')?'selected':'' ?> >Delivery-Incomplete Order received - Product(s) missing from shipment-Outer Package Tampered</option>
											<option value='Delivery-Incomplete Order received - item(s) missing from an outfit/dress-Outer Package Tampered' <?= ($ajio['tagging_evaluator']=='Delivery-Incomplete Order received - item(s) missing from an outfit/dress-Outer Package Tampered')?'selected':'' ?> >Delivery-Incomplete Order received - item(s) missing from an outfit/dress-Outer Package Tampered</option>
											<option value='Feedback-Suggestions about Convenience charge-NA' <?= ($ajio['tagging_evaluator']=='Feedback-Suggestions about Convenience charge-NA')?'selected':'' ?> >Feedback-Suggestions about Convenience charge-NA</option>
											<option value='Price-Whats the price for this order?-Guided Customer on Delivery charge' <?= ($ajio['tagging_evaluator']=='Price-Whats the price for this order?-Guided Customer on Delivery charge')?'selected':'' ?> >Price-Whats the price for this order?-Guided Customer on Delivery charge</option>
											<option value='Price-Whats the price for this order?-Guided Customer on COD charge' <?= ($ajio['tagging_evaluator']=='Price-Whats the price for this order?-Guided Customer on COD charge')?'selected':'' ?> >Price-Whats the price for this order?-Guided Customer on COD charge</option>
											<option value='Price-Whats the price for this order?-Guided Customer on Fulfilment Convenience charge' <?= ($ajio['tagging_evaluator']=='Price-Whats the price for this order?-Guided Customer on Fulfilment Convenience charge')?'selected':'' ?> >Price-Whats the price for this order?-Guided Customer on Fulfilment Convenience charge</option>
											<option value='Goodwill Request-CM insisting Compensation-Convenience Charge' <?= ($ajio['tagging_evaluator']=='Goodwill Request-CM insisting Compensation-Convenience Charge')?'selected':'' ?> >Goodwill Request-CM insisting Compensation-Convenience Charge</option>
											<option value='Other-I want convenience charge-Convinced the customer - No Action Required' <?= ($ajio['tagging_evaluator']=='Other-I want convenience charge-Convinced the customer - No Action Required')?'selected':'' ?> >Other-I want convenience charge-Convinced the customer - No Action Required</option>
											<option value='Ticket-Cx-Ticket Follow up - within TAT-Return related' <?= ($ajio['tagging_evaluator']=='Ticket-Cx-Ticket Follow up - within TAT-Return related')?'selected':'' ?> >Ticket-Cx-Ticket Follow up - within TAT-Return related</option>
											<option value='Ticket-Cx-Ticket Follow up - within TAT-Pickup related' <?= ($ajio['tagging_evaluator']=='Ticket-Cx-Ticket Follow up - within TAT-Pickup related')?'selected':'' ?> >Ticket-Cx-Ticket Follow up - within TAT-Pickup related</option>
											<option value='Ticket-Cx-Ticket Follow up - within TAT-Others' <?= ($ajio['tagging_evaluator']=='Ticket-Cx-Ticket Follow up - within TAT-Others')?'selected':'' ?> >Ticket-Cx-Ticket Follow up - within TAT-Others</option>
											<option value='Ticket-Cx-Ticket Follow up - within TAT-Missing Product related' <?= ($ajio['tagging_evaluator']=='Ticket-Cx-Ticket Follow up - within TAT-Missing Product related')?'selected':'' ?> >Ticket-Cx-Ticket Follow up - within TAT-Missing Product related</option>
											<option value='Ticket-Cx-Ticket Follow up - within TAT-Refund related' <?= ($ajio['tagging_evaluator']=='Ticket-Cx-Ticket Follow up - within TAT-Refund related')?'selected':'' ?> >Ticket-Cx-Ticket Follow up - within TAT-Refund related</option>
											<option value='Ticket-Cx-Ticket Follow up - within TAT-Website related' <?= ($ajio['tagging_evaluator']=='Ticket-Cx-Ticket Follow up - within TAT-Website related')?'selected':'' ?> >Ticket-Cx-Ticket Follow up - within TAT-Website related</option>
											<option value='Ticket-Cx-Ticket Follow up - TAT Breached-Others' <?= ($ajio['tagging_evaluator']=='Ticket-Cx-Ticket Follow up - TAT Breached-Others')?'selected':'' ?> >Ticket-Cx-Ticket Follow up - TAT Breached-Others</option>
											<option value='Ticket-Cx-Ticket Follow up - TAT Breached-Return related' <?= ($ajio['tagging_evaluator']=='Ticket-Cx-Ticket Follow up - TAT Breached-Return related')?'selected':'' ?> >Ticket-Cx-Ticket Follow up - TAT Breached-Return related</option>
											<option value='Ticket-Cx-Ticket Follow up - TAT Breached-Delivery related' <?= ($ajio['tagging_evaluator']=='Ticket-Cx-Ticket Follow up - TAT Breached-Delivery related')?'selected':'' ?> >Ticket-Cx-Ticket Follow up - TAT Breached-Delivery related</option>
											<option value='Ticket-Cx-Ticket Follow up - TAT Breached-Refund related' <?= ($ajio['tagging_evaluator']=='Ticket-Cx-Ticket Follow up - TAT Breached-Refund related')?'selected':'' ?> >Ticket-Cx-Ticket Follow up - TAT Breached-Refund related</option>
											<option value='Ticket-Cx-Ticket Follow up - TAT Breached-Missing Product related' <?= ($ajio['tagging_evaluator']=='Ticket-Cx-Ticket Follow up - TAT Breached-Missing Product related')?'selected':'' ?> >Ticket-Cx-Ticket Follow up - TAT Breached-Missing Product related</option>
											<option value='Ticket-Cx-Ticket Follow up - TAT Breached-Website related' <?= ($ajio['tagging_evaluator']=='Ticket-Cx-Ticket Follow up - TAT Breached-Website related')?'selected':'' ?> >Ticket-Cx-Ticket Follow up - TAT Breached-Website related</option>
											<option value='Ticket-Cx-Ticket Follow up - TAT Breached-Pickup related' <?= ($ajio['tagging_evaluator']=='Ticket-Cx-Ticket Follow up - TAT Breached-Pickup related')?'selected':'' ?> >Ticket-Cx-Ticket Follow up - TAT Breached-Pickup related</option>
											<option value='Ticket-Cx-Ticket Follow up - within TAT-Delivery related' <?= ($ajio['tagging_evaluator']=='Ticket-Cx-Ticket Follow up - within TAT-Delivery related')?'selected':'' ?> >Ticket-Cx-Ticket Follow up - within TAT-Delivery related</option>
											<option value='Callback-Regional Callback-CallBack Needed - Telugu' <?= ($ajio['tagging_evaluator']=='Callback-Regional Callback-CallBack Needed - Telugu')?'selected':'' ?> >Callback-Regional Callback-CallBack Needed - Telugu</option>
											<option value='Callback-Regional Callback-CallBack Needed - Tamil' <?= ($ajio['tagging_evaluator']=='Callback-Regional Callback-CallBack Needed - Tamil')?'selected':'' ?> >Callback-Regional Callback-CallBack Needed - Tamil</option>
											<option value='Callback-Regional Callback-CallBack Needed - Kannada' <?= ($ajio['tagging_evaluator']=='Callback-Regional Callback-CallBack Needed - Kannada')?'selected':'' ?> >Callback-Regional Callback-CallBack Needed - Kannada</option>
											<option value='Account-Suspended Account (Reason for Suspension Required)-Customer wanted Wallet amount transferred' <?= ($ajio['tagging_evaluator']=='Account-Suspended Account (Reason for Suspension Required)-Customer wanted Wallet amount transferred')?'selected':'' ?> >Account-Suspended Account (Reason for Suspension Required)-Customer wanted Wallet amount transferred</option>
											<option value='Account-Suspended Account (Reason for Suspension Required)-Customer wanted to return product' <?= ($ajio['tagging_evaluator']=='Account-Suspended Account (Reason for Suspension Required)-Customer wanted to return product')?'selected':'' ?> >Account-Suspended Account (Reason for Suspension Required)-Customer wanted to return product</option>
											<option value='Account-Suspended Account (Reason for Suspension Required)-Customer wanted to know suspension reason' <?= ($ajio['tagging_evaluator']=='Account-Suspended Account (Reason for Suspension Required)-Customer wanted to know suspension reason')?'selected':'' ?> >Account-Suspended Account (Reason for Suspension Required)-Customer wanted to know suspension reason</option>
											<option value='Callback-Regional Callback-CallBack Needed - Malyalam' <?= ($ajio['tagging_evaluator']=='Callback-Regional Callback-CallBack Needed - Malyalam')?'selected':'' ?> >Callback-Regional Callback-CallBack Needed - Malyalam</option>
											<option value='Order-Excess COD Collected-Informed customer to share image/screenshot' <?= ($ajio['tagging_evaluator']=='Order-Excess COD Collected-Informed customer to share image/screenshot')?'selected':'' ?> >Order-Excess COD Collected-Informed customer to share image/screenshot</option>
											<option value='Marketing-Gift not Received post winning contest-Top Shopper Gift' <?= ($ajio['tagging_evaluator']=='Marketing-Gift not Received post winning contest-Top Shopper Gift')?'selected':'' ?> >Marketing-Gift not Received post winning contest-Top Shopper Gift</option>
											<option value='Marketing-Gift not Received post winning contest-High Value Assured Gift - Instant Reward' <?= ($ajio['tagging_evaluator']=='Marketing-Gift not Received post winning contest-High Value Assured Gift - Instant Reward')?'selected':'' ?> >Marketing-Gift not Received post winning contest-High Value Assured Gift - Instant Reward</option>
											<option value='Marketing-Gift not Received post winning contest-High Value Assured Gift - Reward post return window' <?= ($ajio['tagging_evaluator']=='Marketing-Gift not Received post winning contest-High Value Assured Gift - Reward post return window')?'selected':'' ?> >Marketing-Gift not Received post winning contest-High Value Assured Gift - Reward post return window</option>
											<option value='Delivery-Incomplete Order received - item(s) missing from an outfit/dress-Outer Packaging NOT Tampered' <?= ($ajio['tagging_evaluator']=='Delivery-Incomplete Order received - item(s) missing from an outfit/dress-Outer Packaging NOT Tampered')?'selected':'' ?> >Delivery-Incomplete Order received - item(s) missing from an outfit/dress-Outer Packaging NOT Tampered</option>
											<option value='Return/Exchange-Return On Hold-Informed about Release/Verification TAT' <?= ($ajio['tagging_evaluator']=='Return/Exchange-Return On Hold-Informed about Release/Verification TAT')?'selected':'' ?> >Return/Exchange-Return On Hold-Informed about Release/Verification TAT</option>
											</select>
										
										</td>
									</tr>
									<tr>
										<td style="font-weight:bold; font-size:16px; text-align:right">Earned Score:</td>
										<td><input type="text" readonly id="earnedScore" name="data[earned_score]" class="form-control" style="font-weight:bold" value="<?php echo $ajio['earned_score'] ?>"></td>
										<td style="font-weight:bold; font-size:16px; text-align:right">Possible Score:</td>
										<td><input type="text" readonly id="possibleScore" name="data[possible_score]" class="form-control" style="font-weight:bold" value="<?php echo $ajio['possible_score'] ?>"></td>
										<td style="font-weight:bold; font-size:16px; text-align:right">Overall Score:</td>
										<td><input type="text" readonly id="" name="data[overall_score]" class="form-control" style="font-weight:bold" value="<?php echo $ajio['overall_score'] ?>"></td>
									</tr>
									<tr style="font-weight:bold">
										<td><input type="hidden" class="form-control" id="prefatal" name="data[pre_fatal_score]" value="<?php echo $ajio['pre_fatal_score'] ?>"></td>
										<td><input type="hidden" class="form-control" id="fatalcount" name="data[fatal_count]" value="<?php echo $ajio['fatal_count'] ?>"></td>
									</tr>
									<tr style="background-color:#85C1E9; font-weight:bold">
										<td>Parameter</td>
										<td>Sub Parameter</td>
										<td>Weightage</td>
										<td>Defect</td>
										<td>L1 Reason</td>
										<td>L2 Reason</td>
									</tr>
									<tr>
										<td rowspan=5 style="background-color:#85C1E9; font-weight:bold">Customer Service Essentials</td>
										<td style="color:red">Responded to  customer’s concern(s) correctly.</td>
										<td>15</td>
										<td>
											<select class="form-control ajio fatal ajioAF1" id="ajioAF1_social" name="data[customers_concern]" disabled>
												<option ajio_val=15 ajio_max=15 <?php echo $ajio['customers_concern'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ajio_val=0 ajio_max=15 <?php echo $ajio['customers_concern'] == "Autofail"?"selected":"";?> value="Autofail">Autofail</option>
											</select>
										</td>
										
										<td>
											<select class="form-control" id="customers_concern_l1" name="data[l1_reason1]" disabled>
												<?php 
												if($ajio['l1_reason1']!=''){
													?>
													<option value="<?php echo $ajio['l1_reason1'] ?>"><?php echo $ajio['l1_reason1'] ?></option>
													<?php
												}
												?>
												<option  <?php echo $ajio['l1_reason1'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
												
											</select>
										</td>
										<td><textarea class="form-control" disabled name="data[cmt1]"><?php echo $ajio['cmt1'] ?></textarea></td>
									</tr>
									<tr>
										<td style="color:red">Addressed/redirected customer’s issue for resolution wherever applicable</td>
										<td>10</td>
										<td>
											<select class="form-control ajio fatal ajioAF2" id="ajioAF2_social" name="data[customers_issue]" disabled>
												<option ajio_val=10 ajio_max=10 <?php echo $ajio['customers_issue'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ajio_val=0 ajio_max=10 <?php echo $ajio['customers_issue'] == "Autofail"?"selected":"";?> value="Autofail">Autofail</option>
											</select>
										</td>
										
										<td>
											<select class="form-control" id="customers_issue_l2" name="data[l1_reason2]" disabled>
												<?php 
												if($ajio['l1_reason2']!=''){
													?>
													<option value="<?php echo $ajio['l1_reason2'] ?>"><?php echo $ajio['l1_reason2'] ?></option>
													<?php
												}
												?>
												<option  <?php echo $ajio['l1_reason2'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
												
											</select>
										</td>
										<td><textarea class="form-control" disabled name="data[cmt2]"><?php echo $ajio['cmt2'] ?></textarea></td>
									</tr>
									<tr>
										<td style="color:red">Refered to previous interactions to understand the issue.</td>
										<td>10</td>
										<td>
											<select class="form-control ajio fatal ajioAF3" id="ajioAF3_social" name="data[previous_interaction]" disabled>
												<option ajio_val=10 ajio_max=10 <?php echo $ajio['previous_interaction'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ajio_val=0 ajio_max=10 <?php echo $ajio['previous_interaction'] == "Autofail"?"selected":"";?> value="Autofail">Autofail</option>
											</select>
										</td>
										
										<td>
											<select class="form-control" id="previous_interaction_l3" name="data[l1_reason3]" disabled>
												<?php 
												if($ajio['l1_reason3']!=''){
													?>
													<option value="<?php echo $ajio['l1_reason3'] ?>"><?php echo $ajio['l1_reason3'] ?></option>
													<?php
												}
												?>
												<option  <?php echo $ajio['l1_reason3'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
												
											</select>
										</td>
										<td><textarea class="form-control" disabled name="data[cmt3]"><?php echo $ajio['cmt3'] ?></textarea></td>
									</tr>
									<tr>
										<td style="color:red">Interaction was documented as per guidelines.</td>
										<td>10</td>
										<td>
											<select class="form-control ajio fatal ajioAF4" id="ajioAF4_social" name="data[documented_guidelines]" disabled>
												<option ajio_val=10 ajio_max=10 <?php echo $ajio['documented_guidelines'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ajio_val=0 ajio_max=10 <?php echo $ajio['documented_guidelines'] == "Autofail"?"selected":"";?> value="Autofail">Autofail</option>
											</select>
										</td>
										
										<td>
											<select class="form-control" id="documented_guidelines_l4" name="data[l1_reason4]" disabled>
												<?php 
												if($ajio['l1_reason4']!=''){
													?>
													<option value="<?php echo $ajio['l1_reason4'] ?>"><?php echo $ajio['l1_reason4'] ?></option>
													<?php
												}
												?>
												<option  <?php echo $ajio['l1_reason4'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
												
											</select>
										</td>
										<td><textarea class="form-control" disabled name="data[cmt4]"><?php echo $ajio['cmt4'] ?></textarea></td>
									</tr>
									<tr>
										<td>Validated Customer information.</td>
										<td>5</td>
										<td>
											<select class="form-control ajio" id="customer_information" name="data[customer_information]" disabled>
												<option ajio_val=5 ajio_max=5 <?php echo $ajio['customer_information'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ajio_val=0 ajio_max=5 <?php echo $ajio['customer_information'] == "No"?"selected":"";?> value="No">No</option>
											</select>
										</td>
										
										<td>
											<select class="form-control" id="customer_information_l5" name="data[l1_reason5]" disabled>
												<?php 
												if($ajio['l1_reason5']!=''){
													?>
													<option value="<?php echo $ajio['l1_reason5'] ?>"><?php echo $ajio['l1_reason5'] ?></option>
													<?php
												}
												?>
												<option  <?php echo $ajio['l1_reason5'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
												
											</select>
										</td>
										<td><textarea class="form-control" disabled name="data[cmt5]"><?php echo $ajio['cmt5'] ?></textarea></td>
									</tr>
									<tr>
										<td rowspan=3 style="background-color:#85C1E9; font-weight:bold">Social Media Handling Skills</td>
										<td>When necessary, ask the customer to move to a private channel (DM or FB Message).</td>
										<td>5</td>
										<td>
											<select class="form-control ajio" id="private_channel" name="data[private_channel]" disabled>
												<option ajio_val=5 ajio_max=5 <?php echo $ajio['private_channel'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ajio_val=0 ajio_max=5 <?php echo $ajio['private_channel'] == "No"?"selected":"";?> value="No">No</option>
											</select>
										</td>
										
										<td>
											<select class="form-control" id="private_channel_l6" name="data[l1_reason6]" disabled>
												<?php 
												if($ajio['l1_reason6']!=''){
													?>
													<option value="<?php echo $ajio['l1_reason6'] ?>"><?php echo $ajio['l1_reason6'] ?></option>
													<?php
												}
												?>
												<option  <?php echo $ajio['l1_reason6'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
												
											</select>
										</td>
										<td><textarea class="form-control" disabled name="data[cmt6]"><?php echo $ajio['cmt6'] ?></textarea></td>
									</tr>
									<tr>
										<td>Clarify the issue by asking probing questions. Made Outbound calls wherever required.</td>
										<td>15</td>
										<td>
											<select class="form-control ajio" id="probing_questions" name="data[probing_questions]" disabled>
												<option ajio_val=15 ajio_max=15 <?php echo $ajio['probing_questions'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ajio_val=0 ajio_max=15 <?php echo $ajio['probing_questions'] == "No"?"selected":"";?> value="No">No</option>
											</select>
										</td>
										
										<td>
											<select class="form-control" id="probing_questions_l7" name="data[l1_reason7]" disabled>
												<?php 
												if($ajio['l1_reason7']!=''){
													?>
													<option value="<?php echo $ajio['l1_reason7'] ?>"><?php echo $ajio['l1_reason7'] ?></option>
													<?php
												}
												?>
												<option  <?php echo $ajio['l1_reason7'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
												
											</select>
										</td>
										<td><textarea class="form-control" disabled name="data[cmt7]"><?php echo $ajio['cmt7'] ?></textarea></td>
									</tr>
									<tr>
										<td>Include hyperlinks, relevant hashtags etc that push helpful content.</td>
										<td>5</td>
										<td>
											<select class="form-control ajio" id="relevant_hashtags" name="data[relevant_hashtags]" disabled>
												<option ajio_val=5 ajio_max=5 <?php echo $ajio['relevant_hashtags'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ajio_val=0 ajio_max=5 <?php echo $ajio['relevant_hashtags'] == "No"?"selected":"";?> value="No">No</option>
											</select>
										</td>
										
										<td>
											<select class="form-control" id="relevant_hashtags_l8" name="data[l1_reason8]" disabled>
												<?php 
												if($ajio['l1_reason8']!=''){
													?>
													<option value="<?php echo $ajio['l1_reason8'] ?>"><?php echo $ajio['l1_reason8'] ?></option>
													<?php
												}
												?>
												<option  <?php echo $ajio['l1_reason8'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
												
											</select>
										</td>
										<td><textarea class="form-control" disabled name="data[cmt8]"><?php echo $ajio['cmt8'] ?></textarea></td>
									</tr>
									<tr>
										<td rowspan=3 style="background-color:#85C1E9; font-weight:bold">Social Media Writing Skills</td>
										<td>Use AJIO voice and a friendly tone to build rapport and brand confidence.</td>
										<td>10</td>
										<td>
											<select class="form-control ajio" id="friendly_tone" name="data[friendly_tone]" disabled>
												<option ajio_val=10 ajio_max=10 <?php echo $ajio['friendly_tone'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ajio_val=0 ajio_max=10 <?php echo $ajio['friendly_tone'] == "No"?"selected":"";?> value="No">No</option>
											</select>
										</td>
										
										<td>
											<select class="form-control" id="friendly_tone_l9" name="data[l1_reason9]" disabled>
												<?php 
												if($ajio['l1_reason9']!=''){
													?>
													<option value="<?php echo $ajio['l1_reason9'] ?>"><?php echo $ajio['l1_reason9'] ?></option>
													<?php
												}
												?>
												<option  <?php echo $ajio['l1_reason9'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
												
											</select>
										</td>
										<td><textarea class="form-control" disabled name="data[cmt9]"><?php echo $ajio['cmt9'] ?></textarea></td>
									</tr>
									<tr>
										<td>Avoid spelling, grammar, or punctuation errors that cause confusion.</td>
										<td>10</td>
										<td>
											<select class="form-control ajio" id="avoid_punctuation" name="data[avoid_punctuation]" disabled>
												<option ajio_val=10 ajio_max=10 <?php echo $ajio['avoid_punctuation'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ajio_val=0 ajio_max=10 <?php echo $ajio['avoid_punctuation'] == "No"?"selected":"";?> value="No">No</option>
											</select>
										</td>
										
										<td>
											<select class="form-control" id="avoid_punctuation_l10" name="data[l1_reason10]" disabled>
												<?php 
												if($ajio['l1_reason10']!=''){
													?>
													<option value="<?php echo $ajio['l1_reason10'] ?>"><?php echo $ajio['l1_reason10'] ?></option>
													<?php
												}
												?>
												<option  <?php echo $ajio['l1_reason10'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
												
											</select>
										</td>
										<td><textarea class="form-control" disabled name="data[cmt10]"><?php echo $ajio['cmt10'] ?></textarea></td>
									</tr>
									<tr>
										<td>Make customers feel heard and appreciated.</td>
										<td>5</td>
										<td>
											<select class="form-control ajio" id="feel_heard" name="data[feel_heard]" disabled>
												<option ajio_val=5 ajio_max=5 <?php echo $ajio['feel_heard'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ajio_val=0 ajio_max=5 <?php echo $ajio['feel_heard'] == "No"?"selected":"";?> value="No">No</option>
											</select>
										</td>
										
										<td>
											<select class="form-control" id="feel_heard_l11" name="data[l1_reason11]" disabled>
												<?php 
												if($ajio['l1_reason11']!=''){
													?>
													<option value="<?php echo $ajio['l1_reason11'] ?>"><?php echo $ajio['l1_reason11'] ?></option>
													<?php
												}
												?>
												<option  <?php echo $ajio['l1_reason11'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
												
											</select>
										</td>
										<td><textarea class="form-control" disabled name="data[cmt11]"><?php echo $ajio['cmt11'] ?></textarea></td>
									</tr>
									<tr>
										<td rowspan=1 style="background-color:#85C1E9; font-weight:bold">ZTP</td>
										<td style="color:red">As per AJIO ZTP guidelines</td>
										<td></td>
										<td>
											<select class="form-control ajio fatal ajioAF5" id="ajioAF5_social" name="data[ztp_guidelines]" disabled>
												<option ajio_val=0 ajio_max=0 <?php echo $ajio['ztp_guidelines'] == "No"?"selected":"";?> value="No">No</option>
												<option ajio_val=0 ajio_max=0 <?php echo $ajio['ztp_guidelines'] == "Autofail"?"selected":"";?> value="Autofail">Autofail</option>
											</select>
										</td>
										
										<td>
											<select class="form-control" id="ztp_guidelines_l12" name="data[l1_reason12]" disabled>
												<?php 
												if($ajio['l1_reason12']!=''){
													?>
													<option value="<?php echo $ajio['l1_reason12'] ?>"><?php echo $ajio['l1_reason12'] ?></option>
													<?php
												}
												?>
												<option  <?php echo $ajio['l1_reason12'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
												
											</select>
										</td>
										<td><textarea class="form-control" disabled name="data[cmt12]"><?php echo $ajio['cmt12'] ?></textarea></td>
									</tr>
									
									<tr>
										<td>Call Summary:</td>
										<td colspan=2><textarea class="form-control" disabled name="data[call_summary]"><?php echo $ajio['call_summary'] ?></textarea></td>
										<td>Feedback:</td>
										<td colspan=2><textarea class="form-control" disabled name="data[feedback]"><?php echo $ajio['feedback'] ?></textarea></td>
									</tr>
									<?php if($ajio['attach_file']!=''){ ?>
									<tr oncontextmenu="return false;">
										<td colspan="2">Audio Files (Mp4/Mp3/M4a/Wav)</td>
										<td colspan="4">
											<?php $attach_file = explode(",",$ajio['attach_file']);
											 foreach($attach_file as $af){ ?>
												<audio oncontextmenu="return false;" controls controlslist="nodownload" style="background-color:#607F93">
													  <source src="<?php echo base_url(); ?>qa_files/ajio_social_media/<?php echo $af; ?>" type="audio/ogg">
													  <source src="<?php echo base_url(); ?>qa_files/ajio_social_media/<?php echo $af; ?>" type="audio/mpeg">
												</audio> </br>
											 <?php } ?>
										</td>
									</tr>
									<?php } ?>
									<?php }else if($campaign=="ccsr_voice_email"){ ?> 
											<?php
										$rand_id = 0;
											if($ajio['entry_by']!=''){
												$auditorName = $ajio['auditor_name'];
											}else{
												$auditorName = $ajio['client_name'];
											}
											$auditDate = mysql2mmddyy($ajio['audit_date']);
											$clDate_val = mysqlDt2mmddyy($ajio['call_date']);
										
										if ($rand_id != 0) {
											$agent_id = $rand_data['sid'];
											$fusion_id = $rand_data['fusion_id'];
											$agent_name = $rand_data['fname'] . " " . $rand_data['lname'];
											$tl_id = $rand_data['assigned_to'];
											$tl_name = $rand_data['tl_name'];
											$call_duration = $rand_data['call_duration'];
											
										} else {
											$agent_id = $ajio['agent_id'];
											$fusion_id = $ajio['fusion_id'];
											$agent_name = $ajio['fname'] . " " . $ajio['lname'] ;
											$tl_id = $ajio['tl_id'];
											$tl_name = $ajio['tl_name'];
											$call_duration = $ajio['call_duration'];
										}
									?>
									<tr>
										<td>Auditor Name:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control" value="<?php echo $auditorName; ?>" disabled></td>
										<td>Audit Date:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control" value="<?php echo $auditDate; ?>" disabled></td>
										<td>Call Date/Time:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control" id="call_date_time" name="call_date" value="<?php echo $clDate_val; ?>" disabled></td>
									</tr>
									<tr>
										<td>Agent Name:<span style="font-size:24px;color:red">*</span></td>
										<td>
											<select class="form-control" id="agent_id" name="data[agent_id]" disabled>
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
										<td><input type="text" class="form-control" id="fusion_id" value="<?php echo $ajio['fusion_id'] ?>" readonly ></td>
										<td>L1 Supervisor:<span style="font-size:24px;color:red">*</span></td>
										<td>
											<input type="text" class="form-control" id="tl_name"  value="<?php echo $tl_name; ?>" readonly>
												<input type="hidden" class="form-control" id="tl_id" name="data[tl_id]" value="<?php echo $tl_id; ?>" disabled>
										</td>
									</tr>
									<tr>
										<td>Auditor's BP ID:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control" name="data[agent_bp_id]" value="<?php echo $ajio['agent_bp_id'] ?>" disabled ></td>
										<td>Call <br>Duration:<span style="font-size:24px;color:red">*</span></td>
										<td>
											<input type="text" class="form-control" onkeydown="return false;" id="call_duration" name="data[call_duration]" value="<?php echo $call_duration; ?>" disabled>
										</td>
										<td>Interaction <br>ID:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control" name="data[interaction_id]" value="<?php echo $ajio['interaction_id'] ?>" disabled ></td>
									</tr>
									
									<tr>
										<td>Order ID:<span style="font-size:24px;color:red">*</span></td>
										<td>
											<input type="text" class="form-control" id="" name="data[order_id]" value="<?php echo $ajio['order_id'] ?>" disabled>
										</td>
										<td>VOC:<span style="font-size:24px;color:red">*</span></td>
											<td>
												<select class="form-control" id="voc" name="data[voc]" disabled>
													
													<option value="">-Select-</option>
													<option value="1"  <?= ($ajio['voc']=="1")?"selected":"" ?>>1</option>
													<option value="2"  <?= ($ajio['voc']=="2")?"selected":"" ?>>2</option>
													<option value="3"  <?= ($ajio['voc']=="3")?"selected":"" ?>>3</option>
													<option value="4"  <?= ($ajio['voc']=="4")?"selected":"" ?>>4</option>
													<option value="5"  <?= ($ajio['voc']=="5")?"selected":"" ?>>5</option>
													<option value="6"  <?= ($ajio['voc']=="6")?"selected":"" ?>>6</option>
													<option value="7"  <?= ($ajio['voc']=="7")?"selected":"" ?>>7</option>
													<option value="8"  <?= ($ajio['voc']=="8")?"selected":"" ?>>8</option>
													<option value="9"  <?= ($ajio['voc']=="9")?"selected":"" ?>>9</option>
													<option value="10"  <?= ($ajio['voc']=="10")?"selected":"" ?>>10</option>
												</select>
											</td>
										<td>Call Synopsis:<span style="font-size:24px;color:red">*</span></td>
										<td>
											<input type="text" class="form-control" id="" name="data[call_synopsis]" value="<?php echo $ajio['call_synopsis'] ?>" disabled>
										</td>
										
									</tr>
									<tr>
										<td>Ticket ID:<span style="font-size:24px;color:red">*</span></td>
										<td>
											<input type="text" class="form-control" id="" name="data[ticket_id]" value="<?php echo $ajio['ticket_id'] ?>" disabled>
										</td>
										<td>Ticket Type:<span style="font-size:24px;color:red">*</span></td>
										<td>
											<select class="form-control" name="data[ticket_type]" disabled>
											<option value="">-Select-</option>
											<option value="Complaint"  <?= ($ajio['ticket_type']=="Complaint")?"selected":"" ?>>Complaint</option>
											<option value="Query"  <?= ($ajio['ticket_type']=="Query")?"selected":"" ?>>Query</option>
											<option value="Proactive SR"  <?= ($ajio['ticket_type']=="Proactive SR")?"selected":"" ?>>Proactive SR</option>
											</select>
										</td>
										<td>KPI - ACPT:<span style="font-size:24px;color:red">*</span></td>
										<td>
											<select class="form-control" name="data[KPI_ACPT]" disabled>
												<option value="">-Select-</option>
												<option <?php echo $ajio['KPI_ACPT'] == "Agent"?"selected":"";?> value="Agent">Agent</option>
												<option <?php echo $ajio['KPI_ACPT'] == "Process"?"selected":"";?> value="Process">Process</option>
												<option <?php echo $ajio['KPI_ACPT'] == "Customer"?"selected":"";?> value="Customer">Customer</option>
												<option <?php echo $ajio['KPI_ACPT'] == "Technology"?"selected":"";?> value="Technology">Technology</option>
												<option <?php echo $ajio['KPI_ACPT'] == "NA"?"selected":"";?> value="NA">NA</option>
											</select> 
										</td>
									</tr>
									
									<tr>
										
										<td>Audit Type:<span style="font-size:24px;color:red">*</span></td>
										<td>
											<select class="form-control" id="audit_type" name="data[audit_type]" disabled>
                                                    <option value="">-Select-</option>
                                                    <option value="CQ Audit" <?= ($ajio['audit_type']=="CQ Audit")?"selected":"" ?>>CQ Audit</option>
                                                    <option value="BQ Audit" <?= ($ajio['audit_type']=="BQ Audit")?"selected":"" ?>>BQ Audit</option>
                                                    <option value="Calibration" <?= ($ajio['audit_type']=="Calibration")?"selected":"" ?>>Calibration</option>
                                                    <option value="Pre-Certificate Mock Call" <?= ($ajio['audit_type']=="Pre-Certificate Mock Call")?"selected":"" ?>>Pre-Certificate Mock Call</option>
                                                    <option value="Certification Audit" <?= ($ajio['audit_type']=="Certification Audit")?"selected":"" ?>>Certification Audit</option>
                                                    <option value="WoW Call"  <?= ($ajio['audit_type']=="WoW Call")?"selected":"" ?>>WoW Call</option>
                                                    <option value="Hygiene Audit"  <?= ($ajio['audit_type']=="Hygiene Audit")?"selected":"" ?>>Hygiene Audit</option>
                                                    <option value="Operation Audit"  <?= ($ajio['audit_type']=="Operation Audit")?"selected":"" ?>>Operation Audit</option>
                                                    <option value="Trainer Audit"  <?= ($ajio['audit_type']=="Trainer Audit")?"selected":"" ?>>Trainer Audit</option> 
                                                    <option value="QA Supervisor Audit"  <?= ($ajio['audit_type']=="QA Supervisor Audit")?"selected":"" ?>>QA Supervisor Audit</option> 
                                                </select>
										</td>
										<td class="auType_epi">Auditor Type<span style="font-size:24px;color:red">*</span></td>
											<td class="auType_epi">
												<select class="form-control" id="auditor_type" name="data[auditor_type]">
                                                    <option value="">Select</option>
                                                    <option value="Master" <?= ($ajio['auditor_type']=="Master")?"selected":"" ?>>Master</option>
                                                    <option value="Regular" <?= ($ajio['auditor_type']=="Regular")?"selected":"" ?>>Regular</option>
                                                </select>
											</td>
									</tr>

									<tr>
										<td>Tagging By Evaluator:<span style="font-size:24px;color:red">*</span></td>
										<td colspan="4">	
											<select class="form-control" name="data[tagging_evaluator]" disabled>
												<option value="">-Select-</option>
												<option value='Delivery-Fake Attempt-N/A' <?php echo($ajio['tagging_evaluator']=='Delivery-Fake Attempt-N/A')?'selected':'' ?> >Delivery-Fake Attempt-N/A</option>
												<option value='Account-Store Credit Debited Order Not Processed-N/A' <?php echo($ajio['tagging_evaluator']=='Account-Store Credit Debited Order Not Processed-N/A')?'selected':'' ?> >Account-Store Credit Debited Order Not Processed-N/A</option>
												<option value='Account-Store Credit Discrepancy-Others' <?php echo($ajio['tagging_evaluator']=='Account-Store Credit Discrepancy-Others')?'selected':'' ?> >Account-Store Credit Discrepancy-Others</option>
												<option value='Account-Customer information Leak-N/A' <?php echo($ajio['tagging_evaluator']=='Account-Customer information Leak-N/A')?'selected':'' ?> >Account-Customer information Leak-N/A</option>
												<option value='Callback-Others-N/A' <?php echo($ajio['tagging_evaluator']=='Callback-Others-N/A')?'selected':'' ?> >Callback-Others-N/A</option>
												<option value='Delivery-Snatch Case-N/A' <?php echo($ajio['tagging_evaluator']=='Delivery-Snatch Case-N/A')?'selected':'' ?> >Delivery-Snatch Case-N/A</option>
												<option value='Delivery-Order not dispatched from Warehouse-N/A' <?php echo($ajio['tagging_evaluator']=='Delivery-Order not dispatched from Warehouse-N/A')?'selected':'' ?> >Delivery-Order not dispatched from Warehouse-N/A</option>
												<option value='Delivery-Delayed Delivery-N/A' <?php echo($ajio['tagging_evaluator']=='Delivery-Delayed Delivery-N/A')?'selected':'' ?> >Delivery-Delayed Delivery-N/A</option>
												<option value='Account-Stop sms/email (promotional)-N/A' <?php echo($ajio['tagging_evaluator']=='Account-Stop sms/email (promotional)-N/A')?'selected':'' ?> >Account-Stop sms/email (promotional)-N/A</option>
												<option value='Delivery-Complaint against Delivery Person-Courier person asking Extra Money' <?php echo($ajio['tagging_evaluator']=='Delivery-Complaint against Delivery Person-Courier person asking Extra Money')?'selected':'' ?> >Delivery-Complaint against Delivery Person-Courier person asking Extra Money</option>
												<option value='Callback-Supervisor Callback-N/A' <?php echo($ajio['tagging_evaluator']=='Callback-Supervisor Callback-N/A')?'selected':'' ?> >Callback-Supervisor Callback-N/A</option>
												<option value='Account-Account Deactivation-N/A' <?php echo($ajio['tagging_evaluator']=='Account-Account Deactivation-N/A')?'selected':'' ?> >Account-Account Deactivation-N/A</option>
												<option value='Delivery-RTO Refund Delayed-N/A' <?php echo($ajio['tagging_evaluator']=='Delivery-RTO Refund Delayed-N/A')?'selected':'' ?> >Delivery-RTO Refund Delayed-N/A</option>
												<option value='Online Refund-Amount Debited Order not processed-N/A' <?php echo($ajio['tagging_evaluator']=='Online Refund-Amount Debited Order not processed-N/A')?'selected':'' ?> >Online Refund-Amount Debited Order not processed-N/A</option>
												<option value='Delivery-Special Instructions for Contact Details Update-N/A' <?php echo($ajio['tagging_evaluator']=='Delivery-Special Instructions for Contact Details Update-N/A')?'selected':'' ?> >Delivery-Special Instructions for Contact Details Update-N/A</option>
												<option value='Online Refund-Refund not done against Reference No.-N/A' <?php echo($ajio['tagging_evaluator']=='Online Refund-Refund not done against Reference No.-N/A')?'selected':'' ?> >Online Refund-Refund not done against Reference No.-N/A</option>
												<option value='Delivery-Complaint against Delivery Person-Courier person took Extra Money' <?php echo($ajio['tagging_evaluator']=='Delivery-Complaint against Delivery Person-Courier person took Extra Money')?'selected':'' ?> >Delivery-Complaint against Delivery Person-Courier person took Extra Money</option>
												<option value='Marketing-Promotion Related-N/A' <?php echo($ajio['tagging_evaluator']=='Marketing-Promotion Related-N/A')?'selected':'' ?> >Marketing-Promotion Related-N/A</option>
												<option value='Return-Picked up - Did not reach Warehouse-N/A' <?php echo($ajio['tagging_evaluator']=='Return-Picked up - Did not reach Warehouse-N/A')?'selected':'' ?> >Return-Picked up - Did not reach Warehouse-N/A</option>
												<option value='Return-Self Ship Courier Charges not credited-N/A' <?php echo($ajio['tagging_evaluator']=='Return-Self Ship Courier Charges not credited-N/A')?'selected':'' ?> >Return-Self Ship Courier Charges not credited-N/A</option>
												<option value='Goodwill Request-CM insisting Compensation-N/A' <?php echo($ajio['tagging_evaluator']=='Goodwill Request-CM insisting Compensation-N/A')?'selected':'' ?> >Goodwill Request-CM insisting Compensation-N/A</option>
												<option value='Return-Reached Warehouse - Refund not Initiated-N/A' <?php echo($ajio['tagging_evaluator']=='Return-Reached Warehouse - Refund not Initiated-N/A')?'selected':'' ?> >Return-Reached Warehouse - Refund not Initiated-N/A</option>
												<option value='Online Refund-Refund Reference No. Needed-CC/DC/NB' <?php echo($ajio['tagging_evaluator']=='Online Refund-Refund Reference No. Needed-CC/DC/NB')?'selected':'' ?> >Online Refund-Refund Reference No. Needed-CC/DC/NB</option>
												<option value='Delivery-Complaint against Delivery Person-Rude Behaviour' <?php echo($ajio['tagging_evaluator']=='Delivery-Complaint against Delivery Person-Rude Behaviour')?'selected':'' ?> >Delivery-Complaint against Delivery Person-Rude Behaviour</option>
												<option value='Return-Additional Self Ship Courier Charges Required-N/A' <?php echo($ajio['tagging_evaluator']=='Return-Additional Self Ship Courier Charges Required-N/A')?'selected':'' ?> >Return-Additional Self Ship Courier Charges Required-N/A</option>
												<option value='Return-Pickup delayed-N/A' <?php echo($ajio['tagging_evaluator']=='Return-Pickup delayed-N/A')?'selected':'' ?> >Return-Pickup delayed-N/A</option>
												<option value='Online Refund-Refund Reference No. Needed-IMPS Transfer' <?php echo($ajio['tagging_evaluator']=='Online Refund-Refund Reference No. Needed-IMPS Transfer')?'selected':'' ?> >Online Refund-Refund Reference No. Needed-IMPS Transfer</option>
												<option value='Return-Customer claiming product picked up-Customer did not have acknowledgement copy' <?php echo($ajio['tagging_evaluator']=='Return-Customer claiming product picked up-Customer did not have acknowledgement copy')?'selected':'' ?> >Return-Customer claiming product picked up-Customer did not have acknowledgement copy</option>
												<option value='NEFT(Refund Request)-NEFT Transfer-N/A' <?php echo($ajio['tagging_evaluator']=='NEFT(Refund Request)-NEFT Transfer-N/A')?'selected':'' ?> >NEFT(Refund Request)-NEFT Transfer-N/A</option>
												<option value='Return-Customer claiming product picked up-Shared acknowledgement copy' <?php echo($ajio['tagging_evaluator']=='Return-Customer claiming product picked up-Shared acknowledgement copy')?'selected':'' ?> >Return-Customer claiming product picked up-Shared acknowledgement copy</option>
												<option value='Marketing-Gift not Received post winning contest-N/A' <?php echo($ajio['tagging_evaluator']=='Marketing-Gift not Received post winning contest-N/A')?'selected':'' ?> >Marketing-Gift not Received post winning contest-N/A</option>
												<option value='Return-Non Returnable Product-Wrong Product delivered' <?php echo($ajio['tagging_evaluator']=='Return-Non Returnable Product-Wrong Product delivered')?'selected':'' ?> >Return-Non Returnable Product-Wrong Product delivered</option>
												<option value='Return-Self Shipped no Update From WH-N/A' <?php echo($ajio['tagging_evaluator']=='Return-Self Shipped no Update From WH-N/A')?'selected':'' ?> >Return-Self Shipped no Update From WH-N/A</option>
												<option value='Return-Damaged Product-Damaged post usage' <?php echo($ajio['tagging_evaluator']=='Return-Damaged Product-Damaged post usage')?'selected':'' ?> >Return-Damaged Product-Damaged post usage</option>
												<option value='Return-Regular Courier Charges not credited-N/A' <?php echo($ajio['tagging_evaluator']=='Return-Regular Courier Charges not credited-N/A')?'selected':'' ?> >Return-Regular Courier Charges not credited-N/A</option>
												<option value='Return-Complaint against Delivery Person-Rude Behaviour' <?php echo($ajio['tagging_evaluator']=='Return-Complaint against Delivery Person-Rude Behaviour')?'selected':'' ?> >Return-Complaint against Delivery Person-Rude Behaviour</option>
												<option value='Return-Special Instructions for Contact Details Update-N/A' <?php echo($ajio['tagging_evaluator']=='Return-Special Instructions for Contact Details Update-N/A')?'selected':'' ?> >Return-Special Instructions for Contact Details Update-N/A</option>
												<option value='Return-Complaint against Delivery Person-Excess product handed over' <?php echo($ajio['tagging_evaluator']=='Return-Complaint against Delivery Person-Excess product handed over')?'selected':'' ?> >Return-Complaint against Delivery Person-Excess product handed over</option>
												<option value='Return-Complaint against Delivery Person-Didn’t have pickup receipt' <?php echo($ajio['tagging_evaluator']=='Return-Complaint against Delivery Person-Didn’t have pickup receipt')?'selected':'' ?> >Return-Complaint against Delivery Person-Didn’t have pickup receipt</option>
												<option value='Return-Complaint against Delivery Person-Didn’t know which product to pickup' <?php echo($ajio['tagging_evaluator']=='Return-Complaint against Delivery Person-Didn’t know which product to pickup')?'selected':'' ?> >Return-Complaint against Delivery Person-Didn’t know which product to pickup</option>
												<option value='Return-Complaint against Delivery Person-Courier person refused to pick a product' <?php echo($ajio['tagging_evaluator']=='Return-Complaint against Delivery Person-Courier person refused to pick a product')?'selected':'' ?> >Return-Complaint against Delivery Person-Courier person refused to pick a product</option>
												<option value='Return-Non Ajio Product Returned-Product Picked Up' <?php echo($ajio['tagging_evaluator']=='Return-Non Ajio Product Returned-Product Picked Up')?'selected':'' ?> >Return-Non Ajio Product Returned-Product Picked Up</option>
												<option value='Return-Pickup - Wrong Status Update-Product not picked up - Exchange Related' <?php echo($ajio['tagging_evaluator']=='Return-Pickup - Wrong Status Update-Product not picked up - Exchange Related')?'selected':'' ?> >Return-Pickup - Wrong Status Update-Product not picked up - Exchange Related</option>
												<option value='Return-Fake Attempt-N/A' <?php echo($ajio['tagging_evaluator']=='Return-Fake Attempt-N/A')?'selected':'' ?> >Return-Fake Attempt-N/A</option>
												<option value='Website-Complaint relating to Website-No confirmation received on website/email/sms' <?php echo($ajio['tagging_evaluator']=='Website-Complaint relating to Website-No confirmation received on website/email/sms')?'selected':'' ?> >Website-Complaint relating to Website-No confirmation received on website/email/sms</option>
												<option value='Website-Complaint relating to Website-Unable to view/edit Profile Details' <?php echo($ajio['tagging_evaluator']=='Website-Complaint relating to Website-Unable to view/edit Profile Details')?'selected':'' ?> >Website-Complaint relating to Website-Unable to view/edit Profile Details</option>
												<option value='Website-Complaint relating to Website-Issue with product page info' <?php echo($ajio['tagging_evaluator']=='Website-Complaint relating to Website-Issue with product page info')?'selected':'' ?> >Website-Complaint relating to Website-Issue with product page info</option>
												<option value='Website-Complaint relating to Website-Unable to cancel' <?php echo($ajio['tagging_evaluator']=='Website-Complaint relating to Website-Unable to cancel')?'selected':'' ?> >Website-Complaint relating to Website-Unable to cancel</option>
												<option value='Website-Complaint relating to Website-MRP Mismatch' <?php echo($ajio['tagging_evaluator']=='Website-Complaint relating to Website-MRP Mismatch')?'selected':'' ?> >Website-Complaint relating to Website-MRP Mismatch</option>
												<option value='Website-Complaint relating to Website-Unable to place order' <?php echo($ajio['tagging_evaluator']=='Website-Complaint relating to Website-Unable to place order')?'selected':'' ?> >Website-Complaint relating to Website-Unable to place order</option>
												<option value='Website-Complaint relating to Website-Unable to exchange' <?php echo($ajio['tagging_evaluator']=='Website-Complaint relating to Website-Unable to exchange')?'selected':'' ?> >Website-Complaint relating to Website-Unable to exchange</option>
												<option value='Website-Complaint relating to Website-Unable to return' <?php echo($ajio['tagging_evaluator']=='Website-Complaint relating to Website-Unable to return')?'selected':'' ?> >Website-Complaint relating to Website-Unable to return</option>
												<option value='Website-Complaint relating to Website-Product details required' <?php echo($ajio['tagging_evaluator']=='Website-Complaint relating to Website-Product details required')?'selected':'' ?> >Website-Complaint relating to Website-Product details required</option>
												<option value='VOC-Complaint against CC Employee-N/A' <?php echo($ajio['tagging_evaluator']=='VOC-Complaint against CC Employee-N/A')?'selected':'' ?> >VOC-Complaint against CC Employee-N/A</option>
												<option value='Website-Complaint relating to Website-Unable to login/signup' <?php echo($ajio['tagging_evaluator']=='Website-Complaint relating to Website-Unable to login/signup')?'selected':'' ?> >Website-Complaint relating to Website-Unable to login/signup</option>
												<option value='Return-Non Ajio Product Returned-Product Reached WH' <?php echo($ajio['tagging_evaluator']=='Return-Non Ajio Product Returned-Product Reached WH')?'selected':'' ?> >Return-Non Ajio Product Returned-Product Reached WH</option>
												<option value='VOC-Harassment & Integrity Issues-N/A' <?php echo($ajio['tagging_evaluator']=='VOC-Harassment & Integrity Issues-N/A')?'selected':'' ?> >VOC-Harassment & Integrity Issues-N/A</option>
												<option value='Return-Pickup - Wrong Status Update-Product not picked up - Return Related' <?php echo($ajio['tagging_evaluator']=='Return-Pickup - Wrong Status Update-Product not picked up - Return Related')?'selected':'' ?> >Return-Pickup - Wrong Status Update-Product not picked up - Return Related</option>
												<option value='Website-Complaint relating to Website-Slow Functioning/Unable to open feature-webpage-website' <?php echo($ajio['tagging_evaluator']=='Website-Complaint relating to Website-Slow Functioning/Unable to open feature-webpage-website')?'selected':'' ?> >Website-Complaint relating to Website-Slow Functioning/Unable to open feature-webpage-website</option>
												<option value='WH - Order Related Issues-Customer Return-Product Interchange of Customer' <?php echo($ajio['tagging_evaluator']=='WH - Order Related Issues-Customer Return-Product Interchange of Customer')?'selected':'' ?> >WH - Order Related Issues-Customer Return-Product Interchange of Customer</option>
												<option value='WH - Order Related Issues-RTO-Order Received Without Return ID' <?php echo($ajio['tagging_evaluator']=='WH - Order Related Issues-RTO-Order Received Without Return ID')?'selected':'' ?> >WH - Order Related Issues-RTO-Order Received Without Return ID</option>
												<option value='WH - Order Related Issues-RTO-Others' <?php echo($ajio['tagging_evaluator']=='WH - Order Related Issues-RTO-Others')?'selected':'' ?> >WH - Order Related Issues-RTO-Others</option>
												<option value='WH - Order Related Issues-Customer Return-No Clue Shipment' <?php echo($ajio['tagging_evaluator']=='WH - Order Related Issues-Customer Return-No Clue Shipment')?'selected':'' ?> >WH - Order Related Issues-Customer Return-No Clue Shipment</option>
												<option value='WH - Order Related Issues-Customer Return-Invoice Interchange' <?php echo($ajio['tagging_evaluator']=='WH - Order Related Issues-Customer Return-Invoice Interchange')?'selected':'' ?> >WH - Order Related Issues-Customer Return-Invoice Interchange</option>
												<option value='WH - Order Related Issues-RTO-Damaged Product Received' <?php echo($ajio['tagging_evaluator']=='WH - Order Related Issues-RTO-Damaged Product Received')?'selected':'' ?> >WH - Order Related Issues-RTO-Damaged Product Received</option>
												<option value='WH - Order Related Issues-Customer Return-Missing Free Gift' <?php echo($ajio['tagging_evaluator']=='WH - Order Related Issues-Customer Return-Missing Free Gift')?'selected':'' ?> >WH - Order Related Issues-Customer Return-Missing Free Gift</option>
												<option value='WH - Order Related Issues-Customer Return-Non-Ajio Product Return' <?php echo($ajio['tagging_evaluator']=='WH - Order Related Issues-Customer Return-Non-Ajio Product Return')?'selected':'' ?> >WH - Order Related Issues-Customer Return-Non-Ajio Product Return</option>
												<option value='WH - Order Related Issues-RTO-Empty Box Received' <?php echo($ajio['tagging_evaluator']=='WH - Order Related Issues-RTO-Empty Box Received')?'selected':'' ?> >WH - Order Related Issues-RTO-Empty Box Received</option>
												<option value='WH - Order Related Issues-Customer Return-Order Received Without Return ID' <?php echo($ajio['tagging_evaluator']=='WH - Order Related Issues-Customer Return-Order Received Without Return ID')?'selected':'' ?> >WH - Order Related Issues-Customer Return-Order Received Without Return ID</option>
												<option value='WH - Order Related Issues-Return to be cancelled-AWB not cancelled (Pickup not required)' <?php echo($ajio['tagging_evaluator']=='WH - Order Related Issues-Return to be cancelled-AWB not cancelled (Pickup not required)')?'selected':'' ?> >WH - Order Related Issues-Return to be cancelled-AWB not cancelled (Pickup not required)</option>
												<option value='WH - Order Related Issues-RTO-Missing Free Gift' <?php echo($ajio['tagging_evaluator']=='WH - Order Related Issues-RTO-Missing Free Gift')?'selected':'' ?> >WH - Order Related Issues-RTO-Missing Free Gift</option>
												<option value='WH - Order Related Issues-Forward-MRP Mismatch' <?php echo($ajio['tagging_evaluator']=='WH - Order Related Issues-Forward-MRP Mismatch')?'selected':'' ?> >WH - Order Related Issues-Forward-MRP Mismatch</option>
												<option value='WH - Order Related Issues-Customer Return-Excess Product Received' <?php echo($ajio['tagging_evaluator']=='WH - Order Related Issues-Customer Return-Excess Product Received')?'selected':'' ?> >WH - Order Related Issues-Customer Return-Excess Product Received</option>
												<option value='WH - Order Related Issues-Customer Return-To Be Refunded – Empty Box Received' <?php echo($ajio['tagging_evaluator']=='WH - Order Related Issues-Customer Return-To Be Refunded – Empty Box Received')?'selected':'' ?> >WH - Order Related Issues-Customer Return-To Be Refunded – Empty Box Received</option>
												<option value='WH - Order Related Issues-RTO-No Clue Shipment' <?php echo($ajio['tagging_evaluator']=='WH - Order Related Issues-RTO-No Clue Shipment')?'selected':'' ?> >WH - Order Related Issues-RTO-No Clue Shipment</option>
												<option value='WH - Order Related Issues-RTO-Excess Product Received' <?php echo($ajio['tagging_evaluator']=='WH - Order Related Issues-RTO-Excess Product Received')?'selected':'' ?> >WH - Order Related Issues-RTO-Excess Product Received</option>
												<option value='WH - Order Related Issues-Forward-Design Mismatch' <?php echo($ajio['tagging_evaluator']=='WH - Order Related Issues-Forward-Design Mismatch')?'selected':'' ?> >WH - Order Related Issues-Forward-Design Mismatch</option>
												<option value='WH - Order Related Issues-RTO-Packaging / Box not Received or Damaged' <?php echo($ajio['tagging_evaluator']=='WH - Order Related Issues-RTO-Packaging / Box not Received or Damaged')?'selected':'' ?> >WH - Order Related Issues-RTO-Packaging / Box not Received or Damaged</option>
												<option value='WH - Order Related Issues-Return to be cancelled-AWB cancelled (Pickup not required)' <?php echo($ajio['tagging_evaluator']=='WH - Order Related Issues-Return to be cancelled-AWB cancelled (Pickup not required)')?'selected':'' ?> >WH - Order Related Issues-Return to be cancelled-AWB cancelled (Pickup not required)</option>
												<option value='WH - Order Related Issues-Return to be cancelled-AWB cancelled (Pickup required)' <?php echo($ajio['tagging_evaluator']=='WH - Order Related Issues-Return to be cancelled-AWB cancelled (Pickup required)')?'selected':'' ?> >WH - Order Related Issues-Return to be cancelled-AWB cancelled (Pickup required)</option>
												<option value='WH - Order Related Issues-Forward-Tech Issues' <?php echo($ajio['tagging_evaluator']=='WH - Order Related Issues-Forward-Tech Issues')?'selected':'' ?> >WH - Order Related Issues-Forward-Tech Issues</option>
												<option value='WH - Order Related Issues-Return to be cancelled-AWB not cancelled (Pickup required)' <?php echo($ajio['tagging_evaluator']=='WH - Order Related Issues-Return to be cancelled-AWB not cancelled (Pickup required)')?'selected':'' ?> >WH - Order Related Issues-Return to be cancelled-AWB not cancelled (Pickup required)</option>
												<option value='WH - Order Related Issues-Customer Return-Empty Box Received' <?php echo($ajio['tagging_evaluator']=='WH - Order Related Issues-Customer Return-Empty Box Received')?'selected':'' ?> >WH - Order Related Issues-Customer Return-Empty Box Received</option>
												<option value='WH - Order Related Issues-Customer Return-Non Delhivery pickup-Missing product in return packet' <?php echo($ajio['tagging_evaluator']=='WH - Order Related Issues-Customer Return-Non Delhivery pickup-Missing product in return packet')?'selected':'' ?> >WH - Order Related Issues-Customer Return-Non Delhivery pickup-Missing product in return packet</option>
												<option value='WH - Order Related Issues-Customer Return-Others' <?php echo($ajio['tagging_evaluator']=='WH - Order Related Issues-Customer Return-Others')?'selected':'' ?> >WH - Order Related Issues-Customer Return-Others</option>
												<option value='WH - Order Related Issues-Customer Return-Missing Product in Return Packet' <?php echo($ajio['tagging_evaluator']=='WH - Order Related Issues-Customer Return-Missing Product in Return Packet')?'selected':'' ?> >WH - Order Related Issues-Customer Return-Missing Product in Return Packet</option>
												<option value='WH - Order Related Issues-RTO-Missing Product in Return Packet' <?php echo($ajio['tagging_evaluator']=='WH - Order Related Issues-RTO-Missing Product in Return Packet')?'selected':'' ?> >WH - Order Related Issues-RTO-Missing Product in Return Packet</option>
												<option value='WH - Order Related Issues-RTO-Invoice Interchange' <?php echo($ajio['tagging_evaluator']=='WH - Order Related Issues-RTO-Invoice Interchange')?'selected':'' ?> >WH - Order Related Issues-RTO-Invoice Interchange</option>
												<option value='WH - Order Related Issues-Customer Return-Tags Missing' <?php echo($ajio['tagging_evaluator']=='WH - Order Related Issues-Customer Return-Tags Missing')?'selected':'' ?> >WH - Order Related Issues-Customer Return-Tags Missing</option>
												<option value='WH - Order Related Issues-RTO-Non-Ajio Product Return' <?php echo($ajio['tagging_evaluator']=='WH - Order Related Issues-RTO-Non-Ajio Product Return')?'selected':'' ?> >WH - Order Related Issues-RTO-Non-Ajio Product Return</option>
												<option value='Mobile App-Others-Others' <?php echo($ajio['tagging_evaluator']=='Mobile App-Others-Others')?'selected':'' ?> >Mobile App-Others-Others</option>
												<option value='Delivery-I want quicker Delivery-Informed about expediting policy' <?php echo($ajio['tagging_evaluator']=='Delivery-I want quicker Delivery-Informed about expediting policy')?'selected':'' ?> >Delivery-I want quicker Delivery-Informed about expediting policy</option>
												<option value='Account-I need help with my account-Informed customer about account information' <?php echo($ajio['tagging_evaluator']=='Account-I need help with my account-Informed customer about account information')?'selected':'' ?> >Account-I need help with my account-Informed customer about account information</option>
												<option value='Account-I need help with my account-Guided customer on My Accounts' <?php echo($ajio['tagging_evaluator']=='Account-I need help with my account-Guided customer on My Accounts')?'selected':'' ?> >Account-I need help with my account-Guided customer on My Accounts</option>
												<option value='Account-How do I use JioMoney?-Guided customer on JioMoney validity' <?php echo($ajio['tagging_evaluator']=='Account-How do I use JioMoney?-Guided customer on JioMoney validity')?'selected':'' ?> >Account-How do I use JioMoney?-Guided customer on JioMoney validity</option>
												<option value='Account-How do I use JioMoney?-Guided customer on loading JioMoney' <?php echo($ajio['tagging_evaluator']=='Account-How do I use JioMoney?-Guided customer on loading JioMoney')?'selected':'' ?> >Account-How do I use JioMoney?-Guided customer on loading JioMoney</option>
												<option value='Account-I did not place this order-Retained the order' <?php echo($ajio['tagging_evaluator']=='Account-I did not place this order-Retained the order')?'selected':'' ?> >Account-I did not place this order-Retained the order</option>
												<option value='Business-Others-Advised about the procedure' <?php echo($ajio['tagging_evaluator']=='Business-Others-Advised about the procedure')?'selected':'' ?> >Business-Others-Advised about the procedure</option>
												<option value='Account-Why is my account suspended ?-Guided customer on Reason for Suspension' <?php echo($ajio['tagging_evaluator']=='Account-Why is my account suspended ?-Guided customer on Reason for Suspension')?'selected':'' ?> >Account-Why is my account suspended ?-Guided customer on Reason for Suspension</option>
												<option value='NAR Calls/Emails-Incomplete Call/Email-Call dropped after knowing the query' <?php echo($ajio['tagging_evaluator']=='NAR Calls/Emails-Incomplete Call/Email-Call dropped after knowing the query')?'selected':'' ?> >NAR Calls/Emails-Incomplete Call/Email-Call dropped after knowing the query</option>
												<option value='Mobile App-Help me shop on the App-Helped the customer' <?php echo($ajio['tagging_evaluator']=='Mobile App-Help me shop on the App-Helped the customer')?'selected':'' ?> >Mobile App-Help me shop on the App-Helped the customer</option>
												<option value='Account-How do I use my store credits?-Informed about Store Credit policy' <?php echo($ajio['tagging_evaluator']=='Account-How do I use my store credits?-Informed about Store Credit policy')?'selected':'' ?> >Account-How do I use my store credits?-Informed about Store Credit policy</option>
												<option value='Coupon-How do I use my Coupon?-Educated customer on Coupon features' <?php echo($ajio['tagging_evaluator']=='Coupon-How do I use my Coupon?-Educated customer on Coupon features')?'selected':'' ?> >Coupon-How do I use my Coupon?-Educated customer on Coupon features</option>
												<option value='Cancel-I want to cancel-Cancelled order' <?php echo($ajio['tagging_evaluator']=='Cancel-I want to cancel-Cancelled order')?'selected':'' ?> >Cancel-I want to cancel-Cancelled order</option>
												<option value='NAR Calls/Emails-Incomplete Call/Email-Call suddenly went blank during conversation' <?php echo($ajio['tagging_evaluator']=='NAR Calls/Emails-Incomplete Call/Email-Call suddenly went blank during conversation')?'selected':'' ?> >NAR Calls/Emails-Incomplete Call/Email-Call suddenly went blank during conversation</option>
												<option value='Account-I did not place this order-Cancelled the order' <?php echo($ajio['tagging_evaluator']=='Account-I did not place this order-Cancelled the order')?'selected':'' ?> >Account-I did not place this order-Cancelled the order</option>
												<option value='NAR Calls/Emails-Blank Call-Blank Call' <?php echo($ajio['tagging_evaluator']=='NAR Calls/Emails-Blank Call-Blank Call')?'selected':'' ?> >NAR Calls/Emails-Blank Call-Blank Call</option>
												<option value='Cancel-Explain the Cancellation Policy-Explained the cancellation policy' <?php echo($ajio['tagging_evaluator']=='Cancel-Explain the Cancellation Policy-Explained the cancellation policy')?'selected':'' ?> >Cancel-Explain the Cancellation Policy-Explained the cancellation policy</option>
												<option value='Mobile App-How do I cancel the order on the App-Explained the feature' <?php echo($ajio['tagging_evaluator']=='Mobile App-How do I cancel the order on the App-Explained the feature')?'selected':'' ?> >Mobile App-How do I cancel the order on the App-Explained the feature</option>
												<option value='Account-How do I use JioMoney?-Guided customer to JioMoney Customer Care' <?php echo($ajio['tagging_evaluator']=='Account-How do I use JioMoney?-Guided customer to JioMoney Customer Care')?'selected':'' ?> >Account-How do I use JioMoney?-Guided customer to JioMoney Customer Care</option>
												<option value='Account-I want to Stop SMS/Email Promotions-Informed customer of the procedure' <?php echo($ajio['tagging_evaluator']=='Account-I want to Stop SMS/Email Promotions-Informed customer of the procedure')?'selected':'' ?> >Account-I want to Stop SMS/Email Promotions-Informed customer of the procedure</option>
												<option value='Cancel-I want to cancel-Educated customer on cancellation policy' <?php echo($ajio['tagging_evaluator']=='Cancel-I want to cancel-Educated customer on cancellation policy')?'selected':'' ?> >Cancel-I want to cancel-Educated customer on cancellation policy</option>
												<option value='Mobile App-I have a problem using your app-Explained the App feature/Functions' <?php echo($ajio['tagging_evaluator']=='Mobile App-I have a problem using your app-Explained the App feature/Functions')?'selected':'' ?> >Mobile App-I have a problem using your app-Explained the App feature/Functions</option>
												<option value='NAR Calls/Emails-Incomplete Call/Email-Call dropped before knowing the query' <?php echo($ajio['tagging_evaluator']=='NAR Calls/Emails-Incomplete Call/Email-Call dropped before knowing the query')?'selected':'' ?> >NAR Calls/Emails-Incomplete Call/Email-Call dropped before knowing the query</option>
												<option value='Coupon-I did not receive a coupon after returning/cancelling-Educated customer on Coupon policy' <?php echo($ajio['tagging_evaluator']=='Coupon-I did not receive a coupon after returning/cancelling-Educated customer on Coupon policy')?'selected':'' ?> >Coupon-I did not receive a coupon after returning/cancelling-Educated customer on Coupon policy</option>
												<option value='Account-How many Store Credits do I have?-Provided the amount to the customer' <?php echo($ajio['tagging_evaluator']=='Account-How many Store Credits do I have?-Provided the amount to the customer')?'selected':'' ?> >Account-How many Store Credits do I have?-Provided the amount to the customer</option>
												<option value='Mobile App-The App is slow/ loading & functionality issues-Troubleshooting done' <?php echo($ajio['tagging_evaluator']=='Mobile App-The App is slow/ loading & functionality issues-Troubleshooting done')?'selected':'' ?> >Mobile App-The App is slow/ loading & functionality issues-Troubleshooting done</option>
												<option value='Cancel-I want to cancel-Guided customer to cancel on Website/App' <?php echo($ajio['tagging_evaluator']=='Cancel-I want to cancel-Guided customer to cancel on Website/App')?'selected':'' ?> >Cancel-I want to cancel-Guided customer to cancel on Website/App</option>
												<option value='Mobile App-I am unable to login/sign up on the App-Helped the customer login/signup' <?php echo($ajio['tagging_evaluator']=='Mobile App-I am unable to login/sign up on the App-Helped the customer login/signup')?'selected':'' ?> >Mobile App-I am unable to login/sign up on the App-Helped the customer login/signup</option>
												<option value='Account-I need help with my account-Guided customer on password query' <?php echo($ajio['tagging_evaluator']=='Account-I need help with my account-Guided customer on password query')?'selected':'' ?> >Account-I need help with my account-Guided customer on password query</option>
												<option value='Account-How do I use my store credits?-Explained how to use Store Credits' <?php echo($ajio['tagging_evaluator']=='Account-How do I use my store credits?-Explained how to use Store Credits')?'selected':'' ?> >Account-How do I use my store credits?-Explained how to use Store Credits</option>
												<option value='Business-I want to do marketing/promotion for AJIO-Advised about the procedure' <?php echo($ajio['tagging_evaluator']=='Business-I want to do marketing/promotion for AJIO-Advised about the procedure')?'selected':'' ?> >Business-I want to do marketing/promotion for AJIO-Advised about the procedure</option>
												<option value='NAR Calls/Emails-Abusive Caller-Abusive Caller' <?php echo($ajio['tagging_evaluator']=='NAR Calls/Emails-Abusive Caller-Abusive Caller')?'selected':'' ?> >NAR Calls/Emails-Abusive Caller-Abusive Caller</option>
												<option value='NAR Calls/Emails-Incomplete Call/Email-Call suddenly got interrupted by static noise during conversation' <?php echo($ajio['tagging_evaluator']=='NAR Calls/Emails-Incomplete Call/Email-Call suddenly got interrupted by static noise during conversation')?'selected':'' ?> >NAR Calls/Emails-Incomplete Call/Email-Call suddenly got interrupted by static noise during conversation</option>
												<option value='Cancel-Cancel my Return/Exchange-Informed Unable to cancel' <?php echo($ajio['tagging_evaluator']=='Cancel-Cancel my Return/Exchange-Informed Unable to cancel')?'selected':'' ?> >Cancel-Cancel my Return/Exchange-Informed Unable to cancel</option>
												<option value='Cancel-Why was my pickup/exchange cancelled?-Explained the reason' <?php echo($ajio['tagging_evaluator']=='Cancel-Why was my pickup/exchange cancelled?-Explained the reason')?'selected':'' ?> >Cancel-Why was my pickup/exchange cancelled?-Explained the reason</option>
												<option value='Mobile App-How do I create a return on the App-Explained the feature' <?php echo($ajio['tagging_evaluator']=='Mobile App-How do I create a return on the App-Explained the feature')?'selected':'' ?> >Mobile App-How do I create a return on the App-Explained the feature</option>
												<option value='Business-Media Related-Enquiry/ Concern' <?php echo($ajio['tagging_evaluator']=='Business-Media Related-Enquiry/ Concern')?'selected':'' ?> >Business-Media Related-Enquiry/ Concern</option>
												<option value='Cancel-Why was my order cancelled?-Explained the cancellation reason' <?php echo($ajio['tagging_evaluator']=='Cancel-Why was my order cancelled?-Explained the cancellation reason')?'selected':'' ?> >Cancel-Why was my order cancelled?-Explained the cancellation reason</option>
												<option value='Business-I want to sell my merchandise on AJIO-Advised about the procedure' <?php echo($ajio['tagging_evaluator']=='Business-I want to sell my merchandise on AJIO-Advised about the procedure')?'selected':'' ?> >Business-I want to sell my merchandise on AJIO-Advised about the procedure</option>
												<option value='Delivery-I want Delivery/Pickup at specific time-Informed about delivery policy' <?php echo($ajio['tagging_evaluator']=='Delivery-I want Delivery/Pickup at specific time-Informed about delivery policy')?'selected':'' ?> >Delivery-I want Delivery/Pickup at specific time-Informed about delivery policy</option>
												<option value='Business-I want to apply for job at AJIO-Guided customer on process' <?php echo($ajio['tagging_evaluator']=='Business-I want to apply for job at AJIO-Guided customer on process')?'selected':'' ?> >Business-I want to apply for job at AJIO-Guided customer on process</option>
												<option value='Cancel-Cancel my Return/Exchange-Cancelled the Return /Exchange request' <?php echo($ajio['tagging_evaluator']=='Cancel-Cancel my Return/Exchange-Cancelled the Return /Exchange request')?'selected':'' ?> >Cancel-Cancel my Return/Exchange-Cancelled the Return /Exchange request</option>
												<option value='NAR Calls/Emails-NAR Calls-No Action Required' <?php echo($ajio['tagging_evaluator']=='NAR Calls/Emails-NAR Calls-No Action Required')?'selected':'' ?> >NAR Calls/Emails-NAR Calls-No Action Required</option>
												<option value='NAR Calls/Emails-NAR Emails-No Action Required' <?php echo($ajio['tagging_evaluator']=='NAR Calls/Emails-NAR Emails-No Action Required')?'selected':'' ?> >NAR Calls/Emails-NAR Emails-No Action Required</option>
												<option value='NAR Calls/Emails-NAR Emails-Spam' <?php echo($ajio['tagging_evaluator']=='NAR Calls/Emails-NAR Emails-Spam')?'selected':'' ?> >NAR Calls/Emails-NAR Emails-Spam</option>
												<option value='NAR Calls/Emails-NAR Calls-Non Ajio Queries' <?php echo($ajio['tagging_evaluator']=='NAR Calls/Emails-NAR Calls-Non Ajio Queries')?'selected':'' ?> >NAR Calls/Emails-NAR Calls-Non Ajio Queries</option>
												<option value='NAR Calls/Emails-Test-Test Email' <?php echo($ajio['tagging_evaluator']=='NAR Calls/Emails-Test-Test Email')?'selected':'' ?> >NAR Calls/Emails-Test-Test Email</option>
												<option value='NAR Calls/Emails-NAR Emails-Duplicate email' <?php echo($ajio['tagging_evaluator']=='NAR Calls/Emails-NAR Emails-Duplicate email')?'selected':'' ?> >NAR Calls/Emails-NAR Emails-Duplicate email</option>
												<option value='Cancel-I want to cancel-Informed customer to refuse the delivery' <?php echo($ajio['tagging_evaluator']=='Cancel-I want to cancel-Informed customer to refuse the delivery')?'selected':'' ?> >Cancel-I want to cancel-Informed customer to refuse the delivery</option>
												<option value='NAR Calls/Emails-Prank Call-Prank Call' <?php echo($ajio['tagging_evaluator']=='NAR Calls/Emails-Prank Call-Prank Call')?'selected':'' ?> >NAR Calls/Emails-Prank Call-Prank Call</option>
												<option value='Order-I want to place an order-Placed an order through CS Cockpit' <?php echo($ajio['tagging_evaluator']=='Order-I want to place an order-Placed an order through CS Cockpit')?'selected':'' ?> >Order-I want to place an order-Placed an order through CS Cockpit</option>
												<option value='Order-I want to place an order-Informed customer of pin code serviceability' <?php echo($ajio['tagging_evaluator']=='Order-I want to place an order-Informed customer of pin code serviceability')?'selected':'' ?> >Order-I want to place an order-Informed customer of pin code serviceability</option>
												<option value='Other-I want Compensation-Convinced the customer - No Action Required' <?php echo($ajio['tagging_evaluator']=='Other-I want Compensation-Convinced the customer - No Action Required')?'selected':'' ?> >Other-I want Compensation-Convinced the customer - No Action Required</option>
												<option value='Order-Telesales-Order Placed' <?php echo($ajio['tagging_evaluator']=='Order-Telesales-Order Placed')?'selected':'' ?> >Order-Telesales-Order Placed</option>
												<option value='Order-I had a problem while placing an order-Clarified that order was Not Processed' <?php echo($ajio['tagging_evaluator']=='Order-I had a problem while placing an order-Clarified that order was Not Processed')?'selected':'' ?> >Order-I had a problem while placing an order-Clarified that order was Not Processed</option>
												<option value='Order-I had a problem while placing an order-Informed customer of pin code serviceability' <?php echo($ajio['tagging_evaluator']=='Order-I had a problem while placing an order-Informed customer of pin code serviceability')?'selected':'' ?> >Order-I had a problem while placing an order-Informed customer of pin code serviceability</option>
												<option value='Pre Order - F&L-Explain the features of the product-Explained about product features' <?php echo($ajio['tagging_evaluator']=='Pre Order - F&L-Explain the features of the product-Explained about product features')?'selected':'' ?> >Pre Order - F&L-Explain the features of the product-Explained about product features</option>
												<option value='Order-What are my delivery / payment options?-Informed customer of payment options' <?php echo($ajio['tagging_evaluator']=='Order-What are my delivery / payment options?-Informed customer of payment options')?'selected':'' ?> >Order-What are my delivery / payment options?-Informed customer of payment options</option>
												<option value='Other-I want Compensation-Transferred call to supervisor' <?php echo($ajio['tagging_evaluator']=='Other-I want Compensation-Transferred call to supervisor')?'selected':'' ?> >Other-I want Compensation-Transferred call to supervisor</option>
												<option value='Order-I want to modify my order (ph/addr etc)-Modified Ph. No. /Address on CS Cockpit' <?php echo($ajio['tagging_evaluator']=='Order-I want to modify my order (ph/addr etc)-Modified Ph. No. /Address on CS Cockpit')?'selected':'' ?> >Order-I want to modify my order (ph/addr etc)-Modified Ph. No. /Address on CS Cockpit</option>
												<option value='Order-What are the payment modes?-Informed customer of payment options' <?php echo($ajio['tagging_evaluator']=='Order-What are the payment modes?-Informed customer of payment options')?'selected':'' ?> >Order-What are the payment modes?-Informed customer of payment options</option>
												<option value='Other-I need to speak in regional language-Transferred call to other champ' <?php echo($ajio['tagging_evaluator']=='Other-I need to speak in regional language-Transferred call to other champ')?'selected':'' ?> >Other-I need to speak in regional language-Transferred call to other champ</option>
												<option value='Other-I want to know more about an offer/promotion-Explained that there is no current promotion at AJIO' <?php echo($ajio['tagging_evaluator']=='Other-I want to know more about an offer/promotion-Explained that there is no current promotion at AJIO')?'selected':'' ?> >Other-I want to know more about an offer/promotion-Explained that there is no current promotion at AJIO</option>
												<option value='Order-I want to modify my order (ph/addr etc)-Guided customer to modify details on website/app' <?php echo($ajio['tagging_evaluator']=='Order-I want to modify my order (ph/addr etc)-Guided customer to modify details on website/app')?'selected':'' ?> >Order-I want to modify my order (ph/addr etc)-Guided customer to modify details on website/app</option>
												<option value='Other-I want to know more about an offer/promotion-Explained the promotion to customer' <?php echo($ajio['tagging_evaluator']=='Other-I want to know more about an offer/promotion-Explained the promotion to customer')?'selected':'' ?> >Other-I want to know more about an offer/promotion-Explained the promotion to customer</option>
												<option value='Post Sales Service-Product not working as described after returns period-Guided customer to service Centre' <?php echo($ajio['tagging_evaluator']=='Post Sales Service-Product not working as described after returns period-Guided customer to service Centre')?'selected':'' ?> >Post Sales Service-Product not working as described after returns period-Guided customer to service Centre</option>
												<option value='Other-I need to talk to a supervisor-Transferred call to supervisor' <?php echo($ajio['tagging_evaluator']=='Other-I need to talk to a supervisor-Transferred call to supervisor')?'selected':'' ?> >Other-I need to talk to a supervisor-Transferred call to supervisor</option>
												<option value='Order-What are my delivery / payment options?-Informed customer of serviceability' <?php echo($ajio['tagging_evaluator']=='Order-What are my delivery / payment options?-Informed customer of serviceability')?'selected':'' ?> >Order-What are my delivery / payment options?-Informed customer of serviceability</option>
												<option value='Order-I want my Invoice-Emailed Invoice to the customer' <?php echo($ajio['tagging_evaluator']=='Order-I want my Invoice-Emailed Invoice to the customer')?'selected':'' ?> >Order-I want my Invoice-Emailed Invoice to the customer</option>
												<option value='Other-I need to speak in regional language-Informed about non-availability' <?php echo($ajio['tagging_evaluator']=='Other-I need to speak in regional language-Informed about non-availability')?'selected':'' ?> >Other-I need to speak in regional language-Informed about non-availability</option>
												<option value='Order-I had a problem while placing an order-Placed an order through CS Cockpit' <?php echo($ajio['tagging_evaluator']=='Order-I had a problem while placing an order-Placed an order through CS Cockpit')?'selected':'' ?> >Order-I had a problem while placing an order-Placed an order through CS Cockpit</option>
												<option value='Order-I had a problem while placing an order-Clarified that order was processed.' <?php echo($ajio['tagging_evaluator']=='Order-I had a problem while placing an order-Clarified that order was processed.')?'selected':'' ?> >Order-I had a problem while placing an order-Clarified that order was processed.</option>
												<option value='Pre Order - F&L-Where can i find this product?-Helped customer to find the product' <?php echo($ajio['tagging_evaluator']=='Pre Order - F&L-Where can i find this product?-Helped customer to find the product')?'selected':'' ?> >Pre Order - F&L-Where can i find this product?-Helped customer to find the product</option>
												<option value='Pre Order - F&L-Where can i find this product?-Informed customer that the product is not in stock' <?php echo($ajio['tagging_evaluator']=='Pre Order - F&L-Where can i find this product?-Informed customer that the product is not in stock')?'selected':'' ?> >Pre Order - F&L-Where can i find this product?-Informed customer that the product is not in stock</option>
												<option value='Pre Order - Tech Related - Mobile / Iphone-Product not working as described after returns period-Guided customer to service Centre' <?php echo($ajio['tagging_evaluator']=='Pre Order - Tech Related - Mobile / Iphone-Product not working as described after returns period-Guided customer to service Centre')?'selected':'' ?> >Pre Order - Tech Related - Mobile / Iphone-Product not working as described after returns period-Guided customer to service Centre</option>
												<option value='Order-I want to place an order-Guided customer on placing an order on website/app' <?php echo($ajio['tagging_evaluator']=='Order-I want to place an order-Guided customer on placing an order on website/app')?'selected':'' ?> >Order-I want to place an order-Guided customer on placing an order on website/app</option>
												<option value='Order-I had a problem while placing an order-Helped the customer to place the order on website/app' <?php echo($ajio['tagging_evaluator']=='Order-I had a problem while placing an order-Helped the customer to place the order on website/app')?'selected':'' ?> >Order-I had a problem while placing an order-Helped the customer to place the order on website/app</option>
												<option value='Pre Order - F&L-I need warranty information-Provided Information' <?php echo($ajio['tagging_evaluator']=='Pre Order - F&L-I need warranty information-Provided Information')?'selected':'' ?> >Pre Order - F&L-I need warranty information-Provided Information</option>
												<option value='Pre Order - Tech Related - Mobile / Iphone-I need warranty information-Provided Information' <?php echo($ajio['tagging_evaluator']=='Pre Order - Tech Related - Mobile / Iphone-I need warranty information-Provided Information')?'selected':'' ?> >Pre Order - Tech Related - Mobile / Iphone-I need warranty information-Provided Information</option>
												<option value='Pre Order - Tech Related - Jio Fi-Where can I buy Accessory-Provided Information' <?php echo($ajio['tagging_evaluator']=='Pre Order - Tech Related - Jio Fi-Where can I buy Accessory-Provided Information')?'selected':'' ?> >Pre Order - Tech Related - Jio Fi-Where can I buy Accessory-Provided Information</option>
												<option value='Pre Order - Tech Related - Mobile / Iphone-Where can I buy Accessory-Provided Information' <?php echo($ajio['tagging_evaluator']=='Pre Order - Tech Related - Mobile / Iphone-Where can I buy Accessory-Provided Information')?'selected':'' ?> >Pre Order - Tech Related - Mobile / Iphone-Where can I buy Accessory-Provided Information</option>
												<option value='Pre Order - Tech Related - Mobile / Iphone-Where can i find this product?-Informed customer that the product is not in stock' <?php echo($ajio['tagging_evaluator']=='Pre Order - Tech Related - Mobile / Iphone-Where can i find this product?-Informed customer that the product is not in stock')?'selected':'' ?> >Pre Order - Tech Related - Mobile / Iphone-Where can i find this product?-Informed customer that the product is not in stock</option>
												<option value='Pre Order - Tech Related - Jio Fi-I need warranty information-Provided Information' <?php echo($ajio['tagging_evaluator']=='Pre Order - Tech Related - Jio Fi-I need warranty information-Provided Information')?'selected':'' ?> >Pre Order - Tech Related - Jio Fi-I need warranty information-Provided Information</option>
												<option value='Pre Order - Tech Related - Others-Product not working as described after returns period-Guided customer to service Centre' <?php echo($ajio['tagging_evaluator']=='Pre Order - Tech Related - Others-Product not working as described after returns period-Guided customer to service Centre')?'selected':'' ?> >Pre Order - Tech Related - Others-Product not working as described after returns period-Guided customer to service Centre</option>
												<option value='Pre Order - Tech Related - Others-Where can i find this product?-Helped customer to find the product' <?php echo($ajio['tagging_evaluator']=='Pre Order - Tech Related - Others-Where can i find this product?-Helped customer to find the product')?'selected':'' ?> >Pre Order - Tech Related - Others-Where can i find this product?-Helped customer to find the product</option>
												<option value='Pre Order - Tech Related - Others-Where can I buy Accessory-Provided Information' <?php echo($ajio['tagging_evaluator']=='Pre Order - Tech Related - Others-Where can I buy Accessory-Provided Information')?'selected':'' ?> >Pre Order - Tech Related - Others-Where can I buy Accessory-Provided Information</option>
												<option value='Price-Whats the price for this order?-Informed customer about cost split' <?php echo($ajio['tagging_evaluator']=='Price-Whats the price for this order?-Informed customer about cost split')?'selected':'' ?> >Price-Whats the price for this order?-Informed customer about cost split</option>
												<option value='Price-How much does Gift Wrap cost?-Guided customer on gift wrap charges' <?php echo($ajio['tagging_evaluator']=='Price-How much does Gift Wrap cost?-Guided customer on gift wrap charges')?'selected':'' ?> >Price-How much does Gift Wrap cost?-Guided customer on gift wrap charges</option>
												<option value='Refund-Where is my Refund?-Informed customer about self-ship status' <?php echo($ajio['tagging_evaluator']=='Refund-Where is my Refund?-Informed customer about self-ship status')?'selected':'' ?> >Refund-Where is my Refund?-Informed customer about self-ship status</option>
												<option value='Refund-How do I get my money back?-Informed customer about COD refund' <?php echo($ajio['tagging_evaluator']=='Refund-How do I get my money back?-Informed customer about COD refund')?'selected':'' ?> >Refund-How do I get my money back?-Informed customer about COD refund</option>
												<option value='Refund-How do I get my money back?-Informed Customer about IMPS procedure' <?php echo($ajio['tagging_evaluator']=='Refund-How do I get my money back?-Informed Customer about IMPS procedure')?'selected':'' ?> >Refund-How do I get my money back?-Informed Customer about IMPS procedure</option>
												<option value='Refund-How long does it take to reflect in account once Refund is initiated?-Informed customer of time to refund' <?php echo($ajio['tagging_evaluator']=='Refund-How long does it take to reflect in account once Refund is initiated?-Informed customer of time to refund')?'selected':'' ?> >Refund-How long does it take to reflect in account once Refund is initiated?-Informed customer of time to refund</option>
												<option value='Refund-Enable my IMPS Refund-Enabled the IMPS switch' <?php echo($ajio['tagging_evaluator']=='Refund-Enable my IMPS Refund-Enabled the IMPS switch')?'selected':'' ?> >Refund-Enable my IMPS Refund-Enabled the IMPS switch</option>
												<option value='Refund-My refund has not reflected in source account-Provided Reference No. for CC/DC/NB' <?php echo($ajio['tagging_evaluator']=='Refund-My refund has not reflected in source account-Provided Reference No. for CC/DC/NB')?'selected':'' ?> >Refund-My refund has not reflected in source account-Provided Reference No. for CC/DC/NB</option>
												<option value='Refund-Where is my Refund?-JioMoney refund is processed - informed to wait for 2 business days' <?php echo($ajio['tagging_evaluator']=='Refund-Where is my Refund?-JioMoney refund is processed - informed to wait for 2 business days')?'selected':'' ?> >Refund-Where is my Refund?-JioMoney refund is processed - informed to wait for 2 business days</option>
												<option value='Refund-My refund has not reflected in source account-Provided Reference No. for e-wallets' <?php echo($ajio['tagging_evaluator']=='Refund-My refund has not reflected in source account-Provided Reference No. for e-wallets')?'selected':'' ?> >Refund-My refund has not reflected in source account-Provided Reference No. for e-wallets</option>
												<option value='Refund-Where is my Refund?-Informed about Refund TAT' <?php echo($ajio['tagging_evaluator']=='Refund-Where is my Refund?-Informed about Refund TAT')?'selected':'' ?> >Refund-Where is my Refund?-Informed about Refund TAT</option>
												<option value='Refund-Where is my Refund?-Prepaid refund is processed - informed to wait for 5-7 business days' <?php echo($ajio['tagging_evaluator']=='Refund-Where is my Refund?-Prepaid refund is processed - informed to wait for 5-7 business days')?'selected':'' ?> >Refund-Where is my Refund?-Prepaid refund is processed - informed to wait for 5-7 business days</option>
												<option value='Refund-How do I get my money back?-Informed customer about Wallet Refund' <?php echo($ajio['tagging_evaluator']=='Refund-How do I get my money back?-Informed customer about Wallet Refund')?'selected':'' ?> >Refund-How do I get my money back?-Informed customer about Wallet Refund</option>
												<option value='Refund-Where is my Refund?-IMPS refund is processed - informed to wait for 1 business day' <?php echo($ajio['tagging_evaluator']=='Refund-Where is my Refund?-IMPS refund is processed - informed to wait for 1 business day')?'selected':'' ?> >Refund-Where is my Refund?-IMPS refund is processed - informed to wait for 1 business day</option>
												<option value='Refund-How do I get my money back?-Informed customer about Prepaid Refund' <?php echo($ajio['tagging_evaluator']=='Refund-How do I get my money back?-Informed customer about Prepaid Refund')?'selected':'' ?> >Refund-How do I get my money back?-Informed customer about Prepaid Refund</option>
												<option value='Refund-There is a discrepancy with my store credits-Clarified discrepancy with customer' <?php echo($ajio['tagging_evaluator']=='Refund-There is a discrepancy with my store credits-Clarified discrepancy with customer')?'selected':'' ?> >Refund-There is a discrepancy with my store credits-Clarified discrepancy with customer</option>
												<option value='Refund-My refund has not reflected in source account-Provided reference number for IMPS' <?php echo($ajio['tagging_evaluator']=='Refund-My refund has not reflected in source account-Provided reference number for IMPS')?'selected':'' ?> >Refund-My refund has not reflected in source account-Provided reference number for IMPS</option>
												<option value='Return/Exchange-Create a return for me-Created Return - Received Damaged Product' <?php echo($ajio['tagging_evaluator']=='Return/Exchange-Create a return for me-Created Return - Received Damaged Product')?'selected':'' ?> >Return/Exchange-Create a return for me-Created Return - Received Damaged Product</option>
												<option value='Return/Exchange-Create a return for me-Created Return - Different Product delivered' <?php echo($ajio['tagging_evaluator']=='Return/Exchange-Create a return for me-Created Return - Different Product delivered')?'selected':'' ?> >Return/Exchange-Create a return for me-Created Return - Different Product delivered</option>
												<option value='Return/Exchange-Create a return for me-Created Return - Wrong size delivered' <?php echo($ajio['tagging_evaluator']=='Return/Exchange-Create a return for me-Created Return - Wrong size delivered')?'selected':'' ?> >Return/Exchange-Create a return for me-Created Return - Wrong size delivered</option>
												<option value='Return/Exchange-Create a return for me-Created Return - Product damaged post usage' <?php echo($ajio['tagging_evaluator']=='Return/Exchange-Create a return for me-Created Return - Product damaged post usage')?'selected':'' ?> >Return/Exchange-Create a return for me-Created Return - Product damaged post usage</option>
												<option value='Refund-Why is my return rejected/put on hold?-Guided customer on reason' <?php echo($ajio['tagging_evaluator']=='Refund-Why is my return rejected/put on hold?-Guided customer on reason')?'selected':'' ?> >Refund-Why is my return rejected/put on hold?-Guided customer on reason</option>
												<option value='Return/Exchange-Create a return for me-Defective Product received' <?php echo($ajio['tagging_evaluator']=='Return/Exchange-Create a return for me-Defective Product received')?'selected':'' ?> >Return/Exchange-Create a return for me-Defective Product received</option>
												<option value='Return/Exchange-Create a return for me-Created Return for customer' <?php echo($ajio['tagging_evaluator']=='Return/Exchange-Create a return for me-Created Return for customer')?'selected':'' ?> >Return/Exchange-Create a return for me-Created Return for customer</option>
												<option value='Return/Exchange-Create a return for me-Wrong Product delivered' <?php echo($ajio['tagging_evaluator']=='Return/Exchange-Create a return for me-Wrong Product delivered')?'selected':'' ?> >Return/Exchange-Create a return for me-Wrong Product delivered</option>
												<option value='Return/Exchange-Create a return for me-Created Return for Used Product' <?php echo($ajio['tagging_evaluator']=='Return/Exchange-Create a return for me-Created Return for Used Product')?'selected':'' ?> >Return/Exchange-Create a return for me-Created Return for Used Product</option>
												<option value='Return/Exchange-Create a return for me-Seal tampered cases' <?php echo($ajio['tagging_evaluator']=='Return/Exchange-Create a return for me-Seal tampered cases')?'selected':'' ?> >Return/Exchange-Create a return for me-Seal tampered cases</option>
												<option value='Return/Exchange-Create an Exchange for me-Created Exchange for customer' <?php echo($ajio['tagging_evaluator']=='Return/Exchange-Create an Exchange for me-Created Exchange for customer')?'selected':'' ?> >Return/Exchange-Create an Exchange for me-Created Exchange for customer</option>
												<option value='Return/Exchange-Create a return for me-Created Return - Wrong colour delivered' <?php echo($ajio['tagging_evaluator']=='Return/Exchange-Create a return for me-Created Return - Wrong colour delivered')?'selected':'' ?> >Return/Exchange-Create a return for me-Created Return - Wrong colour delivered</option>
												<option value='Return/Exchange-Create an Exchange for me-Created Exchange – Received Damaged Product' <?php echo($ajio['tagging_evaluator']=='Return/Exchange-Create an Exchange for me-Created Exchange – Received Damaged Product')?'selected':'' ?> >Return/Exchange-Create an Exchange for me-Created Exchange – Received Damaged Product</option>
												<option value='Return/Exchange-Create an Exchange for me-Created Return due to lack of size' <?php echo($ajio['tagging_evaluator']=='Return/Exchange-Create an Exchange for me-Created Return due to lack of size')?'selected':'' ?> >Return/Exchange-Create an Exchange for me-Created Return due to lack of size</option>
												<option value='Return/Exchange-Has my Self-Ship Return reached you?-Asked to check with customers courier company' <?php echo($ajio['tagging_evaluator']=='Return/Exchange-Has my Self-Ship Return reached you?-Asked to check with customers courier company')?'selected':'' ?> >Return/Exchange-Has my Self-Ship Return reached you?-Asked to check with customers courier company</option>
												<option value='Return/Exchange-Has my Self-Ship Return reached you?-Informed - Reached Warehouse and Refund pending' <?php echo($ajio['tagging_evaluator']=='Return/Exchange-Has my Self-Ship Return reached you?-Informed - Reached Warehouse and Refund pending')?'selected':'' ?> >Return/Exchange-Has my Self-Ship Return reached you?-Informed - Reached Warehouse and Refund pending</option>
												<option value='Return/Exchange-Exchange Related-Informed – product will get exchanged' <?php echo($ajio['tagging_evaluator']=='Return/Exchange-Exchange Related-Informed – product will get exchanged')?'selected':'' ?> >Return/Exchange-Exchange Related-Informed – product will get exchanged</option>
												<option value='Return/Exchange-Create a return for me-Empty Parcel received' <?php echo($ajio['tagging_evaluator']=='Return/Exchange-Create a return for me-Empty Parcel received')?'selected':'' ?> >Return/Exchange-Create a return for me-Empty Parcel received</option>
												<option value='Return/Exchange-Has my Self-Ship Return reached you?-Others' <?php echo($ajio['tagging_evaluator']=='Return/Exchange-Has my Self-Ship Return reached you?-Others')?'selected':'' ?> >Return/Exchange-Has my Self-Ship Return reached you?-Others</option>
												<option value='Return/Exchange-Create a return for me-Created Return - Tags/Shoebox missing' <?php echo($ajio['tagging_evaluator']=='Return/Exchange-Create a return for me-Created Return - Tags/Shoebox missing')?'selected':'' ?> >Return/Exchange-Create a return for me-Created Return - Tags/Shoebox missing</option>
												<option value='Return/Exchange-Has my Self-Ship Return reached you?-Informed - Reached Warehouse and Refund initiated' <?php echo($ajio['tagging_evaluator']=='Return/Exchange-Has my Self-Ship Return reached you?-Informed - Reached Warehouse and Refund initiated')?'selected':'' ?> >Return/Exchange-Has my Self-Ship Return reached you?-Informed - Reached Warehouse and Refund initiated</option>
												<option value='Return/Exchange-Customer claiming product picked up-Asked to share acknowledgement copy' <?php echo($ajio['tagging_evaluator']=='Return/Exchange-Customer claiming product picked up-Asked to share acknowledgement copy')?'selected':'' ?> >Return/Exchange-Customer claiming product picked up-Asked to share acknowledgement copy</option>
												<option value='Return/Exchange-How do I return/exchange this item?-Declined - Time Period lapsed' <?php echo($ajio['tagging_evaluator']=='Return/Exchange-How do I return/exchange this item?-Declined - Time Period lapsed')?'selected':'' ?> >Return/Exchange-How do I return/exchange this item?-Declined - Time Period lapsed</option>
												<option value='Return/Exchange-How do I return/exchange this item?-Email sent to confirm policy - Fitment Issue' <?php echo($ajio['tagging_evaluator']=='Return/Exchange-How do I return/exchange this item?-Email sent to confirm policy - Fitment Issue')?'selected':'' ?> >Return/Exchange-How do I return/exchange this item?-Email sent to confirm policy - Fitment Issue</option>
												<option value='Return/Exchange-How do I return/exchange this item?-Informed Return Policy - others' <?php echo($ajio['tagging_evaluator']=='Return/Exchange-How do I return/exchange this item?-Informed Return Policy - others')?'selected':'' ?> >Return/Exchange-How do I return/exchange this item?-Informed Return Policy - others</option>
												<option value='Return/Exchange-Has my Self-Ship Return reached you?-Updated tracking number for the customer' <?php echo($ajio['tagging_evaluator']=='Return/Exchange-Has my Self-Ship Return reached you?-Updated tracking number for the customer')?'selected':'' ?> >Return/Exchange-Has my Self-Ship Return reached you?-Updated tracking number for the customer</option>
												<option value='Return/Exchange-How do I return/exchange this item?-Educated Customer on Exchange Policy' <?php echo($ajio['tagging_evaluator']=='Return/Exchange-How do I return/exchange this item?-Educated Customer on Exchange Policy')?'selected':'' ?> >Return/Exchange-How do I return/exchange this item?-Educated Customer on Exchange Policy</option>
												<option value='Return/Exchange-How do I return/exchange this item?-Declined - Product Used' <?php echo($ajio['tagging_evaluator']=='Return/Exchange-How do I return/exchange this item?-Declined - Product Used')?'selected':'' ?> >Return/Exchange-How do I return/exchange this item?-Declined - Product Used</option>
												<option value='Return/Exchange-How do I return/exchange this item?-Declined - Non returnable product' <?php echo($ajio['tagging_evaluator']=='Return/Exchange-How do I return/exchange this item?-Declined - Non returnable product')?'selected':'' ?> >Return/Exchange-How do I return/exchange this item?-Declined - Non returnable product</option>
												<option value='Return/Exchange-How do I return/exchange this item?-Declined – Non exchangeable product' <?php echo($ajio['tagging_evaluator']=='Return/Exchange-How do I return/exchange this item?-Declined – Non exchangeable product')?'selected':'' ?> >Return/Exchange-How do I return/exchange this item?-Declined – Non exchangeable product</option>
												<option value='Return/Exchange-How do I return/exchange this item?-Declined - tags/shoebox missing' <?php echo($ajio['tagging_evaluator']=='Return/Exchange-How do I return/exchange this item?-Declined - tags/shoebox missing')?'selected':'' ?> >Return/Exchange-How do I return/exchange this item?-Declined - tags/shoebox missing</option>
												<option value='Return/Exchange-How do I return/exchange this item?-Requested image for wrong product delivered' <?php echo($ajio['tagging_evaluator']=='Return/Exchange-How do I return/exchange this item?-Requested image for wrong product delivered')?'selected':'' ?> >Return/Exchange-How do I return/exchange this item?-Requested image for wrong product delivered</option>
												<option value='Return/Exchange-How do I return/exchange this item?-Email sent to confirm policy - Didnot like product' <?php echo($ajio['tagging_evaluator']=='Return/Exchange-How do I return/exchange this item?-Email sent to confirm policy - Didnot like product')?'selected':'' ?> >Return/Exchange-How do I return/exchange this item?-Email sent to confirm policy - Didnot like product</option>
												<option value='Return/Exchange-Unable to create return on website/mobile-Created Return for customer' <?php echo($ajio['tagging_evaluator']=='Return/Exchange-Unable to create return on website/mobile-Created Return for customer')?'selected':'' ?> >Return/Exchange-Unable to create return on website/mobile-Created Return for customer</option>
												<option value='Return/Exchange-How do I return/exchange this item?-Educated customer on Self Service steps' <?php echo($ajio['tagging_evaluator']=='Return/Exchange-How do I return/exchange this item?-Educated customer on Self Service steps')?'selected':'' ?> >Return/Exchange-How do I return/exchange this item?-Educated customer on Self Service steps</option>
												<option value='Return/Exchange-How do I return/exchange this item?-Informed Return Policy - products' <?php echo($ajio['tagging_evaluator']=='Return/Exchange-How do I return/exchange this item?-Informed Return Policy - products')?'selected':'' ?> >Return/Exchange-How do I return/exchange this item?-Informed Return Policy - products</option>
												<option value='Return/Exchange-Pickup related-Provided shipping address' <?php echo($ajio['tagging_evaluator']=='Return/Exchange-Pickup related-Provided shipping address')?'selected':'' ?> >Return/Exchange-Pickup related-Provided shipping address</option>
												<option value='Return/Exchange-Pickup related-Informed - Reached WH and Refund initiated' <?php echo($ajio['tagging_evaluator']=='Return/Exchange-Pickup related-Informed - Reached WH and Refund initiated')?'selected':'' ?> >Return/Exchange-Pickup related-Informed - Reached WH and Refund initiated</option>
												<option value='Return/Exchange-Pickup related-Others' <?php echo($ajio['tagging_evaluator']=='Return/Exchange-Pickup related-Others')?'selected':'' ?> >Return/Exchange-Pickup related-Others</option>
												<option value='Return/Exchange-Pickup related-Provided information on packing product' <?php echo($ajio['tagging_evaluator']=='Return/Exchange-Pickup related-Provided information on packing product')?'selected':'' ?> >Return/Exchange-Pickup related-Provided information on packing product</option>
												<option value='Return/Exchange-Pickup related-Informed - product will be picked up' <?php echo($ajio['tagging_evaluator']=='Return/Exchange-Pickup related-Informed - product will be picked up')?'selected':'' ?> >Return/Exchange-Pickup related-Informed - product will be picked up</option>
												<option value='Return/Exchange-Pickup related-Informed - picked up product still has to reach Warehouse' <?php echo($ajio['tagging_evaluator']=='Return/Exchange-Pickup related-Informed - picked up product still has to reach Warehouse')?'selected':'' ?> >Return/Exchange-Pickup related-Informed - picked up product still has to reach Warehouse</option>
												<option value='Return/Exchange-Is my pin code serviceable for Exchange/Return?-Explained pin-code Serviceability' <?php echo($ajio['tagging_evaluator']=='Return/Exchange-Is my pin code serviceable for Exchange/Return?-Explained pin-code Serviceability')?'selected':'' ?> >Return/Exchange-Is my pin code serviceable for Exchange/Return?-Explained pin-code Serviceability</option>
												<option value='Website-Access/Function-Helped in returning order' <?php echo($ajio['tagging_evaluator']=='Website-Access/Function-Helped in returning order')?'selected':'' ?> >Website-Access/Function-Helped in returning order</option>
												<option value='Website-Access/Function-Helped in accessing page/site' <?php echo($ajio['tagging_evaluator']=='Website-Access/Function-Helped in accessing page/site')?'selected':'' ?> >Website-Access/Function-Helped in accessing page/site</option>
												<option value='Ticket-Cx-Shared attachment-Cx-Shared attachment' <?php echo($ajio['tagging_evaluator']=='Ticket-Cx-Shared attachment-Cx-Shared attachment')?'selected':'' ?> >Ticket-Cx-Shared attachment-Cx-Shared attachment</option>
												<option value='Website-Access/Function-Helped in viewing account details' <?php echo($ajio['tagging_evaluator']=='Website-Access/Function-Helped in viewing account details')?'selected':'' ?> >Website-Access/Function-Helped in viewing account details</option>
												<option value='Website-Access/Function-Helped in cancelling order' <?php echo($ajio['tagging_evaluator']=='Website-Access/Function-Helped in cancelling order')?'selected':'' ?> >Website-Access/Function-Helped in cancelling order</option>
												<option value='Website-Access/Function-Helped in signup/login' <?php echo($ajio['tagging_evaluator']=='Website-Access/Function-Helped in signup/login')?'selected':'' ?> >Website-Access/Function-Helped in signup/login</option>
												<option value='Website-How to shop on App?-Guided customer to visit the App' <?php echo($ajio['tagging_evaluator']=='Website-How to shop on App?-Guided customer to visit the App')?'selected':'' ?> >Website-How to shop on App?-Guided customer to visit the App</option>
												<option value='Website-How to shop on m-site?-Guided customer to visit the mobile site' <?php echo($ajio['tagging_evaluator']=='Website-How to shop on m-site?-Guided customer to visit the mobile site')?'selected':'' ?> >Website-How to shop on m-site?-Guided customer to visit the mobile site</option>
												<option value='OB-Delayed Delivery-To Be Delivered' <?php echo($ajio['tagging_evaluator']=='OB-Delayed Delivery-To Be Delivered')?'selected':'' ?> >OB-Delayed Delivery-To Be Delivered</option>
												<option value='OB-Delayed Delivery-Not Connected' <?php echo($ajio['tagging_evaluator']=='OB-Delayed Delivery-Not Connected')?'selected':'' ?> >OB-Delayed Delivery-Not Connected</option>
												<option value='OB-Delayed Delivery-Delivered' <?php echo($ajio['tagging_evaluator']=='OB-Delayed Delivery-Delivered')?'selected':'' ?> >OB-Delayed Delivery-Delivered</option>
												<option value='OB-Delayed Delivery-RTO' <?php echo($ajio['tagging_evaluator']=='OB-Delayed Delivery-RTO')?'selected':'' ?> >OB-Delayed Delivery-RTO</option>
												<option value='Website-Please explain AJIO-Explained about website' <?php echo($ajio['tagging_evaluator']=='Website-Please explain AJIO-Explained about website')?'selected':'' ?> >Website-Please explain AJIO-Explained about website</option>
												<option value='OB-Order In Progress-Not Connected' <?php echo($ajio['tagging_evaluator']=='OB-Order In Progress-Not Connected')?'selected':'' ?> >OB-Order In Progress-Not Connected</option>
												<option value='OB-NDR-Delivered' <?php echo($ajio['tagging_evaluator']=='OB-NDR-Delivered')?'selected':'' ?> >OB-NDR-Delivered</option>
												<option value='OB-Misc-Informed' <?php echo($ajio['tagging_evaluator']=='OB-Misc-Informed')?'selected':'' ?> >OB-Misc-Informed</option>
												<option value='OB-NDR-To Be Delivered' <?php echo($ajio['tagging_evaluator']=='OB-NDR-To Be Delivered')?'selected':'' ?> >OB-NDR-To Be Delivered</option>
												<option value='OB-Misc-Not Connected' <?php echo($ajio['tagging_evaluator']=='OB-Misc-Not Connected')?'selected':'' ?> >OB-Misc-Not Connected</option>
												<option value='OB-Order In Progress-MRP Mismatch - Credit' <?php echo($ajio['tagging_evaluator']=='OB-Order In Progress-MRP Mismatch - Credit')?'selected':'' ?> >OB-Order In Progress-MRP Mismatch - Credit</option>
												<option value='OB-Order In Progress-MRP Mismatch - Waiver' <?php echo($ajio['tagging_evaluator']=='OB-Order In Progress-MRP Mismatch - Waiver')?'selected':'' ?> >OB-Order In Progress-MRP Mismatch - Waiver</option>
												<option value='OB-Order In Progress-Short Pick - Partially Cancelled' <?php echo($ajio['tagging_evaluator']=='OB-Order In Progress-Short Pick - Partially Cancelled')?'selected':'' ?> >OB-Order In Progress-Short Pick - Partially Cancelled</option>
												<option value='OB-Order In Progress-MRP Mismatch - Cancelled' <?php echo($ajio['tagging_evaluator']=='OB-Order In Progress-MRP Mismatch - Cancelled')?'selected':'' ?> >OB-Order In Progress-MRP Mismatch - Cancelled</option>
												<option value='OB-Order In Progress-Sales Tax - To be RTOed' <?php echo($ajio['tagging_evaluator']=='OB-Order In Progress-Sales Tax - To be RTOed')?'selected':'' ?> >OB-Order In Progress-Sales Tax - To be RTOed</option>
												<option value='OB-Order In Progress-Sales Tax - To be delivered' <?php echo($ajio['tagging_evaluator']=='OB-Order In Progress-Sales Tax - To be delivered')?'selected':'' ?> >OB-Order In Progress-Sales Tax - To be delivered</option>
												<option value='OB-Order In Progress-Order Lost - Informed' <?php echo($ajio['tagging_evaluator']=='OB-Order In Progress-Order Lost - Informed')?'selected':'' ?> >OB-Order In Progress-Order Lost - Informed</option>
												<option value='OB-Callback-Not Connected' <?php echo($ajio['tagging_evaluator']=='OB-Callback-Not Connected')?'selected':'' ?> >OB-Callback-Not Connected</option>
												<option value='OB-Ticket-Not Connected' <?php echo($ajio['tagging_evaluator']=='OB-Ticket-Not Connected')?'selected':'' ?> >OB-Ticket-Not Connected</option>
												<option value='OB-Order In Progress-Telesales - Cancelled' <?php echo($ajio['tagging_evaluator']=='OB-Order In Progress-Telesales - Cancelled')?'selected':'' ?> >OB-Order In Progress-Telesales - Cancelled</option>
												<option value='OB-Order In Progress-OOS - Informed' <?php echo($ajio['tagging_evaluator']=='OB-Order In Progress-OOS - Informed')?'selected':'' ?> >OB-Order In Progress-OOS - Informed</option>
												<option value='OB-Order In Progress-Short Pick - Cancelled' <?php echo($ajio['tagging_evaluator']=='OB-Order In Progress-Short Pick - Cancelled')?'selected':'' ?> >OB-Order In Progress-Short Pick - Cancelled</option>
												<option value='OB-Cancellation due to QC fail-Not Connected' <?php echo($ajio['tagging_evaluator']=='OB-Cancellation due to QC fail-Not Connected')?'selected':'' ?> >OB-Cancellation due to QC fail-Not Connected</option>
												<option value='OB-Ticket-Ticket Created' <?php echo($ajio['tagging_evaluator']=='OB-Ticket-Ticket Created')?'selected':'' ?> >OB-Ticket-Ticket Created</option>
												<option value='OB-Cancellation due to QC fail-Informed' <?php echo($ajio['tagging_evaluator']=='OB-Cancellation due to QC fail-Informed')?'selected':'' ?> >OB-Cancellation due to QC fail-Informed</option>
												<option value='OB-Survey-Not Connected' <?php echo($ajio['tagging_evaluator']=='OB-Survey-Not Connected')?'selected':'' ?> >OB-Survey-Not Connected</option>
												<option value='OB-Ticket-Ticket Escalation' <?php echo($ajio['tagging_evaluator']=='OB-Ticket-Ticket Escalation')?'selected':'' ?> >OB-Ticket-Ticket Escalation</option>
												<option value='OB-Ticket-Ticket Closed' <?php echo($ajio['tagging_evaluator']=='OB-Ticket-Ticket Closed')?'selected':'' ?> >OB-Ticket-Ticket Closed</option>
												<option value='OB-Ticket-Ticket Follow Up' <?php echo($ajio['tagging_evaluator']=='OB-Ticket-Ticket Follow Up')?'selected':'' ?> >OB-Ticket-Ticket Follow Up</option>
												<option value='OB-Survey-Incomplete Survey' <?php echo($ajio['tagging_evaluator']=='OB-Survey-Incomplete Survey')?'selected':'' ?> >OB-Survey-Incomplete Survey</option>
												<option value='OB-NDR-To Be Delivered - Fake Remarks' <?php echo($ajio['tagging_evaluator']=='OB-NDR-To Be Delivered - Fake Remarks')?'selected':'' ?> >OB-NDR-To Be Delivered - Fake Remarks</option>
												<option value='OB-Survey-Completed' <?php echo($ajio['tagging_evaluator']=='OB-Survey-Completed')?'selected':'' ?> >OB-Survey-Completed</option>
												<option value='OB-NDR-Not Contactable2' <?php echo($ajio['tagging_evaluator']=='OB-NDR-Not Contactable2')?'selected':'' ?> >OB-NDR-Not Contactable2</option>
												<option value='OB-NDR-Not Contactable1' <?php echo($ajio['tagging_evaluator']=='OB-NDR-Not Contactable1')?'selected':'' ?> >OB-NDR-Not Contactable1</option>
												<option value='OB-NPR-Picked Up' <?php echo($ajio['tagging_evaluator']=='OB-NPR-Picked Up')?'selected':'' ?> >OB-NPR-Picked Up</option>
												<option value='OB-NPR-Not Contactable3' <?php echo($ajio['tagging_evaluator']=='OB-NPR-Not Contactable3')?'selected':'' ?> >OB-NPR-Not Contactable3</option>
												<option value='OB-NPR-To Be Picked Up - Fake Remarks' <?php echo($ajio['tagging_evaluator']=='OB-NPR-To Be Picked Up - Fake Remarks')?'selected':'' ?> >OB-NPR-To Be Picked Up - Fake Remarks</option>
												<option value='OB-NPR-Pickup Cancelled' <?php echo($ajio['tagging_evaluator']=='OB-NPR-Pickup Cancelled')?'selected':'' ?> >OB-NPR-Pickup Cancelled</option>
												<option value='OB-NPR-Not Contactable2' <?php echo($ajio['tagging_evaluator']=='OB-NPR-Not Contactable2')?'selected':'' ?> >OB-NPR-Not Contactable2</option>
												<option value='OB-NPR-To Be Picked Up' <?php echo($ajio['tagging_evaluator']=='OB-NPR-To Be Picked Up')?'selected':'' ?> >OB-NPR-To Be Picked Up</option>
												<option value='OB-NDR-Not Contactable3' <?php echo($ajio['tagging_evaluator']=='OB-NDR-Not Contactable3')?'selected':'' ?> >OB-NDR-Not Contactable3</option>
												<option value='OB-NPR-Not Contactable1' <?php echo($ajio['tagging_evaluator']=='OB-NPR-Not Contactable1')?'selected':'' ?> >OB-NPR-Not Contactable1</option>
												<option value='OB-NDR-To Be RTO - Fake Remarks' <?php echo($ajio['tagging_evaluator']=='OB-NDR-To Be RTO - Fake Remarks')?'selected':'' ?> >OB-NDR-To Be RTO - Fake Remarks</option>
												<option value='OB-NDR-To Be RTO' <?php echo($ajio['tagging_evaluator']=='OB-NDR-To Be RTO')?'selected':'' ?> >OB-NDR-To Be RTO</option>
												<option value='Feedback-Others-N/A' <?php echo($ajio['tagging_evaluator']=='Feedback-Others-N/A')?'selected':'' ?> >Feedback-Others-N/A</option>
												<option value='Feedback-Suggestions about Website-N/A' <?php echo($ajio['tagging_evaluator']=='Feedback-Suggestions about Website-N/A')?'selected':'' ?> >Feedback-Suggestions about Website-N/A</option>
												<option value='Feedback-Suggestions about CC-N/A' <?php echo($ajio['tagging_evaluator']=='Feedback-Suggestions about CC-N/A')?'selected':'' ?> >Feedback-Suggestions about CC-N/A</option>
												<option value='Feedback-Suggestions about Warehouse-N/A' <?php echo($ajio['tagging_evaluator']=='Feedback-Suggestions about Warehouse-N/A')?'selected':'' ?> >Feedback-Suggestions about Warehouse-N/A</option>
												<option value='Feedback-Suggestions about Profile-N/A' <?php echo($ajio['tagging_evaluator']=='Feedback-Suggestions about Profile-N/A')?'selected':'' ?> >Feedback-Suggestions about Profile-N/A</option>
												<option value='Feedback-Suggestions about Returns/Exchange-N/A' <?php echo($ajio['tagging_evaluator']=='Feedback-Suggestions about Returns/Exchange-N/A')?'selected':'' ?> >Feedback-Suggestions about Returns/Exchange-N/A</option>
												<option value='Feedback-Suggestions about Delivery-N/A' <?php echo($ajio['tagging_evaluator']=='Feedback-Suggestions about Delivery-N/A')?'selected':'' ?> >Feedback-Suggestions about Delivery-N/A</option>
												<option value='Feedback-Suggestions about CC-Unable to reach customer care number' <?php echo($ajio['tagging_evaluator']=='Feedback-Suggestions about CC-Unable to reach customer care number')?'selected':'' ?> >Feedback-Suggestions about CC-Unable to reach customer care number</option>
												<option value='Feedback-Suggestions about Products-N/A' <?php echo($ajio['tagging_evaluator']=='Feedback-Suggestions about Products-N/A')?'selected':'' ?> >Feedback-Suggestions about Products-N/A</option>
												<option value='Feedback-Suggestions about CC-Others' <?php echo($ajio['tagging_evaluator']=='Feedback-Suggestions about CC-Others')?'selected':'' ?> >Feedback-Suggestions about CC-Others</option>
												<option value='Feedback-Suggestions about Refund-N/A' <?php echo($ajio['tagging_evaluator']=='Feedback-Suggestions about Refund-N/A')?'selected':'' ?> >Feedback-Suggestions about Refund-N/A</option>
												<option value='Feedback-Mobile App-Feedback/Suggestion about mobile App' <?php echo($ajio['tagging_evaluator']=='Feedback-Mobile App-Feedback/Suggestion about mobile App')?'selected':'' ?> >Feedback-Mobile App-Feedback/Suggestion about mobile App</option>
												<option value='Online Refund-Refund not done against Reference No. - Prepaid cancelled-N/A' <?php echo($ajio['tagging_evaluator']=='Online Refund-Refund not done against Reference No. - Prepaid cancelled-N/A')?'selected':'' ?> >Online Refund-Refund not done against Reference No. - Prepaid cancelled-N/A</option>
												<option value='WH - Order Related Issues-Forward-Shipment Lost to be refunded' <?php echo($ajio['tagging_evaluator']=='WH - Order Related Issues-Forward-Shipment Lost to be refunded')?'selected':'' ?> >WH - Order Related Issues-Forward-Shipment Lost to be refunded</option>
												<option value='Delivery-POD Required-Customer Disputes on POD Shared' <?php echo($ajio['tagging_evaluator']=='Delivery-POD Required-Customer Disputes on POD Shared')?'selected':'' ?> >Delivery-POD Required-Customer Disputes on POD Shared</option>
												<option value='Delivery-Where is my Order?-Informed Order is RTOed' <?php echo($ajio['tagging_evaluator']=='Delivery-Where is my Order?-Informed Order is RTOed')?'selected':'' ?> >Delivery-Where is my Order?-Informed Order is RTOed</option>
												<option value='Delivery-Where is my Order?-Informed Promised Delivery Date' <?php echo($ajio['tagging_evaluator']=='Delivery-Where is my Order?-Informed Promised Delivery Date')?'selected':'' ?> >Delivery-Where is my Order?-Informed Promised Delivery Date</option>
												<option value='Delivery-Order not marked as Delivered-N/A' <?php echo($ajio['tagging_evaluator']=='Delivery-Order not marked as Delivered-N/A')?'selected':'' ?> >Delivery-Order not marked as Delivered-N/A</option>
												<option value='Coupon-How do I use my Jio Prime Points?-Educated customer on Jio Prime points' <?php echo($ajio['tagging_evaluator']=='Coupon-How do I use my Jio Prime Points?-Educated customer on Jio Prime points')?'selected':'' ?> >Coupon-How do I use my Jio Prime Points?-Educated customer on Jio Prime points</option>
												<option value='Return/Exchange-Is my pin code serviceable for Exchange/Return?-Informed about non availability of exchange at store' <?php echo($ajio['tagging_evaluator']=='Return/Exchange-Is my pin code serviceable for Exchange/Return?-Informed about non availability of exchange at store')?'selected':'' ?> >Return/Exchange-Is my pin code serviceable for Exchange/Return?-Informed about non availability of exchange at store</option>
												<option value='Return/Exchange-Is my pin code serviceable for Exchange/Return?-Informed serviceability of drop at store for product/store' <?php echo($ajio['tagging_evaluator']=='Return/Exchange-Is my pin code serviceable for Exchange/Return?-Informed serviceability of drop at store for product/store')?'selected':'' ?> >Return/Exchange-Is my pin code serviceable for Exchange/Return?-Informed serviceability of drop at store for product/store</option>
												<option value='Return/Exchange-How do I return/exchange this item?-Informed how drop at store option works' <?php echo($ajio['tagging_evaluator']=='Return/Exchange-How do I return/exchange this item?-Informed how drop at store option works')?'selected':'' ?> >Return/Exchange-How do I return/exchange this item?-Informed how drop at store option works</option>
												<option value='Refund-How do I get my money back?-Informed customer about Drop at Store refund – Prepaid Order' <?php echo($ajio['tagging_evaluator']=='Refund-How do I get my money back?-Informed customer about Drop at Store refund – Prepaid Order')?'selected':'' ?> >Refund-How do I get my money back?-Informed customer about Drop at Store refund – Prepaid Order</option>
												<option value='Refund-How do I get my money back?-Informed Cx about SC refund for Drop at Store' <?php echo($ajio['tagging_evaluator']=='Refund-How do I get my money back?-Informed Cx about SC refund for Drop at Store')?'selected':'' ?> >Refund-How do I get my money back?-Informed Cx about SC refund for Drop at Store</option>
												<option value='Refund-How do I get my money back?-Informed Cx about cash refund for drop at store' <?php echo($ajio['tagging_evaluator']=='Refund-How do I get my money back?-Informed Cx about cash refund for drop at store')?'selected':'' ?> >Refund-How do I get my money back?-Informed Cx about cash refund for drop at store</option>
												<option value='Refund-Where is my Refund?-Informed about drop at store refund TAT' <?php echo($ajio['tagging_evaluator']=='Refund-Where is my Refund?-Informed about drop at store refund TAT')?'selected':'' ?> >Refund-Where is my Refund?-Informed about drop at store refund TAT</option>
												<option value='WH - Order Related Issues-Customer Return-Wrong Product Received – EAN Matched' <?php echo($ajio['tagging_evaluator']=='WH - Order Related Issues-Customer Return-Wrong Product Received – EAN Matched')?'selected':'' ?> >WH - Order Related Issues-Customer Return-Wrong Product Received – EAN Matched</option>
												<option value='WH - Order Related Issues-Customer Return-Used Product Received' <?php echo($ajio['tagging_evaluator']=='WH - Order Related Issues-Customer Return-Used Product Received')?'selected':'' ?> >WH - Order Related Issues-Customer Return-Used Product Received</option>
												<option value='Goodwill Request-CM insisting Compensation-Coupon Reactivation' <?php echo($ajio['tagging_evaluator']=='Goodwill Request-CM insisting Compensation-Coupon Reactivation')?'selected':'' ?> >Goodwill Request-CM insisting Compensation-Coupon Reactivation</option>
												<option value='Return-Non Returnable Product-Wrong Product delivered' <?php echo($ajio['tagging_evaluator']=='Return-Non Returnable Product-Wrong Product delivered')?'selected':'' ?> >Return-Non Returnable Product-Wrong Product delivered</option>
												<option value='Return-Customer Delight-N/A' <?php echo($ajio['tagging_evaluator']=='Return-Customer Delight-N/A')?'selected':'' ?> >Return-Customer Delight-N/A</option>
												<option value='Delivery-Customer Delight-N/A' <?php echo($ajio['tagging_evaluator']=='Delivery-Customer Delight-N/A')?'selected':'' ?> >Delivery-Customer Delight-N/A</option>
												<option value='Return-Non Returnable Product-Tags Detached but available' <?php echo($ajio['tagging_evaluator']=='Return-Non Returnable Product-Tags Detached but available')?'selected':'' ?> >Return-Non Returnable Product-Tags Detached but available</option>
												<option value='Return-Non Returnable Product-Tags Not Available - Not Received' <?php echo($ajio['tagging_evaluator']=='Return-Non Returnable Product-Tags Not Available - Not Received')?'selected':'' ?> >Return-Non Returnable Product-Tags Not Available - Not Received</option>
												<option value='Return-Non Returnable Product-Tags Not Available - Misplaced by customer' <?php echo($ajio['tagging_evaluator']=='Return-Non Returnable Product-Tags Not Available - Misplaced by customer')?'selected':'' ?> >Return-Non Returnable Product-Tags Not Available - Misplaced by customer</option>
												<option value='Return-Non Returnable Product-Used Product Delivered' <?php echo($ajio['tagging_evaluator']=='Return-Non Returnable Product-Used Product Delivered')?'selected':'' ?> >Return-Non Returnable Product-Used Product Delivered</option>
												<option value='Return-Non Returnable Product-Classified as non-returnable' <?php echo($ajio['tagging_evaluator']=='Return-Non Returnable Product-Classified as non-returnable')?'selected':'' ?> >Return-Non Returnable Product-Classified as non-returnable</option>
												<option value='Return-Non Returnable Product-Return - Post Return Window' <?php echo($ajio['tagging_evaluator']=='Return-Non Returnable Product-Return - Post Return Window')?'selected':'' ?> >Return-Non Returnable Product-Return - Post Return Window</option>
												<option value='Return/Exchange-How do I return/exchange this item?-Requested customer to share the images' <?php echo($ajio['tagging_evaluator']=='Return/Exchange-How do I return/exchange this item?-Requested customer to share the images')?'selected':'' ?> >Return/Exchange-How do I return/exchange this item?-Requested customer to share the images</option>
												<option value='WH - Order Related Issues-Customer Return-Customer confirmation Required (Non-AJIO Product Received)' <?php echo($ajio['tagging_evaluator']=='WH - Order Related Issues-Customer Return-Customer confirmation Required (Non-AJIO Product Received)')?'selected':'' ?> >WH - Order Related Issues-Customer Return-Customer confirmation Required (Non-AJIO Product Received)</option>
												<option value='WH - Order Related Issues-Customer Return-Other node shipment received' <?php echo($ajio['tagging_evaluator']=='WH - Order Related Issues-Customer Return-Other node shipment received')?'selected':'' ?> >WH - Order Related Issues-Customer Return-Other node shipment received</option>
												<option value='Account-Store Credit Discrepancy-AJIO Cash' <?php echo($ajio['tagging_evaluator']=='Account-Store Credit Discrepancy-AJIO Cash')?'selected':'' ?> >Account-Store Credit Discrepancy-AJIO Cash</option>
												<option value='Account-Store Credit Discrepancy-Bonus Points' <?php echo($ajio['tagging_evaluator']=='Account-Store Credit Discrepancy-Bonus Points')?'selected':'' ?> >Account-Store Credit Discrepancy-Bonus Points</option>
												<option value='NAR Calls/Emails-NAR Emails-Replied & Asked for More Information' <?php echo($ajio['tagging_evaluator']=='NAR Calls/Emails-NAR Emails-Replied & Asked for More Information')?'selected':'' ?> >NAR Calls/Emails-NAR Emails-Replied & Asked for More Information</option>
												<option value='Delivery-Where is my Order?-Guided customer to track the order online' <?php echo($ajio['tagging_evaluator']=='Delivery-Where is my Order?-Guided customer to track the order online')?'selected':'' ?> >Delivery-Where is my Order?-Guided customer to track the order online</option>
												<option value='Order-I had a problem while placing an order-ADONP – within 48 hrs' <?php echo($ajio['tagging_evaluator']=='Order-I had a problem while placing an order-ADONP – within 48 hrs')?'selected':'' ?> >Order-I had a problem while placing an order-ADONP – within 48 hrs</option>
												<option value='Website-Complaint relating to Website-Return ID in Approved Status' <?php echo($ajio['tagging_evaluator']=='Website-Complaint relating to Website-Return ID in Approved Status')?'selected':'' ?> >Website-Complaint relating to Website-Return ID in Approved Status</option>
												<option value='Order-What are the payment modes?-Informed Cx COD Not Available' <?php echo($ajio['tagging_evaluator']=='Order-What are the payment modes?-Informed Cx COD Not Available')?'selected':'' ?> >Order-What are the payment modes?-Informed Cx COD Not Available</option>
												<option value='Website-Complaint relating to Website-AWB Not Assigned' <?php echo($ajio['tagging_evaluator']=='Website-Complaint relating to Website-AWB Not Assigned')?'selected':'' ?> >Website-Complaint relating to Website-AWB Not Assigned</option>
												<option value='NAR Calls/Emails-NAR Calls-Already Actioned' <?php echo($ajio['tagging_evaluator']=='NAR Calls/Emails-NAR Calls-Already Actioned')?'selected':'' ?> >NAR Calls/Emails-NAR Calls-Already Actioned</option>
												<option value='NAR Calls/Emails-NAR Emails-Already Actioned' <?php echo($ajio['tagging_evaluator']=='NAR Calls/Emails-NAR Emails-Already Actioned')?'selected':'' ?> >NAR Calls/Emails-NAR Emails-Already Actioned</option>
												<option value='OB-QC fail while returning-Callback Requested' <?php echo($ajio['tagging_evaluator']=='OB-QC fail while returning-Callback Requested')?'selected':'' ?> >OB-QC fail while returning-Callback Requested</option>
												<option value='OB-QC fail while returning-Others' <?php echo($ajio['tagging_evaluator']=='OB-QC fail while returning-Others')?'selected':'' ?> >OB-QC fail while returning-Others</option>
												<option value='OB-QC fail while returning-Asked to share images' <?php echo($ajio['tagging_evaluator']=='OB-QC fail while returning-Asked to share images')?'selected':'' ?> >OB-QC fail while returning-Asked to share images</option>
												<option value='OB-QC fail while returning-Raised pick without QC' <?php echo($ajio['tagging_evaluator']=='OB-QC fail while returning-Raised pick without QC')?'selected':'' ?> >OB-QC fail while returning-Raised pick without QC</option>
												<option value='OB-QC fail while returning-Declined Returns' <?php echo($ajio['tagging_evaluator']=='OB-QC fail while returning-Declined Returns')?'selected':'' ?> >OB-QC fail while returning-Declined Returns</option>
												<option value='OB-QC fail while returning-Raised Fake Attempt Complaint' <?php echo($ajio['tagging_evaluator']=='OB-QC fail while returning-Raised Fake Attempt Complaint')?'selected':'' ?> >OB-QC fail while returning-Raised Fake Attempt Complaint</option>
												<option value='Pre Order - RJ-What are my delivery / payment options-Informed customer of payment / delivery options' <?php echo($ajio['tagging_evaluator']=='Pre Order - RJ-What are my delivery / payment options-Informed customer of payment / delivery options')?'selected':'' ?> >Pre Order - RJ-What are my delivery / payment options-Informed customer of payment / delivery options</option>
												<option value='Pre Order - RJ-I need Authenticity information-Provided Information' <?php echo($ajio['tagging_evaluator']=='Pre Order - RJ-I need Authenticity information-Provided Information')?'selected':'' ?> >Pre Order - RJ-I need Authenticity information-Provided Information</option>
												<option value='Pre Order - RJ-Explain the features of the product-Explained about product features / Pricing' <?php echo($ajio['tagging_evaluator']=='Pre Order - RJ-Explain the features of the product-Explained about product features / Pricing')?'selected':'' ?> >Pre Order - RJ-Explain the features of the product-Explained about product features / Pricing</option>
												<option value='Account-Query / Dispute about LR-Guided customer to LR team' <?php echo($ajio['tagging_evaluator']=='Account-Query / Dispute about LR-Guided customer to LR team')?'selected':'' ?> >Account-Query / Dispute about LR-Guided customer to LR team</option>
												<option value='Account-How do I use my Loyalty Rewards-Explained how to use LR' <?php echo($ajio['tagging_evaluator']=='Account-How do I use my Loyalty Rewards-Explained how to use LR')?'selected':'' ?> >Account-How do I use my Loyalty Rewards-Explained how to use LR</option>
												<option value='Delivery-Order not dispatched from Warehouse-Shipment in Packed Status' <?php echo($ajio['tagging_evaluator']=='Delivery-Order not dispatched from Warehouse-Shipment in Packed Status')?'selected':'' ?> >Delivery-Order not dispatched from Warehouse-Shipment in Packed Status</option>
												<option value='Return-Reached Warehouse - Refund not Initiated-Excess product handed over' <?php echo($ajio['tagging_evaluator']=='Return-Reached Warehouse - Refund not Initiated-Excess product handed over')?'selected':'' ?> >Return-Reached Warehouse - Refund not Initiated-Excess product handed over</option>
												<option value='Delivery-POD Required-Req cx to check with neighbour / security' <?php echo($ajio['tagging_evaluator']=='Delivery-POD Required-Req cx to check with neighbour / security')?'selected':'' ?> >Delivery-POD Required-Req cx to check with neighbour / security</option>
												<option value='Return-Wrong item with no tag-Return form' <?php echo($ajio['tagging_evaluator']=='Return-Wrong item with no tag-Return form')?'selected':'' ?> >Return-Wrong item with no tag-Return form</option>
												<option value='Return-Wrong Item-Return form' <?php echo($ajio['tagging_evaluator']=='Return-Wrong Item-Return form')?'selected':'' ?> >Return-Wrong Item-Return form</option>
												<option value='OB-Misc-Not Connected - Email Sent' <?php echo($ajio['tagging_evaluator']=='OB-Misc-Not Connected - Email Sent')?'selected':'' ?> >OB-Misc-Not Connected - Email Sent</option>
												<option value='Reliance Jewels-I want certification of authenticity-Certificate to be sent' <?php echo($ajio['tagging_evaluator']=='Reliance Jewels-I want certification of authenticity-Certificate to be sent')?'selected':'' ?> >Reliance Jewels-I want certification of authenticity-Certificate to be sent</option>
												<option value='Reliance Jewels-Information on weight/purity-Requested customer to visit nearest RJ store' <?php echo($ajio['tagging_evaluator']=='Reliance Jewels-Information on weight/purity-Requested customer to visit nearest RJ store')?'selected':'' ?> >Reliance Jewels-Information on weight/purity-Requested customer to visit nearest RJ store</option>
												<option value='Return-Package ID related-cancellation due to items exceeding the package dimension' <?php echo($ajio['tagging_evaluator']=='Return-Package ID related-cancellation due to items exceeding the package dimension')?'selected':'' ?> >Return-Package ID related-cancellation due to items exceeding the package dimension</option>
												<option value='Return-Package ID related-duplicate Package ID to be sent' <?php echo($ajio['tagging_evaluator']=='Return-Package ID related-duplicate Package ID to be sent')?'selected':'' ?> >Return-Package ID related-duplicate Package ID to be sent</option>
												<option value='Pre Order - AJIO LUX-Explain the features of the product-Explained about product features' <?php echo($ajio['tagging_evaluator']=='Pre Order - AJIO LUX-Explain the features of the product-Explained about product features')?'selected':'' ?> >Pre Order - AJIO LUX-Explain the features of the product-Explained about product features</option>
												<option value='Pre Order - AJIO LUX-I need warranty information-Provided Information' <?php echo($ajio['tagging_evaluator']=='Pre Order - AJIO LUX-I need warranty information-Provided Information')?'selected':'' ?> >Pre Order - AJIO LUX-I need warranty information-Provided Information</option>
												<option value='Pre Order - AJIO LUX-Where can i find this product?-Informed customer that the product is not in stock' <?php echo($ajio['tagging_evaluator']=='Pre Order - AJIO LUX-Where can i find this product?-Informed customer that the product is not in stock')?'selected':'' ?> >Pre Order - AJIO LUX-Where can i find this product?-Informed customer that the product is not in stock</option>
												<option value='Pre Order - AJIO LUX-Where can i find this product?-Helped customer to find the product' <?php echo($ajio['tagging_evaluator']=='Pre Order - AJIO LUX-Where can i find this product?-Helped customer to find the product')?'selected':'' ?> >Pre Order - AJIO LUX-Where can i find this product?-Helped customer to find the product</option>
												<option value='Delivery-Marked the order as delivered-N/A' <?php echo($ajio['tagging_evaluator']=='Delivery-Marked the order as delivered-N/A')?'selected':'' ?> >Delivery-Marked the order as delivered-N/A</option>
												<option value='Refund-Where is my Refund?-Educated customer about GST refund' <?php echo($ajio['tagging_evaluator']=='Refund-Where is my Refund?-Educated customer about GST refund')?'selected':'' ?> >Refund-Where is my Refund?-Educated customer about GST refund</option>
												<option value='Return/Exchange-How do I return/exchange this item?-Email sent to confirm policy - Missing Product/Component' <?php echo($ajio['tagging_evaluator']=='Return/Exchange-How do I return/exchange this item?-Email sent to confirm policy - Missing Product/Component')?'selected':'' ?> >Return/Exchange-How do I return/exchange this item?-Email sent to confirm policy - Missing Product/Component</option>
												<option value='NAR Calls/Emails-NAR Emails-Non AJIO Query' <?php echo($ajio['tagging_evaluator']=='NAR Calls/Emails-NAR Emails-Non AJIO Query')?'selected':'' ?> >NAR Calls/Emails-NAR Emails-Non AJIO Query</option>
												<option value='Coupon-Unable to apply coupon-Requested to share coupon details/images' <?php echo($ajio['tagging_evaluator']=='Coupon-Unable to apply coupon-Requested to share coupon details/images')?'selected':'' ?> >Coupon-Unable to apply coupon-Requested to share coupon details/images</option>
												<option value='Account-Store Credit Debited Order Not Processed-R-1 Points' <?php echo($ajio['tagging_evaluator']=='Account-Store Credit Debited Order Not Processed-R-1 Points')?'selected':'' ?> >Account-Store Credit Debited Order Not Processed-R-1 Points</option>
												<option value='Account-I have not received my referral bonus-Informed about referral credit' <?php echo($ajio['tagging_evaluator']=='Account-I have not received my referral bonus-Informed about referral credit')?'selected':'' ?> >Account-I have not received my referral bonus-Informed about referral credit</option>
												<option value='Account-Ajio Referral Discrepancy-Referral points/code not received' <?php echo($ajio['tagging_evaluator']=='Account-Ajio Referral Discrepancy-Referral points/code not received')?'selected':'' ?> >Account-Ajio Referral Discrepancy-Referral points/code not received</option>
												<option value='Website-Complaint relating to Website-Order Delivered - Consignment not visible' <?php echo($ajio['tagging_evaluator']=='Website-Complaint relating to Website-Order Delivered - Consignment not visible')?'selected':'' ?> >Website-Complaint relating to Website-Order Delivered - Consignment not visible</option>
												<option value='Return-Reached Warehouse - Refund not Initiated-Partial Refund Initiated' <?php echo($ajio['tagging_evaluator']=='Return-Reached Warehouse - Refund not Initiated-Partial Refund Initiated')?'selected':'' ?> >Return-Reached Warehouse - Refund not Initiated-Partial Refund Initiated</option>
												<option value='Website-Complaint relating to Website-Change in login info' <?php echo($ajio['tagging_evaluator']=='Website-Complaint relating to Website-Change in login info')?'selected':'' ?> >Website-Complaint relating to Website-Change in login info</option>
												<option value='Account-Fraudulent Activity reported-Educated customer as per policy' <?php echo($ajio['tagging_evaluator']=='Account-Fraudulent Activity reported-Educated customer as per policy')?'selected':'' ?> >Account-Fraudulent Activity reported-Educated customer as per policy</option>
												<option value='Return-Cancelation Request (Chatbot only)-Return to be cancelled (Chatbot only)' <?php echo($ajio['tagging_evaluator']=='Return-Cancelation Request (Chatbot only)-Return to be cancelled (Chatbot only)')?'selected':'' ?> >Return-Cancelation Request (Chatbot only)-Return to be cancelled (Chatbot only)</option>
												<option value='Account-R- One related-R - One refund not credited' <?php echo($ajio['tagging_evaluator']=='Account-R- One related-R - One refund not credited')?'selected':'' ?> >Account-R- One related-R - One refund not credited</option>
												<option value='Account-How do I use my R - One points-Explained how to use R - One points' <?php echo($ajio['tagging_evaluator']=='Account-How do I use my R - One points-Explained how to use R - One points')?'selected':'' ?> >Account-How do I use my R - One points-Explained how to use R - One points</option>
												<option value='Account-I have not received my R - One points-Informed about R - One points' <?php echo($ajio['tagging_evaluator']=='Account-I have not received my R - One points-Informed about R - One points')?'selected':'' ?> >Account-I have not received my R - One points-Informed about R - One points</option>
												<option value='Website-Complaint related to website-R - One points not visible' <?php echo($ajio['tagging_evaluator']=='Website-Complaint related to website-R - One points not visible')?'selected':'' ?> >Website-Complaint related to website-R - One points not visible</option>
												<option value='Account-R- One related-R - One points not credited' <?php echo($ajio['tagging_evaluator']=='Account-R- One related-R - One points not credited')?'selected':'' ?> >Account-R- One related-R - One points not credited</option>
												<option value='Delivery-Cancelation Request (Chatbot only)-Exchange to be cancelled (Chatbot only)' <?php echo($ajio['tagging_evaluator']=='Delivery-Cancelation Request (Chatbot only)-Exchange to be cancelled (Chatbot only)')?'selected':'' ?> >Delivery-Cancelation Request (Chatbot only)-Exchange to be cancelled (Chatbot only)</option>
												<option value='Delivery-Marked the order as delivered-Requested customer to wait for 2 business days' <?php echo($ajio['tagging_evaluator']=='Delivery-Marked the order as delivered-Requested customer to wait for 2 business days')?'selected':'' ?> >Delivery-Marked the order as delivered-Requested customer to wait for 2 business days</option>
												<option value='Return-Non Returnable Product-Damaged Product Received - Fragile' <?php echo($ajio['tagging_evaluator']=='Return-Non Returnable Product-Damaged Product Received - Fragile')?'selected':'' ?> >Return-Non Returnable Product-Damaged Product Received - Fragile</option>
												<option value='Return-Non Returnable Product-Damaged Product Received' <?php echo($ajio['tagging_evaluator']=='Return-Non Returnable Product-Damaged Product Received')?'selected':'' ?> >Return-Non Returnable Product-Damaged Product Received</option>
												<option value='Refund-Where is my Refund?-Imps Failed - Requested Customer to share NEFT details' <?php echo($ajio['tagging_evaluator']=='Refund-Where is my Refund?-Imps Failed - Requested Customer to share NEFT details')?'selected':'' ?> >Refund-Where is my Refund?-Imps Failed - Requested Customer to share NEFT details</option>
												<option value='NEFT(Refund Request)-NEFT Followup-Request for NEFT Transfer' <?php echo($ajio['tagging_evaluator']=='NEFT(Refund Request)-NEFT Followup-Request for NEFT Transfer')?'selected':'' ?> >NEFT(Refund Request)-NEFT Followup-Request for NEFT Transfer</option>
												<option value='Delivery-Empty Package Received-Outer Packaging NOT Tampered' <?php echo($ajio['tagging_evaluator']=='Delivery-Empty Package Received-Outer Packaging NOT Tampered')?'selected':'' ?> >Delivery-Empty Package Received-Outer Packaging NOT Tampered</option>
												<option value='Delivery-Incomplete Order received - Product(s) missing from shipment-Outer Packaging NOT Tampered' <?php echo($ajio['tagging_evaluator']=='Delivery-Incomplete Order received - Product(s) missing from shipment-Outer Packaging NOT Tampered')?'selected':'' ?> >Delivery-Incomplete Order received - Product(s) missing from shipment-Outer Packaging NOT Tampered</option>
												<option value='Delivery-Incomplete Order received - Unit(s) missing from a Set/Pack-Outer Packaging NOT Tampered' <?php echo($ajio['tagging_evaluator']=='Delivery-Incomplete Order received - Unit(s) missing from a Set/Pack-Outer Packaging NOT Tampered')?'selected':'' ?> >Delivery-Incomplete Order received - Unit(s) missing from a Set/Pack-Outer Packaging NOT Tampered</option>
												<option value='Return-Reached Warehouse - Refund not Initiated-Excess product handed over' <?php echo($ajio['tagging_evaluator']=='Return-Reached Warehouse - Refund not Initiated-Excess product handed over')?'selected':'' ?> >Return-Reached Warehouse - Refund not Initiated-Excess product handed over</option>
												<option value='Delivery-Empty Package Received-Outer Packaging NOT Tampered' <?php echo($ajio['tagging_evaluator']=='Delivery-Empty Package Received-Outer Packaging NOT Tampered')?'selected':'' ?> >Delivery-Empty Package Received-Outer Packaging NOT Tampered</option>
												<option value='Delivery-Empty Package Received-Outer Packaging Tampered' <?php echo($ajio['tagging_evaluator']=='Delivery-Empty Package Received-Outer Packaging Tampered')?'selected':'' ?> >Delivery-Empty Package Received-Outer Packaging Tampered</option>
												<option value='Delivery-Empty Package Received – RJ(Jewels)-Outer Packaging NOT Tampered' <?php echo($ajio['tagging_evaluator']=='Delivery-Empty Package Received – RJ(Jewels)-Outer Packaging NOT Tampered')?'selected':'' ?> >Delivery-Empty Package Received – RJ(Jewels)-Outer Packaging NOT Tampered</option>
												<option value='Delivery-Empty Package Received – RJ(Jewels)-Outer Packaging Tampered' <?php echo($ajio['tagging_evaluator']=='Delivery-Empty Package Received – RJ(Jewels)-Outer Packaging Tampered')?'selected':'' ?> >Delivery-Empty Package Received – RJ(Jewels)-Outer Packaging Tampered</option>
												<option value='Delivery-Incomplete Order received - Unit(s) missing from a Set/Pack-Outer Package Tampered' <?php echo($ajio['tagging_evaluator']=='Delivery-Incomplete Order received - Unit(s) missing from a Set/Pack-Outer Package Tampered')?'selected':'' ?> >Delivery-Incomplete Order received - Unit(s) missing from a Set/Pack-Outer Package Tampered</option>
												<option value='Delivery-Incomplete Order received - Product(s) missing from shipment-Outer Package Tampered' <?php echo($ajio['tagging_evaluator']=='Delivery-Incomplete Order received - Product(s) missing from shipment-Outer Package Tampered')?'selected':'' ?> >Delivery-Incomplete Order received - Product(s) missing from shipment-Outer Package Tampered</option>
												<option value='Delivery-Incomplete Order received - item(s) missing from an outfit/dress-Outer Package Tampered' <?php echo($ajio['tagging_evaluator']=='Delivery-Incomplete Order received - item(s) missing from an outfit/dress-Outer Package Tampered')?'selected':'' ?> >Delivery-Incomplete Order received - item(s) missing from an outfit/dress-Outer Package Tampered</option>
												<option value='Feedback-Suggestions about Convenience charge-NA' <?php echo($ajio['tagging_evaluator']=='Feedback-Suggestions about Convenience charge-NA')?'selected':'' ?> >Feedback-Suggestions about Convenience charge-NA</option>
												<option value='Price-Whats the price for this order?-Guided Customer on Delivery charge' <?php echo($ajio['tagging_evaluator']=='Price-Whats the price for this order?-Guided Customer on Delivery charge')?'selected':'' ?> >Price-Whats the price for this order?-Guided Customer on Delivery charge</option>
												<option value='Price-Whats the price for this order?-Guided Customer on COD charge' <?php echo($ajio['tagging_evaluator']=='Price-Whats the price for this order?-Guided Customer on COD charge')?'selected':'' ?> >Price-Whats the price for this order?-Guided Customer on COD charge</option>
												<option value='Price-Whats the price for this order?-Guided Customer on Fulfilment Convenience charge' <?php echo($ajio['tagging_evaluator']=='Price-Whats the price for this order?-Guided Customer on Fulfilment Convenience charge')?'selected':'' ?> >Price-Whats the price for this order?-Guided Customer on Fulfilment Convenience charge</option>
												<option value='Goodwill Request-CM insisting Compensation-Convenience Charge' <?php echo($ajio['tagging_evaluator']=='Goodwill Request-CM insisting Compensation-Convenience Charge')?'selected':'' ?> >Goodwill Request-CM insisting Compensation-Convenience Charge</option>
												<option value='Other-I want convenience charge-Convinced the customer - No Action Required' <?php echo($ajio['tagging_evaluator']=='Other-I want convenience charge-Convinced the customer - No Action Required')?'selected':'' ?> >Other-I want convenience charge-Convinced the customer - No Action Required</option>
												<option value='Ticket-Cx-Ticket Follow up - within TAT-Return related' <?php echo($ajio['tagging_evaluator']=='Ticket-Cx-Ticket Follow up - within TAT-Return related')?'selected':'' ?> >Ticket-Cx-Ticket Follow up - within TAT-Return related</option>
												<option value='Ticket-Cx-Ticket Follow up - within TAT-Pickup related' <?php echo($ajio['tagging_evaluator']=='Ticket-Cx-Ticket Follow up - within TAT-Pickup related')?'selected':'' ?> >Ticket-Cx-Ticket Follow up - within TAT-Pickup related</option>
												<option value='Ticket-Cx-Ticket Follow up - within TAT-Others' <?php echo($ajio['tagging_evaluator']=='Ticket-Cx-Ticket Follow up - within TAT-Others')?'selected':'' ?> >Ticket-Cx-Ticket Follow up - within TAT-Others</option>
												<option value='Ticket-Cx-Ticket Follow up - within TAT-Missing Product related' <?php echo($ajio['tagging_evaluator']=='Ticket-Cx-Ticket Follow up - within TAT-Missing Product related')?'selected':'' ?> >Ticket-Cx-Ticket Follow up - within TAT-Missing Product related</option>
												<option value='Ticket-Cx-Ticket Follow up - within TAT-Refund related' <?php echo($ajio['tagging_evaluator']=='Ticket-Cx-Ticket Follow up - within TAT-Refund related')?'selected':'' ?> >Ticket-Cx-Ticket Follow up - within TAT-Refund related</option>
												<option value='Ticket-Cx-Ticket Follow up - within TAT-Website related' <?php echo($ajio['tagging_evaluator']=='Ticket-Cx-Ticket Follow up - within TAT-Website related')?'selected':'' ?> >Ticket-Cx-Ticket Follow up - within TAT-Website related</option>
												<option value='Ticket-Cx-Ticket Follow up - TAT Breached-Others' <?php echo($ajio['tagging_evaluator']=='Ticket-Cx-Ticket Follow up - TAT Breached-Others')?'selected':'' ?> >Ticket-Cx-Ticket Follow up - TAT Breached-Others</option>
												<option value='Ticket-Cx-Ticket Follow up - TAT Breached-Return related' <?php echo($ajio['tagging_evaluator']=='Ticket-Cx-Ticket Follow up - TAT Breached-Return related')?'selected':'' ?> >Ticket-Cx-Ticket Follow up - TAT Breached-Return related</option>
												<option value='Ticket-Cx-Ticket Follow up - TAT Breached-Delivery related' <?php echo($ajio['tagging_evaluator']=='Ticket-Cx-Ticket Follow up - TAT Breached-Delivery related')?'selected':'' ?> >Ticket-Cx-Ticket Follow up - TAT Breached-Delivery related</option>
												<option value='Ticket-Cx-Ticket Follow up - TAT Breached-Refund related' <?php echo($ajio['tagging_evaluator']=='Ticket-Cx-Ticket Follow up - TAT Breached-Refund related')?'selected':'' ?> >Ticket-Cx-Ticket Follow up - TAT Breached-Refund related</option>
												<option value='Ticket-Cx-Ticket Follow up - TAT Breached-Missing Product related' <?php echo($ajio['tagging_evaluator']=='Ticket-Cx-Ticket Follow up - TAT Breached-Missing Product related')?'selected':'' ?> >Ticket-Cx-Ticket Follow up - TAT Breached-Missing Product related</option>
												<option value='Ticket-Cx-Ticket Follow up - TAT Breached-Website related' <?php echo($ajio['tagging_evaluator']=='Ticket-Cx-Ticket Follow up - TAT Breached-Website related')?'selected':'' ?> >Ticket-Cx-Ticket Follow up - TAT Breached-Website related</option>
												<option value='Ticket-Cx-Ticket Follow up - TAT Breached-Pickup related' <?php echo($ajio['tagging_evaluator']=='Ticket-Cx-Ticket Follow up - TAT Breached-Pickup related')?'selected':'' ?> >Ticket-Cx-Ticket Follow up - TAT Breached-Pickup related</option>
												<option value='Ticket-Cx-Ticket Follow up - within TAT-Delivery related' <?php echo($ajio['tagging_evaluator']=='Ticket-Cx-Ticket Follow up - within TAT-Delivery related')?'selected':'' ?> >Ticket-Cx-Ticket Follow up - within TAT-Delivery related</option>
												<option value='Callback-Regional Callback-CallBack Needed - Telugu' <?php echo($ajio['tagging_evaluator']=='Callback-Regional Callback-CallBack Needed - Telugu')?'selected':'' ?> >Callback-Regional Callback-CallBack Needed - Telugu</option>
												<option value='Callback-Regional Callback-CallBack Needed - Tamil' <?php echo($ajio['tagging_evaluator']=='Callback-Regional Callback-CallBack Needed - Tamil')?'selected':'' ?> >Callback-Regional Callback-CallBack Needed - Tamil</option>
												<option value='Callback-Regional Callback-CallBack Needed - Kannada' <?php echo($ajio['tagging_evaluator']=='Callback-Regional Callback-CallBack Needed - Kannada')?'selected':'' ?> >Callback-Regional Callback-CallBack Needed - Kannada</option>
												<option value='Account-Suspended Account (Reason for Suspension Required)-Customer wanted Wallet amount transferred' <?php echo($ajio['tagging_evaluator']=='Account-Suspended Account (Reason for Suspension Required)-Customer wanted Wallet amount transferred')?'selected':'' ?> >Account-Suspended Account (Reason for Suspension Required)-Customer wanted Wallet amount transferred</option>
												<option value='Account-Suspended Account (Reason for Suspension Required)-Customer wanted to return product' <?php echo($ajio['tagging_evaluator']=='Account-Suspended Account (Reason for Suspension Required)-Customer wanted to return product')?'selected':'' ?> >Account-Suspended Account (Reason for Suspension Required)-Customer wanted to return product</option>
												<option value='Account-Suspended Account (Reason for Suspension Required)-Customer wanted to know suspension reason' <?php echo($ajio['tagging_evaluator']=='Account-Suspended Account (Reason for Suspension Required)-Customer wanted to know suspension reason')?'selected':'' ?> >Account-Suspended Account (Reason for Suspension Required)-Customer wanted to know suspension reason</option>
												<option value='Callback-Regional Callback-CallBack Needed - Malyalam' <?php echo($ajio['tagging_evaluator']=='Callback-Regional Callback-CallBack Needed - Malyalam')?'selected':'' ?> >Callback-Regional Callback-CallBack Needed - Malyalam</option>
												<option value='Order-Excess COD Collected-Informed customer to share image/screenshot' <?php echo($ajio['tagging_evaluator']=='Order-Excess COD Collected-Informed customer to share image/screenshot')?'selected':'' ?> >Order-Excess COD Collected-Informed customer to share image/screenshot</option>
												<option value='Marketing-Gift not Received post winning contest-Top Shopper Gift' <?php echo($ajio['tagging_evaluator']=='Marketing-Gift not Received post winning contest-Top Shopper Gift')?'selected':'' ?> >Marketing-Gift not Received post winning contest-Top Shopper Gift</option>
												<option value='Marketing-Gift not Received post winning contest-High Value Assured Gift - Instant Reward' <?php echo($ajio['tagging_evaluator']=='Marketing-Gift not Received post winning contest-High Value Assured Gift - Instant Reward')?'selected':'' ?> >Marketing-Gift not Received post winning contest-High Value Assured Gift - Instant Reward</option>
												<option value='Marketing-Gift not Received post winning contest-High Value Assured Gift - Reward post return window' <?php echo($ajio['tagging_evaluator']=='Marketing-Gift not Received post winning contest-High Value Assured Gift - Reward post return window')?'selected':'' ?> >Marketing-Gift not Received post winning contest-High Value Assured Gift - Reward post return window</option>
												<option value='Delivery-Incomplete Order received - item(s) missing from an outfit/dress-Outer Packaging NOT Tampered' <?php echo($ajio['tagging_evaluator']=='Delivery-Incomplete Order received - item(s) missing from an outfit/dress-Outer Packaging NOT Tampered')?'selected':'' ?> >Delivery-Incomplete Order received - item(s) missing from an outfit/dress-Outer Packaging NOT Tampered</option>
												<option value='Return/Exchange-Return On Hold-Informed about Release/Verification TAT' <?php echo($ajio['tagging_evaluator']=='Return/Exchange-Return On Hold-Informed about Release/Verification TAT')?'selected':'' ?> >Return/Exchange-Return On Hold-Informed about Release/Verification TAT</option>
												<option value='Return-Pickup status not updated-RID status In progress' <?php echo($ajio['tagging_evaluator']=='Return-Pickup status not updated-RID status In progress')?'selected':'' ?> >Return-Pickup status not updated-RID status In progress</option>
												<option value='Return-Pickup status not updated-RID Status Return Pickup Attempted' <?php echo($ajio['tagging_evaluator']=='Return-Pickup status not updated-RID Status Return Pickup Attempted')?'selected':'' ?> >Return-Pickup status not updated-RID Status Return Pickup Attempted</option>
												<option value='Return-Pickup status not updated-RID status Out for Pickup' <?php echo($ajio['tagging_evaluator']=='Return-Pickup status not updated-RID status Out for Pickup')?'selected':'' ?> >Return-Pickup status not updated-RID status Out for Pickup</option>
												<option value='Return-Pickup status not updated-RID status Return on Hold' <?php echo($ajio['tagging_evaluator']=='Return-Pickup status not updated-RID status Return on Hold')?'selected':'' ?> >Return-Pickup status not updated-RID status Return on Hold</option>
												<option value='Return-Pickup status not updated-RID status Cancelled' <?php echo($ajio['tagging_evaluator']=='Return-Pickup status not updated-RID status Cancelled')?'selected':'' ?> >Return-Pickup status not updated-RID status Cancelled</option>
												<option value='WH - Order Related Issues-Return to be cancelled-Self ship return' <?php echo($ajio['tagging_evaluator']=='WH - Order Related Issues-Return to be cancelled-Self ship return')?'selected':'' ?> >WH - Order Related Issues-Return to be cancelled-Self ship return</option>
												<option value='Return/Exchange -Customer claiming product picked up-Within 24 Hours' <?php echo($ajio['tagging_evaluator']=='Return/Exchange -Customer claiming product picked up-Within 24 Hours')?'selected':'' ?> >Return/Exchange -Customer claiming product picked up-Within 24 Hours</option>
												</select>
										</td>
									</tr>
									<tr>
										<td style="font-weight:bold; font-size:16px; text-align:right">Earned Score:</td>
										<td><input type="text" readonly id="earnedScore" name="data[earned_score]" class="form-control" style="font-weight:bold" value="<?php echo $ajio['earned_score'] ?>"></td>
										<td style="font-weight:bold; font-size:16px; text-align:right">Possible Score:</td>
										<td><input type="text" readonly id="possibleScore" name="data[possible_score]" class="form-control" style="font-weight:bold" value="<?php echo $ajio['possible_score'] ?>"></td>
										<td style="font-weight:bold; font-size:16px; text-align:right">Overall Score:</td>
										<td><input type="text" readonly id="overallScore" name="data[overall_score]" class="form-control ajio_social_Fatal" style="font-weight:bold" value="<?php echo $ajio['overall_score'] ?>"></td>
									</tr>
									<tr style="font-weight:bold">
										<td><input type="hidden" class="form-control" id="prefatal" name="data[pre_fatal_score]" value="<?php echo $ajio['pre_fatal_score'] ?>"></td>
										<td><input type="hidden" class="form-control" id="fatalcount" name="data[fatal_count]" value="<?php echo $ajio['fatal_count'] ?>"></td>
									</tr>
									<tr style="background-color:#85C1E9; font-weight:bold">
										<td>Parameter</td>
										<td>Sub Parameter</td>
										<td>Weightage</td>
										<td>Defect</td>
										<td>L1</td>
										<td>L2 Defect</td>
									</tr>
									<tr>
										<td rowspan=3 style="background-color:#85C1E9; font-weight:bold">Call/Email Quality & Ettiquettes</td>
										<td>Did the champ follow the OB call script and introduce himself properly.</td>
										<td>10</td>
										<td>
											<select class="form-control ajio" id="follow_OB_call" name="data[follow_OB_call]" disabled>
												<option ajio_val=10 ajio_max=10 <?php echo $ajio['follow_OB_call'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ajio_val=0 ajio_max=10 <?php echo $ajio['follow_OB_call'] == "No"?"selected":"";?> value="No">No</option>
											</select>
										</td>
										
										<td>
											<select class="form-control" id="follow_OB_call_l1" name="data[l1_reason1]" disabled>
												<?php 
												if($ajio['l1_reason1']!=''){
													?>
													<option value="<?php echo $ajio['l1_reason1'] ?>"><?php echo $ajio['l1_reason1'] ?></option>
													<?php
												}
												?>
												<option  <?php echo $ajio['l1_reason1'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
												
											</select>
										</td>
										<td><textarea class="form-control" disabled name="data[cmt1]"><?php echo $ajio['cmt1'] ?></textarea></td>
									</tr>
									<tr>
										<td style="color:red">Champ followed the 3 strike rule of customer contact</td>
										<td>10</td>
										<td>
											<select class="form-control ajio fatal ajioAF1" id="ajioAF1_ccsr" name="data[three_strike_rule]" disabled>
												<option ajio_val=10 ajio_max=10 <?php echo $ajio['three_strike_rule'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ajio_val=0 ajio_max=10 <?php echo $ajio['three_strike_rule'] == "Autofail"?"selected":"";?> value="Autofail">Autofail</option>
											</select>
										</td>
										
										<td>
											<select class="form-control" id="three_strike_rule_l2" name="data[l1_reason2]" disabled>
												<?php 
												if($ajio['l1_reason2']!=''){
													?>
													<option value="<?php echo $ajio['l1_reason2'] ?>"><?php echo $ajio['l1_reason2'] ?></option>
													<?php
												}
												?>
												<option  <?php echo $ajio['l1_reason2'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
												
											</select>
										</td>
										<td><textarea class="form-control" disabled name="data[cmt2]"><?php echo $ajio['cmt2'] ?></textarea></td>
									</tr>
									<tr>
										<td>Did the champ offer further assistance and follow appropriate <br> call closure / Call back request fulfilled as per the guideline.</td>
										<td>5</td>
										<td>
											<select class="form-control ajio" id="further_assistance" name="data[further_assistance]" disabled>
												<option ajio_val=5 ajio_max=5 <?php echo $ajio['further_assistance'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ajio_val=0 ajio_max=5 <?php echo $ajio['further_assistance'] == "No"?"selected":"";?> value="No">No</option>
											</select>
										</td>
										
										<td>
											<select class="form-control" id="further_assistance_l3" name="data[l1_reason3]" disabled>
												<?php 
												if($ajio['l1_reason3']!=''){
													?>
													<option value="<?php echo $ajio['l1_reason3'] ?>"><?php echo $ajio['l1_reason3'] ?></option>
													<?php
												}
												?>
												<option  <?php echo $ajio['l1_reason3'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
												
											</select>
										</td>
										<td><textarea class="form-control" disabled name="data[cmt3]"><?php echo $ajio['cmt3'] ?></textarea></td>
									</tr>

									<tr>
										<td rowspan=4 style="background-color:#85C1E9; font-weight:bold">Communication/Writing Skills</td>
										<td>Was the champ polite and used apology and assurance <br> wherever required</td>
										<td>10</td>
										<td>
											<select class="form-control ajio" id="polite" name="data[polite]" disabled>
												<option ajio_val=10 ajio_max=10 <?php echo $ajio['polite'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ajio_val=0 ajio_max=10 <?php echo $ajio['polite'] == "No"?"selected":"";?> value="No">No</option>
											</select>
										</td>
										
										<td>
											<select class="form-control" id="polite_l4" name="data[l1_reason4]" disabled>
												<?php 
												if($ajio['l1_reason4']!=''){
													?>
													<option value="<?php echo $ajio['l1_reason4'] ?>"><?php echo $ajio['l1_reason4'] ?></option>
													<?php
												}
												?>
												<option  <?php echo $ajio['l1_reason4'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
												
											</select>
										</td>
										<td><textarea class="form-control" disabled name="data[cmt4]"><?php echo $ajio['cmt4'] ?></textarea></td>
									</tr>
									<tr>
										<td style="color:red">Was the champ able to comprehend and articulate the<br> resolution to the customer in a manner which was<br> easily understood by the customer by following AJIO standard<br>
										- Email 
										a. champ used appropriate template(s) and customized <br>it to ensure all concerns raised were answered appropriately (Auto fail)<br>
										b. AJIO's approved template, format, font, font size adhered (Mark down) <br>
										c.Did the champ maintain accuracy of written communication ensuring <br>no grammatical errors, SVAs, Punctuation and sentence construction errors(Mark Down)</td>
										<td>10</td>
										<td>
											<select class="form-control ajio fatal ajioAF7" id="comprehend_articulate" name="data[comprehend_articulate]" disabled>
												<option ajio_val=10 ajio_max=10 <?php echo $ajio['comprehend_articulate'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ajio_val=0 ajio_max=10 <?php echo $ajio['comprehend_articulate'] == "No"?"selected":"";?> value="No">No</option>
												<option ajio_val=0 ajio_max=10 <?php echo $ajio['comprehend_articulate'] == "Autofail"?"selected":"";?> value="Autofail">Autofail</option>
											</select>
										</td>
										
										<td>
											<select class="form-control" id="comprehend_articulate_l5" name="data[l1_reason5]" disabled>
												<?php 
												if($ajio['l1_reason5']!=''){
													?>
													<option value="<?php echo $ajio['l1_reason5'] ?>"><?php echo $ajio['l1_reason5'] ?></option>
													<?php
												}
												?>
												<option  <?php echo $ajio['l1_reason5'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
												
											</select>
										</td>
										<td><textarea class="form-control" disabled name="data[cmt5]"><?php echo $ajio['cmt5'] ?></textarea></td>
									</tr>
									<tr>
										<td>Did the champ display active listening skills without making<br> the customer repeat.</td>
										<td>5</td>
										<td>
											<select class="form-control ajio" id="active_listening" name="data[active_listening]" disabled>
												<option ajio_val=5 ajio_max=5 <?php echo $ajio['active_listening'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ajio_val=0 ajio_max=5 <?php echo $ajio['active_listening'] == "No"?"selected":"";?> value="No">No</option>
											</select>
										</td>
										
										<td>
											<select class="form-control" id="active_listening_l6" name="data[l1_reason6]" disabled>
												<?php 
												if($ajio['l1_reason6']!=''){
													?>
													<option value="<?php echo $ajio['l1_reason6'] ?>"><?php echo $ajio['l1_reason6'] ?></option>
													<?php
												}
												?>
												<option  <?php echo $ajio['l1_reason6'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
												
											</select>
										</td>
										<td><textarea class="form-control" disabled name="data[cmt6]"><?php echo $ajio['cmt6'] ?></textarea></td>
									</tr>
									<tr>
										<td>Was the champ able to handle objections effectively and <br>offer rebuttals wherever required. (Especially in case of where<br> the resolution is not in customer's favour).</td>
										<td>10</td>
										<td>
											<select class="form-control ajio" id="handle_objections" name="data[handle_objections]" disabled>
												<option ajio_val=10 ajio_max=10 <?php echo $ajio['handle_objections'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ajio_val=0 ajio_max=10 <?php echo $ajio['handle_objections'] == "No"?"selected":"";?> value="No">No</option>
											</select>
										</td>
										
										<td>
											<select class="form-control" id="handle_objections_l7" name="data[l1_reason7]" disabled>
												<?php 
												if($ajio['l1_reason7']!=''){
													?>
													<option value="<?php echo $ajio['l1_reason7'] ?>"><?php echo $ajio['l1_reason7'] ?></option>
													<?php
												}
												?>
												<option  <?php echo $ajio['l1_reason7'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
												
											</select>
										</td>
										<td><textarea class="form-control" disabled name="data[cmt7]"><?php echo $ajio['cmt7'] ?></textarea></td>
									</tr>
									<tr>
										<td rowspan=3 style="background-color:#85C1E9; font-weight:bold">Effective System Navigation & KM Usage</td>
										<td>Did the champ refer to different applications/portals/tools<br>/SOP/KM to identify the root cause of customer <br>issue and enable resolution.</td>
										<td>5</td>
										<td>
											<select class="form-control ajio" id="enable_resolution" name="data[enable_resolution]" disabled>
												<option ajio_val=5 ajio_max=5 <?php echo $ajio['enable_resolution'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ajio_val=0 ajio_max=5 <?php echo $ajio['enable_resolution'] == "No"?"selected":"";?> value="No">No</option>
											</select>
										</td>
										
										<td>
											<select class="form-control" id="enable_resolution_l8" name="data[l1_reason8]" disabled>
												<?php 
												if($ajio['l1_reason8']!=''){
													?>
													<option value="<?php echo $ajio['l1_reason8'] ?>"><?php echo $ajio['l1_reason8'] ?></option>
													<?php
												}
												?>
												<option  <?php echo $ajio['l1_reason8'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
												
											</select>
										</td>
										<td><textarea class="form-control" disabled name="data[cmt8]"><?php echo $ajio['cmt8'] ?></textarea></td>
									</tr>
									<tr>
										<td style="color:red">Did the champ check the previous complaint history. <br>(repeat complaint, resolution provided on previous complaint. <br>Reason of reopen) and took action accordingly.</td>
										<td>10</td>
										<td>
											<select class="form-control ajio fatal ajioAF2" id="ajioAF2_ccsr" name="data[complaint_history]" disabled>
												<option ajio_val=10 ajio_max=10 <?php echo $ajio['complaint_history'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ajio_val=0 ajio_max=10 <?php echo $ajio['complaint_history'] == "Autofail"?"selected":"";?> value="Autofail">Autofail</option>
											</select>
										</td>
										
										<td>
											<select class="form-control" id="complaint_history_l9" name="data[l1_reason9]" disabled>
												<?php 
												if($ajio['l1_reason9']!=''){
													?>
													<option value="<?php echo $ajio['l1_reason9'] ?>"><?php echo $ajio['l1_reason9'] ?></option>
													<?php
												}
												?>
												<option  <?php echo $ajio['l1_reason9'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
												
											</select>
										</td>
										<td><textarea class="form-control" disabled name="data[cmt9]"><?php echo $ajio['cmt9'] ?></textarea></td>
									</tr>
									<tr>
										<td style="color:red">Did the champ correctly redirect/reassign/reopen the complaint<br> wherever required. Includes when the resolution provided by stakeholder is<br> not valid</td>
										<td>5</td>
										<td>
											<select class="form-control ajio fatal ajioAF2" id="ajioAF3_ccsr" name="data[reopen_complaint]" disabled>
												<option ajio_val=5 ajio_max=5 <?php echo $ajio['reopen_complaint'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ajio_val=0 ajio_max=5 <?php echo $ajio['reopen_complaint'] == "Autofail"?"selected":"";?> value="Autofail">Autofail</option>
											</select>
										</td>
										
										<td>
											<select class="form-control" id="reopen_complaint_l10" name="data[l1_reason10]" disabled>
												<?php 
												if($ajio['l1_reason10']!=''){
													?>
													<option value="<?php echo $ajio['l1_reason10'] ?>"><?php echo $ajio['l1_reason10'] ?></option>
													<?php
												}
												?>
												<option  <?php echo $ajio['l1_reason10'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
												
											</select>
										</td>
										<td><textarea class="form-control" disabled name="data[cmt10]"><?php echo $ajio['cmt10'] ?></textarea></td>
									</tr>
									<tr>
										<td rowspan=3 style="background-color:#85C1E9; font-weight:bold">Issue Resolution</td>
										<td>Any other underlying issue on the account was also<br> addressed proactively.</td>
										<td>10</td>
										<td>
											<select class="form-control ajio" id="addressed_proactively" name="data[addressed_proactively]" disabled>
												<option ajio_val=10 ajio_max=10 <?php echo $ajio['addressed_proactively'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ajio_val=0 ajio_max=10 <?php echo $ajio['addressed_proactively'] == "No"?"selected":"";?> value="No">No</option>
											</select>
										</td>
										
										<td>
											<select class="form-control" id="addressed_proactively_l11" name="data[l1_reason11]" disabled>
												<?php 
												if($ajio['l1_reason11']!=''){
													?>
													<option value="<?php echo $ajio['l1_reason11'] ?>"><?php echo $ajio['l1_reason11'] ?></option>
													<?php
												}
												?>
												<option  <?php echo $ajio['l1_reason11'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
												
											</select>
										</td>
										<td><textarea class="form-control" disabled name="data[cmt11]"><?php echo $ajio['cmt11'] ?></textarea></td>
									</tr>
									<tr>
										<td style="color:red">All the queries were answered properly and in an <br>informative way to avoid repeat call. Champ provided a <br>clear understanding of action taken and the way forward<br> to the customer. (Any Information needed from Cx, <br>Follow up action required by customer. Taking confirmation <br>of the understanding of resolution)</td>
										<td>5</td>
										<td>
											<select class="form-control ajio fatal ajioAF4" id="ajioAF4_ccsr" name="data[answered_properly]" disabled>
												<option ajio_val=5 ajio_max=5 <?php echo $ajio['answered_properly'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ajio_val=0 ajio_max=5 <?php echo $ajio['answered_properly'] == "Autofail"?"selected":"";?> value="Autofail">Autofail</option>
											</select>
										</td>
										
										<td>
											<select class="form-control" id="answered_properly_l12" name="data[l1_reason12]" disabled>
												<?php 
												if($ajio['l1_reason12']!=''){
													?>
													<option value="<?php echo $ajio['l1_reason12'] ?>"><?php echo $ajio['l1_reason12'] ?></option>
													<?php
												}
												?>
												<option  <?php echo $ajio['l1_reason12'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
												
											</select>
										</td>
										<td><textarea class="form-control" disabled name="data[cmt12]"><?php echo $ajio['cmt12'] ?></textarea></td>
									</tr>
									<tr>
										<td style="color:red">Did the champ document the case correctly and adhered <br>to tagging guidelines. Includes closing the complaint appropriately by <br>selecting the correct ICR reason</td>
										<td>5</td>
										<td>
											<select class="form-control ajio fatal ajioAF5" id="ajioAF5_ccsr" name="data[tagging_guidelines]" disabled>
												<option ajio_val=5 ajio_max=5 <?php echo $ajio['tagging_guidelines'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ajio_val=0 ajio_max=5 <?php echo $ajio['tagging_guidelines'] == "No"?"selected":"";?> value="No">No</option>
												<option ajio_val=0 ajio_max=5 <?php echo $ajio['tagging_guidelines'] == "Autofail"?"selected":"";?> value="Autofail">Autofail</option>
											</select>
										</td>
										
										<td>
											<select class="form-control" id="tagging_guidelines_l13" name="data[l1_reason13]" disabled>
												<?php 
												if($ajio['l1_reason13']!=''){
													?>
													<option value="<?php echo $ajio['l1_reason13'] ?>"><?php echo $ajio['l1_reason13'] ?></option>
													<?php
												}
												?>
												<option  <?php echo $ajio['l1_reason13'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
												
											</select>
										</td>
										<td><textarea class="form-control" disabled name="data[cmt13]"><?php echo $ajio['cmt13'] ?></textarea></td>
									</tr>
									<tr>
										<td rowspan=1 style="background-color:#85C1E9; font-weight:bold">ZTP</td>
										<td style="color:red">As per AJIO ZTP guidelines</td>
										<td></td>
										<td>
											<select class="form-control ajio fatal ajioAF6" id="ajioAF6_ccsr" name="data[ztp_guidelines]" disabled>
												<option ajio_val=0 ajio_max=0 <?php echo $ajio['ztp_guidelines'] == "No"?"selected":"";?> value="No">No</option>
												<option ajio_val=0 ajio_max=0 <?php echo $ajio['ztp_guidelines'] == "Autofail"?"selected":"";?> value="Autofail">Autofail</option>
											</select>
										</td>
										
										<td>
											<select class="form-control" id="ztp_guidelines_l14" name="data[l1_reason14]" disabled>
												<?php 
												if($ajio['l1_reason14']!=''){
													?>
													<option value="<?php echo $ajio['l1_reason14'] ?>"><?php echo $ajio['l1_reason14'] ?></option>
													<?php
												}
												?>
												<option  <?php echo $ajio['l1_reason14'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
												
											</select>
										</td>
										<td><textarea class="form-control" disabled name="data[cmt14]"><?php echo $ajio['cmt14'] ?></textarea></td>
									</tr>
									
									<tr>
										<td>Call Summary:</td>
										<td colspan=2><textarea class="form-control" disabled name="data[call_summary]"><?php echo $ajio['call_summary'] ?></textarea></td>
										<td>Feedback:</td>
										<td colspan=2><textarea class="form-control" disabled name="data[feedback]"><?php echo $ajio['feedback'] ?></textarea></td>
									</tr>
									<?php if($ajio['attach_file']!=''){ ?>
									<tr oncontextmenu="return false;">
										<td colspan="2">Audio Files (Mp4/Mp3/M4a/Wav)</td>
										<td colspan="4">
											<?php $attach_file = explode(",",$ajio['attach_file']);
											 foreach($attach_file as $af){ ?>
												<audio oncontextmenu="return false;" controls controlslist="nodownload" style="background-color:#607F93">
													  <source src="<?php echo base_url(); ?>qa_files/ajio_ccsr_voice_email/<?php echo $af; ?>" type="audio/ogg">
													  <source src="<?php echo base_url(); ?>qa_files/ajio_ccsr_voice_email/<?php echo $af; ?>" type="audio/mpeg">
												</audio> </br>
											 <?php } ?>
										</td>
									</tr>
									<?php } ?>
									<?php } ?>	
									
									<tr><td colspan="8" style="background-color:#C5C8C8"></td></tr>
									
									<tr><td style="font-size:16px">Manager Review:</td> <td colspan="8" style="text-align:left"><?php echo $ajio['mgnt_rvw_note'] ?></td></tr>
									<tr><td style="font-size:16px">Client Review:</td> <td colspan="7" style="text-align:left"><?php echo $ajio['client_rvw_note'] ?></td></tr>
									
									<tr><td colspan="7" style="background-color:#C5C8C8"></td></tr>
									
									<form id="form_agent_user" method="POST" action="">
									 <input type="hidden" name="pnid" class="form-control" value="<?php echo $pnid; ?>">
										
										<tr>
											<td colspan=2 style="font-size:16px">Feedback Acceptance <span style="font-size:24px;color:red">*</span></td>
											<td colspan=5>
												<select class="form-control" id="" name="agnt_fd_acpt" required>
													<option value="">--Select--</option>
													<option <?php echo $ajio['agnt_fd_acpt']=='Acceptance'?"selected":""; ?> value="Acceptance">Acceptance</option>	
													<option <?php echo $ajio['agnt_fd_acpt']=='Not Acceptance'?"selected":""; ?> value="Not Acceptance">Not Acceptance</option>	
												</select>
											</td>
										</tr>
										<tr>
											<td colspan=2 style="font-size:16px">Your Review <span style="font-size:24px;color:red">*</span></td>
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
