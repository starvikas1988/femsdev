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

input[type='checkbox'] { 
margin-left:5px;
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
							<table class="table table-striped skt-table" style="width:100%;">
								<tbody>
									<tr>
										<td colspan="10" id="theader" style="font-size:30px">OFFICE DEPOT: CALL QUALITY FORM</td>
										<input type="hidden" name="audit_start_time" value="<?php echo CurrMySqlDate(); ?>">
									</tr>
									<?php
										if($od_voice_id==0){
											$auditorName = get_username();
											$auditDate = CurrDateMDY();
											$clDate_val='';
											$clreview_date='';
										}else{
											if($od_voice['entry_by']!=''){
												$auditorName = $od_voice['auditor_name'];
											}else{
												$auditorName = $od_voice['client_name'];
											}
											$auditDate = mysql2mmddyy($od_voice['audit_date']);
											$clDate_val = mysql2mmddyy($od_voice['call_date']);
											$clreview_date = mysql2mmddyy($od_voice['review_date']);
										}
									?>
									<tr>
										<td style="width:150px">Auditor Name:</td>
										<td style="width:400px"><input type="text" class="form-control" value="<?php echo $auditorName; ?>" disabled></td>
										<td >Audit Date:</td>
										<td colspan="2"><input type="text" class="form-control" value="<?php echo $auditDate; ?>" disabled></td>
										<td style="width:150px">Call Date:</td>
										<td colspan="3"><input type="text" class="form-control" id="call_date" name="call_date" value="<?php echo $clDate_val; ?>" disabled></td>
										</tr>
									<tr>
										<td style="width:150px">Call Duration:</td>
										<td style="width:400px"><input type="text" class="form-control" id="call_duration" name="data[call_duration]" value="<?php echo $od_voice['call_duration'] ?>" disabled ></td>
										
									
										<td>Agent:</td>
										<td colspan="2">
											<select class="form-control" id="agent_id" name="data[agent_id]" disabled >
												<option value="<?php echo $od_voice['agent_id'] ?>"><?php echo $od_voice['fname']." ".$od_voice['lname'] ?></option>
												
												<?php foreach($agentName as $row):  ?>
													<option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
												<?php endforeach; ?>
											</select>
										</td>
										<td>Fusion ID:</td>
										<td colspan="3"><input type="text" class="form-control" id="fusion_id" value="<?php echo $od_voice['fusion_id'] ?>" readonly ></td>
										</tr>
									<tr>
										<td>L1 Supervisor:</td>
										<td >
											<select class="form-control" id="tl_id" name="data[tl_id]" readonly>
												<option value="<?php echo $od_voice['tl_id'] ?>"><?php echo $od_voice['tl_name'] ?></option>
												<option value="">--Select--</option>
												<?php foreach($tlname as $tl): ?>
													<option value="<?php echo $tl['id']; ?>"><?php echo $tl['fname']." ".$tl['lname']; ?></option>
												<?php endforeach; ?>	
											</select>
										</td>
										<td>Review Date:</td>
										<td colspan="2"><input type="text" class="form-control" id="review_date" name="review_date" value="<?php echo $clreview_date; ?>" disabled></td>
									
									<td>Reviewed By:</td>
										<td colspan="3"><input type="text" class="form-control" name="data[reviewed]" value="<?php echo $od_voice['reviewed'] ?>" disabled ></td>
										</tr>
									<tr>
										<td>Customer Id:</td>
										<td><input type="text" class="form-control" name="data[customer_id]" value="<?php echo $od_voice['customer_id'] ?>" disabled ></td>
										<td>Session ID:</td>
										<td colspan="2">
											<input type="text" class="form-control" name="data[session_id]" value="<?php echo $od_voice['session_id'] ?>" disabled > 
										</td>	
										<td>LOB:</td>
									<td colspan="3">
											<select class="form-control" id="lob" name="data[lob]" disabled>
												<option value="<?php echo $od_voice['lob'] ?>"><?php echo $od_voice['lob'] ?></option>
												
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
											<select class="form-control" id="dis_cate" name="data[disposition_cate]" disabled>
												
												<option value="<?php echo $od_voice['disposition_cate'] ?>"><?php echo $od_voice['disposition_cate'] ?></option>
												<option value="">-Select-</option>
												<!-- <option  value="Blank">Blank </option>
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
												<option  value="Websupport">Websupport</option> -->
												<!-- <option  value="Other">Other</option> -->
											</select>
										</td>
										<td>Disposition Sub Category:</td>
										<td colspan="2">
											<select class="form-control" id="dis_sub_cate" name="data[disposition_sub_cate]" disabled>
												<option value="<?php echo $od_voice['disposition_sub_cate'] ?>"><?php echo $od_voice['disposition_sub_cate'] ?></option>
											</select>
										</td>
									<!-- </tr>
									<tr> -->
										<td>Audit Type:</td>
										<td colspan="3">
											<select class="form-control" id="audit_type" name="data[audit_type]" disabled>
												<option value="<?php echo $od_voice['audit_type'] ?>"><?php echo $od_voice['audit_type'] ?></option>
												
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
										</tr>
									<tr>
										<td class="auType">Auditor Type</td>
										<td class="auType">
											<select class="form-control" id="auditor_type" name="data[auditor_type]" disabled>
												
												<option value="Master">Master</option>
												<option value="Regular">Regular</option>
											</select>
										</td>
										
									</tr>
									<tr>
									<td>Workgroup:</td>
										<td>
											<select class="form-control"  name="data[workgroup]" disabled>
												<option value="<?php echo $od_voice['workgroup'] ?>"><?php echo $od_voice['workgroup'] ?></option>
												<!-- <option value="">-Select-</option> -->
												<option value="OD.COM ">OD.COM </option>
												<option value="WebSupport">WebSupport</option>
												<option value="ODPB">ODPB</option>
											</select>
										</td>
									<td>VOC:</td>
										<td colspan="2">
											<select class="form-control" id="voc" name="data[voc]" disabled>
												<option value="<?php echo $od_voice['voc'] ?>"><?php echo $od_voice['voc'] ?></option>
												
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
										<td>Customer VOC:</td>
										<td colspan="3">
											<select class="form-control" id="customer_voc" name="data[customer_voc]" disabled>
												<option value="<?php echo $od_voice['customer_voc'] ?>"><?php echo $od_voice['customer_voc'] ?></option>
												
												<option value="Detractor">Detractor</option>
												<option value="Passive">Passive</option>
												<option value="Promoter">Promoter</option>
											</select>
										</td>
									</tr>
									<tr>
										<td style="font-weight:bold; font-size:16px">Possible Score:</td>
										<td><input type="text" readonly id="od_voice_possible_score" name="data[possible_score]" class="form-control" style="font-weight:bold" value="<?php echo $od_voice['possible_score'] ?>"></td>
										<td style="font-weight:bold; font-size:16px">Earned Score:</td>
										<td colspan="2"><input type="text" readonly id="od_voice_earned_score" name="data[earned_score]" class="form-control" style="font-weight:bold" value="<?php echo $od_voice['earned_score'] ?>"></td>
										<td style="font-weight:bold; font-size:16px; text-align:right">Overall Score:</td>
										<td colspan="3"><input type="text" readonly id="od_voice_overall_score" name="data[overall_score]" class="form-control voice_fatal" style="font-weight:bold" value="<?php echo $od_voice['overall_score'] ?>"></td>
									</tr>
									<tr>
										<td></td><td></td><td></td><td></td><td></td><td></td>
										<td colspan="3"><input type="text" readonly id="voice_score" name="data[division_status]" class="form-control" style="font-weight:bold" value="<?php echo $od_voice['division_status'] ?>"></td>
									</tr>

									<tr style="height:25px; font-weight:bold; background-color:#85C1E9">
										<td colspan="2">PARAMETER</td>
										<td>RESPONSE</td>
										<td>POINTS</td>
										<td>RCA Level 1</td>
										<td>RCA Level 2</td>
										<td>RCA Level 3</td>
										<td>RCA Comments</td>
										<td>COMMENTS</td>
									</tr>
								
									<tr>
										<td class="eml1" colspan="10" style="background-color:#3f5691; color: white;text-align: left;">Connect with the Customer</td>
										
									</tr>
									<tr>
										<td class="eml1" colspan="2">Acknowledge the caller, matched style and pace/put customer at ease</td>
									<?php 
									// if($od_voice_id==0){
										
										$chk_array1="";
										$od_voice['check_list1'];
										$chk_array1=explode(',', $od_voice['check_list1']);
										
										//}

									?>

										<td rowspan="4">
											<select class="form-control od_voice_point customer" name="data[acknowledge_the_caller]" disabled>
												
												<option od_voice_val=1 <?php echo $od_voice['acknowledge_the_caller'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option od_voice_val=1 <?php echo $od_voice['acknowledge_the_caller'] == "No"?"selected":"";?> value="No">No</option>
												<option od_voice_val=0 <?php echo $od_voice['acknowledge_the_caller'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td rowspan="4">1</td>
										<td rowspan="4">
										<select class="form-control  " name="data[acknowledge_rcal1]" id="ackno_rcal" disabled>
												<option value="">Select</option>
												<option <?php echo $od_voice['acknowledge_rcal1'] == "System"?"selected":"";?> value="System">System</option>
												<option <?php echo $od_voice['acknowledge_rcal1'] == "Ability"?"selected":"";?> value="Ability">Ability</option>
												<option <?php echo $od_voice['acknowledge_rcal1'] == "Will"?"selected":"";?> value="Will">Will</option>
												<option <?php echo $od_voice['acknowledge_rcal1'] == "Health"?"selected":"";?> value="Health">Health</option>
												<option <?php echo $od_voice['acknowledge_rcal1'] == "Capacity Issue"?"selected":"";?> value="Capacity Issue">Capacity Issue</option>
												<option <?php echo $od_voice['acknowledge_rcal1'] == "Environment"?"selected":"";?> value="Environment">Environment</option>
											</select>
										</td>
										
										<td rowspan="4">
										<select name="data[acknowledge_rcal2]" class="form-control" id="ackno_rcal2"  disabled>
											<option value="<?php echo $od_voice['acknowledge_rcal2'] ?>"><?php echo $od_voice['acknowledge_rcal2'] ?></option>
										</select>
										</td>
										<td rowspan="4">
										<select name="data[acknowledge_rcal3]" class="form-control" id="ackno_rcal3"  disabled>
											<option value="<?php echo $od_voice['acknowledge_rcal3'] ?>"><?php echo $od_voice['acknowledge_rcal3'] ?></option>
										</select>
										</td rowspan="4">
										<td rowspan="4"><input type="text" class="form-control" name="data[acknowledge_rcal_cmt]" value="<?php echo $od_voice['acknowledge_rcal_cmt'] ?>" disabled></td>
										<td rowspan="4"><input type="text" class="form-control" name="data[cmt1]" value="<?php echo $od_voice['cmt1'] ?>" disabled></td>
										
										</tr>

									<tr>
										<td class="eml1">Use of caller's first Name</td><td><input type="checkbox" name="check_list1[]" <?php if(in_array("Use_of_callers_first_Name", $chk_array1)) { echo 'checked'; }?> value="Use_of_callers_first_Name" disabled></td>
										</tr>

									<tr>
										<td class="eml1" >Branding and Closing Spiel</td><td><input type="checkbox" name="check_list1[]" <?php if(in_array("Branding_and_Closing_Spiel", $chk_array1)) { echo 'checked'; }?> value="Branding_and_Closing_Spiel" disabled></td>
										</tr>

									<tr>
										<td class="eml1" >Thank as Rewards Member</td><td><input type="checkbox" name="check_list1[]" <?php if(in_array("Thank_as_Rewards_Member", $chk_array1)) { echo 'checked'; }?> value="Thank_as_Rewards_Member" disabled></td>
										
										
									</tr>

									<tr>
										<td class="eml1" style="text-align: left;" colspan="2">Made the customer feel important and top priority</td>
										<td>
											<select class="form-control od_voice_point customer" name="data[made_the_customer]" disabled>
												
												<option od_voice_val=1 <?php echo $od_voice['made_the_customer'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option od_voice_val=1 <?php echo $od_voice['made_the_customer'] == "No"?"selected":"";?> value="No">No</option>
												<option od_voice_val=0 <?php echo $od_voice['made_the_customer'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td>1</td>
										<td>
										<select class="form-control  " name="data[customer_rcal1]" id="custo_rca" disabled>
												<option value="">Select</option>
												<option <?php echo $od_voice['customer_rcal1'] == "System"?"selected":"";?> value="System">System</option>
												<option <?php echo $od_voice['customer_rcal1'] == "Ability"?"selected":"";?> value="Ability">Ability</option>
												<option <?php echo $od_voice['customer_rcal1'] == "Will"?"selected":"";?> value="Will">Will</option>
												<option <?php echo $od_voice['customer_rcal1'] == "Health"?"selected":"";?> value="Health">Health</option>
												<option <?php echo $od_voice['customer_rcal1'] == "Capacity Issue"?"selected":"";?> value="Capacity Issue">Capacity Issue</option>
												<option <?php echo $od_voice['customer_rcal1'] == "Environment"?"selected":"";?> value="Environment">Environment</option>
											</select>
										</td>
										
										<td>
										<select name="data[customer_rcal2]" class="form-control" id="custo_rca2"  disabled>
											<option value="<?php echo $od_voice['customer_rcal2'] ?>"><?php echo $od_voice['customer_rcal2'] ?></option>
										</select>
										</td>
										<td>
										<select name="data[customer_rcal3]" class="form-control" id="custo_rca3"  disabled>
											<option value="<?php echo $od_voice['customer_rcal3'] ?>"><?php echo $od_voice['customer_rcal3'] ?></option>
										</select>
										</td>
										<td><input type="text" class="form-control" name="data[customer_rcal_cmt]" value="<?php echo $od_voice['customer_rcal_cmt'] ?>" disabled></td>
										<td colspan=2.5><input type="text" class="form-control" name="data[cmt2]" value="<?php echo $od_voice['cmt2'] ?>" disabled></td>
										
									</tr>
									<?php 
										$chk_array2="";
										$od_voice['check_list2'];
										$chk_array2=explode(',', $od_voice['check_list2']);
										
										
									?>
									<tr>
										<td class="eml1" rowspan="" colspan="2">Appropriate and sincere use of empathy</td>
										<td rowspan="3">
											<select class="form-control od_voice_point customer" name="data[appropriate_and_sincere]" disabled>
												
												<option od_voice_val=1 <?php echo $od_voice['appropriate_and_sincere'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option od_voice_val=1 <?php echo $od_voice['appropriate_and_sincere'] == "No"?"selected":"";?> value="No">No</option>
												<option od_voice_val=0 <?php echo $od_voice['appropriate_and_sincere'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td rowspan="3">1</td>
										<td rowspan="3">
										<select class="form-control  " name="data[appropriate_rcal1]" id="appro_rcal" disabled>
												<option value="">Select</option>
												<option <?php echo $od_voice['appropriate_rcal1'] == "System"?"selected":"";?> value="System">System</option>
												<option <?php echo $od_voice['appropriate_rcal1'] == "Ability"?"selected":"";?> value="Ability">Ability</option>
												<option <?php echo $od_voice['appropriate_rcal1'] == "Will"?"selected":"";?> value="Will">Will</option>
												<option <?php echo $od_voice['appropriate_rcal1'] == "Health"?"selected":"";?> value="Health">Health</option>
												<option <?php echo $od_voice['appropriate_rcal1'] == "Capacity Issue"?"selected":"";?> value="Capacity Issue">Capacity Issue</option>
												<option <?php echo $od_voice['appropriate_rcal1'] == "Environment"?"selected":"";?> value="Environment">Environment</option>
											</select>
										</td>
										
										<td rowspan="3">
										<select name="data[appropriate_rcal2]" class="form-control" id="appro_rcal2" disabled >
											<option value="<?php echo $od_voice['appropriate_rcal2'] ?>"><?php echo $od_voice['appropriate_rcal2'] ?></option>
										</select>
										</td>
										<td rowspan="3">
										<select name="data[appropriate_rcal3]" class="form-control" id="appro_rcal3"  disabled>
											<option value="<?php echo $od_voice['appropriate_rcal3'] ?>"><?php echo $od_voice['appropriate_rcal3'] ?></option>
										</select>
										</td>
										<td rowspan="3"><input type="text" class="form-control" name="data[appropriate_rcal_cmt]" value="<?php echo $od_voice['appropriate_rcal_cmt'] ?>" disabled></td>
										<td rowspan="3"><input type="text" class="form-control" name="data[cmt3]" value="<?php echo $od_voice['cmt3'] ?>" disabled></td>
										</tr>

									<tr>
										<td class="eml1" >No Empathy / apology statement entire call</td><td><input type="checkbox" name="check_list2[]" <?php if(in_array("No_Empathy_apology_statement_entire_call", $chk_array2)) { echo 'checked'; }?> value="No_Empathy_apology_statement_entire_call" disabled></td>
										</tr>

									<tr>

										<td class="eml1">Poor Delivery of empathy</td><td><input type="checkbox" name="check_list2[]" <?php if(in_array("Poor_Delivery_of_empathy", $chk_array2)) { echo 'checked'; }?> value="Poor_Delivery_of_empathy" disabled></td>

										
									</tr>

									<tr>
										<td class="eml1" style="text-align:left;" colspan="2">Customer clearly understood the CSR, agent used proper English (no OD jargon)</td>
										<td>
											<select class="form-control od_voice_point customer" name="data[customer_clearly_understood]" disabled>
												
												<option od_voice_val=1 <?php echo $od_voice['customer_clearly_understood'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option od_voice_val=1 <?php echo $od_voice['customer_clearly_understood'] == "No"?"selected":"";?> value="No">No</option>
												<option od_voice_val=0 <?php echo $od_voice['customer_clearly_understood'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td>1</td>
										<td>
										<select class="form-control  " name="data[understood_rcal1]" id="under_rcal" disabled>
												<option value="">Select</option>
												<option <?php echo $od_voice['understood_rcal1'] == "System"?"selected":"";?> value="System">System</option>
												<option <?php echo $od_voice['understood_rcal1'] == "Ability"?"selected":"";?> value="Ability">Ability</option>
												<option <?php echo $od_voice['understood_rcal1'] == "Will"?"selected":"";?> value="Will">Will</option>
												<option <?php echo $od_voice['understood_rcal1'] == "Health"?"selected":"";?> value="Health">Health</option>
												<option <?php echo $od_voice['understood_rcal1'] == "Capacity Issue"?"selected":"";?> value="Capacity Issue">Capacity Issue</option>
												<option <?php echo $od_voice['understood_rcal1'] == "Environment"?"selected":"";?> value="Environment">Environment</option>
											</select>
										</td>
										
										<td>
										<select name="data[understood_rcal2]" class="form-control" id="under_rcal2"  disabled>
											<option value="<?php echo $od_voice['understood_rcal2'] ?>"><?php echo $od_voice['understood_rcal2'] ?></option>
										</select>
										</td>
										<td>
										<select name="data[understood_rcal3]" class="form-control" id="under_rcal3"  disabled>
											<option value="<?php echo $od_voice['understood_rcal3'] ?>"><?php echo $od_voice['understood_rcal3'] ?></option>
										</select>
										</td>
										<td><input type="text" class="form-control" name="data[understood_rcal_cmt]" value="<?php echo $od_voice['understood_rcal_cmt'] ?>" disabled></td>
										<td colspan=2.5><input type="text" class="form-control" name="data[cmt4]" value="<?php echo $od_voice['cmt4'] ?>" disabled></td>
									</tr>

									<tr>
										<td class="eml1" colspan="10" style="background-color:#3f5691; color: white;text-align: left;">Did the CCP Resolve/Recommend a solution for the customer?</td>
										
									</tr>
									<tr>
										<td class="eml1" style="text-align:left;" colspan="2">CCP recognized Customer contacted us multiple times regarding the same issue and escalated to Supervisor/Team Lead as appropriate? </td>
										<td>
											<select class="form-control od_voice_point business" name="data[recognized_customer_contacted]" disabled>
												<!-- id="voice_FA" -->
												<option od_voice_val=2 <?php echo $od_voice['recognized_customer_contacted'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option od_voice_val=2 <?php echo $od_voice['recognized_customer_contacted'] == "No"?"selected":"";?> value="No">No</option>
												<option od_voice_val=0 <?php echo $od_voice['recognized_customer_contacted'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td>2</td>
										<td>
										<select class="form-control  " name="data[recognized_rcal1]" id="recog_rcal" disabled>
												<option value="">Select</option>
												<option <?php echo $od_voice['recognized_rcal1'] == "System"?"selected":"";?> value="System">System</option>
												<option <?php echo $od_voice['recognized_rcal1'] == "Ability"?"selected":"";?> value="Ability">Ability</option>
												<option <?php echo $od_voice['recognized_rcal1'] == "Will"?"selected":"";?> value="Will">Will</option>
												<option <?php echo $od_voice['recognized_rcal1'] == "Health"?"selected":"";?> value="Health">Health</option>
												<option <?php echo $od_voice['recognized_rcal1'] == "Capacity Issue"?"selected":"";?> value="Capacity Issue">Capacity Issue</option>
												<option <?php echo $od_voice['recognized_rcal1'] == "Environment"?"selected":"";?> value="Environment">Environment</option>
											</select>
										</td>
										
										<td>
										<select name="data[recognized_rcal2]" class="form-control" id="recog_rcal2"  disabled>
											<option value="<?php echo $od_voice['recognized_rcal2'] ?>"><?php echo $od_voice['recognized_rcal2'] ?></option>
										</select>
										</td>
										<td>
										<select name="data[recognized_rcal3]" class="form-control" id="recog_rcal3"  disabled>
											<option value="<?php echo $od_voice['recognized_rcal3'] ?>"><?php echo $od_voice['recognized_rcal3'] ?></option>
										</select>
										</td>
										<td><input type="text" class="form-control" name="data[recognized_rcal_cmt]" value="<?php echo $od_voice['recognized_rcal_cmt'] ?>" disabled></td>
										<td colspan=2.5><input type="text" class="form-control" name="data[cmt5]" value="<?php echo $od_voice['cmt5'] ?>" disabled></td>
									</tr>
									<tr>
										<td class="eml1"  style="text-align:left;" colspan="2">Verified line item, quantity, price, total and delivery info AS NEEDED to place the order/return</td>
										<td>
											<select class="form-control od_voice_point compliance" name="data[verified_line_item]" disabled>
												
												<option od_voice_val=1 <?php echo $od_voice['verified_line_item'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option od_voice_val=1 <?php echo $od_voice['verified_line_item'] == "No"?"selected":"";?> value="No">No</option>
												<option od_voice_val=0 <?php echo $od_voice['verified_line_item'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td>1</td>
										<td>
										<select class="form-control  " name="data[verified_rcal1]" id="verified_rcal" disabled>
												<option value="">Select</option>
												<option <?php echo $od_voice['verified_rcal1'] == "System"?"selected":"";?> value="System">System</option>
												<option <?php echo $od_voice['verified_rcal1'] == "Ability"?"selected":"";?> value="Ability">Ability</option>
												<option <?php echo $od_voice['verified_rcal1'] == "Will"?"selected":"";?> value="Will">Will</option>
												<option <?php echo $od_voice['verified_rcal1'] == "Health"?"selected":"";?> value="Health">Health</option>
												<option <?php echo $od_voice['verified_rcal1'] == "Capacity Issue"?"selected":"";?> value="Capacity Issue">Capacity Issue</option>
												<option <?php echo $od_voice['verified_rcal1'] == "Environment"?"selected":"";?> value="Environment">Environment</option>
											</select>
										</td>
										
										<td>
										<select name="data[verified_rcal2]" class="form-control" id="verified_rcal2"  disabled>
											<option value="<?php echo $od_voice['verified_rcal2'] ?>"><?php echo $od_voice['verified_rcal2'] ?></option>
										</select>
										</td>
										<td>
										<select name="data[verified_rcal3]" class="form-control" id="verified_rcal3"  >
											<option value="<?php echo $od_voice['verified_rcal3'] ?>"><?php echo $od_voice['verified_rcal3'] ?></option>
										</select>
										</td>
										<td><input type="text" class="form-control" name="data[verified_rcal_cmt]" value="<?php echo $od_voice['verified_rcal_cmt'] ?>" disabled></td>
										<td colspan=2.5><input type="text" class="form-control" name="data[cmt6]" value="<?php echo $od_voice['cmt6'] ?>" disabled></td>
										<!-- <td> Critical</td> -->
									</tr>
									<?php 
										$chk_array3="";
										$od_voice['check_list3'];
										$chk_array3=explode(',', $od_voice['check_list3']);
										
										
									?>
									<tr>
										<td class="eml1" colspan="2">Followed SOP/iDepot article and account level pop up box instructions while maintaining control of the call? </td>

										<td rowspan="7">
											<select class="form-control od_voice_point business" name="data[idepot_article_and]" disabled>
												
												<option od_voice_val=3 <?php echo $od_voice['idepot_article_and'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option od_voice_val=3 <?php echo $od_voice['idepot_article_and'] == "No"?"selected":"";?> value="No">No</option>
												<option od_voice_val=0 <?php echo $od_voice['idepot_article_and'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td rowspan="7">3</td>
										<td rowspan="7">
										<select class="form-control  " name="data[idepot_rcal1]" id="idepot_rcal" disabled>
												<option value="">Select</option>
												<option <?php echo $od_voice['idepot_rcal1'] == "System"?"selected":"";?> value="System">System</option>
												<option <?php echo $od_voice['idepot_rcal1'] == "Ability"?"selected":"";?> value="Ability">Ability</option>
												<option <?php echo $od_voice['idepot_rcal1'] == "Will"?"selected":"";?> value="Will">Will</option>
												<option <?php echo $od_voice['idepot_rcal1'] == "Health"?"selected":"";?> value="Health">Health</option>
												<option <?php echo $od_voice['idepot_rcal1'] == "Capacity Issue"?"selected":"";?> value="Capacity Issue">Capacity Issue</option>
												<option <?php echo $od_voice['idepot_rcal1'] == "Environment"?"selected":"";?> value="Environment">Environment</option>
											</select>
										</td>
										
										<td rowspan="7">
										<select name="data[idepot_rcal2]" class="form-control" id="idepot_rcal2"  disabled>
											<option value="<?php echo $od_voice['idepot_rcal2'] ?>"><?php echo $od_voice['idepot_rcal2'] ?></option>
										</select>
										</td>
										<td rowspan="7">
										<select name="data[idepot_rcal3]" class="form-control" id="idepot_rcal3"  disabled>
											<option value="<?php echo $od_voice['idepot_rcal3'] ?>"><?php echo $od_voice['idepot_rcal3'] ?></option>
										</select>
										</td>
										<td rowspan="7"><input type="text" class="form-control" name="data[idepot_rcal_cmt]" value="<?php echo $od_voice['idepot_rcal_cmt'] ?>" disabled></td>
										<td rowspan="7"><input type="text" class="form-control" name="data[cmt7]" value="<?php echo $od_voice['cmt7'] ?>" disabled></td>
									</tr>
									<tr>

										<td class="eml1" >RESOLUTION- Wrong Resolution</td><td><input type="checkbox" name="check_list3[]" <?php if(in_array("Wrong_Resolution", $chk_array3)) { echo 'checked'; }?> value="Wrong_Resolution" disabled></td>
											</tr>
									<tr>
										<td class="eml1" >RESOLUTION- Incomplete Resolution</td><td><input type="checkbox" name="check_list3[]" <?php if(in_array("Incomplete_Resolution", $chk_array3)) { echo 'checked'; }?>  value="Incomplete_Resolution" disabled></td>
											</tr>
									<tr>
										<td class="eml1">INFORMATION- No Info</td><td><input type="checkbox" name="check_list3[]" <?php if(in_array("No_Info", $chk_array3)) { echo 'checked'; }?> value="No_Info" disabled></td>
											</tr>
									<tr>
										<td class="eml1" >INFORMATION- Wrong Info</td><td><input type="checkbox" name="check_list3[]" <?php if(in_array("Wrong_Info", $chk_array3)) { echo 'checked'; }?> value="Wrong_Info" disabled></td>
											</tr>
									<tr>
										<td class="eml1" >INFORMATION- Incomplete Info</td><td><input type="checkbox" name="check_list3[]" <?php if(in_array("Incomplete_Info", $chk_array3)) { echo 'checked'; }?> value="Incomplete_Info" disabled></td>
											</tr>
									<tr>
										<td class="eml1">OTHER- Not using Privacy Shield</td><td><input type="checkbox" name="check_list3[]" <?php if(in_array("Not_using_Privacy_Shield", $chk_array3)) { echo 'checked'; }?> value="Not_using_Privacy_Shield" disabled></td>

										
										
									</tr>
									<?php 
										$chk_array4="";
										$od_voice['check_list4'];
										$chk_array4=explode(',', $od_voice['check_list4']);
										
										
									?>
									<tr>
										<td class="eml1" colspan="2">CCP noted appropriately? (Transaction History, Special Instructions, etc.)</td>

										<td rowspan="4">
											<select class="form-control od_voice_point compliance" id="" name="data[noted_appropriately]" disabled>
												
												<option od_voice_val=2 <?php echo $od_voice['noted_appropriately'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option od_voice_val=2 <?php echo $od_voice['noted_appropriately'] == "No"?"selected":"";?> value="No">No</option>
												<option od_voice_val=0 <?php echo $od_voice['noted_appropriately'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td rowspan="4">2</td>
										<td rowspan="4">
										<select class="form-control  " name="data[appropriately_rcal1]" id="appropriat_rcal" disabled>
												<option value="">Select</option>
												<option <?php echo $od_voice['appropriately_rcal1'] == "System"?"selected":"";?> value="System">System</option>
												<option <?php echo $od_voice['appropriately_rcal1'] == "Ability"?"selected":"";?> value="Ability">Ability</option>
												<option <?php echo $od_voice['appropriately_rcal1'] == "Will"?"selected":"";?> value="Will">Will</option>
												<option <?php echo $od_voice['appropriately_rcal1'] == "Health"?"selected":"";?> value="Health">Health</option>
												<option <?php echo $od_voice['appropriately_rcal1'] == "Capacity Issue"?"selected":"";?> value="Capacity Issue">Capacity Issue</option>
												<option <?php echo $od_voice['appropriately_rcal1'] == "Environment"?"selected":"";?> value="Environment">Environment</option>
											</select>
										</td>
										
										<td rowspan="4">
										<select name="data[appropriately_rcal2]" class="form-control" id="appropriat_rcal2" disabled >
											<option value="<?php echo $od_voice['appropriately_rcal2'] ?>"><?php echo $od_voice['appropriately_rcal2'] ?></option>
										</select>
										</td>
										<td rowspan="4">
										<select name="data[appropriately_rcal3]" class="form-control" id="appropriat_rcal3"  disabled>
											<option value="<?php echo $od_voice['appropriately_rcal3'] ?>"><?php echo $od_voice['appropriately_rcal3'] ?></option>
										</select>
										</td>
										<td rowspan="4"><input type="text" class="form-control" name="data[appropriately_rcal_cmt]" value="<?php echo $od_voice['appropriately_rcal_cmt'] ?>" disabled></td>
										<td rowspan="4"><input type="text" class="form-control" name="data[cmt8]" value="<?php echo $od_voice['cmt8'] ?>" disabled></td>
										</tr>

									<tr>

										<td class="eml1">No Notes</td><td><input type="checkbox" name="check_list4[]" <?php if(in_array("No_Notes", $chk_array4)) { echo 'checked'; }?> value="No_Notes" disabled></td>
										</tr>

									<tr>
										<td class="eml1" >Incomplete Notes</td><td><input type="checkbox" name="check_list4[]" <?php if(in_array("Incomplete_Notes", $chk_array4)) { echo 'checked'; }?> value="Incomplete_Notes" disabled></td>
										</tr>

									<tr>
										<td class="eml1">Wrong Notes</td><td><input type="checkbox" name="check_list4[]" <?php if(in_array("Wrong_Notes", $chk_array4)) { echo 'checked'; }?> value="Wrong_Notes" disabled></td>

										
									</tr>

									<tr>
										<td class="eml1" colspan="10" style="background-color:#3f5691; color: white;text-align: left;">Made it easy for the customer</td>
									
									</tr>
									<tr>
										<td class="eml1" style="text-align:left;" colspan="2">Listened and paraphrased, identified wants/needs and gained agreement by asking open-ended follow up questions.</td>
										<td>
											<select class="form-control od_voice_point customer" name="data[listened_and_paraphrased]" disabled>
												
												<option od_voice_val=1 <?php echo $od_voice['listened_and_paraphrased'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option od_voice_val=1 <?php echo $od_voice['listened_and_paraphrased'] == "No"?"selected":"";?> value="No">No</option>
												<option od_voice_val=0 <?php echo $od_voice['listened_and_paraphrased'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td>1</td>
										<td>
										<select class="form-control  " name="data[paraphrased_rcal1]" id="parap_rcal" disabled>
												<option value="">Select</option>
												<option <?php echo $od_voice['paraphrased_rcal1'] == "System"?"selected":"";?> value="System">System</option>
												<option <?php echo $od_voice['paraphrased_rcal1'] == "Ability"?"selected":"";?> value="Ability">Ability</option>
												<option <?php echo $od_voice['paraphrased_rcal1'] == "Will"?"selected":"";?> value="Will">Will</option>
												<option <?php echo $od_voice['paraphrased_rcal1'] == "Health"?"selected":"";?> value="Health">Health</option>
												<option <?php echo $od_voice['paraphrased_rcal1'] == "Capacity Issue"?"selected":"";?> value="Capacity Issue">Capacity Issue</option>
												<option <?php echo $od_voice['paraphrased_rcal1'] == "Environment"?"selected":"";?> value="Environment">Environment</option>
											</select>
										</td>
										
										<td>
										<select name="data[paraphrased_rcal2]" class="form-control" id="parap_rcal2"  disabled>
											<option value="<?php echo $od_voice['paraphrased_rcal2'] ?>"><?php echo $od_voice['paraphrased_rcal2'] ?></option>
										</select>
										</td>
										<td>
										<select name="data[paraphrased_rcal3]" class="form-control" id="parap_rcal3"  disabled>
											<option value="<?php echo $od_voice['paraphrased_rcal3'] ?>"><?php echo $od_voice['paraphrased_rcal3'] ?></option>
										</select>
										</td>
										<td><input type="text" class="form-control" name="data[paraphrased_rcal_cmt]" value="<?php echo $od_voice['paraphrased_rcal_cmt'] ?>" disabled></td>
										<td colspan=2.5><input type="text" class="form-control" name="data[cmt9]" value="<?php echo $od_voice['cmt9'] ?>" disabled></td>
										
									</tr>
									<tr>
										<td class="eml1" style="text-align:left;" colspan="2">Verified information as appropriate to the call, proactively utilized CTI</td>
										<td>
											<select class="form-control od_voice_point compliance" name="data[verified_information]" disabled>
												
												<option od_voice_val=1 <?php echo $od_voice['verified_information'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option od_voice_val=1 <?php echo $od_voice['verified_information'] == "No"?"selected":"";?> value="No">No</option>
												<option od_voice_val=0 <?php echo $od_voice['verified_information'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td>1</td>
										<td>
										<select class="form-control  " name="data[information_rcal1]" id="inform_rcal" disabled>
												<option value="">Select</option>
												<option <?php echo $od_voice['information_rcal1'] == "System"?"selected":"";?> value="System">System</option>
												<option <?php echo $od_voice['information_rcal1'] == "Ability"?"selected":"";?> value="Ability">Ability</option>
												<option <?php echo $od_voice['information_rcal1'] == "Will"?"selected":"";?> value="Will">Will</option>
												<option <?php echo $od_voice['information_rcal1'] == "Health"?"selected":"";?> value="Health">Health</option>
												<option <?php echo $od_voice['information_rcal1'] == "Capacity Issue"?"selected":"";?> value="Capacity Issue">Capacity Issue</option>
												<option <?php echo $od_voice['information_rcal1'] == "Environment"?"selected":"";?> value="Environment">Environment</option>
											</select>
										</td>
										
										<td>
										<select name="data[information_rcal2]" class="form-control" id="inform_rcal2" disabled >
											<option value="<?php echo $od_voice['information_rcal2'] ?>"><?php echo $od_voice['information_rcal2'] ?></option>
										</select>
										</td>
										<td>
										<select name="data[information_rcal3]" class="form-control" id="inform_rcal3" disabled >
											<option value="<?php echo $od_voice['information_rcal3'] ?>"><?php echo $od_voice['information_rcal3'] ?></option>
										</select>
										</td>
										<td><input type="text" class="form-control" name="data[information_rcal_cmt]" value="<?php echo $od_voice['information_rcal_cmt'] ?>" disabled></td>
										<td colspan=2.5><input type="text" class="form-control" name="data[cmt10]" value="<?php echo $od_voice['cmt10'] ?>" disabled></td>
										
									</tr>
									<tr>
										<td class="eml1" style="text-align:left;" colspan="2">Did the CCP submit the proper forms based on the resolution needed and summarize the resolutions steps? </td>
										<td>
											<select class="form-control od_voice_point business" name="data[submit_the_proper_forms]" disabled>
												
												<option od_voice_val=2 <?php echo $od_voice['submit_the_proper_forms'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option od_voice_val=2 <?php echo $od_voice['submit_the_proper_forms'] == "No"?"selected":"";?> value="No">No</option>
												<option od_voice_val=0 <?php echo $od_voice['submit_the_proper_forms'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td>2</td>
										<td>
										<select class="form-control  " name="data[submit_rcal1]" id="submit_rcal" disabled>
												<option value="">Select</option>
												<option <?php echo $od_voice['submit_rcal1'] == "System"?"selected":"";?> value="System">System</option>
												<option <?php echo $od_voice['submit_rcal1'] == "Ability"?"selected":"";?> value="Ability">Ability</option>
												<option <?php echo $od_voice['submit_rcal1'] == "Will"?"selected":"";?> value="Will">Will</option>
												<option <?php echo $od_voice['submit_rcal1'] == "Health"?"selected":"";?> value="Health">Health</option>
												<option <?php echo $od_voice['submit_rcal1'] == "Capacity Issue"?"selected":"";?> value="Capacity Issue">Capacity Issue</option>
												<option <?php echo $od_voice['submit_rcal1'] == "Environment"?"selected":"";?> value="Environment">Environment</option>
											</select>
										</td>
										
										<td>
										<select name="data[submit_rcal2]" class="form-control" id="submit_rcal2"  disabled>
											<option value="<?php echo $od_voice['submit_rcal2'] ?>"><?php echo $od_voice['submit_rcal2'] ?></option>
										</select>
										</td>
										<td>
										<select name="data[submit_rcal3]" class="form-control" id="submit_rcal3"  disabled>
											<option value="<?php echo $od_voice['submit_rcal3'] ?>"><?php echo $od_voice['submit_rcal3'] ?></option>
										</select>
										</td>
										<td><input type="text" class="form-control" name="data[submit_rcal_cmt]" value="<?php echo $od_voice['submit_rcal_cmt'] ?>" disabled></td>
										</td>
										<td colspan=2.5><input type="text" class="form-control" name="data[cmt11]" value="<?php echo $od_voice['cmt11'] ?>" disabled></td>
										
									</tr>
									<?php 
										$chk_array5="";
										$od_voice['check_list5'];
										$chk_array5=explode(',', $od_voice['check_list5']);
										
										
									?>
									<tr>
										<td class="eml1" colspan="2">Was the proper dispostion code used on the call</td>

										<td rowspan="4">
											<select class="form-control od_voice_point compliance" name="data[proper_dispostion_code]" disabled>
												
												<option od_voice_val=1 <?php echo $od_voice['proper_dispostion_code'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option od_voice_val=1 <?php echo $od_voice['proper_dispostion_code'] == "No"?"selected":"";?> value="No">No</option>
												<option od_voice_val=0 <?php echo $od_voice['proper_dispostion_code'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td rowspan="4">1</td>
										<td rowspan="4">
										<select class="form-control  " name="data[dispostion_rcal1]" id="dispo_rcal" disabled>
												<option value="">Select</option>
												<option <?php echo $od_voice['dispostion_rcal1'] == "System"?"selected":"";?> value="System">System</option>
												<option <?php echo $od_voice['dispostion_rcal1'] == "Ability"?"selected":"";?> value="Ability">Ability</option>
												<option <?php echo $od_voice['dispostion_rcal1'] == "Will"?"selected":"";?> value="Will">Will</option>
												<option <?php echo $od_voice['dispostion_rcal1'] == "Health"?"selected":"";?> value="Health">Health</option>
												<option <?php echo $od_voice['dispostion_rcal1'] == "Capacity Issue"?"selected":"";?> value="Capacity Issue">Capacity Issue</option>
												<option <?php echo $od_voice['dispostion_rcal1'] == "Environment"?"selected":"";?> value="Environment">Environment</option>
											</select>
										</td>
										
										<td rowspan="4">
										<select name="data[dispostion_rcal2]" class="form-control" id="dispo_rcal2"  disabled>
											<option value="<?php echo $od_voice['dispostion_rcal2'] ?>"><?php echo $od_voice['dispostion_rcal2'] ?></option>
										</select>
										</td>
										<td rowspan="4">
										<select name="data[dispostion_rcal3]" class="form-control" id="dispo_rcal3"  disabled>
											<option value="<?php echo $od_voice['dispostion_rcal3'] ?>"><?php echo $od_voice['dispostion_rcal3'] ?></option>
										</select>
										</td>
										<td rowspan="4"><input type="text" class="form-control" name="data[dispostion_rcal_cmt]" value="<?php echo $od_voice['dispostion_rcal_cmt'] ?>" disabled></td>
										<td rowspan="4"><input type="text" class="form-control" name="data[cmt12]" value="<?php echo $od_voice['cmt12'] ?>" disabled></td>
									</tr>
									<tr>

										<td class="eml1" >Related, but not accurate</td><td><input type="checkbox" name="check_list5[]" <?php if(in_array("Related_but_not_accurate", $chk_array5)) { echo 'checked'; }?> value="Related_but_not_accurate" disabled></td>
										</tr>
									<tr>
										<td class="eml1" >Based on Resolution instead of Call Concern</td><td><input type="checkbox" name="check_list5[]" <?php if(in_array("Based_on_Resolution_instead_of_Call_Concern", $chk_array5)) { echo 'checked'; }?> value="Based_on_Resolution_instead_of_Call_Concern" disabled></td>
										</tr>
									<tr>
										<td class="eml1">Irrelevant / Entirely Different Dispo</td><td><input type="checkbox" name="check_list5[]" <?php if(in_array("Irrelevant_Entirely_Different_Dispo", $chk_array5)) { echo 'checked'; }?> value="Irrelevant_Entirely_Different_Dispo" disabled></td>
										</tr>
									
									<tr>
										<td class="eml1" style="text-align:left;" colspan="2">Please provide the type of call (Sales or Service)</td>
										<td>
											<select class="form-control" name="data[please_provide_type]" disabled>
												
												<option <?php echo $od_voice['please_provide_type'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option <?php echo $od_voice['please_provide_type'] == "No"?"selected":"";?> value="No">No</option>
												<option <?php echo $od_voice['please_provide_type'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td></td>
										<td>
										<select class="form-control  " name="data[please_rcal1]" id="ple_rcal" disabled>
												<option value="">Select</option>
												<option <?php echo $od_voice['please_rcal1'] == "System"?"selected":"";?> value="System">System</option>
												<option <?php echo $od_voice['please_rcal1'] == "Ability"?"selected":"";?> value="Ability">Ability</option>
												<option <?php echo $od_voice['please_rcal1'] == "Will"?"selected":"";?> value="Will">Will</option>
												<option <?php echo $od_voice['please_rcal1'] == "Health"?"selected":"";?> value="Health">Health</option>
												<option <?php echo $od_voice['please_rcal1'] == "Capacity Issue"?"selected":"";?> value="Capacity Issue">Capacity Issue</option>
												<option <?php echo $od_voice['please_rcal1'] == "Environment"?"selected":"";?> value="Environment">Environment</option>
											</select>
										</td>
										
										<td>
										<select name="data[please_rcal2]" class="form-control" id="ple_rcal2"  disabled>
											<option value="<?php echo $od_voice['please_rcal2'] ?>"><?php echo $od_voice['please_rcal2'] ?></option>
										</select>
										</td>
										<td>
										<select name="data[please_rcal3]" class="form-control" id="ple_rcal3"  disabled>
											<option value="<?php echo $od_voice['please_rcal3'] ?>"><?php echo $od_voice['please_rcal3'] ?></option>
										</select>
										</td>
										
										<td><input type="text" class="form-control" name="data[please_rcal_cmt]" value="<?php echo $od_voice['please_rcal_cmt'] ?>" disabled></td>
										
										<td colspan=2.5><input type="text" class="form-control" name="data[cmt13]" value="<?php echo $od_voice['cmt13'] ?>" disabled></td>
									</tr>
									
									<tr><td colspan="10" style="background-color:#7DCEA0"></td></tr>
									<tr style="font-weight:bold; background-color:#D7BDE2">
										<td colspan="3">Compliance</td>
										<td colspan="3">Customer</td>
										<td colspan="4">Business</td>
									</tr>
									<tr style="font-weight:bold; background-color:#D7BDE2">
										<td>Earned Point:</td><td colspan="2"><input type="text" readonly class="form-control" id="compliancescore1" name="data[compliancescore]"></td>
										<td>Earned Point:</td><td colspan="2"><input type="text" readonly class="form-control" id="customerscore1" name="data[customerscore]"></td>
										<td>Earned Point:</td><td colspan="3"><input type="text" readonly class="form-control" id="businessscore1" name="data[businessscore]"></td>
									</tr>
									<tr style="font-weight:bold; background-color:#D7BDE2">
										<td>Possible Point:</td><td colspan="2"><input type="text" readonly class="form-control" id="compliancescoreable1" name="data[compliancescoreable]"></td>
										<td>Possible Point:</td><td colspan="2"><input type="text" readonly class="form-control" id="customerscoreable1" name="data[customerscoreable]"></td>
										<td>Possible Point:</td><td colspan="3"><input type="text" readonly class="form-control" id="businessscoreable1" name="data[businessscoreable]"></td>
									</tr>
									<tr style="font-weight:bold; background-color:#D7BDE2">
										<td>Overall Percentage:</td><td colspan="2"><input type="text" readonly class="form-control" id="compliance_score_percent1" name="data[compliance_score_percent]"></td>
										<td>Overall Percentage:</td><td colspan="2"><input type="text" readonly class="form-control" id="customer_score_percent1" name="data[customer_score_percent]"></td>
										<td>Overall Percentage:</td><td colspan="3"><input type="text" readonly class="form-control" id="business_score_percent1" name="data[business_score_percent]"></td>
									</tr>
									
									<tr>
										<td>Call Summary:</td>
										<td colspan="4"><textarea class="form-control"   name="data[call_summary]" disabled=""><?php echo $od_voice['call_summary'] ?></textarea></td>
										<td>Feedback:</td>
										<td colspan="4"><textarea class="form-control"   name="data[feedback]" disabled=""><?php echo $od_voice['feedback'] ?></textarea></td>
									</tr>
									
									<tr>
										<td colspan=2>Upload Files</td>
										<?php if($od_voice_id==0){ ?>
											<td colspan=8><input type="file" multiple class="form-control" id="attach_file" name="attach_file[]"></td>
										<?php }else{
											if($od_voice['attach_file']!=''){ ?>
												<td colspan=4>
													<?php $attach_file = explode(",",$od_voice['attach_file']);
													 foreach($attach_file as $mp){ ?>
														<audio oncontextmenu="return false;" controls controlslist="nodownload" style="background-color:#607F93"> 
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
									
									<?php if($od_voice_id!=0){ ?>
										<tr><td colspan=2 style="font-size:16px; font-weight:bold">Agent Feedback Acceptance:</td><td colspan=8><?php echo $od_voice['agnt_fd_acpt'] ?></td></tr>
										<tr><td colspan=2 style="font-size:16px; font-weight:bold">Agent Review:</td><td colspan=8><?php echo $od_voice['agent_rvw_note'] ?></td></tr>
										<tr><td colspan=2 style="font-size:16px; font-weight:bold">Management Review:</td><td colspan=8><?php echo $od_voice['mgnt_rvw_note'] ?></td></tr>
										<tr><td colspan=2 style="font-size:16px; font-weight:bold">Client Review:</td><td colspan=8><?php echo $od_voice['client_rvw_note'] ?></td></tr>
									<?php } ?>

									<form id="form_agent_user" method="POST" action="">
										<input type="hidden" name="od_voice_id" class="form-control" value="<?php echo $od_voice_id; ?>">
										
										<tr>
											<td colspan="2" style="font-size:16px">Feedback Acceptance</td>
											<td colspan="8">
												<select class="form-control" id="" name="agnt_fd_acpt" required="">
													<option value="">--Select--</option>
													<option <?php echo $od_voice['agnt_fd_acpt']=='Acceptance'?"selected":""; ?> value="Acceptance">Acceptance</option>	
													<option <?php echo $od_voice['agnt_fd_acpt']=='Not Acceptance'?"selected":""; ?> value="Not Acceptance">Not Acceptance</option>	
												</select>
											</td>
										</tr>
										<tr>
											<td colspan="2"  style="font-size:16px">Review</td>
											<td colspan="8"><textarea class="form-control" name="note" required=""><?php echo $od_voice['agent_rvw_note'] ?></textarea></td>
										</tr>
										
										<?php if(is_access_qa_agent_module()==true){
										if(is_available_qa_feedback($od_voice['entry_date'],72) == true){ ?>
											<tr>
												<?php if($od_voice['agent_rvw_note']==''){ ?>
													<td colspan="10"><button class="btn btn-success waves-effect" type="submit" id='btnagentSave' name='btnSave' value="SAVE" style="width:500px">SAVE</button></td>
												<?php } ?>
											</tr>
										<?php } 
										} ?>
									  </form>
									
									<?php 
									if($od_voice_id==0){
										if(is_access_qa_module()==true || is_access_qa_operations_module()==true){ ?>
											<tr><td colspan=10><button class="btn btn-success waves-effect" type="submit" id="qaformsubmit" style="width:500px">SAVE</button></td></tr>
									<?php 
										} 
									}else{ 
										if(is_access_qa_module()==true || is_access_qa_operations_module()==true){
											if(is_available_qa_feedback($od_voice['entry_date'],72) == true){ ?>
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
