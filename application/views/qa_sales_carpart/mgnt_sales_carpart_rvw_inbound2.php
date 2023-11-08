
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
		<form id="form_mgnt_user" method="POST" action="" enctype="multipart/form-data">

			<div class="col-12">
				<div class="widget">
				
					<div class="widget-body">
						<div class="table-responsive">
							<table class="table table-striped skt-table" width="100%">
								<tbody>
									<tr style="background-color:#AEB6BF">
										<td colspan="9" id="theader" style="font-size:30px">Mgnt <?php $page_tilte=explode("_", $page);
									echo ucfirst($page_tilte[0]); ?> Inbound Rvw<!-- <img src="<?php echo base_url(); ?>main_img/hra.png"> --></td>
										<input type="hidden" name="pnid" value="<?php echo $pnid; ?>">
									</tr>
										
									<tr>
										<td colspan="1">QA Name:</td>
										<?php 
										$dataDetails=$page."_new";
										if($$dataDetails['entry_by']!=''){
												$auditorName = $$dataDetails['auditor_name'];
											}else{
												$auditorName = $$dataDetails['client_name'];
										} ?>
										<td colspan="2"><input type="text" class="form-control" value="<?php echo $auditorName; ?>" disabled></td>
										<td colspan="1">Audit Date:</td>
										<td colspan="2"><input type="text" class="form-control" value="<?php echo mysql2mmddyy($$dataDetails['audit_date']); ?>" disabled></td>
										<td colspan="1">Call Id.:</td>
										<td colspan="2"><input type="text" class="form-control" id="call_id" name="data[call_id]" value="<?php echo $$dataDetails['call_id'] ?>" required></td>
									</tr>
									<tr>
										<td colspan="1">Agent:</td>
										<td colspan="2">
											<select class="form-control" id="agent_id" name="data[agent_id]" required>
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
											<select class="form-control" id="tl_id" name="data[tl_id]"  required>
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
										<td colspan="2"><input type="text" class="form-control"  name="data[call_type]" value="<?php echo $$dataDetails['call_type'] ?>"  required></td>
										<td colspan="1">Contact Date:</td>
										<td colspan="2"><input type="text" class="form-control" id="call_date" name="call_date" value="<?php echo $$dataDetails['call_date'] ?>" required></td>
										<td colspan="1">Contact Duration:</td>
										<td colspan="2"><input type="text" class="form-control" id="call_duration" name="data[call_duration]" value="<?php echo $$dataDetails['call_duration'] ?>" required></td>
									</tr>
									<tr>
										<td colspan="1">Audit Type:</td>
										<td colspan="2">
											<select class="form-control" id="audit_type" name="data[audit_type]" required>
												<option value="<?php echo $$dataDetails['audit_type'] ?>"><?php echo $$dataDetails['audit_type'] ?></option>
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
											<select class="form-control" id="auditor_type" name="data[auditor_type]" >
												<option value="">-Select-</option>
												<option <?php echo $$dataDetails['auditor_type']=='Master'?"selected":""; ?> value="Master">Master</option>
												<option <?php echo $$dataDetails['auditor_type']=='Regular'?"selected":""; ?> value="Regular">Regular</option>
											</select>
										</td>
										<td colspan="1">VOC:</td>
										<td colspan="2">
											<select class="form-control" id="voc" name="data[voc]"  required>
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
										<td colspan="2"><select class="form-control fatal_epi" id="auto_fail" name="data[auto_fail]"  required>
												<option value="<?php echo $$dataDetails['auto_fail'] ?>"><?php echo $$dataDetails['auto_fail'] ?></option>
												<option value="No">No</option>
												<option value="Yes">Yes</option>
											</select>
										</td>
										<td colspan="1">Sales Call Type:</td>
										<td colspan="2">
											<select class="form-control" id="sales_call_type" name="data[sales_call_type]" required>
												<option value="<?php echo $$dataDetails['sales_call_type'] ?>"><?php echo $$dataDetails['sales_call_type'] ?></option>
												<option value="">-Select-</option>
												<option value="Closed Sale">Closed Sale</option>
												<option value="Non-Sale">Non-Sale</option>
											</select>
										</td>
										<td class="nonSale_epi" colspan="1">Non-Sale</td>
										<td class="nonSale_epi" colspan="2">
											<select class="form-control" id="nonSale" name="data[nonSale]">
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
										<td><input type="text" class="form-control" id="" name="data[qa_sampling]" value="<?php echo $$dataDetails['qa_sampling'] ?>" required></td>
										<td>Order Number:</td>
										<td><input type="text" class="form-control" id="" name="data[order_no]" value="<?php echo $$dataDetails['order_no'] ?>" required></td>
										<td>NPS:</td>
										<td><input type="text" class="form-control" id="" name="data[nps]" value="<?php echo $$dataDetails['nps'] ?>" required></td>
									<tr>
									<tr>
										<td>CSAT:</td>
										<td><input type="text" class="form-control" id="" name="data[csat]" value="<?php echo $$dataDetails['csat'] ?>" required></td>
										<td>20% Deduction:</td>
										<td colspan=2>
											<select class="form-control deduct_20_perc" id="deduct_20_perc" name="data[deduction_20_percent]" required>
												<option value="">Select</option>
												<option value="Yes" <?php echo $$dataDetails['deduction_20_percent']=="Yes"?"selected":""; ?>>Yes</option>
												<option value="No" <?php echo $$dataDetails['deduction_20_percent']=="No"?"selected":""; ?> >No</option>
											</select>
										</td>
									</tr>
									<!--<tr>
										<td>Sub Category:</td>
										<td colspan=2><input type="text" class="form-control" id="" name="data[sub_category]" value="<?php echo $$dataDetails['sub_category'] ?>" required></td>
									</tr>-->
									<tr>										
										<td style="font-size:18px; font-weight:bold" colspan="1">Earned Score</td>
										<td style="font-size:18px; font-weight:bold" colspan="2"><input type="text" readonly class="form-control" id="earnedScore" name="data[earned_score]" value="" disabled></td>
										<td style="font-size:18px; font-weight:bold" colspan="1">Possible Score</td>
										<td style="font-size:18px; font-weight:bold" colspan="2"><input type="text" readonly class="form-control" id="possibleScore" name="data[possible_score]" value="" disabled></td>
										<td style="font-size:18px; font-weight:bold" colspan="1">Overall Score:</td>
										<td style="font-size:18px; font-weight:bold" colspan="2"><input type="text" readonly class="form-control" id="overallScore" name="data[overall_score]" value="<?php echo $$dataDetails['overall_score'] ?>" readonly></td>
									</tr>
									<tr>
										<td style="font-size:18px; font-weight:bold" colspan="1">Customer Score</td>
										<td style="font-size:18px; font-weight:bold" colspan="2"><input type="text" readonly class="form-control" id="custScore" name="data[cust_score]" value="<?php echo $$dataDetails['cust_score'] ?>" readonly></td><td style="font-size:18px; font-weight:bold" colspan="1">Business Score</td>
										<td style="font-size:18px; font-weight:bold" colspan="2"><input type="text" readonly class="form-control" id="busiScore" name="data[busi_score]" value="<?php echo $$dataDetails['busi_score'] ?>" readonly></td>
										<td style="font-size:18px; font-weight:bold" colspan="1">Compliance Score:</td>
										<td style="font-size:18px; font-weight:bold" colspan="2"><input type="text" readonly class="form-control" id="compScore" name="data[comp_score]" value="<?php echo $$dataDetails['comp_score'] ?>" readonly></td>
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
												<option ds_val=2.8 value="Yes" <?php echo $$dataDetails['Introduction']=="Yes"?"selected":""; ?> >Yes</option>
												<option ds_val=2.8 value="No" <?php echo $$dataDetails['Introduction']=="No"?"selected":""; ?> >No</option>
												<option ds_val=2.8 value="N/A" <?php echo $$dataDetails['Introduction']=="N/A"?"selected":""; ?> >N/A</option>
											</select>
											</td>
											
										<td colspan=2><input type="text" class="form-control" name="data[cmt1]"></td>
									</tr>
									<tr>
										<td>2</td>
										<td colspan=4>Obtaining Customer' Needs</td>
										<td>
											<select class="form-control points_epi cust_score"  name="data[active_listening]" required>
												<option ds_val=7 value="Yes" <?php echo $$dataDetails['active_listening']=="Yes"?"selected":""; ?> >Yes</option>
												<option ds_val=7 value="No" <?php echo $$dataDetails['active_listening']=="No"?"selected":""; ?> >No</option>
												<option ds_val=7 value="N/A" <?php echo $$dataDetails['active_listening']=="N/A"?"selected":""; ?> >N/A</option>
											</select>
										</td>
										
										<td colspan=2><input type="text" class="form-control" name="data[cmt2]"></td>
									</tr>
									<tr>
										<td>3</td>
										<td colspan=4>Questioning</td>
										<td>
											<select class="form-control points_epi cust_score"  name="data[questioning]" required>
												<option ds_val=8.4 value="Yes" <?php echo $$dataDetails['questioning']=="Yes"?"selected":""; ?> >Yes</option>
												<option ds_val=8.4 value="No" <?php echo $$dataDetails['questioning']=="No"?"selected":""; ?> >No</option>
												<option ds_val=8.4 value="N/A" <?php echo $$dataDetails['questioning']=="N/A"?"selected":""; ?> >N/A</option>
											</select>
										</td>
										
									<td colspan=2><input type="text" class="form-control" name="data[cmt3]"></td></tr>
									<tr>
										<td>4</td>
										<td colspan=4>Presentation</td>
										<td>
											<select class="form-control points_epi busi_score"  name="data[presentation]" required>
												<option ds_val=8.4 value="Yes" <?php echo $$dataDetails['presentation']=="Yes"?"selected":""; ?> >Yes</option>
												<option ds_val=8.4 value="No" <?php echo $$dataDetails['presentation']=="No"?"selected":""; ?> >No</option>
												<option ds_val=8.4 value="N/A" <?php echo $$dataDetails['presentation']=="N/A"?"selected":""; ?> >N/A</option>
											</select>
										</td>
										
									<td colspan=2><input type="text" class="form-control" name="data[cmt4]"></td></tr>
									<tr>
										<td>5</td>
										<td colspan=4>Closing the Sale</td>
										<td>
											<select class="form-control points_epi busi_score"  name="data[closing_sale]" required>
												<option ds_val=7 value="Yes" <?php echo $$dataDetails['closing_sale']=="Yes"?"selected":""; ?> >Yes</option>
												<option ds_val=7 value="No" <?php echo $$dataDetails['closing_sale']=="No"?"selected":""; ?> >No</option>
												<option ds_val=7 value="N/A" <?php echo $$dataDetails['closing_sale']=="N/A"?"selected":""; ?> >N/A</option>
											</select>
										</td>
										
									<td colspan=2><input type="text" class="form-control" name="data[cmt5]"></td></tr>
									<tr>
										<td rowspan=3>6</td>
										<td rowspan=3 style="font-weight:bold">Add On</td>
										<td colspan=3>CPP</td>
										<td>
											<select class="form-control points_epi busi_score"  name="data[add_cpp]" required>
												<option ds_val=7 value="Yes" <?php echo $$dataDetails['add_cpp']=="Yes"?"selected":""; ?> >Yes</option>
												<option ds_val=7 value="No" <?php echo $$dataDetails['add_cpp']=="No"?"selected":""; ?> >No</option>
												<option ds_val=7 value="N/A" <?php echo $$dataDetails['add_cpp']=="N/A"?"selected":""; ?> >N/A</option>
											</select>
										</td>
										
									<td colspan=2><input type="text" class="form-control" name="data[cmt6]"></td></tr>
									<tr>
										<td colspan=3>Related Parts / Parts Tray </td>
										<td>
											<select class="form-control points_epi busi_score"  name="data[add_parts]" required>
												<option ds_val=7 value="Yes" <?php echo $$dataDetails['add_parts']=="Yes"?"selected":""; ?> >Yes</option>
												<option ds_val=7 value="No" <?php echo $$dataDetails['add_parts']=="No"?"selected":""; ?> >No</option>
												<option ds_val=7 value="N/A" <?php echo $$dataDetails['add_parts']=="N/A"?"selected":""; ?> >N/A</option>
											</select>
										</td>
										
									<td colspan=2><input type="text" class="form-control" name="data[cmt7]"></td></tr>
									<tr>
										<td colspan=3>RepairPal</td>
										<td>
											<select class="form-control points_epi busi_score"  name="data[RepairPal]" required>
												<option ds_val=3.5 value="Yes" <?php echo $$dataDetails['RepairPal']=="Yes"?"selected":""; ?> >Yes</option>
												<option ds_val=3.5 value="No" <?php echo $$dataDetails['RepairPal']=="No"?"selected":""; ?> >No</option>
												<option ds_val=3.5 value="N/A" <?php echo $$dataDetails['RepairPal']=="N/A"?"selected":""; ?> >N/A</option>
											</select>
										</td>
										
									<td colspan=2><input type="text" class="form-control" name="data[cmt8]"></td></tr>
									<tr>
										<td>7</td>
										<td colspan=4>Shipping Options / Shipping Details</td>
										<td>
											<select class="form-control points_epi busi_score"  name="data[shipping_options]" required>
												<option ds_val=4.2 value="Yes" <?php echo $$dataDetails['shipping_options']=="Yes"?"selected":""; ?> >Yes</option>
												<option ds_val=4.2 value="No" <?php echo $$dataDetails['shipping_options']=="No"?"selected":""; ?> >No</option>
												<option ds_val=4.2 value="N/A" <?php echo $$dataDetails['shipping_options']=="N/A"?"selected":""; ?> >N/A</option>
											</select>
										</td>
										
									<td colspan=2><input type="text" class="form-control" name="data[cmt9]"></td></tr>
									<tr>
										<td rowspan=2>8</td>
										<td rowspan=2 style="font-weight:bold">Recap & Tracking Email</td>
										<td colspan=3>Shipping & Billing / YMMSE / Part Name(s)</td>
										<td>
											<select class="form-control points_epi busi_score"  name="data[shipping_billing]" required>
												<option ds_val=2.8 value="Yes" <?php echo $$dataDetails['shipping_billing']=="Yes"?"selected":""; ?> >Yes</option>
												<option ds_val=2.8 value="No" <?php echo $$dataDetails['shipping_billing']=="No"?"selected":""; ?> >No</option>
												<option ds_val=2.8 value="N/A" <?php echo $$dataDetails['shipping_billing']=="N/A"?"selected":""; ?> >N/A</option>
											</select>
										</td>
										
									<td colspan=2><input type="text" class="form-control" name="data[cmt10]"></td></tr>
									<tr>
										<td colspan=3>Tracking Email</td>
										<td>
											<select class="form-control points_epi busi_score"  name="data[tracking_email_recap]" required>
												<option ds_val=2.8 value="Yes" <?php echo $$dataDetails['tracking_email_recap']=="Yes"?"selected":""; ?> >Yes</option>
												<option ds_val=2.8 value="No" <?php echo $$dataDetails['tracking_email_recap']=="No"?"selected":""; ?> >No</option>
												<option ds_val=2.8 value="N/A" <?php echo $$dataDetails['tracking_email_recap']=="N/A"?"selected":""; ?> >N/A</option>
											</select>
										</td>
										
									<td colspan=2><input type="text" class="form-control" name="data[cmt11]"></td></tr>
									
									
									<tr>
										<td rowspan=3>9</td>
										<td rowspan=3 style="font-weight:bold">Closing Script</td>
										<td colspan=3>Asking / Offering for additional assistance</td>
										<td>
											<select class="form-control points_epi busi_score"  name="data[additional_assistance]" required>
												<option ds_val=2.8 value="Yes" <?php echo $$dataDetails['additional_assistance']=="Yes"?"selected":""; ?> >Yes</option>
												<option ds_val=2.8 value="No" <?php echo $$dataDetails['additional_assistance']=="No"?"selected":""; ?> >No</option>
												<option ds_val=2.8 value="N/A" <?php echo $$dataDetails['additional_assistance']=="N/A"?"selected":""; ?> >N/A</option>
											</select>
										</td>
										
									<td colspan=2><input type="text" class="form-control" name="data[cmt12]"></td></tr>
									<tr>
										<td colspan=3>CSAT / NPS Survey</td>
										<td>
											<select class="form-control points_epi busi_score"  name="data[NPS_survey]" required>
												<option ds_val=3.5 value="Yes" <?php echo $$dataDetails['NPS_survey']=="Yes"?"selected":""; ?> >Yes</option>
												<option ds_val=3.5 value="No" <?php echo $$dataDetails['NPS_survey']=="No"?"selected":""; ?> >No</option>
												<option ds_val=3.5 value="N/A" <?php echo $$dataDetails['NPS_survey']=="N/A"?"selected":""; ?> >N/A</option>
											</select>
										</td>
										
									<td colspan=2><input type="text" class="form-control" name="data[cmt13]"></td></tr>
									<tr>
										<td colspan=3>Rebranding</td>
										<td>
											<select class="form-control points_epi busi_score"  name="data[rebranding_new]" required>
												<option ds_val=2.8 value="Yes" <?php echo $$dataDetails['rebranding_new']=="Yes"?"selected":""; ?> >Yes</option>
												<option ds_val=2.8 value="No" <?php echo $$dataDetails['rebranding_new']=="No"?"selected":""; ?> >No</option>
												<option ds_val=2.8 value="N/A" <?php echo $$dataDetails['rebranding_new']=="N/A"?"selected":""; ?> >N/A</option>
											</select>
										</td>
										
									<td colspan=2><input type="text" class="form-control" name="data[cmt14]"></td></tr>
									
									<tr><td class="eml1" colspan=8>PROCESS ADHERENCE</td></tr>
									<tr>
										<td>10</td>
										<td colspan=4>Discount Rules</td>
										<td>
											<select class="form-control points_pa busi_score"  name="data[discount_rules]" required>
												<option ds_val=10 value="Yes" <?php echo $$dataDetails['discount_rules']=="Yes"?"selected":""; ?> >Yes</option>
												<option ds_val=10 value="No" <?php echo $$dataDetails['discount_rules']=="No"?"selected":""; ?> >No</option>
												<option ds_val=10 value="N/A" <?php echo $$dataDetails['discount_rules']=="N/A"?"selected":""; ?> >N/A</option>
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
												<option ds_val=3.75 value="Yes" <?php echo $$dataDetails['data_gathering']=="Yes"?"selected":""; ?> >Yes</option>
												<option ds_val=3.75 value="No" <?php echo $$dataDetails['data_gathering']=="No"?"selected":""; ?> >No</option>
												<option ds_val=3.75 value="N/A" <?php echo $$dataDetails['data_gathering']=="N/A"?"selected":""; ?> >N/A</option>
											</select>
										</td>
										
									<td colspan=2><input type="text" class="form-control" name="data[cmt17]"></td></tr>
									<tr>
										<td colspan=3>Accuracy</td>
										<td>
											<select class="form-control points_pa comp_score"  name="data[account_accuracy]" required>
												<option ds_val=5 value="Yes" <?php echo $$dataDetails['account_accuracy']=="Yes"?"selected":""; ?> >Yes</option>
												<option ds_val=5 value="No" <?php echo $$dataDetails['account_accuracy']=="No"?"selected":""; ?> >No</option>
												<option ds_val=5 value="N/A" <?php echo $$dataDetails['account_accuracy']=="N/A"?"selected":""; ?> >N/A</option>
											</select>
										</td>
										
									<td colspan=2><input type="text" class="form-control" name="data[cmt18]"></td></tr>
									<tr>
										<td>12</td>
										<td colspan=4>Documentation</td>
										<td>
											<select class="form-control points_pa busi_score"  name="data[documentation]" required>
												<option ds_val=2.5 value="Yes" <?php echo $$dataDetails['documentation']=="Yes"?"selected":""; ?> >Yes</option>
												<option ds_val=2.5 value="No" <?php echo $$dataDetails['documentation']=="No"?"selected":""; ?> >No</option>
												<option ds_val=2.5 value="N/A" <?php echo $$dataDetails['documentation']=="N/A"?"selected":""; ?> >N/A</option>
											</select>
										</td>
										
									<td colspan=2><input type="text" class="form-control" name="data[cmt19]"></td></tr>

									<tr>
										<td>13</td>
										<td colspan=4>Hold Time</td>
										<td>
											<select class="form-control points_pa busi_score"  name="data[hold_time]" required>
												<option ds_val=3.75 value="Yes" <?php echo $$dataDetails['hold_time']=="Yes"?"selected":""; ?> >Yes</option>
												<option ds_val=3.75 value="No" <?php echo $$dataDetails['hold_time']=="No"?"selected":""; ?> >No</option>
												<option ds_val=3.75 value="N/A" <?php echo $$dataDetails['hold_time']=="N/A"?"selected":""; ?> >N/A</option>
											</select>
										</td>
										
									<td colspan=2><input type="text" class="form-control" name="data[cmt20]"></td></tr>

									<tr><td class="eml1" colspan=8>SOFT SKILLS 5%</td></tr>
									<tr>
										<td rowspan=1>14</td>
										<td colspan=4>Overcoming Objections</td>
										<td>
											<select class="form-control points_pa busi_score"  name="data[Overcoming_Objections]" required>
												<option ds_val=5 value="Yes" <?php echo $$dataDetails['Overcoming_Objections']=="Yes"?"selected":""; ?> >Yes</option>
												<option ds_val=5 value="No" <?php echo $$dataDetails['Overcoming_Objections']=="No"?"selected":""; ?> >No</option>
												<option ds_val=5 value="N/A" <?php echo $$dataDetails['Overcoming_Objections']=="N/A"?"selected":""; ?> >N/A</option>
											</select>
										</td>
										
									<td colspan=2><input type="text" class="form-control" name="data[cmt21]"></td></tr>

									
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
												<audio controls='' style="background-color:#607F93">
													  <source src="<?php echo base_url(); ?>qa_files/qa_<?php echo $page; ?>/<?php echo $af; ?>" type="audio/ogg">
													  <source src="<?php echo base_url(); ?>qa_files/qa_<?php echo $page; ?>/<?php echo $af; ?>" type="audio/mpeg">
												</audio> </br>
											 <?php } ?>
										</td>
									</tr>
									<?php } 
									//if($$dataDetails['entry_by']==get_user_id()){ ?>
										<tr><td colspan=2>Edit Upload</td><td colspan=4><input type="file" multiple class="form-control1" id="fileuploadbasic" name="attach_file[]"></td></tr>
									<?php //} ?>
									
									<tr><td colspan="9" style="background-color:#C5C8C8"></td></tr>
									
									<tr><td style="font-size:16px">Agent Review:</td> <td colspan="8" style="text-align:left"><?php echo $$dataDetails['agent_rvw_note']; ?></td></tr>
									<tr><td style="font-size:16px">Manager Review:</td> <td colspan="8" style="text-align:left"><?php echo $$dataDetails['mgnt_rvw_note'] ?></td></tr>
									<tr><td style="font-size:16px">Client Review:</td> <td colspan="8" style="text-align:left"><?php echo $$dataDetails['client_rvw_note'] ?></td></tr>
									
									<tr><td colspan="6" style="background-color:#C5C8C8"></td></tr>
									
									<tr>
										<td colspan="3"  style="font-size:16px">Client/Manager Reviews</td>
										<td colspan="6"><textarea class="form-control1" style="width:100%" name="note" placeholder="Please Write Reviews Here..." required></textarea></td>
									</tr>
									
									<?php if(is_access_qa_module()==true || is_access_qa_operations_module()==true){ 
									if(is_available_qa_feedback($$dataDetails['entry_date'],72) == true){ ?>
										<tr>
											<td colspan="9"><button class="btn btn-success waves-effect" type="submit" id='btnmgntSave' name='btnSave' value="SAVE" style="width:300px">SAVE</button> &nbsp; <a class="btn btn-warning" href="<?php echo base_url(); ?>Qa_<?php echo $page; ?>">Back</a></td>
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