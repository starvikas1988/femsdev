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
	background-color:#F4D03F;
}
</style>

<?php if($gds_id!=0){
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
										<td colspan="6" id="theader" style="font-size:30px">CLIO APPOINTMENT SPOT CHECK FORM</td>
										<input type="hidden" name="audit_start_time" value="<?php echo CurrMySqlDate(); ?>">
									</tr>
									<?php
										if($gds_id==0){
											$auditorName = get_username();
											$auditDate = CurrDateMDY();
											$clDate_val='';
										}else{
											if($clio['entry_by']!=''){
												$auditorName = $clio['auditor_name'];
											}else{
												$auditorName = $clio['client_name'];
											}
											$auditDate = mysql2mmddyy($clio['audit_date']);
											$clDate_val = mysql2mmddyy($clio['call_date']);
										}
									?>
									<tr>
										<td>Auditor Name:</td>
										<td><input type="text" class="form-control" value="<?php echo $auditorName; ?>" disabled></td>
										<td>Audit Date:</td>
										<td><input type="text" class="form-control" value="<?php echo $auditDate; ?>" disabled></td>
										<td>Date & Time:</td>
										<td style="width:200px"><input type="text" class="form-control" id="call_date" name="call_date" value="<?php echo $clDate_val; ?>" required></td>
									</tr>
									<tr>
										<td>Agent:</td>
										<td>
											<select class="form-control" id="agent_id" name="data[agent_id]" required >
												<option value="<?php echo $clio['agent_id'] ?>"><?php echo $clio['fname']." ".$clio['lname'] ?></option>
												<option value="">-Select-</option>
												<?php foreach($agentName as $row):  ?>
													<option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
												<?php endforeach; ?>
											</select>
										</td>
										<td>Fusion ID:</td>
										<td><input type="text" class="form-control" id="fusion_id" value="<?php echo $clio['fusion_id'] ?>" readonly ></td>
										<td>L1 Supervisor:</td>
										<td>
											<select class="form-control" id="tl_id" name="data[tl_id]" readonly>
												<option value="<?php echo $clio['tl_id'] ?>"><?php echo $clio['tl_name'] ?></option>
												<option value="">--Select--</option>
												<?php foreach($tlname as $tl): ?>
													<option value="<?php echo $tl['id']; ?>"><?php echo $tl['fname']." ".$tl['lname']; ?></option>
												<?php endforeach; ?>	
											</select>
										</td>
									</tr>
									
									<tr>
										<td>Call Duration:</td>
										<td><input type="text" class="form-control" id="call_duration"  name="data[call_duration]" value="<?php echo $clio['call_duration'] ?>" required ></td>
										<td>Modality</td>
										<td>
									        <select style="color:black;" class="form-control" name="data[modality]" required>
												<option value="">-Select-</option>
												<option <?php echo $clio['modality'] == "MG"?"selected":"";?> value="MG">MG</option>
												<option <?php echo $clio['modality'] == "US"?"selected":"";?> value="US">US</option>
												<option <?php echo $clio['modality'] == "DEXA"?"selected":"";?> value="DEXA">DEXA</option>
												<option <?php echo $clio['modality'] == "ECHO"?"selected":"";?> value="ECHO">ECHO</option>
												<option <?php echo $clio['modality'] == "MRI"?"selected":"";?> value="MRI">MRI</option>
												<option <?php echo $clio['modality'] == "CT"?"selected":"";?> value="CT">CT</option>
											</select> 
										</td>
										<td>Line of Business</td>
										<td>
									        <select style="color:black;" class="form-control" name="data[lob]" required>
												<option value="">-Select-</option>
												<option <?php echo $clio['lob'] == "P107"?"selected":"";?> value="P107">P107</option>
												<option <?php echo $clio['lob'] == "P003"?"selected":"";?> value="P003">P003</option>
												<option <?php echo $clio['lob'] == "P105"?"selected":"";?> value="P105">P105</option>
											</select> 
										</td>
									</tr>
									
									<tr>
										<td>Audit Type:</td>
										<td>
											<select class="form-control" id="audit_type" name="data[audit_type]" required>
												<option value="<?php echo $clio['audit_type'] ?>"><?php echo $clio['audit_type'] ?></option>
												<option value="">-Select-</option>
												<option value="CQ Audit">CQ Audit</option>
												<option value="BQ Audit">BQ Audit</option>
												<option value="Calibration">Calibration</option>
												<option value="Pre-Certificate Mock Call">Pre-Certificate Mock Call</option>
												<option value="Certification Audit">Certification Audit</option>
												<option value="Operation Audit">Operation Audit</option>
												<option value="Trainer Audit">Trainer Audit</option>
												<option value="WOW Call">WOW Call</option>
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
												<option value="<?php echo $clio['voc'] ?>"><?php echo $clio['voc'] ?></option>
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
										<td><input type="text" readonly id="jurys_inn_possible_score" name="data[possible_score]" class="form-control" style="font-weight:bold" value="<?php echo $clio['possible_score'] ?>"></td>
										<td style="font-weight:bold; font-size:16px">Earned Score:</td>
										<td><input type="text" readonly id="jurys_inn_earned_score" name="data[earned_score]" class="form-control" style="font-weight:bold" value="<?php echo $clio['earned_score'] ?>"></td>
										<td style="font-weight:bold; font-size:16px; text-align:right">Overall Score:</td>
										<td><input type="text" readonly id="jurys_inn_overall_score" name="data[overall_score]" class="form-control gds_prearrival_fatal" style="font-weight:bold" value="<?php echo $clio['overall_score'] ?>"></td>
									</tr>
									<tr style="height:25px; font-weight:bold; background-color:#85C1E9">
										<td colspan=3>PARAMETER</td>
										<td>STATUS</td>
										<td colspan=2>COMMENT</td>
										
									</tr>
									
									<tr>
										<td class="eml1" colspan=3>Referring Doctor</td>
										<td>
											<select class="form-control jurry_points compliance" name="data[Referring_Doctor]" required>
												<option value="">-Select-</option>
												<option ji_val=1 <?php echo $clio['Referring_Doctor'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ji_val=1 <?php echo $clio['Referring_Doctor'] == "No"?"selected":"";?> value="No">No</option>
												<option ji_val=0 <?php echo $clio['Referring_Doctor'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt1]" value="<?php echo $clio['cmt1'] ?>"></td>
										
									</tr>
									<tr>
										<td class="eml1" colspan=3>Eligibility</td>
										<td>
											<select class="form-control jurry_points compliance" name="data[Eligibility]" required>
												<option value="">-Select-</option>
												<option ji_val=1 <?php echo $clio['Eligibility'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ji_val=1 <?php echo $clio['Eligibility'] == "No"?"selected":"";?> value="No">No</option>
												<option ji_val=0 <?php echo $clio['Eligibility'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt2]" value="<?php echo $clio['cmt2'] ?>"></td>
										
									</tr>
									<tr>
										<td class="eml1" colspan=3>Authorization/Prescription</td>
										<td>
											<select class="form-control jurry_points compliance" name="data[Prescription]" required>
												<option value="">-Select-</option>
												<option ji_val=3 <?php echo $clio['Prescription'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ji_val=3 <?php echo $clio['Prescription'] == "No"?"selected":"";?> value="No">No</option>
												<option ji_val=0 <?php echo $clio['Prescription'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt3]" value="<?php echo $clio['cmt3'] ?>"></td>
									</tr>
									<tr>
										<td class="eml1" colspan=3>Orders</td>
										<td>
											<select class="form-control jurry_points compliance" name="data[Orders]" required>
												<option value="">-Select-</option>
												<option ji_val=1 <?php echo $clio['Orders'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ji_val=1 <?php echo $clio['Orders'] == "No"?"selected":"";?> value="No">No</option>
												<option ji_val=0 <?php echo $clio['Orders'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt4]" value="<?php echo $clio['cmt4'] ?>"></td>
									</tr>
									

									
									<tr>
										<td class="eml1" colspan=3>Account Notes</td>
										<td>
											<select class="form-control jurry_points customer" name="data[Account_Notes]" required>
												<option value="">-Select-</option>
												<option ji_val=2 <?php echo $clio['Account_Notes'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ji_val=2 <?php echo $clio['Account_Notes'] == "No"?"selected":"";?> value="No">No</option>
												<option ji_val=0 <?php echo $clio['Account_Notes'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt5]" value="<?php echo $clio['cmt5'] ?>"></td>
									</tr>
									<tr>
										<td class="eml1" colspan=3>Appointment Accuracy (no call out after setting the appointment or no errors after setting up appointment)</td>
										<td>
											<select class="form-control jurry_points customer" name="data[Appointment_Accuracy]" required>
												<option value="">-Select-</option>
												<option ji_val=3 <?php echo $clio['Appointment_Accuracy'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ji_val=3 <?php echo $clio['Appointment_Accuracy'] == "No"?"selected":"";?> value="No">No</option>
												<option ji_val=0 <?php echo $clio['Appointment_Accuracy'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt6]" value="<?php echo $clio['cmt6'] ?>"></td>
										<!-- <td>Business Critical</td> -->
									</tr>
									<tr>
										<td class="eml1" colspan=3>Complete Screening Questions</td>
										<td>
											<select class="form-control jurry_points customer" name="data[Screening_Questions]" required>
												<option value="">-Select-</option>
												<option ji_val=3 <?php echo $clio['Screening_Questions'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ji_val=3 <?php echo $clio['Screening_Questions'] == "No"?"selected":"";?> value="No">No</option>
												<option ji_val=0 <?php echo $clio['Screening_Questions'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt7]" value="<?php echo $clio['cmt7'] ?>"></td>
										
									</tr>
									<tr>
										<td class="eml1" colspan=3>Followed prior notes/diagnosis report</td>
										<td>
											<select class="form-control jurry_points customer" id="" name="data[diagnosis_report]" required>
												<option value="">-Select-</option>
												<option ji_val=3 <?php echo $clio['diagnosis_report'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ji_val=3 <?php echo $clio['diagnosis_report'] == "No"?"selected":"";?> value="No">No</option>
												<option ji_val=0 <?php echo $clio['diagnosis_report'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt8]" value="<?php echo $clio['cmt8'] ?>"></td>
										
									</tr>
									
									<tr>
										<td>Call Summary:</td>
										<td colspan="2"><textarea class="form-control"   name="data[call_summary]"><?php echo $clio['call_summary'] ?></textarea></td>
										<td>Feedback:</td>
										<td colspan="2"><textarea class="form-control"   name="data[feedback]"><?php echo $clio['feedback'] ?></textarea></td>
									</tr>
									
									<tr>
										<td colspan=2>Upload Files</td>
										<?php if($gds_id==0){ ?>
											<td colspan=4><input type="file" multiple class="form-control" id="attach_file" name="attach_file[]"></td>
										<?php }else{
											if($clio['attach_file']!=''){ ?>
												<td colspan=4>
													<?php $attach_file = explode(",",$clio['attach_file']);
													 foreach($attach_file as $mp){ ?>
														<audio controls='' style="background-color:#607F93"> 
														  <source src="<?php echo base_url(); ?>qa_files/qa_clio/<?php echo $mp; ?>" type="audio/ogg">
														  <source src="<?php echo base_url(); ?>qa_files/qa_clio/<?php echo $mp; ?>" type="audio/mpeg">
														</audio> </br>
													 <?php } ?>
												</td>
										<?php }else{
												echo '<td colspan=6><b>No Files</b></td>';
											  }
										} ?>
									</tr>
									<?php  if($gds_id!=0){
										if($clio['entry_by']==get_user_id()){ ?>
											<tr><td colspan=2>Edit Upload</td><td colspan=4><input type="file" multiple class="form-control1" id="fileuploadbasic" name="attach_file[]"></td></tr>
									<?php } 
									} ?>
									
									<?php if($gds_id!=0){ ?>
										<tr><td colspan=2 style="font-size:16px; font-weight:bold">Agent Feedback Acceptance:</td><td colspan=4><?php echo $clio['agnt_fd_acpt'] ?></td></tr>
										<tr><td colspan=2 style="font-size:16px; font-weight:bold">Agent Review:</td><td colspan=4><?php echo $clio['agent_rvw_note'] ?></td></tr>
										<tr><td colspan=2 style="font-size:16px; font-weight:bold">Management Review:</td><td colspan=4><?php echo $clio['mgnt_rvw_note'] ?></td></tr>
										<tr><td colspan=2 style="font-size:16px; font-weight:bold">Client Review:</td><td colspan=4><?php echo $clio['client_rvw_note'] ?></td></tr>
										
										<tr><td colspan=2  style="font-size:16px">Your Review</td><td colspan=4><textarea class="form-control1" style="width:100%" id="note" name="note"  ></textarea></td></tr>
									<?php } ?>
									
									<?php 
									if($gds_id==0){
										if(is_access_qa_module()==true || is_access_qa_operations_module()==true){ ?>
											<tr><td colspan=6><button class="btn btn-success waves-effect" type="submit" id="qaformsubmit" style="width:500px">SAVE</button></td></tr>
									<?php 
										} 
									}else{ 
										if(is_access_qa_module()==true || is_access_qa_operations_module()==true){
											if(is_available_qa_feedback($clio['entry_date'],72) == true){ ?>
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
