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
.ui-datepicker .ui-datepicker-buttonpane button.ui-datepicker-current {
	 float: left;
	 display: none;
	}

</style>

<?php if($stifel_id!=0){
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
										<td colspan="9" id="theader" style="font-size:40px">Stifel Scorecard</td>
										<input type="hidden" name="audit_start_time" value="<?php echo CurrMySqlDate(); ?>">
									</tr>
									<?php
										if($stifel_id==0){
											$auditorName = get_username();
											$auditDate = CurrDateMDY();
											$clDate_val='';
											$tl_name = '';
											$tl_id = '';
										}else{
											$tl_id = $stifel['tl_id'];
											$tl_name = $stifel['tl_name'];
											if($stifel['entry_by']!=''){
												$auditorName = $stifel['auditor_name'];
											}else{
												$auditorName = $stifel['client_name'];
											}
											$auditDate = mysql2mmddyy($stifel['audit_date']);
											$clDate_val = mysqlDt2mmddyy($stifel['call_date']);
										}
									?>
									<tr>
										<td style="width:130px;">Auditor Name:<span style="font-size:24px;color:red">*</span></td>
										<td colspan="2"><input type="text" class="form-control" value="<?php echo $auditorName; ?>" disabled></td>
										<td >Audit Date:<span style="font-size:24px;color:red">*</span></td>
										<td colspan="2"><input type="text" class="form-control" value="<?php echo $auditDate; ?>" disabled></td>
										<td style="width:100px;">Call Date:<span style="font-size:24px;color:red">*</span></td>
										<td colspan="2"><input type="text" class="form-control" id="call_date_time" name="call_date" value="<?php echo $clDate_val; ?>" required></td>
									</tr>
									<tr>
										<td style="width:130px;">Agent:<span style="font-size:24px;color:red">*</span></td>
										<td colspan="2">
											<select class="form-control" id="agent_id" name="data[agent_id]" required >
												<option value="<?php echo $stifel['agent_id'] ?>"><?php echo $stifel['fname']." ".$stifel['lname'] ?></option>
												<option value="">-Select-</option>
												<?php foreach($agentName as $row):  ?>
													<option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
												<?php endforeach; ?>
											</select>
										</td>
										<td >Fusion ID:<span style="font-size:24px;color:red">*</span></td>
										<td colspan="2"><input type="text" class="form-control" id="fusion_id" value="<?php echo $stifel['fusion_id'] ?>" readonly ></td>
										<td style="width:100px;">L1 Supervisor:<span style="font-size:24px;color:red">*</span></td>
										<td colspan="2">
											<input type="text" class="form-control" id="tl_names"  value="<?php echo $tl_name; ?>" readonly>
											<input type="hidden" class="form-control" id="tl_id" name="data[tl_id]" value="<?php echo $tl_id; ?>" required>
										</td>
									</tr>
									<tr>
										<td style="width:130px;">Call Duration:<span style="font-size:24px;color:red">*</span></td>
										<td colspan="2"><input type="text" class="form-control" id="call_duration" onkeydown="return false;" name="data[call_duration]" value="<?php echo $stifel['call_duration'] ?>" required></td>
										<td>Site/Location:<span style="font-size:24px;color:red">*</span></td>
										<td colspan="2"><input type="text" class="form-control" id="" name="data[site]" value="<?php echo $stifel['site'] ?>" required></td>
										<td style="width:100px;">File No:<span style="font-size:24px;color:red">*</span></td>
										<td colspan="2"><input type="text" class="form-control" id="file_no" name="data[file_no]" value="<?php echo $stifel['file_no'] ?>" required></td>
									</tr>
									<tr>
										<!-- <td style="width:130px;">Interaction ID:</td>
										<td colspan="2"><input type="text" class="form-control" name="data[interaction_id]" value="<?php //echo $stifel['interaction_id'] ?>" required></td> -->
									
										<td>Audit Type:<span style="font-size:24px;color:red">*</span></td>
										<td colspan="2">
											<select class="form-control" id="audit_type" name="data[audit_type]" required>
												<option value="">-Select-</option>
												 <option value="CQ Audit" <?= ($stifel['audit_type']=="CQ Audit")?"selected":"" ?>>CQ Audit</option>
                                                    <option value="BQ Audit" <?= ($stifel['audit_type']=="BQ Audit")?"selected":"" ?>>BQ Audit</option>
                                                    <option value="Calibration" <?= ($stifel['audit_type']=="Calibration")?"selected":"" ?>>Calibration</option>
                                                    <option value="Pre-Certificate Mock Call" <?= ($stifel['audit_type']=="Pre-Certificate Mock Call")?"selected":"" ?>>Pre-Certificate Mock Call</option>
                                                    <option value="Certification Audit" <?= ($stifel['audit_type']=="Certification Audit")?"selected":"" ?>>Certification Audit</option>
                                                    <option value="WoW Call"  <?= ($stifel['audit_type']=="WoW Call")?"selected":"" ?>>WoW Call</option>
                                                    <option value="Hygiene Audit"  <?= ($stifel['audit_type']=="Hygiene Audit")?"selected":"" ?>>Hygiene Audit</option>
                                                    <option value="Operation Audit"  <?= ($stifel['audit_type']=="Operation Audit")?"selected":"" ?>>Operation Audit</option>
                                                    <option value="Trainer Audit"  <?= ($stifel['audit_type']=="Trainer Audit")?"selected":"" ?>>Trainer Audit</option> 
                                                    <option value="QA Supervisor Audit"  <?= ($stifel['audit_type']=="QA Supervisor Audit")?"selected":"" ?>>QA Supervisor Audit</option> 
											</select>
										</td>
										<td class="auType" style="width: 100px;">Auditor Type<span style="font-size:24px;color:red">*</span></td>
										<td class="auType">
											<select class="form-control" id="auditor_type" name="data[auditor_type]">
												<option value="">-Select-</option>
												<option value="Master">Master</option>
												<option value="Regular">Regular</option>
											</select>
										</td>
										<td>VOC:<span style="font-size:24px;color:red">*</span></td>
										<td colspan="2">
											<select class="form-control" id="voc" name="data[voc]" required>
												<option value="">-Select-</option>
												<option <?php echo $stifel['voc']=='1'?"selected":""; ?> value="1">1</option>
												<option <?php echo $stifel['voc']=='2'?"selected":""; ?> value="2">2</option>
												<option <?php echo $stifel['voc']=='3'?"selected":""; ?> value="3">3</option>
												<option <?php echo $stifel['voc']=='4'?"selected":""; ?> value="4">4</option>
												<option <?php echo $stifel['voc']=='5'?"selected":""; ?> value="5">5</option>
												<option <?php echo $stifel['voc']=='6'?"selected":""; ?> value="6">6</option>
												<option <?php echo $stifel['voc']=='7'?"selected":""; ?> value="7">7</option>
												<option <?php echo $stifel['voc']=='8'?"selected":""; ?> value="8">8</option>
												<option <?php echo $stifel['voc']=='9'?"selected":""; ?> value="9">9</option>
												<option <?php echo $stifel['voc']=='10'?"selected":""; ?> value="10">10</option>
											</select>
										</td>
									</tr>
									<tr>
										<td style="font-weight:bold; font-size:16px; text-align:right">Earned Score:</td>
										<td colspan="2"><input type="text" value="<?= $stifel['earned_score']?>" readonly id="jurys_inn_earned_score" name="data[earned_score]" class="form-control" style="font-weight:bold"></td>
										<td style="font-weight:bold; font-size:16px; text-align:right">Possible Score:</td>
										<td colspan="2"><input type="text" value="<?= $stifel['possible_score']?>" readonly id="jurys_inn_possible_score" name="data[possible_score]" class="form-control" style="font-weight:bold"></td>
										<td style="font-weight:bold; font-size:16px; text-align:right">Overall Score:</td>
										<td colspan="2"><input type="text" readonly id="jurys_inn_overall_score" name="data[overall_score]" class="form-control stifel_fatal" style="font-weight:bold" value="<?php echo $stifel['overall_score'] ?>"></td>
									</tr>
									<tr style="height:25px; font-weight:bold; background-color:#D2B4DE">
										<td>PARAMETER</td>
										<td colspan=2>SUB PARAMETER</td>
										<td>Weightage</td>
										<td>STATUS</td>
										<td colspan=2>REMARKS</td>
										<td>Critical Error</td>
									</tr>
									<tr>
										<td class="eml" rowspan=2>Greeting and Farewell</td>
										<td colspan=2 style="color:red">Opening</td>
										<td>5</td>
										<td>
											<select class="form-control jurry_points customer" id="stifel_AF7" name="data[opening]" required>
												<!-- <option value="">-Select-</option> -->
												<option ji_val=5 <?php echo $stifel['opening'] == "Pass"?"selected":"";?> value="Pass">Pass</option>
												<option ji_val=5 <?php echo $stifel['opening'] == "Fail"?"selected":"";?> value="Fail">Fail</option>
											</select> 
										</td>
										<td colspan=2><input type="text" name="data[cmt1]" class="form-control" value="<?php echo $stifel['cmt1'] ?>"></td>
										<td>Customer Critical</td>
									</tr>
									<tr>
										<td colspan=2 style="color:red">Closing</td>
										<td>5</td>
										<td>
											<select class="form-control jurry_points customer"  id="stifel_AF8" name="data[closing]" required>
												<!-- <option value="">-Select-</option> -->
												<option ji_val=5 <?php echo $stifel['closing'] == "Pass"?"selected":"";?> value="Pass">Pass</option>
												<option ji_val=5 <?php echo $stifel['closing'] == "Fail"?"selected":"";?> value="Fail">Fail</option>
											</select> 
										</td>
										<td colspan=2><input type="text" name="data[cmt3]" class="form-control" value="<?php echo $stifel['cmt3'] ?>"></td>
										<td>Customer Critical</td>
									</tr>
									<tr>
										<td class="eml" rowspan=2>Ownership</td>
										<td colspan=2>Needs to offer to stay on the call until the issue has been resolved</td>
										<td>10</td>
										<td>
											<select class="form-control jurry_points customer" name="data[stay_on_call]" required>
												<!-- <option value="">-Select-</option> -->
												<option ji_val=10 <?php echo $stifel['stay_on_call'] == "Pass"?"selected":"";?> value="Pass">Pass</option>
												<option ji_val=10 <?php echo $stifel['stay_on_call'] == "Fail"?"selected":"";?> value="Fail">Fail</option>
												<option ji_val=10 <?php echo $stifel['stay_on_call'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
										<td colspan=2><input type="text" name="data[cmt4]" class="form-control" value="<?php echo $stifel['cmt4'] ?>"></td>
										<td>Customer Critical</td>
									</tr>
									<tr>
										<td colspan=2>Ownership / Assurance</td>
										<td>10</td>
										<td>
											<select class="form-control jurry_points customer" name="data[owenship_assurance]" required>
												<!-- <option value="">-Select-</option> -->
												<option ji_val=10 <?php echo $stifel['owenship_assurance'] == "Pass"?"selected":"";?> value="Pass">Pass</option>
												<option ji_val=10 <?php echo $stifel['owenship_assurance'] == "Fail"?"selected":"";?> value="Fail">Fail</option>
												<option ji_val=10 <?php echo $stifel['owenship_assurance'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
										<td colspan=2><input type="text" name="data[cmt5]" class="form-control" value="<?php echo $stifel['cmt5'] ?>"></td>
										<td>Customer Critical</td>
									</tr>
									<tr>
										<td class="eml" rowspan=2>Hold and Escalation Protocol</td>
										<td colspan=2>Call Control</td>
										<td>10</td>
										<td>
											<select class="form-control jurry_points customer" name="data[hold_protocol]" required>
												<!-- <option value="">-Select-</option> -->
												<option ji_val=10 <?php echo $stifel['hold_protocol'] == "Pass"?"selected":"";?> value="Pass">Pass</option>
												<option ji_val=10 <?php echo $stifel['hold_protocol'] == "Fail"?"selected":"";?> value="Fail">Fail</option>
												<option ji_val=10 <?php echo $stifel['hold_protocol'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
										<td colspan=2><input type="text" name="data[cmt6]" class="form-control" value="<?php echo $stifel['cmt6'] ?>"></td>
										<td>Customer Critical</td>
									</tr>
									<tr>
										<td colspan=2>Transfer</td>
										<td>10</td>
										<td>
											<select class="form-control jurry_points business" name="data[transfer]" required>
												<!-- <option value="">-Select-</option> -->
												<option ji_val=10 <?php echo $stifel['transfer'] == "Pass"?"selected":"";?> value="Pass">Pass</option>
												<option ji_val=10 <?php echo $stifel['transfer'] == "Fail"?"selected":"";?> value="Fail">Fail</option>
												<option ji_val=10 <?php echo $stifel['transfer'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
										<td colspan=2><input type="text" name="data[cmt7]" class="form-control" value="<?php echo $stifel['cmt7'] ?>"></td>
										<td>Business Critical</td>
									</tr>
									<tr>
										<td class="eml" rowspan=3>Effective Communication</td>
										<td colspan=2 style="color:red">Tone / Rate Of Speech / Fumbling/Pacing</td>
										<td>10</td>
										<td>
											<select class="form-control jurry_points customer"  id="stifel_AF10" name="data[rate_of_speech]" required>
												<!-- <option value="">-Select-</option> -->
												<option ji_val=10 <?php echo $stifel['rate_of_speech'] == "Pass"?"selected":"";?> value="Pass">Pass</option>
												<option ji_val=10 <?php echo $stifel['rate_of_speech'] == "Fail"?"selected":"";?> value="Fail">Fail</option>
											</select> 
										</td>
										<td colspan=2><input type="text" name="data[cmt8]" class="form-control" value="<?php echo $stifel['cmt8'] ?>"></td>
										<td>Customer Critical</td>
									</tr>
									<tr>
										<td colspan=2 style="color:red">Active Listening</td>
										<td>10</td>
										<td>
											<select class="form-control jurry_points customer"  id="stifel_AF11" name="data[active_listening]" required>
												<!-- <option value="">-Select-</option> -->
												<option ji_val=10 <?php echo $stifel['active_listening'] == "Pass"?"selected":"";?> value="Pass">Pass</option>
												<option ji_val=10 <?php echo $stifel['active_listening'] == "Fail"?"selected":"";?> value="Fail">Fail</option>
											</select> 
										</td>
										<td colspan=2><input type="text" name="data[cmt9]" class="form-control" value="<?php echo $stifel['cmt9'] ?>"></td>
										<td>Customer Critical</td>
									</tr>
									<tr>
										<td colspan=2 style="color:red">Professionalism</td>
										<td>10</td>
										<td>
											<select class="form-control jurry_points customer" id="stifel_AF12"  name="data[parallel_conversion]" required>
												<!-- <option value="">-Select-</option> -->
												<option ji_val=10 <?php echo $stifel['parallel_conversion'] == "Pass"?"selected":"";?> value="Pass">Pass</option>
												<option ji_val=10 <?php echo $stifel['parallel_conversion'] == "Fail"?"selected":"";?> value="Fail">Fail</option>
											</select> 
										</td>
										<td colspan=2><input type="text" name="data[cmt10]" class="form-control" value="<?php echo $stifel['cmt10'] ?>"></td>
										<td>Customer Critical</td>
									</tr>
									<tr>
										<td class="eml" rowspan=2>Resolution</td>
										<td colspan=2 style="color:red">Issue Identification / Understanding</td>
										<td>2</td>
										<td>
											<select class="form-control jurry_points business" id="stifel_AF1" name="data[issue_identification]" required>
												<!-- <option value="">-Select-</option> -->
												<option ji_val=2 <?php echo $stifel['issue_identification'] == "Pass"?"selected":"";?> value="Pass">Pass</option>
												<option ji_val=2 <?php echo $stifel['issue_identification'] == "Fail"?"selected":"";?> value="Fail">Fail</option>
											</select> 
										</td>
										<td colspan=2><input type="text" name="data[cmt11]" class="form-control" value="<?php echo $stifel['cmt11'] ?>"></td>
										<td>Business Critical</td>
									</tr>
									<tr>
										<td colspan=2 style="color:red">False Commitment(Correct and Accurate Information)</td>
										<td>3</td>
										<td>
											<select class="form-control jurry_points business" id="stifel_AF2" name="data[false_commitment]" required>
												<!-- <option value="">-Select-</option> -->
												<option ji_val=3 <?php echo $stifel['false_commitment'] == "Pass"?"selected":"";?> value="Pass">Pass</option>
												<option ji_val=3 <?php echo $stifel['false_commitment'] == "Fail"?"selected":"";?> value="Fail">Fail</option>
											</select> 
										</td>
										<td colspan=2><input type="text" name="data[cmt13]" class="form-control" value="<?php echo $stifel['cmt13'] ?>"></td>
										<td>Business Critical</td>
									</tr>
									<tr>
										<td class="eml">Verification</td>
										<td colspan=2 style="color:red">Verification</td>
										<td>3</td>
										<td>
											<select class="form-control jurry_points compliance1" id="stifel_AF3" name="data[verification_process_follow]" required>
												<!-- <option value="">-Select-</option> -->
												<option ji_val=3 <?php echo $stifel['verification_process_follow'] == "Pass"?"selected":"";?> value="Pass">Pass</option>
												<option ji_val=3 <?php echo $stifel['verification_process_follow'] == "Fail"?"selected":"";?> value="Fail">Fail</option>
											</select> 
										</td>
										<td colspan=2><input type="text" name="data[cmt14]" class="form-control" value="<?php echo $stifel['cmt14'] ?>"></td>
										<td>Compliance Critical</td>
									</tr>
									<tr>
										<td class="eml" rowspan=2 >ZTP</td>
										<td colspan=2 style="color:red">Rudeness</td>
										<td>2</td>
										<td>
											<select class="form-control jurry_points customer" id="stifel_AF5" name="data[rudeness]" required>
												<!-- <option value="">-Select-</option> -->
												<option ji_val=2 <?php echo $stifel['rudeness'] == "Pass"?"selected":"";?> value="Pass">Pass</option>
												<option ji_val=2 <?php echo $stifel['rudeness'] == "Fail"?"selected":"";?> value="Fail">Fail</option>
											</select> 
										</td>
										<td colspan=2><input type="text" name="data[cmt15]" class="form-control" value="<?php echo $stifel['cmt15'] ?>"></td>
										<td>Customer Critical</td>
									</tr>
									<tr>
										<td colspan=2 style="color:red">Call Avoidance</td>
										<td>2</td>
										<td>
											<select class="form-control jurry_points customer" id="stifel_AF6" name="data[call_avoidance]" required>
												<!-- <option value="">-Select-</option> -->
												<option ji_val=2 <?php echo $stifel['call_avoidance'] == "Pass"?"selected":"";?> value="Pass">Pass</option>
												<option ji_val=2 <?php echo $stifel['call_avoidance'] == "Fail"?"selected":"";?> value="Fail">Fail</option>
											</select> 
										</td>
										<td colspan=2><input type="text" name="data[cmt16]" class="form-control" value="<?php echo $stifel['cmt16'] ?>"></td>
										<td>Customer Critical</td>
									</tr>
									<tr>
										<td class="eml" rowspan=1 >Empathy</td>
										<td colspan=2 style="color:red">Empathy / Apology</td>
										<td>8</td>
										<td>
											<select class="form-control jurry_points customer" id="stifel_AF9" name="data[empathy]" required>
												<!-- <option value="">-Select-</option> -->
												<option ji_val=8 <?php echo $stifel['empathy'] == "Pass"?"selected":"";?> value="Pass">Pass</option>
												<option ji_val=8 <?php echo $stifel['empathy'] == "Fail"?"selected":"";?> value="Fail">Fail</option>
											</select> 
										</td>
										<td colspan=2><input type="text" name="data[cmt17]" class="form-control" value="<?php echo $stifel['cmt17'] ?>"></td>
										<td>Customer Critical</td>
									</tr>
									<tr style="background-color:#D2B4DE"><td colspan="3">Customer Score</td><td colspan="3">Business Score</td><td colspan="3">Compliance Score</td></tr>
									<tr style="background-color:#D2B4DE">
										<td>Earned:</td><td id="custJiCisEarned" colspan="2"></td><td>Earned:</td><td id="busiJiCisEarned" colspan="2"></td><td>Earned:</td><td id="complJiCisEarned" colspan="2"></td>
									</tr>
									<tr style="background-color:#D2B4DE">
										<td>Possible:</td><td id="custJiCisPossible" colspan="2"></td><td>Possible:</td><td id="busiJiCisPossible" colspan="2"></td><td>Possible:</td><td id="complJiCisPossible" colspan="2"></td>
									</tr>
									<tr style="background-color:#D2B4DE">
										<td>Percentage:</td><td colspan="2"><input type="text" readonly style="background-color:#D2B4DE; text-align:center" class="form-control" id="custJiCisScore" name="data[customer_score]" value="<?php echo $stifel['customer_score'] ?>"></td>
										<td>Percentage:</td><td colspan="2"><input type="text" readonly style="background-color:#D2B4DE; text-align:center" class="form-control" id="busiJiCisScore" name="data[business_score]" value="<?php echo $stifel['business_score'] ?>"></td>
										<td>Percentage:</td><td colspan="2"><input type="text" readonly style="background-color:#D2B4DE; text-align:center" class="form-control" id="complJiCisScore" name="data[compliance_score]" value="<?php echo $stifel['compliance_score'] ?>"></td>
									</tr>
									<tr>
										<td>Call Summary:</td>
										<td colspan="3"><textarea class="form-control" name="data[call_summary]"><?php echo $stifel['call_summary'] ?></textarea></td>
										<td>Feedback:</td>
										<td colspan="3"><textarea class="form-control" name="data[feedback]"><?php echo $stifel['feedback'] ?></textarea></td>
									</tr>
									<tr>
										<td colspan=2>Upload Files [m4a,mp4,mp3,wav]</td>
										<?php if($stifel_id==0){ ?>
											<td colspan="7"><input type="file" multiple class="form-control" id="attach_file" name="attach_file[]" accept=".m4a,.mp4,.mp3,.wav,audio/*" style="padding-top: 10px;"></td>
										<?php }else{
											if($stifel['attach_file']!=''){ ?>
												<td colspan=4>
													<input type="file" multiple class="form-control"  id="attach_file" name="attach_file[]" accept=".m4a,.mp4,.mp3,.wav,audio/*"> 
													<?php $attach_file = explode(",",$stifel['attach_file']);
													 foreach($attach_file as $mp){ ?>
														<audio controls='' style="background-color:#607F93"> 
														  <source src="<?php echo base_url(); ?>qa_files/qa_stifel/<?php echo $mp; ?>" type="audio/ogg">
														  <source src="<?php echo base_url(); ?>qa_files/qa_stifel/<?php echo $mp; ?>" type="audio/mpeg">
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
									
									<?php if($stifel_id!=0){ ?>
										<tr><td colspan=4 style="font-size:16px; font-weight:bold">Agent Feedback Acceptance:</td><td colspan=5><?php echo $stifel['agnt_fd_acpt'] ?></td></tr>
										<tr><td colspan=4 style="font-size:16px; font-weight:bold">Agent Review:</td><td colspan=5><?php echo $stifel['agent_rvw_note'] ?></td></tr>
										<tr><td colspan=4 style="font-size:16px; font-weight:bold">Management Review:</td><td colspan=5><?php echo $stifel['mgnt_rvw_note'] ?></td></tr>
										<tr><td colspan=4 style="font-size:16px; font-weight:bold">Client Review:</td><td colspan=5><?php echo $stifel['client_rvw_note'] ?></td></tr>
										
										<tr><td colspan=4  style="font-size:16px">Your Review<span style="font-size:24px;color:red">*</span></td><td colspan=5><textarea class="form-control1" style="width:100%" id="note" name="note" required ></textarea></td></tr>
									<?php } ?>
									
									<?php 
									if($stifel_id==0){
										if(is_access_qa_module()==true || is_access_qa_operations_module()==true){ ?>
											<tr><td colspan="9"><button class="btn btn-success waves-effect" type="submit" id="qaformsubmit" style="width:500px">SAVE</button></td></tr>
									<?php 
										} 
									}else{ 
										if(is_access_qa_module()==true || is_access_qa_operations_module()==true){
											if(is_available_qa_feedback($stifel['entry_date'],72) == true){ ?>
												<tr><td colspan="9"><button class="btn btn-success waves-effect" type="submit" id='qaformsubmit' name='btnSave' value="SAVE" style="width:500px">SAVE</button></td></tr>
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
