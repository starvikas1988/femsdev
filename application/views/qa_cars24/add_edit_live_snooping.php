<style>
.table > tbody > tr > td{
	text-align: center;
	font-size:12px;
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
										<td colspan="8" id="theader" style="font-size:30px">Live Snooping</td>
										<?php
										if($pre_booking_id==0){
											$auditorName = get_username();
											$auditDate = CurrDateMDY();
											$clDate_val='';
										}else{
											if($live_snooping['entry_by']!=''){
												$auditorName = $live_snooping['auditor_name'];
											}else{
												$auditorName = $live_snooping['client_name'];
											}
											$auditDate = mysql2mmddyy($live_snooping['audit_date']);
											$clDate_val = mysql2mmddyy($live_snooping['call_date']);
										}
									?>
										<input type="hidden" name="audit_start_time" value="<?php echo CurrMySqlDate(); ?>">
									</tr>
									<tr>
										<td colspan="3">QA Name:</td>
										<td><input type="text" class="form-control" value="<?php echo get_username(); ?>" disabled></td>
										<td colspan="">Audit Date:</td>
										<td><input type="text" class="form-control" value="<?php echo CurrDateMDY(); ?>" disabled></td>
										<td>Call Date:</td>
										<td ><input type="text" class="form-control" id="call_date" name="call_date" value="<?php echo $clDate_val; ?>" required></td>
									</tr>
									<tr>
										<td colspan="3">Agent:</td>
										<td>
											<select class="form-control agentName" id="agent_id" name="data[agent_id]" required>
												<option value="<?php echo $live_snooping['agent_id'] ?>"><?php echo $live_snooping['fname']." ".$live_snooping['lname'] ?></option>
												<option value="">-Select-</option>
												<?php foreach($agentName as $row):  ?>
													<option value="<?php echo $row['id']; ?>"><?php echo $row['name'].' ('.$row['fusion_id'].')'; ?></option>
												<?php endforeach; ?>
											</select>
										</td>
										<td>Campaign:</td>
										<td><input type="text" readonly class="form-control" id="campaign" name="" value="<?php echo $live_snooping['process_name'] ?>"></td>
										<td>L1 Supervisor:</td>
										<td>
											<select class="form-control" id="tl_id" name="data[tl_id]" readonly>
												<option value="<?php echo $live_snooping['tl_id'] ?>"><?php echo $live_snooping['tl_name'] ?></option>
												<option value="">--Select--</option>
												<?php foreach($tlname as $tl): ?>
													<option value="<?php echo $tl['id']; ?>"><?php echo $tl['fname']." ".$tl['lname']; ?></option>
												<?php endforeach; ?>	
											</select>
										</td>
									</tr>
									
									<tr>
										<td colspan="3">Actual Tagging:</td>
										<td><input type="text" class="form-control" id="actual_tagging" name="data[actual_tagging]" value="<?php echo $live_snooping['actual_tagging'] ?>" required></td>
										<td>Agent Tagging:</td>
										<td><input type="text" class="form-control" id="agent_tagging" name="data[agent_tagging]" value="<?php echo $live_snooping['agent_tagging'] ?>"  required></td>
										<td>Agent Tenure:</td>
										<td><input type="text" class="form-control" id="agen_tenure" name="data[agen_tenure]" value="<?php echo $live_snooping['agen_tenure'] ?>" required></td>
									</tr>

									<tr>
										<!-- <td colspan="3">Campaign:</td>
										<td><input type="text" readonly class="form-control" id="campaign" name="data[campaign]" value="<?php echo $live_snooping['campaign'] ?>"></td> -->
										<td colspan="3">Call Duration:</td>
										<td colspan="3"><input type="text" class="form-control" id="call_duration" name="data[call_duration]" value="<?php echo $live_snooping['call_duration'] ?>" required></td>
										<td colspan="" width="100px">Customer Contact Number:</td>
										<td colspan="4"><input type="text" class="form-control" name="data[customer_contact_number]" value="<?php echo $live_snooping['customer_contact_number'] ?>" required></td>
									</tr>
									
									<tr>
										<td colspan="3">Audit Type:</td>
										<td>
											<select class="form-control" id="audit_type" name="data[audit_type]" required>
												<option value="<?php echo $live_snooping['audit_type'] ?>"><?php echo $live_snooping['audit_type'] ?></option>
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
												<option value="<?php echo $live_snooping['auditor_type'] ?>"><?php echo $live_snooping['auditor_type'] ?></option>
												<option value="">-Select-</option>
												<option value="Master">Master</option>
												<option value="Regular">Regular</option>
											</select>
										</td>
										<td>VOC:</td>
										<td>
											<select class="form-control" id="voc" name="data[voc]" required>
												<option value="<?php echo $live_snooping['voc'] ?>"><?php echo $live_snooping['voc'] ?></option>
												<option value="">-Select-</option>
												<option value="1">1</option>
												<option value="2">2</option>
												<option value="3">3</option>
												<option value="4">4</option>
												<option value="5">5</option>
											</select>
										</td>
										<!-- <td style="font-weight:bold; font-size:15px; text-align:right">Overall Score:</td>
										<td><input type="text" readonly id="healthbridge_overall_score" name="data[overall_score]" class="form-control" style="font-weight:bold" value="<?php if($live_snooping['overall_score']){ echo $live_snooping['overall_score']; } else { echo '0.00'.'%'; } ?>"></td> -->
									</tr>

									<tr>
		                              	<td style="font-weight:bold; font-size:16px">Possible Score</td>
		                                 <td colspan="2"><input type="text" readonly id="healthbridge_possible" name="data[possible_score]" class="form-control" value="<?= $live_snooping['possible_score']?>" style="font-weight:bold"></td>

		                                 <td style="font-weight:bold; font-size:16px">Earned Score</td>
		                                 <td colspan="2"><input type="text" readonly id="healthbridge_earned" name="data[earned_score]" class="form-control" value="<?= $live_snooping['earned_score']?>" style="font-weight:bold"></td>                               
		 	                             <td style="font-weight:bold; font-size:16px">Overall Score:</td>
		                                 <td colspan="2"><input type="text" readonly id="healthbridge_overall_score" name="data[overall_score]" class="form-control" value="<?= $live_snooping['overall_score']?>%" style="font-weight:bold"></td>
                              		</tr>
			
									
									<tr style="background-color:#A9CCE3; font-weight:bold"><td colspan="4">Parameter</td><td>Weightage</td><td>Rating</td><td>Reason</td><td colspan=3>Remark</td></tr>
									<tr>
										
										<td colspan=4>1. Opening & Identification</td>
										<td>5</td>
										<td>
											<select class="form-control healthbridge_point" id="standardization1" name="data[Identification]" required>
												<option value="">-Select-</option>
												<option healthbridge_val=5 healthbridge_max_val=5 <?php echo $live_snooping['Identification']=='Good'?"selected":""; ?> value="Good">Good</option>
												<option healthbridge_val=1.5 healthbridge_max_val=5 <?php echo $live_snooping['Identification']=='Bad'?"selected":""; ?> value="Bad">Bad</option>
												<option healthbridge_val=3 healthbridge_max_val=5 <?php echo $live_snooping['Identification']=='Average'?"selected":""; ?> value="Average">Average</option>
												<option healthbridge_val=0 healthbridge_max_val=0 <?php echo $live_snooping['Identification']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>

										<td>
											<select class="form-control healthbridge_point" id="standardization1" name="data[Reason1]" required>
												
												<option value='---'>Select</option>
												<option <?php echo $live_snooping['Reason1']=='Opening of the call was not in proper language'?"selected":""; ?> value="Opening of the call was not in proper language">Opening of the call was not in proper language</option>
												<option <?php echo $live_snooping['Reason1']=='Opening not done in 3 seconds'?"selected":""; ?> value="Opening not done in 3 seconds">Opening not done in 3 seconds</option>
												<option <?php echo $live_snooping['Reason1']=='Opening Missing'?"selected":""; ?> value="Opening Missing">Opening Missing</option>
												<option <?php echo $live_snooping['Reason1']=='Did not address customer with available name'?"selected":""; ?> value="Did not address customer with available name">Did not address customer with available name</option>
												<option <?php echo $live_snooping['Reason1']=='Self-introduction missing'?"selected":""; ?> value="Self-introduction missing">Self-introduction missing</option>
												<option <?php echo $live_snooping['Reason1']=='Brand  missing/Incorrect Branding'?"selected":""; ?> value="Brand  missing/Incorrect Branding">Brand  missing/Incorrect Branding</option>
												<option <?php echo $live_snooping['Reason1']=='Purpose of the call not shared appropriately'?"selected":""; ?> value="Purpose of the call not shared appropriately">Purpose of the call not shared appropriately</option>
											</select>
										</td>
									
										<td><input type="text" class="form-control" name="data[cmt1]" value="<?php echo $live_snooping['cmt1'] ?>"></td>
									</tr>


									<tr>
										
										<td colspan=4>2. Customer assessment (Understanding customer needs)</td>
										<td>22</td>
										<td>
											<select class="form-control healthbridge_point" id="standardization1" name="data[handling]" required>
												<option value="">-Select-</option>
												<option healthbridge_val=22 healthbridge_max_val=22 <?php echo $live_snooping['handling']=='Good'?"selected":""; ?> value="Good">Good</option>
												<option healthbridge_val=6.6 healthbridge_max_val=22 <?php echo $live_snooping['handling']=='Bad'?"selected":""; ?> value="Bad">Bad</option>
												<option healthbridge_val=13.2 healthbridge_max_val=22 <?php echo $live_snooping['handling']=='Average'?"selected":""; ?> value="Average">Average</option>
												<option healthbridge_val=0 healthbridge_max_val=0 <?php echo $live_snooping['handling']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>


										<td>
											<select class="form-control healthbridge_point" id="standardization1" name="data[Reason2]" required>
												
												<option value='---'>Select</option>
												<option <?php echo $live_snooping['Reason2']=='Asked for area pincode without informing the purpose'?"selected":""; ?> value="Asked for area pincode without informing the purpose">Asked for area pincode without informing the purpose</option>
												<option <?php echo $live_snooping['Reason2']=='Asked for the customers name without acknowledging customers concern/purpose'?"selected":""; ?> value="Asked for the customers name without acknowledging customers concern/purpose">Asked for the customer's name without acknowledging customer's concern/purpose</option>
												<option <?php echo $live_snooping['Reason2']=='Asked for information not required at that stage'?"selected":""; ?> value="Asked for information not required at that stage">Asked for information not required at that stage</option>
												<option <?php echo $live_snooping['Reason2']=='Appropriate probing not done'?"selected":""; ?> value="Appropriate probing not done">Appropriate probing not done</option>
												<option <?php echo $live_snooping['Reason2']=='Car finding flow not adherered to'?"selected":""; ?> value="Car finding flow not adherered to">Car finding flow not adherered to</option>
											</select>
										</td>
									
										<td><input type="text" class="form-control" name="data[cmt2]" value="<?php echo $live_snooping['cmt2'] ?>"></td>
									</tr>


									<tr>
										
										<td colspan=4>3. Solution & Objection handling</td>
										<td>22</td>
										<td>
											<select class="form-control healthbridge_point" id="standardization1" name="data[handling1]" required>
												<option value="">-Select-</option>
												<option healthbridge_val=22 healthbridge_max_val=22 <?php echo $live_snooping['handling1']=='Good'?"selected":""; ?> value="Good">Good</option>
												<option healthbridge_val=6.6 healthbridge_max_val=22 <?php echo $live_snooping['handling1']=='Bad'?"selected":""; ?> value="Bad">Bad</option>
												<option healthbridge_val=13.2 healthbridge_max_val=22 <?php echo $live_snooping['handling1']=='Average'?"selected":""; ?> value="Average">Average</option>
												<option healthbridge_val=0 healthbridge_max_val=0 <?php echo $live_snooping['handling1']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>

										<td>
											<select class="form-control healthbridge_point" id="standardization1" name="data[Reason3]" required>
												
												<option value='---'>Select</option>
												<option <?php echo $live_snooping['Reason3']=='Car related query not addressed'?"selected":""; ?> value="Car related query not addressed">Car related query not addressed</option>
												<option <?php echo $live_snooping['Reason3']=='Test related query not addressed'?"selected":""; ?> value="Test related query not addressed">Test related query not addressed</option>
												<option <?php echo $live_snooping['Reason3']=='Loan related query not addressed'?"selected":""; ?> value="Loan related query not addressed">Loan related query not addressed</option>
												<option <?php echo $live_snooping['Reason3']=='USP not pitched'?"selected":""; ?> value="USP not pitched">USP not pitched</option>
												<option <?php echo $live_snooping['Reason3']=='Objection Handling not done'?"selected":""; ?> value="Objection Handling not done">Objection Handling not done</option>
												<option <?php echo $live_snooping['Reason3']=='Rebuttals not used'?"selected":""; ?> value="Rebuttals not used">Rebuttals not used</option>
												<option <?php echo $live_snooping['Reason3']=='Latest offer not informed to the customer'?"selected":""; ?> value="Latest offer not informed to the customer">Latest offer not informed to the customer</option>
											</select>
										</td>
									
										<td><input type="text" class="form-control" name="data[cmt3]" value="<?php echo $live_snooping['cmt3'] ?>"></td>
									</tr>


									<tr>
										
										<td colspan=4>4. Loan Process</td>
										<td>10</td>
										<td>
											<select class="form-control healthbridge_point" id="standardization1" name="data[Process]" required>
												<option value="">-Select-</option>
												<option healthbridge_val=10 healthbridge_max_val=10 <?php echo $live_snooping['Process']=='Good'?"selected":""; ?> value="Good">Good</option>
												<option healthbridge_val=3 healthbridge_max_val=10 <?php echo $live_snooping['Process']=='Bad'?"selected":""; ?> value="Bad">Bad</option>
												<option healthbridge_val=6 healthbridge_max_val=10 <?php echo $live_snooping['Process']=='Average'?"selected":""; ?> value="Average">Average</option>
												<option healthbridge_val=0 healthbridge_max_val=0 <?php echo $live_snooping['Process']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>


										<td>
											<select class="form-control healthbridge_point" id="standardization1" name="data[Reason4]" required>
												
												<option value='---'>Select</option>
												<option <?php echo $live_snooping['Reason4']=='Loan USP & benefits not pitched'?"selected":""; ?> value="Loan USP & benefits not pitched">Loan USP & benefits not pitched</option>
												<option <?php echo $live_snooping['Reason4']=='Did not check area servicability'?"selected":""; ?> value="Did not check area servicability">Did not check area servicability</option>
												<option <?php echo $live_snooping['Reason4']=='Did not check eligibility'?"selected":""; ?> value="Did not check eligibility">Did not check eligibility</option>
												<option <?php echo $live_snooping['Reason4']=='preapproved offer not shared'?"selected":""; ?> value="preapproved offer not shared">preapproved offer not shared</option>
												<option <?php echo $live_snooping['Reason4']=='Loan calculator not used.'?"selected":""; ?> value="Loan calculator not used.">Loan calculator not used.</option>
												<option <?php echo $live_snooping['Reason4']=='Loan documents not informed'?"selected":""; ?> value="Loan documents not informed">Loan documents not informed</option>
												<option <?php echo $live_snooping['Reason4']=='6 months bank statement not informed'?"selected":""; ?> value="6 months bank statement not informed">6 months bank statement not informed</option>
												<option <?php echo $live_snooping['Reason4']=='Bank statement link not shared'?"selected":""; ?> value="Bank statement link not shared">Bank statement link not shared</option>
												<option <?php echo $live_snooping['Reason4']=='How to upload bank statement not explained.'?"selected":""; ?> value="How to upload bank statement not explained.">How to upload bank statement not explained.</option>
											</select>
										</td>
									
										<td><input type="text" class="form-control" name="data[cmt4]" value="<?php echo $live_snooping['cmt4'] ?>"></td>
									</tr>


									<tr>
										
										<td colspan=4>5. Test drive booking process</td>
										<td>12</td>
										<td>
											<select class="form-control healthbridge_point" id="standardization1" name="data[booking_process]" required>
												<option value="">-Select-</option>
												<option healthbridge_val=12 healthbridge_max_val=12 <?php echo $live_snooping['booking_process']=='Good'?"selected":""; ?> value="Good">Good</option>
												<option healthbridge_val=3.6 healthbridge_max_val=12 <?php echo $live_snooping['booking_process']=='Bad'?"selected":""; ?> value="Bad">Bad</option>
												<option healthbridge_val=7.20 healthbridge_max_val=12 <?php echo $live_snooping['booking_process']=='Average'?"selected":""; ?> value="Average">Average</option>
												<option healthbridge_val=0 healthbridge_max_val=0 <?php echo $live_snooping['booking_process']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>

										<td>
											<select class="form-control healthbridge_point" id="standardization1" name="data[Reason5]" required>
												
												<option value='---'>Select</option>
												<option <?php echo $live_snooping['Reason5']=='Advisor failed to inform about the Key features of the car'?"selected":""; ?> value="Advisor failed to inform about the Key features of the car">Advisor failed to inform about the Key features of the car</option>
												<option <?php echo $live_snooping['Reason5']=='Payment mode not confirmed'?"selected":""; ?> value="Payment mode not confirmed">Payment mode not confirmed</option>
												<option <?php echo $live_snooping['Reason5']=='Store distance not checked'?"selected":""; ?> value="Store distance not checked">Store distance not checked</option>
												<option <?php echo $live_snooping['Reason5']=='Payment mode not confirmed Self payment'?"selected":""; ?> value="Payment mode not confirmed Self payment">Payment mode not confirmed Self payment</option>
												<option <?php echo $live_snooping['Reason5']=='Payment mode not confirmed Finance'?"selected":""; ?> value="Payment mode not confirmed Finance">Payment mode not confirmed Finance</option>
												<option <?php echo $live_snooping['Reason5']=='Delivery mode not confirmed( Store/ Home test drive)'?"selected":""; ?> value="Delivery mode not confirmed( Store/ Home test drive)">Delivery mode not confirmed( Store/ Home test drive)</option>
												<option <?php echo $live_snooping['Reason5']=='Date not confirmed'?"selected":""; ?> value="Date not confirmed">Date not confirmed</option>
												<option <?php echo $live_snooping['Reason5']=='Time slot not confirmed'?"selected":""; ?> value="Time slot not confirmed">Time slot not confirmed</option>
												<option <?php echo $live_snooping['Reason5']=='Time slot not confirmed'?"selected":""; ?> value="Time slot not confirmed">Advisor have the opportunity to convince the customer on call book but didn't convince the customer</option>
											</select>
										</td>
									
										<td><input type="text" class="form-control" name="data[cmt5]" value="<?php echo $live_snooping['cmt5'] ?>"></td>
									</tr>


									<tr>
										
										<td colspan=4>6. Rapport Building & Conversation</td>
										<td>10</td>
										<td>
											<select class="form-control healthbridge_point" id="standardization1" name="data[Conversation]" required>
												<option value="">-Select-</option>
												<option healthbridge_val=10 healthbridge_max_val=10 <?php echo $live_snooping['Conversation']=='Good'?"selected":""; ?> value="Good">Good</option>
												<option healthbridge_val=3 healthbridge_max_val=10 <?php echo $live_snooping['Conversation']=='Bad'?"selected":""; ?> value="Bad">Bad</option>
												<option healthbridge_val=6 healthbridge_max_val=10 <?php echo $live_snooping['Conversation']=='Average'?"selected":""; ?> value="Average">Average</option>
												<option healthbridge_val=0 healthbridge_max_val=0 <?php echo $live_snooping['Conversation']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>

										<td>
											<select class="form-control healthbridge_point" id="standardization1" name="data[Reason6]" required>
												
												<option value='---'>Select</option>
												<option <?php echo $live_snooping['Reason6']=='Two way communication was missing'?"selected":""; ?> value="Two way communication was missing">Two way communication was missing</option>
												<option <?php echo $live_snooping['Reason6']=='Advisor rate of speech'?"selected":""; ?> value="Advisor rate of speech">Advisor rate of speech</option>
												<option <?php echo $live_snooping['Reason6']=='Did not personalize'?"selected":""; ?> value="Did not personalize">Did not personalize</option>
												<option <?php echo $live_snooping['Reason6']=='Did not keep appropriate tone'?"selected":""; ?> value="Did not keep appropriate tone">Did not keep appropriate tone</option>
												<option <?php echo $live_snooping['Reason6']=='Did not apologize'?"selected":""; ?> value="Did not apologize">Did not apologize</option>
												<option <?php echo $live_snooping['Reason6']=='Dull tone/sounded lethargic'?"selected":""; ?> value="Dull tone/sounded lethargic">Dull tone/sounded lethargic</option>
												<option <?php echo $live_snooping['Reason6']=='Did not follow the hold/unhold procedure'?"selected":""; ?> value="Did not follow the hold/unhold procedure">Did not follow the hold/unhold procedure</option>
												<option <?php echo $live_snooping['Reason6']=='Did not actively listen to the customer concern'?"selected":""; ?> value="Did not actively listen to the customer concern">Did not actively listen to the customer concern</option>
												<option <?php echo $live_snooping['Reason6']=='Did not acknowledge customer query/ concern'?"selected":""; ?> value="Did not acknowledge customer query/ concern">Did not acknowledge customer query/ concern</option>
												<option <?php echo $live_snooping['Reason6']=='Interrupted the customer'?"selected":""; ?> value="Interrupted the customer">Interrupted the customer</option>
												<option <?php echo $live_snooping['Reason6']=='Dead air found more than 5 secs'?"selected":""; ?> value="Dead air found more than 5 secs">Dead air found more than 5 secs</option>
												<option <?php echo $live_snooping['Reason6']=='Sentence formation was missing'?"selected":""; ?> value="Sentence formation was missing">Sentence formation was missing</option>
												<option <?php echo $live_snooping['Reason6']=='Incorrect choice of words used on the call'?"selected":""; ?> value="Incorrect choice of words used on the call">Incorrect choice of words used on the call</option>
												<option <?php echo $live_snooping['Reason6']=='Used jargons/Internal refrences on call'?"selected":""; ?> value="Used jargons/Internal refrences on call">Used jargons/Internal refrences on call</option>
												<option <?php echo $live_snooping['Reason6']=='Used typical hindi termso'?"selected":""; ?> value="Used typical hindi terms">Used typical hindi terms</option>
												<option <?php echo $live_snooping['Reason6']=='Fumbled & did not speak clearly'?"selected":""; ?> value="Fumbled & did not speak clearly">Fumbled & did not speak clearly</option>
											</select>
										</td>
									
										<td><input type="text" class="form-control" name="data[cmt6]" value="<?php echo $live_snooping['cmt6'] ?>"></td>
									</tr>


									<tr>
										
										<td colspan=4>7. Disposition</td>
										<td>3</td>
										<td>
											<select class="form-control healthbridge_point" id="standardization1" name="data[information]" required>
												<option value="">-Select-</option>
												<option healthbridge_val=3 healthbridge_max_val=3 <?php echo $live_snooping['information']=='Good'?"selected":""; ?> value="Good">Good</option>
												<option healthbridge_val=0.9 healthbridge_max_val=3 <?php echo $live_snooping['information']=='Bad'?"selected":""; ?> value="Bad">Bad</option>
												<option healthbridge_val=1.8 healthbridge_max_val=3 <?php echo $live_snooping['information']=='Average'?"selected":""; ?> value="Average">Average</option>
												<option healthbridge_val=0 healthbridge_max_val=0 <?php echo $live_snooping['information']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>

										<td>
											<select class="form-control healthbridge_point" id="standardization1" name="data[Reason7]" required>
												
												<option value='---'>Select</option>
												<option <?php echo $live_snooping['Reason7']=='Did not choose correct disposition'?"selected":""; ?> value="Did not choose correct disposition">Did not choose correct disposition</option>
												<option <?php echo $live_snooping['Reason7']=='Did not choose correct sub disposition'?"selected":""; ?> value="Did not choose correct sub disposition">Did not choose correct sub disposition</option>
											</select>
										</td>
									
										<td><input type="text" class="form-control" name="data[cmt7]" value="<?php echo $live_snooping['cmt7'] ?>"></td>
									</tr>


									<tr>
										
										<td colspan=4>8. Closing</td>
										<td>3</td>
										<td>
											<select class="form-control healthbridge_point" id="standardization1" name="data[Closing]" required>
												<option value="">-Select-</option>
												<option healthbridge_val=3 healthbridge_max_val=3 <?php echo $live_snooping['Closing']=='Good'?"selected":""; ?> value="Good">Good</option>
												<option healthbridge_val=0.9 healthbridge_max_val=3 <?php echo $live_snooping['Closing']=='Bad'?"selected":""; ?> value="Bad">Bad</option>
												<option healthbridge_val=1.8 healthbridge_max_val=3 <?php echo $live_snooping['Closing']=='Average'?"selected":""; ?> value="Average">Average</option>
												<option healthbridge_val=0 healthbridge_max_val=0 <?php echo $live_snooping['Closing']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>

										<td>
											<select class="form-control healthbridge_point" id="standardization1" name="data[Reason8]" required>
												
												<option value='---'>Select</option>
												<option <?php echo $live_snooping['Reason8']=='Did not summarize'?"selected":""; ?> value="Did not summarize">Did not summarize</option>
												<option <?php echo $live_snooping['Reason8']=='further assistance missing'?"selected":""; ?> value="further assistance missing">further assistance missing</option>
												<option <?php echo $live_snooping['Reason8']=='CSAT not pitched'?"selected":""; ?> value="CSAT not pitched">CSAT not pitched</option>
												<option <?php echo $live_snooping['Reason8']=='closing missing'?"selected":""; ?> value="closing missing">closing missing</option>
											</select>
										</td>
									
										<td><input type="text" class="form-control" name="data[cmt8]" value="<?php echo $live_snooping['cmt8'] ?>"></td>
									</tr>


									<tr>
										
										<td colspan=4>9. Wrong or misleading information</td>
										<td>13</td>
										<td>
											<select class="form-control healthbridge_point" id="standardization1" name="data[misleading]" required>
												<option value="">-Select-</option>
												<option healthbridge_val=13 healthbridge_max_val=13 <?php echo $live_snooping['misleading']=='Good'?"selected":""; ?> value="Good">Good</option>
												<option healthbridge_val=3.9 healthbridge_max_val=13 <?php echo $live_snooping['misleading']=='Bad'?"selected":""; ?> value="Bad">Bad</option>
												<option healthbridge_val=7.8 healthbridge_max_val=13 <?php echo $live_snooping['misleading']=='Average'?"selected":""; ?> value="Average">Average</option>
												<option healthbridge_val=0 healthbridge_max_val=0 <?php echo $live_snooping['misleading']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>

										<td>
											<select class="form-control healthbridge_point" id="standardization1" name="data[Reason9]" required>
												
												<option value='---'>Select</option>
												<option <?php echo $live_snooping['Reason9']=='Incorrect TAT informed'?"selected":""; ?> value="Incorrect TAT informed">Incorrect TAT informed</option>
												<option <?php echo $live_snooping['Reason9']=='Incorrect information related to the price negotiation'?"selected":""; ?> value="Incorrect information related to the price negotiation">Incorrect information related to the price negotiation</option>
												<option <?php echo $live_snooping['Reason9']=='Incorrect information related to the finance'?"selected":""; ?> value="Incorrect information related to the finance">Incorrect information related to the finance</option>
												<option <?php echo $live_snooping['Reason9']=='Incorrect information shared about the test drive'?"selected":""; ?> value="Incorrect information shared about the test drive">Incorrect information shared about the test drive</option>
												<option <?php echo $live_snooping['Reason9']=='Incorrect information shared about the car related /Warranty/Insurance/ 7days return/RC'?"selected":""; ?> value="Incorrect information shared about the car related /Warranty/Insurance/ 7days return/RC">Incorrect information shared about the car related /Warranty/Insurance/ 7days return/RC</option>
												<option <?php echo $live_snooping['Reason9']=='Did the forceful booking found without customer consent'?"selected":""; ?> value="Did the forceful booking found without customer consent">Did the forceful booking found without customer consent</option>
												<option <?php echo $live_snooping['Reason9']=='Did the fake booking found without confirming any details from the custome'?"selected":""; ?> value="Did the fake booking found without confirming any details from the custome">Did the fake booking found without confirming any details from the custome</option>
											</select>
										</td>
									
										<td><input type="text" class="form-control" name="data[cmt9]" value="<?php echo $live_snooping['cmt9'] ?>"></td>
									</tr>

									
									<tr>
										<td colspan="3">Call Synopsis:</td>
										<td colspan=3><textarea class="form-control" id="" name="data[call_summary]"><?php echo $live_snooping['call_summary'] ?></textarea></td>
										<td>Area of improvement:</td>
										<td colspan=3><textarea class="form-control" id="" name="data[feedback]"><?php echo $live_snooping['feedback'] ?></textarea></td>
									</tr>
									
									

									<?php if($pre_booking_id==0){ ?>
									<tr>
										<td colspan=2>Upload Files (wav,wmv,mp3,mp4)</td>
										<td colspan=4><input type="file" multiple class="form-control audioFile" id="attach_file" name="attach_file[]"></td>
									</tr>
									<?php }else{ ?>
									<tr>	
										<td colspan=2>Upload Files (wav,wmv,mp3,mp4)</td>
										<?php if($live_snooping['attach_file']!=''){ ?>
											<td colspan=4>
												<?php $attach_file = explode(",",$live_snooping['attach_file']);
												 foreach($attach_file as $mp){ ?>
													<audio controls='' style="background-color:#607F93"> 
													  <source src="<?php echo base_url(); ?>qa_files/pre_booking/<?php echo $mp; ?>" type="audio/ogg">
													  <source src="<?php echo base_url(); ?>qa_files/pre_booking/<?php echo $mp; ?>" type="audio/mpeg">
													</audio> </br>
												 <?php } ?>
											</td>
										<?php }else{
												//echo '<td colspan=6><b>No Files</b></td>';
											  }
										} ?>
									</tr>
									
									
									<?php if($pre_booking_id!=0){ ?>
										<tr><td colspan=2 style="font-size:12px; font-weight:bold">Agent Feedback Acceptance:</td><td colspan=4><?php echo $live_snooping['agnt_fd_acpt'] ?></td></tr>
										<tr><td colspan=2 style="font-size:12px; font-weight:bold">Management Review:</td><td colspan=4><?php echo $live_snooping['mgnt_rvw_note'] ?></td></tr>
										<tr><td colspan=2 style="font-size:12px; font-weight:bold">Client Review:</td><td colspan=4><?php echo $live_snooping['client_rvw_note'] ?></td></tr>
										
										<tr><td colspan=2  style="font-size:12px">Your Review</td><td colspan=4><textarea class="form-control1" style="width:100%" id="note" name="note"  ><?php echo $live_snooping['agent_rvw_note'] ?></textarea></td></tr>
									<?php } ?>
									
									
									<?php 
									if($pre_booking_id==0){
										if(is_access_qa_module()==true || is_access_qa_operations_module()==true){ ?>
											<tr><td colspan=8><button class="btn btn-success waves-effect" type="submit" id="qaformsubmit" style="width:500px">SAVE</button></td></tr>
									<?php 
										} 
									}else{ 
										if(is_access_qa_module()==true || is_access_qa_operations_module()==true){
											 if($live_snooping['agent_rvw_note']=="") { ?>
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