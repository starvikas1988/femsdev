
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

#fatalspan1{

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

<?php if($call_id!=0){
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
										<td colspan="6" id="theader">VFS Call Monitoring Form </td>
										<input type="hidden" name="audit_start_time" value="<?php echo CurrMySqlDate(); ?>">
									</tr>
									<tr>
									<?php
										if($call_id==0){
											$auditorName = get_username();
											$auditDate = CurrDateMDY();
											$clDate_val='';
										}else{
											if($vfs_call['entry_by']!=''){
												$auditorName = $vfs_call['auditor_name'];
											}else{
												$auditorName = $vfs_call['client_name'];
											}
											$auditDate = mysql2mmddyy($vfs_call['audit_date']);
											$clDate_val=mysql2mmddyy($vfs_call['call_date']);
										}
									?>
										<td>QA Name:<span style="font-size:24px;color:red">*</span></td>
										<td style="width:300px"><input type="text" class="form-control" value="<?php echo $auditorName; ?>" disabled></td>
										<td style="width:150px">Audit Date:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control" value="<?php echo $auditDate; ?>" disabled></td>
										<td>Call Date:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control" id="call_date" name="call_date"  onkeydown="return false;" value="<?php echo $clDate_val; ?>" required></td>
									</tr>
									<tr>
										<td>Agent Name:<span style="font-size:24px;color:red">*</span></td>
										<td>
											<select class="form-control" id="agent_id" name="agent_id" required>
											<?php 
												if($vfs_call['agent_id']!=''){
													?>
													<option value="<?php echo $vfs_call['agent_id'] ?>"><?php echo $vfs_call['fname']." ".$vfs_call['lname'] ?></option>
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
										<td><input type="text" class="form-control" id="fusion_id" name="" value="<?php echo $vfs_call['fusion_id']; ?>" readonly></td>
										<td>L1 Supervisor:<span style="font-size:24px;color:red">*</span></td>
										<td style="width:250px">
											<input type="text" class="form-control" id="tl_name"  value="<?php echo $vfs_call['tl_name']; ?>" readonly>
												<input type="hidden" class="form-control" id="tl_id" name="tl_id" value="<?php echo $vfs_call['tl_id'] ?>" required>
										</td>
									</tr>
									<tr>
										<td>Call Duration:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control" id="" name="call_duration"  value="<?php echo $vfs_call['call_duration']; ?>" required></td>
										<!-- <td><input type="text" class="form-control" id="call_duration" name="call_duration" onkeydown="return false;" value="<?php echo $vfs_call['call_duration']; ?>" required></td> -->
										<td>Mission:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control"  name="mission" value="<?php echo $vfs_call['mission']; ?>" required></td>
										<td>Recording ID:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control"  name="recording_id" value="<?php echo $vfs_call['recording_id']; ?>" required></td>
									</tr>
									<tr>
										<td>Week:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control"  name="week" value="<?php echo $vfs_call['week']; ?>" required></td>
										<!-- <td>
											<select class="form-control"  name="week" required>
												<option value="<?php echo $vfs_call['week'] ?>"><?php echo $vfs_call['week'] ?></option>
												<option value="">-Select-</option>
												<option value="Week1">Week1</option>
												<option value="Week2">Week2</option>
												<option value="Week3">Week3</option>
												<option value="Week4">Week4</option>
												<option value="Week5">Week5</option>
											</select>
										</td> -->
										<td>Fatal Error?:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control" id="fatalspan1" name="autofail_status" value="<?php echo $vfs_call['autofail_status']; ?>" readonly></td>
										<!-- <td>
											<select class="form-control" id="" name="autofail_status" required>
												<option value="">-Select-</option>
												<option <?php echo $vfs_call['autofail_status']=='Fatal'?"selected":""; ?> value="Fatal">Fatal</option>
												<option <?php echo $vfs_call['autofail_status']=='Non Fatal'?"selected":""; ?> value="Non Fatal">Non Fatal</option>
											</select>
										</td> -->
										<td>Host/Country:<span style="font-size:24px;color:red">*</span></td>
										<td>
											<select class="form-control" name="host_country" required>
												<option value=''>-Select-</option>
												<option <?php echo $vfs_call['host_country']=='Philippines' ? 'selected' :'';  ?>  value='Philippines'>Philippines</option>
												<option <?php echo $vfs_call['host_country']=='Australia' ? 'selected' :'';  ?>  value='Australia'>Australia</option>
												<option <?php echo $vfs_call['host_country']=='New Zealand' ? 'selected' :'';  ?>  value='New Zealand'>New Zealand</option>
												<option <?php echo $vfs_call['host_country']=='Singapore' ? 'selected' :'';  ?>  value='Singapore'>Singapore</option>
												<option <?php echo $vfs_call['host_country']=='Thailand' ? 'selected' :'';  ?>  value='Thailand'>Thailand</option>
												<option <?php echo $vfs_call['host_country']=='Indonesia' ? 'selected' :'';  ?>  value='Indonesia'>Indonesia</option>
												<option <?php echo $vfs_call['host_country']=='Malaysia' ? 'selected' :'';  ?>  value='Malaysia'>Malaysia</option>
											</select>
										</td>
									</tr>
									<tr>
										<td>Agent Tenurity:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control" name="tenurity" id="tenure" value="<?php echo $vfs_call['tenurity']; ?>" readonly></td>
										<td>VOC:<span style="font-size:24px;color:red">*</span></td>
										<td>
											<select class="form-control" id="voc" name="voc" required>
												<option value="">-Select-</option>
												<option <?php echo $vfs_call['voc']=='1'?"selected":""; ?> value="1">1</option>
												<option <?php echo $vfs_call['voc']=='2'?"selected":""; ?> value="2">2</option>
												<option <?php echo $vfs_call['voc']=='3'?"selected":""; ?> value="3">3</option>
												<option <?php echo $vfs_call['voc']=='4'?"selected":""; ?> value="4">4</option>
												<option <?php echo $vfs_call['voc']=='5'?"selected":""; ?> value="5">5</option>
											</select>
										</td>
										<td>ACPT:<span style="font-size:24px;color:red">*</span></td>
										<td>
												<select class="form-control" id="" name="acpt" required>
													<option value="">-Select-</option>
													<option value="Agent"  <?= ($vfs_call['acpt']=="Agent")?"selected":"" ?>>Agent</option>
													<option value="Process"  <?= ($vfs_call['acpt']=="Process")?"selected":"" ?>>Process</option>
													<option value="Customer"  <?= ($vfs_call['acpt']=="Customer")?"selected":"" ?>>Customer</option>
													<option value="Technology"  <?= ($vfs_call['acpt']=="Technology")?"selected":"" ?>>Technology</option>
													<option value="NA"  <?= ($vfs_call['acpt']=="NA")?"selected":"" ?>>NA</option>
												</select>
											</td>
									</tr>
									<tr>
										<td>Audit Type:<span style="font-size:24px;color:red">*</span></td>
										<td>
											<select class="form-control" id="audit_type" name="audit_type" required>
												<option value="">-Select-</option>
												<option value="CQ Audit" <?= ($vfs_call['audit_type']=="CQ Audit")?"selected":"" ?>>CQ Audit</option>
												<option value="BQ Audit" <?= ($vfs_call['audit_type']=="BQ Audit")?"selected":"" ?>>BQ Audit</option>
												<option value="Calibration" <?= ($vfs_call['audit_type']=="Calibration")?"selected":"" ?>>Calibration</option>
												<option value="Pre-Certificate Mock Call" <?= ($vfs_call['audit_type']=="Pre-Certificate Mock Call")?"selected":"" ?>>Pre-Certificate Mock Call</option>
												<option value="Certification Audit" <?= ($vfs_call['audit_type']=="Certification Audit")?"selected":"" ?>>Certification Audit</option>
												<option value="WoW Call"  <?= ($vfs_call['audit_type']=="WoW Call")?"selected":"" ?>>WoW Call</option>
												<option value="Hygiene Audit"  <?= ($vfs_call['audit_type']=="Hygiene Audit")?"selected":"" ?>>Hygiene Audit</option>
												<option value="Operation Audit"  <?= ($vfs_call['audit_type']=="Operation Audit")?"selected":"" ?>>Operation Audit</option>
												<option value="Trainer Audit"  <?= ($vfs_call['audit_type']=="Trainer Audit")?"selected":"" ?>>Trainer Audit</option> 
												<option value="QA Supervisor Audit"  <?= ($vfs_call['audit_type']=="QA Supervisor Audit")?"selected":"" ?>>QA Supervisor Audit</option> 
											</select>
										</td>
										<td>L1:<span style="font-size:24px;color:red">*</span></td>
										<td>
											<select class="form-control" name="l1" required>
												<option value=''>-Select-</option>
												<option <?php echo $vfs_call['l1']=='Application related' ? 'selected' :'';  ?>  value='Application related'>Application related</option>
												<option <?php echo $vfs_call['l1']=='Appointment Related' ? 'selected' :'';  ?>  value='Appointment Related'>Appointment Related</option>
												<option <?php echo $vfs_call['l1']=='Consulate Related' ? 'selected' :'';  ?>  value='Consulate Related'>Consulate Related</option>
												<option <?php echo $vfs_call['l1']=='Courier Related' ? 'selected' :'';  ?>  value='Courier Related'>Courier Related</option>
												<option <?php echo $vfs_call['l1']=='Customer Perception' ? 'selected' :'';  ?>  value='Customer Perception'>Customer Perception</option>
												<option <?php echo $vfs_call['l1']=='Process Limitation' ? 'selected' :'';  ?>  value='Process Limitation'>Process Limitation</option>
												<option <?php echo $vfs_call['l1']=='Process not followed' ? 'selected' :'';  ?>  value='Process not followed'>Process not followed</option>
												<option <?php echo $vfs_call['l1']=='Soft Skills' ? 'selected' :'';  ?>  value='Soft Skills'>Soft Skills</option>
												<option <?php echo $vfs_call['l1']=='Website Related' ? 'selected' :'';  ?>  value='Website Related'>Website Related</option>
												<option <?php echo $vfs_call['l1']=='System Limitation' ? 'selected' :'';  ?>  value='System Limitation'>System Limitation</option>
												<option <?php echo $vfs_call['l1']=='System Downtime' ? 'selected' :'';  ?>  value='System Downtime'>System Downtime</option>
												<option <?php echo $vfs_call['l1']=='Knowledge Gap' ? 'selected' :'';  ?>  value='Knowledge Gap'>Knowledge Gap</option>
												<option <?php echo $vfs_call['l1']=='Communication Gap' ? 'selected' :'';  ?>  value='Communication Gap'>Communication Gap</option>
												<option <?php echo $vfs_call['l1']=='Skill Issue' ? 'selected' :'';  ?>  value='Skill Issue'>Skill Issue</option>
												<option <?php echo $vfs_call['l1']=='Behavioral Issue' ? 'selected' :'';  ?>  value='Behavioral Issue'>Behavioral Issue</option>
											</select>
										</td>
										<td>L2:<span style="font-size:24px;color:red">*</span></td>
										<td>
											<select class="form-control" name="l2" required>
												<option value=''>-Select-</option>
												<option <?php echo $vfs_call['l2']=='Application under process' ? 'selected' :'';  ?>  value='Application under process'>Application under process</option>
												<option <?php echo $vfs_call['l2']=='Correct & Complete Information Provided' ? 'selected' :'';  ?>  value='Correct & Complete Information Provided'>Correct & Complete Information Provided</option>
												<option <?php echo $vfs_call['l2']=='Delay in lodging' ? 'selected' :'';  ?>  value='Delay in lodging'>Delay in lodging</option>
												<option <?php echo $vfs_call['l2']=='E - visa related' ? 'selected' :'';  ?>  value='E - visa related'>E - visa related</option>
												<option <?php echo $vfs_call['l2']=='Incorrect Information provided' ? 'selected' :'';  ?>  value='Incorrect Information provided'>Incorrect Information provided</option>
												<option <?php echo $vfs_call['l2']=='Lack of Attentiveness' ? 'selected' :'';  ?>  value='Lack of Attentiveness'>Lack of Attentiveness</option>
												<option <?php echo $vfs_call['l2']=='Lack of courteous and professional' ? 'selected' :'';  ?>  value='Lack of courteous and professional'>Lack of courteous and professional</option>
												<option <?php echo $vfs_call['l2']=='Not authorised to book an appointment' ? 'selected' :'';  ?>  value='Not authorised to book an appointment'>Not authorised to book an appointment</option>
												<option <?php echo $vfs_call['l2']=='Not authorised to confirm the information' ? 'selected' :'';  ?>  value='Not authorised to confirm the information'>Not authorised to confirm the information</option>
												<option <?php echo $vfs_call['l2']=='Other countries query' ? 'selected' :'';  ?>  value='Other countries query'>Other countries query</option>
												<option <?php echo $vfs_call['l2']=='Passport not delivered' ? 'selected' :'';  ?>  value='Passport not delivered'>Passport not delivered</option>
												<option <?php echo $vfs_call['l2']=='Slots not available' ? 'selected' :'';  ?>  value='Slots not available'>Slots not available</option>
												<option <?php echo $vfs_call['l2']=='Unable to fill application form' ? 'selected' :'';  ?>  value='Unable to fill application form'>Unable to fill application form</option>
												<option <?php echo $vfs_call['l2']=='Unable to login' ? 'selected' :'';  ?>  value='Unable to login'>Unable to login</option>
												<option <?php echo $vfs_call['l2']=='Unable to reach the consulate' ? 'selected' :'';  ?>  value='Unable to reach the consulate'>Unable to reach the consulate</option>
												<option <?php echo $vfs_call['l2']=='Process Query' ? 'selected' :'';  ?>  value='Process Query'>Process Query</option>
												<option <?php echo $vfs_call['l2']=='Out of scope issues' ? 'selected' :'';  ?>  value='Out of scope issues'>Out of scope issues</option>
												<option <?php echo $vfs_call['l2']=='CX is not aware that the information is available on the website' ? 'selected' :'';  ?>  value='CX is not aware that the information is available on the website'>CX is not aware that the information is available on the website</option>
												<option <?php echo $vfs_call['l2']=='Agent needs to coordinate first with VAC for the information' ? 'selected' :'';  ?>  value='Agent needs to coordinate first with VAC for the information'>Agent needs to coordinate first with VAC for the information</option>
												<option <?php echo $vfs_call['l2']=='Internet Issue' ? 'selected' :'';  ?>  value='Internet Issue'>Internet Issue</option>
												<option <?php echo $vfs_call['l2']=='Hardware Issue' ? 'selected' :'';  ?>  value='Hardware Issue'>Hardware Issue</option>
												<option <?php echo $vfs_call['l2']=='Tool/Software Inaccessible' ? 'selected' :'';  ?>  value='Tool/Software Inaccessible'>Tool/Software Inaccessible</option>
												<option <?php echo $vfs_call['l2']=='Ineffective Training' ? 'selected' :'';  ?>  value='Ineffective Training'>Ineffective Training</option>
												<option <?php echo $vfs_call['l2']=='Poor Retention' ? 'selected' :'';  ?>  value='Poor Retention'>Poor Retention</option>
												<option <?php echo $vfs_call['l2']=='Poor update cascade' ? 'selected' :'';  ?>  value='Poor update cascade'>Poor update cascade</option>
												<option <?php echo $vfs_call['l2']=='Language Barrier' ? 'selected' :'';  ?>  value='Language Barrier'>Language Barrier</option>
												<option <?php echo $vfs_call['l2']=='Poor Comprehension' ? 'selected' :'';  ?>  value='Poor Comprehension'>Poor Comprehension</option>
												<option <?php echo $vfs_call['l2']=='Poor Communication Skill' ? 'selected' :'';  ?>  value='Poor Communication Skill'>Poor Communication Skill</option>
												<option <?php echo $vfs_call['l2']=='Poor Multi-tasking Skill' ? 'selected' :'';  ?>  value='Poor Multi-tasking Skill'>Poor Multi-tasking Skill</option>
											</select>
										</td>
									</tr>
									</tr>
										<td class="auType">Auditor Type<span style="font-size:24px;color:red">*</span></td>
										<td class="auType">
											<select class="form-control" id="auditor_type" name="auditor_type">
												<option value="">-Select-</option>
												 <option value="Master" <?= ($vfs_call['auditor_type']=="Master")?"selected":"" ?>>Master</option> 
												 <option value="Regular" <?= ($vfs_call['auditor_type']=="Regular")?"selected":"" ?>>Regular</option> 
											</select>
										</td>
									</tr>
									<tr>
										<td style="font-weight:bold">Earned Score:</td>
										<td><input type="text" readonly id="vfsEarned" name="earned_score" class="form-control" style="font-weight:bold" value="<?php echo $vfs_call['overall_score'] ?>"></td>
										<td style="font-weight:bold">Possible Score:</td>
										<td><input type="text" readonly id="vfsPossible" name="possible_score" class="form-control" style="font-weight:bold" value="<?php echo $vfs_call['overall_score'] ?>"></td>
										<td style="font-weight:bold">Overall Score Percentage:</td>
										<td><input type="text" readonly id="vfsOverallScore" name="overall_score" class="form-control vfsCallFatal" style="font-weight:bold" value="<?php echo $vfs_call['overall_score'] ?>"></td>
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
										<td style="background-color:#BFC9CA">5</td>
										<td style="background-color:#BFC9CA"></td>
										<td style="background-color:#BFC9CA" id="score_opening">5</td>
										<td style="background-color:#BFC9CA"></td>
									</tr>
									<tr>
										<td></td>
										<td colspan=1>a.Appropriate greeting - as per script & Clear and Crisp opening</td>
										<td>5</td>
										<td>
											<select class="form-control vfsVal" data-id="opening"  name="appropiate_greeting" required>
												<option vfs_val=5 vfs_max='5' <?php echo $vfs_call['appropiate_greeting']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option vfs_val=0 vfs_max='5' <?php echo $vfs_call['appropiate_greeting']=='No'?"selected":""; ?> value="No">No</option>
												<option vfs_val=0 vfs_max='5' <?php echo $vfs_call['appropiate_greeting']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td id="score_appropiate_greeting">5</td>
										<td><textarea class="form-control" name="comm0"><?php echo $vfs_call['comm0'] ?></textarea></td>
									</tr>
									<tr>
										<td style="background-color:#BFC9CA"><b>2</b></td>
										<td colspan=1 style="background-color:#BFC9CA">Communication</td>
										<td style="background-color:#BFC9CA">30</td>
										<td style="background-color:#BFC9CA"></td>
										<td style="background-color:#BFC9CA" id="score_communication">30</td>
										<td style="background-color:#BFC9CA"></td>
									</tr>
									<tr>
										<td></td>
										<td colspan=1>a. Voice modulation (Maintained proper tone, pitch, & volume throughout the call) & Appropriate pace & clarity of speech</td>
										<td>5</td>
										<td>
											<select class="form-control vfsVal" data-id="communication"  name="voice_modulation" required>
												<option vfs_val=5 vfs_max='5' <?php echo $vfs_call['voice_modulation']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option vfs_val=0 vfs_max='5' <?php echo $vfs_call['voice_modulation']=='No'?"selected":""; ?> value="No">No</option>
												<option vfs_val=0 vfs_max='5' <?php echo $vfs_call['voice_modulation']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td id="score_voice_modulation">5</td>
										<td><textarea class="form-control" name="comm1"><?php echo $vfs_call['comm1'] ?></textarea></td>
									</tr>
									<tr>
										<td></td>
										<td colspan=1>b. Empathy on call & Personalization / Power words</td>
										<td>5</td>
										<td>
											<select class="form-control vfsVal" data-id="communication"  name="call_empathy" required>
												<option vfs_val=5 vfs_max='5' <?php echo $vfs_call['call_empathy']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option vfs_val=0 vfs_max='5' <?php echo $vfs_call['call_empathy']=='No'?"selected":""; ?> value="No">No</option>
												<option vfs_val=0 vfs_max='5' <?php echo $vfs_call['call_empathy']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td id="score_call_empathy">5</td>
										<td><textarea class="form-control" name="comm2"><?php echo $vfs_call['comm2'] ?></textarea></td>
									</tr>
									<tr>
										<td></td>
										<td colspan=1>c. Adjusted to customer language & Courteous & Professional</td>
										<td>5</td>
										<td>
											<select class="form-control vfsVal" data-id="communication"  name="adjust_customer_language" required>
												<option vfs_val=5 vfs_max='5' <?php echo $vfs_call['adjust_customer_language']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option vfs_val=0 vfs_max='5' <?php echo $vfs_call['adjust_customer_language']=='No'?"selected":""; ?> value="No">No</option>
												<option vfs_val=0 vfs_max='5' <?php echo $vfs_call['adjust_customer_language']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td id="score_adjust_customer_language">5</td>
										<td><textarea class="form-control" name="comm3"><?php echo $vfs_call['comm3'] ?></textarea></td>
									</tr>
									<tr>
										<td></td>
										<td colspan=1>d. No jargons - simple words used & Avoid fumbling & fillers</td>
										<td>5</td>
										<td>
											<select class="form-control vfsVal" data-id="communication"  name="simple_word_used" required>
												<option vfs_val=5 vfs_max='5' <?php echo $vfs_call['simple_word_used']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option vfs_val=0 vfs_max='5' <?php echo $vfs_call['simple_word_used']=='No'?"selected":""; ?> value="No">No</option>
												<option vfs_val=0 vfs_max='5' <?php echo $vfs_call['simple_word_used']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td id="score_simple_word_used">5</td>
										<td><textarea class="form-control" name="comm4"><?php echo $vfs_call['comm4'] ?></textarea></td>
									</tr>
									<tr>
										<td></td>
										<td colspan=1>e. Active listening / Attentiveness & Paraphrasing & Acknowledgment</td>
										<td>5</td>
										<td>
											<select class="form-control vfsVal" data-id="communication"  name="active_listening" required>
												<option vfs_val=5 vfs_max='5' <?php echo $vfs_call['active_listening']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option vfs_val=0 vfs_max='5' <?php echo $vfs_call['active_listening']=='No'?"selected":""; ?> value="No">No</option>
												<option vfs_val=0 vfs_max='5' <?php echo $vfs_call['active_listening']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td id="score_active_listening">5</td>
										<td><textarea class="form-control" name="comm5"><?php echo $vfs_call['comm5'] ?></textarea></td>
									</tr>
									<tr>
										<td></td>
										<td colspan=1>f. Grammatically correct sentences & Comprehension</td>
										<td>5</td>
										<td>
											<select class="form-control vfsVal" data-id="communication"  name="avoid_fumbling" required>
												<option vfs_val=5 vfs_max='5' <?php echo $vfs_call['avoid_fumbling']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option vfs_val=0 vfs_max='5' <?php echo $vfs_call['avoid_fumbling']=='No'?"selected":""; ?> value="No">No</option>
												<option vfs_val=0 vfs_max='5' <?php echo $vfs_call['avoid_fumbling']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td id="score_avoid_fumbling">5</td>
										<td><textarea class="form-control" name="comm6"><?php echo $vfs_call['comm6'] ?></textarea></td>
									</tr>
									<tr>
										<td style="background-color:#BFC9CA"><b>3</b></td>
										<td colspan=1 style="background-color:#BFC9CA">Technical aspects</td>
										<td style="background-color:#BFC9CA">30</td>
										<td style="background-color:#BFC9CA"></td>
										<td style="background-color:#BFC9CA" id="score_technical_aspects">30</td>
										<td style="background-color:#BFC9CA"></td>
									</tr>
									<tr>
										<td></td>										
										<td colspan=1>a. Appropriate Probing</td>
										<td>5</td>
										<td>
											<select class="form-control vfsVal" data-id="technical_aspects" name="appropiate_probing" required>
												<option vfs_val=5 vfs_max='5' <?php echo $vfs_call['appropiate_probing']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option vfs_val=0 vfs_max='5' <?php echo $vfs_call['appropiate_probing']=='No'?"selected":""; ?> value="No">No</option>
												<option vfs_val=0 vfs_max='5' <?php echo $vfs_call['appropiate_probing']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td id="score_appropiate_probing">5</td>
										<td><textarea class="form-control" name="comm7"><?php echo $vfs_call['comm7'] ?></textarea></td>
									</tr>
									<tr>
										<td></td>										
										<td colspan=1>b. Took ownership to resolve customer's concern</td>
										<td>5</td>
										<td>
											<select class="form-control vfsVal" data-id="technical_aspects" name="ownership_resolve" required>
												<option vfs_val=5 vfs_max='5' <?php echo $vfs_call['ownership_resolve']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option vfs_val=0 vfs_max='5' <?php echo $vfs_call['ownership_resolve']=='No'?"selected":""; ?> value="No">No</option>
												<option vfs_val=0 vfs_max='5' <?php echo $vfs_call['ownership_resolve']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td id="score_ownership_resolve">5</td>
										<td><textarea class="form-control" name="comm8"><?php echo $vfs_call['comm8'] ?></textarea></td>
									</tr>
									<tr><td></td>
										<td colspan=1>c. Escalate the issue wherever required</td>
										<td>5</td>
										<td>
											<select class="form-control vfsVal" data-id="technical_aspects"  name="escalate_issue" required>
												<option vfs_val=5 vfs_max='5' <?php echo $vfs_call['escalate_issue']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option vfs_val=0 vfs_max='5' <?php echo $vfs_call['escalate_issue']=='No'?"selected":""; ?> value="No">No</option>
												<option vfs_val=0 vfs_max='5' <?php echo $vfs_call['escalate_issue']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td id="score_escalate_issue">5</td>
										<td><textarea class="form-control" name="comm9"><?php echo $vfs_call['comm9'] ?></textarea></td>
									</tr>
									<tr><td></td>
										<td colspan=1>d. Call control</td>
										<td>5</td>
										<td>
											<select class="form-control vfsVal" data-id="technical_aspects"  name="call_control" required>
												<option vfs_val=5 vfs_max='5' <?php echo $vfs_call['call_control']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option vfs_val=0 vfs_max='5' <?php echo $vfs_call['call_control']=='No'?"selected":""; ?> value="No">No</option>
												<option vfs_val=0 vfs_max='5' <?php echo $vfs_call['call_control']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td id="score_call_control">5</td>
										<td><textarea class="form-control" name="comm10"><?php echo $vfs_call['comm10'] ?></textarea></td>
									</tr>
									<tr><td></td>
										<td colspan=1>e. Query resolved on call - FTR</td>
										<td>5</td>
										<td>
											<select class="form-control vfsVal" data-id="technical_aspects"  name="query_resolved" required>
												<option vfs_val=5 vfs_max='5' <?php echo $vfs_call['query_resolved']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option vfs_val=0 vfs_max='5' <?php echo $vfs_call['query_resolved']=='No'?"selected":""; ?> value="No">No</option>
												<option vfs_val=0 vfs_max='5' <?php echo $vfs_call['query_resolved']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td id="score_query_resolved">5</td>
										<td><textarea class="form-control" name="comm11"><?php echo $vfs_call['comm11'] ?></textarea></td>
									</tr>
									<tr><td></td>
										<td colspan=1>f. Step by step procuedure to resolve the QRC(Query/Request/Complaint)</td>
										<td>5</td>
										<td>
											<select class="form-control vfsVal" data-id="technical_aspects"  name="procuedure_request" required>
												<option vfs_val=5 vfs_max='5' <?php echo $vfs_call['procuedure_request']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option vfs_val=0 vfs_max='5' <?php echo $vfs_call['procuedure_request']=='No'?"selected":""; ?> value="No">No</option>
												<option vfs_val=0 vfs_max='5' <?php echo $vfs_call['procuedure_request']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td id="score_procuedure_request">5</td>
										<td><textarea class="form-control" name="comm12"><?php echo $vfs_call['comm12'] ?></textarea></td>
									</tr>
									<tr>
										<td style="background-color:#BFC9CA"><b>4</b></td>
										<td colspan=1 style="background-color:#BFC9CA">Value Additons</td>
										<td style="background-color:#BFC9CA">10</td>
										<td style="background-color:#BFC9CA"></td>
										<td style="background-color:#BFC9CA" id="score_additons">10</td>
										<td style="background-color:#BFC9CA"></td>
									</tr>
									<tr>
										<td></td>										
										<td colspan=1>a. Offers VAS options wherever applicable</td>
										<td>5</td>
										<td>
											<select class="form-control vfsVal" data-id="additons"  name="offers_VAS" required>
												<option vfs_val=5 vfs_max='5' <?php echo $vfs_call['offers_VAS']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option vfs_val=0 vfs_max='5' <?php echo $vfs_call['offers_VAS']=='No'?"selected":""; ?> value="No">No</option>
												<option vfs_val=0 vfs_max='5' <?php echo $vfs_call['offers_VAS']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td id="score_offers_VAS">5</td>
										<td><textarea class="form-control" name="comm13"><?php echo $vfs_call['comm13'] ?></textarea></td>
									</tr>
									<tr>
										<td></td>
										<td colspan=1>b. Awareness created with regards to VFS website (wherever applicable)</td>
										<td>5</td>
										<td>
											<select class="form-control vfsVal" data-id="additons"  name="awareness_created" required>
												<option vfs_val=5 vfs_max='5' <?php echo $vfs_call['awareness_created']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option vfs_val=0 vfs_max='5' <?php echo $vfs_call['awareness_created']=='No'?"selected":""; ?> value="No">No</option>
												<option vfs_val=0 vfs_max='5' <?php echo $vfs_call['awareness_created']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td id="score_awareness_created">5</td>
										<td><textarea class="form-control" name="comm14"><?php echo $vfs_call['comm14'] ?></textarea></td>
									</tr>
									<tr>
										<td style="background-color:#BFC9CA"><b>5</b></td>
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
											<select class="form-control vfsVal" data-id="documentation"  name="correct_disposition" required>
												<option vfs_val=5 vfs_max='5' <?php echo $vfs_call['correct_disposition']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option vfs_val=0 vfs_max='5' <?php echo $vfs_call['correct_disposition']=='No'?"selected":""; ?> value="No">No</option>
												<option vfs_val=0 vfs_max='5' <?php echo $vfs_call['correct_disposition']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td id="score_correct_disposition">5</td>
										<td><textarea class="form-control" name="comm15"><?php echo $vfs_call['comm15'] ?></textarea></td>
									</tr>
									<tr>
										<td></td>
										<td colspan=1>b. Update ASM/V2</td>
										<td>5</td>
										<td>
											<select class="form-control vfsVal" data-id="documentation"  name="update_ASM" required>
												<option vfs_val=5 vfs_max='5' <?php echo $vfs_call['update_ASM']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option vfs_val=0 vfs_max='5' <?php echo $vfs_call['update_ASM']=='No'?"selected":""; ?> value="No">No</option>
												<option vfs_val=0 vfs_max='5' <?php echo $vfs_call['update_ASM']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td id="score_update_ASM">5</td>
										<td><textarea class="form-control" name="comm16"><?php echo $vfs_call['comm16'] ?></textarea></td>
									</tr>
									<tr>
										<td style="background-color:#BFC9CA"><b>6</b></td>
										<td colspan=1 style="background-color:#BFC9CA">Hold Protocol</td>
										<td style="background-color:#BFC9CA">5</td>
										<td style="background-color:#BFC9CA"></td>
										<td style="background-color:#BFC9CA" id="score_hold_protocol">5</td>
										<td style="background-color:#BFC9CA"></td>
									</tr>
									<tr>
										<td></td>
										<td colspan=1>a. Hold Guidelines followed</td>
										<td>5</td>
										<td>
											<select class="form-control vfsVal" data-id="hold_protocol"  name="hold_required" required>
												<option vfs_val=5 vfs_max='5' <?php echo $vfs_call['hold_required']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option vfs_val=0 vfs_max='5' <?php echo $vfs_call['hold_required']=='No'?"selected":""; ?> value="No">No</option>
												<option vfs_val=0 vfs_max='5' <?php echo $vfs_call['hold_required']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td id="score_hold_required">5</td>
										<td><textarea class="form-control" name="comm17"><?php echo $vfs_call['comm17'] ?></textarea></td>
									</tr>
									<tr>
										<td style="background-color:#BFC9CA"><b>7</b></td>
										<td colspan=1 style="background-color:#BFC9CA">Call Closing</td>
										<td style="background-color:#BFC9CA">10</td>
										<td style="background-color:#BFC9CA"></td>
										<td style="background-color:#BFC9CA" id="score_call_closing">10</td>
										<td style="background-color:#BFC9CA"></td>
									</tr>
									<tr>
										<td></td>
										<td colspan=1>a. Further assistance & Adherence to call closing script</td>
										<td>5</td>
										<td>
											<select class="form-control vfsVal" data-id="call_closing"  name="further_assistance" required>
												<option vfs_val=5 vfs_max='5' <?php echo $vfs_call['further_assistance']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option vfs_val=0 vfs_max='5' <?php echo $vfs_call['further_assistance']=='No'?"selected":""; ?> value="No">No</option>
												<option vfs_val=0 vfs_max='5' <?php echo $vfs_call['further_assistance']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td id="score_further_assistance">5</td>
										<td><textarea class="form-control" name="comm18"><?php echo $vfs_call['comm18'] ?></textarea></td>
									</tr>
									<tr>
										<td></td>
										<td colspan=1>b. Attempt to take feedback on experience  - CSAT</td>
										<td>5</td>
										<td>
											<select class="form-control vfsVal" data-id="call_closing"  name="CSAT_experience_feedback" required>
												<option vfs_val=5 vfs_max='5' <?php echo $vfs_call['CSAT_experience_feedback']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option vfs_val=0 vfs_max='5' <?php echo $vfs_call['CSAT_experience_feedback']=='No'?"selected":""; ?> value="No">No</option>
												<option vfs_val=0 vfs_max='5' <?php echo $vfs_call['CSAT_experience_feedback']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td id="score_CSAT_experience_feedback">5</td>
										<td><textarea class="form-control" name="comm19"><?php echo $vfs_call['comm19'] ?></textarea></td>
									</tr>
									<tr>
										<td style="background-color:#BFC9CA"><b>8</b></td>
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
											<select class="form-control vfsVal fatal_epi" id="callAutof1" name="delayed_opening" required>
												<option vfs_val=0 vfs_max=0 <?php echo $vfs_call['delayed_opening']=='No'?"selected":""; ?> value="No">No</option>
												<option vfs_val=0 vfs_max=0  <?php echo $vfs_call['delayed_opening']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
											</select>
										</td>
										<td></td>
										<td><textarea class="form-control" name="comm20"><?php echo $vfs_call['comm20'] ?></textarea></td>
									</tr>
									<tr>
										<td></td>
										<td colspan=1 style="background-color:#D98880">b. Rude on chat</td>
										<td></td>
										<td>
											<select class="form-control vfsVal fatal_epi" id="callAutof2" name="rude_on_call" required>
												<option vfs_val=0 vfs_max=0  <?php echo $vfs_call['rude_on_call']=='No'?"selected":""; ?> value="No">No</option>
												<option vfs_val=0 vfs_max=0  <?php echo $vfs_call['rude_on_call']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
											</select>
										</td>
										<td></td>
										<td><textarea class="form-control" name="comm21"><?php echo $vfs_call['comm21'] ?></textarea></td>
									</tr>
									<tr>
										<td></td>
										<td colspan=1 style="background-color:#D98880">c. Incomplete/Inaccurate Information shared</td>
										<td></td>
										<td>
											<select class="form-control vfsVal fatal_epi" id="callAutof3" name="incomplete_information" required>
												<option vfs_val=0 vfs_max=0  <?php echo $vfs_call['incomplete_information']=='No'?"selected":""; ?> value="No">No</option>
												<option vfs_val=0 vfs_max=0  <?php echo $vfs_call['incomplete_information']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
											</select>
										</td>
										<td></td>
										<td><textarea class="form-control" name="comm22"><?php echo $vfs_call['comm22'] ?></textarea></td>
									</tr>
									<tr>
										<td></td>
										<td colspan=1 style="background-color:#D98880">d. Complaint Avoidance</td>
										<td></td>
										<td>
											<select class="form-control vfsVal fatal_epi" id="callAutof4" name="complaint_avoidance" required>
												<option vfs_val=0 vfs_max=0  <?php echo $vfs_call['complaint_avoidance']=='No'?"selected":""; ?> value="No">No</option>
												<option vfs_val=0 vfs_max=0  <?php echo $vfs_call['complaint_avoidance']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
											</select>
										</td>
										<td></td>
										<td><textarea class="form-control" name="comm23"><?php echo $vfs_call['comm23'] ?></textarea></td>
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
											<select class="form-control" id="disposition" name="disposition" >
												<option value=''>-Select-</option>
												<option <?php echo $vfs_call['disposition']=='Additional Documents asked by the Embassy/consulate'?'selected':''; ?> value='Additional Documents asked by the Embassy/consulate'>Additional Documents asked by the Embassy/consulate</option>
												<option <?php echo $vfs_call['disposition']=='Agent'?'selected':''; ?> value='Agent'>Agent</option>
												<option <?php echo $vfs_call['disposition']=='Appeal Procedure'?'selected':''; ?> value='Appeal Procedure'>Appeal Procedure</option>
												<option <?php echo $vfs_call['disposition']=='Applicant'?'selected':''; ?> value='Applicant'>Applicant</option>
												<option <?php echo $vfs_call['disposition']=='Applicant Requested'?'selected':''; ?> value='Applicant Requested'>Applicant Requested</option>
												<option <?php echo $vfs_call['disposition']=='Application Form Filling'?'selected':''; ?> value='Application Form Filling'>Application Form Filling</option>
												<option <?php echo $vfs_call['disposition']=='Appointment re-confirmation'?'selected':''; ?> value='Appointment re-confirmation'>Appointment re-confirmation</option>
												<option <?php echo $vfs_call['disposition']=='Approval letter'?'selected':''; ?> value='Approval letter'>Approval letter</option>
												<option <?php echo $vfs_call['disposition']=='AWB'?'selected':''; ?> value='AWB'>AWB</option>
												<option <?php echo $vfs_call['disposition']=='AWB Not Generated'?'selected':''; ?> value='AWB Not Generated'>AWB Not Generated</option>
												<option <?php echo $vfs_call['disposition']=='Biometrics'?'selected':''; ?> value='Biometrics'>Biometrics</option>
												<option <?php echo $vfs_call['disposition']=='Blank call'?'selected':''; ?> value='Blank call'>Blank call</option>
												<option <?php echo $vfs_call['disposition']=='Call Connected'?'selected':''; ?> value='Call Connected'>Call Connected</option>
												<option <?php echo $vfs_call['disposition']=='Call not answered'?'selected':''; ?> value='Call not answered'>Call not answered</option>
												<option <?php echo $vfs_call['disposition']=='Cancellation'?'selected':''; ?> value='Cancellation'>Cancellation</option>
												<option <?php echo $vfs_call['disposition']=='Check and Verify'?'selected':''; ?> value='Check and Verify'>Check and Verify</option>
												<option <?php echo $vfs_call['disposition']=='Collection timing'?'selected':''; ?> value='Collection timing'>Collection timing</option>
												<option <?php echo $vfs_call['disposition']=='Consulate Details'?'selected':''; ?> value='Consulate Details'>Consulate Details</option>
												<option <?php echo $vfs_call['disposition']=='Counter Collection'?'selected':''; ?> value='Counter Collection'>Counter Collection</option>
												<option <?php echo $vfs_call['disposition']=='Courier'?'selected':''; ?> value='Courier'>Courier</option>
												<option <?php echo $vfs_call['disposition']=='Courier Assurance'?'selected':''; ?> value='Courier Assurance'>Courier Assurance</option>
												<option <?php echo $vfs_call['disposition']=='Dispositon'?'selected':''; ?> value='Dispositon'>Dispositon</option>
												<option <?php echo $vfs_call['disposition']=='Documentation'?'selected':''; ?> value='Documentation'>Documentation</option>
												<option <?php echo $vfs_call['disposition']=='Documentation - Checklist'?'selected':''; ?> value='Documentation - Checklist'>Documentation - Checklist</option>
												<option <?php echo $vfs_call['disposition']=='Documentation - supporting docs'?'selected':''; ?> value='Documentation - supporting docs'>Documentation - supporting docs</option>
												<option <?php echo $vfs_call['disposition']=='Documents attestation'?'selected':''; ?> value='Documents attestation'>Documents attestation</option>
												<option <?php echo $vfs_call['disposition']=='Embassy Submission'?'selected':''; ?> value='Embassy Submission'>Embassy Submission</option>
												<option <?php echo $vfs_call['disposition']=='Embassy Website'?'selected':''; ?> value='Embassy Website'>Embassy Website</option>
												<option <?php echo $vfs_call['disposition']=='Error Faced while booking an appoitment'?'selected':''; ?> value='Error Faced while booking an appoitment'>Error Faced while booking an appoitment</option>
												<option <?php echo $vfs_call['disposition']=='Existing appointment - Did not rec the letter/confirmation'?'selected':''; ?> value='Existing appointment - Did not rec the letter/confirmation'>Existing appointment - Did not rec the letter/confirmation</option>
												<option <?php echo $vfs_call['disposition']=='Fees'?'selected':''; ?> value='Fees'>Fees</option>
												<option <?php echo $vfs_call['disposition']=='Finance'?'selected':''; ?> value='Finance'>Finance</option>
												<option <?php echo $vfs_call['disposition']=='Follow Up Call'?'selected':''; ?> value='Follow Up Call'>Follow Up Call</option>
												<option <?php echo $vfs_call['disposition']=='Insurance'?'selected':''; ?> value='Insurance'>Insurance</option>
												<option <?php echo $vfs_call['disposition']=='Interview letter'?'selected':''; ?> value='Interview letter'>Interview letter</option>
												<option <?php echo $vfs_call['disposition']=='Interview process'?'selected':''; ?> value='Interview process'>Interview process</option>
												<option <?php echo $vfs_call['disposition']=='Job Related'?'selected':''; ?> value='Job Related'>Job Related</option>
												<option <?php echo $vfs_call['disposition']=='Holidays and working hours - Mission and VAC'?'selected':''; ?> value='Holidays and working hours - Mission and VAC'>Holidays and working hours - Mission and VAC</option>
												<option <?php echo $vfs_call['disposition']=='Legalization procedure'?'selected':''; ?> value='Legalization procedure'>Legalization procedure</option>
												<option <?php echo $vfs_call['disposition']=='Logistic Website'?'selected':''; ?> value='Logistic Website'>Logistic Website</option>
												<option <?php echo $vfs_call['disposition']=='Logistic Website Issue'?'selected':''; ?> value='Logistic Website Issue'>Logistic Website Issue</option>
												<option <?php echo $vfs_call['disposition']=='Manager'?'selected':''; ?> value='Manager'>Manager</option>
												<option <?php echo $vfs_call['disposition']=='Marketing'?'selected':''; ?> value='Marketing'>Marketing</option>
												<option <?php echo $vfs_call['disposition']=='Mea'?'selected':''; ?> value='Mea'>Mea</option>
												<option <?php echo $vfs_call['disposition']=='Mea - Attestation services'?'selected':''; ?> value='Mea - Attestation services'>Mea - Attestation services</option>
												<option <?php echo $vfs_call['disposition']=='MEA Fees'?'selected':''; ?> value='MEA Fees'>MEA Fees</option>
												<option <?php echo $vfs_call['disposition']=='New Appointment - Attestation'?'selected':''; ?> value='New Appointment - Attestation'>New Appointment - Attestation</option>
												<option <?php echo $vfs_call['disposition']=='New Appointment - CC to book'?'selected':''; ?> value='New Appointment - CC to book'>New Appointment - CC to book</option>
												<option <?php echo $vfs_call['disposition']=='New Appointment - How to book'?'selected':''; ?> value='New Appointment - How to book'>New Appointment - How to book</option>
												<option <?php echo $vfs_call['disposition']=='New Appointment - Slots not available'?'selected':''; ?> value='New Appointment - Slots not available'>New Appointment - Slots not available</option>
												<option <?php echo $vfs_call['disposition']=='New Appointment - Where to book'?'selected':''; ?> value='New Appointment - Where to book'>New Appointment - Where to book</option>
												<option <?php echo $vfs_call['disposition']=='Non Deliverable Address'?'selected':''; ?> value='Non Deliverable Address'>Non Deliverable Address</option>
												<option <?php echo $vfs_call['disposition']=='Non VFS mission related'?'selected':''; ?> value='Non VFS mission related'>Non VFS mission related</option>
												<option <?php echo $vfs_call['disposition']=='Not In Scope'?'selected':''; ?> value='Not In Scope'>Not In Scope</option>
												<option <?php echo $vfs_call['disposition']=='Nulla Osta Query'?'selected':''; ?> value='Nulla Osta Query'>Nulla Osta Query</option>
												<option <?php echo $vfs_call['disposition']=='Number Unreachable'?'selected':''; ?> value='Number Unreachable'>Number Unreachable</option>
												<option <?php echo $vfs_call['disposition']=='Other countries helpline number'?'selected':''; ?> value='Other countries helpline number'>Other countries helpline number</option>
												<option <?php echo $vfs_call['disposition']=='Others'?'selected':''; ?> value='Others'>Others</option>
												<option <?php echo $vfs_call['disposition']=='Outside SPT'?'selected':''; ?> value='Outside SPT'>Outside SPT</option>
												<option <?php echo $vfs_call['disposition']=='Passport & Document Submission'?'selected':''; ?> value='Passport & Document Submission'>Passport & Document Submission</option>
												<option <?php echo $vfs_call['disposition']=='Passport services'?'selected':''; ?> value='Passport services'>Passport services</option>
												<option <?php echo $vfs_call['disposition']=='Payment Methods'?'selected':''; ?> value='Payment Methods'>Payment Methods</option>
												<option <?php echo $vfs_call['disposition']=='PL'?'selected':''; ?> value='PL'>PL</option>
												<option <?php echo $vfs_call['disposition']=='PL Booked but not provided'?'selected':''; ?> value='PL Booked but not provided'>PL Booked but not provided</option>
												<option <?php echo $vfs_call['disposition']=='Postal pick-up'?'selected':''; ?> value='Postal pick-up'>Postal pick-up</option>
												<option <?php echo $vfs_call['disposition']=='Postpone interviews'?'selected':''; ?> value='Postpone interviews'>Postpone interviews</option>
												<option <?php echo $vfs_call['disposition']=='PP Hold Request'?'selected':''; ?> value='PP Hold Request'>PP Hold Request</option>
												<option <?php echo $vfs_call['disposition']=='Pre Payments'?'selected':''; ?> value='Pre Payments'>Pre Payments</option>
												<option <?php echo $vfs_call['disposition']=='Prime time services'?'selected':''; ?> value='Prime time services'>Prime time services</option>
												<option <?php echo $vfs_call['disposition']=='Privilege'?'selected':''; ?> value='Privilege'>Privilege</option>
												<option <?php echo $vfs_call['disposition']=='Processing Time'?'selected':''; ?> value='Processing Time'>Processing Time</option>
												<option <?php echo $vfs_call['disposition']=='Reference Number Not Generated'?'selected':''; ?> value='Reference Number Not Generated'>Reference Number Not Generated</option>
												<option <?php echo $vfs_call['disposition']=='Reschedule'?'selected':''; ?> value='Reschedule'>Reschedule</option>
												<option <?php echo $vfs_call['disposition']=='Resubmission of passport'?'selected':''; ?> value='Resubmission of passport'>Resubmission of passport</option>
												<option <?php echo $vfs_call['disposition']=='Routed to correct mission helpline'?'selected':''; ?> value='Routed to correct mission helpline'>Routed to correct mission helpline</option>
												<option <?php echo $vfs_call['disposition']=='Scanning Issue'?'selected':''; ?> value='Scanning Issue'>Scanning Issue</option>
												<option <?php echo $vfs_call['disposition']=='Security procedure at VFS centre'?'selected':''; ?> value='Security procedure at VFS centre'>Security procedure at VFS centre</option>
												<option <?php echo $vfs_call['disposition']=='Service Charge deducted twice'?'selected':''; ?> value='Service Charge deducted twice'>Service Charge deducted twice</option>
												<option <?php echo $vfs_call['disposition']=='Service Inadequate'?'selected':''; ?> value='Service Inadequate'>Service Inadequate</option>
												<option <?php echo $vfs_call['disposition']=='Service issue at VAC'?'selected':''; ?> value='Service issue at VAC'>Service issue at VAC</option>
												<option <?php echo $vfs_call['disposition']=='Services '?'selected':''; ?> value='Services '>Services </option>
												<option <?php echo $vfs_call['disposition']=='SMS Issue'?'selected':''; ?> value='SMS Issue'>SMS Issue</option>
												<option <?php echo $vfs_call['disposition']=='SMS Issue due to wrong PI'?'selected':''; ?> value='SMS Issue due to wrong PI'>SMS Issue due to wrong PI</option>
												<option <?php echo $vfs_call['disposition']=='SMS service'?'selected':''; ?> value='SMS service'>SMS service</option>
												<option <?php echo $vfs_call['disposition']=='Staff'?'selected':''; ?> value='Staff'>Staff</option>
												<option <?php echo $vfs_call['disposition']=='Student demand draft'?'selected':''; ?> value='Student demand draft'>Student demand draft</option>
												<option <?php echo $vfs_call['disposition']=='Student Questioner'?'selected':''; ?> value='Student Questioner'>Student Questioner</option>
												<option <?php echo $vfs_call['disposition']=='Submission process'?'selected':''; ?> value='Submission process'>Submission process</option>
												<option <?php echo $vfs_call['disposition']=='Submission Timing'?'selected':''; ?> value='Submission Timing'>Submission Timing</option>
												<option <?php echo $vfs_call['disposition']=='Supervisor'?'selected':''; ?> value='Supervisor'>Supervisor</option>
												<option <?php echo $vfs_call['disposition']=='Test Call'?'selected':''; ?> value='Test Call'>Test Call</option>
												<option <?php echo $vfs_call['disposition']=='Transfer to MEA'?'selected':''; ?> value='Transfer to MEA'>Transfer to MEA</option>
												<option <?php echo $vfs_call['disposition']=='Unable to download appointment letter'?'selected':''; ?> value='Unable to download appointment letter'>Unable to download appointment letter</option>
												<option <?php echo $vfs_call['disposition']=='Unable to login'?'selected':''; ?> value='Unable to login'>Unable to login</option>
												<option <?php echo $vfs_call['disposition']=='Unable to track application'?'selected':''; ?> value='Unable to track application'>Unable to track application</option>
												<option <?php echo $vfs_call['disposition']=='VAC'?'selected':''; ?> value='VAC'>VAC</option>
												<option <?php echo $vfs_call['disposition']=='VAC Requested'?'selected':''; ?> value='VAC Requested'>VAC Requested</option>
												<option <?php echo $vfs_call['disposition']=='VAYD'?'selected':''; ?> value='VAYD'>VAYD</option>
												<option <?php echo $vfs_call['disposition']=='VAYD booked but service not provided'?'selected':''; ?> value='VAYD booked but service not provided'>VAYD booked but service not provided</option>
												<option <?php echo $vfs_call['disposition']=='VFS centre Address details'?'selected':''; ?> value='VFS centre Address details'>VFS centre Address details</option>
												<option <?php echo $vfs_call['disposition']=='VFS Charges'?'selected':''; ?> value='VFS Charges'>VFS Charges</option>
												<option <?php echo $vfs_call['disposition']=='VFS Website'?'selected':''; ?> value='VFS Website'>VFS Website</option>
												<option <?php echo $vfs_call['disposition']=='VFS Website Issue'?'selected':''; ?> value='VFS Website Issue'>VFS Website Issue</option>
												<option <?php echo $vfs_call['disposition']=='VFS Website not updated'?'selected':''; ?> value='VFS Website not updated'>VFS Website not updated</option>
												<option <?php echo $vfs_call['disposition']=='Visa cancellation'?'selected':''; ?> value='Visa cancellation'>Visa cancellation</option>
												<option <?php echo $vfs_call['disposition']=='Visa Category'?'selected':''; ?> value='Visa Category'>Visa Category</option>
												<option <?php echo $vfs_call['disposition']=='Visa correction'?'selected':''; ?> value='Visa correction'>Visa correction</option>
												<option <?php echo $vfs_call['disposition']=='Visa Fees'?'selected':''; ?> value='Visa Fees'>Visa Fees</option>
												<option <?php echo $vfs_call['disposition']=='Visa Rules'?'selected':''; ?> value='Visa Rules'>Visa Rules</option>
												<option <?php echo $vfs_call['disposition']=='Visa Stamping details'?'selected':''; ?> value='Visa Stamping details'>Visa Stamping details</option>
												<option <?php echo $vfs_call['disposition']=='Walkin without Appointment'?'selected':''; ?> value='Walkin without Appointment'>Walkin without Appointment</option>
												<option <?php echo $vfs_call['disposition']=='Withdrawal'?'selected':''; ?> value='Withdrawal'>Withdrawal</option>
												<option <?php echo $vfs_call['disposition']=='Within SPT'?'selected':''; ?> value='Within SPT'>Within SPT</option>
												<option <?php echo $vfs_call['disposition']=='Wrong Number'?'selected':''; ?> value='Wrong Number'>Wrong Number</option>
											</select>
										</td>
										<td></td>
										<td><!-- <textarea class="form-control" name="comm19"><?php //echo $vfs_call['comm19'] ?></textarea> --></td>
									</tr>
									<tr>
										<td></td>
										<td colspan=1>b. Communication mode through which customer contacted previously</td>
										<td></td>
										<td>
											<input type="text" class="form-control" id="contacted_previously" name="contacted_previously" value="<?php echo $vfs_call['contacted_previously']; ?>">
										</td>
										<td id=""></td>
										<td></td>
									</tr>
									<tr>
										<td></td>
										<td colspan=1>c. Description of Disposition selected</td>
										<td></td>
										<td>
											<input type="text" class="form-control" id="disposition_selected" name="disposition_selected" value="<?php echo $vfs_call['disposition_selected']; ?>">
										</td>
										<td id=""></td>
										<td></td>
									</tr>
									<tr>
										<td></td>
										<td colspan=1>d. Was this the first time customer called us ?</td>
										<td></td>
										<td>
											<select class="form-control" id="customer_called_first" name="customer_called_first" >
												<option value="">-Select-</option>
												<option <?php echo $vfs_call['customer_called_first']=='No'?"selected":""; ?> value="No">No</option>
												<option <?php echo $vfs_call['customer_called_first']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
											</select>
										</td>
										<td id=""></td>
										<td><textarea class="form-control" name="comm24"><?php echo $vfs_call['comm24'] ?></textarea></td>
									</tr>
									<tr>
										<td></td>
										<td colspan=1>e. Did the customer call us more than once but less than 3 times ?</td>
										<td></td>
										<td>
											<select class="form-control" id="customer_called_less_three" name="customer_called_less_three">
												<option value="">-Select-</option>
												<option <?php echo $vfs_call['customer_called_less_three']=='No'?"selected":""; ?> value="No">No</option>
												<option <?php echo $vfs_call['customer_called_less_three']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
											</select>
										</td>
										<td id=""></td>
										<td><textarea class="form-control" name="comm25"><?php echo $vfs_call['comm25'] ?></textarea></td>
									</tr>
									<tr>
										<td></td>
										<td colspan=1>f. Did the customer call us more than 3 times ?</td>
										<td></td>
										<td>
											<select class="form-control" id="customer_called_more_three" name="customer_called_more_three">
												<option value="">-Select-</option>
												<option <?php echo $vfs_call['customer_called_more_three']=='No'?"selected":""; ?> value="No">No</option>
												<option <?php echo $vfs_call['customer_called_more_three']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
											</select>
										</td>
										<td id=""></td>
										<td><textarea class="form-control" name="comm26"><?php echo $vfs_call['comm26'] ?></textarea></td>
									</tr>
									<tr>
										<td>Reason For Fatal Error:</td>
										<td colspan=2><textarea class="form-control"  name="reason_for_fatal"><?php echo $vfs_call['reason_for_fatal'] ?></textarea></td>
										<td>Improvement Area:</td>
										<td colspan=2><textarea class="form-control"  name="inprovement_area"><?php echo $vfs_call['inprovement_area'] ?></textarea></td>
									</tr>
									<tr>
										<td>QA Remarks:</td>
										<td colspan=2><textarea class="form-control"  name="call_summary"><?php echo $vfs_call['call_summary'] ?></textarea></td>
										<!--<td>Feedback:</td>
										<td colspan=2><textarea class="form-control"  name="feedback"><?php echo $vfs_call['feedback'] ?></textarea></td>-->
									</tr>
									<tr>
										<td colspan="2">Upload Files [m4a,mp4,mp3,wav]</td>
										<?php if($call_id==0){ ?>
											<td colspan=4>
												<input type="file" name="attach_file[]" id="attach_file" accept=".m4a,.mp4,.mp3,.wav,audio/*" />
											</td>
										<?php }else{ 
											if($vfs_call['attach_file']!=''){ ?>
											<td colspan="4">
												<input type="file" multiple class="form-control"  id="attach_file" name="attach_file[]" accept=".m4a,.mp4,.mp3,.wav,audio/*"> 
												<?php $attach_file = explode(",",$vfs_call['attach_file']);
												 foreach($attach_file as $mp){ ?>
													<audio controls='' style="background-color:#607F93"> 
													  <source src="<?php echo base_url(); ?>qa_files/qa_vfs/call/<?php echo $mp; ?>" type="audio/ogg">
													  <source src="<?php echo base_url(); ?>qa_files/qa_vfs/call/<?php echo $mp; ?>" type="audio/mpeg">
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
										
									<?php if($call_id!=0){ ?>
										<tr><td colspan=2 style="font-size:16px; font-weight:bold">Agent Review:</td><td colspan=4><?php echo $vfs_call['agent_rvw_note'] ?></td></tr>
										<tr><td colspan=2 style="font-size:16px; font-weight:bold">Management Review:</td><td colspan=4><?php echo $vfs_call['mgnt_rvw_note'] ?></td></tr>
										<tr><td colspan=2 style="font-size:16px; font-weight:bold">Client Review:</td><td colspan=4><?php echo $vfs_call['client_rvw_note'] ?></td></tr>
										
										<tr><td colspan=2  style="font-size:16px">Your Review</td><td colspan=4><textarea class="form-control1" style="width:100%" id="note" name="note" required></textarea></td></tr>
									<?php } ?>
										
									<?php 
									if($call_id==0){
										if(is_access_qa_module()==true || is_access_qa_operations_module()==true){ ?>
											<tr><td colspan=6><button class="btn btn-success waves-effect" type="submit" id="qaformsubmit" style="width:500px">SAVE</button></td></tr>
									<?php 
										} 
									}else{ 
										if(is_access_qa_module()==true || is_access_qa_operations_module()==true){
											if(is_available_qa_feedback($vfs_call['entry_date'],72) == true){ ?>
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
