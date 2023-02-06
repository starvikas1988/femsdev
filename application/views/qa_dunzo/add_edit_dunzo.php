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
										<td colspan="7" id="theader" style="font-size:30px">Dunzo Call Monitoring</td>
										<?php
										if($dunzo_id==0){
											$auditorName = get_username();
											$auditDate = CurrDateMDY();
											$clDate_val='';
										}else{
											if($dunzo['entry_by']!=''){
												$auditorName = $dunzo['auditor_name'];
											}else{
												$auditorName = $dunzo['client_name'];
											}
											$auditDate = mysql2mmddyy($dunzo['audit_date']);
											$clDate_val = mysql2mmddyy($dunzo['call_date']);
										}
									?>
										<input type="hidden" name="audit_start_time" value="<?php echo CurrMySqlDate(); ?>">
									</tr>
									<tr>
										<td colspan="2">QA Name:</td>
										<td style="width:350px"><input type="text" class="form-control" value="<?php echo get_username().'-'.get_email_id_off(); ?>" disabled></td>
										<td>Audit Date:</td>
										<td><input type="text" class="form-control" value="<?php echo CurrDateMDY(); ?>" disabled></td>
										<td>Transaction Date:</td>
										<td><input type="text" class="form-control" id="call_date" name="call_date" value="<?php echo $clDate_val; ?>" required></td>
									</tr>

									<tr>
										<td colspan="2">Agent:</td>
										<td>
											<select class="form-control agentName" id="agent_id" name="data[agent_id]" required>
												<option value="<?php echo $dunzo['agent_id'] ?>"><?php echo $dunzo['fname']." ".$dunzo['lname'] ?></option>
												<option value="">-Select-</option>
												<?php foreach($agentName as $row):  ?>
													<option value="<?php echo $row['id']; ?>"><?php echo $row['name'].' ('.$row['fusion_id'].')'; ?></option>
												<?php endforeach; ?>
											</select>
										</td>
										<td>Fusion ID:</td>
										<td><input type="text" readonly class="form-control" id="fusion_id" name="" value="<?php echo $dunzo['fusion_id'] ?>"></td>
										<td>L1 Supervisor:</td>
										<td>
											<select class="form-control" id="tl_id" name="data[tl_id]" readonly>
												<option value="<?php echo $dunzo['tl_id'] ?>"><?php echo $dunzo['tl_name'] ?></option>
												<option value="">--Select--</option>
												<?php foreach($tlname as $tl): ?>
													<option value="<?php echo $tl['id']; ?>"><?php echo $tl['fname']." ".$tl['lname']; ?></option>
												<?php endforeach; ?>	
											</select>
										</td>
									</tr>
									<tr>
										<td colspan="2">Chat Date:</td>
										<td><input type="text" class="form-control" id="chat_date" name="chat_date" value="<?php echo mysql2mmddyy($dunzo['chat_date']) ?>" required></td>
										<td>Call Duration:</td>
										<td><input type="text" class="form-control" id="call_duration" name="data[call_duration]" value="<?php echo $dunzo['call_duration'] ?>" required></td>
										<td>Customer Contact Number:</td>
										<td><input type="number" class="form-control" name="data[customer_contact_number]" value="<?php echo $dunzo['customer_contact_number'] ?>" required></td>
									</tr>
									<tr>
										<td colspan="2">Campaign:</td>
										<td><input type="text" class="form-control" id="campaign" name="data[campaign]" value="<?php echo $dunzo['campaign'] ?>" required></td>
										<td>Zone:</td>
										<td><input type="text" class="form-control" id="zone" name="data[zone]" value="<?php echo $dunzo['zone'] ?>"  required></td>
										<td>Team Manager:</td>
										<td><input type="text" class="form-control" id="team_manager" name="data[team_manager]" value="<?php echo $dunzo['team_manager'] ?>" required></td>
									</tr>
									<tr>
										<td colspan="2">Transaction ID</td>
										<td><input type="text" class="form-control" id="transaction_id" name="data[transaction_id]" value="<?php echo $dunzo['transaction_id'] ?>" required></td>
										<td>Label category:</td>
										<td><input type="text" class="form-control" id="concept" name="data[concept]" value="<?php echo $dunzo['concept'] ?>"  required></td>
										<td>Call Link:</td>
										<td><input type="text" class="form-control" name="data[call_link]" value="<?php echo $dunzo['call_link'] ?>"  required></td>
									</tr>
									<tr>
										<td colspan="2">Week:</td>
										<td>
											<select class="form-control" name="data[week]" required>
												<option value="<?php echo $dunzo['week'] ?>"><?php echo $dunzo['week'] ?></option>
												<option value="">-Select-</option>
												<option value="Week1">Week1</option>
												<option value="Week2">Week2</option>
												<option value="Week3">Week3</option>
												<option value="Week4">Week4</option>
											</select>
										</td>
									</tr>
									<tr>
										<td colspan="2">Audit Type:</td>
										<td>
											<select class="form-control" id="audit_type" name="data[audit_type]" required>
												<option value="<?php echo $dunzo['audit_type'] ?>"><?php echo $dunzo['audit_type'] ?></option>
												<option value="">-Select-</option>
												<option value="CQ Audit">CQ Audit</option>
												<option value="BQ Audit">BQ Audit</option>
												<option value="Calibration">Calibration</option>
												<option value="Pre-Certification Mock Call">Pre-Certification Mock Call</option>
												<option value="Certification Audit">Certification Audit</option>
												<?php if(get_login_type()!="client"){ ?>
													<option value="Operation Audit">Operation Audit</option>
													<option value="Trainer Audit">Trainer Audit</option>
												<?php } ?>
											</select>
										</td>
										<td class="auType">Auditor Type</td>
										<td class="auType">
											<select class="form-control" id="auditor_type" name="data[auditor_type]">
												<option value="<?php echo $dunzo['auditor_type'] ?>"><?php echo $dunzo['auditor_type'] ?></option>
												<option value="">-Select-</option>
												<option value="Master">Master</option>
												<option value="Regular">Regular</option>
											</select>
										</td>
										<td>VOC:</td>
										<td>
											<select class="form-control" id="voc" name="data[voc]" required>
												<option value="<?php echo $dunzo['voc'] ?>"><?php echo $dunzo['voc'] ?></option>
												<option value="">-Select-</option>
												<option value="1">1</option>
												<option value="2">2</option>
												<option value="3">3</option>
												<option value="4">4</option>
												<option value="5">5</option>
											</select>
										</td>
									</tr>
									<tr>
										<td colspan="2" style="font-weight:bold; font-size:16px">Possible Score:</td>
										<td><input type="text" readonly id="pre_possibleScore" name="data[possible_score]" class="form-control" style="font-weight:bold" value="<?php echo $dunzo['possible_score'] ?>"></td>
										<td style="font-weight:bold; font-size:16px">Earned Score:</td>
										<td><input type="text" readonly id="pre_earnedScore" name="data[earned_score]" class="form-control" style="font-weight:bold" value="<?php echo $dunzo['earned_score'] ?>"></td>
										<td style="font-weight:bold; font-size:16px; text-align:right">Overall Score:</td>
										<td><input type="text" readonly id="pre_overallScore" name="data[overall_score]" class="form-control" style="font-weight:bold" value="<?php if($dunzo['overall_score']){ echo $dunzo['overall_score']; } else { echo '0.00'.'%'; } ?>"></td>
									</tr>
			
									
									<tr style="background-color:#A9CCE3; font-weight:bold"><td>Parameter</td><td colspan=2>Sub-Parameter</td><td>Weightage</td><td>Rating</td><td colspan=3>Remark</td></tr>
									<tr>
										<td rowspan=11 style="background-color:#A9CCE3; font-weight:bold">Customer Experience</td>
										<td colspan=2>Advisor used the standard greeting format</td>
										<td>2</td>
										<td>
											<select class="form-control dunzo_point" id="standardization1" name="data[standard_greeting]" required>
												
												<option dunzo_val=2 <?php echo $dunzo['standard_greeting']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option dunzo_val=2 <?php echo $dunzo['standard_greeting']=='No'?"selected":""; ?> value="No">No</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt1]" value="<?php echo $dunzo['cmt1'] ?>"></td>
									</tr>
									<tr>
										<td colspan=2>Appropriate responses ( acknowledging at the right time)</td>
										<td>3</td>
										<td>
											<select class="form-control dunzo_point" id="standardization2" name="data[appropriate_responses]" required>
												
												<option dunzo_val=3 <?php echo $dunzo['appropriate_responses']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option dunzo_val=3 <?php echo $dunzo['appropriate_responses']=='No'?"selected":""; ?> value="No">No</option>
												
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt2]" value="<?php echo $dunzo['cmt2'] ?>"></td>
									</tr>
									<tr>
										<td colspan=2>Ownership on Chats/ Delay in responding</td>
										<td>3</td>
										<td>
											<select class="form-control dunzo_point" id="standardization2" name="data[delay_response]" required>
												
												<option dunzo_val=3 <?php echo $dunzo['delay_response']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option dunzo_val=3 <?php echo $dunzo['delay_response']=='No'?"selected":""; ?> value="No">No</option>
												
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt3]" value="<?php echo $dunzo['cmt3'] ?>"></td>
									</tr>
									<tr>
										<td colspan=2>Active Listening and Interruption</td>
										<td>3</td>
										<td>
											<select class="form-control dunzo_point" id="standardization2" name="data[active_listening]" required>
												
												<option dunzo_val=3 <?php echo $dunzo['active_listening']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option dunzo_val=3 <?php echo $dunzo['active_listening']=='No'?"selected":""; ?> value="No">No</option>
												
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt4]" value="<?php echo $dunzo['cmt4'] ?>"></td>
									</tr>
									<tr>
										<td colspan=2>Empathy/Sympathy</td>
										<td>3</td>
										<td>
											<select class="form-control dunzo_point" id="standardization2" name="data[empathise]" required>
												
												<option dunzo_val=3 <?php echo $dunzo['empathise']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option dunzo_val=3 <?php echo $dunzo['empathise']=='No'?"selected":""; ?> value="No">No</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt5]" value="<?php echo $dunzo['cmt5'] ?>"></td>
									</tr>
									<tr>
										<td colspan=2>Relevant responses</td>
										<td>3</td>
										<td>
											<select class="form-control dunzo_point" id="standardization2" name="data[relevent_responses]" required>
												
												<option dunzo_val=3 <?php echo $dunzo['relevent_responses']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option dunzo_val=3 <?php echo $dunzo['relevent_responses']=='No'?"selected":""; ?> value="No">No</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt6]" value="<?php echo $dunzo['cmt6'] ?>"></td>
									</tr>
									<tr>
										<td colspan=2>Hold</td>
										<td>3</td>
										<td>
											<select class="form-control dunzo_point" id="standardization2" name="data[hold]" required>
												
												<option dunzo_val=3 <?php echo $dunzo['hold']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option dunzo_val=3 <?php echo $dunzo['hold']=='No'?"selected":""; ?> value="No">No</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt7]" value="<?php echo $dunzo['cmt7'] ?>"></td>
									</tr>
									<tr>
										<td colspan=2>Grammar, Sentence structure, Tone</td>
										<td>3</td>
										<td>
											<select class="form-control dunzo_point" id="standardization2" name="data[grammatically_correct]" required>
												
												<option dunzo_val=3 <?php echo $dunzo['grammatically_correct']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option dunzo_val=3 <?php echo $dunzo['grammatically_correct']=='No'?"selected":""; ?> value="No">No</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt8]" value="<?php echo $dunzo['cmt8'] ?>"></td>
									</tr>
									<tr>
										<td colspan=2>Probing done whenever necessary</td>
										<td>3</td>
										<td>
											<select class="form-control dunzo_point" id="standardization2" name="data[probing_done]" required>
												
												<option dunzo_val=3 <?php echo $dunzo['probing_done']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option dunzo_val=3 <?php echo $dunzo['probing_done']=='No'?"selected":""; ?> value="No">No</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt9]" value="<?php echo $dunzo['cmt9'] ?>"></td>
									</tr>
									<tr>
										<td colspan=2>Recap (Summarization of the conversation)</td>
										<td>2</td>
										<td>
											<select class="form-control dunzo_point" id="standardization2" name="data[summarization]" required>
												
												<option dunzo_val=2 <?php echo $dunzo['summarization']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option dunzo_val=2 <?php echo $dunzo['summarization']=='No'?"selected":""; ?> value="No">No</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt10]" value="<?php echo $dunzo['cmt10'] ?>"></td>
									</tr>
									<tr>
										<td colspan=2>Advisor used the standard closing format</td>
										<td>2</td>
										<td>
											<select class="form-control dunzo_point" id="standardization2" name="data[closing_format]" required>
												
												<option dunzo_val=2 <?php echo $dunzo['closing_format']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option dunzo_val=2 <?php echo $dunzo['closing_format']=='No'?"selected":""; ?> value="No">No</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt11]" value="<?php echo $dunzo['cmt11'] ?>"></td>
									</tr>

									<tr>
										<td rowspan=2 style="background-color:#A9CCE3; font-weight:bold">Business</td>
										<td colspan=2>Accurate Resolution/Information is provided as per the process</td>
										<td>10</td>
										<td>
											<select class="form-control dunzo_point" id="standardization2" name="data[accurate_resolution]" required>
												
												<option dunzo_val=10 <?php echo $dunzo['accurate_resolution']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option dunzo_val=10 <?php echo $dunzo['accurate_resolution']=='No'?"selected":""; ?> value="No">No</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt12]" value="<?php echo $dunzo['cmt12'] ?>"></td>
									</tr>
										<td colspan=2>Private notes</td>
										<td>10</td>
										<td>
											<select class="form-control dunzo_point " id="tagging_fatal" name="data[private_notes]" required>
												
												<option dunzo_val=10 <?php echo $dunzo['private_notes']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option dunzo_val=10 <?php echo $dunzo['private_notes']=='No'?"selected":""; ?> value="No">No</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt13]" value="<?php echo $dunzo['cmt13'] ?>"></td>
									</tr>

									<tr>
										<td rowspan=6 style="background-color:#A9CCE3; font-weight:bold">Compliance</td>
										<td colspan=2 style="color:red">Professional / Courtesy</td>
										<td>10</td>
										<td>
											<select class="form-control dunzo_point all_fatal1" id="pass_fatal1" name="data[professional]" required>
												
												<option dunzo_val=10 <?php echo $dunzo['professional']=='PASS'?"selected":""; ?> value="PASS">PASS</option>
												<option dunzo_val=10 <?php echo $dunzo['professional']=='FATAL'?"selected":""; ?> value="FATAL">FATAL</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt14]" value="<?php echo $dunzo['cmt14'] ?>"></td>
									</tr>
									<tr>
										<td colspan=2 style="color:red">Verification process followed</td>
										<td>5</td>
										<td>
											<select class="form-control dunzo_point all_fatal2" id="pass_fatal2" name="data[verification_process]" required>
												
												<option dunzo_val=5 <?php echo $dunzo['verification_process']=='PASS'?"selected":""; ?> value="PASS">PASS</option>
												<option dunzo_val=5 <?php echo $dunzo['verification_process']=='FATAL'?"selected":""; ?> value="FATAL">FATAL</option>
												
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt15]" value="<?php echo $dunzo['cmt15'] ?>"></td>
									</tr>
									<tr>
										<td colspan=2 style="color:red">Calls made to Partner/User</td>
										<td>10</td>
										<td>
											<select class="form-control dunzo_point all_fatal3" id="pass_fatal3" name="data[call_partner]" required>
												
												<option dunzo_val=10 <?php echo $dunzo['call_partner']=='PASS'?"selected":""; ?> value="PASS">PASS</option>
												<option dunzo_val=10 <?php echo $dunzo['call_partner']=='FATAL'?"selected":""; ?> value="FATAL">FATAL</option>
												
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt16]" value="<?php echo $dunzo['cmt16'] ?>"></td>
									</tr>
									<tr>
										<td colspan=2 style="color:red">Process & Procedure Followed</td>
										<td>10</td>
										<td>
											<select class="form-control dunzo_point all_fatal4" id="pass_fatal4" name="data[process_procedure]" required>
												
												<option dunzo_val=10 <?php echo $dunzo['process_procedure']=='PASS'?"selected":""; ?> value="PASS">PASS</option>
												<option dunzo_val=10 <?php echo $dunzo['process_procedure']=='FATAL'?"selected":""; ?> value="FATAL">FATAL</option>
												
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt17]" value="<?php echo $dunzo['cmt17'] ?>"></td>
									</tr>
									<tr>
										<td colspan=2 style="color:red">Labels</td>
										<td>5</td>
										<td>
											<select class="form-control dunzo_point all_fatal5" id="pass_fatal5" name="data[labels]" required>
												
												<option dunzo_val=5 <?php echo $dunzo['labels']=='PASS'?"selected":""; ?> value="PASS">PASS</option>
												<option dunzo_val=5 <?php echo $dunzo['labels']=='FATAL'?"selected":""; ?> value="FATAL">FATAL</option>
												
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt18]" value="<?php echo $dunzo['cmt18'] ?>"></td>
									</tr>
									<tr>
										<td colspan=2 style="color:red">First Chat Resolution</td>
										<td>10</td>
										<td>
											<select class="form-control dunzo_point all_fatal6" id="pass_fatal6" name="data[chat_resolution]" required>
												
												<option dunzo_val=10 <?php echo $dunzo['chat_resolution']=='PASS'?"selected":""; ?> value="PASS">PASS</option>
												<option dunzo_val=10 <?php echo $dunzo['chat_resolution']=='FATAL'?"selected":""; ?> value="FATAL">FATAL</option>
												
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt19]" value="<?php echo $dunzo['cmt19'] ?>"></td>
									</tr>
									
									<tr>
										<td>Areas of Improvement:</td>
										<td colspan=3><textarea class="form-control" id="" name="data[feedback]"><?php echo $dunzo['feedback'] ?></textarea></td>
										<td>Positives:</td>
										<td colspan=3><textarea class="form-control" id="" name="data[positives]"><?php echo $dunzo['positives'] ?></textarea></td>
									</tr>
									
									<tr>
										<td>Summary of the chat:</td>
										<td colspan=6><textarea class="form-control" id="" name="data[call_summary]"><?php echo $dunzo['call_summary'] ?></textarea></td>
									</tr>

									<?php if($dunzo_id==0){ ?>
									<tr>
										<td colspan=2>Upload Files</td>
										<td colspan=4><input type="file" multiple class="form-control" id="attach_file" name="attach_file[]"></td>
									</tr>
									<?php }else{ ?>
									<tr>	
										<td colspan=2>Upload Files</td>
										<?php if($dunzo['attach_file']!=''){ ?>
											<td colspan=4>
												<?php $attach_file = explode(",",$dunzo['attach_file']);
												 foreach($attach_file as $mp){ ?>
													<audio controls='' style="background-color:#607F93"> 
													  <source src="<?php echo base_url(); ?>qa_files/dunzo/<?php echo $mp; ?>" type="audio/ogg">
													  <source src="<?php echo base_url(); ?>qa_files/dunzo/<?php echo $mp; ?>" type="audio/mpeg">
													</audio> </br>
												 <?php } ?>
											</td>
										<?php }else{
												//echo '<td colspan=6><b>No Files</b></td>';
											  }
										} ?>
									</tr>
									
									
									<?php if($dunzo_id!=0){ ?>
										<tr><td colspan=2 style="font-size:12px; font-weight:bold">Agent Feedback Acceptance:</td><td colspan=4><?php echo $dunzo['agnt_fd_acpt'] ?></td></tr>
										<tr><td colspan=2 style="font-size:12px; font-weight:bold">Management Review:</td><td colspan=4><?php echo $dunzo['mgnt_rvw_note'] ?></td></tr>
										<tr><td colspan=2 style="font-size:12px; font-weight:bold">Client Review:</td><td colspan=4><?php echo $dunzo['client_rvw_note'] ?></td></tr>
										
										<tr><td colspan=2  style="font-size:12px">Your Review</td><td colspan=4><textarea class="form-control1" style="width:100%" id="note" name="note"  ><?php echo $dunzo['agent_rvw_note'] ?></textarea></td></tr>
									<?php } ?>
									
									
									<?php 
									if($dunzo_id==0){
										if(is_access_qa_module()==true || is_access_qa_operations_module()==true){ ?>
											<tr><td colspan=6><button class="btn btn-success waves-effect" type="submit" id="qaformsubmit" style="width:500px">SAVE</button></td></tr>
									<?php 
										} 
									}else{ 
										if(is_access_qa_module()==true || is_access_qa_operations_module()==true){
											 if($dunzo['agent_rvw_note']=="") { ?>
												<tr><td colspan="6"><button class="btn btn-success waves-effect" type="submit" id='qaformsubmit' name='btnSave' value="SAVE" style="width:500px">SAVE</button></td></tr>
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
