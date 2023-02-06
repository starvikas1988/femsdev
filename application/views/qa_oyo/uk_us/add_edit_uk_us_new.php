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
	font-size:18px;
	background-color:#85C1E9;
}
</style>

<?php if($uk_us_new_id!=0){
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
										<td colspan="6" id="theader" style="font-size:40px"><img src="<?php echo base_url(); ?>main_img/oyo.png">&nbsp &nbsp UK  US NEW</td>
										<input type="hidden" name="audit_start_time" value="<?php echo CurrMySqlDate(); ?>">
									</tr>
									<tr><td colspan=6 style="background-color:#BB9A66; font-size:14px; font-weight:bold">CALL DETAILS</td></tr>
									<?php
										if($uk_us_new_id==0){
											$auditorName = get_username();
											$auditDate = CurrDateMDY();
											$clDate_val='';
										}else{
											if($oyo_uk_us_new['entry_by']!=''){
												$auditorName = $oyo_uk_us_new['auditor_name'];
											}else{
												$auditorName = $oyo_uk_us_new['client_name'];
											}
											$auditDate = mysql2mmddyy($oyo_uk_us_new['audit_date']);
											$clDate_val=mysqlDt2mmddyy($oyo_uk_us_new['call_date']);
										}
									?>
									<tr>
										<td>Name of Auditor:</td>
										<td><input type="text" class="form-control" value="<?php echo $auditorName; ?>" disabled></td>
										<td>Date of Audit:</td>
										<td style="width:250px"><input type="text" class="form-control" value="<?php echo $auditDate; ?>" disabled></td>
										<td>Recording Date and Time:</td>
										<td><input type="text" class="form-control" id="call_date" name="call_date" value="<?php echo $clDate_val; ?>" required></td>
									</tr>
									<tr>
										<td>Agent:</td>
										<td>
											<select class="form-control" id="agent_id" name="agent_id" required>
												<option value="<?php echo $oyo_uk_us_new['agent_id'] ?>"><?php echo $oyo_uk_us_new['fname']." ".$oyo_uk_us['lname'] ?></option>
												<option value="">-Select-</option>
												<?php foreach($agentName as $row):  ?>
													<option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
												<?php endforeach; ?>
											</select>
										</td>
										<td>L1 Supervisor:</td>
										<td>
											<select class="form-control" id="tl_id" name="tl_id" readonly>
												<option value="<?php echo $oyo_uk_us_new['tl_id'] ?>"><?php echo $oyo_uk_us_new['tl_name'] ?></option>
												<option value="">--Select--</option>
												<?php foreach($tlname as $tl): ?>
													<option value="<?php echo $tl['id']; ?>"><?php echo $tl['fname']." ".$tl['lname']; ?></option>
												<?php endforeach; ?>	
											</select>
										</td>
										<td>Avaya ID:</td>
										<td><input type="text" class="form-control" id="" name="avaya_id" value="<?php echo $oyo_uk_us_new['avaya_id']; ?>" required></td>
									</tr>
									<tr>
										<td>Call Duration:</td>
										<td><input type="text" class="form-control" id="call_duration" name="call_duration" value="<?php echo $oyo_uk_us_new['call_duration']; ?>" required></td>
										<td>Phone Number:</td>
										<td><input type="text" class="form-control" id="" name="phone" onkeyup="checkDec(this);" value="<?php echo $oyo_uk_us_new['phone']; ?>" required></td>
										<td>Booking ID:</td>
										<td><input type="text" class="form-control" id="" name="booking_id" value="<?php echo $oyo_uk_us_new['booking_id']; ?>" required></td>
									</tr>
									<tr><td colspan=6 style="background-color:#BB9A66; font-size:14px; font-weight:bold">PROCESS</td></tr>
									<tr>
										<td>Geography to be audited:</td>
										<td>
											<select class="form-control" id="" name="geography_audit" required>
												<option value="">-Select-</option>
												<option <?php echo $oyo_uk_us_new['geography_audit']=='UK'?"selected":""; ?> value="UK">UK</option>
												<option <?php echo $oyo_uk_us_new['geography_audit']=='US'?"selected":""; ?> value="US">US</option>
												<option <?php echo $oyo_uk_us_new['geography_audit']=='Mexico'?"selected":""; ?> value="Mexico">Mexico</option>
											</select>
										</td>
										<td>Type of Audit:</td>
										<td>
											<select class="form-control" id="type_audit" name="type_audit" required>
												<option value="">-Select-</option>
												<option <?php echo $oyo_uk_us_new['type_audit']=='Booking'?"selected":""; ?> value="Booking">Booking</option>
												<option <?php echo $oyo_uk_us_new['type_audit']=='Non-booking'?"selected":""; ?> value="Non-booking">Non-booking</option>
												<option <?php echo $oyo_uk_us_new['type_audit']=='Cancellation'?"selected":""; ?> value="Cancellation">Cancellation</option>
												<option <?php echo $oyo_uk_us_new['type_audit']=='Prepaid'?"selected":""; ?> value="Prepaid">Prepaid</option>
												<option <?php echo $oyo_uk_us_new['type_audit']=='SOP'?"selected":""; ?> value="SOP">SOP</option>
												<option <?php echo $oyo_uk_us_new['type_audit']=='Cannabalization'?"selected":""; ?> value="Cannabalization">Cannabalization</option>
												<option <?php echo $oyo_uk_us_new['type_audit']=='Disposition'?"selected":""; ?> value="Disposition">Disposition</option>
												<option <?php echo $oyo_uk_us_new['type_audit']=='Escalation'?"selected":""; ?> value="Escalation">Escalation</option>
												<option <?php echo $oyo_uk_us_new['type_audit']=='Service'?"selected":""; ?> value="Service">Service</option>
												<option <?php echo $oyo_uk_us_new['type_audit']=='Others'?"selected":""; ?> value="Others">Others</option>
											</select>
										</td>
										<td>Cancellation Sub Type:</td>
										<td>
											<select class="form-control" id="cancel_sub_audit_type" name="cancel_sub_audit_type" required>
												<?php if($oyo_uk_us_new['type_audit']=='NA'){ ?>
													<option value="NA">NA</option>';
												<?php }else{ ?>
													<option value="<?php echo $oyo_uk_us_new['cancel_sub_audit_type'] ?>"><?php echo $oyo_uk_us_new['cancel_sub_audit_type'] ?></option>
												<?php } ?>
											</select>
										</td>
									</tr>
									<tr>
										<td>Call Type:</td>
										<td>
											<select class="form-control" id="" name="call_type" required>
												<option value="">-Select-</option>
												<option <?php echo $oyo_uk_us_new['call_type']=='Sales'?"selected":""; ?> value="Sales">Sales</option>
												<option <?php echo $oyo_uk_us_new['call_type']=='Service'?"selected":""; ?> value="Service">Service</option>
												<option <?php echo $oyo_uk_us_new['call_type']=='Technical'?"selected":""; ?> value="Technical">Technical</option>
												<option <?php echo $oyo_uk_us_new['call_type']=='Compliance'?"selected":""; ?> value="Compliance">Compliance</option>
												<option <?php echo $oyo_uk_us_new['call_type']=='Others'?"selected":""; ?> value="Others">Others</option>
											</select>
										</td>
										<td>Can be Automated:</td>
										<td>
											<select class="form-control" id="" name="can_automated" required>
												<option value="">-Select-</option>
												<option <?php echo $oyo_uk_us_new['can_automated']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option <?php echo $oyo_uk_us_new['can_automated']=='No'?"selected":""; ?> value="No">No</option>
											</select>
										</td>
										<td>Call Sub Type:</td>
										<td>
											<select class="form-control" id="" name="call_sub_type" required>
												<option value="">-Select-</option>

												<option <?php echo $oyo_uk_us_new['call_sub_type']=='Booking Created'?"selected":""; ?> value="Booking Created">Booking Created</option>

												<option <?php echo $oyo_uk_us_new['call_sub_type']=='Booking Lost - Enquiry Tariff'?"selected":""; ?> value="Booking Lost - Enquiry Tariff">Booking Lost - Enquiry Tariff</option>

												<option <?php echo $oyo_uk_us_new['call_sub_type']=='Booking Lost - Sold Out / Churned Property'?"selected":""; ?> value="Booking Lost - Sold Out / Churned Property">Booking Lost - Sold Out / Churned Property</option>

												<option <?php echo $oyo_uk_us_new['call_sub_type']=='Booking Lost - Call drop / Lifeline / Network Issue'?"selected":""; ?> value="Booking Lost - Call drop / Lifeline / Network Issue">Booking Lost - Call drop / Lifeline / Network Issue</option>

												<option <?php echo $oyo_uk_us_new['call_sub_type']=='Booking Lost - OYO Policy'?"selected":""; ?> value="Booking Lost - OYO Policy">Booking Lost - OYO Policy</option>

												<option <?php echo $oyo_uk_us_new['call_sub_type']=='Booking Lost - Price Related Issue'?"selected":""; ?> value="Booking Lost - Price Related Issue">Booking Lost - Price Related Issue</option>

												<option <?php echo $oyo_uk_us_new['call_sub_type']=='Booking Lost - Amenities'?"selected":""; ?> value="Booking Lost - Amenities">Booking Lost - Amenities</option>

												<option <?php echo $oyo_uk_us_new['call_sub_type']=='Booking Lost - Unable to connect with the PM'?"selected":""; ?> value="Booking Lost - Unable to connect with the PM">Booking Lost - Unable to connect with the PM</option>

												<option <?php echo $oyo_uk_us_new['call_sub_type']=='Booking Lost - Want to book from PM'?"selected":""; ?> value="Booking Lost - Want to book from PM">Booking Lost - Want to book from PM</option>

												<option <?php echo $oyo_uk_us_new['call_sub_type']=='Enquiry Related to Hotel / OYO Policies / Existing Booking'?"selected":""; ?> value="Enquiry Related to Hotel / OYO Policies / Existing Booking">Enquiry Related to Hotel / OYO Policies / Existing Booking</option>

												<option <?php echo $oyo_uk_us_new['call_sub_type']=='Service Call - Call drop / Lifeline / Network Issue'?"selected":""; ?> value="Service Call - Call drop / Lifeline / Network Issue">Service Call - Call drop / Lifeline / Network Issue</option>
												
												<option <?php echo $oyo_uk_us_new['call_sub_type']=='Transfer to PM'?"selected":""; ?> value="Transfer to PM">Transfer to PM</option>

												<option <?php echo $oyo_uk_us_new['call_sub_type']=='Transfer to Service Team'?"selected":""; ?> value="Transfer to Service Team">Transfer to Service Team</option>

												<option <?php echo $oyo_uk_us_new['call_sub_type']=='Answering Machine'?"selected":""; ?> value="Answering Machine">Answering Machine</option>

												<option <?php echo $oyo_uk_us_new['call_sub_type']=='Language Barrier'?"selected":""; ?> value="Language Barrier">Language Barrier</option>

												<option <?php echo $oyo_uk_us_new['call_sub_type']=='Looking For Job'?"selected":""; ?> value="Looking For Job">Looking For Job</option>

												<option <?php echo $oyo_uk_us_new['call_sub_type']=='Non OYO Call'?"selected":""; ?> value="Non OYO Call">Non OYO Call</option>

												<option <?php echo $oyo_uk_us_new['call_sub_type']=='Partnership With OYO'?"selected":""; ?> value="Partnership With OYO">Partnership With OYO</option>

												<option <?php echo $oyo_uk_us_new['call_sub_type']=='Prank Call'?"selected":""; ?> value="Prank Call">Prank Call</option>

												<option <?php echo $oyo_uk_us_new['call_sub_type']=='Test Call'?"selected":""; ?> value="Test Call">Test Call</option>

												<option <?php echo $oyo_uk_us_new['call_sub_type']=='Technical- Network Issue/Blank Call'?"selected":""; ?> value="Technical- Network Issue/Blank Call">Technical- Network Issue/Blank Call</option>

												
											</select>
										</td>
									</tr>
									<tr>
										<td>Tagging by Agent - Call Type:</td>
										<td>
											<select class="form-control" id="" name="agent_call_type" required>
												<option value="">-Select-</option>
												<option <?php echo $oyo_uk_us_new['agent_call_type']=='Sales'?"selected":""; ?> value="Sales">Sales</option>
												<option <?php echo $oyo_uk_us_new['agent_call_type']=='Service'?"selected":""; ?> value="Service">Service</option>
												<option <?php echo $oyo_uk_us_new['agent_call_type']=='Technical'?"selected":""; ?> value="Technical">Technical</option>
												<option <?php echo $oyo_uk_us_new['agent_call_type']=='Compliance'?"selected":""; ?> value="Compliance">Compliance</option>
												<option <?php echo $oyo_uk_us_new['agent_call_type']=='Others'?"selected":""; ?> value="Others">Others</option>
											</select>
										</td>
										<td>Tagging by Agent -  Call Sub Type:</td>
										<td>
											<select class="form-control" id="" name=" agent_call_sub_type" required>
												<option value="">-Select-</option>
												<option <?php echo $oyo_uk_us_new['agent_call_sub_type']=='Booking Created'?"selected":""; ?> value="Booking Created">Booking Created</option>

												<option <?php echo $oyo_uk_us_new['agent_call_sub_type']=='Booking Lost - Enquiry Tariff'?"selected":""; ?> value="Booking Lost - Enquiry Tariff">Booking Lost - Enquiry Tariff</option>

												<option <?php echo $oyo_uk_us_new['agent_call_sub_type']=='Booking Lost - Sold Out / Churned Property'?"selected":""; ?> value="Booking Lost - Sold Out / Churned Property">Booking Lost - Sold Out / Churned Property</option>

												<option <?php echo $oyo_uk_us_new['agent_call_sub_type']=='Booking Lost - Call drop / Lifeline / Network Issue'?"selected":""; ?> value="Booking Lost - Call drop / Lifeline / Network Issue">Booking Lost - Call drop / Lifeline / Network Issue</option>

												<option <?php echo $oyo_uk_us_new['agent_call_sub_type']=='Booking Lost - OYO Policy'?"selected":""; ?> value="Booking Lost - OYO Policy">Booking Lost - OYO Policy</option>

												<option <?php echo $oyo_uk_us_new['agent_call_sub_type']=='Booking Lost - Price Related Issue'?"selected":""; ?> value="Booking Lost - Price Related Issue">Booking Lost - Price Related Issue</option>

												<option <?php echo $oyo_uk_us_new['agent_call_sub_type']=='Booking Lost - Amenities'?"selected":""; ?> value="Booking Lost - Amenities">Booking Lost - Amenities</option>

												<option <?php echo $oyo_uk_us_new['agent_call_sub_type']=='Booking Lost - Unable to connect with the PM'?"selected":""; ?> value="Booking Lost - Unable to connect with the PM">Booking Lost - Unable to connect with the PM</option>

												<option <?php echo $oyo_uk_us_new['agent_call_sub_type']=='Booking Lost - Want to book from PM'?"selected":""; ?> value="Booking Lost - Want to book from PM">Booking Lost - Want to book from PM</option>

												<option <?php echo $oyo_uk_us_new['agent_call_sub_type']=='Enquiry Related to Hotel / OYO Policies / Existing Booking'?"selected":""; ?> value="Enquiry Related to Hotel / OYO Policies / Existing Booking">Enquiry Related to Hotel / OYO Policies / Existing Booking</option>

												<option <?php echo $oyo_uk_us_new['agent_call_sub_type']=='Service Call - Call drop / Lifeline / Network Issue'?"selected":""; ?> value="Service Call - Call drop / Lifeline / Network Issue">Service Call - Call drop / Lifeline / Network Issue</option>
												
												<option <?php echo $oyo_uk_us_new['agent_call_sub_type']=='Transfer to PM'?"selected":""; ?> value="Transfer to PM">Transfer to PM</option>

												<option <?php echo $oyo_uk_us_new['agent_call_sub_type']=='Transfer to Service Team'?"selected":""; ?> value="Transfer to Service Team">Transfer to Service Team</option>

												<option <?php echo $oyo_uk_us_new['agent_call_sub_type']=='Answering Machine'?"selected":""; ?> value="Answering Machine">Answering Machine</option>

												<option <?php echo $oyo_uk_us_new['agent_call_sub_type']=='Language Barrier'?"selected":""; ?> value="Language Barrier">Language Barrier</option>

												<option <?php echo $oyo_uk_us_new['agent_call_sub_type']=='Looking For Job'?"selected":""; ?> value="Looking For Job">Looking For Job</option>

												<option <?php echo $oyo_uk_us_new['agent_call_sub_type']=='Non OYO Call'?"selected":""; ?> value="Non OYO Call">Non OYO Call</option>

												<option <?php echo $oyo_uk_us_new['agent_call_sub_type']=='Partnership With OYO'?"selected":""; ?> value="Partnership With OYO">Partnership With OYO</option>

												<option <?php echo $oyo_uk_us_new['agent_call_sub_type']=='Prank Call'?"selected":""; ?> value="Prank Call">Prank Call</option>

												<option <?php echo $oyo_uk_us_new['agent_call_sub_type']=='Test Call'?"selected":""; ?> value="Test Call">Test Call</option>

												<option <?php echo $oyo_uk_us_new['agent_call_sub_type']=='Technical- Network Issue/Blank Call'?"selected":""; ?> value="Technical- Network Issue/Blank Call">Technical- Network Issue/Blank Call</option>
												
											</select>
										</td>
										<td>ACPT:</td>
										<td>
											<select class="form-control" id="" name="acpt" required>
												<option value="">-Select-</option>
												<option <?php echo $oyo_uk_us_new['acpt']=='Agent'?"selected":""; ?> value="Agent">Agent</option>
												<option <?php echo $oyo_uk_us_new['acpt']=='Customer'?"selected":""; ?> value="Customer">Customer</option>
												<option <?php echo $oyo_uk_us_new['acpt']=='Process'?"selected":""; ?> value="Process">Process</option>
												<option <?php echo $oyo_uk_us_new['acpt']=='Technical'?"selected":""; ?> value="Technical">Technical</option>
												<option <?php echo $oyo_uk_us_new['acpt']=='Others'?"selected":""; ?> value="Others">Others</option>
											</select>
										</td>
									</tr>
									<tr>
										<td>Property Code:</td>
										<td><input type="text" class="form-control" name="property_code" value="<?php echo $oyo_uk_us_new['property_code'] ?>" required></td>
										<td>Agent Disposition:</td>
										<td><input type="text" class="form-control" name="agent_disposition" value="<?php echo $oyo_uk_us_new['agent_disposition'] ?>" required></td>
										<td>QA Disposition:</td>
										<td><input type="text" class="form-control" name="qa_disposition" value="<?php echo $oyo_uk_us_new['qa_disposition'] ?>" required></td>
									</tr>
									<tr>
										<td>Audit Type:</td>
										<td>
											<select class="form-control" id="audit_type" name="audit_type" required>
												<option value="">-Select-</option>
												<option <?php echo $oyo_uk_us_new['audit_type']=='CQ Audit'?"selected":""; ?> value="CQ Audit">CQ Audit</option>
												<option <?php echo $oyo_uk_us_new['audit_type']=='BQ Audit'?"selected":""; ?> value="BQ Audit">BQ Audit</option>
												<option <?php echo $oyo_uk_us_new['audit_type']=='Calibration'?"selected":""; ?> value="Calibration">Calibration</option>
												<option <?php echo $oyo_uk_us_new['audit_type']=='Pre-Certificate Mock Call'?"selected":""; ?> value="Pre-Certificate Mock Call">Pre-Certificate Mock Call</option>
												<option <?php echo $oyo_uk_us_new['audit_type']=='Certificate Audit'?"selected":""; ?> value="Certificate Audit">Certificate Audit</option>
											</select>
										</td>
										<td class="auType">Auditor Type</td>
										<td class="auType">
											<select class="form-control" id="auditor_type" name="auditor_type">
											<option value="<?php echo $oyo_uk_us_new['auditor_type'] ?>"><?php echo $oyo_uk_us_new['auditor_type'] ?></option>
												<option value="">-Select-</option>
												<option value="Master">Master</option>
												<option value="Regular">Regular</option>
											</select>
										</td>

										<!-- <td class="auType">Auditor Type</td>
										<td class="auType">
											<select class="form-control" id="auditor_type" name="auditor_type">
											<option value="<?php echo $oyo_uk_us['auditor_type'] ?>"><?php echo $oyo_uk_us['auditor_type'] ?></option>
												<option value="">-Select-</option>
												<option value="<?php echo $oyo_uk_us['auditor_type']=='Master'?"selected":""; ?>">Master</option>
												<option value="<?php echo $oyo_uk_us['auditor_type']=='Regular'?"selected":""; ?>">Regular</option>
												
											</select>
										</td> -->
										<td>VOC:</td>
										<td>
											<select class="form-control" id="voc" name="voc" required>
												<option value="">-Select-</option>
												<option <?php echo $oyo_uk_us_new['voc']=='1'?"selected":""; ?> value="1">1</option>
												<option <?php echo $oyo_uk_us_new['voc']=='2'?"selected":""; ?> value="2">2</option>
												<option <?php echo $oyo_uk_us_new['voc']=='3'?"selected":""; ?> value="3">3</option>
												<option <?php echo $oyo_uk_us_new['voc']=='4'?"selected":""; ?> value="4">4</option>
												<option <?php echo $oyo_uk_us_new['voc']=='5'?"selected":""; ?> value="5">5</option>
											</select>
										</td>
										
									</tr>
									<tr>
										<td>Prepay Adharance:</td>
										<td>
											<select class="form-control" id="prepay_adharance" name="prepay_adharance" required>
												<option <?php echo $oyo_uk_us_new['prepay_adharance']=='NA'?"selected":""; ?> value="NA">NA</option>
												<option <?php echo $oyo_uk_us_new['prepay_adharance']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option <?php echo $oyo_uk_us_new['prepay_adharance']=='No'?"selected":""; ?> value="No">No</option>
											</select>
										</td>
										<td>Payments Status:</td>
										<td>
											<select class="form-control" id="payments_status" name="payments_status" required>
										
												<option <?php echo $oyo_uk_us_new['payments_status']=='NA'?"selected":""; ?> value="NA">NA</option>
												<option <?php echo $oyo_uk_us_new['payments_status']=='Payment Succefully Done'?"selected":""; ?> value="Payment Succefully Done">Payment Succefully Done</option>
												<option <?php echo $oyo_uk_us_new['payments_status']=='Want to pay at the hotel'?"selected":""; ?> value="Want to pay at the hotel">Want to pay at the hotel</option>
												<option <?php echo $oyo_uk_us_new['payments_status']=='Line got disconnected'?"selected":""; ?> value="Line got disconnected">Line got disconnected</option>
												<option <?php echo $oyo_uk_us_new['payments_status']=='Want to pay after the call'?"selected":""; ?> value="Want to pay after the call">Want to pay after the call</option>
												<option <?php echo $oyo_uk_us_new['payments_status']=='Payment failed'?"selected":""; ?> value="Payment failed">Payment failed</option>
												<option <?php echo $oyo_uk_us_new['payments_status']=='Payment link not received'?"selected":""; ?> value="Payment link not received">Payment link not received</option>
												<option <?php echo $oyo_uk_us_new['payments_status']=='Done have balance on card or account'?"selected":""; ?> value="Done have balance on card or account">Done have balance on card or account</option>
												<option <?php echo $oyo_uk_us_new['payments_status']=='Internet not working'?"selected":""; ?> value="Internet not working">Internet not working</option>
												<option <?php echo $oyo_uk_us_new['payments_status']=='Payment link not working'?"selected":""; ?> value="Payment link not working">Payment link not working</option>
												<option <?php echo $oyo_uk_us_new['payments_status']=='Payment OTP not received'?"selected":""; ?> value="Payment OTP not received">Payment OTP not received</option>
												<option <?php echo $oyo_uk_us_new['payments_status']=='Dont know how to do online payment'?"selected":""; ?> value="Don't know how to do online payment">Don't know how to do online payment</option>
												<option <?php echo $oyo_uk_us_new['payments_status']=='Using flip phones'?"selected":""; ?> value="Using flip phones">Using flip phones</option>
												
											</select>
										</td>
									</tr>
									<tr>
										<td colspan=5 style="font-weight:bold; font-size:18px; text-align:right">Overall Score:</td>
										<td><input type="text" readonly id="ukusScore" name="overall_score" class="form-control ukusAutofail" style="font-weight:bold"></td>
									</tr>
									<tr><td colspan=6 style="background-color:#BB9A66; font-size:14px; font-weight:bold">CALL ETHICS</td></tr>
									<tr>
										<td colspan=5>Delayed Opening >5 sec </td>
										<td>
											<select class="form-control ukus_point" id="" name="delayed_opening" required>
												<option ukus_val=3 <?php echo $oyo_uk_us_new['delayed_opening']=='No'?"selected":""; ?> value="No">No</option>
												<option ukus_val=0 <?php echo $oyo_uk_us_new['delayed_opening']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option ukus_val=3 <?php echo $oyo_uk_us_new['delayed_opening']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
									</tr>
									<tr>
										<td colspan=5>Was the opening correct? </td>
										<td >
											<select class="form-control ukus_point" id="" name="was_opening_correct" required>
												<option ukus_val=3 <?php echo $oyo_uk_us_new['was_opening_correct']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option ukus_val=0 <?php echo $oyo_uk_us_new['was_opening_correct']=='No'?"selected":""; ?> value="No">No</option>
												<option ukus_val=3 <?php echo $oyo_uk_us_new['was_opening_correct']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
									</tr>
									<tr>
										<td colspan=5>Did the agent ask for further assistance?</td>
										<td>
											<select class="form-control ukus_point" id="" name="agent_ask_further_assistance" required>
												<option ukus_val=3 <?php echo $oyo_uk_us_new['agent_ask_further_assistance']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option ukus_val=0 <?php echo $oyo_uk_us_new['agent_ask_further_assistance']=='No'?"selected":""; ?> value="No">No</option>
												<option ukus_val=3 <?php echo $oyo_uk_us_new['agent_ask_further_assistance']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
									</tr>
									<tr>
										<td colspan=5>Was the closure correct?</td>
										<td>
											<select class="form-control ukus_point" id="" name="was_closure_correct" required>
												<option ukus_val=3 <?php echo $oyo_uk_us_new['was_closure_correct']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option ukus_val=0 <?php echo $oyo_uk_us_new['was_closure_correct']=='No'?"selected":""; ?> value="No">No</option>
												<option ukus_val=3 <?php echo $oyo_uk_us_new['was_closure_correct']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
									</tr>
									<tr>
										<td colspan=5>Was there any grammatical error on the call?</td>
										<td>
											<select class="form-control ukus_point" id="" name="grammatical_error" required>
												<option ukus_val=3 <?php echo $oyo_uk_us_new['grammatical_error']=='No'?"selected":""; ?> value="No">No</option>
												<option ukus_val=0 <?php echo $oyo_uk_us_new['grammatical_error']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option ukus_val=3 <?php echo $oyo_uk_us_new['grammatical_error']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
									</tr>
									<tr>
										<td colspan=5>Was there any MTI observed on the call? </td>
										<td>
											<select class="form-control ukus_point" id="" name="MTI_observed_call" required>
												<option ukus_val=3 <?php echo $oyo_uk_us_new['MTI_observed_call']=='No'?"selected":""; ?> value="No">No</option>
												<option ukus_val=0 <?php echo $oyo_uk_us_new['MTI_observed_call']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option ukus_val=3 <?php echo $oyo_uk_us_new['MTI_observed_call']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
									</tr>
									<tr>
										<td colspan=5>Did the agent display active listening skills on the call?</td>
										<td>
											<select class="form-control ukus_point" id="" name="display_active_listening" required>
												<option ukus_val=5 <?php echo $oyo_uk_us_new['display_active_listening']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option ukus_val=0 <?php echo $oyo_uk_us_new['display_active_listening']=='No'?"selected":""; ?> value="No">No</option>
												<option ukus_val=5 <?php echo $oyo_uk_us_new['display_active_listening']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
									</tr>
									<tr><td colspan=6 style="background-color:#BB9A66; font-size:14px; font-weight:bold">SALES</td></tr>
									<tr>
										<td colspan=5>Did the agent do relevant probing?</td>
										<td>
											<select class="form-control ukus_point" id="" name="agent_relevant_probing" required>
												<option ukus_val=4 <?php echo $oyo_uk_us_new['agent_relevant_probing']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option ukus_val=0 <?php echo $oyo_uk_us_new['agent_relevant_probing']=='No'?"selected":""; ?> value="No">No</option>
												<option ukus_val=4 <?php echo $oyo_uk_us_new['agent_relevant_probing']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
									</tr>
									<tr>
										<td colspan=5>Did the agent puts sales effort?</td>
										<td>
											<select class="form-control ukus_point" id="" name="agent_provide_correct_tariff" required>
												<option ukus_val=5 <?php echo $oyo_uk_us_new['agent_provide_correct_tariff']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option ukus_val=0 <?php echo $oyo_uk_us_new['agent_provide_correct_tariff']=='No'?"selected":""; ?> value="No">No</option>
												<option ukus_val=5 <?php echo $oyo_uk_us_new['agent_provide_correct_tariff']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
									</tr>
									<tr>
										<td colspan=5>Did the agent pitch for additional nights?</td>
										<td>
											<select class="form-control ukus_point" id="" name="pitch_additional_night" required>
												<option ukus_val=4 <?php echo $oyo_uk_us_new['pitch_additional_night']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option ukus_val=0 <?php echo $oyo_uk_us_new['pitch_additional_night']=='No'?"selected":""; ?> value="No">No</option>
												<option ukus_val=4 <?php echo $oyo_uk_us_new['pitch_additional_night']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
									</tr>
									<tr>
										<td colspan=5>Did the agent pitch alternate property , if required?</td>
										<td>
											<select class="form-control ukus_point" id="" name="create_call_urgency" required>
												<option ukus_val=5 <?php echo $oyo_uk_us_new['create_call_urgency']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option ukus_val=0 <?php echo $oyo_uk_us_new['create_call_urgency']=='No'?"selected":""; ?> value="No">No</option>
												<option ukus_val=5 <?php echo $oyo_uk_us_new['create_call_urgency']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
									</tr>
									<tr>
										<td colspan=5>Did the agent give the property details with the DID information? </td>
										<td>
											<select class="form-control ukus_point" id="" name="give_property_details" required>
												<option ukus_val=2 <?php echo $oyo_uk_us_new['give_property_details']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option ukus_val=0 <?php echo $oyo_uk_us_new['give_property_details']=='No'?"selected":""; ?> value="No">No</option>
												<option ukus_val=2 <?php echo $oyo_uk_us_new['give_property_details']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
									</tr>
								
									<tr><td colspan=6 style="background-color:#BB9A66; font-size:14px; font-weight:bold">COMPLIANCE</td></tr>
									
									<tr>
										<td colspan=5>Split booking done without customer consent</td>
										<td>
											<select class="form-control ukus_point" id="" name="customer_consent" required>
												<option ukus_val=5 <?php echo $oyo_uk_us_new['customer_consent']=='No'?"selected":""; ?> value="No">No</option>
												<option ukus_val=0 <?php echo $oyo_uk_us_new['customer_consent']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option ukus_val=6 <?php echo $oyo_uk_us_new['customer_consent']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
									</tr>
									<tr>
										<td colspan=5>Did the agent check with the PM, IF REQUIRED?</td>
										<td>
											<select class="form-control ukus_point" id="" name="check_with_PM" required>
												<option ukus_val=4 <?php echo $oyo_uk_us_new['check_with_PM']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option ukus_val=0 <?php echo $oyo_uk_us_new['check_with_PM']=='No'?"selected":""; ?> value="No">No</option>
												<option ukus_val=4 <?php echo $oyo_uk_us_new['check_with_PM']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
									</tr>
									<tr>
										<td colspan=5>Did the agent summarize the call?</td>
										<td>
											<select class="form-control ukus_point" id="" name="agent_summarize_call" required>
												<option ukus_val=4 <?php echo $oyo_uk_us_new['agent_summarize_call']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option ukus_val=0 <?php echo $oyo_uk_us_new['agent_summarize_call']=='No'?"selected":""; ?> value="No">No</option>
												<option ukus_val=4 <?php echo $oyo_uk_us_new['agent_summarize_call']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
									</tr>
									<tr>
										<td colspan=5>Did the agent effectively pitch for on-call payment?</td>
										<td>
											<select class="form-control ukus_point" id="" name="pitch_for_on_call" required>
												<option ukus_val=5 <?php echo $oyo_uk_us_new['pitch_for_on_call']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option ukus_val=0 <?php echo $oyo_uk_us_new['pitch_for_on_call']=='No'?"selected":""; ?> value="No">No</option>
												<option ukus_val=5 <?php echo $oyo_uk_us_new['pitch_for_on_call']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
									</tr>
									<tr>
										<td colspan=5>Was the tagging/disposition correct?</td>
										<td>
											<select class="form-control ukus_point" id="" name="was_tagging_correct" required>
												<option ukus_val=5 <?php echo $oyo_uk_us_new['was_tagging_correct']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option ukus_val=0 <?php echo $oyo_uk_us_new['was_tagging_correct']=='No'?"selected":""; ?> value="No">No</option>
												<option ukus_val=5 <?php echo $oyo_uk_us_new['was_tagging_correct']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
									</tr>
								
								<tr>
									<td colspan=5 >Did the agent give IVR Information?</td>
										<td>
											<select class="form-control ukus_point" id="" name="ivr_information" required>
												<option ukus_val=2 <?php echo $oyo_uk_us_new['ivr_information']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option ukus_val=0 <?php echo $oyo_uk_us_new['ivr_information']=='No'?"selected":""; ?> value="No">No</option>
												<option ukus_val=2 <?php echo $oyo_uk_us_new['ivr_information']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
									</td>
								</tr>
								<tr>
									<td colspan=5 >Did the agent inform payment TAT?</td>
										<td>
											<select class="form-control ukus_point" id="" name="payment_tat" required>
												<option ukus_val=5 <?php echo $oyo_uk_us_new['payment_tat']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option ukus_val=0 <?php echo $oyo_uk_us_new['payment_tat']=='No'?"selected":""; ?> value="No">No</option>
												<option ukus_val=5 <?php echo $oyo_uk_us_new['payment_tat']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
									</td>
								</tr>
								<tr>
										<td colspan=5 style="color:red">Incorrect information given</td>
										<td>
											<select class="form-control ukus_point" id="ukusnewAutof1" name="agent_provide_incorrect_info" required>
												<option ukus_val=2 <?php echo $oyo_uk_us_new['agent_provide_incorrect_info']=='No'?"selected":""; ?> value="No">No</option>
												<option ukus_val=0 <?php echo $oyo_uk_us_new['agent_provide_incorrect_info']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option ukus_val=2 <?php echo $oyo_uk_us_new['agent_provide_incorrect_info']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
									</tr>
									<tr>
										<td colspan=5 style="color:red">Incomplete information given</td>
										<td>
											<select class="form-control ukus_point" id="ukusnewAutof2" name="agent_provide_incomplete_info" required>
												<option ukus_val=2 <?php echo $oyo_uk_us_new['agent_provide_incomplete_info']=='No'?"selected":""; ?> value="No">No</option>
												<option ukus_val=0 <?php echo $oyo_uk_us_new['agent_provide_incomplete_info']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option ukus_val=2 <?php echo $oyo_uk_us_new['agent_provide_incomplete_info']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
									</tr>
									<tr>
										<td colspan=5 style="color:red">Unethical booking done</td>
										<td>
											<select class="form-control ukus_point" id="ukusnewAutof3" name="unethical_booking" required>
												<option ukus_val=2 <?php echo $oyo_uk_us_new['unethical_booking']=='No'?"selected":""; ?> value="No">No</option>
												<option ukus_val=0 <?php echo $oyo_uk_us_new['unethical_booking']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option ukus_val=2 <?php echo $oyo_uk_us_new['unethical_booking']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
									</tr>
									<tr>
										<td colspan=5 style="color:red">Wrong booking done</td>
										<td>
											<select class="form-control ukus_point" id="ukusnewAutof4" name="wrong_booking" required>
												<option ukus_val=2 <?php echo $oyo_uk_us_new['wrong_booking']=='No'?"selected":""; ?> value="No">No</option>
												<option ukus_val=0 <?php echo $oyo_uk_us_new['wrong_booking']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option ukus_val=2 <?php echo $oyo_uk_us_new['wrong_booking']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
									</tr>
									<tr>
										<td colspan=5 style="color:red">Force booking done for additional night</td>
										<td>
											<select class="form-control ukus_point" id="ukusnewAutof5" name="force_booking" required>
												<option ukus_val=2 <?php echo $oyo_uk_us_new['force_booking']=='No'?"selected":""; ?> value="No">No</option>
												<option ukus_val=0 <?php echo $oyo_uk_us_new['force_booking']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option ukus_val=2 <?php echo $oyo_uk_us_new['force_booking']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
									</tr>
									<tr>
										<td colspan=5 style="color:red">Duplicate booking done</td>
										<td>
											<select class="form-control ukus_point" id="ukusnewAutof6" name="duplicate_booking" required>
												<option ukus_val=2 <?php echo $oyo_uk_us_new['duplicate_booking']=='No'?"selected":""; ?> value="No">No</option>
												<option ukus_val=0 <?php echo $oyo_uk_us_new['duplicate_booking']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option ukus_val=2 <?php echo $oyo_uk_us_new['duplicate_booking']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
									</tr>
									
									<tr><td colspan=6 style="background-color:#BB9A66; font-size:14px; font-weight:bold">CALL QUALITY - SOFT SKILLS</td></tr>
									<tr>
										<td colspan=5>Was the agent polite/courteous on the call?</td>
										<td>
											<select class="form-control ukus_point" id="" name="agent_polite_on_call" required>
												<option ukus_val=3 <?php echo $oyo_uk_us_new['agent_polite_on_call']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option ukus_val=0 <?php echo $oyo_uk_us_new['agent_polite_on_call']=='No'?"selected":""; ?> value="No">No</option>
												<option ukus_val=3 <?php echo $oyo_uk_us_new['agent_polite_on_call']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
									</tr>
									<tr>
										<td colspan=5>Did the agent show empathy/acknowledgement/apology when required?</td>
										<td>
											<select class="form-control ukus_point" id="" name="show_emphaty_when_required" required>
												<option ukus_val=3 <?php echo $oyo_uk_us_new['show_emphaty_when_required']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option ukus_val=0 <?php echo $oyo_uk_us_new['show_emphaty_when_required']=='No'?"selected":""; ?> value="No">No</option>
												<option ukus_val=3 <?php echo $oyo_uk_us_new['show_emphaty_when_required']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
									</tr>
									<tr>
										<td colspan=5>Did the agent take the name of the customer at least twice on the call?</td>
										<td>
											<select class="form-control ukus_point" id="" name="take_customer_name_once" required>
												<option ukus_val=3 <?php echo $oyo_uk_us_new['take_customer_name_once']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option ukus_val=0 <?php echo $oyo_uk_us_new['take_customer_name_once']=='No'?"selected":""; ?> value="No">No</option>
												<option ukus_val=3 <?php echo $oyo_uk_us_new['take_customer_name_once']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
									</tr>
									<tr>
										<td colspan=5>Was there any dead air on the call?</td>
										<td>
											<select class="form-control ukus_point" id="" name="any_dead_air_on_call" required>
												<option ukus_val=3 <?php echo $oyo_uk_us_new['any_dead_air_on_call']=='No'?"selected":""; ?> value="No">No</option>
												<option ukus_val=0 <?php echo $oyo_uk_us_new['any_dead_air_on_call']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option ukus_val=3 <?php echo $oyo_uk_us_new['any_dead_air_on_call']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
									</tr>
									<tr>
										<td colspan=5>Did the agent follow hold procedure?</td>
										<td>
											<select class="form-control ukus_point" id="" name="follow_hold_procedure" required>
												<option ukus_val=3 <?php echo $oyo_uk_us_new['follow_hold_procedure']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option ukus_val=0 <?php echo $oyo_uk_us_new['follow_hold_procedure']=='No'?"selected":""; ?> value="No">No</option>
												<option ukus_val=3 <?php echo $oyo_uk_us_new['follow_hold_procedure']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
									</tr>
																	
									<tr>
										<td>Call Summary:</td>
										<td><textarea class="form-control" id="" name="call_summary"><?php echo $oyo_uk_us_new['call_summary'] ?></textarea></td>
										<td>Feedback:</td>
										<td><textarea class="form-control" id="" name="feedback"><?php echo $oyo_uk_us_new['feedback'] ?></textarea></td>
										<td>L1:</td>
										<td>
										<select class="form-control " id="" name="level1_comment" required>
										<option value="<?php echo $oyo_uk_us_new['level1_comment'] ?>"><?php echo $oyo_uk_us_new['level1_comment'] ?></option>
											<option value="">-Select-</option>
											<option <?php echo $oyo_uk_us_new['level1_comment']=='On call payment not pitched'?"selected":""; ?>value="On call payment not pitched">On call payment not pitched</option>
											<option <?php echo $oyo_uk_us_new['level1_comment']=='Unethical booking done'?"selected":""; ?>value="Unethical booking done">Unethical booking done</option>
											<option <?php echo $oyo_uk_us_new['level1_comment']=='Incomplete information given'?"selected":""; ?>value="Incomplete information given">Incomplete information given</option>
											<option <?php echo $oyo_uk_us_new['level1_comment']=='Incorrect information given'?"selected":""; ?>value="Incorrect information given">Incorrect information given</option>
											<option <?php echo $oyo_uk_us_new['level1_comment']=='SD information not given'?"selected":""; ?>value="SD information not given">SD information not given</option>
											<option <?php echo $oyo_uk_us_new['level1_comment']=='Split booking done'?"selected":""; ?>value="Split booking done">Split booking done</option>
											<option <?php echo $oyo_uk_us_new['level1_comment']=='IVR information not given'?"selected":""; ?>value="IVR information not given">IVR information not given</option>
											<option <?php echo $oyo_uk_us_new['level1_comment']=='Force booking done for additional night'?"selected":""; ?>value="Force booking done for additional night">Force booking done for additional night</option>
											<option <?php echo $oyo_uk_us_new['level1_comment']=='Did not raise a request for Void'?"selected":""; ?>value="Did not raise a request for Void">Did not raise a request for Void</option>
											<option <?php echo $oyo_uk_us_new['level1_comment']=='Not attentive on call'?"selected":""; ?>value="Not attentive on call">Not attentive on call</option>
											<option <?php echo $oyo_uk_us_new['level1_comment']=='Duplicate booking done'?"selected":""; ?>value="Duplicate booking done">Duplicate booking done</option>
											<option <?php echo $oyo_uk_us_new['level1_comment']=='Alternate property not pitched'?"selected":""; ?>value="Alternate property not pitched">Alternate property not pitched</option>
											<option <?php echo $oyo_uk_us_new['level1_comment']=='Lack of sales effort'?"selected":""; ?>value="Lack of sales effort">Lack of sales effort</option>
											<option <?php echo $oyo_uk_us_new['level1_comment']=='Customer never visit the hotel'?"selected":""; ?>value="Customer never visit the hotel">Customer never visit the hotel</option>
											<option <?php echo $oyo_uk_us_new['level1_comment']=='Never answer the IVR call'?"selected":""; ?>value="Never answer the IVR call">Never answer the IVR call</option>
											<option <?php echo $oyo_uk_us_new['level1_comment']=='Change in plan'?"selected":""; ?>value="Change in plan">Change in plan</option>
											<option <?php echo $oyo_uk_us_new['level1_comment']=='Payment not done within the TAT'?"selected":""; ?>value="Payment not done within the TAT">Payment not done within the TAT</option>
											<option <?php echo $oyo_uk_us_new['level1_comment']=='Not happy with the tariff'?"selected":""; ?>value="Not happy with the tariff">Not happy with the tariff</option>
											<option <?php echo $oyo_uk_us_new['level1_comment']=='Just want to know the tariff'?"selected":""; ?>value="Just want to know the tariff">Just want to know the tariff</option>
											<option <?php echo $oyo_uk_us_new['level1_comment']=='Customer disconnected the line'?"selected":""; ?>value="Customer disconnected the line">Customer disconnected the line</option>
											<option <?php echo $oyo_uk_us_new['level1_comment']=='Not happy with SD'?"selected":""; ?>value="Not happy with SD">Not happy with SD</option>
											<option <?php echo $oyo_uk_us_new['level1_comment']=='Looking for low tariff'?"selected":""; ?>value="Looking for low tariff">Looking for low tariff</option>
											<option <?php echo $oyo_uk_us_new['level1_comment']=='Customer do not have his original valid ID proof'?"selected":""; ?>value="Customer do not have his original valid ID proof">Customer do not have his original valid ID proof</option>
											<option <?php echo $oyo_uk_us_new['level1_comment']=='Property sold out'?"selected":""; ?>value="Property sold out">Property sold out</option>
											<option <?php echo $oyo_uk_us_new['level1_comment']=='Amenities not available'?"selected":""; ?>value="Amenities not available">Amenities not available</option><option <?php echo $oyo_uk_us_new['level1_comment']=='Churned Property'?"selected":""; ?>value="Churned Property">Churned Property</option>
											<option <?php echo $oyo_uk_us_new['level1_comment']=='High Tariff'?"selected":""; ?>value="High Tariff">High Tariff</option>
											<option <?php echo $oyo_uk_us_new['level1_comment']=='Required room not available'?"selected":""; ?>value="Required room not available">Required room not available</option>
											<option <?php echo $oyo_uk_us_new['level1_comment']=='Early Check-in restriction'?"selected":""; ?>value="Early Check-in restriction">Early Check-in restriction</option>
											<option <?php echo $oyo_uk_us_new['level1_comment']=='Payment link not received'?"selected":""; ?>value="Payment link not received">Payment link not received</option>
											<option <?php echo $oyo_uk_us_new['level1_comment']=='PM not contactable'?"selected":""; ?>value="PM not contactable">PM not contactable</option>
											<option <?php echo $oyo_uk_us_new['level1_comment']=='Wrong reason update'?"selected":""; ?>value="Wrong reason update">Wrong reason update</option>
											<option <?php echo $oyo_uk_us_new['level1_comment']=='Line got disconnected'?"selected":""; ?>value="Line got disconnected">Line got disconnected</option>
											<option <?php echo $oyo_uk_us_new['level1_comment']=='Voice issue'?"selected":""; ?>value="Voice issue">Voice issue</option>
											<option <?php echo $oyo_uk_us_new['level1_comment']=='System was down'?"selected":""; ?>value="System was down">System was down</option>
											<option <?php echo $oyo_uk_us_new['level1_comment']=='N/A'?"selected":""; ?>value="N/A">N/A</option>
											

											</select>
										</td>
									</tr>
									<tr>
									<td>L2:</td>
										<td><textarea class="form-control" id="" name="level2"><?php echo $oyo_uk_us_new['level2'] ?></textarea></td>
									</tr>
									<tr>
										<td colspan="2">Upload Files</td>
										<?php if($uk_us_new_id==0){ ?>
											<td colspan=4><input type="file" multiple class="form-control" id="attach_file" name="attach_file[]"></td>
										<?php }else{ 
											if($oyo_uk_us_new['attach_file']!=''){ ?>
											<td colspan="4">
												<?php $attach_file = explode(",",$oyo_uk_us_new['attach_file']);
												 foreach($attach_file as $mp){ ?>
													<audio controls='' style="background-color:#607F93"> 
													  <source src="<?php echo base_url(); ?>qa_files/qa_oyo_inter/oyo_uk_us/<?php echo $mp; ?>" type="audio/ogg">
													  <source src="<?php echo base_url(); ?>qa_files/qa_oyo_inter/oyo_uk_us/<?php echo $mp; ?>" type="audio/mpeg">
													</audio> </br>
												 <?php } ?>
											</td>
										<?php }else{
												echo '<td><b>No Files</b></td>';
											  }
										} ?>
									</tr>
									
									<?php if($uk_us_new_id!=0){ ?>
										<tr><td colspan=2 style="font-size:16px; font-weight:bold">Agent Review:</td><td colspan=4><?php echo $oyo_uk_us_new['agent_rvw_note'] ?></td></tr>
										<tr><td colspan=2 style="font-size:16px; font-weight:bold">Management Review:</td><td colspan=4><?php echo $oyo_uk_us_new['mgnt_rvw_note'] ?></td></tr>
										<tr><td colspan=2 style="font-size:16px; font-weight:bold">Client Review:</td><td colspan=4><?php echo $oyo_uk_us_new['client_rvw_note'] ?></td></tr>
										
										<tr><td colspan=2  style="font-size:16px">Your Review</td><td colspan=4><textarea class="form-control1" style="width:100%" id="note" name="note" required></textarea></td></tr>
									<?php } ?>
									
									<?php 
									if($uk_us_new_id==0){
										if(is_access_qa_module()==true || is_access_qa_operations_module()==true || is_quality_access_trainer()==true){ ?>
											<tr><td colspan=6><button class="btn btn-success waves-effect" type="submit" id="qaformsubmit" style="width:500px">SAVE</button></td></tr>
									<?php 
										} 
									}else{ 
										if(is_access_qa_module()==true || is_access_qa_operations_module()==true || is_quality_access_trainer()==true){
											if(is_available_qa_feedback($oyo_uk_us_new['entry_date'],72) == true){ ?>
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
