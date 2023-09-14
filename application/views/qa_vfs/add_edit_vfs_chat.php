
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

.ui-datepicker .ui-datepicker-buttonpane button.ui-datepicker-current {
	 float: left;
	 display: none;
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
										<td>QA Name:<span style="font-size:24px;color:red">*</span></td>
										<td style="width:300px"><input type="text" class="form-control" value="<?php echo $auditorName; ?>" disabled></td>
										<td style="width:150px">Audit Date:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control" value="<?php echo $auditDate; ?>" disabled></td>
										<td>Chat Date:<span style="font-size:24px;color:red">*</span></td>
										<td>
											
											<input type="text" class="form-control" id="call_date" name="call_date" onkeydown="return false;"  value="<?php echo $clDate_val; ?>" required>
										</td>
									</tr>
									<tr>
										<td>Agent Name:<span style="font-size:24px;color:red">*</span></td>
										<td>
											<select class="form-control" id="agent_id" name="agent_id" required>
												<?php 
												if($vfs_chat['agent_id']!=''){
													?>
													<option value="<?php echo $vfs_chat['agent_id'] ?>"><?php echo $vfs_chat['fname']." ".$vfs_chat['lname'] ?></option>
													<?php
												}
												?>
												
												<option value="">-Select-</option>
												<?php foreach($agentName as $row):  ?>
													<option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
												<?php endforeach; ?>
											</select>
										</td>
										<td>Fusion ID:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control" id="fusion_id" name="" value="<?php echo $vfs_chat['fusion_id']; ?>" readonly></td>
										<td>L1 Supervisor:<span style="font-size:24px;color:red">*</span></td>
										<td style="width:250px">
											<input type="text" class="form-control" id="tl_name"  value="<?php echo $vfs_chat['tl_name']; ?>" readonly>
												<input type="hidden" class="form-control" id="tl_id" name="tl_id" value="<?php echo $vfs_chat['tl_id'] ?>" required>
										</td>
									</tr>
									<tr>
										<td>Chat Duration:<span style="font-size:24px;color:red">*</span></td>
										<!-- <td><input type="text" class="form-control" id="call_duration" onkeydown="return false;" name="call_duration" value="<?php echo $vfs_chat['call_duration']; ?>" required></td> -->
										<td><input type="text" class="form-control" id=""  name="call_duration" value="<?php echo $vfs_chat['call_duration']; ?>" required></td>
										<td>Mission:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control"  name="mission" value="<?php echo $vfs_chat['mission']; ?>" required></td>
										<td>Recording ID:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control"  name="recording_id" value="<?php echo $vfs_chat['recording_id']; ?>" required></td>
									</tr>
									<tr>
										<td>Week:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control"  name="week" value="<?php echo $vfs_chat['week']; ?>" required></td>
										<td>Fatal Error?:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control" id="fatalspan3" name="autofail_status" value="<?php echo $vfs_chat['autofail_status']; ?>" readonly></td>

										<!-- <td>
											<select class="form-control" id="fatalspan3" name="autofail_status" required>
												<option value="">-Select-</option>
												<option <?php //echo $vfs_chat['autofail_status']=='Fatal'?"selected":""; ?> value="Fatal">Fatal</option>
												<option <?php //echo $vfs_chat['autofail_status']=='Non Fatal'?"selected":""; ?> value="Non Fatal">Non Fatal</option>
											</select>
										</td> -->
										<td>Host/Country:<span style="font-size:24px;color:red">*</span></td>
										<td>
											<select class="form-control" name="host_country" required>
												<option value=''>-Select-</option>
												<option <?php echo $vfs_chat['host_country']=='Philippines' ? 'selected' :'';  ?>  value='Philippines'>Philippines</option>
												<option <?php echo $vfs_chat['host_country']=='Australia' ? 'selected' :'';  ?>  value='Australia'>Australia</option>
												<option <?php echo $vfs_chat['host_country']=='New Zealand' ? 'selected' :'';  ?>  value='New Zealand'>New Zealand</option>
												<option <?php echo $vfs_chat['host_country']=='Singapore' ? 'selected' :'';  ?>  value='Singapore'>Singapore</option>
												<option <?php echo $vfs_chat['host_country']=='Thailand' ? 'selected' :'';  ?>  value='Thailand'>Thailand</option>
												<option <?php echo $vfs_chat['host_country']=='Indonesia' ? 'selected' :'';  ?>  value='Indonesia'>Indonesia</option>
												<option <?php echo $vfs_chat['host_country']=='Malaysia' ? 'selected' :'';  ?>  value='Malaysia'>Malaysia</option>
											</select>
										</td>
									</tr>
									<tr>
										<td>Agent Tenurity:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control" name="tenurity" id="tenure" value="<?php echo $vfs_chat['tenurity']; ?>" readonly></td>
										<td>VOC:<span style="font-size:24px;color:red">*</span></td>
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
										<td>ACPT:<span style="font-size:24px;color:red">*</span></td>
										<td>
												<select class="form-control" id="" name="acpt" required>
													<option value="">-Select-</option>
													<option value="Agent"  <?= ($vfs_chat['acpt']=="Agent")?"selected":"" ?>>Agent</option>
													<option value="Process"  <?= ($vfs_chat['acpt']=="Process")?"selected":"" ?>>Process</option>
													<option value="Customer"  <?= ($vfs_chat['acpt']=="Customer")?"selected":"" ?>>Customer</option>
													<option value="Technology"  <?= ($vfs_chat['acpt']=="Technology")?"selected":"" ?>>Technology</option>
													<option value="NA"  <?= ($vfs_chat['acpt']=="NA")?"selected":"" ?>>NA</option>
												</select>
											</td>
									</tr>
									<tr>
										<td>Audit Type:<span style="font-size:24px;color:red">*</span></td>
										<td>
											<select class="form-control" id="audit_type" name="audit_type" required>
												<option value="">-Select-</option>
												<option value="CQ Audit" <?= ($vfs_chat['audit_type']=="CQ Audit")?"selected":"" ?>>CQ Audit</option>
												<option value="BQ Audit" <?= ($vfs_chat['audit_type']=="BQ Audit")?"selected":"" ?>>BQ Audit</option>
												<option value="Calibration" <?= ($vfs_chat['audit_type']=="Calibration")?"selected":"" ?>>Calibration</option>
												<option value="Pre-Certificate Mock Call" <?= ($vfs_chat['audit_type']=="Pre-Certificate Mock Call")?"selected":"" ?>>Pre-Certificate Mock Call</option>
												<option value="Certification Audit" <?= ($vfs_chat['audit_type']=="Certification Audit")?"selected":"" ?>>Certification Audit</option>
												<option value="WoW Call"  <?= ($vfs_chat['audit_type']=="WoW Call")?"selected":"" ?>>WoW Call</option>
												<option value="Hygiene Audit"  <?= ($vfs_chat['audit_type']=="Hygiene Audit")?"selected":"" ?>>Hygiene Audit</option>
												<option value="Operation Audit"  <?= ($vfs_chat['audit_type']=="Operation Audit")?"selected":"" ?>>Operation Audit</option>
												<option value="Trainer Audit"  <?= ($vfs_chat['audit_type']=="Trainer Audit")?"selected":"" ?>>Trainer Audit</option> 
												<option value="QA Supervisor Audit"  <?= ($vfs_chat['audit_type']=="QA Supervisor Audit")?"selected":"" ?>>QA Supervisor Audit</option> 
											</select>
										</td>
										<td>L1:<span style="font-size:24px;color:red">*</span></td>
										<td>
											<select class="form-control" name="l1" required>
												<option value=''>-Select-</option>
												<option <?php echo $vfs_chat['l1']=='Application related' ? 'selected' :'';  ?>  value='Application related'>Application related</option>
												<option <?php echo $vfs_chat['l1']=='Appointment Related' ? 'selected' :'';  ?>  value='Appointment Related'>Appointment Related</option>
												<option <?php echo $vfs_chat['l1']=='Consulate Related' ? 'selected' :'';  ?>  value='Consulate Related'>Consulate Related</option>
												<option <?php echo $vfs_chat['l1']=='Courier Related' ? 'selected' :'';  ?>  value='Courier Related'>Courier Related</option>
												<option <?php echo $vfs_chat['l1']=='Customer Perception' ? 'selected' :'';  ?>  value='Customer Perception'>Customer Perception</option>
												<option <?php echo $vfs_chat['l1']=='Process Limitation' ? 'selected' :'';  ?>  value='Process Limitation'>Process Limitation</option>
												<option <?php echo $vfs_chat['l1']=='Process not followed' ? 'selected' :'';  ?>  value='Process not followed'>Process not followed</option>
												<option <?php echo $vfs_chat['l1']=='Soft Skills' ? 'selected' :'';  ?>  value='Soft Skills'>Soft Skills</option>
												<option <?php echo $vfs_chat['l1']=='Website Related' ? 'selected' :'';  ?>  value='Website Related'>Website Related</option>
												<option <?php echo $vfs_chat['l1']=='System Limitation' ? 'selected' :'';  ?>  value='System Limitation'>System Limitation</option>
												<option <?php echo $vfs_chat['l1']=='System Downtime' ? 'selected' :'';  ?>  value='System Downtime'>System Downtime</option>
												<option <?php echo $vfs_chat['l1']=='Knowledge Gap' ? 'selected' :'';  ?>  value='Knowledge Gap'>Knowledge Gap</option>
												<option <?php echo $vfs_chat['l1']=='Communication Gap' ? 'selected' :'';  ?>  value='Communication Gap'>Communication Gap</option>
												<option <?php echo $vfs_chat['l1']=='Skill Issue' ? 'selected' :'';  ?>  value='Skill Issue'>Skill Issue</option>
												<option <?php echo $vfs_chat['l1']=='Behavioral Issue' ? 'selected' :'';  ?>  value='Behavioral Issue'>Behavioral Issue</option>
											</select>
										</td>
										<td>L2:<span style="font-size:24px;color:red">*</span></td>
										<td>
											<select class="form-control" name="l2" required>
												<option value=''>-Select-</option>
												<option <?php echo $vfs_chat['l2']=='Application under process' ? 'selected' :'';  ?>  value='Application under process'>Application under process</option>
												<option <?php echo $vfs_chat['l2']=='Correct & Complete Information Provided' ? 'selected' :'';  ?>  value='Correct & Complete Information Provided'>Correct & Complete Information Provided</option>
												<option <?php echo $vfs_chat['l2']=='Delay in lodging' ? 'selected' :'';  ?>  value='Delay in lodging'>Delay in lodging</option>
												<option <?php echo $vfs_chat['l2']=='E - visa related' ? 'selected' :'';  ?>  value='E - visa related'>E - visa related</option>
												<option <?php echo $vfs_chat['l2']=='Incorrect Information provided' ? 'selected' :'';  ?>  value='Incorrect Information provided'>Incorrect Information provided</option>
												<option <?php echo $vfs_chat['l2']=='Lack of Attentiveness' ? 'selected' :'';  ?>  value='Lack of Attentiveness'>Lack of Attentiveness</option>
												<option <?php echo $vfs_chat['l2']=='Lack of courteous and professional' ? 'selected' :'';  ?>  value='Lack of courteous and professional'>Lack of courteous and professional</option>
												<option <?php echo $vfs_chat['l2']=='Not authorised to book an appointment' ? 'selected' :'';  ?>  value='Not authorised to book an appointment'>Not authorised to book an appointment</option>
												<option <?php echo $vfs_chat['l2']=='Not authorised to confirm the information' ? 'selected' :'';  ?>  value='Not authorised to confirm the information'>Not authorised to confirm the information</option>
												<option <?php echo $vfs_chat['l2']=='Other countries query' ? 'selected' :'';  ?>  value='Other countries query'>Other countries query</option>
												<option <?php echo $vfs_chat['l2']=='Passport not delivered' ? 'selected' :'';  ?>  value='Passport not delivered'>Passport not delivered</option>
												<option <?php echo $vfs_chat['l2']=='Slots not available' ? 'selected' :'';  ?>  value='Slots not available'>Slots not available</option>
												<option <?php echo $vfs_chat['l2']=='Unable to fill application form' ? 'selected' :'';  ?>  value='Unable to fill application form'>Unable to fill application form</option>
												<option <?php echo $vfs_chat['l2']=='Unable to login' ? 'selected' :'';  ?>  value='Unable to login'>Unable to login</option>
												<option <?php echo $vfs_chat['l2']=='Unable to reach the consulate' ? 'selected' :'';  ?>  value='Unable to reach the consulate'>Unable to reach the consulate</option>
												<option <?php echo $vfs_chat['l2']=='Process Query' ? 'selected' :'';  ?>  value='Process Query'>Process Query</option>
												<option <?php echo $vfs_chat['l2']=='Out of scope issues' ? 'selected' :'';  ?>  value='Out of scope issues'>Out of scope issues</option>
												<option <?php echo $vfs_chat['l2']=='CX is not aware that the information is available on the website' ? 'selected' :'';  ?>  value='CX is not aware that the information is available on the website'>CX is not aware that the information is available on the website</option>
												<option <?php echo $vfs_chat['l2']=='Agent needs to coordinate first with VAC for the information' ? 'selected' :'';  ?>  value='Agent needs to coordinate first with VAC for the information'>Agent needs to coordinate first with VAC for the information</option>
												<option <?php echo $vfs_chat['l2']=='Internet Issue' ? 'selected' :'';  ?>  value='Internet Issue'>Internet Issue</option>
												<option <?php echo $vfs_chat['l2']=='Hardware Issue' ? 'selected' :'';  ?>  value='Hardware Issue'>Hardware Issue</option>
												<option <?php echo $vfs_chat['l2']=='Tool/Software Inaccessible' ? 'selected' :'';  ?>  value='Tool/Software Inaccessible'>Tool/Software Inaccessible</option>
												<option <?php echo $vfs_chat['l2']=='Ineffective Training' ? 'selected' :'';  ?>  value='Ineffective Training'>Ineffective Training</option>
												<option <?php echo $vfs_chat['l2']=='Poor Retention' ? 'selected' :'';  ?>  value='Poor Retention'>Poor Retention</option>
												<option <?php echo $vfs_chat['l2']=='Poor update cascade' ? 'selected' :'';  ?>  value='Poor update cascade'>Poor update cascade</option>
												<option <?php echo $vfs_chat['l2']=='Language Barrier' ? 'selected' :'';  ?>  value='Language Barrier'>Language Barrier</option>
												<option <?php echo $vfs_chat['l2']=='Poor Comprehension' ? 'selected' :'';  ?>  value='Poor Comprehension'>Poor Comprehension</option>
												<option <?php echo $vfs_chat['l2']=='Poor Communication Skill' ? 'selected' :'';  ?>  value='Poor Communication Skill'>Poor Communication Skill</option>
												<option <?php echo $vfs_chat['l2']=='Poor Multi-tasking Skill' ? 'selected' :'';  ?>  value='Poor Multi-tasking Skill'>Poor Multi-tasking Skill</option>
											</select>
										</td>
									</tr>
									<tr>
										<td class="auType">Auditor Type<span style="font-size:24px;color:red">*</span></td>
										<td class="auType">
											<select class="form-control" id="auditor_type" name="auditor_type">
												<option value="">-Select-</option>
												 <option value="Master" <?= ($vfs_chat['auditor_type']=="Master")?"selected":"" ?>>Master</option> 
												 <option value="Regular" <?= ($vfs_chat['auditor_type']=="Regular")?"selected":"" ?>>Regular</option> 
											</select>
										</td>
									</tr>
									<tr>
										<td style="font-weight:bold">Earned Score:</td>
										<td><input type="text" readonly id="vfsEarned" name="earned_score" class="form-control" style="font-weight:bold" value="<?php echo $vfs_chat['overall_score'] ?>"></td>
										<td style="font-weight:bold">Possible Score:</td>
										<td><input type="text" readonly id="vfsPossible" name="possible_score" class="form-control" style="font-weight:bold" value="<?php echo $vfs_chat['overall_score'] ?>"></td>
										<td style="font-weight:bold">Overall Score Percentage:</td>
										<td><input type="text" readonly id="vfsOverallScore" name="overall_score" class="form-control vfsChatFatal" style="font-weight:bold" value="<?php if($vfs_chat['overall_score']){ echo $vfs_chat['overall_score']; } else { echo '0.00'.'%'; } ?>"></td>
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
												<option vfs_val=4 vfs_max="4" <?php echo $vfs_chat['appropiate_greeting']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option vfs_val=0 vfs_max="4" <?php echo $vfs_chat['appropiate_greeting']=='No'?"selected":""; ?> value="No">No</option>
												<option vfs_val=0 vfs_max="4" <?php echo $vfs_chat['appropiate_greeting']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td id="score_appropiate_greeting">4</td>
										<td><textarea class="form-control" name="comm0"><?php echo $vfs_chat['comm0'] ?></textarea></td>
									</tr>
									<tr>
										<td style="background-color:#BFC9CA"><b>2</b></td>
										<td colspan=1 style="background-color:#BFC9CA">Technical aspects</td>
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
												<option vfs_val=5 vfs_max="5" <?php echo $vfs_chat['response_time']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option vfs_val=0 vfs_max="5" <?php echo $vfs_chat['response_time']=='No'?"selected":""; ?> value="No">No</option>
												<option vfs_val=0 vfs_max="5" <?php echo $vfs_chat['response_time']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
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
												<option vfs_val=5 vfs_max="5" <?php echo $vfs_chat['FCR_achieved']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option vfs_val=0 vfs_max="5" <?php echo $vfs_chat['FCR_achieved']=='No'?"selected":""; ?> value="No">No</option>
												<option vfs_val=0 vfs_max="5" <?php echo $vfs_chat['FCR_achieved']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
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
												<option vfs_val=4 vfs_max="4" <?php echo $vfs_chat['accurate_information']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option vfs_val=0 vfs_max="4" <?php echo $vfs_chat['accurate_information']=='No'?"selected":""; ?> value="No">No</option>
												<option vfs_val=0 vfs_max="4" <?php echo $vfs_chat['accurate_information']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td id="score_accurate_information">4</td>
										<td><textarea class="form-control" name="comm3"><?php echo $vfs_chat['comm3'] ?></textarea></td>
									</tr>
									<tr>
										<td></td>
										<td colspan=1>d. Understand the issue of the applicant & Attentiveness displayed</td>
										<td>9</td>
										<td>
											<select class="form-control vfsVal"  data-id="technical_aspects" name="understand_issue" required>
												<!-- <option value="">-Select-</option> -->
												<option vfs_val=9 vfs_max="9" <?php echo $vfs_chat['understand_issue']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option vfs_val=0 vfs_max="9" <?php echo $vfs_chat['understand_issue']=='No'?"selected":""; ?> value="No">No</option>
												<option vfs_val=0 vfs_max="9" <?php echo $vfs_chat['understand_issue']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td id="score_understand_issue">9</td>
										<td><textarea class="form-control" name="comm4"><?php echo $vfs_chat['comm4'] ?></textarea></td>
									</tr>
								
									<tr>
										<td></td>
										<td colspan=1>e.Paraphrasing</td>
										<td>5</td>
										<td>
											<select class="form-control vfsVal"  data-id="technical_aspects" name="paraphrasing" required>
												<!-- <option value="">-Select-</option> -->
												<option vfs_val=5 vfs_max="5" <?php echo $vfs_chat['paraphrasing']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option vfs_val=0 vfs_max="5" <?php echo $vfs_chat['paraphrasing']=='No'?"selected":""; ?> value="No">No</option>
												<option vfs_val=0 vfs_max="5" <?php echo $vfs_chat['paraphrasing']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td id="score_paraphrasing">5</td>
										<td><textarea class="form-control" name="comm6"><?php echo $vfs_chat['comm6'] ?></textarea></td>
									</tr>
									<tr>
										<td></td>
										<td colspan=1>f. Used all the available resources for providing resolution</td>
										<td>5</td>
										<td>
											<select class="form-control vfsVal"  data-id="technical_aspects" name="use_available_resource" required>
												<!-- <option value="">-Select-</option> -->
												<option vfs_val=5 vfs_max="5" <?php echo $vfs_chat['use_available_resource']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option vfs_val=0 vfs_max="5" <?php echo $vfs_chat['use_available_resource']=='No'?"selected":""; ?> value="No">No</option>
												<option vfs_val=0 vfs_max="5" <?php echo $vfs_chat['use_available_resource']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td id="score_use_available_resource">5</td>
										<td><textarea class="form-control" name="comm7"><?php echo $vfs_chat['comm7'] ?></textarea></td>
									</tr>
									<tr>
										<td></td>
										<td colspan=1>g. Appropriate Probing</td>
										<td>5</td>
										<td>
											<select class="form-control vfsVal"  data-id="technical_aspects" name="appropiate_probing" required>
												<!-- <option value="">-Select-</option> -->
												<option vfs_val=5 vfs_max="5" <?php echo $vfs_chat['appropiate_probing']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option vfs_val=0 vfs_max="5" <?php echo $vfs_chat['appropiate_probing']=='No'?"selected":""; ?> value="No">No</option>
												<option vfs_val=0 vfs_max="5" <?php echo $vfs_chat['appropiate_probing']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td id="score_appropiate_probing">5</td>
										<td><textarea class="form-control" name="comm8"><?php echo $vfs_chat['comm8'] ?></textarea></td>
									</tr>
									<tr>
										<td style="background-color:#BFC9CA"><b>3</b></td>
										<td colspan=1 style="background-color:#BFC9CA">Additions</td>
										<td style="background-color:#BFC9CA">17</td>
										<td style="background-color:#BFC9CA"></td>
										<td style="background-color:#BFC9CA" id="score_additions">17</td>
										<td style="background-color:#BFC9CA"></td>
									</tr>
									<tr>
										<td></td>
										<td colspan=1>a. Offers VAS options wherever applicable</td>
										<td>10</td>
										<td>
											<select class="form-control vfsVal"  data-id="additions" name="VAS_options" required>
												<option vfs_val=10 vfs_max="10" <?php echo $vfs_chat['VAS_options']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option vfs_val=0 vfs_max="10" <?php echo $vfs_chat['VAS_options']=='No'?"selected":""; ?> value="No">No</option>
												<option vfs_val=0 vfs_max="10" <?php echo $vfs_chat['VAS_options']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td id="score_VAS_options">10</td>
										<td><textarea class="form-control" name="comm9"><?php echo $vfs_chat['comm9'] ?></textarea></td>
									</tr>
									<tr>
										<td></td>
										<td colspan=1>b. Awareness created with regards to VFS website (wherever applicable)</td>
										<td>7</td>
										<td>
											<select class="form-control vfsVal"  data-id="additions" name="awareness_created" required>
												<option vfs_val=7 vfs_max="7" <?php echo $vfs_chat['awareness_created']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option vfs_val=0 vfs_max="7" <?php echo $vfs_chat['awareness_created']=='No'?"selected":""; ?> value="No">No</option>
												<option vfs_val=0 vfs_max="7" <?php echo $vfs_chat['awareness_created']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td id="score_awareness_created">7</td>
										<td><textarea class="form-control" name="comm10"><?php echo $vfs_chat['comm10'] ?></textarea></td>
									</tr>
									
									<tr>
										<td style="background-color:#BFC9CA"><b>4</b></td>
										<td colspan=1 style="background-color:#BFC9CA">Documentation</td>
										<td style="background-color:#BFC9CA">5</td>
										<td style="background-color:#BFC9CA"></td>
										<td style="background-color:#BFC9CA" id="score_documentation">5</td>
										<td style="background-color:#BFC9CA"></td>
									</tr>
									<tr>
										<td></td>
										<td colspan=1>a. Correct dispostion</td>
										<td>5</td>
										<td>
											<select class="form-control vfsVal"  data-id="documentation" name="correct_disposition" required>
												<option vfs_val=5 vfs_max="5" <?php echo $vfs_chat['correct_disposition']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option vfs_val=0 vfs_max="5" <?php echo $vfs_chat['correct_disposition']=='No'?"selected":""; ?> value="No">No</option>
												<option vfs_val=0 vfs_max="5" <?php echo $vfs_chat['correct_disposition']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td id="score_correct_disposition">5</td>
										<td><textarea class="form-control" name="comm11"><?php echo $vfs_chat['comm11'] ?></textarea></td>
									</tr>
									
									<tr>
										<td style="background-color:#BFC9CA"><b>5</b></td>
										<td colspan=1 style="background-color:#BFC9CA">Hold Protocol</td>
										<td style="background-color:#BFC9CA">5</td>
										<td style="background-color:#BFC9CA"></td>
										<td style="background-color:#BFC9CA" id="score_hold_protocol">5</td>
										<td style="background-color:#BFC9CA"></td>

									</tr>
									<tr>
										<td></td>
										<td colspan=1>a. Was Hold Required & Hold guidelines following</td>
										<td>5</td>
										<td>
											<select class="form-control vfsVal"  data-id="hold_protocol" name="hold_required" required>
												<option vfs_val=5 vfs_max="5" <?php echo $vfs_chat['hold_required']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option vfs_val=0 vfs_max="5" <?php echo $vfs_chat['hold_required']=='No'?"selected":""; ?> value="No">No</option>
												<option vfs_val=0 vfs_max="5" <?php echo $vfs_chat['hold_required']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td id="score_hold_required">5</td>
										<td><textarea class="form-control" name="comm13"><?php echo $vfs_chat['comm13'] ?></textarea></td>
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
												<option vfs_val=5 vfs_max="5" <?php echo $vfs_chat['formatting']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option vfs_val=0 vfs_max="5" <?php echo $vfs_chat['formatting']=='No'?"selected":""; ?> value="No">No</option>
												<option vfs_val=0 vfs_max="5" <?php echo $vfs_chat['formatting']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td id="score_formatting">5</td>
										<td><textarea class="form-control" name="comm15"><?php echo $vfs_chat['comm15'] ?></textarea></td>
									</tr>
									<tr>
										<td></td>
										<td colspan=1>b. Avoid Negative statements</td>
										<td>5</td>
										<td>
											<select class="form-control vfsVal"  data-id="communication" name="avoid_negative_statement" required>
												<option vfs_val=5 vfs_max="5" <?php echo $vfs_chat['avoid_negative_statement']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option vfs_val=0 vfs_max="5" <?php echo $vfs_chat['avoid_negative_statement']=='No'?"selected":""; ?> value="No">No</option>
												<option vfs_val=0 vfs_max="5" <?php echo $vfs_chat['avoid_negative_statement']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td id="score_avoid_negative_statement">5</td>
										<td><textarea class="form-control" name="comm16"><?php echo $vfs_chat['comm16'] ?></textarea></td>
									</tr>
									<tr>
										<td></td>
										<td colspan=1>c. Telling the customer what to do next, Step by step procedure guide</td>
										<td>5</td>
										<td>
											<select class="form-control vfsVal"  data-id="communication" name="procedure_guide_step" required>
												<option vfs_val=5 vfs_max="5" <?php echo $vfs_chat['procedure_guide_step']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option vfs_val=0 vfs_max="5" <?php echo $vfs_chat['procedure_guide_step']=='No'?"selected":""; ?> value="No">No</option>
												<option vfs_val=0 vfs_max="5" <?php echo $vfs_chat['procedure_guide_step']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td id="score_procedure_guide_step">5</td>
										<td><textarea class="form-control" name="comm17"><?php echo $vfs_chat['comm17'] ?></textarea></td>
									</tr>
									<tr>
										<td></td>
										<td colspan=1>d. Avoid Slangs & Jargons</td>
										<td>5</td>
										<td>
											<select class="form-control vfsVal"  data-id="communication" name="avoid_slangs" required>
												<option vfs_val=5 vfs_max="5" <?php echo $vfs_chat['avoid_slangs']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option vfs_val=0 vfs_max="5" <?php echo $vfs_chat['avoid_slangs']=='No'?"selected":""; ?> value="No">No</option>
												<option vfs_val=0 vfs_max="5" <?php echo $vfs_chat['avoid_slangs']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td id="score_avoid_slangs">5</td>
										<td><textarea class="form-control" name="comm18"><?php echo $vfs_chat['comm18'] ?></textarea></td>
									</tr>
									<tr>
										<td></td>
										<td colspan=1>e. Correct and accurate grammar usage / Avoid spelling mistakes</td>
										<td>6</td>
										<td>
											<select class="form-control vfsVal"  data-id="communication" name="correct_grammar_use" required>
												<option vfs_val=6 vfs_max="6" <?php echo $vfs_chat['correct_grammar_use']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option vfs_val=0 vfs_max="6" <?php echo $vfs_chat['correct_grammar_use']=='No'?"selected":""; ?> value="No">No</option>
												<option vfs_val=0 vfs_max="6" <?php echo $vfs_chat['correct_grammar_use']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td id="score_correct_grammar_use">6</td>
										<td><textarea class="form-control" name="comm19"><?php echo $vfs_chat['comm19'] ?></textarea></td>
									</tr>
									<tr>
										<td></td>
										<td colspan=1>f. Further assistance</td>
										<td>3</td>
										<td>
											<select class="form-control vfsVal"  data-id="communication" name="further_assistance" required>
												<option vfs_val=3 vfs_max="3" <?php echo $vfs_chat['further_assistance']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option vfs_val=0 vfs_max="3" <?php echo $vfs_chat['further_assistance']=='No'?"selected":""; ?> value="No">No</option>
												<option vfs_val=0 vfs_max="3" <?php echo $vfs_chat['further_assistance']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td id="score_further_assistance">3</td>
										<td><textarea class="form-control" name="comm20"><?php echo $vfs_chat['comm20'] ?></textarea></td>
									</tr>
									<tr>
										<td style="background-color:#BFC9CA"><b>7</b></td>
										<td colspan=1 style="background-color:#BFC9CA">Chat Closing</td>
										<td style="background-color:#BFC9CA">2</td>
										<td style="background-color:#BFC9CA"></td>
										<td style="background-color:#BFC9CA" id="score_closing">2</td>
										<td style="background-color:#BFC9CA"></td>

									</tr>
									<tr>
										<td></td>
										<td colspan=1>a. Adherence to chat closing script</td>
										<td>2</td>
										<td>
											<select class="form-control vfsVal" data-id="closing" name="chat_adherence" required>
												<option vfs_val=2 vfs_max="2" <?php echo $vfs_chat['chat_adherence']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option vfs_val=0 vfs_max="2" <?php echo $vfs_chat['chat_adherence']=='No'?"selected":""; ?> value="No">No</option>
												<option vfs_val=0 vfs_max="2"<?php echo $vfs_chat['chat_adherence']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td id="score_chat_adherence">2</td>
										<td><textarea class="form-control" name="comm21"><?php echo $vfs_chat['comm21'] ?></textarea></td>
									</tr>
								
									<tr>
										<td style="background-color:#BFC9CA"><b>8</b></td>
										<td colspan=1 style="background-color:#BFC9CA">Fatal Parameters</td>
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
												<option vfs_val=0 vfs_max=0 <?php echo $vfs_chat['delayed_opening']=='No'?"selected":""; ?> value="No">No</option>
												<option vfs_val=0 vfs_max=0 <?php echo $vfs_chat['delayed_opening']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
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
												<option vfs_val=0 vfs_max=0 <?php echo $vfs_chat['rude_on_chat']=='No'?"selected":""; ?> value="No">No</option>
												<option vfs_val=0 vfs_max=0 <?php echo $vfs_chat['rude_on_chat']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
											</select>
										</td>
										<td></td>
										<td><textarea class="form-control" name="comm23"><?php echo $vfs_chat['comm23'] ?></textarea></td>
									</tr>
									<tr>
										<td></td>
										<td colspan=1 style="background-color:#D98880">c. Incomplete/Inaccurate Information shared</td>
										<td></td>
										<td>
											<select class="form-control vfsVal fatal_epi" id="chatAutof3" name="inacurate_information" required>
												<option vfs_val=0 vfs_max=0 <?php echo $vfs_chat['inacurate_information']=='No'?"selected":""; ?> value="No">No</option>
												<option vfs_val=0 vfs_max=0 <?php echo $vfs_chat['inacurate_information']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
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
												<option vfs_val=0 vfs_max=0 <?php echo $vfs_chat['complaint_avoidance']=='No'?"selected":""; ?> value="No">No</option>
												<option vfs_val=0 vfs_max=0 <?php echo $vfs_chat['complaint_avoidance']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
											</select>
										</td>
										<td></td>
										<td><textarea class="form-control" name="comm25"><?php echo $vfs_chat['comm25'] ?></textarea></td>
									</tr>
									<tr>
										<td style="background-color:#BFC9CA"><b>9</b></td>
										<td colspan=1 style="background-color:#BFC9CA">First Time Resolution (FTR)</td>
										<td style="background-color:#BFC9CA"></td>
										<td style="background-color:#BFC9CA"></td>
										<td style="background-color:#BFC9CA"></td>
										<td style="background-color:#BFC9CA"></td>
										
									</tr>
									<tr>
										<td></td>
										<td colspan=1>a. Disposition</td>
										<td></td>
										<td>
											<select class="form-control" name="comm32" >
												<option value=''>-Select-</option>
												<option <?php echo $vfs_chat['comm32']=='Additional Documents asked by the Embassy/consulate'?'selected':''; ?> value='Additional Documents asked by the Embassy/consulate'>Additional Documents asked by the Embassy/consulate</option>
												<option <?php echo $vfs_chat['comm32']=='Agent'?'selected':''; ?> value='Agent'>Agent</option>
												<option <?php echo $vfs_chat['comm32']=='Appeal Procedure'?'selected':''; ?> value='Appeal Procedure'>Appeal Procedure</option>
												<option <?php echo $vfs_chat['comm32']=='Applicant'?'selected':''; ?> value='Applicant'>Applicant</option>
												<option <?php echo $vfs_chat['comm32']=='Applicant Requested'?'selected':''; ?> value='Applicant Requested'>Applicant Requested</option>
												<option <?php echo $vfs_chat['comm32']=='Application Form Filling'?'selected':''; ?> value='Application Form Filling'>Application Form Filling</option>
												<option <?php echo $vfs_chat['comm32']=='Appointment re-confirmation'?'selected':''; ?> value='Appointment re-confirmation'>Appointment re-confirmation</option>
												<option <?php echo $vfs_chat['comm32']=='Approval letter'?'selected':''; ?> value='Approval letter'>Approval letter</option>
												<option <?php echo $vfs_chat['comm32']=='AWB'?'selected':''; ?> value='AWB'>AWB</option>
												<option <?php echo $vfs_chat['comm32']=='AWB Not Generated'?'selected':''; ?> value='AWB Not Generated'>AWB Not Generated</option>
												<option <?php echo $vfs_chat['comm32']=='Biometrics'?'selected':''; ?> value='Biometrics'>Biometrics</option>
												<option <?php echo $vfs_chat['comm32']=='Blank call'?'selected':''; ?> value='Blank call'>Blank call</option>
												<option <?php echo $vfs_chat['comm32']=='Call Connected'?'selected':''; ?> value='Call Connected'>Call Connected</option>
												<option <?php echo $vfs_chat['comm32']=='Call not answered'?'selected':''; ?> value='Call not answered'>Call not answered</option>
												<option <?php echo $vfs_chat['comm32']=='Cancellation'?'selected':''; ?> value='Cancellation'>Cancellation</option>
												<option <?php echo $vfs_chat['comm32']=='Check and Verify'?'selected':''; ?> value='Check and Verify'>Check and Verify</option>
												<option <?php echo $vfs_chat['comm32']=='Collection timing'?'selected':''; ?> value='Collection timing'>Collection timing</option>
												<option <?php echo $vfs_chat['comm32']=='Consulate Details'?'selected':''; ?> value='Consulate Details'>Consulate Details</option>
												<option <?php echo $vfs_chat['comm32']=='Counter Collection'?'selected':''; ?> value='Counter Collection'>Counter Collection</option>
												<option <?php echo $vfs_chat['comm32']=='Courier'?'selected':''; ?> value='Courier'>Courier</option>
												<option <?php echo $vfs_chat['comm32']=='Courier Assurance'?'selected':''; ?> value='Courier Assurance'>Courier Assurance</option>
												<option <?php echo $vfs_chat['comm32']=='Dispositon'?'selected':''; ?> value='Dispositon'>Dispositon</option>
												<option <?php echo $vfs_chat['comm32']=='Documentation'?'selected':''; ?> value='Documentation'>Documentation</option>
												<option <?php echo $vfs_chat['comm32']=='Documentation - Checklist'?'selected':''; ?> value='Documentation - Checklist'>Documentation - Checklist</option>
												<option <?php echo $vfs_chat['comm32']=='Documentation - supporting docs'?'selected':''; ?> value='Documentation - supporting docs'>Documentation - supporting docs</option>
												<option <?php echo $vfs_chat['comm32']=='Documents attestation'?'selected':''; ?> value='Documents attestation'>Documents attestation</option>
												<option <?php echo $vfs_chat['comm32']=='Embassy Submission'?'selected':''; ?> value='Embassy Submission'>Embassy Submission</option>
												<option <?php echo $vfs_chat['comm32']=='Embassy Website'?'selected':''; ?> value='Embassy Website'>Embassy Website</option>
												<option <?php echo $vfs_chat['comm32']=='Error Faced while booking an appoitment'?'selected':''; ?> value='Error Faced while booking an appoitment'>Error Faced while booking an appoitment</option>
												<option <?php echo $vfs_chat['comm32']=='Existing appointment - Did not rec the letter/confirmation'?'selected':''; ?> value='Existing appointment - Did not rec the letter/confirmation'>Existing appointment - Did not rec the letter/confirmation</option>
												<option <?php echo $vfs_chat['comm32']=='Fees'?'selected':''; ?> value='Fees'>Fees</option>
												<option <?php echo $vfs_chat['comm32']=='Finance'?'selected':''; ?> value='Finance'>Finance</option>
												<option <?php echo $vfs_chat['comm32']=='Follow Up Call'?'selected':''; ?> value='Follow Up Call'>Follow Up Call</option>
												<option <?php echo $vfs_chat['comm32']=='Insurance'?'selected':''; ?> value='Insurance'>Insurance</option>
												<option <?php echo $vfs_chat['comm32']=='Interview letter'?'selected':''; ?> value='Interview letter'>Interview letter</option>
												<option <?php echo $vfs_chat['comm32']=='Interview process'?'selected':''; ?> value='Interview process'>Interview process</option>
												<option <?php echo $vfs_chat['comm32']=='Job Related'?'selected':''; ?> value='Job Related'>Job Related</option>
												<option <?php echo $vfs_chat['comm32']=='Holidays and working hours - Mission and VAC'?'selected':''; ?> value='Holidays and working hours - Mission and VAC'>Holidays and working hours - Mission and VAC</option>
												<option <?php echo $vfs_chat['comm32']=='Legalization procedure'?'selected':''; ?> value='Legalization procedure'>Legalization procedure</option>
												<option <?php echo $vfs_chat['comm32']=='Logistic Website'?'selected':''; ?> value='Logistic Website'>Logistic Website</option>
												<option <?php echo $vfs_chat['comm32']=='Logistic Website Issue'?'selected':''; ?> value='Logistic Website Issue'>Logistic Website Issue</option>
												<option <?php echo $vfs_chat['comm32']=='Manager'?'selected':''; ?> value='Manager'>Manager</option>
												<option <?php echo $vfs_chat['comm32']=='Marketing'?'selected':''; ?> value='Marketing'>Marketing</option>
												<option <?php echo $vfs_chat['comm32']=='Mea'?'selected':''; ?> value='Mea'>Mea</option>
												<option <?php echo $vfs_chat['comm32']=='Mea - Attestation services'?'selected':''; ?> value='Mea - Attestation services'>Mea - Attestation services</option>
												<option <?php echo $vfs_chat['comm32']=='MEA Fees'?'selected':''; ?> value='MEA Fees'>MEA Fees</option>
												<option <?php echo $vfs_chat['comm32']=='New Appointment - Attestation'?'selected':''; ?> value='New Appointment - Attestation'>New Appointment - Attestation</option>
												<option <?php echo $vfs_chat['comm32']=='New Appointment - CC to book'?'selected':''; ?> value='New Appointment - CC to book'>New Appointment - CC to book</option>
												<option <?php echo $vfs_chat['comm32']=='New Appointment - How to book'?'selected':''; ?> value='New Appointment - How to book'>New Appointment - How to book</option>
												<option <?php echo $vfs_chat['comm32']=='New Appointment - Slots not available'?'selected':''; ?> value='New Appointment - Slots not available'>New Appointment - Slots not available</option>
												<option <?php echo $vfs_chat['comm32']=='New Appointment - Where to book'?'selected':''; ?> value='New Appointment - Where to book'>New Appointment - Where to book</option>
												<option <?php echo $vfs_chat['comm32']=='Non Deliverable Address'?'selected':''; ?> value='Non Deliverable Address'>Non Deliverable Address</option>
												<option <?php echo $vfs_chat['comm32']=='Non VFS mission related'?'selected':''; ?> value='Non VFS mission related'>Non VFS mission related</option>
												<option <?php echo $vfs_chat['comm32']=='Not In Scope'?'selected':''; ?> value='Not In Scope'>Not In Scope</option>
												<option <?php echo $vfs_chat['comm32']=='Nulla Osta Query'?'selected':''; ?> value='Nulla Osta Query'>Nulla Osta Query</option>
												<option <?php echo $vfs_chat['comm32']=='Number Unreachable'?'selected':''; ?> value='Number Unreachable'>Number Unreachable</option>
												<option <?php echo $vfs_chat['comm32']=='Other countries helpline number'?'selected':''; ?> value='Other countries helpline number'>Other countries helpline number</option>
												<option <?php echo $vfs_chat['comm32']=='Others'?'selected':''; ?> value='Others'>Others</option>
												<option <?php echo $vfs_chat['comm32']=='Outside SPT'?'selected':''; ?> value='Outside SPT'>Outside SPT</option>
												<option <?php echo $vfs_chat['comm32']=='Passport & Document Submission'?'selected':''; ?> value='Passport & Document Submission'>Passport & Document Submission</option>
												<option <?php echo $vfs_chat['comm32']=='Passport services'?'selected':''; ?> value='Passport services'>Passport services</option>
												<option <?php echo $vfs_chat['comm32']=='Payment Methods'?'selected':''; ?> value='Payment Methods'>Payment Methods</option>
												<option <?php echo $vfs_chat['comm32']=='PL'?'selected':''; ?> value='PL'>PL</option>
												<option <?php echo $vfs_chat['comm32']=='PL Booked but not provided'?'selected':''; ?> value='PL Booked but not provided'>PL Booked but not provided</option>
												<option <?php echo $vfs_chat['comm32']=='Postal pick-up'?'selected':''; ?> value='Postal pick-up'>Postal pick-up</option>
												<option <?php echo $vfs_chat['comm32']=='Postpone interviews'?'selected':''; ?> value='Postpone interviews'>Postpone interviews</option>
												<option <?php echo $vfs_chat['comm32']=='PP Hold Request'?'selected':''; ?> value='PP Hold Request'>PP Hold Request</option>
												<option <?php echo $vfs_chat['comm32']=='Pre Payments'?'selected':''; ?> value='Pre Payments'>Pre Payments</option>
												<option <?php echo $vfs_chat['comm32']=='Prime time services'?'selected':''; ?> value='Prime time services'>Prime time services</option>
												<option <?php echo $vfs_chat['comm32']=='Privilege'?'selected':''; ?> value='Privilege'>Privilege</option>
												<option <?php echo $vfs_chat['comm32']=='Processing Time'?'selected':''; ?> value='Processing Time'>Processing Time</option>
												<option <?php echo $vfs_chat['comm32']=='Reference Number Not Generated'?'selected':''; ?> value='Reference Number Not Generated'>Reference Number Not Generated</option>
												<option <?php echo $vfs_chat['comm32']=='Reschedule'?'selected':''; ?> value='Reschedule'>Reschedule</option>
												<option <?php echo $vfs_chat['comm32']=='Resubmission of passport'?'selected':''; ?> value='Resubmission of passport'>Resubmission of passport</option>
												<option <?php echo $vfs_chat['comm32']=='Routed to correct mission helpline'?'selected':''; ?> value='Routed to correct mission helpline'>Routed to correct mission helpline</option>
												<option <?php echo $vfs_chat['comm32']=='Scanning Issue'?'selected':''; ?> value='Scanning Issue'>Scanning Issue</option>
												<option <?php echo $vfs_chat['comm32']=='Security procedure at VFS centre'?'selected':''; ?> value='Security procedure at VFS centre'>Security procedure at VFS centre</option>
												<option <?php echo $vfs_chat['comm32']=='Service Charge deducted twice'?'selected':''; ?> value='Service Charge deducted twice'>Service Charge deducted twice</option>
												<option <?php echo $vfs_chat['comm32']=='Service Inadequate'?'selected':''; ?> value='Service Inadequate'>Service Inadequate</option>
												<option <?php echo $vfs_chat['comm32']=='Service issue at VAC'?'selected':''; ?> value='Service issue at VAC'>Service issue at VAC</option>
												<option <?php echo $vfs_chat['comm32']=='Services '?'selected':''; ?> value='Services '>Services </option>
												<option <?php echo $vfs_chat['comm32']=='SMS Issue'?'selected':''; ?> value='SMS Issue'>SMS Issue</option>
												<option <?php echo $vfs_chat['comm32']=='SMS Issue due to wrong PI'?'selected':''; ?> value='SMS Issue due to wrong PI'>SMS Issue due to wrong PI</option>
												<option <?php echo $vfs_chat['comm32']=='SMS service'?'selected':''; ?> value='SMS service'>SMS service</option>
												<option <?php echo $vfs_chat['comm32']=='Staff'?'selected':''; ?> value='Staff'>Staff</option>
												<option <?php echo $vfs_chat['comm32']=='Student demand draft'?'selected':''; ?> value='Student demand draft'>Student demand draft</option>
												<option <?php echo $vfs_chat['comm32']=='Student Questioner'?'selected':''; ?> value='Student Questioner'>Student Questioner</option>
												<option <?php echo $vfs_chat['comm32']=='Submission process'?'selected':''; ?> value='Submission process'>Submission process</option>
												<option <?php echo $vfs_chat['comm32']=='Submission Timing'?'selected':''; ?> value='Submission Timing'>Submission Timing</option>
												<option <?php echo $vfs_chat['comm32']=='Supervisor'?'selected':''; ?> value='Supervisor'>Supervisor</option>
												<option <?php echo $vfs_chat['comm32']=='Test Call'?'selected':''; ?> value='Test Call'>Test Call</option>
												<option <?php echo $vfs_chat['comm32']=='Transfer to MEA'?'selected':''; ?> value='Transfer to MEA'>Transfer to MEA</option>
												<option <?php echo $vfs_chat['comm32']=='Unable to download appointment letter'?'selected':''; ?> value='Unable to download appointment letter'>Unable to download appointment letter</option>
												<option <?php echo $vfs_chat['comm32']=='Unable to login'?'selected':''; ?> value='Unable to login'>Unable to login</option>
												<option <?php echo $vfs_chat['comm32']=='Unable to track application'?'selected':''; ?> value='Unable to track application'>Unable to track application</option>
												<option <?php echo $vfs_chat['comm32']=='VAC'?'selected':''; ?> value='VAC'>VAC</option>
												<option <?php echo $vfs_chat['comm32']=='VAC Requested'?'selected':''; ?> value='VAC Requested'>VAC Requested</option>
												<option <?php echo $vfs_chat['comm32']=='VAYD'?'selected':''; ?> value='VAYD'>VAYD</option>
												<option <?php echo $vfs_chat['comm32']=='VAYD booked but service not provided'?'selected':''; ?> value='VAYD booked but service not provided'>VAYD booked but service not provided</option>
												<option <?php echo $vfs_chat['comm32']=='VFS centre Address details'?'selected':''; ?> value='VFS centre Address details'>VFS centre Address details</option>
												<option <?php echo $vfs_chat['comm32']=='VFS Charges'?'selected':''; ?> value='VFS Charges'>VFS Charges</option>
												<option <?php echo $vfs_chat['comm32']=='VFS Website'?'selected':''; ?> value='VFS Website'>VFS Website</option>
												<option <?php echo $vfs_chat['comm32']=='VFS Website Issue'?'selected':''; ?> value='VFS Website Issue'>VFS Website Issue</option>
												<option <?php echo $vfs_chat['comm32']=='VFS Website not updated'?'selected':''; ?> value='VFS Website not updated'>VFS Website not updated</option>
												<option <?php echo $vfs_chat['comm32']=='Visa cancellation'?'selected':''; ?> value='Visa cancellation'>Visa cancellation</option>
												<option <?php echo $vfs_chat['comm32']=='Visa Category'?'selected':''; ?> value='Visa Category'>Visa Category</option>
												<option <?php echo $vfs_chat['comm32']=='Visa correction'?'selected':''; ?> value='Visa correction'>Visa correction</option>
												<option <?php echo $vfs_chat['comm32']=='Visa Fees'?'selected':''; ?> value='Visa Fees'>Visa Fees</option>
												<option <?php echo $vfs_chat['comm32']=='Visa Rules'?'selected':''; ?> value='Visa Rules'>Visa Rules</option>
												<option <?php echo $vfs_chat['comm32']=='Visa Stamping details'?'selected':''; ?> value='Visa Stamping details'>Visa Stamping details</option>
												<option <?php echo $vfs_chat['comm32']=='Walkin without Appointment'?'selected':''; ?> value='Walkin without Appointment'>Walkin without Appointment</option>
												<option <?php echo $vfs_chat['comm32']=='Withdrawal'?'selected':''; ?> value='Withdrawal'>Withdrawal</option>
												<option <?php echo $vfs_chat['comm32']=='Within SPT'?'selected':''; ?> value='Within SPT'>Within SPT</option>
												<option <?php echo $vfs_chat['comm32']=='Wrong Number'?'selected':''; ?> value='Wrong Number'>Wrong Number</option>
											</select>										
										</td>
										<td></td>
										<td><textarea class="form-control" name="comm26"><?php echo $vfs_chat['comm26'] ?></textarea></td>
									</tr>
									<tr>
										<td></td>
										<td colspan=1>b. Communication mode through which customer contacted previously</td>
										<td></td>
										<td><textarea class="form-control" name="comm33"><?php echo $vfs_chat['comm33'] ?></textarea></td>
										<td></td>
										<td><textarea class="form-control" name="comm27"><?php echo $vfs_chat['comm27'] ?></textarea></td>
									</tr>
									<tr>
										<td></td>
										<td colspan=1>c. Description of Disposition selected</td>
										<td></td>
										<td><textarea class="form-control" name="comm34"><?php echo $vfs_chat['comm34'] ?></textarea></td>
										<td></td>
										<td><textarea class="form-control" name="comm28"><?php echo $vfs_chat['comm28'] ?></textarea></td>
									</tr>
									<tr>
										<td></td>
										<td colspan=1>d. Was this the first time customer called us ?</td>
										<td></td>
										<td>
											 <select class="form-control vfsVal" id="" name="customer_called_first">
												<option value="">Select</option>
												<option vfs_val=0 vfs_max=0 <?php echo $vfs_chat['customer_called_first']=='No'?"selected":""; ?> value="No">No</option>
												<option vfs_val=0 <?php echo $vfs_chat['customer_called_first']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
											</select>
										</td>
										<td></td>
										<td><textarea class="form-control" name="comm29"><?php echo $vfs_chat['comm29'] ?></textarea></td>
									</tr>
									<tr>
										<td></td>
										<td colspan=1>e. Did the customer contact us more than once but less than 3 times ?</td>
										<td></td>
										<td>
											 <select class="form-control vfsVal" id="" name="customer_contact_more_one_less_three">
												<option value="">Select</option>
												<option vfs_val=0 vfs_max=0 <?php echo $vfs_chat['customer_contact_more_one_less_three']=='No'?"selected":""; ?> value="No">No</option>
												<option vfs_val=0 vfs_max=0 <?php echo $vfs_chat['customer_contact_more_one_less_three']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
											</select>
										</td>
										<td></td>
										<td><textarea class="form-control" name="comm30"><?php echo $vfs_chat['comm30'] ?></textarea></td>
									</tr>
									<tr>
										<td></td>
										<td colspan=1>f. Did the customer contact us more than 3 times ?</td>
										<td></td>
										<td>
											 <select class="form-control vfsVal" id="" name="customer_contact_more_three">
												<option value="">Select</option>
												<option vfs_val=0 vfs_max=0 <?php echo $vfs_chat['customer_contact_more_three']=='No'?"selected":""; ?> value="No">No</option>
												<option vfs_val=0 vfs_max=0 <?php echo $vfs_chat['customer_contact_more_three']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
											</select>
										</td>
										<td></td>
										<td><textarea class="form-control" name="comm31"><?php echo $vfs_chat['comm31'] ?></textarea></td>
									</tr>
									<tr>
										<td>Reason For Fatal Error:</td>
										<td colspan=2><textarea class="form-control"  name="reason_for_fatal"><?php echo $vfs_chat['reason_for_fatal'] ?></textarea></td>
										<td>Improvement Area:</td>
										<td colspan=2><textarea class="form-control"  name="inprovement_area"><?php echo $vfs_chat['inprovement_area'] ?></textarea></td>
									</tr>
									<tr>
										<td>QA Remarks:</td>
										<td colspan=2><textarea class="form-control"  name="call_summary"><?php echo $vfs_chat['call_summary'] ?></textarea></td>
										<!--<td>Feedback:</td>
										<td colspan=2><textarea class="form-control"  name="feedback"><?php echo $vfs_chat['feedback'] ?></textarea></td>-->
									</tr>
									<?php if($chat_id==0){ ?>
									<tr>
										<td colspan=2>Upload Files [m4a,mp4,mp3,wav]</td>
										<td colspan=4><input type="file" multiple class="form-control" id="attach_file" name="attach_file[]" accept=".m4a,.mp4,.mp3,.wav,audio/*"></td>
									</tr>
									<?php }else{ ?>
									<tr>	
										<td colspan=2>Upload Files [m4a,mp4,mp3,wav]</td>
										<?php if($vfs_chat['attach_file']!=''){ ?>
											<td colspan=4>
												<input type="file" multiple class="form-control"  id="attach_file" name="attach_file[]" accept=".m4a,.mp4,.mp3,.wav,audio/*"> 
												<?php $attach_file = explode(",",$vfs_chat['attach_file']);
												 foreach($attach_file as $mp){ ?>
													<audio controls='' style="background-color:#607F93"> 
													  <source src="<?php echo base_url(); ?>qa_files/qa_vfs/chat/<?php echo $mp; ?>" type="audio/ogg">
													  <source src="<?php echo base_url(); ?>qa_files/qa_vfs/chat/<?php echo $mp; ?>" type="audio/mpeg">
													</audio> </br>
												 <?php } ?>
											</td>
										<?php }else{
												echo '<td colspan=6>
													<input type="file" multiple class="form-control" id="attach_file" name="attach_file[]" accept=".m4a,.mp4,.mp3,.wav,audio/*">
													<b>No Files</b></td>';
											  }
										} ?>
									</tr>
										
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
