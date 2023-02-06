
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
									<tr><td colspan="6" id="theader" style="font-size:40px;text-align: center;background-color: #16A5CB ;">Credit Mantri Quality Audit Form</td></tr>
									
									<tr>
										<td>Auditor Name:</td>
										<?php if($credit_mantri['entry_by']!=''){
												$auditorName = $credit_mantri['auditor_name'];
												$week="Week ".$controller->weekOfMonth(date("Y-m-d"));
											}else{
												$auditorName = $credit_mantri['client_name'];
												$week= $pre_booking['Week'];
										} ?>
										<td><input type="text" class="form-control" value="<?php echo $auditorName; ?>" disabled></td>
										<td>Audit Date:</td>
										<td><input type="text" class="form-control" value="<?php echo mysql2mmddyy($credit_mantri['audit_date']); ?>" disabled></td>
										<td>Call Date:</td>
										<td><input type="text" class="form-control" value="<?php echo mysql2mmddyy($credit_mantri['call_date']); ?>" disabled></td>
									</tr>
									<tr>
										<td>Agent:</td>
										<td><select class="form-control" disabled><option><?php echo $credit_mantri['fname']." ".$credit_mantri['lname'] ?></option></select></td>
										<td>Fusion ID:</td>
										<td><input type="text" class="form-control" value="<?php echo $credit_mantri['fusion_id'] ?>" disabled></td>
										<td>L1 Supervisor:</td>
										<td><select class="form-control" disabled><option><?php echo $credit_mantri['tl_name'] ?></option></select></td>
									</tr>
									<tr>
										
										
										<td>Call Duration:</td>
										<td><input type="text" class="form-control" id="call_duration" name="data[call_duration]" value="<?php echo $credit_mantri['call_duration'] ?>" disabled ></td>
										<td colspan="">Week:</td>
										<td>
											<input type="text" name="" readonly class="form-control" value="<?php echo $week?>" />
										</td>
										<td>Agency:</td>
										<td>
											<input type="text" class="form-control" name="data[Agency]" value="<?php echo $credit_mantri['Agency'] ?>" disabled>
										</td>
									
									</tr>
									<tr>
										<td>OIC Name:</td>
										<td>
											<input type="text" class="form-control" name="data[OIC]" value="<?php echo $credit_mantri['OIC'] ?>" disabled>
										</td>
										<td>Lead ID:</td>
										<td>
											<input type="text" class="form-control" name="data[Lead]" value="<?php echo $credit_mantri['Lead'] ?>" disabled>
										</td>
										<td>Phone Number:</td>
										<td><input type="text" class="form-control" name="data[phone]" value="<?php echo $credit_mantri['phone'] ?>" onkeyup="checkDec(this);" disabled></td>
									</tr>
									<tr>
										<td>CRM ID:</td>
										<td>
											<input type="text" class="form-control" name="data[CRM]" value="<?php echo $credit_mantri['CRM'] ?>" disabled>
										</td>

										<td>Agent Disposition:</td>
										<td><input type="text" class="form-control" name="data[agent_disposition]" value="<?php echo $credit_mantri['agent_disposition'] ?>" disabled></td>
										<td>QA Disposition:</td>
										<td><input type="text" class="form-control" name="data[qa_disposition]" value="<?php echo $credit_mantri['qa_disposition'] ?>" disabled></td>
									</tr>
									<tr>
										<td>Audit Type:</td>
										<td><select class="form-control" disabled><option><?php echo $credit_mantri['audit_type'] ?></option></select></td>
										<td>VOC:</td>
										<td><select class="form-control" disabled><option><?php echo $credit_mantri['voc'] ?></option></select></td>
										<!-- <td style="font-weight:bold; font-size:16px">Overall Score:</td>
										<td ><input type="text" disabled class="form-control" style="font-weight:bold" value="<?php echo $credit_mantri['overall_score'] ?>"></td> -->
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
											<select class="form-control affinity_point" name="data[Opening]" disabled>
												
												<option affinity_val=10 <?php echo $credit_mantri['Opening'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option affinity_val=10 <?php echo $credit_mantri['Opening'] == "No"?"selected":"";?> value="No">No</option>
												<option affinity_val=10 <?php echo $credit_mantri['Opening'] == "NA"?"selected":"";?> value="NA">NA</option>
											</select> 
										</td>
										<td colspan=2><input type="text" name="data[cmt1]" class="form-control" value="<?php echo $credit_mantri['cmt1'] ?>"disabled></td>
									</tr>
									<tr>
										<td colspan=2>2. Previous interactions</td>
										<td >Sales Skill</td>
										<td>5</td>
										
										<td>
											<select class="form-control affinity_point" name="data[interactions]" disabled>
												
												<option affinity_val=5 <?php echo $credit_mantri['interactions'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option affinity_val=5 <?php echo $credit_mantri['interactions'] == "No"?"selected":"";?> value="No">No</option>
												<option affinity_val=5 <?php echo $credit_mantri['interactions'] == "NA"?"selected":"";?> value="NA">NA</option>
											</select> 
										</td>
										<td colspan=2><input type="text" name="data[cmt2]" class="form-control" value="<?php echo $credit_mantri['cmt2'] ?>"disabled></td>
									</tr>
									<tr>
										<td colspan=2 >3. (Intro Pitch) On customers profile</td>
										<td >Sales Skill</td>
										<td >25</td>
										
										<td>
											<select class="form-control affinity_point" name="data[profile]" disabled>
												
												<option affinity_val=25 <?php echo $credit_mantri['profile'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option affinity_val=25 <?php echo $credit_mantri['profile'] == "No"?"selected":"";?> value="No">No</option>
												<option affinity_val=25 <?php echo $credit_mantri['profile'] == "NA"?"selected":"";?> value="NA">NA</option>
											</select>  
										</td>
										<td colspan=2><input type="text" name="data[cmt3]" class="form-control" value="<?php echo $credit_mantri['cmt3'] ?>"disabled></td>
									</tr>
									<tr>
										<td colspan=2>4. Benefits Explanation / Creating Urgency / Call to action</td>
										<td >Sales Skill</td>
										<td>15</td>
										
										<td>
											<select class="form-control affinity_point" name="data[action]" disabled>
												
												<option affinity_val=15 <?php echo $credit_mantri['action'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option affinity_val=15 <?php echo $credit_mantri['action'] == "No"?"selected":"";?> value="No">No</option>
												<option affinity_val=15 <?php echo $credit_mantri['action'] == "NA"?"selected":"";?> value="NA">NA</option>
											</select> 
										</td>
										<td colspan=2><input type="text" name="data[cmt4]" class="form-control" value="<?php echo $credit_mantri['cmt4'] ?>"disabled></td>
									</tr>
									
									<tr>
										<td colspan=2>5. Objection handling</td>
										<td >Technical/ Product/ Process</td>
										<td>10</td>
										
										<td>
											<select class="form-control affinity_point " name="data[handling]" disabled>
												
												<option affinity_val=10 <?php echo $credit_mantri['handling'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option affinity_val=10 <?php echo $credit_mantri['handling'] == "No"?"selected":"";?> value="No">No</option>
												<option affinity_val=10 <?php echo $credit_mantri['handling'] == "NA"?"selected":"";?> value="NA">NA</option>
											</select> 
										</td>
										<td colspan=2><input type="text" name="data[cmt5]" class="form-control" value="<?php echo $credit_mantri['cmt5'] ?>"disabled></td>
									</tr>
									<tr>
										<td colspan=2>6. CFP Process explanation</td>
										<td >Sales Skill</td>
										<td>20</td>
										
										<td>
											<select class="form-control affinity_point " name="data[explanation]" disabled>
												
												<option affinity_val=20 <?php echo $credit_mantri['explanation'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option affinity_val=20 <?php echo $credit_mantri['explanation'] == "No"?"selected":"";?> value="No">No</option>
												<option affinity_val=20 <?php echo $credit_mantri['explanation'] == "NA"?"selected":"";?> value="NA">NA</option>
											</select> 
										</td>
										<td colspan=2><input type="text" name="data[cmt6]" class="form-control" value="<?php echo $credit_mantri['cmt6'] ?>"disabled></td>
									</tr>
									<tr>
										<td colspan=2>7. Rate of speech</td>
										<td >Technical/ Product/ Process</td>
										<td>5</td>
										
										<td>
											<select class="form-control affinity_point " name="data[speech]" disabled>
												
												<option affinity_val=5 <?php echo $credit_mantri['speech'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option affinity_val=5 <?php echo $credit_mantri['speech'] == "No"?"selected":"";?> value="No">No</option>
												<option affinity_val=5 <?php echo $credit_mantri['speech'] == "NA"?"selected":"";?> value="NA">NA</option>
											</select> 
										</td>
										<td colspan=2><input type="text" name="data[cmt7]" class="form-control" value="<?php echo $credit_mantri['cmt7'] ?>"disabled></td>
									</tr>
									

									<tr>
										<td colspan=2>8. Call disposition in CRM</td>
										<td >Technical/ Product/ Process</td>
										<td>5</td>
										
										<td>
											<select class="form-control affinity_point" name="data[disposition]" disabled>
												
												<option affinity_val=5 <?php echo $credit_mantri['disposition'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option affinity_val=5 <?php echo $credit_mantri['disposition'] == "No"?"selected":"";?> value="No">No</option>
												<option affinity_val=5 <?php echo $credit_mantri['disposition'] == "NA"?"selected":"";?> value="NA">NA</option>
											</select> 
										</td>
										<td colspan=2><input type="text" name="data[cmt8]" class="form-control" value="<?php echo $credit_mantri['cmt8'] ?>"disabled></td>
									</tr>
									<tr>
										<td colspan=2>9. Summarize and Close</td>
										<td >Technical/ Product/ Process</td>
										<td>5</td>
										
										<td>
											<select class="form-control affinity_point" name="data[Close]" disabled>
												
												<option affinity_val=5 <?php echo $credit_mantri['Close'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option affinity_val=5 <?php echo $credit_mantri['Close'] == "No"?"selected":"";?> value="No">No</option>
												<option affinity_val=5 <?php echo $credit_mantri['Close'] == "NA"?"selected":"";?> value="NA">NA</option>
											</select> 
										</td>
										<td colspan=2><input type="text" name="data[cmt9]" class="form-control" value="<?php echo $credit_mantri['cmt9'] ?>"disabled></td>
									</tr>
									<tr>
										<td colspan=2 style="color: red;">10.1 Fatal-Mis-Conduct/ Mis-Behavior</td>
										<td >Auto Fail</td>
										<td>0</td>
										
										<td>
											<select class="form-control affinity_point" id="air_email_af2" name="data[Behavior]" disabled>
												
												<option affinity_val=0 <?php echo $credit_mantri['Behavior'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option affinity_val=0 <?php echo $credit_mantri['Behavior'] == "No"?"selected":"";?> value="No">No</option>
												
											</select> 
										</td>
										<td colspan=2><input type="text" name="data[cmt10]" class="form-control" value="<?php echo $credit_mantri['cmt10'] ?>"disabled></td>
									</tr>
									<tr>
										<td style="color: red;" colspan=2>10.2 Fatal-Mis-Sell/ Wrong Information</td>
										<td>Auto Fail</td>
										<td>0</td>
										
										<td>
											<select class="form-control affinity_point" id="air_email_af1" name="data[Information]" disabled>
												
												<option affinity_val=0 <?php echo $credit_mantri['Information'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option affinity_val=0 <?php echo $credit_mantri['Information'] == "No"?"selected":"";?> value="No">No</option>
												
											</select> 
										</td>
										<td colspan=2><input type="text" name="data[cmt11]" class="form-control" value="<?php echo $credit_mantri['cmt11'] ?>"disabled></td>
									</tr>
									<tr>
										<td>Call Summary:</td>
										<td colspan="2"><textarea class="form-control" disabled><?php echo $credit_mantri['call_summary'] ?></textarea></td>
										<td>Feedback:</td>
										<td colspan="2"><textarea class="form-control" disabled><?php echo $credit_mantri['feedback'] ?></textarea></td>
									</tr>
									
									<?php if($credit_mantri['attach_file']!=''){ ?>
										<tr oncontextmenu="return false;">
											<td colspan="2">Audio Files</td>
											<td colspan="4">
												<?php $attach_file = explode(",",$credit_mantri['attach_file']);
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
									
									<tr><td style="font-size:16px">Manager Review:</td> <td colspan="5" style="text-align:left"><?php echo $credit_mantri['mgnt_rvw_note'] ?></td></tr>
									<tr><td style="font-size:16px">Client Review:</td> <td colspan="5" style="text-align:left"><?php echo $credit_mantri['client_rvw_note'] ?></td></tr>
									
									<tr><td colspan="6" style="background-color:#C5C8C8"></td></tr>
									
									<form id="form_agent_user" method="POST" action="">
									 <input type="hidden" name="pnid" class="form-control" value="<?php echo $pnid; ?>">
										
										<tr>
											<td colspan=2 style="font-size:16px">Feedback Acceptance</td>
											<td colspan=2>
												<select class="form-control" id="" name="agnt_fd_acpt" required>
													<option value="">--Select--</option>
													<option <?php echo $credit_mantri['agnt_fd_acpt']=='Acceptance'?"selected":""; ?> value="Acceptance">Acceptance</option>	
													<option <?php echo $credit_mantri['agnt_fd_acpt']=='Not Acceptance'?"selected":""; ?> value="Not Acceptance">Not Acceptance</option>	
												</select>
											</td>
										</tr>
										<tr>
											<td colspan=2 style="font-size:16px">Your Review</td>
											<td colspan=4><textarea class="form-control" name="note" required="" ><?php echo $credit_mantri['agent_rvw_note'] ?></textarea></td>
										</tr>
										
										<?php if(is_access_qa_agent_module()==true){
										if(is_available_qa_feedback($credit_mantri['entry_date'],72) == true){ ?>
											<tr>
												<?php if($credit_mantri['agent_rvw_note']==''){ ?>
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
