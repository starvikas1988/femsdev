
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
				
					<div class="widget-body">
						<div class="table-responsive">
							<table class="table  skt-table" width="100%">
								<tbody>
									<tr><td colspan="6" id="theader" style="font-size:40px;text-align: center;background-color: #16A5CB ;">Debt Solution 123 [VOICEMAIL]</td></tr>
									
									<tr>
										<td>Auditor Name:</td>
										<?php if($loanxm_voicemail['entry_by']!=''){
												$auditorName = $loanxm_voicemail['auditor_name'];
											}else{
												$auditorName = $loanxm_voicemail['client_name'];
										} ?>
										<td><input type="text" class="form-control" value="<?php echo $auditorName; ?>" disabled></td>
										<td>Audit Date:</td>
										<td><input type="text" class="form-control" value="<?php echo mysql2mmddyy($loanxm_voicemail['audit_date']); ?>" disabled></td>
										<td>Call Date:</td>
										<td><input type="text" class="form-control" value="<?php echo mysql2mmddyy($loanxm_voicemail['call_date']); ?>" disabled></td>
									</tr>
									<tr>
										<td>Agent:</td>
										<td><select class="form-control" disabled><option><?php echo $loanxm_voicemail['fname']." ".$loanxm_voicemail['lname'] ?></option></select></td>
										<td>Fusion ID:</td>
										<td><input type="text" class="form-control" value="<?php echo $loanxm_voicemail['fusion_id'] ?>" disabled></td>
										<td>L1 Supervisor:</td>
										<td><select class="form-control" disabled><option><?php echo $loanxm_voicemail['tl_name'] ?></option></select></td>
									</tr>
									<tr>
										<td>Call Duration:</td>
										<td><input type="text" class="form-control" value="<?php echo $loanxm_voicemail['call_duration'] ?>" disabled ></td>
										<td>Call ID:</td>
										<td><input type="text" class="form-control" value="<?php echo $loanxm_voicemail['five9_id'] ?>" disabled ></td>
										<td>Customer Name:</td>
										<td><input type="text" class="form-control" value="<?php echo $loanxm_voicemail['customer_name'] ?>" disabled ></td>
									</tr>
									<tr>
										<td>Customer Contact number:</td>
										<td><input type="text" class="form-control" value="<?php echo $loanxm_voicemail['customer_contact'] ?>" disabled ></td>
										<td>Disposition</td>
										<td><input type="text" class="form-control" value="<?php echo $loanxm_voicemail['disposition'] ?>"disabled></td>
									</tr>
									<tr>
										<td>Audit Type:</td>
										<td><select class="form-control" disabled><option><?php echo $loanxm_voicemail['audit_type'] ?></option></select></td>
										<td>VOC:</td>
										<td><select class="form-control" disabled><option><?php echo $loanxm_voicemail['voc'] ?></option></select></td>
										<!-- <td style="font-weight:bold; font-size:16px">Overall Score:</td>
										<td ><input type="text" disabled class="form-control" style="font-weight:bold" value="<?php echo $loanxm_voicemail['overall_score'] ?>"></td> -->
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
											<select class="form-control loanxm_point business" name="data[adherence_voicemail_script]" disabled>
												<option value="">-Select-</option>
												<option loanxm_val=20 <?php echo $loanxm_voicemail['adherence_voicemail_script'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option loanxm_val=0 <?php echo $loanxm_voicemail['adherence_voicemail_script'] == "No"?"selected":"";?> value="No">No</option>
												<option loanxm_val=20 <?php echo $loanxm_voicemail['adherence_voicemail_script'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
									</tr>
									<tr>
										<td>2</td>
										<td colspan=2>Uses appropriate tone, pace, and voice inflection</td>
										<td>25</td>
										<td class="eml">Customer</td>
										<td>
											<select class="form-control loanxm_point customer" name="data[use_appropiate_tone]" disabled>
												<option value="">-Select-</option>
												<option loanxm_val=25 <?php echo $loanxm_voicemail['use_appropiate_tone'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option loanxm_val=0 <?php echo $loanxm_voicemail['use_appropiate_tone'] == "No"?"selected":"";?> value="No">No</option>
												<option loanxm_val=25 <?php echo $loanxm_voicemail['use_appropiate_tone'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
									</tr>
									<tr>
										<td>3</td>
										<td colspan=2>Did the agent use proper word choice, pronunciation, and enunciation?</td>
										<td>15</td>
										<td class="eml">Customer</td>
										<td>
											<select class="form-control loanxm_point customer" name="data[agent_use_proper_word_choice]" disabled>
												<option value="">-Select-</option>
												<option loanxm_val=15 <?php echo $loanxm_voicemail['agent_use_proper_word_choice'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option loanxm_val=0 <?php echo $loanxm_voicemail['agent_use_proper_word_choice'] == "No"?"selected":"";?> value="No">No</option>
												<option loanxm_val=15 <?php echo $loanxm_voicemail['agent_use_proper_word_choice'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>  
										</td>
									</tr>
									<tr>
										<td>4</td>
										<td colspan=2>Leaves voicemail immediately after the tone</td>
										<td>20</td>
										<td class="eml">Customer</td>
										<td>
											<select class="form-control loanxm_point customer" name="data[leave_voicemail]" disabled>
												<option value="">-Select-</option>
												<option loanxm_val=20 <?php echo $loanxm_voicemail['leave_voicemail'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option loanxm_val=0 <?php echo $loanxm_voicemail['leave_voicemail'] == "No"?"selected":"";?> value="No">No</option>
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
												<option loanxm_val=0 <?php //echo $loanxm_voicemail['disposition_in_Five9'] == "No"?"selected":"";?> value="No">No</option>
												<option loanxm_val=20 <?php //echo $loanxm_voicemail['disposition_in_Five9'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
									</tr> -->
									<tr>
										<td>5</td>
										<td colspan=2>Term Code properly in Livebox  </td>
										<td>20</td>
										<td class="eml">Business</td>
										<td>
											<select class="form-control loanxm_point business" name="data[disposition_in_livebox]" disabled>
												<option value="">-Select-</option>
												<option loanxm_val=20 <?php echo $loanxm_voicemail['disposition_in_livebox'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option loanxm_val=20 <?php echo $loanxm_voicemail['disposition_in_livebox'] == "No"?"selected":"";?> value="No">No</option>
												<option loanxm_val=20 <?php echo $loanxm_voicemail['disposition_in_livebox'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
									</tr>

									<tr>
										<td>6</td>
										<td colspan=2>Background sound quality</td>
										<td>0</td>
										<td class="eml">Business</td>
										<td>
											<select class="form-control loanxm_point" name="data[quality]" disabled="">
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
											<select class="form-control loanxm_point" name="data[quality]" disabled="">
												<option value="">-Select-</option>
												<option loanxm_val=20 <?php echo $loanxm_voicemail['quality'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option loanxm_val=20 <?php echo $loanxm_voicemail['quality'] == "No"?"selected":"";?> value="No">No</option>
												<!-- <option loanxm_val=0 <?php echo $loanxm_voicemail['quality'] == "N/A"?"selected":"";?> value="N/A">N/A</option> -->
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
										<td colspan="2"><textarea class="form-control" disabled><?php echo $loanxm_voicemail['call_summary'] ?></textarea></td>
										<td>Feedback:</td>
										<td colspan="2"><textarea class="form-control" disabled><?php echo $loanxm_voicemail['feedback'] ?></textarea></td>
									</tr>
									
									<?php if($loanxm_voicemail['attach_file']!=''){ ?>
										<tr oncontextmenu="return false;">
											<td colspan="2">Audio Files</td>
											<td colspan="4">
												<?php $attach_file = explode(",",$loanxm_voicemail['attach_file']);
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
									
									<tr><td style="font-size:16px">Manager Review:</td> <td colspan="5" style="text-align:left"><?php echo $loanxm_voicemail['mgnt_rvw_note'] ?></td></tr>
									<tr><td style="font-size:16px">Client Review:</td> <td colspan="5" style="text-align:left"><?php echo $loanxm_voicemail['client_rvw_note'] ?></td></tr>
									
									<tr><td colspan="6" style="background-color:#C5C8C8"></td></tr>
									
									<form id="form_agent_user" method="POST" action="">
									 <input type="hidden" name="pnid" class="form-control" value="<?php echo $pnid; ?>">
										
										<tr>
											<td colspan=2 style="font-size:16px">Feedback Acceptance</td>
											<td colspan=2>
												<select class="form-control" id="" name="agnt_fd_acpt" required>
													<option value="">--Select--</option>
													<option <?php echo $loanxm_voicemail['agnt_fd_acpt']=='Acceptance'?"selected":""; ?> value="Acceptance">Acceptance</option>	
													<option <?php echo $loanxm_voicemail['agnt_fd_acpt']=='Not Acceptance'?"selected":""; ?> value="Not Acceptance">Not Acceptance</option>	
												</select>
											</td>
										</tr>
										<tr>
											<td colspan=2 style="font-size:16px">Your Review</td>
											<td colspan=4><textarea class="form-control" name="note" required><?php echo $loanxm_voicemail['agent_rvw_note'] ?></textarea></td>
										</tr>
										
										<?php if(is_access_qa_agent_module()==true){
										if(is_available_qa_feedback($loanxm_voicemail['entry_date'],72) == true){ ?>
											<tr>
												<?php if($loanxm_voicemail['agent_rvw_note']==''){ ?>
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
