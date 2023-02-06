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

<?php if(is_access_qa_edit_feedback()==false){ ?>
	<style>
		.form-control{
			pointer-events:none;
			background-color:#D5DBDB;
		}
	</style>
<?php } ?>

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
										<td colspan="6" id="theader" style="font-size:30px">AMERIDIAL [Stauers sales Scorecard]
										<input type="hidden" name="fbid" value="<?php echo $fbid; ?>">
										</td>
									</tr>
									
									<tr>
										<td>QA Name:</td>
										<td><input type="text" class="form-control" value="<?php echo $aspca_data['auditor_name']; ?>" disabled></td>
										<td>Audit Date:</td>
										<td><input type="text" class="form-control" value="<?php echo mysql2mmddyy($aspca_data['audit_date']); ?>" disabled></td>
										<td>Call Date:</td>
										<td><input type="text" class="form-control" id="call_date" name="call_date" value="<?php echo mysql2mmddyy($aspca_data['call_date']); ?>" required></td>
									</tr>
									<tr>
										<td>Agent:</td>
										<td>
											<select class="form-control" id="agent_id" name="agent_id" required>
												<option value="<?php echo $aspca_data['agent_id'] ?>"><?php echo $aspca_data['fname']." ".$aspca_data['lname'] ?></option>
												<option value="">-Select-</option>
												<?php foreach($agentName as $row):  ?>
													<option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
												<?php endforeach; ?>
											</select>
										</td>
										<td>Fusion ID:</td>
										<td><input type="text" readonly class="form-control" id="fusion_id" name="" value="<?php echo $aspca_data['fusion_id'] ?>"></td>
										<td>L1 Supervisor:</td>
										<td>
											<select class="form-control" id="tl_id" name="tl_id" readonly>
												<option value="<?php echo $aspca_data['tl_id'] ?>"><?php echo $aspca_data['tl_name'] ?></option>
												<option value="">--Select--</option>
												<?php foreach($tlname as $tl): ?>
													<option value="<?php echo $tl['id']; ?>"><?php echo $tl['fname']." ".$tl['lname']; ?></option>
												<?php endforeach; ?>	
											</select>
										</td>
									</tr>
									<tr>
										<td>Site/Location:</td>
										<td><input type="text" readonly class="form-control" id="office_id" value="<?php echo $aspca_data['office_id'] ?>"></td>
										<td>Call Duration:</td>
										<td><input type="text" class="form-control" id="call_duration" name="call_duration" value="<?php echo $aspca_data['call_duration'] ?>" required></td>
										<td>File No.:</td>
										<td><input type="text" class="form-control" id="file_no" name="file_no" value="<?php echo $aspca_data['file_no'] ?>" required></td>
									</tr>
									<tr>
										<td>Audit Type:</td>
										<td>
											<select class="form-control" id="audit_type" name="audit_type" required>
												<option value="<?php echo $aspca_data['audit_type'] ?>"><?php echo $aspca_data['audit_type'] ?></option>
												<option value="">-Select-</option>
												<option value="CQ Audit">CQ Audit</option>
												<option value="BQ Audit">BQ Audit</option>
												<option value="Calibration">Calibration</option>
												<option value="Pre-Certification Mock Call">Pre-Certification Mock Call</option>
												<option value="Certification Audit">Certification Audit</option>
											</select>
										</td>
										<td class="auType">Auditor Type</td>
										<td class="auType">
											<select class="form-control" id="auditor_type" name="auditor_type">
												<option value="">-Select-</option>
												<option <?php echo $aspca_data['auditor_type']=='Master'?"selected":""; ?> value="Master">Master</option>
												<option <?php echo $aspca_data['auditor_type']=='Regular'?"selected":""; ?> value="Regular">Regular</option>
											</select>
										</td>
										<td>VOC:</td>
										<td>
											<select class="form-control" id="voc" name="voc" required>
												<option value="<?php echo $aspca_data['voc'] ?>"><?php echo $aspca_data['voc'] ?></option>
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
										<td style="font-weight:bold; font-size:16px">Earned Score</td>
										<td><input type="text" readonly id="conduent_earn_score" name="earned_score" class="form-control" style="font-weight:bold" value="<?php echo $aspca_data['earned_score'] ?>"></td>
										<td style="font-weight:bold; font-size:16px">Possible Score</td>
										<td><input type="text" readonly id="conduent_possible_score" name="possible_score" class="form-control" style="font-weight:bold" value="<?php echo $aspca_data['possible_score'] ?>"></td>
										<td style="font-weight:bold; font-size:16px">Overall Score:</td>
										<td><input type="text" readonly id="conduent_overall_score" name="overall_score" class="form-control" style="font-weight:bold" value="<?php echo $aspca_data['overall_score'] ?>"></td>
									</tr>
									<tr style="height:25px; font-weight:bold; background-color:#D4AC0D">
										<td colspan="4">PARAMETER</td>
										<td>STATUS</td>
									</tr>
									<tr>
										<td class="eml1" colspan=4>Was the call answered within 5 seconds?</td>
										<td>4</td>
										<td>
											<select class="form-control conduent_points" id="" name="text1" required>
												<option value="">-Select-</option>
												<option acm_val=4 <?php echo $aspca_data['call_answered_5_seconds']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option acm_val=4 <?php echo $aspca_data['call_answered_5_seconds']=='No'?"selected":""; ?> value="No">No</option>
												<option acm_val=4 <?php echo $aspca_data['call_answered_5_seconds']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" value="<?php echo $aspca_data['cmt1'] ?>" name="cmt1"></td>
										<td>Customer</td>
									</tr>
									<tr>
										<td class="eml1" colspan=4>Did the agent verify the customer's name and address on the account?</td>
										<td>8</td>
										<td>
											<select class="form-control conduent_points" id="" name="text2" required>
												<option value="">-Select-</option>
												<option acm_val=8 <?php echo $aspca_data['agent_verify_customer_name_address']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option acm_val=8 <?php echo $aspca_data['agent_verify_customer_name_address']=='No'?"selected":""; ?> value="No">No</option>
												<option acm_val=8 <?php echo $aspca_data['agent_verify_customer_name_address']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" value="<?php echo $aspca_data['cmt2'] ?>" name="cmt2"></td>
										<td>Compliance</td>
									</tr>
									<tr>
										<td class="eml1" colspan=4>Did the agent capture the correct offer code?</td>
										<td>4</td>
										<td>
											<select class="form-control conduent_points" id="" name="text3" required>
												<option value="">-Select-</option>
												<option acm_val=4 <?php echo $aspca_data['agent_capture_correct_offer']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option acm_val=4 <?php echo $aspca_data['agent_capture_correct_offer']=='No'?"selected":""; ?> value="No">No</option>
												<option acm_val=4 <?php echo $aspca_data['agent_capture_correct_offer']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" value="<?php echo $aspca_data['cmt3'] ?> "name="cmt3"></td>
										<td>Business Critical</td>
									</tr>
									<tr>
										<td class="eml1" colspan=4>Did the agent verify the phone number with the customer?</td>
										<td>7</td>
										<td>
											<select class="form-control conduent_points" id="" name="text4" required>
												<option value="">-Select-</option>
												<option acm_val=7 <?php echo $aspca_data['agent_verify_phone_number']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option acm_val=7 <?php echo $aspca_data['agent_verify_phone_number']=='No'?"selected":""; ?> value="No">No</option>
												<option acm_val=7 <?php echo $aspca_data['agent_verify_phone_number']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" value="<?php echo $aspca_data['cmt4'] ?>" name="cmt4"></td>
										<td>Compliance</td>
									</tr>
									<tr>
										<td class="eml1" colspan=4>Did the agent verify the customer's email address?</td>
										<td>7</td>
										<td>
											<select class="form-control conduent_points" id="" name="text5" required>
												<option value="">-Select-</option>
												<option acm_val=7 <?php echo $aspca_data['agent_verify_customer_email']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option acm_val=7 <?php echo $aspca_data['agent_verify_customer_email']=='No'?"selected":""; ?> value="No">No</option>
												<option acm_val=7 <?php echo $aspca_data['agent_verify_customer_email']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" value="<?php echo $aspca_data['cmt5'] ?>"  name="cmt5"></td>
										<td>Compliance</td>
									</tr>
									<tr>
										<td class="eml1" colspan=4>Did the agent compliment the caller's purchase choice?</td>
										<td>5</td>
										<td>
											<select class="form-control conduent_points" id="" name="text6" required>
												<option value="">-Select-</option>
												<option acm_val=5 <?php echo $aspca_data['agent_compliment_caller_purchase']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option acm_val=5 <?php echo $aspca_data['agent_compliment_caller_purchase']=='No'?"selected":""; ?> value="No">No</option>
												<option acm_val=5 <?php echo $aspca_data['agent_compliment_caller_purchase']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" value="<?php echo $aspca_data['cmt6'] ?>" name="cmt6"></td>
										<td>Compliance</td>
									</tr>
									<tr>
										<td class="eml1" colspan=4>Did the agent recap the item?</td>
										<td>7</td>
										<td>
											<select class="form-control conduent_points" id="" name="text6" required>
												<option value="">-Select-</option>
												<option acm_val=7 <?php echo $aspca_data['agent_recap']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option acm_val=7 <?php echo $aspca_data['agent_recap']=='No'?"selected":""; ?> value="No">No</option>
												<option acm_val=7 <?php echo $aspca_data['agent_recap']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control"  value="<?php echo $aspca_data['cmt7'] ?>" name="cmt7"></td>
										<td>Business</td>
									</tr>
									<tr>
										<td class="eml1" colspan=4>Did the agent cover atleast one upsell ( ask if the customer would be interested in any other products)?</td>
										<td>10</td>
										<td>
											<select class="form-control conduent_points" id="" name="text6" required>
												<option value="">-Select-</option>
												<option acm_val=10 <?php echo $aspca_data['agent_cover_upsell']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option acm_val=10 <?php echo $aspca_data['agent_cover_upsell']=='No'?"selected":""; ?> value="No">No</option>
												<option acm_val=10 <?php echo $aspca_data['agent_cover_upsell']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" value="<?php echo $aspca_data['cmt8'] ?>"  name="cmt8"></td>
										<td>Business</td>
									</tr>
									<tr>
										<td class="eml1" colspan=4>Was the shipping address verified?</td>
										<td>6</td>
										<td>
											<select class="form-control conduent_points" id="" name="text15" required>
												<option value="">-Select-</option>
												<option acm_val=6 <?php echo $aspca_data['shipping_address_verified']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option acm_val=6 <?php echo $aspca_data['shipping_address_verified']=='No'?"selected":""; ?> value="No">No</option>
												<option acm_val=6 <?php echo $aspca_data['shipping_address_verified']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" value="<?php echo $aspca_data['cmt9'] ?>" name="cmt9"></td>
										<td>Customer</td>
									</tr>
									<tr>
										<td class="eml1" colspan=4>Did the agent quote the correct delivery time?</td>
										<td>6</td>
										<td>
											<select class="form-control conduent_points" id="" name="text16" required>
												<option value="">-Select-</option>
												<option acm_val=6 <?php echo $aspca_data['quote_correct_delivery_time']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option acm_val=6 <?php echo $aspca_data['quote_correct_delivery_time']=='No'?"selected":""; ?> value="No">No</option>
												<option acm_val=6 <?php echo $aspca_data['quote_correct_delivery_time']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" value="<?php echo $aspca_data['cmt10'] ?>" name="cmt10"></td>
										<td>Customer</td>
									</tr>
									<tr>
										<td class="eml1" colspan=4>Did the agent give a total product quote appropriately?</td>
										<td>6</td>
										<td>
											<select class="form-control conduent_points" id="" name="text17" required>
												<option value="">-Select-</option>
												<option acm_val=6 <?php echo $aspca_data['agent_total_product_appropriately']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option acm_val=6 <?php echo $aspca_data['agent_total_product_appropriately']=='No'?"selected":""; ?> value="No">No</option>
												<option acm_val=6 <?php echo $aspca_data['agent_total_product_appropriately']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" value="<?php echo $aspca_data['cmt11'] ?>"  name="cmt11"></td>
										<td>Customer</td>
									</tr>
									<tr>
										<td class="eml1" colspan=4>Did the agent quote shipping & taxes correctly?</td>
										<td>6</td>
										<td>
											<select class="form-control conduent_points" id="" name="text18" required>
												<option value="">-Select-</option>
												<option acm_val=6 <?php echo $aspca_data['agent_quote_shipping_taxes']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option acm_val=6 <?php echo $aspca_data['agent_quote_shipping_taxes']=='No'?"selected":""; ?> value="No">No</option>
												<option acm_val=6 <?php echo $aspca_data['agent_quote_shipping_taxes']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" value="<?php echo $aspca_data['cmt12'] ?>"   name="cmt12"></td>
										<td>Customer</td>
									</tr>
									<tr>
										<td class="eml1" colspan=4>Did the agent provide the order number correctly?</td>
										<td>5</td>
										<td>
											<select class="form-control conduent_points" id="" name="text20" required>
												<option value="">-Select-</option>
												<option acm_val=5 <?php echo $aspca_data['agent_provide_order_number']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option acm_val=5 <?php echo $aspca_data['agent_provide_order_number']=='No'?"selected":""; ?> value="No">No</option>
												<option acm_val=5 <?php echo $aspca_data['agent_provide_order_number']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" value="<?php echo $aspca_data['cmt13'] ?>" name="cmt13"></td>
										<td>Customer</td>
									</tr>
									<tr>
										<td class="eml1" colspan=4>Did the agent close the call with the brand correctly?</td>
										<td>2</td>
										<td>
											<select class="form-control conduent_points" id="" name="text21" required>
												<option value="">-Select-</option>
												<option acm_val=2 <?php echo $aspca_data['agent_close_call_brand_correctly']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option acm_val=2 <?php echo $aspca_data['agent_close_call_brand_correctly']=='No'?"selected":""; ?> value="No">No</option>
												<option acm_val=2 <?php echo $aspca_data['agent_close_call_brand_correctly']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" value="<?php echo $aspca_data['cmt14'] ?>" name="cmt14"></td>
										<td>Business</td>
									</tr>
									<tr>
										<td class="eml1" colspan=4>Did the agent disposition the call correctly?</td>
										<td>5</td>
										<td>
											<select class="form-control conduent_points" id="" name="text21" required>
												<option value="">-Select-</option>
												<option acm_val=5 <?php echo $aspca_data['agent_disposition']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option acm_val=5 <?php echo $aspca_data['agent_disposition']=='No'?"selected":""; ?> value="No">No</option>
												<option acm_val=5 <?php echo $aspca_data['agent_disposition']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" value="<?php echo $aspca_data['cmt15'] ?>" name="cmt15"></td>
										<td>Business</td>
									</tr>
									<tr>
										<td class="eml1" colspan=4>Did the agent maintain call control? No dead air for more than 15 secs?</td>
										<td>4</td>
										<td>
											<select class="form-control conduent_points" id="" name="text21" required>
												<option value="">-Select-</option>
												<option acm_val=4 <?php echo $aspca_data['dead_air']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option acm_val=4 <?php echo $aspca_data['dead_air']=='No'?"selected":""; ?> value="No">No</option>
												<option acm_val=4 <?php echo $aspca_data['dead_air']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" value="<?php echo $aspca_data['cmt16'] ?>" name="cmt16"></td>
										<td>Customer</td>
									</tr>
									<tr>
										<td class="eml1" colspan=4>Was the customer satisfied with his/her experience?</td>
										<td>3</td>
										<td>
											<select class="form-control conduent_points" id="" name="text22" required>
												<option value="">-Select-</option>
												<option acm_val=3 <?php echo $aspca_data['customer_satisfied_experience']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option acm_val=3 <?php echo $aspca_data['customer_satisfied_experience']=='No'?"selected":""; ?> value="No">No</option>
												<option acm_val=3 <?php echo $aspca_data['customer_satisfied_experience']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" value="<?php echo $aspca_data['cmt17'] ?>" name="cmt17"></td>
										<td>Customer</td>
									</tr>
									<tr>
										<td class="eml1" colspan=4>Was the customer dissatisfied with the agent's professionalism and/or tone?</td>
										<td>2</td>
										<td>
											<select class="form-control conduent_points" id="" name="text23" required>
												<option value="">-Select-</option>
												<option acm_val=2 <?php echo $aspca_data['customer_dissatisfied_professionalism']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option acm_val=2 <?php echo $aspca_data['customer_dissatisfied_professionalism']=='No'?"selected":""; ?> value="No">No</option>
												<option acm_val=2 <?php echo $aspca_data['customer_dissatisfied_professionalism']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" value="<?php echo $aspca_data['cmt18'] ?>" name="cmt18"></td>
										<td>Customer</td>
									</tr>
									<tr>
									<td colspan=9 class="eml1" style="color:red">Other (Any score here =ZERO fatal for call)</td>
								</tr>
								<tr>
										<td class="eml" colspan=4 style="color:red">Did the agent give the total to be charged and verify the credit card to be charged correctly?</td>
										<td>1</td>
										<td>
											<select class="form-control conduent_points business" id="hovBR1"  name="text19" required>
												<option value="">-Select-</option>
												<option acm_val=1 <?php echo $aspca_data['agent_give_total_charged']=='Pass'?"selected":""; ?> value="Pass">Pass</option>
												<option acm_val=0 <?php echo $aspca_data['agent_give_total_charged']=='Fail'?"selected":""; ?> value="Fail">Fail</option>
												<option acm_val=1 <?php echo $aspca_data['agent_give_total_charged']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
									<td colspan=2><input type="text" class="form-control" value="<?php echo $aspca_data['cmt19'] ?>" name="cmt19"></td>
									<td>Business</td>
								</tr>
								<tr>
									<td class="eml" colspan=4 style="color:red">Rude Remarks</td>
										<td>1</td>
										<td>
											<select class="form-control conduent_points compliance_round" id="hovBR2" name="rude_remarks" required>
												<option value="">-Select-</option>
												<option acm_val=1 <?php echo $aspca_data['rude_remarks']=='Pass'?"selected":""; ?> value="Pass">Pass</option>
												<option acm_val=0 <?php echo $aspca_data['rude_remarks']=='Fail'?"selected":""; ?> value="Fail">Fail</option>
												<option acm_val=1 <?php echo $aspca_data['rude_remarks']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
									<td colspan=2><input type="text" class="form-control" value="<?php echo $aspca_data['cmt20'] ?>" name="cmt20"></td>
									<td>Compliance</td>
								</tr>
								<tr>
									<td class="eml" colspan=4 style="color:red">Call Avoidance</td>
										<td>1</td>
										<td>
											<select class="form-control conduent_points compliance_round" id="hovBR2" name="call_avoidance" required>
												<option value="">-Select-</option>
												<option acm_val=1 <?php echo $aspca_data['call_avoidance']=='Pass'?"selected":""; ?> value="Pass">Pass</option>
												<option acm_val=0 <?php echo $aspca_data['call_avoidance']=='Fail'?"selected":""; ?> value="Fail">Fail</option>
												<option acm_val=1 <?php echo $aspca_data['call_avoidance']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
									<td colspan=2><input type="text" class="form-control" value="<?php echo $aspca_data['cmt21'] ?>" name="cmt21"></td>
									<td>Compliance</td>
								</tr>
								<tr style="background-color:#D2B4DE"><td colspan=2>Customer Score</td><td colspan=4>Business Score</td><td colspan=4>Compliance Score</td></tr>
									<tr style="background-color:#D2B4DE">
										<td>Earned:</td><td colspan="">
											<input type="text" readonly style="background-color:#D2B4DE; text-align:center" class="form-control" id="custlockEarned1" name="custlockEarned" value="<?php echo $aspca_data['custlockEarned'] ?>">
										</td>
										<td>Earned:</td>
										<td colspan="3">
											<input type="text" readonly style="background-color:#D2B4DE; text-align:center" class="form-control" id="busilockEarned1" name="busilockEarned" value="<?php echo $aspca_data['busilockEarned'] ?>">
										</td>
										<td>Earned:</td>
										<td colspan="3">
											<input type="text" readonly style="background-color:#D2B4DE; text-align:center" class="form-control" id="compllockEarned1" name="compllockEarned" value="<?php echo $aspca_data['compllockEarned'] ?>">
										</td>
									</tr>
									<tr style="background-color:#D2B4DE">
										<td>Possible:</td>
										<td colspan="">
										<input type="text" readonly style="background-color:#D2B4DE; text-align:center" class="form-control" id="custlockPossible1" name="custlockPossible" value="<?php echo $aspca_data['custlockPossible'] ?>">	
										</td>
										<td>Possible:</td>
										<td colspan="3">
										<input type="text" readonly style="background-color:#D2B4DE; text-align:center" class="form-control" id="busilockPossible1" name="busilockPossible" value="<?php echo $aspca_data['busilockPossible'] ?>">	
										</td>
										<td>Possible:</td>
										<td colspan="3">
										<input type="text" readonly style="background-color:#D2B4DE; text-align:center" class="form-control" id="compllockPossible1" name="compllockPossible" value="<?php echo $aspca_data['compllockPossible'] ?>">	
										</td>
									</tr>
									<tr style="background-color:#D2B4DE">
										<td>Percentage:</td><td colspan=""><input type="text" readonly style="background-color:#D2B4DE; text-align:center" class="form-control" id="custlockScore" name="customer_score" value="<?php echo $aspca_data['customer_score'] ?>"></td>
										<td>Percentage:</td><td colspan="3"><input type="text" readonly style="background-color:#D2B4DE; text-align:center" class="form-control" id="busilockScore" name="business_score" value="<?php echo $aspca_data['business_score'] ?>"></td>
										<td>Percentage:</td><td colspan="3"><input type="text" readonly style="background-color:#D2B4DE; text-align:center" class="form-control" id="compllockScore" name="compliance_score" value="<?php echo $aspca_data['compliance_score'] ?>"></td>
									</tr>
									<tr>
										<td>Call Summary:</td>
										<td colspan="2"><textarea class="form-control" id="call_summary" name="call_summary"><?php echo $aspca_data['call_summary'] ?></textarea></td>
										<td>Feedback:</td>
										<td colspan="2"><textarea class="form-control" id="feedback" name="feedback"><?php echo $aspca_data['feedback'] ?></textarea></td>
									</tr>
									
									<?php if($aspca_data['attach_file']!=''){ ?>
									<tr>
										<td colspan="2">Audio Files</td>
										<td colspan="4">
											<?php $attach_file = explode(",",$aspca_data['attach_file']);
											 foreach($attach_file as $mp){ ?>
												<audio controls='' style="background-color:#607F93"> 
												  <source src="<?php echo base_url(); ?>qa_files/qa_ameridial/stauers_sales/<?php echo $mp; ?>" type="audio/ogg">
												  <source src="<?php echo base_url(); ?>qa_files/qa_ameridial/stauers_sales/<?php echo $mp; ?>" type="audio/mpeg">
												</audio> </br>
											 <?php } ?>
										</td>
									</tr>
									<?php } ?>
									
									<tr><td colspan="6" style="background-color:#C5C8C8"></td></tr>
									
									<?php if($aspca_data['agent_rvw_date']==''){ ?>
										<tr>
											<td colspan="6" style="font-size:16px; font-weight:bold">Agent Review Not found</td>
										</tr>
									<?php }else{ ?>
										<tr>
											<td colspan=2 style="font-size:16px">Feedback Acceptance</td>
											<td colspan=2>
												<select class="form-control" id="" name="agnt_fd_acpt" disabled>
													<option value="">--Select--</option>
													<option <?php echo $aspca_data['agnt_fd_acpt']=='Acceptance'?"selected":""; ?> value="Acceptance">Acceptance</option>	
													<option <?php echo $aspca_data['agnt_fd_acpt']=='Not Acceptance'?"selected":""; ?> value="Not Acceptance">Not Acceptance</option>	
												</select>
											</td>
										</tr>
										<tr>
											<td colspan="2"  style="font-size:16px">Agent Review</td>
											<td colspan="4">
												<textarea class="form-control" id="note" name="note" disabled><?php echo $aspca_data['agent_rvw_note']; ?></textarea>
											</td>
										</tr>
									<?php } ?>	
									
									<tr><td colspan="6" style="background-color:#C5C8C8"></td></tr>
									
									<tr>
										<td colspan="2"  style="font-size:16px">Manager Review</td>
										<td colspan="4">
											<input type="hidden" id="action" name="action" class="form-control" value="<?php echo $aspca_data['id']; ?>">
											<textarea class="form-control1" style="width:100%" id="note" name="note" required><?php echo $aspca_data['mgnt_rvw_note'] ?></textarea>
										</td>
									</tr>
									
									<?php if(is_access_qa_module()==true || is_access_qa_operations_module()==true){
									if(is_available_qa_feedback($aspca_data['entry_date'],72) == true){ ?>
										<tr>
											<td colspan="6"><button class="btn btn-success waves-effect" type="submit" id='btnmgntSave' name='btnSave' value="SAVE" style="width:500px">SAVE</button></td>
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
