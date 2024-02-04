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

<?php if ($ajio_id != 0) {
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
											<td colspan="6" id="theader" style="font-size:40px">UPDATER QA FORM</td>
											<input type="hidden" name="audit_start_time" value="<?php echo CurrMySqlDate(); ?>">
										</tr>
										<?php
										if ($ajio_id == 0) {
											$auditorName = get_username();
											$auditDate = CurrDateMDY();
											//$auditDate =  CurrDateTimeMDY();
											$clDate_val = '';
										} else {
											if ($qa_acg_curd['entry_by'] != '') {
												$auditorName = $qa_acg_curd['auditor_name'];
											} else {
												$auditorName = $qa_acg_curd['client_name'];
											}
											//$new = explode("-", $qa_acg_curd['audit_date']);
											//$new1 = explode(" ", $new[2]);
											//print_r($new);
											$auditDate = mysql2mmddyy($qa_acg_curd['audit_date']);
										 //    $at = array($new[1], $new1[0], $new[0]);
										 //    $n_date = implode("/", $at);
											// $auditDate = ($n_date)." ".$new1[1];
											$clDate_val = mysql2mmddyy($qa_acg_curd['call_date']);
										}
										?>
										<tr>
											<td>Auditor Name: <span style="font-size:24px;color:red">*</span></td>
											<td><input type="text" class="form-control" value="<?= $auditorName; ?>" disabled></td>
											<td>Audit Date:<span style="font-size:24px;color:red">*</span></td>
											<td><input type="text" class="form-control" value="<?= $auditDate; ?>" disabled></td>
											<td>Call Date:<span style="font-size:24px;color:red">*</span></td>
											<td>
												<input type="text" id="call_date" name="call_date"  onkeydown="return false;" value="<?php echo $clDate_val; ?>" max="<?php echo date("Y-m-d"); ?>" class="form-control" required>
											</td>
										</tr>
										<tr>
											<td>Agent Name:<span style="font-size:24px;color:red">*</span></td>
											<td>
												<select class="form-control" id="agent_id" name="data[agent_id]" required>
													<?php 
													if($qa_acg_curd['agent_id']!=''){
														?>
														<option value="<?php echo $qa_acg_curd['agent_id'] ?>"><?php echo $qa_acg_curd['fname'] . " " . $qa_acg_curd['lname'] ?></option>
														<?php
													}else{
														?>
														<option value="">Select</option>
														<?php
													}
													?>
													
													
													<?php foreach ($agentName as $row) :  ?>
													<?php 
													if($row['id'] == $qa_acg_curd['agent_id']){
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
											<td>Employee ID:<span style="font-size:24px;color:red">*</span></td>
											<td><input type="text" class="form-control" id="fusion_id" required value="<?php echo $qa_acg_curd['fusion_id'] ?>" readonly></td>
											<td> L1 Supervisor:<span style="font-size:24px;color:red">*</span></td>
											<td>
												<!-- <select class="form-control" id="tl_id" name="data[tl_id]" readonly>
													<?php 
													if($qa_acg_curd['tl_id']!=''){
														?>
														<option value="<?php echo $qa_acg_curd['tl_id'] ?>"><?php echo $qa_acg_curd['tl_name'] ?></option>
														<?php 

													}else{
														?>
														<option value="">--Select--</option>
														<?php foreach ($tlname as $tl) : ?>
														<option value="<?php echo $tl['id']; ?>"><?php echo $tl['fname'] . " " . $tl['lname']; ?></option>
													<?php endforeach; ?>
														<?php
													}
													?>
												</select> -->
												<input type="text" class="form-control" id="tl_name" required value="<?php echo $qa_acg_curd['tl_name'] ?>" readonly>
												<input type="hidden" class="form-control" id="tl_id" name="data[tl_id]" value="<?php echo $qa_acg_curd['tl_id'] ?>" required>
											</td>
										</tr>
										<tr>
											<td>ACPT:<span style="font-size:24px;color:red">*</span></td>
											<td>
												<select class="form-control" id="" name="data[acpt]" required>
											
											    <option value="">-Select-</option>
											    <option value="Agent" <?= ($qa_acg_curd['acpt']=="Agent")?"selected":"" ?>>Agent</option>
												<option value="Customer" <?= ($qa_acg_curd['acpt']=="Customer")?"selected":"" ?>>Customer</option>
												<option value="Process" <?= ($qa_acg_curd['acpt']=="Process")?"selected":"" ?>>Process</option>
												<option value="Technical" <?= ($qa_acg_curd['acpt']=="Technical")?"selected":"" ?>>Technical</option>
												<option value="NA" <?= ($qa_acg_curd['acpt']=="NA")?"selected":"" ?>>NA</option>
											
										</select>
											</td>
											<td>Phone Number:<span style="font-size:24px;color:red">*</span></td>
											<td><input type="text" class="form-control" name="data[phone]" value="<?php echo $qa_acg_curd['phone'] ?>" onkeyup="checkDec(this);" required>
												<span id="start_phone" style="color:red"></span></td>

											<td>Brand:<span style="font-size:24px;color:red">*</span></td>
											<td>
												<input type="text" class="form-control" name="data[type_of_audit]" value="<?php echo $qa_acg_curd['type_of_audit'] ?>" required>
											</td>
										</tr>
										<tr>
											<td>Call ID: <span style="font-size:24px;color:red">*</span></td>
											<td>
												<input type="text" class="form-control" name="data[call_id]" value="<?php echo $qa_acg_curd['call_id'] ?>" required>
											</td>
											<td>L1:<span style="font-size:24px;color:red">*</span></td>
											<td>
												<input type="text" class="form-control" name="data[l1]" value="<?php echo $qa_acg_curd['l1'] ?>" required>
											</td>
											<td>L2:<span style="font-size:24px;color:red">*</span></td>
											<td>
												<input type="text" class="form-control" name="data[l2]" value="<?php echo $qa_acg_curd['l2'] ?>" required>
											</td>
											
										</tr>
										<tr>
											
											<td>VOC:<span style="font-size:24px;color:red">*</span></td>
											<td>
												<select class="form-control" id="voc" name="data[voc]" required>
													
													<option value="">-Select-</option>
													<option value="1"  <?= ($qa_acg_curd['voc']=="1")?"selected":"" ?>>1</option>
													<option value="2"  <?= ($qa_acg_curd['voc']=="2")?"selected":"" ?>>2</option>
													<option value="3"  <?= ($qa_acg_curd['voc']=="3")?"selected":"" ?>>3</option>
													<option value="4"  <?= ($qa_acg_curd['voc']=="4")?"selected":"" ?>>4</option>
													<option value="5"  <?= ($qa_acg_curd['voc']=="5")?"selected":"" ?>>5</option>
													<option value="6"  <?= ($qa_acg_curd['voc']=="6")?"selected":"" ?>>6</option>
													<option value="7"  <?= ($qa_acg_curd['voc']=="7")?"selected":"" ?>>7</option>
													<option value="8"  <?= ($qa_acg_curd['voc']=="8")?"selected":"" ?>>8</option>
													<option value="9"  <?= ($qa_acg_curd['voc']=="9")?"selected":"" ?>>9</option>
													<option value="10"  <?= ($qa_acg_curd['voc']=="10")?"selected":"" ?>>10</option>
												</select>
											</td>
											<td>Audit Type:<span style="font-size:24px;color:red">*</span></td>
											<td>
												<select class="form-control" id="audit_type" name="data[audit_type]" required>
                                                    <option value="">-Select-</option>
                                                    <option value="CQ Audit" <?= ($qa_acg_curd['audit_type']=="CQ Audit")?"selected":"" ?>>CQ Audit</option>
                                                    <option value="BQ Audit" <?= ($qa_acg_curd['audit_type']=="BQ Audit")?"selected":"" ?>>BQ Audit</option>
                                                    <option value="Calibration" <?= ($qa_acg_curd['audit_type']=="Calibration")?"selected":"" ?>>Calibration</option>
                                                    <option value="WoW Call"  <?= ($qa_acg_curd['audit_type']=="WoW Call")?"selected":"" ?>>WoW Call</option>
                                                    <option value="Pre-Certificate Mock Call" <?= ($qa_acg_curd['audit_type']=="Pre-Certificate Mock Call")?"selected":"" ?>>Pre-Certificate Mock Call</option>
                                                    <option value="Certification Audit" <?= ($qa_acg_curd['audit_type']=="Certification Audit")?"selected":"" ?>>Certification Audit</option>
                                                    <option value="Operation Audit" <?= ($qa_acg_curd['audit_type']=="Operation Audit")?"selected":"" ?>>Operation Audit</option>
                                                    <option value="Trainer Audit"  <?= ($qa_acg_curd['audit_type']=="Trainer Audit")?"selected":"" ?>>Trainer Audit</option>
                                                    <option value="QA Supervisor Audit"  <?= ($qa_acg_curd['audit_type']=="QA Supervisor Audit")?"selected":"" ?>>QA Supervisor Audit</option>
                                                </select>
											</td>
											<td class="auType_epi">Auditor Type<span style="font-size:24px;color:red">*</span></td>
											<td class="auType_epi">
												<select class="form-control" id="auditor_type" name="data[auditor_type]">
                                                    <option value="">Select</option>
                                                    <option value="Master" <?= ($qa_acg_curd['auditor_type']=="Master")?"selected":"" ?>>Master</option>
                                                    <option value="Regular" <?= ($qa_acg_curd['auditor_type']=="Regular")?"selected":"" ?>>Regular</option>
                                                </select>
											</td>
										</tr>
										<tr>
											<td style="font-weight:bold; font-size:16px; text-align:left">Earned Score</td>
											<td><input type="text" readonly id="acg_earned_score" name="data[earned_score]" class="form-control" value="<?php echo $qa_acg_curd['earned_score'] ?>" /></td>
											<td style="font-weight:bold; font-size:16px; text-align:left">Possible Score</td>
											<td><input type="text" readonly id="acg_possible_score" name="data[possible_score]" class="form-control" value="<?php echo $qa_acg_curd['possible_score'] ?>" /></td>
											<td style="font-weight:bold; font-size:16px; text-align:right">Overall Score:</td>
											<td><input type="text" readonly id="acg_overall_score" name="data[overall_score]" class="form-control acgFatal" style="font-weight:bold" value="<?php echo $qa_acg_curd['overall_score'] ?>"></td>
										</tr>
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
												<select class="form-control acg_point compliance" name="data[opening_call]" required>
													
													<option acg_val=4 acg_max="4"<?php echo $qa_acg_curd['opening_call'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option acg_val=0 acg_max="4" <?php echo $qa_acg_curd['opening_call'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													<option acg_val=0 acg_max="4" <?php echo $qa_acg_curd['opening_call'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt1]" class="form-control" value="<?php echo $qa_acg_curd['cmt1'] ?>"></td>
										</tr>
										<tr>
											<td colspan=2>Did the  agent mentioned his name and the brand name on call?</td>
											<td>4</td>
											<td>
												<select class="form-control acg_point compliance" name="data[brand_name]" required>
													
													<option acg_val=4 acg_max="4" <?php echo $qa_acg_curd['brand_name'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option acg_val=0 acg_max="4" <?php echo $qa_acg_curd['brand_name'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													<option acg_val=0 acg_max="4" <?php echo $qa_acg_curd['brand_name'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt2]" class="form-control" value="<?php echo $qa_acg_curd['cmt2'] ?>"></td>
										</tr>

										<tr>
											<td colspan="2" class="text-danger">Did the agent mentioned that the customer is on a recorded line?</td>
											<td>5</td>
											<td>
												<select class="form-control acg_point" id ="ajioAF1" name="data[recorded_line]" required>
													
													<option acg_val=5 acg_max="5" <?= $qa_acg_curd["recorded_line"] == "Pass" ? "selected" : "" ?> value="Pass">Pass</option>
													<option acg_val=0 acg_max="5" <?= $qa_acg_curd["recorded_line"] == "Fail" ? "selected" : "" ?> value="Fail">Fail</option>
													<option acg_val=0 acg_max="5" <?= $qa_acg_curd["recorded_line"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt3]" class="form-control" value="<?php echo $qa_acg_curd['cmt3'] ?>"></td>
										</tr>

										<tr>
											<td class="eml" rowspan=3>Communication</td>
											<td colspan=2>Agent had proper rate of speech on call?</td>
											<td>4</td>
											<td>
												<select class="form-control acg_point" name="data[rate_of_speech]" required>
													
													<option acg_val=4 acg_max="4" <?php echo $qa_acg_curd['rate_of_speech'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option acg_val=0 acg_max="4" <?php echo $qa_acg_curd['rate_of_speech'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													<option acg_val=0 acg_max="4" <?php echo $qa_acg_curd['rate_of_speech'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt4]" class="form-control" value="<?php echo $qa_acg_curd['cmt4'] ?>"></td>
										</tr>

										<tr>
											<td colspan=2>Agent didn’t overlapped the customer while speaking?</td>
											<td>4</td>
											<td>
												<select class="form-control acg_point" name="data[overlapped_customer]" required>
													
													<option acg_val=4 acg_max="4" <?php echo $qa_acg_curd['overlapped_customer'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option acg_val=0 acg_max="4" <?php echo $qa_acg_curd['overlapped_customer'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													<option acg_val=0 acg_max="4" <?php echo $qa_acg_curd['overlapped_customer'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt5]" class="form-control" value="<?php echo $qa_acg_curd['cmt5'] ?>"></td>
										</tr>

										<tr>
											<td  colspan="2">Agent sounded energrtic and confident on call?</td>
											<td>4</td>
											<td>
												<select class="form-control acg_point" name="data[energrtic]" required>
													
													<option acg_val=4 acg_max="4" <?= $qa_acg_curd["energrtic"] == "Pass" ? "selected" : "" ?> value="Pass">Pass</option>
													<option acg_val=0 acg_max="4" <?= $qa_acg_curd["energrtic"] == "Fail" ? "selected" : "" ?> value="Fail">Fail</option>
													<option acg_val=0 <?= $qa_acg_curd["energrtic"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt6]" class="form-control" value="<?php echo $qa_acg_curd['cmt6'] ?>"></td>
										</tr>
										<tr>
											<td class="eml" rowspan=6>Call Handling</td>
											<td colspan="2">Agent asked permission before putting the call on hold?</td>
											<td>3</td>
											<td>
												<select class="form-control acg_point customer" name="data[call_on_hold]" required>
												
													<option acg_val=3 acg_max="3"<?= $qa_acg_curd["call_on_hold"] == "Pass" ? "selected" : "" ?> value="Pass">Pass</option>
													<option acg_val=0 acg_max="3"<?= $qa_acg_curd["call_on_hold"] == "Fail" ? "selected" : "" ?> value="Fail">Fail</option>
													<option acg_val=0 acg_max="3"<?= $qa_acg_curd["call_on_hold"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt7]" class="form-control" value="<?php echo $qa_acg_curd['cmt7'] ?>"></td>
										</tr>
										<tr>
											<td colspan="2">Agent mentioned the reason for putting the customer on hold</td>
											<td>3</td>
											<td>
												<select class="form-control acg_point customer" name="data[call_on_hold_reason]" required>
												
													<option acg_val=3 acg_max="3" <?= $qa_acg_curd["call_on_hold_reason"] == "Pass" ? "selected" : "" ?> value="Pass">Pass</option>
													<option acg_val=0 acg_max="3" <?= $qa_acg_curd["call_on_hold_reason"] == "Fail" ? "selected" : "" ?> value="Fail">Fail</option>
													<option acg_val=0 acg_max="3" <?= $qa_acg_curd["call_on_hold_reason"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt8]" class="form-control" value="<?php echo $qa_acg_curd['cmt8'] ?>"></td>
										</tr>
										<tr>
											<td colspan="2">Agent thanked the customer after resuming the call from hold</td>
											<td>3</td>
											<td>
												<select class="form-control acg_point" name="data[call_on_hold_resume]" required>
												
													<option acg_val=3 acg_max="3" <?= $qa_acg_curd["call_on_hold_resume"] == "Pass" ? "selected" : "" ?> value="Pass">Pass</option>
													<option acg_val=0 acg_max="3" <?= $qa_acg_curd["call_on_hold_resume"] == "Fail" ? "selected" : "" ?> value="Fail">Fail</option>
													<option acg_val=0 acg_max="3" <?= $qa_acg_curd["call_on_hold_resume"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt9]" class="form-control" value="<?php echo $qa_acg_curd['cmt9'] ?>"></td>
										</tr>

										<tr>
											<td colspan="2">Agent was able to answer all the customer query and handle the objection</td>
											<td>4</td>
											<td>
												<select class="form-control acg_point" name="data[customer_query]" required>
												
													<option acg_val=4 acg_max="4" <?= $qa_acg_curd["customer_query"] == "Pass" ? "selected" : "" ?> value="Pass">Pass</option>
													<option acg_val=0 acg_max="4" <?= $qa_acg_curd["customer_query"] == "Fail" ? "selected" : "" ?> value="Fail">Fail</option>
													<option acg_val=0 acg_max="4" <?= $qa_acg_curd["customer_query"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt10]" class="form-control" value="<?php echo $qa_acg_curd['cmt10'] ?>"></td>
										</tr>
										<tr>
											<td colspan="2" class="text-danger">Did the agent pause the recording when collecting the SSN-DOB-CC?</td>
											<td>5</td>
											<td>
												<select class="form-control acg_point" id ="ajioAF2" name="data[pause_recording_ssn]" required>
												
													<option acg_val=5 acg_max="5" <?= $qa_acg_curd["pause_recording_ssn"] == "Pass" ? "selected" : "" ?> value="Pass">Pass</option>
													<option acg_val=0 acg_max="5" <?= $qa_acg_curd["pause_recording_ssn"] == "Fail" ? "selected" : "" ?> value="Fail">Fail</option>
													<option acg_val=0 acg_max="5" <?= $qa_acg_curd["pause_recording_ssn"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt11]" class="form-control" value="<?php echo $qa_acg_curd['cmt11'] ?>"></td>
										</tr>
										<tr>
											<td colspan="2">Agent created right amount of urgency on call to convert the call into sales</td>
											<td>3</td>
											<td>
												<select class="form-control acg_point" name="data[convert_call_sales]" required>
												
													<option acg_val=3 acg_max="3" <?= $qa_acg_curd["convert_call_sales"] == "Pass" ? "selected" : "" ?> value="Pass">Pass</option>
													<option acg_val=0 acg_max="3"<?= $qa_acg_curd["convert_call_sales"] == "Fail" ? "selected" : "" ?> value="Fail">Fail</option>
													<option acg_val=0 acg_max="3"<?= $qa_acg_curd["convert_call_sales"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt12]" class="form-control" value="<?php echo $qa_acg_curd['cmt12'] ?>"></td>
										</tr>

										<tr>
											<td class="eml" rowspan=13>Mandatory Information</td>
											<td colspan="2">Did the agent properly mentioned the pricing and tenurity of the plan?</td>
											<td>3</td>
											<td>
												<select class="form-control acg_point" name="data[pricing_tenurity]" required>
											
													<option acg_val=3 acg_max="3" <?= $qa_acg_curd["pricing_tenurity"] == "Pass" ? "selected" : "" ?> value="Pass">Pass</option>
													<option acg_val=0 acg_max="3" <?= $qa_acg_curd["pricing_tenurity"] == "Fail" ? "selected" : "" ?> value="Fail">Fail</option>
													<option acg_val=0 acg_max="3" <?= $qa_acg_curd["pricing_tenurity"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt13]" class="form-control" value="<?php echo $qa_acg_curd['cmt13'] ?>"></td>
										</tr>
										<tr>
											<td colspan="2">Did the agent suggested the right plan to the customer?</td>
											<td>3</td>
											<td>
												<select class="form-control acg_point" name="data[right_plan_suggestion]" required>
										
													<option acg_val=3 acg_max="3" <?= $qa_acg_curd["right_plan_suggestion"] == "Pass" ? "selected" : "" ?> value="Pass">Pass</option>
													<option acg_val=0 acg_max="3" <?= $qa_acg_curd["right_plan_suggestion"] == "Fail" ? "selected" : "" ?> value="Fail">Fail</option>
													<option acg_val=0 acg_max="3" <?= $qa_acg_curd["right_plan_suggestion"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt14]" class="form-control" value="<?php echo $qa_acg_curd['cmt14'] ?>"></td>
										</tr>
										<tr>
											<td colspan="2">Did the agent explained what the plan would cover and also complete features of the plan?</td>
											<td>3</td>
											<td>
												<select class="form-control acg_point" name="data[plan_cover]" required>
													<option acg_val=3 acg_max="3" <?= $qa_acg_curd["plan_cover"] == "Pass" ? "selected" : "" ?> value="Pass">Pass</option>
													<option acg_val=0 acg_max="3" <?= $qa_acg_curd["plan_cover"] == "Fail" ? "selected" : "" ?> value="Fail">Fail</option>
													<option acg_val=0 acg_max="3" <?= $qa_acg_curd["plan_cover"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt15]" class="form-control" value="<?php echo $qa_acg_curd['cmt15'] ?>"></td>
										</tr>
										<tr>
											<td colspan="2" class="text-danger">Did the agent offer at least 1 digital option to the customer prior to offering the Automated Verbal Approval?</td>
											<td>4</td>
											<td>
												<select class="form-control acg_point" id ="ajioAF3" name="data[least_one_digital_option]" required>
													<option acg_val=4 acg_max="4" <?= $qa_acg_curd["least_one_digital_option"] == "Pass" ? "selected" : "" ?> value="Pass">Pass</option>
													<option acg_val=0 acg_max="4" <?= $qa_acg_curd["least_one_digital_option"] == "Fail" ? "selected" : "" ?> value="Fail">Fail</option>
													<option acg_val=0 acg_max="4" <?= $qa_acg_curd["least_one_digital_option"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt16]" class="form-control" value="<?php echo $qa_acg_curd['cmt16'] ?>"></td>
										</tr>

										<tr>
											<td colspan="2" class="text-danger">Did the agent inform the customer about emailing the order summary and that this is accessible at xfinity.com/MyAccount?</td>
											<td>4</td>
											<td>
												<select class="form-control acg_point" id ="ajioAF4" name="data[email_order_summary]" required>
													<option acg_val=4 acg_max="4" <?= $qa_acg_curd["email_order_summary"] == "Pass" ? "selected" : "" ?> value="Pass">Pass</option>
													<option acg_val=0 acg_max="4" <?= $qa_acg_curd["email_order_summary"] == "Fail" ? "selected" : "" ?> value="Fail">Fail</option>
													<option acg_val=0 acg_max="4" <?= $qa_acg_curd["email_order_summary"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt17]" class="form-control" value="<?php echo $qa_acg_curd['cmt17'] ?>"></td>
										</tr>
										<tr>
											<td colspan="2" class="text-danger">Did the agent inform about Auto IVR reviewing the order summary?</td>
											<td>4</td>
											<td>
												<select class="form-control acg_point" id ="ajioAF5" name="data[auto_IVR_reviewing]" required>
													<option acg_val=4 acg_max="4" <?= $qa_acg_curd["auto_IVR_reviewing"] == "Pass" ? "selected" : "" ?> value="Pass">Pass</option>
													<option acg_val=0 acg_max="4" <?= $qa_acg_curd["auto_IVR_reviewing"] == "Fail" ? "selected" : "" ?> value="Fail">Fail</option>
													<option acg_val=0 acg_max="4" <?= $qa_acg_curd["auto_IVR_reviewing"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt18]" class="form-control" value="<?php echo $qa_acg_curd['cmt18'] ?>"></td>
										</tr>
										<tr>
											<td colspan="2" class="text-danger">Did the agent inform customer to press 1 for approval?</td>
											<td>4</td>
											<td>
												<select class="form-control acg_point" id ="ajioAF6" name="data[press_one_approval]" required>
													<option acg_val=4 acg_max="4" <?= $qa_acg_curd["press_one_approval"] == "Pass" ? "selected" : "" ?> value="Pass">Pass</option>
													<option acg_val=0 acg_max="4" <?= $qa_acg_curd["press_one_approval"] == "Fail" ? "selected" : "" ?> value="Fail">Fail</option>
													<option acg_val=0 acg_max="4" <?= $qa_acg_curd["press_one_approval"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt19]" class="form-control" value="<?php echo $qa_acg_curd['cmt19'] ?>"></td>
										</tr>
										<tr>
											<td colspan="2" class="text-danger">Did the agent inform about staying online with customer?</td>
											<td>4</td>
											<td>
												<select class="form-control acg_point" id ="ajioAF7" name="data[staying_online]" required>
													<option acg_val=4 acg_max="4" <?= $qa_acg_curd["staying_online"] == "Pass" ? "selected" : "" ?> value="Pass">Pass</option>
													<option acg_val=0 acg_max="4" <?= $qa_acg_curd["staying_online"] == "Fail" ? "selected" : "" ?> value="Fail">Fail</option>
													<option acg_val=0 acg_max="4" <?= $qa_acg_curd["staying_online"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt20]" class="form-control" value="<?php echo $qa_acg_curd['cmt20'] ?>"></td>
										</tr>
										<tr>
											<td colspan="2" class="text-danger">Did the agent inform about asking questions before providing approval?</td>
											<td>4</td>
											<td>
												<select class="form-control acg_point" id ="ajioAF8" name="data[asking_questions]" required>
													<option acg_val=4 acg_max="4" <?= $qa_acg_curd["asking_questions"] == "Pass" ? "selected" : "" ?> value="Pass">Pass</option>
													<option acg_val=0 acg_max="4" <?= $qa_acg_curd["asking_questions"] == "Fail" ? "selected" : "" ?> value="Fail">Fail</option>
													<option acg_val=0 acg_max="4" <?= $qa_acg_curd["asking_questions"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt21]" class="form-control" value="<?php echo $qa_acg_curd['cmt21'] ?>"></td>
										</tr>

										<tr>
											<td  colspan="2" class="text-danger">Did the agent accurately answer the customer's questions?</td>
											<td>4</td>
											<td>
												<select class="form-control acg_point" id ="ajioAF9" name="data[accurately_answer]" required>
													<option acg_val=4 acg_max="4" <?= $qa_acg_curd["accurately_answer"] == "Pass" ? "selected" : "" ?> value="Pass">Pass</option>
													<option acg_val=0 acg_max="4" <?= $qa_acg_curd["accurately_answer"] == "Fail" ? "selected" : "" ?> value="Fail">Fail</option>
													<option acg_val=0 acg_max="4" <?= $qa_acg_curd["accurately_answer"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt22]" class="form-control" value="<?php echo $qa_acg_curd['cmt22'] ?>"></td>
										</tr>
										<tr>
											<td colspan="2" class="text-danger">Did a technical issue occur on the call?</td>
											<td>4</td>
											<td>
												<select class="form-control acg_point" id ="ajioAF10" name="data[technical_issue]" required>
													<option acg_val=4 acg_max="4" <?= $qa_acg_curd["technical_issue"] == "Pass" ? "selected" : "" ?> value="Pass">Pass</option>
													<option acg_val=0 acg_max="4" <?= $qa_acg_curd["technical_issue"] == "Fail" ? "selected" : "" ?> value="Fail">Fail</option>
													<option acg_val=0 acg_max="4" <?= $qa_acg_curd["technical_issue"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt23]" class="form-control" value="<?php echo $qa_acg_curd['cmt23'] ?>"></td>
										</tr>
										<tr>
											<td colspan="2" class="text-danger">Did the agent press 1 in the IVR on the customer's behalf?</td>
											<td>4</td>
											<td>
												<select class="form-control acg_point" id ="ajioAF11" name="data[customers_behalf_IVR]" required>
													<option acg_val=4 acg_max="4" <?= $qa_acg_curd["customers_behalf_IVR"] == "Pass" ? "selected" : "" ?> value="Pass">Pass</option>
													<option acg_val=0 acg_max="4"<?= $qa_acg_curd["customers_behalf_IVR"] == "Fail" ? "selected" : "" ?> value="Fail">Fail</option>
													<option acg_val=0 acg_max="4"<?= $qa_acg_curd["customers_behalf_IVR"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt24]" class="form-control" value="<?php echo $qa_acg_curd['cmt24'] ?>"></td>
										</tr>
										<tr>
											<td colspan="2" class="text-danger">Did the agent read the disclosure verbatim according to the brand?</td>
											<td>4</td>
											<td>
												<select class="form-control acg_point" id ="ajioAF12" name="data[disclosure_verbatim]" required>
													<option acg_val=4 acg_max="4"<?= $qa_acg_curd["disclosure_verbatim"] == "Pass" ? "selected" : "" ?> value="Pass">Pass</option>
													<option acg_val=0 acg_max="4"<?= $qa_acg_curd["disclosure_verbatim"] == "Fail" ? "selected" : "" ?> value="Fail">Fail</option>
													<option acg_val=0 acg_max="4"<?= $qa_acg_curd["disclosure_verbatim"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt25]" class="form-control" value="<?php echo $qa_acg_curd['cmt25'] ?>"></td>
										</tr>


										<tr>
											<td class="eml" rowspan=2>Closing</td>
											<td colspan="2">Did the agent summrized the ordeer before closing?</td>
											<td>2</td>
											<td>
												<select class="form-control acg_point" name="data[summrized_the_order]" required>
													<option acg_val=2 acg_max="2"<?= $qa_acg_curd["summrized_the_order"] == "Pass" ? "selected" : "" ?> value="Pass">Pass</option>
													<option acg_val=0 acg_max="2" <?= $qa_acg_curd["summrized_the_order"] == "Fail" ? "selected" : "" ?> value="Fail">Fail</option>
													<option acg_val=0 acg_max="2" <?= $qa_acg_curd["summrized_the_order"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt26]" class="form-control" value="<?php echo $qa_acg_curd['cmt26'] ?>"></td>
										</tr>
										<tr>
											<td colspan="2">Did the agent closed the call properly by thanking the customer?</td>
											<td>3</td>
											<td>
												<select class="form-control acg_point" name="data[closed_call_properly]" required>
													<option acg_val=3 acg_max="3" <?= $qa_acg_curd["closed_call_properly"] == "Pass" ? "selected" : "" ?> value="Pass">Pass</option>
													<option acg_val=0 acg_max="3" <?= $qa_acg_curd["closed_call_properly"] == "Fail" ? "selected" : "" ?> value="Fail">Fail</option>
													<option acg_val=0 acg_max="3" <?= $qa_acg_curd["closed_call_properly"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt27]" class="form-control" value="<?php echo $qa_acg_curd['cmt27'] ?>"></td>
										</tr>

										<tr>
											<td>Call Summary:</td>
											<td colspan=2><textarea class="form-control" name="data[call_summary]"><?php echo $qa_acg_curd['call_summary'] ?></textarea></td>
											<td>Feedback:</td>
											<td colspan=2><textarea class="form-control" name="data[feedback]"><?php echo $qa_acg_curd['feedback'] ?></textarea></td>
										</tr>
										
										<tr>
											<td colspan=2>Upload Files [m4a,mp4,mp3,wav]</td>
											<?php /* if($ajio_id!=0 && $qa_acg_curd['entry_by']==get_user_id()){ 
												$form_control_class='class="form-control1"';
											}else{
												$form_control_class='class="form-control"';
											} */
											?>
											<td colspan=2><input type="file" multiple class="form-control" name="attach_file[]" accept=".m4a,.mp4,.mp3,.wav,audio/*" id="attach_file"></td>
											<?php if($ajio_id!=0){
												if ($qa_acg_curd['attach_file']!=''){ ?>
													<td colspan=2><?php $attach_file = explode(",", $qa_acg_curd['attach_file']);
														foreach ($attach_file as $mp) { ?>
															<audio controls='' style="background-color:#607F93">
																<source src="<?php echo base_url(); ?>qa_files/qa_acg/<?php echo $mp; ?>" type="audio/ogg">
																<source src="<?php echo base_url(); ?>qa_files/qa_acg/<?php echo $mp; ?>" type="audio/mpeg">
															</audio> </br>
														<?php } ?>
													</td>
											<?php }else{
													echo '<td colspan=2><b>No Files are uploaded</b></td>';
												} 
											} ?>
										</tr>

										<?php if ($ajio_id != 0) { ?>
											<tr>
												<td colspan=2 style="font-size:16px; font-weight:bold">Agent Feedback Acceptance:</td>
												<td colspan=4><?php echo $qa_acg_curd['agnt_fd_acpt'] ?></td>
											</tr>
											<tr>
												<td colspan=2 style="font-size:16px; font-weight:bold">Agent Review:</td>
												<td colspan=4><?php echo $qa_acg_curd['agent_rvw_note'] ?></td>
											</tr>
											<tr>
												<td colspan=2 style="font-size:16px; font-weight:bold">Management Review:</td>
												<td colspan=4><?php echo $qa_acg_curd['mgnt_rvw_note'] ?></td>
											</tr>
											<tr>
												<td colspan=2 style="font-size:16px; font-weight:bold">Client Review:</td>
												<td colspan=4><?php echo $qa_acg_curd['client_rvw_note'] ?></td>
											</tr>

											<tr>
												<td colspan=2 style="font-size:16px">Your Review<span style="font-size:24px;color:red">*</span></td>
												<td colspan=4><textarea class="form-control1" style="width:100%" id="note" name="note" required></textarea></td>
											</tr>
										<?php } ?>

										<?php
										if ($ajio_id == 0) {
											if (is_access_qa_module() == true || is_access_qa_operations_module() == true) { ?>
												<tr>
													<td colspan=6><button class="btn btn-success blains-effect" type="submit" id="qaformsubmit" style="width:500px">SAVE</button></td>
												</tr>
												<?php
											}
										} else {
											if (is_access_qa_module() == true || is_access_qa_operations_module() == true) {
												if (is_available_qa_feedback($qa_acg_curd['entry_date'], 72) == true) { ?>
													<tr>
														<td colspan="6"><button class="btn btn-success blains-effect" type="submit" id='qaformsubmit' name='btnSave' value="SAVE" style="width:500px">SAVE</button></td>
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