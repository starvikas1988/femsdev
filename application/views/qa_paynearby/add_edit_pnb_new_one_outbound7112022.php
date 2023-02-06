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
										<td colspan="6" id="theader" style="font-size:40px">PNB OUTBOUND</td>
										<input type="hidden" name="audit_start_time" value="<?php echo CurrMySqlDate(); ?>">
									</tr>
									<?php
										if($pnboutbound_id==0){
											$auditorName = get_username();
											$auditDate = CurrDateMDY();
											$clDate_val='';
											//$go_live_date='';
										}else{
											if($pnboutbound_new['entry_by']!=''){
												$auditorName = $pnboutbound_new['auditor_name'];
											}else{
												$auditorName = $pnboutbound_new['client_name'];
											}
											$auditDate = mysql2mmddyy($pnboutbound_new['audit_date']);
											$clDate_val = mysql2mmddyy($pnboutbound_new['call_date']);
											//$go_live_date = mysql2mmddyy($pnboutbound_new['go_live_date']);
										}
									?>
									<tr>
										<td style="width:150px">Auditor Name:</td>
										<td style="width:300px"><input type="text" class="form-control" value="<?php echo $auditorName; ?>" disabled></td>
										<td>Audit Date:</td>
										<td style="width:250px"><input type="text" class="form-control" value="<?php echo $auditDate; ?>" disabled></td>
										<td>Call Date:</td>
										<td><input type="text" class="form-control" id="call_date" name="call_date" value="<?php echo $clDate_val; ?>" required ></td>
									</tr>
									<tr>
										<td>Agent:</td>
										<td>
											<select class="form-control agentName" id="agent_id" name="data[agent_id]" required>
												<option value="<?php echo $pnboutbound_new['agent_id'] ?>"><?php echo $pnboutbound_new['fname']." ".$pnboutbound_new['lname'] ?></option>
												<option value="">-Select-</option>
												<?php foreach($agentName as $row):  ?>
													<option value="<?php echo $row['id']; ?>"><?php echo $row['name'].' ('.$row['fusion_id'].')'; ?></option>
												<?php endforeach; ?>
											</select>
										</td>
										<td>Fusion ID:</td>
										<td><input type="text" readonly class="form-control" id="fusion_id" name="" value="<?php echo $pnboutbound_new['fusion_id'] ?>"></td>
										<td>L1 Supervisor:</td>
										<td>
											<select class="form-control" id="tl_id" name="data[tl_id]" readonly>
												<option value="<?php echo $pnboutbound_new['tl_id'] ?>"><?php echo $pnboutbound_new['tl_name'] ?></option>
												<option value="">--Select--</option>
												<?php foreach($tlname as $tl): ?>
													<option value="<?php echo $tl['id']; ?>"><?php echo $tl['fname']." ".$tl['lname']; ?></option>
												<?php endforeach; ?>
											</select>
										</td>
									</tr>
									<tr>
										<td>Campaign:</td>
										<td><input type="text" readonly class="form-control" id="campaign" name="data[campaign]" value="<?php echo $pnboutbound_new['campaign'] ?>"></td>
										<td>Call Duration:</td>
										<td><input type="text" class="form-control" id="call_duration" name="data[call_duration]" value="<?php echo $pnboutbound_new['call_duration'] ?>" required></td>
										<td>Incoming No.:</td>
										<td><input type="text" class="form-control" id="incoming_no" name="data[incoming_no]" value="<?php echo $pnboutbound_new['incoming_no'] ?>" onkeyup="checkDec(this);" required></td>
									</tr>
									<tr>
										<td>Register No.:</td>
										<td><input type="text" class="form-control" id="register_no" name="data[register_no]" value="<?php echo $pnboutbound_new['register_no'] ?>" required></td>
										<td>Customer Name:</td>
										<td><input type="text" class="form-control" id="customer" name="data[customer]" value="<?php echo $pnboutbound_new['customer'] ?>" required></td>
										<td>Call Link:</td>
										<td><input type="text" class="form-control" id="call_link" name="data[call_link]" value="<?php echo $pnboutbound_new['call_link'] ?>" required></td>
									</tr>
									<tr>
										<td>Ticket No.:</td>
										<td><input type="text" class="form-control" id="ticket_no" name="data[ticket_no]" value="<?php echo $pnboutbound_new['ticket_no'] ?>" required></td>
										<td>Call Disconnect By:</td>
										<td><input type="text" class="form-control" id="call_disconnect_by" name="data[call_disconnect_by]" value="<?php echo $pnboutbound_new['call_disconnect_by'] ?>"  required></td>
										<td>Tagging/Disposition:</td>
										<td>
											<input type="text" class="form-control" id="" name="data[tagging]" value="<?php echo $pnboutbound_new['tagging'] ?>" required>
										</td>
									</tr>
									<tr>
										<td>Query/Service:</td>
										<td><input type="text" value="<?php echo $pnboutbound_new['query_service']?>" class="form-control" id="query_service" name="data[query_service]" required></td>
										<td>Type of Call:</td>
										<td><input type="text" class="form-control" id="call_type" name="data[call_type]" value="<?php echo $pnboutbound_new['call_type'] ?>" required></td>
									</tr>
									<tr>
										<td>Audit Type:</td>
										<td>
											<select class="form-control" id="audit_type" name="data[audit_type]" required>
												<option value="<?php echo $pnboutbound_new['audit_type'] ?>"><?php echo $pnboutbound_new['audit_type'] ?></option>
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
												<option value="<?php echo $pnboutbound_new['auditor_type'] ?>"><?php echo $pnboutbound_new['auditor_type'] ?></option>
												<option value="">-Select-</option>
												<option value="Master">Master</option>
												<option value="Regular">Regular</option>
											</select>
										</td>
										<td>VOC:</td>
										<td>
											<select class="form-control" id="voc" name="data[voc]" required>
												<option value="<?php echo $pnboutbound_new['voc'] ?>"><?php echo $pnboutbound_new['voc'] ?></option>
												<option value="">-Select-</option>
												<option value="1">1</option>
												<option value="2">2</option>
												<option value="3">3</option>
												<option value="4">4</option>
												<option value="5">5</option>
											</select>
										</td>
									</tr>
									<tr>
										<td style="font-weight:bold; font-size:16px">Possible Score:</td>
										<td><input type="text" readonly id="paynear_possibleScore" name="data[possible_score]" class="form-control" style="font-weight:bold" value="<?php echo $pnboutbound_new['possible_score'] ?>"></td>
										<td style="font-weight:bold; font-size:16px">Earned Score: </td>
										<td><input type="text" readonly id="paynear_earnedScore" name="data[earned_score]" class="form-control" style="font-weight:bold" value="<?php echo $pnboutbound_new['earned_score'] ?>"></td>
										<td style="font-weight:bold; font-size:16px; text-align:right">Overall Score:</td>
										<td><input type="text" readonly id="pnb_ob_overallScore" name="data[overall_score]" class="form-control pnboutboundFatal" style="font-weight:bold" value="<?php echo $pnboutbound_new['overall_score'] ?>"></td>
									</tr>
								</tbody>
							</table>
							<table class="table table-striped skt-table">
								<tbody>
									<tr style="background-color:#A9CCE3; font-weight:bold">
										<!-- <td>Criticality</td> -->
										<td>Parameters</td>
										<td>weightage</td>
										<td>Rating</td>
										<td>Reason</td>
										<td>Remarks</td>
									</tr>
									<tr>
										<td>Standard Call Opening (Greeting With Company Name Right Party Confirmation)</td>
										<td>3</td>
										<td>
										  <select name="data[standard_call_opening]" class="form-control pnb_ob_point" required>
											<option pnb_ob_val=3 pnb_ob_max=3 value="Good" <?php if($pnboutbound_new['standard_call_opening']=="Good") echo "selected"; ?>>Good</option>
											<option pnb_ob_val=1.5 pnb_ob_max=3 value="Needs Improvement" <?php if($pnboutbound_new['standard_call_opening']=="Needs Improvement") echo "selected"; ?>>Needs Improvement</option>
											<option pnb_ob_val=0 pnb_ob_max=3 value="Poor" <?php if($pnboutbound_new['standard_call_opening']=="Poor") echo "selected"; ?>>Poor</option>
											<option pnb_ob_val=0 pnb_ob_max=0 value="N/A" <?php if($pnboutbound_new['standard_call_opening']=="N/A") echo "selected";?>>N/A</option>
										  </select>
									</td>
									<td><input type="text" name="data[sco_reason]" value="<?php echo $pnboutbound_new['sco_reason']?>" class="form-control"/></td>
									<td><input type="text" name="data[remark1]" value="<?php echo $pnboutbound_new['remark1']?>" class="form-control"/></td>
								</tr>
								<tr>
									<td>Appropriate Empathy/Apology Wherever Applicable</td>
									<td>3</td>
									<td>
									  <select name="data[appr_empathy_apology]" class="form-control pnb_ob_point" required>
										<option pnb_ob_val=3 pnb_ob_max=3 value="Good" <?php if($pnboutbound_new['appr_empathy_apology']=="Good") echo "selected"; ?>>Good</option>
										<option pnb_ob_val=1.5 pnb_ob_max=3 value="Needs Improvement" <?php if($pnboutbound_new['appr_empathy_apology']=="Needs Improvement") echo "selected"; ?>>Needs Improvement</option>
										<option pnb_ob_val=0 pnb_ob_max=3 value="Poor" <?php if($pnboutbound_new['appr_empathy_apology']=="Poor") echo "selected"; ?>>Poor</option>
										<option pnb_ob_val=0 pnb_ob_max=0 value="N/A" <?php if($pnboutbound_new['appr_empathy_apology']=="N/A") echo "selected"; ?>>N/A</option>
									  </select>
									</td>
									<td><input type="text" name="data[appr_emp_ap_reason]" value="<?php echo $pnboutbound_new['appr_emp_ap_reason']?>" class="form-control"/></td>
									<td><input type="text" name="data[remark2]" value="<?php echo $pnboutbound_new['remark2']?>" class="form-control"/></td>
								</tr>
								
								<tr>
									<td>Maintained professional Tone/ Assured the retailer wherever applicable</td>
									<td>3</td>
									<td>
									  <select name="data[professional]" class="form-control pnb_ob_point" required>
										<option pnb_ob_val=3 pnb_ob_max=3 value="Good" <?php if($pnboutbound_new['professional']=="Good") echo "selected"; ?>>Good</option>
										<option pnb_ob_val=1.5 pnb_ob_max=3 value="Needs Improvement" <?php if($pnboutbound_new['professional']=="Needs Improvement") echo "selected"; ?>>Needs Improvement</option>
										<option pnb_ob_val=0 pnb_ob_max=3 value="Poor" <?php if($pnboutbound_new['professional']=="Poor") echo "selected"; ?>>Poor</option>
										<option pnb_ob_val=0 pnb_ob_max=0 value="N/A" <?php if($pnboutbound_new['professional']=="N/A") echo "selected"; ?>>N/A</option>
									  </select>
									</td>
									<td><input type="text" name="data[professional_reason]" value="<?php echo $pnboutbound_new['professional_reason']?>" class="form-control"/></td>
									<td><input type="text" name="data[remark3]" value="<?php echo $pnboutbound_new['remark3']?>" class="form-control"/></td>
								</tr>
								<tr>
									<td>Eshtablished connect with the retailer</td>
									<td>8</td>
									<td>
									  <select name="data[connect_retailer]" class="form-control pnb_ob_point" required>
										<option pnb_ob_val=8 pnb_ob_max=8 value="Good" <?php if($pnboutbound_new['connect_retailer']=="Good") echo "selected"; ?>>Good</option>
										<option pnb_ob_val=4 pnb_ob_max=8 value="Needs Improvement" <?php if($pnboutbound_new['connect_retailer']=="Needs Improvement") echo "selected"; ?>>Needs Improvement</option>
										<option pnb_ob_val=0 pnb_ob_max=8 value="Poor" <?php if($pnboutbound_new['connect_retailer']=="Poor") echo "selected"; ?>>Poor</option>
										<option pnb_ob_val=0 pnb_ob_max=0 value="N/A" <?php if($pnboutbound_new['connect_retailer']=="N/A") echo "selected"; ?>>N/A</option>
									  </select>
									</td>
									<td><input type="text" name="data[connect_retailer_reason]" value="<?php echo $pnboutbound_new['connect_retailer_reason']?>" class="form-control"/></td>
									<td><input type="text" name="data[remark4]" value="<?php echo $pnboutbound_new['remark4']?>" class="form-control"/></td>
								</tr>
								
								<tr>
									<td>Rate/Clarity of speech was moderate/No usage of Jargons</td>
									<td>5</td>
									<td>
										<select name="data[clarity_of_speech]" class="form-control pnb_ob_point" required>
											<option pnb_ob_val=5 pnb_ob_max=5 value="Good" <?php if($pnboutbound_new['clarity_of_speech']=="Good") echo "selected"; ?>>Good</option>
											<option pnb_ob_val=2.5 pnb_ob_max=5 value="Needs Improvement" <?php if($pnboutbound_new['clarity_of_speech']=="Needs Improvement") echo "selected"; ?>>Needs Improvement</option>
											<option pnb_ob_val=0 pnb_ob_max=5 value="Poor" <?php if($pnboutbound_new['clarity_of_speech']=="Poor") echo "selected"; ?>>Poor</option>
											<option pnb_ob_val=0 pnb_ob_max=0 value="N/A" <?php if($pnboutbound_new['clarity_of_speech']=="N/A") echo "selected"; ?>>N/A</option>
										  </select>
									</td>
									<td><input type="text" name="data[clarity_of_speech_reason]" value="<?php echo $pnboutbound_new['clarity_of_speech_reason']?>" class="form-control"/></td>
									<td><input type="text" name="data[remark5]" value="<?php echo $pnboutbound_new['remark5']?>" class="form-control"/></td>
								</tr>
								<tr>
									<td>Active Listening</td>
									<td>3</td>
									<td>
										<select name="data[active_listening]" class="form-control pnb_ob_point" required>
											<option pnb_ob_val=3 pnb_ob_max=3 value="Good" <?php if($pnboutbound_new['active_listening']=="Good") echo "selected"; ?>>Good</option>
											<option pnb_ob_val=1.5 pnb_ob_max=3 value="Needs Improvement" <?php if($pnboutbound_new['active_listening']=="Needs Improvement") echo "selected"; ?>>Needs Improvement</option>
											<option pnb_ob_val=0 pnb_ob_max=3 value="Poor" <?php if($pnboutbound_new['active_listening']=="Poor") echo "selected"; ?>>Poor</option>
											<option pnb_ob_val=0 pnb_ob_max=0 value="N/A" <?php if($pnboutbound_new['active_listening']=="N/A") echo "selected"; ?>>N/A</option>
										  </select>
									</td>
									<td><input type="text" name="data[active_listening_reason]" value="<?php echo $pnboutbound_new['active_listening_reason']?>" class="form-control"/></td>
									<td><input type="text" name="data[remark6]" value="<?php echo $pnboutbound_new['remark6']?>" class="form-control"/></td>
								</tr>
								<tr>
									<td>Interruption & Parallel Talking</td>
									<td>3</td>
									<td>
										<select name="data[parallel_talking]" class="form-control pnb_ob_point" required>
											<option pnb_ob_val=3 pnb_ob_max=3 value="Good" <?php if($pnboutbound_new['parallel_talking']=="Good") echo "selected"; ?>>Good</option>
											<option pnb_ob_val=1.5 pnb_ob_max=3 value="Needs Improvement" <?php if($pnboutbound_new['parallel_talking']=="Needs Improvement") echo "selected"; ?>>Needs Improvement</option>
											<option pnb_ob_val=0 pnb_ob_max=3 value="Poor" <?php if($pnboutbound_new['parallel_talking']=="Poor") echo "selected"; ?>>Poor</option>
											<option pnb_ob_val=0 pnb_ob_max=0 value="N/A" <?php if($pnboutbound_new['parallel_talking']=="N/A") echo "selected"; ?>>N/A</option>
										 </select>
									</td>
									
									<td><input type="text" name="data[parallel_talking_reason]" value="<?php echo $pnboutbound_new['parallel_talking_reason']?>" class="form-control"/></td>
									<td><input type="text" name="data[remark7]" value="<?php echo $pnboutbound_new['remark7']?>" class="form-control"/></td>
								</tr>
								<tr>
									<td>Seamless Conversation (No abrupt pause/dead air)</td>
									<td>5</td>
									<td>
										<select name="data[dead_air]" class="form-control pnb_ob_point" required>
											<option pnb_ob_val=5 pnb_ob_max=5 value="Good" <?php if($pnboutbound_new['dead_air']=="Good") echo "selected"; ?>>Good</option>
											<option pnb_ob_val=2.5 pnb_ob_max=5 value="Needs Improvement" <?php if($pnboutbound_new['dead_air']=="Needs Improvement") echo "selected"; ?>>Needs Improvement</option>
											<option pnb_ob_val=0 pnb_ob_max=5 value="Poor" <?php if($pnboutbound_new['dead_air']=="Poor") echo "selected"; ?>>Poor</option>
											<option pnb_ob_val=0 pnb_ob_max=0 value="N/A" <?php if($pnboutbound_new['dead_air']=="N/A") echo "selected"; ?>>N/A</option>
										  </select>
									</td>
									<td><input type="text" name="data[dead_air_reason]" value="<?php echo $pnboutbound_new['dead_air_reason']?>" class="form-control"/></td>
									<td><input type="text" name="data[remark8]" value="<?php echo $pnboutbound_new['remark8']?>" class="form-control"/></td>
								</tr>
								<tr>
									<td>Reason for drop in business figures</td>
									<td>8</td>
									<td>
										<select class="form-control pnb_ob_point" name="data[drop_business]" required>
										<option pnb_ob_val=8 pnb_ob_max=8 value="Good" <?php if($pnboutbound_new['drop_business']=="Good") echo "selected"; ?>>Good</option>
										<option pnb_ob_val=4 pnb_ob_max=8 value="Needs Improvement" <?php if($pnboutbound_new['drop_business']=="Needs Improvement") echo "selected"; ?>>Needs Improvement</option>
										<option pnb_ob_val=0 pnb_ob_max=8 value="Poor" <?php if($pnboutbound_new['drop_business']=="Poor") echo "selected"; ?>>Poor</option>
										<option pnb_ob_val=0 pnb_ob_max=0 value="N/A" <?php if($pnboutbound_new['drop_business']=="N/A") echo "selected"; ?>>N/A</option>
										</select>
									</td>
									<td><input type="text" name="data[drop_business_reason]" value="<?php echo $pnboutbound_new['drop_business_reason']?>" class="form-control"/></td>
									<td><input type="text" name="data[remark9]" value="<?php echo $pnboutbound_new['remark9']?>" class="form-control"/></td>
								</tr>
								
								<tr>
									<td>All required checks done for conversion (System checks)</td>
									<td>8</td>
									<td>
										<select class="form-control pnb_ob_point" name="data[conversion_check]" required>
											<option pnb_ob_val=8 pnb_ob_max=8 value="Good" <?php if($pnboutbound_new['conversion_check']=="Good") echo "selected"; ?>>Good</option>
											<option pnb_ob_val=4 pnb_ob_max=8 value="Needs Improvement" <?php if($pnboutbound_new['conversion_check']=="Needs Improvement") echo "selected"; ?>>Needs Improvement</option>
											<option pnb_ob_val=0 pnb_ob_max=8 value="Poor" <?php if($pnboutbound_new['conversion_check']=="Poor") echo "selected"; ?>>Poor</option>
											<option pnb_ob_val=0 pnb_ob_max=0 value="N/A" <?php if($pnboutbound_new['conversion_check']=="N/A") echo "selected"; ?>>N/A</option>
										</select>
									</td>
									<td><input type="text" name="data[conversion_check_reason]" value="<?php echo $pnboutbound_new['conversion_check_reason']?>" class="form-control"/></td>
									<td><input type="text" name="data[remark10]" value="<?php echo $pnboutbound_new['remark10']?>" class="form-control"/></td>
								</tr>
								<tr>
									<td style="color:red;">Agent Shared The Correct/Complete Information</td>
									<td>10</td>
									<td>
										<select class="form-control pnb_ob_point pnb_ob_fatal" name="data[complete_information]" required>
											<option pnb_ob_val=10 pnb_ob_max=10 value="Good" <?php if($pnboutbound_new['complete_information']=="Good") echo "selected"; ?>>Good</option>
											<option pnb_ob_val=0 pnb_ob_max=10 value="Fatal" <?php if($pnboutbound_new['complete_information']=="Fatal") echo "selected"; ?>>Fatal</option>
										</select>
									</td>
									<td><input type="text" name="data[complete_information_reason]" value="<?php echo $pnboutbound_new['complete_information_reason']?>" class="form-control"/></td>
									<td><input type="text" name="data[remark11]" value="<?php echo $pnboutbound_new['remark11']?>" class="form-control"/></td>
								</tr>
								<tr>
									<td>Business opportunity was explored and explained</td>
									<td>8</td>
									<td>
										<select class="form-control pnb_ob_point" name="data[business_opportunity]" required>
											<option pnb_ob_val=8 pnb_ob_max=8 value="Good" <?php if($pnboutbound_new['business_opportunity']=="Good") echo "selected"; ?>>Good</option>
											<option pnb_ob_val=4 pnb_ob_max=8 value="Needs Improvement" <?php if($pnboutbound_new['business_opportunity']=="Needs Improvement") echo "selected"; ?>>Needs Improvement</option>
											<option pnb_ob_val=0 pnb_ob_max=8 value="Poor" <?php if($pnboutbound_new['business_opportunity']=="Poor") echo "selected"; ?>>Poor</option>
											<option pnb_ob_val=0 pnb_ob_max=0 value="N/A" <?php if($pnboutbound_new['business_opportunity']=="N/A") echo "selected"; ?>>N/A</option>
										</select>
									</td>
									<td><input type="text" name="data[business_opportunity_reason]" value="<?php echo $pnboutbound_new['business_opportunity_reason']?>" class="form-control"/></td>
									<td><input type="text" name="data[remark12]" value="<?php echo $pnboutbound_new['remark12']?>" class="form-control"/></td>
								</tr>
								<tr>
									<td>CRM/Convox Remarks were captured properly</td>
									<td>5</td>
									<td>
										<select class="form-control pnb_ob_point" name="data[crm]" required>
											<option pnb_ob_val=5 pnb_ob_max=5 value="Good" <?php if($pnboutbound_new['crm']=="Good") echo "selected"; ?>>Good</option>
											<option pnb_ob_val=2.5 pnb_ob_max=5 value="Needs Improvement" <?php if($pnboutbound_new['crm']=="Needs Improvement") echo "selected"; ?>>Needs Improvement</option>
											<option pnb_ob_val=0 pnb_ob_max=5 value="Poor" <?php if($pnboutbound_new['crm']=="Poor") echo "selected"; ?>>Poor</option>
											<option pnb_ob_val=0 pnb_ob_max=0 value="N/A" <?php if($pnboutbound_new['crm']=="N/A") echo "selected"; ?>>N/A</option>
										</select>
									</td>
									<td><input type="text" name="data[crm_reason]" value="<?php echo $pnboutbound_new['crm_reason']?>" class="form-control"/></td>
									<td><input type="text" name="data[remark13]" value="<?php echo $pnboutbound_new['remark13']?>" class="form-control"/></td>
								</tr>
								<tr>
									<td>Actioning in System, Need to follow up ( For Complaint / Issue which escalated to concern Team)</td>
									<td>8</td>
									<td>
										<select class="form-control pnb_ob_point" name="data[actioning_in_system]" required>
											<option pnb_ob_val=8 pnb_ob_max=8 value="Good" <?php if($pnboutbound_new['actioning_in_system']=="Good") echo "selected"; ?>>Good</option>
											<option pnb_ob_val=4 pnb_ob_max=8 value="Needs Improvement" <?php if($pnboutbound_new['actioning_in_system']=="Needs Improvement") echo "selected"; ?>>Needs Improvement</option>
											<option pnb_ob_val=0 pnb_ob_max=8 value="Poor" <?php if($pnboutbound_new['actioning_in_system']=="Poor") echo "selected"; ?>>Poor</option>
											<option pnb_ob_val=0 pnb_ob_max=0 value="N/A" <?php if($pnboutbound_new['actioning_in_system']=="N/A") echo "selected"; ?>>N/A</option>
										</select>
									</td>
									<td><input type="text" name="data[actioning_in_system_reason]" value="<?php echo $pnboutbound_new['actioning_in_system_reason']?>" class="form-control"/></td>
									<td><input type="text" name="data[remark14]" value="<?php echo $pnboutbound_new['remark14']?>" class="form-control"/></td>
								</tr>
								<tr>
									<td>Summarization of Call</td>
									<td>5</td>
									<td>
										<select class="form-control pnb_ob_point" name="data[summarization_of_call]" required>
											<option pnb_ob_val=5 pnb_ob_max=5 value="Good" <?php if($pnboutbound_new['summarization_of_call']=="Good") echo "selected"; ?>>Good</option>
											<option pnb_ob_val=2.5 pnb_ob_max=5 value="Needs Improvement" <?php if($pnboutbound_new['summarization_of_call']=="Needs Improvement") echo "selected"; ?>>Needs Improvement</option>
											<option pnb_ob_val=0 pnb_ob_max=5 value="Poor" <?php if($pnboutbound_new['summarization_of_call']=="Poor") echo "selected"; ?>>Poor</option>
											<option pnb_ob_val=0 pnb_ob_max=0 value="N/A" <?php if($pnboutbound_new['summarization_of_call']=="N/A") echo "selected"; ?>>N/A</option>
										</select>
									</td>
									<td><input type="text" name="data[summarization_of_call_reason]" value="<?php echo $pnboutbound_new['summarization_of_call_reason']?>" class="form-control"/></td>
									<td><input type="text" name="data[remark15]" value="<?php echo $pnboutbound_new['remark15']?>" class="form-control"/></td>
								</tr>
								<tr>
									<td>Closing of call</td>
									<td>3</td>
									<td>
										<select class="form-control pnb_ob_point" name="data[closing_call]" required>
											<option pnb_ob_val=3 pnb_ob_max=3 value="Good" <?php if($pnboutbound_new['closing_call']=="Good") echo "selected"; ?>>Good</option>
											<option pnb_ob_val=1.5 pnb_ob_max=3 value="Needs Improvement" <?php if($pnboutbound_new['closing_call']=="Needs Improvement") echo "selected"; ?>>Needs Improvement</option>
											<option pnb_ob_val=0 pnb_ob_max=3 value="Poor" <?php if($pnboutbound_new['closing_call']=="Poor") echo "selected"; ?>>Poor</option>
											<option pnb_ob_val=0 pnb_ob_max=0 value="N/A" <?php if($pnboutbound_new['closing_call']=="N/A") echo "selected"; ?>>N/A</option>
										</select>
									</td>
									<td><input type="text" name="data[closing_call_reason]" value="<?php echo $pnboutbound_new['closing_call_reason']?>" class="form-control"/></td>
									<td><input type="text" name="data[remark16]" value="<?php echo $pnboutbound_new['remark16']?>" class="form-control"/></td>
								</tr>
								<tr>
									<td style="color:red;">Tagging & Disposition in Convox</td>
									<td>8</td>
									<td>
										<select class="form-control pnb_ob_point pnb_ob_fatal" name="data[tagging_disposition]" required>
											<option pnb_ob_val=8 pnb_ob_max=8 value="Good" <?php if($pnboutbound_new['tagging_disposition']=="Good") echo "selected"; ?>>Good</option>
											<option pnb_ob_val=0 pnb_ob_max=8 value="Fatal" <?php if($pnboutbound_new['tagging_disposition']=="Fatal") echo "selected"; ?>>Fatal</option>
										</select>
									</td>
									<td><input type="text" name="data[tagging_disposition_reason]" value="<?php echo $pnboutbound_new['tagging_disposition_reason']?>" class="form-control"/></td>
									<td><input type="text" name="data[remark17]" value="<?php echo $pnboutbound_new['remark17']?>" class="form-control"/></td>
								</tr>
								<tr>
									<td style="color:red;">ZTP</td>
									<td>4</td>
									<td>
										<select class="form-control pnb_ob_point pnb_ob_fatal" name="data[ztp]" required>
											<option pnb_ob_val=4 pnb_ob_max=4 value="Good" <?php if($pnboutbound_new['ztp']=="Good") echo "selected"; ?>>Good</option>
											<option pnb_ob_val=0 pnb_ob_max=4 value="Fatal" <?php if($pnboutbound_new['ztp']=="Fatal") echo "selected"; ?>>Fatal</option>
										</select>
									</td>
									<td><input type="text" name="data[ztp_reason]" value="<?php echo $pnboutbound_new['ztp_reason']?>" class="form-control"/></td>
									<td><input type="text" name="data[remark15]" value="<?php echo $pnboutbound_new['remark15']?>" class="form-control"/></td>
								</tr>
								
								<tr>
									<td>Call Summary:</td>
									<td><textarea class="form-control1" style="width:450px" name="data[call_summary]"><?php echo $pnboutbound_new['call_summary'] ?></textarea></td>
									<td>Feedback:</td>
									<td colspan=4><textarea class="form-control1" style="width:450px" name="data[feedback]"><?php echo $pnboutbound_new['feedback'] ?></textarea></td>
								</tr>
								<tr>
									<td colspan=2>Upload Files (wav,wmv,mp3,mp4)</td>
									<?php if($pnboutbound_id==0){ ?>
										<td colspan=2><input type="file" multiple class="form-control audioFile" id="fileuploadbasic" name="attach_file[]" ></td>
									<?php }else{ ?>
										<td colspan=2><input type="file" multiple class="form-control audioFile" name="attach_file[]" ></td>
										<td colspan=2>
											<?php if($pnboutbound_new['attach_file']!=''){
												$attach_file = explode(",",$pnboutbound_new['attach_file']);
												 foreach($attach_file as $mp){ ?>
													<audio controls='' style="background-color:#607F93"> 
													  <source src="<?php echo base_url(); ?>qa_files/pnboutbound/<?php echo $mp; ?>" type="audio/ogg">
													  <source src="<?php echo base_url(); ?>qa_files/pnboutbound/<?php echo $mp; ?>" type="audio/mpeg">
													</audio> </br>
												 <?php }  
											}?>
										</td>
									<?php } ?>
								</tr>
								
									
									<?php if($pnboutbound_id!=0){ ?>
										<tr><td colspan=2 style="font-size:16px; font-weight:bold">Agent Feedback Acceptance:</td><td colspan=4><?php echo $pnboutbound_new['agnt_fd_acpt'] ?></td></tr>
										<tr><td colspan=2 style="font-size:16px; font-weightbold">Agent Review:</td><td colspan=4><?php echo $pnboutbound_new['agent_rvw_note'] ?></td></tr>
										<tr><td colspan=2 style="font-size:16px; font-weight:bold">Management Review:</td><td colspan=4><?php echo $pnboutbound_new['mgnt_rvw_note'] ?></td></tr>
										<tr><td colspan=2 style="font-size:16px; font-weight:bold">Client Review:</td><td colspan=4><?php echo $pnboutbound_new['client_rvw_note'] ?></td></tr>

										<tr><td colspan=2  style="font-size:16px">Your Review</td><td colspan=4><textarea class="form-control1" style="width:100%" id="note" name="note"  ></textarea></td></tr>
									<?php } ?>


									<?php
									if($pnboutbound_id==0){
										if(is_access_qa_module()==true || is_access_qa_operations_module()==true){ ?>
											<tr><td colspan=6><button class="btn btn-success waves-effect" type="submit" id="qaformsubmit" style="width:500px">SAVE</button></td></tr>
									<?php
										}
									}else{
										if(is_access_qa_module()==true || is_access_qa_operations_module()==true){
											if(is_available_qa_feedback($pnboutbound_new['entry_date'],72) == true){ ?>
												<tr><td colspan="6"><button class="btn btn-success waves-effect" type="submit" id='qaformsubmit' name='btnSave' value="SAVE" style="width:500px">SAVE</button></td></tr>
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