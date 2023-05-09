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
											<td colspan="8" id="theader" style="font-size:40px; text-align:center!important; ">PARK WEST AGENT FORM</td>
											<input type="hidden" name="audit_start_time" value="<?php echo CurrMySqlDate(); ?>">
										</tr>
										
										<tr>
											<td>Auditor Name:</td>
											<?php if($park_west_data['entry_by']!=''){
												$auditorName = $park_west_data['auditor_name'];
											}else{
												$auditorName = $park_west_data['client_name'];
										} ?>
											<td colspan="2"><input type="text" class="form-control" value="<?= $auditorName; ?>" disabled></td>
											<td>Audit Date:</td>
											<td><input type="text" class="form-control" value="<?php echo mysql2mmddyy($park_west_data['audit_date']); ?>" disabled></td>
											<td>Call Date:</td>
											<td colspan="2">
												<input type="text" id="call_date" name="call_date"  onkeydown="return false;" value="<?php echo mysql2mmddyy($park_west_data['call_date']); ?>" max="<?php echo date("Y-m-d"); ?>" class="form-control" disabled>
											</td>
										</tr>
										<tr>
											<td>Agent Name:</td>
											<td colspan="2">
												<select class="form-control" id="agent_ids" name="data[agent_id]" disabled>
													<?php 
													if($park_west_data['agent_id']!=''){
														?>
														<option value="<?php echo $park_west_data['agent_id'] ?>"><?php echo $park_west_data['fname'] . " " . $park_west_data['lname'] ?></option>
														<?php
													}else{
														?>
														<option value="">Select</option>
														<?php
													}
													?>
													
													
													<?php foreach ($agentName as $row) :  ?>
													<?php 
													if($row['id'] == $park_west_data['agent_id']){
														continue;
													}else{
														?>
														<option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
														<?php
													}
													?>
														
													<?php endforeach; ?>
												</select>
											</td>
											<td>Fusion ID:</td>
											<td><input type="text" class="form-control" id="fusion_id" disabled value="<?php echo $park_west_data['fusion_id'] ?>" readonly></td>
											<td> L1 Supervisor:</td>
											<td colspan="2">

												<input type="text" class="form-control" id="tl_names"  value="<?php echo $park_west_data['tl_name'] ?>" readonly>
												<input type="hidden" class="form-control" id="tl_id" name="data[tl_id]" value="<?php echo $park_west_data['tl_id'] ?>" disabled>
											</td>
										</tr>
										<tr>
											<td>AHT RCA:<span style="font-size:24px;color:red">*</span></td>
											<td colspan="2">
												<select class="form-control" id="" name="data[AHT_RCA]" disabled>
											
											    <option value="">-Select-</option>
											    <option value="Agent" <?= ($park_west_data['AHT_RCA']=="Agent")?"selected":"" ?>>Agent</option>
												<option value="Customer" <?= ($park_west_data['AHT_RCA']=="Customer")?"selected":"" ?>>Customer</option>
												<option value="Process" <?= ($park_west_data['AHT_RCA']=="Process")?"selected":"" ?>>Process</option>
												<option value="Technical" <?= ($park_west_data['AHT_RCA']=="Technical")?"selected":"" ?>>Technical</option>
												<option value="NA" <?= ($park_west_data['AHT_RCA']=="NA")?"selected":"" ?>>NA</option>
											
										</select>
											</td>
											<td>Phone Number:<span style="font-size:24px;color:red">*</span></td>
											<td><input type="text" class="form-control" name="data[customer_phone]" value="<?php echo $park_west_data['customer_phone'] ?>" onkeyup="checkDec(this);" disabled>
												<span id="start_phone" style="color:red"></span></td>

											<td>Customer Name:<span style="font-size:24px;color:red">*</span></td>
											<td colspan="2">
												<input type="text" class="form-control" name="data[customer_name]" value="<?php echo $park_west_data['customer_name'] ?>" disabled>
											</td>
										</tr>
										
										<tr>
											<td>Call Duration:<span style="font-size:24px;color:red">*</span></td>
											<td colspan="2"><input type="text" class="form-control" onkeydown="return false;" id="call_duration" name="data[call_duration]" value="<?php echo $park_west_data['call_duration']?>" disabled></td>
											<td>VOC:<span style="font-size:24px;color:red">*</span></td>
											<td>
												<select class="form-control" id="voc" name="data[voc]" disabled>
													
													<option value="">-Select-</option>
													<option value="1"  <?= ($park_west_data['voc']=="1")?"selected":"" ?>>1</option>
													<option value="2"  <?= ($park_west_data['voc']=="2")?"selected":"" ?>>2</option>
													<option value="3"  <?= ($park_west_data['voc']=="3")?"selected":"" ?>>3</option>
													<option value="4"  <?= ($park_west_data['voc']=="4")?"selected":"" ?>>4</option>
													<option value="5"  <?= ($park_west_data['voc']=="5")?"selected":"" ?>>5</option>
													<option value="6"  <?= ($park_west_data['voc']=="6")?"selected":"" ?>>6</option>
													<option value="7"  <?= ($park_west_data['voc']=="7")?"selected":"" ?>>7</option>
													<option value="8"  <?= ($park_west_data['voc']=="8")?"selected":"" ?>>8</option>
													<option value="9"  <?= ($park_west_data['voc']=="9")?"selected":"" ?>>9</option>
													<option value="10"  <?= ($park_west_data['voc']=="10")?"selected":"" ?>>10</option>
												</select>
											</td>
											<td>Audit Type:<span style="font-size:24px;color:red">*</span></td>
											<td colspan="2">
												<select class="form-control" id="audit_type" name="data[audit_type]" disabled>
                                                    <option value="">-Select-</option>
                                                    <option value="CQ Audit" <?= ($park_west_data['audit_type']=="CQ Audit")?"selected":"" ?>>CQ Audit</option>
                                                    <option value="BQ Audit" <?= ($park_west_data['audit_type']=="BQ Audit")?"selected":"" ?>>BQ Audit</option>
                                                    <option value="Calibration" <?= ($park_west_data['audit_type']=="Calibration")?"selected":"" ?>>Calibration</option>
                                                    <option value="Pre-Certificate Mock Call" <?= ($park_west_data['audit_type']=="Pre-Certificate Mock Call")?"selected":"" ?>>Pre-Certificate Mock Call</option>
                                                    <option value="Certification Audit" <?= ($park_west_data['audit_type']=="Certification Audit")?"selected":"" ?>>Certification Audit</option>
                                                    <option value="WoW Call"  <?= ($park_west_data['audit_type']=="WoW Call")?"selected":"" ?>>WoW Call Audit</option>
                                                    <option value="Hygiene Audit"  <?= ($park_west_data['audit_type']=="Hygiene Audit")?"selected":"" ?>>Hygiene Audit</option>
                                                    <option value="Operation Audit"  <?= ($park_west_data['audit_type']=="Operation Audit")?"selected":"" ?>>Operation Audit</option>
                                                    <option value="Trainer Audit"  <?= ($park_west_data['audit_type']=="Trainer Audit")?"selected":"" ?>>Trainer Audit</option>
                                                   
                                                    
                                                </select>
											</td>
											
										</tr>
										<tr>
											
											<td class="auType_epi">Auditor Type<span style="font-size:24px;color:red">*</span></td>
											<td class="auType_epi">
												<select class="form-control" id="auditor_type" name="data[auditor_type]">
                                                    <option value="">Select</option>
                                                    <option value="Master" <?= ($park_west_data['auditor_type']=="Master")?"selected":"" ?>>Master</option>
                                                    <option value="Regular" <?= ($park_west_data['auditor_type']=="Regular")?"selected":"" ?>>Regular</option>
                                                </select>
											</td>
										</tr>
										<tr>
											<td style="font-weight:bold; font-size:16px; text-align:left">Earned Score</td>
											<td colspan="2"><input type="text" readonly id="park_earned_score" name="data[earned_score]" class="form-control" value="<?php echo $park_west_data['earned_score'] ?>" /></td>
											<td style="font-weight:bold; font-size:16px; text-align:left">Possible Score</td>
											<td><input type="text" readonly id="park_possible_score" name="data[possible_score]" class="form-control" value="<?php echo $park_west_data['possible_score'] ?>" /></td>
											<td style="font-weight:bold; font-size:16px; text-align:right">Overall Score:</td>
											<td colspan="2"><input type="text" class="form-control parkFatal" readonly id="park_overall_score" name="data[overall_score]"  style="font-weight:bold" value="<?php echo $park_west_data['overall_score'] ?>"></td>
										</tr>
										<tr class="eml" style="height:25px; font-weight:bold">
											<td>PARAMETER</td>
											<td colspan=2>SUB PARAMETER</td>
											<td>WEIGHTAGE/PARAMETER</td>
											<td>WEIGHTAGE/CATEGORY</td>
											<td>STATUS</td>
											<td colspan=2>REMARKS</td>
										</tr>

										<tr>
											<td class="eml" rowspan=8>Opening</td>
											<td colspan=2 class="text-danger">Identify himself/herself by first and last name at the beginning of the call? **SQ**</td>
											<td>1.25</td>
											<td rowspan=8>10%</td>
											<td>
												<select class="form-control park_west_point" id ="parkAF1" name="data[identify_himself]" disabled>
													
													<option park_west_val=1.25 park_west_max="1.25"<?php echo $park_west_data['identify_himself'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option park_west_val=0 park_west_max="1.25" <?php echo $park_west_data['identify_himself'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													<option park_west_val=0 park_west_max="1.25" <?php echo $park_west_data['identify_himself'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt1]" class="form-control" value="<?php echo $park_west_data['cmt1'] ?>"></td>
										</tr>
										<tr>
											<td colspan=2 class="text-danger">Provide the Quality Assurance Statement verbatim, before any specific account information was discussed?**SQ**</td>
											<td>1.25</td>
											<td>
												<select class="form-control park_west_point" id ="parkAF2" name="data[provide_quality_assurance]" disabled>
													
													<option park_west_val=1.25 park_west_max="1.25" <?php echo $park_west_data['provide_quality_assurance'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option park_west_val=0 park_west_max="1.25" <?php echo $park_west_data['provide_quality_assurance'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													<option park_west_val=0 park_west_max="1.25" <?php echo $park_west_data['provide_quality_assurance'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt2]" class="form-control" value="<?php echo $park_west_data['cmt2'] ?>"></td>
										</tr>

										<tr>
											<td colspan="2" class="text-danger">State "My Quick Wallet" with no deviation? **SQ**</td>
											<td>1.25</td>
											<td>
												<select class="form-control park_west_point " id ="parkAF3" name="data[state_my_quick_wallet]" disabled>
													
													<option park_west_val=1.25 park_west_max="1.25" <?= $park_west_data["state_my_quick_wallet"] == "Pass" ? "selected" : "" ?> value="Pass">Pass</option>
													<option park_west_val=0 park_west_max="1.25" <?= $park_west_data["state_my_quick_wallet"] == "Fail" ? "selected" : "" ?> value="Fail">Fail</option>
													<option park_west_val=0 park_west_max="1.25" <?= $park_west_data["state_my_quick_wallet"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt3]" class="form-control" value="<?php echo $park_west_data['cmt3'] ?>"></td>
										</tr>
										<tr>
											<td colspan="2" class="text-danger">Verify that he/she was speaking to a right party according to the client requirements (First and Last Name) and before providing the disclosures?</td>
											<td>1.25</td>
											<td>
												<select class="form-control park_west_point" id ="parkAF4" name="data[speaking_right_party]" disabled>
													
													<option park_west_val=1.25 park_west_max="1.25" <?= $park_west_data["speaking_right_party"] == "Pass" ? "selected" : "" ?> value="Pass">Pass</option>
													<option park_west_val=0 park_west_max="1.25" <?= $park_west_data["speaking_right_party"] == "Fail" ? "selected" : "" ?> value="Fail">Fail</option>
													<option park_west_val=0 park_west_max="1.25" <?= $park_west_data["speaking_right_party"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt4]" class="form-control" value="<?php echo $park_west_data['cmt4'] ?>"></td>
										</tr>

										<tr>
											<td colspan="2" class="text-danger">Verify two pieces of demographics information on an outbound call?
											Any two of: (1) Full Name, (2) Date of Birth, (3)
											 Last four digits of SSN, (4)Email Address
											</td>
											<td>1.25</td>
											<td>
												<select class="form-control park_west_point" id ="parkAF5" name="data[demographics_information]" disabled>
													
													<option park_west_val=1.25 park_west_max="1.25" <?= $park_west_data["demographics_information"] == "Pass" ? "selected" : "" ?> value="Pass">Pass</option>
													<option park_west_val=0 park_west_max="1.25" <?= $park_west_data["demographics_information"] == "Fail" ? "selected" : "" ?> value="Fail">Fail</option>
													<option park_west_val=0 park_west_max="1.25" <?= $park_west_data["demographics_information"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt5]" class="form-control" value="<?php echo $park_west_data['cmt5'] ?>"></td>
										</tr>

										<tr>
											<td colspan="2" class="text-danger">Provide the Mini Miranda disclosure verbatim, before any specific account information was discussed? **SQ**
											</td>
											<td>1.25</td>
											<td>
												<select class="form-control park_west_point" id ="parkAF6" name="data[disclosure_verbatim]" disabled>
													
													<option park_west_val=1.25 park_west_max="1.25" <?= $park_west_data["disclosure_verbatim"] == "Pass" ? "selected" : "" ?> value="Pass">Pass</option>
													<option park_west_val=0 park_west_max="1.25" <?= $park_west_data["disclosure_verbatim"] == "Fail" ? "selected" : "" ?> value="Fail">Fail</option>
													<option park_west_val=0 park_west_max="1.25" <?= $park_west_data["disclosure_verbatim"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt6]" class="form-control" value="<?php echo $park_west_data['cmt6'] ?>"></td>
										</tr>
										<tr>
											<td colspan="2">Did the rep ask for callback permission as per Reg F policy?
											</td>
											<td>1.25</td>
											<td>
												<select class="form-control park_west_point" id ="" name="data[callback_permission]" disabled>
													
													<option park_west_val=1.25 park_west_max="1.25" <?= $park_west_data["callback_permission"] == "Pass" ? "selected" : "" ?> value="Pass">Pass</option>
													<option park_west_val=0 park_west_max="1.25" <?= $park_west_data["callback_permission"] == "Fail" ? "selected" : "" ?> value="Fail">Fail</option>
													<option park_west_val=0 park_west_max="1.25" <?= $park_west_data["callback_permission"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt7]" class="form-control" value="<?php echo $park_west_data['cmt7'] ?>"></td>
										</tr>
										<tr>
											<td colspan="2">State/Ask for balance due? (If disabled, also inform the breakdown of principal, finance fees & NSF Fees.)
											</td>
											<td>1.25</td>
											<td>
												<select class="form-control park_west_point" id ="" name="data[balance_due]" disabled>
													
													<option park_west_val=1.25 park_west_max="1.25" <?= $park_west_data["balance_due"] == "Pass" ? "selected" : "" ?> value="Pass">Pass</option>
													<option park_west_val=0 park_west_max="1.25" <?= $park_west_data["balance_due"] == "Fail" ? "selected" : "" ?> value="Fail">Fail</option>
													<option park_west_val=0 park_west_max="1.25" <?= $park_west_data["balance_due"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt8]" class="form-control" value="<?php echo $park_west_data['cmt8'] ?>"></td>
										</tr>



										<tr>
											<td class="eml" rowspan=4>Effort</td>
											<td colspan=2>Ask for intention to resolve the account?</td>
											<td>6</td>
											<td rowspan=4>24%</td>
											<td>
												<select class="form-control park_west_point" name="data[resolve_account]" disabled>
													
													<option park_west_val=6 park_west_max="6" <?php echo $park_west_data['resolve_account'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option park_west_val=0 park_west_max="6" <?php echo $park_west_data['resolve_account'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													<option park_west_val=0 park_west_max="6" <?php echo $park_west_data['resolve_account'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt9]" class="form-control" value="<?php echo $park_west_data['cmt9'] ?>"></td>
										</tr>
										<tr>
											<td colspan=2>Ask for the payment to the account?</td>
											<td>6</td>
											<td>
												<select class="form-control park_west_point" name="data[payment_account]" disabled>
													
													<option park_west_val=6 park_west_max="6" <?php echo $park_west_data['payment_account'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option park_west_val=0 park_west_max="6" <?php echo $park_west_data['payment_account'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													<option park_west_val=0 park_west_max="6" <?php echo $park_west_data['payment_account'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt10]" class="form-control" value="<?php echo $park_west_data['cmt10'] ?>"></td>
										</tr>
										<tr>
											<td colspan=2>Followed the previous conversations on the account for the follow-up call</td>
											<td>6</td>
											<td>
												<select class="form-control park_west_point" name="data[follow_up_call]" disabled>
													
													<option park_west_val=6 park_west_max="6" <?php echo $park_west_data['follow_up_call'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option park_west_val=0 park_west_max="6" <?php echo $park_west_data['follow_up_call'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													<option park_west_val=0 park_west_max="6" <?php echo $park_west_data['follow_up_call'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt11]" class="form-control" value="<?php echo $park_west_data['cmt11'] ?>"></td>
										</tr>
										<tr>
											<td colspan=2>Able to take a promise to pay on the account?</td>
											<td>6</td>
											<td>
												<select class="form-control park_west_point" name="data[promise_pay]" disabled>
													
													<option park_west_val=6 park_west_max="6" <?php echo $park_west_data['promise_pay'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option park_west_val=0 park_west_max="6" <?php echo $park_west_data['promise_pay'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													<option park_west_val=0 park_west_max="6" <?php echo $park_west_data['promise_pay'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt12]" class="form-control" value="<?php echo $park_west_data['cmt12'] ?>"></td>
										</tr>

										<tr>
											<td class="eml" rowspan=4>Negotiation</td>
											<td colspan=2>
												Did the collector elaborate the consiquences of not clearing the bills and benefits of paying off? Eg.
												a) Not paying off your debt will prevent your ability to get short term loans with our company and perhaps other companies
												b) Paying off will allow you to apply for a new loan in the future
												c) Finance fees may continue to be added to your balance if no payments are being made
											</td>
											<td>2.50</td>
											<td rowspan=4>10%</td>
											<td>
												<select class="form-control park_west_point" name="data[elaborate_consiquences]" disabled>
													
													<option park_west_val=2.5 park_west_max="2.5" <?php echo $park_west_data['elaborate_consiquences'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option park_west_val=0 park_west_max="2.5" <?php echo $park_west_data['elaborate_consiquences'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													<option park_west_val=0 park_west_max="2.5" <?php echo $park_west_data['elaborate_consiquences'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt13]" class="form-control" value="<?php echo $park_west_data['cmt13'] ?>"></td>
										</tr>
										<tr>
											<td colspan=2>
												Did the collector provide applicable settelment options? Eg.
                                                a) We are willing to set up a payment plan on your paydays to pay this off in smaller payments over the next 1 -2 months.
											</td>
											<td>2.50</td>
											<td>
												<select class="form-control park_west_point" name="data[settelment_options]" disabled>
													
													<option park_west_val=2.5 park_west_max="2.5" <?php echo $park_west_data['settelment_options'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option park_west_val=0 park_west_max="2.5" <?php echo $park_west_data['settelment_options'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													<option park_west_val=0 park_west_max="2.5" <?php echo $park_west_data['settelment_options'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt14]" class="form-control" value="<?php echo $park_west_data['cmt14'] ?>"></td>
										</tr>

										<tr>
											<td colspan=2>
												Could the collector manage to create urgency for payment? Eg.
                                                a) We may be disabled to reach out to your employer for verification of employment
											</td>
											<td>2.50</td>
											<td>
												<select class="form-control park_west_point" name="data[urgency_for_payment]" disabled>
													
													<option park_west_val=2.5 park_west_max="2.5" <?php echo $park_west_data['urgency_for_payment'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option park_west_val=0 park_west_max="2.5" <?php echo $park_west_data['urgency_for_payment'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													<option park_west_val=0 park_west_max="2.5" <?php echo $park_west_data['urgency_for_payment'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt15]" class="form-control" value="<?php echo $park_west_data['cmt15'] ?>"></td>
										</tr>

										<tr>
											<td colspan=2>
												Did Collector try to negotiate effectively to convince the customer for payment with all possible options?
											</td>
											<td>2.50</td>
											<td>
												<select class="form-control park_west_point" name="data[negotiate_effectively]" disabled>
													
													<option park_west_val=2.5 park_west_max="2.5" <?php echo $park_west_data['negotiate_effectively'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option park_west_val=0 park_west_max="2.5" <?php echo $park_west_data['negotiate_effectively'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													<option park_west_val=0 park_west_max="2.5" <?php echo $park_west_data['negotiate_effectively'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt16]" class="form-control" value="<?php echo $park_west_data['cmt16'] ?>"></td>
										</tr>

										<tr>
											<td class="eml" rowspan=16>Compliance</td>
											<td colspan=2 class="text-danger">
												Did not  Misrepresent their identity or authorization and status of the consumer's account?
											</td>
											<td>0.94</td>
											<td rowspan=16>15%</td>
											<td>
												<select class="form-control park_west_point" id ="parkAF7" name="data[misrepresent_their_identity]" disabled>
													
													<option park_west_val=0.94 park_west_max="0.94" <?php echo $park_west_data['misrepresent_their_identity'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option park_west_val=0 park_west_max="0.94" <?php echo $park_west_data['misrepresent_their_identity'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													<option park_west_val=0 park_west_max="0.94" <?php echo $park_west_data['misrepresent_their_identity'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt17]" class="form-control" value="<?php echo $park_west_data['cmt17'] ?>"></td>
										</tr>
										<tr>
											<td colspan=2 class="text-danger">
												Did not Discuss or imply that any type of legal actions - will be taken or property repossessed, also on time barred accounts amd Did not Threaten to take actions that the client cannot legally take? 
											</td>
											<td>0.94</td>
											<td>
												<select class="form-control park_west_point" id ="parkAF8" name="data[imply_leagal_actions]" disabled>
													
													<option park_west_val=0.94 park_west_max="0.94" <?php echo $park_west_data['imply_leagal_actions'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option park_west_val=0 park_west_max="0.94" <?php echo $park_west_data['imply_leagal_actions'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													<option park_west_val=0 park_west_max="0.94" <?php echo $park_west_data['imply_leagal_actions'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt18]" class="form-control" value="<?php echo $park_west_data['cmt18'] ?>"></td>
										</tr>

										<tr>
											<td colspan=2 class="text-danger">
												Did not Make any false representations regarding the nature of the communication? 
											</td>
											<td>0.94</td>
											<td>
												<select class="form-control park_west_point" id ="parkAF9" name="data[nature_of_communication]" disabled>
													
													<option park_west_val=0.94 park_west_max="0.94" <?php echo $park_west_data['nature_of_communication'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option park_west_val=0 park_west_max="0.94" <?php echo $park_west_data['nature_of_communication'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													<option park_west_val=0 park_west_max="0.94" <?php echo $park_west_data['nature_of_communication'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt19]" class="form-control" value="<?php echo $park_west_data['cmt19'] ?>"></td>
										</tr>
										<tr>
											<td colspan=2 class="text-danger">
												Did not Contact the consumer at any unusual times (sate regulations) or outside the hours of 8:00 am and 9:00 pm at the consumer's location?
											</td>
											<td>0.94</td>
											<td>
												<select class="form-control park_west_point" id ="parkAF10"name="data[contact_customer]" disabled>
													
													<option park_west_val=0.94 park_west_max="0.94" <?php echo $park_west_data['contact_customer'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option park_west_val=0 park_west_max="0.94" <?php echo $park_west_data['contact_customer'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													<option park_west_val=0 park_west_max="0.94" <?php echo $park_west_data['contact_customer'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt20]" class="form-control" value="<?php echo $park_west_data['cmt20'] ?>"></td>
										</tr>
										<tr>
											<td colspan=2 class="text-danger">
												Did not Communicate with the consumer at work if it is known or there is reason to know that such calls are prohibited?
											</td>
											<td>0.94</td>
											<td>
												<select class="form-control park_west_point" id ="parkAF11" name="data[communicate_customer_work]" disabled>
													
													<option park_west_val=0.94 park_west_max="0.94" <?php echo $park_west_data['communicate_customer_work'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option park_west_val=0 park_west_max="0.94" <?php echo $park_west_data['communicate_customer_work'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													<option park_west_val=0 park_west_max="0.94" <?php echo $park_west_data['communicate_customer_work'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt21]" class="form-control" value="<?php echo $park_west_data['cmt21'] ?>"></td>
										</tr>
										<tr>
											<td colspan=2 class="text-danger">
												Did not Communicate with the consumer after learning the consumer is represented by an attorney, filed for bankruptcy unless a permissible reason exists?
											</td>
											<td>0.94</td>
											<td>
												<select class="form-control park_west_point" id ="parkAF12" name="data[communicate_customer_learning]" disabled>
													
													<option park_west_val=0.94 park_west_max="0.94" <?php echo $park_west_data['communicate_customer_learning'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option park_west_val=0 park_west_max="0.94" <?php echo $park_west_data['communicate_customer_learning'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													<option park_west_val=0 park_west_max="0.94" <?php echo $park_west_data['communicate_customer_learning'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt22]" class="form-control" value="<?php echo $park_west_data['cmt22'] ?>"></td>
										</tr>
										<tr>
											<td colspan=2 class="text-danger">
												Adhere to the cell phone policy/TCPA regulations and policy regarding contacting consumers via cell phone, email and fax?
											</td>
											<td>0.94</td>
											<td>
												<select class="form-control park_west_point" id ="parkAF13" name="data[phone_policy]" disabled>
													
													<option park_west_val=0.94 park_west_max="0.94" <?php echo $park_west_data['phone_policy'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option park_west_val=0 park_west_max="0.94" <?php echo $park_west_data['phone_policy'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													<option park_west_val=0 park_west_max="0.94" <?php echo $park_west_data['phone_policy'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt23]" class="form-control" value="<?php echo $park_west_data['cmt23'] ?>"></td>
										</tr>
										<tr>
											<td colspan=2 class="text-danger">
												Adhere to policy regarding third parties for the sole purpose of obtaining location information for the consumer?
											</td>
											<td>0.94</td>
											<td>
												<select class="form-control park_west_point" id ="parkAF14"  name="data[adhere_policy]" disabled>
													
													<option park_west_val=0.94 park_west_max="0.94" <?php echo $park_west_data['adhere_policy'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option park_west_val=0 park_west_max="0.94" <?php echo $park_west_data['adhere_policy'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													<option park_west_val=0 park_west_max="0.94" <?php echo $park_west_data['adhere_policy'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt24]" class="form-control" value="<?php echo $park_west_data['cmt24'] ?>"></td>
										</tr>
										<tr>
											<td colspan=2 class="text-danger">
												Enter Status code/disposition codes correctly to ensure that inappropriate dialing does not take place?
											</td>
											<td>0.94</td>
											<td>
												<select class="form-control park_west_point" id ="parkAF15" name="data[status_code]" disabled>
													
													<option park_west_val=0.94 park_west_max="0.94" <?php echo $park_west_data['status_code'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option park_west_val=0 park_west_max="0.94" <?php echo $park_west_data['status_code'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													<option park_west_val=0 park_west_max="0.94" <?php echo $park_west_data['status_code'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt25]" class="form-control" value="<?php echo $park_west_data['cmt25'] ?>"></td>
										</tr>
										<tr>
											<td colspan=2 class="text-danger">
												Did not Make any statement that could constitute unfair, deceptive, or abusive acts or practices that may raise UDAAP concerns?
											</td>
											<td>0.94</td>
											<td>
												<select class="form-control park_west_point" id ="parkAF16"  name="data[abusive_acts]" disabled>
													
													<option park_west_val=0.94 park_west_max="0.94" <?php echo $park_west_data['abusive_acts'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option park_west_val=0 park_west_max="0.94" <?php echo $park_west_data['abusive_acts'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													<option park_west_val=0 park_west_max="0.94" <?php echo $park_west_data['abusive_acts'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt26]" class="form-control" value="<?php echo $park_west_data['cmt26'] ?>"></td>
										</tr>
										<tr>
											<td colspan=2 class="text-danger">
												Did not Communicate or threaten to communicate false credit information or information which should be known to be false and utilized the proper CBR script whenever a consumer enquires about that?
											</td>
											<td>0.94</td>
											<td>
												<select class="form-control park_west_point" id ="parkAF17" name="data[false_credit_information]" disabled>
													
													<option park_west_val=0.94 park_west_max="0.94" <?php echo $park_west_data['false_credit_information'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option park_west_val=0 park_west_max="0.94" <?php echo $park_west_data['false_credit_information'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													<option park_west_val=0 park_west_max="0.94" <?php echo $park_west_data['false_credit_information'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt27]" class="form-control" value="<?php echo $park_west_data['cmt27'] ?>"></td>
										</tr>
										<tr>
											<td colspan=2 class="text-danger">
												Handle the consumer's dispute correctly and take appropriate action including providing the consumer with the correct contact information to submit a written dispute or complaint, or offer to escalate the call?
											</td>
											<td>0.94</td>
											<td>
												<select class="form-control park_west_point" id ="parkAF18" name="data[take_appropriate_action]" disabled>
													
													<option park_west_val=0.94 park_west_max="0.94" <?php echo $park_west_data['take_appropriate_action'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option park_west_val=0 park_west_max="0.94" <?php echo $park_west_data['take_appropriate_action'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													<option park_west_val=0 park_west_max="0.94" <?php echo $park_west_data['take_appropriate_action'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt28]" class="form-control" value="<?php echo $park_west_data['cmt28'] ?>"></td>
										</tr>
										<tr>
											<td colspan=2 class="text-danger">
												Did not Make the disabled statement on time barred accounts, indicating that the consumer cannot be pursued with legal action?
											</td>
											<td>0.94</td>
											<td>
												<select class="form-control park_west_point" id ="parkAF19" name="data[pursue_leagal_action]" disabled>
													
													<option park_west_val=0.94 park_west_max="0.94" <?php echo $park_west_data['pursue_leagal_action'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option park_west_val=0 park_west_max="0.94" <?php echo $park_west_data['pursue_leagal_action'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													<option park_west_val=0 park_west_max="0.94" <?php echo $park_west_data['pursue_leagal_action'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt29]" class="form-control" value="<?php echo $park_west_data['cmt29'] ?>"></td>
										</tr>
										<tr>
											<td colspan=2 class="text-danger">
												Adhere to FDCPA  laws?
											</td>
											<td>0.94</td>
											<td>
												<select class="form-control park_west_point" id ="parkAF20" name="data[adhere_FDCPA]" disabled>
													
													<option park_west_val=0.94 park_west_max="0.94" <?php echo $park_west_data['adhere_FDCPA'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option park_west_val=0 park_west_max="0.94" <?php echo $park_west_data['adhere_FDCPA'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													<option park_west_val=0 park_west_max="0.94" <?php echo $park_west_data['adhere_FDCPA'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt30]" class="form-control" value="<?php echo $park_west_data['cmt30'] ?>"></td>
										</tr>
										<tr>
											<td colspan=2 class="text-danger">
												Did not Make any statement that could be considered discriminatory towards a consumer or a violation ECOA policy?
											</td>
											<td>0.94</td>
											<td>
												<select class="form-control park_west_point" id ="parkAF21" name="data[violation_ECOA_policy]" disabled>
													
													<option park_west_val=0.94 park_west_max="0.94" <?php echo $park_west_data['violation_ECOA_policy'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option park_west_val=0 park_west_max="0.94" <?php echo $park_west_data['violation_ECOA_policy'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													<option park_west_val=0 park_west_max="0.94" <?php echo $park_west_data['violation_ECOA_policy'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt31]" class="form-control" value="<?php echo $park_west_data['cmt31'] ?>"></td>
										</tr>
										<tr>
											<td colspan=2 class="text-danger">
												Did the collectors adhere to the State Restrictions?
											</td>
											<td>0.94</td>
											<td>
												<select class="form-control park_west_point" id ="parkAF22"name="data[adhere_state_restrictions]" disabled>
													
													<option park_west_val=0.94 park_west_max="0.94" <?php echo $park_west_data['adhere_state_restrictions'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option park_west_val=0 park_west_max="0.94" <?php echo $park_west_data['adhere_state_restrictions'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													<option park_west_val=0 park_west_max="0.94" <?php echo $park_west_data['adhere_state_restrictions'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt32]" class="form-control" value="<?php echo $park_west_data['cmt32'] ?>"></td>
										</tr>

										<tr>
											<td class="eml" rowspan=6>Payment Script</td>
											<td colspan=2>
												Confirm with consumer if he/she is the authorized user of the debit or credit card / checking account?
											</td>
											<td>1.67</td>
											<td rowspan=6>10%</td>
											<td>
												<select class="form-control park_west_point" id ="" name="data[authorized_user]" disabled>
													
													<option park_west_val=1.67 park_west_max="1.67" <?php echo $park_west_data['authorized_user'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option park_west_val=0 park_west_max="1.67" <?php echo $park_west_data['authorized_user'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													<option park_west_val=0 park_west_max="1.67" <?php echo $park_west_data['authorized_user'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt33]" class="form-control" value="<?php echo $park_west_data['cmt33'] ?>"></td>
										</tr>
										<tr>
											<td colspan=2>
												Recap the call by verifying consumer's Name, Address, CC/AP information?
											</td>
											<td>1.67</td>
											<td>
												<select class="form-control park_west_point" id ="" name="data[recap_call]" disabled>
													
													<option park_west_val=1.67 park_west_max="1.67" <?php echo $park_west_data['recap_call'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option park_west_val=0 park_west_max="1.67" <?php echo $park_west_data['recap_call'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													<option park_west_val=0 park_west_max="1.67" <?php echo $park_west_data['recap_call'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt34]" class="form-control" value="<?php echo $park_west_data['cmt34'] ?>"></td>
										</tr>
										<tr>
											<td colspan=2>
												Stated the proper payment script before processing payment?
											</td>
											<td>1.67</td>
											<td>
												<select class="form-control park_west_point" id ="" name="data[proper_payment_script]" disabled>
													
													<option park_west_val=1.67 park_west_max="1.67" <?php echo $park_west_data['proper_payment_script'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option park_west_val=0 park_west_max="1.67" <?php echo $park_west_data['proper_payment_script'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													<option park_west_val=0 park_west_max="1.67" <?php echo $park_west_data['proper_payment_script'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt35]" class="form-control" value="<?php echo $park_west_data['cmt35'] ?>"></td>
										</tr>
										<tr>
											<td colspan=2 class="text-danger">
												Obtain permission from the consumer to initiate electronic credit /debit card transactions or through checking account and get supervisor verification if needed?**SQ**
											</td>
											<td>1.67</td>
											<td>
												<select class="form-control park_west_point" id ="parkAF24" name="data[permission_from_customer]" disabled>
													
													<option park_west_val=1.67 park_west_max="1.67" <?php echo $park_west_data['permission_from_customer'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option park_west_val=0 park_west_max="1.67" <?php echo $park_west_data['permission_from_customer'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													<option park_west_val=0 park_west_max="1.67" <?php echo $park_west_data['permission_from_customer'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt36]" class="form-control" value="<?php echo $park_west_data['cmt36'] ?>"></td>
										</tr>
										<tr>
											<td colspan=2>
												Educate the consumer about correspondence being sent (Receipts, PIF, SIF, Confirmations, etc)?
											</td>
											<td>1.67</td>
											<td>
												<select class="form-control park_west_point" id ="" name="data[educate_customer]" disabled>
													
													<option park_west_val=1.67 park_west_max="1.67" <?php echo $park_west_data['educate_customer'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option park_west_val=0 park_west_max="1.67" <?php echo $park_west_data['educate_customer'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													<option park_west_val=0 park_west_max="1.67" <?php echo $park_west_data['educate_customer'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt37]" class="form-control" value="<?php echo $park_west_data['cmt37'] ?>"></td>
										</tr>
										<tr>
											<td colspan=2>
												In case of PDCs, did the Collector asks for permission to call the Consumer back if it is declined or there is an issue with the payment? 
											</td>
											<td>1.67</td>
											<td>
												<select class="form-control park_west_point" id ="" name="data[consumer_callback]" disabled>
													
													<option park_west_val=1.67 park_west_max="1.67" <?php echo $park_west_data['consumer_callback'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option park_west_val=0 park_west_max="1.67" <?php echo $park_west_data['consumer_callback'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													<option park_west_val=0 park_west_max="1.67" <?php echo $park_west_data['consumer_callback'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt38]" class="form-control" value="<?php echo $park_west_data['cmt38'] ?>"></td>
										</tr>

										<tr>
											<td class="eml" rowspan=4>Call Control</td>
											<td colspan=2>
												Demonstrate Active Listening?
											</td>
											<td>2.50</td>
											<td rowspan=4>10%</td>
											<td>
												<select class="form-control park_west_point" id ="" name="data[active_listening]" disabled>
													
													<option park_west_val=2.5 park_west_max="2.5" <?php echo $park_west_data['active_listening'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option park_west_val=0 park_west_max="2.5" <?php echo $park_west_data['active_listening'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													<option park_west_val=0 park_west_max="2.5" <?php echo $park_west_data['active_listening'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt39]" class="form-control" value="<?php echo $park_west_data['cmt39'] ?>"></td>
										</tr>
										<tr>
											<td colspan=2>
												Represent the company and the client in a positive manner?
											</td>
											<td>2.50</td>
											<td>
												<select class="form-control park_west_point" id ="" name="data[positive_manner]" disabled>
													
													<option park_west_val=2.5 park_west_max="2.5" <?php echo $park_west_data['positive_manner'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option park_west_val=0 park_west_max="2.5" <?php echo $park_west_data['positive_manner'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													<option park_west_val=0 park_west_max="2.5" <?php echo $park_west_data['positive_manner'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt40]" class="form-control" value="<?php echo $park_west_data['cmt40'] ?>"></td>
										</tr>
										<tr>
											<td colspan=2>
												Anticipate and overcome objections?
											</td>
											<td>2.50</td>
											<td>
												<select class="form-control park_west_point" id ="" name="data[overcome_objections]" disabled>
													
													<option park_west_val=2.5 park_west_max="2.5" <?php echo $park_west_data['overcome_objections'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option park_west_val=0 park_west_max="2.5" <?php echo $park_west_data['overcome_objections'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													<option park_west_val=0 park_west_max="2.5" <?php echo $park_west_data['overcome_objections'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt41]" class="form-control" value="<?php echo $park_west_data['cmt41'] ?>"></td>
										</tr>
										<tr>
											<td colspan=2>
												Transfer call to My Quick Wallet's support appropriately (if applicable)?
											</td>
											<td>2.50</td>
											<td>
												<select class="form-control park_west_point" id ="" name="data[transfer_call]" disabled>
													
													<option park_west_val=2.5 park_west_max="2.5" <?php echo $park_west_data['transfer_call'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option park_west_val=0 park_west_max="2.5" <?php echo $park_west_data['transfer_call'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													<option park_west_val=0 park_west_max="2.5" <?php echo $park_west_data['transfer_call'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt42]" class="form-control" value="<?php echo $park_west_data['cmt42'] ?>"></td>
										</tr>
										<tr>
											<td class="eml" rowspan=4>Closing</td>
											<td colspan=2>
												Summarize the call?
											</td>
											<td>1.50</td>
											<td rowspan=4>6%</td>
											<td>
												<select class="form-control park_west_point" id ="" name="data[summarize_call]" disabled>
													
													<option park_west_val=1.5 park_west_max="1.5" <?php echo $park_west_data['summarize_call'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option park_west_val=0 park_west_max="1.5" <?php echo $park_west_data['summarize_call'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													<option park_west_val=0 park_west_max="1.5" <?php echo $park_west_data['summarize_call'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt43]" class="form-control" value="<?php echo $park_west_data['cmt43'] ?>"></td>
										</tr>
										<tr>
											<td colspan=2>
												Provided My Quick Wallet's support number incase its disabled (if applicable)?
											</td>
											<td>1.50</td>
											<td>
												<select class="form-control park_west_point" id ="" name="data[support_wallet]" disabled>
													
													<option park_west_val=1.5 park_west_max="1.5" <?php echo $park_west_data['support_wallet'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option park_west_val=0 park_west_max="1.5" <?php echo $park_west_data['support_wallet'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													<option park_west_val=0 park_west_max="1.5" <?php echo $park_west_data['support_wallet'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt44]" class="form-control" value="<?php echo $park_west_data['cmt44'] ?>"></td>
										</tr>
										<tr>
											<td colspan=2>
												Set appropriate timelines and expectations for follow up?
											</td>
											<td>1.50</td>
											<td>
												<select class="form-control park_west_point" id ="" name="data[follow_up]" disabled>
													
													<option park_west_val=1.5 park_west_max="1.5" <?php echo $park_west_data['follow_up'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option park_west_val=0 park_west_max="1.5" <?php echo $park_west_data['follow_up'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													<option park_west_val=0 park_west_max="1.5" <?php echo $park_west_data['follow_up'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt45]" class="form-control" value="<?php echo $park_west_data['cmt45'] ?>"></td>
										</tr>
										<tr>
											<td colspan=2>
												Close the call Professionally?
											</td>
											<td>1.50</td>
											<td>
												<select class="form-control park_west_point" id ="" name="data[close_call_professionally]" disabled>
													
													<option park_west_val=1.5 park_west_max="1.5" <?php echo $park_west_data['close_call_professionally'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option park_west_val=0 park_west_max="1.5" <?php echo $park_west_data['close_call_professionally'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													<option park_west_val=0 park_west_max="1.5" <?php echo $park_west_data['close_call_professionally'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt46]" class="form-control" value="<?php echo $park_west_data['cmt46'] ?>"></td>
										</tr>

										<tr>
											<td class="eml" rowspan=8>Documentation</td>
											<td colspan=2>
												Use the proper action code?
											</td>
											<td>1.88</td>
											<td rowspan=8>15%</td>
											<td>
												<select class="form-control park_west_point" id ="" name="data[proper_action_code]" disabled>
													
													<option park_west_val=1.88 park_west_max="1.88" <?php echo $park_west_data['proper_action_code'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option park_west_val=0 park_west_max="1.88" <?php echo $park_west_data['proper_action_code'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													<option park_west_val=0 park_west_max="1.88" <?php echo $park_west_data['proper_action_code'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt47]" class="form-control" value="<?php echo $park_west_data['cmt47'] ?>"></td>
										</tr>
										<tr>
											<td colspan=2 class="text-danger">
												Use the proper result code?
											</td>
											<td>1.88</td>
											<td>
												<select class="form-control park_west_point" id ="parkAF25" name="data[proper_result_code]" disabled>
													
													<option park_west_val=1.88 park_west_max="1.88" <?php echo $park_west_data['proper_result_code'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option park_west_val=0 park_west_max="1.88" <?php echo $park_west_data['proper_result_code'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													<option park_west_val=0 park_west_max="1.88" <?php echo $park_west_data['proper_result_code'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt48]" class="form-control" value="<?php echo $park_west_data['cmt48'] ?>"></td>
										</tr>
										<tr>
											<td colspan=2 class="text-danger">
												Document thoroughly the context of the conversation?
											</td>
											<td>1.88</td>
											<td>
												<select class="form-control park_west_point" id ="parkAF26" name="data[document_thoroughly]" disabled>
													
													<option park_west_val=1.88 park_west_max="1.88" <?php echo $park_west_data['document_thoroughly'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option park_west_val=0 park_west_max="1.88" <?php echo $park_west_data['document_thoroughly'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													<option park_west_val=0 park_west_max="1.88" <?php echo $park_west_data['document_thoroughly'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt49]" class="form-control" value="<?php echo $park_west_data['cmt49'] ?>"></td>
										</tr>
										<tr>
											<td colspan=2>
												Did the rep document the callback permission on the account as per Reg F policy?
											</td>
											<td>1.88</td>
											<td>
												<select class="form-control park_west_point" id ="" name="data[document_callback]" disabled>
													
													<option park_west_val=1.88 park_west_max="1.88" <?php echo $park_west_data['document_callback'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option park_west_val=0 park_west_max="1.88" <?php echo $park_west_data['document_callback'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													<option park_west_val=0 park_west_max="1.88" <?php echo $park_west_data['document_callback'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt50]" class="form-control" value="<?php echo $park_west_data['cmt50'] ?>"></td>
										</tr>
										<tr>
											<td colspan=2 class="text-danger">
												Remove any phone numbers known to be incorrect?**SQ**
											</td>
											<td>1.88</td>
											<td>
												<select class="form-control park_west_point" id ="parkAF27" name="data[remove_phone_no]" disabled>
													
													<option park_west_val=1.88 park_west_max="1.88" <?php echo $park_west_data['remove_phone_no'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option park_west_val=0 park_west_max="1.88" <?php echo $park_west_data['remove_phone_no'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													<option park_west_val=0 park_west_max="1.88" <?php echo $park_west_data['remove_phone_no'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt51]" class="form-control" value="<?php echo $park_west_data['cmt51'] ?>"></td>
										</tr>
										<tr>
											<td colspan=2 class="text-danger">
												Update address information if appropriate?**SQ**
											</td>
											<td>1.88</td>
											<td>
												<select class="form-control park_west_point" id ="parkAF28" name="data[update_address_information]" disabled>
													
													<option park_west_val=1.88 park_west_max="1.88" <?php echo $park_west_data['update_address_information'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option park_west_val=0 park_west_max="1.88" <?php echo $park_west_data['update_address_information'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													<option park_west_val=0 park_west_max="1.88" <?php echo $park_west_data['update_address_information'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt52]" class="form-control" value="<?php echo $park_west_data['cmt52'] ?>"></td>
										</tr>
										<tr>
											<td colspan=2 class="text-danger">
												Change the status of the account, if appropriate?**SQ**
											</td>
											<td>1.88</td>
											<td>
												<select class="form-control park_west_point" id ="parkAF29" name="data[change_status]" disabled>
													
													<option park_west_val=1.88 park_west_max="1.88" <?php echo $park_west_data['change_status'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option park_west_val=0 park_west_max="1.88" <?php echo $park_west_data['change_status'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													<option park_west_val=0 park_west_max="1.88" <?php echo $park_west_data['change_status'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt53]" class="form-control" value="<?php echo $park_west_data['cmt53'] ?>"></td>
										</tr>
										<tr>
											<td colspan=2>
												Escalate the account to a supervisor for handling, if appropriate?
											</td>
											<td>1.88</td>
											<td>
												<select class="form-control park_west_point" id ="" name="data[escalate_account]" disabled>
													
													<option park_west_val=1.88 park_west_max="1.88" <?php echo $park_west_data['escalate_account'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option park_west_val=0 park_west_max="1.88" <?php echo $park_west_data['escalate_account'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													<option park_west_val=0 park_west_max="1.88" <?php echo $park_west_data['escalate_account'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt54]" class="form-control" value="<?php echo $park_west_data['cmt54'] ?>"></td>
										</tr>

										<tr>
											<td>Call Summary:</td>
											<td colspan=2><textarea class="form-control" name="data[call_summary]"><?php echo $park_west_data['call_summary'] ?></textarea></td>
											<td>Feedback:</td>
											<td colspan=4><textarea class="form-control" name="data[feedback]"><?php echo $park_west_data['feedback'] ?></textarea></td>
										</tr>
										
										<?php if($park_west_data['attach_file']!=''){ ?>
									<tr oncontextmenu="return false;">
										<td colspan="2">Audio Files (Mp4/Mp3/M4a/Wav)</td>
										<td colspan="4">
											<?php $attach_file = explode(",",$park_west_data['attach_file']);
											 foreach($attach_file as $af){ ?>
												<audio oncontextmenu="return false;" controls controlslist="nodownload" style="background-color:#607F93">
													  <source src="<?php echo base_url(); ?>qa_files/park_west/qa_audio_files/<?php echo $af; ?>" type="audio/ogg">
													  <source src="<?php echo base_url(); ?>qa_files/park_west/qa_audio_files/<?php echo $af; ?>" type="audio/mpeg">
												</audio> </br>
											 <?php } ?>
										</td>
									</tr>
									<?php } ?>

									<tr>
										<td style="font-size:12px">Manager Review:</td>
										<td colspan="8" style="text-align:left"><?php echo $park_west_data['mgnt_rvw_note'] ?></td>
									</tr>
									<tr>
										<td style="font-size:12px">Client Review:</td>
										<td colspan="8" style="text-align:left"><?php echo $park_west_data['client_rvw_note'] ?></td>
									</tr>

									<tr><td colspan="10" style="background-color:#C5C8C8"></td></tr>
									
									 <form id="form_agent_user" method="POST" action="">
										<input type="hidden" name="park_west_id" class="form-control" value="<?php echo $park_west_id; ?>">
										
										<tr>
											<td colspan=2 style="font-size:16px">Feedback Acceptance<span style="font-size:24px;color:red">*</span></td>
											<td colspan=6>
												<select class="form-control" id="" name="agnt_fd_acpt" required="">
													<option value="">--Select--</option>
													<option <?php echo $park_west_data['agnt_fd_acpt']=='Acceptance'?"selected":""; ?> value="Acceptance">Acceptance</option>	
													<option <?php echo $park_west_data['agnt_fd_acpt']=='Not Acceptance'?"selected":""; ?> value="Not Acceptance">Not Acceptance</option>	
												</select>
											</td>
										</tr>
										<tr>
											<td colspan=2 style="font-size:16px">Your Review<span style="font-size:24px;color:red">*</span></td>
											<td colspan=6><textarea class="form-control" name="note" required><?php echo $park_west_data['agent_rvw_note'] ?></textarea></td>
										</tr>
										
										<?php if(is_access_qa_agent_module()==true){
										if(is_available_qa_feedback($park_west_data['entry_date'],72) == true){ ?>
											<tr>
												<?php if($park_west_data['agent_rvw_note']==''){ ?>
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