
<style>

.table > tbody > tr > td{
	text-align: center;
	font-size:13px;
}

#theader{
	font-size:20px;
	font-weight:bold;
}

input[type='checkbox']{
	width: 20px;
}
</style>

<?php if($kenny_id!=0){
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
										<td colspan="8" id="theader" style="font-size:30px">Kenny-U-Pull</td>
										<input type="hidden" name="audit_start_time" value="<?php echo CurrMySqlDate(); ?>">
									</tr>
									<tr>
									<?php
										if($kenny_id==0){
											$auditorName = get_username();
											$auditDate = CurrDateMDY();
											$clDate_val='';
										}else{
											if($kenny_u_pull['entry_by']!=''){
												$auditorName = $kenny_u_pull['auditor_name'];
											}else{
												$auditorName = $kenny_u_pull['client_name'];
											}
											$auditDate = mysql2mmddyy($kenny_u_pull['audit_date']);
											$clDate_val=mysql2mmddyy($kenny_u_pull['call_date']);
										}
									?>
										<td>QA Name:</td>
										<td style="width:300px"><input type="text" class="form-control" value="<?php echo $auditorName; ?>" disabled></td>
										<td style="width:150px">Audit Date:</td>
										<td colspan="3"><input type="text" class="form-control" value="<?php echo $auditDate; ?>" disabled></td>
										<td style="width:200px">Call Date:</td>
										<td style="width:400px"><input type="text" class="form-control" id="call_date" name="call_date" value="<?php echo $clDate_val; ?>" required></td>
									</tr>
									<tr>
										<td>Agent:</td>
										<td>
											<select class="form-control" id="agent_id" name="agent_id" required>
												<option value="<?php echo $kenny_u_pull['agent_id'] ?>"><?php echo $kenny_u_pull['fname']." ".$kenny_u_pull['lname'] ?></option>
												<option value="">-Select-</option>
												<?php foreach($agentName as $row):  ?>
													<option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
												<?php endforeach; ?>
											</select>
										</td>
										<td>Fusion ID:</td>
										<td colspan="3"><input type="text" class="form-control" id="fusion_id" name="" value="<?php echo $kenny_u_pull['fusion_id']; ?>" readonly></td>
										<td>L1 Supervisor:</td>
										<td style="width:250px">
											<select class="form-control" id="tl_id" name="tl_id" readonly>
												<option value="<?php echo $kenny_u_pull['tl_id'] ?>"><?php echo $kenny_u_pull['tl_name'] ?></option>
												<option value="">--Select--</option>
												<?php foreach($tlname as $tl): ?>
													<option value="<?php echo $tl['id']; ?>"><?php echo $tl['fname']." ".$tl['lname']; ?></option>
												<?php endforeach; ?>	
											</select>
										</td>
									</tr>
									<tr>
										<td>Call Type:</td>
										<td><input type="text" class="form-control" id="call_type_2words" name="call_type" onkeyup="word_length_limit()" value="<?php echo $kenny_u_pull['call_type']; ?>" required></td>
										<td>case:</td>
										<td><input type="text" class="form-control" id="case" name="case" value="<?php echo $kenny_u_pull['case']; ?>" required>
										</td>
									</tr>
									<tr>
										<td>Audit Type:</td>
										<td>
											<select class="form-control" id="audit_type" name="audit_type" required>
											<option value="">-Select-</option>
											<option <?php echo $kenny_u_pull['audit_type']=='CQ Audit'?"selected":""; ?> value="CQ Audit">CQ Audit</option>
											<option <?php echo $kenny_u_pull['audit_type']=='BQ Audit'?"selected":""; ?> value="BQ Audit">BQ Audit</option>
											<option <?php echo $kenny_u_pull['audit_type']=='Calibration'?"selected":""; ?> value="Calibration">Calibration</option>
											<option <?php echo $kenny_u_pull['audit_type']=='Pre-Certificate Mock Call'?"selected":""; ?> value="Pre-Certificate Mock Call">Pre-Certificate Mock Call</option>
											<option <?php echo $kenny_u_pull['audit_type']=='Certificate Audit'?"selected":""; ?> value="Certificate Audit">Certificate Audit</option>
											</select>
										</td>
										<td class="auType">Auditor Type</td>
										<td class="auType">
											<select class="form-control" id="auditor_type" name="auditor_type">
												<option value="">-Select-</option>
												<option value="Master">Master</option>
												<option value="Regular">Regular</option>
											</select>
										</td>
										<td>VOC:</td>
										<td colspan="3">
											<select class="form-control" id="voc" name="voc" required>
												<option value="">-Select-</option>
												<option <?php echo $kenny_u_pull['voc']=='1'?"selected":""; ?> value="1">1</option>
												<option <?php echo $kenny_u_pull['voc']=='2'?"selected":""; ?> value="2">2</option>
												<option <?php echo $kenny_u_pull['voc']=='3'?"selected":""; ?> value="3">3</option>
												<option <?php echo $kenny_u_pull['voc']=='4'?"selected":""; ?> value="4">4</option>
												<option <?php echo $kenny_u_pull['voc']=='5'?"selected":""; ?> value="5">5</option>
											</select>
										</td>
									</tr>
									<tr>
										<td>Call ID:</td>
										<td><input type="text" class="form-control" id="" name="call_id" value="<?php echo $kenny_u_pull['call_id']; ?>" required></td>
										<td>Call Duration:</td>
										<td colspan="3"><input type="text" class="form-control" id="call_duration" name="call_duration" value="<?php echo $kenny_u_pull['call_duration']; ?>" required></td>
										<td>Site/Location:</td>
										<td><input type="text" class="form-control" id="site_location" name="site_location" value="<?php echo $kenny_u_pull['site_location']; ?>" required>
										</td>
									</td>
									<tr>
										<td style="font-weight:bold">Possible Score:</td>
										<td colspan="2"><input type="text" readonly id="kennyPossibleScore" name="" class="form-control" style="font-weight:bold" ></td>
										<td style="font-weight:bold">Earned Score:</td>
										<td colspan="2"><input type="text" readonly id="kennyEarnedScore" name="" class="form-control" style="font-weight:bold" ></td>
										<td style="font-weight:bold">Overall Score:</td>
										<td colspan="2"><input type="text" readonly id="kennyOverallScore" name="overall_score" class="form-control" style="font-weight:bold" value="<?php echo $kenny_u_pull['overall_score'] ?>"></td>
									</tr>
									<tr style="font-weight:bold; background-color:#3498DB; color:white"><td colspan=8>SOFT SKILLS</td></tr>
									<tr style="font-weight:bold; background-color:#1F618D; color:white">
										<td colspan=3>INTRODUCTION (5%)</td>
										<td>Weightage</td>
										<td>STATUS</td>
										<td colspan=2>REMARKS</td>
										<td>Error Type</td>
									</tr>
									<tr>
										<td><b>Introducing Self</b></td>
										<td colspan=2>Agents must present themselves in a courteous manner mentioning their first name clearly.Agents must name the company (Brand Name)</td>
										<td>2.5</td>
										<td>
											<select class="form-control kennyVal business" id="" name="introducing_self" required>
												<option kenny_val=2.5 <?php echo $kenny_u_pull['introducing_self']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option kenny_val=2.5 <?php echo $kenny_u_pull['introducing_self']=='No'?"selected":""; ?> value="No">No</option>
												<option kenny_val=2.5 <?php echo $kenny_u_pull['introducing_self']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="cmt1" value="<?php echo $kenny_u_pull['cmt1'] ?>" ></td>
										<td>Business</td>
									</tr>
									<tr>
										<td><b>Greets the customer in a courteous manner</b></td>
										<td colspan=2>Demonstrates willingness to help
                                         Use an appropriate flow with scripted opening 
                                        "Welcome to Kenny, my name is Marie, how may I help you?"</td>
										<td>2.5</td>
										<td>
											<select class="form-control kennyVal business" id="" name="greet_customer" required>
												<option kenny_val=2.5 <?php echo $kenny_u_pull['greet_customer']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option kenny_val=2.5 <?php echo $kenny_u_pull['greet_customer']=='No'?"selected":""; ?> value="No">No</option>
												<option kenny_val=2.5 <?php echo $kenny_u_pull['greet_customer']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="cmt2" value="<?php echo $kenny_u_pull['cmt2'] ?>" ></td>
										<td>Business</td>
									</tr>
									<tr style="font-weight:bold; background-color:#1F618D; color:white">
										<td colspan=3>CORE (Probing & Information) (35%)</td>
										<td>Weightage</td>
										<td>STATUS</td>
										<td colspan=2>REMARKS</td>
										<td>Error Type</td>
									</tr>
									<tr>
										<td><b>Is the car complete?</b></td>
										<td colspan=2>Agent must confirm with the customer if the following parts are still present on the vehicle.-Battery-Catalytic converter-Engine-Tires-Transmission</td>
										<td>5</td>
										<td>
											<select class="form-control kennyVal business" id="" name="car_complete" required>
												<option kenny_val=5 <?php echo $kenny_u_pull['car_complete']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option kenny_val=5 <?php echo $kenny_u_pull['car_complete']=='No'?"selected":""; ?> value="No">No</option>
												<option kenny_val=5 <?php echo $kenny_u_pull['car_complete']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="cmt3" value="<?php echo $kenny_u_pull['cmt3'] ?>" ></td>
										<td>Business</td>
									</tr>
									<tr>
										<td><b>The Deductions</b></td>
										<td colspan=2>Agents must inform about the Deductions applicable for Battery not present, tires missing, catalytic converter is not original or missing, or the Engine, Transmission is missing.</td>
										<td>5</td>
										<td>
											<select class="form-control kennyVal business" id="" name="the_deduction" required>
												<option kenny_val=5 <?php echo $kenny_u_pull['the_deduction']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option kenny_val=5 <?php echo $kenny_u_pull['the_deduction']=='No'?"selected":""; ?> value="No">No</option>
												<option kenny_val=5 <?php echo $kenny_u_pull['the_deduction']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="cmt4" value="<?php echo $kenny_u_pull['cmt4'] ?>" ></td>
										<td>Business</td>
									</tr>
									<tr>
										<td><b>Negotiation</b></td>
										<td colspan=2>Negotiation one of the most important parts. The competition is fierce, to stay 1st, we must be fast, precise and convincing.</td>
										<td>15</td>
										<td>
											<select class="form-control kennyVal business" id="" name="negotiation" required>
												<option kenny_val=15 <?php echo $kenny_u_pull['negotiation']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option kenny_val=15 <?php echo $kenny_u_pull['negotiation']=='No'?"selected":""; ?> value="No">No</option>
												<option kenny_val=15 <?php echo $kenny_u_pull['negotiation']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="cmt5" value="<?php echo $kenny_u_pull['cmt5'] ?>" ></td>
										<td>Business</td>
									</tr>
									<tr>
										<td><b>Accessibility – Snow removal (Winter period)</b></td>
										<td colspan=2>Agents must always confirm where the vehicle is;Street, Driveway, Commercial parking, Commercial Garage Ask for the name of the garage as well as the opening hours Alley: Please have the vehicle moved to the driveway or the street Impound: Validate that the invoice is paid before towing</td>
										<td>5</td>
										<td>
											<select class="form-control kennyVal business" id="" name="accessibility" required>
												<option kenny_val=5 <?php echo $kenny_u_pull['accessibility']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option kenny_val=5 <?php echo $kenny_u_pull['accessibility']=='No'?"selected":""; ?> value="No">No</option>
												<option kenny_val=5 <?php echo $kenny_u_pull['accessibility']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="cmt6" value="<?php echo $kenny_u_pull['cmt6'] ?>" ></td>
										<td>Business</td>
									</tr>
									<tr>
										<td><b>Expected Price</b></td>
										<td colspan=2>Agents must always ask the customer for the desired price.</td>
										<td>5</td>
										<td>
											<select class="form-control kennyVal business" id="" name="expected_price" required>
												<option kenny_val=5 <?php echo $kenny_u_pull['expected_price']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option kenny_val=5 <?php echo $kenny_u_pull['expected_price']=='No'?"selected":""; ?> value="No">No</option>
												<option kenny_val=5 <?php echo $kenny_u_pull['expected_price']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="cmt7" value="<?php echo $kenny_u_pull['cmt7'] ?>" ></td>
										<td>Business</td>
									</tr>
									<tr style="font-weight:bold; background-color:#1F618D; color:white">
										<td colspan=3>TECHNICAL PORTION (25%)</td>
										<td>Weightage</td>
										<td>STATUS</td>
										<td colspan=2>REMARKS</td>
										<td>Error Type</td>
									</tr>
									<tr>
										<td><b>Branch Selection</b></td>
										<td colspan=2>Agent need to validate the customer's postal code by searching in Google Maps or Request assistance from senior agents (ssa)</td>
										<td>3.5</td>
										<td>
											<select class="form-control kennyVal business" id="" name="branch_selection" required>
												<option kenny_val=3.5 <?php echo $kenny_u_pull['branch_selection']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option kenny_val=3.5 <?php echo $kenny_u_pull['branch_selection']=='No'?"selected":""; ?> value="No">No</option>
												<option kenny_val=3.5 <?php echo $kenny_u_pull['branch_selection']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="cmt8" value="<?php echo $kenny_u_pull['cmt8'] ?>" ></td>
										<td>Business</td>
									</tr>
									<tr>
										<td><b>Phone Number and Postal Code</b></td>
										<td colspan=2>Agent need to confirm if the customer already has an open file by searching with their phone number.If a draft already exists under the same action (Kenny, Autoscrap etc) Agent must work from the draft</td>
										<td>3.5</td>
										<td>
											<select class="form-control kennyVal compliancee" id="" name="postal_card" required>
												<option kenny_val=3.5 <?php echo $kenny_u_pull['postal_card']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option kenny_val=3.5 <?php echo $kenny_u_pull['postal_card']=='No'?"selected":""; ?> value="No">No</option>
												<option kenny_val=3.5 <?php echo $kenny_u_pull['postal_card']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="cmt9" value="<?php echo $kenny_u_pull['cmt9'] ?>" ></td>
										<td>Compliance</td>
									</tr>
									<tr>
										<td style="color:red"><b>File opening</b></td>
										<td style="color:red" colspan=2>If there is no file or it is under a different company, agent must open a new file with Phone Number & Postal Code *ALL FILES MUST BE OPEN OR CAN RESULT IN A DISCIPLINARY ACTION* *NONE OF THE FILES SHOULD BE DELETED AT ANY CIRCUMSTANCES* *WE MUST BE ABLE TO FIND THE FILES*</td>
										<td>3.5</td>
										<td>
											<select class="form-control kennyVal business" id="file_opening" name="file_opening" required>
												<option kenny_val=3.5 <?php echo $kenny_u_pull['file_opening']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option kenny_val=3.5 <?php echo $kenny_u_pull['file_opening']=='No'?"selected":""; ?> value="No">No</option>
												<option kenny_val=3.5 <?php echo $kenny_u_pull['file_opening']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="cmt10" value="<?php echo $kenny_u_pull['cmt10'] ?>" ></td>
										<td>Business</td>
									</tr>
									<tr>
										<td><b>Vehicle identification Number(NIV – VIN)</b></td>
										<td colspan=2>This is essential to avoid buying a vehicle that still has debts. The VIN request must be made via the Teams Photo and VIN Channel • Agent must always provide the province • The confirmation must be attached to Odoo.</td>
										<td>1.5</td>
										<td>
											<select class="form-control kennyVal business" id="vehicle_identification" name="vehicle_identification" required>
												<option kenny_val=1.5 <?php echo $kenny_u_pull['vehicle_identification']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option kenny_val=1.5 <?php echo $kenny_u_pull['vehicle_identification']=='No'?"selected":""; ?> value="No">No</option>
												<option kenny_val=1.5 <?php echo $kenny_u_pull['vehicle_identification']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="cmt11" value="<?php echo $kenny_u_pull['cmt11'] ?>" ></td>
										<td>Business</td>
									</tr>
									<tr>
										<td><b>Mileage</b></td>
										<td colspan=2>The mileage is a very important indicato. Agent must probe to confirm the exact mileage.</td>
										<td>1.5</td>
										<td>
											<select class="form-control kennyVal business" id="mileage" name="mileage" required>
												<option kenny_val=1.5 <?php echo $kenny_u_pull['mileage']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option kenny_val=1.5 <?php echo $kenny_u_pull['mileage']=='No'?"selected":""; ?> value="No">No</option>
												<option kenny_val=1.5 <?php echo $kenny_u_pull['mileage']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="cmt12" value="<?php echo $kenny_u_pull['cmt12'] ?>" ></td>
										<td>Business</td>
									</tr>
									<tr>
										<td><b>Aesthetic Conditions</b></td>
										<td colspan=2>The aesthetic condition helps us to have a clear image of the vehicle. Agent must confirm the below condtions before buying it? • Is the car rusted? • Has the car been in an accident?</td>
										<td>3.5</td>
										<td>
											<select class="form-control kennyVal business" id="aesthetic_conditions" name="aesthetic_conditions" required>
												<option kenny_val=3.5 <?php echo $kenny_u_pull['aesthetic_conditions']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option kenny_val=3.5 <?php echo $kenny_u_pull['aesthetic_conditions']=='No'?"selected":""; ?> value="No">No</option>
												<option kenny_val=3.5 <?php echo $kenny_u_pull['aesthetic_conditions']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="cmt13" value="<?php echo $kenny_u_pull['cmt13'] ?>" ></td>
										<td>Business</td>
									</tr>
									<tr>
										<td><b>Mechanical Condition</b></td>
										<td colspan=2>It is important to ask open-ended questions, this will compel the client to provide 
										information. Agents must have as much information as possible to have a clear picture that will be 
										of great help during the negotiation.
										• Does it start?
										• Does it move forward and backward?</td>
										<td>3.5</td>
										<td>
											<select class="form-control kennyVal business" id="mechanical_condition" name="mechanical_condition" required>
												<option kenny_val=3.5 <?php echo $kenny_u_pull['mechanical_condition']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option kenny_val=3.5 <?php echo $kenny_u_pull['mechanical_condition']=='No'?"selected":""; ?> value="No">No</option>
												<option kenny_val=3.5 <?php echo $kenny_u_pull['mechanical_condition']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="cmt14" value="<?php echo $kenny_u_pull['cmt14'] ?>" ></td>
										<td>Business</td>
									</tr>
									<tr>
										<td><b>Towing Address</b></td>
										<td colspan=2>When scheduling the towing, it is important to confirm the address at which we must pick up the vehicle</td>
										<td>3.5</td>
										<td>
											<select class="form-control kennyVal business" id="towing_address" name="towing_address" required>
												<option kenny_val=3.5 <?php echo $kenny_u_pull['towing_address']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option kenny_val=3.5 <?php echo $kenny_u_pull['towing_address']=='No'?"selected":""; ?> value="No">No</option>
												<option kenny_val=3.5 <?php echo $kenny_u_pull['towing_address']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="cmt15" value="<?php echo $kenny_u_pull['cmt15'] ?>" ></td>
										<td>Business</td>
									</tr>
									<tr>
										<td><b>Customer Drops off his Vehicle (Drop-Off)</b></td>
										<td colspan=2>If the customer insists on dropping off his vehicle, it is extremely important to enter a date. 
										The majority do not drop off the vehicle, so we want to give a sense of importance. Create 
										the expectation that we have made an appointment and are waiting for the customer in 
										the branch.
										Example: Mr. Customer, what date and time do you plan to drop off your vehicle on?
										The cashier will be waiting for you with the sum of …. $
										I can guarantee the price until tomorrow 4 p.m.
										It is important to respect the date and time in order to guarantee the price of …$</td>
										<td>1</td>
										<td>
											<select class="form-control kennyVal business" id="drop_off" name="drop_off" required>
												<option kenny_val=1 <?php echo $kenny_u_pull['drop_off']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option kenny_val=1 <?php echo $kenny_u_pull['drop_off']=='No'?"selected":""; ?> value="No">No</option>
												<option kenny_val=1 <?php echo $kenny_u_pull['drop_off']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="cmt16" value="<?php echo $kenny_u_pull['cmt16'] ?>" ></td>
										<td>Business</td>
									</tr>
									<tr style="font-weight:bold; background-color:#1F618D; color:white">
										<td colspan=3>CSAT (Customer Experience - START TO FINISH) (5%)</td>
										<td>Weightage</td>
										<td>STATUS</td>
										<td colspan=2>REMARKS</td>
										<td>Error Type</td>
									</tr>
									<tr>
										<td><b>Active Listening</b></td>
										<td colspan=2>• Agent does not make the customer repeat unnecessarily.
										• Agents Asks questions to deepen the need or confirm the information.</td>
										<td>1</td>
										<td>
											<select class="form-control kennyVal customer" id="active_listening" name="active_listening" required>
												<option kenny_val=1 <?php echo $kenny_u_pull['active_listening']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option kenny_val=1 <?php echo $kenny_u_pull['active_listening']=='No'?"selected":""; ?> value="No">No</option>
												<option kenny_val=1 <?php echo $kenny_u_pull['active_listening']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="cmt17" value="<?php echo $kenny_u_pull['cmt17'] ?>" ></td>
										<td>Customer</td>
									</tr>
									<tr>
										<td><b>Interruption</b></td>
										<td colspan=2>• Agent does not interrupt the client.
										• Agent must not speak at the same time as the customer.</td>
										<td>1</td>
										<td>
											<select class="form-control kennyVal customer" id="interruption" name="interruption" required>
												<option kenny_val=1 <?php echo $kenny_u_pull['interruption']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option kenny_val=1 <?php echo $kenny_u_pull['interruption']=='No'?"selected":""; ?> value="No">No</option>
												<option kenny_val=1 <?php echo $kenny_u_pull['interruption']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="cmt18" value="<?php echo $kenny_u_pull['cmt18'] ?>" ></td>
										<td>Customer</td>
									</tr>
									<tr>
										<td><b>Tone of Voice (from greeting to closing)</b></td>
										<td colspan=2>Agent must :
										• Adopt a warm and friendly tone. This allows her voice to always convey an engaging smile.
										• Use a confident tone;
										• Uses a regular flow, which allows the client to understand the speech and to have a steady pace.
										• Adjust the tone of your voice to avoid sounding monotone.
										**Lack of courtesy to a customer will not be tolerated and will result in a 0% rating**</td>
										<td>1</td>
										<td>
											<select class="form-control kennyVal customer" id="tone_voice" name="tone_voice" required>
												<option kenny_val=1 <?php echo $kenny_u_pull['tone_voice']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option kenny_val=1 <?php echo $kenny_u_pull['tone_voice']=='No'?"selected":""; ?> value="No">No</option>
												<option kenny_val=1 <?php echo $kenny_u_pull['tone_voice']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="cmt19" value="<?php echo $kenny_u_pull['cmt19'] ?>" ></td>
										<td>Customer</td>
									</tr>
									<tr>
										<td><b>Hold & Dead air</b></td>
										<td colspan=2>Agent must follow the below hold procedure as using mute is not allowed :
										• Get the OK from the customer to be placed on hold
										• Inform the client of what will be done during the waiting period.
										• Thank the customer for their patience when they return from the hold.
										• If the hold is longer than expected, return to the customer within 2 minutes, explaining the 
										reason</td>
										<td>1</td>
										<td>
											<select class="form-control kennyVal customer" id="dead_air" name="dead_air" required>
												<option kenny_val=1 <?php echo $kenny_u_pull['dead_air']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option kenny_val=1 <?php echo $kenny_u_pull['dead_air']=='No'?"selected":""; ?> value="No">No</option>
												<option kenny_val=1 <?php echo $kenny_u_pull['dead_air']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="cmt20" value="<?php echo $kenny_u_pull['cmt20'] ?>" ></td>
										<td>Customer</td>
									</tr>
									<tr>
										<td><b>Ending the call</b></td>
										<td colspan=2>Agent must close the call by following the below mentioned way 
										• Use a polite and a warm tone.
										• Thank the customer for choosing Kenny, Autoscrap etc…</td>
										<td>1</td>
										<td>
											<select class="form-control kennyVal business" id="ending_call" name="ending_call" required>
												<option kenny_val=1 <?php echo $kenny_u_pull['ending_call']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option kenny_val=1 <?php echo $kenny_u_pull['ending_call']=='No'?"selected":""; ?> value="No">No</option>
												<option kenny_val=1 <?php echo $kenny_u_pull['ending_call']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="cmt21" value="<?php echo $kenny_u_pull['cmt21'] ?>" ></td>
										<td>Business</td>
									</tr>
									<tr style="font-weight:bold; background-color:#1F618D; color:white">
										<td colspan=3>CONCLUSION (RECAP) (20%)</td>
										<td>Weightage</td>
										<td style="width: 150px;">STATUS</td>
										<td colspan=2>REMARKS</td>
										<td>Error Type</td>
									</tr>
									<tr>
										<td><b>Confirmation Phone Number</b></td>
										<td colspan=2>Agents must confirm the number on file and ask if the client wishes to provide a second one
										• If we made a mistake, agents could correct it.</td>
										<td>5</td>
										<td>
											<select class="form-control kennyVal business" id="confirm_phone" name="confirm_phone" required>
												<option kenny_val=5 <?php echo $kenny_u_pull['confirm_phone']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option kenny_val=5 <?php echo $kenny_u_pull['confirm_phone']=='No'?"selected":""; ?> value="No">No</option>
												<option kenny_val=5 <?php echo $kenny_u_pull['confirm_phone']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="cmt22" value="<?php echo $kenny_u_pull['cmt22'] ?>" ></td>
										<td>Business</td>
									</tr>
									<tr>
										<td><b>Address Confirmation</b></td>
										<td colspan=2>Agents must confirm towing address
										• If we made a mistake, agents could correct it</td>
										<td>5</td>
										<td>
											<select class="form-control kennyVal business" id="confirm_address" name="confirm_address" required>
												<option kenny_val=5 <?php echo $kenny_u_pull['confirm_address']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option kenny_val=5 <?php echo $kenny_u_pull['confirm_address']=='No'?"selected":""; ?> value="No">No</option>
												<option kenny_val=5 <?php echo $kenny_u_pull['confirm_address']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="cmt23" value="<?php echo $kenny_u_pull['cmt23'] ?>" ></td>
										<td>Business</td>
									</tr>
									<tr>
										<td><b> Confirmation of the tow date/time</b></td>
										<td colspan=2> Before the end of the call, agents must confirm with the customer the date and time of the towing.
										We cannot confirm a specific time
										Odoo and Dispatch calendar should be same</td>
										<td>5</td>
										<td>
											<select class="form-control kennyVal business" id="confirm_date_time" name="confirm_date_time" required>
												<option kenny_val=5 <?php echo $kenny_u_pull['confirm_date_time']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option kenny_val=5 <?php echo $kenny_u_pull['confirm_date_time']=='No'?"selected":""; ?> value="No">No</option>
												<option kenny_val=5 <?php echo $kenny_u_pull['confirm_date_time']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="cmt24" value="<?php echo $kenny_u_pull['cmt24'] ?>" ></td>
										<td>Business</td>
									</tr>
									<tr>
										<td><b>Process after purchase</b></td>
										<td colspan=2>Cash payment,A.T.A.C (Québec only) et Transferts,Power of attorney (if needed – Québec only),Personal Items and License Plate,Keys and registration papers (registrations)</td>
										<td>5</td>
										<td>
											<select class="form-control kennyVal business" id="purchase_process" name="purchase_process" required>
												<option kenny_val=5 <?php echo $kenny_u_pull['purchase_process']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option kenny_val=5 <?php echo $kenny_u_pull['purchase_process']=='No'?"selected":""; ?> value="No">No</option>
												<option kenny_val=5 <?php echo $kenny_u_pull['purchase_process']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="cmt25" value="<?php echo $kenny_u_pull['cmt25'] ?>" ></td>
										<td>Business</td>
									</tr>
									<tr style="font-weight:bold; background-color:#1F618D; color:white">
										<td colspan=3>PROCEDURE (10%)</td>
										<td>Weightage</td>
										<td>STATUS</td>
										<td colspan=2>REMARKS</td>
										<td>Error Type</td>
									</tr>
									<tr>
										<td><b>Process Adherence</b></td>
										<td colspan=2>This portion refers to the procedures to follow. Depending on the severity of the missed 
										opportunity,</td>
										<td>10</td>
										<td>
											<select class="form-control kennyVal customer" id="" name="adherence_process" required>
												<option kenny_val=10 <?php echo $kenny_u_pull['adherence_process']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option kenny_val=10 <?php echo $kenny_u_pull['adherence_process']=='No'?"selected":""; ?> value="No">No</option>
												<option kenny_val=10 <?php echo $kenny_u_pull['adherence_process']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="cmt26" value="<?php echo $kenny_u_pull['cmt26'] ?>" ></td>
										<td>Customer</td>
									</tr>

									<tr style="font-weight:bold; background-color:#1F618D; color:white">
										<td colspan=3>ZTP</td>
										<td>Weightage</td>
										<td>STATUS</td>
										<td colspan=2>REMARKS</td>
										<td>Error Type</td>
									</tr>
									<tr>
										<td style="color:red"><b>Rude Remarks</b></td>
										<td colspan=2>Rude/Impolite behavior, Inappropriate tone or language, being sarcastic.</td>
										<td></td>
										<td>
											<select class="form-control kennyVal" id="kenny_AF1" name="rude_behaviour" required>
												<option kenny_val=0 <?php echo $kenny_u_pull['rude_behaviour']=='No'?"selected":""; ?> value="No">No</option>
												<option kenny_val=0 <?php echo $kenny_u_pull['rude_behaviour']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="cmt27" value="<?php echo $kenny_u_pull['cmt27'] ?>" ></td>
										<td>Customer</td>
									</tr>
									<tr>
										<td style="color:red"><b>Call Avoidance</b></td>
										<td colspan=2>Agent disconnecting call while the customer was there (Invalid call disconnection)</td>
										<td></td>
										<td>
											<select class="form-control kennyVal" id="kenny_AF2" name="call_avoidance" required>
												<option kenny_val=0 <?php echo $kenny_u_pull['call_avoidance']=='No'?"selected":""; ?> value="No">No</option>
												<option kenny_val=0 <?php echo $kenny_u_pull['call_avoidance']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" name="cmt28" value="<?php echo $kenny_u_pull['cmt28'] ?>" ></td>
										<td>Customer</td>
									</tr>

									<tr style="background-color:#D2B4DE"><td colspan=3>Customer Score</td><td colspan=3>Business Score</td><td colspan=3>Compliance Score</td></tr>
									<tr style="background-color:#D2B4DE">
										<td>Earned:</td><td id="custSenEarned" colspan="2"></td><td>Earned:</td><td id="busiSenEarned" colspan="2"></td><td>Earned:</td><td id="complSenEarned" colspan="2"></td>
									</tr>
									<tr style="background-color:#D2B4DE">
										<td>Possible:</td><td id="custSenPossible" colspan="2"></td><td>Possible:</td><td id="busiSenPossible" colspan="2"></td><td>Possible:</td><td id="complSenPossible" colspan="2"></td>
									</tr>
									<tr style="background-color:#D2B4DE">
										<td>Percentage:</td><td colspan="2"><input type="text" readonly style="background-color:#D2B4DE; text-align:center" class="form-control" id="custSenScore" name="customer_score" value="<?php echo $kenny_u_pull['customer_score'] ?>"></td>
										<td>Percentage:</td><td colspan="2"><input type="text" readonly style="background-color:#D2B4DE; text-align:center" class="form-control" id="busiSenScore" name="business_score" value="<?php echo $kenny_u_pull['business_score'] ?>"></td>
										<td>Percentage:</td><td colspan="2"><input type="text" readonly style="background-color:#D2B4DE; text-align:center" class="form-control" id="complSenScore" name="compliance_score" value="<?php echo $kenny_u_pull['compliance_score'] ?>"></td>
									</tr>


									<tr>
										<td>Call Summary:</td>
										<td colspan=3><textarea class="form-control" id="" name="call_summary"><?php echo $kenny_u_pull['call_summary'] ?></textarea></td>
										<td>Feedback:</td>
										<td colspan=3><textarea class="form-control" id="" name="feedback"><?php echo $kenny_u_pull['feedback'] ?></textarea></td>
									</tr>
									<tr>
										<td colspan="2">Upload Files</td>
										<?php if($kenny_id==0){ ?>
											<td colspan=6><input type="file" multiple class="form-control" id="attach_file" name="attach_file[]"></td>
										<?php }else{ 
											if($kenny_u_pull['attach_file']!=''){ ?>
											<td colspan="6">
												<?php $attach_file = explode(",",$kenny_u_pull['attach_file']);
												 foreach($attach_file as $mp){ ?>
													<audio controls='' style="background-color:#607F93"> 
													  <source src="<?php echo base_url(); ?>qa_files/qa_kenny_u_pull/<?php echo $mp; ?>" type="audio/ogg">
													  <source src="<?php echo base_url(); ?>qa_files/qa_kenny_u_pull/<?php echo $mp; ?>" type="audio/mpeg">
													</audio> </br>
												 <?php } ?>
											</td>
										<?php }else{
												echo '<td><b>No Files</b></td>';
											  }
										} ?>
									</tr>
										
									<?php if($kenny_id!=0){ ?>
										<tr><td colspan=3 style="font-size:16px; font-weight:bold">Agent Review:</td><td colspan=4><?php echo $kenny_u_pull['agent_rvw_note'] ?></td></tr>
										<tr><td colspan=3 style="font-size:16px; font-weight:bold">Management Review:</td><td colspan=4><?php echo $kenny_u_pull['mgnt_rvw_note'] ?></td></tr>
										<tr><td colspan=3 style="font-size:16px; font-weight:bold">Client Review:</td><td colspan=4><?php echo $kenny_u_pull['client_rvw_note'] ?></td></tr>
										
										<tr><td colspan=3  style="font-size:16px">Your Review</td><td colspan=4><textarea class="form-control1" style="width:100%" id="note" name="note" required></textarea></td></tr>
									<?php } ?>
										
									<?php 
									if($kenny_id==0){
										if(is_access_qa_module()==true || is_access_qa_operations_module()==true){ ?>
											<tr><td colspan=8><button class="btn btn-success waves-effect" type="submit" id="qaformsubmit" style="width:500px">SAVE</button></td></tr>
									<?php 
										} 
									}else{ 
										if(is_access_qa_module()==true || is_access_qa_operations_module()==true){
											if(is_available_qa_feedback($kenny_u_pull['entry_date'],72) == true){ ?>
												<tr><td colspan="8"><button class="btn btn-success waves-effect" type="submit" id='qaformsubmit' name='btnSave' value="SAVE" style="width:500px">SAVE</button></td></tr>
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


<script type="text/javascript">
	function word_length_limit(){
		var word = $("#call_type_2words").val();
		var wordcnt = word.split(" ");
		var wordcnt_length = wordcnt.length;
		if(wordcnt_length>2){
			alert("Maximun of 2 words");
			$("#call_type_2words").val("");
		}
	}
</script>
