<style>
.table > tbody > tr > td{
	text-align: center;
	font-size:13px;
}

#theader{
	font-size:20px;
	font-weight:bold;
}

.prm_hdr{
	background-color:#E74C3C; 
	color:white; 
	font-weight:bold;
}

.prms_clm{
	background-color:#A9CCE3;
	font-weight:bold;
}

.prms_clm2{
	background-color:#F5B041;
	font-weight:bold;
	color:red;
}
</style>

<?php if($escalation_id!=0){
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
										<td colspan="6" id="theader" style="font-size:40px"><img src="<?php echo base_url(); ?>main_img/oyo.png">&nbsp SIG Chat [Escalation]</td>
										<input type="hidden" name="audit_start_time" value="<?php echo CurrMySqlDate(); ?>">
									</tr>
									<?php
										if($escalation_id==0){
											$auditorName = get_username();
											$auditDate = CurrDateMDY();
											$clDate_val='';
										}else{
											if($chat_escalation['entry_by']!=''){
												$auditorName = $chat_escalation['auditor_name'];
											}else{
												$auditorName = $chat_escalation['client_name'];
											}
											$auditDate = mysql2mmddyy($chat_escalation['audit_date']);
											$clDate_val = mysql2mmddyy($chat_escalation['call_date']);
										}
									?>
									<tr>
										<td style="width:250px">Name of Auditor:</td>
										<td><input type="text" class="form-control" value="<?php echo $auditorName; ?>" disabled></td>
										<td style="width:100px">Date of Audit:</td>
										<td style="width:250px"><input type="text" class="form-control" value="<?php echo $auditDate; ?>" disabled></td>
										<td>Chat Date:</td>
										<td style="width:275px"><input type="text" class="form-control" id="call_date" name="call_date" value="<?php echo $clDate_val; ?>" required></td>
									</tr>
									<tr>
										<td>Agent:</td>
										<td>
											<select class="form-control" id="agent_id" name="agent_id" required>
												<option value="<?php echo $chat_escalation['agent_id'] ?>"><?php echo $chat_escalation['fname']." ".$chat_escalation['lname'] ?></option>
												<option value="">-Select-</option>
												<?php foreach($agentName as $row):  ?>
													<option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
												<?php endforeach; ?>
											</select>
										</td>
										<td>Fusion ID:</td>
										<td><input type="text" class="form-control" id="fusion_id" name="fusion_id" value="<?php echo $chat_escalation['fusion_id']; ?>" readonly></td>
										<td>L1 Supervisor:</td>
										<td>
											<select class="form-control" id="tl_id" name="tl_id" readonly>
												<option value="<?php echo $chat_escalation['tl_id'] ?>"><?php echo $chat_escalation['tl_name'] ?></option>
												<option value="">--Select--</option>
												<?php foreach($tlname as $tl): ?>
													<option value="<?php echo $tl['id']; ?>"><?php echo $tl['fname']." ".$tl['lname']; ?></option>
												<?php endforeach; ?>	
											</select>
										</td>
									</tr>
									<tr>
										<td>Guest Contact Number:</td>
										<td><input type="text" class="form-control" id="" name="guest_number" onkeyup="checkDec(this);" value="<?php echo $chat_escalation['guest_number']; ?>" required></td>
										<td>Haptik ID:</td>
										<td><input type="text" class="form-control" id="" name="haptik_id" value="<?php echo $chat_escalation['haptik_id']; ?>" required></td>
										<td>Booking ID:</td>
										<td><input type="text" class="form-control" id="" name="booking_id" value="<?php echo $chat_escalation['booking_id']; ?>" required></td>
									</tr>
									<tr>
										<td>Chat Link:</td>
										<td><input type="text" class="form-control" id="" name="chat_link" value="<?php echo $chat_escalation['chat_link']; ?>" required></td>
										<td>Escalation Ticket ID:</td>
										<td><input type="text" class="form-control" id="" name="escalation_ticket_id" value="<?php echo $chat_escalation['escalation_ticket_id']; ?>" required></td>
										<td>Tenurity</td>
										<td><input type="text" class="form-control" id="" name="tenurity" value="<?php echo $chat_escalation['tenurity']; ?>" required></td>
									</tr>
									<tr>
										<td>Property Code:</td>
										<td><input type="text" class="form-control" name="property_code" value="<?php echo $chat_escalation['property_code'] ?>" required></td>
										<td>Agent Disposition:</td>
										<td><input type="text" class="form-control" name="agent_disposition" value="<?php echo $chat_escalation['agent_disposition'] ?>" required></td>
										<td>QA Disposition:</td>
										<td><input type="text" class="form-control" name="qa_disposition" value="<?php echo $chat_escalation['qa_disposition'] ?>" required></td>
									</tr>
									<tr>
										<td>Audit Type:</td>
										<td>
											<select class="form-control" id="audit_type" name="audit_type" required>
												<option value="">-Select-</option>
												<option <?php echo $chat_escalation['audit_type']=='CQ Audit'?"selected":""; ?> value="CQ Audit">CQ Audit</option>
												<option <?php echo $chat_escalation['audit_type']=='BQ Audit'?"selected":""; ?> value="BQ Audit">BQ Audit</option>
												<option <?php echo $chat_escalation['audit_type']=='Calibration'?"selected":""; ?> value="Calibration">Calibration</option>
												<option <?php echo $chat_escalation['audit_type']=='Pre-Certificate Mock Call'?"selected":""; ?> value="Pre-Certificate Mock Call">Pre-Certificate Mock Call</option>
												<option <?php echo $chat_escalation['audit_type']=='Certificate Audit'?"selected":""; ?> value="Certificate Audit">Certificate Audit</option>
											</select>
										</td>
										<td >Auditor Type</td>
										<td >
											<select class="form-control" id="auditor_type" name="auditor_type">
												<option value="">-Select-</option>
												<option value="Master">Master</option>
												<option value="Regular">Regular</option>
											</select>
										</td>
										<td>VOC:</td>
										<td>
											<select class="form-control" id="voc" name="voc" required>
												<option value="">-Select-</option>
												<option <?php echo $chat_escalation['voc']=='1'?"selected":""; ?> value="1">1</option>
												<option <?php echo $chat_escalation['voc']=='2'?"selected":""; ?> value="2">2</option>
												<option <?php echo $chat_escalation['voc']=='3'?"selected":""; ?> value="3">3</option>
												<option <?php echo $chat_escalation['voc']=='4'?"selected":""; ?> value="4">4</option>
												<option <?php echo $chat_escalation['voc']=='5'?"selected":""; ?> value="5">5</option>
											</select>
										</td>
									</tr>

									<tr>
										<td>Conversation Identifier</td>
										<td><input type="text" class="form-control" id="" name="conversation_identifier" value="<?php echo $chat_escalation['conversation_identifier']; ?>" required></td>
										<td>AHT:</td>
										<td><input type="text" class="form-control" id="" name="aht" value="<?php echo $chat_escalation['aht']; ?>" required></td>
										<td>CRS ID:</td>
										<td><input type="text" class="form-control" id="" name="crs_id" value="<?php echo $chat_escalation['crs_id']; ?>" required></td>
										
									</tr>

									<tr>
										<td>Haptik Category:</td>
										<td><input type="text" class="form-control" id="" name="haptik_category" value="<?php echo $chat_escalation['haptik_category']; ?>" required></td>
										<td>Haptik Sub Category:</td>
										<td><input type="text" class="form-control" id="" name="haptik_subcategory" value="<?php echo $chat_escalation['haptik_subcategory']; ?>" required></td>
										<td>OD Reason:</td>
										<td><input type="text" class="form-control" id="" name="od_reason" value="<?php echo $chat_escalation['od_reason']; ?>" required></td>
										
									</tr>

									<tr>
										<td>OD Category:</td>
										<td><input type="text" class="form-control" id="" name="od_category" value="<?php echo $chat_escalation['od_category']; ?>" required></td>
										<td>OD Sub Category:</td>
										<td><input type="text" class="form-control" id="" name="od_subcategory" value="<?php echo $chat_escalation['od_subcategory']; ?>" required></td>
										<td>OD Actual Reason:</td>
										<td><input type="text" class="form-control" id="" name="od_actual_reason" value="<?php echo $chat_escalation['od_actual_reason']; ?>" required></td>
										
									</tr>

									<tr>
										<td>OD Actual Category:</td>
										<td><input type="text" class="form-control" id="" name="od_actual_category" value="<?php echo $chat_escalation['od_actual_category']; ?>" required></td>
										<td>OD Actual Sub Category:</td>
										<td><input type="text" class="form-control" id="" name="od_actual_subcategory" value="<?php echo $chat_escalation['od_actual_subcategory']; ?>" required></td>
										<td>Chat Synopsis:</td>
										<td><input type="text" class="form-control" id="" name="chat_synopsis" value="<?php echo $chat_escalation['chat_synopsis']; ?>" required></td>
										
									</tr>

									<tr>
										<td>Monitor File Name (Guest):</td>
										<td><input type="text" class="form-control" id="" name="monitor_filename_guest" value="<?php echo $chat_escalation['monitor_filename_guest']; ?>" required></td>
										<td>Monitor File Name (PM):</td>
										<td><input type="text" class="form-control" id="" name="monitor_filename_pm" value="<?php echo $chat_escalation['monitor_filename_pm']; ?>" required></td>
										<td>Monitor File Name (SM):</td>
										<td><input type="text" class="form-control" id="" name="monitor_filename_sm" value="<?php echo $chat_escalation['monitor_filename_sm']; ?>" required></td>
										
									</tr>

									<tr>
										<td>Var 1:</td>
										<td><input type="text" class="form-control" id="" name="var_1" value="<?php echo $chat_escalation['var_1']; ?>" required></td>
										<td>Var 2:</td>
										<td><input type="text" class="form-control" id="" name="var_2" value="<?php echo $chat_escalation['var_2']; ?>" required></td>
										<td>Var 3:</td>
										<td><input type="text" class="form-control" id="" name="var_3" value="<?php echo $chat_escalation['var_3']; ?>" required></td>
										
									</tr>

									<tr style="font-weight:bold">
										<td>Earned Score:</td>
										<td><input type="text" readonly id="srvErnScore" name="earned_score" class="form-control" value="<?php echo $chat_escalation['earned_score']; ?>"></td>
										<td>Possible Score:</td>
										<td><input type="text" readonly id="srvPsblScore" name="possible_score" class="form-control" value="<?php echo $chat_escalation['possible_score']; ?>"></td>
										<td>Overall Score:</td>
										<td><input type="text" readonly id="chatServiceScore" name="overall_score" class="form-control chatEscalationAF" value="<?php echo $chat_escalation['overall_score']; ?>"></td>
									</tr>
									<tr class="prm_hdr"><td style="background-color:#512E5F">Parameters</td><td colspan=2>Sub Parameters</td><td>Weightage</td><td>Reason</td><td>Dropdown</td></tr>
									<tr>
										<td rowspan="1" style="background-color:#A9CCE3; font-weight:bold">Call Opening</td>
										<td colspan="2" class="prms_clm">1.1 Opening & Salutation</td>
										<td>2</td>
										<td>
											<select class="form-control chat_point" id="" name="opening_salutation" required>
												<option chat_val=2 <?php echo $chat_escalation['opening_salutation']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option chat_val=2 <?php echo $chat_escalation['opening_salutation']=='No'?"selected":""; ?> value="No">No</option>
												<option chat_val=0 <?php echo $chat_escalation['opening_salutation']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td>
											<select class="form-control" id="" name="dd_val1">
												<option value="<?php echo $chat_escalation['dd_val1'] ?>"><?php echo $chat_escalation['dd_val1'] ?></option>
												<option value="">-Select-</option>
												<option value="Did not use the opening script over the chat">Did not use the opening script over the chat</option>
												<option value="Did not open the chat within 180 secs">Did not open the chat within 180 secs</option>
												<option value="No Opening given with Guest/PM/stock over the call">No Opening given with Guest/PM/stock over the call</option>
												<option value="Self Introduction missing/clear with Guest/PM/stock over the call">Self Introduction missing/clear with Guest/PM/stock over the call</option>
												<option value="OYO Branding missing with Guest/PM/stock over the call">OYO Branding missing with Guest/PM/stock over the call</option>
												<option value="Brand name was not clear with Guest/PM/stock over the call">Brand name was not clear with Guest/PM/stock over the call</option>
											</select>
										</td>
										
									</tr>

									<tr>
										<td rowspan=2 style="background-color:#A9CCE3; font-weight:bold">Probing</td>
										
										<td colspan="2" class="prms_clm">2.1 Effective Probing Done</td>
										<td>3</td>
										<td>
											<select class="form-control chat_point" id="" name="effective_probing" required>
												<option chat_val=3 <?php echo $chat_escalation['effective_probing']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option chat_val=3 <?php echo $chat_escalation['effective_probing']=='No'?"selected":""; ?> value="No">No</option>
												<option chat_val=0 <?php echo $chat_escalation['effective_probing']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td>
											<select class="form-control" id="" name="dd_val2">
												<option value="<?php echo $chat_escalation['dd_val2'] ?>"><?php echo $chat_escalation['dd_val2'] ?></option>
												<option value="">-Select-</option>
												<option value="Unnecessary probing done">Unnecessary probing done</option>
												<option value="Incorrect probing done">Incorrect probing done</option>
												<option value="No Probing done whenever required">No Probing done whenever required</option>
											</select>
										</td>
										
									</tr>
									<tr>
										<td colspan="2" class="prms_clm" >2.2 Identify issue and offer assurance</td>
										<td>7</td>
										<td>
											<select class="form-control chat_point" id="" name="issue_identified" required>
												<option chat_val=7 <?php echo $chat_escalation['issue_identified']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option chat_val=7 <?php echo $chat_escalation['issue_identified']=='No'?"selected":""; ?> value="No">No</option>
												<option chat_val=0 <?php echo $chat_escalation['issue_identified']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td>
											<select class="form-control" id="" name="dd_val3">
												<option value="<?php echo $chat_escalation['dd_val3'] ?>"><?php echo $chat_escalation['dd_val3'] ?></option>
												<option value="">-Select-</option>
												<option value="Issue not identified correctly">Issue not identified correctly</option>
												<option value="Issue not identified completely">Issue not identified completely</option>
												<option value="Assurance not offered">Assurance not offered</option>
											</select>
										</td>
										
									</tr>

									<tr>
										<td rowspan=8 style="background-color:#A9CCE3; font-weight:bold">Soft Skill & Communication.</td>
										<td colspan="2" class="prms_clm">3.1 Apology & Empathy</td>
										<td>4</td>
										<td>
											<select class="form-control chat_point" id="" name="apology_empathy" required>
												<option chat_val=4 <?php echo $chat_escalation['apology_empathy']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option chat_val=4 <?php echo $chat_escalation['apology_empathy']=='No'?"selected":""; ?> value="No">No</option>
												<option chat_val=0 <?php echo $chat_escalation['apology_empathy']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td>
											<select class="form-control" id="" name="dd_val4">
												<option value="<?php echo $chat_escalation['dd_val4'] ?>"><?php echo $chat_escalation['dd_val4'] ?></option>
												<option value="">-Select-</option>
												<option value="Timely apology not done">Timely apology not done</option>
												<option value="Apology/empathy not done">Apology/empathy not done</option>
												<option value="Apology/empathy sounded scripted">Apology/empathy sounded scripted</option>
											</select>
										</td>
										
									</tr>

									<tr>
										<td colspan="2" class="prms_clm">3.2 Capital letter/long sentence/spacing error/Punctuation</td>
										<td>3</td>
										<td>
											<select class="form-control chat_point" id="" name="spacing_error_punctuation" required>
												<option chat_val=3 <?php echo $chat_escalation['spacing_error_punctuation']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option chat_val=3 <?php echo $chat_escalation['spacing_error_punctuation']=='No'?"selected":""; ?> value="No">No</option>
												<option chat_val=0 <?php echo $chat_escalation['spacing_error_punctuation']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td>
											<select class="form-control" id="" name="dd_val5">
												<option value="<?php echo $chat_escalation['dd_val5'] ?>"><?php echo $chat_escalation['dd_val5'] ?></option>
												<option value="">-Select-</option>
												<option value="Capital Letter Error">Capital Letter Error</option>
												<option value="Long Sentence Error">Long Sentence Error</option>
												<option value="Spacing error">Spacing error</option>
												<option value="Punctuation Error">Punctuation Error</option>
											</select>
										</td>
										
									</tr>

									<tr>
										<td colspan="2" class="prms_clm">3.3 Attentiveness</td>
										<td>4</td>
										<td>
											<select class="form-control chat_point" id="" name="attentiveness" required>
												<option chat_val=4 <?php echo $chat_escalation['attentiveness']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option chat_val=4 <?php echo $chat_escalation['attentiveness']=='No'?"selected":""; ?> value="No">No</option>
												<option chat_val=0 <?php echo $chat_escalation['attentiveness']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td>
											<select class="form-control" id="" name="dd_val6">
												<option value="<?php echo $chat_escalation['dd_val6'] ?>"><?php echo $chat_escalation['dd_val6'] ?></option>
												<option value="">-Select-</option>
												<option value="Guest had to tell his concern more than once over the chat">Guest had to tell his concern more than once over the chat</option>
												<option value="Made the customer repeat > 1 instance over the call">Made the customer repeat > 1 instance over the call</option>
												<option value="Did not apologies the guest after sending the irrelevant message">Did not apologies the guest after sending the irrelevant message</option>
												<option value="Too many Interruptions > 1 instance over the call">Too many Interruptions > 1 instance over the call</option>
											</select>
										</td>
										
									</tr>

									<tr>
										<td colspan="2" class="prms_clm">3.4 SMS language/Abbreviations/Choice of words</td>
										<td>3</td>
										<td>
											<select class="form-control chat_point" id="" name="sms_language" required>
												<option chat_val=3 <?php echo $chat_escalation['sms_language']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option chat_val=3 <?php echo $chat_escalation['sms_language']=='No'?"selected":""; ?> value="No">No</option>
												<option chat_val=0 <?php echo $chat_escalation['sms_language']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td>
											<select class="form-control" id="" name="dd_val7">
												<option value="<?php echo $chat_escalation['dd_val7'] ?>"><?php echo $chat_escalation['dd_val7'] ?></option>
												<option value="">-Select-</option>
												<option value="SMS language like 'OK', 'u', 'y', etc used">SMS language like 'OK', 'u', 'y', etc used</option>
												<option value="Poor choice of words">Poor choice of words</option>
												<option value="Abbreviations like 'BRB', 'TTYL', etc used">Abbreviations like 'BRB', 'TTYL', etc used</option>
											</select>
										</td>
										
									</tr>
									<tr>
										<td colspan="2" class="prms_clm" >3.5 Spell check</td>
										<td>2</td>
										<td>
											<select class="form-control chat_point" id="esclFatal2" name="spell_check" required>
												<option chat_val=2 <?php echo $chat_escalation['spell_check']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option chat_val=2 <?php echo $chat_escalation['spell_check']=='No'?"selected":""; ?> value="No">No</option>
												<option chat_val=0 <?php echo $chat_escalation['spell_check']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td>
											<select class="form-control" id="" name="dd_val8">
												<option value="<?php echo $chat_escalation['dd_val8'] ?>"><?php echo $chat_escalation['dd_val8'] ?></option>
												<option value="">-Select-</option>
												<option value="Incorrect spelling">Incorrect spelling</option>
											</select>
										</td>
										
									</tr>
									<tr>
										<td colspan="2" class="prms_clm">3.6 Politeness /Courtesy / Professionalism</td>
										<td>4</td>
										<td>
											<select class="form-control chat_point" id="" name="courteous_words" required>
												<option chat_val=4 <?php echo $chat_escalation['courteous_words']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option chat_val=4 <?php echo $chat_escalation['courteous_words']=='No'?"selected":""; ?> value="No">No</option>
												<option chat_val=0 <?php echo $chat_escalation['courteous_words']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td>
											<select class="form-control" id="" name="dd_val9">
												<option value="<?php echo $chat_escalation['dd_val9'] ?>"><?php echo $chat_escalation['dd_val9'] ?></option>
												<option value="">-Select-</option>
												<option value="Did not use power words">Did not use power words</option>
												<option value="Did not display willingness to help">Did not display willingness to help</option>
												<option value="Sounding casual on call">Sounding casual on call</option>
												<option value="Agent was blunt/ authoritative/aggressive">Agent was blunt/ authoritative/aggressive</option>
												<option value="Agent was Yawning on call">Agent was Yawning on call</option>
											</select>
										</td>
										
									</tr>
									<tr>
										<td colspan="2" class="prms_clm" >3.7 Grammar / Sentence Structure/Incomplete Sentence</td>
										<td>6</td>
										<td>
											<select class="form-control chat_point" id="esclFatal3" name="incomplete_sentence" required>
												<option chat_val=6 <?php echo $chat_escalation['incomplete_sentence']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option chat_val=6 <?php echo $chat_escalation['incomplete_sentence']=='No'?"selected":""; ?> value="No">No</option>
												<option chat_val=0 <?php echo $chat_escalation['incomplete_sentence']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td>
											<select class="form-control" id="" name="dd_val10">
												<option value="<?php echo $chat_escalation['dd_val10'] ?>"><?php echo $chat_escalation['dd_val10'] ?></option>
												<option value="">-Select-</option>
												<option value="Incorrect Grammar">Incorrect Grammar</option>
												<option value="Incomplete Sentence">Incomplete Sentence</option>
												<option value="Incorrect Sentence Structure">Incorrect Sentence Structure</option>
												<option value="Language mismatch">Language mismatch</option>
											</select>
										</td>
										
									</tr>

									<tr>
										<td colspan="2" class="prms_clm">3.8 Timely Acknowledgment/Refresh Interval time</td>
										<td>6</td>
										<td>
											<select class="form-control chat_point" id="" name="time_acknowledge" required>
												<option chat_val=6 <?php echo $chat_escalation['time_acknowledge']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option chat_val=6 <?php echo $chat_escalation['time_acknowledge']=='No'?"selected":""; ?> value="No">No</option>
												<option chat_val=0 <?php echo $chat_escalation['time_acknowledge']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td>
											<select class="form-control" id="" name="dd_val11">
												<option value="<?php echo $chat_escalation['dd_val11'] ?>"><?php echo $chat_escalation['dd_val11'] ?></option>
												<option value="">-Select-</option>
												<option value="Did not response the guest within 3 Minutes">Did not response the guest within 3 Minutes</option>
												<option value="Did not response the guest within the committed time frame">Did not response the guest within the committed time frame</option>
												<option value="Did not put the chat on 'Waiting for User' within 50 seconds">Did not put the chat on 'Waiting for User' within 50 seconds</option>
											</select>
										</td>
										
									</tr>

									<tr>
										<td rowspan=4 style="background-color:#A9CCE3; font-weight:bold">Resolution</td>
										<td colspan="2" class="prms_clm" >4.1 Unnecessary time taken from guest for follow up from Stock team and to check other information</td>
										<td>4</td>
										<td>
											<select class="form-control chat_point" id="" name="unnecessary_time_taken" required>
												<option chat_val=4 <?php echo $chat_escalation['unnecessary_time_taken']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option chat_val=4 <?php echo $chat_escalation['unnecessary_time_taken']=='No'?"selected":""; ?> value="No">No</option>
												<option chat_val=0 <?php echo $chat_escalation['unnecessary_time_taken']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td>
											<select class="form-control" id="" name="dd_val12">
												<option value="<?php echo $chat_escalation['dd_val12'] ?>"><?php echo $chat_escalation['dd_val12'] ?></option>
												<option value="">-Select-</option>
												<option value="More than 15 mins time taken to validate with Stock team">More than 15 mins time taken to validate with Stock team</option>
												<option value="More than 5 minutes time taken to check the information">More than 5 minutes time taken to check the information</option>
												<option value="Legitimate wait-time used">Legitimate wait-time used</option>
											</select>
										</td>
										
									</tr>

									<tr>
										<td colspan="2" class="prms_clm">4.2 Correct Information / Resolution provided</td>
										<td>10</td>
										<td>
											<select class="form-control chat_point" id="esclFatal6" name="correct_information" required>
												<option chat_val=10 <?php echo $chat_escalation['correct_information']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option chat_val=10 <?php echo $chat_escalation['correct_information']=='No'?"selected":""; ?> value="No">No</option>
												<option chat_val=0 <?php echo $chat_escalation['correct_information']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td>
											<select class="form-control" id="" name="dd_val13">
												<option value="<?php echo $chat_escalation['dd_val13'] ?>"><?php echo $chat_escalation['dd_val13'] ?></option>
												<option value="">-Select-</option>
												<option value="Incorrect information shared">Incorrect information shared</option>
												<option value="Incomplete Information shared">Incomplete Information shared</option>
												<option value="Proactively proposed for cancellation">Proactively proposed for cancellation</option>
												<option value="Cancelled the booking instead of shifting">Cancelled the booking instead of shifting</option>
												<option value="Cancelled CID booking without PM validation">Cancelled CID booking without PM validation</option>
												<option value="Incorrect Modification done">Incorrect Modification done</option>
												<option value="Incomplete Modification done">Incomplete Modification done</option>
												<option value="Modification/cancellation done without customer consent">Modification/cancellation done without customer consent</option>
												<option value="TAT not informed">TAT not informed</option>
												<option value="Incorrect TAT informed">Incorrect TAT informed</option>
												<option value="No Resolution given">No Resolution given</option>
												<option value="Incorrect Process followed">Incorrect Process followed</option>
											</select>
										</td>
										
									</tr>

									<tr>
										<td colspan="2" class="prms_clm" >4.3 Correct refund or complimentary procedure</td>
										<td>5</td>
										<td>
											<select class="form-control chat_point" id="" name="correct_refund" required>
												<option chat_val=5 <?php echo $chat_escalation['correct_refund']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option chat_val=5 <?php echo $chat_escalation['correct_refund']=='No'?"selected":""; ?> value="No">No</option>
												<option chat_val=0 <?php echo $chat_escalation['correct_refund']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td>
											<select class="form-control" id="" name="dd_val14">
												<option value="<?php echo $chat_escalation['dd_val14'] ?>"><?php echo $chat_escalation['dd_val14'] ?></option>
												<option value="">-Select-</option>
												<option value="Did not raise refund in OREO">Did not raise refund in OREO</option>
												<option value="Raised OREO with incorrect tagging">Raised OREO with incorrect tagging</option>
												<option value="Refund/complimentary processed outside the SOP">Refund/complimentary processed outside the SOP</option>
												<option value="Incorrect complimentary added">Incorrect complimentary added</option>
												<option value="Did not add complimentary">Did not add complimentary</option>
												<option value="Did not mark an email to concerned department">Did not mark an email to concerned department</option>
											</select>
										</td>
										
									</tr>
									<tr>
										<td colspan="2" class="prms_clm" >4.4 Proper follow up with PM/Stock team</td>
										<td>6</td>
										<td>
											<select class="form-control chat_point" id="" name="proper_followup" required>
												<option chat_val=6 <?php echo $chat_escalation['proper_followup']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option chat_val=6 <?php echo $chat_escalation['proper_followup']=='No'?"selected":""; ?> value="No">No</option>
												<option chat_val=0 <?php echo $chat_escalation['proper_followup']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td>
											<select class="form-control" id="" name="dd_val15">
												<option value="<?php echo $chat_escalation['dd_val15'] ?>"><?php echo $chat_escalation['dd_val15'] ?></option>
												<option value="">-Select-</option>
												<option value="Proper follow up with PM/Stock Team not done">Proper follow up with PM/Stock Team not done</option>
												<option value="Did Not Call">Did Not Call</option>
												<option value="Did not email">Did not email</option>
												<option value="Appropriate validation not done">Appropriate validation not done</option>
											</select>
										</td>
										
									</tr>
									<tr>
										<td rowspan=4 style="background-color:#A9CCE3; font-weight:bold">5. Documentation</td>
										<td colspan="2" class="prms_clm">5.1 Complete and correct notes (CRS/Lifeline/OYO desk)</td>
										<td>5</td>
										<td>
											<select class="form-control chat_point" id="" name="complete_notes" required>
												<option chat_val=5 <?php echo $chat_escalation['complete_notes']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option chat_val=5 <?php echo $chat_escalation['complete_notes']=='No'?"selected":""; ?> value="No">No</option>
												<option chat_val=0 <?php echo $chat_escalation['complete_notes']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td>
											<select class="form-control" id="" name="dd_val16">
												<option value="<?php echo $chat_escalation['dd_val16'] ?>"><?php echo $chat_escalation['dd_val16'] ?></option>
												<option value="">-Select-</option>
												<option value="Did not capture notes">Did not capture notes</option>
												<option value="Incomplete notes captured">Incomplete notes captured</option>
												<option value="Incorrect notes captured">Incorrect notes captured</option>
											</select>
										</td>
										
									</tr>
									<tr>
										<td colspan="2" class="prms_clm">5.2 Tagging of Issue Category and sub category</td>
										<td>10</td>
										<td>
											<select class="form-control chat_point" id="" name="tagging_issue_category" required>
												<option chat_val=10 <?php echo $chat_escalation['tagging_issue_category']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option chat_val=10 <?php echo $chat_escalation['tagging_issue_category']=='No'?"selected":""; ?> value="No">No</option>
												<option chat_val=0 <?php echo $chat_escalation['tagging_issue_category']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td>
											<select class="form-control" id="" name="dd_val17">
												<option value="<?php echo $chat_escalation['dd_val17'] ?>"><?php echo $chat_escalation['dd_val17'] ?></option>
												<option value="">-Select-</option>
												<option value="Incorrect Issue selected">Incorrect Issue selected</option>
												<option value="Incorrect Category selected">Incorrect Category selected</option>
												<option value="Incorrect sub sub category selected">Incorrect sub sub category selected</option>
												<option value="Did not work on existing ticket ">Did not work on existing ticket </option>
											</select>
										</td>
									</tr>

									<tr>
										<td colspan="2" class="prms_clm">5.3 Correct Ticket Status and tagging of remaining fields in OYO deskk</td>
										<td>4</td>
										<td>
											<select class="form-control chat_point" id="" name="correct_ticket_status" required>
												<option chat_val=4 <?php echo $chat_escalation['correct_ticket_status']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option chat_val=4 <?php echo $chat_escalation['correct_ticket_status']=='No'?"selected":""; ?> value="No">No</option>
												<option chat_val=0 <?php echo $chat_escalation['correct_ticket_status']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td>
											<select class="form-control" id="" name="dd_val18">
												<option value="<?php echo $chat_escalation['dd_val18'] ?>"><?php echo $chat_escalation['dd_val18'] ?></option>
												<option value="">-Select-</option>
												<option value="Did not select the correct Ticket Type">Did not select the correct Ticket Type</option>
												<option value="Did not mention PNR number in case of OTA">Did not mention PNR number in case of OTA</option>
												<option value="Incorrect Ticket status selected except resolved">Incorrect Ticket status selected except resolved</option>
												<option value="Did not capture the booking ID in Resource column">Did not capture the booking ID in Resource column</option>
												<option value="Advisor did not mark case as “STUCK”">Advisor did not mark case as “STUCK”</option>
												<option value="Speling error of “STUCK” was observed">Speling error of “STUCK” was observed</option>
												<option value="Incorrectly updated PM/ Stock connectivity status">Incorrectly updated PM/ Stock connectivity status</option>
											</select>
										</td>
										
									</tr>

									<tr>
										<td colspan="2" class="prms_clm">5.4 Resolution Email to be sent to Guest</td>
										<td>3</td>
										<td>
											<select class="form-control chat_point" id="" name="resolution_email" required>
												<option chat_val=3 <?php echo $chat_escalation['resolution_email']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option chat_val=3 <?php echo $chat_escalation['resolution_email']=='No'?"selected":""; ?> value="No">No</option>
												<option chat_val=0 <?php echo $chat_escalation['resolution_email']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td>
											<select class="form-control" id="" name="dd_val19">
												<option value="<?php echo $chat_escalation['dd_val19'] ?>"><?php echo $chat_escalation['dd_val19'] ?></option>
												<option value="">-Select-</option>
												<option value="Did not send resolution Email">Did not send resolution Email</option>
												<option value="Incorrect/incomplete Resolution Email">Incorrect/incomplete Resolution Email</option>
												<option value="Grammatically incorrect resolution email">Grammatically incorrect resolution email</option>
												<option value="Resolution email sent without providing resolution">Resolution email sent without providing resolution</option>
												<option value="Noed to confirm guest email ID (where applicable)">Noed to confirm guest email ID (where applicable)</option>
											</select>
										</td>
										
									</tr>

									<tr>
										<td rowspan=4 style="background-color:#A9CCE3; font-weight:bold">6. Closing</td>

										<td colspan="2" class="prms_clm">6.1 Further Assistance Asked</td>
										<td>2</td>
										<td>
											<select class="form-control chat_point" id="" name="further_assistance" required>
												<option chat_val=2 <?php echo $chat_escalation['further_assistance']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option chat_val=2 <?php echo $chat_escalation['further_assistance']=='No'?"selected":""; ?> value="No">No</option>
												<option chat_val=0 <?php echo $chat_escalation['further_assistance']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td>
											<select class="form-control" id="" name="dd_val20">
												<option value="<?php echo $chat_escalation['dd_val20'] ?>"><?php echo $chat_escalation['dd_val20'] ?></option>
												<option value="">-Select-</option>
												<option value="Further assistance message not sent">Further assistance message not sent</option>
												<option value="Delay in FA >3 minutes">Delay in FA >3 minutes</option>
											</select>
										</td>
										
									</tr>
									<tr>
										<td colspan="2" class="prms_clm">6.2 G-sat avoidance</td>
										<td>2</td>
										<td>
											<select class="form-control chat_point" id="" name="infraction_Gsat" required>
												<option chat_val=2 <?php echo $chat_escalation['infraction_Gsat']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option chat_val=2 <?php echo $chat_escalation['infraction_Gsat']=='No'?"selected":""; ?> value="No">No</option>
												<option chat_val=0 <?php echo $chat_escalation['infraction_Gsat']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td>
											<select class="form-control" id="" name="dd_val21">
												<option value="<?php echo $chat_escalation['dd_val21'] ?>"><?php echo $chat_escalation['dd_val21'] ?></option>
												<option value="">-Select-</option>
												<option value="Agent changed ticket status to 'Closed' instead of 'Resolved'">Agent changed ticket status to 'Closed' instead of 'Resolved'</option>
											</select>
										</td>
										
									</tr>
									<tr>
										<td colspan="2" class="prms_clm">6.3 Closing done with branding of OYO</td>
										<td>3</td>
										<td>
											<select class="form-control chat_point" id="" name="OYO_branding_closing_done" required>
												<option chat_val=3 <?php echo $chat_escalation['OYO_branding_closing_done']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option chat_val=3 <?php echo $chat_escalation['OYO_branding_closing_done']=='No'?"selected":""; ?> value="No">No</option>
												<option chat_val=0 <?php echo $chat_escalation['OYO_branding_closing_done']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td>
											<select class="form-control" id="" name="dd_val22">
												<option value="<?php echo $chat_escalation['dd_val22'] ?>"><?php echo $chat_escalation['dd_val22'] ?></option>
												<option value="">-Select-</option>
												<option value="Closing message sent without branding of OYO">Closing message sent without branding of OYO</option>
												<option value="Closing message not sent">Closing message not sent</option>
												<option value="Closing sent before 1 min">Closing sent before 1 min</option>
												<option value="Delay in Closing >3 minutes">Delay in Closing >3 minutes</option>
											</select>
										</td>
									</tr>

									<tr>
										<td colspan="2" class="prms_clm">6.4 Disconnect check/Response time</td>
										<td>2</td>
										<td>
											<select class="form-control chat_point" id="" name="disconnect_check" required>
												<option chat_val=2 <?php echo $chat_escalation['disconnect_check']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option chat_val=2 <?php echo $chat_escalation['disconnect_check']=='No'?"selected":""; ?> value="No">No</option>
												<option chat_val=0 <?php echo $chat_escalation['disconnect_check']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td>
											<select class="form-control" id="" name="dd_val23">
												<option value="<?php echo $chat_escalation['dd_val23'] ?>"><?php echo $chat_escalation['dd_val23'] ?></option>
												<option value="">-Select-</option>
												<option value="Disconnect check message not sent">Disconnect check message not sent</option>
												<option value="Disconnect check message not sent before 3 minutes">Disconnect check message not sent before 3 minutes</option>
											</select>
										</td>
									</tr>

									<tr>
										<td rowspan=7 style="background-color:#A9CCE3; font-weight:bold">7. Advisor - Actionable</td>
										<td colspan="2" style="background-color:red; font-weight:bold">Transaction was handled ethically - Call/Chat was not disconnected</td>
										<td>-</td>
										<td>
											<select class="form-control chat_point" id="" name="transaction_handled" required>
												
												<option chat_val=0 <?php echo $chat_escalation['transaction_handled']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option chat_val=0 <?php echo $chat_escalation['transaction_handled']=='No'?"selected":""; ?> value="No">No</option>
												<option chat_val=0 <?php echo $chat_escalation['transaction_handled']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td>
											
										</td>

									</tr>
									<tr>
										<td colspan="2" style="background-color:red; font-weight:bold">Agent maintained profanity on the call</td>
										<td>-</td>
										<td>
											<select class="form-control chat_point" id="" name="agent_profanity" required>
												
												<option chat_val=0 <?php echo $chat_escalation['agent_profanity']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option chat_val=0 <?php echo $chat_escalation['agent_profanity']=='No'?"selected":""; ?> value="No">No</option>
												<option chat_val=0 <?php echo $chat_escalation['agent_profanity']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td>
											
										</td>
										
									</tr>

									<tr>
										<td colspan="2" style="background-color:red; font-weight:bold">Agent sounded rude/ sarcastic /degraded customer</td>
										<td>-</td>
										<td>
											<select class="form-control chat_point" id="" name="agent_sounded_rude" required>
												
												<option chat_val=0 <?php echo $chat_escalation['agent_sounded_rude']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option chat_val=0 <?php echo $chat_escalation['agent_sounded_rude']=='No'?"selected":""; ?> value="No">No</option>
												<option chat_val=0 <?php echo $chat_escalation['agent_sounded_rude']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td>
											
										</td>
										
									</tr>

									<tr>
										<td colspan="2" class="prms_clm2">Agent made false commitment to guest >> financial loss >>3000 INR</td>
										<td>-</td>
										<td>
											<select class="form-control chat_point" id="" name="false_commitment" required>
												
												<option chat_val=0 <?php echo $chat_escalation['false_commitment']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option chat_val=0 <?php echo $chat_escalation['false_commitment']=='No'?"selected":""; ?> value="No">No</option>
												<option chat_val=0<?php echo $chat_escalation['false_commitment']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td>
											
										</td>
										
									</tr>

									<tr>
										<td colspan="2" class="prms_clm2">Agent raised escalation ticket/worked on existing ticket</td>
										<td>-</td>
										<td>
											<select class="form-control chat_point" id="" name="agent_raised_escalation" required>
												
												<option chat_val=0 <?php echo $chat_escalation['agent_raised_escalation']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option chat_val=0 <?php echo $chat_escalation['agent_raised_escalation']=='No'?"selected":""; ?> value="No">No</option>
												<option chat_val=0 <?php echo $chat_escalation['agent_raised_escalation']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td>
											
										</td>
										
									</tr>

									<tr>
										<td colspan="2" class="prms_clm2">Agent raised duplicate tickets for the same category less than 14 days</td>
										<td>-</td>
										<td>
											<select class="form-control chat_point" id="" name="agent_raised_duplicate" required>
												
												<option chat_val=0 <?php echo $chat_escalation['agent_raised_duplicate']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option chat_val=0 <?php echo $chat_escalation['agent_raised_duplicate']=='No'?"selected":""; ?> value="No">No</option>
												<option chat_val=0 <?php echo $chat_escalation['agent_raised_duplicate']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td>
											
										</td>
										
									</tr>

									<tr>
										<td colspan="2" class="prms_clm2">Agent adhered to Escalation matrix /Did not refuse next level escalation</td>
										<td>-</td>
										<td>
											<select class="form-control chat_point" id="" name="agent_adhered" required>
												
												<option chat_val=0 <?php echo $chat_escalation['agent_adhered']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option chat_val=0 <?php echo $chat_escalation['agent_adhered']=='No'?"selected":""; ?> value="No">No</option>
												<option chat_val=0 <?php echo $chat_escalation['agent_adhered']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td>
											
										</td>
										
									</tr>
									<tr>
										<td>Call Summary:</td>
										<td colspan=2><textarea class="form-control" id="" name="call_summary"><?php echo $chat_escalation['call_summary'] ?></textarea></td>
										<td>Feedback:</td>
										<td colspan=2><textarea class="form-control" id="" name="feedback"><?php echo $chat_escalation['feedback'] ?></textarea></td>
									</tr>
									<tr>
										<td colspan="2">Upload Files</td>
										<?php if($escalation_id==0){ ?>
											<td colspan=4><input type="file" multiple class="form-control" id="attach_file" name="attach_file[]"></td>
										<?php }else{ 
											if($chat_escalation['attach_file']!=''){ ?>
											<td colspan="4">
												<?php $attach_file = explode(",",$chat_escalation['attach_file']);
												 foreach($attach_file as $mp){ ?>
													<audio controls='' style="background-color:#607F93"> 
													  <source src="<?php echo base_url(); ?>qa_files/qa_oyo_sig/sig_chat_escalation/<?php echo $mp; ?>" type="audio/ogg">
													  <source src="<?php echo base_url(); ?>qa_files/qa_oyo_sig/sig_chat_escalation/<?php echo $mp; ?>" type="audio/mpeg">
													</audio> </br>
												 <?php } ?>
											</td>
										<?php }else{
												echo '<td><b>No Files</b></td>';
											  }
										} ?>
									</tr>
									
									<?php if($escalation_id!=0){ ?>
										<tr><td colspan=2 style="font-size:16px; font-weight:bold">Agent Review:</td><td colspan=4><?php echo $chat_escalation['agent_rvw_note'] ?></td></tr>
										<tr><td colspan=2 style="font-size:16px; font-weight:bold">Management Review:</td><td colspan=4><?php echo $chat_escalation['mgnt_rvw_note'] ?></td></tr>
										<tr><td colspan=2 style="font-size:16px; font-weight:bold">Client Review:</td><td colspan=4><?php echo $chat_escalation['client_rvw_note'] ?></td></tr>
										
										<tr><td colspan=2  style="font-size:16px">Your Review</td><td colspan=4><textarea class="form-control1" style="width:100%" id="note" name="note" required></textarea></td></tr>
									<?php } ?>
									
									<?php 
									if($escalation_id==0){
										if(is_access_qa_module()==true || is_access_qa_operations_module()==true || is_quality_access_trainer()==true){ ?>
											<tr><td colspan=6><button class="btn btn-success waves-effect" type="submit" id="qaformsubmit" style="width:500px">SAVE</button></td></tr>
									<?php 
										} 
									}else{ 
										if(is_access_qa_module()==true || is_access_qa_operations_module()==true || is_quality_access_trainer()==true){
											if(is_available_qa_feedback($chat_escalation['entry_date'],72) == true){ ?>
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
