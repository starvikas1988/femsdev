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

</style>

<?php if($ajio_id!=0){
if(is_access_qa_edit_feedback()==false){ ?>
	<style>
		.form-control{
			pointer-events:none;
			background-color:#D5DBDB;
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
										<td colspan="6" id="theader" style="font-size:40px">AJIO [Chat]</td>
										<input type="hidden" name="audit_start_time" value="<?php echo CurrMySqlDate(); ?>">
									</tr>
									<?php
										if($ajio_id==0){
											$auditorName = get_username();
											$auditDate = CurrDateMDY();
											$clDate_val='';
										}else{
											if($ajio_chat['entry_by']!=''){
												$auditorName = $ajio_chat['auditor_name'];
											}else{
												$auditorName = $ajio_chat['client_name'];
											}
											$auditDate = mysql2mmddyy($ajio_chat['audit_date']);
											$clDate_val = mysqlDt2mmddyy($ajio_chat['call_date']);
										}
									?>
									<tr>
										<td>Auditor Name:</td>
										<td><input type="text" class="form-control" value="<?php echo $auditorName; ?>" disabled></td>
										<td>Audit Date:</td>
										<td><input type="text" class="form-control" value="<?php echo $auditDate; ?>" disabled></td>
										<td style="width:200px">Call Date/Time:</td>
										<td><input type="text" class="form-control" id="call_date_time" name="call_date" value="<?php echo $clDate_val; ?>" required></td>
									</tr>
									<tr>
										<td>Champ Name:</td>
										<td>
											<select class="form-control" id="agent_id" name="data[agent_id]" required >
												<option value="<?php echo $ajio_chat['agent_id'] ?>"><?php echo $ajio_chat['fname']." ".$ajio_chat['lname'] ?></option>
												<option value="">-Select-</option>
												<?php foreach($agentName as $row):  ?>
													<option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
												<?php endforeach; ?>
											</select>
										</td>
										<td>Fusion ID:</td>
										<td><input type="text" class="form-control" id="fusion_id" value="<?php echo $ajio_chat['fusion_id'] ?>" readonly ></td>
										<td>L1 Supervisor:</td>
										<td>
											<select class="form-control" id="tl_id" name="data[tl_id]" readonly>
												<option value="<?php echo $ajio_chat['tl_id'] ?>"><?php echo $ajio_chat['tl_name'] ?></option>
												<option value="">--Select--</option>
												<?php foreach($tlname as $tl): ?>
													<option value="<?php echo $tl['id']; ?>"><?php echo $tl['fname']." ".$tl['lname']; ?></option>
												<?php endforeach; ?>	
											</select>
										</td>
									</tr>
									<tr>
										<td>Champ BP ID:</td>
										<td><input type="text" class="form-control" name="data[agent_bp_id]" value="<?php echo $ajio_chat['agent_bp_id'] ?>" required ></td>
										<td>Call Duration:</td>
										<td><input type="text" class="form-control" id="call_duration" name="data[call_duration]" value="<?php echo $ajio_chat['call_duration'] ?>" required ></td>
										<td>Chat Link:</td>
										<td><input type="text" class="form-control" name="data[chat_link]" value="<?php echo $ajio_chat['chat_link'] ?>" required ></td>
									</tr>
									<tr>
										<td>Nature of Call/ Dispositions:</td>
										<td>
											<select class="form-control" name="data[call_nature]" required>
												<option value="<?php echo $ajio_chat['call_nature'] ?>"><?php echo $ajio_chat['call_nature'] ?></option>
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
											<select class="form-control" name="data[opening]" required>
												<option value="">-Select-</option>
												<option <?php echo $ajio_chat['opening'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option <?php echo $ajio_chat['opening'] == "No"?"selected":"";?> value="No">No</option>
											</select> 
										</td>
										<td>Closing</td>
										<td>
											<select class="form-control" name="data[closing]" required>
												<option value="">-Select-</option>
												<option <?php echo $ajio_chat['closing'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option <?php echo $ajio_chat['closing'] == "No"?"selected":"";?> value="No">No</option>
											</select> 
										</td>
									</tr>
									<tr>
										<td>Previous Interaction Checking:</td>
										<td>
											<select class="form-control" name="data[previous_interaction]" required>
												<option value="">-Select-</option>
												<option <?php echo $ajio_chat['previous_interaction'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option <?php echo $ajio_chat['previous_interaction'] == "No"?"selected":"";?> value="No">No</option>
											</select>
										</td>
										<td>Probing</td>
										<td>
											<select class="form-control" name="data[probing]" required>
												<option value="">-Select-</option>
												<option <?php echo $ajio_chat['probing'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option <?php echo $ajio_chat['probing'] == "No"?"selected":"";?> value="No">No</option>
											</select> 
										</td>
										<td>Hold</td>
										<td>
											<select class="form-control" name="data[hold]" required>
												<option value="">-Select-</option>
												<option <?php echo $ajio_chat['hold'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option <?php echo $ajio_chat['hold'] == "No"?"selected":"";?> value="No">No</option>
											</select> 
										</td>
									</tr>
									<tr>
										<td>Communication (Grammar):</td>
										<td>
											<select class="form-control" name="data[communication]" required>
												<option value="<?php echo $ajio_chat['communication'] ?>"><?php echo $ajio_chat['communication'] ?></option>
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
										<td><input type="text" class="form-control" name="data[response_time]" value="<?php echo $ajio_chat['response_time'] ?>" required></td>
										<td>System Navigation</td>
										<td>
											<select class="form-control" name="data[system_navigation]" required>
												<option value="">-Select-</option>
												<option <?php echo $ajio_chat['system_navigation'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option <?php echo $ajio_chat['system_navigation'] == "No"?"selected":"";?> value="No">No</option>
											</select> 
										</td>
									</tr>
									<tr>
										<td>Disposition:</td>
										<td>
											<select class="form-control" name="data[disposition]" required>
												<option value="<?php echo $ajio_chat['disposition'] ?>"><?php echo $ajio_chat['disposition'] ?></option>
												<option value="">-Select-</option>
												<option value="Correct">Correct</option>
												<option value="Incorrect">Incorrect</option>
												<option value="Multiple tagging not done when required">Multiple tagging not done when required</option>
												<option value="No Tagging">No Tagging</option>
												<option value="N/A">N/A</option>
											</select>
										</td>
										<td>Disposition L1:</td>
										<td>
											<select class="form-control" name="data[disposition_l1]" required>
												<option value="<?php echo $ajio_chat['disposition_l1'] ?>"><?php echo $ajio_chat['disposition_l1'] ?></option>
												<option value="">-Select-</option>
												<option value="Query understanding issue">Query understanding issue</option>
												<option value="Probing leading incorrect resolution/tagging">Probing leading incorrect resolution/tagging</option>
												<option value="Incorrect KM article referred">Incorrect KM article referred</option>
												<option value="Incorrect KM leg selection">Incorrect KM leg selection</option>
												<option value="Under No tagging : only KM referred no tagging">Under No tagging : only KM referred no tagging</option>
												<option value="Under No tagging : Only follow Cockpit no tagging">Under No tagging : Only follow Cockpit no tagging</option>
												<option value="Under No tagging :  No Resolution given with No">Under No tagging :  No Resolution given with No</option>
												<option value="Incorrect Intervention type">Incorrect Intervention type</option>
												<option value="N/A">N/A</option>
											</select>
										</td>
										<td>KM Navigation</td>
										<td>
											<select class="form-control" name="data[km_navigation]" required>
												<option value="">-Select-</option>
												<option <?php echo $ajio_chat['km_navigation'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option <?php echo $ajio_chat['km_navigation'] == "No"?"selected":"";?> value="No">No</option>
												<option <?php echo $ajio_chat['km_navigation'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
									</tr>
									<tr>
										<td>Article Number:</td>
										<td><input type="text" class="form-control" name="data[article_no]" value="<?php echo $ajio_chat['article_no'] ?>" required></td>
										<td>TNPS Given:</td>
										<td>
											<select class="form-control" name="data[tnps_given]" required>
												<option value="<?php echo $ajio_chat['tnps_given'] ?>"><?php echo $ajio_chat['tnps_given'] ?></option>
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
											<select class="form-control" name="data[fatal_nonfatal]" required>
												<option value="<?php echo $ajio_chat['fatal_nonfatal'] ?>"><?php echo $ajio_chat['fatal_nonfatal'] ?></option>
												<option value="">-Select-</option>
												<option value="Fatal">Fatal</option>
												<option value="Non Fatal">Non Fatal</option>
											</select>
										</td>
									</tr>
									<tr>
										<td>Resolution Validation:</td>
										<td>
											<select class="form-control" name="data[resolution_validation]" required>
												<option value="<?php echo $ajio_chat['resolution_validation'] ?>"><?php echo $ajio_chat['resolution_validation'] ?></option>
												<option value="">-Select-</option>
												<option value="Correct Resolution">Correct Resolution</option>
												<option value="Incorrect Resolution">Incorrect Resolution</option>
												<option value="Incomplete Resolution">Incomplete Resolution</option>
												<option value="Inappropriate action taken">Inappropriate action taken</option>
												<option value="False Assurance">False Assurance</option>
											</select>
										</td>
										<td>L1 Drill Down:</td>
										<td><input type="text" class="form-control" name="data[l1_drill_down]" value="<?php echo $ajio_chat['l1_drill_down'] ?>" required></td>
										<td>L2 Drill Down:</td>
										<td><input type="text" class="form-control" name="data[l2_drill_down]" value="<?php echo $ajio_chat['l2_drill_down'] ?>" required></td>
									</tr>
									<tr>
										<td>Call/Chat Disconnection</td>
										<td>
											<select class="form-control" name="data[call_chat_disconnection]" required>
												<option value="">-Select-</option>
												<option <?php echo $ajio_chat['call_chat_disconnection'] == "Compliance"?"selected":"";?> value="Compliance">Compliance</option>
												<option <?php echo $ajio_chat['call_chat_disconnection'] == "Non Compliance"?"selected":"";?> value="Non Compliance">Non Compliance</option>
											</select> 
										</td>
										<td>Call/Chat/Email Avoidance</td>
										<td>
											<select class="form-control" name="data[call_chat_email_avoidance]" required>
												<option value="">-Select-</option>
												<option <?php echo $ajio_chat['call_chat_email_avoidance'] == "Compliance"?"selected":"";?> value="Compliance">Compliance</option>
												<option <?php echo $ajio_chat['call_chat_email_avoidance'] == "Non Compliance"?"selected":"";?> value="Non Compliance">Non Compliance</option>
											</select> 
										</td>
										<td>Flirting/Seeking personal details</td>
										<td>
											<select class="form-control" name="data[seeking_personal_details]" required>
												<option value="">-Select-</option>
												<option <?php echo $ajio_chat['seeking_personal_details'] == "Compliance"?"selected":"";?> value="Compliance">Compliance</option>
												<option <?php echo $ajio_chat['seeking_personal_details'] == "Non Compliance"?"selected":"";?> value="Non Compliance">Non Compliance</option>
											</select> 
										</td>
									</tr>
									<tr>
										<td>Rude Behavior/Mocking the customer</td>
										<td>
											<select class="form-control" name="data[rude_behavior]" required>
												<option value="">-Select-</option>
												<option <?php echo $ajio_chat['rude_behavior'] == "Compliance"?"selected":"";?> value="Compliance">Compliance</option>
												<option <?php echo $ajio_chat['rude_behavior'] == "Non Compliance"?"selected":"";?> value="Non Compliance">Non Compliance</option>
											</select> 
										</td>
										<td>Abusive Behavior</td>
										<td>
											<select class="form-control" name="data[abuse_behavior]" required>
												<option value="">-Select-</option>
												<option <?php echo $ajio_chat['abuse_behavior'] == "Compliance"?"selected":"";?> value="Compliance">Compliance</option>
												<option <?php echo $ajio_chat['abuse_behavior'] == "Non Compliance"?"selected":"";?> value="Non Compliance">Non Compliance</option>
											</select> 
										</td>
										<td>Making Changes to customer’s account without permission or seeking confidential information such as password, OTP etc. or data privacy breach</td>
										<td>
											<select class="form-control" name="data[change_customer_account_without_permission]" required>
												<option value="">-Select-</option>
												<option <?php echo $ajio_chat['change_customer_account_without_permission'] == "Compliance"?"selected":"";?> value="Compliance">Compliance</option>
												<option <?php echo $ajio_chat['change_customer_account_without_permission'] == "Non Compliance"?"selected":"";?> value="Non Compliance">Non Compliance</option>
											</select> 
										</td>
									</tr>
									<tr>
										<td>Audit Type:</td>
										<td>
											<select class="form-control" id="audit_type" name="data[audit_type]" required>
												<option value="<?php echo $ajio_chat['audit_type'] ?>"><?php echo $ajio_chat['audit_type'] ?></option>
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
											<select class="form-control" id="voc" name="data[voc]" required>
												<option value="<?php echo $ajio_chat['voc'] ?>"><?php echo $ajio_chat['voc'] ?></option>
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
										<td><input type="text" readonly id="ajio_chat_overall_score" name="data[overall_score]" class="form-control ajio_chatFatal" style="font-weight:bold" value="<?php //echo $ajio_chat['overall_score'] ?>"></td>
									</tr>-->
									
									<tr>
										<td>Call Observation:</td>
										<td colspan=2><textarea class="form-control" name="data[call_summary]"><?php echo $ajio_chat['call_summary'] ?></textarea></td>
										<td>Feedback:</td>
										<td colspan=2><textarea class="form-control" name="data[feedback]"><?php echo $ajio_chat['feedback'] ?></textarea></td>
									</tr>
									<tr>
										<td colspan=2>Upload Files</td>
										<?php if($ajio_id==0){ ?>
											<td colspan=4><input type="file" multiple class="form-control" id="attach_file" name="attach_file[]"></td>
										<?php }else{
											if($ajio_chat['attach_file']!=''){ ?>
												<td colspan=4>
													<?php $attach_file = explode(",",$ajio_chat['attach_file']);
													 foreach($attach_file as $mp){ ?>
														<audio controls='' style="background-color:#607F93"> 
														  <source src="<?php echo base_url(); ?>qa_files/qa_ajio/inbound/<?php echo $mp; ?>" type="audio/ogg">
														  <source src="<?php echo base_url(); ?>qa_files/qa_ajio/inbound/<?php echo $mp; ?>" type="audio/mpeg">
														</audio> </br>
													 <?php } ?>
												</td>
										<?php }else{
												echo '<td colspan=6><b>No Files</b></td>';
											  }
										} ?>
									</tr>
									
									<?php if($ajio_id!=0){ ?>
										<tr><td colspan=2 style="font-size:16px; font-weight:bold">Agent Feedback Acceptance:</td><td colspan=4><?php echo $ajio_chat['agnt_fd_acpt'] ?></td></tr>
										<tr><td colspan=2 style="font-size:16px; font-weight:bold">Agent Review:</td><td colspan=4><?php echo $ajio_chat['agent_rvw_note'] ?></td></tr>
										<tr><td colspan=2 style="font-size:16px; font-weight:bold">Management Review:</td><td colspan=4><?php echo $ajio_chat['mgnt_rvw_note'] ?></td></tr>
										<tr><td colspan=2 style="font-size:16px; font-weight:bold">Client Review:</td><td colspan=4><?php echo $ajio_chat['client_rvw_note'] ?></td></tr>
										
										<tr><td colspan=2  style="font-size:16px">Your Review</td><td colspan=4><textarea class="form-control1" style="width:100%" id="note" name="note"  ></textarea></td></tr>
									<?php } ?>
									
									<?php 
									if($ajio_id==0){
										if(is_access_qa_module()==true || is_access_qa_operations_module()==true){ ?>
											<tr><td colspan=6><button class="btn btn-success waves-effect" type="submit" id="qaformsubmit" style="width:500px">SAVE</button></td></tr>
									<?php 
										} 
									}else{ 
										if(is_access_qa_module()==true || is_access_qa_operations_module()==true){
											if(is_available_qa_feedback($ajio_chat['entry_date'],72) == true){ ?>
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
