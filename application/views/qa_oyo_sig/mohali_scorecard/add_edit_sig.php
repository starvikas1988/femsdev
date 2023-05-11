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
	font-size:18px;
	background-color:#85C1E9;
}
</style>

<?php if($sig_id!=0){
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
										<td colspan="6" id="theader" style="font-size:50px"><img src="<?php echo base_url(); ?>main_img/oyo.png">&nbsp SIG-ITC-1(Mohali)</td>
										<input type="hidden" name="audit_start_time" value="<?php echo CurrMySqlDate(); ?>">
									</tr>
									<tr><td colspan=6 style="background-color:#85C1E9; font-size:14px; font-weight:bold">Section A</td></tr>
									<?php
										if($sig_id==0){
											$auditorName = get_username();
											$auditDate = CurrDateMDY();
											$clDate_val='';
										}else{
											if($oyo_sig_mohali['entry_by']!=''){
												$auditorName = $oyo_sig_mohali['auditor_name'];
											}else{
												$auditorName = $oyo_sig_mohali['client_name'];
											}
											$auditDate = mysql2mmddyy($oyo_sig_mohali['audit_date']);
											//$clDate_val=mysqlDt2mmddyy($oyo_sig_mohali['call_date']);
										}
									?>
									<tr>
										<td>Name of Auditor:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control" value="<?php echo $auditorName; ?>" disabled></td>
										<td>Date of Audit:<span style="font-size:24px;color:red">*</span></td>
										<td style="width:250px"><input type="text" class="form-control" value="<?php echo $auditDate; ?>" disabled></td>
										<td>Call Date:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="date" class="form-control" id="call_date2" name="data[call_date]" value="<?php echo $oyo_sig_mohali['call_date'] ?>" required></td>
									</tr>
									<tr>
										<td>Agent:<span style="font-size:24px;color:red">*</span></td>
										<td>
											<select class="form-control" id="agent_id" name="data[agent_id]" required >
												<option value="<?php echo $oyo_sig_mohali['agent_id'] ?>"><?php echo $oyo_sig_mohali['fname']." ".$oyo_sig_mohali['lname']."  ".$oyo_sig_mohali['fusion_id'] ?></option>
												<option value="">-Select-</option>
												<?php foreach($agentName as $row):  ?>
													<option value="<?php echo $row['id']; ?>"><?php echo $row['name']." - ".$row['fusion_id']; ?></option>
												<?php endforeach; ?>
											</select>
											
										</td>
										<td>L1 Supervisor:<span style="font-size:24px;color:red">*</span></td>
										<td>
											<input type="text" class="form-control" id="tl_names"  value="<?php echo $oyo_sig_mohali['tl_name'] ?>" readonly>
												<input type="hidden" class="form-control" id="tl_id" name="data[tl_id]" value="<?php echo $oyo_sig_mohali['tl_id'] ?>" required>
										</td>
										<td>Czentrix ID:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control" id="" name="data[czentrix_id]" value="<?php echo $oyo_sig_mohali['czentrix_id']; ?>" required></td>
									</tr>
									<tr>
										<td>Call Duration:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control" id="call_duration" name="data[call_duration]" value="<?php echo $oyo_sig_mohali['call_duration']; ?>" required></td>
										<td>Phone Number:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control" id="" name="data[phone]" onkeyup="check_numberDec(this);" value="<?php echo $oyo_sig_mohali['phone']; ?>" required><span id="start_phone" style="color:red"></span></td>
										<td>Campaign:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control" id="" name="data[campaign]" value="<?php echo $oyo_sig_mohali['campaign']; ?>" required></td>
									</tr>
									<tr>
										<td>Call Type:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control" id="" name="data[call_type]" value="<?php echo $oyo_sig_mohali['call_type']; ?>" required></td>
										<td>Process<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control" id="" name="data[process_name]" value="<?php echo $oyo_sig_mohali['process_name']; ?>" required></td>
										<td>Booking ID:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control" id="" name="data[call_id]" value="<?php echo $oyo_sig_mohali['call_id']; ?>" required></td>
									</tr>
									<tr>
										<td>Report UID:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control" id="" name="data[conf_id]" value="<?php echo $oyo_sig_mohali['conf_id']; ?>" required></td>
										<td>Batch No:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control" id="" name="data[batch_no]" value="<?php echo $oyo_sig_mohali['batch_no']; ?>" required></td>
										<td>Czentrix Disposition:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control" id="" name="data[czentrix_disposition]" value="<?php echo $oyo_sig_mohali['czentrix_disposition']; ?>" required></td>
									</tr>
									<tr>
										<td>Ticket Id:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control" id="phone" name="data[ticket_id]" onkeyup="checkDec(this);" value="<?php echo $oyo_sig_mohali['ticket_id'] ?>" required></td>
										<td>Agent Disposition:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control" name="data[agent_disposition]" value="<?php echo $oyo_sig_mohali['agent_disposition'] ?>" required></td>
										<td>QA Disposition:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control" name="data[qa_disposition]" value="<?php echo $oyo_sig_mohali['qa_disposition'] ?>" required></td>
									</tr>
									<tr>
										<td>Audit Type:<span style="font-size:24px;color:red">*</span></td>
										<td>
											<select class="form-control" id="audit_type" name="data[audit_type]" required>
												<option value="">-Select-</option>
												<option <?php echo $oyo_sig_mohali['audit_type']=='CQ Audit'?"selected":""; ?> value="CQ Audit">CQ Audit</option>
												<option <?php echo $oyo_sig_mohali['audit_type']=='BQ Audit'?"selected":""; ?> value="BQ Audit">BQ Audit</option>
												<option <?php echo $oyo_sig_mohali['audit_type']=='Calibration'?"selected":""; ?> value="Calibration">Calibration</option>
												<option <?php echo $oyo_sig_mohali['audit_type']=='Pre-Certificate Mock Call'?"selected":""; ?> value="Pre-Certificate Mock Call">Pre-Certificate Mock Call</option>
												<option <?php echo $oyo_sig_mohali['audit_type']=='Certificate Audit'?"selected":""; ?> value="Certificate Audit">Certificate Audit</option>
												<option value="WoW Call"  <?= ($oyo_sig_mohali['audit_type']=="WoW Call")?"selected":"" ?>>WoW Call</option>
                                                <option value="Hygiene Audit"  <?= ($oyo_sig_mohali['audit_type']=="Hygiene Audit")?"selected":"" ?>>Hygiene Audit</option>
                                                <option value="Operation Audit"  <?= ($oyo_sig_mohali['audit_type']=="Operation Audit")?"selected":"" ?>>Operation Audit</option>
                                                <option value="Trainer Audit"  <?= ($oyo_sig_mohali['audit_type']=="Trainer Audit")?"selected":"" ?>>Trainer Audit</option>
											</select>
										</td>
										<td class="auType">Auditor Type <span style="font-size:24px;color:red">*</span></td>
										<td class="auType">
											<select class="form-control" id="auditor_type" name="data[auditor_type]">
												<option value="">-Select-</option>
												<option value="Master">Master</option>
												<option value="Regular">Regular</option>
											</select>
										</td>
										<td>VOC:<span style="font-size:24px;color:red">*</span></td>
										<td>
											<select class="form-control" id="voc" name="data[voc]" required>
												<option value="">-Select-</option>
												<option <?php echo $oyo_sig_mohali['voc']=='1'?"selected":""; ?> value="1">1</option>
												<option <?php echo $oyo_sig_mohali['voc']=='2'?"selected":""; ?> value="2">2</option>
												<option <?php echo $oyo_sig_mohali['voc']=='3'?"selected":""; ?> value="3">3</option>
												<option <?php echo $oyo_sig_mohali['voc']=='4'?"selected":""; ?> value="4">4</option>
												<option <?php echo $oyo_sig_mohali['voc']=='5'?"selected":""; ?> value="5">5</option>
											</select>
										</td>
									</tr>
									<tr>
										<td style="font-weight:bold; font-size:16px; text-align:left">Earned Score</td>
											<td><input type="text" readonly id="sig_mohali_earned_score" name="data[earned_score]" class="form-control" value="<?php echo $oyo_sig_mohali['earned_score'] ?>" /></td>
											<td style="font-weight:bold; font-size:16px; text-align:left">Possible Score</td>
											<td><input type="text" readonly id="sig_mohali_possible_score" name="data[possible_score]" class="form-control" value="<?php echo $oyo_sig_mohali['possible_score'] ?>" /></td>
										<td style="font-weight:bold; font-size:18px; text-align:right">Overall Score:</td>
										<td><input type="text" readonly id="sig_mohali_overall_score" name="data[overall_score]" class="form-control sigAutofail" style="font-weight:bold" value="<?php echo $oyo_sig_mohali['overall_score'] ?>"></td>
									</tr>
									<!-- <tr style="background-color:#F1948A; font-weight:bold"><td colspan=3>Parameters</td><td>Scoring</td><td colspan=2>Drop Downs</td></tr> -->
									<tr style="background-color:#A9CCE3; font-weight:bold"><td>Parameter</td><td colspan=2>Sub-Parameter</td><td>Sub-Parameter Wise Score</td><td>Validation (Y/N/NA)</td><td colspan=3>Remark</td></tr>
									   <tr>
										<td rowspan=1 style="background-color:#A9CCE3; font-weight:bold">1. Call Opening </td>
										<td colspan=2>1.1 Opening Protocol</td>
										<td>3</td>
										<td>
											<select class="form-control sig_mohali_point " id="call_opening_5sec_mohali" name="data[call_opening_5sec]" required>
												<option sig_val=3 <?php echo $oyo_sig_mohali['call_opening_5sec']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option sig_val=0 <?php echo $oyo_sig_mohali['call_opening_5sec']=='No'?"selected":""; ?> value="No">No</option>
												<option sig_val=3 <?php echo $oyo_sig_mohali['call_opening_5sec']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
										<td colspan=2>
											<select class="form-control" id="sig_mohaliremarks1" name="data[remarks1]" >
												<option value="<?php echo $oyo_sig_mohali['remarks1']?>"><?php echo $oyo_sig_mohali['remarks1']?></option>
												<option value="">-Select-</option>
											</select>
										</td>
									</tr>
									<tr>
										<td rowspan=2 style="background-color:#A9CCE3; font-weight:bold">2. Probing</td>
										<td colspan=2>2.1 Effective Probing Done</td>
										<td>3</td>
										<td>
											<select class="form-control sig_mohali_point" id="probing_done_mohali" name="data[probing_done]" required>
												<option sig_val=3 <?php echo $oyo_sig_mohali['probing_done']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option sig_val=0 <?php echo $oyo_sig_mohali['probing_done']=='No'?"selected":""; ?> value="No">No</option>
												<option sig_val=3 <?php echo $oyo_sig_mohali['probing_done']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
										<td colspan=2>
											<select class="form-control" id="sig_mohaliremarks2" name="data[remarks2]" >
												<option value="<?php echo $oyo_sig_mohali['remarks2']?>"><?php echo $oyo_sig_mohali['remarks2']?></option>
												<option value="">-Select-</option>
											</select>
										</td>
									</tr>
									<tr>
										<td colspan=2>2.2 Issue Identified and Paraphrased for guest confirmation</td>
										<td>3</td>
										<td>
											<select class="form-control sig_mohali_point" id="issue_identified_mohali" name="data[issue_identified]" required>
												<option sig_val=3 <?php echo $oyo_sig_mohali['issue_identified']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option sig_val=0 <?php echo $oyo_sig_mohali['issue_identified']=='No'?"selected":""; ?> value="No">No</option>
												<option sig_val=3 <?php echo $oyo_sig_mohali['issue_identified']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
										<td colspan=2><select class="form-control" id="sig_mohaliremarks3" name="data[remarks3]" ><option value="<?php echo $oyo_sig_mohali['remarks3']?>"><?php echo $oyo_sig_mohali['remarks3']?></option><option value="">-Select-</option></select></td>
									</tr>
									<tr>
										<td rowspan=7 style="background-color:#A9CCE3; font-weight:bold">3. Call Handling Skills</td>
										<td colspan=2>3.1 Apology & Empathy</td>
										<td>3</td>
										<td>
											<select class="form-control sig_mohali_point" id="apology_empathy_mohali" name="data[apology_empathy]" required>
												<option sig_val=3 <?php echo $oyo_sig_mohali['apology_empathy']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option sig_val=0 <?php echo $oyo_sig_mohali['apology_empathy']=='No'?"selected":""; ?> value="No">No</option>
												<option sig_val=3 <?php echo $oyo_sig_mohali['apology_empathy']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
										<td colspan=2><select class="form-control" id="sig_mohaliremarks4" name="data[remarks4]" ><option value="<?php echo $oyo_sig_mohali['remarks4']?>"><?php echo $oyo_sig_mohali['remarks4']?></option><option value="">-Select-</option></select></td>
									</tr>
									<tr>
										<td colspan=2>3.2 Voice Intonation, Modulation & Rate Of Speech</td>
										<td>2</td>
										<td>
											<select class="form-control sig_mohali_point" id="voice_intonation_mohali" name="data[voice_intonation]" required>
												<option sig_val=2 <?php echo $oyo_sig_mohali['voice_intonation']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option sig_val=0 <?php echo $oyo_sig_mohali['voice_intonation']=='No'?"selected":""; ?> value="No">No</option>
												<option sig_val=2 <?php echo $oyo_sig_mohali['voice_intonation']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
										<td colspan=2><select class="form-control" id="sig_mohaliremarks5" name="data[remarks5]" ><option value="<?php echo $oyo_sig_mohali['remarks5']?>"><?php echo $oyo_sig_mohali['remarks5']?></option><option value="">-Select-</option></select></td>
									</tr>
									<tr>
										<td colspan=2>3.3 Active Listening / Avoid Interruption & Repetitions</td>
										<td>5</td>
										<td>
											<select class="form-control sig_mohali_point" id="active_listening_mohali" name="data[active_listening]" required>
												<option sig_val=5 <?php echo $oyo_sig_mohali['active_listening']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option sig_val=0 <?php echo $oyo_sig_mohali['active_listening']=='No'?"selected":""; ?> value="No">No</option>
												<option sig_val=5 <?php echo $oyo_sig_mohali['active_listening']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
										<td colspan=2><select class="form-control" id="sig_mohaliremarks6" name="data[remarks6]" ><option value="<?php echo $oyo_sig_mohali['remarks6']?>"><?php echo $oyo_sig_mohali['remarks6']?></option><option value="">-Select-</option></select></td>
									</tr>
									<tr>
										<td colspan=2>3.4 Confidence and Enthusiasm</td>
										<td>3</td>
										<td>
											<select class="form-control sig_mohali_point" id="confidence_and_enthusiasm_mohali" name="data[confidence_enthusiasm]" required>
												<option sig_val=3 <?php echo $oyo_sig_mohali['confidence_enthusiasm']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option sig_val=0 <?php echo $oyo_sig_mohali['confidence_enthusiasm']=='No'?"selected":""; ?> value="No">No</option>
												<option sig_val=3 <?php echo $oyo_sig_mohali['confidence_enthusiasm']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
										<td colspan=2><select class="form-control" id="sig_mohaliremarks7" name="data[remarks7]" ><option value="<?php echo $oyo_sig_mohali['remarks7']?>"><?php echo $oyo_sig_mohali['remarks7']?></option><option value="">-Select-</option></select></td>
									</tr>
									<tr>
										<td colspan=2>3.5 Politeness & Professionalism</td>
										<td>5</td>
										<td>
											<select class="form-control sig_mohali_point" id="politeness_professionalism_mohali" name="data[politeness]" required>
												<option sig_val=5 <?php echo $oyo_sig_mohali['politeness']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option sig_val=0 <?php echo $oyo_sig_mohali['politeness']=='No'?"selected":""; ?> value="No">No</option>
												<option sig_val=5 <?php echo $oyo_sig_mohali['politeness']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
										<td colspan=2><select class="form-control" id="sig_mohaliremarks8" name="data[remarks8]" ><option value="<?php echo $oyo_sig_mohali['remarks8']?>"><?php echo $oyo_sig_mohali['remarks8']?></option><option value="">-Select-</option></select></td>
									</tr>
									<tr>
										<td colspan=2>3.6 Grammar & Sentence Construction</td>
										<td>2</td>
										<td>
											<select class="form-control sig_mohali_point" id="grammar_sentence_mohali" name="data[sentence_construction]" required>
												<option sig_val=2 <?php echo $oyo_sig_mohali['sentence_construction']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option sig_val=0 <?php echo $oyo_sig_mohali['sentence_construction']=='No'?"selected":""; ?> value="No">No</option>
												<option sig_val=2 <?php echo $oyo_sig_mohali['sentence_construction']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
										<td colspan=2><select class="form-control" id="sig_mohaliremarks9" name="data[remarks9]" ><option value="<?php echo $oyo_sig_mohali['remarks9']?>"><?php echo $oyo_sig_mohali['remarks9']?></option><option value="">-Select-</option></select></td>
									</tr>
									<tr>
										<td colspan=2>3.7 Acknowledgement of guest queries and offer assurance</td>
										<td>3</td>
										<td>
											<select class="form-control sig_mohali_point" id="acknowledgement_guest_mohali" name="data[acknowledgement]" required>
												<option sig_val=3 <?php echo $oyo_sig_mohali['acknowledgement']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option sig_val=0 <?php echo $oyo_sig_mohali['acknowledgement']=='No'?"selected":""; ?> value="No">No</option>
												<option sig_val=3 <?php echo $oyo_sig_mohali['acknowledgement']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
										<td colspan=2><select class="form-control" id="sig_mohaliremarks10" name="data[remarks10]" ><option value="<?php echo $oyo_sig_mohali['remarks10']?>"><?php echo $oyo_sig_mohali['remarks10']?></option><option value="">-Select-</option></select></td>
									</tr>

									<tr>
										<td rowspan=3 style="background-color:#A9CCE3; font-weight:bold">4. Hold & Dead air Procedure</td>
										<td colspan=2>4.1 Did the agent adhere to Hold Protocol</td>
										<td>5</td>
										<td>
											<select class="form-control sig_mohali_point" id="agent_adhere_hold_mohali" name="data[adhere_hold_protocol]" required>
												<option sig_val=5 <?php echo $oyo_sig_mohali['adhere_hold_protocol']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option sig_val=0 <?php echo $oyo_sig_mohali['adhere_hold_protocol']=='No'?"selected":""; ?> value="No">No</option>
												<option sig_val=5 <?php echo $oyo_sig_mohali['adhere_hold_protocol']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
										<td colspan=2>
											<select class="form-control" id="sig_mohaliremarks11" name="data[remarks11]" >
												<option value="<?php echo $oyo_sig_mohali['remarks11']?>"><?php echo $oyo_sig_mohali['remarks11']?></option>
												<option value="">-Select-</option>
											</select>
										</td>
									</tr>
									<tr>
										<td colspan=2>4.2 Did the agent adhere to dead air Protocol</td>
										<td>2</td>
										<td>
											<select class="form-control sig_mohali_point" id="agent_adhere_dead_mohali" name="data[dead_air_protocol]" required>
												<option sig_val=2 <?php echo $oyo_sig_mohali['dead_air_protocol']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option sig_val=0 <?php echo $oyo_sig_mohali['dead_air_protocol']=='No'?"selected":""; ?> value="No">No</option>
												<option sig_val=2 <?php echo $oyo_sig_mohali['dead_air_protocol']=='NA'?"selected":""; ?> value="NA">NA</option>
												
											</select>
										</td>
										<td colspan=2><select class="form-control" id="sig_mohaliremarks12" name="data[remarks12]" ><option value="<?php echo $oyo_sig_mohali['remarks12']?>"><?php echo $oyo_sig_mohali['remarks12']?></option><option value="">-Select-</option></select></td>
									</tr>
									<tr>
										<td colspan=2>4.3 Legitimate Hold used (Hold not required still used)</td>
										<td>5</td>
										<td>
											<select class="form-control sig_mohali_point" id="legitimate_hold_mohali" name="data[legitimate_hold]" required>
												<option sig_val=5 <?php echo $oyo_sig_mohali['legitimate_hold']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option sig_val=0 <?php echo $oyo_sig_mohali['legitimate_hold']=='No'?"selected":""; ?> value="No">No</option>
												<option sig_val=5 <?php echo $oyo_sig_mohali['legitimate_hold']=='NA'?"selected":""; ?> value="NA">NA</option>
												
											</select>
										</td>
										<td colspan=2><select class="form-control" id="sig_mohaliremarks13" name="data[remarks13]" ><option value="<?php echo $oyo_sig_mohali['remarks13']?>"><?php echo $oyo_sig_mohali['remarks13']?></option><option value="">-Select-</option></select></td>
									</tr>
									<tr>
										<td rowspan=6 style="background-color:#A9CCE3; font-weight:bold">5. Resolution</td>
										<td colspan=2>5.1 Correct Information / Resolution provided</td>
										<td>10</td>
										<td>
											<select class="form-control sig_mohali_point" id="resolution_provided_mohali" name="data[correct_information]" required>
												<option sig_val=10 <?php echo $oyo_sig_mohali['correct_information']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option sig_val=0 <?php echo $oyo_sig_mohali['correct_information']=='No'?"selected":""; ?> value="No">No</option>
												<option sig_val=10 <?php echo $oyo_sig_mohali['correct_information']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
										<td colspan=2>
											<select class="form-control" id="sig_mohaliremarks14" name="data[remarks14]" >
												<option value="<?php echo $oyo_sig_mohali['remarks14']?>"><?php echo $oyo_sig_mohali['remarks14']?></option>
												<option value="">-Select-</option>
											</select>
										</td>
									</tr>
									<tr>
										<td colspan=2>5.2 Correct refund (OREO and auto refund)/complimentary procedure</td>
										<td>2</td>
										<td>
											<select class="form-control sig_mohali_point" id="correct_refund_mohali" name="data[correct_refund]" required>
												<option sig_val=2 <?php echo $oyo_sig_mohali['correct_refund']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option sig_val=0 <?php echo $oyo_sig_mohali['correct_refund']=='No'?"selected":""; ?> value="No">No</option>
												<option sig_val=2 <?php echo $oyo_sig_mohali['correct_refund']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
										<td colspan=2><select class="form-control" id="sig_mohaliremarks15" name="data[remarks15]" ><option value="<?php echo $oyo_sig_mohali['remarks15']?>"><?php echo $oyo_sig_mohali['remarks15']?></option><option value="">-Select-</option></select></td>
									</tr>
									<tr>
										<td colspan=2>5.3 Proper follow up with PM/Stock team</td>
										<td>3</td>
										<td>
											<select class="form-control sig_mohali_point" id="follow_up_with_mohali" name="data[proper_followup]" required>
												<option sig_val=3 <?php echo $oyo_sig_mohali['proper_followup']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option sig_val=0 <?php echo $oyo_sig_mohali['proper_followup']=='No'?"selected":""; ?> value="No">No</option>
												<option sig_val=3 <?php echo $oyo_sig_mohali['proper_followup']=='NA'?"selected":""; ?> value="NA">NA</option>
												
											</select>
										</td>
										<td colspan=2><select class="form-control" id="sig_mohaliremarks16" name="data[remarks16]" ><option value="<?php echo $oyo_sig_mohali['remarks16']?>"><?php echo $oyo_sig_mohali['remarks16']?></option><option value="">-Select-</option></select></td>
									</tr>
									<tr>
										<td colspan=2>5.4 GNC Closure Procedure</td>
										<td>2</td>
										<td>
											<select class="form-control sig_mohali_point" id="closure_procedure_mohali" name="data[gnc_closure]" required>
												<option sig_val=2 <?php echo $oyo_sig_mohali['gnc_closure']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option sig_val=0 <?php echo $oyo_sig_mohali['gnc_closure']=='No'?"selected":""; ?> value="No">No</option>
												<option sig_val=2 <?php echo $oyo_sig_mohali['gnc_closure']=='NA'?"selected":""; ?> value="NA">NA</option>
												
											</select>
										</td>
										<td colspan=2><select class="form-control" id="sig_mohaliremarks17" name="data[remarks17]" ><option value="<?php echo $oyo_sig_mohali['remarks17']?>"><?php echo $oyo_sig_mohali['remarks17']?></option><option value="">-Select-</option></select></td>
									</tr>
									<tr>
										<td colspan=2>5.5 Ownership (Call Back as promised/call back if call get disconnected)</td>
										<td>5</td>
										<td>
											<select class="form-control sig_mohali_point" id="back_as_promised_mohali" name="data[ownership]" required>
												<option sig_val=5 <?php echo $oyo_sig_mohali['ownership']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option sig_val=0 <?php echo $oyo_sig_mohali['ownership']=='No'?"selected":""; ?> value="No">No</option>
												<option sig_val=5 <?php echo $oyo_sig_mohali['ownership']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
										<td colspan=2><select class="form-control" id="sig_mohaliremarks18" name="data[remarks18]" ><option value="<?php echo $oyo_sig_mohali['remarks18']?>"><?php echo $oyo_sig_mohali['remarks18']?></option><option value="">-Select-</option></select></td>
									</tr>
									<tr>
										<td colspan=2>5.6 Send correct resolution email</td>
										<td>4</td>
										<td>
											<select class="form-control sig_mohali_point" id="send_correct_resolution_mohali" name="data[correct_email]" required>
												<option sig_val=4 <?php echo $oyo_sig_mohali['correct_email']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option sig_val=0 <?php echo $oyo_sig_mohali['correct_email']=='No'?"selected":""; ?> value="No">No</option>
												<option sig_val=4 <?php echo $oyo_sig_mohali['correct_email']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
										<td colspan=2><select class="form-control" id="sig_mohaliremarks19" name="data[remarks19]" ><option value="<?php echo $oyo_sig_mohali['remarks19']?>"><?php echo $oyo_sig_mohali['remarks19']?></option><option value="">-Select-</option></select></td>
									</tr>
									<tr>
										<td rowspan=4 style="background-color:#A9CCE3; font-weight:bold">6. Documentation </td>
										<td colspan=2>6.1 Complete and correct notes (CRS/C-Zentrix/OYO desk)</td>
										<td>5</td>
										<td>
											<select class="form-control sig_mohali_point" id="complete_and_correct_mohali" name="data[correct_notes]" required>
												
												<option sig_val=5 <?php echo $oyo_sig_mohali['correct_notes']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option sig_val=0 <?php echo $oyo_sig_mohali['correct_notes']=='No'?"selected":""; ?> value="No">No</option>
												<option sig_val=5 <?php echo $oyo_sig_mohali['correct_notes']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
										<td colspan=2>
											<select class="form-control" id="sig_mohaliremarks20" name="data[remarks20]" >
												<option value="<?php echo $oyo_sig_mohali['remarks20']?>"><?php echo $oyo_sig_mohali['remarks20']?></option>
												<option value="">-Select-</option>
											</select>
										</td>
									</tr>
									<tr>
										<td colspan=2>6.2 Accurate Tagging of Issue Category and sub category</td>
										<td>10</td>
										<td>
											<select class="form-control sig_mohali_point" id="accurate_tagging_off_mohali" name="data[accurate_tagging]" required>
												<option sig_val=10 <?php echo $oyo_sig_mohali['accurate_tagging']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option sig_val=0 <?php echo $oyo_sig_mohali['accurate_tagging']=='No'?"selected":""; ?> value="No">No</option>
												<option sig_val=10 <?php echo $oyo_sig_mohali['accurate_tagging']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
										<td colspan=2><select class="form-control" id="sig_mohaliremarks21" name="data[remarks21]" ><option value="<?php echo $oyo_sig_mohali['remarks21']?>"><?php echo $oyo_sig_mohali['remarks21']?></option><option value="">-Select-</option></select></td>
									</tr>
									<tr>
										<td colspan=2>6.3 Call Disposed accurately on Czentrix</td>
										<td>3</td>
										<td>
											<select class="form-control sig_mohali_point" id="disposed_accurately_mohali" name="data[call_disposed]" required>
												<option sig_val=3 <?php echo $oyo_sig_mohali['call_disposed']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option sig_val=0 <?php echo $oyo_sig_mohali['call_disposed']=='No'?"selected":""; ?> value="No">No</option>
												<option sig_val=3 <?php echo $oyo_sig_mohali['call_disposed']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
										<td colspan=2><select class="form-control" id="sig_mohaliremarks22" name="data[remarks22]" ><option value="<?php echo $oyo_sig_mohali['remarks22']?>"><?php echo $oyo_sig_mohali['remarks22']?></option><option value="">-Select-</option></select></td>
									</tr>
									<tr>
										<td colspan=2>6.4 Correct Ticket Status and tagging of remaining fields in Oyo Desk</td>
										<td>3</td>
										<td>
											<select class="form-control sig_mohali_point" id="ticket_status_mohali" name="data[correct_ticket_status]" required>
												<option sig_val=3 <?php echo $oyo_sig_mohali['correct_ticket_status']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option sig_val=0 <?php echo $oyo_sig_mohali['correct_ticket_status']=='No'?"selected":""; ?> value="No">No</option>
												<option sig_val=3 <?php echo $oyo_sig_mohali['correct_ticket_status']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
										<td colspan=2><select class="form-control" id="sig_mohaliremarks23" name="data[remarks23]" ><option value="<?php echo $oyo_sig_mohali['remarks23']?>"><?php echo $oyo_sig_mohali['remarks23']?></option><option value="">-Select-</option></select></td>
									</tr>
									  <tr>
										<td rowspan=5 style="background-color:#A9CCE3; font-weight:bold">7. Call Closing</td>
										<td colspan=2>7.1 Pitched Need Help (YO) for self help</td>
										<td>2</td>
										<td>
											<select class="form-control sig_mohali_point" id="pitched_need_help_mohali" name="data[piched_need_help]" required>
												<option sig_val=2 <?php echo $oyo_sig_mohali['piched_need_help']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option sig_val=0 <?php echo $oyo_sig_mohali['piched_need_help']=='No'?"selected":""; ?> value="No">No</option>
												<option sig_val=2 <?php echo $oyo_sig_mohali['piched_need_help']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
										<td colspan=2>
											<select class="form-control" id="sig_mohaliremarks24" name="data[remarks24]" >
												<option value="<?php echo $oyo_sig_mohali['remarks24']?>"><?php echo $oyo_sig_mohali['remarks24']?></option>
												<option value="">-Select-</option>
											</select>
										</td>
									</tr>
									<tr>
										<td colspan=2>7.2 Further Assistance Asked</td>
										<td>1</td>
										<td>
											<select class="form-control sig_mohali_point" id="further_assistance_mohali" name="data[further_assistance]" required>
												<option sig_val=1 <?php echo $oyo_sig_mohali['further_assistance']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option sig_val=0 <?php echo $oyo_sig_mohali['further_assistance']=='No'?"selected":""; ?> value="No">No</option>
												<option sig_val=1 <?php echo $oyo_sig_mohali['further_assistance']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
										<td colspan=2><select class="form-control" id="sig_mohaliremarks25" name="data[remarks25]" ><option value="<?php echo $oyo_sig_mohali['remarks25']?>"><?php echo $oyo_sig_mohali['remarks25']?></option><option value="">-Select-</option></select></td>
									</tr>
									<tr>
										<td colspan=2>7.3 G-Sat Survey Effectively Pitched</td>
										<td>2</td>
										<td>
											<select class="form-control sig_mohali_point" id="survey_effectively_mohali" name="data[Gsat_survey_pitched]" required>
												
												<option sig_val=2 <?php echo $oyo_sig_mohali['Gsat_survey_pitched']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option sig_val=0 <?php echo $oyo_sig_mohali['Gsat_survey_pitched']=='No'?"selected":""; ?> value="No">No</option>
												<option sig_val=2 <?php echo $oyo_sig_mohali['Gsat_survey_pitched']=='NA'?"selected":""; ?> value="NA">NA</option>
												
											</select>
										</td>
										<td colspan=2><select class="form-control" id="sig_mohaliremarks26" name="data[remarks26]" ><option value="<?php echo $oyo_sig_mohali['remarks26']?>"><?php echo $oyo_sig_mohali['remarks26']?></option><option value="">-Select-</option></select></td>
									</tr>
									<tr>
										<td colspan=2>7.4 G- Sat Survey Avoidance</td>
										<td>3</td>
										<td>
											<select class="form-control sig_mohali_point" id="survey_avoidance_mohali" name="data[Gsat_survey_avoidance]" required>
												
												<option sig_val=3 <?php echo $oyo_sig_mohali['Gsat_survey_avoidance']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option sig_val=0 <?php echo $oyo_sig_mohali['Gsat_survey_avoidance']=='No'?"selected":""; ?> value="No">No</option>
												<option sig_val=3 <?php echo $oyo_sig_mohali['Gsat_survey_avoidance']=='NA'?"selected":""; ?> value="NA">NA</option>
												
											</select>
										</td>
										<td colspan=2><select class="form-control" id="sig_mohaliremarks27" name="data[remarks27]" ><option value="<?php echo $oyo_sig_mohali['remarks27']?>"><?php echo $oyo_sig_mohali['remarks27']?></option><option value="">-Select-</option></select></td>
									</tr>

									<tr>
										<td colspan=2>7.5 Closing done with branding of OYO</td>
										<td>1</td>
										<td>
											<select class="form-control sig_mohali_point" id="closing_done_with_mohali" name="data[closing_done_branding]" required>
												
												<option sig_val=1 <?php echo $oyo_sig_mohali['closing_done_branding']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option sig_val=0 <?php echo $oyo_sig_mohali['closing_done_branding']=='No'?"selected":""; ?> value="No">No</option>
												<option sig_val=1 <?php echo $oyo_sig_mohali['closing_done_branding']=='NA'?"selected":""; ?> value="NA">NA</option>
												
											</select>
										</td>
										<td colspan=2><select class="form-control" id="sig_mohaliremarks28" name="data[remarks28]" ><option value="<?php echo $oyo_sig_mohali['remarks28']?>"><?php echo $oyo_sig_mohali['remarks28']?></option><option value="">-Select-</option></select></td>
									</tr>
									<tr>
										<td rowspan=1 style="background-color:#A9CCE3; font-weight:bold">8 Process - Zero Tolerance</td>
										<td colspan=2 style="color:red">8.1 Process ZT - Back ground noise</td>
										<td></td>
										<td>
											<select class="form-control sig_mohali_point sig_mohali_fatal" id="back_ground_noise_mohali" name="data[back_ground_noise]" required>
												<option sig_val=0<?php echo $oyo_sig_mohali['back_ground_noise']=='No'?"selected":""; ?> value="No">No</option>
												<option sig_val=0<?php echo $oyo_sig_mohali['back_ground_noise']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option sig_val=0<?php echo $oyo_sig_mohali['back_ground_noise']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
										<td colspan=2>
											<select class="form-control" id="sig_mohaliremarks29" name="data[remarks29]" >
												<option value="<?php echo $oyo_sig_mohali['remarks29']?>"><?php echo $oyo_sig_mohali['remarks29']?></option>
												<option value="">-Select-</option>
											</select>
										</td>
									</tr>

									<tr>
										<td rowspan=2 style="background-color:#A9CCE3; font-weight:bold">9 Advisor - Actionable</td>
										<td colspan=2 style="color:red">(Zero Tolerance - High)</td>
										<td></td>
										<td>
											<select class="form-control sig_mohali_point sig_mohali_fatal" id="zero_tolerance_mohali" name="data[zero_tolerance]" required>
												
												<option sig_val=0 <?php echo $oyo_sig_mohali['zero_tolerance']=='No'?"selected":""; ?> value="No">No</option>
												<option sig_val=0 <?php echo $oyo_sig_mohali['zero_tolerance']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option sig_val=0 <?php echo $oyo_sig_mohali['zero_tolerance']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
										<td colspan=2>
											<select class="form-control" id="sig_mohaliremarks30" name="data[remarks30]" >
												<option value="<?php echo $oyo_sig_mohali['remarks30']?>"><?php echo $oyo_sig_mohali['remarks30']?></option>
												<option value="">-Select-</option>
											</select>
										</td>
									</tr>
									<tr>
										<td colspan=2 style="color:red">(Warning Letter - Medium)</td>
										<td></td>
										<td>
											<select class="form-control sig_mohali_point sig_mohali_fatal" id="warning_letter_mohali" name="data[warning_letter]" required>
												<option sig_val=0 <?php echo $oyo_sig_mohali['warning_letter']=='No'?"selected":""; ?> value="No">No</option>
												<option sig_val=0 <?php echo $oyo_sig_mohali['warning_letter']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option sig_val=0 <?php echo $oyo_sig_mohali['warning_letter']=='NA'?"selected":""; ?> value="NA">NA</option>
												
											</select>
										</td>
										<td colspan=2>
											<select class="form-control" id="sig_mohaliremarks31" name="data[remarks31]" >
												<option value="<?php echo $oyo_sig_mohali['remarks31']?>"><?php echo $oyo_sig_mohali['remarks31']?></option>
												<option value="">-Select-</option>
											</select>
										</td>
									</tr>

									<tr>
										<td>Call Summary:</td>
										<td colspan=2><textarea class="form-control" id="" name="data[call_summary]"><?php echo $oyo_sig_mohali['call_summary'] ?></textarea></td>
										<td>Feedback:</td>
										<td colspan=2><textarea class="form-control" id="" name="data[feedback]"><?php echo $oyo_sig_mohali['feedback'] ?></textarea></td>
									</tr>
									<tr>
										<td colspan="2">Upload Files [m4a,mp4,mp3,wav]</td>
										<?php if($sig_id==0){ ?>
											<td colspan=4><input type="file" multiple class="form-control" id="attach_file" name="attach_file[]"accept=".m4a,.mp4,.mp3,.wav,audio/*" />
											</td>
										<?php }else{ 
											if($oyo_sig_mohali['attach_file']!=''){ ?>
											<td colspan="4">
												<input type="file" multiple class="form-control"  id="attach_file" name="attach_file[]" accept=".m4a,.mp4,.mp3,.wav,audio/*"> 
												<?php $attach_file = explode(",",$oyo_sig_mohali['attach_file']);
												 foreach($attach_file as $mp){ ?>
													<audio controls='' style="background-color:#607F93"> 
													  <source src="<?php echo base_url(); ?>qa_files/qa_oyo_sig/sig_new/<?php echo $mp; ?>" type="audio/ogg">
													  <source src="<?php echo base_url(); ?>qa_files/qa_oyo_sig/sig_new/<?php echo $mp; ?>" type="audio/mpeg">
													</audio> </br>
												 <?php } ?>
											</td>
										<?php }else{
											echo '<td colspan=4>
													<input type="file" multiple class="form-control" id="attach_file" name="attach_file[]" accept=".m4a,.mp4,.mp3,.wav,audio/*">
													<b>No Files</b></td>';
												//echo '<td><b>No Files</b></td>';
											  }
										} ?>
									</tr>
									
									<?php if($sig_id!=0){ ?>
										<tr><td colspan=2 style="font-size:16px; font-weight:bold">Agent Review:</td><td colspan=4><?php echo $oyo_sig_mohali['agent_rvw_note'] ?></td></tr>
										<tr><td colspan=2 style="font-size:16px; font-weight:bold">Management Review:</td><td colspan=4><?php echo $oyo_sig_mohali['mgnt_rvw_note'] ?></td></tr>
										<tr><td colspan=2 style="font-size:16px; font-weight:bold">Client Review:</td><td colspan=4><?php echo $oyo_sig_mohali['client_rvw_note'] ?></td></tr>
										
										<tr><td colspan=2  style="font-size:16px">Your Review</td><td colspan=4><textarea class="form-control1" style="width:100%" id="note" name="note" required></textarea></td></tr>
									<?php } ?>
									
									<?php 
									if($sig_id==0){
										if(is_access_qa_module()==true || is_quality_access_trainer()==true || is_access_qa_operations_module()==true){ ?>
											<tr><td colspan=6><button class="btn btn-success waves-effect" type="submit" id="qaformsubmit" style="width:500px">SAVE</button></td></tr>
									<?php 
										} 
									}else{ 
										if(is_access_qa_module()==true || is_quality_access_trainer()==true || is_access_qa_operations_module()==true){
											if(is_available_qa_feedback($oyo_sig_mohali['entry_date'],72) == true){ ?>
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