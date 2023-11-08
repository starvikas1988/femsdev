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
.ui-datepicker .ui-datepicker-buttonpane button.ui-datepicker-current {
	 float: left;
	 display: none;
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
										<td colspan="7" id="theader" style="font-size:30px">Revive Rx Inbound</td>
										<?php
											$rand_id = 0;
											if($revive_rx_inbound_data['entry_by']!=''){
												$auditorName = $revive_rx_inbound_data['auditor_name'];
											}else{
												$auditorName = $revive_rx_inbound_data['client_name'];
											}
											$auditDate = mysql2mmddyy($revive_rx_inbound_data['audit_date']);
											$clDate_val = mysql2mmddyy($revive_rx_inbound_data['call_date']);
										

										if ($rand_id != 0) {
											$agent_id = $rand_data['sid'];
											$fusion_id = $rand_data['fusion_id'];
											$agent_name = $rand_data['fname'] . " " . $rand_data['lname'];
											$tl_id = $rand_data['assigned_to'];
											$tl_name = $rand_data['tl_name'];
											$call_duration = $rand_data['call_duration'];
											
										} else {
											$agent_id = $revive_rx_inbound_data['agent_id'];
											$fusion_id = $revive_rx_inbound_data['fusion_id'];
											$agent_name = $revive_rx_inbound_data['fname'] . " " . $revive_rx_inbound_data['lname'] ;
											$tl_id = $revive_rx_inbound_data['tl_id'];
											$tl_name = $revive_rx_inbound_data['tl_name'];
											$call_duration = $revive_rx_inbound_data['call_duration'];
										}
									?>
										<input type="hidden" name="audit_start_time" value="<?php echo CurrMySqlDate(); ?>">
									</tr>
									<tr>
										<td colspan="2">QA Name:</td>
										<td style="width: 250px"><input type="text" class="form-control" value="<?php echo get_username(); ?>" disabled></td>
										<td>Audit Date:</td>
										<td><input type="text" class="form-control" value="<?php echo CurrDateMDY(); ?>" disabled></td>
										<td>Call Date:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control" id="call_date" name="call_date" value="<?php echo $clDate_val; ?>" disabled></td>
									</tr>

									<tr>
										<td colspan="2">Agent:<span style="font-size:24px;color:red">*</span></td>
										<td>
											<select class="form-control agentName" id="agent_id" name="data[agent_id]" disabled>
												<option value="">-Select-</option>
												<?php foreach($agentName as $row){
												$sCss='';
												if($row['id']==$agent_id) $sCss='selected';
											?>
												<option value="<?php echo $row['id']; ?>" <?php echo $sCss; ?>><?php echo $row['name']; ?></option>
											<?php } ?>
											</select>
										</td>
										<td>Fusion ID:</td>
										<td><input type="text" readonly class="form-control" id="fusion_id" name="" value="<?php echo $fusion_id; ?>"></td>
										<td>L1 Supervisor:</td>
										<td>
											<input type="text" class="form-control" id="tl_names"  value="<?php echo $tl_name; ?>" readonly>
												<input type="hidden" class="form-control" id="tl_id" name="data[tl_id]" value="<?php echo $tl_id; ?>" disabled>
										</td>
									</tr>
									<tr>
										<td colspan="2">Call Id:<span style="font-size:24px;color:red">*</span></td>
										<td>
										<input type="text" class="form-control" id="call_id" name="data[call_id]" value="<?php echo $revive_rx_inbound_data['call_id'] ?>" disabled>
										</td>
										<td>Call Duration:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control" id="call_duration" name="data[call_duration]" value="<?php echo $call_duration; ?>" disabled></td>
										<td>Contact Number:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control" name="data[contact_no]" value="<?php echo $revive_rx_inbound_data['contact_no'] ?>" onkeyup="checkDec(this);" disabled><span id="start_phone" style="color:red"></span></td>
									</tr>
									
									<tr>
										<td colspan="2">VOC:<span style="font-size:24px;color:red">*</span></td>
										<td>
											<select class="form-control" id="voc" name="data[voc]" disabled>
												<option value="">-Select-</option>
												<option value="1"  <?= ($revive_rx_inbound_data['voc']=="1")?"selected":"" ?>>1</option>
													<option value="2"  <?= ($revive_rx_inbound_data['voc']=="2")?"selected":"" ?>>2</option>
													<option value="3"  <?= ($revive_rx_inbound_data['voc']=="3")?"selected":"" ?>>3</option>
													<option value="4"  <?= ($revive_rx_inbound_data['voc']=="4")?"selected":"" ?>>4</option>
													<option value="5"  <?= ($revive_rx_inbound_data['voc']=="5")?"selected":"" ?>>5</option>
											</select>
										</td>
										<td>Call Type:<span style="font-size:24px;color:red">*</span></td>
										<td>
											<select class="form-control" id="" name="data[call_type]" disabled>
												<option value="">-Select-</option>
												<option value="IB"  <?= ($revive_rx_inbound_data['call_type']=="IB")?"selected":"" ?>>IB</option>
													<option value="OB"  <?= ($revive_rx_inbound_data['call_type']=="OB")?"selected":"" ?>>OB</option>
											</select>
										</td>
										
										<td>Audit Type:<span style="font-size:24px;color:red">*</span></td>
										<td>
											<select class="form-control" id="audit_type" name="data[audit_type]" disabled>
												<option value="">-Select-</option>
												  <option value="CQ Audit" <?= ($revive_rx_inbound_data['audit_type']=="CQ Audit")?"selected":"" ?>>CQ Audit</option>
                                                    <option value="BQ Audit" <?= ($revive_rx_inbound_data['audit_type']=="BQ Audit")?"selected":"" ?>>BQ Audit</option>
                                                    <option value="Calibration" <?= ($revive_rx_inbound_data['audit_type']=="Calibration")?"selected":"" ?>>Calibration</option>
                                                    <option value="Pre-Certificate Mock Call" <?= ($revive_rx_inbound_data['audit_type']=="Pre-Certificate Mock Call")?"selected":"" ?>>Pre-Certificate Mock Call</option>
                                                    <option value="Certification Audit" <?= ($revive_rx_inbound_data['audit_type']=="Certification Audit")?"selected":"" ?>>Certification Audit</option>
                                                    <option value="WoW Call"  <?= ($revive_rx_inbound_data['audit_type']=="WoW Call")?"selected":"" ?>>WoW Call</option>
                                                    <option value="Hygiene Audit"  <?= ($revive_rx_inbound_data['audit_type']=="Hygiene Audit")?"selected":"" ?>>Hygiene Audit</option>
                                                    <option value="Operation Audit"  <?= ($revive_rx_inbound_data['audit_type']=="Operation Audit")?"selected":"" ?>>Operation Audit</option>
                                                    <option value="Trainer Audit"  <?= ($revive_rx_inbound_data['audit_type']=="Trainer Audit")?"selected":"" ?>>Trainer Audit</option> 
                                                    <option value="QA Supervisor Audit"  <?= ($revive_rx_inbound_data['audit_type']=="QA Supervisor Audit")?"selected":"" ?>>QA Supervisor Audit</option> 
											</select>
										</td>
									</tr>
									<tr>
										<td class="auType">Auditor Type:<span style="font-size:24px;color:red">*</span></td>
										<td class="auType">
											<select class="form-control" id="auditor_type" name="data[auditor_type]">
												<option value="">-Select-</option>
												 <option value="Master" <?= ($revive_rx_inbound_data['auditor_type']=="Master")?"selected":"" ?>>Master</option>
                                                    <option value="Regular" <?= ($revive_rx_inbound_data['auditor_type']=="Regular")?"selected":"" ?>>Regular</option>
											</select>
										</td>
										
									</tr>
									<tr>
										<td colspan="2" style="font-weight:bold; font-size:16px">Possible Score:</td>
										<td>
											<input type="text" readonly id="revive_rx_inbound_possible_score" name="data[possible_score]" class="form-control" value="<?php echo $revive_rx_inbound_data['possible_score'] ?>" />

										</td>
										<td style="font-weight:bold; font-size:16px">Earned Score:</td>
										<td><input type="text" readonly id="revive_rx_inbound_earned_score" name="data[earned_score]" class="form-control" style="font-weight:bold" value="<?php echo $revive_rx_inbound_data['earned_score'] ?>"></td>
										<td style="font-weight:bold; font-size:16px; text-align:right">Overall Score:</td>
										<td><input type="text" readonly id="revive_rx_inbound_overall_score" name="data[overall_score]" class="form-control inboundFatal" style="font-weight:bold" value="<?php echo $revive_rx_inbound_data['overall_score'] ?>"></td>
									</tr>
			
									
									<tr style="background-color:#A9CCE3; font-weight:bold"><td colspan="4">Parameter</td><td>Weightage</td><td>Rating</td><td colspan=3>Remark</td></tr>
									<td colspan="8" style="background-color: #A9CCE3;">Soft skills</td>
									<tr>
										
										<td colspan=4>Used proper opening providing pharmacy's name and asking for patient's name</td>
										<td>5</td>
										<td>
											<select class="form-control revive_rx_inbound_point" id="" name="data[proper_opening]" disabled>
												
												<option revive_rx_inbound_val=5 revive_rx_inbound_max=5 <?php echo $revive_rx_inbound_data['proper_opening']=='Pass'?"selected":""; ?> value="Pass">Pass</option>
												<option revive_rx_inbound_val=0 revive_rx_inbound_max=5 <?php echo $revive_rx_inbound_data['proper_opening']=='Fail'?"selected":""; ?> value="Fail">Fail</option>
												<option revive_rx_inbound_val=5 revive_rx_inbound_max=5 <?php echo $revive_rx_inbound_data['proper_opening']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt1]" disabled value="<?php echo $revive_rx_inbound_data['cmt1'] ?>"></td>
									</tr>
									<tr>
										
										<td colspan=4>Did we use polite vocabulary (Thank you and apologies)</td>
										<td>2</td>
										<td>
											<select class="form-control revive_rx_inbound_point" id="" name="data[polite_vocabulary]" disabled>
												
												<option revive_rx_inbound_val=2 revive_rx_inbound_max=2 <?php echo $revive_rx_inbound_data['polite_vocabulary']=='Pass'?"selected":""; ?> value="Pass">Pass</option>
												<option revive_rx_inbound_val=0 revive_rx_inbound_max=2 <?php echo $revive_rx_inbound_data['polite_vocabulary']=='Fail'?"selected":""; ?> value="Fail">Fail</option>
												<option revive_rx_inbound_val=2 revive_rx_inbound_max=2 <?php echo $revive_rx_inbound_data['polite_vocabulary']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt2]" disabled value="<?php echo $revive_rx_inbound_data['cmt2'] ?>"></td>
									</tr>
									<tr>
										
										<td colspan=4>Did not overtalk the customer</td>
										<td>3</td>
										<td>
											<select class="form-control revive_rx_inbound_point" id="" name="data[overtalk_customer]" disabled>
												
												<option revive_rx_inbound_val=3 revive_rx_inbound_max="3" <?php echo $revive_rx_inbound_data['overtalk_customer']=='Pass'?"selected":""; ?> value="Pass">Pass</option>
												<option revive_rx_inbound_val=0 revive_rx_inbound_max=3 <?php echo $revive_rx_inbound_data['overtalk_customer']=='Fail'?"selected":""; ?> value="Fail">Fail</option>
												<option revive_rx_inbound_val=3 revive_rx_inbound_max=3 <?php echo $revive_rx_inbound_data['overtalk_customer']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt3]" disabled value="<?php echo $revive_rx_inbound_data['cmt3'] ?>"></td>
									</tr>
									<tr>
										
										<td colspan=4>The agent adjust and speaks with a strong steady speed or pace</td>
										<td>2</td>
										<td>
											<select class="form-control revive_rx_inbound_point" id="" name="data[speaks_strong]" disabled>
												
												<option revive_rx_inbound_val=2 revive_rx_inbound_max=2 <?php echo $revive_rx_inbound_data['speaks_strong']=='Pass'?"selected":""; ?> value="Pass">Pass</option>
												<option revive_rx_inbound_val=0 revive_rx_inbound_max=2 <?php echo $revive_rx_inbound_data['speaks_strong']=='Fail'?"selected":""; ?> value="Fail">Fail</option>
												<option revive_rx_inbound_val=2 revive_rx_inbound_max=2 <?php echo $revive_rx_inbound_data['speaks_strong']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt4]" disabled value="<?php echo $revive_rx_inbound_data['cmt4'] ?>"></td>
									</tr>
									<tr>
										
										<td colspan=4>Tone was warm and genuine throughout the call</td>
										<td>3</td>
										<td>
											<select class="form-control revive_rx_inbound_point" id="" name="data[tone_warm]" disabled>
												
												<option revive_rx_inbound_val=3 revive_rx_inbound_max=3 <?php echo $revive_rx_inbound_data['tone_warm']=='Pass'?"selected":""; ?> value="Pass">Pass</option>
												<option revive_rx_inbound_val=0 revive_rx_inbound_max=3 <?php echo $revive_rx_inbound_data['tone_warm']=='Fail'?"selected":""; ?> value="Fail">Fail</option>
												<option revive_rx_inbound_val=3 revive_rx_inbound_max=3 <?php echo $revive_rx_inbound_data['tone_warm']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt5]" disabled value="<?php echo $revive_rx_inbound_data['cmt5'] ?>"></td>
									</tr>
									<tr>
										
										<td colspan=4>Took ownership and sounded confident and creditable throughout the call</td>
										<td>4</td>
										<td>
											<select class="form-control revive_rx_inbound_point" id="" name="data[took_ownership]" disabled>
												
												<option revive_rx_inbound_val=4 revive_rx_inbound_max=4 <?php echo $revive_rx_inbound_data['took_ownership']=='Pass'?"selected":""; ?> value="Pass">Pass</option>
												<option revive_rx_inbound_val=0 revive_rx_inbound_max=4 <?php echo $revive_rx_inbound_data['took_ownership']=='Fail'?"selected":""; ?> value="Fail">Fail</option>
												<option revive_rx_inbound_val=4 revive_rx_inbound_max=4 <?php echo $revive_rx_inbound_data['took_ownership']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt6]" disabled value="<?php echo $revive_rx_inbound_data['cmt6'] ?>"></td>
									</tr>
									<tr>
										
										<td colspan=4>Did we avoid dead air</td>
										<td>2</td>
										<td>
											<select class="form-control revive_rx_inbound_point" id="" name="data[dead_air]" disabled>
												
												<option revive_rx_inbound_val=2 revive_rx_inbound_max=2 <?php echo $revive_rx_inbound_data['dead_air']=='Pass'?"selected":""; ?> value="Pass">Pass</option>
												<option revive_rx_inbound_val=0 revive_rx_inbound_max=2 <?php echo $revive_rx_inbound_data['dead_air']=='Fail'?"selected":""; ?> value="Fail">Fail</option>
												<option revive_rx_inbound_val=2 revive_rx_inbound_max=2 <?php echo $revive_rx_inbound_data['dead_air']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt7]" disabled value="<?php echo $revive_rx_inbound_data['cmt7'] ?>"></td>
									</tr>
									<tr>
										<td colspan="8" style="background-color: #A9CCE3;">Compliance</td>
									</tr>
									<tr>
										
										<td colspan=4>Verified Patient's current contact information</td>
										<td>3</td>
										<td>
											<select class="form-control revive_rx_inbound_point" id="" name="data[contact_information]" disabled>
												
												<option revive_rx_inbound_val=3 revive_rx_inbound_max=3 <?php echo $revive_rx_inbound_data['contact_information']=='Pass'?"selected":""; ?> value="Pass">Pass</option>
												<option revive_rx_inbound_val=0 revive_rx_inbound_max=3 <?php echo $revive_rx_inbound_data['contact_information']=='Fail'?"selected":""; ?> value="Fail">Fail</option>
												<option revive_rx_inbound_val=3 revive_rx_inbound_max=3 <?php echo $revive_rx_inbound_data['contact_information']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt8]" disabled value="<?php echo $revive_rx_inbound_data['cmt8'] ?>"></td>
									</tr>
									<tr>
										
										<td colspan=4>Verified and gather patient information</td>
										<td>7</td>
										<td>
											<select class="form-control revive_rx_inbound_point" id="" name="data[patient_information]" disabled>
												
												<option revive_rx_inbound_val=7 revive_rx_inbound_max=7 <?php echo $revive_rx_inbound_data['patient_information']=='Pass'?"selected":""; ?> value="Pass">Pass</option>
												<option revive_rx_inbound_val=0 revive_rx_inbound_max=7 <?php echo $revive_rx_inbound_data['patient_information']=='Fail'?"selected":""; ?> value="Fail">Fail</option>
												<option revive_rx_inbound_val=7 revive_rx_inbound_max=7 <?php echo $revive_rx_inbound_data['patient_information']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt9]" disabled value="<?php echo $revive_rx_inbound_data['cmt9'] ?>"></td>
									</tr>
									<tr>
										
										<td colspan=4>Provided accurate and complete information</td>
										<td>5</td>
										<td>
											<select class="form-control revive_rx_inbound_point" id="" name="data[complete_information]" disabled>
												
												<option revive_rx_inbound_val=5 revive_rx_inbound_max=5 <?php echo $revive_rx_inbound_data['complete_information']=='Pass'?"selected":""; ?> value="Pass">Pass</option>
												<option revive_rx_inbound_val=0 revive_rx_inbound_max=5 <?php echo $revive_rx_inbound_data['complete_information']=='Fail'?"selected":""; ?> value="Fail">Fail</option>
												<option revive_rx_inbound_val=5 revive_rx_inbound_max=5 <?php echo $revive_rx_inbound_data['complete_information']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt10]" disabled value="<?php echo $revive_rx_inbound_data['cmt10'] ?>"></td>
									</tr>
									<tr>
										
										<td colspan=4>Agent asked for clarifying and probing questions</td>
										<td>2</td>
										<td>
											<select class="form-control revive_rx_inbound_point" id="" name="data[probing_questions]" disabled>
												
												<option revive_rx_inbound_val=2 revive_rx_inbound_max=2 <?php echo $revive_rx_inbound_data['probing_questions']=='Pass'?"selected":""; ?> value="Pass">Pass</option>
												<option revive_rx_inbound_val=0 revive_rx_inbound_max=2 <?php echo $revive_rx_inbound_data['probing_questions']=='Fail'?"selected":""; ?> value="Fail">Fail</option>
												<option revive_rx_inbound_val=2 revive_rx_inbound_max=2 <?php echo $revive_rx_inbound_data['probing_questions']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt11]" disabled value="<?php echo $revive_rx_inbound_data['cmt11'] ?>"></td>
									</tr>
									<tr>
										
										<td colspan=4>Followed proper hold and transfer procedures</td>
										<td>5</td>
										<td>
											<select class="form-control revive_rx_inbound_point" id="" name="data[hold_transfer]" disabled>
												
												<option revive_rx_inbound_val=5 revive_rx_inbound_max=5 <?php echo $revive_rx_inbound_data['hold_transfer']=='Pass'?"selected":""; ?> value="Pass">Pass</option>
												<option revive_rx_inbound_val=0 revive_rx_inbound_max=5 <?php echo $revive_rx_inbound_data['hold_transfer']=='Fail'?"selected":""; ?> value="Fail">Fail</option>
												<option revive_rx_inbound_val=5 revive_rx_inbound_max=5 <?php echo $revive_rx_inbound_data['hold_transfer']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt12]" disabled value="<?php echo $revive_rx_inbound_data['cmt12'] ?>"></td>
									</tr>
									<tr>
										
										<td colspan=4>Left appropiate notes in the account</td>
										<td>4</td>
										<td>
											<select class="form-control revive_rx_inbound_point" id="" name="data[appropiate_notes]" disabled>
												
												<option revive_rx_inbound_val=4 revive_rx_inbound_max=4 <?php echo $revive_rx_inbound_data['appropiate_notes']=='Pass'?"selected":""; ?> value="Pass">Pass</option>
												<option revive_rx_inbound_val=0 revive_rx_inbound_max=4 <?php echo $revive_rx_inbound_data['appropiate_notes']=='Fail'?"selected":""; ?> value="Fail">Fail</option>
												<option revive_rx_inbound_val=4 revive_rx_inbound_max=4 <?php echo $revive_rx_inbound_data['appropiate_notes']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt13]" disabled value="<?php echo $revive_rx_inbound_data['cmt13'] ?>"></td>
									</tr>
									<tr>
										
										<td colspan=4>Update the system acordingly (TEXT messages, assessment, allergies, future tasks, pay simple payment)</td>
										<td>7</td>
										<td>
											<select class="form-control revive_rx_inbound_point" id="" name="data[update_system]" disabled>
												
												<option revive_rx_inbound_val=7 revive_rx_inbound_max=7 <?php echo $revive_rx_inbound_data['update_system']=='Pass'?"selected":""; ?> value="Pass">Pass</option>
												<option revive_rx_inbound_val=0 revive_rx_inbound_max=7 <?php echo $revive_rx_inbound_data['update_system']=='Fail'?"selected":""; ?> value="Fail">Fail</option>
												<option revive_rx_inbound_val=7 revive_rx_inbound_max=7 <?php echo $revive_rx_inbound_data['update_system']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt14]" disabled value="<?php echo $revive_rx_inbound_data['cmt14'] ?>"></td>
									</tr>
									<tr>
										
										<td colspan=4>Confirmed the total amount, asked for authorization to process the payment and fill.</td>
										<td>5</td>
										<td>
											<select class="form-control revive_rx_inbound_point" id="" name="data[confirm_total_amount]" disabled>
												
												<option revive_rx_inbound_val=5 revive_rx_inbound_max=5 <?php echo $revive_rx_inbound_data['confirm_total_amount']=='Pass'?"selected":""; ?> value="Pass">Pass</option>
												<option revive_rx_inbound_val=0 revive_rx_inbound_max=5 <?php echo $revive_rx_inbound_data['confirm_total_amount']=='Fail'?"selected":""; ?> value="Fail">Fail</option>
												<option revive_rx_inbound_val=5 revive_rx_inbound_max=5 <?php echo $revive_rx_inbound_data['confirm_total_amount']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt15]" disabled value="<?php echo $revive_rx_inbound_data['cmt15'] ?>"></td>
									</tr>
									<tr>
										
										<td colspan=4>Left voicemail and sent TEXT message (unable to contact patient).</td>
										<td>7</td>
										<td>
											<select class="form-control revive_rx_inbound_point" id="" name="data[left_voicemail]" disabled>
												
												<option revive_rx_inbound_val=7 revive_rx_inbound_max=7 <?php echo $revive_rx_inbound_data['left_voicemail']=='Pass'?"selected":""; ?> value="Pass">Pass</option>
												<option revive_rx_inbound_val=0 revive_rx_inbound_max=7 <?php echo $revive_rx_inbound_data['left_voicemail']=='Fail'?"selected":""; ?> value="Fail">Fail</option>
												<option revive_rx_inbound_val=7 revive_rx_inbound_max=7 <?php echo $revive_rx_inbound_data['left_voicemail']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt16]" disabled value="<?php echo $revive_rx_inbound_data['cmt16'] ?>"></td>
									</tr>
									<tr>
										
										<td colspan=4>Did we ask If additional assitance was needed.</td>
										<td>2</td>
										<td>
											<select class="form-control revive_rx_inbound_point" id="" name="data[additional_assitance]" disabled>
												
												<option revive_rx_inbound_val=2 revive_rx_inbound_max=2 <?php echo $revive_rx_inbound_data['additional_assitance']=='Pass'?"selected":""; ?> value="Pass">Pass</option>
												<option revive_rx_inbound_val=0 revive_rx_inbound_max=2 <?php echo $revive_rx_inbound_data['additional_assitance']=='Fail'?"selected":""; ?> value="Fail">Fail</option>
												<option revive_rx_inbound_val=2 revive_rx_inbound_max=2 <?php echo $revive_rx_inbound_data['additional_assitance']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt17]" disabled value="<?php echo $revive_rx_inbound_data['cmt17'] ?>"></td>
									</tr>
									<tr>
										
										<td colspan=4>Closed the call positively.</td>
										<td>2</td>
										<td>
											<select class="form-control revive_rx_inbound_point" id="" name="data[close_call]" disabled>
												
												<option revive_rx_inbound_val=2 revive_rx_inbound_max=2 <?php echo $revive_rx_inbound_data['close_call']=='Pass'?"selected":""; ?> value="Pass">Pass</option>
												<option revive_rx_inbound_val=0 revive_rx_inbound_max=2 <?php echo $revive_rx_inbound_data['close_call']=='Fail'?"selected":""; ?> value="Fail">Fail</option>
												<option revive_rx_inbound_val=2 revive_rx_inbound_max=2 <?php echo $revive_rx_inbound_data['close_call']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt18]" disabled value="<?php echo $revive_rx_inbound_data['cmt18'] ?>"></td>
									</tr>
									<tr>
										<td colspan="8" style="background-color: #A9CCE3;">Business Critical-Fatal</td>
									</tr>
									<tr>
										
										<td colspan=4 style="color: red;">Properly authenticates (Complete shipping address and DOB)</td>
										<td>15</td>
										<td>
											<select class="form-control revive_rx_inbound_point" id="inbound_fatal1" name="data[propertly_authenticates]" disabled>
												
												<option revive_rx_inbound_val=15 revive_rx_inbound_max="15" <?php echo $revive_rx_inbound_data['propertly_authenticates']=='Pass'?"selected":""; ?> value="Pass">Pass</option>
												<option revive_rx_inbound_val=0 revive_rx_inbound_max="15" <?php echo $revive_rx_inbound_data['propertly_authenticates']=='Fail'?"selected":""; ?> value="Fail">Fail</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt19]" disabled value="<?php echo $revive_rx_inbound_data['cmt19'] ?>"></td>
									</tr>
									<tr>
										
										<td colspan=4 style="color: red;">Navigated effectively through the system (Verify if calls is needed)</td>
										<td>15</td>
										<td>
											<select class="form-control revive_rx_inbound_point" id="inbound_fatal2" name="data[navigated_effectively]" disabled>
												
												<option revive_rx_inbound_val=15 revive_rx_inbound_max="15" <?php echo $revive_rx_inbound_data['navigated_effectively']=='Pass'?"selected":""; ?> value="Pass">Pass</option>
												<option revive_rx_inbound_val=0 revive_rx_inbound_max="15" <?php echo $revive_rx_inbound_data['navigated_effectively']=='Fail'?"selected":""; ?> value="Fail">Fail</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt20]" disabled value="<?php echo $revive_rx_inbound_data['cmt20'] ?>"></td>
									</tr>

									<tr>
										<td>Call Summary:</td>
										<td colspan=3><textarea class="form-control" id="" disabled name="data[call_summary]"><?php echo $revive_rx_inbound_data['call_summary'] ?></textarea></td>
										<td>Feedback:</td>
										<td colspan=3><textarea class="form-control" id="" disabled name="data[feedback]"><?php echo $revive_rx_inbound_data['feedback'] ?></textarea></td>
									</tr>

									<?php if($revive_rx_inbound_data['attach_file']!=''){ ?>
									<tr oncontextmenu="return false;">
										<td colspan="2">Audio Files (Mp4/Mp3/M4a/Wav)</td>
										<td colspan="4">
											<?php $attach_file = explode(",",$revive_rx_inbound_data['attach_file']);
											 foreach($attach_file as $af){ ?>
												<audio oncontextmenu="return false;" controls controlslist="nodownload" style="background-color:#607F93">
													  <source src="<?php echo base_url(); ?>qa_files/revive_rx_inbound/<?php echo $af; ?>" type="audio/ogg">
													  <source src="<?php echo base_url(); ?>qa_files/revive_rx_inbound/<?php echo $af; ?>" type="audio/mpeg">
												</audio> </br>
											 <?php } ?>
										</td>
									</tr>
									<?php } ?>

									<tr>
										<td style="font-size:12px">Manager Review:</td>
										<td colspan="8" style="text-align:left"><?php echo $revive_rx_inbound_data['mgnt_rvw_note'] ?></td>
									</tr>
									<tr>
										<td style="font-size:12px">Client Review:</td>
										<td colspan="8" style="text-align:left"><?php echo $revive_rx_inbound_data['client_rvw_note'] ?></td>
									</tr>

									<tr><td colspan="10" style="background-color:#C5C8C8"></td></tr>
									
									 <form id="form_agent_user" method="POST" action="">
										<input type="hidden" name="revive_rx_inbound_id" class="form-control" value="<?php echo $revive_rx_inbound_id; ?>">
										
										<tr>
											<td colspan=2 style="font-size:16px">Feedback Acceptance<span style="font-size:24px;color:red">*</span></td>
											<td colspan=6>
												<select class="form-control" id="" name="agnt_fd_acpt" required="">
													<option value="">--Select--</option>
													<option <?php echo $revive_rx_inbound_data['agnt_fd_acpt']=='Acceptance'?"selected":""; ?> value="Acceptance">Acceptance</option>	
													<option <?php echo $revive_rx_inbound_data['agnt_fd_acpt']=='Not Acceptance'?"selected":""; ?> value="Not Acceptance">Not Acceptance</option>	
												</select>
											</td>
										</tr>
										<tr>
											<td colspan=2 style="font-size:16px">Your Review<span style="font-size:24px;color:red">*</span></td>
											<td colspan=6><textarea class="form-control" name="note" required><?php echo $revive_rx_inbound_data['agent_rvw_note'] ?></textarea></td>
										</tr>
										
										<?php if(is_access_qa_agent_module()==true){
										if(is_available_qa_feedback($revive_rx_inbound_data['entry_date'],72) == true){ ?>
											<tr>
												<?php if($revive_rx_inbound_data['agent_rvw_note']==''){ ?>
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
