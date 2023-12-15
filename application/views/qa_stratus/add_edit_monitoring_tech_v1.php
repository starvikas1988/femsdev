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

<?php if($monitoringtech_v1_id!=0){
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
										<td colspan="6" id="theader" style="font-size:40px;text-align: center;background-color: #1948E0  ; color:white;">Monitoring Tech Audit Form V1</td>
										<input type="hidden" name="audit_start_time" value="<?php echo CurrMySqlDate(); ?>">
									</tr>
									<?php
										if($monitoringtech_v1_id==0){
											$auditorName = get_username();
											$auditDate = CurrDateMDY();
											$clDate_val='';
											$call_duration='';
											//$dobDate_val='';
										}else{
											if($monitoring_tech_v1['entry_by']!=''){
												$auditorName = $monitoring_tech_v1['auditor_name'];
											}else{
												$auditorName = $monitoring_tech_v1['client_name'];
											}
											$auditDate = mysql2mmddyy($monitoring_tech_v1['audit_date']);
											$clDate_val = mysqlDt2mmddyy($monitoring_tech_v1['call_date']);
											$call_duration = $monitoring_tech_v1['call_duration'];
											//$dobDate_val = mysql2mmddyy($monitoring_tech_v1['dob']);
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
												<option value="<?php echo $monitoring_tech_v1['agent_id'] ?>"><?php echo $monitoring_tech_v1['fname']." ".$monitoring_tech_v1['lname'] ?></option>
												<option value="">-Select-</option>
												<?php foreach($agentName as $row):  ?>
													<option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
												<?php endforeach; ?>
											</select>
										</td>
											<td>Fusion ID: <span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control" id="fusion_id" value="<?php echo $monitoring_tech_v1['fusion_id'] ?>" readonly ></td>
											<td>L1 Supervisor: <span style="font-size:24px;color:red">*</span></td>
										<td>

											<input type="text" class="form-control" id="tl_name"  value="<?php echo $monitoring_tech_v1['tl_name'] ?>" readonly>
											<input type="hidden" class="form-control" id="tl_id" name="data[tl_id]" value="<?php echo $monitoring_tech_v1['tl_id'] ?>" required>
										</td>
									</tr>
									<tr>
										<td>Order Number:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control" name="data[order_number]" value="<?php echo $monitoring_tech_v1['order_number'] ?>" required ></td>
										<td>Customer Name:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control" name="data[customer_name]" value="<?php echo $monitoring_tech_v1['customer_name'] ?>" required ></td>
										<td >Auto Fail<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control" name="data[auto_fail]" id="param1" value="<?php echo $monitoring_tech_v1['auto_fail'] ?>"   readonly> </td>
									</tr>

									<tr>
										<td>VOC: <span style="font-size:24px;color:red">*</span></td>
										<td>
											<select class="form-control" id="voc" name="data[voc]" required>
													
													<option value="">-Select-</option>
													<option value="1"  <?= ($monitoring_tech_v1['voc']=="1")?"selected":"" ?>>1</option>
													<option value="2"  <?= ($monitoring_tech_v1['voc']=="2")?"selected":"" ?>>2</option>
													<option value="3"  <?= ($monitoring_tech_v1['voc']=="3")?"selected":"" ?>>3</option>
													<option value="4"  <?= ($monitoring_tech_v1['voc']=="4")?"selected":"" ?>>4</option>
													<option value="5"  <?= ($monitoring_tech_v1['voc']=="5")?"selected":"" ?>>5</option>
													<option value="6"  <?= ($monitoring_tech_v1['voc']=="6")?"selected":"" ?>>6</option>
													<option value="7"  <?= ($monitoring_tech_v1['voc']=="7")?"selected":"" ?>>7</option>
													<option value="8"  <?= ($monitoring_tech_v1['voc']=="8")?"selected":"" ?>>8</option>
													<option value="9"  <?= ($monitoring_tech_v1['voc']=="9")?"selected":"" ?>>9</option>
													<option value="10"  <?= ($monitoring_tech_v1['voc']=="10")?"selected":"" ?>>10</option>
												</select>
										</td>
										<td>KPI-ACPT: <span style="font-size:24px;color:red">*</span></td>
										<td>
											<select class="form-control" id="" name="data[kpi_acpt]" required>
                                                   <option value="">-Select-</option>
												    <option value="Agent" <?= ($monitoring_tech_v1['kpi_acpt']=="Agent")?"selected":"" ?>>Agent</option>
													<option value="Customer" <?= ($monitoring_tech_v1['kpi_acpt']=="Customer")?"selected":"" ?>>Customer</option>
													<option value="Process" <?= ($monitoring_tech_v1['kpi_acpt']=="Process")?"selected":"" ?>>Process</option>
													<option value="Technology" <?= ($monitoring_tech_v1['kpi_acpt']=="Technology")?"selected":"" ?>>Technology</option>
													<option value="NA" <?= ($monitoring_tech_v1['kpi_acpt']=="NA")?"selected":"" ?>>NA</option>
                                                    
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
                                                    <option value="CQ Audit" <?= ($monitoring_tech_v1['audit_type']=="CQ Audit")?"selected":"" ?>>CQ Audit</option>
                                                    <option value="BQ Audit" <?= ($monitoring_tech_v1['audit_type']=="BQ Audit")?"selected":"" ?>>BQ Audit</option>
                                                    <option value="Calibration" <?= ($monitoring_tech_v1['audit_type']=="Calibration")?"selected":"" ?>>Calibration</option>
                                                    <option value="Pre-Certificate Mock Call" <?= ($monitoring_tech_v1['audit_type']=="Pre-Certificate Mock Call")?"selected":"" ?>>Pre-Certificate Mock Call</option>
                                                    <option value="Certification Audit" <?= ($monitoring_tech_v1['audit_type']=="Certification Audit")?"selected":"" ?>>Certification Audit</option>
                                                    <option value="WoW Call"  <?= ($monitoring_tech_v1['audit_type']=="WoW Call")?"selected":"" ?>>WoW Call</option>
                                                    <option value="Operation Audit"  <?= ($monitoring_tech_v1['audit_type']=="Operation Audit")?"selected":"" ?>>Operation Audit</option>
                                                    <option value="Trainer Audit"  <?= ($monitoring_tech_v1['audit_type']=="Trainer Audit")?"selected":"" ?>>Trainer Audit</option>
                                                    <option value="Hygiene Audit"  <?= ($monitoring_tech_v1['audit_type']=="Hygiene Audit")?"selected":"" ?>>Hygiene Audit</option>
                                                    <option value="QA Supervisor Audit"  <?= ($monitoring_tech_v1['audit_type']=="QA Supervisor Audit")?"selected":"" ?>>QA Supervisor Audit</option>   
                                                </select>
										</td>
									
										
										<td class="auType">Auditor Type: <span style="font-size:24px;color:red">*</span></td>
										<td class="auType">
											<select class="form-control" id="auditor_type" name="data[auditor_type]">
                                                    <option value="">Select</option>
                                                    <option value="Master" <?= ($monitoring_tech_v1['auditor_type']=="Master")?"selected":"" ?>>Master</option>
                                                    <option value="Regular" <?= ($monitoring_tech_v1['auditor_type']=="Regular")?"selected":"" ?>>Regular</option>
                                                </select>
										</td>
									</tr>
									
									<tr>
										<td style="font-weight:bold; font-size:16px; text-align:right">Earned Score:</td>
										<td><input type="text" readonly id="stratus_earned" name="data[earned_score]" class="form-control" style="font-weight:bold" value="<?php echo $monitoring_tech_v1['earned_score'] ?>"></td>
										<td style="font-weight:bold; font-size:16px; text-align:right">Possible Score:</td>
										<td><input type="text" readonly id="stratus_possible" name="data[possible_score]" class="form-control" style="font-weight:bold" value="<?php echo $monitoring_tech_v1['possible_score'] ?>"></td>
										<td style="font-weight:bold; font-size:16px; text-align:right">Overall Score:</td>
										<td><input type="text" readonly id="stratus_overall_score" name="data[overall_score]" class="form-control monitorinttech_fatal" style="font-weight:bold" value="<?php echo $monitoring_tech_v1['overall_score'] ?>"></td>
									</tr>
									
									<tr style=" font-weight:bold;background-color:#6d71e3 ;color: white;">
										<td>COPC</td>
										<td>Parameters</td>
										<td>Sub Parameter</td>
										<td>Status</td>
										<td>Weight</td>
										<td>REMARKS</td>
									</tr>
									<tr>
										<td colspan="6" style="background-color:#FFFF00; text-align:center;">QUALITY</td>
									</tr>
									<tr>
										<td style="background-color:#F6DDCC">Business Critical</td>
										<td>1. Q2 Checks</td>
										<td>The studies are being checked every 2 hours, and an inspection note has been completed (timers are being reset).</td>
										<td>
											<select  class="form-control stratus_point business stratusAuto" id="" name="data[Q2_checks]" required>
												<!-- <option value="">-Select-</option> -->
												<option stratus_val=10 <?php echo $monitoring_tech_v1['Q2_checks'] == "Pass"?"selected":"";?> value="Pass">Pass</option>
												<option stratus_val=10 <?php echo $monitoring_tech_v1['Q2_checks'] == "Fail"?"selected":"";?> value="Fail">Fail</option>
												<option stratus_val=10 <?php echo $monitoring_tech_v1['Q2_checks'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
										<td>10</td>
										<td><input type="text" class="form-control" name="data[cmt1]" value="<?php echo $monitoring_tech_v1['cmt1'] ?>"></td>
									</tr>
									<tr>
										<td style="background-color:#F6DDCC">Business Critical</td>
										<td>2. Templates</td>
										<td>The agent documents Q2 checks on the patient report, using the correct templat. (see templates below)</td>
										<td>
											<select  class="form-control stratus_point business stratusAuto" id="" name="data[templates]" required>
												<!-- <option value="">-Select-</option> -->
												<option stratus_val=2 <?php echo $monitoring_tech_v1['templates'] == "Pass"?"selected":"";?> value="Pass">Pass</option>
												<option stratus_val=2 <?php echo $monitoring_tech_v1['templates'] == "Fail"?"selected":"";?> value="Fail">Fail</option>
												<option stratus_val=2 <?php echo $monitoring_tech_v1['templates'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
										<td>2</td>
										<td><input type="text" class="form-control" name="data[cmt2]" value="<?php echo $monitoring_tech_v1['cmt2'] ?>"></td>
									</tr>
									<tr>
										<td style="background-color:#F6DDCC">Business Critical</td>
										<td>3. Hours/Battery %</td>
										<td>The agents is notating the hours collected and amplifier battery percentage on every check. </td>
										<td>
											<select  class="form-control stratus_point business stratusAuto" id="" name="data[hours_battery_per]" required>
												<!-- <option value="">-Select-</option> -->
												<option stratus_val=3 <?php echo $monitoring_tech_v1['hours_battery_per'] == "Pass"?"selected":"";?> value="Pass">Pass</option>
												<option stratus_val=3 <?php echo $monitoring_tech_v1['hours_battery_per'] == "Fail"?"selected":"";?> value="Fail">Fail</option>
												<option stratus_val=3 <?php echo $monitoring_tech_v1['hours_battery_per'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
										<td>3</td>
										<td><input type="text" class="form-control" name="data[cmt3]" value="<?php echo $monitoring_tech_v1['cmt3'] ?>"></td>
									</tr>
									<tr>
										<td style="background-color:#F6DDCC">Business Critical</td>
										<td>4. Camera</td>
										<td>The agent is documenting if the patient is on Camera 1, Camera 2, both cameras, or off-camera.</td>
										<td>
											<select  class="form-control stratus_point business stratusAuto" id="" name="data[camera]" required>
												<!-- <option value="">-Select-</option> -->
												<option stratus_val=3 <?php echo $monitoring_tech_v1['camera'] == "Pass"?"selected":"";?> value="Pass">Pass</option>
												<option stratus_val=3 <?php echo $monitoring_tech_v1['camera'] == "Fail"?"selected":"";?> value="Fail">Fail</option>
												<option stratus_val=3 <?php echo $monitoring_tech_v1['camera'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
										<td>3</td>
										<td><input type="text" class="form-control" name="data[cmt4]" value="<?php echo $monitoring_tech_v1['cmt4'] ?>"></td>
									</tr>
									<tr>
										<td style="background-color:#F6DDCC">Business Critical</td>
										<td>5. Disconnects</td>
										<td>Day Shift: The agent highlights the patient blue and documents the Field Tech that disconnected the patient. 
Night Shift: The agent highlights the unit numbers cell blue, and documents the time and the Field Tech scheduled to disconnect the patient.</td>
										<td>
											<select  class="form-control stratus_point business stratusAuto" id="" name="data[disconnects]" required>
												<!-- <option value="">-Select-</option> -->
												<option stratus_val=2 <?php echo $monitoring_tech_v1['disconnects'] == "Pass"?"selected":"";?> value="Pass">Pass</option>
												<option stratus_val=2 <?php echo $monitoring_tech_v1['disconnects'] == "Fail"?"selected":"";?> value="Fail">Fail</option>
												<option stratus_val=2 <?php echo $monitoring_tech_v1['disconnects'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
										<td>2</td>
										<td><input type="text" class="form-control" name="data[cmt5]" value="<?php echo $monitoring_tech_v1['cmt5'] ?>"></td>
									</tr>
									<tr>
										<td style="background-color:#F6DDCC">Business Critical</td>
										<td>6. Call Logs</td>
										<td>The agent is documenting in the "Check Notes" when contacting a patient -- all calls, successful or unsuccessful.</td>
										<td>
											<select  class="form-control stratus_point business stratusAuto" id="" name="data[call_logs]" required>
												<!-- <option value="">-Select-</option> -->
												<option stratus_val=5 <?php echo $monitoring_tech_v1['call_logs'] == "Pass"?"selected":"";?> value="Pass">Pass</option>
												<option stratus_val=5 <?php echo $monitoring_tech_v1['call_logs'] == "Fail"?"selected":"";?> value="Fail">Fail</option>
												<option stratus_val=5 <?php echo $monitoring_tech_v1['call_logs'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
										<td>5</td>
										<td><input type="text" class="form-control" name="data[cmt6]" value="<?php echo $monitoring_tech_v1['cmt6'] ?>"></td>
									</tr>
									<tr>
										<td style="background-color:#F6DDCC">Business Critical</td>
										<td>7. TV Console Notes</td>
										<td>The agent is documenting the patient's last name, leaving a detailed note, and including their initials. No blank notes. </td>
										<td>
											<select  class="form-control stratus_point business stratusAuto" id="" name="data[tv_console_notes]" required>
												<!-- <option value="">-Select-</option> -->
												<option stratus_val=3 <?php echo $monitoring_tech_v1['tv_console_notes'] == "Pass"?"selected":"";?> value="Pass">Pass</option>
												<option stratus_val=3 <?php echo $monitoring_tech_v1['tv_console_notes'] == "Fail"?"selected":"";?> value="Fail">Fail</option>
												<option stratus_val=3 <?php echo $monitoring_tech_v1['tv_console_notes'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
										<td>3</td>
										<td><input type="text" class="form-control" name="data[cmt7]" value="<?php echo $monitoring_tech_v1['cmt7'] ?>"></td>
									</tr>
									<tr>
										<td colspan="6" style="background-color:#FFFF00; text-align:center;">ACCURACY</td>
									</tr>
									<tr>
										<td style="background-color:#F6DDCC">Business Critical</td>
										<td>8. Master Setup List</td>
										<td>The agent places initial on the Master Setup once the study has been cleared (box is checked), which is verifying that they have received this patient in their Team Monitor.</td>
										<td>
											<select  class="form-control stratus_point business stratusAuto" id="" name="data[master_setup_list]" required>
												<!-- <option value="">-Select-</option> -->
												<option stratus_val=3 <?php echo $monitoring_tech_v1['master_setup_list'] == "Pass"?"selected":"";?> value="Pass">Pass</option>
												<option stratus_val=3 <?php echo $monitoring_tech_v1['master_setup_list'] == "Fail"?"selected":"";?> value="Fail">Fail</option>
												<option stratus_val=3 <?php echo $monitoring_tech_v1['master_setup_list'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
										<td>3</td>
										<td><input type="text" class="form-control" name="data[cmt8]" value="<?php echo $monitoring_tech_v1['cmt8'] ?>"></td>
									</tr>
									<tr>
										<td style="background-color:#F6DDCC">Business Critical</td>
										<td>9. MSL Information</td>
										<td>The agent is transferring accurate information on the Master Setup List on to their Patient Report.</td>
										<td>
											<select  class="form-control stratus_point business stratusAuto" id="" name="data[MSL_information]" required>
												<!-- <option value="">-Select-</option> -->
												<option stratus_val=5 <?php echo $monitoring_tech_v1['MSL_information'] == "Pass"?"selected":"";?> value="Pass">Pass</option>
												<option stratus_val=5 <?php echo $monitoring_tech_v1['MSL_information'] == "Fail"?"selected":"";?> value="Fail">Fail</option>
												<option stratus_val=5 <?php echo $monitoring_tech_v1['MSL_information'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
										<td>5</td>
										<td><input type="text" class="form-control" name="data[cmt9]" value="<?php echo $monitoring_tech_v1['cmt9'] ?>"></td>
									</tr>
									<tr>
										<td style="background-color:#F6DDCC">Business Critical</td>
										<td>10. Patient Info</td>
										<td>The agent is verifying and documenting the correct patient's name, DOB, and BT ID number.</td>
										<td>
											<select  class="form-control stratus_point business stratusAuto" id="" name="data[patient_information]" required>
												<!-- <option value="">-Select-</option> -->
												<option stratus_val=5 <?php echo $monitoring_tech_v1['patient_information'] == "Pass"?"selected":"";?> value="Pass">Pass</option>
												<option stratus_val=5 <?php echo $monitoring_tech_v1['patient_information'] == "Fail"?"selected":"";?> value="Fail">Fail</option>
												<option stratus_val=5 <?php echo $monitoring_tech_v1['patient_information'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
										<td>5</td>
										<td><input type="text" class="form-control" name="data[cmt10]" value="<?php echo $monitoring_tech_v1['cmt10'] ?>"></td>
									</tr>
									<tr>
										<td style="background-color:#F6DDCC">Business Critical</td>
										<td>11. Phone Numbers</td>
										<td>The patient is documenting all phone numbers listed for the patient correctly.</td>
										<td>
											<select  class="form-control stratus_point business stratusAuto" id="" name="data[phone_numbers]" required>
												<!-- <option value="">-Select-</option> -->
												<option stratus_val=5 <?php echo $monitoring_tech_v1['phone_numbers'] == "Pass"?"selected":"";?> value="Pass">Pass</option>
												<option stratus_val=5 <?php echo $monitoring_tech_v1['phone_numbers'] == "Fail"?"selected":"";?> value="Fail">Fail</option>
												<option stratus_val=5 <?php echo $monitoring_tech_v1['phone_numbers'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
										<td>5</td>
										<td><input type="text" class="form-control" name="data[cmt11]" value="<?php echo $monitoring_tech_v1['cmt11'] ?>"></td>
									</tr>
									<tr>
										<td style="background-color:#F6DDCC">Business Critical</td>
										<td>12. Start Time</td>
										<td>The agent is documenting the exact start time.</td>
										<td>
											<select  class="form-control stratus_point business stratusAuto" id="" name="data[start_time]" required>
												<!-- <option value="">-Select-</option> -->
												<option stratus_val=3 <?php echo $monitoring_tech_v1['start_time'] == "Pass"?"selected":"";?> value="Pass">Pass</option>
												<option stratus_val=3 <?php echo $monitoring_tech_v1['start_time'] == "Fail"?"selected":"";?> value="Fail">Fail</option>
												<option stratus_val=3 <?php echo $monitoring_tech_v1['start_time'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
										<td>3</td>
										<td><input type="text" class="form-control" name="data[cmt12]" value="<?php echo $monitoring_tech_v1['cmt12'] ?>"></td>
									</tr>
									<tr>
										<td style="background-color:#F6DDCC">Business Critical</td>
										<td>13. Number of Cameras</td>
										<td>The agent is documenting the accurate number of cameras: 2 cams, 1 cam or no cam.</td>
										<td>
											<select  class="form-control stratus_point business stratusAuto" id="" name="data[number_of_cameras]" required>
												<!-- <option value="">-Select-</option> -->
												<option stratus_val=3 <?php echo $monitoring_tech_v1['number_of_cameras'] == "Pass"?"selected":"";?> value="Pass">Pass</option>
												<option stratus_val=3 <?php echo $monitoring_tech_v1['number_of_cameras'] == "Fail"?"selected":"";?> value="Fail">Fail</option>
												<option stratus_val=3 <?php echo $monitoring_tech_v1['number_of_cameras'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
										<td>3</td>
										<td><input type="text" class="form-control" name="data[cmt13]" value="<?php echo $monitoring_tech_v1['cmt13'] ?>"></td>
									</tr>
									<tr>
										<td style="background-color:#F6DDCC">Business Critical</td>
										<td>14. Time Zone</td>
										<td>The agent is documenting the correct state and time zone that the patient is located in.</td>
										<td>
											<select  class="form-control stratus_point business stratusAuto" id="" name="data[time_zone]" required>
												<!-- <option value="">-Select-</option> -->
												<option stratus_val=5 <?php echo $monitoring_tech_v1['time_zone'] == "Pass"?"selected":"";?> value="Pass">Pass</option>
												<option stratus_val=5 <?php echo $monitoring_tech_v1['time_zone'] == "Fail"?"selected":"";?> value="Fail">Fail</option>
												<option stratus_val=5 <?php echo $monitoring_tech_v1['time_zone'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
										<td>5</td>
										<td><input type="text" class="form-control" name="data[cmt14]" value="<?php echo $monitoring_tech_v1['cmt14'] ?>"></td>
									</tr>
									<tr>
										<td style="background-color:#F6DDCC">Business Critical</td>
										<td>15. WIP</td>
										<td>The agent is correctly changing the Work In Progress state in Brightree.</td>
										<td>
											<select  class="form-control stratus_point business stratusAuto" id="" name="data[wip]" required>
												<!-- <option value="">-Select-</option> -->
												<option stratus_val=5 <?php echo $monitoring_tech_v1['wip'] == "Pass"?"selected":"";?> value="Pass">Pass</option>
												<option stratus_val=5 <?php echo $monitoring_tech_v1['wip'] == "Fail"?"selected":"";?> value="Fail">Fail</option>
												<option stratus_val=5 <?php echo $monitoring_tech_v1['wip'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
										<td>5</td>
										<td><input type="text" class="form-control" name="data[cmt15]" value="<?php echo $monitoring_tech_v1['cmt15'] ?>"></td>
									</tr>
									<tr>
										<td style="background-color:#F6DDCC">Business Critical</td>
										<td>16. Time Syncs </td>
										<td>The agent is syncing the time on units, if it was in the incorrect time zone or had not been completed in the past 10 days.</td>
										<td>
											<select  class="form-control stratus_point business stratusAuto" id="" name="data[time_syncs]" required>
												<!-- <option value="">-Select-</option> -->
												<option stratus_val=3 <?php echo $monitoring_tech_v1['time_syncs'] == "Pass"?"selected":"";?> value="Pass">Pass</option>
												<option stratus_val=3 <?php echo $monitoring_tech_v1['time_syncs'] == "Fail"?"selected":"";?> value="Fail">Fail</option>
												<option stratus_val=3 <?php echo $monitoring_tech_v1['time_syncs'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
										<td>3</td>
										<td><input type="text" class="form-control" name="data[cmt16]" value="<?php echo $monitoring_tech_v1['cmt16'] ?>"></td>
									</tr>
									<tr>
										<td style="background-color:#F6DDCC">Business Critical</td>
										<td>17. Data Card</td>
										<td>The agent is formatting the data card.</td>
										<td>
											<select  class="form-control stratus_point business stratusAuto" id="" name="data[data_card]" required>
												<!-- <option value="">-Select-</option> -->
												<option stratus_val=3 <?php echo $monitoring_tech_v1['data_card'] == "Pass"?"selected":"";?> value="Pass">Pass</option>
												<option stratus_val=3 <?php echo $monitoring_tech_v1['data_card'] == "Fail"?"selected":"";?> value="Fail">Fail</option>
												<option stratus_val=3 <?php echo $monitoring_tech_v1['data_card'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
										<td>3</td>
										<td><input type="text" class="form-control" name="data[cmt17]" value="<?php echo $monitoring_tech_v1['cmt17'] ?>"></td>
									</tr>
									<tr>
										<td style="background-color:#F6DDCC">Business Critical</td>
										<td>18. AV Log</td>
										<td>The agent is checking on the A/V Log to ensure audio is on, the cameras are confirgured properly, T4A firmware is updated and other unit issues.</td>
										<td>
											<select  class="form-control stratus_point business stratusAuto" id="" name="data[av_log]" required>
												<!-- <option value="">-Select-</option> -->
												<option stratus_val=3 <?php echo $monitoring_tech_v1['av_log'] == "Pass"?"selected":"";?> value="Pass">Pass</option>
												<option stratus_val=3 <?php echo $monitoring_tech_v1['av_log'] == "Fail"?"selected":"";?> value="Fail">Fail</option>
												<option stratus_val=3 <?php echo $monitoring_tech_v1['av_log'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
										<td>3</td>
										<td><input type="text" class="form-control" name="data[cmt18]" value="<?php echo $monitoring_tech_v1['cmt18'] ?>"></td>
									</tr>
									<tr>
										<td colspan="6" style="background-color:#FFFF00; text-align:center;">PRODUCTIVITY</td>
									</tr>
									<tr>
										<td style="background-color:#F6DDCC">Business Critical</td>
										<td>19. Response Time FTs</td>
										<td>The agent is responding to the Field Techs calling out in a timely manner.</td>
										<td>
											<select  class="form-control stratus_point business stratusAuto" id="" name="data[response_time_FTS]" required>
												<!-- <option value="">-Select-</option> -->
												<option stratus_val=5 <?php echo $monitoring_tech_v1['response_time_FTS'] == "Pass"?"selected":"";?> value="Pass">Pass</option>
												<option stratus_val=5 <?php echo $monitoring_tech_v1['response_time_FTS'] == "Fail"?"selected":"";?> value="Fail">Fail</option>
												<option stratus_val=5 <?php echo $monitoring_tech_v1['response_time_FTS'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
										<td>5</td>
										<td><input type="text" class="form-control" name="data[cmt19]" value="<?php echo $monitoring_tech_v1['cmt19'] ?>"></td>
									</tr>
									<tr>
										<td style="background-color:#F6DDCC">Business Critical</td>
										<td>20. Response Time RTs</td>
										<td>The agent is responding to the Resource Techs in a timely manner.</td>
										<td>
											<select  class="form-control stratus_point business stratusAuto" id="" name="data[response_time_RTS]" required>
												<!-- <option value="">-Select-</option> -->
												<option stratus_val=5 <?php echo $monitoring_tech_v1['response_time_RTS'] == "Pass"?"selected":"";?> value="Pass">Pass</option>
												<option stratus_val=5 <?php echo $monitoring_tech_v1['response_time_RTS'] == "Fail"?"selected":"";?> value="Fail">Fail</option>
												<option stratus_val=5 <?php echo $monitoring_tech_v1['response_time_RTS'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
										<td>5</td>
										<td><input type="text" class="form-control" name="data[cmt20]" value="<?php echo $monitoring_tech_v1['cmt20'] ?>"></td>
									</tr>
									<tr>
										<td style="background-color:#F6DDCC">Business Critical</td>
										<td>21. On-Turns</td>
										<td>The agent is following and taking turns in the data card / time sync group during their "on" hours.</td>
										<td>
											<select  class="form-control stratus_point business stratusAuto" id="" name="data[on_turns]" required>
												<!-- <option value="">-Select-</option> -->
												<option stratus_val=5 <?php echo $monitoring_tech_v1['on_turns'] == "Pass"?"selected":"";?> value="Pass">Pass</option>
												<option stratus_val=5 <?php echo $monitoring_tech_v1['on_turns'] == "Fail"?"selected":"";?> value="Fail">Fail</option>
												<option stratus_val=5 <?php echo $monitoring_tech_v1['on_turns'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
										<td>5</td>
										<td><input type="text" class="form-control" name="data[cmt21]" value="<?php echo $monitoring_tech_v1['cmt21'] ?>"></td>
									</tr>
									<tr>
										<td style="background-color:#F6DDCC">Business Critical</td>
										<td>22. Courtesy Calls</td>
										<td>The agent is completing courtesy calls or posting the patient information in the call tech group. The agent should document patients call preferences on the patient report.</td>
										<td>
											<select  class="form-control stratus_point business stratusAuto" id="" name="data[courtesy_calls]" required>
												<!-- <option value="">-Select-</option> -->
												<option stratus_val=10 <?php echo $monitoring_tech_v1['courtesy_calls'] == "Pass"?"selected":"";?> value="Pass">Pass</option>
												<option stratus_val=10 <?php echo $monitoring_tech_v1['courtesy_calls'] == "Fail"?"selected":"";?> value="Fail">Fail</option>
												<option stratus_val=10 <?php echo $monitoring_tech_v1['courtesy_calls'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
										<td>10</td>
										<td><input type="text" class="form-control" name="data[cmt22]" value="<?php echo $monitoring_tech_v1['cmt22'] ?>"></td>
									</tr>
									<tr>
										<td style="background-color:#F6DDCC">Business Critical</td>
										<td style="color: red;">23. Call Video</td>
										<td style="color: red;">The agent is calling the patients if they are off camera every check.</td>
										<td>
											<select  class="form-control stratus_point business stratusAuto" id="call_video_fatal" name="data[call_video_fatal]" required>
												<!-- <option value="">-Select-</option> -->
												<option stratus_val=10 <?php echo $monitoring_tech_v1['call_video_fatal'] == "Pass"?"selected":"";?> value="Pass">Pass</option>
												<option stratus_val=10 <?php echo $monitoring_tech_v1['call_video_fatal'] == "Fail"?"selected":"";?> value="Fail">Fail</option>
												<option stratus_val=10 <?php echo $monitoring_tech_v1['call_video_fatal'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
										<td>10</td>
										<td><input type="text" class="form-control" name="data[cmt23]" value="<?php echo $monitoring_tech_v1['cmt23'] ?>"></td>
									</tr>
									<tr>
										<td style="background-color:#F6DDCC">Business Critical</td>
										<td style="color: red;">24. Call OOR</td>
										<td style="color: red;">The agent is calling the patients if they are out of range every four hours.</td>
										<td>
											<select  class="form-control stratus_point business stratusAuto" id="call_OOR_fatal" name="data[call_OOR_fatal]" required>
												<!-- <option value="">-Select-</option> -->
												<option stratus_val=10 <?php echo $monitoring_tech_v1['call_OOR_fatal'] == "Pass"?"selected":"";?> value="Pass">Pass</option>
												<option stratus_val=10 <?php echo $monitoring_tech_v1['call_OOR_fatal'] == "Fail"?"selected":"";?> value="Fail">Fail</option>
												<option stratus_val=10 <?php echo $monitoring_tech_v1['call_OOR_fatal'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
										<td>10</td>
										<td><input type="text" class="form-control" name="data[cmt24]" value="<?php echo $monitoring_tech_v1['cmt24'] ?>"></td>
									</tr>
									<tr>
										<td style="background-color:#F6DDCC">Business Critical</td>
										<td>25. Self Disconnects</td>
										<td>The agent is following the Self DC protocol template and walking the patient through a self DC.</td>
										<td>
											<select  class="form-control stratus_point business stratusAuto" id="" name="data[self_disconnects]" required>
												<!-- <option value="">-Select-</option> -->
												<option stratus_val=3 <?php echo $monitoring_tech_v1['self_disconnects'] == "Pass"?"selected":"";?> value="Pass">Pass</option>
												<option stratus_val=3 <?php echo $monitoring_tech_v1['self_disconnects'] == "Fail"?"selected":"";?> value="Fail">Fail</option>
												<option stratus_val=3 <?php echo $monitoring_tech_v1['self_disconnects'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
										<td>3</td>
										<td><input type="text" class="form-control" name="data[cmt25]" value="<?php echo $monitoring_tech_v1['cmt25'] ?>"></td>
									</tr>
									<tr>
										<td style="background-color:#F6DDCC">Business Critical</td>
										<td>26. Escalation</td>
										<td>The agent is reaching out to their Resource Tech if a patient would like to self DS, extensive troubleshooting, wire maintenance, and other issues with the exam. Reporting and follow-up must be done according to internal and external protocols.</td>
										<td>
											<select  class="form-control stratus_point business stratusAuto" id="" name="data[escalation]" required>
												<!-- <option value="">-Select-</option> -->
												<option stratus_val=10 <?php echo $monitoring_tech_v1['escalation'] == "Pass"?"selected":"";?> value="Pass">Pass</option>
												<option stratus_val=10 <?php echo $monitoring_tech_v1['escalation'] == "Fail"?"selected":"";?> value="Fail">Fail</option>
												<option stratus_val=10 <?php echo $monitoring_tech_v1['escalation'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
										<td>10</td>
										<td><input type="text" class="form-control" name="data[cmt26]" value="<?php echo $monitoring_tech_v1['cmt26'] ?>"></td>
									</tr>
									<tr>
										<td colspan="6" style="background-color:#FFFF00; text-align:center;">PATIENT CARE / HANDLING</td>
									</tr>
									<tr>
										<td style="color:#FF0000">Compliance Critical</td>
										<td colspan="2">27. The agent mantains privacy and confidentiality.</td>
										
										<td>
											<select  class="form-control stratus_point compliance stratusAuto" id="" name="data[mantains_privacy]" required>
												<!-- <option value="">-Select-</option> -->
												<option stratus_val=10 <?php echo $monitoring_tech_v1['mantains_privacy'] == "Pass"?"selected":"";?> value="Pass">Pass</option>
												<option stratus_val=10 <?php echo $monitoring_tech_v1['mantains_privacy'] == "Fail"?"selected":"";?> value="Fail">Fail</option>
												<option stratus_val=10 <?php echo $monitoring_tech_v1['mantains_privacy'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
										<td>10</td>
										<td><input type="text" class="form-control" name="data[cmt27]" value="<?php echo $monitoring_tech_v1['cmt27'] ?>"></td>
									</tr>
									<tr>
										<td style="color:#0000FF">Customer Critical</td>
										<td colspan="2">28. The agent is able to handle the patient with care and kindness.</td>
										
										<td>
											<select  class="form-control stratus_point customer stratusAuto" id="" name="data[handle_patient]" required>
												<!-- <option value="">-Select-</option> -->
												<option stratus_val=5 <?php echo $monitoring_tech_v1['handle_patient'] == "Pass"?"selected":"";?> value="Pass">Pass</option>
												<option stratus_val=5 <?php echo $monitoring_tech_v1['handle_patient'] == "Fail"?"selected":"";?> value="Fail">Fail</option>
												<option stratus_val=5 <?php echo $monitoring_tech_v1['handle_patient'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
										<td>5</td>
										<td><input type="text" class="form-control" name="data[cmt28]" value="<?php echo $monitoring_tech_v1['cmt28'] ?>"></td>
									</tr>
									<tr>
										<td style="color:#0000FF">Customer Critical</td>
										<td colspan="2">29. The agents maintains the dignity of the patient the best way he or she can.</td>
										
										<td>
											<select  class="form-control stratus_point customer stratusAuto" id="" name="data[dignity_of_patient]" required>
												<!-- <option value="">-Select-</option> -->
												<option stratus_val=5 <?php echo $monitoring_tech_v1['dignity_of_patient'] == "Pass"?"selected":"";?> value="Pass">Pass</option>
												<option stratus_val=5 <?php echo $monitoring_tech_v1['dignity_of_patient'] == "Fail"?"selected":"";?> value="Fail">Fail</option>
												<option stratus_val=5 <?php echo $monitoring_tech_v1['dignity_of_patient'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
										<td>5</td>
										<td><input type="text" class="form-control" name="data[cmt29]" value="<?php echo $monitoring_tech_v1['cmt29'] ?>"></td>
									</tr>
									<tr>
										<td style="color:#0000FF">Customer Critical</td>
										<td colspan="2">30. The agent takes the initiative.</td>
										
										<td>
											<select  class="form-control stratus_point customer stratusAuto" id="" name="data[agent_initiative]" required>
												<!-- <option value="">-Select-</option> -->
												<option stratus_val=5 <?php echo $monitoring_tech_v1['agent_initiative'] == "Pass"?"selected":"";?> value="Pass">Pass</option>
												<option stratus_val=5 <?php echo $monitoring_tech_v1['agent_initiative'] == "Fail"?"selected":"";?> value="Fail">Fail</option>
												<option stratus_val=5 <?php echo $monitoring_tech_v1['agent_initiative'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
										<td>5</td>
										<td><input type="text" class="form-control" name="data[cmt30]" value="<?php echo $monitoring_tech_v1['cmt30'] ?>"></td>
									</tr>
									<tr>
										<td style="color:#0000FF">Customer Critical</td>
										<td colspan="2">31. The agent treats the patient as adults.</td>
										
										<td>
											<select  class="form-control stratus_point customer stratusAuto" id="" name="data[treat_patient_as_adults]" required>
												<!-- <option value="">-Select-</option> -->
												<option stratus_val=5 <?php echo $monitoring_tech_v1['treat_patient_as_adults'] == "Pass"?"selected":"";?> value="Pass">Pass</option>
												<option stratus_val=5 <?php echo $monitoring_tech_v1['treat_patient_as_adults'] == "Fail"?"selected":"";?> value="Fail">Fail</option>
												<option stratus_val=5 <?php echo $monitoring_tech_v1['treat_patient_as_adults'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
										<td>5</td>
										<td><input type="text" class="form-control" name="data[cmt31]" value="<?php echo $monitoring_tech_v1['cmt31'] ?>"></td>
									</tr>
									<tr>
										<td style="color:#0000FF">Customer Critical</td>
										<td colspan="2">32. The agent attentively listens and emphatically acts.</td>
										
										<td>
											<select  class="form-control stratus_point customer stratusAuto" id="" name="data[active_listening]" required>
												<!-- <option value="">-Select-</option> -->
												<option stratus_val=5 <?php echo $monitoring_tech_v1['active_listening'] == "Pass"?"selected":"";?> value="Pass">Pass</option>
												<option stratus_val=5 <?php echo $monitoring_tech_v1['active_listening'] == "Fail"?"selected":"";?> value="Fail">Fail</option>
												<option stratus_val=5 <?php echo $monitoring_tech_v1['active_listening'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
										<td>5</td>
										<td><input type="text" class="form-control" name="data[cmt32]" value="<?php echo $monitoring_tech_v1['cmt32'] ?>"></td>
									</tr>
									<tr><td colspan="6" style="background-color:#7DCEA0"></td></tr>
									<tr style="font-weight:bold; background-color:#D7BDE2">
										<td colspan="2">Compliance</td>
										<td colspan="2">Customer</td>
										<td colspan="2">Business</td>
									</tr>
									<tr style="font-weight:bold; background-color:#D7BDE2">
										<td>Earned Point:</td><td ><input type="text" readonly class="form-control" id="compliancescore1" name="data[compliancescore]"></td>
										<td>Earned Point:</td><td ><input type="text" readonly class="form-control" id="customerscore1" name="data[customerscore]"></td>
										<td>Earned Point:</td><td ><input type="text" readonly class="form-control" id="businessscore1" name="data[businessscore]"></td>
									</tr>
									<tr style="font-weight:bold; background-color:#D7BDE2">
										<td>Possible Point:</td><td ><input type="text" readonly class="form-control" id="compliancescoreable1" name="data[compliancescoreable]"></td>
										<td>Possible Point:</td><td ><input type="text" readonly class="form-control" id="customerscoreable1" name="data[customerscoreable]"></td>
										<td>Possible Point:</td><td ><input type="text" readonly class="form-control" id="businessscoreable1" name="data[businessscoreable]"></td>
									</tr>
									<tr style="font-weight:bold; background-color:#D7BDE2">
										<td>Overall Percentage:</td><td ><input type="text" readonly class="form-control" id="compliance_score_percent1" name="data[compliance_score_percent]"></td>
										<td>Overall Percentage:</td><td ><input type="text" readonly class="form-control" id="customer_score_percent1" name="data[customer_score_percent]"></td>
										<td>Overall Percentage:</td><td ><input type="text" readonly class="form-control" id="business_score_percent1" name="data[business_score_percent]"></td>
									</tr>
									
									<tr>
										<td style="background-color:#5058e6;color: white;">Call Summary:</td>
										<td colspan=2><textarea class="form-control" name="data[call_summary]"><?php echo $monitoring_tech_v1['call_summary'] ?></textarea></td>
										<td style="background-color:#5058e6;color: white;">Feedback:</td>
										<td colspan=2><textarea class="form-control" name="data[feedback]"><?php echo $monitoring_tech_v1['feedback'] ?></textarea></td>
									</tr>
									<tr>
										<td colspan=2 style="background-color:#5058e6;color: white;">Upload Files [m4a,mp4,mp3,wav]</td>
										<?php if($monitoringtech_v1_id==0){ ?>
											<td colspan=4>
												<input type="file" name="attach_file[]" id="attach_file" accept=".m4a,.mp4,.mp3,.wav,audio/*" />
											</td>
										<?php }else{
											if($monitoring_tech_v1['attach_file']!=''){ ?>
												<td colspan=4>
													<input type="file" multiple class="form-control"  id="attach_file" name="attach_file[]" accept=".m4a,.mp4,.mp3,.wav,audio/*"> 
													<?php $attach_file = explode(",",$monitoring_tech_v1['attach_file']);
													 foreach($attach_file as $mp){ ?>
														<audio controls='' style="background-color:#607F93"> 
														  <source src="<?php echo base_url(); ?>qa_files/qa_stratus/<?php echo $mp; ?>" type="audio/ogg">
														  <source src="<?php echo base_url(); ?>qa_files/qa_stratus/<?php echo $mp; ?>" type="audio/mpeg">
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
									
									<?php if($monitoringtech_v1_id!=0){ ?>
										<tr><td colspan=2 style="font-size:16px; font-weight:bold">Agent Feedback Acceptance:</td><td colspan=4><?php echo $monitoring_tech_v1['agnt_fd_acpt'] ?></td></tr>
										<tr><td colspan=2 style="font-size:16px; font-weight:bold">Agent Review:</td><td colspan=4><?php echo $monitoring_tech_v1['agent_rvw_note'] ?></td></tr>
										<tr><td colspan=2 style="font-size:16px; font-weight:bold">Management Review:</td><td colspan=4><?php echo $monitoring_tech_v1['mgnt_rvw_note'] ?></td></tr>
										<tr><td colspan=2 style="font-size:16px; font-weight:bold">Client Review:</td><td colspan=4><?php echo $monitoring_tech_v1['client_rvw_note'] ?></td></tr>
										
										<tr><td colspan=2  style="font-size:16px">Your Review <span style="font-size:24px;color:red">*</span></td><td colspan=4><textarea class="form-control1" style="width:100%" id="note" name="note" required></textarea></td></tr>
									<?php } ?>
									
									<?php 
									if($monitoringtech_v1_id==0){
										if(is_access_qa_module()==true || is_access_qa_operations_module()==true){ ?>
											<tr><td colspan=6><button class="btn btn-success waves-effect" type="submit" id="qaformsubmit" style="width:500px">SAVE</button></td></tr>
									<?php 
										} 
									}else{ 
										if(is_access_qa_module()==true || is_access_qa_operations_module()==true){
											if(is_available_qa_feedback($monitoring_tech_v1['entry_date'],72) == true){ ?>
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
