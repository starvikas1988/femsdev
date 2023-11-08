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
.ui-datepicker .ui-datepicker-buttonpane button.ui-datepicker-current {
	 float: left;
	 display: none;
	}
</style>

<?php if($ajio_social_media_id!=0){
if(is_access_qa_edit_feedback()==false){ ?>
	<style>
		.form_ajio{
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
										<td colspan="6" id="theader" style="font-size:40px">Social Media-Quality Form</td>
										<input type="hidden" name="audit_start_time" value="<?php echo CurrMySqlDate(); ?>">
									</tr>
									<?php
										if($ajio_social_media_id==0){
											$auditorName = get_username();
											$auditDate = CurrDateMDY();
											$clDate_val='';
										}else{
											if($ajio_social_media_data['entry_by']!=''){
												$auditorName = $ajio_social_media_data['auditor_name'];
											}else{
												$auditorName = $ajio_social_media_data['client_name'];
											}
											$auditDate = mysql2mmddyy($ajio_social_media_data['audit_date']);
											$clDate_val = mysqlDt2mmddyy($ajio_social_media_data['call_date']);
										}
										if ($rand_id != 0) {
											$agent_id = $rand_data['sid'];
											$fusion_id = $rand_data['fusion_id'];
											$agent_name = $rand_data['fname'] . " " . $rand_data['lname'];
											$tl_id = $rand_data['assigned_to'];
											$tl_name = $rand_data['tl_name'];
											$call_duration = $rand_data['call_duration'];
											
										} else {
											$agent_id = $ajio_social_media_data['agent_id'];
											$fusion_id = $ajio_social_media_data['fusion_id'];
											$agent_name = $ajio_social_media_data['fname'] . " " . $ajio_social_media_data['lname'] ;
											$tl_id = $ajio_social_media_data['tl_id'];
											$tl_name = $ajio_social_media_data['tl_name'];
											$call_duration = $ajio_social_media_data['call_duration'];
										}
									?>
									<tr>
										<td>Auditor Name:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control form_ajio" value="<?php echo $auditorName; ?>" disabled></td>
										<td>Audit Date:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control form_ajio" value="<?php echo $auditDate; ?>" disabled></td>
										<td>Interaction ID:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control form_ajio" name="data[interaction_id]" pattern="^[a-zA-Z0-9_]*$" title="Only alphanumeric allowed" value="<?php echo $ajio_social_media_data['interaction_id'] ?>" required ></td>
										
									</tr>
									<tr>
										<td>Agent Name:<span style="font-size:24px;color:red">*</span></td>
										<td>
											<select class="form-control form_ajio" id="agent_id" name="data[agent_id]" required>
											<option value="">-Select-</option>
											<?php foreach($agentName as $row){
												$sCss='';
												if($row['id']==$agent_id) $sCss='selected';
											?>
												<option value="<?php echo $row['id']; ?>" <?php echo $sCss; ?>><?php echo $row['name']; ?></option>
											<?php } ?>
										</select>
										</td>
										<td>Employee <br>ID:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control form_ajio" id="fusion_id" value="<?php echo $ajio_social_media_data['fusion_id'] ?>" readonly ></td>
										<td>L1 <br>Supervisor:<span style="font-size:24px;color:red">*</span></td>
										<td>
											<input type="text" class="form-control form_ajio" id="tl_name"  value="<?php echo $tl_name; ?>" readonly>
												<input type="hidden" class="form-control form_ajio" id="tl_id" name="data[tl_id]" value="<?php echo $tl_id; ?>" required>
										</td>
									</tr>
									<tr>
										<td>Auditor's BP Id:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control form_ajio" name="data[agent_bp_id]" pattern="^[a-zA-Z0-9_]*$" title="Only alphanumeric allowed" value="<?php echo $ajio_social_media_data['agent_bp_id'] ?>" required ></td>
										<td>Call Date/<br>Time:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control form_ajio" id="call_date_time" name="call_date" value="<?php echo $clDate_val; ?>" required></td>
										<td>Call <br>Duration:<span style="font-size:24px;color:red">*</span></td>
										<td>
											<input type="text" class="form-control form_ajio"  id="" name="data[call_duration]" value="<?php echo $call_duration; ?>" required>
										</td>
									</tr>
									
									<tr>
										<td>Order Id:<span style="font-size:24px;color:red">*</span></td>
										<td>
											<input type="text" class="form-control form_ajio" id="" name="data[order_id]" pattern="^[a-zA-Z0-9_]*$" title="Only alphanumeric allowed" value="<?php echo $ajio_social_media_data['order_id'] ?>" required>
										</td>
										<td>VOC:<span style="font-size:24px;color:red">*</span></td>
											<td>
												<select class="form-control form_ajio" id="voc" name="data[voc]" required>
													
													<option value="">-Select-</option>
													<option value="1"  <?= ($ajio_social_media_data['voc']=="1")?"selected":"" ?>>1</option>
													<option value="2"  <?= ($ajio_social_media_data['voc']=="2")?"selected":"" ?>>2</option>
													<option value="3"  <?= ($ajio_social_media_data['voc']=="3")?"selected":"" ?>>3</option>
													<option value="4"  <?= ($ajio_social_media_data['voc']=="4")?"selected":"" ?>>4</option>
													<option value="5"  <?= ($ajio_social_media_data['voc']=="5")?"selected":"" ?>>5</option>
													<option value="6"  <?= ($ajio_social_media_data['voc']=="6")?"selected":"" ?>>6</option>
													<option value="7"  <?= ($ajio_social_media_data['voc']=="7")?"selected":"" ?>>7</option>
													<option value="8"  <?= ($ajio_social_media_data['voc']=="8")?"selected":"" ?>>8</option>
													<option value="9"  <?= ($ajio_social_media_data['voc']=="9")?"selected":"" ?>>9</option>
													<option value="10"  <?= ($ajio_social_media_data['voc']=="10")?"selected":"" ?>>10</option>
												</select>
											</td>
										<td>Call <br>Synopsis:<span style="font-size:24px;color:red">*</span></td>
										<td>
											<input type="text" class="form-control form_ajio" id="" name="data[call_synopsis]" pattern="^[a-zA-Z0-9_]*$" title="Only alphanumeric allowed" value="<?php echo $ajio_social_media_data['call_synopsis'] ?>" required>
										</td>
										
									</tr>
									<tr>
										<td>Ticket ID:<span style="font-size:24px;color:red">*</span></td>
										<td>
											<input type="text" class="form-control form_ajio" id="" name="data[ticket_id]" pattern="^[a-zA-Z0-9_]*$" title="Only alphanumeric allowed" value="<?php echo $ajio_social_media_data['ticket_id'] ?>" required>
										</td>
										<td>Ticket Type:<span style="font-size:24px;color:red">*</span></td>
										<td>
											<select class="form-control form_ajio" name="data[ticket_type]" required>
											<option value="">-Select-</option>
											<option value="Complaint"  <?= ($ajio_social_media_data['ticket_type']=="Complaint")?"selected":"" ?>>Complaint</option>
											<option value="Query"  <?= ($ajio_social_media_data['ticket_type']=="Query")?"selected":"" ?>>Query</option>
											<option value="Proactive SR"  <?= ($ajio_social_media_data['ticket_type']=="Proactive SR")?"selected":"" ?>>Proactive SR</option>
											</select>
										</td>
										<td>KPI - ACPT:<span style="font-size:24px;color:red">*</span></td>
										<td>
											<select class="form-control form_ajio" name="data[KPI_ACPT]" required>
												<option value="">-Select-</option>
												<option <?php echo $ajio_social_media_data['KPI_ACPT'] == "Agent"?"selected":"";?> value="Agent">Agent</option>
												<option <?php echo $ajio_social_media_data['KPI_ACPT'] == "Process"?"selected":"";?> value="Process">Process</option>
												<option <?php echo $ajio_social_media_data['KPI_ACPT'] == "Customer"?"selected":"";?> value="Customer">Customer</option>
												<option <?php echo $ajio_social_media_data['KPI_ACPT'] == "Technology"?"selected":"";?> value="Technology">Technology</option>
												<option <?php echo $ajio_social_media_data['KPI_ACPT'] == "NA"?"selected":"";?> value="NA">NA</option>
											</select> 
										</td>
									</tr>
									
									<tr>
										
										<td>Audit Type:<span style="font-size:24px;color:red">*</span></td>
										<td>
											<select class="form-control form_ajio" id="audit_type" name="data[audit_type]" required>
                                                    <option value="">-Select-</option>
                                                    <option value="CQ Audit" <?= ($ajio_social_media_data['audit_type']=="CQ Audit")?"selected":"" ?>>CQ Audit</option>
                                                    <option value="BQ Audit" <?= ($ajio_social_media_data['audit_type']=="BQ Audit")?"selected":"" ?>>BQ Audit</option>
                                                    <option value="Calibration" <?= ($ajio_social_media_data['audit_type']=="Calibration")?"selected":"" ?>>Calibration</option>
                                                    <option value="Pre-Certificate Mock Call" <?= ($ajio_social_media_data['audit_type']=="Pre-Certificate Mock Call")?"selected":"" ?>>Pre-Certificate Mock Call</option>
                                                    <option value="Certification Audit" <?= ($ajio_social_media_data['audit_type']=="Certification Audit")?"selected":"" ?>>Certification Audit</option>
                                                    <option value="WoW Call"  <?= ($ajio_social_media_data['audit_type']=="WoW Call")?"selected":"" ?>>WoW Call</option>
                                                    <option value="Hygiene Audit"  <?= ($ajio_social_media_data['audit_type']=="Hygiene Audit")?"selected":"" ?>>Hygiene Audit</option>
                                                    <option value="Operation Audit"  <?= ($ajio_social_media_data['audit_type']=="Operation Audit")?"selected":"" ?>>Operation Audit</option>
                                                    <option value="Trainer Audit"  <?= ($ajio_social_media_data['audit_type']=="Trainer Audit")?"selected":"" ?>>Trainer Audit</option> 
                                                    <option value="QA Supervisor Audit"  <?= ($ajio_social_media_data['audit_type']=="QA Supervisor Audit")?"selected":"" ?>>QA Supervisor Audit</option> 
                                                </select>
										</td>
										<td class="auType_epi">Auditor Type<span style="font-size:24px;color:red">*</span></td>
											<td class="auType_epi">
												<select class="form-control form_ajio" id="auditor_type" name="data[auditor_type]">
                                                    <option value="">Select</option>
                                                    <option value="Master" <?= ($ajio_social_media_data['auditor_type']=="Master")?"selected":"" ?>>Master</option>
                                                    <option value="Regular" <?= ($ajio_social_media_data['auditor_type']=="Regular")?"selected":"" ?>>Regular</option>
                                                </select>
											</td>
									</tr>

									<tr>
										<td>Tagging by<br> Evaluator:<span style="font-size:24px;color:red">*</span></td>
										<td colspan="4">
											
											<select class="form-control form_ajio" name="data[tagging_evaluator]" required>
											<option value="">-Select-</option>
											<option value='Delivery-Fake Attempt-N/A' <?= ($ajio_social_media_data['tagging_evaluator']=='Delivery-Fake Attempt-N/A')?'selected':'' ?> >Delivery-Fake Attempt-N/A</option>
											<option value='Account-Store Credit Debited Order Not Processed-N/A' <?= ($ajio_social_media_data['tagging_evaluator']=='Account-Store Credit Debited Order Not Processed-N/A')?'selected':'' ?> >Account-Store Credit Debited Order Not Processed-N/A</option>
											<option value='Account-Store Credit Discrepancy-Others' <?= ($ajio_social_media_data['tagging_evaluator']=='Account-Store Credit Discrepancy-Others')?'selected':'' ?> >Account-Store Credit Discrepancy-Others</option>
											<option value='Account-Customer information Leak-N/A' <?= ($ajio_social_media_data['tagging_evaluator']=='Account-Customer information Leak-N/A')?'selected':'' ?> >Account-Customer information Leak-N/A</option>
											<option value='Callback-Others-N/A' <?= ($ajio_social_media_data['tagging_evaluator']=='Callback-Others-N/A')?'selected':'' ?> >Callback-Others-N/A</option>
											<option value='Delivery-Snatch Case-N/A' <?= ($ajio_social_media_data['tagging_evaluator']=='Delivery-Snatch Case-N/A')?'selected':'' ?> >Delivery-Snatch Case-N/A</option>
											<option value='Delivery-Order not dispatched from Warehouse-N/A' <?= ($ajio_social_media_data['tagging_evaluator']=='Delivery-Order not dispatched from Warehouse-N/A')?'selected':'' ?> >Delivery-Order not dispatched from Warehouse-N/A</option>
											<option value='Delivery-Delayed Delivery-N/A' <?= ($ajio_social_media_data['tagging_evaluator']=='Delivery-Delayed Delivery-N/A')?'selected':'' ?> >Delivery-Delayed Delivery-N/A</option>
											<option value='Account-Stop sms/email (promotional)-N/A' <?= ($ajio_social_media_data['tagging_evaluator']=='Account-Stop sms/email (promotional)-N/A')?'selected':'' ?> >Account-Stop sms/email (promotional)-N/A</option>
											<option value='Delivery-Complaint against Delivery Person-Courier person asking Extra Money' <?= ($ajio_social_media_data['tagging_evaluator']=='Delivery-Complaint against Delivery Person-Courier person asking Extra Money')?'selected':'' ?> >Delivery-Complaint against Delivery Person-Courier person asking Extra Money</option>
											<option value='Callback-Supervisor Callback-N/A' <?= ($ajio_social_media_data['tagging_evaluator']=='Callback-Supervisor Callback-N/A')?'selected':'' ?> >Callback-Supervisor Callback-N/A</option>
											<option value='Account-Account Deactivation-N/A' <?= ($ajio_social_media_data['tagging_evaluator']=='Account-Account Deactivation-N/A')?'selected':'' ?> >Account-Account Deactivation-N/A</option>
											<option value='Delivery-RTO Refund Delayed-N/A' <?= ($ajio_social_media_data['tagging_evaluator']=='Delivery-RTO Refund Delayed-N/A')?'selected':'' ?> >Delivery-RTO Refund Delayed-N/A</option>
											<option value='Online Refund-Amount Debited Order not processed-N/A' <?= ($ajio_social_media_data['tagging_evaluator']=='Online Refund-Amount Debited Order not processed-N/A')?'selected':'' ?> >Online Refund-Amount Debited Order not processed-N/A</option>
											<option value='Delivery-Special Instructions for Contact Details Update-N/A' <?= ($ajio_social_media_data['tagging_evaluator']=='Delivery-Special Instructions for Contact Details Update-N/A')?'selected':'' ?> >Delivery-Special Instructions for Contact Details Update-N/A</option>
											<option value='Online Refund-Refund not done against Reference No.-N/A' <?= ($ajio_social_media_data['tagging_evaluator']=='Online Refund-Refund not done against Reference No.-N/A')?'selected':'' ?> >Online Refund-Refund not done against Reference No.-N/A</option>
											<option value='Delivery-Complaint against Delivery Person-Courier person took Extra Money' <?= ($ajio_social_media_data['tagging_evaluator']=='Delivery-Complaint against Delivery Person-Courier person took Extra Money')?'selected':'' ?> >Delivery-Complaint against Delivery Person-Courier person took Extra Money</option>
											<option value='Marketing-Promotion Related-N/A' <?= ($ajio_social_media_data['tagging_evaluator']=='Marketing-Promotion Related-N/A')?'selected':'' ?> >Marketing-Promotion Related-N/A</option>
											<option value='Return-Picked up - Did not reach Warehouse-N/A' <?= ($ajio_social_media_data['tagging_evaluator']=='Return-Picked up - Did not reach Warehouse-N/A')?'selected':'' ?> >Return-Picked up - Did not reach Warehouse-N/A</option>
											<option value='Return-Self Ship Courier Charges not credited-N/A' <?= ($ajio_social_media_data['tagging_evaluator']=='Return-Self Ship Courier Charges not credited-N/A')?'selected':'' ?> >Return-Self Ship Courier Charges not credited-N/A</option>
											<option value='Goodwill Request-CM insisting Compensation-N/A' <?= ($ajio_social_media_data['tagging_evaluator']=='Goodwill Request-CM insisting Compensation-N/A')?'selected':'' ?> >Goodwill Request-CM insisting Compensation-N/A</option>
											<option value='Return-Reached Warehouse - Refund not Initiated-N/A' <?= ($ajio_social_media_data['tagging_evaluator']=='Return-Reached Warehouse - Refund not Initiated-N/A')?'selected':'' ?> >Return-Reached Warehouse - Refund not Initiated-N/A</option>
											<option value='Online Refund-Refund Reference No. Needed-CC/DC/NB' <?= ($ajio_social_media_data['tagging_evaluator']=='Online Refund-Refund Reference No. Needed-CC/DC/NB')?'selected':'' ?> >Online Refund-Refund Reference No. Needed-CC/DC/NB</option>
											<option value='Delivery-Complaint against Delivery Person-Rude Behaviour' <?= ($ajio_social_media_data['tagging_evaluator']=='Delivery-Complaint against Delivery Person-Rude Behaviour')?'selected':'' ?> >Delivery-Complaint against Delivery Person-Rude Behaviour</option>
											<option value='Return-Additional Self Ship Courier Charges Required-N/A' <?= ($ajio_social_media_data['tagging_evaluator']=='Return-Additional Self Ship Courier Charges Required-N/A')?'selected':'' ?> >Return-Additional Self Ship Courier Charges Required-N/A</option>
											<option value='Return-Pickup delayed-N/A' <?= ($ajio_social_media_data['tagging_evaluator']=='Return-Pickup delayed-N/A')?'selected':'' ?> >Return-Pickup delayed-N/A</option>
											<option value='Online Refund-Refund Reference No. Needed-IMPS Transfer' <?= ($ajio_social_media_data['tagging_evaluator']=='Online Refund-Refund Reference No. Needed-IMPS Transfer')?'selected':'' ?> >Online Refund-Refund Reference No. Needed-IMPS Transfer</option>
											<option value='Return-Customer claiming product picked up-Customer did not have acknowledgement copy' <?= ($ajio_social_media_data['tagging_evaluator']=='Return-Customer claiming product picked up-Customer did not have acknowledgement copy')?'selected':'' ?> >Return-Customer claiming product picked up-Customer did not have acknowledgement copy</option>
											<option value='NEFT(Refund Request)-NEFT Transfer-N/A' <?= ($ajio_social_media_data['tagging_evaluator']=='NEFT(Refund Request)-NEFT Transfer-N/A')?'selected':'' ?> >NEFT(Refund Request)-NEFT Transfer-N/A</option>
											<option value='Return-Customer claiming product picked up-Shared acknowledgement copy' <?= ($ajio_social_media_data['tagging_evaluator']=='Return-Customer claiming product picked up-Shared acknowledgement copy')?'selected':'' ?> >Return-Customer claiming product picked up-Shared acknowledgement copy</option>
											<option value='Marketing-Gift not Received post winning contest-N/A' <?= ($ajio_social_media_data['tagging_evaluator']=='Marketing-Gift not Received post winning contest-N/A')?'selected':'' ?> >Marketing-Gift not Received post winning contest-N/A</option>
											<option value='Return-Non Returnable Product-Wrong Product delivered' <?= ($ajio_social_media_data['tagging_evaluator']=='Return-Non Returnable Product-Wrong Product delivered')?'selected':'' ?> >Return-Non Returnable Product-Wrong Product delivered</option>
											<option value='Return-Self Shipped no Update From WH-N/A' <?= ($ajio_social_media_data['tagging_evaluator']=='Return-Self Shipped no Update From WH-N/A')?'selected':'' ?> >Return-Self Shipped no Update From WH-N/A</option>
											<option value='Return-Damaged Product-Damaged post usage' <?= ($ajio_social_media_data['tagging_evaluator']=='Return-Damaged Product-Damaged post usage')?'selected':'' ?> >Return-Damaged Product-Damaged post usage</option>
											<option value='Return-Regular Courier Charges not credited-N/A' <?= ($ajio_social_media_data['tagging_evaluator']=='Return-Regular Courier Charges not credited-N/A')?'selected':'' ?> >Return-Regular Courier Charges not credited-N/A</option>
											<option value='Return-Complaint against Delivery Person-Rude Behaviour' <?= ($ajio_social_media_data['tagging_evaluator']=='Return-Complaint against Delivery Person-Rude Behaviour')?'selected':'' ?> >Return-Complaint against Delivery Person-Rude Behaviour</option>
											<option value='Return-Special Instructions for Contact Details Update-N/A' <?= ($ajio_social_media_data['tagging_evaluator']=='Return-Special Instructions for Contact Details Update-N/A')?'selected':'' ?> >Return-Special Instructions for Contact Details Update-N/A</option>
											<option value='Return-Complaint against Delivery Person-Excess product handed over' <?= ($ajio_social_media_data['tagging_evaluator']=='Return-Complaint against Delivery Person-Excess product handed over')?'selected':'' ?> >Return-Complaint against Delivery Person-Excess product handed over</option>
											<option value='Return-Complaint against Delivery Person-Didn’t have pickup receipt' <?= ($ajio_social_media_data['tagging_evaluator']=='Return-Complaint against Delivery Person-Didn’t have pickup receipt')?'selected':'' ?> >Return-Complaint against Delivery Person-Didn’t have pickup receipt</option>
											<option value='Return-Complaint against Delivery Person-Didn’t know which product to pickup' <?= ($ajio_social_media_data['tagging_evaluator']=='Return-Complaint against Delivery Person-Didn’t know which product to pickup')?'selected':'' ?> >Return-Complaint against Delivery Person-Didn’t know which product to pickup</option>
											<option value='Return-Complaint against Delivery Person-Courier person refused to pick a product' <?= ($ajio_social_media_data['tagging_evaluator']=='Return-Complaint against Delivery Person-Courier person refused to pick a product')?'selected':'' ?> >Return-Complaint against Delivery Person-Courier person refused to pick a product</option>
											<option value='Return-Non Ajio Product Returned-Product Picked Up' <?= ($ajio_social_media_data['tagging_evaluator']=='Return-Non Ajio Product Returned-Product Picked Up')?'selected':'' ?> >Return-Non Ajio Product Returned-Product Picked Up</option>
											<option value='Return-Pickup - Wrong Status Update-Product not picked up - Exchange Related' <?= ($ajio_social_media_data['tagging_evaluator']=='Return-Pickup - Wrong Status Update-Product not picked up - Exchange Related')?'selected':'' ?> >Return-Pickup - Wrong Status Update-Product not picked up - Exchange Related</option>
											<option value='Return-Fake Attempt-N/A' <?= ($ajio_social_media_data['tagging_evaluator']=='Return-Fake Attempt-N/A')?'selected':'' ?> >Return-Fake Attempt-N/A</option>
											<option value='Website-Complaint relating to Website-No confirmation received on website/email/sms' <?= ($ajio_social_media_data['tagging_evaluator']=='Website-Complaint relating to Website-No confirmation received on website/email/sms')?'selected':'' ?> >Website-Complaint relating to Website-No confirmation received on website/email/sms</option>
											<option value='Website-Complaint relating to Website-Unable to view/edit Profile Details' <?= ($ajio_social_media_data['tagging_evaluator']=='Website-Complaint relating to Website-Unable to view/edit Profile Details')?'selected':'' ?> >Website-Complaint relating to Website-Unable to view/edit Profile Details</option>
											<option value='Website-Complaint relating to Website-Issue with product page info' <?= ($ajio_social_media_data['tagging_evaluator']=='Website-Complaint relating to Website-Issue with product page info')?'selected':'' ?> >Website-Complaint relating to Website-Issue with product page info</option>
											<option value='Website-Complaint relating to Website-Unable to cancel' <?= ($ajio_social_media_data['tagging_evaluator']=='Website-Complaint relating to Website-Unable to cancel')?'selected':'' ?> >Website-Complaint relating to Website-Unable to cancel</option>
											<option value='Website-Complaint relating to Website-MRP Mismatch' <?= ($ajio_social_media_data['tagging_evaluator']=='Website-Complaint relating to Website-MRP Mismatch')?'selected':'' ?> >Website-Complaint relating to Website-MRP Mismatch</option>
											<option value='Website-Complaint relating to Website-Unable to place order' <?= ($ajio_social_media_data['tagging_evaluator']=='Website-Complaint relating to Website-Unable to place order')?'selected':'' ?> >Website-Complaint relating to Website-Unable to place order</option>
											<option value='Website-Complaint relating to Website-Unable to exchange' <?= ($ajio_social_media_data['tagging_evaluator']=='Website-Complaint relating to Website-Unable to exchange')?'selected':'' ?> >Website-Complaint relating to Website-Unable to exchange</option>
											<option value='Website-Complaint relating to Website-Unable to return' <?= ($ajio_social_media_data['tagging_evaluator']=='Website-Complaint relating to Website-Unable to return')?'selected':'' ?> >Website-Complaint relating to Website-Unable to return</option>
											<option value='Website-Complaint relating to Website-Product details required' <?= ($ajio_social_media_data['tagging_evaluator']=='Website-Complaint relating to Website-Product details required')?'selected':'' ?> >Website-Complaint relating to Website-Product details required</option>
											<option value='VOC-Complaint against CC Employee-N/A' <?= ($ajio_social_media_data['tagging_evaluator']=='VOC-Complaint against CC Employee-N/A')?'selected':'' ?> >VOC-Complaint against CC Employee-N/A</option>
											<option value='Website-Complaint relating to Website-Unable to login/signup' <?= ($ajio_social_media_data['tagging_evaluator']=='Website-Complaint relating to Website-Unable to login/signup')?'selected':'' ?> >Website-Complaint relating to Website-Unable to login/signup</option>
											<option value='Return-Non Ajio Product Returned-Product Reached WH' <?= ($ajio_social_media_data['tagging_evaluator']=='Return-Non Ajio Product Returned-Product Reached WH')?'selected':'' ?> >Return-Non Ajio Product Returned-Product Reached WH</option>
											<option value='VOC-Harassment & Integrity Issues-N/A' <?= ($ajio_social_media_data['tagging_evaluator']=='VOC-Harassment & Integrity Issues-N/A')?'selected':'' ?> >VOC-Harassment & Integrity Issues-N/A</option>
											<option value='Return-Pickup - Wrong Status Update-Product not picked up - Return Related' <?= ($ajio_social_media_data['tagging_evaluator']=='Return-Pickup - Wrong Status Update-Product not picked up - Return Related')?'selected':'' ?> >Return-Pickup - Wrong Status Update-Product not picked up - Return Related</option>
											<option value='Website-Complaint relating to Website-Slow Functioning/Unable to open feature-webpage-website' <?= ($ajio_social_media_data['tagging_evaluator']=='Website-Complaint relating to Website-Slow Functioning/Unable to open feature-webpage-website')?'selected':'' ?> >Website-Complaint relating to Website-Slow Functioning/Unable to open feature-webpage-website</option>
											<option value='WH - Order Related Issues-Customer Return-Product Interchange of Customer' <?= ($ajio_social_media_data['tagging_evaluator']=='WH - Order Related Issues-Customer Return-Product Interchange of Customer')?'selected':'' ?> >WH - Order Related Issues-Customer Return-Product Interchange of Customer</option>
											<option value='WH - Order Related Issues-RTO-Order Received Without Return ID' <?= ($ajio_social_media_data['tagging_evaluator']=='WH - Order Related Issues-RTO-Order Received Without Return ID')?'selected':'' ?> >WH - Order Related Issues-RTO-Order Received Without Return ID</option>
											<option value='WH - Order Related Issues-RTO-Others' <?= ($ajio_social_media_data['tagging_evaluator']=='WH - Order Related Issues-RTO-Others')?'selected':'' ?> >WH - Order Related Issues-RTO-Others</option>
											<option value='WH - Order Related Issues-Customer Return-No Clue Shipment' <?= ($ajio_social_media_data['tagging_evaluator']=='WH - Order Related Issues-Customer Return-No Clue Shipment')?'selected':'' ?> >WH - Order Related Issues-Customer Return-No Clue Shipment</option>
											<option value='WH - Order Related Issues-Customer Return-Invoice Interchange' <?= ($ajio_social_media_data['tagging_evaluator']=='WH - Order Related Issues-Customer Return-Invoice Interchange')?'selected':'' ?> >WH - Order Related Issues-Customer Return-Invoice Interchange</option>
											<option value='WH - Order Related Issues-RTO-Damaged Product Received' <?= ($ajio_social_media_data['tagging_evaluator']=='WH - Order Related Issues-RTO-Damaged Product Received')?'selected':'' ?> >WH - Order Related Issues-RTO-Damaged Product Received</option>
											<option value='WH - Order Related Issues-Customer Return-Missing Free Gift' <?= ($ajio_social_media_data['tagging_evaluator']=='WH - Order Related Issues-Customer Return-Missing Free Gift')?'selected':'' ?> >WH - Order Related Issues-Customer Return-Missing Free Gift</option>
											<option value='WH - Order Related Issues-Customer Return-Non-Ajio Product Return' <?= ($ajio_social_media_data['tagging_evaluator']=='WH - Order Related Issues-Customer Return-Non-Ajio Product Return')?'selected':'' ?> >WH - Order Related Issues-Customer Return-Non-Ajio Product Return</option>
											<option value='WH - Order Related Issues-RTO-Empty Box Received' <?= ($ajio_social_media_data['tagging_evaluator']=='WH - Order Related Issues-RTO-Empty Box Received')?'selected':'' ?> >WH - Order Related Issues-RTO-Empty Box Received</option>
											<option value='WH - Order Related Issues-Customer Return-Order Received Without Return ID' <?= ($ajio_social_media_data['tagging_evaluator']=='WH - Order Related Issues-Customer Return-Order Received Without Return ID')?'selected':'' ?> >WH - Order Related Issues-Customer Return-Order Received Without Return ID</option>
											<option value='WH - Order Related Issues-Return to be cancelled-AWB not cancelled (Pickup not required)' <?= ($ajio_social_media_data['tagging_evaluator']=='WH - Order Related Issues-Return to be cancelled-AWB not cancelled (Pickup not required)')?'selected':'' ?> >WH - Order Related Issues-Return to be cancelled-AWB not cancelled (Pickup not required)</option>
											<option value='WH - Order Related Issues-RTO-Missing Free Gift' <?= ($ajio_social_media_data['tagging_evaluator']=='WH - Order Related Issues-RTO-Missing Free Gift')?'selected':'' ?> >WH - Order Related Issues-RTO-Missing Free Gift</option>
											<option value='WH - Order Related Issues-Forward-MRP Mismatch' <?= ($ajio_social_media_data['tagging_evaluator']=='WH - Order Related Issues-Forward-MRP Mismatch')?'selected':'' ?> >WH - Order Related Issues-Forward-MRP Mismatch</option>
											<option value='WH - Order Related Issues-Customer Return-Excess Product Received' <?= ($ajio_social_media_data['tagging_evaluator']=='WH - Order Related Issues-Customer Return-Excess Product Received')?'selected':'' ?> >WH - Order Related Issues-Customer Return-Excess Product Received</option>
											<option value='WH - Order Related Issues-Customer Return-To Be Refunded – Empty Box Received' <?= ($ajio_social_media_data['tagging_evaluator']=='WH - Order Related Issues-Customer Return-To Be Refunded – Empty Box Received')?'selected':'' ?> >WH - Order Related Issues-Customer Return-To Be Refunded – Empty Box Received</option>
											<option value='WH - Order Related Issues-RTO-No Clue Shipment' <?= ($ajio_social_media_data['tagging_evaluator']=='WH - Order Related Issues-RTO-No Clue Shipment')?'selected':'' ?> >WH - Order Related Issues-RTO-No Clue Shipment</option>
											<option value='WH - Order Related Issues-RTO-Excess Product Received' <?= ($ajio_social_media_data['tagging_evaluator']=='WH - Order Related Issues-RTO-Excess Product Received')?'selected':'' ?> >WH - Order Related Issues-RTO-Excess Product Received</option>
											<option value='WH - Order Related Issues-Forward-Design Mismatch' <?= ($ajio_social_media_data['tagging_evaluator']=='WH - Order Related Issues-Forward-Design Mismatch')?'selected':'' ?> >WH - Order Related Issues-Forward-Design Mismatch</option>
											<option value='WH - Order Related Issues-RTO-Packaging / Box not Received or Damaged' <?= ($ajio_social_media_data['tagging_evaluator']=='WH - Order Related Issues-RTO-Packaging / Box not Received or Damaged')?'selected':'' ?> >WH - Order Related Issues-RTO-Packaging / Box not Received or Damaged</option>
											<option value='WH - Order Related Issues-Return to be cancelled-AWB cancelled (Pickup not required)' <?= ($ajio_social_media_data['tagging_evaluator']=='WH - Order Related Issues-Return to be cancelled-AWB cancelled (Pickup not required)')?'selected':'' ?> >WH - Order Related Issues-Return to be cancelled-AWB cancelled (Pickup not required)</option>
											<option value='WH - Order Related Issues-Return to be cancelled-AWB cancelled (Pickup required)' <?= ($ajio_social_media_data['tagging_evaluator']=='WH - Order Related Issues-Return to be cancelled-AWB cancelled (Pickup required)')?'selected':'' ?> >WH - Order Related Issues-Return to be cancelled-AWB cancelled (Pickup required)</option>
											<option value='WH - Order Related Issues-Forward-Tech Issues' <?= ($ajio_social_media_data['tagging_evaluator']=='WH - Order Related Issues-Forward-Tech Issues')?'selected':'' ?> >WH - Order Related Issues-Forward-Tech Issues</option>
											<option value='WH - Order Related Issues-Return to be cancelled-AWB not cancelled (Pickup required)' <?= ($ajio_social_media_data['tagging_evaluator']=='WH - Order Related Issues-Return to be cancelled-AWB not cancelled (Pickup required)')?'selected':'' ?> >WH - Order Related Issues-Return to be cancelled-AWB not cancelled (Pickup required)</option>
											<option value='WH - Order Related Issues-Customer Return-Empty Box Received' <?= ($ajio_social_media_data['tagging_evaluator']=='WH - Order Related Issues-Customer Return-Empty Box Received')?'selected':'' ?> >WH - Order Related Issues-Customer Return-Empty Box Received</option>
											<option value='WH - Order Related Issues-Customer Return-Non Delhivery pickup-Missing product in return packet' <?= ($ajio_social_media_data['tagging_evaluator']=='WH - Order Related Issues-Customer Return-Non Delhivery pickup-Missing product in return packet')?'selected':'' ?> >WH - Order Related Issues-Customer Return-Non Delhivery pickup-Missing product in return packet</option>
											<option value='WH - Order Related Issues-Customer Return-Others' <?= ($ajio_social_media_data['tagging_evaluator']=='WH - Order Related Issues-Customer Return-Others')?'selected':'' ?> >WH - Order Related Issues-Customer Return-Others</option>
											<option value='WH - Order Related Issues-Customer Return-Missing Product in Return Packet' <?= ($ajio_social_media_data['tagging_evaluator']=='WH - Order Related Issues-Customer Return-Missing Product in Return Packet')?'selected':'' ?> >WH - Order Related Issues-Customer Return-Missing Product in Return Packet</option>
											<option value='WH - Order Related Issues-RTO-Missing Product in Return Packet' <?= ($ajio_social_media_data['tagging_evaluator']=='WH - Order Related Issues-RTO-Missing Product in Return Packet')?'selected':'' ?> >WH - Order Related Issues-RTO-Missing Product in Return Packet</option>
											<option value='WH - Order Related Issues-RTO-Invoice Interchange' <?= ($ajio_social_media_data['tagging_evaluator']=='WH - Order Related Issues-RTO-Invoice Interchange')?'selected':'' ?> >WH - Order Related Issues-RTO-Invoice Interchange</option>
											<option value='WH - Order Related Issues-Customer Return-Tags Missing' <?= ($ajio_social_media_data['tagging_evaluator']=='WH - Order Related Issues-Customer Return-Tags Missing')?'selected':'' ?> >WH - Order Related Issues-Customer Return-Tags Missing</option>
											<option value='WH - Order Related Issues-RTO-Non-Ajio Product Return' <?= ($ajio_social_media_data['tagging_evaluator']=='WH - Order Related Issues-RTO-Non-Ajio Product Return')?'selected':'' ?> >WH - Order Related Issues-RTO-Non-Ajio Product Return</option>
											<option value='Mobile App-Others-Others' <?= ($ajio_social_media_data['tagging_evaluator']=='Mobile App-Others-Others')?'selected':'' ?> >Mobile App-Others-Others</option>
											<option value='Delivery-I want quicker Delivery-Informed about expediting policy' <?= ($ajio_social_media_data['tagging_evaluator']=='Delivery-I want quicker Delivery-Informed about expediting policy')?'selected':'' ?> >Delivery-I want quicker Delivery-Informed about expediting policy</option>
											<option value='Account-I need help with my account-Informed customer about account information' <?= ($ajio_social_media_data['tagging_evaluator']=='Account-I need help with my account-Informed customer about account information')?'selected':'' ?> >Account-I need help with my account-Informed customer about account information</option>
											<option value='Account-I need help with my account-Guided customer on My Accounts' <?= ($ajio_social_media_data['tagging_evaluator']=='Account-I need help with my account-Guided customer on My Accounts')?'selected':'' ?> >Account-I need help with my account-Guided customer on My Accounts</option>
											<option value='Account-How do I use JioMoney?-Guided customer on JioMoney validity' <?= ($ajio_social_media_data['tagging_evaluator']=='Account-How do I use JioMoney?-Guided customer on JioMoney validity')?'selected':'' ?> >Account-How do I use JioMoney?-Guided customer on JioMoney validity</option>
											<option value='Account-How do I use JioMoney?-Guided customer on loading JioMoney' <?= ($ajio_social_media_data['tagging_evaluator']=='Account-How do I use JioMoney?-Guided customer on loading JioMoney')?'selected':'' ?> >Account-How do I use JioMoney?-Guided customer on loading JioMoney</option>
											<option value='Account-I did not place this order-Retained the order' <?= ($ajio_social_media_data['tagging_evaluator']=='Account-I did not place this order-Retained the order')?'selected':'' ?> >Account-I did not place this order-Retained the order</option>
											<option value='Business-Others-Advised about the procedure' <?= ($ajio_social_media_data['tagging_evaluator']=='Business-Others-Advised about the procedure')?'selected':'' ?> >Business-Others-Advised about the procedure</option>
											<option value='Account-Why is my account suspended ?-Guided customer on Reason for Suspension' <?= ($ajio_social_media_data['tagging_evaluator']=='Account-Why is my account suspended ?-Guided customer on Reason for Suspension')?'selected':'' ?> >Account-Why is my account suspended ?-Guided customer on Reason for Suspension</option>
											<option value='NAR Calls/Emails-Incomplete Call/Email-Call dropped after knowing the query' <?= ($ajio_social_media_data['tagging_evaluator']=='NAR Calls/Emails-Incomplete Call/Email-Call dropped after knowing the query')?'selected':'' ?> >NAR Calls/Emails-Incomplete Call/Email-Call dropped after knowing the query</option>
											<option value='Mobile App-Help me shop on the App-Helped the customer' <?= ($ajio_social_media_data['tagging_evaluator']=='Mobile App-Help me shop on the App-Helped the customer')?'selected':'' ?> >Mobile App-Help me shop on the App-Helped the customer</option>
											<option value='Account-How do I use my store credits?-Informed about Store Credit policy' <?= ($ajio_social_media_data['tagging_evaluator']=='Account-How do I use my store credits?-Informed about Store Credit policy')?'selected':'' ?> >Account-How do I use my store credits?-Informed about Store Credit policy</option>
											<option value='Coupon-How do I use my Coupon?-Educated customer on Coupon features' <?= ($ajio_social_media_data['tagging_evaluator']=='Coupon-How do I use my Coupon?-Educated customer on Coupon features')?'selected':'' ?> >Coupon-How do I use my Coupon?-Educated customer on Coupon features</option>
											<option value='Cancel-I want to cancel-Cancelled order' <?= ($ajio_social_media_data['tagging_evaluator']=='Cancel-I want to cancel-Cancelled order')?'selected':'' ?> >Cancel-I want to cancel-Cancelled order</option>
											<option value='NAR Calls/Emails-Incomplete Call/Email-Call suddenly went blank during conversation' <?= ($ajio_social_media_data['tagging_evaluator']=='NAR Calls/Emails-Incomplete Call/Email-Call suddenly went blank during conversation')?'selected':'' ?> >NAR Calls/Emails-Incomplete Call/Email-Call suddenly went blank during conversation</option>
											<option value='Account-I did not place this order-Cancelled the order' <?= ($ajio_social_media_data['tagging_evaluator']=='Account-I did not place this order-Cancelled the order')?'selected':'' ?> >Account-I did not place this order-Cancelled the order</option>
											<option value='NAR Calls/Emails-Blank Call-Blank Call' <?= ($ajio_social_media_data['tagging_evaluator']=='NAR Calls/Emails-Blank Call-Blank Call')?'selected':'' ?> >NAR Calls/Emails-Blank Call-Blank Call</option>
											<option value='Cancel-Explain the Cancellation Policy-Explained the cancellation policy' <?= ($ajio_social_media_data['tagging_evaluator']=='Cancel-Explain the Cancellation Policy-Explained the cancellation policy')?'selected':'' ?> >Cancel-Explain the Cancellation Policy-Explained the cancellation policy</option>
											<option value='Mobile App-How do I cancel the order on the App-Explained the feature' <?= ($ajio_social_media_data['tagging_evaluator']=='Mobile App-How do I cancel the order on the App-Explained the feature')?'selected':'' ?> >Mobile App-How do I cancel the order on the App-Explained the feature</option>
											<option value='Account-How do I use JioMoney?-Guided customer to JioMoney Customer Care' <?= ($ajio_social_media_data['tagging_evaluator']=='Account-How do I use JioMoney?-Guided customer to JioMoney Customer Care')?'selected':'' ?> >Account-How do I use JioMoney?-Guided customer to JioMoney Customer Care</option>
											<option value='Account-I want to Stop SMS/Email Promotions-Informed customer of the procedure' <?= ($ajio_social_media_data['tagging_evaluator']=='Account-I want to Stop SMS/Email Promotions-Informed customer of the procedure')?'selected':'' ?> >Account-I want to Stop SMS/Email Promotions-Informed customer of the procedure</option>
											<option value='Cancel-I want to cancel-Educated customer on cancellation policy' <?= ($ajio_social_media_data['tagging_evaluator']=='Cancel-I want to cancel-Educated customer on cancellation policy')?'selected':'' ?> >Cancel-I want to cancel-Educated customer on cancellation policy</option>
											<option value='Mobile App-I have a problem using your app-Explained the App feature/Functions' <?= ($ajio_social_media_data['tagging_evaluator']=='Mobile App-I have a problem using your app-Explained the App feature/Functions')?'selected':'' ?> >Mobile App-I have a problem using your app-Explained the App feature/Functions</option>
											<option value='NAR Calls/Emails-Incomplete Call/Email-Call dropped before knowing the query' <?= ($ajio_social_media_data['tagging_evaluator']=='NAR Calls/Emails-Incomplete Call/Email-Call dropped before knowing the query')?'selected':'' ?> >NAR Calls/Emails-Incomplete Call/Email-Call dropped before knowing the query</option>
											<option value='Coupon-I did not receive a coupon after returning/cancelling-Educated customer on Coupon policy' <?= ($ajio_social_media_data['tagging_evaluator']=='Coupon-I did not receive a coupon after returning/cancelling-Educated customer on Coupon policy')?'selected':'' ?> >Coupon-I did not receive a coupon after returning/cancelling-Educated customer on Coupon policy</option>
											<option value='Account-How many Store Credits do I have?-Provided the amount to the customer' <?= ($ajio_social_media_data['tagging_evaluator']=='Account-How many Store Credits do I have?-Provided the amount to the customer')?'selected':'' ?> >Account-How many Store Credits do I have?-Provided the amount to the customer</option>
											<option value='Mobile App-The App is slow/ loading & functionality issues-Troubleshooting done' <?= ($ajio_social_media_data['tagging_evaluator']=='Mobile App-The App is slow/ loading & functionality issues-Troubleshooting done')?'selected':'' ?> >Mobile App-The App is slow/ loading & functionality issues-Troubleshooting done</option>
											<option value='Cancel-I want to cancel-Guided customer to cancel on Website/App' <?= ($ajio_social_media_data['tagging_evaluator']=='Cancel-I want to cancel-Guided customer to cancel on Website/App')?'selected':'' ?> >Cancel-I want to cancel-Guided customer to cancel on Website/App</option>
											<option value='Mobile App-I am unable to login/sign up on the App-Helped the customer login/signup' <?= ($ajio_social_media_data['tagging_evaluator']=='Mobile App-I am unable to login/sign up on the App-Helped the customer login/signup')?'selected':'' ?> >Mobile App-I am unable to login/sign up on the App-Helped the customer login/signup</option>
											<option value='Account-I need help with my account-Guided customer on password query' <?= ($ajio_social_media_data['tagging_evaluator']=='Account-I need help with my account-Guided customer on password query')?'selected':'' ?> >Account-I need help with my account-Guided customer on password query</option>
											<option value='Account-How do I use my store credits?-Explained how to use Store Credits' <?= ($ajio_social_media_data['tagging_evaluator']=='Account-How do I use my store credits?-Explained how to use Store Credits')?'selected':'' ?> >Account-How do I use my store credits?-Explained how to use Store Credits</option>
											<option value='Business-I want to do marketing/promotion for AJIO-Advised about the procedure' <?= ($ajio_social_media_data['tagging_evaluator']=='Business-I want to do marketing/promotion for AJIO-Advised about the procedure')?'selected':'' ?> >Business-I want to do marketing/promotion for AJIO-Advised about the procedure</option>
											<option value='NAR Calls/Emails-Abusive Caller-Abusive Caller' <?= ($ajio_social_media_data['tagging_evaluator']=='NAR Calls/Emails-Abusive Caller-Abusive Caller')?'selected':'' ?> >NAR Calls/Emails-Abusive Caller-Abusive Caller</option>
											<option value='NAR Calls/Emails-Incomplete Call/Email-Call suddenly got interrupted by static noise during conversation' <?= ($ajio_social_media_data['tagging_evaluator']=='NAR Calls/Emails-Incomplete Call/Email-Call suddenly got interrupted by static noise during conversation')?'selected':'' ?> >NAR Calls/Emails-Incomplete Call/Email-Call suddenly got interrupted by static noise during conversation</option>
											<option value='Cancel-Cancel my Return/Exchange-Informed Unable to cancel' <?= ($ajio_social_media_data['tagging_evaluator']=='Cancel-Cancel my Return/Exchange-Informed Unable to cancel')?'selected':'' ?> >Cancel-Cancel my Return/Exchange-Informed Unable to cancel</option>
											<option value='Cancel-Why was my pickup/exchange cancelled?-Explained the reason' <?= ($ajio_social_media_data['tagging_evaluator']=='Cancel-Why was my pickup/exchange cancelled?-Explained the reason')?'selected':'' ?> >Cancel-Why was my pickup/exchange cancelled?-Explained the reason</option>
											<option value='Mobile App-How do I create a return on the App-Explained the feature' <?= ($ajio_social_media_data['tagging_evaluator']=='Mobile App-How do I create a return on the App-Explained the feature')?'selected':'' ?> >Mobile App-How do I create a return on the App-Explained the feature</option>
											<option value='Business-Media Related-Enquiry/ Concern' <?= ($ajio_social_media_data['tagging_evaluator']=='Business-Media Related-Enquiry/ Concern')?'selected':'' ?> >Business-Media Related-Enquiry/ Concern</option>
											<option value='Cancel-Why was my order cancelled?-Explained the cancellation reason' <?= ($ajio_social_media_data['tagging_evaluator']=='Cancel-Why was my order cancelled?-Explained the cancellation reason')?'selected':'' ?> >Cancel-Why was my order cancelled?-Explained the cancellation reason</option>
											<option value='Business-I want to sell my merchandise on AJIO-Advised about the procedure' <?= ($ajio_social_media_data['tagging_evaluator']=='Business-I want to sell my merchandise on AJIO-Advised about the procedure')?'selected':'' ?> >Business-I want to sell my merchandise on AJIO-Advised about the procedure</option>
											<option value='Delivery-I want Delivery/Pickup at specific time-Informed about delivery policy' <?= ($ajio_social_media_data['tagging_evaluator']=='Delivery-I want Delivery/Pickup at specific time-Informed about delivery policy')?'selected':'' ?> >Delivery-I want Delivery/Pickup at specific time-Informed about delivery policy</option>
											<option value='Business-I want to apply for job at AJIO-Guided customer on process' <?= ($ajio_social_media_data['tagging_evaluator']=='Business-I want to apply for job at AJIO-Guided customer on process')?'selected':'' ?> >Business-I want to apply for job at AJIO-Guided customer on process</option>
											<option value='Cancel-Cancel my Return/Exchange-Cancelled the Return /Exchange request' <?= ($ajio_social_media_data['tagging_evaluator']=='Cancel-Cancel my Return/Exchange-Cancelled the Return /Exchange request')?'selected':'' ?> >Cancel-Cancel my Return/Exchange-Cancelled the Return /Exchange request</option>
											<option value='NAR Calls/Emails-NAR Calls-No Action Required' <?= ($ajio_social_media_data['tagging_evaluator']=='NAR Calls/Emails-NAR Calls-No Action Required')?'selected':'' ?> >NAR Calls/Emails-NAR Calls-No Action Required</option>
											<option value='NAR Calls/Emails-NAR Emails-No Action Required' <?= ($ajio_social_media_data['tagging_evaluator']=='NAR Calls/Emails-NAR Emails-No Action Required')?'selected':'' ?> >NAR Calls/Emails-NAR Emails-No Action Required</option>
											<option value='NAR Calls/Emails-NAR Emails-Spam' <?= ($ajio_social_media_data['tagging_evaluator']=='NAR Calls/Emails-NAR Emails-Spam')?'selected':'' ?> >NAR Calls/Emails-NAR Emails-Spam</option>
											<option value='NAR Calls/Emails-NAR Calls-Non Ajio Queries' <?= ($ajio_social_media_data['tagging_evaluator']=='NAR Calls/Emails-NAR Calls-Non Ajio Queries')?'selected':'' ?> >NAR Calls/Emails-NAR Calls-Non Ajio Queries</option>
											<option value='NAR Calls/Emails-Test-Test Email' <?= ($ajio_social_media_data['tagging_evaluator']=='NAR Calls/Emails-Test-Test Email')?'selected':'' ?> >NAR Calls/Emails-Test-Test Email</option>
											<option value='NAR Calls/Emails-NAR Emails-Duplicate email' <?= ($ajio_social_media_data['tagging_evaluator']=='NAR Calls/Emails-NAR Emails-Duplicate email')?'selected':'' ?> >NAR Calls/Emails-NAR Emails-Duplicate email</option>
											<option value='Cancel-I want to cancel-Informed customer to refuse the delivery' <?= ($ajio_social_media_data['tagging_evaluator']=='Cancel-I want to cancel-Informed customer to refuse the delivery')?'selected':'' ?> >Cancel-I want to cancel-Informed customer to refuse the delivery</option>
											<option value='NAR Calls/Emails-Prank Call-Prank Call' <?= ($ajio_social_media_data['tagging_evaluator']=='NAR Calls/Emails-Prank Call-Prank Call')?'selected':'' ?> >NAR Calls/Emails-Prank Call-Prank Call</option>
											<option value='Order-I want to place an order-Placed an order through CS Cockpit' <?= ($ajio_social_media_data['tagging_evaluator']=='Order-I want to place an order-Placed an order through CS Cockpit')?'selected':'' ?> >Order-I want to place an order-Placed an order through CS Cockpit</option>
											<option value='Order-I want to place an order-Informed customer of pin code serviceability' <?= ($ajio_social_media_data['tagging_evaluator']=='Order-I want to place an order-Informed customer of pin code serviceability')?'selected':'' ?> >Order-I want to place an order-Informed customer of pin code serviceability</option>
											<option value='Other-I want Compensation-Convinced the customer - No Action Required' <?= ($ajio_social_media_data['tagging_evaluator']=='Other-I want Compensation-Convinced the customer - No Action Required')?'selected':'' ?> >Other-I want Compensation-Convinced the customer - No Action Required</option>
											<option value='Order-Telesales-Order Placed' <?= ($ajio_social_media_data['tagging_evaluator']=='Order-Telesales-Order Placed')?'selected':'' ?> >Order-Telesales-Order Placed</option>
											<option value='Order-I had a problem while placing an order-Clarified that order was Not Processed' <?= ($ajio_social_media_data['tagging_evaluator']=='Order-I had a problem while placing an order-Clarified that order was Not Processed')?'selected':'' ?> >Order-I had a problem while placing an order-Clarified that order was Not Processed</option>
											<option value='Order-I had a problem while placing an order-Informed customer of pin code serviceability' <?= ($ajio_social_media_data['tagging_evaluator']=='Order-I had a problem while placing an order-Informed customer of pin code serviceability')?'selected':'' ?> >Order-I had a problem while placing an order-Informed customer of pin code serviceability</option>
											<option value='Pre Order - F&L-Explain the features of the product-Explained about product features' <?= ($ajio_social_media_data['tagging_evaluator']=='Pre Order - F&L-Explain the features of the product-Explained about product features')?'selected':'' ?> >Pre Order - F&L-Explain the features of the product-Explained about product features</option>
											<option value='Order-What are my delivery / payment options?-Informed customer of payment options' <?= ($ajio_social_media_data['tagging_evaluator']=='Order-What are my delivery / payment options?-Informed customer of payment options')?'selected':'' ?> >Order-What are my delivery / payment options?-Informed customer of payment options</option>
											<option value='Other-I want Compensation-Transferred call to supervisor' <?= ($ajio_social_media_data['tagging_evaluator']=='Other-I want Compensation-Transferred call to supervisor')?'selected':'' ?> >Other-I want Compensation-Transferred call to supervisor</option>
											<option value='Order-I want to modify my order (ph/addr etc)-Modified Ph. No. /Address on CS Cockpit' <?= ($ajio_social_media_data['tagging_evaluator']=='Order-I want to modify my order (ph/addr etc)-Modified Ph. No. /Address on CS Cockpit')?'selected':'' ?> >Order-I want to modify my order (ph/addr etc)-Modified Ph. No. /Address on CS Cockpit</option>
											<option value='Order-What are the payment modes?-Informed customer of payment options' <?= ($ajio_social_media_data['tagging_evaluator']=='Order-What are the payment modes?-Informed customer of payment options')?'selected':'' ?> >Order-What are the payment modes?-Informed customer of payment options</option>
											<option value='Other-I need to speak in regional language-Transferred call to other champ' <?= ($ajio_social_media_data['tagging_evaluator']=='Other-I need to speak in regional language-Transferred call to other champ')?'selected':'' ?> >Other-I need to speak in regional language-Transferred call to other champ</option>
											<option value='Other-I want to know more about an offer/promotion-Explained that there is no current promotion at AJIO' <?= ($ajio_social_media_data['tagging_evaluator']=='Other-I want to know more about an offer/promotion-Explained that there is no current promotion at AJIO')?'selected':'' ?> >Other-I want to know more about an offer/promotion-Explained that there is no current promotion at AJIO</option>
											<option value='Order-I want to modify my order (ph/addr etc)-Guided customer to modify details on website/app' <?= ($ajio_social_media_data['tagging_evaluator']=='Order-I want to modify my order (ph/addr etc)-Guided customer to modify details on website/app')?'selected':'' ?> >Order-I want to modify my order (ph/addr etc)-Guided customer to modify details on website/app</option>
											<option value='Other-I want to know more about an offer/promotion-Explained the promotion to customer' <?= ($ajio_social_media_data['tagging_evaluator']=='Other-I want to know more about an offer/promotion-Explained the promotion to customer')?'selected':'' ?> >Other-I want to know more about an offer/promotion-Explained the promotion to customer</option>
											<option value='Post Sales Service-Product not working as described after returns period-Guided customer to service Centre' <?= ($ajio_social_media_data['tagging_evaluator']=='Post Sales Service-Product not working as described after returns period-Guided customer to service Centre')?'selected':'' ?> >Post Sales Service-Product not working as described after returns period-Guided customer to service Centre</option>
											<option value='Other-I need to talk to a supervisor-Transferred call to supervisor' <?= ($ajio_social_media_data['tagging_evaluator']=='Other-I need to talk to a supervisor-Transferred call to supervisor')?'selected':'' ?> >Other-I need to talk to a supervisor-Transferred call to supervisor</option>
											<option value='Order-What are my delivery / payment options?-Informed customer of serviceability' <?= ($ajio_social_media_data['tagging_evaluator']=='Order-What are my delivery / payment options?-Informed customer of serviceability')?'selected':'' ?> >Order-What are my delivery / payment options?-Informed customer of serviceability</option>
											<option value='Order-I want my Invoice-Emailed Invoice to the customer' <?= ($ajio_social_media_data['tagging_evaluator']=='Order-I want my Invoice-Emailed Invoice to the customer')?'selected':'' ?> >Order-I want my Invoice-Emailed Invoice to the customer</option>
											<option value='Other-I need to speak in regional language-Informed about non-availability' <?= ($ajio_social_media_data['tagging_evaluator']=='Other-I need to speak in regional language-Informed about non-availability')?'selected':'' ?> >Other-I need to speak in regional language-Informed about non-availability</option>
											<option value='Order-I had a problem while placing an order-Placed an order through CS Cockpit' <?= ($ajio_social_media_data['tagging_evaluator']=='Order-I had a problem while placing an order-Placed an order through CS Cockpit')?'selected':'' ?> >Order-I had a problem while placing an order-Placed an order through CS Cockpit</option>
											<option value='Order-I had a problem while placing an order-Clarified that order was processed.' <?= ($ajio_social_media_data['tagging_evaluator']=='Order-I had a problem while placing an order-Clarified that order was processed.')?'selected':'' ?> >Order-I had a problem while placing an order-Clarified that order was processed.</option>
											<option value='Pre Order - F&L-Where can i find this product?-Helped customer to find the product' <?= ($ajio_social_media_data['tagging_evaluator']=='Pre Order - F&L-Where can i find this product?-Helped customer to find the product')?'selected':'' ?> >Pre Order - F&L-Where can i find this product?-Helped customer to find the product</option>
											<option value='Pre Order - F&L-Where can i find this product?-Informed customer that the product is not in stock' <?= ($ajio_social_media_data['tagging_evaluator']=='Pre Order - F&L-Where can i find this product?-Informed customer that the product is not in stock')?'selected':'' ?> >Pre Order - F&L-Where can i find this product?-Informed customer that the product is not in stock</option>
											<option value='Pre Order - Tech Related - Mobile / Iphone-Product not working as described after returns period-Guided customer to service Centre' <?= ($ajio_social_media_data['tagging_evaluator']=='Pre Order - Tech Related - Mobile / Iphone-Product not working as described after returns period-Guided customer to service Centre')?'selected':'' ?> >Pre Order - Tech Related - Mobile / Iphone-Product not working as described after returns period-Guided customer to service Centre</option>
											<option value='Order-I want to place an order-Guided customer on placing an order on website/app' <?= ($ajio_social_media_data['tagging_evaluator']=='Order-I want to place an order-Guided customer on placing an order on website/app')?'selected':'' ?> >Order-I want to place an order-Guided customer on placing an order on website/app</option>
											<option value='Order-I had a problem while placing an order-Helped the customer to place the order on website/app' <?= ($ajio_social_media_data['tagging_evaluator']=='Order-I had a problem while placing an order-Helped the customer to place the order on website/app')?'selected':'' ?> >Order-I had a problem while placing an order-Helped the customer to place the order on website/app</option>
											<option value='Pre Order - F&L-I need warranty information-Provided Information' <?= ($ajio_social_media_data['tagging_evaluator']=='Pre Order - F&L-I need warranty information-Provided Information')?'selected':'' ?> >Pre Order - F&L-I need warranty information-Provided Information</option>
											<option value='Pre Order - Tech Related - Mobile / Iphone-I need warranty information-Provided Information' <?= ($ajio_social_media_data['tagging_evaluator']=='Pre Order - Tech Related - Mobile / Iphone-I need warranty information-Provided Information')?'selected':'' ?> >Pre Order - Tech Related - Mobile / Iphone-I need warranty information-Provided Information</option>
											<option value='Pre Order - Tech Related - Jio Fi-Where can I buy Accessory-Provided Information' <?= ($ajio_social_media_data['tagging_evaluator']=='Pre Order - Tech Related - Jio Fi-Where can I buy Accessory-Provided Information')?'selected':'' ?> >Pre Order - Tech Related - Jio Fi-Where can I buy Accessory-Provided Information</option>
											<option value='Pre Order - Tech Related - Mobile / Iphone-Where can I buy Accessory-Provided Information' <?= ($ajio_social_media_data['tagging_evaluator']=='Pre Order - Tech Related - Mobile / Iphone-Where can I buy Accessory-Provided Information')?'selected':'' ?> >Pre Order - Tech Related - Mobile / Iphone-Where can I buy Accessory-Provided Information</option>
											<option value='Pre Order - Tech Related - Mobile / Iphone-Where can i find this product?-Informed customer that the product is not in stock' <?= ($ajio_social_media_data['tagging_evaluator']=='Pre Order - Tech Related - Mobile / Iphone-Where can i find this product?-Informed customer that the product is not in stock')?'selected':'' ?> >Pre Order - Tech Related - Mobile / Iphone-Where can i find this product?-Informed customer that the product is not in stock</option>
											<option value='Pre Order - Tech Related - Jio Fi-I need warranty information-Provided Information' <?= ($ajio_social_media_data['tagging_evaluator']=='Pre Order - Tech Related - Jio Fi-I need warranty information-Provided Information')?'selected':'' ?> >Pre Order - Tech Related - Jio Fi-I need warranty information-Provided Information</option>
											<option value='Pre Order - Tech Related - Others-Product not working as described after returns period-Guided customer to service Centre' <?= ($ajio_social_media_data['tagging_evaluator']=='Pre Order - Tech Related - Others-Product not working as described after returns period-Guided customer to service Centre')?'selected':'' ?> >Pre Order - Tech Related - Others-Product not working as described after returns period-Guided customer to service Centre</option>
											<option value='Pre Order - Tech Related - Others-Where can i find this product?-Helped customer to find the product' <?= ($ajio_social_media_data['tagging_evaluator']=='Pre Order - Tech Related - Others-Where can i find this product?-Helped customer to find the product')?'selected':'' ?> >Pre Order - Tech Related - Others-Where can i find this product?-Helped customer to find the product</option>
											<option value='Pre Order - Tech Related - Others-Where can I buy Accessory-Provided Information' <?= ($ajio_social_media_data['tagging_evaluator']=='Pre Order - Tech Related - Others-Where can I buy Accessory-Provided Information')?'selected':'' ?> >Pre Order - Tech Related - Others-Where can I buy Accessory-Provided Information</option>
											<option value='Price-Whats the price for this order?-Informed customer about cost split' <?= ($ajio_social_media_data['tagging_evaluator']=='Price-Whats the price for this order?-Informed customer about cost split')?'selected':'' ?> >Price-Whats the price for this order?-Informed customer about cost split</option>
											<option value='Price-How much does Gift Wrap cost?-Guided customer on gift wrap charges' <?= ($ajio_social_media_data['tagging_evaluator']=='Price-How much does Gift Wrap cost?-Guided customer on gift wrap charges')?'selected':'' ?> >Price-How much does Gift Wrap cost?-Guided customer on gift wrap charges</option>
											<option value='Refund-Where is my Refund?-Informed customer about self-ship status' <?= ($ajio_social_media_data['tagging_evaluator']=='Refund-Where is my Refund?-Informed customer about self-ship status')?'selected':'' ?> >Refund-Where is my Refund?-Informed customer about self-ship status</option>
											<option value='Refund-How do I get my money back?-Informed customer about COD refund' <?= ($ajio_social_media_data['tagging_evaluator']=='Refund-How do I get my money back?-Informed customer about COD refund')?'selected':'' ?> >Refund-How do I get my money back?-Informed customer about COD refund</option>
											<option value='Refund-How do I get my money back?-Informed Customer about IMPS procedure' <?= ($ajio_social_media_data['tagging_evaluator']=='Refund-How do I get my money back?-Informed Customer about IMPS procedure')?'selected':'' ?> >Refund-How do I get my money back?-Informed Customer about IMPS procedure</option>
											<option value='Refund-How long does it take to reflect in account once Refund is initiated?-Informed customer of time to refund' <?= ($ajio_social_media_data['tagging_evaluator']=='Refund-How long does it take to reflect in account once Refund is initiated?-Informed customer of time to refund')?'selected':'' ?> >Refund-How long does it take to reflect in account once Refund is initiated?-Informed customer of time to refund</option>
											<option value='Refund-Enable my IMPS Refund-Enabled the IMPS switch' <?= ($ajio_social_media_data['tagging_evaluator']=='Refund-Enable my IMPS Refund-Enabled the IMPS switch')?'selected':'' ?> >Refund-Enable my IMPS Refund-Enabled the IMPS switch</option>
											<option value='Refund-My refund hasnt reflected in source account-Provided Reference No. for CC/DC/NB' <?= ($ajio_social_media_data['tagging_evaluator']=='Refund-My refund hasnt reflected in source account-Provided Reference No. for CC/DC/NB')?'selected':'' ?> >Refund-My refund hasnt reflected in source account-Provided Reference No. for CC/DC/NB</option>
											<option value='Refund-Where is my Refund?-JioMoney refund is processed - informed to wait for 2 business days' <?= ($ajio_social_media_data['tagging_evaluator']=='Refund-Where is my Refund?-JioMoney refund is processed - informed to wait for 2 business days')?'selected':'' ?> >Refund-Where is my Refund?-JioMoney refund is processed - informed to wait for 2 business days</option>
											<option value='Refund-My refund hasnt reflected in source account-Provided Reference No. for e-wallets' <?= ($ajio_social_media_data['tagging_evaluator']=='Refund-My refund hasnt reflected in source account-Provided Reference No. for e-wallets')?'selected':'' ?> >Refund-My refund hasnt reflected in source account-Provided Reference No. for e-wallets</option>
											<option value='Refund-Where is my Refund?-Informed about Refund TAT' <?= ($ajio_social_media_data['tagging_evaluator']=='Refund-Where is my Refund?-Informed about Refund TAT')?'selected':'' ?> >Refund-Where is my Refund?-Informed about Refund TAT</option>
											<option value='Refund-Where is my Refund?-Prepaid refund is processed - informed to wait for 5-7 business days' <?= ($ajio_social_media_data['tagging_evaluator']=='Refund-Where is my Refund?-Prepaid refund is processed - informed to wait for 5-7 business days')?'selected':'' ?> >Refund-Where is my Refund?-Prepaid refund is processed - informed to wait for 5-7 business days</option>
											<option value='Refund-How do I get my money back?-Informed customer about Wallet Refund' <?= ($ajio_social_media_data['tagging_evaluator']=='Refund-How do I get my money back?-Informed customer about Wallet Refund')?'selected':'' ?> >Refund-How do I get my money back?-Informed customer about Wallet Refund</option>
											<option value='Refund-Where is my Refund?-IMPS refund is processed - informed to wait for 1 business day' <?= ($ajio_social_media_data['tagging_evaluator']=='Refund-Where is my Refund?-IMPS refund is processed - informed to wait for 1 business day')?'selected':'' ?> >Refund-Where is my Refund?-IMPS refund is processed - informed to wait for 1 business day</option>
											<option value='Refund-How do I get my money back?-Informed customer about Prepaid Refund' <?= ($ajio_social_media_data['tagging_evaluator']=='Refund-How do I get my money back?-Informed customer about Prepaid Refund')?'selected':'' ?> >Refund-How do I get my money back?-Informed customer about Prepaid Refund</option>
											<option value='Refund-There is a discrepancy with my store credits-Clarified discrepancy with customer' <?= ($ajio_social_media_data['tagging_evaluator']=='Refund-There is a discrepancy with my store credits-Clarified discrepancy with customer')?'selected':'' ?> >Refund-There is a discrepancy with my store credits-Clarified discrepancy with customer</option>
											<option value='Refund-My refund hasnt reflected in source account-Provided reference number for IMPS' <?= ($ajio_social_media_data['tagging_evaluator']=='Refund-My refund hasnt reflected in source account-Provided reference number for IMPS')?'selected':'' ?> >Refund-My refund hasnt reflected in source account-Provided reference number for IMPS</option>
											<option value='Return/Exchange-Create a return for me-Created Return - Received Damaged Product' <?= ($ajio_social_media_data['tagging_evaluator']=='Return/Exchange-Create a return for me-Created Return - Received Damaged Product')?'selected':'' ?> >Return/Exchange-Create a return for me-Created Return - Received Damaged Product</option>
											<option value='Return/Exchange-Create a return for me-Created Return - Different Product delivered' <?= ($ajio_social_media_data['tagging_evaluator']=='Return/Exchange-Create a return for me-Created Return - Different Product delivered')?'selected':'' ?> >Return/Exchange-Create a return for me-Created Return - Different Product delivered</option>
											<option value='Return/Exchange-Create a return for me-Created Return - Wrong size delivered' <?= ($ajio_social_media_data['tagging_evaluator']=='Return/Exchange-Create a return for me-Created Return - Wrong size delivered')?'selected':'' ?> >Return/Exchange-Create a return for me-Created Return - Wrong size delivered</option>
											<option value='Return/Exchange-Create a return for me-Created Return - Product damaged post usage' <?= ($ajio_social_media_data['tagging_evaluator']=='Return/Exchange-Create a return for me-Created Return - Product damaged post usage')?'selected':'' ?> >Return/Exchange-Create a return for me-Created Return - Product damaged post usage</option>
											<option value='Refund-Why is my return rejected/put on hold?-Guided customer on reason' <?= ($ajio_social_media_data['tagging_evaluator']=='Refund-Why is my return rejected/put on hold?-Guided customer on reason')?'selected':'' ?> >Refund-Why is my return rejected/put on hold?-Guided customer on reason</option>
											<option value='Return/Exchange-Create a return for me-Defective Product received' <?= ($ajio_social_media_data['tagging_evaluator']=='Return/Exchange-Create a return for me-Defective Product received')?'selected':'' ?> >Return/Exchange-Create a return for me-Defective Product received</option>
											<option value='Return/Exchange-Create a return for me-Created Return for customer' <?= ($ajio_social_media_data['tagging_evaluator']=='Return/Exchange-Create a return for me-Created Return for customer')?'selected':'' ?> >Return/Exchange-Create a return for me-Created Return for customer</option>
											<option value='Return/Exchange-Create a return for me-Wrong Product delivered' <?= ($ajio_social_media_data['tagging_evaluator']=='Return/Exchange-Create a return for me-Wrong Product delivered')?'selected':'' ?> >Return/Exchange-Create a return for me-Wrong Product delivered</option>
											<option value='Return/Exchange-Create a return for me-Created Return for Used Product' <?= ($ajio_social_media_data['tagging_evaluator']=='Return/Exchange-Create a return for me-Created Return for Used Product')?'selected':'' ?> >Return/Exchange-Create a return for me-Created Return for Used Product</option>
											<option value='Return/Exchange-Create a return for me-Seal tampered cases' <?= ($ajio_social_media_data['tagging_evaluator']=='Return/Exchange-Create a return for me-Seal tampered cases')?'selected':'' ?> >Return/Exchange-Create a return for me-Seal tampered cases</option>
											<option value='Return/Exchange-Create an Exchange for me-Created Exchange for customer' <?= ($ajio_social_media_data['tagging_evaluator']=='Return/Exchange-Create an Exchange for me-Created Exchange for customer')?'selected':'' ?> >Return/Exchange-Create an Exchange for me-Created Exchange for customer</option>
											<option value='Return/Exchange-Create a return for me-Created Return - Wrong colour delivered' <?= ($ajio_social_media_data['tagging_evaluator']=='Return/Exchange-Create a return for me-Created Return - Wrong colour delivered')?'selected':'' ?> >Return/Exchange-Create a return for me-Created Return - Wrong colour delivered</option>
											<option value='Return/Exchange-Create an Exchange for me-Created Exchange – Received Damaged Product' <?= ($ajio_social_media_data['tagging_evaluator']=='Return/Exchange-Create an Exchange for me-Created Exchange – Received Damaged Product')?'selected':'' ?> >Return/Exchange-Create an Exchange for me-Created Exchange – Received Damaged Product</option>
											<option value='Return/Exchange-Create an Exchange for me-Created Return due to lack of size' <?= ($ajio_social_media_data['tagging_evaluator']=='Return/Exchange-Create an Exchange for me-Created Return due to lack of size')?'selected':'' ?> >Return/Exchange-Create an Exchange for me-Created Return due to lack of size</option>
											<option value='Return/Exchange-Has my Self-Ship Return reached you?-Asked to check with customers courier company' <?= ($ajio_social_media_data['tagging_evaluator']=='Return/Exchange-Has my Self-Ship Return reached you?-Asked to check with customers courier company')?'selected':'' ?> >Return/Exchange-Has my Self-Ship Return reached you?-Asked to check with customers courier company</option>
											<option value='Return/Exchange-Has my Self-Ship Return reached you?-Informed - Reached Warehouse and Refund pending' <?= ($ajio_social_media_data['tagging_evaluator']=='Return/Exchange-Has my Self-Ship Return reached you?-Informed - Reached Warehouse and Refund pending')?'selected':'' ?> >Return/Exchange-Has my Self-Ship Return reached you?-Informed - Reached Warehouse and Refund pending</option>
											<option value='Return/Exchange-Exchange Related-Informed – product will get exchanged' <?= ($ajio_social_media_data['tagging_evaluator']=='Return/Exchange-Exchange Related-Informed – product will get exchanged')?'selected':'' ?> >Return/Exchange-Exchange Related-Informed – product will get exchanged</option>
											<option value='Return/Exchange-Create a return for me-Empty Parcel received' <?= ($ajio_social_media_data['tagging_evaluator']=='Return/Exchange-Create a return for me-Empty Parcel received')?'selected':'' ?> >Return/Exchange-Create a return for me-Empty Parcel received</option>
											<option value='Return/Exchange-Has my Self-Ship Return reached you?-Others' <?= ($ajio_social_media_data['tagging_evaluator']=='Return/Exchange-Has my Self-Ship Return reached you?-Others')?'selected':'' ?> >Return/Exchange-Has my Self-Ship Return reached you?-Others</option>
											<option value='Return/Exchange-Create a return for me-Created Return - Tags/Shoebox missing' <?= ($ajio_social_media_data['tagging_evaluator']=='Return/Exchange-Create a return for me-Created Return - Tags/Shoebox missing')?'selected':'' ?> >Return/Exchange-Create a return for me-Created Return - Tags/Shoebox missing</option>
											<option value='Return/Exchange-Has my Self-Ship Return reached you?-Informed - Reached Warehouse and Refund initiated' <?= ($ajio_social_media_data['tagging_evaluator']=='Return/Exchange-Has my Self-Ship Return reached you?-Informed - Reached Warehouse and Refund initiated')?'selected':'' ?> >Return/Exchange-Has my Self-Ship Return reached you?-Informed - Reached Warehouse and Refund initiated</option>
											<option value='Return/Exchange-Customer claiming product picked up-Asked to share acknowledgement copy' <?= ($ajio_social_media_data['tagging_evaluator']=='Return/Exchange-Customer claiming product picked up-Asked to share acknowledgement copy')?'selected':'' ?> >Return/Exchange-Customer claiming product picked up-Asked to share acknowledgement copy</option>
											<option value='Return/Exchange-How do I return/exchange this item?-Declined - Time Period lapsed' <?= ($ajio_social_media_data['tagging_evaluator']=='Return/Exchange-How do I return/exchange this item?-Declined - Time Period lapsed')?'selected':'' ?> >Return/Exchange-How do I return/exchange this item?-Declined - Time Period lapsed</option>
											<option value='Return/Exchange-How do I return/exchange this item?-Email sent to confirm policy - Fitment Issue' <?= ($ajio_social_media_data['tagging_evaluator']=='Return/Exchange-How do I return/exchange this item?-Email sent to confirm policy - Fitment Issue')?'selected':'' ?> >Return/Exchange-How do I return/exchange this item?-Email sent to confirm policy - Fitment Issue</option>
											<option value='Return/Exchange-How do I return/exchange this item?-Informed Return Policy - others' <?= ($ajio_social_media_data['tagging_evaluator']=='Return/Exchange-How do I return/exchange this item?-Informed Return Policy - others')?'selected':'' ?> >Return/Exchange-How do I return/exchange this item?-Informed Return Policy - others</option>
											<option value='Return/Exchange-Has my Self-Ship Return reached you?-Updated tracking number for the customer' <?= ($ajio_social_media_data['tagging_evaluator']=='Return/Exchange-Has my Self-Ship Return reached you?-Updated tracking number for the customer')?'selected':'' ?> >Return/Exchange-Has my Self-Ship Return reached you?-Updated tracking number for the customer</option>
											<option value='Return/Exchange-How do I return/exchange this item?-Educated Customer on Exchange Policy' <?= ($ajio_social_media_data['tagging_evaluator']=='Return/Exchange-How do I return/exchange this item?-Educated Customer on Exchange Policy')?'selected':'' ?> >Return/Exchange-How do I return/exchange this item?-Educated Customer on Exchange Policy</option>
											<option value='Return/Exchange-How do I return/exchange this item?-Declined - Product Used' <?= ($ajio_social_media_data['tagging_evaluator']=='Return/Exchange-How do I return/exchange this item?-Declined - Product Used')?'selected':'' ?> >Return/Exchange-How do I return/exchange this item?-Declined - Product Used</option>
											<option value='Return/Exchange-How do I return/exchange this item?-Declined - Non returnable product' <?= ($ajio_social_media_data['tagging_evaluator']=='Return/Exchange-How do I return/exchange this item?-Declined - Non returnable product')?'selected':'' ?> >Return/Exchange-How do I return/exchange this item?-Declined - Non returnable product</option>
											<option value='Return/Exchange-How do I return/exchange this item?-Declined – Non exchangeable product' <?= ($ajio_social_media_data['tagging_evaluator']=='Return/Exchange-How do I return/exchange this item?-Declined – Non exchangeable product')?'selected':'' ?> >Return/Exchange-How do I return/exchange this item?-Declined – Non exchangeable product</option>
											<option value='Return/Exchange-How do I return/exchange this item?-Declined - tags/shoebox missing' <?= ($ajio_social_media_data['tagging_evaluator']=='Return/Exchange-How do I return/exchange this item?-Declined - tags/shoebox missing')?'selected':'' ?> >Return/Exchange-How do I return/exchange this item?-Declined - tags/shoebox missing</option>
											<option value='Return/Exchange-How do I return/exchange this item?-Requested image for wrong product delivered' <?= ($ajio_social_media_data['tagging_evaluator']=='Return/Exchange-How do I return/exchange this item?-Requested image for wrong product delivered')?'selected':'' ?> >Return/Exchange-How do I return/exchange this item?-Requested image for wrong product delivered</option>
											<option value='Return/Exchange-How do I return/exchange this item?-Email sent to confirm policy - Didnt like product' <?= ($ajio_social_media_data['tagging_evaluator']=='Return/Exchange-How do I return/exchange this item?-Email sent to confirm policy - Didnt like product')?'selected':'' ?> >Return/Exchange-How do I return/exchange this item?-Email sent to confirm policy - Didnt like product</option>
											<option value='Return/Exchange-Unable to create return on website/mobile-Created Return for customer' <?= ($ajio_social_media_data['tagging_evaluator']=='Return/Exchange-Unable to create return on website/mobile-Created Return for customer')?'selected':'' ?> >Return/Exchange-Unable to create return on website/mobile-Created Return for customer</option>
											<option value='Return/Exchange-How do I return/exchange this item?-Educated customer on Self Service steps' <?= ($ajio_social_media_data['tagging_evaluator']=='Return/Exchange-How do I return/exchange this item?-Educated customer on Self Service steps')?'selected':'' ?> >Return/Exchange-How do I return/exchange this item?-Educated customer on Self Service steps</option>
											<option value='Return/Exchange-How do I return/exchange this item?-Informed Return Policy - products' <?= ($ajio_social_media_data['tagging_evaluator']=='Return/Exchange-How do I return/exchange this item?-Informed Return Policy - products')?'selected':'' ?> >Return/Exchange-How do I return/exchange this item?-Informed Return Policy - products</option>
											<option value='Return/Exchange-Pickup related-Provided shipping address' <?= ($ajio_social_media_data['tagging_evaluator']=='Return/Exchange-Pickup related-Provided shipping address')?'selected':'' ?> >Return/Exchange-Pickup related-Provided shipping address</option>
											<option value='Return/Exchange-Pickup related-Informed - Reached WH and Refund initiated' <?= ($ajio_social_media_data['tagging_evaluator']=='Return/Exchange-Pickup related-Informed - Reached WH and Refund initiated')?'selected':'' ?> >Return/Exchange-Pickup related-Informed - Reached WH and Refund initiated</option>
											<option value='Return/Exchange-Pickup related-Others' <?= ($ajio_social_media_data['tagging_evaluator']=='Return/Exchange-Pickup related-Others')?'selected':'' ?> >Return/Exchange-Pickup related-Others</option>
											<option value='Return/Exchange-Pickup related-Provided information on packing product' <?= ($ajio_social_media_data['tagging_evaluator']=='Return/Exchange-Pickup related-Provided information on packing product')?'selected':'' ?> >Return/Exchange-Pickup related-Provided information on packing product</option>
											<option value='Return/Exchange-Pickup related-Informed - product will be picked up' <?= ($ajio_social_media_data['tagging_evaluator']=='Return/Exchange-Pickup related-Informed - product will be picked up')?'selected':'' ?> >Return/Exchange-Pickup related-Informed - product will be picked up</option>
											<option value='Return/Exchange-Pickup related-Informed - picked up product still has to reach Warehouse' <?= ($ajio_social_media_data['tagging_evaluator']=='Return/Exchange-Pickup related-Informed - picked up product still has to reach Warehouse')?'selected':'' ?> >Return/Exchange-Pickup related-Informed - picked up product still has to reach Warehouse</option>
											<option value='Return/Exchange-Is my pin code serviceable for Exchange/Return?-Explained pin-code Serviceability' <?= ($ajio_social_media_data['tagging_evaluator']=='Return/Exchange-Is my pin code serviceable for Exchange/Return?-Explained pin-code Serviceability')?'selected':'' ?> >Return/Exchange-Is my pin code serviceable for Exchange/Return?-Explained pin-code Serviceability</option>
											<option value='Website-Access/Function-Helped in returning order' <?= ($ajio_social_media_data['tagging_evaluator']=='Website-Access/Function-Helped in returning order')?'selected':'' ?> >Website-Access/Function-Helped in returning order</option>
											<option value='Website-Access/Function-Helped in accessing page/site' <?= ($ajio_social_media_data['tagging_evaluator']=='Website-Access/Function-Helped in accessing page/site')?'selected':'' ?> >Website-Access/Function-Helped in accessing page/site</option>
											<option value='Ticket-Cx-Shared attachment-Cx-Shared attachment' <?= ($ajio_social_media_data['tagging_evaluator']=='Ticket-Cx-Shared attachment-Cx-Shared attachment')?'selected':'' ?> >Ticket-Cx-Shared attachment-Cx-Shared attachment</option>
											<option value='Website-Access/Function-Helped in viewing account details' <?= ($ajio_social_media_data['tagging_evaluator']=='Website-Access/Function-Helped in viewing account details')?'selected':'' ?> >Website-Access/Function-Helped in viewing account details</option>
											<option value='Website-Access/Function-Helped in cancelling order' <?= ($ajio_social_media_data['tagging_evaluator']=='Website-Access/Function-Helped in cancelling order')?'selected':'' ?> >Website-Access/Function-Helped in cancelling order</option>
											<option value='Website-Access/Function-Helped in signup/login' <?= ($ajio_social_media_data['tagging_evaluator']=='Website-Access/Function-Helped in signup/login')?'selected':'' ?> >Website-Access/Function-Helped in signup/login</option>
											<option value='Website-How to shop on App?-Guided customer to visit the App' <?= ($ajio_social_media_data['tagging_evaluator']=='Website-How to shop on App?-Guided customer to visit the App')?'selected':'' ?> >Website-How to shop on App?-Guided customer to visit the App</option>
											<option value='Website-How to shop on m-site?-Guided customer to visit the mobile site' <?= ($ajio_social_media_data['tagging_evaluator']=='Website-How to shop on m-site?-Guided customer to visit the mobile site')?'selected':'' ?> >Website-How to shop on m-site?-Guided customer to visit the mobile site</option>
											<option value='OB-Delayed Delivery-To Be Delivered' <?= ($ajio_social_media_data['tagging_evaluator']=='OB-Delayed Delivery-To Be Delivered')?'selected':'' ?> >OB-Delayed Delivery-To Be Delivered</option>
											<option value='OB-Delayed Delivery-Not Connected' <?= ($ajio_social_media_data['tagging_evaluator']=='OB-Delayed Delivery-Not Connected')?'selected':'' ?> >OB-Delayed Delivery-Not Connected</option>
											<option value='OB-Delayed Delivery-Delivered' <?= ($ajio_social_media_data['tagging_evaluator']=='OB-Delayed Delivery-Delivered')?'selected':'' ?> >OB-Delayed Delivery-Delivered</option>
											<option value='OB-Delayed Delivery-RTO' <?= ($ajio_social_media_data['tagging_evaluator']=='OB-Delayed Delivery-RTO')?'selected':'' ?> >OB-Delayed Delivery-RTO</option>
											<option value='Website-Please explain AJIO-Explained about website' <?= ($ajio_social_media_data['tagging_evaluator']=='Website-Please explain AJIO-Explained about website')?'selected':'' ?> >Website-Please explain AJIO-Explained about website</option>
											<option value='OB-Order In Progress-Not Connected' <?= ($ajio_social_media_data['tagging_evaluator']=='OB-Order In Progress-Not Connected')?'selected':'' ?> >OB-Order In Progress-Not Connected</option>
											<option value='OB-NDR-Delivered' <?= ($ajio_social_media_data['tagging_evaluator']=='OB-NDR-Delivered')?'selected':'' ?> >OB-NDR-Delivered</option>
											<option value='OB-Misc-Informed' <?= ($ajio_social_media_data['tagging_evaluator']=='OB-Misc-Informed')?'selected':'' ?> >OB-Misc-Informed</option>
											<option value='OB-NDR-To Be Delivered' <?= ($ajio_social_media_data['tagging_evaluator']=='OB-NDR-To Be Delivered')?'selected':'' ?> >OB-NDR-To Be Delivered</option>
											<option value='OB-Misc-Not Connected' <?= ($ajio_social_media_data['tagging_evaluator']=='OB-Misc-Not Connected')?'selected':'' ?> >OB-Misc-Not Connected</option>
											<option value='OB-Order In Progress-MRP Mismatch - Credit' <?= ($ajio_social_media_data['tagging_evaluator']=='OB-Order In Progress-MRP Mismatch - Credit')?'selected':'' ?> >OB-Order In Progress-MRP Mismatch - Credit</option>
											<option value='OB-Order In Progress-MRP Mismatch - Waiver' <?= ($ajio_social_media_data['tagging_evaluator']=='OB-Order In Progress-MRP Mismatch - Waiver')?'selected':'' ?> >OB-Order In Progress-MRP Mismatch - Waiver</option>
											<option value='OB-Order In Progress-Short Pick - Partially Cancelled' <?= ($ajio_social_media_data['tagging_evaluator']=='OB-Order In Progress-Short Pick - Partially Cancelled')?'selected':'' ?> >OB-Order In Progress-Short Pick - Partially Cancelled</option>
											<option value='OB-Order In Progress-MRP Mismatch - Cancelled' <?= ($ajio_social_media_data['tagging_evaluator']=='OB-Order In Progress-MRP Mismatch - Cancelled')?'selected':'' ?> >OB-Order In Progress-MRP Mismatch - Cancelled</option>
											<option value='OB-Order In Progress-Sales Tax - To be RTOed' <?= ($ajio_social_media_data['tagging_evaluator']=='OB-Order In Progress-Sales Tax - To be RTOed')?'selected':'' ?> >OB-Order In Progress-Sales Tax - To be RTOed</option>
											<option value='OB-Order In Progress-Sales Tax - To be delivered' <?= ($ajio_social_media_data['tagging_evaluator']=='OB-Order In Progress-Sales Tax - To be delivered')?'selected':'' ?> >OB-Order In Progress-Sales Tax - To be delivered</option>
											<option value='OB-Order In Progress-Order Lost - Informed' <?= ($ajio_social_media_data['tagging_evaluator']=='OB-Order In Progress-Order Lost - Informed')?'selected':'' ?> >OB-Order In Progress-Order Lost - Informed</option>
											<option value='OB-Callback-Not Connected' <?= ($ajio_social_media_data['tagging_evaluator']=='OB-Callback-Not Connected')?'selected':'' ?> >OB-Callback-Not Connected</option>
											<option value='OB-Ticket-Not Connected' <?= ($ajio_social_media_data['tagging_evaluator']=='OB-Ticket-Not Connected')?'selected':'' ?> >OB-Ticket-Not Connected</option>
											<option value='OB-Order In Progress-Telesales - Cancelled' <?= ($ajio_social_media_data['tagging_evaluator']=='OB-Order In Progress-Telesales - Cancelled')?'selected':'' ?> >OB-Order In Progress-Telesales - Cancelled</option>
											<option value='OB-Order In Progress-OOS - Informed' <?= ($ajio_social_media_data['tagging_evaluator']=='OB-Order In Progress-OOS - Informed')?'selected':'' ?> >OB-Order In Progress-OOS - Informed</option>
											<option value='OB-Order In Progress-Short Pick - Cancelled' <?= ($ajio_social_media_data['tagging_evaluator']=='OB-Order In Progress-Short Pick - Cancelled')?'selected':'' ?> >OB-Order In Progress-Short Pick - Cancelled</option>
											<option value='OB-Cancellation due to QC fail-Not Connected' <?= ($ajio_social_media_data['tagging_evaluator']=='OB-Cancellation due to QC fail-Not Connected')?'selected':'' ?> >OB-Cancellation due to QC fail-Not Connected</option>
											<option value='OB-Ticket-Ticket Created' <?= ($ajio_social_media_data['tagging_evaluator']=='OB-Ticket-Ticket Created')?'selected':'' ?> >OB-Ticket-Ticket Created</option>
											<option value='OB-Cancellation due to QC fail-Informed' <?= ($ajio_social_media_data['tagging_evaluator']=='OB-Cancellation due to QC fail-Informed')?'selected':'' ?> >OB-Cancellation due to QC fail-Informed</option>
											<option value='OB-Survey-Not Connected' <?= ($ajio_social_media_data['tagging_evaluator']=='OB-Survey-Not Connected')?'selected':'' ?> >OB-Survey-Not Connected</option>
											<option value='OB-Ticket-Ticket Escalation' <?= ($ajio_social_media_data['tagging_evaluator']=='OB-Ticket-Ticket Escalation')?'selected':'' ?> >OB-Ticket-Ticket Escalation</option>
											<option value='OB-Ticket-Ticket Closed' <?= ($ajio_social_media_data['tagging_evaluator']=='OB-Ticket-Ticket Closed')?'selected':'' ?> >OB-Ticket-Ticket Closed</option>
											<option value='OB-Ticket-Ticket Follow Up' <?= ($ajio_social_media_data['tagging_evaluator']=='OB-Ticket-Ticket Follow Up')?'selected':'' ?> >OB-Ticket-Ticket Follow Up</option>
											<option value='OB-Survey-Incomplete Survey' <?= ($ajio_social_media_data['tagging_evaluator']=='OB-Survey-Incomplete Survey')?'selected':'' ?> >OB-Survey-Incomplete Survey</option>
											<option value='OB-NDR-To Be Delivered - Fake Remarks' <?= ($ajio_social_media_data['tagging_evaluator']=='OB-NDR-To Be Delivered - Fake Remarks')?'selected':'' ?> >OB-NDR-To Be Delivered - Fake Remarks</option>
											<option value='OB-Survey-Completed' <?= ($ajio_social_media_data['tagging_evaluator']=='OB-Survey-Completed')?'selected':'' ?> >OB-Survey-Completed</option>
											<option value='OB-NDR-Not Contactable2' <?= ($ajio_social_media_data['tagging_evaluator']=='OB-NDR-Not Contactable2')?'selected':'' ?> >OB-NDR-Not Contactable2</option>
											<option value='OB-NDR-Not Contactable1' <?= ($ajio_social_media_data['tagging_evaluator']=='OB-NDR-Not Contactable1')?'selected':'' ?> >OB-NDR-Not Contactable1</option>
											<option value='OB-NPR-Picked Up' <?= ($ajio_social_media_data['tagging_evaluator']=='OB-NPR-Picked Up')?'selected':'' ?> >OB-NPR-Picked Up</option>
											<option value='OB-NPR-Not Contactable3' <?= ($ajio_social_media_data['tagging_evaluator']=='OB-NPR-Not Contactable3')?'selected':'' ?> >OB-NPR-Not Contactable3</option>
											<option value='OB-NPR-To Be Picked Up - Fake Remarks' <?= ($ajio_social_media_data['tagging_evaluator']=='OB-NPR-To Be Picked Up - Fake Remarks')?'selected':'' ?> >OB-NPR-To Be Picked Up - Fake Remarks</option>
											<option value='OB-NPR-Pickup Cancelled' <?= ($ajio_social_media_data['tagging_evaluator']=='OB-NPR-Pickup Cancelled')?'selected':'' ?> >OB-NPR-Pickup Cancelled</option>
											<option value='OB-NPR-Not Contactable2' <?= ($ajio_social_media_data['tagging_evaluator']=='OB-NPR-Not Contactable2')?'selected':'' ?> >OB-NPR-Not Contactable2</option>
											<option value='OB-NPR-To Be Picked Up' <?= ($ajio_social_media_data['tagging_evaluator']=='OB-NPR-To Be Picked Up')?'selected':'' ?> >OB-NPR-To Be Picked Up</option>
											<option value='OB-NDR-Not Contactable3' <?= ($ajio_social_media_data['tagging_evaluator']=='OB-NDR-Not Contactable3')?'selected':'' ?> >OB-NDR-Not Contactable3</option>
											<option value='OB-NPR-Not Contactable1' <?= ($ajio_social_media_data['tagging_evaluator']=='OB-NPR-Not Contactable1')?'selected':'' ?> >OB-NPR-Not Contactable1</option>
											<option value='OB-NDR-To Be RTO - Fake Remarks' <?= ($ajio_social_media_data['tagging_evaluator']=='OB-NDR-To Be RTO - Fake Remarks')?'selected':'' ?> >OB-NDR-To Be RTO - Fake Remarks</option>
											<option value='OB-NDR-To Be RTO' <?= ($ajio_social_media_data['tagging_evaluator']=='OB-NDR-To Be RTO')?'selected':'' ?> >OB-NDR-To Be RTO</option>
											<option value='Feedback-Others-N/A' <?= ($ajio_social_media_data['tagging_evaluator']=='Feedback-Others-N/A')?'selected':'' ?> >Feedback-Others-N/A</option>
											<option value='Feedback-Suggestions about Website-N/A' <?= ($ajio_social_media_data['tagging_evaluator']=='Feedback-Suggestions about Website-N/A')?'selected':'' ?> >Feedback-Suggestions about Website-N/A</option>
											<option value='Feedback-Suggestions about CC-N/A' <?= ($ajio_social_media_data['tagging_evaluator']=='Feedback-Suggestions about CC-N/A')?'selected':'' ?> >Feedback-Suggestions about CC-N/A</option>
											<option value='Feedback-Suggestions about Warehouse-N/A' <?= ($ajio_social_media_data['tagging_evaluator']=='Feedback-Suggestions about Warehouse-N/A')?'selected':'' ?> >Feedback-Suggestions about Warehouse-N/A</option>
											<option value='Feedback-Suggestions about Profile-N/A' <?= ($ajio_social_media_data['tagging_evaluator']=='Feedback-Suggestions about Profile-N/A')?'selected':'' ?> >Feedback-Suggestions about Profile-N/A</option>
											<option value='Feedback-Suggestions about Returns/Exchange-N/A' <?= ($ajio_social_media_data['tagging_evaluator']=='Feedback-Suggestions about Returns/Exchange-N/A')?'selected':'' ?> >Feedback-Suggestions about Returns/Exchange-N/A</option>
											<option value='Feedback-Suggestions about Delivery-N/A' <?= ($ajio_social_media_data['tagging_evaluator']=='Feedback-Suggestions about Delivery-N/A')?'selected':'' ?> >Feedback-Suggestions about Delivery-N/A</option>
											<option value='Feedback-Suggestions about CC-Unable to reach customer care number' <?= ($ajio_social_media_data['tagging_evaluator']=='Feedback-Suggestions about CC-Unable to reach customer care number')?'selected':'' ?> >Feedback-Suggestions about CC-Unable to reach customer care number</option>
											<option value='Feedback-Suggestions about Products-N/A' <?= ($ajio_social_media_data['tagging_evaluator']=='Feedback-Suggestions about Products-N/A')?'selected':'' ?> >Feedback-Suggestions about Products-N/A</option>
											<option value='Feedback-Suggestions about CC-Others' <?= ($ajio_social_media_data['tagging_evaluator']=='Feedback-Suggestions about CC-Others')?'selected':'' ?> >Feedback-Suggestions about CC-Others</option>
											<option value='Feedback-Suggestions about Refund-N/A' <?= ($ajio_social_media_data['tagging_evaluator']=='Feedback-Suggestions about Refund-N/A')?'selected':'' ?> >Feedback-Suggestions about Refund-N/A</option>
											<option value='Feedback-Mobile App-Feedback/Suggestion about mobile App' <?= ($ajio_social_media_data['tagging_evaluator']=='Feedback-Mobile App-Feedback/Suggestion about mobile App')?'selected':'' ?> >Feedback-Mobile App-Feedback/Suggestion about mobile App</option>
											<option value='Online Refund-Refund not done against Reference No. - Prepaid cancelled-N/A' <?= ($ajio_social_media_data['tagging_evaluator']=='Online Refund-Refund not done against Reference No. - Prepaid cancelled-N/A')?'selected':'' ?> >Online Refund-Refund not done against Reference No. - Prepaid cancelled-N/A</option>
											<option value='WH - Order Related Issues-Forward-Shipment Lost to be refunded' <?= ($ajio_social_media_data['tagging_evaluator']=='WH - Order Related Issues-Forward-Shipment Lost to be refunded')?'selected':'' ?> >WH - Order Related Issues-Forward-Shipment Lost to be refunded</option>
											<option value='Delivery-POD Required-Customer Disputes on POD Shared' <?= ($ajio_social_media_data['tagging_evaluator']=='Delivery-POD Required-Customer Disputes on POD Shared')?'selected':'' ?> >Delivery-POD Required-Customer Disputes on POD Shared</option>
											<option value='Delivery-Where is my Order?-Informed Order is RTOed' <?= ($ajio_social_media_data['tagging_evaluator']=='Delivery-Where is my Order?-Informed Order is RTOed')?'selected':'' ?> >Delivery-Where is my Order?-Informed Order is RTOed</option>
											<option value='Delivery-Where is my Order?-Informed Promised Delivery Date' <?= ($ajio_social_media_data['tagging_evaluator']=='Delivery-Where is my Order?-Informed Promised Delivery Date')?'selected':'' ?> >Delivery-Where is my Order?-Informed Promised Delivery Date</option>
											<option value='Delivery-Order not marked as Delivered-N/A' <?= ($ajio_social_media_data['tagging_evaluator']=='Delivery-Order not marked as Delivered-N/A')?'selected':'' ?> >Delivery-Order not marked as Delivered-N/A</option>
											<option value='Coupon-How do I use my Jio Prime Points?-Educated customer on Jio Prime points' <?= ($ajio_social_media_data['tagging_evaluator']=='Coupon-How do I use my Jio Prime Points?-Educated customer on Jio Prime points')?'selected':'' ?> >Coupon-How do I use my Jio Prime Points?-Educated customer on Jio Prime points</option>
											<option value='Return/Exchange-Is my pin code serviceable for Exchange/Return?-Informed about non availability of exchange at store' <?= ($ajio_social_media_data['tagging_evaluator']=='Return/Exchange-Is my pin code serviceable for Exchange/Return?-Informed about non availability of exchange at store')?'selected':'' ?> >Return/Exchange-Is my pin code serviceable for Exchange/Return?-Informed about non availability of exchange at store</option>
											<option value='Return/Exchange-Is my pin code serviceable for Exchange/Return?-Informed serviceability of drop at store for product/store' <?= ($ajio_social_media_data['tagging_evaluator']=='Return/Exchange-Is my pin code serviceable for Exchange/Return?-Informed serviceability of drop at store for product/store')?'selected':'' ?> >Return/Exchange-Is my pin code serviceable for Exchange/Return?-Informed serviceability of drop at store for product/store</option>
											<option value='Return/Exchange-How do I return/exchange this item?-Informed how drop at store option works' <?= ($ajio_social_media_data['tagging_evaluator']=='Return/Exchange-How do I return/exchange this item?-Informed how drop at store option works')?'selected':'' ?> >Return/Exchange-How do I return/exchange this item?-Informed how drop at store option works</option>
											<option value='Refund-How do I get my money back?-Informed customer about Drop at Store refund – Prepaid Order' <?= ($ajio_social_media_data['tagging_evaluator']=='Refund-How do I get my money back?-Informed customer about Drop at Store refund – Prepaid Order')?'selected':'' ?> >Refund-How do I get my money back?-Informed customer about Drop at Store refund – Prepaid Order</option>
											<option value='Refund-How do I get my money back?-Informed Cx about SC refund for Drop at Store' <?= ($ajio_social_media_data['tagging_evaluator']=='Refund-How do I get my money back?-Informed Cx about SC refund for Drop at Store')?'selected':'' ?> >Refund-How do I get my money back?-Informed Cx about SC refund for Drop at Store</option>
											<option value='Refund-How do I get my money back?-Informed Cx about cash refund for drop at store' <?= ($ajio_social_media_data['tagging_evaluator']=='Refund-How do I get my money back?-Informed Cx about cash refund for drop at store')?'selected':'' ?> >Refund-How do I get my money back?-Informed Cx about cash refund for drop at store</option>
											<option value='Refund-Where is my Refund?-Informed about drop at store refund TAT' <?= ($ajio_social_media_data['tagging_evaluator']=='Refund-Where is my Refund?-Informed about drop at store refund TAT')?'selected':'' ?> >Refund-Where is my Refund?-Informed about drop at store refund TAT</option>
											<option value='WH - Order Related Issues-Customer Return-Wrong Product Received – EAN Matched' <?= ($ajio_social_media_data['tagging_evaluator']=='WH - Order Related Issues-Customer Return-Wrong Product Received – EAN Matched')?'selected':'' ?> >WH - Order Related Issues-Customer Return-Wrong Product Received – EAN Matched</option>
											<option value='WH - Order Related Issues-Customer Return-Used Product Received' <?= ($ajio_social_media_data['tagging_evaluator']=='WH - Order Related Issues-Customer Return-Used Product Received')?'selected':'' ?> >WH - Order Related Issues-Customer Return-Used Product Received</option>
											<option value='Goodwill Request-CM insisting Compensation-Coupon Reactivation' <?= ($ajio_social_media_data['tagging_evaluator']=='Goodwill Request-CM insisting Compensation-Coupon Reactivation')?'selected':'' ?> >Goodwill Request-CM insisting Compensation-Coupon Reactivation</option>
											<option value='Return-Non Returnable Product-Wrong Product delivered' <?= ($ajio_social_media_data['tagging_evaluator']=='Return-Non Returnable Product-Wrong Product delivered')?'selected':'' ?> >Return-Non Returnable Product-Wrong Product delivered</option>
											<option value='Return-Customer Delight-N/A' <?= ($ajio_social_media_data['tagging_evaluator']=='Return-Customer Delight-N/A')?'selected':'' ?> >Return-Customer Delight-N/A</option>
											<option value='Delivery-Customer Delight-N/A' <?= ($ajio_social_media_data['tagging_evaluator']=='Delivery-Customer Delight-N/A')?'selected':'' ?> >Delivery-Customer Delight-N/A</option>
											<option value='Return-Non Returnable Product-Tags Detached but available' <?= ($ajio_social_media_data['tagging_evaluator']=='Return-Non Returnable Product-Tags Detached but available')?'selected':'' ?> >Return-Non Returnable Product-Tags Detached but available</option>
											<option value='Return-Non Returnable Product-Tags Not Available - Not Received' <?= ($ajio_social_media_data['tagging_evaluator']=='Return-Non Returnable Product-Tags Not Available - Not Received')?'selected':'' ?> >Return-Non Returnable Product-Tags Not Available - Not Received</option>
											<option value='Return-Non Returnable Product-Tags Not Available - Misplaced by customer' <?= ($ajio_social_media_data['tagging_evaluator']=='Return-Non Returnable Product-Tags Not Available - Misplaced by customer')?'selected':'' ?> >Return-Non Returnable Product-Tags Not Available - Misplaced by customer</option>
											<option value='Return-Non Returnable Product-Used Product Delivered' <?= ($ajio_social_media_data['tagging_evaluator']=='Return-Non Returnable Product-Used Product Delivered')?'selected':'' ?> >Return-Non Returnable Product-Used Product Delivered</option>
											<option value='Return-Non Returnable Product-Classified as non-returnable' <?= ($ajio_social_media_data['tagging_evaluator']=='Return-Non Returnable Product-Classified as non-returnable')?'selected':'' ?> >Return-Non Returnable Product-Classified as non-returnable</option>
											<option value='Return-Non Returnable Product-Return - Post Return Window' <?= ($ajio_social_media_data['tagging_evaluator']=='Return-Non Returnable Product-Return - Post Return Window')?'selected':'' ?> >Return-Non Returnable Product-Return - Post Return Window</option>
											<option value='Return/Exchange-How do I return/exchange this item?-Requested customer to share the images' <?= ($ajio_social_media_data['tagging_evaluator']=='Return/Exchange-How do I return/exchange this item?-Requested customer to share the images')?'selected':'' ?> >Return/Exchange-How do I return/exchange this item?-Requested customer to share the images</option>
											<option value='WH - Order Related Issues-Customer Return-Customer confirmation Required (Non-AJIO Product Received)' <?= ($ajio_social_media_data['tagging_evaluator']=='WH - Order Related Issues-Customer Return-Customer confirmation Required (Non-AJIO Product Received)')?'selected':'' ?> >WH - Order Related Issues-Customer Return-Customer confirmation Required (Non-AJIO Product Received)</option>
											<option value='WH - Order Related Issues-Customer Return-Other node shipment received' <?= ($ajio_social_media_data['tagging_evaluator']=='WH - Order Related Issues-Customer Return-Other node shipment received')?'selected':'' ?> >WH - Order Related Issues-Customer Return-Other node shipment received</option>
											<option value='Account-Store Credit Discrepancy-AJIO Cash' <?= ($ajio_social_media_data['tagging_evaluator']=='Account-Store Credit Discrepancy-AJIO Cash')?'selected':'' ?> >Account-Store Credit Discrepancy-AJIO Cash</option>
											<option value='Account-Store Credit Discrepancy-Bonus Points' <?= ($ajio_social_media_data['tagging_evaluator']=='Account-Store Credit Discrepancy-Bonus Points')?'selected':'' ?> >Account-Store Credit Discrepancy-Bonus Points</option>
											<option value='NAR Calls/Emails-NAR Emails-Replied & Asked for More Information' <?= ($ajio_social_media_data['tagging_evaluator']=='NAR Calls/Emails-NAR Emails-Replied & Asked for More Information')?'selected':'' ?> >NAR Calls/Emails-NAR Emails-Replied & Asked for More Information</option>
											<option value='Delivery-Where is my Order?-Guided customer to track the order online' <?= ($ajio_social_media_data['tagging_evaluator']=='Delivery-Where is my Order?-Guided customer to track the order online')?'selected':'' ?> >Delivery-Where is my Order?-Guided customer to track the order online</option>
											<option value='Order-I had a problem while placing an order-ADONP – within 48 hrs' <?= ($ajio_social_media_data['tagging_evaluator']=='Order-I had a problem while placing an order-ADONP – within 48 hrs')?'selected':'' ?> >Order-I had a problem while placing an order-ADONP – within 48 hrs</option>
											<option value='Website-Complaint relating to Website-Return ID in Approved Status' <?= ($ajio_social_media_data['tagging_evaluator']=='Website-Complaint relating to Website-Return ID in Approved Status')?'selected':'' ?> >Website-Complaint relating to Website-Return ID in Approved Status</option>
											<option value='Order-What are the payment modes?-Informed Cx COD Not Available' <?= ($ajio_social_media_data['tagging_evaluator']=='Order-What are the payment modes?-Informed Cx COD Not Available')?'selected':'' ?> >Order-What are the payment modes?-Informed Cx COD Not Available</option>
											<option value='Website-Complaint relating to Website-AWB Not Assigned' <?= ($ajio_social_media_data['tagging_evaluator']=='Website-Complaint relating to Website-AWB Not Assigned')?'selected':'' ?> >Website-Complaint relating to Website-AWB Not Assigned</option>
											<option value='NAR Calls/Emails-NAR Calls-Already Actioned' <?= ($ajio_social_media_data['tagging_evaluator']=='NAR Calls/Emails-NAR Calls-Already Actioned')?'selected':'' ?> >NAR Calls/Emails-NAR Calls-Already Actioned</option>
											<option value='NAR Calls/Emails-NAR Emails-Already Actioned' <?= ($ajio_social_media_data['tagging_evaluator']=='NAR Calls/Emails-NAR Emails-Already Actioned')?'selected':'' ?> >NAR Calls/Emails-NAR Emails-Already Actioned</option>
											<option value='OB-QC fail while returning-Callback Requested' <?= ($ajio_social_media_data['tagging_evaluator']=='OB-QC fail while returning-Callback Requested')?'selected':'' ?> >OB-QC fail while returning-Callback Requested</option>
											<option value='OB-QC fail while returning-Others' <?= ($ajio_social_media_data['tagging_evaluator']=='OB-QC fail while returning-Others')?'selected':'' ?> >OB-QC fail while returning-Others</option>
											<option value='OB-QC fail while returning-Asked to share images' <?= ($ajio_social_media_data['tagging_evaluator']=='OB-QC fail while returning-Asked to share images')?'selected':'' ?> >OB-QC fail while returning-Asked to share images</option>
											<option value='OB-QC fail while returning-Raised pick without QC' <?= ($ajio_social_media_data['tagging_evaluator']=='OB-QC fail while returning-Raised pick without QC')?'selected':'' ?> >OB-QC fail while returning-Raised pick without QC</option>
											<option value='OB-QC fail while returning-Declined Returns' <?= ($ajio_social_media_data['tagging_evaluator']=='OB-QC fail while returning-Declined Returns')?'selected':'' ?> >OB-QC fail while returning-Declined Returns</option>
											<option value='OB-QC fail while returning-Raised Fake Attempt Complaint' <?= ($ajio_social_media_data['tagging_evaluator']=='OB-QC fail while returning-Raised Fake Attempt Complaint')?'selected':'' ?> >OB-QC fail while returning-Raised Fake Attempt Complaint</option>
											<option value='Pre Order - RJ-What are my delivery / payment options-Informed customer of payment / delivery options' <?= ($ajio_social_media_data['tagging_evaluator']=='Pre Order - RJ-What are my delivery / payment options-Informed customer of payment / delivery options')?'selected':'' ?> >Pre Order - RJ-What are my delivery / payment options-Informed customer of payment / delivery options</option>
											<option value='Pre Order - RJ-I need Authenticity information-Provided Information' <?= ($ajio_social_media_data['tagging_evaluator']=='Pre Order - RJ-I need Authenticity information-Provided Information')?'selected':'' ?> >Pre Order - RJ-I need Authenticity information-Provided Information</option>
											<option value='Pre Order - RJ-Explain the features of the product-Explained about product features / Pricing' <?= ($ajio_social_media_data['tagging_evaluator']=='Pre Order - RJ-Explain the features of the product-Explained about product features / Pricing')?'selected':'' ?> >Pre Order - RJ-Explain the features of the product-Explained about product features / Pricing</option>
											<option value='Account-Query / Dispute about LR-Guided customer to LR team' <?= ($ajio_social_media_data['tagging_evaluator']=='Account-Query / Dispute about LR-Guided customer to LR team')?'selected':'' ?> >Account-Query / Dispute about LR-Guided customer to LR team</option>
											<option value='Account-How do I use my Loyalty Rewards-Explained how to use LR' <?= ($ajio_social_media_data['tagging_evaluator']=='Account-How do I use my Loyalty Rewards-Explained how to use LR')?'selected':'' ?> >Account-How do I use my Loyalty Rewards-Explained how to use LR</option>
											<option value='Delivery-Order not dispatched from Warehouse-Shipment in Packed Status' <?= ($ajio_social_media_data['tagging_evaluator']=='Delivery-Order not dispatched from Warehouse-Shipment in Packed Status')?'selected':'' ?> >Delivery-Order not dispatched from Warehouse-Shipment in Packed Status</option>
											<option value='Return-Reached Warehouse - Refund not Initiated-Excess product handed over' <?= ($ajio_social_media_data['tagging_evaluator']=='Return-Reached Warehouse - Refund not Initiated-Excess product handed over')?'selected':'' ?> >Return-Reached Warehouse - Refund not Initiated-Excess product handed over</option>
											<option value='Delivery-POD Required-Req cx to check with neighbour / security' <?= ($ajio_social_media_data['tagging_evaluator']=='Delivery-POD Required-Req cx to check with neighbour / security')?'selected':'' ?> >Delivery-POD Required-Req cx to check with neighbour / security</option>
											<option value='Return-Wrong item with no tag-Return form' <?= ($ajio_social_media_data['tagging_evaluator']=='Return-Wrong item with no tag-Return form')?'selected':'' ?> >Return-Wrong item with no tag-Return form</option>
											<option value='Return-Wrong Item-Return form' <?= ($ajio_social_media_data['tagging_evaluator']=='Return-Wrong Item-Return form')?'selected':'' ?> >Return-Wrong Item-Return form</option>
											<option value='OB-Misc-Not Connected - Email Sent' <?= ($ajio_social_media_data['tagging_evaluator']=='OB-Misc-Not Connected - Email Sent')?'selected':'' ?> >OB-Misc-Not Connected - Email Sent</option>
											<option value='Reliance Jewels-I want certification of authenticity-Certificate to be sent' <?= ($ajio_social_media_data['tagging_evaluator']=='Reliance Jewels-I want certification of authenticity-Certificate to be sent')?'selected':'' ?> >Reliance Jewels-I want certification of authenticity-Certificate to be sent</option>
											<option value='Reliance Jewels-Information on weight/purity-Requested customer to visit nearest RJ store' <?= ($ajio_social_media_data['tagging_evaluator']=='Reliance Jewels-Information on weight/purity-Requested customer to visit nearest RJ store')?'selected':'' ?> >Reliance Jewels-Information on weight/purity-Requested customer to visit nearest RJ store</option>
											<option value='Return-Package ID related-cancellation due to items exceeding the package dimension' <?= ($ajio_social_media_data['tagging_evaluator']=='Return-Package ID related-cancellation due to items exceeding the package dimension')?'selected':'' ?> >Return-Package ID related-cancellation due to items exceeding the package dimension</option>
											<option value='Return-Package ID related-duplicate Package ID to be sent' <?= ($ajio_social_media_data['tagging_evaluator']=='Return-Package ID related-duplicate Package ID to be sent')?'selected':'' ?> >Return-Package ID related-duplicate Package ID to be sent</option>
											<option value='Pre Order - AJIO LUX-Explain the features of the product-Explained about product features' <?= ($ajio_social_media_data['tagging_evaluator']=='Pre Order - AJIO LUX-Explain the features of the product-Explained about product features')?'selected':'' ?> >Pre Order - AJIO LUX-Explain the features of the product-Explained about product features</option>
											<option value='Pre Order - AJIO LUX-I need warranty information-Provided Information' <?= ($ajio_social_media_data['tagging_evaluator']=='Pre Order - AJIO LUX-I need warranty information-Provided Information')?'selected':'' ?> >Pre Order - AJIO LUX-I need warranty information-Provided Information</option>
											<option value='Pre Order - AJIO LUX-Where can i find this product?-Informed customer that the product is not in stock' <?= ($ajio_social_media_data['tagging_evaluator']=='Pre Order - AJIO LUX-Where can i find this product?-Informed customer that the product is not in stock')?'selected':'' ?> >Pre Order - AJIO LUX-Where can i find this product?-Informed customer that the product is not in stock</option>
											<option value='Pre Order - AJIO LUX-Where can i find this product?-Helped customer to find the product' <?= ($ajio_social_media_data['tagging_evaluator']=='Pre Order - AJIO LUX-Where can i find this product?-Helped customer to find the product')?'selected':'' ?> >Pre Order - AJIO LUX-Where can i find this product?-Helped customer to find the product</option>
											<option value='Delivery-Marked the order as delivered-N/A' <?= ($ajio_social_media_data['tagging_evaluator']=='Delivery-Marked the order as delivered-N/A')?'selected':'' ?> >Delivery-Marked the order as delivered-N/A</option>
											<option value='Refund-Where is my Refund?-Educated customer about GST refund' <?= ($ajio_social_media_data['tagging_evaluator']=='Refund-Where is my Refund?-Educated customer about GST refund')?'selected':'' ?> >Refund-Where is my Refund?-Educated customer about GST refund</option>
											<option value='Return/Exchange-How do I return/exchange this item?-Email sent to confirm policy - Missing Product/Component' <?= ($ajio_social_media_data['tagging_evaluator']=='Return/Exchange-How do I return/exchange this item?-Email sent to confirm policy - Missing Product/Component')?'selected':'' ?> >Return/Exchange-How do I return/exchange this item?-Email sent to confirm policy - Missing Product/Component</option>
											<option value='NAR Calls/Emails-NAR Emails-Non AJIO Query' <?= ($ajio_social_media_data['tagging_evaluator']=='NAR Calls/Emails-NAR Emails-Non AJIO Query')?'selected':'' ?> >NAR Calls/Emails-NAR Emails-Non AJIO Query</option>
											<option value='Coupon-Unable to apply coupon-Requested to share coupon details/images' <?= ($ajio_social_media_data['tagging_evaluator']=='Coupon-Unable to apply coupon-Requested to share coupon details/images')?'selected':'' ?> >Coupon-Unable to apply coupon-Requested to share coupon details/images</option>
											<option value='Account-Store Credit Debited Order Not Processed-R-1 Points' <?= ($ajio_social_media_data['tagging_evaluator']=='Account-Store Credit Debited Order Not Processed-R-1 Points')?'selected':'' ?> >Account-Store Credit Debited Order Not Processed-R-1 Points</option>
											<option value='Account-I have not received my referral bonus-Informed about referral credit' <?= ($ajio_social_media_data['tagging_evaluator']=='Account-I have not received my referral bonus-Informed about referral credit')?'selected':'' ?> >Account-I have not received my referral bonus-Informed about referral credit</option>
											<option value='Account-Ajio Referral Discrepancy-Referral points/code not received' <?= ($ajio_social_media_data['tagging_evaluator']=='Account-Ajio Referral Discrepancy-Referral points/code not received')?'selected':'' ?> >Account-Ajio Referral Discrepancy-Referral points/code not received</option>
											<option value='Website-Complaint relating to Website-Order Delivered - Consignment not visible' <?= ($ajio_social_media_data['tagging_evaluator']=='Website-Complaint relating to Website-Order Delivered - Consignment not visible')?'selected':'' ?> >Website-Complaint relating to Website-Order Delivered - Consignment not visible</option>
											<option value='Return-Reached Warehouse - Refund not Initiated-Partial Refund Initiated' <?= ($ajio_social_media_data['tagging_evaluator']=='Return-Reached Warehouse - Refund not Initiated-Partial Refund Initiated')?'selected':'' ?> >Return-Reached Warehouse - Refund not Initiated-Partial Refund Initiated</option>
											<option value='Website-Complaint relating to Website-Change in login info' <?= ($ajio_social_media_data['tagging_evaluator']=='Website-Complaint relating to Website-Change in login info')?'selected':'' ?> >Website-Complaint relating to Website-Change in login info</option>
											<option value='Account-Fraudulent Activity reported-Educated customer as per policy' <?= ($ajio_social_media_data['tagging_evaluator']=='Account-Fraudulent Activity reported-Educated customer as per policy')?'selected':'' ?> >Account-Fraudulent Activity reported-Educated customer as per policy</option>
											<option value='Return-Cancelation Request (Chatbot only)-Return to be cancelled (Chatbot only)' <?= ($ajio_social_media_data['tagging_evaluator']=='Return-Cancelation Request (Chatbot only)-Return to be cancelled (Chatbot only)')?'selected':'' ?> >Return-Cancelation Request (Chatbot only)-Return to be cancelled (Chatbot only)</option>
											<option value='Account-R- One related-R - One refund not credited' <?= ($ajio_social_media_data['tagging_evaluator']=='Account-R- One related-R - One refund not credited')?'selected':'' ?> >Account-R- One related-R - One refund not credited</option>
											<option value='Account-How do I use my R - One points-Explained how to use R - One points' <?= ($ajio_social_media_data['tagging_evaluator']=='Account-How do I use my R - One points-Explained how to use R - One points')?'selected':'' ?> >Account-How do I use my R - One points-Explained how to use R - One points</option>
											<option value='Account-I have not received my R - One points-Informed about R - One points' <?= ($ajio_social_media_data['tagging_evaluator']=='Account-I have not received my R - One points-Informed about R - One points')?'selected':'' ?> >Account-I have not received my R - One points-Informed about R - One points</option>
											<option value='Website-Complaint related to website-R - One points not visible' <?= ($ajio_social_media_data['tagging_evaluator']=='Website-Complaint related to website-R - One points not visible')?'selected':'' ?> >Website-Complaint related to website-R - One points not visible</option>
											<option value='Account-R- One related-R - One points not credited' <?= ($ajio_social_media_data['tagging_evaluator']=='Account-R- One related-R - One points not credited')?'selected':'' ?> >Account-R- One related-R - One points not credited</option>
											<option value='Delivery-Cancelation Request (Chatbot only)-Exchange to be cancelled (Chatbot only)' <?= ($ajio_social_media_data['tagging_evaluator']=='Delivery-Cancelation Request (Chatbot only)-Exchange to be cancelled (Chatbot only)')?'selected':'' ?> >Delivery-Cancelation Request (Chatbot only)-Exchange to be cancelled (Chatbot only)</option>
											<option value='Delivery-Marked the order as delivered-Requested customer to wait for 2 business days' <?= ($ajio_social_media_data['tagging_evaluator']=='Delivery-Marked the order as delivered-Requested customer to wait for 2 business days')?'selected':'' ?> >Delivery-Marked the order as delivered-Requested customer to wait for 2 business days</option>
											<option value='Return-Non Returnable Product-Damaged Product Received - Fragile' <?= ($ajio_social_media_data['tagging_evaluator']=='Return-Non Returnable Product-Damaged Product Received - Fragile')?'selected':'' ?> >Return-Non Returnable Product-Damaged Product Received - Fragile</option>
											<option value='Return-Non Returnable Product-Damaged Product Received' <?= ($ajio_social_media_data['tagging_evaluator']=='Return-Non Returnable Product-Damaged Product Received')?'selected':'' ?> >Return-Non Returnable Product-Damaged Product Received</option>
											<option value='Refund-Where is my Refund?-Imps Failed - Requested Customer to share NEFT details' <?= ($ajio_social_media_data['tagging_evaluator']=='Refund-Where is my Refund?-Imps Failed - Requested Customer to share NEFT details')?'selected':'' ?> >Refund-Where is my Refund?-Imps Failed - Requested Customer to share NEFT details</option>
											<option value='NEFT(Refund Request)-NEFT Followup-Request for NEFT Transfer' <?= ($ajio_social_media_data['tagging_evaluator']=='NEFT(Refund Request)-NEFT Followup-Request for NEFT Transfer')?'selected':'' ?> >NEFT(Refund Request)-NEFT Followup-Request for NEFT Transfer</option>
											<option value='Delivery-Empty Package Received-Outer Packaging NOT Tampered' <?= ($ajio_social_media_data['tagging_evaluator']=='Delivery-Empty Package Received-Outer Packaging NOT Tampered')?'selected':'' ?> >Delivery-Empty Package Received-Outer Packaging NOT Tampered</option>
											<option value='Delivery-Incomplete Order received - Product(s) missing from shipment-Outer Packaging NOT Tampered' <?= ($ajio_social_media_data['tagging_evaluator']=='Delivery-Incomplete Order received - Product(s) missing from shipment-Outer Packaging NOT Tampered')?'selected':'' ?> >Delivery-Incomplete Order received - Product(s) missing from shipment-Outer Packaging NOT Tampered</option>
											<option value='Delivery-Incomplete Order received - Unit(s) missing from a Set/Pack-Outer Packaging NOT Tampered' <?= ($ajio_social_media_data['tagging_evaluator']=='Delivery-Incomplete Order received - Unit(s) missing from a Set/Pack-Outer Packaging NOT Tampered')?'selected':'' ?> >Delivery-Incomplete Order received - Unit(s) missing from a Set/Pack-Outer Packaging NOT Tampered</option>
											<option value='Return-Reached Warehouse - Refund not Initiated-Excess product handed over' <?= ($ajio_social_media_data['tagging_evaluator']=='Return-Reached Warehouse - Refund not Initiated-Excess product handed over')?'selected':'' ?> >Return-Reached Warehouse - Refund not Initiated-Excess product handed over</option>
											<option value='Delivery-Empty Package Received-Outer Packaging NOT Tampered' <?= ($ajio_social_media_data['tagging_evaluator']=='Delivery-Empty Package Received-Outer Packaging NOT Tampered')?'selected':'' ?> >Delivery-Empty Package Received-Outer Packaging NOT Tampered</option>
											<option value='Delivery-Empty Package Received-Outer Packaging Tampered' <?= ($ajio_social_media_data['tagging_evaluator']=='Delivery-Empty Package Received-Outer Packaging Tampered')?'selected':'' ?> >Delivery-Empty Package Received-Outer Packaging Tampered</option>
											<option value='Delivery-Empty Package Received – RJ(Jewels)-Outer Packaging NOT Tampered' <?= ($ajio_social_media_data['tagging_evaluator']=='Delivery-Empty Package Received – RJ(Jewels)-Outer Packaging NOT Tampered')?'selected':'' ?> >Delivery-Empty Package Received – RJ(Jewels)-Outer Packaging NOT Tampered</option>
											<option value='Delivery-Empty Package Received – RJ(Jewels)-Outer Packaging Tampered' <?= ($ajio_social_media_data['tagging_evaluator']=='Delivery-Empty Package Received – RJ(Jewels)-Outer Packaging Tampered')?'selected':'' ?> >Delivery-Empty Package Received – RJ(Jewels)-Outer Packaging Tampered</option>
											<option value='Delivery-Incomplete Order received - Unit(s) missing from a Set/Pack-Outer Package Tampered' <?= ($ajio_social_media_data['tagging_evaluator']=='Delivery-Incomplete Order received - Unit(s) missing from a Set/Pack-Outer Package Tampered')?'selected':'' ?> >Delivery-Incomplete Order received - Unit(s) missing from a Set/Pack-Outer Package Tampered</option>
											<option value='Delivery-Incomplete Order received - Product(s) missing from shipment-Outer Package Tampered' <?= ($ajio_social_media_data['tagging_evaluator']=='Delivery-Incomplete Order received - Product(s) missing from shipment-Outer Package Tampered')?'selected':'' ?> >Delivery-Incomplete Order received - Product(s) missing from shipment-Outer Package Tampered</option>
											<option value='Delivery-Incomplete Order received - item(s) missing from an outfit/dress-Outer Package Tampered' <?= ($ajio_social_media_data['tagging_evaluator']=='Delivery-Incomplete Order received - item(s) missing from an outfit/dress-Outer Package Tampered')?'selected':'' ?> >Delivery-Incomplete Order received - item(s) missing from an outfit/dress-Outer Package Tampered</option>
											<option value='Feedback-Suggestions about Convenience charge-NA' <?= ($ajio_social_media_data['tagging_evaluator']=='Feedback-Suggestions about Convenience charge-NA')?'selected':'' ?> >Feedback-Suggestions about Convenience charge-NA</option>
											<option value='Price-Whats the price for this order?-Guided Customer on Delivery charge' <?= ($ajio_social_media_data['tagging_evaluator']=='Price-Whats the price for this order?-Guided Customer on Delivery charge')?'selected':'' ?> >Price-Whats the price for this order?-Guided Customer on Delivery charge</option>
											<option value='Price-Whats the price for this order?-Guided Customer on COD charge' <?= ($ajio_social_media_data['tagging_evaluator']=='Price-Whats the price for this order?-Guided Customer on COD charge')?'selected':'' ?> >Price-Whats the price for this order?-Guided Customer on COD charge</option>
											<option value='Price-Whats the price for this order?-Guided Customer on Fulfilment Convenience charge' <?= ($ajio_social_media_data['tagging_evaluator']=='Price-Whats the price for this order?-Guided Customer on Fulfilment Convenience charge')?'selected':'' ?> >Price-Whats the price for this order?-Guided Customer on Fulfilment Convenience charge</option>
											<option value='Goodwill Request-CM insisting Compensation-Convenience Charge' <?= ($ajio_social_media_data['tagging_evaluator']=='Goodwill Request-CM insisting Compensation-Convenience Charge')?'selected':'' ?> >Goodwill Request-CM insisting Compensation-Convenience Charge</option>
											<option value='Other-I want convenience charge-Convinced the customer - No Action Required' <?= ($ajio_social_media_data['tagging_evaluator']=='Other-I want convenience charge-Convinced the customer - No Action Required')?'selected':'' ?> >Other-I want convenience charge-Convinced the customer - No Action Required</option>
											<option value='Ticket-Cx-Ticket Follow up - within TAT-Return related' <?= ($ajio_social_media_data['tagging_evaluator']=='Ticket-Cx-Ticket Follow up - within TAT-Return related')?'selected':'' ?> >Ticket-Cx-Ticket Follow up - within TAT-Return related</option>
											<option value='Ticket-Cx-Ticket Follow up - within TAT-Pickup related' <?= ($ajio_social_media_data['tagging_evaluator']=='Ticket-Cx-Ticket Follow up - within TAT-Pickup related')?'selected':'' ?> >Ticket-Cx-Ticket Follow up - within TAT-Pickup related</option>
											<option value='Ticket-Cx-Ticket Follow up - within TAT-Others' <?= ($ajio_social_media_data['tagging_evaluator']=='Ticket-Cx-Ticket Follow up - within TAT-Others')?'selected':'' ?> >Ticket-Cx-Ticket Follow up - within TAT-Others</option>
											<option value='Ticket-Cx-Ticket Follow up - within TAT-Missing Product related' <?= ($ajio_social_media_data['tagging_evaluator']=='Ticket-Cx-Ticket Follow up - within TAT-Missing Product related')?'selected':'' ?> >Ticket-Cx-Ticket Follow up - within TAT-Missing Product related</option>
											<option value='Ticket-Cx-Ticket Follow up - within TAT-Refund related' <?= ($ajio_social_media_data['tagging_evaluator']=='Ticket-Cx-Ticket Follow up - within TAT-Refund related')?'selected':'' ?> >Ticket-Cx-Ticket Follow up - within TAT-Refund related</option>
											<option value='Ticket-Cx-Ticket Follow up - within TAT-Website related' <?= ($ajio_social_media_data['tagging_evaluator']=='Ticket-Cx-Ticket Follow up - within TAT-Website related')?'selected':'' ?> >Ticket-Cx-Ticket Follow up - within TAT-Website related</option>
											<option value='Ticket-Cx-Ticket Follow up - TAT Breached-Others' <?= ($ajio_social_media_data['tagging_evaluator']=='Ticket-Cx-Ticket Follow up - TAT Breached-Others')?'selected':'' ?> >Ticket-Cx-Ticket Follow up - TAT Breached-Others</option>
											<option value='Ticket-Cx-Ticket Follow up - TAT Breached-Return related' <?= ($ajio_social_media_data['tagging_evaluator']=='Ticket-Cx-Ticket Follow up - TAT Breached-Return related')?'selected':'' ?> >Ticket-Cx-Ticket Follow up - TAT Breached-Return related</option>
											<option value='Ticket-Cx-Ticket Follow up - TAT Breached-Delivery related' <?= ($ajio_social_media_data['tagging_evaluator']=='Ticket-Cx-Ticket Follow up - TAT Breached-Delivery related')?'selected':'' ?> >Ticket-Cx-Ticket Follow up - TAT Breached-Delivery related</option>
											<option value='Ticket-Cx-Ticket Follow up - TAT Breached-Refund related' <?= ($ajio_social_media_data['tagging_evaluator']=='Ticket-Cx-Ticket Follow up - TAT Breached-Refund related')?'selected':'' ?> >Ticket-Cx-Ticket Follow up - TAT Breached-Refund related</option>
											<option value='Ticket-Cx-Ticket Follow up - TAT Breached-Missing Product related' <?= ($ajio_social_media_data['tagging_evaluator']=='Ticket-Cx-Ticket Follow up - TAT Breached-Missing Product related')?'selected':'' ?> >Ticket-Cx-Ticket Follow up - TAT Breached-Missing Product related</option>
											<option value='Ticket-Cx-Ticket Follow up - TAT Breached-Website related' <?= ($ajio_social_media_data['tagging_evaluator']=='Ticket-Cx-Ticket Follow up - TAT Breached-Website related')?'selected':'' ?> >Ticket-Cx-Ticket Follow up - TAT Breached-Website related</option>
											<option value='Ticket-Cx-Ticket Follow up - TAT Breached-Pickup related' <?= ($ajio_social_media_data['tagging_evaluator']=='Ticket-Cx-Ticket Follow up - TAT Breached-Pickup related')?'selected':'' ?> >Ticket-Cx-Ticket Follow up - TAT Breached-Pickup related</option>
											<option value='Ticket-Cx-Ticket Follow up - within TAT-Delivery related' <?= ($ajio_social_media_data['tagging_evaluator']=='Ticket-Cx-Ticket Follow up - within TAT-Delivery related')?'selected':'' ?> >Ticket-Cx-Ticket Follow up - within TAT-Delivery related</option>
											<option value='Callback-Regional Callback-CallBack Needed - Telugu' <?= ($ajio_social_media_data['tagging_evaluator']=='Callback-Regional Callback-CallBack Needed - Telugu')?'selected':'' ?> >Callback-Regional Callback-CallBack Needed - Telugu</option>
											<option value='Callback-Regional Callback-CallBack Needed - Tamil' <?= ($ajio_social_media_data['tagging_evaluator']=='Callback-Regional Callback-CallBack Needed - Tamil')?'selected':'' ?> >Callback-Regional Callback-CallBack Needed - Tamil</option>
											<option value='Callback-Regional Callback-CallBack Needed - Kannada' <?= ($ajio_social_media_data['tagging_evaluator']=='Callback-Regional Callback-CallBack Needed - Kannada')?'selected':'' ?> >Callback-Regional Callback-CallBack Needed - Kannada</option>
											<option value='Account-Suspended Account (Reason for Suspension Required)-Customer wanted Wallet amount transferred' <?= ($ajio_social_media_data['tagging_evaluator']=='Account-Suspended Account (Reason for Suspension Required)-Customer wanted Wallet amount transferred')?'selected':'' ?> >Account-Suspended Account (Reason for Suspension Required)-Customer wanted Wallet amount transferred</option>
											<option value='Account-Suspended Account (Reason for Suspension Required)-Customer wanted to return product' <?= ($ajio_social_media_data['tagging_evaluator']=='Account-Suspended Account (Reason for Suspension Required)-Customer wanted to return product')?'selected':'' ?> >Account-Suspended Account (Reason for Suspension Required)-Customer wanted to return product</option>
											<option value='Account-Suspended Account (Reason for Suspension Required)-Customer wanted to know suspension reason' <?= ($ajio_social_media_data['tagging_evaluator']=='Account-Suspended Account (Reason for Suspension Required)-Customer wanted to know suspension reason')?'selected':'' ?> >Account-Suspended Account (Reason for Suspension Required)-Customer wanted to know suspension reason</option>
											<option value='Callback-Regional Callback-CallBack Needed - Malyalam' <?= ($ajio_social_media_data['tagging_evaluator']=='Callback-Regional Callback-CallBack Needed - Malyalam')?'selected':'' ?> >Callback-Regional Callback-CallBack Needed - Malyalam</option>
											<option value='Order-Excess COD Collected-Informed customer to share image/screenshot' <?= ($ajio_social_media_data['tagging_evaluator']=='Order-Excess COD Collected-Informed customer to share image/screenshot')?'selected':'' ?> >Order-Excess COD Collected-Informed customer to share image/screenshot</option>
											<option value='Marketing-Gift not Received post winning contest-Top Shopper Gift' <?= ($ajio_social_media_data['tagging_evaluator']=='Marketing-Gift not Received post winning contest-Top Shopper Gift')?'selected':'' ?> >Marketing-Gift not Received post winning contest-Top Shopper Gift</option>
											<option value='Marketing-Gift not Received post winning contest-High Value Assured Gift - Instant Reward' <?= ($ajio_social_media_data['tagging_evaluator']=='Marketing-Gift not Received post winning contest-High Value Assured Gift - Instant Reward')?'selected':'' ?> >Marketing-Gift not Received post winning contest-High Value Assured Gift - Instant Reward</option>
											<option value='Marketing-Gift not Received post winning contest-High Value Assured Gift - Reward post return window' <?= ($ajio_social_media_data['tagging_evaluator']=='Marketing-Gift not Received post winning contest-High Value Assured Gift - Reward post return window')?'selected':'' ?> >Marketing-Gift not Received post winning contest-High Value Assured Gift - Reward post return window</option>
											<option value='Delivery-Incomplete Order received - item(s) missing from an outfit/dress-Outer Packaging NOT Tampered' <?= ($ajio_social_media_data['tagging_evaluator']=='Delivery-Incomplete Order received - item(s) missing from an outfit/dress-Outer Packaging NOT Tampered')?'selected':'' ?> >Delivery-Incomplete Order received - item(s) missing from an outfit/dress-Outer Packaging NOT Tampered</option>
											<option value='Return/Exchange-Return On Hold-Informed about Release/Verification TAT' <?= ($ajio_social_media_data['tagging_evaluator']=='Return/Exchange-Return On Hold-Informed about Release/Verification TAT')?'selected':'' ?> >Return/Exchange-Return On Hold-Informed about Release/Verification TAT</option>
											</select>
										
										</td>
									</tr>
									<tr>
										<td style="font-weight:bold; font-size:14px; text-align:right">Earned Score:</td>
										<td><input type="text" readonly id="earnedScore" name="data[earned_score]" class="form-control form_ajio" style="font-weight:bold" value="<?php echo $ajio_social_media_data['earned_score'] ?>"></td>
										<td style="font-weight:bold; font-size:14px; text-align:right">Possible<br>Score:</td>
										<td><input type="text" readonly id="possibleScore" name="data[possible_score]" class="form-control form_ajio" style="font-weight:bold" value="<?php echo $ajio_social_media_data['possible_score'] ?>"></td>
										<td style="font-weight:bold; font-size:14px; text-align:right">Overall <br>Score:</td>
										<td><input type="text" readonly id="overallScore" name="data[overall_score]" class="form-control form_ajio ajio_social_Fatal" style="font-weight:bold" value="<?php echo $ajio_social_media_data['overall_score'] ?>"></td>
									</tr>
									<tr style="font-weight:bold">
										<td><input type="hidden" class="form-control form_ajio" id="prefatal" name="data[pre_fatal_score]" value="<?php echo $ajio_social_media_data['pre_fatal_score'] ?>"></td>
										<td><input type="hidden" class="form-control form_ajio" id="fatalcount" name="data[fatal_count]" value="<?php echo $ajio_social_media_data['fatal_count'] ?>"></td>
									</tr>
									<tr style="background-color:#85C1E9; font-weight:bold">
										<td>Parameter</td>
										<td>Sub Parameter</td>
										<td>Weightage</td>
										<td>Defect</td>
										<td>L1 Reason</td>
										<td>L2 Reason</td>
									</tr>
									<tr>
										<td rowspan=5 style="background-color:#85C1E9; font-weight:bold">Customer Service Essentials</td>
										<td style="color:red">Responded to  customer’s concern(s) correctly.</td>
										<td>15</td>
										<td>
											<select class="form-control form_ajio ajio fatal ajioAF1" id="ajioAF1_social" name="data[customers_concern]" required>
												<option ajio_val=15 ajio_max=15 <?php echo $ajio_social_media_data['customers_concern'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ajio_val=0 ajio_max=15 <?php echo $ajio_social_media_data['customers_concern'] == "Autofail"?"selected":"";?> value="Autofail">Autofail</option>
											</select>
										</td>
										
										<td>
											<select class="form-control form_ajio" id="customers_concern_l1" name="data[l1_reason1]" required>
												<?php 
												if($ajio_social_media_data['l1_reason1']!=''){
													?>
													<option value="<?php echo $ajio_social_media_data['l1_reason1'] ?>"><?php echo $ajio_social_media_data['l1_reason1'] ?></option>
													<?php
												}
												?>
												<option  <?php echo $ajio_social_media_data['l1_reason1'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
												
											</select>
										</td>
										<td><textarea class="form-control form_ajio" name="data[cmt1]"><?php echo $ajio_social_media_data['cmt1'] ?></textarea></td>
									</tr>
									<tr>
										<td style="color:red">Addressed/redirected customer’s issue for resolution wherever applicable</td>
										<td>10</td>
										<td>
											<select class="form-control form_ajio ajio fatal ajioAF2" id="ajioAF2_social" name="data[customers_issue]" required>
												<option ajio_val=10 ajio_max=10 <?php echo $ajio_social_media_data['customers_issue'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ajio_val=0 ajio_max=10 <?php echo $ajio_social_media_data['customers_issue'] == "Autofail"?"selected":"";?> value="Autofail">Autofail</option>
											</select>
										</td>
										
										<td>
											<select class="form-control form_ajio" id="customers_issue_l2" name="data[l1_reason2]" required>
												<?php 
												if($ajio_social_media_data['l1_reason2']!=''){
													?>
													<option value="<?php echo $ajio_social_media_data['l1_reason2'] ?>"><?php echo $ajio_social_media_data['l1_reason2'] ?></option>
													<?php
												}
												?>
												<option  <?php echo $ajio_social_media_data['l1_reason2'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
												
											</select>
										</td>
										<td><textarea class="form-control form_ajio" name="data[cmt2]"><?php echo $ajio_social_media_data['cmt2'] ?></textarea></td>
									</tr>
									<tr>
										<td style="color:red">Refered to previous interactions to understand the issue.</td>
										<td>10</td>
										<td>
											<select class="form-control form_ajio ajio fatal ajioAF3" id="ajioAF3_social" name="data[previous_interaction]" required>
												<option ajio_val=10 ajio_max=10 <?php echo $ajio_social_media_data['previous_interaction'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ajio_val=0 ajio_max=10 <?php echo $ajio_social_media_data['previous_interaction'] == "Autofail"?"selected":"";?> value="Autofail">Autofail</option>
											</select>
										</td>
										
										<td>
											<select class="form-control form_ajio" id="previous_interaction_l3" name="data[l1_reason3]" required>
												<?php 
												if($ajio_social_media_data['l1_reason3']!=''){
													?>
													<option value="<?php echo $ajio_social_media_data['l1_reason3'] ?>"><?php echo $ajio_social_media_data['l1_reason3'] ?></option>
													<?php
												}
												?>
												<option  <?php echo $ajio_social_media_data['l1_reason3'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
												
											</select>
										</td>
										<td><textarea class="form-control form_ajio" name="data[cmt3]"><?php echo $ajio_social_media_data['cmt3'] ?></textarea></td>
									</tr>
									<tr>
										<td style="color:red">Interaction was documented as per guidelines.</td>
										<td>10</td>
										<td>
											<select class="form-control form_ajio ajio fatal ajioAF4" id="ajioAF4_social" name="data[documented_guidelines]" required>
												<option ajio_val=10 ajio_max=10 <?php echo $ajio_social_media_data['documented_guidelines'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ajio_val=0 ajio_max=10 <?php echo $ajio_social_media_data['documented_guidelines'] == "Autofail"?"selected":"";?> value="Autofail">Autofail</option>
											</select>
										</td>
										
										<td>
											<select class="form-control form_ajio" id="documented_guidelines_l4" name="data[l1_reason4]" required>
												<?php 
												if($ajio_social_media_data['l1_reason4']!=''){
													?>
													<option value="<?php echo $ajio_social_media_data['l1_reason4'] ?>"><?php echo $ajio_social_media_data['l1_reason4'] ?></option>
													<?php
												}
												?>
												<option  <?php echo $ajio_social_media_data['l1_reason4'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
												
											</select>
										</td>
										<td><textarea class="form-control form_ajio" name="data[cmt4]"><?php echo $ajio_social_media_data['cmt4'] ?></textarea></td>
									</tr>
									<tr>
										<td>Validated Customer information.</td>
										<td>5</td>
										<td>
											<select class="form-control form_ajio ajio" id="customer_information" name="data[customer_information]" required>
												<option ajio_val=5 ajio_max=5 <?php echo $ajio_social_media_data['customer_information'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ajio_val=0 ajio_max=5 <?php echo $ajio_social_media_data['customer_information'] == "No"?"selected":"";?> value="No">No</option>
											</select>
										</td>
										
										<td>
											<select class="form-control form_ajio" id="customer_information_l5" name="data[l1_reason5]" required>
												<?php 
												if($ajio_social_media_data['l1_reason5']!=''){
													?>
													<option value="<?php echo $ajio_social_media_data['l1_reason5'] ?>"><?php echo $ajio_social_media_data['l1_reason5'] ?></option>
													<?php
												}
												?>
												<option  <?php echo $ajio_social_media_data['l1_reason5'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
												
											</select>
										</td>
										<td><textarea class="form-control form_ajio" name="data[cmt5]"><?php echo $ajio_social_media_data['cmt5'] ?></textarea></td>
									</tr>
									<tr>
										<td rowspan=3 style="background-color:#85C1E9; font-weight:bold">Social Media Handling Skills</td>
										<td>When necessary, ask the customer to move to a private channel (DM or FB Message).</td>
										<td>5</td>
										<td>
											<select class="form-control form_ajio ajio" id="private_channel" name="data[private_channel]" required>
												<option ajio_val=5 ajio_max=5 <?php echo $ajio_social_media_data['private_channel'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ajio_val=0 ajio_max=5 <?php echo $ajio_social_media_data['private_channel'] == "No"?"selected":"";?> value="No">No</option>
											</select>
										</td>
										
										<td>
											<select class="form-control form_ajio" id="private_channel_l6" name="data[l1_reason6]" required>
												<?php 
												if($ajio_social_media_data['l1_reason6']!=''){
													?>
													<option value="<?php echo $ajio_social_media_data['l1_reason6'] ?>"><?php echo $ajio_social_media_data['l1_reason6'] ?></option>
													<?php
												}
												?>
												<option  <?php echo $ajio_social_media_data['l1_reason6'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
												
											</select>
										</td>
										<td><textarea class="form-control form_ajio" name="data[cmt6]"><?php echo $ajio_social_media_data['cmt6'] ?></textarea></td>
									</tr>
									<tr>
										<td>Clarify the issue by asking probing questions. Made Outbound calls wherever required.</td>
										<td>15</td>
										<td>
											<select class="form-control form_ajio ajio" id="probing_questions" name="data[probing_questions]" required>
												<option ajio_val=15 ajio_max=15 <?php echo $ajio_social_media_data['probing_questions'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ajio_val=0 ajio_max=15 <?php echo $ajio_social_media_data['probing_questions'] == "No"?"selected":"";?> value="No">No</option>
											</select>
										</td>
										
										<td>
											<select class="form-control form_ajio" id="probing_questions_l7" name="data[l1_reason7]" required>
												<?php 
												if($ajio_social_media_data['l1_reason7']!=''){
													?>
													<option value="<?php echo $ajio_social_media_data['l1_reason7'] ?>"><?php echo $ajio_social_media_data['l1_reason7'] ?></option>
													<?php
												}
												?>
												<option  <?php echo $ajio_social_media_data['l1_reason7'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
												
											</select>
										</td>
										<td><textarea class="form-control form_ajio" name="data[cmt7]"><?php echo $ajio_social_media_data['cmt7'] ?></textarea></td>
									</tr>
									<tr>
										<td>Include hyperlinks, relevant hashtags etc that push helpful content.</td>
										<td>5</td>
										<td>
											<select class="form-control form_ajio ajio" id="relevant_hashtags" name="data[relevant_hashtags]" required>
												<option ajio_val=5 ajio_max=5 <?php echo $ajio_social_media_data['relevant_hashtags'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ajio_val=0 ajio_max=5 <?php echo $ajio_social_media_data['relevant_hashtags'] == "No"?"selected":"";?> value="No">No</option>
											</select>
										</td>
										
										<td>
											<select class="form-control form_ajio" id="relevant_hashtags_l8" name="data[l1_reason8]" required>
												<?php 
												if($ajio_social_media_data['l1_reason8']!=''){
													?>
													<option value="<?php echo $ajio_social_media_data['l1_reason8'] ?>"><?php echo $ajio_social_media_data['l1_reason8'] ?></option>
													<?php
												}
												?>
												<option  <?php echo $ajio_social_media_data['l1_reason8'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
												
											</select>
										</td>
										<td><textarea class="form-control form_ajio" name="data[cmt8]"><?php echo $ajio_social_media_data['cmt8'] ?></textarea></td>
									</tr>
									<tr>
										<td rowspan=3 style="background-color:#85C1E9; font-weight:bold">Social Media Writing Skills</td>
										<td>Use AJIO voice and a friendly tone to build rapport and brand confidence.</td>
										<td>10</td>
										<td>
											<select class="form-control form_ajio ajio" id="friendly_tone" name="data[friendly_tone]" required>
												<option ajio_val=10 ajio_max=10 <?php echo $ajio_social_media_data['friendly_tone'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ajio_val=0 ajio_max=10 <?php echo $ajio_social_media_data['friendly_tone'] == "No"?"selected":"";?> value="No">No</option>
											</select>
										</td>
										
										<td>
											<select class="form-control form_ajio" id="friendly_tone_l9" name="data[l1_reason9]" required>
												<?php 
												if($ajio_social_media_data['l1_reason9']!=''){
													?>
													<option value="<?php echo $ajio_social_media_data['l1_reason9'] ?>"><?php echo $ajio_social_media_data['l1_reason9'] ?></option>
													<?php
												}
												?>
												<option  <?php echo $ajio_social_media_data['l1_reason9'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
												
											</select>
										</td>
										<td><textarea class="form-control form_ajio" name="data[cmt9]"><?php echo $ajio_social_media_data['cmt9'] ?></textarea></td>
									</tr>
									<tr>
										<td>Avoid spelling, grammar, or punctuation errors that cause confusion.</td>
										<td>10</td>
										<td>
											<select class="form-control form_ajio ajio" id="avoid_punctuation" name="data[avoid_punctuation]" required>
												<option ajio_val=10 ajio_max=10 <?php echo $ajio_social_media_data['avoid_punctuation'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ajio_val=0 ajio_max=10 <?php echo $ajio_social_media_data['avoid_punctuation'] == "No"?"selected":"";?> value="No">No</option>
											</select>
										</td>
										
										<td>
											<select class="form-control form_ajio" id="avoid_punctuation_l10" name="data[l1_reason10]" required>
												<?php 
												if($ajio_social_media_data['l1_reason10']!=''){
													?>
													<option value="<?php echo $ajio_social_media_data['l1_reason10'] ?>"><?php echo $ajio_social_media_data['l1_reason10'] ?></option>
													<?php
												}
												?>
												<option  <?php echo $ajio_social_media_data['l1_reason10'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
												
											</select>
										</td>
										<td><textarea class="form-control form_ajio" name="data[cmt10]"><?php echo $ajio_social_media_data['cmt10'] ?></textarea></td>
									</tr>
									<tr>
										<td>Make customers feel heard and appreciated.</td>
										<td>5</td>
										<td>
											<select class="form-control form_ajio ajio" id="feel_heard" name="data[feel_heard]" required>
												<option ajio_val=5 ajio_max=5 <?php echo $ajio_social_media_data['feel_heard'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ajio_val=0 ajio_max=5 <?php echo $ajio_social_media_data['feel_heard'] == "No"?"selected":"";?> value="No">No</option>
											</select>
										</td>
										
										<td>
											<select class="form-control form_ajio" id="feel_heard_l11" name="data[l1_reason11]" required>
												<?php 
												if($ajio_social_media_data['l1_reason11']!=''){
													?>
													<option value="<?php echo $ajio_social_media_data['l1_reason11'] ?>"><?php echo $ajio_social_media_data['l1_reason11'] ?></option>
													<?php
												}
												?>
												<option  <?php echo $ajio_social_media_data['l1_reason11'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
												
											</select>
										</td>
										<td><textarea class="form-control form_ajio" name="data[cmt11]"><?php echo $ajio_social_media_data['cmt11'] ?></textarea></td>
									</tr>
									<tr>
										<td rowspan=1 style="background-color:#85C1E9; font-weight:bold">ZTP</td>
										<td style="color:red">As per AJIO ZTP guidelines</td>
										<td></td>
										<td>
											<select class="form-control form_ajio ajio fatal ajioAF5" id="ajioAF5_social" name="data[ztp_guidelines]" required>
												<option ajio_val=0 ajio_max=0 <?php echo $ajio_social_media_data['ztp_guidelines'] == "No"?"selected":"";?> value="No">No</option>
												<option ajio_val=0 ajio_max=0 <?php echo $ajio_social_media_data['ztp_guidelines'] == "Autofail"?"selected":"";?> value="Autofail">Autofail</option>
											</select>
										</td>
										
										<td>
											<select class="form-control form_ajio" id="ztp_guidelines_l12" name="data[l1_reason12]" required>
												<?php 
												if($ajio_social_media_data['l1_reason12']!=''){
													?>
													<option value="<?php echo $ajio_social_media_data['l1_reason12'] ?>"><?php echo $ajio_social_media_data['l1_reason12'] ?></option>
													<?php
												}
												?>
												<option  <?php echo $ajio_social_media_data['l1_reason12'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
												
											</select>
										</td>
										<td><textarea class="form-control form_ajio" name="data[cmt12]"><?php echo $ajio_social_media_data['cmt12'] ?></textarea></td>
									</tr>
									
									<tr>
										<td>Call Summary:</td>
										<td colspan=2><textarea class="form-control form_ajio" name="data[call_summary]"><?php echo $ajio_social_media_data['call_summary'] ?></textarea></td>
										<td>Feedback:</td>
										<td colspan=2><textarea class="form-control form_ajio" name="data[feedback]"><?php echo $ajio_social_media_data['feedback'] ?></textarea></td>
									</tr>
									<tr>
										<td colspan=2>Upload Files [m4a,mp4,mp3,wav]</td>
											<?php if ($ajio_social_media_id == 0) { ?>
												<td colspan=6>
													<input type="file" name="attach_file[]" id="attach_file" accept=".m4a,.mp4,.mp3,.wav,audio/*" />
												</td>
												<?php } else {
												if ($ajio_social_media_data['attach_file'] != '') { ?>
													<td colspan=6>
														<input type="file" multiple class="form-control form_ajio"  id="attach_file" name="attach_file[]" accept=".m4a,.mp4,.mp3,.wav,audio/*"> 
														<?php $attach_file = explode(",", $ajio_social_media_data['attach_file']);
														foreach ($attach_file as $mp) { ?>
															<audio controls='' style="background-color:#607F93">
																<source src="<?php echo base_url(); ?>qa_files/ajio_social_media/<?php echo $mp; ?>" type="audio/ogg">
																<source src="<?php echo base_url(); ?>qa_files/ajio_social_media/<?php echo $mp; ?>" type="audio/mpeg">
															</audio> </br>
														<?php } ?>
													</td>
											<?php } else {
													echo '<td colspan=6>
													<input type="file" multiple class="form-control form_ajio" id="attach_file" name="attach_file[]" accept=".m4a,.mp4,.mp3,.wav,audio/*">
													<b>No Files</b></td>';
												}
											} ?>
										</tr>
									
									<?php if($ajio_social_media_id!=0){ ?>
										<tr><td colspan=2 style="font-size:16px; font-weight:bold">Agent Feedback Acceptance:</td><td colspan=4><?php echo $ajio_social_media_data['agnt_fd_acpt'] ?></td></tr>
										<tr><td colspan=2 style="font-size:16px; font-weight:bold">Agent Review:</td><td colspan=4><?php echo $ajio_social_media_data['agent_rvw_note'] ?></td></tr>
										<tr><td colspan=2 style="font-size:16px; font-weight:bold">Management Review:</td><td colspan=4><?php echo $ajio_social_media_data['mgnt_rvw_note'] ?></td></tr>
										<tr><td colspan=2 style="font-size:16px; font-weight:bold">Client Review:</td><td colspan=4><?php echo $ajio_social_media_data['client_rvw_note'] ?></td></tr>
										
										<tr><td colspan=2  style="font-size:16px">Your Review</td><td colspan=4><textarea class="form-control form_ajio1" style="width:100%" id="note" name="note"  ></textarea></td></tr>
									<?php } ?>
									
									<?php 
									if($ajio_social_media_id==0){
										if(is_access_qa_module()==true || is_access_qa_operations_module()==true){ ?>
											<tr><td colspan=6><button class="btn btn-success waves-effect" type="submit" id="qaformsubmit" style="width:500px">SAVE</button></td></tr>
									<?php 
										} 
									}else{ 
										if(is_access_qa_module()==true || is_access_qa_operations_module()==true){
											if(is_available_qa_feedback($ajio_social_media_data['entry_date'],72) == true){ ?>
												<tr><td colspan="6"><button class="btn btn-success waves-effect" type="submit" id='qaformsubmit' name='btnSave' value="SAVE" style="width:500px">SAVE</button></td></tr>
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
