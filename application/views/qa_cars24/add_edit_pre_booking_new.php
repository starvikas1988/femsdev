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
										<td colspan="7" id="theader" style="font-size:30px">Pre Booking</td>
										<?php
										if($pre_booking_id==0){
											$auditorName = get_username();
											$auditDate = CurrDateMDY();
											$clDate_val='';
										}else{
											if($pre_booking['entry_by']!=''){
												$auditorName = $pre_booking['auditor_name'];
											}else{
												$auditorName = $pre_booking['client_name'];
											}
											$auditDate = mysql2mmddyy($pre_booking['audit_date']);
											$clDate_val = mysql2mmddyy($pre_booking['call_date']);
										}
									?>
										<input type="hidden" name="audit_start_time" value="<?php echo CurrMySqlDate(); ?>">
									</tr>
									<tr>
										<td colspan="2">QA Name:</td>
										<td><input type="text" class="form-control" value="<?php echo get_username(); ?>" disabled></td>
										<td>Audit Date:</td>
										<td><input type="text" class="form-control" value="<?php echo CurrDateMDY(); ?>" disabled></td>
										<td>Call Date:</td>
										<td><input type="text" class="form-control" id="call_date" name="call_date" value="<?php echo $clDate_val; ?>" required></td>
									</tr>
									<tr>
										<td colspan="2">Agent:</td>
										<td>
											<select class="form-control agentName" id="agent_id" name="data[agent_id]" required>
												<option value="<?php echo $pre_booking['agent_id'] ?>"><?php echo $pre_booking['fname']." ".$pre_booking['lname'] ?></option>
												<option value="">-Select-</option>
												<?php foreach($agentName as $row):  ?>
													<option value="<?php echo $row['id']; ?>"><?php echo $row['name'].' ('.$row['fusion_id'].')'; ?></option>
												<?php endforeach; ?>
											</select>
										</td>
										<td>Campaign:</td>
										<td><input type="text" readonly class="form-control" id="campaign" name="" value="<?php echo $pre_booking['process_name'] ?>"></td>
										<td>L1 Supervisor:</td>
										<td>
											<select class="form-control" id="tl_id" name="data[tl_id]" readonly>
												<option value="<?php echo $pre_booking['tl_id'] ?>"><?php echo $pre_booking['tl_name'] ?></option>
												<option value="">--Select--</option>
												<?php foreach($tlname as $tl): ?>
													<option value="<?php echo $tl['id']; ?>"><?php echo $tl['fname']." ".$tl['lname']; ?></option>
												<?php endforeach; ?>	
											</select>
										</td>
									</tr>
									<tr>
										<td colspan="2">Campaign:</td>
										<td><input type="text" readonly class="form-control" id="campaign" name="data[campaign]" value="<?php echo $pre_booking['campaign'] ?>"></td>
										<td>Call Duration:</td>
										<td><input type="text" class="form-control" id="call_duration" name="data[call_duration]" value="<?php echo $pre_booking['call_duration'] ?>" required></td>
										<td>Customer Contact Number:</td>
										<td><input type="text" class="form-control" name="data[customer_contact_number]" value="<?php echo $pre_booking['customer_contact_number'] ?>" onkeyup="checkDec(this);" required></td>
									</tr>
									<tr>
										<td colspan="2">Actual Tagging:</td>
										<td><input type="text" class="form-control" id="actual_tagging" name="data[actual_tagging]" value="<?php echo $pre_booking['actual_tagging'] ?>" required></td>
										<td>Agent Tagging:</td>
										<td><input type="text" class="form-control" id="agent_tagging" name="data[agent_tagging]" value="<?php echo $pre_booking['agent_tagging'] ?>"  required></td>
										<td>Agent Tenure:</td>
										<td><input type="text" class="form-control" id="agen_tenure" name="data[agen_tenure]" value="<?php echo $pre_booking['agen_tenure'] ?>" required></td>
									</tr>
									
									<tr>
										<td colspan="2">Audit Type:</td>
										<td>
											<select class="form-control" id="audit_type" name="data[audit_type]" required>
												<option value="<?php echo $pre_booking['audit_type'] ?>"><?php echo $pre_booking['audit_type'] ?></option>
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
												<option value="<?php echo $pre_booking['auditor_type'] ?>"><?php echo $pre_booking['auditor_type'] ?></option>
												<option value="">-Select-</option>
												<option value="Master">Master</option>
												<option value="Regular">Regular</option>
											</select>
										</td>
										<td>VOC:</td>
										<td>
											<select class="form-control" id="voc" name="data[voc]" required>
												<option value="<?php echo $pre_booking['voc'] ?>"><?php echo $pre_booking['voc'] ?></option>
												<option value="">-Select-</option>
												<option value="1">1</option>
												<option value="2">2</option>
												<option value="3">3</option>
												<option value="4">4</option>
												<option value="5">5</option>
											</select>
										</td>
										<td style="font-weight:bold; font-size:15px; text-align:right">Overall Score:</td>
										<td><input type="text" readonly id="pre_overallScore" name="data[overall_score]" class="form-control" style="font-weight:bold" value="<?php if($pre_booking['overall_score']){ echo $pre_booking['overall_score']; } else { echo '0.00'.'%'; } ?>"></td>
									</tr>
			
									
									<tr style="background-color:#A9CCE3; font-weight:bold"><td>Parameter</td><td colspan=2>Sub-Parameter</td><td>Weightage</td><td>Rating</td><td>Reason for No</td><td colspan=3>Remark</td></tr>
									<tr>
										<td rowspan=3 style="background-color:#A9CCE3; font-weight:bold">Opening & Identification</td>
										<td colspan=2>Did the advisor open the call correctly?</td>
										<td>2</td>
										<td>
											<select class="form-control pre_booking_point" id="standardization1" name="data[opening_done_within]" required>
												
												<option pre_booking_val=2 <?php echo $pre_booking['opening_done_within']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option pre_booking_val=2 <?php echo $pre_booking['opening_done_within']=='No'?"selected":""; ?> value="No">No</option>
												<option pre_booking_val=0 <?php echo $pre_booking['opening_done_within']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
										<td>
											<select class="form-control standard" id="standardization1" name="data[opening_done_within_no_reason]" required>
												<option value='---'>Select</option>
												<option <?php echo $pre_booking['opening_done_within']=='No'?"selected":""; ?> value="No">Delay opening done after 3 Secs</option>
												<option <?php echo $pre_booking['opening_done_within']=='No'?"selected":""; ?> value="No">Self Introduction was not done</option>
												<option <?php echo $pre_booking['opening_done_within']=='No'?"selected":""; ?> value="No">Greetings not done</option>
												<option <?php echo $pre_booking['opening_done_within']=='No'?"selected":""; ?> value="No">Company introduction was not done</option>
											</select>
										</td>
										<td><input type="text" class="form-control" name="data[cmt1]" value="<?php echo $pre_booking['cmt1'] ?>"></td>
									</tr>
									<tr>
										<td colspan=2>Did the advisor follow the customer identification process?</td>
										<td>1</td>
										<td>
											<select class="form-control pre_booking_point" id="standardization2" name="data[self_introduction]" required>
												
												<option pre_booking_val=1 <?php echo $pre_booking['self_introduction']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option pre_booking_val=1 <?php echo $pre_booking['self_introduction']=='No'?"selected":""; ?> value="No">No</option>
												<option pre_booking_val=0 <?php echo $pre_booking['self_introduction']=='NA'?"selected":""; ?> value="NA">NA</option>
												
											</select>
										</td>
										<td>
											<select class="form-control standard" id="standardization2" name="data[self_introduction_no_reason]" required>
												<option value='---'>Select</option>
												<option <?php echo $pre_booking['self_introduction']=='No'?"selected":""; ?> value="No">Customer identification not done</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt2]" value="<?php echo $pre_booking['cmt2'] ?>"></td>
									</tr>
									<tr>
										<td colspan=2>Did the advisor share the purpose of the call with the customer?</td>
										<td>2</td>
										<td>
											<select class="form-control pre_booking_point" id="standardization2" name="data[customer_identification]" required>
												
												<option pre_booking_val=2 <?php echo $pre_booking['customer_identification']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option pre_booking_val=2 <?php echo $pre_booking['customer_identification']=='No'?"selected":""; ?> value="No">No</option>
												<option pre_booking_val=0 <?php echo $pre_booking['customer_identification']=='NA'?"selected":""; ?> value="NA">NA</option>
												
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt3]" value="<?php echo $pre_booking['cmt3'] ?>"></td>
									</tr>

									<tr>
										<td rowspan=3 style="background-color:#A9CCE3; font-weight:bold">Relevant probing done to understand the customer needs and concern</td>
										<td colspan=2>Did the advisor ask appropriate fact-finding questions/do probing for the car booking?</td>
										<td>3</td>
										<td>
											<select class="form-control pre_booking_point" id="standardization2" name="data[purpose_of_the_call]" required>
												
												<option pre_booking_val=3 <?php echo $pre_booking['purpose_of_the_call']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option pre_booking_val=3 <?php echo $pre_booking['purpose_of_the_call']=='No'?"selected":""; ?> value="No">No</option>
												<option pre_booking_val=0 <?php echo $pre_booking['purpose_of_the_call']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
										<td>
											<select class="form-control standard" id="standardization2" name="data[purpose_of_the_call_no_reason]" required>
												<option value='---'>Select</option>
												<option <?php echo $pre_booking['purpose_of_the_call']=='No'?"selected":""; ?> value="No">Relevant probing was not done</option>
												<option <?php echo $pre_booking['purpose_of_the_call']=='No'?"selected":""; ?> value="No">Probing - On Car selection was not done</option>
												<option <?php echo $pre_booking['purpose_of_the_call']=='No'?"selected":""; ?> value="No">Probing - Customer refusal reason was not done</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt4]" value="<?php echo $pre_booking['cmt4'] ?>"></td>
									</tr>
										<td colspan=2 style="color:red">Did the advisor use effective rebuttals/sales and objection handling to encourage the customer to confirm the booking?</td>
										<td>4</td>
										<td>
											<select class="form-control pre_booking_point all_fatal1" id="tagging_fatal" name="data[effective_rebuttals]" required>
												
												<option pre_booking_val=4 <?php echo $pre_booking['effective_rebuttals']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option pre_booking_val=4 <?php echo $pre_booking['effective_rebuttals']=='No'?"selected":""; ?> value="No">No</option>
												<option pre_booking_val=0 <?php echo $pre_booking['effective_rebuttals']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt5]" value="<?php echo $pre_booking['cmt5'] ?>"></td>
									</tr>
									<tr>
										<td colspan=2>Did the advisor answer all customer queries effectively/ understanding the customer's concern/ comprehending well?</td>
										<td>4</td>
										<td>
											<select class="form-control pre_booking_point" id="pass_fail2" name="data[customer_concern]" required>
												
												<option pre_booking_val=4 <?php echo $pre_booking['customer_concern']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option pre_booking_val=4 <?php echo $pre_booking['customer_concern']=='No'?"selected":""; ?> value="No">No</option>
												<option pre_booking_val=0 <?php echo $pre_booking['customer_concern']=='NA'?"selected":""; ?> value="NA">NA</option>
												
											</select>
										</td>
										<td>
											<select class="form-control standard" id="standardization2" name="data[customer_concern_no_reason]" required>
												<option value='---'>Select</option>
												<option <?php echo $pre_booking['customer_concern']=='No'?"selected":""; ?> value="No">Not able to understand the customer concern</option>
												<option <?php echo $pre_booking['customer_concern']=='No'?"selected":""; ?> value="No">Not able to address the cusomer queries</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt6]" value="<?php echo $pre_booking['cmt6'] ?>"></td>
									</tr>

									<tr>
										<td rowspan=1 style="background-color:#A9CCE3; font-weight:bold"> USPs & Process Information</td>
										<td colspan=2>Did the advisor inform Comprehensive Warranty & CARS24 Quality Standards /7 day trial & Hassle-free RC transfer/CARS24 Consumer Finance & Benefits?</td>
										<td>5</td>
										<td>
											<select class="form-control pre_booking_point" id="pass_fail3" name="data[comprehensive_warranty]" required>
												
												<option pre_booking_val=5 <?php echo $pre_booking['comprehensive_warranty']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option pre_booking_val=5 <?php echo $pre_booking['comprehensive_warranty']=='No'?"selected":""; ?> value="No">No</option>
												<option pre_booking_val=0 <?php echo $pre_booking['comprehensive_warranty']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
										<td>
											<select class="form-control standard" id="standardization2" name="data[comprehensive_warranty_no_reason]" required>
												<option value='---'>Select</option>
												<option <?php echo $pre_booking['comprehensive_warranty']=='No'?"selected":""; ?> value="No">Comprehensive Warranty not ifnformed</option>
												<option <?php echo $pre_booking['comprehensive_warranty']=='No'?"selected":""; ?> value="No">7 day trial with 500Km driven not informed</option>
												<option <?php echo $pre_booking['comprehensive_warranty']=='No'?"selected":""; ?> value="No">CARS 24 Consumer Finance & Benefits not informed</option>
												<option <?php echo $pre_booking['comprehensive_warranty']=='No'?"selected":""; ?> value="No">CARS24 Quality Standards covered not informed</option>
												<option <?php echo $pre_booking['comprehensive_warranty']=='No'?"selected":""; ?> value="No">4 Days test drive information not shared</option>
												<option <?php echo $pre_booking['comprehensive_warranty']=='No'?"selected":""; ?> value="No">140 checks information not shared</option>
												<option <?php echo $pre_booking['comprehensive_warranty']=='No'?"selected":""; ?> value="No">Upto 100% finance not shared</option>
												<option <?php echo $pre_booking['comprehensive_warranty']=='No'?"selected":""; ?> value="No">Hassle-free RC transfer information not shared</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt7]" value="<?php echo $pre_booking['cmt7'] ?>"></td>
									</tr>

									<tr>
										<td rowspan=6 style="background-color:#A9CCE3; font-weight:bold">Booking Process</td>
										<td colspan=2 style="color:red">Did the advisor inform Car Details- Make/Model confirmed /Delivery Type, Date & Location confirmation (Hub-Pick Up/ Home Delivery)</td>
										<td>3</td>
										<td>
											<select class="form-control pre_booking_point all_fatal2" id="fatal6_com" name="data[delivery_type]" required>
												
												<option pre_booking_val=3 <?php echo $pre_booking['delivery_type']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option pre_booking_val=3 <?php echo $pre_booking['delivery_type']=='No'?"selected":""; ?> value="No">No</option>
												<option pre_booking_val=0 <?php echo $pre_booking['delivery_type']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
										<td>
											<select class="form-control standard" id="standardization2" name="data[delivery_type_no_reason]" required>
												<option value='---'>Select</option>
												<option <?php echo $pre_booking['delivery_type']=='No'?"selected":""; ?> value="No">Car name was not informed</option>
												<option <?php echo $pre_booking['delivery_type']=='No'?"selected":""; ?> value="No">Car model was not informed</option>
												<option <?php echo $pre_booking['delivery_type']=='No'?"selected":""; ?> value="No">Test Drive Type was not informed</option>
												<option <?php echo $pre_booking['delivery_type']=='No'?"selected":""; ?> value="No">Test Drive Date was not asked</option>
												<option <?php echo $pre_booking['delivery_type']=='No'?"selected":""; ?> value="No">Location confirmation was not asked</option>
												<option <?php echo $pre_booking['delivery_type']=='No'?"selected":""; ?> value="No">Hub details were not shared</option>
												<option <?php echo $pre_booking['delivery_type']=='No'?"selected":""; ?> value="No">Home Delivery address was not captured.Insurance information not shared</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt8]" value="<?php echo $pre_booking['cmt8'] ?>"></td>
									</tr>
									<tr>
										<td colspan=2>Did the advisor inform RC Transfer documents & RTO Charges Information (If Applicable)?</td>
										<td>2</td>
										<td>
											<select class="form-control pre_booking_point" id="fatal7_com" name="data[rc_ransfer_documents]" required>
												
												<option pre_booking_val=2 <?php echo $pre_booking['rc_ransfer_documents']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option pre_booking_val=2 <?php echo $pre_booking['rc_ransfer_documents']=='No'?"selected":""; ?> value="No">No</option>
												<option pre_booking_val=0 <?php echo $pre_booking['rc_ransfer_documents']=='NA'?"selected":""; ?> value="NA">NA</option>
												
											</select>
										</td>
											<td>
											<select class="form-control standard" id="standardization2" name="data[rc_ransfer_documents_no_reason]" required>
												<option value='---'>Select</option>
												<option <?php echo $pre_booking['rc_ransfer_documents']=='No'?"selected":""; ?> value="No">RC Documents not informed</option>
												<option <?php echo $pre_booking['rc_ransfer_documents']=='No'?"selected":""; ?> value="No">RTO charges not informed</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt9]" value="<?php echo $pre_booking['cmt9'] ?>"></td>
									</tr>
									<tr>
										<td colspan=2>Did the advisor confirm/capture the customer's Email-id confirmation/Whatsapp Opt-in pitching (if required)</td>
										<td>2</td>
										<td>
											<select class="form-control pre_booking_point" id="fatal7_com" name="data[whats_app_opt]" required>
												
												<option pre_booking_val=2 <?php echo $pre_booking['whats_app_opt']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option pre_booking_val=2 <?php echo $pre_booking['whats_app_opt']=='No'?"selected":""; ?> value="No">No</option>
												<option pre_booking_val=0 <?php echo $pre_booking['whats_app_opt']=='NA'?"selected":""; ?> value="NA">NA</option>
												
											</select>
										</td>
										<td>
											<select class="form-control standard" id="standardization2" name="data[whats_app_opt_no_reason]" required>
												<option value='---'>Select</option>
												<option <?php echo $pre_booking['whats_app_opt']=='No'?"selected":""; ?> value="No">Both details not asked</option>
												<option <?php echo $pre_booking['whats_app_opt']=='No'?"selected":""; ?> value="No">Customer Email ID not asked</option>
												<option <?php echo $pre_booking['whats_app_opt']=='No'?"selected":""; ?> value="No">What's app opt in option not asked</option>
												<option <?php echo $pre_booking['whats_app_opt']=='No'?"selected":""; ?> value="No">Email id asked but not inform about the important updates will be received</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt10]" value="<?php echo $pre_booking['cmt10'] ?>"></td>
									</tr>
									<tr>
										<td colspan=2>Did the advisor share the Order link/Car link?</td>
										<td>2</td>
										<td>
											<select class="form-control pre_booking_point" id="fatal7_com" name="data[car_details_link]" required>
												
												<option pre_booking_val=2 <?php echo $pre_booking['car_details_link']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option pre_booking_val=2 <?php echo $pre_booking['car_details_link']=='No'?"selected":""; ?> value="No">No</option>
												<option pre_booking_val=0 <?php echo $pre_booking['car_details_link']=='NA'?"selected":""; ?> value="NA">NA</option>
												
											</select>
										</td>
										<td>
											<select class="form-control standard" id="standardization2" name="data[car_details_link_no_reason]" required>
												<option value='---'>Select</option>
												<option <?php echo $pre_booking['car_details_link']=='No'?"selected":""; ?> value="No">Car link not shared</option>
												<option <?php echo $pre_booking['car_details_link']=='No'?"selected":""; ?> value="No">Order link not shared</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt11]" value="<?php echo $pre_booking['cmt11'] ?>"></td>
									</tr>
									<tr>
										<td colspan=2 style="color:red">Did the advisor inform about the booking and final payment amount?</td>
										<td>4</td>
										<td>
											<select class="form-control pre_booking_point all_fatal3" id="fatal7_com" name="data[payment_type_confirmation]" required>
												
												<option pre_booking_val=4 <?php echo $pre_booking['payment_type_confirmation']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option pre_booking_val=4 <?php echo $pre_booking['payment_type_confirmation']=='No'?"selected":""; ?> value="No">No</option>
												<option pre_booking_val=0 <?php echo $pre_booking['payment_type_confirmation']=='NA'?"selected":""; ?> value="NA">NA</option>
												
											</select>
										</td>
										<td>
											<select class="form-control standard" id="standardization2" name="data[payment_type_confirmation_no_reason]" required>
												<option value='---'>Select</option>
												<option <?php echo $pre_booking['payment_type_confirmation']=='No'?"selected":""; ?> value="No">Finace charges not informed</option>
												<option <?php echo $pre_booking['payment_type_confirmation']=='No'?"selected":""; ?> value="No">Booking amount not informed</option>
												<option <?php echo $pre_booking['payment_type_confirmation']=='No'?"selected":""; ?> value="No">Final payment informed</option>
											</select>
										</td>

										<td colspan=2><input type="text" class="form-control" name="data[cmt12]" value="<?php echo $pre_booking['cmt12'] ?>"></td>
									</tr>
									<tr>
										<td colspan=2>Did the advisor convince the customer to try to book a car on call?</td>
										<td>3</td>
										<td>
											<select class="form-control pre_booking_point" id="fatal7_com" name="data[consumer_convince_finance]" required>
												
												<option pre_booking_val=3 <?php echo $pre_booking['consumer_convince_finance']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option pre_booking_val=3 <?php echo $pre_booking['consumer_convince_finance']=='No'?"selected":""; ?> value="No">No</option>
												<option pre_booking_val=0 <?php echo $pre_booking['consumer_convince_finance']=='NA'?"selected":""; ?> value="NA">NA</option>
												
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt13]" value="<?php echo $pre_booking['cmt13'] ?>"></td>
									</tr>

									<tr>
										<td rowspan=3 style="background-color:#A9CCE3; font-weight:bold">Consumer finance</td>
										<td colspan=2>Did the advisor share a pre-approved offer/ capture loan details (if applicable)?</td>
										<td>2</td>
										<td>
											<select class="form-control pre_booking_point" id="standardization2" name="data[loan_details_capturing]" required>
												
												<option pre_booking_val=2 <?php echo $pre_booking['loan_details_capturing']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option pre_booking_val=2 <?php echo $pre_booking['loan_details_capturing']=='No'?"selected":""; ?> value="No">No</option>
												<option pre_booking_val=0 <?php echo $pre_booking['loan_details_capturing']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
										<td>
											<select class="form-control standard" id="standardization2" name="data[loan_details_capturing_no_reason]" required>
												<option value='---'>Select</option>
												<option <?php echo $pre_booking['loan_details_capturing']=='No'?"selected":""; ?> value="No">Loan Details not capturing</option>
												<option <?php echo $pre_booking['loan_details_capturing']=='No'?"selected":""; ?> value="No">Loan offer details not capture</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt14]" value="<?php echo $pre_booking['cmt14'] ?>"></td>
									</tr>
										<td colspan=2 style="color:red">Did the advisor inform about the loan documents and share the bank statement link (if applicable)?</td>
										<td>4</td>
										<td>
											<select class="form-control pre_booking_point all_fatal4" id="tagging_fatal" name="data[loan_documents_information]" required>
												
												<option pre_booking_val=4 <?php echo $pre_booking['loan_documents_information']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option pre_booking_val=4 <?php echo $pre_booking['loan_documents_information']=='No'?"selected":""; ?> value="No">No</option>
												<option pre_booking_val=0 <?php echo $pre_booking['loan_documents_information']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
										<td>
											<select class="form-control standard" id="standardization2" name="data[loan_documents_information_no_reason]" required>
												<option value='---'>Select</option>
												<option <?php echo $pre_booking['loan_documents_information']=='No'?"selected":""; ?> value="No">Loan Documents didn't share</option>
												<option <?php echo $pre_booking['loan_documents_information']=='No'?"selected":""; ?> value="No">Loan statement link not shared</option>
												<option <?php echo $pre_booking['loan_documents_information']=='No'?"selected":""; ?> value="No">Incomplete loan document information shared</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt15]" value="<?php echo $pre_booking['cmt15'] ?>"></td>
									</tr>
									<tr>
										<td colspan=2> Did the advisor inform you about the payment type?</td>
										<td>1</td>
										<td>
											<select class="form-control pre_booking_point" id="pass_fail2" name="data[payment_type_inform]" required>
												
												<option pre_booking_val=1 <?php echo $pre_booking['payment_type_inform']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option pre_booking_val=1 <?php echo $pre_booking['payment_type_inform']=='No'?"selected":""; ?> value="No">No</option>
												<option pre_booking_val=0 <?php echo $pre_booking['payment_type_inform']=='NA'?"selected":""; ?> value="NA">NA</option>
												
											</select>
										</td>
										<td>
											<select class="form-control standard" id="standardization2" name="data[payment_type_inform_no_reason]" required>
												<option value='---'>Select</option>
												<option <?php echo $pre_booking['payment_type_inform']=='No'?"selected":""; ?> value="No">Pay on delivery details missing</option>
												<option <?php echo $pre_booking['payment_type_inform']=='No'?"selected":""; ?> value="No">Finance details missing</option>
												<option <?php echo $pre_booking['payment_type_inform']=='No'?"selected":""; ?> value="No">Payment channel information not shared</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt16]" value="<?php echo $pre_booking['cmt16'] ?>"></td>
									</tr>

									<tr>
										<td rowspan=3 style="background-color:#A9CCE3; font-weight:bold">Clarity, Grammar, Tone & Regional Influence</td>
										<td colspan=2>Did the advisor speak clearly and concisely, maintain appropriate ROS?</td>
										<td>5</td>
										<td>
											<select class="form-control pre_booking_point" id="standardization2" name="data[voice_clarity]" required>
												
												<option pre_booking_val=5 <?php echo $pre_booking['voice_clarity']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option pre_booking_val=5 <?php echo $pre_booking['voice_clarity']=='No'?"selected":""; ?> value="No">No</option>
												<option pre_booking_val=0 <?php echo $pre_booking['voice_clarity']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
										<td>
											<select class="form-control standard" id="standardization2" name="data[voice_clarity_no_reason]" required>
												<option value='---'>Select</option>
												<option <?php echo $pre_booking['voice_clarity']=='No'?"selected":""; ?> value="No">Speak Clearly</option>
												<option <?php echo $pre_booking['voice_clarity']=='No'?"selected":""; ?> value="No">Speak Concisely</option>
												<option <?php echo $pre_booking['voice_clarity']=='No'?"selected":""; ?> value="No">Low ROS</option>
												<option <?php echo $pre_booking['voice_clarity']=='No'?"selected":""; ?> value="No">High ROS</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt17]" value="<?php echo $pre_booking['cmt17'] ?>"></td>
									</tr>
										<td colspan=2>Did you observe any regional influence and was the advisor able to construct the sentences appropriately to ensure better customer understanding?</td>
										<td>5</td>
										<td>
											<select class="form-control pre_booking_point all_fatal1" id="tagging_fatal" name="data[language_switching]" required>
												
												<option pre_booking_val=5 <?php echo $pre_booking['language_switching']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option pre_booking_val=5 <?php echo $pre_booking['language_switching']=='No'?"selected":""; ?> value="No">No</option>
												<option pre_booking_val=0 <?php echo $pre_booking['language_switching']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
										<td>
											<select class="form-control standard" id="standardization2" name="data[language_switching_no_reason]" required>
												<option value='---'>Select</option>
												<option <?php echo $pre_booking['loan_documents_information']=='No'?"selected":""; ?> value="No">MTI</option>
												<option <?php echo $pre_booking['loan_documents_information']=='No'?"selected":""; ?> value="No">RTI</option>
												<option <?php echo $pre_booking['loan_documents_information']=='No'?"selected":""; ?> value="No">Sentence formation Missing</option>
												<option <?php echo $pre_booking['loan_documents_information']=='No'?"selected":""; ?> value="No">Grammatical Error</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt18]" value="<?php echo $pre_booking['cmt18'] ?>"></td>
									</tr>
									<tr>
										<td colspan=2> Did the advisor sound energetic, confident and intonate well?</td>
										<td>4</td>
										<td>
											<select class="form-control pre_booking_point" id="pass_fail2" name="data[voice_modulation]" required>
												
												<option pre_booking_val=4 <?php echo $pre_booking['voice_modulation']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option pre_booking_val=4 <?php echo $pre_booking['voice_modulation']=='No'?"selected":""; ?> value="No">No</option>
												<option pre_booking_val=0 <?php echo $pre_booking['voice_modulation']=='NA'?"selected":""; ?> value="NA">NA</option>
												
											</select>
										</td>
										<td>
											<select class="form-control standard" id="standardization2" name="data[voice_modulation_no_reason]" required>
												<option value='---'>Select</option>
												<option <?php echo $pre_booking['voice_modulation']=='No'?"selected":""; ?> value="No">Tone was Robotic through out the call</option>
												<option <?php echo $pre_booking['voice_modulation']=='No'?"selected":""; ?> value="No">Sound was not confident</option>
												<option <?php echo $pre_booking['voice_modulation']=='No'?"selected":""; ?> value="No">Energetic throughout the call was missing</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt19]" value="<?php echo $pre_booking['cmt19'] ?>"></td>
									</tr>

									<tr>
										<td rowspan=3 style="background-color:#A9CCE3; font-weight:bold">Listening, Phone etiquettes, Fluency and Hold Procedure</td>
										<td colspan=2>Did the advisor actively listen to the customer throughout the call, avoid interruption, avoid repeating himself/herself during the call and appropriately</td>
										<td>5</td>
										<td>
											<select class="form-control pre_booking_point" id="standardization2" name="data[voice_repeating]" required>
												
												<option pre_booking_val=5 <?php echo $pre_booking['voice_repeating']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option pre_booking_val=5 <?php echo $pre_booking['voice_repeating']=='No'?"selected":""; ?> value="No">No</option>
												<option pre_booking_val=0 <?php echo $pre_booking['voice_repeating']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
										<td>
											<select class="form-control standard" id="standardization2" name="data[voice_repeating_no_reason]" required>
												<option value='---'>Select</option>
												<option <?php echo $pre_booking['voice_repeating']=='No'?"selected":""; ?> value="No">Advisor Interrupt the customer Advisor was not Attentive</option>
												<option <?php echo $pre_booking['voice_repeating']=='No'?"selected":""; ?> value="No">Acknowledgment Missing</option>
												<option <?php echo $pre_booking['voice_repeating']=='No'?"selected":""; ?> value="No">Advisor repeat the same word multiple times</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt20]" value="<?php echo $pre_booking['cmt20'] ?>"></td>
									</tr>
										<td colspan=2>Did the advisor avoid the usage of fillers and Jargon?</td>
										<td>2</td>
										<td>
											<select class="form-control pre_booking_point all_fatal1" id="tagging_fatal" name="data[filter_jardon]" required>
												
												<option pre_booking_val=2 <?php echo $pre_booking['filter_jardon']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option pre_booking_val=2 <?php echo $pre_booking['filter_jardon']=='No'?"selected":""; ?> value="No">No</option>
												<option pre_booking_val=0 <?php echo $pre_booking['filter_jardon']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
										<td>
											<select class="form-control standard" id="standardization2" name="data[filter_jardon_no_reason]" required>
												<option value='---'>Select</option>
												<option <?php echo $pre_booking['filter_jardon']=='No'?"selected":""; ?> value="No">Advisor used fillers on the call</option>
												<option <?php echo $pre_booking['filter_jardon']=='No'?"selected":""; ?> value="No">Advisor fumbled on the call</option>
												<option <?php echo $pre_booking['filter_jardon']=='No'?"selected":""; ?> value="No">Advisor Stammered on the call</option>
												<option <?php echo $pre_booking['filter_jardon']=='No'?"selected":""; ?> value="No">Advisor used Jargons on the call</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt21]" value="<?php echo $pre_booking['cmt21'] ?>"></td>
									</tr>
									<tr>
										<td colspan=2>Did the advisor follow the correct Hold /Transfer Procedure (HMT), Use Mute(if required) and avoid dead air during the call?</td>
										<td>3</td>
										<td>
											<select class="form-control pre_booking_point" id="pass_fail2" name="data[transfer_procedure]" required>
												
												<option pre_booking_val=3 <?php echo $pre_booking['transfer_procedure']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option pre_booking_val=3 <?php echo $pre_booking['transfer_procedure']=='No'?"selected":""; ?> value="No">No</option>
												<option pre_booking_val=0 <?php echo $pre_booking['transfer_procedure']=='NA'?"selected":""; ?> value="NA">NA</option>
												
											</select>
										</td>
										<td>
											<select class="form-control standard" id="standardization2" name="data[transfer_procedure_no_reason]" required>
												<option value='---'>Select</option>
												<option <?php echo $pre_booking['transfer_procedure']=='No'?"selected":""; ?> value="No">Hold Procedure not followed on call</option>
												<option <?php echo $pre_booking['transfer_procedure']=='No'?"selected":""; ?> value="No">Advisor voice was not observed for 5secs(Dead air)</option>
												<option <?php echo $pre_booking['transfer_procedure']=='No'?"selected":""; ?> value="No">Failed to use mute on the call</option>
												<option <?php echo $pre_booking['transfer_procedure']=='No'?"selected":""; ?> value="No">Hold/On-Hold Procedure not followed on call</option>
												<option <?php echo $pre_booking['transfer_procedure']=='No'?"selected":""; ?> value="No">On-Hold Procedure not followed on call</option>
												<option <?php echo $pre_booking['transfer_procedure']=='No'?"selected":""; ?> value="No">Unnecessary hold placed on call</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt22]" value="<?php echo $pre_booking['cmt22'] ?>"></td>
									</tr>

									<tr>
										<td rowspan=1 style="background-color:#A9CCE3; font-weight:bold">Conversational Skills</td>
										<td colspan=2>Did the advisor personalize over the call, use pleasantries words and statements/adjust the conversation as per the customer's requirements/circumstances in </td>
										<td>5</td>
										<td>
											<select class="form-control pre_booking_point" id="standardization2" name="data[personalize_call]" required>
												
												<option pre_booking_val=5 <?php echo $pre_booking['personalize_call']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option pre_booking_val=5 <?php echo $pre_booking['personalize_call']=='No'?"selected":""; ?> value="No">No</option>
												<option pre_booking_val=0 <?php echo $pre_booking['personalize_call']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
										<td>
											<select class="form-control standard" id="standardization2" name="data[personalize_call_no_reason]" required>
												<option value='---'>Select</option>
												<option <?php echo $pre_booking['personalize_call']=='No'?"selected":""; ?> value="No">Personalization was missing on the call</option>
												<option <?php echo $pre_booking['personalize_call']=='No'?"selected":""; ?> value="No">Pleasantries words are missing</option>
												<option <?php echo $pre_booking['personalize_call']=='No'?"selected":""; ?> value="No">Adjust the conversation with the customers requirement was missing</option>
												<option <?php echo $pre_booking['personalize_call']=='No'?"selected":""; ?> value="No">Circumstances in order to build rapport with the customer was missing</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt23]" value="<?php echo $pre_booking['cmt23'] ?>"></td>
									</tr>

									<tr>
										<td rowspan=3 style="background-color:#A9CCE3; font-weight:bold">Customer handling skills</td>
										<td colspan=2>Did the advisor use "Service No" techniques?</td>
										<td>2</td>
										<td>
											<select class="form-control pre_booking_point" id="standardization2" name="data[service_no_tech]" required>
												
												<option pre_booking_val=2 <?php echo $pre_booking['service_no_tech']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option pre_booking_val=2 <?php echo $pre_booking['service_no_tech']=='No'?"selected":""; ?> value="No">No</option>
												<option pre_booking_val=0 <?php echo $pre_booking['service_no_tech']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt24]" value="<?php echo $pre_booking['cmt24'] ?>"></td>
									</tr>
									<tr>
										<td colspan=2>Did the advisor empathise/apologise to the customer wherever required?</td>
										<td>4</td>
										<td>
											<select class="form-control pre_booking_point all_fatal1" id="tagging_fatal" name="data[empathise]" required>
												
												<option pre_booking_val=4 <?php echo $pre_booking['empathise']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option pre_booking_val=4 <?php echo $pre_booking['empathise']=='No'?"selected":""; ?> value="No">No</option>
												<option pre_booking_val=0 <?php echo $pre_booking['empathise']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
										<td>
											<select class="form-control standard" id="standardization2" name="data[empathise_no_reason]" required>
												<option value='---'>Select</option>
												<option <?php echo $pre_booking['empathise']=='No'?"selected":""; ?> value="No">Fail to Empathized</option>
												<option <?php echo $pre_booking['empathise']=='No'?"selected":""; ?> value="No">Apologized the customer whenever necessary during the call</option>
												<option <?php echo $pre_booking['empathise']=='No'?"selected":""; ?> value="No">Not able to Understand the customer's concern</option>
												<option <?php echo $pre_booking['empathise']=='No'?"selected":""; ?> value="No">Multiple apologized for the same reason</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt25]" value="<?php echo $pre_booking['cmt25'] ?>"></td>
									</tr>
									<tr>
										<td colspan=2 style="color:red">Was the advisor professional on the call? (they harassed/misbehaved/was rude/abused the customer).</td>
										<td>5</td>
										<td>
											<select class="form-control pre_booking_point all_fatal5" id="pass_fail2" name="data[rude_behaviour]" required>
												
												<option pre_booking_val=5 <?php echo $pre_booking['rude_behaviour']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option pre_booking_val=5 <?php echo $pre_booking['rude_behaviour']=='No'?"selected":""; ?> value="No">No</option>
												<option pre_booking_val=0 <?php echo $pre_booking['rude_behaviour']=='NA'?"selected":""; ?> value="NA">NA</option>
												
											</select>
										</td>
										<td>
											<select class="form-control standard" id="standardization2" name="data[rude_behaviour_no_reason]" required>
												<option value='---'>Select</option>
												<option <?php echo $pre_booking['rude_behaviour']=='No'?"selected":""; ?> value="No">Customer was harassed by the advisor</option>
												<option <?php echo $pre_booking['rude_behaviour']=='No'?"selected":""; ?> value="No">Advisor misbehave with the customer</option>
												<option <?php echo $pre_booking['rude_behaviour']=='No'?"selected":""; ?> value="No">Advisor was Rude on the call</option>
												<option <?php echo $pre_booking['rude_behaviour']=='No'?"selected":""; ?> value="No">Advisor tone was blunt on the call</option>
												<option <?php echo $pre_booking['rude_behaviour']=='No'?"selected":""; ?> value="No">Advisor use the foul language on the call</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt26]" value="<?php echo $pre_booking['cmt26'] ?>"></td>
									</tr>

									<tr>
										<td rowspan=1 style="background-color:#A9CCE3; font-weight:bold">Closing</td>
										<td colspan=2>Did the advisor summarize/further assistance/close the call appropriately with CSAT link?</td>
										<td>4</td>
										<td>
											<select class="form-control pre_booking_point" id="standardization2" name="data[csat_link]" required>
												
												<option pre_booking_val=4 <?php echo $pre_booking['csat_link']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option pre_booking_val=4 <?php echo $pre_booking['csat_link']=='No'?"selected":""; ?> value="No">No</option>
												<option pre_booking_val=0 <?php echo $pre_booking['csat_link']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
										<td>
											<select class="form-control standard" id="standardization2" name="data[csat_link_no_reason]" required>
												<option value='---'>Select</option>
												<option <?php echo $pre_booking['csat_link']=='No'?"selected":""; ?> value="No">Closing script was missing</option>
												<option <?php echo $pre_booking['csat_link']=='No'?"selected":""; ?> value="No">Further assistance was missing</option>
												<option <?php echo $pre_booking['csat_link']=='No'?"selected":""; ?> value="No">Summarization was missing</option>
												<option <?php echo $pre_booking['csat_link']=='No'?"selected":""; ?> value="No">Feedback link not inform to the customer</option>
												<option <?php echo $pre_booking['csat_link']=='No'?"selected":""; ?> value="No">Nothing was not followed on the call</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt27]" value="<?php echo $pre_booking['cmt27'] ?>"></td>
									</tr>

									<tr>
										<td rowspan=1 style="background-color:#A9CCE3; font-weight:bold">Documentation</td>
										<td colspan=2 style="color:red">Did the advisor use the correct disposition/update all notes and details correctly on the call?</td>
										<td>4</td>
										<td>
											<select class="form-control pre_booking_point all_fatal6" id="standardization2" name="data[correct_dispostion]" required>
												
												<option pre_booking_val=4 <?php echo $pre_booking['correct_dispostion']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option pre_booking_val=4 <?php echo $pre_booking['correct_dispostion']=='No'?"selected":""; ?> value="No">No</option>
												<option pre_booking_val=0 <?php echo $pre_booking['correct_dispostion']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
										<td>
											<select class="form-control standard" id="standardization2" name="data[correct_dispostion_no_reason]" required>
												<option value='---'>Select</option>
												<option <?php echo $pre_booking['correct_dispostion']=='No'?"selected":""; ?> value="No">Incorrect Disposition</option>
												<option <?php echo $pre_booking['correct_dispostion']=='No'?"selected":""; ?> value="No">Incomplete Notes</option>
												<option <?php echo $pre_booking['correct_dispostion']=='No'?"selected":""; ?> value="No">Incorrect Notes</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt28]" value="<?php echo $pre_booking['cmt28'] ?>"></td>
									</tr>

									<tr>
										<td rowspan=1 style="background-color:#A9CCE3; font-weight:bold">Correct and accurate info</td>
										<td colspan=2 style="color:red"> Did the advisor provide all accurate information and not mislead the customer, provide incorrect information, or make any false promises?</td>
										<td>4</td>
										<td>
											<select class="form-control pre_booking_point all_fatal7" id="standardization2" name="data[incorrect_information]" required>
												
												<option pre_booking_val=4 <?php echo $pre_booking['incorrect_information']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option pre_booking_val=4 <?php echo $pre_booking['incorrect_information']=='No'?"selected":""; ?> value="No">No</option>
												<option pre_booking_val=0 <?php echo $pre_booking['incorrect_information']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
										<td>
											<select class="form-control standard" id="standardization2" name="data[incorrect_information_no_reason]" required>
												<option value='---'>Select</option>
												<option <?php echo $pre_booking['incorrect_information']=='No'?"selected":""; ?> value="No">The CF form was not filled out by the customer & the agent informed you that you are not eligible for a loan.</option>
												<option <?php echo $pre_booking['incorrect_information']=='No'?"selected":""; ?> value="No">Although the bank statement was rejected,the agent informed you that you are qualified for a loan.</option>
												<option <?php echo $pre_booking['incorrect_information']=='No'?"selected":""; ?> value="No">The finance call's TAT was incorrectly shared.</option>
												<option <?php echo $pre_booking['incorrect_information']=='No'?"selected":""; ?> value="No">The down payment amount was incorrectly reported.</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt29]" value="<?php echo $pre_booking['cmt29'] ?>"></td>
									</tr>

									<tr>
										<td rowspan=1 style="background-color:#A9CCE3; font-weight:bold">Wrong Practices</td>
										<td colspan=2 style="color:red">Did not find any non-adherence to wrong practices.</td>
										<td>4</td>
										<td>
											<select class="form-control pre_booking_point all_fatal8" id="standardization2" name="data[unprofessional]" required>
												
												<option pre_booking_val=4 <?php echo $pre_booking['unprofessional']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option pre_booking_val=4 <?php echo $pre_booking['unprofessional']=='No'?"selected":""; ?> value="No">No</option>
												<option pre_booking_val=0 <?php echo $pre_booking['unprofessional']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
										<td>
											<select class="form-control standard" id="standardization2" name="data[unprofessional_no_reason]" required>
												<option value='---'>Select</option>
												<option <?php echo $pre_booking['unprofessional']=='No'?"selected":""; ?> value="No">Advisor disconnect the Call from his end</option>
												<option <?php echo $pre_booking['unprofessional']=='No'?"selected":""; ?> value="No">Advisor force the customer to book the car</option>
												<option <?php echo $pre_booking['unprofessional']=='No'?"selected":""; ?> value="No">Advisor didn't answer the Call</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt30]" value="<?php echo $pre_booking['cmt30'] ?>"></td>
									</tr>
									<tr>
										<td rowspan=1 style="background-color:#A9CCE3; font-weight:bold">Exceptional Call</td>
										<td colspan=2>Did the Advisor provide Customer Experience beyond expectation ?</td>
										<td></td>
										<td>
											<select class="form-control standard" id="standardization_ex" name="data[customer_experience]" required>
												
												<option <?php echo $pre_booking['customer_experience']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option <?php echo $pre_booking['customer_experience']=='No'?"selected":""; ?> value="No">No</option>
											</select>
										</td>
										<td>
											<select class="form-control standard" id="standardization_exsub" name="data[customer_experience_reason]" required>
												<option <?php echo $pre_booking['customer_experience_reason']=='Star Call'?"selected":""; ?> value="Star Call">Star Call</option>
												<option <?php echo $pre_booking['customer_experience_reason']=='Normal Call'?"selected":""; ?> value="Normal Call">Normal Call</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt31]" value="<?php echo $pre_booking['cmt31'] ?>"></td>
									</tr>
									<tr>
										<td rowspan=7 style="background-color:#A9CCE3; font-weight:bold">Others</td>
										<td colspan=2>Opening script followed as per new Guidelines</td>
										<td></td>
										<td>
											<select class="form-control" name="data[opening_script_follow]" required>
												<option <?php echo $pre_booking['opening_script_follow']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option <?php echo $pre_booking['opening_script_follow']=='No'?"selected":""; ?> value="No">No</option>
												<option <?php echo $pre_booking['opening_script_follow']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=3><input type="text" class="form-control" name="data[cmt44]" value="<?php echo $pre_booking['cmt44'] ?>"></td>
									</tr>
									<tr>
										<td colspan=2>Effective Objection handling was there or not- as per new guidelines</td>
										<td></td>
										<td>
											<select class="form-control" name="data[effective_objection_handling]" required>
												<option <?php echo $pre_booking['effective_objection_handling']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option <?php echo $pre_booking['effective_objection_handling']=='No'?"selected":""; ?> value="No">No</option>
												<option <?php echo $pre_booking['effective_objection_handling']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=3><input type="text" class="form-control" name="data[cmt45]" value="<?php echo $pre_booking['cmt45'] ?>"></td>
									</tr>
									<tr>
										<td colspan=2>Different Car suggested or not</td>
										<td></td>
										<td>
											<select class="form-control" name="data[different_car_suggest_or_not]" required>
												<option <?php echo $pre_booking['different_car_suggest_or_not']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option <?php echo $pre_booking['different_car_suggest_or_not']=='No'?"selected":""; ?> value="No">No</option>
												<option <?php echo $pre_booking['different_car_suggest_or_not']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=3><input type="text" class="form-control" name="data[cmt46]" value="<?php echo $pre_booking['cmt46'] ?>"></td>
									</tr>
									<tr>
										<td colspan=2>Booking probability as per QA</td>
										<td></td>
										<td>
											<select class="form-control" name="data[booking_probably_as_qa]" required>
												<option <?php echo $pre_booking['booking_probably_as_qa']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option <?php echo $pre_booking['booking_probably_as_qa']=='No'?"selected":""; ?> value="No">No</option>
												<option <?php echo $pre_booking['booking_probably_as_qa']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=3><input type="text" class="form-control" name="data[cmt47]" value="<?php echo $pre_booking['cmt47'] ?>"></td>
									</tr>
									<tr>
										<td colspan=2>Did the call was having two way conversation?</td>
										<td></td>
										<td>
											<select class="form-control" name="data[call_having_tow_way_conversion]" required>
												<option <?php echo $pre_booking['call_having_tow_way_conversion']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option <?php echo $pre_booking['call_having_tow_way_conversion']=='No'?"selected":""; ?> value="No">No</option>
												<option <?php echo $pre_booking['call_having_tow_way_conversion']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=3><input type="text" class="form-control" name="data[cmt48]" value="<?php echo $pre_booking['cmt48'] ?>"></td>
									</tr>
									<tr>
										<td colspan=2>Did the advisor followed replaced words or scripts?</td>
										<td></td>
										<td>
											<select class="form-control" name="data[advisor_follow_replace_words]" required>
												<option <?php echo $pre_booking['advisor_follow_replace_words']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option <?php echo $pre_booking['advisor_follow_replace_words']=='No'?"selected":""; ?> value="No">No</option>
												<option <?php echo $pre_booking['advisor_follow_replace_words']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=3><input type="text" class="form-control" name="data[cmt49]" value="<?php echo $pre_booking['cmt49'] ?>"></td>
									</tr>
									<tr>
										<td colspan=2>Did the advisor followed the car finding flow process?</td>
										<td></td>
										<td>
											<select class="form-control" name="data[advisor_follow_car_finding_process]" required>
												<option <?php echo $pre_booking['advisor_follow_car_finding_process']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option <?php echo $pre_booking['advisor_follow_car_finding_process']=='No'?"selected":""; ?> value="No">No</option>
												<option <?php echo $pre_booking['advisor_follow_car_finding_process']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=3><input type="text" class="form-control" name="data[cmt50]" value="<?php echo $pre_booking['cmt50'] ?>"></td>
									</tr>
									
									<tr style="background-color:#A9CCE3; font-weight:bold"><td>Categories</td><td colspan=2>ACTP Analysis</td><td colspan=2>Observations</td><td>Other Observation</td><td colspan=2>Suggestion if Any</td></tr>
									<tr>
										<td rowspan=4 style="background-color:#A9CCE3; font-weight:bold">ACTP Analysis</td>
										<td colspan=2>Advisor related observations / challenges noticed on call</td>
										<td colspan=2><input type="text" class="form-control" name="data[observations_challenges]" value="<?php echo $pre_booking['observations_challenges'] ?>"></td>
										<td><input type="text" class="form-control" name="data[other_observations_challenges]" value="<?php echo $pre_booking['other_observations_challenges'] ?>"></td>
										<td colspan=2><input type="text" class="form-control" name="data[suggestion_observations_challenges]" value="<?php echo $pre_booking['suggestion_observations_challenges'] ?>"></td>
									</tr>
									<tr>
										<td colspan=2>Customer related observations / challenges noticed on call</td>
										<td colspan=2><input type="text" class="form-control" name="data[customer_observations]" value="<?php echo $pre_booking['customer_observations'] ?>"></td>
										<td><input type="text" class="form-control" name="data[other_customer_observations]" value="<?php echo $pre_booking['other_customer_observations'] ?>"></td>
										<td colspan=2><input type="text" class="form-control" name="data[suggestion_customer_observations]" value="<?php echo $pre_booking['suggestion_customer_observations'] ?>"></td>
									</tr>
									<tr>
										<td colspan=2>Technical related observations / challenges noticed on call</td>
										<td colspan=2><input type="text" class="form-control" name="data[technical_observations]" value="<?php echo $pre_booking['technical_observations'] ?>"></td>
										<td><input type="text" class="form-control" name="data[other_technical_observations]" value="<?php echo $pre_booking['other_technical_observations'] ?>"></td>
										<td colspan=2><input type="text" class="form-control" name="data[suggestion_technical_observations]" value="<?php echo $pre_booking['suggestion_technical_observations'] ?>"></td>
									</tr>
									<tr>
										<td colspan=2>Process related observations / challenges noticed on call</td>
										<td colspan=2><input type="text" class="form-control" name="data[process_observations]" value="<?php echo $pre_booking['process_observations'] ?>"></td>
										<td><input type="text" class="form-control" name="data[other_process_observations]" value="<?php echo $pre_booking['other_process_observations'] ?>"></td>
										<td colspan=2><input type="text" class="form-control" name="data[suggestion_process_observations]" value="<?php echo $pre_booking['suggestion_process_observations'] ?>"></td>
									</tr>
									
									
									<tr>
										<td>Call Summary:</td>
										<td colspan=3><textarea class="form-control" id="" name="data[call_summary]"><?php echo $pre_booking['call_summary'] ?></textarea></td>
										<td>Remark:</td>
										<td colspan=3><textarea class="form-control" id="" name="data[feedback]"><?php echo $pre_booking['feedback'] ?></textarea></td>
									</tr>
									
									<tr>
										<td>Probability of Booking basis the call:</td>
										<td colspan=3><select class="form-control standard fat" id="fatal8_com" name="data[probability_of]" required>
												
												<option pre_booking_val=1 <?php echo $pre_booking['probability_of']=='High'?"selected":""; ?> value="High">High</option>
												<option pre_booking_val=1 <?php echo $pre_booking['probability_of']=='Mid'?"selected":""; ?> value="Mid">Mid</option>
												<option pre_booking_val=0 <?php echo $pre_booking['probability_of']=='Low'?"selected":""; ?> value="Low">Low</option>
												<option pre_booking_val=0 <?php echo $pre_booking['probability_of']=='Already purchased'?"selected":""; ?> value="Already purchased">Already purchased</option>
											</select></td>
										<td>Factors that could impact Booking:</td>
										<td colspan=3><select class="form-control standard" id="fatal8_com" name="data[factors_that_could]" required>
												<option pre_booking_val=1 <?php echo $pre_booking['factors_that_could']=='Advisor'?"selected":""; ?> value="Advisor">Advisor</option>
												<option pre_booking_val=1 <?php echo $pre_booking['factors_that_could']=='Customer'?"selected":""; ?> value="Customer">Customer</option>
												<option pre_booking_val=0 <?php echo $pre_booking['factors_that_could']=='Process'?"selected":""; ?> value="Process">Process</option>
												<option pre_booking_val=0 <?php echo $pre_booking['factors_that_could']=='Technology'?"selected":""; ?> value="Technology">Technology</option>
												<option pre_booking_val=0 <?php echo $pre_booking['factors_that_could']=='Process'?"selected":""; ?> value="Process">Process</option>
												<option pre_booking_val=0 <?php echo $pre_booking['factors_that_could']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
									</tr>
									<tr>
										<td>Reasons for impact on Booking (WHY 1):</td>
										<td colspan=6><textarea class="form-control" id="" name="data[reasons_for_why1]"><?php echo $pre_booking['reasons_for_why1'] ?></textarea></td>
									</tr>
									
									<tr>
										<td>Reasons for impact on Booking (WHY 2):</td>
										<td colspan=3><textarea class="form-control" id="" name="data[reasons_for_why2]"><?php echo $pre_booking['reasons_for_why2'] ?></textarea></td>
											<td>Overall feel of the call basis Sales Pitch:</td>
										<td colspan=3>
											<select class="form-control standard  fat" id="fatal8_com" name="data[overall_feel_of_the]" required>
                                           <option pre_booking_val=1 <?php echo $pre_booking['overall_feel_of_the']=='Excellent'?"selected":""; ?> value="Excellent">Excellent</option>
												<option pre_booking_val=1 <?php echo $pre_booking['overall_feel_of_the']=='Average'?"selected":""; ?> value="Average">Average</option>
												<option pre_booking_val=0 <?php echo $pre_booking['overall_feel_of_the']=='Poor'?"selected":""; ?> value="Poor">Poor</option>
												<option pre_booking_val=0 <?php echo $pre_booking['overall_feel_of_the']=='Already purchased'?"selected":""; ?> value="Already purchased">Already purchased</option>
											</select>
										</td>
									</tr>

									<?php if($pre_booking_id==0){ ?>
									<tr>
										<td colspan=2>Upload Files (wav,wmv,mp3,mp4)</td>
										<td colspan=4><input type="file" multiple class="form-control audioFile" id="attach_file" name="attach_file[]"></td>
									</tr>
									<?php }else{ ?>
									<tr>	
										<td colspan=2>Upload Files (wav,wmv,mp3,mp4)</td>
										<?php if($pre_booking['attach_file']!=''){ ?>
											<td colspan=4>
												<?php $attach_file = explode(",",$pre_booking['attach_file']);
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
										<tr><td colspan=2 style="font-size:12px; font-weight:bold">Agent Feedback Acceptance:</td><td colspan=4><?php echo $pre_booking['agnt_fd_acpt'] ?></td></tr>
										<tr><td colspan=2 style="font-size:12px; font-weight:bold">Management Review:</td><td colspan=4><?php echo $pre_booking['mgnt_rvw_note'] ?></td></tr>
										<tr><td colspan=2 style="font-size:12px; font-weight:bold">Client Review:</td><td colspan=4><?php echo $pre_booking['client_rvw_note'] ?></td></tr>
										
										<tr><td colspan=2  style="font-size:12px">Your Review</td><td colspan=4><textarea class="form-control1" style="width:100%" id="note" name="note"  ><?php echo $pre_booking['agent_rvw_note'] ?></textarea></td></tr>
									<?php } ?>
									
									
									<?php 
									if($pre_booking_id==0){
										if(is_access_qa_module()==true || is_access_qa_operations_module()==true){ ?>
											<tr><td colspan=6><button class="btn btn-success waves-effect" type="submit" id="qaformsubmit" style="width:500px">SAVE</button></td></tr>
									<?php 
										} 
									}else{ 
										if(is_access_qa_module()==true || is_access_qa_operations_module()==true){
											 if($pre_booking['agent_rvw_note']=="") { ?>
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