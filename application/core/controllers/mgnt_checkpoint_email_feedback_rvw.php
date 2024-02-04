
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
		<form id="form_mgnt_user" method="POST" action="">

			<div class="col-12">
				<div class="widget">
				
					<div class="widget-body">
						<div class="table-responsive">
							<table class="table table-striped skt-table" width="100%">
								<tbody>
									<tr style="background-color:#AEB6BF">
										<td colspan="6" id="theader" style="font-size:30px"><!-- <img src="<?php echo base_url(); ?>main_img/puppyspot.png"> --> Checkpoint Email
										<input type="hidden" name="pa_id" value="<?php echo $paid; ?>">
										</td>
										
									</tr>
									
									<?php foreach($get_checkpoint_email_feedback as $pspa): ?>
									
									<tr>
										<td>QA Name:</td>
										<td><input type="text" class="form-control" id="auditor_name" name="auditor_name" value="<?php echo $pspa['auditor_name']; ?>" required readonly ></td>
										<td>Audit Date Time:</td>
										<td><input type="text" class="form-control" value="<?php echo mysql2mmddyy($pspa['audit_date']); ?>" disabled></td>
										<td>Customer ID:</td>
										<td><input type="text" class="form-control" id="customer_id" name="customer_id" value="<?php echo $pspa['customer_id']; ?>" required></td>
									</tr>
									<tr>
										<td>Agent:</td>
										<td>
											<select class="form-control" id="agent_id" name="agent_id" required>
												<option value="<?php echo $pspa['agent_id'] ?>"><?php echo $pspa['fname']." ".$pspa['lname'] ?></option>
												<option value="">-Select-</option>
												<?php foreach($agentName as $row):  ?>
													<option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
												<?php endforeach; ?>
											</select>
										</td>
										<td>Fusion ID:</td>
										<td><input type="text" readonly class="form-control" id="fusion_id" name="" value="<?php echo $pspa['fusion_id'] ?>"></td>
										<td>L1 Supervisor:</td>
										<td>
											<select class="form-control" id="tl_id" name="tl_id" required>
												<option value="<?php echo $pspa['tl_id'] ?>"><?php echo $pspa['tl_name'] ?></option>
												<option value="">--Select--</option>
												<?php foreach($tlname as $tl): ?>
													<option value="<?php echo $tl['id']; ?>"><?php echo $tl['fname']." ".$tl['lname']; ?></option>
												<?php endforeach; ?>	
											</select>
										</td>
									</tr>
									<tr>
										<td>Call ID:</td>
										<td><input type="text" class="form-control" id="call_id" name="call_id" value="<?php echo $pspa['call_id'] ?>" required></td>
										<td>Call Date:</td>
										<td><input type="text" class="form-control" id="call_date" name="call_date" value="<?php echo mysql2mmddyy($pspa['call_date']) ?>" required></td>
										<td>Mobile No.:</td>
										<td><input type="text" class="form-control" id="phone" name="phone" value="<?php echo $pspa['phone'] ?>" onkeyup="checkDec(this);" required></td>
									</tr>
									<tr>
										<td>Campaign:</td>
										<td><input type="text" readonly class="form-control" id="campaign" name="campaign" value="<?php echo $pspa['campaign'] ?>"></td>
										<td>Audit Type:</td>
										<td>
											<select class="form-control" id="audit_type" name="audit_type" required>
												<option value="<?php echo $pspa['audit_type'] ?>"><?php echo $pspa['audit_type'] ?></option>
												<option value="">-Select-</option>
												<option value="CQ Audit">CQ Audit</option>
												<option value="BQ Audit">BQ Audit</option>
												<option value="Calibration">Calibration</option>
												<option value="Client Request Audit">Client Request Audit</option>
											</select>
										</td>
										<td>VOC:</td>
										<td>
											<select class="form-control" id="voc" name="voc" required>
												<option value="<?php echo $pspa['voc'] ?>"><?php echo $pspa['voc'] ?></option>
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
										<td colspan="4"></td>
										<td style="font-size:18px; font-weight:bold">Total Score:</td>
										<td style="font-size:18px; font-weight:bold"><input type="text" readonly class="form-control" id="checkpoint_total_score" name="total_score" value="<?php echo $pspa['overall_score'] ?>"></td>
									</tr>
									
									<tr><td colspan="6" style="background-color:#C5C8C8"></td></tr>
									
									<tr style="height:45px">
										<td class="eml1" colspan="4"></td>
										<td class="eml1">Points Earned</td>
										<td class="eml1">Remarks</td>
									</tr>
									<tr>
										<td rowspan="7" class="eml1">Body of the email</td>
										<td class="eml" colspan="3">Probing Question (to assist)</td>
										<td>
											<select class="form-control" id="probing_que_assist" name="probing_que_assist" required>
												<option value="">-Select-</option>
												<?php $sel='';
												if($pspa['probing_que_assist']=='10') $sel='Selected'; ?>
												<option value="10" <?php echo $sel; ?>ds_val="Yes" hval=10 >Yes</option>
												<?php $sel='';
												if($pspa['probing_que_assist']=='0') $sel='Selected'; ?>
												<option value="0" <?php echo $sel; ?> ds_val="No" hval=10 >No</option>	
												<?php $sel='';
												if($pspa['probing_que_assist']=='-1') $sel='Selected'; ?>
												<option value="-1" <?php echo $sel; ?> ds_val="NA" hval=10 >NA</option>	
											</select>
											<input type="hidden" id="probing_que_assist_hd" name="probing_que_assist_hd" value="10">
										</td>
										<td class="emp2"><input type="text" class="form-control" id="probing_que_assist_rmk" name="probing_que_assist_rmk" value="<?php echo $pspa['probing_que_assist_rmk'] ?>" ></td>
									</tr>
									<tr>
										<td class="eml" colspan="3">Probing Question (to tag ticket).</td>
										<td>
											<select class="form-control" id="probing_que_ticket" name="probing_que_ticket" required>
												<option value="">-Select-</option>
												<?php $sel='';
												if($pspa['probing_que_ticket']=='10') $sel='Selected'; ?>
												<option value="10" <?php echo $sel; ?> ds_val="Yes" hval=10 >Yes</option>
												<?php $sel='';
												if($pspa['probing_que_ticket']=='0') $sel='Selected'; ?>
												<option value="0" <?php echo $sel; ?> ds_val="No" hval=10 >No</option>
												<?php $sel='';
												if($pspa['probing_que_ticket']=='-1') $sel='Selected'; ?>
												<option value="-1" <?php echo $sel; ?> ds_val="NA" hval=10 >NA</option>
											</select>
											<input type="hidden" id="probing_que_ticket_hd" name="probing_que_ticket_hd" value="10">
										</td>
										<td class="emp2"><input type="text" class="form-control" id="probing_que_ticket_rmk" name="probing_que_ticket_rmk" value="<?php echo $pspa['probing_que_ticket_rmk'] ?>" ></td>
									</tr>
									<tr>
										<td class="eml" colspan="3">Accuracy and appropriateness of information</td>
										<td>
											<select class="form-control" id="accuracy_info" name="accuracy_info" required>
												<option value="">-Select-</option>
												<?php $sel='';
												if($pspa['accuracy_info']=='10') $sel='Selected'; ?>
												<option value="10" <?php echo $sel; ?> ds_val="Yes" hval=10 >Yes</option>
												<?php $sel='';
												if($pspa['accuracy_info']=='0') $sel='Selected'; ?>
												<option value="0" <?php echo $sel; ?> ds_val="No" hval=10 >No</option>
												<?php $sel='';
												if($pspa['accuracy_info']=='-1') $sel='Selected'; ?>
												<option value="-1" <?php echo $sel; ?> ds_val="NA" hval=10 >NA</option>
											</select>
											<input type="hidden" id="accuracy_info_hd" name="accuracy_info_hd" value="10">
										</td>
										<td class="emp2"><input type="text" class="form-control" id="accuracy_info_rmk" name="accuracy_info_rmk" value="<?php echo $pspa['accuracy_info_rmk'] ?>" ></td>
									</tr>
									
									<tr>
										<td class="eml" colspan="3">Does the customer have more than 2 concerns / questions?</td>
										<td>
											<select class="form-control" id="more_concerns" name="more_concerns" required>
												<option value="">-Select-</option>
												<?php $sel='';
												if($pspa['more_concerns']=='10') $sel='Selected'; ?>
												<option value="10" <?php echo $sel; ?> ds_val="Yes" hval=10 >Yes</option>
												<?php $sel='';
												if($pspa['more_concerns']=='0') $sel='Selected'; ?>
												<option value="0" <?php echo $sel; ?> ds_val="No" hval=10 >No</option>
												<?php $sel='';
												if($pspa['more_concerns']=='-1') $sel='Selected'; ?>
												<option value="-1" <?php echo $sel; ?> ds_val="NA" hval=10 >NA</option>
											</select>
										</td>
										<td class="emp2"><input type="text" class="form-control" id="more_concerns_rmk" name="more_concerns_rmk" value="<?php echo $pspa['more_concerns_rmk'] ?>" ></td>
									</tr>
									<tr>
										<td class="eml" colspan="3">Did the rep review previous conversation?</td>
										<td>
											<select class="form-control" id="review_conversation" name="review_conversation" required>
												<option value="">-Select-</option>
												<?php $sel='';
												if($pspa['review_conversation']=='10') $sel='Selected'; ?>
												<option value="10" <?php echo $sel; ?> ds_val="Yes" hval=10 >Yes</option>
												<?php $sel='';
												if($pspa['review_conversation']=='0') $sel='Selected'; ?>
												<option value="0" <?php echo $sel; ?> ds_val="No" hval=10 >No</option>
												<?php $sel='';
												if($pspa['review_conversation']=='-1') $sel='Selected'; ?>
												<option value="-1" <?php echo $sel; ?> ds_val="NA" hval=10 >NA</option>
											</select>
											<input type="hidden" id="review_conversation_hd" name="review_conversation_hd" value="10">
										</td>
										<td class="emp2"><input type="text" class="form-control" id="review_conversation_rmk" name="review_conversation_rmk" value="<?php echo $pspa['review_conversation_rmk'] ?>" ></td>
									</tr>
									
									<tr>										
										<td class="eml" colspan="3">Resolution</td>
										<td>
											<select class="form-control" id="resolution" name="resolution" required>
												<option value="">-Select-</option>
												<?php $sel='';
												if($pspa['resolution']=='10') $sel='Selected'; ?>
												<option value="10" <?php echo $sel; ?> ds_val="Yes" hval=10 >Yes</option>
												<?php $sel='';
												if($pspa['resolution']=='0') $sel='Selected'; ?>
												<option value="0" <?php echo $sel; ?> ds_val="No" hval=10 >No</option>
												<?php $sel='';
												if($pspa['resolution']=='-1') $sel='Selected'; ?>
												<option value="-1" <?php echo $sel; ?> ds_val="NA" hval=10 >NA</option>
											</select>
											<input type="hidden" id="resolution_hd" name="resolution_hd" value="10">
										</td>
										<td class="emp2"><input type="text" class="form-control" id="resolution_rmk" name="resolution_rmk" value="<?php echo $pspa['resolution_rmk'] ?>" ></td>
									</tr>
									<tr>										
										<td class="eml" colspan="3">Offer Additional/Alternate Resolution</td>
										<td>
											<select class="form-control" id="offer_additional" name="offer_additional" required>
												<option value="">-Select-</option>
												<?php $sel='';
												if($pspa['offer_additional']=='6') $sel='Selected'; ?>
												<option value="6" <?php echo $sel; ?> ds_val="Yes" hval=6 >Yes</option>
												<?php $sel='';
												if($pspa['offer_additional']=='0') $sel='Selected'; ?>
												<option value="0" <?php echo $sel; ?> ds_val="No" hval=6 >No</option>
												<?php $sel='';
												if($pspa['offer_additional']=='-1') $sel='Selected'; ?>
												<option value="-1" <?php echo $sel; ?> ds_val="NA" hval=6 >NA</option>
											</select>
											<input type="hidden" id="offer_additional_hd" name="offer_additional_hd" value="6">
										</td>
										<td class="emp2"><input type="text" class="form-control" id="offer_additional_rmk" name="offer_additional_rmk" value="<?php echo $pspa['offer_additional_rmk'] ?>" ></td>
									</tr>
									
									<tr><td colspan="6" style="background-color:#566573"></td></tr>
									
									<tr>
										<td rowspan="6" class="eml1">Format and Tone</td>
										<td class="eml" colspan="3">Empathy and Enthusiasm (apologize when needed only)</td>
										<td>
											<select class="form-control" id="empathy_enthusiasm" name="empathy_enthusiasm" required>
												<option value="">-Select-</option>
												<?php $sel='';
												if($pspa['empathy_enthusiasm']=='4') $sel='Selected'; ?>
												<option value="4" <?php echo $sel; ?> ds_val="Yes" hval=4 >Yes</option>
												<?php $sel='';
												if($pspa['empathy_enthusiasm']=='0') $sel='Selected'; ?>
												<option value="0" <?php echo $sel; ?> ds_val="No" hval=4 >No</option>	
												<?php $sel='';
												if($pspa['empathy_enthusiasm']=='-1') $sel='Selected'; ?>
												<option value="-1" <?php echo $sel; ?> ds_val="NA" hval=4 >NA</option>												
											</select>
											<input type="hidden" id="empathy_enthusiasm_hd" name="empathy_enthusiasm_hd" value="4">
										</td>
										<td class="emp2"><input type="text" class="form-control" id="empathy_enthusiasm_rmk" name="empathy_enthusiasm_rmk" value="<?php echo $pspa['empathy_enthusiasm_rmk'] ?>" ></td>
									</tr>
									<tr>
										<td class="eml" colspan="3">Simplicity and Politeness</td>
										<td>
											<select class="form-control" id="simplicity_politeness" name="simplicity_politeness" required>
												<option value="">-Select-</option>
												<?php $sel='';
												if($pspa['simplicity_politeness']=='3') $sel='Selected'; ?>
												<option value="3" <?php echo $sel; ?> ds_val="Yes" hval=3 >Yes</option>
												<?php $sel='';
												if($pspa['simplicity_politeness']=='0') $sel='Selected'; ?>
												<option value="0" <?php echo $sel; ?> ds_val="No" hval=3 >No</option>												
												<?php $sel='';
												if($pspa['simplicity_politeness']=='-1') $sel='Selected'; ?>
												<option value="-1" <?php echo $sel; ?> ds_val="NA" hval=3 >NA</option>
											</select>
											<input type="hidden" id="simplicity_politeness_hd" name="simplicity_politeness_hd" value="3">
										</td>
										<td class="emp2"><input type="text" class="form-control" id="simplicity_politeness_rmk" name="simplicity_politeness_rmk" value="<?php echo $pspa['simplicity_politeness_rmk'] ?>" ></td>
									</tr>
									<tr>
										<td class="eml" colspan="3">Grammar</td>
										<td>
											<select class="form-control" id="grammar" name="grammar" required>
												<option value="">-Select-</option>
												<?php $sel='';
												if($pspa['grammar']=='1') $sel='Selected'; ?>
												<option value="1" <?php echo $sel; ?> ds_val="Yes" hval=1 >Yes</option>
												<?php $sel='';
												if($pspa['grammar']=='0') $sel='Selected'; ?>
												<option value="0" <?php echo $sel; ?> ds_val="No" hval=1 >No</option>
												<?php $sel='';
												if($pspa['grammar']=='-1') $sel='Selected'; ?>
												<option value="-1" <?php echo $sel; ?> ds_val="NA" hval=1 >NA</option>
											</select>
											<input type="hidden" id="grammar_hd" name="grammar_hd" value="1">
										</td>
										<td class="emp2"><input type="text" class="form-control" id="grammar_rmk" name="grammar_rmk" value="<?php echo $pspa['grammar_rmk'] ?>" ></td>
									</tr>									
									<tr>										
										<td class="eml" colspan="3">Are the thoughts and instruction on the email properly organized?</td>
										<td>
											<select class="form-control" id="instruction_email" name="instruction_email" required>
												<option value="">-Select-</option>
												<?php $sel='';
												if($pspa['instruction_email']=='3') $sel='Selected'; ?>
												<option value="3" <?php echo $sel; ?> ds_val="Yes" hval=3 >Yes</option>
												<?php $sel='';
												if($pspa['instruction_email']=='0') $sel='Selected'; ?>
												<option value="0" <?php echo $sel; ?> ds_val="No" hval=3 >No</option>	
												<?php $sel='';
												if($pspa['instruction_email']=='-1') $sel='Selected'; ?>
												<option value="-1" <?php echo $sel; ?> ds_val="NA" hval=3 >NA</option>
											</select>
											<input type="hidden" id="instruction_email_hd" name="instruction_email_hd" value="3">
										</td>
										<td class="emp2"><input type="text" class="form-control" id="instruction_email_rmk" name="instruction_email_rmk" value="<?php echo $pspa['instruction_email_rmk'] ?>" ></td>
									</tr>
									<tr>
										<td class="eml" colspan="3">Salutation</td>
										<td>
											<select class="form-control" id="salutation" name="salutation" required>
												<option value="">-Select-</option>
												<?php $sel='';
												if($pspa['salutation']=='3') $sel='Selected'; ?>
												<option value="3" <?php echo $sel; ?> ds_val="Yes" hval=3 >Yes</option>
												<?php $sel='';
												if($pspa['salutation']=='0') $sel='Selected'; ?>
												<option value="0" <?php echo $sel; ?> ds_val="No" hval=3 >No</option>	
												<?php $sel='';
												if($pspa['salutation']=='-1') $sel='Selected'; ?>
												<option value="-1" <?php echo $sel; ?> ds_val="NA" hval=3 >NA</option>
											</select>
											<input type="hidden" id="salutation_hd" name="salutation_hd" value="3">
										</td>
										<td class="emp2"><input type="text" class="form-control" id="salutation_rmk" name="salutation_rmk" value="<?php echo $pspa['salutation_rmk'] ?>" ></td>
									</tr>
									<tr>
										<td class="eml" colspan="3">Closing</td>
										<td>
											<select class="form-control" id="closing" name="closing" required>
												<option value="">-Select-</option>
												<?php $sel='';
												if($pspa['closing']=='3') $sel='Selected'; ?>
												<option value="3" <?php echo $sel; ?> ds_val="Yes" hval=3 >Yes</option>
												<?php $sel='';
												if($pspa['closing']=='0') $sel='Selected'; ?>
												<option value="0" <?php echo $sel; ?> ds_val="No" hval=3 >No</option>
												<?php $sel='';
												if($pspa['closing']=='-1') $sel='Selected'; ?>
												<option value="-1" <?php echo $sel; ?> ds_val="NA" hval=3 >NA</option>
											</select>
											<input type="hidden" id="closing_hd" name="closing_hd" value="3">
										</td>
										<td class="emp2"><input type="text" class="form-control" id="closing_rmk" name="closing_rmk" value="<?php echo $pspa['closing_rmk'] ?>" ></td>
									</tr>
									
									<tr><td colspan="6" style="background-color:#566573"></td></tr>
									
									<tr>
										<td rowspan="6" class="eml1">Actions Taken</td>
										<td class="eml" colspan="3">Escalation / Asked for proper assistance</td>
										<td>
											<select class="form-control" id="escalation" name="escalation" required>
												<option value="">-Select-</option>
												<?php $sel='';
												if($pspa['escalation']=='8') $sel='Selected'; ?>
												<option value="8" <?php echo $sel; ?> ds_val="Yes" hval=8 >Yes</option>
												<?php $sel='';
												if($pspa['escalation']=='0') $sel='Selected'; ?>
												<option value="0" <?php echo $sel; ?> ds_val="No" hval=8 >No</option>
												<?php $sel='';
												if($pspa['escalation']=='-1') $sel='Selected'; ?>
												<option value="-1" <?php echo $sel; ?> ds_val="NA" hval=8 >NA</option>
											</select>
											<input type="hidden" id="escalation_hd" name="escalation_hd" value="8">
										</td>
										<td class="emp2"><input type="text" class="form-control" id="escalation_rmk" name="escalation_rmk" value="<?php echo $pspa['escalation_rmk'] ?>" ></td>
									</tr>
									
									
									<tr>
										<td class="eml" colspan="3">Use of Proper Tools:</td>
										<td>
											<select class="form-control" id="proper_tools" name="proper_tools" required>
												<option value="">-Select-</option>
												<?php $sel='';
												if($pspa['proper_tools']=='8') $sel='Selected'; ?>
												<option value="8" <?php echo $sel; ?> ds_val="Yes" hval=8 >Yes</option>
												<?php $sel='';
												if($pspa['proper_tools']=='0') $sel='Selected'; ?>
												<option value="0" <?php echo $sel; ?> ds_val="No" hval=8 >No</option>
												<?php $sel='';
												if($pspa['proper_tools']=='-1') $sel='Selected'; ?>
												<option value="-1" <?php echo $sel; ?> ds_val="NA" hval=8 >NA</option>
											</select>
											<input type="hidden" id="proper_tools_hd" name="proper_tools_hd" value="8">
										</td>
										<td class="emp2"><input type="text" class="form-control" id="proper_tools_rmk" name="proper_tools_rmk" value="<?php echo $pspa['proper_tools_rmk'] ?>" ></td>
									</tr>
									
									<tr>
										<td class="eml" colspan="3">Proper Tags were used on the ticket</td>
										<td>
											<select class="form-control" id="proper_tags" name="proper_tags" required>
												<option value="">-Select-</option>
												<?php $sel='';
												if($pspa['proper_tags']=='8') $sel='Selected'; ?>
												<option value="8" <?php echo $sel; ?> ds_val="Yes" hval=8 >Yes</option>
												<?php $sel='';
												if($pspa['proper_tags']=='0') $sel='Selected'; ?>
												<option value="0" <?php echo $sel; ?> ds_val="No" hval=8 >No</option>
												<?php $sel='';
												if($pspa['proper_tags']=='-1') $sel='Selected'; ?>
												<option value="-1" <?php echo $sel; ?> ds_val="NA" hval=8 >NA</option>
											</select>
											<input type="hidden" id="proper_tags_hd" name="proper_tags_hd" value="8">
										</td>
										<td class="emp2"><input type="text" class="form-control" id="proper_tags_rmk" name="proper_tags_rmk" value="<?php echo $pspa['proper_tags_rmk'] ?>" ></td>
									</tr>
									
									
									<tr>
										<td class="eml" colspan="3">Other notes</td>
										<td>
											<select class="form-control" id="other_notes" name="other_notes" required>
												<option value="">-Select-</option>
												<?php $sel='';
												if($pspa['other_notes']=='3') $sel='Selected'; ?>
												<option value="3" <?php echo $sel; ?> ds_val="Yes" hval=3 >Yes</option>
												<?php $sel='';
												if($pspa['other_notes']=='0') $sel='Selected'; ?>
												<option value="0" <?php echo $sel; ?> ds_val="No" hval=3 >No</option>
												<?php $sel='';
												if($pspa['other_notes']=='-1') $sel='Selected'; ?>
												<option value="-1" <?php echo $sel; ?> ds_val="NA" hval=3 >NA</option>
											</select>
											<input type="hidden" id="other_notes_hd" name="other_notes_hd" value="3">
										</td>
										<td class="emp2"><input type="text" class="form-control" id="other_notes_rmk" name="other_notes_rmk" value="<?php echo $pspa['other_notes_rmk'] ?>" ></td>
									</tr>
									
									
									<tr>
										<td class="eml" colspan="3">Timeliness of response</td>
										<td>
											<select class="form-control" id="timeliness_response" name="timeliness_response" required>
												<option value="">-Select-</option>
												<?php $sel='';
												if($pspa['timeliness_response']=='3') $sel='Selected'; ?>
												<option value="3" <?php echo $sel; ?> ds_val="Yes" hval=3 >Yes</option>
												<?php $sel='';
												if($pspa['timeliness_response']=='0') $sel='Selected'; ?>
												<option value="0" <?php echo $sel; ?> ds_val="No" hval=3 >No</option>
												<?php $sel='';
												if($pspa['timeliness_response']=='-1') $sel='Selected'; ?>
												<option value="-1" <?php echo $sel; ?> ds_val="NA" hval=3 >NA</option>
											</select>
											<input type="hidden" id="timeliness_response_hd" name="timeliness_response_hd" value="3">
										</td>
										<td class="emp2"><input type="text" class="form-control" id="timeliness_response_rmk" name="timeliness_response_rmk" value="<?php echo $pspa['timeliness_response_rmk'] ?>" ></td>
									</tr>
									
									
									<tr>									
										<td class="eml" colspan="3">Status</td>
										<td>
											<select class="form-control" id="status" name="status" required>
												<option value="">-Select-</option>
												<?php $sel='';
												if($pspa['status']=='7') $sel='Selected'; ?>
												<option value="7" <?php echo $sel; ?> ds_val="Yes" hval=3 >Yes</option>
												<?php $sel='';
												if($pspa['status']=='0') $sel='Selected'; ?>
												<option value="0" <?php echo $sel; ?> ds_val="No" hval=3 >No</option>
												<?php $sel='';
												if($pspa['status']=='-1') $sel='Selected'; ?>
												<option value="-1" <?php echo $sel; ?> ds_val="NA" hval=3 >NA</option>
											</select>
											<input type="hidden" id="status_hd" name="status_hd" value="7">
										</td>
										<td class="emp2"><input type="text" class="form-control" id="status_rmk" name="status_rmk" value="<?php echo $pspa['status_rmk'] ?>" ></td>
									</tr>
									
									<tr><td colspan="6" style="background-color:#566573"></td></tr>
																		
									<tr>
										<td colspan="2">RECOMMENDATIONS:</td>
										<td colspan="4"><textarea class="form-control" id="recommendations" name="recommendations"><?php echo $pspa['recommendations'] ?></textarea></td>
									</tr> 
									<tr>
										<td colspan="2">Call Summary:</td>
										<td colspan="4"><textarea class="form-control" id="feedback" name="feedback"><?php echo $pspa['feedback'] ?></textarea></td>
									</tr>
									
									<?php if($pspa['attach_file']!=''){ ?>
									<tr>
										<td colspan="2">Audio Files</td>
										<td colspan="4">
											<?php $attach_file = explode(",",$pspa['attach_file']); ?>
											
											 <?php if(strstr($pspa['attach_file'], 'docx') || strstr($pspa['attach_file'], 'doc')){
												 
												foreach($attach_file as $af){ ?>
													<a href="<?php echo base_url(); ?>qa_files/qa_checkpoint/checkpoint_email/<?php echo $af; ?>" style="font-size:15px"><?php echo $af; ?></a> </br>
											 <?php }
												
											  }else{ ?>
											
											 <?php foreach($attach_file as $af){ ?>
												<audio controls='' style="background-color:#607F93"> 
												  <source src="<?php echo base_url(); ?>qa_files/qa_checkpoint/checkpoint_email/<?php echo $af; ?>" type="audio/ogg">
												  <source src="<?php echo base_url(); ?>qa_files/qa_checkpoint/checkpoint_email/<?php echo $af; ?>" type="audio/mpeg">
												</audio> </br>
											 <?php } 
											  } ?>
										</td>
									</tr> 
									<?php } ?>
									
									<?php endforeach; ?>
									
									<tr><td colspan="6" style="background-color:#C5C8C8"></td></tr>
									
									<?php if($row1['id']==''){ ?>
										<tr>
											<td colspan="6" style="font-size:16px; font-weight:bold">Agent Review Not found</td>
										</tr>
									<?php }else{ ?>
										<tr>
											<td colspan="2"  style="font-size:16px">Agent Review</td>
											<td colspan="4">
												<textarea class="form-control" id="note" name="note" disabled><?php echo $row1['note']; ?></textarea>
											</td>
										</tr>
									<?php } ?>	
									
									<tr><td colspan="6" style="background-color:#C5C8C8"></td></tr>
									
									<tr>
										<td colspan="2"  style="font-size:16px">Manager Review</td>
										<td colspan="4">
											<input type="hidden" id="action" name="action" class="form-control" value="<?php echo $row2['id']; ?>">
											<textarea class="form-control" id="note" name="note" required><?php echo $row2['note'] ?></textarea>
										</td>
									</tr>
									
									<?php if(is_access_qa_module()==true || is_access_qa_operations_module()==true){
									if(is_available_qa_feedback($get_checkpoint_email_feedback[0]['entry_date'],72) == true){ ?>
										<tr>
											<td colspan="6"><button class="btn btn-success waves-effect" type="submit" id='btnmgntSave' name='btnSave' value="SAVE" style="width:500px">SAVE</button></td>
										</tr>
									<?php } 
									} ?>
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
