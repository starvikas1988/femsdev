
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
									<tr style="background-color:#AEB6BF">
										<td colspan="6" id="theader" style="font-size:30px">PAYNEARBY - OUTBOUND</td>
									</tr>
                  <tr>
										<td style="width:150px">Auditor Name:</td>
										<td style="width:300px"><input type="text" class="form-control" value="<?php echo $paynearby_feedback['auditor_name']; ?>" disabled></td>
										<td>Audit Date:</td>
										<td style="width:250px"><input type="text" class="form-control" value="<?php echo mysql2mmddyy($paynearby_feedback['audit_date']); ?>" disabled></td>
										<td>Call Date:</td>
										<td><input type="text" class="form-control" id="call_date" name="call_date" value="<?php echo mysqlDt2mmddyy($paynearby_feedback['call_date']); ?>" disabled ></td>
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
										<td><input type="text" readonly class="form-control" id="campaign" name="data[campaign]" value="<?php echo $paynearby_feedback['campaign'] ?>"></td>
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
										<td><input type="text" value="<?= $paynearby_feedback['query_service']?>" class="form-control" id="query_service" name="data[query_service]" disabled></td>
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
										<td><input type="text" readonly name="" class="form-control" style="font-weight:bold" value="<?php echo $paynearby_feedback['possible_score'] ?>"></td>
										<td style="font-weight:bold; font-size:16px">Earned Score: </td>
										<td><input type="text" readonly name="" class="form-control" style="font-weight:bold" value="<?php echo $paynearby_feedback['earned_score'] ?>"></td>
										<td style="font-weight:bold; font-size:16px; text-align:right">Overall Score:</td>
										<td><input type="text" readonly name="data[overall_score]" class="form-control pnboutboundFatal" style="font-weight:bold" value="<?php echo $paynearby_feedback['overall_score'] ?>"></td>
									</tr>
								</tbody>
							</table>
							<table class="table table-striped skt-table">
								<tbody>
									<tr style="background-color:#A9CCE3; font-weight:bold">
										<td>Criticality</td>
										<td>Parameters</td>
										<td>Rating</td>
										<td>Reason</td>
										<td>Remarks</td>
									</tr>
									<tr>
										<td rowspan=8 style="background-color:#A9CCE3; font-weight:bold">Call Handling</td>
										<td>Standard Call Opening (Greeting With Company Name Right Party Confirmation)</td>
										<td>
										  <select name="data[standard_call_opening]" class="form-control pnb_ob_point" disabled>
											<option pnb_ob_val=6 pnb_ob_max=6 value="Good" <?php if($paynearby_feedback['standard_call_opening']=="Good") echo "selected"; ?>>Good</option>
											<option pnb_ob_val=3 pnb_ob_max=6 value="Needs Improvement" <?php if($paynearby_feedback['standard_call_opening']=="Needs Improvement") echo "selected"; ?>>Needs Improvement</option>
											<option pnb_ob_val=0 pnb_ob_max=6 value="Poor" <?php if($paynearby_feedback['standard_call_opening']=="Poor") echo "selected"; ?>>Poor</option>
											<option pnb_ob_val=0 pnb_ob_max=0 value="N?A" <?php if($paynearby_feedback['standard_call_opening']=="N/A") echo "selected";?>>N/A</option>
										  </select>
									</td>
									<td>
									  <select class="form-control" name="data[sco_reason]" disabled>
										<option value="">-- SELECT --</option>
										<option value="Opening Script Adhered" <?php if($paynearby_feedback['sco_reason']=="Opening Script Adhered") echo "selected";?>>Opening Script Adhered</option>
										<option value="Branding/Cx name confirmation done but missed few info" <?php if($paynearby_feedback['sco_reason']=="Branding/Cx name confirmation done but missed few info") echo "selected";?>>Branding/Cx name confirmation done but missed few info</option>
										<option value="Branding is missing" <?php if($paynearby_feedback['sco_reason']=="Branding is missing") echo "selected";?>>Branding is missing</option>
										<option value="Cx name confirmation not done" <?php if($paynearby_feedback['sco_reason']=="Cx name confirmation not done") echo "selected";?>>Cx name confirmation not done</option>
										<option value="Permission not taken" <?php if($paynearby_feedback['sco_reason']=="Permission not taken") echo "selected";?>>Permission not taken</option>
									  </select>
									</td>
									<td><input type="text" name="data[remark1]" value="<?php echo $paynearby_feedback['remark1']?>" class="form-control" disabled/></td>
								</tr>
								<tr>
									<td>Appropriate Empathy/Apology Wherever Applicable / Professional Tone / Assurance</td>
									<td>
									  <select name="data[appr_empathy_apology]" class="form-control pnb_ob_point" disabled>
										<option pnb_ob_val=5 pnb_ob_max=5 value="Good" <?php if($paynearby_feedback['appr_empathy_apology']=="Good") echo "selected"; ?>>Good</option>
										<option pnb_ob_val=2.5 pnb_ob_max=5 value="Needs Improvement" <?php if($paynearby_feedback['appr_empathy_apology']=="Needs Improvement") echo "selected"; ?>>Needs Improvement</option>
										<option pnb_ob_val=0 pnb_ob_max=5 value="Poor" <?php if($paynearby_feedback['appr_empathy_apology']=="Poor") echo "selected"; ?>>Poor</option>
										<option pnb_ob_val=0 pnb_ob_max=0 value="N?A" <?php if($paynearby_feedback['appr_empathy_apology']=="N/A") echo "selected"; ?>>N/A</option>
									  </select>
									</td>
									<td>
									  <select class="form-control" name="data[appr_emp_ap_reason]" disabled>
										<option value="">-- SELECT --</option>
										<option value="Empathy/apology available wherever applicable" <?php if($paynearby_feedback['appr_emp_ap_reason']=="Empathy/apology available wherever applicable") echo "selected";?>>Empathy/apology available wherever applicable</option>
										<option value="Empathy/apology unavailable wherever applicable" <?php if($paynearby_feedback['appr_emp_ap_reason']=="Empathy/apology unavailable wherever applicable") echo "selected";?>>Empathy/apology unavailable wherever applicable</option>
										<option value="Empathy not shown multiple times wherever applicable" <?php if($paynearby_feedback['appr_emp_ap_reason']=="Empathy not shown multiple times wherever applicable") echo "selected";?>>Empathy not shown multiple times wherever applicable</option>
									  </select>
									</td>
									<td><input type="text" name="data[remark2]" value="<?php echo $paynearby_feedback['remark2']?>" class="form-control" disabled/></td>
								</tr>
								
								<tr>
									<td>Personalization & Connect</td>
									<td>
									  <select name="data[personalization_connect]" class="form-control pnb_ob_point" disabled>
										<option pnb_ob_val=5 pnb_ob_max=5 value="Good" <?php if($paynearby_feedback['personalization_connect']=="Good") echo "selected"; ?>>Good</option>
										<option pnb_ob_val=2.5 pnb_ob_max=5 value="Needs Improvement" <?php if($paynearby_feedback['personalization_connect']=="Needs Improvement") echo "selected"; ?>>Needs Improvement</option>
										<option pnb_ob_val=0 pnb_ob_max=5 value="Poor" <?php if($paynearby_feedback['personalization_connect']=="Poor") echo "selected"; ?>>Poor</option>
										<option pnb_ob_val=0 pnb_ob_max=0 value="N?A" <?php if($paynearby_feedback['personalization_connect']=="N/A") echo "selected"; ?>>N/A</option>
									  </select>
									</td>
									<td>
									  <select class="form-control" name="data[personalization_connect_reason]" disabled>
										<option value="">-- SELECT --</option>
										<option value="Incorrect sentence formation impacting conversation" <?php if($paynearby_feedback['personalization_connect_reason']=="Incorrect sentence formation impacting conversation") echo "selected";?>>Incorrect sentence formation impacting conversation</option>
										<option value="Incorrect sentence formation not impacting conversation" <?php if($paynearby_feedback['personalization_connect_reason']=="Incorrect sentence formation not impacting conversation") echo "selected";?>>Incorrect sentence formation not impacting conversation</option>
									  </select>
									</td>
									<td><input type="text" name="data[remark3]" value="<?php echo $paynearby_feedback['remark3']?>" class="form-control" disabled/></td>
								</tr>
								<tr>
									<td>Rate of Speech / Clarity Of Speech / Jargons</td>
									<td>
									  <select name="data[rate_of_speech]" class="form-control pnb_ob_point" disabled>
										<option pnb_ob_val=5 pnb_ob_max=5 value="Good" <?php if($paynearby_feedback['rate_of_speech']=="Good") echo "selected"; ?>>Good</option>
										<option pnb_ob_val=2.5 pnb_ob_max=5 value="Needs Improvement" <?php if($paynearby_feedback['rate_of_speech']=="Needs Improvement") echo "selected"; ?>>Needs Improvement</option>
										<option pnb_ob_val=0 pnb_ob_max=5 value="Poor" <?php if($paynearby_feedback['rate_of_speech']=="Poor") echo "selected"; ?>>Poor</option>
										<option pnb_ob_val=0 pnb_ob_max=0 value="N?A" <?php if($paynearby_feedback['rate_of_speech']=="N/A") echo "selected"; ?>>N/A</option>
									  </select>
									</td>
									<td>
									  <select class="form-control" name="data[rate_of_speech_reason]" disabled>
										<option value="">-- SELECT --</option>
										<option value="Rate of speech a bit high but not impacting the conversastion" <?php if($paynearby_feedback['rate_of_speech_reason']=="Rate of speech a bit high but not impacting the conversastion") echo "selected";?>>Rate of speech a bit high but not impacting the conversastion</option>
										<option value="Not energetic tone throughout the call" <?php if($paynearby_feedback['rate_of_speech_reason']=="Not energetic tone throughout the call") echo "selected";?>>Not energetic tone throughout the call</option>
										<option value="Filler /Fumbling on call" <?php if($paynearby_feedback['rate_of_speech_reason']=="Filler /Fumbling on call") echo "selected";?>>Filler /Fumbling on call</option>
										<option value="High Rate of speech or unclear speech observed" <?php if($paynearby_feedback['rate_of_speech_reason']=="High Rate of speech or unclear speech observed") echo "selected";?>>High Rate of speech or unclear speech observed</option>
										<option value="Multiple fumbling impacting the conversation" <?php if($paynearby_feedback['rate_of_speech_reason']=="Multiple fumbling impacting the conversation") echo "selected";?>>Multiple fumbling impacting the conversation</option>
									  </select>
									</td>
									<td><input type="text" name="data[remark4]" value="<?php echo $paynearby_feedback['remark4']?>" class="form-control" disabled/></td>
								</tr>
								
								<tr>
									<td>Active Listening/Attentive On Call</td>
									<td>
										<select name="data[active_listening]" class="form-control pnb_ob_point" disabled>
											<option pnb_ob_val=6 pnb_ob_max=6 value="Good" <?php if($paynearby_feedback['active_listening']=="Good") echo "selected"; ?>>Good</option>
											<option pnb_ob_val=3 pnb_ob_max=6 value="Needs Improvement" <?php if($paynearby_feedback['active_listening']=="Needs Improvement") echo "selected"; ?>>Needs Improvement</option>
											<option pnb_ob_val=0 pnb_ob_max=6 value="Poor" <?php if($paynearby_feedback['active_listening']=="Poor") echo "selected"; ?>>Poor</option>
											<option pnb_ob_val=0 pnb_ob_max=0 value="N?A" <?php if($paynearby_feedback['active_listening']=="N/A") echo "selected"; ?>>N/A</option>
										  </select>
									</td>
									<td>
										<select class="form-control" name="data[active_listening_reason]" disabled>
											<option value="">-- SELECT --</option>
											<option value="Missed to acknowledge_needs improvement in active listening" <?php if($paynearby_feedback['active_listening_reason']=="Missed to acknowledge_needs improvement in active listening") echo "selected";?>>Missed to acknowledge_needs improvement in active listening</option>
											<option value="Not attentive_made the customer repeat multiple times" <?php if($paynearby_feedback['active_listening_reason']=="Not attentive_made the customer repeat multiple times") echo "selected";?>>Not attentive_made the customer repeat multiple times</option>
											<option value="Missed to acknowledge impacting the conversation" <?php if($paynearby_feedback['active_listening_reason']=="Missed to acknowledge impacting the conversation") echo "selected";?>>Missed to acknowledge impacting the conversation</option>
										</select>
									</td>
									<td><input type="text" name="data[remark5]" value="<?php echo $paynearby_feedback['remark5']?>" class="form-control" disabled/></td>
								</tr>
								<tr>
									<td>Interruption & Parallel Talking</td>
									<td>
										<select name="data[parallel_talking]" class="form-control pnb_ob_point" disabled>
											<option pnb_ob_val=6 pnb_ob_max=6 value="Good" <?php if($paynearby_feedback['parallel_talking']=="Good") echo "selected"; ?>>Good</option>
											<option pnb_ob_val=3 pnb_ob_max=6 value="Needs Improvement" <?php if($paynearby_feedback['parallel_talking']=="Needs Improvement") echo "selected"; ?>>Needs Improvement</option>
											<option pnb_ob_val=0 pnb_ob_max=6 value="Poor" <?php if($paynearby_feedback['parallel_talking']=="Poor") echo "selected"; ?>>Poor</option>
											<option pnb_ob_val=0 pnb_ob_max=0 value="N?A" <?php if($paynearby_feedback['parallel_talking']=="N/A") echo "selected"; ?>>N/A</option>
										  </select>
									</td>
									<td>
										<select class="form-control" name="data[parallel_talking_reason]" disabled>
											<option value="">-- SELECT --</option>
											<option value="Interruption once or unintentional interruption not impacting the conversation" <?php if($paynearby_feedback['parallel_talking_reason']=="Interruption once or unintentional interruption not impacting the conversation") echo "selected";?>>Interruption once or unintentional interruption not impacting the conversation</option>
											<option value="Interruption observed multiple times" <?php if($paynearby_feedback['parallel_talking_reason']=="Interruption observed multiple times") echo "selected";?>>Interruption observed multiple times</option>
											<option value="Interruption impacting the customer/conversation" <?php if($paynearby_feedback['parallel_talking_reason']=="Interruption impacting the customer/conversation") echo "selected";?>>Interruption impacting the customer/conversation</option>
										</select>
									</td>
									<td><input type="text" name="data[remark6]" value="<?php echo $paynearby_feedback['remark6']?>" class="form-control" disabled/></td>
								</tr>
								<tr>
									<td>Closing On Call</td>
									<td>
										<select name="data[closing_on_call]" class="form-control pnb_ob_point" disabled>
											<option pnb_ob_val=5 pnb_ob_max=5 value="Good" <?php if($paynearby_feedback['closing_on_call']=="Good") echo "selected"; ?>>Good</option>
											<option pnb_ob_val=2.5 pnb_ob_max=5 value="Needs Improvement" <?php if($paynearby_feedback['closing_on_call']=="Needs Improvement") echo "selected"; ?>>Needs Improvement</option>
											<option pnb_ob_val=0 pnb_ob_max=5 value="Poor" <?php if($paynearby_feedback['closing_on_call']=="Poor") echo "selected"; ?>>Poor</option>
											<option pnb_ob_val=0 pnb_ob_max=0 value="N/A" <?php if($paynearby_feedback['closing_on_call']=="N/A") echo "selected"; ?>>N/A</option>
										 </select>
									</td>
									
									<td>
										<select class="form-control" name="data[coc_reason]" disabled>
											<option value="">-- SELECT --</option>
											<option value="Partial closing (script not adhered)" <?php if($paynearby_feedback['coc_reason']=="Partial closing (script not adhered)") echo "selected";?>>Partial closing (script not adhered)</option>
											<option value="Fraud alert is missing on call" <?php if($paynearby_feedback['coc_reason']=="Fraud alert is missing on call") echo "selected";?>>Fraud alert is missing on call</option>
											<option value="NA" <?php if($paynearby_feedback['coc_reason']=="NA") echo "selected";?>>NA</option>
										</select>
									</td>
									<td><input type="text" name="data[remark7]" value="<?php echo $paynearby_feedback['remark7']?>" class="form-control" disabled/></td>
								</tr>
								<tr>
									<td>Hold/Mute/Transfer</td>
									<td>
										<select name="data[hmt]" class="form-control pnb_ob_point" disabled>
											<option pnb_ob_val=5 pnb_ob_max=5 value="Good" <?php if($paynearby_feedback['hmt']=="Good") echo "selected"; ?>>Good</option>
											<option pnb_ob_val=2.5 pnb_ob_max=5 value="Needs Improvement" <?php if($paynearby_feedback['hmt']=="Needs Improvement") echo "selected"; ?>>Needs Improvement</option>
											<option pnb_ob_val=0 pnb_ob_max=5 value="Poor" <?php if($paynearby_feedback['hmt']=="Poor") echo "selected"; ?>>Poor</option>
											<option pnb_ob_val=0 pnb_ob_max=0 value="N?A" <?php if($paynearby_feedback['hmt']=="N/A") echo "selected"; ?>>N/A</option>
										  </select>
									</td>
									<td>
										<select class="form-control" name="data[hmt_reason]" disabled>
											<option value="">-- SELECT --</option>
											<option value="Put call on hold without verbiage" <?php if($paynearby_feedback['hmt_reason']=="Put call on hold without verbiage") echo "selected";?>>Put call on hold without verbiage</option>
											<option value="Hold exceeded more than 1 min" <?php if($paynearby_feedback['hmt_reason']=="Hold exceeded more than 1 min") echo "selected";?>>Hold exceeded more than 1 min</option>
											<option value="Used mute instead of hold" <?php if($paynearby_feedback['hmt_reason']=="Used mute instead of hold") echo "selected";?>>Used mute instead of hold</option>
											<option value="Unnesesarily putting the call on mute" <?php if($paynearby_feedback['hmt_reason']=="Unnesesarily putting the call on mute") echo "selected";?>>Unnesesarily putting the call on mute</option>
											<option value="Lack of professionalism on call" <?php if($paynearby_feedback['hmt_reason']=="Lack of professionalism on call") echo "selected";?>>Lack of professionalism on call</option>
											<option value="Dead air >7 secs" <?php if($paynearby_feedback['hmt_reason']=="Dead air >7 secs") echo "selected";?>>Dead air >7 secs</option>
										</select>
									</td>
									<td><input type="text" name="data[remark8]" value="<?php echo $paynearby_feedback['remark8']?>" class="form-control" disabled/></td>
								</tr>
								<tr>
									<td rowspan=4 style="background-color:#A9CCE3; font-weight:bold">Business Criticality</td>
									<td>Effective Probing (open / close ended questiones to be asked whenever disabled)</td>
									<td>
										<select class="form-control pnb_ob_point" name="data[rapport_building]" disabled>
										<option pnb_ob_val=8 pnb_ob_max=8 value="Good" <?php if($paynearby_feedback['rapport_building']=="Good") echo "selected"; ?>>Good</option>
										<option pnb_ob_val=4 pnb_ob_max=8 value="Needs Improvement" <?php if($paynearby_feedback['rapport_building']=="Needs Improvement") echo "selected"; ?>>Needs Improvement</option>
										<option pnb_ob_val=0 pnb_ob_max=8 value="Poor" <?php if($paynearby_feedback['rapport_building']=="Poor") echo "selected"; ?>>Poor</option>
										<option pnb_ob_val=0 pnb_ob_max=0 value="N?A" <?php if($paynearby_feedback['rapport_building']=="N/A") echo "selected"; ?>>N/A</option>
										</select>
									</td>
									<td>
										<select class="form-control" name="data[rapport_building_reason]" disabled>
											<option value="">-- SELECT --</option>
											<option value="Probing not done when disabled" <?php if($paynearby_feedback['rapport_building_reason']=="Probing not done when disabled") echo "selected";?>>Probing not done when disabled</option>
											<option value="Probing missing leads to improper close looping" <?php if($paynearby_feedback['rapport_building_reason']=="Probing missing leads to improper close looping") echo "selected";?>>Probing missing leads to improper close looping</option>
											<option value="No effort given for rapport building" <?php if($paynearby_feedback['rapport_building_reason']=="No effort given for rapport building") echo "selected";?>>No effort given for rapport building</option>
										</select>
									</td>
									<td><input type="text" name="data[remark9]" value="<?php echo $paynearby_feedback['remark9']?>" class="form-control" disabled/></td>
								</tr>
								
								<tr>
									<td>Sales Urgency & Proper Rebuttal Given</td>
									<td>
										<select class="form-control pnb_ob_point" name="data[proper_rebuttal]" disabled>
											<option pnb_ob_val=30 pnb_ob_max=30 value="Good" <?php if($paynearby_feedback['proper_rebuttal']=="Good") echo "selected"; ?>>Good</option>
											<option pnb_ob_val=15 pnb_ob_max=30 value="Needs Improvement" <?php if($paynearby_feedback['proper_rebuttal']=="Needs Improvement") echo "selected"; ?>>Needs Improvement</option>
											<option pnb_ob_val=0 pnb_ob_max=30 value="Poor" <?php if($paynearby_feedback['proper_rebuttal']=="Poor") echo "selected"; ?>>Poor</option>
											<option pnb_ob_val=0 pnb_ob_max=0 value="N?A" <?php if($paynearby_feedback['proper_rebuttal']=="N/A") echo "selected"; ?>>N/A</option>
										</select>
									</td>
									<td>
										<select class="form-control" name="data[proper_rebuttal_reason]" disabled>
											<option value="">-- SELECT --</option>
											<option value="Full effort not given/partially done" <?php if($paynearby_feedback['proper_rebuttal_reason']=="Full effort not given/partially done") echo "selected";?>>Full effort not given/partially done</option>
											<option value="Sales urgency not created at all" <?php if($paynearby_feedback['proper_rebuttal_reason']=="Sales urgency not created at all") echo "selected";?>>Sales urgency not created at all</option>
											<option value="N/A" <?php if($paynearby_feedback['proper_rebuttal_reason']=="N/A") echo "selected";?>>N/A</option>
										</select>
									</td>
									<td><input type="text" name="data[remark10]" value="<?php echo $paynearby_feedback['remark10']?>" class="form-control" disabled/></td>
								</tr>
								<tr>
									<td style="color:red;">Agent Shared The Correct/Complete Information</td>
									<td>
										<select class="form-control pnb_ob_point pnb_ob_fatal" name="data[agent_shared_comp_info]" disabled>
											<option pnb_ob_val=2 pnb_ob_max=2 value="Good" <?php if($paynearby_feedback['agent_shared_comp_info']=="Good") echo "selected"; ?>>Good</option>
											<option pnb_ob_val=0 pnb_ob_max=2 value="Fatal" <?php if($paynearby_feedback['agent_shared_comp_info']=="Fatal") echo "selected"; ?>>Fatal</option>
										</select>
									</td>
									<td>
										<select class="form-control" name="data[as_c_info_reason]" disabled>
											<option value="">-- SELECT --</option>
											<option value="Incorrect Information" <?php if($paynearby_feedback['as_c_info_reason']=="Incorrect Information") echo "selected";?>>Incorrect Information</option>
											<option value="Incomplete Information" <?php if($paynearby_feedback['as_c_info_reason']=="Incomplete Information") echo "selected";?>>Incomplete Information</option>
											<option value="Wrong Commitment" <?php if($paynearby_feedback['as_c_info_reason']=="Wrong Commitment") echo "selected";?>>Wrong Commitment</option>
										</select>
									</td>
									<td><input type="text" name="data[remark11]" value="<?php echo $paynearby_feedback['remark11']?>" class="form-control" disabled/></td>
								</tr>
								<tr>
									<td>All Product Features Mentioned</td>
									<td>
										<select class="form-control pnb_ob_point" name="data[all_product_features]" disabled>
											<option pnb_ob_val=8 pnb_ob_max=8 value="Good" <?php if($paynearby_feedback['all_product_features']=="Good") echo "selected"; ?>>Good</option>
											<option pnb_ob_val=4 pnb_ob_max=8 value="Needs Improvement" <?php if($paynearby_feedback['all_product_features']=="Needs Improvement") echo "selected"; ?>>Needs Improvement</option>
											<option pnb_ob_val=0 pnb_ob_max=8 value="Poor" <?php if($paynearby_feedback['all_product_features']=="Poor") echo "selected"; ?>>Poor</option>
											<option pnb_ob_val=0 pnb_ob_max=0 value="N?A" <?php if($paynearby_feedback['all_product_features']=="N/A") echo "selected"; ?>>N/A</option>
										</select>
									</td>
									<td>
										<select class="form-control" name="data[apf_reason]" disabled>
											<option value="">-- SELECT --</option>
											<option value="Product explained partially" <?php if($paynearby_feedback['apf_reason']=="Product explained partially") echo "selected";?>>Product explained partially</option>
											<option value="Product explanation not done" <?php if($paynearby_feedback['apf_reason']=="Product explanation not done") echo "selected";?>>Product explanation not done</option>
											<option value="N/A" <?php if($paynearby_feedback['apf_reason']=="N/A") echo "selected";?>>N/A</option>
										</select>
									</td>
									<td><input type="text" name="data[remark12]" value="<?php echo $paynearby_feedback['remark12']?>" class="form-control" disabled/></td>
								</tr>
								<tr> 
									<td rowspan="2" style="background-color:#A9CCE3; font-weight:bold">Documentation</td>
									<td>Whether All The Information Collected And Recorded Properly</td>
									<td>
										<select class="form-control pnb_ob_point" name="data[all_info_collected]" disabled>
											<option pnb_ob_val=5 pnb_ob_max=5 value="Good" <?php if($paynearby_feedback['all_info_collected']=="Good") echo "selected"; ?>>Good</option>
											<option pnb_ob_val=2.5 pnb_ob_max=5 value="Needs Improvement" <?php if($paynearby_feedback['all_info_collected']=="Needs Improvement") echo "selected"; ?>>Needs Improvement</option>
											<option pnb_ob_val=0 pnb_ob_max=5 value="Poor" <?php if($paynearby_feedback['all_info_collected']=="Poor") echo "selected"; ?>>Poor</option>
											<option pnb_ob_val=0 pnb_ob_max=0 value="N?A" <?php if($paynearby_feedback['all_info_collected']=="N/A") echo "selected"; ?>>N/A</option>
										</select>
									</td>
									<td>
										<select class="form-control" name="data[aic_reason]" disabled>
											<option value="">-- SELECT --</option>
											<option value="Proper VOC Captured" <?php if($paynearby_feedback['aic_reason']=="Proper VOC Captured") echo "selected";?>>Proper VOC Captured</option>
											<option value="Partial VOC captured" <?php if($paynearby_feedback['aic_reason']=="Partial VOC captured") echo "selected";?>>Partial VOC captured</option>
											<option value="VOC not captured at all" <?php if($paynearby_feedback['aic_reason']=="VOC not captured at all") echo "selected";?>>VOC not captured at all</option>
										</select>
									</td>
									<td><input type="text" name="data[remark13]" value="<?php echo $paynearby_feedback['remark13']?>" class="form-control" disabled/></td>
								</tr>
								<tr>
									<td style="color:red;">Update The Vertical/Lob Issue Category & Sub Category/ Issue Category Reason/Order Id Or Transaction Id (If Any)</td>
									<td>
										<select class="form-control pnb_ob_point pnb_ob_fatal" name="data[update_the_vertical_lob]" disabled>
											<option pnb_ob_val=2 pnb_ob_max=2 value="Good" <?php if($paynearby_feedback['update_the_vertical_lob']=="Good") echo "selected"; ?>>Good</option>
											<option pnb_ob_val=0 pnb_ob_max=2 value="Fatal" <?php if($paynearby_feedback['update_the_vertical_lob']=="Fatal") echo "selected"; ?>>Fatal</option>
										</select>
									</td>
									<td>
										<select class="form-control" name="data[utvl_reason]" disabled>
											<option value="">-- SELECT --</option>
											<option value="Remarks not captured" <?php if($paynearby_feedback['utvl_reason']=="Remarks not captured") echo "selected";?>>Remarks not captured</option>
											<option value="Incomplete remarks captured" <?php if($paynearby_feedback['utvl_reason']=="Incomplete remarks captured") echo "selected";?>>Incomplete remarks captured</option>
											<option value="Tagging not done" <?php if($paynearby_feedback['utvl_reason']=="Tagging not done") echo "selected";?>>Tagging not done</option>
											<option value="Incorrect issue cat/sub cat selected" <?php if($paynearby_feedback['utvl_reason']=="Incorrect issue cat/sub cat selected") echo "selected";?>>Incorrect issue cat/sub cat selected</option>
										</select>
									</td>
									<td><input type="text" name="data[remark14]" value="<?php echo $paynearby_feedback['remark14']?>" class="form-control" disabled/></td>
								</tr>
								<tr>
									<td class="eml" style="color:red;">Zero Tolerance Policy</td>
									<td style="color:red;">Policy And Procedure Followed By The Agent As Per Ztp (Rude And Profanity Etc)</td>
									<td>
										<select class="form-control pnb_ob_point pnb_ob_fatal" name="data[ztp]" disabled>
											<option pnb_ob_val=2 pnb_ob_max=2 value="Good" <?php if($paynearby_feedback['ztp']=="Good") echo "selected"; ?>>Good</option>
											<option pnb_ob_val=0 pnb_ob_max=2 value="Fatal" <?php if($paynearby_feedback['ztp']=="Fatal") echo "selected"; ?>>Fatal</option>
										</select>
									</td>
									<td>
										<select class="form-control" name="data[ztp_reason]" disabled>
											<option value="">-- SELECT --</option>
											<option value="Rude on call" <?php if($paynearby_feedback['ztp_reason']=="Rude on call") echo "selected";?>>Rude on call</option>
											<option value="Sarcastic on call" <?php if($paynearby_feedback['ztp_reason']=="Sarcastic on call") echo "selected";?>>Sarcastic on call</option>
											<option value="Call disconnection while Cx was speaking" <?php if($paynearby_feedback['ztp_reason']=="Call disconnection while Cx was speaking") echo "selected";?>>Call disconnection while Cx was speaking</option>
											<option value="Abusive on call" <?php if($paynearby_feedback['ztp_reason']=="Abusive on call") echo "selected";?>>Abusive on call</option>
											<option value="Asking personal information with Cx" <?php if($paynearby_feedback['ztp_reason']=="Asking personal information with Cx") echo "selected";?>>Asking personal information with Cx</option>
										</select>
									</td>
									<td><input type="text" name="data[remark15]" value="<?php echo $paynearby_feedback['remark15']?>" class="form-control" disabled/></td>
								</tr>

								<tr>
									<td>Call Summary:</td>
									<td><textarea class="form-control" id="" name="data[call_summary]" disabled><?php echo $paynearby_feedback['call_summary'] ?></textarea></td>
									<td>Feedback:</td>
									<td colspan=4><textarea class="form-control" id="" name="data[feedback]" disabled><?php echo $paynearby_feedback['feedback'] ?></textarea></td>
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
												<textarea class="form-control" <?php echo $disable; ?> id="note" name="note" required><?php echo $paynearby_feedback['agent_rvw_note'] ?></textarea>
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

		</form>
		</div>

	</section>
</div>
