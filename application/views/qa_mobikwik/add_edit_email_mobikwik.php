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

<?php if($mobikwik_id!=0){
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
										<td colspan=9 id="theader" style="font-size:40px">Mobikwik Email Audit Sheet</td>
										<input type="hidden" name="audit_start_time" value="<?php echo CurrMySqlDate(); ?>">
									</tr>
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
										<td colspan=2><input type="text" class="form-control" id="call_date_time" name="call_date" value="<?php echo $clDate_val; ?>" required></td>
									</tr>
									<tr>
										<?php
										$desig = '';
										?>
										<td>Agent/TL/QA/Trainer:</td>
										<td colspan=2>
											<select class="form-control" id="agent_id" name="data[agent_id]" required>
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
										<td colspan=2><input type="text" class="form-control" id="call_duration" name="data[call_duration]" value="<?php echo $mobikwik_new['call_duration'] ?>" required></td>
										<!-- <td>Product Name:</td>

										<td colspan=2><input type="text" class="form-control" id="product_name" name="data[product_name]" value="<?php echo $mobikwik_new['product_name'] ?>" required></td> -->
									
										<td>Customer VOC:</td>
										<td colspan=2><input type="text" class="form-control" id="cust_voc" name="data[customer_voc]" value="<?php echo $mobikwik_new['customer_voc'] ?>" required></td>
										
									</tr>
									<tr>
										
										<td>Objections:</td>
										<td colspan=2><input type="text" class="form-control" id="objections" name="data[objections]" value="<?php echo $mobikwik_new['objections'] ?>" required></td>
										<td>Email ID:</td>
										<td colspan=2><input type="text" class="form-control" id="email" name="data[email]" value="<?php echo $mobikwik_new['email'] ?>" required></td>
										
									</tr>
									<tr>
										<td>Phone:</td>
										<td colspan=2><input type="text" class="form-control" id="phone" name="data[customer_phone]" onkeyup="checkDec(this);" value="<?php echo $mobikwik_new['customer_phone'] ?>" required></td>
										<td>Agent Disposition:</td>
										<td colspan=2><input type="text" class="form-control" name="data[agent_disposition]" value="<?php echo $mobikwik_new['agent_disposition'] ?>" required></td>
										<td>QA Disposition:</td>
										<td colspan=2><input type="text" class="form-control" name="data[qa_disposition]" value="<?php echo $mobikwik_new['qa_disposition'] ?>" required></td>
									</tr>
									<tr>
									<td>ACPT:</td>
										<td colspan=2>
											<select class="form-control" name="data[acpt]" required>
												<option value="">Select</option>
											<option <?php echo $mobikwik_new['acpt']=='Agent'?"selected":""; ?> value="Agent">Agent</option>
											<option <?php echo $mobikwik_new['acpt']=='Customer'?"selected":""; ?> value="Customer">Customer</option>
											<option <?php echo $mobikwik_new['acpt']=='Product'?"selected":""; ?> value="Product">Product</option>
											<option <?php echo $mobikwik_new['acpt']=='Process'?"selected":""; ?> value="Process">Process</option>
											<option <?php echo $mobikwik_new['acpt']=='Technology'?"selected":""; ?> value="Technology">Technology</option>
											</select>
										</td>
									<td>ACPT 1 Remarks</td>
									<td colspan=2><input type="text" class="form-control" name="data[acpt1]" value="<?php echo $mobikwik_new['acpt1'] ?>" required></td>
									<td>ACPT 2 Remarks</td>
									<td colspan=2><input type="text" class="form-control" name="data[acpt2]" value="<?php echo $mobikwik_new['acpt2'] ?>" required></td>

									</tr>
									<tr>
										<td>Audit Type:</td>
										<td colspan=2>
											<select class="form-control" id="audit_type" name="data[audit_type]" required>
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
											<select class="form-control" id="voc" name="data[voc]" required>
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
											<select name="data[call_opening]" class="form-control idfc" required>
												<!-- <option value="">Select</option> -->
												<option idfc_val=5 <?= ($mobikwik_new['call_opening']=="Yes")?"selected":""?> value='Yes'>Yes</option>
												<option idfc_val=5 <?= ($mobikwik_new['call_opening']=="No")?"selected":""?> value='No'>No</option>
												<option idfc_val=0 <?= ($mobikwik_new['call_opening']=="N/A")?"selected":""?> value='N/A'>N/A</option>
												</select> 
										</td>
										<td colspan=3>
											5
										</td>
										<td colspan=3><input type="text" value="<?= $mobikwik_new['call_opening_cmnt']?>" name="data[call_opening_cmnt]" class="form-control"></td>
									</tr>
									
									<tr>
										<td class="" rowspan="4"> Email - Query/Objection/Concern - Handling</td>
										<td class="fatal">Did the Advisor understand the customer query/concern/used relevant probing </td>
										<td>
											<select name="data[query_objection]" class="form-control idfc" id="idfcAF1" required>
											<!-- <option value="">Select</option> -->
												<option idfc_val=10 <?= ($mobikwik_new['query_objection']=="Yes")?"selected":""?> value='Yes'>Yes</option>
												<option idfc_val=10 <?= ($mobikwik_new['query_objection']=="Fatal")?"selected":""?> value='Fatal'>Fatal</option>
												<option idfc_val=0 <?= ($mobikwik_new['query_objection']=="N/A")?"selected":""?> value='N/A'>N/A</option>
											</select>
										</td>
										<td colspan=3>
											10
										</td>
										<td colspan=3><input type="text" value="<?= $mobikwik_new['query_objection_cmnt']?>" name="data[query_objection_cmnt]" class="form-control"></td>
									</tr>
									
									<tr>
										<!-- <td class="fatal" rowspan=4>Problem Resolution</td> -->
										<td class="">Did Advisor edit /use relevant canned responses?</td>
										<td>
											<select name="data[responses]" class="form-control idfc"  required>
											<!-- <option value="">Select</option> -->
												<option idfc_val=5 <?= ($mobikwik_new['responses']=="Yes")?"selected":""?> value='Yes'>Yes</option>
												<option idfc_val=5 <?= ($mobikwik_new['responses']=="No")?"selected":""?> value='No'>No</option>
												<option idfc_val=0 <?= ($mobikwik_new['responses']=="N/A")?"selected":""?> value='N/A'>N/A</option>
											</select>
										</td>
										<td colspan=3>
											5
										</td>
										<td colspan=3><input type="text" value="<?= $mobikwik_new['responses_cmnt']?>" name="data[responses_cmnt]" class="form-control"></td>
									</tr>
									<tr>
										
										<td class="fatal">Did the Advisor provide correct/complete information to resolve customers' query/concern?</td>
										<td>
											<select name="data[advisor]" class="form-control idfc" id="idfcAF2" required>
											<!-- <option value="">Select</option> -->
												<option idfc_val=15 <?= ($mobikwik_new['advisor']=="Yes")?"selected":""?> value='Yes'>Yes</option>
												<option idfc_val=15 <?= ($mobikwik_new['advisor']=="Fatal")?"selected":""?> value='Fatal'>Fatal</option>
												<option idfc_val=0 <?= ($mobikwik_new['advisor']=="N/A")?"selected":""?> value='N/A'>N/A</option>
											</select>
										</td>
										<td colspan=3>
											15
										</td>
										<td colspan=3><input type="text" value="<?= $mobikwik_new['advisor_cmnt']?>" name="data[advisor_cmnt]" class="form-control"></td>
									</tr>
									<tr>
										<td class="fatal">Did the advisor check previously raised complaint or escalate the concern to dedicated team on email/sheet</td>
										<td>
											<select name="data[complaint]" class="form-control idfc" id="idfcAF3" required>
											<!-- <option value="">Select</option> -->
												<option idfc_val=10 <?= ($mobikwik_new['complaint']=="Yes")?"selected":""?> value='Yes'>Yes</option>
												<option idfc_val=10 <?= ($mobikwik_new['complaint']=="Fatal")?"selected":""?> value='Fatal'>Fatal</option>
												<option idfc_val=0 <?= ($mobikwik_new['complaint']=="N/A")?"selected":""?> value='N/A'>N/A</option>
											</select>
										</td>
										<td colspan=3>
											10
										</td>
										<td colspan=3><input type="text" value="<?= $mobikwik_new['complaint_cmnt']?>" name="data[complaint_cmnt]" class="form-control"></td>
									</tr>
									<tr>
									<td class="" rowspan="4">Communication</td>
										<td class="">Did the Advisor use Empathy/Apology and acknowledgement of query or complaint</td>
										<td>
											<select name="data[empathy]" class="form-control idfc"  required>
											<!-- <option value="">Select</option> -->
												<option idfc_val=5 <?= ($mobikwik_new['empathy']=="Yes")?"selected":""?> value='Yes'>Yes</option>
												<option idfc_val=5 <?= ($mobikwik_new['empathy']=="No")?"selected":""?> value='No'>No</option>
												<option idfc_val=0 <?= ($mobikwik_new['empathy']=="N/A")?"selected":""?> value='N/A'>N/A</option>
											</select>
										</td>
										<td colspan=3>
											5
										</td>
										<td colspan=3><input type="text" value="<?= $mobikwik_new['empathy_cmnt']?>" name="data[empathy_cmnt]" class="form-control"></td>
									</tr>
									<tr>
										
										<td>Did the Advisor make personalize Email</td>
										<td>
											<select name="data[personalize]" class="form-control idfc" required>
											<!-- <option value="">Select</option> -->
												<option idfc_val=5 <?= ($mobikwik_new['personalize']=="Yes")?"selected":""?> value='Yes'>Yes</option>
												<option idfc_val=5 <?= ($mobikwik_new['personalize']=="No")?"selected":""?> value='No'>No</option>
												<option idfc_val=0 <?= ($mobikwik_new['personalize']=="N/A")?"selected":""?> value='N/A'>N/A</option>
											</select>
										</td>
										<td colspan=3>
											5
										</td>
										<td colspan=3><input type="text" value="<?= $mobikwik_new['personalize_cmnt']?>" name="data[personalize_cmnt]" class="form-control"></td>
									</tr>
									<tr>
										<td>Did the Advisor use accurate Sentence formation, Grammar, Punctuation, Tenses, Spellings, avoid usage of jargons & correct choice of words?</td>
										<td>
											<select name="data[grammar]" class="form-control idfc" required>
											<!-- <option value="">Select</option> -->
												<option idfc_val=5 <?= ($mobikwik_new['grammar']=="Yes")?"selected":""?> value='Yes'>Yes</option>
												<option idfc_val=5 <?= ($mobikwik_new['grammar']=="No")?"selected":""?> value='No'>No</option>
												<option idfc_val=0 <?= ($mobikwik_new['grammar']=="N/A")?"selected":""?> value='N/A'>N/A</option>
											</select>
										</td>
										<td colspan=3>
										5
										</td>
										<td colspan=3><input type="text" value="<?= $mobikwik_new['grammar_cmnt']?>" name="data[grammar_cmnt]" class="form-control"></td>
									</tr>
									<tr>
										<td class="fatal">Repeat response - did the advisor use same content as per the trail email/Case got reopen due to wrong response shared by agent</td>
										<td>
											<select name="data[trail_email]" class="form-control idfc" id="idfcAF4" required>
											<!-- <option value="">Select</option> -->
												<option idfc_val=10 <?= ($mobikwik_new['trail_email']=="Yes")?"selected":""?> value='Yes'>Yes</option>
												<option idfc_val=10 <?= ($mobikwik_new['trail_email']=="Fatal")?"selected":""?> value='Fatal'>Fatal</option>
												<option idfc_val=0 <?= ($mobikwik_new['trail_email']=="N/A")?"selected":""?> value='N/A'>N/A</option>
											</select>
										</td>
										<td colspan=3>
											10
										</td>
										<td colspan=3><input type="text" value="<?= $mobikwik_new['trail_email_cmnt']?>" name="data[trail_email_cmnt]" class="form-control"></td>
									</tr>
									<tr>
										<td class="" rowspan="2">Documentation</td>
										<td class="fatal">Did the Advisor use the correct disposition/Tagging and category as per the conversation? </td>
										<td>
											<select name="data[conversation]" class="form-control idfc" id="idfcAF5" required>
											<!-- <option value="">Select</option> -->
												<option idfc_val=10 <?= ($mobikwik_new['conversation']=="Yes")?"selected":""?> value='Yes'>Yes</option>
												<option idfc_val=10 <?= ($mobikwik_new['conversation']=="Fatal")?"selected":""?> value='Fatal'>Fatal</option>
												<option idfc_val=0 <?= ($mobikwik_new['conversation']=="N/A")?"selected":""?> value='N/A'>N/A</option>
												</select>
										</td>
										<td colspan=3>
											10
										</td>
										<td colspan=3><input type="text" value="<?= $mobikwik_new['conversation_cmnt']?>" name="data[conversation_cmnt]" class="form-control"></td>
									</tr>
									<tr>
										
										<td class="fatal">Did the Advisor inform the correct TAT? </td>
										<td>
											<select name="data[correct_TAT]" class="form-control idfc" id="idfcAF6" required>
											<!-- <option value="">Select</option> -->
												<option idfc_val=5 <?= ($mobikwik_new['correct_TAT']=="Yes")?"selected":""?> value='Yes'>Yes</option>
												<option idfc_val=5 <?= ($mobikwik_new['correct_TAT']=="Fatal")?"selected":""?> value='Fatal'>Fatal</option>
												<option idfc_val=0 <?= ($mobikwik_new['correct_TAT']=="N/A")?"selected":""?> value='N/A'>N/A</option>
												</select>
										</td>
										<td colspan=3>
											5
										</td>
										<td colspan=3><input type="text" value="<?= $mobikwik_new['correct_TAT_cmnt']?>" name="data[correct_TAT_cmnt]" class="form-control"></td>
									</tr>
									<tr>
										<td class="" >Closing</td>
										<td class="">Did the Advisor close the email properly/ followed the closing procedure</td>
										<td>
											<select name="data[email_properly]" class="form-control idfc" id="idfcAF6" required>
												<!-- <option value="">Select</option> -->
												<option idfc_val=5 <?= ($mobikwik_new['email_properly']=="Yes")?"selected":""?> value='Yes'>Yes</option>
												<option idfc_val=5 <?= ($mobikwik_new['email_properly']=="No")?"selected":""?> value='No'>No</option>
												<option idfc_val=0 <?= ($mobikwik_new['email_properly']=="N/A")?"selected":""?> value='N/A'>N/A</option>
											</select>
										</td>
										<td colspan=3>
											5
										</td>
										<td colspan=3><input type="text" value="<?= $mobikwik_new['email_properly_cmnt']?>" name="data[email_properly_cmnt]" class="form-control"></td>
									</tr>
									<tr>
									<td class="" rowspan="2">Wrong Practices </td>
										<td class="fatal">No instance of email avoidance or wrong practice followed?</td>
										<td>
											<select name="data[avoidance]" class="form-control idfc" id="idfcAF7" required>
											<!-- <option value="">Select</option> -->
												<option idfc_val=5 <?= ($mobikwik_new['avoidance']=="Yes")?"selected":""?> value='Yes'>Yes</option>
												<option idfc_val=5 <?= ($mobikwik_new['avoidance']=="Fatal")?"selected":""?> value='Fatal'>Fatal</option>
												<option idfc_val=0 <?= ($mobikwik_new['avoidance']=="N/A")?"selected":""?> value='N/A'>N/A</option>
												</select>
										</td>
										<td colspan=3>
											5
										</td>
										<td colspan=3><input type="text" value="<?= $mobikwik_new['avoidance_cmnt']?>" name="data[avoidance_cmnt]" class="form-control"></td>
									</tr>
									<tr>
										<td class="fatal">The Advisor was professional during email ( rude /offensive /sarcastic / unethical words not used)</td>
										<td>
											<select name="data[professional]" class="form-control idfc" id="idfcAF8" required>
												<!-- <option value="">Select</option> -->
												<option idfc_val=5 <?= ($mobikwik_new['professional']=="Yes")?"selected":""?> value='Yes'>Yes</option>
												<option idfc_val=5 <?= ($mobikwik_new['professional']=="Fatal")?"selected":""?> value='Fatal'>Fatal</option>
												<option idfc_val=0 <?= ($mobikwik_new['professional']=="N/A")?"selected":""?> value='N/A'>N/A</option>
											</select>
										</td>
										<td colspan=3>
											5
										</td>
										<td colspan=3><input type="text" value="<?= $mobikwik_new['professional_cmnt']?>" name="data[professional_cmnt]" class="form-control"></td>
									</tr>
									
									<tr>
										<td>Call Summary:</td>
										<td colspan=3><textarea class="form-control" id="" name="data[call_summary]"><?php echo $mobikwik_new['call_summary'] ?></textarea></td>
										<td>Feedback:</td>
										<td colspan=3><textarea class="form-control" id="" name="data[feedback]"><?php echo $mobikwik_new['feedback'] ?></textarea></td>
									</tr>
									<tr>
										<td colspan=2>Upload Files (Only: mp3 / avi / mp4 / wmv /wav)</td>
										<?php if($mobikwik_id==0){ ?>
											<td colspan=6><input type="file" multiple class="form-control" id="attach_file" name="attach_file[]"></td>
										<?php }else{ 
											if($mobikwik_new['attach_file']!=''){ ?>
											<td colspan=6>
												<?php $attach_file = explode(",",$mobikwik_new['attach_file']);
												 foreach($attach_file as $mp){ ?>
													<audio controls='' style="background-color:#607F93"> 
													  <source src="<?php echo base_url(); ?>qa_files/qa_mobikwik/<?php echo $mp; ?>" type="audio/ogg">
													  <source src="<?php echo base_url(); ?>qa_files/qa_mobikwik/<?php echo $mp; ?>" type="audio/mpeg">
													</audio> </br>
												 <?php } ?>
											</td>
										<?php }else{
												echo '<td><b>No Files</b></td>';
											  }
										} ?>
									</tr>
									
									<?php if($mobikwik_id!=0){ ?>
										<tr><td colspan=2 style="font-size:16px; font-weight:bold">Agent Review:</td><td colspan=8><?php echo $mobikwik_new['agent_rvw_note'] ?></td></tr>
										<tr><td colspan=2 style="font-size:16px; font-weight:bold">Management Review:</td><td colspan=8><?php echo $mobikwik_new['mgnt_rvw_note'] ?></td></tr>
										<tr><td colspan=2 style="font-size:16px; font-weight:bold">Client Review:</td><td colspan=8><?php echo $mobikwik_new['client_rvw_note'] ?></td></tr>
										
										<tr><td colspan=3  style="font-size:16px">Your Review</td><td colspan=8><textarea class="form-control1" style="width:100%" id="note" name="note" required></textarea></td></tr>
									<?php } ?>
									
									<?php 
									if($mobikwik_id==0){
										if(is_access_qa_module()==true || is_access_qa_operations_module()==true || is_quality_access_trainer()==true){ ?>
											<tr><td colspan=6><button class="btn btn-success waves-effect" type="submit" value="SAVE" name="btnSave" id="qaformsubmit" style="width:500px">SAVE</button></td></tr>
									<?php 
										} 
									}else{ 
										if(is_access_qa_module()==true || is_quality_access_trainer()==true){
											if(is_available_qa_feedback($mobikwik_new['entry_date'],72) == true){ ?>
												<tr><td colspan=6><button class="btn btn-success waves-effect" type="submit" id='qaformsubmit' name='btnSave' value="SAVE" style="width:500px">SAVE</button></td></tr>
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
