<style>
.table > tbody > tr > td{
	text-align: center;
	font-size:12px;
}

#theader{
	font-size:20px;
	font-weight:bold;
	background-color:#95A5A6;
}

.eml{
	font-weight:bold;
	background-color:#F4D03F;
}
.eml1{
	font-weight:bold;
	background-color:#add8e6;
}
.eml2{
	font-weight:bold;
	background-color:#90ee90;
}
.eml3{
	font-weight:bold;
	background-color:#C4A484;
}
.eml4{
	font-weight:bold;
	background-color:#969d54;
}
.ui-datepicker .ui-datepicker-buttonpane button.ui-datepicker-current {
	 float: left;
	 display: none;
	}

</style>

<?php if ($sentry_credit_id != 0) {
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
									<tr style="background-color:#AEB6BF">
										<td colspan=6 id="theader" style="font-size:30px">SENTRY CREDIT Observation Form</td>
										<?php
										if($sentry_credit_id==0){
											$auditorName = get_username();
											$auditDate = CurrDateMDY();
											$clDate_val='';
										}else{
											if($sentry_credit_data['entry_by']!=''){
												$auditorName = $sentry_credit_data['auditor_name'];
											}else{
												$auditorName = $sentry_credit_data['client_name'];
											}
											$auditDate = mysql2mmddyy($sentry_credit_data['audit_date']);
											$clDate_val = mysql2mmddyy($sentry_credit_data['call_date']);
										}
									?>
										<input type="hidden" name="audit_start_time" value="<?php echo CurrMySqlDate(); ?>">
									</tr>
									<tr>
										<td>QA Name:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control" value="<?php echo $auditorName; ?>" disabled></td>
										<td>Audit Date:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control" id="audit_date" value="<?php echo $auditDate; ?>" disabled></td>
										<td>Call Date:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control" id="call_date" onkeydown="return false;" name="call_date" value="<?php echo $clDate_val; ?>" required></td>
									</tr>
									<tr>
										<td>Agent:<span style="font-size:24px;color:red">*</span></td>
										<td>
											<select class="form-control" id="agent_id" name="data[agent_id]" required>
												<option value="<?php echo $sentry_credit_data['agent_id'] ?>"><?php echo $sentry_credit_data['fname']." ".$sentry_credit_data['lname'] ?></option>
												<option value="">-Select-</option>
												<?php foreach($agentName as $row):  ?>
													<option value="<?php echo $row['id']; ?>"><?php echo $row['name'].' ('.$row['fusion_id'].')'; ?></option>
												<?php endforeach; ?>
											</select>
										</td>
										<td>Fusion ID:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" readonly class="form-control" id="fusion_id" name="" value="<?php echo $sentry_credit_data['fusion_id'] ?>"></td>
										<td>L1 Supervisor:<span style="font-size:24px;color:red">*</span></td>
										<td>
										<input type="text" class="form-control" id="tl_names"  value="<?php echo $sentry_credit_data['tl_name']; ?>" readonly>
												<input type="hidden" class="form-control" id="tl_id" name="data[tl_id]" value="<?php echo $sentry_credit_data['tl_id'] ?>" required>
										</td>
									</tr>
									<tr>
										<td>Collector:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control" name="data[collector]" value="<?php echo $sentry_credit_data['collector'] ?>" required></td>
										<td>Call Duration:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control" id="call_duration" onkeydown="return false;" name="data[call_duration]" value="<?php echo $sentry_credit_data['call_duration'] ?>" required></td>
										<td>Agent Tenurity:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control" id="tenuarity" name="data[tenurity]" value="<?php echo $sentry_credit_data['tenurity'] ?>" readonly></td>
									</tr>
									<tr>
										<td>SCI:<span style="font-size:24px;color:red">*</span></td>
										<td>
											<input type="text" class="form-control" id="sci" name="data[sci]" value="<?php echo $sentry_credit_data['sci'] ?>" required>
										</td>
										<td>Client:<span style="font-size:24px;color:red">*</span></td>
										<td>
											<input type="text" class="form-control" id="client" name="data[client]" value="<?php echo $sentry_credit_data['client'] ?>" required>
										</td>
										<td>Site/Location:<span style="font-size:24px;color:red">*</span></td>
										<td>
											<select class="form-control" name="data[site]" required>
												<option value="">-Select-</option>
												<option <?php echo $sentry_credit_data['site']=='Cebu'?"selected":""; ?> value="Cebu">Fresh Cebu</option>
												<option <?php echo $sentry_credit_data['site']=='Esal'?"selected":""; ?> value="Esal">Esal</option>
											</select>
										</td>
									</tr>
									
									<tr>
										<td>VOC:<span style="font-size:24px;color:red">*</span></td>
										<td>
											<select class="form-control" id="voc" name="data[voc]" required>
												<option value="">-Select-</option>
												<option value="1" <?= ($sentry_credit_data['voc']=="1")?"selected":"" ?>>1</option>
													<option value="2"  <?= ($sentry_credit_data['voc']=="2")?"selected":"" ?>>2</option>
													<option value="3"  <?= ($sentry_credit_data['voc']=="3")?"selected":"" ?>>3</option>
													<option value="4"  <?= ($sentry_credit_data['voc']=="4")?"selected":"" ?>>4</option>
													<option value="5"  <?= ($sentry_credit_data['voc']=="5")?"selected":"" ?>>5</option>
													<option value="6"  <?= ($sentry_credit_data['voc']=="6")?"selected":"" ?>>6</option>
													<option value="7"  <?= ($sentry_credit_data['voc']=="7")?"selected":"" ?>>7</option>
													<option value="8"  <?= ($sentry_credit_data['voc']=="8")?"selected":"" ?>>8</option>
													<option value="9"  <?= ($sentry_credit_data['voc']=="9")?"selected":"" ?>>9</option>
													<option value="10"  <?= ($sentry_credit_data['voc']=="10")?"selected":"" ?>>10</option>
											</select>
										</td>
										<td>VT ID:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control" name="data[call_id]" value="<?php echo $sentry_credit_data['call_id'] ?>" required></td>
										<td>ACPT<span style="font-size:24px;color:red">*</span></td>
											<td>
												<select class="form-control" name="data[acpt]" required>
													<option value="">-Select-</option>
                                                    <option value="Agent"  <?= ($sentry_credit_data['acpt']=="Agent")?"selected":"" ?>>Agent</option>
                                                    <option value="Process"  <?= ($sentry_credit_data['acpt']=="Process")?"selected":"" ?>>Process</option>
                                                    <option value="Customer"  <?= ($sentry_credit_data['acpt']=="Customer")?"selected":"" ?>>Customer</option>
                                                    <option value="Technology"  <?= ($sentry_credit_data['acpt']=="Technology")?"selected":"" ?>>Technology</option>
                                                    <option value="NA"  <?= ($sentry_credit_data['acpt']=="NA")?"selected":"" ?>>NA</option>
                                                </select>
											</td>
										<tr>
										<td>Audit Type:<span style="font-size:24px;color:red">*</span></td>
										<td>
											<select class="form-control" id="audit_type" name="data[audit_type]" required>
												<option value="">-Select-</option>
												 <option value="CQ Audit" <?= ($sentry_credit_data['audit_type']=="CQ Audit")?"selected":"" ?>>CQ Audit</option>
                                                    <option value="BQ Audit" <?= ($sentry_credit_data['audit_type']=="BQ Audit")?"selected":"" ?>>BQ Audit</option>
                                                    <option value="Calibration" <?= ($sentry_credit_data['audit_type']=="Calibration")?"selected":"" ?>>Calibration</option>
                                                    <option value="Pre-Certificate Mock Call" <?= ($sentry_credit_data['audit_type']=="Pre-Certificate Mock Call")?"selected":"" ?>>Pre-Certificate Mock Call</option>
                                                    <option value="Certification Audit" <?= ($sentry_credit_data['audit_type']=="Certification Audit")?"selected":"" ?>>Certification Audit</option>
                                                    <option value="WoW Call"  <?= ($sentry_credit_data['audit_type']=="WoW Call")?"selected":"" ?>>WoW Call</option>
                                                    <option value="Hygiene Audit"  <?= ($sentry_credit_data['audit_type']=="Hygiene Audit")?"selected":"" ?>>Hygiene Audit</option>
                                                    <option value="Operation Audit"  <?= ($sentry_credit_data['audit_type']=="Operation Audit")?"selected":"" ?>>Operation Audit</option>
                                                    <option value="Trainer Audit"  <?= ($sentry_credit_data['audit_type']=="Trainer Audit")?"selected":"" ?>>Trainer Audit</option>
                                                    <option value="QA Supervisor Audit"  <?= ($sentry_credit_data['audit_type']=="QA Supervisor Audit")?"selected":"" ?>>QA Supervisor Audit</option>
											</select>
										</td>
											<td class="auType">Auditor Type:<span style="font-size:24px;color:red">*</span></td>
											<td class="auType">
												<select class="form-control" id="auditor_type" name="data[auditor_type]">
													<option value="<?php echo $sentry_credit_data['auditor_type'] ?>"><?php echo $sentry_credit_data['auditor_type'] ?></option>
													<option value="">-Select-</option>
													<option value="Master">Master</option>
													<option value="Regular">Regular</option>
												</select>
											</td>
										</tr>
									
									<tr>
										<td style="font-weight:bold; font-size:16px">Earned Score:</td>
										<td><input type="text" readonly id="sentry_credit_earned" name="data[earned_score]" class="form-control" style="font-weight:bold" value="<?php echo $sentry_credit_data['earned_score'] ?>"></td>
										<td style="font-weight:bold; font-size:16px">Possible Score:</td>
										<td><input type="text" readonly id="sentry_credit_possible" name="data[possible_score]" class="form-control" style="font-weight:bold" value="<?php echo $sentry_credit_data['possible_score'] ?>"></td>
										<td style="font-weight:bold; font-size:16px; text-align:right">Overall Score:</td>
										<td><input type="text" readonly id="sentry_credit_overall" name="data[overall_score]" class="form-control sentry_creditFatal" style="font-weight:bold" value="<?php echo $sentry_credit_data['overall_score'] ?>"></td>
									</tr>
									
									<tr class="eml" style="height:25px; font-weight:bold">
											<td>PARAMETER</td>
											<td colspan=2>SUB PARAMETER</td>
											<td>WEIGHTAGE</td>
											<td>STATUS</td>
											<td colspan=2>REMARKS</td>
									</tr>

										<tr>
											<td class="eml1" rowspan=7>Opening</td>
												<td colspan=2 class="text-danger">Did the collector begin with the exact call recording disclosure?</td>
												<td>5.26</td>
												<td>
													<select class="form-control sentry_credit_point" id="sentry_Fatal1" name="data[begin_call_recording]" required>
														
														<option sentry_credit_val=5.26 sentry_credit_max="5.26"<?php echo $sentry_credit_data['begin_call_recording'] == "Yes" ? "selected" : ""; ?> value="Yes">Yes</option>
														<option sentry_credit_val=0 sentry_credit_max="5.26" <?php echo $sentry_credit_data['begin_call_recording'] == "No" ? "selected" : ""; ?> value="No">No</option>
														<option sentry_credit_val=5.26 sentry_credit_max="5.26" <?php echo $sentry_credit_data['begin_call_recording'] == "NA" ? "selected" : ""; ?> value="NA">NA</option>
													</select>
												</td>
												<td colspan=2><input type="text" name="data[cmt1]" class="form-control" value="<?php echo $sentry_credit_data['cmt1'] ?>"></td>
										</tr>
										<tr>
											<td colspan=2 class="text-danger">Did collector verify they are speaking to the debtor or authorized party prior to collecting a debt? (DOB/SSN/ADDY/EMAIL)</td>
											<td>5.26</td>
											<td>
												<select class="form-control sentry_credit_point" id="sentry_Fatal2" name="data[verify_speacking]" required>
													
													<option sentry_credit_val=5.26 sentry_credit_max="5.26"<?php echo $sentry_credit_data['verify_speacking'] == "Yes" ? "selected" : ""; ?> value="Yes">Yes</option>
													<option sentry_credit_val=0 sentry_credit_max="5.26" <?php echo $sentry_credit_data['verify_speacking'] == "No" ? "selected" : ""; ?> value="No">No</option>
													<option sentry_credit_val=5.26 sentry_credit_max="5.26" <?php echo $sentry_credit_data['verify_speacking'] == "NA" ? "selected" : ""; ?> value="NA">NA</option> 
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt2]" class="form-control" value="<?php echo $sentry_credit_data['cmt2'] ?>"></td>
										</tr>

										<tr>
											<td colspan=2>Email Requested/Confirmed?</td>
											<td>5.26</td>
											<td>
												<select class="form-control sentry_credit_point" id="" name="data[email_requested]" required>
													
													<option sentry_credit_val=5.26 sentry_credit_max="5.26"<?php echo $sentry_credit_data['email_requested'] == "Yes" ? "selected" : ""; ?> value="Yes">Yes</option>
													<option sentry_credit_val=0 sentry_credit_max="5.26" <?php echo $sentry_credit_data['email_requested'] == "No" ? "selected" : ""; ?> value="No">No</option>
													<option sentry_credit_val=5.26 sentry_credit_max="5.26" <?php echo $sentry_credit_data['email_requested'] == "NA" ? "selected" : ""; ?> value="NA">NA</option> 
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt3]" class="form-control" value="<?php echo $sentry_credit_data['cmt3'] ?>"></td>
										</tr>
										<tr>
											<td colspan=2 class="text-danger">Did collector Identify themselves by name prior to attempting to collect a debt?</td>
											<td>5.26</td>
											<td>
												<select class="form-control sentry_credit_point" id="sentry_Fatal3" name="data[identify_themselves]" required>
													
													<option sentry_credit_val=5.26 sentry_credit_max="5.26"<?php echo $sentry_credit_data['identify_themselves'] == "Yes" ? "selected" : ""; ?> value="Yes">Yes</option>
													<option sentry_credit_val=0 sentry_credit_max="5.26" <?php echo $sentry_credit_data['identify_themselves'] == "No" ? "selected" : ""; ?> value="No">No</option>
													<option sentry_credit_val=5.26 sentry_credit_max="5.26" <?php echo $sentry_credit_data['identify_themselves'] == "NA" ? "selected" : ""; ?> value="NA">NA</option> 
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt4]" class="form-control" value="<?php echo $sentry_credit_data['cmt4'] ?>"></td>
										</tr>
										<tr>
											<td colspan=2 class="text-danger">Did collector Identify collection agency by name prior to attempting to collect a debt?</td>
											<td>5.26</td>
											<td>
												<select class="form-control sentry_credit_point" id="sentry_Fatal4" name="data[identify_collection_agency]" required>
													
													<option sentry_credit_val=5.26 sentry_credit_max="5.26"<?php echo $sentry_credit_data['identify_collection_agency'] == "Yes" ? "selected" : ""; ?> value="Yes">Yes</option>
													<option sentry_credit_val=0 sentry_credit_max="5.26" <?php echo $sentry_credit_data['identify_collection_agency'] == "No" ? "selected" : ""; ?> value="No">No</option>
													<option sentry_credit_val=5.26 sentry_credit_max="5.26" <?php echo $sentry_credit_data['identify_collection_agency'] == "NA" ? "selected" : ""; ?> value="NA">NA</option> 
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt5]" class="form-control" value="<?php echo $sentry_credit_data['cmt5'] ?>"></td>
										</tr>
										<tr>
											<td colspan=2 class="text-danger">Did collector give Mini Miranda prior to attempting to collect the debt (this should happen at the beginning of call after debtor confirms he/she is a right party and prior to collector concluding the opening of call and debtor speaking)?</td>
											<td>5.26</td>
											<td>
												<select class="form-control sentry_credit_point" id="sentry_Fatal5" name="data[give_Mini_Miranda]" required>
													
													<option sentry_credit_val=5.26 sentry_credit_max="5.26"<?php echo $sentry_credit_data['give_Mini_Miranda'] == "Yes" ? "selected" : ""; ?> value="Yes">Yes</option>
													<option sentry_credit_val=0 sentry_credit_max="5.26" <?php echo $sentry_credit_data['give_Mini_Miranda'] == "No" ? "selected" : ""; ?> value="No">No</option>
													<option sentry_credit_val=5.26 sentry_credit_max="5.26" <?php echo $sentry_credit_data['give_Mini_Miranda'] == "NA" ? "selected" : ""; ?> value="NA">NA</option> 
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt6]" class="form-control" value="<?php echo $sentry_credit_data['cmt6'] ?>"></td>
										</tr>
										<tr>
											<td colspan=2 class="text-danger">Did collector identify the original creditor, current creditor, client, merchant, or credit card type, if not identified by the consumer? Was balance disclosed on the call? </td>
											<td>5.26</td>
											<td>
												<select class="form-control sentry_credit_point" id="sentry_Fatal6" name="data[identify_original_creditor]" required>
													
													<option sentry_credit_val=5.26 sentry_credit_max="5.26"<?php echo $sentry_credit_data['identify_original_creditor'] == "Yes" ? "selected" : ""; ?> value="Yes">Yes</option>
													<option sentry_credit_val=0 sentry_credit_max="5.26" <?php echo $sentry_credit_data['identify_original_creditor'] == "No" ? "selected" : ""; ?> value="No">No</option>
													<option sentry_credit_val=5.26 sentry_credit_max="5.26" <?php echo $sentry_credit_data['identify_original_creditor'] == "NA" ? "selected" : ""; ?> value="NA">NA</option> 
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt7]" class="form-control" value="<?php echo $sentry_credit_data['cmt7'] ?>"></td>
										</tr>

									<tr>
										<td class="eml" rowspan=12>Call Progression</td>
											<td colspan=2>Did the collector avoid  communicating any false, deceptive or misleading information? (UDAAP)</td>
											<td>5.26</td>
											<td>
												<select class="form-control sentry_credit_point" id="" name="data[avoid_communicating_false]" required>
													
													<option sentry_credit_val=5.26 sentry_credit_max="5.26"<?php echo $sentry_credit_data['avoid_communicating_false'] == "Yes" ? "selected" : ""; ?> value="Yes">Yes</option>
													<option sentry_credit_val=0 sentry_credit_max="5.26" <?php echo $sentry_credit_data['avoid_communicating_false'] == "No" ? "selected" : ""; ?> value="No">No</option>
													<option sentry_credit_val=5.26 sentry_credit_max="5.26" <?php echo $sentry_credit_data['avoid_communicating_false'] == "NA" ? "selected" : ""; ?> value="NA">NA</option> 
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt8]" class="form-control" value="<?php echo $sentry_credit_data['cmt8'] ?>"></td>
										</tr>
										<tr>
											<td colspan=2>Did the collector avoid abusive, rude or unprofessional behavior? (UDAAP)</td>
											<td>5.26</td>
											<td>
												<select class="form-control sentry_credit_point" id="" name="data[avoid_unprofessional_behavior]" required>
													
													<option sentry_credit_val=5.26 sentry_credit_max="5.26"<?php echo $sentry_credit_data['avoid_unprofessional_behavior'] == "Yes" ? "selected" : ""; ?> value="Yes">Yes</option>
													<option sentry_credit_val=0 sentry_credit_max="5.26" <?php echo $sentry_credit_data['avoid_unprofessional_behavior'] == "No" ? "selected" : ""; ?> value="No">No</option>
													<option sentry_credit_val=5.26 sentry_credit_max="5.26" <?php echo $sentry_credit_data['avoid_unprofessional_behavior'] == "NA" ? "selected" : ""; ?> value="NA">NA</option> 
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt9]" class="form-control" value="<?php echo $sentry_credit_data['cmt9'] ?>"></td>
										</tr>
										<tr>
											<td colspan=2>Did collector obtain reason for delinquency?</td>
											<td>5.26</td>
											<td>
												<select class="form-control sentry_credit_point" id="" name="data[reason_for_delinquency]" required>
													
													<option sentry_credit_val=5.26 sentry_credit_max="5.26"<?php echo $sentry_credit_data['reason_for_delinquency'] == "Yes" ? "selected" : ""; ?> value="Yes">Yes</option>
													<option sentry_credit_val=0 sentry_credit_max="5.26" <?php echo $sentry_credit_data['reason_for_delinquency'] == "No" ? "selected" : ""; ?> value="No">No</option>
													<option sentry_credit_val=5.26 sentry_credit_max="5.26" <?php echo $sentry_credit_data['reason_for_delinquency'] == "NA" ? "selected" : ""; ?> value="NA">NA</option> 
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt10]" class="form-control" value="<?php echo $sentry_credit_data['cmt10'] ?>"></td>
										</tr>
										<tr>
											<td colspan=2>Did collector follow negotiation hierarchy?</td>
											<td>5.26</td>
											<td>
												<select class="form-control sentry_credit_point" id="" name="data[follow_negotiation_hierarchy]" required>
													
													<option sentry_credit_val=5.26 sentry_credit_max="5.26"<?php echo $sentry_credit_data['follow_negotiation_hierarchy'] == "Yes" ? "selected" : ""; ?> value="Yes">Yes</option>
													<option sentry_credit_val=0 sentry_credit_max="5.26" <?php echo $sentry_credit_data['follow_negotiation_hierarchy'] == "No" ? "selected" : ""; ?> value="No">No</option>
													<option sentry_credit_val=5.26 sentry_credit_max="5.26" <?php echo $sentry_credit_data['follow_negotiation_hierarchy'] == "NA" ? "selected" : ""; ?> value="NA">NA</option> 
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt11]" class="form-control" value="<?php echo $sentry_credit_data['cmt11'] ?>"></td>
										</tr>
										<tr>
											<td colspan=2>Did the collector properly handle any dispute or complaint? (FDCPA)</td>
											<td>5.26</td>
											<td>
												<select class="form-control sentry_credit_point" id="" name="data[handle_dispute]" required>
													
													<option sentry_credit_val=5.26 sentry_credit_max="5.26"<?php echo $sentry_credit_data['handle_dispute'] == "Yes" ? "selected" : ""; ?> value="Yes">Yes</option>
													<option sentry_credit_val=0 sentry_credit_max="5.26" <?php echo $sentry_credit_data['handle_dispute'] == "No" ? "selected" : ""; ?> value="No">No</option>
													<option sentry_credit_val=5.26 sentry_credit_max="5.26" <?php echo $sentry_credit_data['handle_dispute'] == "NA" ? "selected" : ""; ?> value="NA">NA</option> 
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt12]" class="form-control" value="<?php echo $sentry_credit_data['cmt12'] ?>"></td>
										</tr>
										<tr>
											<td colspan=2>Did collector offer appropriate resolutions based on information available?</td>
											<td>5.26</td>
											<td>
												<select class="form-control sentry_credit_point" id="" name="data[offer_appropriate_resolutions]" required>
													
													<option sentry_credit_val=5.26 sentry_credit_max="5.26"<?php echo $sentry_credit_data['offer_appropriate_resolutions'] == "Yes" ? "selected" : ""; ?> value="Yes">Yes</option>
													<option sentry_credit_val=0 sentry_credit_max="5.26" <?php echo $sentry_credit_data['offer_appropriate_resolutions'] == "No" ? "selected" : ""; ?> value="No">No</option>
													<option sentry_credit_val=5.26 sentry_credit_max="5.26" <?php echo $sentry_credit_data['offer_appropriate_resolutions'] == "NA" ? "selected" : ""; ?> value="NA">NA</option> 
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt13]" class="form-control" value="<?php echo $sentry_credit_data['cmt13'] ?>"></td>
										</tr>
										<tr>
											<td colspan=2 class="text-danger">For accounts that resulted in a payment, did collector follow the appropriate script for the payment type, with the required disclosures for Debit Card, Credit Cards, Check by Phone and Post Dates?</td>
											<td>5.26</td>
											<td>
												<select class="form-control sentry_credit_point" id="sentry_Fatal7" name="data[follow_appropriate_script]" required>
													
													<option sentry_credit_val=5.26 sentry_credit_max="5.26"<?php echo $sentry_credit_data['follow_appropriate_script'] == "Yes" ? "selected" : ""; ?> value="Yes">Yes</option>
													<option sentry_credit_val=0 sentry_credit_max="5.26" <?php echo $sentry_credit_data['follow_appropriate_script'] == "No" ? "selected" : ""; ?> value="No">No</option>
													<option sentry_credit_val=5.26 sentry_credit_max="5.26" <?php echo $sentry_credit_data['follow_appropriate_script'] == "NA" ? "selected" : ""; ?> value="NA">NA</option> 
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt14]" class="form-control" value="<?php echo $sentry_credit_data['cmt14'] ?>"></td>
										</tr>
										<tr>
											<td colspan=2 class="text-danger">For accounts that resulted in a payment, did the collector ask for the name as it appears on the card or checking account and ask for the billing or account address for the account?</td>
											<td>5.26</td>
											<td>
												<select class="form-control sentry_credit_point" id="sentry_Fatal8" name="data[checking_account]" required>
													
													<option sentry_credit_val=5.26 sentry_credit_max="5.26"<?php echo $sentry_credit_data['checking_account'] == "Yes" ? "selected" : ""; ?> value="Yes">Yes</option>
													<option sentry_credit_val=0 sentry_credit_max="5.26" <?php echo $sentry_credit_data['checking_account'] == "No" ? "selected" : ""; ?> value="No">No</option>
													<option sentry_credit_val=5.26 sentry_credit_max="5.26" <?php echo $sentry_credit_data['checking_account'] == "NA" ? "selected" : ""; ?> value="NA">NA</option> 
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt15]" class="form-control" value="<?php echo $sentry_credit_data['cmt15'] ?>"></td>
										</tr>
										<tr>
											<td colspan=2>If agency system notes have been reviewed, did collector correctly and accurately update the system notes?</td>
											<td>5.26</td>
											<td>
												<select class="form-control sentry_credit_point" id="" name="data[update_system_notes]" required>
													
													<option sentry_credit_val=5.26 sentry_credit_max="5.26"<?php echo $sentry_credit_data['update_system_notes'] == "Yes" ? "selected" : ""; ?> value="Yes">Yes</option>
													<option sentry_credit_val=0 sentry_credit_max="5.26" <?php echo $sentry_credit_data['update_system_notes'] == "No" ? "selected" : ""; ?> value="No">No</option>
													<option sentry_credit_val=5.26 sentry_credit_max="5.26" <?php echo $sentry_credit_data['update_system_notes'] == "NA" ? "selected" : ""; ?> value="NA">NA</option> 
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt16]" class="form-control" value="<?php echo $sentry_credit_data['cmt16'] ?>"></td>
										</tr>
										<tr>
											<td colspan=2>Did the collector properly complete any promise tab required?</td>
											<td>5.26</td>
											<td>
												<select class="form-control sentry_credit_point" id="" name="data[complete_promise_tab]" required>
													
													<option sentry_credit_val=5.26 sentry_credit_max="5.26"<?php echo $sentry_credit_data['complete_promise_tab'] == "Yes" ? "selected" : ""; ?> value="Yes">Yes</option>
													<option sentry_credit_val=0 sentry_credit_max="5.26" <?php echo $sentry_credit_data['complete_promise_tab'] == "No" ? "selected" : ""; ?> value="No">No</option>
													<option sentry_credit_val=5.26 sentry_credit_max="5.26" <?php echo $sentry_credit_data['complete_promise_tab'] == "NA" ? "selected" : ""; ?> value="NA">NA</option> 
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt17]" class="form-control" value="<?php echo $sentry_credit_data['cmt17'] ?>"></td>
										</tr>
										<tr>
											<td colspan=2>Did the collector properly handle the account based on the specific compliance popup screen (OOS disclosures, spouse communication requirements, REG F, etc)?</td>
											<td>5.26</td>
											<td>
												<select class="form-control sentry_credit_point" id="" name="data[OOS_disclosures]" required>
													
													<option sentry_credit_val=5.26 sentry_credit_max="5.26"<?php echo $sentry_credit_data['OOS_disclosures'] == "Yes" ? "selected" : ""; ?> value="Yes">Yes</option>
													<option sentry_credit_val=0 sentry_credit_max="5.26" <?php echo $sentry_credit_data['OOS_disclosures'] == "No" ? "selected" : ""; ?> value="No">No</option>
													<option sentry_credit_val=5.26 sentry_credit_max="5.26" <?php echo $sentry_credit_data['OOS_disclosures'] == "NA" ? "selected" : ""; ?> value="NA">NA</option> 
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt18]" class="form-control" value="<?php echo $sentry_credit_data['cmt18'] ?>"></td>
										</tr>
										<tr>
											<td colspan=2>Did the collector complete all necessary file upkeep work (update mailing address, update bankruptcy tab, etc)?</td>
											<td>5.26</td>
											<td>
												<select class="form-control sentry_credit_point" id="" name="data[complete_file_upkeep_work]" required>
													
													<option sentry_credit_val=5.26 sentry_credit_max="5.26"<?php echo $sentry_credit_data['complete_file_upkeep_work'] == "Yes" ? "selected" : ""; ?> value="Yes">Yes</option>
													<option sentry_credit_val=0 sentry_credit_max="5.26" <?php echo $sentry_credit_data['complete_file_upkeep_work'] == "No" ? "selected" : ""; ?> value="No">No</option>
													<option sentry_credit_val=5.26 sentry_credit_max="5.26" <?php echo $sentry_credit_data['complete_file_upkeep_work'] == "NA" ? "selected" : ""; ?> value="NA">NA</option> 
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt19]" class="form-control" value="<?php echo $sentry_credit_data['cmt19'] ?>"></td>
										</tr>
										<tr>
											<td>VT Comment:</td>
										<td colspan=3><textarea class="form-control" id="" name="data[vt_comment]"><?php echo $sentry_credit_data['vt_comment'] ?></textarea></td>
										</tr>
									<tr>
										
										<td>Call Summary:</td>
										<td colspan=3><textarea class="form-control" id="" name="data[call_summary]"><?php echo $sentry_credit_data['call_summary'] ?></textarea></td>
										<td>Feedback:</td>
										<td colspan=3><textarea class="form-control" id="" name="data[feedback]"><?php echo $sentry_credit_data['feedback'] ?></textarea></td>
									</tr>

									<?php if($sentry_credit_id==0){ ?>
									<tr>
										<td colspan=2>Upload Files [m4a,mp4,mp3,wav]</td>
										<td colspan=4><input type="file" multiple class="form-control" id="attach_file" name="attach_file[]" accept=".m4a,.mp4,.mp3,.wav,audio/*"></td>
									</tr>
									<?php }else{ ?>
									<tr>	
										<td colspan=2>Upload Files [m4a,mp4,mp3,wav]</td>
										<?php if($sentry_credit_data['attach_file']!=''){ ?>
											<td colspan=4>
												<input type="file" multiple class="form-control"  id="attach_file" name="attach_file[]" accept=".m4a,.mp4,.mp3,.wav,audio/*"> 
												<?php $attach_file = explode(",",$sentry_credit_data['attach_file']);
												 foreach($attach_file as $mp){ ?>
													<audio controls='' style="background-color:#607F93"> 
													  <source src="<?php echo base_url(); ?>qa_files/qa_sentry/<?php echo $mp; ?>" type="audio/ogg">
													  <source src="<?php echo base_url(); ?>qa_files/qa_sentry/<?php echo $mp; ?>" type="audio/mpeg">
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
									
									<?php if ($sentry_credit_id != 0) { ?>
											<tr>
												<td colspan=2 style="font-size:16px; font-weight:bold">Agent Feedback Acceptance:</td>
												<td colspan=6><?php echo $sentry_credit_data['agnt_fd_acpt'] ?></td>
											</tr>
											<tr>
												<td colspan=2 style="font-size:16px; font-weight:bold">Agent Review:</td>
												<td colspan=6><?php echo $sentry_credit_data['agent_rvw_note'] ?></td>
											</tr>
											<tr>
												<td colspan=2 style="font-size:16px; font-weight:bold">Management Review:</td>
												<td colspan=6><?php echo $sentry_credit_data['mgnt_rvw_note'] ?></td>
											</tr>
											<tr>
												<td colspan=2 style="font-size:16px; font-weight:bold">Client Review:</td>
												<td colspan=6><?php echo $sentry_credit_data['client_rvw_note'] ?></td>
											</tr>

											<tr>
												<td colspan=2 style="font-size:16px">Your Review<span style="font-size:24px;color:red">*</span></td>
												<td colspan=6><textarea class="form-control1" style="width:100%" id="note" name="note" required></textarea></td>
											</tr>
										<?php } ?>

										<?php
										if ($sentry_credit_id == 0) {
											if (is_access_qa_module() == true || is_access_qa_operations_module() == true) { ?>
												<tr>
													<td colspan=8><button class="btn btn-success blains-effect" type="submit" id="qaformsubmit" style="width:500px;margin:auto;display:block;">SAVE</button></td>
												</tr>
												<?php
											}
										} else {
											if (is_access_qa_module() == true || is_access_qa_operations_module() == true) {
												if (is_available_qa_feedback($sentry_credit_data['entry_date'], 72) == true) { ?>
													<tr>
														<td colspan="8"><button class="btn btn-success blains-effect" type="submit" id='qaformsubmit' name='btnSave' value="SAVE" style="width:500px;margin:auto;display:block;">SAVE</button></td>
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
