
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
									<tr style="background-color:#AEB6BF"><td colspan="6" id="theader" style="font-size:30px">GTN Technical Staffing</td></tr>
									<?php
										if($gtn_technical_id==0){
											$auditorName = get_username();
											$auditDate = CurrDateMDY();
											$clDate_val='';
										}else{
											if($gtn_technical['entry_by']!=''){
												$auditorName = $gtn_technical['auditor_name'];
											}else{
												$auditorName = $gtn_technical['client_name'];
											}
											$auditDate = mysql2mmddyy($gtn_technical['audit_date']);
											$clDate_val = mysql2mmddyy($gtn_technical['call_date']);
										}
									?>
								
									<tr>
										<td>Auditor Name:</td>
										<?php if($gtn_technical['entry_by']!=''){
												$auditorName = $gtn_technical['auditor_name'];
											}else{
												$auditorName = $gtn_technical['client_name'];
										} ?>
										<td><input type="text" class="form-control" value="<?php echo $auditorName; ?>" disabled></td>
										<td>Audit Date:</td>
										<td><input type="text" class="form-control" value="<?php echo mysql2mmddyy($gtn_technical['audit_date']); ?>" disabled></td>
										<td>Call Date:</td>
										<td><input type="text" class="form-control" value="<?php echo mysql2mmddyy($gtn_technical['call_date']); ?>" disabled></td>
									</tr>
									<tr>
										<td>Agent:</td>
										<td>
											<select class="form-control" disabled>
												<option><?php echo $gtn_technical['fname']." ".$gtn_technical['lname']." - [".$gtn_technical['fusion_id']."]" ?></option>
											</select>
										</td>
										<td>L1 Supervisor:</td>
										<td><select class="form-control" disabled><option><?php echo $gtn_technical['tl_name'] ?></option></select></td>
										<td>Call Duration:</td>
										<td><input type="text" class="form-control"  value="<?php echo $gtn_technical['call_duration'] ?>" disabled></td>
									
									</tr>
									<tr>
									<td>Designation:</td>
										<td><input type="text" class="form-control" id="designation" value="<?php echo $gtn_technical['designation'] ?>" readonly ></td>	
									<td>Mobile No:</td>
										<td><input type="text" class="form-control" name=data[mobile_no] value="<?php echo $gtn_technical['mobile_no']; ?>" disabled></td>	
									<td>Language:</td>
										<td><input type="text" class="form-control" name=data[language] value="<?php echo $gtn_technical['language']; ?>" disabled></td>
									</tr>
									<tr>
									<td>Recruiter Name:</td>
										<td><input type="text" class="form-control" id="recruiter_name" value="<?php echo $gtn_technical['recruiter_name'] ?>" readonly ></td>	
									<td>Candidate Name:</td>
										<td><input type="text" class="form-control" name=data[candidate_name] value="<?php echo $gtn_technical['candidate_name']; ?>" disabled></td>	
									<td>Portal Name:</td>
										<td><input type="text" class="form-control" name=data[portal_name] value="<?php echo $gtn_technical['portal_name']; ?>" disabled></td>
									</tr>
									<tr>
										<td>Audit Type:</td>
										<td><select class="form-control" disabled><option><?php echo $gtn_technical['audit_type'] ?></option></select></td>
										<td>Week</td>
										<td>
											<select class="form-control"  name="data[week]" disabled>
												<option value="<?php echo $gtn_technical['week'] ?>"><?php echo $gtn_technical['week'] ?></option>
											</select>
										</td>	
										<td>VOC:</td>
										<td><select class="form-control" disabled><option><?php echo $gtn_technical['voc'] ?></option></select></td>
										
									</tr>
									<tr>
									<td style="font-weight:bold; font-size:16px; text-align:right">Overall Score:</td>
										<td><input type="text" class="form-control" style="font-weight:bold" value="<?php echo $gtn_technical['overall_score'] ?>" disabled></td>
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
											<select class="form-control gtn_points" name="data[polite_tone]" disabled>
												<option gtn_val=5 <?php echo $gtn_technical['polite_tone'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option gtn_val=5 <?php echo $gtn_technical['polite_tone'] == "No"?"selected":"";?> value="No">No</option>
												<option gtn_val=0 <?php echo $gtn_technical['polite_tone'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
									</tr>
									<tr>
										<td colspan=4>Did the recruiter tried to figure out candidate communication skills</td>
										<td>5</td>
										<td>
											<select class="form-control gtn_points"  name="data[communication_skills]" disabled>
												<option gtn_val=5 <?php echo $gtn_technical['communication_skills'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option gtn_val=5 <?php echo $gtn_technical['communication_skills'] == "No"?"selected":"";?> value="No">No</option>
												<option gtn_val=0 <?php echo $gtn_technical['communication_skills'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
									</tr>
									<tr>
										<td colspan=4>Did the recruiter selected right profile as per Job description?</td>
										<td>15</td>
										<td>
											<select class="form-control gtn_points"  name="data[Job_description]" disabled>
												<option gtn_val=15 <?php echo $gtn_technical['Job_description'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option gtn_val=15 <?php echo $gtn_technical['Job_description'] == "No"?"selected":"";?> value="No">No</option>
												<option gtn_val=0 <?php echo $gtn_technical['Job_description'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
									</tr>
									<tr>
										<td colspan=4>Did the recuiter confirmed the candidate vital details like email, immediate contact etc</td>
										<td>10</td>
										<td>
											<select class="form-control gtn_points"  name="data[immediate_contact]" disabled>
												<option gtn_val=10 <?php echo $gtn_technical['immediate_contact'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option gtn_val=10 <?php echo $gtn_technical['immediate_contact'] == "No"?"selected":"";?> value="No">No</option>
												<option gtn_val=0 <?php echo $gtn_technical['immediate_contact'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
									</tr>
									<tr>
										<td colspan=4>Recruiter explained the job role role?</td>
										<td>8</td>
										<td>
											<select class="form-control gtn_points"  name="data[job_role]" disabled>
												<option gtn_val=8 <?php echo $gtn_technical['job_role'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option gtn_val=8 <?php echo $gtn_technical['job_role'] == "No"?"selected":"";?> value="No">No</option>
												<option gtn_val=0 <?php echo $gtn_technical['job_role'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
									</tr>
									<tr>
										<td colspan=4>Recruiter confirmed the vaccination status</td>
										<td>7</td>
										<td>
											<select class="form-control gtn_points"   name="data[vaccination_status]" disabled>
												<option gtn_val=7 <?php echo $gtn_technical['vaccination_status'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option gtn_val=7 <?php echo $gtn_technical['vaccination_status'] == "No"?"selected":"";?> value="No">No</option>
												<option gtn_val=0 <?php echo $gtn_technical['vaccination_status'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
									</tr>
									<tr>
										<td colspan=4>Did the recruiter confirmed on primary probings like working remotely or on weekdays , job location within 1 hr.</td>
										<td>15</td>
										<td>
											<select class="form-control gtn_points" name="data[probings]" disabled>
												<option gtn_val=15 <?php echo $gtn_technical['probings'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option gtn_val=15 <?php echo $gtn_technical['probings'] == "No"?"selected":"";?> value="No">No</option>
												<option gtn_val=0 <?php echo $gtn_technical['probings'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
									</tr>
									<tr>
										<td colspan=4>Did the recruiter confirm the salary </td>
										<td>5</td>
										<td>
											<select class="form-control gtn_points" name="data[confirm_salary]" disabled>
												<option gtn_val=5 <?php echo $gtn_technical['confirm_salary'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option gtn_val=5 <?php echo $gtn_technical['confirm_salary'] == "No"?"selected":"";?> value="No">No</option>
												<option gtn_val=0 <?php echo $gtn_technical['confirm_salary'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
									</tr>
									<tr>
										<td colspan=4>Recruiter showed right aount of negiation skills</td>
										<td>10</td>
										<td>
											<select class="form-control gtn_points" name="data[negiation_skills]" disabled>
												<option gtn_val=10 <?php echo $gtn_technical['negiation_skills'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option gtn_val=10 <?php echo $gtn_technical['negiation_skills'] == "No"?"selected":"";?> value="No">No</option>
												<option gtn_val=0 <?php echo $gtn_technical['negiation_skills'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
									</tr>
									<tr>
										<td colspan=4>Did the recruiter closed the session properly by asking joining possiblity and everything </td>
										<td>10</td>
										<td>
											<select class="form-control gtn_points" name="data[closed_session]" disabled>
												<option gtn_val=10 <?php echo $gtn_technical['closed_session'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option gtn_val=10 <?php echo $gtn_technical['closed_session'] == "No"?"selected":"";?> value="No">No</option>
												<option gtn_val=0 <?php echo $gtn_technical['closed_session'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
									</tr>
									<tr>
										<td colspan=4>Recruiter updated the candidate status properly in portal?</td>
										<td>10</td>
										<td>
											<select class="form-control gtn_points" name="data[portal]" disabled>
												<option gtn_val=10 <?php echo $gtn_technical['portal'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option gtn_val=10 <?php echo $gtn_technical['portal'] == "No"?"selected":"";?> value="No">No</option>
												<option gtn_val=0 <?php echo $gtn_technical['portal'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
									</tr>
					
									<tr>
										<td>Level 1</td>
										<td colspan=2><input type="text" class="form-control" name="data[level1]" value="<?php echo $gtn_technical['level1'] ?>" disabled></td>
										<td>Level 2</td>
										<td colspan=2><input type="text" class="form-control" name="data[level2]" value="<?php echo $gtn_technical['level2'] ?>" disabled></td>

									</tr>
									<tr>
										<td>Factor:</td>
										<td colspan="2"><textarea class="form-control" disabled><?php echo $gtn_technical['factor'] ?></textarea></td>
										<td>Remarks/Observations:</td>
										<td colspan="2"><textarea class="form-control" disabled><?php echo $gtn_technical['remarks'] ?></textarea></td>
									</tr>
									
									<?php if($gtn_technical['attach_file']!=''){ ?>
									<tr oncontextmenu="return false;">
										<td colspan="2">Audio Files</td>
										<td colspan="4">
											<?php $attach_file = explode(",",$gtn_technical['attach_file']);
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
									
									<tr><td style="font-size:16px">Manager Review:</td> <td colspan="5" style="text-align:left"><?php echo $gtn_technical['mgnt_rvw_note'] ?></td></tr>
									<tr><td style="font-size:16px">Client Review:</td> <td colspan="5" style="text-align:left"><?php echo $gtn_technical['client_rvw_note'] ?></td></tr>
									
									<tr><td colspan="6" style="background-color:#C5C8C8"></td></tr>
									
									<form id="form_agent_user" method="POST" action="">
									 <input type="hidden" name="pnid" class="form-control" value="<?php echo $pnid; ?>">
										
										<tr>
											<td colspan=2 style="font-size:16px">Feedback Acceptance</td>
											<td colspan=2>
												<select class="form-control" id="" name="agnt_fd_acpt" required>
													<option value="">--Select--</option>
													<option <?php echo $gtn_technical['agnt_fd_acpt']=='Acceptance'?"selected":""; ?> value="Acceptance">Acceptance</option>	
													<option <?php echo $gtn_technical['agnt_fd_acpt']=='Not Acceptance'?"selected":""; ?> value="Not Acceptance">Not Acceptance</option>	
												</select>
											</td>
										</tr>
										<tr>
											<td colspan=2 style="font-size:16px">Your Review</td>
											<td colspan=4><textarea class="form-control" name="note" required><?php echo $gtn_technical['agent_rvw_note'] ?></textarea></td>
										</tr>
										
										<?php if(is_access_qa_agent_module()==true){
										if(is_available_qa_feedback($gtn_technical['entry_date'],72) == true){ ?>
											<tr>
												<?php if($gtn_technical['agnt_fd_acpt']==''){ ?>
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
