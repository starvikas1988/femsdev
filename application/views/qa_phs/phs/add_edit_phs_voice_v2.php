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

.eml1{
	font-weight:bold;
	background-color:#F8C471;
}

.prm1{
	font-weight:bold;
	background-color:#5DADE2;
}
</style>

<?php if($voice_id!=0){
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
										<td colspan="7" id="theader" style="font-size:40px">Premier Health Solutions [Voice Version 2]</td>
										<input type="hidden" name="audit_start_time" value="<?php echo CurrMySqlDate(); ?>">
									</tr>
									<?php
										if($voice_id==0){
											$auditorName = get_username();
											$auditDate = CurrDateMDY();
											$clDate_val='';
										}else{
											if($phs_voice_v2['entry_by']!=''){
												$auditorName = $phs_voice_v2['auditor_name'];
											}else{
												$auditorName = $phs_voice_v2['client_name'];
											}
											$auditDate = mysql2mmddyy($phs_voice_v2['audit_date']);
											$clDate_val = mysql2mmddyy($phs_voice_v2['call_date']);
										}
									?>
									<tr>
										<td>Auditor Name:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control" value="<?php echo $auditorName; ?>" disabled></td>
										<td>Audit Date:<span style="font-size:24px;color:red">*</span></td>
										<td colspan="2"><input type="text" class="form-control" value="<?php echo $auditDate; ?>" disabled></td>
										<td>Call Date:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control" onkeydown="return false;" id="call_date" name="call_date" value="<?php echo $clDate_val; ?>" required></td>
									</tr>
									<tr>
										<td>Agent:<span style="font-size:24px;color:red">*</span></td>
										<td>
											<select class="form-control" id="agent_id" name="data[agent_id]" required >
												<?php
												if($phs_voice_v2['agent_id']!=''){
													?>
													<option value="<?php echo $phs_voice_v2['agent_id'] ?>"><?php echo $phs_voice_v2['fname']." ".$phs_voice_v2['lname'] ?></option>
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
										<td colspan="2"><input type="text" class="form-control" id="fusion_id" value="<?php echo $phs_voice_v2['fusion_id'] ?>" readonly ></td>
										<td>L1 Supervisor:<span style="font-size:24px;color:red">*</span></td>
										<td>
											<select class="form-control" id="tl_id" name="data[tl_id]" required>
												<?php 
												if($phs_voice_v2['tl_id']!=''){
													?>
													<option value="<?php echo $phs_voice_v2['tl_id'] ?>"><?php echo $phs_voice_v2['tl_name'] ?></option>
													<?php
												}
												?>
												<option value="">--Select--</option>
												<?php foreach($tlname as $tl): ?>
													<option value="<?php echo $tl['id']; ?>"><?php echo $tl['fname']." ".$tl['lname']; ?></option>
												<?php endforeach; ?>	
											</select>
										</td>
									</tr>
									<tr>
										<td>Channel:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control" name="data[channel]" value="<?php echo $phs_voice_v2['channel'] ?>" required ></td>
										<td>File Number:<span style="font-size:24px;color:red">*</span></td>
										<td colspan="2"><input type="text" class="form-control" name="data[file_no]" value="<?php echo $phs_voice_v2['file_no'] ?>" required ></td>
										<td>Time stamp/ Link:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control" name="data[link]" value="<?php echo $phs_voice_v2['link'] ?>" required ></td>
									</tr>
									<tr>
										<td>ACPT:<span style="font-size:24px;color:red">*</span></td>
										<td>
											<select class="form-control" name="data[acpt]" required>
												<?php
												if($phs_voice_v2['acpt']!=''){
													?>
													<option value="<?php echo $phs_voice_v2['acpt'] ?>"><?php echo $phs_voice_v2['acpt'] ?></option>
													<?php	
												}
												?>
												<option value="">-Select-</option>
												<option value="Agent">Agent</option>
												<option value="Customer">Customer</option>
												<option value="Process">Process</option>
												<option value="Technology">Technology</option>
											</select>
										</td>
										<td>ZTP:<span style="font-size:24px;color:red">*</span></td>
										<td colspan="2">
											<select class="form-control" name="data[ztp]" required>
												<?php
												if($phs_voice_v2['ztp']!=''){
													?>
													<option value="<?php echo $phs_voice_v2['ztp'] ?>"><?php echo $phs_voice_v2['ztp'] ?></option>
													<?php	
												}
												?>
												<option value="Yes">Yes</option>
												<option value="No">No</option>
											</select>
										</td>
										<td>Member ID:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control" name="data[member_id]" value="<?php echo $phs_voice_v2['member_id'] ?>" required ></td>
									</tr>
									<tr>
										<td>Call Type:<span style="font-size:24px;color:red">*</span></td>
										<td>
											<select class="form-control" name="data[call_type]" required>
												<?php
												if($phs_voice_v2['call_type']!=''){
													?>
													<option value="<?php echo $phs_voice_v2['call_type'] ?>"><?php echo $phs_voice_v2['call_type'] ?></option>
													<?php	
												}
												?>
												
												<option value="">-Select-</option>
												<option value="Cancellation">Cancellation</option>
												<option value="Refund">Refund</option>
												<option value="Benefits and Eligibility">Benefits and Eligibility</option>
												<option value="Billing">Billing</option>
												<option value="Member Portal">Member Portal</option>
												<option value="Claims">Claims</option>
												<option value="General Inquiry">General Inquiry</option>
												<option value="ID Cards">ID Cards</option>
												<option value="Reinstatement">Reinstatement</option>
												<option value="Rollover">Rollover</option>
												<option value="Plan Upgrade">Plan Upgrade</option>
											</select>
										</td>
										<td>Caller Type:<span style="font-size:24px;color:red">*</span></td>
										<td colspan="2">
											<select class="form-control" name="data[caller_type]" required>
												<?php
												if($phs_voice_v2['caller_type']!=''){
													?>
													<option value="<?php echo $phs_voice_v2['caller_type'] ?>"><?php echo $phs_voice_v2['caller_type'] ?></option>
													<?php	
												}
												?>
												<option value="">-Select-</option>
												<option value="Member">Member</option>
												<option value="Provider">Provider</option>
											</select>
										</td>
										<td>PHS Product/Agency:<span style="font-size:24px;color:red">*</span></td>
										<td>
											<select class="form-control" name="data[product_agency]" required>
												<?php
												if($phs_voice_v2['product_agency']!=''){
													?>
													<option value="<?php echo $phs_voice_v2['product_agency'] ?>"><?php echo $phs_voice_v2['product_agency'] ?></option>
													<?php	
												}
												?>
												<option value="">-Select-</option>
												<option value="PHS-HD">PHS-HD</option>
												<option value="AWA">AWA</option>
												<option value="IMG">IMG</option>
												<option value="UNA">UNA</option>
												<option value="SGH">SGH</option>
											</select>
										</td>
									</tr>
									<tr>
										<td>Audit Type:<span style="font-size:24px;color:red">*</span></td>
										<td>
											<select class="form-control" id="audit_type" name="data[audit_type]" required>
												<?php
												if($phs_voice_v2['audit_type']!=''){
													?>
													<option value="<?php echo $phs_voice_v2['audit_type'] ?>"><?php echo $phs_voice_v2['audit_type'] ?></option>
													<?php	
												}
												?>
												
												<option value="">-Select-</option>
												<option value="CQ Audit">CQ Audit</option>
												<option value="BQ Audit">BQ Audit</option>
												<option value="Calibration">Calibration</option>
												<option value="Pre-Certificate Mock Call">Pre-Certificate Mock Call</option>
												<option value="Certification Audit">Certification Audit</option>
												<option value="Operation Audit">Operation Audit</option>
												<option value="Trainer Audit">Trainer Audit</option>
												<option value="Normal">Normal</option>
												<option value="Escalation">Escalation</option>
												<option value="WOW Call">WOW Call</option>
											</select>
										</td>
										<td class="auType">Auditor Type<span style="font-size:24px;color:red">*</span></td>
										<td colspan="2" class="auType">
											<select class="form-control" id="auditor_type" name="data[auditor_type]" required>
												<?php
												if($phs_voice_v2['auditor_type']!=''){
													?>
													<option value="<?php echo $phs_voice_v2['auditor_type'] ?>"><?php echo $phs_voice_v2['auditor_type'] ?></option>
													<?php	
												}
												?>
												<option value="">-Select-</option>
												<option value="Master">Master</option>
												<option value="Regular">Regular</option>
											</select>
										</td>
										<td>VOC:<span style="font-size:24px;color:red">*</span></td>
										<td>
											<select class="form-control" id="voc" name="data[voc]" required>
												<?php
												if($phs_voice_v2['voc']!=''){
													?>
													<option value="<?php echo $phs_voice_v2['voc'] ?>"><?php echo $phs_voice_v2['voc'] ?></option>
													<?php	
												}
												?>
												<option value="">-Select-</option>
												<option value="1">1</option>
												<option value="2">2</option>
												<option value="3">3</option>
												<option value="4">4</option>
												<option value="5">5</option>
												<option value="6">6</option>
												<option value="7">7</option>
												<option value="8">8</option>
												<option value="9">9</option>
												<option value="10">10</option>
											</select>
										</td>
									</tr>
									<tr>
										<td>Language:<span style="font-size:24px;color:red">*</span></td>
										<td>
											<select class="form-control" name="data[language]" required>
												<option value="">-Select-</option>
												<option <?php echo $phs_voice_v2['language'] == "English"?"selected":"";?> value="English">English</option>
												<option <?php echo $phs_voice_v2['language'] == "Spanish"?"selected":"";?> value="Spanish">Spanish</option>
											</select>
										</td>
									</tr>
									<tr>
										<td style="font-weight:bold; font-size:16px">Possible Score:</td>
										<td><input type="text" readonly id="phs_chatemail_possible" name="data[possible_score]" class="form-control" style="font-weight:bold" value="<?php echo $phs_voice_v2['possible_score'] ?>"></td>
										<td style="font-weight:bold; font-size:16px">Earned Score:</td>
										<td colspan="2"><input type="text" readonly id="phs_chatemail_earned" name="data[earned_score]" class="form-control" style="font-weight:bold" value="<?php echo $phs_voice_v2['earned_score'] ?>"></td>
										<td style="font-weight:bold; font-size:16px; text-align:right">Overall Score:</td>
										<td colspan="2"><input type="text" readonly id="phs_chatemail_overall" name="data[overall_score]" class="form-control phs_chatemail_v2Fatal" style="font-weight:bold" value="<?php echo $phs_voice_v2['overall_score'] ?>"></td>
									</tr>
									<tr style="height:18px; font-weight:bold"><td colspan=7 class="prm1">Critical / Immediate Fail</td></tr>
									<tr>
										<td class="prm1">1</td>
										<td class="eml1" colspan=2 style="color:red">Verified the name, address,phone #, email, and DOB (3 out of 4 required)</td>
										<td>
											<select class="form-control chatemail_pnt" id ="ajioAF1" name="data[verify_name_address]" required>
												<option value="">-Select-</option>
												<option phs_val=10 phs_max="10" <?php echo $phs_voice_v2['verify_name_address'] == "Completely"?"selected":"";?> value="Completely">Completely</option>
												<option phs_val=5 phs_max="10"<?php echo $phs_voice_v2['verify_name_address'] == "Partially"?"selected":"";?> value="Partially">Partially</option>
												<option phs_val=0 phs_max="10"<?php echo $phs_voice_v2['verify_name_address'] == "Fatal"?"selected":"";?> value="Fatal">Fatal</option>
												<option phs_val=0 phs_max="10"<?php echo $phs_voice_v2['verify_name_address'] == "TBD"?"selected":"";?> value="TBD">TBD</option>
												<option phs_val=0 phs_max="10"<?php echo $phs_voice_v2['verify_name_address'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td>H</td>
										<td>10</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt1]" value="<?php echo $phs_voice_v2['cmt1'] ?>"></td>
									</tr>
									<tr>
										<td class="prm1">2</td>
										<td class="eml1" colspan=2 style="color:red">Entered Interaction Notes in E123</td>
										<td>
											<select class="form-control chatemail_pnt" id ="ajioAF2" name="data[entraction_notes]" required>
												<option value="">-Select-</option>
												<option phs_val=10 phs_max="10"<?php echo $phs_voice_v2['entraction_notes'] == "Completely"?"selected":"";?> value="Completely">Completely</option>
												<option phs_val=5 phs_max="10"<?php echo $phs_voice_v2['entraction_notes'] == "Partially"?"selected":"";?> value="Partially">Partially</option>
												<option phs_val=0 phs_max="10"<?php echo $phs_voice_v2['entraction_notes'] == "Fatal"?"selected":"";?> value="Fatal">Fatal</option>
												<option phs_val=0 phs_max="10"<?php echo $phs_voice_v2['entraction_notes'] == "TBD"?"selected":"";?> value="TBD">TBD</option>
												<option phs_val=0 phs_max="10"<?php echo $phs_voice_v2['entraction_notes'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td>H</td>
										<td>10</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt2]" value="<?php echo $phs_voice_v2['cmt2'] ?>"></td>
									</tr>
									<tr>
										<td class="prm1">3</td>
										<td class="eml1" colspan=2 style="color:red">Did the CSR follow the Policy/Procedure correctly</td>
										<td>
											<select class="form-control chatemail_pnt" id ="ajioAF3"name="data[csr_policy]" required>
												<option value="">-Select-</option>
												<option phs_val=10 phs_max="10"<?php echo $phs_voice_v2['csr_policy'] == "Completely"?"selected":"";?> value="Completely">Completely</option>
												<option phs_val=5 phs_max="10"<?php echo $phs_voice_v2['csr_policy'] == "Partially"?"selected":"";?> value="Partially">Partially</option>
												<option phs_val=0 phs_max="10"<?php echo $phs_voice_v2['csr_policy'] == "Fatal"?"selected":"";?> value="Fatal">Fatal</option>
												<option phs_val=0 phs_max="10"<?php echo $phs_voice_v2['csr_policy'] == "TBD"?"selected":"";?> value="TBD">TBD</option>
												<option phs_val=0 phs_max="10"<?php echo $phs_voice_v2['csr_policy'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td>H</td>
										<td>10</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt3]" value="<?php echo $phs_voice_v2['cmt3'] ?>"></td>
									</tr>
									<tr>
										<td class="prm1">4</td>
										<td class="eml1" colspan=2 style="color:red">Did the CSR provide accurate information? (Correct information given without liability impact)</td>
										<td>
											<select class="form-control chatemail_pnt" id ="ajioAF4" name="data[accurate_information]" required>
												<option value="">-Select-</option>
												<option phs_val=10 phs_max="10"<?php echo $phs_voice_v2['accurate_information'] == "Completely"?"selected":"";?> value="Completely">Completely</option>
												<option phs_val=5 phs_max="10"<?php echo $phs_voice_v2['accurate_information'] == "Partially"?"selected":"";?> value="Partially">Partially</option>
												<option phs_val=0 phs_max="10"<?php echo $phs_voice_v2['accurate_information'] == "Fatal"?"selected":"";?> value="Fatal">Fatal</option>
												<option phs_val=0 phs_max="10"<?php echo $phs_voice_v2['accurate_information'] == "TBD"?"selected":"";?> value="TBD">TBD</option>
												<option phs_val=0 phs_max="10"<?php echo $phs_voice_v2['accurate_information'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td>H</td>
										<td>10</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt4]" value="<?php echo $phs_voice_v2['cmt4'] ?>"></td>
									</tr>
									<tr style="height:18px; font-weight:bold"><td colspan=7 class="prm1">Opening</td></tr>
									<tr>
										<td class="prm1">5</td>
										<td class="eml1" colspan=2>Appropriate greeting (advising this call may be recorded for quality assurance)</td>
										<td>
											<select class="form-control chatemail_pnt" name="data[appropriate_greeting]" required>
												<option value="">-Select-</option>
												<option phs_val=6 phs_max="6"<?php echo $phs_voice_v2['appropriate_greeting'] == "Completely"?"selected":"";?> value="Completely">Completely</option>
												<option phs_val=3 phs_max="6"<?php echo $phs_voice_v2['appropriate_greeting'] == "Partially"?"selected":"";?> value="Partially">Partially</option>
												<option phs_val=0 phs_max="6"<?php echo $phs_voice_v2['appropriate_greeting'] == "Not at all"?"selected":"";?> value="Not at all">Not at all</option>
												<option phs_val=0 phs_max="6"<?php echo $phs_voice_v2['appropriate_greeting'] == "TBD"?"selected":"";?> value="TBD">TBD</option>
												<option phs_val=0 phs_max="6"<?php echo $phs_voice_v2['appropriate_greeting'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td>M</td>
										<td>6</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt5]" value="<?php echo $phs_voice_v2['cmt5'] ?>"></td>
									</tr>
									<tr>
										<td class="prm1">6</td>
										<td class="eml1" colspan=2 style="color:red">Provider Call - Ask for the PROVIDER's name and the name of the facility</td>
										<td>
											<select class="form-control chatemail_pnt" name="data[provider_call]" id ="ajioAF5" required>
												<option value="">-Select-</option>
												<option phs_val=10 phs_max="10"<?php echo $phs_voice_v2['provider_call'] == "Completely"?"selected":"";?> value="Completely">Completely</option>
												<option phs_val=5 phs_max="10"<?php echo $phs_voice_v2['provider_call'] == "Partially"?"selected":"";?> value="Partially">Partially</option>
												<option phs_val=0 phs_max="10"<?php echo $phs_voice_v2['provider_call'] == "Fatal"?"selected":"";?> value="Fatal">Fatal</option>
												<option phs_val=0 phs_max="10"<?php echo $phs_voice_v2['provider_call'] == "TBD"?"selected":"";?> value="TBD">TBD</option>
												<option phs_val=0 phs_max="10"<?php echo $phs_voice_v2['provider_call'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td>H</td>
										<td>10</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt6]" value="<?php echo $phs_voice_v2['cmt6'] ?>"></td>
									</tr>
									<tr>
										<td class="prm1">7</td>
										<td class="eml1" colspan=2 style="color:red">Obtain call back number</td>
										<td>
											<select class="form-control chatemail_pnt" name="data[call_back_number]" id ="ajioAF6" required>
												<option value="">-Select-</option>
												<option phs_val=10 phs_max="10"<?php echo $phs_voice_v2['call_back_number'] == "Completely"?"selected":"";?> value="Completely">Completely</option>
												<option phs_val=5 phs_max="10"<?php echo $phs_voice_v2['call_back_number'] == "Partially"?"selected":"";?> value="Partially">Partially</option>
												<option phs_val=0 phs_max="10"<?php echo $phs_voice_v2['call_back_number'] == "Fatal"?"selected":"";?> value="Fatal">Fatal</option>
												<option phs_val=0 phs_max="10"<?php echo $phs_voice_v2['call_back_number'] == "TBD"?"selected":"";?> value="TBD">TBD</option>
												<option phs_val=0 phs_max="10"<?php echo $phs_voice_v2['call_back_number'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td>H</td>
										<td>10</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt7]" value="<?php echo $phs_voice_v2['cmt7'] ?>"></td>
									</tr>

									<tr style="height:18px; font-weight:bold"><td colspan=7 class="prm1">Rapport</td></tr>
									<tr>
										<td class="prm1">8</td>
										<td class="eml1" colspan=2>Did the CSR meet the expectations set during the interaction (hold time)</td>
										<td>
											<select class="form-control chatemail_pnt" name="data[hold_time]" required>
												<option value="">-Select-</option>
												<option phs_val=6 phs_max="6"<?php echo $phs_voice_v2['hold_time'] == "Completely"?"selected":"";?> value="Completely">Completely</option>
												<option phs_val=3 phs_max="6"<?php echo $phs_voice_v2['hold_time'] == "Partially"?"selected":"";?> value="Partially">Partially</option>
												<option phs_val=0 phs_max="6"<?php echo $phs_voice_v2['hold_time'] == "Not at all"?"selected":"";?> value="Not at all">Not at all</option>
												<option phs_val=0 phs_max="6"<?php echo $phs_voice_v2['hold_time'] == "TBD"?"selected":"";?> value="TBD">TBD</option>
												<option phs_val=0 phs_max="6"<?php echo $phs_voice_v2['hold_time'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td>M</td>
										<td>6</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt8]" value="<?php echo $phs_voice_v2['cmt8'] ?>"></td>
									</tr>
									<tr>
										<td class="prm1">9</td>
										<td class="eml1" colspan=2>Was the CSR Words/Statements/Polite/Positive/Professional</td>
										<td>
											<select class="form-control chatemail_pnt" name="data[csr_statement]" required>
												<option value="">-Select-</option>
												<option phs_val=6 phs_max="6"<?php echo $phs_voice_v2['csr_statement'] == "Completely"?"selected":"";?> value="Completely">Completely</option>
												<option phs_val=3 phs_max="6"<?php echo $phs_voice_v2['csr_statement'] == "Partially"?"selected":"";?> value="Partially">Partially</option>
												<option phs_val=0 phs_max="6"<?php echo $phs_voice_v2['csr_statement'] == "Not at all"?"selected":"";?> value="Not at all">Not at all</option>
												<option phs_val=0 phs_max="6"<?php echo $phs_voice_v2['csr_statement'] == "TBD"?"selected":"";?> value="TBD">TBD</option>
												<option phs_val=0 phs_max="6"<?php echo $phs_voice_v2['csr_statement'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td>M</td>
										<td>6</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt9]" value="<?php echo $phs_voice_v2['cmt9'] ?>"></td>
									</tr>
									<tr>
										<td class="prm1">10</td>
										<td class="eml1" colspan=2>Express Empathy/Understanding</td>
										<td>
											<select class="form-control chatemail_pnt" name="data[empathy]" required>
												<option value="">-Select-</option>
												<option phs_val=6 phs_max="6"<?php echo $phs_voice_v2['empathy'] == "Completely"?"selected":"";?> value="Completely">Completely</option>
												<option phs_val=3 phs_max="6"<?php echo $phs_voice_v2['empathy'] == "Partially"?"selected":"";?> value="Partially">Partially</option>
												<option phs_val=0 phs_max="6"<?php echo $phs_voice_v2['empathy'] == "Not at all"?"selected":"";?> value="Not at all">Not at all</option>
												<option phs_val=0 phs_max="6"<?php echo $phs_voice_v2['empathy'] == "TBD"?"selected":"";?> value="TBD">TBD</option>
												<option phs_val=0 phs_max="6"<?php echo $phs_voice_v2['empathy'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td>M</td>
										<td>6</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt10]" value="<?php echo $phs_voice_v2['cmt10'] ?>"></td>
									</tr>

									<tr style="height:18px; font-weight:bold"><td colspan=7 class="prm1">Call Handling</td></tr>
									<tr>
										<td class="prm1">11</td>
										<td class="eml1" colspan=2>Active Listening</td>
										<td>
											<select class="form-control chatemail_pnt" name="data[active_listening]" required>
												<option value="">-Select-</option>
												<option phs_val=6 phs_max="6"<?php echo $phs_voice_v2['active_listening'] == "Completely"?"selected":"";?> value="Completely">Completely</option>
												<option phs_val=3 phs_max="6"<?php echo $phs_voice_v2['active_listening'] == "Partially"?"selected":"";?> value="Partially">Partially</option>
												<option phs_val=0 phs_max="6"<?php echo $phs_voice_v2['active_listening'] == "Not at all"?"selected":"";?> value="Not at all">Not at all</option>
												<option phs_val=0 phs_max="6"<?php echo $phs_voice_v2['active_listening'] == "TBD"?"selected":"";?> value="TBD">TBD</option>
												<option phs_val=0 phs_max="6"<?php echo $phs_voice_v2['active_listening'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td>M</td>
										<td>6</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt11]" value="<?php echo $phs_voice_v2['cmt11'] ?>"></td>
									</tr>
									<tr>
										<td class="prm1">12</td>
										<td class="eml1" colspan=2>Did the CSR prevent unexplained dead air</td>
										<td>
											<select class="form-control chatemail_pnt" name="data[dead_air]" required>
												<option value="">-Select-</option>
												<option phs_val=2 phs_max="2"<?php echo $phs_voice_v2['dead_air'] == "Completely"?"selected":"";?> value="Completely">Completely</option>
												<option phs_val=1 phs_max="2"<?php echo $phs_voice_v2['dead_air'] == "Partially"?"selected":"";?> value="Partially">Partially</option>
												<option phs_val=0 phs_max="2"<?php echo $phs_voice_v2['dead_air'] == "Not at all"?"selected":"";?> value="Not at all">Not at all</option>
												<option phs_val=0 phs_max="2"<?php echo $phs_voice_v2['dead_air'] == "TBD"?"selected":"";?> value="TBD">TBD</option>
												<option phs_val=0 phs_max="2"<?php echo $phs_voice_v2['dead_air'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td>L</td>
										<td>2</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt12]" value="<?php echo $phs_voice_v2['cmt12'] ?>"></td>
									</tr>
									<tr>
										<td class="prm1">13</td>
										<td class="eml1" colspan=2>Good Hold/Transfer Etiquette</td>
										<td>
											<select class="form-control chatemail_pnt" name="data[transfer_etiquette]" required>
												<option value="">-Select-</option>
												<option phs_val=2 phs_max="2"<?php echo $phs_voice_v2['transfer_etiquette'] == "Completely"?"selected":"";?> value="Completely">Completely</option>
												<option phs_val=1 phs_max="2"<?php echo $phs_voice_v2['transfer_etiquette'] == "Partially"?"selected":"";?> value="Partially">Partially</option>
												<option phs_val=0 phs_max="2"<?php echo $phs_voice_v2['transfer_etiquette'] == "Not at all"?"selected":"";?> value="Not at all">Not at all</option>
												<option phs_val=0 phs_max="2"<?php echo $phs_voice_v2['transfer_etiquette'] == "TBD"?"selected":"";?> value="TBD">TBD</option>
												<option phs_val=0 phs_max="2"<?php echo $phs_voice_v2['transfer_etiquette'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td>L</td>
										<td>2</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt13]" value="<?php echo $phs_voice_v2['cmt13'] ?>"></td>
									</tr>
									<tr>
										<td class="prm1">14</td>
										<td class="eml1" colspan=2>Demonstrate control of call</td>
										<td>
											<select class="form-control chatemail_pnt" name="data[control_of_call]" required>
												<option value="">-Select-</option>
												<option phs_val=6 phs_max="6"<?php echo $phs_voice_v2['control_of_call'] == "Completely"?"selected":"";?> value="Completely">Completely</option>
												<option phs_val=3 phs_max="6"<?php echo $phs_voice_v2['control_of_call'] == "Partially"?"selected":"";?> value="Partially">Partially</option>
												<option phs_val=0 phs_max="6"<?php echo $phs_voice_v2['control_of_call'] == "Not at all"?"selected":"";?> value="Not at all">Not at all</option>
												<option phs_val=0 phs_max="6"<?php echo $phs_voice_v2['control_of_call'] == "TBD"?"selected":"";?> value="TBD">TBD</option>
												<option phs_val=0 phs_max="6"<?php echo $phs_voice_v2['control_of_call'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td>M</td>
										<td>6</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt14]" value="<?php echo $phs_voice_v2['cmt14'] ?>"></td>
									</tr>
									<tr>
										<td class="prm1">15</td>
										<td class="eml1" colspan=2>Did the CSR allow the member/provider/caller to speak without interrupting</td>
										<td>
											<select class="form-control chatemail_pnt business" name="data[speak_without_interrupting]" required>
												<option value="">-Select-</option>
												<option phs_val=6 phs_max="6"<?php echo $phs_voice_v2['speak_without_interrupting'] == "Completely"?"selected":"";?> value="Completely">Completely</option>
												<option phs_val=3 phs_max="6"<?php echo $phs_voice_v2['speak_without_interrupting'] == "Partially"?"selected":"";?> value="Partially">Partially</option>
												<option phs_val=0 phs_max="6"<?php echo $phs_voice_v2['speak_without_interrupting'] == "Not at all"?"selected":"";?> value="Not at all">Not at all</option>
												<option phs_val=0 phs_max="6"<?php echo $phs_voice_v2['speak_without_interrupting'] == "TBD"?"selected":"";?> value="TBD">TBD</option>
												<option phs_val=0 phs_max="6"<?php echo $phs_voice_v2['speak_without_interrupting'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td>M</td>
										<td>6</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt15]" value="<?php echo $phs_voice_v2['cmt15'] ?>"></td>
									</tr>
									<tr style="height:18px; font-weight:bold"><td colspan=7 class="prm1">Knowledge</td></tr>
									<tr>
										<td class="prm1">16</td>
										<td class="eml1" colspan=2>Did the CSR review all interactions, history, billing, finance, and AOR notes</td>
										<td>
											<select class="form-control chatemail_pnt" name="data[csr_review]" required>
												<option value="">-Select-</option>
												<option phs_val=6 phs_max="6"<?php echo $phs_voice_v2['csr_review'] == "Completely"?"selected":"";?> value="Completely">Completely</option>
												<option phs_val=3 phs_max="6"<?php echo $phs_voice_v2['csr_review'] == "Partially"?"selected":"";?> value="Partially">Partially</option>
												<option phs_val=0 phs_max="6"<?php echo $phs_voice_v2['csr_review'] == "Not at all"?"selected":"";?> value="Not at all">Not at all</option>
												<option phs_val=0 phs_max="6"<?php echo $phs_voice_v2['csr_review'] == "TBD"?"selected":"";?> value="TBD">TBD</option>
												<option phs_val=0 phs_max="6"<?php echo $phs_voice_v2['csr_review'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td>M</td>
										<td>6</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt16]" value="<?php echo $phs_voice_v2['cmt16'] ?>"></td>
									</tr>
									<tr>
										<td class="prm1">17</td>
										<td class="eml1" colspan=2>Does the CSR have a good understanding of the products/benefits</td>
										<td>
											<select class="form-control chatemail_pnt" name="data[products_benefits]" required>
												<option value="">-Select-</option>
												<option phs_val=6 phs_max="6"<?php echo $phs_voice_v2['products_benefits'] == "Completely"?"selected":"";?> value="Completely">Completely</option>
												<option phs_val=3 phs_max="6"<?php echo $phs_voice_v2['products_benefits'] == "Partially"?"selected":"";?> value="Partially">Partially</option>
												<option phs_val=0 phs_max="6"<?php echo $phs_voice_v2['products_benefits'] == "Not at all"?"selected":"";?> value="Not at all">Not at all</option>
												<option phs_val=0 phs_max="6"<?php echo $phs_voice_v2['products_benefits'] == "TBD"?"selected":"";?> value="TBD">TBD</option>
												<option phs_val=0 phs_max="6"<?php echo $phs_voice_v2['products_benefits'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td>M</td>
										<td>6</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt17]" value="<?php echo $phs_voice_v2['cmt17'] ?>"></td>
									</tr>
									<tr>
										<td class="prm1">18</td>
										<td class="eml1" colspan=2>Asked probing questions</td>
										<td>
											<select class="form-control chatemail_pnt" name="data[probing_questions]" required>
												<option value="">-Select-</option>
												<option phs_val=6 phs_max="6"<?php echo $phs_voice_v2['probing_questions'] == "Completely"?"selected":"";?> value="Completely">Completely</option>
												<option phs_val=3 phs_max="6"<?php echo $phs_voice_v2['probing_questions'] == "Partially"?"selected":"";?> value="Partially">Partially</option>
												<option phs_val=0 phs_max="6"<?php echo $phs_voice_v2['probing_questions'] == "Not at all"?"selected":"";?> value="Not at all">Not at all</option>
												<option phs_val=0 phs_max="6"<?php echo $phs_voice_v2['probing_questions'] == "TBD"?"selected":"";?> value="TBD">TBD</option>
												<option phs_val=0 phs_max="6"<?php echo $phs_voice_v2['probing_questions'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td>M</td>
										<td>6</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt18]" value="<?php echo $phs_voice_v2['cmt18'] ?>"></td>
									</tr>
									<tr>
										<td class="prm1">19</td>
										<td class="eml1" colspan=2>Was the reason for the call addressed fully according to policy?</td>
										<td>
											<select class="form-control chatemail_pnt" name="data[reason_for_call]" required>
												<option value="">-Select-</option>
												<option phs_val=10 phs_max="10"<?php echo $phs_voice_v2['reason_for_call'] == "Completely"?"selected":"";?> value="Completely">Completely</option>
												<option phs_val=5 phs_max="10"<?php echo $phs_voice_v2['reason_for_call'] == "Partially"?"selected":"";?> value="Partially">Partially</option>
												<option phs_val=0 phs_max="10"<?php echo $phs_voice_v2['reason_for_call'] == "Not at all"?"selected":"";?> value="Not at all">Not at all</option>
												<option phs_val=0 phs_max="10"<?php echo $phs_voice_v2['reason_for_call'] == "TBD"?"selected":"";?> value="TBD">TBD</option>
												<option phs_val=0 phs_max="10"<?php echo $phs_voice_v2['reason_for_call'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td>H</td>
										<td>10</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt19]" value="<?php echo $phs_voice_v2['cmt19'] ?>"></td>
									</tr>

									<tr style="height:18px; font-weight:bold"><td colspan=7 class="prm1">Closing</td></tr>
									<tr>
										<td class="prm1">20</td>
										<td class="eml1" colspan=2>Call Recap (Summary of the call)</td>
										<td>
											<select class="form-control chatemail_pnt" name="data[call_recap]" required>
												<option value="">-Select-</option>
												<option phs_val=2 phs_max="2"<?php echo $phs_voice_v2['call_recap'] == "Completely"?"selected":"";?> value="Completely">Completely</option>
												<option phs_val=1 phs_max="2"<?php echo $phs_voice_v2['call_recap'] == "Partially"?"selected":"";?> value="Partially">Partially</option>
												<option phs_val=0 phs_max="2"<?php echo $phs_voice_v2['call_recap'] == "Not at all"?"selected":"";?> value="Not at all">Not at all</option>
												<option phs_val=0 phs_max="2"<?php echo $phs_voice_v2['call_recap'] == "TBD"?"selected":"";?> value="TBD">TBD</option>
												<option phs_val=0 phs_max="2"<?php echo $phs_voice_v2['call_recap'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td>L</td>
										<td>2</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt20]" value="<?php echo $phs_voice_v2['cmt20'] ?>"></td>
									</tr>
									<tr>
										<td class="prm1">21</td>
										<td class="eml1" colspan=2>Inquired if additional assistance was needed</td>
										<td>
											<select class="form-control chatemail_pnt" name="data[additional_assistance]" required>
												<option value="">-Select-</option>
												<option phs_val=6 phs_max="6"<?php echo $phs_voice_v2['additional_assistance'] == "Completely"?"selected":"";?> value="Completely">Completely</option>
												<option phs_val=3 phs_max="6"<?php echo $phs_voice_v2['additional_assistance'] == "Partially"?"selected":"";?> value="Partially">Partially</option>
												<option phs_val=0 phs_max="6"<?php echo $phs_voice_v2['additional_assistance'] == "Not at all"?"selected":"";?> value="Not at all">Not at all</option>
												<option phs_val=0 phs_max="6"<?php echo $phs_voice_v2['additional_assistance'] == "TBD"?"selected":"";?> value="TBD">TBD</option>
												<option phs_val=0 phs_max="6"<?php echo $phs_voice_v2['additional_assistance'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td>M</td>
										<td>6</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt21]" value="<?php echo $phs_voice_v2['cmt21'] ?>"></td>
									</tr>
									<tr>
										<td class="prm1">22</td>
										<td class="eml1" colspan=2>Updated information correctly in E123 (NBD, Payment Information, Address Changes, etc.)</td>
										<td>
											<select class="form-control chatemail_pnt" name="data[updated_information]" required>
												<option value="">-Select-</option>
												<option phs_val=6 phs_max="6"<?php echo $phs_voice_v2['updated_information'] == "Completely"?"selected":"";?> value="Completely">Completely</option>
												<option phs_val=3 phs_max="6"<?php echo $phs_voice_v2['updated_information'] == "Partially"?"selected":"";?> value="Partially">Partially</option>
												<option phs_val=0 phs_max="6"<?php echo $phs_voice_v2['updated_information'] == "Not at all"?"selected":"";?> value="Not at all">Not at all</option>
												<option phs_val=0 phs_max="6"<?php echo $phs_voice_v2['updated_information'] == "TBD"?"selected":"";?> value="TBD">TBD</option>
												<option phs_val=0 phs_max="6"<?php echo $phs_voice_v2['updated_information'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td>M</td>
										<td>6</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt22]" value="<?php echo $phs_voice_v2['cmt22'] ?>"></td>
									</tr>
									<tr>
										<td class="prm1">23</td>
										<td class="eml1" colspan=2>Offered help above & beyond</td>
										<td>
											<select class="form-control chatemail_pnt" name="data[offer_help]" required>
												<option value="">-Select-</option>
												<option phs_val=2 phs_max="2"<?php echo $phs_voice_v2['offer_help'] == "Completely"?"selected":"";?> value="Completely">Completely</option>
												<option phs_val=1 phs_max="2"<?php echo $phs_voice_v2['offer_help'] == "Partially"?"selected":"";?> value="Partially">Partially</option>
												<option phs_val=0 phs_max="2"<?php echo $phs_voice_v2['offer_help'] == "Not at all"?"selected":"";?> value="Not at all">Not at all</option>
												<option phs_val=0 phs_max="2"<?php echo $phs_voice_v2['offer_help'] == "TBD"?"selected":"";?> value="TBD">TBD</option>
												<option phs_val=0 phs_max="2"<?php echo $phs_voice_v2['offer_help'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td>L</td>
										<td>2</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt23]" value="<?php echo $phs_voice_v2['cmt23'] ?>"></td>
									</tr>
									<tr>
										<td>Call Summary:</td>
										<td colspan="2"><textarea class="form-control"   name="data[call_summary]"><?php echo $phs_voice_v2['call_summary'] ?></textarea></td>
										<td>Feedback:</td>
										<td colspan="3"><textarea class="form-control"   name="data[feedback]"><?php echo $phs_voice_v2['feedback'] ?></textarea></td>
									</tr>
									
									<tr>
										<td colspan=2>Upload Files (mp3|avi|mp4|wmv|wav)</td>
										<?php if($voice_id==0){ ?>
											<td colspan=5><input type="file" multiple class="form-control" id="attach_file" name="attach_file[]"></td>
										<?php }else{
											if($phs_voice_v2['attach_file']!=''){ ?>
												<td colspan=5>
													<?php $attach_file = explode(",",$phs_voice_v2['attach_file']);
													 foreach($attach_file as $mp){ ?>
														<audio controls='' style="background-color:#607F93"> 
														  <source src="<?php echo base_url(); ?>qa_files/qa_phs/phs/<?php echo $mp; ?>" type="audio/ogg">
														  <source src="<?php echo base_url(); ?>qa_files/qa_phs/phs/<?php echo $mp; ?>" type="audio/mpeg">
														</audio> </br>
													 <?php } ?>
												</td>
										<?php }else{
												echo '<td colspan=6><b>No Files</b></td>';
											  }
										} ?>
									</tr>
									<?php  if($voice_id!=0){
										if($phs_voice_v2['entry_by']==get_user_id()){ ?>
											<tr><td colspan=2>Edit Upload (mp3|avi|mp4|wmv|wav)</td><td colspan=5><input type="file" multiple class="form-control1" id="fileuploadbasic" name="attach_file[]"></td></tr>
									<?php } 
									} ?>
									
									<?php if($voice_id!=0){ ?>
										<tr><td colspan=2 style="font-size:16px; font-weight:bold">Agent Feedback Acceptance:</td><td colspan=5><?php echo $phs_voice_v2['agnt_fd_acpt'] ?></td></tr>
										<tr><td colspan=2 style="font-size:16px; font-weight:bold">Agent Review:</td><td colspan=5><?php echo $phs_voice_v2['agent_rvw_note'] ?></td></tr>
										<tr><td colspan=2 style="font-size:16px; font-weight:bold">Management Review:</td><td colspan=5><?php echo $phs_voice_v2['mgnt_rvw_note'] ?></td></tr>
										<tr><td colspan=2 style="font-size:16px; font-weight:bold">Client Review:</td><td colspan=5><?php echo $phs_voice_v2['client_rvw_note'] ?></td></tr>
										
										<tr><td colspan=2  style="font-size:16px">Your Review<span style="font-size:24px;color:red">*</span></td><td colspan=5><textarea class="form-control1" style="width:100%" id="note" name="note" required></textarea></td></tr>
									<?php } ?>
									
									<?php 
									if($voice_id==0){
										if(is_access_qa_module()==true || is_access_qa_operations_module()==true){ ?>
											<tr><td colspan=7><button class="btn btn-success waves-effect" type="submit" id="qaformsubmit" style="width:500px">SAVE</button></td></tr>
									<?php 
										} 
									}else{ 
										if(is_access_qa_module()==true || is_access_qa_operations_module()==true){
											if(is_available_qa_feedback($phs_voice_v2['entry_date'],72) == true){ ?>
												<tr><td colspan="7"><button class="btn btn-success waves-effect" type="submit" id='qaformsubmit' name='btnSave' value="SAVE" style="width:500px">SAVE</button></td></tr>
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
