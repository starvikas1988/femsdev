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
											<td colspan="8" id="theader" style="font-size:40px; text-align:center!important; ">FC HOTLINE AGENT FORM</td>
											<input type="hidden" name="audit_start_time" value="<?php echo CurrMySqlDate(); ?>">
										</tr>
										<?php
										
											if ($fc_hotline_data['entry_by'] != '') {
												$auditorName = $fc_hotline_data['auditor_name'];
											} else {
												$auditorName = $fc_hotline_data['client_name'];
											}
										
											$auditDate = mysql2mmddyy($fc_hotline_data['audit_date']);
										 
											$clDate_val = mysql2mmddyy($fc_hotline_data['call_date']);
										

										if ($rand_id != 0) {
											$agent_id = $rand_data['sid'];
											$fusion_id = $rand_data['fusion_id'];
											$agent_name = $rand_data['fname'] . " " . $rand_data['lname'];
											$tl_id = $rand_data['assigned_to'];
											$tl_name = $rand_data['tl_name'];
											$call_duration = $rand_data['call_duration'];
											
										} else {
											$agent_id = $fc_hotline_data['agent_id'];
											$fusion_id = $fc_hotline_data['fusion_id'];
											$agent_name = $fc_hotline_data['fname'] . " " . $fc_hotline_data['lname'] ;
											$tl_id = $fc_hotline_data['tl_id'];
											$tl_name = $fc_hotline_data['tl_name'];
											$call_duration = $fc_hotline_data['call_duration'];
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
											<td><input type="text" class="form-control" id="fusion_id"  value="<?php echo $fusion_id; ?>" readonly></td>
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
											    <option value="Agent" <?= ($fc_hotline_data['acpt']=="Agent")?"selected":"" ?>>Agent</option>
												<option value="Customer" <?= ($fc_hotline_data['acpt']=="Customer")?"selected":"" ?>>Customer</option>
												<option value="Process" <?= ($fc_hotline_data['acpt']=="Process")?"selected":"" ?>>Process</option>
												<option value="Technology" <?= ($fc_hotline_data['acpt']=="Technology")?"selected":"" ?>>Technology</option>
												<option value="NA" <?= ($fc_hotline_data['acpt']=="NA")?"selected":"" ?>>NA</option>
												
											
										</select>
											</td>
											<td>Skill:<span style="font-size:24px;color:red">*</span></td>
											<td>
												<select class="form-control" id="" name="data[skill]" disabled>
													
													<option value="">-Select-</option>
													<option value="GI"  <?= ($fc_hotline_data['skill']=="GI")?"selected":"" ?>>GI</option>
													<option value="EZpay"  <?= ($fc_hotline_data['skill']=="EZpay")?"selected":"" ?>>EZpay</option>
													<option value="DCO"  <?= ($fc_hotline_data['skill']=="DCO")?"selected":"" ?>>DCO</option>
													<option value="VAC"  <?= ($fc_hotline_data['skill']=="VAC")?"selected":"" ?>>VAC</option>
													<option value="EDU"  <?= ($fc_hotline_data['skill']=="EDU")?"selected":"" ?>>EDU</option>
												</select>
											</td>

											<td>File/Call ID:<span style="font-size:24px;color:red">*</span></td>
											<td>
												<input type="text" class="form-control" name="data[call_id]" value="<?php echo $fc_hotline_data['call_id'] ?>" disabled>
											</td>
										</tr>
										
										<tr>
											<td>Call Duration:<span style="font-size:24px;color:red">*</span></td>
											<td><input type="text" class="form-control" onkeydown="return false;" id="call_duration" name="data[call_duration]" value="<?php echo $call_duration; ?>" disabled></td>

											<td>Reason of the Call:<span style="font-size:24px;color:red">*</span></td>
											<td>
												<select class="form-control" id="" name="data[reason_for_call]" disabled>
													<option value="">-Select-</option>
													<option value="Inbound"  <?= ($fc_hotline_data['reason_for_call']=="Inbound")?"selected":"" ?>>Inbound</option>
													<option value="Outbound"  <?= ($fc_hotline_data['reason_for_call']=="Outbound")?"selected":"" ?>>Outbound</option>
												</select>
											</td>
											<td>VOC:<span style="font-size:24px;color:red">*</span></td>
											<td>
												<select class="form-control" id="voc" name="data[voc]" disabled>
													
													<option value="">-Select-</option>
													<option value="1"  <?= ($fc_hotline_data['voc']=="1")?"selected":"" ?>>1</option>
													<option value="2"  <?= ($fc_hotline_data['voc']=="2")?"selected":"" ?>>2</option>
													<option value="3"  <?= ($fc_hotline_data['voc']=="3")?"selected":"" ?>>3</option>
													<option value="4"  <?= ($fc_hotline_data['voc']=="4")?"selected":"" ?>>4</option>
													<option value="5"  <?= ($fc_hotline_data['voc']=="5")?"selected":"" ?>>5</option>
													<option value="6"  <?= ($fc_hotline_data['voc']=="6")?"selected":"" ?>>6</option>
													<option value="7"  <?= ($fc_hotline_data['voc']=="7")?"selected":"" ?>>7</option>
													<option value="8"  <?= ($fc_hotline_data['voc']=="8")?"selected":"" ?>>8</option>
													<option value="9"  <?= ($fc_hotline_data['voc']=="9")?"selected":"" ?>>9</option>
													<option value="10"  <?= ($fc_hotline_data['voc']=="10")?"selected":"" ?>>10</option>
												</select>
											</td>
										</tr>
										<tr>
											<td>Site:<span style="font-size:24px;color:red">*</span></td>
											<td>
												<input type="text" class="form-control" id="site" name="data[site]" value="<?php echo $fc_hotline_data['site'] ?>" readonly>
											</td>
											<td>Evaluation Link:<span style="font-size:24px;color:red">*</span></td>
											<td>
												<input type="text" class="form-control" id="" name="data[evaluation_link]" value="<?php echo $fc_hotline_data['evaluation_link'] ?>" disabled>
											</td>

											<td>Disposition:<span style="font-size:24px;color:red">*</span>
											</td>
											<td>
												<select class="form-control" id="" name="data[disposition]" disabled>
                                                    <option value="">-Select-</option>
                                                    <option value="C-CSR called the wrong line" <?= ($fc_hotline_data['disposition']=="C-CSR called the wrong line")?"selected":"" ?>>C-CSR called the wrong line</option>
                                                    <option value="FC-Escalation- Auth Hold" <?= ($fc_hotline_data['disposition']=="FC-Escalation- Auth Hold")?"selected":"" ?>>FC-Escalation- Auth Hold</option>
                                                    <option value="FC-Escalation- expired promotion" <?= ($fc_hotline_data['disposition']=="FC-Escalation- expired promotion")?"selected":"" ?>>FC-Escalation- expired promotion</option>
                                                    <option value="FC-Escalation- EZpay" <?= ($fc_hotline_data['disposition']=="FC-Escalation- EZpay")?"selected":"" ?>>FC-Escalation- EZpay</option>
                                                    <option value="FC-Escalation- guest hung up" <?= ($fc_hotline_data['disposition']=="FC-Escalation- guest hung up")?"selected":"" ?>>FC-Escalation- guest hung up</option>
                                                    <option value="FC-Escalation- other" <?= ($fc_hotline_data['disposition']=="FC-Escalation- other")?"selected":"" ?>>FC-Escalation- other</option>
                                                    <option value="FC-Escalation- unnecessary" <?= ($fc_hotline_data['disposition']=="FC-Escalation- unnecessary")?"selected":"" ?>>FC-Escalation- unnecessary</option>
                                                    <option value="FC-Escalation- vacations" <?= ($fc_hotline_data['disposition']=="FC-Escalation- vacations")?"selected":"" ?>>FC-Escalation- vacations</option>
                                                    <option value="FC-Escalation- website" <?= ($fc_hotline_data['disposition']=="FC-Escalation- website")?"selected":"" ?>>FC-Escalation- website</option>
                                                    <option value="FC-General Question - necessary" <?= ($fc_hotline_data['disposition']=="FC-General Question - necessary")?"selected":"" ?>>FC-General Question - necessary</option>
                                                    <option value="FC-General Question - unnecessary" <?= ($fc_hotline_data['disposition']=="FC-General Question - unnecessary")?"selected":"" ?>>FC-General Question - unnecessary</option>
                                                    <option value="FC-Override - EZpay settle" <?= ($fc_hotline_data['disposition']=="FC-Override - EZpay settle")?"selected":"" ?>>FC-Override - EZpay settle</option>
                                                    <option value="FC-Override - general" <?= ($fc_hotline_data['disposition']=="FC-Override - general")?"selected":"" ?>>FC-Override - general</option>
                                                    <option value="FC-Override - MPR/Freedom Pay" <?= ($fc_hotline_data['disposition']=="FC-Override - MPR/Freedom Pay")?"selected":"" ?>>FC-Override - MPR/Freedom Pay</option>
                                                </select>
											</td>
											</tr>
											<tr>
												<td>Audit Type:<span style="font-size:24px;color:red">*</span>
											</td>
											<td>
												<select class="form-control" id="audit_type" name="data[audit_type]" disabled>
                                                    <option value="">-Select-</option>
                                                    <option value="CQ Audit" <?= ($fc_hotline_data['audit_type']=="CQ Audit")?"selected":"" ?>>CQ Audit</option>
                                                    <option value="BQ Audit" <?= ($fc_hotline_data['audit_type']=="BQ Audit")?"selected":"" ?>>BQ Audit</option>
                                                    <option value="Calibration" <?= ($fc_hotline_data['audit_type']=="Calibration")?"selected":"" ?>>Calibration</option>
                                                    <option value="Pre-Certificate Mock Call" <?= ($fc_hotline_data['audit_type']=="Pre-Certificate Mock Call")?"selected":"" ?>>Pre-Certificate Mock Call</option>
                                                    <option value="Certification Audit" <?= ($fc_hotline_data['audit_type']=="Certification Audit")?"selected":"" ?>>Certification Audit</option>
                                                    <option value="WoW Call"  <?= ($fc_hotline_data['audit_type']=="WoW Call")?"selected":"" ?>>WoW Call</option>
                                                    <option value="Hygiene Audit"  <?= ($fc_hotline_data['audit_type']=="Hygiene Audit")?"selected":"" ?>>Hygiene Audit</option>
                                                    <option value="Operation Audit"  <?= ($fc_hotline_data['audit_type']=="Operation Audit")?"selected":"" ?>>Operation Audit</option>
                                                    <option value="Trainer Audit"  <?= ($fc_hotline_data['audit_type']=="Trainer Audit")?"selected":"" ?>>Trainer Audit</option> 
                                                    <option value="QA Supervisor Audit"  <?= ($fc_hotline_data['audit_type']=="QA Supervisor Audit")?"selected":"" ?>>QA Supervisor Audit</option> 
                                                </select>
											</td>
											<td class="auType_epi">Auditor Type<span style="font-size:24px;color:red">*</span></td>
											<td class="auType_epi">
												<select class="form-control" id="auditor_type" name="data[auditor_type]">
                                                    <option value="">Select</option>
                                                    <option value="Master" <?= ($fc_hotline_data['auditor_type']=="Master")?"selected":"" ?>>Master</option>
                                                    <option value="Regular" <?= ($fc_hotline_data['auditor_type']=="Regular")?"selected":"" ?>>Regular</option>
                                                </select>
											</td>
										</tr>
										<tr>
											<td style="font-weight:bold; font-size:16px; text-align:left">Earned Score</td>
											<td><input type="text" readonly id="fc_hotline_earned_score" name="data[earned_score]" class="form-control" value="<?php echo $fc_hotline_data['earned_score'] ?>" /></td>
											<td style="font-weight:bold; font-size:16px; text-align:left">Possible Score</td>
											<td><input type="text" readonly id="fc_hotline_possible_score" name="data[possible_score]" class="form-control" value="<?php echo $fc_hotline_data['possible_score'] ?>" /></td>
											<td style="font-weight:bold; font-size:16px; text-align:right">Overall Score:</td>
											<td><input type="text" class="form-control fc_hotlineFatal" readonly id="fc_hotline_overall_score" name="data[overall_score]"  style="font-weight:bold" value="<?php echo $fc_hotline_data['overall_score'] ?>"></td>
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
											<td class="eml" rowspan="6">AMBASSADOR INTERACTION</td>
											<td>1 - Did the Floor Coach provide accurate and up-to-date information?</td>
											<td>	
											FC displays knowledage of our<br>products and provides the ambassador<br>only with correct information. 		
											</td>
											
											<td>20</td>
											<td>
												<select class="form-control fc_hotline_point" id ="" name="data[accurate_information]" disabled>
													<option fc_hotline_val=20 fc_hotline_max="20"<?php echo $fc_hotline_data['accurate_information'] == "Yes" ? "selected" : ""; ?> value="Yes">Yes</option>
													<option fc_hotline_val=0 fc_hotline_max="20" <?php echo $fc_hotline_data['accurate_information'] == "No" ? "selected" : ""; ?> value="No">No</option>
												</select>
											</td>
											<td><input type="text" disabled name="data[cmt1]" class="form-control" value="<?php echo $fc_hotline_data['cmt1'] ?>"></td>
										</tr>
										<tr>
											<td>2 - Active Listening</td>
											<td>
											FC listens to agent and<br>what their needs are. If<br>needed, they repeat the question<br>to better understand. "Just so<br>I understand, you have<br>a guest on the phone<br>and they are asking…" FC<br> pays attention to the agent at all times 	
											</td>
											
											<td>20</td>
											<td>
												<select class="form-control fc_hotline_point" id ="" name="data[active_listening]" disabled>
													<option fc_hotline_val=20 fc_hotline_max="20"<?php echo $fc_hotline_data['active_listening'] == "Yes" ? "selected" : ""; ?> value="Yes">Yes</option>
													<option fc_hotline_val=0 fc_hotline_max="20" <?php echo $fc_hotline_data['active_listening'] == "No" ? "selected" : ""; ?> value="No">No</option>
												</select>
											</td>
											<td><input type="text" disabled name="data[cmt2]" class="form-control" value="<?php echo $fc_hotline_data['cmt2'] ?>"></td>
										</tr>
										<tr>
											<td>3 - Floor Coach's verbatim, tone, and content</td>
											<td>
											Is the FC polite and<br>did they use a professional<br>tone toward the agent during<br>the entire time? Was the<br>FC sincere and helful? 	
											</td>
											
											<td>10</td>
											<td>
												<select class="form-control fc_hotline_point" id ="" name="data[verbatim_tone]" disabled>
													<option fc_hotline_val=10 fc_hotline_max="10"<?php echo $fc_hotline_data['verbatim_tone'] == "Yes" ? "selected" : ""; ?> value="Yes">Yes</option>
													<option fc_hotline_val=0 fc_hotline_max="10" <?php echo $fc_hotline_data['verbatim_tone'] == "No" ? "selected" : ""; ?> value="No">No</option>
												</select>
											</td>
											<td><input type="text" disabled name="data[cmt3]" class="form-control" value="<?php echo $fc_hotline_data['cmt3'] ?>"></td>
										</tr>
										<tr>
											<td>4 - Finding the solution</td>
											<td>
											Did the FC make the<br>right decion for SEA and<br> the guest? Did the FC<br>maintain an open-minded approach<br>to be helpful to the<br>ambassador as well as the guest. 	
											</td>
											<td>20</td>
											<td>
												<select class="form-control fc_hotline_point" id ="" name="data[finding_solution]" disabled>
													<option fc_hotline_val=20 fc_hotline_max="20"<?php echo $fc_hotline_data['finding_solution'] == "Yes" ? "selected" : ""; ?> value="Yes">Yes</option>
													<option fc_hotline_val=0 fc_hotline_max="20" <?php echo $fc_hotline_data['finding_solution'] == "No" ? "selected" : ""; ?> value="No">No</option>
												</select>
											</td>
											<td><input type="text" disabled name="data[cmt4]" class="form-control" value="<?php echo $fc_hotline_data['cmt4'] ?>"></td>
										</tr>
										<tr>
											<td>5- Floor coach did not blame anyone else for the issue being called about.</td>
											<td>
											We are all one entity,<br>and should never negatively speak<br>about the operation as a<br> whole. If a ambassdor<br>(or you) are frustrated about<br>something, re-direct their/your<br> attention to productive avenues to<br>bring call to a succesfull conclusion.	
											</td>
											<td>10</td>
											<td>
												<select class="form-control fc_hotline_point" id ="" name="data[issue_called_about]" disabled>
													<option fc_hotline_val=10 fc_hotline_max="10"<?php echo $fc_hotline_data['issue_called_about'] == "Yes" ? "selected" : ""; ?> value="Yes">Yes</option>
													<option fc_hotline_val=0 fc_hotline_max="10" <?php echo $fc_hotline_data['issue_called_about'] == "No" ? "selected" : ""; ?> value="No">No</option>
												</select>
											</td>
											<td><input type="text" disabled name="data[cmt5]" class="form-control" value="<?php echo $fc_hotline_data['cmt5'] ?>"></td>
										</tr>
										<tr>
											<td>6- Efficiency on the call</td>
											<td>
											FC Sticks to what is<br>necessary to resolve the call,<br>answering questions and fullfilling Ambassdor's requests.
											</td>
											<td>20</td>
											<td>
												<select class="form-control fc_hotline_point" id ="" name="data[efficiency_on_call]" disabled>
													<option fc_hotline_val=20 fc_hotline_max="20"<?php echo $fc_hotline_data['efficiency_on_call'] == "Yes" ? "selected" : ""; ?> value="Yes">Yes</option>
													<option fc_hotline_val=0 fc_hotline_max="20" <?php echo $fc_hotline_data['efficiency_on_call'] == "No" ? "selected" : ""; ?> value="No">No</option>
												</select>
											</td>
											<td><input type="text" disabled name="data[cmt6]" class="form-control" value="<?php echo $fc_hotline_data['cmt6'] ?>"></td>
										</tr>

										<tr>
											<td>Call Summary:</td>
											<td colspan=3><textarea class="form-control" disabled name="data[call_summary]"><?php echo $fc_hotline_data['call_summary'] ?></textarea></td>
											<td>Feedback:</td>
											<td colspan=4><textarea class="form-control" disabled name="data[feedback]"><?php echo $fc_hotline_data['feedback'] ?></textarea></td>
										</tr>
										<?php if($fc_hotline_data['attach_file']!=''){ ?>
									<tr oncontextmenu="return false;">
										<td colspan="2">Audio Files (Mp4/Mp3/M4a/Wav)</td>
										<td colspan="4">
											<?php $attach_file = explode(",",$fc_hotline_data['attach_file']);
											 foreach($attach_file as $af){ ?>
												<audio oncontextmenu="return false;" controls controlslist="nodownload" style="background-color:#607F93">
													  <source src="<?php echo base_url(); ?>qa_files/sea_world/fc_hotline/<?php echo $af; ?>" type="audio/ogg">
													  <source src="<?php echo base_url(); ?>qa_files/sea_world/fc_hotline/<?php echo $af; ?>" type="audio/mpeg">
												</audio> </br>
											 <?php } ?>
										</td>
									</tr>
									<?php } ?>

									<tr>
										<td style="font-size:12px">Manager Review:</td>
										<td colspan="8" style="text-align:left"><?php echo $fc_hotline_data['mgnt_rvw_note'] ?></td>
									</tr>
									<tr>
										<td style="font-size:12px">Client Review:</td>
										<td colspan="8" style="text-align:left"><?php echo $fc_hotline_data['client_rvw_note'] ?></td>
									</tr>

									<tr><td colspan="10" style="background-color:#C5C8C8"></td></tr>
									
									 <form id="form_agent_user" method="POST" action="">
										<input type="hidden" name="fc_hotline_id" class="form-control" value="<?php echo $fc_hotline_id; ?>">
										
										<tr>
											<td colspan=2 style="font-size:16px">Feedback Acceptance<span style="font-size:24px;color:red">*</span></td>
											<td colspan=6>
												<select class="form-control" id="" name="agnt_fd_acpt" required="">
													<option value="">--Select--</option>
													<option <?php echo $fc_hotline_data['agnt_fd_acpt']=='Acceptance'?"selected":""; ?> value="Acceptance">Acceptance</option>	
													<option <?php echo $fc_hotline_data['agnt_fd_acpt']=='Not Acceptance'?"selected":""; ?> value="Not Acceptance">Not Acceptance</option>	
												</select>
											</td>
										</tr>
										<tr>
											<td colspan=2 style="font-size:16px">Your Review<span style="font-size:24px;color:red">*</span></td>
											<td colspan=6><textarea class="form-control" name="note" required><?php echo $fc_hotline_data['agent_rvw_note'] ?></textarea></td>
										</tr>
										
										<?php if(is_access_qa_agent_module()==true){
										if(is_available_qa_feedback($fc_hotline_data['entry_date'],72) == true){ ?>
											<tr>
												<?php if($fc_hotline_data['agent_rvw_note']==''){ ?>
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