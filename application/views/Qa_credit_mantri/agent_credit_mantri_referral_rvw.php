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
	background-color:#85C1E9;
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
							<table class="table  skt-table" width="100%">
								<tbody>
									<tr>
										<td colspan="6" id="theader" style="font-size:40px;text-align: center;background-color: #16A5CB ;">Credit Mantri Referral Audit Sheet</td>
										<input type="hidden" name="audit_start_time" value="<?php echo CurrMySqlDate(); ?>">
									</tr>
									<?php if($credit_mantri_referral['entry_by']!=''){
												$auditorName = $credit_mantri_referral['auditor_name'];
												$week="Week ".$controller->weekOfMonth(date("Y-m-d"));
											}else{
												$auditorName = $credit_mantri_referral['client_name'];
												$week= $pre_booking['Week'];
										} ?>
									<tr>
										<td>Auditor Name:</td>
										<td><input type="text" class="form-control" value="<?php echo $auditorName; ?>" disabled></td>
										<td>Audit Date:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control" value="<?php echo mysql2mmddyy($credit_mantri_referral['audit_date']); ?>" disabled></td>
										<td>Call Date:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control" value="<?php echo mysql2mmddyy($credit_mantri_referral['call_date']); ?>" disabled></td>
									</tr>
									<tr>
										<td>Agent:<span style="font-size:24px;color:red">*</span></td>
										<td><select class="form-control" disabled><option><?php echo $credit_mantri_referral['fname']." ".$credit_mantri_referral['lname'] ?></option></select></td>
										<td>Fusion ID:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control" value="<?php echo $credit_mantri_referral['fusion_id'] ?>" disabled></td>
										<td>L1 Supervisor:<span style="font-size:24px;color:red">*</span></td>
										<td><select class="form-control" disabled><option><?php echo $credit_mantri_referral['tl_name'] ?></option></select></td>
									</tr>
									<tr>
										<td>Call Duration:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control" id="call_duration" name="data[call_duration]" value="<?php echo $credit_mantri_referral['call_duration'] ?>" disabled ></td>
										<td colspan="">Week:<span style="font-size:24px;color:red">*</span></td>
										<td>
											<input type="text" name="" readonly class="form-control" value="<?php echo $week?>" />
										</td>
										<td>Agency:<span style="font-size:24px;color:red">*</span></td>
										<td>
											<input type="text" class="form-control" name="data[Agency]" value="<?php echo $credit_mantri_referral['Agency'] ?>" disabled>
										</td>
									
									</tr>

									<tr>
										<td>OIC Name:<span style="font-size:24px;color:red">*</span></td>
										<td>
											<input type="text" class="form-control" name="data[OIC]" value="<?php echo $credit_mantri_referral['OIC'] ?>" disabled>
										</td>
										<td>Lead ID:<span style="font-size:24px;color:red">*</span></td>
										<td>
											<input type="text" class="form-control" name="data[Lead]" value="<?php echo $credit_mantri_referral['Lead'] ?>" disabled>
										</td>
										<td>Phone Number:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control" name="data[phone]" value="<?php echo $credit_mantri_referral['phone'] ?>" onkeyup="checkDec(this);" disabled></td>
									</tr>
									<tr>
										<td>CRM ID:<span style="font-size:24px;color:red">*</span></td>
										<td>
											<input type="text" class="form-control" name="data[CRM]" value="<?php echo $credit_mantri_referral['CRM'] ?>" disabled>
										</td>

										<td>Agent Disposition:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control" name="data[agent_disposition]" value="<?php echo $credit_mantri_referral['agent_disposition'] ?>" disabled></td>
										<td>QA Disposition:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control" name="data[qa_disposition]" value="<?php echo $credit_mantri_referral['qa_disposition'] ?>" disabled></td>
									</tr>
									<tr>
										<td>Audit Type:<span style="font-size:24px;color:red">*</span></td>
										<td><select class="form-control" disabled><option><?php echo $credit_mantri_referral['audit_type'] ?></option></select></td>
										<?php
										if($credit_mantri_referral['auditor_type']!=''){
											?>
										<td class="auType">Auditor Type<span style="font-size:24px;color:red">*</span></td>
										<td><select class="form-control" disabled><option><?php echo $credit_mantri_referral['auditor_type'] ?></option></select></td>
											<?php
										}
										?>
										<td>VOC:<span style="font-size:24px;color:red">*</span></td>
										<td><select class="form-control" disabled><option><?php echo $credit_mantri_referral['voc'] ?></option></select></td>
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
											<select class="form-control affinity_point" name="data[Opening]" disabled>
												
												<option affinity_val=10 <?php echo $credit_mantri_referral['Opening'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option affinity_val=10 <?php echo $credit_mantri_referral['Opening'] == "No"?"selected":"";?> value="No">No</option>
												<option affinity_val=0 <?php echo $credit_mantri_referral['Opening'] == "NA"?"selected":"";?> value="NA">NA</option>
											</select> 
										</td>
										<td colspan=2><input type="text" name="data[cmt1]" class="form-control" value="<?php echo $credit_mantri_referral['cmt1'] ?>" disabled></td>
									</tr>
									<tr>
										<td colspan=2>2. Intro Pitch</td>
										<td>10</td>
										
										<td>
											<select class="form-control affinity_point" name="data[intro_pitch]" disabled>
												
												<option affinity_val=10 <?php echo $credit_mantri_referral['intro_pitch'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option affinity_val=10 <?php echo $credit_mantri_referral['intro_pitch'] == "No"?"selected":"";?> value="No">No</option>
												<option affinity_val=0 <?php echo $credit_mantri_referral['intro_pitch'] == "NA"?"selected":"";?> value="NA">NA</option>
											</select> 
										</td>
										<td colspan=2><input type="text" name="data[cmt2]" class="form-control" value="<?php echo $credit_mantri_referral['cmt2'] ?>" disabled></td>
									</tr>
									<tr>
										<td colspan=2 >3. Key Focus Areas</td>
										<td >20</td>
										
										<td>
											<select class="form-control affinity_point" name="data[key_focus_area]" disabled>
												
												<option affinity_val=20 <?php echo $credit_mantri_referral['key_focus_area'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option affinity_val=20 <?php echo $credit_mantri_referral['key_focus_area'] == "No"?"selected":"";?> value="No">No</option>
												<option affinity_val=0 <?php echo $credit_mantri_referral['key_focus_area'] == "NA"?"selected":"";?> value="NA">NA</option>
											</select>  
										</td>
										<td colspan=2><input type="text" name="data[cmt3]" class="form-control" value="<?php echo $credit_mantri_referral['cmt3'] ?>" disabled></td>
									</tr>
									<tr>
										<td colspan=2>4. Ojection Handling</td>
										<td>20</td>
										
										<td>
											<select class="form-control affinity_point" name="data[objection_handling]" disabled>
												
												<option affinity_val=20 <?php echo $credit_mantri_referral['objection_handling'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option affinity_val=20 <?php echo $credit_mantri_referral['objection_handling'] == "No"?"selected":"";?> value="No">No</option>
												<option affinity_val=0 <?php echo $credit_mantri_referral['objection_handling'] == "NA"?"selected":"";?> value="NA">NA</option>
											</select> 
										</td>
										<td colspan=2><input type="text" name="data[cmt4]" class="form-control" value="<?php echo $credit_mantri_referral['cmt4'] ?>" disabled></td>
									</tr>
									
									<tr>
										<td colspan=2>5. Urgency creation</td>
										<td>20</td>
										
										<td>
											<select class="form-control affinity_point " name="data[urgency_creation]" disabled>
												
												<option affinity_val=20 <?php echo $credit_mantri_referral['urgency_creation'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option affinity_val=20 <?php echo $credit_mantri_referral['urgency_creation'] == "No"?"selected":"";?> value="No">No</option>
												<option affinity_val=0 <?php echo $credit_mantri_referral['urgency_creation'] == "NA"?"selected":"";?> value="NA">NA</option>
											</select> 
										</td>
										<td colspan=2><input type="text" name="data[cmt5]" class="form-control" value="<?php echo $credit_mantri_referral['cmt5'] ?>" disabled></td>
									</tr>
									<tr>
										<td colspan=2>6. Referral Closure process</td>
										<td>10</td>
										
										<td>
											<select class="form-control affinity_point " name="data[referral_closure_process]" disabled>
												
												<option affinity_val=10 <?php echo $credit_mantri_referral['referral_closure_process'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option affinity_val=10 <?php echo $credit_mantri_referral['referral_closure_process'] == "No"?"selected":"";?> value="No">No</option>
												<option affinity_val=0 <?php echo $credit_mantri_referral['referral_closure_process'] == "NA"?"selected":"";?> value="NA">NA</option>
											</select> 
										</td>
										<td colspan=2><input type="text" name="data[cmt6]" class="form-control" value="<?php echo $credit_mantri_referral['cmt6'] ?>" disabled></td>
									</tr>
									<tr>
										<td colspan=2>7. CRM disposition</td>
										<td>10</td>
										
										<td>
											<select class="form-control affinity_point " name="data[crm_disposition]" disabled>
												
												<option affinity_val=10 <?php echo $credit_mantri_referral['crm_disposition'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option affinity_val=10 <?php echo $credit_mantri_referral['crm_disposition'] == "No"?"selected":"";?> value="No">No</option>
												<option affinity_val=0 <?php echo $credit_mantri_referral['crm_disposition'] == "NA"?"selected":"";?> value="NA">NA</option>
											</select> 
										</td>
										<td colspan=2><input type="text" name="data[cmt7]" class="form-control" value="<?php echo $credit_mantri_referral['cmt7'] ?>" disabled></td>
									</tr>
									
									<tr>
										<td colspan=2 style="color: red;">8. Fatal(Misleading or misguide customer related to loan amount/ ROI / Documents.)</td>
										<td>0</td>
										
										<td>
											<select class="form-control affinity_point" id="air_email_af1" name="data[missleading_customer]" disabled>
												
												<option affinity_val=0 <?php echo $credit_mantri_referral['missleading_customer'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option affinity_val=0 <?php echo $credit_mantri_referral['missleading_customer'] == "No"?"selected":"";?> value="No">No</option>
												
											</select> 
										</td>
										<td colspan=2><input type="text" name="data[cmt8]" class="form-control" value="<?php echo $credit_mantri_referral['cmt8'] ?>" disabled></td>
									</tr>
									
									<tr>
										<td>Call Summary:</td>
										<td colspan=2><textarea class="form-control" disabled name="data[call_summary]"><?php echo $credit_mantri_referral['call_summary'] ?></textarea></td>
										<td>Feedback:</td>
										<td colspan=2><textarea class="form-control" disabled name="data[feedback]"><?php echo $credit_mantri_referral['feedback'] ?></textarea></td>
									</tr>
									<?php if($credit_mantri_referral['attach_file']!=''){ ?>
										<tr oncontextmenu="return false;">
											<td colspan="2">Audio Files (mp3|avi|mp4|wmv|wav)</td>
											<td colspan="4">
												<?php $attach_file = explode(",",$credit_mantri_referral['attach_file']);
												 foreach($attach_file as $mp){ ?>
													<audio controls='' style="background-color:#607F93"> 
													  <source src="<?php echo base_url(); ?>qa_files/qa_loanxm/<?php echo $mp; ?>" type="audio/ogg">
													  <source src="<?php echo base_url(); ?>qa_files/qa_loanxm/<?php echo $mp; ?>" type="audio/mpeg">
													</audio> </br>
												 <?php } ?>
											</td>
										</tr>
									<?php } ?>
									
									<tr><td colspan="6" style="background-color:#C5C8C8"></td></tr>
									
									<tr><td style="font-size:16px">Manager Review:</td> <td colspan="5" style="text-align:left"><?php echo $credit_mantri_referral['mgnt_rvw_note'] ?></td></tr>
									<tr><td style="font-size:16px">Client Review:</td> <td colspan="5" style="text-align:left"><?php echo $credit_mantri_referral['client_rvw_note'] ?></td></tr>
									
									<tr><td colspan="6" style="background-color:#C5C8C8"></td></tr>
									
									<form id="form_agent_user" method="POST" action="">
									 <input type="hidden" name="pnid" class="form-control" value="<?php echo $pnid; ?>">
									 <input type="hidden" name="campaign" class="form-control" value="credit_mantri_referral">
										
										<tr>
											<td colspan=2 style="font-size:16px">Feedback Acceptance<span style="font-size:24px;color:red">*</span></td>
											<td colspan=2>
												<select class="form-control" id="" name="agnt_fd_acpt" required>
													<option value="">--Select--</option>
													<option <?php echo $credit_mantri_referral['agnt_fd_acpt']=='Acceptance'?"selected":""; ?> value="Acceptance">Acceptance</option>	
													<option <?php echo $credit_mantri_referral['agnt_fd_acpt']=='Not Acceptance'?"selected":""; ?> value="Not Acceptance">Not Acceptance</option>	
												</select>
											</td>
										</tr>
										<tr>
											<td colspan=2 style="font-size:16px">Your Review<span style="font-size:24px;color:red">*</span></td>
											<td colspan=4><textarea class="form-control" name="note" required="" ><?php echo $credit_mantri_referral['agent_rvw_note'] ?></textarea></td>
										</tr>
										
										<?php if(is_access_qa_agent_module()==true){
										if(is_available_qa_feedback($credit_mantri_referral['entry_date'],72) == true){ ?>
											<tr>
												<?php if($credit_mantri_referral['agent_rvw_note']==''){ ?>
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
					
				  </form>
					
				</div>
			</div>
		</div>

	</section>
</div>


<script>
	function checkDec(el){
		var ex = /^[0-9]+\.?[0-9]*$/;
		if(ex.test(el.value)==false){
			el.value = el.value.substring(0,el.value.length - 1);
		}
	}
</script>