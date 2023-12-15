<style>
	.table>tbody>tr>td {
		text-align: center;
		font-size: 13px;
	}

	#theader {
		font-size: 20px;
		font-weight: bold;
		background-color: #95A5A6;
	}

	.eml {
		background-color: #85C1E9;
	}
	.eml1{
		font-size:20px;
		font-weight:bold;
		background-color:#CCD1D1;
	}
	.fatal .eml{
		background-color: red;
		color:white;
	}

	.ui-datepicker .ui-datepicker-buttonpane button.ui-datepicker-current {
	 float: left;
	 display: none;
	}
</style>
<?php // .ui-datepicker .ui-datepicker-buttonpane button.ui-datepicker-current {
	 //float: left;
	// display: none;
	//used for call_duration to disable now button.
	//} ?>


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
											<td colspan="8" id="theader" style="font-size:40px; text-align:center!important; ">FC ESCALATION AGENT FORM</td>
											<input type="hidden" name="audit_start_time" value="<?php echo CurrMySqlDate(); ?>">
										</tr>
										<?php
											$rand_id = 0;
											if ($fc_escalation_data['entry_by'] != '') {
												$auditorName = $fc_escalation_data['auditor_name'];
											} else {
												$auditorName = $fc_escalation_data['client_name'];
											}
										
											$auditDate = mysql2mmddyy($fc_escalation_data['audit_date']);
										 
											$clDate_val = mysql2mmddyy($fc_escalation_data['call_date']);
										

										if ($rand_id != 0) {
											$agent_id = $rand_data['sid'];
											$fusion_id = $rand_data['fusion_id'];
											$agent_name = $rand_data['fname'] . " " . $rand_data['lname'];
											$tl_id = $rand_data['assigned_to'];
											$tl_name = $rand_data['tl_name'];
											$call_duration = $rand_data['call_duration'];
											
										} else {
											$agent_id = $fc_escalation_data['agent_id'];
											$fusion_id = $fc_escalation_data['fusion_id'];
											$agent_name = $fc_escalation_data['fname'] . " " . $fc_escalation_data['lname'] ;
											$tl_id = $fc_escalation_data['tl_id'];
											$tl_name = $fc_escalation_data['tl_name'];
											$call_duration = $fc_escalation_data['call_duration'];
										}
										?>
										<tr>
											<td>Auditor Name: <span style="font-size:24px;color:red">*</span></td>
											<td><input type="text" class="form-control" value="<?= $auditorName; ?>" disabled></td>
											<td>Audit Date:<span style="font-size:24px;color:red">*</span></td>
											<td><input type="text" class="form-control" value="<?= $auditDate; ?>" disabled></td>
											<td>Call Date:<span style="font-size:24px;color:red">*</span></td>
											<td>
												<input type="text" id="call_date" name="call_date"  onkeydown="return false;" value="<?php echo $clDate_val; ?>" max="<?php echo date("Y-m-d"); ?>" class="form-control" disabled>
											</td>
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
											<td>Fusion ID:<span style="font-size:24px;color:red">*</span></td>
											<td><input type="text" class="form-control" id="fusion_id" required value="<?php echo $fusion_id; ?>" readonly></td>
											<td> L1 Supervisor:<span style="font-size:24px;color:red">*</span></td>
											<td>
												<input type="text" class="form-control" id="tl_name"  value="<?php echo $tl_name; ?>" readonly>
												<input type="hidden" class="form-control" id="tl_id" name="data[tl_id]" value="<?php echo $tl_id; ?>" disabled>
											</td>
										</tr>
										<tr>
											<td>ACPT:<span style="font-size:24px;color:red">*</span></td>
											<td>
												<select class="form-control" id="" name="data[acpt]" disabled>
											
											    <option value="">-Select-</option>
											    <option value="Agent" <?= ($fc_escalation_data['acpt']=="Agent")?"selected":"" ?>>Agent</option>
												<option value="Customer" <?= ($fc_escalation_data['acpt']=="Customer")?"selected":"" ?>>Customer</option>
												<option value="Process" <?= ($fc_escalation_data['acpt']=="Process")?"selected":"" ?>>Process</option>
												<option value="Technology" <?= ($fc_escalation_data['acpt']=="Technology")?"selected":"" ?>>Technology</option>
												<option value="NA" <?= ($fc_escalation_data['acpt']=="NA")?"selected":"" ?>>NA</option>
												
											
										</select>
											</td>
											<td>Skill:<span style="font-size:24px;color:red">*</span></td>
											<td>
												<select class="form-control" id="" name="data[skill]" disabled>
													
													<option value="">-Select-</option>
													<option value="GI"  <?= ($fc_escalation_data['skill']=="GI")?"selected":"" ?>>GI</option>
													<option value="EZpay"  <?= ($fc_escalation_data['skill']=="EZpay")?"selected":"" ?>>EZpay</option>
													<option value="DCO"  <?= ($fc_escalation_data['skill']=="DCO")?"selected":"" ?>>DCO</option>
													<option value="VAC"  <?= ($fc_escalation_data['skill']=="VAC")?"selected":"" ?>>VAC</option>
													<option value="EDU"  <?= ($fc_escalation_data['skill']=="EDU")?"selected":"" ?>>EDU</option>
												</select>
											</td>

											<td>File/Call ID:<span style="font-size:24px;color:red">*</span></td>
											<td>
												<input type="text" class="form-control" name="data[call_id]" value="<?php echo $fc_escalation_data['call_id'] ?>" disabled>
											</td>
										</tr>
										
										<tr>
											<td>Call Duration:<span style="font-size:24px;color:red">*</span></td>
											<td><input type="text" class="form-control" onkeydown="return false;" id="call_duration" name="data[call_duration]" value="<?php echo $call_duration; ?>" disabled></td>

											<td>Reason of the Call:<span style="font-size:24px;color:red">*</span></td>
											<td>
												<select class="form-control" id="" name="data[reason_for_call]" disabled>
													
													<option value="">-Select-</option>
													<option value="Inbound"  <?= ($fc_escalation_data['reason_for_call']=="Inbound")?"selected":"" ?>>Inbound</option>
													<option value="Outbound"  <?= ($fc_escalation_data['reason_for_call']=="Outbound")?"selected":"" ?>>Outbound</option>
												</select>
											</td>
											<td>VOC:<span style="font-size:24px;color:red">*</span></td>
											<td>
												<select class="form-control" id="voc" name="data[voc]" disabled>
													
													<option value="">-Select-</option>
													<option value="1"  <?= ($fc_escalation_data['voc']=="1")?"selected":"" ?>>1</option>
													<option value="2"  <?= ($fc_escalation_data['voc']=="2")?"selected":"" ?>>2</option>
													<option value="3"  <?= ($fc_escalation_data['voc']=="3")?"selected":"" ?>>3</option>
													<option value="4"  <?= ($fc_escalation_data['voc']=="4")?"selected":"" ?>>4</option>
													<option value="5"  <?= ($fc_escalation_data['voc']=="5")?"selected":"" ?>>5</option>
													<option value="6"  <?= ($fc_escalation_data['voc']=="6")?"selected":"" ?>>6</option>
													<option value="7"  <?= ($fc_escalation_data['voc']=="7")?"selected":"" ?>>7</option>
													<option value="8"  <?= ($fc_escalation_data['voc']=="8")?"selected":"" ?>>8</option>
													<option value="9"  <?= ($fc_escalation_data['voc']=="9")?"selected":"" ?>>9</option>
													<option value="10"  <?= ($fc_escalation_data['voc']=="10")?"selected":"" ?>>10</option>
												</select>
											</td>
										</tr>
										<tr>
											<td>Site:<span style="font-size:24px;color:red">*</span></td>
											<td>
												<input type="text" class="form-control" id="site" name="data[site]" value="<?php echo $fc_escalation_data['site'] ?>" readonly>
											</td>
											<td>Evaluation Link:<span style="font-size:24px;color:red">*</span></td>
											<td>
												<input type="text" class="form-control" id="" name="data[evaluation_link]" value="<?php echo $fc_escalation_data['evaluation_link'] ?>" disabled>
											</td>

											<td>Disposition:<span style="font-size:24px;color:red">*</span>
											</td>
											<td>
												<select class="form-control" id="" name="data[disposition]" disabled>
                                                    <option value="">-Select-</option>
                                                    <option value="C-CSR called the wrong line" <?= ($fc_escalation_data['disposition']=="C-CSR called the wrong line")?"selected":"" ?>>C-CSR called the wrong line</option>
                                                    <option value="FC-Escalation- Auth Hold" <?= ($fc_escalation_data['disposition']=="FC-Escalation- Auth Hold")?"selected":"" ?>>FC-Escalation- Auth Hold</option>
                                                    <option value="FC-Escalation- expired promotion" <?= ($fc_escalation_data['disposition']=="FC-Escalation- expired promotion")?"selected":"" ?>>FC-Escalation- expired promotion</option>
                                                    <option value="FC-Escalation- EZpay" <?= ($fc_escalation_data['disposition']=="FC-Escalation- EZpay")?"selected":"" ?>>FC-Escalation- EZpay</option>
                                                    <option value="FC-Escalation- guest hung up" <?= ($fc_escalation_data['disposition']=="FC-Escalation- guest hung up")?"selected":"" ?>>FC-Escalation- guest hung up</option>
                                                    <option value="FC-Escalation- other" <?= ($fc_escalation_data['disposition']=="FC-Escalation- other")?"selected":"" ?>>FC-Escalation- other</option>
                                                    <option value="FC-Escalation- unnecessary" <?= ($fc_escalation_data['disposition']=="FC-Escalation- unnecessary")?"selected":"" ?>>FC-Escalation- unnecessary</option>
                                                    <option value="FC-Escalation- vacations" <?= ($fc_escalation_data['disposition']=="FC-Escalation- vacations")?"selected":"" ?>>FC-Escalation- vacations</option>
                                                    <option value="FC-Escalation- website" <?= ($fc_escalation_data['disposition']=="FC-Escalation- website")?"selected":"" ?>>FC-Escalation- website</option>
                                                    <option value="FC-General Question - necessary" <?= ($fc_escalation_data['disposition']=="FC-General Question - necessary")?"selected":"" ?>>FC-General Question - necessary</option>
                                                    <option value="FC-General Question - unnecessary" <?= ($fc_escalation_data['disposition']=="FC-General Question - unnecessary")?"selected":"" ?>>FC-General Question - unnecessary</option>
                                                    <option value="FC-Override - EZpay settle" <?= ($fc_escalation_data['disposition']=="FC-Override - EZpay settle")?"selected":"" ?>>FC-Override - EZpay settle</option>
                                                    <option value="FC-Override - general" <?= ($fc_escalation_data['disposition']=="FC-Override - general")?"selected":"" ?>>FC-Override - general</option>
                                                    <option value="FC-Override - MPR/Freedom Pay" <?= ($fc_escalation_data['disposition']=="FC-Override - MPR/Freedom Pay")?"selected":"" ?>>FC-Override - MPR/Freedom Pay</option>
                                                    <option value="FC-Override - other" <?= ($fc_escalation_data['disposition']=="FC-Override - other")?"selected":"" ?>>FC-Override - other</option>
                                                    <option value="FC-Override - park call" <?= ($fc_escalation_data['disposition']=="FC-Override - park call")?"selected":"" ?>>FC-Override - park call</option>
                                                    <option value="FC-Override - vacations" <?= ($fc_escalation_data['disposition']=="FC-Override - vacations")?"selected":"" ?>>FC-Override - vacations</option>
                                                    <option value="FC-Woohoo" <?= ($fc_escalation_data['disposition']=="FC-Woohoo")?"selected":"" ?>>FC-Woohoo</option>
                                                </select>
											</td>
											</tr>
											<tr>
												<td>Audit Type:<span style="font-size:24px;color:red">*</span>
											</td>
											<td>
												<select class="form-control" id="audit_type" name="data[audit_type]" disabled>
                                                    <option value="">-Select-</option>
                                                    <option value="CQ Audit" <?= ($fc_escalation_data['audit_type']=="CQ Audit")?"selected":"" ?>>CQ Audit</option>
                                                    <option value="BQ Audit" <?= ($fc_escalation_data['audit_type']=="BQ Audit")?"selected":"" ?>>BQ Audit</option>
                                                    <option value="Calibration" <?= ($fc_escalation_data['audit_type']=="Calibration")?"selected":"" ?>>Calibration</option>
                                                    <option value="Pre-Certificate Mock Call" <?= ($fc_escalation_data['audit_type']=="Pre-Certificate Mock Call")?"selected":"" ?>>Pre-Certificate Mock Call</option>
                                                    <option value="Certification Audit" <?= ($fc_escalation_data['audit_type']=="Certification Audit")?"selected":"" ?>>Certification Audit</option>
                                                    <option value="WoW Call"  <?= ($fc_escalation_data['audit_type']=="WoW Call")?"selected":"" ?>>WoW Call</option>
                                                    <option value="Hygiene Audit"  <?= ($fc_escalation_data['audit_type']=="Hygiene Audit")?"selected":"" ?>>Hygiene Audit</option>
                                                    <option value="Operation Audit"  <?= ($fc_escalation_data['audit_type']=="Operation Audit")?"selected":"" ?>>Operation Audit</option>
                                                    <option value="Trainer Audit"  <?= ($fc_escalation_data['audit_type']=="Trainer Audit")?"selected":"" ?>>Trainer Audit</option> 
                                                    <option value="QA Supervisor Audit"  <?= ($fc_escalation_data['audit_type']=="QA Supervisor Audit")?"selected":"" ?>>QA Supervisor Audit</option> 
                                                </select>
											</td>
											<td class="auType_epi">Auditor Type<span style="font-size:24px;color:red">*</span></td>
											<td class="auType_epi">
												<select class="form-control" id="auditor_type" name="data[auditor_type]">
                                                    <option value="">Select</option>
                                                    <option value="Master" <?= ($fc_escalation_data['auditor_type']=="Master")?"selected":"" ?>>Master</option>
                                                    <option value="Regular" <?= ($fc_escalation_data['auditor_type']=="Regular")?"selected":"" ?>>Regular</option>
                                                </select>
											</td>
										</tr>
										<tr>
											<td style="font-weight:bold; font-size:16px; text-align:left">Earned Score</td>
											<td><input type="text" readonly id="fc_escalation_earned_score" name="data[earned_score]" class="form-control" value="<?php echo $fc_escalation_data['earned_score'] ?>" /></td>
											<td style="font-weight:bold; font-size:16px; text-align:left">Possible Score</td>
											<td><input type="text" readonly id="fc_escalation_possible_score" name="data[possible_score]" class="form-control" value="<?php echo $fc_escalation_data['possible_score'] ?>" /></td>
											<td style="font-weight:bold; font-size:16px; text-align:right">Overall Score:</td>
											<td><input type="text" class="form-control fc_escalationFatal" readonly id="fc_escalation_overall_score" name="data[overall_score]"  style="font-weight:bold" value="<?php echo $fc_escalation_data['overall_score'] ?>"></td>
										</tr>
										<tr class="eml" style="height:25px; font-weight:bold">
											<td>SECTION</td>
											<td>PARAMETER</td>
											<td>GUIDELINE</td>
											<td>WEIGHT(%)</td>
											<td>STATUS</td>
											<td>REMARKS</td>
										</tr>

										<tr>
											<td class="eml" rowspan="8">GUEST INTERACTION</td>
											<td>1 - Did the Floor Coach provide accurate and up-to-date information?</td>
											<td>	
											Did the floor coach provide<br>accurate information of product,<br>parks,and anything pertaining to Seaworld entertainment.		
											</td>
											
											<td>20</td>
											<td>
												<select class="form-control fc_escalation_point" id ="" name="data[accurate_information]" disabled>
													<option fc_escalation_val=20 fc_escalation_max="20"<?php echo $fc_escalation_data['accurate_information'] == "Yes" ? "selected" : ""; ?> value="Yes">Yes</option>
													<option fc_escalation_val=0 fc_escalation_max="20" <?php echo $fc_escalation_data['accurate_information'] == "No" ? "selected" : ""; ?> value="No">No</option>
												</select>
											</td>
											<td><input type="text" disabled name="data[cmt1]" class="form-control" value="<?php echo $fc_escalation_data['cmt1'] ?>"></td>
										</tr>
										<tr>
											<td>2 - Active Listening</td>
											<td>
											Floor Coach  should capture all<br>the guest's concerns or grevences,<br>they should not interrup guest<br>if they are talking without<br>following with an apology.<br>Floor coach responds to guest's<br>statements and does not cause guest to repeat themselves. 	
											</td>
											
											<td>10</td>
											<td>
												<select class="form-control fc_escalation_point" id ="" name="data[active_listening]" disabled>
													<option fc_escalation_val=10 fc_escalation_max="10"<?php echo $fc_escalation_data['active_listening'] == "Yes" ? "selected" : ""; ?> value="Yes">Yes</option>
													<option fc_escalation_val=0 fc_escalation_max="10" <?php echo $fc_escalation_data['active_listening'] == "No" ? "selected" : ""; ?> value="No">No</option>
												</select>
											</td>
											<td><input type="text" disabled name="data[cmt2]" class="form-control" value="<?php echo $fc_escalation_data['cmt2'] ?>"></td>
										</tr>
										<tr>
											<td>3 - Floor Coach's verbatim, tone, and content</td>
											<td>
											Floor Coach comes across welcoming<br> and easy to understand,<br>utilizing proper inflection throughout call.	
											</td>
											
											<td>10</td>
											<td>
												<select class="form-control fc_escalation_point" id ="" name="data[verbatim_tone]" disabled>
													<option fc_escalation_val=10 fc_escalation_max="10"<?php echo $fc_escalation_data['verbatim_tone'] == "Yes" ? "selected" : ""; ?> value="Yes">Yes</option>
													<option fc_escalation_val=0 fc_escalation_max="10" <?php echo $fc_escalation_data['verbatim_tone'] == "No" ? "selected" : ""; ?> value="No">No</option>
												</select>
											</td>
											<td><input type="text" disabled name="data[cmt3]" class="form-control" value="<?php echo $fc_escalation_data['cmt3'] ?>"></td>
										</tr>
										<tr>
											<td>4 - Finding the solution</td>
											<td>
											The FC needs to  be doing <br>discovery when needed, and <br>offering solution based concerns discussed with the guest	
											</td>
											<td>10</td>
											<td>
												<select class="form-control fc_escalation_point" id ="" name="data[finding_solution]" disabled>
													<option fc_escalation_val=10 fc_escalation_max="10"<?php echo $fc_escalation_data['finding_solution'] == "Yes" ? "selected" : ""; ?> value="Yes">Yes</option>
													<option fc_escalation_val=0 fc_escalation_max="10" <?php echo $fc_escalation_data['finding_solution'] == "No" ? "selected" : ""; ?> value="No">No</option>
												</select>
											</td>
											<td><input type="text" disabled name="data[cmt4]" class="form-control" value="<?php echo $fc_escalation_data['cmt4'] ?>"></td>
										</tr>
										<tr>
											<td>5 - Owns the call</td>
											<td>
											Floor Coach resolved the reason <br>of the call with confidence,<br> without blaming another ambassador , park or department.	
											</td>
											<td>20</td>
											<td>
												<select class="form-control fc_escalation_point" id ="" name="data[owns_call]" disabled>
													<option fc_escalation_val=20 fc_escalation_max="20"<?php echo $fc_escalation_data['owns_call'] == "Yes" ? "selected" : ""; ?> value="Yes">Yes</option>
													<option fc_escalation_val=0 fc_escalation_max="20" <?php echo $fc_escalation_data['owns_call'] == "No" ? "selected" : ""; ?> value="No">No</option>
												</select>
											</td>
											<td><input type="text" disabled name="data[cmt5]" class="form-control" value="<?php echo $fc_escalation_data['cmt5'] ?>"></td>
										</tr>
										<tr>
											<td>6 - Empathetic</td>
											<td>
											Floor coach should be empathic ,<br> apologetic  and polite based on<br> the reason for the escalation<br> but also be able to adapt<br> based on the guest's needs<br> such as show excitement but all expressions should come across as sincere.	
											</td>
											<td>10</td>
											<td>
												<select class="form-control fc_escalation_point" id ="" name="data[empathetic]" disabled>
													<option fc_escalation_val=10 fc_escalation_max="10"<?php echo $fc_escalation_data['empathetic'] == "Yes" ? "selected" : ""; ?> value="Yes">Yes</option>
													<option fc_escalation_val=0 fc_escalation_max="10" <?php echo $fc_escalation_data['empathetic'] == "No" ? "selected" : ""; ?> value="No">No</option>
												</select>
											</td>
											<td><input type="text" disabled name="data[cmt6]" class="form-control" value="<?php echo $fc_escalation_data['cmt6'] ?>"></td>
										</tr>
										<tr>
											<td>7 - Efficiency on the call</td>
											<td>
											Floor coach focues the conversation<br> with guest on the reason<br> for escalation and on building<br>  repport with guest. Floor coach<br>does not place guest on unnessary hold  or allow for dead air .	
											</td>
											<td>10</td>
											<td>
												<select class="form-control fc_escalation_point" id ="" name="data[efficiency_of_call]" disabled>
													<option fc_escalation_val=10 fc_escalation_max="10"<?php echo $fc_escalation_data['efficiency_of_call'] == "Yes" ? "selected" : ""; ?> value="Yes">Yes</option>
													<option fc_escalation_val=0 fc_escalation_max="10" <?php echo $fc_escalation_data['efficiency_of_call'] == "No" ? "selected" : ""; ?> value="No">No</option>
												</select>
											</td>
											<td><input type="text" disabled name="data[cmt7]" class="form-control" value="<?php echo $fc_escalation_data['cmt7'] ?>"></td>
										</tr>
										<tr>
											<td>8 - Proper Opening/Closing</td>
											<td>
											Floor Coach follows proper opening<br> by stating name, tagging the<br> park and closes the call<br> by offering further assistance,tagging<br> the park and mentioning the survey	
											</td>
											<td>10</td>
											<td>
												<select class="form-control fc_escalation_point" id ="" name="data[proper_opening_closing]" disabled>
													<option fc_escalation_val=10 fc_escalation_max="10"<?php echo $fc_escalation_data['proper_opening_closing'] == "Yes" ? "selected" : ""; ?> value="Yes">Yes</option>
													<option fc_escalation_val=0 fc_escalation_max="10" <?php echo $fc_escalation_data['proper_opening_closing'] == "No" ? "selected" : ""; ?> value="No">No</option>
												</select>
											</td>
											<td><input type="text" disabled name="data[cmt8]" class="form-control" value="<?php echo $fc_escalation_data['cmt8'] ?>"></td>
										</tr>
										<tr>
											<td class="eml1" style="color: red;" rowspan="4">COMPLIANCE ITEMS</td>
											<td style="color: red;">9 - Explains EZpay Contract / Cancelation Policy</td>
											<td>
											</td>
											<td></td>
											<td>
												<select class="form-control fc_escalation_point" id ="fc_fatal1" name="data[cancelation_policy]" disabled>
													<option fc_escalation_val=0 fc_escalation_max="0"<?php echo $fc_escalation_data['cancelation_policy'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option fc_escalation_val=0 fc_escalation_max="0" <?php echo $fc_escalation_data['cancelation_policy'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
												</select>
											</td>
											<td><input type="text" disabled name="data[cmt9]" class="form-control" value="<?php echo $fc_escalation_data['cmt9'] ?>"></td>
										</tr>
										<tr>
											<td style="color: red;">10 - Leaves notes in all accounts/orders</td>
											<td>
											</td>
											<td></td>
											<td>
												<select class="form-control fc_escalation_point" id ="fc_fatal2" name="data[leaves_notes]" disabled>
													<option fc_escalation_val=0 fc_escalation_max="0"<?php echo $fc_escalation_data['leaves_notes'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option fc_escalation_val=0 fc_escalation_max="0" <?php echo $fc_escalation_data['leaves_notes'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
												</select>
											</td>
											<td><input type="text" disabled name="data[cmt10]" class="form-control" value="<?php echo $fc_escalation_data['cmt10'] ?>"></td>
										</tr>
										<tr>
											<td style="color: red;">11 - Qualifies the park by city/state</td>
											<td>
											</td>
											<td></td>
											<td>
												<select class="form-control fc_escalation_point" id ="fc_fatal3" name="data[qualifies_park]" disabled>
													<option fc_escalation_val=0 fc_escalation_max="0"<?php echo $fc_escalation_data['qualifies_park'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option fc_escalation_val=0 fc_escalation_max="0" <?php echo $fc_escalation_data['qualifies_park'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
												</select>
											</td>
											<td><input type="text" disabled name="data[cmt11]" class="form-control" value="<?php echo $fc_escalation_data['cmt11'] ?>"></td>
										</tr>
										<tr>
											<td style="color: red;">12 - Customer focused at all times (Not offensive/rude)</td>
											<td>
											</td>
											<td></td>
											<td>
												<select class="form-control fc_escalation_point" id ="fc_fatal4" name="data[offensive_rude]" disabled>
													<option fc_escalation_val=0 fc_escalation_max="0"<?php echo $fc_escalation_data['offensive_rude'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option fc_escalation_val=0 fc_escalation_max="0" <?php echo $fc_escalation_data['offensive_rude'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
												</select>
											</td>
											<td><input type="text" disabled name="data[cmt12]" class="form-control" value="<?php echo $fc_escalation_data['cmt12'] ?>"></td>
										</tr>

										<tr>
											<td>Call Summary:</td>
											<td colspan=3><textarea class="form-control" disabled name="data[call_summary]"><?php echo $fc_escalation_data['call_summary'] ?></textarea></td>
											<td>Feedback:</td>
											<td colspan=4><textarea class="form-control" disabled name="data[feedback]"><?php echo $fc_escalation_data['feedback'] ?></textarea></td>
										</tr>

										<?php if($fc_escalation_data['attach_file']!=''){ ?>
									<tr oncontextmenu="return false;">
										<td colspan="2">Audio Files (Mp4/Mp3/M4a/Wav)</td>
										<td colspan="4">
											<?php $attach_file = explode(",",$fc_escalation_data['attach_file']);
											 foreach($attach_file as $af){ ?>
												<audio oncontextmenu="return false;" controls controlslist="nodownload" style="background-color:#607F93">
													  <source src="<?php echo base_url(); ?>qa_files/sea_world/fc_escalation/<?php echo $af; ?>" type="audio/ogg">
													  <source src="<?php echo base_url(); ?>qa_files/sea_world/fc_escalation/<?php echo $af; ?>" type="audio/mpeg">
												</audio> </br>
											 <?php } ?>
										</td>
									</tr>
									<?php } ?>

									<tr>
										<td style="font-size:12px">Manager Review:</td>
										<td colspan="8" style="text-align:left"><?php echo $fc_escalation_data['mgnt_rvw_note'] ?></td>
									</tr>
									<tr>
										<td style="font-size:12px">Client Review:</td>
										<td colspan="8" style="text-align:left"><?php echo $fc_escalation_data['client_rvw_note'] ?></td>
									</tr>

									<tr><td colspan="10" style="background-color:#C5C8C8"></td></tr>
									
									 <form id="form_agent_user" method="POST" action="">
										<input type="hidden" name="fc_id" class="form-control" value="<?php echo $fc_id; ?>">
										
										<tr>
											<td colspan=2 style="font-size:16px">Feedback Acceptance<span style="font-size:24px;color:red">*</span></td>
											<td colspan=6>
												<select class="form-control" id="" name="agnt_fd_acpt" required="">
													<option value="">--Select--</option>
													<option <?php echo $fc_escalation_data['agnt_fd_acpt']=='Acceptance'?"selected":""; ?> value="Acceptance">Acceptance</option>	
													<option <?php echo $fc_escalation_data['agnt_fd_acpt']=='Not Acceptance'?"selected":""; ?> value="Not Acceptance">Not Acceptance</option>	
												</select>
											</td>
										</tr>
										<tr>
											<td colspan=2 style="font-size:16px">Your Review<span style="font-size:24px;color:red">*</span></td>
											<td colspan=6><textarea class="form-control" name="note" required><?php echo $fc_escalation_data['agent_rvw_note'] ?></textarea></td>
										</tr>
										
										<?php if(is_access_qa_agent_module()==true){
										if(is_available_qa_feedback($fc_escalation_data['entry_date'],72) == true){ ?>
											<tr>
												<?php if($fc_escalation_data['agent_rvw_note']==''){ ?>
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