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
	background-color:#85C1E9;
}

</style>

<?php if($loanxm_id!=0){
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
							<table class="table  skt-table" width="100%">
								<tbody>
									<tr>
										<td colspan="6" id="theader" style="font-size:40px;text-align: center;background-color: #16A5CB ;">Credit Mantri Referral Audit Sheet</td>
										<input type="hidden" name="audit_start_time" value="<?php echo CurrMySqlDate(); ?>">
									</tr>
									<?php
										if($loanxm_id==0){
											$auditorName = get_username();
											$auditDate = CurrDateMDY();
											$clDate_val='';
											$week="Week ".$controller->weekOfMonth(date("Y-m-d"));
										}else{
											if($credit_mantri_referral['entry_by']!=''){
												$auditorName = $credit_mantri_referral['auditor_name'];
											}else{
												$auditorName = $credit_mantri_referral['client_name'];
											}
											$auditDate = mysql2mmddyy($credit_mantri_referral['audit_date']);
											$clDate_val = mysql2mmddyy($credit_mantri_referral['call_date']);
											$week= $credit_mantri_referral['Week'];
										}
									?>
									<tr>
										<td style="width:16%">Auditor Name:<span style="font-size:24px;color:red">*</span></td>
										<td style="width:16%"><input type="text" class="form-control" value="<?php echo $auditorName; ?>" disabled></td>
										<td style="width:16%">Audit Date:<span style="font-size:24px;color:red">*</span></td>
										<td style="width:16%"><input type="text" class="form-control" value="<?php echo $auditDate; ?>" disabled></td>
										<td style="width:16%">Call Date:<span style="font-size:24px;color:red">*</span></td>
										<td style="width:16%"><input type="text" class="form-control" onkeydown="return false;" id="call_date" name="call_date" value="<?php echo $clDate_val; ?>" required></td>
									</tr>
									<tr>
										<td>Agent:<span style="font-size:24px;color:red">*</span></td>
										<td>
											<select class="form-control" id="agent_id" name="data[agent_id]" required >
												<?php 
												if($credit_mantri_referral['agent_id']!=''){
													?>
													<option value="<?php echo $credit_mantri_referral['agent_id'] ?>"><?php echo $credit_mantri_referral['fname']." ".$credit_mantri_referral['lname'] ?></option>
													<?php
												}
												?>
												<option value="">-Select-</option>
												<?php foreach($agentName as $row):  ?>
													<option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
												<?php endforeach; ?>
											</select>
										</td>
											<td>Fusion ID:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control" id="fusion_id" value="<?php echo $credit_mantri_referral['fusion_id'] ?>" readonly ></td>
											<td>L1 Supervisor:<span style="font-size:24px;color:red">*</span></td>
										<td>
											<select class="form-control" id="tl_id" name="data[tl_id]" required>
												<?php 
												if($credit_mantri_referral['tl_id']!=''){
													?>
													<option value="<?php echo $credit_mantri_referral['tl_id'] ?>"><?php echo $credit_mantri_referral['tl_name'] ?></option>
													<?php
												}
												?>
												<option value="">--Select--</option>
												<?php foreach($tlname as $tl): ?>
													<option value="<?php echo $tl['id']; ?>"><?php echo $tl['name']; ?></option>
												<?php endforeach; ?>	
											</select>
										</td>
									</tr>
									<tr>
										<td>Call Duration:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control" id="call_duration" onkeydown="return false;" name="data[call_duration]" value="<?php echo $credit_mantri_referral['call_duration'] ?>" required ></td>
										<td colspan="">Week:<span style="font-size:24px;color:red">*</span></td>
										<td>
											<input type="text" name="data[Week]" readonly class="form-control" value="<?php echo $week?>" />
										</td>
										<td>Agency:<span style="font-size:24px;color:red">*</span></td>
										<td>
											<input type="text" class="form-control" name="data[Agency]" value="<?php echo $credit_mantri_referral['Agency'] ?>" required>
										</td>
									</tr>
									<tr>
										<td>OIC Name:<span style="font-size:24px;color:red">*</span></td>
										<td>
											<input type="text" class="form-control" name="data[OIC]" value="<?php echo $credit_mantri_referral['OIC'] ?>" required>
										</td>
										<td>Lead ID:<span style="font-size:24px;color:red">*</span></td>
										<td>
											<input type="text" class="form-control" name="data[Lead]" value="<?php echo $credit_mantri_referral['Lead'] ?>" required>
										</td>
										<td>Phone Number:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control" id="phone" name="data[phone]" value="<?php echo $credit_mantri_referral['phone'] ?>" onkeyup="checkDec(this);" required></td>
									</tr>
									<tr>
										<td>CRM ID:<span style="font-size:24px;color:red">*</span></td>
										<td>
											<input type="text" class="form-control" name="data[CRM]" value="<?php echo $credit_mantri_referral['CRM'] ?>" required>
										</td>

										<td>Agent Disposition:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control" name="data[agent_disposition]" value="<?php echo $credit_mantri_referral['agent_disposition'] ?>" required></td>
										<td>QA Disposition:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control" name="data[qa_disposition]" value="<?php echo $credit_mantri_referral['qa_disposition'] ?>" required></td>
									</tr>
									<tr>
										<td>Audit Type:<span style="font-size:24px;color:red">*</span></td>
										<td>
											<select class="form-control" id="audit_type" name="data[audit_type]" required>
												<?php 
												if($credit_mantri_referral['audit_type']!=''){
													?>
													<option value="<?php echo $credit_mantri_referral['audit_type'] ?>"><?php echo $credit_mantri_referral['audit_type'] ?></option>
													<?php
												}
												?>
												<option value="">-Select-</option>
												<option value="CQ Audit">CQ Audit</option>
												<option value="BQ Audit">BQ Audit</option>
												<option value="Calibration">Calibration</option>
												<option value="Pre-Certificate Mock Call">Pre-Certificate Mock Call</option>
												<option value="Certification Audit">Certification Audit</option>
												<option value="Operation Audit">Operation Audit</option>
												<option value="Trainer Audit">Trainer Audit</option>
											</select>
										</td>
										<?php 
										if($credit_mantri_referral['auditor_type']!=''){
											?>
											<td>Auditor Type<span style="font-size:24px;color:red">*</span></td>
										<td class="form-control">
											<select class="form-control" id="auditor_type" name="data[auditor_type]">
												<?php 
												if($credit_mantri_referral['auditor_type']!=''){
													?>
													<option value="<?php echo $credit_mantri_referral['auditor_type'] ?>"><?php echo $credit_mantri_referral['auditor_type'] ?></option>
													<?php
												}
												?>
											</select>
										</td>
											<?php
										}else{
											?>
											<td class="auType">Auditor Type<span style="font-size:24px;color:red">*</span></td>
										<td class="auType">
											<select class="form-control" id="auditor_type" name="data[auditor_type]">
												<?php 
												if($credit_mantri_referral['auditor_type']!=''){
													?>
													<option value="<?php echo $credit_mantri_referral['auditor_type'] ?>"><?php echo $credit_mantri_referral['auditor_type'] ?></option>
													<?php
												}
												?>
												<option value="">-Select-</option>
												<option value="Master">Master</option>
												<option value="Regular">Regular</option>
											</select>
										</td>
											<?php
										}
										?>
										
										<td>VOC:<span style="font-size:24px;color:red">*</span></td>
										<td>
											<select class="form-control" id="voc" name="data[voc]" required>
												<?php 
												if($credit_mantri_referral['voc']!=''){
													?>
													<option value="<?php echo $credit_mantri_referral['voc'] ?>"><?php echo $credit_mantri_referral['voc'] ?></option>
													<?php
												}
												?>
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
									<tr>
									
										
										<td style="font-weight:bold; font-size:16px; text-align:right">Earned Score:</td>
										<td><input type="text" value="<?= $credit_mantri_referral['earned_score']?>" readonly id="pre_earnedScore" name="data[earned_score]" class="form-control" style="font-weight:bold"></td>
										<td style="font-weight:bold; font-size:16px; text-align:right">Possible Score:</td>
										<td><input type="text" value="<?= $credit_mantri_referral['possible_score']?>" readonly id="pre_possibleScore" name="data[possible_score]" class="form-control" style="font-weight:bold"></td>
										<td style="font-weight:bold; font-size:16px; text-align:right">Overall Score:</td>
										<td><input type="text" readonly id="pre_overallScore" name="data[overall_score]" class="form-control airmethod_email_fatal" style="font-weight:bold" value="<?php if($credit_mantri_referral['overall_score']){ echo $credit_mantri_referral['overall_score'].'%'; } else { echo '0.00'.'%'; } ?>"></td>
									</tr>
									
									<tr style=" font-weight:bold;background-color: #D3E32D ;">
										<td colspan="2">Parameter</td>
										<td>Score</td>
										<td>Legend</td>
										<td colspan=2>Remarks</td>
									</tr>
									
									<tr>
										<td colspan=2>1. Call Opening</td>
										<td>10</td>
										<td>
											<select class="form-control affinity_point" name="data[Opening]" required>
												
												<option affinity_val=10 <?php echo $credit_mantri_referral['Opening'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option affinity_val=10 <?php echo $credit_mantri_referral['Opening'] == "No"?"selected":"";?> value="No">No</option>
												<option affinity_val=0 <?php echo $credit_mantri_referral['Opening'] == "NA"?"selected":"";?> value="NA">NA</option>
											</select> 
										</td>
										<td colspan=2><input type="text" name="data[cmt1]" class="form-control" value="<?php echo $credit_mantri_referral['cmt1'] ?>"></td>
									</tr>
									<tr>
										<td colspan=2>2. Intro Pitch</td>
										<td>10</td>
										
										<td>
											<select class="form-control affinity_point" name="data[intro_pitch]" required>
												
												<option affinity_val=10 <?php echo $credit_mantri_referral['intro_pitch'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option affinity_val=10 <?php echo $credit_mantri_referral['intro_pitch'] == "No"?"selected":"";?> value="No">No</option>
												<option affinity_val=0 <?php echo $credit_mantri_referral['intro_pitch'] == "NA"?"selected":"";?> value="NA">NA</option>
											</select> 
										</td>
										<td colspan=2><input type="text" name="data[cmt2]" class="form-control" value="<?php echo $credit_mantri_referral['cmt2'] ?>"></td>
									</tr>
									<tr>
										<td colspan=2 >3. Key Focus Areas</td>
										<td >20</td>
										
										<td>
											<select class="form-control affinity_point" name="data[key_focus_area]" required>
												
												<option affinity_val=20 <?php echo $credit_mantri_referral['key_focus_area'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option affinity_val=20 <?php echo $credit_mantri_referral['key_focus_area'] == "No"?"selected":"";?> value="No">No</option>
												<option affinity_val=0 <?php echo $credit_mantri_referral['key_focus_area'] == "NA"?"selected":"";?> value="NA">NA</option>
											</select>  
										</td>
										<td colspan=2><input type="text" name="data[cmt3]" class="form-control" value="<?php echo $credit_mantri_referral['cmt3'] ?>"></td>
									</tr>
									<tr>
										<td colspan=2>4. Ojection Handling</td>
										<td>20</td>
										
										<td>
											<select class="form-control affinity_point" name="data[objection_handling]" required>
												
												<option affinity_val=20 <?php echo $credit_mantri_referral['objection_handling'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option affinity_val=20 <?php echo $credit_mantri_referral['objection_handling'] == "No"?"selected":"";?> value="No">No</option>
												<option affinity_val=0 <?php echo $credit_mantri_referral['objection_handling'] == "NA"?"selected":"";?> value="NA">NA</option>
											</select> 
										</td>
										<td colspan=2><input type="text" name="data[cmt4]" class="form-control" value="<?php echo $credit_mantri_referral['cmt4'] ?>"></td>
									</tr>
									
									<tr>
										<td colspan=2>5. Urgency creation</td>
										<td>20</td>
										
										<td>
											<select class="form-control affinity_point " name="data[urgency_creation]" required>
												
												<option affinity_val=20 <?php echo $credit_mantri_referral['urgency_creation'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option affinity_val=20 <?php echo $credit_mantri_referral['urgency_creation'] == "No"?"selected":"";?> value="No">No</option>
												<option affinity_val=0 <?php echo $credit_mantri_referral['urgency_creation'] == "NA"?"selected":"";?> value="NA">NA</option>
											</select> 
										</td>
										<td colspan=2><input type="text" name="data[cmt5]" class="form-control" value="<?php echo $credit_mantri_referral['cmt5'] ?>"></td>
									</tr>
									<tr>
										<td colspan=2>6. Referral Closure process</td>
										<td>10</td>
										
										<td>
											<select class="form-control affinity_point " name="data[referral_closure_process]" required>
												
												<option affinity_val=10 <?php echo $credit_mantri_referral['referral_closure_process'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option affinity_val=10 <?php echo $credit_mantri_referral['referral_closure_process'] == "No"?"selected":"";?> value="No">No</option>
												<option affinity_val=0 <?php echo $credit_mantri_referral['referral_closure_process'] == "NA"?"selected":"";?> value="NA">NA</option>
											</select> 
										</td>
										<td colspan=2><input type="text" name="data[cmt6]" class="form-control" value="<?php echo $credit_mantri_referral['cmt6'] ?>"></td>
									</tr>
									<tr>
										<td colspan=2>7. CRM disposition</td>
										<td>10</td>
										
										<td>
											<select class="form-control affinity_point " name="data[crm_disposition]" required>
												
												<option affinity_val=10 <?php echo $credit_mantri_referral['crm_disposition'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option affinity_val=10 <?php echo $credit_mantri_referral['crm_disposition'] == "No"?"selected":"";?> value="No">No</option>
												<option affinity_val=0 <?php echo $credit_mantri_referral['crm_disposition'] == "NA"?"selected":"";?> value="NA">NA</option>
											</select> 
										</td>
										<td colspan=2><input type="text" name="data[cmt7]" class="form-control" value="<?php echo $credit_mantri_referral['cmt7'] ?>"></td>
									</tr>
									
									<tr>
										<td colspan=2 style="color: red;">8. Fatal(Misleading or misguide customer related to loan amount/ ROI / Documents.)</td>
										<td>0</td>
										
										<td>
											<select class="form-control affinity_point" id="air_email_af1" name="data[missleading_customer]" required>
												
												<option affinity_val=0 <?php echo $credit_mantri_referral['missleading_customer'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option affinity_val=0 <?php echo $credit_mantri_referral['missleading_customer'] == "No"?"selected":"";?> value="No">No</option>
												
											</select> 
										</td>
										<td colspan=2><input type="text" name="data[cmt8]" class="form-control" value="<?php echo $credit_mantri_referral['cmt8'] ?>"></td>
									</tr>
									
									<tr>
										<td>Call Summary:</td>
										<td colspan=2><textarea class="form-control" name="data[call_summary]"><?php echo $credit_mantri_referral['call_summary'] ?></textarea></td>
										<td>Feedback:</td>
										<td colspan=2><textarea class="form-control" name="data[feedback]"><?php echo $credit_mantri_referral['feedback'] ?></textarea></td>
									</tr>
									<tr>
										<td colspan=2>Upload Files (mp3|avi|mp4|wmv|wav)</td>
										<?php if($loanxm_id==0){ ?>
											<td colspan=4><input type="file" multiple class="form-control" id="attach_file" name="attach_file[]"></td>
										<?php }else{
											if($credit_mantri_referral['attach_file']!=''){ ?>
												<td colspan=4>
													<?php $attach_file = explode(",",$credit_mantri_referral['attach_file']);
													 foreach($attach_file as $mp){ ?>
														<audio controls='' style="background-color:#607F93"> 
														  <source src="<?php echo base_url(); ?>qa_files/qa_loanxm/<?php echo $mp; ?>" type="audio/ogg">
														  <source src="<?php echo base_url(); ?>qa_files/qa_loanxm/<?php echo $mp; ?>" type="audio/mpeg">
														</audio> </br>
													 <?php } ?>
												</td>
										<?php }else{
												echo '<td colspan=6><b>No Files</b></td>';
											  }
										} ?>
									</tr>
									
									<?php if($loanxm_id!=0){ ?>
										<tr><td colspan=2 style="font-size:16px; font-weight:bold">Agent Feedback Acceptance:</td><td colspan=4><?php echo $credit_mantri_referral['agnt_fd_acpt'] ?></td></tr>
										<tr><td colspan=2 style="font-size:16px; font-weight:bold">Agent Review:</td><td colspan=4><?php echo $credit_mantri_referral['agent_rvw_note'] ?></td></tr>
										<tr><td colspan=2 style="font-size:16px; font-weight:bold">Management Review:</td><td colspan=4><?php echo $credit_mantri_referral['mgnt_rvw_note'] ?></td></tr>
										<tr><td colspan=2 style="font-size:16px; font-weight:bold">Client Review:</td><td colspan=4><?php echo $credit_mantri_referral['client_rvw_note'] ?></td></tr>
										
										<tr><td colspan=2  style="font-size:16px">Your Review<span style="font-size:24px;color:red">*</span></td><td colspan=4><textarea class="form-control1" style="width:100%" id="note" name="note" required></textarea></td></tr>
									<?php } ?>
									
									<?php 
									if($loanxm_id==0){
										if(is_access_qa_module()==true || is_access_qa_operations_module()==true){ ?>
											<tr><td colspan=6><button class="btn btn-success waves-effect" type="submit" id="qaformsubmit" style="width:500px">SAVE</button></td></tr>
									<?php 
										} 
									}else{ 
										if(is_access_qa_module()==true || is_access_qa_operations_module()==true){
											if(is_available_qa_feedback($credit_mantri_referral['entry_date'],72) == true){ ?>
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

<!-- <script>
	function checkDec(el){
		var ex = /^[0-9]+\.?[0-9]*$/;
		if(ex.test(el.value)==false){
			el.value = el.value.substring(0,el.value.length - 1);
		}
	}
</script> -->