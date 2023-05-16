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

</style>

<?php if($monitoringtech_id!=0){
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
										<td colspan="6" id="theader" style="font-size:40px;text-align: center;background-color: #1948E0  ; color:white;">Monitoring Tech Audit Form</td>
										<input type="hidden" name="audit_start_time" value="<?php echo CurrMySqlDate(); ?>">
									</tr>
									<?php
										if($monitoringtech_id==0){
											$auditorName = get_username();
											$auditDate = CurrDateMDY();
											$clDate_val='';
											$dobDate_val='';
										}else{
											if($monitoring_tech['entry_by']!=''){
												$auditorName = $monitoring_tech['auditor_name'];
											}else{
												$auditorName = $monitoring_tech['client_name'];
											}
											$auditDate = mysql2mmddyy($monitoring_tech['audit_date']);
											$clDate_val = mysql2mmddyy($monitoring_tech['call_date']);
											$dobDate_val = mysql2mmddyy($monitoring_tech['dob']);
										}
									?>
									<tr>
										<td style="width:16%">Auditor Name: <span style="font-size:24px;color:red">*</span></td>
										<td style="width:16%"><input type="text" class="form-control" value="<?php echo $auditorName; ?>" disabled></td>
										<td style="width:16%">Audit Date: <span style="font-size:24px;color:red">*</span></td>
										<td style="width:16%"><input type="text" class="form-control" value="<?php echo $auditDate; ?>" disabled></td>
										<td style="width:16%">Call Date: <span style="font-size:24px;color:red">*</span></td>
										<td style="width:16%"><input type="text" class="form-control" id="call_date" onkeydown="return false;" name="call_date" value="<?php echo $clDate_val; ?>" required></td>
									</tr>
									<tr>
										<td>Agent: <span style="font-size:24px;color:red">*</span></td>
										<td>
											<select class="form-control" id="agent_id" name="data[agent_id]" required >
												<option value="<?php echo $monitoring_tech['agent_id'] ?>"><?php echo $monitoring_tech['fname']." ".$monitoring_tech['lname'] ?></option>
												<option value="">-Select-</option>
												<?php foreach($agentName as $row):  ?>
													<option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
												<?php endforeach; ?>
											</select>
										</td>
											<td>Fusion ID: <span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control" id="fusion_id" value="<?php echo $monitoring_tech['fusion_id'] ?>" readonly ></td>
											<td>L1 Supervisor: <span style="font-size:24px;color:red">*</span></td>
										<td>

											<input type="text" class="form-control" id="tl_name"  value="<?php echo $monitoring_tech['tl_name'] ?>" readonly>
											<input type="hidden" class="form-control" id="tl_id" name="data[tl_id]" value="<?php echo $monitoring_tech['tl_id'] ?>" required>
										</td>
									</tr>
									<tr>
										<td>Order Number:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control" name="data[order_number]" value="<?php echo $monitoring_tech['order_number'] ?>" required ></td>
										<td>Customer Name:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control" name="data[customer_name]" value="<?php echo $monitoring_tech['customer_name'] ?>" required ></td>
										<td >Auto Fail<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control" name="data[auto_fail]" id="param1" value="<?php echo $monitoring_tech['auto_fail'] ?>"   readonly> </td>
									</tr>

									<!-- <tr>
										
										<td>Dr: <span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control" name="data[dr]" value="<?php //echo $monitoring_tech['dr'] ?>" required ></td>
										<td>Patient: <span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control" name="data[customer_name]" value="<?php //echo $monitoring_tech['customer_name'] ?>" required ></td>
										<td >Rep: <span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control" name="data[rep]" id="" value="<?php //echo $monitoring_tech['rep'] ?>" required> </td>
									</tr> -->

									<tr>
										<td>VOC: <span style="font-size:24px;color:red">*</span></td>
										<td>
											<select class="form-control" id="voc" name="data[voc]" required>
													
													<option value="">-Select-</option>
													<option value="1"  <?= ($monitoring_tech['voc']=="1")?"selected":"" ?>>1</option>
													<option value="2"  <?= ($monitoring_tech['voc']=="2")?"selected":"" ?>>2</option>
													<option value="3"  <?= ($monitoring_tech['voc']=="3")?"selected":"" ?>>3</option>
													<option value="4"  <?= ($monitoring_tech['voc']=="4")?"selected":"" ?>>4</option>
													<option value="5"  <?= ($monitoring_tech['voc']=="5")?"selected":"" ?>>5</option>
													<option value="6"  <?= ($monitoring_tech['voc']=="6")?"selected":"" ?>>6</option>
													<option value="7"  <?= ($monitoring_tech['voc']=="7")?"selected":"" ?>>7</option>
													<option value="8"  <?= ($monitoring_tech['voc']=="8")?"selected":"" ?>>8</option>
													<option value="9"  <?= ($monitoring_tech['voc']=="9")?"selected":"" ?>>9</option>
													<option value="10"  <?= ($monitoring_tech['voc']=="10")?"selected":"" ?>>10</option>
												</select>
										</td>
										<td>Audit Type: <span style="font-size:24px;color:red">*</span></td>
										<td>
											<select class="form-control" id="audit_type" name="data[audit_type]" required>
                                                    <option value="">-Select-</option>
                                                    <option value="CQ Audit" <?= ($monitoring_tech['audit_type']=="CQ Audit")?"selected":"" ?>>CQ Audit</option>
                                                    <option value="BQ Audit" <?= ($monitoring_tech['audit_type']=="BQ Audit")?"selected":"" ?>>BQ Audit</option>
                                                    <option value="Calibration" <?= ($monitoring_tech['audit_type']=="Calibration")?"selected":"" ?>>Calibration</option>
                                                    <option value="Pre-Certificate Mock Call" <?= ($monitoring_tech['audit_type']=="Pre-Certificate Mock Call")?"selected":"" ?>>Pre-Certificate Mock Call</option>
                                                    <option value="Certification Audit" <?= ($monitoring_tech['audit_type']=="Certification Audit")?"selected":"" ?>>Certification Audit</option>
                                                    <option value="WoW Call"  <?= ($monitoring_tech['audit_type']=="WoW Call")?"selected":"" ?>>WoW Call</option>
                                                    <option value="Hygiene Audit"  <?= ($monitoring_tech['audit_type']=="Hygiene Audit")?"selected":"" ?>>Hygiene Audit</option>
                                                    <option value="Operation Audit"  <?= ($monitoring_tech['audit_type']=="Operation Audit")?"selected":"" ?>>Operation Audit</option>
                                                    <option value="Trainer Audit"  <?= ($monitoring_tech['audit_type']=="Trainer Audit")?"selected":"" ?>>Trainer Audit</option>  
                                                </select>
										</td>
										
										<td class="auType">Auditor Type: <span style="font-size:24px;color:red">*</span></td>
										<td class="auType">
											<select class="form-control" id="auditor_type" name="data[auditor_type]">
                                                    <option value="">Select</option>
                                                    <option value="Master" <?= ($monitoring_tech['auditor_type']=="Master")?"selected":"" ?>>Master</option>
                                                    <option value="Regular" <?= ($monitoring_tech['auditor_type']=="Regular")?"selected":"" ?>>Regular</option>
                                                </select>
										</td>
									</tr>
									
									<tr>
										<td style="font-weight:bold; font-size:16px; text-align:right">Earned Score:</td>
										<td><input type="text" readonly id="stratus_earned" name="data[earned_score]" class="form-control" style="font-weight:bold" value="<?php echo $monitoring_tech['earned_score'] ?>"></td>
										<td style="font-weight:bold; font-size:16px; text-align:right">Possible Score:</td>
										<td><input type="text" readonly id="stratus_possible" name="data[possible_score]" class="form-control" style="font-weight:bold" value="<?php echo $monitoring_tech['possible_score'] ?>"></td>
										<td style="font-weight:bold; font-size:16px; text-align:right">Overall Score:</td>
										<td><input type="text" readonly id="stratus_overall_score" name="data[overall_score]" class="form-control monitorinttech_fatal" style="font-weight:bold" value="<?php echo $monitoring_tech['overall_score'] ?>"></td>
									</tr>
									
									<tr style=" font-weight:bold;background-color:#6d71e3 ;color: white;">
										<td>COPC</td>
										<td colspan="2">Parameters</td>
										<td>Y/N</td>
										<td>Points</td>
										<td>Markdown Comments</td>
									</tr>
									<tr>
										<td style="background-color:#F9E79F">Compliance Critical</td>
										<td colspan="2" style="color: red;">1. Did the agent do his/her routine checks.</td>
										<td>
											<select  class="form-control stratus_point compliance stratusAuto" id="monitorinttectAF1" name="data[routine_checks]" required>
												<!-- <option value="">-Select-</option> -->
												<option stratus_val=5 <?php echo $monitoring_tech['routine_checks'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option stratus_val=5 <?php echo $monitoring_tech['routine_checks'] == "No"?"selected":"";?> value="No">No</option>
												<option stratus_val=0 <?php echo $monitoring_tech['routine_checks'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
										<td>5</td>
										<td><input type="text" class="form-control" name="data[cmt1]" value="<?php echo $monitoring_tech['cmt1'] ?>"></td>
									</tr>
									<tr>
									<!-- <td style="background-color:#FADBD8">Business Critical</td> -->
										<td colspan=6 style="text-align: left; background-color:#A3E4D7">2. Proper documentation</td>
										
									</tr>
									
									<tr>
										<td style="background-color:#F6DDCC">Business Critical</td>
										<td colspan="2" style="text-align: left;">2.1 Did the agent documents  Q2 checks on the patient report, using the correct template?</td>
										<td>
											<select  class="form-control stratus_point business" id="" name="data[patient_report]" required>
												<!-- <option value="">-Select-</option> -->
												<option stratus_val=1 <?php echo $monitoring_tech['patient_report'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option stratus_val=1 <?php echo $monitoring_tech['patient_report'] == "No"?"selected":"";?> value="No">No</option>
												<option stratus_val=0<?php echo $monitoring_tech['patient_report'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
										<td>1</td>
										<td><input type="text" class="form-control" name="data[cmt2]" value="<?php echo $monitoring_tech['cmt2'] ?>"></td>
									</tr>
									<tr>
										<td style="background-color:#F6DDCC">Business Critical</td>
										<td colspan="2" style="">2.2 Did the agent notate the hours collected and amplifier battery percentage on every check?</td>
										<td>
											<select  class="form-control stratus_point business" id="" name="data[amplifier]" required>
												<!-- <option value="">-Select-</option> -->
												<option stratus_val=1 <?php echo $monitoring_tech['amplifier'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option stratus_val=1 <?php echo $monitoring_tech['amplifier'] == "No"?"selected":"";?> value="No">No</option>
												<option stratus_val=0 <?php echo $monitoring_tech['amplifier'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
										<td>1</td>
										<td><input type="text" class="form-control" name="data[cmt3]" value="<?php echo $monitoring_tech['cmt3'] ?>"></td>
									</tr>
									<tr>
										<td style="background-color:#F6DDCC">Business Critical</td>
										<td colspan="2" style="">2.3 Did the agent document if the patient is on camera 1, camera 2, both cameras, or off camera?</td>
										<td>
											<select  class="form-control stratus_point business" id="" name="data[cameras]" required>
												<!-- <option value="">-Select-</option> -->
												<option stratus_val=1 <?php echo $monitoring_tech['cameras'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option stratus_val=1 <?php echo $monitoring_tech['cameras'] == "No"?"selected":"";?> value="No">No</option>
												<option stratus_val=0 <?php echo $monitoring_tech['cameras'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
										<td>1</td>
										<td><input type="text" class="form-control" name="data[cmt4]" value="<?php echo $monitoring_tech['cmt4'] ?>"></td>
									</tr>
									<tr>
										<td style="background-color:#F6DDCC">Business Critical</td>
										<td colspan="2" style="">2.4 Day Shift: Highlighting the patient blue and documenting the field tech that disconnected the patient.
										Night Shift: Highlighting the unit numbers cell blue.  Documenting the time and field tech scheduled to disconnect the patient. </td>
										<td>
											<select  class="form-control stratus_point business" id="" name="data[highlighting]" required>
												<!-- <option value="">-Select-</option> -->
												<option stratus_val=1 <?php echo $monitoring_tech['highlighting'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option stratus_val=1 <?php echo $monitoring_tech['highlighting'] == "No"?"selected":"";?> value="No">No</option>
												<option stratus_val=0 <?php echo $monitoring_tech['highlighting'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
										<td>1</td>
										<td><input type="text" class="form-control" name="data[cmt5]" value="<?php echo $monitoring_tech['cmt5'] ?>"></td>
									</tr>
									<tr>
										<td style="background-color:#F6DDCC">Business Critical</td>
										<td colspan="2" style="">2.5 Did the agent document in the call log when contacting a patient. All Calls, successful or unsuccessful?</td>
										<td>
											<select  class="form-control stratus_point business" id="" name="data[contacting]" required>
												<!-- <option value="">-Select-</option> -->
												<option stratus_val=1 <?php echo $monitoring_tech['contacting'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option stratus_val=1 <?php echo $monitoring_tech['contacting'] == "No"?"selected":"";?> value="No">No</option>
												<option stratus_val=0 <?php echo $monitoring_tech['contacting'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
										<td>1</td>
										<td><input type="text" class="form-control" name="data[cmt6]" value="<?php echo $monitoring_tech['cmt6'] ?>"></td>
									</tr>
									<tr>
										<td style="background-color:#F6DDCC">Business Critical</td>
										<td colspan="2" style="">2.6 Did the agent document the patients last name, leaving a detailed note, and including their initials? No blank notes. </td>
										<td>
											<select  class="form-control stratus_point business" id="" name="data[initials]" required>
												<!-- <option value="">-Select-</option> -->
												<option stratus_val=1 <?php echo $monitoring_tech['initials'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option stratus_val=1 <?php echo $monitoring_tech['initials'] == "No"?"selected":"";?> value="No">No</option>
												<option stratus_val=0 <?php echo $monitoring_tech['initials'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
										<td>1</td>
										<td><input type="text" class="form-control" name="data[cmt7]" value="<?php echo $monitoring_tech['cmt7'] ?>"></td>
									</tr>
									<tr>
										<td style="background-color:#F9E79F">Compliance Critical</td>
										<td colspan="2" style="">3 Did the agent call the patient whenever they are not seen on cam or out of range after two checks? </td>
										<td>
											<select  class="form-control stratus_point compliance" id="" name="data[patient_call]" required>
												<!-- <option value="">-Select-</option> -->
												<option stratus_val=5 <?php echo $monitoring_tech['patient_call'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option stratus_val=5 <?php echo $monitoring_tech['patient_call'] == "No"?"selected":"";?> value="No">No</option>
												<option stratus_val=0 <?php echo $monitoring_tech['patient_call'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
										<td>5</td>
										<td><input type="text" class="form-control" name="data[cmt8]" value="<?php echo $monitoring_tech['cmt8'] ?>"></td>
									</tr>
									<tr>
									<!-- <td style="background-color:#FADBD8">Business Critical</td> -->
										<td colspan=6 style="text-align: left; background-color:#A3E4D7">4.New Patient Setup </td>
										
									</tr>
									<tr>
										<td style="background-color:#F9E79F">Compliance Critical</td>
										<td colspan="2" style="">4.1Did the agent places initial on the Master Setup once the study has been cleared (box is checked), which is verifying that they have received this patient in their Team Monitor?</td>
										<td>
											<select  class="form-control stratus_point compliance" id="" name="data[master_setup]" required>
												<!-- <option value="">-Select-</option> -->
												<option stratus_val=1 <?php echo $monitoring_tech['master_setup'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option stratus_val=1 <?php echo $monitoring_tech['master_setup'] == "No"?"selected":"";?> value="No">No</option>
												<option stratus_val=0 <?php echo $monitoring_tech['master_setup'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
										<td>1</td>
										<td><input type="text" class="form-control" name="data[cmt9]" value="<?php echo $monitoring_tech['cmt9'] ?>"></td>
									</tr>
									<tr>
										<td style="background-color:#F9E79F">Compliance Critical</td>
										<td colspan="2" style="">4.2 Did the agent transfer the information that is on the Master Setup List on to their patient report?</td>
										<td>
											<select  class="form-control stratus_point compliance" id="" name="data[patient_rept]" required>
												<!-- <option value="">-Select-</option> -->
												<option stratus_val=1 <?php echo $monitoring_tech['patient_rept'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option stratus_val=1 <?php echo $monitoring_tech['patient_rept'] == "No"?"selected":"";?> value="No">No</option>
												<option stratus_val=0 <?php echo $monitoring_tech['patient_rept'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
										<td>1</td>
										<td><input type="text" class="form-control" name="data[cmt10]" value="<?php echo $monitoring_tech['cmt10'] ?>"></td>
									</tr>
									<tr>
										<td style="background-color:#F9E79F">Compliance Critical</td>
										<td colspan="2" style="">4.3 Did the agent verify and document the patients name, DOB, and BT ID number.</td>
										<td>
											<select  class="form-control stratus_point compliance" id="" name="data[patient_id]" required>
												<!-- <option value="">-Select-</option> -->
												<option stratus_val=1 <?php echo $monitoring_tech['patient_id'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option stratus_val=1 <?php echo $monitoring_tech['patient_id'] == "No"?"selected":"";?> value="No">No</option>
												<option stratus_val=0 <?php echo $monitoring_tech['patient_id'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
										<td>1</td>
										<td><input type="text" class="form-control" name="data[cmt11]" value="<?php echo $monitoring_tech['cmt11'] ?>"></td>
									</tr>	
									<tr>
										<td style="background-color:#F9E79F">Compliance Critical</td>
										<td colspan="2" style="">4.4 Did the agent document all phone numbers listed for the patient? </td>
										<td>
											<select  class="form-control stratus_point compliance" id="" name="data[patient_phone]" required>
												<!-- <option value="">-Select-</option> -->
												<option stratus_val=1 <?php echo $monitoring_tech['patient_phone'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option stratus_val=1 <?php echo $monitoring_tech['patient_phone'] == "No"?"selected":"";?> value="No">No</option>
												<option stratus_val=0 <?php echo $monitoring_tech['patient_phone'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
										<td>1</td>
										<td><input type="text" class="form-control" name="data[cmt12]" value="<?php echo $monitoring_tech['cmt12'] ?>"></td>
									</tr>	
									<tr>
										<td style="background-color:#F9E79F">Compliance Critical</td>
										<td colspan="2" style="">4.5 Did the agent document the exact start time? </td>
										<td>
											<select  class="form-control stratus_point compliance" id="" name="data[start_time]" required>
												<!-- <option value="">-Select-</option> -->
												<option stratus_val=1 <?php echo $monitoring_tech['start_time'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option stratus_val=1 <?php echo $monitoring_tech['start_time'] == "No"?"selected":"";?> value="No">No</option>
												<option stratus_val=0 <?php echo $monitoring_tech['start_time'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
										<td>1</td>
										<td><input type="text" class="form-control" name="data[cmt13]" value="<?php echo $monitoring_tech['cmt13'] ?>"></td>
									</tr>					
									<tr>
										<td style="background-color:#F9E79F">Compliance Critical</td>
										<td colspan="2" style="">4.6 Did the agent document if the patient has 2 cams, 1 cam, or no cameras?</td>
										<td>
											<select  class="form-control stratus_point compliance" id="" name="data[patient_cameras]" required>
												<!-- <option value="">-Select-</option> -->
												<option stratus_val=1 <?php echo $monitoring_tech['patient_cameras'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option stratus_val=1 <?php echo $monitoring_tech['patient_cameras'] == "No"?"selected":"";?> value="No">No</option>
												<option stratus_val=0 <?php echo $monitoring_tech['patient_cameras'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
										<td>1</td>
										<td><input type="text" class="form-control" name="data[cmt14]" value="<?php echo $monitoring_tech['cmt14'] ?>"></td>
									</tr>	
									<tr>
										<td style="background-color:#F9E79F">Compliance Critical</td>
										<td colspan="2" style="">4.7 Did the agent document the state and time zone the patient is located in?</td>
										<td>
											<select  class="form-control stratus_point compliance" id="" name="data[patient_location]" required>
												<!-- <option value="">-Select-</option> -->
												<option stratus_val=1 <?php echo $monitoring_tech['patient_location'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option stratus_val=1 <?php echo $monitoring_tech['patient_location'] == "No"?"selected":"";?> value="No">No</option>
												<option stratus_val=0 <?php echo $monitoring_tech['patient_location'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
										<td>1</td>
										<td><input type="text" class="form-control" name="data[cmt15]" value="<?php echo $monitoring_tech['cmt15'] ?>"></td>
									</tr>	
									<tr>
										<td style="background-color:#F9E79F">Compliance Critical</td>
										<td colspan="2" style="">5 Did the agent update WIP state in Bright Tree?</td>
										<td>
											<select  class="form-control stratus_point compliance" id="" name="data[bright_tree]" required>
												<!-- <option value="">-Select-</option> -->
												<option stratus_val=5 <?php echo $monitoring_tech['bright_tree'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option stratus_val=5 <?php echo $monitoring_tech['bright_tree'] == "No"?"selected":"";?> value="No">No</option>
												<option stratus_val=0 <?php echo $monitoring_tech['bright_tree'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
										<td>5</td>
										<td><input type="text" class="form-control" name="data[cmt16]" value="<?php echo $monitoring_tech['cmt16'] ?>"></td>
									</tr>
									<tr>
									<!-- <td style="background-color:#FADBD8">Business Critical</td> -->
										<td colspan=6 style="text-align: left; background-color:#A3E4D7">6. Patient Unit Setup</td>
										
									</tr>
									<tr>
										<td style="background-color:#F9E79F">Compliance Critical</td>
										<td colspan="2" style="">6.1 Did the agent sync the time on units, if it is the incorrect time zone or has not been completed in the past ten days?</td>
										<td>
											<select  class="form-control stratus_point compliance" id="" name="data[incorrect_time]" required>
												<!-- <option value="">-Select-</option> -->
												<option stratus_val=1 <?php echo $monitoring_tech['incorrect_time'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option stratus_val=1 <?php echo $monitoring_tech['incorrect_time'] == "No"?"selected":"";?> value="No">No</option>
												<option stratus_val=0 <?php echo $monitoring_tech['incorrect_time'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
										<td>1</td>
										<td><input type="text" class="form-control" name="data[cmt17]" value="<?php echo $monitoring_tech['cmt17'] ?>"></td>
									</tr>
									<tr>
										<td style="background-color:#F9E79F">Compliance Critical</td>
										<td colspan="2" style="">6.2 Did the agent format the data card?</td>
										<td>
											<select  class="form-control stratus_point compliance" id="" name="data[data_card]" required>
												<!-- <option value="">-Select-</option> -->
												<option stratus_val=1 <?php echo $monitoring_tech['data_card'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option stratus_val=1 <?php echo $monitoring_tech['data_card'] == "No"?"selected":"";?> value="No">No</option>
												<option stratus_val=0 <?php echo $monitoring_tech['data_card'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
										<td>1</td>
										<td><input type="text" class="form-control" name="data[cmt18]" value="<?php echo $monitoring_tech['cmt18'] ?>"></td>
									</tr>	
									<tr>
										<td style="background-color:#F9E79F">Compliance Critical</td>
										<td colspan="2" style="">6.3 Did the agent check the A/V Log to ensure audio is on, the cameras are configured properly, T4A firmware is updated and other unit issues?</td>
										<td>
											<select  class="form-control stratus_point compliance" id="" name="data[configured]" required>
												<!-- <option value="">-Select-</option> -->
												<option stratus_val=1 <?php echo $monitoring_tech['configured'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option stratus_val=1 <?php echo $monitoring_tech['configured'] == "No"?"selected":"";?> value="No">No</option>
												<option stratus_val=0 <?php echo $monitoring_tech['configured'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
										<td>1</td>
										<td><input type="text" class="form-control" name="data[cmt19]" value="<?php echo $monitoring_tech['cmt19'] ?>"></td>
									</tr>	

									<tr><td colspan="6" style="background-color:#7DCEA0"></td></tr>
									<tr style="font-weight:bold; background-color:#D7BDE2">
										<td colspan="3">Compliance</td>
										<!-- <td colspan="2">Customer</td> -->
										<td colspan="3">Business</td>
									</tr>
									<tr style="font-weight:bold; background-color:#D7BDE2">
										<td colspan="2">Earned Point:</td><td ><input type="text" readonly class="form-control" id="compliancescore1" name="data[compliancescore]"></td>
										<!-- <td>Earned Point:</td><td ><input type="text" readonly class="form-control" id="customerscore1" name="data[customerscore]"></td> -->
										<td colspan="2">Earned Point:</td><td ><input type="text" readonly class="form-control" id="businessscore1" name="data[businessscore]"></td>
									</tr>
									<tr style="font-weight:bold; background-color:#D7BDE2">
										<td colspan="2">Possible Point:</td><td ><input type="text" readonly class="form-control" id="compliancescoreable1" name="data[compliancescoreable]"></td>
										<!-- <td>Possible Point:</td><td ><input type="text" readonly class="form-control" id="customerscoreable1" name="data[customerscoreable]"></td> -->
										<td colspan="2">Possible Point:</td><td ><input type="text" readonly class="form-control" id="businessscoreable1" name="data[businessscoreable]"></td>
									</tr>
									<tr style="font-weight:bold; background-color:#D7BDE2">
										<td colspan="2">Overall Percentage:</td><td ><input type="text" readonly class="form-control" id="compliance_score_percent1" name="data[compliance_score_percent]"></td>
										<!-- <td>Overall Percentage:</td><td ><input type="text" readonly class="form-control" id="customer_score_percent1" name="data[customer_score_percent]"></td> -->
										<td colspan="2">Overall Percentage:</td><td ><input type="text" readonly class="form-control" id="business_score_percent1" name="data[business_score_percent]"></td>
									</tr>
									
									<tr>
										<td style="background-color:#5058e6;color: white;">Call Summary:</td>
										<td colspan=2><textarea class="form-control" name="data[call_summary]"><?php echo $monitoring_tech['call_summary'] ?></textarea></td>
										<td style="background-color:#5058e6;color: white;">Feedback:</td>
										<td colspan=2><textarea class="form-control" name="data[feedback]"><?php echo $monitoring_tech['feedback'] ?></textarea></td>
									</tr>
									<tr>
										<td colspan=2 style="background-color:#5058e6;color: white;">Upload Files [m4a,mp4,mp3,wav]</td>
										<?php if($monitoringtech_id==0){ ?>
											<td colspan=4>
												<input type="file" name="attach_file[]" id="attach_file" accept=".m4a,.mp4,.mp3,.wav,audio/*" />
											</td>
										<?php }else{
											if($monitoring_tech['attach_file']!=''){ ?>
												<td colspan=4>
													<input type="file" multiple class="form-control"  id="attach_file" name="attach_file[]" accept=".m4a,.mp4,.mp3,.wav,audio/*"> 
													<?php $attach_file = explode(",",$monitoring_tech['attach_file']);
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
									
									<?php if($monitoringtech_id!=0){ ?>
										<tr><td colspan=2 style="font-size:16px; font-weight:bold">Agent Feedback Acceptance:</td><td colspan=4><?php echo $monitoring_tech['agnt_fd_acpt'] ?></td></tr>
										<tr><td colspan=2 style="font-size:16px; font-weight:bold">Agent Review:</td><td colspan=4><?php echo $monitoring_tech['agent_rvw_note'] ?></td></tr>
										<tr><td colspan=2 style="font-size:16px; font-weight:bold">Management Review:</td><td colspan=4><?php echo $monitoring_tech['mgnt_rvw_note'] ?></td></tr>
										<tr><td colspan=2 style="font-size:16px; font-weight:bold">Client Review:</td><td colspan=4><?php echo $monitoring_tech['client_rvw_note'] ?></td></tr>
										
										<tr><td colspan=2  style="font-size:16px">Your Review</td><td colspan=4><textarea class="form-control1" style="width:100%" id="note" name="note"></textarea></td></tr>
									<?php } ?>
									
									<?php 
									if($monitoringtech_id==0){
										if(is_access_qa_module()==true || is_access_qa_operations_module()==true){ ?>
											<tr><td colspan=6><button class="btn btn-success waves-effect" type="submit" id="qaformsubmit" style="width:500px">SAVE</button></td></tr>
									<?php 
										} 
									}else{ 
										if(is_access_qa_module()==true || is_access_qa_operations_module()==true){
											if(is_available_qa_feedback($monitoring_tech['entry_date'],72) == true){ ?>
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
