
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
	font-weight:bold;
	background-color:#CCD1D1;
}

.eml2{
	font-size:24px;
	font-weight:bold;
	background-color:#05203E;
	color:white;
}

.eml1{
	font-size:20px;
	font-weight:bold;
	background-color:#AED6F1;
}

.emp2{
	font-size:16px; 
	font-weight:bold;
}

.seml{
	font-size:15px;
	font-weight:bold;
	background-color:#CCD1D1;
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
										<td colspan="6" id="theader" style="font-size:40px; text-align:center!important; ">VRS Right Party V2 AGENT FORM</td>
										<!-- <td colspan="6" id="theader" style="font-size:30px"><img src="<?php //echo base_url(); ?>main_img/vrs.png"></td> -->
										<input type="hidden" name="audit_start_time" value="<?php echo CurrMySqlDate(); ?>">
									</tr>
									
									<tr>
										<td>QA Name:</td>
										<?php if($right_party_v2_data['entry_by']!=''){
												$auditorName = $right_party_v2_data['auditor_name'];
											}else{
												$auditorName = $right_party_v2_data['client_name'];
										} ?>
										<td><input type="text" class="form-control" value="<?= $auditorName; ?>"   disabled></td>
										<td>Audit Date:</td>
										<td><input type="text" class="form-control" value="<?php echo CurrDateMDY(); ?>" disabled></td>
										<td>Mobile No.:</td>
										<td><input type="text" class="form-control" id="phone" name="data[phone]" onkeyup="checkDec(this);" value="<?php echo $right_party_v2_data['phone'] ?>" disabled>
										<span id="start_phone" style="color:red"></span></td>
									</tr>
									<tr>
										<td>Agent:</td>
										<td>
											
											<select class="form-control" id="agent_id" name="data[agent_id]" disabled>
													<?php 
													if($right_party_v2_data['agent_id']!=''){
														?>
														<option value="<?php echo $right_party_v2_data['agent_id'] ?>"><?php echo $right_party_v2_data['fname'] . " " . $right_party_v2_data['lname'] ?></option>
														<?php
													}else{
														?>
														<option value="">Select</option>
														<?php
													}
													?>
													
													
													<?php foreach ($agentName as $row) :  ?>
													<?php 
													if($row['id'] == $right_party_v2_data['agent_id']){
														continue;
													}else{
														?>
														<option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
														<?php
													}
													?>
														
													<?php endforeach; ?>
												</select>
										</td>
										<td>Employee ID:</td>
											<td><input type="text" class="form-control" id="fusion_id" required value="<?php echo $right_party_v2_data['fusion_id'] ?>" readonly></td>
										<td>L1 Supervisor:</td>
										<td>
											<input type="text" class="form-control" id="tl_name"  value="<?php echo $right_party_v2_data['tl_name'] ?>" readonly>
												<input type="hidden" class="form-control" id="tl_id" name="data[tl_id]" value="<?php echo $right_party_v2_data['tl_id'] ?>" >
										</td>
									</tr>
									<tr>
										<td style="font-weight:bold">Client:</td>
										<td><input type="text" class="form-control" id="" name="data[c_name]" value="<?php echo $right_party_v2_data['c_name'] ?>" disabled></td>
										<td>Contact Date:</td>
										<!-- <td><input type="text" class="form-control" id="contact_date" name="call_date" disabled></td> -->
										<td>
												<input type="text" id="call_date" name="call_date"  onkeydown="return false;" value="<?php echo $right_party_v2_data['call_date']; ?>" max="<?php echo date("Y-m-d"); ?>" class="form-control" disabled>
										</td>
										<td>Contact Duration:</td>
										<td><input type="text" class="form-control" id="call_duration" name="data[call_duration]" value="<?php echo $right_party_v2_data['call_duration']; ?>" disabled></td>
									</tr>
									<tr>
										<td>ACPT</td>
										<td>
											<select class="form-control" id="acpt" name="data[acpt]"  disabled>
												<option value="">-Select-</option>
												<option value="Agent" <?= ($right_party_v2_data['acpt']=="Agent")?"selected":"" ?>>Agent</option>
												<option value="Customer" <?= ($right_party_v2_data['acpt']=="Customer")?"selected":"" ?>>Customer</option>
												<option value="Process" <?= ($right_party_v2_data['acpt']=="Process")?"selected":"" ?>>Process</option>
												<option value="Technology" <?= ($right_party_v2_data['acpt']=="Technology")?"selected":"" ?>>Technology</option>
											</select>
										</td>
										<td colspan=2>
											<select class="form-control" id="acpt_option" name="data[acpt_option]" disabled>
												<?php
												if($right_party_v2_data[acpt_option]!=''){
													?>
													<option value="<?php echo $right_party_v2_data['acpt_option'] ?>"><?php echo $right_party_v2_data['acpt_option'] ?></option>
													<?php

												}

												 ?>
											</select>
										</td>
										<td colspan=2 class="acptoth">
											<input type="text" class="form-control" id="acpt_other" name="data[acpt_other]" value="<?php echo $right_party_v2_data['call_duration']; ?>">
										</td>
									</tr>
									<tr>
										<td>Audit Type:</td>
										<td>
											<select class="form-control" id="audit_type" name="data[audit_type]" disabled>
												<option value="">-Select-</option>
												 <option value="CQ Audit" <?= ($right_party_v2_data['audit_type']=="CQ Audit")?"selected":"" ?>>CQ Audit</option>
                                                    <option value="BQ Audit" <?= ($right_party_v2_data['audit_type']=="BQ Audit")?"selected":"" ?>>BQ Audit</option>
												<option value="Calibration" <?= ($right_party_v2_data['audit_type']=="Calibration")?"selected":"" ?>>Calibration</option>
												<option value="Pre-Certificate Mock Call" <?= ($right_party_v2_data['audit_type']=="Pre-Certificate Mock Call")?"selected":"" ?>>Pre-Certificate Mock Call</option>
												<option value="Certification Audit" <?= ($right_party_v2_data['audit_type']=="Certification Audit")?"selected":"" ?>>Certification Audit</option>
                                                    <option value="WoW Call"  <?= ($right_party_v2_data['audit_type']=="WoW Call")?"selected":"" ?>>WoW Call</option>
											</select>
										</td>
										<td class="auType">Auditor Type</td>
										<td class="auType">
											<select class="form-control" id="auditor_type" name="data[auditor_type]">
												<option value="">-Select-</option>
												<option value="Master" <?= ($right_party_v2_data['auditor_type']=="Master")?"selected":"" ?>>Master</option>
                                                    <option value="Regular" <?= ($right_party_v2_data['auditor_type']=="Regular")?"selected":"" ?>>Regular</option>
											</select>
										</td>
										<td>VOC:</td>
										<td>
											<select class="form-control" id="voc" name="data[voc]" disabled>
												<option value="">-Select-</option>
													<option value="1"  <?= ($right_party_v2_data['voc']=="1")?"selected":"" ?>>1</option>
													<option value="2"  <?= ($right_party_v2_data['voc']=="2")?"selected":"" ?>>2</option>
													<option value="3"  <?= ($right_party_v2_data['voc']=="3")?"selected":"" ?>>3</option>
													<option value="4"  <?= ($right_party_v2_data['voc']=="4")?"selected":"" ?>>4</option>
													<option value="5"  <?= ($right_party_v2_data['voc']=="5")?"selected":"" ?>>5</option>
												
											</select>
										</td>
									</tr>
									<tr>
										<td>VSI Account:</td>
										<td><input type="text" class="form-control" id="vsi_account" name="data[vsi_account]" value="<?php echo $right_party_v2_data['vsi_account']; ?>" disabled></td>
										<td style="font-size:15px; font-weight:bold">QA Type</td>
										<td style="font-size:15px; font-weight:bold">
											<select class="form-control" name="data[qa_type]" disabled>
												<option value="">-Select-</option>
												<option value="Regular"  <?= ($right_party_v2_data['qa_type']=="Regular")?"selected":"" ?>>Regular</option>
												<option value="Analysis"  <?= ($right_party_v2_data['qa_type']=="Analysis")?"selected":"" ?>>Analysis</option>
											</select>
										</td>
										<td>Call ID:</td>
										<td><input type="text" class="form-control" id="" name="data[call_id]" value="<?php echo $right_party_v2_data['call_id']; ?>" disabled></td>
									</tr>
									<tr>
										<td colspan=5 style="font-size:18px; font-weight:bold; text-align:right">Overall Score:</td>
										<!-- <td style="font-size:18px; font-weight:bold"><input type="text" readonly class="form-control" id="overallScore" name="data[overall_score]" value="100%"></td> -->
										
										<td style="font-size:18px; font-weight:bold"><input type="text" class="form-control right_party_v2_Fatal" readonly id="right_party_v2_overall_score" name="data[overall_score]"  style="font-weight:bold" value="<?php echo $right_party_v2_data['overall_score'] ?>"></td>
									</tr>

									<tr style="height:45px">
										<td class="eml2">Category</td>
										<td class="eml2" colspan=2>Sub Category</td>
										<td class="eml2">Weightage</td>
										<td class="eml2" style="width:150px">Status</td>
										<td class="eml2" style="width:150px">Scoring</td>
									</tr>
									<tr>
										<td rowspan=9 class="eml1">Opening</td>
										<td class="eml" colspan=2 style="color:red">Identify himself/herself by first and last name at the beginning of the call? **SQ**</td>
										<td>1.11</td>
										<td>
											<select class="form-control opening_score" id="o_fatal1" name="data[identifynameatbeginning]" disabled>
												<option o_val=1.11 o_val_max="1.11"<?php echo $right_party_v2_data['identifynameatbeginning'] == "Yes" ? "selected" : ""; ?> value="Yes">Yes</option>
												<option o_val=0 o_val_max="1.11"<?php echo $right_party_v2_data['identifynameatbeginning'] == "No" ? "selected" : ""; ?> value="No">No</option>
												<option o_val=1.11 o_val_max="1.11"<?php echo $right_party_v2_data['identifynameatbeginning'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td rowspan=9><input type="text" readonly class="form-control" id="totalOpening" name="data[openingscore]"></td>
									</tr>
									<tr>
										<td class="eml" colspan=2 style="color:red">Provide the Quality Assurance Statement verbatim, before any specific account information was discussed?**SQ**
										Recording disclosure: "All calls are recorded and may be monitored for Quality Assurance"</td>
										<td>1.11</td>
										<td>
											<select class="form-control opening_score" id="o_fatal2" name="data[assurancetsatementverbatim]" disabled>
												<option o_val=1.11 o_val_max="1.11"<?php echo $right_party_v2_data['assurancetsatementverbatim'] == "Yes" ? "selected" : ""; ?> value="Yes">Yes</option>
												<option o_val=0 o_val_max="1.11"<?php echo $right_party_v2_data['assurancetsatementverbatim'] == "No" ? "selected" : ""; ?> value="No">No</option>
												<option o_val=1.11 o_val_max="1.11"<?php echo $right_party_v2_data['assurancetsatementverbatim'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
											</select>
										</td>
									</tr>
									<tr>
										<td class="eml" colspan=2 style="color:red">State "Vital Recovery Services" with no deviation? **SQ**</td>
										<td>1.11</td>
										<td>
											<select class="form-control opening_score" id="o_fatal3" name="data[VRSwithnodeviation]" disabled>
												<option o_val=1.11 o_val_max="1.11"<?php echo $right_party_v2_data['VRSwithnodeviation'] == "Yes" ? "selected" : ""; ?> value="Yes">Yes</option>
												<option o_val=0 o_val_max="1.11"<?php echo $right_party_v2_data['VRSwithnodeviation'] == "No" ? "selected" : ""; ?> value="No">No</option>
												<option o_val=1.11 o_val_max="1.11"<?php echo $right_party_v2_data['VRSwithnodeviation'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												
											</select>
										</td>
									</tr>
									<tr>
										<td class="eml" colspan=2 style="color:red">Verify that he/she was speaking to a right party according to the client requirements (First and Last Name) and before providing the disclosures?</td>
										<td>1.11</td>
										<td>
											<select class="form-control opening_score" id="o_fatal4" name="data[speakingtorightparty]" disabled>
												<option o_val=1.11 o_val_max="1.11"<?php echo $right_party_v2_data['speakingtorightparty'] == "Yes" ? "selected" : ""; ?> value="Yes">Yes</option>
												<option o_val=0 o_val_max="1.11"<?php echo $right_party_v2_data['speakingtorightparty'] == "No" ? "selected" : ""; ?> value="No">No</option>
												<option o_val=1.11 o_val_max="1.11"<?php echo $right_party_v2_data['speakingtorightparty'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												
											</select>
										</td>
									</tr>
									<tr>
										<td class="eml" colspan=2 style="color:red">Verify one/two pieces of demographics information on an outbound call, and one/two pieces on an inbound call? 1) must abide by client requirements, and 2) Consumer must provide information unless there is a resistance. 3)Must be completed before disclosures 4) Exception on consumer fail to verify two pieces of demographics information/fail to verify complete address (missing street number,etc)</td>
										<td>1.11</td>
										<td>
											<select class="form-control opening_score" id="o_fatal5" name="data[demographicsinformation]" disabled>
												<option o_val=1.11 o_val_max="1.11"<?php echo $right_party_v2_data['demographicsinformation'] == "Yes" ? "selected" : ""; ?> value="Yes">Yes</option>
												<option o_val=0 o_val_max="1.11"<?php echo $right_party_v2_data['demographicsinformation'] == "No" ? "selected" : ""; ?> value="No">No</option>
												<option o_val=1.11 o_val_max="1.11"<?php echo $right_party_v2_data['demographicsinformation'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												
											</select>
										</td>
									</tr>
									<tr>
										<td class="eml" colspan=2 style="color:red">Provide the Mini Miranda disclosure verbatim, before any specific account information was discussed? **SQ**
										Mini Miranda disclosure: "This is a communication from a debt collector. This is an attempt to collect a debt and any information obtained will be used for that purpose."</td>
										<td>1.11</td>
										<td>
											<select class="form-control opening_score" id="o_fatal6" name="data[minimirandadisclosure]" disabled>
												<option o_val=1.11 o_val_max="1.11"<?php echo $right_party_v2_data['minimirandadisclosure'] == "Yes" ? "selected" : ""; ?> value="Yes">Yes</option>
												<option o_val=0 o_val_max="1.11"<?php echo $right_party_v2_data['minimirandadisclosure'] == "No" ? "selected" : ""; ?> value="No">No</option>
												<option o_val=1.11 o_val_max="1.11"<?php echo $right_party_v2_data['minimirandadisclosure'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												
											</select>
										</td>
									</tr>
									<tr>
										<td class="eml" colspan=2 style="color:red">State the client name and the purpose of the communication?</td>
										<td>1.11</td>
										<td>
											<select class="form-control opening_score" id="o_fatal7" name="data[statetheclientname]" disabled>
												<option o_val=1.11 o_val_max="1.11"<?php echo $right_party_v2_data['statetheclientname'] == "Yes" ? "selected" : ""; ?> value="Yes">Yes</option>
												<option o_val=0 o_val_max="1.11"<?php echo $right_party_v2_data['statetheclientname'] == "No" ? "selected" : ""; ?> value="No">No</option>
												<option o_val=1.11 o_val_max="1.11"<?php echo $right_party_v2_data['statetheclientname'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												
											</select>
										</td>
									</tr>
									<tr>
										<td class="eml" colspan=2>Did the rep ask for callback permission as per Reg F policy?</td>
										<td>1.12</td>
										<td>
											<select class="form-control opening_score" name="data[for_callback_permission]" disabled>
												<option o_val=1.12 o_val_max="1.12"<?php echo $right_party_v2_data['for_callback_permission'] == "Yes" ? "selected" : ""; ?> value="Yes">Yes</option>
												<option o_val=0 o_val_max="1.12"<?php echo $right_party_v2_data['for_callback_permission'] == "No" ? "selected" : ""; ?> value="No">No</option>
												<option o_val=1.12 o_val_max="1.12"<?php echo $right_party_v2_data['for_callback_permission'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												
											</select>
										</td>
									</tr>
									<tr>
										<td class="eml" colspan=2>Sate/Ask for balance due?</td>
										<td>1.11</td>
										<td>
											<select class="form-control opening_score" id="" name="data[askforbalancedue]" disabled>
												<option o_val=1.11 o_val_max="1.11"<?php echo $right_party_v2_data['askforbalancedue'] == "Yes" ? "selected" : ""; ?> value="Yes">Yes</option>
												<option o_val=0 o_val_max="1.11"<?php echo $right_party_v2_data['askforbalancedue'] == "No" ? "selected" : ""; ?> value="No">No</option>
												<option o_val=1.11 o_val_max="1.11"<?php echo $right_party_v2_data['askforbalancedue'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												
											</select>
										</td>
									</tr>
									<tr>
										<td rowspan=5 class="eml1">Effort</td>
										<td class="eml" colspan=2>Ask for a reason for delinquency/intention to resolve the account?</td>
										<td>4</td>
										<td>
											<select class="form-control effort_score" id="" name="data[reasonfordelinquency]" disabled>
												<option e_val=4 e_val_max="4"<?php echo $right_party_v2_data['reasonfordelinquency'] == "Yes" ? "selected" : ""; ?> value="Yes">Yes</option>
												<option e_val=0 e_val_max="4"<?php echo $right_party_v2_data['reasonfordelinquency'] == "No" ? "selected" : ""; ?> value="No">No</option>
												<option e_val=4 e_val_max="4"<?php echo $right_party_v2_data['reasonfordelinquency'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												
											</select>
										</td>
										<td rowspan=5><input type="text" readonly class="form-control" id="totalEffort" name="data[effortscore]"></td>
									</tr>
									<tr>
										<td class="eml" colspan=2>Full and Complete information taken?
										Examples: Probing questions to determine the reason why RP is unable to pay; Questions to determine RP's financial situation/other sources of income/employement status; Questions to determine RP's income and expenses to provide best payment options.</td>
										<td>4</td>
										<td>
											<select class="form-control effort_score" id="" name="data[completeinformationtaken]" disabled>
												<option e_val=4 e_val_max="4"<?php echo $right_party_v2_data['completeinformationtaken'] == "Yes" ? "selected" : ""; ?> value="Yes">Yes</option>
												<option e_val=0 e_val_max="4"<?php echo $right_party_v2_data['completeinformationtaken'] == "No" ? "selected" : ""; ?> value="No">No</option>
												<option e_val=4 e_val_max="4"<?php echo $right_party_v2_data['completeinformationtaken'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												
											</select>
										</td>
									</tr>
									<tr>
										<td class="eml" colspan=2>Ask for the payment over the phone? / Ask for a post dated payment (except for the states MA or RI)?</td>
										<td>4</td>
										<td>
											<select class="form-control effort_score" id="" name="data[askforpaymentonphone]" disabled>
												<option e_val=4 e_val_max="4"<?php echo $right_party_v2_data['askforpaymentonphone'] == "Yes" ? "selected" : ""; ?> value="Yes">Yes</option>
												<option e_val=0 e_val_max="4"<?php echo $right_party_v2_data['askforpaymentonphone'] == "No" ? "selected" : ""; ?> value="No">No</option>
												<option e_val=4 e_val_max="4"<?php echo $right_party_v2_data['askforpaymentonphone'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>

											</select>
										</td>
									</tr>
									
									<tr>
										<td class="eml" colspan=2>Followed the previous conversations on the account for the follow-up call</td>
										<td>4</td>
										<td>
											<select class="form-control effort_score" id="" name="data[accountforfollowupcall]" disabled>
												<option e_val=4 e_val_max="4"<?php echo $right_party_v2_data['accountforfollowupcall'] == "Yes" ? "selected" : ""; ?> value="Yes">Yes</option>
												<option e_val=0 e_val_max="4"<?php echo $right_party_v2_data['accountforfollowupcall'] == "No" ? "selected" : ""; ?> value="No">No</option>
												<option e_val=4 e_val_max="4"<?php echo $right_party_v2_data['accountforfollowupcall'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												
											</select>
										</td>
									</tr>
									<tr>
										<td class="eml" colspan=2>Able to take a promise to pay on the account?</td>
										<td>4</td>
										<td>
											<select class="form-control effort_score" id="" name="data[promisetopayaccount]" disabled>
												<option e_val=4 e_val_max="4"<?php echo $right_party_v2_data['promisetopayaccount'] == "Yes" ? "selected" : ""; ?> value="Yes">Yes</option>
												<option e_val=0 e_val_max="4"<?php echo $right_party_v2_data['promisetopayaccount'] == "No" ? "selected" : ""; ?> value="No">No</option>
												<option e_val=4 e_val_max="4"<?php echo $right_party_v2_data['promisetopayaccount'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												
											</select>
										</td>
									</tr>
									<tr>
										<td rowspan=2 class="eml1">Negotiation</td>
										<td class="eml" colspan=2>Offer to split the balance in part? / Offer settlement appropriately? / Offer appropriate payment plan options? / Did Collector follow proper negotiation sequence to provide settelment options? / Offer a small good faith payment?</td>
										<td>10</td>
										<td>
											<select class="form-control negotiation_score" id="" name="data[splitbalanceinpart]" disabled>
												<option n_val=10 n_val_max="10"<?php echo $right_party_v2_data['splitbalanceinpart'] == "Yes" ? "selected" : ""; ?> value="Yes">Yes</option>
												<option n_val=0 n_val_max="10"<?php echo $right_party_v2_data['splitbalanceinpart'] == "No" ? "selected" : ""; ?> value="No">No</option>
												<option n_val=10 n_val_max="10"<?php echo $right_party_v2_data['splitbalanceinpart'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												
											</select>
										</td>
										<td rowspan=2><input type="text" readonly class="form-control" id="totalNegotiation" name="data[negotiationscore]"></td>
									</tr>
									<tr>
										<td class="eml" colspan=2>Did Collector try to negotiate effectively to convince the customer for payment?</td>
										<td>10</td>
										<td>
											<select class="form-control negotiation_score" id="" name="data[negotiate_effectively]" disabled>
												<option n_val=10 n_val_max="10"<?php echo $right_party_v2_data['negotiate_effectively'] == "Yes" ? "selected" : ""; ?> value="Yes">Yes</option>
												<option n_val=0 n_val_max="10"<?php echo $right_party_v2_data['negotiate_effectively'] == "No" ? "selected" : ""; ?> value="No">No</option>
												<option n_val=10 n_val_max="10"<?php echo $right_party_v2_data['negotiate_effectively'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												
											</select>
										</td>
									</tr>

									<tr>
										<td rowspan=16 class="eml1">Compliance</td>
										<td class="eml" colspan=2 style="color:red">Did not  Misrepresent their identity or authorization and status of the consumer's account?</td>
										<td>0.94</td>
										<td>
											<select class="form-control compliance_score" id="c_fatal1" name="misrepresentidentity" disabled>
												<option c_val=0.94 c_val_max="0.94"<?php echo $right_party_v2_data['misrepresentidentity'] == "Yes" ? "selected" : ""; ?> value="Yes">Yes</option>
												<option c_val=0 c_val_max="0.94"<?php echo $right_party_v2_data['misrepresentidentity'] == "No" ? "selected" : ""; ?> value="No">No</option>
												<option c_val=0.94 c_val_max="0.94"<?php echo $right_party_v2_data['misrepresentidentity'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												
											</select>
										</td>
										<td rowspan=16><input type="text" readonly class="form-control" id="totalCompliance" name="data[compliancescore]"></td>
									</tr>
									<tr>
										<td class="eml" colspan=2 style="color:red">Did not Discuss or imply that any type of legal actions - will be taken or property repossessed, also on time barred accounts amd Did not Threaten to take actions that VRS or the client cannot legally take?</td>
										<td>0.94</td>
										<td>
											<select class="form-control compliance_score" id="c_fatal2" name="data[discussoflegalaction]" disabled>
												<option c_val=0.94 c_val_max="0.94"<?php echo $right_party_v2_data['discussoflegalaction'] == "Yes" ? "selected" : ""; ?> value="Yes">Yes</option>
												<option c_val=0 c_val_max="0.94"<?php echo $right_party_v2_data['discussoflegalaction'] == "No" ? "selected" : ""; ?> value="No">No</option>
												<option c_val=0.94 c_val_max="0.94"<?php echo $right_party_v2_data['discussoflegalaction'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
											</select>
										</td>
									</tr>
									<tr>
										<td class="eml" colspan=2 style="color:red">Did not Make any false representations regarding the nature of the communication?</td>
										<td>0.94</td>
										<td>
											<select class="form-control compliance_score" id="c_fatal3" name="data[makeanyfalserepresentation]" disabled>
												<option c_val=0.94 c_val_max="0.94"<?php echo $right_party_v2_data['reasonfordelinquency'] == "Yes" ? "selected" : ""; ?> value="Yes">Yes</option>
												<option c_val=0 c_val_max="0.94"<?php echo $right_party_v2_data['reasonfordelinquency'] == "No" ? "selected" : ""; ?> value="No">No</option>
												<option c_val=0.94 c_val_max="0.94"<?php echo $right_party_v2_data['reasonfordelinquency'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												
											</select>
										</td>
									</tr>
									<tr>
										<td class="eml" colspan=2 style="color:red">Did not Contact the consumer at any unusual times (sate regulations) or outside the hours of 8:00 am and 9:00 pm at the consumer's location?</td>
										<td>0.94</td>
										<td>
											<select class="form-control compliance_score" id="c_fatal4" name="data[contactcustomerusualtime]" disabled>
												<option c_val=0.94 c_val_max="0.94"<?php echo $right_party_v2_data['contactcustomerusualtime'] == "Yes" ? "selected" : ""; ?> value="Yes">Yes</option>
												<option c_val=0 c_val_max="0.94"<?php echo $right_party_v2_data['contactcustomerusualtime'] == "No" ? "selected" : ""; ?> value="No">No</option>
												<option c_val=0.94 c_val_max="0.94"<?php echo $right_party_v2_data['contactcustomerusualtime'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												
											</select>
										</td>
									</tr>
									<tr>
										<td class="eml" colspan=2 style="color:red">Did not Communicate with the consumer at work if it is known or there is reason to know that such calls are prohibited?</td>
										<td>0.94</td>
										<td>
											<select class="form-control compliance_score" id="c_fatal5" name="data[communicateconsumeratwork]" disabled>
												<option c_val=0.94 c_val_max="0.94"<?php echo $right_party_v2_data['communicateconsumeratwork'] == "Yes" ? "selected" : ""; ?> value="Yes">Yes</option>
												<option c_val=0 c_val_max="0.94"<?php echo $right_party_v2_data['communicateconsumeratwork'] == "No" ? "selected" : ""; ?> value="No">No</option>
												<option c_val=0.94 c_val_max="0.94"<?php echo $right_party_v2_data['communicateconsumeratwork'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												
											</select>
										</td>
									</tr>
									<tr>
										<td class="eml" colspan=2 style="color:red">Did not Communicate with the consumer after learning the consumer is represented by an attorney, filed for bankruptcy unless a permissible reason exists?</td>
										<td>0.94</td>
										<td>
											<select class="form-control compliance_score" id="c_fatal6" name="data[communicateconsumeranattorney]" disabled>
												<option c_val=0.94 c_val_max="0.94"<?php echo $right_party_v2_data['communicateconsumeranattorney'] == "Yes" ? "selected" : ""; ?> value="Yes">Yes</option>
												<option c_val=0 c_val_max="0.94"<?php echo $right_party_v2_data['communicateconsumeranattorney'] == "No" ? "selected" : ""; ?> value="No">No</option>
												<option c_val=0.94 c_val_max="0.94"<?php echo $right_party_v2_data['communicateconsumeranattorney'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												
											</select>
										</td>
									</tr>
									<tr>
										<td class="eml" colspan=2 style="color:red">Adhere to the cell phone policy/TCPA regulations and policy regarding contacting consumers via cell phone, email and fax?</td>
										<td>0.94</td>
										<td>
											<select class="form-control compliance_score" id="c_fatal7" name="data[adheretocellphonepolicy]" disabled>
												<option c_val=0.94 c_val_max="0.94"<?php echo $right_party_v2_data['adheretocellphonepolicy'] == "Yes" ? "selected" : ""; ?> value="Yes">Yes</option>
												<option c_val=0 c_val_max="0.94"<?php echo $right_party_v2_data['adheretocellphonepolicy'] == "No" ? "selected" : ""; ?> value="No">No</option>
												<option c_val=0.94 c_val_max="0.94"<?php echo $right_party_v2_data['adheretocellphonepolicy'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												
											</select>
										</td>
									</tr>
									<tr>
										<td class="eml" colspan=2 style="color:red">Adhere to policy regarding third parties for the sole purpose of obtaining location information for the consumer?</td>
										<td>0.94</td>
										<td>
											<select class="form-control compliance_score" id="c_fatal8" name="data[adhereto3rdpartypolicy]" disabled>
												<option c_val=0.94 c_val_max="0.94"<?php echo $right_party_v2_data['adhereto3rdpartypolicy'] == "Yes" ? "selected" : ""; ?> value="Yes">Yes</option>
												<option c_val=0 c_val_max="0.94"<?php echo $right_party_v2_data['adhereto3rdpartypolicy'] == "No" ? "selected" : ""; ?> value="No">No</option>
												<option c_val=0.94 c_val_max="0.94"<?php echo $right_party_v2_data['adhereto3rdpartypolicy'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												
											</select>
										</td>
									</tr>
									<tr>
										<td class="eml" colspan=2 style="color:red">Enter Status code/disposition codes correctly to ensure that inappropriate dialing does not take place?</td>
										<td>0.94</td>
										<td>
											<select class="form-control compliance_score" id="c_fatal9" name="data[enterstatuscodecorrectly]" disabled>
												<option c_val=0.94 c_val_max="0.94"<?php echo $right_party_v2_data['enterstatuscodecorrectly'] == "Yes" ? "selected" : ""; ?> value="Yes">Yes</option>
												<option c_val=0 c_val_max="0.94"<?php echo $right_party_v2_data['enterstatuscodecorrectly'] == "No" ? "selected" : ""; ?> value="No">No</option>
												<option c_val=0.94 c_val_max="0.94"<?php echo $right_party_v2_data['enterstatuscodecorrectly'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>

											</select>
										</td>
									</tr>
									<tr>
										<td class="eml" colspan=2 style="color:red">Did not Make any statement that could constitute unfair, deceptive, or abusive acts or practices that may raise UDAAP concerns?</td>
										<td>0.94</td>
										<td>
											<select class="form-control compliance_score" id="c_fatal10" name="data[raiseUDAAPconcerns]" disabled>
												<option c_val=0.94 c_val_max="0.94"<?php echo $right_party_v2_data['raiseUDAAPconcerns'] == "Yes" ? "selected" : ""; ?> value="Yes">Yes</option>
												<option c_val=0 c_val_max="0.94"<?php echo $right_party_v2_data['raiseUDAAPconcerns'] == "No" ? "selected" : ""; ?> value="No">No</option>
												<option c_val=0.94 c_val_max="0.94"<?php echo $right_party_v2_data['raiseUDAAPconcerns'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												
											</select>
										</td>
									</tr>
									<tr>
										<td class="eml" colspan=2 style="color:red">Did not Communicate or threaten to communicate false credit information or information which should be known to be false and utilized the proper CBR script whenever a consumer enquires about that?</td>
										<td>0.94</td>
										<td>
											<select class="form-control compliance_score" id="c_fatal11" name="data[communicatefalsecreditinformation]" disabled>
												<option c_val=0.94 c_val_max="0.94"<?php echo $right_party_v2_data['communicatefalsecreditinformation'] == "Yes" ? "selected" : ""; ?> value="Yes">Yes</option>
												<option c_val=0 c_val_max="0.94"<?php echo $right_party_v2_data['communicatefalsecreditinformation'] == "No" ? "selected" : ""; ?> value="No">No</option>
												<option c_val=0.94 c_val_max="0.94"<?php echo $right_party_v2_data['communicatefalsecreditinformation'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												
											</select>
										</td>
									</tr>
									<tr>
										<td class="eml" colspan=2 style="color:red">Handle the consumer's dispute correctly and take appropriate action including providing the consumer with the correct contact information to submit a written dispute or complaint, or offer to escalate the call?</td>
										<td>0.94</td>
										<td>
											<select class="form-control compliance_score" id="c_fatal12" name="data[handleconsumerdispute]" disabled>
												<option c_val=0.94 c_val_max="0.94"<?php echo $right_party_v2_data['handleconsumerdispute'] == "Yes" ? "selected" : ""; ?> value="Yes">Yes</option>
												<option c_val=0 c_val_max="0.94"<?php echo $right_party_v2_data['handleconsumerdispute'] == "No" ? "selected" : ""; ?> value="No">No</option>
												<option c_val=0.94 c_val_max="0.94"<?php echo $right_party_v2_data['handleconsumerdispute'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												
											</select>
										</td>
									</tr>
									<tr>
										<td class="eml" colspan=2 style="color:red">Did not Make the disabled statement on time barred accounts, indicating that the consumer cannot be pursued with legal action?</td>
										<td>0.94</td>
										<td>
											<select class="form-control compliance_score" id="c_fatal13" name="data[maketimebarredaccounts]" disabled>
												<option c_val=0.94 c_val_max="0.94"<?php echo $right_party_v2_data['maketimebarredaccounts'] == "Yes" ? "selected" : ""; ?> value="Yes">Yes</option>
												<option c_val=0 c_val_max="0.94"<?php echo $right_party_v2_data['maketimebarredaccounts'] == "No" ? "selected" : ""; ?> value="No">No</option>
												<option c_val=0.94 c_val_max="0.94"<?php echo $right_party_v2_data['maketimebarredaccounts'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												
											</select>
										</td>
									</tr>
									<tr>
										<td class="eml" colspan=2 style="color:red">Adhere to FDCPA  laws?</td>
										<td>0.94</td>
										<td>
											<select class="form-control compliance_score" id="c_fatal14" name="data[adhereFDCPAlaws]" disabled>
												<option c_val=0.94 c_val_max="0.94"<?php echo $right_party_v2_data['adhereFDCPAlaws'] == "Yes" ? "selected" : ""; ?> value="Yes">Yes</option>
												<option c_val=0 c_val_max="0.94"<?php echo $right_party_v2_data['adhereFDCPAlaws'] == "No" ? "selected" : ""; ?> value="No">No</option>
												<option c_val=0.94 c_val_max="0.94"<?php echo $right_party_v2_data['adhereFDCPAlaws'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												
											</select>
										</td>
									</tr>
									<tr>
										<td class="eml" colspan=2 style="color:red">Did not Make any statement that could be considered discriminatory towards a consumer or a violation of VRS ECOA policy?</td>
										<td>0.94</td>
										<td>
											<select class="form-control compliance_score" id="c_fatal15" name="data[discriminatoryECOApolicy]" disabled>
												<option c_val=0.94 c_val_max="0.94"<?php echo $right_party_v2_data['discriminatoryECOApolicy'] == "Yes" ? "selected" : ""; ?> value="Yes">Yes</option>
												<option c_val=0 c_val_max="0.94"<?php echo $right_party_v2_data['discriminatoryECOApolicy'] == "No" ? "selected" : ""; ?> value="No">No</option>
												<option c_val=0.94 c_val_max="0.94"<?php echo $right_party_v2_data['discriminatoryECOApolicy'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												
											</select>
										</td>
									</tr>
									<tr>
										<td class="eml" colspan=2 style="color:red">Did the collectors adhere to the State Restrictions?</td>
										<td>0.94</td>
										<td>
											<select class="form-control compliance_score" id="c_fatal16" name="data[adherestaterestriction]" disabled>
												<option c_val=0.94 c_val_max="0.94"<?php echo $right_party_v2_data['adherestaterestriction'] == "Yes" ? "selected" : ""; ?> value="Yes">Yes</option>
												<option c_val=0 c_val_max="0.94"<?php echo $right_party_v2_data['adherestaterestriction'] == "No" ? "selected" : ""; ?> value="No">No</option>
												<option c_val=0.94 c_val_max="0.94"<?php echo $right_party_v2_data['adherestaterestriction'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												
											</select>
										</td>
									</tr>
									<tr>
										<td rowspan=5 class="eml1">Payment Script</td>
										<td class="eml" colspan=2>Confirm with consumer if he/she is the authorized user of the debit or credit card / checking account? & Recap the call by verifying consumer's Name, Address, CC/AP information?</td>
										<td>1</td>
										<td>
											<select class="form-control pscript_score" id="" name="confirmauthoriseduser" disabled>
												<option ps_val=1 ps_val_max="1"<?php echo $right_party_v2_data['confirmauthoriseduser'] == "Yes" ? "selected" : ""; ?> value="Yes">Yes</option>
												<option ps_val=0 ps_val_max="1"<?php echo $right_party_v2_data['confirmauthoriseduser'] == "No" ? "selected" : ""; ?> value="No">No</option>
												<option ps_val=1 ps_val_max="1"<?php echo $right_party_v2_data['confirmauthoriseduser'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
											
											</select>
										</td>
										<td rowspan=5><input type="text" readonly class="form-control" id="totalPaymentScript" name="data[paymentscriptscore]"></td>
									</tr>
									<tr>
										<td class="eml" colspan=2>Stated the proper payment script before processing payment?</td>
										<td>1</td>
										<td>
											<select class="form-control pscript_score" id="" name="data[properpaymentscript]" disabled>
												<option ps_val=1 ps_val_max="1"<?php echo $right_party_v2_data['properpaymentscript'] == "Yes" ? "selected" : ""; ?> value="Yes">Yes</option>
												<option ps_val=0 ps_val_max="1"<?php echo $right_party_v2_data['properpaymentscript'] == "No" ? "selected" : ""; ?> value="No">No</option>
												<option ps_val=1 ps_val_max="1"<?php echo $right_party_v2_data['properpaymentscript'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												
											</select>
										</td>
									</tr>
									<tr>
										<td class="eml" colspan=2 style="color:red">Obtain permission from the consumer to initiate electronic credit /debit card transactions or through checking account and get supervisor verification if needed?**SQ**</td>
										<td>1</td>
										<td>
											<select class="form-control pscript_score" id="ps_fatal1" name="data[obtainpermissionfromconsumer]" disabled>
												<option ps_val=1 ps_val_max="1"<?php echo $right_party_v2_data['obtainpermissionfromconsumer'] == "Yes" ? "selected" : ""; ?> value="Yes">Yes</option>
												<option ps_val=0 ps_val_max="1"<?php echo $right_party_v2_data['obtainpermissionfromconsumer'] == "No" ? "selected" : ""; ?> value="No">No</option>
												<option ps_val=1 ps_val_max="1"<?php echo $right_party_v2_data['obtainpermissionfromconsumer'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												
											</select>
										</td>
									</tr>
									
									<tr>
										<td class="eml" colspan=2>Did the Collector update Consumer on payment reminder, BIF / SIF Letters?</td>
										<td>1</td>
										<td>
											<select class="form-control pscript_score" id="" name="update_consumer_on_payment" disabled>
												<option ps_val=1 ps_val_max="1"<?php echo $right_party_v2_data['update_consumer_on_payment'] == "Yes" ? "selected" : ""; ?> value="Yes">Yes</option>
												<option ps_val=0 ps_val_max="1"<?php echo $right_party_v2_data['update_consumer_on_payment'] == "No" ? "selected" : ""; ?> value="No">No</option>
												<option ps_val=1 ps_val_max="1"<?php echo $right_party_v2_data['update_consumer_on_payment'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												
											</select>
										</td>
									</tr>
									<tr>
										<td class="eml" colspan=2>In case of PDCs, did the Collector asks for permission to call the Consumer back if it is declined or there is an issue with the payment? / if they do not hear from the Consumers by that specific date and time for PTPs?</td>
										<td>1</td>
										<td>
											<select class="form-control pscript_score" id="" name="data[collector_ask_for_permission]" disabled>
												<option ps_val=1 ps_val_max="1"<?php echo $right_party_v2_data['collector_ask_for_permission'] == "Yes" ? "selected" : ""; ?> value="Yes">Yes</option>
												<option ps_val=0 ps_val_max="1"<?php echo $right_party_v2_data['collector_ask_for_permission'] == "No" ? "selected" : ""; ?> value="No">No</option>
												<option ps_val=1 ps_val_max="1"<?php echo $right_party_v2_data['collector_ask_for_permission'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												
											</select>
										</td>
									</tr>

									<!-- ////////vikas contd.////////// -->
									<tr>
										<td rowspan=4 class="eml1">Call Control</td>
										<td class="eml" colspan=2>Demonstrate Active Listening?</td>
										<td>2.5</td>
										<td>
											<select class="form-control callcontrol_score" id="" name="data[demonstrateactivelistening]" disabled>
												<option cc_val=2.5 cc_val_max="2.5"<?php echo $right_party_v2_data['demonstrateactivelistening'] == "Yes" ? "selected" : ""; ?> value="Yes">Yes</option>
												<option cc_val=0 cc_val_max="2.5"<?php echo $right_party_v2_data['demonstrateactivelistening'] == "No" ? "selected" : ""; ?> value="No">No</option>
												<option cc_val=2.5 cc_val_max="2.5"<?php echo $right_party_v2_data['demonstrateactivelistening'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												
											</select>
										</td>
										<td rowspan=4><input type="text" readonly class="form-control" id="totalCallControl" name="data[callcontrolscore]"></td>
									</tr>
									<tr>
										<td class="eml" colspan=2>Anticipate and overcome objections?</td>
										<td>2.5</td>
										<td>
											<select class="form-control callcontrol_score" id="" name="data[anticipateovercomeobjection]" disabled>
												<option cc_val=2.5 cc_val_max="2.5"<?php echo $right_party_v2_data['anticipateovercomeobjection'] == "Yes" ? "selected" : ""; ?> value="Yes">Yes</option>
												<option cc_val=0 cc_val_max="2.5"<?php echo $right_party_v2_data['anticipateovercomeobjection'] == "No" ? "selected" : ""; ?> value="No">No</option>
												<option cc_val=2.5 cc_val_max="2.5"<?php echo $right_party_v2_data['anticipateovercomeobjection'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												
											</select>
										</td>
									</tr>
									<tr>
										<td class="eml" colspan=2>Did the collector get connected with the consumer by building a rapport?</td>
										<td>2.5</td>
										<td>
											<select class="form-control callcontrol_score" id="" name="data[collector_connect_customer]" disabled>
												<option cc_val=2.5 cc_val_max="2.5"<?php echo $right_party_v2_data['collector_connect_customer'] == "Yes" ? "selected" : ""; ?> value="Yes">Yes</option>
												<option cc_val=0 cc_val_max="2.5"<?php echo $right_party_v2_data['collector_connect_customer'] == "No" ? "selected" : ""; ?> value="No">No</option>
												<option cc_val=2.5 cc_val_max="2.5"<?php echo $right_party_v2_data['collector_connect_customer'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												
											</select>
										</td>
									</tr>
									<tr>
										<td class="eml" colspan=2>Did the collector use system appropriately?
										Examples: Appropriate usage of ERPS/Lariat to provide accurate information / to provide a breakdown of balance (as disabled)</td>
										<td>2.5</td>
										<td>
											<select class="form-control callcontrol_score" id="" name="data[collector_use_system_properly]" disabled>
												<option cc_val=2.5 cc_val_max="2.5"<?php echo $right_party_v2_data['collector_use_system_properly'] == "Yes" ? "selected" : ""; ?> value="Yes">Yes</option>
												<option cc_val=0 cc_val_max="2.5"<?php echo $right_party_v2_data['collector_use_system_properly'] == "No" ? "selected" : ""; ?> value="No">No</option>
												<option cc_val=2.5 cc_val_max="2.5"<?php echo $right_party_v2_data['collector_use_system_properly'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												
											</select>
										</td>
									</tr>
									<tr>
										<td rowspan=3 class="eml1">Soft Skills / Telephone Etiquettes</td>
										<td class="eml" colspan=2>Offer any apologies/empathy statement on RP's unfortunate situation</td>
										<td>1.67</td>
										<td>
											<select class="form-control softskill_score" id="" name="data[offer_apologies]" disabled>
												<option ss_val=1.67 ss_val_max="1.67"<?php echo $right_party_v2_data['offer_apologies'] == "Yes" ? "selected" : ""; ?> value="Yes">Yes</option>
												<option ss_val=0 ss_val_max="1.67"<?php echo $right_party_v2_data['offer_apologies'] == "No" ? "selected" : ""; ?> value="No">No</option>
												<option ss_val=1.67 ss_val_max="1.67"<?php echo $right_party_v2_data['offer_apologies'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												
											</select>
										</td>
										<td rowspan=3><input type="text" readonly class="form-control" id="totalSoftskill" name="data[softskillscore]"></td>
									</tr>
									<tr>
										<td class="eml" colspan=2>Did collector hung up on RP? / Did collector interrupt or talked over RP? / Did collector has disrespectful attitude/tone?</td>
										<td>1.67</td>
										<td>
											<select class="form-control softskill_score" id="" name="data[hungupRP]" disabled>
												<option ss_val=1.67 ss_val_max="1.67"<?php echo $right_party_v2_data['hungupRP'] == "Yes" ? "selected" : ""; ?> value="Yes">Yes</option>
												<option ss_val=0 ss_val_max="1.67"<?php echo $right_party_v2_data['hungupRP'] == "No" ? "selected" : ""; ?> value="No">No</option>
												<option ss_val=1.67 ss_val_max="1.67"<?php echo $right_party_v2_data['hungupRP'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
											</select>
										</td>
									</tr>
									<tr>
										<td class="eml" colspan=2>Was the collector tone pleasant and accommodating? / Was the collector tone came across as confident and sounded knowledable?</td>
										<td>1.67</td>
										<td>
											<select class="form-control softskill_score" id="" name="data[collector_tone_pleasant]" disabled>
												<option ss_val=1.67 ss_val_max="1.67"<?php echo $right_party_v2_data['collector_tone_pleasant'] == "Yes" ? "selected" : ""; ?> value="Yes">Yes</option>
												<option ss_val=0 ss_val_max="1.67"<?php echo $right_party_v2_data['collector_tone_pleasant'] == "No" ? "selected" : ""; ?> value="No">No</option>
												<option ss_val=1.67 ss_val_max="1.67"<?php echo $right_party_v2_data['collector_tone_pleasant'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
											</select>
										</td>
									</tr>
									<tr>
										<td rowspan=4 class="eml1">Closing</td>
										<td class="eml" colspan=2>Summarize the call?</td>
										<td>1.25</td>
										<td>
											<select class="form-control closing_score" id="" name="data[summarizethecall]" disabled>
												<option cl_val=1.25 cl_val_max="1.25"<?php echo $right_party_v2_data['summarizethecall'] == "Yes" ? "selected" : ""; ?> value="Yes">Yes</option>
												<option cl_val=0 cl_val_max="1.25"<?php echo $right_party_v2_data['summarizethecall'] == "No" ? "selected" : ""; ?> value="No">No</option>
												<option cl_val=1.25 cl_val_max="1.25"<?php echo $right_party_v2_data['summarizethecall'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												
											</select>
										</td>
										<td rowspan=4><input type="text" readonly class="form-control" id="totalClosing" name="data[closingscore]"></td>
									</tr>
									<tr>
										<td class="eml" colspan=2>Provided VRS call back number?</td>
										<td>1.25</td>
										<td>
											<select class="form-control closing_score" id="" name="data[provideVRScallbacknumber]" disabled>
												<option cl_val=1.25 cl_val_max="1.25"<?php echo $right_party_v2_data['provideVRScallbacknumber'] == "Yes" ? "selected" : ""; ?> value="Yes">Yes</option>
												<option cl_val=0 cl_val_max="1.25"<?php echo $right_party_v2_data['provideVRScallbacknumber'] == "No" ? "selected" : ""; ?> value="No">No</option>
												<option cl_val=1.25 cl_val_max="1.25"<?php echo $right_party_v2_data['provideVRScallbacknumber'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												
											</select>
										</td>
									</tr>
									<tr>
										<td class="eml" colspan=2>Set appropriate timelines and expectations for follow up?</td>
										<td>1.25</td>
										<td>
											<select class="form-control closing_score" id="" name="data[setappropiatetimeline]" disabled>
												<option cl_val=1.25 cl_val_max="1.25"<?php echo $right_party_v2_data['setappropiatetimeline'] == "Yes" ? "selected" : ""; ?> value="Yes">Yes</option>
												<option cl_val=0 cl_val_max="1.25"<?php echo $right_party_v2_data['setappropiatetimeline'] == "No" ? "selected" : ""; ?> value="No">No</option>
												<option cl_val=1.25 cl_val_max="1.25"<?php echo $right_party_v2_data['setappropiatetimeline'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
											
											</select>
										</td>
									</tr>
									<tr>
										<td class="eml" colspan=2>Close the call Professionally with proper greeting? / Did collector ask if there are any further questions?</td>
										<td>1.25</td>
										<td>
											<select class="form-control closing_score" id="" name="data[closecallprofessionally]" disabled>
												<option cl_val=1.25 cl_val_max="1.25"<?php echo $right_party_v2_data['closecallprofessionally'] == "Yes" ? "selected" : ""; ?> value="Yes">Yes</option>
												<option cl_val=0 cl_val_max="1.25"<?php echo $right_party_v2_data['closecallprofessionally'] == "No" ? "selected" : ""; ?> value="No">No</option>
												<option cl_val=1.25 cl_val_max="1.25"<?php echo $right_party_v2_data['closecallprofessionally'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												
											</select>
										</td>
									</tr>
									<tr>
										<td rowspan=8 class="eml1">Documentation</td>
										<td class="eml" colspan=2>Use the proper action code?</td>
										<td>1.25</td>
										<td>
											<select class="form-control document_score" name="data[useproperactioncode]" disabled>
												<option d_val=1.25 d_val_max="1.25"<?php echo $right_party_v2_data['useproperactioncode'] == "Yes" ? "selected" : ""; ?> value="Yes">Yes</option>
												<option d_val=0 d_val_max="1.25"<?php echo $right_party_v2_data['useproperactioncode'] == "No" ? "selected" : ""; ?> value="No">No</option>
												<option d_val=1.25 d_val_max="1.25"<?php echo $right_party_v2_data['useproperactioncode'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
										
											</select>
										</td>
										<td rowspan=8><input type="text" readonly class="form-control" id="totalDocument" name="data[documentationscore]"></td>
									</tr>
									<tr>
										<td class="eml" colspan=2 style="color:red">Use the proper result code?</td>
										<td>1.25</td>
										<td>
											<select class="form-control document_score" id="d_fatal1" name="data[useproperresultcode]" disabled>
												<option d_val=1.25 d_val_max="1.25"<?php echo $right_party_v2_data['useproperresultcode'] == "Yes" ? "selected" : ""; ?> value="Yes">Yes</option>
												<option d_val=0 d_val_max="1.25"<?php echo $right_party_v2_data['useproperresultcode'] == "No" ? "selected" : ""; ?> value="No">No</option>
												<option d_val=1.25 d_val_max="1.25"<?php echo $right_party_v2_data['useproperresultcode'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												
											</select>
										</td>
									</tr>
									<tr>
										<td class="eml" colspan=2 style="color:red">Document thoroughly the context of the conversation?</td>
										<td>1.25</td>
										<td>
											<select class="form-control document_score" id="d_fatal2" name="data[contextoftheconversation]" disabled>
												<option d_val=1.25 d_val_max="1.25"<?php echo $right_party_v2_data['contextoftheconversation'] == "Yes" ? "selected" : ""; ?> value="Yes">Yes</option>
												<option d_val=0 d_val_max="1.25"<?php echo $right_party_v2_data['contextoftheconversation'] == "No" ? "selected" : ""; ?> value="No">No</option>
												<option d_val=1.25 d_val_max="1.25"<?php echo $right_party_v2_data['contextoftheconversation'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												
											</select>
										</td>
									</tr>
									<tr>
										<td class="eml" colspan=2>Did the rep document the callback permission on the account as per Reg F policy?</td>
										<td>1.25</td>
										<td>
											<select class="form-control document_score" name="data[document_the_callback]" disabled>
												<option d_val=1.25 d_val_max="1.25"<?php echo $right_party_v2_data['document_the_callback'] == "Yes" ? "selected" : ""; ?> value="Yes">Yes</option>
												<option d_val=0 d_val_max="1.25"<?php echo $right_party_v2_data['document_the_callback'] == "No" ? "selected" : ""; ?> value="No">No</option>
												<option d_val=1.25 d_val_max="1.25"<?php echo $right_party_v2_data['document_the_callback'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
											
											</select>
										</td>
									</tr>
									<tr>
										<td class="eml" colspan=2 style="color:red">Remove any phone numbers known to be incorrect?**SQ**</td>
										<td>1.25</td>
										<td>
											<select class="form-control document_score" id="d_fatal3" name="data[removeanyphonenumber]" disabled>
												<option d_val=1.25 d_val_max="1.25"<?php echo $right_party_v2_data['removeanyphonenumber'] == "Yes" ? "selected" : ""; ?> value="Yes">Yes</option>
												<option d_val=0 d_val_max="1.25"<?php echo $right_party_v2_data['removeanyphonenumber'] == "No" ? "selected" : ""; ?> value="No">No</option>
												<option d_val=1.25 d_val_max="1.25"<?php echo $right_party_v2_data['removeanyphonenumber'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												
											</select>
										</td>
									</tr>
									<tr>
										<td class="eml" colspan=2 style="color:red">Update address information if appropriate?**SQ**</td>
										<td>1.25</td>
										<td>
											<select class="form-control document_score" id="d_fatal4" name="data[updateaddressinformation]" disabled>
												<option d_val=1.25 d_val_max="1.25"<?php echo $right_party_v2_data['updateaddressinformation'] == "Yes" ? "selected" : ""; ?> value="Yes">Yes</option>
												<option d_val=0 d_val_max="1.25"<?php echo $right_party_v2_data['updateaddressinformation'] == "No" ? "selected" : ""; ?> value="No">No</option>
												<option d_val=1.25 d_val_max="1.25"<?php echo $right_party_v2_data['updateaddressinformation'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
											
											</select>
										</td>
									</tr>
									<tr>
										<td class="eml" colspan=2 style="color:red">Change the status of the account, if appropriate?**SQ**</td>
										<td>1.25</td>
										<td>
											<select class="form-control document_score" id="d_fatal5" name="data[changestateofAccount]" disabled>
												<option d_val=1.25 d_val_max="1.25"<?php echo $right_party_v2_data['changestateofAccount'] == "Yes" ? "selected" : ""; ?> value="Yes">Yes</option>
												<option d_val=0 d_val_max="1.25"<?php echo $right_party_v2_data['changestateofAccount'] == "No" ? "selected" : ""; ?> value="No">No</option>
												<option d_val=1.25 d_val_max="1.25"<?php echo $right_party_v2_data['changestateofAccount'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
											</select>
										</td>
									</tr>
									<tr>
										<td class="eml" colspan=2>Escalate the account to a supervisor for handling, if appropriate?</td>
										<td>1.25</td>
										<td>
											<select class="form-control document_score" id="" name="data[superviserforhandle]" disabled>
												<option d_val=1.25 d_val_max="1.25"<?php echo $right_party_v2_data['superviserforhandle'] == "Yes" ? "selected" : ""; ?> value="Yes">Yes</option>
												<option d_val=0 d_val_max="1.25"<?php echo $right_party_v2_data['superviserforhandle'] == "No" ? "selected" : ""; ?> value="No">No</option>
												<option d_val=1.25 d_val_max="1.25"<?php echo $right_party_v2_data['superviserforhandle'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
											</select>
										</td>
									</tr>
									<tr>
										<td colspan=2>Call Summary:</td>
										<td colspan=4><textarea class="form-control" disabled name="data[call_summary]"><?php echo $right_party_v2_data['call_summary'] ?></textarea></td>
									</tr>
									<tr>
										<td colspan=2>Feedback:</td>
										<td colspan=4><textarea class="form-control" disabled name="data[feedback]"><?php echo $right_party_v2_data['feedback'] ?></textarea></td>
									</tr>
								
									<?php if($right_party_v2_data['attach_file']!=''){ ?>
									<tr oncontextmenu="return false;">
										<td colspan="2">Audio Files (Mp4/Mp3/M4a/Wav)</td>
										<td colspan="4">
											<?php $attach_file = explode(",",$right_party_v2_data['attach_file']);
											 foreach($attach_file as $af){ ?>
												<audio oncontextmenu="return false;" controls controlslist="nodownload" style="background-color:#607F93">
													  <source src="<?php echo base_url(); ?>qa_files/qa_rp_vrs_v2/<?php echo $af; ?>" type="audio/ogg">
													  <source src="<?php echo base_url(); ?>qa_files/qa_rp_vrs_v2/<?php echo $af; ?>" type="audio/mpeg">
												</audio> </br>
											 <?php } ?>
										</td>
									</tr>
									<?php } ?>

									<tr>
										<td style="font-size:12px">Manager Review:</td>
										<td colspan="8" style="text-align:left"><?php echo $right_party_v2_data['mgnt_rvw_note'] ?></td>
									</tr>
									<tr>
										<td style="font-size:12px">Client Review:</td>
										<td colspan="8" style="text-align:left"><?php echo $right_party_v2_data['client_rvw_note'] ?></td>
									</tr>

									<tr><td colspan="10" style="background-color:#C5C8C8"></td></tr>
									
									 <form id="form_agent_user" method="POST" action="">
										<input type="hidden" name="right_party_v2_id" class="form-control" value="<?php echo $right_party_v2_id; ?>">
										
										<tr>
											<td colspan=2 style="font-size:16px">Feedback Acceptance<span style="font-size:24px;color:red">*</span></td>
											<td colspan=6>
												<select class="form-control" id="" name="agnt_fd_acpt" required="">
													<option value="">--Select--</option>
													<option <?php echo $right_party_v2_data['agnt_fd_acpt']=='Acceptance'?"selected":""; ?> value="Acceptance">Acceptance</option>	
													<option <?php echo $right_party_v2_data['agnt_fd_acpt']=='Not Acceptance'?"selected":""; ?> value="Not Acceptance">Not Acceptance</option>	
												</select>
											</td>
										</tr>
										<tr>
											<td colspan=2 style="font-size:16px">Your Review<span style="font-size:24px;color:red">*</span></td>
											<td colspan=6><textarea class="form-control" name="note" required><?php echo $right_party_v2_data['agent_rvw_note'] ?></textarea></td>
										</tr>
										
										<?php if(is_access_qa_agent_module()==true){
										if(is_available_qa_feedback($right_party_v2_data['entry_date'],72) == true){ ?>
											<tr>
												<?php if($right_party_v2_data['agent_rvw_note']==''){ ?>
													<td colspan="8"><button class="btn btn-success waves-effect" type="submit" id='btnagentSave' name='btnSave' value="SAVE" style="width:500px;margin:auto;display:block;">SAVE</button></td>
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
