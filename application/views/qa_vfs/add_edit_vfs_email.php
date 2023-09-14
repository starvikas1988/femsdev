
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

#fatalspan2{

	background-color: transparent;
	border: none;
	outline: none;
}

.ui-datepicker .ui-datepicker-buttonpane button.ui-datepicker-current {
	 float: left;
	 display: none;
	}

</style>

<?php if($email_id!=0){
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
										<td colspan="6" id="theader">VFS Email Monitoring Form 
										<input type="hidden" name="audit_start_time" value="<?php echo CurrMySqlDate(); ?>">
									</tr>
									<tr>
									<?php
										if($email_id==0){
											$auditorName = get_username();
											$auditDate = CurrDateMDY();
											$clDate_val='';
										}else{
											if($vfs_email['entry_by']!=''){
												$auditorName = $vfs_email['auditor_name'];
											}else{
												$auditorName = $vfs_email['client_name'];
											}
											$auditDate = mysql2mmddyy($vfs_email['audit_date']);
											$clDate_val=mysql2mmddyy($vfs_email['call_date']);
										}
									?>
										<td>QA Name:<span style="font-size:24px;color:red">*</span></td>
										<td style="width:300px"><input type="text" class="form-control" value="<?php echo $auditorName; ?>" disabled></td>
										<td style="width:150px">Audit Date:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control" value="<?php echo $auditDate; ?>" disabled></td>
										<td>Email Date:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control" id="call_date" name="call_date" onkeydown="return false;" value="<?php echo $clDate_val; ?>" required></td>
									</tr>
									<tr>
										<td>Agent Name:<span style="font-size:24px;color:red">*</span></td>
										<td>
											<select class="form-control" id="agent_id" name="agent_id" required>
												<?php 
												if($vfs_email['agent_id']!=''){
													?>
													<option value="<?php echo $vfs_email['agent_id'] ?>"><?php echo $vfs_email['fname']." ".$vfs_email['lname'] ?></option>
													<?php
												}
												?>
												
												<option value="">-Select-</option>
												<?php foreach($agentName as $row):  ?>
													<option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
												<?php endforeach; ?>
											</select>
										</td>
										<td>Employee ID:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control" id="fusion_id" name="" value="<?php echo $vfs_email['fusion_id']; ?>" readonly></td>
										<td>L1 Supervisor:<span style="font-size:24px;color:red">*</span></td>
										<td style="width:250px">
											<input type="text" class="form-control" id="tl_name"  value="<?php echo $vfs_email['tl_name']; ?>" readonly>
												<input type="hidden" class="form-control" id="tl_id" name="tl_id" value="<?php echo $vfs_email['tl_id'] ?>" required>
										</td>
									</tr>
									<tr>
										<td>Email Responded Within:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control" id="" name="call_duration" value="<?php echo $vfs_email['call_duration']; ?>" required></td>
										<!-- <td><input type="text" class="form-control" id="call_duration" name="call_duration" onkeydown="return false;" value="<?php echo $vfs_email['call_duration']; ?>" required></td> -->
										<td>Mission:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control"  name="mission" value="<?php echo $vfs_email['mission']; ?>" required></td>
										<td>Recording ID:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control"  name="recording_id" value="<?php echo $vfs_email['recording_id']; ?>" required></td>
									</tr>
									<tr>
										<td>Week:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control"  name="week" value="<?php echo $vfs_email['week']; ?>" required></td>
										
										<td>Fatal Error?:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control" id="fatalspan2" name="autofail_status" value="<?php echo $vfs_email['autofail_status']; ?>" readonly></td>
										<!-- <td>
											<select class="form-control" id="" name="autofail_status" required>
												<option value="">-Select-</option>
												<option <?php echo $vfs_email['autofail_status']=='Fatal'?"selected":""; ?> value="Fatal">Fatal</option>
												<option <?php echo $vfs_email['autofail_status']=='Non Fatal'?"selected":""; ?> value="Non Fatal">Non Fatal</option>
											</select> 
										</td> -->
										<td>Host/Country:</td>
										<td>
											<select class="form-control" name="host_country" required>
												<option value=''>-Select-</option>
												<option <?php echo $vfs_email['host_country']=='Philippines' ? 'selected' :'';  ?>  value='Philippines'>Philippines</option>
												<option <?php echo $vfs_email['host_country']=='Australia' ? 'selected' :'';  ?>  value='Australia'>Australia</option>
												<option <?php echo $vfs_email['host_country']=='New Zealand' ? 'selected' :'';  ?>  value='New Zealand'>New Zealand</option>
												<option <?php echo $vfs_email['host_country']=='Singapore' ? 'selected' :'';  ?>  value='Singapore'>Singapore</option>
												<option <?php echo $vfs_email['host_country']=='Thailand' ? 'selected' :'';  ?>  value='Thailand'>Thailand</option>
												<option <?php echo $vfs_email['host_country']=='Indonesia' ? 'selected' :'';  ?>  value='Indonesia'>Indonesia</option>
												<option <?php echo $vfs_email['host_country']=='Malaysia' ? 'selected' :'';  ?>  value='Malaysia'>Malaysia</option>
											</select>
										</td>
									</tr>
									<tr>
										<td>Agent Tenurity:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control" name="tenurity" id="tenure" value="<?php echo $vfs_email['tenurity']; ?>" readonly></td>
										<td>VOC:<span style="font-size:24px;color:red">*</span></td>
										<td>
											<select class="form-control" id="voc" name="voc" required>
												<option value="">-Select-</option>
												<option <?php echo $vfs_email['voc']=='1'?"selected":""; ?> value="1">1</option>
												<option <?php echo $vfs_email['voc']=='2'?"selected":""; ?> value="2">2</option>
												<option <?php echo $vfs_email['voc']=='3'?"selected":""; ?> value="3">3</option>
												<option <?php echo $vfs_email['voc']=='4'?"selected":""; ?> value="4">4</option>
												<option <?php echo $vfs_email['voc']=='5'?"selected":""; ?> value="5">5</option>
											</select>
										</td>
										<td>ACPT:<span style="font-size:24px;color:red">*</span></td>
										<td>
												<select class="form-control" id="" name="acpt" required>
													<option value="">-Select-</option>
													<option value="Agent"  <?= ($vfs_email['acpt']=="Agent")?"selected":"" ?>>Agent</option>
													<option value="Process"  <?= ($vfs_email['acpt']=="Process")?"selected":"" ?>>Process</option>
													<option value="Customer"  <?= ($vfs_email['acpt']=="Customer")?"selected":"" ?>>Customer</option>
													<option value="Technology"  <?= ($vfs_email['acpt']=="Technology")?"selected":"" ?>>Technology</option>
													<option value="NA"  <?= ($vfs_email['acpt']=="NA")?"selected":"" ?>>NA</option>
												</select>
											</td>
									</tr>
									<tr>
										<td>Audit Type:<span style="font-size:24px;color:red">*</span></td>
										<td>
											<select class="form-control" id="audit_type" name="audit_type" required>
												<option value="">-Select-</option>
												<option value="CQ Audit" <?= ($vfs_email['audit_type']=="CQ Audit")?"selected":"" ?>>CQ Audit</option>
												<option value="BQ Audit" <?= ($vfs_email['audit_type']=="BQ Audit")?"selected":"" ?>>BQ Audit</option>
												<option value="Calibration" <?= ($vfs_email['audit_type']=="Calibration")?"selected":"" ?>>Calibration</option>
												<option value="Pre-Certificate Mock Call" <?= ($vfs_email['audit_type']=="Pre-Certificate Mock Call")?"selected":"" ?>>Pre-Certificate Mock Call</option>
												<option value="Certification Audit" <?= ($vfs_email['audit_type']=="Certification Audit")?"selected":"" ?>>Certification Audit</option>
												<option value="WoW Call"  <?= ($vfs_email['audit_type']=="WoW Call")?"selected":"" ?>>WoW Call</option>
												<option value="Hygiene Audit"  <?= ($vfs_email['audit_type']=="Hygiene Audit")?"selected":"" ?>>Hygiene Audit</option>
												<option value="Operation Audit"  <?= ($vfs_email['audit_type']=="Operation Audit")?"selected":"" ?>>Operation Audit</option>
												<option value="Trainer Audit"  <?= ($vfs_email['audit_type']=="Trainer Audit")?"selected":"" ?>>Trainer Audit</option> 
												<option value="QA Supervisor Audit"  <?= ($vfs_email['audit_type']=="QA Supervisor Audit")?"selected":"" ?>>QA Supervisor Audit</option> 
											</select>
										</td>
										<td>L1:<span style="font-size:24px;color:red">*</span></td>
										<td>
											<select class="form-control" name="l1" required>
												<option value=''>-Select-</option>
												<option <?php echo $vfs_email['l1']=='Application related' ? 'selected' :'';  ?>  value='Application related'>Application related</option>
												<option <?php echo $vfs_email['l1']=='Appointment Related' ? 'selected' :'';  ?>  value='Appointment Related'>Appointment Related</option>
												<option <?php echo $vfs_email['l1']=='Consulate Related' ? 'selected' :'';  ?>  value='Consulate Related'>Consulate Related</option>
												<option <?php echo $vfs_email['l1']=='Courier Related' ? 'selected' :'';  ?>  value='Courier Related'>Courier Related</option>
												<option <?php echo $vfs_email['l1']=='Customer Perception' ? 'selected' :'';  ?>  value='Customer Perception'>Customer Perception</option>
												<option <?php echo $vfs_email['l1']=='Process Limitation' ? 'selected' :'';  ?>  value='Process Limitation'>Process Limitation</option>
												<option <?php echo $vfs_email['l1']=='Process not followed' ? 'selected' :'';  ?>  value='Process not followed'>Process not followed</option>
												<option <?php echo $vfs_email['l1']=='Soft Skills' ? 'selected' :'';  ?>  value='Soft Skills'>Soft Skills</option>
												<option <?php echo $vfs_email['l1']=='Website Related' ? 'selected' :'';  ?>  value='Website Related'>Website Related</option>
												<option <?php echo $vfs_email['l1']=='System Limitation' ? 'selected' :'';  ?>  value='System Limitation'>System Limitation</option>
												<option <?php echo $vfs_email['l1']=='System Downtime' ? 'selected' :'';  ?>  value='System Downtime'>System Downtime</option>
												<option <?php echo $vfs_email['l1']=='Knowledge Gap' ? 'selected' :'';  ?>  value='Knowledge Gap'>Knowledge Gap</option>
												<option <?php echo $vfs_email['l1']=='Communication Gap' ? 'selected' :'';  ?>  value='Communication Gap'>Communication Gap</option>
												<option <?php echo $vfs_email['l1']=='Skill Issue' ? 'selected' :'';  ?>  value='Skill Issue'>Skill Issue</option>
												<option <?php echo $vfs_email['l1']=='Behavioral Issue' ? 'selected' :'';  ?>  value='Behavioral Issue'>Behavioral Issue</option>
											</select>
										</td>
										<td>L2:<span style="font-size:24px;color:red">*</span></td>
										<td>
											<select class="form-control" name="l2" required>
												<option value=''>-Select-</option>
												<option <?php echo $vfs_email['l2']=='Application under process' ? 'selected' :'';  ?>  value='Application under process'>Application under process</option>
												<option <?php echo $vfs_email['l2']=='Correct & Complete Information Provided' ? 'selected' :'';  ?>  value='Correct & Complete Information Provided'>Correct & Complete Information Provided</option>
												<option <?php echo $vfs_email['l2']=='Delay in lodging' ? 'selected' :'';  ?>  value='Delay in lodging'>Delay in lodging</option>
												<option <?php echo $vfs_email['l2']=='E - visa related' ? 'selected' :'';  ?>  value='E - visa related'>E - visa related</option>
												<option <?php echo $vfs_email['l2']=='Incorrect Information provided' ? 'selected' :'';  ?>  value='Incorrect Information provided'>Incorrect Information provided</option>
												<option <?php echo $vfs_email['l2']=='Lack of Attentiveness' ? 'selected' :'';  ?>  value='Lack of Attentiveness'>Lack of Attentiveness</option>
												<option <?php echo $vfs_email['l2']=='Lack of courteous and professional' ? 'selected' :'';  ?>  value='Lack of courteous and professional'>Lack of courteous and professional</option>
												<option <?php echo $vfs_email['l2']=='Not authorised to book an appointment' ? 'selected' :'';  ?>  value='Not authorised to book an appointment'>Not authorised to book an appointment</option>
												<option <?php echo $vfs_email['l2']=='Not authorised to confirm the information' ? 'selected' :'';  ?>  value='Not authorised to confirm the information'>Not authorised to confirm the information</option>
												<option <?php echo $vfs_email['l2']=='Other countries query' ? 'selected' :'';  ?>  value='Other countries query'>Other countries query</option>
												<option <?php echo $vfs_email['l2']=='Passport not delivered' ? 'selected' :'';  ?>  value='Passport not delivered'>Passport not delivered</option>
												<option <?php echo $vfs_email['l2']=='Slots not available' ? 'selected' :'';  ?>  value='Slots not available'>Slots not available</option>
												<option <?php echo $vfs_email['l2']=='Unable to fill application form' ? 'selected' :'';  ?>  value='Unable to fill application form'>Unable to fill application form</option>
												<option <?php echo $vfs_email['l2']=='Unable to login' ? 'selected' :'';  ?>  value='Unable to login'>Unable to login</option>
												<option <?php echo $vfs_email['l2']=='Unable to reach the consulate' ? 'selected' :'';  ?>  value='Unable to reach the consulate'>Unable to reach the consulate</option>
												<option <?php echo $vfs_email['l2']=='Process Query' ? 'selected' :'';  ?>  value='Process Query'>Process Query</option>
												<option <?php echo $vfs_email['l2']=='Out of scope issues' ? 'selected' :'';  ?>  value='Out of scope issues'>Out of scope issues</option>
												<option <?php echo $vfs_email['l2']=='CX is not aware that the information is available on the website' ? 'selected' :'';  ?>  value='CX is not aware that the information is available on the website'>CX is not aware that the information is available on the website</option>
												<option <?php echo $vfs_email['l2']=='Agent needs to coordinate first with VAC for the information' ? 'selected' :'';  ?>  value='Agent needs to coordinate first with VAC for the information'>Agent needs to coordinate first with VAC for the information</option>
												<option <?php echo $vfs_email['l2']=='Internet Issue' ? 'selected' :'';  ?>  value='Internet Issue'>Internet Issue</option>
												<option <?php echo $vfs_email['l2']=='Hardware Issue' ? 'selected' :'';  ?>  value='Hardware Issue'>Hardware Issue</option>
												<option <?php echo $vfs_email['l2']=='Tool/Software Inaccessible' ? 'selected' :'';  ?>  value='Tool/Software Inaccessible'>Tool/Software Inaccessible</option>
												<option <?php echo $vfs_email['l2']=='Ineffective Training' ? 'selected' :'';  ?>  value='Ineffective Training'>Ineffective Training</option>
												<option <?php echo $vfs_email['l2']=='Poor Retention' ? 'selected' :'';  ?>  value='Poor Retention'>Poor Retention</option>
												<option <?php echo $vfs_email['l2']=='Poor update cascade' ? 'selected' :'';  ?>  value='Poor update cascade'>Poor update cascade</option>
												<option <?php echo $vfs_email['l2']=='Language Barrier' ? 'selected' :'';  ?>  value='Language Barrier'>Language Barrier</option>
												<option <?php echo $vfs_email['l2']=='Poor Comprehension' ? 'selected' :'';  ?>  value='Poor Comprehension'>Poor Comprehension</option>
												<option <?php echo $vfs_email['l2']=='Poor Communication Skill' ? 'selected' :'';  ?>  value='Poor Communication Skill'>Poor Communication Skill</option>
												<option <?php echo $vfs_email['l2']=='Poor Multi-tasking Skill' ? 'selected' :'';  ?>  value='Poor Multi-tasking Skill'>Poor Multi-tasking Skill</option>
											</select>
										</td>
									</tr>
									<tr>
										<td class="auType">Auditor Type:<span style="font-size:24px;color:red">*</span></td>
										<td class="auType">
											<select class="form-control" id="auditor_type" name="auditor_type">
												<option value="">-Select-</option>
												 <option value="Master" <?= ($vfs_email['auditor_type']=="Master")?"selected":"" ?>>Master</option> 
												 <option value="Regular" <?= ($vfs_email['auditor_type']=="Regular")?"selected":"" ?>>Regular</option> 
											</select>
										</td>
									</tr>
									<tr>
										<td style="font-weight:bold">Earned Score:</td>
										<td><input type="text" readonly id="vfsEarned" name="earned_score" class="form-control" style="font-weight:bold" value="<?php echo $vfs_email['overall_score'] ?>"></td>
										<td style="font-weight:bold">Possible Score:</td>
										<td><input type="text" readonly id="vfsPossible" name="possible_score" class="form-control" style="font-weight:bold" value="<?php echo $vfs_email['overall_score'] ?>"></td>
										<td style="font-weight:bold">Overall Score Percentage:</td>
										<td><input type="text" readonly id="vfsOverallScore" name="overall_score" class="form-control vfsEmailFatal" style="font-weight:bold" value="<?php echo $vfs_email['overall_score'] ?>"></td>
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
										<td colspan=1 style="background-color:#BFC9CA">Content Writing (Look and feel)</td>
										<td style="background-color:#BFC9CA">11</td>
										<td style="background-color:#BFC9CA"></td>
										<td style="background-color:#BFC9CA" id="score_content_writing">11</td>
										<td style="background-color:#BFC9CA" ></td>
									</tr>
									
									<tr>
										<td></td>
										<td colspan=1>a. Greeting & Salutation used correctly</td>
										<td>3</td>
										<td>
											<select class="form-control vfsVal"  data-id="content_writing" name="salutation" required>
												<option vfs_val=3 vfs_max='3' <?php echo $vfs_email['salutation']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option vfs_val=0 vfs_max='3' <?php echo $vfs_email['salutation']=='No'?"selected":""; ?> value="No">No</option>
												<option vfs_val=0 vfs_max='3' <?php echo $vfs_email['salutation']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td id="score_salutation">3</td>
										<td><textarea class="form-control" name="comm1"><?php echo $vfs_email['comm1'] ?></textarea></td>
									</tr>
									<tr>
										<td></td>
										<td colspan=1>b. Used bullet points where appropriate</td>
										<td>3</td>
										<td>
											<select class="form-control vfsVal"  data-id="content_writing" name="use_bullet_point" required>
												<option vfs_val=3 vfs_max='3' <?php echo $vfs_email['use_bullet_point']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option vfs_val=0 vfs_max='3' <?php echo $vfs_email['use_bullet_point']=='No'?"selected":""; ?> value="No">No</option>
												<option vfs_val=0 vfs_max='3' <?php echo $vfs_email['use_bullet_point']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td id="score_use_bullet_point">3</td>
										<td><textarea class="form-control" name="comm2"><?php echo $vfs_email['comm2'] ?></textarea></td>
									</tr>
									
									<tr>
										<td></td>
										<td colspan=1>c. Used one idea per paragraph & Simple & definite statements</td>
										<td>2</td>
										<td>
											<select class="form-control vfsVal"  data-id="content_writing" name="definite_statements" required>
												<option vfs_val=2 vfs_max='2' <?php echo $vfs_email['definite_statements']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option vfs_val=0 vfs_max='2'  <?php echo $vfs_email['definite_statements']=='No'?"selected":""; ?> value="No">No</option>
												<option vfs_val=0 vfs_max='2' <?php echo $vfs_email['definite_statements']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td id="score_definite_statements">2</td>
										<td><textarea class="form-control" name="comm3"><?php echo $vfs_email['comm3'] ?></textarea></td>
									</tr>
									<tr>
										<td></td>
										<td colspan=1>d. Template Adherence where applicable</td>
										<td>3</td>
										<td>
											<select class="form-control vfsVal"  data-id="content_writing" name="template_adherence" required>
												<option vfs_val=3 vfs_max='3' <?php echo $vfs_email['template_adherence']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option vfs_val=0 vfs_max='3' <?php echo $vfs_email['template_adherence']=='No'?"selected":""; ?> value="No">No</option>
												<option vfs_val=0 vfs_max='3' <?php echo $vfs_email['template_adherence']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td id="score_template_adherence">3</td>
										<td><textarea class="form-control" name="comm4"><?php echo $vfs_email['comm4'] ?></textarea></td>
									</tr>
									<tr>
										<td style="background-color:#BFC9CA"><b>2</b></td>
										<td colspan=1 style="background-color:#BFC9CA">Accuracy / follow up </td>
										<td style="background-color:#BFC9CA">42</td>
										<td style="background-color:#BFC9CA"></td>
										<td style="background-color:#BFC9CA" id="score_accuracy">42</td>
										<td style="background-color:#BFC9CA" ></td>
									</tr>
									<tr>
										<td></td>
										<td colspan=1>a. Interim response provided (if applicable) & trail answered as per TAT provided</td>
										<td>3</td>
										<td>
											<select class="form-control vfsVal" data-id="accuracy" name="interim_responce" required>
												<option vfs_val=3 vfs_max='3' <?php echo $vfs_email['interim_responce']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option vfs_val=0 vfs_max='3' <?php echo $vfs_email['interim_responce']=='No'?"selected":""; ?> value="No">No</option>
												<option vfs_val=0 vfs_max='3' <?php echo $vfs_email['interim_responce']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td id="score_interim_responce">3</td>
										<td><textarea class="form-control" name="comm5"><?php echo $vfs_email['comm5'] ?></textarea></td>
									</tr>
									<tr>
										<td></td>
										<td colspan=1>b. FCR achieved</td>
										<td>11</td>
										<td>
											<select class="form-control vfsVal"  data-id="accuracy" name="FCR_achieved" required>
												<option vfs_val=11 vfs_max='11' <?php echo $vfs_email['FCR_achieved']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option vfs_val=0 vfs_max='11' <?php echo $vfs_email['FCR_achieved']=='No'?"selected":""; ?> value="No">No</option>
												<option vfs_val=0 vfs_max='11' <?php echo $vfs_email['FCR_achieved']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td id="score_FCR_achieved">11</td>
										<td><textarea class="form-control" name="comm6"><?php echo $vfs_email['comm6'] ?></textarea></td>
									</tr>
									<tr>
										<td></td>
										<td colspan=1>c. Complete and accurate information</td>
										<td>11</td>
										<td>
											<select class="form-control vfsVal"  data-id="accuracy" name="complete_information" required>
												<option vfs_val=11 vfs_max='11' <?php echo $vfs_email['complete_information']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option vfs_val=0 vfs_max='11' <?php echo $vfs_email['complete_information']=='No'?"selected":""; ?> value="No">No</option>
												<option vfs_val=0 vfs_max='11' <?php echo $vfs_email['complete_information']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td id="score_complete_information">11</td>
										<td><textarea class="form-control" name="comm7"><?php echo $vfs_email['comm7'] ?></textarea></td>
									</tr>
									
									<tr>
										<td></td>
										<td colspan=1>d. Understand the issue of the customer & Attentiveness displayed</td>
										<td>9</td>
										<td>
											<select class="form-control vfsVal"  data-id="accuracy" name="customer_attentiveness" required>
												<option vfs_val=9 vfs_max='9' <?php echo $vfs_email['customer_attentiveness']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option vfs_val=0 vfs_max='9' <?php echo $vfs_email['customer_attentiveness']=='No'?"selected":""; ?> value="No">No</option>
												<option vfs_val=0 vfs_max='9' <?php echo $vfs_email['customer_attentiveness']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td id="score_customer_attentiveness">9</td>
										<td><textarea class="form-control" name="comm8"><?php echo $vfs_email['comm8'] ?></textarea></td>
									</tr>
									
									<tr>
										<td></td>
										<td colspan=1>e. Used all the available resources for providing resolution</td>
										<td>4</td>
										<td>
											<select class="form-control vfsVal"  data-id="accuracy" name="use_available_resource" required>
												<option vfs_val=4 vfs_max='4' <?php echo $vfs_email['use_available_resource']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option vfs_val=0 vfs_max='4' <?php echo $vfs_email['use_available_resource']=='No'?"selected":""; ?> value="No">No</option>
												<option vfs_val=0 vfs_max='4' <?php echo $vfs_email['use_available_resource']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td id="score_use_available_resource">4</td>
										<td><textarea class="form-control" name="comm9"><?php echo $vfs_email['comm9'] ?></textarea></td>
									</tr>
									<tr>
										<td></td>
										<td colspan=1>f. Standardized subject line on trail mails</td>
										<td>4</td>
										<td>
											<select class="form-control vfsVal"  data-id="accuracy" name="standardized_subject" required>
												<option vfs_val=4 vfs_max='4' <?php echo $vfs_email['standardized_subject']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option vfs_val=0 vfs_max='4' <?php echo $vfs_email['standardized_subject']=='No'?"selected":""; ?> value="No">No</option>
												<option vfs_val=0 vfs_max='4' <?php echo $vfs_email['standardized_subject']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td id="score_standardized_subject">4</td>
										<td><textarea class="form-control" name="comm10"><?php echo $vfs_email['comm10'] ?></textarea></td>
									</tr>
									<tr>
										<td style="background-color:#BFC9CA"><b>3</b></td>
										<td colspan=1 style="background-color:#BFC9CA">Additions</td>
										<td style="background-color:#BFC9CA">20</td>
										<td style="background-color:#BFC9CA"></td>
										<td style="background-color:#BFC9CA" id="score_additions">20</td>
										<td style="background-color:#BFC9CA" ></td>
									</tr>
									<tr>
										<td></td>
										<td colspan=1>a. Offers VAS options wherever applicable</td>
										<td>10</td>
										<td>
											<select class="form-control vfsVal"  data-id="additions" name="VAS_option" required>
												<option vfs_val=10 vfs_max='10' <?php echo $vfs_email['VAS_option']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option vfs_val=0 vfs_max='10' <?php echo $vfs_email['VAS_option']=='No'?"selected":""; ?> value="No">No</option>
												<option vfs_val=0 vfs_max='10' <?php echo $vfs_email['VAS_option']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td id="score_VAS_option">10</td>
										<td><textarea class="form-control" name="comm11"><?php echo $vfs_email['comm11'] ?></textarea></td>
									</tr>
									<tr>
										<td></td>
										<td colspan=1>b. Awareness created with regards to VFS website (wherever applicable)</td>
										<td>10</td>
										<td>
											<select class="form-control vfsVal"  data-id="additions" name="awarreness_created" required>
												<option vfs_val=10 vfs_max='10' <?php echo $vfs_email['awarreness_created']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option vfs_val=0 vfs_max='10' <?php echo $vfs_email['awarreness_created']=='No'?"selected":""; ?> value="No">No</option>
												<option vfs_val=0 vfs_max='10' <?php echo $vfs_email['awarreness_created']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td id="score_awarreness_created">10</td>
										<td><textarea class="form-control" name="comm12"><?php echo $vfs_email['comm12'] ?></textarea></td>
									</tr>
									<tr>
										<td style="background-color:#BFC9CA"><b>4</b></td>
										<td colspan=1 style="background-color:#BFC9CA">Tool/Application Documentation</td>
										<td style="background-color:#BFC9CA">5</td>
										<td style="background-color:#BFC9CA"></td>
										<td style="background-color:#BFC9CA" id="score_Documentation">5</td>
										<td style="background-color:#BFC9CA" ></td>
									</tr>
									<tr>
										<td></td>
										<td colspan=1>a. Correct dispostion</td>
										<td>5</td>
										<td>
											<select class="form-control vfsVal"  data-id="Documentation" name="correct_disposition" required>
												<option vfs_val=5 vfs_max='5' <?php echo $vfs_email['correct_disposition']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option vfs_val=0 vfs_max='5' <?php echo $vfs_email['correct_disposition']=='No'?"selected":""; ?> value="No">No</option>
												<option vfs_val=0 vfs_max='5' <?php echo $vfs_email['correct_disposition']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td id="score_correct_disposition">5</td>
										<td><textarea class="form-control" name="comm13"><?php echo $vfs_email['comm13'] ?></textarea></td>
									</tr>
									
									<tr>
										<td style="background-color:#BFC9CA"><b>5</b></td>
										<td colspan=1 style="background-color:#BFC9CA">Composition</td>
										<td style="background-color:#BFC9CA">22</td>
										<td style="background-color:#BFC9CA"></td>
										<td style="background-color:#BFC9CA" id="score_Composition">22</td>
										<td style="background-color:#BFC9CA" ></td>
									</tr>
									<tr>
										<td></td>
										<td colspan=1>a. Formatting</td>
										<td>3</td>
										<td>
											<select class="form-control vfsVal" data-id="Composition" name="formatting" required>
												<option vfs_val=3 vfs_max='3' <?php echo $vfs_email['formatting']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option vfs_val=0 vfs_max='3' <?php echo $vfs_email['formatting']=='No'?"selected":""; ?> value="No">No</option>
												<option vfs_val=0 vfs_max='3' <?php echo $vfs_email['formatting']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td id="score_formatting">3</td>
										<td><textarea class="form-control" name="comm14"><?php echo $vfs_email['comm14'] ?></textarea></td>
									</tr>
									<tr>
										<td></td>
										<td colspan=1>b. Telling the customer what to do next, Step by step procedure guide</td>
										<td>3</td>
										<td>
											<select class="form-control vfsVal" data-id="Composition" name="procedure_guide_step" required>
												<option vfs_val=3 vfs_max='3' <?php echo $vfs_email['procedure_guide_step']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option vfs_val=0 vfs_max='3' <?php echo $vfs_email['procedure_guide_step']=='No'?"selected":""; ?> value="No">No</option>
												<option vfs_val=0 vfs_max='3' <?php echo $vfs_email['procedure_guide_step']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td id="score_procedure_guide_step">3</td>
										<td><textarea class="form-control" name="comm15"><?php echo $vfs_email['comm15'] ?></textarea></td>
									</tr>
									<tr>
										<td></td>
										<td colspan=1>c. Avoid Slangs  & Jargons</td>
										<td>3</td>
										<td>
											<select class="form-control vfsVal"  data-id="Composition" name="avoid_slangs" required>
												<option vfs_val=3 vfs_max='3' <?php echo $vfs_email['avoid_slangs']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option vfs_val=0 vfs_max='3' <?php echo $vfs_email['avoid_slangs']=='No'?"selected":""; ?> value="No">No</option>
												<option vfs_val=0 vfs_max='3' <?php echo $vfs_email['avoid_slangs']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td id="score_avoid_slangs">3</td>
										<td><textarea class="form-control" name="comm16"><?php echo $vfs_email['comm16'] ?></textarea></td>
									</tr>
									<tr>
										<td></td>
										<td colspan=1>d. Correct and accurate grammar usage</td>
										<td>6</td>
										<td>
											<select class="form-control vfsVal"  data-id="Composition" name="correct_grammar_use" required>
												<option vfs_val=6 vfs_max='6' <?php echo $vfs_email['correct_grammar_use']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option vfs_val=0 vfs_max='6' <?php echo $vfs_email['correct_grammar_use']=='No'?"selected":""; ?> value="No">No</option>
												<option vfs_val=0 vfs_max='6' <?php echo $vfs_email['correct_grammar_use']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td id="score_correct_grammar_use">6</td>
										<td><textarea class="form-control" name="comm17"><?php echo $vfs_email['comm17'] ?></textarea></td>
									</tr>
									
									<tr>
										<td></td>
										<td colspan=1>e. Further assistance & Correct closing</td>
										<td>7</td>
										<td>
											<select class="form-control vfsVal"  data-id="Composition" name="correct_assistance" required>
												<option vfs_val=7 vfs_max='7' <?php echo $vfs_email['correct_assistance']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option vfs_val=0  vfs_max='7' <?php echo $vfs_email['correct_assistance']=='No'?"selected":""; ?> value="No">No</option>
												<option vfs_val=0 vfs_max='7' <?php echo $vfs_email['correct_assistance']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td id="score_correct_closing">7</td>
										<td><textarea class="form-control" name="comm18"><?php echo $vfs_email['comm18'] ?></textarea></td>
									</tr>
									<tr>
										<td style="background-color:#BFC9CA"><b>6</b></td>
										<td colspan=1 style="background-color:#BFC9CA">Fatal Parameter</td>
										<td style="background-color:#BFC9CA"></td>
										<td style="background-color:#BFC9CA"></td>
										<td style="background-color:#BFC9CA"></td>
										<td style="background-color:#BFC9CA" ></td>
									</tr>
									<tr>	
										<td></td>									
										<td colspan=1 style="background-color:#D98880">a. Rude or unprofessional on email</td>
										<td></td>
										<td>
											<select class="form-control vfsVal fatal_epi" id="emailAutof1" name="rude_on_email" required>
												<option vfs_val=0 vfs_max=0 <?php echo $vfs_email['rude_on_email']=='No'?"selected":""; ?> value="No">No</option>
												<option vfs_val=0 vfs_max=0 <?php echo $vfs_email['rude_on_email']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
											</select>
										</td>
										<td></td>
										<td><textarea class="form-control" name="comm19"><?php echo $vfs_email['comm19'] ?></textarea></td>
									</tr>
									<tr>	
										<td></td>									
										<td colspan=1 style="background-color:#D98880">b. Incomplete / Inaccurate Information shared</td>
										<td></td>
										<td>
											<select class="form-control vfsVal fatal_epi" id="emailAutof2" name="inacurate_information" required>
												<option vfs_val=0 vfs_max=0 <?php echo $vfs_email['inacurate_information']=='No'?"selected":""; ?> value="No">No</option>
												<option vfs_val=0 vfs_max=0 <?php echo $vfs_email['inacurate_information']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
											</select>
										</td>
										<td></td>
										<td><textarea class="form-control" name="comm20"><?php echo $vfs_email['comm20'] ?></textarea></td>
									</tr>
									<tr>	
										<td></td>									
										<td colspan=1 style="background-color:#D98880">c. Email hygiene</td>
										<td></td>
										<td>
											<select class="form-control vfsVal fatal_epi" id="emailAutof3" name="email_hygiene" required>
												<option vfs_val=0 vfs_max=0 <?php echo $vfs_email['email_hygiene']=='No'?"selected":""; ?> value="No">No</option>
												<option vfs_val=0 vfs_max=0 <?php echo $vfs_email['email_hygiene']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
											</select>
										</td>
										<td></td>
										<td><textarea class="form-control" name="comm21"><?php echo $vfs_email['comm21'] ?></textarea></td>
									</tr>
									<tr>	
										<td></td>									
										<td colspan=1 style="background-color:#D98880">d. Complaint Avoidance</td>
										<td></td>
										<td>
											<select class="form-control vfsVal fatal_epi" id="emailAutof4" name="complaint_avoidance" required>
												<option vfs_val=0 vfs_max=0 <?php echo $vfs_email['complaint_avoidance']=='No'?"selected":""; ?> value="No">No</option>
												<option vfs_val=0 vfs_max=0 <?php echo $vfs_email['complaint_avoidance']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
											</select>
										</td>
										<td></td>
										<td><textarea class="form-control" name="comm22"><?php echo $vfs_email['comm22'] ?></textarea></td>
									</tr>
											<tr>
										<td style="background-color:#BFC9CA"><b>7</b></td>
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
												<option <?php echo $vfs_email['disposition']=='Additional Documents asked by the Embassy/consulate'?'selected':''; ?> value='Additional Documents asked by the Embassy/consulate'>Additional Documents asked by the Embassy/consulate</option>
												<option <?php echo $vfs_email['disposition']=='Agent'?'selected':''; ?> value='Agent'>Agent</option>
												<option <?php echo $vfs_email['disposition']=='Appeal Procedure'?'selected':''; ?> value='Appeal Procedure'>Appeal Procedure</option>
												<option <?php echo $vfs_email['disposition']=='Applicant'?'selected':''; ?> value='Applicant'>Applicant</option>
												<option <?php echo $vfs_email['disposition']=='Applicant Requested'?'selected':''; ?> value='Applicant Requested'>Applicant Requested</option>
												<option <?php echo $vfs_email['disposition']=='Application Form Filling'?'selected':''; ?> value='Application Form Filling'>Application Form Filling</option>
												<option <?php echo $vfs_email['disposition']=='Appointment re-confirmation'?'selected':''; ?> value='Appointment re-confirmation'>Appointment re-confirmation</option>
												<option <?php echo $vfs_email['disposition']=='Approval letter'?'selected':''; ?> value='Approval letter'>Approval letter</option>
												<option <?php echo $vfs_email['disposition']=='AWB'?'selected':''; ?> value='AWB'>AWB</option>
												<option <?php echo $vfs_email['disposition']=='AWB Not Generated'?'selected':''; ?> value='AWB Not Generated'>AWB Not Generated</option>
												<option <?php echo $vfs_email['disposition']=='Biometrics'?'selected':''; ?> value='Biometrics'>Biometrics</option>
												<option <?php echo $vfs_email['disposition']=='Blank call'?'selected':''; ?> value='Blank call'>Blank call</option>
												<option <?php echo $vfs_email['disposition']=='Call Connected'?'selected':''; ?> value='Call Connected'>Call Connected</option>
												<option <?php echo $vfs_email['disposition']=='Call not answered'?'selected':''; ?> value='Call not answered'>Call not answered</option>
												<option <?php echo $vfs_email['disposition']=='Cancellation'?'selected':''; ?> value='Cancellation'>Cancellation</option>
												<option <?php echo $vfs_email['disposition']=='Check and Verify'?'selected':''; ?> value='Check and Verify'>Check and Verify</option>
												<option <?php echo $vfs_email['disposition']=='Collection timing'?'selected':''; ?> value='Collection timing'>Collection timing</option>
												<option <?php echo $vfs_email['disposition']=='Consulate Details'?'selected':''; ?> value='Consulate Details'>Consulate Details</option>
												<option <?php echo $vfs_email['disposition']=='Counter Collection'?'selected':''; ?> value='Counter Collection'>Counter Collection</option>
												<option <?php echo $vfs_email['disposition']=='Courier'?'selected':''; ?> value='Courier'>Courier</option>
												<option <?php echo $vfs_email['disposition']=='Courier Assurance'?'selected':''; ?> value='Courier Assurance'>Courier Assurance</option>
												<option <?php echo $vfs_email['disposition']=='Dispositon'?'selected':''; ?> value='Dispositon'>Dispositon</option>
												<option <?php echo $vfs_email['disposition']=='Documentation'?'selected':''; ?> value='Documentation'>Documentation</option>
												<option <?php echo $vfs_email['disposition']=='Documentation - Checklist'?'selected':''; ?> value='Documentation - Checklist'>Documentation - Checklist</option>
												<option <?php echo $vfs_email['disposition']=='Documentation - supporting docs'?'selected':''; ?> value='Documentation - supporting docs'>Documentation - supporting docs</option>
												<option <?php echo $vfs_email['disposition']=='Documents attestation'?'selected':''; ?> value='Documents attestation'>Documents attestation</option>
												<option <?php echo $vfs_email['disposition']=='Embassy Submission'?'selected':''; ?> value='Embassy Submission'>Embassy Submission</option>
												<option <?php echo $vfs_email['disposition']=='Embassy Website'?'selected':''; ?> value='Embassy Website'>Embassy Website</option>
												<option <?php echo $vfs_email['disposition']=='Error Faced while booking an appoitment'?'selected':''; ?> value='Error Faced while booking an appoitment'>Error Faced while booking an appoitment</option>
												<option <?php echo $vfs_email['disposition']=='Existing appointment - Did not rec the letter/confirmation'?'selected':''; ?> value='Existing appointment - Did not rec the letter/confirmation'>Existing appointment - Did not rec the letter/confirmation</option>
												<option <?php echo $vfs_email['disposition']=='Fees'?'selected':''; ?> value='Fees'>Fees</option>
												<option <?php echo $vfs_email['disposition']=='Finance'?'selected':''; ?> value='Finance'>Finance</option>
												<option <?php echo $vfs_email['disposition']=='Follow Up Call'?'selected':''; ?> value='Follow Up Call'>Follow Up Call</option>
												<option <?php echo $vfs_email['disposition']=='Insurance'?'selected':''; ?> value='Insurance'>Insurance</option>
												<option <?php echo $vfs_email['disposition']=='Interview letter'?'selected':''; ?> value='Interview letter'>Interview letter</option>
												<option <?php echo $vfs_email['disposition']=='Interview process'?'selected':''; ?> value='Interview process'>Interview process</option>
												<option <?php echo $vfs_email['disposition']=='Job Related'?'selected':''; ?> value='Job Related'>Job Related</option>
												<option <?php echo $vfs_email['disposition']=='Holidays and working hours - Mission and VAC'?'selected':''; ?> value='Holidays and working hours - Mission and VAC'>Holidays and working hours - Mission and VAC</option>
												<option <?php echo $vfs_email['disposition']=='Legalization procedure'?'selected':''; ?> value='Legalization procedure'>Legalization procedure</option>
												<option <?php echo $vfs_email['disposition']=='Logistic Website'?'selected':''; ?> value='Logistic Website'>Logistic Website</option>
												<option <?php echo $vfs_email['disposition']=='Logistic Website Issue'?'selected':''; ?> value='Logistic Website Issue'>Logistic Website Issue</option>
												<option <?php echo $vfs_email['disposition']=='Manager'?'selected':''; ?> value='Manager'>Manager</option>
												<option <?php echo $vfs_email['disposition']=='Marketing'?'selected':''; ?> value='Marketing'>Marketing</option>
												<option <?php echo $vfs_email['disposition']=='Mea'?'selected':''; ?> value='Mea'>Mea</option>
												<option <?php echo $vfs_email['disposition']=='Mea - Attestation services'?'selected':''; ?> value='Mea - Attestation services'>Mea - Attestation services</option>
												<option <?php echo $vfs_email['disposition']=='MEA Fees'?'selected':''; ?> value='MEA Fees'>MEA Fees</option>
												<option <?php echo $vfs_email['disposition']=='New Appointment - Attestation'?'selected':''; ?> value='New Appointment - Attestation'>New Appointment - Attestation</option>
												<option <?php echo $vfs_email['disposition']=='New Appointment - CC to book'?'selected':''; ?> value='New Appointment - CC to book'>New Appointment - CC to book</option>
												<option <?php echo $vfs_email['disposition']=='New Appointment - How to book'?'selected':''; ?> value='New Appointment - How to book'>New Appointment - How to book</option>
												<option <?php echo $vfs_email['disposition']=='New Appointment - Slots not available'?'selected':''; ?> value='New Appointment - Slots not available'>New Appointment - Slots not available</option>
												<option <?php echo $vfs_email['disposition']=='New Appointment - Where to book'?'selected':''; ?> value='New Appointment - Where to book'>New Appointment - Where to book</option>
												<option <?php echo $vfs_email['disposition']=='Non Deliverable Address'?'selected':''; ?> value='Non Deliverable Address'>Non Deliverable Address</option>
												<option <?php echo $vfs_email['disposition']=='Non VFS mission related'?'selected':''; ?> value='Non VFS mission related'>Non VFS mission related</option>
												<option <?php echo $vfs_email['disposition']=='Not In Scope'?'selected':''; ?> value='Not In Scope'>Not In Scope</option>
												<option <?php echo $vfs_email['disposition']=='Nulla Osta Query'?'selected':''; ?> value='Nulla Osta Query'>Nulla Osta Query</option>
												<option <?php echo $vfs_email['disposition']=='Number Unreachable'?'selected':''; ?> value='Number Unreachable'>Number Unreachable</option>
												<option <?php echo $vfs_email['disposition']=='Other countries helpline number'?'selected':''; ?> value='Other countries helpline number'>Other countries helpline number</option>
												<option <?php echo $vfs_email['disposition']=='Others'?'selected':''; ?> value='Others'>Others</option>
												<option <?php echo $vfs_email['disposition']=='Outside SPT'?'selected':''; ?> value='Outside SPT'>Outside SPT</option>
												<option <?php echo $vfs_email['disposition']=='Passport & Document Submission'?'selected':''; ?> value='Passport & Document Submission'>Passport & Document Submission</option>
												<option <?php echo $vfs_email['disposition']=='Passport services'?'selected':''; ?> value='Passport services'>Passport services</option>
												<option <?php echo $vfs_email['disposition']=='Payment Methods'?'selected':''; ?> value='Payment Methods'>Payment Methods</option>
												<option <?php echo $vfs_email['disposition']=='PL'?'selected':''; ?> value='PL'>PL</option>
												<option <?php echo $vfs_email['disposition']=='PL Booked but not provided'?'selected':''; ?> value='PL Booked but not provided'>PL Booked but not provided</option>
												<option <?php echo $vfs_email['disposition']=='Postal pick-up'?'selected':''; ?> value='Postal pick-up'>Postal pick-up</option>
												<option <?php echo $vfs_email['disposition']=='Postpone interviews'?'selected':''; ?> value='Postpone interviews'>Postpone interviews</option>
												<option <?php echo $vfs_email['disposition']=='PP Hold Request'?'selected':''; ?> value='PP Hold Request'>PP Hold Request</option>
												<option <?php echo $vfs_email['disposition']=='Pre Payments'?'selected':''; ?> value='Pre Payments'>Pre Payments</option>
												<option <?php echo $vfs_email['disposition']=='Prime time services'?'selected':''; ?> value='Prime time services'>Prime time services</option>
												<option <?php echo $vfs_email['disposition']=='Privilege'?'selected':''; ?> value='Privilege'>Privilege</option>
												<option <?php echo $vfs_email['disposition']=='Processing Time'?'selected':''; ?> value='Processing Time'>Processing Time</option>
												<option <?php echo $vfs_email['disposition']=='Reference Number Not Generated'?'selected':''; ?> value='Reference Number Not Generated'>Reference Number Not Generated</option>
												<option <?php echo $vfs_email['disposition']=='Reschedule'?'selected':''; ?> value='Reschedule'>Reschedule</option>
												<option <?php echo $vfs_email['disposition']=='Resubmission of passport'?'selected':''; ?> value='Resubmission of passport'>Resubmission of passport</option>
												<option <?php echo $vfs_email['disposition']=='Routed to correct mission helpline'?'selected':''; ?> value='Routed to correct mission helpline'>Routed to correct mission helpline</option>
												<option <?php echo $vfs_email['disposition']=='Scanning Issue'?'selected':''; ?> value='Scanning Issue'>Scanning Issue</option>
												<option <?php echo $vfs_email['disposition']=='Security procedure at VFS centre'?'selected':''; ?> value='Security procedure at VFS centre'>Security procedure at VFS centre</option>
												<option <?php echo $vfs_email['disposition']=='Service Charge deducted twice'?'selected':''; ?> value='Service Charge deducted twice'>Service Charge deducted twice</option>
												<option <?php echo $vfs_email['disposition']=='Service Inadequate'?'selected':''; ?> value='Service Inadequate'>Service Inadequate</option>
												<option <?php echo $vfs_email['disposition']=='Service issue at VAC'?'selected':''; ?> value='Service issue at VAC'>Service issue at VAC</option>
												<option <?php echo $vfs_email['disposition']=='Services '?'selected':''; ?> value='Services '>Services </option>
												<option <?php echo $vfs_email['disposition']=='SMS Issue'?'selected':''; ?> value='SMS Issue'>SMS Issue</option>
												<option <?php echo $vfs_email['disposition']=='SMS Issue due to wrong PI'?'selected':''; ?> value='SMS Issue due to wrong PI'>SMS Issue due to wrong PI</option>
												<option <?php echo $vfs_email['disposition']=='SMS service'?'selected':''; ?> value='SMS service'>SMS service</option>
												<option <?php echo $vfs_email['disposition']=='Staff'?'selected':''; ?> value='Staff'>Staff</option>
												<option <?php echo $vfs_email['disposition']=='Student demand draft'?'selected':''; ?> value='Student demand draft'>Student demand draft</option>
												<option <?php echo $vfs_email['disposition']=='Student Questioner'?'selected':''; ?> value='Student Questioner'>Student Questioner</option>
												<option <?php echo $vfs_email['disposition']=='Submission process'?'selected':''; ?> value='Submission process'>Submission process</option>
												<option <?php echo $vfs_email['disposition']=='Submission Timing'?'selected':''; ?> value='Submission Timing'>Submission Timing</option>
												<option <?php echo $vfs_email['disposition']=='Supervisor'?'selected':''; ?> value='Supervisor'>Supervisor</option>
												<option <?php echo $vfs_email['disposition']=='Test Call'?'selected':''; ?> value='Test Call'>Test Call</option>
												<option <?php echo $vfs_email['disposition']=='Transfer to MEA'?'selected':''; ?> value='Transfer to MEA'>Transfer to MEA</option>
												<option <?php echo $vfs_email['disposition']=='Unable to download appointment letter'?'selected':''; ?> value='Unable to download appointment letter'>Unable to download appointment letter</option>
												<option <?php echo $vfs_email['disposition']=='Unable to login'?'selected':''; ?> value='Unable to login'>Unable to login</option>
												<option <?php echo $vfs_email['disposition']=='Unable to track application'?'selected':''; ?> value='Unable to track application'>Unable to track application</option>
												<option <?php echo $vfs_email['disposition']=='VAC'?'selected':''; ?> value='VAC'>VAC</option>
												<option <?php echo $vfs_email['disposition']=='VAC Requested'?'selected':''; ?> value='VAC Requested'>VAC Requested</option>
												<option <?php echo $vfs_email['disposition']=='VAYD'?'selected':''; ?> value='VAYD'>VAYD</option>
												<option <?php echo $vfs_email['disposition']=='VAYD booked but service not provided'?'selected':''; ?> value='VAYD booked but service not provided'>VAYD booked but service not provided</option>
												<option <?php echo $vfs_email['disposition']=='VFS centre Address details'?'selected':''; ?> value='VFS centre Address details'>VFS centre Address details</option>
												<option <?php echo $vfs_email['disposition']=='VFS Charges'?'selected':''; ?> value='VFS Charges'>VFS Charges</option>
												<option <?php echo $vfs_email['disposition']=='VFS Website'?'selected':''; ?> value='VFS Website'>VFS Website</option>
												<option <?php echo $vfs_email['disposition']=='VFS Website Issue'?'selected':''; ?> value='VFS Website Issue'>VFS Website Issue</option>
												<option <?php echo $vfs_email['disposition']=='VFS Website not updated'?'selected':''; ?> value='VFS Website not updated'>VFS Website not updated</option>
												<option <?php echo $vfs_email['disposition']=='Visa cancellation'?'selected':''; ?> value='Visa cancellation'>Visa cancellation</option>
												<option <?php echo $vfs_email['disposition']=='Visa Category'?'selected':''; ?> value='Visa Category'>Visa Category</option>
												<option <?php echo $vfs_email['disposition']=='Visa correction'?'selected':''; ?> value='Visa correction'>Visa correction</option>
												<option <?php echo $vfs_email['disposition']=='Visa Fees'?'selected':''; ?> value='Visa Fees'>Visa Fees</option>
												<option <?php echo $vfs_email['disposition']=='Visa Rules'?'selected':''; ?> value='Visa Rules'>Visa Rules</option>
												<option <?php echo $vfs_email['disposition']=='Visa Stamping details'?'selected':''; ?> value='Visa Stamping details'>Visa Stamping details</option>
												<option <?php echo $vfs_email['disposition']=='Walkin without Appointment'?'selected':''; ?> value='Walkin without Appointment'>Walkin without Appointment</option>
												<option <?php echo $vfs_email['disposition']=='Withdrawal'?'selected':''; ?> value='Withdrawal'>Withdrawal</option>
												<option <?php echo $vfs_email['disposition']=='Within SPT'?'selected':''; ?> value='Within SPT'>Within SPT</option>
												<option <?php echo $vfs_email['disposition']=='Wrong Number'?'selected':''; ?> value='Wrong Number'>Wrong Number</option>
											</select>
										</td>
										<td></td>
										<td></td>
									</tr>
									<tr>
										<td></td>
										<td colspan=1>b. Communication mode through which customer contacted previously</td>
										<td></td>
										<td>
											<input type="text" class="form-control" id="contacted_previously" name="contacted_previously" value="<?php echo $vfs_email['contacted_previously']; ?>">
										</td>
										<td id=""></td>
										<td></td>
									</tr>
									<tr>
										<td></td>
										<td colspan=1>c. Description of Disposition selected</td>
										<td></td>
										<td>
											<input type="text" class="form-control" id="disposition_selected" name="disposition_selected" value="<?php echo $vfs_email['disposition_selected']; ?>">
										</td>
										<td id=""></td>
										<td></td>
									</tr>
									<tr>
										<td></td>
										<td colspan=1>d. Was this the first time customer called us ?</td>
										<td></td>
										<td>
											<select class="form-control" id="customer_called_first" name="customer_called_first">
												<option value="">Select</option>
												<option <?php echo $vfs_email['customer_called_first']=='No'?"selected":""; ?> value="No">No</option>
												<option <?php echo $vfs_email['customer_called_first']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
											</select>
										</td>
										<td id=""></td>
										<td><textarea class="form-control" name="comm23"><?php echo $vfs_email['comm23'] ?></textarea></td>
									</tr>
									<tr>
										<td></td>
										<td colspan=1>e. Did the customer call us more than once but less than 3 times ?</td>
										<td></td>
										<td>
											<select class="form-control" id="customer_called_less_three" name="customer_called_less_three">
												<option value="">Select</option>
												<option <?php echo $vfs_email['customer_called_less_three']=='No'?"selected":""; ?> value="No">No</option>
												<option <?php echo $vfs_email['customer_called_less_three']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
											</select>
										</td>
										<td id=""></td>
										<td><textarea class="form-control" name="comm24"><?php echo $vfs_email['comm24'] ?></textarea></td>
									</tr>
									<tr>
										<td></td>
										<td colspan=1>f. Did the customer call us more than 3 times ?</td>
										<td></td>
										<td>
											<select class="form-control" id="customer_called_more_three" name="customer_called_more_three">
												<option value="">Select</option>
												<option <?php echo $vfs_email['customer_called_more_three']=='No'?"selected":""; ?> value="No">No</option>
												<option <?php echo $vfs_email['customer_called_more_three']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
											</select>
										</td>
										<td id=""></td>
										<td><textarea class="form-control" name="comm25"><?php echo $vfs_email['comm25'] ?></textarea></td>
									</tr>	
									<tr>
										<td>Reason For Fatal Error:</td>
										<td colspan=2><textarea class="form-control"  name="reason_for_fatal"><?php echo $vfs_email['reason_for_fatal'] ?></textarea></td>
										<td>Improvement Area:</td>
										<td colspan=2><textarea class="form-control"  name="inprovement_area"><?php echo $vfs_email['inprovement_area'] ?></textarea></td>
									</tr>
									<!--<tr>
										<td>Email Summary:</td>
										<td colspan=2><textarea class="form-control"  name="call_summary"><?php echo $vfs_email['call_summary'] ?></textarea></td>
										<td>Feedback:</td>
										<td colspan=2><textarea class="form-control"  name="feedback"><?php echo $vfs_email['feedback'] ?></textarea></td>
									</tr>-->
									
									<tr>
										<td colspan="2">Upload Files [m4a,mp4,mp3,wav]</td>
										<?php if($email_id==0){ ?>
											<td colspan=4>
												<input type="file" name="attach_file[]" id="attach_file" accept=".m4a,.mp4,.mp3,.wav,audio/*" />
											</td>
										<?php }else{ 
											if($vfs_email['attach_file']!=''){ ?>
											<td colspan="4">
												<input type="file" multiple class="form-control"  id="attach_file" name="attach_file[]" accept=".m4a,.mp4,.mp3,.wav,audio/*"> 
												<?php $attach_file = explode(",",$vfs_email['attach_file']);
												 foreach($attach_file as $mp){ ?>
													<audio controls='' style="background-color:#607F93"> 
													  <source src="<?php echo base_url(); ?>qa_files/qa_vfs/email/<?php echo $mp; ?>" type="audio/ogg">
													  <source src="<?php echo base_url(); ?>qa_files/qa_vfs/email/<?php echo $mp; ?>" type="audio/mpeg">
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
										
									<?php if($email_id!=0){ ?>
										<tr><td colspan=2 style="font-size:16px; font-weight:bold">Agent Review:</td><td colspan=4><?php echo $vfs_email['agent_rvw_note'] ?></td></tr>
										<tr><td colspan=2 style="font-size:16px; font-weight:bold">Management Review:</td><td colspan=4><?php echo $vfs_email['mgnt_rvw_note'] ?></td></tr>
										<tr><td colspan=2 style="font-size:16px; font-weight:bold">Client Review:</td><td colspan=4><?php echo $vfs_email['client_rvw_note'] ?></td></tr>
										
										<tr><td colspan=2  style="font-size:16px">Your Review</td><td colspan=4><textarea class="form-control1" style="width:100%" id="note" name="note" required></textarea></td></tr>
									<?php } ?>
										
									<?php 
									if($email_id==0){
										if(is_access_qa_module()==true || is_access_qa_operations_module()==true){ ?>
											<tr><td colspan=6><button class="btn btn-success waves-effect" type="submit" id="qaformsubmit" style="width:500px">SAVE</button></td></tr>
									<?php 
										} 
									}else{ 
										if(is_access_qa_module()==true || is_access_qa_operations_module()==true){
											if(is_available_qa_feedback($vfs_email['entry_date'],72) == true){ ?>
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
