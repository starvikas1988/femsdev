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
										<td colspan=6 id="theader" style="font-size:30px">OCTA FX</td>
										<?php
										if($oc_id==0){
											$auditorName = get_username();
											$auditDate = CurrDateMDY();
											$clDate_val='';
										}else{
											if($octafx['entry_by']!=''){
												$auditorName = $octafx['auditor_name'];
											}else{
												$auditorName = $octafx['client_name'];
											}
											$auditDate = mysql2mmddyy($octafx['audit_date']);
											$clDate_val = mysql2mmddyy($octafx['call_date']);
										}
									?>
										<input type="hidden" name="audit_start_time" value="<?php echo CurrMySqlDate(); ?>">
									</tr>
									<tr>
										<td>QA Name:</td>
										<td><input type="text" class="form-control" value="<?php echo $auditorName; ?>" disabled></td>
										<td>Audit Date:</td>
										<td><input type="text" class="form-control" value="<?php echo $auditDate; ?>" disabled></td>
										<td>Call Date:</td>
										<td><input type="text" class="form-control" id="call_date" name="call_date" value="<?php echo $clDate_val; ?>" required></td>
									</tr>
									<tr>
										<td>Agent:</td>
										<td>
											<select class="form-control agentName" id="agent_id" name="data[agent_id]" required>
												<option value="<?php echo $octafx['agent_id'] ?>"><?php echo $octafx['fname']." ".$octafx['lname'] ?></option>
												<option value="">-Select-</option>
												<?php foreach($agentName as $row):  ?>
													<option value="<?php echo $row['id']; ?>"><?php echo $row['name'].' ('.$row['fusion_id'].')'; ?></option>
												<?php endforeach; ?>
											</select>
										</td>
										<td>Fusion ID:</td>
										<td><input type="text" readonly class="form-control" id="fusion_id" name="" value="<?php echo $octafx['fusion_id'] ?>"></td>
										<td>L1 Supervisor:</td>
										<td>
											<select class="form-control" id="tl_id" name="data[tl_id]" readonly>
												<option value="<?php echo $octafx['tl_id'] ?>"><?php echo $octafx['tl_name'] ?></option>
												<option value="">--Select--</option>
												<?php foreach($tlname as $tl): ?>
													<option value="<?php echo $tl['id']; ?>"><?php echo $tl['fname']." ".$tl['lname']; ?></option>
												<?php endforeach; ?>	
											</select>
										</td>
									</tr>
									<tr>
										<td>Transaction/Ticket ID:</td>
										<td><input type="text" class="form-control" name="data[ticket_id]" value="<?php echo $octafx['ticket_id'] ?>" required></td>
										<td>Call Duration:</td>
										<td><input type="text" class="form-control" id="call_duration" name="data[call_duration]" value="<?php echo $octafx['call_duration'] ?>" required></td>
										<td>Contact Dtails:</td>
										<td><input type="number" class="form-control" name="data[contact]" value="<?php echo $octafx['contact'] ?>" required></td>
									</tr>
									<tr>
										<td>Team:</td>
										<td>
											<select class="form-control" name="data[team]" required>
												<option value="">-Select-</option>
												<option <?php echo $octafx['team']=='India'?"selected":""; ?> value="India">India</option>
												<option <?php echo $octafx['team']=='Malay'?"selected":""; ?> value="Malay">Malay</option>
											</select>
										</td>
										<td>Language:</td>
										<td>
											<select class="form-control" name="data[language]" required>
												<option value="">-Select-</option>
												<option <?php echo $octafx['language']=='English'?"selected":""; ?> value="English">English</option>
												<option <?php echo $octafx['language']=='Hindi'?"selected":""; ?> value="Hindi">Hindi</option>
												<option <?php echo $octafx['language']=='Others'?"selected":""; ?> value="Others">Others</option>
											</select>
										</td>
										<td>ACPT:</td>
										<td>
											<select class="form-control" name="data[acpt]" required>
												<option value="">-Select-</option>
												<option <?php echo $octafx['acpt']=='Agent'?"selected":""; ?> value="Agent">Agent</option>
												<option <?php echo $octafx['acpt']=='Client'?"selected":""; ?> value="Client">Client</option>
												<option <?php echo $octafx['acpt']=='Process'?"selected":""; ?> value="Process">Process</option>
												<option <?php echo $octafx['acpt']=='Technology'?"selected":""; ?> value="Technology">Technology</option>
											</select>
										</td>
									</tr>
									<tr>
										<td>Week:</td>
										<td>
											<select class="form-control" name="data[week]" required>
												<option value="<?php echo $octafx['week'] ?>"><?php echo $octafx['week'] ?></option>
												<option value="">-Select-</option>
												<option value="Week1">Week1</option>
												<option value="Week2">Week2</option>
												<option value="Week3">Week3</option>
												<option value="Week4">Week4</option>
											</select>
										</td>
										<!--<td>Call Type 1:</td>
										<td>
											<select class="form-control octafx_point1 call_type1" id="call_type1" name="data[call_type1]" required>
												<option value="">-Select-</option>
												<option ofx_val=0 ofx_max=0 <?php echo $octafx['call_type1']=='Successful Deposit Call'?"selected":""; ?> value="Successful Deposit Call">Successful Deposit Call</option>
												<option ofx_val=0 ofx_max=0 <?php echo $octafx['call_type1']=='Unsuccessful Deposit Call'?"selected":""; ?> value="Unsuccessful Deposit Call">Unsuccessful Deposit Call</option>
											</select>
										</td>-->
										<td>Lead Type:</td>
										<td>
											<select class="form-control" name="data[call_type2]" required>
												<option value="">-Select-</option>
												<option <?php echo $octafx['call_type2']=='Fresh Lead'?"selected":""; ?> value="Fresh Lead">Fresh Lead</option>
												<option <?php echo $octafx['call_type2']=='Follow up'?"selected":""; ?> value="Follow up">Follow up</option>
											</select>
										</td>
									</tr>
									<tr>
										<td>Audit Type:</td>
										<td>
											<select class="form-control" id="audit_type" name="data[audit_type]" required>
												<option value="<?php echo $octafx['audit_type'] ?>"><?php echo $octafx['audit_type'] ?></option>
												<option value="">-Select-</option>
												<option value="CQ Audit">CQ Audit</option>
												<option value="BQ Audit">BQ Audit</option>
												<option value="Calibration">Calibration</option>
												<option value="Pre-Certification Mock Call">Pre-Certification Mock Call</option>
												<option value="Certification Audit">Certification Audit</option>
												<option value="Operation Audit">Operation Audit</option>
												<option value="Trainer Audit">Trainer Audit</option>
											</select>
										</td>
										<td class="auType">Auditor Type</td>
										<td class="auType">
											<select class="form-control" id="auditor_type" name="data[auditor_type]">
												<option value="<?php echo $octafx['auditor_type'] ?>"><?php echo $octafx['auditor_type'] ?></option>
												<option value="">-Select-</option>
												<option value="Master">Master</option>
												<option value="Regular">Regular</option>
											</select>
										</td>
										<td>VOC:</td>
										<td>
											<select class="form-control" id="voc" name="data[voc]" required>
												<option value="<?php echo $octafx['voc'] ?>"><?php echo $octafx['voc'] ?></option>
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
										<td style="font-weight:bold; font-size:16px">Earned Score:</td>
										<td><input type="text" readonly id="octa_earned" name="data[earned_score]" class="form-control" style="font-weight:bold" value="<?php echo $octafx['earned_score'] ?>"></td>
										<td style="font-weight:bold; font-size:16px">Possible Score:</td>
										<td><input type="text" readonly id="octa_possible" name="data[possible_score]" class="form-control" style="font-weight:bold" value="<?php echo $octafx['possible_score'] ?>"></td>
										<td style="font-weight:bold; font-size:16px; text-align:right">Overall Score:</td>
										<td><input type="text" readonly id="octa_overall" name="data[overall_score]" class="form-control octafxFatal" style="font-weight:bold" value="<?php echo $octafx['overall_score'] ?>"></td>
									</tr>
									
									<tr style="background-color:#A9CCE3; font-weight:bold"><td colspan=2>Criteria</td><td>Status</td><td colspan=3>Reason</td></tr>
									<tr>
										<td colspan=2>Preparation</td>
										<td>
											<select class="form-control" id="preparation" name="data[preparation]" required>
												<option value="">-Select-</option>
												<option <?php echo $octafx['preparation']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option <?php echo $octafx['preparation']=='No'?"selected":""; ?> value="No">No</option>
											</select>
										</td>
										<td colspan=3>
											<select class="form-control octafx_point" id="preparation_reason" name="data[preparation_reason]" required>
												<option value="<?php echo $octafx['preparation_reason']; ?>"><?php echo $octafx['preparation_reason']; ?></option>
											</select>
										</td>
									</tr>
									<tr>
										<td colspan=2>Introduction</td>
										<td>
											<select class="form-control" id="introduction" name="data[introduction]" required>
												<option value="">-Select-</option>
												<option <?php echo $octafx['introduction']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option <?php echo $octafx['introduction']=='No'?"selected":""; ?> value="No">No</option>
											</select>
										</td>
										<td colspan=3>
											<select class="form-control octafx_point" id="introduction_reason" name="data[introduction_reason]" required>
												<option value="<?php echo $octafx['introduction_reason']; ?>"><?php echo $octafx['introduction_reason']; ?></option>
											</select>
										</td>
									</tr>
									<tr>
										<td colspan=2>Profiling</td>
										<td>
											<select class="form-control" id="profiling" name="data[profiling]" required>
												<option value="">-Select-</option>
												<option <?php echo $octafx['profiling']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option <?php echo $octafx['profiling']=='No'?"selected":""; ?> value="No">No</option>
												<option <?php echo $octafx['profiling']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=3>
											<select class="form-control octafx_point" id="profiling_reason" name="data[profiling_reason]" required>
												<option value="<?php echo $octafx['profiling_reason']; ?>"><?php echo $octafx['profiling_reason']; ?></option>
											</select>
										</td>
									</tr>
									<tr>
										<td colspan=2>Delivery</td>
										<td>
											<select class="form-control" id="delivary" name="data[delivary]" required>
												<option value="">-Select-</option>
												<option <?php echo $octafx['delivary']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option <?php echo $octafx['delivary']=='No'?"selected":""; ?> value="No">No</option>
												<option <?php echo $octafx['delivary']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=3>
											<select class="form-control octafx_point" id="delivary_reason" name="data[delivary_reason]" required>
												<option value="<?php echo $octafx['delivary_reason']; ?>"><?php echo $octafx['delivary_reason']; ?></option>
											</select>
										</td>
									</tr>
									<tr>
										<td colspan=2>Objections</td>
										<td>
											<select class="form-control" id="objection" name="data[objection]" required>
												<option value="">-Select-</option>
												<option <?php echo $octafx['objection']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option <?php echo $octafx['objection']=='No'?"selected":""; ?> value="No">No</option>
												<option <?php echo $octafx['objection']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=3>
											<select class="form-control octafx_point" id="objection_reason" name="data[objection_reason]" required>
												<option value="<?php echo $octafx['objection_reason']; ?>"><?php echo $octafx['objection_reason']; ?></option>
											</select>
										</td>
									</tr>
									<tr>
										<td colspan=2>Closing</td>
										<td>
											<select class="form-control" id="closing" name="data[closing]" required>
												<option value="">-Select-</option>
												<option <?php echo $octafx['closing']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option <?php echo $octafx['closing']=='No'?"selected":""; ?> value="No">No</option>
												<option <?php echo $octafx['closing']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=3>
											<select class="form-control octafx_point" id="closing_reason" name="data[closing_reason]" required>
												<option value="<?php echo $octafx['closing_reason']; ?>"><?php echo $octafx['closing_reason']; ?></option>
											</select>
										</td>
									</tr>
									<tr>
										<td colspan=2>Conclusion</td>
										<td>
											<select class="form-control" id="conclusion" name="data[conclusion]" required>
												<option value="">-Select-</option>
												<option <?php echo $octafx['conclusion']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option <?php echo $octafx['conclusion']=='No'?"selected":""; ?> value="No">No</option>
											</select>
										</td>
										<td colspan=3>
											<select class="form-control octafx_point" id="conclusion_reason" name="data[conclusion_reason]" required>
												<option value="<?php echo $octafx['conclusion_reason']; ?>"><?php echo $octafx['conclusion_reason']; ?></option>
											</select>
										</td>
									</tr>
									<tr>
										<td colspan=2>Follow-up</td>
										<td>
											<select class="form-control" id="follow_up" name="data[follow_up]" required>
												<option value="">-Select-</option>
												<option <?php echo $octafx['follow_up']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option <?php echo $octafx['follow_up']=='No'?"selected":""; ?> value="No">No</option>
											</select>
										</td>
										<td colspan=3>
											<select class="form-control octafx_point" id="follow_up_reason" name="data[follow_up_reason]" required>
												<option value="<?php echo $octafx['follow_up_reason']; ?>"><?php echo $octafx['follow_up_reason']; ?></option>
											</select>
										</td>
									</tr>
									<tr>
										<td colspan=2>Clear explanation of products and services to client</td>
										<td>
											<select class="form-control" id="product_explanation" name="data[product_explanation]" required>
												<option value="">-Select-</option>
												<option <?php echo $octafx['product_explanation']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option <?php echo $octafx['product_explanation']=='No'?"selected":""; ?> value="No">No</option>
											</select>
										</td>
										<td colspan=3>
											<select class="form-control octafx_point" id="product_explanation_reason" name="data[product_explanation_reason]" required>
												<option value="<?php echo $octafx['product_explanation_reason']; ?>"><?php echo $octafx['product_explanation_reason']; ?></option>
											</select>
										</td>
									</tr>
									<tr>
										<td colspan=2>Rapport</td>
										<td>
											<select class="form-control" id="rapport" name="data[rapport]" required>
												<option value="">-Select-</option>
												<option <?php echo $octafx['rapport']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option <?php echo $octafx['rapport']=='No'?"selected":""; ?> value="No">No</option>
											</select>
										</td>
										<td colspan=3>
											<select class="form-control octafx_point" id="rapport_reason" name="data[rapport_reason]" required>
												<option value="<?php echo $octafx['rapport_reason']; ?>"><?php echo $octafx['rapport_reason']; ?></option>
											</select>
										</td>
									</tr>
									<tr>
										<td colspan=2>Clarity</td>
										<td>
											<select class="form-control" id="clarity" name="data[clarity]" required>
												<option value="">-Select-</option>
												<option <?php echo $octafx['clarity']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option <?php echo $octafx['clarity']=='No'?"selected":""; ?> value="No">No</option>
											</select>
										</td>
										<td colspan=3>
											<select class="form-control octafx_point" id="clarity_reason" name="data[clarity_reason]" required>
												<option value="<?php echo $octafx['clarity_reason']; ?>"><?php echo $octafx['clarity_reason']; ?></option>
											</select>
										</td>
									</tr>
									<tr>
										<td colspan=2>Enthusiasm</td>
										<td>
											<select class="form-control" id="enthusiasm" name="data[enthusiasm]" required>
												<option value="">-Select-</option>
												<option <?php echo $octafx['enthusiasm']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option <?php echo $octafx['enthusiasm']=='No'?"selected":""; ?> value="No">No</option>
											</select>
										</td>
										<td colspan=3>
											<select class="form-control octafx_point" id="enthusiasm_reason" name="data[enthusiasm_reason]" required>
												<option value="<?php echo $octafx['enthusiasm_reason']; ?>"><?php echo $octafx['enthusiasm_reason']; ?></option>
											</select>
										</td>
									</tr>
									<tr>
										<td colspan=2>Goal driven</td>
										<td>
											<select class="form-control" id="goal_driven" name="data[goal_driven]" required>
												<option value="">-Select-</option>
												<option <?php echo $octafx['goal_driven']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option <?php echo $octafx['goal_driven']=='No'?"selected":""; ?> value="No">No</option>
											</select>
										</td>
										<td colspan=3>
											<select class="form-control octafx_point" id="goal_driven_reason" name="data[goal_driven_reason]" required>
												<option value="<?php echo $octafx['goal_driven_reason']; ?>"><?php echo $octafx['goal_driven_reason']; ?></option>
											</select>
										</td>
									</tr>
									<tr>
										<td colspan=2>Dos and Don'ts (Call ethicate)</td>
										<td>
											<select class="form-control" id="do_dont_call_ethicate" name="data[do_dont_call_ethicate]" required>
												<option value="">-Select-</option>
												<option <?php echo $octafx['do_dont_call_ethicate']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option <?php echo $octafx['do_dont_call_ethicate']=='No'?"selected":""; ?> value="No">No</option>
											</select>
										</td>
										<td colspan=3>
											<select class="form-control octafx_point" id="do_dont_call_ethicate_reason" name="data[do_dont_call_ethicate_reason]" required>
												<option value="<?php echo $octafx['do_dont_call_ethicate_reason']; ?>"><?php echo $octafx['do_dont_call_ethicate_reason']; ?></option>
											</select>
										</td>
									</tr>
									<tr>
										<td colspan=2 style="color:red">Giving trading advice</td>
										<td>
											<select class="form-control octafxAF1" id="trading_advice" name="data[trading_advice]" required>
												<option value="">-Select-</option>
												<option <?php echo $octafx['trading_advice']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option <?php echo $octafx['trading_advice']=='No'?"selected":""; ?> value="No">No</option>
											</select>
										</td>
										<td colspan=3>
											<select class="form-control octafx_point" id="trading_advice_reason" name="data[trading_advice_reason]" required>
												<option value="<?php echo $octafx['trading_advice_reason']; ?>"><?php echo $octafx['trading_advice_reason']; ?></option>
											</select>
										</td>
									</tr>
									<tr>
										<td colspan=2 style="color:red">Profanity rudeness or sarcasm</td>
										<td>
											<select class="form-control octafxAF2" id="profanity_rudeness" name="data[profanity_rudeness]" required>
												<option value="">-Select-</option>
												<option <?php echo $octafx['profanity_rudeness']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option <?php echo $octafx['profanity_rudeness']=='No'?"selected":""; ?> value="No">No</option>
											</select>
										</td>
										<td colspan=3>
											<select class="form-control octafx_point" id="profanity_rudeness_reason" name="data[profanity_rudeness_reason]" required>
												<option value="<?php echo $octafx['profanity_rudeness_reason']; ?>"><?php echo $octafx['profanity_rudeness_reason']; ?></option>
											</select>
										</td>
									</tr>
									<tr>
										<td colspan=2 style="color:red">Asking details of payment option for example card details</td>
										<td>
											<select class="form-control octafxAF3" id="asking_details_payment_details" name="data[asking_details_payment_details]" required>
												<option value="">-Select-</option>
												<option <?php echo $octafx['asking_details_payment_details']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option <?php echo $octafx['asking_details_payment_details']=='No'?"selected":""; ?> value="No">No</option>
											</select>
										</td>
										<td colspan=3>
											<select class="form-control octafx_point" id="asking_details_payment_details_reason" name="data[asking_details_payment_details_reason]" required>
												<option value="<?php echo $octafx['asking_details_payment_details_reason']; ?>"><?php echo $octafx['asking_details_payment_details_reason']; ?></option>
											</select>
										</td>
									</tr>
									<tr>
										<td colspan=2 style="color:red">Using customers personal info for non official purpose</td>
										<td>
											<select class="form-control octafxAF4" id="use_customer_info" name="data[use_customer_info]" required>
												<option value="">-Select-</option>
												<option <?php echo $octafx['use_customer_info']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option <?php echo $octafx['use_customer_info']=='No'?"selected":""; ?> value="No">No</option>
											</select>
										</td>
										<td colspan=3>
											<select class="form-control octafx_point" id="use_customer_info_reason" name="data[use_customer_info_reason]" required>
												<option value="<?php echo $octafx['use_customer_info_reason']; ?>"><?php echo $octafx['use_customer_info_reason']; ?></option>
											</select>
										</td>
									</tr>
									<tr>
										<td colspan=2 style="color:red">False commitment/Mislead the client for deposit</td>
										<td>
											<select class="form-control octafxAF5" id="false_commitment" name="data[false_commitment]" required>
												<option value="">-Select-</option>
												<option <?php echo $octafx['false_commitment']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option <?php echo $octafx['false_commitment']=='No'?"selected":""; ?> value="No">No</option>
											</select>
										</td>
										<td colspan=3>
											<select class="form-control octafx_point" id="false_commitment_reason" name="data[false_commitment_reason]" required>
												<option value="<?php echo $octafx['false_commitment_reason']; ?>"><?php echo $octafx['false_commitment_reason']; ?></option>
											</select>
										</td>
									</tr>
									<tr>
										<td colspan=2 style="color:red">Login to client's trading platform/ personal area on behalf of the client</td>
										<td>
											<select class="form-control octafxAF6" id="login_client_trading" name="data[login_client_trading]" required>
												<option value="">-Select-</option>
												<option <?php echo $octafx['login_client_trading']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option <?php echo $octafx['login_client_trading']=='No'?"selected":""; ?> value="No">No</option>
											</select>
										</td>
										<td colspan=3>
											<select class="form-control octafx_point" id="login_client_trading_reason" name="data[login_client_trading_reason]" required>
												<option value="<?php echo $octafx['login_client_trading_reason']; ?>"><?php echo $octafx['login_client_trading_reason']; ?></option>
											</select>
										</td>
									</tr>
									
									<?php $call_dipo='class="call_dipo"';
										/* if($oc_id!=0 && $octafx['call_type1']=='Successful Deposit Call'){ 
											$call_dipo='class="call_dipo1"';
										}else{
											$call_dipo='class="call_dipo"';
										} */
									?>
									<tr <?php echo $call_dipo ?>>
										<td colspan=2>Client deposited during call</td>
										<td>
											<select class="form-control client_disposit_during_call" id="client_disposit_during_call" name="data[client_disposit_during_call]" >
												<option value="">-Select-</option>
												<option <?php echo $octafx['client_disposit_during_call']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option <?php echo $octafx['client_disposit_during_call']=='No'?"selected":""; ?> value="No">No</option>
											</select>
										</td>
										<td colspan=3>
											<select class="form-control octafx_point client_disposit_during_call_reason" id="client_disposit_during_call_reason" name="data[client_disposit_during_call_reason]" >
												<option value="<?php echo $octafx['client_disposit_during_call_reason']; ?>"><?php echo $octafx['client_disposit_during_call_reason']; ?></option>
											</select>
										</td>
									</tr>
									<tr <?php echo $call_dipo ?>>
										<td colspan=2>Client deposited during call above KPI</td>
										<td>
											<select class="form-control client_disposit_during_call_kpi" id="client_disposit_during_call_kpi" name="data[client_disposit_during_call_kpi]" >
												<option value="">-Select-</option>
												<option <?php echo $octafx['client_disposit_during_call_kpi']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option <?php echo $octafx['client_disposit_during_call_kpi']=='No'?"selected":""; ?> value="No">No</option>
											</select>
										</td>
										<td colspan=3>
											<select class="form-control octafx_point client_disposit_during_call_kpi_reason" id="client_disposit_during_call_kpi_reason" name="data[client_disposit_during_call_kpi_reason]" >
												<option value="<?php echo $octafx['client_disposit_during_call_kpi_reason']; ?>"><?php echo $octafx['client_disposit_during_call_kpi_reason']; ?></option>
											</select>
										</td>
									</tr>
									<tr <?php echo $call_dipo ?>>
										<td colspan=2>Client uploaded documents during call</td>
										<td>
											<select class="form-control client_upload_document" id="client_upload_document" name="data[client_upload_document]" >
												<option value="">-Select-</option>
												<option <?php echo $octafx['client_upload_document']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option <?php echo $octafx['client_upload_document']=='No'?"selected":""; ?> value="No">No</option>
											</select>
										</td>
										<td colspan=3>
											<select class="form-control octafx_point client_upload_document_reason" id="client_upload_document_reason" name="data[client_upload_document_reason]" >
												<option value="<?php echo $octafx['client_upload_document_reason']; ?>"><?php echo $octafx['client_upload_document_reason']; ?></option>
											</select>
										</td>
									</tr>
									
									<tr>
										<td>Audit Summary:</td>
										<td colspan=3><textarea class="form-control" id="" name="data[call_summary]"><?php echo $octafx['call_summary'] ?></textarea></td>
										<td>Audit Feedback:</td>
										<td colspan=3><textarea class="form-control" id="" name="data[feedback]"><?php echo $octafx['feedback'] ?></textarea></td>
									</tr>

									<?php if($oc_id==0){ ?>
									<tr>
										<td colspan=2>Upload Files [m4a,mp4,mp3,wav]</td>
										<td colspan=4><input type="file" multiple class="form-control" id="attach_file" name="attach_file[]"></td>
									</tr>
									<?php }else{ ?>
									<tr>	
										<td colspan=2>Upload Files [m4a,mp4,mp3,wav]</td>
										<?php if($octafx['attach_file']!=''){ ?>
											<td colspan=4>
												<?php $attach_file = explode(",",$octafx['attach_file']);
												 foreach($attach_file as $mp){ ?>
													<audio controls='' style="background-color:#607F93"> 
													  <source src="<?php echo base_url(); ?>qa_files/octafx/<?php echo $mp; ?>" type="audio/ogg">
													  <source src="<?php echo base_url(); ?>qa_files/octafx/<?php echo $mp; ?>" type="audio/mpeg">
													</audio> </br>
												 <?php } ?>
											</td>
										<?php }else{
												//echo '<td colspan=6><b>No Files</b></td>';
											  }
										} ?>
									</tr>
									
									
									<?php if($oc_id!=0){ ?>
										<tr><td colspan=2 style="font-size:12px; font-weight:bold">Agent Feedback Acceptance:</td><td colspan=4><?php echo $octafx['agnt_fd_acpt'] ?></td></tr>
										<tr><td colspan=2 style="font-size:12px; font-weight:bold">Management Review:</td><td colspan=4><?php echo $octafx['mgnt_rvw_note'] ?></td></tr>
										<tr><td colspan=2 style="font-size:12px; font-weight:bold">Client Review:</td><td colspan=4><?php echo $octafx['client_rvw_note'] ?></td></tr>
										
										<tr><td colspan=2  style="font-size:12px">Your Review</td><td colspan=4><textarea class="form-control1" style="width:100%" id="note" name="note"  ><?php echo $octafx['agent_rvw_note'] ?></textarea></td></tr>
									<?php } ?>
									
									
									<?php 
									if($oc_id==0){
										if(is_access_qa_module()==true || is_access_qa_operations_module()==true){ ?>
											<tr><td colspan=6><button class="btn btn-success waves-effect" type="submit" id="qaformsubmit" style="width:500px">SAVE</button></td></tr>
									<?php 
										} 
									}else{ 
										if(is_access_qa_module()==true || is_access_qa_operations_module()==true){
											 if($octafx['agent_rvw_note']=="") { ?>
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
