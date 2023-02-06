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
	font-weight:bold;
}

</style>

<?php if($cholamandlam_ibl_id!=0){
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
										<td colspan="6" id="theader" style="font-size:40px">Cholamandlam IBL</td>
										<input type="hidden" name="audit_start_time" value="<?php echo CurrMySqlDate(); ?>">
									</tr>
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
										<td><input type="text" class="form-control" value="<?php echo $auditorName; ?>" disabled></td>
										<td>Audit Date:</td>
										<td><input type="text" class="form-control" value="<?php echo $auditDate; ?>" disabled></td>
										<td>Call Date:</td>
										<td><input type="text" class="form-control" id="call_date" name="call_date" value="<?php echo $clDate_val; ?>" required></td>
									</tr>
									<tr>
										<td>Agent:</td>
										<td>
											<select class="form-control" id="agent_id" name="data[agent_id]" required >
												<option value="<?php echo $cholamandlam_ibl['agent_id'] ?>"><?php echo $cholamandlam_ibl['fname']." ".$cholamandlam_ibl['lname'] ?></option>
												<option value="">-Select-</option>
												<?php foreach($agentName as $row):  ?>
													<option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
												<?php endforeach; ?>
											</select>
										</td>
										<td>Fusion ID:</td>
										<td><input type="text" class="form-control" id="fusion_id" value="<?php echo $cholamandlam_ibl['fusion_id'] ?>" readonly ></td>
										<td>L1 Supervisor:</td>
										<td>
											<select class="form-control" id="tl_id" name="data[tl_id]" readonly>
												<option value="<?php echo $cholamandlam_ibl['tl_id'] ?>"><?php echo $cholamandlam_ibl['tl_name'] ?></option>
												<option value="">--Select--</option>
												<?php foreach($tlname as $tl): ?>
													<option value="<?php echo $tl['id']; ?>"><?php echo $tl['fname']." ".$tl['lname']; ?></option>
												<?php endforeach; ?>	
											</select>
										</td>
									</tr>
									<tr>
										<td>Call Duration:</td>
										<td><input type="text" class="form-control" id="call_duration" name="data[call_duration]" value="<?php echo $cholamandlam_ibl['call_duration'] ?>" required></td>
									
										<td>Audit Type:</td>
										<td>
											<select class="form-control" id="audit_type" name="data[audit_type]" required>
												<option value="<?php echo $cholamandlam_ibl['audit_type'] ?>"><?php echo $cholamandlam_ibl['audit_type'] ?></option>	
												<option value="">-Select-</option>
												<option <?php echo $cholamandlam_ibl['audit_type']=='CQ Audit'?"selected":""; ?> value="CQ Audit">CQ Audit</option>
												<option <?php echo $cholamandlam_ibl['audit_type']=='BQ Audit'?"selected":""; ?> value="BQ Audit">BQ Audit</option>
												<option <?php echo $cholamandlam_ibl['audit_type']=='Calibration'?"selected":""; ?> value="Calibration">Calibration</option>
												<option <?php echo $cholamandlam_ibl['audit_type']=='Pre-Certificate Mock Call'?"selected":""; ?> value="Pre-Certificate Mock Call">Pre-Certificate Mock Call</option>
												<option <?php echo $cholamandlam_ibl['audit_type']=='Certificate Audit'?"selected":""; ?> value="Certificate Audit">Certificate Audit</option>
											</select>
										</td>
										<td class="auType">Auditor Type</td>
										<td class="auType">
											<select class="form-control" id="auditor_type" name="data[auditor_type]">
												<option value="<?php echo $cholamandlam_ibl['auditor_type'] ?>"><?php echo $cholamandlam_ibl['auditor_type'] ?></option>
												<option value="">-Select-</option>
												<option value="Master">Master</option>
												<option value="Regular">Regular</option>
											</select>
										</td>
									</tr>
									<tr>
										<td>Campaign:</td>
										<td>
											<select class="form-control" name="data[track_id]" required>
												<option value="">-Select-</option>
												<option <?php echo $cholamandlam_ibl['track_id']=='CIFCO'?"selected":""; ?> value="CIFCO">CIFCO</option>
												<option <?php echo $cholamandlam_ibl['track_id']=='IBL'?"selected":""; ?> value="IBL">IBL</option>
											</select>
										</td>
										<td>Mobile No:</td>
										<td><input type="text" class="form-control" oninput="checkDec(this)" name=data[mobile_no] value="<?php echo $cholamandlam_ibl['mobile_no']; ?>" required></td>	
										<td>Language:</td>
										<td><input type="text" class="form-control" name=data[language] value="<?php echo $cholamandlam_ibl['language']; ?>" required></td>
									</tr>
									<tr>
										<td>Week</td>
											<td>
											<select class="form-control"  name="data[week]" required>
												<option value="<?php echo $cholamandlam_ibl['week'] ?>"><?php echo $cholamandlam_ibl['week'] ?></option>
												<option value="">-Select-</option>
												<option value="Week1">Week1</option>
												<option value="Week2">Week2</option>
												<option value="Week3">Week3</option>
												<option value="Week4">Week4</option>
												<option value="Week5">Week5</option>
											</select>
										</td>	
										<td>VOC:</td>
										<td>
											<select class="form-control" id="voc" name="data[voc]" required>
												<option value="<?php echo $cholamandlam_ibl['voc'] ?>"><?php echo $cholamandlam_ibl['voc'] ?></option>
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
										<td style="font-weight:bold; font-size:16px">Possible Score:</td>
										<td><input type="text" readonly id="cholamandlam_possibleScore" name="data[possible_score]" class="form-control" style="font-weight:bold" value="<?php echo $cholamandlam_ibl['possible_score'] ?>"></td>

										<td style="font-weight:bold; font-size:16px">Earned Score:</td>
										<td><input type="text" readonly id="cholamandlam_earnedScore" name="data[earned_score]" class="form-control" style="font-weight:bold" value="<?php echo $cholamandlam_ibl['earned_score'] ?>"></td>

										<td style="font-weight:bold; font-size:16px; text-align:right">Overall Score:</td>
										<td><input type="text" readonly id="cholamandlam_overallScore" name="data[overall_score]" class="form-control" style="font-weight:bold" value="<?php echo $cholamandlam_ibl['overall_score'] ?>"></td>
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
											<select class="form-control cholamandlam_points" id="cholamandlam_AF3" name="data[product_information]" required>
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
											<select class="form-control cholamandlam_points" id="cholamandlam_AF6"  name="data[disposition_ibl]" required>
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
											<select class="form-control cholamandlam_points" id="cholamandlam_AF5" name="data[objection_handling]" required>
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
											<select class="form-control cholamandlam_points" id="cholamandlam_AF2" name="data[vehicle_details]" required>
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
											<select class="form-control cholamandlam_points" id="cholamandlam_AF4" name="data[premium_confirmation]" required>
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
											<select class="form-control cholamandlam_points" id="cholamandlam_AF1"  name="data[professional_call]" required>
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
											<select class="form-control cholamandlam_points" name="data[call_opening]" required>
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
											<select class="form-control cholamandlam_points" name="data[necessary_probing]" required>
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
											<select class="form-control cholamandlam_points" name="data[hold_procedure_ibl]" required>
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
											<select class="form-control cholamandlam_points" id="" name="data[active_listening]" required>
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
											<select class="form-control cholamandlam_points" name="data[display_enthusiasm]" required>
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
											<select class="form-control cholamandlam_points" id="" name="data[alternate_number]" required>
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
											<select class="form-control cholamandlam_points" id="" name="data[date_confirmation]" required>
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
											<select class="form-control cholamandlam_points" id="" name="data[urgency_creation]" required>
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
											<select class="form-control cholamandlam_points" name="data[effort_call]" required>
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
											<select class="form-control cholamandlam_points" name="data[closing]" required>
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
										<td><input type="text" class="form-control" name="data[correct_disposition]" value="<?php echo $cholamandlam_ibl['correct_disposition'] ?>" required></td>
										<td>Disposition selected by agent</td>
										<td><input type="text" class="form-control" name="data[disposition_agent]" value="<?php echo $cholamandlam_ibl['disposition_agent'] ?>" required></td>
										<td>Wrong Disposition -Failure Remarks</td>
										<td><input type="text" class="form-control" name="data[failure_remarks]" value="<?php echo $cholamandlam_ibl['failure_remarks'] ?>" required></td>
									</tr>
									<tr>
										<td>Maintain Professionalism - Failure Reason</td>
										<td><input type="text" class="form-control" name="data[failure_reason]" value="<?php echo $cholamandlam_ibl['failure_reason'] ?>" required></td>
										<td>Standard call opening Adherence</td>
										<td><input type="text" class="form-control" name="data[standard_call]" value="<?php echo $cholamandlam_ibl['standard_call'] ?>" required></td>
										<td>Pick up call validation</td>
										<td><input type="text" class="form-control" name="data[call_validation]" value="<?php echo $cholamandlam_ibl['call_validation'] ?>" required></td>
									<tr>
										<td>EMI Amount Confirmation</td>
										<td><input type="text" class="form-control" name="data[emi_amount]" value="<?php echo $cholamandlam_ibl['emi_amount'] ?>" required></td>
										<td>Address Confirmation</td>
										<td><input type="text" class="form-control" name="data[address]" value="<?php echo $cholamandlam_ibl['address'] ?>" required></td>
										<td>Invalid Pickup Remarks (If any)</td>
										<td><input type="text" class="form-control" name="data[pickup_remarks]" value="<?php echo $cholamandlam_ibl['pickup_remarks'] ?>" required></td>
									</tr>

									<tr>
										<td>Call Summary:</td>
										<td colspan=2><textarea class="form-control" name="data[call_summary]"><?php echo $cholamandlam_ibl['call_summary'] ?></textarea></td>
										<td>Feedback:</td>
										<td colspan=2><textarea class="form-control" name="data[feedback]"><?php echo $cholamandlam_ibl['feedback'] ?></textarea></td>
									</tr>
									<tr>
										<td colspan=2>Upload Files</td>
										<?php if($cholamandlam_ibl_id==0){ ?>
											<td colspan=4><input type="file" multiple class="form-control" id="attach_file" name="attach_file[]"></td>
										<?php }else{
											if($cholamandlam_ibl['attach_file']!=''){ ?>
												<td colspan=4>
													<?php $attach_file = explode(",",$cholamandlam_ibl['attach_file']);
													 foreach($attach_file as $mp){ ?>
														<audio controls='' style="background-color:#607F93"> 
														  <source src="<?php echo base_url(); ?>qa_files/qa_cholamandlam/<?php echo $mp; ?>" type="audio/ogg">
														  <source src="<?php echo base_url(); ?>qa_files/qa_cholamandlam/<?php echo $mp; ?>" type="audio/mpeg">
														</audio> </br>
													 <?php } ?>
												</td>
										<?php }else{
												echo '<td colspan=6><b>No Files</b></td>';
											  }
										} ?>
									</tr>
									
									<?php if($cholamandlam_ibl_id!=0){ ?>
										<tr><td colspan=2 style="font-size:16px; font-weight:bold">Agent Feedback Acceptance:</td><td colspan=4><?php echo $cholamandlam_ibl['agnt_fd_acpt'] ?></td></tr>
										<tr><td colspan=2 style="font-size:16px; font-weight:bold">Agent Review:</td><td colspan=4><?php echo $cholamandlam_ibl['agent_rvw_note'] ?></td></tr>
										<tr><td colspan=2 style="font-size:16px; font-weight:bold">Management Review:</td><td colspan=4><?php echo $cholamandlam_ibl['mgnt_rvw_note'] ?></td></tr>
										<tr><td colspan=2 style="font-size:16px; font-weight:bold">Client Review:</td><td colspan=4><?php echo $cholamandlam_ibl['client_rvw_note'] ?></td></tr>
										
										<tr><td colspan=2  style="font-size:16px">Your Review</td><td colspan=4><textarea class="form-control1" style="width:100%" id="note" name="note"  ></textarea></td></tr>
									<?php } ?>
									
									<?php 
									if($cholamandlam_ibl_id==0){
										if(is_access_qa_module()==true || is_access_qa_operations_module()==true){ ?>
											<tr><td colspan=6><button class="btn btn-success waves-effect" type="submit" id="qaformsubmit" style="width:500px">SAVE</button></td></tr>
									<?php 
										} 
									}else{ 
										if(is_access_qa_module()==true || is_access_qa_operations_module()==true){
											if(is_available_qa_feedback($cholamandlam_ibl['entry_date'],72) == true){ ?>
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
