
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

				  <form id="form_audit_user" method="POST" action="" enctype="multipart/form-data">
					<div class="widget-body">
					 	<div class="table-responsive">
							<table class="table table-striped skt-table" width="100%">
								<tbody>
									<tr style="background-color:#AEB6BF"><td colspan="9" id="theader" style="font-size:30px">
									<?php $page_tilte=explode("_", $page);
									echo ucfirst($page_tilte[0]); ?> Inbound QA Form (Version 2)</td></tr>
									<input type="hidden" name="data[audit_start_time]" value="<?php echo $stratAuditTime; ?>">
									<tr>
										<td colspan="1">QA Name:</td>
										<td colspan="2"><input type="text" class="form-control" value="<?php echo get_username(); ?>" disabled></td>
										<td colspan="1">Audit Date:</td>
										<td colspan="2"><input type="text" name="data[audit_date]" class="form-control" value="<?php echo CurrDateMDY(); ?>" disabled>
										</td>
										<td colspan="1">Call Id.:</td>
										<td colspan="2"><input type="text" class="form-control" id="call_id" name="data[call_id]"  required></td>
									</tr>
									<tr>
										<td colspan="1">Agent:</td>
										<td  colspan="2">
											<select class="form-control" id="agent_id" name="data[agent_id]" required>
												<option value="">-Select-</option>
												<?php foreach($agentName as $row):  ?>
													<option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
												<?php endforeach; ?>
											</select>
										</td>
										<td colspan="1">Fusion ID:</td>
										<td colspan="2"><input type="text" class="form-control" id="fusion_id" disabled></td> 
										<td colspan="1">L1 Supervisor:</td>
										<td  colspan="2">
											<select class="form-control" readonly id="tl_id" name="data[tl_id]" required>
												<option value="">--Select--</option>
												<?php foreach($tlname as $tl): ?>
													<option value="<?php echo $tl['id']; ?>"><?php echo $tl['fname']." ".$tl['lname']; ?></option>
												<?php endforeach; ?>	
											</select>
										</td>
									</tr>
									<tr>
										<td colspan="1">Call_type:</td>
										<td colspan="2"><input type="text" class="form-control"  name="data[call_type]" required></td>
										<td colspan="1">Contact Date:</td>
										<td colspan="2"><input type="text" class="form-control" id="call_date" name="call_date" required></td>
										<td colspan="1">Contact Duration:</td>
										<td colspan="2"><input type="text" class="form-control" id="call_duration" name="data[call_duration]" required></td>
									</tr>
									<tr>
										<td colspan="1">Audit Type:</td>
										<td colspan="2">
											<select class="form-control" id="audit_type" name="data[audit_type]" required>
												<option value="">-Select-</option>
												<option value="CQ Audit">CQ Audit</option>
												<option value="BQ Audit">BQ Audit</option>
												<option value="Calibration">Calibration</option>
												<option value="Pre-Certification Mock Call">Pre-Certification Mock Call</option>
												<option value="Certification Audit">Certification Audit</option>
												<option value="Operation Audit">Operation Audit</option>
												<option value="Trainer Audit">Trainer Audit</option>
												<option value="Wow Call">Wow Call</option>
											</select>
										</td>
										<td class="auType_epi" colspan="1">Auditor Type</td>
										<td class="auType_epi" colspan="2">
											<select class="form-control" id="auditor_type" name="data[auditor_type]">
												<option value="">-Select-</option>
												<option value="Master">Master</option>
												<option value="Regular">Regular</option>
											</select>
										</td>
										<td colspan="1">VOC:</td>
										<td colspan="2">
											<select class="form-control" id="voc" name="data[voc]" required>
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
										<td colspan="2">
											<select class="form-control fatal_epi" id="auto_fail" name="data[auto_fail]"  required>
												<option value="No">No</option>
												<option value="Yes">Yes</option>
											</select>
										</td>
										<td colspan="1">Sales Call Type:</td>
										<td colspan="2">
											<select class="form-control" id="sales_call_type" name="data[sales_call_type]" required>
												<option value="">-Select-</option>
												<option value="Closed Sale">Closed Sale</option>
												<option value="Non-Sale">Non-Sale</option>
											</select>
										</td>
										<td class="nonSale_epi" colspan="1">Non-Sale</td>
										<td class="nonSale_epi" colspan="2">
											<select class="form-control" id="nonSale" name="data[nonSale]">
												<option value="">-Select-</option>
												<option value="CPP Price Objection">CPP Price Objection</option>
											    <option value="Customer Hang-up">Customer Hang-up</option>
											    <option value="Delivery Time Frame Issue">Delivery Time Frame Issue</option>
											    <option value="Did Not Carry">Did Not Carry</option>
											    <option value="Drop / Ghost Calls">Drop / Ghost Calls</option>
											    <option value="Marketing Promotions">Marketing Promotions</option>
											    <option value="Out of Stock">Out of Stock</option>
											    <option value="Post Sale Issue or CS Concern">Post Sale Issue or CS Concern</option>
											    <option value="Price Part Objection">Price Part Objection</option>
											    <option value="Sales Inquiry (Caller is inquiring for somebody)">Sales Inquiry (Caller is inquiring for somebody)</option>
											    <option value="Sales Inquiry (CX will check with Mechanic first)">Sales Inquiry (CX will check with Mechanic first)</option>
											    <option value="Sales Inquiry (No email address)">Sales Inquiry (No email address)</option>
											    <option value="Sales Inquiry (No funds yet)">Sales Inquiry (No funds yet)</option>
											    <option value="Same Month CC Expiry">Same Month CC Expiry</option>
											    <option value="Shipping Cost">Shipping Cost</option>
											    <option value="Technical Fit Notes">Technical Fit Notes</option>
											</select>
										</td>
									</tr>
									<tr>
										<td>Sampling:</td>
										<td colspan="2"><input type="text" class="form-control" name="data[qa_sampling]" required></td>
										<!--<td>MC Disposition:</td>
										<td colspan="2">
											<select class="form-control" name="data[mc_disposition]" required>
												<option value="">-Select-</option>
												<option value="CS Tracking Inquiry and Order Status - General Tracking inquiry">CS Tracking Inquiry and Order Status - General Tracking inquiry</option>
												<option value="CS Tracking Inquiry - Delayed">CS Tracking Inquiry - Delayed</option>
												<option value="CS Order Accounts Concerns (Modify/Update Order)">CS Order Accounts Concerns (Modify/Update Order)</option>
												<option value="CS Partial Order - Where is the rest of my order?">CS Partial Order - Where is the rest of my order?</option>
												<option value="CS Cancellation Request">CS Cancellation Request</option>
												<option value="CS Lost or Damaged Package - Claims">CS Lost or Damaged Package - Claims</option>
												<option value="CS Non-Customer Related Interactions">CS Non-Customer Related Interactions</option>
												<option value="CS Refund Request or Follow up">CS Refund Request or Follow up</option>
												<option value="CS Shipping Label request">CS Shipping Label request</option>
												<option value="CS Warranty Claim">CS Warranty Claim</option>
												<option value="CS Return a Part for a Refund/Return Set Up in Sales Console/Replacement Request">CS Return a Part for a Refund/Return Set Up in Sales Console/Replacement Request</option>
												<option value="CS Transferred Issue">CS Transferred Issue</option>
												<option value="CS Marketing Promotions">CS Marketing Promotions</option>
												<option value="CS Payment Issues, Pre-auth and Incremental charges">CS Payment Issues, Pre-auth and Incremental charges</option>
												<option value="CPT Declined Orders">CPT Declined Orders</option>
											</select>
										</td>-->
										<td>Order Number:</td>
										<td colspan="2"><input type="text" class="form-control" name="data[order_no]" required></td>
										<td>NPS:</td>
										<td colspan="2"><input type="text" class="form-control" name="data[nps]" required></td>
									</tr>
									<tr>
										<td>CSAT:</td>
										<td colspan="2"><input type="text" class="form-control" name="data[csat]" required></td>
										<td>20% Deduction:</td>
										<td colspan=2>
											<select class="form-control deduct_20_perc" id="deduct_20_perc" name="data[deduction_20_percent]" required>
												<option value="">Select</option>
												<option value="Yes">Yes</option>
												<option value="No">No</option>
											</select>
										</td>
									</tr>
									<!--<tr>
										<td>Sub Category:</td>
										<td colspan=2><input type="text" class="form-control" name="data[sub_category]" required></td>
									</tr>-->
									<tr>
										<td style="font-size:18px; font-weight:bold" colspan="1">Earned Score</td>
										<td style="font-size:18px; font-weight:bold" colspan="2"><input type="text" readonly class="form-control" id="earnedScore" name="data[earned_score]" value=""></td><td style="font-size:18px; font-weight:bold" colspan="1">Possible Score</td>
										<td style="font-size:18px; font-weight:bold" colspan="2"><input type="text" readonly class="form-control" id="possibleScore" name="data[possible_score]" value=""></td>
										<td style="font-size:18px; font-weight:bold" colspan="1">Overall Score:</td>
										<td style="font-size:18px; font-weight:bold" colspan="2"><input type="text" readonly class="form-control" id="overallScore" name="data[overall_score]" value=""></td>
									</tr>
									<tr>
										<td style="font-size:18px; font-weight:bold" colspan="1">Customer Score</td>
										<td style="font-size:18px; font-weight:bold" colspan="2"><input type="text" readonly class="form-control" id="custScore" name="data[cust_score]" value=""></td><td style="font-size:18px; font-weight:bold" colspan="1">Business Score</td>
										<td style="font-size:18px; font-weight:bold" colspan="2"><input type="text" readonly class="form-control" id="busiScore" name="data[busi_score]" value=""></td>
										<td style="font-size:18px; font-weight:bold" colspan="1">Compliance Score:</td>
										<td style="font-size:18px; font-weight:bold" colspan="2"><input type="text" readonly class="form-control" id="compScore" name="data[comp_score]" value=""></td>
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
											<select class="form-control points_epi cust_score" name="data[Introduction]" required>
												<option ds_val=2.8 value="Yes">Yes</option>
												<option ds_val=2.8 value="No">No</option>
												<option ds_val=2.8 value="N/A">N/A</option>
											</select>
										</td>
										
										<td colspan=2><input type="text" class="form-control" name="data[cmt1]"></td>
									</tr>
									<tr>
										<td>2</td>
										<td colspan=4>Obtaining Customer' Needs</td>
										<td>
											<select class="form-control points_epi cust_score"  name="data[active_listening]" required>
												<option ds_val=7 value="Yes">Yes</option>
												<option ds_val=7 value="No">No</option>
												<option ds_val=7 value="N/A">N/A</option>
											</select>
										</td>
										
										<td colspan=2><input type="text" class="form-control" name="data[cmt2]"></td>
									</tr>
									<tr>
										<td>3</td>
										<td colspan=4>Questioning</td>
										<td>
											<select class="form-control points_epi cust_score"  name="data[questioning]" required>
												<option ds_val=8.4 value="Yes">Yes</option>
												<option ds_val=8.4 value="No">No</option>
												<option ds_val=8.4 value="N/A">N/A</option>
											</select>
										</td>
										
									<td colspan=2><input type="text" class="form-control" name="data[cmt3]"></td></tr>
									<tr>
										<td>4</td>
										<td colspan=4>Presentation</td>
										<td>
											<select class="form-control points_epi busi_score"  name="data[presentation]" required>
												<option ds_val=8.4 value="Yes">Yes</option>
												<option ds_val=8.4 value="No">No</option>
												<option ds_val=8.4 value="N/A">N/A</option>
											</select>
										</td>
										
									<td colspan=2><input type="text" class="form-control" name="data[cmt4]"></td></tr>
									<tr>
										<td>5</td>
										<td colspan=4>Closing the Sale</td>
										<td>
											<select class="form-control points_epi busi_score"  name="data[closing_sale]" required>
												<option ds_val=7 value="Yes">Yes</option>
												<option ds_val=7 value="No">No</option>
												<option ds_val=7 value="N/A">N/A</option>
											</select>
										</td>
										
									<td colspan=2><input type="text" class="form-control" name="data[cmt5]"></td></tr>
									<tr>
										<td rowspan=3>6</td>
										<td rowspan=3 style="font-weight:bold">Add On</td>
										<td colspan=3>CPP</td>
										<td>
											<select class="form-control points_epi busi_score"  name="data[add_cpp]" required>
												<option ds_val=7 value="Yes">Yes</option>
												<option ds_val=7 value="No">No</option>
												<option ds_val=7 value="N/A">N/A</option>
											</select>
										</td>
										
									<td colspan=2><input type="text" class="form-control" name="data[cmt6]"></td></tr>
									<tr>
										<td colspan=3>Related Parts / Parts Tray </td>
										<td>
											<select class="form-control points_epi busi_score"  name="data[add_parts]" required>
												<option ds_val=7 value="Yes">Yes</option>
												<option ds_val=7 value="No">No</option>
												<option ds_val=7 value="N/A">N/A</option>
											</select>
										</td>
										
									<td colspan=2><input type="text" class="form-control" name="data[cmt7]"></td></tr>
									<tr>
										<td colspan=3>RepairPal</td>
										<td>
											<select class="form-control points_epi busi_score"  name="data[RepairPal]" required>
												<option ds_val=3.5 value="Yes">Yes</option>
												<option ds_val=3.5 value="No">No</option>
												<option ds_val=3.5 value="N/A">N/A</option>
											</select>
										</td>
										
									<td colspan=2><input type="text" class="form-control" name="data[cmt8]"></td></tr>
									<tr>
										<td>7</td>
										<td colspan=4>Shipping Options / Shipping Details</td>
										<td>
											<select class="form-control points_epi busi_score"  name="data[shipping_options]" required>
												<option ds_val=4.2 value="Yes">Yes</option>
												<option ds_val=4.2 value="No">No</option>
												<option ds_val=4.2 value="N/A">N/A</option>
											</select>
										</td>
										
									<td colspan=2><input type="text" class="form-control" name="data[cmt9]"></td></tr>
									<tr>
										<td rowspan=2>8</td>
										<td rowspan=2 style="font-weight:bold">Recap & Tracking Email</td>
										<td colspan=3>Shipping & Billing / YMMSE / Part Name(s)</td>
										<td>
											<select class="form-control points_epi busi_score"  name="data[shipping_billing]" required>
												<option ds_val=2.8 value="Yes">Yes</option>
												<option ds_val=2.8 value="No">No</option>
												<option ds_val=2.8 value="N/A">N/A</option>
											</select>
										</td>
										
									<td colspan=2><input type="text" class="form-control" name="data[cmt10]"></td></tr>
									<tr>
										<td colspan=3>Tracking Email</td>
										<td>
											<select class="form-control points_epi busi_score"  name="data[tracking_email_recap]" required>
												<option ds_val=2.8 value="Yes">Yes</option>
												<option ds_val=2.8 value="No">No</option>
												<option ds_val=2.8 value="N/A">N/A</option>
											</select>
										</td>
										
									<td colspan=2><input type="text" class="form-control" name="data[cmt11]"></td></tr>
									
									
									<tr>
										<td rowspan=3>9</td>
										<td rowspan=3 style="font-weight:bold">Closing Script</td>
										<td colspan=3>Asking / Offering for additional assistance</td>
										<td>
											<select class="form-control points_epi busi_score"  name="data[additional_assistance]" required>
												<option ds_val=2.8 value="Yes">Yes</option>
												<option ds_val=2.8 value="No">No</option>
												<option ds_val=2.8 value="N/A">N/A</option>
											</select>
										</td>
										
									<td colspan=2><input type="text" class="form-control" name="data[cmt12]"></td></tr>
									<tr>
										<td colspan=3>CSAT / NPS Survey</td>
										<td>
											<select class="form-control points_epi busi_score"  name="data[NPS_survey]" required>
												<option ds_val=3.5 value="Yes">Yes</option>
												<option ds_val=3.5 value="No">No</option>
												<option ds_val=3.5 value="N/A">N/A</option>
											</select>
										</td>
										
									<td colspan=2><input type="text" class="form-control" name="data[cmt13]"></td></tr>
									<tr>
										<td colspan=3>Rebranding</td>
										<td>
											<select class="form-control points_epi busi_score"  name="data[rebranding_new]" required>
												<option ds_val=2.8 value="Yes">Yes</option>
												<option ds_val=2.8 value="No">No</option>
												<option ds_val=2.8 value="N/A">N/A</option>
											</select>
										</td>
										
									<td colspan=2><input type="text" class="form-control" name="data[cmt14]"></td></tr>
									
									<tr><td class="eml1" colspan=8>PROCESS ADHERENCE</td></tr>
									<tr>
										<td>10</td>
										<td colspan=4>Discount Rules</td>
										<td>
											<select class="form-control points_pa busi_score"  name="data[discount_rules]" required>
												<option ds_val=10 value="Yes">Yes</option>
												<option ds_val=10 value="No">No</option>
												<option ds_val=10 value="N/A">N/A</option>
											</select>
										</td>
										
									<td colspan=2><input type="text" class="form-control" name="data[cmt15]"></td></tr>
									<tr>
										<td rowspan=3>11</td>
										<td rowspan=3 style="font-weight:bold">Account Verification</td>
									</tr>
									<tr>
										<td colspan=3>Data Gathering Compliance</td>
										<td>
											<select class="form-control points_pa comp_score"  name="data[data_gathering]" required>
												<option ds_val=3.75 value="Yes">Yes</option>
												<option ds_val=3.75 value="No">No</option>
												<option ds_val=3.75 value="N/A">N/A</option>
											</select>
										</td>
										
									<td colspan=2><input type="text" class="form-control" name="data[cmt17]"></td></tr>
									<tr>
										<td colspan=3>Accuracy</td>
										<td>
											<select class="form-control points_pa comp_score"  name="data[account_accuracy]" required>
												<option ds_val=5 value="Yes">Yes</option>
												<option ds_val=5 value="No">No</option>
												<option ds_val=5 value="N/A">N/A</option>
											</select>
										</td>
										
									<td colspan=2><input type="text" class="form-control" name="data[cmt18]"></td></tr>
									<tr>
										<td>12</td>
										<td colspan=4>Documentation</td>
										<td>
											<select class="form-control points_pa busi_score"  name="data[documentation]" required>
												<option ds_val=2.5 value="Yes">Yes</option>
												<option ds_val=2.5 value="No">No</option>
												<option ds_val=2.5 value="N/A">N/A</option>
											</select>
										</td>
										
									<td colspan=2><input type="text" class="form-control" name="data[cmt19]"></td></tr>

									<tr>
										<td>13</td>
										<td colspan=4>Hold Time</td>
										<td>
											<select class="form-control points_pa busi_score"  name="data[hold_time]" required>
												<option ds_val=3.75 value="Yes">Yes</option>
												<option ds_val=3.75 value="No">No</option>
												<option ds_val=3.75 value="N/A">N/A</option>
											</select>
										</td>
										
									<td colspan=2><input type="text" class="form-control" name="data[cmt20]"></td></tr>

									<tr><td class="eml1" colspan=8>SOFT SKILLS 5%</td></tr>
									<tr>
										<td rowspan=1>14</td>
										<td colspan=4>Overcoming Objections</td>
										<td>
											<select class="form-control points_pa busi_score"  name="data[Overcoming_Objections]" required>
												<option ds_val=5 value="Yes">Yes</option>
												<option ds_val=5 value="No">No</option>
												<option ds_val=5 value="N/A">N/A</option>
											</select>
										</td>
										
									<td colspan=2><input type="text" class="form-control" name="data[cmt21]"></td></tr>

									<tr>
										<td colspan=3>Call Summary:</td>
										<td colspan=6><textarea class="form-control" name="data[call_summary]"></textarea></td>
									</tr>
									<tr>
										<td colspan=3>Feedback:</td>
										<td colspan=6><textarea class="form-control" name="data[feedback]"></textarea></td>
									</tr>
									<tr>
										<td colspan=3>Upload Files</td>
										<td colspan=6><input type="file" multiple class="form-control" id="attach_file" name="attach_file[]"></td>
									</tr>
									<?php if(is_access_qa_module()==true){ ?>
									<tr>
										<td colspan=9><button class="btn btn-success waves-effect" type="submit" id="qaformsubmit" style="width:500px">SAVE</button></td>
									</tr>
									<?php } ?>
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