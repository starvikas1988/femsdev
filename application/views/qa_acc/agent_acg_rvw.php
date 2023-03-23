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
	.new-section
	{
		margin-top: -18px;
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
											<td colspan="6" id="theader" style="font-size:40px">ACG QA FORM Agent</td>
											<input type="hidden" name="audit_start_time" value="<?php echo CurrMySqlDate(); ?>">
										</tr>
										
										<tr>
											<td>QA Name:</td>
											<?php if ($agent_acg_rvw['entry_by'] != '') {
												$auditorName = $agent_acg_rvw['auditor_name'];
											} else {
												$auditorName = $agent_acg_rvw['client_name'];
											} ?>
											<td style="width: 230px;"><input type="text" class="form-control" value="<?php echo $auditorName; ?>" disabled></td>
											<td>Audit Date:.</td>
											<td style="width:230px;"><input type="text" class="form-control" value="<?php echo mysql2mmddyy($agent_acg_rvw['audit_date']); ?>" disabled></td>
											<td>Call Date:.</td>
											<td colspan="2"><input type="text" class="form-control" value="<?php echo mysql2mmddyy($agent_acg_rvw['call_date']); ?>" disabled></td>
										</tr>

										<tr>
											<td>Agent Name:.</td>
											<td>
												<select class="form-control" id="agent_id" name="data[agent_id]" disabled>
													<option value="<?php echo $agent_acg_rvw['agent_id'] ?>"><?php echo $agent_acg_rvw['fname'] . " " . $agent_acg_rvw['lname'] ?></option>
												</select>
											</td>
											<td>Fusion ID:.</td>
											<td><input type="text" class="form-control" id="fusion_id" value="<?php echo $agent_acg_rvw['fusion_id'] ?>" readonly></td>
											<td>L1 Supervisor:.</td>
											<td colspan="2">
												<select class="form-control" id="tl_id" name="data[tl_id]" readonly>
													<option value="<?php echo $agent_acg_rvw['tl_id'] ?>"><?php echo $agent_acg_rvw['tl_name'] ?></option>
												</select>
											</td>
										</tr>
										<tr>
											<td>ACPT:<span style="font-size:24px;color:red">*</span></td>
											<td>
												<select class="form-control" id="" name="data[acpt]" disabled>
											
											    <option value="">-Select-</option>
											    <option value="Agent" <?= ($agent_acg_rvw['acpt']=="Agent")?"selected":"" ?>>Agent</option>
												<option value="Customer" <?= ($agent_acg_rvw['acpt']=="Customer")?"selected":"" ?>>Customer</option>
												<option value="Process" <?= ($agent_acg_rvw['acpt']=="Process")?"selected":"" ?>>Process</option>
												<option value="Technical" <?= ($agent_acg_rvw['acpt']=="Technical")?"selected":"" ?>>Technical</option>
												<option value="NA" <?= ($agent_acg_rvw['acpt']=="NA")?"selected":"" ?>>NA</option>
											
										</select>
											</td>
											<td>Phone Number:</td>
											<td><input type="text" class="form-control" name="data[phone]" value="<?php echo $agent_acg_rvw['phone'] ?>" disabled></td>

											<td>Type of Audit:<span style="font-size:24px;color:red">*</span></td>
											<td>
												<input type="text" class="form-control" name="data[type_of_audit]" value="<?php echo $agent_acg_rvw['type_of_audit'] ?>" disabled>
											</td>
										</tr>
										<tr>
											<td>Call ID <span style="font-size:24px;color:red">*</span></td>
											<td>
												<input type="text" class="form-control" name="data[call_id]" value="<?php echo $agent_acg_rvw['call_id'] ?>" disabled>
											</td>
											<td>L1<span style="font-size:24px;color:red">*</span></td>
											<td>
												<input type="text" class="form-control" name="data[l1]" value="<?php echo $agent_acg_rvw['l1'] ?>" disabled>
											</td>
											<td>L2<span style="font-size:24px;color:red">*</span></td>
											<td>
												<input type="text" class="form-control" name="data[l2]" value="<?php echo $agent_acg_rvw['l2'] ?>" disabled>
											</td>
											
										</tr>
										<tr>
											
											<td>VOC:<span style="font-size:24px;color:red">*</span></td>
											<td>
												<select class="form-control" id="voc" name="data[voc]" disabled>
													
													<option value="">-Select-</option>
													<option value="1"  <?= ($agent_acg_rvw['voc']=="1")?"selected":"" ?>>1</option>
													<option value="2"  <?= ($agent_acg_rvw['voc']=="2")?"selected":"" ?>>2</option>
													<option value="3"  <?= ($agent_acg_rvw['voc']=="3")?"selected":"" ?>>3</option>
													<option value="4"  <?= ($agent_acg_rvw['voc']=="4")?"selected":"" ?>>4</option>
													<option value="5"  <?= ($agent_acg_rvw['voc']=="5")?"selected":"" ?>>5</option>
													<option value="6"  <?= ($agent_acg_rvw['voc']=="6")?"selected":"" ?>>6</option>
													<option value="7"  <?= ($agent_acg_rvw['voc']=="7")?"selected":"" ?>>7</option>
													<option value="8"  <?= ($agent_acg_rvw['voc']=="8")?"selected":"" ?>>8</option>
													<option value="9"  <?= ($agent_acg_rvw['voc']=="9")?"selected":"" ?>>9</option>
													<option value="10"  <?= ($agent_acg_rvw['voc']=="10")?"selected":"" ?>>10</option>
												</select>
											</td>
											<td>Audit Type:<span style="font-size:24px;color:red">*</span></td>
											<td>
												<select class="form-control" id="audit_type" name="data[audit_type]" disabled>
                                                    <option value="">-Select-</option>
                                                    <option value="CQ Audit" <?= ($agent_acg_rvw['audit_type']=="CQ Audit")?"selected":"" ?>>CQ Audit</option>
                                                    <option value="BQ Audit" <?= ($agent_acg_rvw['audit_type']=="BQ Audit")?"selected":"" ?>>BQ Audit</option>
                                                    <option value="Calibration" <?= ($agent_acg_rvw['audit_type']=="Calibration")?"selected":"" ?>>Calibration</option>
                                                    <option value="Pre-Certificate Mock Call" <?= ($agent_acg_rvw['audit_type']=="Pre-Certificate Mock Call")?"selected":"" ?>>Pre-Certificate Mock Call</option>
                                                    <option value="Certification Audit" <?= ($agent_acg_rvw['audit_type']=="Certification Audit")?"selected":"" ?>>Certification Audit</option>
                                                    <option value="Operation Audit" <?= ($agent_acg_rvw['audit_type']=="Operation Audit")?"selected":"" ?>>Operation Audit</option>
                                                    <option value="Trainer Audit"  <?= ($agent_acg_rvw['audit_type']=="Trainer Audit")?"selected":"" ?>>Trainer Audit</option>
                                                </select>
											</td>
											<td class="auType_epi">Auditor Type<span style="font-size:24px;color:red">*</span></td>
											<td class="auType_epi">
												<select class="form-control" id="auditor_type" name="data[auditor_type]" disabled>
                                                    
                                                    <option value="Master" <?= ($agent_acg_rvw['auditor_type']=="Master")?"selected":"" ?>>Master</option>
                                                    <option value="Regular" <?= ($agent_acg_rvw['auditor_type']=="Regular")?"selected":"" ?>>Regular</option>
                                                </select>
											</td>
										</tr>
										<tr>
											<td style="font-weight:bold; font-size:16px; text-align:left">Earned Score</td>
											<td><input type="text" readonly id="acg_earned_score" name="data[earned_score]" class="form-control" value="<?php echo $agent_acg_rvw['earned_score'] ?>" /></td>
											<td style="font-weight:bold; font-size:16px; text-align:left">Possible Score</td>
											<td><input type="text" readonly id="acg_possible_score" name="data[possible_score]" class="form-control" value="<?php echo $agent_acg_rvw['possible_score'] ?>" /></td>
											<td style="font-weight:bold; font-size:16px; text-align:right">Overall Score:</td>
											<td><input type="text" readonly id="acg_overall_score" name="data[overall_score]" class="form-control avonFatal" style="font-weight:bold" value="<?php echo $agent_acg_rvw['overall_score'] ?>"></td>
										</tr>
										</table>
										</div>
										<div class="table-responsive new-section">
								<table class="table table-striped skt-table" width="100%">
										<tr class="eml" style="height:25px; font-weight:bold">
											<td>PARAMETER</td>
											<td colspan=2>SUB PARAMETER</td>
											<td>WEIGHTAGE</td>
											<td>STATUS</td>
											<td colspan=2>REMARKS</td>
										</tr>

										<tr>
											<td class="eml" rowspan=3>Opening</td>
											<td colspan=2>Did the agent greeted the customer while opening the call?</td>
											<td>4</td>
											<td>
												<select class="form-control acg_point compliance" name="data[opening_call]" disabled>
													
													<option acg_val=4 <?php echo $agent_acg_rvw['opening_call'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option acg_val=0 <?php echo $agent_acg_rvw['opening_call'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													<option acg_val=0 <?php echo $agent_acg_rvw['opening_call'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt1]" class="form-control" value="<?php echo $agent_acg_rvw['cmt1'] ?>" disabled></td>
										</tr>
										<tr>
											<td colspan=2>Did the  agent mentioned his name and the brand name on call?</td>
											<td>4</td>
											<td>
												<select class="form-control acg_point compliance" name="data[brand_name]" disabled>
													
													<option acg_val=4 <?php echo $agent_acg_rvw['brand_name'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option acg_val=0 <?php echo $agent_acg_rvw['brand_name'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													<option acg_val=0 <?php echo $agent_acg_rvw['brand_name'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt2]" class="form-control" value="<?php echo $agent_acg_rvw['cmt2'] ?>" disabled></td>
										</tr>

										<tr>
											<td colspan="2" class="text-danger">Did the agent mentioned that the customer is on a recorded line?</td>
											<td>5</td>
											<td>
												<select class="form-control acg_point acg_fatal" name="data[recorded_line]" disabled>
													
													<option acg_val=5 <?= $agent_acg_rvw["recorded_line"] == "Pass" ? "selected" : "" ?> value="Pass">Pass</option>
													<option acg_val=0 <?= $agent_acg_rvw["recorded_line"] == "Fail" ? "selected" : "" ?> value="Fail">Fail</option>
													<option acg_val=0 <?= $agent_acg_rvw["recorded_line"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt3]" class="form-control" value="<?php echo $agent_acg_rvw['cmt3'] ?>" disabled></td>
										</tr>

										<tr>
											<td class="eml" rowspan=3>Communication</td>
											<td colspan=2>Agent had proper rate of speech on call?</td>
											<td>4</td>
											<td>
												<select class="form-control acg_point" name="data[rate_of_speech]" disabled>
													
													<option acg_val=4 <?php echo $agent_acg_rvw['rate_of_speech'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option acg_val=0 <?php echo $agent_acg_rvw['rate_of_speech'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													<option acg_val=0 <?php echo $agent_acg_rvw['rate_of_speech'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt4]" class="form-control" value="<?php echo $agent_acg_rvw['cmt4'] ?>" disabled></td>
										</tr>

										<tr>
											<td colspan=2>Agent didn’t overlapped the customer while speaking?</td>
											<td>4</td>
											<td>
												<select class="form-control acg_point" name="data[overlapped_customer]" disabled>
													
													<option acg_val=4 <?php echo $agent_acg_rvw['overlapped_customer'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option acg_val=0 <?php echo $agent_acg_rvw['overlapped_customer'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													<option acg_val=0 <?php echo $agent_acg_rvw['overlapped_customer'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt5]" class="form-control" value="<?php echo $agent_acg_rvw['cmt5'] ?>" disabled></td>
										</tr>

										<tr>
											<td  colspan="2">Agent sounded energrtic and confident on call?</td>
											<td>4</td>
											<td>
												<select class="form-control acg_point" name="data[energrtic]" disabled>
													
													<option acg_val=4 <?= $agent_acg_rvw["energrtic"] == "Pass" ? "selected" : "" ?> value="Pass">Pass</option>
													<option acg_val=0 <?= $agent_acg_rvw["energrtic"] == "Fail" ? "selected" : "" ?> value="Fail">Fail</option>
													<option acg_val=0 <?= $agent_acg_rvw["energrtic"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt6]" class="form-control" value="<?php echo $agent_acg_rvw['cmt6'] ?>" disabled></td>
										</tr>
										<tr>
											<td class="eml" rowspan=6>Call Handling</td>
											<td colspan="2">Agent asked permission before putting the call on hold?</td>
											<td>3</td>
											<td>
												<select class="form-control acg_point customer" name="data[call_on_hold]" disabled>
												
													<option acg_val=3 <?= $agent_acg_rvw["call_on_hold"] == "Pass" ? "selected" : "" ?> value="Pass">Pass</option>
													<option acg_val=0 <?= $agent_acg_rvw["call_on_hold"] == "Fail" ? "selected" : "" ?> value="Fail">Fail</option>
													<option acg_val=0 <?= $agent_acg_rvw["call_on_hold"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt7]" class="form-control" value="<?php echo $agent_acg_rvw['cmt7'] ?>" disabled></td>
										</tr>
										<tr>
											<td colspan="2">Agent mentioned the reason for putting the customer on hold</td>
											<td>3</td>
											<td>
												<select class="form-control acg_point customer" name="data[call_on_hold_reason]" disabled>
												
													<option acg_val=3 <?= $agent_acg_rvw["call_on_hold_reason"] == "Pass" ? "selected" : "" ?> value="Pass">Pass</option>
													<option acg_val=0 <?= $agent_acg_rvw["call_on_hold_reason"] == "Fail" ? "selected" : "" ?> value="Fail">Fail</option>
													<option acg_val=0 <?= $agent_acg_rvw["call_on_hold_reason"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt8]" class="form-control" value="<?php echo $agent_acg_rvw['cmt8'] ?>" disabled></td>
										</tr>
										<tr>
											<td colspan="2">Agent thanked the customer after resuming the call from hold</td>
											<td>3</td>
											<td>
												<select class="form-control acg_point" name="data[call_on_hold_resume]" disabled>
												
													<option acg_val=3 <?= $agent_acg_rvw["call_on_hold_resume"] == "Pass" ? "selected" : "" ?> value="Pass">Pass</option>
													<option acg_val=0 <?= $agent_acg_rvw["call_on_hold_resume"] == "Fail" ? "selected" : "" ?> value="Fail">Fail</option>
													<option acg_val=0 <?= $agent_acg_rvw["call_on_hold_resume"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt9]" class="form-control" value="<?php echo $agent_acg_rvw['cmt9'] ?>" disabled></td>
										</tr>

										<tr>
											<td colspan="2">Agent was able to answer all the customer query and handle the objection</td>
											<td>4</td>
											<td>
												<select class="form-control acg_point" name="data[customer_query]" disabled>
												
													<option acg_val=4 <?= $agent_acg_rvw["customer_query"] == "Pass" ? "selected" : "" ?> value="Pass">Pass</option>
													<option acg_val=0 <?= $agent_acg_rvw["customer_query"] == "Fail" ? "selected" : "" ?> value="Fail">Fail</option>
													<option acg_val=0 <?= $agent_acg_rvw["customer_query"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt10]" class="form-control" value="<?php echo $agent_acg_rvw['cmt10'] ?>" disabled></td>
										</tr>
										<tr>
											<td colspan="2" class="text-danger">Did the agent pause the recording when collecting the SSN-DOB-CC?</td>
											<td>5</td>
											<td>
												<select class="form-control acg_point acg_fatal" name="data[pause_recording_ssn]" disabled>
												
													<option acg_val=5 <?= $agent_acg_rvw["pause_recording_ssn"] == "Pass" ? "selected" : "" ?> value="Pass">Pass</option>
													<option acg_val=0 <?= $agent_acg_rvw["pause_recording_ssn"] == "Fail" ? "selected" : "" ?> value="Fail">Fail</option>
													<option acg_val=0 <?= $agent_acg_rvw["pause_recording_ssn"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt11]" class="form-control" value="<?php echo $agent_acg_rvw['cmt11'] ?>" disabled></td>
										</tr>
										<tr>
											<td colspan="2">Agent created right amount of urgency on call to convert the call into sales</td>
											<td>3</td>
											<td>
												<select class="form-control acg_point" name="data[convert_call_sales]" disabled>
												
													<option acg_val=3 <?= $agent_acg_rvw["convert_call_sales"] == "Pass" ? "selected" : "" ?> value="Pass">Pass</option>
													<option acg_val=0 <?= $agent_acg_rvw["convert_call_sales"] == "Fail" ? "selected" : "" ?> value="Fail">Fail</option>
													<option acg_val=0 <?= $agent_acg_rvw["convert_call_sales"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt12]" class="form-control" value="<?php echo $agent_acg_rvw['cmt12'] ?>" disabled></td>
										</tr>

										<tr>
											<td class="eml" rowspan=13>Mandatory Information</td>
											<td colspan="2">Did the agent properly mentioned the pricing and tenurity of the plan?</td>
											<td>3</td>
											<td>
												<select class="form-control acg_point" name="data[pricing_tenurity]" disabled>
											
													<option acg_val=3 <?= $agent_acg_rvw["pricing_tenurity"] == "Pass" ? "selected" : "" ?> value="Pass">Pass</option>
													<option acg_val=0 <?= $agent_acg_rvw["pricing_tenurity"] == "Fail" ? "selected" : "" ?> value="Fail">Fail</option>
													<option acg_val=0 <?= $agent_acg_rvw["pricing_tenurity"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt13]" class="form-control" value="<?php echo $agent_acg_rvw['cmt13'] ?>" disabled></td>
										</tr>
										<tr>
											<td colspan="2">Did the agent suggested the right plan to the customer?</td>
											<td>3</td>
											<td>
												<select class="form-control acg_point" name="data[right_plan_suggestion]" disabled>
										
													<option acg_val=3 <?= $agent_acg_rvw["right_plan_suggestion"] == "Pass" ? "selected" : "" ?> value="Pass">Pass</option>
													<option acg_val=0 <?= $agent_acg_rvw["right_plan_suggestion"] == "Fail" ? "selected" : "" ?> value="Fail">Fail</option>
													<option acg_val=0 <?= $agent_acg_rvw["right_plan_suggestion"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt14]" class="form-control" value="<?php echo $agent_acg_rvw['cmt14'] ?>" disabled></td>
										</tr>
										<tr>
											<td colspan="2">Did the agent explained what the plan would cover and also complete features of the plan?</td>
											<td>3</td>
											<td>
												<select class="form-control acg_point" name="data[plan_cover]" disabled>
													<option acg_val=3 <?= $agent_acg_rvw["plan_cover"] == "Pass" ? "selected" : "" ?> value="Pass">Pass</option>
													<option acg_val=0 <?= $agent_acg_rvw["plan_cover"] == "Fail" ? "selected" : "" ?> value="Fail">Fail</option>
													<option acg_val=0 <?= $agent_acg_rvw["plan_cover"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt15]" class="form-control" value="<?php echo $agent_acg_rvw['cmt15'] ?>" disabled></td>
										</tr>
										<tr>
											<td colspan="2" class="text-danger">Did the agent offer at least 1 digital option to the customer prior to offering the Automated Verbal Approval?</td>
											<td>4</td>
											<td>
												<select class="form-control acg_point acg_fatal" name="data[least_one_digital_option]" disabled>
													<option acg_val=4 <?= $agent_acg_rvw["least_one_digital_option"] == "Pass" ? "selected" : "" ?> value="Pass">Pass</option>
													<option acg_val=0 <?= $agent_acg_rvw["least_one_digital_option"] == "Fail" ? "selected" : "" ?> value="Fail">Fail</option>
													<option acg_val=0 <?= $agent_acg_rvw["least_one_digital_option"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt16]" class="form-control" value="<?php echo $agent_acg_rvw['cmt16'] ?>" disabled></td>
										</tr>

										<tr>
											<td colspan="2" class="text-danger">Did the agent inform the customer about emailing the order summary and that this is accessible at xfinity.com/MyAccount?</td>
											<td>4</td>
											<td>
												<select class="form-control acg_point acg_fatal" name="data[email_order_summary]" disabled>
													<option acg_val=4 <?= $agent_acg_rvw["email_order_summary"] == "Pass" ? "selected" : "" ?> value="Pass">Pass</option>
													<option acg_val=0 <?= $agent_acg_rvw["email_order_summary"] == "Fail" ? "selected" : "" ?> value="Fail">Fail</option>
													<option acg_val=0 <?= $agent_acg_rvw["email_order_summary"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt17]" class="form-control" value="<?php echo $agent_acg_rvw['cmt17'] ?>" disabled></td>
										</tr>
										<tr>
											<td colspan="2" class="text-danger">Did the agent inform about Auto IVR reviewing the order summary?</td>
											<td>4</td>
											<td>
												<select class="form-control acg_point acg_fatal" name="data[auto_IVR_reviewing]" disabled>
													<option acg_val=4 <?= $agent_acg_rvw["auto_IVR_reviewing"] == "Pass" ? "selected" : "" ?> value="Pass">Pass</option>
													<option acg_val=0 <?= $agent_acg_rvw["auto_IVR_reviewing"] == "Fail" ? "selected" : "" ?> value="Fail">Fail</option>
													<option acg_val=0 <?= $agent_acg_rvw["auto_IVR_reviewing"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt18]" class="form-control" value="<?php echo $agent_acg_rvw['cmt18'] ?>" disabled></td>
										</tr>
										<tr>
											<td colspan="2" class="text-danger">Did the agent inform customer to press 1 for approval?</td>
											<td>4</td>
											<td>
												<select class="form-control acg_point acg_fatal" name="data[press_one_approval]" disabled>
													<option acg_val=4 <?= $agent_acg_rvw["press_one_approval"] == "Pass" ? "selected" : "" ?> value="Pass">Pass</option>
													<option acg_val=0 <?= $agent_acg_rvw["press_one_approval"] == "Fail" ? "selected" : "" ?> value="Fail">Fail</option>
													<option acg_val=0 <?= $agent_acg_rvw["press_one_approval"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt19]" class="form-control" value="<?php echo $agent_acg_rvw['cmt19'] ?>" disabled></td>
										</tr>
										<tr>
											<td colspan="2" class="text-danger">Did the agent inform about staying online with customer?</td>
											<td>4</td>
											<td>
												<select class="form-control acg_point acg_fatal" name="data[staying_online]" disabled>
													<option acg_val=4 <?= $agent_acg_rvw["staying_online"] == "Pass" ? "selected" : "" ?> value="Pass">Pass</option>
													<option acg_val=0 <?= $agent_acg_rvw["staying_online"] == "Fail" ? "selected" : "" ?> value="Fail">Fail</option>
													<option acg_val=0 <?= $agent_acg_rvw["staying_online"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt20]" class="form-control" value="<?php echo $agent_acg_rvw['cmt20'] ?>" disabled></td>
										</tr>
										<tr>
											<td colspan="2" class="text-danger">Did the agent inform about asking questions before providing approval?</td>
											<td>4</td>
											<td>
												<select class="form-control acg_point acg_fatal" name="data[asking_questions]" disabled>
													<option acg_val=4 <?= $agent_acg_rvw["asking_questions"] == "Pass" ? "selected" : "" ?> value="Pass">Pass</option>
													<option acg_val=0 <?= $agent_acg_rvw["asking_questions"] == "Fail" ? "selected" : "" ?> value="Fail">Fail</option>
													<option acg_val=0 <?= $agent_acg_rvw["asking_questions"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt21]" class="form-control" value="<?php echo $agent_acg_rvw['cmt21'] ?>"disabled></td>
										</tr>

										<tr>
											<td  colspan="2" class="text-danger">Did the agent accurately answer the customer's questions?</td>
											<td>4</td>
											<td>
												<select class="form-control acg_point acg_fatal" name="data[accurately_answer]" disabled>
													<option acg_val=4 <?= $agent_acg_rvw["accurately_answer"] == "Pass" ? "selected" : "" ?> value="Pass">Pass</option>
													<option acg_val=0 <?= $agent_acg_rvw["accurately_answer"] == "Fail" ? "selected" : "" ?> value="Fail">Fail</option>
													<option acg_val=0 <?= $agent_acg_rvw["accurately_answer"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt22]" class="form-control" value="<?php echo $agent_acg_rvw['cmt22'] ?>" disabled></td>
										</tr>
										<tr>
											<td colspan="2" class="text-danger">Did a technical issue occur on the call?</td>
											<td>4</td>
											<td>
												<select class="form-control acg_point acg_fatal" name="data[technical_issue]" disabled>
													<option acg_val=4 <?= $agent_acg_rvw["technical_issue"] == "Pass" ? "selected" : "" ?> value="Pass">Pass</option>
													<option acg_val=0 <?= $agent_acg_rvw["technical_issue"] == "Fail" ? "selected" : "" ?> value="Fail">Fail</option>
													<option acg_val=0 <?= $agent_acg_rvw["technical_issue"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt23]" class="form-control" value="<?php echo $agent_acg_rvw['cmt23'] ?>" disabled></td>
										</tr>
										<tr>
											<td colspan="2" class="text-danger">Did the agent press 1 in the IVR on the customer's behalf?</td>
											<td>4</td>
											<td>
												<select class="form-control acg_point acg_fatal" name="data[customers_behalf_IVR]" disabled>
													<option acg_val=4 <?= $agent_acg_rvw["customers_behalf_IVR"] == "Pass" ? "selected" : "" ?> value="Pass">Pass</option>
													<option acg_val=0 <?= $agent_acg_rvw["customers_behalf_IVR"] == "Fail" ? "selected" : "" ?> value="Fail">Fail</option>
													<option acg_val=0 <?= $agent_acg_rvw["customers_behalf_IVR"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt24]" class="form-control" value="<?php echo $agent_acg_rvw['cmt24'] ?>" disabled></td>
										</tr>
										<tr>
											<td colspan="2" class="text-danger">Did the agent read the disclosure verbatim according to the brand?</td>
											<td>4</td>
											<td>
												<select class="form-control acg_point acg_fatal" name="data[disclosure_verbatim]" disabled>
													<option acg_val=4 <?= $agent_acg_rvw["disclosure_verbatim"] == "Pass" ? "selected" : "" ?> value="Pass">Pass</option>
													<option acg_val=0 <?= $agent_acg_rvw["disclosure_verbatim"] == "Fail" ? "selected" : "" ?> value="Fail">Fail</option>
													<option acg_val=0 <?= $agent_acg_rvw["disclosure_verbatim"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt25]" class="form-control" value="<?php echo $agent_acg_rvw['cmt25'] ?>" disabled></td>
										</tr>


										<tr>
											<td class="eml" rowspan=2>Closing</td>
											<td colspan="2">Did the agent summrized the ordeer before closing?</td>
											<td>2</td>
											<td>
												<select class="form-control acg_point" name="data[summrized_the_order]" disabled>
													<option acg_val=2 <?= $agent_acg_rvw["summrized_the_order"] == "Pass" ? "selected" : "" ?> value="Pass">Pass</option>
													<option acg_val=0 <?= $agent_acg_rvw["summrized_the_order"] == "Fail" ? "selected" : "" ?> value="Fail">Fail</option>
													<option acg_val=0 <?= $agent_acg_rvw["summrized_the_order"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt26]" class="form-control" value="<?php echo $agent_acg_rvw['cmt26'] ?>" disabled></td>
										</tr>
										<tr>
											<td colspan="2">Did the agent closed the call properly by thanking the customer?</td>
											<td>3</td>
											<td>
												<select class="form-control acg_point" name="data[closed_call_properly]" disabled>
													<option acg_val=3 <?= $agent_acg_rvw["closed_call_properly"] == "Pass" ? "selected" : "" ?> value="Pass">Pass</option>
													<option acg_val=0 <?= $agent_acg_rvw["closed_call_properly"] == "Fail" ? "selected" : "" ?> value="Fail">Fail</option>
													<option acg_val=0 <?= $agent_acg_rvw["closed_call_properly"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt27]" class="form-control" value="<?php echo $agent_acg_rvw['cmt27'] ?>" disabled></td>
										</tr>

										<tr>
											<td>Call Summary:</td>
											<td colspan=2><textarea class="form-control" name="data[call_summary]" disabled><?php echo $agent_acg_rvw['call_summary'] ?></textarea></td>
											<td>Feedback:</td>
											<td colspan=2><textarea class="form-control" name="data[feedback]" disabled><?php echo $agent_acg_rvw['feedback'] ?></textarea></td>
										</tr>

										<tr>

										<td> Attached File (avi|mp4|3gp|mpeg|mpg|mov|mp3|flv|wmv|mkv|wav) </td>
										<td colspan="7">
											<?php
											if ($agent_acg_rvw['attach_file'] != '') {
												$attach_file = explode(",", $agent_acg_rvw['attach_file']);
												foreach ($attach_file as $mp) {
											?>
													<audio controls='' style="width:120px; height:25px; background-color:#607F93">
														<source src="<?php echo base_url(); ?>qa_files/qa_acg/<?php echo $mp; ?>" type="audio/ogg">
														<source src="<?php echo base_url(); ?>qa_files/qa_acg/<?php echo $mp; ?>" type="audio/mpeg">
													</audio>
											<?php }
											} else {
												echo "Not Avaliable ";
											}	?>
										</td>
									</tr>
										
									<tr>
										<td colspan="8" style="background-color:#9FE2BF"></td>
									</tr>

									<tr>
										<td style="font-size:12px">Manager Review:</td>
										<td colspan="8" style="text-align:left"><?php echo $agent_acg_rvw['mgnt_rvw_note'] ?></td>
									</tr>


									<tr>
										<td colspan="8" style="background-color:#9FE2BF"></td>
									</tr>

									<form id="form_agent_user" method="POST" action="">
										<input type="hidden" name="pnid" class="form-control" value="<?php echo $pnid; ?>">

										<!--  had--->



										<!---end-- had-->

										<?php if (is_access_qa_agent_module() == true) {
											if (is_available_qa_feedback($agent_acg_rvw['entry_date'], 72) == true) { ?>
												<tr>
													<?php if ($agent_acg_rvw['agent_rvw_note'] == '') { ?>

														<!-- add--->
												<tr>
													<td colspan=2 style="font-size:12px">Feedback Status</td>
													<td colspan=5>
														<select class="form-control" id="" name="agnt_fd_acpt" required>
															<option value="">--Select--</option>
															<option <?php echo $agent_acg_rvw['agnt_fd_acpt'] == 'Accepted' ? "selected" : ""; ?> value="Accepted">Acceptaned</option>
															<option <?php echo $agent_acg_rvw['agnt_fd_acpt'] == 'Not Accepted' ? "selected" : ""; ?> value="Not Accepted">Not Accepted</option>
														</select>
													</td>
												</tr>
												<tr>
													<td colspan=2 style="font-size:12px">Agent Review</td>
													<td colspan=5><textarea class="form-control" name="note"><?php echo $agent_acg_rvw['agent_rvw_note'] ?></textarea></td>
												</tr>

												<!--end--->

												<td colspan="8"><button class="btn btn-success waves-effect" type="submit" id='btnagentSave' name='btnSave' value="SAVE" style="width:500px">SAVE</button></td>
											<?php } else if ($agent_acg_rvw['agent_rvw_note'] != '') { ?>
												<tr>
													<td style="font-size:12px">Agent Review:</td>
													<td colspan="7" style="text-align:left"><?php echo $agent_acg_rvw['agent_rvw_note'] ?></td>
												</tr><?php
													}

													?>
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