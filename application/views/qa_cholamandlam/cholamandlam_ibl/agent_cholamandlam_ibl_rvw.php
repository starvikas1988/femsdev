
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
							<table class="table table-striped skt-table" width="100%">
								<tbody>
									<tr style="background-color:#AEB6BF"><td colspan="6" id="theader" style="font-size:30px">Cholamandlam IBL</td></tr>
									<?php
										if($cholamandlam_ibl_id==0){
											$auditorName = get_username();
											$auditDate = CurrDateMDY();
											$clDate_val='';
										}else{
											if($cholamandlam_ibl['entry_by']!=''){
												$auditorName = $cholamandlam_ibl['auditor_name'];
											}else{
												$auditorName = $cholamandlam_ibl['client_name'];
											}
											$auditDate = mysql2mmddyy($cholamandlam_ibl['audit_date']);
											$clDate_val = mysql2mmddyy($cholamandlam_ibl['call_date']);
										}
									?>
								
									<tr>
										<td>Auditor Name:</td>
										<?php if($cholamandlam_ibl['entry_by']!=''){
												$auditorName = $cholamandlam_ibl['auditor_name'];
											}else{
												$auditorName = $cholamandlam_ibl['client_name'];
										} ?>
										<td><input type="text" class="form-control" value="<?php echo $auditorName; ?>" disabled></td>
										<td>Audit Date:</td>
										<td><input type="text" class="form-control" value="<?php echo mysql2mmddyy($cholamandlam_ibl['audit_date']); ?>" disabled></td>
										<td>Call Date:</td>
										<td><input type="text" class="form-control" value="<?php echo mysql2mmddyy($cholamandlam_ibl['call_date']); ?>" disabled></td>
									</tr>
									<tr>
										<td>Agent:</td>
										<td>
											<select class="form-control" disabled>
												<option><?php echo $cholamandlam_ibl['fname']." ".$cholamandlam_ibl['lname']." - [".$cholamandlam_ibl['fusion_id']."]" ?></option>
											</select>
										</td>
										<td>L1 Supervisor:</td>
										<td><select class="form-control" disabled><option><?php echo $cholamandlam_ibl['tl_name'] ?></option></select></td>
										<td>Call Duration:</td>
										<td><input type="text" class="form-control"  value="<?php echo $cholamandlam_ibl['call_duration'] ?>" disabled></td>
									
									</tr>
									<tr>
									<td>Campaign:</td>
									<td>
										<select class="form-control" name="data[track_id]" disabled>
											<option value="">-Select-</option>
											<option <?php echo $cholamandlam_ibl['track_id']=='CIFCO'?"selected":""; ?> value="CIFCO">CIFCO</option>
											<option <?php echo $cholamandlam_ibl['track_id']=='IBL'?"selected":""; ?> value="IBL">IBL</option>
										</select>
									</td>
									<td>Mobile No:</td>
										<td><input type="text" class="form-control" name=data[mobile_no] value="<?php echo $cholamandlam_ibl['mobile_no']; ?>" disabled></td>	
									<td>Language:</td>
										<td><input type="text" class="form-control" name=data[language] value="<?php echo $cholamandlam_ibl['language']; ?>" disabled></td>
									</tr>
									<tr>
										<td>Audit Type:</td>
										<td><select class="form-control" disabled><option><?php echo $cholamandlam_ibl['audit_type'] ?></option></select></td>
										<td>Week</td>
										<td>
											<select class="form-control"  name="data[week]" disabled>
												<option value="<?php echo $cholamandlam_ibl['week'] ?>"><?php echo $cholamandlam_ibl['week'] ?></option>
											</select>
										</td>	
										<td>VOC:</td>
										<td><select class="form-control" disabled><option><?php echo $cholamandlam_ibl['voc'] ?></option></select></td>
										
									</tr>
									<tr>
									<td style="font-weight:bold; font-size:16px; text-align:right">Overall Score:</td>
										<td><input type="text" class="form-control" style="font-weight:bold" value="<?php echo $cholamandlam_ibl['overall_score'] ?>" disabled></td>
									</tr>
									<tr style="height:25px; font-weight:bold; background-color:#D2B4DE">
										<td>PARAMETER</td>
										<td colspan=3>SUB PARAMETER</td>
										<td>WEIGHTAGE</td>
										<td>STATUS</td>
									</tr>
									<tr>
										<td>Sales Skill</td>
										<td colspan=3 style="color:#FF0000">Product information</td>
										<td>10</td>
										<td>
											<select class="form-control cholamandlam_points" id="cholamandlam_AF3" name="data[product_information]" disabled>
												<option cholamandlam_val=10 <?php echo $cholamandlam_ibl['product_information'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option cholamandlam_val=10 <?php echo $cholamandlam_ibl['product_information'] == "No"?"selected":"";?> value="No">No</option>
												<option cholamandlam_val=0 <?php echo $cholamandlam_ibl['product_information'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
									</tr>
									<tr>
										<td>Documentation</td>
										<td colspan=3 style="color:#FF0000">Disposition</td>
										<td>5</td>
										<td>
											<select class="form-control cholamandlam_points" id="cholamandlam_AF6"  name="data[disposition_ibl]" disabled>
												<option cholamandlam_val=5 <?php echo $cholamandlam_ibl['disposition_ibl'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option cholamandlam_val=5 <?php echo $cholamandlam_ibl['disposition_ibl'] == "No"?"selected":"";?> value="No">No</option>
												<option cholamandlam_val=0 <?php echo $cholamandlam_ibl['disposition_ibl'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
									</tr>
									<tr>
										<td>Sales Skill</td>
										<td colspan=3 style="color:#FF0000">Objection handling , based on customer query</td>
										<td>10</td>
										<td>
											<select class="form-control cholamandlam_points" id="cholamandlam_AF5" name="data[objection_handling]" disabled>
												<option cholamandlam_val=10 <?php echo $cholamandlam_ibl['objection_handling'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option cholamandlam_val=10 <?php echo $cholamandlam_ibl['objection_handling'] == "No"?"selected":"";?> value="No">No</option>
												<option cholamandlam_val=0 <?php echo $cholamandlam_ibl['objection_handling'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
									</tr>
									<tr>
										<td>Sales Skill</td>
										<td colspan=3 style="color:#FF0000">Vehicle details and RED confirmation</td>
										<td>10</td>
										<td>
											<select class="form-control cholamandlam_points" id="cholamandlam_AF2" name="data[vehicle_details]" disabled>
												<option cholamandlam_val=10 <?php echo $cholamandlam_ibl['vehicle_details'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option cholamandlam_val=10 <?php echo $cholamandlam_ibl['vehicle_details'] == "No"?"selected":"";?> value="No">No</option>
												<option cholamandlam_val=0 <?php echo $cholamandlam_ibl['vehicle_details'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
									</tr>
									<tr>
										<td>Sales Skill</td>
										<td colspan=3 style="color:#FF0000">Premium confirmation</td>
										<td>5</td>
										<td>
											<select class="form-control cholamandlam_points" id="cholamandlam_AF4" name="data[premium_confirmation]" disabled>
												<option cholamandlam_val=5 <?php echo $cholamandlam_ibl['premium_confirmation'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option cholamandlam_val=5 <?php echo $cholamandlam_ibl['premium_confirmation'] == "No"?"selected":"";?> value="No">No</option>
												<option cholamandlam_val=0 <?php echo $cholamandlam_ibl['premium_confirmation'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
									</tr>
									<tr>
										<td>Soft Skill</td>
										<td colspan=3 style="color:#FF0000">Professional on call</td>
										<td>5</td>
										<td>
											<select class="form-control cholamandlam_points" id="cholamandlam_AF1"  name="data[professional_call]" disabled>
												<option cholamandlam_val=5 <?php echo $cholamandlam_ibl['professional_call'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option cholamandlam_val=5 <?php echo $cholamandlam_ibl['professional_call'] == "No"?"selected":"";?> value="No">No</option>
												<option cholamandlam_val=0 <?php echo $cholamandlam_ibl['professional_call'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
									</tr>
									<tr>
										<td>Soft Skill</td>
										<td colspan=3>Standard Call opening (Opened the call without delay & with proper script & greeting)</td>
										<td>5</td>
										<td>
											<select class="form-control cholamandlam_points" name="data[call_opening]" disabled>
												<option cholamandlam_val=5 <?php echo $cholamandlam_ibl['call_opening'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option cholamandlam_val=5 <?php echo $cholamandlam_ibl['call_opening'] == "No"?"selected":"";?> value="No">No</option>
												<option cholamandlam_val=0 <?php echo $cholamandlam_ibl['call_opening'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
									</tr>
									<tr>
										<td>Soft Skill</td>
										<td colspan=3>Necessary Probing Done</td>
										<td>5</td>
										<td>
											<select class="form-control cholamandlam_points" name="data[necessary_probing]" disabled>
												<option cholamandlam_val=5 <?php echo $cholamandlam_ibl['necessary_probing'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option cholamandlam_val=5 <?php echo $cholamandlam_ibl['necessary_probing'] == "No"?"selected":"";?> value="No">No</option>
												<option cholamandlam_val=0 <?php echo $cholamandlam_ibl['necessary_probing'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
									</tr>
									<tr>
										<td>Soft Skill</td>
										<td colspan=3>Rate of speech/Empathy/Hold procedure</td>
										<td>5</td>
										<td>
											<select class="form-control cholamandlam_points" name="data[hold_procedure_ibl]" disabled>
												<option cholamandlam_val=5 <?php echo $cholamandlam_ibl['hold_procedure_ibl'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option cholamandlam_val=5 <?php echo $cholamandlam_ibl['hold_procedure_ibl'] == "No"?"selected":"";?> value="No">No</option>
												<option cholamandlam_val=0 <?php echo $cholamandlam_ibl['hold_procedure_ibl'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
									</tr>
									<tr>
										<td>Soft Skill</td>
										<td colspan=3>Active Listening / Interruption</td>
										<td>5</td>
										<td>
											<select class="form-control cholamandlam_points" id="" name="data[active_listening]" disabled>
												<option cholamandlam_val=5 <?php echo $cholamandlam_ibl['active_listening'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option cholamandlam_val=5 <?php echo $cholamandlam_ibl['active_listening'] == "No"?"selected":"";?> value="No">No</option>
												<option cholamandlam_val=0 <?php echo $cholamandlam_ibl['active_listening'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
									</tr>
									<tr>
										<td>Soft Skill</td>
										<td colspan=3>Display enthusiasm</td>
										<td>5</td>
										<td>
											<select class="form-control cholamandlam_points" name="data[display_enthusiasm]" disabled>
												<option cholamandlam_val=5 <?php echo $cholamandlam_ibl['display_enthusiasm'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option cholamandlam_val=5 <?php echo $cholamandlam_ibl['display_enthusiasm'] == "No"?"selected":"";?> value="No">No</option>
												<option cholamandlam_val=0 <?php echo $cholamandlam_ibl['display_enthusiasm'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
									</tr>
									<tr>
										<td>Sales Skill</td>
										<td colspan=3>Alternate number confirmation</td>
										<td>5</td>
										<td>
											<select class="form-control cholamandlam_points" id="" name="data[alternate_number]" disabled>
												<option cholamandlam_val=5 <?php echo $cholamandlam_ibl['alternate_number'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option cholamandlam_val=5 <?php echo $cholamandlam_ibl['alternate_number'] == "No"?"selected":"";?> value="No">No</option>
												<option cholamandlam_val=0 <?php echo $cholamandlam_ibl['alternate_number'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
									</tr>
									<tr>
										<td>Sales Skill</td>
										<td colspan=3>PTP date confirmation</td>
										<td>5</td>
										<td>
											<select class="form-control cholamandlam_points" id="" name="data[date_confirmation]" disabled>
												<option cholamandlam_val=5 <?php echo $cholamandlam_ibl['date_confirmation'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option cholamandlam_val=5 <?php echo $cholamandlam_ibl['date_confirmation'] == "No"?"selected":"";?> value="No">No</option>
												<option cholamandlam_val=0 <?php echo $cholamandlam_ibl['date_confirmation'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
									</tr>
									<tr>
										<td>Sales Skill</td>
										<td colspan=3>Urgency creation</td>
										<td>5</td>
										<td>
											<select class="form-control cholamandlam_points" id="" name="data[urgency_creation]" disabled>
												<option cholamandlam_val=5 <?php echo $cholamandlam_ibl['urgency_creation'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option cholamandlam_val=5 <?php echo $cholamandlam_ibl['urgency_creation'] == "No"?"selected":"";?> value="No">No</option>
												<option cholamandlam_val=0 <?php echo $cholamandlam_ibl['urgency_creation'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
									</tr>
									<tr>
										<td>Sales Skill</td>
										<td colspan=3>Effort on call</td>
										<td>10</td>
										<td>
											<select class="form-control cholamandlam_points" name="data[effort_call]" disabled>
												<option cholamandlam_val=10 <?php echo $cholamandlam_ibl['effort_call'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option cholamandlam_val=10 <?php echo $cholamandlam_ibl['effort_call'] == "No"?"selected":"";?> value="No">No</option>
												<option cholamandlam_val=0 <?php echo $cholamandlam_ibl['effort_call'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
									</tr>
									<tr>
										<td>Soft Skill</td>
										<td colspan=3>Closing</td>
										<td>5</td>
										<td>
											<select class="form-control cholamandlam_points" name="data[closing]" disabled>
												<option cholamandlam_val=5 <?php echo $cholamandlam_ibl['closing'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option cholamandlam_val=5 <?php echo $cholamandlam_ibl['closing'] == "No"?"selected":"";?> value="No">No</option>
												<option cholamandlam_val=0 <?php echo $cholamandlam_ibl['closing'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
									</tr>
									<tr>
										<td rowspan=3>Parameter Comment</td>
										<td colspan=2>Soft Skill Comment</td>
										<td colspan=3><textarea name="data[soft_skill_comment]" class="form-control"><?php echo $cholamandlam_ibl['soft_skill_comment'] ?></textarea></td>
									</tr>
									<tr>
										<td colspan=2>Sales Skill Comment</td>
										<td colspan=3><textarea name="data[sales_skill_comment]" class="form-control"><?php echo $cholamandlam_ibl['sales_skill_comment'] ?></textarea></td>
									</tr>
									<tr>
										<td colspan=2>Documentation Comment</td>
										<td colspan=3><textarea name="data[documentation_comment]" class="form-control"><?php echo $cholamandlam_ibl['documentation_comment'] ?></textarea></td>
									</tr>		
									<tr>
										<td>Correct Disposition</td>
										<td><input type="text" class="form-control" name="data[correct_disposition]" value="<?php echo $cholamandlam_ibl['correct_disposition'] ?>" disabled></td>
										<td>Disposition selected by agent</td>
										<td><input type="text" class="form-control" name="data[disposition_agent]" value="<?php echo $cholamandlam_ibl['disposition_agent'] ?>" disabled></td>
										<td>Wrong Disposition -Failure Remarks</td>
										<td><input type="text" class="form-control" name="data[failure_remarks]" value="<?php echo $cholamandlam_ibl['failure_remarks'] ?>" disabled></td>
									</tr>
									<tr>
										<td>Maintain Professionalism - Failure Reason</td>
										<td><input type="text" class="form-control" name="data[failure_reason]" value="<?php echo $cholamandlam_ibl['failure_reason'] ?>" disabled></td>
										<td>Standard call opening Adherence</td>
										<td><input type="text" class="form-control" name="data[standard_call]" value="<?php echo $cholamandlam_ibl['standard_call'] ?>" disabled></td>
										<td>Pick up call validation</td>
										<td><input type="text" class="form-control" name="data[call_validation]" value="<?php echo $cholamandlam_ibl['call_validation'] ?>" disabled></td>
									<tr>
										<td>EMI Amount Confirmation</td>
										<td><input type="text" class="form-control" name="data[emi_amount]" value="<?php echo $cholamandlam_ibl['emi_amount'] ?>" disabled></td>
										<td>Address Confirmation</td>
										<td><input type="text" class="form-control" name="data[address]" value="<?php echo $cholamandlam_ibl['address'] ?>" disabled></td>
										<td>Invalid Pickup Remarks (If any)</td>
										<td><input type="text" class="form-control" name="data[pickup_remarks]" value="<?php echo $cholamandlam_ibl['pickup_remarks'] ?>" disabled></td>
									</tr>
									<tr>
										<td>Call Summary:</td>
										<td colspan="2"><textarea class="form-control" disabled><?php echo $cholamandlam_ibl['call_summary'] ?></textarea></td>
										<td>Feedback:</td>
										<td colspan="2"><textarea class="form-control" disabled><?php echo $cholamandlam_ibl['feedback'] ?></textarea></td>
									</tr>
									
									<?php if($cholamandlam_ibl['attach_file']!=''){ ?>
									<tr oncontextmenu="return false;">
										<td colspan="2">Audio Files</td>
										<td colspan="4">
											<?php $attach_file = explode(",",$cholamandlam_ibl['attach_file']);
											 foreach($attach_file as $mp){ ?>
												<audio controls='' style="background-color:#607F93"> 
												  <source src="<?php echo base_url(); ?>qa_files/qa_cholamandlam/<?php echo $mp; ?>" type="audio/ogg">
												  <source src="<?php echo base_url(); ?>qa_files/qa_cholamandlam/<?php echo $mp; ?>" type="audio/mpeg">
												</audio> </br>
											 <?php } ?>
										</td>
									</tr>
									<?php } ?>
									
									<tr><td colspan="6" style="background-color:#C5C8C8"></td></tr>
									
									<tr><td style="font-size:16px">Manager Review:</td> <td colspan="5" style="text-align:left"><?php echo $cholamandlam_ibl['mgnt_rvw_note'] ?></td></tr>
									<tr><td style="font-size:16px">Client Review:</td> <td colspan="5" style="text-align:left"><?php echo $cholamandlam_ibl['client_rvw_note'] ?></td></tr>
									
									<tr><td colspan="6" style="background-color:#C5C8C8"></td></tr>
									
									<form id="form_agent_user" method="POST" action="">
									 <input type="hidden" name="pnid" class="form-control" value="<?php echo $pnid; ?>">
										
										<tr>
											<td colspan=2 style="font-size:16px">Feedback Acceptance</td>
											<td colspan=2>
												<select class="form-control" id="" name="agnt_fd_acpt" required>
													<option value="">--Select--</option>
													<option <?php echo $cholamandlam_ibl['agnt_fd_acpt']=='Acceptance'?"selected":""; ?> value="Acceptance">Acceptance</option>	
													<option <?php echo $cholamandlam_ibl['agnt_fd_acpt']=='Not Acceptance'?"selected":""; ?> value="Not Acceptance">Not Acceptance</option>	
												</select>
											</td>
										</tr>
										<tr>
											<td colspan=2 style="font-size:16px">Your Review</td>
											<td colspan=4><textarea class="form-control" name="note" required><?php echo $cholamandlam_ibl['agent_rvw_note'] ?></textarea></td>
										</tr>
										
										<?php if(is_access_qa_agent_module()==true){
										if(is_available_qa_feedback($cholamandlam_ibl['entry_date'],72) == true){ ?>
											<tr>
												<?php if($cholamandlam_ibl['agnt_fd_acpt']==''){ ?>
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
