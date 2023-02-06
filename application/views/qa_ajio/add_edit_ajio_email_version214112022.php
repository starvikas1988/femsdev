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

</style>

<?php if($ajio_id!=0){
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
							<table class="table table-striped skt-table" width="100%">
								<tbody>
									<tr>
										<td colspan="7" id="theader" style="font-size:40px">AJIO [Email] V2</td>
										<input type="hidden" name="audit_start_time" value="<?php echo CurrMySqlDate(); ?>">
									</tr>
									<?php
										if($ajio_id==0){
											$auditorName = get_username();
											$auditDate = CurrDateMDY();
											$clDate_val='';
										}else{
											if($ajio_email_v2['entry_by']!=''){
												$auditorName = $ajio_email_v2['auditor_name'];
											}else{
												$auditorName = $ajio_email_v2['client_name'];
											}
											$auditDate = mysql2mmddyy($ajio_email_v2['audit_date']);
											$clDate_val = mysqlDt2mmddyy($ajio_email_v2['call_date']);
										}
									?>
									<tr>
										<td>Auditor Name:</td>
										<td><input type="text" class="form-control" value="<?php echo $auditorName; ?>" disabled></td>
										<td>Audit Date:</td>
										<td style="width:200px;"><input type="text" class="form-control" value="<?php echo $auditDate; ?>" disabled></td>
										<td style="width:100px">Call Date/Time:</td>
										<td colspan="2"><input type="text" class="form-control" id="call_date_time" name="call_date" value="<?php echo $clDate_val; ?>" required></td>
									</tr>
									<tr>
										<td>Champ/Agent Name:</td>
										<td>
											<select class="form-control" id="agent_id" name="data[agent_id]" required >
												<option value="<?php echo $ajio_email_v2['agent_id'] ?>"><?php echo $ajio_email_v2['fname']." ".$ajio_email_v2['lname'] ?></option>
												<option value="">-Select-</option>
												<?php foreach($agentName as $row):  ?>
													<option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
												<?php endforeach; ?>
											</select>
										</td>
										<td>Fusion/BP ID:</td>
										<td><input type="text" class="form-control" id="fusion_id" value="<?php echo $ajio_email_v2['fusion_id'] ?>" readonly ></td>
										<td>L1 Supervisor:</td>
										<td colspan="2">
											<select class="form-control" id="tl_id" name="data[tl_id]" readonly>
												<option value="<?php echo $ajio_email_v2['tl_id'] ?>"><?php echo $ajio_email_v2['tl_name'] ?></option>
												<option value="">--Select--</option>
												<?php foreach($tlname as $tl): ?>
													<option value="<?php echo $tl['id']; ?>"><?php echo $tl['fname']." ".$tl['lname']; ?></option>
												<?php endforeach; ?>	
											</select>
										</td>
									</tr>
									<tr>
										<td>Interaction ID:</td>
										<td><input type="text" class="form-control" name="data[call_id]" value="<?php echo $ajio_email_v2['call_id'] ?>" required ></td>
										<td>Type of Audit:</td>
										<td>
											<select class="form-control" name="data[type_of_audit]" required>
												<option value="<?php echo $ajio_email_v2['type_of_audit'] ?>"><?php echo $ajio_email_v2['type_of_audit'] ?></option>
												<option value="">-Select-</option>
												<option value="Detractor Audit">Detractor Audit</option>
												<option value="Passive Audit">Passive Audit</option>
												<option value="Promoter Audit">Promoter Audit</option>
												<option value="High AHT Audit">High AHT Audit</option>
												<option value="Random Audit">Random Audit</option>
												<option value="A2A">A2A</option>
												<option value="Calibration">Calibration</option>
											</select>
										</td>
									</tr>
									<tr>
										<td>Predactive CSAT:</td>
										<td>
											<select class="form-control" id="audit_type" name="data[audit_type]" required>
												<option value="<?php echo $ajio_email_v2['audit_type'] ?>"><?php echo $ajio_email_v2['audit_type'] ?></option>
												<option value="">-Select-</option>
												<option value="CQ Audit">CQ Audit</option>
												<option value="BQ Audit">BQ Audit</option>
												<option value="Calibration">Calibration</option>
												<option value="Pre-Certificate Mock Call">Pre-Certificate Mock Call</option>
												<option value="Certification Audit">Certification Audit</option>
												<option value="Operation Audit">Operation Audit</option>
												<option value="Trainer Audit">Trainer Audit</option>
												<option value="Hygiene Audit">Hygiene Audit</option>
											</select>
										</td>
										<td class="auType">Auditor Type</td>
										<td class="auType">
											<select class="form-control" id="auditor_type" name="data[auditor_type]">
												<option value="">-Select-</option>
												<option value="Master">Master</option>
												<option value="Regular">Regular</option>
											</select>
										</td>
										<td>VOC:</td>
										<td>
											<select class="form-control" id="voc" name="data[voc]" required>
												<option value="<?php echo $ajio_email_v2['voc'] ?>"><?php echo $ajio_email_v2['voc'] ?></option>
												<option value="">-Select-</option>
												<option value="1">1</option>
												<option value="2">2</option>
												<option value="3">3</option>
												<option value="4">4</option>
												<option value="5">5</option>
												<option value="6">6</option>
												<option value="7">7</option>
												<option value="8">8</option>
												<option value="9">9</option>
												<option value="10">10</option>
											</select>
										</td>
									</tr>
									<tr>
										<td style="font-weight:bold; font-size:16px; text-align:right">Earned Score:</td>
										<td><input type="text" readonly id="earnedScore" name="data[earned_score]" class="form-control" style="font-weight:bold" value="<?php echo $ajio_email_v2['earned_score'] ?>"></td>
										<td style="font-weight:bold; font-size:16px; text-align:right">Possible Score:</td>
										<td><input type="text" readonly id="possibleScore" name="data[possible_score]" class="form-control" style="font-weight:bold" value="<?php echo $ajio_email_v2['possible_score'] ?>"></td>
										<td style="font-weight:bold; font-size:16px; text-align:right">Overall Score:</td>
										<td colspan="2"><input type="text" readonly id="overallScore" name="data[overall_score]" class="form-control ajio_email_v2Fatal" style="font-weight:bold" value="<?php echo $ajio_email_v2['overall_score'] ?>"></td>
									</tr>
									<tr style="font-weight:bold">
										<td><input type="hidden" class="form-control" id="prefatal" name="data[pre_fatal_score]" value="<?php echo $ajio_email_v2['pre_fatal_score'] ?>"></td>
										<td><input type="hidden" class="form-control" id="fatalcount" name="data[fatal_count]" value="<?php echo $ajio_email_v2['fatal_count'] ?>"></td>
									</tr>
									<tr style="background-color:#85C1E9; font-weight:bold">
										<td>Parameter</td>
										<td colspan=2>Sub Parameter</td>
										<td>Defect</td>
										<td>Weightage</td>
										<td>L1 Reason</td>
										<td>L2 Reason</td>
									</tr>
									<tr>
										<td rowspan=7 style="background-color:#85C1E9; font-weight:bold">Comprehension & Email Ettiquettes</td>
										<td colspan=2>Did the champ use appropriate acknowledgements, re-assurance and apology wherever required</td>
										<td>
											<select class="form-control ajio" id="" name="data[appropriate_acknowledgements]" required>
												<option ajio_val=10 ajio_max=10 <?php echo $ajio_email_v2['appropriate_acknowledgements'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ajio_val=0 ajio_max=10 <?php echo $ajio_email_v2['appropriate_acknowledgements'] == "Failed to assure the customer when needed"?"selected":"";?> value="Failed to assure the customer when needed">Failed to assure the customer when needed</option>
												<option ajio_val=0 ajio_max=10 <?php echo $ajio_email_v2['appropriate_acknowledgements'] == "Did not empathize when needed"?"selected":"";?> value="Did not empathize when needed">Did not empathize when needed</option>
												<option ajio_val=0 ajio_max=10 <?php echo $ajio_email_v2['appropriate_acknowledgements'] == "Incorrect acknowledgement used"?"selected":"";?> value="Incorrect acknowledgement used">Incorrect acknowledgement used</option>
											</select>
										</td>
										<td>10</td>
										<td><textarea class="form-control" name="data[l1_reason1]"><?php echo $ajio_email_v2['l1_reason1'] ?></textarea></td>
										<td><textarea class="form-control" name="data[l2_reason1]"><?php echo $ajio_email_v2['l2_reason1'] ?></textarea></td>
									</tr>
									<tr>
										<td colspan=2>Did the champ use font, font size, and formatting  as per AJIO's brand guidelines</td>
										<td>
											<select class="form-control ajio" name="data[font_size_formatting]" required>
												<option ajio_val=5 ajio_max=5 <?php echo $ajio_email_v2['font_size_formatting'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ajio_val=0 ajio_max=5 <?php echo $ajio_email_v2['font_size_formatting'] == "Incorrect font size/color"?"selected":"";?> value="Incorrect font size/color">Incorrect font size/color</option>
												<option ajio_val=0 ajio_max=5 <?php echo $ajio_email_v2['font_size_formatting'] == "Email was not formatted appropriately"?"selected":"";?> value="Email was not formatted appropriately">Email was not formatted appropriately</option>
												<option ajio_val=0 ajio_max=5 <?php echo $ajio_email_v2['font_size_formatting'] == "Incorrect date structure"?"selected":"";?> value="Incorrect date structure">Incorrect date structure</option>
												<option ajio_val=0 ajio_max=5 <?php echo $ajio_email_v2['font_size_formatting'] == "Incorrect subject line"?"selected":"";?> value="Incorrect subject line">Incorrect subject line</option>
												<option ajio_val=0 ajio_max=5 <?php echo $ajio_email_v2['font_size_formatting'] == "Responded without trail"?"selected":"";?> value="Responded without trail">Responded without trail</option>
											</select>
										</td>
										<td>5</td>
										<td><textarea class="form-control" name="data[l1_reason2]"><?php echo $ajio_email_v2['l1_reason2'] ?></textarea></td>
										<td><textarea class="form-control" name="data[l2_reason2]"><?php echo $ajio_email_v2['l2_reason2'] ?></textarea></td>
									</tr>
									<tr>
										<td colspan=2>Was the email response in line with AJIO's approved template/format</td>
										<td>
											<select class="form-control ajio" id="" name="data[email_response]" required>
												<option ajio_val=5 ajio_max=5 <?php echo $ajio_email_v2['email_response'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ajio_val=0 ajio_max=5 <?php echo $ajio_email_v2['email_response'] == "No"?"selected":"";?> value="No">No</option>
											</select>
										</td>
										<td>5</td>
										<td><textarea class="form-control" name="data[l1_reason3]"><?php echo $ajio_email_v2['l1_reason3'] ?></textarea></td>
										<td><textarea class="form-control" name="data[l2_reason3]"><?php echo $ajio_email_v2['l2_reason3'] ?></textarea></td>
									</tr>
									<tr>
										<td colspan=2 style="color:red">Did the champ use appropriate template(s) and customized it to ensure all concerns raised were answered appropriately</td>
										<td>
											<select class="form-control ajio fatal" id="ajioAF1" name="data[use_appropriate_template]" required>
												<option ajio_val=10 ajio_max=10 <?php echo $ajio_email_v2['use_appropriate_template'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ajio_val=0 ajio_max=10 <?php echo $ajio_email_v2['use_appropriate_template'] == "Autofail"?"selected":"";?> value="Autofail">Autofail</option>
											</select>
										</td>
										<td>10</td>
										<td><textarea class="form-control" name="data[l1_reason4]"><?php echo $ajio_email_v2['l1_reason4'] ?></textarea></td>
										<td><textarea class="form-control" name="data[l2_reason4]"><?php echo $ajio_email_v2['l2_reason4'] ?></textarea></td>
									</tr>
									<tr>
										<td colspan=2>Did the champ maintain accuracy of written communication ensuring no grammatical errors, SVAs, Punctuation and sentence construction errors.</td>
										<td>
											<select class="form-control ajio" id="" name="data[written_communication]" required>
												<option ajio_val=10 ajio_max=10 <?php echo $ajio_email_v2['written_communication'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ajio_val=0 ajio_max=10 <?php echo $ajio_email_v2['written_communication'] == "Incorrect sentence Structure"?"selected":"";?> value="Incorrect sentence Structure">Incorrect sentence Structure</option>
												<option ajio_val=0 ajio_max=10 <?php echo $ajio_email_v2['written_communication'] == "incorrect spacing"?"selected":"";?> value="incorrect spacing">incorrect spacing</option>
												<option ajio_val=0 ajio_max=10 <?php echo $ajio_email_v2['written_communication'] == "Grammatical error"?"selected":"";?> value="Grammatical error">Grammatical error</option>
												<option ajio_val=0 ajio_max=10 <?php echo $ajio_email_v2['written_communication'] == "Incorrect punctuation"?"selected":"";?> value="Incorrect punctuation">Incorrect punctuation</option>
											</select>
										</td>
										<td>10</td>
										<td><textarea class="form-control" name="data[l1_reason5]"><?php echo $ajio_email_v2['l1_reason5'] ?></textarea></td>
										<td><textarea class="form-control" name="data[l2_reason5]"><?php echo $ajio_email_v2['l2_reason5'] ?></textarea></td>
									</tr>
									<tr>
										<td colspan=2 style="color:red">Did the champ refer to all relevant previous interactions when required to gather information about customer's account and issue end to end</td>
										<td>
											<select class="form-control ajio fatal" id="ajioAF2" name="data[relevant_previous_interactions]" required>
												<option ajio_val=10 ajio_max=10 <?php echo $ajio_email_v2['use_appropriate_template'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ajio_val=0 ajio_max=10 <?php echo $ajio_email_v2['relevant_previous_interactions'] == "Autofail"?"selected":"";?> value="Autofail">Autofail</option>
											</select>
										</td>
										<td>10</td>
										<td><textarea class="form-control" name="data[l1_reason6]"><?php echo $ajio_email_v2['l1_reason6'] ?></textarea></td>
										<td><textarea class="form-control" name="data[l2_reason6]"><?php echo $ajio_email_v2['l2_reason6'] ?></textarea></td>
									</tr>
									<tr>
										<td colspan=2>Was the champ able to identify and handle objections effectively and offer rebuttals wherever required</td>
										<td>
											<select class="form-control ajio" id="" name="data[handle_objections]" required>
												<option ajio_val=10 ajio_max=10 <?php echo $ajio_email_v2['handle_objections'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ajio_val=0 ajio_max=10 <?php echo $ajio_email_v2['handle_objections'] == "Failed to address customer's objection(s)/emotion(s)"?"selected":"";?> value="Failed to address customer's objection(s)/emotion(s)">Failed to address customer's objection(s)/emotion(s)</option>
												<option ajio_val=0 ajio_max=10 <?php echo $ajio_email_v2['handle_objections'] == "Did not use objection handling script/statement"?"selected":"";?> value="Did not use objection handling script/statement">Did not use objection handling script/statement</option>
												<option ajio_val=0 ajio_max=10 <?php echo $ajio_email_v2['handle_objections'] == "Inappropriate/Incorrect rebuttals provided"?"selected":"";?> value="Inappropriate/Incorrect rebuttals provided">Inappropriate/Incorrect rebuttals provided</option>
											</select>
										</td>
										<td>10</td>
										<td><textarea class="form-control" name="data[l1_reason7]"><?php echo $ajio_email_v2['l1_reason7'] ?></textarea></td>
										<td><textarea class="form-control" name="data[l2_reason7]"><?php echo $ajio_email_v2['l2_reason7'] ?></textarea></td>
									</tr>
									<tr>
										<td rowspan=4 style="background-color:#85C1E9; font-weight:bold">Effective System Navigation & KM Usage</td>
										<td colspan=2>Did the champ refer to all releavnt articles/T2Rs correctly</td>
										<td>
											<select class="form-control ajio" name="data[all_relevant_articles]" required>
												<option ajio_val=5 ajio_max=5 <?php echo $ajio_email_v2['all_relevant_articles'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ajio_val=0 ajio_max=5 <?php echo $ajio_email_v2['all_relevant_articles'] == "No"?"selected":"";?> value="No">No</option>
												<option ajio_val=0 ajio_max=0 <?php echo $ajio_email_v2['all_relevant_articles'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td>5</td>
										<td><textarea class="form-control" name="data[l1_reason8]"><?php echo $ajio_email_v2['l1_reason8'] ?></textarea></td>
										<td><textarea class="form-control" name="data[l2_reason8]"><?php echo $ajio_email_v2['l2_reason8'] ?></textarea></td>
									</tr>
									<tr>
										<td colspan=2>Did the champ refer to different applications/portals/tools to identify the root cause of customer issue and enable resolution.</td>
										<td>
											<select class="form-control ajio" name="data[applications_portals]" required>
												<option ajio_val=5 ajio_max=5 <?php echo $ajio_email_v2['applications_portals'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ajio_val=0 ajio_max=5 <?php echo $ajio_email_v2['applications_portals'] == "Asked for information that was already available"?"selected":"";?> value="Asked for information that was already available">Asked for information that was already available</option>
												<option ajio_val=0 ajio_max=5 <?php echo $ajio_email_v2['applications_portals'] == "Did not use all means to enable resolution"?"selected":"";?> value="Did not use all means to enable resolution">Did not use all means to enable resolution</option>
											</select>
										</td>
										<td>5</td>
										<td><textarea class="form-control" name="data[l1_reason9]"><?php echo $ajio_email_v2['l1_reason9'] ?></textarea></td>
										<td><textarea class="form-control" name="data[l2_reason9]"><?php echo $ajio_email_v2['l2_reason9'] ?></textarea></td>
									</tr>
									<tr>
										<td colspan=2 style="color:red">Email/Interaction was authenticated wherever required</td>
										<td>
											<select class="form-control ajio fatal" id="ajioAF3" name="data[email_interaction]" required>
												<option ajio_val=5 ajio_max=5 <?php echo $ajio_email_v2['email_interaction'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ajio_val=0 ajio_max=5 <?php echo $ajio_email_v2['email_interaction'] == "Autofail"?"selected":"";?> value="Autofail">Autofail</option>
												<option ajio_val=0 ajio_max=0 <?php echo $ajio_email_v2['email_interaction'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td>5</td>
										<td><textarea class="form-control" name="data[l1_reason10]"><?php echo $ajio_email_v2['l1_reason10'] ?></textarea></td>
										<td><textarea class="form-control" name="data[l2_reason10]"><?php echo $ajio_email_v2['l2_reason10'] ?></textarea></td>
									</tr>
									<tr>
										<td colspan=2>Did the champ take ownership and request for outcall/call back was addressed wherever required</td>
										<td>
											<select class="form-control ajio" name="data[outcall_call_back]" required>
												<option ajio_val=5 ajio_max=5 <?php echo $ajio_email_v2['outcall_call_back'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ajio_val=0 ajio_max=5 <?php echo $ajio_email_v2['outcall_call_back'] == "No"?"selected":"";?> value="No">No</option>
												<option ajio_val=0 ajio_max=0 <?php echo $ajio_email_v2['outcall_call_back'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td>5</td>
										<td><textarea class="form-control" name="data[l1_reason11]"><?php echo $ajio_email_v2['l1_reason11'] ?></textarea></td>
										<td><textarea class="form-control" name="data[l2_reason11]"><?php echo $ajio_email_v2['l2_reason11'] ?></textarea></td>
									</tr>

									<tr>
										<td rowspan=3 style="background-color:#85C1E9; font-weight:bold">Issue Resolution</td>
										<td colspan=2 style="color:red">Champ executed all necessary actions to ensure issue resolution</td>
										<td>
											<select class="form-control ajio fatal" id="ajioAF4" name="data[ensure_issue_resolution]" required>
												<option ajio_val=5 ajio_max=5 <?php echo $ajio_email_v2['ensure_issue_resolution'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ajio_val=0 ajio_max=5 <?php echo $ajio_email_v2['ensure_issue_resolution'] == "Autofail"?"selected":"";?> value="Autofail">Autofail</option>
											</select>
										</td>
										<td>5</td>
										<td>
											<!-- <textarea class="form-control" name="data[l1_reason10]"><?php //echo $ajio_email_v2['l1_reason10'] ?></textarea> -->
											<select class="form-control" name="data[l1_reason12]" >
												<option value=""></option>
												<option <?php echo $ajio_email_v2['l1_reason12'] == "C&R raised when not required"?"selected":"";?> value="C&R raised when not required">C&R raised when not required</option>
												<option <?php echo $ajio_email_v2['l1_reason12'] == "C&R not raised when required"?"selected":"";?> value="C&R not raised when required">C&R not raised when required</option>
												<option <?php echo $ajio_email_v2['l1_reason12'] == "Wrong C&R raised"?"selected":"";?> value="Wrong C&R raised">Wrong C&R raised</option>
												<option <?php echo $ajio_email_v2['l1_reason12'] == "C&R raised without images/appropriate details"?"selected":"";?> value="C&R raised without images/appropriate details">C&R raised without images/appropriate details</option>
												<option <?php echo $ajio_email_v2['l1_reason12'] == "Action not taken"?"selected":"";?> value="Action not taken">Action not taken</option>
												<option <?php echo $ajio_email_v2['l1_reason12'] == "Unnecessary redirection"?"selected":"";?> value="Unnecessary redirection">Unnecessary redirection</option>
												<option <?php echo $ajio_email_v2['l1_reason12'] == "Autofail & Yes"?"selected":"";?> value="Autofail & Yes">Autofail & Yes</option>
											</select>
										</td>
										<td><textarea class="form-control" name="data[l2_reason12]"><?php echo $ajio_email_v2['l2_reason12'] ?></textarea></td>
									</tr>
									<tr>
										<td colspan=2 style="color:red">All the queries were answered properly and in an informative way to avoid repeat call. Champ provided a clear understanding of action taken and the way forward to the customer.</td>
										<td>
											<select class="form-control ajio fatal" id="ajioAF5" name="data[avoid_repeat_call]" required>
												<option ajio_val=10 ajio_max=10 <?php echo $ajio_email_v2['avoid_repeat_call'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ajio_val=0 ajio_max=10 <?php echo $ajio_email_v2['avoid_repeat_call'] == "Autofail"?"selected":"";?> value="Autofail">Autofail</option>
											</select>
										</td>
										<td>10</td>
										<td>
											<!-- <textarea class="form-control" name="data[l1_reason13]"><?php //echo $ajio_email_v2['l1_reason13'] ?></textarea> -->
											<select class="form-control" name="data[l1_reason13]" >
												<option value=""></option>
												<option <?php echo $ajio_email_v2['l1_reason13'] == "Incorrect information Shared"?"selected":"";?> value="Incorrect information Shared">Incorrect information Shared</option>
												<option <?php echo $ajio_email_v2['l1_reason13'] == "Incomplete information Shared"?"selected":"";?> value="Incomplete information Shared">Incomplete information Shared</option>
												<option <?php echo $ajio_email_v2['l1_reason13'] == "False assurance"?"selected":"";?> value="False assurance">False assurance</option>
											</select>
										</td>
										<td><textarea class="form-control" name="data[l2_reason13]"><?php echo $ajio_email_v2['l2_reason13'] ?></textarea></td>
									</tr>
									<tr>
										<td colspan=2 style="color:red">Did the champ document the case correctly and adhered to tagging guidelines.</td>
										<td>
											<select class="form-control ajio fatal" id="ajioAF6" name="data[tagging_guidelines]" required>
												<option ajio_val=5 ajio_max=5 <?php echo $ajio_email_v2['tagging_guidelines'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ajio_val=0 ajio_max=5 <?php echo $ajio_email_v2['tagging_guidelines'] == "Autofail"?"selected":"";?> value="Autofail">Autofail</option>
												<option ajio_val=0 ajio_max=5 <?php echo $ajio_email_v2['tagging_guidelines'] == "CAM rule not adhered to."?"selected":"";?> value="CAM rule not adhered to.">CAM rule not adhered to.</option>
												<option ajio_val=5 ajio_max=5 <?php echo $ajio_email_v2['tagging_guidelines'] == "Documented on incorrect account"?"selected":"";?> value="Documented on incorrect account">Documented on incorrect account</option>
												<option ajio_val=0 ajio_max=5 <?php echo $ajio_email_v2['tagging_guidelines'] == "All queries not documented"?"selected":"";?> value="All queries not documented">All queries not documented</option>
											</select>
										</td>
										<td>5</td>
										<td><textarea class="form-control" name="data[l1_reason14]"><?php echo $ajio_email_v2['l1_reason14'] ?></textarea></td>
										<td><textarea class="form-control" name="data[l2_reason14]"><?php echo $ajio_email_v2['l2_reason14'] ?></textarea></td>
									</tr>

									<tr>
										<td style="background-color:#F1948A; font-weight:bold">ZTP</td>
										<td colspan=2 style="color:red">As per AJIO ZTP guidelines</td>
										<td>
											<select class="form-control ajio fatal" id="ajioAF7" name="data[ztp_guidelines]" required>
												<option ajio_val=0 ajio_max=0 <?php echo $ajio_email_v2['ztp_guidelines'] == "No"?"selected":"";?> value="No">No</option>
												<option ajio_val=0 ajio_max=0 <?php echo $ajio_email_v2['ztp_guidelines'] == "Autofail"?"selected":"";?> value="Autofail">Autofail</option>
											</select>
										</td>
										<td>0</td>
										<td><textarea class="form-control" name="data[l1_reason15]"><?php echo $ajio_email_v2['l1_reason15'] ?></textarea></td>
										<td><textarea class="form-control" name="data[l2_reason15]"><?php echo $ajio_email_v2['l2_reason15'] ?></textarea></td>
									</tr>
									<tr>
										<td>Call Synopsis:</td>
										<td colspan="7"><textarea class="form-control" name="data[call_synopsis]"><?php echo $ajio_email_v2['call_synopsis'] ?></textarea></td>
									</tr>
									<tr>
										<td>Call Observation:</td>
										<td colspan=2><textarea class="form-control" name="data[call_summary]"><?php echo $ajio_email_v2['call_summary'] ?></textarea></td>
										<td>Feedback:</td>
										<td colspan="4"><textarea class="form-control" name="data[feedback]"><?php echo $ajio_email_v2['feedback'] ?></textarea></td>
									</tr>
									<tr>
										<td colspan=2>Upload Files</td>
										<?php if($ajio_id==0){ ?>
											<td colspan="5"><input type="file" multiple class="form-control" id="attach_file" name="attach_file[]" style="padding: 10px 10px 10px 10px;"></td>
										<?php }else{
											if($ajio_email_v2['attach_file']!=''){ ?>
												<td colspan=4>
													<?php $attach_file = explode(",",$ajio_email_v2['attach_file']);
													 foreach($attach_file as $mp){ ?>
														<audio controls='' style="background-color:#607F93"> 
														  <source src="<?php echo base_url(); ?>qa_files/qa_ajio/email/<?php echo $mp; ?>" type="audio/ogg">
														  <source src="<?php echo base_url(); ?>qa_files/qa_ajio/email/<?php echo $mp; ?>" type="audio/mpeg">
														</audio> </br>
													 <?php } ?>
												</td>
										<?php }else{
												echo '<td colspan=6><b>No Files</b></td>';
											  }
										} ?>
									</tr>
									
									<?php if($ajio_id!=0){ ?>
										<tr><td colspan=2 style="font-size:16px; font-weight:bold">Agent Feedback Acceptance:</td><td colspan=4><?php echo $ajio_email_v2['agnt_fd_acpt'] ?></td></tr>
										<tr><td colspan=2 style="font-size:16px; font-weight:bold">Agent Review:</td><td colspan=4><?php echo $ajio_email_v2['agent_rvw_note'] ?></td></tr>
										<tr><td colspan=2 style="font-size:16px; font-weight:bold">Management Review:</td><td colspan=4><?php echo $ajio_email_v2['mgnt_rvw_note'] ?></td></tr>
										<tr><td colspan=2 style="font-size:16px; font-weight:bold">Client Review:</td><td colspan=4><?php echo $ajio_email_v2['client_rvw_note'] ?></td></tr>
										
										<tr><td colspan=2  style="font-size:16px">Your Review</td><td colspan=4><textarea class="form-control1" style="width:100%" id="note" name="note"  ></textarea></td></tr>
									<?php } ?>
									
									<?php 
									if($ajio_id==0){
										if(is_access_qa_module()==true || is_access_qa_operations_module()==true){ ?>
											<tr><td colspan=7><button class="btn btn-success waves-effect" type="submit" id="qaformsubmit" style="width:500px">SAVE</button></td></tr>
									<?php 
										} 
									}else{ 
										if(is_access_qa_module()==true || is_access_qa_operations_module()==true){
											if(is_available_qa_feedback($ajio_email_v2['entry_date'],72) == true){ ?>
												<tr><td colspan="7"><button class="btn btn-success waves-effect" type="submit" id='qaformsubmit' name='btnSave' value="SAVE" style="width:500px">SAVE</button></td></tr>
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
