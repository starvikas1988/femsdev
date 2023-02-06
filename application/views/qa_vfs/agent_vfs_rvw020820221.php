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
									<tr><td colspan=6 id="theader">VFS <?php echo ucfirst($campaign) ?> Monitoring Form</td></tr>
									
									<tr>
										<td>QA Name:</td>
										<?php if($agent_vfs['entry_by']!=''){
												$auditorName = $agent_vfs['auditor_name'];
											}else{
												$auditorName = $agent_vfs['client_name'];
										} ?>
										<td style="width:300px"><input type="text" class="form-control" value="<?php echo $auditorName; ?>" disabled></td>
										<td style="width:150px">Audit Date:</td>
										<td><input type="text" class="form-control" value="<?php echo mmddyy2mysql($agent_vfs['audit_date']); ?>" disabled></td>
										<td>Date Of <?php echo ucfirst($campaign) ?>:</td>
										<td><input type="text" class="form-control" id="" name="" value="<?php echo mmddyy2mysql($agent_vfs['call_date']); ?>" disabled></td>
									</tr>
									<tr>
										<td>Employee Name:</td>
										<td>
											<select class="form-control" id="" name="" disabled>
												<option><?php echo $agent_vfs['fname']." ".$agent_vfs['lname'] ?></option>
											</select>
										</td>
										<td>Fusion ID:</td>
										<td><input type="text" class="form-control" id="" name="" value="<?php echo $agent_vfs['fusion_id']; ?>" disabled></td>
										<td>L1 Supervisor:</td>
										<td style="width:250px">
											<select class="form-control" id="" name="" disabled>
												<option><?php echo $agent_vfs['tl_name'] ?></option>	
											</select>
										</td>
									</tr>
									<tr>
										<td><?php echo ucfirst($campaign) ?> Duration:</td>
										<td><input type="text" class="form-control" id="" name="" value="<?php echo $agent_vfs['call_duration']; ?>" disabled></td>
										<td>Mission:</td>
										<td><input type="text" class="form-control" id="" name="" value="<?php echo $agent_vfs['mission']; ?>" disabled></td>
										<td>Recording ID:</td>
										<td><input type="text" class="form-control" id="" name="" value="<?php echo $agent_vfs['recording_id']; ?>" disabled></td>
									</tr>
									<tr>
										<td>Week:</td>
										<td>
											<select class="form-control" id="" name="" disabled><option><?php echo $agent_vfs['week'] ?></option></select>
										</td>
										<td>Audit Type:</td>
										<td>
											<select class="form-control" id="" name="" disabled><option value=""><?php echo $agent_vfs['audit_type'] ?></option></select>
										</td>
										<td>VOC:</td>
										<td>
											<select class="form-control" id="" name="" disabled><option><?php echo $agent_vfs['voc'] ?></option></select>
										</td>
									</tr>
									<tr>
										<td style="font-weight:bold">Total Score:</td>
										<td><input type="text" readonly id="" name="" class="form-control" style="font-weight:bold" value="<?php echo $agent_vfs['earned_score'] ?>"></td>
										<td style="font-weight:bold">Target:</td>
										<td><input type="text" readonly id="" name="" class="form-control" style="font-weight:bold" value="<?php echo $agent_vfs['possible_score'] ?>"></td>
										<td style="font-weight:bold">Overall Score Percentage:</td>
										<td><input type="text" readonly id="" name="" class="form-control" style="font-weight:bold" value="<?php echo $agent_vfs['overall_score'] ?>"></td>
									</tr>
									<tr style="font-weight:bold; background-color:#2471A3; color:white">
										<td colspan=4>Parameters</td>
										<td>Weightage</td>
										<td>Rating</td>
									</tr>
									
									<?php if($campaign=='chat'){ ?>
									
										<tr>
											<td style="background-color:#BFC9CA"><b>1. Opening</b></td>
											<td colspan=3>a. Appropriate greeting - as per script</td>
											<td>4</td>
											<td>
												<select class="form-control vfsVal" id="" name="appropiate_greeting" disabled>
													<option vfs_val=4 <?php echo $agent_vfs['appropiate_greeting']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
													<option vfs_val=4 <?php echo $agent_vfs['appropiate_greeting']=='No'?"selected":""; ?> value="No">No</option>
													<option vfs_val=0 <?php echo $agent_vfs['appropiate_greeting']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
												</select>
											</td>
										</tr>
										<tr>
											<td rowspan=7 style="background-color:#BFC9CA"><b>2. Technical aspects</b></td>
											<td colspan=3>a. Response Time</td>
											<td>5</td>
											<td>
												<select class="form-control vfsVal" id="" name="response_time" disabled>
													<option vfs_val=5 <?php echo $agent_vfs['response_time']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
													<option vfs_val=5 <?php echo $agent_vfs['response_time']=='No'?"selected":""; ?> value="No">No</option>
													<option vfs_val=0 <?php echo $agent_vfs['response_time']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
												</select>
											</td>
										</tr>
										<tr>
											<td colspan=3>b. FCR achieved</td>
											<td>5</td>
											<td>
												<select class="form-control vfsVal" id="" name="FCR_achieved" disabled>
													<option vfs_val=5 <?php echo $agent_vfs['FCR_achieved']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
													<option vfs_val=5 <?php echo $agent_vfs['FCR_achieved']=='No'?"selected":""; ?> value="No">No</option>
													<option vfs_val=0 <?php echo $agent_vfs['FCR_achieved']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
												</select>
											</td>
										</tr>
										<tr>
											<td colspan=3>c. Understand the issue of the applicant</td>
											<td>8</td>
											<td>
												<select class="form-control vfsVal" id="" name="understand_issue" disabled>
													<option vfs_val=8 <?php echo $agent_vfs['understand_issue']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
													<option vfs_val=8 <?php echo $agent_vfs['understand_issue']=='No'?"selected":""; ?> value="No">No</option>
													<option vfs_val=0 <?php echo $agent_vfs['understand_issue']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
												</select>
											</td>
										</tr>
										<tr>
											<td colspan=3>d. Attentiveness displayed</td>
											<td>5</td>
											<td>
												<select class="form-control vfsVal" id="" name="attentiveness_display" disabled>
													<option vfs_val=5 <?php echo $agent_vfs['attentiveness_display']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
													<option vfs_val=5 <?php echo $agent_vfs['attentiveness_display']=='No'?"selected":""; ?> value="No">No</option>
													<option vfs_val=0 <?php echo $agent_vfs['attentiveness_display']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
												</select>
											</td>
										</tr>
										<tr>
											<td colspan=3>e.Paraphrasing</td>
											<td>5</td>
											<td>
												<select class="form-control vfsVal" id="" name="paraphrasing" disabled>
													<option vfs_val=5 <?php echo $agent_vfs['paraphrasing']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
													<option vfs_val=5 <?php echo $agent_vfs['paraphrasing']=='No'?"selected":""; ?> value="No">No</option>
													<option vfs_val=0 <?php echo $agent_vfs['paraphrasing']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
												</select>
											</td>
										</tr>
										<tr>
											<td colspan=3>f. Used all the available resources for providing resolution</td>
											<td>5</td>
											<td>
												<select class="form-control vfsVal" id="" name="use_available_resource" disabled>
													<option vfs_val=5 <?php echo $agent_vfs['use_available_resource']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
													<option vfs_val=5 <?php echo $agent_vfs['use_available_resource']=='No'?"selected":""; ?> value="No">No</option>
													<option vfs_val=0 <?php echo $agent_vfs['use_available_resource']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
												</select>
											</td>
										</tr>
										<tr>
											<td colspan=3>g. Appropriate Probing</td>
											<td>5</td>
											<td>
												<select class="form-control vfsVal" id="" name="appropiate_probing" disabled>
													<option vfs_val=5 <?php echo $agent_vfs['appropiate_probing']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
													<option vfs_val=5 <?php echo $agent_vfs['appropiate_probing']=='No'?"selected":""; ?> value="No">No</option>
													<option vfs_val=0 <?php echo $agent_vfs['appropiate_probing']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
												</select>
											</td>
										</tr>
										<tr>
											<td rowspan=2 style="background-color:#BFC9CA"><b>3. Additions</b></td>
											<td colspan=3>a. Offers VAS options wherever applicable</td>
											<td>10</td>
											<td>
												<select class="form-control vfsVal" id="" name="VAS_options" disabled>
													<option vfs_val=10 <?php echo $agent_vfs['VAS_options']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
													<option vfs_val=10 <?php echo $agent_vfs['VAS_options']=='No'?"selected":""; ?> value="No">No</option>
													<option vfs_val=0 <?php echo $agent_vfs['VAS_options']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
												</select>
											</td>
										</tr>
										<tr>
											<td colspan=3>b. Awareness created with regards to VFS website (wherever applicable)</td>
											<td>4</td>
											<td>
												<select class="form-control vfsVal" id="" name="awareness_created" disabled>
													<option vfs_val=4 <?php echo $agent_vfs['awareness_created']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
													<option vfs_val=4 <?php echo $agent_vfs['awareness_created']=='No'?"selected":""; ?> value="No">No</option>
													<option vfs_val=0 <?php echo $agent_vfs['awareness_created']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
												</select>
											</td>
										</tr>
										<tr>
											<td rowspan=2 style="background-color:#BFC9CA"><b>4. Documentation</b></td>
											<td colspan=3>a. Correct dispostion</td>
											<td>5</td>
											<td>
												<select class="form-control vfsVal" id="" name="correct_disposition" disabled>
													<option vfs_val=5 <?php echo $agent_vfs['correct_disposition']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
													<option vfs_val=5 <?php echo $agent_vfs['correct_disposition']=='No'?"selected":""; ?> value="No">No</option>
													<option vfs_val=0 <?php echo $agent_vfs['correct_disposition']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
												</select>
											</td>
										</tr>
										<tr>
											<td colspan=3>b. Update ASM/V2</td>
											<td>5</td>
											<td>
												<select class="form-control vfsVal" id="" name="update_ASM" disabled>
													<option vfs_val=5 <?php echo $agent_vfs['update_ASM']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
													<option vfs_val=5 <?php echo $agent_vfs['update_ASM']=='No'?"selected":""; ?> value="No">No</option>
													<option vfs_val=0 <?php echo $agent_vfs['update_ASM']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
												</select>
											</td>
										</tr>
										<tr>
											<td rowspan=2 style="background-color:#BFC9CA"><b>5. Hold Protocol</b></td>
											<td colspan=3>a. Was Hold disabled</td>
											<td>2</td>
											<td>
												<select class="form-control vfsVal" id="" name="hold_disabled" disabled>
													<option vfs_val=2 <?php echo $agent_vfs['hold_disabled']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
													<option vfs_val=2 <?php echo $agent_vfs['hold_disabled']=='No'?"selected":""; ?> value="No">No</option>
													<option vfs_val=0 <?php echo $agent_vfs['hold_disabled']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
												</select>
											</td>
										</tr>
										<tr>
											<td colspan=3>b. Hold Guidelines followed</td>
											<td>1</td>
											<td>
												<select class="form-control vfsVal" id="" name="hold_guidelines" disabled>
													<option vfs_val=1 <?php echo $agent_vfs['hold_guidelines']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
													<option vfs_val=1 <?php echo $agent_vfs['hold_guidelines']=='No'?"selected":""; ?> value="No">No</option>
													<option vfs_val=0 <?php echo $agent_vfs['hold_guidelines']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
												</select>
											</td>
										</tr>
										<tr>
											<td rowspan=6 style="background-color:#BFC9CA"><b>6. Communication</b></td>
											<td colspan=3>a. Formatting</td>
											<td>5</td>
											<td>
												<select class="form-control vfsVal" id="" name="formatting" disabled>
													<option vfs_val=5 <?php echo $agent_vfs['formatting']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
													<option vfs_val=5 <?php echo $agent_vfs['formatting']=='No'?"selected":""; ?> value="No">No</option>
													<option vfs_val=0 <?php echo $agent_vfs['formatting']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
												</select>
											</td>
										</tr>
										<tr>
											<td colspan=3>b. Avoid Negative statements</td>
											<td>5</td>
											<td>
												<select class="form-control vfsVal" id="" name="avoid_negative_statement" disabled>
													<option vfs_val=5 <?php echo $agent_vfs['avoid_negative_statement']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
													<option vfs_val=5 <?php echo $agent_vfs['avoid_negative_statement']=='No'?"selected":""; ?> value="No">No</option>
													<option vfs_val=0 <?php echo $agent_vfs['avoid_negative_statement']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
												</select>
											</td>
										</tr>
										<tr>
											<td colspan=3>c. Telling the customer what to do next, Step by step procedure guide</td>
											<td>5</td>
											<td>
												<select class="form-control vfsVal" id="" name="procedure_guide_step" disabled>
													<option vfs_val=5 <?php echo $agent_vfs['procedure_guide_step']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
													<option vfs_val=5 <?php echo $agent_vfs['procedure_guide_step']=='No'?"selected":""; ?> value="No">No</option>
													<option vfs_val=0 <?php echo $agent_vfs['procedure_guide_step']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
												</select>
											</td>
										</tr>
										<tr>
											<td colspan=3>d. Avoid Slangs & Jargons</td>
											<td>5</td>
											<td>
												<select class="form-control vfsVal" id="" name="avoid_slangs" disabled>
													<option vfs_val=5 <?php echo $agent_vfs['avoid_slangs']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
													<option vfs_val=5 <?php echo $agent_vfs['avoid_slangs']=='No'?"selected":""; ?> value="No">No</option>
													<option vfs_val=0 <?php echo $agent_vfs['avoid_slangs']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
												</select>
											</td>
										</tr>
										<tr>
											<td colspan=3>e. Correct and accurate grammar usage</td>
											<td>6</td>
											<td>
												<select class="form-control vfsVal" id="" name="correct_grammar_use" disabled>
													<option vfs_val=6 <?php echo $agent_vfs['correct_grammar_use']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
													<option vfs_val=6 <?php echo $agent_vfs['correct_grammar_use']=='No'?"selected":""; ?> value="No">No</option>
													<option vfs_val=0 <?php echo $agent_vfs['correct_grammar_use']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
												</select>
											</td>
										</tr>
										<tr>
											<td colspan=3>f. Further assistance</td>
											<td>3</td>
											<td>
												<select class="form-control vfsVal" id="" name="further_assistance" disabled>
													<option vfs_val=3 <?php echo $agent_vfs['further_assistance']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
													<option vfs_val=3 <?php echo $agent_vfs['further_assistance']=='No'?"selected":""; ?> value="No">No</option>
													<option vfs_val=0 <?php echo $agent_vfs['further_assistance']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
												</select>
											</td>
										</tr>
										<tr>
											<td style="background-color:#BFC9CA"><b>7. Chat Closing</b></td>
											<td colspan=3>a. Adherence to chat closing script</td>
											<td>2</td>
											<td>
												<select class="form-control vfsVal" id="" name="chat_adherence" disabled>
													<option vfs_val=2 <?php echo $agent_vfs['chat_adherence']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
													<option vfs_val=2 <?php echo $agent_vfs['chat_adherence']=='No'?"selected":""; ?> value="No">No</option>
													<option vfs_val=0 <?php echo $agent_vfs['chat_adherence']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
												</select>
											</td>
										</tr>
										<tr>
											<td rowspan=4 style="background-color:#BFC9CA"><b>8. Fatal Parameter</b></td>
											<td colspan=3 style="background-color:#D98880">a. Delayed opening</td>
											<td></td>
											<td>
												<select class="form-control vfsVal" id="chatAutof1" name="delayed_opening" disabled>
													<option vfs_val=0 <?php echo $agent_vfs['delayed_opening']=='No'?"selected":""; ?> value="No">No</option>
													<option vfs_val=0 <?php echo $agent_vfs['delayed_opening']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												</select>
											</td>
										</tr>
										<tr>
											<td colspan=3 style="background-color:#D98880">b. Rude on chat</td>
											<td></td>
											<td>
												<select class="form-control vfsVal" id="chatAutof2" name="rude_on_chat" disabled>
													<option vfs_val=0 <?php echo $agent_vfs['rude_on_chat']=='No'?"selected":""; ?> value="No">No</option>
													<option vfs_val=0 <?php echo $agent_vfs['rude_on_chat']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												</select>
											</td>
										</tr>
										<tr>
											<td colspan=3 style="background-color:#D98880">c. Inaccurate / Incomplete Information</td>
											<td></td>
											<td>
												<select class="form-control vfsVal" id="chatAutof3" name="inacurate_information" disabled>
													<option vfs_val=0 <?php echo $agent_vfs['inacurate_information']=='No'?"selected":""; ?> value="No">No</option>
													<option vfs_val=0 <?php echo $agent_vfs['inacurate_information']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												</select>
											</td>
										</tr>
										<tr>
											<td colspan=3 style="background-color:#D98880">d. Complaint Avoidance</td>
											<td></td>
											<td>
												<select class="form-control vfsVal" id="chatAutof4" name="complaint_avoidance" disabled>
													<option vfs_val=0 <?php echo $agent_vfs['complaint_avoidance']=='No'?"selected":""; ?> value="No">No</option>
													<option vfs_val=0 <?php echo $agent_vfs['complaint_avoidance']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												</select>
											</td>
										</tr>
										<tr oncontextmenu="return false;">
											<td colspan=2>Upload Files</td>
											<?php if($agent_vfs['attach_file']!=''){ ?>
											<td colspan=4>
												<?php $attach_file = explode(",",$agent_vfs['attach_file']);
												 foreach($attach_file as $mp){ ?>
													<audio controls='' style="background-color:#607F93"> 
													  <source src="<?php echo base_url(); ?>qa_files/qa_vfs/chat/<?php echo $mp; ?>" type="audio/ogg">
													  <source src="<?php echo base_url(); ?>qa_files/qa_vfs/chat/<?php echo $mp; ?>" type="audio/mpeg">
													</audio> </br>
												 <?php } ?>
											</td>
											<?php }else{
													echo '<td><b>No Files</b></td>';
												  } 
											?>
										</tr>
									
									<?php }else if($campaign=='call'){ ?>
									
										<tr>
											<td rowspan=2 style="background-color:#BFC9CA"><b>1. Opening</b></td>
											<td colspan=3>a. Appropriate greeting - as per script</td>
											<td>2</td>
											<td>
												<select class="form-control vfsVal" id="" name="appropiate_greeting" disabled>
													<option vfs_val=2 <?php echo $agent_vfs['appropiate_greeting']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
													<option vfs_val=2 <?php echo $agent_vfs['appropiate_greeting']=='No'?"selected":""; ?> value="No">No</option>
													<option vfs_val=0 <?php echo $agent_vfs['appropiate_greeting']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
												</select>
											</td>
										</tr>
										<tr>
											<td colspan=3>b. Clear and Crisp opening</td>
											<td>2</td>
											<td>
												<select class="form-control vfsVal" id="" name="clear_opening" disabled>
													<option vfs_val=2 <?php echo $agent_vfs['clear_opening']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
													<option vfs_val=2 <?php echo $agent_vfs['clear_opening']=='No'?"selected":""; ?> value="No">No</option>
													<option vfs_val=0 <?php echo $agent_vfs['clear_opening']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
												</select>
											</td>
										</tr>
										<tr>
											<td rowspan=9 style="background-color:#BFC9CA"><b>2. Communication</b></td>
											<td colspan=3>a. Voice modulation</td>
											<td>3</td>
											<td>
												<select class="form-control vfsVal" id="" name="voice_modulation" disabled>
													<option vfs_val=3 <?php echo $agent_vfs['voice_modulation']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
													<option vfs_val=3 <?php echo $agent_vfs['voice_modulation']=='No'?"selected":""; ?> value="No">No</option>
													<option vfs_val=0 <?php echo $agent_vfs['voice_modulation']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
												</select>
											</td>
										</tr>
										<tr>
											<td colspan=3>b. Appropriate pace/Clarity of Speech</td>
											<td>3</td>
											<td>
												<select class="form-control vfsVal" id="" name="appropiate_pace" disabled>
													<option vfs_val=3 <?php echo $agent_vfs['appropiate_pace']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
													<option vfs_val=3 <?php echo $agent_vfs['appropiate_pace']=='No'?"selected":""; ?> value="No">No</option>
													<option vfs_val=0 <?php echo $agent_vfs['appropiate_pace']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
												</select>
											</td>
										</tr>
										<tr>
											<td colspan=3>c. Courteous and professional</td>
											<td>5</td>
											<td>
												<select class="form-control vfsVal" id="" name="professional_courteous" disabled>
													<option vfs_val=5 <?php echo $agent_vfs['professional_courteous']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
													<option vfs_val=5 <?php echo $agent_vfs['professional_courteous']=='No'?"selected":""; ?> value="No">No</option>
													<option vfs_val=0 <?php echo $agent_vfs['professional_courteous']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
												</select>
											</td>
										</tr>
										<tr>
											<td colspan=3>d. Empathy on call</td>
											<td>5</td>
											<td>
												<select class="form-control vfsVal" id="" name="call_empathy" disabled>
													<option vfs_val=5 <?php echo $agent_vfs['call_empathy']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
													<option vfs_val=5 <?php echo $agent_vfs['call_empathy']=='No'?"selected":""; ?> value="No">No</option>
													<option vfs_val=0 <?php echo $agent_vfs['call_empathy']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
												</select>
											</td>
										</tr>
										<tr>
											<td colspan=3>e. Adjusted to customer language</td>
											<td>3</td>
											<td>
												<select class="form-control vfsVal" id="" name="adjust_customer_language" disabled>
													<option vfs_val=3 <?php echo $agent_vfs['adjust_customer_language']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
													<option vfs_val=3 <?php echo $agent_vfs['adjust_customer_language']=='No'?"selected":""; ?> value="No">No</option>
													<option vfs_val=0 <?php echo $agent_vfs['adjust_customer_language']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
												</select>
											</td>
										</tr>
										<tr>
											<td colspan=3>f. No jargons - simple words used</td>
											<td>5</td>
											<td>
												<select class="form-control vfsVal" id="" name="simple_word_used" disabled>
													<option vfs_val=5 <?php echo $agent_vfs['simple_word_used']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
													<option vfs_val=5 <?php echo $agent_vfs['simple_word_used']=='No'?"selected":""; ?> value="No">No</option>
													<option vfs_val=0 <?php echo $agent_vfs['simple_word_used']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
												</select>
											</td>
										</tr>
										<tr>
											<td colspan=3>g. Active listening / Attentiveness</td>
											<td>5</td>
											<td>
												<select class="form-control vfsVal" id="" name="active_listening" disabled>
													<option vfs_val=5 <?php echo $agent_vfs['active_listening']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
													<option vfs_val=5 <?php echo $agent_vfs['active_listening']=='No'?"selected":""; ?> value="No">No</option>
													<option vfs_val=0 <?php echo $agent_vfs['active_listening']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
												</select>
											</td>
										</tr>
										<tr>
											<td colspan=3>h. Paraprashing</td>
											<td>5</td>
											<td>
												<select class="form-control vfsVal" id="" name="paraprasing" disabled>
													<option vfs_val=5 <?php echo $agent_vfs['paraprasing']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
													<option vfs_val=5 <?php echo $agent_vfs['paraprasing']=='No'?"selected":""; ?> value="No">No</option>
													<option vfs_val=0 <?php echo $agent_vfs['paraprasing']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
												</select>
											</td>
										</tr>
										<tr>
											<td colspan=3>i. Grammatically correct sentences & Avoid fumbling & Fillers</td>
											<td>5</td>
											<td>
												<select class="form-control vfsVal" id="" name="avoid_fumbling" disabled>
													<option vfs_val=5 <?php echo $agent_vfs['avoid_fumbling']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
													<option vfs_val=5 <?php echo $agent_vfs['avoid_fumbling']=='No'?"selected":""; ?> value="No">No</option>
													<option vfs_val=0 <?php echo $agent_vfs['avoid_fumbling']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
												</select>
											</td>
										</tr>
										<tr>
											<td rowspan=4 style="background-color:#BFC9CA"><b>3. Technical aspects</b></td>
											<td colspan=3>a. Appropriate Probing</td>
											<td>5</td>
											<td>
												<select class="form-control vfsVal" id="" name="appropiate_probing" disabled>
													<option vfs_val=5 <?php echo $agent_vfs['appropiate_probing']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
													<option vfs_val=5 <?php echo $agent_vfs['appropiate_probing']=='No'?"selected":""; ?> value="No">No</option>
													<option vfs_val=0 <?php echo $agent_vfs['appropiate_probing']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
												</select>
											</td>
										</tr>
										<tr>
											<td colspan=3>b. Escalate the issue wherever disabled</td>
											<td>3</td>
											<td>
												<select class="form-control vfsVal" id="" name="escalate_issue" disabled>
													<option vfs_val=3 <?php echo $agent_vfs['escalate_issue']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
													<option vfs_val=3 <?php echo $agent_vfs['escalate_issue']=='No'?"selected":""; ?> value="No">No</option>
													<option vfs_val=0 <?php echo $agent_vfs['escalate_issue']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
												</select>
											</td>
										</tr>
										<tr>
											<td colspan=3>c. Call control</td>
											<td>5</td>
											<td>
												<select class="form-control vfsVal" id="" name="call_control" disabled>
													<option vfs_val=5 <?php echo $agent_vfs['call_control']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
													<option vfs_val=5 <?php echo $agent_vfs['call_control']=='No'?"selected":""; ?> value="No">No</option>
													<option vfs_val=0 <?php echo $agent_vfs['call_control']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
												</select>
											</td>
										</tr>
										<tr>
											<td colspan=3>d. Query resolved on call - FTR</td>
											<td>6</td>
											<td>
												<select class="form-control vfsVal" id="" name="query_resolved" disabled>
													<option vfs_val=6 <?php echo $agent_vfs['query_resolved']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
													<option vfs_val=6 <?php echo $agent_vfs['query_resolved']=='No'?"selected":""; ?> value="No">No</option>
													<option vfs_val=0 <?php echo $agent_vfs['query_resolved']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
												</select>
											</td>
										</tr>
										<tr>
											<td rowspan=2 style="background-color:#BFC9CA"><b>4. Additons</b></td>
											<td colspan=3>a. Offers VAS options wherever applicable</td>
											<td>10</td>
											<td>
												<select class="form-control vfsVal" id="" name="offers_VAS" disabled>
													<option vfs_val=10 <?php echo $agent_vfs['offers_VAS']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
													<option vfs_val=10 <?php echo $agent_vfs['offers_VAS']=='No'?"selected":""; ?> value="No">No</option>
													<option vfs_val=0 <?php echo $agent_vfs['offers_VAS']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
												</select>
											</td>
										</tr>
										<tr>
											<td colspan=3>b. Awareness created with regards to VFS website (wherever applicable)</td>
											<td>4</td>
											<td>
												<select class="form-control vfsVal" id="" name="awareness_created" disabled>
													<option vfs_val=4 <?php echo $agent_vfs['awareness_created']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
													<option vfs_val=4 <?php echo $agent_vfs['awareness_created']=='No'?"selected":""; ?> value="No">No</option>
													<option vfs_val=0 <?php echo $agent_vfs['awareness_created']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
												</select>
											</td>
										</tr>
										<tr>
											<td rowspan=2 style="background-color:#BFC9CA"><b>5. Documentation</b></td>
											<td colspan=3>a. Correct dispostion</td>
											<td>5</td>
											<td>
												<select class="form-control vfsVal" id="" name="correct_disposition" disabled>
													<option vfs_val=5 <?php echo $agent_vfs['correct_disposition']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
													<option vfs_val=5 <?php echo $agent_vfs['correct_disposition']=='No'?"selected":""; ?> value="No">No</option>
													<option vfs_val=0 <?php echo $agent_vfs['correct_disposition']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
												</select>
											</td>
										</tr>
										<tr>
											<td colspan=3>b. Update ASM/V2</td>
											<td>5</td>
											<td>
												<select class="form-control vfsVal" id="" name="update_ASM" disabled>
													<option vfs_val=5 <?php echo $agent_vfs['update_ASM']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
													<option vfs_val=5 <?php echo $agent_vfs['update_ASM']=='No'?"selected":""; ?> value="No">No</option>
													<option vfs_val=0 <?php echo $agent_vfs['update_ASM']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
												</select>
											</td>
										</tr>
										<tr>
											<td rowspan=3 style="background-color:#BFC9CA"><b>6. Hold Protocol</b></td>
											<td colspan=3>a. Was Hold disabled</td>
											<td>2</td>
											<td>
												<select class="form-control vfsVal" id="" name="hold_required" disabled>
													<option vfs_val=2 <?php echo $agent_vfs['hold_required']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
													<option vfs_val=2 <?php echo $agent_vfs['hold_required']=='No'?"selected":""; ?> value="No">No</option>
													<option vfs_val=0 <?php echo $agent_vfs['hold_required']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
												</select>
											</td>
										</tr>
										<tr>
											<td colspan=3>b. Hold Guidelines followed</td>
											<td>1</td>
											<td>
												<select class="form-control vfsVal" id="" name="hold_guidelines" disabled>
													<option vfs_val=1 <?php echo $agent_vfs['hold_guidelines']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
													<option vfs_val=1 <?php echo $agent_vfs['hold_guidelines']=='No'?"selected":""; ?> value="No">No</option>
													<option vfs_val=0 <?php echo $agent_vfs['hold_guidelines']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
												</select>
											</td>
										</tr>
										<tr>
											<td colspan=3>c. Dead Air <= 8 seconds</td>
											<td>2</td>
											<td>
												<select class="form-control vfsVal" id="" name="dead_air_8sec" disabled>
													<option vfs_val=2 <?php echo $agent_vfs['dead_air_8sec']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
													<option vfs_val=2 <?php echo $agent_vfs['dead_air_8sec']=='No'?"selected":""; ?> value="No">No</option>
													<option vfs_val=0 <?php echo $agent_vfs['dead_air_8sec']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
												</select>
											</td>
										</tr>
										<tr>
											<td rowspan=3 style="background-color:#BFC9CA"><b>7. Call Closing</b></td>
											<td colspan=3>a. Further assistance</td>
											<td>2</td>
											<td>
												<select class="form-control vfsVal" id="" name="further_assistance" disabled>
													<option vfs_val=2 <?php echo $agent_vfs['further_assistance']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
													<option vfs_val=2 <?php echo $agent_vfs['further_assistance']=='No'?"selected":""; ?> value="No">No</option>
													<option vfs_val=0 <?php echo $agent_vfs['further_assistance']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
												</select>
											</td>
										</tr>
										<tr>
											<td colspan=3>b. Attempt to take feedback on experience  - CSAT</td>
											<td>5</td>
											<td>
												<select class="form-control vfsVal" id="" name="CSAT_experience_feedback" disabled>
													<option vfs_val=5 <?php echo $agent_vfs['CSAT_experience_feedback']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
													<option vfs_val=5 <?php echo $agent_vfs['CSAT_experience_feedback']=='No'?"selected":""; ?> value="No">No</option>
													<option vfs_val=0 <?php echo $agent_vfs['CSAT_experience_feedback']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
												</select>
											</td>
										</tr>
										<tr>
											<td colspan=3>c. Adherence to call closing script</td>
											<td>2</td>
											<td>
												<select class="form-control vfsVal" id="" name="call_adherence" disabled>
													<option vfs_val=2 <?php echo $agent_vfs['call_adherence']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
													<option vfs_val=2 <?php echo $agent_vfs['call_adherence']=='No'?"selected":""; ?> value="No">No</option>
													<option vfs_val=0 <?php echo $agent_vfs['call_adherence']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
												</select>
											</td>
										</tr>
										<tr>
											<td rowspan=4 style="background-color:#BFC9CA"><b>8. Fatal Parameter</b></td>
											<td colspan=3 style="background-color:#D98880">a. Delayed opening</td>
											<td></td>
											<td>
												<select class="form-control vfsVal" id="callAutof1" name="delayed_opening" disabled>
													<option vfs_val=0 <?php echo $agent_vfs['delayed_opening']=='No'?"selected":""; ?> value="No">No</option>
													<option vfs_val=0 <?php echo $agent_vfs['delayed_opening']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												</select>
											</td>
										</tr>
										<tr>
											<td colspan=3 style="background-color:#D98880">b. Rude on chat</td>
											<td></td>
											<td>
												<select class="form-control vfsVal" id="callAutof2" name="rude_on_call" disabled>
													<option vfs_val=0 <?php echo $agent_vfs['rude_on_call']=='No'?"selected":""; ?> value="No">No</option>
													<option vfs_val=0 <?php echo $agent_vfs['rude_on_call']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												</select>
											</td>
										</tr>
										<tr>
											<td colspan=3 style="background-color:#D98880">c. Incomplete/Inaccurate Information shared</td>
											<td></td>
											<td>
												<select class="form-control vfsVal" id="chatAutof3" name="incomplete_information" disabled>
													<option vfs_val=0 <?php echo $agent_vfs['incomplete_information']=='No'?"selected":""; ?> value="No">No</option>
													<option vfs_val=0 <?php echo $agent_vfs['incomplete_information']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												</select>
											</td>
										</tr>
										<tr>
											<td colspan=3 style="background-color:#D98880">d. Complaint Avoidance</td>
											<td></td>
											<td>
												<select class="form-control vfsVal" id="chatAutof4" name="complaint_avoidance" disabled>
													<option vfs_val=0 <?php echo $agent_vfs['complaint_avoidance']=='No'?"selected":""; ?> value="No">No</option>
													<option vfs_val=0 <?php echo $agent_vfs['complaint_avoidance']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												</select>
											</td>
										</tr>
										<tr oncontextmenu="return false;">
											<td colspan=2>Upload Files</td>
											<?php if($agent_vfs['attach_file']!=''){ ?>
											<td colspan=4>
												<?php $attach_file = explode(",",$agent_vfs['attach_file']);
												 foreach($attach_file as $mp){ ?>
													<audio controls='' style="background-color:#607F93"> 
													  <source src="<?php echo base_url(); ?>qa_files/qa_vfs/call/<?php echo $mp; ?>" type="audio/ogg">
													  <source src="<?php echo base_url(); ?>qa_files/qa_vfs/call/<?php echo $mp; ?>" type="audio/mpeg">
													</audio> </br>
												 <?php } ?>
											</td>
											<?php }else{
													echo '<td><b>No Files</b></td>';
												  } 
											?>
										</tr>
									
									<?php }else if($campaign=='email'){ ?>
									
										<tr>
											<td rowspan=4 style="background-color:#BFC9CA"><b>1. Content Writing (Look and feel)</b></td>
											<td colspan=3>a. Used one idea per paragraph</td>
											<td>2</td>
											<td>
												<select class="form-control vfsVal" id="" name="use_paragraph_idea" disabled>
													<option vfs_val=2 <?php echo $agent_vfs['use_paragraph_idea']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
													<option vfs_val=2 <?php echo $agent_vfs['use_paragraph_idea']=='No'?"selected":""; ?> value="No">No</option>
													<option vfs_val=0 <?php echo $agent_vfs['use_paragraph_idea']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
												</select>
											</td>
										</tr>
										<tr>
											<td colspan=3>b. Used bullet points where appropriate</td>
											<td>3</td>
											<td>
												<select class="form-control vfsVal" id="" name="use_bullet_point" disabled>
													<option vfs_val=3 <?php echo $agent_vfs['use_bullet_point']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
													<option vfs_val=3 <?php echo $agent_vfs['use_bullet_point']=='No'?"selected":""; ?> value="No">No</option>
													<option vfs_val=0 <?php echo $agent_vfs['use_bullet_point']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
												</select>
											</td>
										</tr>
										<tr>
											<td colspan=3>c. Adhered word limit per sentence</td>
											<td>2</td>
											<td>
												<select class="form-control vfsVal" id="" name="adhered_word_limit" disabled>
													<option vfs_val=2 <?php echo $agent_vfs['adhered_word_limit']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
													<option vfs_val=2 <?php echo $agent_vfs['adhered_word_limit']=='No'?"selected":""; ?> value="No">No</option>
													<option vfs_val=0 <?php echo $agent_vfs['adhered_word_limit']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
												</select>
											</td>
										</tr>
										<tr>
											<td colspan=3>d. Template Adherence where applicable</td>
											<td>3</td>
											<td>
												<select class="form-control vfsVal" id="" name="template_adherence" disabled>
													<option vfs_val=3 <?php echo $agent_vfs['template_adherence']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
													<option vfs_val=3 <?php echo $agent_vfs['template_adherence']=='No'?"selected":""; ?> value="No">No</option>
													<option vfs_val=0 <?php echo $agent_vfs['template_adherence']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
												</select>
											</td>
										</tr>
										<tr>
											<td rowspan=6 style="background-color:#BFC9CA"><b>2. Accuracy / follow up</b></td>
											<td colspan=3>a. Interim response provided (if applicable) & trail answered as per TAT provided</td>
											<td>3</td>
											<td>
												<select class="form-control vfsVal" id="" name="interim_responce" disabled>
													<option vfs_val=3 <?php echo $agent_vfs['interim_responce']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
													<option vfs_val=3 <?php echo $agent_vfs['interim_responce']=='No'?"selected":""; ?> value="No">No</option>
													<option vfs_val=0 <?php echo $agent_vfs['interim_responce']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
												</select>
											</td>
										</tr>
										<tr>
											<td colspan=3>b. FCR achieved</td>
											<td>9</td>
											<td>
												<select class="form-control vfsVal" id="" name="FCR_achieved" disabled>
													<option vfs_val=9 <?php echo $agent_vfs['FCR_achieved']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
													<option vfs_val=9 <?php echo $agent_vfs['FCR_achieved']=='No'?"selected":""; ?> value="No">No</option>
													<option vfs_val=0 <?php echo $agent_vfs['FCR_achieved']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
												</select>
											</td>
										</tr>
										<tr>
											<td colspan=3>c. Understand the issue of the applicant</td>
											<td>9</td>
											<td>
												<select class="form-control vfsVal" id="" name="understand_issue" disabled>
													<option vfs_val=9 <?php echo $agent_vfs['understand_issue']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
													<option vfs_val=9 <?php echo $agent_vfs['understand_issue']=='No'?"selected":""; ?> value="No">No</option>
													<option vfs_val=0 <?php echo $agent_vfs['understand_issue']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
												</select>
											</td>
										</tr>
										<tr>
											<td colspan=3>d. Attentiveness displayed</td>
											<td>6</td>
											<td>
												<select class="form-control vfsVal" id="" name="attentiveness_display" disabled>
													<option vfs_val=6 <?php echo $agent_vfs['attentiveness_display']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
													<option vfs_val=6 <?php echo $agent_vfs['attentiveness_display']=='No'?"selected":""; ?> value="No">No</option>
													<option vfs_val=0 <?php echo $agent_vfs['attentiveness_display']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
												</select>
											</td>
										</tr>
										<tr>
											<td colspan=3>e. Used all the available resources for providing resolution</td>
											<td>9</td>
											<td>
												<select class="form-control vfsVal" id="" name="use_available_resource" disabled>
													<option vfs_val=9 <?php echo $agent_vfs['use_available_resource']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
													<option vfs_val=9 <?php echo $agent_vfs['use_available_resource']=='No'?"selected":""; ?> value="No">No</option>
													<option vfs_val=0 <?php echo $agent_vfs['use_available_resource']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
												</select>
											</td>
										</tr>
										<tr>
											<td colspan=3>f. Standardized subject line on trail mails</td>
											<td>2</td>
											<td>
												<select class="form-control vfsVal" id="" name="standardized_subject" disabled>
													<option vfs_val=2 <?php echo $agent_vfs['standardized_subject']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
													<option vfs_val=2 <?php echo $agent_vfs['standardized_subject']=='No'?"selected":""; ?> value="No">No</option>
													<option vfs_val=0 <?php echo $agent_vfs['standardized_subject']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
												</select>
											</td>
										</tr>
										<tr>
											<td rowspan=2 style="background-color:#BFC9CA"><b>2. Additions</b></td>
											<td colspan=3>a. Offers VAS options wherever applicable</td>
											<td>10</td>
											<td>
												<select class="form-control vfsVal" id="" name="VAS_option" disabled>
													<option vfs_val=10 <?php echo $agent_vfs['VAS_option']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
													<option vfs_val=10 <?php echo $agent_vfs['VAS_option']=='No'?"selected":""; ?> value="No">No</option>
													<option vfs_val=0 <?php echo $agent_vfs['VAS_option']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
												</select>
											</td>
										</tr>
										<tr>
											<td colspan=3>b. Awareness created with regards to VFS website (wherever applicable)</td>
											<td>4</td>
											<td>
												<select class="form-control vfsVal" id="" name="awarreness_created" disabled>
													<option vfs_val=4 <?php echo $agent_vfs['awarreness_created']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
													<option vfs_val=4 <?php echo $agent_vfs['awarreness_created']=='No'?"selected":""; ?> value="No">No</option>
													<option vfs_val=0 <?php echo $agent_vfs['awarreness_created']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
												</select>
											</td>
										</tr>
										<tr>
											<td rowspan=2 style="background-color:#BFC9CA"><b>2. Documentation</b></td>
											<td colspan=3>a. Correct dispostion</td>
											<td>5</td>
											<td>
												<select class="form-control vfsVal" id="" name="correct_disposition" disabled>
													<option vfs_val=5 <?php echo $agent_vfs['correct_disposition']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
													<option vfs_val=5 <?php echo $agent_vfs['correct_disposition']=='No'?"selected":""; ?> value="No">No</option>
													<option vfs_val=0 <?php echo $agent_vfs['correct_disposition']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
												</select>
											</td>
										</tr>
										<tr>
											<td colspan=3>b. Update ASM/V2</td>
											<td>5</td>
											<td>
												<select class="form-control vfsVal" id="" name="update_ASM" disabled>
													<option vfs_val=5 <?php echo $agent_vfs['update_ASM']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
													<option vfs_val=5 <?php echo $agent_vfs['update_ASM']=='No'?"selected":""; ?> value="No">No</option>
													<option vfs_val=0 <?php echo $agent_vfs['update_ASM']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
												</select>
											</td>
										</tr>
										<tr>
											<td rowspan=7 style="background-color:#BFC9CA"><b>2. Composition</b></td>
											<td colspan=3>a. Formatting</td>
											<td>5</td>
											<td>
												<select class="form-control vfsVal" id="" name="formatting" disabled>
													<option vfs_val=5 <?php echo $agent_vfs['formatting']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
													<option vfs_val=5 <?php echo $agent_vfs['formatting']=='No'?"selected":""; ?> value="No">No</option>
													<option vfs_val=0 <?php echo $agent_vfs['formatting']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
												</select>
											</td>
										</tr>
										<tr>
											<td colspan=3>b. Shows respect and makes the customer feel valued</td>
											<td>5</td>
											<td>
												<select class="form-control vfsVal" id="" name="show_customer_feel_value" disabled>
													<option vfs_val=5 <?php echo $agent_vfs['show_customer_feel_value']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
													<option vfs_val=5 <?php echo $agent_vfs['show_customer_feel_value']=='No'?"selected":""; ?> value="No">No</option>
													<option vfs_val=0 <?php echo $agent_vfs['show_customer_feel_value']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
												</select>
											</td>
										</tr>
										<tr>
											<td colspan=3>c. Telling the customer what to do next, Step by step procedure guide</td>
											<td>3</td>
											<td>
												<select class="form-control vfsVal" id="" name="procedure_guide_step" disabled>
													<option vfs_val=3 <?php echo $agent_vfs['procedure_guide_step']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
													<option vfs_val=3 <?php echo $agent_vfs['procedure_guide_step']=='No'?"selected":""; ?> value="No">No</option>
													<option vfs_val=0 <?php echo $agent_vfs['procedure_guide_step']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
												</select>
											</td>
										</tr>
										<tr>
											<td colspan=3>d. Avoid Slangs  & Jargons</td>
											<td>3</td>
											<td>
												<select class="form-control vfsVal" id="" name="avoid_slangs" disabled>
													<option vfs_val=3 <?php echo $agent_vfs['avoid_slangs']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
													<option vfs_val=3 <?php echo $agent_vfs['avoid_slangs']=='No'?"selected":""; ?> value="No">No</option>
													<option vfs_val=0 <?php echo $agent_vfs['avoid_slangs']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
												</select>
											</td>
										</tr>
										<tr>
											<td colspan=3>e. Correct and accurate grammar usage</td>
											<td>5</td>
											<td>
												<select class="form-control vfsVal" id="" name="correct_grammar_use" disabled>
													<option vfs_val=5 <?php echo $agent_vfs['correct_grammar_use']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
													<option vfs_val=5 <?php echo $agent_vfs['correct_grammar_use']=='No'?"selected":""; ?> value="No">No</option>
													<option vfs_val=0 <?php echo $agent_vfs['correct_grammar_use']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
												</select>
											</td>
										</tr>
										<tr>
											<td colspan=3>f .Correct closing</td>
											<td>4</td>
											<td>
												<select class="form-control vfsVal" id="" name="correct_closing" disabled>
													<option vfs_val=4 <?php echo $agent_vfs['correct_closing']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
													<option vfs_val=4 <?php echo $agent_vfs['correct_closing']=='No'?"selected":""; ?> value="No">No</option>
													<option vfs_val=0 <?php echo $agent_vfs['correct_closing']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
												</select>
											</td>
										</tr>
										<tr>
											<td colspan=3>g. Further assistance</td>
											<td>3</td>
											<td>
												<select class="form-control vfsVal" id="" name="further_assistance" disabled>
													<option vfs_val=3 <?php echo $agent_vfs['further_assistance']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
													<option vfs_val=3 <?php echo $agent_vfs['further_assistance']=='No'?"selected":""; ?> value="No">No</option>
													<option vfs_val=0 <?php echo $agent_vfs['further_assistance']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
												</select>
											</td>
										</tr>
										<tr>
											<td rowspan=4 style="background-color:#BFC9CA"><b>8. Fatal Parameter</b></td>
											<td colspan=3 style="background-color:#D98880">a. Rude or unprofessional on email</td>
											<td></td>
											<td>
												<select class="form-control vfsVal" id="emailAutof1" name="rude_on_email" disabled>
													<option vfs_val=0 <?php echo $agent_vfs['rude_on_email']=='No'?"selected":""; ?> value="No">No</option>
													<option vfs_val=0 <?php echo $agent_vfs['rude_on_email']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												</select>
											</td>
										</tr>
										<tr>
											<td colspan=3 style="background-color:#D98880">b. Incomplete / Inaccurate Information shared</td>
											<td></td>
											<td>
												<select class="form-control vfsVal" id="emailAutof2" name="inacurate_information" disabled>
													<option vfs_val=0 <?php echo $agent_vfs['inacurate_information']=='No'?"selected":""; ?> value="No">No</option>
													<option vfs_val=0 <?php echo $agent_vfs['inacurate_information']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												</select>
											</td>
										</tr>
										<tr>
											<td colspan=3 style="background-color:#D98880">c. Email hygiene</td>
											<td></td>
											<td>
												<select class="form-control vfsVal" id="emailAutof3" name="email_hygiene" disabled>
													<option vfs_val=0 <?php echo $agent_vfs['email_hygiene']=='No'?"selected":""; ?> value="No">No</option>
													<option vfs_val=0 <?php echo $agent_vfs['email_hygiene']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												</select>
											</td>
										</tr>
										<tr>
											<td colspan=3 style="background-color:#D98880">d. Complaint Avoidance</td>
											<td></td>
											<td>
												<select class="form-control vfsVal" id="emailAutof4" name="complaint_avoidance" disabled>
													<option vfs_val=0 <?php echo $agent_vfs['complaint_avoidance']=='No'?"selected":""; ?> value="No">No</option>
													<option vfs_val=0 <?php echo $agent_vfs['complaint_avoidance']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												</select>
											</td>
										</tr>
										<tr oncontextmenu="return false;">
											<td colspan=2>Upload Files</td>
											<?php if($agent_vfs['attach_file']!=''){ ?>
											<td colspan=4>
												<?php $attach_file = explode(",",$agent_vfs['attach_file']);
												 foreach($attach_file as $mp){ ?>
													<audio controls='' style="background-color:#607F93"> 
													  <source src="<?php echo base_url(); ?>qa_files/qa_vfs/email/<?php echo $mp; ?>" type="audio/ogg">
													  <source src="<?php echo base_url(); ?>qa_files/qa_vfs/email/<?php echo $mp; ?>" type="audio/mpeg">
													</audio> </br>
												 <?php } ?>
											</td>
											<?php }else{
													echo '<td><b>No Files</b></td>';
												  } 
											?>
										</tr>
									
									<?php } ?>
									
									<tr>
										<td>Reason For Fatal Error:</td>
										<td colspan=2><textarea class="form-control" id="" name="" disabled><?php echo $agent_vfs['reason_for_fatal'] ?></textarea></td>
										<td>Inprovement Area:</td>
										<td colspan=2><textarea class="form-control" id="" name="" disabled><?php echo $agent_vfs['inprovement_area'] ?></textarea></td>
									</tr>
									<tr>
										<td>Improvment Area:</td>
										<td colspan=2><textarea class="form-control" id="" name="" disabled><?php echo $agent_vfs['call_summary'] ?></textarea></td>
										<td>Feedback:</td>
										<td colspan=2><textarea class="form-control" id="" name="" disabled><?php echo $agent_vfs['feedback'] ?></textarea></td>
									</tr>
									
									<tr><td colspan="6" style="background-color:#C5C8C8"></td></tr>
									
									<tr><td style="font-size:16px">Manager Review:</td> <td colspan=5 style="text-align:left"><?php echo $agent_vfs['mgnt_rvw_note'] ?></td></tr>
									<tr><td style="font-size:16px">Client Review:</td> <td colspan=5 style="text-align:left"><?php echo $agent_vfs['client_rvw_note'] ?></td></tr>
									
									<tr><td colspan=6 style="background-color:#C5C8C8"></td></tr>
									
									 <form id="form_agent_user" method="POST" action="">
										<tr>
											<td style="font-size:16px">Review
												<input type="hidden" name="pnid" class="form-control" value="<?php echo $pnid; ?>">
											</td>
											<td colspan=5><textarea class="form-control" name="note" required><?php echo $agent_vfs['agent_rvw_note'] ?></textarea></td>
										</tr>
										
										<?php if(is_access_qa_agent_module()==true){
										if(is_available_qa_feedback($agent_vfs['entry_date'],72) == true){ ?>
											<tr>
												<?php if($agent_vfs['agent_rvw_note']==''){ ?>
													<td colspan="6"><button class="btn btn-success waves-effect" type="submit" id='btnagentSave' name='btnSave' value="SAVE" style="width:500px">SAVE</button></td>
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

		</form>	
		</div>

	</section>
</div>
