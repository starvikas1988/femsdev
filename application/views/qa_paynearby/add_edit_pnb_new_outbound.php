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
											if($pnboutbound['entry_by']!=''){
												$auditorName = $pnboutbound['auditor_name'];
											}else{
												$auditorName = $pnboutbound['client_name'];
											}
											$auditDate = mysql2mmddyy($pnboutbound['audit_date']);
											$clDate_val = mysql2mmddyy($pnboutbound['call_date']);
											//$go_live_date = mysql2mmddyy($pnboutbound['go_live_date']);
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
												<option value="<?php echo $pnboutbound['agent_id'] ?>"><?php echo $pnboutbound['fname']." ".$pnboutbound['lname'] ?></option>
												<option value="">-Select-</option>
												<?php foreach($agentName as $row):  ?>
													<option value="<?php echo $row['id']; ?>"><?php echo $row['name'].' ('.$row['fusion_id'].')'; ?></option>
												<?php endforeach; ?>
											</select>
										</td>
										<td>Fusion ID:</td>
										<td><input type="text" readonly class="form-control" id="fusion_id" name="" value="<?php echo $pnboutbound['fusion_id'] ?>"></td>
										<td>L1 Supervisor:</td>
										<td>
											<select class="form-control" id="tl_id" name="data[tl_id]" readonly>
												<option value="<?php echo $pnboutbound['tl_id'] ?>"><?php echo $pnboutbound['tl_name'] ?></option>
												<option value="">--Select--</option>
												<?php foreach($tlname as $tl): ?>
													<option value="<?php echo $tl['id']; ?>"><?php echo $tl['fname']." ".$tl['lname']; ?></option>
												<?php endforeach; ?>
											</select>
										</td>
									</tr>
									<tr>
										<td>Campaign:</td>
										<td><input type="text" readonly class="form-control" id="campaign" name="data[campaign]" value="<?php echo $pnboutbound['campaign'] ?>"></td>
										<td>Call Duration:</td>
										<td><input type="text" class="form-control" id="call_duration" name="data[call_duration]" value="<?php echo $pnboutbound['call_duration'] ?>" required></td>
										<td>Incoming No.:</td>
										<td><input type="text" class="form-control" id="incoming_no" name="data[incoming_no]" value="<?php echo $pnboutbound['incoming_no'] ?>" onkeyup="checkDec(this);" required></td>
									</tr>
									<tr>
										<td>Register No.:</td>
										<td><input type="text" class="form-control" id="register_no" name="data[register_no]" value="<?php echo $pnboutbound['register_no'] ?>" required></td>
										<td>Customer Name:</td>
										<td><input type="text" class="form-control" id="customer" name="data[customer]" value="<?php echo $pnboutbound['customer'] ?>" required></td>
										<td>Call Link:</td>
										<td><input type="text" class="form-control" id="call_link" name="data[call_link]" value="<?php echo $pnboutbound['call_link'] ?>" required></td>
									</tr>
									<tr>
										<td>Ticket No.:</td>
										<td><input type="text" class="form-control" id="ticket_no" name="data[ticket_no]" value="<?php echo $pnboutbound['ticket_no'] ?>" required></td>
										<td>Call Disconnect By:</td>
										<td><input type="text" class="form-control" id="call_disconnect_by" name="data[call_disconnect_by]" value="<?php echo $pnboutbound['call_disconnect_by'] ?>"  required></td>
										<td>Tagging/Disposition:</td>
										<td>
											<input type="text" class="form-control" id="" name="data[tagging]" value="<?php echo $pnboutbound['tagging'] ?>" required>
										</td>
									</tr>
									<tr>
										<td>Query/Service:</td>
										<td><input type="text" value="<?php echo $pnboutbound['query_service']?>" class="form-control" id="query_service" name="data[query_service]" required></td>
										<td>Type of Call:</td>
										<td><input type="text" class="form-control" id="call_type" name="data[call_type]" value="<?php echo $pnboutbound['call_type'] ?>" required></td>
									</tr>
									<tr>
										<td>Audit Type:</td>
										<td>
											<select class="form-control" id="audit_type" name="data[audit_type]" required>
												<option value="<?php echo $pnboutbound['audit_type'] ?>"><?php echo $pnboutbound['audit_type'] ?></option>
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
												<option value="<?php echo $pnboutbound['auditor_type'] ?>"><?php echo $pnboutbound['auditor_type'] ?></option>
												<option value="">-Select-</option>
												<option value="Master">Master</option>
												<option value="Regular">Regular</option>
											</select>
										</td>
										<td>VOC:</td>
										<td>
											<select class="form-control" id="voc" name="data[voc]" required>
												<option value="<?php echo $pnboutbound['voc'] ?>"><?php echo $pnboutbound['voc'] ?></option>
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
										<td><input type="text" readonly id="paynear_possibleScore" name="data[possible_score]" class="form-control" style="font-weight:bold" value="<?php echo $pnboutbound['possible_score'] ?>"></td>
										<td style="font-weight:bold; font-size:16px">Earned Score: </td>
										<td><input type="text" readonly id="paynear_earnedScore" name="data[earned_score]" class="form-control" style="font-weight:bold" value="<?php echo $pnboutbound['earned_score'] ?>"></td>
										<td style="font-weight:bold; font-size:16px; text-align:right">Overall Score:</td>
										<td><input type="text" readonly id="pnb_ob_overallScore" name="data[overall_score]" class="form-control pnboutboundFatal" style="font-weight:bold" value="<?php echo $pnboutbound['overall_score'] ?>"></td>
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
										  <select name="data[standard_call_opening]" class="form-control pnb_ob_point" required>
											<option pnb_ob_val=6 pnb_ob_max=6 value="Good" <?php if($pnboutbound['standard_call_opening']=="Good") echo "selected"; ?>>Good</option>
											<option pnb_ob_val=3 pnb_ob_max=6 value="Needs Improvement" <?php if($pnboutbound['standard_call_opening']=="Needs Improvement") echo "selected"; ?>>Needs Improvement</option>
											<option pnb_ob_val=0 pnb_ob_max=6 value="Poor" <?php if($pnboutbound['standard_call_opening']=="Poor") echo "selected"; ?>>Poor</option>
											<option pnb_ob_val=0 pnb_ob_max=0 value="N/A" <?php if($pnboutbound['standard_call_opening']=="N/A") echo "selected";?>>N/A</option>
										  </select>
									</td>
									<td>
									  <select class="form-control" name="data[sco_reason]">
										<option value="">-- SELECT --</option>
										<option value="Opening Script Adhered" <?php if($pnboutbound['sco_reason']=="Opening Script Adhered") echo "selected";?>>Opening Script Adhered</option>
										<option value="Branding/Cx name confirmation done but missed few info" <?php if($pnboutbound['sco_reason']=="Branding/Cx name confirmation done but missed few info") echo "selected";?>>Branding/Cx name confirmation done but missed few info</option>
										<option value="Branding is missing" <?php if($pnboutbound['sco_reason']=="Branding is missing") echo "selected";?>>Branding is missing</option>
										<option value="Cx name confirmation not done" <?php if($pnboutbound['sco_reason']=="Cx name confirmation not done") echo "selected";?>>Cx name confirmation not done</option>
										<option value="Permission not taken" <?php if($pnboutbound['sco_reason']=="Permission not taken") echo "selected";?>>Permission not taken</option>
									  </select>
									</td>
									<td><input type="text" name="data[remark1]" value="<?php echo $pnboutbound['remark1']?>" class="form-control"/></td>
								</tr>
								<tr>
									<td>Appropriate Empathy/Apology Wherever Applicable / Professional Tone / Assurance</td>
									<td>
									  <select name="data[appr_empathy_apology]" class="form-control pnb_ob_point" required>
										<option pnb_ob_val=5 pnb_ob_max=5 value="Good" <?php if($pnboutbound['appr_empathy_apology']=="Good") echo "selected"; ?>>Good</option>
										<option pnb_ob_val=2.5 pnb_ob_max=5 value="Needs Improvement" <?php if($pnboutbound['appr_empathy_apology']=="Needs Improvement") echo "selected"; ?>>Needs Improvement</option>
										<option pnb_ob_val=0 pnb_ob_max=5 value="Poor" <?php if($pnboutbound['appr_empathy_apology']=="Poor") echo "selected"; ?>>Poor</option>
										<option pnb_ob_val=0 pnb_ob_max=0 value="N/A" <?php if($pnboutbound['appr_empathy_apology']=="N/A") echo "selected"; ?>>N/A</option>
									  </select>
									</td>
									<td>
									  <select class="form-control" name="data[appr_emp_ap_reason]">
										<option value="">-- SELECT --</option>
										<option value="Empathy/apology available wherever applicable" <?php if($pnboutbound['appr_emp_ap_reason']=="Empathy/apology available wherever applicable") echo "selected";?>>Empathy/apology available wherever applicable</option>
										<option value="Empathy/apology unavailable wherever applicable" <?php if($pnboutbound['appr_emp_ap_reason']=="Empathy/apology unavailable wherever applicable") echo "selected";?>>Empathy/apology unavailable wherever applicable</option>
										<option value="Empathy not shown multiple times wherever applicable" <?php if($pnboutbound['appr_emp_ap_reason']=="Empathy not shown multiple times wherever applicable") echo "selected";?>>Empathy not shown multiple times wherever applicable</option>
									  </select>
									</td>
									<td><input type="text" name="data[remark2]" value="<?php echo $pnboutbound['remark2']?>" class="form-control"/></td>
								</tr>
								
								<tr>
									<td>Personalization & Connect</td>
									<td>
									  <select name="data[personalization_connect]" class="form-control pnb_ob_point" required>
										<option pnb_ob_val=5 pnb_ob_max=5 value="Good" <?php if($pnboutbound['personalization_connect']=="Good") echo "selected"; ?>>Good</option>
										<option pnb_ob_val=2.5 pnb_ob_max=5 value="Needs Improvement" <?php if($pnboutbound['personalization_connect']=="Needs Improvement") echo "selected"; ?>>Needs Improvement</option>
										<option pnb_ob_val=0 pnb_ob_max=5 value="Poor" <?php if($pnboutbound['personalization_connect']=="Poor") echo "selected"; ?>>Poor</option>
										<option pnb_ob_val=0 pnb_ob_max=0 value="N/A" <?php if($pnboutbound['personalization_connect']=="N/A") echo "selected"; ?>>N/A</option>
									  </select>
									</td>
									<td>
									  <select class="form-control" name="data[personalization_connect_reason]">
										<option value="">-- SELECT --</option>
										<option value="Incorrect sentence formation impacting conversation" <?php if($pnboutbound['personalization_connect_reason']=="Incorrect sentence formation impacting conversation") echo "selected";?>>Incorrect sentence formation impacting conversation</option>
										<option value="Incorrect sentence formation not impacting conversation" <?php if($pnboutbound['personalization_connect_reason']=="Incorrect sentence formation not impacting conversation") echo "selected";?>>Incorrect sentence formation not impacting conversation</option>
									  </select>
									</td>
									<td><input type="text" name="data[remark3]" value="<?php echo $pnboutbound['remark3']?>" class="form-control"/></td>
								</tr>
								<tr>
									<td>Rate of Speech / Clarity Of Speech / Jargons</td>
									<td>
									  <select name="data[rate_of_speech]" class="form-control pnb_ob_point" required>
										<option pnb_ob_val=5 pnb_ob_max=5 value="Good" <?php if($pnboutbound['rate_of_speech']=="Good") echo "selected"; ?>>Good</option>
										<option pnb_ob_val=2.5 pnb_ob_max=5 value="Needs Improvement" <?php if($pnboutbound['rate_of_speech']=="Needs Improvement") echo "selected"; ?>>Needs Improvement</option>
										<option pnb_ob_val=0 pnb_ob_max=5 value="Poor" <?php if($pnboutbound['rate_of_speech']=="Poor") echo "selected"; ?>>Poor</option>
										<option pnb_ob_val=0 pnb_ob_max=0 value="N/A" <?php if($pnboutbound['rate_of_speech']=="N/A") echo "selected"; ?>>N/A</option>
									  </select>
									</td>
									<td>
									  <select class="form-control" name="data[rate_of_speech_reason]">
										<option value="">-- SELECT --</option>
										<option value="Rate of speech a bit high but not impacting the conversastion" <?php if($pnboutbound['rate_of_speech_reason']=="Rate of speech a bit high but not impacting the conversastion") echo "selected";?>>Rate of speech a bit high but not impacting the conversastion</option>
										<option value="Not energetic tone throughout the call" <?php if($pnboutbound['rate_of_speech_reason']=="Not energetic tone throughout the call") echo "selected";?>>Not energetic tone throughout the call</option>
										<option value="Filler /Fumbling on call" <?php if($pnboutbound['rate_of_speech_reason']=="Filler /Fumbling on call") echo "selected";?>>Filler /Fumbling on call</option>
										<option value="High Rate of speech or unclear speech observed" <?php if($pnboutbound['rate_of_speech_reason']=="High Rate of speech or unclear speech observed") echo "selected";?>>High Rate of speech or unclear speech observed</option>
										<option value="Multiple fumbling impacting the conversation" <?php if($pnboutbound['rate_of_speech_reason']=="Multiple fumbling impacting the conversation") echo "selected";?>>Multiple fumbling impacting the conversation</option>
									  </select>
									</td>
									<td><input type="text" name="data[remark4]" value="<?php echo $pnboutbound['remark4']?>" class="form-control"/></td>
								</tr>
								
								<tr>
									<td>Active Listening/Attentive On Call</td>
									<td>
										<select name="data[active_listening]" class="form-control pnb_ob_point" required>
											<option pnb_ob_val=6 pnb_ob_max=6 value="Good" <?php if($pnboutbound['active_listening']=="Good") echo "selected"; ?>>Good</option>
											<option pnb_ob_val=3 pnb_ob_max=6 value="Needs Improvement" <?php if($pnboutbound['active_listening']=="Needs Improvement") echo "selected"; ?>>Needs Improvement</option>
											<option pnb_ob_val=0 pnb_ob_max=6 value="Poor" <?php if($pnboutbound['active_listening']=="Poor") echo "selected"; ?>>Poor</option>
											<option pnb_ob_val=0 pnb_ob_max=0 value="N/A" <?php if($pnboutbound['active_listening']=="N/A") echo "selected"; ?>>N/A</option>
										  </select>
									</td>
									<td>
										<select class="form-control" name="data[active_listening_reason]">
											<option value="">-- SELECT --</option>
											<option value="Missed to acknowledge_needs improvement in active listening" <?php if($pnboutbound['active_listening_reason']=="Missed to acknowledge_needs improvement in active listening") echo "selected";?>>Missed to acknowledge_needs improvement in active listening</option>
											<option value="Not attentive_made the customer repeat multiple times" <?php if($pnboutbound['active_listening_reason']=="Not attentive_made the customer repeat multiple times") echo "selected";?>>Not attentive_made the customer repeat multiple times</option>
											<option value="Missed to acknowledge impacting the conversation" <?php if($pnboutbound['active_listening_reason']=="Missed to acknowledge impacting the conversation") echo "selected";?>>Missed to acknowledge impacting the conversation</option>
										</select>
									</td>
									<td><input type="text" name="data[remark5]" value="<?php echo $pnboutbound['remark5']?>" class="form-control"/></td>
								</tr>
								<tr>
									<td>Interruption & Parallel Talking</td>
									<td>
										<select name="data[parallel_talking]" class="form-control pnb_ob_point" required>
											<option pnb_ob_val=6 pnb_ob_max=6 value="Good" <?php if($pnboutbound['parallel_talking']=="Good") echo "selected"; ?>>Good</option>
											<option pnb_ob_val=3 pnb_ob_max=6 value="Needs Improvement" <?php if($pnboutbound['parallel_talking']=="Needs Improvement") echo "selected"; ?>>Needs Improvement</option>
											<option pnb_ob_val=0 pnb_ob_max=6 value="Poor" <?php if($pnboutbound['parallel_talking']=="Poor") echo "selected"; ?>>Poor</option>
											<option pnb_ob_val=0 pnb_ob_max=0 value="N/A" <?php if($pnboutbound['parallel_talking']=="N/A") echo "selected"; ?>>N/A</option>
										  </select>
									</td>
									<td>
										<select class="form-control" name="data[parallel_talking_reason]">
											<option value="">-- SELECT --</option>
											<option value="Interruption once or unintentional interruption not impacting the conversation" <?php if($pnboutbound['parallel_talking_reason']=="Interruption once or unintentional interruption not impacting the conversation") echo "selected";?>>Interruption once or unintentional interruption not impacting the conversation</option>
											<option value="Interruption observed multiple times" <?php if($pnboutbound['parallel_talking_reason']=="Interruption observed multiple times") echo "selected";?>>Interruption observed multiple times</option>
											<option value="Interruption impacting the customer/conversation" <?php if($pnboutbound['parallel_talking_reason']=="Interruption impacting the customer/conversation") echo "selected";?>>Interruption impacting the customer/conversation</option>
										</select>
									</td>
									<td><input type="text" name="data[remark6]" value="<?php echo $pnboutbound['remark6']?>" class="form-control"/></td>
								</tr>
								<tr>
									<td>Closing On Call</td>
									<td>
										<select name="data[closing_on_call]" class="form-control pnb_ob_point" required>
											<option pnb_ob_val=5 pnb_ob_max=5 value="Good" <?php if($pnboutbound['closing_on_call']=="Good") echo "selected"; ?>>Good</option>
											<option pnb_ob_val=2.5 pnb_ob_max=5 value="Needs Improvement" <?php if($pnboutbound['closing_on_call']=="Needs Improvement") echo "selected"; ?>>Needs Improvement</option>
											<option pnb_ob_val=0 pnb_ob_max=5 value="Poor" <?php if($pnboutbound['closing_on_call']=="Poor") echo "selected"; ?>>Poor</option>
											<option pnb_ob_val=0 pnb_ob_max=0 value="N/A" <?php if($pnboutbound['closing_on_call']=="N/A") echo "selected"; ?>>N/A</option>
										 </select>
									</td>
									
									<td>
										<select class="form-control" name="data[coc_reason]">
											<option value="">-- SELECT --</option>
											<option value="Partial closing (script not adhered)" <?php if($pnboutbound['coc_reason']=="Partial closing (script not adhered)") echo "selected";?>>Partial closing (script not adhered)</option>
											<option value="Fraud alert is missing on call" <?php if($pnboutbound['coc_reason']=="Fraud alert is missing on call") echo "selected";?>>Fraud alert is missing on call</option>
											<option value="NA" <?php if($pnboutbound['coc_reason']=="NA") echo "selected";?>>NA</option>
										</select>
									</td>
									<td><input type="text" name="data[remark7]" value="<?php echo $pnboutbound['remark7']?>" class="form-control"/></td>
								</tr>
								<tr>
									<td>Hold/Mute/Transfer</td>
									<td>
										<select name="data[hmt]" class="form-control pnb_ob_point" required>
											<option pnb_ob_val=5 pnb_ob_max=5 value="Good" <?php if($pnboutbound['hmt']=="Good") echo "selected"; ?>>Good</option>
											<option pnb_ob_val=2.5 pnb_ob_max=5 value="Needs Improvement" <?php if($pnboutbound['hmt']=="Needs Improvement") echo "selected"; ?>>Needs Improvement</option>
											<option pnb_ob_val=0 pnb_ob_max=5 value="Poor" <?php if($pnboutbound['hmt']=="Poor") echo "selected"; ?>>Poor</option>
											<option pnb_ob_val=0 pnb_ob_max=0 value="N/A" <?php if($pnboutbound['hmt']=="N/A") echo "selected"; ?>>N/A</option>
										  </select>
									</td>
									<td>
										<select class="form-control" name="data[hmt_reason]">
											<option value="">-- SELECT --</option>
											<option value="Put call on hold without verbiage" <?php if($pnboutbound['hmt_reason']=="Put call on hold without verbiage") echo "selected";?>>Put call on hold without verbiage</option>
											<option value="Hold exceeded more than 1 min" <?php if($pnboutbound['hmt_reason']=="Hold exceeded more than 1 min") echo "selected";?>>Hold exceeded more than 1 min</option>
											<option value="Used mute instead of hold" <?php if($pnboutbound['hmt_reason']=="Used mute instead of hold") echo "selected";?>>Used mute instead of hold</option>
											<option value="Unnesesarily putting the call on mute" <?php if($pnboutbound['hmt_reason']=="Unnesesarily putting the call on mute") echo "selected";?>>Unnesesarily putting the call on mute</option>
											<option value="Lack of professionalism on call" <?php if($pnboutbound['hmt_reason']=="Lack of professionalism on call") echo "selected";?>>Lack of professionalism on call</option>
											<option value="Dead air >7 secs" <?php if($pnboutbound['hmt_reason']=="Dead air >7 secs") echo "selected";?>>Dead air >7 secs</option>
										</select>
									</td>
									<td><input type="text" name="data[remark8]" value="<?php echo $pnboutbound['remark8']?>" class="form-control"/></td>
								</tr>
								<tr>
									<td rowspan=4 style="background-color:#A9CCE3; font-weight:bold">Business Criticality</td>
									<td>Effective Probing (open / close ended questiones to be asked whenever required)</td>
									<td>
										<select class="form-control pnb_ob_point" name="data[rapport_building]" required>
										<option pnb_ob_val=8 pnb_ob_max=8 value="Good" <?php if($pnboutbound['rapport_building']=="Good") echo "selected"; ?>>Good</option>
										<option pnb_ob_val=4 pnb_ob_max=8 value="Needs Improvement" <?php if($pnboutbound['rapport_building']=="Needs Improvement") echo "selected"; ?>>Needs Improvement</option>
										<option pnb_ob_val=0 pnb_ob_max=8 value="Poor" <?php if($pnboutbound['rapport_building']=="Poor") echo "selected"; ?>>Poor</option>
										<option pnb_ob_val=0 pnb_ob_max=0 value="N/A" <?php if($pnboutbound['rapport_building']=="N/A") echo "selected"; ?>>N/A</option>
										</select>
									</td>
									<td>
										<select class="form-control" name="data[rapport_building_reason]">
											<option value="">-- SELECT --</option>
											<option value="Probing not done when required" <?php if($pnboutbound['rapport_building_reason']=="Probing not done when required") echo "selected";?>>Probing not done when required</option>
											<option value="Probing missing leads to improper close looping" <?php if($pnboutbound['rapport_building_reason']=="Probing missing leads to improper close looping") echo "selected";?>>Probing missing leads to improper close looping</option>
											<option value="No effort given for rapport building" <?php if($pnboutbound['rapport_building_reason']=="No effort given for rapport building") echo "selected";?>>No effort given for rapport building</option>
										</select>
									</td>
									<td><input type="text" name="data[remark9]" value="<?php echo $pnboutbound['remark9']?>" class="form-control"/></td>
								</tr>
								
								<tr>
									<td>Sales Urgency & Proper Rebuttal Given</td>
									<td>
										<select class="form-control pnb_ob_point" name="data[proper_rebuttal]" required>
											<option pnb_ob_val=30 pnb_ob_max=30 value="Good" <?php if($pnboutbound['proper_rebuttal']=="Good") echo "selected"; ?>>Good</option>
											<option pnb_ob_val=15 pnb_ob_max=30 value="Needs Improvement" <?php if($pnboutbound['proper_rebuttal']=="Needs Improvement") echo "selected"; ?>>Needs Improvement</option>
											<option pnb_ob_val=0 pnb_ob_max=30 value="Poor" <?php if($pnboutbound['proper_rebuttal']=="Poor") echo "selected"; ?>>Poor</option>
											<option pnb_ob_val=0 pnb_ob_max=0 value="N/A" <?php if($pnboutbound['proper_rebuttal']=="N/A") echo "selected"; ?>>N/A</option>
										</select>
									</td>
									<td>
										<select class="form-control" name="data[proper_rebuttal_reason]">
											<option value="">-- SELECT --</option>
											<option value="Full effort not given/partially done" <?php if($pnboutbound['proper_rebuttal_reason']=="Full effort not given/partially done") echo "selected";?>>Full effort not given/partially done</option>
											<option value="Sales urgency not created at all" <?php if($pnboutbound['proper_rebuttal_reason']=="Sales urgency not created at all") echo "selected";?>>Sales urgency not created at all</option>
											<option value="N/A" <?php if($pnboutbound['proper_rebuttal_reason']=="N/A") echo "selected";?>>N/A</option>
										</select>
									</td>
									<td><input type="text" name="data[remark10]" value="<?php echo $pnboutbound['remark10']?>" class="form-control"/></td>
								</tr>
								<tr>
									<td style="color:red;">Agent Shared The Correct/Complete Information</td>
									<td>
										<select class="form-control pnb_ob_point pnb_ob_fatal" name="data[agent_shared_comp_info]" required>
											<option pnb_ob_val=2 pnb_ob_max=2 value="Good" <?php if($pnboutbound['agent_shared_comp_info']=="Good") echo "selected"; ?>>Good</option>
											<option pnb_ob_val=0 pnb_ob_max=2 value="Fatal" <?php if($pnboutbound['agent_shared_comp_info']=="Fatal") echo "selected"; ?>>Fatal</option>
										</select>
									</td>
									<td>
										<select class="form-control" name="data[as_c_info_reason]">
											<option value="">-- SELECT --</option>
											<option value="Incorrect Information" <?php if($pnboutbound['as_c_info_reason']=="Incorrect Information") echo "selected";?>>Incorrect Information</option>
											<option value="Incomplete Information" <?php if($pnboutbound['as_c_info_reason']=="Incomplete Information") echo "selected";?>>Incomplete Information</option>
											<option value="Wrong Commitment" <?php if($pnboutbound['as_c_info_reason']=="Wrong Commitment") echo "selected";?>>Wrong Commitment</option>
										</select>
									</td>
									<td><input type="text" name="data[remark11]" value="<?php echo $pnboutbound['remark11']?>" class="form-control"/></td>
								</tr>
								<tr>
									<td>All Product Features Mentioned</td>
									<td>
										<select class="form-control pnb_ob_point" name="data[all_product_features]" required>
											<option pnb_ob_val=8 pnb_ob_max=8 value="Good" <?php if($pnboutbound['all_product_features']=="Good") echo "selected"; ?>>Good</option>
											<option pnb_ob_val=4 pnb_ob_max=8 value="Needs Improvement" <?php if($pnboutbound['all_product_features']=="Needs Improvement") echo "selected"; ?>>Needs Improvement</option>
											<option pnb_ob_val=0 pnb_ob_max=8 value="Poor" <?php if($pnboutbound['all_product_features']=="Poor") echo "selected"; ?>>Poor</option>
											<option pnb_ob_val=0 pnb_ob_max=0 value="N/A" <?php if($pnboutbound['all_product_features']=="N/A") echo "selected"; ?>>N/A</option>
										</select>
									</td>
									<td>
										<select class="form-control" name="data[apf_reason]">
											<option value="">-- SELECT --</option>
											<option value="Product explained partially" <?php if($pnboutbound['apf_reason']=="Product explained partially") echo "selected";?>>Product explained partially</option>
											<option value="Product explanation not done" <?php if($pnboutbound['apf_reason']=="Product explanation not done") echo "selected";?>>Product explanation not done</option>
											<option value="N/A" <?php if($pnboutbound['apf_reason']=="N/A") echo "selected";?>>N/A</option>
										</select>
									</td>
									<td><input type="text" name="data[remark12]" value="<?php echo $pnboutbound['remark12']?>" class="form-control"/></td>
								</tr>
								<tr>
									<td rowspan="2" style="background-color:#A9CCE3; font-weight:bold">Documentation</td>
									<td>Whether All The Information Collected And Recorded Properly</td>
									<td>
										<select class="form-control pnb_ob_point" name="data[all_info_collected]" required>
											<option pnb_ob_val=5 pnb_ob_max=5 value="Good" <?php if($pnboutbound['all_info_collected']=="Good") echo "selected"; ?>>Good</option>
											<option pnb_ob_val=2.5 pnb_ob_max=5 value="Needs Improvement" <?php if($pnboutbound['all_info_collected']=="Needs Improvement") echo "selected"; ?>>Needs Improvement</option>
											<option pnb_ob_val=0 pnb_ob_max=5 value="Poor" <?php if($pnboutbound['all_info_collected']=="Poor") echo "selected"; ?>>Poor</option>
											<option pnb_ob_val=0 pnb_ob_max=0 value="N/A" <?php if($pnboutbound['all_info_collected']=="N/A") echo "selected"; ?>>N/A</option>
										</select>
									</td>
									<td>
										<select class="form-control" name="data[aic_reason]">
											<option value="">-- SELECT --</option>
											<option value="Proper VOC Captured" <?php if($pnboutbound['aic_reason']=="Proper VOC Captured") echo "selected";?>>Proper VOC Captured</option>
											<option value="Partial VOC captured" <?php if($pnboutbound['aic_reason']=="Partial VOC captured") echo "selected";?>>Partial VOC captured</option>
											<option value="VOC not captured at all" <?php if($pnboutbound['aic_reason']=="VOC not captured at all") echo "selected";?>>VOC not captured at all</option>
										</select>
									</td>
									<td><input type="text" name="data[remark13]" value="<?php echo $pnboutbound['remark13']?>" class="form-control"/></td>
								</tr>
								<tr>
									<td style="color:red;">Update The Vertical/Lob Issue Category & Sub Category/ Issue Category Reason/Order Id Or Transaction Id (If Any)</td>
									<td>
										<select class="form-control pnb_ob_point pnb_ob_fatal" name="data[update_the_vertical_lob]" required>
											<option pnb_ob_val=2 pnb_ob_max=2 value="Good" <?php if($pnboutbound['update_the_vertical_lob']=="Good") echo "selected"; ?>>Good</option>
											<option pnb_ob_val=0 pnb_ob_max=2 value="Fatal" <?php if($pnboutbound['update_the_vertical_lob']=="Fatal") echo "selected"; ?>>Fatal</option>
										</select>
									</td>
									<td>
										<select class="form-control" name="data[utvl_reason]">
											<option value="">-- SELECT --</option>
											<option value="Remarks not captured" <?php if($pnboutbound['utvl_reason']=="Remarks not captured") echo "selected";?>>Remarks not captured</option>
											<option value="Incomplete remarks captured" <?php if($pnboutbound['utvl_reason']=="Incomplete remarks captured") echo "selected";?>>Incomplete remarks captured</option>
											<option value="Tagging not done" <?php if($pnboutbound['utvl_reason']=="Tagging not done") echo "selected";?>>Tagging not done</option>
											<option value="Incorrect issue cat/sub cat selected" <?php if($pnboutbound['utvl_reason']=="Incorrect issue cat/sub cat selected") echo "selected";?>>Incorrect issue cat/sub cat selected</option>
										</select>
									</td>
									<td><input type="text" name="data[remark14]" value="<?php echo $pnboutbound['remark14']?>" class="form-control"/></td>
								</tr>
								<tr>
									<td class="eml" style="color:red;">Zero Tolerance Policy</td>
									<td style="color:red;">Policy And Procedure Followed By The Agent As Per Ztp (Rude And Profanity Etc)</td>
									<td>
										<select class="form-control pnb_ob_point pnb_ob_fatal" name="data[ztp]" required>
											<option pnb_ob_val=2 pnb_ob_max=2 value="Good" <?php if($pnboutbound['ztp']=="Good") echo "selected"; ?>>Good</option>
											<option pnb_ob_val=0 pnb_ob_max=2 value="Fatal" <?php if($pnboutbound['ztp']=="Fatal") echo "selected"; ?>>Fatal</option>
										</select>
									</td>
									<td>
										<select class="form-control" name="data[ztp_reason]">
											<option value="">-- SELECT --</option>
											<option value="Rude on call" <?php if($pnboutbound['ztp_reason']=="Rude on call") echo "selected";?>>Rude on call</option>
											<option value="Sarcastic on call" <?php if($pnboutbound['ztp_reason']=="Sarcastic on call") echo "selected";?>>Sarcastic on call</option>
											<option value="Call disconnection while Cx was speaking" <?php if($pnboutbound['ztp_reason']=="Call disconnection while Cx was speaking") echo "selected";?>>Call disconnection while Cx was speaking</option>
											<option value="Abusive on call" <?php if($pnboutbound['ztp_reason']=="Abusive on call") echo "selected";?>>Abusive on call</option>
											<option value="Asking personal information with Cx" <?php if($pnboutbound['ztp_reason']=="Asking personal information with Cx") echo "selected";?>>Asking personal information with Cx</option>
										</select>
									</td>
									<td><input type="text" name="data[remark15]" value="<?php echo $pnboutbound['remark15']?>" class="form-control"/></td>
								</tr>
								
								<tr>
									<td>Call Summary:</td>
									<td><textarea class="form-control1" style="width:450px" name="data[call_summary]"><?php echo $pnboutbound['call_summary'] ?></textarea></td>
									<td>Feedback:</td>
									<td colspan=4><textarea class="form-control1" style="width:450px" name="data[feedback]"><?php echo $pnboutbound['feedback'] ?></textarea></td>
								</tr>
								<tr>
									<td colspan=2>Upload Files (wav,wmv,mp3,mp4)</td>
									<?php if($pnboutbound_id==0){ ?>
										<td colspan=2><input type="file" multiple class="form-control audioFile" id="fileuploadbasic" name="attach_file[]" ></td>
									<?php }else{ ?>
										<td colspan=2><input type="file" multiple class="form-control audioFile" name="attach_file[]" ></td>
										<td colspan=2>
											<?php if($pnboutbound['attach_file']!=''){
												$attach_file = explode(",",$pnboutbound['attach_file']);
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
										<tr><td colspan=2 style="font-size:16px; font-weight:bold">Agent Feedback Acceptance:</td><td colspan=4><?php echo $pnboutbound['agnt_fd_acpt'] ?></td></tr>
										<tr><td colspan=2 style="font-size:16px; font-weightbold">Agent Review:</td><td colspan=4><?php echo $pnboutbound['agent_rvw_note'] ?></td></tr>
										<tr><td colspan=2 style="font-size:16px; font-weight:bold">Management Review:</td><td colspan=4><?php echo $pnboutbound['mgnt_rvw_note'] ?></td></tr>
										<tr><td colspan=2 style="font-size:16px; font-weight:bold">Client Review:</td><td colspan=4><?php echo $pnboutbound['client_rvw_note'] ?></td></tr>

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
											if(is_available_qa_feedback($pnboutbound['entry_date'],72) == true){ ?>
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