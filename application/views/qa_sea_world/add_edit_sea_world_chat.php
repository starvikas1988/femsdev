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

<?php if ($sea_world_id != 0) {
	if (is_access_qa_edit_feedback() == false) { ?>
		<style>
			.form-control {
				pointer-events: none;
				background-color: #D5DBDB;
			}
		</style>
<?php }
} ?>

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
											<td colspan="8" id="theader" style="font-size:40px; text-align:center!important; ">SEA WORLD CHAT QA FORM</td>
											<input type="hidden" name="audit_start_time" value="<?php echo CurrMySqlDate(); ?>">
										</tr>
										<?php
										if ($sea_world_id == 0) {
											$auditorName = get_username();
											$auditDate = CurrDateMDY();
											//$auditDate =  CurrDateTimeMDY();
											$clDate_val = '';
										} else {
											if ($sea_world_chat_data['entry_by'] != '') {
												$auditorName = $sea_world_chat_data['auditor_name'];
											} else {
												$auditorName = $sea_world_chat_data['client_name'];
											}
										
											$auditDate = mysql2mmddyy($sea_world_chat_data['audit_date']);
										 
											$clDate_val = mysqlDt2mmddyy($sea_world_chat_data['call_date']);
										}

										if ($rand_id != 0) {
											$agent_id = $rand_data['sid'];
											$fusion_id = $rand_data['fusion_id'];
											$agent_name = $rand_data['fname'] . " " . $rand_data['lname'];
											$tl_id = $rand_data['assigned_to'];
											$tl_name = $rand_data['tl_name'];
											$call_duration = $rand_data['call_duration'];
											
										} else {
											$agent_id = $sea_world_chat_data['agent_id'];
											$fusion_id = $sea_world_chat_data['fusion_id'];
											$agent_name = $sea_world_chat_data['fname'] . " " . $sea_world_chat_data['lname'] ;
											$tl_id = $sea_world_chat_data['tl_id'];
											$tl_name = $sea_world_chat_data['tl_name'];
											$call_duration = $sea_world_chat_data['call_duration'];
										}
										?>
										<tr>
											<td>Auditor Name: <span style="font-size:24px;color:red">*</span></td>
											<td><input type="text" class="form-control" value="<?= $auditorName; ?>" disabled></td>
											<td>Audit Date:<span style="font-size:24px;color:red">*</span></td>
											<td><input type="text" class="form-control" value="<?= $auditDate; ?>" disabled></td>
											<td>Chat Date/Time:<span style="font-size:24px;color:red">*</span></td>
											<td>
												<input type="text" id="call_date_time" name="call_date"  onkeydown="return false;" value="<?php echo $clDate_val; ?>" max="<?php echo date("Y-m-d"); ?>" class="form-control" required>
											</td>
										</tr>
										<tr>
											<td>Agent Name:<span style="font-size:24px;color:red">*</span></td>
											<td>
												<select class="form-control" id="agent_id" name="data[agent_id]" required>
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
												<input type="hidden" class="form-control" id="tl_id" name="data[tl_id]" value="<?php echo $tl_id; ?>" required>
											</td>
										</tr>
										<tr>
											<td>KPI - ACPT:<span style="font-size:24px;color:red">*</span></td>
											<td>
												<select class="form-control" id="" name="data[acpt]" required>
											
											    <option value="">-Select-</option>
											    <option value="Agent" <?= ($sea_world_chat_data['acpt']=="Agent")?"selected":"" ?>>Agent</option>
												<option value="Customer" <?= ($sea_world_chat_data['acpt']=="Customer")?"selected":"" ?>>Customer</option>
												<option value="Process" <?= ($sea_world_chat_data['acpt']=="Process")?"selected":"" ?>>Process</option>
												<option value="Technology" <?= ($sea_world_chat_data['acpt']=="Technology")?"selected":"" ?>>Technology</option>
												<option value="NA" <?= ($sea_world_chat_data['acpt']=="NA")?"selected":"" ?>>NA</option>
												
											
										</select>
											</td>
											<td>Skill:<span style="font-size:24px;color:red">*</span></td>
											<td>
												<select class="form-control" id="" name="data[skill]" required>
													
													<option value="">-Select-</option>
													<option value="Gen"  <?= ($sea_world_chat_data['skill']=="Gen")?"selected":"" ?>>Gen</option>
													<option value="EZpay"  <?= ($sea_world_chat_data['skill']=="EZpay")?"selected":"" ?>>EZpay</option>
													<option value="DCO"  <?= ($sea_world_chat_data['skill']=="DCO")?"selected":"" ?>>DCO</option>
													<option value="VAC"  <?= ($sea_world_chat_data['skill']=="VAC")?"selected":"" ?>>VAC</option>
													<option value="EDU"  <?= ($sea_world_chat_data['skill']=="EDU")?"selected":"" ?>>EDU</option>
												</select>
											</td>

											<td>Field/Call ID:<span style="font-size:24px;color:red">*</span></td>
											<td>
												<input type="text" class="form-control" name="data[call_id]" value="<?php echo $sea_world_chat_data['call_id'] ?>" required>
											</td>
										</tr>
										
										<tr>
											<td>Chat Duration:<span style="font-size:24px;color:red">*</span></td>
											<td><input type="text" class="form-control" onkeydown="return false;" id="call_duration" name="data[call_duration]" value="<?php echo $call_duration; ?>" required></td>

											<td>Ticket ID:<span style="font-size:24px;color:red">*</span></td>
											<td><input type="text" class="form-control"  id="" name="data[ticket_id]" value="<?php echo $sea_world_chat_data['ticket_id']; ?>" required></td>
											<td>VOC:<span style="font-size:24px;color:red">*</span></td>
											<td>
												<select class="form-control" id="voc" name="data[voc]" required>
													
													<option value="">-Select-</option>
													<option value="1"  <?= ($sea_world_chat_data['voc']=="1")?"selected":"" ?>>1</option>
													<option value="2"  <?= ($sea_world_chat_data['voc']=="2")?"selected":"" ?>>2</option>
													<option value="3"  <?= ($sea_world_chat_data['voc']=="3")?"selected":"" ?>>3</option>
													<option value="4"  <?= ($sea_world_chat_data['voc']=="4")?"selected":"" ?>>4</option>
													<option value="5"  <?= ($sea_world_chat_data['voc']=="5")?"selected":"" ?>>5</option>
													<option value="6"  <?= ($sea_world_chat_data['voc']=="6")?"selected":"" ?>>6</option>
													<option value="7"  <?= ($sea_world_chat_data['voc']=="7")?"selected":"" ?>>7</option>
													<option value="8"  <?= ($sea_world_chat_data['voc']=="8")?"selected":"" ?>>8</option>
													<option value="9"  <?= ($sea_world_chat_data['voc']=="9")?"selected":"" ?>>9</option>
													<option value="10"  <?= ($sea_world_chat_data['voc']=="10")?"selected":"" ?>>10</option>
												</select>
											</td>
										</tr>
										<tr>
											<td>Site:<span style="font-size:24px;color:red">*</span></td>
											<td>
												<input type="text" class="form-control" id="site" name="data[site]" value="<?php echo $sea_world_chat_data['site'] ?>" readonly>
											</td>
											<td>Evaluation Link:<span style="font-size:24px;color:red">*</span></td>
											<td>
												<input type="text" class="form-control" id="" name="data[evaluation_link]" value="<?php echo $sea_world_chat_data['evaluation_link'] ?>" required>
											</td>

											<td>Audit Type:<span style="font-size:24px;color:red">*</span></td>
											<td>
												<select class="form-control" id="audit_type" name="data[audit_type]" required>
                                                    <option value="">-Select-</option>
                                                    <option value="CQ Audit" <?= ($sea_world_chat_data['audit_type']=="CQ Audit")?"selected":"" ?>>CQ Audit</option>
                                                    <option value="BQ Audit" <?= ($sea_world_chat_data['audit_type']=="BQ Audit")?"selected":"" ?>>BQ Audit</option>
                                                    <option value="Calibration" <?= ($sea_world_chat_data['audit_type']=="Calibration")?"selected":"" ?>>Calibration</option>
                                                    <option value="Pre-Certificate Mock Call" <?= ($sea_world_chat_data['audit_type']=="Pre-Certificate Mock Call")?"selected":"" ?>>Pre-Certificate Mock Call</option>
                                                    <option value="Certification Audit" <?= ($sea_world_chat_data['audit_type']=="Certification Audit")?"selected":"" ?>>Certification Audit</option>
                                                    <option value="WoW Call"  <?= ($sea_world_chat_data['audit_type']=="WoW Call")?"selected":"" ?>>WoW Call</option>
                                                    <option value="Hygiene Audit"  <?= ($sea_world_chat_data['audit_type']=="Hygiene Audit")?"selected":"" ?>>Hygiene Audit</option>
                                                    <option value="Operation Audit"  <?= ($sea_world_chat_data['audit_type']=="Operation Audit")?"selected":"" ?>>Operation Audit</option>
                                                    <option value="Trainer Audit"  <?= ($sea_world_chat_data['audit_type']=="Trainer Audit")?"selected":"" ?>>Trainer Audit</option> 
                                                    <option value="QA Supervisor Audit"  <?= ($sea_world_chat_data['audit_type']=="QA Supervisor Audit")?"selected":"" ?>>QA Supervisor Audit</option> 
                                                </select>
											</td>
											</tr>
											<tr>
											<td class="auType_epi">Auditor Type<span style="font-size:24px;color:red">*</span></td>
											<td class="auType_epi">
												<select class="form-control" id="auditor_type" name="data[auditor_type]">
                                                    <option value="">Select</option>
                                                    <option value="Master" <?= ($sea_world_chat_data['auditor_type']=="Master")?"selected":"" ?>>Master</option>
                                                    <option value="Regular" <?= ($sea_world_chat_data['auditor_type']=="Regular")?"selected":"" ?>>Regular</option>
                                                </select>
											</td>
										</tr>
										<tr>
											<td style="font-weight:bold; font-size:16px; text-align:left">Earned Score</td>
											<td><input type="text" readonly id="sea_world_chat_earned_score" name="data[earned_score]" class="form-control" value="<?php echo $sea_world_chat_data['earned_score'] ?>" /></td>
											<td style="font-weight:bold; font-size:16px; text-align:left">Possible Score</td>
											<td><input type="text" readonly id="sea_world_chat_possible_score" name="data[possible_score]" class="form-control" value="<?php echo $sea_world_chat_data['possible_score'] ?>" /></td>
											<td style="font-weight:bold; font-size:16px; text-align:right">Overall Score:</td>
											<td><input type="text" class="form-control seaworldChatFatal" readonly id="sea_world_chat_overall_score" name="data[overall_score]"  style="font-weight:bold" value="<?php echo $sea_world_chat_data['overall_score'] ?>"></td>
										</tr>
										<tr class="eml" style="height:25px; font-weight:bold">
											<td>PARAMETER</td>
											<td>SUB PARAMETER</td>
											<td>LEGEND</td>
											<td>WEIGHT(%)</td>
											<td>SCORE</td>
											<td>REMARKS</td>
										</tr>

										<tr>
											<td class="eml" rowspan=2>Section 1 - Greeting/Closing</td>
											<td>1a. Proper greeting</td>
											<td>
												<select class="form-control" id ="" style="width: 200px;" name="data[cmt1]" required>
													
													<option <?php echo $sea_world_chat_data['cmt1'] == "Agent properly greets the guest by thanking them for contacting SW & BG (or DCO, or SPL)" ? "selected" : ""; ?> value="Agent properly greets the guest by thanking them for contacting SW & BG (or DCO, or SPL)">Agent properly greets the guest by thanking them for contacting SW & BG (or DCO, or SPL)</option>
													<option <?php echo $sea_world_chat_data['cmt1'] == "Agent offers assistance." ? "selected" : ""; ?> value="Agent offers assistance.">Agent offers assistance.</option>
													<option  <?php echo $sea_world_chat_data['cmt1'] == "Agent informs the guest there will be a survey at the end of the chat." ? "selected" : ""; ?> value="Agent informs the guest there will be a survey at the end of the chat.">Agent informs the guest there will be a survey at the end of the chat.</option>
												</select>
											</td>
											<td>3</td>
											<td>
												<select class="form-control sea_world_chat_point" id ="" name="data[proper_greeting]" required>
													
													<option sea_world_chat_val=3 sea_world_chat_max="3"<?php echo $sea_world_chat_data['proper_greeting'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option sea_world_chat_val=0 sea_world_chat_max="3" <?php echo $sea_world_chat_data['proper_greeting'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													<option sea_world_chat_val=3 sea_world_chat_max="3" <?php echo $sea_world_chat_data['proper_greeting'] == "NA" ? "selected" : ""; ?> value="NA">NA</option>
												</select>
											</td>
											<td><input type="text" name="data[remarks1]" class="form-control" value="<?php echo $sea_world_chat_data['remarks1'] ?>"></td>
										</tr>
										<tr>
											<td>1b. Proper Closing</td>
											<td>
												<select class="form-control" id ="" style="width: 200px;" name="data[cmt2]" required>
													
													<option <?php echo $sea_world_chat_data['cmt1'] == "Agent offers additional assistance." ? "selected" : ""; ?> value="Agent offers additional assistance.">Agent offers additional assistance.</option>
													<option <?php echo $sea_world_chat_data['cmt1'] == "Agent thanks the guest for contacting SW & BG (or park discussed in the CHAT)" ? "selected" : ""; ?> value="Agent thanks the guest for contacting SW & BG (or park discussed in the CHAT)">Agent thanks the guest for contacting SW & BG (or park discussed in the CHAT)</option>
													<option  <?php echo $sea_world_chat_data['cmt1'] == "Agent reminds the guest of the survey following the chat." ? "selected" : ""; ?> value="Agent reminds the guest of the survey following the chat.">Agent reminds the guest of the survey following the chat.</option>
												</select>
											</td>
											<td>3</td>
											<td>
												<select class="form-control sea_world_chat_point" id ="" name="data[proper_closing]" required>
													
													<option sea_world_chat_val=3 sea_world_chat_max="3"<?php echo $sea_world_chat_data['proper_closing'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option sea_world_chat_val=0 sea_world_chat_max="3" <?php echo $sea_world_chat_data['proper_closing'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													<option sea_world_chat_val=3 sea_world_chat_max="3" <?php echo $sea_world_chat_data['proper_closing'] == "NA" ? "selected" : ""; ?> value="NA">NA</option>
												</select>
											</td>
											<td><input type="text" name="data[remarks2]" class="form-control" value="<?php echo $sea_world_chat_data['remarks2'] ?>"></td>
										</tr>
										<tr>
											<td class="eml" rowspan=4>Section 2 - Ambassador Etiquette</td>
											<td>2a. Conversation was clear,<br> understood, uses proper spelling as well as grammer.</td>
											<td>
												<select class="form-control" id ="" style="width: 200px;" name="data[cmt3]" required>
													
													<option <?php echo $sea_world_chat_data['cmt3'] == "Used clear and simple language to avoid misunderstandings." ? "selected" : ""; ?> value="Used clear and simple language to avoid misunderstandings.">Used clear and simple language to avoid misunderstandings.</option>
													<option <?php echo $sea_world_chat_data['cmt3'] == "Ensure proper grammar and spelling for professionalism." ? "selected" : ""; ?> value="Ensure proper grammar and spelling for professionalism.">Ensure proper grammar and spelling for professionalism.</option>
												</select>
											</td>
											<td>9</td>
											<td>
												<select class="form-control sea_world_chat_point" id ="" name="data[proper_spelling]" required>
													
													<option sea_world_chat_val=9 sea_world_chat_max="9" <?php echo $sea_world_chat_data['proper_spelling'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option sea_world_chat_val=0 sea_world_chat_max="9" <?php echo $sea_world_chat_data['proper_spelling'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													<option sea_world_chat_val=9 sea_world_chat_max="9" <?php echo $sea_world_chat_data['proper_spelling'] == "NA" ? "selected" : ""; ?> value="NA">NA</option>
												</select>
											</td>
											<td><input type="text" name="data[remarks3]" class="form-control" value="<?php echo $sea_world_chat_data['remarks3'] ?>"></td>
										</tr>
										<tr>
											<td>2b. Ambassador used courteous &<br> professional words and phrases.</td>
											<td>
												<select class="form-control" id ="" style="width: 200px;" name="data[cmt4]" required>
													<option <?php echo $sea_world_chat_data['cmt4'] == "Use courteous language, including phrases like Thank you, Please, May I, and You're welcome." ? "selected" : ""; ?> value="Use courteous language, including phrases like Thank you, Please, May I, and You're welcome.">Use courteous language, including phrases like Thank you, Please, May I, and You're welcome.</option>
													<option <?php echo $sea_world_chat_data['cmt4'] == "Maintain a friendly and approachable tone in chat-based interactions." ? "selected" : ""; ?> value="Maintain a friendly and approachable tone in chat-based interactions.">Maintain a friendly and approachable tone in chat-based interactions.</option>
													<option <?php echo $sea_world_chat_data['cmt4'] == "Uphold professionalism and politeness throughout the conversation." ? "selected" : ""; ?> value="Uphold professionalism and politeness throughout the conversation.">Uphold professionalism and politeness throughout the conversation.</option>
													<option <?php echo $sea_world_chat_data['cmt4'] == "Consistently display a can-do attitude when addressing customer inquiries and issues." ? "selected" : ""; ?> value="Consistently display a can-do attitude when addressing customer inquiries and issues.">Consistently display a can-do attitude when addressing customer inquiries and issues.</option>
												</select>
											</td>
											<td>6</td>
											<td>
												<select class="form-control sea_world_chat_point" id ="" name="data[professional_words]" required>
													
													<option sea_world_chat_val=6 sea_world_chat_max="6" <?php echo $sea_world_chat_data['professional_words'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option sea_world_chat_val=0 sea_world_chat_max="6" <?php echo $sea_world_chat_data['professional_words'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													<option sea_world_chat_val=6 sea_world_chat_max="6" <?php echo $sea_world_chat_data['professional_words'] == "NA" ? "selected" : ""; ?> value="NA">NA</option>
												</select>
											</td>
											<td><input type="text" name="data[remarks4]" class="form-control" value="<?php echo $sea_world_chat_data['remarks4'] ?>"></td>
										</tr>
										<tr>
											<td>2c. The agent adapted their approach<br>to the customer based on the<br>customer’s unique needs, personality<br> and issues.</td>
											<td>
												<select class="form-control" id ="" style="width: 200px;" name="data[cmt5]" required>
													<option <?php echo $sea_world_chat_data['cmt5'] == "Maintain polite and respectful communication at all times." ? "selected" : ""; ?> value="Maintain polite and respectful communication at all times.">Maintain polite and respectful communication at all times.</option>
													<option <?php echo $sea_world_chat_data['cmt5'] == "Demonstrate empathy and concern when dealing with upset guests, including offering sincere apologies." ? "selected" : ""; ?> value="Demonstrate empathy and concern when dealing with upset guests, including offering sincere apologies.">Demonstrate empathy and concern when dealing with upset guests, including offering sincere apologies.</option>
													<option <?php echo $sea_world_chat_data['cmt5'] == "Share in the excitement of enthusiastic guests and engage them in a lively manner." ? "selected" : ""; ?> value="Share in the excitement of enthusiastic guests and engage them in a lively manner.">Share in the excitement of enthusiastic guests and engage them in a lively manner.</option>
													<option <?php echo $sea_world_chat_data['cmt5'] == "Ensure that all emotional responses, whether addressing upset or excited guests, convey sincerity and authenticity." ? "selected" : ""; ?> value="Ensure that all emotional responses, whether addressing upset or excited guests, convey sincerity and authenticity.">Ensure that all emotional responses, whether addressing upset or excited guests, convey sincerity and authenticity.</option>
													<option <?php echo $sea_world_chat_data['cmt5'] == "Adapt your approach and tone based on the emotional state of the guest, showing a high level of responsiveness to their needs and feelings." ? "selected" : ""; ?> value="Adapt your approach and tone based on the emotional state of the guest, showing a high level of responsiveness to their needs and feelings.">Adapt your approach and tone based on the emotional state of the guest, showing a high level of responsiveness to their needs and feelings.</option>
												</select>
											</td>
											<td>6</td>
											<td>
												<select class="form-control sea_world_chat_point" id ="" name="data[adapted_approach]" required>
													
													<option sea_world_chat_val=6 sea_world_chat_max="6" <?php echo $sea_world_chat_data['adapted_approach'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option sea_world_chat_val=0 sea_world_chat_max="6" <?php echo $sea_world_chat_data['adapted_approach'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													<option sea_world_chat_val=6 sea_world_chat_max="6" <?php echo $sea_world_chat_data['adapted_approach'] == "NA" ? "selected" : ""; ?> value="NA">NA</option>
												</select>
											</td>
											<td><input type="text" name="data[remarks5]" class="form-control" value="<?php echo $sea_world_chat_data['remarks5'] ?>"></td>
										</tr>
										<tr>
											<td>2d. Active Listening.</td>
											<td>
												<select class="form-control" id ="" style="width: 200px;" name="data[cmt6]" required>
													<option <?php echo $sea_world_chat_data['cmt6'] == "Read and understood the guest questions fully before responding." ? "selected" : ""; ?> value="Read and understood the guest questions fully before responding.">Read and understood the guest questions fully before responding.</option>
													<option <?php echo $sea_world_chat_data['cmt6'] == "Acknowledge any issue mentioned in the chat" ? "selected" : ""; ?> value="Acknowledge any issue mentioned in the chat">Acknowledge any issue mentioned in the chat</option>
												</select>
											</td>
											<td>7</td>
											<td>
												<select class="form-control sea_world_chat_point" id ="" name="data[active_listening]" required>
													
													<option sea_world_chat_val=7 sea_world_chat_max="7" <?php echo $sea_world_chat_data['active_listening'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option sea_world_chat_val=0 sea_world_chat_max="7" <?php echo $sea_world_chat_data['active_listening'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													<option sea_world_chat_val=7 sea_world_chat_max="7" <?php echo $sea_world_chat_data['active_listening'] == "NA" ? "selected" : ""; ?> value="NA">NA</option>
												</select>
											</td>
											<td><input type="text" name="data[remarks6]" class="form-control" value="<?php echo $sea_world_chat_data['remarks6'] ?>"></td>
										</tr>
										<tr>
											<td class="eml" rowspan=5>Section 3 - Call Handling and Problem Solving</td>	
											<td>3.1.a. Agent takes ownership of the<br> Chat and resolves all issues that<br> arise throughout the Chat.</td>
											<td>
												<select class="form-control" id ="" style="width: 200px;" name="data[cmt7]" required>
													<option <?php echo $sea_world_chat_data['cmt7'] == "Prioritizes first contact resolution." ? "selected" : ""; ?> value="Prioritizes first contact resolution.">Prioritizes first contact resolution.</option>
													<option <?php echo $sea_world_chat_data['cmt7'] == "Makes every effort to find answer or resolution to reason for chat." ? "selected" : ""; ?> value="Makes every effort to find answer or resolution to reason for chat.">Makes every effort to find answer or resolution to reason for chat.</option>
													<option <?php echo $sea_world_chat_data['cmt7'] == "Does not encourage contact for another day, park or department for something that could be resolved on this chat." ? "selected" : ""; ?> value="Does not encourage contact for another day, park or department for something that could be resolved on this chat.">Does not encourage contact for another day, park or department for something that could be resolved on this chat.</option>
												</select>
											</td>
											<td>12</td>
											<td>
												<select class="form-control sea_world_chat_point" id ="" name="data[take_ownership]" required>
													
													<option sea_world_chat_val=12 sea_world_chat_max="12" <?php echo $sea_world_chat_data['take_ownership'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option sea_world_chat_val=0 sea_world_chat_max="12" <?php echo $sea_world_chat_data['take_ownership'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													<option sea_world_chat_val=12 sea_world_chat_max="12" <?php echo $sea_world_chat_data['take_ownership'] == "NA" ? "selected" : ""; ?> value="NA">NA</option>
												</select>
											</td>
											<td><input type="text" name="data[remarks7]" class="form-control" value="<?php echo $sea_world_chat_data['remarks7'] ?>"></td>
										</tr>
										<tr>	
											<td>3.1.b. Agent follows all SOP/Policies<br> as stated in SharePoint or provided <br>by Leadership.</td>
											<td>
												<select class="form-control" id ="" style="width: 200px;" name="data[cmt8]" required>
													<option <?php echo $sea_world_chat_data['cmt8'] == "Protects the interests of the business and the guest by ensuring all procedures and processes are followed." ? "selected" : ""; ?> value="Protects the interests of the business and the guest by ensuring all procedures and processes are followed.">Protects the interests of the business and the guest by ensuring all procedures and processes are followed.</option>
												</select>
											</td>
											<td>8</td>
											<td>
												<select class="form-control sea_world_chat_point" id ="" name="data[follows_all_SOP]" required>
													
													<option sea_world_chat_val=8 sea_world_chat_max="8" <?php echo $sea_world_chat_data['follows_all_SOP'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option sea_world_chat_val=0 sea_world_chat_max="8" <?php echo $sea_world_chat_data['follows_all_SOP'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													<option sea_world_chat_val=8 sea_world_chat_max="8" <?php echo $sea_world_chat_data['follows_all_SOP'] == "NA" ? "selected" : ""; ?> value="NA">NA</option>
												</select>
											</td>
											<td><input type="text" name="data[remarks8]" class="form-control" value="<?php echo $sea_world_chat_data['remarks8'] ?>"></td>
										</tr>
										<tr>	
											<td>3.1.c. Agent does not blame parks<br> or other departments for problem.</td>
											<td>
												<select class="form-control" id ="" style="width: 200px;" name="data[cmt9]" required>
													<option <?php echo $sea_world_chat_data['cmt9'] == "Should not use negative language about the organization, parks, departments, individuals within organization or internal systems." ? "selected" : ""; ?> value="Should not use negative language about the organization, parks, departments, individuals within organization or internal systems.">Should not use negative language about the organization, parks, departments, individuals within organization or internal systems.</option>
													<option <?php echo $sea_world_chat_data['cmt9'] == "Should not participate or agree if guest complains about organization, parks, departments, individuals within organization or internal systems." ? "selected" : ""; ?> value="Should not participate or agree if guest complains about organization, parks, departments, individuals within organization or internal systems.">Should not participate or agree if guest complains about organization, parks, departments, individuals within organization or internal systems.</option>
													<option <?php echo $sea_world_chat_data['cmt9'] == "Re-direct their/your attention to productive avenues to bring chat to a successful conclusion." ? "selected" : ""; ?> value="Re-direct their/your attention to productive avenues to bring chat to a successful conclusion.">Re-direct their/your attention to productive avenues to bring chat to a successful conclusion.</option>
												</select>
											</td>
											<td>5</td>
											<td>
												<select class="form-control sea_world_chat_point" id ="" name="data[blame_parks]" required>
													
													<option sea_world_chat_val=5 sea_world_chat_max="5" <?php echo $sea_world_chat_data['blame_parks'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option sea_world_chat_val=0 sea_world_chat_max="5" <?php echo $sea_world_chat_data['blame_parks'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													<option sea_world_chat_val=5 sea_world_chat_max="5" <?php echo $sea_world_chat_data['blame_parks'] == "NA" ? "selected" : ""; ?> value="NA">NA</option>
												</select>
											</td>
											<td><input type="text" name="data[remarks9]" class="form-control" value="<?php echo $sea_world_chat_data['remarks9'] ?>"></td>
										</tr>
										<tr>	
											<td>3.1.d. The agent asked pertinent<br> questions to accurately diagnose the<br> guest's need or problem.</td>
											<td>
												<select class="form-control" id ="" style="width: 200px;" name="data[cmt10]" required>
													<option <?php echo $sea_world_chat_data['cmt10'] == "Get to the root cause of why the guest is calling." ? "selected" : ""; ?> value="Get to the root cause of why the guest is calling.">Get to the root cause of why the guest is calling.</option>
													<option <?php echo $sea_world_chat_data['cmt10'] == "Avoid making assumptions." ? "selected" : ""; ?> value="Avoid making assumptions.">Avoid making assumptions.</option>
													<option <?php echo $sea_world_chat_data['cmt10'] == "When in doubt, ask pointed questions to help you understand the full scope of the situation, ensuring a clear and accurate response to the guest's inquiry." ? "selected" : ""; ?> value="When in doubt, ask pointed questions to help you understand the full scope of the situation, ensuring a clear and accurate response to the guest's inquiry.">When in doubt, ask pointed questions to help you understand the full scope of the situation, ensuring a clear and accurate response to the guest's inquiry.</option>
												</select>
											</td>
											<td>7</td>
											<td>
												<select class="form-control sea_world_chat_point" id ="" name="data[pertinent_questions]" required>
													
													<option sea_world_chat_val=7 sea_world_chat_max="7" <?php echo $sea_world_chat_data['pertinent_questions'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option sea_world_chat_val=0 sea_world_chat_max="7" <?php echo $sea_world_chat_data['pertinent_questions'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													<option sea_world_chat_val=7 sea_world_chat_max="7" <?php echo $sea_world_chat_data['pertinent_questions'] == "NA" ? "selected" : ""; ?> value="NA">NA</option>
												</select>
											</td>
											<td><input type="text" name="data[remarks10]" class="form-control" value="<?php echo $sea_world_chat_data['remarks10'] ?>"></td>
										</tr>
										<tr>	
											<td>3.1.e. Agent used appropropriate<br> resources to address the issue.</td>
											<td>
												<select class="form-control" id ="" style="width: 200px;" name="data[cmt11]" required>
													<option <?php echo $sea_world_chat_data['cmt11'] == "Did the agent use SharePoint appropriately?" ? "selected" : ""; ?> value="Did the agent use SharePoint appropriately?">Did the agent use SharePoint appropriately?</option>
													<option <?php echo $sea_world_chat_data['cmt11'] == "Did they go online or consult GSA to find additional information?" ? "selected" : ""; ?> value="Did they go online or consult GSA to find additional information?">Did they go online or consult GSA to find additional information?</option>
													<option <?php echo $sea_world_chat_data['cmt11'] == "Did the agent pull up the guest's account or order to gain a better understanding of the situation?" ? "selected" : ""; ?> value="Did the agent pull up the guest's account or order to gain a better understanding of the situation?">Did the agent pull up the guest's account or order to gain a better understanding of the situation?</option>
													<option <?php echo $sea_world_chat_data['cmt11'] == "Did the agent attempt to log in with the guest to verify the claim or troubleshoot issues?" ? "selected" : ""; ?> value="Did the agent attempt to log in with the guest to verify the claim or troubleshoot issues?">Did the agent attempt to log in with the guest to verify the claim or troubleshoot issues?</option>
													<option <?php echo $sea_world_chat_data['cmt11'] == "If needed, did the agent contact a Floor Coordinator (FC) for assistance?" ? "selected" : ""; ?> value="If needed, did the agent contact a Floor Coordinator (FC) for assistance?">If needed, did the agent contact a Floor Coordinator (FC) for assistance?</option>
													<option <?php echo $sea_world_chat_data['cmt11'] == "If the information is available and accessible, the agent is expected to provide it, ensuring a thorough and helpful response to the guest." ? "selected" : ""; ?> value="If the information is available and accessible, the agent is expected to provide it, ensuring a thorough and helpful response to the guest.">If the information is available and accessible, the agent is expected to provide it, ensuring a thorough and helpful response to the guest.</option>
												</select>
											</td>
											<td>4</td>
											<td>
												<select class="form-control sea_world_chat_point" id ="" name="data[appropropriate_resources]" required>
													
													<option sea_world_chat_val=4 sea_world_chat_max="4" <?php echo $sea_world_chat_data['appropropriate_resources'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option sea_world_chat_val=0 sea_world_chat_max="4" <?php echo $sea_world_chat_data['appropropriate_resources'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													<option sea_world_chat_val=4 sea_world_chat_max="4" <?php echo $sea_world_chat_data['appropropriate_resources'] == "NA" ? "selected" : ""; ?> value="NA">NA</option>
												</select>
											</td>
											<td><input type="text" name="data[remarks11]" class="form-control" value="<?php echo $sea_world_chat_data['remarks11'] ?>"></td>
										</tr>
										<tr>
											<td class="eml" rowspan=2>3.2 Product Knowledge</td>		
											<td>3.2.a. Agent is familiar with ourproducts<br> and provides accurate information.</td>
											<td>
												<select class="form-control" id ="" style="width: 200px;" name="data[cmt12]" required>
													<option <?php echo $sea_world_chat_data['cmt12'] == "Agent displays knowledge of our products." ? "selected" : ""; ?> value="Agent displays knowledge of our products.">Agent displays knowledge of our products.</option>
													<option <?php echo $sea_world_chat_data['cmt12'] == "Agent provides the guest with information that is correct, ensuring accuracy in responses and enhancing the guest experience." ? "selected" : ""; ?> value="Agent provides the guest with information that is correct, ensuring accuracy in responses and enhancing the guest experience.">Agent provides the guest with information that is correct, ensuring accuracy in responses and enhancing the guest experience.</option>
												</select>
											</td>
											<td>8</td>
											<td>
												<select class="form-control sea_world_chat_point" id ="" name="data[accurate_information]" required>
													
													<option sea_world_chat_val=8 sea_world_chat_max="8" <?php echo $sea_world_chat_data['accurate_information'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option sea_world_chat_val=0 sea_world_chat_max="8" <?php echo $sea_world_chat_data['accurate_information'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													<option sea_world_chat_val=8 sea_world_chat_max="8" <?php echo $sea_world_chat_data['accurate_information'] == "NA" ? "selected" : ""; ?> value="NA">NA</option>
												</select>
											</td>
											<td><input type="text" name="data[remarks12]" class="form-control" value="<?php echo $sea_world_chat_data['remarks12'] ?>"></td>
										</tr>
										<tr>		
											<td>3.2.b. Agent presents a sense of<br> urgency whenever applicable.</td>
											<td>
												<select class="form-control" id ="" style="width: 200px;" name="data[cmt13]" required>
													<option <?php echo $sea_world_chat_data['cmt13'] == "Ensures the guest is aware that prices and availability are subject to change by explaining dynamic pricing. " ? "selected" : ""; ?> value="Ensures the guest is aware that prices and availability are subject to change by explaining dynamic pricing. ">Ensures the guest is aware that prices and availability are subject to change by explaining dynamic pricing. </option>
												</select>
											</td>
											<td>4</td>
											<td>
												<select class="form-control sea_world_chat_point" id ="" name="data[sense_urgency]" required>
													
													<option sea_world_chat_val=4 sea_world_chat_max="4" <?php echo $sea_world_chat_data['sense_urgency'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option sea_world_chat_val=0 sea_world_chat_max="4" <?php echo $sea_world_chat_data['sense_urgency'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													<option sea_world_chat_val=4 sea_world_chat_max="4" <?php echo $sea_world_chat_data['sense_urgency'] == "NA" ? "selected" : ""; ?> value="NA">NA</option>
												</select>
											</td>
											<td><input type="text" name="data[remarks13]" class="form-control" value="<?php echo $sea_world_chat_data['remarks13'] ?>">
											</td>
										</tr>
										<tr>
											<td class="eml" rowspan=3>3.3 Call Efficiency</td>				
											<td>3.3.a. Agent handles chat efficiently<br> through effective navigation and by<br> not going over irrelevant products or information.</td>
											<td>
												<select class="form-control" id ="" style="width: 200px;" name="data[cmt14]" required>
													<option <?php echo $sea_world_chat_data['cmt14'] == "Agent sticks to what is necessary to resolve the call." ? "selected" : ""; ?> value="Agent sticks to what is necessary to resolve the call.">Agent sticks to what is necessary to resolve the call.</option>
													<option <?php echo $sea_world_chat_data['cmt14'] == "This includes tasks such as de-escalating an upset guest, answering questions, and making sales when applicable." ? "selected" : ""; ?> value="This includes tasks such as de-escalating an upset guest, answering questions, and making sales when applicable.">This includes tasks such as de-escalating an upset guest, answering questions, and making sales when applicable.</option>
													<option <?php echo $sea_world_chat_data['cmt14'] == "Agent focuses on using the best identifiers to locate orders/accounts, prioritizing options such as barcode or order number, and phone number." ? "selected" : ""; ?> value="Agent focuses on using the best identifiers to locate orders/accounts, prioritizing options such as barcode or order number, and phone number.">Agent focuses on using the best identifiers to locate orders/accounts, prioritizing options such as barcode or order number, and phone number.</option>
													<option <?php echo $sea_world_chat_data['cmt14'] == "Does not going over irrelevant products or information." ? "selected" : ""; ?> value="Does not going over irrelevant products or information.">Does not going over irrelevant products or information.</option>
													<option <?php echo $sea_world_chat_data['cmt14'] == "Does not over verify the pass , by reviewing more then two pieces of information." ? "selected" : ""; ?> value="Does not over verify the pass , by reviewing more then two pieces of information.">Does not over verify the pass , by reviewing more then two pieces of information.</option>
												</select>
											</td>
											<td>6</td>
											<td>
												<select class="form-control sea_world_chat_point" id ="" name="data[handles_chat_efficiently]" required>
													
													<option sea_world_chat_val=6 sea_world_chat_max="6" <?php echo $sea_world_chat_data['handles_chat_efficiently'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option sea_world_chat_val=0 sea_world_chat_max="6" <?php echo $sea_world_chat_data['handles_chat_efficiently'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													<option sea_world_chat_val=6 sea_world_chat_max="6" <?php echo $sea_world_chat_data['handles_chat_efficiently'] == "NA" ? "selected" : ""; ?> value="NA">NA</option>
												</select>
											</td>
											<td><input type="text" name="data[remarks14]" class="form-control" value="<?php echo $sea_world_chat_data['remarks14'] ?>">
											</td>
										</tr>
										<tr>				
											<td>3.3.b. Uses Proper Hold Procedures.</td>
											<td>
												<select class="form-control" id ="" style="width: 200px;" name="data[cmt15]" required>
													<option <?php echo $sea_world_chat_data['cmt15'] == "Must request approval to step away from the chat." ? "selected" : ""; ?> value="Must request approval to step away from the chat.">Must request approval to step away from the chat.</option>
													<option <?php echo $sea_world_chat_data['cmt15'] == "Must inform the guest of the time they plan to return." ? "selected" : ""; ?> value="Must inform the guest of the time they plan to return.">Must inform the guest of the time they plan to return.</option>
													<option <?php echo $sea_world_chat_data['cmt15'] == "Must come back to the chat to touch base 2 minutes after the last response, keeping the guest informed and engaged." ? "selected" : ""; ?> value="Must come back to the chat to touch base 2 minutes after the last response, keeping the guest informed and engaged.">Must come back to the chat to touch base 2 minutes after the last response, keeping the guest informed and engaged.</option>
												</select>
											</td>
											<td>8</td>
											<td>
												<select class="form-control sea_world_chat_point" id ="" name="data[hold_procedures]" required>
													
													<option sea_world_chat_val=8 sea_world_chat_max="8" <?php echo $sea_world_chat_data['hold_procedures'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option sea_world_chat_val=0 sea_world_chat_max="8" <?php echo $sea_world_chat_data['hold_procedures'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													<option sea_world_chat_val=8 sea_world_chat_max="8" <?php echo $sea_world_chat_data['hold_procedures'] == "NA" ? "selected" : ""; ?> value="NA">NA</option>
												</select>
											</td>
											<td><input type="text" name="data[remarks15]" class="form-control" value="<?php echo $sea_world_chat_data['remarks15'] ?>">
											</td>
										</tr>
										<tr>				
											<td>3.3.c. Ambassador minimized or eliminated<br> dead time on Chat.</td>
											<td>
												<select class="form-control" id ="" style="width: 200px;" name="data[cmt16]" required>
													<option <?php echo $sea_world_chat_data['cmt16'] == "Must type a response in the chat by the next following minute of the last response made." ? "selected" : ""; ?> value="Must type a response in the chat by the next following minute of the last response made.">Must type a response in the chat by the next following minute of the last response made.</option>
													<option <?php echo $sea_world_chat_data['cmt16'] == "The response cannot consist of mere filler words." ? "selected" : ""; ?> value="The response cannot consist of mere filler words.">The response cannot consist of mere filler words.</option>
													<option <?php echo $sea_world_chat_data['cmt16'] == "The response must contribute to the reason for the chat, which is typically about SeaWorld products." ? "selected" : ""; ?> value="The response must contribute to the reason for the chat, which is typically about SeaWorld products.">The response must contribute to the reason for the chat, which is typically about SeaWorld products.</option>
													<option <?php echo $sea_world_chat_data['cmt16'] == "The response should aim to build rapport with the guest, ensuring a positive interaction." ? "selected" : ""; ?> value="The response should aim to build rapport with the guest, ensuring a positive interaction.">The response should aim to build rapport with the guest, ensuring a positive interaction.</option>
												</select>
											</td>
											<td>4</td>
											<td>
												<select class="form-control sea_world_chat_point" id ="" name="data[dead_time]" required>
													
													<option sea_world_chat_val=4 sea_world_chat_max="4" <?php echo $sea_world_chat_data['dead_time'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option sea_world_chat_val=0 sea_world_chat_max="4" <?php echo $sea_world_chat_data['dead_time'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													<option sea_world_chat_val=4 sea_world_chat_max="4" <?php echo $sea_world_chat_data['dead_time'] == "NA" ? "selected" : ""; ?> value="NA">NA</option>
												</select>
											</td>
											<td><input type="text" name="data[remarks16]" class="form-control" value="<?php echo $sea_world_chat_data['remarks16'] ?>">
											</td>
										</tr>
										<tr>
											<td class="eml" rowspan=6>Compliance (auto-fail items)</td>					
											<td colspan="2" style="color:red">Qualifies park by city/state</td>
											<td></td>
											<td>
												<select class="form-control sea_world_chat_point" id ="seaworldChatAF1" name="data[qualifies_park]" required>
													
													<option sea_world_chat_val=0 sea_world_chat_max="0" <?php echo $sea_world_chat_data['qualifies_park'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option sea_world_chat_val=0 sea_world_chat_max="0" <?php echo $sea_world_chat_data['qualifies_park'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
												</select>
											</td>
											<td><input type="text" name="data[remarks17]" class="form-control" value="<?php echo $sea_world_chat_data['remarks17'] ?>">
											</td>
										</tr>
										<tr>				
											<td colspan="2" style="color:red">Explains EZpay Contract / Explains<br>cancelation policies</td>
											<td></td>
											<td>
												<select class="form-control sea_world_chat_point" id ="seaworldChatAF2" name="data[cancelation_policies]" required>
													
													<option sea_world_chat_val=0 sea_world_chat_max="0" <?php echo $sea_world_chat_data['cancelation_policies'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option sea_world_chat_val=0 sea_world_chat_max="0" <?php echo $sea_world_chat_data['cancelation_policies'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
												</select>
											</td>
											<td><input type="text" name="data[remarks18]" class="form-control" value="<?php echo $sea_world_chat_data['remarks18'] ?>">
											</td>
										</tr>
										<tr>				
											<td colspan="2" style="color:red">Customer focused at all times <br>(Does not use Rude or Offensive langauge )</td>
											<td></td>
											<td>
												<select class="form-control sea_world_chat_point" id ="seaworldChatAF3" name="data[customer_focused]" required>
													
													<option sea_world_chat_val=0 sea_world_chat_max="0" <?php echo $sea_world_chat_data['customer_focused'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option sea_world_chat_val=0 sea_world_chat_max="0" <?php echo $sea_world_chat_data['customer_focused'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
												</select>
											</td>
											<td><input type="text" name="data[remarks19]" class="form-control" value="<?php echo $sea_world_chat_data['remarks19'] ?>">
											</td>
										</tr>
										<tr>				
											<td colspan="2" style="color:red">Uses the correct Disposition Code</td>
											<td></td>
											<td>
												<select class="form-control sea_world_chat_point" id ="seaworldChatAF4" name="data[correct_disposition]" required>
													
													<option sea_world_chat_val=0 sea_world_chat_max="0" <?php echo $sea_world_chat_data['correct_disposition'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option sea_world_chat_val=0 sea_world_chat_max="0" <?php echo $sea_world_chat_data['correct_disposition'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
												</select>
											</td>
											<td><input type="text" name="data[remarks20]" class="form-control" value="<?php echo $sea_world_chat_data['remarks20'] ?>">
											</td>
										</tr>
										<tr>				
											<td colspan="2" style="color:red">Follows all PCI Policies <br>( Can't Share CC info )</td>
											<td></td>
											<td>
												<select class="form-control sea_world_chat_point" id ="seaworldChatAF5" name="data[PCI_policies]" required>
													
													<option sea_world_chat_val=0 sea_world_chat_max="0" <?php echo $sea_world_chat_data['PCI_policies'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option sea_world_chat_val=0 sea_world_chat_max="0" <?php echo $sea_world_chat_data['PCI_policies'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
												</select>
											</td>
											<td><input type="text" name="data[remarks21]" class="form-control" value="<?php echo $sea_world_chat_data['remarks21'] ?>">
											</td>
										</tr>
										<tr>				
											<td colspan="2" style="color:red">Leaves COMPLETE notes in all<br> accounts/orders
 											- Agent leaves all <br>names of Leadership that they may have<br> gotten direction from for the issue<br> the guest is calling for<br>
 											- Agent leaves all details of the<br> call on the account or order.<br>
 											- Agent should think of being the <br>next agent contacted from the guest<br> about the same issue.<br> Being the next agent, you will<br> want to know what, why, and <br>the solution was of the call.</td>
											<td></td>
											<td>
												<select class="form-control sea_world_chat_point" id ="seaworldChatAF6" name="data[complete_notes]" required>
													
													<option sea_world_chat_val=0 sea_world_chat_max="0" <?php echo $sea_world_chat_data['complete_notes'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option sea_world_chat_val=0 sea_world_chat_max="0" <?php echo $sea_world_chat_data['complete_notes'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
												</select>
											</td>
											<td><input type="text" name="data[remarks22]" class="form-control" value="<?php echo $sea_world_chat_data['remarks22'] ?>">
											</td>
										</tr>

										<tr>
											<td>Call Summary:</td>
											<td colspan=3><textarea class="form-control" name="data[call_summary]"><?php echo $sea_world_chat_data['call_summary'] ?></textarea></td>
											<td>Feedback:</td>
											<td colspan=4><textarea class="form-control" name="data[feedback]"><?php echo $sea_world_chat_data['feedback'] ?></textarea></td>
										</tr>
										<tr>
											<td colspan=2>Upload Files [m4a,mp4,mp3,wav]</td>
											<?php if ($sea_world_id == 0) { ?>
												<td colspan=6>
													<input type="file" name="attach_file[]" id="attach_file" accept=".m4a,.mp4,.mp3,.wav,audio/*" />
												</td>
												<?php } else {
												if ($sea_world_chat_data['attach_file'] != '') { ?>
													<td colspan=6>
														<input type="file" multiple class="form-control"  id="attach_file" name="attach_file[]" accept=".m4a,.mp4,.mp3,.wav,audio/*"> 
														<?php $attach_file = explode(",", $sea_world_chat_data['attach_file']);
														foreach ($attach_file as $mp) { ?>
															<audio controls='' style="background-color:#607F93">
																<source src="<?php echo base_url(); ?>qa_files/sea_world/<?php echo $mp; ?>" type="audio/ogg">
																<source src="<?php echo base_url(); ?>qa_files/sea_world/<?php echo $mp; ?>" type="audio/mpeg">
															</audio> </br>
														<?php } ?>
													</td>
											<?php } else {
													echo '<td colspan=6>
													<input type="file" multiple class="form-control" id="attach_file" name="attach_file[]" accept=".m4a,.mp4,.mp3,.wav,audio/*">
													<b>No Files</b></td>';
												}
											} ?>
										</tr>

										<?php if ($sea_world_id != 0) { ?>
											<tr>
												<td colspan=2 style="font-size:16px; font-weight:bold">Agent Feedback Acceptance:</td>
												<td colspan=6><?php echo $sea_world_chat_data['agnt_fd_acpt'] ?></td>
											</tr>
											<tr>
												<td colspan=2 style="font-size:16px; font-weight:bold">Agent Review:</td>
												<td colspan=6><?php echo $sea_world_chat_data['agent_rvw_note'] ?></td>
											</tr>
											<tr>
												<td colspan=2 style="font-size:16px; font-weight:bold">Management Review:</td>
												<td colspan=6><?php echo $sea_world_chat_data['mgnt_rvw_note'] ?></td>
											</tr>
											<tr>
												<td colspan=2 style="font-size:16px; font-weight:bold">Client Review:</td>
												<td colspan=6><?php echo $sea_world_chat_data['client_rvw_note'] ?></td>
											</tr>

											<tr>
												<td colspan=2 style="font-size:16px">Your Review<span style="font-size:24px;color:red">*</span></td>
												<td colspan=6><textarea class="form-control1" style="width:100%" id="note" name="note" required></textarea></td>
											</tr>
										<?php } ?>

										<?php
										if ($sea_world_id == 0) {
											if (is_access_qa_module() == true || is_access_qa_operations_module() == true) { ?>
												<tr>
													<td colspan=8><button class="btn btn-success blains-effect" type="submit" id="qaformsubmit" style="width:500px;margin:auto;display:block;">SAVE</button></td>
												</tr>
												<?php
											}
										} else {
											if (is_access_qa_module() == true || is_access_qa_operations_module() == true) {
												if (is_available_qa_feedback($sea_world_chat_data['entry_date'], 72) == true) { ?>
													<tr>
														<td colspan="8"><button class="btn btn-success blains-effect" type="submit" id='qaformsubmit' name='btnSave' value="SAVE" style="width:500px;margin:auto;display:block;">SAVE</button></td>
													</tr>
										<?php
												}
											}
										}
										?>

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