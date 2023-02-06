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

<?php if($gtn_technical_id!=0){
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
										<td colspan="6" id="theader" style="font-size:40px">GTN Technical Staffing</td>
										<input type="hidden" name="audit_start_time" value="<?php echo CurrMySqlDate(); ?>">
									</tr>
									<?php
										if($gtn_technical_id==0){
											$auditorName = get_username();
											$auditDate = CurrDateMDY();
											$clDate_val='';
										}else{
											if($gtn_list['entry_by']!=''){
												$auditorName = $gtn_list['auditor_name'];
											}else{
												$auditorName = $gtn_list['client_name'];
											}
											$auditDate = mysql2mmddyy($gtn_list['audit_date']);
											$clDate_val = mysql2mmddyy($gtn_list['call_date']);
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
												<option value="<?php echo $gtn_list['agent_id'] ?>"><?php echo $gtn_list['fname']." ".$gtn_list['lname'] ?></option>
												<option value="">-Select-</option>
												<?php foreach($agentName as $row):  ?>
													<option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
												<?php endforeach; ?>
											</select>
										</td>
										<td>Fusion ID:</td>
										<td><input type="text" class="form-control" id="fusion_id" value="<?php echo $gtn_list['fusion_id'] ?>" readonly ></td>
										<td>L1 Supervisor:</td>
										<td>
											<select class="form-control" id="tl_id" name="data[tl_id]" readonly>
												<option value="<?php echo $gtn_list['tl_id'] ?>"><?php echo $gtn_list['tl_name'] ?></option>
												<option value="">--Select--</option>
												<?php foreach($tlname as $tl): ?>
													<option value="<?php echo $tl['id']; ?>"><?php echo $tl['fname']." ".$tl['lname']; ?></option>
												<?php endforeach; ?>	
											</select>
										</td>
									</tr>
									<tr>
										<td>Call Duration:</td>
										<td><input type="text" class="form-control" id="call_duration" name="data[call_duration]" value="<?php echo $gtn_list['call_duration'] ?>" required></td>
									
										<td>Audit Type:</td>
										<td>
											<select class="form-control" id="audit_type" name="data[audit_type]" required>
												<option value="<?php echo $gtn_list['audit_type'] ?>"><?php echo $gtn_list['audit_type'] ?></option>	
												<option value="">-Select-</option>
												<option <?php echo $gtn_list['audit_type']=='CQ Audit'?"selected":""; ?> value="CQ Audit">CQ Audit</option>
												<option <?php echo $gtn_list['audit_type']=='BQ Audit'?"selected":""; ?> value="BQ Audit">BQ Audit</option>
												<option <?php echo $gtn_list['audit_type']=='Calibration'?"selected":""; ?> value="Calibration">Calibration</option>
												<option <?php echo $gtn_list['audit_type']=='Pre-Certificate Mock Call'?"selected":""; ?> value="Pre-Certificate Mock Call">Pre-Certificate Mock Call</option>
												<option <?php echo $gtn_list['audit_type']=='Certificate Audit'?"selected":""; ?> value="Certificate Audit">Certificate Audit</option>
											</select>
										</td>
										<td class="auType">Auditor Type</td>
										<td class="auType">
											<select class="form-control" id="auditor_type" name="data[auditor_type]">
												<option value="<?php echo $gtn_list['auditor_type'] ?>"><?php echo $gtn_list['auditor_type'] ?></option>
												<option value="">-Select-</option>
												<option value="Master">Master</option>
												<option value="Regular">Regular</option>
											</select>
										</td>
									</tr>
									<tr>
										<td>Recruiter Name:</td>
										<td><input type="text" class="form-control" name=data[recruiter_name] value="<?php echo $gtn_list['recruiter_name']; ?>" required></td>
										<td>Mobile No:</td>
										<td><input type="text" class="form-control" oninput="checkDec(this)" name=data[mobile_no] value="<?php echo $gtn_list['mobile_no']; ?>" required></td>	
										<td>Language:</td>
										<td><input type="text" class="form-control" name=data[language] value="<?php echo $gtn_list['language']; ?>" required></td>
									</tr>
									<tr>
										<td>Candidate Name:</td>
										<td><input type="text" class="form-control" name=data[candidate_name] value="<?php echo $gtn_list['candidate_name']; ?>" required></td>
										<td>Designation:</td>
										<td><input type="text" class="form-control" name=data[designation] value="<?php echo $gtn_list['designation']; ?>" required></td>
										<td>Portal Name:</td>
										<td><input type="text" class="form-control" name=data[portal_name] value="<?php echo $gtn_list['portal_name']; ?>" required></td>
									</tr>
									<tr>
										<td>Week</td>
											<td>
											<select class="form-control"  name="data[week]" required>
												<option value="<?php echo $gtn_list['week'] ?>"><?php echo $gtn_list['week'] ?></option>
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
												<option value="<?php echo $gtn_list['voc'] ?>"><?php echo $gtn_list['voc'] ?></option>
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
										<td><input type="text" readonly id="gtn_possibleScore" name="data[possible_score]" class="form-control" style="font-weight:bold" value="<?php echo $gtn_list['possible_score'] ?>"></td>

										<td style="font-weight:bold; font-size:16px">Earned Score:</td>
										<td><input type="text" readonly id="gtn_earnedScore" name="data[earned_score]" class="form-control" style="font-weight:bold" value="<?php echo $gtn_list['earned_score'] ?>"></td>

										<td style="font-weight:bold; font-size:16px; text-align:right">Overall Score:</td>
										<td><input type="text" readonly id="gtn_overallScore" name="data[overall_score]" class="form-control" style="font-weight:bold" value="<?php echo $gtn_list['overall_score'] ?>"></td>
									</tr>
									<tr style="height:25px; font-weight:bold; background-color:#D2B4DE">
										<td colspan=4>PARAMETER</td>
										<td>WEIGHTAGE</td>
										<td>STATUS</td>
									</tr>
									<tr>
										<td colspan=4>Did the recruiter maintained a polite tone?</td>
										<td>5</td>
										<td>
											<select class="form-control gtn_points" name="data[polite_tone]" required>
												<option gtn_val=5 <?php echo $gtn_list['polite_tone'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option gtn_val=5 <?php echo $gtn_list['polite_tone'] == "No"?"selected":"";?> value="No">No</option>
												<option gtn_val=0 <?php echo $gtn_list['polite_tone'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
									</tr>
									<tr>
										<td colspan=4>Did the recruiter tried to figure out candidate communication skills</td>
										<td>5</td>
										<td>
											<select class="form-control gtn_points"  name="data[communication_skills]" required>
												<option gtn_val=5 <?php echo $gtn_list['communication_skills'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option gtn_val=5 <?php echo $gtn_list['communication_skills'] == "No"?"selected":"";?> value="No">No</option>
												<option gtn_val=0 <?php echo $gtn_list['communication_skills'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
									</tr>
									<tr>
										<td colspan=4>Did the recruiter selected right profile as per Job description?</td>
										<td>15</td>
										<td>
											<select class="form-control gtn_points"  name="data[Job_description]" required>
												<option gtn_val=15 <?php echo $gtn_list['Job_description'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option gtn_val=15 <?php echo $gtn_list['Job_description'] == "No"?"selected":"";?> value="No">No</option>
												<option gtn_val=0 <?php echo $gtn_list['Job_description'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
									</tr>
									<tr>
										<td colspan=4>Did the recuiter confirmed the candidate vital details like email, immediate contact etc</td>
										<td>10</td>
										<td>
											<select class="form-control gtn_points"  name="data[immediate_contact]" required>
												<option gtn_val=10 <?php echo $gtn_list['immediate_contact'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option gtn_val=10 <?php echo $gtn_list['immediate_contact'] == "No"?"selected":"";?> value="No">No</option>
												<option gtn_val=0 <?php echo $gtn_list['immediate_contact'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
									</tr>
									<tr>
										<td colspan=4>Recruiter explained the job role role?</td>
										<td>8</td>
										<td>
											<select class="form-control gtn_points"  name="data[job_role]" required>
												<option gtn_val=8 <?php echo $gtn_list['job_role'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option gtn_val=8 <?php echo $gtn_list['job_role'] == "No"?"selected":"";?> value="No">No</option>
												<option gtn_val=0 <?php echo $gtn_list['job_role'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
									</tr>
									<tr>
										<td colspan=4>Recruiter confirmed the vaccination status</td>
										<td>7</td>
										<td>
											<select class="form-control gtn_points"   name="data[vaccination_status]" required>
												<option gtn_val=7 <?php echo $gtn_list['vaccination_status'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option gtn_val=7 <?php echo $gtn_list['vaccination_status'] == "No"?"selected":"";?> value="No">No</option>
												<option gtn_val=0 <?php echo $gtn_list['vaccination_status'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
									</tr>
									<tr>
										<td colspan=4>Did the recruiter confirmed on primary probings like working remotely or on weekdays , job location within 1 hr.</td>
										<td>15</td>
										<td>
											<select class="form-control gtn_points" name="data[probings]" required>
												<option gtn_val=15 <?php echo $gtn_list['probings'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option gtn_val=15 <?php echo $gtn_list['probings'] == "No"?"selected":"";?> value="No">No</option>
												<option gtn_val=0 <?php echo $gtn_list['probings'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
									</tr>
									<tr>
										<td colspan=4>Did the recruiter confirm the salary </td>
										<td>5</td>
										<td>
											<select class="form-control gtn_points" name="data[confirm_salary]" required>
												<option gtn_val=5 <?php echo $gtn_list['confirm_salary'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option gtn_val=5 <?php echo $gtn_list['confirm_salary'] == "No"?"selected":"";?> value="No">No</option>
												<option gtn_val=0 <?php echo $gtn_list['confirm_salary'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
									</tr>
									<tr>
										<td colspan=4>Recruiter showed right aount of negiation skills</td>
										<td>10</td>
										<td>
											<select class="form-control gtn_points" name="data[negiation_skills]" required>
												<option gtn_val=10 <?php echo $gtn_list['negiation_skills'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option gtn_val=10 <?php echo $gtn_list['negiation_skills'] == "No"?"selected":"";?> value="No">No</option>
												<option gtn_val=0 <?php echo $gtn_list['negiation_skills'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
									</tr>
									<tr>
										<td colspan=4>Did the recruiter closed the session properly by asking joining possiblity and everything </td>
										<td>10</td>
										<td>
											<select class="form-control gtn_points" name="data[closed_session]" required>
												<option gtn_val=10 <?php echo $gtn_list['closed_session'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option gtn_val=10 <?php echo $gtn_list['closed_session'] == "No"?"selected":"";?> value="No">No</option>
												<option gtn_val=0 <?php echo $gtn_list['closed_session'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
									</tr>
									<tr>
										<td colspan=4>Recruiter updated the candidate status properly in portal?</td>
										<td>10</td>
										<td>
											<select class="form-control gtn_points" name="data[portal]" required>
												<option gtn_val=10 <?php echo $gtn_list['portal'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option gtn_val=10 <?php echo $gtn_list['portal'] == "No"?"selected":"";?> value="No">No</option>
												<option gtn_val=0 <?php echo $gtn_list['portal'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
									</tr>
					
									<tr>
										<td>Level 1</td>
										<td colspan=2><input type="text" class="form-control" name="data[level1]" value="<?php echo $gtn_list['level1'] ?>" required></td>
										<td>Level 2</td>
										<td colspan=2><input type="text" class="form-control" name="data[level2]" value="<?php echo $gtn_list['level2'] ?>" required></td>

									</tr>
									<tr>
										<td>Factor:</td>
										<td colspan=2><textarea class="form-control" name="data[factor]"><?php echo $gtn_list['factor'] ?></textarea></td>
										<td>Remarks/Observations:</td>
										<td colspan=2><textarea class="form-control" name="data[remarks]"><?php echo $gtn_list['remarks'] ?></textarea></td>
									</tr>
									<tr>
										<td colspan=2>Upload Files</td>
										<?php if($gtn_technical_id==0){ ?>
											<td colspan=4><input type="file" multiple class="form-control" id="attach_file" name="attach_file[]"></td>
										<?php }else{
											if($gtn_list['attach_file']!=''){ ?>
												<td colspan=4>
													<?php $attach_file = explode(",",$gtn_list['attach_file']);
													 foreach($attach_file as $mp){ ?>
														<audio controls='' style="background-color:#607F93"> 
														  <source src="<?php echo base_url(); ?>qa_files/qa_gtn/<?php echo $mp; ?>" type="audio/ogg">
														  <source src="<?php echo base_url(); ?>qa_files/qa_gtn/<?php echo $mp; ?>" type="audio/mpeg">
														</audio> </br>
													 <?php } ?>
												</td>
										<?php }else{
												echo '<td colspan=6><b>No Files</b></td>';
											  }
										} ?>
									</tr>
									
									<?php if($gtn_technical_id!=0){ ?>
										<tr><td colspan=2 style="font-size:16px; font-weight:bold">Agent Feedback Acceptance:</td><td colspan=4><?php echo $gtn_list['agnt_fd_acpt'] ?></td></tr>
										<tr><td colspan=2 style="font-size:16px; font-weight:bold">Agent Review:</td><td colspan=4><?php echo $gtn_list['agent_rvw_note'] ?></td></tr>
										<tr><td colspan=2 style="font-size:16px; font-weight:bold">Management Review:</td><td colspan=4><?php echo $gtn_list['mgnt_rvw_note'] ?></td></tr>
										<tr><td colspan=2 style="font-size:16px; font-weight:bold">Client Review:</td><td colspan=4><?php echo $gtn_list['client_rvw_note'] ?></td></tr>
										
										<tr><td colspan=2  style="font-size:16px">Your Review</td><td colspan=4><textarea class="form-control1" style="width:100%" id="note" name="note"  ></textarea></td></tr>
									<?php } ?>
									
									<?php 
									if($gtn_technical_id==0){
										if(is_access_qa_module()==true || is_access_qa_operations_module()==true){ ?>
											<tr><td colspan=6><button class="btn btn-success waves-effect" type="submit" id="qaformsubmit" style="width:500px">SAVE</button></td></tr>
									<?php 
										} 
									}else{ 
										if(is_access_qa_module()==true || is_access_qa_operations_module()==true){
											if(is_available_qa_feedback($gtn_list['entry_date'],72) == true){ ?>
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
