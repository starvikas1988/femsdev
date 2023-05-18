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
.table .select2-selection.select2-selection--single{
	height: 40px!important;
}
</style>

<!-- <?php// if($od_ecommerce_id!=0){
//if(is_access_qa_edit_feedback()==false){ ?>
	<style>
		.form-control{
			pointer-events:none;
			background-color:#D5DBDB;
		}
	</style>
<?php// } 
//} ?> -->

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
										<td colspan="10" id="theader" style="font-size:30px">OFFICE DEPOT: ECOMMERCE QUALITY FORM</td>
										<input type="hidden" name="audit_start_time" value="<?php echo CurrMySqlDate(); ?>">
									</tr>
									<?php
										if($od_ecommerce_id==0){
											$auditorName = get_username();
											$auditDate = CurrDateMDY();
											$clDate_val='';
											$clreview_date='';
										}else{
											if($od_ecommerce['entry_by']!=''){
												$auditorName = $od_ecommerce['auditor_name'];
											}else{
												$auditorName = $od_ecommerce['client_name'];
											}
											$auditDate = mysql2mmddyy($od_ecommerce['audit_date']);
											$clDate_val = mysql2mmddyy($od_ecommerce['call_date']);
											$clreview_date = mysql2mmddyy($od_ecommerce['review_date']);
										}
									?>
									<tr>
										<td style="width:150px">Auditor Name:</td>
										<td style="width:250px"><input type="text" class="form-control" value="<?php echo $auditorName; ?>" disabled></td>
										<td style="width:150px">Audit Date:</td>
										<td style="width:200px"><input type="text" class="form-control" value="<?php echo $auditDate; ?>" disabled></td>
										<td style="width:150px">Call Date:</td>
										<td style="width:250px"><input type="text" class="form-control" id="call_date" name="call_date" value="<?php echo $clDate_val; ?>" required></td>
										<td style="width:150px">Call Duration:</td>
										<td style="width:250px"><input type="text" class="form-control" id="call_duration" name="data[call_duration]" value="<?php echo $od_ecommerce['call_duration'] ?>" required ></td>
										
									</tr>
									<tr>
										<td>Agent:</td>
										<td>
											<select class="form-control" id="agent_id" name="data[agent_id]" required >
												<option value="<?php echo $od_ecommerce['agent_id'] ?>"><?php echo $od_ecommerce['fname']." ".$od_ecommerce['lname'] ?></option>
												
												<?php foreach($agentName as $row):  ?>
													<option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
												<?php endforeach; ?>
											</select>
										</td>
										<td>Fusion ID:</td>
										<td><input type="text" class="form-control" id="fusion_id" value="<?php echo $od_ecommerce['fusion_id'] ?>" readonly ></td>
										<td>L1 Supervisor:</td>
										<td>
											<select class="form-control" id="tl_id" name="data[tl_id]" readonly>
												<option value="<?php echo $od_ecommerce['tl_id'] ?>"><?php echo $od_ecommerce['tl_name'] ?></option>
												<option value="">--Select--</option>
												<?php foreach($tlname as $tl): ?>
													<option value="<?php echo $tl['id']; ?>"><?php echo $tl['fname']." ".$tl['lname']; ?></option>
												<?php endforeach; ?>	
											</select>
										</td>
										<td>Review Date:</td>
										<td style="width:200px"><input type="text" class="form-control" id="review_date" name="review_date" value="<?php echo $clreview_date; ?>" required></td>
									</tr>
									<tr>
									<td>Reviewed By:</td>
										<td><input type="text" class="form-control" name="data[reviewed]" value="<?php echo $od_ecommerce['reviewed'] ?>" required ></td>
										<td>Customer Id:</td>
										<td><input type="text" class="form-control" name="data[customer_id]" value="<?php echo $od_ecommerce['customer_id'] ?>" required ></td>
										<td>Session ID:</td>
										<td>
											<input type="text" class="form-control" name="data[session_id]" value="<?php echo $od_ecommerce['session_id'] ?>" required > 
										</td>	
										<td>LOB:</td>
									<td>
											<select class="form-control" id="lob" name="data[lob]" required>
												<option value="<?php echo $od_ecommerce['lob'] ?>"><?php echo $od_ecommerce['lob'] ?></option>
												
												<option value="BDD">BDD</option>
												<option value="ENT-NAT">ENT-NAT</option>
												<option value="Ecommerce-Rewards">Ecommerce-Rewards</option>
												<option value="Billing">Billing</option>
											</select>
										</td>
									</tr>
									
									<tr>
									<td>Disposition Category:</td>
										<td>
											<select class="form-control" id="dis_cate" name="data[disposition_cate]" required>
												
												<option value="<?php echo $od_ecommerce['disposition_cate'] ?>"><?php echo $od_ecommerce['disposition_cate'] ?></option>
												<option value="">-Select-</option>
												<option  value="Blank">Blank </option>
												<option  value="Billing">Billing </option>
												<option  value="Cancel">Cancel</option>
												<option  value="Order Status">Order Status </option>
												<option  value="Other">Other </option>
												<option  value="Place Order">Place Order</option>
												<option  value="Product">Product </option>
												<option  value="Payment Issues">Payment Issues</option>
												<option  value="Returns & Credits">Returns & Credits</option>
												<option  value="Rewards">Rewards</option>
												<option  value="Services">Services</option>
												<option  value="Store">Store</option>
												<option  value="Websupport">Websupport</option>
												<!-- <option  value="Other">Other</option> -->
											</select>
										</td>
										<td>Disposition Sub Category:</td>
										<td>
											<select class="form-control" id="dis_sub_cate" name="data[disposition_sub_cate]" required>
												<option value="<?php echo $od_ecommerce['disposition_sub_cate'] ?>"><?php echo $od_ecommerce['disposition_sub_cate'] ?></option>
											</select>
										</td>
									<!-- </tr>
									<tr> -->
										<td>Audit Type:</td>
										<td>
											<select class="form-control" id="audit_type" name="data[audit_type]" required>
												<option value="<?php echo $od_ecommerce['audit_type'] ?>"><?php echo $od_ecommerce['audit_type'] ?></option>
												
												<option value="CQ Audit">CQ Audit</option>
												<option value="BQ Audit">BQ Audit</option>
												<option value="Calibration">Calibration</option>
												<option value="Pre-Certificate Mock Call">Pre-Certificate Mock Call</option>
												<option value="Certification Audit">Certification Audit</option>
												<option value="Operation Audit">Operation Audit</option>
												<option value="Trainer Audit">Trainer Audit</option>
												<option value="Wow Call Nomination">Wow Call Nomination</option>
											</select>
										</td>
										<td class="auType">Auditor Type</td>
										<td class="auType">
											<select class="form-control" id="auditor_type" name="data[auditor_type]">
												
												<option value="Master">Master</option>
												<option value="Regular">Regular</option>
											</select>
										</td>
										
									</tr>
									<tr>
									<td>Workgroup:</td>
										<td>
											<select class="form-control"  name="data[workgroup]" required>
												<option value="<?php echo $od_ecommerce['workgroup'] ?>"><?php echo $od_ecommerce['workgroup'] ?></option>
												<!-- <option value="">-Select-</option> -->
												<option value="OD.COM ">OD.COM </option>
												<option value="WebSupport">WebSupport</option>
											</select>
										</td>
									<td>VOC:</td>
										<td>
											<select class="form-control" id="voc" name="data[voc]" required>
												<option value="<?php echo $od_ecommerce['voc'] ?>"><?php echo $od_ecommerce['voc'] ?></option>
												
												<option value="1">1</option>
												<option value="2">2</option>
												<option value="3">3</option>
												<option value="4">4</option>
												<option value="5">5</option>
												<option value="6">6</option>
												<option value="7">7</option>
												<option value="8">8</option>
												<option value="9">9</option>
												<option value="10">10</option>
											</select>
										</td>
									</tr>
									<tr>
										<td style="font-weight:bold; font-size:16px">Possible Score:</td>
										<td><input type="text" readonly id="od_ecommerce_possible_score" name="data[possible_score]" class="form-control" style="font-weight:bold" value="<?php echo $od_ecommerce['possible_score'] ?>"></td>
										<td style="font-weight:bold; font-size:16px">Earned Score:</td>
										<td><input type="text" readonly id="od_ecommerce_earned_score" name="data[earned_score]" class="form-control" style="font-weight:bold" value="<?php echo $od_ecommerce['earned_score'] ?>"></td>
										<td style="font-weight:bold; font-size:16px; text-align:right">Overall Score:</td>
										<td><input type="text" readonly id="od_ecommerce_overall_score" name="data[overall_score]" class="form-control voice_fatal" style="font-weight:bold" value="<?php echo $od_ecommerce['overall_score'] ?>"></td>
										<td colspan="2"><input type="text" readonly id="ecommerce_score" name="data[division_status]" class="form-control" style="font-weight:bold" value="<?php echo $od_ecommerce['division_status'] ?>"></td>
									</tr>
								
									<tr style="height:25px; font-weight:bold; background-color:#85C1E9">
										<td>COPC PARAMETER</td>
										<td colspan="3">PARAMETER</td>
										<td>RESPONSE</td>
										<td>POSSIBLE POINTS</td>
										<!-- <td>RCA Level 1</td>
										<td>RCA Level 2</td>
										<td>RCA Level 3</td>
										<td>RCA Comments</td> -->
										<td colspan="2">COMMENTS</td>
									</tr>
								
									<tr>
										<td class="eml1" colspan="8" style="background-color:#3f5691; color: white;text-align: left;">CONNECT WITH CUSTOMER</td>
										<td class="eml1" colspan="" style="background-color:#8195c9"></td>
									</tr>
									<tr>
									<td style="background-color:#A9DFBF">Customer Critical</td>
										<td colspan="3" class="eml1" style="text-align: left;" >Acknowledged the caller, match style and pace/put customer at ease.</td>
										<td>
											<select class="form-control od_ecommerce_point customer" name="data[acknowledge_the_caller]" required>
												
												<option od_ecommerce_val=1 <?php echo $od_ecommerce['acknowledge_the_caller'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option od_ecommerce_val=1 <?php echo $od_ecommerce['acknowledge_the_caller'] == "No"?"selected":"";?> value="No">No</option>
												<option od_ecommerce_val=0 <?php echo $od_ecommerce['acknowledge_the_caller'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td>1</td>
										
										<td colspan=2.5><input type="text" class="form-control" name="data[cmt1]" value="<?php echo $od_ecommerce['cmt1'] ?>"></td>
										
									</tr>
									<tr>
									<td style="background-color:#FADBD8">Business Critical</td>
										<td colspan="3" class="eml1" style="text-align: left;">Properly identified customer and/or account.</td>
										<td>
											<select class="form-control od_ecommerce_point business" name="data[made_the_customer]" required>
												
												<option od_ecommerce_val=1 <?php echo $od_ecommerce['made_the_customer'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option od_ecommerce_val=1 <?php echo $od_ecommerce['made_the_customer'] == "No"?"selected":"";?> value="No">No</option>
												<option od_ecommerce_val=0 <?php echo $od_ecommerce['made_the_customer'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td>1</td>
										
										<td colspan=2.5><input type="text" class="form-control" name="data[cmt2]" value="<?php echo $od_ecommerce['cmt2'] ?>"></td>
										
									</tr>
									<tr>
									<td style="background-color:#A9DFBF">Customer Critical</td>
										<td colspan="3" class="eml1" style="text-align:left;">Appropriate and sincere use of empathy.</td>
										<td>
											<select class="form-control od_ecommerce_point customer" name="data[appropriate_and_sincere]" required>
												
												<option od_ecommerce_val=1 <?php echo $od_ecommerce['appropriate_and_sincere'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option od_ecommerce_val=1 <?php echo $od_ecommerce['appropriate_and_sincere'] == "No"?"selected":"";?> value="No">No</option>
												<option od_ecommerce_val=0 <?php echo $od_ecommerce['appropriate_and_sincere'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td>1</td>
										
										<td colspan=2.5><input type="text" class="form-control" name="data[cmt3]" value="<?php echo $od_ecommerce['cmt3'] ?>"></td>
									</tr>
									<tr>
									<td style="background-color:#A9DFBF">Customer Critical</td>
										<td colspan="3" class="eml1" style="text-align:left;">Made the customer feel important and top priority.</td>
										<td>
											<select class="form-control od_ecommerce_point customer" name="data[customer_clearly_understood]" required>
												
												<option od_ecommerce_val=1 <?php echo $od_ecommerce['customer_clearly_understood'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option od_ecommerce_val=1 <?php echo $od_ecommerce['customer_clearly_understood'] == "No"?"selected":"";?> value="No">No</option>
												<option od_ecommerce_val=0 <?php echo $od_ecommerce['customer_clearly_understood'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td>1</td>
										
										<td colspan=2.5><input type="text" class="form-control" name="data[cmt4]" value="<?php echo $od_ecommerce['cmt4'] ?>"></td>
									</tr>

									<tr>
										
										<td class="eml1" colspan="8" style="background-color:#3f5691; color: white;text-align: left;">WAS THE ISSUE RESOLVED FOR THE CUSTOMER</td>
										<td class="eml1" colspan=8 style="background-color:#8195c9"></td>
									</tr>
									<tr>
									<td style="background-color:#FADBD8">Business Critical</td>
										<td colspan="3" class="eml1" style="text-align:left;">Followed processing guidelines for ECOM/ODR. </td>
										<td>
											<select class="form-control od_ecommerce_point business" name="data[recognized_customer_contacted]" required>
												<!-- id="voice_FA" -->
												<option od_ecommerce_val=3 <?php echo $od_ecommerce['recognized_customer_contacted'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option od_ecommerce_val=3 <?php echo $od_ecommerce['recognized_customer_contacted'] == "No"?"selected":"";?> value="No">No</option>
												<option od_ecommerce_val=0 <?php echo $od_ecommerce['recognized_customer_contacted'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td>3</td>
										
										<td colspan=2.5><input type="text" class="form-control" name="data[cmt5]" value="<?php echo $od_ecommerce['cmt5'] ?>"></td>
									</tr>
									<tr>
									<td style="background-color:#FADBD8">Business Critical</td>
										<td colspan="3" class="eml1"  style="text-align:left;">Did agent utilize all available resources/Did agent escalate the issue appropriately?</td>
										<td>
											<select class="form-control od_ecommerce_point business" name="data[verified_line_item]" required>
												
												<option od_ecommerce_val=1 <?php echo $od_ecommerce['verified_line_item'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option od_ecommerce_val=1 <?php echo $od_ecommerce['verified_line_item'] == "No"?"selected":"";?> value="No">No</option>
												<option od_ecommerce_val=0 <?php echo $od_ecommerce['verified_line_item'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td>1</td>
										
										<td colspan=2.5><input type="text" class="form-control" name="data[cmt6]" value="<?php echo $od_ecommerce['cmt6'] ?>"></td>
										<!-- <td> Critical</td> -->
										<tr>
										<td style="background-color:#F9E79F">Compliance Critical</td>
										<td colspan="3" class="eml1" style="text-align:left;">CCP noted appropriately? (Transaction History, Special Instructions, etc.)</td>
										<td>
											<select class="form-control od_ecommerce_point compliance" name="data[idepot_article_and]" required>
												
												<option od_ecommerce_val=2 <?php echo $od_ecommerce['idepot_article_and'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option od_ecommerce_val=2 <?php echo $od_ecommerce['idepot_article_and'] == "No"?"selected":"";?> value="No">No</option>
												<option od_ecommerce_val=0 <?php echo $od_ecommerce['idepot_article_and'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td>2</td>
										
										<td colspan=2.5><input type="text" class="form-control" name="data[cmt7]" value="<?php echo $od_ecommerce['cmt7'] ?>"></td>
										
									
									</tr>
									<tr>
										
										<td class="eml1" colspan="8" style="background-color:#3f5691; color: white;text-align: left;">MADE IT EASY FOR THE CUSTOMER</td>
										<td class="eml1" colspan=8 style="background-color:#8195c9"></td>
									</tr>
									
									<tr>
									<td style="background-color:#A9DFBF">Customer Critical</td>
										<td colspan="3" class="eml1" style="text-align:left;">Agent maintained control of the call (kept call on track).</td>
										<td>
											<select class="form-control od_ecommerce_point customer" id="" name="data[noted_appropriately]" required>
												
												<option od_ecommerce_val=1 <?php echo $od_ecommerce['noted_appropriately'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option od_ecommerce_val=1 <?php echo $od_ecommerce['noted_appropriately'] == "No"?"selected":"";?> value="No">No</option>
												<option od_ecommerce_val=0 <?php echo $od_ecommerce['noted_appropriately'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td>1</td>
										
										<td colspan=2.5><input type="text" class="form-control" name="data[cmt8]" value="<?php echo $od_ecommerce['cmt8'] ?>"></td>
									</tr>

								
									<tr>
									<td style="background-color:#A9DFBF">Customer Critical</td>
										<td colspan="3" class="eml1" style="text-align:left;">Listened and paraphrased, identified wants/needs and gained agreement by asking open-ended follow up questions.</td>
										<td>
											<select class="form-control od_ecommerce_point customer" name="data[listened_and_paraphrased]" required>
												
												<option od_ecommerce_val=1 <?php echo $od_ecommerce['listened_and_paraphrased'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option od_ecommerce_val=1 <?php echo $od_ecommerce['listened_and_paraphrased'] == "No"?"selected":"";?> value="No">No</option>
												<option od_ecommerce_val=0 <?php echo $od_ecommerce['listened_and_paraphrased'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td>1</td>
										
										<td colspan=2.5><input type="text" class="form-control" name="data[cmt9]" value="<?php echo $od_ecommerce['cmt9'] ?>"></td>
										
									</tr>
									<tr>
									<td style="background-color:#F9E79F">Compliance Critical</td>
										<td colspan="3" class="eml1" style="text-align:left;">Verified information as appropriate to the call, proactively utilized CTI.</td>
										<td>
											<select class="form-control od_ecommerce_point compliance" name="data[verified_information]" required>
												
												<option od_ecommerce_val=1 <?php echo $od_ecommerce['verified_information'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option od_ecommerce_val=1 <?php echo $od_ecommerce['verified_information'] == "No"?"selected":"";?> value="No">No</option>
												<option od_ecommerce_val=0 <?php echo $od_ecommerce['verified_information'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td>1</td>
										
										<td colspan=2.5><input type="text" class="form-control" name="data[cmt10]" value="<?php echo $od_ecommerce['cmt10'] ?>"></td>
										
									</tr>
									<tr>
									<td style="background-color:#F9E79F">Compliance Critical</td>
										<td colspan="3" class="eml1" style="text-align:left;">Was the proper disposition code used on the call?</td>
										<td>
											<select class="form-control od_ecommerce_point compliance" name="data[submit_the_proper_forms]" required>
												
												<option od_ecommerce_val=1 <?php echo $od_ecommerce['submit_the_proper_forms'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option od_ecommerce_val=1 <?php echo $od_ecommerce['submit_the_proper_forms'] == "No"?"selected":"";?> value="No">No</option>
												<option od_ecommerce_val=0 <?php echo $od_ecommerce['submit_the_proper_forms'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td>1</td>
										
										</td>
										<td colspan=2.5><input type="text" class="form-control" name="data[cmt11]" value="<?php echo $od_ecommerce['cmt11'] ?>"></td>
										
									</tr>
									
									<tr><td colspan="10" style="background-color:#7DCEA0"></td></tr>
									<tr style="font-weight:bold; background-color:#D7BDE2">
										<td colspan="3">Compliance</td>
										<td colspan="3">Customer</td>
										<td colspan="4">Business</td>
									</tr>
									<tr style="font-weight:bold; background-color:#D7BDE2">
										<td>Earned Point:</td><td colspan="2"><input type="text" readonly class="form-control" id="compliancescore2" name="data[compliancescore]"></td>
										<td>Earned Point:</td><td colspan="2"><input type="text" readonly class="form-control" id="customerscore2" name="data[customerscore]"></td>
										<td>Earned Point:</td><td colspan="3"><input type="text" readonly class="form-control" id="businessscore2" name="data[businessscore]"></td>
									</tr>
									<tr style="font-weight:bold; background-color:#D7BDE2">
										<td>Possible Point:</td><td colspan="2"><input type="text" readonly class="form-control" id="compliancescoreable2" name="data[compliancescoreable]"></td>
										<td>Possible Point:</td><td colspan="2"><input type="text" readonly class="form-control" id="customerscoreable2" name="data[customerscoreable]"></td>
										<td>Possible Point:</td><td colspan="3"><input type="text" readonly class="form-control" id="businessscoreable2" name="data[businessscoreable]"></td>
									</tr>
									<tr style="font-weight:bold; background-color:#D7BDE2">
										<td>Overall Percentage:</td><td colspan="2"><input type="text" readonly class="form-control" id="compliance_score_percent2" name="data[compliance_score_percent]"></td>
										<td>Overall Percentage:</td><td colspan="2"><input type="text" readonly class="form-control" id="customer_score_percent2" name="data[customer_score_percent]"></td>
										<td>Overall Percentage:</td><td colspan="3"><input type="text" readonly class="form-control" id="business_score_percent2" name="data[business_score_percent]"></td>
									</tr>
									<tr>
										<td>Call Summary:</td>
										<td colspan="3"><textarea class="form-control"   name="data[call_summary]"><?php echo $od_ecommerce['call_summary'] ?></textarea></td>
										<td>Feedback:</td>
										<td colspan="4"><textarea class="form-control"   name="data[feedback]"><?php echo $od_ecommerce['feedback'] ?></textarea></td>
									</tr>
									
									<tr>
										<td colspan=2>Upload Files</td>
										<?php if($od_ecommerce_id==0){ ?>
											<td colspan=8><input type="file" multiple class="form-control" id="attach_file" name="attach_file[]"></td>
										<?php }else{
											if($od_ecommerce['attach_file']!=''){ ?>
												<td colspan=8>
													<?php $attach_file = explode(",",$od_ecommerce['attach_file']);
													 foreach($attach_file as $mp){ ?>
														<audio controls='' style="background-color:#607F93"> 
														  <source src="<?php echo base_url(); ?>qa_files/qa_od/<?php echo $mp; ?>" type="audio/ogg">
														  <source src="<?php echo base_url(); ?>qa_files/qa_od/<?php echo $mp; ?>" type="audio/mpeg">
														</audio> </br>
													 <?php } ?>
												</td>
										<?php }else{
												echo '<td colspan=6><b>No Files</b></td>';
											  }
										} ?>
									</tr>
									
									<?php if($od_ecommerce_id!=0){ ?>
										<tr><td colspan=2 style="font-size:16px; font-weight:bold">Agent Feedback Acceptance:</td><td colspan=8><?php echo $od_ecommerce['agnt_fd_acpt'] ?></td></tr>
										<tr><td colspan=2 style="font-size:16px; font-weight:bold">Agent Review:</td><td colspan=8><?php echo $od_ecommerce['agent_rvw_note'] ?></td></tr>
										<tr><td colspan=2 style="font-size:16px; font-weight:bold">Management Review:</td><td colspan=8><?php echo $od_ecommerce['mgnt_rvw_note'] ?></td></tr>
										<tr><td colspan=2 style="font-size:16px; font-weight:bold">Client Review:</td><td colspan=8><?php echo $od_ecommerce['client_rvw_note'] ?></td></tr>
										
										<tr><td colspan=2  style="font-size:16px">Your Review</td><td colspan=8><textarea class="form-control1" style="width:100%" id="note" name="note"  ></textarea></td></tr>
									<?php } ?>
									
									<?php 
									if($od_ecommerce_id==0){
										if(is_access_qa_module()==true || is_access_qa_operations_module()==true){ ?>
											<tr><td colspan=8><button class="btn btn-success waves-effect" type="submit" id="qaformsubmit" style="width:500px">SAVE</button></td></tr>
									<?php 
										} 
									}else{ 
										if(is_access_qa_module()==true || is_access_qa_operations_module()==true){
											if(is_available_qa_feedback($od_ecommerce['entry_date'],72) == true){ ?>
												<tr><td colspan="10"><button class="btn btn-success waves-effect" type="submit" id='qaformsubmit' name='btnSave' value="SAVE" style="width:500px">SAVE</button></td></tr>
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
