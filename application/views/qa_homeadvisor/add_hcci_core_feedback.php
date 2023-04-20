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
	.top-space{
		margin-top: -20px;
	}

	/*start custom 18-04-2023*/
	.checkbox input[type="checkbox"], .checkbox input[type="radio"] {
		opacity: 1;
	}
	/*end custom 18-04-2023*/
</style>


<?php if ($hcci_id != 0) {
	if (is_access_qa_edit_feedback() == false) { ?>
		<style>
			.form-control {
				pointer-events: none;
				background-color: #D5DBDB;
			}
			.btn-group {
				pointer-events: none;
				background-color: #D5DBDB;
			}
			.btn-default {
				pointer-events: none;
				background-color: #eee;
				width: 100%;
    			text-align: left;
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
											<td colspan="10" id="theader" style="font-size:40px;text-align:center!important;">HCCI [CORE V2]</td>
											<input type="hidden" name="audit_start_time" value="<?php echo CurrMySqlDate(); ?>">
										</tr>
										<?php
										if ($hcci_id == 0) {
											$auditorName = get_username();
											$auditDate = CurrDateMDY();
											//$auditDate =  CurrDateTimeMDY();
											$clDate_val = '';
										} else {
											if ($hcci_data['entry_by'] != '') {
												$auditorName = $hcci_data['auditor_name'];
											} else {
												$auditorName = $hcci_data['client_name'];
											}
											$clDate_val = mysql2mmddyySls($hcci_data['call_date']);
											$auditDate = mysql2mmddyy($hcci_data['audit_date']);
										}
										?>
										<tr>
											<td>Auditor Name:</td>
											<td><input type="text" class="form-control" value="<?= $auditorName; ?>" disabled></td>
											<td>Audit Date:</td>
											<td><input type="text" class="form-control" value="<?= $auditDate; ?>" disabled></td>
											<td>Contact Date:<span style="font-size:24px;color:red">*</span></td>
											<td>
												<input type="text" id="call_date" name="call_date"  onkeydown="return false;" value="<?php echo $clDate_val; ?>" max="<?php echo date("Y-m-d"); ?>" class="form-control" required>
											</td>
										</tr>
										<tr>
											<td>Agent Name:<span style="font-size:24px;color:red">*</span></td>
											<td>
												<select class="form-control" id="agent_id" name="data[agent_id]" required>
													<?php 
													if($hcci_data['agent_id']!=''){
														?>
														<option value="<?php echo $hcci_data['agent_id'] ?>"><?php echo $hcci_data['fname'] . " " . $hcci_data['lname'] ?></option>
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
											<td>Fusion ID:</td>
											<td><input type="text" class="form-control" id="fusion_id" required value="<?php echo $hcci_data['fusion_id'] ?>" readonly></td>
											<td>L1 Supervisor:</td>
											<td>
												<!--<select class="form-control" id="tl_id" name="data[tl_id]" readonly>
													<?php 
													if($hcci_data['tl_id']!=''){
														?>
														<option value="<?php echo $hcci_data['tl_id'] ?>"><?php echo $hcci_data['tl_name'] ?></option>
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
												</select>-->
								
												<input type="text" class="form-control" id="tl_name" required value="<?php echo $hcci_data['tl_name'] ?>" readonly>
												<input type="hidden" class="form-control" id="tl_id" name="data[tl_id]" value="<?php echo $hcci_data['tl_id'] ?>" required>
												<!-- <input type="hidden" class="form-control" id="hcci_id" name="hcci_id" value="<?php //echo $hcci_id ?>" required> -->
											</td>
										</tr>
										<tr>
											<td>Call File:<span style="font-size:24px;color:red">*</span></td>
											<td>
												<input type="text" class="form-control" id="call_file" name="data[call_file]" required value="<?php echo $hcci_data['call_file'] ?>">
											</td>
											<td>Contact Duration:<span style="font-size:24px;color:red">*</span></td>
											<td><input type="text" class="form-control" onkeydown="return false;" id="call_duration" name="data[call_duration]" value="<?php echo $hcci_data['call_duration']?>" required></td>
											<!-- <td><input type="text" class="form-control" onkeydown="return false;" id="call_duration" name="data[call_duration]" value="<?php echo $hcci_data['call_duration'] ?>" required></td> -->
											<td>SR No:<span style="font-size:24px;color:red">*</span></td>
											<td>
												<input type="text" class="form-control" id="sr_no" name="data[sr_no]" required value="<?php echo $hcci_data['sr_no'] ?>">
											</td>
										</tr>
										<tr>
											<td>Consumer No:<span style="font-size:24px;color:red">*</span></td>
											<td><input type="text" class="form-control" id="consumer_no" name="data[consumer_no]" value="<?php echo $hcci_data['consumer_no'] ?>" onkeyup="checkDecConsumer(this);" required>
												<span id="start_phone" style="color:red"></span></td> 
											<!-- <td><input type="text" class="form-control" id="phone" name="data[consumer_no]" value="<?php //echo $hcci_data['consumer_no'] ?>"  required>
											</td> -->	

											<td>VOC:<span style="font-size:24px;color:red">*</span></td>
											<td>
												<select class="form-control" id="voc" name="data[voc]" required>
													
													<option value="">-Select-</option>
													<option value="1"  <?= ($hcci_data['voc']=="1")?"selected":"" ?>>1</option>
													<option value="2"  <?= ($hcci_data['voc']=="2")?"selected":"" ?>>2</option>
													<option value="3"  <?= ($hcci_data['voc']=="3")?"selected":"" ?>>3</option>
													<option value="4"  <?= ($hcci_data['voc']=="4")?"selected":"" ?>>4</option>
													<option value="5"  <?= ($hcci_data['voc']=="5")?"selected":"" ?>>5</option>
													<option value="6"  <?= ($hcci_data['voc']=="6")?"selected":"" ?>>6</option>
													<option value="7"  <?= ($hcci_data['voc']=="7")?"selected":"" ?>>7</option>
													<option value="8"  <?= ($hcci_data['voc']=="8")?"selected":"" ?>>8</option>
													<option value="9"  <?= ($hcci_data['voc']=="9")?"selected":"" ?>>9</option>
													<option value="10"  <?= ($hcci_data['voc']=="10")?"selected":"" ?>>10</option>
												</select>
											</td>
											<td>Audit Type:<span style="font-size:24px;color:red">*</span></td>
											<td>
												<select class="form-control" id="audit_type" name="data[audit_type]" required>
                                                    <option value="">-Select-</option>
                                                    <option value="CQ Audit" <?= ($hcci_data['audit_type']=="CQ Audit")?"selected":"" ?>>CQ Audit</option>
                                                    <option value="BQ Audit" <?= ($hcci_data['audit_type']=="BQ Audit")?"selected":"" ?>>BQ Audit</option>
                                                    <option value="Calibration" <?= ($hcci_data['audit_type']=="Calibration")?"selected":"" ?>>Calibration</option>
                                                    <option value="Pre-Certificate Mock Call" <?= ($hcci_data['audit_type']=="Pre-Certificate Mock Call")?"selected":"" ?>>Pre-Certificate Mock Call</option>
                                                    <option value="Certification Audit" <?= ($hcci_data['audit_type']=="Certification Audit")?"selected":"" ?>>Certification Audit</option>
                                                    <option value="Operation Audit" <?= ($hcci_data['audit_type']=="Operation Audit")?"selected":"" ?>>Operation Audit</option>
                                                    <option value="Trainer Audit"  <?= ($hcci_data['audit_type']=="Trainer Audit")?"selected":"" ?>>Trainer Audit</option>
                                                </select>
											</td>
										</tr>
										<tr>
											<td class="auType_epi">Auditor Type<span style="font-size:24px;color:red">*</span></td>
											<td class="auType_epi">
												<select class="form-control" id="auditor_type" name="data[auditor_type]">
                                                    <option value="">-Select-</option>
                                                    <option value="Master" <?= ($hcci_data['auditor_type']=="Master")?"selected":"" ?>>Master</option>
                                                    <option value="Regular" <?= ($hcci_data['auditor_type']=="Regular")?"selected":"" ?>>Regular</option>
                                                </select>
											</td>
											
										</tr>
										<tr>
											<td style="font-weight:bold; font-size:16px; text-align:left">Earned Score</td>
											<td><input type="text" readonly id="hcci_earned_score" name="data[earned_score]" class="form-control" value="<?php echo $hcci_data['earned_score'] ?>" /></td>
											<td style="font-weight:bold; font-size:16px; text-align:left">Possible Score</td>
											<td><input type="text" readonly id="hcci_possible_score" name="data[possible_score]" class="form-control" value="<?php echo $hcci_data['possible_score'] ?>" /></td>
											<td style="font-weight:bold; font-size:16px; text-align:right">Overall Score:</td>
											<td><input type="text" readonly id="hcci_overall_score" name="data[overall_score]" class="form-control avonFatal" style="font-weight:bold" value="<?php echo $hcci_data['overall_score'] ?>"></td>
										</tr>
									</tbody>
								</table>
							</div>
										<div class="table-responsive top-space">
								<table class="table table-bordered table-striped skt-table" width="100%">
									<tbody>
										<tr class="eml" style="height:25px; font-weight:bold">
											
											<td>CATEGORY</td>
											<td>SUB CATEGORY</td>
											<td colspan=2>PARAMETER</td>
											<td>WEIGHTAGE</td>
											<td>EVALUATION</td>
											<td colspan="0" style="width:150px;display:block;margin:auto;border:none;"> Reason for failed 
											(Multi selection)</td>
											<td colspan="2">COPC Criticality</td>
										</tr>

										<tr>
											
											<td class="eml" rowspan=3>Issue Identification</td>
											<td>Brand</td>
											<td colspan=2>Did the agent use the correct brand? The agent correctly identified as Angi, and if applicable, the partnership the customer booked through.</td>
											<td>5</td>
											<td style="width:100px;">
												<select class="form-control hcci_point business" name="data[brand]" required>
													
													<option hcci_val=5 <?php echo $hcci_data['brand'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option hcci_val=0 <?php echo $hcci_data['brand'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
												</select>
											</td>
											<td colspan=2><!-- <input type="text" name="data[cmt1]" class="form-control" value="<?php //echo $hcci_data['cmt1'] ?>"> --></td>
											<td style="font-weight:bold; background-color:#D7BDE2">Business Citical</td>
										</tr>

										<tr>
											
											<td>Issue Identification</td>
											<td colspan=2>Did the agent correctly identify the issue(s) or, if unclear, did they ask the right kind of clarifying question? "Yes" here means the agent completely understood every part of the issue(s), including the root cause of the issue(s), and identified when multiple issues were raised by the customer. If the agent misunderstood some of the issue(s) or all of the issue(s) they should be scored "No."</td>
											<td>25</td>
											<td>
												<select class="form-control hcci_point customer" id="status_points1" name="data[issue_identification]" required>
													
													<option hcci_val=25 <?php echo $hcci_data['issue_identification'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option hcci_val=0 <?php echo $hcci_data['issue_identification'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
												</select>
											</td>
											<td colspan=2>
												
											    <select class="form-control multiple-select" name="data[cmt1][]"  id="remarks1"  multiple="multiple" disabled>
													<!-- <option  value="">-Select-</option> -->
													<option value="Did not understand the issue(s)" <?= ($hcci_data['cmt1A']=="Did not understand the issue(s)")?"selected":"" ?>
													<?= ($hcci_data['cmt1B']=="Did not understand the issue(s)")?"selected":"" ?>
													<?= ($hcci_data['cmt1C']=="Did not understand the issue(s)")?"selected":"" ?>
													>Did not understand the issue(s)</option>
													<option value="Did not probe to identify customer issue(s)" <?= ($hcci_data['cmt1B']=="Did not probe to identify customer issue(s)")?"selected":"" ?>
													<?= ($hcci_data['cmt1A']=="Did not probe to identify customer issue(s)")?"selected":"" ?>
													<?= ($hcci_data['cmt1C']=="Did not probe to identify customer issue(s)")?"selected":"" ?>>Did not probe to identify customer issue(s)</option>
													<option value="Did not ask the right kind of follow up question" <?= ($hcci_data['cmt1C']=="Did not ask the right kind of follow up question")?"selected":"" ?>
													<?= ($hcci_data['cmt1A']=="Did not ask the right kind of follow up question")?"selected":"" ?>
													<?= ($hcci_data['cmt1B']=="Did not ask the right kind of follow up question")?"selected":"" ?>
													>Did not ask the right kind of follow up question</option>
												</select>
												<!-- <input type="text" name="data[cmt1]" class="form-control" value="<?php //echo $hcci_data['cmt2'] ?>"></td> -->
											<td style="font-weight:bold; background-color:#D7BDE2">Customer Citical</td>
										</tr>
										<tr>
											
											<td>Issue Resolution</td>
											<td colspan=2>Did the agent resolve the issue(s) in a manner that does not require additional outreach from the customer? (One Call Resolution) "Yes" here means all of the customer's issues were addressed and don't require any additional assistance from our team.</td>
											<td>25</td>
											<td>
												<select class="form-control hcci_point customer" id="status_points2" name="data[issue_resolution]" required>
													
													<option hcci_val=25 <?php echo $hcci_data['issue_resolution'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option hcci_val=0 <?php echo $hcci_data['issue_resolution'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
												</select>
											</td>
											<td colspan=2>
												<select class="form-control multiple-select" name="data[cmt2][]" id="remarks2" multiple="multiple" disabled>
													<!-- <option value="">-Select-</option> -->
													<option value="Did not resolve one or more issues" <?= ($hcci_data['cmt2A']=="Did not resolve one or more issues")?"selected":"" ?>
													<?= ($hcci_data['cmt2B']=="Did not resolve one or more issues")?"selected":"" ?>
													<?= ($hcci_data['cmt2C']=="Did not resolve one or more issues")?"selected":"" ?>
													>Did not resolve one or more issues</option>
													<option value="Did not proactively offer help when it was warranted" <?= ($hcci_data['cmt2B']=="Did not proactively offer help when it was warranted")?"selected":"" ?>
													<?= ($hcci_data['cmt2A']=="Did not proactively offer help when it was warranted")?"selected":"" ?>
													<?= ($hcci_data['cmt2C']=="Did not proactively offer help when it was warranted")?"selected":"" ?>
													>Did not proactively offer help when it was warranted</option>
													<option value="Information given to user was inaccurate" <?= ($hcci_data['cmt2C']=="Information given to user was inaccurate")?"selected":"" ?>
													<?= ($hcci_data['cmt2A']=="Information given to user was inaccurate")?"selected":"" ?>
													<?= ($hcci_data['cmt2B']=="Information given to user was inaccurate")?"selected":"" ?>
													>Information given to user was inaccurate</option>
												</select>

												<!-- <input type="text" name="data[cmt1]" class="form-control" value="<?php //echo $hcci_data['cmt3'] ?>"> -->
											</td>
											<td style="font-weight:bold; background-color:#D7BDE2">Customer Citical</td>
										</tr>
										<tr>
											<td class="eml" rowspan=3>Policy Adherence</td>
											<td>Identify Verification</td>
											<td colspan=2>Did the agent verify the customer's identity before making changes to the booking or user profile? The agent must confirm 3 points of verification before making changes to the booking or the user's profile. User must be the one to state identification details. Agent should not read from information on the screen. If AGENT states these details, the answer should be 'NO'.</td>
											<td>20</td>
											<td>
												<select class="form-control hcci_point business" id="status_points3" name="data[identify_verification]" required>
													
													<option hcci_val=20 <?php echo $hcci_data['identify_verification'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option hcci_val=0 <?php echo $hcci_data['identify_verification'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
												</select>
											</td>
											<td colspan=2>
												<select class="form-control multiple-select" name="data[cmt3][]" id="remarks3" multiple="multiple" disabled>
													<!-- <option value="">-Select-</option> -->
													<option value="Did not request accepted point(s) of verification" <?= ($hcci_data['cmt3A']=="Did not request accepted point(s) of verification")?"selected":"" ?>
													<?= ($hcci_data['cmt3B']=="Did not request accepted point(s) of verification")?"selected":"" ?>
													>Did not request accepted point(s) of verification</option>
													<option value="Points of verification provided by user did not match account details, but agent proceeded" <?= ($hcci_data['cmt3B']=="Points of verification provided by user did not match account details, but agent proceeded")?"selected":"" ?>
													<?= ($hcci_data['cmt3A']=="Points of verification provided by user did not match account details, but agent proceeded")?"selected":"" ?>
													>Points of verification provided by user did not match account details, but agent proceeded</option>
												</select>
												<!-- <input type="text" name="data[cmt1]" class="form-control" value="<?php //echo $hcci_data['cmt1'] ?>"> -->
											</td>
											<td style="font-weight:bold; background-color:#D7BDE2">Business</td>
										</tr>
										<tr>
											<!-- <td class="eml" rowspan=2>Policy Adherence</td> -->
											<td>Situational Policy</td>
											<td colspan=2>Did the agent adhere to the designated policy for the customer's situation? "Yes" here means the agent scored "Yes" on criteria 1b, Issue Identification, chose the correct policy to address the issue raised, and followed the affiliated decision tree accurately. "No" here means the agent used the wrong policy for the customer's situation, did not follow the decision tree correctly, or misunderstood how to address the issue.</td>
											<td>25</td>
											<td>
												<select class="form-control hcci_point business" id="status_points4" name="data[situational_policy]" required>
													
													<option hcci_val=25 <?php echo $hcci_data['situational_policy'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option hcci_val=0 <?php echo $hcci_data['situational_policy'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
												</select>
											</td>
											<td colspan=2>
												<select class="form-control multiple-select" name="data[cmt4][]" id="remarks4" multiple="multiple" disabled>
													<!-- <option value="">-Select-</option> -->
													<option value="Did not follow the workflow correctly" <?= ($hcci_data['cmt4A']=="Did not follow the workflow correctly")?"selected":"" ?>
													<?= ($hcci_data['cmt4B']=="Did not follow the workflow correctly")?"selected":"" ?>
													<?= ($hcci_data['cmt4C']=="Did not follow the workflow correctly")?"selected":"" ?>
													<?= ($hcci_data['cmt4D']=="Did not follow the workflow correctly")?"selected":"" ?>
													>Did not follow the workflow correctly</option>
													<option value="Followed incorrect workflow" <?= ($hcci_data['cmt4B']=="Followed incorrect workflow")?"selected":"" ?>
													<?= ($hcci_data['cmt4A']=="Followed incorrect workflow")?"selected":"" ?>
													<?= ($hcci_data['cmt4C']=="Followed incorrect workflow")?"selected":"" ?>
													<?= ($hcci_data['cmt4D']=="Followed incorrect workflow")?"selected":"" ?>
													>Followed incorrect workflow</option>
													<option value="Did not adhere to policy" <?= ($hcci_data['cmt4C']=="Did not adhere to policy")?"selected":"" ?>
													<?= ($hcci_data['cmt4A']=="Did not adhere to policy")?"selected":"" ?>
													<?= ($hcci_data['cmt4B']=="Did not adhere to policy")?"selected":"" ?>
													<?= ($hcci_data['cmt4D']=="Did not adhere to policy")?"selected":"" ?>
													>Did not adhere to policy</option>
													<option value="Misunderstood how to address the issue(s)" <?= ($hcci_data['cmt4D']=="Misunderstood how to address the issue(s)")?"selected":"" ?>
													<?= ($hcci_data['cmt4A']=="Misunderstood how to address the issue(s)")?"selected":"" ?>
													<?= ($hcci_data['cmt4B']=="Misunderstood how to address the issue(s)")?"selected":"" ?>
													<?= ($hcci_data['cmt4C']=="Misunderstood how to address the issue(s)")?"selected":"" ?>
													>Misunderstood how to address the issue(s)</option>
												</select>
												<!-- <input type="text" name="data[cmt1]" class="form-control" value="<?php //echo $hcci_data['cmt1'] ?>"> -->
											</td>
											<td style="font-weight:bold; background-color:#D7BDE2">Business</td>
										</tr>
										<tr>
											<td>Strategic Cross-Sale Offered</td>
											<td colspan=2>Did the agent offer a Strategic (or Seasonal) Cross-Sale that is related to the current or upcoming Seaon or the user's current or past projects? The answer is "Yes", if the Cross Sale is related to the current SR or booking (or that of a project found in the User's SR activity within the past 30 days-in BETTI), or if the cross sale offered is Seasonal. If the agent offers a "Random" cross sale, the answer should be "No".</td>
											<td>15</td>
											<td>
												<select class="form-control hcci_point business"  name="data[strategic_Cross_Sale_Offered]" required>
													
													<option hcci_val=15 <?php echo $hcci_data['strategic_Cross_Sale_Offered'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option hcci_val=0 <?php echo $hcci_data['strategic_Cross_Sale_Offered'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
												</select>
											</td>
											<td colspan=2>
												<!-- <input type="text" name="data[cmt1]" class="form-control" value="<?php //echo $hcci_data['cmt1'] ?>"> -->
											</td>
											<td style="font-weight:bold; background-color:#D7BDE2">Business</td>
										</tr>
										<tr>
											<td class="eml" rowspan=4>Communication</td>
											<td>Call Beginning</td>
											<td colspan=2>Did the agent begin the call appropriately? This includes confirming understanding of the customer's issue(s) and, if necessary, empathizing for the situation. This does not mean following the workflow - it's instead asking if the agent began the call pleasantly, and apologizing for the customer's experience if needed.</td>
											<td>5</td>
											<td>
												<select class="form-control hcci_point customer" id="status_points5" name="data[call_Beginning]" required>
													
													<option hcci_val=5 <?php echo $hcci_data['call_Beginning'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option hcci_val=0 <?php echo $hcci_data['call_Beginning'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
												</select>
											</td>
											<td colspan=2>
												<select class="form-control multiple-select" name="data[cmt5][]" id="remarks5" multiple="multiple" disabled>
													<!-- <option value="">-Select-</option> -->
													<option value="Did not empathize when empathy was needed" <?= ($hcci_data['cmt5A']=="Did not empathize when empathy was needed")?"selected":"" ?>
													<?= ($hcci_data['cmt5B']=="Did not empathize when empathy was needed")?"selected":"" ?>
													<?= ($hcci_data['cmt5C']=="Did not empathize when empathy was needed")?"selected":"" ?>
													>Did not empathize when empathy was needed</option>
													<option value="Over-apologized" <?= ($hcci_data['cmt5B']=="Over-apologized")?"selected":"" ?>
													<?= ($hcci_data['cmt5A']=="Over-apologized")?"selected":"" ?>
													<?= ($hcci_data['cmt5C']=="Over-apologized")?"selected":"" ?>
													>Over-apologized</option>
													<option value="Did not introduce themselves to the user" <?= ($hcci_data['cmt5C']=="Did not introduce themselves to the user")?"selected":"" ?>
													<?= ($hcci_data['cmt5A']=="Did not introduce themselves to the user")?"selected":"" ?>
													<?= ($hcci_data['cmt5B']=="Did not introduce themselves to the user")?"selected":"" ?>
													>Did not introduce themselves to the user</option>
												</select>
												<!-- <input type="text" name="data[cmt1]" class="form-control" value="<?php //echo $hcci_data['cmt1'] ?>"> -->
											</td>
											<td style="font-weight:bold; background-color:#D7BDE2">Customer</td>
										</tr>
										<tr>
											<td>Call Control</td>
											<td colspan=2>Did the agent effectively lead the call and, if applicable, communicate resolution steps they were taking? If yes, the agent should be in control of the call and be able to help guide the user through the interaction. They should also communicate clearly which steps they are taking and what the resolution is.</td>
											<td>5</td>
											<td>
												<select class="form-control hcci_point customer" id="status_points6" name="data[call_Control]" required>
													
													<option hcci_val=5 <?php echo $hcci_data['call_Control'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option hcci_val=0 <?php echo $hcci_data['call_Control'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
												</select>
											</td>
											<td colspan=2>
												<select class="form-control multiple-select" name="data[cmt6][]" id="remarks6" multiple="multiple"disabled>
													<!-- <option value="">-Select-</option> -->
													<option value="Did not communicate steps taken to the user" <?= ($hcci_data['cmt6A']=="Did not communicate steps taken to the user")?"selected":"" ?>
													<?= ($hcci_data['cmt6B']=="Did not communicate steps taken to the user")?"selected":"" ?>
													<?= ($hcci_data['cmt6C']=="Did not communicate steps taken to the user")?"selected":"" ?>
													>Did not communicate steps taken to the user</option>
													<option value="Agent was not in control of the call" <?= ($hcci_data['cmt6B']=="Agent was not in control of the call")?"selected":"" ?>
													<?= ($hcci_data['cmt6A']=="Agent was not in control of the call")?"selected":"" ?>
													<?= ($hcci_data['cmt6C']=="Agent was not in control of the call")?"selected":"" ?>
													>Agent was not in control of the call</option>
													<option value="Gave inaccurate information to the user" <?= ($hcci_data['cmt6C']=="Gave inaccurate information to the user")?"selected":"" ?>
													<?= ($hcci_data['cmt6A']=="Gave inaccurate information to the user")?"selected":"" ?>
													<?= ($hcci_data['cmt6B']=="Gave inaccurate information to the user")?"selected":"" ?>
													>Gave inaccurate information to the user</option>
												</select>
												<!-- <input type="text" name="data[cmt1]" class="form-control" value="<?php //echo $hcci_data['cmt1'] ?>"> -->
											</td>
											<td style="font-weight:bold; background-color:#D7BDE2">Customer</td>
										</tr>
										<tr>
											<td>Pace</td>
											<td colspan=2>Was the agent's pace consistent? This includes avoiding long silences without explanation, allowing the user to speak if you're both trying to talk at the same time, allowing the user to finish their thoughts before responding, avoiding speaking too fast, and maintaining consistent tone throughout the call</td>
											<td>5</td>
											<td>
												<select class="form-control hcci_point customer" id="status_points7" name="data[pace]" required>
													
													<option hcci_val=5 <?php echo $hcci_data['pace'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option hcci_val=0 <?php echo $hcci_data['pace'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
												</select>
											</td>
											<td colspan=2>
												<select class="form-control multiple-select" name="data[cmt7][]" id="remarks7" multiple="multiple" disabled>
													<!-- <option value="">-Select-</option> -->
													<option value="Long silences were present during the interaction" <?= ($hcci_data['cmt7A']=="Long silences were present during the interaction")?"selected":"" ?>
													<?= ($hcci_data['cmt7B']=="Long silences were present during the interaction")?"selected":"" ?>
													<?= ($hcci_data['cmt7C']=="Long silences were present during the interaction")?"selected":"" ?>
													<?= ($hcci_data['cmt7D']=="Long silences were present during the interaction")?"selected":"" ?>
													>Long silences were present during the interaction</option>
													<option value="Agent did not allow user to finish their thoughts before responding" <?= ($hcci_data['cmt7B']=="Agent did not allow user to finish their thoughts before responding")?"selected":"" ?>
													<?= ($hcci_data['cmt7A']=="Agent did not allow user to finish their thoughts before responding")?"selected":"" ?>
													<?= ($hcci_data['cmt7C']=="Agent did not allow user to finish their thoughts before responding")?"selected":"" ?>
													<?= ($hcci_data['cmt7D']=="Agent did not allow user to finish their thoughts before responding")?"selected":"" ?>
													>Agent did not allow user to finish their thoughts before responding</option>
													<option value="Agent's tone was not consistent throughout conversation" <?= ($hcci_data['cmt7C']=="Agent's tone was not consistent throughout conversation")?"selected":"" ?>
													<?= ($hcci_data['cmt7A']=="Agent's tone was not consistent throughout conversation")?"selected":"" ?>
													<?= ($hcci_data['cmt7B']=="Agent's tone was not consistent throughout conversation")?"selected":"" ?>
													<?= ($hcci_data['cmt7D']=="Agent's tone was not consistent throughout conversation")?"selected":"" ?>
													>Agent's tone was not consistent throughout conversation</option>
													<option value="Pace of speech made the agent difficult to follow" <?= ($hcci_data['cmt7D']=="Pace of speech made the agent difficult to follow")?"selected":"" ?>
													<?= ($hcci_data['cmt7A']=="Pace of speech made the agent difficult to follow")?"selected":"" ?>
													<?= ($hcci_data['cmt7B']=="Pace of speech made the agent difficult to follow")?"selected":"" ?>
													<?= ($hcci_data['cmt7C']=="Pace of speech made the agent difficult to follow")?"selected":"" ?>
													>Pace of speech made the agent difficult to follow</option>
												</select>
												<!-- <input type="text" name="data[cmt1]" class="form-control" value="<?php //echo $hcci_data['cmt1'] ?>"> -->
											</td>
											<td style="font-weight:bold; background-color:#D7BDE2">Customer</td>
										</tr>
										<tr>
											<td>Holds</td>
											<td colspan=2>Did agent follow appropriate guidance for placing customer on hold? This includes requesting permission and estimating how long you will be before placing user on hold, completing work within estimated hold time, and, if exceeding estimated hold time, checking in with the user to update estimated time and confirming they're still able to wait on the line. If no hold was present, the answer is YES.</td>
											<td>5</td>
											<td>
												<select class="form-control hcci_point customer" id="status_points8" name="data[holds]" required>
													
													<option hcci_val=5 <?php echo $hcci_data['pace'] == "holds" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option hcci_val=0 <?php echo $hcci_data['holds'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
												</select>
											</td>
											<td colspan=2>
												<select class="form-control multiple-select" name="data[cmt8][]" id="remarks8" multiple="multiple" disabled>
													<!-- <option value="">-Select-</option> -->
													<option value="Agent did not request permission to place user on hold" <?= ($hcci_data['cmt8A']=="Agent did not request permission to place user on hold")?"selected":"" ?>
													<?= ($hcci_data['cmt8B']=="Agent did not request permission to place user on hold")?"selected":"" ?>
													<?= ($hcci_data['cmt8C']=="Agent did not request permission to place user on hold")?"selected":"" ?>
													<?= ($hcci_data['cmt8D']=="Agent did not request permission to place user on hold")?"selected":"" ?>
													<?= ($hcci_data['cmt8E']=="Agent did not request permission to place user on hold")?"selected":"" ?>
													>Agent did not request permission to place user on hold</option>
													<option value="Agent did not convey a hold duration to the customer" <?= ($hcci_data['cmt8B']=="Agent did not convey a hold duration to the customer")?"selected":"" ?>
													<?= ($hcci_data['cmt8A']=="Agent did not convey a hold duration to the customer")?"selected":"" ?>
													<?= ($hcci_data['cmt8C']=="Agent did not convey a hold duration to the customer")?"selected":"" ?>
													<?= ($hcci_data['cmt8D']=="Agent did not convey a hold duration to the customer")?"selected":"" ?>
													<?= ($hcci_data['cmt8E']=="Agent did not convey a hold duration to the customer")?"selected":"" ?>
													>Agent did not convey a hold duration to the customer</option>
													<option value="Agent did not check in with the user to update estimated time" <?= ($hcci_data['cmt8C']=="Agent did not check in with the user to update estimated time")?"selected":"" ?>
													<?= ($hcci_data['cmt8A']=="Agent did not check in with the user to update estimated time")?"selected":"" ?>
													<?= ($hcci_data['cmt8B']=="Agent did not check in with the user to update estimated time")?"selected":"" ?>
													<?= ($hcci_data['cmt8D']=="Agent did not check in with the user to update estimated time")?"selected":"" ?>
													<?= ($hcci_data['cmt8E']=="Agent did not check in with the user to update estimated time")?"selected":"" ?>
													>Agent did not check in with the user to update estimated time</option>
													<option value="Hold was inappropriate or unnecessary" <?= ($hcci_data['cmt8D']=="Hold was inappropriate or unnecessary")?"selected":"" ?>
													<?= ($hcci_data['cmt8A']=="Hold was inappropriate or unnecessary")?"selected":"" ?>
													<?= ($hcci_data['cmt8B']=="Hold was inappropriate or unnecessary")?"selected":"" ?>
													<?= ($hcci_data['cmt8C']=="Hold was inappropriate or unnecessary")?"selected":"" ?>
													<?= ($hcci_data['cmt8E']=="Hold was inappropriate or unnecessary")?"selected":"" ?>
													>Hold was inappropriate or unnecessary</option>
													<option value="Agent placed the user on 'Mute' rather than using the hold button" <?= ($hcci_data['cmt8E']=="Agent placed the user on 'Mute' rather than using the hold button")?"selected":"" ?>
													<?= ($hcci_data['cmt8A']=="Agent placed the user on 'Mute' rather than using the hold button")?"selected":"" ?>
													<?= ($hcci_data['cmt8B']=="Agent placed the user on 'Mute' rather than using the hold button")?"selected":"" ?>
													<?= ($hcci_data['cmt8C']=="Agent placed the user on 'Mute' rather than using the hold button")?"selected":"" ?>
													<?= ($hcci_data['cmt8D']=="Agent placed the user on 'Mute' rather than using the hold button")?"selected":"" ?>
													>Agent placed the user on 'Mute' rather than using the hold button</option>
												</select>
												<!-- <input type="text" name="data[cmt1]" class="form-control" value="<?php //echo $hcci_data['cmt1'] ?>"> -->
											</td>
											<td style="font-weight:bold; background-color:#D7BDE2">Customer</td>
										</tr>
										<tr>
											<td class="eml" rowspan=5>Internal Processes</td>
											<td>Dash Documentation</td>
											<td colspan=2>Did the agent correctly document this interaction in Dash? This includes leaving the date, agent name, relevant notes of actions taken, and the Zendesk ticket number.</td>
											<td>5</td>
											<td>
												<select class="form-control hcci_point compliance" id="status_points9" name="data[dash_Documentation]" required>
													
													<option hcci_val=5 <?php echo $hcci_data['pace'] == "dash_Documentation" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option hcci_val=0 <?php echo $hcci_data['dash_Documentation'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
												</select>
											</td>
											<td colspan=2>
												<select class="form-control multiple-select" name="data[cmt9][]" id="remarks9" multiple="multiple" disabled>
													<!-- <option value="">-Select-</option> -->
													<option value="Missing date" <?= ($hcci_data['cmt9A']=="Missing date")?"selected":"" ?>
													<?= ($hcci_data['cmt9B']=="Missing date")?"selected":"" ?>
													<?= ($hcci_data['cmt9C']=="Missing date")?"selected":"" ?>
													<?= ($hcci_data['cmt9D']=="Missing date")?"selected":"" ?>
													<?= ($hcci_data['cmt9E']=="Missing date")?"selected":"" ?>
													>Missing date</option>
													<option value="Missing agent name" <?= ($hcci_data['cmt9B']=="Missing agent name")?"selected":"" ?>
													<?= ($hcci_data['cmt9A']=="Missing agent name")?"selected":"" ?>
													<?= ($hcci_data['cmt9C']=="Missing agent name")?"selected":"" ?>
													<?= ($hcci_data['cmt9D']=="Missing agent name")?"selected":"" ?>
													<?= ($hcci_data['cmt9E']=="Missing agent name")?"selected":"" ?>
													>Missing agent name</option>
													<option value="Missing or incomplete note of action taken" <?= ($hcci_data['cmt9C']=="Missing or incomplete note of action taken")?"selected":"" ?>
													<?= ($hcci_data['cmt9A']=="Missing or incomplete note of action taken")?"selected":"" ?>
													<?= ($hcci_data['cmt9B']=="Missing or incomplete note of action taken")?"selected":"" ?>
													<?= ($hcci_data['cmt9D']=="Missing or incomplete note of action taken")?"selected":"" ?>
													<?= ($hcci_data['cmt9E']=="Missing or incomplete note of action taken")?"selected":"" ?>
													>Missing or incomplete note of action taken</option>
													<option value="Incorrect Dash note format used" <?= ($hcci_data['cmt9D']=="Incorrect Dash note format used")?"selected":"" ?>
													<?= ($hcci_data['cmt9A']=="Incorrect Dash note format used")?"selected":"" ?>
													<?= ($hcci_data['cmt9B']=="Incorrect Dash note format used")?"selected":"" ?>
													<?= ($hcci_data['cmt9C']=="Incorrect Dash note format used")?"selected":"" ?>
													<?= ($hcci_data['cmt9E']=="Incorrect Dash note format used")?"selected":"" ?>
													>Incorrect Dash note format used</option>
													<option value="Incomplete relevant information in notes" <?= ($hcci_data['cmt9E']=="Incomplete relevant information in notes")?"selected":"" ?>
													<?= ($hcci_data['cmt9A']=="Incomplete relevant information in notes")?"selected":"" ?>
													<?= ($hcci_data['cmt9B']=="Incomplete relevant information in notes")?"selected":"" ?>
													<?= ($hcci_data['cmt9C']=="Incomplete relevant information in notes")?"selected":"" ?>
													<?= ($hcci_data['cmt9D']=="Incomplete relevant information in notes")?"selected":"" ?>
													>Incomplete relevant information in notes</option>
												</select>
												<!-- <input type="text" name="data[cmt1]" class="form-control" value="<?php //echo $hcci_data['cmt1'] ?>"> -->
											</td>
											<td style="font-weight:bold; background-color:#D7BDE2">Compliance</td>
										</tr>
										<tr>
											<td>Disposition Tagging</td>
											<td colspan=2>Did the agent select the best available ticket disposition? Tagging should reflect the inbound ticket. "Yes" here means the agent scored "Yes" on criteria 1b, Issue Identification, as well as criteria 2b, Situational Policy, and tagged the ticket according to the issue(s) and policies addressed by criteria 1b and 2b.</td>
											<td>20</td>
											<td>
												<select class="form-control hcci_point business" id="status_points10" name="data[disposition_Tagging]" required>
													
													<option hcci_val=20 <?php echo $hcci_data['pace'] == "disposition_Tagging" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option hcci_val=0 <?php echo $hcci_data['disposition_Tagging'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
												</select>
											</td>
											<td colspan=2>
												<select class="form-control multiple-select" name="data[cmt10][]" id="remarks10" multiple="multiple" disabled>
													<!-- <option value="">-Select-</option> -->
													<option value="Disposition was not updated correctly with new reply" <?= ($hcci_data['cmt10A']=="Disposition was not updated correctly with new reply")?"selected":"" ?>
													<?= ($hcci_data['cmt10B']=="Disposition was not updated correctly with new reply")?"selected":"" ?>
													>Disposition was not updated correctly with new reply</option>
													<option value="Incorrect disposition chosen" <?= ($hcci_data['cmt10B']=="Incorrect disposition chosen")?"selected":"" ?>
													<?= ($hcci_data['cmt10A']=="Incorrect disposition chosen")?"selected":"" ?>
													>Incorrect disposition chosen</option>
												</select>
												<!-- <input type="text" name="data[cmt1]" class="form-control" value="<?php //echo $hcci_data['cmt1'] ?>"> -->
											</td>
											<td style="font-weight:bold; background-color:#D7BDE2">Business</td>
										</tr>
										<tr>
											<td>Betti SR Audit</td>
											<td colspan=2>Did the agent perform the Lead Audit Interview in BETTI? A Lead Audit Interview must be performed in BETTI, on the SR corresponding to the booking ID in DASH, whenever changes or updates are made in DASH. "YES" means the agent performed the Lead Audit Interview, on the correct SR in BETTI, and selected "Customer Serious".</td>
											<td>5</td>
											<td>
												<select class="form-control hcci_point business" id="status_points11" name="data[betti_SR_Audit]" required>
													
													<option hcci_val=5 <?php echo $hcci_data['pace'] == "betti_SR_Audit" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option hcci_val=0 <?php echo $hcci_data['betti_SR_Audit'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
												</select>
											</td>
											<td colspan=2>
												<select class="form-control multiple-select" name="data[cmt11][]" id="remarks11" multiple="multiple" disabled>
													<!-- <option value="">-Select-</option> -->
													<option value="The Agent did NOT perform Lead Audit Interview in BETTI." <?= ($hcci_data['cmt11A']=="The Agent did NOT perform Lead Audit Interview in BETTI.")?"selected":"" ?>
													<?= ($hcci_data['cmt11B']=="The Agent did NOT perform Lead Audit Interview in BETTI.")?"selected":"" ?>
													<?= ($hcci_data['cmt11C']=="The Agent did NOT perform Lead Audit Interview in BETTI.")?"selected":"" ?>
													>The Agent did NOT perform Lead Audit Interview in BETTI.</option>
													<option value="The Agent did NOT perform the Audit on the CORRECT SR in BETTI." <?= ($hcci_data['cmt11B']=="The Agent did NOT perform the Audit on the CORRECT SR in BETTI.")?"selected":"" ?>
													<?= ($hcci_data['cmt11A']=="The Agent did NOT perform the Audit on the CORRECT SR in BETTI.")?"selected":"" ?>
													<?= ($hcci_data['cmt11C']=="The Agent did NOT perform the Audit on the CORRECT SR in BETTI.")?"selected":"" ?>
													>The Agent did NOT perform the Audit on the CORRECT SR in BETTI.</option>
													<option value="Performed Lead Audit Interview in BETTI, did NOT Select Customer Serious" <?= ($hcci_data['cmt11C']=="Performed Lead Audit Interview in BETTI, did NOT Select Customer Serious")?"selected":"" ?>
													<?= ($hcci_data['cmt11A']=="Performed Lead Audit Interview in BETTI, did NOT Select Customer Serious")?"selected":"" ?>
													<?= ($hcci_data['cmt11B']=="Performed Lead Audit Interview in BETTI, did NOT Select Customer Serious")?"selected":"" ?>
													>Performed Lead Audit Interview in BETTI, did NOT Select Customer Serious</option>
												</select>
												<!-- <input type="text" name="data[cmt1]" class="form-control" value="<?php //echo $hcci_data['cmt1'] ?>"> -->
											</td>
											<td style="font-weight:bold; background-color:#D7BDE2">Business</td>
										</tr>
										<tr>
											<td>Escalation</td>
											<td colspan=2>Did the agent follow the correct escalation process? This includes recognizing that a situation is an escalation and following the correct escalation process. If the agent escalated the ticket/call, but they should have been able to work the call themselves, mark NO.</td>
											<td>5</td>
											<td>
												<select class="form-control hcci_point compliance" name="data[escalation]" required>
													
													<option hcci_val=5 <?php echo $hcci_data['pace'] == "escalation" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option hcci_val=0 <?php echo $hcci_data['escalation'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
												</select>
											</td>
											<td colspan=2>
												<!-- <input type="text" name="data[cmt1]" class="form-control" value="<?php //echo $hcci_data['cmt1'] ?>"> -->
											</td>
											<td style="font-weight:bold; background-color:#D7BDE2">Compliance</td>
										</tr>
										<tr>
											<td>Correct Action</td>
											<td colspan=2>Did the agent take the correct action? This means using the correct resolution wizard and taking all the steps the agent said they would in their conversation with the customer. If only some of the actions were taken correctly this should be scored "No."</td>
											<td>5</td>
											<td>
												<select class="form-control hcci_point business" name="data[correct_Action]" required>
													
													<option hcci_val=5 <?php echo $hcci_data['correct_Action'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option hcci_val=0 <?php echo $hcci_data['correct_Action'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
												</select>
											</td>
											<td colspan=2>
												<!-- <input type="text" name="data[cmt1]" class="form-control" value="<?php //echo $hcci_data['cmt1'] ?>"> -->
											</td>
											<td style="font-weight:bold; background-color:#D7BDE2">Business</td>
										</tr>
										
										<tr>
											<td class="eml" rowspan=6 colspan=2>Critical Fail Behaviors</td>
											<!-- <td rowspan=6 >Critical Fail Behaviors</td> -->
											<td class="text-danger" colspan=2>Unintelligible language</td>
											<td>0</td>
											<td>
												<select class="form-control hcci_point hcci_fatal" name="data[unintelligible_language]" required>
													
													<option hcci_val=0 <?php echo $hcci_data['unintelligible_language'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option hcci_val=0 <?php echo $hcci_data['unintelligible_language'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
												</select>
											</td>
											<td colspan=2>
												<!-- <input type="text" name="data[cmt1]" class="form-control" value="<?php //echo $hcci_data['cmt1'] ?>"> -->
											</td>
											<td style="font-weight:bold; background-color:#D7BDE2">Compliance</td>
										</tr>
										<tr>
											
											<td  class="text-danger" colspan=2>Failed to address one or more of the customer's issue(s)</td>
											<td>0</td>
											<td>
												<select class="form-control hcci_point hcci_fatal" name="data[address_customer_issues]" required>
													
													<option hcci_val=0 <?php echo $hcci_data['address_customer_issues'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option hcci_val=0 <?php echo $hcci_data['address_customer_issues'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
												</select>
											</td>
											<td colspan=2>
												<!-- <input type="text" name="data[cmt1]" class="form-control" value="<?php //echo $hcci_data['cmt1'] ?>"> -->
											</td>
											<td style="font-weight:bold; background-color:#D7BDE2">Compliance</td>
										</tr>
										<tr>
											
											<td class="text-danger" colspan=2>Failed to validate customer's account</td>
											<td>0</td>
											<td>
												<select class="form-control hcci_point hcci_fatal" name="data[validate_customers_account]" required>
													
													<option hcci_val=0 <?php echo $hcci_data['validate_customers_account'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option hcci_val=0 <?php echo $hcci_data['validate_customers_account'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
												</select>
											</td>
											<td colspan=2>
												<!-- <input type="text" name="data[cmt1]" class="form-control" value="<?php //echo $hcci_data['cmt1'] ?>"> -->
											</td>
											<td style="font-weight:bold; background-color:#D7BDE2">Compliance</td>
										</tr>
										<tr>
											
											<td class="text-danger" colspan=2>Failed to implement correct outcome according to workflow or policy</td>
											<td>0</td>
											<td>
												<select class="form-control hcci_point hcci_fatal" name="data[correct_outcome]" required>
													
													<option hcci_val=0 <?php echo $hcci_data['correct_outcome'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option hcci_val=0 <?php echo $hcci_data['correct_outcome'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
												</select>
											</td>
											<td colspan=2>
												<!-- <input type="text" name="data[cmt1]" class="form-control" value="<?php //echo $hcci_data['cmt1'] ?>"> -->
											</td>
											<td style="font-weight:bold; background-color:#D7BDE2">Compliance</td>
										</tr>
										<tr>
											
											<td class="text-danger" colspan=2>Egregious policy error (excessive OOP, gave out personal information w/o permission, etc.) - DISCIPLINARY ACTION REQUIRED</td>
											<td>0</td>
											<td>
												<select class="form-control hcci_point hcci_fatal" name="data[egregious_policy_error]" required>
													
													<option hcci_val=0 <?php echo $hcci_data['egregious_policy_error'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option hcci_val=0 <?php echo $hcci_data['egregious_policy_error'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
												</select>
											</td>
											<td colspan=2>
												<!-- <input type="text" name="data[cmt1]" class="form-control" value="<?php //echo $hcci_data['cmt1'] ?>"> -->
											</td>
											<td style="font-weight:bold; background-color:#D7BDE2">Compliance</td>
										</tr>
										<tr>
											
											<td class="text-danger" colspan=2>Flagrantly inappropriate response (cursing, insulting, speaking negatively of company/agent/pro, etc.) - DISCIPLINARY ACTION REQUIRED</td>
											<td>0</td>
											<td>
												<select class="form-control hcci_point hcci_fatal" name="data[flagrantly_inappropriate_response]" required>
													
													<option hcci_val=0 <?php echo $hcci_data['flagrantly_inappropriate_response'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option hcci_val=0 <?php echo $hcci_data['flagrantly_inappropriate_response'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
												</select>
											</td>
											<td colspan=2>
												<!-- <input type="text" name="data[cmt1]" class="form-control" value="<?php //echo $hcci_data['cmt1'] ?>"> -->
											</td>
											<td style="font-weight:bold; background-color:#D7BDE2">Compliance</td>
										</tr>

										<tr>
											<td class="eml" rowspan=6 colspan=2>For Coaching</td>
											<!-- <td rowspan=6 >Critical Fail Behaviors</td> -->
											<td colspan=2>Failed to build Value in ANGI Services</td>
											<td>0</td>
											<td>
												<select class="form-control hcci_point" name="data[build_ANGI_Services]" required>
													
													<option hcci_val=0 <?php echo $hcci_data['build_ANGI_Services'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option hcci_val=0 <?php echo $hcci_data['build_ANGI_Services'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
												</select>
											</td>
											<td colspan=2>
												<!-- <input type="text" name="data[cmt1]" class="form-control" value="<?php //echo $hcci_data['cmt1'] ?>"> -->
											</td>
											<td style="font-weight:bold; background-color:#D7BDE2"></td>
										</tr>
										<tr>
											
											<td colspan=2>Failed to mention Stella Survey</td>
											<td>0</td>
											<td>
												<select class="form-control hcci_point" name="data[mention_Stella_Survey]" required>
													
													<option hcci_val=0 <?php echo $hcci_data['mention_Stella_Survey'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option hcci_val=0 <?php echo $hcci_data['mention_Stella_Survey'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
												</select>
											</td>
											<td colspan=2>
												<!-- <input type="text" name="data[cmt1]" class="form-control" value="<?php //echo $hcci_data['cmt1'] ?>"> -->
											</td>
											<td style="font-weight:bold; background-color:#D7BDE2"></td>
										</tr>
										<tr>
											
											<td colspan=2>Failed to mention the "ANGI APP"</td>
											<td>0</td>
											<td>
												<select class="form-control hcci_point" name="data[mention_ANGI_APP]" required>
													
													<option hcci_val=0 <?php echo $hcci_data['mention_ANGI_APP'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option hcci_val=0 <?php echo $hcci_data['mention_ANGI_APP'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
												</select>
											</td>
											<td colspan=2>
												<!-- <input type="text" name="data[cmt1]" class="form-control" value="<?php //echo $hcci_data['cmt1'] ?>"> -->
											</td>
											<td style="font-weight:bold; background-color:#D7BDE2"></td>
										</tr>
									</tbody>
								</table>
							</div>
							<div class="table-responsive top-space">
								<table class="table table-striped skt-table" width="100%">
									<tbody>

									<tr style="font-weight:bold; background-color:#D7BDE2"><td colspan=2>Customer Score</td><td colspan=2>Business Score</td><td colspan=2>Compliance Score</td></tr>
									<tr style="font-weight:bold; background-color:#D7BDE2">
										<td>Earned Point:</td><td ><input type="text" readonly class="form-control" id="customer_earnedCore_score" name="data[customer_earned_score]" value="<?php echo $hcci_data['customer_earned_score']; ?>"></td>
										<td>Earned Point:</td><td ><input type="text" readonly class="form-control" id="business_earnedCore_score" name="data[business_earned_score]" value="<?php echo $hcci_data['business_earned_score']; ?>"></td>
										<td>Earned Point:</td><td ><input type="text" readonly class="form-control" id="compliance_earnedCore_score" name="data[compliance_earned_score]" value="<?php echo $hcci_data['compliance_earned_score']; ?>"></td>
									</tr>
									<tr style="font-weight:bold; background-color:#D7BDE2">
										<td>Possible Point:</td><td ><input type="text" readonly class="form-control" id="customer_possibleCore_score" name="data[customer_possible_score]" value="<?php echo $hcci_data['customer_possible_score']; ?>"></td>
										<td>Possible Point:</td><td ><input type="text" readonly class="form-control" id="business_possibleCore_score" name="data[business_possible_score]" value="<?php echo $hcci_data['business_possible_score']; ?>"></td>
										<td>Possible Point:</td><td ><input type="text" readonly class="form-control" id="compliance_possibleCore_score" name="data[compliance_possible_score]" value="<?php echo $hcci_data['compliance_possible_score']; ?>"></td>
									</tr>
									<tr style="font-weight:bold; background-color:#D7BDE2">
										<td>Overall Percentage:</td><td ><input type="text" readonly class="form-control" id="customer_overall_score" name="data[customer_overall_score]" value="<?php echo $hcci_data['customer_overall_score'] ?>"></td>
										<td>Overall Percentage:</td><td ><input type="text" readonly class="form-control" id="business_overall_score" name="data[business_overall_score]" value="<?php echo $hcci_data['business_overall_score'] ?>"></td>
										<td>Overall Percentage:</td><td ><input type="text" readonly class="form-control" id="compliance_overall_score" name="data[compliance_overall_score]" value="<?php echo $hcci_data['compliance_overall_score'] ?>"></td>
									</tr>
										<tr>
											<td>Call Summary:</td>
											<td colspan=2><textarea class="form-control" name="data[call_summary]"><?php echo $hcci_data['call_summary'] ?></textarea></td>
											<td>Feedback:</td>
											<td colspan=2><textarea class="form-control" name="data[feedback]"><?php echo $hcci_data['feedback'] ?></textarea></td>
										</tr>
										<tr>
											<td colspan=2>Upload Files (Mp4/Mp3/M4a/Wav)</td>
											<?php if ($hcci_id == 0) { ?>
												<td colspan=4><input type="file" multiple class="form-control" id="attach_file" name="attach_file[]" accept=".m4a,.mp4,.mp3,.wav,audio/*" ></td>
												<?php } else {
												if ($hcci_data['attach_file'] != '') { ?>
													<td colspan=4>
														<input type="file" multiple class="form-control"  id="attach_file" name="attach_file[]" accept=".m4a,.mp4,.mp3,.wav,audio/*" >
														<?php $attach_file = explode(",", $hcci_data['attach_file']);
														foreach ($attach_file as $mp) { ?>
															<audio controls='' style="background-color:#607F93">
																<source src="<?php echo base_url(); ?>qa_files/qa_homeadvisor/hcci_files/<?php echo $mp; ?>" type="audio/ogg">
																<source src="<?php echo base_url(); ?>qa_files/qa_homeadvisor/hcci_files/<?php echo $mp; ?>" type="audio/mpeg">
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

										<?php if ($hcci_id != 0) { ?>
											<tr>
												<td colspan=2 style="font-size:16px; font-weight:bold">Agent Feedback Acceptance:</td>
												<td colspan=4><?php echo $hcci_data['agnt_fd_acpt'] ?></td>
											</tr>
											<tr>
												<td colspan=2 style="font-size:16px; font-weight:bold">Agent Review:</td>
												<td colspan=4><?php echo $hcci_data['agent_rvw_note'] ?></td>
											</tr>
											<tr>
												<td colspan=2 style="font-size:16px; font-weight:bold">Management Review:</td>
												<td colspan=4><?php echo $hcci_data['mgnt_rvw_note'] ?></td>
											</tr>
											<tr>
												<td colspan=2 style="font-size:16px; font-weight:bold">Client Review:</td>
												<td colspan=4><?php echo $hcci_data['client_rvw_note'] ?></td>
											</tr>

											<tr>
												<td colspan=2 style="font-size:16px">Your Review<span style="font-size:24px;color:red">*</span></td>
												<td colspan=4><textarea class="form-control1" style="width:100%" id="note" name="note" required></textarea></td>
											</tr>
										<?php } ?>

										<?php
										if ($hcci_id == 0) {
											if (is_access_qa_module() == true || is_access_qa_operations_module() == true) { ?>
												<tr>
													<td colspan=6><button class="btn btn-success waves-effect" type="submit" id="qaformsubmit" style="width:500px;margin:auto;display:block;">SAVE</button></td>
												</tr>
												<?php
											}
										} else {
											if (is_access_qa_module() == true || is_access_qa_operations_module() == true) {
												if (is_available_qa_feedback($hcci_data['entry_date'], 72) == true) { ?>
													<tr>
														<td colspan="6"><button class="btn btn-success waves-effect" type="submit" id='qaformsubmit' name='btnSave' value="SAVE" style="width:500px;margin:auto;display:block;">SAVE</button></td>
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

