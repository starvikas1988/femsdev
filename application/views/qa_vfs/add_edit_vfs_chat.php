
<style>

.table > tbody > tr > td{
	text-align: center;
	font-size:13px;
}

#theader{
	font-size:20px;
	font-weight:bold;
	background-color:#CA6F1E;
}

input[type='checkbox']{
	width: 20px;
}

#fatalspan3{

	background-color: transparent;
	border: none;
	outline: none;
	color: white;
}

</style>

<?php if($chat_id!=0){
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
									<tr style="background-color:#AEB6BF">
										<td colspan="6" id="theader">VFS Chat Monitoring Form  </td>
										<input type="hidden" name="audit_start_time" value="<?php echo CurrMySqlDate(); ?>">
									</tr>
									<tr>
									<?php
										if($chat_id==0){
											$auditorName = get_username();
											$auditDate = CurrDateMDY();
											$clDate_val='';
										}else{
											if($vfs_chat['entry_by']!=''){
												$auditorName = $vfs_chat['auditor_name'];
											}else{
												$auditorName = $vfs_chat['client_name'];
											}
											$auditDate = mysql2mmddyy($vfs_chat['audit_date']);
											$clDate_val=mysql2mmddyy($vfs_chat['call_date']);
										}
									?>
										<td>QA Name:</td>
										<td style="width:300px"><input type="text" class="form-control" value="<?php echo $auditorName; ?>" disabled></td>
										<td style="width:150px">Audit Date:</td>
										<td><input type="text" class="form-control" value="<?php echo $auditDate; ?>" disabled></td>
										<td>Date and time Of Chat:</td>
										<td><input type="text" class="form-control" id="call_date" name="call_date" value="<?php echo $clDate_val; ?>" required></td>
									</tr>
									<tr>
										<td>Employee Name:</td>
										<td>
											<select class="form-control" id="agent_id" name="agent_id" required>
												<option value="<?php echo $vfs_chat['agent_id'] ?>"><?php echo $vfs_chat['fname']." ".$vfs_chat['lname'] ?></option>
												<option value="">-Select-</option>
												<?php foreach($agentName as $row):  ?>
													<option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
												<?php endforeach; ?>
											</select>
										</td>
										<td>Fusion ID:</td>
										<td><input type="text" class="form-control" id="fusion_id" name="" value="<?php echo $vfs_chat['fusion_id']; ?>" readonly></td>
										<td>L1 Supervisor:</td>
										<td style="width:250px">
											<select class="form-control" id="tl_id" name="tl_id" readonly>
												<option value="<?php echo $vfs_chat['tl_id'] ?>"><?php echo $vfs_chat['tl_name'] ?></option>
												<option value="">--Select--</option>
												<?php foreach($tlname as $tl): ?>
													<option value="<?php echo $tl['id']; ?>"><?php echo $tl['fname']." ".$tl['lname']; ?></option>
												<?php endforeach; ?>	
											</select>
										</td>
									</tr>
									<tr>
										<td>Call Duration:</td>
										<td><input type="text" class="form-control" id="call_duration" name="call_duration" value="<?php echo $vfs_chat['call_duration']; ?>" required></td>
										<td>Mission:</td>
										<td><input type="text" class="form-control"  name="mission" value="<?php echo $vfs_chat['mission']; ?>" required></td>
										<td>Recording ID:</td>
										<td><input type="text" class="form-control"  name="recording_id" value="<?php echo $vfs_chat['recording_id']; ?>" required></td>
									</tr>
									<tr>
										<td>Week:</td>
										<td>
											<select class="form-control"  name="week" required>
												<option value="<?php echo $vfs_chat['week'] ?>"><?php echo $vfs_chat['week'] ?></option>
												<option value="">-Select-</option>
												<option value="Week1">Week1</option>
												<option value="Week2">Week2</option>
												<option value="Week3">Week3</option>
												<option value="Week4">Week4</option>
												<option value="Week5">Week5</option>
											</select>
										</td>
										<td>Status:</td>
										<td><input type="text" class="form-control" id="fatalspan3" name="autofail_status" value="<?php echo $vfs_chat['autofail_status']; ?>" readonly></td>
									</tr>
									<tr>
										<td>Audit Type:</td>
										<td>
											<select class="form-control" id="audit_type" name="audit_type" required>
											<option value="">-Select-</option>
											<option <?php echo $vfs_chat['audit_type']=='CQ Audit'?"selected":""; ?> value="CQ Audit">CQ Audit</option>
											<option <?php echo $vfs_chat['audit_type']=='BQ Audit'?"selected":""; ?> value="BQ Audit">BQ Audit</option>
											<option <?php echo $vfs_chat['audit_type']=='Calibration'?"selected":""; ?> value="Calibration">Calibration</option>
											<option <?php echo $vfs_chat['audit_type']=='Pre-Certificate Mock Call'?"selected":""; ?> value="Pre-Certificate Mock Call">Pre-Certificate Mock Call</option>
											<option <?php echo $vfs_chat['audit_type']=='Certificate Audit'?"selected":""; ?> value="Certificate Audit">Certificate Audit</option>
											</select>
										</td>
										<td class="auType">Auditor Type</td>
										<td class="auType">
											<select class="form-control" id="auditor_type" name="auditor_type">
												<option value="">-Select-</option>
												<option value="Master">Master</option>
												<option value="Regular">Regular</option>
											</select>
										</td>
										<td>VOC:</td>
										<td>
											<select class="form-control" id="voc" name="voc" required>
												<option value="">-Select-</option>
												<option <?php echo $vfs_chat['voc']=='1'?"selected":""; ?> value="1">1</option>
												<option <?php echo $vfs_chat['voc']=='2'?"selected":""; ?> value="2">2</option>
												<option <?php echo $vfs_chat['voc']=='3'?"selected":""; ?> value="3">3</option>
												<option <?php echo $vfs_chat['voc']=='4'?"selected":""; ?> value="4">4</option>
												<option <?php echo $vfs_chat['voc']=='5'?"selected":""; ?> value="5">5</option>
											</select>
										</td>
									</tr>
									<tr>
										<td style="font-weight:bold">Total Score:</td>
										<td><input type="text" readonly id="vfsEarned" name="earned_score" class="form-control" style="font-weight:bold" value="<?php echo $vfs_chat['overall_score'] ?>"></td>
										<td style="font-weight:bold">Target:</td>
										<td><input type="text" readonly id="vfsPossible" name="possible_score" class="form-control" style="font-weight:bold" value="<?php echo $vfs_chat['overall_score'] ?>"></td>
										<td style="font-weight:bold">Overall Score Percentage:</td>
										<td><input type="text" readonly id="vfsOverallScore" name="overall_score" class="form-control vfsChatFatal" style="font-weight:bold" value="<?php echo $vfs_chat['overall_score'] ?>"></td>
									</tr>
									<tr style="font-weight:bold; background-color:#2471A3; color:white">
										<td colspan=2>Parameters</td>
										<td>Weightage</td>
										<td>Rating</td>
										<td>Final Score</td>
										<td>Remarks</td>
									</tr>
									<tr>
										<td style="background-color:#BFC9CA"><b>1</b></td>
										<td colspan=1 style="background-color:#BFC9CA">Opening</td>
										<td style="background-color:#BFC9CA">4</td>
										<td style="background-color:#BFC9CA"></td>
										<td style="background-color:#BFC9CA" id="score_opening">4</td>
										<td style="background-color:#BFC9CA"></td>
									</tr>
									<tr>
										<td></td>
										<td colspan=1>a. Appropriate greeting - as per script</td>
										<td>4</td>
										<td>
											<select class="form-control vfsVal" data-id="opening" name="appropiate_greeting" required><!-- <option value="">-Select-</option> -->
												<option vfs_val=4 <?php echo $vfs_chat['appropiate_greeting']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option vfs_val=4 <?php echo $vfs_chat['appropiate_greeting']=='No'?"selected":""; ?> value="No">No</option>
												<option vfs_val=0 <?php echo $vfs_chat['appropiate_greeting']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td id="score_appropiate_greeting">4</td>
										<td><textarea class="form-control" name="comm0"><?php echo $vfs_chat['comm0'] ?></textarea></td>
									</tr>
									<tr>
										<td style="background-color:#BFC9CA"><b>2</b></td>
										<td colspan=1 style="background-color:#BFC9CA">Accuracy aspects</td>
										<td style="background-color:#BFC9CA">38</td>
										<td style="background-color:#BFC9CA"></td>
										<td style="background-color:#BFC9CA" id="score_technical_aspects">38</td>
										<td style="background-color:#BFC9CA"></td>

									</tr>
									<tr>
										<td></td>
										<td colspan=1>a. Response Time</td>
										<td>5</td>
										<td>
											<select class="form-control vfsVal"  data-id="technical_aspects" name="response_time" required>
												<!-- <option value="">-Select-</option> -->
												<option vfs_val=5 <?php echo $vfs_chat['response_time']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option vfs_val=5 <?php echo $vfs_chat['response_time']=='No'?"selected":""; ?> value="No">No</option>
												<option vfs_val=0 <?php echo $vfs_chat['response_time']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td id="score_response_time">5</td>
										<td><textarea class="form-control" name="comm1"><?php echo $vfs_chat['comm1'] ?></textarea></td>
									</tr>
									<tr>
										<td></td>
										<td colspan=1>b. FCR achieved</td>
										<td>5</td>
										<td>
											<select class="form-control vfsVal"  data-id="technical_aspects" name="FCR_achieved" required>
												<!-- <option value="">-Select-</option> -->
												<option vfs_val=5 <?php echo $vfs_chat['FCR_achieved']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option vfs_val=5 <?php echo $vfs_chat['FCR_achieved']=='No'?"selected":""; ?> value="No">No</option>
												<option vfs_val=0 <?php echo $vfs_chat['FCR_achieved']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td id="score_FCR_achieved">5</td>
										<td><textarea class="form-control" name="comm2"><?php echo $vfs_chat['comm2'] ?></textarea></td>
									</tr>
									<tr>
										<td></td>
										<td colspan=1>c. Complete and accurate information</td>
										<td>4</td>
										<td>
											<select class="form-control vfsVal"  data-id="technical_aspects" name="accurate_information" required>
												<!-- <option value="">-Select-</option> -->
												<option vfs_val=4 <?php echo $vfs_chat['accurate_information']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option vfs_val=4 <?php echo $vfs_chat['accurate_information']=='No'?"selected":""; ?> value="No">No</option>
												<option vfs_val=0 <?php echo $vfs_chat['accurate_information']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td id="score_understand_issue">4</td>
										<td><textarea class="form-control" name="comm3"><?php echo $vfs_chat['comm3'] ?></textarea></td>
									</tr>
									<tr>
										<td></td>
										<td colspan=1>d. Understand the issue of the applicant</td>
										<td>4</td>
										<td>
											<select class="form-control vfsVal"  data-id="technical_aspects" name="understand_issue" required>
												<!-- <option value="">-Select-</option> -->
												<option vfs_val=4 <?php echo $vfs_chat['understand_issue']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option vfs_val=4 <?php echo $vfs_chat['understand_issue']=='No'?"selected":""; ?> value="No">No</option>
												<option vfs_val=0 <?php echo $vfs_chat['understand_issue']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td id="score_understand_issue">4</td>
										<td><textarea class="form-control" name="comm4"><?php echo $vfs_chat['comm4'] ?></textarea></td>
									</tr>
									<tr>
										<td></td>
										<td colspan=1>e. Attentiveness displayed</td>
										<td>5</td>
										<td>
											<select class="form-control vfsVal"  data-id="technical_aspects" name="attentiveness_display" required>
												<!-- <option value="">-Select-</option> -->
												<option vfs_val=5 <?php echo $vfs_chat['attentiveness_display']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option vfs_val=5 <?php echo $vfs_chat['attentiveness_display']=='No'?"selected":""; ?> value="No">No</option>
												<option vfs_val=0 <?php echo $vfs_chat['attentiveness_display']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td id="score_attentiveness_display">5</td>
										<td><textarea class="form-control" name="comm4"><?php echo $vfs_chat['comm5'] ?></textarea></td>
									</tr>
									<tr>
										<td></td>
										<td colspan=1>f.Paraphrasing</td>
										<td>5</td>
										<td>
											<select class="form-control vfsVal"  data-id="technical_aspects" name="paraphrasing" required>
												<!-- <option value="">-Select-</option> -->
												<option vfs_val=5 <?php echo $vfs_chat['paraphrasing']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option vfs_val=5 <?php echo $vfs_chat['paraphrasing']=='No'?"selected":""; ?> value="No">No</option>
												<option vfs_val=0 <?php echo $vfs_chat['paraphrasing']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td id="score_paraphrasing">5</td>
										<td><textarea class="form-control" name="comm5"><?php echo $vfs_chat['comm6'] ?></textarea></td>
									</tr>
									<tr>
										<td></td>
										<td colspan=1>g. Used all the available resources for providing resolution</td>
										<td>5</td>
										<td>
											<select class="form-control vfsVal"  data-id="technical_aspects" name="use_available_resource" required>
												<!-- <option value="">-Select-</option> -->
												<option vfs_val=5 <?php echo $vfs_chat['use_available_resource']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option vfs_val=5 <?php echo $vfs_chat['use_available_resource']=='No'?"selected":""; ?> value="No">No</option>
												<option vfs_val=0 <?php echo $vfs_chat['use_available_resource']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td id="score_use_available_resource">5</td>
										<td><textarea class="form-control" name="comm6"><?php echo $vfs_chat['comm7'] ?></textarea></td>
									</tr>
									<tr>
										<td></td>
										<td colspan=1>h. Appropriate Probing</td>
										<td>5</td>
										<td>
											<select class="form-control vfsVal"  data-id="technical_aspects" name="appropiate_probing" required>
												<!-- <option value="">-Select-</option> -->
												<option vfs_val=5 <?php echo $vfs_chat['appropiate_probing']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option vfs_val=5 <?php echo $vfs_chat['appropiate_probing']=='No'?"selected":""; ?> value="No">No</option>
												<option vfs_val=0 <?php echo $vfs_chat['appropiate_probing']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td id="score_appropiate_probing">5</td>
										<td><textarea class="form-control" name="comm7"><?php echo $vfs_chat['comm8'] ?></textarea></td>
									</tr>
									<tr>
										<td style="background-color:#BFC9CA"><b>3</b></td>
										<td colspan=1 style="background-color:#BFC9CA">Additions</td>
										<td style="background-color:#BFC9CA">14</td>
										<td style="background-color:#BFC9CA"></td>
										<td style="background-color:#BFC9CA" id="score_additions">14</td>
										<td style="background-color:#BFC9CA"></td>
									</tr>
									<tr>
										<td></td>
										<td colspan=1>a. Offers VAS options wherever applicable</td>
										<td>10</td>
										<td>
											<select class="form-control vfsVal"  data-id="additions" name="VAS_options" required>
												<option vfs_val=10 <?php echo $vfs_chat['VAS_options']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option vfs_val=10 <?php echo $vfs_chat['VAS_options']=='No'?"selected":""; ?> value="No">No</option>
												<option vfs_val=0 <?php echo $vfs_chat['VAS_options']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td id="score_VAS_options">10</td>
										<td><textarea class="form-control" name="comm8"><?php echo $vfs_chat['comm9'] ?></textarea></td>
									</tr>
									<tr>
										<td></td>
										<td colspan=1>b. Awareness created with regards to VFS website (wherever applicable)</td>
										<td>4</td>
										<td>
											<select class="form-control vfsVal"  data-id="additions" name="awareness_created" required>
												<option vfs_val=4 <?php echo $vfs_chat['awareness_created']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option vfs_val=4 <?php echo $vfs_chat['awareness_created']=='No'?"selected":""; ?> value="No">No</option>
												<option vfs_val=0 <?php echo $vfs_chat['awareness_created']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td id="score_awareness_created">4</td>
										<td><textarea class="form-control" name="comm9"><?php echo $vfs_chat['comm10'] ?></textarea></td>
									</tr>
									<tr>
										<td style="background-color:#BFC9CA"><b>4</b></td>
										<td colspan=1 style="background-color:#BFC9CA">Documentation</td>
										<td style="background-color:#BFC9CA">10</td>
										<td style="background-color:#BFC9CA"></td>
										<td style="background-color:#BFC9CA" id="score_documentation">10</td>
										<td style="background-color:#BFC9CA"></td>
									</tr>
									<tr>
										<td></td>
										<td colspan=1>a. Correct dispostion</td>
										<td>5</td>
										<td>
											<select class="form-control vfsVal"  data-id="documentation" name="correct_disposition" required>
												<option vfs_val=5 <?php echo $vfs_chat['correct_disposition']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option vfs_val=5 <?php echo $vfs_chat['correct_disposition']=='No'?"selected":""; ?> value="No">No</option>
												<option vfs_val=0 <?php echo $vfs_chat['correct_disposition']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td id="score_correct_disposition">5</td>
										<td><textarea class="form-control" name="comm10"><?php echo $vfs_chat['comm11'] ?></textarea></td>
									</tr>
									<tr>
										<td></td>
										<td colspan=1>b. Update ASM/V2</td>
										<td>5</td>
										<td>
											<select class="form-control vfsVal"  data-id="documentation" name="update_ASM" required>
												<option vfs_val=5 <?php echo $vfs_chat['update_ASM']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option vfs_val=5 <?php echo $vfs_chat['update_ASM']=='No'?"selected":""; ?> value="No">No</option>
												<option vfs_val=0 <?php echo $vfs_chat['update_ASM']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td id="score_update_ASM">5</td>
										<td><textarea class="form-control" name="comm11"><?php echo $vfs_chat['comm12'] ?></textarea></td>
									</tr>
									<tr>
										<td style="background-color:#BFC9CA"><b>5</b></td>
										<td colspan=1 style="background-color:#BFC9CA">Hold Protocol</td>
										<td style="background-color:#BFC9CA">3</td>
										<td style="background-color:#BFC9CA"></td>
										<td style="background-color:#BFC9CA" id="score_hold_protocol">3</td>
										<td style="background-color:#BFC9CA"></td>

									</tr>
									<tr>
										<td></td>
										<td colspan=1>a. Was Hold Required</td>
										<td>2</td>
										<td>
											<select class="form-control vfsVal"  data-id="hold_required" name="hold_required" required>
												<option vfs_val=2 <?php echo $vfs_chat['hold_required']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option vfs_val=2 <?php echo $vfs_chat['hold_required']=='No'?"selected":""; ?> value="No">No</option>
												<option vfs_val=0 <?php echo $vfs_chat['hold_required']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td id="score_hold_required">2</td>
										<td><textarea class="form-control" name="comm12"><?php echo $vfs_chat['comm13'] ?></textarea></td>
									</tr>
									<tr>
										<td></td>
										<td colspan=1>b. Hold Guidelines followed</td>
										<td>1</td>
										<td>
											<select class="form-control vfsVal"  data-id="hold_protocol" name="hold_guidelines" required>
												<option vfs_val=1 <?php echo $vfs_chat['hold_guidelines']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option vfs_val=1 <?php echo $vfs_chat['hold_guidelines']=='No'?"selected":""; ?> value="No">No</option>
												<option vfs_val=0 <?php echo $vfs_chat['hold_guidelines']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td id="score_hold_guidelines">1</td>
										<td><textarea class="form-control" name="comm13"><?php echo $vfs_chat['comm14'] ?></textarea></td>
									</tr>
									<tr>
										<td style="background-color:#BFC9CA"><b>6</b></td>
										<td colspan=1 style="background-color:#BFC9CA">Communication</td>
										<td style="background-color:#BFC9CA">29</td>
										<td style="background-color:#BFC9CA"></td>
										<td style="background-color:#BFC9CA" id="score_communication">29</td>
										<td style="background-color:#BFC9CA"></td>

									</tr>
									<tr>
										<td></td>
										<td colspan=1>a. Formatting</td>
										<td>5</td>
										<td>
											<select class="form-control vfsVal"  data-id="communication" name="formatting" required>
												<option vfs_val=5 <?php echo $vfs_chat['formatting']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option vfs_val=5 <?php echo $vfs_chat['formatting']=='No'?"selected":""; ?> value="No">No</option>
												<option vfs_val=0 <?php echo $vfs_chat['formatting']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td id="score_formatting">5</td>
										<td><textarea class="form-control" name="comm14"><?php echo $vfs_chat['comm15'] ?></textarea></td>
									</tr>
									<tr>
										<td></td>
										<td colspan=1>b. Avoid Negative statements</td>
										<td>5</td>
										<td>
											<select class="form-control vfsVal"  data-id="communication" name="avoid_negative_statement" required>
												<option vfs_val=5 <?php echo $vfs_chat['avoid_negative_statement']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option vfs_val=5 <?php echo $vfs_chat['avoid_negative_statement']=='No'?"selected":""; ?> value="No">No</option>
												<option vfs_val=0 <?php echo $vfs_chat['avoid_negative_statement']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td id="score_avoid_negative_statement">5</td>
										<td><textarea class="form-control" name="comm15"><?php echo $vfs_chat['comm16'] ?></textarea></td>
									</tr>
									<tr>
										<td></td>
										<td colspan=1>c. Telling the customer what to do next, Step by step procedure guide</td>
										<td>5</td>
										<td>
											<select class="form-control vfsVal"  data-id="communication" name="procedure_guide_step" required>
												<option vfs_val=5 <?php echo $vfs_chat['procedure_guide_step']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option vfs_val=5 <?php echo $vfs_chat['procedure_guide_step']=='No'?"selected":""; ?> value="No">No</option>
												<option vfs_val=0 <?php echo $vfs_chat['procedure_guide_step']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td id="score_procedure_guide_step">5</td>
										<td><textarea class="form-control" name="comm16"><?php echo $vfs_chat['comm17'] ?></textarea></td>
									</tr>
									<tr>
										<td></td>
										<td colspan=1>d. Avoid Slangs & Jargons</td>
										<td>5</td>
										<td>
											<select class="form-control vfsVal"  data-id="communication" name="avoid_slangs" required>
												<option vfs_val=5 <?php echo $vfs_chat['avoid_slangs']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option vfs_val=5 <?php echo $vfs_chat['avoid_slangs']=='No'?"selected":""; ?> value="No">No</option>
												<option vfs_val=0 <?php echo $vfs_chat['avoid_slangs']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td id="score_avoid_slangs">5</td>
										<td><textarea class="form-control" name="comm17"><?php echo $vfs_chat['comm18'] ?></textarea></td>
									</tr>
									<tr>
										<td></td>
										<td colspan=1>e. Correct and accurate grammar usage / Avoid spelling mistakes</td>
										<td>6</td>
										<td>
											<select class="form-control vfsVal"  data-id="communication" name="correct_grammar_use" required>
												<option vfs_val=6 <?php echo $vfs_chat['correct_grammar_use']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option vfs_val=6 <?php echo $vfs_chat['correct_grammar_use']=='No'?"selected":""; ?> value="No">No</option>
												<option vfs_val=0 <?php echo $vfs_chat['correct_grammar_use']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td id="score_correct_grammar_use">6</td>
										<td><textarea class="form-control" name="comm18"><?php echo $vfs_chat['comm19'] ?></textarea></td>
									</tr>
									<tr>
										<td></td>
										<td colspan=1>f. Further assistance</td>
										<td>3</td>
										<td>
											<select class="form-control vfsVal"  data-id="communication" name="further_assistance" required>
												<option vfs_val=3 <?php echo $vfs_chat['further_assistance']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option vfs_val=3 <?php echo $vfs_chat['further_assistance']=='No'?"selected":""; ?> value="No">No</option>
												<option vfs_val=0 <?php echo $vfs_chat['further_assistance']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td id="score_further_assistance">3</td>
										<td><textarea class="form-control" name="comm19"><?php echo $vfs_chat['comm20'] ?></textarea></td>
									</tr>
									<tr>
										<td style="background-color:#BFC9CA"><b>7</b></td>
										<td colspan=1 style="background-color:#BFC9CA">Chat Closing</td>
										<td style="background-color:#BFC9CA">2</td>
										<td style="background-color:#BFC9CA"></td>
										<td style="background-color:#BFC9CA" id="score_chat-closing">2</td>
										<td style="background-color:#BFC9CA"></td>

									</tr>
									<tr>
										<td></td>
										<td colspan=1>a. Adherence to chat closing script</td>
										<td>2</td>
										<td>
											<select class="form-control vfsVal" data-id="closing" name="chat_adherence" required>
												<option vfs_val=2 <?php echo $vfs_chat['chat_adherence']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option vfs_val=2 <?php echo $vfs_chat['chat_adherence']=='No'?"selected":""; ?> value="No">No</option>
												<option vfs_val=0 <?php echo $vfs_chat['chat_adherence']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td id="score_chat_adherence">2</td>
										<td><textarea class="form-control" name="comm20"><?php echo $vfs_chat['comm21'] ?></textarea></td>
									</tr>
								
									<tr>
										<td style="background-color:#BFC9CA"><b>9</b></td>
										<td colspan=1 style="background-color:#BFC9CA">Fatal Parameter</td>
										<td style="background-color:#BFC9CA"></td>
										<td style="background-color:#BFC9CA"></td>
										<td style="background-color:#BFC9CA"></td>
										<td style="background-color:#BFC9CA"></td>
										
									</tr>
									<tr>
										<td></td>
										<td colspan=1 style="background-color:#D98880">a. Delayed opening</td>
										<td></td>
										<td>
											<select class="form-control vfsVal fatal_epi" id="chatAutof1" name="delayed_opening" required>
												<option vfs_val=0 <?php echo $vfs_chat['delayed_opening']=='No'?"selected":""; ?> value="No">No</option>
												<option vfs_val=0 <?php echo $vfs_chat['delayed_opening']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
											</select>
										</td>
										<td></td>
										<td><textarea class="form-control" name="comm22"><?php echo $vfs_chat['comm22'] ?></textarea></td>
									</tr>
									<tr>
										<td></td>
										<td colspan=1 style="background-color:#D98880">b. Rude on chat</td>
										<td></td>
										<td>
											<select class="form-control vfsVal fatal_epi" id="chatAutof2" name="rude_on_chat" required>
												<option vfs_val=0 <?php echo $vfs_chat['rude_on_chat']=='No'?"selected":""; ?> value="No">No</option>
												<option vfs_val=0 <?php echo $vfs_chat['rude_on_chat']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
											</select>
										</td>
										<td></td>
										<td><textarea class="form-control" name="comm23"><?php echo $vfs_chat['comm23'] ?></textarea></td>
									</tr>
									<tr>
										<td></td>
										<td colspan=1 style="background-color:#D98880">c. Inaccurate / Incomplete Information</td>
										<td></td>
										<td>
											<select class="form-control vfsVal fatal_epi" id="chatAutof3" name="inacurate_information" required>
												<option vfs_val=0 <?php echo $vfs_chat['inacurate_information']=='No'?"selected":""; ?> value="No">No</option>
												<option vfs_val=0 <?php echo $vfs_chat['inacurate_information']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
											</select>
										</td>
										<td></td>
										<td><textarea class="form-control" name="comm24"><?php echo $vfs_chat['comm24'] ?></textarea></td>
									</tr>
									<tr>
										<td></td>
										<td colspan=1 style="background-color:#D98880">d. Complaint Avoidance</td>
										<td></td>
										<td>
											<select class="form-control vfsVal fatal_epi" id="chatAutof4" name="complaint_avoidance" required>
												<option vfs_val=0 <?php echo $vfs_chat['complaint_avoidance']=='No'?"selected":""; ?> value="No">No</option>
												<option vfs_val=0 <?php echo $vfs_chat['complaint_avoidance']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
											</select>
										</td>
										<td></td>
										<td><textarea class="form-control" name="comm25"><?php echo $vfs_chat['comm25'] ?></textarea></td>
									</tr>
									<tr>
										<td>Reason For Fatal Error:</td>
										<td colspan=2><textarea class="form-control"  name="reason_for_fatal"><?php echo $vfs_chat['reason_for_fatal'] ?></textarea></td>
										<td>Improvement Area:</td>
										<td colspan=2><textarea class="form-control"  name="inprovement_area"><?php echo $vfs_chat['inprovement_area'] ?></textarea></td>
									</tr>
									<tr>
										<td>Chat Summary:</td>
										<td colspan=2><textarea class="form-control"  name="call_summary"><?php echo $vfs_chat['call_summary'] ?></textarea></td>
										<td>Feedback:</td>
										<td colspan=2><textarea class="form-control"  name="feedback"><?php echo $vfs_chat['feedback'] ?></textarea></td>
									</tr>
									<!-- <tr>
										<td colspan="2">Upload Files</td>
										<?php if($chat_id==0){ ?>
											<td colspan=4><input type="file" multiple class="form-control" id="attach_file" name="attach_file[]"></td>
										<?php }else{ 
											if($vfs_chat['attach_file']!=''){ ?>
											<td colspan="4">
												<?php $attach_file = explode(",",$vfs_chat['attach_file']);
												 foreach($attach_file as $mp){ ?>
													<audio controls='' style="background-color:#607F93"> 
													  <source src="<?php echo base_url(); ?>qa_files/qa_vfs/chat/<?php echo $mp; ?>" type="audio/ogg">
													  <source src="<?php echo base_url(); ?>qa_files/qa_vfs/chat/<?php echo $mp; ?>" type="audio/mpeg">
													</audio> </br>
												 <?php } ?>
											</td>
										<?php }else{
												echo '<td><b>No Files</b></td>';
											  }
										} ?>
									</tr> -->
										
									<?php if($chat_id!=0){ ?>
										<tr><td colspan=2 style="font-size:16px; font-weight:bold">Agent Review:</td><td colspan=4><?php echo $vfs_chat['agent_rvw_note'] ?></td></tr>
										<tr><td colspan=2 style="font-size:16px; font-weight:bold">Management Review:</td><td colspan=4><?php echo $vfs_chat['mgnt_rvw_note'] ?></td></tr>
										<tr><td colspan=2 style="font-size:16px; font-weight:bold">Client Review:</td><td colspan=4><?php echo $vfs_chat['client_rvw_note'] ?></td></tr>
										
										<tr><td colspan=2  style="font-size:16px">Your Review</td><td colspan=4><textarea class="form-control1" style="width:100%" id="note" name="note" required></textarea></td></tr>
									<?php } ?>
										
									<?php 
									if($chat_id==0){
										if(is_access_qa_module()==true || is_access_qa_operations_module()==true){ ?>
											<tr><td colspan=6><button class="btn btn-success waves-effect" type="submit" id="qaformsubmit" style="width:500px">SAVE</button></td></tr>
									<?php 
										} 
									}else{ 
										if(is_access_qa_module()==true || is_access_qa_operations_module()==true){
											if(is_available_qa_feedback($vfs_chat['entry_date'],72) == true){ ?>
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
