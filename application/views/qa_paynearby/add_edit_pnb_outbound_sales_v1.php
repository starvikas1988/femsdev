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
.new-file input[type="file"]{
	padding-top: 10px!important;
}
.select2-selection.select2-selection--single{
	height: 40px!important;
	border-radius: 1px!important;
}
.new-btn{
	width: 500px;
	padding: 10px;
	border-radius:1px!important ;
}
.form-control{
		border-radius:1px!important ;
}
.select2-container{
	width: 100%!important;
}
.ui-datepicker .ui-datepicker-buttonpane button.ui-datepicker-current {
	 float: left;
	 display: none;
	}
</style>

<?php if($pnboutbound_v1_id!=0){
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
										<td colspan="6" id="theader" style="font-size:40px">PNB OUTBOUND Sales V1</td>
										<input type="hidden" name="audit_start_time" value="<?php echo CurrMySqlDate(); ?>">
									</tr>
									

									<?php
										if ($pnboutbound_v1_id == 0) {
											$auditorName = get_username();
											$auditDate = CurrDateMDY();
											//$auditDate =  CurrDateTimeMDY();
											$clDate_val = '';
										} else {
											if ($pnb_outbound_sales_v1['entry_by'] != '') {
												$auditorName = $pnb_outbound_sales_v1['auditor_name'];
											} else {
												$auditorName = $pnb_outbound_sales_v1['client_name'];
											}
										
											$auditDate = mysql2mmddyy($pnb_outbound_sales_v1['audit_date']);
										 
											$clDate_val = mysql2mmddyy($pnb_outbound_sales_v1['call_date']);
										}

										if ($rand_id != 0) {
											$agent_id = $rand_data['sid'];
											$fusion_id = $rand_data['fusion_id'];
											$agent_name = $rand_data['fname'] . " " . $rand_data['lname'];
											$tl_id = $rand_data['assigned_to'];
											$tl_name = $rand_data['tl_name'];
											$call_duration = $rand_data['call_duration'];
											
										} else {
											$agent_id = $pnb_outbound_sales_v1['agent_id'];
											$fusion_id = $pnb_outbound_sales_v1['fusion_id'];
											$agent_name = $pnb_outbound_sales_v1['fname'] . " " . $pnb_outbound_sales_v1['lname'] ;
											$tl_id = $pnb_outbound_sales_v1['tl_id'];
											$tl_name = $pnb_outbound_sales_v1['tl_name'];
											$call_duration = $pnb_outbound_sales_v1['call_duration'];
										}
										?>
									<tr>
										<td style="width:120px">Auditor Name:</td>
										<td style="width:250px;"><input type="text" class="form-control" value="<?php echo $auditorName; ?>" disabled></td>
										<td style="width: 120px;">Audit Date:</td>
										<td style="width:250px"><input type="text" class="form-control" value="<?php echo $auditDate; ?>" disabled></td>
										<td>Call Date:<span style="font-size:24px;color:red">*</span></td>
										<td style="width:250px;"><input type="text" class="form-control" id="from_date" name="call_date" value="<?php echo $clDate_val; ?>" required ></td>
									</tr>
									<tr>
										<td>Agent:<span style="font-size:24px;color:red">*</span></td>
										<td>
											<select class="form-control" id="agent_id" name="data[agent_id]" required>
											<option value="">-Select-</option>
											<?php foreach($agentName as $row){
												$sCss='';
												if($row['id']==$agent_id) $sCss='selected';
											?>
												<option value="<?php echo $row['id']; ?>" <?php echo $sCss; ?>><?php echo $row['name']; ?></option>
											<?php } ?>
										</select>
										</td>
										<td>Fusion ID:</td>
										<td><input type="text" readonly class="form-control" id="fusion_id" name="" value="<?php echo $fusion_id; ?>"></td>
										<td>L1 Supervisor:</td>
										<td>
											<input type="text" class="form-control" id="tl_name"  value="<?php echo $tl_name; ?>" readonly>
												<input type="hidden" class="form-control" id="tl_id" name="data[tl_id]" value="<?php echo $tl_id; ?>" required>
										</td>
									</tr>
									<tr>
										<td>Campaign:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control" id="campaign" name="data[campaign]" value="<?php echo $pnb_outbound_sales_v1['campaign'] ?>" required></td>
										<td>Call Duration:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control" id="call_duration" name="data[call_duration]" value="<?php echo $pnb_outbound_sales_v1['call_duration'] ?>" required></td>
										<td>Incoming No.:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control" id="" name="data[incoming_no]" value="<?php echo $pnb_outbound_sales_v1['incoming_no'] ?>"  required>
									</tr>
									<tr>
										<td>Register No.:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control" id="register_no" name="data[register_no]" value="<?php echo $pnb_outbound_sales_v1['register_no'] ?>" required></td>
										<td>Customer Name:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control" id="customer_name" name="data[customer_name]" value="<?php echo $pnb_outbound_sales_v1['customer_name'] ?>" required></td>
										<td>Call Link:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control" id="call_link" name="data[call_link]" value="<?php echo $pnb_outbound_sales_v1['call_link'] ?>" required></td>
									</tr>
									<tr>
										<td>Ticket No.:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control" id="ticket_no" name="data[ticket_no]" value="<?php echo $pnb_outbound_sales_v1['ticket_no'] ?>" required></td>
										<td>Call Disconnect By:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control" id="call_disconnect_by" name="data[call_disconnect_by]" value="<?php echo $pnb_outbound_sales_v1['call_disconnect_by'] ?>"  required></td>
										<td>Tagging/Disposition:<span style="font-size:24px;color:red">*</span></td>
										<td>
											<input type="text" class="form-control" id="" name="data[tagging]" value="<?php echo $pnb_outbound_sales_v1['tagging'] ?>" required>
										</td>
									</tr>
									<tr>
										<td>Query/Service:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" value="<?php echo $pnb_outbound_sales_v1['query_service']?>" class="form-control" id="query_service" name="data[query_service]" required></td>
										<td>Type of Call:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control" id="call_type" name="data[call_type]" value="<?php echo $pnb_outbound_sales_v1['call_type'] ?>" required></td>
										<td>ACPT:<span style="font-size:24px;color:red">*</span></td>
											<td>
												<select class="form-control" id="" name="data[acpt]" required>
											
											    <option value="">-Select-</option>
											    <option value="Agent" <?= ($pnb_outbound_sales_v1['acpt']=="Agent")?"selected":"" ?>>Agent</option>
												<option value="Customer" <?= ($pnb_outbound_sales_v1['acpt']=="Customer")?"selected":"" ?>>Customer</option>
												<option value="Process" <?= ($pnb_outbound_sales_v1['acpt']=="Process")?"selected":"" ?>>Process</option>
												<option value="Technology" <?= ($pnb_outbound_sales_v1['acpt']=="Technology")?"selected":"" ?>>Technology</option>	
												<option value="NA" <?= ($pnb_outbound_sales_v1['acpt']=="NA")?"selected":"" ?>>NA</option>	
											</select>
										</td>
									</tr>
									<tr>
										<td>Audit Type:<span style="font-size:24px;color:red">*</span></td>
										<td>
											<select class="form-control" id="audit_type" name="data[audit_type]" required>
												 <option value="">-Select-</option>
                                                    <option value="CQ Audit" <?= ($pnb_outbound_sales_v1['audit_type']=="CQ Audit")?"selected":"" ?>>CQ Audit</option>
                                                    <option value="BQ Audit" <?= ($pnb_outbound_sales_v1['audit_type']=="BQ Audit")?"selected":"" ?>>BQ Audit</option>
                                                    <option value="Calibration" <?= ($pnb_outbound_sales_v1['audit_type']=="Calibration")?"selected":"" ?>>Calibration</option>
                                                    <option value="Pre-Certificate Mock Call" <?= ($pnb_outbound_sales_v1['audit_type']=="Pre-Certificate Mock Call")?"selected":"" ?>>Pre-Certificate Mock Call</option>
                                                    <option value="Certification Audit" <?= ($pnb_outbound_sales_v1['audit_type']=="Certification Audit")?"selected":"" ?>>Certification Audit</option>
                                                    <option value="OJT Audit"  <?= ($pnb_outbound_sales_v1['audit_type']=="OJT Audit")?"selected":"" ?>>OJT Audit</option>
                                                    <option value="Operation Audit"  <?= ($pnb_outbound_sales_v1['audit_type']=="Operation Audit")?"selected":"" ?>>Operation Audit</option>
                                                    <option value="Trainer Audit"  <?= ($pnb_outbound_sales_v1['audit_type']=="Trainer Audit")?"selected":"" ?>>Trainer Audit</option> 
											</select>
										</td>
										<td class="auType">Auditor Type <span style="font-size:24px;color:red">*</span></td>
										<td class="auType">
											<select class="form-control" id="auditor_type" name="data[auditor_type]">
												  <option value="">Select</option>
                                                    <option value="Master" <?= ($pnb_outbound_sales_v1['auditor_type']=="Master")?"selected":"" ?>>Master</option>
                                                    <option value="Regular" <?= ($pnb_outbound_sales_v1['auditor_type']=="Regular")?"selected":"" ?>>Regular</option>
											</select>
										</td>
										<td>VOC:<span style="font-size:24px;color:red">*</span></td>
										<td>
											<select class="form-control" id="voc" name="data[voc]" required>
												<option value="">-Select-</option>
													<option value="1"  <?= ($pnb_outbound_sales_v1['voc']=="1")?"selected":"" ?>>1</option>
													<option value="2"  <?= ($pnb_outbound_sales_v1['voc']=="2")?"selected":"" ?>>2</option>
													<option value="3"  <?= ($pnb_outbound_sales_v1['voc']=="3")?"selected":"" ?>>3</option>
													<option value="4"  <?= ($pnb_outbound_sales_v1['voc']=="4")?"selected":"" ?>>4</option>
													<option value="5"  <?= ($pnb_outbound_sales_v1['voc']=="5")?"selected":"" ?>>5</option>
													<option value="6"  <?= ($pnb_outbound_sales_v1['voc']=="6")?"selected":"" ?>>6</option>
													<option value="7"  <?= ($pnb_outbound_sales_v1['voc']=="7")?"selected":"" ?>>7</option>
													<option value="8"  <?= ($pnb_outbound_sales_v1['voc']=="8")?"selected":"" ?>>8</option>
													<option value="9"  <?= ($pnb_outbound_sales_v1['voc']=="9")?"selected":"" ?>>9</option>
													<option value="10"  <?= ($pnb_outbound_sales_v1['voc']=="10")?"selected":"" ?>>10</option>
											</select>
										</td>
									</tr>
									<tr style="background-color:#EAFAF1">
										<td>Prediactive CSAT:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" name="data[customer_voc]" class="form-control" value="<?php echo $pnb_outbound_sales_v1['customer_voc']; ?>" required></td>
										<td>Issue Resolved:<span style="font-size:24px;color:red">*</span></td>
										<td>
											<select class="form-control" name="data[issue_resolved]" required>
												<option value="">-Select-</option>
												<option <?php echo $pnb_outbound_sales_v1['issue_resolved']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option <?php echo $pnb_outbound_sales_v1['issue_resolved']=='No'?"selected":""; ?> value="No">No</option>
											</select>
										</td>
										<td>Customer came with (mood):<span style="font-size:24px;color:red">*</span></td>
										<td>
											<select class="form-control" name="data[customer_came_with_mood]" required>
												<option value="">-Select-</option>
												<option <?php echo $pnb_outbound_sales_v1['customer_came_with_mood']=='Happy'?"selected":""; ?> value="Happy">Happy</option>
												<option <?php echo $pnb_outbound_sales_v1['customer_came_with_mood']=='Not Happy'?"selected":""; ?> value="Not Happy">Not Happy</option>
												<option <?php echo $pnb_outbound_sales_v1['customer_came_with_mood']=='Neutral'?"selected":""; ?> value="Neutral">Neutral</option>
												<option <?php echo $pnb_outbound_sales_v1['customer_came_with_mood']=='Extremely Dissatisfied'?"selected":""; ?> value="Extremely Dissatisfied">Extremely Dissatisfied</option>
											</select>
										</td>
									</tr>
									<tr style="background-color:#EAFAF1">
										<td>Priority:<span style="font-size:24px;color:red">*</span></td>
										<td>
											<select class="form-control" name="data[priority]" required>
												<option value="">-Select-</option>
												<option <?php echo $pnb_outbound_sales_v1['priority']=='High'?"selected":""; ?> value="High">High</option>
												<option <?php echo $pnb_outbound_sales_v1['priority']=='Medium'?"selected":""; ?> value="Medium">Medium</option>
												<option <?php echo $pnb_outbound_sales_v1['priority']=='Low'?"selected":""; ?> value="Low">Low</option>
											</select>
										</td>
										<td>Product related:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" name="data[product_related]" class="form-control" value="<?php echo $pnb_outbound_sales_v1['product_related']; ?>" required></td>
										<td>Process related:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" name="data[process_related]" class="form-control" value="<?php echo $pnb_outbound_sales_v1['process_related']; ?>" required></td>
									</tr>
									<tr style="background-color:#EAFAF1">
										<td>Agent related:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" name="data[agent_related]" class="form-control" value="<?php echo $pnb_outbound_sales_v1['agent_related']; ?>" required></td>
										<td>Needs Escalation:<span style="font-size:24px;color:red">*</span></td>
										<td>
											<select class="form-control" name="data[need_escalation]" required>
												<option value="">-Select-</option>
												<option <?php echo $pnb_outbound_sales_v1['need_escalation']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option <?php echo $pnb_outbound_sales_v1['need_escalation']=='No'?"selected":""; ?> value="No">No</option>
											</select>
										</td>
										<td>Call Back Required?:<span style="font-size:24px;color:red">*</span></td>
										<td>
											<select class="form-control" name="data[call_back_required]" required>
												<option value="">-Select-</option>
												<option <?php echo $pnb_outbound_sales_v1['call_back_required']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option <?php echo $pnb_outbound_sales_v1['call_back_required']=='No'?"selected":""; ?> value="No">No</option>
											</select>
										</td>
									</tr>
									<tr>
										<td style="font-weight:bold; font-size:16px">Possible<br>Score:</td>
										<td><input type="text" readonly id="pnb_ob_sal_v1_possible_score" name="data[possible_score]" class="form-control" style="font-weight:bold" value="<?php echo $pnb_outbound_sales_v1['possible_score'] ?>"></td>
										<td style="font-weight:bold; font-size:16px">Earned Score: </td>
										<td><input type="text" readonly id="pnb_ob_sal_v1_earned_score" name="data[earned_score]" class="form-control" style="font-weight:bold" value="<?php echo $pnb_outbound_sales_v1['earned_score'] ?>"></td>
										<td style="font-weight:bold; font-size:16px; text-align:right">Overall Score:</td>
										<td><input type="text" readonly id="pnb_ob_sal_v1_overall_score" name="data[overall_score]" class="form-control pnb_outbound_sales_v1Fatal" style="font-weight:bold" value="<?php echo $pnb_outbound_sales_v1['overall_score'] ?>"></td>
									</tr>
								</tbody>
							</table>
							<table class="table table-striped skt-table">
								<tbody>
									<tr style="background-color:#A9CCE3; font-weight:bold">
										<!-- <td>Sub-Parameters</td> -->
										<td >Parameters</td>
										<td>Sub-Parameters</td>
										<td>Scorable</td>
										<td style="width:150px;">Rating</td>
										<td>Remarks</td>
									</tr>
									<tr>
										<td rowspan=3 style="background-color:#7DCEA0">Call opening </td>
										<td>Standard Call Opening (Greeting With Company Name Right Party Confirmation)</td>
										<td>2</td>
										<td>
										  <select name="data[call_opening_greeting]" class="form-control pnb_ob_sal_v1_point" required>
											<option pnb_ob_sal_v1_val=2 pnb_ob_sal_v1_max=2 value="Good" <?php if($pnb_outbound_sales_v1['call_opening_greeting']=="Good") echo "selected"; ?>>Good</option>
											<option pnb_ob_sal_v1_val=1 pnb_ob_sal_v1_max=2 value="Needs Improvement" <?php if($pnb_outbound_sales_v1['call_opening_greeting']=="Needs Improvement") echo "selected"; ?>>Needs Improvement</option>
											<option pnb_ob_sal_v1_val=0 pnb_ob_sal_v1_max=2 value="Poor" <?php if($pnb_outbound_sales_v1['call_opening_greeting']=="Poor") echo "selected"; ?>>Poor</option>
											<option pnb_ob_sal_v1_val=2 pnb_ob_sal_v1_max=2 value="N/A" <?php if($pnb_outbound_sales_v1['call_opening_greeting']=="N/A") echo "selected";?>>N/A</option>
										  </select>
									</td>
									<td><input type="text" name="data[cmt1]" value="<?php echo $pnb_outbound_sales_v1['cmt1']?>" class="form-control"/></td>
								</tr>
								<tr>
										<td>Purpose of the call</td>
										<td>3</td>
										<td>
										  <select name="data[call_purpose]" class="form-control pnb_ob_sal_v1_point" required>
											<option pnb_ob_sal_v1_val=3 pnb_ob_sal_v1_max=3 value="Good" <?php if($pnb_outbound_sales_v1['call_purpose']=="Good") echo "selected"; ?>>Good</option>
											<option pnb_ob_sal_v1_val=1.5 pnb_ob_sal_v1_max=3 value="Needs Improvement" <?php if($pnb_outbound_sales_v1['call_purpose']=="Needs Improvement") echo "selected"; ?>>Needs Improvement</option>
											<option pnb_ob_sal_v1_val=0 pnb_ob_sal_v1_max=3 value="Poor" <?php if($pnb_outbound_sales_v1['call_purpose']=="Poor") echo "selected"; ?>>Poor</option>
											<option pnb_ob_sal_v1_val=3 pnb_ob_sal_v1_max=3 value="N/A" <?php if($pnb_outbound_sales_v1['call_purpose']=="N/A") echo "selected";?>>N/A</option>
										  </select>
									</td>
									<td><input type="text" name="data[cmt2]" value="<?php echo $pnb_outbound_sales_v1['cmt2']?>" class="form-control"/></td>
								</tr>
								<tr>
										<td>Seek Permission</td>
										<td>2</td>
										<td>
										  <select name="data[seek_permission]" class="form-control pnb_ob_sal_v1_point" required>
											<option pnb_ob_sal_v1_val=2 pnb_ob_sal_v1_max=2 value="Good" <?php if($pnb_outbound_sales_v1['seek_permission']=="Good") echo "selected"; ?>>Good</option>
											<option pnb_ob_sal_v1_val=1 pnb_ob_sal_v1_max=2 value="Needs Improvement" <?php if($pnb_outbound_sales_v1['seek_permission']=="Needs Improvement") echo "selected"; ?>>Needs Improvement</option>
											<option pnb_ob_sal_v1_val=0 pnb_ob_sal_v1_max=2 value="Poor" <?php if($pnb_outbound_sales_v1['seek_permission']=="Poor") echo "selected"; ?>>Poor</option>
											<option pnb_ob_sal_v1_val=2 pnb_ob_sal_v1_max=2 value="N/A" <?php if($pnb_outbound_sales_v1['seek_permission']=="N/A") echo "selected";?>>N/A</option>
										  </select>
									</td>
									<td><input type="text" name="data[cmt3]" value="<?php echo $pnb_outbound_sales_v1['cmt3']?>" class="form-control"/></td>
								</tr>
								<tr>
									<td rowspan=3 style="background-color:#7DCEA0">Business criticality</td>
										<td>Benefit of product with real time example</td>
										<td>8</td>
										<td>
										  <select name="data[product_benefit]" class="form-control pnb_ob_sal_v1_point" required>
											<option pnb_ob_sal_v1_val=8 pnb_ob_sal_v1_max=8 value="Good" <?php if($pnb_outbound_sales_v1['product_benefit']=="Good") echo "selected"; ?>>Good</option>
											<option pnb_ob_sal_v1_val=4 pnb_ob_sal_v1_max=8 value="Needs Improvement" <?php if($pnb_outbound_sales_v1['product_benefit']=="Needs Improvement") echo "selected"; ?>>Needs Improvement</option>
											<option pnb_ob_sal_v1_val=0 pnb_ob_sal_v1_max=8 value="Poor" <?php if($pnb_outbound_sales_v1['product_benefit']=="Poor") echo "selected"; ?>>Poor</option>
											<option pnb_ob_sal_v1_val=8 pnb_ob_sal_v1_max=8 value="N/A" <?php if($pnb_outbound_sales_v1['product_benefit']=="N/A") echo "selected";?>>N/A</option>
										  </select>
									</td>
									<td><input type="text" name="data[cmt4]" value="<?php echo $pnb_outbound_sales_v1['cmt4']?>" class="form-control"/></td>
								</tr>
								<tr>
										<td>Complete product presentation</td>
										<td>10</td>
										<td>
										  <select name="data[complete_product]" class="form-control pnb_ob_sal_v1_point" required>
											<option pnb_ob_sal_v1_val=10 pnb_ob_sal_v1_max=10 value="Good" <?php if($pnb_outbound_sales_v1['complete_product']=="Good") echo "selected"; ?>>Good</option>
											<option pnb_ob_sal_v1_val=5 pnb_ob_sal_v1_max=10 value="Needs Improvement" <?php if($pnb_outbound_sales_v1['complete_product']=="Needs Improvement") echo "selected"; ?>>Needs Improvement</option>
											<option pnb_ob_sal_v1_val=0 pnb_ob_sal_v1_max=10 value="Poor" <?php if($pnb_outbound_sales_v1['complete_product']=="Poor") echo "selected"; ?>>Poor</option>
											<option pnb_ob_sal_v1_val=10 pnb_ob_sal_v1_max=10 value="N/A" <?php if($pnb_outbound_sales_v1['complete_product']=="N/A") echo "selected";?>>N/A</option>
										  </select>
									</td>
									<td><input type="text" name="data[cmt5]" value="<?php echo $pnb_outbound_sales_v1['cmt5']?>" class="form-control"/></td>
								</tr>
								<tr>
										<td>Earning potential</td>
										<td>8</td>
										<td>
										  <select name="data[earning_potential]" class="form-control pnb_ob_sal_v1_point" required>
											<option pnb_ob_sal_v1_val=8 pnb_ob_sal_v1_max=8 value="Good" <?php if($pnb_outbound_sales_v1['earning_potential']=="Good") echo "selected"; ?>>Good</option>
											<option pnb_ob_sal_v1_val=4 pnb_ob_sal_v1_max=8 value="Needs Improvement" <?php if($pnb_outbound_sales_v1['earning_potential']=="Needs Improvement") echo "selected"; ?>>Needs Improvement</option>
											<option pnb_ob_sal_v1_val=0 pnb_ob_sal_v1_max=8 value="Poor" <?php if($pnb_outbound_sales_v1['earning_potential']=="Poor") echo "selected"; ?>>Poor</option>
											<option pnb_ob_sal_v1_val=8 pnb_ob_sal_v1_max=8 value="N/A" <?php if($pnb_outbound_sales_v1['earning_potential']=="N/A") echo "selected";?>>N/A</option>
										  </select>
									</td>
									<td><input type="text" name="data[cmt6]" value="<?php echo $pnb_outbound_sales_v1['cmt6']?>" class="form-control"/></td>
								</tr>
								<tr>
									<td rowspan=4 style="background-color:#7DCEA0">Objection Handling</td>
										<td>Sales Urgency creation  & Proper effective Rebuttal Given (Agent efforts to sell on call)</td>
										<td>8</td>
										<td>
										  <select name="data[sales_urgency]" class="form-control pnb_ob_sal_v1_point" required>
											<option pnb_ob_sal_v1_val=8 pnb_ob_sal_v1_max=8 value="Good" <?php if($pnb_outbound_sales_v1['sales_urgency']=="Good") echo "selected"; ?>>Good</option>
											<option pnb_ob_sal_v1_val=4 pnb_ob_sal_v1_max=8 value="Needs Improvement" <?php if($pnb_outbound_sales_v1['sales_urgency']=="Needs Improvement") echo "selected"; ?>>Needs Improvement</option>
											<option pnb_ob_sal_v1_val=0 pnb_ob_sal_v1_max=8 value="Poor" <?php if($pnb_outbound_sales_v1['sales_urgency']=="Poor") echo "selected"; ?>>Poor</option>
											<option pnb_ob_sal_v1_val=8 pnb_ob_sal_v1_max=8 value="N/A" <?php if($pnb_outbound_sales_v1['sales_urgency']=="N/A") echo "selected";?>>N/A</option>
										  </select>
									</td>
									<td><input type="text" name="data[cmt7]" value="<?php echo $pnb_outbound_sales_v1['cmt7']?>" class="form-control"/></td>
								</tr>
								<tr>
										<td>Effective Probing (open / close ended questions to be asked as per propose purchase )</td>
										<td>8</td>
										<td>
										  <select name="data[effective_probing]" class="form-control pnb_ob_sal_v1_point" required>
											<option pnb_ob_sal_v1_val=8 pnb_ob_sal_v1_max=8 value="Good" <?php if($pnb_outbound_sales_v1['effective_probing']=="Good") echo "selected"; ?>>Good</option>
											<option pnb_ob_sal_v1_val=4 pnb_ob_sal_v1_max=8 value="Needs Improvement" <?php if($pnb_outbound_sales_v1['effective_probing']=="Needs Improvement") echo "selected"; ?>>Needs Improvement</option>
											<option pnb_ob_sal_v1_val=0 pnb_ob_sal_v1_max=8 value="Poor" <?php if($pnb_outbound_sales_v1['effective_probing']=="Poor") echo "selected"; ?>>Poor</option>
											<option pnb_ob_sal_v1_val=8 pnb_ob_sal_v1_max=8 value="N/A" <?php if($pnb_outbound_sales_v1['effective_probing']=="N/A") echo "selected";?>>N/A</option>
										  </select>
									</td>
									<td><input type="text" name="data[cmt8]" value="<?php echo $pnb_outbound_sales_v1['cmt8']?>" class="form-control"/></td>
								</tr>
								<tr>
										<td style="color:red;">Complete product & process information</td>
										<td>10</td>
										<td>
										  <select name="data[process_information]" class="form-control pnb_ob_sal_v1_point pnb_ob_sales_v1_fatal" id="ob_sales_fatal1" required>
											<option pnb_ob_sal_v1_val=10 pnb_ob_sal_v1_max=10 value="Good" <?php if($pnb_outbound_sales_v1['process_information']=="Good") echo "selected"; ?>>Good</option>
											<option pnb_ob_sal_v1_val=0 pnb_ob_sal_v1_max=10 value="Fatal" <?php if($pnb_outbound_sales_v1['process_information']=="Fatal") echo "selected"; ?>>Fatal</option>
										  </select>
									</td>
									<td><input type="text" name="data[cmt9]" value="<?php echo $pnb_outbound_sales_v1['cmt9']?>" class="form-control"/></td>
								</tr>
								<tr>
										<td>Lead creation </td>
										<td>6</td>
										<td>
										  <select name="data[lead_creation]" class="form-control pnb_ob_sal_v1_point" required>
											<option pnb_ob_sal_v1_val=6 pnb_ob_sal_v1_max=6 value="Good" <?php if($pnb_outbound_sales_v1['lead_creation']=="Good") echo "selected"; ?>>Good</option>
											<option pnb_ob_sal_v1_val=3 pnb_ob_sal_v1_max=6 value="Needs Improvement" <?php if($pnb_outbound_sales_v1['lead_creation']=="Needs Improvement") echo "selected"; ?>>Needs Improvement</option>
											<option pnb_ob_sal_v1_val=0 pnb_ob_sal_v1_max=6 value="Poor" <?php if($pnb_outbound_sales_v1['lead_creation']=="Poor") echo "selected"; ?>>Poor</option>
											<option pnb_ob_sal_v1_val=6 pnb_ob_sal_v1_max=6 value="N/A" <?php if($pnb_outbound_sales_v1['lead_creation']=="N/A") echo "selected";?>>N/A</option>
										  </select>
									</td>
									<td><input type="text" name="data[cmt10]" value="<?php echo $pnb_outbound_sales_v1['cmt10']?>" class="form-control"/></td>
								</tr>
								<tr>
									<td rowspan=6 style="background-color:#7DCEA0">Sales building skill/ soft skill</td>
										<td>Appropriate Empathy/Apology Wherever Applicable / Professional Tone / Assurance</td>
										<td>3</td>
										<td>
										  <select name="data[appropriate_empathy]" class="form-control pnb_ob_sal_v1_point" required>
											<option pnb_ob_sal_v1_val=3 pnb_ob_sal_v1_max=3 value="Good" <?php if($pnb_outbound_sales_v1['appropriate_empathy']=="Good") echo "selected"; ?>>Good</option>
											<option pnb_ob_sal_v1_val=1.5 pnb_ob_sal_v1_max=3 value="Needs Improvement" <?php if($pnb_outbound_sales_v1['appropriate_empathy']=="Needs Improvement") echo "selected"; ?>>Needs Improvement</option>
											<option pnb_ob_sal_v1_val=0 pnb_ob_sal_v1_max=3 value="Poor" <?php if($pnb_outbound_sales_v1['appropriate_empathy']=="Poor") echo "selected"; ?>>Poor</option>
											<option pnb_ob_sal_v1_val=3 pnb_ob_sal_v1_max=3 value="N/A" <?php if($pnb_outbound_sales_v1['appropriate_empathy']=="N/A") echo "selected";?>>N/A</option>
										  </select>
									</td>
									<td><input type="text" name="data[cmt11]" value="<?php echo $pnb_outbound_sales_v1['cmt11']?>" class="form-control"/></td>
								</tr>
								<tr>
										<td>Personalization & Connect</td>
										<td>3</td>
										<td>
										  <select name="data[personalization_connect]" class="form-control pnb_ob_sal_v1_point" required>
											<option pnb_ob_sal_v1_val=3 pnb_ob_sal_v1_max=3 value="Good" <?php if($pnb_outbound_sales_v1['personalization_connect']=="Good") echo "selected"; ?>>Good</option>
											<option pnb_ob_sal_v1_val=1.5 pnb_ob_sal_v1_max=3 value="Needs Improvement" <?php if($pnb_outbound_sales_v1['personalization_connect']=="Needs Improvement") echo "selected"; ?>>Needs Improvement</option>
											<option pnb_ob_sal_v1_val=0 pnb_ob_sal_v1_max=3 value="Poor" <?php if($pnb_outbound_sales_v1['personalization_connect']=="Poor") echo "selected"; ?>>Poor</option>
											<option pnb_ob_sal_v1_val=3 pnb_ob_sal_v1_max=3 value="N/A" <?php if($pnb_outbound_sales_v1['personalization_connect']=="N/A") echo "selected";?>>N/A</option>
										  </select>
									</td>
									<td><input type="text" name="data[cmt12]" value="<?php echo $pnb_outbound_sales_v1['cmt12']?>" class="form-control"/></td>
								</tr>
								<tr>
										<td>Ros/Clarity Of Speech / Jargons</td>
										<td>3</td>
										<td>
										  <select name="data[jargons]" class="form-control pnb_ob_sal_v1_point" required>
											<option pnb_ob_sal_v1_val=3 pnb_ob_sal_v1_max=3 value="Good" <?php if($pnb_outbound_sales_v1['jargons']=="Good") echo "selected"; ?>>Good</option>
											<option pnb_ob_sal_v1_val=1.5 pnb_ob_sal_v1_max=3 value="Needs Improvement" <?php if($pnb_outbound_sales_v1['jargons']=="Needs Improvement") echo "selected"; ?>>Needs Improvement</option>
											<option pnb_ob_sal_v1_val=0 pnb_ob_sal_v1_max=3 value="Poor" <?php if($pnb_outbound_sales_v1['jargons']=="Poor") echo "selected"; ?>>Poor</option>
											<option pnb_ob_sal_v1_val=3 pnb_ob_sal_v1_max=3 value="N/A" <?php if($pnb_outbound_sales_v1['jargons']=="N/A") echo "selected";?>>N/A</option>
										  </select>
									</td>
									<td><input type="text" name="data[cmt13]" value="<?php echo $pnb_outbound_sales_v1['cmt13']?>" class="form-control"/></td>
								</tr>
								<tr>
										<td>Active Listening/Attentive On Call</td>
										<td>2</td>
										<td>
										  <select name="data[active_listening]" class="form-control pnb_ob_sal_v1_point" required>
											<option pnb_ob_sal_v1_val=2 pnb_ob_sal_v1_max=2 value="Good" <?php if($pnb_outbound_sales_v1['active_listening']=="Good") echo "selected"; ?>>Good</option>
											<option pnb_ob_sal_v1_val=1 pnb_ob_sal_v1_max=2 value="Needs Improvement" <?php if($pnb_outbound_sales_v1['active_listening']=="Needs Improvement") echo "selected"; ?>>Needs Improvement</option>
											<option pnb_ob_sal_v1_val=0 pnb_ob_sal_v1_max=2 value="Poor" <?php if($pnb_outbound_sales_v1['active_listening']=="Poor") echo "selected"; ?>>Poor</option>
											<option pnb_ob_sal_v1_val=2 pnb_ob_sal_v1_max=2 value="N/A" <?php if($pnb_outbound_sales_v1['active_listening']=="N/A") echo "selected";?>>N/A</option>
										  </select>
									</td>
									<td><input type="text" name="data[cmt14]" value="<?php echo $pnb_outbound_sales_v1['cmt14']?>" class="form-control"/></td>
								</tr>
								<tr>
										<td>Interruption & Parallel Talking</td>
										<td>3</td>
										<td>
										  <select name="data[interruption_talk]" class="form-control pnb_ob_sal_v1_point" required>
											<option pnb_ob_sal_v1_val=3 pnb_ob_sal_v1_max=3 value="Good" <?php if($pnb_outbound_sales_v1['interruption_talk']=="Good") echo "selected"; ?>>Good</option>
											<option pnb_ob_sal_v1_val=1.5 pnb_ob_sal_v1_max=3 value="Needs Improvement" <?php if($pnb_outbound_sales_v1['interruption_talk']=="Needs Improvement") echo "selected"; ?>>Needs Improvement</option>
											<option pnb_ob_sal_v1_val=0 pnb_ob_sal_v1_max=3 value="Poor" <?php if($pnb_outbound_sales_v1['interruption_talk']=="Poor") echo "selected"; ?>>Poor</option>
											<option pnb_ob_sal_v1_val=3 pnb_ob_sal_v1_max=3 value="N/A" <?php if($pnb_outbound_sales_v1['interruption_talk']=="N/A") echo "selected";?>>N/A</option>
										  </select>
									</td>
									<td><input type="text" name="data[cmt15]" value="<?php echo $pnb_outbound_sales_v1['cmt15']?>" class="form-control"/></td>
								</tr>
								<tr>
										<td>HMT</td>
										<td>3</td>
										<td>
										  <select name="data[hmt]" class="form-control pnb_ob_sal_v1_point" required>
											<option pnb_ob_sal_v1_val=3 pnb_ob_sal_v1_max=3 value="Good" <?php if($pnb_outbound_sales_v1['hmt']=="Good") echo "selected"; ?>>Good</option>
											<option pnb_ob_sal_v1_val=1.5 pnb_ob_sal_v1_max=3 value="Needs Improvement" <?php if($pnb_outbound_sales_v1['hmt']=="Needs Improvement") echo "selected"; ?>>Needs Improvement</option>
											<option pnb_ob_sal_v1_val=0 pnb_ob_sal_v1_max=3 value="Poor" <?php if($pnb_outbound_sales_v1['hmt']=="Poor") echo "selected"; ?>>Poor</option>
											<option pnb_ob_sal_v1_val=3 pnb_ob_sal_v1_max=3 value="N/A" <?php if($pnb_outbound_sales_v1['hmt']=="N/A") echo "selected";?>>N/A</option>
										  </select>
									</td>
									<td><input type="text" name="data[cmt16]" value="<?php echo $pnb_outbound_sales_v1['cmt16']?>" class="form-control"/></td>
								</tr>
								<tr>
									<td rowspan=2 style="background-color:#7DCEA0">Documentation</td>
										<td>Convox/CRM Comments captured properly</td>
										<td>4</td>
										<td>
										  <select name="data[convox_comment]" class="form-control pnb_ob_sal_v1_point" required>
											<option pnb_ob_sal_v1_val=4 pnb_ob_sal_v1_max=4 value="Good" <?php if($pnb_outbound_sales_v1['convox_comment']=="Good") echo "selected"; ?>>Good</option>
											<option pnb_ob_sal_v1_val=2 pnb_ob_sal_v1_max=4 value="Needs Improvement" <?php if($pnb_outbound_sales_v1['convox_comment']=="Needs Improvement") echo "selected"; ?>>Needs Improvement</option>
											<option pnb_ob_sal_v1_val=0 pnb_ob_sal_v1_max=4 value="Poor" <?php if($pnb_outbound_sales_v1['convox_comment']=="Poor") echo "selected"; ?>>Poor</option>
											<option pnb_ob_sal_v1_val=4 pnb_ob_sal_v1_max=4 value="N/A" <?php if($pnb_outbound_sales_v1['convox_comment']=="N/A") echo "selected";?>>N/A</option>
										  </select>
									</td>
									<td><input type="text" name="data[cmt17]" value="<?php echo $pnb_outbound_sales_v1['cmt17']?>" class="form-control"/></td>
								</tr>
								<tr>
										<td style="color:red;">Tagging/Disposition</td>
										<td>4</td>
										<td>
										  <select name="data[tagging]" class="form-control pnb_ob_sal_v1_point pnb_ob_sales_v1_fatal" id="ob_sales_fatal2" required>
											<option pnb_ob_sal_v1_val=4 pnb_ob_sal_v1_max=4 value="Good" <?php if($pnb_outbound_sales_v1['tagging']=="Good") echo "selected"; ?>>Good</option>
											<option pnb_ob_sal_v1_val=0 pnb_ob_sal_v1_max=4 value="Fatal" <?php if($pnb_outbound_sales_v1['tagging']=="Fatal") echo "selected"; ?>>Fatal</option>
										  </select>
									</td>
									<td><input type="text" name="data[cmt18]" value="<?php echo $pnb_outbound_sales_v1['cmt18']?>" class="form-control"/></td>
								</tr>
								<tr>
									<td rowspan=2 style="background-color:#7DCEA0">Call closing</td>
										<td>Admiration and service promise </td>
										<td>3</td>
										<td>
										  <select name="data[service_promise]" class="form-control pnb_ob_sal_v1_point" id="" required>
											<option pnb_ob_sal_v1_val=3 pnb_ob_sal_v1_max=3 value="Good" <?php if($pnb_outbound_sales_v1['service_promise']=="Good") echo "selected"; ?>>Good</option>
											<option pnb_ob_sal_v1_val=1.5 pnb_ob_sal_v1_max=3 value="Needs Improvement" <?php if($pnb_outbound_sales_v1['service_promise']=="Needs Improvement") echo "selected"; ?>>Needs Improvement</option>
											<option pnb_ob_sal_v1_val=0 pnb_ob_sal_v1_max=3 value="Poor" <?php if($pnb_outbound_sales_v1['service_promise']=="Poor") echo "selected"; ?>>Poor</option>
											<option pnb_ob_sal_v1_val=3 pnb_ob_sal_v1_max=3 value="N/A" <?php if($pnb_outbound_sales_v1['service_promise']=="N/A") echo "selected";?>>N/A</option>
										  </select>
									</td>
									<td><input type="text" name="data[cmt19]" value="<?php echo $pnb_outbound_sales_v1['cmt19']?>" class="form-control"/></td>
								</tr>
								<tr>
										<td>Positive call closing</td>
										<td>3</td>
										<td>
										  <select name="data[positive_call_closing]" class="form-control pnb_ob_sal_v1_point" id="" required>
											<option pnb_ob_sal_v1_val=3 pnb_ob_sal_v1_max=3 value="Good" <?php if($pnb_outbound_sales_v1['positive_call_closing']=="Good") echo "selected"; ?>>Good</option>
											<option pnb_ob_sal_v1_val=1.5 pnb_ob_sal_v1_max=3 value="Needs Improvement" <?php if($pnb_outbound_sales_v1['positive_call_closing']=="Needs Improvement") echo "selected"; ?>>Needs Improvement</option>
											<option pnb_ob_sal_v1_val=0 pnb_ob_sal_v1_max=3 value="Poor" <?php if($pnb_outbound_sales_v1['positive_call_closing']=="Poor") echo "selected"; ?>>Poor</option>
											<option pnb_ob_sal_v1_val=3 pnb_ob_sal_v1_max=3 value="N/A" <?php if($pnb_outbound_sales_v1['positive_call_closing']=="N/A") echo "selected";?>>N/A</option>
										  </select>
									</td>
									<td><input type="text" name="data[cmt20]" value="<?php echo $pnb_outbound_sales_v1['cmt20']?>" class="form-control"/></td>
								</tr>
								<tr>
									<td style="background-color:#7DCEA0; color:red;">Zero Tolerance Policy</td>
										<td style="color:red;">Policy And Procedure Followed By The Agent As Per ZTP (Rude And Profanity Etc).</td>
										<td>4</td>
										<td>
										  <select name="data[ztp]" class="form-control pnb_ob_sal_v1_point pnb_ob_sales_v1_fatal" id="ob_sales_fatal3" required>
											<option pnb_ob_sal_v1_val=4 pnb_ob_sal_v1_max=4 value="Good" <?php if($pnb_outbound_sales_v1['ztp']=="Good") echo "selected"; ?>>Good</option>
											<option pnb_ob_sal_v1_val=0 pnb_ob_sal_v1_max=4 value="Fatal" <?php if($pnb_outbound_sales_v1['ztp']=="Fatal") echo "selected"; ?>>Fatal</option>
										  </select>
									</td>
									<td><input type="text" name="data[cmt21]" value="<?php echo $pnb_outbound_sales_v1['cmt21']?>" class="form-control"/></td>
								</tr>
								<tr>
									<td>Call Summary:</td>
									<td colspan="6"><textarea class="form-control" name="data[call_summary]"><?php echo $pnb_outbound_sales_v1['call_summary'] ?></textarea></td>
									</tr>
								
								<tr>
									<td>Feedback:</td>
									<td colspan="6"><textarea class="form-control" name="data[feedback]"><?php echo $pnb_outbound_sales_v1['feedback'] ?></textarea></td>
								</tr>
								<tr>
											<td colspan=2>Upload Files [m4a,mp4,mp3,wav]</td>
											<?php if ($pnboutbound_v1_id == 0) { ?>
												<td colspan=6>
													<input type="file" name="attach_file[]" id="attach_file" accept=".m4a,.mp4,.mp3,.wav,audio/*" />
												</td>
												<?php } else {
												if ($pnb_outbound_sales_v1['attach_file'] != '') { ?>
													<td colspan=6>
														<input type="file" multiple class="form-control"  id="attach_file" name="attach_file[]" accept=".m4a,.mp4,.mp3,.wav,audio/*"> 
														<?php $attach_file = explode(",", $pnb_outbound_sales_v1['attach_file']);
														foreach ($attach_file as $mp) { ?>
															<audio controls='' style="background-color:#607F93">
																<source src="<?php echo base_url(); ?>qa_files/pnb_outbound_sales_v1/<?php echo $mp; ?>" type="audio/ogg">
																<source src="<?php echo base_url(); ?>qa_files/pnb_outbound_sales_v1/<?php echo $mp; ?>" type="audio/mpeg">
															</audio> </br>
														<?php } ?>
													</td>
											<?php } else {
													echo '<td colspan=6>
													<input type="file" multiple class="form-control" id="attach_file" name="attach_file[]" accept=".m4a,.mp4,.mp3,.wav,audio/*">
													<b>No Files</b></td>';
												}
											} ?>
								</tr>
								
									
									<?php if($pnboutbound_v1_id!=0){ ?>
										<tr><td colspan=2 style="font-size:16px; font-weight:bold">Agent Feedback Acceptance:</td><td colspan=6><?php echo $pnb_outbound_sales_v1['agnt_fd_acpt'] ?></td></tr>
										<tr><td colspan=2 style="font-size:16px; font-weightbold">Agent Review:</td><td colspan=6><?php echo $pnb_outbound_sales_v1['agent_rvw_note'] ?></td></tr>
										<tr><td colspan=2 style="font-size:16px; font-weight:bold">Management Review:</td><td colspan=6><?php echo $pnb_outbound_sales_v1['mgnt_rvw_note'] ?></td></tr>
										<tr><td colspan=2 style="font-size:16px; font-weight:bold">Client Review:</td><td colspan=6><?php echo $pnb_outbound_sales_v1['client_rvw_note'] ?></td></tr>

										<tr><td colspan=2  style="font-size:16px">Your Review<span style="font-size:24px;color:red">*</span></td><td colspan=6><textarea class="form-control1" style="width:100%" id="note" name="note" required></textarea></td></tr>
									<?php } ?>


									<?php
									if($pnboutbound_v1_id==0){
										if(is_access_qa_module()==true || is_access_qa_operations_module()==true){ ?>
											<tr><td colspan=6><button class="btn btn-success waves-effect new-btn" type="submit" id="qaformsubmit">SAVE</button></td></tr>
									<?php
										}
									}else{
										if(is_access_qa_module()==true || is_access_qa_operations_module()==true){
											if(is_available_qa_feedback($pnb_outbound_sales_v1['entry_date'],72) == true){ ?>
												<tr><td colspan="6"><button class="btn btn-success waves-effect new-btn" type="submit" id='qaformsubmit' name='btnSave' value="SAVE" style="width:500px">SAVE</button></td></tr>
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
