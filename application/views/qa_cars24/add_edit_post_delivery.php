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
										<td colspan="7" id="theader" style="font-size:30px">Post Delivery</td>
										<?php
										if($post_delivery_id==0){
											$auditorName = get_username();
											$auditDate = CurrDateMDY();
											$clDate_val='';
										}else{
											if($post_delivery['entry_by']!=''){
												$auditorName = $post_delivery['auditor_name'];
											}else{
												$auditorName = $post_delivery['client_name'];
											}
											$auditDate = mysql2mmddyy($post_delivery['audit_date']);
											$clDate_val = mysqlDt2mmddyy($post_delivery['call_date']);
										}
									?>
										<input type="hidden" name="audit_start_time" value="<?php echo CurrMySqlDate(); ?>">
									</tr>
									<tr>
										<td colspan="2">QA Name:</td>
										<td><input type="text" class="form-control" value="<?php echo get_username(); ?>" disabled></td>
										<td>Audit Date:</td>
										<td><input type="text" class="form-control" value="<?php echo ConvServerToLocal($auditDate); ?>" disabled></td>
										<td>Call Date/Time:</td>
										<td><input type="text" class="form-control" id="call_date_time" name="call_date" value="<?php echo $clDate_val; ?>" required></td>
									</tr>
									<tr>
										<td colspan="2">Agent:</td>
										<td>
											<select class="form-control agentName" id="agent_id" name="data[agent_id]" required>
												<option value="<?php echo $post_delivery['agent_id'] ?>"><?php echo $post_delivery['fname']." ".$post_delivery['lname'] ?></option>
												<option value="">-Select-</option>
												<?php foreach($agentName as $row):  ?>
													<option value="<?php echo $row['id']; ?>"><?php echo $row['name'].' ('.$row['fusion_id'].')'; ?></option>
												<?php endforeach; ?>
											</select>
										</td>
										<td>Campaign:</td>
										<td><input type="text" readonly class="form-control" id="campaign" name="" value="<?php echo $post_delivery['process_name'] ?>"></td>
										<td>L1 Supervisor:</td>
										<td>
											<select class="form-control" id="tl_id" name="data[tl_id]" readonly>
												<option value="<?php echo $post_delivery['tl_id'] ?>"><?php echo $post_delivery['tl_name'] ?></option>
												<option value="">--Select--</option>
												<?php foreach($tlname as $tl): ?>
													<option value="<?php echo $tl['id']; ?>"><?php echo $tl['fname']." ".$tl['lname']; ?></option>
												<?php endforeach; ?>	
											</select>
										</td>
									</tr>
									<tr>
										
										<td colspan="2">Call Duration:</td>
										<td><input type="text" class="form-control" id="call_duration" name="data[call_duration]" value="<?php echo $post_delivery['call_duration'] ?>" required></td>
										<td>Customer Contact Number:</td>
										<td><input type="text" class="form-control" id="customer_contact_number" name="data[customer_contact_number]" value="<?php echo $post_delivery['customer_contact_number'] ?>" onkeyup="checkDec(this);" required></td>
										<td>Actual Disposition:</td>
										<td><input type="text" class="form-control" id="actual_disposition" name="data[actual_disposition]" value="<?php echo $post_delivery['actual_disposition'] ?>" required></td>
									</tr>
									<tr>
										<td colspan="2">Audit Type:</td>
										<td>
											<select class="form-control" id="audit_type" name="data[audit_type]" required>
												<option value="<?php echo $post_delivery['audit_type'] ?>"><?php echo $post_delivery['audit_type'] ?></option>
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
												<option value="<?php echo $post_delivery['auditor_type'] ?>"><?php echo $post_delivery['auditor_type'] ?></option>
												<option value="">-Select-</option>
												<option value="Master">Master</option>
												<option value="Regular">Regular</option>
											</select>
										</td>
										<td>VOC:</td>
										<td>
											<select class="form-control" id="voc" name="data[voc]" required>
												<option value="<?php echo $post_delivery['voc'] ?>"><?php echo $post_delivery['voc'] ?></option>
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
										<td>Disposition:</td>
										<td colspan="2">
										<select class="form-control" id="disposition" name="data[Disposition1]" required>
												<option value="<?php echo $post_delivery['Disposition1'] ?>"><?php echo $post_delivery['Disposition1'] ?></option>
												<option value="">-Select-</option>
												<option value="Open">Open</option>
												<option value="RC Transfer & Handover (Rename)">RC Transfer & Handover (Rename)</option>
												<option value="Return Related">Return Related</option>
												<option value="Warranty/ Repair">Warranty/ Repair</option>
												<option value="Loan Related">Loan Related</option>
												<option value="Dropped">Dropped</option>
												<option value="Other Post Sale Support">Other Post Sale Support</option>												
												<option value="Ad Hoc Calling">Ad Hoc Calling</option>	
											</select>
										</td>


										<td>Sub Disposition:</td>
										<td colspan="4">
										<select class="form-control" id="sub_dispo" name="data[Sub_Disposition]" required>
												<option value="<?php echo $post_delivery['Sub_Disposition'] ?>"><?php echo $post_delivery['Sub_Disposition'] ?></option>
											</select>
											</td>
									</tr>
									<tr>
										<td>Sub Description:</td>
										<td colspan="4">
										<select class="form-control" id="sub_subdispo" name="data[Sub_subDisposition]" required>
											<option value="<?php echo $post_delivery['Sub_subDisposition'] ?>"><?php echo $post_delivery['Sub_subDisposition'] ?></option>
													
											</select>
										</td>
									</tr>
									<tr>
										<td colspan="2" style="font-weight:bold; font-size:12px">Rating(Standardization):</td>
										<td><input type="text" readonly id="standardization_rating" name="data[standardization_rating]" class="form-control" style="font-weight:bold" value="<?php echo $post_delivery['standardization_rating']; ?>"></td>
										
										<td style="font-weight:bold; font-size:12px">Score(Standardization):</td>
										<td><input type="text" readonly id="standardization_score" name="data[standardization_score]" class="form-control" style="font-weight:bold" value="<?php echo $post_delivery['standardization_score']; ?>"></td>
										
										<td style="font-weight:bold; font-size:12px; text-align:right">CQ Score(Standardization):</td>
										<td><input type="text" readonly id="standardization_cqscore" name="data[standardization_cqscore]" class="form-control pnboutboundFatal" style="font-weight:bold" value="<?php if($post_delivery['standardization_cqscore']){ echo $post_delivery['standardization_cqscore']; } else { echo '0.00'.'%'; } ?>"></td>
									</tr>
									<tr>
										<td colspan="2" style="font-weight:bold; font-size:12px">Rating(Product & Process):</td>
										<td><input type="text" readonly id="product_possibleScore" name="data[product_possibleScore]" class="form-control" style="font-weight:bold" value="<?php echo $post_delivery['product_possibleScore']; ?>"></td>
										
										<td style="font-weight:bold; font-size:12px">Score(Product & Process):</td>
										<td><input type="text" readonly id="product_earnedScore" name="data[product_earnedScore]" class="form-control" style="font-weight:bold" value="<?php echo $post_delivery['product_earnedScore']; ?>"></td>
										
										<td style="font-weight:bold; font-size:12px; text-align:right">CQ Score(Product & Process):</td>
										<td><input type="text" readonly id="product_overallScore" name="data[product_overallScore]" class="form-control pnboutboundFatal" style="font-weight:bold" value="<?php if($post_delivery['product_overallScore']){ echo $post_delivery['product_overallScore']; } else { echo '0.00'.'%'; } ?>"></td>
									</tr>
									<tr>
										<td colspan="2" style="font-weight:bold; font-size:12px">Rating(Communication & Soft-Skills):</td>
										<td><input type="text" readonly id="communication_possibleScore" name="data[communication_possibleScore]" class="form-control" style="font-weight:bold" value="<?php echo $post_delivery['possible_score']; ?>"></td>
										
										<td style="font-weight:bold; font-size:12px">Score(Communication & Soft-Skills):</td>
										<td><input type="text" readonly id="communication_earnedScore" name="data[communication_earnedScore]" class="form-control" style="font-weight:bold" value="<?php echo $post_delivery['communication_earnedScore']; ?>"></td>
										
										<td style="font-weight:bold; font-size:12px; text-align:right">CQ Score(Communication & Soft-Skills):</td>
										<td><input type="text" readonly id="communication_overallScore" name="data[communication_overallScore]" class="form-control pnboutboundFatal" style="font-weight:bold" value="<?php if($post_delivery['communication_overallScore']){ echo $post_delivery['communication_overallScore']; } else { echo '0.00'.'%'; } ?>"></td>
									</tr>
									<tr>
										<td colspan="2" style="font-weight:bold; font-size:12px">Rating(Critical Error & ZTP):</td>
										<td><input type="text" readonly id="critical_possibleScore" name="data[critical_possibleScore]" class="form-control" style="font-weight:bold" value="<?php echo $post_delivery['critical_possibleScore']; ?>"></td>
										
										<td style="font-weight:bold; font-size:12px">Score(Critical Error & ZTP):</td>
										<td><input type="text" readonly id="critical_earnedScore" name="data[critical_earnedScore]" class="form-control" style="font-weight:bold" value="<?php echo $post_delivery['critical_earnedScore']; ?>"></td>
										
										<td style="font-weight:bold; font-size:12px; text-align:right">CQ Score(Critical Error & ZTP):</td>
										<td><input type="text" readonly id="critical_overallScore" name="data[critical_overallScore]" class="form-control pnboutboundFatal" style="font-weight:bold" value="<?php if($post_delivery['critical_overallScore']){ echo $post_delivery['critical_overallScore']; } else { echo '0.00'.'%'; } ?>"></td>
									</tr>
									<tr>
										<td colspan="2" style="font-weight:bold; font-size:12px">Rating(Fatal Count):</td>
										<td><input type="text" readonly id="fatal_possibleScore" name="data[fatal_possibleScore]" class="form-control" style="font-weight:bold" value="<?php echo $post_delivery['fatal_possibleScore']; ?>"></td>
										
										<td style="font-weight:bold; font-size:12px">Score(Fatal Count):</td>
										<td><input type="text" readonly id="fatal_earnedScore" name="data[fatal_earnedScore]" class="form-control" style="font-weight:bold" value="<?php echo $post_delivery['fatal_earnedScore']; ?>"></td>
										
										<td style="font-weight:bold; font-size:12px; text-align:right">CQ Score(Fatal Count):</td>
										<td><input type="text" readonly id="fatal_overallScore" name="data[fatal_overallScore]" class="form-control pnboutboundFatal" style="font-weight:bold" value="<?php if($post_delivery['fatal_overallScore']){ echo $post_delivery['fatal_overallScore']; } else { echo '0.00'.'%'; } ?>"></td>
									</tr>
									<tr>
										<td colspan="2" style="font-weight:bold; font-size:12px">Rating(Score without fatal):</td>
										<td><input type="text" readonly id="without_fatal_possibleScore" name="data[without_fatal_possibleScore]" class="form-control" style="font-weight:bold" value="100"></td>
										
										<td style="font-weight:bold; font-size:12px">Score(Score without fatal):</td>
										<td><input type="text" readonly id="without_fatal_earnedScore" name="data[without_fatal_earnedScore]" class="form-control" style="font-weight:bold" value="100"></td>
										
										<td style="font-weight:bold; font-size:12px; text-align:right">CQ Score(Score without fatal):</td>
										<td><input type="text" readonly id="without_fatal_overallScore" name="data[without_fatal_overallScore]" class="form-control pnboutboundFatal" style="font-weight:bold" value="100"></td>
									</tr>
									<tr>
										<td colspan="">Language:</td>
										<td colspan="4">
											<select class="form-control" id="voc" name="data[Language]" required>
												<option value="<?php echo $post_delivery['Language'] ?>"><?php echo $post_delivery['Language'] ?></option>
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
										<td colspan="2" style="font-weight:bold; font-size:15px">Possible Score:</td>
										<td><input type="text" readonly id="post_delivery_possibleScore" name="data[possible_score]" class="form-control" style="font-weight:bold" value="<?php echo $post_delivery['possible_score']; ?>"></td>
										
										<td style="font-weight:bold; font-size:15px">Earn Score:</td>
										<td><input type="text" readonly id="post_delivery_earnedScore" name="data[earned_score]" class="form-control" style="font-weight:bold" value="<?php echo $post_delivery['earned_score']; ?>"></td>
										
										<td style="font-weight:bold; font-size:15px; text-align:right">Overall Score:</td>
										<td><input type="text" readonly id="post_delivery_overallScore" name="data[overall_score]" class="form-control pnboutboundFatal" style="font-weight:bold" value="<?php if($post_delivery['overall_score']){ echo $post_delivery['overall_score']; } else { echo '0.00'.'%'; } ?>"></td>
									</tr>
									<tr style="background-color:#A9CCE3; font-weight:bold"><td>Category</td><td>Parameter</td><td colspan=3>Sub-Parameter</td><td colspan=1>Sub-Parameter Wise Score</td><td>Validation (Y/N/NA)</td></tr>
									<tr>
										<td rowspan=6 style="background-color:#A9CCE3; font-weight:bold">Standardization</td>
										<td rowspan=2 style="background-color:#A9CCE3; font-weight:bold">Opening</td>
										<td colspan=3>Opening done in 5 Sec in English/ Regional Language</td>
										<td>1</td>
										<td>
											<select class="form-control post_delivery_booking_point standard" id="standardization1" name="data[opening_done_in]" required>
												<option value="">Select</option>
												<option post_delivery_booking_val=1 <?php echo $post_delivery['opening_done_in']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option post_delivery_booking_val=1 <?php echo $post_delivery['opening_done_in']=='No'?"selected":""; ?> value="No">No</option>
												<option post_delivery_booking_val=0 <?php echo $post_delivery['opening_done_in']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
									</tr>
									<tr>
										<td colspan=3>Greeting/ Self introduction/ Company Introduction/ Customer identification/Purpose of the call</td>
										<td>1</td>
										<td>
											<select class="form-control post_delivery_booking_point standard" id="standardization2" name="data[greeting_self_introduction]" required>
												<option value="">Select</option>
												<option post_delivery_booking_val=1 <?php echo $post_delivery['greeting_self_introduction']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option post_delivery_booking_val=1 <?php echo $post_delivery['greeting_self_introduction']=='No'?"selected":""; ?> value="No">No</option>
												<option post_delivery_booking_val=0 <?php echo $post_delivery['greeting_self_introduction']=='NA'?"selected":""; ?> value="NA">NA</option>
												
											</select>
										</td>
									</tr>

									<tr>
										<td rowspan=2 style="background-color:#A9CCE3; font-weight:bold">Hold/On-Hold </td>
										<td colspan=3>Hold/On-Hold Procedure followed on call</td>
										<td>1</td>
										<td>
											<select class="form-control post_delivery_booking_point standard" id="standardization3" name="data[hold_procedure]" required>
												<option value="">Select</option>
												<option post_delivery_booking_val=1 <?php echo $post_delivery['hold_procedure']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option post_delivery_booking_val=1 <?php echo $post_delivery['hold_procedure']=='No'?"selected":""; ?> value="No">No</option>
												<option post_delivery_booking_val=0 <?php echo $post_delivery['hold_procedure']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
									</tr>
									<tr>
										<td colspan=3>No Dead Air</td>
										<td>1</td>
										<td>
											<select class="form-control post_delivery_booking_point standard" id="standardization4" name="data[no_dead_air]" required>
												<option value="">Select</option>
												<option post_delivery_booking_val=1 <?php echo $post_delivery['no_dead_air']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option post_delivery_booking_val=1 <?php echo $post_delivery['no_dead_air']=='No'?"selected":""; ?> value="No">No</option>
												<option post_delivery_booking_val=0 <?php echo $post_delivery['no_dead_air']=='NA'?"selected":""; ?> value="NA">NA</option>
												
											</select>
										</td>
									</tr>

									<tr>
										<td rowspan=2 style="background-color:#A9CCE3; font-weight:bold">Closing </td>
										<td colspan=3>Call Summarization was done on the call</td>
										<td>1</td>
										<td>
											<select class="form-control post_delivery_booking_point standard" id="standardization5" name="data[call_summarization]" required>
												<option value="">Select</option>
												<option post_delivery_booking_val=1 <?php echo $post_delivery['call_summarization']=='Yes'?"selected":""; ?> value="Yes">Yes</opticall_summarizationon>
												<option post_delivery_booking_val=1 <?php echo $post_delivery['call_summarization']=='No'?"selected":""; ?> value="No">No</option>
												<option post_delivery_booking_val=0 <?php echo $post_delivery['call_summarization']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
									</tr>
									<tr>
										<td colspan=3>Associate asked for further assistance & closed the call properly</td>
										<td>1</td>
										<td>
											<select class="form-control post_delivery_booking_point standard" id="standardization6" name="data[associate_asked]" required>
												<option value="">Select</option>
												<option post_delivery_booking_val=1 <?php echo $post_delivery['associate_asked']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option post_delivery_booking_val=1 <?php echo $post_delivery['associate_asked']=='No'?"selected":""; ?> value="No">No</option>
												<option post_delivery_booking_val=0 <?php echo $post_delivery['associate_asked']=='NA'?"selected":""; ?> value="NA">NA</option>
												
											</select>
										</td>
									</tr>

									<tr>
										<td rowspan=12 style="background-color:#A9CCE3; font-weight:bold">Product & Process</td>
										<tr>
										<td rowspan=5 style="background-color:#A9CCE3; font-weight:bold">Customer Assistance & Agent Effort </td>
										<td colspan=3>Associate able to understand/identify the customer concern clearly</td>
										<td>1</td>
										<td>
											<select class="form-control post_delivery_booking_point product_process" id="pass_fail2" name="data[associate_able_to]" required>
												<option value="">Select</option>
												<option post_delivery_booking_val=1 <?php echo $post_delivery['associate_able_to']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option post_delivery_booking_val=1 <?php echo $post_delivery['associate_able_to']=='No'?"selected":""; ?> value="No">No</option>
												<option post_delivery_booking_val=0 <?php echo $post_delivery['associate_able_to']=='NA'?"selected":""; ?> value="NA">NA</option>
												
											</select>
										</td>
									</tr>
										
										<td colspan=3>Relevant probing done to understand the customer needs and concern</td>
										<td>1</td>
										<td>
											<select class="form-control post_delivery_booking_point product_process" id="pass_fail1" name="data[relevant_probing_done]" required>
												<option value="">Select</option>
												<option post_delivery_booking_val=1 <?php echo $post_delivery['relevant_probing_done']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option post_delivery_booking_val=1 <?php echo $post_delivery['relevant_probing_done']=='No'?"selected":""; ?> value="No">No</option>
												<option post_delivery_booking_val=0 <?php echo $post_delivery['relevant_probing_done']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
									</tr>

									<tr>
										<td colspan=3>All customer queries addressed effectively/ Effective rebuttals and objection handling used</td>
										<td>1</td>
										<td>
											<select class="form-control post_delivery_booking_point product_process" id="pass_fail2" name="data[all_customer_queries]" required>
												<option value="">Select</option>
												<option post_delivery_booking_val=1 <?php echo $post_delivery['all_customer_queries']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option post_delivery_booking_val=1 <?php echo $post_delivery['all_customer_queries']=='No'?"selected":""; ?> value="No">No</option>
												<option post_delivery_booking_val=0 <?php echo $post_delivery['all_customer_queries']=='NA'?"selected":""; ?> value="NA">NA</option>
												
											</select>
										</td>
									</tr>
									<tr>
										<td colspan=3 style="color:red">Correct TAT informed (wherever applicable)</td>
										<td>1</td>
										<td>
											<select class="form-control post_delivery_booking_point product_process fat" id="fatal1" name="data[correct_tat_informed]" required>
												<option value="">Select</option>
												<option post_delivery_booking_val=1 <?php echo $post_delivery['correct_tat_informed']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option post_delivery_booking_val=1 <?php echo $post_delivery['correct_tat_informed']=='No'?"selected":""; ?> value="No">No</option>
												<option post_delivery_booking_val=0 <?php echo $post_delivery['correct_tat_informed']=='NA'?"selected":""; ?> value="NA">NA</option>
												
											</select>
										</td>
									</tr>

									<tr>
										<td colspan=3 style="color:red">Warranty/Invoice/ RC-Receipt etc shared with customer(Wherever Applicable)</td>
										<td>1</td>
										<td>
											<select class="form-control post_delivery_booking_point product_process fat" id="fatal2" name="data[warranty_invoice]" required>
												<option value="">Select</option>
												<option post_delivery_booking_val=1 <?php echo $post_delivery['warranty_invoice']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option post_delivery_booking_val=1 <?php echo $post_delivery['warranty_invoice']=='No'?"selected":""; ?> value="No">No</option>
												<option post_delivery_booking_val=0 <?php echo $post_delivery['warranty_invoice']=='NA'?"selected":""; ?> value="NA">NA</option>
												
											</select>
										</td>
									</tr>

									<tr>
										<td rowspan=4 style="background-color:#A9CCE3; font-weight:bold">Ticket Creation & FCR </td>
										<td colspan=3>First Call Resolution Provided to the customer</td>
										<td>1</td>
										<td>
											<select class="form-control post_delivery_booking_point product_process" id="pass_fail1" name="data[first_Call_resolution]" required>
												<option value="">Select</option>
												<option post_delivery_booking_val=1 <?php echo $post_delivery['first_Call_resolution']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option post_delivery_booking_val=1 <?php echo $post_delivery['first_Call_resolution']=='No'?"selected":""; ?> value="No">No</option>
												<option post_delivery_booking_val=0 <?php echo $post_delivery['first_Call_resolution']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
									</tr>
									<tr>
										<td colspan=3 style="color:red">Customer concern raised on Zendesk- If Required</td>
										<td>1</td>
										<td>
											<select class="form-control post_delivery_booking_point product_process" id="fatal3" name="data[customer_concern_raised]" required>
												<option value="">Select</option>
												<option post_delivery_booking_val=1 <?php echo $post_delivery['customer_concern_raised']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option post_delivery_booking_val=1 <?php echo $post_delivery['customer_concern_raised']=='No'?"selected":""; ?> value="No">No</option>
												<option post_delivery_booking_val=0 <?php echo $post_delivery['customer_concern_raised']=='NA'?"selected":""; ?> value="NA">NA</option>
												
											</select>
										</td>
									</tr>
									<tr>
										<td colspan=3>Correct Details & Remarks Captured against ticket</td>
										<td>1</td>
										<td>
											<select class="form-control post_delivery_booking_point product_process" id="pass_fail2" name="data[correct_details_remark]" required>
												<option value="">Select</option>
												<option post_delivery_booking_val=1 <?php echo $post_delivery['correct_details_remark']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option post_delivery_booking_val=1 <?php echo $post_delivery['correct_details_remark']=='No'?"selected":""; ?> value="No">No</option>
												<option post_delivery_booking_val=0 <?php echo $post_delivery['correct_details_remark']=='NA'?"selected":""; ?> value="NA">NA</option>
												
											</select>
										</td>
									</tr>
									<tr>
										<td colspan=3>No Duplicate ticket created on Zendesk- If already available</td>
										<td>1</td>
										<td>
											<select class="form-control post_delivery_booking_point product_process" id="pass_fail2" name="data[no_duplicate_ticket]" required>
												<option value="">Select</option>
												<option post_delivery_booking_val=1 <?php echo $post_delivery['no_duplicate_ticket']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option post_delivery_booking_val=1 <?php echo $post_delivery['no_duplicate_ticket']=='No'?"selected":""; ?> value="No">No</option>
												<option post_delivery_booking_val=0 <?php echo $post_delivery['no_duplicate_ticket']=='NA'?"selected":""; ?> value="NA">NA</option>
												
											</select>
										</td>
									</tr>

									<tr>
										<td rowspan=2 style="background-color:#A9CCE3; font-weight:bold">Disposition </td>
										<td colspan=3 style="color:red">Correct Dispostion and remarks captured</td>
										<td>1</td>
										<td>
											<select class="form-control post_delivery_booking_point product_process fat" id="fatal4" name="data[correct_dispostion]" required>
												<option value="">Select</option>
												<option post_delivery_booking_val=1 <?php echo $post_delivery['correct_dispostion']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option post_delivery_booking_val=1 <?php echo $post_delivery['correct_dispostion']=='No'?"selected":""; ?> value="No">No</option>
												<option post_delivery_booking_val=0 <?php echo $post_delivery['correct_dispostion']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
									</tr>
									<tr>
										<td colspan=3>Customer Email-ID confirmed/Captured</td>
										<td>1</td>
										<td>
											<select class="form-control post_delivery_booking_point product_process" id="pass_fail2" name="data[customer_email_id]" required>
												<option value="">Select</option>
												<option post_delivery_booking_val=1 <?php echo $post_delivery['customer_email_id']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option post_delivery_booking_val=1 <?php echo $post_delivery['customer_email_id']=='No'?"selected":""; ?> value="No">No</option>
												<option post_delivery_booking_val=0 <?php echo $post_delivery['customer_email_id']=='NA'?"selected":""; ?> value="NA">NA</option>
												
											</select>
										</td>
									</tr>
									<tr>
										<td rowspan=11 style="background-color:#A9CCE3; font-weight:bold">Communication & Soft-Skills</td>
										<td rowspan=4 style="background-color:#A9CCE3; font-weight:bold">Rapport Building </td>
										<td colspan=3>Associate Personalized on call</td>
										<td>1</td>
										<td>
											<select class="form-control post_delivery_booking_point communication_soft_skills" id="pass_fail1" name="data[associate_personalized]" required>
												<option value="">Select</option>
												<option post_delivery_booking_val=1 <?php echo $post_delivery['associate_personalized']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option post_delivery_booking_val=1 <?php echo $post_delivery['associate_personalized']=='No'?"selected":""; ?> value="No">No</option>
												<option post_delivery_booking_val=0 <?php echo $post_delivery['associate_personalized']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
									</tr>
									<tr>
										<td colspan=3>Language switched as per customer ease</td>
										<td>1</td>
										<td>
											<select class="form-control post_delivery_booking_point communication_soft_skills" id="pass_fail2" name="data[language_switched]" required>
												<option value="">Select</option>
												<option post_delivery_booking_val=1 <?php echo $post_delivery['language_switched']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option post_delivery_booking_val=1 <?php echo $post_delivery['language_switched']=='No'?"selected":""; ?> value="No">No</option>
												<option post_delivery_booking_val=0 <?php echo $post_delivery['language_switched']=='NA'?"selected":""; ?> value="NA">NA</option>
												
											</select>
										</td>
									</tr>
									<tr>
										<td colspan=3>No interruption on call</td>
										<td>1</td>
										<td>
											<select class="form-control post_delivery_booking_point communication_soft_skills" id="pass_fail2" name="data[no_interruption]" required>
												<option value="">Select</option>
												<option post_delivery_booking_val=1 <?php echo $post_delivery['no_interruption']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option post_delivery_booking_val=1 <?php echo $post_delivery['no_interruption']=='No'?"selected":""; ?> value="No">No</option>
												<option post_delivery_booking_val=0 <?php echo $post_delivery['no_interruption']=='NA'?"selected":""; ?> value="NA">NA</option>
												
											</select>
										</td>
									</tr>
									<tr>
										<td colspan=3 style="color:red">Showed Empathy/Apologized (Wherever required)</td>
										<td>1</td>
										<td>
											<select class="form-control post_delivery_booking_point communication_soft_skills" id="fatal5" name="data[showed_empathy]" required>
												<option value="">Select</option>
												<option post_delivery_booking_val=1 <?php echo $post_delivery['showed_empathy']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option post_delivery_booking_val=1 <?php echo $post_delivery['showed_empathy']=='No'?"selected":""; ?> value="No">No</option>
												<option post_delivery_booking_val=0 <?php echo $post_delivery['showed_empathy']=='NA'?"selected":""; ?> value="NA">NA</option>
												
											</select>
										</td>
									</tr>

									<tr>
										<td rowspan=3 style="background-color:#A9CCE3; font-weight:bold">Tone/ Voice </td>
										<td colspan=3>Tone was appropriate throughout the call</td>
										<td>1</td>
										<td>
											<select class="form-control post_delivery_booking_point communication_soft_skills" id="pass_fail1" name="data[tone_was_appropriate]" required>
												<option value="">Select</option>
												<option post_delivery_booking_val=1 <?php echo $post_delivery['tone_was_appropriate']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option post_delivery_booking_val=1 <?php echo $post_delivery['tone_was_appropriate']=='No'?"selected":""; ?> value="No">No</option>
												<option post_delivery_booking_val=0 <?php echo $post_delivery['tone_was_appropriate']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
									</tr>
									<tr>
										<td colspan=3>Voice clarity and appropriate rate of speech</td>
										<td>1</td>
										<td>
											<select class="form-control post_delivery_booking_point communication_soft_skills" id="pass_fail2" name="data[voice_clarity_appropriate]" required>
												<option value="">Select</option>
												<option post_delivery_booking_val=1 <?php echo $post_delivery['voice_clarity_appropriate']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option post_delivery_booking_val=1 <?php echo $post_delivery['voice_clarity_appropriate']=='No'?"selected":""; ?> value="No">No</option>
												<option post_delivery_booking_val=0 <?php echo $post_delivery['voice_clarity_appropriate']=='NA'?"selected":""; ?> value="NA">NA</option>
												
											</select>
										</td>
									</tr>
									<tr>
										<td colspan=3>MTI/ RTI Error on call</td>
										<td>1</td>
										<td>
											<select class="form-control post_delivery_booking_point communication_soft_skills" id="pass_fail2" name="data[mit_rti_error]" required>
												<option value="">Select</option>
												<option post_delivery_booking_val=1 <?php echo $post_delivery['mit_rti_error']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option post_delivery_booking_val=1 <?php echo $post_delivery['mit_rti_error']=='No'?"selected":""; ?> value="No">No</option>
												<option post_delivery_booking_val=0 <?php echo $post_delivery['mit_rti_error']=='NA'?"selected":""; ?> value="NA">NA</option>
												
											</select>
										</td>
									</tr>

									<tr>
										<td rowspan=2 style="background-color:#A9CCE3; font-weight:bold">Sentence Formation & Grammar </td>
										<td colspan=3>Accurate sentence construction without any grammatical errors</td>
										<td>1</td>
										<td>
											<select class="form-control post_delivery_booking_point communication_soft_skills" id="pass_fail1" name="data[accurate_sentence]" required>
												<option value="">Select</option>
												<option post_delivery_booking_val=1 <?php echo $post_delivery['accurate_sentence']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option post_delivery_booking_val=1 <?php echo $post_delivery['accurate_sentence']=='No'?"selected":""; ?> value="No">No</option>
												<option post_delivery_booking_val=0 <?php echo $post_delivery['accurate_sentence']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
									</tr>
									<tr>
										<td colspan=3>No Pronunciation error</td>
										<td>1</td>
										<td>
											<select class="form-control post_delivery_booking_point communication_soft_skills" id="pass_fail2" name="data[no_pronunciation_error]" required>
												<option value="">Select</option>
												<option post_delivery_booking_val=1 <?php echo $post_delivery['no_pronunciation_error']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option post_delivery_booking_val=1 <?php echo $post_delivery['no_pronunciation_error']=='No'?"selected":""; ?> value="No">No</option>
												<option post_delivery_booking_val=0 <?php echo $post_delivery['no_pronunciation_error']=='NA'?"selected":""; ?> value="NA">NA</option>
												
											</select>
										</td>
									</tr>

									<tr>
										<td rowspan=2 style="background-color:#A9CCE3; font-weight:bold">Attentiveness </td>
										<td colspan=3>Active Listening and comprehension</td>
										<td>1</td>
										<td>
											<select class="form-control post_delivery_booking_point communication_soft_skills" id="pass_fail1" name="data[active_listening]" required>
												<option value="">Select</option>
												<option post_delivery_booking_val=1 <?php echo $post_delivery['active_listening']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option post_delivery_booking_val=1 <?php echo $post_delivery['active_listening']=='No'?"selected":""; ?> value="No">No</option>
												<option post_delivery_booking_val=0 <?php echo $post_delivery['active_listening']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
									</tr>
									<tr>
										<td colspan=3>Acknowledgement of customer inputs</td>
										<td>1</td>
										<td>
											<select class="form-control post_delivery_booking_point communication_soft_skills" id="pass_fail2" name="data[acknowledgement]" required>
												<option value="">Select</option>
												<option post_delivery_booking_val=1 <?php echo $post_delivery['acknowledgement']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option post_delivery_booking_val=1 <?php echo $post_delivery['acknowledgement']=='No'?"selected":""; ?> value="No">No</option>
												<option post_delivery_booking_val=0 <?php echo $post_delivery['acknowledgement']=='NA'?"selected":""; ?> value="NA">NA</option>
												
											</select>
										</td>
									</tr>

									<tr>
										<td rowspan=4 style="background-color:#A9CCE3; font-weight:bold">Critical Error & ZTP</td>
										<td rowspan=2 style="background-color:#A9CCE3; font-weight:bold">Critical Error (Compliance) </td>
										<td colspan=3 style="color:red">Available tools used to help the customer (CRM/ Zendesk/ Knowledgebank etc)</td>
										<td>1</td>
										<td>
											<select class="form-control post_delivery_booking_point error_ztp fat" id="fatal6_com" name="data[available_tools_used]" required>
												<option value="">Select</option>
												<option post_delivery_booking_val=1 <?php echo $post_delivery['available_tools_used']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option post_delivery_booking_val=1 <?php echo $post_delivery['available_tools_used']=='No'?"selected":""; ?> value="No">No</option>
												<option post_delivery_booking_val=0 <?php echo $post_delivery['available_tools_used']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
									</tr>
									<tr>
										<td colspan=3 style="color:red">Incorrect or Misleading information</td>
										<td>1</td>
										<td>
											<select class="form-control post_delivery_booking_point error_ztp fat" id="fatal7_com" name="data[incorrect_or_misleading]" required>
												<option value="">Select</option>
												<option post_delivery_booking_val=1 <?php echo $post_delivery['incorrect_or_misleading']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option post_delivery_booking_val=1 <?php echo $post_delivery['incorrect_or_misleading']=='No'?"selected":""; ?> value="No">No</option>
												<option post_delivery_booking_val=0 <?php echo $post_delivery['incorrect_or_misleading']=='NA'?"selected":""; ?> value="NA">NA</option>
												
											</select>
										</td>
									</tr>

									<tr>
										<td rowspan=2 style="background-color:#A9CCE3; font-weight:bold">ZTP (Compliance) </td>
										<td colspan=3 style="color:red">No Rude behaviour, Profanity, offensive or Abusive remark or language found</td>
										<td>1</td>
										<td>
											<select class="form-control post_delivery_booking_point error_ztp fat" id="fatal8_com" name="data[no_rude_behaviour]" required>
												<option value="">Select</option>
												<option post_delivery_booking_val=1 <?php echo $post_delivery['no_rude_behaviour']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option post_delivery_booking_val=1 <?php echo $post_delivery['no_rude_behaviour']=='No'?"selected":""; ?> value="No">No</option>
												<option post_delivery_booking_val=0 <?php echo $post_delivery['no_rude_behaviour']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
									</tr>
									<tr>
										<td colspan=3 style="color:red">No Disconnection found during the call</td>
										<td>1</td>
										<td>
											<select class="form-control post_delivery_booking_point error_ztp fat" id="fatal9_com" name="data[no_disconnection]" required>
												<option value="">Select</option>
												<option post_delivery_booking_val=1 <?php echo $post_delivery['no_disconnection']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option post_delivery_booking_val=1 <?php echo $post_delivery['no_disconnection']=='No'?"selected":""; ?> value="No">No</option>
												<option post_delivery_booking_val=0 <?php echo $post_delivery['no_disconnection']=='NA'?"selected":""; ?> value="NA">NA</option>
												
											</select>
										</td>
									</tr>
									
									<tr>
										<td>Call Summary:</td>
										<td colspan=3><textarea class="form-control" id="" name="data[call_summary]"><?php echo $post_delivery['call_summary'] ?></textarea></td>
										<td>Feedback:</td>
										<td colspan=3><textarea class="form-control" id="" name="data[feedback]"><?php echo $post_delivery['feedback'] ?></textarea></td>
									</tr>
									<tr>
										<td>AOI (Area of improvement):</td>
										<td colspan=3><textarea class="form-control" id="" name="data[aoi]"><?php echo $post_delivery['aoi'] ?></textarea></td>
										<td>Process & Product Observations (If any):</td>
										<td colspan=3><textarea class="form-control" id="" name="data[ppo]"><?php echo $post_delivery['ppo'] ?></textarea></td>
									</tr>
									<tr>
										<td>Compliance (Special case study):</td>
										<td colspan=3><textarea class="form-control" id="" name="data[css]"><?php echo $post_delivery['css'] ?></textarea></td>
									</tr>
									
									<?php if($post_delivery_id==0){ ?>
									<tr>
										<td colspan=2>Upload Files (wav,wmv,mp3,mp4)</td>
										<td colspan=4><input type="file" multiple class="form-control audioFile" id="attach_file" name="attach_file[]"></td>
									</tr>
									<?php }else{ ?>
									<tr>	
										<td colspan=2>Upload Files (wav,wmv,mp3,mp4)</td>
										<td colspan=2><input type="file" multiple class="form-control audioFile" name="attach_file[]"></td>
										<?php if($post_delivery['attach_file']!=''){ ?>
											<td colspan=2>
												<?php $attach_file = explode(",",$post_delivery['attach_file']);
												 foreach($attach_file as $mp){ ?>
													<audio controls='' style="background-color:#607F93"> 
													  <source src="<?php echo base_url(); ?>qa_files/post_delivery/<?php echo $mp; ?>" type="audio/ogg">
													  <source src="<?php echo base_url(); ?>qa_files/post_delivery/<?php echo $mp; ?>" type="audio/mpeg">
													</audio> </br>
												 <?php } ?>
											</td>
										<?php }else{
												echo '<td colspan=2><b>No Files are uploaded</b></td>';
											  }
										} ?>
									</tr>
									
									
									<?php if($post_delivery_id!=0){ ?>
										<tr><td colspan=2 style="font-size:12px; font-weight:bold">Agent Feedback Acceptance:</td><td colspan=4><?php echo $post_delivery['agnt_fd_acpt'] ?></td></tr>
										<tr><td colspan=2 style="font-size:12px; font-weight:bold">Management Review:</td><td colspan=4><?php echo $post_delivery['mgnt_rvw_note'] ?></td></tr>
										<tr><td colspan=2 style="font-size:12px; font-weight:bold">Client Review:</td><td colspan=4><?php echo $post_delivery['client_rvw_note'] ?></td></tr>
										
										<tr><td colspan=2  style="font-size:12px">Your Review</td><td colspan=4><textarea class="form-control1" style="width:100%" id="note" name="note"  ><?php echo $post_delivery['agent_rvw_note'] ?></textarea></td></tr>
									<?php } ?>
									
									
									<?php 
									if($post_delivery_id==0){
										if(is_access_qa_module()==true || is_access_qa_operations_module()==true){ ?>
											<tr><td colspan=6><button class="btn btn-success waves-effect" type="submit" id="qaformsubmit" style="width:500px">SAVE</button></td></tr>
									<?php 
										} 
									}else{ 
										if(is_access_qa_module()==true || is_access_qa_operations_module()==true){
											 if($post_delivery['agent_rvw_note']=="") { ?>
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