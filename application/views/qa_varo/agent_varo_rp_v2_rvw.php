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

.eml{
	font-weight:bold;
	background-color:#F4D03F;
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
										<td colspan="6" id="theader" style="font-size:40px">Varo RP V2 AGENT FORM</td>
										<input type="hidden" name="audit_start_time" value="<?php echo CurrMySqlDate(); ?>">
									</tr>
									<?php
										
										if($varo_rp['entry_by']!=''){
											$auditorName = $varo_rp['auditor_name'];
										}else{
											$auditorName = $varo_rp['client_name'];
										}
										$auditDate = mysql2mmddyy($varo_rp['audit_date']);
										$clDate_val = mysql2mmddyy($varo_rp['call_date']);
											
										
									?>
									<tr>
										<td style="width:150px">Auditor Name:<span style="font-size:24px;color:red">*</span></td>
										<td style="width:300px"><input type="text" class="form-control" value="<?php echo $auditorName; ?>" disabled></td>
										<td>Audit Date:<span style="font-size:24px;color:red">*</span></td>
										<td style="width:250px"><input type="text" class="form-control" value="<?php echo $auditDate; ?>" disabled></td>
										<td>Call Date:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control" id="call_date" name="call_date" value="<?php echo $clDate_val; ?>" disabled ></td>
									</tr>
									<tr>
										<td>Agent:<span style="font-size:24px;color:red">*</span></td>
										<td>
											<select class="form-control" id="agent_ids" name="data[agent_id]" disabled >
												<?php 
													if($varo_rp['agent_id']!=''){
														?>
														<option value="<?php echo $varo_rp['agent_id'] ?>"><?php echo $varo_rp['fname']." ".$varo_rp['lname']." - ".$varo_rp['fusion_id'] ?></option>
														<?php
													}else{
														?>
														<option value="">Select</option>
														<?php
													}
													?>
												<?php foreach($agentName as $row):  ?>
													<?php
													if($row['id']!= $varo_rp['agent_id'])
													{
														?>
														<option value="<?php echo $row['id']; ?>"><?php echo $row['name']." - ".$row['fusion_id']; ?></option>
														<?php

													}
													 ?>
													
													
												<?php endforeach; ?>
											</select>
										</td>
										<td style="background-color:#D7BDE2; font-weight:bold">Process:<span style="font-size:24px;color:red">*</span></td>
										<td style="background-color:#D7BDE2; font-weight:bold"><input type="text" class="form-control" id="campaign" style="background-color:#D7BDE2"value="<?php echo $varo_rp['process'] ?>" readonly ></td>
										<td>L1 Supervisor:<span style="font-size:24px;color:red">*</span></td>
										<td>
											<input type="text" class="form-control" id="tl_names"  value="<?php echo $varo_rp['tl_name'] ?>" readonly>
											<input type="hidden" class="form-control" id="tl_id" name="data[tl_id]" value="<?php echo $varo_rp['tl_id'] ?>" disabled>
										</td>
									</tr>

									<tr>
										<td>Call Duration:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control" id="call_duration" name="data[call_duration]" onkeydown="return false;" value="<?php echo $varo_rp['call_duration'] ?>" disabled ></td>
										<td>Phone Number:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control" id="phone" name="data[phone_number]" onkeyup="checkDec(this);" value="<?php echo $varo_rp['phone_number'] ?>" disabled ></td>
										<td>VSI Account:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control" id="" name="data[vsi_account]" value="<?php echo $varo_rp['vsi_account'] ?>" disabled ></td>
									</tr>
									<tr>
										
										<td>QA Type:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control" id="" name="data[qa_type]" value="<?php echo $varo_rp['qa_type'] ?>" disabled ></td>

										<td>Call ID:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control" id="" name="data[call_id]" value="<?php echo $varo_rp['call_id'] ?>" disabled ></td>

										<td>Area of Opportunity:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control" id="" name="data[area_of_opportunity]" value="<?php echo $varo_rp['area_of_opportunity'] ?>" disabled ></td>
										
										
									</tr>

									<tr>
										<td>Audit Type:<span style="font-size:24px;color:red">*</span></td>
										<td>
											<select class="form-control" id="audit_type" name="data[audit_type]" disabled>
												<option value="">-Select-</option>
												<option value="CQ Audit" <?= ($varo_rp['audit_type']=="CQ Audit")?"selected":"" ?>>CQ Audit</option>
                                                    <option value="BQ Audit" <?= ($varo_rp['audit_type']=="BQ Audit")?"selected":"" ?>>BQ Audit</option>
                                                    <option value="Calibration" <?= ($varo_rp['audit_type']=="Calibration")?"selected":"" ?>>Calibration</option>
                                                    <option value="Pre-Certificate Mock Call" <?= ($varo_rp['audit_type']=="Pre-Certificate Mock Call")?"selected":"" ?>>Pre-Certificate Mock Call</option>
                                                    <option value="Certification Audit" <?= ($varo_rp['audit_type']=="Certification Audit")?"selected":"" ?>>Certification Audit</option>
                                                    <option value="Operation Audit" <?= ($varo_rp['audit_type']=="Operation Audit")?"selected":"" ?>>Operation Audit</option>
                                                    <option value="Trainer Audit"  <?= ($varo_rp['audit_type']=="Trainer Audit")?"selected":"" ?>>Trainer Audit</option>
                                                    <option value="WOW Call" <?= ($varo_rp['audit_type']=="WOW Call")?"selected":"" ?>>WOW Call</option>
											</select>
										</td>
										
										<td class="auType">Auditor Type<span style="font-size:24px;color:red">*</span></td>
										<td class="auType">
											<select class="form-control" id="auditor_type" name="data[auditor_type]">
												<option value="Master" <?= ($varo_rp['auditor_type']=="Master")?"selected":"" ?>>Master</option>
                                                <option value="Regular" <?= ($varo_rp['auditor_type']=="Regular")?"selected":"" ?>>Regular</option>
											</select>
										</td>
									   
										<td>VOC:<span style="font-size:24px;color:red">*</span></td>
										<td>
											<select class="form-control" id="voc" name="data[voc]" disabled>
												<option value="">-Select-</option>
												<option value="1"  <?= ($varo_rp['voc']=="1")?"selected":"" ?>>1</option>
													<option value="2"  <?= ($varo_rp['voc']=="2")?"selected":"" ?>>2</option>
													<option value="3"  <?= ($varo_rp['voc']=="3")?"selected":"" ?>>3</option>
													<option value="4"  <?= ($varo_rp['voc']=="4")?"selected":"" ?>>4</option>
													<option value="5"  <?= ($varo_rp['voc']=="5")?"selected":"" ?>>5</option>
													<option value="6"  <?= ($varo_rp['voc']=="6")?"selected":"" ?>>6</option>
													<option value="7"  <?= ($varo_rp['voc']=="7")?"selected":"" ?>>7</option>
													<option value="8"  <?= ($varo_rp['voc']=="8")?"selected":"" ?>>8</option>
													<option value="9"  <?= ($varo_rp['voc']=="9")?"selected":"" ?>>9</option>
													<option value="10"  <?= ($varo_rp['voc']=="10")?"selected":"" ?>>10</option>
											</select>
										</td>

									</tr>

									</tr>

									<tr>
										<td colspan="" style="font-weight:bold; font-size:16px; text-align:right"></td>
										<td></td>
										<td colspan="" style="font-weight:bold; font-size:16px; text-align:right"></td>
										<td></td>
										<td style="font-weight:bold; font-size:16px; text-align:right">Overall Score:</td>
										<td><input type="text" class="form-control varso_rp_Fatal" readonly id="" name="data[overall_score]"  style="font-weight:bold" value="<?php echo $varo_rp['overall_score'] ?>"></td>
									</tr>
									<tr style="background-color:#A9CCE3; font-weight:bold"><td>Parameter</td><td colspan=3>Sub Parameter</td><td>Marking</td><td>Score</td></tr>
									<tr>
										<td rowspan=9 style="background-color:#A9CCE3; font-weight:bold">Opening </td>
										<td colspan=3 style="color:red">Identify himself/herself by first and last name at the beginning of the call? **SQ**</td>
										
										<td>
											<select class="form-control varo_rp_point opening_point" id="o_fatal1" name="data[identify_himself]" disabled>
												<option varo_rp_val=2.22 <?php echo $varo_rp['identify_himself']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option varo_rp_val=2.22 <?php echo $varo_rp['identify_himself']=='NA'?"selected":""; ?> value="NA">NA</option>
												<option varo_rp_val=0 <?php echo $varo_rp['identify_himself']=='No'?"selected":""; ?> value="No">No</option>
											</select>
										</td>
										<td rowspan=3>20</td>
									</tr>
									
									<tr>
										<td colspan=3 style="color:red">Provide the Quality Assurance Statement verbatim, before any specific account information was discussed?**SQ**<br> Recording disclosure: "All calls are recorded and may be monitored for Quality Assurance"</td>
										
										<td>
											<select class="form-control varo_rp_point opening_point" id="o_fatal2" name="data[provide_the_quality]" disabled>
												<option varo_rp_val=2.22 <?php echo $varo_rp['provide_the_quality']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option varo_rp_val=2.22 <?php echo $varo_rp['provide_the_quality']=='NA'?"selected":""; ?> value="NA">NA</option>
												<option varo_rp_val=0 <?php echo $varo_rp['provide_the_quality']=='No'?"selected":""; ?> value="No">No</option>
											</select>
										</td>
										
									</tr>
									<tr>
										<td colspan=3 style="color:red">State "Varo Bank" with no deviation? **SQ**</td>
										
										<td>
											<select class="form-control varo_rp_point opening_point" id="o_fatal3" name="data[state_varo_bank]" disabled>
												<option varo_rp_val=2.22 <?php echo $varo_rp['state_varo_bank']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option varo_rp_val=2.22 <?php echo $varo_rp['state_varo_bank']=='NA'?"selected":""; ?> value="NA">NA</option>
												<option varo_rp_val=0 <?php echo $varo_rp['state_varo_bank']=='No'?"selected":""; ?> value="No">No</option>
											</select>
										</td>
										
									</tr>
									<tr>
										<td colspan=3 style="color:red">Verify that he/she was speaking to a right party according to the client requirements (First and Last Name) and before providing the disclosures?</td>
										
										<td>
											<select class="form-control varo_rp_point opening_point" id="o_fatal4" name="data[speaking_to_right_party]" disabled>
												<option varo_rp_val=2.22 <?php echo $varo_rp['speaking_to_right_party']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option varo_rp_val=2.22 <?php echo $varo_rp['speaking_to_right_party']=='NA'?"selected":""; ?> value="NA">NA</option>
												<option varo_rp_val=0 <?php echo $varo_rp['speaking_to_right_party']=='No'?"selected":""; ?> value="No">No</option>
											</select>
										</td>
										<td><input id="opening_score" type="hidden" name="" disabled=""></td>
									</tr>
									<tr>
										<td colspan=3 style="color:red">Verify two pieces of demographics information on an outbound call, and two pieces on an inbound call? 1) must abide by client requirements, and 2) Consumer must provide information unless there is a resistance. 3)Must be completed before disclosures 4) Exception on consumer fail to verify two pieces of demographics information/fail to verify complete address (missing street number,etc)</td>
										
										<td>
											<select class="form-control varo_rp_point opening_point" id="o_fatal5" name="data[demographics_information]" disabled>
												<option varo_rp_val=2.22 <?php echo $varo_rp['demographics_information']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option varo_rp_val=2.22 <?php echo $varo_rp['demographics_information']=='NA'?"selected":""; ?> value="NA">NA</option>
												<option varo_rp_val=0 <?php echo $varo_rp['demographics_information']=='No'?"selected":""; ?> value="No">No</option>
											</select>
										</td>
										<td rowspan="5"></td>
									</tr>
									<tr>
										<td colspan=3 style="color:red">Provide the Mini Miranda disclosure verbatim, before any specific account information was discussed? **SQ**<br>Mini Miranda disclosure: "This call is considered an attempt to collect a debt, any information would be used for that purpose. If you dispute the validity of this debt, you have 30 days to notify us of such dispute."</td>
										
										<td>
											<select class="form-control varo_rp_point opening_point" id="o_fatal6" name="data[mini_miranda_disclosure]" disabled>
												<option varo_rp_val=2.22 <?php echo $varo_rp['mini_miranda_disclosure']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option varo_rp_val=2.22 <?php echo $varo_rp['mini_miranda_disclosure']=='NA'?"selected":""; ?> value="NA">NA</option>
												<option varo_rp_val=0 <?php echo $varo_rp['mini_miranda_disclosure']=='No'?"selected":""; ?> value="No">No</option>
											</select>
										</td>
										
									</tr>
									<tr>
										<td colspan=3 style="color:red">State the client name and the purpose of the communication?
										<br>Example: Must inform the account is ADVANCE/ BELIEVE/ NEGATIVE. In case of negative, must inform if it is Check-in or Savings depending on the account.</td>
										
										<td>
											<select class="form-control varo_rp_point opening_point" id="o_fatal7" name="data[client_name_and_purpose]" disabled>
												<option varo_rp_val=2.22 <?php echo $varo_rp['client_name_and_purpose']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option varo_rp_val=2.22 <?php echo $varo_rp['client_name_and_purpose']=='NA'?"selected":""; ?> value="NA">NA</option>
												<option varo_rp_val=0 <?php echo $varo_rp['client_name_and_purpose']=='No'?"selected":""; ?> value="No">No</option>
											</select>
										</td>
										
									</tr>
									<tr>
										<td colspan=3>Did the rep ask for callback permission as per Reg F policy?</td>
										
										<td>
											<select class="form-control varo_rp_point opening_point" name="data[callback_permission_policy]" disabled>
												<option varo_rp_val=2.22 <?php echo $varo_rp['callback_permission_policy']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option varo_rp_val=2.22 <?php echo $varo_rp['callback_permission_policy']=='NA'?"selected":""; ?> value="NA">NA</option>
												<option varo_rp_val=0 <?php echo $varo_rp['callback_permission_policy']=='No'?"selected":""; ?> value="No">No</option>
											</select>
										</td>
										
									</tr>
									<tr>
										<td colspan=3>State/Ask for balance due?</td>
										
										<td>
											<select class="form-control varo_rp_point opening_point" name="data[ask_for_balance_due]" disabled>
												<option varo_rp_val=2.22 <?php echo $varo_rp['ask_for_balance_due']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option varo_rp_val=2.22 <?php echo $varo_rp['ask_for_balance_due']=='NA'?"selected":""; ?> value="NA">NA</option>
												<option varo_rp_val=0 <?php echo $varo_rp['ask_for_balance_due']=='No'?"selected":""; ?> value="No">No</option>
											</select>
										</td>
										
									</tr>
									<!-- Effort & Negotiation -->
									<tr>
										<td rowspan=6 style="background-color:#A9CCE3; font-weight:bold">Effort & Negotiation</td>
										<td colspan=3>Intention to resolve the account? / Ask for a reason for delinquency? / Ask appropriate probing questions as when it is disabled.</td>
										
										<td>
											<select class="form-control varo_rp_point effort_point" id="cmthScriptAF6" name="data[reason_for_delinquency]" disabled>
												<option varo_rp_val=2.5 <?php echo $varo_rp['reason_for_delinquency']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option varo_rp_val=2.5 <?php echo $varo_rp['reason_for_delinquency']=='NA'?"selected":""; ?> value="NA">NA</option>
												<option varo_rp_val=0 <?php echo $varo_rp['reason_for_delinquency']=='No'?"selected":""; ?> value="No">No</option>
											</select>
										</td>
										<td rowspan=2></td>
									</tr>
									<tr>
										<td colspan=3>Ask for the payment to the account?</td>
										
										<td>
											<select class="form-control varo_rp_point effort_point" id="cmthScriptAF7" name="data[ask_for_the_payment]" disabled>
												<option varo_rp_val=2.5 <?php echo $varo_rp['ask_for_the_payment']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option varo_rp_val=2.5 <?php echo $varo_rp['ask_for_the_payment']=='NA'?"selected":""; ?> value="NA">NA</option>
												<option varo_rp_val=0 <?php echo $varo_rp['ask_for_the_payment']=='No'?"selected":""; ?> value="No">No</option>
											</select>
										</td>
										
									</tr>
									<tr>
										<td colspan=3>Help customer reset password for app incase customer states they have forgotten password ?</td>
										
										<td>
											<select class="form-control varo_rp_point effort_point" id="cmthScriptAF8" name="data[help_customer_reset_password]" disabled>
												<option varo_rp_val=2.5 <?php echo $varo_rp['help_customer_reset_password']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option varo_rp_val=0 <?php echo $varo_rp['help_customer_reset_password']=='No'?"selected":""; ?> value="No">No</option>
												<option varo_rp_val=2.5 <?php echo $varo_rp['help_customer_reset_password']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
										<td><input id="effort_score" type="hidden" name="" disabled=""></td>
									</tr>
									<tr>
										<td colspan=3>Followed the previous conversations on the account for the follow-up call</td>
										
										<td>
											<select class="form-control varo_rp_point effort_point" id="cmthScriptAF9" name="data[followed_the_previous_conversation]" disabled>
												<option varo_rp_val=2.5 <?php echo $varo_rp['followed_the_previous_conversation']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option varo_rp_val=2.5 <?php echo $varo_rp['followed_the_previous_conversation']=='NA'?"selected":""; ?> value="NA">NA</option>
												<option varo_rp_val=0 <?php echo $varo_rp['followed_the_previous_conversation']=='No'?"selected":""; ?> value="No">No</option>
											</select>
										</td>
										<td rowspan=3>15</td>
									</tr>
									<tr>
										<td colspan=3>Able to take a promise to pay on the account?</td>
										
										<td>
											<select class="form-control varo_rp_point effort_point" id="cmthScriptAF9" name="data[promise_to_pay_the_account]" disabled>
												<option varo_rp_val=2.5 <?php echo $varo_rp['promise_to_pay_the_account']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option varo_rp_val=2.5 <?php echo $varo_rp['promise_to_pay_the_account']=='NA'?"selected":""; ?> value="NA">NA</option>
												<option varo_rp_val=0 <?php echo $varo_rp['promise_to_pay_the_account']=='No'?"selected":""; ?> value="No">No</option>
											</select>
										</td>
										
									</tr>
									<tr>
										
										<td colspan=3>Did Collector try to negotiate effectively to convince the customer for payment?</td>
										
										<td>
											<select class="form-control varo_rp_point effort_point" id="cmthScriptAF10" name="data[convince_the_customer_for_payment]" disabled>
												<option varo_rp_val=2.5 <?php echo $varo_rp['convince_the_customer_for_payment']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option varo_rp_val=0 <?php echo $varo_rp['convince_the_customer_for_payment']=='No'?"selected":""; ?> value="No">No</option>
												<option varo_rp_val=2.5 <?php echo $varo_rp['convince_the_customer_for_payment']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
										<!--<td><input id="negotiation_score" type="hidden" name="" disabled=""></td>-->
									</tr>
									<!-- Compliance -->
									<tr>
										<td rowspan=16 style="background-color:#A9CCE3; font-weight:bold">Compliance</td>
										<td colspan=3 style="color:red">Did not  Misrepresent their identity or authorization and status of the consumer's account?
                                        </td>
										
										<td>
											<select class="form-control varo_rp_point compliance_point" id="complianceFatal1" name="data[misrepresent_their_identity]" disabled>
												<option varo_rp_val=1.25 <?php echo $varo_rp['misrepresent_their_identity']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option varo_rp_val=0 <?php echo $varo_rp['misrepresent_their_identity']=='No'?"selected":""; ?> value="No">No</option>
												<option varo_rp_val=1.25 <?php echo $varo_rp['misrepresent_their_identity']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
										<td></td>
									</tr>
									<tr>
										<td colspan=3 style="color:red">Did not Discuss or imply that any type of legal actions - will be taken or property repossessed, also on time barred accounts amd Did not Threaten to take actions that VRS or the client cannot legally take? 
                                        </td>
										
										<td>
											<select class="form-control varo_rp_point compliance_point" id="complianceFatal2" name="data[did_discuss_or_imply_legal_action]" disabled>
												<option varo_rp_val=1.25 <?php echo $varo_rp['did_discuss_or_imply_legal_action']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option varo_rp_val=0 <?php echo $varo_rp['did_discuss_or_imply_legal_action']=='No'?"selected":""; ?> value="No">No</option>
												<option varo_rp_val=1.25 <?php echo $varo_rp['did_discuss_or_imply_legal_action']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
										<td></td>
									</tr>
									<tr>
										<td colspan=3 style="color:red">Did not Make any false representations regarding the nature of the communication?</td>
										
										<td>
											<select class="form-control varo_rp_point compliance_point" id="complianceFatal3" name="data[false_representation]" disabled>
												<option varo_rp_val=1.25 <?php echo $varo_rp['false_representation']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option varo_rp_val=0 <?php echo $varo_rp['false_representation']=='No'?"selected":""; ?> value="No">No</option>
												<option varo_rp_val=1.25 <?php echo $varo_rp['false_representation']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
										<td></td>
									</tr>
									<tr>
										<td colspan=3 style="color:red">Did not Contact the consumer at any unusual times (sate regulations) or outside the hours of 8:00 am and 9:00 pm at the consumer's location?</td>
										
										<td>
											<select class="form-control varo_rp_point compliance_point" id="complianceFatal4" name="data[contact_the_consumer_unusual_time]" disabled>
												<option varo_rp_val=1.25 <?php echo $varo_rp['contact_the_consumer_unusual_time']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option varo_rp_val=0 <?php echo $varo_rp['contact_the_consumer_unusual_time']=='No'?"selected":""; ?> value="No">No</option>
												<option varo_rp_val=1.25 <?php echo $varo_rp['contact_the_consumer_unusual_time']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
										<td rowspan="3">20</td>
									</tr>
									<tr>
										<td colspan=3 style="color:red">Did not Communicate with the consumer at work if it is known or there is reason to know that such calls are prohibited?</td>
										
										<td>
											<select class="form-control varo_rp_point compliance_point" id="complianceFatal5" name="data[communicate_consumar_at_work]" disabled>
												<option varo_rp_val=1.25 <?php echo $varo_rp['communicate_consumar_at_work']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option varo_rp_val=0<?php echo $varo_rp['communicate_consumar_at_work']=='No'?"selected":""; ?> value="No">No</option>
												<option varo_rp_val=1.25 <?php echo $varo_rp['communicate_consumar_at_work']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
										
									</tr>
									<tr>
										<td colspan=3 style="color:red">Did not Communicate with the consumer after learning the consumer is represented by an attorney, filed for bankruptcy unless a permissible reason exists?</td>
										
										<td>
											<select class="form-control varo_rp_point compliance_point" id="complianceFatal6" name="data[consumer_represented_an_attorney]" disabled>
												<option varo_rp_val=1.25 <?php echo $varo_rp['consumer_represented_an_attorney']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option varo_rp_val=0 <?php echo $varo_rp['consumer_represented_an_attorney']=='No'?"selected":""; ?> value="No">No</option>
												<option varo_rp_val=1.25 <?php echo $varo_rp['consumer_represented_an_attorney']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
										
									</tr>
									
									<tr>
										<td colspan=3 style="color:red">Adhere to the cell phone policy/TCPA regulations and policy regarding contacting consumers via cell phone, email and fax?</td>
										
										<td>
											<select class="form-control varo_rp_point compliance_point" id="complianceFatal7" name="data[adhereto_the_cell_policy]" disabled>
												<option varo_rp_val=1.25 <?php echo $varo_rp['adhereto_the_cell_policy']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option varo_rp_val=0 <?php echo $varo_rp['adhereto_the_cell_policy']=='No'?"selected":""; ?> value="No">No</option>
												<option varo_rp_val=1.25 <?php echo $varo_rp['adhereto_the_cell_policy']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
										<td></td>
									</tr>
									<tr>
										<td colspan=3 style="color:red">Adhere to policy regarding third parties for the sole purpose of obtaining location information for the consumer?</td>
										
										<td>
											<select class="form-control varo_rp_point compliance_point" id="complianceFatal8" name="data[adhere_to_third_party_policy]" disabled>
												<option varo_rp_val=1.25 <?php echo $varo_rp['adhere_to_third_party_policy']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option varo_rp_val=0 <?php echo $varo_rp['adhere_to_third_party_policy']=='No'?"selected":""; ?> value="No">No</option>
												<option varo_rp_val=1.25 <?php echo $varo_rp['adhere_to_third_party_policy']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
										<td><input id="compliance_score" type="hidden" name="" disabled=""></td>
									</tr>
									<tr>
										<td colspan=3 style="color:red">Enter Status code/disposition codes correctly to ensure that inappropriate dialing does not take place?</td>
										
										<td>
											<select class="form-control varo_rp_point compliance_point" id="complianceFatal9" name="data[enter_status_code]" disabled>
												<option varo_rp_val=1.25 <?php echo $varo_rp['enter_status_code']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option varo_rp_val=0 <?php echo $varo_rp['enter_status_code']=='No'?"selected":""; ?> value="No">No</option>
												<option varo_rp_val=1.25 <?php echo $varo_rp['enter_status_code']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
										<td rowspan=""></td>
									</tr>
									<tr>
										<td colspan=3 style="color:red">Did not Make any statement that could constitute unfair, deceptive, or abusive acts or practices that may raise UDAAP concerns?</td>
										
										<td>
											<select class="form-control varo_rp_point compliance_point" id="complianceFatal10" name="data[constitute_unfair_statement]" disabled>
												<option varo_rp_val=1.25 <?php echo $varo_rp['constitute_unfair_statement']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option varo_rp_val=0 <?php echo $varo_rp['constitute_unfair_statement']=='No'?"selected":""; ?> value="No">No</option>
												<option varo_rp_val=1.25 <?php echo $varo_rp['constitute_unfair_statement']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
										<td></td>
									</tr>
									<tr>
										<td colspan=3 style="color:red">Did not Communicate or threaten to communicate false credit information or information which should be known to be false and utilized the proper CBR script whenever a consumer enquires about that?</td>
										
										<td>
											<select class="form-control varo_rp_point compliance_point" id="complianceFatal11" name="data[threaten_to_communicate_false_credit_information]" disabled>
												<option varo_rp_val=1.25 <?php echo $varo_rp['threaten_to_communicate_false_credit_information']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option varo_rp_val=0 <?php echo $varo_rp['threaten_to_communicate_false_credit_information']=='No'?"selected":""; ?> value="No">No</option>
												<option varo_rp_val=1.25 <?php echo $varo_rp['threaten_to_communicate_false_credit_information']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
										<td></td>
									</tr>
									<tr>
										<td colspan=3 style="color:red">Handle the consumer's dispute correctly and take appropriate action including providing the consumer with the correct contact information to submit a written dispute or complaint, or offer to escalate the call?</td>
										
										<td>
											<select class="form-control varo_rp_point compliance_point" id="complianceFatal12" name="data[handel_consumer_dispute_correctly]" disabled>
												<option varo_rp_val=1.25 <?php echo $varo_rp['handel_consumer_dispute_correctly']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option varo_rp_val=0 <?php echo $varo_rp['handel_consumer_dispute_correctly']=='No'?"selected":""; ?> value="No">No</option>
												<option varo_rp_val=1.25 <?php echo $varo_rp['handel_consumer_dispute_correctly']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
										<td></td>
									</tr>
									<tr>
										<td colspan=3 style="color:red">Did not Make the disabled statement on time barred accounts, indicating that the consumer cannot be pursued with legal action?</td>
										
										<td>
											<select class="form-control varo_rp_point compliance_point" id="complianceFatal13" name="data[statement_on_time_barred_accounts]" disabled>
												<option varo_rp_val=1.25 <?php echo $varo_rp['statement_on_time_barred_accounts']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option varo_rp_val=0 <?php echo $varo_rp['statement_on_time_barred_accounts']=='No'?"selected":""; ?> value="No">No</option>
												<option varo_rp_val=1.25 <?php echo $varo_rp['statement_on_time_barred_accounts']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
										<td></td>
									</tr>
									<tr>
										<td colspan=3 style="color:red">Adhere to FDCPA laws?</td>
										
										<td>
											<select class="form-control varo_rp_point compliance_point" id="complianceFatal14" name="data[adhere_to_fdcpa]" disabled>
												<option varo_rp_val=1.25 <?php echo $varo_rp['adhere_to_fdcpa']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option varo_rp_val=0 <?php echo $varo_rp['adhere_to_fdcpa']=='No'?"selected":""; ?> value="No">No</option>

												<option varo_rp_val=1.25 <?php echo $varo_rp['adhere_to_fdcpa']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
										<td></td>
									</tr>
									<tr>
										<td colspan=3 style="color:red">Did not Make any statement that could be considered discriminatory towards a consumer or a violation of VRS ECOA policy?</td>
										
										<td>
											<select class="form-control varo_rp_point compliance_point" id="complianceFatal15" name="data[violation_of_vrs_ecoa_policy]" disabled>
												<option varo_rp_val=1.25 <?php echo $varo_rp['violation_of_vrs_ecoa_policy']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option varo_rp_val=0 <?php echo $varo_rp['violation_of_vrs_ecoa_policy']=='No'?"selected":""; ?> value="No">No</option>
												<option varo_rp_val=1.25 <?php echo $varo_rp['violation_of_vrs_ecoa_policy']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
										<td></td>
									</tr>
									<tr>
										<td colspan=3 style="color:red">Did the collectors adhere to the State Restrictions?</td>
										
										<td>
											<select class="form-control varo_rp_point compliance_point" id="complianceFatal16" name="data[adhere_to_the_state_restrictions]" disabled>
												<option varo_rp_val=1.25 <?php echo $varo_rp['adhere_to_the_state_restrictions']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option varo_rp_val=0 <?php echo $varo_rp['adhere_to_the_state_restrictions']=='No'?"selected":""; ?> value="No">No</option>
												<option varo_rp_val=1.25 <?php echo $varo_rp['adhere_to_the_state_restrictions']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
										<td></td>
									</tr>
									<!-- Call Control-->
									<tr>
										<td rowspan=4 style="background-color:#A9CCE3; font-weight:bold">Call Control </td>
										<td colspan=3>Demonstrate Active Listening?</td>
										
										<td>
											<select class="form-control varo_rp_point call_control_point" id="cmthScriptAF1" name="data[demonstrate_active_listening]" disabled>
												<option varo_rp_val=2.5 <?php echo $varo_rp['demonstrate_active_listening']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option varo_rp_val=2.5 <?php echo $varo_rp['demonstrate_active_listening']=='NA'?"selected":""; ?> value="NA">NA</option>
												<option varo_rp_val=0 <?php echo $varo_rp['demonstrate_active_listening']=='No'?"selected":""; ?> value="No">No</option>
											</select>
										</td>
										<td></td>
									</tr>
									<tr>
										<td colspan=3>Anticipate and overcome objections?</td>
										
										<td>
											<select class="form-control varo_rp_point call_control_point" id="cmthScriptAF5" name="data[anticipate_and_overcome_objections]" disabled>
												<option varo_rp_val=2.5 <?php echo $varo_rp['anticipate_and_overcome_objections']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option varo_rp_val=2.5 <?php echo $varo_rp['anticipate_and_overcome_objections']=='NA'?"selected":""; ?> value="NA">NA</option>
												<option varo_rp_val=0 <?php echo $varo_rp['anticipate_and_overcome_objections']=='No'?"selected":""; ?> value="No">No</option>
											</select>
										</td>
										<td></td>
									</tr>
									<tr>
										<td colspan=3>Did the collector use system appropriately? <br>
										Examples: Appropriate usage of system to provide accurate information / to provide a breakdown of past due balance (as disabled).</td>
										
										<td>
											<select class="form-control varo_rp_point call_control_point" id="cmthScriptAF3" name="data[collector_use_system_appropriately]" disabled>
												<option varo_rp_val=2.5 <?php echo $varo_rp['collector_use_system_appropriately']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option varo_rp_val=2.5 <?php echo $varo_rp['collector_use_system_appropriately']=='NA'?"selected":""; ?> value="NA">NA</option>
												<option varo_rp_val=0 <?php echo $varo_rp['collector_use_system_appropriately']=='No'?"selected":""; ?> value="No">No</option>
											</select>
										</td>
										<td><input id="call_control_score" type="hidden" name="" disabled="">10</td>
									</tr>
									
									

									<tr>
										<td colspan=3>DId the collector transfer the customer to Varo support for the appropriate reason (Voice: mobile wallet activation/dispute/login/Zelle, Chat: common account related questions) appropriately?</td>
										
										<td>
											<select class="form-control varo_rp_point call_control_point" id="cmthScriptAF5" name="data[transfer_call_varo_support]" disabled>
												<option varo_rp_val=2.5 <?php echo $varo_rp['transfer_call_varo_support']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option varo_rp_val=2.5 <?php echo $varo_rp['transfer_call_varo_support']=='NA'?"selected":""; ?> value="NA">NA</option>
												<option varo_rp_val=0 <?php echo $varo_rp['transfer_call_varo_support']=='No'?"selected":""; ?> value="No">No</option>
											</select>
										</td>
										<td></td>
									</tr>
									
									<!-- -->
									
									<!-- Soft Skills / Telephone Etiquettes-->
									<tr>
										<td rowspan=4 style="background-color:#A9CCE3; font-weight:bold">Soft Skills / Telephone Etiquettes </td>
										<td colspan=3>Did the collector get connected with the consumer by building a rapport and represent the company and the client in a positive manner?</td>
										
										<td>
											<select class="form-control varo_rp_point soft_skill_point" id="cmthScriptAF1" name="data[collector_get_connected_with_consumer]" disabled>
												<option varo_rp_val=3.75 <?php echo $varo_rp['collector_get_connected_with_consumer']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option varo_rp_val=3.75 <?php echo $varo_rp['collector_get_connected_with_consumer']=='NA'?"selected":""; ?> value="NA">NA</option>
												<option varo_rp_val=0 <?php echo $varo_rp['collector_get_connected_with_consumer']=='No'?"selected":""; ?> value="No">No</option>
											</select>
										</td>
										<td></td>
									</tr>
									<tr>
										<td colspan=3>Offer any apologies / empathy statements on RP's unfortunate situation.</td>
										
										<td>
											<select class="form-control varo_rp_point soft_skill_point" id="cmthScriptAF5" name="data[apology_empathy_statement]" disabled>
												<option varo_rp_val=3.75 <?php echo $varo_rp['apology_empathy_statement']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option varo_rp_val=3.75 <?php echo $varo_rp['apology_empathy_statement']=='NA'?"selected":""; ?> value="NA">NA</option>
												<option varo_rp_val=0 <?php echo $varo_rp['apology_empathy_statement']=='No'?"selected":""; ?> value="No">No</option>
											</select>
										</td>
										<td></td>
									</tr>
									<tr>
										<td colspan=3>Did collector hung up on RP? / Did collector interrupt or talked over RP?</td>
										
										<td>
											<select class="form-control varo_rp_point soft_skill_point" id="cmthScriptAF3" name="data[collector_hang_up_rp]" disabled>
												<option varo_rp_val=3.75 <?php echo $varo_rp['collector_hang_up_rp']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option varo_rp_val=3.75 <?php echo $varo_rp['collector_hang_up_rp']=='NA'?"selected":""; ?> value="NA">NA</option>
												<option varo_rp_val=0 <?php echo $varo_rp['collector_hang_up_rp']=='No'?"selected":""; ?> value="No">No</option>
											</select>
										</td>
										<td><input id="call_control_score" type="hidden" name="" disabled="">10</td>
									</tr>
									
									

									<tr>
										<td colspan=3>Was the collector tone pleasant and accommodating? / Was the collector tone came across as confident and sounded knowledable?</td>
										
										<td>
											<select class="form-control varo_rp_point soft_skill_point" id="cmthScriptAF5" name="data[tone_pleasant_accommodating]" disabled>
												<option varo_rp_val=3.75 <?php echo $varo_rp['tone_pleasant_accommodating']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option varo_rp_val=3.75 <?php echo $varo_rp['tone_pleasant_accommodating']=='NA'?"selected":""; ?> value="NA">NA</option>
												<option varo_rp_val=0 <?php echo $varo_rp['tone_pleasant_accommodating']=='No'?"selected":""; ?> value="No">No</option>
											</select>
										</td>
										<td></td>
									</tr>
									
									<!-- Closing -->

									<tr>
										<td rowspan=5 style="background-color:#A9CCE3; font-weight:bold">Closing </td>
										<td colspan=3>Did collector has disrespectful attitude/tone?</td>
										
										<td>
											<select class="form-control varo_rp_point closing_point" id="cmthScriptAF3" name="data[disrespectful_attitude]" disabled>
												<option varo_rp_val=1 <?php echo $varo_rp['disrespectful_attitude']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option varo_rp_val=1 <?php echo $varo_rp['disrespectful_attitude']=='NA'?"selected":""; ?> value="NA">NA</option>
												<option varo_rp_val=0 <?php echo $varo_rp['disrespectful_attitude']=='No'?"selected":""; ?> value="No">No</option>
											</select>
										</td>
										
										<td></td>
									</tr>
									
									<tr>
										<td colspan=3>Summarize the call?</td>
										
										<td>
											<select class="form-control varo_rp_point closing_point" id="cmthScriptAF1" name="data[summarize_the_call]" disabled>
												<option varo_rp_val=1 <?php echo $varo_rp['summarize_the_call']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option varo_rp_val=1 <?php echo $varo_rp['summarize_the_call']=='NA'?"selected":""; ?> value="NA">NA</option>
												<option varo_rp_val=0 <?php echo $varo_rp['summarize_the_call']=='No'?"selected":""; ?> value="No">No</option>
											</select>
										</td>
										<td></td>
									</tr>
									<tr>
										<td colspan=3>Did the collector provided Varo Bank FAQ's on how to contact customer support voice/chat incase its disabled? (Voice: mobile wallet activation/dispute/login/Zelle, Chat: common account related questions) </td>
										
										<td>
											<select class="form-control varo_rp_point closing_point" id="cmthScriptAF4" name="data[provided_varo_bank_support]" disabled>
												<option varo_rp_val=1 <?php echo $varo_rp['provided_varo_bank_support']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option varo_rp_val=1 <?php echo $varo_rp['provided_varo_bank_support']=='NA'?"selected":""; ?> value="NA">NA</option>
												<option varo_rp_val=0 <?php echo $varo_rp['provided_varo_bank_support']=='No'?"selected":""; ?> value="No">No</option>
											</select>
										</td>
										<td><input id="closing_score" type="hidden" name="" disabled="">5</td>
									</tr>
									<tr>
										<td colspan=3>Set appropriate timelines and expectations for follow up?</td>
										
										<td>
											<select class="form-control varo_rp_point closing_point" id="cmthScriptAF4" name="data[set_appropriate_timelines]" disabled>
												<option varo_rp_val=1 <?php echo $varo_rp['set_appropriate_timelines']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option varo_rp_val=1 <?php echo $varo_rp['set_appropriate_timelines']=='NA'?"selected":""; ?> value="NA">NA</option>
												<option varo_rp_val=0 <?php echo $varo_rp['set_appropriate_timelines']=='No'?"selected":""; ?> value="No">No</option>
											</select>
										</td>
										<td></td>
									</tr>
									<tr>
										<td colspan=3>Close the call Professionally? / Did collector ask if there are any further questions?</td>
										
										<td>
											<select class="form-control varo_rp_point closing_point" id="cmthScriptAF5" name="data[professionally_close_the_call]" disabled>
												<option varo_rp_val=1 <?php echo $varo_rp['professionally_close_the_call']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option varo_rp_val=1 <?php echo $varo_rp['professionally_close_the_call']=='NA'?"selected":""; ?> value="NA">NA</option>
												<option varo_rp_val=0 <?php echo $varo_rp['professionally_close_the_call']=='No'?"selected":""; ?> value="No">No</option>
											</select>
										</td>
										<td></td>
									</tr>
									<!-- Documentation  -->
									<tr>
										<td rowspan=7 style="background-color:#A9CCE3; font-weight:bold">Documentation </td>
										<td colspan=3 style="color:red">Did the collector file and document any complaints?</td>
										
										<td>
											<select class="form-control varo_rp_point documentation_point" id="doc_fatal2" name="data[collector_file_document]" disabled>
												<option varo_rp_val=2.14 <?php echo $varo_rp['collector_file_document']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option varo_rp_val=2.14 <?php echo $varo_rp['collector_file_document']=='NA'?"selected":""; ?> value="NA">NA</option>
												<option varo_rp_val=0 <?php echo $varo_rp['collector_file_document']=='No'?"selected":""; ?> value="No">No</option>
											</select>
										</td>
										<td></td>
									</tr>
									
									
									<tr>
										<td colspan=3 style="color:red">Document thoroughly the context of the conversation?</td>
										
										<td>
											<select class="form-control varo_rp_point documentation_point" id="doc_fatal3" name="data[context_of_conversation]" disabled>
												<option varo_rp_val=2.14 <?php echo $varo_rp['context_of_conversation']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option varo_rp_val=2.14 <?php echo $varo_rp['context_of_conversation']=='NA'?"selected":""; ?> value="NA">NA</option>
												<option varo_rp_val=0 <?php echo $varo_rp['context_of_conversation']=='No'?"selected":""; ?> value="No">No</option>
											</select>
										</td>
										<td></td>
									</tr>
									<tr>
										<td colspan=3>Did the rep document the callback permission on the account as per Reg F policy?</td>
										
										<td>
											<select class="form-control varo_rp_point documentation_point" id="doc_fatal4" name="data[callback_permission_document]" disabled>
												<option varo_rp_val=2.14 <?php echo $varo_rp['callback_permission_document']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option varo_rp_val=2.14 <?php echo $varo_rp['callback_permission_document']=='NA'?"selected":""; ?> value="NA">NA</option>
												<option varo_rp_val=0 <?php echo $varo_rp['callback_permission_document']=='No'?"selected":""; ?> value="No">No</option>
											</select>
										</td>
										<td><input id="documentation_score" type="hidden" name="" disabled=""></td>
									</tr>
									<tr>
										<td colspan=3 style="color:red">Remove any phone numbers known to be incorrect?**SQ**</td>
										
										<td>
											<select class="form-control varo_rp_point documentation_point" id="doc_fatal5" name="data[remove_any_incorrect_phone]" disabled>
												<option varo_rp_val=2.14 <?php echo $varo_rp['remove_any_incorrect_phone']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option varo_rp_val=2.14 <?php echo $varo_rp['remove_any_incorrect_phone']=='NA'?"selected":""; ?> value="NA">NA</option>
												<option varo_rp_val=0 <?php echo $varo_rp['remove_any_incorrect_phone']=='No'?"selected":""; ?> value="No">No</option>
											</select>
										</td>
										<td>15</td>
									</tr>
									<tr>
										<td colspan=3 style="color:red">Update address information if appropriate?**SQ**</td>
										
										<td>
											<select class="form-control varo_rp_point documentation_point" id="doc_fatal6" name="data[update_address_information]" disabled>
												<option varo_rp_val=2.14 <?php echo $varo_rp['update_address_information']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option varo_rp_val=2.14 <?php echo $varo_rp['update_address_information']=='NA'?"selected":""; ?> value="NA">NA</option>
												<option varo_rp_val=0 <?php echo $varo_rp['update_address_information']=='No'?"selected":""; ?> value="No">No</option>
											</select>
										</td>
										<td></td>
									</tr>
									<tr>
										<td colspan=3 style="color:red">Change the status of the account, if appropriate?**SQ**</td>
										
										<td>
											<select class="form-control varo_rp_point documentation_point" id="doc_fatal8" name="data[change_the_status]" disabled>
												<option varo_rp_val=2.14 <?php echo $varo_rp['change_the_status']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option varo_rp_val=2.14 <?php echo $varo_rp['change_the_status']=='NA'?"selected":""; ?> value="NA">NA</option>
												<option varo_rp_val=0 <?php echo $varo_rp['change_the_status']=='No'?"selected":""; ?> value="No">No</option>
											</select>
										</td>
										<td></td>
									</tr>
									
									<tr>
										<td colspan=3>Escalate the account to a supervisor for handling, if appropriate?</td>
										
										<td>
											<select class="form-control varo_rp_point documentation_point" name="data[escalate_the_account_to_supervisor]" id="doc_fatal9" disabled>
												<option varo_rp_val=2.14 <?php echo $varo_rp['escalate_the_account_to_supervisor']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option varo_rp_val=2.14 <?php echo $varo_rp['escalate_the_account_to_supervisor']=='NA'?"selected":""; ?> value="NA">NA</option>
												<option varo_rp_val=0 <?php echo $varo_rp['escalate_the_account_to_supervisor']=='No'?"selected":""; ?> value="No">No</option>
											</select>
										</td>
										<td></td>
									</tr>

									<tr>
										<td>Observations:</td>
										<td colspan=2><textarea class="form-control" id="" name="data[call_summary]"><?php echo $varo_rp['call_summary'] ?></textarea></td>
										<td>Area of opportunity:</td>
										<td colspan=2><textarea class="form-control" id="" name="data[feedback]"><?php echo $varo_rp['feedback'] ?></textarea></td>
									</tr>
									
									<?php if($varo_rp['attach_file']!=''){ ?>
									<tr oncontextmenu="return false;">
										<td colspan="2">Audio Files (Mp4/Mp3/M4a/Wav)</td>
										<td colspan="4">
											<?php $attach_file = explode(",",$varo_rp['attach_file']);
											 foreach($attach_file as $af){ ?>
												<audio oncontextmenu="return false;" controls controlslist="nodownload" style="background-color:#607F93">
													  <source src="<?php echo base_url(); ?>qa_files/qa_varo_rp/<?php echo $af; ?>" type="audio/ogg">
													  <source src="<?php echo base_url(); ?>qa_files/qa_varo_rp/<?php echo $af; ?>" type="audio/mpeg">
												</audio> </br>
											 <?php } ?>
										</td>
									</tr>
									<?php } ?>
									<tr>
										<td style="font-size:12px">Manager Review:</td>
										<td colspan="8" style="text-align:left"><?php echo $varo_rp['mgnt_rvw_note'] ?></td>
									</tr>
									<tr>
										<td style="font-size:12px">Client Review:</td>
										<td colspan="8" style="text-align:left"><?php echo $varo_rp['client_rvw_note'] ?></td>
									</tr>

									<tr><td colspan="10" style="background-color:#C5C8C8"></td></tr>
									
									<form id="form_agent_user" method="POST" action="">
										<input type="hidden" name="varo_rp_v2_id" class="form-control" value="<?php echo $varo_rp_v2_id; ?>">
										
										<tr>
											<td colspan=2 style="font-size:16px">Feedback Acceptance<span style="font-size:24px;color:red">*</span></td>
											<td colspan=6>
												<select class="form-control" id="" name="agnt_fd_acpt" required="">
													<option value="">--Select--</option>
													<option <?php echo $varo_rp['agnt_fd_acpt']=='Acceptance'?"selected":""; ?> value="Acceptance">Acceptance</option>	
													<option <?php echo $varo_rp['agnt_fd_acpt']=='Not Acceptance'?"selected":""; ?> value="Not Acceptance">Not Acceptance</option>	
												</select>
											</td>
										</tr>
										<tr>
											<td colspan=2 style="font-size:16px">Your Review<span style="font-size:24px;color:red">*</span></td>
											<td colspan=6><textarea class="form-control" name="note" required><?php echo $varo_rp['agent_rvw_note'] ?></textarea></td>
										</tr>
										
										<?php if(is_access_qa_agent_module()==true){
										if(is_available_qa_feedback($varo_rp['entry_date'],72) == true){ ?>
											<tr>
												<?php if($varo_rp['agent_rvw_note']==''){ ?>
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
