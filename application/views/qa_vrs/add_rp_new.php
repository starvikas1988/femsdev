
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

.eml2{
	font-size:24px;
	font-weight:bold;
	background-color:#05203E;
	color:white;
}

.eml1{
	font-size:20px;
	font-weight:bold;
	background-color:#AED6F1;
}

.emp2{
	font-size:16px; 
	font-weight:bold;
}

.seml{
	font-size:15px;
	font-weight:bold;
	background-color:#CCD1D1;
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
										<td colspan="6" id="theader" style="font-size:30px"><img src="<?php echo base_url(); ?>main_img/vrs.png"></td>
										<input type="hidden" name="audit_start_time" value="<?php echo CurrMySqlDate(); ?>">
									</tr>
									<tr>
										<td>QA Name:</td>
										<td><input type="text" class="form-control" value="<?php echo get_username(); ?>" disabled></td>
										<td>Audit Date:</td>
										<td><input type="text" class="form-control" value="<?php echo CurrDateMDY(); ?>" disabled></td>
										<td>Mobile No.:</td>
										<td><input type="text" class="form-control" id="phone" name="phone" onkeyup="checkDec(this);" required></td>
									</tr>
									<tr>
										<td>Agent:</td>
										<td colspan=2>
											<select class="form-control" id="agent_id" name="agent_id" required>
												<option value="">-Select-</option>
												<?php foreach($agentName as $row):  ?>
													<option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
												<?php endforeach; ?>
											</select>
										</td>
										<!--<td>Fusion ID:</td>
										<td><input type="text" class="form-control" id="fusion_id" disabled></td> -->
										<td>L1 Supervisor:</td>
										<td colspan=2>
											<select class="form-control" readonly id="tl_id" name="tl_id" required>
												<option value="">--Select--</option>
												<?php foreach($tlname as $tl): ?>
													<option value="<?php echo $tl['id']; ?>"><?php echo $tl['fname']." ".$tl['lname']; ?></option>
												<?php endforeach; ?>	
											</select>
										</td>
									</tr>
									<tr>
										<td style="font-weight:bold">Client:</td>
										<td><input type="text" class="form-control" id="" name="c_name" required></td>
										<td>Contact Date:</td>
										<td><input type="text" class="form-control" id="contact_date" name="call_date" required></td>
										<td>Contact Duration:</td>
										<td><input type="text" class="form-control" id="contact_duration" name="call_duration" required></td>
									</tr>
									<tr>
										<td>ACPT</td>
										<td>
											<select class="form-control" id="acpt" name="acpt" required>
												<option value="">-Select-</option>
												<option value="Agent">Agent</option>
												<option value="Customer">Customer</option>
												<option value="Process">Process</option>
												<option value="Technology">Technology</option>
											</select>
										</td>
										<td colspan=2>
											<select class="form-control" id="acpt_option" name="acpt_option" required></select>
										</td>
										<td colspan=2 class="acptoth">
											<input type="text" class="form-control" id="acpt_other" name="acpt_other">
										</td>
									</tr>
									<tr>
										<td>Audit Type:</td>
										<td>
											<select class="form-control" id="audit_type" name="audit_type" required>
												<option value="">-Select-</option>
												<option value="CQ Audit">CQ Audit</option>
												<option value="BQ Audit">BQ Audit</option>
												<option value="Calibration">Calibration</option>
												<option value="Pre-Certification Mock Call">Pre-Certification Mock Call</option>
												<option value="Certification Audit">Certification Audit</option>
												<option value="WOW Call">WOW Call</option>
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
										<td>
											<select class="form-control" id="voc" name="voc" required>
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
										<td>VSI Account:</td>
										<td><input type="text" class="form-control" id="vsi_account" name="vsi_account" required></td>
										<td style="font-size:15px; font-weight:bold">QA Type</td>
										<td style="font-size:15px; font-weight:bold">
											<select class="form-control" name="qa_type" required>
												<option value="">-Select-</option>
												<option value="Regular">Regular</option>
												<option value="Analysis">Analysis</option>
											</select>
										</td>
										<td>Call ID:</td>
										<td><input type="text" class="form-control" id="" name="call_id" required></td>
									</tr>
									<tr>
										<td colspan=5 style="font-size:18px; font-weight:bold; text-align:right">Overall Score:</td>
										<td style="font-size:18px; font-weight:bold"><input type="text" readonly class="form-control" id="overallScore" name="overall_score" value="100%"></td>
									</tr>
									<tr style="height:45px">
										<td class="eml2">Category</td>
										<td class="eml2" colspan=3>Sub Category</td>
										<td class="eml2" style="width:150px">Status</td>
										<td class="eml2" style="width:150px">Scoring</td>
									</tr>
									<tr>
										<td rowspan=9 class="eml1">Opening</td>
										<td class="eml" colspan=3 style="color:red">Identify himself/herself by first and last name at the beginning of the call? **SQ**</td>
										<td>
											<select class="form-control opening_score" id="o_fatal1" name="identifynameatbeginning" required>
												<option o_val=1.12 value="Yes">Yes</option>
												<option o_val=0 value="No">No</option>
												<option o_val=1.12 value="N/A">N/A</option>
											</select>
										</td>
										<td rowspan=8><input type="text" readonly class="form-control" id="totalOpening" name="openingscore"></td>
									</tr>
									<tr>
										<td class="eml" colspan=3 style="color:red">Provide the Quality Assurance Statement verbatim, before any specific account information was discussed?**SQ**</td>
										<td>
											<select class="form-control opening_score" id="o_fatal2" name="assurancetsatementverbatim" required>
												<option o_val=1.12 value="Yes">Yes</option>
												<option o_val=0 value="No">No</option>
												<option o_val=1.12 value="N/A">N/A</option>
											</select>
										</td>
									</tr>
									<tr>
										<td class="eml" colspan=3 style="color:red">State "Vital Recovery Services" with no deviation? **SQ**</td>
										<td>
											<select class="form-control opening_score" id="o_fatal3" name="VRSwithnodeviation" required>
												<option o_val=1.12 value="Yes">Yes</option>
												<option o_val=0 value="No">No</option>
												<option o_val=1.12 value="N/A">N/A</option>
											</select>
										</td>
									</tr>
									<tr>
										<td class="eml" colspan=3 style="color:red">Verify that he/she was speaking to a right party according to the client requirements (First and Last Name) and before providing the disclosures?</td>
										<td>
											<select class="form-control opening_score" id="o_fatal4" name="speakingtorightparty" required>
												<option o_val=1.12 value="Yes">Yes</option>
												<option o_val=0 value="No">No</option>
												<option o_val=1.12 value="N/A">N/A</option>
											</select>
										</td>
									</tr>
									<tr>
										<td class="eml" colspan=3 style="color:red">Verify one/two pieces of demographics information on an outbound call, and one/two pieces on an inbound call? 1) must abide by client requirements, 2) Must be completed before disclosures, 3) Exception on consumer fail to verify two pieces of demographics information/fail to verify complete address (missing street number, etc). ** Exception for GMF - Collector must receive information from Consumer, avoiding proactive verification.</td>
										<td>
											<select class="form-control opening_score" id="o_fatal5" name="demographicsinformation" required>
												<option o_val=1.12 value="Yes">Yes</option>
												<option o_val=0 value="No">No</option>
												<option o_val=1.12 value="N/A">N/A</option>
											</select>
										</td>
									</tr>
									<tr>
										<td class="eml" colspan=3 style="color:red">Provide the Mini Miranda disclosure verbatim, before any specific account information was discussed? **SQ**</td>
										<td>
											<select class="form-control opening_score" id="o_fatal6" name="minimirandadisclosure" required>
												<option o_val=1.12 value="Yes">Yes</option>
												<option o_val=0 value="No">No</option>
												<option o_val=1.12 value="N/A">N/A</option>
											</select>
										</td>
									</tr>
									<tr>
										<td class="eml" colspan=3 style="color:red">State the client name and the purpose of the communication?</td>
										<td>
											<select class="form-control opening_score" id="o_fatal7" name="statetheclientname" required>
												<option o_val=1.12 value="Yes">Yes</option>
												<option o_val=0 value="No">No</option>
												<option o_val=1.12 value="N/A">N/A</option>
											</select>
										</td>
									</tr>
									<tr>
										<td class="eml" colspan=3>Did the rep ask for callback permission as per Reg F policy?</td>
										<td>
											<select class="form-control opening_score" name="for_callback_permission" required>
												<option o_val=1.12 value="Yes">Yes</option>
												<option o_val=0 value="No">No</option>
												<option o_val=1.12 value="N/A">N/A</option>
											</select>
										</td>
									</tr>
									<tr>
										<td class="eml" colspan=3>Sate/Ask for balance due?</td>
										<td>
											<select class="form-control opening_score" id="" name="askforbalancedue" required>
												<option o_val=1.12 value="Yes">Yes</option>
												<option o_val=0 value="No">No</option>
												<option o_val=1.12 value="N/A">N/A</option>
											</select>
										</td>
									</tr>
									<tr>
										<td rowspan=6 class="eml1">Effort</td>
										<td class="eml" colspan=3>Ask for a reason for delinquency/intention to resolve the account?</td>
										<td>
											<select class="form-control effort_score" id="" name="reasonfordelinquency" required>
												<option e_val=4.17 value="Yes">Yes</option>
												<option e_val=0 value="No">No</option>
												<option e_val=4.17 value="N/A">N/A</option>
											</select>
										</td>
										<td rowspan=6><input type="text" readonly class="form-control" id="totalEffort" name="effortscore"></td>
									</tr>
									<tr>
										<td class="eml" colspan=3>Full and Complete information taken?</td>
										<td>
											<select class="form-control effort_score" id="" name="completeinformationtaken" required>
												<option e_val=4.17 value="Yes">Yes</option>
												<option e_val=0 value="No">No</option>
												<option e_val=4.17 value="N/A">N/A</option>
											</select>
										</td>
									</tr>
									<tr>
										<td class="eml" colspan=3>Ask for the payment over the phone?</td>
										<td>
											<select class="form-control effort_score" id="" name="askforpaymentonphone" required>
												<option e_val=4.17 value="Yes">Yes</option>
												<option e_val=0 value="No">No</option>
												<option e_val=4.17 value="N/A">N/A</option>
											</select>
										</td>
									</tr>
									<tr>
										<td class="eml" colspan=3>Ask for a post dated payment (except for the states MA or RI)?</td>
										<td>
											<select class="form-control effort_score" id="" name="askforpostdelaypayment" required>
												<option e_val=4.17 value="Yes">Yes</option>
												<option e_val=0 value="No">No</option>
												<option e_val=4.17 value="N/A">N/A</option>
											</select>
										</td>
									</tr>
									<tr>
										<td class="eml" colspan=3>Followed the previous conversations on the account for the follow-up call</td>
										<td>
											<select class="form-control effort_score" id="" name="accountforfollowupcall" required>
												<option e_val=4.17 value="Yes">Yes</option>
												<option e_val=0 value="No">No</option>
												<option e_val=4.17 value="N/A">N/A</option>
											</select>
										</td>
									</tr>
									<tr>
										<td class="eml" colspan=3>Able to take a promise to pay on the account?</td>
										<td>
											<select class="form-control effort_score" id="" name="promisetopayaccount" required>
												<option e_val=4.17 value="Yes">Yes</option>
												<option e_val=0 value="No">No</option>
												<option e_val=4.17 value="N/A">N/A</option>
											</select>
										</td>
									</tr>
									<tr>
										<td rowspan=6 class="eml1">Negotiation</td>
										<td class="eml" colspan=3>Offer to split the balance in part?</td>
										<td>
											<select class="form-control negotiation_score" id="" name="splitbalanceinpart" required>
												<option n_val=4.17 value="Yes">Yes</option>
												<option n_val=0 value="No">No</option>
												<option n_val=4.17 value="N/A">N/A</option>
											</select>
										</td>
										<td rowspan=6><input type="text" readonly class="form-control" id="totalNegotiation" name="negotiationscore"></td>
									</tr>
									<tr>
										<td class="eml" colspan=3>Offer a one/three/lump sum settlement appropriately?</td>
										<td>
											<select class="form-control negotiation_score" id="" name="offersumsettlement" required>
												<option n_val=4.17 value="Yes">Yes</option>
												<option n_val=0 value="No">No</option>
												<option n_val=4.17 value="N/A">N/A</option>
											</select>
										</td>
									</tr>
									<tr>
										<td class="eml" colspan=3>Offer a payment plan with significant down payment?</td>
										<td>
											<select class="form-control negotiation_score" id="" name="paymentplanwithpayment" required>
												<option n_val=4.17 value="Yes">Yes</option>
												<option n_val=0 value="No">No</option>
												<option n_val=4.17 value="N/A">N/A</option>
											</select>
										</td>
									</tr>
									<tr>
										<td class="eml" colspan=3>Did Collector follow proper negotiation sequence to provide settelment options?</td>
										<td>
											<select class="form-control negotiation_score" id="" name="collectorfollowpropernegotiation" required>
												<option n_val=4.17 value="Yes">Yes</option>
												<option n_val=0 value="No">No</option>
												<option n_val=4.17 value="N/A">N/A</option>
											</select>
										</td>
									</tr>
									<tr>
										<td class="eml" colspan=3>Did Collector try to negotiate effectively to convince the customer for payment?</td>
										<td>
											<select class="form-control negotiation_score" id="" name="collectortrynegotiatepayment" required>
												<option n_val=4.17 value="Yes">Yes</option>
												<option n_val=0 value="No">No</option>
												<option n_val=4.17 value="N/A">N/A</option>
											</select>
										</td>
									</tr>
									<tr>
										<td class="eml" colspan=3>Offer a small good faith payment?</td>
										<td>
											<select class="form-control negotiation_score" id="" name="offergoodfaithpayment" required>
												<option n_val=4.17 value="Yes">Yes</option>
												<option n_val=0 value="No">No</option>
												<option n_val=4.17 value="N/A">N/A</option>
											</select>
										</td>
									</tr>
									<tr>
										<td rowspan=16 class="eml1">Compliance</td>
										<td class="eml" colspan=3 style="color:red">Did not  Misrepresent their identity or authorization and status of the consumer's account?</td>
										<td>
											<select class="form-control compliance_score" id="c_fatal1" name="misrepresentidentity" required>
												<option c_val=0.625 value="Yes">Yes</option>
												<option c_val=0 value="No">No</option>
												<option c_val=0.625 value="N/A">N/A</option>
											</select>
										</td>
										<td rowspan=16><input type="text" readonly class="form-control" id="totalCompliance" name="compliancescore"></td>
									</tr>
									<tr>
										<td class="eml" colspan=3 style="color:red">Did not Discuss or imply that any type of legal actions - will be taken or property repossessed, also on time barred accounts amd Did not Threaten to take actions that VRS or the client cannot legally take?</td>
										<td>
											<select class="form-control compliance_score" id="c_fatal2" name="discussoflegalaction" required>
												<option c_val=0.625 value="Yes">Yes</option>
												<option c_val=0 value="No">No</option>
												<option c_val=0.625 value="N/A">N/A</option>
											</select>
										</td>
									</tr>
									<tr>
										<td class="eml" colspan=3 style="color:red">Did not Make any false representations regarding the nature of the communication?</td>
										<td>
											<select class="form-control compliance_score" id="c_fatal3" name="makeanyfalserepresentation" required>
												<option c_val=0.625 value="Yes">Yes</option>
												<option c_val=0 value="No">No</option>
												<option c_val=0.625 value="N/A">N/A</option>
											</select>
										</td>
									</tr>
									<tr>
										<td class="eml" colspan=3 style="color:red">Did not Contact the consumer at any unusual times (sate regulations) or outside the hours of 8:00 am and 9:00 pm at the consumer's location?</td>
										<td>
											<select class="form-control compliance_score" id="c_fatal4" name="contactcustomerusualtime" required>
												<option c_val=0.625 value="Yes">Yes</option>
												<option c_val=0 value="No">No</option>
												<option c_val=0.625 value="N/A">N/A</option>
											</select>
										</td>
									</tr>
									<tr>
										<td class="eml" colspan=3 style="color:red">Did not Communicate with the consumer at work if it is known or there is reason to know that such calls are prohibited?</td>
										<td>
											<select class="form-control compliance_score" id="c_fatal5" name="communicateconsumeratwork" required>
												<option c_val=0.625 value="Yes">Yes</option>
												<option c_val=0 value="No">No</option>
												<option c_val=0.625 value="N/A">N/A</option>
											</select>
										</td>
									</tr>
									<tr>
										<td class="eml" colspan=3 style="color:red">Did not Communicate with the consumer after learning the consumer is represented by an attorney, filed for bankruptcy unless a permissible reason exists?</td>
										<td>
											<select class="form-control compliance_score" id="c_fatal6" name="communicateconsumeranattorney" required>
												<option c_val=0.625 value="Yes">Yes</option>
												<option c_val=0 value="No">No</option>
												<option c_val=0.625 value="N/A">N/A</option>
											</select>
										</td>
									</tr>
									<tr>
										<td class="eml" colspan=3 style="color:red">Adhere to the cell phone policy/TCPA regulations and policy regarding contacting consumers via cell phone, email and fax?</td>
										<td>
											<select class="form-control compliance_score" id="c_fatal7" name="adheretocellphonepolicy" required>
												<option c_val=0.625 value="Yes">Yes</option>
												<option c_val=0 value="No">No</option>
												<option c_val=0.625 value="N/A">N/A</option>
											</select>
										</td>
									</tr>
									<tr>
										<td class="eml" colspan=3 style="color:red">Adhere to policy regarding third parties for the sole purpose of obtaining location information for the consumer?</td>
										<td>
											<select class="form-control compliance_score" id="c_fatal8" name="adhereto3rdpartypolicy" required>
												<option c_val=0.625 value="Yes">Yes</option>
												<option c_val=0 value="No">No</option>
												<option c_val=0.625 value="N/A">N/A</option>
											</select>
										</td>
									</tr>
									<tr>
										<td class="eml" colspan=3 style="color:red">Enter Status code/disposition codes correctly to ensure that inappropriate dialing does not take place?</td>
										<td>
											<select class="form-control compliance_score" id="c_fatal9" name="enterstatuscodecorrectly" required>
												<option c_val=0.625 value="Yes">Yes</option>
												<option c_val=0 value="No">No</option>
												<option c_val=0.625 value="N/A">N/A</option>
											</select>
										</td>
									</tr>
									<tr>
										<td class="eml" colspan=3 style="color:red">Did not Make any statement that could constitute unfair, deceptive, or abusive acts or practices that may raise UDAAP concerns?</td>
										<td>
											<select class="form-control compliance_score" id="c_fatal10" name="raiseUDAAPconcerns" required>
												<option c_val=0.625 value="Yes">Yes</option>
												<option c_val=0 value="No">No</option>
												<option c_val=0.625 value="N/A">N/A</option>
											</select>
										</td>
									</tr>
									<tr>
										<td class="eml" colspan=3 style="color:red">Did not Communicate or threaten to communicate false credit information or information which should be known to be false and utilized the proper CBR script whenever a consumer enquires about that?</td>
										<td>
											<select class="form-control compliance_score" id="c_fatal11" name="communicatefalsecreditinformation" required>
												<option c_val=0.625 value="Yes">Yes</option>
												<option c_val=0 value="No">No</option>
												<option c_val=0.625 value="N/A">N/A</option>
											</select>
										</td>
									</tr>
									<tr>
										<td class="eml" colspan=3 style="color:red">Handle the consumer's dispute correctly and take appropriate action including providing the consumer with the correct contact information to submit a written dispute or complaint, or offer to escalate the call?</td>
										<td>
											<select class="form-control compliance_score" id="c_fatal12" name="handleconsumerdispute" required>
												<option c_val=0.625 value="Yes">Yes</option>
												<option c_val=0 value="No">No</option>
												<option c_val=0.625 value="N/A">N/A</option>
											</select>
										</td>
									</tr>
									<tr>
										<td class="eml" colspan=3 style="color:red">Did not Make the required statement on time barred accounts, indicating that the consumer cannot be pursued with legal action?</td>
										<td>
											<select class="form-control compliance_score" id="c_fatal13" name="maketimebarredaccounts" required>
												<option c_val=0.625 value="Yes">Yes</option>
												<option c_val=0 value="No">No</option>
												<option c_val=0.625 value="N/A">N/A</option>
											</select>
										</td>
									</tr>
									<tr>
										<td class="eml" colspan=3 style="color:red">Adhere to FDCPA  laws?</td>
										<td>
											<select class="form-control compliance_score" id="c_fatal14" name="adhereFDCPAlaws" required>
												<option c_val=0.625 value="Yes">Yes</option>
												<option c_val=0 value="No">No</option>
												<option c_val=0.625 value="N/A">N/A</option>
											</select>
										</td>
									</tr>
									<tr>
										<td class="eml" colspan=3 style="color:red">Did not Make any statement that could be considered discriminatory towards a consumer or a violation of VRS ECOA policy?</td>
										<td>
											<select class="form-control compliance_score" id="c_fatal15" name="discriminatoryECOApolicy" required>
												<option c_val=0.625 value="Yes">Yes</option>
												<option c_val=0 value="No">No</option>
												<option c_val=0.625 value="N/A">N/A</option>
											</select>
										</td>
									</tr>
									<tr>
										<td class="eml" colspan=3 style="color:red">Did the collectors adhere to the State Restrictions?</td>
										<td>
											<select class="form-control compliance_score" id="c_fatal16" name="adherestaterestriction" required>
												<option c_val=0.625 value="Yes">Yes</option>
												<option c_val=0 value="No">No</option>
												<option c_val=0.625 value="N/A">N/A</option>
											</select>
										</td>
									</tr>
									<tr>
										<td rowspan=10 class="eml1">Payment Script</td>
										<td class="eml" colspan=3>Confirm with consumer if he/she is the authorized user of the debit or credit card / checking account?</td>
										<td>
											<select class="form-control pscript_score" id="" name="confirmauthoriseduser" required>
												<option ps_val=1 value="Yes">Yes</option>
												<option ps_val=0 value="No">No</option>
												<option ps_val=1 value="N/A">N/A</option>
											</select>
										</td>
										<td rowspan=7><input type="text" readonly class="form-control" id="totalPaymentScript" name="paymentscriptscore"></td>
									</tr>
									<tr>
										<td class="eml" colspan=3>Recap the call by verifying consumer's Name, Address, CC/AP information?</td>
										<td>
											<select class="form-control pscript_score" id="" name="recapthecallverify" required>
												<option ps_val=1 value="Yes">Yes</option>
												<option ps_val=0 value="No">No</option>
												<option ps_val=1 value="N/A">N/A</option>
											</select>
										</td>
									</tr>
									<tr>
										<td class="eml" colspan=3>Stated the proper payment script before processing payment?</td>
										<td>
											<select class="form-control pscript_score" id="" name="properpaymentscript" required>
												<option ps_val=1 value="Yes">Yes</option>
												<option ps_val=0 value="No">No</option>
												<option ps_val=1 value="N/A">N/A</option>
											</select>
										</td>
									</tr>
									<tr>
										<td class="eml" colspan=3 style="color:red">Advise of the payment processing fee before the payment was taken, and take appropriate steps if the consumer pushed back? **SQ**</td>
										<td>
											<select class="form-control pscript_score" id="ps_fatal1" name="paymentprocessingfee" required>
												<option ps_val=1 value="Yes">Yes</option>
												<option ps_val=0 value="No">No</option>
												<option ps_val=1 value="N/A">N/A</option>
											</select>
										</td>
									</tr>
									<tr>
										<td class="eml" colspan=3 style="color:red">Obtain permission from the consumer to initiate electronic credit /debit card transactions or through checking account and get supervisor verification if needed?**SQ**</td>
										<td>
											<select class="form-control pscript_score" id="ps_fatal2" name="obtainpermissionfromconsumer" required>
												<option ps_val=1 value="Yes">Yes</option>
												<option ps_val=0 value="No">No</option>
												<option ps_val=1 value="N/A">N/A</option>
											</select>
										</td>
									</tr>
									<tr>
										<td class="eml" colspan=3>Did the Collector update Consumer on payment reminder, BIF / SIF Letters?</td>
										<td>
											<select class="form-control pscript_score" id="" name="update_consumer_on_payment" required>
												<option ps_val=1 value="Yes">Yes</option>
												<option ps_val=0 value="No">No</option>
												<option ps_val=1 value="N/A">N/A</option>
											</select>
										</td>
									</tr>
									<tr>
										<td class="eml" colspan=3>Educate the consumer about correspondence being sent (Receipts, PIF, SIF, Confirmations, etc)?</td>
										<td>
											<select class="form-control pscript_score" id="" name="educatetheconsumer" required>
												<option ps_val=1 value="Yes">Yes</option>
												<option ps_val=0 value="No">No</option>
												<option ps_val=1 value="N/A">N/A</option>
											</select>
										</td>
									</tr>
									<tr>
										<td class="eml" colspan=3>Provide the consumer with the confirmation code?</td>
										<td>
											<select class="form-control pscript_score" id="" name="consumerconfirmationcode" required>
												<option ps_val=1 value="Yes">Yes</option>
												<option ps_val=0 value="No">No</option>
												<option ps_val=1 value="N/A">N/A</option>
											</select>
										</td>
									</tr>
									<tr>
										<td class="eml" colspan=3>In case of PDCs, did the Collector asks for permission to call the Consumer back if it is declined or there is an issue with the payment?</td>
										<td>
											<select class="form-control pscript_score" id="" name="in_case_of_pdcs" required>
												<option ps_val=1 value="Yes">Yes</option>
												<option ps_val=0 value="No">No</option>
												<option ps_val=1 value="N/A">N/A</option>
											</select>
										</td>
									</tr>
									<tr>
										<td class="eml" colspan=3>Did the Collector ask for permission to call Consumers back if they do not hear from the Consumers by that specific date and time for PTPs? </td>
										<td>
											<select class="form-control pscript_score" id="" name="collector_ask_for_permission" required>
												<option ps_val=1 value="Yes">Yes</option>
												<option ps_val=0 value="No">No</option>
												<option ps_val=1 value="N/A">N/A</option>
											</select>
										</td>
									</tr>
									<tr>
										<td rowspan=3 class="eml1">Call Control</td>
										<td class="eml" colspan=3>Demonstrate Active Listening?</td>
										<td>
											<select class="form-control callcontrol_score" id="" name="demonstrateactivelistening" required>
												<option cc_val=1.67 value="Yes">Yes</option>
												<option cc_val=0 value="No">No</option>
												<option cc_val=1.67 value="N/A">N/A</option>
											</select>
										</td>
										<td rowspan=3><input type="text" readonly class="form-control" id="totalCallControl" name="callcontrolscore"></td>
									</tr>
									<tr>
										<td class="eml" colspan=3>Represent the company and the client in a positive manner?</td>
										<td>
											<select class="form-control callcontrol_score" id="" name="representclientandcompany" required>
												<option cc_val=1.67 value="Yes">Yes</option>
												<option cc_val=0 value="No">No</option>
												<option cc_val=1.67 value="N/A">N/A</option>
											</select>
										</td>
									</tr>
									<tr>
										<td class="eml" colspan=3>Anticipate and overcome objections?</td>
										<td>
											<select class="form-control callcontrol_score" id="" name="anticipateovercomeobjection" required>
												<option cc_val=1.67 value="Yes">Yes</option>
												<option cc_val=0 value="No">No</option>
												<option cc_val=1.67 value="N/A">N/A</option>
											</select>
										</td>
									</tr>
									<tr>
										<td rowspan=4 class="eml1">Closing</td>
										<td class="eml" colspan=3>Summarize the call?</td>
										<td>
											<select class="form-control closing_score" id="" name="summarizethecall" required>
												<option cl_val=1.25 value="Yes">Yes</option>
												<option cl_val=0 value="No">No</option>
												<option cl_val=1.25 value="N/A">N/A</option>
											</select>
										</td>
										<td rowspan=4><input type="text" readonly class="form-control" id="totalClosing" name="closingscore"></td>
									</tr>
									<tr>
										<td class="eml" colspan=3>Provided VRS call back number?</td>
										<td>
											<select class="form-control closing_score" id="" name="provideVRScallbacknumber" required>
												<option cl_val=1.25 value="Yes">Yes</option>
												<option cl_val=0 value="No">No</option>
												<option cl_val=1.25 value="N/A">N/A</option>
											</select>
										</td>
									</tr>
									<tr>
										<td class="eml" colspan=3>Set appropriate timelines and expectations for follow up?</td>
										<td>
											<select class="form-control closing_score" id="" name="setappropiatetimeline" required>
												<option cl_val=1.25 value="Yes">Yes</option>
												<option cl_val=0 value="No">No</option>
												<option cl_val=1.25 value="N/A">N/A</option>
											</select>
										</td>
									</tr>
									<tr>
										<td class="eml" colspan=3>Close the call Professionally?</td>
										<td>
											<select class="form-control closing_score" id="" name="closecallprofessionally" required>
												<option cl_val=1.25 value="Yes">Yes</option>
												<option cl_val=0 value="No">No</option>
												<option cl_val=1.25 value="N/A">N/A</option>
											</select>
										</td>
									</tr>
									<tr>
										<td rowspan=8 class="eml1">Documentation</td>
										<td class="eml" colspan=3>Use the proper action code?</td>
										<td>
											<select class="form-control document_score" name="useproperactioncode" required>
												<option d_val=1.25 value="Yes">Yes</option>
												<option d_val=0 value="No">No</option>
												<option d_val=1.25 value="N/A">N/A</option>
											</select>
										</td>
										<td rowspan=7><input type="text" readonly class="form-control" id="totalDocument" name="documentationscore"></td>
									</tr>
									<tr>
										<td class="eml" colspan=3 style="color:red">Use the proper result code?</td>
										<td>
											<select class="form-control document_score" id="d_fatal2" name="useproperresultcode" required>
												<option d_val=1.25 value="Yes">Yes</option>
												<option d_val=0 value="No">No</option>
												<option d_val=1.25 value="N/A">N/A</option>
											</select>
										</td>
									</tr>
									<tr>
										<td class="eml" colspan=3 style="color:red">Document thoroughly the context of the conversation?</td>
										<td>
											<select class="form-control document_score" id="d_fatal3" name="contextoftheconversation" required>
												<option d_val=1.25 value="Yes">Yes</option>
												<option d_val=0 value="No">No</option>
												<option d_val=1.25 value="N/A">N/A</option>
											</select>
										</td>
									</tr>
									<tr>
										<td class="eml" colspan=3>Did the rep document the callback permission on the account as per Reg F policy?</td>
										<td>
											<select class="form-control document_score" name="document_the_callback" required>
												<option d_val=1.25 value="Yes">Yes</option>
												<option d_val=0 value="No">No</option>
												<option d_val=1.25 value="N/A">N/A</option>
											</select>
										</td>
									</tr>
									<tr>
										<td class="eml" colspan=3 style="color:red">Remove any phone numbers known to be incorrect?**SQ**</td>
										<td>
											<select class="form-control document_score" id="d_fatal4" name="removeanyphonenumber" required>
												<option d_val=1.25 value="Yes">Yes</option>
												<option d_val=0 value="No">No</option>
												<option d_val=1.25 value="N/A">N/A</option>
											</select>
										</td>
									</tr>
									<tr>
										<td class="eml" colspan=3 style="color:red">Update address information if appropriate?**SQ**</td>
										<td>
											<select class="form-control document_score" id="d_fatal5" name="updateaddressinformation" required>
												<option d_val=1.25 value="Yes">Yes</option>
												<option d_val=0 value="No">No</option>
												<option d_val=1.25 value="N/A">N/A</option>
											</select>
										</td>
									</tr>
									<tr>
										<td class="eml" colspan=3 style="color:red">Change the status of the account, if appropriate?**SQ**</td>
										<td>
											<select class="form-control document_score" id="d_fatal6" name="changestateofAccount" required>
												<option d_val=1.25 value="Yes">Yes</option>
												<option d_val=0 value="No">No</option>
												<option d_val=1.25 value="N/A">N/A</option>
											</select>
										</td>
									</tr>
									<tr>
										<td class="eml" colspan=3>Escalate the account to a supervisor for handling, if appropriate?/ Escalate the account to a supervisor for handling, if appropriate?</td>
										<td>
											<select class="form-control document_score" id="" name="superviserforhandle" required>
												<option d_val=1.25 value="Yes">Yes</option>
												<option d_val=0 value="No">No</option>
												<option d_val=1.25 value="N/A">N/A</option>
											</select>
										</td>
									</tr>
									<tr>
										<td colspan=2>Call Summary:</td>
										<td colspan=4><textarea class="form-control" name="call_summary"></textarea></td>
									</tr>
									<tr>
										<td colspan=2>Feedback:</td>
										<td colspan=4><textarea class="form-control" name="feedback"></textarea></td>
									</tr>
									<tr>
										<td colspan=2>Upload Audio File [mp3|mp4|wav|m4a]:</td>
										<td colspan=4><input type="file" multiple class="form-control" id="attach_file" name="attach_file[]"></td>
									</tr>
									<?php if(is_access_qa_module()==true){ ?>
									<tr>
										<td colspan=6><button class="btn btn-success waves-effect" type="submit" id="qaformsubmit" style="width:500px">SAVE</button></td>
									</tr>
									<?php } ?>
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
