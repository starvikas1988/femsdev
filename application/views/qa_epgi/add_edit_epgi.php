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
	.fatal .eml{
		background-color: red;
		color:white;
	}
	.ui-datepicker .ui-datepicker-buttonpane button.ui-datepicker-current {
	 float: left;
	 display: none;
	}
</style>

<?php if ($epgi_id!= 0) {
	if (is_access_qa_edit_feedback() == false) { ?>
		<style>
			.form-control {
				pointer-events: none;
				background-color: #D5DBDB;
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
											<td colspan="8" id="theader" style="font-size:40px">EPGI</td>
											<input type="hidden" name="audit_start_time" value="<?php echo CurrMySqlDate(); ?>">
										</tr>
										<?php
										if ($epgi_id == 0) {
											$auditorName = get_username();
											//$auditDate = CurrDateMDY();
											$auditDate =  CurrDateTimeMDY();
											$clDate_val = '';
										} else {
											if ($epgi_data['entry_by'] != '') {
												$auditorName = $epgi_data['auditor_name'];
											} else {
												$auditorName = $epgi_data['client_name'];
											}
											$clDate_val = mysql2mmddyySls($epgi_data['call_date']);
										}
										?>
										<tr>
											<td>Auditor Name:</td>
											<td><input type="text" class="form-control" value="<?= $auditorName; ?>" disabled></td>
											<td>Audit Date:</td>
											<td colspan="2"><input type="text" class="form-control" value="<?= CurrDateTimeMDY() ?>" disabled></td>
											<td>Transaction Date:<span style="font-size:24px;color:red">*</span></td>
											<td>
												<input type="text" id="call_date" name="call_date"  onkeydown="return false;" value="<?php echo $clDate_val; ?>" max="<?php echo date("Y-m-d"); ?>" class="form-control" required>
											</td>
										</tr>
										<tr>
											<td>Agent Name:<span style="font-size:24px;color:red">*</span></td>
											<td>
												<select class="form-control" id="agent_id" name="data[agent_id]" required>
													<?php 
													if($epgi_data['agent_id']!=''){
														?>
														<option value="<?php echo $epgi_data['agent_id'] ?>"><?php echo $epgi_data['fname'] . " " . $epgi_data['lname'] ?></option>
														<?php
													}else{
														?>
														<option value="">Select</option>
														<?php
													}
													?>
													
													<?php foreach ($agentName as $row) :  ?>
														<option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
													<?php endforeach; ?>
												</select>
											</td>
											<td>Employee ID:</td>
											<td colspan="2"><input type="text" class="form-control" id="fusion_id" required value="<?php echo $epgi_data['fusion_id'] ?>" readonly></td>
											<td> TL Name:<span style="font-size:24px;color:red">*</span></td>
											<td>
												<input type="text" class="form-control" id="tl_name" required value="<?php echo $epgi_data['tl_name'] ?>" readonly>
												<input type="hidden" class="form-control" id="tl_id" name="data[tl_id]" value="<?php echo $epgi_data['tl_id'] ?>" required>
											</td>
										</tr>
										<tr>
											<td>Call Id:<span style="font-size:24px;color:red">*</span></td>
											<td>
												<input type="text" id="call_id" name="data[call_id]"  value="<?php echo $epgi_data['call_id']; ?>" class="form-control" required>
											</td>
											<td>AHT:<span style="font-size:24px;color:red">*</span></td>
											<td colspan="2"><input type="text" class="form-control" onkeydown="return false;" id="call_duration" name="data[call_duration]" value="<?php echo $epgi_data['call_duration']?>" required></td>
											<td>Call Type:<span style="font-size:24px;color:red">*</span></td>
											<td>
												<select class="form-control" name="data[call_type]" required>
													<option value="">-Select-</option>
													<option value="Inbound" <?= ($epgi_data['call_type']=="Inbound")?"selected":""?>>Inbound</option>
													<option value="Outbound" <?= ($epgi_data['call_type']=="Outbound")?"selected":""?>>Outbound</option>
												</select>
											</td>
										</tr>
										<tr>
											<td>ACPT<span style="font-size:24px;color:red">*</span></td>
											<td>
												<select class="form-control" name="data[acpt]" required>
													<option value="">-Select-</option>
                                                    <option value="Agent"  <?= ($epgi_data['acpt']=="Agent")?"selected":"" ?>>Agent</option>
                                                    <option value="Process"  <?= ($epgi_data['acpt']=="Process")?"selected":"" ?>>Process</option>
                                                    <option value="Customer"  <?= ($epgi_data['acpt']=="Customer")?"selected":"" ?>>Customer</option>
                                                    <option value="Technology"  <?= ($epgi_data['acpt']=="Technology")?"selected":"" ?>>Technology</option>
                                                </select>
											</td>
											<td>VOC:<span style="font-size:24px;color:red">*</span></td>
											<td colspan="2">
												<select class="form-control" id="voc" name="data[voc]" required>
													
													<option value="">-Select-</option>
													<option value="1"  <?= ($epgi_data['voc']=="1")?"selected":"" ?>>1</option>
													<option value="2"  <?= ($epgi_data['voc']=="2")?"selected":"" ?>>2</option>
													<option value="3"  <?= ($epgi_data['voc']=="3")?"selected":"" ?>>3</option>
													<option value="4"  <?= ($epgi_data['voc']=="4")?"selected":"" ?>>4</option>
													<option value="5"  <?= ($epgi_data['voc']=="5")?"selected":"" ?>>5</option>
													<option value="6"  <?= ($epgi_data['voc']=="6")?"selected":"" ?>>6</option>
													<option value="7"  <?= ($epgi_data['voc']=="7")?"selected":"" ?>>7</option>
													<option value="8"  <?= ($epgi_data['voc']=="8")?"selected":"" ?>>8</option>
													<option value="9"  <?= ($epgi_data['voc']=="9")?"selected":"" ?>>9</option>
													<option value="10"  <?= ($epgi_data['voc']=="10")?"selected":"" ?>>10</option>
												</select>
											</td>
											<td>Audit Type:<span style="font-size:24px;color:red">*</span></td>
											<td>
												<select class="form-control" id="audit_type" name="data[audit_type]" required>
                                                    <option value="">-Select-</option>
                                                    <option value="CQ Audit" <?= ($epgi_data['audit_type']=="CQ Audit")?"selected":"" ?>>CQ Audit</option>
                                                    <option value="BQ Audit" <?= ($epgi_data['audit_type']=="BQ Audit")?"selected":"" ?>>BQ Audit</option>
                                                    <option value="Calibration" <?= ($epgi_data['audit_type']=="Calibration")?"selected":"" ?>>Calibration</option>
                                                    <option value="Pre-Certificate Mock Call" <?= ($epgi_data['audit_type']=="Pre-Certificate Mock Call")?"selected":"" ?>>Pre-Certificate Mock Call</option>
                                                    <option value="Certification Audit" <?= ($epgi_data['audit_type']=="Certification Audit")?"selected":"" ?>>Certification Audit</option>
                                                    <option value="Operation Audit" <?= ($epgi_data['audit_type']=="Operation Audit")?"selected":"" ?>>Operation Audit</option>
                                                    <option value="Trainer Audit"  <?= ($epgi_data['audit_type']=="Trainer Audit")?"selected":"" ?>>Trainer Audit</option>
                                                </select>
											</td>
										</tr>
										<tr>
											<td class="auType">Auditor Type<span style="font-size:24px;color:red">*</span></td>
											<td class="auType">
												<select class="form-control" id="auditor_type" name="data[auditor_type]">
                                                    
                                                    <option value="Master" <?= ($epgi_data['auditor_type']=="Master")?"selected":"" ?>>Master</option>
                                                    <option value="Regular" <?= ($epgi_data['auditor_type']=="Regular")?"selected":"" ?>>Regular</option>
                                                </select>
											</td>
											<td>Site:<span style="font-size:24px;color:red">*</span></td>
											<td><input type="text" class="form-control" id="site" name="data[site]" value="<?php echo $epgi_data['site'] ?>" readonly></td>
											
										</tr>
										
										<tr>
											<td style="font-weight:bold; font-size:16px; text-align:left">Earned Score</td>
											<td><input type="text" readonly id="epgi_earned_score" name="data[earned_score]" class="form-control" value="<?php echo $epgi_data['earned_score'] ?>" /></td>
											<td style="font-weight:bold; font-size:16px; text-align:left">Possible Score</td>
											<td><input type="text" readonly id="epgi_possible_score" name="data[possible_score]" class="form-control" value="<?php echo $epgi_data['possible_score'] ?>" /></td>
											<td style="font-weight:bold; font-size:16px; text-align:right">Overall Score:</td>
											<td><input type="text" readonly id="epgi_overall_score" name="data[overall_score]" class="form-control" style="font-weight:bold" value="<?php echo $epgi_data['overall_score'] ?>"></td>
										</tr>
										<tr class="eml" style="height:25px; font-weight:bold">
											<td>Critical Accuracy</td>
											<td>PARAMETER</td>
											<td colspan=2>SUB PARAMETER</td>
											<td>Weightage</td>
											<td>STATUS</td>
											<td colspan=2>REMARKS</td>
										</tr>

										<tr>
											<td class="eml" rowspan=6 style="font-weight:bold; background-color:#d6bf91">Business Critical</td>
											<td class="eml" rowspan=4>Greeting</td>
											<td colspan=2>The appropriate greeting was used (inbound/outbound)</td>
											<td>2</td>
											<td>
												<select class="form-control epgi_point business" name="data[appropriate_greeting]" required>
													
													<option epgi_val=2 <?php echo $epgi_data['appropriate_greeting'] == "Excellent" ? "selected" : ""; ?> value="Excellent">Excellent</option>
													<option epgi_val=1 <?php echo $epgi_data['appropriate_greeting'] == "Opportunity" ? "selected" : ""; ?> value="Opportunity">Opportunity</option>
													<option epgi_val=0 <?php echo $epgi_data['appropriate_greeting'] == "Unsatisfactory" ? "selected" : ""; ?> value="Unsatisfactory">Unsatisfactory</option>
													<option epgi_val=2 <?php echo $epgi_data['appropriate_greeting'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											
											<td colspan=2><input type="text" name="data[cmt1]" class="form-control" value="<?php echo $epgi_data['cmt1'] ?>"></td>
										</tr>
										<tr>
											<td colspan=2>Identifying the company (inbound/outbound)</td>
											<td>2</td>
											<td>
												<select class="form-control epgi_point business" name="data[Identify_company]" required>
													
													<option epgi_val=2 <?php echo $epgi_data['Identify_company'] == "Excellent" ? "selected" : ""; ?> value="Excellent">Excellent</option>
													<option epgi_val=1 <?php echo $epgi_data['Identify_company'] == "Opportunity" ? "selected" : ""; ?> value="Opportunity">Opportunity</option>
													<option epgi_val=0 <?php echo $epgi_data['Identify_company'] == "Unsatisfactory" ? "selected" : ""; ?> value="Unsatisfactory">Unsatisfactory</option>
													<option epgi_val=2 <?php echo $epgi_data['Identify_company'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
										
											<td colspan=2><input type="text" name="data[cmt2]" class="form-control" value="<?php echo $epgi_data['cmt2'] ?>"></td>
										</tr>

										<tr>
											<td colspan=2>Offer Assistance (inbound willingness statement)</td>
											<td>2</td>
											<td>
												<select class="form-control epgi_point business" name="data[offer_assistance]" required>
													
													<option epgi_val=2 <?php echo $epgi_data['offer_assistance'] == "Excellent" ? "selected" : ""; ?> value="Excellent">Excellent</option>
													<option epgi_val=1 <?php echo $epgi_data['offer_assistance'] == "Opportunity" ? "selected" : ""; ?> value="Opportunity">Opportunity</option>
													<option epgi_val=0 <?php echo $epgi_data['offer_assistance'] == "Unsatisfactory" ? "selected" : ""; ?> value="Unsatisfactory">Unsatisfactory</option>
													<option epgi_val=2 <?php echo $epgi_data['offer_assistance'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
										
											<td colspan=2><input type="text" name="data[cmt3]" class="form-control" value="<?php echo $epgi_data['cmt3'] ?>"></td>
										</tr>

										<tr>
											<td colspan=2>The representative fully explained the purpose for the call. (outbound)</td>
											<td>2</td>
											<td>
												<select class="form-control epgi_point business" name="data[purpose_for_call]" required>
													
													<option epgi_val=2 <?php echo $epgi_data['purpose_for_call'] == "Excellent" ? "selected" : ""; ?> value="Excellent">Excellent</option>
													<option epgi_val=1 <?php echo $epgi_data['purpose_for_call'] == "Opportunity" ? "selected" : ""; ?> value="Opportunity">Opportunity</option>
													<option epgi_val=0 <?php echo $epgi_data['purpose_for_call'] == "Unsatisfactory" ? "selected" : ""; ?> value="Unsatisfactory">Unsatisfactory</option>
													<option epgi_val=2 <?php echo $epgi_data['purpose_for_call'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
										
											<td colspan=2><input type="text" name="data[cmt4]" class="form-control" value="<?php echo $epgi_data['cmt4'] ?>"></td>
										</tr>

										<tr>
											<td class="eml" rowspan=2>Verification</td>
											<td colspan="2">Correctly verified & entered patient demographics (existing and new patients)</td>
											<td>5</td>
											<td>
												<select class="form-control epgi_point business" name="data[patient_demographics]" required>
													
													<option epgi_val=5 <?php echo $epgi_data['patient_demographics'] == "Excellent" ? "selected" : ""; ?> value="Excellent">Excellent</option>
													<option epgi_val=3 <?php echo $epgi_data['patient_demographics'] == "Opportunity" ? "selected" : ""; ?> value="Opportunity">Opportunity</option>
													<option epgi_val=0 <?php echo $epgi_data['patient_demographics'] == "Unsatisfactory" ? "selected" : ""; ?> value="Unsatisfactory">Unsatisfactory</option>
													<option epgi_val=5 <?php echo $epgi_data['patient_demographics'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
										
											<td colspan=2><input type="text" name="data[cmt5]" class="form-control" value="<?php echo $epgi_data['cmt5'] ?>"></td>
										</tr>

										<tr>
											<td colspan="2">Verified insurance is Accepted at EPGI/Offices</td>
											<td>5</td>
											<td>
												<select class="form-control epgi_point business" name="data[verified_insurance]" required>
													
													<option epgi_val=5 <?php echo $epgi_data['verified_insurance'] == "Excellent" ? "selected" : ""; ?> value="Excellent">Excellent</option>
													<option epgi_val=3 <?php echo $epgi_data['verified_insurance'] == "Opportunity" ? "selected" : ""; ?> value="Opportunity">Opportunity</option>
													<option epgi_val=0 <?php echo $epgi_data['verified_insurance'] == "Unsatisfactory" ? "selected" : ""; ?> value="Unsatisfactory">Unsatisfactory</option>
													<option epgi_val=5 <?php echo $epgi_data['verified_insurance'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
										
											<td colspan=2><input type="text" name="data[cmt6]" class="form-control" value="<?php echo $epgi_data['cmt6'] ?>"></td>
										</tr>

										<tr>
											<td class="eml" rowspan=6 style="font-weight:bold; background-color:#D7BDE2">Compliance Critical</td>
											<td class="eml" rowspan=6>Scheduling</td>
											<td colspan="2">Correctly entered patient's information </td>
											<td>7</td>
											<td>
												<select class="form-control epgi_point compliance" name="data[patients_information]" required>
													<option epgi_val=7 <?php echo $epgi_data['patients_information'] == "Excellent" ? "selected" : ""; ?> value="Excellent">Excellent</option>
													<option epgi_val=3 <?php echo $epgi_data['patients_information'] == "Opportunity" ? "selected" : ""; ?> value="Opportunity">Opportunity</option>
													<option epgi_val=0 <?php echo $epgi_data['patients_information'] == "Unsatisfactory" ? "selected" : ""; ?> value="Unsatisfactory">Unsatisfactory</option>
													<option epgi_val=7 <?php echo $epgi_data['patients_information'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt7]" class="form-control" value="<?php echo $epgi_data['cmt7'] ?>"></td>
										</tr>

										<tr>
											<td colspan="2">Correctly scheduled office visit</td>
											<td>7</td>
											<td>
												<select class="form-control epgi_point compliance" name="data[office_visit]" required>
													<option epgi_val=7 <?php echo $epgi_data['office_visit'] == "Excellent" ? "selected" : ""; ?> value="Excellent">Excellent</option>
													<option epgi_val=3 <?php echo $epgi_data['office_visit'] == "Opportunity" ? "selected" : ""; ?> value="Opportunity">Opportunity</option>
													<option epgi_val=0 <?php echo $epgi_data['office_visit'] == "Unsatisfactory" ? "selected" : ""; ?> value="Unsatisfactory">Unsatisfactory</option>
													<option epgi_val=7 <?php echo $epgi_data['office_visit'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt8]" class="form-control" value="<?php echo $epgi_data['cmt8'] ?>"></td>
										</tr>

										<tr>
											<td colspan="2">Correctly scheduled telehealth visit</td>
											<td>7</td>
											<td>
												<select class="form-control epgi_point compliance" name="data[scheduled_telehealth_visit]" required>
													<option epgi_val=7 <?php echo $epgi_data['scheduled_telehealth_visit'] == "Excellent" ? "selected" : ""; ?> value="Excellent">Excellent</option>
													<option epgi_val=3 <?php echo $epgi_data['scheduled_telehealth_visit'] == "Opportunity" ? "selected" : ""; ?> value="Opportunity">Opportunity</option>
													<option epgi_val=0 <?php echo $epgi_data['scheduled_telehealth_visit'] == "Unsatisfactory" ? "selected" : ""; ?> value="Unsatisfactory">Unsatisfactory</option>
													<option epgi_val=7 <?php echo $epgi_data['scheduled_telehealth_visit'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt9]" class="form-control" value="<?php echo $epgi_data['cmt9'] ?>"></td>
										</tr>

										<tr>
											<td colspan="2">Correctly scheduled hospital follow-up</td>
											<td>7</td>
											<td>
												<select class="form-control epgi_point compliance" name="data[hospital_follow_up]" required>
													<option epgi_val=7 <?php echo $epgi_data['hospital_follow_up'] == "Excellent" ? "selected" : ""; ?> value="Excellent">Excellent</option>
													<option epgi_val=3 <?php echo $epgi_data['hospital_follow_up'] == "Opportunity" ? "selected" : ""; ?> value="Opportunity">Opportunity</option>
													<option epgi_val=0 <?php echo $epgi_data['hospital_follow_up'] == "Unsatisfactory" ? "selected" : ""; ?> value="Unsatisfactory">Unsatisfactory</option>
													<option epgi_val=7 <?php echo $epgi_data['hospital_follow_up'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt10]" class="form-control" value="<?php echo $epgi_data['cmt10'] ?>"></td>
										</tr>

										<tr>
											<td colspan="2">Correctly sent patient messaging/pods</td>
											<td>7</td>
											<td>
												<select class="form-control epgi_point compliance" name="data[patient_pods]" required>
													<option epgi_val=7 <?php echo $epgi_data['patient_pods'] == "Excellent" ? "selected" : ""; ?> value="Excellent">Excellent</option>
													<option epgi_val=3 <?php echo $epgi_data['patient_pods'] == "Opportunity" ? "selected" : ""; ?> value="Opportunity">Opportunity</option>
													<option epgi_val=0 <?php echo $epgi_data['patient_pods'] == "Unsatisfactory" ? "selected" : ""; ?> value="Unsatisfactory">Unsatisfactory</option>
													<option epgi_val=7 <?php echo $epgi_data['patient_pods'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt11]" class="form-control" value="<?php echo $epgi_data['cmt11'] ?>"></td>
										</tr>

										<tr>
											<td colspan="2">Correctly utilized EPIC link</td>
											<td>7</td>
											<td>
												<select class="form-control epgi_point compliance" name="data[utilized_EPIC_link]" required>
													<option epgi_val=7 <?php echo $epgi_data['utilized_EPIC_link'] == "Excellent" ? "selected" : ""; ?> value="Excellent">Excellent</option>
													<option epgi_val=3 <?php echo $epgi_data['utilized_EPIC_link'] == "Opportunity" ? "selected" : ""; ?> value="Opportunity">Opportunity</option>
													<option epgi_val=0 <?php echo $epgi_data['utilized_EPIC_link'] == "Unsatisfactory" ? "selected" : ""; ?> value="Unsatisfactory">Unsatisfactory</option>
													<option epgi_val=7 <?php echo $epgi_data['utilized_EPIC_link'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt12]" class="form-control" value="<?php echo $epgi_data['cmt12'] ?>"></td>
										</tr>
										
										<tr>
											<td class="eml" rowspan=2 style="font-weight:bold; background-color:#d6bf91">Business Critical</td>
											<td class="eml" rowspan=2>Telephony</td>
											<td colspan="2">Correctly utilized phone system with little to no delay in communication</td>
											<td>4</td>
											<td>
												<select class="form-control epgi_point business" name="data[delay_in_communication]" required>
													<option epgi_val=4 <?php echo $epgi_data['delay_in_communication'] == "Excellent" ? "selected" : ""; ?> value="Excellent">Excellent</option>
													<option epgi_val=2 <?php echo $epgi_data['delay_in_communication'] == "Opportunity" ? "selected" : ""; ?> value="Opportunity">Opportunity</option>
													<option epgi_val=0 <?php echo $epgi_data['delay_in_communication'] == "Unsatisfactory" ? "selected" : ""; ?> value="Unsatisfactory">Unsatisfactory</option>
													<option epgi_val=4 <?php echo $epgi_data['delay_in_communication'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt13]" class="form-control" value="<?php echo $epgi_data['cmt13'] ?>"></td>
										</tr>
										<tr>
											<td colspan="2">Used correct procedure for transferring to staff extension or department</td>
											<td>4</td>
											<td>
												<select class="form-control epgi_point business" name="data[transferring_to_staff]" required>
													<option epgi_val=4 <?php echo $epgi_data['transferring_to_staff'] == "Excellent" ? "selected" : ""; ?> value="Excellent">Excellent</option>
													<option epgi_val=2 <?php echo $epgi_data['transferring_to_staff'] == "Opportunity" ? "selected" : ""; ?> value="Opportunity">Opportunity</option>
													<option epgi_val=0 <?php echo $epgi_data['transferring_to_staff'] == "Unsatisfactory" ? "selected" : ""; ?> value="Unsatisfactory">Unsatisfactory</option>
													<option epgi_val=4 <?php echo $epgi_data['transferring_to_staff'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt14]" class="form-control" value="<?php echo $epgi_data['cmt14'] ?>"></td>
										</tr>

										<tr>
											<td class="eml" rowspan=5 style="font-weight:bold; background-color:pink">Customer Critical</td>
											<td class="eml" rowspan=5>Soft Skills</td>
											<td colspan="2">Avoided long silences during the call</td>
											<td>5</td>
											<td>
												<select class="form-control epgi_point customer" name="data[avoided_long_silences]" required>
													<option epgi_val=5 <?php echo $epgi_data['avoided_long_silences'] == "Excellent" ? "selected" : ""; ?> value="Excellent">Excellent</option>
													<option epgi_val=3 <?php echo $epgi_data['avoided_long_silences'] == "Opportunity" ? "selected" : ""; ?> value="Opportunity">Opportunity</option>
													<option epgi_val=0 <?php echo $epgi_data['avoided_long_silences'] == "Unsatisfactory" ? "selected" : ""; ?> value="Unsatisfactory">Unsatisfactory</option>
													<option epgi_val=5 <?php echo $epgi_data['avoided_long_silences'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt15]" class="form-control" value="<?php echo $epgi_data['cmt15'] ?>"></td>
										</tr>

										<tr>
											<td colspan="2">Did not interrupt the caller</td>
											<td>5</td>
											<td>
												<select class="form-control epgi_point customer" name="data[interrupt_caller]" required>
													<option epgi_val=5 <?php echo $epgi_data['interrupt_caller'] == "Excellent" ? "selected" : ""; ?> value="Excellent">Excellent</option>
													<option epgi_val=3 <?php echo $epgi_data['interrupt_caller'] == "Opportunity" ? "selected" : ""; ?> value="Opportunity">Opportunity</option>
													<option epgi_val=0 <?php echo $epgi_data['interrupt_caller'] == "Unsatisfactory" ? "selected" : ""; ?> value="Unsatisfactory">Unsatisfactory</option>
													<option epgi_val=5 <?php echo $epgi_data['interrupt_caller'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt16]" class="form-control" value="<?php echo $epgi_data['cmt16'] ?>"></td>
										</tr>

										<tr>
											<td colspan="2">Was  polite, friendly, and professional</td>
											<td>5</td>
											<td>
												<select class="form-control epgi_point customer" name="data[polite]" required>
													<option epgi_val=5 <?php echo $epgi_data['polite'] == "Excellent" ? "selected" : ""; ?> value="Excellent">Excellent</option>
													<option epgi_val=3 <?php echo $epgi_data['polite'] == "Opportunity" ? "selected" : ""; ?> value="Opportunity">Opportunity</option>
													<option epgi_val=0 <?php echo $epgi_data['polite'] == "Unsatisfactory" ? "selected" : ""; ?> value="Unsatisfactory">Unsatisfactory</option>
													<option epgi_val=5 <?php echo $epgi_data['polite'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt17]" class="form-control" value="<?php echo $epgi_data['cmt17'] ?>"></td>
										</tr>

										<tr>
											<td colspan="2">Call was kept to the point and utilized time efficiently</td>
											<td>5</td>
											<td>
												<select class="form-control epgi_point customer" name="data[utilized_time_efficiently]" required>
													<option epgi_val=5 <?php echo $epgi_data['utilized_time_efficiently'] == "Excellent" ? "selected" : ""; ?> value="Excellent">Excellent</option>
													<option epgi_val=3 <?php echo $epgi_data['utilized_time_efficiently'] == "Opportunity" ? "selected" : ""; ?> value="Opportunity">Opportunity</option>
													<option epgi_val=0 <?php echo $epgi_data['utilized_time_efficiently'] == "Unsatisfactory" ? "selected" : ""; ?> value="Unsatisfactory">Unsatisfactory</option>
													<option epgi_val=5 <?php echo $epgi_data['utilized_time_efficiently'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt18]" class="form-control" value="<?php echo $epgi_data['cmt18'] ?>"></td>
										</tr>

										<tr>
											<td colspan="2">Conveyed appropriate empathy, when necessary, while maintaining control of the call</td>
											<td>5</td>
											<td>
												<select class="form-control epgi_point customer" name="data[appropriate_empathy]" required>
													<option epgi_val=5 <?php echo $epgi_data['appropriate_empathy'] == "Excellent" ? "selected" : ""; ?> value="Excellent">Excellent</option>
													<option epgi_val=3 <?php echo $epgi_data['appropriate_empathy'] == "Opportunity" ? "selected" : ""; ?> value="Opportunity">Opportunity</option>
													<option epgi_val=0 <?php echo $epgi_data['appropriate_empathy'] == "Unsatisfactory" ? "selected" : ""; ?> value="Unsatisfactory">Unsatisfactory</option>
													<option epgi_val=5 <?php echo $epgi_data['appropriate_empathy'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt19]" class="form-control" value="<?php echo $epgi_data['cmt19'] ?>"></td>
										</tr>

										<tr>
											<td class="eml" rowspan=1 style="font-weight:bold; background-color:pink">Customer Critical</td>
											<td class="eml" rowspan=3>End Call</td>
											<td colspan="2">Offered further assistance</td>
											<td>2</td>
											<td>
												<select class="form-control epgi_point customer" name="data[further_assistance]" required>
													<option epgi_val=2 <?php echo $epgi_data['further_assistance'] == "Excellent" ? "selected" : ""; ?> value="Excellent">Excellent</option>
													<option epgi_val=1 <?php echo $epgi_data['further_assistance'] == "Opportunity" ? "selected" : ""; ?> value="Opportunity">Opportunity</option>
													<option epgi_val=0 <?php echo $epgi_data['further_assistance'] == "Unsatisfactory" ? "selected" : ""; ?> value="Unsatisfactory">Unsatisfactory</option>
													<option epgi_val=2 <?php echo $epgi_data['further_assistance'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt20]" class="form-control" value="<?php echo $epgi_data['cmt20'] ?>"></td>
										</tr>
										<tr>
											<td class="eml" rowspan=1 style="font-weight:bold; background-color:#D7BDE2">Compliance Critical</td>
											<td colspan="2">Call ended on a positive note with a summary/verification of actions and date of appointment(s)</td>
											<td>2</td>
											<td>
												<select class="form-control epgi_point compliance" name="data[summary_verification]" required>
													<option epgi_val=2 <?php echo $epgi_data['summary_verification'] == "Excellent" ? "selected" : ""; ?> value="Excellent">Excellent</option>
													<option epgi_val=1 <?php echo $epgi_data['summary_verification'] == "Opportunity" ? "selected" : ""; ?> value="Opportunity">Opportunity</option>
													<option epgi_val=0 <?php echo $epgi_data['summary_verification'] == "Unsatisfactory" ? "selected" : ""; ?> value="Unsatisfactory">Unsatisfactory</option>
													<option epgi_val=2 <?php echo $epgi_data['summary_verification'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt21]" class="form-control" value="<?php echo $epgi_data['cmt21'] ?>"></td>
										</tr>
										<tr>
											<td class="eml" rowspan=1 style="font-weight:bold; background-color:pink">Customer Critical</td>
											<td colspan="2">Thanked the caller for his/her time and branded the call</td>
											<td>3</td>
											<td>
												<select class="form-control epgi_point customer" name="data[thanked_caller]" required>
													<option epgi_val=3 <?php echo $epgi_data['thanked_caller'] == "Excellent" ? "selected" : ""; ?> value="Excellent">Excellent</option>
													<option epgi_val=1 <?php echo $epgi_data['thanked_caller'] == "Opportunity" ? "selected" : ""; ?> value="Opportunity">Opportunity</option>
													<option epgi_val=0 <?php echo $epgi_data['thanked_caller'] == "Unsatisfactory" ? "selected" : ""; ?> value="Unsatisfactory">Unsatisfactory</option>
													<option epgi_val=2 <?php echo $epgi_data['thanked_caller'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt22]" class="form-control" value="<?php echo $epgi_data['cmt22'] ?>"></td>
										</tr>

									<tr style="font-weight:bold; background-color:#D7BDE2"><td colspan=2>Customer Score</td><td colspan=2>Business Score</td><td colspan=4>Compliance Score</td></tr>

									<tr style="font-weight:bold; background-color:#D7BDE2">
										<td>Earned Point:</td><td ><input type="text" readonly class="form-control" id="customer_earned_score" name="data[customer_earned_score]" value="<?php echo $epgi_data['customer_earned_score'] ?>"></td>
										<td>Earned Point:</td><td ><input type="text" readonly class="form-control" id="business_earned_score" name="data[business_earned_score]" value="<?php echo $epgi_data['business_earned_score'] ?>"></td>
										<td>Earned Point:</td><td colspan=2><input type="text" readonly class="form-control" id="compliance_earned_score" name="data[compliance_earned_score]" value="<?php echo $epgi_data['compliance_earned_score'] ?>"></td>
									</tr>
									<tr style="font-weight:bold; background-color:#D7BDE2">
										<td>Possible Point:</td><td ><input type="text" readonly class="form-control" id="customer_possible_score" name="data[customer_possible_score]" value="<?php echo $epgi_data['customer_possible_score'] ?>"></td>
										<td>Possible Point:</td><td ><input type="text" readonly class="form-control" id="business_possible_score" name="data[business_possible_score]" value="<?php echo $epgi_data['business_possible_score'] ?>"></td>
										<td>Possible Point:</td><td colspan=2><input type="text" readonly class="form-control" id="compliance_possible_score" name="data[compliance_possible_score]" value="<?php echo $epgi_data['compliance_possible_score'] ?>"></td>
									</tr>
									<tr style="font-weight:bold; background-color:#D7BDE2">
										<td>Overall Percentage:</td><td ><input type="text" readonly class="form-control" id="customer_overall_score" name="data[customer_overall_score]" value="<?php echo $epgi_data['customer_overall_score'] ?>"></td>
										<td>Overall Percentage:</td><td ><input type="text" readonly class="form-control" id="business_overall_score" name="data[business_overall_score]" value="<?php echo $epgi_data['business_overall_score'] ?>"></td>
										<td>Overall Percentage:</td><td colspan=2><input type="text" readonly class="form-control" id="compliance_overall_score" name="data[compliance_overall_score]" value="<?php echo $epgi_data['compliance_overall_score'] ?>"></td>
									</tr>
										<tr>
											<td>Call Summary:</td>
											<td colspan=2><textarea class="form-control" name="data[call_summary]"><?php echo $epgi_data['call_summary'] ?></textarea></td>
											<td>Feedback:</td>
											<td colspan=4><textarea class="form-control" name="data[feedback]"><?php echo $epgi_data['feedback'] ?></textarea></td>
										</tr>
										<tr>
											<td colspan=2>Upload Files [m4a,mp4,mp3,wav]</td>
											<?php if ($epgi_id == 0) { ?>
												<td colspan=6>
													<input type="file" name="attach_file[]" id="attach_file" accept=".m4a,.mp4,.mp3,.wav,audio/*" />
												</td>
												<?php } else {
												if ($epgi_data['attach_file'] != '') { ?>
													<td colspan=6>
														<input type="file" multiple class="form-control"  id="attach_file" name="attach_file[]" accept=".m4a,.mp4,.mp3,.wav,audio/*"> 
														<?php $attach_file = explode(",", $epgi_data['attach_file']);
														foreach ($attach_file as $mp) { ?>
															<audio controls='' style="background-color:#607F93">
																<source src="<?php echo base_url(); ?>qa_files/qa_epgi/<?php echo $mp; ?>" type="audio/ogg">
																<source src="<?php echo base_url(); ?>qa_files/qa_epgi/<?php echo $mp; ?>" type="audio/mpeg">
															</audio> </br>
														<?php } ?>
													</td>
											<?php } else {
													echo '<td colspan=6>
													<input type="file" multiple class="form-control" id="attach_file" name="attach_file[]" accept=".m4a,.mp4,.mp3,.wav,audio/*">
													<b>No Files</b></td>';
												}
											} ?>
										</tr>

										<?php if ($epgi_id != 0) { ?>
											<tr>
												<td colspan=2 style="font-size:16px; font-weight:bold">Agent Feedback Acceptance:</td>
												<td colspan=4><?php echo $epgi_data['agnt_fd_acpt'] ?></td>
											</tr>
											<tr>
												<td colspan=2 style="font-size:16px; font-weight:bold">Agent Review:</td>
												<td colspan=4><?php echo $epgi_data['agent_rvw_note'] ?></td>
											</tr>
											<tr>
												<td colspan=2 style="font-size:16px; font-weight:bold">Management Review:</td>
												<td colspan=4><?php echo $epgi_data['mgnt_rvw_note'] ?></td>
											</tr>
											<tr>
												<td colspan=2 style="font-size:16px; font-weight:bold">Client Review:</td>
												<td colspan=4><?php echo $epgi_data['client_rvw_note'] ?></td>
											</tr>

											<tr>
												<td colspan=2 style="font-size:16px">Your Review<span style="font-size:24px;color:red">*</span></td>
												<td colspan=4><textarea class="form-control1" style="width:100%" id="note" name="note" required></textarea></td>
											</tr>
										<?php } ?>

										<?php
										if ($epgi_id == 0) {
											if (is_access_qa_module() == true || is_access_qa_operations_module() == true) { ?>
												<tr>
													<td colspan=8><button class="btn btn-success waves-effect" type="submit" id="qaformsubmit" style="width:500px">SAVE</button></td>
												</tr>
												<?php
											}
										} else {
											if (is_access_qa_module() == true || is_access_qa_operations_module() == true) {
												if (is_available_qa_feedback($epgi_data['entry_date'], 72) == true) { ?>
													<tr>
														<td colspan="8"><button class="btn btn-success waves-effect" type="submit" id='qaformsubmit' name='btnSave' value="SAVE" style="width:500px">SAVE</button></td>
													</tr>
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