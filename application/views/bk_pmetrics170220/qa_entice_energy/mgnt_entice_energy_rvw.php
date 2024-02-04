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
	background-color:#F5CBA7;
}

.eml1{
	font-weight:bold;
	background-color:#E5E8E8;
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
										<td colspan=8 id="theader" style="font-size:30px">Entice Energy Scorecard
										<input type="hidden" name="pnid" value="<?php echo $pnid; ?>">
										</td>
									</tr>
									
									<tr>
										<td>QA Name:</td>
										<td colspan=2><input type="text" class="form-control" value="<?php echo $enticeEnergy['auditor_name']; ?>" disabled></td>
										<td>Audit Date:</td>
										<td colspan=2><input type="text" class="form-control" value="<?php echo mysql2mmddyy($enticeEnergy['audit_date']); ?>" disabled></td>
										<td>Call Date:</td>
										<td><input type="text" class="form-control" id="call_date" name="call_date" value="<?php echo mysql2mmddyy($enticeEnergy['call_date']); ?>" required></td>
									</tr>
									<tr>
										<td>Agent:</td>
										<td colspan=3>
											<select class="form-control" id="agent_id" name="agent_id" required>
												<option value="<?php echo $enticeEnergy['agent_id'] ?>"><?php echo $enticeEnergy['fname']." ".$enticeEnergy['lname'] ?></option>
												<option value="">-Select-</option>
												<?php foreach($agentName as $row):  ?>
													<option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
												<?php endforeach; ?>
											</select>
										</td>
										<!--<td>Fusion ID:</td>
										<td><input type="text" readonly class="form-control" id="fusion_id" name="" value="<?php //echo $enticeEnergy['fusion_id'] ?>"></td> -->
										<td>L1 Supervisor:</td>
										<td colspan=3>
											<select class="form-control" id="tl_id" name="tl_id" readonly>
												<option value="<?php echo $enticeEnergy['tl_id'] ?>"><?php echo $enticeEnergy['tl_name'] ?></option>
												<option value="">--Select--</option>
												<?php foreach($tlname as $tl): ?>
													<option value="<?php echo $tl['id']; ?>"><?php echo $tl['fname']." ".$tl['lname']; ?></option>
												<?php endforeach; ?>	
											</select>
										</td>
									</tr>
									<tr>
										<td>Customer Name:</td>
										<td colspan=2><input type="text" class="form-control" id="" name="customer_name" value="<?php echo $enticeEnergy['customer_name'] ?>" required></td>
										<td>Week ending Date:</td>
										<td><input type="text" class="form-control" id="week_end_date" name="week_end_date" value="<?php echo mysql2mmddyy($enticeEnergy['week_end_date']) ?>" required></td>
										<td>Type Of Call:</td>
										<td colspan=2>
											<select class="form-control" id="" name="call_type" required>
												<option value="<?php echo $enticeEnergy['call_type'] ?>"><?php echo $enticeEnergy['call_type'] ?></option>
												<option value="">Select</option>
												<option value="G&E Sale Only">G&E Sale Only</option>
												<option value="Non-Sale">Non-Sale</option>
												<option value="Complaint">Complaint</option>
												<option value="Televerification">Televerification</option>
												<option value="Cancellation">Cancellation</option>
												<option value="Retention/Product Change">Retention/Product Change</option>
												<option value="Retention/Upsell">Retention/Upsell</option>
												<option value="G&E Sale incl D&G Boiler Care">G&E Sale incl D&G Boiler Care</option>
												<option value="D&G Boiler Care">D&G Boiler Care</option>
												<option value="D&G Appliance Care">D&G Appliance Care</option>
												<option value="G&E Sale incl D&G Boiler Care & Appliance Care">G&E Sale incl D&G Boiler Care & Appliance Care</option>
												<option value="G&E Sale incl D&G Appliance Care">G&E Sale incl D&G Appliance Care</option>
											</select>
										</td>
									</tr>
									<tr>
										<td>Customer Contact Number:</td>
										<td colspan=2><input type="text" class="form-control" id="customer_phone" name="customer_phone" onkeyup="checkDec(this);" value="<?php echo $enticeEnergy['customer_phone'] ?>" required></td>
									</tr>
									<tr>
										<td>Audit Type:</td>
										<td colspan=2>
											<select class="form-control" id="audit_type" name="audit_type" required>
												<option value="<?php echo $enticeEnergy['audit_type'] ?>"><?php echo $enticeEnergy['audit_type'] ?></option>
												<option value="">-Select-</option>
												<option value="CQ Audit">CQ Audit</option>
												<option value="BQ Audit">BQ Audit</option>
												<option value="Calibration">Calibration</option>
												<option value="Client Request Audit">Client Request Audit</option>
											</select>
										</td>
										<td class="auType">Auditor Type</td>
										<td colspan=2 class="auType">
											<select class="form-control" id="auditor_type" name="auditor_type">
												<option value="">-Select-</option>
												<option <?php echo $enticeEnergy['auditor_type']=='Master'?"selected":""; ?> value="Master">Master</option>
												<option <?php echo $enticeEnergy['auditor_type']=='Regular'?"selected":""; ?> value="Regular">Regular</option>
											</select>
										</td>
										<td>VOC:</td>
										<td>
											<select class="form-control" id="voc" name="voc" required>
												<option value="<?php echo $enticeEnergy['voc'] ?>"><?php echo $enticeEnergy['voc'] ?></option>
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
										<td style="font-weight:bold; font-size:16px; text-align:right">Earned Score:</td>
										<td><input type="text" readonly id="ee_earned_score" name="earned_score" class="form-control" style="font-weight:bold" value="<?php echo $enticeEnergy['earned_score'] ?>"></td>
										<td style="font-weight:bold; font-size:16px; text-align:right">Possible Score:</td>
										<td><input type="text" readonly id="ee_possible_score" name="possible_score" class="form-control" style="font-weight:bold" value="<?php echo $enticeEnergy['possible_score'] ?>"></td>
										<td style="font-weight:bold; font-size:16px; text-align:right">Overall Score:</td>
										<td><input type="text" readonly id="ee_overall_score" name="overall_score" class="form-control" style="font-weight:bold" value="<?php echo $enticeEnergy['overall_score'] ?>"></td>
									</tr>
									
									<tr><td colspan=8 style="font-weight:bold; font-size:20px; background-color:#5DADE2">Introduction</td></tr>
									<tr>
										<td>A1</td>
										<td colspan=2>Agent states name, representing Entice Energy, reason for call stated & customer advised of call recording</td>
										<td>4</td>
										<td>
											<select class="form-control ee_points" id="" name="agentstatesname" required>
												<option value="">-Select-</option>
												<option ee_val=4 <?php echo $enticeEnergy['agentstatesname']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option ee_val=4 <?php echo $enticeEnergy['agentstatesname']=='No'?"selected":""; ?> value="No">No</option>
												<option ee_val=0 <?php echo $enticeEnergy['agentstatesname']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=3>Call recording must be advised within first 3 minutes of the call</td>
									</tr>
									
									<tr>
										<td>A2</td>
										<td colspan=2>Confirmation that speaking to DMC and Over the age of 18. Homeowner Question asked?</td>
										<td>4</td>
										<td>
											<select class="form-control ee_points" id="" name="cofirmspeakingtoDMC" required>
												<option value="">-Select-</option>
												<option ee_val=4 <?php echo $enticeEnergy['cofirmspeakingtoDMC']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option ee_val=4 <?php echo $enticeEnergy['cofirmspeakingtoDMC']=='No'?"selected":""; ?> value="No">No</option>
												<option ee_val=0 <?php echo $enticeEnergy['cofirmspeakingtoDMC']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=3>Agent to confirm they are speaking with the bill payer</td>
									</tr>
									<tr>
										<td>A3</td>
										<td colspan=2>Golden Account details confirmed- Customers full name, DOB, Email (phonetics used to confirm) Address, and phone number confirmed</td>
										<td>4</td>
										<td>
											<select class="form-control ee_points" id="" name="goldenaccountdetails" required>
												<option value="">-Select-</option>
												<option ee_val=4 <?php echo $enticeEnergy['goldenaccountdetails']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option ee_val=4 <?php echo $enticeEnergy['goldenaccountdetails']=='No'?"selected":""; ?> value="No">No</option>
												<option ee_val=0 <?php echo $enticeEnergy['goldenaccountdetails']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=3>Phonetics used to capture email address. Customer must confirm best contact number and alternitive number (day/evening), DOB and full name</td>
									</tr>
									<tr>
										<td>A4</td>
										<td colspan=2>Customer to provide first line and post code of their address (agent confirms)</td>
										<td>4</td>
										<td>
											<select class="form-control ee_points" id="" name="customerprovide1stline" required>
												<option value="">-Select-</option>
												<option ee_val=4 <?php echo $enticeEnergy['customerprovide1stline']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option ee_val=4 <?php echo $enticeEnergy['customerprovide1stline']=='No'?"selected":""; ?> value="No">No</option>
												<option ee_val=0 <?php echo $enticeEnergy['customerprovide1stline']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=3>Customer must provide this information to agent</td>
									</tr>
									<tr><td colspan=8 style="font-weight:bold; font-size:20px; background-color:#5DADE2">Customers Current Usage Details</td></tr>
									<tr>
										<td>B1</td>
										<td colspan=2>Did agent ask if customer takes part in the WHD and advise accordingly (4) Was the Winter Uplift advised to the customer (anyone joining in September)</td>
										<td>3</td>
										<td>
											<select class="form-control ee_points" id="" name="customertakepartinWHD" required>
												<option value="">-Select-</option>
												<option ee_val=3 <?php echo $enticeEnergy['customertakepartinWHD']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option ee_val=3 <?php echo $enticeEnergy['customertakepartinWHD']=='No'?"selected":""; ?> value="No">No</option>
												<option ee_val=0 <?php echo $enticeEnergy['customertakepartinWHD']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=3>Warm Home Discount - £140 from Government for people who claim certain benefits</td>
									</tr>
									<tr>
										<td>B2</td>
										<td colspan=2>Confirm Single/ Duel Fuel & select correct supplier? (4)</td>
										<td>3</td>
										<td>
											<select class="form-control ee_points" id="" name="confirmsigleduelFuel" required>
												<option value="">-Select-</option>
												<option ee_val=3 <?php echo $enticeEnergy['confirmsigleduelFuel']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option ee_val=3 <?php echo $enticeEnergy['confirmsigleduelFuel']=='No'?"selected":""; ?> value="No">No</option>
												<option ee_val=0 <?php echo $enticeEnergy['confirmsigleduelFuel']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=3>Current supplier confirmed. Dual or single tariff?</td>
									</tr>
									<tr>
										<td>B3</td>
										<td colspan=2>Tariff probed 3 times- if customer unaware of tariff- agent makes it clear they are basing on a standard tariff and customer confirms happy to proceed</td>
										<td>3</td>
										<td>
											<select class="form-control ee_points" id="" name="tariffprobed3times" required>
												<option value="">-Select-</option>
												<option ee_val=3 <?php echo $enticeEnergy['tariffprobed3times']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option ee_val=3 <?php echo $enticeEnergy['tariffprobed3times']=='No'?"selected":""; ?> value="No">No</option>
												<option ee_val=0 <?php echo $enticeEnergy['tariffprobed3times']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=3>If a customer does not have a bill we must probe their tariff 3 times. Start date? End date? Any benefits? If customer still unsure base it on a standard tariff but the customer must confirm they are happy for you to do so</td>
									</tr>
									<tr>
										<td>B4</td>
										<td colspan=2>Have you asked sufficient questions to accurately complete the comparison for the person? 1. Ask for a bill with the annual consumption (if this is not available go to option 2) 2. Comparison based on customers spend. Agent asks about the 60% - 40% split and confirms this with the customer</td>
										<td>3</td>
										<td>
											<select class="form-control ee_points" id="" name="askedsufficientquestion" required>
												<option value="">-Select-</option>
												<option ee_val=3 <?php echo $enticeEnergy['askedsufficientquestion']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option ee_val=3 <?php echo $enticeEnergy['askedsufficientquestion']=='No'?"selected":""; ?> value="No">No</option>
												<option ee_val=0 <?php echo $enticeEnergy['askedsufficientquestion']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=3>1. Agent must ask the customer for a bill with their current annual consumption in KWH (preferred and best way to complete comparison) 2. If no bill - agent can ask the customers current spend. Agent to ask which fuel they use more of G or E? 60%/40% split 3. If customer has no bill or doesn't know how much they spend or if they have recently moved - agent can use the ready reckoner</td>
									</tr>
									<tr>
										<td>B5</td>
										<td colspan=2>Does the customer have a Smart Meter? Loss of functionality advised. Agent can not promise this to a customer</td>
										<td>3</td>
										<td>
											<select class="form-control ee_points" id="" name="customerhaveSmartmeter" required>
												<option value="">-Select-</option>
												<option ee_val=3 <?php echo $enticeEnergy['customerhaveSmartmeter']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option ee_val=3 <?php echo $enticeEnergy['customerhaveSmartmeter']=='No'?"selected":""; ?> value="No">No</option>
												<option ee_val=0 <?php echo $enticeEnergy['customerhaveSmartmeter']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=3>If customer has a smart meter, agent must advise of loss of functionality on the smart meter</td>
									</tr>
									<tr>
										<td>B6</td>
										<td colspan=2>Economy 7 checked and caller advised correctly?</td>
										<td>3</td>
										<td>
											<select class="form-control ee_points" id="" name="economy7checked" required>
												<option value="">-Select-</option>
												<option ee_val=3 <?php echo $enticeEnergy['economy7checked']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option ee_val=3 <?php echo $enticeEnergy['economy7checked']=='No'?"selected":""; ?> value="No">No</option>
												<option ee_val=0 <?php echo $enticeEnergy['economy7checked']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=3>Agent to ask if customer has E7 - if customer unsure agent to probe - Cheaper rate of electric in the evening? Any storage heaters? If customer still unsure agent to select No. When selecting address at the end of the call if the property shows there is Economy 7 agent must re run comparison</td>
									</tr>
									<tr>
										<td>B7</td>
										<td colspan=2>Confirm if customer has any debt and advised accordingly?</td>
										<td>3</td>
										<td>
											<select class="form-control ee_points" id="" name="customerhasanydebt" required>
												<option value="">-Select-</option>
												<option ee_val=3 <?php echo $enticeEnergy['customerhasanydebt']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option ee_val=3 <?php echo $enticeEnergy['customerhasanydebt']=='No'?"selected":""; ?> value="No">No</option>
												<option ee_val=0 <?php echo $enticeEnergy['customerhasanydebt']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=3>Ask customer if there is any debt - if there is, this will need to be cleared within 3 weeks. If customer unable to do so agent to advise they can not proceed as it will be rejected by their supplier</td>
									</tr>
									<tr><td colspan=8 style="font-weight:bold; font-size:20px; background-color:#5DADE2">Tariff Information</td></tr>
									<tr>
										<td>C1</td>
										<td colspan=2>Did agent give Entice Energy's best tariff and savings?</td>
										<td>3</td>
										<td>
											<select class="form-control ee_points" id="" name="agentgavebesttariff" required>
												<option value="">-Select-</option>
												<option ee_val=3 <?php echo $enticeEnergy['agentgavebesttariff']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option ee_val=3 <?php echo $enticeEnergy['agentgavebesttariff']=='No'?"selected":""; ?> value="No">No</option>
												<option ee_val=0 <?php echo $enticeEnergy['agentgavebesttariff']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=3>Agent to advise of Tariff name - Fixed Saver V6</td>
									</tr>
									<tr>
										<td>C2</td>
										<td colspan=2>Did agent give current and future spends? Full breakdown must be given to mark this section as yes. Annual spend, separate monthly DD where applicable and combined DD amount where applicable</td>
										<td>3</td>
										<td>
											<select class="form-control ee_points" id="" name="agentgavefuturespend" required>
												<option value="">-Select-</option>
												<option ee_val=3 <?php echo $enticeEnergy['agentgavefuturespend']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option ee_val=3 <?php echo $enticeEnergy['agentgavefuturespend']=='No'?"selected":""; ?> value="No">No</option>
												<option ee_val=0 <?php echo $enticeEnergy['agentgavefuturespend']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=3>Full comparison as it appears on screen to be advised - Annual spend on electric, monthly spend on electric, annual spend on gas, monthly spend on gas</td>
									</tr>
									
									<tr>
										<td rowspan=2>C3</td>
										<td colspan=2 rowspan=2>Unit Rates: </br>
										-C3a. Daily standing charge & unit rates provided in full. If agent comparing other supplier unit rates all must be provided </br>
										-C3b. VAT Statement - customer advised comparison & unit rates are inclusive of VAT</td>
										<td rowspan=2>3</td>
										<td>
											<select class="form-control ee_points" id="" name="dailystandingcharges_C3a" required>
												<option value="">-Select-</option>
												<option ee_val=1.5 <?php echo $enticeEnergy['dailystandingcharges_C3a']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option ee_val=1.5 <?php echo $enticeEnergy['dailystandingcharges_C3a']=='No'?"selected":""; ?> value="No">No</option>
												<option ee_val=0 <?php echo $enticeEnergy['dailystandingcharges_C3a']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=3>Either just all of Entice Energy's rates advised or advised like for like with current supplier</td>
									</tr>
									<tr>
										<td>
											<select class="form-control ee_points" id="" name="VATstatement_C3b" required>
												<option value="">-Select-</option>
												<option ee_val=1.5 <?php echo $enticeEnergy['VATstatement_C3b']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option ee_val=1.5 <?php echo $enticeEnergy['VATstatement_C3b']=='No'?"selected":""; ?> value="No">No</option>
												<option ee_val=0 <?php echo $enticeEnergy['VATstatement_C3b']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=3></td>
									</tr>
									
									<tr>
										<td rowspan=2>C4</td>
										<td colspan=2 rowspan=2>Cancellation Fees: </br>
										-C4a. Customer advised if cancellation fees may apply with current supplier </br> 
										-C4b. Customer advised of SP cancellation fees (if applicable) at the point of the comparison and prior to offering/reading the product key facts (Please note: must be given in £'s as displayed on quote breakdown)</td>
										<td rowspan=2>3</td>
										<td>
											<select class="form-control ee_points" id="" name="cancelletionfees_C4a" required>
												<option value="">-Select-</option>
												<option ee_val=1.5 <?php echo $enticeEnergy['cancelletionfees_C4a']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option ee_val=1.5 <?php echo $enticeEnergy['cancelletionfees_C4a']=='No'?"selected":""; ?> value="No">No</option>
												<option ee_val=0 <?php echo $enticeEnergy['cancelletionfees_C4a']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=3>If customer is in a tariff and they provide you with the exact name of it system will show if there are cancellation fees - agent must advise of this</td>
									</tr>
									<tr>
										<td>
											<select class="form-control ee_points" id="" name="SPcancelletionfees_C4b" required>
												<option value="">-Select-</option>
												<option ee_val=1.5 <?php echo $enticeEnergy['SPcancelletionfees_C4b']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option ee_val=1.5 <?php echo $enticeEnergy['SPcancelletionfees_C4b']=='No'?"selected":""; ?> value="No">No</option>
												<option ee_val=0 <?php echo $enticeEnergy['SPcancelletionfees_C4b']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=3>Entice Energy exit fees of £30 per fuel to be advised to customer</td>
									</tr>
									
									<tr><td colspan=8 style="font-weight:bold; font-size:20px; background-color:#5DADE2">Direct Debit Details</td></tr>
									<tr>
										<td>D1</td>
										<td colspan=2>Agent states name, representing Entice Energy, reason for call stated & customer advised of call recording</td>
										<td>2</td>
										<td>
											<select class="form-control ee_points" id="" name="verifycustomerbankaccount" required>
												<option value="">-Select-</option>
												<option ee_val=2 <?php echo $enticeEnergy['verifycustomerbankaccount']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option ee_val=2 <?php echo $enticeEnergy['verifycustomerbankaccount']=='No'?"selected":""; ?> value="No">No</option>
												<option ee_val=0 <?php echo $enticeEnergy['verifycustomerbankaccount']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=3>Bank details must be taken from the account holder. If they need to provide their partners details the partner must confirm with you they are happy to do so</td>
									</tr>
									<tr>
										<td>D2</td>
										<td colspan=2>Obtained & reconfirmed the account number, sort code &  name as it is on account (4)</td>
										<td>3</td>
										<td>
											<select class="form-control ee_points" id="" name="reconfirmaccountnumber" required>
												<option value="">-Select-</option>
												<option ee_val=3 <?php echo $enticeEnergy['verifycustomerbankaccount']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option ee_val=3 <?php echo $enticeEnergy['verifycustomerbankaccount']=='No'?"selected":""; ?> value="No">No</option>
												<option ee_val=0 <?php echo $enticeEnergy['verifycustomerbankaccount']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=3>Reading the DD guarentee word for word will cover all points</td>
									</tr>
									<tr>
										<td>D3</td>
										<td colspan=2>Advised that they will receive confirmation of payments dates and amounts within 3 working days (4)</td>
										<td>3</td>
										<td>
											<select class="form-control ee_points" id="" name="receiveconfirmpayment" required>
												<option value="">-Select-</option>
												<option ee_val=3 <?php echo $enticeEnergy['receiveconfirmpayment']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option ee_val=3 <?php echo $enticeEnergy['receiveconfirmpayment']=='No'?"selected":""; ?> value="No">No</option>
												<option ee_val=0 <?php echo $enticeEnergy['receiveconfirmpayment']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=3></td>
									</tr>
									<tr>
										<td>D4</td>
										<td colspan=2>Informed that the direct debit mandate will appear as Entice  Energy on their bank statement (2)</td>
										<td>2</td>
										<td>
											<select class="form-control ee_points" id="" name="directdebitmandate" required>
												<option value="">-Select-</option>
												<option ee_val=2 <?php echo $enticeEnergy['directdebitmandate']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option ee_val=2 <?php echo $enticeEnergy['directdebitmandate']=='No'?"selected":""; ?> value="No">No</option>
												<option ee_val=0 <?php echo $enticeEnergy['directdebitmandate']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=3></td>
									</tr>
									<tr><td colspan=8 style="font-weight:bold; font-size:20px; background-color:#5DADE2">Contractual Terms</td></tr>
									<tr>
										<td>E1</td>
										<td colspan=2>T&C's read correctly?</td>
										<td>3</td>
										<td>
											<select class="form-control ee_points" id="" name="correctT&Cneed" required>
												<option value="">-Select-</option>
												<option ee_val=3 <?php echo $enticeEnergy['correctT&Cneed']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option ee_val=3 <?php echo $enticeEnergy['correctT&Cneed']=='No'?"selected":""; ?> value="No">No</option>
												<option ee_val=0 <?php echo $enticeEnergy['correctT&Cneed']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=3>T&C's must be read word for word as they appear on the screen</td>
									</tr>
									<tr>
										<td>E2</td>
										<td colspan=2>Did agent read contact number / contact options for entice?</td>
										<td>3</td>
										<td>
											<select class="form-control ee_points" id="" name="agentreadcontactnumber" required>
												<option value="">-Select-</option>
												<option ee_val=3 <?php echo $enticeEnergy['agentreadcontactnumber']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option ee_val=3 <?php echo $enticeEnergy['agentreadcontactnumber']=='No'?"selected":""; ?> value="No">No</option>
												<option ee_val=0 <?php echo $enticeEnergy['agentreadcontactnumber']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=3>Agent to provide customer with phone number for Entice Energy</td>
									</tr>
									<tr>
										<td>E3</td>
										<td colspan=2>Sign up scripting read and clear yes obtained by agent before verification?</td>
										<td>3</td>
										<td>
											<select class="form-control ee_points" id="" name="signupScriptingread" required>
												<option value="">-Select-</option>
												<option ee_val=3 <?php echo $enticeEnergy['signupScriptingread']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option ee_val=3 <?php echo $enticeEnergy['signupScriptingread']=='No'?"selected":""; ?> value="No">No</option>
												<option ee_val=0 <?php echo $enticeEnergy['signupScriptingread']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=3>Clear yes must be obtained from the customer before submission</td>
									</tr>
									<tr><td colspan=8 style="font-weight:bold; font-size:20px; background-color:#5DADE2">Standards Of Conduct</td></tr>
									<tr>
										<td>F1</td>
										<td colspan=2>Was the agent open, honest and transparent with the customer at all times in line with SOC?  (The agent must not mislead the customer in any way)</td>
										<td>2</td>
										<td>
											<select class="form-control ee_points" id="" name="honestwithcustomer" required>
												<option value="">-Select-</option>
												<option ee_val=2 <?php echo $enticeEnergy['honestwithcustomer']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option ee_val=2 <?php echo $enticeEnergy['honestwithcustomer']=='No'?"selected":""; ?> value="No">No</option>
												<option ee_val=0 <?php echo $enticeEnergy['honestwithcustomer']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=3>Agent must not mislead the customer in anyway. Selling on the cooling off period will also instantly fail the call</td>
									</tr>
									
									<tr><td colspan=8 style="font-weight:bold; font-size:20px; background-color:#5DADE2">Vulnerability</td></tr>
									<tr>
										<td rowspan=2>G1</td>
										<td colspan=2 rowspan=2>Vulnerability </br>
										G1a. Did the agent recognise signs of potential vulnerability throughout the call </br>
										G1b. Did the agent ask the Vulnerability/Priority Services Register question</td>
										<td rowspan=2>2</td>
										<td>
											<select class="form-control ee_points" id="" name="potentialVulnerability_G1a" required>
												<option value="">-Select-</option>
												<option ee_val=1 <?php echo $enticeEnergy['potentialVulnerability_G1a']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option ee_val=1 <?php echo $enticeEnergy['potentialVulnerability_G1a']=='No'?"selected":""; ?> value="No">No</option>
												<option ee_val=0 <?php echo $enticeEnergy['potentialVulnerability_G1a']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=3></td>
									</tr>
									<tr>
										<td>
											<select class="form-control ee_points" id="" name="priorityVulnerability_G1b" required>
												<option value="">-Select-</option>
												<option ee_val=1 <?php echo $enticeEnergy['priorityVulnerability_G1b']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option ee_val=1 <?php echo $enticeEnergy['priorityVulnerability_G1b']=='No'?"selected":""; ?> value="No">No</option>
												<option ee_val=0 <?php echo $enticeEnergy['priorityVulnerability_G1b']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=3></td>
									</tr>
									<tr>
										<td>G2</td>
										<td colspan=2>Did the agent take appropriate action/act accordingly at point of sale and inform customer of Priority Services Register including providing the phone number ( Applicable for G& E only) </td>
										<td>2</td>
										<td>
											<select class="form-control ee_points" id="" name="takeappropriateaction" required>
												<option value="">-Select-</option>
												<option ee_val=1 <?php echo $enticeEnergy['takeappropriateaction']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option ee_val=1 <?php echo $enticeEnergy['takeappropriateaction']=='No'?"selected":""; ?> value="No">No</option>
												<option ee_val=0 <?php echo $enticeEnergy['takeappropriateaction']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=3></td>
									</tr>
									
									<tr>
										<td>Call Summary:</td>
										<td colspan=3><textarea class="form-control" id="call_summary" name="call_summary"><?php echo $enticeEnergy['call_summary'] ?></textarea></td>
										<td>Feedback:</td>
										<td colspan=3><textarea class="form-control" id="feedback" name="feedback"><?php echo $enticeEnergy['feedback'] ?></textarea></td>
									</tr>
									
									<?php if($enticeEnergy['attach_file']!=''){ ?>
									<tr>
										<td colspan=2>Audio Files</td>
										<td colspan=6>
											<?php $attach_file = explode(",",$enticeEnergy['attach_file']);
											 foreach($attach_file as $mp){ ?>
												<audio controls='' style="background-color:#607F93"> 
												  <source src="<?php echo base_url(); ?>qa_files/qa_entice_energy/<?php echo $mp; ?>" type="audio/ogg">
												  <source src="<?php echo base_url(); ?>qa_files/qa_entice_energy/<?php echo $mp; ?>" type="audio/mpeg">
												</audio> </br>
											 <?php } ?>
										</td>
									</tr>
									<?php } ?>
									
									<tr><td colspan=8 style="background-color:#C5C8C8"></td></tr>
									
									<tr><td colspan=2  style="font-size:16px">Agent Review:</td> <td colspan=6><?php echo $enticeEnergy['agent_rvw_note'] ?></td></tr>	
									<tr><td colspan=2  style="font-size:16px">Management Review:</td> <td colspan=6><?php echo $enticeEnergy['mgnt_rvw_note'] ?></td></tr>	
									<tr><td colspan=2  style="font-size:16px">Client Review:</td> <td colspan=6><?php echo $enticeEnergy['client_rvw_note'] ?></td></tr>	
									
									<tr><td colspan=8 style="background-color:#C5C8C8"></td></tr>
									
									<tr>
										<td colspan=2  style="font-size:16px">Your Review:</td>
										<td colspan=6><textarea class="form-control" name="note" required></textarea></td>
									</tr>
									
									<?php if(is_access_qa_module()==true || is_access_qa_operations_module()==true){
									if(is_available_qa_feedback($enticeEnergy['entry_date'],72) == true){ ?>
										<tr>
											<td colspan=8><button class="btn btn-success waves-effect" type="submit" id='btnmgntSave' name='btnSave' value="SAVE" style="width:500px">SAVE</button></td>
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
