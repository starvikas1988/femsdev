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
	background-color:#85C1E9;
}
.ui-datepicker .ui-datepicker-buttonpane button.ui-datepicker-current {
	 float: left;
	 display: none;
	}

</style>

<?php if($urban_piper_tech_id!=0){
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
							<table class="table  skt-table" width="100%">
								<tbody>
									<tr>
										<td colspan="6" id="theader" style="font-size:40px;text-align: center;background-color: #1948E0  ; color:white;">Urban Piper Tech Support Audit Form</td>
										<input type="hidden" name="audit_start_time" value="<?php echo CurrMySqlDate(); ?>">
									</tr>
									<?php
										if($urban_piper_tech_id==0){
											$auditorName = get_username();
											$auditDate = CurrDateMDY();
											$clDate_val='';
											$call_duration='';
											//$dobDate_val='';
										}else{
											if($urban_piper_tech_data['entry_by']!=''){
												$auditorName = $urban_piper_tech_data['auditor_name'];
											}else{
												$auditorName = $urban_piper_tech_data['client_name'];
											}
											$auditDate = mysql2mmddyy($urban_piper_tech_data['audit_date']);
											$clDate_val = mysqlDt2mmddyy($urban_piper_tech_data['call_date']);
											$call_duration = $urban_piper_tech_data['call_duration'];
											//$dobDate_val = mysql2mmddyy($urban_piper_tech_data['dob']);
										}
									?>
									<tr>
										<td style="width:16%">Auditor Name: <span style="font-size:24px;color:red">*</span></td>
										<td style="width:16%"><input type="text" class="form-control" value="<?php echo $auditorName; ?>" disabled></td>
										<td style="width:16%">Audit Date: <span style="font-size:24px;color:red">*</span></td>
										<td style="width:16%"><input type="text" class="form-control" value="<?php echo $auditDate; ?>" disabled></td>
										<td style="width:16%">Call Date/Time: <span style="font-size:24px;color:red">*</span></td>
										<td style="width:16%"><input type="text" class="form-control" id="call_date_time" onkeydown="return false;" name="call_date" value="<?php echo $clDate_val; ?>" required></td>
									</tr>
									<tr>
										<td>Agent: <span style="font-size:24px;color:red">*</span></td>
										<td>
											<select class="form-control" id="agent_id" name="data[agent_id]" required >
												<option value="<?php echo $urban_piper_tech_data['agent_id'] ?>"><?php echo $urban_piper_tech_data['fname']." ".$urban_piper_tech_data['lname'] ?></option>
												<option value="">-Select-</option>
												<?php foreach($agentName as $row):  ?>
													<option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
												<?php endforeach; ?>
											</select>
										</td>
											<td>Fusion ID: <span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control" id="fusion_id" value="<?php echo $urban_piper_tech_data['fusion_id'] ?>" readonly ></td>
											<td>L1 Supervisor: <span style="font-size:24px;color:red">*</span></td>
										<td>

											<input type="text" class="form-control" id="tl_name"  value="<?php echo $urban_piper_tech_data['tl_name'] ?>" readonly>
											<input type="hidden" class="form-control" id="tl_id" name="data[tl_id]" value="<?php echo $urban_piper_tech_data['tl_id'] ?>" required>
										</td>
									</tr>
									<tr>
										<td>Ticket ID:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control" name="data[ticket_id]" value="<?php echo $urban_piper_tech_data['ticket_id'] ?>" required ></td>
										<td>Auditor's BP Id:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control" name="data[bp_id]" value="<?php echo $urban_piper_tech_data['bp_id'] ?>" required ></td>
										<td >Interaction ID<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control" name="data[interaction_id]" id="" value="<?php echo $urban_piper_tech_data['interaction_id'] ?>"   required> </td>
									</tr>

									<tr>
										<td>VOC: <span style="font-size:24px;color:red">*</span></td>
										<td>
											<select class="form-control" id="voc" name="data[voc]" required>
													
													<option value="">-Select-</option>
													<option value="1"  <?= ($urban_piper_tech_data['voc']=="1")?"selected":"" ?>>1</option>
													<option value="2"  <?= ($urban_piper_tech_data['voc']=="2")?"selected":"" ?>>2</option>
													<option value="3"  <?= ($urban_piper_tech_data['voc']=="3")?"selected":"" ?>>3</option>
													<option value="4"  <?= ($urban_piper_tech_data['voc']=="4")?"selected":"" ?>>4</option>
													<option value="5"  <?= ($urban_piper_tech_data['voc']=="5")?"selected":"" ?>>5</option>
													<option value="6"  <?= ($urban_piper_tech_data['voc']=="6")?"selected":"" ?>>6</option>
													<option value="7"  <?= ($urban_piper_tech_data['voc']=="7")?"selected":"" ?>>7</option>
													<option value="8"  <?= ($urban_piper_tech_data['voc']=="8")?"selected":"" ?>>8</option>
													<option value="9"  <?= ($urban_piper_tech_data['voc']=="9")?"selected":"" ?>>9</option>
													<option value="10"  <?= ($urban_piper_tech_data['voc']=="10")?"selected":"" ?>>10</option>
												</select>
										</td>
										<td>KPI-ACPT: <span style="font-size:24px;color:red">*</span></td>
										<td>
											<select class="form-control" id="" name="data[kpi_acpt]" required>
                                                   <option value="">-Select-</option>
												    <option value="Agent" <?= ($urban_piper_tech_data['kpi_acpt']=="Agent")?"selected":"" ?>>Agent</option>
													<option value="Customer" <?= ($urban_piper_tech_data['kpi_acpt']=="Customer")?"selected":"" ?>>Customer</option>
													<option value="Process" <?= ($urban_piper_tech_data['kpi_acpt']=="Process")?"selected":"" ?>>Process</option>
													<option value="Technology" <?= ($urban_piper_tech_data['kpi_acpt']=="Technology")?"selected":"" ?>>Technology</option>
													<option value="NA" <?= ($urban_piper_tech_data['kpi_acpt']=="NA")?"selected":"" ?>>NA</option>
                                                    
                                                </select>
										</td>
										<td>Call Duration:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control" id="call_duration" name="data[call_duration]" onkeydown="return false;" value="<?php echo $call_duration; ?>" required></td> 
										</tr>
									<tr>
										<td>Audit Type: <span style="font-size:24px;color:red">*</span></td>
										<td>
											<select class="form-control" id="audit_type" name="data[audit_type]" required>
                                                    <option value="">-Select-</option>
                                                    <option value="CQ Audit" <?= ($urban_piper_tech_data['audit_type']=="CQ Audit")?"selected":"" ?>>CQ Audit</option>
                                                    <option value="BQ Audit" <?= ($urban_piper_tech_data['audit_type']=="BQ Audit")?"selected":"" ?>>BQ Audit</option>
                                                    <option value="Calibration" <?= ($urban_piper_tech_data['audit_type']=="Calibration")?"selected":"" ?>>Calibration</option>
                                                    <option value="Pre-Certificate Mock Call" <?= ($urban_piper_tech_data['audit_type']=="Pre-Certificate Mock Call")?"selected":"" ?>>Pre-Certificate Mock Call</option>
                                                    <option value="Certification Audit" <?= ($urban_piper_tech_data['audit_type']=="Certification Audit")?"selected":"" ?>>Certification Audit</option>
                                                    <option value="WoW Call"  <?= ($urban_piper_tech_data['audit_type']=="WoW Call")?"selected":"" ?>>WoW Call</option>
                                                    <option value="Operation Audit"  <?= ($urban_piper_tech_data['audit_type']=="Operation Audit")?"selected":"" ?>>Operation Audit</option>
                                                    <option value="Trainer Audit"  <?= ($urban_piper_tech_data['audit_type']=="Trainer Audit")?"selected":"" ?>>Trainer Audit</option>
                                                    <option value="Hygiene Audit"  <?= ($urban_piper_tech_data['audit_type']=="Hygiene Audit")?"selected":"" ?>>Hygiene Audit</option>
                                                    <option value="QA Supervisor Audit"  <?= ($urban_piper_tech_data['audit_type']=="QA Supervisor Audit")?"selected":"" ?>>QA Supervisor Audit</option>   
                                                </select>
										</td>
									
										
										<td class="auType">Auditor Type: <span style="font-size:24px;color:red">*</span></td>
										<td class="auType">
											<select class="form-control" id="auditor_type" name="data[auditor_type]">
                                                    <option value="">Select</option>
                                                    <option value="Master" <?= ($urban_piper_tech_data['auditor_type']=="Master")?"selected":"" ?>>Master</option>
                                                    <option value="Regular" <?= ($urban_piper_tech_data['auditor_type']=="Regular")?"selected":"" ?>>Regular</option>
                                                </select>
										</td>
									</tr>
									
									<tr>
										<td style="font-weight:bold; font-size:16px; text-align:right">Earned Score:</td>
										<td><input type="text" readonly id="urban_piper_earned_score" name="data[earned_score]" class="form-control" style="font-weight:bold" value="<?php echo $urban_piper_tech_data['earned_score'] ?>"></td>
										<td style="font-weight:bold; font-size:16px; text-align:right">Possible Score:</td>
										<td><input type="text" readonly id="urban_piper_possible_score" name="data[possible_score]" class="form-control" style="font-weight:bold" value="<?php echo $urban_piper_tech_data['possible_score'] ?>"></td>
										<td style="font-weight:bold; font-size:16px; text-align:right">Overall Score:</td>
										<td><input type="text" readonly id="urban_piper_overall_score" name="data[overall_score]" class="form-control urban_piperFatal" style="font-weight:bold" value="<?php echo $urban_piper_tech_data['overall_score'] ?>"></td>
									</tr>
									
									<tr style=" font-weight:bold;background-color:#6d71e3 ;color: white;">
										<td></td>
										<td>Parameters</td>
										<td>Sub Parameter</td>
										<td>Status</td>
										<td>Weight</td>
										<td>REMARKS</td>
									</tr>
									<tr>
										<td rowspan="6" style="background-color:#FFFF00; text-align:center;">SOFT SKILLS</td>
										<td>Call Opening</td>
										<td>Introduction within 7 sec with branding.</td>
										<td>
											<select  class="form-control urban_piper_point" id="" name="data[call_opening_ss]" required>
												<!-- <option value="">-Select-</option> -->
												<option urban_piper_val=5 urban_piper_max="5"<?php echo $urban_piper_tech_data['call_opening_ss'] == "Pass"?"selected":"";?> value="Pass">Pass</option>
												<option urban_piper_val=0 urban_piper_max="5"<?php echo $urban_piper_tech_data['call_opening_ss'] == "Fail"?"selected":"";?> value="Fail">Fail</option>
												<option urban_piper_val=5 urban_piper_max="5"<?php echo $urban_piper_tech_data['call_opening_ss'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
										<td>5</td>
										<td><input type="text" class="form-control" name="data[cmt1]" value="<?php echo $urban_piper_tech_data['cmt1'] ?>"></td>
									</tr>
									<tr>
										<td>Acknowlgement</td>
										<td>Understanding the Merchant issue and reciprocating in the same way.</td>
										<td>
											<select  class="form-control urban_piper_point" id="" name="data[acknowlgement_ss]" required>
												<!-- <option value="">-Select-</option> -->
												<option urban_piper_val=5 urban_piper_max="5"<?php echo $urban_piper_tech_data['acknowlgement_ss'] == "Pass"?"selected":"";?> value="Pass">Pass</option>
												<option urban_piper_val=0 urban_piper_max="5"<?php echo $urban_piper_tech_data['acknowlgement_ss'] == "Fail"?"selected":"";?> value="Fail">Fail</option>
												<option urban_piper_val=5 urban_piper_max="5"<?php echo $urban_piper_tech_data['acknowlgement_ss'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
										<td>5</td>
										<td><input type="text" class="form-control" name="data[cmt2]" value="<?php echo $urban_piper_tech_data['cmt2'] ?>"></td>
									</tr>
									<tr>
										<td>Verfication</td>
										<td>Verifying buisness ID.</td>
										<td>
											<select  class="form-control urban_piper_point" id="" name="data[verfication_ss]" required>
												<!-- <option value="">-Select-</option> -->
												<option urban_piper_val=10 urban_piper_max="10"<?php echo $urban_piper_tech_data['verfication_ss'] == "Pass"?"selected":"";?> value="Pass">Pass</option>
												<option urban_piper_val=0 urban_piper_max="10"<?php echo $urban_piper_tech_data['verfication_ss'] == "Fail"?"selected":"";?> value="Fail">Fail</option>
												<option urban_piper_val=10 urban_piper_max="10"<?php echo $urban_piper_tech_data['verfication_ss'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
										<td>10</td>
										<td><input type="text" class="form-control" name="data[cmt3]" value="<?php echo $urban_piper_tech_data['cmt3'] ?>"></td>
									</tr>
									<tr>
										<td>Personalization</td>
										<td>Addressing the Merchant with Name.</td>
										<td>
											<select  class="form-control urban_piper_point" id="" name="data[personalization_ss]" required>
												<!-- <option value="">-Select-</option> -->
												<option urban_piper_val=5 urban_piper_max="5"<?php echo $urban_piper_tech_data['personalization_ss'] == "Pass"?"selected":"";?> value="Pass">Pass</option>
												<option urban_piper_val=0 urban_piper_max="5"<?php echo $urban_piper_tech_data['personalization_ss'] == "Fail"?"selected":"";?> value="Fail">Fail</option>
												<option urban_piper_val=5 urban_piper_max="5"<?php echo $urban_piper_tech_data['personalization_ss'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
										<td>5</td>
										<td><input type="text" class="form-control" name="data[cmt4]" value="<?php echo $urban_piper_tech_data['cmt4'] ?>"></td>
									</tr>
									<tr>
										<td>Politness/Apology/Asssurance</td>
										<td>Advisor should be sound polite and should be show the apology/Empthy where required.</td>
										<td>
											<select  class="form-control urban_piper_point" id="" name="data[politness_ss]" required>
												<!-- <option value="">-Select-</option> -->
												<option urban_piper_val=10 urban_piper_max="10"<?php echo $urban_piper_tech_data['politness_ss'] == "Pass"?"selected":"";?> value="Pass">Pass</option>
												<option urban_piper_val=0 urban_piper_max="10"<?php echo $urban_piper_tech_data['politness_ss'] == "Fail"?"selected":"";?> value="Fail">Fail</option>
												<option urban_piper_val=10 urban_piper_max="10"<?php echo $urban_piper_tech_data['politness_ss'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
										<td>10</td>
										<td><input type="text" class="form-control" name="data[cmt5]" value="<?php echo $urban_piper_tech_data['cmt5'] ?>"></td>
									</tr>
									<tr>
										<td>Probing</td>
										<td>Should probe to get into the root cause of the concern.</td>
										<td>
											<select  class="form-control urban_piper_point" id="" name="data[probing_ss]" required>
												<!-- <option value="">-Select-</option> -->
												<option urban_piper_val=10 urban_piper_max="10"<?php echo $urban_piper_tech_data['probing_ss'] == "Pass"?"selected":"";?> value="Pass">Pass</option>
												<option urban_piper_val=0 urban_piper_max="10"<?php echo $urban_piper_tech_data['probing_ss'] == "Fail"?"selected":"";?> value="Fail">Fail</option>
												<option urban_piper_val=10 urban_piper_max="10"<?php echo $urban_piper_tech_data['probing_ss'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
										<td>10</td>
										<td><input type="text" class="form-control" name="data[cmt6]" value="<?php echo $urban_piper_tech_data['cmt6'] ?>"></td>
									</tr>
									<tr>
										<td rowspan="5" style="background-color:#F6DDCC">Technical Support</td>
										<td>Hold</td>
										<td>Should follow the proper hold procedure (should be refreshed within 2 min).</td>
										<td>
											<select  class="form-control urban_piper_point" id="" name="data[hold_policy_ts]" required>
												<!-- <option value="">-Select-</option> -->
												<option urban_piper_val=5 urban_piper_max="5"<?php echo $urban_piper_tech_data['hold_policy_ts'] == "Pass"?"selected":"";?> value="Pass">Pass</option>
												<option urban_piper_val=0 urban_piper_max="5"<?php echo $urban_piper_tech_data['hold_policy_ts'] == "Fail"?"selected":"";?> value="Fail">Fail</option>
												<option urban_piper_val=5 urban_piper_max="5"<?php echo $urban_piper_tech_data['hold_policy_ts'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
										<td>5</td>
										<td><input type="text" class="form-control" name="data[cmt7]" value="<?php echo $urban_piper_tech_data['cmt7'] ?>"></td>
									</tr>
									<tr>
										<td>Troubleshooting</td>
										<td>Trouble shooting should be accurate and complete as per the merchant concern.</td>
										<td>
											<select  class="form-control urban_piper_point" id="" name="data[troubleshooting_ts]" required>
												<!-- <option value="">-Select-</option> -->
												<option urban_piper_val=10 urban_piper_max="10"<?php echo $urban_piper_tech_data['troubleshooting_ts'] == "Pass"?"selected":"";?> value="Pass">Pass</option>
												<option urban_piper_val=0 urban_piper_max="10"<?php echo $urban_piper_tech_data['troubleshooting_ts'] == "Fail"?"selected":"";?> value="Fail">Fail</option>
												<option urban_piper_val=10 urban_piper_max="10"<?php echo $urban_piper_tech_data['troubleshooting_ts'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
										<td>10</td>
										<td><input type="text" class="form-control" name="data[cmt8]" value="<?php echo $urban_piper_tech_data['cmt8'] ?>"></td>
									</tr>
									<tr>
										<td>Forms</td>
										<td>Filling Sales Form.</td>
										<td>
											<select  class="form-control urban_piper_point" id="" name="data[forms_ts]" required>
												<!-- <option value="">-Select-</option> -->
												<option urban_piper_val=10 urban_piper_max="10"<?php echo $urban_piper_tech_data['forms_ts'] == "Pass"?"selected":"";?> value="Pass">Pass</option>
												<option urban_piper_val=0 urban_piper_max="10"<?php echo $urban_piper_tech_data['forms_ts'] == "Fail"?"selected":"";?> value="Fail">Fail</option>
												<option urban_piper_val=10 urban_piper_max="10"<?php echo $urban_piper_tech_data['forms_ts'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
										<td>10</td>
										<td><input type="text" class="form-control" name="data[cmt9]" value="<?php echo $urban_piper_tech_data['cmt9'] ?>"></td>
									</tr>
									<tr>
										<td>Call backs</td>
										<td>Connecting back on previous inquiry.</td>
										<td>
											<select  class="form-control urban_piper_point" id="" name="data[call_backs_ts]" required>
												<!-- <option value="">-Select-</option> -->
												<option urban_piper_val=10 urban_piper_max="10"<?php echo $urban_piper_tech_data['call_backs_ts'] == "Pass"?"selected":"";?> value="Pass">Pass</option>
												<option urban_piper_val=0 urban_piper_max="10"<?php echo $urban_piper_tech_data['call_backs_ts'] == "Fail"?"selected":"";?> value="Fail">Fail</option>
												<option urban_piper_val=10 urban_piper_max="10"<?php echo $urban_piper_tech_data['call_backs_ts'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
										<td>10</td>
										<td><input type="text" class="form-control" name="data[cmt10]" value="<?php echo $urban_piper_tech_data['cmt10'] ?>"></td>
									</tr>
									<tr>
										<td>Correct escaltion/Ticketing</td>
										<td>Escalating issues on Slack.</td>
										<td>
											<select  class="form-control urban_piper_point" id="" name="data[correct_escaltion_ts]" required>
												<!-- <option value="">-Select-</option> -->
												<option urban_piper_val=10 urban_piper_max="10"<?php echo $urban_piper_tech_data['correct_escaltion_ts'] == "Pass"?"selected":"";?> value="Pass">Pass</option>
												<option urban_piper_val=0 urban_piper_max="10"<?php echo $urban_piper_tech_data['correct_escaltion_ts'] == "Fail"?"selected":"";?> value="Fail">Fail</option>
												<option urban_piper_val=10 urban_piper_max="10"<?php echo $urban_piper_tech_data['correct_escaltion_ts'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
										<td>10</td>
										<td><input type="text" class="form-control" name="data[cmt11]" value="<?php echo $urban_piper_tech_data['cmt11'] ?>"></td>
									</tr>
									<tr>
										<td rowspan="3" style="background-color:#FF7F7F ">Compliance</td>
										<td style="color:red;">Disposition</td>
										<td style="color:red;">Correct dispostion.</td>
										<td>
											<select  class="form-control urban_piper_point" id="urban_piperAF1" name="data[disposition_compliance]" required>
												<!-- <option value="">-Select-</option> -->
												<option urban_piper_val=0 urban_piper_max="0" <?php echo $urban_piper_tech_data['disposition_compliance'] == "Pass"?"selected":"";?> value="Pass">Pass</option>
												<option urban_piper_val=0 urban_piper_max="0" <?php echo $urban_piper_tech_data['disposition_compliance'] == "Fail"?"selected":"";?> value="Fail">Fail</option>
												<option urban_piper_val=0 urban_piper_max="0" <?php echo $urban_piper_tech_data['disposition_compliance'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
										<td></td>
										<td><input type="text" class="form-control" name="data[cmt12]" value="<?php echo $urban_piper_tech_data['cmt12'] ?>"></td>
									</tr>
									<tr>
										<td style="color:red;">Forms</td>
										<td style="color:red;">Filling all internal forms.</td>
										<td>
											<select  class="form-control urban_piper_point" id="urban_piperAF2" name="data[forms_compliance]" required>
												<!-- <option value="">-Select-</option> -->
												<option urban_piper_val=0 urban_piper_max="0" <?php echo $urban_piper_tech_data['forms_compliance'] == "Pass"?"selected":"";?> value="Pass">Pass</option>
												<option urban_piper_val=0 urban_piper_max="0" <?php echo $urban_piper_tech_data['forms_compliance'] == "Fail"?"selected":"";?> value="Fail">Fail</option>
												<option urban_piper_val=0 urban_piper_max="0" <?php echo $urban_piper_tech_data['forms_compliance'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
										<td></td>
										<td><input type="text" class="form-control" name="data[cmt13]" value="<?php echo $urban_piper_tech_data['cmt13'] ?>"></td>
									</tr>
									<tr>
										<td style="color:red;">Resolution</td>
										<td style="color:red;">Providing correct resolution.</td>
										<td>
											<select  class="form-control urban_piper_point" id="urban_piperAF3" name="data[resolution_compliance]" required>
												<!-- <option value="">-Select-</option> -->
												<option urban_piper_val=0 urban_piper_max="0" <?php echo $urban_piper_tech_data['resolution_compliance'] == "Pass"?"selected":"";?> value="Pass">Pass</option>
												<option urban_piper_val=0 urban_piper_max="0" <?php echo $urban_piper_tech_data['resolution_compliance'] == "Fail"?"selected":"";?> value="Fail">Fail</option>
												<option urban_piper_val=0 urban_piper_max="0" <?php echo $urban_piper_tech_data['resolution_compliance'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
										<td></td>
										<td><input type="text" class="form-control" name="data[cmt14]" value="<?php echo $urban_piper_tech_data['cmt14'] ?>"></td>
									</tr>
									<tr>
										<td rowspan="3" style="background-color:#ADD8E6">Call Closing</td>
										<td style="color:red;">ZTP </td>
										<td style="color:red;">Call disconnection.</td>
										<td>
											<select  class="form-control urban_piper_point" id="urban_piperAF4" name="data[ztp_cc]" required>
												<!-- <option value="">-Select-</option> -->
												<option urban_piper_val=0 urban_piper_max=0 <?php echo $urban_piper_tech_data['ztp_cc'] == "Pass"?"selected":"";?> value="Pass">Pass</option>
												<option urban_piper_val=0 urban_piper_max=0 <?php echo $urban_piper_tech_data['ztp_cc'] == "Fail"?"selected":"";?> value="Fail">Fail</option>
												<option urban_piper_val=0 urban_piper_max=0 <?php echo $urban_piper_tech_data['ztp_cc'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
										<td></td>
										<td><input type="text" class="form-control" name="data[cmt15]" value="<?php echo $urban_piper_tech_data['cmt15'] ?>"></td>
									</tr>
									<tr>
										<td>Further Assistance.</td>
										<td>Should ask for further assistance</td>
										<td>
										<select  class="form-control urban_piper_point" id="" name="data[further_assistance_cc]" required>
												<!-- <option value="">-Select-</option> -->
												<option urban_piper_val=5 urban_piper_max="5"<?php echo $urban_piper_tech_data['further_assistance_cc'] == "Pass"?"selected":"";?> value="Pass">Pass</option>
												<option urban_piper_val=0 urban_piper_max="5"<?php echo $urban_piper_tech_data['further_assistance_cc'] == "Fail"?"selected":"";?> value="Fail">Fail</option>
												<option urban_piper_val=5 urban_piper_max="5"<?php echo $urban_piper_tech_data['further_assistance_cc'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
										<td>5</td>
										<td><input type="text" class="form-control" name="data[cmt16]" value="<?php echo $urban_piper_tech_data['cmt16'] ?>"></td>
									</tr>
									<tr>
										<td>Call Closing</td>
										<td>Closing the call with Branding.</td>
										<td>
											<select  class="form-control urban_piper_point" id="" name="data[call_closing_cc]" required>
												<!-- <option value="">-Select-</option> -->
												<option urban_piper_val=5 urban_piper_max="5"<?php echo $urban_piper_tech_data['call_closing_cc'] == "Pass"?"selected":"";?> value="Pass">Pass</option>
												<option urban_piper_val=0 urban_piper_max="5"<?php echo $urban_piper_tech_data['call_closing_cc'] == "Fail"?"selected":"";?> value="Fail">Fail</option>
												<option urban_piper_val=5 urban_piper_max="5"<?php echo $urban_piper_tech_data['call_closing_cc'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td>5</td>
										<td><input type="text" class="form-control" name="data[cmt17]" value="<?php echo $urban_piper_tech_data['cmt17'] ?>"></td>
									</tr>
									<tr>
										<td style="background-color:#5058e6;color: white;">Call Summary:</td>
										<td colspan=2><textarea class="form-control" name="data[call_summary]"><?php echo $urban_piper_tech_data['call_summary'] ?></textarea></td>
										<td style="background-color:#5058e6;color: white;">Feedback:</td>
										<td colspan=2><textarea class="form-control" name="data[feedback]"><?php echo $urban_piper_tech_data['feedback'] ?></textarea></td>
									</tr>
									<tr>
										<td colspan=2 style="background-color:#5058e6;color: white;">Upload Files [m4a,mp4,mp3,wav]</td>
										<?php if($urban_piper_tech_id==0){ ?>
											<td colspan=4>
												<input type="file" name="attach_file[]" id="attach_file" accept=".m4a,.mp4,.mp3,.wav,audio/*" />
											</td>
										<?php }else{
											if($urban_piper_tech_data['attach_file']!=''){ ?>
												<td colspan=4>
													<input type="file" multiple class="form-control"  id="attach_file" name="attach_file[]" accept=".m4a,.mp4,.mp3,.wav,audio/*"> 
													<?php $attach_file = explode(",",$urban_piper_tech_data['attach_file']);
													 foreach($attach_file as $mp){ ?>
														<audio controls='' style="background-color:#607F93"> 
														  <source src="<?php echo base_url(); ?>qa_files/qa_urban_piper/<?php echo $mp; ?>" type="audio/ogg">
														  <source src="<?php echo base_url(); ?>qa_files/qa_urban_piper/<?php echo $mp; ?>" type="audio/mpeg">
														</audio> </br>
													 <?php } ?>
												</td>
										<?php }else{
												//echo '<td colspan=6><b>No Files</b></td>';
											echo '<td colspan=6>
													<input type="file" multiple class="form-control" id="attach_file" name="attach_file[]" accept=".m4a,.mp4,.mp3,.wav,audio/*">
													<b>No Files</b></td>';
											  }
										} ?>
									</tr>
									
									<?php if($urban_piper_tech_id!=0){ ?>
										<tr><td colspan=2 style="font-size:16px; font-weight:bold">Agent Feedback Acceptance:</td><td colspan=4><?php echo $urban_piper_tech_data['agnt_fd_acpt'] ?></td></tr>
										<tr><td colspan=2 style="font-size:16px; font-weight:bold">Agent Review:</td><td colspan=4><?php echo $urban_piper_tech_data['agent_rvw_note'] ?></td></tr>
										<tr><td colspan=2 style="font-size:16px; font-weight:bold">Management Review:</td><td colspan=4><?php echo $urban_piper_tech_data['mgnt_rvw_note'] ?></td></tr>
										<tr><td colspan=2 style="font-size:16px; font-weight:bold">Client Review:</td><td colspan=4><?php echo $urban_piper_tech_data['client_rvw_note'] ?></td></tr>
										
										<tr><td colspan=2  style="font-size:16px">Your Review <span style="font-size:24px;color:red">*</span></td><td colspan=4><textarea class="form-control1" style="width:100%" id="note" name="note" required></textarea></td></tr>
									<?php } ?>
									
									<?php 
									if($urban_piper_tech_id==0){
										if(is_access_qa_module()==true || is_access_qa_operations_module()==true){ ?>
											<tr><td colspan=6><button class="btn btn-success waves-effect" type="submit" id="qaformsubmit" style="width:500px">SAVE</button></td></tr>
									<?php 
										} 
									}else{ 
										if(is_access_qa_module()==true || is_access_qa_operations_module()==true){
											if(is_available_qa_feedback($urban_piper_tech_data['entry_date'],72) == true){ ?>
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
