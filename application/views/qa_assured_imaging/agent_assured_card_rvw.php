<style>
	.table>tbody>tr>td {
		text-align: center;
		font-size: 13px;
	}

	#theader {
		font-size: 20px;
		font-weight: bold;
		background-color: #95A5A6;
	}

	.eml {
		background-color: #85C1E9;
	}
	.eml1{
		font-size:20px;
		font-weight:bold;
		background-color:#CCD1D1;
	}
	.fatal .eml{
		background-color: red;
		color:white;
	}

	.ui-datepicker .ui-datepicker-buttonpane button.ui-datepicker-current {
	 float: left;
	 display: none;
	}
</style>
<?php // .ui-datepicker .ui-datepicker-buttonpane button.ui-datepicker-current {
	 //float: left;
	// display: none;
	//used for call_duration to disable now button.
	//} ?>

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
											<td colspan="8" id="theader" style="font-size:40px; text-align:center!important; ">Audit Card QA FORM</td>
											<input type="hidden" name="audit_start_time" value="<?php echo CurrMySqlDate(); ?>">
										</tr>
										<?php
									
											if ($assured_imaging_data['entry_by'] != '') {
												$auditorName = $assured_imaging_data['auditor_name'];
											} else {
												$auditorName = $assured_imaging_data['client_name'];
											}
										
											$auditDate = mysql2mmddyy($assured_imaging_data['audit_date']);
										 
											$clDate_val = mysqlDt2mmddyy($assured_imaging_data['call_date']);
										

										if ($rand_id != 0) {
											$agent_id = $rand_data['sid'];
											$fusion_id = $rand_data['fusion_id'];
											$agent_name = $rand_data['fname'] . " " . $rand_data['lname'];
											$tl_id = $rand_data['assigned_to'];
											$tl_name = $rand_data['tl_name'];
											$call_duration = $rand_data['call_duration'];
											
										} else {
											$agent_id = $assured_imaging_data['agent_id'];
											$fusion_id = $assured_imaging_data['fusion_id'];
											$agent_name = $assured_imaging_data['fname'] . " " . $assured_imaging_data['lname'] ;
											$tl_id = $assured_imaging_data['tl_id'];
											$tl_name = $assured_imaging_data['tl_name'];
											$call_duration = $assured_imaging_data['call_duration'];
										}
										?>
										
										<tr>
											<td>Auditor Name: <span style="font-size:24px;color:red">*</span></td>
											<td colspan="2"><input type="text" class="form-control" value="<?= $auditorName; ?>" disabled></td>
											<td>Audit Date:<span style="font-size:24px;color:red">*</span></td>
											<td><input type="text" class="form-control" value="<?= $auditDate; ?>" disabled></td>
											<td>Call Date/Time:<span style="font-size:24px;color:red">*</span></td>
											<td colspan="2">
												<input type="text" id="call_date_time" name="call_date"  onkeydown="return false;" value="<?php echo $clDate_val; ?>" max="<?php echo date("Y-m-d"); ?>" class="form-control" disabled>
											</td>
										</tr>
										<tr>
											<td>Agent Name:<span style="font-size:24px;color:red">*</span></td>
											<td colspan="2">
												<select class="form-control" id="agent_id" name="data[agent_id]" disabled>
													<option value="">-Select-</option>
													<?php foreach($agentName as $row){
														$sCss='';
														if($row['id']==$agent_id) $sCss='selected';
													?>
														<option value="<?php echo $row['id']; ?>" <?php echo $sCss; ?>><?php echo $row['name']; ?></option>
													<?php } ?>
												</select>
											</td>
											<td>Fusion ID:<span style="font-size:24px;color:red">*</span></td>
											<td><input type="text" class="form-control" id="fusion_id" required value="<?php echo $fusion_id; ?>" readonly></td>
											<td> L1 <br>Supervisor:<span style="font-size:24px;color:red">*</span></td>
											<td colspan="2">
												<input type="text" class="form-control" id="tl_name"  value="<?php echo $tl_name; ?>" readonly>
												<input type="hidden" class="form-control" id="tl_id" name="data[tl_id]" value="<?php echo $tl_id; ?>" disabled>
											</td>
										</tr>
										<tr>
											<td>Skill:<span style="font-size:24px;color:red">*</span></td>
											<td colspan="2">
												<input type="text" class="form-control" name="data[skill]" value="<?php echo $assured_imaging_data['skill'] ?>" disabled>
											</td>
											<td>PO:<span style="font-size:24px;color:red">*</span></td>
											<td><input type="text" class="form-control" name="data[po]" value="<?php echo $assured_imaging_data['po'] ?>" disabled></td>

											<td>Auditor's BP Id:<span style="font-size:24px;color:red">*</span></td>
											<td colspan="2">
												<input type="text" class="form-control" name="data[call_id]" value="<?php echo $assured_imaging_data['call_id'] ?>" disabled>
											</td>
										</tr>
										
										<tr>
											<td>Call Duration:<span style="font-size:24px;color:red">*</span></td>
											<td colspan="2"><input type="text" class="form-control" onkeydown="return false;" id="call_duration" name="data[call_duration]" value="<?php echo $call_duration; ?>" disabled></td>
											<td>VOC:<span style="font-size:24px;color:red">*</span></td>
											<td>
												<select class="form-control" id="voc" name="data[voc]" disabled>
													
													<option value="">-Select-</option>
													<option value="1"  <?= ($assured_imaging_data['voc']=="1")?"selected":"" ?>>1</option>
													<option value="2"  <?= ($assured_imaging_data['voc']=="2")?"selected":"" ?>>2</option>
													<option value="3"  <?= ($assured_imaging_data['voc']=="3")?"selected":"" ?>>3</option>
													<option value="4"  <?= ($assured_imaging_data['voc']=="4")?"selected":"" ?>>4</option>
													<option value="5"  <?= ($assured_imaging_data['voc']=="5")?"selected":"" ?>>5</option>
												</select>
											</td>
											<td>Record Id:<span style="font-size:24px;color:red">*</span></td>
											<td>
												<input type="text" class="form-control" id="" name="data[record_id]" value="<?php echo $assured_imaging_data['record_id'] ?>" disabled>
											</td>
										</tr>
										<tr>
											<td>KPI - ACPT:<span style="font-size:24px;color:red">*</span></td>
											<td colspan="2">
												<select class="form-control" id="" name="data[kpi_acpt]" disabled>
													<option value="">-Select-</option>
													<option value="Agent"  <?= ($assured_imaging_data['kpi_acpt']=="Agent")?"selected":"" ?>>Agent</option>
													<option value="Process"  <?= ($assured_imaging_data['kpi_acpt']=="Process")?"selected":"" ?>>Process</option>
													<option value="Customer"  <?= ($assured_imaging_data['kpi_acpt']=="Customer")?"selected":"" ?>>Customer</option>
													<option value="Technology"  <?= ($assured_imaging_data['kpi_acpt']=="Technology")?"selected":"" ?>>Technology</option>
													<option value="NA"  <?= ($assured_imaging_data['kpi_acpt']=="NA")?"selected":"" ?>>NA</option>
												</select>
											</td>
											<td>Audit Type:<span style="font-size:24px;color:red">*</span></td>
											<td>
												<select class="form-control" id="audit_type" name="data[audit_type]" disabled>
                                                    <option value="">-Select-</option>
                                                    <option value="CQ Audit" <?= ($assured_imaging_data['audit_type']=="CQ Audit")?"selected":"" ?>>CQ Audit</option>
                                                    <option value="BQ Audit" <?= ($assured_imaging_data['audit_type']=="BQ Audit")?"selected":"" ?>>BQ Audit</option>
                                                    <option value="Calibration" <?= ($assured_imaging_data['audit_type']=="Calibration")?"selected":"" ?>>Calibration</option>
                                                    <option value="Pre-Certificate Mock Call" <?= ($assured_imaging_data['audit_type']=="Pre-Certificate Mock Call")?"selected":"" ?>>Pre-Certificate Mock Call</option>
                                                    <option value="Certification Audit" <?= ($assured_imaging_data['audit_type']=="Certification Audit")?"selected":"" ?>>Certification Audit</option>
                                                    <option value="WoW Call"  <?= ($assured_imaging_data['audit_type']=="WoW Call")?"selected":"" ?>>WoW Call</option>
                                                    <option value="Hygiene Audit"  <?= ($assured_imaging_data['audit_type']=="Hygiene Audit")?"selected":"" ?>>Hygiene Audit</option>
                                                    <option value="Operation Audit"  <?= ($assured_imaging_data['audit_type']=="Operation Audit")?"selected":"" ?>>Operation Audit</option>
                                                    <option value="Trainer Audit"  <?= ($assured_imaging_data['audit_type']=="Trainer Audit")?"selected":"" ?>>Trainer Audit</option> 
                                                    <option value="QA Supervisor Audit"  <?= ($assured_imaging_data['audit_type']=="QA Supervisor Audit")?"selected":"" ?>>QA Supervisor Audit</option> 
                                                </select>
											</td>
											
											<td class="auType_epi">Auditor Type<span style="font-size:24px;color:red">*</span></td>
											<td class="auType_epi">
												<select class="form-control" id="auditor_type" name="data[auditor_type]">
                                                    <option value="">Select</option>
                                                    <option value="Master" <?= ($assured_imaging_data['auditor_type']=="Master")?"selected":"" ?>>Master</option>
                                                    <option value="Regular" <?= ($assured_imaging_data['auditor_type']=="Regular")?"selected":"" ?>>Regular</option>
                                                </select>
											</td>
										</tr>
										<tr>
											<td style="font-weight:bold; font-size:16px; text-align:left">Earned<br>Score</td>
											<td colspan="2"><input type="text" readonly id="assured_imaging_earned_score" name="data[earned_score]" class="form-control" value="<?php echo $assured_imaging_data['earned_score'] ?>" /></td>
											<td style="font-weight:bold; font-size:16px; text-align:left">Possible Score</td>
											<td><input type="text" readonly id="assured_imaging_possible_score" name="data[possible_score]" class="form-control" value="<?php echo $assured_imaging_data['possible_score'] ?>" /></td>
											<td style="font-weight:bold; font-size:16px; text-align:right">Overall<br>Score:</td>
											<td colspan="2"><input type="text" class="form-control" readonly id="assured_imaging_overall_score" name="data[overall_score]"  style="font-weight:bold" value="<?php echo $assured_imaging_data['overall_score'] ?>"></td>
										</tr>
										<tr class="eml" style="height:25px; font-weight:bold">
											<td>PARAMETER</td>
											<td colspan=3>SUB PARAMETER</td>
											<td>STATUS</td>
											<td>WEIGHTAGE</td>
											<td colspan=2>REMARKS</td>
										</tr>

										<tr>
											<td class="eml" rowspan=4>Greeting</td>
											<td colspan=3>Answer the call promptly and greet the caller in a professional and friendly manner,<br>identifying oneself and the company. 
											Use any script provided for partcular client/facility/event.</td>
											
											<td>
												<select class="form-control assured_imaging_point" id ="" name="data[call_promptly]" disabled>
													<option assured_imaging_val=4 assured_imaging_max="4"<?php echo $assured_imaging_data['call_promptly'] == "Excellent" ? "selected" : ""; ?> value="Excellent">Excellent</option>
													<option assured_imaging_val=4 assured_imaging_max="4" <?php echo $assured_imaging_data['call_promptly'] == "Opportunity" ? "selected" : ""; ?> value="Opportunity">Opportunity</option>
													<option assured_imaging_val=4 assured_imaging_max="4" <?php echo $assured_imaging_data['call_promptly'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											<td>4</td>
											<td colspan=2><input type="text" disabled name="data[cmt1]" class="form-control" value="<?php echo $assured_imaging_data['cmt1'] ?>"></td>
										</tr>
										<tr>
											<td colspan=3>Identifying the company (inbound/outbound).</td>
											
											<td>
												<select class="form-control assured_imaging_point" id ="" name="data[identifying_company]" disabled>
													<option assured_imaging_val=4 assured_imaging_max="4"<?php echo $assured_imaging_data['identifying_company'] == "Excellent" ? "selected" : ""; ?> value="Excellent">Excellent</option>
													<option assured_imaging_val=2 assured_imaging_max="4" <?php echo $assured_imaging_data['identifying_company'] == "Opportunity" ? "selected" : ""; ?> value="Opportunity">Opportunity</option>
													<option assured_imaging_val=4 assured_imaging_max="4" <?php echo $assured_imaging_data['identifying_company'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											<td>4</td>
											<td colspan=2><input type="text" disabled name="data[cmt2]" class="form-control" value="<?php echo $assured_imaging_data['cmt2'] ?>"></td>
										</tr>
										<tr>
											<td colspan=3>Offer Assistance (inbound willingness statement).</td>
											
											<td>
												<select class="form-control assured_imaging_point" id ="" name="data[offer_assistance]" disabled>
													<option assured_imaging_val=4 assured_imaging_max="4"<?php echo $assured_imaging_data['offer_assistance'] == "Excellent" ? "selected" : ""; ?> value="Excellent">Excellent</option>
													<option assured_imaging_val=2 assured_imaging_max="4" <?php echo $assured_imaging_data['offer_assistance'] == "Opportunity" ? "selected" : ""; ?> value="Opportunity">Opportunity</option>
													<option assured_imaging_val=4 assured_imaging_max="4" <?php echo $assured_imaging_data['offer_assistance'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											<td>4</td>
											<td colspan=2><input type="text" disabled name="data[cmt3]" class="form-control" value="<?php echo $assured_imaging_data['cmt3'] ?>"></td>
										</tr>
										<tr>
											<td colspan=3>The representative fully explained the purpose for the call. (outbound).</td>
											
											<td>
												<select class="form-control assured_imaging_point" id ="" name="data[call_purpose]" disabled>
													<option assured_imaging_val=4 assured_imaging_max="4"<?php echo $assured_imaging_data['call_purpose'] == "Excellent" ? "selected" : ""; ?> value="Excellent">Excellent</option>
													<option assured_imaging_val=2 assured_imaging_max="4" <?php echo $assured_imaging_data['call_purpose'] == "Opportunity" ? "selected" : ""; ?> value="Opportunity">Opportunity</option>
													<option assured_imaging_val=4 assured_imaging_max="4" <?php echo $assured_imaging_data['call_purpose'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											<td>4</td>
											<td colspan=2><input type="text" disabled name="data[cmt4]" class="form-control" value="<?php echo $assured_imaging_data['cmt4'] ?>"></td>
										</tr>
										<tr>
											<td class="eml" rowspan=4>Verification</td>
											<td colspan=3>Information Gathering: Ask necessary questions to collect additional information required <br>for scheduling,such as preferred dates, times, services, documents such as insurance <br> information and necessary referrals/orders.</td>
											
											<td>
												<select class="form-control assured_imaging_point" id ="" name="data[information_gathering]" disabled>
													<option assured_imaging_val=4 assured_imaging_max="4"<?php echo $assured_imaging_data['information_gathering'] == "Excellent" ? "selected" : ""; ?> value="Excellent">Excellent</option>
													<option assured_imaging_val=2 assured_imaging_max="4" <?php echo $assured_imaging_data['information_gathering'] == "Opportunity" ? "selected" : ""; ?> value="Opportunity">Opportunity</option>
													<option assured_imaging_val=4 assured_imaging_max="4" <?php echo $assured_imaging_data['information_gathering'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											<td>4</td>
											<td colspan=2><input type="text" disabled name="data[cmt5]" class="form-control" value="<?php echo $assured_imaging_data['cmt5'] ?>"></td>
										</tr>
										<tr>
											<td colspan=3>Maintain customer confidentiality and comply with data protection regulations during call<br> handling  and scheduling activities.</td>
											
											<td> 
												<select class="form-control assured_imaging_point" id ="" name="data[customer_confidentiality]" disabled>
													<option assured_imaging_val=4 assured_imaging_max="4"<?php echo $assured_imaging_data['customer_confidentiality'] == "Excellent" ? "selected" : ""; ?> value="Excellent">Excellent</option>
													<option assured_imaging_val=2 assured_imaging_max="4" <?php echo $assured_imaging_data['customer_confidentiality'] == "Opportunity" ? "selected" : ""; ?> value="Opportunity">Opportunity</option>
													<option assured_imaging_val=4 assured_imaging_max="4" <?php echo $assured_imaging_data['customer_confidentiality'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											<td>4</td>
											<td colspan=2><input type="text" disabled name="data[cmt6]" class="form-control" value="<?php echo $assured_imaging_data['cmt6'] ?>"></td>
										</tr>
										<tr>
											<td colspan=3>Adhere to call center security protocols, including password protection, restricted <br>access to customer information, and secure handling of sensitive data.</td>
											
											<td>
												<select class="form-control assured_imaging_point" id ="" name="data[security_protocols]" disabled>
													<option assured_imaging_val=4 assured_imaging_max="4"<?php echo $assured_imaging_data['security_protocols'] == "Excellent" ? "selected" : ""; ?> value="Excellent">Excellent</option>
													<option assured_imaging_val=2 assured_imaging_max="4" <?php echo $assured_imaging_data['security_protocols'] == "Opportunity" ? "selected" : ""; ?> value="Opportunity">Opportunity</option>
													<option assured_imaging_val=4 assured_imaging_max="4" <?php echo $assured_imaging_data['security_protocols'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											<td>4</td>
											<td colspan=2><input type="text" disabled name="data[cmt7]" class="form-control" value="<?php echo $assured_imaging_data['cmt7'] ?>"></td>
										</tr>
										<tr>
											<td colspan=3>Maintains accuracy, attention to detail, professionalism, and adherence to scheduling and<br> HIPAA guidelines.</td>
											
											<td>
												<select class="form-control assured_imaging_point" id ="" name="data[professionalism]" disabled>
													<option assured_imaging_val=4 assured_imaging_max="4"<?php echo $assured_imaging_data['professionalism'] == "Excellent" ? "selected" : ""; ?> value="Excellent">Excellent</option>
													<option assured_imaging_val=2 assured_imaging_max="4" <?php echo $assured_imaging_data['professionalism'] == "Opportunity" ? "selected" : ""; ?> value="Opportunity">Opportunity</option>
													<option assured_imaging_val=4 assured_imaging_max="4" <?php echo $assured_imaging_data['professionalism'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											<td>4</td>
											<td colspan=2><input type="text" disabled name="data[cmt8]" class="form-control" value="<?php echo $assured_imaging_data['cmt8'] ?>"></td>
										</tr>
										<tr>
											<td class="eml" rowspan=6>Scheduling</td>
											<td colspan=3> Availability Check: Access the scheduling system, calendar or event log to <br>check the availability of resources, staff, or equipment for the requested <br>appointment.</td>
											
											<td>
												<select class="form-control assured_imaging_point" id ="" name="data[availability_check]" disabled>
													<option assured_imaging_val=4 assured_imaging_max="4"<?php echo $assured_imaging_data['availability_check'] == "Excellent" ? "selected" : ""; ?> value="Excellent">Excellent</option>
													<option assured_imaging_val=2 assured_imaging_max="4" <?php echo $assured_imaging_data['availability_check'] == "Opportunity" ? "selected" : ""; ?> value="Opportunity">Opportunity</option>
													<option assured_imaging_val=4 assured_imaging_max="4" <?php echo $assured_imaging_data['availability_check'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											<td>4</td>
											<td colspan=2><input type="text" disabled name="data[cmt9]" class="form-control" value="<?php echo $assured_imaging_data['cmt9'] ?>"></td>
										</tr>
										<tr>
											<td colspan=3>  Appointment Scheduling: Enter the appointment details into the scheduling systems, ensuring <br>accuracy and confirming the appointment with the customer. Provide all necessary<br> documentation into patient 
											chart. </td>
											
											<td>
												<select class="form-control assured_imaging_point" id ="" name="data[appointment_scheduling]" disabled>
													<option assured_imaging_val=4 assured_imaging_max="4"<?php echo $assured_imaging_data['appointment_scheduling'] == "Excellent" ? "selected" : ""; ?> value="Excellent">Excellent</option>
													<option assured_imaging_val=2 assured_imaging_max="4" <?php echo $assured_imaging_data['appointment_scheduling'] == "Opportunity" ? "selected" : ""; ?> value="Opportunity">Opportunity</option>
													<option assured_imaging_val=4 assured_imaging_max="4" <?php echo $assured_imaging_data['appointment_scheduling'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											<td>4</td>
											<td colspan=2><input type="text" disabled name="data[cmt10]" class="form-control" value="<?php echo $assured_imaging_data['cmt10'] ?>"></td>
										</tr>
										<tr>
											<td colspan=3>Insurance information: selected correct insurance, adding policy and group number. Added <br>correct relationship. </td>
											
											<td>
												<select class="form-control assured_imaging_point" id ="" name="data[insurance_information]" disabled>
													<option assured_imaging_val=4 assured_imaging_max="4"<?php echo $assured_imaging_data['insurance_information'] == "Excellent" ? "selected" : ""; ?> value="Excellent">Excellent</option>
													<option assured_imaging_val=2 assured_imaging_max="4" <?php echo $assured_imaging_data['insurance_information'] == "Opportunity" ? "selected" : ""; ?> value="Opportunity">Opportunity</option>
													<option assured_imaging_val=4 assured_imaging_max="4" <?php echo $assured_imaging_data['insurance_information'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											<td>4</td>
											<td colspan=2><input type="text" disabled name="data[cmt25]" class="form-control" value="<?php echo $assured_imaging_data['cmt25'] ?>"></td>
										</tr>
										<tr>
											<td colspan=3>  Confirmation: Provide the customer with appointment details, including date, time, location,<br> and any additional instructions or requirements.</td>
											
											<td>
												<select class="form-control assured_imaging_point" id ="" name="data[confirmation]" disabled>
													<option assured_imaging_val=4 assured_imaging_max="4"<?php echo $assured_imaging_data['confirmation'] == "Excellent" ? "selected" : ""; ?> value="Excellent">Excellent</option>
													<option assured_imaging_val=2 assured_imaging_max="4" <?php echo $assured_imaging_data['confirmation'] == "Opportunity" ? "selected" : ""; ?> value="Opportunity">Opportunity</option>
													<option assured_imaging_val=4 assured_imaging_max="4" <?php echo $assured_imaging_data['confirmation'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											<td>4</td>
											<td colspan=2><input type="text" disabled name="data[cmt11]" class="form-control" value="<?php echo $assured_imaging_data['cmt11'] ?>"></td>
										</tr>
										<tr>
											<td colspan=3>Rescheduling: Follow the established procedure for rescheduling appointments,accommodating <br> customer requests while considering availability and minimizing disruption. Document any and all changes made and why.</td>
											
											<td>
												<select class="form-control assured_imaging_point" id ="" name="data[rescheduling]" disabled>
													<option assured_imaging_val=4 assured_imaging_max="4"<?php echo $assured_imaging_data['rescheduling'] == "Excellent" ? "selected" : ""; ?> value="Excellent">Excellent</option>
													<option assured_imaging_val=2 assured_imaging_max="4" <?php echo $assured_imaging_data['rescheduling'] == "Opportunity" ? "selected" : ""; ?> value="Opportunity">Opportunity</option>
													<option assured_imaging_val=4 assured_imaging_max="4" <?php echo $assured_imaging_data['rescheduling'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											<td>4</td>
											<td colspan=2><input type="text" disabled name="data[cmt12]" class="form-control" value="<?php echo $assured_imaging_data['cmt12'] ?>"></td>
										</tr>
										<tr>
											<td colspan=3> Cancellations: Follow the established procedure for canceling appointments, updating the<br> scheduling system, and notifying the relevant parties. Document any and all changes<br> made and why. </td>
											
											<td>
												<select class="form-control assured_imaging_point" id ="" name="data[cancellations]" disabled>
													<option assured_imaging_val=4 assured_imaging_max="4"<?php echo $assured_imaging_data['cancellations'] == "Excellent" ? "selected" : ""; ?> value="Excellent">Excellent</option>
													<option assured_imaging_val=2 assured_imaging_max="4" <?php echo $assured_imaging_data['cancellations'] == "Opportunity" ? "selected" : ""; ?> value="Opportunity">Opportunity</option>
													<option assured_imaging_val=4 assured_imaging_max="4" <?php echo $assured_imaging_data['cancellations'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											<td>4</td>
											<td colspan=2><input type="text" disabled name="data[cmt13]" class="form-control" value="<?php echo $assured_imaging_data['cmt13'] ?>"></td>
										</tr>
										<tr>
											<td class="eml" rowspan=2>Telephony</td>
											<td colspan=3> Correctly utilized phone system with little to no delay in communication. </td>
											
											<td>
												<select class="form-control assured_imaging_point" id ="" name="data[utilized_phone]" disabled>
													<option assured_imaging_val=4 assured_imaging_max="4"<?php echo $assured_imaging_data['utilized_phone'] == "Excellent" ? "selected" : ""; ?> value="Excellent">Excellent</option>
													<option assured_imaging_val=2 assured_imaging_max="4" <?php echo $assured_imaging_data['utilized_phone'] == "Opportunity" ? "selected" : ""; ?> value="Opportunity">Opportunity</option>
													<option assured_imaging_val=4 assured_imaging_max="4" <?php echo $assured_imaging_data['utilized_phone'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											<td>4</td>
											<td colspan=2><input type="text" disabled name="data[cmt14]" class="form-control" value="<?php echo $assured_imaging_data['cmt14'] ?>"></td>
										</tr>
										<tr>
											<td colspan=3> Used correct procedure for transferring to staff extension or department when/<br>if necessary. </td>
											
											<td>
												<select class="form-control assured_imaging_point" id ="" name="data[correct_procedure]" disabled>
													<option assured_imaging_val=4 assured_imaging_max="4"<?php echo $assured_imaging_data['correct_procedure'] == "Excellent" ? "selected" : ""; ?> value="Excellent">Excellent</option>
													<option assured_imaging_val=2 assured_imaging_max="4" <?php echo $assured_imaging_data['correct_procedure'] == "Opportunity" ? "selected" : ""; ?> value="Opportunity">Opportunity</option>
													<option assured_imaging_val=4 assured_imaging_max="4" <?php echo $assured_imaging_data['correct_procedure'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											<td>4</td>
											<td colspan=2><input type="text" disabled name="data[cmt15]" class="form-control" value="<?php echo $assured_imaging_data['cmt15'] ?>"></td>
										</tr>
										<tr>
											<td class="eml" rowspan=5>Soft Skills</td>
											<td colspan=3>Avoided long silences during the call Active Listening: Listen attentively to<br> the customer's appointment request, capturing all relevant details 
											accurately.  </td>
											
											<td>
												<select class="form-control assured_imaging_point" id ="" name="data[active_listening]" disabled>
													<option assured_imaging_val=4 assured_imaging_max="4"<?php echo $assured_imaging_data['active_listening'] == "Excellent" ? "selected" : ""; ?> value="Excellent">Excellent</option>
													<option assured_imaging_val=2 assured_imaging_max="4" <?php echo $assured_imaging_data['active_listening'] == "Opportunity" ? "selected" : ""; ?> value="Opportunity">Opportunity</option>
													<option assured_imaging_val=4 assured_imaging_max="4" <?php echo $assured_imaging_data['active_listening'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											<td>4</td>
											<td colspan=2><input type="text" disabled name="data[cmt16]" class="form-control" value="<?php echo $assured_imaging_data['cmt16'] ?>"></td>
										</tr>
										<tr>
											<td colspan=3>Did not interrupt the caller.</td>
											
											<td>
												<select class="form-control assured_imaging_point" id ="" name="data[interrupt_caller]" disabled>
													<option assured_imaging_val=4 assured_imaging_max="4"<?php echo $assured_imaging_data['interrupt_caller'] == "Excellent" ? "selected" : ""; ?> value="Excellent">Excellent</option>
													<option assured_imaging_val=2 assured_imaging_max="4" <?php echo $assured_imaging_data['interrupt_caller'] == "Opportunity" ? "selected" : ""; ?> value="Opportunity">Opportunity</option>
													<option assured_imaging_val=4 assured_imaging_max="4" <?php echo $assured_imaging_data['interrupt_caller'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											<td>4</td>
											<td colspan=2><input type="text" disabled name="data[cmt17]" class="form-control" value="<?php echo $assured_imaging_data['cmt17'] ?>"></td>
										</tr>
										<tr>
											<td colspan=3>Was  polite, friendly, and professional.</td>
											
											<td>
												<select class="form-control assured_imaging_point" id ="" name="data[polite]" disabled>
													<option assured_imaging_val=4 assured_imaging_max="4"<?php echo $assured_imaging_data['polite'] == "Excellent" ? "selected" : ""; ?> value="Excellent">Excellent</option>
													<option assured_imaging_val=2 assured_imaging_max="4" <?php echo $assured_imaging_data['polite'] == "Opportunity" ? "selected" : ""; ?> value="Opportunity">Opportunity</option>
													<option assured_imaging_val=4 assured_imaging_max="4" <?php echo $assured_imaging_data['polite'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											<td>4</td>
											<td colspan=2><input type="text" disabled name="data[cmt18]" class="form-control" value="<?php echo $assured_imaging_data['cmt18'] ?>"></td>
										</tr>
										<tr>
											<td colspan=3>Call was kept to the point and utilized time efficiently.</td>
											
											<td>
												<select class="form-control assured_imaging_point" id ="" name="data[utilized_time_efficiently]" disabled>
													<option assured_imaging_val=4 assured_imaging_max="4"<?php echo $assured_imaging_data['utilized_time_efficiently'] == "Excellent" ? "selected" : ""; ?> value="Excellent">Excellent</option>
													<option assured_imaging_val=2 assured_imaging_max="4" <?php echo $assured_imaging_data['utilized_time_efficiently'] == "Opportunity" ? "selected" : ""; ?> value="Opportunity">Opportunity</option>
													<option assured_imaging_val=4 assured_imaging_max="4" <?php echo $assured_imaging_data['utilized_time_efficiently'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											<td>4</td>
											<td colspan=2><input type="text" disabled name="data[cmt19]" class="form-control" value="<?php echo $assured_imaging_data['cmt19'] ?>"></td>
										</tr>
										<tr>
											<td colspan=3>Conveyed appropriate empathy, when necessary, while maintaining control of the call.</td>
											
											<td>
												<select class="form-control assured_imaging_point" id ="" name="data[appropriate_empathy]" disabled>
													<option assured_imaging_val=4 assured_imaging_max="4"<?php echo $assured_imaging_data['appropriate_empathy'] == "Excellent" ? "selected" : ""; ?> value="Excellent">Excellent</option>
													<option assured_imaging_val=2 assured_imaging_max="4" <?php echo $assured_imaging_data['appropriate_empathy'] == "Opportunity" ? "selected" : ""; ?> value="Opportunity">Opportunity</option>
													<option assured_imaging_val=4 assured_imaging_max="4" <?php echo $assured_imaging_data['appropriate_empathy'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											<td>4</td>
											<td colspan=2><input type="text" disabled name="data[cmt20]" class="form-control" value="<?php echo $assured_imaging_data['cmt20'] ?>"></td>
										</tr>
										<tr>
											<td class="eml" rowspan=4>End Call</td>
											<td colspan=3>Offered further assistance.</td>
											
											<td>
												<select class="form-control assured_imaging_point" id ="" name="data[further_assistance]" disabled>
													<option assured_imaging_val=4 assured_imaging_max="4"<?php echo $assured_imaging_data['further_assistance'] == "Excellent" ? "selected" : ""; ?> value="Excellent">Excellent</option>
													<option assured_imaging_val=2 assured_imaging_max="4" <?php echo $assured_imaging_data['further_assistance'] == "Opportunity" ? "selected" : ""; ?> value="Opportunity">Opportunity</option>
													<option assured_imaging_val=4 assured_imaging_max="4" <?php echo $assured_imaging_data['further_assistance'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											<td>4</td>
											<td colspan=2><input type="text" disabled name="data[cmt21]" class="form-control" value="<?php echo $assured_imaging_data['cmt21'] ?>"></td>
										</tr>
										<tr>
											<td colspan=3>Call ended on a positive note with a summary/verification of<br> actions and date of appointment(s).</td>
											
											<td>
												<select class="form-control assured_imaging_point" id ="" name="data[positive_note]" disabled>
													<option assured_imaging_val=4 assured_imaging_max="4"<?php echo $assured_imaging_data['positive_note'] == "Excellent" ? "selected" : ""; ?> value="Excellent">Excellent</option>
													<option assured_imaging_val=2 assured_imaging_max="4" <?php echo $assured_imaging_data['positive_note'] == "Opportunity" ? "selected" : ""; ?> value="Opportunity">Opportunity</option>
													<option assured_imaging_val=4 assured_imaging_max="4" <?php echo $assured_imaging_data['positive_note'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											<td>4</td>
											<td colspan=2><input type="text" disabled name="data[cmt22]" class="form-control" value="<?php echo $assured_imaging_data['cmt22'] ?>"></td>
										</tr>
										<tr>
											<td colspan=3>Utilizing correct disposition and documented throroughly .</td>
											
											<td>
												<select class="form-control assured_imaging_point" id ="" name="data[correct_disposition]" disabled>
													<option assured_imaging_val=4 assured_imaging_max="4"<?php echo $assured_imaging_data['correct_disposition'] == "Excellent" ? "selected" : ""; ?> value="Excellent">Excellent</option>
													<option assured_imaging_val=2 assured_imaging_max="4" <?php echo $assured_imaging_data['correct_disposition'] == "Opportunity" ? "selected" : ""; ?> value="Opportunity">Opportunity</option>
													<option assured_imaging_val=4 assured_imaging_max="4" <?php echo $assured_imaging_data['correct_disposition'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											<td>4</td>
											<td colspan=2><input type="text" disabled name="data[cmt23]" class="form-control" value="<?php echo $assured_imaging_data['cmt23'] ?>"></td>
										</tr>
										<tr>
											<td colspan=3>Thanked the caller for his/her time and branded the call.</td>
											
											<td>
												<select class="form-control assured_imaging_point" id ="" name="data[branded_call]" disabled>
													<option assured_imaging_val=4 assured_imaging_max="4"<?php echo $assured_imaging_data['branded_call'] == "Excellent" ? "selected" : ""; ?> value="Excellent">Excellent</option>
													<option assured_imaging_val=2 assured_imaging_max="4" <?php echo $assured_imaging_data['branded_call'] == "Opportunity" ? "selected" : ""; ?> value="Opportunity">Opportunity</option>
													<option assured_imaging_val=4 assured_imaging_max="4" <?php echo $assured_imaging_data['branded_call'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											<td>4</td>
											<td colspan=2><input type="text" disabled name="data[cmt24]" class="form-control" value="<?php echo $assured_imaging_data['cmt24'] ?>"></td>
										</tr>
										<tr>
											<td>Call Summary:</td>
											<td colspan=3><textarea class="form-control" disabled name="data[call_summary]"><?php echo $assured_imaging_data['call_summary'] ?></textarea></td>
											<td>Feedback:</td>
											<td colspan=4><textarea class="form-control" disabled name="data[feedback]"><?php echo $assured_imaging_data['feedback'] ?></textarea></td>
										</tr>
										<?php if($assured_imaging_data['attach_file']!=''){ ?>
									<tr oncontextmenu="return false;">
										<td colspan="2">Audio Files (Mp4/Mp3/M4a/Wav)</td>
										<td colspan="4">
											<?php $attach_file = explode(",",$assured_imaging_data['attach_file']);
											 foreach($attach_file as $af){ ?>
												<audio oncontextmenu="return false;" controls controlslist="nodownload" style="background-color:#607F93">
													  <source src="<?php echo base_url(); ?>qa_files/assured_imaging/<?php echo $af; ?>" type="audio/ogg">
													  <source src="<?php echo base_url(); ?>qa_files/assured_imaging/<?php echo $af; ?>" type="audio/mpeg">
												</audio> </br>
											 <?php } ?>
										</td>
									</tr>
									<?php } ?>

									<tr>
										<td style="font-size:12px">Manager Review:</td>
										<td colspan="8" style="text-align:left"><?php echo $assured_imaging_data['mgnt_rvw_note'] ?></td>
									</tr>
									<tr>
										<td style="font-size:12px">Client Review:</td>
										<td colspan="8" style="text-align:left"><?php echo $assured_imaging_data['client_rvw_note'] ?></td>
									</tr>

									<tr><td colspan="10" style="background-color:#C5C8C8"></td></tr>
									
									 <form id="form_agent_user" method="POST" action="">
										<input type="hidden" name="assured_imaging_id" class="form-control" value="<?php echo $assured_imaging_id; ?>">
										
										<tr>
											<td colspan=2 style="font-size:16px">Feedback Acceptance<span style="font-size:24px;color:red">*</span></td>
											<td colspan=6>
												<select class="form-control" id="" name="agnt_fd_acpt" required="">
													<option value="">--Select--</option>
													<option <?php echo $assured_imaging_data['agnt_fd_acpt']=='Acceptance'?"selected":""; ?> value="Acceptance">Acceptance</option>	
													<option <?php echo $assured_imaging_data['agnt_fd_acpt']=='Not Acceptance'?"selected":""; ?> value="Not Acceptance">Not Acceptance</option>	
												</select>
											</td>
										</tr>
										<tr>
											<td colspan=2 style="font-size:16px">Your Review<span style="font-size:24px;color:red">*</span></td>
											<td colspan=6><textarea class="form-control" name="note" required><?php echo $assured_imaging_data['agent_rvw_note'] ?></textarea></td>
										</tr>
										
										<?php if(is_access_qa_agent_module()==true){
										if(is_available_qa_feedback($assured_imaging_data['entry_date'],72) == true){ ?>
											<tr>
												<?php if($assured_imaging_data['agent_rvw_note']==''){ ?>
													<td colspan="10"><button class="btn btn-success waves-effect" type="submit" id='btnagentSave' name='btnSave' value="SAVE" style="width:500px;margin:auto;display:block;">SAVE</button></td>
												<?php } ?>
											</tr>
										<?php } 
										} ?>
									
									  </form>

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