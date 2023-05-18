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

<?php if($od_business_id!=0){
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
										<td colspan="10" id="theader" style="font-size:30px">OFFICE DEPOT: Business Direct Call Quality Form</td>
										<input type="hidden" name="audit_start_time" value="<?php echo CurrMySqlDate(); ?>">
									</tr>
									<?php
										if($od_business_id==0){
											$auditorName = get_username();
											$auditDate = CurrDateMDY();
											$clDate_val='';
											$clreview_date='';
										}else{
											if($od_business['entry_by']!=''){
												$auditorName = $od_business['auditor_name'];
											}else{
												$auditorName = $od_business['client_name'];
											}
											$auditDate = mysql2mmddyy($od_business['audit_date']);
											$clDate_val = mysql2mmddyy($od_business['call_date']);
											$clreview_date = mysql2mmddyy($od_business['review_date']);
										}
									?>
									<tr>
										<td style="width:150px">Auditor Name:<span style="font-size:24px;color:red">*</span></td>
										<td style="width:250px"><input type="text" class="form-control" value="<?php echo $auditorName; ?>" disabled></td>
										<td style="width:150px">Audit Date:<span style="font-size:24px;color:red">*</span></td>
										<td style="width:200px"><input type="text" class="form-control" value="<?php echo $auditDate; ?>" disabled></td>
										<td style="width:150px">Call Date:<span style="font-size:24px;color:red">*</span></td>
										<td style="width:250px"><input type="text" class="form-control" id="call_date" name="call_date" value="<?php echo $clDate_val; ?>" required></td>
										<td style="width:150px">Call Duration:<span style="font-size:24px;color:red">*</span></td>
										<td style="width:250px"><input type="text" class="form-control" id="call_duration" name="data[call_duration]" value="<?php echo $od_business['call_duration'] ?>" required ></td>
										
									</tr>
									<tr>
										<td>Agent:<span style="font-size:24px;color:red">*</span></td>
										<td>
											<select class="form-control" id="agent_id" name="data[agent_id]" required >
												<option value="<?php echo $od_business['agent_id'] ?>"><?php echo $od_business['fname']." ".$od_business['lname'] ?></option>
												
												<?php foreach($agentName as $row):  ?>
													<option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
												<?php endforeach; ?>
											</select>
										</td>
										<td>Fusion ID:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control" id="fusion_id" value="<?php echo $od_business['fusion_id'] ?>" readonly ></td>
										<td>L1 Supervisor:<span style="font-size:24px;color:red">*</span></td>
										<td>
											<input type="text" class="form-control" id="tl_name"  value="<?php echo $od_business['tl_name'] ?>" readonly>
												<input type="hidden" class="form-control" id="tl_id" name="data[tl_id]" value="<?php echo $od_business['tl_id'] ?>" required>
										</td>
										<td>Review Date:<span style="font-size:24px;color:red">*</span></td>
										<td style="width:200px"><input type="text" class="form-control" id="review_date" name="review_date" value="<?php echo $clreview_date; ?>" required></td>
									</tr>
									<tr>
									<td>Reviewed By:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control" name="data[reviewed]" value="<?php echo $od_business['reviewed'] ?>" required ></td>
										<td>Customer Id:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control" name="data[customer_id]" value="<?php echo $od_business['customer_id'] ?>" required ></td>
										<td>Session ID:<span style="font-size:24px;color:red">*</span></td>
										<td>
											<input type="text" class="form-control" name="data[session_id]" value="<?php echo $od_business['session_id'] ?>" required > 
										</td>	
										<td>LOB:<span style="font-size:24px;color:red">*</span></td>
									<td>
											<select class="form-control" id="lob" name="data[lob]" required>
												<option value="<?php echo $od_business['lob'] ?>"><?php echo $od_business['lob'] ?></option>
												
												<option value="BDD">BDD</option>
											</select>
										</td>
									</tr>
									
									<tr>
									<td>Disposition Category:<span style="font-size:24px;color:red">*</span></td>
										<td>
											<select class="form-control" id="dis_cate" name="data[disposition_cate]" required>
												
												<option value="<?php echo $od_business['disposition_cate'] ?>"><?php echo $od_business['disposition_cate'] ?></option>
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
										<td>Disposition Sub Category:<span style="font-size:24px;color:red">*</span></td>
										<td>
											<select class="form-control" id="dis_sub_cate" name="data[disposition_sub_cate]" required>
												<option value="<?php echo $od_business['disposition_sub_cate'] ?>"><?php echo $od_business['disposition_sub_cate'] ?></option>
											</select>
										</td>
									<!-- </tr>
									<tr> -->
										<td>Audit Type:<span style="font-size:24px;color:red">*</span></td>
										<td>
											<select class="form-control" id="audit_type" name="data[audit_type]" required>
												<option value="<?php echo $od_business['audit_type'] ?>"><?php echo $od_business['audit_type'] ?></option>
												
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
										<td class="auType">Auditor Type<span style="font-size:24px;color:red">*</span></td>
										<td class="auType">
											<select class="form-control" id="auditor_type" name="data[auditor_type]">
												
												<option value="Master">Master</option>
												<option value="Regular">Regular</option>
											</select>
										</td>
										
									</tr>
									<tr>
									<td>Workgroup:<span style="font-size:24px;color:red">*</span></td>
										<td>
											<select class="form-control"  name="data[workgroup]" required>
												<option value="<?php echo $od_business['workgroup'] ?>"><?php echo $od_business['workgroup'] ?></option>
												<!-- <option value="">-Select-</option> -->
												<option value="OD.COM ">OD.COM </option>
												<option value="WebSupport">WebSupport</option>
											</select>
										</td>
									<td>Predictive CSAT:<span style="font-size:24px;color:red">*</span></td>
										<td>
											<select class="form-control" id="voc" name="data[voc]" required>
												<option value="<?php echo $od_business['voc'] ?>"><?php echo $od_business['voc'] ?></option>
												
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
										<td>Customer VOC:<span style="font-size:24px;color:red">*</span></td>
										<td colspan="2">
											<select class="form-control" id="customer_voc" name="data[customer_voc]" required>
												<option value="<?php echo $od_business['customer_voc'] ?>"><?php echo $od_business['customer_voc'] ?></option>
												
												<option value="Detractor">Detractor</option>
												<option value="Passive">Passive</option>
												<option value="Promoter">Promoter</option>
											</select>
										</td>
									</tr>
									<tr>
										<td style="font-weight:bold; font-size:16px">Possible Score:</td>
										<td><input type="text" readonly id="od_business_possible_score" name="data[possible_score]" class="form-control" style="font-weight:bold" value="<?php echo $od_business['possible_score'] ?>"></td>
										<td style="font-weight:bold; font-size:16px">Earned Score:</td>
										<td><input type="text" readonly id="od_business_earned_score" name="data[earned_score]" class="form-control" style="font-weight:bold" value="<?php echo $od_business['earned_score'] ?>"></td>
										<td style="font-weight:bold; font-size:16px; text-align:right">Overall Score:</td>
										<td><input type="text" readonly id="od_business_overall_score" name="data[overall_score]" class="form-control voice_fatal" style="font-weight:bold" value="<?php echo $od_business['overall_score'] ?>"></td>
										<td colspan="2"><input type="text" readonly id="ecommerce_score" name="data[division_status]" class="form-control" style="font-weight:bold" value="<?php echo $od_business['division_status'] ?>"></td>
									</tr>
								
									<tr style="height:25px; font-weight:bold; background-color:#85C1E9">
										<td>COPC PARAMETER</td>
										<td colspan="3">PARAMETER</td>
										<td>RESPONSE</td>
										<td>POSSIBLE POINTS</td>
										<td colspan="2">COMMENTS</td>
									</tr>
								
									<tr>
										<td class="eml1" colspan="8" style="background-color:#3f5691; color: white;text-align: left;">CONNECT WITH CUSTOMER</td>
										<td class="eml1" colspan="" style="background-color:#8195c9"></td>
									</tr>
									<tr>
									<td style="background-color:#A9DFBF">Customer Critical</td>
										<td colspan="3" class="eml1" style="text-align: left;" >Acknowledged the caller, matched style and pace/put customer at ease.</td>
										<td>
											<select class="form-control od_business_point customer" name="data[acknowledge_the_caller]" required>
												
												<option od_business_val=1 <?php echo $od_business['acknowledge_the_caller'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option od_business_val=1 <?php echo $od_business['acknowledge_the_caller'] == "No"?"selected":"";?> value="No">No</option>
												<option od_business_val=0 <?php echo $od_business['acknowledge_the_caller'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td>1</td>
										
										<td colspan=2.5><input type="text" class="form-control" name="data[cmt1]" value="<?php echo $od_business['cmt1'] ?>"></td>
										
									</tr>
									<tr>
									<td style="background-color:#A9DFBF">Customer Critical</td>
										<td colspan="3" class="eml1" style="text-align: left;">Made the customer feel important and top priority</td>
										<td>
											<select class="form-control od_business_point business" name="data[customer_feel_important]" required>
												
												<option od_business_val=1 <?php echo $od_business['customer_feel_important'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option od_business_val=1 <?php echo $od_business['customer_feel_important'] == "No"?"selected":"";?> value="No">No</option>
												<option od_business_val=0 <?php echo $od_business['customer_feel_important'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td>1</td>
										
										<td colspan=2.5><input type="text" class="form-control" name="data[cmt2]" value="<?php echo $od_business['cmt2'] ?>"></td>
										
									</tr>
									<tr>
									<td style="background-color:#A9DFBF">Customer Critical</td>
										<td colspan="3" class="eml1" style="text-align:left;">Appropriate and sincere use of empathy</td>
										<td>
											<select class="form-control od_business_point customer" name="data[appropriate_empathy]" required>
												
												<option od_business_val=1 <?php echo $od_business['appropriate_empathy'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option od_business_val=1 <?php echo $od_business['appropriate_empathy'] == "No"?"selected":"";?> value="No">No</option>
												<option od_business_val=0 <?php echo $od_business['appropriate_empathy'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td>1</td>
										
										<td colspan=2.5><input type="text" class="form-control" name="data[cmt3]" value="<?php echo $od_business['cmt3'] ?>"></td>
									</tr>
									<tr>
									<td style="background-color:#A9DFBF">Customer Critical</td>
										<td colspan="3" class="eml1" style="text-align:left;">Customer clearly understood the CSR, agent used proper English (no OD jargon)</td>
										<td>
											<select class="form-control od_business_point customer" name="data[understood_CSR]" required>
												
												<option od_business_val=1 <?php echo $od_business['understood_CSR'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option od_business_val=1 <?php echo $od_business['understood_CSR'] == "No"?"selected":"";?> value="No">No</option>
												<option od_business_val=0 <?php echo $od_business['understood_CSR'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td>1</td>
										
										<td colspan=2.5><input type="text" class="form-control" name="data[cmt4]" value="<?php echo $od_business['cmt4'] ?>"></td>
									</tr>

									<tr>
										
										<td class="eml1" colspan="8" style="background-color:#3f5691; color: white;text-align: left;">Did the CCP Resolve/Recommend a solution for the customer?</td>
										<td class="eml1" colspan=8 style="background-color:#8195c9"></td>
									</tr>
									<tr>
									<td style="background-color:#FADBD8">Business Critical</td>
										<td colspan="3" class="eml1" style="text-align:left;">CCP recognized Customer contacted us multiple times regarding the same issue and escalated to Supervisor/Team Lead as appropriate?</td>
										<td>
											<select class="form-control od_business_point business" name="data[CCP_recognized]" required>
												<!-- id="voice_FA" -->
												<option od_business_val=2 <?php echo $od_business['CCP_recognized'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option od_business_val=2 <?php echo $od_business['CCP_recognized'] == "No"?"selected":"";?> value="No">No</option>
												<option od_business_val=0 <?php echo $od_business['CCP_recognized'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td>2</td>
										
										<td colspan=2.5><input type="text" class="form-control" name="data[cmt5]" value="<?php echo $od_business['cmt5'] ?>"></td>
									</tr>
									<tr>
									<td style="background-color:#F9E79F">Compliance Critical</td>
										<td colspan="3" class="eml1"  style="text-align:left;">Verified line item, quantity, price, total and delivery info AS NEEDED to place the order/return</td>
										<td>
											<select class="form-control od_business_point compliance" name="data[verify_place_order]" required>
												
												<option od_business_val=1 <?php echo $od_business['verify_place_order'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option od_business_val=1 <?php echo $od_business['verify_place_order'] == "No"?"selected":"";?> value="No">No</option>
												<option od_business_val=0 <?php echo $od_business['verify_place_order'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td>1</td>
										
										<td colspan=2.5><input type="text" class="form-control" name="data[cmt6]" value="<?php echo $od_business['cmt6'] ?>"></td>
									</tr>
										<!-- <td> Critical</td> -->
									<tr>
										<td style="background-color:#FADBD8">Business Critical</td>
										<td colspan="3" class="eml1" style="text-align:left;">Followed SOP/iDepot article and account level pop up box instructions while maintaining control of the call? </td>
										<td>
											<select class="form-control od_business_point business" name="data[control_call]" required>
												
												<option od_business_val=3 <?php echo $od_business['control_call'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option od_business_val=3 <?php echo $od_business['control_call'] == "No"?"selected":"";?> value="No">No</option>
												<option od_business_val=0 <?php echo $od_business['control_call'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td>3</td>
										
										<td colspan=2.5><input type="text" class="form-control" name="data[cmt7]" value="<?php echo $od_business['cmt7'] ?>"></td>
										
									
									</tr>
									<tr>
									<td style="background-color:#F9E79F">Compliance Critical</td>
										<td colspan="3" class="eml1"  style="text-align:left;">CCP noted appropriately? (Transaction History, Special Instructions, etc.)</td>
										<td>
											<select class="form-control od_business_point compliance" name="data[CCP_noted]" required>
												
												<option od_business_val=2 <?php echo $od_business['CCP_noted'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option od_business_val=2 <?php echo $od_business['CCP_noted'] == "No"?"selected":"";?> value="No">No</option>
												<option od_business_val=0 <?php echo $od_business['CCP_noted'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td>2</td>
										
										<td colspan=2.5><input type="text" class="form-control" name="data[cmt8]" value="<?php echo $od_business['cmt8'] ?>"></td>
									</tr>
									<tr>
										
										<td class="eml1" colspan="8" style="background-color:#3f5691; color: white;text-align: left;">MADE IT EASY FOR THE CUSTOMER</td>
										<td class="eml1" colspan=8 style="background-color:#8195c9"></td>
									</tr>
									
									<tr>
									<td style="background-color:#A9DFBF">Customer Critical</td>
										<td colspan="3" class="eml1" style="text-align:left;">CCP listened/comprehended and paraphrased, identified wants/needs, and gained agreement by asking open-ended follow up questions? Did the agent ask the customer 'Did I take care of everything for you today'?</td>
										<td>
											<select class="form-control od_business_point customer" id="" name="data[CCP_listened]" required>
												
												<option od_business_val=3 <?php echo $od_business['CCP_listened'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option od_business_val=3 <?php echo $od_business['CCP_listened'] == "No"?"selected":"";?> value="No">No</option>
												<option od_business_val=0 <?php echo $od_business['CCP_listened'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td>3</td>
										
										<td colspan=2.5><input type="text" class="form-control" name="data[cmt9]" value="<?php echo $od_business['cmt9'] ?>"></td>
									</tr>

								
									<tr>
									<td style="background-color:#F9E79F">Compliance Critical</td>
										<td colspan="3" class="eml1" style="text-align:left;">Verified information as appropriate to the call, proactively utilized CTI/Proper dispostion code used on the call.</td>
										<td>
											<select class="form-control od_business_point compliance" name="data[verified_information]" required>
												
												<option od_business_val=2 <?php echo $od_business['verified_information'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option od_business_val=2 <?php echo $od_business['verified_information'] == "No"?"selected":"";?> value="No">No</option>
												<option od_business_val=0 <?php echo $od_business['verified_information'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td>2</td>
										
										<td colspan=2.5><input type="text" class="form-control" name="data[cmt10]" value="<?php echo $od_business['cmt10'] ?>"></td>
										
									</tr>
									<tr>
									<td style="background-color:#FADBD8">Business Critical</td>
										<td colspan="3" class="eml1" style="text-align:left;">Did the CCP submit the proper forms based on the resolution needed and summarize the resolutions steps?  </td>
										<td>
											<select class="form-control od_business_point business" name="data[summarize_resolutions]" required>
												
												<option od_business_val=2 <?php echo $od_business['summarize_resolutions'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option od_business_val=2 <?php echo $od_business['summarize_resolutions'] == "No"?"selected":"";?> value="No">No</option>
												<option od_business_val=0 <?php echo $od_business['summarize_resolutions'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td>2</td>
										
										<td colspan=2.5><input type="text" class="form-control" name="data[cmt11]" value="<?php echo $od_business['cmt11'] ?>"></td>
										
									</tr>
									<tr>
									<td style="background-color:#FADBD8">Business Critical</td>
										<td colspan="3" class="eml1" style="text-align:left;">Did the CCP ask for the sale/microconversion?</td>
										<td>
											<select class="form-control od_business_point business" name="data[CCP_microconversion]" required>
												
												<option od_business_val=3 <?php echo $od_business['CCP_microconversion'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option od_business_val=3 <?php echo $od_business['CCP_microconversion'] == "No"?"selected":"";?> value="No">No</option>
												<option od_business_val=0 <?php echo $od_business['CCP_microconversion'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td>3</td>
										
										</td>
										<td colspan=2.5><input type="text" class="form-control" name="data[cmt12]" value="<?php echo $od_business['cmt12'] ?>"></td>
										
									</tr>
									<tr>
									<td style="background-color:#FADBD8">Business Critical</td>
										<td colspan="3" class="eml1" style="text-align:left;">Was the offer/microconversion accepted?</td>
										<td>
											<select class="form-control od_business_point business" name="data[offer_accepted]" required>
												
												<option od_business_val=2 <?php echo $od_business['offer_accepted'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option od_business_val=2 <?php echo $od_business['offer_accepted'] == "No"?"selected":"";?> value="No">No</option>
												<option od_business_val=0 <?php echo $od_business['offer_accepted'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td>2</td>
										
										</td>
										<td colspan=2.5><input type="text" class="form-control" name="data[cmt13]" value="<?php echo $od_business['cmt13'] ?>"></td>
										
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
										<td colspan="3"><textarea class="form-control"   name="data[call_summary]"><?php echo $od_business['call_summary'] ?></textarea></td>
										<td>Feedback:</td>
										<td colspan="4"><textarea class="form-control"   name="data[feedback]"><?php echo $od_business['feedback'] ?></textarea></td>
									</tr>
									
									<tr>
										<td colspan=2>Upload Files [m4a,mp4,mp3,wav]</td>
										<?php if($od_business_id==0){ ?>
											<td colspan=8><input type="file" multiple class="form-control" id="attach_file" name="attach_file[]"accept=".m4a,.mp4,.mp3,.wav,audio/*"></td>
										<?php }else{
											if($od_business['attach_file']!=''){ ?>
												<td colspan=8>
													<input type="file" multiple class="form-control"  id="attach_file" name="attach_file[]" accept=".m4a,.mp4,.mp3,.wav,audio/*"> 
													<?php $attach_file = explode(",",$od_business['attach_file']);
													 foreach($attach_file as $mp){ ?>
														<audio controls='' style="background-color:#607F93"> 
														  <source src="<?php echo base_url(); ?>qa_files/qa_od/<?php echo $mp; ?>" type="audio/ogg">
														  <source src="<?php echo base_url(); ?>qa_files/qa_od/<?php echo $mp; ?>" type="audio/mpeg">
														</audio> </br>
													 <?php } ?>
												</td>
										<?php }else{
												//echo '<td colspan=6><b>No Files</b></td>';
											echo '<td colspan=6>
													<input type="file" multiple class="form-control" id="attach_file" name="attach_file[]" accept=".m4a,.mp4,.mp3,.wav,audio/*">
													<b>No Files</b></td>';
											  }
										} ?>
									</tr>
									
									<?php if($od_business_id!=0){ ?>
										<tr><td colspan=2 style="font-size:16px; font-weight:bold">Agent Feedback Acceptance:</td><td colspan=8><?php echo $od_business['agnt_fd_acpt'] ?></td></tr>
										<tr><td colspan=2 style="font-size:16px; font-weight:bold">Agent Review:</td><td colspan=8><?php echo $od_business['agent_rvw_note'] ?></td></tr>
										<tr><td colspan=2 style="font-size:16px; font-weight:bold">Management Review:</td><td colspan=8><?php echo $od_business['mgnt_rvw_note'] ?></td></tr>
										<tr><td colspan=2 style="font-size:16px; font-weight:bold">Client Review:</td><td colspan=8><?php echo $od_business['client_rvw_note'] ?></td></tr>
										
										<tr><td colspan=2  style="font-size:16px">Your Review</td><td colspan=8><textarea class="form-control1" style="width:100%" id="note" name="note"  ></textarea></td></tr>
									<?php } ?>
									
									<?php 
									if($od_business_id==0){
										if(is_access_qa_module()==true || is_access_qa_operations_module()==true){ ?>
											<tr><td colspan=8><button class="btn btn-success waves-effect" type="submit" id="qaformsubmit" style="width:500px">SAVE</button></td></tr>
									<?php 
										} 
									}else{ 
										if(is_access_qa_module()==true || is_access_qa_operations_module()==true){
											if(is_available_qa_feedback($od_business['entry_date'],72) == true){ ?>
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
