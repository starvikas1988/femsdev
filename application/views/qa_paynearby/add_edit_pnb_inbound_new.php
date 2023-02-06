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

<?php if($pnb_inb_id!=0){
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
									<tr style="background-color:#AEB6BF">
									<?php
										if($lob=='kyc') $hdr_lob='INBOUND KYC';
										else if($lob=='inb') $hdr_lob='INBOUND';
									?>
										<td colspan="6" id="theader" style="font-size:30px">Paynear By - <?php echo $hdr_lob ?></td>
										<?php
										if($pnb_inb_id==0){
											$auditorName = get_username();
											$auditDate = CurrDateMDY();
											$clDate_val='';
										}else{
											if($pnbinbound['entry_by']!=''){
												$auditorName = $pnbinbound['auditor_name'];
											}else{
												$auditorName = $pnbinbound['client_name'];
											}
											$auditDate = mysql2mmddyy($pnbinbound['audit_date']);
											$clDate_val = mysql2mmddyy($pnbinbound['call_date']);
										}
									?>
										<input type="hidden" name="audit_start_time" value="<?php echo CurrMySqlDate(); ?>">
									</tr>
									<tr>
										<td>QA Name:</td>
										<td><input type="text" class="form-control" value="<?php echo get_username(); ?>" disabled></td>
										<td>Audit Date:</td>
										<td><input type="text" class="form-control" value="<?php echo CurrDateMDY(); ?>" disabled></td>
										<td>Call Date/Time:</td>
										<td><input type="text" class="form-control" id="call_date_time" name="call_date" value="<?php echo $clDate_val; ?>" required></td>
									</tr>
									<tr>
										<td>Agent:</td>
										<td>
											<select class="form-control agentName" id="agent_id" name="data[agent_id]" required>
												<option value="<?php echo $pnbinbound['agent_id'] ?>"><?php echo $pnbinbound['fname']." ".$pnbinbound['lname'] ?></option>
												<option value="">-Select-</option>
												<?php foreach($agentName as $row):  ?>
													<option value="<?php echo $row['id']; ?>"><?php echo $row['name'].' ('.$row['fusion_id'].')'; ?></option>
												<?php endforeach; ?>
											</select>
										</td>
										<td>Fusion ID:</td>
										<td><input type="text" readonly class="form-control" id="fusion_id" name="" value="<?php echo $pnbinbound['fusion_id'] ?>"></td>
										<td>L1 Supervisor:</td>
										<td>
											<select class="form-control" id="tl_id" name="data[tl_id]" readonly>
												<option value="<?php echo $pnbinbound['tl_id'] ?>"><?php echo $pnbinbound['tl_name'] ?></option>
												<option value="">--Select--</option>
												<?php foreach($tlname as $tl): ?>
													<option value="<?php echo $tl['id']; ?>"><?php echo $tl['fname']." ".$tl['lname']; ?></option>
												<?php endforeach; ?>
											</select>
										</td>
									</tr>
									<tr>
										<td>Campaign:</td>
										<td><input type="text" readonly class="form-control" id="campaign" name="data[campaign]" value="<?php echo $pnbinbound['campaign'] ?>"></td>
										<td>Call Duration:</td>
										<td><input type="text" class="form-control" id="call_duration" name="data[call_duration]" value="<?php echo $pnbinbound['call_duration'] ?>" required></td>
										<td>Incoming No.:</td>
										<td><input type="text" class="form-control" id="incoming_no" name="data[incoming_no]" value="<?php echo $pnbinbound['incoming_no'] ?>" onkeyup="checkDec(this);" required></td>
									</tr>
									<tr>
										<td>Register No.:</td>
										<td><input type="text" class="form-control" id="register_no" name="data[register_no]" value="<?php echo $pnbinbound['register_no'] ?>" required></td>
										<?php if($lob=='kyc'){ ?>
										<td>ACPT:</td>
										<td><input type="text" class="form-control" id="customer" name="data[customer]" value="<?php echo $pnbinbound['customer'] ?>" required></td>
										<?php }else{
											?>
										<td>ACPT:</td>
										<td><input type="text" class="form-control" id="customer" name="data[customer]" value="<?php echo $pnbinbound['customer'] ?>" required></td>
											<?php
										} ?>	
										
										<td>Call Link:</td>
										<td><input type="text" class="form-control" id="call_link" name="data[call_link]" value="<?php echo $pnbinbound['call_link'] ?>" required></td>
									</tr>
									<tr>
										<td>Ticket No.:</td>
										<td><input type="text" class="form-control" id="ticket_no" name="data[ticket_no]" value="<?php echo $pnbinbound['ticket_no'] ?>" required></td>
										<td>Call Disconnect By:</td>
										<td>
										  <select class="form-control" name="data[call_disconnect_by]" required>
											<option value="">Select</option>
											<option value="Caller" <?= ($pnbinbound['call_disconnect_by']=="Caller")?"selected":""?>>Caller</option>
											<option value="Caller" <?= ($pnbinbound['call_disconnect_by']=="Agent")?"selected":""?>>Agent</option>
											<option value="Caller" <?= ($pnbinbound['call_disconnect_by']=="System")?"selected":""?>>System</option>
										  </select>
										</td>
										<td>Tagging/Disposition:</td>
										<td>
											<input type="text" class="form-control" id="" name="data[tagging]" value="<?php echo $pnbinbound['tagging'] ?>" required>
										</td>
									</tr>
									<tr>
										<td>Query/Complaint/Others:</td>
										<td>
											<select class="form-control" id="query_service" name="data[query_service]" required>
												<option value="">Select</option>
												<option value="Query" <?= ($pnbinbound['query_service']=="Query")?"selected":""?>>Query</option>
												<option value="Complaint" <?= ($pnbinbound['query_service']=="Complaint")?"selected":""?>>Complaint</option>
												<option value="Others" <?= ($pnbinbound['query_service']=="Others")?"selected":""?>>Others</option>
											</select>
										</td>
										<td>Type of Call:</td>
										<td><input type="text" class="form-control" id="call_type" name="data[call_type]" value="<?php echo $pnbinbound['call_type'] ?>" required></td>
										<td>VOC:</td>
										<td><input type="text" class="form-control" name="data[customer_voc]" value="<?php echo $pnbinbound['customer_voc'] ?>" required></td>
									</tr>
									<tr>
										<td>Issue Resolved?:</td>
										<td>
											<select class="form-control" name="data[issue_resolved]" required>
												<option value="">Select</option>
												<option value="Yes" <?= ($pnbinbound['issue_resolved']=="Yes")?"selected":""?>>Yes</option>
												<option value="No" <?= ($pnbinbound['issue_resolved']=="No")?"selected":""?>>No</option>
											</select>
										</td>
										<td>Customer came with (mood):</td>
										<td>
											<select class="form-control" name="data[customer_came_withmood]" required>
												<option value="">Select</option>
												<option value="Happy" <?= ($pnbinbound['customer_came_withmood']=="Happy")?"selected":""?>>Happy</option>
												<option value="Not Happy" <?= ($pnbinbound['customer_came_withmood']=="Not Happy")?"selected":""?>>Not Happy</option>
												<option value="Neutral" <?= ($pnbinbound['customer_came_withmood']=="Neutral")?"selected":""?>>Neutral</option>
												<option value="Extremely Dissatisfied" <?= ($pnbinbound['customer_came_withmood']=="Extremely Dissatisfied")?"selected":""?>>Extremely Dissatisfied</option>
											</select>
										</td>
										<td>Customer left with (mood):</td>
										<td>
											<select class="form-control" name="data[customer_left_with_mood]" required>
												<option value="">Select</option>
												<option value="Happy" <?= ($pnbinbound['customer_left_with_mood']=="Happy")?"selected":""?>>Happy</option>
												<option value="Not Happy" <?= ($pnbinbound['customer_left_with_mood']=="Not Happy")?"selected":""?>>Not Happy</option>
												<option value="Neutral" <?= ($pnbinbound['customer_left_with_mood']=="Neutral")?"selected":""?>>Neutral</option>
												<option value="Extremely Dissatisfied" <?= ($pnbinbound['customer_left_with_mood']=="Extremely Dissatisfied")?"selected":""?>>Extremely Dissatisfied</option>
											</select>
										</td>
									</tr>
									<tr>
										<td>Product related:</td>
										<td><input type="text" class="form-control" name="data[product_related]" value="<?php echo $pnbinbound['product_related'] ?>" required></td>
										<td>Process related:</td>
										<td><input type="text" class="form-control" name="data[process_related]" value="<?php echo $pnbinbound['process_related'] ?>" required></td>
										<td>Agent related:</td>
										<td><input type="text" class="form-control" name="data[agent_related]" value="<?php echo $pnbinbound['agent_related'] ?>" required></td>
									</tr>
									<tr>
										<td>Needs Escalation:</td>
										<td>
											<select class="form-control" name="data[need_escalation]" required>
												<option value="">Select</option>
												<option value="Yes" <?= ($pnbinbound['need_escalation']=="Yes")?"selected":""?>>Yes</option>
												<option value="No" <?= ($pnbinbound['need_escalation']=="No")?"selected":""?>>No</option>
											</select>
										</td>
										<td>Call Back Required?:</td>
										<td>
											<select class="form-control" name="data[call_back_required]" required>
												<option value="">Select</option>
												<option value="Yes" <?= ($pnbinbound['call_back_required']=="Yes")?"selected":""?>>Yes</option>
												<option value="No" <?= ($pnbinbound['call_back_required']=="No")?"selected":""?>>No</option>
											</select>
										</td>
									</tr>
									<tr>
										<td>Audit Type:</td>
										<td>
											<select class="form-control" id="audit_type" name="data[audit_type]" required>
												<option value="<?php echo $pnbinbound['audit_type'] ?>"><?php echo $pnbinbound['audit_type'] ?></option>
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
												<option value="<?php echo $pnbinbound['auditor_type'] ?>"><?php echo $pnbinbound['auditor_type'] ?></option>
												<option value="">-Select-</option>
												<option value="Master">Master</option>
												<option value="Regular">Regular</option>
											</select>
										</td>
										<td>Prediactive CSAT:</td>
										<td>
											<select class="form-control" id="voc" name="data[voc]" required>
												<option value="<?php echo $pnbinbound['voc'] ?>"><?php echo $pnbinbound['voc'] ?></option>
												<option value="">-Select-</option>
												<option value="1">1</option>
												<option value="2">2</option>
												<option value="3">3</option>
												<option value="4">4</option>
												<option value="5">5</option>
											</select>
										</td>
									</tr>

									<?php if($lob=='kyc'){ ?>
										<tr>
											<td>Digi KYC Done Post Call</td>
											<td>
												<select name="data[kyc_done_post_call]" class="form-control" required>
													<option value="">-Select-</option>
													<option value="Yes" <?= ($pnbinbound['kyc_done_post_call']=="Yes")?"selected":""?>>Yes</option>
													<option value="No" <?= ($pnbinbound['kyc_done_post_call']=="No")?"selected":""?>>No</option>
													<option value="NA" <?= ($pnbinbound['kyc_done_post_call']=="NA")?"selected":""?>>NA</option>
												</select>
											</td>
											<td>Digi KYC Not Completed on Call Reason</td>
											<td><input type="text" name="data[kyc_not_complete_reason]" value="<?= $pnbinbound['kyc_not_complete_reason']?>" class="form-control" required/></td>
											<td>Digi KYC Status</td>
											<td>
												<select name="data[kyc_status]" class="form-control" required>
													<option value="">-Select-</option>
													<option value="Yes" <?= ($pnbinbound['kyc_status']=="Yes")?"selected":""?>>Yes</option>
													<option value="No" <?= ($pnbinbound['kyc_status']=="No")?"selected":""?>>No</option>
													<option value="NA" <?= ($pnbinbound['kyc_status']=="NA")?"selected":""?>>NA</option>
												</select>
											</td>
										</tr>
										<tr>
											<td>E-KYC Done Post Call</td>
											<td>
												<select name="data[ekyc_post_call]" class="form-control" required>
													<option value="">-Select-</option>
													<option value="Yes" <?= ($pnbinbound['ekyc_post_call']=="Yes")?"selected":""?>>Yes</option>
													<option value="No" <?= ($pnbinbound['ekyc_post_call']=="No")?"selected":""?>>No</option>
													<option value="NA" <?= ($pnbinbound['ekyc_post_call']=="NA")?"selected":""?>>NA</option>
												</select>
											</td>
											<td>E-KYC Status</td>
											<td>
												<select name="data[ekyc_status]" class="form-control" required>
													<option value="">-Select-</option>
													<option value="Yes" <?= ($pnbinbound['ekyc_status']=="Yes")?"selected":""?>>Yes</option>
													<option value="No" <?= ($pnbinbound['ekyc_status']=="No")?"selected":""?>>No</option>
													<option value="NA" <?= ($pnbinbound['ekyc_status']=="NA")?"selected":""?>>NA</option>
												</select>
											</td>
											<td>Ekyc Not Completed On Call Reason</td>
											<td><input type="text" name="data[ekyc_not_complete_reason]" class="form-control" required value="<?= $pnbinbound['ekyc_not_complete_reason']?>"/></td>
										</tr>
									<?php } ?>

									<tr>
										<td style="font-weight:bold; font-size:16px">Possible Score</td>
										<td><input type="text" readonly id="possibleScorexx" name="data[possible_score]" class="form-control" style="font-weight:bold" value="<?php echo $pnbinbound['possible_score'] ?>"></td>
										<td style="font-weight:bold; font-size:16px">Earned Score</td>
										<td><input type="text" readonly id="earnedScorexx" name="data[earned_score]" class="form-control" style="font-weight:bold" value="<?php echo $pnbinbound['earned_score'] ?>"></td>
										<td style="font-weight:bold; font-size:16px; text-align:right">Overall Score:</td>
										<td><input type="text" readonly id="overallScore" name="data[overall_score]" class="form-control pnbinboundFatal" style="font-weight:bold" value="<?php if($pnbinbound['overall_score']) {echo $pnbinbound['overall_score'].'%';}?>"></td>
									</tr>
								</tbody>
							</table>
							<table class="table table-striped skt-table">
								<tbody>
									<tr style="height:25px; font-weight:bold; background-color:#85C1E9">
										<td>Criticality</td>
										<td>Parameters</td>
										<td>Rating</td>
										<td>Reason</td>
										<td>Remarks</td>
									</tr>
									<tr>
										<td rowspan=9 style="background-color:#7DCEA0">Call Handling</td>
										<td>Standard Call Opening</td>
										<td>
											<select name="data[standard_call_opening]" class="form-control pnb_point_new" required>

												<option pnb_val=7 pnb_max_val=7 <?= ($pnbinbound['standard_call_opening']=="Good")?"selected":""?> value="Good">Good</option>
												<option pnb_val=3.5 pnb_max_val=7 <?= ($pnbinbound['standard_call_opening']=="Needs Improvement")?"selected":""?> value="Needs Improvement">Needs Improvement</option>
												<option pnb_val=0 pnb_max_val=7 <?= ($pnbinbound['standard_call_opening']=="Poor")?"selected":""?> value="Poor">Poor</option>
												<option pnb_val=0 pnb_max_val=0 <?= ($pnbinbound['standard_call_opening']=="N/A")?"selected":""?> value="N/A">N/A</option>
											</select>
										</td>
										<td>
											<select name="data[sco_reason]" class="form-control">
												<option value="">-Select-</option>
												<option value="Branding is Missing" <?= ($pnbinbound['sco_reason']=="Branding is Missing")?"selected":""?>>Branding is Missing</option>
												<option value="Cx name confirmation not done" <?= ($pnbinbound['sco_reason']=="Cx name confirmation not done")?"selected":""?>>Cx name confirmation not done</option>
												<option value="Delayed Opening" <?= ($pnbinbound['sco_reason']=="Delayed Opening")?"selected":""?>>Delayed Opening</option>
											</select>
										</td>
										<td>
											<input type="text" name="data[remark1]" class="form-control" value="<?= $pnbinbound['remark1']?>"/>
										</td>
									</tr>
									<tr>
										<td>Appropriate Empathy/Apology Wherever Applicable</td>
										<td>
											<select name="data[appr_empathy_apology]" class="form-control pnb_point_new" required>

												<option pnb_val="7" pnb_max_val="7" <?= ($pnbinbound['appr_empathy_apology']=="Good")?"selected":""?> value="Good">Good</option>
												<option pnb_val="3.5" pnb_max_val="7" <?= ($pnbinbound['appr_empathy_apology']=="Needs Improvement")?"selected":""?> value="Needs Improvement">Needs Improvement</option>
												<option pnb_val="0" pnb_max_val="7" <?= ($pnbinbound['appr_empathy_apology']=="Poor")?"selected":""?> value="Poor">Poor</option>
												<option pnb_val="0" pnb_max_val="0" <?= ($pnbinbound['appr_empathy_apology']=="N/A")?"selected":""?> value="N/A">N/A</option>
											</select>
										</td>
										<td>
											<select name="data[appr_emp_ap_reason]" class="form-control">
												<option value="">-Select-</option>
												<option value="Empathy/apology unavailable wherever applicable" <?= ($pnbinbound['appr_emp_ap_reason']=="Empathy/apology unavailable wherever applicable")?"selected":""?>>Empathy/apology unavailable wherever applicable</option>
												<option value="Empathy not shown multiple times wherever applicable" <?= ($pnbinbound['appr_emp_ap_reason']=="Empathy not shown multiple times wherever applicable")?"selected":""?>>Empathy not shown multiple times wherever applicable</option>
												<option value="N/A" <?= ($pnbinbound['appr_emp_ap_reason']=="N/A")?"selected":""?>>N/A</option>
											</select>
										</td>
										<td>
											<input type="text" name="data[remark2]" class="form-control" value="<?= $pnbinbound['remark2']?>"/>
										</td>
									</tr>
									<tr>
										<td>Assurance/Paraphrasing</td>
										<td>
											<select name="data[assurance_paraph]" class="form-control pnb_point_new" required>

												<option pnb_val="7" pnb_max_val="7" <?= ($pnbinbound['assurance_paraph']=="Good")?"selected":""?> value="Good">Good</option>
												<option pnb_val="3.5" pnb_max_val="7" <?= ($pnbinbound['assurance_paraph']=="Needs Improvement")?"selected":""?> value="Needs Improvement">Needs Improvement</option>
												<option pnb_val="0" pnb_max_val="7" <?= ($pnbinbound['assurance_paraph']=="Poor")?"selected":""?> value="Poor">Poor</option>
												<option pnb_val="0" pnb_max_val="0" <?= ($pnbinbound['assurance_paraph']=="N/A")?"selected":""?> value="N/A">N/A</option>
											</select>
										</td>
										<td>
											<select name="data[assurance_paraph_reason]" class="form-control">
												<option value="">-Select-</option>
												<option value="Assurance not provided wherever applicable" <?= ($pnbinbound['assurance_paraph_reason']=="Assurance not provided wherever applicable")?"selected":""?>>Assurance not provided wherever applicable</option>
												<option value="Query not understood properly due to lack of paraphashing impacting resolution" <?= ($pnbinbound['assurance_paraph_reason']=="Query not understood properly due to lack of paraphashing impacting resolution")?"selected":""?>>Query not understood properly due to lack of paraphashing impacting resolution</option>
											</select>
										</td>
										<td>
											<input type="text" name="data[remark3]" class="form-control" value="<?= $pnbinbound['remark3']?>"/>
										</td>
									</tr>
									<tr>
										<td>Correct Sentence Formation With Appropriate Salutation</td>
										<td>
											<select name="data[correct_sentence_formation]" class="form-control pnb_point_new" required>

												<option pnb_val="7" pnb_max_val="7" <?= ($pnbinbound['correct_sentence_formation']=="Good")?"selected":""?> value="Good">Good</option>
												<option pnb_val="3.5" pnb_max_val="7" <?= ($pnbinbound['correct_sentence_formation']=="Needs Improvement")?"selected":""?> value="Needs Improvement">Needs Improvement</option>
												<option pnb_val="0" pnb_max_val="7" <?= ($pnbinbound['correct_sentence_formation']=="Poor")?"selected":""?> value="Poor">Poor</option>
												<option pnb_val="0" pnb_max_val="0" <?= ($pnbinbound['correct_sentence_formation']=="N/A")?"selected":""?> value="N/A">N/A</option>
											</select>
										</td>
										<td>
											<select name="data[correct_sentence_form_reason]" class="form-control">
												<option value="">-Select-</option>
												<option value="Incorrect sentence formation impacting conversation" <?= ($pnbinbound['correct_sentence_form_reason']=="Incorrect sentence formation impacting conversation")?"selected":""?>>Incorrect sentence formation impacting conversation</option>
												<option value="Incorrect sentence formation not impacting conversation" <?= ($pnbinbound['correct_sentence_form_reason']=="Incorrect sentence formation not impacting conversation")?"selected":""?>>Incorrect sentence formation not impacting conversation</option>
											</select>
										</td>
										<td>
											<input type="text" name="data[remark4]" class="form-control" value="<?= $pnbinbound['remark4']?>"/>
										</td>
									</tr>
									<tr>
										<td>Feeling Confident/Well Mannered/Ros/Clarity Of Speech/Jargon</td>
										<td>
											<select name="data[feeling_confident]" class="form-control pnb_point_new" required>

												<option pnb_val="7" pnb_max_val="7" <?= ($pnbinbound['feeling_confident']=="Good")?"selected":""?> value="Good">Good</option>
												<option pnb_val="3.5" pnb_max_val="7" <?= ($pnbinbound['feeling_confident']=="Needs Improvement")?"selected":""?> value="Needs Improvement">Needs Improvement</option>
												<option pnb_val="0" pnb_max_val="7" <?= ($pnbinbound['feeling_confident']=="Poor")?"selected":""?> value="Poor">Poor</option>
												<option pnb_val="0" pnb_max_val="0" <?= ($pnbinbound['feeling_confident']=="N/A")?"selected":""?> value="N/A">N/A</option>
											</select>
										</td>
										<td>
											<select name="data[feeling_confident_reason]" class="form-control">
												<option value="">-Select-</option>
												<option value="Filler / Fumbling on call" <?= ($pnbinbound['feeling_confident_reason']=="Filler / Fumbling on call")?"selected":""?>>Filler / Fumbling on call</option>
												<option value="High Rate of speech or unclear speech observed" <?= ($pnbinbound['feeling_confident_reason']=="High Rate of speech or unclear speech observed")?"selected":""?>>High Rate of speech or unclear speech observed</option>
												<option value="Multiple fumbling impacting the conversation" <?= ($pnbinbound['feeling_confident_reason']=="Multiple fumbling impacting the conversation")?"selected":""?>>Multiple fumbling impacting the conversation</option>
											</select>
										</td>
										<td>
											<input type="text" name="data[remark5]" class="form-control" value="<?= $pnbinbound['remark5']?>"/>
										</td>
									</tr>
									<tr>
										<td>Active Listening/Attentiveness</td>
										<td>
											<select name="data[active_listening]" class="form-control pnb_point_new" required>

												<option pnb_val="7" pnb_max_val="7" <?= ($pnbinbound['active_listening']=="Good")?"selected":""?> value="Good">Good</option>
												<option pnb_val="3.5" pnb_max_val="7" <?= ($pnbinbound['active_listening']=="Needs Improvement")?"selected":""?> value="Needs Improvement">Needs Improvement</option>
												<option pnb_val="0" pnb_max_val="7" <?= ($pnbinbound['active_listening']=="Poor")?"selected":""?> value="Poor">Poor</option>
												<option pnb_val="0" pnb_max_val="0" <?= ($pnbinbound['active_listening']=="N/A")?"selected":""?> value="N/A">N/A</option>
											</select>
										</td>
										<td>
											<select name="data[active_listening_reason]" class="form-control">
												<option value="">-Select-</option>
												<option value="Missed to acknowledge_needs improvement in active listening" <?= ($pnbinbound['active_listening_reason']=="Missed to acknowledge_needs improvement in active listening")?"selected":""?>>Missed to acknowledge_needs improvement in active listening</option>
												<option value="Not attentive_made the customer repeat multiple times" <?= ($pnbinbound['active_listening_reason']=="Not attentive_made the customer repeat multiple times")?"selected":""?>>Not attentive_made the customer repeat multiple times</option>
												<option value="Missed to acknowledge impacting the conversation" <?= ($pnbinbound['active_listening_reason']=="Missed to acknowledge impacting the conversation")?"selected":""?>>Missed to acknowledge impacting the conversation</option>
											</select>
										</td>
										<td>
											<input type="text" name="data[remark6]" class="form-control" value="<?= $pnbinbound['remark6']?>"/>
										</td>
									</tr>
									<tr>
										<td>Interruption & Parallel Talking</td>
										<td>
											<select name="data[interruption]" class="form-control pnb_point_new" required>

												<option pnb_val="7" pnb_max_val="7" <?= ($pnbinbound['interruption']=="Good")?"selected":""?> value="Good">Good</option>
												<option pnb_val="3.5" pnb_max_val="7" <?= ($pnbinbound['interruption']=="Needs Improvement")?"selected":""?> value="Needs Improvement">Needs Improvement</option>
												<option pnb_val="0" pnb_max_val="7" <?= ($pnbinbound['interruption']=="Poor")?"selected":""?> value="Poor">Poor</option>
												<option pnb_val="0" pnb_max_val="0" <?= ($pnbinbound['interruption']=="N/A")?"selected":""?> value="N/A">N/A</option>
											</select>
										</td>
										<td>
											<select name="data[interruption_reason]" class="form-control">
												<option value="">-Select-</option>
												<option value="Interruption once or unintentional interruption not impacting the conversation" <?= ($pnbinbound['interruption_reason']=="Interruption once or unintentional interruption not impacting the conversation")?"selected":""?>>Interruption once or unintentional interruption not impacting the conversation</option>
												<option value="Interruption observed multiple times" <?= ($pnbinbound['interruption_reason']=="Interruption observed multiple times")?"selected":""?>>Interruption observed multiple times</option>
												<option value="Interruption impacting the customer/conversation" <?= ($pnbinbound['interruption_reason']=="Interruption impacting the customer/conversation")?"selected":""?>>Interruption impacting the customer/conversation</option>
											</select>
										</td>
										<td>
											<input type="text" name="data[remark7]" class="form-control" value="<?= $pnbinbound['remark7']?>"/>
										</td>
									</tr>
									<tr>
										<td>Closing on call</td>
										<td>
											<select name="data[closing_on_call]" class="form-control pnb_point_new" required>

												<option pnb_val="7" pnb_max_val="7" <?= ($pnbinbound['closing_on_call']=="Good")?"selected":""?> value="Good">Good</option>
												<option pnb_val="3.5" pnb_max_val="7" <?= ($pnbinbound['closing_on_call']=="Needs Improvement")?"selected":""?> value="Needs Improvement">Needs Improvement</option>
												<option pnb_val="0" pnb_max_val="7" <?= ($pnbinbound['closing_on_call']=="Poor")?"selected":""?> value="Poor">Poor</option>
												<option pnb_val="0" pnb_max_val="0" <?= ($pnbinbound['closing_on_call']=="N/A")?"selected":""?> value="N/A">N/A</option>
											</select>
										</td>
										<td>
											<select name="data[closing_on_call_reason]" class="form-control">
												<option value="">-Select-</option>
												<option value="Further assistance is missing" <?= ($pnbinbound['closing_on_call_reason']=="Further assistance is missing")?"selected":""?>>Further assistance is missing</option>
												<option value="Health check not done" <?= ($pnbinbound['closing_on_call_reason']=="Health check not done")?"selected":""?>>Health check not done</option>
												<option value="Closing not done on call" <?= ($pnbinbound['closing_on_call_reason']=="Closing not done on call")?"selected":""?>>Closing not done on call</option>
												<option value="CSAT Not Pitched" <?= ($pnbinbound['closing_on_call_reason']=="CSAT Not Pitched")?"selected":""?>>CSAT Not Pitched</option>
												<option value="IVR promotion not done on call" <?= ($pnbinbound['closing_on_call_reason']=="IVR promotion not done on call")?"selected":""?>>IVR promotion not done on call</option>
												<option value="Old CSAT script followed" <?= ($pnbinbound['closing_on_call_reason']=="Old CSAT script followed")?"selected":""?>>Old CSAT script followed</option>
												<option value="New CSAT script not adhered completely" <?= ($pnbinbound['closing_on_call_reason']=="New CSAT script not adhered completely")?"selected":""?>>New CSAT script not adhered completely</option>
												<option value="Incomplete CSAT pitching" <?= ($pnbinbound['closing_on_call_reason']=="Incomplete CSAT pitching")?"selected":""?>>Incomplete CSAT pitching</option>
												<option value="Personalization not done while pitching for CSAT" <?= ($pnbinbound['closing_on_call_reason']=="Personalization not done while pitching for CSAT")?"selected":""?>>Personalization not done while pitching for CSAT</option>
												<option value="N/A" <?= ($pnbinbound['closing_on_call_reason']=="N/A")?"selected":""?>>N/A</option>
											</select>
										</td>
										<td>
											<input type="text" name="data[remark8]" class="form-control" value="<?= $pnbinbound['remark8']?>"/>
										</td>
									</tr>
									<tr>
										<td>HMT Protocol</td>
										<td>
											<select name="data[hmt_protocol]" class="form-control pnb_point_new" required>

												<option pnb_val="7" pnb_max_val="7" <?= ($pnbinbound['hmt_protocol']=="Good")?"selected":""?> value="Good">Good</option>
												<option pnb_val="3.5" pnb_max_val="7" <?= ($pnbinbound['hmt_protocol']=="Needs Improvement")?"selected":""?> value="Needs Improvement">Needs Improvement</option>
												<option pnb_val="0" pnb_max_val="7" <?= ($pnbinbound['hmt_protocol']=="Poor")?"selected":""?> value="Poor">Poor</option>
												<option pnb_val="0" pnb_max_val="0" <?= ($pnbinbound['hmt_protocol']=="N/A")?"selected":""?> value="N/A">N/A</option>
											</select>
										</td>
										<td>
											<select name="data[hmt_protocol_reason]" class="form-control">
												<option value="">-Select-</option>
												<option value="Put call on hold without verbiage" <?= ($pnbinbound['hmt_protocol_reason']=="Put call on hold without verbiage")?"selected":""?>>Put call on hold without verbiage</option>
												<option value="Hold exceeded more than 1 min" <?= ($pnbinbound['hmt_protocol_reason']=="Hold exceeded more than 1 min")?"selected":""?>>Hold exceeded more than 1 min</option>
												<option value="Used mute instead of hold" <?= ($pnbinbound['hmt_protocol_reason']=="Used mute instead of hold")?"selected":""?>>Used mute instead of hold</option>
												<option value="Unnesesarily putting the call on mute" <?= ($pnbinbound['hmt_protocol_reason']=="Unnesesarily putting the call on mute")?"selected":""?>>Unnesesarily putting the call on mute</option>
												<option value="Dead air >7 secs" <?= ($pnbinbound['hmt_protocol_reason']=="Dead air >7 secs")?"selected":""?>>Dead air >7 secs</option>
												<option value="Transfer not done wherever required" <?= ($pnbinbound['hmt_protocol_reason']=="Transfer not done wherever required")?"selected":""?>>Transfer not done wherever required</option>
												<option value="Speaking with peers" <?= ($pnbinbound['hmt_protocol_reason']=="Speaking with peers")?"selected":""?>>Speaking with peers</option>
												<option value="Sneezed without putting mute" <?= ($pnbinbound['hmt_protocol_reason']=="Sneezed without putting mute")?"selected":""?>>Sneezed without putting mute</option>
												<option value="N/A" <?= ($pnbinbound['hmt_protocol_reason']=="N/A")?"selected":""?>>N/A</option>
											</select>
										</td>
										<td>
											<input type="text" name="data[remark9]" class="form-control" value="<?= $pnbinbound['remark9']?>"/>
										</td>
									</tr>
									<tr>
										<td rowspan="4" style="background-color:#7DCEA0">Business Criticality</td>
										<td>Effective Probing/System Check</td>
										<td>
											<select name="data[effective_probing]" class="form-control pnb_point_new" required>

												<option pnb_val="7" pnb_max_val="7" <?= ($pnbinbound['effective_probing']=="Good")?"selected":""?> value="Good">Good</option>
												<option pnb_val="3.5" pnb_max_val="7" <?= ($pnbinbound['effective_probing']=="Needs Improvement")?"selected":""?> value="Needs Improvement">Needs Improvement</option>
												<option pnb_val="0" pnb_max_val="7" <?= ($pnbinbound['effective_probing']=="Poor")?"selected":""?> value="Poor">Poor</option>
												<option pnb_val="0" pnb_max_val="0" <?= ($pnbinbound['effective_probing']=="N/A")?"selected":""?> value="N/A">N/A</option>
											</select>
										</td>
										<td>
											<select name="data[effective_probing_reason]" class="form-control">
												<option value="">-Select-</option>
												<option value="Probing not done when required" <?= ($pnbinbound['effective_probing_reason']=="Probing not done when required")?"selected":""?>>Probing not done when required</option>
												<option value="Last ticket history not referred" <?= ($pnbinbound['effective_probing_reason']=="Last ticket history not referred")?"selected":""?>>Last ticket history not referred</option>
												<option value="Probing missing leads to improper resolution" <?= ($pnbinbound['effective_probing_reason']=="Probing missing leads to improper resolution")?"selected":""?>>Probing missing leads to improper resolution</option>
											</select>
										</td>
										<td>
											<input type="text" name="data[remark10]" class="form-control" value="<?= $pnbinbound['remark10']?>"/>
										</td>
									</tr>
									<tr>
										<td>Self help - IVR Promotion/Sales Pitch/Convincing skill</td>
										<td>
											<select name="data[self_help]" class="form-control pnb_point_new" required>

												<option pnb_val="7" pnb_max_val="7" <?= ($pnbinbound['self_help']=="Good")?"selected":""?> value="Good">Good</option>
												<option pnb_val="3.5" pnb_max_val="7" <?= ($pnbinbound['self_help']=="Needs Improvement")?"selected":""?> value="Needs Improvement">Needs Improvement</option>
												<option pnb_val="0" pnb_max_val="7" <?= ($pnbinbound['self_help']=="Poor")?"selected":""?> value="Poor">Poor</option>
												<option pnb_val="0" pnb_max_val="0" <?= ($pnbinbound['self_help']=="N/A")?"selected":""?> value="N/A">N/A</option>
											</select>
										</td>
										<td>
											<select name="data[self_help_reason]" class="form-control">
												<option value="">-Select-</option>
												<option value="Urge for sales missing" <?= ($pnbinbound['self_help_reason']=="Urge for sales missing")?"selected":""?>>Urge for sales missing</option>
												<option value="Convincing skills missing" <?= ($pnbinbound['self_help_reason']=="Convincing skills missing")?"selected":""?>>Convincing skills missing</option>
												<option value="Incomplete IVR flow guided" <?= ($pnbinbound['self_help_reason']=="Incomplete IVR flow guided")?"selected":""?>>Incomplete IVR flow guided</option>
												<option value="Incorrect/no IVR flow guided" <?= ($pnbinbound['self_help_reason']=="Incorrect/no IVR flow guided")?"selected":""?>>Incorrect/no IVR flow guided</option>
												<option value="N/A" <?= ($pnbinbound['self_help_reason']=="N/A")?"selected":""?>>N/A</option>
											</select>
										</td>
										<td>
											<input type="text" name="data[remark11]" class="form-control" value="<?= $pnbinbound['remark11']?>"/>
										</td>
									</tr>
									<tr>
										<td style="color:red;">Security Check - Authentication</td>
										<td>
											<select name="data[security_check]" class="form-control pnb_point_new" id="pnb_fatal1" required>

												<option pnb_val="4" pnb_max_val="4" <?= ($pnbinbound['security_check']=="Good")?"selected":""?> value="Good">Good</option>
												<option pnb_val="0" pnb_max_val="4" <?= ($pnbinbound['security_check']=="Fatal")?"selected":""?> value="Fatal">Fatal</option>
												<option pnb_val="0" pnb_max_val="0" <?= ($pnbinbound['security_check']=="N/A")?"selected":""?> value="N/A">N/A</option>
											</select>
										</td>
										<td>
											<select name="data[security_check_reason]" class="form-control">
												<option value="">-Select-</option>
												<option value="Security check not done" <?= ($pnbinbound['security_check_reason']=="Security check not done")?"selected":""?>>Security check not done</option>
												<option value="Security check process not followed" <?= ($pnbinbound['security_check_reason']=="Security check process not followed")?"selected":""?>>Security check process not followed</option>
												<option value="N/A" <?= ($pnbinbound['security_check_reason']=="N/A")?"selected":""?>>N/A</option>
											</select>
										</td>
										<td>
											<input type="text" name="data[remark12]" class="form-control" value="<?= $pnbinbound['remark12']?>"/>
										</td>
									</tr>
									<tr>
										<td style="color:red;">Agent Shared The Correct/Complete Information</td>
										<td>
											<select name="data[agent_shared_comp_info]" class="form-control pnb_point_new" id="pnb_fatal2" required>

												<option pnb_val="4" pnb_max_val="4" <?= ($pnbinbound['agent_shared_comp_info']=="Good")?"selected":""?> value="Good">Good</option>
												<option pnb_val="0" pnb_max_val="4" <?= ($pnbinbound['agent_shared_comp_info']=="Fatal")?"selected":""?> value="Fatal">Fatal</option>
											</select>
										</td>
										<td>
											<select name="data[agent_shared_comp_info_reason]" class="form-control">
												<option value="">-Select-</option>
												<option value="Incorrect Information" <?= ($pnbinbound['agent_shared_comp_info_reason']=="Incorrect Information")?"selected":""?>>Incorrect Information</option>
												<option value="Incomplete Information" <?= ($pnbinbound['agent_shared_comp_info_reason']=="Incomplete Information")?"selected":""?>>Incomplete Information</option>
												<option value="Wrong Commitment" <?= ($pnbinbound['agent_shared_comp_info_reason']=="Wrong Commitment")?"selected":""?>>Wrong Commitment</option>
											</select>
										</td>
										<td>
											<input type="text" name="data[remark13]" class="form-control" value="<?= $pnbinbound['remark13']?>"/>
										</td>
									</tr>
									<tr>
										<td rowspan="2" style="background-color:#7DCEA0">Documentation</td>
										<td>Whether All The Information Collected And Recorded Properly</td>
										<td>
											<select name="data[all_info_collected]" class="form-control pnb_point_new" required>

												<option pnb_val="7" pnb_max_val="7" <?= ($pnbinbound['all_info_collected']=="Good")?"selected":""?> value="Good">Good</option>
												<option pnb_val="3.5" pnb_max_val="7" <?= ($pnbinbound['all_info_collected']=="Needs Improvement")?"selected":""?> value="Needs Improvement">Needs Improvement</option>
												<option pnb_val="0" pnb_max_val="7" <?= ($pnbinbound['all_info_collected']=="Poor")?"selected":""?> value="Poor">Poor</option>
												<option pnb_val="0" pnb_max_val="0" <?= ($pnbinbound['all_info_collected']=="N/A")?"selected":""?> value="N/A">N/A</option>
											</select>
										</td>
										<td>
											<select name="data[all_info_collected_reason]" class="form-control">
												<option value="">-Select-</option>
												<option value="Incomplete Remarks Captured" <?= ($pnbinbound['all_info_collected_reason']=="Incomplete Remarks Captured")?"selected":""?>>Incomplete Remarks Captured</option>
												<option value="Remarks not Captured at all" <?= ($pnbinbound['all_info_collected_reason']=="Remarks not Captured at all")?"selected":""?>>Remarks not Captured at all</option>
											</select>
										</td>
										<td>
											<input type="text" name="data[remark14]" class="form-control" value="<?= $pnbinbound['remark14']?>"/>
										</td>
									</tr>
									<tr>
										<td style="color:red;">Update The Vertical/Lob Issue Category & Sub Category/ Issue Category Reason/Order Id Or Transaction Id (If Any)</td>
										<td>
											<select name="data[update_vertical_lob_issue]" class="form-control pnb_point_new" id="pnb_fatal3" required>

												<option pnb_val="4" pnb_max_val="4" <?= ($pnbinbound['update_vertical_lob_issue']=="Good")?"selected":""?> value="Good">Good</option>
												<option pnb_val="0" pnb_max_val="4" <?= ($pnbinbound['update_vertical_lob_issue']=="Fatal")?"selected":""?> value="Fatal">Fatal</option>
											</select>
										</td>
										<td>
											<select name="data[update_vertical_lob_issue_reason]" class="form-control">
												<option value="">-Select-</option>
												<option value="Tagging not done" <?= ($pnbinbound['update_vertical_lob_issue_reason']=="Tagging not done")?"selected":""?>>Tagging not done</option>
												<option value="Incorrect issue cat/sub cat selected" <?= ($pnbinbound['update_vertical_lob_issue_reason']=="Remarks not Captured at allIncorrect issue cat/sub cat selected")?"selected":""?>>Incorrect issue cat/sub cat selected</option>
												<option value="Ticket not submitted" <?= ($pnbinbound['update_vertical_lob_issue_reason']=="Ticket not submitted")?"selected":""?>>Ticket not submitted</option>
											</select>
										</td>
										<td>
											<input type="text" name="data[remark15]" class="form-control" value="<?= $pnbinbound['remark15']?>"/>
										</td>
									</tr>
									<tr>
										<td style="color:red;">Zero Tolerance Policy</td>
										<td style="color:red;">Policy And Procedure Followed By The Agent As Per Ztp (Rude And Profanity Etc</td>
										<td>
											<select name="data[policy_and_procedure]" class="form-control pnb_point_new" id="pnb_fatal4" required>

												<option pnb_val="4" pnb_max_val="4" <?= ($pnbinbound['policy_and_procedure']=="Good")?"selected":""?> value="Good">Good</option>
												<option pnb_val="0" pnb_max_val="4" <?= ($pnbinbound['policy_and_procedure']=="Fatal")?"selected":""?> value="Fatal">Fatal</option>
											</select>
										</td>
										<td>
											<select name="data[policy_and_procedure_reason]" class="form-control">
												<option value="">-Select-</option>
												<option value="Rude on Call" <?= ($pnbinbound['policy_and_procedure_reason']=="Rude on Call")?"selected":""?>>Rude on Call</option>
												<option value="Sarcastic on Call" <?= ($pnbinbound['policy_and_procedure_reason']=="Sarcastic on Call")?"selected":""?>>Sarcastic on Call</option>
												<option value="Call disconnection while Cx was speaking" <?= ($pnbinbound['policy_and_procedure_reason']=="Call disconnection while Cx was speaking")?"selected":""?>>Call disconnection while Cx was speaking</option>
												<option value="Abusive on Call" <?= ($pnbinbound['policy_and_procedure_reason']=="Abusive on Call")?"selected":""?>>Abusive on Call</option>
												<option value="Asking Personal Information with Cx" <?= ($pnbinbound['policy_and_procedure_reason']=="Asking Personal Information with Cx")?"selected":""?>>Asking Personal Information with Cx</option>
											</select>
										</td>
										<td>
											<input type="text" name="data[remark16]" class="form-control" value="<?= $pnbinbound['remark16']?>"/>
										</td>
									</tr>
									<tr><td colspan=6 style="background-color:#7DCEA0"></td></tr>

									<tr>
										<td>Call Summary:</td>
										<td colspan="2"><textarea class="form-control"   name="data[call_summary]"><?php echo $pnbinbound['call_summary'] ?></textarea></td>
										<td>Feedback:</td>
										<td colspan="2"><textarea class="form-control"   name="data[feedback]"><?php echo $pnbinbound['feedback'] ?></textarea></td>
									</tr>
									<tr>
										<td>TNI Feedback:</td>
										<td colspan="2"><textarea class="form-control"   name="data[tni_feedback]"><?php echo $pnbinbound['tni_feedback'] ?></textarea></td>
									</tr>
									<tr>
										<td colspan=2>Upload Files (wav,wmv,mp3,mp4)</td>
										<?php if($pnb_inb_id==0){ ?>
											<td colspan=2><input type="file" multiple class="form-control audioFile" id="fileuploadbasic" name="attach_file[]" ></td>
										<?php }else{ ?>
											<td colspan=2><input type="file" multiple class="form-control audioFile" name="attach_file[]" ></td>
											<td colspan=2>
												<?php if($pnbinbound['attach_file']!=''){ 
													$attach_file = explode(",",$pnbinbound['attach_file']);
													 foreach($attach_file as $mp){ ?>
														<audio controls='' style="background-color:#607F93"> 
														  <source src="<?php echo base_url(); ?>qa_files/pnbinbound_new/<?php echo $mp; ?>" type="audio/ogg">
														  <source src="<?php echo base_url(); ?>qa_files/pnbinbound_new/<?php echo $mp; ?>" type="audio/mpeg">
														</audio> </br>
													 <?php }  
												}?>
											</td>
										<?php } ?>
									</tr>

									<?php if($pnb_inb_id!=0){ ?>
										<tr><td colspan=2 style="font-size:16px; font-weight:bold">Agent Feedback Acceptance:</td><td colspan=4><?php echo $pnbinbound['agnt_fd_acpt'] ?></td></tr>
										<tr><td colspan=2 style="font-size:16px; font-weight:bold">Agent Review:</td><td colspan=4><?php echo $pnbinbound['agent_rvw_note'] ?></td></tr>
										<tr><td colspan=2 style="font-size:16px; font-weight:bold">Management Review:</td><td colspan=4><?php echo $pnbinbound['mgnt_rvw_note'] ?></td></tr>
										<tr><td colspan=2 style="font-size:16px; font-weight:bold">Client Review:</td><td colspan=4><?php echo $pnbinbound['client_rvw_note'] ?></td></tr>

										<tr><td colspan=2  style="font-size:16px">Your Review</td><td colspan=4><textarea class="form-control1" style="width:100%" id="note" name="note"  ></textarea></td></tr>
									<?php } ?>

									<?php
									if($pnb_inb_id==0){
										if(is_access_qa_module()==true || is_access_qa_operations_module()==true){ ?>
											<tr><td colspan=6><button class="btn btn-success waves-effect" type="submit" id="qaformsubmit" style="width:500px">SAVE</button></td></tr>
									<?php
										}
									}else{
										if(is_access_qa_module()==true || is_access_qa_operations_module()==true){
											if(is_available_qa_feedback($pnbinbound['entry_date'],72) == true){ ?>
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