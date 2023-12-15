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
	font-weight:bold;
	background-color:#F5CBA7;
}

.eml1{
	font-weight:bold;
	background-color:#E5E8E8;
}

</style>

<?php if(is_access_qa_edit_feedback()==false){ ?>
	<style>
		.form-control{
			pointer-events:none;
			background-color:#D5DBDB;
		}
	</style>
<?php } ?>

<div class="wrap">
	<section class="app-content">


		<div class="row">
		<form id="form_mgnt_user" method="POST" action="">

			<div class="col-12">
				<div class="widget">
				
					<div class="widget-body">
						<div class="table-responsive">
							<table class="table table-striped skt-table" width="100%">
								<tbody>
									<tr style="background-color:#AEB6BF">
										<td colspan="6" id="theader" style="font-size:30px">AMERIDIAL [Fortune Builder]
										<input type="hidden" name="fbid" value="<?php echo $fbid; ?>">
										</td>
									</tr>
									
									<tr>
										<td>QA Name:</td>
										<td><input type="text" class="form-control" value="<?php echo $fobi_data['auditor_name']; ?>" disabled></td>
										<td>Audit Date:</td>
										<td><input type="text" class="form-control" value="<?php echo mysql2mmddyy($fobi_data['audit_date']); ?>" disabled></td>
										<td>Call Date:</td>
										<td><input type="text" class="form-control" id="call_date" name="call_date" value="<?php echo mysql2mmddyy($fobi_data['call_date']); ?>" required></td>
									</tr>
									<tr>
										<td>Agent:</td>
										<td>
											<select class="form-control" id="agent_id" name="agent_id" required>
												<option value="<?php echo $fobi_data['agent_id'] ?>"><?php echo $fobi_data['fname']." ".$fobi_data['lname'] ?></option>
												<option value="">-Select-</option>
												<?php foreach($agentName as $row):  ?>
													<option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
												<?php endforeach; ?>
											</select>
										</td>
										<td>Fusion ID:</td>
										<td><input type="text" readonly class="form-control" id="fusion_id" name="" value="<?php echo $fobi_data['fusion_id'] ?>"></td>
										<td>L1 Supervisor:</td>
										<td>
											<select class="form-control" id="tl_id" name="tl_id" readonly>
												<option value="<?php echo $fobi_data['tl_id'] ?>"><?php echo $fobi_data['tl_name'] ?></option>
												<option value="">--Select--</option>
												<?php foreach($tlname as $tl): ?>
													<option value="<?php echo $tl['id']; ?>"><?php echo $tl['fname']." ".$tl['lname']; ?></option>
												<?php endforeach; ?>	
											</select>
										</td>
									</tr>
									<tr>
										<td>Site/Location:</td>
										<td><input type="text" readonly class="form-control" id="office_id" value="<?php echo $fobi_data['office_id'] ?>"></td>
										<td>Call Duration:</td>
										<td><input type="text" class="form-control" id="call_duration" name="call_duration" value="<?php echo $fobi_data['call_duration'] ?>" required></td>
										<td>File No.:</td>
										<td><input type="text" class="form-control" id="file_no" name="file_no" value="<?php echo $fobi_data['file_no'] ?>" required></td>
									</tr>
									<tr>
										<td>Audit Type:</td>
										<td>
											<select class="form-control" id="audit_type" name="audit_type" required>
												<option value="<?php echo $fobi_data['audit_type'] ?>"><?php echo $fobi_data['audit_type'] ?></option>
												<option value="">-Select-</option>
												<option value="CQ Audit">CQ Audit</option>
												<option value="BQ Audit">BQ Audit</option>
												<option value="Calibration">Calibration</option>
												<option value="Pre-Certification Mock Call">Pre-Certification Mock Call</option>
												<option value="Certification Audit">Certification Audit</option>
											</select>
										</td>
										<td class="auType">Auditor Type</td>
										<td class="auType">
											<select class="form-control" id="auditor_type" name="auditor_type">
												<option value="">-Select-</option>
												<option <?php echo $fobi_data['auditor_type']=='Master'?"selected":""; ?> value="Master">Master</option>
												<option <?php echo $fobi_data['auditor_type']=='Regular'?"selected":""; ?> value="Regular">Regular</option>
											</select>
										</td>
										<td>VOC:</td>
										<td>
											<select class="form-control" id="voc" name="voc" required>
												<option value="<?php echo $fobi_data['voc'] ?>"><?php echo $fobi_data['voc'] ?></option>
												<option value="">-Select-</option>
												<option value="1">1</option>
												<option value="2">2</option>
												<option value="3">3</option>
												<option value="4">4</option>
												<option value="5">5</option>
											</select>
										</td>
									</tr>
									<tr>
										<td style="font-weight:bold; font-size:16px">Earned Score</td>
										<td><input type="text" readonly id="fb_earnedScore" name="earned_score" class="form-control" style="font-weight:bold" value="<?php echo $fobi_data['earned_score'] ?>"></td>
										<td style="font-weight:bold; font-size:16px">Possible Score</td>
										<td><input type="text" readonly id="fb_possibleScore" name="possible_score" class="form-control" style="font-weight:bold" value="<?php echo $fobi_data['possible_score'] ?>"></td>
										<td style="font-weight:bold; font-size:16px">Overall Score:</td>
										<td><input type="text" readonly id="fb_overallScore" name="overall_score" class="form-control" style="font-weight:bold" value="<?php echo $fobi_data['overall_score'] ?>"></td>
									</tr>
									<tr style="height:25px; font-weight:bold; background-color:#D4AC0D">
										<td colspan="5">PARAMETER</td>
										<td>STATUS</td>
									</tr>
									<tr>
										<td class="eml1" colspan=5>Was the call answered within 5 seconds?</td>
										<td>
											<select class="form-control amd_point" id="" name="callans5sec" required>
												<option value="">-Select-</option>
												<option amd_val=5 <?php echo $fobi_data['callans5sec']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option amd_val=5 <?php echo $fobi_data['callans5sec']=='No'?"selected":""; ?> value="No">No</option>
												<option amd_val=5 <?php echo $fobi_data['callans5sec']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
									</tr>
									<tr>
										<td class="eml1" colspan=5>Did the agent introduce him/herself to the caller?</td>
										<td>
											<select class="form-control amd_point" id="" name="agentintro" required>
												<option value="">-Select-</option>
												<option amd_val=5 <?php echo $fobi_data['agentintro']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option amd_val=5 <?php echo $fobi_data['agentintro']=='No'?"selected":""; ?> value="No">No</option>
												<option amd_val=5 <?php echo $fobi_data['agentintro']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
									</tr>
									<tr>
										<td class="eml1" colspan=5>Did the agent advise the call is being recorded?</td>
										<td>
											<select class="form-control amd_point" id="" name="agentadvise" required>
												<option value="">-Select-</option>
												<option amd_val=5 <?php echo $fobi_data['agentadvise']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option amd_val=5 <?php echo $fobi_data['agentadvise']=='No'?"selected":""; ?> value="No">No</option>
												<option amd_val=5 <?php echo $fobi_data['agentadvise']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
									</tr>
									<tr>
										<td class="eml1" colspan=5>Did the agent use the standard greeting? ("Thank you for calling the Real Estate Registration Line. Who do I have the pleasure of speaking with?")</td>
										<td>
											<select class="form-control amd_point" id="" name="agentgreeting" required>
												<option value="">-Select-</option>
												<option amd_val=5 <?php echo $fobi_data['agentgreeting']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option amd_val=5 <?php echo $fobi_data['agentgreeting']=='No'?"selected":""; ?> value="No">No</option>
												<option amd_val=5 <?php echo $fobi_data['agentgreeting']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
									</tr>
									<tr>
										<td class="eml1" colspan=5>Did the agent ask for the zip code?</td>
										<td>
											<select class="form-control amd_point" id="" name="agentzip" required>
												<option value="">-Select-</option>
												<option amd_val=5 <?php echo $fobi_data['agentzip']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option amd_val=5 <?php echo $fobi_data['agentzip']=='No'?"selected":""; ?> value="No">No</option>
												<option amd_val=5 <?php echo $fobi_data['agentzip']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
									</tr>
									<tr>
										<td class="eml1" colspan=5>Did the agent verify caller's first and last name and complete address?</td>
										<td>
											<select class="form-control amd_point" id="" name="verifycaller" required>
												<option value="">-Select-</option>
												<option amd_val=5 <?php echo $fobi_data['verifycaller']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option amd_val=5 <?php echo $fobi_data['verifycaller']=='No'?"selected":""; ?> value="No">No</option>
												<option amd_val=5 <?php echo $fobi_data['verifycaller']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
									</tr>
									<tr>
										<td class="eml1" colspan=5>Did the agent ask for and verify the caller's email address (must read back phonetically)</td>
										<td>
											<select class="form-control amd_point" id="" name="calleremail" required>
												<option value="">-Select-</option>
												<option amd_val=5 <?php echo $fobi_data['calleremail']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option amd_val=5 <?php echo $fobi_data['calleremail']=='No'?"selected":""; ?> value="No">No</option>
												<option amd_val=5 <?php echo $fobi_data['calleremail']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
									</tr>
									<tr>
										<td class="eml1" colspan=5>Did the agent correctly offer the seminars?</td>
										<td>
											<select class="form-control amd_point" id="" name="agentseminar" required>
												<option value="">-Select-</option>
												<option amd_val=10 <?php echo $fobi_data['agentseminar']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option amd_val=10 <?php echo $fobi_data['agentseminar']=='No'?"selected":""; ?> value="No">No</option>
												<option amd_val=10 <?php echo $fobi_data['agentseminar']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
									</tr>
									<tr>
										<td class="eml1" colspan=5>Did the agent correctly ask for and verify the phone number?</td>
										<td>
											<select class="form-control amd_point" id="" name="agentphone" required>
												<option value="">-Select-</option>
												<option amd_val=5 <?php echo $fobi_data['agentphone']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option amd_val=5 <?php echo $fobi_data['agentphone']=='No'?"selected":""; ?> value="No">No</option>
												<option amd_val=5 <?php echo $fobi_data['agentphone']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
									</tr>
									<tr>
										<td class="eml1" colspan=5>Did the agent inform the caller about the text reminders he/she will receive?</td>
										<td>
											<select class="form-control amd_point" id="" name="callerreminder" required>
												<option value="">-Select-</option>
												<option amd_val=5 <?php echo $fobi_data['callerreminder']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option amd_val=5 <?php echo $fobi_data['callerreminder']=='No'?"selected":""; ?> value="No">No</option>
												<option amd_val=5 <?php echo $fobi_data['callerreminder']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
									</tr>
									<tr>
										<td class="eml1" colspan=5>Did the agent summarize the call with relevant details?</td>
										<td>
											<select class="form-control amd_point" id="" name="agentsummerize" required>
												<option value="">-Select-</option>
												<option amd_val=5 <?php echo $fobi_data['agentsummerize']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option amd_val=5 <?php echo $fobi_data['agentsummerize']=='No'?"selected":""; ?> value="No">No</option>
												<option amd_val=5 <?php echo $fobi_data['agentsummerize']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
									</tr>
									<tr>
										<td class="eml1" colspan=5>Did the agent offer to register a guest?</td>
										<td>
											<select class="form-control amd_point" id="" name="registerguest" required>
												<option value="">-Select-</option>
												<option amd_val=5 <?php echo $fobi_data['registerguest']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option amd_val=5 <?php echo $fobi_data['registerguest']=='No'?"selected":""; ?> value="No">No</option>
												<option amd_val=5 <?php echo $fobi_data['registerguest']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
									</tr>
									<tr>
										<td class="eml1" colspan=5>Did the agents collect and verify the guests email address(es)? (must read back phonetically)</td>
										<td>
											<select class="form-control amd_point" id="" name="verifyguest" required>
												<option value="">-Select-</option>
												<option amd_val=10 <?php echo $fobi_data['verifyguest']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option amd_val=10 <?php echo $fobi_data['verifyguest']=='No'?"selected":""; ?> value="No">No</option>
												<option amd_val=10 <?php echo $fobi_data['verifyguest']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
									</tr>
									<tr>
										<td class="eml1" colspan=5>Did the agent demonstrate knowledge of Fortune Builders?</td>
										<td>
											<select class="form-control amd_point" id="" name="agentdemonstrate" required>
												<option value="">-Select-</option>
												<option amd_val=10 <?php echo $fobi_data['agentdemonstrate']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option amd_val=10 <?php echo $fobi_data['agentdemonstrate']=='No'?"selected":""; ?> value="No">No</option>
												<option amd_val=10 <?php echo $fobi_data['agentdemonstrate']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
									</tr>
									<tr>
										<td class="eml1" colspan=5>Did the agent use appropriate grammar and pronunciation?</td>
										<td>
											<select class="form-control amd_point" id="" name="appropiategrammer" required>
												<option value="">-Select-</option>
												<option amd_val=5 <?php echo $fobi_data['appropiategrammer']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option amd_val=5 <?php echo $fobi_data['appropiategrammer']=='No'?"selected":""; ?> value="No">No</option>
												<option amd_val=5 <?php echo $fobi_data['appropiategrammer']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
									</tr>
									<tr>
										<td class="eml1" colspan=5>Did the agent use good pacing and tone?</td>
										<td>
											<select class="form-control amd_point" id="" name="goodpacing" required>
												<option value="">-Select-</option>
												<option amd_val=5 <?php echo $fobi_data['goodpacing']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option amd_val=5 <?php echo $fobi_data['goodpacing']=='No'?"selected":""; ?> value="No">No</option>
												<option amd_val=5 <?php echo $fobi_data['goodpacing']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
									</tr>
									<tr>
										<td class="eml1" colspan=5>Did the agent display professionalism and handle difficult callers appropriately?</td>
										<td>
											<select class="form-control amd_point" id="" name="agentdisplay" required>
												<option value="">-Select-</option>
												<option amd_val=15 <?php echo $fobi_data['agentdisplay']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option amd_val=15 <?php echo $fobi_data['agentdisplay']=='No'?"selected":""; ?> value="No">No</option>
												<option amd_val=15 <?php echo $fobi_data['agentdisplay']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
									</tr>
									<tr>
										<td class="eml1" colspan=5>Did the agent maintain call control throughout the call?</td>
										<td>
											<select class="form-control amd_point" id="" name="callcontrol" required>
												<option value="">-Select-</option>
												<option amd_val=5 <?php echo $fobi_data['callcontrol']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option amd_val=5 <?php echo $fobi_data['callcontrol']=='No'?"selected":""; ?> value="No">No</option>
												<option amd_val=5 <?php echo $fobi_data['callcontrol']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
									</tr>
									<tr>
										<td class="eml1" colspan=5>Did the agent use the appropriate Closing?</td>
										<td>
											<select class="form-control amd_point" id="" name="agentclosing" required>
												<option value="">-Select-</option>
												<option amd_val=10 <?php echo $fobi_data['agentclosing']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option amd_val=10 <?php echo $fobi_data['agentclosing']=='No'?"selected":""; ?> value="No">No</option>
												<option amd_val=10 <?php echo $fobi_data['agentclosing']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
									</tr>
									<tr>
										<td class="eml1" colspan=5>Did the agent correctly disposition the call?</td>
										<td>
											<select class="form-control amd_point" id="" name="correctdisposition" required>
												<option value="">-Select-</option>
												<option amd_val=15 <?php echo $fobi_data['correctdisposition']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option amd_val=15 <?php echo $fobi_data['correctdisposition']=='No'?"selected":""; ?> value="No">No</option>
												<option amd_val=15 <?php echo $fobi_data['correctdisposition']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
									</tr>
									<tr>
										<td>Call Summary:</td>
										<td colspan="2"><textarea class="form-control" id="call_summary" name="call_summary"><?php echo $fobi_data['call_summary'] ?></textarea></td>
										<td>Feedback:</td>
										<td colspan="2"><textarea class="form-control" id="feedback" name="feedback"><?php echo $fobi_data['feedback'] ?></textarea></td>
									</tr>
									
									<?php if($fobi_data['attach_file']!=''){ ?>
									<tr>
										<td colspan="2">Audio Files</td>
										<td colspan="4">
											<?php $attach_file = explode(",",$fobi_data['attach_file']);
											 foreach($attach_file as $mp){ ?>
												<audio controls='' style="background-color:#607F93"> 
												  <source src="<?php echo base_url(); ?>qa_files/qa_ameridial/fortune_builder/<?php echo $mp; ?>" type="audio/ogg">
												  <source src="<?php echo base_url(); ?>qa_files/qa_ameridial/fortune_builder/<?php echo $mp; ?>" type="audio/mpeg">
												</audio> </br>
											 <?php } ?>
										</td>
									</tr>
									<?php } ?>
									
									<tr><td colspan="6" style="background-color:#C5C8C8"></td></tr>
									
									<tr><td colspan=2 style="font-size:16px; font-weight:bold">Agent Feedback Acceptance:</td><td colspan=4><?php echo $fobi_data['agnt_fd_acpt'] ?></td></tr>
									<tr><td colspan=2 style="font-size:16px; font-weight:bold">Agent Review:</td><td colspan=4><?php echo $fobi_data['agent_rvw_note'] ?></td></tr>
									<tr><td colspan=2 style="font-size:16px; font-weight:bold">Management Review:</td><td colspan=4><?php echo $fobi_data['mgnt_rvw_note'] ?></td></tr>
									
									<tr><td colspan="6" style="background-color:#C5C8C8"></td></tr>
									
									<tr>
										<td colspan="2"  style="font-size:16px">Your Review</td>
										<td colspan="4"><textarea class="form-control1" style="width:100%" name="note" required></textarea></td>
									</tr>
									
									<?php if(is_access_qa_module()==true || is_access_qa_operations_module()==true){
									if(is_available_qa_feedback($fobi_data['entry_date'],72) == true){ ?>
										<tr>
											<td colspan="6"><button class="btn btn-success waves-effect" type="submit" id='btnmgntSave' name='btnSave' value="SAVE" style="width:500px">SAVE</button></td>
										</tr>
									<?php } 
									} ?>
									
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
