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
.fatal{
	color:red;
}
</style>

<?php if($idfc_id!=0){
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
										<td colspan="6" id="theader" style="font-size:40px">Collections Audit Sheet</td>
										<input type="hidden" name="audit_start_time" value="<?php echo CurrMySqlDate(); ?>">
									</tr>
									<?php
										if($idfc_id==0){
											$auditorName = get_username();
											$auditDate = CurrDateMDY();
											$clDate_val='';
										}else{
											if($idfc_new['entry_by']!=''){
												$auditorName = $idfc_new['auditor_name'];
											}else{
												$auditorName = $idfc_new['client_name'];
											}
											$auditDate = mysql2mmddyy($idfc_new['audit_date']);
											$clDate_val = mysqlDt2mmddyy($idfc_new['call_date']);
										}
									?>
									<tr>
										<td style="width:150px">Name of Auditor:</td>
										<td><input type="text" class="form-control" value="<?php echo $auditorName; ?>" disabled></td>
										<td>Date of Audit:</td>
										<td style="width:250px"><input type="text" class="form-control" value="<?php echo $auditDate; ?>" disabled></td>
										<td>Call Date/Time:</td>
										<td><input type="text" class="form-control" id="call_date_time" name="call_date" value="<?php echo $clDate_val; ?>" required></td>
									</tr>
									<tr>
										<td>Agent:</td>
										<td>
											<select class="form-control" id="agent_id" name="data[agent_id]" required>
												<option value="<?php echo $idfc_new['agent_id'] ?>"><?php echo $idfc_new['fname']." ".$idfc_new['lname'] ?></option>
												<option value="">-Select-</option>
												<?php foreach($agentName as $row):  ?>
													<option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
												<?php endforeach; ?>
											</select>
										</td>
										<td>MWP ID:</td>
										<td><input type="text" class="form-control" id="fusion_id" value="<?php echo $idfc_new['fusion_id'] ?>" readonly></td>
										<td>L1 Supervisor:</td>
										<td>
											<select class="form-control" id="tl_id" name="data[tl_id]" readonly>
												<option value="<?php echo $idfc_new['tl_id'] ?>"><?php echo $idfc_new['tl_name'] ?></option>
												<option value="">--Select--</option>
												<?php foreach($tlname as $tl): ?>
													<option value="<?php echo $tl['id']; ?>"><?php echo $tl['fname']." ".$tl['lname']; ?></option>
												<?php endforeach; ?>	
											</select>
										</td>
									</tr>
									<tr>
										<td>Phone:</td>
										<td><input type="text" class="form-control" id="phone" name="data[customer_phone]" onkeyup="checkDec(this);" value="<?php echo $idfc_new['customer_phone'] ?>" required></td>
										<td>Customer Name:</td>
										<td><input type="text" class="form-control" name="data[customer_name]"  value="<?php echo $idfc_new['customer_name'] ?>" required></td>
										<td>AHT:</td>
										<td><input type="text" class="form-control" id="call_duration" name="data[call_duration]" value="<?php echo $idfc_new['call_duration'] ?>" required></td>
									</tr>
									<tr>
										<td>Loan ID:</td>
										<td><input type="text" class="form-control" name="data[loan_id]" value="<?php echo $idfc_new['loan_id'] ?>" required></td>
										<td>Week:</td>
										<td>
											<select class="form-control" name="data[week]" required>
												<option value="">-Select-</option>
												<option <?php echo $idfc_new['week']=='Week1'?"selected":""; ?> value="Week1">Week1</option>
												<option <?php echo $idfc_new['week']=='Week2'?"selected":""; ?> value="Week2">Week2</option>
												<option <?php echo $idfc_new['week']=='Week3'?"selected":""; ?> value="Week3">Week3</option>
												<option <?php echo $idfc_new['week']=='Week4'?"selected":""; ?> value="Week4">Week4</option>
											</select>
										</td>
										<td>Product Name:</td>
										<td>
											<select class="form-control" name="data[product_name]" required>
												<option value="<?php echo $idfc_new['product_name'] ?>"><?php echo $idfc_new['product_name'] ?></option>
												<option value="">-Select-</option>
												<option  value="SUVIDHA">SUVIDHA</option>
												<option  value="BIL_PL">BIL_PL</option>
												<option  value="UC-AL">UC-AL</option>
												<option  value="X-SELL">X-SELL</option>
												<option  value="TW">TW</option>
												<option  value="LAP">LAP</option>
												<option  value="BIL_BIL">BIL_BIL</option>
												<option  value="HL">HL</option>
												<option  value="CL">CL</option>
												<option  value="MBL">MBL</option>
												<option  value="PL">PL</option>
											</select>
										</td>
									</tr>
									<tr>
										<td>Customer VOC:</td>
										<td>
											<select class="form-control" id="cust_voc" name="data[customer_voc]" required>
												<option value="<?php echo $idfc_new['customer_voc'] ?>"><?php echo $idfc_new['customer_voc'] ?></option>
												<option value="">-Select-</option>
												<option  value="Financial issue">Financial issue</option>
												<option  value="Health issue">Health issue</option>
												<option  value="Dispute on EMI/Charges">Dispute on EMI/Charges</option>
												<option  value="Loan cancel/Not Received/Settle">Loan cancel/Not Received/Settle</option>
												<option  value="No Information about charges">No Information about charges</option>
												<option  value="Want FOS/ECS">Want FOS/ECS</option>
												<option  value="Wrong number/Loan">Wrong number/Loan</option>
												<option  value="Third Party on Call">Third Party on Call</option>
												<option  value="Frustated regarding continous call">Frustated regarding continous call</option>
												<option  value="Refuse to pay Charges/EMI">Refuse to pay Charges/EMI</option>
												<option  value="Loan not Taken">Loan not Taken</option>
												<option  value="Cannot Pay Online">Cannot Pay Online</option>
												<option  value="Not Applicable">Not Applicable</option>
												<option  value="Out of station">Out of station</option>
												<option  value="Pay at the time of Loan closure">Pay at the time of Loan closure</option>
												<option  value="Promise to pay">Promise to pay</option>
												<option  value="Behaviour Issue">Behaviour Issue</option>
												<option  value="Bank realted issue">Bank realted issue</option>
												<option  value="Other">Other</option>
											</select>
										</td>
										<td>Customer Sub VOC:</td>
										<td>
											<select class="form-control" id="cust_sub_voc" name="data[customer_sub_voc]" required>
												<option value="<?php echo $idfc_new['customer_sub_voc'] ?>"><?php echo $idfc_new['customer_sub_voc'] ?></option>
											</select>
										</td>
										<td>Campaign Name:</td>
										<td>
											<select class="form-control" name="data[campaign_name]" required>
												<option value="<?php echo $idfc_new['campaign_name'] ?>"><?php echo $idfc_new['campaign_name'] ?></option>
												<option value="">-Select-</option>
												<option  value="Core">Core</option>
												<option  value="ODBC">ODBC</option>
												<option  value="BCC_ND">BCC_ND</option>
												<option  value="BCC_BX">BCC_BX</option>
												<option  value="PBM">PBM</option>
												<option  value="Autopay">Autopay</option>
												<option  value="Other">Other</option>
											</select>
										</td>
									</tr>
									<tr>
										<td>Objections:</td>
										<td>
											<select class="form-control" name="data[objections]" required>
												<option value="<?php echo $idfc_new['objections'] ?>"><?php echo $idfc_new['objections'] ?></option>
												<option value="">-Select-</option>
												<option  value="Salary not received">Salary not received</option>
												<option  value="No Money">No Money</option>
												<option  value="Denied for Charges">Denied for Charges</option>
												<option  value="Customer claimed that he paid charges">Customer claimed that he paid charges</option>
												<option  value="Pay after waiver of charges">Pay after waiver of charges</option>
												<option  value="Customer is having issue in Bank account">Customer is having issue in Bank account</option>
												<option  value="ECS did not deduct EMI">ECS did not deduct EMI</option>
												<option  value="Amount deducted on Due date">Amount deducted on Due date</option>
												<option  value="Amount deducted after Due date">Amount deducted after Due date</option>
												<option  value="Already paid by cashpickup">Already paid by cashpickup</option>
												<option  value="Already paid at showroom">Already paid at showroom</option>
												<option  value="Customer not using online apps">Customer not using online apps</option>
												<option  value="Paid on or before due date still got charged">Paid on or before due date still got charged</option>
												<option  value="Not Received calls for charges earlier">Not Received calls for charges earlier</option>
												<option  value="Payment not received">Payment not received</option>
												<option  value="Want appology call for Misbehave">Want appology call for Misbehave</option>
												<option  value="Paid amount but adjusted in charges">Paid amount but adjusted in charges</option>
												<option  value="Unable to pay on due date - different salary date">Unable to pay on due date - different salary date</option>
												<option  value="Pay after loan closure">Pay after loan closure</option>
												<option  value="Wants to deactivate ECS">Wants to deactivate ECS</option>
												<option  value="Internet not working on call">Internet not working on call</option>
												<option  value="Customer does not know how to use online app/payment">Customer does not know how to use online app/payment</option>
												<option  value="Trust issue in online payment">Trust issue in online payment</option>
												<option  value="Want to return Product">Want to return Product</option>
												<option  value="Met with an accident">Met with an accident</option>
												<option  value="Already paid to shopkeeper">Already paid to shopkeeper</option>
												<option  value="EMI mismatch">EMI mismatch</option>
												<option  value="RC not received">RC not received</option>
												<option  value="Product Not Working">Product Not Working</option>
												<option  value="Product Lost/theft">Product Lost/theft</option>
												<option  value="Product Not received">Product Not received</option>
												<option  value="Product taken by someone else">Product taken by someone else</option>
												<option  value="Account freezed">Account freezed</option>
												<option  value="Wants to Update Bank account">Wants to Update Bank account</option>
												<option  value="Other">Other</option>
											</select>
										</td>
										<td>Agent Disposition:</td>
										<td><input type="text" class="form-control" name="data[agent_disposition]" value="<?php echo $idfc_new['agent_disposition'] ?>" required></td>
										<td>QA Disposition:</td>
										<td><input type="text" class="form-control" name="data[qa_disposition]" value="<?php echo $idfc_new['qa_disposition'] ?>" required></td>
									</tr>
									<tr>
										<td>Audit Type:</td>
										<td>
											<select class="form-control" id="audit_type" name="data[audit_type]" required>
												<option value="">-Select-</option>
												<option <?php echo $idfc_new['audit_type']=='CQ Audit'?"selected":""; ?> value="CQ Audit">CQ Audit</option>
												<option <?php echo $idfc_new['audit_type']=='BQ Audit'?"selected":""; ?> value="BQ Audit">BQ Audit</option>
												<option <?php echo $idfc_new['audit_type']=='Calibration'?"selected":""; ?> value="Calibration">Calibration</option>
												<option <?php echo $idfc_new['audit_type']=='Pre-Certificate Mock Call'?"selected":""; ?> value="Pre-Certificate Mock Call">Pre-Certificate Mock Call</option>
												<option <?php echo $idfc_new['audit_type']=='Certificate Audit'?"selected":""; ?> value="Certificate Audit">Certificate Audit</option>
												<?php if(get_login_type()!="client"){ ?>
													<option <?php echo $idfc_new['audit_type']=='Operation Audit'?"selected":""; ?> value="Operation Audit">Operation Audit</option>
													<option <?php echo $idfc_new['audit_type']=='Trainer Audit'?"selected":""; ?> value="Trainer Audit">Trainer Audit</option>
												<?php } ?>
											</select>
										</td>
										<td>Auditor Type</td>
										<td>
											<select class="form-control" id="auditor_type" name="data[auditor_type]">
												<option value="">-Select-</option>
												<option <?= ($idfc_new['auditor_type']=="Master")?"selected":""?> value="Master">Master</option>
												<option <?= ($idfc_new['auditor_type']=="Regular")?"selected":""?> value="Regular">Regular</option>
											</select>
										</td>
										<td>VOC:</td>
										<td>
											<select class="form-control" id="voc" name="data[voc]" required>
												<option value="">-Select-</option>
												<option <?php echo $idfc_new['voc']=='1'?"selected":""; ?> value="1">1</option>
												<option <?php echo $idfc_new['voc']=='2'?"selected":""; ?> value="2">2</option>
												<option <?php echo $idfc_new['voc']=='3'?"selected":""; ?> value="3">3</option>
												<option <?php echo $idfc_new['voc']=='4'?"selected":""; ?> value="4">4</option>
												<option <?php echo $idfc_new['voc']=='5'?"selected":""; ?> value="5">5</option>
											</select>
										</td>
									</tr>
									<tr>
										<td style="font-weight:bold; font-size:16px; text-align:right">Earned Score:</td>
										<td><input type="text" value="<?= $idfc_new['earned_score']?>" readonly id="idfcEarnedScore" name="data[earned_score]" class="form-control" style="font-weight:bold"></td>
										<td style="font-weight:bold; font-size:16px; text-align:right">Possible Score:</td>
										<td><input type="text" value="<?= $idfc_new['possible_score']?>" readonly id="idfcPossibleScore" name="data[possible_score]" class="form-control" style="font-weight:bold"></td>
										<td style="font-weight:bold; font-size:16px; text-align:right">Overall Score:</td>
										<td><input type="text" value="<?= $idfc_new['overall_score']?>" readonly id="idfcOverallScore" name="data[overall_score]" class="form-control idfcQAFatal" style="font-weight:bold"></td>
									</tr>
									<tr style="background-color:#5DADE2; font-weight:bold; color:white">
										<th colspan=2>Parameters</th>
										<th>Score</th>
										<th>Legend</th>
										<th colspan=2>Remarks</th>
									</tr>
									<tr>
										<td colspan=2>Call Opening - Greeting & Customer Identification</td>
										<td>
											<select name="data[customer_identification]" class="form-control idfc" required>
												<option idfc_val=4 <?= ($idfc_new['customer_identification']=="Yes")?"selected":""?> value='Yes'>Yes</option>
												<option idfc_val=4 <?= ($idfc_new['customer_identification']=="No")?"selected":""?> value='No'>No</option>
												<option idfc_val=0 <?= ($idfc_new['customer_identification']=="N/A")?"selected":""?> value='N/A'>N/A</option>
											</select>
										</td>
										<td>
											<p><strong>Yes:</strong> Call should be opened within 5 secs. Associate should greet appropriately (Good Morning/Afternoon /Evening) as per script, ask for customer first before initiating the conversation.
											<br/><strong>No:</strong> Call opening not done within 5 sec or call opening not done or customer identification not done</p>
										</td>
										<td colspan=2><input type="text" value="<?= $idfc_new['cmt1']?>" name="data[cmt1]" class="form-control"></td>
									</tr>

									<tr>
										<td colspan=2>Call Opening - Self Introduction & Reaching RPC</td>
										<td>
											<select name="data[self_introduction]" class="form-control idfc" required>
												<option idfc_val=2 <?= ($idfc_new['self_introduction']=="Yes")?"selected":""?> value='Yes'>Yes</option>
												<option idfc_val=2 <?= ($idfc_new['self_introduction']=="No")?"selected":""?> value='No'>No</option>
												<option idfc_val=0 <?= ($idfc_new['self_introduction']=="N/A")?"selected":""?> value='N/A'>N/A</option>
											</select>
										</td>
										<td>
											<p>
											<strong>Yes:</strong> Associate should Introduce self and organisation, In case of Third Party, appropriate authorization with complete details like name and relationship to be confirmed before providing information,Check if third party is aware of the customer's alternate contact details and capture the number on CRM, Needs to capture call back date and time from RPC/TPC 
											<br/><strong>No:</strong> Self & organization intruduction not done or did not check for RPC
											</p>
										</td>
										<td colspan=2><input type="text" value="<?= $idfc_new['cmt2']?>" name="data[cmt2]" class="form-control"></td>
									</tr>

									<tr>
										<td colspan=2>Call Opening - Purpose of Call</td>
										<td>
											<select name="data[purpose_of_call]" class="form-control idfc" required>
												<option idfc_val=3 <?= ($idfc_new['purpose_of_call']=="Yes")?"selected":""?> value='Yes'>Yes</option>
												<option idfc_val=3 <?= ($idfc_new['purpose_of_call']=="No")?"selected":""?> value='No'>No</option>
												<option idfc_val=0 <?= ($idfc_new['purpose_of_call']=="N/A")?"selected":""?> value='N/A'>N/A</option>
											</select>
										</td>
										<td>
											<p>
											<strong>Yes:</strong> Associate need to inform the reason of call appropriately.
											<br/><strong>No:</strong> Associate did not inform the reason of call
											</p>
										</td>
										<td colspan=2><input type="text" value="<?= $idfc_new['cmt3']?>" name="data[cmt3]" class="form-control"></td>
									</tr>

									<tr>
										<td colspan=2>Providing Information & Educating - Complete & Correct Information Minor Impact</td>
										<td>
											<select name="data[complete_correct]" class="form-control idfc" required>
												<option idfc_val=6 <?= ($idfc_new['complete_correct']=="Yes")?"selected":""?> value='Yes'>Yes</option>
												<option idfc_val=6 <?= ($idfc_new['complete_correct']=="No")?"selected":""?> value='No'>No</option>
												<option idfc_val=0 <?= ($idfc_new['complete_correct']=="N/A")?"selected":""?> value='N/A'>N/A</option>
											</select>
										</td>
										<td>
											<p>
											<strong>Yes:</strong> Product name & Bounce reason communicated to the customer, Authorized payment script
											<br/><strong>No:</strong> Bounce reason not informed (non customer impacting)
											</p>
										</td>
										<td colspan=2><input type="text" value="<?= $idfc_new['cmt4']?>" name="data[cmt4]" class="form-control"></td>
									</tr>
									<tr>
										<td class="fatal" colspan=2>Providing Information & Educating - Incomplete / Incorrect Information - EMI, Penal & Bounce Charges</td>
										<td>
											<select name="data[incomplete_incorrect]" class="form-control idfc idfc_fatal" id="idfcAF1" required>
												<option idfc_val=0 <?= ($idfc_new['incomplete_incorrect']=="Yes")?"selected":""?> value='Yes'>Yes</option>
												<option idfc_val=0 <?= ($idfc_new['incomplete_incorrect']=="Fatal")?"selected":""?> value='Fatal'>Fatal</option>
												<option idfc_val=0 <?= ($idfc_new['incomplete_incorrect']=="N/A")?"selected":""?> value='N/A'>N/A</option>
											</select>
										</td>
										<td class="fatal">
											<p>
											<strong>Yes:</strong> EMI & Bounce charges correctly informed to customer 
											<br/><strong>Fatal:</strong> incomplete or incorrect EMI & Bounce charges informed by agent (customer financial impact)
											</p>
										</td>
										<td colspan=2><input type="text" value="<?= $idfc_new['cmt5']?>" name="data[cmt5]" class="form-control"></td>
									</tr>
									<tr>
										<td class="fatal" colspan=2>Providing Information & Educating - Incomplete / Wrong Information / False Commitment - Others</td>
										<td>
											<select name="data[incomplete_wrong]" class="form-control idfc idfc_fatal" id="idfcAF2" required>
												<option idfc_val=0 <?= ($idfc_new['incomplete_wrong']=="Yes")?"selected":""?> value='Yes'>Yes</option>
												<option idfc_val=0 <?= ($idfc_new['incomplete_wrong']=="Fatal")?"selected":""?> value='Fatal'>Fatal</option>
												<option idfc_val=0 <?= ($idfc_new['incomplete_wrong']=="N/A")?"selected":""?> value='N/A'>N/A</option>
											</select>
										</td>
										<td class="fatal">
											<p>
											<strong>Yes:</strong> Information provided are correct and complete and no false commitment made 
											<br/><strong>Fatal:</strong> Any Information provided to customer, which is incomplete or incorrect and has financial implication and major impact on business
											</p>
										</td>
										<td colspan=2><input type="text" value="<?= $idfc_new['cmt6']?>" name="data[cmt6]" class="form-control"></td>
									</tr>
									<tr>
										<td class="fatal" colspan=2>Providing Information & Educating - Confirmed PU and PTP Details</td>
										<td>
											<select name="data[confirmed_pu]" class="form-control idfc idfc_fatal" id="idfcAF3" required>
												<option idfc_val=0 <?= ($idfc_new['confirmed_pu']=="Yes")?"selected":""?> value='Yes'>Yes</option>
												<option idfc_val=0 <?= ($idfc_new['confirmed_pu']=="Fatal")?"selected":""?> value='Fatal'>Fatal</option>
												<option idfc_val=0 <?= ($idfc_new['confirmed_pu']=="N/A")?"selected":""?> value='N/A'>N/A</option>
											</select>
										</td>
										<td class="fatal">
											<p>
											<strong>Yes:</strong> Associate should confirm mandate details like Date, Address, Time, Amount, MOP etc. for Pickup / PTP.
											In case of Pick up, Confirmed address, alternate person, alternate no, Date & Time
											<br/><strong>Fatal:</strong> Associate missing on any of the above mandate information for PTP/ PU
											<br/><strong>NA:</strong> Scenario does not qualify for PTP/ PU
											</p>
										</td>
										<td colspan=2><input type="text" value="<?= $idfc_new['cmt7']?>" name="data[cmt7]" class="form-control"></td>
									</tr>

									<tr>
										<td colspan=2>CRM/SOA Navigation - Referred the Trail remarks in CRM</td>
										<td>
											<select name="data[referred_the_trail]" class="form-control idfc" required>
												<option idfc_val=6 <?= ($idfc_new['referred_the_trail']=="Yes")?"selected":""?> value='Yes'>Yes</option>
												<option idfc_val=6 <?= ($idfc_new['referred_the_trail']=="No")?"selected":""?> value='No'>No</option>
												<option idfc_val=0 <?= ($idfc_new['referred_the_trail']=="N/A")?"selected":""?> value='N/A'>N/A</option>
											</select>
										</td>
										<td>
											<p>
											<strong>Yes:</strong> Associate referred previous interaction and link it with customer conversation.
											<br/><strong>No:</strong> Associated did not refer the previous interaction where as available
											<br/><strong>NA:</strong> No previous interaction available or not appropriate to the call scenario
											</p>
										</td>
										<td colspan=2><input type="text" value="<?= $idfc_new['cmt8']?>" name="data[cmt8]" class="form-control"></td>
									</tr>
									<tr>
										<td colspan=2>CRM/SOA Navigation - Referred customers Payment history / Other details in CRM, have checked SOA while asking for payment</td>
										<td>
											<select name="data[referred_customers_payment]" class="form-control idfc" required>
												<option idfc_val=5 <?= ($idfc_new['referred_customers_payment']=="Yes")?"selected":""?> value='Yes'>Yes</option>
												<option idfc_val=5 <?= ($idfc_new['referred_customers_payment']=="N0")?"selected":""?> value='No'>No</option>
												<option idfc_val=0 <?= ($idfc_new['referred_customers_payment']=="N/A")?"selected":""?> value='N/A'>N/A</option>
											</select>
										</td>
										<td>
											<p>
											<strong>Yes:</strong> Should check customer last payment history, how he has made the payment in past 3 Months by checking SOA on every call & probe for the payment accordingly.  Should make customer understand about the impact of delaying payment every month by referring last payment dates
											<br/><strong>No:</strong> Did not check previous payment history and informed the customer the impact of delayed payment
											<br/><strong>NA:</strong> No previous payment history available
											</p>
										</td>
										<td colspan=2><input type="text" value="<?= $idfc_new['cmt9']?>" name="data[cmt9]" class="form-control"></td>
									</tr>

									<tr>
										<td colspan=2 class="fatal">Created Urgency/Consequence Informed - Use convincing skills for early payment</td>
										<td>
											<select name="data[use_convincing_skills]" class="form-control idfc idfc_fatal" id="idfcAF4" required>
												<option idfc_val=0 <?= ($idfc_new['use_convincing_skills']=="Yes")?"selected":""?> value='Yes'>Yes</option>
												<option idfc_val=0 <?= ($idfc_new['use_convincing_skills']=="Fatal")?"selected":""?> value='Fatal'>Fatal</option>
												<option idfc_val=0 <?= ($idfc_new['use_convincing_skills']=="N/A")?"selected":""?> value='N/A'>N/A</option>
											</select>
										</td>
										<td class="fatal">
											<p>
											<strong>Yes:</strong> Agent should convince the customer for early payment
											<br/>Agent should create urgency to make payment
											<br/>Agent should ask to customer for delay payment reasons
											<br/>Agent should convince for Bounce & Penal charges collections
											<br/><strong>Fatal:</strong> Agent did not use the convincing skill/ created urgency on call for payment/ Agent did not convince properly for payment on Bounce & Penal charges
											<br/><strong>NA:</strong> Scenario does not require for early payment (e.g. customer already made the payment)
											</p>
										</td>
										<td colspan=2><input type="text" value="<?= $idfc_new['cmt10']?>" name="data[cmt10]" class="form-control"></td>
									</tr>
									<tr>
										<td colspan=2>Effective Probing - Follow appropriate and relevant probing as per the process</td>
										<td>
											<select name="data[follow_appropriate]" class="form-control idfc" required>
												<option idfc_val=10 <?= ($idfc_new['follow_appropriate']=="Yes")?"selected":""?> value='Yes'>Yes</option>
												<option idfc_val=10 <?= ($idfc_new['follow_appropriate']=="No")?"selected":""?> value='No'>No</option>
												<option idfc_val=0 <?= ($idfc_new['follow_appropriate']=="N/A")?"selected":""?> value='N/A'>N/A</option>
											</select>
										</td>
										<td>
											<p>
											<strong>Yes:</strong> Probe with relevant & precise questions to reach to the exact customer issue without overdoing it.
											<br/>When apparent you require a assistance, reach out immediately to dedicated resources for help (floor support, mentors, Supervisors)
											<br/>Understand internal/external escalation processes and follow them
											<br/><strong>No:</strong> Associate did not probe effectively or didnot reachout for assitance or escalation
											<br/><strong>NA:</strong> Scenario does not apply for additional probing/escalation
											</p>
										</td>
										<td colspan=2><input type="text" value="<?= $idfc_new['cmt11']?>" name="data[cmt11]" class="form-control"></td>
									</tr>
									<tr>
										<td colspan=2>Reason for delay - Identify accurate reasons of payment delay</td>
										<td>
											<select name="data[identify_accurate_reasons]" class="form-control idfc" required>
												<option idfc_val=6 <?= ($idfc_new['identify_accurate_reasons']=="Yes")?"selected":""?> value='Yes'>Yes</option>
												<option idfc_val=6 <?= ($idfc_new['identify_accurate_reasons']=="No")?"selected":""?> value='No'>No</option>
												<option idfc_val=0 <?= ($idfc_new['identify_accurate_reasons']=="NA")?"selected":""?> value='NA'>NA</option>
											</select>
										</td>
										<td>
											<p>
											<strong>Yes:</strong> Agent should further identify the reasons of non payment and update proper problem statement in CMS with accurate, clear and understandable reason of payment delay
											<br/><strong>No:</strong> Agent did not identify the problem statement for non payment
											<br/><strong>NA:</strong> Scenario did not apply
											</p>
										</td>
										<td colspan=2><input type="text" value="<?= $idfc_new['cmt12']?>" name="data[cmt12]" class="form-control"></td>
									</tr>

									<tr>
										<td colspan=2>Objection Handling / Negotiation / Resolution</td>
										<td>
											<select name="data[objection_handling]" class="form-control idfc" required>
												<option idfc_val=5 <?= ($idfc_new['objection_handling']=="Yes")?"selected":""?> value='Yes'>Yes</option>
												<option idfc_val=5 <?= ($idfc_new['objection_handling']=="No")?"selected":""?> value='No'>No</option>
												<option idfc_val=0 <?= ($idfc_new['objection_handling']=="N/A")?"selected":""?> value='N/A'>N/A</option>
											</select>
										</td>
										<td>
											<p>
											<strong>Yes:</strong> Agent  understood the conversation and handled customer queries accordingly
											proper rebuttal were used against onjection raised, negotiation skill used for other payment mode options, offer resolution to customer for ease of collection
											<br/><strong>No:</strong> Proper objection handling not done/ alternate payment option not shared/ proper resolution to concern issue not given
											<br/><string>NA:</strong> Scenario did not apply
											</p>
										</td>
										<td colspan=2><input type="text" value="<?= $idfc_new['cmt13']?>" name="data[cmt13]" class="form-control"></td>
									</tr>

									<tr>
										<td colspan=2>Appropriate Payment Options - Online Payment effectively pitched</td>
										<td>
											<select name="data[online_payment]" class="form-control idfc" required>
												<option idfc_val=10 <?= ($idfc_new['online_payment']=="Yes")?"selected":""?> value='Yes'>Yes</option>
												<option idfc_val=10 <?= ($idfc_new['online_payment']=="No")?"selected":""?> value='No'>No</option>
												<option idfc_val=0 <?= ($idfc_new['online_payment']=="N/A")?"selected":""?> value='N/A'>N/A</option>
											</select>
										</td>
										<td>
											<p>
											<strong>Yes:</strong> Agent should inform the benefits / other ways of online payment,  efforts made by the agents to push the customer for online payment.
											Only if customer not willing / doesn't agree for online payment option , then we can pitch for pick-up ( wherever option available )
											<br/><strong>No:</strong> Agent didnot inform benefit or pitched alternate payment options/ Pick up
											<br/><strong>NA:</strong> Alternate payment option not applicable
											</p>
										</td>
										<td colspan=2><input type="text" value="<?= $idfc_new['cmt14']?>" name="data[cmt14]" class="form-control"></td>
									</tr>

									<tr>
										<td colspan=2>Soft Skill - Active Listening ( Interruption, Not attentive ,Repetition) & Should  Acknowledge the customer while customer is asking any query related to loan / payment</td>
										<td>
											<select name="data[active_listening]" class="form-control idfc" required>
												<option idfc_val=6 <?= ($idfc_new['active_listening']=="Yes")?"selected":""?> value='Yes'>Yes</option>
												<option idfc_val=6 <?= ($idfc_new['active_listening']=="No")?"selected":""?> value='No'>No</option>
												<option idfc_val=0 <?= ($idfc_new['active_listening']=="N/A")?"selected":""?> value='N/A'>N/A</option>
											</select>
										</td>
										<td>
											<p>
											<strong>Yes:</strong> Should avoid interruption/ overlap and should allow the customer to speak first, Associate should listen attentively without making customer repeat multiple times.
											Acknowledge customer's concern/issues/pains with right verbal cue (e.g.: acknowldging customer by using affirmation words as surely / definitely / certainly etc)
											<br/><strong>No:</strong> Multiple overlapping/ interruption/ not allowing the customer to speak/ not attentive and asking customer to repeat
											</p>
										</td>
										<td colspan=2><input type="text" value="<?= $idfc_new['cmt15']?>" name="data[cmt15]" class="form-control"></td>
									</tr>

									<tr>
										<td colspan=2>Soft Skill - Clarity of Speech & Rate of Speech</td>
										<td>
											<select name="data[clarity_speech]" class="form-control idfc" required>
												<option idfc_val=5 <?= ($idfc_new['clarity_speech']=="Yes")?"selected":""?> value='Yes'>Yes</option>
												<option idfc_val=5 <?= ($idfc_new['clarity_speech']=="No")?"selected":""?> value='No'>No</option>
												<option idfc_val=0 <?= ($idfc_new['clarity_speech']=="N/A")?"selected":""?> value='N/A'>N/A</option>
											</select>
										</td>
										<td>
											<p>
											<strong>Yes:</strong> Avoid rushing on Call, Speech should be clear and understandable
											<br/><strong>No:</strong> Russing on call/ trying to finish the call in a hurry/ speech not clear/ understandable
											</p>
										</td>
										<td colspan=2><input type="text" value="<?= $idfc_new['cmt16']?>" name="data[cmt16]" class="form-control"></td>
									</tr>

									<tr>
										<td colspan=2>Soft Skill - Tone and Voice Modulation / Comprehensive</td>
										<td>
											<select name="data[tone_and_voice]" class="form-control idfc" required>
												<option idfc_val=5 <?= ($idfc_new['tone_and_voice']=="Yes")?"selected":""?> value='Yes'>Yes</option>
												<option idfc_val=5 <?= ($idfc_new['tone_and_voice']=="No")?"selected":""?> value='No'>No</option>
												<option idfc_val=0 <?= ($idfc_new['tone_and_voice']=="N/A")?"selected":""?> value='N/A'>N/A</option>
											</select>
										</td>
										<td>
											<p>
											<strong>Yes:</strong> Associate should sound energetic and enthusiastic on call, Should be able to modulate his/her voice and avoid flat tone
											<br/><strong>No:</strong> No voice modulation and flat/ low on energy
											</p>
										</td>
										<td colspan=2><input type="text" value="<?= $idfc_new['cmt17']?>" name="data[cmt17]" class="form-control"></td>
									</tr>

									<tr>
										<td colspan=2>Soft Skill - Empathy</td>
										<td>
											<select name="data[empathy]" class="form-control idfc" required>
												<option idfc_val=3 <?= ($idfc_new['empathy']=="Yes")?"selected":""?> value='Yes'>Yes</option>
												<option idfc_val=3 <?= ($idfc_new['empathy']=="No")?"selected":""?> value='No'>No</option>
												<option idfc_val=0 <?= ($idfc_new['empathy']=="N/A")?"selected":""?> value='N/A'>N/A</option>
											</select>
										</td>
										<td>
											<p>
											<strong>Yes:</strong> Empathizes the concern of the customers as required
											<br/><strong>No:</strong> Did not empathize the customer
											<br/><strong>NA:</strong> Scenario not applicable
											</p>
										</td>
										<td colspan=2><input type="text" value="<?= $idfc_new['cmt18']?>" name="data[cmt18]" class="form-control"></td>
									</tr>

									<tr>
										<td colspan=2>Soft Skill - Confidence</td>
										<td>
											<select name="data[confidence]" class="form-control idfc" required>
												<option idfc_val=4 <?= ($idfc_new['confidence']=="Yes")?"selected":""?> value='Yes'>Yes</option>
												<option idfc_val=4 <?= ($idfc_new['confidence']=="No")?"selected":""?> value='No'>No</option>
												<option idfc_val=0 <?= ($idfc_new['confidence']=="N/A")?"selected":""?> value='N/A'>N/A</option>
											</select>
										</td>
										<td>
											<p>
											<strong>Yes:</strong> Associate was confident and assertive while convincing the customer, 
											<br/><strong>No:</strong> Frequent fumbling/ not confident
											</p>
										</td>
										<td colspan=2><input type="text" value="<?= $idfc_new['cmt19']?>" name="data[cmt19]" class="form-control"></td>
									</tr>

									<tr>
										<td colspan=2>Soft Skill - Language and Grammar ( Slang, Jargons, Regional tone , Abbreviations )</td>
										<td>
											<select name="data[language_and_grammar]" class="form-control idfc" required>
												<option idfc_val=3 <?= ($idfc_new['language_and_grammar']=="Yes")?"selected":""?> value='Yes'>Yes</option>
												<option idfc_val=3 <?= ($idfc_new['language_and_grammar']=="No")?"selected":""?> value='No'>No</option>
												<option idfc_val=0 <?= ($idfc_new['language_and_grammar']=="N/A")?"selected":""?> value='N/A'>N/A</option>
											</select>
										</td>
										<td>
											<p>
											<strong>Yes:</strong> Sentence construction should be meaningful.
											<br/>Grammatical errors should be avoided. Correct Pronunciation required.
											<br/>Avoid using jargons on call (e.g. PU, PTP etc.)
											<br/>Need to speak customer's preffered language. 
											<br/>Avoid switching language at start of call without permission from customer
											<br/><strong>No:</strong> Incorrect sentence/ grammatical error/ jargons usde multiple time/ not speaking customer preferred language
											</p>
										</td>
										<td colspan=2><input type="text" value="<?= $idfc_new['cmt20']?>" name="data[cmt20]" class="form-control"></td>
									</tr>

									<tr>
										<td colspan=2>Soft Skill - Telephone Etiquettes & Hold Procedure</td>
										<td>
											<select name="data[telephone_etiquettes]" class="form-control idfc" required>
												<option idfc_val=2 <?= ($idfc_new['telephone_etiquettes']=="Yes")?"selected":""?> value='Yes'>Yes</option>
												<option idfc_val=2 <?= ($idfc_new['telephone_etiquettes']=="No")?"selected":""?> value='No'>No</option>
												<option idfc_val=0 <?= ($idfc_new['telephone_etiquettes']=="N/A")?"selected":""?> value='N/A'>N/A</option>
											</select>
										</td>
										<td>
											<p>
											<strong>Yes:</strong> Appropriate Hold Procedure need to be followed. Should seek permission from the customer before putting call on hold and thank the customer for being on line. Avoid Unnecessary Hold
											<br/>Should avoid Dead Air on Call, Should avoid Dead Air on Call. Dead air would be gap in conversation exceeding 10 secs.
											<br/><strong>No:</strong> Kept the customer on hold without permission or long hold/ multiple dead air observed
											</p>
										</td>
										<td colspan=2><input type="text" value="<?= $idfc_new['cmt21']?>" name="data[cmt21]" class="form-control"></td>
									</tr>

									<tr>
										<td class="fatal" colspan=2>Soft Skill - Rudeness/Unprofessionalism /Call Disconnection</td>
										<td>
											<select name="data[rudeness_unprofessionalism]" class="form-control idfc idfc_fatal" id="idfcAF5" required>
												<option idfc_val=0 <?= ($idfc_new['rudeness_unprofessionalism']=="Yes")?"selected":""?> value='Yes'>Yes</option>
												<option idfc_val=0 <?= ($idfc_new['rudeness_unprofessionalism']=="Fatal")?"selected":""?> value='Fatal'>Fatal</option>
												<option idfc_val=0 <?= ($idfc_new['rudeness_unprofessionalism']=="N/A")?"selected":""?> value='N/A'>N/A</option>
											</select>
										</td>
										<td class="fatal">
											<p>
											<strong>Yes:</strong> Use proffesional language be polite and courteous
											<br/><strong>Fatal:</strong> Unprofessional language/ Assertiveness/ being rude/ using profenity/ call disconnection
											</p>
										</td>
										<td colspan=2><input type="text" value="<?= $idfc_new['cmt22']?>" name="data[cmt22]" class="form-control"></td>
									</tr>

									<tr>
										<td colspan=2>CRM Protocol (Minor Impact)</td>
										<td>
											<select name="data[crm_protocol]" class="form-control idfc" required>
												<option idfc_val=3 <?= ($idfc_new['crm_protocol']=="Yes")?"selected":""?> value='Yes'>Yes</option>
												<option idfc_val=3 <?= ($idfc_new['crm_protocol']=="No")?"selected":""?> value='No'>No</option>
												<option idfc_val=0 <?= ($idfc_new['crm_protocol']=="No")?"selected":""?> value='No'>No</option>
											</select>
										</td>
										<td>
											<p>
											<strong>Yes:</strong> Field and Remark Updation (Minor Impact) 
											<br/><strong>No:</strong> failed to mention reason delay / reason for call back, failed to mention alternate no , TPC name and relation etc
											</p>
										</td>
										<td colspan=2><input type="text" value="<?= $idfc_new['cmt23']?>" name="data[cmt23]" class="form-control"></td>
									</tr>

									<tr>
										<td colspan=2>CRM Protocol - Capture Alternate Number</td>
										<td>
											<select name="data[capture_alternate]" class="form-control idfc" required>
												<option idfc_val=2 <?= ($idfc_new['capture_alternate']=="Yes")?"selected":""?> value='Yes'>Yes</option>
												<option idfc_val=2 <?= ($idfc_new['capture_alternate']=="No")?"selected":""?> value='No'>No</option>
												<option idfc_val=0 <?= ($idfc_new['capture_alternate']=="N/A")?"selected":""?> value='N/A'>N/A</option>
											</select>
										</td>
										<td>
											<p>
											<strong>Yes:</strong> Need to capture alternate contact no. from RPC
											<br/><strong>No:</strong> Missed to capture alternate no
											</p>
										</td>
										<td colspan=2><input type="text" value="<?= $idfc_new['cmt24']?>" name="data[cmt24]" class="form-control"></td>
									</tr>

									<tr>
										<td class="fatal" colspan=2>CRM protocol  - Field and Remark Updation (Major Impact)</td>
										<td>
											<select name="data[field_and_remark]" class="form-control idfc idfc_fatal" id="idfcAF6" required>
												<option idfc_val=0 <?= ($idfc_new['field_and_remark']=="Yes")?"selected":""?> value='Yes'>Yes</option>
												<option idfc_val=0 <?= ($idfc_new['field_and_remark']=="Fatal")?"selected":""?> value='Fatal'>Fatal</option>
												<option idfc_val=0 <?= ($idfc_new['field_and_remark']=="N/A")?"selected":""?> value='N/A'>N/A</option>
											</select>
										</td>
										<td class="fatal">
											<p>
											<strong>Yes:</strong> All fields correctly updated with proper remarks 
											<br/><strong>Fatal:</strong> failed to mention PU / PTP details in remarks, failed to mention complete scenario in RTP & Dispute cases (Major Impact)
											</p>
										</td>
										<td colspan=2><input type="text" value="<?= $idfc_new['cmt25']?>" name="data[cmt25]" class="form-control"></td>
									</tr>

									<tr>
										<td class="fatal" colspan=2>CRM protocol  - Disposition</td>
										<td>
											<select name="data[crm_protocol_disposition]" class="form-control idfc idfc_fatal" id="idfcAF7" required>
												<option idfc_val=0 <?= ($idfc_new['crm_protocol_disposition']=="Yes")?"selected":""?> value='Yes'>Yes</option>
												<option idfc_val=0 <?= ($idfc_new['crm_protocol_disposition']=="Fatal")?"selected":""?> value='Fatal'>Fatal</option>
												<option idfc_val=0 <?= ($idfc_new['crm_protocol_disposition']=="N/A")?"selected":""?> value='N/A'>N/A</option>
											</select>
										</td>
										<td class="fatal">
											<p>
											<strong>Yes:</strong> Should select correct disposition as per call scenario.
											<br/><strong>Fatal:</strong> Incorrect disposition selected
											</p>
										</td>
										<td colspan=2><input type="text" value="<?= $idfc_new['cmt26']?>" name="data[cmt26]" class="form-control"></td>
									</tr>

									<tr>
										<td colspan=2>Call Closing - Summarization</td>
										<td>
											<select name="data[summarization]" class="form-control idfc" required>
												<option idfc_val=3 <?= ($idfc_new['summarization']=="Yes")?"selected":""?> value='Yes'>Yes</option>
												<option idfc_val=3 <?= ($idfc_new['summarization']=="No")?"selected":""?> value='No'>No</option>
												<option idfc_val=0 <?= ($idfc_new['summarization']=="N/A")?"selected":""?> value='N/A'>N/A</option>
											</select>
										</td>
										<td>
											<p>
											<strong>Yes:</strong> Reconfirming the promise details (Date, time, amount & MOP)/conversation at the end of the call.
											<br/>In case of PU , reconfirm the add , date , time ,alt person , MOP amount etc
											<br/>In case of no PTP/ PU agent to re-confirm on the information shared on call
											<br/><strong>No:</strong> Failed/ missed to summarize the call
											</p>
										</td>
										<td colspan=2><input type="text" value="<?= $idfc_new['cmt27']?>" name="data[cmt27]" class="form-control"></td>
									</tr>

									<tr>
										<td colspan=2>Call Closing - Strong assurance on PU / PTP</td>
										<td>
											<select name="data[strong_assurance]" class="form-control idfc" required>
												<option idfc_val=5 idfc_max=5 <?= ($idfc_new['strong_assurance']=="Yes")?"selected":""?> value='Yes'>Yes</option>
												<option idfc_val=5 idfc_max=5 <?= ($idfc_new['strong_assurance']=="No")?"selected":""?> value='No'>No</option>
												<option idfc_val=0 idfc_max=0 <?= ($idfc_new['strong_assurance']=="N/A")?"selected":""?> value='N/A'>N/A</option>
											</select>
										</td>
										<td>
											<p>
											<strong>Yes:</strong> Should take strong acknowledgment from customer on the commitment made for payment to ensure PTP is not broken 
											<br/><strong>No:</strong> Failed/ Missed to take proper acknowledgement for PTP
											<br/><strong>NA:</strong> Scenario not applicable
											</p>
										</td>
										<td colspan=2><input type="text" value="<?= $idfc_new['cmt28']?>" name="data[cmt28]" class="form-control"></td>
									</tr>

									<tr>
										<td colspan=2>Closing</td>
										<td>
											<select name="data[closing]" class="form-control idfc" required>
												<option idfc_val=2 <?= ($idfc_new['closing']=="Yes")?"selected":""?> value='Yes'>Yes</option>
												<option idfc_val=2 <?= ($idfc_new['closing']=="No")?"selected":""?> value='No'>No</option>
												<option idfc_val=0 <?= ($idfc_new['closing']=="N/A")?"selected":""?> value='N/A'>N/A</option>
											</select>
										</td>
										<td>
											<p>
											<strong>Yes:</strong> Thanking the customer as per script  
											<br/><strong>No:</strong> Did not thank the customer
											</p>
										</td>
										<td colspan=2><input type="text" value="<?= $idfc_new['cmt29']?>" name="data[cmt29]" class="form-control"></td>
									</tr>
									<tr>
										<td>Call Summary:</td>
										<td colspan=2><textarea class="form-control" id="" name="data[call_summary]"><?php echo $idfc_new['call_summary'] ?></textarea></td>
										<td>Feedback:</td>
										<td colspan=2><textarea class="form-control" id="" name="data[feedback]"><?php echo $idfc_new['feedback'] ?></textarea></td>
									</tr>
									<tr>
										<td colspan="2">Upload Files</td>
										<?php if($idfc_id==0){ ?>
											<td colspan=4><input type="file" multiple class="form-control" id="attach_file" name="attach_file[]"></td>
										<?php }else{ 
											if($idfc_new['attach_file']!=''){ ?>
											<td colspan="4">
												<?php $attach_file = explode(",",$idfc_new['attach_file']);
												 foreach($attach_file as $mp){ ?>
													<audio controls='' style="background-color:#607F93"> 
													  <source src="<?php echo base_url(); ?>qa_files/qa_idfc/idfc_new/<?php echo $mp; ?>" type="audio/ogg">
													  <source src="<?php echo base_url(); ?>qa_files/qa_idfc/idfc_new/<?php echo $mp; ?>" type="audio/mpeg">
													</audio> </br>
												 <?php } ?>
											</td>
										<?php }else{
												echo '<td><b>No Files</b></td>';
											  }
										} ?>
									</tr>
									
									<?php if($idfc_id!=0){ ?>
										<tr><td colspan=2 style="font-size:16px; font-weight:bold">Agent Review:</td><td colspan=4><?php echo $idfc_new['agent_rvw_note'] ?></td></tr>
										<tr><td colspan=2 style="font-size:16px; font-weight:bold">Management Review:</td><td colspan=4><?php echo $idfc_new['mgnt_rvw_note'] ?></td></tr>
										<tr><td colspan=2 style="font-size:16px; font-weight:bold">Client Review:</td><td colspan=4><?php echo $idfc_new['client_rvw_note'] ?></td></tr>
										
										<tr><td colspan=2  style="font-size:16px">Your Review</td><td colspan=4><textarea class="form-control1" style="width:100%" id="note" name="note" required></textarea></td></tr>
									<?php } ?>
									
									<?php 
									if($idfc_id==0){
										if(is_access_qa_module()==true || is_access_qa_operations_module()==true || is_quality_access_trainer()==true){ ?>
											<tr><td colspan=6><button class="btn btn-success waves-effect" type="submit" value="SAVE" name="btnSave" id="qaformsubmit" style="width:500px">SAVE</button></td></tr>
									<?php 
										} 
									}else{ 
										if(is_access_qa_module()==true || is_quality_access_trainer()==true){
											if(is_available_qa_feedback($idfc_new['entry_date'],72) == true){ ?>
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
