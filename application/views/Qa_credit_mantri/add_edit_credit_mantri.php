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
										<td colspan="6" id="theader" style="font-size:40px;text-align: center;background-color: #16A5CB ;">Credit Mantri Audit Sheet</td>
										<input type="hidden" name="audit_start_time" value="<?php echo CurrMySqlDate(); ?>">
									</tr>
									<?php
										if($loanxm_id==0){
											$auditorName = get_username();
											$auditDate = CurrDateMDY();
											$clDate_val='';
											$week="Week ".$controller->weekOfMonth(date("Y-m-d"));
										}else{
											if($credit_mantri['entry_by']!=''){
												$auditorName = $credit_mantri['auditor_name'];
											}else{
												$auditorName = $credit_mantri['client_name'];
											}
											$auditDate = mysql2mmddyy($credit_mantri['audit_date']);
											$clDate_val = mysql2mmddyy($credit_mantri['call_date']);
											$week= $credit_mantri['Week'];
										}
									?>
									<tr>
										<td style="width:16%">Auditor Name:</td>
										<td style="width:16%"><input type="text" class="form-control" value="<?php echo $auditorName; ?>" disabled></td>
										<td style="width:16%">Audit Date:</td>
										<td style="width:16%"><input type="text" class="form-control" value="<?php echo $auditDate; ?>" disabled></td>
										<td style="width:16%">Call Date:</td>
										<td style="width:16%"><input type="text" class="form-control" id="call_date" name="call_date" value="<?php echo $clDate_val; ?>" required></td>
									</tr>
									<tr>
										<td>Agent:</td>
										<td>
											<select class="form-control" id="agent_id" name="data[agent_id]" required >
												<option value="<?php echo $credit_mantri['agent_id'] ?>"><?php echo $credit_mantri['fname']." ".$credit_mantri['lname'] ?></option>
												<option value="">-Select-</option>
												<?php foreach($agentName as $row):  ?>
													<option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
												<?php endforeach; ?>
											</select>
										</td>
											<td>Fusion ID:</td>
										<td><input type="text" class="form-control" id="fusion_id" value="<?php echo $credit_mantri['fusion_id'] ?>" readonly ></td>
											<td>L1 Supervisor:</td>
										<td>
											<select class="form-control" id="tl_id" name="data[tl_id]" readonly>
												<option value="<?php echo $credit_mantri['tl_id'] ?>"><?php echo $credit_mantri['tl_name'] ?></option>
												<option value="">--Select--</option>
												<?php foreach($tlname as $tl): ?>
													<option value="<?php echo $tl['id']; ?>"><?php echo $tl['name']; ?></option>
												<?php endforeach; ?>	
											</select>
										</td>
									</tr>
									<tr>
										<td>Call Duration:</td>
										<td><input type="text" class="form-control" id="call_duration" name="data[call_duration]" value="<?php echo $credit_mantri['call_duration'] ?>" required ></td>
										<td colspan="">Week:</td>
										<td>
											<input type="text" name="" readonly class="form-control" value="<?php echo $week?>" />
										</td>
										<td>Agency:</td>
										<td>
											<input type="text" class="form-control" name="data[Agency]" value="<?php echo $credit_mantri['Agency'] ?>" required>
										</td>
									</tr>
									<tr>
										<td>OIC Name:</td>
										<td>
											<input type="text" class="form-control" name="data[OIC]" value="<?php echo $credit_mantri['OIC'] ?>" required>
										</td>
										<td>Lead ID:</td>
										<td>
											<input type="text" class="form-control" name="data[Lead]" value="<?php echo $credit_mantri['Lead'] ?>" required>
										</td>
										<td>Phone Number:</td>
										<td><input type="text" class="form-control" name="data[phone]" value="<?php echo $credit_mantri['phone'] ?>" onkeyup="checkDec(this);" required></td>
									</tr>
									<tr>
										<td>CRM ID:</td>
										<td>
											<input type="text" class="form-control" name="data[CRM]" value="<?php echo $credit_mantri['CRM'] ?>" required>
										</td>

										<td>Agent Disposition:</td>
										<td><input type="text" class="form-control" name="data[agent_disposition]" value="<?php echo $credit_mantri['agent_disposition'] ?>" required></td>
										<td>QA Disposition:</td>
										<td><input type="text" class="form-control" name="data[qa_disposition]" value="<?php echo $credit_mantri['qa_disposition'] ?>" required></td>
									</tr>
									<tr>
										<td>Audit Type:</td>
										<td>
											<select class="form-control" id="audit_type" name="data[audit_type]" required>
												<option value="<?php echo $credit_mantri['audit_type'] ?>"><?php echo $credit_mantri['audit_type'] ?></option>
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
												<option value="<?php echo $credit_mantri['voc'] ?>"><?php echo $credit_mantri['voc'] ?></option>
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
										<td><input type="text" value="<?= $credit_mantri['earned_score']?>" readonly id="pre_earnedScore" name="data[earned_score]" class="form-control" style="font-weight:bold"></td>
										<td style="font-weight:bold; font-size:16px; text-align:right">Possible Score:</td>
										<td><input type="text" value="<?= $credit_mantri['possible_score']?>" readonly id="pre_possibleScore" name="data[possible_score]" class="form-control" style="font-weight:bold"></td>
										<td style="font-weight:bold; font-size:16px; text-align:right">Overall Score:</td>
										<td><input type="text" readonly id="pre_overallScore" name="data[overall_score]" class="form-control airmethod_email_fatal" style="font-weight:bold" value="<?php if($credit_mantri['overall_score']){ echo $credit_mantri['overall_score'].'%'; } else { echo '0.00'.'%'; } ?>"></td>
									</tr>
									
									<tr style=" font-weight:bold;background-color: #D3E32D ;">
										<td colspan="2">Parameter</td>
										<td>Section</td>
										<td>Score</td>
										<td>Legend</td>
										<td colspan=2>Remarks</td>
									</tr>
									
									<tr>
										<td colspan=2>1. Call Opening</td>
										<td >Sales Skill</td>
										<td>10</td>
										<td>
											<select class="form-control affinity_point" name="data[Opening]" required>
												
												<option affinity_val=10 <?php echo $credit_mantri['Opening'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option affinity_val=10 <?php echo $credit_mantri['Opening'] == "No"?"selected":"";?> value="No">No</option>
												<option affinity_val=0 <?php echo $credit_mantri['Opening'] == "NA"?"selected":"";?> value="NA">NA</option>
											</select> 
										</td>
										<td colspan=2><input type="text" name="data[cmt1]" class="form-control" value="<?php echo $credit_mantri['cmt1'] ?>"></td>
									</tr>
									<tr>
										<td colspan=2>2. Previous interactions</td>
										<td >Sales Skill</td>
										<td>5</td>
										
										<td>
											<select class="form-control affinity_point" name="data[interactions]" required>
												
												<option affinity_val=5 <?php echo $credit_mantri['interactions'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option affinity_val=5 <?php echo $credit_mantri['interactions'] == "No"?"selected":"";?> value="No">No</option>
												<option affinity_val=0 <?php echo $credit_mantri['interactions'] == "NA"?"selected":"";?> value="NA">NA</option>
											</select> 
										</td>
										<td colspan=2><input type="text" name="data[cmt2]" class="form-control" value="<?php echo $credit_mantri['cmt2'] ?>"></td>
									</tr>
									<tr>
										<td colspan=2 >3. (Intro Pitch) On customers profile</td>
										<td >Sales Skill</td>
										<td >25</td>
										
										<td>
											<select class="form-control affinity_point" name="data[profile]" required>
												
												<option affinity_val=25 <?php echo $credit_mantri['profile'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option affinity_val=25 <?php echo $credit_mantri['profile'] == "No"?"selected":"";?> value="No">No</option>
												<option affinity_val=0 <?php echo $credit_mantri['profile'] == "NA"?"selected":"";?> value="NA">NA</option>
											</select>  
										</td>
										<td colspan=2><input type="text" name="data[cmt3]" class="form-control" value="<?php echo $credit_mantri['cmt3'] ?>"></td>
									</tr>
									<tr>
										<td colspan=2>4. Benefits Explanation / Creating Urgency / Call to action</td>
										<td >Sales Skill</td>
										<td>15</td>
										
										<td>
											<select class="form-control affinity_point" name="data[action]" required>
												
												<option affinity_val=15 <?php echo $credit_mantri['action'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option affinity_val=15 <?php echo $credit_mantri['action'] == "No"?"selected":"";?> value="No">No</option>
												<option affinity_val=0 <?php echo $credit_mantri['action'] == "NA"?"selected":"";?> value="NA">NA</option>
											</select> 
										</td>
										<td colspan=2><input type="text" name="data[cmt4]" class="form-control" value="<?php echo $credit_mantri['cmt4'] ?>"></td>
									</tr>
									
									<tr>
										<td colspan=2>5. Objection handling</td>
										<td >Technical/ Product/ Process</td>
										<td>10</td>
										
										<td>
											<select class="form-control affinity_point " name="data[handling]" required>
												
												<option affinity_val=10 <?php echo $credit_mantri['handling'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option affinity_val=10 <?php echo $credit_mantri['handling'] == "No"?"selected":"";?> value="No">No</option>
												<option affinity_val=0 <?php echo $credit_mantri['handling'] == "NA"?"selected":"";?> value="NA">NA</option>
											</select> 
										</td>
										<td colspan=2><input type="text" name="data[cmt5]" class="form-control" value="<?php echo $credit_mantri['cmt5'] ?>"></td>
									</tr>
									<tr>
										<td colspan=2>6. CFP Process explanation</td>
										<td >Sales Skill</td>
										<td>20</td>
										
										<td>
											<select class="form-control affinity_point " name="data[explanation]" required>
												
												<option affinity_val=20 <?php echo $credit_mantri['explanation'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option affinity_val=20 <?php echo $credit_mantri['explanation'] == "No"?"selected":"";?> value="No">No</option>
												<option affinity_val=0 <?php echo $credit_mantri['explanation'] == "NA"?"selected":"";?> value="NA">NA</option>
											</select> 
										</td>
										<td colspan=2><input type="text" name="data[cmt6]" class="form-control" value="<?php echo $credit_mantri['cmt6'] ?>"></td>
									</tr>
									<tr>
										<td colspan=2>7. Rate of speech</td>
										<td >Technical/ Product/ Process</td>
										<td>5</td>
										
										<td>
											<select class="form-control affinity_point " name="data[speech]" required>
												
												<option affinity_val=5 <?php echo $credit_mantri['speech'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option affinity_val=5 <?php echo $credit_mantri['speech'] == "No"?"selected":"";?> value="No">No</option>
												<option affinity_val=0 <?php echo $credit_mantri['speech'] == "NA"?"selected":"";?> value="NA">NA</option>
											</select> 
										</td>
										<td colspan=2><input type="text" name="data[cmt7]" class="form-control" value="<?php echo $credit_mantri['cmt7'] ?>"></td>
									</tr>
									

									<tr>
										<td colspan=2>8. Call disposition in CRM</td>
										<td >Technical/ Product/ Process</td>
										<td>5</td>
										
										<td>
											<select class="form-control affinity_point" name="data[disposition]" required>
												
												<option affinity_val=5 <?php echo $credit_mantri['disposition'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option affinity_val=5 <?php echo $credit_mantri['disposition'] == "No"?"selected":"";?> value="No">No</option>
												<option affinity_val=0 <?php echo $credit_mantri['disposition'] == "NA"?"selected":"";?> value="NA">NA</option>
											</select> 
										</td>
										<td colspan=2><input type="text" name="data[cmt8]" class="form-control" value="<?php echo $credit_mantri['cmt8'] ?>"></td>
									</tr>
									<tr>
										<td colspan=2>9. Summarize and Close</td>
										<td >Technical/ Product/ Process</td>
										<td>5</td>
										
										<td>
											<select class="form-control affinity_point" name="data[Close]" required>
												
												<option affinity_val=5 <?php echo $credit_mantri['Close'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option affinity_val=5 <?php echo $credit_mantri['Close'] == "No"?"selected":"";?> value="No">No</option>
												<option affinity_val=0 <?php echo $credit_mantri['Close'] == "NA"?"selected":"";?> value="NA">NA</option>
											</select> 
										</td>
										<td colspan=2><input type="text" name="data[cmt9]" class="form-control" value="<?php echo $credit_mantri['cmt9'] ?>"></td>
									</tr>
									<tr>
										<td colspan=2 style="color: red;">10.1 Fatal-Mis-Conduct/ Mis-Behavior</td>
										<td >Auto Fail</td>
										<td>0</td>
										
										<td>
											<select class="form-control affinity_point" id="air_email_af2" name="data[Behavior]" required>
												
												<option affinity_val=0 <?php echo $credit_mantri['Behavior'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option affinity_val=0 <?php echo $credit_mantri['Behavior'] == "No"?"selected":"";?> value="No">No</option>
												
											</select> 
										</td>
										<td colspan=2><input type="text" name="data[cmt10]" class="form-control" value="<?php echo $credit_mantri['cmt10'] ?>"></td>
									</tr>
									<tr>
										<td style="color: red;" colspan=2>10.2 Fatal-Mis-Sell/ Wrong Information</td>
										<td>Auto Fail</td>
										<td>0</td>
										
										<td>
											<select class="form-control affinity_point" id="air_email_af1" name="data[Information]" required>
												
												<option affinity_val=0 <?php echo $credit_mantri['Information'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option affinity_val=0 <?php echo $credit_mantri['Information'] == "No"?"selected":"";?> value="No">No</option>
												
											</select> 
										</td>
										<td colspan=2><input type="text" name="data[cmt11]" class="form-control" value="<?php echo $credit_mantri['cmt11'] ?>"></td>
									</tr>
									
									

									<tr>
										<td>Call Summary:</td>
										<td colspan=2><textarea class="form-control" name="data[call_summary]"><?php echo $credit_mantri['call_summary'] ?></textarea></td>
										<td>Feedback:</td>
										<td colspan=2><textarea class="form-control" name="data[feedback]"><?php echo $credit_mantri['feedback'] ?></textarea></td>
									</tr>
									<tr>
										<td colspan=2>Upload Files (mp3,mp4,jpg,jpeg,png)</td>
										<?php if($loanxm_id==0){ ?>
											<td colspan=4><input type="file" multiple class="form-control" id="attach_file" name="attach_file[]"></td>
										<?php }else{
											if($credit_mantri['attach_file']!=''){ ?>
												<td colspan=4>
													<?php $attach_file = explode(",",$credit_mantri['attach_file']);
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
										<tr><td colspan=2 style="font-size:16px; font-weight:bold">Agent Feedback Acceptance:</td><td colspan=4><?php echo $credit_mantri['agnt_fd_acpt'] ?></td></tr>
										<tr><td colspan=2 style="font-size:16px; font-weight:bold">Agent Review:</td><td colspan=4><?php echo $credit_mantri['agent_rvw_note'] ?></td></tr>
										<tr><td colspan=2 style="font-size:16px; font-weight:bold">Management Review:</td><td colspan=4><?php echo $credit_mantri['mgnt_rvw_note'] ?></td></tr>
										<tr><td colspan=2 style="font-size:16px; font-weight:bold">Client Review:</td><td colspan=4><?php echo $credit_mantri['client_rvw_note'] ?></td></tr>
										
										<tr><td colspan=2  style="font-size:16px">Your Review</td><td colspan=4><textarea class="form-control1" style="width:100%" id="note" name="note"></textarea></td></tr>
									<?php } ?>
									
									<?php 
									if($loanxm_id==0){
										if(is_access_qa_module()==true || is_access_qa_operations_module()==true){ ?>
											<tr><td colspan=6><button class="btn btn-success waves-effect" type="submit" id="qaformsubmit" style="width:500px">SAVE</button></td></tr>
									<?php 
										} 
									}else{ 
										if(is_access_qa_module()==true || is_access_qa_operations_module()==true){
											if(is_available_qa_feedback($credit_mantri['entry_date'],72) == true){ ?>
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


<script>
	function checkDec(el){
		var ex = /^[0-9]+\.?[0-9]*$/;
		if(ex.test(el.value)==false){
			el.value = el.value.substring(0,el.value.length - 1);
		}
	}
</script>