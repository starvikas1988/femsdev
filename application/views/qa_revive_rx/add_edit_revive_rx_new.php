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
										<td colspan="7" id="theader" style="font-size:30px">Revive Rx New</td>
										<?php
										if($revive_rx_id==0){
											$auditorName = get_username();
											$auditDate = CurrDateMDY();
											$clDate_val='';
										}else{
											if($revive_rx['entry_by']!=''){
												$auditorName = $revive_rx['auditor_name'];
											}else{
												$auditorName = $revive_rx['client_name'];
											}
											$auditDate = mysql2mmddyy($revive_rx['audit_date']);
											$clDate_val = mysql2mmddyy($revive_rx['call_date']);
										}
									?>
										<input type="hidden" name="audit_start_time" value="<?php echo CurrMySqlDate(); ?>">
									</tr>
									<tr>
										<td colspan="2">QA Name:</td>
										<td style="width: 250px"><input type="text" class="form-control" value="<?php echo get_username(); ?>" disabled></td>
										<td>Audit Date:</td>
										<td><input type="text" class="form-control" value="<?php echo CurrDateMDY(); ?>" disabled></td>
										<td>Call Date:</td>
										<td><input type="text" class="form-control" id="call_date" name="call_date" value="<?php echo $clDate_val; ?>" required></td>
									</tr>

									<tr>
										<td colspan="2">Agent:</td>
										<td>
											<select class="form-control agentName" id="agent_id" name="data[agent_id]" required>
												<option value="<?php echo $revive_rx['agent_id'] ?>"><?php echo $revive_rx['fname']." ".$revive_rx['lname'] ?></option>
												<option value="">-Select-</option>
												<?php foreach($agentName as $row):  ?>
													<option value="<?php echo $row['id']; ?>"><?php echo $row['name'].' ('.$row['fusion_id'].')'; ?></option>
												<?php endforeach; ?>
											</select>
										</td>
										<td>Fusion ID:</td>
										<td><input type="text" readonly class="form-control" id="fusion_id" name="" value="<?php echo $revive_rx['fusion_id'] ?>"></td>
										<td>L1 Supervisor:</td>
										<td>
											<select class="form-control" id="tl_id" name="data[tl_id]" readonly>
												<option value="<?php echo $revive_rx['tl_id'] ?>"><?php echo $revive_rx['tl_name'] ?></option>
												<option value="">--Select--</option>
												<?php foreach($tlname as $tl): ?>
													<option value="<?php echo $tl['id']; ?>"><?php echo $tl['fname']." ".$tl['lname']; ?></option>
												<?php endforeach; ?>	
											</select>
										</td>
									</tr>
									<tr>
										<td colspan="2">Call Id:</td>
										<td>
										<input type="text" class="form-control" id="call_id" name="data[call_id]" value="<?php echo $revive_rx['call_id'] ?>" required>
										</td>
										<td>Call Duration:</td>
										<td><input type="text" class="form-control" id="call_duration" name="data[call_duration]" value="<?php echo $revive_rx['call_duration'] ?>" required></td>
										<td>Contact Number:</td>
										<td><input type="number" class="form-control" name="data[customer_contact_number]" value="<?php echo $revive_rx['customer_contact_number'] ?>" required></td>
									</tr>
									
									<tr>
										<td colspan="2">Audit Type:</td>
										<td>
											<select class="form-control" id="audit_type" name="data[audit_type]" required>
												<option value="<?php echo $revive_rx['audit_type'] ?>"><?php echo $revive_rx['audit_type'] ?></option>
												<option value="">-Select-</option>
												<option value="CQ Audit">CQ Audit</option>
												<option value="BQ Audit">BQ Audit</option>
												<option value="Calibration">Calibration</option>
												<option value="Pre-Certification Mock Call">Pre-Certification Mock Call</option>
												<option value="Certification Audit">Certification Audit</option>
												<option value="WOW Call">WOW Call</option>
												<?php if(get_login_type()!="client"){ ?>
													<option value="Operation Audit">Operation Audit</option>
													<option value="Trainer Audit">Trainer Audit</option>
												<?php } ?>
											</select>
										</td>
										<td class="auType">Auditor Type</td>
										<td class="auType">
											<select class="form-control" id="auditor_type" name="data[auditor_type]">
												<option value="<?php echo $revive_rx['auditor_type'] ?>"><?php echo $revive_rx['auditor_type'] ?></option>
												<option value="">-Select-</option>
												<option value="Master">Master</option>
												<option value="Regular">Regular</option>
											</select>
										</td>
										<td>VOC:</td>
										<td>
											<select class="form-control" id="voc" name="data[voc]" required>
												<option value="<?php echo $revive_rx['voc'] ?>"><?php echo $revive_rx['voc'] ?></option>
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
										<td><input type="text" readonly id="pre_possibleScore" name="data[possible_score]" class="form-control" style="font-weight:bold" value="<?php echo $revive_rx['possible_score'] ?>"></td>
										<td style="font-weight:bold; font-size:16px">Earned Score:</td>
										<td><input type="text" readonly id="pre_earnedScore" name="data[earned_score]" class="form-control" style="font-weight:bold" value="<?php echo $revive_rx['earned_score'] ?>"></td>
										<td style="font-weight:bold; font-size:16px; text-align:right">Overall Score:</td>
										<td><input type="text" readonly id="pre_overallScore" name="data[overall_score]" class="form-control" style="font-weight:bold" value="<?php if($revive_rx['overall_score']){ echo $revive_rx['overall_score']; } else { echo '0.00'.'%'; } ?>"></td>
									</tr>
			
									
									<tr style="background-color:#A9CCE3; font-weight:bold"><td colspan="4">Parameter</td><td>Weightage</td><td>Rating</td><td colspan=3>Remark</td></tr>
									<td colspan="8" style="background-color: #A9CCE3;">Customer</td>
									<tr>
										
										<td colspan=4>Used proper opening providing pharmacy's name and asking for patient's name</td>
										<td>5</td>
										<td>
											<select class="form-control revive_rx_point" id="standardization1" name="data[patients_name]" required>
												
												<option revive_rx_val=5 <?php echo $revive_rx['patients_name']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option revive_rx_val=5 <?php echo $revive_rx['patients_name']=='No'?"selected":""; ?> value="No">No</option>
												<option revive_rx_val=5 <?php echo $revive_rx['patients_name']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt1]" value="<?php echo $revive_rx['cmt1'] ?>"></td>
									</tr>

									<tr>
										
										<td colspan=4>Soft skills</td>
										<td>5</td>
										<td>
											<select class="form-control revive_rx_point" id="standardization2" name="data[Soft_skills]" required>
												
												<option revive_rx_val=5 <?php echo $revive_rx['Soft_skills']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option revive_rx_val=5 <?php echo $revive_rx['Soft_skills']=='No'?"selected":""; ?> value="No">No</option>
												<option revive_rx_val=5 <?php echo $revive_rx['Soft_skills']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt2]" value="<?php echo $revive_rx['cmt2'] ?>"></td>
									</tr>
									<tr>
										
										<td colspan=4>Did not over talk the customer</td>
										<td>2</td>
										<td>
											<select class="form-control revive_rx_point " id="tagging_fatal" name="data[the_customer]" required>
												
												<option revive_rx_val=2 <?php echo $revive_rx['the_customer']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option revive_rx_val=2 <?php echo $revive_rx['the_customer']=='No'?"selected":""; ?> value="No">No</option>
												<option revive_rx_val=2 <?php echo $revive_rx['the_customer']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt3]" value="<?php echo $revive_rx['cmt3'] ?>"></td>
									</tr>

									<tr>
										
										<td colspan=4>Tone was warm and genuine throughout the call</td>
										<td>4</td>
										<td>
											<select class="form-control revive_rx_point" id="pass_fail3" name="data[throughout_the_call]" required>
												
												<option revive_rx_val=4 <?php echo $revive_rx['throughout_the_call']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option revive_rx_val=4 <?php echo $revive_rx['throughout_the_call']=='No'?"selected":""; ?> value="No">No</option>
												<option revive_rx_val=4 <?php echo $revive_rx['throughout_the_call']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt4]" value="<?php echo $revive_rx['cmt4'] ?>"></td>
									</tr>
									<tr>
										
										<td colspan=4>Took ownweship and sounded confident and creditable throughout the call</td>
										<td>5</td>
										<td>
											<select class="form-control revive_rx_point" id="pass_fail2" name="data[creditable_throughout]" required>
												
												<option revive_rx_val=5 <?php echo $revive_rx['creditable_throughout']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option revive_rx_val=5 <?php echo $revive_rx['creditable_throughout']=='No'?"selected":""; ?> value="No">No</option>
												<option revive_rx_val=5 <?php echo $revive_rx['creditable_throughout']=='NA'?"selected":""; ?> value="NA">NA</option>
												
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt5]" value="<?php echo $revive_rx['cmt5'] ?>"></td>
									</tr>
									<td colspan="8" style="background-color: #A9CCE3;">Compliance</td>
									<tr>
										
										<td colspan=4>Verified patients current contact information</td>
										<td>3</td>
										<td>
											<select class="form-control revive_rx_point" id="fatal2_com" name="data[contact_information]" required>
												
												<option revive_rx_val=3 <?php echo $revive_rx['contact_information']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option revive_rx_val=3 <?php echo $revive_rx['contact_information']=='No'?"selected":""; ?> value="No">No</option>
												<option revive_rx_val=3 <?php echo $revive_rx['contact_information']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt6]" value="<?php echo $revive_rx['cmt6'] ?>"></td>
									</tr>
									<tr>
										
										<td colspan=4>Verifed and updated personal information</td>
										<td>10</td>
										<td>
											<select class="form-control revive_rx_point" id="fatal7_com" name="data[personalinformation]" required>
												
												<option revive_rx_val=10 <?php echo $revive_rx['personalinformation']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option revive_rx_val=10 <?php echo $revive_rx['personalinformation']=='No'?"selected":""; ?> value="No">No</option>
												<option revive_rx_val=10 <?php echo $revive_rx['personalinformation']=='NA'?"selected":""; ?> value="NA">NA</option>
												
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt7]" value="<?php echo $revive_rx['cmt7'] ?>"></td>
									</tr>
									<tr>
										
										<td colspan=4>Provided accurate and complete information </td>
										<td>5</td>
										<td>
											<select class="form-control revive_rx_point" id="fatal7_com" name="data[complete_information]" required>
												
												<option revive_rx_val=5 <?php echo $revive_rx['complete_information']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option revive_rx_val=5 <?php echo $revive_rx['complete_information']=='No'?"selected":""; ?> value="No">No</option>
												<option revive_rx_val=5 <?php echo $revive_rx['complete_information']=='NA'?"selected":""; ?> value="NA">NA</option>
												
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt8]" value="<?php echo $revive_rx['cmt8'] ?>"></td>
									</tr>
									<tr>
										
										<td colspan=4 >Followed proper hold and transfer procedures</td>
										<td>5</td>
										<td>
											<select class="form-control revive_rx_point"  name="data[transfer_procedures]" required>
												
												<option revive_rx_val=5 <?php echo $revive_rx['transfer_procedures']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option revive_rx_val=5 <?php echo $revive_rx['transfer_procedures']=='No'?"selected":""; ?> value="No">No</option>
												<option revive_rx_val=5 <?php echo $revive_rx['transfer_procedures']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt9]" value="<?php echo $revive_rx['cmt9'] ?>"></td>
									</tr>
									<tr>
										
										<td colspan=4 >Left appropiate notes on the account</td>
										<td>7</td>
										<td>
											<select class="form-control revive_rx_point"  name="data[the_account]" required>
												
												<option revive_rx_val=7 <?php echo $revive_rx['the_account']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option revive_rx_val=7 <?php echo $revive_rx['the_account']=='No'?"selected":""; ?> value="No">No</option>
												<option revive_rx_val=7 <?php echo $revive_rx['the_account']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt10]" value="<?php echo $revive_rx['cmt10'] ?>"></td>
									</tr>
									<tr>
										
										<td colspan=4 >Asked for authorization to process the payment and fill the medication if needed</td>
										<td>5</td>
										<td>
											<select class="form-control revive_rx_point"  name="data[if_needed]" required>
												
												<option revive_rx_val=5 <?php echo $revive_rx['if_needed']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option revive_rx_val=5 <?php echo $revive_rx['if_needed']=='No'?"selected":""; ?> value="No">No</option>
												<option revive_rx_val=5 <?php echo $revive_rx['if_needed']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt11]" value="<?php echo $revive_rx['cmt11'] ?>"></td>
									</tr>

									<tr>
										
										<td colspan=4 >Verified allergies and intolerances</td>
										<td>5</td>
										<td>
											<select class="form-control revive_rx_point"  name="data[and_intolerances]" required>
												
												<option revive_rx_val=5 <?php echo $revive_rx['and_intolerances']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option revive_rx_val=5 <?php echo $revive_rx['and_intolerances']=='No'?"selected":""; ?> value="No">No</option>
												<option revive_rx_val=5 <?php echo $revive_rx['and_intolerances']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt12]" value="<?php echo $revive_rx['cmt12'] ?>"></td>
									</tr>
									<tr>
										
										<td colspan=4 >Left voicemail and sent text message (Unable to contact patient)</td>
										<td>7</td>
										<td>
											<select class="form-control revive_rx_point"  name="data[text_message]" required>
												
												<option revive_rx_val=7 <?php echo $revive_rx['text_message']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option revive_rx_val=7 <?php echo $revive_rx['text_message']=='No'?"selected":""; ?> value="No">No</option>
												<option revive_rx_val=7 <?php echo $revive_rx['text_message']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt13]" value="<?php echo $revive_rx['cmt13'] ?>"></td>
									</tr>
									<tr>
										
										<td colspan=4 >Closed the call positively </td>
										<td>2</td>
										<td>
											<select class="form-control revive_rx_point"  name="data[call_positively]" required>
												
												<option revive_rx_val=2 <?php echo $revive_rx['call_positively']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option revive_rx_val=2 <?php echo $revive_rx['call_positively']=='No'?"selected":""; ?> value="No">No</option>
												<option revive_rx_val=2 <?php echo $revive_rx['call_positively']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt14]" value="<?php echo $revive_rx['cmt14'] ?>"></td>
									</tr>

									<td colspan="8" style="background-color: #A9CCE3;">Business Critical</td>
									<tr>
										
										<td colspan=4 style="color: red;">Propertly authenticates (Complete shipping address and DOB)</td>
										<td>15</td>
										<td>
											<select class="form-control revive_rx_point all_fatal1" id="all_fatal1" name="data[Propertly_authenticates]" required>
												
												<option revive_rx_val=15 <?php echo $revive_rx['Propertly_authenticates']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option revive_rx_val=15 <?php echo $revive_rx['Propertly_authenticates']=='No'?"selected":""; ?> value="No">No</option>
												<option revive_rx_val=15 <?php echo $revive_rx['Propertly_authenticates']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt15]" value="<?php echo $revive_rx['cmt15'] ?>"></td>
									</tr>
									<tr>
										
										<td colspan=4 style="color: red;">Navigated effectively through the sytem (Verify if call is needed)</td>
										<td>15</td>
										<td>
											<select class="form-control revive_rx_point all_fatal2" id="all_fatal2" name="data[Navigated_effectively]" required>
												
												<option revive_rx_val=15 <?php echo $revive_rx['Navigated_effectively']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option revive_rx_val=15 <?php echo $revive_rx['Navigated_effectively']=='No'?"selected":""; ?> value="No">No</option>
												<option revive_rx_val=15 <?php echo $revive_rx['Navigated_effectively']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt16]" value="<?php echo $revive_rx['cmt16'] ?>"></td>
									</tr>

									




									<tr>
										<td>Call Summary:</td>
										<td colspan=3><textarea class="form-control" id="" name="data[call_summary]"><?php echo $revive_rx['call_summary'] ?></textarea></td>
										<td>Remark:</td>
										<td colspan=3><textarea class="form-control" id="" name="data[feedback]"><?php echo $revive_rx['feedback'] ?></textarea></td>
									</tr>

									<?php if($revive_rx_id==0){ ?>
									<tr>
										<td colspan=2>Upload Files</td>
										<td colspan=5><input type="file" multiple class="form-control" id="attach_file" name="attach_file[]"></td>
									</tr>
									<?php }else{ ?>
									<tr>	
										<td colspan=2>Upload Files</td>
										<?php if($revive_rx['attach_file']!=''){ ?>
											<td colspan=5>
												<?php $attach_file = explode(",",$revive_rx['attach_file']);
												 foreach($attach_file as $mp){ ?>
													<audio controls='' style="background-color:#607F93"> 
													  <source src="<?php echo base_url(); ?>qa_files/revive_rx/<?php echo $mp; ?>" type="audio/ogg">
													  <source src="<?php echo base_url(); ?>qa_files/revive_rx/<?php echo $mp; ?>" type="audio/mpeg">
													</audio> </br>
												 <?php } ?>
											</td>
										<?php }else{
												//echo '<td colspan=6><b>No Files</b></td>';
											  }
										} ?>
									</tr>
									
									
									<?php if($revive_rx_id!=0){ ?>
										<tr><td colspan=2 style="font-size:12px; font-weight:bold">Agent Feedback Acceptance:</td><td colspan=5><?php echo $revive_rx['agnt_fd_acpt'] ?></td></tr>
										<tr><td colspan=2 style="font-size:12px; font-weight:bold">Management Review:</td><td colspan=5><?php echo $revive_rx['mgnt_rvw_note'] ?></td></tr>
										<tr><td colspan=2 style="font-size:12px; font-weight:bold">Client Review:</td><td colspan=5><?php echo $revive_rx['client_rvw_note'] ?></td></tr>
										
										<tr><td colspan=2  style="font-size:12px">Your Review</td><td colspan=5><textarea class="form-control1" style="width:100%" id="note" name="note"  ><?php echo $revive_rx['agent_rvw_note'] ?></textarea></td></tr>
									<?php } ?>
									
									
									<?php 
									if($revive_rx_id==0){
										if(is_access_qa_module()==true || is_access_qa_operations_module()==true){ ?>
											<tr><td colspan=7><button class="btn btn-success waves-effect" type="submit" id="qaformsubmit" style="width:500px">SAVE</button></td></tr>
									<?php 
										} 
									}else{ 
										if(is_access_qa_module()==true || is_access_qa_operations_module()==true){
											 if($revive_rx['agent_rvw_note']=="") { ?>
												<tr><td colspan="7"><button class="btn btn-success waves-effect" type="submit" id='qaformsubmit' name='btnSave' value="SAVE" style="width:500px">SAVE</button></td></tr>
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
