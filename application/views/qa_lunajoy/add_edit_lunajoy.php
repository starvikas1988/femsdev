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

<?php if($lunajoy_id!=0){
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
										<td colspan="6" id="theader" style="font-size:40px;text-align: center;background-color: #1948E0  ; color:white;"> Lunajoy QA Audit Form</td>
										<input type="hidden" name="audit_start_time" value="<?php echo CurrMySqlDate(); ?>">
									</tr>
									<?php
										if($lunajoy_id==0){
											$auditorName = get_username();
											$auditDate = CurrDateMDY();
											$clDate_val='';
											$call_duration='';
											//$dobDate_val='';
										}else{
											if($lunajoy_data['entry_by']!=''){
												$auditorName = $lunajoy_data['auditor_name'];
											}else{
												$auditorName = $lunajoy_data['client_name'];
											}
											$auditDate = mysql2mmddyy($lunajoy_data['audit_date']);
											$clDate_val = mysqlDt2mmddyy($lunajoy_data['call_date']);
											$call_duration = $lunajoy_data['call_duration'];
											//$dobDate_val = mysql2mmddyy($lunajoy_data['dob']);
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
												<option value="<?php echo $lunajoy_data['agent_id'] ?>"><?php echo $lunajoy_data['fname']." ".$lunajoy_data['lname'] ?></option>
												<option value="">-Select-</option>
												<?php foreach($agentName as $row):  ?>
													<option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
												<?php endforeach; ?>
											</select>
										</td>
											<td>Employee ID: <span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control" id="fusion_id" value="<?php echo $lunajoy_data['fusion_id'] ?>" readonly ></td>
											<td>L1 Supervisor: <span style="font-size:24px;color:red">*</span></td>
										<td>

											<input type="text" class="form-control" id="tl_name"  value="<?php echo $lunajoy_data['tl_name'] ?>" readonly>
											<input type="hidden" class="form-control" id="tl_id" name="data[tl_id]" value="<?php echo $lunajoy_data['tl_id'] ?>" required>
										</td>
									</tr>
									<tr>
										<td>Order/Ticket Id:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control" name="data[ticket_id]" value="<?php echo $lunajoy_data['ticket_id'] ?>" required ></td>
										<td>Call Duration:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control" id="call_duration" name="data[call_duration]" onkeydown="return false;" value="<?php echo $call_duration; ?>" required></td> 
										<td >Interaction ID<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control" name="data[interaction_id]" id="" value="<?php echo $lunajoy_data['interaction_id'] ?>"   required> </td>
									</tr>

									<tr>
										<td>VOC: <span style="font-size:24px;color:red">*</span></td>
										<td>
											<select class="form-control" id="voc" name="data[voc]" required>
													
													<option value="">-Select-</option>
													<option value="1"  <?= ($lunajoy_data['voc']=="1")?"selected":"" ?>>1</option>
													<option value="2"  <?= ($lunajoy_data['voc']=="2")?"selected":"" ?>>2</option>
													<option value="3"  <?= ($lunajoy_data['voc']=="3")?"selected":"" ?>>3</option>
													<option value="4"  <?= ($lunajoy_data['voc']=="4")?"selected":"" ?>>4</option>
													<option value="5"  <?= ($lunajoy_data['voc']=="5")?"selected":"" ?>>5</option>
													<option value="6"  <?= ($lunajoy_data['voc']=="6")?"selected":"" ?>>6</option>
													<option value="7"  <?= ($lunajoy_data['voc']=="7")?"selected":"" ?>>7</option>
													<option value="8"  <?= ($lunajoy_data['voc']=="8")?"selected":"" ?>>8</option>
													<option value="9"  <?= ($lunajoy_data['voc']=="9")?"selected":"" ?>>9</option>
													<option value="10"  <?= ($lunajoy_data['voc']=="10")?"selected":"" ?>>10</option>
												</select>
										</td>
										<td>KPI-ACPT: <span style="font-size:24px;color:red">*</span></td>
										<td>
											<select class="form-control" id="" name="data[kpi_acpt]" required>
                                                   <option value="">-Select-</option>
												    <option value="Agent" <?= ($lunajoy_data['kpi_acpt']=="Agent")?"selected":"" ?>>Agent</option>
													<option value="Customer" <?= ($lunajoy_data['kpi_acpt']=="Customer")?"selected":"" ?>>Customer</option>
													<option value="Process" <?= ($lunajoy_data['kpi_acpt']=="Process")?"selected":"" ?>>Process</option>
													<option value="Technology" <?= ($lunajoy_data['kpi_acpt']=="Technology")?"selected":"" ?>>Technology</option>
													<option value="NA" <?= ($lunajoy_data['kpi_acpt']=="NA")?"selected":"" ?>>NA</option>
                                                    
                                                </select>
										</td>
										<td>Audit Type: <span style="font-size:24px;color:red">*</span></td>
										<td>
											<select class="form-control" id="audit_type" name="data[audit_type]" required>
                                                    <option value="">-Select-</option>
                                                    <option value="CQ Audit" <?= ($lunajoy_data['audit_type']=="CQ Audit")?"selected":"" ?>>CQ Audit</option>
                                                    <option value="BQ Audit" <?= ($lunajoy_data['audit_type']=="BQ Audit")?"selected":"" ?>>BQ Audit</option>
                                                    <option value="Calibration" <?= ($lunajoy_data['audit_type']=="Calibration")?"selected":"" ?>>Calibration</option>
                                                    <option value="Pre-Certificate Mock Call" <?= ($lunajoy_data['audit_type']=="Pre-Certificate Mock Call")?"selected":"" ?>>Pre-Certificate Mock Call</option>
                                                    <option value="Certification Audit" <?= ($lunajoy_data['audit_type']=="Certification Audit")?"selected":"" ?>>Certification Audit</option>
                                                    <option value="WoW Call"  <?= ($lunajoy_data['audit_type']=="WoW Call")?"selected":"" ?>>WoW Call</option>
                                                    <option value="Operation Audit"  <?= ($lunajoy_data['audit_type']=="Operation Audit")?"selected":"" ?>>Operation Audit</option>
                                                    <option value="Trainer Audit"  <?= ($lunajoy_data['audit_type']=="Trainer Audit")?"selected":"" ?>>Trainer Audit</option>
                                                    <option value="Hygiene Audit"  <?= ($lunajoy_data['audit_type']=="Hygiene Audit")?"selected":"" ?>>Hygiene Audit</option>
                                                    <option value="QA Supervisor Audit"  <?= ($lunajoy_data['audit_type']=="QA Supervisor Audit")?"selected":"" ?>>QA Supervisor Audit</option>   
                                                </select>
										</td>
										
										</tr>
									<tr>
										<td class="auType">Auditor Type: <span style="font-size:24px;color:red">*</span></td>
										<td class="auType">
											<select class="form-control" id="auditor_type" name="data[auditor_type]">
                                                    <option value="">Select</option>
                                                    <option value="Master" <?= ($lunajoy_data['auditor_type']=="Master")?"selected":"" ?>>Master</option>
                                                    <option value="Regular" <?= ($lunajoy_data['auditor_type']=="Regular")?"selected":"" ?>>Regular</option>
                                                </select>
										</td>
									</tr>
									
									<tr>
										<td style="font-weight:bold; font-size:16px; text-align:right">Earned Score:</td>
										<td><input type="text" readonly id="lunajoy_earned_score" name="data[earned_score]" class="form-control" style="font-weight:bold" value="<?php echo $lunajoy_data['earned_score'] ?>"></td>
										<td style="font-weight:bold; font-size:16px; text-align:right">Possible Score:</td>
										<td><input type="text" readonly id="lunajoy_possible_score" name="data[possible_score]" class="form-control" style="font-weight:bold" value="<?php echo $lunajoy_data['possible_score'] ?>"></td>
										<td style="font-weight:bold; font-size:16px; text-align:right">Overall Score:</td>
										<td><input type="text" readonly id="lunajoy_overall_score" name="data[overall_score]" class="form-control urban_piperFatal" style="font-weight:bold" value="<?php echo $lunajoy_data['overall_score'] ?>"></td>
									</tr>
									
									<tr style=" font-weight:bold;background-color:#6d71e3 ;color: white;">
										<td>Parameters</td>
										<td colspan="2">Sub Parameter</td>
										<td>Status</td>
										<td>Weight</td>
										<td>REMARKS</td>
									</tr>
									<tr>
										<td rowspan="6" style="background-color:#FFFF00; text-align:center;">Polite and professional - 15%</td>
										<td colspan="2">Listening to patient (not cutting them off).</td>
										<td>
											<select  class="form-control lunajoy_point" id="" name="data[listening_to_patient]" required>
												<option value="">-Select-</option>
												<option lunajoy_val=2.5 lunajoy_max="2.5"<?php echo $lunajoy_data['listening_to_patient'] == "Pass"?"selected":"";?> value="Pass">Pass</option>
												<option lunajoy_val=0 lunajoy_max="2.5"<?php echo $lunajoy_data['listening_to_patient'] == "Fail"?"selected":"";?> value="Fail">Fail</option>
												<option lunajoy_val=2.5 lunajoy_max="2.5"<?php echo $lunajoy_data['listening_to_patient'] == "NA"?"selected":"";?> value="NA">NA</option>
											</select> 
										</td>
										<td>2.5</td>
										<td><input type="text" class="form-control" name="data[cmt1]" value="<?php echo $lunajoy_data['cmt1'] ?>"></td>
									</tr>
									<tr>
										<td colspan="2">Courteous, thoughtful, and making sure patient has a positive experience.</td>
										<td>
											<select  class="form-control lunajoy_point" id="" name="data[positive_experience]" required>
												<option value="">-Select-</option>
												<option lunajoy_val=2.5 lunajoy_max="2.5"<?php echo $lunajoy_data['positive_experience'] == "Pass"?"selected":"";?> value="Pass">Pass</option>
												<option lunajoy_val=0 lunajoy_max="2.5"<?php echo $lunajoy_data['positive_experience'] == "Fail"?"selected":"";?> value="Fail">Fail</option>
												<option lunajoy_val=2.5 lunajoy_max="2.5"<?php echo $lunajoy_data['positive_experience'] == "NA"?"selected":"";?> value="NA">NA</option>
											</select> 
										</td>
										<td>2.5</td>
										<td><input type="text" class="form-control" name="data[cmt2]" value="<?php echo $lunajoy_data['cmt2'] ?>"></td>
									</tr>
									<tr>
										<td colspan="2">Answering each question the patient asks.</td>
										<td>
											<select  class="form-control lunajoy_point" id="" name="data[answering_question]" required>
												<option value="">-Select-</option>
												<option lunajoy_val=2.5 lunajoy_max="2.5"<?php echo $lunajoy_data['answering_question'] == "Pass"?"selected":"";?> value="Pass">Pass</option>
												<option lunajoy_val=0 lunajoy_max="2.5"<?php echo $lunajoy_data['answering_question'] == "Fail"?"selected":"";?> value="Fail">Fail</option>
												<option lunajoy_val=2.5 lunajoy_max="2.5"<?php echo $lunajoy_data['answering_question'] == "NA"?"selected":"";?> value="NA">NA</option>
											</select> 
										</td>
										<td>2.5</td>
										<td><input type="text" class="form-control" name="data[cmt3]" value="<?php echo $lunajoy_data['cmt3'] ?>"></td>
									</tr>
									<tr>
										<td colspan="2">Supporting the patient and other team members (ie booking the patient appointment even if you don't get the credit).</td>
										<td>
											<select  class="form-control lunajoy_point" id="" name="data[supporting_patient]" required>
												<option value="">-Select-</option>
												<option lunajoy_val=2.5 lunajoy_max="2.5"<?php echo $lunajoy_data['supporting_patient'] == "Pass"?"selected":"";?> value="Pass">Pass</option>
												<option lunajoy_val=0 lunajoy_max="2.5"<?php echo $lunajoy_data['supporting_patient'] == "Fail"?"selected":"";?> value="Fail">Fail</option>
												<option lunajoy_val=2.5 lunajoy_max="2.5"<?php echo $lunajoy_data['supporting_patient'] == "NA"?"selected":"";?> value="NA">NA</option>
											</select> 
										</td>
										<td>2.5</td>
										<td><input type="text" class="form-control" name="data[cmt4]" value="<?php echo $lunajoy_data['cmt4'] ?>"></td>
									</tr>
									<tr>
										<td colspan="2">Used all the required tools e.g. Grammarly to ensure the quality of the text/email content.</td>
										<td>
											<select  class="form-control lunajoy_point" id="" name="data[grammarly_tools]" required>
												<option value="">-Select-</option>
												<option lunajoy_val=2.5 lunajoy_max="2.5"<?php echo $lunajoy_data['grammarly_tools'] == "Pass"?"selected":"";?> value="Pass">Pass</option>
												<option lunajoy_val=0 lunajoy_max="2.5"<?php echo $lunajoy_data['grammarly_tools'] == "Fail"?"selected":"";?> value="Fail">Fail</option>
												<option lunajoy_val=2.5 lunajoy_max="2.5"<?php echo $lunajoy_data['grammarly_tools'] == "NA"?"selected":"";?> value="NA">NA</option>
											</select> 
										</td>
										<td>2.5</td>
										<td><input type="text" class="form-control" name="data[cmt5]" value="<?php echo $lunajoy_data['cmt5'] ?>"></td>
									</tr>
									<tr>
										<td colspan="2">Used "Engaged" in GHL.</td>
										<td>
											<select  class="form-control lunajoy_point" id="" name="data[engaged_ghl]" required>
												<option value="">-Select-</option>
												<option lunajoy_val=2.5 lunajoy_max="2.5"<?php echo $lunajoy_data['engaged_ghl'] == "Pass"?"selected":"";?> value="Pass">Pass</option>
												<option lunajoy_val=0 lunajoy_max="2.5"<?php echo $lunajoy_data['engaged_ghl'] == "Fail"?"selected":"";?> value="Fail">Fail</option>
												<option lunajoy_val=2.5 lunajoy_max="2.5"<?php echo $lunajoy_data['engaged_ghl'] == "NA"?"selected":"";?> value="NA">NA</option>
											</select> 
										</td>
										<td>2.5</td>
										<td><input type="text" class="form-control" name="data[cmt6]" value="<?php echo $lunajoy_data['cmt6'] ?>"></td>
									</tr>
									<tr>
										<td rowspan="6" style="background-color:#F6DDCC; text-align:center;">Action - 15%</td>
										<td colspan="2">Was the correct tag used?</td>
										<td>
											<select  class="form-control lunajoy_point" id="" name="data[correct_tag]" required>
												<option value="">-Select-</option>
												<option lunajoy_val=2.5 lunajoy_max="2.5"<?php echo $lunajoy_data['correct_tag'] == "Pass"?"selected":"";?> value="Pass">Pass</option>
												<option lunajoy_val=0 lunajoy_max="2.5"<?php echo $lunajoy_data['correct_tag'] == "Fail"?"selected":"";?> value="Fail">Fail</option>
												<option lunajoy_val=2.5 lunajoy_max="2.5"<?php echo $lunajoy_data['correct_tag'] == "NA"?"selected":"";?> value="NA">NA</option>
											</select> 
										</td>
										<td>2.5</td>
										<td><input type="text" class="form-control" name="data[cmt7]" value="<?php echo $lunajoy_data['cmt7'] ?>"></td>
									</tr>
									<tr>
										<td colspan="2">Did you notate the patients chart? (if needed)</td>
										<td>
											<select  class="form-control lunajoy_point" id="" name="data[patients_chart]" required>
												<option value="">-Select-</option>
												<option lunajoy_val=2.5 lunajoy_max="2.5"<?php echo $lunajoy_data['patients_chart'] == "Pass"?"selected":"";?> value="Pass">Pass</option>
												<option lunajoy_val=0 lunajoy_max="2.5"<?php echo $lunajoy_data['patients_chart'] == "Fail"?"selected":"";?> value="Fail">Fail</option>
												<option lunajoy_val=2.5 lunajoy_max="2.5"<?php echo $lunajoy_data['patients_chart'] == "NA"?"selected":"";?> value="NA">NA</option>
											</select> 
										</td>
										<td>2.5</td>
										<td><input type="text" class="form-control" name="data[cmt8]" value="<?php echo $lunajoy_data['cmt8'] ?>"></td>
									</tr>
									<tr>
										<td colspan="2">Did you complete the action? (example, delete or move the appointment)</td>
										<td>
											<select  class="form-control lunajoy_point" id="" name="data[complete_action]" required>
												<option value="">-Select-</option>
												<option lunajoy_val=2.5 lunajoy_max="2.5"<?php echo $lunajoy_data['complete_action'] == "Pass"?"selected":"";?> value="Pass">Pass</option>
												<option lunajoy_val=0 lunajoy_max="2.5"<?php echo $lunajoy_data['complete_action'] == "Fail"?"selected":"";?> value="Fail">Fail</option>
												<option lunajoy_val=2.5 lunajoy_max="2.5"<?php echo $lunajoy_data['complete_action'] == "NA"?"selected":"";?> value="NA">NA</option>
											</select> 
										</td>
										<td>2.5</td>
										<td><input type="text" class="form-control" name="data[cmt9]" value="<?php echo $lunajoy_data['cmt9'] ?>"></td>
									</tr>
									<tr>
										<td colspan="2">Was the patient moved to the correct pipeline?</td>
										<td>
											<select  class="form-control lunajoy_point" id="" name="data[correct_pipeline]" required>
												<option value="">-Select-</option>
												<option lunajoy_val=2.5 lunajoy_max="2.5"<?php echo $lunajoy_data['correct_pipeline'] == "Pass"?"selected":"";?> value="Pass">Pass</option>
												<option lunajoy_val=0 lunajoy_max="2.5"<?php echo $lunajoy_data['correct_pipeline'] == "Fail"?"selected":"";?> value="Fail">Fail</option>
												<option lunajoy_val=2.5 lunajoy_max="2.5"<?php echo $lunajoy_data['correct_pipeline'] == "NA"?"selected":"";?> value="NA">NA</option>
											</select> 
										</td>
										<td>2.5</td>
										<td><input type="text" class="form-control" name="data[cmt10]" value="<?php echo $lunajoy_data['cmt10'] ?>"></td>
									</tr>
									<tr>
										<td colspan="2">Was the clinician informed of a cancelation for appts withing 24 hours?</td>
										<td>
											<select  class="form-control lunajoy_point" id="" name="data[cancelation_for_appts]" required>
												<option value="">-Select-</option>
												<option lunajoy_val=2.5 lunajoy_max="2.5"<?php echo $lunajoy_data['cancelation_for_appts'] == "Pass"?"selected":"";?> value="Pass">Pass</option>
												<option lunajoy_val=0 lunajoy_max="2.5"<?php echo $lunajoy_data['cancelation_for_appts'] == "Fail"?"selected":"";?> value="Fail">Fail</option>
												<option lunajoy_val=2.5 lunajoy_max="2.5"<?php echo $lunajoy_data['cancelation_for_appts'] == "NA"?"selected":"";?> value="NA">NA</option>
											</select> 
										</td>
										<td>2.5</td>
										<td><input type="text" class="form-control" name="data[cmt11]" value="<?php echo $lunajoy_data['cmt11'] ?>"></td>
									</tr>
									<tr>
										<td colspan="2">Did you tag engaged by?</td>
										<td>
											<select  class="form-control lunajoy_point" id="" name="data[tag_engaged]" required>
												<option value="">-Select-</option>
												<option lunajoy_val=2.5 lunajoy_max="2.5"<?php echo $lunajoy_data['tag_engaged'] == "Pass"?"selected":"";?> value="Pass">Pass</option>
												<option lunajoy_val=0 lunajoy_max="2.5"<?php echo $lunajoy_data['tag_engaged'] == "Fail"?"selected":"";?> value="Fail">Fail</option>
												<option lunajoy_val=2.5 lunajoy_max="2.5"<?php echo $lunajoy_data['tag_engaged'] == "NA"?"selected":"";?> value="NA">NA</option>
											</select> 
										</td>
										<td>2.5</td>
										<td><input type="text" class="form-control" name="data[cmt12]" value="<?php echo $lunajoy_data['cmt12'] ?>"></td>
									</tr>
									<tr>
										<td rowspan="2" style="background-color:#FF7F7F ; text-align:center;">Timely - 15%</td>
										<td colspan="2">Provide support to customers in an opportune manner.</td>
										<td>
											<select  class="form-control lunajoy_point" id="" name="data[support_customers]" required>
												<option value="">-Select-</option>
												<option lunajoy_val=7.5 lunajoy_max="7.5"<?php echo $lunajoy_data['support_customers'] == "Pass"?"selected":"";?> value="Pass">Pass</option>
												<option lunajoy_val=0 lunajoy_max="7.5"<?php echo $lunajoy_data['support_customers'] == "Fail"?"selected":"";?> value="Fail">Fail</option>
												<option lunajoy_val=7.5 lunajoy_max="7.5"<?php echo $lunajoy_data['support_customers'] == "NA"?"selected":"";?> value="NA">NA</option>
											</select> 
										</td>
										<td>7.5</td>
										<td><input type="text" class="form-control" name="data[cmt13]" value="<?php echo $lunajoy_data['cmt13'] ?>"></td>
									</tr>
									<tr>
										<td colspan="2">Responding to customer requests on time as well as resolving customer issues in a timely fashion.</td>
										<td>
											<select  class="form-control lunajoy_point" id="" name="data[resolving_customer_issues]" required>
												<option value="">-Select-</option>
												<option lunajoy_val=7.5 lunajoy_max="7.5"<?php echo $lunajoy_data['resolving_customer_issues'] == "Pass"?"selected":"";?> value="Pass">Pass</option>
												<option lunajoy_val=0 lunajoy_max="7.5"<?php echo $lunajoy_data['resolving_customer_issues'] == "Fail"?"selected":"";?> value="Fail">Fail</option>
												<option lunajoy_val=7.5 lunajoy_max="7.5"<?php echo $lunajoy_data['resolving_customer_issues'] == "NA"?"selected":"";?> value="NA">NA</option>
											</select> 
										</td>
										<td>7.5</td>
										<td><input type="text" class="form-control" name="data[cmt14]" value="<?php echo $lunajoy_data['cmt14'] ?>"></td>
									</tr>
									<tr>
										<td rowspan="1" style="background-color:#ADD8E6; text-align:center;">Correct information - 30%</td>
										<td colspan="2">Providing the patient with correct information regarding clinician specialty, appointment availability, the consent form, CC authorization form, no-show/late cancel policy. Following procedure and workflow.</td>
										<td>
											<select  class="form-control lunajoy_point" id="" name="data[correct_information]" required>
												<option value="">-Select-</option>
												<option lunajoy_val=30 lunajoy_max="30"<?php echo $lunajoy_data['correct_information'] == "Pass"?"selected":"";?> value="Pass">Pass</option>
												<option lunajoy_val=0 lunajoy_max="30"<?php echo $lunajoy_data['correct_information'] == "Fail"?"selected":"";?> value="Fail">Fail</option>
												<option lunajoy_val=30 lunajoy_max="30"<?php echo $lunajoy_data['correct_information'] == "NA"?"selected":"";?> value="NA">NA</option>
											</select> 
										</td>
										<td>30</td>
										<td><input type="text" class="form-control" name="data[cmt15]" value="<?php echo $lunajoy_data['cmt15'] ?>"></td>
									</tr>
									<tr>
										<td rowspan="2" style="background-color:#eedd82; text-align:center;">FCR - 25%</td>
										<td colspan="2">Did the patients needs get resolved by front desk on the first attempt. Example, booking the patient appt, billing issues, RX.</td>
										<td>
											<select  class="form-control lunajoy_point" id="" name="data[resolved_by_front_desk]" required>
												<option value="">-Select-</option>
												<option lunajoy_val=12.5 lunajoy_max="12.5"<?php echo $lunajoy_data['resolved_by_front_desk'] == "Pass"?"selected":"";?> value="Pass">Pass</option>
												<option lunajoy_val=0 lunajoy_max="12.5"<?php echo $lunajoy_data['resolved_by_front_desk'] == "Fail"?"selected":"";?> value="Fail">Fail</option>
												<option lunajoy_val=12.5 lunajoy_max="12.5"<?php echo $lunajoy_data['resolved_by_front_desk'] == "NA"?"selected":"";?> value="NA">NA</option>
											</select> 
										</td>
										<td>12.5</td>
										<td><input type="text" class="form-control" name="data[cmt16]" value="<?php echo $lunajoy_data['cmt16'] ?>"></td>
									</tr>
									<tr>
										<td colspan="2">Used and followed the proper workflow, channel, tools to achieve FCR.</td>
										<td>
											<select  class="form-control lunajoy_point" id="" name="data[proper_workflow]" required>
												<option value="">-Select-</option>
												<option lunajoy_val=12.5 lunajoy_max="12.5"<?php echo $lunajoy_data['proper_workflow'] == "Pass"?"selected":"";?> value="Pass">Pass</option>
												<option lunajoy_val=0 lunajoy_max="12.5"<?php echo $lunajoy_data['proper_workflow'] == "Fail"?"selected":"";?> value="Fail">Fail</option>
												<option lunajoy_val=12.5 lunajoy_max="12.5"<?php echo $lunajoy_data['proper_workflow'] == "NA"?"selected":"";?> value="NA">NA</option>
											</select> 
										</td>
										<td>12.5</td>
										<td><input type="text" class="form-control" name="data[cmt17]" value="<?php echo $lunajoy_data['cmt17'] ?>"></td>
									</tr>
									<tr>
										<td style="background-color:#5058e6;color: white;">Call Summary:</td>
										<td colspan=2><textarea class="form-control" name="data[call_summary]"><?php echo $lunajoy_data['call_summary'] ?></textarea></td>
										<td style="background-color:#5058e6;color: white;">Feedback:</td>
										<td colspan=2><textarea class="form-control" name="data[feedback]"><?php echo $lunajoy_data['feedback'] ?></textarea></td>
									</tr>
									<tr>
										<td colspan=2 style="background-color:#5058e6;color: white;">Upload Files [m4a,mp4,mp3,wav]</td>
										<?php if($lunajoy_id==0){ ?>
											<td colspan=4>
												<input type="file" name="attach_file[]" id="attach_file" accept=".m4a,.mp4,.mp3,.wav,audio/*" />
											</td>
										<?php }else{
											if($lunajoy_data['attach_file']!=''){ ?>
												<td colspan=4>
													<input type="file" multiple class="form-control"  id="attach_file" name="attach_file[]" accept=".m4a,.mp4,.mp3,.wav,audio/*"> 
													<?php $attach_file = explode(",",$lunajoy_data['attach_file']);
													 foreach($attach_file as $mp){ ?>
														<audio controls='' style="background-color:#607F93"> 
														  <source src="<?php echo base_url(); ?>qa_files/qa_lunajoy/<?php echo $mp; ?>" type="audio/ogg">
														  <source src="<?php echo base_url(); ?>qa_files/qa_lunajoy/<?php echo $mp; ?>" type="audio/mpeg">
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
									
									<?php if($lunajoy_id!=0){ ?>
										<tr><td colspan=2 style="font-size:16px; font-weight:bold">Agent Feedback Acceptance:</td><td colspan=4><?php echo $lunajoy_data['agnt_fd_acpt'] ?></td></tr>
										<tr><td colspan=2 style="font-size:16px; font-weight:bold">Agent Review:</td><td colspan=4><?php echo $lunajoy_data['agent_rvw_note'] ?></td></tr>
										<tr><td colspan=2 style="font-size:16px; font-weight:bold">Management Review:</td><td colspan=4><?php echo $lunajoy_data['mgnt_rvw_note'] ?></td></tr>
										<tr><td colspan=2 style="font-size:16px; font-weight:bold">Client Review:</td><td colspan=4><?php echo $lunajoy_data['client_rvw_note'] ?></td></tr>
										
										<tr><td colspan=2  style="font-size:16px">Your Review <span style="font-size:24px;color:red">*</span></td><td colspan=4><textarea class="form-control1" style="width:100%" id="note" name="note" required></textarea></td></tr>
									<?php } ?>
									
									<?php 
									if($lunajoy_id==0){
										if(is_access_qa_module()==true || is_access_qa_operations_module()==true){ ?>
											<tr><td colspan=6><button class="btn btn-success waves-effect" type="submit" id="qaformsubmit" style="width:500px">SAVE</button></td></tr>
									<?php 
										} 
									}else{ 
										if(is_access_qa_module()==true || is_access_qa_operations_module()==true){
											if(is_available_qa_feedback($lunajoy_data['entry_date'],72) == true){ ?>
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
