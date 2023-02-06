
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
									<tr style="background-color:#AEB6BF"><td colspan="12" id="theader" style="font-size:30px">Mobikwik Email Audit Sheet</td></tr>
									
									<?php
										if($mobikwik_id==0){
											$auditorName = get_username();
											$auditDate = GetLocalTime();
											$clDate_val='';
										}else{
											if($mobikwik_new['entry_by']!=''){
												$auditorName = $mobikwik_new['auditor_name'];
											}else{
												$auditorName = $mobikwik_new['client_name'];
											}
											$auditDate = ConvServerToLocal($mobikwik_new['entry_date']);
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

										<td colspan=2><input type="text" class="form-control" id="product_name" name="data[product_name]" value="<?php echo $mobikwik_new['product_name'] ?>" required></td> -->
									
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
											<select class="form-control" id="auditor_type" name="data[auditor_type]">
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
										<th colspan=3>Points</th>
										<th colspan=2>Remarks</th>
									</tr>
									<tr>
										<td >Opening</td>
										<td>Did the advisor greet and personalized on email wherever required </td>
										<td style=width:100px;>
											<select name="data[call_opening]" class="form-control idfc" disabled>
												<!-- <option value="">Select</option> -->
												<option idfc_val=5 <?= ($mobikwik_new['call_opening']=="Yes")?"selected":""?> value='Yes'>Yes</option>
												<option idfc_val=5 <?= ($mobikwik_new['call_opening']=="No")?"selected":""?> value='No'>No</option>
												<option idfc_val=0 <?= ($mobikwik_new['call_opening']=="N/A")?"selected":""?> value='N/A'>N/A</option>
												</select> 
										</td>
										<td colspan=3>
											5
										</td>
										<td colspan=3><input type="text" value="<?= $mobikwik_new['call_opening_cmnt']?>" disabled name="data[call_opening_cmnt]" class="form-control"></td>
									</tr>
									
									<tr>
										<td class="" rowspan="4"> Email - Query/Objection/Concern - Handling</td>
										<td class="fatal">Did the Advisor understand the customer query/concern/used relevant probing </td>
										<td>
											<select name="data[query_objection]" class="form-control idfc" id="idfcAF1" disabled>
											<!-- <option value="">Select</option> -->
												<option idfc_val=10 <?= ($mobikwik_new['query_objection']=="Yes")?"selected":""?> value='Yes'>Yes</option>
												<option idfc_val=10 <?= ($mobikwik_new['query_objection']=="Fatal")?"selected":""?> value='Fatal'>Fatal</option>
												<option idfc_val=0 <?= ($mobikwik_new['query_objection']=="N/A")?"selected":""?> value='N/A'>N/A</option>
											</select>
										</td>
										<td colspan=3>
											10
										</td>
										<td colspan=3><input type="text" value="<?= $mobikwik_new['query_objection_cmnt']?>" disabled name="data[query_objection_cmnt]" class="form-control"></td>
									</tr>
									
									<tr>
										<!-- <td class="fatal" rowspan=4>Problem Resolution</td> -->
										<td class="">Did Advisor edit /use relevant canned responses?</td>
										<td>
											<select name="data[responses]" class="form-control idfc"  disabled>
											<!-- <option value="">Select</option> -->
												<option idfc_val=5 <?= ($mobikwik_new['responses']=="Yes")?"selected":""?> value='Yes'>Yes</option>
												<option idfc_val=5 <?= ($mobikwik_new['responses']=="No")?"selected":""?> value='No'>No</option>
												<option idfc_val=0 <?= ($mobikwik_new['responses']=="N/A")?"selected":""?> value='N/A'>N/A</option>
											</select>
										</td>
										<td colspan=3>
											5
										</td>
										<td colspan=3><input type="text" value="<?= $mobikwik_new['responses_cmnt']?>" disabled name="data[responses_cmnt]" class="form-control"></td>
									</tr>
									<tr>
										
										<td class="fatal">Did the Advisor provide correct/complete information to resolve customers' query/concern?</td>
										<td>
											<select name="data[advisor]" class="form-control idfc" id="idfcAF2" disabled>
											<!-- <option value="">Select</option> -->
												<option idfc_val=15 <?= ($mobikwik_new['advisor']=="Yes")?"selected":""?> value='Yes'>Yes</option>
												<option idfc_val=15 <?= ($mobikwik_new['advisor']=="Fatal")?"selected":""?> value='Fatal'>Fatal</option>
												<option idfc_val=0 <?= ($mobikwik_new['advisor']=="N/A")?"selected":""?> value='N/A'>N/A</option>
											</select>
										</td>
										<td colspan=3>
											15
										</td>
										<td colspan=3><input type="text" value="<?= $mobikwik_new['advisor_cmnt']?>" disabled name="data[advisor_cmnt]" class="form-control"></td>
									</tr>
									<tr>
										<td class="fatal">Did the advisor check previously raised complaint or escalate the concern to dedicated team on email/sheet</td>
										<td>
											<select name="data[complaint]" class="form-control idfc" id="idfcAF3" disabled>
											<!-- <option value="">Select</option> -->
												<option idfc_val=10 <?= ($mobikwik_new['complaint']=="Yes")?"selected":""?> value='Yes'>Yes</option>
												<option idfc_val=10 <?= ($mobikwik_new['complaint']=="Fatal")?"selected":""?> value='Fatal'>Fatal</option>
												<option idfc_val=0 <?= ($mobikwik_new['complaint']=="N/A")?"selected":""?> value='N/A'>N/A</option>
											</select>
										</td>
										<td colspan=3>
											10
										</td>
										<td colspan=3><input type="text" value="<?= $mobikwik_new['complaint_cmnt']?>" disabled name="data[complaint_cmnt]" class="form-control"></td>
									</tr>
									<tr>
									<td class="" rowspan="4">Communication</td>
										<td class="">Did the Advisor use Empathy/Apology and acknowledgement of query or complaint</td>
										<td>
											<select name="data[empathy]" class="form-control idfc"  disabled>
											<!-- <option value="">Select</option> -->
												<option idfc_val=5 <?= ($mobikwik_new['empathy']=="Yes")?"selected":""?> value='Yes'>Yes</option>
												<option idfc_val=5 <?= ($mobikwik_new['empathy']=="No")?"selected":""?> value='No'>No</option>
												<option idfc_val=0 <?= ($mobikwik_new['empathy']=="N/A")?"selected":""?> value='N/A'>N/A</option>
											</select>
										</td>
										<td colspan=3>
											5
										</td>
										<td colspan=3><input type="text" value="<?= $mobikwik_new['empathy_cmnt']?>" disabled name="data[empathy_cmnt]" class="form-control"></td>
									</tr>
									<tr>
										
										<td>Did the Advisor make personalize Email</td>
										<td>
											<select name="data[personalize]" class="form-control idfc" disabled>
											<!-- <option value="">Select</option> -->
												<option idfc_val=5 <?= ($mobikwik_new['personalize']=="Yes")?"selected":""?> value='Yes'>Yes</option>
												<option idfc_val=5 <?= ($mobikwik_new['personalize']=="No")?"selected":""?> value='No'>No</option>
												<option idfc_val=0 <?= ($mobikwik_new['personalize']=="N/A")?"selected":""?> value='N/A'>N/A</option>
											</select>
										</td>
										<td colspan=3>
											5
										</td>
										<td colspan=3><input type="text" value="<?= $mobikwik_new['personalize_cmnt']?>" disabled name="data[personalize_cmnt]" class="form-control"></td>
									</tr>
									<tr>
										<td>Did the Advisor use accurate Sentence formation, Grammar, Punctuation, Tenses, Spellings, avoid usage of jargons & correct choice of words?</td>
										<td>
											<select name="data[grammar]" class="form-control idfc" disabled>
											<!-- <option value="">Select</option> -->
												<option idfc_val=5 <?= ($mobikwik_new['grammar']=="Yes")?"selected":""?> value='Yes'>Yes</option>
												<option idfc_val=5 <?= ($mobikwik_new['grammar']=="No")?"selected":""?> value='No'>No</option>
												<option idfc_val=0 <?= ($mobikwik_new['grammar']=="N/A")?"selected":""?> value='N/A'>N/A</option>
											</select>
										</td>
										<td colspan=3>
										5
										</td>
										<td colspan=3><input type="text" value="<?= $mobikwik_new['grammar_cmnt']?>" disabled name="data[grammar_cmnt]" class="form-control"></td>
									</tr>
									<tr>
										<td class="fatal">Repeat response - did the advisor use same content as per the trail email/Case got reopen due to wrong response shared by agent</td>
										<td>
											<select name="data[trail_email]" class="form-control idfc" id="idfcAF4" disabled>
											<!-- <option value="">Select</option> -->
												<option idfc_val=10 <?= ($mobikwik_new['trail_email']=="Yes")?"selected":""?> value='Yes'>Yes</option>
												<option idfc_val=10 <?= ($mobikwik_new['trail_email']=="Fatal")?"selected":""?> value='Fatal'>Fatal</option>
												<option idfc_val=0 <?= ($mobikwik_new['trail_email']=="N/A")?"selected":""?> value='N/A'>N/A</option>
											</select>
										</td>
										<td colspan=3>
											10
										</td>
										<td colspan=3><input type="text" value="<?= $mobikwik_new['trail_email_cmnt']?>" disabled name="data[trail_email_cmnt]" class="form-control"></td>
									</tr>
									<tr>
										<td class="" rowspan="2">Documentation</td>
										<td class="fatal">Did the Advisor use the correct disposition/Tagging and category as per the conversation? </td>
										<td>
											<select name="data[conversation]" class="form-control idfc" id="idfcAF5" disabled>
											<!-- <option value="">Select</option> -->
												<option idfc_val=10 <?= ($mobikwik_new['conversation']=="Yes")?"selected":""?> value='Yes'>Yes</option>
												<option idfc_val=10 <?= ($mobikwik_new['conversation']=="Fatal")?"selected":""?> value='Fatal'>Fatal</option>
												<option idfc_val=0 <?= ($mobikwik_new['conversation']=="N/A")?"selected":""?> value='N/A'>N/A</option>
												</select>
										</td>
										<td colspan=3>
											10
										</td>
										<td colspan=3><input type="text" value="<?= $mobikwik_new['conversation_cmnt']?>" disabled name="data[conversation_cmnt]" class="form-control"></td>
									</tr>
									<tr>
										
										<td class="fatal">Did the Advisor inform the correct TAT? </td>
										<td>
											<select name="data[correct_TAT]" class="form-control idfc" id="idfcAF6" disabled>
											<!-- <option value="">Select</option> -->
												<option idfc_val=5 <?= ($mobikwik_new['correct_TAT']=="Yes")?"selected":""?> value='Yes'>Yes</option>
												<option idfc_val=5 <?= ($mobikwik_new['correct_TAT']=="Fatal")?"selected":""?> value='Fatal'>Fatal</option>
												<option idfc_val=0 <?= ($mobikwik_new['correct_TAT']=="N/A")?"selected":""?> value='N/A'>N/A</option>
												</select>
										</td>
										<td colspan=3>
											5
										</td>
										<td colspan=3><input type="text" value="<?= $mobikwik_new['correct_TAT_cmnt']?>" disabled name="data[correct_TAT_cmnt]" class="form-control"></td>
									</tr>
									<tr>
										<td class="" >Closing</td>
										<td class="">Did the Advisor close the email properly/ followed the closing procedure</td>
										<td>
											<select name="data[email_properly]" class="form-control idfc" id="idfcAF6" disabled>
												<!-- <option value="">Select</option> -->
												<option idfc_val=5 <?= ($mobikwik_new['email_properly']=="Yes")?"selected":""?> value='Yes'>Yes</option>
												<option idfc_val=5 <?= ($mobikwik_new['email_properly']=="No")?"selected":""?> value='No'>No</option>
												<option idfc_val=0 <?= ($mobikwik_new['email_properly']=="N/A")?"selected":""?> value='N/A'>N/A</option>
											</select>
										</td>
										<td colspan=3>
											5
										</td>
										<td colspan=3><input type="text" value="<?= $mobikwik_new['email_properly_cmnt']?>" disabled name="data[email_properly_cmnt]" class="form-control"></td>
									</tr>
									<tr>
									<td class="" rowspan="2">Wrong Practices </td>
										<td class="fatal">No instance of email avoidance or wrong practice followed?</td>
										<td>
											<select name="data[avoidance]" class="form-control idfc" id="idfcAF7" disabled>
											<!-- <option value="">Select</option> -->
												<option idfc_val=5 <?= ($mobikwik_new['avoidance']=="Yes")?"selected":""?> value='Yes'>Yes</option>
												<option idfc_val=5 <?= ($mobikwik_new['avoidance']=="Fatal")?"selected":""?> value='Fatal'>Fatal</option>
												<option idfc_val=0 <?= ($mobikwik_new['avoidance']=="N/A")?"selected":""?> value='N/A'>N/A</option>
												</select>
										</td>
										<td colspan=3>
											5
										</td>
										<td colspan=3><input type="text" value="<?= $mobikwik_new['avoidance_cmnt']?>" disabled name="data[avoidance_cmnt]" class="form-control"></td>
									</tr>
									<tr>
										<td class="fatal">The Advisor was professional during email ( rude /offensive /sarcastic / unethical words not used)</td>
										<td>
											<select name="data[professional]" class="form-control idfc" id="idfcAF8" disabled>
												<!-- <option value="">Select</option> -->
												<option idfc_val=5 <?= ($mobikwik_new['professional']=="Yes")?"selected":""?> value='Yes'>Yes</option>
												<option idfc_val=5 <?= ($mobikwik_new['professional']=="Fatal")?"selected":""?> value='Fatal'>Fatal</option>
												<option idfc_val=0 <?= ($mobikwik_new['professional']=="N/A")?"selected":""?> value='N/A'>N/A</option>
											</select>
										</td>
										<td colspan=3>
											5
										</td>
										<td colspan=3><input type="text" value="<?= $mobikwik_new['professional_cmnt']?>" disabled name="data[professional_cmnt]" class="form-control"></td>
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
