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
										<td colspan="6" id="theader" style="font-size:50px"><img src="<?php echo base_url(); ?>main_img/oyo.png">&nbsp SIG</td>
										<input type="hidden" name="audit_start_time" value="<?php echo CurrMySqlDate(); ?>">
									</tr>
									<tr><td colspan=6 style="background-color:#85C1E9; font-size:14px; font-weight:bold">Section A</td></tr>
									<?php
										if($sig_id==0){
											$auditorName = get_username();
											$auditDate = CurrDateMDY();
											$clDate_val='';
										}else{
											if($oyo_sig['entry_by']!=''){
												$auditorName = $oyo_sig['auditor_name'];
											}else{
												$auditorName = $oyo_sig['client_name'];
											}
											$auditDate = mysql2mmddyy($oyo_sig['audit_date']);
											//$clDate_val=mysqlDt2mmddyy($oyo_sig['call_date']);
										}
									?>
									<tr>
										<td>Name of Auditor:</td>
										<td><input type="text" class="form-control" value="<?php echo $auditorName; ?>" disabled></td>
										<td>Date of Audit:</td>
										<td style="width:250px"><input type="text" class="form-control" value="<?php echo $auditDate; ?>" disabled></td>
										<td>Call Date:</td>
										<td><input type="date" class="form-control" id="call_date2" name="data[call_date]" value="<?php echo $oyo_sig['call_date'] ?>" required></td>
									</tr>
									<tr>
										<td>Agent:</td>
										<td>
											<select class="form-control" id="agent_id" name="data[agent_id]" required >
												<option value="<?php echo $oyo_sig['agent_id'] ?>"><?php echo $oyo_sig['fname']." ".$oyo_sig['lname']."  ".$oyo_sig['fusion_id'] ?></option>
												<option value="">-Select-</option>
												<?php foreach($agentName as $row):  ?>
													<option value="<?php echo $row['id']; ?>"><?php echo $row['name']." - ".$row['fusion_id']; ?></option>
												<?php endforeach; ?>
											</select>
											
										</td>
										<td>L1 Supervisor:</td>
										<td>
											<select class="form-control" id="tl_id" name="data[tl_id]"  readonly>
												<option value="<?php echo $oyo_sig['tl_id'] ?>"><?php echo $oyo_sig['tl_name'] ?></option>
												<option value="">--Select--</option>
												<?php foreach($tlname as $tl): ?>
													<option value="<?php echo $tl['id']; ?>"><?php echo $tl['fname']." ".$tl['lname']; ?></option>
												<?php endforeach; ?>	
											</select>
										</td>
										<td>Czentrix ID:</td>
										<td><input type="text" class="form-control" id="" name="data[czentrix_id]" value="<?php echo $oyo_sig['czentrix_id']; ?>" required></td>
									</tr>
									<tr>
										<td>Call Duration:</td>
										<td><input type="text" class="form-control" id="call_duration" name="data[call_duration]" value="<?php echo $oyo_sig['call_duration']; ?>" required></td>
										<td>Phone Number:</td>
										<td><input type="text" class="form-control" id="" name="data[phone]" onkeyup="checkDec(this);" value="<?php echo $oyo_sig['phone']; ?>" required></td>
										<td></td>
										<td></td>
									</tr>
									<tr>
										<td>Call Type:</td>
										<td><input type="text" class="form-control" id="" name="data[call_type]" value="<?php echo $oyo_sig['call_type']; ?>" required></td>
										<td>Disconnection Source:</td>
										<td><input type="text" class="form-control" id="" name="data[disconnection_source]" value="<?php echo $oyo_sig['disconnection_source']; ?>" required></td>
										<td>Call ID:</td>
										<td><input type="text" class="form-control" id="" name="data[call_id]" value="<?php echo $oyo_sig['call_id']; ?>" required></td>
									</tr>
									<tr>
										<td>CONF Unique ID:</td>
										<td><input type="text" class="form-control" id="" name="data[conf_id]" value="<?php echo $oyo_sig['conf_id']; ?>" required></td>
										<td>Monitor File Name:</td>
										<td><input type="text" class="form-control" id="" name="data[monitor_file_name]" value="<?php echo $oyo_sig['monitor_file_name']; ?>" required></td>
										<td>Czentrix Disposition:</td>
										<td><input type="text" class="form-control" id="" name="data[czentrix_disposition]" value="<?php echo $oyo_sig['czentrix_disposition']; ?>" required></td>
									</tr>
									<tr>
										<td>Property Code:</td>
										<td><input type="text" class="form-control" id="phone" name="data[property_code]" onkeyup="checkDec(this);" value="<?php echo $oyo_sig['property_code'] ?>" required></td>
										<td>Agent Disposition:</td>
										<td><input type="text" class="form-control" name="data[agent_disposition]" value="<?php echo $oyo_sig['agent_disposition'] ?>" required></td>
										<td>QA Disposition:</td>
										<td><input type="text" class="form-control" name="data[qa_disposition]" value="<?php echo $oyo_sig['qa_disposition'] ?>" required></td>
									</tr>
									<tr>
										<td>Audit Type:</td>
										<td>
											<select class="form-control" id="audit_type" name="data[audit_type]" required>
												<option value="">-Select-</option>
												<option <?php echo $oyo_sig['audit_type']=='CQ Audit'?"selected":""; ?> value="CQ Audit">CQ Audit</option>
												<option <?php echo $oyo_sig['audit_type']=='BQ Audit'?"selected":""; ?> value="BQ Audit">BQ Audit</option>
												<option <?php echo $oyo_sig['audit_type']=='Calibration'?"selected":""; ?> value="Calibration">Calibration</option>
												<option <?php echo $oyo_sig['audit_type']=='Pre-Certificate Mock Call'?"selected":""; ?> value="Pre-Certificate Mock Call">Pre-Certificate Mock Call</option>
												<option <?php echo $oyo_sig['audit_type']=='Certificate Audit'?"selected":""; ?> value="Certificate Audit">Certificate Audit</option>
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
												<option <?php echo $oyo_sig['voc']=='1'?"selected":""; ?> value="1">1</option>
												<option <?php echo $oyo_sig['voc']=='2'?"selected":""; ?> value="2">2</option>
												<option <?php echo $oyo_sig['voc']=='3'?"selected":""; ?> value="3">3</option>
												<option <?php echo $oyo_sig['voc']=='4'?"selected":""; ?> value="4">4</option>
												<option <?php echo $oyo_sig['voc']=='5'?"selected":""; ?> value="5">5</option>
											</select>
										</td>
									</tr>
									<tr>
										<td colspan=5 style="font-weight:bold; font-size:18px; text-align:right">Overall Score:</td>
										<td><input type="text" readonly id="sigScore" name="data[overall_score]" class="form-control sigAutofail" style="font-weight:bold"></td>
									</tr>
									<!-- <tr style="background-color:#F1948A; font-weight:bold"><td colspan=3>Parameters</td><td>Scoring</td><td colspan=2>Drop Downs</td></tr> -->
									<tr style="background-color:#A9CCE3; font-weight:bold"><td>Parameter</td><td colspan=2>Sub-Parameter</td><td>Sub-Parameter Wise Score</td><td>Validation (Y/N/NA)</td><td colspan=3>Remark</td></tr>
									   <tr>
										<td rowspan=1 style="background-color:#A9CCE3; font-weight:bold">1. Call Opening </td>
										<td colspan=2>1.1 Opening Protocol</td>
										<td>3</td>
										<td>
											<select class="form-control sig_point " id="call_opening_5sec" name="data[call_opening_5sec]" required>
												<option sig_val=3 <?php echo $oyo_sig['call_opening_5sec']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option sig_val=0 <?php echo $oyo_sig['call_opening_5sec']=='No'?"selected":""; ?> value="No">No</option>
												<option sig_val=3 <?php echo $oyo_sig['call_opening_5sec']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
										<td colspan=2>
											<select class="form-control" id="sig_remarks1" name="data[remarks1]" >
												<option value="<?php echo $oyo_sig['remarks1']?>"><?php echo $oyo_sig['remarks1']?></option>
												<option value="">-Select-</option>
											</select>
										</td>
									</tr>
									<tr>
										<td rowspan=2 style="background-color:#A9CCE3; font-weight:bold">2. Probing</td>
										<td colspan=2>2.1 Effective Probing Done</td>
										<td>3</td>
										<td>
											<select class="form-control sig_point" id="probing_done" name="data[probing_done]" required>
												<option sig_val=3 <?php echo $oyo_sig['probing_done']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option sig_val=0 <?php echo $oyo_sig['probing_done']=='No'?"selected":""; ?> value="No">No</option>
												<option sig_val=3 <?php echo $oyo_sig['probing_done']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
										<td colspan=2>
											<select class="form-control" id="sig_remarks2" name="data[remarks2]" >
												<option value="<?php echo $oyo_sig['remarks2']?>"><?php echo $oyo_sig['remarks2']?></option>
												<option value="">-Select-</option>
											</select>
										</td>
									</tr>
									<tr>
										<td colspan=2>2.2 Issue Identified and Paraphrased for guest confirmation</td>
										<td>3</td>
										<td>
											<select class="form-control sig_point" id="issue_identified" name="data[issue_identified]" required>
												<option sig_val=3 <?php echo $oyo_sig['issue_identified']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option sig_val=0 <?php echo $oyo_sig['issue_identified']=='No'?"selected":""; ?> value="No">No</option>
												<option sig_val=3 <?php echo $oyo_sig['issue_identified']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
										<td colspan=2><select class="form-control" id="sig_remarks3" name="data[remarks3]" ><option value="<?php echo $oyo_sig['remarks3']?>"><?php echo $oyo_sig['remarks3']?></option><option value="">-Select-</option></select></td>
									</tr>
									<tr>
										<td rowspan=7 style="background-color:#A9CCE3; font-weight:bold">3. Call Handling Skills</td>
										<td colspan=2>3.1 Apology & Empathy</td>
										<td>3</td>
										<td>
											<select class="form-control sig_point" id="apology_empathy" name="data[apology_empathy]" required>
												<option sig_val=3 <?php echo $oyo_sig['apology_empathy']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option sig_val=0 <?php echo $oyo_sig['apology_empathy']=='No'?"selected":""; ?> value="No">No</option>
												<option sig_val=3 <?php echo $oyo_sig['apology_empathy']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
										<td colspan=2><select class="form-control" id="sig_remarks4" name="data[remarks4]" ><option value="<?php echo $oyo_sig['remarks4']?>"><?php echo $oyo_sig['remarks4']?></option><option value="">-Select-</option></select></td>
									</tr>
									<tr>
										<td colspan=2>3.2 Voice Intonation, Modulation & Rate Of Speech</td>
										<td>2</td>
										<td>
											<select class="form-control sig_point" id="voice_intonation" name="data[voice_intonation]" required>
												<option sig_val=2 <?php echo $oyo_sig['voice_intonation']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option sig_val=0 <?php echo $oyo_sig['voice_intonation']=='No'?"selected":""; ?> value="No">No</option>
												<option sig_val=2 <?php echo $oyo_sig['voice_intonation']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
										<td colspan=2><select class="form-control" id="sig_remarks5" name="data[remarks5]" ><option value="<?php echo $oyo_sig['remarks5']?>"><?php echo $oyo_sig['remarks5']?></option><option value="">-Select-</option></select></td>
									</tr>
									<tr>
										<td colspan=2>3.3 Active Listening / Avoid Interruption & Repetitions</td>
										<td>5</td>
										<td>
											<select class="form-control sig_point" id="active_listening" name="data[active_listening]" required>
												<option sig_val=5 <?php echo $oyo_sig['active_listening']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option sig_val=0 <?php echo $oyo_sig['active_listening']=='No'?"selected":""; ?> value="No">No</option>
												<option sig_val=5 <?php echo $oyo_sig['active_listening']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
										<td colspan=2><select class="form-control" id="sig_remarks6" name="data[remarks6]" ><option value="<?php echo $oyo_sig['remarks6']?>"><?php echo $oyo_sig['remarks6']?></option><option value="">-Select-</option></select></td>
									</tr>
									<tr>
										<td colspan=2>3.4 Confidence and Enthusiasm</td>
										<td>3</td>
										<td>
											<select class="form-control sig_point" id="confidence_and_enthusiasm" name="data[confidence_enthusiasm]" required>
												<option sig_val=3 <?php echo $oyo_sig['confidence_enthusiasm']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option sig_val=0 <?php echo $oyo_sig['confidence_enthusiasm']=='No'?"selected":""; ?> value="No">No</option>
												<option sig_val=3 <?php echo $oyo_sig['confidence_enthusiasm']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
										<td colspan=2><select class="form-control" id="sig_remarks7" name="data[remarks7]" ><option value="<?php echo $oyo_sig['remarks7']?>"><?php echo $oyo_sig['remarks7']?></option><option value="">-Select-</option></select></td>
									</tr>
									<tr>
										<td colspan=2>3.5 Politeness & Professionalism</td>
										<td>5</td>
										<td>
											<select class="form-control sig_point" id="politeness_professionalism" name="data[politeness]" required>
												<option sig_val=5 <?php echo $oyo_sig['politeness']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option sig_val=0 <?php echo $oyo_sig['politeness']=='No'?"selected":""; ?> value="No">No</option>
												<option sig_val=5 <?php echo $oyo_sig['politeness']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
										<td colspan=2><select class="form-control" id="sig_remarks8" name="data[remarks8]" ><option value="<?php echo $oyo_sig['remarks8']?>"><?php echo $oyo_sig['remarks8']?></option><option value="">-Select-</option></select></td>
									</tr>
									<tr>
										<td colspan=2>3.6 Grammar & Sentence Construction</td>
										<td>2</td>
										<td>
											<select class="form-control sig_point" id="grammar_sentence" name="data[sentence_construction]" required>
												<option sig_val=2 <?php echo $oyo_sig['sentence_construction']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option sig_val=0 <?php echo $oyo_sig['sentence_construction']=='No'?"selected":""; ?> value="No">No</option>
												<option sig_val=2 <?php echo $oyo_sig['sentence_construction']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
										<td colspan=2><select class="form-control" id="sig_remarks9" name="data[remarks9]" ><option value="<?php echo $oyo_sig['remarks9']?>"><?php echo $oyo_sig['remarks9']?></option><option value="">-Select-</option></select></td>
									</tr>
									<tr>
										<td colspan=2>3.7 Acknowledgement of guest queries and offer assurance</td>
										<td>3</td>
										<td>
											<select class="form-control sig_point" id="acknowledgement_guest" name="data[acknowledgement]" required>
												<option sig_val=3 <?php echo $oyo_sig['acknowledgement']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option sig_val=0 <?php echo $oyo_sig['acknowledgement']=='No'?"selected":""; ?> value="No">No</option>
												<option sig_val=3 <?php echo $oyo_sig['acknowledgement']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
										<td colspan=2><select class="form-control" id="sig_remarks10" name="data[remarks10]" ><option value="<?php echo $oyo_sig['remarks10']?>"><?php echo $oyo_sig['remarks10']?></option><option value="">-Select-</option></select></td>
									</tr>

									<tr>
										<td rowspan=3 style="background-color:#A9CCE3; font-weight:bold">4. Hold & Dead air Procedure</td>
										<td colspan=2>4.1 Did the agent adhere to Hold Protocol</td>
										<td>5</td>
										<td>
											<select class="form-control sig_point" id="agent_adhere_hold" name="data[adhere_hold_protocol]" required>
												<option sig_val=5 <?php echo $oyo_sig['adhere_hold_protocol']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option sig_val=0 <?php echo $oyo_sig['adhere_hold_protocol']=='No'?"selected":""; ?> value="No">No</option>
												<option sig_val=5 <?php echo $oyo_sig['adhere_hold_protocol']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
										<td colspan=2>
											<select class="form-control" id="sig_remarks11" name="data[remarks11]" >
												<option value="<?php echo $oyo_sig['remarks11']?>"><?php echo $oyo_sig['remarks11']?></option>
												<option value="">-Select-</option>
											</select>
										</td>
									</tr>
									<tr>
										<td colspan=2>4.2 Did the agent adhere to dead air Protocol</td>
										<td>2</td>
										<td>
											<select class="form-control sig_point" id="agent_adhere_dead" name="data[dead_air_protocol]" required>
												<option sig_val=2 <?php echo $oyo_sig['dead_air_protocol']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option sig_val=0 <?php echo $oyo_sig['dead_air_protocol']=='No'?"selected":""; ?> value="No">No</option>
												<option sig_val=2 <?php echo $oyo_sig['dead_air_protocol']=='NA'?"selected":""; ?> value="NA">NA</option>
												
											</select>
										</td>
										<td colspan=2><select class="form-control" id="sig_remarks12" name="data[remarks12]" ><option value="<?php echo $oyo_sig['remarks12']?>"><?php echo $oyo_sig['remarks12']?></option><option value="">-Select-</option></select></td>
									</tr>
									<tr>
										<td colspan=2>4.3 Legitimate Hold used (Hold not required still used)</td>
										<td>5</td>
										<td>
											<select class="form-control sig_point" id="legitimate_hold" name="data[legitimate_hold]" required>
												<option sig_val=5 <?php echo $oyo_sig['legitimate_hold']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option sig_val=0 <?php echo $oyo_sig['legitimate_hold']=='No'?"selected":""; ?> value="No">No</option>
												<option sig_val=5 <?php echo $oyo_sig['legitimate_hold']=='NA'?"selected":""; ?> value="NA">NA</option>
												
											</select>
										</td>
										<td colspan=2><select class="form-control" id="sig_remarks13" name="data[remarks13]" ><option value="<?php echo $oyo_sig['remarks13']?>"><?php echo $oyo_sig['remarks13']?></option><option value="">-Select-</option></select></td>
									</tr>
									<tr>
										<td rowspan=6 style="background-color:#A9CCE3; font-weight:bold">5. Resolution</td>
										<td colspan=2>5.1 Correct Information / Resolution provided</td>
										<td>10</td>
										<td>
											<select class="form-control sig_point" id="resolution_provided" name="data[correct_information]" required>
												<option sig_val=10 <?php echo $oyo_sig['correct_information']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option sig_val=0 <?php echo $oyo_sig['correct_information']=='No'?"selected":""; ?> value="No">No</option>
												<option sig_val=10 <?php echo $oyo_sig['correct_information']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
										<td colspan=2>
											<select class="form-control" id="sig_remarks14" name="data[remarks14]" >
												<option value="<?php echo $oyo_sig['remarks14']?>"><?php echo $oyo_sig['remarks14']?></option>
												<option value="">-Select-</option>
											</select>
										</td>
									</tr>
									<tr>
										<td colspan=2>5.2 Correct refund (OREO and auto refund)/complimentary procedure</td>
										<td>2</td>
										<td>
											<select class="form-control sig_point" id="correct_refund" name="data[correct_refund]" required>
												<option sig_val=2 <?php echo $oyo_sig['correct_refund']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option sig_val=0 <?php echo $oyo_sig['correct_refund']=='No'?"selected":""; ?> value="No">No</option>
												<option sig_val=2 <?php echo $oyo_sig['correct_refund']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
										<td colspan=2><select class="form-control" id="sig_remarks15" name="data[remarks15]" ><option value="<?php echo $oyo_sig['remarks15']?>"><?php echo $oyo_sig['remarks15']?></option><option value="">-Select-</option></select></td>
									</tr>
									<tr>
										<td colspan=2>5.3 Proper follow up with PM/Stock team</td>
										<td>3</td>
										<td>
											<select class="form-control sig_point" id="follow_up_with" name="data[proper_followup]" required>
												<option sig_val=3 <?php echo $oyo_sig['proper_followup']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option sig_val=0 <?php echo $oyo_sig['proper_followup']=='No'?"selected":""; ?> value="No">No</option>
												<option sig_val=3 <?php echo $oyo_sig['proper_followup']=='NA'?"selected":""; ?> value="NA">NA</option>
												
											</select>
										</td>
										<td colspan=2><select class="form-control" id="sig_remarks16" name="data[remarks16]" ><option value="<?php echo $oyo_sig['remarks16']?>"><?php echo $oyo_sig['remarks16']?></option><option value="">-Select-</option></select></td>
									</tr>
									<tr>
										<td colspan=2>5.4 GNC Closure Procedure</td>
										<td>2</td>
										<td>
											<select class="form-control sig_point" id="closure_procedure" name="data[gnc_closure]" required>
												<option sig_val=2 <?php echo $oyo_sig['gnc_closure']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option sig_val=0 <?php echo $oyo_sig['gnc_closure']=='No'?"selected":""; ?> value="No">No</option>
												<option sig_val=2 <?php echo $oyo_sig['gnc_closure']=='NA'?"selected":""; ?> value="NA">NA</option>
												
											</select>
										</td>
										<td colspan=2><select class="form-control" id="sig_remarks17" name="data[remarks17]" ><option value="<?php echo $oyo_sig['remarks17']?>"><?php echo $oyo_sig['remarks17']?></option><option value="">-Select-</option></select></td>
									</tr>
									<tr>
										<td colspan=2>5.5 Ownership (Call Back as promised/call back if call get disconnected)</td>
										<td>5</td>
										<td>
											<select class="form-control sig_point" id="back_as_promised" name="data[ownership]" required>
												<option sig_val=5 <?php echo $oyo_sig['ownership']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option sig_val=0 <?php echo $oyo_sig['ownership']=='No'?"selected":""; ?> value="No">No</option>
												<option sig_val=5 <?php echo $oyo_sig['ownership']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
										<td colspan=2><select class="form-control" id="sig_remarks18" name="data[remarks18]" ><option value="<?php echo $oyo_sig['remarks18']?>"><?php echo $oyo_sig['remarks18']?></option><option value="">-Select-</option></select></td>
									</tr>
									<tr>
										<td colspan=2>5.6 Send correct resolution email</td>
										<td>4</td>
										<td>
											<select class="form-control sig_point" id="send_correct_resolution" name="data[correct_email]" required>
												<option sig_val=4 <?php echo $oyo_sig['correct_email']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option sig_val=0 <?php echo $oyo_sig['correct_email']=='No'?"selected":""; ?> value="No">No</option>
												<option sig_val=4 <?php echo $oyo_sig['correct_email']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
										<td colspan=2><select class="form-control" id="sig_remarks19" name="data[remarks19]" ><option value="<?php echo $oyo_sig['remarks19']?>"><?php echo $oyo_sig['remarks19']?></option><option value="">-Select-</option></select></td>
									</tr>
									<tr>
										<td rowspan=4 style="background-color:#A9CCE3; font-weight:bold">6. Documentation </td>
										<td colspan=2>6.1 Complete and correct notes (CRS/C-Zentrix/OYO desk)</td>
										<td>5</td>
										<td>
											<select class="form-control sig_point" id="complete_and_correct" name="data[correct_notes]" required>
												
												<option sig_val=5 <?php echo $oyo_sig['correct_notes']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option sig_val=0 <?php echo $oyo_sig['correct_notes']=='No'?"selected":""; ?> value="No">No</option>
												<option sig_val=5 <?php echo $oyo_sig['correct_notes']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
										<td colspan=2>
											<select class="form-control" id="sig_remarks20" name="data[remarks20]" >
												<option value="<?php echo $oyo_sig['remarks20']?>"><?php echo $oyo_sig['remarks20']?></option>
												<option value="">-Select-</option>
											</select>
										</td>
									</tr>
									<tr>
										<td colspan=2>6.2 Accurate Tagging of Issue Category and sub category</td>
										<td>10</td>
										<td>
											<select class="form-control sig_point" id="accurate_tagging_off" name="data[accurate_tagging]" required>
												<option sig_val=10 <?php echo $oyo_sig['accurate_tagging']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option sig_val=0 <?php echo $oyo_sig['accurate_tagging']=='No'?"selected":""; ?> value="No">No</option>
												<option sig_val=10 <?php echo $oyo_sig['accurate_tagging']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
										<td colspan=2><select class="form-control" id="sig_remarks21" name="data[remarks21]" ><option value="<?php echo $oyo_sig['remarks21']?>"><?php echo $oyo_sig['remarks21']?></option><option value="">-Select-</option></select></td>
									</tr>
									<tr>
										<td colspan=2>6.3 Call Disposed accurately on Czentrix</td>
										<td>3</td>
										<td>
											<select class="form-control sig_point" id="disposed_accurately" name="data[call_disposed]" required>
												<option sig_val=3 <?php echo $oyo_sig['call_disposed']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option sig_val=0 <?php echo $oyo_sig['call_disposed']=='No'?"selected":""; ?> value="No">No</option>
												<option sig_val=3 <?php echo $oyo_sig['call_disposed']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
										<td colspan=2><select class="form-control" id="sig_remarks22" name="data[remarks22]" ><option value="<?php echo $oyo_sig['remarks22']?>"><?php echo $oyo_sig['remarks22']?></option><option value="">-Select-</option></select></td>
									</tr>
									<tr>
										<td colspan=2>6.4 Correct Ticket Status and tagging of remaining fields in Oyo Desk</td>
										<td>3</td>
										<td>
											<select class="form-control sig_point" id="ticket_status" name="data[correct_ticket_status]" required>
												<option sig_val=3 <?php echo $oyo_sig['correct_ticket_status']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option sig_val=3 <?php echo $oyo_sig['correct_ticket_status']=='No'?"selected":""; ?> value="No">No</option>
												<option sig_val=3 <?php echo $oyo_sig['correct_ticket_status']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
										<td colspan=2><select class="form-control" id="sig_remarks23" name="data[remarks23]" ><option value="<?php echo $oyo_sig['remarks23']?>"><?php echo $oyo_sig['remarks23']?></option><option value="">-Select-</option></select></td>
									</tr>
									  <tr>
										<td rowspan=5 style="background-color:#A9CCE3; font-weight:bold">7. Call Closing</td>
										<td colspan=2>7.1 Pitched Need Help (YO) for self help</td>
										<td>2</td>
										<td>
											<select class="form-control sig_point" id="pitched_need_help" name="data[piched_need_help]" required>
												<option sig_val=2 <?php echo $oyo_sig['piched_need_help']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option sig_val=0 <?php echo $oyo_sig['piched_need_help']=='No'?"selected":""; ?> value="No">No</option>
												<option sig_val=2 <?php echo $oyo_sig['piched_need_help']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
										<td colspan=2>
											<select class="form-control" id="sig_remarks24" name="data[remarks24]" >
												<option value="<?php echo $oyo_sig['remarks24']?>"><?php echo $oyo_sig['remarks24']?></option>
												<option value="">-Select-</option>
											</select>
										</td>
									</tr>
									<tr>
										<td colspan=2>7.2 Further Assistance Asked</td>
										<td>1</td>
										<td>
											<select class="form-control sig_point" id="further_assistance" name="data[further_assistance]" required>
												<option sig_val=1 <?php echo $oyo_sig['further_assistance']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option sig_val=0 <?php echo $oyo_sig['further_assistance']=='No'?"selected":""; ?> value="No">No</option>
												<option sig_val=1 <?php echo $oyo_sig['further_assistance']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
										<td colspan=2><select class="form-control" id="sig_remarks25" name="data[remarks25]" ><option value="<?php echo $oyo_sig['remarks25']?>"><?php echo $oyo_sig['remarks25']?></option><option value="">-Select-</option></select></td>
									</tr>
									<tr>
										<td colspan=2>7.3 G-Sat Survey Effectively Pitched</td>
										<td>2</td>
										<td>
											<select class="form-control sig_point" id="survey_effectively" name="data[Gsat_survey_pitched]" required>
												
												<option sig_val=2 <?php echo $oyo_sig['Gsat_survey_pitched']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option sig_val=0 <?php echo $oyo_sig['Gsat_survey_pitched']=='No'?"selected":""; ?> value="No">No</option>
												<option sig_val=2 <?php echo $oyo_sig['Gsat_survey_pitched']=='NA'?"selected":""; ?> value="NA">NA</option>
												
											</select>
										</td>
										<td colspan=2><select class="form-control" id="sig_remarks26" name="data[remarks26]" ><option value="<?php echo $oyo_sig['remarks26']?>"><?php echo $oyo_sig['remarks26']?></option><option value="">-Select-</option></select></td>
									</tr>
									<tr>
										<td colspan=2>7.4 G- Sat Survey Avoidance</td>
										<td>3</td>
										<td>
											<select class="form-control sig_point" id="survey_avoidance" name="data[Gsat_survey_avoidance]" required>
												
												<option sig_val=3 <?php echo $oyo_sig['Gsat_survey_avoidance']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option sig_val=0 <?php echo $oyo_sig['Gsat_survey_avoidance']=='No'?"selected":""; ?> value="No">No</option>
												<option sig_val=3 <?php echo $oyo_sig['Gsat_survey_avoidance']=='NA'?"selected":""; ?> value="NA">NA</option>
												
											</select>
										</td>
										<td colspan=2><select class="form-control" id="sig_remarks27" name="data[remarks27]" ><option value="<?php echo $oyo_sig['remarks27']?>"><?php echo $oyo_sig['remarks27']?></option><option value="">-Select-</option></select></td>
									</tr>

									<tr>
										<td colspan=2>7.5 Closing done with branding of OYO</td>
										<td>1</td>
										<td>
											<select class="form-control sig_point" id="closing_done_with" name="data[closing_done_branding]" required>
												
												<option sig_val=1 <?php echo $oyo_sig['closing_done_branding']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option sig_val=0 <?php echo $oyo_sig['closing_done_branding']=='No'?"selected":""; ?> value="No">No</option>
												<option sig_val=1 <?php echo $oyo_sig['closing_done_branding']=='NA'?"selected":""; ?> value="NA">NA</option>
												
											</select>
										</td>
										<td colspan=2><select class="form-control" id="sig_remarks28" name="data[remarks28]" ><option value="<?php echo $oyo_sig['remarks28']?>"><?php echo $oyo_sig['remarks28']?></option><option value="">-Select-</option></select></td>
									</tr>
									<tr>
										<td rowspan=1 style="background-color:#A9CCE3; font-weight:bold">8 Process - Zero Tolerance</td>
										<td colspan=2>8.1 Process ZT - Back ground noise</td>
										<td></td>
										<td>
											<select class="form-control" id="back_ground_noise" name="data[back_ground_noise]" required>
												
												<option <?php echo $oyo_sig['back_ground_noise']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option <?php echo $oyo_sig['back_ground_noise']=='No'?"selected":""; ?> value="No">No</option>
												<option <?php echo $oyo_sig['back_ground_noise']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
										<td colspan=2>
											<select class="form-control" id="sig_remarks29" name="data[remarks29]" >
												<option value="<?php echo $oyo_sig['remarks29']?>"><?php echo $oyo_sig['remarks29']?></option>
												<option value="">-Select-</option>
											</select>
										</td>
									</tr>

									<tr>
										<td rowspan=9 style="background-color:#A9CCE3; font-weight:bold">9 Advisor - Actionable</td>
										<td colspan=2 style="color:red">Transaction was handled ethically - Call was not disconnected</td>
										<td></td>
										<td>
											<select class="form-control sig_point" id="handled_ethically" name="data[handled_ethically]" required>
												
												<option sig_val=0 <?php echo $oyo_sig['handled_ethically']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option sig_val=0 <?php echo $oyo_sig['handled_ethically']=='No'?"selected":""; ?> value="No">No</option>
												<option sig_val=0 <?php echo $oyo_sig['handled_ethically']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
										<td colspan=2></td>
									</tr>
									<tr>
										<td colspan=2 style="color:red">Agent maintained profanity on the call</td>
										<td></td>
										<td>
											<select class="form-control sig_point " id="maintained_profanity" name="data[maintained_profanity]" required>
												
												<option sig_val=0 <?php echo $oyo_sig['maintained_profanity']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option sig_val=0 <?php echo $oyo_sig['maintained_profanity']=='No'?"selected":""; ?> value="No">No</option>
												<option sig_val=0 <?php echo $oyo_sig['maintained_profanity']=='NA'?"selected":""; ?> value="NA">NA</option>
												
											</select>
										</td>
										<td colspan=2></td>
									</tr>
									<tr>
										<td colspan=2 style="color:red">Agent did not sounded sarcastic /degraded customer</td>
										<td></td>
										<td>
											<select class="form-control sig_point" id="sounded_sarcastic" name="data[sounded_sarcastic]" required>
												
												<option sig_val=0 <?php echo $oyo_sig['sounded_sarcastic']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option sig_val=0 <?php echo $oyo_sig['sounded_sarcastic']=='No'?"selected":""; ?> value="No">No</option>
												<option sig_val=0 <?php echo $oyo_sig['sounded_sarcastic']=='NA'?"selected":""; ?> value="NA">NA</option>
												
											</select>
										</td>
										<td colspan=2></td>
									</tr>
									<tr>
										<td colspan=2 style="color:red">Agent did not make False commitment to guest >> financial loss >>3000 INR</td>
										<td></td>
										<td>
											<select class="form-control sig_point" id="false_commitment" name="data[false_commitment]" required>
												
												<option sig_val=0 <?php echo $oyo_sig['false_commitment']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option sig_val=0 <?php echo $oyo_sig['false_commitment']=='No'?"selected":""; ?> value="No">No</option>
												<option sig_val=0 <?php echo $oyo_sig['false_commitment']=='NA'?"selected":""; ?> value="NA">NA</option>
												
											</select>
										</td>
										<td colspan=2></td>
									</tr>
									<tr>
										<td colspan=2 style="color:red">Agent did not Force Close ticket (No work done and case closed directly)</td>
										<td></td>
										<td>
											<select class="form-control sig_point" id="force_close_ticket" name="data[force_close_ticket]" required>
												
												<option sig_val=0 <?php echo $oyo_sig['force_close_ticket']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option sig_val=0 <?php echo $oyo_sig['force_close_ticket']=='No'?"selected":""; ?> value="No">No</option>
												<option sig_val=0 <?php echo $oyo_sig['force_close_ticket']=='NA'?"selected":""; ?> value="NA">NA</option>
												
											</select>
										</td>
										<td colspan=2></td>
									</tr>
									<tr>
										<td colspan=2 style="color:red">Agent raised escalation ticket on IB call</td>
										<td></td>
										<td>
											<select class="form-control sig_point" id="escalation_ticket" name="data[escalation_ticket]" required>
												
												<option sig_val=0 <?php echo $oyo_sig['escalation_ticket']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option sig_val=0 <?php echo $oyo_sig['escalation_ticket']=='No'?"selected":""; ?> value="No">No</option>
												<option sig_val=0 <?php echo $oyo_sig['escalation_ticket']=='NA'?"selected":""; ?> value="NA">NA</option>
												
											</select>
										</td>
										<td colspan=2></td>
									</tr>
									<tr>
										<td colspan=2 style="color:red">Agent raised duplicate tickets for the same category less than 14 days</td>
										<td></td>
										<td>
											<select class="form-control sig_point" id="duplicate_tickets" name="data[duplicate_tickets]" required>
												
												<option sig_val=0 <?php echo $oyo_sig['duplicate_tickets']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option sig_val=0 <?php echo $oyo_sig['duplicate_tickets']=='No'?"selected":""; ?> value="No">No</option>
												<option sig_val=0 <?php echo $oyo_sig['duplicate_tickets']=='NA'?"selected":""; ?> value="NA">NA</option>
												
											</select>
										</td>
										<td colspan=2></td>
									</tr>
									<tr>
										<td colspan=2 style="color:red">Agent adhered to Escalation matrix /Did not refuse next level escalation</td>
										<td></td>
										<td>
											<select class="form-control sig_point" id="escalation_matrix" name="data[escalation_matrix]" required>
												<option sig_val=0 <?php echo $oyo_sig['escalation_matrix']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option sig_val=0 <?php echo $oyo_sig['escalation_matrix']=='No'?"selected":""; ?> value="No">No</option>
												<option sig_val=0 <?php echo $oyo_sig['escalation_matrix']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
										<td colspan=2></td>
									</tr>
									<tr>
										<td colspan=2 style="color:red">Agent did not misuse hold protocol</td>
										<td></td>
										<td>
											<select class="form-control sig_point" id="misuse_hold_protocol" name="data[misuse_hold_protocol]" required>
												<option sig_val=0 <?php echo $oyo_sig['misuse_hold_protocol']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option sig_val=0 <?php echo $oyo_sig['misuse_hold_protocol']=='No'?"selected":""; ?> value="No">No</option>
												<option sig_val=0 <?php echo $oyo_sig['misuse_hold_protocol']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
										<td colspan=2></td>
									</tr>

									<tr>
										<td>Call Summary:</td>
										<td colspan=2><textarea class="form-control" id="" name="data[call_summary]"><?php echo $oyo_sig['call_summary'] ?></textarea></td>
										<td>Feedback:</td>
										<td colspan=2><textarea class="form-control" id="" name="data[feedback]"><?php echo $oyo_sig['feedback'] ?></textarea></td>
									</tr>
									<tr>
										<td colspan="2">Upload Files</td>
										<?php if($sig_id==0){ ?>
											<td colspan=4><input type="file" multiple class="form-control" id="attach_file" name="attach_file[]"></td>
										<?php }else{ 
											if($oyo_sig['attach_file']!=''){ ?>
											<td colspan="4">
												<?php $attach_file = explode(",",$oyo_sig['attach_file']);
												 foreach($attach_file as $mp){ ?>
													<audio controls='' style="background-color:#607F93"> 
													  <source src="<?php echo base_url(); ?>qa_files/qa_oyo_sig/sig_new/<?php echo $mp; ?>" type="audio/ogg">
													  <source src="<?php echo base_url(); ?>qa_files/qa_oyo_sig/sig_new/<?php echo $mp; ?>" type="audio/mpeg">
													</audio> </br>
												 <?php } ?>
											</td>
										<?php }else{
												echo '<td><b>No Files</b></td>';
											  }
										} ?>
									</tr>
									
									<?php if($sig_id!=0){ ?>
										<tr><td colspan=2 style="font-size:16px; font-weight:bold">Agent Review:</td><td colspan=4><?php echo $oyo_sig['agent_rvw_note'] ?></td></tr>
										<tr><td colspan=2 style="font-size:16px; font-weight:bold">Management Review:</td><td colspan=4><?php echo $oyo_sig['mgnt_rvw_note'] ?></td></tr>
										<tr><td colspan=2 style="font-size:16px; font-weight:bold">Client Review:</td><td colspan=4><?php echo $oyo_sig['client_rvw_note'] ?></td></tr>
										
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
											if(is_available_qa_feedback($oyo_sig['entry_date'],72) == true){ ?>
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