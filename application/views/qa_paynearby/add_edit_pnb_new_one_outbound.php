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
.new-file input[type="file"]{
	padding-top: 10px!important;
}
.select2-selection.select2-selection--single{
	height: 40px!important;
	border-radius: 1px!important;
}
.new-btn{
	width: 500px;
	padding: 10px;
	border-radius:1px!important ;
}
.form-control{
		border-radius:1px!important ;
}
.select2-container{
	width: 100%!important;
}
</style>

<?php if($pnboutbound_id!=0){
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
										<td colspan="6" id="theader" style="font-size:40px">Retention VRM</td>
										<input type="hidden" name="audit_start_time" value="<?php echo CurrMySqlDate(); ?>">
									</tr>
									<?php
										if($pnboutbound_id==0){
											$auditorName = get_username();
											$auditDate = CurrDateMDY();
											$clDate_val='';
											//$go_live_date='';
										}else{
											if($pnb_new_ob['entry_by']!=''){
												$auditorName = $pnb_new_ob['auditor_name'];
											}else{
												$auditorName = $pnb_new_ob['client_name'];
											}
											$auditDate = mysql2mmddyy($pnb_new_ob['audit_date']);
											$clDate_val = mysql2mmddyy($pnb_new_ob['call_date']);
											//$go_live_date = mysql2mmddyy($pnb_new_ob['go_live_date']);
										}
									?>
									<tr>
										<td style="width:120px">Auditor Name:</td>
										<td style="width:250px;"><input type="text" class="form-control" value="<?php echo $auditorName; ?>" disabled></td>
										<td style="width: 120px;">Audit Date:</td>
										<td style="width:250px"><input type="text" class="form-control" value="<?php echo $auditDate; ?>" disabled></td>
										<td>Call Date:</td>
										<td style="width:250px;"><input type="text" readonly class="form-control" id="from_date" name="call_date" value="<?php echo $clDate_val; ?>" required ></td>
									</tr>
									<tr>
										<td>Agent:</td>
										<td>
											<select class="form-control agentName" id="agent_id" name="data[agent_id]" required>
												<option value="<?php echo $pnb_new_ob['agent_id'] ?>"><?php echo $pnb_new_ob['fname']." ".$pnb_new_ob['lname'] ?></option>
												<!-- <option value="">-Select-</option> -->
												<?php foreach($agentName as $row):  ?>
													<option value="<?php echo $row['id']; ?>"><?php echo $row['name'].' ('.$row['fusion_id'].')'; ?></option>
												<?php endforeach; ?>
											</select>
										</td>
										<td>Fusion ID:</td>
										<td><input type="text" readonly class="form-control" id="fusion_id" name="" value="<?php echo $pnb_new_ob['fusion_id'] ?>"></td>
										<td>L1 Supervisor:</td>
										<td>
											<select class="form-control" id="tl_id" name="data[tl_id]" readonly>
												<option value="<?php echo $pnb_new_ob['tl_id'] ?>"><?php echo $pnb_new_ob['tl_name'] ?></option>
												<option value="">--Select--</option>
												<?php foreach($tlname as $tl): ?>
													<option value="<?php echo $tl['id']; ?>"><?php echo $tl['fname']." ".$tl['lname']; ?></option>
												<?php endforeach; ?>
											</select>
										</td>
									</tr>
									<tr>
										<td>Campaign:</td>
										<td><input type="text" readonly class="form-control" id="campaign" name="data[campaign]" value="<?php echo $pnb_new_ob['campaign'] ?>"></td>
										<td>Call Duration:</td>
										<td><input type="text" readonly class="form-control" id="call_duration" name="data[call_duration]" value="<?php echo $pnb_new_ob['call_duration'] ?>" required></td>
										<td>Incoming No.:</td>
										<td><input type="text" class="form-control" id="incoming_no" name="data[incoming_no]" value="<?php echo $pnb_new_ob['incoming_no'] ?>" onkeyup="checkDec(this);" required></td>
									</tr>
									<tr>
										<td>Register No.:</td>
										<td><input type="text" class="form-control" id="register_no" name="data[register_no]" value="<?php echo $pnb_new_ob['register_no'] ?>" required></td>
										<td>Customer Name:</td>
										<td><input type="text" class="form-control" id="customer" name="data[customer]" value="<?php echo $pnb_new_ob['customer'] ?>" required></td>
										<td>Call Link:</td>
										<td><input type="text" class="form-control" id="call_link" name="data[call_link]" value="<?php echo $pnb_new_ob['call_link'] ?>" required></td>
									</tr>
									<tr>
										<td>Ticket No.:</td>
										<td><input type="text" class="form-control" id="ticket_no" name="data[ticket_no]" value="<?php echo $pnb_new_ob['ticket_no'] ?>" required></td>
										<td>Call Disconnect By:</td>
										<td><input type="text" class="form-control" id="call_disconnect_by" name="data[call_disconnect_by]" value="<?php echo $pnb_new_ob['call_disconnect_by'] ?>"  required></td>
										<td>Tagging/Disposition:</td>
										<td>
											<input type="text" class="form-control" id="" name="data[tagging]" value="<?php echo $pnb_new_ob['tagging'] ?>" required>
										</td>
									</tr>
									<tr>
										<td>Query/Service:</td>
										<td><input type="text" value="<?php echo $pnb_new_ob['query_service']?>" class="form-control" id="query_service" name="data[query_service]" required></td>
										<td>Type of Call:</td>
										<td><input type="text" class="form-control" id="call_type" name="data[call_type]" value="<?php echo $pnb_new_ob['call_type'] ?>" required></td>
									</tr>
									<tr>
										<td>Audit Type:</td>
										<td>
											<select class="form-control" id="audit_type" name="data[audit_type]" required>
												<option value="<?php echo $pnb_new_ob['audit_type'] ?>"><?php echo $pnb_new_ob['audit_type'] ?></option>
												<option value="">-Select-</option>
												<option value="CQ Audit">CQ Audit</option>
												<option value="BQ Audit">BQ Audit</option>
												<option value="Calibration">Calibration</option>
												<option value="Pre-Certification Mock Call">Pre-Certification Mock Call</option>
												<option value="Certification Audit">Certification Audit</option>
												<?php if(get_login_type()!="client"){ ?>
													<option value="Operation Audit">Operation Audit</option>
													<option value="Trainer Audit">Trainer Audit</option>
													<option value="QA Supervisor Audit">QA Supervisor Audit</option>
												<?php } ?>
											</select>
										</td>
										<td class="auType">Auditor Type</td>
										<td class="auType">
											<select class="form-control" id="auditor_type" name="data[auditor_type]">
												<option value="<?php echo $pnb_new_ob['auditor_type'] ?>"><?php echo $pnb_new_ob['auditor_type'] ?></option>
												<option value="">-Select-</option>
												<option value="Master">Master</option>
												<option value="Regular">Regular</option>
											</select>
										</td>
										<td>VOC:</td>
										<td>
											<select class="form-control" id="voc" name="data[voc]" required>
												<option value="<?php echo $pnb_new_ob['voc'] ?>"><?php echo $pnb_new_ob['voc'] ?></option>
												<option value="">-Select-</option>
												<option value="1">1</option>
												<option value="2">2</option>
												<option value="3">3</option>
												<option value="4">4</option>
												<option value="5">5</option>
											</select>
										</td>
									</tr>
									<tr style="background-color:#EAFAF1">
										<td>VOC:</td>
										<td><input type="text" name="data[customer_voc]" class="form-control" value="<?php echo $pnb_new_ob['customer_voc']; ?>" required></td>
										<td>Issue Resolved:</td>
										<td>
											<select class="form-control" name="data[issue_resolved]" required>
												<option value="">-Select-</option>
												<option <?php echo $pnb_new_ob['issue_resolved']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option <?php echo $pnb_new_ob['issue_resolved']=='No'?"selected":""; ?> value="No">No</option>
											</select>
										</td>
										<td>Customer came with (mood):</td>
										<td>
											<select class="form-control" name="data[customer_came_with_mood]" required>
												<option value="">-Select-</option>
												<option <?php echo $pnb_new_ob['customer_came_with_mood']=='Happy'?"selected":""; ?> value="Happy">Happy</option>
												<option <?php echo $pnb_new_ob['customer_came_with_mood']=='Not Happy'?"selected":""; ?> value="Not Happy">Not Happy</option>
												<option <?php echo $pnb_new_ob['customer_came_with_mood']=='Neutral'?"selected":""; ?> value="Neutral">Neutral</option>
												<option <?php echo $pnb_new_ob['customer_came_with_mood']=='Extremely Dissatisfied'?"selected":""; ?> value="Extremely Dissatisfied">Extremely Dissatisfied</option>
											</select>
										</td>
									</tr>
									<tr style="background-color:#EAFAF1">
										<td>Priority:</td>
										<td>
											<select class="form-control" name="data[priority]" required>
												<option value="">-Select-</option>
												<option <?php echo $pnb_new_ob['priority']=='High'?"selected":""; ?> value="High">High</option>
												<option <?php echo $pnb_new_ob['priority']=='Medium'?"selected":""; ?> value="Medium">Medium</option>
												<option <?php echo $pnb_new_ob['priority']=='Low'?"selected":""; ?> value="Low">Low</option>
											</select>
										</td>
										<td>Product related:</td>
										<td><input type="text" name="data[product_related]" class="form-control" value="<?php echo $pnb_new_ob['product_related']; ?>" required></td>
										<td>Process related:</td>
										<td><input type="text" name="data[process_related]" class="form-control" value="<?php echo $pnb_new_ob['process_related']; ?>" required></td>
									</tr>
									<tr style="background-color:#EAFAF1">
										<td>Agent related:</td>
										<td><input type="text" name="data[agent_related]" class="form-control" value="<?php echo $pnb_new_ob['agent_related']; ?>" required></td>
										<td>Needs Escalation:</td>
										<td>
											<select class="form-control" name="data[need_escalation]" required>
												<option value="">-Select-</option>
												<option <?php echo $pnb_new_ob['need_escalation']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option <?php echo $pnb_new_ob['need_escalation']=='No'?"selected":""; ?> value="No">No</option>
											</select>
										</td>
										<td>Call Back Required?:</td>
										<td>
											<select class="form-control" name="data[call_back_required]" required>
												<option value="">-Select-</option>
												<option <?php echo $pnb_new_ob['call_back_required']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option <?php echo $pnb_new_ob['call_back_required']=='No'?"selected":""; ?> value="No">No</option>
											</select>
										</td>
									</tr>
									<tr>
										<td style="font-weight:bold; font-size:16px">Possible Score:</td>
										<td><input type="text" readonly id="paynear_possibleScore" name="data[possible_score]" class="form-control" style="font-weight:bold" value="<?php echo $pnb_new_ob['possible_score'] ?>"></td>
										<td style="font-weight:bold; font-size:16px">Earned Score: </td>
										<td><input type="text" readonly id="paynear_earnedScore" name="data[earned_score]" class="form-control" style="font-weight:bold" value="<?php echo $pnb_new_ob['earned_score'] ?>"></td>
										<td style="font-weight:bold; font-size:16px; text-align:right">Overall Score:</td>
										<td><input type="text" readonly id="pnb_ob_overallScore" name="data[overall_score]" class="form-control pnb_new_obFatal" style="font-weight:bold" value="<?php echo $pnb_new_ob['overall_score'] ?>"></td>
									</tr>
								</tbody>
							</table>
							<table class="table table-striped skt-table">
								<tbody>
									<tr style="background-color:#A9CCE3; font-weight:bold">
										<!-- <td>Criticality</td> -->
										<td >Parameters</td>
										<td>weightage</td>
										<td style="width:150px;">Rating</td>
										<td>Reason</td>
										<td>Remarks</td>
									</tr>
									<tr>
										<td>Standard Call Opening (Greeting With Company Name Right Party Confirmation)</td>
										<td>3</td>
										<td>
										  <select name="data[standard_call_opening]" class="form-control pnb_ob_point" required>
											<option pnb_ob_val=3 pnb_ob_max=3 value="Good" <?php if($pnb_new_ob['standard_call_opening']=="Good") echo "selected"; ?>>Good</option>
											<option pnb_ob_val=1.5 pnb_ob_max=3 value="Needs Improvement" <?php if($pnb_new_ob['standard_call_opening']=="Needs Improvement") echo "selected"; ?>>Needs Improvement</option>
											<option pnb_ob_val=0 pnb_ob_max=3 value="Poor" <?php if($pnb_new_ob['standard_call_opening']=="Poor") echo "selected"; ?>>Poor</option>
											<option pnb_ob_val=0 pnb_ob_max=0 value="N/A" <?php if($pnb_new_ob['standard_call_opening']=="N/A") echo "selected";?>>N/A</option>
										  </select>
									</td>
									<td><input type="text" name="data[sco_reason]" value="<?php echo $pnb_new_ob['sco_reason']?>" class="form-control"/></td>
									<td><input type="text" name="data[remark1]" value="<?php echo $pnb_new_ob['remark1']?>" class="form-control"/></td>
								</tr>
								<tr>
									<td>Appropriate Empathy/Apology Wherever Applicable</td>
									<td>3</td>
									<td>
									  <select name="data[appr_empathy_apology]" class="form-control pnb_ob_point" required>
										<option pnb_ob_val=3 pnb_ob_max=3 value="Good" <?php if($pnb_new_ob['appr_empathy_apology']=="Good") echo "selected"; ?>>Good</option>
										<option pnb_ob_val=1.5 pnb_ob_max=3 value="Needs Improvement" <?php if($pnb_new_ob['appr_empathy_apology']=="Needs Improvement") echo "selected"; ?>>Needs Improvement</option>
										<option pnb_ob_val=0 pnb_ob_max=3 value="Poor" <?php if($pnb_new_ob['appr_empathy_apology']=="Poor") echo "selected"; ?>>Poor</option>
										<option pnb_ob_val=0 pnb_ob_max=0 value="N/A" <?php if($pnb_new_ob['appr_empathy_apology']=="N/A") echo "selected"; ?>>N/A</option>
									  </select>
									</td>
									<td><input type="text" name="data[appr_emp_ap_reason]" value="<?php echo $pnb_new_ob['appr_emp_ap_reason']?>" class="form-control"/></td>
									<td><input type="text" name="data[remark2]" value="<?php echo $pnb_new_ob['remark2']?>" class="form-control"/></td>
								</tr>
								
								<tr>
									<td>Maintained professional Tone/ Assured the retailer wherever applicable</td>
									<td>3</td>
									<td>
									  <select name="data[professional]" class="form-control pnb_ob_point" required>
										<option pnb_ob_val=3 pnb_ob_max=3 value="Good" <?php if($pnb_new_ob['professional']=="Good") echo "selected"; ?>>Good</option>
										<option pnb_ob_val=1.5 pnb_ob_max=3 value="Needs Improvement" <?php if($pnb_new_ob['professional']=="Needs Improvement") echo "selected"; ?>>Needs Improvement</option>
										<option pnb_ob_val=0 pnb_ob_max=3 value="Poor" <?php if($pnb_new_ob['professional']=="Poor") echo "selected"; ?>>Poor</option>
										<option pnb_ob_val=0 pnb_ob_max=0 value="N/A" <?php if($pnb_new_ob['professional']=="N/A") echo "selected"; ?>>N/A</option>
									  </select>
									</td>
									<td><input type="text" name="data[professional_reason]" value="<?php echo $pnb_new_ob['professional_reason']?>" class="form-control"/></td>
									<td><input type="text" name="data[remark3]" value="<?php echo $pnb_new_ob['remark3']?>" class="form-control"/></td>
								</tr>
								<tr>
									<td>Eshtablished connect with the retailer</td>
									<td>8</td>
									<td>
									  <select name="data[connect_retailer]" class="form-control pnb_ob_point" required>
										<option pnb_ob_val=8 pnb_ob_max=8 value="Good" <?php if($pnb_new_ob['connect_retailer']=="Good") echo "selected"; ?>>Good</option>
										<option pnb_ob_val=4 pnb_ob_max=8 value="Needs Improvement" <?php if($pnb_new_ob['connect_retailer']=="Needs Improvement") echo "selected"; ?>>Needs Improvement</option>
										<option pnb_ob_val=0 pnb_ob_max=8 value="Poor" <?php if($pnb_new_ob['connect_retailer']=="Poor") echo "selected"; ?>>Poor</option>
										<option pnb_ob_val=0 pnb_ob_max=0 value="N/A" <?php if($pnb_new_ob['connect_retailer']=="N/A") echo "selected"; ?>>N/A</option>
									  </select>
									</td>
									<td><input type="text" name="data[connect_retailer_reason]" value="<?php echo $pnb_new_ob['connect_retailer_reason']?>" class="form-control"/></td>
									<td><input type="text" name="data[remark4]" value="<?php echo $pnb_new_ob['remark4']?>" class="form-control"/></td>
								</tr>
								
								<tr>
									<td>Rate/Clarity of speech was moderate/No usage of Jargons</td>
									<td>5</td>
									<td>
										<select name="data[clarity_of_speech]" class="form-control pnb_ob_point" required>
											<option pnb_ob_val=5 pnb_ob_max=5 value="Good" <?php if($pnb_new_ob['clarity_of_speech']=="Good") echo "selected"; ?>>Good</option>
											<option pnb_ob_val=2.5 pnb_ob_max=5 value="Needs Improvement" <?php if($pnb_new_ob['clarity_of_speech']=="Needs Improvement") echo "selected"; ?>>Needs Improvement</option>
											<option pnb_ob_val=0 pnb_ob_max=5 value="Poor" <?php if($pnb_new_ob['clarity_of_speech']=="Poor") echo "selected"; ?>>Poor</option>
											<option pnb_ob_val=0 pnb_ob_max=0 value="N/A" <?php if($pnb_new_ob['clarity_of_speech']=="N/A") echo "selected"; ?>>N/A</option>
										  </select>
									</td>
									<td><input type="text" name="data[clarity_of_speech_reason]" value="<?php echo $pnb_new_ob['clarity_of_speech_reason']?>" class="form-control"/></td>
									<td><input type="text" name="data[remark5]" value="<?php echo $pnb_new_ob['remark5']?>" class="form-control"/></td>
								</tr>
								<tr>
									<td>Active Listening</td>
									<td>3</td>
									<td>
										<select name="data[active_listening]" class="form-control pnb_ob_point" required>
											<option pnb_ob_val=3 pnb_ob_max=3 value="Good" <?php if($pnb_new_ob['active_listening']=="Good") echo "selected"; ?>>Good</option>
											<option pnb_ob_val=1.5 pnb_ob_max=3 value="Needs Improvement" <?php if($pnb_new_ob['active_listening']=="Needs Improvement") echo "selected"; ?>>Needs Improvement</option>
											<option pnb_ob_val=0 pnb_ob_max=3 value="Poor" <?php if($pnb_new_ob['active_listening']=="Poor") echo "selected"; ?>>Poor</option>
											<option pnb_ob_val=0 pnb_ob_max=0 value="N/A" <?php if($pnb_new_ob['active_listening']=="N/A") echo "selected"; ?>>N/A</option>
										  </select>
									</td>
									<td><input type="text" name="data[active_listening_reason]" value="<?php echo $pnb_new_ob['active_listening_reason']?>" class="form-control"/></td>
									<td><input type="text" name="data[remark6]" value="<?php echo $pnb_new_ob['remark6']?>" class="form-control"/></td>
								</tr>
								<tr>
									<td>Interruption & Parallel Talking</td>
									<td>3</td>
									<td>
										<select name="data[parallel_talking]" class="form-control pnb_ob_point" required>
											<option pnb_ob_val=3 pnb_ob_max=3 value="Good" <?php if($pnb_new_ob['parallel_talking']=="Good") echo "selected"; ?>>Good</option>
											<option pnb_ob_val=1.5 pnb_ob_max=3 value="Needs Improvement" <?php if($pnb_new_ob['parallel_talking']=="Needs Improvement") echo "selected"; ?>>Needs Improvement</option>
											<option pnb_ob_val=0 pnb_ob_max=3 value="Poor" <?php if($pnb_new_ob['parallel_talking']=="Poor") echo "selected"; ?>>Poor</option>
											<option pnb_ob_val=0 pnb_ob_max=0 value="N/A" <?php if($pnb_new_ob['parallel_talking']=="N/A") echo "selected"; ?>>N/A</option>
										 </select>
									</td>
									
									<td><input type="text" name="data[parallel_talking_reason]" value="<?php echo $pnb_new_ob['parallel_talking_reason']?>" class="form-control"/></td>
									<td><input type="text" name="data[remark7]" value="<?php echo $pnb_new_ob['remark7']?>" class="form-control"/></td>
								</tr>
								<tr>
									<td>Seamless Conversation (No abrupt pause/dead air)</td>
									<td>5</td>
									<td>
										<select name="data[dead_air]" class="form-control pnb_ob_point" required>
											<option pnb_ob_val=5 pnb_ob_max=5 value="Good" <?php if($pnb_new_ob['dead_air']=="Good") echo "selected"; ?>>Good</option>
											<option pnb_ob_val=2.5 pnb_ob_max=5 value="Needs Improvement" <?php if($pnb_new_ob['dead_air']=="Needs Improvement") echo "selected"; ?>>Needs Improvement</option>
											<option pnb_ob_val=0 pnb_ob_max=5 value="Poor" <?php if($pnb_new_ob['dead_air']=="Poor") echo "selected"; ?>>Poor</option>
											<option pnb_ob_val=0 pnb_ob_max=0 value="N/A" <?php if($pnb_new_ob['dead_air']=="N/A") echo "selected"; ?>>N/A</option>
										  </select>
									</td>
									<td><input type="text" name="data[dead_air_reason]" value="<?php echo $pnb_new_ob['dead_air_reason']?>" class="form-control"/></td>
									<td><input type="text" name="data[remark8]" value="<?php echo $pnb_new_ob['remark8']?>" class="form-control"/></td>
								</tr>
								<tr>
									<td>Reason for drop in business figures</td>
									<td>8</td>
									<td>
										<select class="form-control pnb_ob_point" name="data[drop_business]" required>
										<option pnb_ob_val=8 pnb_ob_max=8 value="Good" <?php if($pnb_new_ob['drop_business']=="Good") echo "selected"; ?>>Good</option>
										<option pnb_ob_val=4 pnb_ob_max=8 value="Needs Improvement" <?php if($pnb_new_ob['drop_business']=="Needs Improvement") echo "selected"; ?>>Needs Improvement</option>
										<option pnb_ob_val=0 pnb_ob_max=8 value="Poor" <?php if($pnb_new_ob['drop_business']=="Poor") echo "selected"; ?>>Poor</option>
										<option pnb_ob_val=0 pnb_ob_max=0 value="N/A" <?php if($pnb_new_ob['drop_business']=="N/A") echo "selected"; ?>>N/A</option>
										</select>
									</td>
									<td><input type="text" name="data[drop_business_reason]" value="<?php echo $pnb_new_ob['drop_business_reason']?>" class="form-control"/></td>
									<td><input type="text" name="data[remark9]" value="<?php echo $pnb_new_ob['remark9']?>" class="form-control"/></td>
								</tr>
								
								<tr>
									<td>All required checks done for conversion (System checks)</td>
									<td>8</td>
									<td>
										<select class="form-control pnb_ob_point" name="data[conversion_check]" required>
											<option pnb_ob_val=8 pnb_ob_max=8 value="Good" <?php if($pnb_new_ob['conversion_check']=="Good") echo "selected"; ?>>Good</option>
											<option pnb_ob_val=4 pnb_ob_max=8 value="Needs Improvement" <?php if($pnb_new_ob['conversion_check']=="Needs Improvement") echo "selected"; ?>>Needs Improvement</option>
											<option pnb_ob_val=0 pnb_ob_max=8 value="Poor" <?php if($pnb_new_ob['conversion_check']=="Poor") echo "selected"; ?>>Poor</option>
											<option pnb_ob_val=0 pnb_ob_max=0 value="N/A" <?php if($pnb_new_ob['conversion_check']=="N/A") echo "selected"; ?>>N/A</option>
										</select>
									</td>
									<td><input type="text" name="data[conversion_check_reason]" value="<?php echo $pnb_new_ob['conversion_check_reason']?>" class="form-control"/></td>
									<td><input type="text" name="data[remark10]" value="<?php echo $pnb_new_ob['remark10']?>" class="form-control"/></td>
								</tr>
								<tr>
									<td style="color:red;">Agent Shared The Correct/Complete Information</td>
									<td>10</td>
									<td>
										<select class="form-control pnb_ob_point pnb_ob_fatal" name="data[complete_information]" required>
											<option pnb_ob_val=10 pnb_ob_max=10 value="Good" <?php if($pnb_new_ob['complete_information']=="Good") echo "selected"; ?>>Good</option>
											<option pnb_ob_val=0 pnb_ob_max=10 value="Fatal" <?php if($pnb_new_ob['complete_information']=="Fatal") echo "selected"; ?>>Fatal</option>
										</select>
									</td>
									<td><input type="text" name="data[complete_information_reason]" value="<?php echo $pnb_new_ob['complete_information_reason']?>" class="form-control"/></td>
									<td><input type="text" name="data[remark11]" value="<?php echo $pnb_new_ob['remark11']?>" class="form-control"/></td>
								</tr>
								<tr>
									<td>Business opportunity was explored and explained</td>
									<td>8</td>
									<td>
										<select class="form-control pnb_ob_point" name="data[business_opportunity]" required>
											<option pnb_ob_val=8 pnb_ob_max=8 value="Good" <?php if($pnb_new_ob['business_opportunity']=="Good") echo "selected"; ?>>Good</option>
											<option pnb_ob_val=4 pnb_ob_max=8 value="Needs Improvement" <?php if($pnb_new_ob['business_opportunity']=="Needs Improvement") echo "selected"; ?>>Needs Improvement</option>
											<option pnb_ob_val=0 pnb_ob_max=8 value="Poor" <?php if($pnb_new_ob['business_opportunity']=="Poor") echo "selected"; ?>>Poor</option>
											<option pnb_ob_val=0 pnb_ob_max=0 value="N/A" <?php if($pnb_new_ob['business_opportunity']=="N/A") echo "selected"; ?>>N/A</option>
										</select>
									</td>
									<td><input type="text" name="data[business_opportunity_reason]" value="<?php echo $pnb_new_ob['business_opportunity_reason']?>" class="form-control"/></td>
									<td><input type="text" name="data[remark12]" value="<?php echo $pnb_new_ob['remark12']?>" class="form-control"/></td>
								</tr>
								<tr>
									<td>CRM/Convox Remarks were captured properly</td>
									<td>5</td>
									<td>
										<select class="form-control pnb_ob_point" name="data[crm]" required>
											<option pnb_ob_val=5 pnb_ob_max=5 value="Good" <?php if($pnb_new_ob['crm']=="Good") echo "selected"; ?>>Good</option>
											<option pnb_ob_val=2.5 pnb_ob_max=5 value="Needs Improvement" <?php if($pnb_new_ob['crm']=="Needs Improvement") echo "selected"; ?>>Needs Improvement</option>
											<option pnb_ob_val=0 pnb_ob_max=5 value="Poor" <?php if($pnb_new_ob['crm']=="Poor") echo "selected"; ?>>Poor</option>
											<option pnb_ob_val=0 pnb_ob_max=0 value="N/A" <?php if($pnb_new_ob['crm']=="N/A") echo "selected"; ?>>N/A</option>
										</select>
									</td>
									<td><input type="text" name="data[crm_reason]" value="<?php echo $pnb_new_ob['crm_reason']?>" class="form-control"/></td>
									<td><input type="text" name="data[remark13]" value="<?php echo $pnb_new_ob['remark13']?>" class="form-control"/></td>
								</tr>
								<tr>
									<td style="color:red;">Actioning in System, Need to follow up ( For Complaint / Issue which escalated to concern Team)</td>
									<td>8</td>
									<td>
										<select class="form-control pnb_ob_point pnb_ob_fatal" name="data[actioning_in_system]" required>
											<option pnb_ob_val=8 pnb_ob_max=8 value="Good" <?php if($pnb_new_ob['actioning_in_system']=="Good") echo "selected"; ?>>Good</option>
											<option pnb_ob_val=0 pnb_ob_max=8 value="Fatal" <?php if($pnb_new_ob['actioning_in_system']=="Fatal") echo "selected"; ?>>Fatal</option>
										</select>
									</td>
									<td><input type="text" name="data[actioning_in_system_reason]" value="<?php echo $pnb_new_ob['actioning_in_system_reason']?>" class="form-control"/></td>
									<td><input type="text" name="data[remark14]" value="<?php echo $pnb_new_ob['remark14']?>" class="form-control"/></td>
								</tr>
								<tr>
									<td>Summarization of Call</td>
									<td>5</td>
									<td>
										<select class="form-control pnb_ob_point" name="data[summarization_of_call]" required>
											<option pnb_ob_val=5 pnb_ob_max=5 value="Good" <?php if($pnb_new_ob['summarization_of_call']=="Good") echo "selected"; ?>>Good</option>
											<option pnb_ob_val=2.5 pnb_ob_max=5 value="Needs Improvement" <?php if($pnb_new_ob['summarization_of_call']=="Needs Improvement") echo "selected"; ?>>Needs Improvement</option>
											<option pnb_ob_val=0 pnb_ob_max=5 value="Poor" <?php if($pnb_new_ob['summarization_of_call']=="Poor") echo "selected"; ?>>Poor</option>
											<option pnb_ob_val=0 pnb_ob_max=0 value="N/A" <?php if($pnb_new_ob['summarization_of_call']=="N/A") echo "selected"; ?>>N/A</option>
										</select>
									</td>
									<td><input type="text" name="data[summarization_of_call_reason]" value="<?php echo $pnb_new_ob['summarization_of_call_reason']?>" class="form-control"/></td>
									<td><input type="text" name="data[remark15]" value="<?php echo $pnb_new_ob['remark15']?>" class="form-control"/></td>
								</tr>
								<tr>
									<td>Closing of call</td>
									<td>3</td>
									<td>
										<select class="form-control pnb_ob_point" name="data[closing_call]" required>
											<option pnb_ob_val=3 pnb_ob_max=3 value="Good" <?php if($pnb_new_ob['closing_call']=="Good") echo "selected"; ?>>Good</option>
											<option pnb_ob_val=1.5 pnb_ob_max=3 value="Needs Improvement" <?php if($pnb_new_ob['closing_call']=="Needs Improvement") echo "selected"; ?>>Needs Improvement</option>
											<option pnb_ob_val=0 pnb_ob_max=3 value="Poor" <?php if($pnb_new_ob['closing_call']=="Poor") echo "selected"; ?>>Poor</option>
											<option pnb_ob_val=0 pnb_ob_max=0 value="N/A" <?php if($pnb_new_ob['closing_call']=="N/A") echo "selected"; ?>>N/A</option>
										</select>
									</td>
									<td><input type="text" name="data[closing_call_reason]" value="<?php echo $pnb_new_ob['closing_call_reason']?>" class="form-control"/></td>
									<td><input type="text" name="data[remark16]" value="<?php echo $pnb_new_ob['remark16']?>" class="form-control"/></td>
								</tr>
								<tr>
									<td style="color:red;">Tagging & Disposition in Convox</td>
									<td>8</td>
									<td>
										<select class="form-control pnb_ob_point pnb_ob_fatal" name="data[tagging_disposition]" required>
											<option pnb_ob_val=8 pnb_ob_max=8 value="Good" <?php if($pnb_new_ob['tagging_disposition']=="Good") echo "selected"; ?>>Good</option>
											<option pnb_ob_val=0 pnb_ob_max=8 value="Fatal" <?php if($pnb_new_ob['tagging_disposition']=="Fatal") echo "selected"; ?>>Fatal</option>
										</select>
									</td>
									<td><input type="text" name="data[tagging_disposition_reason]" value="<?php echo $pnb_new_ob['tagging_disposition_reason']?>" class="form-control"/></td>
									<td><input type="text" name="data[remark17]" value="<?php echo $pnb_new_ob['remark17']?>" class="form-control"/></td>
								</tr>
								<tr>
									<td style="color:red;">ZTP</td>
									<td>4</td>
									<td>
										<select class="form-control pnb_ob_point pnb_ob_fatal" name="data[ztp]" required>
											<option pnb_ob_val=4 pnb_ob_max=4 value="Good" <?php if($pnb_new_ob['ztp']=="Good") echo "selected"; ?>>Good</option>
											<option pnb_ob_val=0 pnb_ob_max=4 value="Fatal" <?php if($pnb_new_ob['ztp']=="Fatal") echo "selected"; ?>>Fatal</option>
										</select>
									</td>
									<td><input type="text" name="data[ztp_reason]" value="<?php echo $pnb_new_ob['ztp_reason']?>" class="form-control"/></td>
									<td><input type="text" name="data[remark18]" value="<?php echo $pnb_new_ob['remark18']?>" class="form-control"/></td>
								</tr>
								
								<tr>
									<td>Call Summary:</td>
									<td colspan="6"><textarea class="form-control" name="data[call_summary]"><?php echo $pnb_new_ob['call_summary'] ?></textarea></td>
									</tr>
								
								<tr>
									<td>Feedback:</td>
									<td colspan="6"><textarea class="form-control" name="data[feedback]"><?php echo $pnb_new_ob['feedback'] ?></textarea></td>
								</tr>
								<tr>
									<td >Upload Files (wav,wmv,mp3,mp4)</td>
									<?php if($pnboutbound_id==0){ ?>
										<td colspan=6 class="new-file"><input type="file" multiple class="form-control audioFile" id="fileuploadbasic" name="attach_file[]" ></td>
									<?php }else{ ?>
										<td colspan=><input type="file" multiple class="form-control audioFile" name="attach_file[]" ></td>
										<td colspan=>
											<?php if($pnb_new_ob['attach_file']!=''){
												$attach_file = explode(",",$pnb_new_ob['attach_file']);
												 foreach($attach_file as $mp){ ?>
													<audio controls='' style="background-color:#607F93"> 
													  <source src="<?php echo base_url(); ?>qa_files/pnb_new_ob/<?php echo $mp; ?>" type="audio/ogg">
													  <source src="<?php echo base_url(); ?>qa_files/pnb_new_ob/<?php echo $mp; ?>" type="audio/mpeg">
													</audio> </br>
												 <?php }  
											}?>
										</td>
									<?php } ?>
								</tr>
								
									
									<?php if($pnboutbound_id!=0){ ?>
										<tr><td colspan=2 style="font-size:16px; font-weight:bold">Agent Feedback Acceptance:</td><td colspan=6><?php echo $pnb_new_ob['agnt_fd_acpt'] ?></td></tr>
										<tr><td colspan=2 style="font-size:16px; font-weightbold">Agent Review:</td><td colspan=6><?php echo $pnb_new_ob['agent_rvw_note'] ?></td></tr>
										<tr><td colspan=2 style="font-size:16px; font-weight:bold">Management Review:</td><td colspan=6><?php echo $pnb_new_ob['mgnt_rvw_note'] ?></td></tr>
										<tr><td colspan=2 style="font-size:16px; font-weight:bold">Client Review:</td><td colspan=6><?php echo $pnb_new_ob['client_rvw_note'] ?></td></tr>

										<tr><td colspan=2  style="font-size:16px">Your Review</td><td colspan=6><textarea class="form-control1" style="width:100%" id="note" name="note" required></textarea></td></tr>
									<?php } ?>


									<?php
									if($pnboutbound_id==0){
										if(is_access_qa_module()==true || is_access_qa_operations_module()==true){ ?>
											<tr><td colspan=6><button class="btn btn-success waves-effect new-btn" type="submit" id="qaformsubmit">SAVE</button></td></tr>
									<?php
										}
									}else{
										if(is_access_qa_module()==true || is_access_qa_operations_module()==true){
											if(is_available_qa_feedback($pnb_new_ob['entry_date'],72) == true){ ?>
												<tr><td colspan="6"><button class="btn btn-success waves-effect new-btn" type="submit" id='qaformsubmit' name='btnSave' value="SAVE" style="width:500px">SAVE</button></td></tr>
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
$(document).ready(function(){
	
	$('.audioFile').change(function () {
		var ext = this.value.match(/\.(.+)$/)[1];switch (ext) {
			case 'wav':
			case 'wmv':
			case 'mp3':
			case 'mp4':
				$('#uploadButton').attr('disabled', false);
				break;
			default:
				alert('This is not an allowed file type.');
				this.value = '';
		}
	});
	
});	
</script>