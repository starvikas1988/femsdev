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
										<td colspan="12" id="theader" style="font-size:30px">Pre Booking New</td>
										<?php
										if($pre_booking_id==0){
											$auditorName = get_username();
											$auditDate = CurrDateMDY();
											$clDate_val='';
											$month=date("F");
											$week="Week ".$controller->weekOfMonth(date("Y-m-d"));
										}else{
											if($pre_booking['entry_by']!=''){
												$auditorName = $pre_booking['auditor_name'];
											}else{
												$auditorName = $pre_booking['client_name'];
											}
											//p$auditDate = mysql2mmddyy($pre_booking['audit_date']);
											$auditDate = ConvServerToLocal($pre_booking['audit_date']);
											// $clDate_val = mysql2mmddyy($pre_booking['call_date']);
											$clDate_val = mysqlDt2mmddyy($pre_booking['call_date']);
											$month= $pre_booking['Month'];
											$week= $pre_booking['Week'];
										}
									?>
										<input type="hidden" name="audit_start_time" value="<?php echo CurrMySqlDate(); ?>">
									</tr>
									<tr>
										<td colspan="2">QA Name:</td>
										<td><input type="text" class="form-control" value="<?php echo get_username(); ?>" disabled></td>
										<td colspan="2">Audit Date:</td>
										<td><input type="text" class="form-control" value="<?php echo CurrDateMDY(); ?>" disabled></td>
										<td>Call Date:</td>
										<td colspan="4"><input type="text" class="form-control" id="call_date" name="call_date" value="<?php echo $clDate_val; ?>" required></td>
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
										<td colspan="2">Campaign:</td>
										<td><input type="text" readonly class="form-control" id="campaign" name="" value="<?php echo $pre_booking['process_name'] ?>"></td>
										<td>L1 Supervisor:</td>
										<td colspan="4">
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
										<td colspan="2">Auditor Role:</td>
										<td>
											<select class="form-control" id="Auditor_Role" name="data[Auditor_Role]" required>
												<option value="<?php echo $pre_booking['Auditor_Role'] ?>"><?php echo $pre_booking['Auditor_Role'] ?></option>
												<option value="">-Select-</option>
												<option value="QA">QA</option>
												<option value="TL">TL</option>
												<option value="Trainer">Trainer</option>
												<option value="AM">AM</option>
												
											</select>
										</td>
										<!-- <td colspan="2">Call Audit Type:</td>
										<td>
											<select class="form-control" id="call_audit_type" name="data[call_audit_type]" required>
												<option value="<?php echo $pre_booking['call_audit_type'] ?>"><?php echo $pre_booking['call_audit_type'] ?></option>
												<option value="">-Select-</option>
												<option value="ATA Audit">ATA Audit</option>
												<option value="Normal Audit">Normal Audit</option>
												<option value="Special Audit">Special Audit</option>
												<option value="CSAT Audit">CSAT Audit</option>
												<option value="Calibration Audit">Calibration Audit</option>
												<option value="DSAT Audit">DSAT Audit</option>
												
											</select>
										</td> -->
										<td colspan="2">Call Duration:</td>
										<td><input type="text" class="form-control" id="call_duration" name="data[call_duration]" value="<?php echo $pre_booking['call_duration'] ?>" required></td>
										<td>Operator Go Live Date:</td>
										<td colspan="4"><input  readonly  class="form-control " id="live_date" name="live_date" value="<?php echo $pre_booking['live_date'] ?>"></td>
									</tr>


									<tr>
										<!-- <td colspan="2">Auditor Name:</td>
										<td>
											<select class="form-control" id="Auditor_Name1" name="data[Auditor_Name1]" required>
												<option value="<?php echo $pre_booking['Auditor_Name1'] ?>"><?php echo $pre_booking['Auditor_Name1'] ?></option>
												<option value="">-Select-</option>
												<option value="Yashika">Yashika</option>
												<option value="Niharika">Niharika</option>
												<option value="Nawaz">Nawaz</option>
												<option value="Amandeep Kaur">Amandeep Kaur</option>
												<option value="Ruchika Chauhan ">Ruchika Chauhan </option>
												<option value="Narinder Singh">Narinder Singh</option>
												<option value="Gurwinder Kaur">Gurwinder Kaur</option>
												<option value="Vaishali">Vaishali</option>
												<option value="Prabhat Kumar">Prabhat Kumar</option>
												<option value="Sourav Dhiman">Sourav Dhiman</option>
												<option value="Rahul Malhotra">Rahul Malhotra</option>
												<option value="Shalini Thakur">Shalini Thakur</option>
												<option value="Sudhanshu Praharaj">Sudhanshu Praharaj</option>
												<option value="Shivani Bhardwaj">Shivani Bhardwaj</option>
												<option value="Manish Kumar">Manish Kumar</option>
												<option value="Ruma">Ruma</option>
											</select>
										</td> -->
										<td colspan="2">Customer Contact Number:</td>
										<td colspan=""><input type="text" class="form-control" name="data[customer_contact_number]" value="<?php echo $pre_booking['customer_contact_number'] ?>" required></td>
										<td colspan="2">AON:</td>
										<td><input type="text" readonly class="form-control tenure" id="tenure" name="data[AON]" value="<?php echo $pre_booking['AON'] ?>"></td>

										<td>Disposition:</td>
										<td colspan="4">
										<select class="form-control" id="disposition" name="data[Disposition1]" required>
												<option value="<?php echo $pre_booking['Disposition1'] ?>"><?php echo $pre_booking['Disposition1'] ?></option>
												<option value="">-Select-</option>
												<option value="Open">Open</option>
												<option value="Dead Lead">Dead Lead</option>
												<option value="Dropped">Dropped</option>
												<option value="Interested In Booking">Interested In Booking</option>
												<option value="Not Interested in Booking">Not Interested in Booking</option>
												<option value="Open">Open</option>
												<option value="Pre-Booking Query">Pre-Booking Query</option>
												<option value="Interested_others">Interested _others</option>
											</select>
										</td>
									</tr>


									<tr>
										<td colspan="2">Month:</td>
										<td>
											<input type="text" name="data[Month]" readonly class="form-control" value="<?php echo $month ?>" />
											<!-- <select class="form-control" id="Month" name="data[Month]" required>
												<option value="<?php echo $pre_booking['Month'] ?>"><?php echo $pre_booking['Month'] ?></option>
												<option value="">-Select-</option>
												<option value="January">January</option>
												<option value="February">February</option>
												<option value="March">March</option>
												<option value="April">April</option>
												<option value="May">May</option>
												<option value="June">June</option>
												<option value="July">July</option>
												<option value="August">August</option>
												<option value="September">September</option>
												<option value="October">October</option>
												<option value="November">November</option>
												<option value="December">December</option>
												
											</select> -->
										</td>
										<td colspan="2">Week:</td>
										<td>
											<input type="text" name="" readonly class="form-control" value="<?php echo $week?>" />
											<!-- <select class="form-control" name="data[Week]" required>
												<option value="<?php echo $pre_booking['Week'] ?>"><?php echo $pre_booking['Week'] ?></option>
												<option value="">-Select-</option>
												<option value="Week1">Week1</option>
												<option value="Week2">Week2</option>
												<option value="Week3">Week3</option>
												<option value="Week4">Week4</option>
												<option value="Week5">Week5</option>	
											</select> -->
										</td>

										<td>Sub Disposition:</td>
										<td colspan="4">
										<select class="form-control" id="sub_dispo" name="data[Sub_Disposition]" required>
												<option value="<?php echo $pre_booking['Sub_Disposition'] ?>"><?php echo $pre_booking['Sub_Disposition'] ?></option>
												<option value="">-Select-</option>
												<option value="7 Day Return/ Money Back Related Query">7 Day Return/ Money Back Related Query</option>
												<option value="Already booked/bought from CARS24">Already booked/bought from CARS24</option>
												<option value="Already booked/bought from outside - New Car">Already booked/bought from outside - New Car</option>
												<option value="Already booked/bought from outside - Used Car">Already booked/bought from outside - Used Car</option>
												<option value="Already bought a new car">Already bought a new car</option>
												<option value="Already bought a used car">Already bought a used car</option>
												<option value="Already Visited">Already Visited</option>
												<option value="Awaiting refund from previous booking">Awaiting refund from previous booking</option>
												<option value="Bank Statement & Order Link Shared">Bank Statement & Order Link Shared</option>
												<option value="Booking amount relate issue">Booking amount relate issue</option>
												<option value="Booking Cancel">Booking Cancel</option>
												<option value="Booking completed on call">Booking completed on call</option>
												<option value="Call back">Call back</option>
												<option value="Car link shared">Car link shared</option>
												<option value="Car Specific Query">Car Specific Query</option>
												<option value="Consumer Financing Related Query">Consumer Financing Related Query</option>
												<option value="Could not find preferred make/ model">Could not find preferred make/ model</option>
												<option value="Created New HD booking">Created New HD booking</option>
												<option value="Customer Disconnected Call">Customer Disconnected Call</option>
												<option value="Customer need CA help but CA number not available">Customer need CA help but CA number not available</option>
												<option value="Delayed Plan to Visit">Delayed Plan to Visit</option>
												<option value="Do not call">Do not call</option>
												<option value="Do Not Call / DND">Do Not Call / DND</option>
												<option value="Do not want to pay for test drive">Do not want to pay for test drive</option>
												<option value="Documents Related Query">Documents Related Query</option>
												<option value="Existing Booking got auto cancelled - preferred car not available">Existing Booking got auto cancelled - preferred car not available</option>
												<option value="Expected Negotiation on listed price">Expected Negotiation on listed price</option>
												<option value="Hub too far (Does not want HD)">Hub too far (Does not want HD)</option>
												<option value="Insurance/ Warranty Related Query">Insurance/ Warranty Related Query</option>
												<option value="Language Barrier">Language Barrier</option>
												<option value="Loan Offer and Banking Links shared">Loan Offer and Banking Links shared</option>
												<option value="Loan rejected by Cars24">Loan rejected by Cars24</option>
												<option value="Need loan confirm before visit">Need loan confirm before visit</option>
												<option value="Negotiate/loan before visit">Negotiate/loan before visit</option>
												<option value="Non operational city">Non operational city</option>
												<option value="Non-Buyer query">Non-Buyer query</option>
												<option value="Not clear on Hub directions">Not clear on Hub directions</option>
												<option value="Bank Statement & Order Link Shared">Bank Statement & Order Link Shared</option>
												<option value="Payment/Charges/ Refund related Query">Payment/Charges/ Refund related Query</option>
												<option value="Postponed plan to purchase the car">Postponed plan to purchase the car</option>
												<option value="Postponed plan to purchase the car < 1 month">Postponed plan to purchase the car < 1 month</option>
												<option value="Postponed plan to purchase the car > 1 month">Postponed plan to purchase the car > 1 month</option>
												<option value="Price Related Query">Price Related Query</option>
												<option value="RC Transfer Process Related Query">RC Transfer Process Related Query</option>
												<option value="Reason not Specified/General Query">Reason not Specified/General Query</option>
												<option value="Ringing Call Not Picked">Ringing Call Not Picked</option>
												<option value="Selected car not available">Selected car not available</option>
												<option value="Short hung up">Short hung up</option>
												<option value="Switched Off">Switched Off</option>
												<option value="System Error">System Error</option>
												<option value="Test Lead">Test Lead</option>
												<option value="Token Done">Token Done</option>
												<option value="Visit slot rescheduled ">Visit slot rescheduled </option>
												<option value="Visit/Delivery Process Related Query">Visit/Delivery Process Related Query</option>
												<option value="Voice Issue">Voice Issue</option>
												<option value="Want Loan- from CARS24 but not available">Want Loan- from CARS24 but not available</option>
												<option value="Want Loan- Offer Terms Not Acceptable">Want Loan- Offer Terms Not Acceptable</option>
												<option value="Want to buy new car">Want to buy new car</option>
												<option value="Wants to buy a new car only">Wants to buy a new car only</option>
												<option value="Wants to reserve the car">Wants to reserve the car</option>
												<option value="Will browse and book later">Will browse and book later</option>
												<option value="Will explore more cars - visit">Will explore more cars - visit</option>
												<option value="Will visit new booking -by self">Will visit new booking -by self</option>
												<option value="Will visit on new booking - Free">Will visit on new booking - Free</option>
												<option value="Will visit on same/existing visit">Will visit on same/existing visit</option>
												<option value="Order link shared">Order link shared</option>
												
												
											</select>
											</td>
									</tr>


									
									
									<tr>
										<!-- <td colspan="2">Actual Tagging:</td>
										<td colspan="2"><input type="text" class="form-control" id="actual_tagging" name="data[actual_tagging]" value="<?php echo $pre_booking['actual_tagging'] ?>" required></td> -->
										<!-- <td colspan="2">Agent Tagging:</td>
										<td><input type="text" class="form-control" id="agent_tagging" name="data[agent_tagging]" value="<?php echo $pre_booking['agent_tagging'] ?>"  required></td> -->

										<td>Agent Tenure:</td>
										<td colspan="6"><input type="text" readonly class="form-control tenure_bucket" id="tenure_bucket" name="data[agen_tenure]" value="<?php echo $pre_booking['agen_tenure'] ?>" required></td>

											<td>Parameter Weighted Accuracy:</td>
										<td colspan="4"><input type="text" class="form-control" id="cars_overallScore" name="data[Parameter_Weighted]" value="<?php echo $pre_booking['Parameter_Weighted'] ?>%" readonly></td>
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
										<td colspan="2">VOC:</td>
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

										<td colspan="">Language:</td>
										<td colspan="4">
											<select class="form-control" id="voc" name="data[Language]" required>
												<option value="<?php echo $pre_booking['Language'] ?>"><?php echo $pre_booking['Language'] ?></option>
												<option value="">-Select-</option>
												<option value="English">English</option>
												<option value="Gujrati">Gujrati</option>
												<option value="Hindi">Hindi</option>
												<option value="Kannad">Kannad</option>
												<option value="Malyalam">Malyalam</option>
												<option value="Marathi">Marathi</option>
												<option value="Punjabi">Punjabi</option>
												<option value="Tamil">Tamil</option>
												<option value="Telugu">Telugu</option>
											</select>
										</td>
										
									</tr>
									<tr>
										<td style="font-weight:bold; font-size:15px; text-align:right">Overall Score:</td>
										<td colspan="4"><input type="text" readonly id="pre_overallScore" name="data[overall_score]" class="form-control" style="font-weight:bold" value="<?php if($pre_booking['overall_score']){ echo $pre_booking['overall_score']; } else { echo '0.00'.'%'; } ?>"></td>


										<td>Critical Transaction Flag:</td>
										<td><input type="text" class="form-control" id="crucial_score" name="data[Critical_Transaction]" value="<?php echo $pre_booking['Critical_Transaction'] ?>" readonly></td>


										<td>Overall Defects:</td>
										<td colspan="4"><input type="text" class="form-control" id="defects_score" name="data[Overall_Defects]" value="<?php echo $pre_booking['Overall_Defects'] ?>" readonly></td>

									</tr>
									<tr>
									

										<td colspan="">Parameter Overall Result:</td>
										<td><input type="text" class="form-control" id="overall_result1" name="data[parameter_overall_result]" value="<?php echo $pre_booking['parameter_overall_result'] ?>" readonly></td>

										


										<td>Sub Parameter Overall Result:</td>
										<td><input type="text" class="form-control" id="overall_result" name="data[Overall_Result]" value="<?php echo $pre_booking['Overall_Result'] ?>" readonly></td>


										<td>Critical Errors:</td>
										<td colspan="4"><input type="text" class="form-control" id="cru_score" name="data[Sub_Parameter_Opportunities_Process]" value="<?php echo $pre_booking['Sub_Parameter_Opportunities_Process'] ?>" readonly></td>
									</tr>





									<!-- <tr>
		                              	<td style="font-weight:bold; font-size:16px">Process Score</td>
		                                 <td colspan="2"><input type="text" readonly id="processJiCisEarned" name="data[possible_score]" class="form-control" value="<?= $pre_booking['possible_score']?>" style="font-weight:bold"></td>

		                                 <td style="font-weight:bold; font-size:16px">Customer Score</td>
		                                 <td colspan="2"><input type="text" readonly id="custJiCisEarned" name="data[earned_score]" class="form-control" value="<?= $pre_booking['earned_score']?>" style="font-weight:bold"></td>                               
		 	                           
                              		</tr> -->
			
									
									<tr style="background-color:#A9CCE3; font-weight:bold"><td>Parameter</td><td>Rating</td><td colspan=2>Sub-Parameter</td><td>Ratings</td><td>Status</td><td>Reason</td><td colspan=2>Remark</td><td>Weightage</td><td>Parameter</td></tr>
									<tr>
										<td rowspan=2 style="background-color:#A9CCE3; font-weight:bold">1. Opening & Identification</td>
										<td rowspan=2 colspan="1">
											<select class="form-control pre_booking_point1" style="width: 100px;" id="standardization1" name="data[Rating1]" required>
												<option selected value=''>Select</option>
												<option pre_booking_val=5 pre_booking_max_val=5 <?php echo $pre_booking['Rating1']=='Good'?"selected":""; ?> value="Good">Good</option>
												<option pre_booking_val=1.5 pre_booking_max_val=5 <?php echo $pre_booking['Rating1']=='Bad'?"selected":""; ?> value="Bad">Bad</option>
												<option pre_booking_val=3 pre_booking_max_val=5 <?php echo $pre_booking['Rating1']=='Average'?"selected":""; ?> value="Average">Average</option>
												<option pre_booking_val=0 pre_booking_max_val=0 <?php echo $pre_booking['Rating1']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
										<td colspan=2>1.1 Opening guideline was followed correctly (Opening in 3 seconds, self and company introduction- cars24.com)</td>
										<td>
											<select class="form-control pre_booking_point process" id="standardization1" name="data[Ratings1]" identifier2="defects" identifier="process" identifier_pro="pro_count" style="width: 100px;" required>
												<option selected  value=''>Select</option>
												<option pre_booking_val=2 <?php echo $pre_booking['Ratings1']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option pre_booking_val=2 <?php echo $pre_booking['Ratings1']=='No'?"selected":""; ?> value="No">No</option>
												<option pre_booking_val=0 <?php echo $pre_booking['Ratings1']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
										<td colspan="1">Non Crucial</td>
										<td>
											<select class="form-control standard aoi" id="mySelect" name="data[Reason1]" required>
												<option selected value=''>Select</option>
												<option <?php echo $pre_booking['Reason1']=='Opening of the call was not in proper language'?"selected":""; ?> value="Opening of the call was not in proper language">Opening of the call was not in proper language</option>
												<option <?php echo $pre_booking['Reason1']=='Opening not done in 3 seconds'?"selected":""; ?> value="Opening not done in 3 seconds">Opening not done in 3 seconds</option>
												<option <?php echo $pre_booking['Reason1']=='Opening Missing'?"selected":""; ?> value="Opening Missing">Opening Missing</option>
												<option <?php echo $pre_booking['Reason1']=='Did not address customer with available name'?"selected":""; ?> value="Did not address customer with available name">Did not address customer with available name</option>
												<option <?php echo $pre_booking['Reason1']=='Self-introduction missing'?"selected":""; ?> value="Self-introduction missing">Self-introduction missing</option>
												<option <?php echo $pre_booking['Reason1']=='Brand  missing/Incorrect Branding'?"selected":""; ?> value="Brand  missing/Incorrect Branding">Brand  missing/Incorrect Branding</option>
											</select>
										</td>
										<td><input type="text" class="form-control remarks" name="data[cmt1]" value="<?php echo $pre_booking['cmt1'] ?>"></td>
										<td  colspan="2">2</td>
										<td colspan="1">Process</td>
										
									</tr>
									<tr>
										<td colspan=2>1.2 Purpose of the call was shared as per lead type (Callback/ Dropped/Manual booking)</td>
																			<td>
											<select class="form-control pre_booking_point process" id="standardization1" name="data[Ratings2]" identifier2="defects" identifier="process" identifier_pro="pro_count" required>
												<option selected value=''>Select</option>
												<option pre_booking_val=3 <?php echo $pre_booking['Ratings2']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option pre_booking_val=3 <?php echo $pre_booking['Ratings2']=='No'?"selected":""; ?> value="No">No</option>
												<option pre_booking_val=0 <?php echo $pre_booking['Ratings2']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
										<td colspan="1">Non Crucial</td>
										<td>
											<select class="form-control standard aoi" id="standardization1" name="data[Reason2]" required>
												<option selected value=''>Select</option>
												<option <?php echo $pre_booking['Reason2']=='Purpose of the call not shared appropriately'?"selected":""; ?> value="Purpose of the call not shared appropriately">Purpose of the call not shared appropriately</option>

												<option <?php echo $pre_booking['Reason2']=='History not referred on the call.'?"selected":""; ?> value="History not referred on the call.">History not referred on the call.</option>
												
											</select>
										</td>
										<td><input type="text" class="form-control remarks" name="data[cmt2]" value="<?php echo $pre_booking['cmt2'] ?>"></td>
										<td  colspan="2">3</td>
										<td colspan="1">Process</td>
									</tr>
									

									<tr>
										<td rowspan=2 style="background-color:#A9CCE3; font-weight:bold">2. Customer assessment (Understanding customer needs)</td>
										<td rowspan=2>
											<select class="form-control pre_booking_point1" id="standardization1" name="data[Rating2]" required>
												<option selected value=''>Select</option>
												<option pre_booking_val=22 pre_booking_max_val=22 <?php echo $pre_booking['Rating2']=='Good'?"selected":""; ?> value="Good">Good</option>
												<option pre_booking_val=6.6 pre_booking_max_val=22 <?php echo $pre_booking['Rating2']=='Bad'?"selected":""; ?> value="Bad">Bad</option>
												<option pre_booking_val=13.2 pre_booking_max_val=22 <?php echo $pre_booking['Rating2']=='Average'?"selected":""; ?> value="Average">Average</option>
												<option pre_booking_val=0 pre_booking_max_val=0 <?php echo $pre_booking['Rating2']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
										<td colspan=2>2.1 Context was set before asking for any information from the customer</td>
										<td>
											<select class="form-control pre_booking_point process" id="standardization1" name="data[Ratings3]" identifier2="defects" identifier="process" identifier_pro="pro_count" required>
												<option selected value=''>Select</option>
												<option pre_booking_val=8 <?php echo $pre_booking['Ratings3']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option pre_booking_val=8 <?php echo $pre_booking['Ratings3']=='No'?"selected":""; ?> value="No">No</option>
												<option pre_booking_val=0 <?php echo $pre_booking['Ratings3']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
										<td colspan="1">Non Crucial</td>
										<td>
											<select class="form-control standard aoi" id="standardization1" name="data[Reason3]" required>
												<option selected value=''>Select</option>
												<option <?php echo $pre_booking['Reason3']=='Asked for area pincode without informing the purpose'?"selected":""; ?> value="Asked for area pincode without informing the purpose">Asked for area pincode without informing the purpose</option>
												<option <?php echo $pre_booking['Reason3']=='Asked for the customers name without acknowledging customers concern/purpose'?"selected":""; ?> value="Asked for the customers name without acknowledging customers concern/purpose">Asked for the customer's name without acknowledging customer's concern/purpose</option>
												<option <?php echo $pre_booking['Reason3']=='Asked for information not required at that stage'?"selected":""; ?> value="Asked for information not required at that stage">Asked for information not required at that stage</option>
												
											</select>
										</td>
										<td><input type="text" class="form-control remarks" name="data[cmt3]" value="<?php echo $pre_booking['cmt3'] ?>"></td>
										<td  colspan="2">8</td>
										<td colspan="1">Process</td>
										
									</tr>
									<tr>
										<td colspan=2>2.2 Customer's requirement was correctly understood, relevant probing was done</td>
																			<td>
											<select class="form-control pre_booking_point process" id="standardization1" name="data[Ratings4]" identifier2="defects" identifier="process" identifier_pro="pro_count" identifier1="Crucial" required>
												<option selected value=''>Select</option>
												<option pre_booking_val=14 <?php echo $pre_booking['Ratings4']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option pre_booking_val=14 <?php echo $pre_booking['Ratings4']=='No'?"selected":""; ?> value="No">No</option>
												<option pre_booking_val=0 <?php echo $pre_booking['Ratings4']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
										<td colspan="1">Crucial</td>
										<td>
											<select class="form-control standard aoi" id="standardization1" name="data[Reason4]" required>
												<option selected value=''>Select</option>
												<option <?php echo $pre_booking['Reason4']=='Appropriate probing not done'?"selected":""; ?> value="Appropriate probing not done">Appropriate probing not done</option>
												<option <?php echo $pre_booking['Reason4']=='Car finding flow not adherered to'?"selected":""; ?> value="Car finding flow not adherered to">Car finding flow not adherered to</option>
												<option <?php echo $pre_booking['Reason4']=='Similar car not pitched on the call.'?"selected":""; ?> value="Similar car not pitched on the call.">Similar car not pitched on the call.</option>
												
											</select>
										</td>
										<td><input type="text" class="form-control remarks" name="data[cmt4]" value="<?php echo $pre_booking['cmt4'] ?>"></td>
										<td  colspan="2">14</td>
										<td colspan="1">Process</td>
									</tr>

									<tr>
										<td rowspan=2 style="background-color:#A9CCE3; font-weight:bold">3. Solution & Objection handling</td>
										<td rowspan=2>
											<select class="form-control pre_booking_point1" id="standardization1" name="data[Rating3]" required>
												<option selected value=''>Select</option>
												<option pre_booking_val=22 pre_booking_max_val=22 <?php echo $pre_booking['Rating3']=='Good'?"selected":""; ?> value="Good">Good</option>
												<option pre_booking_val=6.6 pre_booking_max_val=22 <?php echo $pre_booking['Rating3']=='Bad'?"selected":""; ?> value="Bad">Bad</option>
												<option pre_booking_val=13.2 pre_booking_max_val=22 <?php echo $pre_booking['Rating3']=='Average'?"selected":""; ?> value="Average">Average</option>
												<option pre_booking_val=0 pre_booking_max_val=0 <?php echo $pre_booking['Rating3']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
										<td colspan=2>3.1 Appropriate options/ solutions were shared after understanding the customer needs</td>
										<td>
											<select class="form-control pre_booking_point process" id="standardization1" name="data[Ratings5]" identifier2="defects" identifier="process" identifier_pro="pro_count" identifier1="Crucial" required>
												<option selected value=''>Select</option>
												<option pre_booking_val=11 <?php echo $pre_booking['Ratings5']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option pre_booking_val=11 <?php echo $pre_booking['Ratings5']=='No'?"selected":""; ?> value="No">No</option>
												<option pre_booking_val=0 <?php echo $pre_booking['Ratings5']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
										<td colspan="1">Crucial</td>
										<td>
											<select class="form-control standard aoi" id="standardization1" name="data[Reason5]" required>
												<option selected value=''>Select</option>
												<option <?php echo $pre_booking['Reason5']=='Car related query not addressed'?"selected":""; ?> value="Car related query not addressed">Car related query not addressed</option>
												<option <?php echo $pre_booking['Reason5']=='Test related query not addressed'?"selected":""; ?> value="Test related query not addressed">Test related query not addressed</option>
												<option <?php echo $pre_booking['Reason5']=='Loan related query not addressed'?"selected":""; ?> value="Loan related query not addressed">Loan related query not addressed</option>
												
											</select>
										</td>
										<td><input type="text" class="form-control remarks" name="data[cmt5]" value="<?php echo $pre_booking['cmt5'] ?>"></td>
										<td  colspan="2">11</td>
										<td colspan="1">Process</td>
										
									</tr>
									<tr>
										<td colspan=2>3.2 Relevant USPs/ rebuttals/offers were effectively used to handle customer objections</td>
																			<td>
											<select class="form-control pre_booking_point process" id="standardization1" name="data[Ratings6]" identifier2="defects" identifier="process" identifier_pro="pro_count" identifier1="Crucial" required>
												<option selected value=''>Select</option>
												<option pre_booking_val=11 <?php echo $pre_booking['Ratings6']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option pre_booking_val=11 <?php echo $pre_booking['Ratings6']=='No'?"selected":""; ?> value="No">No</option>
												<option pre_booking_val=0 <?php echo $pre_booking['Ratings6']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
										<td colspan="1">Crucial</td>
										<td>
											<select class="form-control standard aoi" id="standardization1" name="data[Reason6]" required>
												<option selected value=''>Select</option>
												<option <?php echo $pre_booking['Reason6']=='USP not pitched'?"selected":""; ?> value="USP not pitched">USP not pitched</option>
												<option <?php echo $pre_booking['Reason6']=='Objection Handling not done'?"selected":""; ?> value="Objection Handling not done">Objection Handling not done</option>
												<option <?php echo $pre_booking['Reason6']=='Rebuttals not used'?"selected":""; ?> value="Rebuttals not used">Rebuttals not used</option>
												<option <?php echo $pre_booking['Reason6']=='Latest offer not informed to the customer'?"selected":""; ?> value="Latest offer not informed to the customer">Latest offer not informed to the customer</option>
											</select>
										</td>
										<td><input type="text" class="form-control remarks" name="data[cmt6]" value="<?php echo $pre_booking['cmt6'] ?>"></td>
										<td  colspan="2">11</td>
										<td colspan="1">Process</td>
									</tr>


									<tr>
										<td rowspan=4 style="background-color:#A9CCE3; font-weight:bold">4. Loan Process</td>
										<td rowspan=4>
											<select class="form-control pre_booking_point1" id="standardization1" name="data[Rating4]" required>
												<option selected value=''>Select</option>
												<option pre_booking_val=10 pre_booking_max_val=10 <?php echo $pre_booking['Rating4']=='Good'?"selected":""; ?> value="Good">Good</option>
												<option pre_booking_val=3 pre_booking_max_val=10 <?php echo $pre_booking['Rating4']=='Bad'?"selected":""; ?> value="Bad">Bad</option>
												<option pre_booking_val=6 pre_booking_max_val=10 <?php echo $pre_booking['Rating4']=='Average'?"selected":""; ?> value="Average">Average</option>
												<option pre_booking_val=0 pre_booking_max_val=0 <?php echo $pre_booking['Rating4']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
										<td colspan=2>4.1 Financing option was pitched in case of budget issue/ Loan USPs explained wherever required</td>
										<td>
											<select class="form-control pre_booking_point process" id="standardization1" name="data[Ratings7]" identifier2="defects" identifier="process" identifier_pro="pro_count" required>
												<option selected value=''>Select</option>
												<option pre_booking_val=2 <?php echo $pre_booking['Ratings7']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option pre_booking_val=2 <?php echo $pre_booking['Ratings7']=='No'?"selected":""; ?> value="No">No</option>
												<option pre_booking_val=0 <?php echo $pre_booking['Ratings7']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
										<td colspan="1">Non Crucial</td>
										<td>
											<select class="form-control standard aoi" id="standardization1" name="data[Reason7]" required>
												<option selected value=''>Select</option>
												<option <?php echo $pre_booking['Reason7']=='Loan USP & benefits not pitched'?"selected":""; ?> value="Loan USP & benefits not pitched">Loan USP & benefits not pitched</option>
												
											</select>
										</td>
										<td><input type="text" class="form-control remarks" name="data[cmt7]" value="<?php echo $pre_booking['cmt7'] ?>"></td>
										<td  colspan="2">2</td>
										<td colspan="1">Process</td>
										
									</tr>
									<tr>
										<td colspan=2>4.2 Loan eligibility was checked for the customer and pre-approved offer was shared/ EMI calculator was used, wherever applicable</td>
										<td>
											<select class="form-control pre_booking_point process" id="standardization1" name="data[Ratings8]" identifier2="defects" identifier="process" identifier_pro="pro_count" identifier1="Crucial" required>
												<option selected value=''>Select</option>
												<option pre_booking_val=3 <?php echo $pre_booking['Ratings8']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option pre_booking_val=3 <?php echo $pre_booking['Ratings8']=='No'?"selected":""; ?> value="No">No</option>
												<option pre_booking_val=0 <?php echo $pre_booking['Ratings8']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
										<td colspan="1">Crucial</td>
										<td>
											<select class="form-control standard aoi" id="standardization1" name="data[Reason8]" required>
												<option selected value=''>Select</option>
												<option <?php echo $pre_booking['Reason8']=='Did not check area servicability'?"selected":""; ?> value="Did not check area servicability">Did not check area servicability</option>
												<option <?php echo $pre_booking['Reason8']=='Did not check eligibility'?"selected":""; ?> value="Did not check eligibility">Did not check eligibility</option>
												<option <?php echo $pre_booking['Reason8']=='preapproved offer not shared'?"selected":""; ?> value="preapproved offer not shared">preapproved offer not shared</option>
												<option <?php echo $pre_booking['Reason8']=='Loan calculator not used.'?"selected":""; ?> value="Loan calculator not used.">Loan calculator not used.</option>
											</select>
										</td>
										<td><input type="text" class="form-control remarks" name="data[cmt8]" value="<?php echo $pre_booking['cmt8'] ?>"></td>
										<td  colspan="2">3</td>
										<td colspan="1">Process</td>


										<tr>
										<td colspan=2>4.3 In case of non-servicability or customer ineligible for loan, alternative options were shared</td>
																			<td>
											<select class="form-control pre_booking_point process" id="standardization1" name="data[Ratings9]" identifier2="defects" identifier="process" identifier_pro="pro_count" required>
												<option selected value=''>Select</option>
												<option pre_booking_val=2 <?php echo $pre_booking['Ratings9']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option pre_booking_val=2 <?php echo $pre_booking['Ratings9']=='No'?"selected":""; ?> value="No">No</option>
												<option pre_booking_val=0 <?php echo $pre_booking['Ratings9']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
										<td colspan="1">Non Crucial</td>
										<td><input type="text" class="form-control aoi" name="data[Reason9]" value="<?php echo $pre_booking['Reason9'] ?>"></td>
										<td><input type="text" class="form-control remarks" name="data[cmt9]" value="<?php echo $pre_booking['cmt9'] ?>"></td>
										<td  colspan="2">2</td>
										<td colspan="1">Process</td>

										<tr>
										<td colspan=2>4.4 Information about the loan documents and the bank statement link was shared, wherever applicable</td>
										<td>
											<select class="form-control pre_booking_point process" id="standardization1" name="data[Ratings10]" identifier2="defects" identifier1="Crucial" identifier="process" identifier_pro="pro_count" required>
												<option selected value=''>Select</option>
												<option pre_booking_val=3 <?php echo $pre_booking['Ratings10']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option pre_booking_val=3 <?php echo $pre_booking['Ratings10']=='No'?"selected":""; ?> value="No">No</option>
												<option pre_booking_val=0 <?php echo $pre_booking['Ratings10']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
										<td colspan="1">Crucial</td>
										<td>
											<select class="form-control standard aoi" id="standardization1" name="data[Reason10]" required>
												<option selected value=''>Select</option>
												<option <?php echo $pre_booking['Reason10']=='Loan documents not informed'?"selected":""; ?> value="Loan documents not informed">Loan documents not informed</option>
												<option <?php echo $pre_booking['Reason10']=='6 months bank statement not informed'?"selected":""; ?> value="6 months bank statement not informed">6 months bank statement not informed</option>
												<option <?php echo $pre_booking['Reason10']=='Bank statement link not shared'?"selected":""; ?> value="Bank statement link not shared">Bank statement link not shared</option>
												<option <?php echo $pre_booking['Reason10']=='How to upload bank statement not explained.'?"selected":""; ?> value="How to upload bank statement not explained.">How to upload bank statement not explained.</option>
											</select>
										</td>
										<td><input type="text" class="form-control remarks" name="data[cmt10]" value="<?php echo $pre_booking['cmt10'] ?>"></td>
										<td  colspan="2">3</td>
										<td colspan="1">Process</td>


									</tr>


									<tr>
										<td rowspan=3 style="background-color:#A9CCE3; font-weight:bold">5. Test drive booking process</td>
										<td rowspan=3>
											<select class="form-control pre_booking_point1" id="standardization1" name="data[Rating5]" required>
												<option selected value=''>Select</option>
												<option pre_booking_val=12 pre_booking_max_val=12 <?php echo $pre_booking['Rating5']=='Good'?"selected":""; ?> value="Good">Good</option>
												<option pre_booking_val=3.6 pre_booking_max_val=12 <?php echo $pre_booking['Rating5']=='Bad'?"selected":""; ?> value="Bad">Bad</option>
												<option pre_booking_val=7.20 pre_booking_max_val=12 <?php echo $pre_booking['Rating5']=='Average'?"selected":""; ?> value="Average">Average</option>
												<option pre_booking_val=0 pre_booking_max_val=0 <?php echo $pre_booking['Rating5']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
										<td colspan=2>5.1 Car details along with key highlights of the car were shared</td>
										<td>
											<select class="form-control pre_booking_point process" id="standardization1" name="data[Ratings11]" identifier2="defects" identifier="process" identifier_pro="pro_count" required>
												<option selected value=''>Select</option>
												<option pre_booking_val=2 <?php echo $pre_booking['Ratings11']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option pre_booking_val=2 <?php echo $pre_booking['Ratings11']=='No'?"selected":""; ?> value="No">No</option>
												<option pre_booking_val=0 <?php echo $pre_booking['Ratings11']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
										<td colspan="1">Non Crucial</td>
										<td>
											<select class="form-control standard aoi" id="standardization1" name="data[Reason11]" required>
												<option selected value=''>Select</option>
												<option <?php echo $pre_booking['Reason11']=='Advisor failed to inform about the Key features of the car'?"selected":""; ?> value="Advisor failed to inform about the Key features of the car">Advisor failed to inform about the Key features of the car</option>
												
											</select>
										</td>
										<td><input type="text" class="form-control remarks" name="data[cmt11]" value="<?php echo $pre_booking['cmt11'] ?>"></td>
										<td  colspan="2">2</td>
										<td colspan="1">Process</td>
										
									</tr>
									<tr>
										<td colspan=2>5.2 All the required details for for the test drive were confirmed (date/ time/ payment mode/ location/Hub distance)</td>
																			<td>
											<select class="form-control pre_booking_point process" id="standardization1" name="data[Ratings12]" identifier2="defects" identifier1="Crucial" identifier="process" identifier_pro="pro_count" required>
												<option selected value=''>Select</option>
												<option pre_booking_val=5 <?php echo $pre_booking['Ratings12']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option pre_booking_val=5 <?php echo $pre_booking['Ratings12']=='No'?"selected":""; ?> value="No">No</option>
												<option pre_booking_val=0 <?php echo $pre_booking['Ratings12']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
										<td colspan="1">Crucial</td>
										<td>
											<select class="form-control standard aoi" id="standardization1" name="data[Reason12]" required>
												<option selected value=''>Select</option>
												<option <?php echo $pre_booking['Reason12']=='Payment mode not confirmed'?"selected":""; ?> value="Payment mode not confirmed">Payment mode not confirmed</option>
												<option <?php echo $pre_booking['Reason12']=='Store distance not checked'?"selected":""; ?> value="Store distance not checked">Store distance not checked</option>
												<option <?php echo $pre_booking['Reason12']=='Payment mode not confirmed Self payment'?"selected":""; ?> value="Payment mode not confirmed Self payment">Payment mode not confirmed Self payment</option>
												<option <?php echo $pre_booking['Reason12']=='Payment mode not confirmed Finance'?"selected":""; ?> value="Payment mode not confirmed Finance">Payment mode not confirmed Finance</option>
												<option <?php echo $pre_booking['Reason12']=='Delivery mode not confirmed( Store/ Home test drive)'?"selected":""; ?> value="Delivery mode not confirmed( Store/ Home test drive)">Delivery mode not confirmed( Store/ Home test drive)</option>
												<option <?php echo $pre_booking['Reason12']=='Date not confirmed'?"selected":""; ?> value="Date not confirmed">Date not confirmed</option>
												<option <?php echo $pre_booking['Reason12']=='Time slot not confirmed'?"selected":""; ?> value="Time slot not confirmed">Time slot not confirmed</option>
											</select>
										</td>
										<td><input type="text" class="form-control remarks" name="data[cmt12]" value="<?php echo $pre_booking['cmt12'] ?>"></td>
										<td  colspan="2">5</td>
										<td colspan="1">Process</td>


										<tr>
										<td colspan=2>5.3 Effort was put for booking the test drive on the call itself</td>
																			<td>
											<select class="form-control pre_booking_point process" id="standardization1" name="data[Ratings13]" identifier2="defects" identifier="process" identifier_pro="pro_count" required>
												<option selected value=''>Select</option>
												<option pre_booking_val=5 <?php echo $pre_booking['Ratings13']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option pre_booking_val=5 <?php echo $pre_booking['Ratings13']=='No'?"selected":""; ?> value="No">No</option>
												<option pre_booking_val=0 <?php echo $pre_booking['Ratings13']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
										<td colspan="1">Non Crucial</td>
										<td>
											<select class="form-control standard aoi" id="standardization1" name="data[Reason13]" required>
												<option selected value=''>Select</option>
												<option <?php echo $pre_booking['Reason13']=='Advisor have the opportunity to convince the customer on call book but didnt convince the customer'?"selected":""; ?> value="Advisor have the opportunity to convince the customer on call book but didnt convince the customer">Advisor have the opportunity to convince the customer on call book but didnt convince the customer</option>
												
											</select>
										</td>
										<td><input type="text" class="form-control remarks" name="data[cmt13]" value="<?php echo $pre_booking['cmt13'] ?>"></td>
										<td  colspan="2">5</td>
										<td colspan="1">Process</td>


									</tr>


									<tr>
										<td rowspan=3 style="background-color:#A9CCE3; font-weight:bold">6. Rapport Building & Conversation</td>
										<td rowspan=3>
											<select class="form-control pre_booking_point1" id="standardization1" name="data[Rating6]" required>
												<option selected value=''>Select</option>
												<option pre_booking_val=10 pre_booking_max_val=10 <?php echo $pre_booking['Rating6']=='Good'?"selected":""; ?> value="Good">Good</option>
												<option pre_booking_val=3 pre_booking_max_val=10 <?php echo $pre_booking['Rating6']=='Bad'?"selected":""; ?> value="Bad">Bad</option>
												<option pre_booking_val=6 pre_booking_max_val=10 <?php echo $pre_booking['Rating6']=='Average'?"selected":""; ?> value="Average">Average</option>
												<option pre_booking_val=0 pre_booking_max_val=0 <?php echo $pre_booking['Rating6']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
										<td colspan=2>6.1 There was rapport, Rate of speech was appropriate, energy and confidence, friendly/polite tone, and personalization on the call</td>
										<td>
											<select class="form-control pre_booking_point customer no_count" id="standardization1" name="data[Ratings14]" identifier2="defects" identifier="customer" identifier_no="no_count" required>
												<option selected value=''>Select</option>
												<option pre_booking_val=4 <?php echo $pre_booking['Ratings14']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option pre_booking_val=4 <?php echo $pre_booking['Ratings14']=='No'?"selected":""; ?> value="No">No</option>
												<option pre_booking_val=0 <?php echo $pre_booking['Ratings14']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
										<td colspan="1">Non Crucial</td>
										<td>
											<select class="form-control standard aoi" id="standardization1" name="data[Reason14]" required>
												<option selected value=''>Select</option>
												<option <?php echo $pre_booking['Reason14']=='Two way communication was missing'?"selected":""; ?> value="Two way communication was missing">Two way communication was missing</option>
												<option <?php echo $pre_booking['Reason14']=='Advisor rate of speech'?"selected":""; ?> value="Advisor rate of speech">Advisor rate of speech</option>
												<option <?php echo $pre_booking['Reason14']=='Did not personalize'?"selected":""; ?> value="Did not personalize">Did not personalize</option>
												<option <?php echo $pre_booking['Reason14']=='Did not keep appropriate tone'?"selected":""; ?> value="Did not keep appropriate tone">Did not keep appropriate tone</option>
												<option <?php echo $pre_booking['Reason14']=='Did not apologize'?"selected":""; ?> value="Did not apologize">Did not apologize</option>
												<option <?php echo $pre_booking['Reason14']=='Dull tone/sounded lethargic'?"selected":""; ?> value="Dull tone/sounded lethargic">Dull tone/sounded lethargic</option>
											</select>
										</td>
										<td><input type="text" class="form-control remarks" name="data[cmt14]" value="<?php echo $pre_booking['cmt14'] ?>"></td>
										<td  colspan="2">4</td>
										<td colspan="1">CustEx</td>
										
									</tr>
									<tr>
										<td colspan=2>6.2 There was active listening and acknowledgement on the call- no interruption, no unnecessary repetition, no dead air</td>
										<td>
											<select class="form-control pre_booking_point customer no_count" id="standardization1" name="data[Ratings15]" identifier2="defects" identifier="customer" identifier_no="no_count" required>
												<option selected value=''>Select</option>
												<option pre_booking_val=2 <?php echo $pre_booking['Ratings15']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option pre_booking_val=2 <?php echo $pre_booking['Ratings15']=='No'?"selected":""; ?> value="No">No</option>
												<option pre_booking_val=0 <?php echo $pre_booking['Ratings15']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
										<td colspan="1">Non Crucial</td>
										<td>
											<select class="form-control standard aoi" id="standardization1" name="data[Reason15]" required>
												<option selected value=''>Select</option>
												<option <?php echo $pre_booking['Reason15']=='Did not follow the hold/unhold procedure'?"selected":""; ?> value="Did not follow the hold/unhold procedure">Did not follow the hold/unhold procedure</option>
												<option <?php echo $pre_booking['Reason15']=='Did not actively listen to the customer concern'?"selected":""; ?> value="Did not actively listen to the customer concern">Did not actively listen to the customer concern</option>
												<option <?php echo $pre_booking['Reason15']=='Did not acknowledge customer query/ concern'?"selected":""; ?> value="Did not acknowledge customer query/ concern">Did not acknowledge customer query/ concern</option>
												<option <?php echo $pre_booking['Reason15']=='Interrupted the customer'?"selected":""; ?> value="Interrupted the customer">Interrupted the customer</option>
												<option <?php echo $pre_booking['Reason15']=='Dead air found more than 5 secs'?"selected":""; ?> value="Dead air found more than 5 secs">Dead air found more than 5 secs</option>
											</select>
										</td>
										<td><input type="text" class="form-control remarks" name="data[cmt15]" value="<?php echo $pre_booking['cmt15'] ?>"></td>
										<td  colspan="2">2</td>
										<td colspan="1">CustEx</td>


										<tr>
										<td colspan=2>6.3 Clear and concise communication- Sentences were appropriately constructed with the right grammar , jargon/internal references/archaic Hindi terms were avoided</td>
										<td>
											<select class="form-control pre_booking_point customer no_count" id="standardization1" name="data[Ratings16]" identifier2="defects" identifier="customer" identifier_no="no_count" required>
												<option selected value=''>Select</option>
												<option pre_booking_val=4 <?php echo $pre_booking['Ratings16']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option pre_booking_val=4 <?php echo $pre_booking['Ratings16']=='No'?"selected":""; ?> value="No">No</option>
												<option pre_booking_val=0 <?php echo $pre_booking['Ratings16']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
										<td colspan="1">Non Crucial</td>
										<td>
											<select class="form-control standard aoi" id="standardization1" name="data[Reason16]" required>
												<option selected value=''>Select</option>
												<option <?php echo $pre_booking['Reason16']=='Sentence formation was missing'?"selected":""; ?> value="Sentence formation was missing">Sentence formation was missing</option>
												<option <?php echo $pre_booking['Reason16']=='Incorrect choice of words used on the call'?"selected":""; ?> value="Incorrect choice of words used on the call">Incorrect choice of words used on the call</option>
												<option <?php echo $pre_booking['Reason16']=='Used jargons/Internal refrences on call'?"selected":""; ?> value="Used jargons/Internal refrences on call">Used jargons/Internal refrences on call</option>
												<option <?php echo $pre_booking['Reason16']=='Used typical hindi termso'?"selected":""; ?> value="Used typical hindi terms">Used typical hindi terms</option>
												<option <?php echo $pre_booking['Reason16']=='Fumbled & did not speak clearly'?"selected":""; ?> value="Fumbled & did not speak clearly">Fumbled & did not speak clearly</option>
											</select>
										</td>
										<td><input type="text" class="form-control remarks" name="data[cmt16]" value="<?php echo $pre_booking['cmt16'] ?>"></td>
										<td  colspan="2">4</td>
										<td colspan="1">CustEx</td>


									</tr>


									<tr>
										<td rowspan=1 style="background-color:#A9CCE3; font-weight:bold">7. Disposition</td>
										<td rowspan=1>
											<select class="form-control pre_booking_point1" id="standardization1" name="data[Rating7]" required>
												<option selected value=''>Select</option>
												<option pre_booking_val=2 pre_booking_max_val=6 <?php echo $pre_booking['Rating7']=='Good'?"selected":""; ?> value="Good">Good</option>
												<option pre_booking_val=1.8 pre_booking_max_val=6 <?php echo $pre_booking['Rating7']=='Bad'?"selected":""; ?> value="Bad">Bad</option>
												<!-- <option pre_booking_val=3.6 pre_booking_max_val=6 <?php echo $pre_booking['Rating7']=='Average'?"selected":""; ?> value="Average">Average</option>
												<option pre_booking_val=0 pre_booking_max_val=0 <?php echo $pre_booking['Rating7']=='NA'?"selected":""; ?> value="NA">NA</option> -->
											</select>
										</td>
										<td colspan=2>7.1 The correct disposition and tags were selected</td>
										<td>
											<select class="form-control pre_booking_point process" id="standardization1" name="data[Ratings17]" identifier2="defects" identifier1="Crucial" identifier="process" identifier_pro="pro_count" required>
												<option selected value=''>Select</option>
												<option pre_booking_val=3 <?php echo $pre_booking['Ratings17']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option pre_booking_val=3 <?php echo $pre_booking['Ratings17']=='No'?"selected":""; ?> value="No">No</option>
												<option pre_booking_val=0 <?php echo $pre_booking['Ratings17']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
										<td colspan="1">Crucial</td>
										<td>
											<select class="form-control standard aoi" id="standardization1" name="data[Reason17]" required>
												<option selected value=''>Select</option>
												<option <?php echo $pre_booking['Reason17']=='Did not choose correct disposition'?"selected":""; ?> value="Did not choose correct disposition">Did not choose correct disposition</option>
												<option <?php echo $pre_booking['Reason17']=='Did not choose correct sub disposition'?"selected":""; ?> value="Did not choose correct sub disposition">Did not choose correct sub disposition</option>
											</select>
										</td>
										<td><input type="text" class="form-control remarks" name="data[cmt17]" value="<?php echo $pre_booking['cmt17'] ?>"></td>
										<td  colspan="2">3</td>
										<td colspan="1">Process</td>
										
									</tr>
									
									</tr>

									<tr>
										<td rowspan=1 style="background-color:#A9CCE3; font-weight:bold">8. Closing</td>
										<td rowspan=1>
											<select class="form-control pre_booking_point1" id="standardization1" name="data[Rating8]" required>
												<option selected value=''>Select</option>
												<option pre_booking_val=13 pre_booking_max_val=13 <?php echo $pre_booking['Rating8']=='Good'?"selected":""; ?> value="Good">Good</option>
												<option pre_booking_val=3.9 pre_booking_max_val=13 <?php echo $pre_booking['Rating8']=='Bad'?"selected":""; ?> value="Bad">Bad</option>
												<option pre_booking_val=7.8 pre_booking_max_val=13 <?php echo $pre_booking['Rating8']=='Average'?"selected":""; ?> value="Average">Average</option>
												<option pre_booking_val=0 pre_booking_max_val=0 <?php echo $pre_booking['Rating8']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
										<td colspan=2>8.1 Closing guideline was followed correctly (Summarization, further assistance, CSAT for callbacks)</td>
										<td>
											<select class="form-control pre_booking_point process" id="standardization1" name="data[Ratings18]" identifier2="defects" identifier="process" identifier_pro="pro_count" required>
												<option selected value=''>Select</option>
												<option pre_booking_val=3 <?php echo $pre_booking['Ratings18']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option pre_booking_val=3 <?php echo $pre_booking['Ratings18']=='No'?"selected":""; ?> value="No">No</option>
												<option pre_booking_val=0 <?php echo $pre_booking['Ratings18']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
										<td colspan="1">Non Crucial</td>
										<td>
											<select class="form-control standard aoi" id="standardization1" name="data[Reason18]" required>
												<option selected value=''>Select</option>
												<option <?php echo $pre_booking['Reason18']=='Did not summarize'?"selected":""; ?> value="Did not summarize">Did not summarize</option>
												<option <?php echo $pre_booking['Reason18']=='further assistance missing'?"selected":""; ?> value="further assistance missing">further assistance missing</option>
												<option <?php echo $pre_booking['Reason18']=='CSAT not pitched'?"selected":""; ?> value="CSAT not pitched">CSAT not pitched</option>
												<option <?php echo $pre_booking['Reason18']=='closing missing'?"selected":""; ?> value="closing missing">closing missing</option>
											</select>
										</td>
										<td><input type="text" class="form-control remarks" name="data[cmt18]" value="<?php echo $pre_booking['cmt18'] ?>"></td>
										<td  colspan="2">3</td>
										<td colspan="1">Process</td>
										
									</tr>
									
									</tr>

									<tr>
										<td rowspan=1 style="background-color:#A9CCE3; font-weight:bold">9. Wrong or misleading information</td>
										<td rowspan=1>
											<select class="form-control pre_booking_point" id="standardization1" name="data[Rating9]" required>
												
												
												<option pre_booking_val=2 pre_booking_max_val <?php echo $pre_booking['Rating9']=='Bad'?"selected":""; ?> value="Bad">Bad</option>
												
												<option pre_booking_val=2 pre_booking_max_val= <?php echo $pre_booking['Rating9']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
										<td colspan=2>9.1 No Incomplete or misleading information provided/Forceful/false booking was done on call</td>
										<td>
											<select class="form-control pre_booking_point process" identifier2="defects" identifier1="Crucial" identifier="process" identifier_pro="pro_count" id="standardization1" name="data[Ratings19]" required>
												<option selected value=''>Select</option>
												<option pre_booking_val=13 <?php echo $pre_booking['Ratings19']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option pre_booking_val=13 <?php echo $pre_booking['Ratings19']=='No'?"selected":""; ?> value="No">No</option>
												<option pre_booking_val=0 <?php echo $pre_booking['Ratings19']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
										<td colspan="1">Crucial</td>
										<td>
											<select class="form-control standard aoi" id="standardization1" name="data[Reason19]" required>
												<option selected value=''>Select</option>
												<option <?php echo $pre_booking['Reason19']=='Incorrect TAT informed'?"selected":""; ?> value="Incorrect TAT informed">Incorrect TAT informed</option>
												<option <?php echo $pre_booking['Reason19']=='Incorrect information related to the price negotiation'?"selected":""; ?> value="Incorrect information related to the price negotiation">Incorrect information related to the price negotiation</option>
												<option <?php echo $pre_booking['Reason19']=='Incorrect information related to the finance'?"selected":""; ?> value="Incorrect information related to the finance">Incorrect information related to the finance</option>
												<option <?php echo $pre_booking['Reason19']=='Incorrect information shared about the test drive'?"selected":""; ?> value="Incorrect information shared about the test drive">Incorrect information shared about the test drive</option>
												<option <?php echo $pre_booking['Reason19']=='Incorrect information shared about the car related /Warranty/Insurance/ 7days return/RC'?"selected":""; ?> value="Incorrect information shared about the car related /Warranty/Insurance/ 7days return/RC">Incorrect information shared about the car related /Warranty/Insurance/ 7days return/RC</option>
											</select>
										</td>
										<td><input type="text" class="form-control remarks" name="data[cmt19]" value="<?php echo $pre_booking['cmt19'] ?>"></td>
										<td  colspan="2">13</td>
										<td colspan="1">Process</td>
										
									</tr>
									
									</tr>

									<tr>
										<td rowspan=1 style="background-color:#A9CCE3; font-weight:bold">10. Zero Tolerance</td>
									
										<td colspan=3>ZTP</td>
										<td>
											<select class="form-control pre_booking_point process" id="standardization1" name="data[Ratings20]" identifier2="defects" identifier="process" identifier_pro="pro_count" required>
												<option selected value=''>Select</option>
												<option pre_booking_val=0 <?php echo $pre_booking['Ratings20']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option pre_booking_val=0 <?php echo $pre_booking['Ratings20']=='No'?"selected":""; ?> value="No">No</option>
												<option pre_booking_val=0 <?php echo $pre_booking['Ratings20']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
										<td colspan="1">ZTP</td>
										<td>
											<select class="form-control standard aoi" id="standardization1" name="data[Reason20]">
												<option selected value=''>Select</option>
												<option <?php echo $pre_booking['Reason20']=='Do not use vulgar, abusive or offensive language in references to someones Race, Ethnicity, Religion, Gender, Lifestyle, and sexual orientation'?"selected":""; ?> value="Do not use vulgar, abusive or offensive language in references to someones Race, Ethnicity, Religion, Gender, Lifestyle, and sexual orientation">Do not use vulgar, abusive or offensive language in references to someone's Race, Ethnicity, Religion, Gender, Lifestyle, and sexual orientation</option>
												<option <?php echo $pre_booking['Reason20']=='Do not yell or scream at the customer- Do not use rude, abrasive, sarcastic comments'?"selected":""; ?> value="Do not yell or scream at the customer- Do not use rude, abrasive, sarcastic comments">Do not yell or scream at the customer- Do not use rude, abrasive, sarcastic comments</option>
												<option <?php echo $pre_booking['Reason20']=='Do not create fake/forced test drive booking without customer consent'?"selected":""; ?> value="Do not create fake/forced test drive booking without customer consent">Do not create fake/forced test drive booking without customer consent</option>
												<option <?php echo $pre_booking['Reason20']=='Avoid singing or humming on call'?"selected":""; ?> value="Avoid singing or humming on call">Avoid singing or humming on call</option>
												<option <?php echo $pre_booking['Reason20']=='Do not disconnect the call by giving a forced closing/ Not give response to the customer.'?"selected":""; ?> value="Do not disconnect the call by giving a forced closing/ Not give response to the customer.">Do not disconnect the call by giving a forced closing/ Not give response to the customer.</option>
												<option <?php echo $pre_booking['Reason20']=='Incase of abusive customer- one should warn the customer in polite manner and warn 2-3 times before disconnect the call.'?"selected":""; ?> value="Incase of abusive customer- one should warn the customer in polite manner and warn 2-3 times before disconnect the call.">Incase of abusive customer- one should warn the customer in polite manner and warn 2-3 times before disconnect the call.</option>
												<option <?php echo $pre_booking['Reason20']=='Do not transfer Call/Chat without informing the same to the customer'?"selected":""; ?> value="Do not transfer Call/Chat without informing the same to the customer">Do not transfer Call/Chat without informing the same to the customer</option>
												<option <?php echo $pre_booking['Reason20']=='Do not make disparaging remarks about CARS24/ its affiliates/ products on system'?"selected":""; ?> value="Do not make disparaging remarks about CARS24/ its affiliates/ products on system">Do not make disparaging remarks about CARS24/ its affiliates/ products on system</option>
												<option <?php echo $pre_booking['Reason20']=='Do not miss creating tickets/forwarding customer concerns to the respective team -As per the SOP'?"selected":""; ?> value="Do not miss creating tickets/forwarding customer concerns to the respective team -As per the SOP">Do not miss creating tickets/forwarding customer concerns to the respective team -As per the SOP</option>
												<option <?php echo $pre_booking['Reason20']=='Do not call the customer from a personal number'?"selected":""; ?> value="Do not call the customer from a personal number">Do not call the customer from a personal number</option>
												<option <?php echo $pre_booking['Reason20']=='Do not share any personal information on call like phone number, home address etc'?"selected":""; ?> value="Do not share any personal information on call like phone number, home address etc">Do not share any personal information on call like phone number, home address etc</option>
											</select>
										</td>
										<td><input type="text" class="form-control remarks" name="data[cmt20]" value="<?php echo $pre_booking['cmt20'] ?>"></td>
										<td  colspan="2"></td>
										<td colspan="1">Process</td>
										
									</tr>
									
									</tr>


									<tr>
										<td rowspan=1 style="background-color:#A9CCE3; font-weight:bold">11. Exceptional Call</td>
									
										<td colspan=3>11.1 Did the Advisor provide Customer Experience beyond expectation ?</td>
										<td>
											<select class="form-control pre_booking_point " id="standardization1" name="data[Ratings21]" required>
												<option selected value=''>Select</option>
												<option pre_booking_val=0 <?php echo $pre_booking['Ratings21']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option pre_booking_val=0 <?php echo $pre_booking['Ratings21']=='No'?"selected":""; ?> value="No">No</option>
												<option pre_booking_val=0 <?php echo $pre_booking['Ratings21']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
										<td colspan="1">Analysis</td>
										<td><input type="text" class="form-control 11-1 " name="data[cmt21]" value="<?php echo $pre_booking['cmt21'] ?>"></td>
										<td><input type="text" class="form-control remarks" name="data[cmt22]" value="<?php echo $pre_booking['cmt22'] ?>"></td>
										<td  colspan="2"></td>
										<td colspan="1">Analysis</td>
										
									</tr>
									</tr>

									<tr>
										<td rowspan=4 style="background-color:#A9CCE3; font-weight:bold">12. ACTP Analysis</td>
										
										<td colspan=3>12.1 Advisor related observations / challenges noticed on call</td>
										<td colspan="2"><input type="text" class="form-control" name="data[cmt23]" value="<?php echo $pre_booking['cmt23'] ?>"></td>
										<td><input type="text" class="form-control aoi" name="data[cmt24]" value="<?php echo $pre_booking['cmt24'] ?>"></td>
										<td><input type="text" class="form-control remarks" name="data[cmt25]" value="<?php echo $pre_booking['cmt25'] ?>"></td>
										<td  colspan="2"></td>
										<td colspan="1">Analysis</td>
										
									</tr>
									<tr>
										<td colspan=3>12.2 Customer related observations / challenges noticed on call</td>
										<td colspan="2"><input type="text" class="form-control" name="data[cmt26]" value="<?php echo $pre_booking['cmt26'] ?>"></td>
										<td><input type="text" class="form-control aoi" name="data[cmt27]" value="<?php echo $pre_booking['cmt27'] ?>"></td>
										<td><input type="text" class="form-control remarks" name="data[cmt28]" value="<?php echo $pre_booking['cmt28'] ?>"></td>
										<td  colspan="2"></td>
										<td colspan="1">Analysis</td>


										<tr>
										<td colspan=3>12.3 Technical related observations / challenges noticed on call</td>
											<td colspan="2"><input type="text" class="form-control" name="data[cmt29]" value="<?php echo $pre_booking['cmt29'] ?>"></td>
										<td><input type="text" class="form-control aoi" name="data[cmt30]" value="<?php echo $pre_booking['cmt30'] ?>"></td>
										<td><input type="text" class="form-control remarks" name="data[cmt31]" value="<?php echo $pre_booking['cmt31'] ?>"></td>
										<td  colspan="2"></td>
										<td colspan="1">Analysis</td>

										<tr>
										<td colspan=3>12.4 Process related observations / challenges noticed on call</td>
										<td colspan="2"><input type="text" class="form-control" name="data[cmt32]" value="<?php echo $pre_booking['cmt32'] ?>"></td>
										<td><input type="text" class="form-control aoi" name="data[cmt33]" value="<?php echo $pre_booking['cmt33'] ?>"></td>
										<td><input type="text" class="form-control remarks" name="data[cmt34]" value="<?php echo $pre_booking['cmt34'] ?>"></td>
										<td  colspan="2"></td>
										<td colspan="1">Analysis</td>


									</tr>


									<tr>
										<td rowspan=5 style="background-color:#A9CCE3; font-weight:bold">13. Compliance</td>
										
										<td colspan=3>13.1 Different Car suggested and pitched properly</td>
										<td colspan="2">
											<select class="form-control " id="standardization1" name="data[cmt35]" required>
												<option selected value=''>Select</option>
												<option <?php echo $pre_booking['cmt35']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option <?php echo $pre_booking['cmt35']=='No'?"selected":""; ?> value="No">No</option>
												<option <?php echo $pre_booking['cmt35']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
										<td><input type="text" class="form-control aoi" name="data[cmt36]" value="<?php echo $pre_booking['cmt36'] ?>"></td>
										<td><input type="text" class="form-control remarks" name="data[cmt37]" value="<?php echo $pre_booking['cmt37'] ?>"></td>
										<td  colspan="2"></td>
										<td colspan="1"></td>
										
									</tr>
									<tr>
										<td colspan=3>13.2 Car Finding Process flow</td>
										<td colspan="2">
											<select class="form-control " id="standardization1" name="data[cmt38]" required>
												<option selected value=''>Select</option>
												<option <?php echo $pre_booking['cmt38']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option <?php echo $pre_booking['cmt38']=='No'?"selected":""; ?> value="No">No</option>
												<option <?php echo $pre_booking['cmt38']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
										<td><input type="text" class="form-control aoi" name="data[cmt39]" value="<?php echo $pre_booking['cmt39'] ?>"></td>
										<td><input type="text" class="form-control remarks" name="data[cmt40]" value="<?php echo $pre_booking['cmt40'] ?>"></td>
										<td  colspan="2"></td>
										<td colspan="1"></td>


										<tr>
										<td colspan=3>13.3 Order link shared(All the details shared with the customer)</td>
											<td colspan="2">
											<select class="form-control " id="standardization1" name="data[cmt41]" required>
												<option selected value=''>Select</option>
												<option <?php echo $pre_booking['cmt41']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option <?php echo $pre_booking['cmt41']=='No'?"selected":""; ?> value="No">No</option>
												<option <?php echo $pre_booking['cmt41']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
										<td><input type="text" class="form-control aoi" name="data[cmt42]" value="<?php echo $pre_booking['cmt42'] ?>"></td>
										<td><input type="text" class="form-control remarks" name="data[cmt43]" value="<?php echo $pre_booking['cmt43'] ?>"></td>
										<td  colspan="2"></td>
										<td colspan="1"></td>

										<tr>
										<td colspan=3>13.4 Pitched for visit effectively</td>
										<td colspan="2">
											<select class="form-control " id="standardization1" name="data[cmt44]" required>
												<option selected value=''>Select</option>
												<option <?php echo $pre_booking['cmt44']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option <?php echo $pre_booking['cmt44']=='No'?"selected":""; ?> value="No">No</option>
												<option <?php echo $pre_booking['cmt44']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
										<td><input type="text" class="form-control aoi" name="data[cmt45]" value="<?php echo $pre_booking['cmt45'] ?>"></td>
										<td><input type="text" class="form-control remarks" name="data[cmt46]" value="<?php echo $pre_booking['cmt46'] ?>"></td>
										<td  colspan="2"></td>
										<td colspan="1"></td>

										<tr>
										<td colspan=3>13.5 Pitched paid  where ever required</td>
										<td colspan="2">
											<select class="form-control " id="standardization1" name="data[cmt47]" required>
												<option selected value=''>Select</option>
												<option <?php echo $pre_booking['cmt47']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option <?php echo $pre_booking['cmt47']=='No'?"selected":""; ?> value="No">No</option>
												<option <?php echo $pre_booking['cmt47']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
										<td><input type="text" class="form-control aoi" name="data[cmt48]" value="<?php echo $pre_booking['cmt48'] ?>"></td>
										<td><input type="text" class="form-control remarks" name="data[cmt49]" value="<?php echo $pre_booking['cmt49'] ?>"></td>
										<td  colspan="2"></td>
										<td colspan="1"></td>


									</tr>


									<tr><td colspan=4  style="background-color:#D2B4DE">Sub Parameter Opportunities Process Parameters</td><td colspan=8  style="background-color:#D2B4DE">Sub Parameter Opportunities Customer Parameters</td></tr>
									<tr>
										<td colspan="2" style="background-color:#D2B4DE">Count:</td><td  colspan="2"><input id="processEarned" class="form-control" value="<?php echo $pre_booking['Sub_Parameter_Opportunities_Process'] ?>" name="data[Sub_Parameter_Opportunities_Process]"></td>

										<td colspan="2"  style="background-color:#D2B4DE">Count:</td><td  colspan="8"><input id="customerEarned" class="form-control" value="<?php echo $pre_booking['Sub_Parameter_Opportunities_Customer'] ?>" name="data[Sub_Parameter_Opportunities_Customer]"></td>
									</tr>
									

									

									

									<tr><td colspan=4  style="background-color:#D2B4DE">Sub Parameter Defects  Process Parameters</td><td colspan=8  style="background-color:#D2B4DE">Sub Parameter Defects Customer Parameters</td></tr>
									<tr>
										<!-- <td colspan="2"  style="background-color:#D2B4DE">Count:</td><td colspan="2"><input id="processPossible" class="form-control" value="<?php echo $pre_booking['Sub_Parameter_Defects_Process'] ?>" name="data[Sub_Parameter_Defects_Process]"></td> -->

										<td colspan="2"  style="background-color:#D2B4DE">Count:</td><td colspan="2"><input id="process_count" class="form-control" value="<?php echo $pre_booking['Sub_Parameter_Defects_Process'] ?>" name="data[Sub_Parameter_Defects_Process]"></td>

										<!-- <td colspan="2"  style="background-color:#D2B4DE">Count:</td><td colspan="6"><input id="customerPossible" class="form-control" value="<?php echo $pre_booking['Sub_Parameter_Defects_Customer'] ?>" name="data[Sub_Parameter_Defects_Customer]"></td> -->

										<td colspan="2"  style="background-color:#D2B4DE">Count:</td><td colspan="6"><input id="customerno_count" class="form-control" value="<?php echo $pre_booking['Sub_Parameter_Defects_Customer'] ?>" name="data[Sub_Parameter_Defects_Customer]"></td>
									</tr>


									<!-- <tr style="background-color:#D2B4DE"><td colspan=4>Sub Parameter Accuracy  Process Parameters</td><td colspan=8>Sub Parameter Accuracy Customer Parameters</td></tr>
									<tr style="background-color:#D2B4DE">
										<td colspan="">Accuracy:</td><td id="processJiCisScore" colspan="2"></td><td colspan="4">Accuracy:</td><td id="custJiCisScore" colspan="4"></td>
									</tr> -->


									<tr ><td colspan=4 style="background-color:#D2B4DE">Sub Parameter Accuracy Process Parameters</td><td colspan=8 style="background-color:#D2B4DE">Sub Parameter Accuracy Customer Parameters</td></tr>
									<tr>
										<td colspan="2"  style="background-color:#D2B4DE">Earned:</td><td id="custJiCisEarned" colspan="2" ></td><td colspan="2"  style="background-color:#D2B4DE">Earned:</td><td id="processJiCisEarned" colspan="6"></td>
									</tr>
									<tr >
										<td colspan="2" style="background-color:#D2B4DE">Possible:</td><td id="custJiCisPossible" colspan="2"></td><td colspan="2" style="background-color:#D2B4DE">Possible:</td><td id="processJiCisPossible" colspan="6"></td>
									</tr>
									<tr style="background-color:#D2B4DE">
										<td colspan="2">Percentage:</td><td colspan="2"><input type="text" readonly style="text-align:center" class="form-control" id="processJiCisScore" name="data[Process_Score]"></td>
										<td colspan="2">Percentage:</td><td colspan="6"><input type="text" readonly style=" text-align:center" class="form-control" id="custJiCisScore" name="data[Customer_Score]"></td>
										
										
									</tr>
									
									


									<tr>
										<td>Call Summary:</td>
										<td colspan=3><textarea class="form-control" id="" name="data[call_summary]"><?php echo $pre_booking['call_summary'] ?></textarea></td>
										<td colspan="2">Remark:</td>
										<td colspan=6><textarea class="form-control" id="" name="data[feedback]"><?php echo $pre_booking['feedback'] ?></textarea></td>
									</tr>
									
									<tr>
										<td>Probability of Booking basis the call:</td>
										<td colspan=3><select class="form-control standard fat" id="fatal8_com" name="data[probability_of]" required>
												
												<option pre_booking_val=1 <?php echo $pre_booking['probability_of']=='High'?"selected":""; ?> value="High">High</option>
												<option pre_booking_val=1 <?php echo $pre_booking['probability_of']=='Mid'?"selected":""; ?> value="Mid">Mid</option>
												<option pre_booking_val=0 <?php echo $pre_booking['probability_of']=='Low'?"selected":""; ?> value="Low">Low</option>
												<option pre_booking_val=0 <?php echo $pre_booking['probability_of']=='Already purchased'?"selected":""; ?> value="Already purchased">Already purchased</option>
											</select></td>
										<td colspan="2">Factors that could impact Booking:</td>
										<td colspan=6><select class="form-control standard" id="fatal8_com" name="data[factors_that_could]" required>
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
										<td colspan="2">Reasons for impact on Booking (WHY 1):</td>
										<td colspan=10><textarea class="form-control" id="" name="data[reasons_for_why1]"><?php echo $pre_booking['reasons_for_why1'] ?></textarea></td>
									</tr>
									<tr>
										<td colspan="2">AOI:</td>
										<td colspan=10><textarea class="form-control" id="aoi_val" name="data[AOI]"><?php echo $pre_booking['AOI'] ?></textarea></td>
									</tr>

									<tr>
										<td colspan="2">Sub AOI:</td>
										<td colspan=10><textarea class="form-control" id="remarks_val" name="data[Sub_AOI]"><?php echo $pre_booking['Sub_AOI'] ?></textarea></td>
									</tr>
									
									<tr>
										<td>Reasons for impact on Booking (WHY 2):</td>
										<td colspan=3><textarea class="form-control" id="" name="data[reasons_for_why2]"><?php echo $pre_booking['reasons_for_why2'] ?></textarea></td>
											<td colspan="2">Overall feel of the call basis Sales Pitch:</td>
										<td colspan=6>
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
										<td colspan=2>Upload Files(wav,wmv,mp3,mp4)</td>
										<td colspan=2><input type="file" multiple class="form-control audioFile" id="attach_file" name="attach_file[]"></td>
										<?php if($pre_booking['attach_file']!=''){ ?>
											<td colspan=2>
												<?php $attach_file = explode(",",$pre_booking['attach_file']);
												 foreach($attach_file as $mp){ ?>
													<audio controls='' style="background-color:#607F93"> 
													  <source src="<?php echo base_url(); ?>qa_files/pre_booking/<?php echo $mp; ?>" type="audio/ogg">
													  <source src="<?php echo base_url(); ?>qa_files/pre_booking/<?php echo $mp; ?>" type="audio/mpeg">
													</audio> </br>
												 <?php } ?>
											</td>
										<?php }else{
												echo '<td colspan=2><b>No Files are uploaded</b></td>';
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