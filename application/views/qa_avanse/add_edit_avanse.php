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

<?php if($avanse_id!=0){
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
										<td colspan="6" id="theader" style="font-size:30px">Avanse</td>
										<input type="hidden" name="audit_start_time" value="<?php echo CurrMySqlDate(); ?>">
									</tr>
									<?php
										if($avanse_id==0){
											$auditorName = get_username();
											$auditDate = CurrDateMDY();
											$clDate_val='';
										}else{
											if($auditData['entry_by']!=''){
												$auditorName = $auditData['auditor_name'];
											}else{
												$auditorName = $auditData['client_name'];
											}
											$auditDate = mysql2mmddyy($auditData['audit_date']);
											$clDate_val = mysql2mmddyy($auditData['call_date']);
										}
									?>
									<tr>
										<td>Auditor Name:</td>
										<td><input type="text" class="form-control" value="<?php echo $auditorName; ?>" required></td>
										<td>Audit Date:</td>
										<td><input type="text" class="form-control" value="<?php echo $auditDate; ?>" required></td>
										<td>Call Date:</td>
										<td style="width:200px"><input type="text" class="form-control" id="call_date" name="call_date" value="<?php echo $clDate_val; ?>" required></td>
									</tr>
									<tr>
										<td>Agent Name:</td>
										<td>
											<select class="form-control" id="agent_id" name="data[agent_id]" required >
												<?php if($auditData['agent_id']){ ?>
												<option value="<?php echo $auditData['agent_id'] ?>"><?php echo $auditData['fname']." ".$auditData['lname'] ?></option>
											   <?php } ?>
												<option value="">--Select--</option>
												<?php foreach($agentName as $row):  ?>
													<option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
												<?php endforeach; ?>
											</select>
										</td>
										<td>Agent ID:</td>
										<td><input type="text" class="form-control" id="fusion_id" value="<?php echo $auditData['fusion_id'] ?>" readonly ></td>
										<td>L1 Supervisor:</td>
										<td>
											<select class="form-control" id="tl_id" name="data[tl_id]" readonly>
												<option value="<?php echo $auditData['tl_id'] ?>"><?php echo $auditData['tl_name'] ?></option>
												<option value="">--Select--</option>
												<?php foreach($tlname as $tl): ?>
													<option value="<?php echo $tl['id']; ?>"><?php echo $tl['fname']." ".$tl['lname']; ?></option>
												<?php endforeach; ?>	
											</select>
										</td>
									</tr>
									<tr>
										<td>Campaign:</td>
										<td>
											<select class="form-control" name="data[campaign]" required>
												<option value="<?php echo $auditData['campaign'] ?>"><?php echo $auditData['campaign'] ?></option>
												<option value="">-Select-</option>
												<option value="Cross">Cross</option>
												<option value="Avanse wellness">Avanse wellness</option>
												<option value="Avanse Preapproved">Avanse Preapproved</option>
											</select>
										</td>
										<td>Product Name:</td>
										<td>
											<select class="form-control" name="data[product]" required>
												<option value="<?php echo $auditData['product'] ?>"><?php echo $auditData['product'] ?></option>
												<option value="">-Select-</option>
												<option value="Pre Approved PL">Pre Approved PL</option>
											</select>
										</td>
										<td>Customer VOC:</td>
										<td>
											<select class="form-control" name="data[customer_voc]" required>
												<option value="<?php echo $auditData['customer_voc'] ?>"><?php echo $auditData['customer_voc'] ?></option>
												<option value="">-Select-</option>
												<option value="Already taken loan form others">Already taken loan form others</option>
												<option value="Rate of interest is very High">Rate of interest is very High</option>
												<option value="Trust issue">Trust issue</option>
											</select>
										</td>
									</tr>
									<tr>
										<td>Phone Number:</td>
										<td><input type="text" class="form-control" name="data[phone]" value="<?php echo $auditData['phone'] ?>" required></td>
										<td>Agent Disposition:</td>
										<td><input type="text" class="form-control" name="data[agent_disposition]" value="<?php echo $auditData['agent_disposition'] ?>" required></td>
										<td>QA Disposition:</td>
										<td><input type="text" class="form-control" name="data[qa_disposition]" value="<?php echo $auditData['qa_disposition'] ?>" required></td>
									</tr>
									<tr>
										<td>Audit Type:</td>
										<td>
											<select class="form-control" id="audit_type" name="data[audit_type]" required>
											<option value="">-Select-</option>
											<option <?php echo $auditData['audit_type']=='CQ Audit'?"selected":""; ?> value="CQ Audit">CQ Audit</option>
											<option <?php echo $auditData['audit_type']=='BQ Audit'?"selected":""; ?> value="BQ Audit">BQ Audit</option>
											<option <?php echo $auditData['audit_type']=='Calibration'?"selected":""; ?> value="Calibration">Calibration</option>
											<option <?php echo $auditData['audit_type']=='Pre-Certificate Mock Call'?"selected":""; ?> value="Pre-Certificate Mock Call">Pre-Certificate Mock Call</option>
											<option <?php echo $auditData['audit_type']=='Certificate Audit'?"selected":""; ?> value="Certificate Audit">Certificate Audit</option>
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
												<option value="">-Select-</option>
												<option <?php echo $auditData['voc']=='1'?"selected":""; ?> value="1">1</option>
												<option <?php echo $auditData['voc']=='2'?"selected":""; ?> value="2">2</option>
												<option <?php echo $auditData['voc']=='3'?"selected":""; ?> value="3">3</option>
												<option <?php echo $auditData['voc']=='4'?"selected":""; ?> value="4">4</option>
												<option <?php echo $auditData['voc']=='5'?"selected":""; ?> value="5">5</option>
											</select>
										</td>
									</tr>
									<tr>
										<td style="font-weight:bold; font-size:16px">Possible Score:</td>
										<td><input type="text" readonly id="avanse_possible_score" name="data[possible_score]" class="form-control" style="font-weight:bold" value="<?php echo $auditData['possible_score'] ?>"></td>
										<td style="font-weight:bold; font-size:16px">Earned Score:</td>
										<td><input type="text" readonly id="avanse_earned_score" name="data[earned_score]" class="form-control" style="font-weight:bold" value="<?php echo $auditData['earned_score'] ?>"></td>
										<td style="font-weight:bold; font-size:16px; text-align:right">Overall Score:</td>
										<td><input type="text" readonly id="avanse_overall_score" name="data[overall_score]" class="form-control" style="font-weight:bold" value="<?php echo $auditData['overall_score'] ?>"></td>
									</tr>
									<tr style="height:25px; font-weight:bold; background-color:#85C1E9">
										<td>Parameters</td>
										<td>Sub Parameters</td>
										<td>Rating</td>
										<td>Legend</td>
										<td colspan=2>Remarks</td>
									</tr>
									<tr>
										<td class="eml1" rowspan=3>Greeting</td>
										<td class="eml1">Call Opening</td>
										<td>
											<select class="form-control avanse_val" name="data[call_opening]" max-possible=5 required>
												<option avanse_val=5 <?php echo $auditData['call_opening'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option avanse_val=0 <?php echo $auditData['call_opening'] == "No"?"selected":"";?> value="No">No</option>
											</select>
										</td>
										<td style="width:300px">
											Welcome script used Identifies Self & brand, Opening should be in 5sec Opening Script to be followed. The Caller Name, Brand Name and Consumer Name If any of these components are missing than the same will be marked as no
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt1]" value="<?php echo $auditData['cmt1'] ?>"></td>
									</tr>
									<tr>
										<td class="eml1">Call Closing </td>
										<td>
											<select class="form-control avanse_val" name="data[call_closing]" max-possible=5 required>
												<option avanse_val=5 <?php echo $auditData['call_closing'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option avanse_val=0 <?php echo $auditData['call_closing'] == "No"?"selected":"";?> value="No">No</option>
												<option avanse_val=0 <?php echo $auditData['call_closing'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td style="width:300px">
											Further assistance to be given followed by closing script if any of these component missing then it will marked no otherwise yes 
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt2]" value="<?php echo $auditData['cmt2'] ?>"></td>
									</tr>
									<tr>
										<td class="eml1">Purpose of the call</td>
										<td>
											<select class="form-control avanse_val" name="data[call_purpose]" max-possible=5 required>
												<option avanse_val=5 <?php echo $auditData['call_purpose'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option avanse_val=0 <?php echo $auditData['call_purpose'] == "No"?"selected":"";?> value="No">No</option>
											</select>
										</td>
										<td style="width:300px">
											 as you are valuable customer of Avanse finance services and you had taken education loan from us hence Avanse is providing you an offer of pre-approved personal and vocational loan which you can avail very easily. If it is missed on call then marked No otherwise yes
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt3]" value="<?php echo $auditData['cmt3'] ?>"></td>
									</tr>
									<tr>
										<td class="eml1" rowspan=3>Selling skills</td>
										<td class="eml1">Did agent use the FAB approach to sell product ?</td>
										<td>
											<select class="form-control avanse_val" name="data[did_agent_use_fab]" max-possible=5 required>
												<option avanse_val=5 <?php echo $auditData['did_agent_use_fab'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option avanse_val=0 <?php echo $auditData['did_agent_use_fab'] == "No"?"selected":"";?> value="No">No</option>
											</select>
										</td>
										<td style="width:300px">
											Associate should recognize lead generate signal. If customer not interested, associate should make effective attempt to convince the customer (Min Effective 2 Attempt)
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt4]" value="<?php echo $auditData['cmt4'] ?>"></td>
									</tr>
									<tr>
										<td class="eml1">Did agent covince the customer appropriately ?</td>
										<td>
											<select class="form-control avanse_val" name="data[did_agent_covince]" max-possible=5 required>
												<option avanse_val=5 <?php echo $auditData['did_agent_covince'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option avanse_val=0 <?php echo $auditData['did_agent_covince'] == "No"?"selected":"";?> value="No">No</option>
											</select>
										</td>
										<td style="width:300px">
											Effective convincing to be done by using live example
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt5]" value="<?php echo $auditData['cmt5'] ?>"></td>
									</tr>
									<tr>
										<td class="eml1">Did agent able to handle customer objection efficiently</td>
										<td>
											<select class="form-control avanse_val" name="data[customer_objection_handle]" max-possible=5 required>
												<option avanse_val=5 <?php echo $auditData['customer_objection_handle'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option avanse_val=0 <?php echo $auditData['customer_objection_handle'] == "No"?"selected":"";?> value="No">No</option>
											</select>
										</td>
										<td style="width:300px">
											Associate should give correct rebuttal on call then and there when customer has raised any objection/query in positive manner. Associate should not mis-guide / skip the objection raised by customer on the call
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt6]" value="<?php echo $auditData['cmt6'] ?>"></td>
									</tr>
									<tr>
										<td class="eml1" rowspan=2>Communication</td>
										<td class="eml1">Tone & Pace</td>
										<td>
											<select class="form-control avanse_val" name="data[tone_pace]" max-possible=5 required>
												<option avanse_val=5 <?php echo $auditData['tone_pace'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option avanse_val=0 <?php echo $auditData['tone_pace'] == "No"?"selected":"";?> value="No">No</option>
											</select>
										</td>
										<td style="width:300px">
											Pace has to be proper and should not impact the clarity of the words which makes it difficult for the Consumer to understand, no rushing should be observed. Tone should be energetic and not flat, smiling tone should be maintained. If all of these things are adhered it will be rated as yes if any two of these components are adhered it will be rated as No Any interruption more than 1 time will lead to mark down as No, choice of words and call handling should be professional, no jargons to be used & wrong sentence formation
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt7]" value="<?php echo $auditData['cmt7'] ?>"></td>
									</tr>
									<tr>
										<td class="eml1">Dead air & Hold</td>
										<td>
											<select class="form-control avanse_val" name="data[dead_air_hold]" max-possible=5 required>
												<option avanse_val=5 <?php echo $auditData['dead_air_hold'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option avanse_val=0 <?php echo $auditData['dead_air_hold'] == "No"?"selected":"";?> value="No">No</option>
												<option avanse_val=0 <?php echo $auditData['dead_air_hold'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td style="width:300px">
											Dead air of more than 10 secs will be marked as No. Hold script and hold time more than 1 minute will be marked as No
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt8]" value="<?php echo $auditData['cmt8'] ?>"></td>
									</tr>
									<tr>
										<td class="eml1 text-danger" rowspan=3>Information & Documentation</td>
										<td class="eml1 text-danger">Complete & Correct Information</td>
										<td>
											<select class="form-control avanse_val" id="complete_correct_information" name="data[complete_correct_information]" max-possible=10 required>
												<option avanse_val=10 <?php echo $auditData['complete_correct_information'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option avanse_val=0 <?php echo $auditData['complete_correct_information'] == "Fatal"?"selected":"";?> value="Fatal">Fatal</option>
											</select>
										</td>
										<td style="width:300px">
											Need to inform the sectioned amount & ROI & need to share the link with the customer. If no information or incomplete information given to the customer it will be marked as fatal. The call will be 0
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt9]" value="<?php echo $auditData['cmt9'] ?>"></td>
									</tr>
									<tr>
										<td class="eml1 text-danger">Mandatory Information</td>
										<td>
											<select class="form-control avanse_val" id="mandatory_information" name="data[mandatory_information]" max-possible=10 required>
												<option avanse_val=10 <?php echo $auditData['mandatory_information'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option avanse_val=0 <?php echo $auditData['mandatory_information'] == "Fatal"?"selected":"";?> value="Fatal">Fatal</option>
											</select>
										</td>
										<td style="width:300px">
											Need to inform the sectioned amount & ROI. Need to confirm the occupation - salaried or business man, if it is missed then it will marked as FATAL. The call will be 0
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt10]" value="<?php echo $auditData['cmt10'] ?>"></td>
									</tr>
									<tr>
										<td class="eml1 text-danger">Tagging & Remarks</td>
										<td>
											<select class="form-control avanse_val" id="tagging_remarks" name="data[tagging_remarks]" max-possible=10 required>
												<option avanse_val=10 <?php echo $auditData['tagging_remarks'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option avanse_val=0 <?php echo $auditData['tagging_remarks'] == "Fatal"?"selected":"";?> value="Fatal">Fatal</option>
											</select>
										</td>
										<td style="width:300px">
											Correct disposition used, correct & complete notes capture. If any of these component is missing then call be fatal, the call score is 0
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt11]" value="<?php echo $auditData['cmt11'] ?>"></td>
									</tr>
									<tr>
										<td rowspan=3 class="eml1 text-danger">Zero Tolerance (Compliance Critical)</td>
										<td class="text-danger">Call Disconnection</td>
										<td>
											<select class="form-control avanse_val" id="call_disconnection" name="data[call_disconnection]" max-possible=10 required>
												<option avanse_val=10 <?php echo $auditData['call_disconnection'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option avanse_val=0 <?php echo $auditData['call_disconnection'] == "Fatal"?"selected":"";?> value="Fatal">Fatal</option>
											</select>
										</td>
										<td style="width:300px">
											Agent purposely disconnected the call during conversation with customer
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt12]" value="<?php echo $auditData['cmt12'] ?>"></td>
									</tr>
									<tr>
										<td class="eml1 text-danger">Call/Query Avoidance</td>
										<td>
											<select class="form-control avanse_val" id="call_avoidance" name="data[call_avoidance]" max-possible=10 required>
												<option avanse_val=10 <?php echo $auditData['call_avoidance'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option avanse_val=0 <?php echo $auditData['call_avoidance'] == "Fatal"?"selected":"";?> value="Fatal">Fatal</option>
											</select>
										</td>
										<td style="width:300px">
											Not given response to the customer OR Customer disconnected the call due to no response
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt13]" value="<?php echo $auditData['cmt13'] ?>"></td>
									</tr>
									<tr>
										<td class="eml1 text-danger">Personal & Confedential Details not to be shared</td>
										<td>
											<select class="form-control avanse_val" name="data[details_shared]" id="details_shared" max-possible=10 required>
												<option avanse_val=10 <?php echo $auditData['details_shared'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option avanse_val=0 <?php echo $auditData['details_shared'] == "Fatal"?"selected":"";?> value="Fatal">Fatal</option>
											</select>
										</td>
										<td style="width:300px">
											Sharing personal details or company's confidential details with customer
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt14]" value="<?php echo $auditData['cmt14'] ?>"></td>
									</tr>
									
									<tr>
										<td>Call Summary:</td>
										<td colspan=2><textarea class="form-control"   name="data[call_summary]"><?php echo $auditData['call_summary'] ?></textarea></td>
										<td>Feedback:</td>
										<td colspan=2><textarea class="form-control"   name="data[feedback]"><?php echo $auditData['feedback'] ?></textarea></td>
									</tr>
									<tr>
										<td colspan=2>Upload Files (mp3,mp4,jpg,jpeg,png)</td>
										<?php if($avanse_id==0){ ?>
											<td colspan=4><input type="file" multiple class="form-control" id="attach_file" name="attach_file[]" accept="audio/mp3,audio/*;capture=microphone,image/png, image/gif, image/jpeg,video/mp4,video/x-m4v,video/*"></td>
										<?php }else{
											if($auditData['attach_file']!=''){ ?>
												<td colspan=4>
													<?php $attach_file = explode(",",$auditData['attach_file']);
													 foreach($attach_file as $mp){ ?>
														<audio controls='' style="background-color:#607F93"> 
														  <source src="<?php echo base_url(); ?>qa_files/qa_avanse/<?php echo $mp; ?>" type="audio/ogg">
														  <source src="<?php echo base_url(); ?>qa_files/qa_avanse/<?php echo $mp; ?>" type="audio/mpeg">
														</audio> </br>
													 <?php } ?>
												</td>
										<?php }else{
												echo '<td colspan=6><b>No Files</b></td>';
											  }
										} ?>
									</tr>
									<?php if($avanse_id!=0){ ?>
										<tr><td colspan=2 style="font-size:16px; font-weight:bold">Agent Feedback Acceptance:</td><td colspan=4><?php echo $auditData['agnt_fd_acpt'] ?></td></tr>
										<tr><td colspan=2 style="font-size:16px; font-weight:bold">Agent Review:</td><td colspan=4><?php echo $auditData['agent_rvw_note'] ?></td></tr>
										<tr><td colspan=2 style="font-size:16px; font-weight:bold">Management Review:</td><td colspan=4><?php echo $auditData['mgnt_rvw_note'] ?></td></tr>
										<tr><td colspan=2 style="font-size:16px; font-weight:bold">Client Review:</td><td colspan=4><?php echo $auditData['client_rvw_note'] ?></td></tr>
										
										<tr><td colspan=2  style="font-size:16px">Your Review</td><td colspan=4><textarea class="form-control1" style="width:100%" id="note" name="note"  ></textarea></td></tr>
									<?php } ?>
									
									<?php 
									if($avanse_id==0){
										if(is_access_qa_module()==true || is_access_qa_operations_module()==true){ ?>
											<tr><td colspan=6><button class="btn btn-success waves-effect" type="submit" id="qaformsubmit" style="width:500px">SAVE</button></td></tr>
									<?php 
										} 
									}else{ 
										if(is_access_qa_module()==true || is_access_qa_operations_module()==true){
											if(is_available_qa_feedback($auditData['entry_date'],72) == true){ ?>
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