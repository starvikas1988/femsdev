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
										<td colspan="6" id="theader" style="font-size:40px;text-align: center;background-color: #16A5CB ;">Debt Solution 123 [VOICEMAIL]</td>
										<input type="hidden" name="audit_start_time" value="<?php echo CurrMySqlDate(); ?>">
									</tr>
									<?php
										if($loanxm_id==0){
											$auditorName = get_username();
											$auditDate = CurrDateMDY();
											$clDate_val='';
										}else{
											if($loanxm_voicemail['entry_by']!=''){
												$auditorName = $loanxm_voicemail['auditor_name'];
											}else{
												$auditorName = $loanxm_voicemail['client_name'];
											}
											$auditDate = mysql2mmddyy($loanxm_voicemail['audit_date']);
											$clDate_val = mysql2mmddyy($loanxm_voicemail['call_date']);
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
												<option value="<?php echo $loanxm_voicemail['agent_id'] ?>"><?php echo $loanxm_voicemail['fname']." ".$loanxm_voicemail['lname'] ?></option>
												<option value="">-Select-</option>
												<?php foreach($agentName as $row):  ?>
													<option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
												<?php endforeach; ?>
											</select>
										</td>
											<td>Fusion ID:</td>
										<td><input type="text" class="form-control" id="fusion_id" value="<?php echo $loanxm_voicemail['fusion_id'] ?>" readonly ></td>
											<td>L1 Supervisor:</td>
										<td>
											<select class="form-control" id="tl_id" name="data[tl_id]" readonly>
												<option value="<?php echo $loanxm_voicemail['tl_id'] ?>"><?php echo $loanxm_voicemail['tl_name'] ?></option>
												<option value="">--Select--</option>
												<?php foreach($tlname as $tl): ?>
													<option value="<?php echo $tl['id']; ?>"><?php echo $tl['name']; ?></option>
												<?php endforeach; ?>	
											</select>
										</td>
									</tr>
									<tr>
										<td>Call Duration:</td>
										<td><input type="text" class="form-control" id="call_duration" name="data[call_duration]" value="<?php echo $loanxm_voicemail['call_duration'] ?>" required ></td>
										<td>Call ID:</td>
										<td><input type="text" class="form-control" name="data[five9_id]" value="<?php echo $loanxm_voicemail['five9_id'] ?>" required ></td>
										<td>Customer Name:</td>
										<td><input type="text" class="form-control" name="data[customer_name]" value="<?php echo $loanxm_voicemail['customer_name'] ?>" required ></td>
									</tr>
									<tr>
										<td>Customer Contact number:</td>
										<td><input type="text" class="form-control" name="data[customer_contact]" value="<?php echo $loanxm_voicemail['customer_contact'] ?>" required ></td>
										<td>Disposition</td>
										<td><input type="text" class="form-control" name="data[disposition]" value="<?php echo $loanxm_voicemail['disposition'] ?>"required></td>
									</tr>
									<tr>
										<td>Audit Type:</td>
										<td>
											<select class="form-control" id="audit_type" name="data[audit_type]" required>
												<option value="<?php echo $loanxm_voicemail['audit_type'] ?>"><?php echo $loanxm_voicemail['audit_type'] ?></option>
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
												<option value="<?php echo $loanxm_voicemail['voc'] ?>"><?php echo $loanxm_voicemail['voc'] ?></option>
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
										<td style="font-weight:bold; font-size:16px;">Pass/Fail</td>
										<td><input type="text" readonly id="loanxm_passfail" name="data[pass_fail]" class="form-control" value="<?php echo $loanxm_voicemail['pass_fail'] ?>"></td>
									</tr>
									<tr>
										<td style="font-weight:bold; font-size:16px; text-align:right">Earned Score:</td>
										<td><input type="text" value="<?= $loanxm_voicemail['earned_score']?>" readonly id="loanxm_earnedScore" name="data[earned_score]" class="form-control" style="font-weight:bold"></td>
										<td style="font-weight:bold; font-size:16px; text-align:right">Possible Score:</td>
										<td><input type="text" value="<?= $loanxm_voicemail['possible_score']?>" readonly id="loanxm_possibleScore" name="data[possible_score]" class="form-control" style="font-weight:bold"></td>
										<td style="font-weight:bold; font-size:16px; text-align:right">Overall Score:</td>
										<td><input type="text" readonly id="loanxmOverallScore" name="data[overall_score]" class="form-control loanxmFatal_ds" style="font-weight:bold" value="<?php if($loanxm_voicemail['overall_score']){ echo $loanxm_voicemail['overall_score'].'%'; } else { echo '0.00'.'%'; } ?>"></td>
									</tr>
									
									<tr style=" font-weight:bold;background-color: #D3E32D ;">
										<td>#</td><td colspan="2">Question</td><td>Points</td><td>Criticalities</td><td>Score</td>
									</tr>
									<tr>
										<td>1</td>
										<td colspan=2>Adherence to Voicemail script</td>
										<td>20</td>
										<td class="eml">Business</td>
										<td>
											<select class="form-control loanxm_point business" name="data[adherence_voicemail_script]" required>
												<option value="">-Select-</option>
												<option loanxm_val=20 <?php echo $loanxm_voicemail['adherence_voicemail_script'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option loanxm_val=20 <?php echo $loanxm_voicemail['adherence_voicemail_script'] == "No"?"selected":"";?> value="No">No</option>
												<option loanxm_val=20 <?php echo $loanxm_voicemail['adherence_voicemail_script'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
									</tr>
									<tr>
										<td>2</td>
										<td colspan=2>Uses appropriate tone, pace, and voice inflection</td>
										<td>20</td>
										<td class="eml">Customer</td>
										<td>
											<select class="form-control loanxm_point customer" name="data[use_appropiate_tone]" required>
												<option value="">-Select-</option>
												<option loanxm_val=20 <?php echo $loanxm_voicemail['use_appropiate_tone'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option loanxm_val=20 <?php echo $loanxm_voicemail['use_appropiate_tone'] == "No"?"selected":"";?> value="No">No</option>
												<option loanxm_val=20 <?php echo $loanxm_voicemail['use_appropiate_tone'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
									</tr>
									<tr>
										<td>3</td>
										<td colspan=2>Did the agent use proper word choice, pronunciation, and enunciation?</td>
										<td>10</td>
										<td class="eml">Customer</td>
										<td>
											<select class="form-control loanxm_point customer" name="data[agent_use_proper_word_choice]" required>
												<option value="">-Select-</option>
												<option loanxm_val=10 <?php echo $loanxm_voicemail['agent_use_proper_word_choice'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option loanxm_val=10 <?php echo $loanxm_voicemail['agent_use_proper_word_choice'] == "No"?"selected":"";?> value="No">No</option>
												<option loanxm_val=10 <?php echo $loanxm_voicemail['agent_use_proper_word_choice'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>  
										</td>
									</tr>
									<tr>
										<td>4</td>
										<td colspan=2>Leaves voicemail immediately after the tone</td>
										<td>20</td>
										<td class="eml">Customer</td>
										<td>
											<select class="form-control loanxm_point customer" name="data[leave_voicemail]" required>
												<option value="">-Select-</option>
												<option loanxm_val=20 <?php echo $loanxm_voicemail['leave_voicemail'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option loanxm_val=20 <?php echo $loanxm_voicemail['leave_voicemail'] == "No"?"selected":"";?> value="No">No</option>
												<option loanxm_val=20 <?php echo $loanxm_voicemail['leave_voicemail'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
									</tr>
									<!-- <tr>
										<td>5</td>
										<td colspan=2>Dispositioned properly in Five9</td>
										<td>20</td>
										<td class="eml">Business</td>
										<td>
											<select class="form-control loanxm_point business" name="data[disposition_in_Five9]" required>
												<option value="">-Select-</option>
												<option loanxm_val=20 <?php //echo $loanxm_voicemail['disposition_in_Five9'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option loanxm_val=20 <?php //echo $loanxm_voicemail['disposition_in_Five9'] == "No"?"selected":"";?> value="No">No</option>
												<option loanxm_val=20 <?php //echo $loanxm_voicemail['disposition_in_Five9'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
									</tr> -->
									<tr>
										<td>5</td>
										<td colspan=2>Term Code properly in Livebox Dispositioned properly in Livebox </td>
										<td>10</td>
										<td class="eml">Business</td>
										<td>
											<select class="form-control loanxm_point business" name="data[disposition_in_livebox]" required>
												<option value="">-Select-</option>
												<option loanxm_val=10 <?php echo $loanxm_voicemail['disposition_in_livebox'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option loanxm_val=10 <?php echo $loanxm_voicemail['disposition_in_livebox'] == "No"?"selected":"";?> value="No">No</option>
												<option loanxm_val=10 <?php echo $loanxm_voicemail['disposition_in_livebox'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
									</tr>

									<tr>
										<td>6</td>
										<td colspan=2>Background sound quality</td>
										<td>0</td>
										<td class="eml">Customer</td>
										<td>
											<select class="form-control loanxm_point customer" name="data[quality]" required>
												<option value="">-Select-</option>
												<option loanxm_val=0 <?php echo $loanxm_voicemail['quality'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option loanxm_val=0 <?php echo $loanxm_voicemail['quality'] == "No"?"selected":"";?> value="No">No</option>
												<!-- <option loanxm_val=0 <?php echo $loanxm_voicemail['quality'] == "N/A"?"selected":"";?> value="N/A">N/A</option> -->
											</select> 
										</td>
									</tr>
									<tr>
										<td>7</td>
										<td colspan=2>Timely term coding of call</td>
										<td>20</td>
										<td class="eml">Business</td>
										<td>
											<select class="form-control loanxm_point business" name="data[timely_coding]" required>
												<option value="">-Select-</option>
												<option loanxm_val=20 <?php echo $loanxm_voicemail['timely_coding'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option loanxm_val=20 <?php echo $loanxm_voicemail['timely_coding'] == "No"?"selected":"";?> value="No">No</option>
												<!-- <option loanxm_val=0 <?php echo $loanxm_voicemail['timely_coding'] == "N/A"?"selected":"";?> value="N/A">N/A</option> -->
											</select> 
										</td>
									</tr>


									<tr style="background-color:#D2B4DE"><td colspan=2>Customer Score</td><td colspan=2>Business Score</td><td colspan=2>Compliance Score</td></tr>
									<tr style="background-color:#D2B4DE">
										<td>Earned:</td><td id="custJiCisEarned"></td><td>Earned:</td><td id="busiJiCisEarned"></td><td>Earned:</td><td id="complJiCisEarned"></td>
									</tr>
									<tr style="background-color:#D2B4DE">
										<td>Possible:</td><td id="custJiCisPossible"></td><td>Possible:</td><td id="busiJiCisPossible"></td><td>Possible:</td><td id="complJiCisPossible"></td>
									</tr>
									<tr style="background-color:#D2B4DE">
										<td>Percentage:</td><td><input type="text" readonly style="background-color:#D2B4DE; text-align:center" class="form-control" id="custJiCisScore" name="data[customer_score]" value="<?php echo $loanxm_voicemail['customer_score'] ?>"></td>
										<td>Percentage:</td><td><input type="text" readonly style="background-color:#D2B4DE; text-align:center" class="form-control" id="busiJiCisScore" name="data[business_score]" value="<?php echo $loanxm_voicemail['business_score'] ?>"></td>
										<td>Percentage:</td><td><input type="text" readonly style="background-color:#D2B4DE; text-align:center" class="form-control" id="complJiCisScore" name="data[compliance_score]" value="<?php echo $loanxm_voicemail['compliance_score'] ?>"></td>
									</tr>
									<tr>
										<td>Call Summary:</td>
										<td colspan=2><textarea class="form-control" name="data[call_summary]"><?php echo $loanxm_voicemail['call_summary'] ?></textarea></td>
										<td>Feedback:</td>
										<td colspan=2><textarea class="form-control" name="data[feedback]"><?php echo $loanxm_voicemail['feedback'] ?></textarea></td>
									</tr>
									<tr>
										<td colspan=2>Upload Files</td>
										<?php if($loanxm_id==0){ ?>
											<td colspan=4><input type="file" multiple class="form-control" id="attach_file" name="attach_file[]"></td>
										<?php }else{
											if($loanxm_voicemail['attach_file']!=''){ ?>
												<td colspan=4>
													<?php $attach_file = explode(",",$loanxm_voicemail['attach_file']);
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
										<tr><td colspan=2 style="font-size:16px; font-weight:bold">Agent Feedback Acceptance:</td><td colspan=4><?php echo $loanxm_voicemail['agnt_fd_acpt'] ?></td></tr>
										<tr><td colspan=2 style="font-size:16px; font-weight:bold">Agent Review:</td><td colspan=4><?php echo $loanxm_voicemail['agent_rvw_note'] ?></td></tr>
										<tr><td colspan=2 style="font-size:16px; font-weight:bold">Management Review:</td><td colspan=4><?php echo $loanxm_voicemail['mgnt_rvw_note'] ?></td></tr>
										<tr><td colspan=2 style="font-size:16px; font-weight:bold">Client Review:</td><td colspan=4><?php echo $loanxm_voicemail['client_rvw_note'] ?></td></tr>
										
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
											if(is_available_qa_feedback($loanxm_voicemail['entry_date'],72) == true){ ?>
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
