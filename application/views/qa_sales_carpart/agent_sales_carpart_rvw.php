
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
	background-color:#CCD1D1;
}

.eml2{
	font-size:24px;
	font-weight:bold;
	background-color:#008B8B;
	color:white;
}

.eml1{
	font-size:20px;
	font-weight:bold;
	background-color:#AED6F1;
}

.emp2{
	font-size:16px; 
	font-weight:bold;
}

.seml{
	font-size:15px;
	font-weight:bold;
	background-color:#CCD1D1;
}

</style>

<div class="wrap">
	<section class="app-content">

		<div class="row">
			<div class="col-12">
				<div class="widget">
				
				
				<?php if($campaign=='sales'){ ?>
					
					<div class="widget-body">
						<div class="table-responsive">
							<table class="table table-striped skt-table" width="100%" oncontextmenu="return false;">
								<tbody>
									<tr style="background-color:#AEB6BF">
										<td colspan="9" id="theader" style="font-size:30px">CarParts</td>
										<input type="hidden" name="pnid" value="<?php echo $pnid; ?>">
									</tr>
										
									<tr>
										<td colspan="1">QA Name:</td>
										<?php 
										$dataDetails=$page."_agnt_feedback";
										if($$dataDetails['entry_by']!=''){
												$auditorName = $$dataDetails['auditor_name'];
											}else{
												$auditorName = $$dataDetails['client_name'];
										} ?>
										<td colspan="2"><input type="text" class="form-control" value="<?php echo $auditorName; ?>" disabled></td>
										<td colspan="1">Audit Date:</td>
										<td colspan="2"><input type="text" class="form-control" value="<?php echo mysql2mmddyy($$dataDetails['audit_date']); ?>" disabled></td>
										<td colspan="1">Call Id.:</td>
										<td colspan="2"><input type="text" class="form-control" id="call_id" name="data[call_id]" value="<?php echo $$dataDetails['call_id'] ?>" disabled></td>
									</tr>
									<tr>
										<td colspan="1">Agent:</td>
										<td colspan="2">
											<select class="form-control" id="agent_id" name="data[agent_id]" disabled>
												<option value="<?php echo $$dataDetails['agent_id'] ?>"><?php echo $$dataDetails['fname']." ".$$dataDetails['lname'] ?></option>
												<option value="">-Select-</option>
												<?php foreach($agentName as $row):  ?>
													<option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
												<?php endforeach; ?>
											</select>
										</td>
										<td colspan="1">Fusion ID:</td>
										<td colspan="2"><input type="text" disabled class="form-control" id="fusion_id" value="<?php echo $$dataDetails['fusion_id'] ?>"></td>
										<td colspan="1">L1 Supervisor:</td>
										<td colspan="2">
											<select class="form-control" id="tl_id" name="data[tl_id]"  disabled>
												<option value="<?php echo $$dataDetails['tl_id'] ?>"><?php echo $$dataDetails['tl_name'] ?></option>
												<option value="">--Select--</option>
												<?php foreach($tlname as $tl): ?>
													<option value="<?php echo $tl['id']; ?>"><?php echo $tl['fname']." ".$tl['lname']; ?></option>
												<?php endforeach; ?>	
											</select>
										</td>
									</tr>
									<tr>
										<td style="font-weight:bold" colspan="1">Call_type:</td>
										<td colspan="2"><input type="text" class="form-control"  name="data[call_type]" value="<?php echo $$dataDetails['call_type'] ?>"  disabled></td>
										<td colspan="1">Contact Date:</td>
										<td colspan="2"><input type="text" class="form-control" id="call_date" name="call_date" value="<?php echo mysql2mmddyy($$dataDetails['call_date']) ?>" disabled></td>
										<td colspan="1">Contact Duration:</td>
										<td colspan="2"><input type="text" class="form-control" id="call_duration" name="data[call_duration]" value="<?php echo $$dataDetails['call_duration'] ?>" disabled></td>
									</tr>
									<tr>
										<td colspan="1">Audit Type:</td>
										<td colspan="2">
											<select class="form-control" id="audit_type" name="data[audit_type]" disabled>
												<option value="<?php echo $$dataDetails['audit_type'] ?>"><?php echo $$dataDetails['audit_type'] ?></option>
												<option value="">-Select-</option>
												<option value="CQ Audit">CQ Audit</option>
												<option value="BQ Audit">BQ Audit</option>
												<option value="Calibration">Calibration</option>
												<option value="Pre-Certification Mock Call">Pre-Certification Mock Call</option>
												<option value="Certification Audit">Certification Audit</option>
											</select>
										</td>
										<td colspan="1">VOC:</td>
										<td colspan="2">
											<select class="form-control" id="voc" name="data[voc]"  disabled>
												<option value="<?php echo $$dataDetails['voc'] ?>"><?php echo $$dataDetails['voc'] ?></option>
												<option value="">-Select-</option>
												<option value="1">1</option>
												<option value="2">2</option>
												<option value="3">3</option>
												<option value="4">4</option>
												<option value="5">5</option>
											</select>
										</td>
										<td>Sampling:</td>
										<td colspan=2><input type="text" class="form-control" id="" name="data[qa_sampling]" value="<?php echo $$dataDetails['qa_sampling'] ?>" disabled></td>
									</tr>
									<tr>
										<td style="font-weight:bold" colspan="1">Auto Fail:</td>
										<td colspan="2"><select class="form-control fatal_epi" id="auto_fail" name="data[auto_fail]"  disabled>
												<option value="<?php echo $$dataDetails['auto_fail'] ?>"><?php echo $$dataDetails['auto_fail'] ?></option>
												<option value="No">No</option>
												<option value="Yes">Yes</option>
											</select>
										</td>
										<td colspan="1">Sales Call Type:</td>
										<td colspan="2">
											<select class="form-control" id="sales_call_type" name="data[sales_call_type]" disabled>
												<option value="<?php echo $$dataDetails['sales_call_type'] ?>"><?php echo $$dataDetails['sales_call_type'] ?></option>
												<option value="">-Select-</option>
												<option value="Closed Sale">Closed Sale</option>
												<option value="Non-Sale">Non-Sale</option>
											</select>
										</td>
										<td class="nonSale_epi" colspan="1">Non-Sale</td>
										<td class="nonSale_epi" colspan="2">
											<select class="form-control" id="nonSale" name="data[nonSale]">
												<option value="<?php echo $$dataDetails['nonSale'] ?>"><?php echo $$dataDetails['nonSale'] ?></option>
												<option value="">-Select-</option>
												<option value="CS CONCERN">CS CONCERN</option>
												<option value="DELIVERY TIME FRAME">DELIVERY TIME FRAME</option>
												<option value="DID NOT CARRY">DID NOT CARRY</option>
												<option value="GHOST/WRONG CALL">GHOST/WRONG CALL</option>
												<option value="MARKETING">MARKETING</option>
												<option value="OTHERS">OTHERS</option>
												<option value="OUT OF STOCK">OUT OF STOCK</option>
												<option value="PRICE OBJECTION">PRICE OBJECTION</option>
												<option value="SALES INQUIRY">SALES INQUIRY</option>
												<option value="SHIPPING COST">SHIPPING COST</option>
												<option value="TECH FITNOTE">TECH FITNOTE</option>
											</select>
										</td>
									</tr>
									<tr>
										<td>Order Number:</td>
										<td><input type="text" class="form-control" id="" name="data[order_no]" value="<?php echo $$dataDetails['order_no'] ?>" disabled></td>
										<td>NPS:</td>
										<td><input type="text" class="form-control" id="" name="data[nps]" value="<?php echo $$dataDetails['nps'] ?>" disabled></td>
										<td>CSAT:</td>
										<td><input type="text" class="form-control" id="" name="data[csat]" value="<?php echo $$dataDetails['csat'] ?>" disabled></td>
										<!--<td>MC Disposition:</td>
										<td class="nonSale_epi" colspan="2">
											<select class="form-control" id="" name="data[mc_disposition]" disabled>
												<option value="<?php echo $$dataDetails['mc_disposition'] ?>"><?php echo $$dataDetails['mc_disposition'] ?></option>
											</select>
										</td>
										<td>Sub Category:</td>
										<td colspan=2><input type="text" class="form-control" id="" name="data[sub_category]" value="<?php echo $$dataDetails['sub_category'] ?>" disabled></td>-->
									</tr>
									<tr>
										<td style="font-size:18px; font-weight:bold" colspan="1">Customer Score</td>
										<td style="font-size:18px; font-weight:bold" colspan="2"><input type="text" readonly class="form-control" id="custScore" name="data[cust_score]" value="<?php echo $$dataDetails['cust_score'] ?>" readonly></td><td style="font-size:18px; font-weight:bold" colspan="1">Business Score</td>
										<td style="font-size:18px; font-weight:bold" colspan="2"><input type="text" readonly class="form-control" id="busiScore" name="data[busi_score]" value="<?php echo $$dataDetails['busi_score'] ?>" readonly></td>
										<td style="font-size:18px; font-weight:bold" colspan="1">Compliance Score:</td>
										<td style="font-size:18px; font-weight:bold" colspan="2"><input type="text" readonly class="form-control" id="compScore" name="data[comp_score]" value="<?php echo $$dataDetails['comp_score'] ?>" readonly></td>
									</tr>
									<tr>										
										<td style="font-size:18px; font-weight:bold" colspan="1">Earned Score</td>
										<td style="font-size:18px; font-weight:bold" colspan="2"><input type="text" readonly class="form-control" id="earnedScore" name="data[earned_score]" value="" disabled></td>
										<td style="font-size:18px; font-weight:bold" colspan="1">Possible Score</td>
										<td style="font-size:18px; font-weight:bold" colspan="2"><input type="text" readonly class="form-control" id="possibleScore" name="data[possible_score]" value="" disabled></td>
										<td style="font-size:18px; font-weight:bold" colspan="1">Overall Score:</td>
										<td style="font-size:18px; font-weight:bold" colspan="2"><input type="text" readonly class="form-control" id="overallScore" name="data[overall_score]" value="<?php echo $$dataDetails['overall_score'] ?>" disabled></td>
									</tr>
									
									<tr style="height:45px">
										<td class="eml2" colspan=3>Category</td>
										<td class="eml2" style="width:150px">Status</td>
										<td class="eml2" colspan=4>Remarks</td>
									</tr>
									<tr><td colspan=8 class="eml1">CALL STRUCTURE</td></tr>
									<tr>
										<td>1</td>
										<td colspan=4>Introduction</td>
										<td>
											<select class="form-control points_epi cust_score" name="data[Introduction]" disabled>
												<option ds_val=4.75 value="Yes" <?php echo $$dataDetails['Introduction']=="Yes"?"selected":""; ?> >Yes</option>
												<option ds_val=4.75 value="No" <?php echo $$dataDetails['Introduction']=="No"?"selected":""; ?> >No</option>
												<option ds_val=4.75 value="N/A" <?php echo $$dataDetails['Introduction']=="N/A"?"selected":""; ?> >N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" value="<?php echo $$dataDetails['cmt1'] ?>" name="data[cmt1]"></td>
									</tr>
									<tr>
										<td>2</td>
										<td colspan=4>Active Listening</td>
										<td>
											<select class="form-control points_epi cust_score"  name="data[active_listening]" disabled>
												<option ds_val=9.5 value="Yes" <?php echo $$dataDetails['active_listening']=="Yes"?"selected":""; ?> >Yes</option>
												<option ds_val=9.5 value="No" <?php echo $$dataDetails['active_listening']=="No"?"selected":""; ?> >No</option>
												<option ds_val=9.5 value="N/A" <?php echo $$dataDetails['active_listening']=="N/A"?"selected":""; ?> >N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" value="<?php echo $$dataDetails['cmt2'] ?>" name="data[cmt2]"></td>
									</tr>
									<tr>
										<td>3</td>
										<td colspan=4>Questioning</td>
										<td>
											<select class="form-control points_epi cust_score"  name="data[questioning]" disabled>
												<option ds_val=9.5 value="Yes" <?php echo $$dataDetails['questioning']=="Yes"?"selected":""; ?> >Yes</option>
												<option ds_val=9.5 value="No" <?php echo $$dataDetails['questioning']=="No"?"selected":""; ?> >No</option>
												<option ds_val=9.5 value="N/A" <?php echo $$dataDetails['questioning']=="N/A"?"selected":""; ?> >N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" value="<?php echo $$dataDetails['cmt3'] ?>" name="data[cmt3]"></td>
									</tr>
									<tr>
										<td>4</td>
										<td colspan=4>Presentation</td>
										<td>
											<select class="form-control points_epi busi_score"  name="data[presentation]" disabled>
												<option ds_val=14.25 value="Yes" <?php echo $$dataDetails['presentation']=="Yes"?"selected":""; ?> >Yes</option>
												<option ds_val=14.25 value="No" <?php echo $$dataDetails['presentation']=="No"?"selected":""; ?> >No</option>
												<option ds_val=14.25 value="N/A" <?php echo $$dataDetails['presentation']=="N/A"?"selected":""; ?> >N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" value="<?php echo $$dataDetails['cmt4'] ?>" name="data[cmt4]"></td>
									</tr>
									<tr>
										<td>5</td>
										<td colspan=4>Closing the Sale</td>
										<td>
											<select class="form-control points_epi busi_score"  name="data[closing_sale]" disabled>
												<option ds_val=14.25 value="Yes" <?php echo $$dataDetails['closing_sale']=="Yes"?"selected":""; ?> >Yes</option>
												<option ds_val=14.25 value="No" <?php echo $$dataDetails['closing_sale']=="No"?"selected":""; ?> >No</option>
												<option ds_val=14.25 value="N/A" <?php echo $$dataDetails['closing_sale']=="N/A"?"selected":""; ?> >N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" value="<?php echo $$dataDetails['cmt5'] ?>" name="data[cmt5]"></td>
									</tr>
									<tr>
										<td rowspan=2>6</td>
										<td rowspan=2 style="font-weight:bold">Add On</td>
										<td colspan=3>CPP</td>
										<td>
											<select class="form-control points_epi busi_score"  name="data[add_cpp]" disabled>
												<option ds_val=4.75 value="Yes" <?php echo $$dataDetails['add_cpp']=="Yes"?"selected":""; ?> >Yes</option>
												<option ds_val=4.75 value="No" <?php echo $$dataDetails['add_cpp']=="No"?"selected":""; ?> >No</option>
												<option ds_val=4.75 value="N/A" <?php echo $$dataDetails['add_cpp']=="N/A"?"selected":""; ?> >N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" value="<?php echo $$dataDetails['cmt6'] ?>" name="data[cmt6]"></td>
									</tr>
									<tr>
										<td colspan=3>Related Parts</td>
										<td>
											<select class="form-control points_epi busi_score"  name="data[add_parts]" disabled>
												<option ds_val=4.75 value="Yes" <?php echo $$dataDetails['add_parts']=="Yes"?"selected":""; ?> >Yes</option>
												<option ds_val=4.75 value="No" <?php echo $$dataDetails['add_parts']=="No"?"selected":""; ?> >No</option>
												<option ds_val=4.75 value="N/A" <?php echo $$dataDetails['add_parts']=="N/A"?"selected":""; ?> >N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" value="<?php echo $$dataDetails['cmt7'] ?>" name="data[cmt7]"></td>
									</tr>
									<tr>
										<td>7</td>
										<td colspan=4>Shipping Options</td>
										<td>
											<select class="form-control points_epi busi_score"  name="data[shipping_options]" disabled>
												<option ds_val=9.5 value="Yes" <?php echo $$dataDetails['shipping_options']=="Yes"?"selected":""; ?> >Yes</option>
												<option ds_val=9.5 value="No" <?php echo $$dataDetails['shipping_options']=="No"?"selected":""; ?> >No</option>
												<option ds_val=9.5 value="N/A" <?php echo $$dataDetails['shipping_options']=="N/A"?"selected":""; ?> >N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" value="<?php echo $$dataDetails['cmt8'] ?>" name="data[cmt8]"></td>
									</tr>
									<tr>
										<td rowspan=4>8</td>
										<td rowspan=4 style="font-weight:bold">Recap/Summary</td>
										<td colspan=3>Shipping and Billing </td>
										<td>
											<select class="form-control points_epi busi_score"  name="data[shipping_billing]" disabled>
												<option ds_val=1.9 value="Yes" <?php echo $$dataDetails['shipping_billing']=="Yes"?"selected":""; ?> >Yes</option>
												<option ds_val=1.9 value="No" <?php echo $$dataDetails['shipping_billing']=="No"?"selected":""; ?> >No</option>
												<option ds_val=1.9 value="N/A" <?php echo $$dataDetails['shipping_billing']=="N/A"?"selected":""; ?> >N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" value="<?php echo $$dataDetails['cmt9'] ?>" name="data[cmt9]"></td>
									</tr>
									<tr>
										<td colspan=3>YMMSE</td>
										<td>
											<select class="form-control points_epi busi_score"  name="data[YMMSE]" disabled>
												<option ds_val=1.9 value="Yes" <?php echo $$dataDetails['YMMSE']=="Yes"?"selected":""; ?> >Yes</option>
												<option ds_val=1.9 value="No" <?php echo $$dataDetails['YMMSE']=="No"?"selected":""; ?> >No</option>
												<option ds_val=1.9 value="N/A" <?php echo $$dataDetails['YMMSE']=="N/A"?"selected":""; ?> >N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" value="<?php echo $$dataDetails['cmt10'] ?>" name="data[cmt10]"></td>
									</tr>
									<tr>
										<td colspan=3>Part Name(s)</td>
										<td>
											<select class="form-control points_epi busi_score"  name="data[recap_summary]" disabled>
												<option ds_val=1.9 value="Yes" <?php echo $$dataDetails['recap_summary']=="Yes"?"selected":""; ?> >Yes</option>
												<option ds_val=1.9 value="No" <?php echo $$dataDetails['recap_summary']=="No"?"selected":""; ?> >No</option>
												<option ds_val=1.9 value="N/A" <?php echo $$dataDetails['recap_summary']=="N/A"?"selected":""; ?> >N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" value="<?php echo $$dataDetails['cmt11'] ?>" name="data[cmt11]"></td>
									</tr>
									<tr>
										<td colspan=3>Total Price of the order</td>
										<td>
											<select class="form-control points_epi busi_score"  name="data[total_price]" disabled>
												<option ds_val=1.9 value="Yes" <?php echo $$dataDetails['total_price']=="Yes"?"selected":""; ?> >Yes</option>
												<option ds_val=1.9 value="No" <?php echo $$dataDetails['total_price']=="No"?"selected":""; ?> >No</option>
												<option ds_val=1.9 value="N/A" <?php echo $$dataDetails['total_price']=="N/A"?"selected":""; ?> >N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" value="<?php echo $$dataDetails['cmt12'] ?>" name="data[cmt12]"></td>
									</tr>
									<tr>
										<td rowspan=2>9</td>
										<td rowspan=2 style="font-weight:bold">Closing Script</td>
										<td colspan=3>Rebranding</td>
										<td>
											<select class="form-control points_epi busi_score"  name="data[rebranding]" disabled>
												<option ds_val=4.75 value="Yes" <?php echo $$dataDetails['rebranding']=="Yes"?"selected":""; ?> >Yes</option>
												<option ds_val=4.75 value="No" <?php echo $$dataDetails['rebranding']=="No"?"selected":""; ?> >No</option>
												<option ds_val=4.75 value="N/A" <?php echo $$dataDetails['rebranding']=="N/A"?"selected":""; ?> >N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" value="<?php echo $$dataDetails['cmt13'] ?>" name="data[cmt13]"></td>
									</tr>
									<tr>
										<td colspan=3>Tracking Email</td>
										<td>
											<select class="form-control points_epi busi_score"  name="data[tracking_email]" disabled>
												<option ds_val=1.9 value="Yes" <?php echo $$dataDetails['tracking_email']=="Yes"?"selected":""; ?> >Yes</option>
												<option ds_val=1.9 value="No" <?php echo $$dataDetails['tracking_email']=="No"?"selected":""; ?> >No</option>
												<option ds_val=1.9 value="N/A" <?php echo $$dataDetails['tracking_email']=="N/A"?"selected":""; ?> >N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" value="<?php echo $$dataDetails['cmt14'] ?>" name="data[cmt14]"></td>
									</tr>
									<tr>
										<td>10</td>
										<td colspan=4>Overcoming Objections</td>
										<td>
											<select class="form-control points_epi busi_score"  name="data[overcoming_objections]" disabled>
												<option ds_val=9.5 value="Yes" <?php echo $$dataDetails['overcoming_objections']=="Yes"?"selected":""; ?> >Yes</option>
												<option ds_val=9.5 value="No" <?php echo $$dataDetails['overcoming_objections']=="No"?"selected":""; ?> >No</option>
												<option ds_val=9.5 value="N/A" <?php echo $$dataDetails['overcoming_objections']=="N/A"?"selected":""; ?> >N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" value="<?php echo $$dataDetails['cmt15'] ?>" name="data[cmt15]"></td>
									</tr>
									
									<tr><td class="eml1" colspan=8>PROCESS ADHERENCE</td></tr>
									<tr>
										<td>11</td>
										<td colspan=4>Discount Rules</td>
										<td>
											<select class="form-control points_pa busi_score"  name="data[discount_rules]" disabled>
												<option ds_val=1.5 value="Yes" <?php echo $$dataDetails['discount_rules']=="Yes"?"selected":""; ?> >Yes</option>
												<option ds_val=1.5 value="No" <?php echo $$dataDetails['discount_rules']=="No"?"selected":""; ?> >No</option>
												<option ds_val=1.5 value="N/A" <?php echo $$dataDetails['discount_rules']=="N/A"?"selected":""; ?> >N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" value="<?php echo $$dataDetails['cmt16'] ?>" name="data[cmt16]"></td>
									</tr>
									<tr>
										<td rowspan=3>12</td>
										<td rowspan=3 style="font-weight:bold">Account Verification</td>
										<td colspan=3>"MyAccount" utilization</td>
										<td>
											<select class="form-control points_pa comp_score"  name="data[account_verification]" disabled>
												<option ds_val=1 value="Yes" <?php echo $$dataDetails['account_verification']=="Yes"?"selected":""; ?> >Yes</option>
												<option ds_val=1 value="No" <?php echo $$dataDetails['account_verification']=="No"?"selected":""; ?> >No</option>
												<option ds_val=1 value="N/A" <?php echo $$dataDetails['account_verification']=="N/A"?"selected":""; ?> >N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" value="<?php echo $$dataDetails['cmt17'] ?>" name="data[cmt17]"></td>
									</tr>
									<tr>
										<td colspan=3>Data Gathering Compliance</td>
										<td>
											<select class="form-control points_pa comp_score"  name="data[data_gathering]" disabled>
												<option ds_val=1 value="Yes" <?php echo $$dataDetails['data_gathering']=="Yes"?"selected":""; ?> >Yes</option>
												<option ds_val=1 value="No" <?php echo $$dataDetails['data_gathering']=="No"?"selected":""; ?> >No</option>
												<option ds_val=1 value="N/A" <?php echo $$dataDetails['data_gathering']=="N/A"?"selected":""; ?> >N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" value="<?php echo $$dataDetails['cmt19'] ?>" name="data[cmt19]"></td>
									</tr>
									<tr>
										<td colspan=3>Accuracy</td>
										<td>
											<select class="form-control points_pa comp_score"  name="data[account_accuracy]" disabled>
												<option ds_val=1 value="Yes" <?php echo $$dataDetails['account_accuracy']=="Yes"?"selected":""; ?> >Yes</option>
												<option ds_val=1 value="No" <?php echo $$dataDetails['account_accuracy']=="No"?"selected":""; ?> >No</option>
												<option ds_val=1 value="N/A" <?php echo $$dataDetails['account_accuracy']=="N/A"?"selected":""; ?> >N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" value="<?php echo $$dataDetails['cmt20'] ?>" name="data[cmt20]"></td>
									</tr>
									<tr>
										<td>13</td>
										<td colspan=4>Documentation</td>
										<td>
											<select class="form-control points_pa busi_score"  name="data[documentation]" disabled>
												<option ds_val=0.5 value="Yes" <?php echo $$dataDetails['documentation']=="Yes"?"selected":""; ?> >Yes</option>
												<option ds_val=0.5 value="No" <?php echo $$dataDetails['documentation']=="No"?"selected":""; ?> >No</option>
												<option ds_val=0.5 value="N/A" <?php echo $$dataDetails['documentation']=="N/A"?"selected":""; ?> >N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" class="form-control" value="<?php echo $$dataDetails['cmt18'] ?>" name="data[cmt18]"></td>
									</tr>
									
									<tr>
										<td colspan="3">Call Summary:</td>
										<td colspan="6"><textarea class="form-control" id="call_summary" name="data[call_summary]"><?php echo $$dataDetails['call_summary'] ?></textarea></td>
									</tr>
									<tr>
										<td colspan="3">Feedback:</td>
										<td colspan="6"><textarea class="form-control" id="feedback" name="data[feedback]"><?php echo $$dataDetails['feedback'] ?></textarea></td>
									</tr>
									
									<?php if($$dataDetails['attach_file']!=''){ ?>
									<tr>
										<td colspan="3">Audio Files</td>
										<td colspan="6">
											<?php $attach_file = explode(",",$$dataDetails['attach_file']);
											 foreach($attach_file as $af){ ?>
												<audio controls='' controlsList="nodownload" style="background-color:#607F93">
													  <source src="<?php echo base_url(); ?>qa_files/qa_<?php echo $page ?>/<?php echo $af; ?>" type="audio/ogg">
													  <source src="<?php echo base_url(); ?>qa_files/qa_<?php echo $page ?>/<?php echo $af; ?>" type="audio/mpeg">
												</audio> </br>
											 <?php } ?>
										</td>
									</tr>
									<?php } ?>
									<tr><td colspan="9" style="background-color:#C5C8C8"></td></tr>
									
									<tr><td style="font-size:16px" colspan="2">Manager Review:</td> <td colspan="7" style="text-align:left"><?php echo $$dataDetails['mgnt_rvw_note'] ?></td></tr>
									<tr><td style="font-size:16px" colspan="2">Client Review:</td> <td colspan="7" style="text-align:left"><?php echo $$dataDetails['client_rvw_note'] ?></td></tr>
									<!-- <tr><td style="font-size:16px">Your Review:</td> <td colspan="5" style="text-align:left"><?php echo $$dataDetails['agent_rvw_note']; ?></td></tr> -->
									
									<tr><td colspan="9" style="background-color:#C5C8C8"></td></tr>
									
									 <form id="form_agent_user" method="POST" action="">
										<tr>
											<td colspan="3"  style="font-size:16px">Your Review
												<input type="hidden" name="pnid" class="form-control" value="<?php echo $pnid; ?>">
											</td>
											<td colspan="6"><textarea class="form-control" name="note" required><?php echo $$dataDetails['agent_rvw_note'] ?></textarea></td>
										</tr>
										
										<?php if(is_access_qa_agent_module()==true){
										if(is_available_qa_feedback($$dataDetails['entry_date'],72) == true){ ?>
											<tr>
												<?php if($$dataDetails['agent_rvw_note']==''){ ?>
													<td colspan="9"><button class="btn btn-success waves-effect" type="submit" id='btnagentSave' name='btnSave' value="SAVE" style="width:500px">SAVE</button></td>
												<?php } ?>
											</tr>
										<?php } 
										} ?>
									
									  </form>
								</tbody>
							</table>
						</div>
					</div>
					
				<?php }else if($campaign=='service'){ ?>
				
					<div class="widget-body">
						<div class="table-responsive">
							<table class="table table-striped skt-table" width="100%" oncontextmenu="return false;">
								<tbody>
									<tr style="background-color:#AEB6BF">
										<td colspan="9" id="theader" style="font-size:30px">CarParts</td>
										<input type="hidden" name="pnid" value="<?php echo $pnid; ?>">
									</tr>
										
									<tr>
										<td colspan="1">QA Name:</td>
										<?php 
										$dataDetails=$page."_agnt_feedback";
										if($$dataDetails['entry_by']!=''){
												$auditorName = $$dataDetails['auditor_name'];
											}else{
												$auditorName = $$dataDetails['client_name'];
										} ?>
										<td colspan="2"><input type="text" class="form-control" value="<?php echo $auditorName; ?>" disabled></td>
										<td colspan="1">Audit Date:</td>
										<td colspan="2"><input type="text" class="form-control" value="<?php echo mysql2mmddyy($$dataDetails['audit_date']); ?>" disabled></td>
										<td colspan="1">Call Id.:</td>
										<td colspan="2"><input type="text" class="form-control" id="call_id" name="data[call_id]" value="<?php echo $$dataDetails['call_id'] ?>" disabled></td>
									</tr>
									<tr>
										<td colspan="1">Agent:</td>
										<td colspan="2">
											<select class="form-control" id="agent_id" name="data[agent_id]" disabled>
												<option value="<?php echo $$dataDetails['agent_id'] ?>"><?php echo $$dataDetails['fname']." ".$$dataDetails['lname'] ?></option>
												<option value="">-Select-</option>
												<?php foreach($agentName as $row):  ?>
													<option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
												<?php endforeach; ?>
											</select>
										</td>
										<td colspan="1">Fusion ID:</td>
										<td colspan="2"><input type="text" disabled class="form-control" id="fusion_id" value="<?php echo $$dataDetails['fusion_id'] ?>"></td>
										<td colspan="1">L1 Supervisor:</td>
										<td colspan="2">
											<select class="form-control" id="tl_id" name="data[tl_id]"  disabled>
												<option value="<?php echo $$dataDetails['tl_id'] ?>"><?php echo $$dataDetails['tl_name'] ?></option>
												<option value="">--Select--</option>
												<?php foreach($tlname as $tl): ?>
													<option value="<?php echo $tl['id']; ?>"><?php echo $tl['fname']." ".$tl['lname']; ?></option>
												<?php endforeach; ?>	
											</select>
										</td>
									</tr>
									<tr>
										<td style="font-weight:bold" colspan="1">Call_type:</td>
										<td colspan="2"><input type="text" class="form-control"  name="data[call_type]" value="<?php echo $$dataDetails['call_type'] ?>"  disabled></td>
										<td colspan="1">Contact Date:</td>
										<td colspan="2"><input type="text" class="form-control" id="call_date" name="call_date" value="<?php echo mysql2mmddyy($$dataDetails['call_date']) ?>" disabled></td>
										<td colspan="1">Contact Duration:</td>
										<td colspan="2"><input type="text" class="form-control" id="call_duration" name="data[call_duration]" value="<?php echo $$dataDetails['call_duration'] ?>" disabled></td>
									</tr>
									<tr>
										<td colspan="1">Audit Type:</td>
										<td colspan="2">
											<select class="form-control" id="audit_type" name="data[audit_type]" disabled>
												<option value="<?php echo $$dataDetails['audit_type'] ?>"><?php echo $$dataDetails['audit_type'] ?></option>
												<option value="">-Select-</option>
												<option value="CQ Audit">CQ Audit</option>
												<option value="BQ Audit">BQ Audit</option>
												<option value="Calibration">Calibration</option>
												<option value="Pre-Certification Mock Call">Pre-Certification Mock Call</option>
												<option value="Certification Audit">Certification Audit</option>
											</select>
										</td>
										<td class="auType_epi" colspan="1">Auditor Type</td>
										<td class="auType_epi" colspan="2">
											<select class="form-control" id="auditor_type" name="data[auditor_type]" disabled>
												<option value="">-Select-</option>
												<option <?php echo $$dataDetails['auditor_type']=='Master'?"selected":""; ?> value="Master">Master</option>
												<option <?php echo $$dataDetails['auditor_type']=='Regular'?"selected":""; ?> value="Regular">Regular</option>
											</select>
										</td>
										<td colspan="1">VOC:</td>
										<td colspan="2">
											<select class="form-control" id="voc" name="data[voc]"  disabled>
												<option value="<?php echo $$dataDetails['voc'] ?>"><?php echo $$dataDetails['voc'] ?></option>
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
										<td style="font-weight:bold" colspan="1">Auto Fail:</td>
										<td colspan="2"><select class="form-control fatal_epi" id="auto_fail" name="data[auto_fail]"  disabled>
												<option value="<?php echo $$dataDetails['auto_fail'] ?>"><?php echo $$dataDetails['auto_fail'] ?></option>
												<option value="No">No</option>
												<option value="Yes">Yes</option>
											</select>
										</td>
										
									</tr>
									<tr>
										<td style="font-size:18px; font-weight:bold" colspan="1">Customer Score</td>
										<td style="font-size:18px; font-weight:bold" colspan="2"><input type="text" readonly class="form-control" id="custScore" name="data[cust_score]" value="<?php echo $$dataDetails['cust_score'] ?>" readonly></td><td style="font-size:18px; font-weight:bold" colspan="1">Business Score</td>
										<td style="font-size:18px; font-weight:bold" colspan="2"><input type="text" readonly class="form-control" id="busiScore" name="data[busi_score]" value="<?php echo $$dataDetails['busi_score'] ?>" readonly></td>
										<td style="font-size:18px; font-weight:bold" colspan="1">Compliance Score:</td>
										<td style="font-size:18px; font-weight:bold" colspan="2"><input type="text" readonly class="form-control" id="compScore" name="data[comp_score]" value="<?php echo $$dataDetails['comp_score'] ?>" readonly></td>
									</tr>
									<tr>										
										<td style="font-size:18px; font-weight:bold" colspan="1">Earned Score</td>
										<td style="font-size:18px; font-weight:bold" colspan="2"><input type="text" readonly class="form-control" id="earnedScore" name="data[earned_score]" value="" disabled></td>
										<td style="font-size:18px; font-weight:bold" colspan="1">Possible Score</td>
										<td style="font-size:18px; font-weight:bold" colspan="2"><input type="text" readonly class="form-control" id="possibleScore" name="data[possible_score]" value="" disabled></td>
										<td style="font-size:18px; font-weight:bold" colspan="1">Overall Score:</td>
										<td style="font-size:18px; font-weight:bold" colspan="2"><input type="text" readonly class="form-control" id="overallScore" name="data[overall_score]" value="<?php echo $$dataDetails['overall_score'] ?>" disabled></td>
									</tr>
									<tr style="height:45px">
										<td class="eml2">Category</td>
										<td class="eml2" colspan=4>Sub Category</td>
										<td class="eml2" style="width:150px">Status</td>
										<td class="eml2" colspan=4>Remarks</td>
									</tr>
									<tr>
										<td rowspan=10 class="eml1">CALL STRUCTURE</td>
										<td class="eml" colspan=4>Call Opening
										</td>
										<td>
											<select class="form-control points_epi cust_score" name="data[call_opening]" disabled>
												<option ds_val=4 value="Yes" <?php echo $$dataDetails['call_opening']=="Yes"?"selected":""; ?> >Yes</option>
												<option ds_val=4 value="No" <?php echo $$dataDetails['call_opening']=="No"?"selected":""; ?> >No</option>
												<option ds_val=4 value="N/A" <?php echo $$dataDetails['call_opening']=="N/A"?"selected":""; ?> >N/A</option>
											</select>
										</td>
										<td colspan=2><textarea class="form-control" disabled><?php echo $$dataDetails['cmt1'] ?></textarea></td>
									</tr>
									<tr>
										<td class="eml" colspan=4>Account Verification</td>
										<td>
											<select class="form-control points_epi comp_score"  name="data[account_verification]" disabled>
												<option ds_val=4 value="Yes" <?php echo $$dataDetails['account_verification']=="Yes"?"selected":""; ?> >Yes</option>
												<option ds_val=4 value="No" <?php echo $$dataDetails['account_verification']=="No"?"selected":""; ?> >No</option>
												<option ds_val=4 value="N/A" <?php echo $$dataDetails['account_verification']=="N/A"?"selected":""; ?> >N/A</option>
											</select>
										</td>
										<td colspan=2><textarea class="form-control" disabled><?php echo $$dataDetails['cmt2'] ?></textarea></td>
									</tr>
									<tr>
										<td class="eml" colspan=4>Concern and Assurance</td>
										<td>
											<select class="form-control points_epi cust_score"  name="data[concern_assurance]" disabled>
												<option ds_val=8 value="Yes" <?php echo $$dataDetails['concern_assurance']=="Yes"?"selected":""; ?> >Yes</option>
												<option ds_val=8 value="No" <?php echo $$dataDetails['concern_assurance']=="No"?"selected":""; ?> >No</option>
												<option ds_val=8 value="N/A" <?php echo $$dataDetails['concern_assurance']=="N/A"?"selected":""; ?> >N/A</option>
											</select>
										</td>
									<td colspan=2><textarea class="form-control" disabled><?php echo $$dataDetails['cmt3'] ?></textarea></td>
									</tr>
									<tr>
										<td class="eml" colspan=4>P.A.T.I.E.N.C.E. (Pace, Tone and Energy)</td>
										<td>
											<select class="form-control points_epi cust_score"  name="data[tone_energy]" disabled>
												<option ds_val=12 value="Yes" <?php echo $$dataDetails['tone_energy']=="Yes"?"selected":""; ?> >Yes</option>
												<option ds_val=12 value="No" <?php echo $$dataDetails['tone_energy']=="No"?"selected":""; ?> >No</option>
												<option ds_val=12 value="N/A" <?php echo $$dataDetails['tone_energy']=="N/A"?"selected":""; ?> >N/A</option>
											</select>
										</td>
									<td colspan=2><textarea class="form-control" disabled><?php echo $$dataDetails['cmt4'] ?></textarea></td>
									</tr>
									<tr>
										<td class="eml" colspan=4>Rapport and Empathy</td>
										<td>
											<select class="form-control points_epi cust_score"  name="data[rapport_empathy]" disabled>
												<option ds_val=12 value="Yes" <?php echo $$dataDetails['rapport_empathy']=="Yes"?"selected":""; ?> >Yes</option>
												<option ds_val=12 value="No" <?php echo $$dataDetails['rapport_empathy']=="No"?"selected":""; ?> >No</option>
												<option ds_val=12 value="N/A" <?php echo $$dataDetails['rapport_empathy']=="N/A"?"selected":""; ?> >N/A</option>
											</select>
										</td>
									<td colspan=2><textarea class="form-control" disabled><?php echo $$dataDetails['cmt5'] ?></textarea></td>
									</tr>
									<tr>
										<td class="eml" colspan=4>Probing</td>
										<td>
											<select class="form-control points_epi cust_score"  name="data[probing]" disabled>
												<option ds_val=8 value="Yes" <?php echo $$dataDetails['probing']=="Yes"?"selected":""; ?> >Yes</option>
												<option ds_val=8 value="No" <?php echo $$dataDetails['probing']=="No"?"selected":""; ?> >No</option>
												<option ds_val=8 value="N/A" <?php echo $$dataDetails['probing']=="N/A"?"selected":""; ?> >N/A</option>
											</select>
										</td>
									<td colspan=2><textarea class="form-control" disabled><?php echo $$dataDetails['cmt6'] ?></textarea></td>
									</tr>
									<tr>
										<td class="eml" colspan=4>Conveyance and Resolution</td>
										<td>
											<select class="form-control points_epi busi_score"  name="data[conveyance_resolution]" disabled>
												<option ds_val=12 value="Yes" <?php echo $$dataDetails['conveyance_resolution']=="Yes"?"selected":""; ?> >Yes</option>
												<option ds_val=12 value="No" <?php echo $$dataDetails['conveyance_resolution']=="No"?"selected":""; ?> >No</option>
												<option ds_val=12 value="N/A" <?php echo $$dataDetails['conveyance_resolution']=="N/A"?"selected":""; ?> >N/A</option>
											</select>
										</td>
									<td colspan=2><textarea class="form-control" disabled><?php echo $$dataDetails['cmt7'] ?></textarea></td>
									</tr>
									<tr>
										<td class="eml" colspan=4>Proper Hold Procedure</td>
										<td>
											<select class="form-control points_epi busi_score"  name="data[proper_procedure]" disabled>
												<option ds_val=8 value="Yes" <?php echo $$dataDetails['proper_procedure']=="Yes"?"selected":""; ?> >Yes</option>
												<option ds_val=8 value="No" <?php echo $$dataDetails['proper_procedure']=="No"?"selected":""; ?> >No</option>
												<option ds_val=8 value="N/A" <?php echo $$dataDetails['proper_procedure']=="N/A"?"selected":""; ?> >N/A</option>
											</select>
										</td>
									<td colspan=2><textarea class="form-control" disabled><?php echo $$dataDetails['cmt8'] ?></textarea></td>
									</tr>
									<tr>
										<td class="eml" colspan=4>Recap and Closing Statement </td>
										<td>
											<select class="form-control points_epi busi_score"  name="data[recap_statement]" disabled>
												<option ds_val=4 value="Yes" <?php echo $$dataDetails['recap_statement']=="Yes"?"selected":""; ?> >Yes</option>
												<option ds_val=4 value="No" <?php echo $$dataDetails['recap_statement']=="No"?"selected":""; ?> >No</option>
												<option ds_val=4 value="N/A" <?php echo $$dataDetails['recap_statement']=="N/A"?"selected":""; ?> >N/A</option>
											</select>
										</td>
									<td colspan=2><textarea class="form-control" disabled><?php echo $$dataDetails['cmt9'] ?></textarea></td>
									</tr>
									<tr>
										<td class="eml" colspan=4>Objections Handling</td>
										<td>
											<select class="form-control points_epi busi_score"  name="data[objections_handling]" disabled>
												<option ds_val=8 value="Yes" <?php echo $$dataDetails['objections_handling']=="Yes"?"selected":""; ?> >Yes</option>
												<option ds_val=8 value="No" <?php echo $$dataDetails['objections_handling']=="No"?"selected":""; ?> >No</option>
												<option ds_val=8 value="N/A" <?php echo $$dataDetails['objections_handling']=="N/A"?"selected":""; ?> >N/A</option>
											</select>
										</td>
									<td colspan=2><textarea class="form-control" disabled><?php echo $$dataDetails['cmt10'] ?></textarea></td>
									</tr>
									<tr>
										<td rowspan=4 class="eml1">PROCESS ADHERENCE</td>
										<td class="eml" colspan=4>Returns Tagging</td>
										<td>
											<select class="form-control points_pa busi_score"  name="data[returns_tagging]" disabled>
												<option ds_val=4 value="Yes" <?php echo $$dataDetails['returns_tagging']=="Yes"?"selected":""; ?> >Yes</option>
												<option ds_val=4 value="No" <?php echo $$dataDetails['returns_tagging']=="No"?"selected":""; ?> >No</option>
												<option ds_val=4 value="N/A" <?php echo $$dataDetails['returns_tagging']=="N/A"?"selected":""; ?> >N/A</option>
											</select>
										</td>
									<td colspan=2><textarea class="form-control" disabled><?php echo $$dataDetails['cmt11'] ?></textarea></td>
									</tr>
									<tr>
										<td class="eml" colspan=4>Documentation </td>
										<td>
											<select class="form-control points_pa busi_score"  name="data[documentation]" disabled>
												<option ds_val=6 value="Yes" <?php echo $$dataDetails['documentation']=="Yes"?"selected":""; ?> >Yes</option>
												<option ds_val=6 value="No" <?php echo $$dataDetails['documentation']=="No"?"selected":""; ?> >No</option>
												<option ds_val=6 value="N/A" <?php echo $$dataDetails['documentation']=="N/A"?"selected":""; ?> >N/A</option>
											</select>
										</td>
									<td colspan=2><textarea class="form-control" disabled><?php echo $$dataDetails['cmt12'] ?></textarea></td>
									</tr>
									<tr>
										<td class="eml" colspan=4>Actions Taken</td>
										<td>
											<select class="form-control points_pa busi_score"  name="data[actions_taken]" disabled>
												<option ds_val=10 value="Yes" <?php echo $$dataDetails['actions_taken']=="Yes"?"selected":""; ?> >Yes</option>
												<option ds_val=10 value="No" <?php echo $$dataDetails['actions_taken']=="No"?"selected":""; ?> >No</option>
												<option ds_val=10 value="N/A" <?php echo $$dataDetails['actions_taken']=="N/A"?"selected":""; ?> >N/A</option>
											</select>
										</td>
										<td colspan=2><textarea class="form-control" disabled><?php echo $$dataDetails['cmt13'] ?></textarea></td>
									</tr>
									<tr>
										<td class="eml"></td>
										<td class="eml" colspan=3>Self Service Option Offered?</td>
										<td>
											<select class="form-control points_pa busi_score"  name="data[action_self_service]" disabled>
												<option ds_val=0 <?php echo $$dataDetails['action_self_service']=="Yes"?"selected":""; ?> value="Yes">Yes</option>
												<option ds_val=0 <?php echo $$dataDetails['action_self_service']=="Yes"?"selected":""; ?> value="No">No</option>
												<option ds_val=0 <?php echo $$dataDetails['action_self_service']=="Yes"?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><textarea class="form-control" disabled><?php echo $$dataDetails['cmt14'] ?></textarea></td>
									</tr>
									<tr>
										<td colspan="3">Call Summary:</td>
										<td colspan="6"><textarea class="form-control" id="call_summary" name="data[call_summary]"><?php echo $$dataDetails['call_summary'] ?></textarea></td>
									</tr>
									<tr>
										<td colspan="3">Feedback:</td>
										<td colspan="6"><textarea class="form-control" id="feedback" name="data[feedback]"><?php echo $$dataDetails['feedback'] ?></textarea></td>
									</tr>
									
									<?php if($$dataDetails['attach_file']!=''){ ?>
									<tr oncontextmenu="return false;">
										<td colspan="3">Audio Files</td>
										<td colspan="6">
											<?php $attach_file = explode(",",$$dataDetails['attach_file']);
											 foreach($attach_file as $af){ ?>
												<audio controls='' controlsList="nodownload" style="background-color:#607F93">
													  <source src="<?php echo base_url(); ?>qa_files/qa_<?php echo $page ?>/<?php echo $af; ?>" type="audio/ogg">
													  <source src="<?php echo base_url(); ?>qa_files/qa_<?php echo $page ?>/<?php echo $af; ?>" type="audio/mpeg">
												</audio> </br>
											 <?php } ?>
										</td>
									</tr>
									<?php } ?>
									<tr><td colspan="9" style="background-color:#C5C8C8"></td></tr>
									
									<tr><td style="font-size:16px" colspan="2">Manager Review:</td> <td colspan="7" style="text-align:left"><?php echo $$dataDetails['mgnt_rvw_note'] ?></td></tr>
									<tr><td style="font-size:16px" colspan="2">Client Review:</td> <td colspan="7" style="text-align:left"><?php echo $$dataDetails['client_rvw_note'] ?></td></tr>
									<!-- <tr><td style="font-size:16px">Your Review:</td> <td colspan="5" style="text-align:left"><?php echo $$dataDetails['agent_rvw_note']; ?></td></tr> -->
									
									<tr><td colspan="9" style="background-color:#C5C8C8"></td></tr>
									
									 <form id="form_agent_user" method="POST" action="">
										<tr>
											<td colspan="3"  style="font-size:16px">Your Review
												<input type="hidden" name="pnid" class="form-control" value="<?php echo $pnid; ?>">
											</td>
											<td colspan="6"><textarea class="form-control" name="note" required><?php echo $$dataDetails['agent_rvw_note'] ?></textarea></td>
										</tr>
										
										<?php if(is_access_qa_agent_module()==true){
										if(is_available_qa_feedback($$dataDetails['entry_date'],72) == true){ ?>
											<tr>
												<?php if($$dataDetails['agent_rvw_note']==''){ ?>
													<td colspan="9"><button class="btn btn-success waves-effect" type="submit" id='btnagentSave' name='btnSave' value="SAVE" style="width:500px">SAVE</button></td>
												<?php } ?>
											</tr>
										<?php } 
										} ?>
									
									  </form>
								</tbody>
							</table>
						</div>
					</div>
				
				

				<?php }else if($campaign=='inbound'){ ?>
				
					<div class="widget-body">
						<div class="table-responsive">
							<table class="table table-striped skt-table" width="100%" oncontextmenu="return false;">
								<tbody>
									<tr style="background-color:#AEB6BF">
										<td colspan="9" id="theader" style="font-size:30px">Inbound</td>
										<input type="hidden" name="pnid" value="<?php echo $pnid; ?>">
									</tr>
										
									<tr>
										<td colspan="1">QA Name:</td>
										<?php 
										$dataDetails=$page."_agnt_feedback";
										if($$dataDetails['entry_by']!=''){
												$auditorName = $$dataDetails['auditor_name'];
											}else{
												$auditorName = $$dataDetails['client_name'];
										} ?>
										<td colspan="2"><input type="text" class="form-control" value="<?php echo $auditorName; ?>" disabled></td>
										<td colspan="1">Audit Date:</td>
										<td colspan="2"><input type="text" class="form-control" value="<?php echo mysql2mmddyy($$dataDetails['audit_date']); ?>" disabled></td>
										<td colspan="1">Call Id.:</td>
										<td colspan="2"><input type="text" class="form-control" id="call_id" name="data[call_id]" value="<?php echo $$dataDetails['call_id'] ?>" disabled></td>
									</tr>
									<tr>
										<td colspan="1">Agent:</td>
										<td colspan="2">
											<select class="form-control" id="agent_id" name="data[agent_id]" disabled>
												<option value="<?php echo $$dataDetails['agent_id'] ?>"><?php echo $$dataDetails['fname']." ".$$dataDetails['lname'] ?></option>
												<option value="">-Select-</option>
												<?php foreach($agentName as $row):  ?>
													<option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
												<?php endforeach; ?>
											</select>
										</td>
										<td colspan="1">Fusion ID:</td>
										<td colspan="2"><input type="text" disabled class="form-control" id="fusion_id" value="<?php echo $$dataDetails['fusion_id'] ?>"></td>
										<td colspan="1">L1 Supervisor:</td>
										<td colspan="2">
											<select class="form-control" id="tl_id" name="data[tl_id]"  disabled>
												<option value="<?php echo $$dataDetails['tl_id'] ?>"><?php echo $$dataDetails['tl_name'] ?></option>
												<option value="">--Select--</option>
												<?php foreach($tlname as $tl): ?>
													<option value="<?php echo $tl['id']; ?>"><?php echo $tl['fname']." ".$tl['lname']; ?></option>
												<?php endforeach; ?>	
											</select>
										</td>
									</tr>
									<tr>
										<td style="font-weight:bold" colspan="1">Call_type:</td>
										<td colspan="2"><input type="text" class="form-control"  name="data[call_type]" value="<?php echo $$dataDetails['call_type'] ?>"  disabled></td>
										<td colspan="1">Contact Date:</td>
										<td colspan="2"><input type="text" class="form-control" id="call_date" name="call_date" value="<?php echo mysql2mmddyy($$dataDetails['call_date']) ?>" disabled></td>
										<td colspan="1">Contact Duration:</td>
										<td colspan="2"><input type="text" class="form-control" id="call_duration" name="data[call_duration]" value="<?php echo $$dataDetails['call_duration'] ?>" disabled></td>
									</tr>
									<tr>
										<td colspan="1">Audit Type:</td>
										<td colspan="2">
											<select class="form-control" id="audit_type" name="data[audit_type]" disabled>
												<option value="<?php echo $$dataDetails['audit_type'] ?>"><?php echo $$dataDetails['audit_type'] ?></option>
												<option value="">-Select-</option>
												<option value="CQ Audit">CQ Audit</option>
												<option value="BQ Audit">BQ Audit</option>
												<option value="Calibration">Calibration</option>
												<option value="Pre-Certification Mock Call">Pre-Certification Mock Call</option>
												<option value="Certification Audit">Certification Audit</option>
											</select>
										</td>
										<td class="auType_epi" colspan="1">Auditor Type</td>
										<td class="auType_epi" colspan="2">
											<select class="form-control" id="auditor_type" name="data[auditor_type]" disabled>
												<option value="">-Select-</option>
												<option <?php echo $$dataDetails['auditor_type']=='Master'?"selected":""; ?> value="Master">Master</option>
												<option <?php echo $$dataDetails['auditor_type']=='Regular'?"selected":""; ?> value="Regular">Regular</option>
											</select>
										</td>
										<td colspan="1">VOC:</td>
										<td colspan="2">
											<select class="form-control" id="voc" name="data[voc]"  disabled>
												<option value="<?php echo $$dataDetails['voc'] ?>"><?php echo $$dataDetails['voc'] ?></option>
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
										<td style="font-weight:bold" colspan="1">Auto Fail:</td>
										<td colspan="2"><select class="form-control fatal_epi" id="auto_fail" name="data[auto_fail]"  disabled>
												<option value="<?php echo $$dataDetails['auto_fail'] ?>"><?php echo $$dataDetails['auto_fail'] ?></option>
												<option value="No">No</option>
												<option value="Yes">Yes</option>
											</select>
										</td>
										
									</tr>
									<tr>										
										<td style="font-size:18px; font-weight:bold" colspan="1">Earned Score</td>
										<td style="font-size:18px; font-weight:bold" colspan="2"><input type="text" readonly class="form-control" id="earnedScore" name="data[earned_score]" value="" disabled></td>
										<td style="font-size:18px; font-weight:bold" colspan="1">Possible Score</td>
										<td style="font-size:18px; font-weight:bold" colspan="2"><input type="text" readonly class="form-control" id="possibleScore" name="data[possible_score]" value="" disabled></td>
										<td style="font-size:18px; font-weight:bold" colspan="1">Overall Score:</td>
										<td style="font-size:18px; font-weight:bold" colspan="2"><input type="text" readonly class="form-control" id="overallScore" name="data[overall_score]" value="<?php echo $$dataDetails['overall_score'] ?>" disabled></td>
									</tr>
									<tr>
										<td style="font-size:18px; font-weight:bold" colspan="1">Customer Score</td>
										<td style="font-size:18px; font-weight:bold" colspan="2"><input type="text" readonly class="form-control" id="custScore" name="data[cust_score]" value="<?php echo $$dataDetails['cust_score'] ?>" readonly></td><td style="font-size:18px; font-weight:bold" colspan="1">Business Score</td>
										<td style="font-size:18px; font-weight:bold" colspan="2"><input type="text" readonly class="form-control" id="busiScore" name="data[busi_score]" value="<?php echo $$dataDetails['busi_score'] ?>" readonly></td>
										<td style="font-size:18px; font-weight:bold" colspan="1">Compliance Score:</td>
										<td style="font-size:18px; font-weight:bold" colspan="2"><input type="text" readonly class="form-control" id="compScore" name="data[comp_score]" value="<?php echo $$dataDetails['comp_score'] ?>" readonly></td>
									</tr>
									
									<tr style="height:45px">
										<td class="eml2">Category</td>
										<td class="eml2" colspan=4>Sub Category</td>
										<td class="eml2" style="width:150px">Status</td>
										<td class="eml2" colspan=4>Remarks</td>
									</tr>
									<tr>
										<td>1</td>
										<td colspan=4>Introduction</td>
										<td>
											<select class="form-control points_epi cust_score" name="data[Introduction]" disabled="">
												<option ds_val=2.8 value="Yes" <?php echo $$dataDetails['Introduction']=="Yes"?"selected":""; ?> >Yes</option>
												<option ds_val=2.8 value="No" <?php echo $$dataDetails['Introduction']=="No"?"selected":""; ?> >No</option>
												<option ds_val=2.8 value="N/A" <?php echo $$dataDetails['Introduction']=="N/A"?"selected":""; ?> >N/A</option>
											</select>
											</td>
											
										<td colspan=2><input type="text" class="form-control" name="data[cmt1]" disabled></td>
									</tr>
									<tr>
										<td>2</td>
										<td colspan=4>Obtaining Customer' Needs</td>
										<td>
											<select class="form-control points_epi cust_score"  name="data[active_listening]" disabled>
												<option ds_val=7 value="Yes" <?php echo $$dataDetails['active_listening']=="Yes"?"selected":""; ?> >Yes</option>
												<option ds_val=7 value="No" <?php echo $$dataDetails['active_listening']=="No"?"selected":""; ?> >No</option>
												<option ds_val=7 value="N/A" <?php echo $$dataDetails['active_listening']=="N/A"?"selected":""; ?> >N/A</option>
											</select>
										</td>
										
										<td colspan=2><input type="text" class="form-control" name="data[cmt2]" disabled></td>
									</tr>
									<tr>
										<td>3</td>
										<td colspan=4>Questioning</td>
										<td>
											<select class="form-control points_epi cust_score"  name="data[questioning]" disabled>
												<option ds_val=8.4 value="Yes" <?php echo $$dataDetails['questioning']=="Yes"?"selected":""; ?> >Yes</option>
												<option ds_val=8.4 value="No" <?php echo $$dataDetails['questioning']=="No"?"selected":""; ?> >No</option>
												<option ds_val=8.4 value="N/A" <?php echo $$dataDetails['questioning']=="N/A"?"selected":""; ?> >N/A</option>
											</select>
										</td>
										
									<td colspan=2><input type="text" class="form-control" name="data[cmt3]" disabled></td></tr>
									<tr>
										<td>4</td>
										<td colspan=4>Presentation</td>
										<td>
											<select class="form-control points_epi busi_score"  name="data[presentation]" disabled>
												<option ds_val=8.4 value="Yes" <?php echo $$dataDetails['presentation']=="Yes"?"selected":""; ?> >Yes</option>
												<option ds_val=8.4 value="No" <?php echo $$dataDetails['presentation']=="No"?"selected":""; ?> >No</option>
												<option ds_val=8.4 value="N/A" <?php echo $$dataDetails['presentation']=="N/A"?"selected":""; ?> >N/A</option>
											</select>
										</td>
										
									<td colspan=2><input type="text" class="form-control" name="data[cmt4]" disabled></td></tr>
									<tr>
										<td>5</td>
										<td colspan=4>Closing the Sale</td>
										<td>
											<select class="form-control points_epi busi_score"  name="data[closing_sale]" disabled>
												<option ds_val=7 value="Yes" <?php echo $$dataDetails['closing_sale']=="Yes"?"selected":""; ?> >Yes</option>
												<option ds_val=7 value="No" <?php echo $$dataDetails['closing_sale']=="No"?"selected":""; ?> >No</option>
												<option ds_val=7 value="N/A" <?php echo $$dataDetails['closing_sale']=="N/A"?"selected":""; ?> >N/A</option>
											</select>
										</td>
										
									<td colspan=2><input type="text" class="form-control" name="data[cmt5]" disabled></td></tr>
									<tr>
										<td rowspan=3>6</td>
										<td rowspan=3 style="font-weight:bold">Add On</td>
										<td colspan=3>CPP</td>
										<td>
											<select class="form-control points_epi busi_score"  name="data[add_cpp]" disabled>
												<option ds_val=7 value="Yes" <?php echo $$dataDetails['add_cpp']=="Yes"?"selected":""; ?> >Yes</option>
												<option ds_val=7 value="No" <?php echo $$dataDetails['add_cpp']=="No"?"selected":""; ?> >No</option>
												<option ds_val=7 value="N/A" <?php echo $$dataDetails['add_cpp']=="N/A"?"selected":""; ?> >N/A</option>
											</select>
										</td>
										
									<td colspan=2><input type="text" class="form-control" name="data[cmt6]" disabled></td></tr>
									<tr>
										<td colspan=3>Related Parts / Parts Tray </td>
										<td>
											<select class="form-control points_epi busi_score"  name="data[add_parts]" disabled>
												<option ds_val=7 value="Yes" <?php echo $$dataDetails['add_parts']=="Yes"?"selected":""; ?> >Yes</option>
												<option ds_val=7 value="No" <?php echo $$dataDetails['add_parts']=="No"?"selected":""; ?> >No</option>
												<option ds_val=7 value="N/A" <?php echo $$dataDetails['add_parts']=="N/A"?"selected":""; ?> >N/A</option>
											</select>
										</td>
										
									<td colspan=2><input type="text" class="form-control" name="data[cmt7]" disabled></td></tr>
									<tr>
										<td colspan=3>RepairPal</td>
										<td>
											<select class="form-control points_epi busi_score"  name="data[RepairPal]" disabled>
												<option ds_val=3.5 value="Yes" <?php echo $$dataDetails['RepairPal']=="Yes"?"selected":""; ?> >Yes</option>
												<option ds_val=3.5 value="No" <?php echo $$dataDetails['RepairPal']=="No"?"selected":""; ?> >No</option>
												<option ds_val=3.5 value="N/A" <?php echo $$dataDetails['RepairPal']=="N/A"?"selected":""; ?> >N/A</option>
											</select>
										</td>
										
									<td colspan=2><input type="text" class="form-control" name="data[cmt8]" disabled></td></tr>
									<tr>
										<td>7</td>
										<td colspan=4>Shipping Options / Shipping Details</td>
										<td>
											<select class="form-control points_epi busi_score"  name="data[shipping_options]" disabled>
												<option ds_val=4.2 value="Yes" <?php echo $$dataDetails['shipping_options']=="Yes"?"selected":""; ?> >Yes</option>
												<option ds_val=4.2 value="No" <?php echo $$dataDetails['shipping_options']=="No"?"selected":""; ?> >No</option>
												<option ds_val=4.2 value="N/A" <?php echo $$dataDetails['shipping_options']=="N/A"?"selected":""; ?> >N/A</option>
											</select>
										</td>
										
									<td colspan=2><input type="text" class="form-control" name="data[cmt9]" disabled></td></tr>
									<tr>
										<td rowspan=2>8</td>
										<td rowspan=2 style="font-weight:bold">Recap & Tracking Email</td>
										<td colspan=3>Shipping & Billing / YMMSE / Part Name(s)</td>
										<td>
											<select class="form-control points_epi busi_score"  name="data[shipping_billing]" disabled>
												<option ds_val=2.8 value="Yes" <?php echo $$dataDetails['shipping_billing']=="Yes"?"selected":""; ?> >Yes</option>
												<option ds_val=2.8 value="No" <?php echo $$dataDetails['shipping_billing']=="No"?"selected":""; ?> >No</option>
												<option ds_val=2.8 value="N/A" <?php echo $$dataDetails['shipping_billing']=="N/A"?"selected":""; ?> >N/A</option>
											</select>
										</td>
										
									<td colspan=2><input type="text" class="form-control" name="data[cmt10]" disabled></td></tr>
									<tr>
										<td colspan=3>Tracking Email</td>
										<td>
											<select class="form-control points_epi busi_score"  name="data[tracking_email_recap]" disabled>
												<option ds_val=2.8 value="Yes" <?php echo $$dataDetails['tracking_email_recap']=="Yes"?"selected":""; ?> >Yes</option>
												<option ds_val=2.8 value="No" <?php echo $$dataDetails['tracking_email_recap']=="No"?"selected":""; ?> >No</option>
												<option ds_val=2.8 value="N/A" <?php echo $$dataDetails['tracking_email_recap']=="N/A"?"selected":""; ?> >N/A</option>
											</select>
										</td>
										
									<td colspan=2><input type="text" class="form-control" name="data[cmt11]" disabled></td></tr>
									
									
									<tr>
										<td rowspan=3>9</td>
										<td rowspan=3 style="font-weight:bold">Closing Script</td>
										<td colspan=3>Asking / Offering for additional assistance</td>
										<td>
											<select class="form-control points_epi busi_score"  name="data[additional_assistance]" disabled>
												<option ds_val=2.8 value="Yes" <?php echo $$dataDetails['additional_assistance']=="Yes"?"selected":""; ?> >Yes</option>
												<option ds_val=2.8 value="No" <?php echo $$dataDetails['additional_assistance']=="No"?"selected":""; ?> >No</option>
												<option ds_val=2.8 value="N/A" <?php echo $$dataDetails['additional_assistance']=="N/A"?"selected":""; ?> >N/A</option>
											</select>
										</td>
										
									<td colspan=2><input type="text" class="form-control" name="data[cmt12]" disabled></td></tr>
									<tr>
										<td colspan=3>CSAT / NPS Survey</td>
										<td>
											<select class="form-control points_epi busi_score"  name="data[NPS_survey]" disabled>
												<option ds_val=3.5 value="Yes" <?php echo $$dataDetails['NPS_survey']=="Yes"?"selected":""; ?> >Yes</option>
												<option ds_val=3.5 value="No" <?php echo $$dataDetails['NPS_survey']=="No"?"selected":""; ?> >No</option>
												<option ds_val=3.5 value="N/A" <?php echo $$dataDetails['NPS_survey']=="N/A"?"selected":""; ?> >N/A</option>
											</select>
										</td>
										
									<td colspan=2><input type="text" class="form-control" name="data[cmt13]" disabled></td></tr>
									<tr>
										<td colspan=3>Rebranding</td>
										<td>
											<select class="form-control points_epi busi_score"  name="data[rebranding_new]" disabled>
												<option ds_val=2.8 value="Yes" <?php echo $$dataDetails['rebranding_new']=="Yes"?"selected":""; ?> >Yes</option>
												<option ds_val=2.8 value="No" <?php echo $$dataDetails['rebranding_new']=="No"?"selected":""; ?> >No</option>
												<option ds_val=2.8 value="N/A" <?php echo $$dataDetails['rebranding_new']=="N/A"?"selected":""; ?> >N/A</option>
											</select>
										</td>
										
									<td colspan=2><input type="text" class="form-control" name="data[cmt14]" disabled></td></tr>
									
									<tr><td class="eml1" colspan=8>PROCESS ADHERENCE</td></tr>
									<tr>
										<td>10</td>
										<td colspan=4>Discount Rules</td>
										<td>
											<select class="form-control points_pa busi_score"  name="data[discount_rules]" disabled>
												<option ds_val=10 value="Yes" <?php echo $$dataDetails['discount_rules']=="Yes"?"selected":""; ?> >Yes</option>
												<option ds_val=10 value="No" <?php echo $$dataDetails['discount_rules']=="No"?"selected":""; ?> >No</option>
												<option ds_val=10 value="N/A" <?php echo $$dataDetails['discount_rules']=="N/A"?"selected":""; ?> >N/A</option>
											</select>
										</td>
										
									<td colspan=2><input type="text" class="form-control" name="data[cmt15]" disabled></td></tr>
									<tr>
										<td rowspan=3>11</td>
										<td rowspan=3 style="font-weight:bold">Account Verification</td>
										<td colspan=3>"MyAccount" utilization</td>
										<td>
											<select class="form-control points_pa comp_score"  name="data[account_verification]" disabled>
												<option ds_val=2.5 value="Yes" <?php echo $$dataDetails['account_verification']=="Yes"?"selected":""; ?> >Yes</option>
												<option ds_val=2.5 value="No" <?php echo $$dataDetails['account_verification']=="No"?"selected":""; ?> >No</option>
												<option ds_val=2.5 value="N/A" <?php echo $$dataDetails['account_verification']=="N/A"?"selected":""; ?> >N/A</option>
											</select>
										</td>
										
									<td colspan=2><input type="text" class="form-control" name="data[cmt16]" disabled></td></tr>
									<tr>
										<td colspan=3>Data Gathering Compliance</td>
										<td>
											<select class="form-control points_pa comp_score"  name="data[data_gathering]" disabled>
												<option ds_val=2.5 value="Yes" <?php echo $$dataDetails['data_gathering']=="Yes"?"selected":""; ?> >Yes</option>
												<option ds_val=2.5 value="No" <?php echo $$dataDetails['data_gathering']=="No"?"selected":""; ?> >No</option>
												<option ds_val=2.5 value="N/A" <?php echo $$dataDetails['data_gathering']=="N/A"?"selected":""; ?> >N/A</option>
											</select>
										</td>
										
									<td colspan=2><input type="text" class="form-control" name="data[cmt17]" disabled></td></tr>
									<tr>
										<td colspan=3>Accuracy</td>
										<td>
											<select class="form-control points_pa comp_score"  name="data[account_accuracy]" disabled>
												<option ds_val=3.75 value="Yes" <?php echo $$dataDetails['account_accuracy']=="Yes"?"selected":""; ?> >Yes</option>
												<option ds_val=3.75 value="No" <?php echo $$dataDetails['account_accuracy']=="No"?"selected":""; ?> >No</option>
												<option ds_val=3.75 value="N/A" <?php echo $$dataDetails['account_accuracy']=="N/A"?"selected":""; ?> >N/A</option>
											</select>
										</td>
										
									<td colspan=2><input type="text" class="form-control" name="data[cmt18]" disabled></td></tr>
									<tr>
										<td>12</td>
										<td colspan=4>Documentation</td>
										<td>
											<select class="form-control points_pa busi_score"  name="data[documentation]" disabled>
												<option ds_val=2.5 value="Yes" <?php echo $$dataDetails['documentation']=="Yes"?"selected":""; ?> >Yes</option>
												<option ds_val=2.5 value="No" <?php echo $$dataDetails['documentation']=="No"?"selected":""; ?> >No</option>
												<option ds_val=2.5 value="N/A" <?php echo $$dataDetails['documentation']=="N/A"?"selected":""; ?> >N/A</option>
											</select>
										</td>
										
									<td colspan=2><input type="text" class="form-control" name="data[cmt19]" disabled></td></tr>

									<tr>
										<td>13</td>
										<td colspan=4>Hold Time</td>
										<td>
											<select class="form-control points_pa busi_score"  name="data[hold_time]" disabled>
												<option ds_val=3.75 value="Yes" <?php echo $$dataDetails['hold_time']=="Yes"?"selected":""; ?> >Yes</option>
												<option ds_val=3.75 value="No" <?php echo $$dataDetails['hold_time']=="No"?"selected":""; ?> >No</option>
												<option ds_val=3.75 value="N/A" <?php echo $$dataDetails['hold_time']=="N/A"?"selected":""; ?> >N/A</option>
											</select>
										</td>
										
									<td colspan=2><input type="text" class="form-control" name="data[cmt20]" disabled></td></tr>

									<tr><td class="eml1" colspan=8>SOFT SKILLS 5%</td></tr>
									<tr>
										<td rowspan=1>14</td>
										<td colspan=4>Overcoming Objections</td>
										<td>
											<select class="form-control points_pa busi_score"  name="data[Overcoming_Objections]" disabled>
												<option ds_val=5 value="Yes" <?php echo $$dataDetails['Overcoming_Objections']=="Yes"?"selected":""; ?> >Yes</option>
												<option ds_val=5 value="No" <?php echo $$dataDetails['Overcoming_Objections']=="No"?"selected":""; ?> >No</option>
												<option ds_val=5 value="N/A" <?php echo $$dataDetails['Overcoming_Objections']=="N/A"?"selected":""; ?> >N/A</option>
											</select>
										</td>
										
									<td colspan=2><input type="text" class="form-control" name="data[cmt21]" disabled></td></tr>
									<tr>
										<td colspan="3">Call Summary:</td>
										<td colspan="6"><textarea class="form-control" id="call_summary" name="data[call_summary]" disabled><?php echo $$dataDetails['call_summary'] ?></textarea></td>
									</tr>
									<tr>
										<td colspan="3">Feedback:</td>
										<td colspan="6"><textarea class="form-control" id="feedback" name="data[feedback]" disabled><?php echo $$dataDetails['feedback'] ?></textarea></td>
									</tr>
									
									<?php if($$dataDetails['attach_file']!=''){ ?>
									<tr oncontextmenu="return false;">
										<td colspan="3">Audio Files</td>
										<td colspan="6">
											<?php $attach_file = explode(",",$$dataDetails['attach_file']);
											 foreach($attach_file as $af){ ?>
												<audio controls='' controlsList="nodownload" style="background-color:#607F93">
													  <source src="<?php echo base_url(); ?>qa_files/qa_<?php echo $page ?>/<?php echo $af; ?>" type="audio/ogg">
													  <source src="<?php echo base_url(); ?>qa_files/qa_<?php echo $page ?>/<?php echo $af; ?>" type="audio/mpeg">
												</audio> </br>
											 <?php } ?>
										</td>
									</tr>
									<?php } ?>
									<tr><td colspan="9" style="background-color:#C5C8C8"></td></tr>
									
									<tr><td style="font-size:16px" colspan="2">Manager Review:</td> <td colspan="7" style="text-align:left" disabled><?php echo $$dataDetails['mgnt_rvw_note'] ?></td></tr>
									<tr><td style="font-size:16px" colspan="2" disabled>Client Review:</td> <td colspan="7" style="text-align:left"><?php echo $$dataDetails['client_rvw_note'] ?></td></tr>
									<!-- <tr><td style="font-size:16px">Your Review:</td> <td colspan="5" style="text-align:left"><?php echo $$dataDetails['agent_rvw_note']; ?></td></tr> -->
									
									<tr><td colspan="9" style="background-color:#C5C8C8"></td></tr>
									
									 <form id="form_agent_user" method="POST" action="">
										<tr>
											<td colspan="3"  style="font-size:16px">Your Review
												<input type="hidden" name="pnid" class="form-control" value="<?php echo $pnid; ?>">
											</td>
											<td colspan="6"><textarea class="form-control" name="note" required=""><?php echo $$dataDetails['agent_rvw_note'] ?></textarea></td>
										</tr>
										
										<?php if(is_access_qa_agent_module()==true){
										if(is_available_qa_feedback($$dataDetails['entry_date'],72) == true){ ?>
											<tr>
												<?php if($$dataDetails['agent_rvw_note']==''){ ?>
													<td colspan="9"><button class="btn btn-success waves-effect" type="submit" id='btnagentSave' name='btnSave' value="SAVE" style="width:500px">SAVE</button></td>
												<?php } ?>
											</tr>
										<?php } 
										} ?>
									
									  </form>
								</tbody>
							</table>
						</div>
					</div>


				<?php }else if($campaign=='inbound2'){ ?>
				
					<div class="widget-body">
						<div class="table-responsive">
							<table class="table table-striped skt-table" width="100%" oncontextmenu="return false;">
								<tbody>
									<tr style="background-color:#AEB6BF">
										<td colspan="9" id="theader" style="font-size:30px">Inbound (Version 2)</td>
										<input type="hidden" name="pnid" value="<?php echo $pnid; ?>">
									</tr>
										
									<tr>
										<td colspan="1">QA Name:</td>
										<?php 
										$dataDetails=$page."_agnt_feedback";
										if($$dataDetails['entry_by']!=''){
												$auditorName = $$dataDetails['auditor_name'];
											}else{
												$auditorName = $$dataDetails['client_name'];
										} ?>
										<td colspan="2"><input type="text" class="form-control" value="<?php echo $auditorName; ?>" disabled></td>
										<td colspan="1">Audit Date:</td>
										<td colspan="2"><input type="text" class="form-control" value="<?php echo mysql2mmddyy($$dataDetails['audit_date']); ?>" disabled></td>
										<td colspan="1">Call Id.:</td>
										<td colspan="2"><input type="text" class="form-control" id="call_id" name="data[call_id]" value="<?php echo $$dataDetails['call_id'] ?>" disabled></td>
									</tr>
									<tr>
										<td colspan="1">Agent:</td>
										<td colspan="2">
											<select class="form-control" id="agent_id" name="data[agent_id]" disabled>
												<option value="<?php echo $$dataDetails['agent_id'] ?>"><?php echo $$dataDetails['fname']." ".$$dataDetails['lname'] ?></option>
												<option value="">-Select-</option>
												<?php foreach($agentName as $row):  ?>
													<option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
												<?php endforeach; ?>
											</select>
										</td>
										<td colspan="1">Fusion ID:</td>
										<td colspan="2"><input type="text" disabled class="form-control" id="fusion_id" value="<?php echo $$dataDetails['fusion_id'] ?>"></td>
										<td colspan="1">L1 Supervisor:</td>
										<td colspan="2">
											<select class="form-control" id="tl_id" name="data[tl_id]"  disabled>
												<option value="<?php echo $$dataDetails['tl_id'] ?>"><?php echo $$dataDetails['tl_name'] ?></option>
												<option value="">--Select--</option>
												<?php foreach($tlname as $tl): ?>
													<option value="<?php echo $tl['id']; ?>"><?php echo $tl['fname']." ".$tl['lname']; ?></option>
												<?php endforeach; ?>	
											</select>
										</td>
									</tr>
									<tr>
										<td style="font-weight:bold" colspan="1">Call_type:</td>
										<td colspan="2"><input type="text" class="form-control"  name="data[call_type]" value="<?php echo $$dataDetails['call_type'] ?>"  disabled></td>
										<td colspan="1">Contact Date:</td>
										<td colspan="2"><input type="text" class="form-control" id="call_date" name="call_date" value="<?php echo mysql2mmddyy($$dataDetails['call_date']) ?>" disabled></td>
										<td colspan="1">Contact Duration:</td>
										<td colspan="2"><input type="text" class="form-control" id="call_duration" name="data[call_duration]" value="<?php echo $$dataDetails['call_duration'] ?>" disabled></td>
									</tr>
									<tr>
										<td colspan="1">Audit Type:</td>
										<td colspan="2">
											<select class="form-control" id="audit_type" name="data[audit_type]" disabled>
												<option value="<?php echo $$dataDetails['audit_type'] ?>"><?php echo $$dataDetails['audit_type'] ?></option>
												<option value="">-Select-</option>
												<option value="CQ Audit">CQ Audit</option>
												<option value="BQ Audit">BQ Audit</option>
												<option value="Calibration">Calibration</option>
												<option value="Pre-Certification Mock Call">Pre-Certification Mock Call</option>
												<option value="Certification Audit">Certification Audit</option>
											</select>
										</td>
										<td class="auType_epi" colspan="1">Auditor Type</td>
										<td class="auType_epi" colspan="2">
											<select class="form-control" id="auditor_type" name="data[auditor_type]" disabled>
												<option value="">-Select-</option>
												<option <?php echo $$dataDetails['auditor_type']=='Master'?"selected":""; ?> value="Master">Master</option>
												<option <?php echo $$dataDetails['auditor_type']=='Regular'?"selected":""; ?> value="Regular">Regular</option>
											</select>
										</td>
										<td colspan="1">VOC:</td>
										<td colspan="2">
											<select class="form-control" id="voc" name="data[voc]"  disabled>
												<option value="<?php echo $$dataDetails['voc'] ?>"><?php echo $$dataDetails['voc'] ?></option>
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
										<td style="font-weight:bold" colspan="1">Auto Fail:</td>
										<td colspan="2"><select class="form-control fatal_epi" id="auto_fail" name="data[auto_fail]"  disabled>
												<option value="<?php echo $$dataDetails['auto_fail'] ?>"><?php echo $$dataDetails['auto_fail'] ?></option>
												<option value="No">No</option>
												<option value="Yes">Yes</option>
											</select>
										</td>
										<td colspan="1">Sales Call Type:</td>
										<td colspan="2">
											<select class="form-control" id="sales_call_type" name="data[sales_call_type]" disabled>
												<option value="<?php echo $$dataDetails['sales_call_type'] ?>"><?php echo $$dataDetails['sales_call_type'] ?></option>
												<option value="">-Select-</option>
												<option value="Closed Sale">Closed Sale</option>
												<option value="Non-Sale">Non-Sale</option>
											</select>
										</td>
										<td class="nonSale_epi" colspan="1">Non-Sale</td>
										<td class="nonSale_epi" colspan="2">
											<select class="form-control" id="nonSale" name="data[nonSale]" disabled>
												<option value="">-Select-</option>
												<option value="CPP Price Objection" <?php echo( $$dataDetails['nonSale']=="CPP Price Objection")?"selected":"" ?>>CPP Price Objection</option>
												<option value="Customer Hang-up" <?php echo($$dataDetails['nonSale']=="Customer Hang-up")?"selected":""?> >Customer Hang-up </option>
												<option value="Delivery Time Frame Issue" <?php echo($$dataDetails['nonSale']=="Delivery Time Frame Issue")?"selected":""?> >Delivery Time Frame Issue</option>
												<option value="Did Not Carry" <?php echo($$dataDetails['nonSale']=="Did Not Carry")?"selected":""?> >Did Not Carry</option>
												<option value="Drop / Ghost Calls" <?php echo($$dataDetails['nonSale']=="Drop / Ghost Calls")?"selected":""?> >Drop / Ghost Calls</option>
												<option value="Marketing Promotions" <?php echo($$dataDetails['nonSale']=="Marketing Promotions")?"selected":""?> >Marketing Promotions</option>
												<option value="Out of Stock" <?php echo($$dataDetails['nonSale']=="Out of Stock")?"selected":""?> >Out of Stock</option>
												<option value="Post Sale Issue or CS Concern" <?php echo($$dataDetails['nonSale']=="Post Sale Issue or CS Concern")?"selected":""?> >Post Sale Issue or CS Concern</option>
												<option value="Price Part Objection" <?php echo($$dataDetails['nonSale']=="Price Part Objection")?"selected":""?> >Price Part Objection</option>
												<option value="Sales Inquiry (Caller is inquiring for somebody)" <?php echo($$dataDetails['nonSale']=="Sales Inquiry (Caller is inquiring for somebody)")?"selected":""?> >Sales Inquiry (Caller is inquiring for somebody)</option>
												<option value="Sales Inquiry (CX will check with Mechanic first)" <?php echo($$dataDetails['nonSale']=="Sales Inquiry (CX will check with Mechanic first)")?"selected":""?> >Sales Inquiry (CX will check with Mechanic first)</option>
												<option value="Sales Inquiry (No email address)" <?php echo($$dataDetails['nonSale']=="Sales Inquiry (No email address)")?"selected":""?> >Sales Inquiry (No email address)</option>
												<option value="Sales Inquiry (No funds yet)" <?php echo($$dataDetails['nonSale']=="Sales Inquiry (No funds yet)")?"selected":""?> >Sales Inquiry (No funds yet)</option>
												<option value="Same Month CC Expiry" <?php echo($$dataDetails['nonSale']=="Same Month CC Expiry")?"selected":""?> >Same Month CC Expiry</option>
												<option value="Shipping Cost" <?php echo($$dataDetails['nonSale']=="Shipping Cost")?"selected":""?> >Shipping Cost</option>
												<option value="Technical Fit Notes" <?php echo($$dataDetails['nonSale']=="Technical Fit Notes")?"selected":""?> >Technical Fit Notes</option>
											</select>
										</td>
										
									</tr>
									<tr>
										<td>Sampling:</td>
										<td><input type="text" class="form-control" id="" name="data[qa_sampling]" value="<?php echo $$dataDetails['qa_sampling'] ?>" disabled></td>
										<td>Order Number:</td>
										<td><input type="text" class="form-control" id="" name="data[order_no]" value="<?php echo $$dataDetails['order_no'] ?>" disabled></td>
										<td>NPS:</td>
										<td><input type="text" class="form-control" id="" name="data[nps]" value="<?php echo $$dataDetails['nps'] ?>" disabled></td>
									<tr>
										<td>CSAT:</td>
										<td><input type="text" class="form-control" id="" name="data[csat]" value="<?php echo $$dataDetails['csat'] ?>" disabled></td>
										<td>20% Deduction:</td>
										<td colspan=2>
											<select class="form-control deduct_20_perc" id="deduct_20_perc" name="data[deduction_20_percent]" disabled>
												<option value="">Select</option>
												<option value="Yes" <?php echo $$dataDetails['deduction_20_percent']=="Yes"?"selected":""; ?>>Yes</option>
												<option value="No" <?php echo $$dataDetails['deduction_20_percent']=="No"?"selected":""; ?> >No</option>
											</select>
										</td>
									</tr>										
										<td style="font-size:18px; font-weight:bold" colspan="1">Earned Score</td>
										<td style="font-size:18px; font-weight:bold" colspan="2"><input type="text" readonly class="form-control" id="earnedScore" name="data[earned_score]" value="" disabled></td>
										<td style="font-size:18px; font-weight:bold" colspan="1">Possible Score</td>
										<td style="font-size:18px; font-weight:bold" colspan="2"><input type="text" readonly class="form-control" id="possibleScore" name="data[possible_score]" value="" disabled></td>
										<td style="font-size:18px; font-weight:bold" colspan="1">Overall Score:</td>
										<td style="font-size:18px; font-weight:bold" colspan="2"><input type="text" readonly class="form-control" id="overallScore" name="data[overall_score]" value="<?php echo $$dataDetails['overall_score'] ?>" disabled></td>
									</tr>
									<tr>
										<td style="font-size:18px; font-weight:bold" colspan="1">Customer Score</td>
										<td style="font-size:18px; font-weight:bold" colspan="2"><input type="text" readonly class="form-control" id="custScore" name="data[cust_score]" value="<?php echo $$dataDetails['cust_score'] ?>" readonly></td><td style="font-size:18px; font-weight:bold" colspan="1">Business Score</td>
										<td style="font-size:18px; font-weight:bold" colspan="2"><input type="text" readonly class="form-control" id="busiScore" name="data[busi_score]" value="<?php echo $$dataDetails['busi_score'] ?>" readonly></td>
										<td style="font-size:18px; font-weight:bold" colspan="1">Compliance Score:</td>
										<td style="font-size:18px; font-weight:bold" colspan="2"><input type="text" readonly class="form-control" id="compScore" name="data[comp_score]" value="<?php echo $$dataDetails['comp_score'] ?>" readonly></td>
									</tr>
									
									<tr style="height:45px">
										<td class="eml2">Category</td>
										<td class="eml2" colspan=4>Sub Category</td>
										<td class="eml2" style="width:150px">Status</td>
										<td class="eml2" colspan=4>Remarks</td>
									</tr>
									<tr>
										<td>1</td>
										<td colspan=4>Introduction</td>
										<td>
											<select class="form-control points_epi cust_score" name="data[Introduction]" disabled="">
												<option ds_val=2.8 value="Yes" <?php echo $$dataDetails['Introduction']=="Yes"?"selected":""; ?> >Yes</option>
												<option ds_val=2.8 value="No" <?php echo $$dataDetails['Introduction']=="No"?"selected":""; ?> >No</option>
												<option ds_val=2.8 value="N/A" <?php echo $$dataDetails['Introduction']=="N/A"?"selected":""; ?> >N/A</option>
											</select>
											</td>
											
										<td colspan=2><input type="text" class="form-control" name="data[cmt1]" disabled></td>
									</tr>
									<tr>
										<td>2</td>
										<td colspan=4>Obtaining Customer' Needs</td>
										<td>
											<select class="form-control points_epi cust_score"  name="data[active_listening]" disabled>
												<option ds_val=7 value="Yes" <?php echo $$dataDetails['active_listening']=="Yes"?"selected":""; ?> >Yes</option>
												<option ds_val=7 value="No" <?php echo $$dataDetails['active_listening']=="No"?"selected":""; ?> >No</option>
												<option ds_val=7 value="N/A" <?php echo $$dataDetails['active_listening']=="N/A"?"selected":""; ?> >N/A</option>
											</select>
										</td>
										
										<td colspan=2><input type="text" class="form-control" name="data[cmt2]" disabled></td>
									</tr>
									<tr>
										<td>3</td>
										<td colspan=4>Questioning</td>
										<td>
											<select class="form-control points_epi cust_score"  name="data[questioning]" disabled>
												<option ds_val=8.4 value="Yes" <?php echo $$dataDetails['questioning']=="Yes"?"selected":""; ?> >Yes</option>
												<option ds_val=8.4 value="No" <?php echo $$dataDetails['questioning']=="No"?"selected":""; ?> >No</option>
												<option ds_val=8.4 value="N/A" <?php echo $$dataDetails['questioning']=="N/A"?"selected":""; ?> >N/A</option>
											</select>
										</td>
										
									<td colspan=2><input type="text" class="form-control" name="data[cmt3]" disabled></td></tr>
									<tr>
										<td>4</td>
										<td colspan=4>Presentation</td>
										<td>
											<select class="form-control points_epi busi_score"  name="data[presentation]" disabled>
												<option ds_val=8.4 value="Yes" <?php echo $$dataDetails['presentation']=="Yes"?"selected":""; ?> >Yes</option>
												<option ds_val=8.4 value="No" <?php echo $$dataDetails['presentation']=="No"?"selected":""; ?> >No</option>
												<option ds_val=8.4 value="N/A" <?php echo $$dataDetails['presentation']=="N/A"?"selected":""; ?> >N/A</option>
											</select>
										</td>
										
									<td colspan=2><input type="text" class="form-control" name="data[cmt4]" disabled></td></tr>
									<tr>
										<td>5</td>
										<td colspan=4>Closing the Sale</td>
										<td>
											<select class="form-control points_epi busi_score"  name="data[closing_sale]" disabled>
												<option ds_val=7 value="Yes" <?php echo $$dataDetails['closing_sale']=="Yes"?"selected":""; ?> >Yes</option>
												<option ds_val=7 value="No" <?php echo $$dataDetails['closing_sale']=="No"?"selected":""; ?> >No</option>
												<option ds_val=7 value="N/A" <?php echo $$dataDetails['closing_sale']=="N/A"?"selected":""; ?> >N/A</option>
											</select>
										</td>
										
									<td colspan=2><input type="text" class="form-control" name="data[cmt5]" disabled></td></tr>
									<tr>
										<td rowspan=3>6</td>
										<td rowspan=3 style="font-weight:bold">Add On</td>
										<td colspan=3>CPP</td>
										<td>
											<select class="form-control points_epi busi_score"  name="data[add_cpp]" disabled>
												<option ds_val=7 value="Yes" <?php echo $$dataDetails['add_cpp']=="Yes"?"selected":""; ?> >Yes</option>
												<option ds_val=7 value="No" <?php echo $$dataDetails['add_cpp']=="No"?"selected":""; ?> >No</option>
												<option ds_val=7 value="N/A" <?php echo $$dataDetails['add_cpp']=="N/A"?"selected":""; ?> >N/A</option>
											</select>
										</td>
										
									<td colspan=2><input type="text" class="form-control" name="data[cmt6]" disabled></td></tr>
									<tr>
										<td colspan=3>Related Parts / Parts Tray </td>
										<td>
											<select class="form-control points_epi busi_score"  name="data[add_parts]" disabled>
												<option ds_val=7 value="Yes" <?php echo $$dataDetails['add_parts']=="Yes"?"selected":""; ?> >Yes</option>
												<option ds_val=7 value="No" <?php echo $$dataDetails['add_parts']=="No"?"selected":""; ?> >No</option>
												<option ds_val=7 value="N/A" <?php echo $$dataDetails['add_parts']=="N/A"?"selected":""; ?> >N/A</option>
											</select>
										</td>
										
									<td colspan=2><input type="text" class="form-control" name="data[cmt7]" disabled></td></tr>
									<tr>
										<td colspan=3>RepairPal</td>
										<td>
											<select class="form-control points_epi busi_score"  name="data[RepairPal]" disabled>
												<option ds_val=3.5 value="Yes" <?php echo $$dataDetails['RepairPal']=="Yes"?"selected":""; ?> >Yes</option>
												<option ds_val=3.5 value="No" <?php echo $$dataDetails['RepairPal']=="No"?"selected":""; ?> >No</option>
												<option ds_val=3.5 value="N/A" <?php echo $$dataDetails['RepairPal']=="N/A"?"selected":""; ?> >N/A</option>
											</select>
										</td>
										
									<td colspan=2><input type="text" class="form-control" name="data[cmt8]" disabled></td></tr>
									<tr>
										<td>7</td>
										<td colspan=4>Shipping Options / Shipping Details</td>
										<td>
											<select class="form-control points_epi busi_score"  name="data[shipping_options]" disabled>
												<option ds_val=4.2 value="Yes" <?php echo $$dataDetails['shipping_options']=="Yes"?"selected":""; ?> >Yes</option>
												<option ds_val=4.2 value="No" <?php echo $$dataDetails['shipping_options']=="No"?"selected":""; ?> >No</option>
												<option ds_val=4.2 value="N/A" <?php echo $$dataDetails['shipping_options']=="N/A"?"selected":""; ?> >N/A</option>
											</select>
										</td>
										
									<td colspan=2><input type="text" class="form-control" name="data[cmt9]" disabled></td></tr>
									<tr>
										<td rowspan=2>8</td>
										<td rowspan=2 style="font-weight:bold">Recap & Tracking Email</td>
										<td colspan=3>Shipping & Billing / YMMSE / Part Name(s)</td>
										<td>
											<select class="form-control points_epi busi_score"  name="data[shipping_billing]" disabled>
												<option ds_val=2.8 value="Yes" <?php echo $$dataDetails['shipping_billing']=="Yes"?"selected":""; ?> >Yes</option>
												<option ds_val=2.8 value="No" <?php echo $$dataDetails['shipping_billing']=="No"?"selected":""; ?> >No</option>
												<option ds_val=2.8 value="N/A" <?php echo $$dataDetails['shipping_billing']=="N/A"?"selected":""; ?> >N/A</option>
											</select>
										</td>
										
									<td colspan=2><input type="text" class="form-control" name="data[cmt10]" disabled></td></tr>
									<tr>
										<td colspan=3>Tracking Email</td>
										<td>
											<select class="form-control points_epi busi_score"  name="data[tracking_email_recap]" disabled>
												<option ds_val=2.8 value="Yes" <?php echo $$dataDetails['tracking_email_recap']=="Yes"?"selected":""; ?> >Yes</option>
												<option ds_val=2.8 value="No" <?php echo $$dataDetails['tracking_email_recap']=="No"?"selected":""; ?> >No</option>
												<option ds_val=2.8 value="N/A" <?php echo $$dataDetails['tracking_email_recap']=="N/A"?"selected":""; ?> >N/A</option>
											</select>
										</td>
										
									<td colspan=2><input type="text" class="form-control" name="data[cmt11]" disabled></td></tr>
									
									
									<tr>
										<td rowspan=3>9</td>
										<td rowspan=3 style="font-weight:bold">Closing Script</td>
										<td colspan=3>Asking / Offering for additional assistance</td>
										<td>
											<select class="form-control points_epi busi_score"  name="data[additional_assistance]" disabled>
												<option ds_val=2.8 value="Yes" <?php echo $$dataDetails['additional_assistance']=="Yes"?"selected":""; ?> >Yes</option>
												<option ds_val=2.8 value="No" <?php echo $$dataDetails['additional_assistance']=="No"?"selected":""; ?> >No</option>
												<option ds_val=2.8 value="N/A" <?php echo $$dataDetails['additional_assistance']=="N/A"?"selected":""; ?> >N/A</option>
											</select>
										</td>
										
									<td colspan=2><input type="text" class="form-control" name="data[cmt12]" disabled></td></tr>
									<tr>
										<td colspan=3>CSAT / NPS Survey</td>
										<td>
											<select class="form-control points_epi busi_score"  name="data[NPS_survey]" disabled>
												<option ds_val=3.5 value="Yes" <?php echo $$dataDetails['NPS_survey']=="Yes"?"selected":""; ?> >Yes</option>
												<option ds_val=3.5 value="No" <?php echo $$dataDetails['NPS_survey']=="No"?"selected":""; ?> >No</option>
												<option ds_val=3.5 value="N/A" <?php echo $$dataDetails['NPS_survey']=="N/A"?"selected":""; ?> >N/A</option>
											</select>
										</td>
										
									<td colspan=2><input type="text" class="form-control" name="data[cmt13]" disabled></td></tr>
									<tr>
										<td colspan=3>Rebranding</td>
										<td>
											<select class="form-control points_epi busi_score"  name="data[rebranding_new]" disabled>
												<option ds_val=2.8 value="Yes" <?php echo $$dataDetails['rebranding_new']=="Yes"?"selected":""; ?> >Yes</option>
												<option ds_val=2.8 value="No" <?php echo $$dataDetails['rebranding_new']=="No"?"selected":""; ?> >No</option>
												<option ds_val=2.8 value="N/A" <?php echo $$dataDetails['rebranding_new']=="N/A"?"selected":""; ?> >N/A</option>
											</select>
										</td>
										
									<td colspan=2><input type="text" class="form-control" name="data[cmt14]" disabled></td></tr>
									
									<tr><td class="eml1" colspan=8>PROCESS ADHERENCE</td></tr>
									<tr>
										<td>10</td>
										<td colspan=4>Discount Rules</td>
										<td>
											<select class="form-control points_pa busi_score"  name="data[discount_rules]" disabled>
												<option ds_val=10 value="Yes" <?php echo $$dataDetails['discount_rules']=="Yes"?"selected":""; ?> >Yes</option>
												<option ds_val=10 value="No" <?php echo $$dataDetails['discount_rules']=="No"?"selected":""; ?> >No</option>
												<option ds_val=10 value="N/A" <?php echo $$dataDetails['discount_rules']=="N/A"?"selected":""; ?> >N/A</option>
											</select>
										</td>
										
									<td colspan=2><input type="text" class="form-control" name="data[cmt15]" disabled></td></tr>
									<tr>
										<td rowspan=3>11</td>
										<td rowspan=3 style="font-weight:bold">Account Verification</td>
									</tr>
									<tr>
										<td colspan=3>Data Gathering Compliance</td>
										<td>
											<select class="form-control points_pa comp_score"  name="data[data_gathering]" disabled>
												<option ds_val=3.75 value="Yes" <?php echo $$dataDetails['data_gathering']=="Yes"?"selected":""; ?> >Yes</option>
												<option ds_val=3.75 value="No" <?php echo $$dataDetails['data_gathering']=="No"?"selected":""; ?> >No</option>
												<option ds_val=3.75 value="N/A" <?php echo $$dataDetails['data_gathering']=="N/A"?"selected":""; ?> >N/A</option>
											</select>
										</td>
										
									<td colspan=2><input type="text" class="form-control" name="data[cmt17]" disabled></td></tr>
									<tr>
										<td colspan=3>Accuracy</td>
										<td>
											<select class="form-control points_pa comp_score"  name="data[account_accuracy]" disabled>
												<option ds_val=5 value="Yes" <?php echo $$dataDetails['account_accuracy']=="Yes"?"selected":""; ?> >Yes</option>
												<option ds_val=5 value="No" <?php echo $$dataDetails['account_accuracy']=="No"?"selected":""; ?> >No</option>
												<option ds_val=5 value="N/A" <?php echo $$dataDetails['account_accuracy']=="N/A"?"selected":""; ?> >N/A</option>
											</select>
										</td>
										
									<td colspan=2><input type="text" class="form-control" name="data[cmt18]" disabled></td></tr>
									<tr>
										<td>12</td>
										<td colspan=4>Documentation</td>
										<td>
											<select class="form-control points_pa busi_score"  name="data[documentation]" disabled>
												<option ds_val=2.5 value="Yes" <?php echo $$dataDetails['documentation']=="Yes"?"selected":""; ?> >Yes</option>
												<option ds_val=2.5 value="No" <?php echo $$dataDetails['documentation']=="No"?"selected":""; ?> >No</option>
												<option ds_val=2.5 value="N/A" <?php echo $$dataDetails['documentation']=="N/A"?"selected":""; ?> >N/A</option>
											</select>
										</td>
										
									<td colspan=2><input type="text" class="form-control" name="data[cmt19]" disabled></td></tr>

									<tr>
										<td>13</td>
										<td colspan=4>Hold Time</td>
										<td>
											<select class="form-control points_pa busi_score"  name="data[hold_time]" disabled>
												<option ds_val=3.75 value="Yes" <?php echo $$dataDetails['hold_time']=="Yes"?"selected":""; ?> >Yes</option>
												<option ds_val=3.75 value="No" <?php echo $$dataDetails['hold_time']=="No"?"selected":""; ?> >No</option>
												<option ds_val=3.75 value="N/A" <?php echo $$dataDetails['hold_time']=="N/A"?"selected":""; ?> >N/A</option>
											</select>
										</td>
										
									<td colspan=2><input type="text" class="form-control" name="data[cmt20]" disabled></td></tr>

									<tr><td class="eml1" colspan=8>SOFT SKILLS 5%</td></tr>
									<tr>
										<td rowspan=1>14</td>
										<td colspan=4>Overcoming Objections</td>
										<td>
											<select class="form-control points_pa busi_score"  name="data[Overcoming_Objections]" disabled>
												<option ds_val=5 value="Yes" <?php echo $$dataDetails['Overcoming_Objections']=="Yes"?"selected":""; ?> >Yes</option>
												<option ds_val=5 value="No" <?php echo $$dataDetails['Overcoming_Objections']=="No"?"selected":""; ?> >No</option>
												<option ds_val=5 value="N/A" <?php echo $$dataDetails['Overcoming_Objections']=="N/A"?"selected":""; ?> >N/A</option>
											</select>
										</td>
										
									<td colspan=2><input type="text" class="form-control" name="data[cmt21]" disabled></td></tr>
									<tr>
										<td colspan="3">Call Summary:</td>
										<td colspan="6"><textarea class="form-control" id="call_summary" name="data[call_summary]" disabled><?php echo $$dataDetails['call_summary'] ?></textarea></td>
									</tr>
									<tr>
										<td colspan="3">Feedback:</td>
										<td colspan="6"><textarea class="form-control" id="feedback" name="data[feedback]" disabled><?php echo $$dataDetails['feedback'] ?></textarea></td>
									</tr>
									
									<?php if($$dataDetails['attach_file']!=''){ ?>
									<tr oncontextmenu="return false;">
										<td colspan="3">Audio Files</td>
										<td colspan="6">
											<?php $attach_file = explode(",",$$dataDetails['attach_file']);
											 foreach($attach_file as $af){ ?>
												<audio controls='' controlsList="nodownload" style="background-color:#607F93">
													  <source src="<?php echo base_url(); ?>qa_files/qa_<?php echo $page ?>/<?php echo $af; ?>" type="audio/ogg">
													  <source src="<?php echo base_url(); ?>qa_files/qa_<?php echo $page ?>/<?php echo $af; ?>" type="audio/mpeg">
												</audio> </br>
											 <?php } ?>
										</td>
									</tr>
									<?php } ?>
									<tr><td colspan="9" style="background-color:#C5C8C8"></td></tr>
									
									<tr><td style="font-size:16px" colspan="2">Manager Review:</td> <td colspan="7" style="text-align:left" disabled><?php echo $$dataDetails['mgnt_rvw_note'] ?></td></tr>
									<tr><td style="font-size:16px" colspan="2" disabled>Client Review:</td> <td colspan="7" style="text-align:left"><?php echo $$dataDetails['client_rvw_note'] ?></td></tr>
									<!-- <tr><td style="font-size:16px">Your Review:</td> <td colspan="5" style="text-align:left"><?php echo $$dataDetails['agent_rvw_note']; ?></td></tr> -->
									
									<tr><td colspan="9" style="background-color:#C5C8C8"></td></tr>
									
									 <form id="form_agent_user" method="POST" action="">
										<tr>
											<td colspan="3"  style="font-size:16px">Your Review
												<input type="hidden" name="pnid" class="form-control" value="<?php echo $pnid; ?>">
											</td>
											<td colspan="6"><textarea class="form-control" name="note" required=""><?php echo $$dataDetails['agent_rvw_note'] ?></textarea></td>
										</tr>
										
										<?php if(is_access_qa_agent_module()==true){
										if(is_available_qa_feedback($$dataDetails['entry_date'],72) == true){ ?>
											<tr>
												<?php if($$dataDetails['agent_rvw_note']==''){ ?>
													<td colspan="9"><button class="btn btn-success waves-effect" type="submit" id='btnagentSave' name='btnSave' value="SAVE" style="width:500px">SAVE</button></td>
												<?php } ?>
											</tr>
										<?php } 
										} ?>
									
									  </form>
								</tbody>
							</table>
						</div>
					</div>
				
				<?php } ?>
					
					
				</div>	
			</div>
		</div>

	</section>
</div>