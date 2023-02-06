
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
			<div class="col-12">
				<div class="widget">
				
					<div class="widget-body">
						<div class="table-responsive">
							<table class="table table-striped skt-table" width="100%">
								<tbody>
									<tr style="background-color:#AEB6BF"><td colspan="12" id="theader" style="font-size:30px">Mobikwik Audit Sheet</td></tr>
									
									<?php
										if($mobikwik_id==0){
											$auditorName = get_username();
											$auditDate = CurrDateMDY();
											$clDate_val='';
										}else{
											if($mobikwik_new['entry_by']!=''){
												$auditorName = $mobikwik_new['auditor_name'];
											}else{
												$auditorName = $mobikwik_new['client_name'];
											}
											$auditDate = mysql2mmddyy($mobikwik_new['audit_date']);
											$clDate_val = mysqlDt2mmddyy($mobikwik_new['call_date']);
										}
									?>
									<tr>
										<td>Name of Auditor:</td>
										<td colspan=2><input type="text" class="form-control" value="<?php echo $auditorName; ?>" disabled></td>
										<td style="width:100px">Date of Audit:</td>
										<td style="width:250px" colspan=2><input type="text" class="form-control" value="<?php echo $auditDate; ?>" disabled></td>
										<td>Call Date/Time:</td>
										<td colspan=2><input type="text" class="form-control" id="call_date_time" name="call_date" value="<?php echo $clDate_val; ?>" disabled></td>
									</tr>
									<tr>
										<?php
										$desig = '';
										?>
										<td>Agent/TL/QA/Trainer:</td>
										<td colspan=2>
											<select class="form-control" id="agent_id" name="data[agent_id]" disabled>
												<option value="<?php echo $mobikwik_new['agent_id'] ?>"><?php echo $mobikwik_new['fname']." ".$mobikwik_new['lname'] ?></option>
												<option value="">-Select-</option>
												<?php foreach($agentName as $row):  ?>
													<?php 
													if($row['roleName'] == 'QA Auditor' || $row['roleName'] == 'QA Specialist' || $row['roleName'] == 'Quality Analyst'){
														$desig = 'QA';

													}else{
														$desig = strtoupper($row['designation']);
													}
													?>
													<option value="<?php echo $row['id']; ?>"><?php echo $row['name'].'--('.$desig.')'; ?></option>
												<?php endforeach; ?>
											</select>
										</td>
										<td>MWP ID:</td>
										<td colspan=2><input type="text" class="form-control" id="fusion_id" value="<?php echo $mobikwik_new['fusion_id'] ?>" readonly></td>
										<td>L1 Supervisor:</td>
										<td colspan=2>
											<select class="form-control" id="tl_id" name="data[tl_id]" readonly>
												<option value="<?php echo $mobikwik_new['tl_id'] ?>"><?php echo $mobikwik_new['tl_name'] ?></option>
												<option value="">--Select--</option>
												<?php foreach($tlname as $tl): ?>
													<option value="<?php echo $tl['id']; ?>"><?php echo $tl['fname']." ".$tl['lname']; ?></option>
												<?php endforeach; ?>	
											</select>
										</td>
									</tr>
									<tr>
										<td>Designation:</td>
										<?php 
										$desig1 = '';
										if($mobikwik_new['agent_id']!=''){
											if($mobikwik_new['roleName'] == 'QA Auditor' || $mobikwik_new['roleName'] == 'QA Specialist' || $mobikwik_new['roleName'] == 'Quality Analyst'){
														$desig1 = 'QA';

													}else{
														$desig1 = strtoupper($mobikwik_new['designation']);
											}
											?>
											<td colspan=2><input type="text" class="form-control" id="designation" name="" value="<?php echo $desig1; ?>" readonly></td>
											<?php

										}else{
											?>
											<td colspan=2><input type="text" class="form-control" id="designation" name="" value="" readonly></td>
											<?php
										}
										?>
										<td>AHT:</td>
										<td colspan=2><input type="text" class="form-control" id="call_duration" name="data[call_duration]" value="<?php echo $mobikwik_new['call_duration'] ?>" disabled></td>
										<!-- <td>Product Name:</td>

										<td colspan=2><input type="text" class="form-control" id="product_name" name="data[product_name]" value="<?php echo $mobikwik_new['product_name'] ?>" disabled></td> -->
									
										<td>Customer VOC:</td>
										<td colspan=2><input type="text" class="form-control" id="cust_voc" name="data[customer_voc]" value="<?php echo $mobikwik_new['customer_voc'] ?>" disabled></td>
										
									</tr>
									<tr>
										
										<td>Objections:</td>
										<td colspan=2><input type="text" class="form-control" id="objections" name="data[objections]" value="<?php echo $mobikwik_new['objections'] ?>" disabled></td>
										<td>Email ID:</td>
										<td colspan=2><input type="text" class="form-control" id="email" name="data[email]" value="<?php echo $mobikwik_new['email'] ?>" disabled></td>
										
									</tr>
									<tr>
										<td>Phone:</td>
										<td colspan=2><input type="text" class="form-control" id="phone" name="data[customer_phone]" onkeyup="checkDec(this);" value="<?php echo $mobikwik_new['customer_phone'] ?>" disabled></td>
										<td>Agent Disposition:</td>
										<td colspan=2><input type="text" class="form-control" name="data[agent_disposition]" value="<?php echo $mobikwik_new['agent_disposition'] ?>" disabled></td>
										<td>QA Disposition:</td>
										<td colspan=2><input type="text" class="form-control" name="data[qa_disposition]" value="<?php echo $mobikwik_new['qa_disposition'] ?>" disabled></td>
									</tr>
									<tr>
									<td>ACPT:</td>
										<td colspan=2>
											<select class="form-control" name="data[acpt]" disabled>
												<option value="">Select</option>
											<option <?php echo $mobikwik_new['acpt']=='Agent'?"selected":""; ?> value="Agent">Agent</option>
											<option <?php echo $mobikwik_new['acpt']=='Customer'?"selected":""; ?> value="Customer">Customer</option>
											<option <?php echo $mobikwik_new['acpt']=='Product'?"selected":""; ?> value="Product">Product</option>
											<option <?php echo $mobikwik_new['acpt']=='Process'?"selected":""; ?> value="Process">Process</option>
											<option <?php echo $mobikwik_new['acpt']=='Technology'?"selected":""; ?> value="Technology">Technology</option>
											</select>
										</td>
									<td>ACPT 1 Remarks</td>
									<td colspan=2><input type="text" class="form-control" name="data[acpt1]" value="<?php echo $mobikwik_new['acpt1'] ?>" disabled></td>
									<td>ACPT 2 Remarks</td>
									<td colspan=2><input type="text" class="form-control" name="data[acpt2]" value="<?php echo $mobikwik_new['acpt2'] ?>" disabled></td>

									</tr>
									<tr>
										<td>Audit Type:</td>
										<td colspan=2>
											<select class="form-control" id="audit_type" name="data[audit_type]" disabled>
												<option value="">-Select-</option>
												<option <?php echo $mobikwik_new['audit_type']=='CQ Audit'?"selected":""; ?> value="CQ Audit">CQ Audit</option>
												<option <?php echo $mobikwik_new['audit_type']=='BQ Audit'?"selected":""; ?> value="BQ Audit">BQ Audit</option>
												<option <?php echo $mobikwik_new['audit_type']=='Calibration'?"selected":""; ?> value="Calibration">Calibration</option>
												<option <?php echo $mobikwik_new['audit_type']=='Pre-Certificate Mock Call'?"selected":""; ?> value="Pre-Certificate Mock Call">Pre-Certificate Mock Call</option>
												<option <?php echo $mobikwik_new['audit_type']=='Certificate Audit'?"selected":""; ?> value="Certificate Audit">Certificate Audit</option>
												<?php if(get_login_type()!="client"){ ?>
													<option <?php echo $mobikwik_new['audit_type']=='Operation Audit'?"selected":""; ?> value="Operation Audit">Operation Audit</option>
													<option <?php echo $mobikwik_new['audit_type']=='Trainer Audit'?"selected":""; ?> value="Trainer Audit">Trainer Audit</option>
												<?php } ?>
											</select>
										</td>
										<td class="auType">Auditor Type</td>
										<td colspan=2 class="auType">
											<select class="form-control" id="auditor_type" disabled name="data[auditor_type]">
												<option value="">-Select-</option>
												<option <?= ($mobikwik_new['auditor_type']=="Master")?"selected":""?> value="Master">Master</option>
												<option <?= ($mobikwik_new['auditor_type']=="Regular")?"selected":""?> value="Regular">Regular</option>
											</select>
										</td>
										<td>VOC:</td>
										<td colspan=2>
											<select class="form-control" id="voc" name="data[voc]" disabled>
												<option value="">-Select-</option>
												<option <?php echo $mobikwik_new['voc']=='1'?"selected":""; ?> value="1">1</option>
												<option <?php echo $mobikwik_new['voc']=='2'?"selected":""; ?> value="2">2</option>
												<option <?php echo $mobikwik_new['voc']=='3'?"selected":""; ?> value="3">3</option>
												<option <?php echo $mobikwik_new['voc']=='4'?"selected":""; ?> value="4">4</option>
												<option <?php echo $mobikwik_new['voc']=='5'?"selected":""; ?> value="5">5</option>
											</select>
										</td>
									</tr>
									<tr>
										<td style="font-weight:bold; font-size:16px; text-align:center">Possible Score:</td>
										<td colspan=2><input type="text" value="<?= $mobikwik_new['possible_score']?>" readonly id="idfcPossibleScore" name="data[possible_score]" class="form-control" style="font-weight:bold"></td>
										<td style="font-weight:bold; font-size:16px; text-align:left">Earned Score:</td>
										<td colspan=2><input type="text" value="<?= $mobikwik_new['earned_score']?>" readonly id="idfcEarnedScore" name="data[earned_score]" class="form-control" style="font-weight:bold"></td>
										<td style="font-weight:bold; font-size:16px; text-align:right">Overall Score:</td>
										<td colspan=2><input type="text" value="<?= $mobikwik_new['overall_score']?>" readonly id="idfcOverallScore" name="data[overall_score]" class="form-control " style="font-weight:bold"></td>
									</tr>
									<tr style="background-color:#5DADE2; font-weight:bold; color:white">
										<th>Parameters</th>
										<th>Sub-Parameters</th>
										<th>Status</th>
										<th colspan=3>Legend</th>
										<th colspan=2>Remarks</th>
									</tr>
									<tr>
										<td >Greeting</td>
										<td>Call Opening </td>
										<td style=width:100px;>
											<select name="data[call_opening]" class="form-control idfc" disabled>
												<!-- <option value="">Select</option> -->
												<option idfc_val=10 <?= ($mobikwik_new['call_opening']=="Yes")?"selected":""?> value='Yes'>Yes</option>
												<option idfc_val=10 <?= ($mobikwik_new['call_opening']=="No")?"selected":""?> value='No'>No</option>
												<option idfc_val=0 <?= ($mobikwik_new['call_opening']=="N/A")?"selected":""?> value='N/A'>N/A</option>
												</select> 
										</td>
										<td colspan=3>
											<p> 
												<strong>:</strong>Verify that greeting must contain salutation, organization and agent name.  
											</p>
										</td>
										<td colspan=3><input type="text" value="<?= $mobikwik_new['call_opening_cmnt']?>" disabled name="data[call_opening_cmnt]" class="form-control"></td>
									</tr>
									
									<tr>
										<td class="fatal">Verification</td>
										<td class="fatal">Verify any of the two details for verification from the list </td>
										<td>
											<select name="data[verification]" class="form-control idfc" id="idfcAF1" disabled>
											<!-- <option value="">Select</option> -->
												<option idfc_val=10 <?= ($mobikwik_new['verification']=="Yes")?"selected":""?> value='Yes'>Yes</option>
												<option idfc_val=10 <?= ($mobikwik_new['verification']=="Fatal")?"selected":""?> value='Fatal'>Fatal</option>
												<option idfc_val=0 <?= ($mobikwik_new['verification']=="N/A")?"selected":""?> value='N/A'>N/A</option>
											</select>
										</td>
										<td colspan=3>
											<p> 
												<strong>: </strong>Verify that complete verification procedure is followed and Registered phone number, email id or last 2 add money history/wallet transaction are verified.
											</p>
										</td>
										<td colspan=3><input type="text" value="<?= $mobikwik_new['verification_cmnt']?>" disabled name="data[verification_cmnt]" class="form-control"></td>
									</tr>
									
									<tr>
										<td class="fatal" rowspan=4>Problem Resolution</td>
										<td class="fatal">Understanding of user concern</td>
										<td>
											<select name="data[concern]" class="form-control idfc"id="idfcAF2"  disabled>
											<!-- <option value="">Select</option> -->
												<option idfc_val=5 <?= ($mobikwik_new['concern']=="Yes")?"selected":""?> value='Yes'>Yes</option>
												<option idfc_val=5 <?= ($mobikwik_new['concern']=="Fatal")?"selected":""?> value='Fatal'>Fatal</option>
												<option idfc_val=0 <?= ($mobikwik_new['concern']=="N/A")?"selected":""?> value='N/A'>N/A</option>
											</select>
										</td>
										<td colspan=3>
											<p>
												<strong>:</strong>
												Has the agent confirmed user concern and paraphrase it for confirmation.
											</p>
										</td>
										<td colspan=3><input type="text" value="<?= $mobikwik_new['concern_cmnt']?>" disabled name="data[concern_cmnt]" class="form-control"></td>
									</tr>
									<tr>
										
										<td class="fatal">System Check for Previously Raised Complaint</td>
										<td>
											<select name="data[raised_complaint]" class="form-control idfc" id="idfcAF3" disabled>
											<!-- <option value="">Select</option> -->
												<option idfc_val=5 <?= ($mobikwik_new['raised_complaint']=="Yes")?"selected":""?> value='Yes'>Yes</option>
												<option idfc_val=5 <?= ($mobikwik_new['raised_complaint']=="Fatal")?"selected":""?> value='Fatal'>Fatal</option>
												<option idfc_val=0 <?= ($mobikwik_new['raised_complaint']=="N/A")?"selected":""?> value='N/A'>N/A</option>
											</select>
										</td>
										<td colspan=3>
											<p>
												<strong>:</strong>
												Has the agent checked for previously raised complaint.
											</p>
										</td>
										<td colspan=3><input type="text" value="<?= $mobikwik_new['raised_complaint_cmnt']?>" disabled name="data[raised_complaint_cmnt]" class="form-control"></td>
									</tr>
									<tr>
										<td class="fatal">Problem Resolution</td>
										<td>
											<select name="data[resolution]" class="form-control idfc" id="idfcAF4" disabled>
											<!-- <option value="">Select</option> -->
												<option idfc_val=10 <?= ($mobikwik_new['resolution']=="Yes")?"selected":""?> value='Yes'>Yes</option>
												<option idfc_val=10 <?= ($mobikwik_new['resolution']=="Fatal")?"selected":""?> value='Fatal'>Fatal</option>
												<option idfc_val=0 <?= ($mobikwik_new['resolution']=="N/A")?"selected":""?> value='N/A'>N/A</option>
											</select>
										</td>
										<td colspan=3>
											<p> 
												<strong>:</strong>
												Has the resolution provided for the current query/complaint is accurate.
												
											</p>
										</td>
										<td colspan=3><input type="text" value="<?= $mobikwik_new['resolution_cmnt']?>" disabled name="data[resolution_cmnt]" class="form-control"></td>
									</tr>
									<tr>
										<td class="fatal">Escalation Matrix</td>
										<td>
											<select name="data[matrix]" class="form-control idfc" id="idfcAF5" disabled>
											<!-- <option value="">Select</option> -->
												<option idfc_val=10 <?= ($mobikwik_new['matrix']=="Yes")?"selected":""?> value='Yes'>Yes</option>
												<option idfc_val=10 <?= ($mobikwik_new['matrix']=="Fatal")?"selected":""?> value='Fatal'>Fatal</option>
												<option idfc_val=0 <?= ($mobikwik_new['matrix']=="N/A")?"selected":""?> value='N/A'>N/A</option>
											</select>
										</td>
										<td colspan=3>
											<p> 
												<strong>:</strong>
												1. Verify whether escalation matrix is followed and the concern is escalated to correct team for earliest resolution.
												2. Verify if the call is transferred/ call back arranged by agent for the user
												
											</p>
										</td>
										<td colspan=3><input type="text" value="<?= $mobikwik_new['matrix_cmnt']?>" disabled name="data[matrix_cmnt]" class="form-control"></td>
									</tr>
									<tr>
										<td rowspan=3>Closing</td>
										<td>Ask for further assistance</td>
										<td>
											<select name="data[assistance]" class="form-control idfc" disabled>
											<!-- <option value="">Select</option> -->
												<option idfc_val=3 <?= ($mobikwik_new['assistance']=="Yes")?"selected":""?> value='Yes'>Yes</option>
												<option idfc_val=3 <?= ($mobikwik_new['assistance']=="No")?"selected":""?> value='No'>No</option>
												<option idfc_val=0 <?= ($mobikwik_new['assistance']=="N/A")?"selected":""?> value='N/A'>N/A</option>
											</select>
										</td>
										<td colspan=3>
											<p>
												<strong>:</strong>
												Has the agent asked for further assistance on call.
											</p>
										</td>
										<td colspan=3><input type="text" value="<?= $mobikwik_new['assistance_cmnt']?>" disabled name="data[assistance_cmnt]" class="form-control"></td>
									</tr>
									<tr>
										<td>Follow complete closing script</td>
										<td>
											<select name="data[complete]" class="form-control idfc" disabled>
											<!-- <option value="">Select</option> -->
												<option idfc_val=3 <?= ($mobikwik_new['complete']=="Yes")?"selected":""?> value='Yes'>Yes</option>
												<option idfc_val=3 <?= ($mobikwik_new['complete']=="No")?"selected":""?> value='No'>No</option>
												<option idfc_val=0 <?= ($mobikwik_new['complete']=="N/A")?"selected":""?> value='N/A'>N/A</option>
											</select>
										</td>
										<td colspan=3>
											<p> 
												<strong>:</strong>
												Has the agent followed complete closing script.
												
											</p>
										</td>
										<td colspan=3><input type="text" value="<?= $mobikwik_new['complete_cmnt']?>" disabled name="data[complete_cmnt]" class="form-control"></td>
									</tr>
									<tr>
										<td>Pitch Disclaimer</td>
										<td>
											<select name="data[disclaimer]" class="form-control idfc" disabled>
											<!-- <option value="">Select</option> -->
												<option idfc_val=4 <?= ($mobikwik_new['disclaimer']=="Yes")?"selected":""?> value='Yes'>Yes</option>
												<option idfc_val=4 <?= ($mobikwik_new['disclaimer']=="No")?"selected":""?> value='No'>No</option>
												<option idfc_val=0 <?= ($mobikwik_new['disclaimer']=="N/A")?"selected":""?> value='N/A'>N/A</option>
											</select>
										</td>
										<td colspan=3>
											<p> 
												<strong>:</strong>
												Has the agent conveyed disclaimer on call.
												
											</p>
										</td>
										<td colspan=3><input type="text" value="<?= $mobikwik_new['disclaimer_cmnt']?>" disabled name="data[disclaimer_cmnt]" class="form-control"></td>
									</tr>
									<tr>
										<td class="" rowspan="2">After Call Work</td>
										<td class="">Remarks </td>
										<td>
											<select name="data[remarks]" class="form-control idfc" id="mobikwik1" disabled>
											<!-- <option value="">Select</option> -->
												<option idfc_val=10 <?= ($mobikwik_new['remarks']=="Yes")?"selected":""?> value='Yes'>Yes</option>
												<option idfc_val=10 <?= ($mobikwik_new['remarks']=="No")?"selected":""?> value='No'>No</option>
												<option idfc_val=0 <?= ($mobikwik_new['remarks']=="N/A")?"selected":""?> value='N/A'>N/A</option>
												</select>
										</td>
										<td colspan=3>
											<p> 
												<strong>:</strong>
												Complete Remarks Should be mentioned by agent on Fresh work.
											</p>
										</td>
										<td colspan=3><input type="text" value="<?= $mobikwik_new['remarks_cmnt']?>" disabled name="data[remarks_cmnt]" class="form-control"></td>
									</tr>
									<tr>
										
										<td class="fatal">Disposition </td>
										<td>
											<select name="data[disposition]" class="form-control idfc" id="idfcAF7" disabled>
											<!-- <option value="">Select</option> -->
												<option idfc_val=10 <?= ($mobikwik_new['disposition']=="Yes")?"selected":""?> value='Yes'>Yes</option>
												<option idfc_val=10 <?= ($mobikwik_new['disposition']=="Fatal")?"selected":""?> value='Fatal'>Fatal</option>
												<option idfc_val=0 <?= ($mobikwik_new['disclaimer']=="N/A")?"selected":""?> value='N/A'>N/A</option>
												</select>
										</td>
										<td colspan=3>
											<p> 
												<strong>:</strong>
												Check for the disposition details from report to ensure that call is mapped under correct category.
											</p>
										</td>
										<td colspan=3><input type="text" value="<?= $mobikwik_new['disposition_cmnt']?>" disabled name="data[disposition_cmnt]" class="form-control"></td>
									</tr>
									<tr>
										<td class="" rowspan="6">Etiquettes</td>
										<td class="fatal">Be polite with customer/Agent hangup</td>
										<td>
											<select name="data[hangup]" class="form-control idfc" id="idfcAF6" disabled>
												<!-- <option value="">Select</option> -->
												<option idfc_val=5 <?= ($mobikwik_new['hangup']=="Yes")?"selected":""?> value='Yes'>Yes</option>
												<option idfc_val=5 <?= ($mobikwik_new['hangup']=="Fatal")?"selected":""?> value='Fatal'>Fatal</option>
												<option idfc_val=0 <?= ($mobikwik_new['hangup']=="N/A")?"selected":""?> value='N/A'>N/A</option>
											</select>
										</td>
										<td colspan=3>
											<p> 
												<strong>:</strong>
												Use of profanity, Rudeness, Sarcasm, Shouting and Agent hang-up.
											
											</p>
										</td>
										<td colspan=3><input type="text" value="<?= $mobikwik_new['hangup_cmnt']?>" disabled name="data[hangup_cmnt]" class="form-control"></td>
									</tr>
									<tr>
										
										<td>Dead air </td>
										<td>
											<select name="data[dead_air]" class="form-control idfc" id="mobikwik1" disabled>
											<!-- <option value="">Select</option> -->
												<option idfc_val=3 <?= ($mobikwik_new['dead_air']=="Yes")?"selected":""?> value='Yes'>Yes</option>
												<option idfc_val=3 <?= ($mobikwik_new['dead_air']=="No")?"selected":""?> value='No'>No</option>
												<option idfc_val=0 <?= ($mobikwik_new['dead_air']=="N/A")?"selected":""?> value='N/A'>N/A</option>
												</select>
										</td>
										<td colspan=3>
											<p> 
												<strong>:</strong>
												Engage with customer and share what you are doing. (should not be more then 10 seconds).
											</p>
										</td>
										<td colspan=3><input type="text" value="<?= $mobikwik_new['dead_air_cmnt']?>" disabled name="data[dead_air_cmnt]" class="form-control"></td>
									</tr>
									<tr>
										<td class="">Attentiveness</td>
										<td>
											<select name="data[attentiveness]" class="form-control idfc" id="mobikwik3" disabled>
												<!-- <option value="">Select</option> -->
												<option idfc_val=2 <?= ($mobikwik_new['attentiveness']=="Yes")?"selected":""?> value='Yes'>Yes</option>
												<option idfc_val=2 <?= ($mobikwik_new['attentiveness']=="No")?"selected":""?> value='No'>No</option>
												<option idfc_val=0 <?= ($mobikwik_new['attentiveness']=="N/A")?"selected":""?> value='N/A'>N/A</option>
											</select>
										</td>
										<td colspan=3>
											<p> 
												<strong>:</strong>
												Understand and respond to customer query/concern promptly.
											</p>
										</td>
										<td colspan=3><input type="text" value="<?= $mobikwik_new['attentiveness_cmnt']?>" disabled name="data[attentiveness_cmnt]" class="form-control"></td>
									</tr>
									<tr>
										<td class="">Speak Clearly</td>
										<td>
											<select name="data[speak_clearly]" class="form-control idfc" id="mobikwik4" disabled>
												<!-- <option value="">Select</option> -->
												<option idfc_val=3 <?= ($mobikwik_new['speak_clearly']=="Yes")?"selected":""?> value='Yes'>Yes</option>
												<option idfc_val=3 <?= ($mobikwik_new['speak_clearly']=="No")?"selected":""?> value='No'>No</option>
												<option idfc_val=0 <?= ($mobikwik_new['speak_clearly']=="N/A")?"selected":""?> value='N/A'>N/A</option>
											</select>
										</td>
										<td colspan=3>
											<p> 
												<strong>:</strong>
												Pitch should be low.
											</p>
										</td>
										<td colspan=3><input type="text" value="<?= $mobikwik_new['speak_clearly_cmnt']?>" disabled name="data[speak_clearly_cmnt]" class="form-control"></td>
									</tr>
									<tr>
										<td class="">Empathize /Apologize if required</td>
										<td>
											<select name="data[empathize]" class="form-control idfc" id="mobikwik5" disabled>
											<!-- <option value="">Select</option> -->
												<option idfc_val=4 <?= ($mobikwik_new['empathize']=="Yes")?"selected":""?> value='Yes'>Yes</option>
												<option idfc_val=4 <?= ($mobikwik_new['empathize']=="No")?"selected":""?> value='No'>No</option>
												<option idfc_val=0 <?= ($mobikwik_new['empathize']=="N/A")?"selected":""?> value='N/A'>N/A</option>
												</select>
										</td>
										<td colspan=3>
											<p> 
												<strong>:</strong>
												Has the agent apologies/empathies where required.
											</p>
										</td>
										<td colspan=3><input type="text" value="<?= $mobikwik_new['empathize_cmnt']?>" disabled name="data[empathize_cmnt]" class="form-control"></td>
									</tr>
									<tr>
										<td class="">Hold guidelines should be followed</td>
										<td>
											<select name="data[guidelines]" class="form-control idfc" id="mobikwik5" disabled>
											<!-- <option value="">Select</option> -->
												<option idfc_val=3 <?= ($mobikwik_new['guidelines']=="Yes")?"selected":""?> value='Yes'>Yes</option>
												<option idfc_val=3 <?= ($mobikwik_new['guidelines']=="No")?"selected":""?> value='No'>No</option>
												<option idfc_val=0 <?= ($mobikwik_new['guidelines']=="N/A")?"selected":""?> value='N/A'>N/A</option>
												</select>
										</td>
										<td colspan=3>
											<p> 
												<strong>:</strong>
												1. Ask for permission before keeping user on hold
												2. Refresh hold in every 30 seconds
												3. Appreciate user for staying on hold
											</p>
										</td>
										<td colspan=3><input type="text" value="<?= $mobikwik_new['guidelines_cmnt']?>" disabled name="data[guidelines_cmnt]" class="form-control"></td>
									</tr>

									<tr>
										<td>Call Summary:</td>
										<td colspan=6><textarea class="form-control" id="call_summary" name="call_summary" disabled><?php echo $mobikwik_new['call_summary'] ?></textarea></td>
										<td>Feedback:</td>
										<td colspan=6><textarea class="form-control" id="feedback" name="feedback" disabled><?php echo $mobikwik_new['feedback'] ?></textarea></td>
									</tr>
									
									<?php if($mobikwik_new['attach_file']!=''){ ?>
									<tr oncontextmenu="return false;">
										<td colspan="6">Audio Files</td>
										<td colspan="8">
											<?php $attach_file = explode(",",$mobikwik_new['attach_file']);
											 foreach($attach_file as $mp){ ?>
												<audio controls='' style="background-color:#607F93"> 
												  <source src="<?php echo base_url(); ?>qa_files/qa_mobikwik/<?php echo $mp; ?>" type="audio/ogg">
												  <source src="<?php echo base_url(); ?>qa_files/qa_mobikwik/<?php echo $mp; ?>" type="audio/mpeg">
												</audio> </br>
											 <?php } ?>
										</td>
									</tr>
									<?php } ?>
									
									<tr><td colspan="12" style="background-color:#C5C8C8"></td></tr>
									
									<tr><td style="font-size:16px">Manager Review:</td> <td colspan="10" style="text-align:center"><?php echo $mobikwik_new['mgnt_rvw_note'] ?></td></tr>
									<tr><td style="font-size:16px">Client Review:</td> <td colspan="10" style="text-align:center"><?php echo $mobikwik_new['client_rvw_note'] ?></td></tr>
									
									<tr><td colspan="12" style="background-color:#C5C8C8"></td></tr>
									
									 <form id="form_agent_user" method="POST" action="">
									   <input type="hidden" name="pnid" class="form-control" value="<?php echo $pnid; ?>">
									   
										<tr>
											<td colspan=6 style="font-size:16px">Feedback Acceptance</td>
											<td colspan=6>
												<select class="form-control" id="" name="agnt_fd_acpt" required>
													<option value="">--Select--</option>
													<option <?php echo $mobikwik_new['agnt_fd_acpt']=='Acceptance'?"selected":""; ?> value="Acceptance">Acceptance</option>	
													<option <?php echo $mobikwik_new['agnt_fd_acpt']=='Not Acceptance'?"selected":""; ?> value="Not Acceptance">Not Acceptance</option>	
												</select>
											</td>
										</tr>
										<tr>
											<td colspan=6 style="font-size:16px">Review</td>
											<td colspan=8><textarea class="form-control" name="note" required><?php echo $mobikwik_new['agent_rvw_note'] ?></textarea></td>
										</tr>
										
										<?php if(is_access_qa_agent_module()==true){
										if(is_available_qa_feedback($mobikwik_new['entry_date'],72) == true){ ?>
											<tr>
												<?php if($mobikwik_new['agent_rvw_note']==''){ ?>
													<td colspan="12"><button class="btn btn-success waves-effect" type="submit" id='btnagentSave' name='btnSave' value="SAVE" style="width:500px">SAVE</button></td>
												<?php } ?>
											</tr>
										<?php } 
										} ?>
									
									  </form>
									
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
