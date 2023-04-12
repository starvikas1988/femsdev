<style>
.table > tbody > tr > td{
	text-align: center;
	font-size:13px;
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

<?php if($craftjack_id!=0){
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
									<tr>
										<td colspan="8" id="theader" style="font-size:40px">CRAFTJACK QA EVALUATION FORM</td>
										<input type="hidden" name="audit_start_time" value="<?php echo CurrMySqlDate(); ?>">
									</tr>
									<?php
										if($craftjack_id==0){
											$auditorName = get_username();
											$auditDate = CurrDateMDY();
											$clDate_val='';
											//$go_live_date='';
										}else{
											if($craftjack_new['entry_by']!=''){
												$auditorName = $craftjack_new['auditor_name'];
											}else{
												$auditorName = $craftjack_new['client_name'];
											}
											$auditDate = mysql2mmddyy($craftjack_new['audit_date']);
											$clDate_val = mysql2mmddyy($craftjack_new['call_date']);
											//$go_live_date = mysql2mmddyy($craftjack_new['go_live_date']);
										}
									?>
									<tr>
										<td style="width:150px">Auditor Name:</td>
										<td style="width:300px"><input type="text" class="form-control" value="<?php echo $auditorName; ?>" disabled></td>
										<td>Audit Date:</td>
										<td style="width:250px"><input type="text" class="form-control" value="<?php echo $auditDate; ?>" disabled></td>
										<td>Call Date:</td>
										<td colspan="2"><input type="text" class="form-control" id="call_date" name="call_date" value="<?php echo $clDate_val; ?>" required ></td>
									</tr>
									<tr>
										<td>Agent:</td>
										<td>
											<select class="form-control agentName" id="agent_id" name="data[agent_id]" required>
												<?php if($craftjack_new['agent_id']){ ?>
												<option value="<?php echo $craftjack_new['agent_id'] ?>"><?php echo $craftjack_new['fname']." ".$craftjack_new['lname'] ?></option>
											<?php } ?>
												<option value="">-Select-</option>
												<?php foreach($agentName as $row):  ?>
													<option value="<?php echo $row['id']; ?>"><?php echo $row['name'].' ('.$row['fusion_id'].')'; ?></option>
												<?php endforeach; ?>
											</select>
										</td>
										<td>Fusion ID:</td>
										<td><input type="text" readonly class="form-control" id="fusion_id" name="" value="<?php echo $craftjack_new['fusion_id'] ?>"></td>
										<td>L1 Supervisor:</td>
										<td colspan="2">
											<select class="form-control" id="tl_id" name="data[tl_id]" readonly>
												<option value="<?php echo $craftjack_new['tl_id'] ?>"><?php echo $craftjack_new['tl_name'] ?></option>
												<option value="">--Select--</option>
												<?php foreach($tlname as $tl): ?>
													<option value="<?php echo $tl['id']; ?>"><?php echo $tl['fname']." ".$tl['lname']; ?></option>
												<?php endforeach; ?>
											</select>
										</td>
									</tr>

									<tr>
										<td>Customer Name:</td>
										<td><input type="text" class="form-control" id="customer" name="data[customer]" value="<?php echo $craftjack_new['customer'] ?>" required></td>
										<td>Customer Phone:</td>
										<td><input type="number" class="form-control" id="customer_phone" name="data[customer_phone]" value="<?php echo $craftjack_new['customer_phone'] ?>" required></td>
										<td>Call Duration:</td>
										<td colspan="2"><input type="text" class="form-control" id="call_duration" name="data[call_duration]" value="<?php echo $craftjack_new['call_duration'] ?>" required></td>
									</tr>
									<tr>
										<td>Service Request:</td>
										<td><input type="text" class="form-control" id="service_request" name="data[service_request]" value="<?php echo $craftjack_new['service_request'] ?>" required></td>
										<td>Factor:</td>
										<td><input type="text" class="form-control" id="factor" name="data[factor]" value="<?php echo $craftjack_new['factor'] ?>" required></td>
										<td>L1 Analysis</td>
										<td colspan="2"><input type="text" class="form-control" id="analysis" name="data[analysis]" value="<?php echo $craftjack_new['analysis'] ?>" required></td>
									</tr>
									<tr>

											<td>AHT RCA:<span style="font-size:24px;color:red">*</span></td>
											<td >
											<select class="form-control" id="aht_rca" autocomplete="off" name="data[aht_rca]" value="<?php echo $craftjack_new['aht_rca'] ?>" required>

													<option value="">-Select-</option>
													<option value="Agent">Agent</option>
													<option value="Customer">Customer</option>
													<option value="Process">Process</option>
													<option value="Technical">Technical</option>
													<option value="N/A">N/A</option>
											
												</select>
												</td>
											<td> L1 <span style="font-size:24px;color:red">*</span></td>
											<td>
											<input type="text" class="form-control" id="l1" name="data[l1]" autocomplete="off" value="<?php echo $craftjack_new['l1'] ?>" required>
											</td>

											<td> L2:<span style="font-size:24px;color:red">*</span></td>
											<td>
											<input type="text" class="form-control" id="l2" name="data[l2]" autocomplete="off" value="<?php echo $craftjack_new['l2'] ?>" required>
											</td>

										</tr>
									<tr>
										<!-- <td>Interaction ID:</td>
										<td><input type="text" class="form-control"  name="data[interaction_id]" value="<?php //echo $craftjack_new['interaction_id'] ?>" required></td> -->
										<td>Type of Call:</td>
										<td><input type="text" class="form-control" id="call_type" name="data[call_type]" value="<?php echo $craftjack_new['call_type'] ?>" required></td>
										<!-- <td>Call Pass/Fail:</td>
										<td><input type="text" class="form-control" id="show_pass_fail" name="data[pass_fail]" value="<?php echo $craftjack_new['pass_fail'] ?>" readonly></td> -->
										<td>Fatal Error:</td>
										<td><input type="text" class="form-control" id="fatal_error" name="data[pass_fail]" value="<?php echo $craftjack_new['pass_fail'] ?>" readonly></td>
										<!-- <td>Fatal Error:</td>
										<td>
											<select class="form-control" id="ftl_error" name="data[ftl_error]" required>
												<option value="<?php //echo $craftjack_new['ftl_error'] ?>"><?php echo $craftjack_new['ftl_error'] ?></option>
												<option value="">-Select-</option>
												<option value="Pass">Pass</option>
												<option value="No">No</option>
												
											</select>
										</td> -->

									</tr>

									<tr>
										<td>Audit Type:</td>
										<td>
											<select class="form-control" id="audit_type" name="data[audit_type]" required>
												<option value="<?php echo $craftjack_new['audit_type'] ?>"><?php echo $craftjack_new['audit_type'] ?></option>
												<option value="">-Select-</option>
												<option value="CQ Audit">CQ Audit</option>
												<option value="BQ Audit">BQ Audit</option>
												<option value="Calibration">Calibration</option>
												<option value="Pre-Certification Mock Call">Pre-Certification Mock Call</option>
												<option value="Certification Audit">Certification Audit</option>
												<option value="WOW Call">WOW Call</option>
												<?php if(get_login_type()!="client"){ ?>
													<option value="Operation Audit">Operation Audit</option>
													<option value="Trainer Audit">Trainer Audit</option>
												<?php } ?>
											</select>
										</td>
										<td class="auType">Auditor Type</td>
										<td class="auType">
											<select class="form-control" id="auditor_type" name="data[auditor_type]">
												<option value="<?php echo $craftjack_new['auditor_type'] ?>"><?php echo $craftjack_new['auditor_type'] ?></option>
												<option value="">-Select-</option>
												<option value="Master">Master</option>
												<option value="Regular">Regular</option>
											</select>
										</td>
										<td>VOC:</td>
										<td>
											<select class="form-control" id="voc" name="data[voc]" required>
												<option value="<?php echo $craftjack_new['voc'] ?>"><?php echo $craftjack_new['voc'] ?></option>
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
										<td style="font-weight:bold; font-size:16px">Possible Score:</td>
										<td><input type="text" readonly id="craft_possibleScore" name="data[possible_score]" class="form-control" style="font-weight:bold" value="<?php echo $craftjack_new['possible_score']; ?>"></td>

										<td style="font-weight:bold; font-size:16px">Earned Score:</td>
										<td><input type="text" readonly id="craft_earnedScore" name="data[earned_score]" class="form-control" style="font-weight:bold" value="<?php echo $craftjack_new['earned_score']; ?>"></td>

										<td style="font-weight:bold; font-size:16px; text-align:right">Overall Score:</td>
										<td colspan="2"><input type="text" readonly id="craft_overallScore" name="data[overall_score]" class="form-control pnboutboundFatal" style="font-weight:bold" value="<?php if($craftjack_new['overall_score']){ echo $craftjack_new['overall_score'].'%'; } else { echo '0.00'.'%'; } ?>"></td>
									</tr>
									<tr style="background-color:#A9CCE3; font-weight:bold">
										<td>Parameter</td>
										<td colspan=2>Sub Parameter</td>
										<td>Points</td>
										<td>Status</td>
										<td colspan="2">Comments</td>
									</tr>
									  <tr>
										<td rowspan=2 style="background-color:#A9CCE3; font-weight:bold">Opening</td>
										<td colspan=2 style="color:red">Opened call Properly (did the agent mentioned about Recorded Line)</td>
										<td>10</td>
										<td>
											<select class="form-control craftjack_point" id="fatal_error1" name="data[opened_call_properly]" required>
												
												<option craftjack_val=10 craftjack_max=10 <?php echo $craftjack_new['opened_call_properly']=='Pass'?"selected":""; ?> value="Pass">Pass</option>
												<option craftjack_val=0 craftjack_max=10 <?php echo $craftjack_new['opened_call_properly']=='Fail'?"selected":""; ?> value="Fail">Fail</option>
												<option craftjack_val=0 <?php echo $craftjack_new['opened_call_properly']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
										<td colspan="2"><input type="text" name="data[cmt1]" value="<?= $craftjack_new['cmt1']?>" class="form-control"/></td>
									</tr>
									
									<tr>
										
										<td colspan=2>Confirmed Requested Job</td>
										<td>5</td>
										<td>
											<select class="form-control craftjack_point" id="" name="data[confirmed_requested]" required>
												
												<option craftjack_val=5 craftjack_max=5 <?php echo $craftjack_new['confirmed_requested']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option craftjack_val=0 craftjack_max=5 <?php echo $craftjack_new['confirmed_requested']=='No'?"selected":""; ?> value="No">No</option>
												<option craftjack_val=0 <?php echo $craftjack_new['confirmed_requested']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
										<td colspan="2"><input type="text" name="data[cmt2]" value="<?= $craftjack_new['cmt2']?>" class="form-control"/></td>
									</tr>
									<tr>
									<td rowspan=3 style="background-color:#A9CCE3; font-weight:bold">Job Done</td>
										<td colspan=2 style="color:red">Probed Job done</td>
										<td>5</td>
										<td>
											<select class="form-control craftjack_point" id="fatal_error2" name="data[probed_job]" required>
												
												<option craftjack_val=5 craftjack_max=5 <?php echo $craftjack_new['probed_job']=='Pass'?"selected":""; ?> value="Pass">Pass</option>
												<option craftjack_val=0 craftjack_max=5 <?php echo $craftjack_new['probed_job']=='Fail'?"selected":""; ?> value="Fail">Fail</option>
												<option craftjack_val=0 <?php echo $craftjack_new['probed_job']=='NA'?"selected":""; ?> value="NA">NA</option>

											</select>
										</td>
										<td colspan="2"><input type="text" name="data[cmt3]" value="<?= $craftjack_new['cmt3']?>" class="form-control"/></td>
									</tr>
									<tr>
										<td colspan=2>Job done by suggested company</td>
										<td>5</td>
										<td>
											<select class="form-control craftjack_point" id="" name="data[suggested_company]" required>
												

												<option craftjack_val=5 craftjack_max=5 <?php echo $craftjack_new['suggested_company']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option craftjack_val=0 craftjack_max=5 <?php echo $craftjack_new['suggested_company']=='No'?"selected":""; ?> value="No">No</option>
												<option craftjack_val=0 <?php echo $craftjack_new['suggested_company']=='NA'?"selected":""; ?> value="NA">NA</option>

											</select>
										</td>
										<td colspan="2"><input type="text" name="data[cmt4]" value="<?= $craftjack_new['cmt4']?>" class="form-control"/></td>
									</tr>

									<tr>
										<td colspan=2>Probed Experience</td>
										<td>5</td>
										<td>
											<select class="form-control craftjack_point" id="" name="data[probed_experience]" required>
												<option craftjack_val=5 craftjack_max=5 <?php echo $craftjack_new['probed_experience']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option craftjack_val=0 craftjack_max=5 <?php echo $craftjack_new['probed_experience']=='No'?"selected":""; ?> value="No">No</option>
												<option craftjack_val=0 <?php echo $craftjack_new['probed_experience']=='NA'?"selected":""; ?> value="NA">NA</option>

											</select>
										</td>
										<td colspan="2"><input type="text" name="data[cmt5]" value="<?= $craftjack_new['cmt5']?>" class="form-control"/></td>
									</tr>

									<tr>
										<td rowspan=1 style="background-color:#A9CCE3; font-weight:bold">Offered Upsell</td>
										<td colspan=2 style="color:red">Offered Upsell</td>
										<td>10</td>
										<td>
											<select class="form-control craftjack_point" id="fatal_error3" name="data[offered_upsell]" required>
												
												<option craftjack_val=10 craftjack_max=10 <?php echo $craftjack_new['offered_upsell']=='Pass'?"selected":""; ?> value="Pass">Pass</option>
												<option craftjack_val=0 craftjack_max=10 <?php echo $craftjack_new['offered_upsell']=='Fail'?"selected":""; ?> value="Fail">Fail</option>
												<option craftjack_val=0 <?php echo $craftjack_new['offered_upsell']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
										<td colspan="2"><input type="text" name="data[cmt6]" value="<?= $craftjack_new['cmt6']?>" class="form-control"/></td>
									</tr>

									<tr>
										<td rowspan=3 style="background-color:#A9CCE3; font-weight:bold">SR</td>
										<td colspan=2>Authorised to Send Details</td>
										<td>5</td>
										<td>
											<select class="form-control craftjack_point" id="" name="data[authorised_to]" required>
												
												<option craftjack_val=5 craftjack_max=5 <?php echo $craftjack_new['authorised_to']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option craftjack_val=0 craftjack_max=5 <?php echo $craftjack_new['authorised_to']=='No'?"selected":""; ?> value="No">No</option>
												<option craftjack_val=0 <?php echo $craftjack_new['authorised_to']=='NA'?"selected":""; ?> value="NA">NA</option>

											</select>
										</td>
										<td colspan="2"><input type="text" name="data[cmt7]" value="<?= $craftjack_new['cmt7']?>" class="form-control"/></td>
									</tr>
									<tr>
										<td colspan=2 style="color:red">Gather Contact Details (email/phone/address)</td>
										<td>10</td>
										<td>
											<select class="form-control craftjack_point" id="fatal_error4" name="data[gather_contact]" required>
												
												<option craftjack_val=10 craftjack_max=10 <?php echo $craftjack_new['gather_contact']=='Pass'?"selected":""; ?> value="Pass">Pass</option>
												<option craftjack_val=0 craftjack_max=10 <?php echo $craftjack_new['gather_contact']=='Fail'?"selected":""; ?> value="Fail">Fail</option>
												<option craftjack_val=0 <?php echo $craftjack_new['gather_contact']=='NA'?"selected":""; ?> value="NA">NA</option>

											</select>
										</td>
										<td colspan="2"><input type="text" name="data[cmt8]" value="<?= $craftjack_new['cmt8']?>" class="form-control"/></td>
									</tr>
									<tr>
										<td colspan=2 style="color:red">Read Contact Verbatim</td>
										<td>10</td>
										<td>
											<select class="form-control craftjack_point" id="fatal_error5" name="data[contact_verbatim]" required>
												

												<option craftjack_val=10 craftjack_max=10 <?php echo $craftjack_new['contact_verbatim']=='Pass'?"selected":""; ?> value="Pass">Pass</option>
												<option craftjack_val=0 craftjack_max=10 <?php echo $craftjack_new['contact_verbatim']=='Fail'?"selected":""; ?> value="Fail">Fail</option>
												<option craftjack_val=0 <?php echo $craftjack_new['contact_verbatim']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
										<td colspan="2"><input type="text" name="data[cmt9]" value="<?= $craftjack_new['cmt9']?>" class="form-control"/></td>
									</tr>

									<!-- <tr>
										<td colspan=2>Informed Contact procedure</td>
										<td>5</td>
										<td>
											<select class="form-control craftjack_point" id="pass_fail7" name="data[informed_contact]" required>
												
												<option craftjack_val=5 craftjack_max=5 <?php echo $craftjack_new['informed_contact']=='Pass'?"selected":""; ?> value="Pass">Pass</option>
												<option craftjack_val=0 craftjack_max=5 <?php echo $craftjack_new['informed_contact']=='Fail'?"selected":""; ?> value="Fail">Fail</option>
												<option craftjack_val=0 <?php echo $craftjack_new['informed_contact']=='NA'?"selected":""; ?> value="NA">NA</option>

											</select>
										</td>
										<td colspan="2"><input type="text" name="data[cmt10]" value="<?= $craftjack_new['cmt10']?>" class="form-control"/></td>
									</tr> -->
									
									<tr>
										<td rowspan=5 style="background-color:#A9CCE3; font-weight:bold">Communication</td>
										<td colspan=2>Active Listening </td>
										<td>5</td>
										<td>
											<select class="form-control craftjack_point"  id="" name="data[active_listening]" required>
												
												<option craftjack_val=5 craftjack_max=5 <?php echo $craftjack_new['active_listening']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option craftjack_val=0 craftjack_max=5 <?php echo $craftjack_new['active_listening']=='No'?"selected":""; ?> value="No">No</option>
												<option craftjack_val=0 <?php echo $craftjack_new['active_listening']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
										<td colspan="2"><input type="text" name="data[cmt15]" value="<?= $craftjack_new['cmt15']?>" class="form-control"/></td>
									</tr>
									<tr>
										
										<td colspan=2 style="color:red">Interrupted customer
                                        </td>
										<td>10</td>
										<td>
											<select class="form-control craftjack_point"  id="fatal_error6" name="data[interrupted_customer]" required>
												
												<option craftjack_val=10 craftjack_max=10 <?php echo $craftjack_new['interrupted_customer']=='Pass'?"selected":""; ?> value="Pass">Pass</option>
												<option craftjack_val=0 craftjack_max=10 <?php echo $craftjack_new['interrupted_customer']=='Fail'?"selected":""; ?> value="Fail">Fail</option>
												<option craftjack_val=0 <?php echo $craftjack_new['interrupted_customer']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
										<td colspan="2"><input type="text" name="data[cmt11]" value="<?= $craftjack_new['cmt11']?>" class="form-control"/></td>
									</tr>
									
									<tr>
										
										<td colspan=2>Call Etiquette </td>
										<td>5</td>
										<td>
											<select class="form-control craftjack_point"  id="" name="data[call_etiquette]" required>
												
												<option craftjack_val=5 craftjack_max=5 <?php echo $craftjack_new['call_etiquette']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option craftjack_val=0 craftjack_max=5 <?php echo $craftjack_new['call_etiquette']=='No'?"selected":""; ?> value="No">No</option>
												<option craftjack_val=0 <?php echo $craftjack_new['call_etiquette']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
										<td colspan="2"><input type="text" name="data[cmt16]" value="<?= $craftjack_new['cmt16']?>" class="form-control"/></td>
									</tr>
									<tr>
										<td colspan=2>Rate of speech / Clarity  </td>
										<td>5</td>
										<td>
											<select class="form-control craftjack_point" name="data[rate_of_speech]" required>
												
												<option craftjack_val=5 craftjack_max=5 <?php echo $craftjack_new['rate_of_speech']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option craftjack_val=0 craftjack_max=5 <?php echo $craftjack_new['rate_of_speech']=='No'?"selected":""; ?> value="No">No</option>
												<option craftjack_val=0 <?php echo $craftjack_new['rate_of_speech']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
										<td colspan="2"><input type="text" name="data[cmt12]" value="<?= $craftjack_new['cmt12']?>" class="form-control"/></td>
									</tr>
									<tr>
										<td colspan=2>Ownership of call</td>
										<td>5</td>
										<td>
											<select class="form-control craftjack_point" name="data[ownership_of_call]" required>
												
												<option craftjack_val=5 craftjack_max=5 <?php echo $craftjack_new['ownership_of_call']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
						
												<option craftjack_val=0 craftjack_max=5 <?php echo $craftjack_new['ownership_of_call']=='No'?"selected":""; ?> value="No">No</option>

												<option craftjack_val=0 <?php echo $craftjack_new['ownership_of_call']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
										<td colspan="2"><input type="text" name="data[cmt13]" value="<?= $craftjack_new['cmt13']?>" class="form-control"/></td>
									</tr>
									<tr>
										<td rowspan=1 style="background-color:#A9CCE3; font-weight:bold">Closing</td>
										<td colspan=2>Closing</td>
										<td>5</td>
										<td>
											<select class="form-control craftjack_point" id="" name="data[closing]" required>
												
												<option craftjack_val=5 craftjack_max=5 <?php echo $craftjack_new['closing']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option craftjack_val=0 craftjack_max=5 <?php echo $craftjack_new['closing']=='No'?"selected":""; ?> value="No">No</option>
												<option craftjack_val=0 <?php echo $craftjack_new['closing']=='NA'?"selected":""; ?> value="NA">NA</option>
											</select>
										</td>
										<td colspan="2"><input type="text" name="data[cmt14]" value="<?= $craftjack_new['cmt14']?>" class="form-control"/></td>
									</tr>
									<tr>
										<td rowspan=2 style="background-color:#A9CCE3; font-weight:bold">QA Comments</td>
										<td colspan=2>Positive
                                        </td>
										<td></td>
										<td colspan="3">
											<textarea class="form-control" id="" name="data[positive]" required><?php echo $craftjack_new['positive'] ?></textarea>
										</td>
										<td></td>
									</tr>
									<tr>
										<td colspan=2>Negative
                                        </td>
										<td></td>
										<td colspan="3">
											<textarea class="form-control" id="" name="data[negative]" required><?php echo $craftjack_new['negative'] ?></textarea>
										</td>
									</tr>
									
									<tr>
										<td>Call Summary:</td>
										<td colspan=2><textarea class="form-control" id="" name="data[call_summary]"><?php echo $craftjack_new['call_summary'] ?></textarea></td>
										<td>Feedback:</td>
										<td colspan=2><textarea class="form-control" id="" name="data[feedback]"><?php echo $craftjack_new['feedback'] ?></textarea></td>
									</tr>

									<?php if($craftjack_id==0){ ?>
									<tr>
										<td colspan=2>Upload Files</td>
										<td colspan=5><input type="file" multiple class="form-control" id="attach_file" name="attach_file[]"></td>
									</tr>
									<?php }else{ ?>
									<tr>
										<td colspan=2>Upload Files</td>
										<?php if($craftjack_new['attach_file']!=''){ ?>
											<td colspan=5>
												<?php $attach_file = explode(",",$craftjack_new['attach_file']);
												 foreach($attach_file as $mp){ ?>
													<audio controls='' style="background-color:#607F93">
													  <source src="<?php echo base_url(); ?>qa_files/craftjack/<?php echo $mp; ?>" type="audio/ogg">
													  <source src="<?php echo base_url(); ?>qa_files/craftjack/<?php echo $mp; ?>" type="audio/mpeg">
													</audio> </br>
												 <?php } ?>
											</td>
										<?php }else{
												//echo '<td colspan=6><b>No Files</b></td>';
											  }
										} ?>
									</tr>


									<?php if($craftjack_id!=0){ ?>
										<tr><td colspan=2 style="font-size:16px; font-weight:bold">Agent Feedback Acceptance:</td><td colspan=5><?php echo $craftjack_new['agnt_fd_acpt'] ?></td></tr>
										<tr><td colspan=2 style="font-size:16px; font-weight:bold">Management Review:</td><td colspan=5><?php echo $craftjack_new['mgnt_rvw_note'] ?></td></tr>
										<tr><td colspan=2 style="font-size:16px; font-weight:bold">Client Review:</td><td colspan=5><?php echo $craftjack_new['client_rvw_note'] ?></td></tr>

										<tr><td colspan=2  style="font-size:16px">Your Review</td><td colspan=5><textarea class="form-control1" style="width:100%" id="note" name="note"  ><?php echo $craftjack_new['agent_rvw_note'] ?></textarea></td></tr>
									<?php } ?>


									<?php
									if($craftjack_id==0){
										if(is_access_qa_module()==true || is_access_qa_operations_module()==true){ ?>
											<tr><td colspan=8><button class="btn btn-success waves-effect" type="submit" id="qaformsubmit" style="width:500px">SAVE</button></td></tr>
									<?php
										}
									}else{
                                          /*
										if(is_access_qa_module()==true || is_access_qa_operations_module()==true){
											 if($craftjack_new['agent_rvw_note']=="") { 
                                           */
										?>
												<tr><td colspan="8"><button class="btn btn-success waves-effect" type="submit" id='qaformsubmit' name='btnSave' value="SAVE" style="width:500px">SAVE</button></td></tr>
									<?php
                                      /*
										}
										}
									  */
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
