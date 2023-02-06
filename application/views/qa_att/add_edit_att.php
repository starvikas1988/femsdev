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
	font-weight:bold;
	background-color:#F4D03F;
}
</style>

<?php if($att_id!=0){
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
										<td colspan=6 id="theader" style="font-size:40px">AT&T Audit Sheet</td>
										<input type="hidden" name="audit_start_time" value="<?php echo CurrMySqlDate(); ?>">
									</tr>
									<?php
										if($att_id==0){
											$auditorName = get_username();
											$auditDate = CurrDateMDY();
											$clDate_val='';
											//$go_live_date='';
										}else{
											if($att['entry_by']!=''){
												$auditorName = $att['auditor_name'];
											}else{
												$auditorName = $att['client_name'];
											}
											$auditDate = mysql2mmddyy($att['audit_date']);
											$clDate_val = mysql2mmddyy($att['call_date']);
											//$go_live_date = mysql2mmddyy($att['go_live_date']);
										}
									?>
									<tr>
										<td>Auditor Name:</td>
										<td><input type="text" class="form-control" value="<?php echo $auditorName; ?>" disabled></td>
										<td>Audit Date:</td>
										<td><input type="text" class="form-control" value="<?php echo $auditDate; ?>" disabled></td>
										<td>Call Date:</td>
										<td><input type="text" class="form-control" id="call_date" name="call_date" value="<?php echo $clDate_val; ?>" required ></td>
									</tr>
									<tr>
										<td>Agent:</td>
										<td>
											<select class="form-control agentName" id="agent_id" name="data[agent_id]" required>
												<?php if($att['agent_id']){ ?>
												<option value="<?php echo $att['agent_id'] ?>"><?php echo $att['fname']." ".$att['lname'] ?></option>
											<?php } ?>
												<option value="">-Select-</option>
												<?php foreach($agentName as $row):  ?>
													<option value="<?php echo $row['id']; ?>"><?php echo $row['name'].' ('.$row['fusion_id'].')'; ?></option>
												<?php endforeach; ?>
											</select>
										</td>
										<td>Employee ID:</td>
										<td><input type="text" readonly class="form-control" id="fusion_id" name="data[employee_id]" value="<?php echo $att['fusion_id'] ?>"></td>
										<td>L1 Supervisor:</td>
										<td>
											<select class="form-control" id="tl_id" name="data[tl_id]" readonly>
												<option value="<?php echo $att['tl_id'] ?>"><?php echo $att['tl_name'] ?></option>
												<option value="">--Select--</option>
												<?php foreach($tlname as $tl): ?>
													<option value="<?php echo $tl['id']; ?>"><?php echo $tl['fname']." ".$tl['lname']; ?></option>
												<?php endforeach; ?>
											</select>
										</td>
									</tr>
									<tr>
										<td>Phone Number:</td>
										<td><input type="text" class="form-control" id="phone_number" name="data[phone_number]" value="<?php echo $att['phone_number'] ?>" onkeyup="checkDec(this);" required></td>
										<td>Call Duration:</td>
										<td><input type="text" class="form-control" id="call_duration" name="data[call_duration]" value="<?php echo $att['call_duration'] ?>" required></td>
										<td>Type of Call:</td>
										<td><input type="text" class="form-control" name="data[call_type]" value="<?php echo $att['call_type'] ?>" required></td>
                                        <!--<td><select class="form-control" id="call_type" name="data[call_type]" required>
												<option value="<?php echo $att['call_type'] ?>"><?php echo $att['call_type'] ?></option>
												<option value="">-Select-</option>
												<option value="SO">SO</option>
												<option value="SJ">SJ</option>
												<option value="REC">REC</option>
												<option value="CC">CC</option>
											</select>
										</td>-->

										<!-- removed by sourav -->

										<!-- <td>Improvement Key:</td>
										<td><select class="form-control" name="data[improvement_key]">
												<option value="<?php echo $att['improvement_key'] ?>"><?php echo $att['improvement_key'] ?></option>
												<option value="">-Select-</option>
												<option value="Good improvement">Good improvement</option>
												<option value=" Little Improvement"> Little Improvement</option>
												<option value="No Improvement">No Improvement</option>
												<option value="Some Improvement">Some Improvement</option>
											</select>
										</td> 

										<td>Previous Opportunities?</td>
										<td><select class="form-control" name="data[previous_opportunity]">
												<option value="<?php echo $att['previous_opportunity'] ?>"><?php echo $att['previous_opportunity'] ?></option>
												<option value="">-Select-</option>
												<option value="Yes">Yes</option>
												<option value="No">No</option>
											</select>
										</td>-->

										<!-- removed by sourav -->

									</tr>
									<tr>
										<td>Call ID:</td>
										<td><input type="text" class="form-control" name="data[call_record_id]" value="<?php echo $att['call_record_id'] ?>" required></td>
										<td>ATTUID:</td>
										<td><input type="text" class="form-control" name="data[attuid]" value="<?php echo $att['attuid'] ?>" required></td>

										<!-- removed by sourav -->
										<!-- <td>Register Number:</td>
										<td><input type="text" class="form-control" name="data[register_no]" value="<?php echo $att['register_no'] ?>" required></td> -->
										<!-- removed by sourav -->

										<!-- Modified by sourav -->
										<td>LOB:</td>
										<td>
											<select class="form-control" name="data[lob]" required>
												<option value="" selected disabled>-Select-</option>
												<option <?php echo $att['lob']=='FNC'?"selected":""; ?> value="FNC">FNC</option>
												<option <?php echo $att['lob']=='FNL SP'?"selected":""; ?> value="FNL SP">FNL SP</option>
												<option <?php echo $att['lob']=='BMTS'?"selected":""; ?> value="BMTS">BMTS</option>
												<option <?php echo $att['lob']=='BMTS SP'?"selected":""; ?> value="BMTS SP">BMTS SP</option>
												<option <?php echo $att['lob']=='FNL'?"selected":""; ?> value="FNL">FNL</option>
											</select>
										</td>
									</tr>
									<tr>
										<td>Was this a first call from customer:</td>
										<td>
											<select class="form-control" name="data[first_call]" required>
												<option <?php echo $att['first_call']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option <?php echo $att['first_call']=='No'?"selected":""; ?> value="No">No</option>
											</select>
										</td>
										<td>Issue resolved:</td>
										<td>
											<select class="form-control" name="data[issue_resolved]" required>
												<option <?php echo $att['issue_resolved']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option <?php echo $att['issue_resolved']=='No'?"selected":""; ?> value="No">No</option>
											</select>
										</td>
										<td>Fiber Offer:</td>
										<td><input type="text" class="form-control" name="data[fiber_offer]" value="<?php echo $att['fiber_offer'] ?>" required></td>
									</tr>
									<tr>
										<td>Violation </td>
										<td>
											<select class="form-control" id="violation" name="data[violation]" required>
												<option value="" selected disabled>-Select-</option>
												<option value="Yes" <?php echo $att['violation']=='Yes'?"selected":""; ?>>Yes</option>
												<option value="No" <?php echo $att['violation']=='No'?"selected":""; ?>>No</option>
											</select>
										</td>
										<td>Type of Violation </td>
										<td>
											<select class="form-control" id="violation_type" name="data[violation_type]" required>
												<option value="" selected disabled>-Select-</option>
												<option value="No violation" <?php echo $att['violation_type']=='No violation'?"selected":""; ?>>No violation</option>
												<option value="Authentication" <?php echo $att['violation_type']=='Authentication'?"selected":""; ?>>Authentication</option>
												<option value="CPNI" <?php echo $att['violation_type']=='CPNI'?"selected":""; ?>>CPNI</option>
												<option value="Required disclosures" <?php echo $att['violation_type']=='Required disclosures'?"selected":""; ?>>Required disclosures</option>
												<option value="Credit Check" <?php echo $att['violation_type']=='Credit Check'?"selected":""; ?>>Credit Check</option>
												<option value="Documentation" <?php echo $att['violation_type']=='Documentation'?"selected":""; ?>>Documentation</option>
												<option value="Added to CX account without permission" <?php echo $att['violation_type']=='Added to CX account without permission'?"selected":""; ?>>Added to CX account without permission</option>
												<option value="Verbal consent to use SSN" <?php echo $att['violation_type']=='Verbal consent to use SSN'?"selected":""; ?>>Verbal consent to use SSN</option>
												<option value="Sales compliance " <?php echo $att['violation_type']=='Sales compliance '?"selected":""; ?>>Sales compliance </option>
												<option value="Vulgar, Offensive or sexually oriented language in communication with customers / Using profanity or curse words during the call" <?php echo $att['violation_type']=='Vulgar, Offensive or sexually oriented language in communication with customers / Using profanity or curse words during the call'?"selected":""; ?>>Vulgar, Offensive or sexually oriented language in communication with customers / Using profanity or curse words during the call</option>
												<option value="Derogatory references" <?php echo $att['violation_type']=='Derogatory references'?"selected":""; ?>>Derogatory references</option>
												<option value="Rude, abusive,  or discourteous" <?php echo $att['violation_type']=='Rude, abusive,  or discourteous'?"selected":""; ?>>Rude, abusive,  or discourteous</option>
												<option value="Flirting or making social engagements" <?php echo $att['violation_type']=='Flirting or making social engagements'?"selected":""; ?>>Flirting or making social engagements</option>
												<option value="Hung up on or blind transferred" <?php echo $att['violation_type']=='Hung up on or blind transferred'?"selected":""; ?>>Hung up on or blind transferred</option>
												<option value="Intentional transferring the call back to the queue" <?php echo $att['violation_type']=='Intentional transferring the call back to the queue'?"selected":""; ?>>Intentional transferring the call back to the queue</option>
												<option value="Intentional disseminating of inaccurate information or troubleshooting steps to release the call " <?php echo $att['violation_type']=='Intentional disseminating of inaccurate information or troubleshooting steps to release the call '?"selected":""; ?>>Intentional disseminating of inaccurate information or troubleshooting steps to release the call </option>
												<option value="intentionally ignoring cx from the queue" <?php echo $att['violation_type']=='intentionally ignoring cx from the queue'?"selected":""; ?>>intentionally ignoring cx from the queue</option>
												<option value="Camping" <?php echo $att['violation_type']=='Camping'?"selected":""; ?>>Camping</option>
												<option value="Hold >4 minutes" <?php echo $att['violation_type']=='Hold >4 minutes'?"selected":""; ?>>Hold >4 minutes</option>
												<option value="Refused to escalate" <?php echo $att['violation_type']=='Refused to escalate'?"selected":""; ?>>Refused to escalate</option>
												<option value="Transfer/Reassign/Redirect - in-scope" <?php echo $att['violation_type']=='Transfer/Reassign/Redirect - in-scope'?"selected":""; ?>>Transfer/Reassign/Redirect - in-scope</option>
												<option value="Unauthorized access" <?php echo $att['violation_type']=='Unauthorized access'?"selected":""; ?>>Unauthorized access</option>
												<option value="Was the agent seen retaining, collecting, accessing, and/or using CX information" <?php echo $att['violation_type']=='Was the agent seen retaining, collecting, accessing, and/or using CX information'?"selected":""; ?>>Was the agent seen retaining, collecting, accessing, and/or using CX information</option>
												<option value="Falsify AT&T’s or Cx records" <?php echo $att['violation_type']=='Falsify AT&T’s or Cx records'?"selected":""; ?>>Falsify AT&T’s or Cx records</option>
												<option value="Misrepresent or misleading" <?php echo $att['violation_type']=='Misrepresent or misleading'?"selected":""; ?>>Misrepresent or misleading</option>
												<option value="More than one violation" <?php echo $att['violation_type']=='More than one violation'?"selected":""; ?>>More than one violation</option>
											</select>
										</td>
										<td>Customer Audit Type:</td>
										<td>
											<select class="form-control" id="customer_audit_type" name="data[customer_audit_type]" required>
												<option value="" disabled selected>-Select-</option>
												<option value="Quality" <?php echo $att['customer_audit_type']=='Quality'?"selected":""; ?>>Quality</option>
												<option value="Compliance" <?php echo $att['customer_audit_type']=='Compliance'?"selected":""; ?>>Compliance</option>
											</select>
										</td>
									</tr>
									<tr>
										<td>Audit Type:</td>
										<td>
											<select class="form-control" id="audit_type" name="data[audit_type]" required>
												<option value="<?php echo $att['audit_type'] ?>"><?php echo $att['audit_type'] ?></option>
												<option value="">-Select-</option>
												<option value="CQ Audit">CQ Audit</option>
												<option value="BQ Audit">BQ Audit</option>
												<option value="Calibration">Calibration</option>
												<option value="Pre-Certification Mock Call">Pre-Certification Mock Call</option>
												<option value="Certification Audit">Certification Audit</option>
												<?php if(get_login_type()!="client"){ ?>
													<option value="Operation Audit">Operation Audit</option>
													<option value="Trainer Audit">Trainer Audit</option>
												<?php } ?>
											</select>
										</td>
										<td class="auType">Auditor Type</td>
										<td class="auType">
											<select class="form-control" id="auditor_type" name="data[auditor_type]">
												<option value="<?php echo $att['auditor_type'] ?>"><?php echo $att['auditor_type'] ?></option>
												<option value="">-Select-</option>
												<option value="Master">Master</option>
												<option value="Regular">Regular</option>
											</select>
										</td>
										<td>VOC:</td>
										<td>
											<select class="form-control" id="voc" name="data[voc]" required>
												<option value="<?php echo $att['voc'] ?>"><?php echo $att['voc'] ?></option>
												<option value="">-Select-</option>
												<option value="1">1</option>
												<option value="2">2</option>
												<option value="3">3</option>
												<option value="4">4</option>
												<option value="5">5</option>
											</select>
										</td>
									</tr>
									<tr><td colspan=6 style="background-color:#BFC9CA"></td></tr>
									
									<tr>
										<td style="font-weight:bold; font-size:16px">Possible Score:</td>
										<td><input type="text" readonly id="attPossible" name="data[possible_score]" class="form-control" style="font-weight:bold" value="<?php echo $att['possible_score']; ?>"></td>

										<td style="font-weight:bold; font-size:16px">Earned Score:</td>
										<td><input type="text" readonly id="attEarned" name="data[earned_score]" class="form-control" style="font-weight:bold" value="<?php echo $att['earned_score']; ?>"></td>

										<td style="font-weight:bold; font-size:16px; text-align:right">Overall Score:</td>
										<td>
											<input type="text" readonly id="attOverall" name="data[overall_score]" class="form-control" style="font-weight:bold" value="<?php echo $att['overall_score'] ?>">
										</td>
									</tr>
									<tr style="background-color:#A9CCE3; font-weight:bold">
										<td colspan=2>At Your Service</td>
										<td colspan=2>Expected behavior</td>
										<td>Weitage</td>
										<td>Rating</td>
									</tr>
									<tr>
										<td rowspan=2>Commitment</td>
										<td rowspan=2>Greet</td>
										<td colspan=2>Warmly welcome</td>
										<td>5</td>
										<td>
											<select class="form-control att_point" name="data[warmly_welcome]" required>
												<option att_val=5 <?php echo $att['warmly_welcome']=='Effective'?"selected":""; ?> value="Effective">Effective</option>
												<option att_val=5 <?php echo $att['warmly_welcome']=='Not effective'?"selected":""; ?> value="Not effective">Not effective</option>
												<option att_val=0 <?php echo $att['warmly_welcome']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
									</tr>
									<tr>
										<td colspan=2>Call flow utilization</td>
										<td>5</td>
										<td>
											<select class="form-control att_point" name="data[call_flow_utilization]" required>
												<option att_val=5 <?php echo $att['call_flow_utilization']=='Effective'?"selected":""; ?> value="Effective">Effective</option>
												<option att_val=5 <?php echo $att['call_flow_utilization']=='Not effective'?"selected":""; ?> value="Not effective">Not effective</option>
												<option att_val=0 <?php echo $att['call_flow_utilization']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
									</tr>
								<!-- 	<tr>
										<td colspan=2>Make it personal</td>
										<td>3</td>
										<td>
											<select class="form-control att_point" name="data[make_it_personal]" required>
												<option att_val=3 <?php echo $att['make_it_personal']=='Effective'?"selected":""; ?> value="Effective">Effective</option>
												<option att_val=3 <?php echo $att['make_it_personal']=='Not effective'?"selected":""; ?> value="Not effective">Not effective</option>
												<option att_val=0 <?php echo $att['make_it_personal']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
									</tr> -->
									<tr>
										<td rowspan=5>Analytical Thinking</td>
										<td rowspan=5>Understand</td>
										<td colspan=2>Acknowledge</td>
										<td>6</td>
										<td>
											<select class="form-control att_point" name="data[acknowledge]" required>
												<option att_val=6 <?php echo $att['acknowledge']=='Effective'?"selected":""; ?> value="Effective">Effective</option>
												<option att_val=6 <?php echo $att['acknowledge']=='Not effective'?"selected":""; ?> value="Not effective">Not effective</option>
												<option att_val=0 <?php echo $att['acknowledge']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
									</tr>
									<tr>
										<td colspan=2>Empathy</td>
										<td>6</td>
										<td>
											<select class="form-control att_point" name="data[empathy]" required>
												<option att_val=6 <?php echo $att['empathy']=='Effective'?"selected":""; ?> value="Effective">Effective</option>
												<option att_val=6 <?php echo $att['empathy']=='Not effective'?"selected":""; ?> value="Not effective">Not effective</option>
												<option att_val=0 <?php echo $att['empathy']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
									</tr>
									<tr>
										<td colspan=2>Reassurance</td>
										<td>6</td>
										<td>
											<select class="form-control att_point" name="data[reassurance]" required>
												<option att_val=6 <?php echo $att['reassurance']=='Effective'?"selected":""; ?> value="Effective">Effective</option>
												<option att_val=6 <?php echo $att['reassurance']=='Not effective'?"selected":""; ?> value="Not effective">Not effective</option>
												<option att_val=0 <?php echo $att['reassurance']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
									</tr>
							<!-- 		<tr>
										<td colspan=2>Ownership</td>
										<td>3</td>
										<td>
											<select class="form-control att_point" name="data[ownership]" required>
												<option att_val=3 <?php echo $att['ownership']=='Effective'?"selected":""; ?> value="Effective">Effective</option>
												<option att_val=3 <?php echo $att['ownership']=='Not effective'?"selected":""; ?> value="Not effective">Not effective</option>
												<option att_val=0 <?php echo $att['ownership']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
									</tr> -->
									<tr>
										<td colspan=2>CPNI</td>
										<td>6</td>
										<td>
											<select class="form-control att_point" name="data[cpni]" required>
												<option att_val=6 <?php echo $att['cpni']=='Effective'?"selected":""; ?> value="Effective">Effective</option>
												<option att_val=6 <?php echo $att['cpni']=='Not effective'?"selected":""; ?> value="Not effective">Not effective</option>
												<option att_val=0 <?php echo $att['cpni']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
									</tr>
									<tr>
										<!-- Modified by sourav -->
										<td colspan=2>CBR</td>
										<td>6</td>
										<td>
											<select class="form-control att_point" name="data[cbr]" required>

												<option att_val=6 <?php echo $att['cbr']=='Effective'?"selected":""; ?> value="Effective">Effective</option>
												<option att_val=6 <?php echo $att['cbr']=='Not effective'?"selected":""; ?> value="Not effective">Not effective</option>
												<option att_val=0 <?php echo $att['cbr']=='N/A'?"selected":""; ?> value="N/A">N/A</option>

											</select>
										</td>
										<!-- Modified by sourav -->
									</tr>
									<tr>
										<td rowspan=5>Results Delivery</td>
										<td rowspan=3>Recommend</td>
										<td colspan=2>Resources Utilization</td>
										<td>7</td>
										<td>
											<select class="form-control att_point" name="data[resources_utilization]" required>
												<option att_val=7 <?php echo $att['resources_utilization']=='Effective'?"selected":""; ?> value="Effective">Effective</option>
												<option att_val=7 <?php echo $att['resources_utilization']=='Not effective'?"selected":""; ?> value="Not effective">Not effective</option>
												<option att_val=0 <?php echo $att['resources_utilization']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
									</tr>
									<tr>
										<td colspan=2>Professional Language / Communication</td>
										<td>7</td>
										<td>
											<select class="form-control att_point" name="data[professional_language]" required>
												<option att_val=7 <?php echo $att['professional_language']=='Effective'?"selected":""; ?> value="Effective">Effective</option>
												<option att_val=7 <?php echo $att['professional_language']=='Not effective'?"selected":""; ?> value="Not effective">Not effective</option>
												<option att_val=0 <?php echo $att['professional_language']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
									</tr>
									<tr>
										<td colspan=2>Hold & Dead air</td>
										<td>7</td>
										<td>
											<select class="form-control att_point" name="data[hold_dead_air]" required>
												<option att_val=7 <?php echo $att['hold_dead_air']=='Effective'?"selected":""; ?> value="Effective">Effective</option>
												<option att_val=7 <?php echo $att['hold_dead_air']=='Not effective'?"selected":""; ?> value="Not effective">Not effective</option>
												<option att_val=0 <?php echo $att['hold_dead_air']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
									</tr>
							<!-- 		<tr>
										<td colspan=2>Effective Sales Offer</td>
										<td>12</td>
										<td>
											<select class="form-control att_point" name="data[effective_sales_offer]" required>
												<option att_val=12 <?php echo $att['effective_sales_offer']=='Effective'?"selected":""; ?> value="Effective">Effective</option>
												<option att_val=12 <?php echo $att['effective_sales_offer']=='Not effective'?"selected":""; ?> value="Not effective">Not effective</option>
												<option att_val=0 <?php echo $att['effective_sales_offer']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
									</tr> -->
									<!--<tr>
										<td colspan=2>Sales compliance</td>
										<td>10</td>
										<td>
											<select class="form-control att_point" name="data[sales_compliance]" required>
												<option att_val=10 <?php echo $att['sales_compliance']=='Effective'?"selected":""; ?> value="Effective">Effective</option>
												<option att_val=10 <?php echo $att['sales_compliance']=='Not effective'?"selected":""; ?> value="Not effective">Not effective</option>
												<option att_val=0 <?php echo $att['sales_compliance']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
									</tr>-->
									<tr>
										<td rowspan=2>Resolve</td>
										<td colspan=2>Fully resolve</td>
										<td>8</td>
										<td>
											<select class="form-control att_point" name="data[fully_resolved]" required>
												<option att_val=8 <?php echo $att['fully_resolved']=='Effective'?"selected":""; ?> value="Effective">Effective</option>
												<option att_val=8 <?php echo $att['fully_resolved']=='Not effective'?"selected":""; ?> value="Not effective">Not effective</option>
												<option att_val=0 <?php echo $att['fully_resolved']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
									</tr>
									<tr>
										<td colspan=2>Transfer procedure</td>
										<td>5</td>
										<td>
											<select class="form-control att_point" name="data[transfer_procedure]" required>
												<option att_val=5 <?php echo $att['transfer_procedure']=='Effective'?"selected":""; ?> value="Effective">Effective</option>
												<option att_val=5 <?php echo $att['transfer_procedure']=='Not effective'?"selected":""; ?> value="Not effective">Not effective</option>
												<option att_val=0 <?php echo $att['transfer_procedure']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
									</tr>
									<tr>
										<td rowspan=5>Excellent Experience</td>
										<td rowspan=3>Confirm & educate</td>
										<td colspan=2>Recap</td>
										<td>5</td>
										<td>
											<select class="form-control att_point" name="data[recap]" required>
												<option att_val=5 <?php echo $att['recap']=='Effective'?"selected":""; ?> value="Effective">Effective</option>
												<option att_val=5 <?php echo $att['recap']=='Not effective'?"selected":""; ?> value="Not effective">Not effective</option>
												<option att_val=0 <?php echo $att['recap']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
									</tr>
									<tr>
										<td colspan=2>Next steps</td>
										<td>5</td>
										<td>
											<select class="form-control att_point" name="data[next_step]" required>
												<option att_val=5 <?php echo $att['next_step']=='Effective'?"selected":""; ?> value="Effective">Effective</option>
												<option att_val=5 <?php echo $att['next_step']=='Not effective'?"selected":""; ?> value="Not effective">Not effective</option>
												<option att_val=0 <?php echo $att['next_step']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
									</tr>
									<tr>
										<td colspan=2>Self service options</td>
										<td>5</td>
										<td>
											<select class="form-control att_point" name="data[self_service_option]" required>
												<option att_val=5 <?php echo $att['self_service_option']=='Effective'?"selected":""; ?> value="Effective">Effective</option>
												<option att_val=5 <?php echo $att['self_service_option']=='Not effective'?"selected":""; ?> value="Not effective">Not effective</option>
												<option att_val=0 <?php echo $att['self_service_option']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
									</tr>
									<tr>
										<td rowspan=2>Positive close</td>
										<td colspan=2>Additional Assistance</td>
										<td>6</td>
										<td>
											<select class="form-control att_point" name="data[additional_assistance]" required>
												<option att_val=6 <?php echo $att['additional_assistance']=='Effective'?"selected":""; ?> value="Effective">Effective</option>
												<option att_val=6 <?php echo $att['additional_assistance']=='Not effective'?"selected":""; ?> value="Not effective">Not effective</option>
												<option att_val=0 <?php echo $att['additional_assistance']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
									</tr>
									<tr>
										<td colspan=2>Sincerely Thank</td>
										<td>5</td>
										<td>
											<select class="form-control att_point" name="data[sincerely_thanks]" required>
												<option att_val=5 <?php echo $att['sincerely_thanks']=='Effective'?"selected":""; ?> value="Effective">Effective</option>
												<option att_val=5 <?php echo $att['sincerely_thanks']=='Not effective'?"selected":""; ?> value="Not effective">Not effective</option>
												<option att_val=0 <?php echo $att['sincerely_thanks']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
									</tr>
									
									<tr><td colspan=6 style="background-color:#BFC9CA"></td></tr>
									
									<tr>
										<td colspan=5 style="font-weight:bold; font-size:16px; text-align:right">Compliance Score:</td>
										<td><input type="text" readonly id="attComplianceOverall" name="data[compliance_score]" class="form-control" style="font-weight:bold" value="<?php echo $att['compliance_score'] ?>"></td>
									</tr>
									<tr style="background-color:#A9CCE3; font-weight:bold">
										<td rowspan=25 style="background-color:#A9CCE3; font-weight:bold">STANDARD/ REQUIRED COMPLIANCE</td>
										<td colspan=2>Paramerers</td>
										<td>Status</td>
										<td colspan=2>Remarks</td>
									</tr>
									<tr>
										<td colspan=2>Authentication</td>
										<td>
											<select class="form-control attCompliance" id="attCompAF1" name="data[authentication]" required>	
												<option <?php echo $att['authentication']=='No'?"selected":""; ?> value="No">No</option>
												<option <?php echo $att['authentication']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
											</select>
										</td>
										<td colspan=2><textarea name="data[cmt1]" class="form-control"><?php echo $att['cmt1'] ?></textarea></td>
									</tr>
									<tr>
										<td colspan=2>CPNI</td>
										<td>
											<select class="form-control attCompliance" id="attCompAF2" name="data[cpni_compliance]" required>
												<option <?php echo $att['cpni_compliance']=='No'?"selected":""; ?> value="No">No</option>
												<option <?php echo $att['cpni_compliance']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
											</select>
										</td>
										<td colspan=2><textarea name="data[cmt2]" class="form-control"><?php echo $att['cmt2'] ?></textarea></td>
									</tr>
									<tr>
										<td colspan=2>Required disclosures</td>
										<td>
											<select class="form-control attCompliance" id="attCompAF3" name="data[required_disclosures]" required>
												<option <?php echo $att['required_disclosures']=='No'?"selected":""; ?> value="No">No</option>
												<option <?php echo $att['required_disclosures']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
											</select>
										</td>
										<td colspan=2><textarea name="data[cmt3]" class="form-control"><?php echo $att['cmt3'] ?></textarea></td>
									</tr>
									<tr>
										<td colspan=2>Credit Check</td>
										<td>
											<select class="form-control attCompliance" id="attCompAF4" name="data[credit_check]" required>
												<option <?php echo $att['credit_check']=='No'?"selected":""; ?> value="No">No</option>
												<option <?php echo $att['credit_check']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
											</select>
										</td>
										<td colspan=2><textarea name="data[cmt4]" class="form-control"><?php echo $att['cmt4'] ?></textarea></td>
									</tr>
									<tr>
										<td colspan=2>Documentation</td>
										<td>
											<select class="form-control attCompliance" id="attCompAF5" name="data[documentation]" required>
												<option <?php echo $att['documentation']=='No'?"selected":""; ?> value="No">No</option>
												<option <?php echo $att['documentation']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
											</select>
										</td>
										<td colspan=2><textarea name="data[cmt5]" class="form-control"><?php echo $att['cmt5'] ?></textarea></td>
									</tr>
									<tr>
										<td colspan=2>Added to CX account without permission</td>
										<td>
											<select class="form-control attCompliance" id="attCompAF6" name="data[account_permission]" required>
												<option <?php echo $att['account_permission']=='No'?"selected":""; ?> value="No">No</option>
												<option <?php echo $att['account_permission']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
											</select>
										</td>
										<td colspan=2><textarea name="data[cmt6]" class="form-control"><?php echo $att['cmt6'] ?></textarea></td>
									</tr>
									<tr>
										<td colspan=2>Verbal consent to use SSN</td>
										<td>
											<select class="form-control attCompliance" id="attCompAF7" name="data[verbal_consent]" required>
												<option <?php echo $att['verbal_consent']=='No'?"selected":""; ?> value="No">No</option>
												<option <?php echo $att['verbal_consent']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
											</select>
										</td>
										<td colspan=2><textarea name="data[cmt7]" class="form-control"><?php echo $att['cmt7'] ?></textarea></td>
									</tr>
									<tr>
										<td colspan=2>Sales compliance </td>
										<td>
											<select class="form-control attCompliance" id="attCompAF8" name="data[compliance_sales]" required>
												<option <?php echo $att['compliance_sales']=='No'?"selected":""; ?> value="No">No</option>
												<option <?php echo $att['compliance_sales']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
											</select>
										</td>
										<td colspan=2><textarea name="data[cmt8]" class="form-control"><?php echo $att['cmt8'] ?></textarea></td>
									</tr>
									<tr>
										<td colspan=2>Vulgar, Offensive or sexually oriented language in communication with customers / Using profanity or curse words during the call</td>
										<td>
											<select class="form-control attCompliance" id="attCompAF9" name="data[communication_customers]" required>
												<option <?php echo $att['communication_customers']=='No'?"selected":""; ?> value="No">No</option>
												<option <?php echo $att['communication_customers']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
											</select>
										</td>
										<td colspan=2><textarea name="data[cmt9]" class="form-control"><?php echo $att['cmt9'] ?></textarea></td>
									</tr>
									<tr>
										<td colspan=2>Derogatory references</td>
										<td>
											<select class="form-control attCompliance" id="attCompAF10" name="data[derogatory_references]" required>
												<option <?php echo $att['derogatory_references']=='No'?"selected":""; ?> value="No">No</option>
												<option <?php echo $att['derogatory_references']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
											</select>
										</td>
										<td colspan=2><textarea name="data[cmt10]" class="form-control"><?php echo $att['cmt10'] ?></textarea></td>
									</tr>
									<tr>
										<td colspan=2>Rude, abusive,  or discourteous</td>
										<td>
											<select class="form-control attCompliance" id="attCompAF11" name="data[discourteous]" required>
												<option <?php echo $att['discourteous']=='No'?"selected":""; ?> value="No">No</option>
												<option <?php echo $att['discourteous']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
											</select>
										</td>
										<td colspan=2><textarea name="data[cmt11]" class="form-control"><?php echo $att['cmt11'] ?></textarea></td>
									</tr>
									<tr>
										<td colspan=2>Flirting or making social engagements</td>
										<td>
											<select class="form-control attCompliance" id="attCompAF12" name="data[social_engagements]" required>	
												<option <?php echo $att['social_engagements']=='No'?"selected":""; ?> value="No">No</option>
												<option <?php echo $att['social_engagements']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
											</select>
										</td>
										<td colspan=2><textarea name="data[cmt12]" class="form-control"><?php echo $att['cmt12'] ?></textarea></td>
									</tr>
									<tr>
										<td colspan=2>Hung up on or blind transferred</td>
										<td>
											<select class="form-control attCompliance" id="attCompAF13" name="data[blind_transferred]" required>	
												<option <?php echo $att['blind_transferred']=='No'?"selected":""; ?> value="No">No</option>
												<option <?php echo $att['blind_transferred']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
											</select>
										</td>
										<td colspan=2><textarea name="data[cmt13]" class="form-control"><?php echo $att['cmt13'] ?></textarea></td>
									</tr>
									<tr>
										<td colspan=2>Intentional transferring the call back to the queue</td>
										<td>
											<select class="form-control attCompliance" id="attCompAF14" name="data[intentional_transferring]" required>	
												<option <?php echo $att['intentional_transferring']=='No'?"selected":""; ?> value="No">No</option>
												<option <?php echo $att['intentional_transferring']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
											</select>
										</td>
										<td colspan=2><textarea name="data[cmt14]" class="form-control"><?php echo $att['cmt14'] ?></textarea></td>
									</tr>
									<tr>
										<td colspan=2>Intentional disseminating of inaccurate information or troubleshooting steps to release the call</td>
										<td>
											<select class="form-control attCompliance" id="attCompAF15" name="data[inaccurate_information]" required>	
												<option <?php echo $att['inaccurate_information']=='No'?"selected":""; ?> value="No">No</option>
												<option <?php echo $att['inaccurate_information']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
											</select>
										</td>
										<td colspan=2><textarea name="data[cmt15]" class="form-control"><?php echo $att['cmt15'] ?></textarea></td>
									</tr>
									<tr>
										<td colspan=2>Intentionally ignoring customer from the queue</td>
										<td>
											<select class="form-control attCompliance" id="attCompAF16" name="data[intentioanlly_ignoring_customer]" required>	
												<option <?php echo $att['intentioanlly_ignoring_customer']=='No'?"selected":""; ?> value="No">No</option>
												<option <?php echo $att['intentioanlly_ignoring_customer']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
											</select>
										</td>
										<td colspan=2><textarea name="data[cmt16]" class="form-control"><?php echo $att['cmt16'] ?></textarea></td>
									</tr>
									<tr>
										<td colspan=2>Camping</td>
										<td>
											<select class="form-control attCompliance" id="attCompAF17" name="data[camping]" required>	
												<option <?php echo $att['camping']=='No'?"selected":""; ?> value="No">No</option>
												<option <?php echo $att['camping']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
											</select>
										</td>
										<td colspan=2><textarea name="data[cmt17]" class="form-control"><?php echo $att['cmt17'] ?></textarea></td>
									</tr>
									<tr>
										<td colspan=2>Hold/Dead air > 4 minutes</td>
										<td>
											<select class="form-control attCompliance" id="attCompAF18" name="data[compliance_hold_dead_air]" required>	
												<option <?php echo $att['compliance_hold_dead_air']=='No'?"selected":""; ?> value="No">No</option>
												<option <?php echo $att['compliance_hold_dead_air']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
											</select>
										</td>
										<td colspan=2><textarea name="data[cmt18]" class="form-control"><?php echo $att['cmt18'] ?></textarea></td>
									</tr>
									<tr>
										<td colspan=2>Refused to escalate</td>
										<td>
											<select class="form-control attCompliance" id="attCompAF19" name="data[refused_escalate]" required>	
												<option <?php echo $att['refused_escalate']=='No'?"selected":""; ?> value="No">No</option>
												<option <?php echo $att['refused_escalate']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
											</select>
										</td>
										<td colspan=2><textarea name="data[cmt19]" class="form-control"><?php echo $att['cmt19'] ?></textarea></td>
									</tr>
									<tr>
										<td colspan=2>Transfer/Reassign/Redirect - in-scope</td>
										<td>
											<select class="form-control attCompliance" id="attCompAF20" name="data[transfer_in_scope]" required>	
												<option <?php echo $att['transfer_in_scope']=='No'?"selected":""; ?> value="No">No</option>
												<option <?php echo $att['transfer_in_scope']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
											</select>
										</td>
										<td colspan=2><textarea name="data[cmt20]" class="form-control"><?php echo $att['cmt20'] ?></textarea></td>
									</tr>
									<tr>
										<td colspan=2>Unauthorized access</td>
										<td>
											<select class="form-control attCompliance" id="attCompAF21" name="data[unauthorized_access]" required>	
												<option <?php echo $att['unauthorized_access']=='No'?"selected":""; ?> value="No">No</option>
												<option <?php echo $att['unauthorized_access']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
											</select>
										</td>
										<td colspan=2><textarea name="data[cmt21]" class="form-control"><?php echo $att['cmt21'] ?></textarea></td>
									</tr>
									<tr>
										<td colspan=2>Was the agent seen retaining collecting accessing and/or using customer information</td>
										<td>
											<select class="form-control attCompliance" id="attCompAF22" name="data[agent_seen_retaining_collecting]" required>	
												<option <?php echo $att['agent_seen_retaining_collecting']=='No'?"selected":""; ?> value="No">No</option>
												<option <?php echo $att['agent_seen_retaining_collecting']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
											</select>
										</td>
										<td colspan=2><textarea name="data[cmt22]" class="form-control"><?php echo $att['cmt22'] ?></textarea></td>
									</tr>
									<tr>
										<td colspan=2>Falsify AT&Ts or customers records</td>
										<td>
											<select class="form-control attCompliance" id="attCompAF23" name="data[att_customer_records]" required>	
												<option <?php echo $att['att_customer_records']=='No'?"selected":""; ?> value="No">No</option>
												<option <?php echo $att['att_customer_records']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
											</select>
										</td>
										<td colspan=2><textarea name="data[cmt23]" class="form-control"><?php echo $att['cmt23'] ?></textarea></td>
									</tr>
									<tr>
										<td colspan=2>Misrepresent or misleading</td>
										<td>
											<select class="form-control attCompliance" id="attCompAF24" name="data[misrepresent_misleading]" required>	
												<option <?php echo $att['misrepresent_misleading']=='No'?"selected":""; ?> value="No">No</option>
												<option <?php echo $att['misrepresent_misleading']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
											</select>
										</td>
										<td colspan=2><textarea name="data[cmt24]" class="form-control"><?php echo $att['cmt24'] ?></textarea></td>
									</tr>
									
									<tr><td colspan=6 style="background-color:#BFC9CA"></td></tr>
									
									<tr>
										<td>Call Summary:</td>
										<td colspan="2"><textarea class="form-control" id="" name="data[call_summary]"><?php echo $att['call_summary'] ?></textarea></td>
										<td>Feedback:</td>
										<td colspan="2"><textarea class="form-control" id="" name="data[feedback]"><?php echo $att['feedback'] ?></textarea></td>
									</tr>
									<?php if($att_id==0){ ?>
									<tr>
										<td colspan=3>Upload Files</td>
										<td colspan=5><input type="file" multiple class="form-control" id="attach_file" name="attach_file[]"></td>
									</tr>
									<?php }else{ ?>
									<tr>
										<td colspan=3>Upload Files</td>
										<?php if($att['attach_file']!=''){ ?>
											<td colspan=5>
												<?php $attach_file = explode(",",$att['attach_file']);
												 foreach($attach_file as $mp){ ?>
													<audio controls='' style="background-color:#607F93">
													  <source src="<?php echo base_url(); ?>qa_files/qa_att/<?php echo $mp; ?>" type="audio/ogg">
													  <source src="<?php echo base_url(); ?>qa_files/qa_att/<?php echo $mp; ?>" type="audio/mpeg">
													</audio> </br>
												 <?php } ?>
											</td>
										<?php }else{
												echo '<td colspan=6><b>No Files</b></td>';
											  }
										} ?>
									</tr>


									<?php if($att_id!=0){ ?>
										<tr><td colspan=3 style="font-size:16px; font-weight:bold">Agent Feedback Acceptance:</td><td colspan=5><?php echo $att['agnt_fd_acpt'] ?></td></tr>
										<tr><td colspan=3 style="font-size:16px; font-weight:bold">Management Review:</td><td colspan=5><?php echo $att['mgnt_rvw_note'] ?></td></tr>
										<tr><td colspan=3 style="font-size:16px; font-weight:bold">Client Review:</td><td colspan=5><?php echo $att['client_rvw_note'] ?></td></tr>

										<tr><td colspan=3  style="font-size:16px">Your Review</td><td colspan=5><textarea class="form-control1" style="width:100%" id="note" name="note"  ><?php echo $att['agent_rvw_note'] ?></textarea></td></tr>
									<?php } ?>


									<?php
									if($att_id==0){
										if(is_access_qa_module()==true || is_access_qa_operations_module()==true){ ?>
											<tr><td colspan=8><button class="btn btn-success waves-effect" type="submit" id="qaformsubmit" style="width:500px">SAVE</button></td></tr>
									<?php
										}
									}else{
										if(is_access_qa_module()==true || is_access_qa_operations_module()==true){
											 if($att['agent_rvw_note']=="") { ?>
												<tr><td colspan="8"><button class="btn btn-success waves-effect" type="submit" id='qaformsubmit' name='btnSave' value="SAVE" style="width:500px">SAVE</button></td></tr>
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


<script>
	function checkDec(el){
		var ex = /^[0-9]+\.?[0-9]*$/;
		if(ex.test(el.value)==false){
			el.value = el.value.substring(0,el.value.length - 1);
		}
	}
</script>