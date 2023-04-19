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
											<td colspan="10" id="theader" style="font-size:40px">AGENT HCCI [CORE V2]</td>
											<input type="hidden" name="audit_start_time" value="<?php echo CurrMySqlDate(); ?>">
										</tr>
									
										<tr>
											<td>Auditor Name:</td>
											<?php if($agnt_feedback['entry_by']!=''){
												$auditorName = $agnt_feedback['auditor_name'];
											}else{
												$auditorName = $agnt_feedback['client_name'];
										} ?>
											<td><input type="text" class="form-control" value="<?= $auditorName; ?>" disabled></td>
											<td>Audit Date:</td>
											<td><input type="text" class="form-control" value="<?php echo mysql2mmddyy($agnt_feedback['audit_date']); ?>" disabled></td>
											<td>Contact Date:</td>
											<td>
												<input type="text" id="call_date" name="call_date"  onkeydown="return false;" value="<?php echo mysql2mmddyy($agnt_feedback['call_date']); ?>" max="<?php echo date("Y-m-d"); ?>" class="form-control" disabled>
											</td>
										</tr>
										<tr>
											<td>Agent Name:</td>
											<td>
												<select class="form-control" id="agent_id" name="data[agent_id]" disabled="">
												<option value="<?php echo $agnt_feedback['agent_id'] ?>"><?php echo $agnt_feedback['fname']." ".$agnt_feedback['lname'] ?></option>
												<option value="">-Select-</option>
												<?php foreach($agentName as $row):  ?>
													<option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
												<?php endforeach; ?>
											</select>
											</td>
											<td>Fusion ID:</td>
											<td><input type="text" disabled class="form-control" id="fusion_id" value="<?php echo $agnt_feedback['fusion_id'] ?>"></td>
											<td>L1 Supervisor:</td>
											<td>
												
								
												<input type="text" class="form-control" id="tl_name" disabled value="<?php echo $agnt_feedback['tl_name'] ?>" readonly>
												<input type="hidden" class="form-control" id="tl_id" name="data[tl_id]" value="<?php echo $agnt_feedback['tl_id'] ?>" disabled>
											</td>
										</tr>
										<tr>
											<td>Call File:</td>
											<td>
												<input type="text" class="form-control" id="call_file" name="data[call_file]" disabled value="<?php echo $agnt_feedback['call_file'] ?>">
											</td>
											<td>Contact Duration:</td>
											<td><input type="text" class="form-control" onkeydown="return false;" id="call_duration" name="data[call_duration]" value="<?php echo $agnt_feedback['call_duration']?>" disabled></td>
										
											<td>SR No:</td>
											<td>
												<input type="text" class="form-control" id="sr_no" name="data[sr_no]" disabled value="<?php echo $agnt_feedback['sr_no'] ?>">
											</td>
										</tr>
										<tr>
											<td>Consumer No:</td>
											<td><input type="text" class="form-control" id="phone" name="data[consumer_no]" value="<?php echo $agnt_feedback['consumer_no'] ?>" onkeyup="checkDec(this);" disabled>
												<span id="start_phone" style="color:red"></span></td>

											<td>VOC:</td>
											<td>
												<select class="form-control" id="voc" name="data[voc]" disabled>
													
													<option value="">-Select-</option>
													<option value="1"  <?= ($agnt_feedback['voc']=="1")?"selected":"" ?>>1</option>
													<option value="2"  <?= ($agnt_feedback['voc']=="2")?"selected":"" ?>>2</option>
													<option value="3"  <?= ($agnt_feedback['voc']=="3")?"selected":"" ?>>3</option>
													<option value="4"  <?= ($agnt_feedback['voc']=="4")?"selected":"" ?>>4</option>
													<option value="5"  <?= ($agnt_feedback['voc']=="5")?"selected":"" ?>>5</option>
													<option value="6"  <?= ($agnt_feedback['voc']=="6")?"selected":"" ?>>6</option>
													<option value="7"  <?= ($agnt_feedback['voc']=="7")?"selected":"" ?>>7</option>
													<option value="8"  <?= ($agnt_feedback['voc']=="8")?"selected":"" ?>>8</option>
													<option value="9"  <?= ($agnt_feedback['voc']=="9")?"selected":"" ?>>9</option>
													<option value="10"  <?= ($agnt_feedback['voc']=="10")?"selected":"" ?>>10</option>
												</select>
											</td>
											<td>Audit Type:</td>
											<td>
												<select class="form-control" id="audit_type" name="data[audit_type]" disabled>
                                                    <option value="">-Select-</option>
                                                    <option value="CQ Audit" <?= ($agnt_feedback['audit_type']=="CQ Audit")?"selected":"" ?>>CQ Audit</option>
                                                    <option value="BQ Audit" <?= ($agnt_feedback['audit_type']=="BQ Audit")?"selected":"" ?>>BQ Audit</option>
                                                    <option value="Calibration" <?= ($agnt_feedback['audit_type']=="Calibration")?"selected":"" ?>>Calibration</option>
                                                    <option value="Pre-Certificate Mock Call" <?= ($agnt_feedback['audit_type']=="Pre-Certificate Mock Call")?"selected":"" ?>>Pre-Certificate Mock Call</option>
                                                    <option value="Certification Audit" <?= ($agnt_feedback['audit_type']=="Certification Audit")?"selected":"" ?>>Certification Audit</option>
                                                    <option value="Operation Audit" <?= ($agnt_feedback['audit_type']=="Operation Audit")?"selected":"" ?>>Operation Audit</option>
                                                    <option value="Trainer Audit"  <?= ($agnt_feedback['audit_type']=="Trainer Audit")?"selected":"" ?>>Trainer Audit</option>
                                                </select>
											</td>
										</tr>
										<tr>
											<td class="auType">Auditor Type</td>
											<td class="auType">
												<select class="form-control" id="auditor_type" name="data[auditor_type]">
                                                    
                                                    <option value="Master" <?= ($agnt_feedback['auditor_type']=="Master")?"selected":"" ?>>Master</option>
                                                    <option value="Regular" <?= ($agnt_feedback['auditor_type']=="Regular")?"selected":"" ?>>Regular</option>
                                                </select>
											</td>
											
										</tr>
										<tr>
											<td style="font-weight:bold; font-size:16px; text-align:left">Earned Score</td>
											<td><input type="text" readonly id="hcci_earned_score" name="data[earned_score]" class="form-control" value="<?php echo $agnt_feedback['earned_score'] ?>" /></td>
											<td style="font-weight:bold; font-size:16px; text-align:left">Possible Score</td>
											<td><input type="text" readonly id="hcci_possible_score" name="data[possible_score]" class="form-control" value="<?php echo $agnt_feedback['possible_score'] ?>" /></td>
											<td style="font-weight:bold; font-size:16px; text-align:right">Overall Score:</td>
											<td><input type="text" readonly id="hcci_overall_score" name="data[overall_score]" class="form-control avonFatal" style="font-weight:bold" value="<?php echo $agnt_feedback['overall_score'].'%' ?>"></td>
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
											<td>STATUS</td>
											<td colspan="0" style="width:150px;display:block;margin:auto;border:none;">REMARKS</td>
											<td colspan="2">Critical Accuracy</td>
										</tr>

										<tr>
											
											<td class="eml" rowspan=3>Issue Identification</td>
											<td>Brand</td>
											<td colspan=2>Did the agent use the correct brand? The agent correctly identified as Angi, and if applicable, the partnership the customer booked through.</td>
											<td>5</td>
											<td style="width:100px;">
												<select class="form-control hcci_point business" name="data[brand]" disabled>
													
													<option hcci_val=5 <?php echo $agnt_feedback['brand'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option hcci_val=0 <?php echo $agnt_feedback['brand'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
												</select>
											</td>
											<td colspan=2><!-- <input type="text" name="data[cmt1]" class="form-control" value="<?php //echo $agnt_feedback['cmt1'] ?>"> --></td>
											<td style="font-weight:bold; background-color:#D7BDE2">Business Citical</td>
										</tr>

										<tr>
											
											<td>Issue Identification</td>
											<td colspan=2>Did the agent correctly identify the issue(s) or, if unclear, did they ask the right kind of clarifying question? "Yes" here means the agent completely understood every part of the issue(s), including the root cause of the issue(s), and identified when multiple issues were raised by the customer. If the agent misunderstood some of the issue(s) or all of the issue(s) they should be scored "No."</td>
											<td>25</td>
											<td>
												<select class="form-control hcci_point customer" name="data[issue_identification]" disabled>
													
													<option hcci_val=25 <?php echo $agnt_feedback['issue_identification'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option hcci_val=0 <?php echo $agnt_feedback['issue_identification'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
												</select>
											</td>
											<td colspan=2>
												
											    <select class="form-control multiple-select" name="data[cmt1]" multiple="multiple" disabled>
													<option value="">-Select-</option>
													<option value="Did not understand the issue(s)" <?= ($agnt_feedback['cmt1A']=="Did not understand the issue(s)")?"selected":"" ?>>Did not understand the issue(s)</option>
													<option value="Did not probe to identify customer issue(s)" <?= ($agnt_feedback['cmt1B']=="Did not probe to identify customer issue(s)")?"selected":"" ?>>Did not probe to identify customer issue(s)</option>
													<option value="Did not ask the right kind of follow up question" <?= ($agnt_feedback['cmt1C']=="Did not ask the right kind of follow up question")?"selected":"" ?>>Did not ask the right kind of follow up question</option>
												</select>
												<!-- <input type="text" name="data[cmt1]" class="form-control" value="<?php //echo $agnt_feedback['cmt2'] ?>"></td> -->
											<td style="font-weight:bold; background-color:#D7BDE2">Customer Citical</td>
										</tr>
										<tr>
											
											<td>Issue Resolution</td>
											<td colspan=2>Did the agent resolve the issue(s) in a manner that does not require additional outreach from the customer? (One Call Resolution) "Yes" here means all of the customer's issues were addressed and don't require any additional assistance from our team.</td>
											<td>25</td>
											<td>
												<select class="form-control hcci_point customer" name="data[issue_resolution]" disabled>
													
													<option hcci_val=25 <?php echo $agnt_feedback['issue_resolution'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option hcci_val=0 <?php echo $agnt_feedback['issue_resolution'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
												</select>
											</td>
											<td colspan=2>
												<select class="form-control multiple-select" name="data[cmt2]" multiple="multiple" disabled>
													<option value="">-Select-</option>
													<option value="Did not resolve one or more issues" <?= ($agnt_feedback['cmt2A']=="Did not resolve one or more issues")?"selected":"" ?>>Did not resolve one or more issues</option>
													<option value="Did not proactively offer help when it was warranted" <?= ($agnt_feedback['cmt2B']=="Did not proactively offer help when it was warranted")?"selected":"" ?>>Did not proactively offer help when it was warranted</option>
													<option value="Information given to user was inaccurate" <?= ($agnt_feedback['cmt2C']=="Information given to user was inaccurate")?"selected":"" ?>>Information given to user was inaccurate</option>
												</select>

												<!-- <input type="text" name="data[cmt1]" class="form-control" value="<?php //echo $agnt_feedback['cmt3'] ?>"> -->
											</td>
											<td style="font-weight:bold; background-color:#D7BDE2">Customer Citical</td>
										</tr>
										<tr>
											<td class="eml" rowspan=3>Policy Adherence</td>
											<td>Identify Verification</td>
											<td colspan=2>Did the agent verify the customer's identity before making changes to the booking or user profile? The agent must confirm 3 points of verification before making changes to the booking or the user's profile. User must be the one to state identification details. Agent should not read from information on the screen. If AGENT states these details, the answer should be 'NO'.</td>
											<td>20</td>
											<td>
												<select class="form-control hcci_point business" name="data[identify_verification]" disabled>
													
													<option hcci_val=20 <?php echo $agnt_feedback['identify_verification'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option hcci_val=0 <?php echo $agnt_feedback['identify_verification'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
												</select>
											</td>
											<td colspan=2>
												<select class="form-control multiple-select" name="data[cmt3]" multiple="multiple" disabled>
													<option value="">-Select-</option>
													<option value="Did not request accepted point(s) of verification" <?= ($agnt_feedback['cmt3A']=="Did not request accepted point(s) of verification")?"selected":"" ?>>Did not request accepted point(s) of verification</option>
													<option value="Points of verification provided by user did not match account details, but agent proceeded" <?= ($agnt_feedback['cmt3B']=="Points of verification provided by user did not match account details, but agent proceeded")?"selected":"" ?>>Points of verification provided by user did not match account details, but agent proceeded</option>
												</select>
												<!-- <input type="text" name="data[cmt1]" class="form-control" value="<?php //echo $agnt_feedback['cmt1'] ?>"> -->
											</td>
											<td style="font-weight:bold; background-color:#D7BDE2">Business</td>
										</tr>
										<tr>
											<!-- <td class="eml" rowspan=2>Policy Adherence</td> -->
											<td>Situational Policy</td>
											<td colspan=2>Did the agent adhere to the designated policy for the customer's situation? "Yes" here means the agent scored "Yes" on criteria 1b, Issue Identification, chose the correct policy to address the issue raised, and followed the affiliated decision tree accurately. "No" here means the agent used the wrong policy for the customer's situation, did not follow the decision tree correctly, or misunderstood how to address the issue.</td>
											<td>25</td>
											<td>
												<select class="form-control hcci_point business" name="data[situational_policy]" disabled>
													
													<option hcci_val=25 <?php echo $agnt_feedback['situational_policy'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option hcci_val=0 <?php echo $agnt_feedback['situational_policy'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
												</select>
											</td>
											<td colspan=2>
												<select class="form-control multiple-select" name="data[cmt4]" multiple="multiple" disabled>
													<option value="">-Select-</option>
													<option value="Did not follow the workflow correctly" <?= ($agnt_feedback['cmt4A']=="Did not follow the workflow correctly")?"selected":"" ?>>Did not follow the workflow correctly</option>
													<option value="Followed incorrect workflow" <?= ($agnt_feedback['cmt4B']=="Followed incorrect workflow")?"selected":"" ?>>Followed incorrect workflow</option>
													<option value="Did not adhere to policy" <?= ($agnt_feedback['cmt4C']=="Did not adhere to policy")?"selected":"" ?>>Did not adhere to policy</option>
													<option value="Misunderstood how to address the issue(s)" <?= ($agnt_feedback['cmt4D']=="Misunderstood how to address the issue(s)")?"selected":"" ?>>Misunderstood how to address the issue(s)</option>
												</select>
												<!-- <input type="text" name="data[cmt1]" class="form-control" value="<?php //echo $agnt_feedback['cmt1'] ?>"> -->
											</td>
											<td style="font-weight:bold; background-color:#D7BDE2">Business</td>
										</tr>
										<tr>
											<td>Strategic Cross-Sale Offered</td>
											<td colspan=2>Did the agent offer a Strategic (or Seasonal) Cross-Sale that is related to the current or upcoming Seaon or the user's current or past projects? The answer is "Yes", if the Cross Sale is related to the current SR or booking (or that of a project found in the User's SR activity within the past 30 days-in BETTI), or if the cross sale offered is Seasonal. If the agent offers a "Random" cross sale, the answer should be "No".</td>
											<td>15</td>
											<td>
												<select class="form-control hcci_point business" name="data[strategic_Cross_Sale_Offered]" disabled>
													
													<option hcci_val=15 <?php echo $agnt_feedback['strategic_Cross_Sale_Offered'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option hcci_val=0 <?php echo $agnt_feedback['strategic_Cross_Sale_Offered'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
												</select>
											</td>
											<td colspan=2>
												<!-- <input type="text" name="data[cmt1]" class="form-control" value="<?php //echo $agnt_feedback['cmt1'] ?>"> -->
											</td>
											<td style="font-weight:bold; background-color:#D7BDE2">Business</td>
										</tr>
										<tr>
											<td class="eml" rowspan=4>Communication</td>
											<td>Call Beginning</td>
											<td colspan=2>Did the agent begin the call appropriately? This includes confirming understanding of the customer's issue(s) and, if necessary, empathizing for the situation. This does not mean following the workflow - it's instead asking if the agent began the call pleasantly, and apologizing for the customer's experience if needed.</td>
											<td>5</td>
											<td>
												<select class="form-control hcci_point customer" name="data[call_Beginning]" disabled>
													
													<option hcci_val=5 <?php echo $agnt_feedback['call_Beginning'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option hcci_val=0 <?php echo $agnt_feedback['call_Beginning'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
												</select>
											</td>
											<td colspan=2>
												<select class="form-control multiple-select" name="data[cmt5]" multiple="multiple" disabled>
													<option value="">-Select-</option>
													<option value="Did not empathize when empathy was needed" <?= ($agnt_feedback['cmt5A']=="Did not empathize when empathy was needed")?"selected":"" ?>>Did not empathize when empathy was needed</option>
													<option value="Over-apologized" <?= ($agnt_feedback['cmt5B']=="Over-apologized")?"selected":"" ?>>Over-apologized</option>
													<option value="Did not introduce themselves to the user" <?= ($agnt_feedback['cmt5C']=="Did not introduce themselves to the user")?"selected":"" ?>>Did not introduce themselves to the user</option>
												</select>
												<!-- <input type="text" name="data[cmt1]" class="form-control" value="<?php //echo $agnt_feedback['cmt1'] ?>"> -->
											</td>
											<td style="font-weight:bold; background-color:#D7BDE2">Customer</td>
										</tr>
										<tr>
											<td>Call Control</td>
											<td colspan=2>Did the agent effectively lead the call and, if applicable, communicate resolution steps they were taking? If yes, the agent should be in control of the call and be able to help guide the user through the interaction. They should also communicate clearly which steps they are taking and what the resolution is.</td>
											<td>5</td>
											<td>
												<select class="form-control hcci_point customer" name="data[call_Control]" disabled>
													
													<option hcci_val=5 <?php echo $agnt_feedback['call_Control'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option hcci_val=0 <?php echo $agnt_feedback['call_Control'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
												</select>
											</td>
											<td colspan=2>
												<select class="form-control multiple-select" name="data[cmt6]" multiple="multiple"  disabled>
													<option value="">-Select-</option>
													<option value="Did not communicate steps taken to the user" <?= ($agnt_feedback['cmt6A']=="Did not communicate steps taken to the user")?"selected":"" ?>>Did not communicate steps taken to the user</option>
													<option value="Agent was not in control of the call" <?= ($agnt_feedback['cmt6B']=="Agent was not in control of the call")?"selected":"" ?>>Agent was not in control of the call</option>
													<option value="Gave inaccurate information to the user" <?= ($agnt_feedback['cmt6C']=="Gave inaccurate information to the user")?"selected":"" ?>>Gave inaccurate information to the user</option>
												</select>
												<!-- <input type="text" name="data[cmt1]" class="form-control" value="<?php //echo $agnt_feedback['cmt1'] ?>"> -->
											</td>
											<td style="font-weight:bold; background-color:#D7BDE2">Customer</td>
										</tr>
										<tr>
											<td>Pace</td>
											<td colspan=2>Was the agent's pace consistent? This includes avoiding long silences without explanation, allowing the user to speak if you're both trying to talk at the same time, allowing the user to finish their thoughts before responding, avoiding speaking too fast, and maintaining consistent tone throughout the call</td>
											<td>5</td>
											<td>
												<select class="form-control hcci_point customer" name="data[pace]" disabled>
													
													<option hcci_val=5 <?php echo $agnt_feedback['pace'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option hcci_val=0 <?php echo $agnt_feedback['pace'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
												</select>
											</td>
											<td colspan=2>
												<select class="form-control multiple-select" name="data[cmt7]" multiple="multiple"  disabled>
													<option value="">-Select-</option>
													<option value="Long silences were present during the interaction" <?= ($agnt_feedback['cmt7A']=="Long silences were present during the interaction")?"selected":"" ?>>Long silences were present during the interaction</option>
													<option value="Agent did not allow user to finish their thoughts before responding" <?= ($agnt_feedback['cmt7B']=="Agent did not allow user to finish their thoughts before responding")?"selected":"" ?>>Agent did not allow user to finish their thoughts before responding</option>
													<option value="Agent's tone was not consistent throughout conversation" <?= ($agnt_feedback['cmt7C']=="Agent's tone was not consistent throughout conversation")?"selected":"" ?>>Agent's tone was not consistent throughout conversation</option>
													<option value="Pace of speech made the agent difficult to follow" <?= ($agnt_feedback['cmt7D']=="Pace of speech made the agent difficult to follow")?"selected":"" ?>>Pace of speech made the agent difficult to follow</option>
												</select>
												<!-- <input type="text" name="data[cmt1]" class="form-control" value="<?php //echo $agnt_feedback['cmt1'] ?>"> -->
											</td>
											<td style="font-weight:bold; background-color:#D7BDE2">Customer</td>
										</tr>
										<tr>
											<td>Holds</td>
											<td colspan=2>Did agent follow appropriate guidance for placing customer on hold? This includes requesting permission and estimating how long you will be before placing user on hold, completing work within estimated hold time, and, if exceeding estimated hold time, checking in with the user to update estimated time and confirming they're still able to wait on the line. If no hold was present, the answer is YES.</td>
											<td>5</td>
											<td>
												<select class="form-control hcci_point customer" name="data[holds]" disabled>
													
													<option hcci_val=5 <?php echo $agnt_feedback['pace'] == "holds" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option hcci_val=0 <?php echo $agnt_feedback['holds'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
												</select>
											</td>
											<td colspan=2>
												<select class="form-control multiple-select" name="data[cmt8]" multiple="multiple" disabled>
													<option value="">-Select-</option>
													<option value="Agent did not request permission to place user on hold" <?= ($agnt_feedback['cmt8A']=="Agent did not request permission to place user on hold")?"selected":"" ?>>Agent did not request permission to place user on hold</option>
													<option value="Agent did not convey a hold duration to the customer" <?= ($agnt_feedback['cmt8B']=="Agent did not convey a hold duration to the customer")?"selected":"" ?>>Agent did not convey a hold duration to the customer</option>
													<option value="Agent did not check in with the user to update estimated time" <?= ($agnt_feedback['cmt8C']=="Agent did not check in with the user to update estimated time")?"selected":"" ?>>Agent did not check in with the user to update estimated time</option>
													<option value="Hold was inappropriate or unnecessary" <?= ($agnt_feedback['cmt8D']=="Hold was inappropriate or unnecessary")?"selected":"" ?>>Hold was inappropriate or unnecessary</option>
													<option value="Agent placed the user on 'Mute' rather than using the hold button" <?= ($agnt_feedback['cmt8E']=="Agent placed the user on 'Mute' rather than using the hold button")?"selected":"" ?>>Agent placed the user on 'Mute' rather than using the hold button</option>
												</select>
												<!-- <input type="text" name="data[cmt1]" class="form-control" value="<?php //echo $agnt_feedback['cmt1'] ?>"> -->
											</td>
											<td style="font-weight:bold; background-color:#D7BDE2">Customer</td>
										</tr>
										<tr>
											<td class="eml" rowspan=5>Internal Processes</td>
											<td>Dash Documentation</td>
											<td colspan=2>Did the agent correctly document this interaction in Dash? This includes leaving the date, agent name, relevant notes of actions taken, and the Zendesk ticket number.</td>
											<td>5</td>
											<td>
												<select class="form-control hcci_point compliance" name="data[dash_Documentation]" disabled>
													
													<option hcci_val=5 <?php echo $agnt_feedback['pace'] == "dash_Documentation" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option hcci_val=0 <?php echo $agnt_feedback['dash_Documentation'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
												</select>
											</td>
											<td colspan=2>
												<select class="form-control multiple-select" name="data[cmt9]" multiple="multiple" disabled>
													<option value="">-Select-</option>
													<option value="Missing date" <?= ($agnt_feedback['cmt9A']=="Missing date")?"selected":"" ?>>Missing date</option>
													<option value="Missing agent name" <?= ($agnt_feedback['cmt9B']=="Missing agent name")?"selected":"" ?>>Missing agent name</option>
													<option value="Missing or incomplete note of action taken" <?= ($agnt_feedback['cmt9C']=="Missing or incomplete note of action taken")?"selected":"" ?>>Missing or incomplete note of action taken</option>
													<option value="Incorrect Dash note format used" <?= ($agnt_feedback['cmt9D']=="Incorrect Dash note format used")?"selected":"" ?>>Incorrect Dash note format used</option>
													<option value="Incomplete relevant information in notes" <?= ($agnt_feedback['cmt9E']=="Incomplete relevant information in notes")?"selected":"" ?>>Incomplete relevant information in notes</option>
												</select>
												<!-- <input type="text" name="data[cmt1]" class="form-control" value="<?php //echo $agnt_feedback['cmt1'] ?>"> -->
											</td>
											<td style="font-weight:bold; background-color:#D7BDE2">Compliance</td>
										</tr>
										<tr>
											<td>Disposition Tagging</td>
											<td colspan=2>Did the agent select the best available ticket disposition? Tagging should reflect the inbound ticket. "Yes" here means the agent scored "Yes" on criteria 1b, Issue Identification, as well as criteria 2b, Situational Policy, and tagged the ticket according to the issue(s) and policies addressed by criteria 1b and 2b.</td>
											<td>20</td>
											<td>
												<select class="form-control hcci_point business" name="data[disposition_Tagging]" disabled>
													
													<option hcci_val=20 <?php echo $agnt_feedback['pace'] == "disposition_Tagging" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option hcci_val=0 <?php echo $agnt_feedback['disposition_Tagging'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
												</select>
											</td>
											<td colspan=2>
												<select class="form-control multiple-select" name="data[cmt10]" multiple="multiple" disabled>
													<option value="">-Select-</option>
													<option value="Disposition was not updated correctly with new reply" <?= ($agnt_feedback['cmt10A']=="Disposition was not updated correctly with new reply")?"selected":"" ?>>Disposition was not updated correctly with new reply</option>
													<option value="Incorrect disposition chosen" <?= ($agnt_feedback['cmt10B']=="Incorrect disposition chosen")?"selected":"" ?>>Incorrect disposition chosen</option>
												</select>
												<!-- <input type="text" name="data[cmt1]" class="form-control" value="<?php //echo $agnt_feedback['cmt1'] ?>"> -->
											</td>
											<td style="font-weight:bold; background-color:#D7BDE2">Business</td>
										</tr>
										<tr>
											<td>Betti SR Audit</td>
											<td colspan=2>Did the agent perform the Lead Audit Interview in BETTI? A Lead Audit Interview must be performed in BETTI, on the SR corresponding to the booking ID in DASH, whenever changes or updates are made in DASH. "YES" means the agent performed the Lead Audit Interview, on the correct SR in BETTI, and selected "Customer Serious".</td>
											<td>5</td>
											<td>
												<select class="form-control hcci_point business" name="data[betti_SR_Audit]" disabled>
													
													<option hcci_val=5 <?php echo $agnt_feedback['pace'] == "betti_SR_Audit" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option hcci_val=0 <?php echo $agnt_feedback['betti_SR_Audit'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
												</select>
											</td>
											<td colspan=2>
												<select class="form-control multiple-select" name="data[cmt11]" multiple="multiple" disabled>
													<option value="">-Select-</option>
													<option value="The Agent did NOT perform Lead Audit Interview in BETTI." <?= ($agnt_feedback['cmt11A']=="The Agent did NOT perform Lead Audit Interview in BETTI.")?"selected":"" ?>>The Agent did NOT perform Lead Audit Interview in BETTI.</option>
													<option value="The Agent did NOT perform the Audit on the CORRECT SR in BETTI." <?= ($agnt_feedback['cmt11B']=="The Agent did NOT perform the Audit on the CORRECT SR in BETTI.")?"selected":"" ?>>The Agent did NOT perform the Audit on the CORRECT SR in BETTI.</option>
													<option value="Performed Lead Audit Interview in BETTI, did NOT Select Customer Serious" <?= ($agnt_feedback['cmt11C']=="Performed Lead Audit Interview in BETTI, did NOT Select Customer Serious")?"selected":"" ?>>Performed Lead Audit Interview in BETTI, did NOT Select Customer Serious</option>
												</select>
												<!-- <input type="text" name="data[cmt1]" class="form-control" value="<?php //echo $agnt_feedback['cmt1'] ?>"> -->
											</td>
											<td style="font-weight:bold; background-color:#D7BDE2">Business</td>
										</tr>
										<tr>
											<td>Escalation</td>
											<td colspan=2>Did the agent follow the correct escalation process? This includes recognizing that a situation is an escalation and following the correct escalation process. If the agent escalated the ticket/call, but they should have been able to work the call themselves, mark NO.</td>
											<td>5</td>
											<td>
												<select class="form-control hcci_point compliance" name="data[escalation]" disabled>
													
													<option hcci_val=5 <?php echo $agnt_feedback['pace'] == "escalation" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option hcci_val=0 <?php echo $agnt_feedback['escalation'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
												</select>
											</td>
											<td colspan=2>
												<!-- <input type="text" name="data[cmt1]" class="form-control" value="<?php //echo $agnt_feedback['cmt1'] ?>"> -->
											</td>
											<td style="font-weight:bold; background-color:#D7BDE2">Compliance</td>
										</tr>
										<tr>
											<td>Correct Action</td>
											<td colspan=2>Did the agent take the correct action? This means using the correct resolution wizard and taking all the steps the agent said they would in their conversation with the customer. If only some of the actions were taken correctly this should be scored "No."</td>
											<td>5</td>
											<td>
												<select class="form-control hcci_point business" name="data[correct_Action]" disabled>
													
													<option hcci_val=5 <?php echo $agnt_feedback['correct_Action'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option hcci_val=0 <?php echo $agnt_feedback['correct_Action'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
												</select>
											</td>
											<td colspan=2>
												<!-- <input type="text" name="data[cmt1]" class="form-control" value="<?php //echo $agnt_feedback['cmt1'] ?>"> -->
											</td>
											<td style="font-weight:bold; background-color:#D7BDE2">Business</td>
										</tr>
										
										<tr>
											<td class="eml" rowspan=6 colspan=2>Critical Fail Behaviors</td>
											<!-- <td rowspan=6 >Critical Fail Behaviors</td> -->
											<td class="text-danger" colspan=2>Unintelligible language</td>
											<td>0</td>
											<td>
												<select class="form-control hcci_point hcci_fatal" name="data[unintelligible_language]" disabled>
													
													<option hcci_val=0 <?php echo $agnt_feedback['unintelligible_language'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option hcci_val=0 <?php echo $agnt_feedback['unintelligible_language'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
												</select>
											</td>
											<td colspan=2>
												<!-- <input type="text" name="data[cmt1]" class="form-control" value="<?php //echo $agnt_feedback['cmt1'] ?>"> -->
											</td>
											<td style="font-weight:bold; background-color:#D7BDE2"></td>
										</tr>
										<tr>
											
											<td class="text-danger" colspan=2>Failed to address one or more of the customer's issue(s)</td>
											<td>0</td>
											<td>
												<select class="form-control hcci_point hcci_fatal" name="data[address_customer_issues]" disabled>
													
													<option hcci_val=0 <?php echo $agnt_feedback['address_customer_issues'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option hcci_val=0 <?php echo $agnt_feedback['address_customer_issues'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
												</select>
											</td>
											<td colspan=2>
												<!-- <input type="text" name="data[cmt1]" class="form-control" value="<?php //echo $agnt_feedback['cmt1'] ?>"> -->
											</td>
											<td style="font-weight:bold; background-color:#D7BDE2"></td>
										</tr>
										<tr>
											
											<td class="text-danger" colspan=2>Failed to validate customer's account</td>
											<td>0</td>
											<td>
												<select class="form-control hcci_point hcci_fatal" name="data[validate_customers_account]" disabled>
													
													<option hcci_val=0 <?php echo $agnt_feedback['validate_customers_account'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option hcci_val=0 <?php echo $agnt_feedback['validate_customers_account'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
												</select>
											</td>
											<td colspan=2>
												<!-- <input type="text" name="data[cmt1]" class="form-control" value="<?php //echo $agnt_feedback['cmt1'] ?>"> -->
											</td>
											<td style="font-weight:bold; background-color:#D7BDE2"></td>
										</tr>
										<tr>
											
											<td class="text-danger" colspan=2>Failed to implement correct outcome according to workflow or policy</td>
											<td>0</td>
											<td>
												<select class="form-control hcci_point hcci_fatal" name="data[correct_outcome]" disabled>
													
													<option hcci_val=0 <?php echo $agnt_feedback['correct_outcome'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option hcci_val=0 <?php echo $agnt_feedback['correct_outcome'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
												</select>
											</td>
											<td colspan=2>
												<!-- <input type="text" name="data[cmt1]" class="form-control" value="<?php //echo $agnt_feedback['cmt1'] ?>"> -->
											</td>
											<td style="font-weight:bold; background-color:#D7BDE2"></td>
										</tr>
										<tr>
											
											<td class="text-danger" colspan=2>Egregious policy error (excessive OOP, gave out personal information w/o permission, etc.) - DISCIPLINARY ACTION disabled</td>
											<td>0</td>
											<td>
												<select class="form-control hcci_point hcci_fatal" name="data[egregious_policy_error]" disabled>
													
													<option hcci_val=0 <?php echo $agnt_feedback['egregious_policy_error'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option hcci_val=0 <?php echo $agnt_feedback['egregious_policy_error'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
												</select>
											</td>
											<td colspan=2>
												<!-- <input type="text" name="data[cmt1]" class="form-control" value="<?php //echo $agnt_feedback['cmt1'] ?>"> -->
											</td>
											<td style="font-weight:bold; background-color:#D7BDE2"></td>
										</tr>
										<tr>
											
											<td class="text-danger" colspan=2>Flagrantly inappropriate response (cursing, insulting, speaking negatively of company/agent/pro, etc.) - DISCIPLINARY ACTION disabled</td>
											<td>0</td>
											<td>
												<select class="form-control hcci_point hcci_fatal" name="data[flagrantly_inappropriate_response]" disabled>
													
													<option hcci_val=0 <?php echo $agnt_feedback['flagrantly_inappropriate_response'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option hcci_val=0 <?php echo $agnt_feedback['flagrantly_inappropriate_response'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
												</select>
											</td>
											<td colspan=2>
												<!-- <input type="text" name="data[cmt1]" class="form-control" value="<?php //echo $agnt_feedback['cmt1'] ?>"> -->
											</td>
											<td style="font-weight:bold; background-color:#D7BDE2"></td>
										</tr>

										<tr>
											<td class="eml" rowspan=6 colspan=2>For Coaching</td>
											<!-- <td rowspan=6 >Critical Fail Behaviors</td> -->
											<td colspan=2>Failed to build Value in ANGI Services</td>
											<td>0</td>
											<td>
												<select class="form-control hcci_point" name="data[build_ANGI_Services]" disabled>
													
													<option hcci_val=0 <?php echo $agnt_feedback['build_ANGI_Services'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option hcci_val=0 <?php echo $agnt_feedback['build_ANGI_Services'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
												</select>
											</td>
											<td colspan=2>
												<!-- <input type="text" name="data[cmt1]" class="form-control" value="<?php //echo $agnt_feedback['cmt1'] ?>"> -->
											</td>
											<td style="font-weight:bold; background-color:#D7BDE2"></td>
										</tr>
										<tr>
											
											<td colspan=2>Failed to mention Stella Survey</td>
											<td>0</td>
											<td>
												<select class="form-control hcci_point" name="data[mention_Stella_Survey]" disabled>
													
													<option hcci_val=0 <?php echo $agnt_feedback['mention_Stella_Survey'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option hcci_val=0 <?php echo $agnt_feedback['mention_Stella_Survey'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
												</select>
											</td>
											<td colspan=2>
												<!-- <input type="text" name="data[cmt1]" class="form-control" value="<?php //echo $agnt_feedback['cmt1'] ?>"> -->
											</td>
											<td style="font-weight:bold; background-color:#D7BDE2"></td>
										</tr>
										<tr>
											
											<td colspan=2>Failed to mention the "ANGI APP"</td>
											<td>0</td>
											<td>
												<select class="form-control hcci_point" name="data[mention_ANGI_APP]" disabled>
													
													<option hcci_val=0 <?php echo $agnt_feedback['mention_ANGI_APP'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option hcci_val=0 <?php echo $agnt_feedback['mention_ANGI_APP'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
												</select>
											</td>
											<td colspan=2>
												<!-- <input type="text" name="data[cmt1]" class="form-control" value="<?php //echo $agnt_feedback['cmt1'] ?>"> -->
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
										<td>Earned Point:</td><td ><input type="text" readonly class="form-control" id="customer_earnedCore_score" name="data[customer_earned_score]" value="<?php echo $agnt_feedback['customer_earned_score'] ?>"></td>
										<td>Earned Point:</td><td ><input type="text" readonly class="form-control" id="business_earnedCore_score" name="data[business_earned_score]" value="<?php echo $agnt_feedback['business_earned_score'] ?>"></td>
										<td>Earned Point:</td><td ><input type="text" readonly class="form-control" id="compliance_earnedCore_score" name="data[compliance_earned_score]" value="<?php echo $agnt_feedback['compliance_earned_score'] ?>"></td>
									</tr>
									<tr style="font-weight:bold; background-color:#D7BDE2">
										<td>Possible Point:</td><td ><input type="text" readonly class="form-control" id="customer_possibleCore_score" name="data[customer_possible_score]" value="<?php echo $agnt_feedback['customer_possible_score'] ?>"></td>
										<td>Possible Point:</td><td ><input type="text" readonly class="form-control" id="business_possibleCore_score" name="data[business_possible_score]" value="<?php echo $agnt_feedback['business_possible_score'] ?>"></td>
										<td>Possible Point:</td><td ><input type="text" readonly class="form-control" id="compliance_possibleCore_score" name="data[compliance_possible_score]" value="<?php echo $agnt_feedback['compliance_possible_score'] ?>"></td>
									</tr>
									<tr style="font-weight:bold; background-color:#D7BDE2">
										<td>Overall Percentage:</td><td ><input type="text" readonly class="form-control" id="customer_overall_score" name="data[customer_overall_score]" value="<?php echo $agnt_feedback['customer_overall_score'] ?>"></td>
										<td>Overall Percentage:</td><td ><input type="text" readonly class="form-control" id="business_overall_score" name="data[business_overall_score]" value="<?php echo $agnt_feedback['business_overall_score'] ?>"></td>
										<td>Overall Percentage:</td><td ><input type="text" readonly class="form-control" id="compliance_overall_score" name="data[compliance_overall_score]" value="<?php echo $agnt_feedback['compliance_overall_score'] ?>"></td>
									</tr>
										<tr>
											<td>Call Summary:</td>
											<td colspan=2><textarea class="form-control" name="data[call_summary]" disabled><?php echo $agnt_feedback['call_summary'] ?></textarea></td>
											<td>Feedback:</td>
											<td colspan=2><textarea class="form-control" name="data[feedback]" disabled><?php echo $agnt_feedback['feedback'] ?></textarea></td>
										</tr>
										<?php if($agnt_feedback['attach_file']!=''){ ?>
									<tr oncontextmenu="return false;">
										<td colspan="2">Audio Files (Mp4/Mp3/M4a/Wav)</td>
										<td colspan="4">
											<?php $attach_file = explode(",",$agnt_feedback['attach_file']);
											 foreach($attach_file as $af){ ?>
												<audio oncontextmenu="return false;" controls controlslist="nodownload" style="background-color:#607F93">
													  <source src="<?php echo base_url(); ?>qa_files/qa_homeadvisor/hcci_files/<?php echo $af; ?>" type="audio/ogg">
													  <source src="<?php echo base_url(); ?>qa_files/qa_homeadvisor/hcci_files/<?php echo $af; ?>" type="audio/mpeg">
												</audio> </br>
											 <?php } ?>
										</td>
									</tr>
									<?php } ?>

									<tr>
										<td style="font-size:12px">Manager Review:</td>
										<td colspan="8" style="text-align:left"><?php echo $agnt_feedback['mgnt_rvw_note'] ?></td>
									</tr>
									<tr>
										<td style="font-size:12px">Client Review:</td>
										<td colspan="8" style="text-align:left"><?php echo $agnt_feedback['client_rvw_note'] ?></td>
									</tr>
									<tr><td colspan="6" style="background-color:#C5C8C8"></td></tr>
									
									 <form id="form_agent_user" method="POST" action="">
										<input type="hidden" name="pnid" class="form-control" value="<?php echo $pnid; ?>">
										
										<tr>
											<td colspan=2 style="font-size:16px">Feedback Acceptance<span style="font-size:24px;color:red">*</span></td>
											<td colspan=2>
												<select class="form-control" id="" name="agnt_fd_acpt" required="">
													<option value="">--Select--</option>
													<option <?php echo $agnt_feedback['agnt_fd_acpt']=='Acceptance'?"selected":""; ?> value="Acceptance">Acceptance</option>	
													<option <?php echo $agnt_feedback['agnt_fd_acpt']=='Not Acceptance'?"selected":""; ?> value="Not Acceptance">Not Acceptance</option>	
												</select>
											</td>
										</tr>
										<tr>
											<td colspan=2 style="font-size:16px">Your Review<span style="font-size:24px;color:red">*</span></td>
											<td colspan=4><textarea class="form-control" name="note" required><?php echo $agnt_feedback['agent_rvw_note'] ?></textarea></td>
										</tr>
										
										<?php if(is_access_qa_agent_module()==true){
										if(is_available_qa_feedback($agnt_feedback['entry_date'],72) == true){ ?>
											<tr>
												<?php if($agnt_feedback['agent_rvw_note']==''){ ?>
													<td colspan="6"><button class="btn btn-success waves-effect" type="submit" id='btnagentSave' name='btnSave' value="SAVE" style="width:500px">SAVE</button></td>
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

<script>$(function() { $('#multiselect').multiselect(); $('.multiple-select').multiselect({ includeSelectAllOption: true, enableFiltering: true, numberDisplayed: 0, enableCaseInsensitiveFiltering: true, filterPlaceholder: 'Search for something...' }); }); </script>

