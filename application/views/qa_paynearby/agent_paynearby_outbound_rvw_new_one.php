<style>

.table > tbody > tr > td{
	text-align: center;
	font-size:13px;
}

#theader{
	font-size:20px;
	font-weight:bold;
}

.eml{
	font-weight:bold;
	background-color:#CCD1D1;
}

.eml1{
	font-size:24px;
	font-weight:bold;
	background-color:#05203E;
	color:white;
}

.emp2{
	font-size:16px;
	font-weight:bold;
}

</style>

<div class="wrap">
	<section class="app-content">

		<div class="row">
			<div class="col-12">
				<div class="widget">
					<div class="widget-body">
					 	<div class="table-responsive">
							<table class="table table-striped skt-table" width="100%">
								<tbody>
									<tr>
										<td colspan="6" id="theader" style="font-size:40px">Retention VRM</td>
										<input type="hidden" name="audit_start_time" value="<?php echo CurrMySqlDate(); ?>">
									</tr>
									
									<tr>
										<td style="width:120px">Auditor Name:</td>
										<td style="width:250px;"><input type="text" class="form-control" value="<?php echo $paynearby_feedback['auditor_name']; ?>" disabled></td>
										<td style="width: 120px;">Audit Date:</td>
										<td style="width:250px"><input type="text" class="form-control" value="<?php echo $paynearby_feedback['audit_date']; ?>" disabled></td>
										<td>Call Date:</td>
										<td style="width:250px;"><input type="text" class="form-control" id="call_date" name="call_date" value="<?php echo mysql2mmddyy($paynearby_feedback['call_date']); ?>" readonly ></td>
									</tr>
									<tr>
										<td>Agent:</td>
										<td>
											<select class="form-control agentName" id="agent_id" name="data[agent_id]" disabled>
												<option value="<?php echo $paynearby_feedback['agent_id'] ?>"><?php echo $paynearby_feedback['fname']." ".$paynearby_feedback['lname'] ?></option>
												<option value="">-Select-</option>
												<?php foreach($agentName as $row):  ?>
													<option value="<?php echo $row['id']; ?>"><?php echo $row['name'].' ('.$row['fusion_id'].')'; ?></option>
												<?php endforeach; ?>
											</select>
										</td>
										<td>Fusion ID:</td>
										<td><input type="text" readonly class="form-control" id="fusion_id" name="" value="<?php echo $paynearby_feedback['fusion_id'] ?>"></td>
										<td>L1 Supervisor:</td>
										<td>
											<select class="form-control" id="tl_id" name="data[tl_id]" readonly>
												<option value="<?php echo $paynearby_feedback['tl_id'] ?>"><?php echo $paynearby_feedback['tl_name'] ?></option>
												<option value="">--Select--</option>
												<?php foreach($tlname as $tl): ?>
													<option value="<?php echo $tl['id']; ?>"><?php echo $tl['fname']." ".$tl['lname']; ?></option>
												<?php endforeach; ?>
											</select>
										</td>
									</tr>
									<tr>
										<td>Campaign:</td>
										<td><input type="text" readonly class="form-control" id="campaign" name="data[campaign]" value="<?php echo $paynearby_feedback['campaign'] ?>" disabled></td>
										<td>Call Duration:</td>
										<td><input type="text" class="form-control" id="call_duration" name="data[call_duration]" value="<?php echo $paynearby_feedback['call_duration'] ?>" disabled></td>
										<td>Incoming No.:</td>
										<td><input type="text" class="form-control" id="incoming_no" name="data[incoming_no]" value="<?php echo $paynearby_feedback['incoming_no'] ?>" onkeyup="checkDec(this);" disabled></td>
									</tr>
									<tr>
										<td>Register No.:</td>
										<td><input type="text" class="form-control" id="register_no" name="data[register_no]" value="<?php echo $paynearby_feedback['register_no'] ?>" disabled></td>
										<td>Customer Name:</td>
										<td><input type="text" class="form-control" id="customer" name="data[customer]" value="<?php echo $paynearby_feedback['customer'] ?>" disabled></td>
										<td>Call Link:</td>
										<td><input type="text" class="form-control" id="call_link" name="data[call_link]" value="<?php echo $paynearby_feedback['call_link'] ?>" disabled></td>
									</tr>
									<tr>
										<td>Ticket No.:</td>
										<td><input type="text" class="form-control" id="ticket_no" name="data[ticket_no]" value="<?php echo $paynearby_feedback['ticket_no'] ?>" disabled></td>
										<td>Call Disconnect By:</td>
										<td><input type="text" class="form-control" id="call_disconnect_by" name="data[call_disconnect_by]" value="<?php echo $paynearby_feedback['call_disconnect_by'] ?>"  disabled></td>
										<td>Tagging/Disposition:</td>
										<td>
											<input type="text" class="form-control" id="" name="data[tagging]" value="<?php echo $paynearby_feedback['tagging'] ?>" disabled>
										</td>
									</tr>
									<tr>
										<td>Query/Service:</td>
										<td><input type="text" value="<?php echo $paynearby_feedback['query_service']?>" class="form-control" id="query_service" name="data[query_service]" disabled></td>
										<td>Type of Call:</td>
										<td><input type="text" class="form-control" id="call_type" name="data[call_type]" value="<?php echo $paynearby_feedback['call_type'] ?>" disabled></td>
									</tr>
									<tr>
										<td>Audit Type:</td>
										<td>
											<select class="form-control" id="audit_type" name="data[audit_type]" disabled>
												<option value="<?php echo $paynearby_feedback['audit_type'] ?>"><?php echo $paynearby_feedback['audit_type'] ?></option>
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
												<option value="<?php echo $paynearby_feedback['auditor_type'] ?>"><?php echo $paynearby_feedback['auditor_type'] ?></option>
												<option value="">-Select-</option>
												<option value="Master">Master</option>
												<option value="Regular">Regular</option>
											</select>
										</td>
										<td>VOC:</td>
										<td>
											<select class="form-control" id="voc" name="data[voc]" disabled>
												<option value="<?php echo $paynearby_feedback['voc'] ?>"><?php echo $paynearby_feedback['voc'] ?></option>
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
										<td><input type="text" readonly id="paynear_possibleScore" name="data[possible_score]" class="form-control" style="font-weight:bold" value="<?php echo $paynearby_feedback['possible_score'] ?>"></td>
										<td style="font-weight:bold; font-size:16px">Earned Score: </td>
										<td><input type="text" readonly id="paynear_earnedScore" name="data[earned_score]" class="form-control" style="font-weight:bold" value="<?php echo $paynearby_feedback['earned_score'] ?>"></td>
										<td style="font-weight:bold; font-size:16px; text-align:right">Overall Score:</td>
										<td><input type="text" readonly id="pnb_ob_overallScore" name="data[overall_score]" class="form-control pnboutboundFatal" style="font-weight:bold" value="<?php echo $paynearby_feedback['overall_score'] ?>"></td>
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
										  <select name="data[standard_call_opening]" class="form-control pnb_ob_point" disabled>
											<option pnb_ob_val=3 pnb_ob_max=3 value="Good" <?php if($paynearby_feedback['standard_call_opening']=="Good") echo "selected"; ?>>Good</option>
											<option pnb_ob_val=1.5 pnb_ob_max=3 value="Needs Improvement" <?php if($paynearby_feedback['standard_call_opening']=="Needs Improvement") echo "selected"; ?>>Needs Improvement</option>
											<option pnb_ob_val=0 pnb_ob_max=3 value="Poor" <?php if($paynearby_feedback['standard_call_opening']=="Poor") echo "selected"; ?>>Poor</option>
											<option pnb_ob_val=0 pnb_ob_max=0 value="N/A" <?php if($paynearby_feedback['standard_call_opening']=="N/A") echo "selected";?>>N/A</option>
										  </select>
									</td>
									<td><input type="text" name="data[sco_reason]" value="<?php echo $paynearby_feedback['sco_reason']?>" class="form-control" disabled/></td>
									<td><input type="text" name="data[remark1]" value="<?php echo $paynearby_feedback['remark1']?>" class="form-control" disabled/></td>
								</tr>
								<tr>
									<td>Appropriate Empathy/Apology Wherever Applicable</td>
									<td>3</td>
									<td>
									  <select name="data[appr_empathy_apology]" class="form-control pnb_ob_point" disabled>
										<option pnb_ob_val=3 pnb_ob_max=3 value="Good" <?php if($paynearby_feedback['appr_empathy_apology']=="Good") echo "selected"; ?>>Good</option>
										<option pnb_ob_val=1.5 pnb_ob_max=3 value="Needs Improvement" <?php if($paynearby_feedback['appr_empathy_apology']=="Needs Improvement") echo "selected"; ?>>Needs Improvement</option>
										<option pnb_ob_val=0 pnb_ob_max=3 value="Poor" <?php if($paynearby_feedback['appr_empathy_apology']=="Poor") echo "selected"; ?>>Poor</option>
										<option pnb_ob_val=0 pnb_ob_max=0 value="N/A" <?php if($paynearby_feedback['appr_empathy_apology']=="N/A") echo "selected"; ?>>N/A</option>
									  </select>
									</td>
									<td><input type="text" name="data[appr_emp_ap_reason]" value="<?php echo $paynearby_feedback['appr_emp_ap_reason']?>" class="form-control" disabled/></td>
									<td><input type="text" name="data[remark2]" value="<?php echo $paynearby_feedback['remark2']?>" class="form-control" disabled/></td>
								</tr>
								
								<tr>
									<td>Maintained professional Tone/ Assured the retailer wherever applicable</td>
									<td>3</td>
									<td>
									  <select name="data[professional]" class="form-control pnb_ob_point" disabled>
										<option pnb_ob_val=3 pnb_ob_max=3 value="Good" <?php if($paynearby_feedback['professional']=="Good") echo "selected"; ?>>Good</option>
										<option pnb_ob_val=1.5 pnb_ob_max=3 value="Needs Improvement" <?php if($paynearby_feedback['professional']=="Needs Improvement") echo "selected"; ?>>Needs Improvement</option>
										<option pnb_ob_val=0 pnb_ob_max=3 value="Poor" <?php if($paynearby_feedback['professional']=="Poor") echo "selected"; ?>>Poor</option>
										<option pnb_ob_val=0 pnb_ob_max=0 value="N/A" <?php if($paynearby_feedback['professional']=="N/A") echo "selected"; ?>>N/A</option>
									  </select>
									</td>
									<td><input type="text" name="data[professional_reason]" value="<?php echo $paynearby_feedback['professional_reason']?>" class="form-control" disabled/></td>
									<td><input type="text" name="data[remark3]" value="<?php echo $paynearby_feedback['remark3']?>" class="form-control" disabled/></td>
								</tr>
								<tr>
									<td>Eshtablished connect with the retailer</td>
									<td>8</td>
									<td>
									  <select name="data[connect_retailer]" class="form-control pnb_ob_point" disabled>
										<option pnb_ob_val=8 pnb_ob_max=8 value="Good" <?php if($paynearby_feedback['connect_retailer']=="Good") echo "selected"; ?>>Good</option>
										<option pnb_ob_val=4 pnb_ob_max=8 value="Needs Improvement" <?php if($paynearby_feedback['connect_retailer']=="Needs Improvement") echo "selected"; ?>>Needs Improvement</option>
										<option pnb_ob_val=0 pnb_ob_max=8 value="Poor" <?php if($paynearby_feedback['connect_retailer']=="Poor") echo "selected"; ?>>Poor</option>
										<option pnb_ob_val=0 pnb_ob_max=0 value="N/A" <?php if($paynearby_feedback['connect_retailer']=="N/A") echo "selected"; ?>>N/A</option>
									  </select>
									</td>
									<td><input type="text" name="data[connect_retailer_reason]" value="<?php echo $paynearby_feedback['connect_retailer_reason']?>" class="form-control" disabled/></td>
									<td><input type="text" name="data[remark4]" value="<?php echo $paynearby_feedback['remark4']?>" class="form-control" disabled/></td>
								</tr>
								
								<tr>
									<td>Rate/Clarity of speech was moderate/No usage of Jargons</td>
									<td>5</td>
									<td>
										<select name="data[clarity_of_speech]" class="form-control pnb_ob_point" disabled>
											<option pnb_ob_val=5 pnb_ob_max=5 value="Good" <?php if($paynearby_feedback['clarity_of_speech']=="Good") echo "selected"; ?>>Good</option>
											<option pnb_ob_val=2.5 pnb_ob_max=5 value="Needs Improvement" <?php if($paynearby_feedback['clarity_of_speech']=="Needs Improvement") echo "selected"; ?>>Needs Improvement</option>
											<option pnb_ob_val=0 pnb_ob_max=5 value="Poor" <?php if($paynearby_feedback['clarity_of_speech']=="Poor") echo "selected"; ?>>Poor</option>
											<option pnb_ob_val=0 pnb_ob_max=0 value="N/A" <?php if($paynearby_feedback['clarity_of_speech']=="N/A") echo "selected"; ?>>N/A</option>
										  </select>
									</td>
									<td><input type="text" name="data[clarity_of_speech_reason]" value="<?php echo $paynearby_feedback['clarity_of_speech_reason']?>" class="form-control" disabled/></td>
									<td><input type="text" name="data[remark5]" value="<?php echo $paynearby_feedback['remark5']?>" class="form-control" disabled/></td>
								</tr>
								<tr>
									<td>Active Listening</td>
									<td>3</td>
									<td>
										<select name="data[active_listening]" class="form-control pnb_ob_point" disabled>
											<option pnb_ob_val=3 pnb_ob_max=3 value="Good" <?php if($paynearby_feedback['active_listening']=="Good") echo "selected"; ?>>Good</option>
											<option pnb_ob_val=1.5 pnb_ob_max=3 value="Needs Improvement" <?php if($paynearby_feedback['active_listening']=="Needs Improvement") echo "selected"; ?>>Needs Improvement</option>
											<option pnb_ob_val=0 pnb_ob_max=3 value="Poor" <?php if($paynearby_feedback['active_listening']=="Poor") echo "selected"; ?>>Poor</option>
											<option pnb_ob_val=0 pnb_ob_max=0 value="N/A" <?php if($paynearby_feedback['active_listening']=="N/A") echo "selected"; ?>>N/A</option>
										  </select>
									</td>
									<td><input type="text" name="data[active_listening_reason]" value="<?php echo $paynearby_feedback['active_listening_reason']?>" class="form-control" disabled/></td>
									<td><input type="text" name="data[remark6]" value="<?php echo $paynearby_feedback['remark6']?>" class="form-control" disabled/></td>
								</tr>
								<tr>
									<td>Interruption & Parallel Talking</td>
									<td>3</td>
									<td>
										<select name="data[parallel_talking]" class="form-control pnb_ob_point" disabled>
											<option pnb_ob_val=3 pnb_ob_max=3 value="Good" <?php if($paynearby_feedback['parallel_talking']=="Good") echo "selected"; ?>>Good</option>
											<option pnb_ob_val=1.5 pnb_ob_max=3 value="Needs Improvement" <?php if($paynearby_feedback['parallel_talking']=="Needs Improvement") echo "selected"; ?>>Needs Improvement</option>
											<option pnb_ob_val=0 pnb_ob_max=3 value="Poor" <?php if($paynearby_feedback['parallel_talking']=="Poor") echo "selected"; ?>>Poor</option>
											<option pnb_ob_val=0 pnb_ob_max=0 value="N/A" <?php if($paynearby_feedback['parallel_talking']=="N/A") echo "selected"; ?>>N/A</option>
										 </select>
									</td>
									
									<td><input type="text" name="data[parallel_talking_reason]" value="<?php echo $paynearby_feedback['parallel_talking_reason']?>" class="form-control" disabled/></td>
									<td><input type="text" name="data[remark7]" value="<?php echo $paynearby_feedback['remark7']?>" class="form-control" disabled/></td>
								</tr>
								<tr>
									<td>Seamless Conversation (No abrupt pause/dead air)</td>
									<td>5</td>
									<td>
										<select name="data[dead_air]" class="form-control pnb_ob_point" disabled>
											<option pnb_ob_val=5 pnb_ob_max=5 value="Good" <?php if($paynearby_feedback['dead_air']=="Good") echo "selected"; ?>>Good</option>
											<option pnb_ob_val=2.5 pnb_ob_max=5 value="Needs Improvement" <?php if($paynearby_feedback['dead_air']=="Needs Improvement") echo "selected"; ?>>Needs Improvement</option>
											<option pnb_ob_val=0 pnb_ob_max=5 value="Poor" <?php if($paynearby_feedback['dead_air']=="Poor") echo "selected"; ?>>Poor</option>
											<option pnb_ob_val=0 pnb_ob_max=0 value="N/A" <?php if($paynearby_feedback['dead_air']=="N/A") echo "selected"; ?>>N/A</option>
										  </select>
									</td>
									<td><input type="text" name="data[dead_air_reason]" value="<?php echo $paynearby_feedback['dead_air_reason']?>" class="form-control" disabled/></td>
									<td><input type="text" name="data[remark8]" value="<?php echo $paynearby_feedback['remark8']?>" class="form-control" disabled/></td>
								</tr>
								<tr>
									<td>Reason for drop in business figures</td>
									<td>8</td>
									<td>
										<select class="form-control pnb_ob_point" name="data[drop_business]" disabled>
										<option pnb_ob_val=8 pnb_ob_max=8 value="Good" <?php if($paynearby_feedback['drop_business']=="Good") echo "selected"; ?>>Good</option>
										<option pnb_ob_val=4 pnb_ob_max=8 value="Needs Improvement" <?php if($paynearby_feedback['drop_business']=="Needs Improvement") echo "selected"; ?>>Needs Improvement</option>
										<option pnb_ob_val=0 pnb_ob_max=8 value="Poor" <?php if($paynearby_feedback['drop_business']=="Poor") echo "selected"; ?>>Poor</option>
										<option pnb_ob_val=0 pnb_ob_max=0 value="N/A" <?php if($paynearby_feedback['drop_business']=="N/A") echo "selected"; ?>>N/A</option>
										</select>
									</td>
									<td><input type="text" name="data[drop_business_reason]" value="<?php echo $paynearby_feedback['drop_business_reason']?>" class="form-control" disabled/></td>
									<td><input type="text" name="data[remark9]" value="<?php echo $paynearby_feedback['remark9']?>" class="form-control" disabled/></td>
								</tr>
								
								<tr>
									<td>All required checks done for conversion (System checks)</td>
									<td>8</td>
									<td>
										<select class="form-control pnb_ob_point" name="data[conversion_check]" disabled>
											<option pnb_ob_val=8 pnb_ob_max=8 value="Good" <?php if($paynearby_feedback['conversion_check']=="Good") echo "selected"; ?>>Good</option>
											<option pnb_ob_val=4 pnb_ob_max=8 value="Needs Improvement" <?php if($paynearby_feedback['conversion_check']=="Needs Improvement") echo "selected"; ?>>Needs Improvement</option>
											<option pnb_ob_val=0 pnb_ob_max=8 value="Poor" <?php if($paynearby_feedback['conversion_check']=="Poor") echo "selected"; ?>>Poor</option>
											<option pnb_ob_val=0 pnb_ob_max=0 value="N/A" <?php if($paynearby_feedback['conversion_check']=="N/A") echo "selected"; ?>>N/A</option>
										</select>
									</td>
									<td><input type="text" name="data[conversion_check_reason]" value="<?php echo $paynearby_feedback['conversion_check_reason']?>" class="form-control" disabled/></td>
									<td><input type="text" name="data[remark10]" value="<?php echo $paynearby_feedback['remark10']?>" class="form-control" disabled/></td>
								</tr>
								<tr>
									<td style="color:red;">Agent Shared The Correct/Complete Information</td>
									<td>10</td>
									<td>
										<select class="form-control pnb_ob_point pnb_ob_fatal" name="data[complete_information]" disabled>
											<option pnb_ob_val=10 pnb_ob_max=10 value="Good" <?php if($paynearby_feedback['complete_information']=="Good") echo "selected"; ?>>Good</option>
											<option pnb_ob_val=0 pnb_ob_max=10 value="Fatal" <?php if($paynearby_feedback['complete_information']=="Fatal") echo "selected"; ?>>Fatal</option>
										</select>
									</td>
									<td><input type="text" name="data[complete_information_reason]" value="<?php echo $paynearby_feedback['complete_information_reason']?>" class="form-control" disabled/></td>
									<td><input type="text" name="data[remark11]" value="<?php echo $paynearby_feedback['remark11']?>" class="form-control" disabled/></td>
								</tr>
								<tr>
									<td>Business opportunity was explored and explained</td>
									<td>8</td>
									<td>
										<select class="form-control pnb_ob_point" name="data[business_opportunity]" disabled>
											<option pnb_ob_val=8 pnb_ob_max=8 value="Good" <?php if($paynearby_feedback['business_opportunity']=="Good") echo "selected"; ?>>Good</option>
											<option pnb_ob_val=4 pnb_ob_max=8 value="Needs Improvement" <?php if($paynearby_feedback['business_opportunity']=="Needs Improvement") echo "selected"; ?>>Needs Improvement</option>
											<option pnb_ob_val=0 pnb_ob_max=8 value="Poor" <?php if($paynearby_feedback['business_opportunity']=="Poor") echo "selected"; ?>>Poor</option>
											<option pnb_ob_val=0 pnb_ob_max=0 value="N/A" <?php if($paynearby_feedback['business_opportunity']=="N/A") echo "selected"; ?>>N/A</option>
										</select>
									</td>
									<td><input type="text" name="data[business_opportunity_reason]" value="<?php echo $paynearby_feedback['business_opportunity_reason']?>" class="form-control" disabled/></td>
									<td><input type="text" name="data[remark12]" value="<?php echo $paynearby_feedback['remark12']?>" class="form-control" disabled/></td>
								</tr>
								<tr>
									<td>CRM/Convox Remarks were captured properly</td>
									<td>5</td>
									<td>
										<select class="form-control pnb_ob_point" name="data[crm]" disabled>
											<option pnb_ob_val=5 pnb_ob_max=5 value="Good" <?php if($paynearby_feedback['crm']=="Good") echo "selected"; ?>>Good</option>
											<option pnb_ob_val=2.5 pnb_ob_max=5 value="Needs Improvement" <?php if($paynearby_feedback['crm']=="Needs Improvement") echo "selected"; ?>>Needs Improvement</option>
											<option pnb_ob_val=0 pnb_ob_max=5 value="Poor" <?php if($paynearby_feedback['crm']=="Poor") echo "selected"; ?>>Poor</option>
											<option pnb_ob_val=0 pnb_ob_max=0 value="N/A" <?php if($paynearby_feedback['crm']=="N/A") echo "selected"; ?>>N/A</option>
										</select>
									</td>
									<td><input type="text" name="data[crm_reason]" value="<?php echo $paynearby_feedback['crm_reason']?>" class="form-control" disabled/></td>
									<td><input type="text" name="data[remark13]" value="<?php echo $paynearby_feedback['remark13']?>" class="form-control" disabled/></td>
								</tr>
								<tr>
									<td style="color:red;">Actioning in System, Need to follow up ( For Complaint / Issue which escalated to concern Team)</td>
									<td>8</td>
									<td>
										<select class="form-control pnb_ob_point" name="data[actioning_in_system]" disabled>
										<option pnb_ob_val=8 pnb_ob_max=8 value="Good" <?php if($paynearby_feedback['actioning_in_system']=="Good") echo "selected"; ?>>Good</option>
											<option pnb_ob_val=0 pnb_ob_max=8 value="Fatal" <?php if($paynearby_feedback['actioning_in_system']=="Fatal") echo "selected"; ?>>Fatal</option>
										</select>
									</td>
									<td><input type="text" name="data[actioning_in_system_reason]" value="<?php echo $paynearby_feedback['actioning_in_system_reason']?>" class="form-control" disabled/></td>
									<td><input type="text" name="data[remark14]" value="<?php echo $paynearby_feedback['remark14']?>" class="form-control" disabled/></td>
								</tr>
								<tr>
									<td>Summarization of Call</td>
									<td>5</td>
									<td>
										<select class="form-control pnb_ob_point" name="data[summarization_of_call]" disabled>
											<option pnb_ob_val=5 pnb_ob_max=5 value="Good" <?php if($paynearby_feedback['summarization_of_call']=="Good") echo "selected"; ?>>Good</option>
											<option pnb_ob_val=2.5 pnb_ob_max=5 value="Needs Improvement" <?php if($paynearby_feedback['summarization_of_call']=="Needs Improvement") echo "selected"; ?>>Needs Improvement</option>
											<option pnb_ob_val=0 pnb_ob_max=5 value="Poor" <?php if($paynearby_feedback['summarization_of_call']=="Poor") echo "selected"; ?>>Poor</option>
											<option pnb_ob_val=0 pnb_ob_max=0 value="N/A" <?php if($paynearby_feedback['summarization_of_call']=="N/A") echo "selected"; ?>>N/A</option>
										</select>
									</td>
									<td><input type="text" name="data[summarization_of_call_reason]" value="<?php echo $paynearby_feedback['summarization_of_call_reason']?>" class="form-control" disabled/></td>
									<td><input type="text" name="data[remark15]" value="<?php echo $paynearby_feedback['remark15']?>" class="form-control" disabled/></td>
								</tr>
								<tr>
									<td>Closing of call</td>
									<td>3</td>
									<td>
										<select class="form-control pnb_ob_point" name="data[closing_call]" disabled>
											<option pnb_ob_val=3 pnb_ob_max=3 value="Good" <?php if($paynearby_feedback['closing_call']=="Good") echo "selected"; ?>>Good</option>
											<option pnb_ob_val=1.5 pnb_ob_max=3 value="Needs Improvement" <?php if($paynearby_feedback['closing_call']=="Needs Improvement") echo "selected"; ?>>Needs Improvement</option>
											<option pnb_ob_val=0 pnb_ob_max=3 value="Poor" <?php if($paynearby_feedback['closing_call']=="Poor") echo "selected"; ?>>Poor</option>
											<option pnb_ob_val=0 pnb_ob_max=0 value="N/A" <?php if($paynearby_feedback['closing_call']=="N/A") echo "selected"; ?>>N/A</option>
										</select>
									</td>
									<td><input type="text" name="data[closing_call_reason]" value="<?php echo $paynearby_feedback['closing_call_reason']?>" class="form-control" disabled/></td>
									<td><input type="text" name="data[remark16]" value="<?php echo $paynearby_feedback['remark16']?>" class="form-control" disabled/></td>
								</tr>
								<tr>
									<td style="color:red;">Tagging & Disposition in Convox</td>
									<td>8</td>
									<td>
										<select class="form-control pnb_ob_point pnb_ob_fatal" name="data[tagging_disposition]" disabled>
											<option pnb_ob_val=8 pnb_ob_max=8 value="Good" <?php if($paynearby_feedback['tagging_disposition']=="Good") echo "selected"; ?>>Good</option>
											<option pnb_ob_val=0 pnb_ob_max=8 value="Fatal" <?php if($paynearby_feedback['tagging_disposition']=="Fatal") echo "selected"; ?>>Fatal</option>
										</select>
									</td>
									<td><input type="text" name="data[tagging_disposition_reason]" value="<?php echo $paynearby_feedback['tagging_disposition_reason']?>" class="form-control" disabled/></td>
									<td><input type="text" name="data[remark17]" value="<?php echo $paynearby_feedback['remark17']?>" class="form-control" disabled/></td>
								</tr>
								<tr>
									<td style="color:red;">ZTP</td>
									<td>4</td>
									<td>
										<select class="form-control pnb_ob_point pnb_ob_fatal" name="data[ztp]" disabled>
											<option pnb_ob_val=4 pnb_ob_max=4 value="Good" <?php if($paynearby_feedback['ztp']=="Good") echo "selected"; ?>>Good</option>
											<option pnb_ob_val=0 pnb_ob_max=4 value="Fatal" <?php if($paynearby_feedback['ztp']=="Fatal") echo "selected"; ?>>Fatal</option>
										</select>
									</td>
									<td><input type="text" name="data[ztp_reason]" value="<?php echo $paynearby_feedback['ztp_reason']?>" class="form-control" disabled/></td>
									<td><input type="text" name="data[remark18]" value="<?php echo $paynearby_feedback['remark18']?>" class="form-control" disabled/></td>
								</tr>
								
								<tr>
									<td>Call Summary:</td>
									<td colspan="6"><textarea class="form-control" name="data[call_summary]" disabled><?php echo $paynearby_feedback['call_summary'] ?></textarea></td>
									</tr>
								
								<tr>
									<td>Feedback:</td>
									<td colspan="6"><textarea class="form-control" name="data[feedback]" disabled><?php echo $paynearby_feedback['feedback'] ?></textarea></td>
								</tr>
									<?php if($paynearby_feedback['attach_file']!=''){ ?>
									<tr oncontextmenu="return false;">
										<td colspan="2">Audio Files</td>
										<td colspan="4">
											<?php $attach_file = explode(",",$paynearby_feedback['attach_file']);
											 foreach($attach_file as $mp){ ?>
												<audio controls='' style="background-color:#607F93">
												  <source src="<?php echo base_url(); ?>qa_files/pnboutbound/<?php echo $mp; ?>" type="audio/ogg">
												  <source src="<?php echo base_url(); ?>qa_files/pnboutbound/<?php echo $mp; ?>" type="audio/mpeg">
												</audio> </br>
											 <?php } ?>
										</td>
									</tr>
									<?php } ?>
									<tr><td colspan="6" style="background-color:#C5C8C8"></td></tr>

									 <form id="form_agent_user" method="POST" action="">
										<tr>
											<td colspan="6">
												<input type="hidden" name="pnid" class="form-control" value="<?php echo $pnid; ?>">
												<input type="hidden" id="action" name="action" class="form-control" value="<?php echo $paynearby_feedback['id']; ?>">
											</td>
										</tr>
										<tr>
											<td colspan=2 style="font-size:16px">Feedback Acceptance</td>
											<td colspan=4>
												<select class="form-control" id="" name="agnt_fd_acpt" required>
													<option value="">Select</option>
													<option <?php echo $paynearby_feedback['agnt_fd_acpt']=='Accepted'?"selected":""; ?> value="Accepted">Accepted</option>
													<option <?php echo $paynearby_feedback['agnt_fd_acpt']=='Not Accepted'?"selected":""; ?> value="Not Accepted">Not Accepted</option>
												</select>
											</td>
										</tr>
										<tr>
											<td colspan="2"  style="font-size:16px">Your Review</td>
											<td colspan="4">
												<?php
													$disable="";
													if($paynearby_feedback['agent_rvw_date']!="") $disable="disabled";
												?>
												<textarea class="form-control"<?php echo $disable; ?> id="note" name="note" required><?php echo $paynearby_feedback['agent_rvw_note'] ?></textarea>
											</td>
										</tr>

										<?php if(is_access_qa_agent_module()==true){
										if(is_available_qa_feedback($paynearby_feedback['entry_date'],72) == true){ ?>
											<tr>
												<?php if($paynearby_feedback['agent_rvw_date']==''){ ?>
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