
<style>
@import url('https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,500;1,900&display=swap');

body {
    font-family: 'Roboto', sans-serif;
}
.table > tbody > tr > td{
	text-align: center;
	font-size:13px;
}

.select2-selection.select2-selection--single{
    height: 40px!important;
    border-radius: 1px!important;
}
.select2-selection .select2-selection__arrow{
    height: 40px!important;
}
.select2-selection.select2-selection--single .select2-selection__rendered {
  line-height: 40px !important;
}
.select2-container{
	width: 100%!important;
}
.form-control{
	border-radius:1px!important;
}

#theader{
	font-size:20px;
	font-weight:bold;
}

.eml{
	font-weight:bold;
	background-color:#FAD7A0;
}

.eml1{
	font-weight:bold;
}
.heading td{
	
    padding: 10px!important;
    font-family: 'Roboto'!important;
    font-weight: 600!important;
    letter-spacing: 1px;
}
.btn-save{width: 200px!important;
    padding: 10px!important;
    border-radius: 1px!important;
    font-size: 13px!important;
	color:#fff;
	background:#5e62ecd4;
}
.btn-save:hover ,.btn-save:focus{
    
	color:#fff;
    box-shadow: 0 0 0 2px #fff, 0 0 0 4px #5e62ecd4;
}
.ui-datepicker .ui-datepicker-buttonpane button.ui-datepicker-current {
	 float: left;
	 display: none;
	}
</style>

<?php if($ajio_id!=0){
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
										<td colspan="6" id="theader" style="font-size:40px">AJIO [Voice] V2</td>
										<input type="hidden" name="audit_start_time" value="<?php echo CurrMySqlDate(); ?>">
									</tr>
									<?php
										if($ajio_id==0){
											$auditorName = get_username();
											$auditDate = CurrDateMDY();
											$clDate_val='';
										}else{
											if($ajio_inb_v2['entry_by']!=''){
												$auditorName = $ajio_inb_v2['auditor_name'];
											}else{
												$auditorName = $ajio_inb_v2['client_name'];
											}
											$auditDate = mysql2mmddyy($ajio_inb_v2['audit_date']);
											$clDate_val = mysqlDt2mmddyy($ajio_inb_v2['call_date']);
										}
									?>
									<tr>
										<td>Auditor Name:</td>
										<td><input type="text" class="form-control" value="<?php echo $auditorName; ?>" disabled></td>
										<td>Audit Date:</td>
										<td><input type="text" class="form-control" value="<?php echo $auditDate; ?>" disabled></td>
										<td style="width:200px">Call Date/Time:</td>
										<td><input type="text" class="form-control" id="call_date_time" name="call_date" value="<?php echo $clDate_val; ?>" required></td>
									</tr>
									<tr>
										<td>Champ/Agent Name:</td>
										<td>
											<select class="form-control agentName" id="agent_id" name="data[agent_id]" required >
												<option value="<?php echo $ajio_inb_v2['agent_id'] ?>"><?php echo $ajio_inb_v2['fname']." ".$ajio_inb_v2['lname'] ?></option>
												<option value="">-Select-</option>
												<?php foreach($agentName as $row):  ?>
													<option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
												<?php endforeach; ?>
											</select>
										</td>
										<td>Fusion/BP ID:</td>
										<td><input type="text" class="form-control" id="fusion_id" value="<?php echo $ajio_inb_v2['fusion_id'] ?>" readonly ></td>
										<td>L1 Supervisor:</td>
										<td>
											<input type="text" class="form-control" id="tl_names"  value="<?php echo $ajio_inb_v2['tl_name'] ?>" readonly>
												<input type="hidden" class="form-control" id="tl_id" name="data[tl_id]" value="<?php echo $ajio_inb_v2['tl_id'] ?>" required>
										</td>
									</tr>
									<tr>
										<td>Partner:</td>
										<td><input type="text" class="form-control" name="data[partner]" value="<?php echo $ajio_inb_v2['partner'] ?>" required ></td>
										<td>Call Duration:</td>
										<td><input type="text" class="form-control" onkeydown="return false;" id="call_duration" name="data[call_duration]" value="<?php echo $ajio_inb_v2['call_duration'] ?>" required ></td>
								
										<td>Ticket Type:</td>
										<td>
											<select class="form-control" id="ticket_type" name="data[ticket_type]" required>
												<option value="">-Select-</option>
												<option value="Complaint" <?= ($ajio_inb_v2['ticket_type']=="Complaint")?"selected":"" ?>>Complaint</option>
												<option value="Query" <?= ($ajio_inb_v2['ticket_type']=="Query")?"selected":"" ?>>Query</option>
												<option value="Proactive SR" <?= ($ajio_inb_v2['ticket_type']=="Proactive SR")?"selected":"" ?>>Proactive SR</option>
											</select>
										</td>
									</tr>
									<tr>
										<td>Auditor’s BP ID:</td>
										<td><input type="text" class="form-control" name="data[auditors_bp_id]" value="<?php echo $ajio_inb_v2['auditors_bp_id'] ?>" required ></td>
										<td>Interaction ID:</td>
										<td><input type="text" class="form-control" name="data[interaction_id]" value="<?php echo $ajio_inb_v2['interaction_id'] ?>" required ></td>
										<td>Order ID:</td>
										<td><input type="text" class="form-control" name="data[order_id]" value="<?php echo $ajio_inb_v2['order_id'] ?>" required ></td>
									</tr>
									<tr>
										<td>Ticket ID:</td>
										<td><input type="text" class="form-control" name="data[ticket_id]" value="<?php echo $ajio_inb_v2['ticket_id'] ?>" required ></td>
										<td>Call Synopsis:</td>
										<td><input type="text" class="form-control" name="data[call_synopsis_header]" value="<?php echo $ajio_inb_v2['call_synopsis_header'] ?>" required ></td>
										<td>Language:</td>
										<td><input type="text" class="form-control" name="data[language]" value="<?php echo $ajio_inb_v2['language'] ?>" required ></td>
									</tr>
									<tr>
										<td>Audit Type:</td>
										<td>
											<select class="form-control" id="audit_type" name="data[audit_type]" required>
												<option value="<?php echo $ajio_inb_v2['audit_type'] ?>"><?php echo $ajio_inb_v2['audit_type'] ?></option>
												<option value="">-Select-</option>
												<option value="CQ Audit">CQ Audit</option>
												<option value="BQ Audit">BQ Audit</option>
												<option value="Calibration">Calibration</option>
												<option value="Pre-Certificate Mock Call">Pre-Certificate Mock Call</option>
												<option value="Certification Audit">Certification Audit</option>
												<option value="Operation Audit">Operation Audit</option>
												<option value="Trainer Audit">Trainer Audit</option>
												<option value="Hygiene Audit">Hygiene Audit</option>
												<option value="WOW Call">WOW Call</option>
												<option value="QA Supervisor Audit">QA Supervisor Audit</option>
											</select>
										</td>
										<td class="auType">Auditor Type</td>
										<td class="auType">
											<select class="form-control" id="auditor_type" name="data[auditor_type]">
											<option value="<?php echo $ajio_inb_v2['auditor_type'] ?>"><?php echo $ajio_inb_v2['auditor_type'] ?></option>
												<option value="">-Select-</option>
												<option value="Master">Master</option>
												<option value="Regular">Regular</option>
											</select>
										</td>
										<td>VOC:</td>
										<td>
											<select class="form-control" id="voc" name="data[voc]" required>
												<option value="<?php echo $ajio_inb_v2['voc'] ?>"><?php echo $ajio_inb_v2['voc'] ?></option>
												<option value="">-Select-</option>
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
									
									<!-- <tr>
										<td class="cust_voc">Customer voc:</td>
										<td class="cust_voc"><input type="text" class="form-control" id="voice_cust" name="data[voice_cust]" value="<?php echo $ajio_inb_v2['voice_cust'] ?>"  ></td>
										<td class="utiliza">KM Utilization:</td>
										<td class="utiliza">
											<select class="form-control" id="utilization" name="data[utilization]" >
												<option value="<?php echo $ajio_inb_v2['utilization'] ?>"><?php echo $ajio_inb_v2['utilization'] ?></option>
												<option value="">-Select-</option>
												<option value="Yes">Yes</option>
												<option value="No">No</option>
											</select>
										</td>
										<td class="arti">Article</td>
										<td class="arti"><input type="text" class="form-control" id="article" name="data[article]" value="<?php echo $ajio_inb_v2['article'] ?>"  ></td>
									</tr>
									<tr>
										<td class="fatal_nonfatal">Fatal/Non-Fatal:</td>
										<td class="fatal_nonfatal">
											<select class="form-control" id="fatal_non_fatal" name="data[fatal_nonfatal]" >
												<option value="<?php echo $ajio_inb_v2['fatal_nonfatal'] ?>"><?php echo $ajio_inb_v2['fatal_nonfatal'] ?></option>
												<option value="">-Select-</option>
												<option value="Fatal">Fatal</option>
												<option value="Non-Fatal">Non-Fatal</option>
											</select>
										</td>				
										<td class="acpt">Detractor ACPT:</td>
										<td class="acpt">
											<select class="form-control" id="detractor_acpt" name="data[detractor_acpt]" >
												<option value="<?php echo $ajio_inb_v2['detractor_acpt'] ?>"><?php echo $ajio_inb_v2['detractor_acpt'] ?></option>
												<option value="">-Select-</option>
												<option value="Agent">Agent</option>
												<option value="Process">Process</option>
												<option value="Customer">Customer</option>
												<option value="Technology">Technology</option>
											</select>
										</td>
										<td class="detrac_l1">Detractor L1:</td>
										<td class="detrac_l1"><input type="text" class="form-control" id="detractor_l1" name="data[detractor_l1]" value="<?php echo $ajio_inb_v2['detractor_l1'] ?>"  ></td>
									</tr>
									<tr>
										<td class="detrac_l2">Detractor L2:</td>
										<td class="detrac_l2"><input type="text" class="form-control" id="detractor_l2" name="data[detractor_l2]" value="<?php echo $ajio_inb_v2['detractor_l2'] ?>"  ></td>
										<td class="tcd">TCD</td>
										<td class="tcd"><input type="text" class="form-control" id="tcd" name="data[tcd]" value="<?php echo $ajio_inb_v2['tcd'] ?>"  ></td>
										<td class="modulation">Voice modulation:</td>
										<td class="modulation">
											<select class="form-control" id="voice_modulation" id="voice_modulation" name="data[voice_modulation]" >
												<option value="<?php echo $ajio_inb_v2['voice_modulation'] ?>"><?php echo $ajio_inb_v2['voice_modulation'] ?></option>
												<option value="">-Select-</option>
												<option value="Yes">Yes</option>
												<option value="No">No</option>
											</select>
										</td>
									</tr>
									<tr>
										<td class="assurance">Assurance given:</td>
										<td class="assurance">
											<select class="form-control" id="assurance_given" name="data[assurance_given]" >
												<option value="<?php echo $ajio_inb_v2['assurance_given'] ?>"><?php echo $ajio_inb_v2['assurance_given'] ?></option>
												<option value="">-Select-</option>
												<option value="Yes">Yes</option>
												<option value="No">No</option>
											</select>
										</td>
									</tr> -->
									
									<tr>
									<td>Tagging by Evaluator:<span style="font-size:24px;color:red">*</span></td>
										<td colspan="6">
											<select class="form-control agentName" id="tagging_evaluator" name="data[tagging_evaluator]" required>
												<?php 
												if($ajio_inb_v2['tagging_evaluator']!=''){
													?>
													<option value="<?php echo $ajio_inb_v2['tagging_evaluator'] ?>"><?php echo $ajio_inb_v2['tagging_evaluator'] ?></option>
													<?php
												}else{
													?>
													<option value="">-Select-</option>
													<?php
												}
												?>
												
												<option value="Delivery-Fake Attempt-N/A">Delivery-Fake Attempt-N/A</option>
												<option value="Account-Store Credit Debited Order Not Processed-N/A">Account-Store Credit Debited Order Not Processed-N/A</option>
												<option value="Account-Store Credit Discrepancy-Others">Account-Store Credit Discrepancy-Others</option>
												<option value="Account-Customer information Leak-N/A">Account-Customer information Leak-N/A</option>
												<option value="Callback-Others-N/A">Callback-Others-N/A</option>
												<option value="Delivery-Snatch Case-N/A">Delivery-Snatch Case-N/A</option>
												<option value="Delivery-Order not dispatched from Warehouse-N/A">Delivery-Order not dispatched from Warehouse-N/A</option>
												<option value="Delivery-Delayed Delivery-N/A">Delivery-Delayed Delivery-N/A</option>
												<option value="Account-Stop sms/email (promotional)-N/A">Account-Stop sms/email (promotional)-N/A</option>
												<option value="Delivery-Complaint against Delivery Person-Courier person asking Extra Money">Delivery-Complaint against Delivery Person-Courier person asking Extra Money</option>
												<option value="Callback-Supervisor Callback-N/A">Callback-Supervisor Callback-N/A</option>
												<option value="Account-Account Deactivation-N/A">Account-Account Deactivation-N/A</option>
												<option value="Delivery-RTO Refund Delayed-N/A">Delivery-RTO Refund Delayed-N/A</option>
												<option value="Online Refund-Amount Debited Order not processed-N/A">Online Refund-Amount Debited Order not processed-N/A</option>
												<option value="Delivery-Special Instructions for Contact Details Update-N/A">Delivery-Special Instructions for Contact Details Update-N/A</option>
												<option value="Online Refund-Refund not done against Reference No.-N/A">Online Refund-Refund not done against Reference No.-N/A</option>
												<option value="Delivery-Complaint against Delivery Person-Courier person took Extra Money">Delivery-Complaint against Delivery Person-Courier person took Extra Money</option>
												<option value="Marketing-Promotion Related-N/A">Marketing-Promotion Related-N/A</option>
												<option value="Return-Picked up - Did not reach Warehouse-N/A">Return-Picked up - Did not reach Warehouse-N/A</option>
												<option value="Return-Self Ship Courier Charges not credited-N/A">Return-Self Ship Courier Charges not credited-N/A</option>
												<option value="Goodwill Request-CM insisting Compensation-N/A">Goodwill Request-CM insisting Compensation-N/A</option>
												<option value="Return-Reached Warehouse - Refund not Initiated-N/A">Return-Reached Warehouse - Refund not Initiated-N/A</option>
												<option value="Online Refund-Refund Reference No. Needed-CC/DC/NB">Online Refund-Refund Reference No. Needed-CC/DC/NB</option>
												<option value="Delivery-Complaint against Delivery Person-Rude Behaviour">Delivery-Complaint against Delivery Person-Rude Behaviour</option>
												<option value="Return-Additional Self Ship Courier Charges Required-N/A">Return-Additional Self Ship Courier Charges Required-N/A</option>
												<option value="Return-Pickup delayed-N/A">Return-Pickup delayed-N/A</option>
												<option value="Online Refund-Refund Reference No. Needed-IMPS Transfer">Online Refund-Refund Reference No. Needed-IMPS Transfer</option>
												<option value="Return-Customer claiming product picked up-Customer did not have acknowledgement copy">Return-Customer claiming product picked up-Customer did not have acknowledgement copy</option>
												<option value="NEFT(Refund Request)-NEFT Transfer-N/A">NEFT(Refund Request)-NEFT Transfer-N/A</option>
												<option value="Return-Customer claiming product picked up-Shared acknowledgement copy">Return-Customer claiming product picked up-Shared acknowledgement copy</option>
												<option value="Marketing-Gift not Received post winning contest-N/A">Marketing-Gift not Received post winning contest-N/A</option>
												<option value="Return-Non Returnable Product-Wrong Product delivered">Return-Non Returnable Product-Wrong Product delivered</option>
												<option value="Return-Self Shipped no Update From WH-N/A">Return-Self Shipped no Update From WH-N/A</option>
												<option value="Return-Damaged Product-Damaged post usage">Return-Damaged Product-Damaged post usage</option>
												<option value="Return-Regular Courier Charges not credited-N/A">Return-Regular Courier Charges not credited-N/A</option>
												<option value="Return-Complaint against Delivery Person-Rude Behaviour">Return-Complaint against Delivery Person-Rude Behaviour</option>
												<option value="Return-Special Instructions for Contact Details Update-N/A">Return-Special Instructions for Contact Details Update-N/A</option>
												<option value="Return-Complaint against Delivery Person-Excess product handed over">Return-Complaint against Delivery Person-Excess product handed over</option>
												<option value="Return-Complaint against Delivery Person-Didn’t have pickup receipt">Return-Complaint against Delivery Person-Didn’t have pickup receipt</option>
												<option value="Return-Complaint against Delivery Person-Didn’t know which product to pickup">Return-Complaint against Delivery Person-Didn’t know which product to pickup</option>
												<option value="Return-Complaint against Delivery Person-Courier person refused to pick a product">Return-Complaint against Delivery Person-Courier person refused to pick a product</option>
												<option value="Return-Non Ajio Product Returned-Product Picked Up">Return-Non Ajio Product Returned-Product Picked Up</option>
												<option value="Return-Pickup - Wrong Status Update-Product not picked up - Exchange Related">Return-Pickup - Wrong Status Update-Product not picked up - Exchange Related</option>
												<option value="Return-Fake Attempt-N/A">Return-Fake Attempt-N/A</option>
												<option value="Website-Complaint relating to Website-No confirmation received on website/email/sms">Website-Complaint relating to Website-No confirmation received on website/email/sms</option>
												<option value="Website-Complaint relating to Website-Unable to view/edit Profile Details">Website-Complaint relating to Website-Unable to view/edit Profile Details</option>
												<option value="Website-Complaint relating to Website-Issue with product page info">Website-Complaint relating to Website-Issue with product page info</option>
												<option value="Website-Complaint relating to Website-Unable to cancel">Website-Complaint relating to Website-Unable to cancel</option>
												<option value="Website-Complaint relating to Website-MRP Mismatch">Website-Complaint relating to Website-MRP Mismatch</option>
												<option value="Website-Complaint relating to Website-Unable to place order">Website-Complaint relating to Website-Unable to place order</option>
												<option value="Website-Complaint relating to Website-Unable to exchange">Website-Complaint relating to Website-Unable to exchange</option>
												<option value="Website-Complaint relating to Website-Unable to return">Website-Complaint relating to Website-Unable to return</option>
												<option value="Website-Complaint relating to Website-Product details required">Website-Complaint relating to Website-Product details required</option>
												<option value="VOC-Complaint against CC Employee-N/A">VOC-Complaint against CC Employee-N/A</option>
												<option value="Website-Complaint relating to Website-Unable to login/signup">Website-Complaint relating to Website-Unable to login/signup</option>
												<option value="Return-Non Ajio Product Returned-Product Reached WH">Return-Non Ajio Product Returned-Product Reached WH</option>
												<option value="VOC-Harassment & Integrity Issues-N/A">VOC-Harassment & Integrity Issues-N/A</option>
												<option value="Return-Pickup - Wrong Status Update-Product not picked up - Return Related">Return-Pickup - Wrong Status Update-Product not picked up - Return Related</option>
												<option value="Website-Complaint relating to Website-Slow Functioning/Unable to open feature-webpage-website">Website-Complaint relating to Website-Slow Functioning/Unable to open feature-webpage-website</option>
												<option value="WH - Order Related Issues-Customer Return-Product Interchange of Customer">WH - Order Related Issues-Customer Return-Product Interchange of Customer</option>
												<option value="WH - Order Related Issues-RTO-Order Received Without Return ID">WH - Order Related Issues-RTO-Order Received Without Return ID</option>
												<option value="WH - Order Related Issues-RTO-Others">WH - Order Related Issues-RTO-Others</option>
												<option value="WH - Order Related Issues-Customer Return-No Clue Shipment">WH - Order Related Issues-Customer Return-No Clue Shipment</option>
												<option value="WH - Order Related Issues-Customer Return-Invoice Interchange">WH - Order Related Issues-Customer Return-Invoice Interchange</option>
												<option value="WH - Order Related Issues-RTO-Damaged Product Received">WH - Order Related Issues-RTO-Damaged Product Received</option>
												<option value="WH - Order Related Issues-Customer Return-Missing Free Gift">WH - Order Related Issues-Customer Return-Missing Free Gift</option>
												<option value="WH - Order Related Issues-Customer Return-Non-Ajio Product Return">WH - Order Related Issues-Customer Return-Non-Ajio Product Return</option>
												<option value="WH - Order Related Issues-RTO-Empty Box Received">WH - Order Related Issues-RTO-Empty Box Received</option>
												<option value="WH - Order Related Issues-Customer Return-Order Received Without Return ID">WH - Order Related Issues-Customer Return-Order Received Without Return ID</option>
												<option value="WH - Order Related Issues-Return to be cancelled-AWB not cancelled (Pickup not required)">WH - Order Related Issues-Return to be cancelled-AWB not cancelled (Pickup not required)</option>
												<option value="WH - Order Related Issues-RTO-Missing Free Gift">WH - Order Related Issues-RTO-Missing Free Gift</option>
												<option value="WH - Order Related Issues-Forward-MRP Mismatch">WH - Order Related Issues-Forward-MRP Mismatch</option>
												<option value="WH - Order Related Issues-Customer Return-Excess Product Received">WH - Order Related Issues-Customer Return-Excess Product Received</option>
												<option value="WH - Order Related Issues-Customer Return-To Be Refunded – Empty Box Received">WH - Order Related Issues-Customer Return-To Be Refunded – Empty Box Received</option>
												<option value="WH - Order Related Issues-RTO-No Clue Shipment">WH - Order Related Issues-RTO-No Clue Shipment</option>
												<option value="WH - Order Related Issues-RTO-Excess Product Received">WH - Order Related Issues-RTO-Excess Product Received</option>
												<option value="WH - Order Related Issues-Forward-Design Mismatch">WH - Order Related Issues-Forward-Design Mismatch</option>
												<option value="WH - Order Related Issues-RTO-Packaging / Box not Received or Damaged">WH - Order Related Issues-RTO-Packaging / Box not Received or Damaged</option>
												<option value="WH - Order Related Issues-Return to be cancelled-AWB cancelled (Pickup not required)">WH - Order Related Issues-Return to be cancelled-AWB cancelled (Pickup not required)</option>
												<option value="WH - Order Related Issues-Return to be cancelled-AWB cancelled (Pickup required)">WH - Order Related Issues-Return to be cancelled-AWB cancelled (Pickup required)</option>
												<option value="WH - Order Related Issues-Forward-Tech Issues">WH - Order Related Issues-Forward-Tech Issues</option>
												<option value="WH - Order Related Issues-Return to be cancelled-AWB not cancelled (Pickup required)">WH - Order Related Issues-Return to be cancelled-AWB not cancelled (Pickup required)</option>
												<option value="WH - Order Related Issues-Customer Return-Empty Box Received">WH - Order Related Issues-Customer Return-Empty Box Received</option>
												<option value="WH - Order Related Issues-Customer Return-Non Delhivery pickup-Missing product in return packet">WH - Order Related Issues-Customer Return-Non Delhivery pickup-Missing product in return packet</option>
												<option value="WH - Order Related Issues-Customer Return-Others">WH - Order Related Issues-Customer Return-Others</option>
												<option value="WH - Order Related Issues-Customer Return-Missing Product in Return Packet">WH - Order Related Issues-Customer Return-Missing Product in Return Packet</option>
												<option value="WH - Order Related Issues-RTO-Missing Product in Return Packet">WH - Order Related Issues-RTO-Missing Product in Return Packet</option>
												<option value="WH - Order Related Issues-RTO-Invoice Interchange">WH - Order Related Issues-RTO-Invoice Interchange</option>
												<option value="WH - Order Related Issues-Customer Return-Tags Missing">WH - Order Related Issues-Customer Return-Tags Missing</option>
												<option value="WH - Order Related Issues-RTO-Non-Ajio Product Return">WH - Order Related Issues-RTO-Non-Ajio Product Return</option>
												<option value="Mobile App-Others-Others">Mobile App-Others-Others</option>
												<option value="Delivery-I want quicker Delivery-Informed about expediting policy">Delivery-I want quicker Delivery-Informed about expediting policy</option>
												<option value="Account-I need help with my account-Informed customer about account information">Account-I need help with my account-Informed customer about account information</option>
												<option value="Account-I need help with my account-Guided customer on My Accounts">Account-I need help with my account-Guided customer on My Accounts</option>
												<option value="Account-How do I use JioMoney?-Guided customer on JioMoney validity">Account-How do I use JioMoney?-Guided customer on JioMoney validity</option>
												<option value="Account-How do I use JioMoney?-Guided customer on loading JioMoney">Account-How do I use JioMoney?-Guided customer on loading JioMoney</option>
												<option value="Account-I did not place this order-Retained the order">Account-I did not place this order-Retained the order</option>
												<option value="Business-Others-Advised about the procedure">Business-Others-Advised about the procedure</option>
												<option value="Account-Why is my account suspended ?-Guided customer on Reason for Suspension">Account-Why is my account suspended ?-Guided customer on Reason for Suspension</option>
												<option value="NAR Calls/Emails-Incomplete Call/Email-Call dropped after knowing the query">NAR Calls/Emails-Incomplete Call/Email-Call dropped after knowing the query</option>
												<option value="Mobile App-Help me shop on the App-Helped the customer">Mobile App-Help me shop on the App-Helped the customer</option>
												<option value="Account-How do I use my store credits?-Informed about Store Credit policy">Account-How do I use my store credits?-Informed about Store Credit policy</option>
												<option value="Coupon-How do I use my Coupon?-Educated customer on Coupon features">Coupon-How do I use my Coupon?-Educated customer on Coupon features</option>
												<option value="Cancel-I want to cancel-Cancelled order">Cancel-I want to cancel-Cancelled order</option>
												<option value="NAR Calls/Emails-Incomplete Call/Email-Call suddenly went blank during conversation">NAR Calls/Emails-Incomplete Call/Email-Call suddenly went blank during conversation</option>
												<option value="Account-I did not place this order-Cancelled the order">Account-I did not place this order-Cancelled the order</option>
												<option value="NAR Calls/Emails-Blank Call-Blank Call">NAR Calls/Emails-Blank Call-Blank Call</option>
												<option value="Cancel-Explain the Cancellation Policy-Explained the cancellation policy">Cancel-Explain the Cancellation Policy-Explained the cancellation policy</option>
												<option value="Mobile App-How do I cancel the order on the App-Explained the feature">Mobile App-How do I cancel the order on the App-Explained the feature</option>
												<option value="Account-How do I use JioMoney?-Guided customer to JioMoney Customer Care">Account-How do I use JioMoney?-Guided customer to JioMoney Customer Care</option>
												<option value="Account-I want to Stop SMS/Email Promotions-Informed customer of the procedure">Account-I want to Stop SMS/Email Promotions-Informed customer of the procedure</option>
												<option value="Cancel-I want to cancel-Educated customer on cancellation policy">Cancel-I want to cancel-Educated customer on cancellation policy</option>
												<option value="Mobile App-I have a problem using your app-Explained the App feature/Functions">Mobile App-I have a problem using your app-Explained the App feature/Functions</option>
												<option value="NAR Calls/Emails-Incomplete Call/Email-Call dropped before knowing the query">NAR Calls/Emails-Incomplete Call/Email-Call dropped before knowing the query</option>
												<option value="Coupon-I did not receive a coupon after returning/cancelling-Educated customer on Coupon policy">Coupon-I did not receive a coupon after returning/cancelling-Educated customer on Coupon policy</option>
												<option value="Account-How many Store Credits do I have?-Provided the amount to the customer">Account-How many Store Credits do I have?-Provided the amount to the customer</option>
												<option value="Mobile App-The App is slow/ loading & functionality issues-Troubleshooting done">Mobile App-The App is slow/ loading & functionality issues-Troubleshooting done</option>
												<option value="Cancel-I want to cancel-Guided customer to cancel on Website/App">Cancel-I want to cancel-Guided customer to cancel on Website/App</option>
												<option value="Mobile App-I am unable to login/sign up on the App-Helped the customer login/signup">Mobile App-I am unable to login/sign up on the App-Helped the customer login/signup</option>
												<option value="Account-I need help with my account-Guided customer on password query">Account-I need help with my account-Guided customer on password query</option>
												<option value="Account-How do I use my store credits?-Explained how to use Store Credits">Account-How do I use my store credits?-Explained how to use Store Credits</option>
												<option value="Business-I want to do marketing/promotion for AJIO-Advised about the procedure">Business-I want to do marketing/promotion for AJIO-Advised about the procedure</option>
												<option value="NAR Calls/Emails-Abusive Caller-Abusive Caller">NAR Calls/Emails-Abusive Caller-Abusive Caller</option>
												<option value="NAR Calls/Emails-Incomplete Call/Email-Call suddenly got interrupted by static noise during conversation">NAR Calls/Emails-Incomplete Call/Email-Call suddenly got interrupted by static noise during conversation</option>
												<option value="Cancel-Cancel my Return/Exchange-Informed Unable to cancel">Cancel-Cancel my Return/Exchange-Informed Unable to cancel</option>
												<option value="Cancel-Why was my pickup/exchange cancelled?-Explained the reason">Cancel-Why was my pickup/exchange cancelled?-Explained the reason</option>
												<option value="Mobile App-How do I create a return on the App-Explained the feature">Mobile App-How do I create a return on the App-Explained the feature</option>
												<option value="Business-Media Related-Enquiry/ Concern">Business-Media Related-Enquiry/ Concern</option>
												<option value="Cancel-Why was my order cancelled?-Explained the cancellation reason">Cancel-Why was my order cancelled?-Explained the cancellation reason</option>
												<option value="Business-I want to sell my merchandise on AJIO-Advised about the procedure">Business-I want to sell my merchandise on AJIO-Advised about the procedure</option>
												<option value="Delivery-I want Delivery/Pickup at specific time-Informed about delivery policy">Delivery-I want Delivery/Pickup at specific time-Informed about delivery policy</option>
												<option value="Business-I want to apply for job at AJIO-Guided customer on process">Business-I want to apply for job at AJIO-Guided customer on process</option>
												<option value="Cancel-Cancel my Return/Exchange-Cancelled the Return /Exchange request">Cancel-Cancel my Return/Exchange-Cancelled the Return /Exchange request</option>
												<option value="NAR Calls/Emails-NAR Calls-No Action Required">NAR Calls/Emails-NAR Calls-No Action Required</option>
												<option value="NAR Calls/Emails-NAR Emails-No Action Required">NAR Calls/Emails-NAR Emails-No Action Required</option>
												<option value="NAR Calls/Emails-NAR Emails-Spam">NAR Calls/Emails-NAR Emails-Spam</option>
												<option value="NAR Calls/Emails-NAR Calls-Non Ajio Queries">NAR Calls/Emails-NAR Calls-Non Ajio Queries</option>
												<option value="NAR Calls/Emails-Test-Test Email">NAR Calls/Emails-Test-Test Email</option>
												<option value="NAR Calls/Emails-NAR Emails-Duplicate email">NAR Calls/Emails-NAR Emails-Duplicate email</option>
												<option value="Cancel-I want to cancel-Informed customer to refuse the delivery">Cancel-I want to cancel-Informed customer to refuse the delivery</option>
												<option value="NAR Calls/Emails-Prank Call-Prank Call">NAR Calls/Emails-Prank Call-Prank Call</option>
												<option value="Order-I want to place an order-Placed an order through CS Cockpit">Order-I want to place an order-Placed an order through CS Cockpit</option>
												<option value="Order-I want to place an order-Informed customer of pin code serviceability">Order-I want to place an order-Informed customer of pin code serviceability</option>
												<option value="Other-I want Compensation-Convinced the customer - No Action Required">Other-I want Compensation-Convinced the customer - No Action Required</option>
												<option value="Order-Telesales-Order Placed">Order-Telesales-Order Placed</option>
												<option value="Order-I had a problem while placing an order-Clarified that order was Not Processed">Order-I had a problem while placing an order-Clarified that order was Not Processed</option>
												<option value="Order-I had a problem while placing an order-Informed customer of pin code serviceability">Order-I had a problem while placing an order-Informed customer of pin code serviceability</option>
												<option value="Pre Order - F&L-Explain the features of the product-Explained about product features">Pre Order - F&L-Explain the features of the product-Explained about product features</option>
												<option value="Order-What are my delivery / payment options?-Informed customer of payment options">Order-What are my delivery / payment options?-Informed customer of payment options</option>
												<option value="Other-I want Compensation-Transferred call to supervisor">Other-I want Compensation-Transferred call to supervisor</option>
												<option value="Order-I want to modify my order (ph/addr etc)-Modified Ph. No. /Address on CS Cockpit">Order-I want to modify my order (ph/addr etc)-Modified Ph. No. /Address on CS Cockpit</option>
												<option value="Order-What are the payment modes?-Informed customer of payment options">Order-What are the payment modes?-Informed customer of payment options</option>
												<option value="Other-I need to speak in regional language-Transferred call to other champ">Other-I need to speak in regional language-Transferred call to other champ</option>
												<option value="Other-I want to know more about an offer/promotion-Explained that there is no current promotion at AJIO">Other-I want to know more about an offer/promotion-Explained that there is no current promotion at AJIO</option>
												<option value="Order-I want to modify my order (ph/addr etc)-Guided customer to modify details on website/app">Order-I want to modify my order (ph/addr etc)-Guided customer to modify details on website/app</option>
												<option value="Other-I want to know more about an offer/promotion-Explained the promotion to customer">Other-I want to know more about an offer/promotion-Explained the promotion to customer</option>
												<option value="Post Sales Service-Product not working as described after returns period-Guided customer to service Centre">Post Sales Service-Product not working as described after returns period-Guided customer to service Centre</option>
												<option value="Other-I need to talk to a supervisor-Transferred call to supervisor">Other-I need to talk to a supervisor-Transferred call to supervisor</option>
												<option value="Order-What are my delivery / payment options?-Informed customer of serviceability">Order-What are my delivery / payment options?-Informed customer of serviceability</option>
												<option value="Order-I want my Invoice-Emailed Invoice to the customer">Order-I want my Invoice-Emailed Invoice to the customer</option>
												<option value="Other-I need to speak in regional language-Informed about non-availability">Other-I need to speak in regional language-Informed about non-availability</option>
												<option value="Order-I had a problem while placing an order-Placed an order through CS Cockpit">Order-I had a problem while placing an order-Placed an order through CS Cockpit</option>
												<option value="Order-I had a problem while placing an order-Clarified that order was processed.">Order-I had a problem while placing an order-Clarified that order was processed.</option>
												<option value="Pre Order - F&L-Where can i find this product?-Helped customer to find the product">Pre Order - F&L-Where can i find this product?-Helped customer to find the product</option>
												<option value="Pre Order - F&L-Where can i find this product?-Informed customer that the product is not in stock">Pre Order - F&L-Where can i find this product?-Informed customer that the product is not in stock</option>
												<option value="Pre Order - Tech Related - Mobile / Iphone-Product not working as described after returns period-Guided customer to service Centre">Pre Order - Tech Related - Mobile / Iphone-Product not working as described after returns period-Guided customer to service Centre</option>
												<option value="Order-I want to place an order-Guided customer on placing an order on website/app">Order-I want to place an order-Guided customer on placing an order on website/app</option>
												<option value="Order-I had a problem while placing an order-Helped the customer to place the order on website/app">Order-I had a problem while placing an order-Helped the customer to place the order on website/app</option>
												<option value="Pre Order - F&L-I need warranty information-Provided Information">Pre Order - F&L-I need warranty information-Provided Information</option>
												<option value="Pre Order - Tech Related - Mobile / Iphone-I need warranty information-Provided Information">Pre Order - Tech Related - Mobile / Iphone-I need warranty information-Provided Information</option>
												<option value="Pre Order - Tech Related - Jio Fi-Where can I buy Accessory-Provided Information">Pre Order - Tech Related - Jio Fi-Where can I buy Accessory-Provided Information</option>
												<option value="Pre Order - Tech Related - Mobile / Iphone-Where can I buy Accessory-Provided Information">Pre Order - Tech Related - Mobile / Iphone-Where can I buy Accessory-Provided Information</option>
												<option value="Pre Order - Tech Related - Mobile / Iphone-Where can i find this product?-Informed customer that the product is not in stock">Pre Order - Tech Related - Mobile / Iphone-Where can i find this product?-Informed customer that the product is not in stock</option>
												<option value="Pre Order - Tech Related - Jio Fi-I need warranty information-Provided Information">Pre Order - Tech Related - Jio Fi-I need warranty information-Provided Information</option>
												<option value="Pre Order - Tech Related - Others-Product not working as described after returns period-Guided customer to service Centre">Pre Order - Tech Related - Others-Product not working as described after returns period-Guided customer to service Centre</option>
												<option value="Pre Order - Tech Related - Others-Where can i find this product?-Helped customer to find the product">Pre Order - Tech Related - Others-Where can i find this product?-Helped customer to find the product</option>
												<option value="Pre Order - Tech Related - Others-Where can I buy Accessory-Provided Information">Pre Order - Tech Related - Others-Where can I buy Accessory-Provided Information</option>
												<option value="Price-What's the price for this order?-Informed customer about cost split">Price-What's the price for this order?-Informed customer about cost split</option>
												<option value="Price-How much does Gift Wrap cost?-Guided customer on gift wrap charges">Price-How much does Gift Wrap cost?-Guided customer on gift wrap charges</option>
												<option value="Refund-Where is my Refund?-Informed customer about self-ship status">Refund-Where is my Refund?-Informed customer about self-ship status</option>
												<option value="Refund-How do I get my money back?-Informed customer about COD refund">Refund-How do I get my money back?-Informed customer about COD refund</option>
												<option value="Refund-How do I get my money back?-Informed Customer about IMPS procedure">Refund-How do I get my money back?-Informed Customer about IMPS procedure</option>
												<option value="Refund-How long does it take to reflect in account once Refund is initiated?-Informed customer of time to refund">Refund-How long does it take to reflect in account once Refund is initiated?-Informed customer of time to refund</option>
												<option value="Refund-Enable my IMPS Refund-Enabled the IMPS switch">Refund-Enable my IMPS Refund-Enabled the IMPS switch</option>
												<option value="Refund-My refund hasn't reflected in source account-Provided Reference No. for CC/DC/NB">Refund-My refund hasn't reflected in source account-Provided Reference No. for CC/DC/NB</option>
												<option value="Refund-Where is my Refund?-JioMoney refund is processed - informed to wait for 2 business days">Refund-Where is my Refund?-JioMoney refund is processed - informed to wait for 2 business days</option>
												<option value="Refund-My refund hasn't reflected in source account-Provided Reference No. for e-wallets">Refund-My refund hasn't reflected in source account-Provided Reference No. for e-wallets</option>
												<option value="Refund-Where is my Refund?-Informed about Refund TAT">Refund-Where is my Refund?-Informed about Refund TAT</option>
												<option value="Refund-Where is my Refund?-Prepaid refund is processed - informed to wait for 5-7 business days">Refund-Where is my Refund?-Prepaid refund is processed - informed to wait for 5-7 business days</option>
												<option value="Refund-How do I get my money back?-Informed customer about Wallet Refund">Refund-How do I get my money back?-Informed customer about Wallet Refund</option>
												<option value="Refund-Where is my Refund?-IMPS refund is processed - informed to wait for 1 business day">Refund-Where is my Refund?-IMPS refund is processed - informed to wait for 1 business day</option>
												<option value="Refund-How do I get my money back?-Informed customer about Prepaid Refund">Refund-How do I get my money back?-Informed customer about Prepaid Refund</option>
												<option value="Refund-There is a discrepancy with my store credits-Clarified discrepancy with customer">Refund-There is a discrepancy with my store credits-Clarified discrepancy with customer</option>
												<option value="Refund-My refund hasn't reflected in source account-Provided reference number for IMPS">Refund-My refund hasn't reflected in source account-Provided reference number for IMPS</option>
												<option value="Return/Exchange-Create a return for me-Created Return - Received Damaged Product">Return/Exchange-Create a return for me-Created Return - Received Damaged Product</option>
												<option value="Return/Exchange-Create a return for me-Created Return - Different Product delivered">Return/Exchange-Create a return for me-Created Return - Different Product delivered</option>
												<option value="Return/Exchange-Create a return for me-Created Return - Wrong size delivered">Return/Exchange-Create a return for me-Created Return - Wrong size delivered</option>
												<option value="Return/Exchange-Create a return for me-Created Return - Product damaged post usage">Return/Exchange-Create a return for me-Created Return - Product damaged post usage</option>
												<option value="Refund-Why is my return rejected/put on hold?-Guided customer on reason">Refund-Why is my return rejected/put on hold?-Guided customer on reason</option>
												<option value="Return/Exchange-Create a return for me-Defective Product received">Return/Exchange-Create a return for me-Defective Product received</option>
												<option value="Return/Exchange-Create a return for me-Created Return for customer">Return/Exchange-Create a return for me-Created Return for customer</option>
												<option value="Return/Exchange-Create a return for me-Wrong Product delivered">Return/Exchange-Create a return for me-Wrong Product delivered</option>
												<option value="Return/Exchange-Create a return for me-Created Return for Used Product">Return/Exchange-Create a return for me-Created Return for Used Product</option>
												<option value="Return/Exchange-Create a return for me-Seal tampered cases">Return/Exchange-Create a return for me-Seal tampered cases</option>
												<option value="Return/Exchange-Create an Exchange for me-Created Exchange for customer">Return/Exchange-Create an Exchange for me-Created Exchange for customer</option>
												<option value="Return/Exchange-Create a return for me-Created Return - Wrong colour delivered">Return/Exchange-Create a return for me-Created Return - Wrong colour delivered</option>
												<option value="Return/Exchange-Create an Exchange for me-Created Exchange – Received Damaged Product">Return/Exchange-Create an Exchange for me-Created Exchange – Received Damaged Product</option>
												<option value="Return/Exchange-Create an Exchange for me-Created Return due to lack of size">Return/Exchange-Create an Exchange for me-Created Return due to lack of size</option>
												<option value="Return/Exchange-Has my Self-Ship Return reached you?-Asked to check with customer's courier company">Return/Exchange-Has my Self-Ship Return reached you?-Asked to check with customer's courier company</option>
												<option value="Return/Exchange-Has my Self-Ship Return reached you?-Informed - Reached Warehouse and Refund pending">Return/Exchange-Has my Self-Ship Return reached you?-Informed - Reached Warehouse and Refund pending</option>
												<option value="Return/Exchange-Exchange Related-Informed – product will get exchanged">Return/Exchange-Exchange Related-Informed – product will get exchanged</option>
												<option value="Return/Exchange-Create a return for me-Empty Parcel received">Return/Exchange-Create a return for me-Empty Parcel received</option>
												<option value="Return/Exchange-Has my Self-Ship Return reached you?-Others">Return/Exchange-Has my Self-Ship Return reached you?-Others</option>
												<option value="Return/Exchange-Create a return for me-Created Return - Tags/Shoebox missing">Return/Exchange-Create a return for me-Created Return - Tags/Shoebox missing</option>
												<option value="Return/Exchange-Has my Self-Ship Return reached you?-Informed - Reached Warehouse and Refund initiated">Return/Exchange-Has my Self-Ship Return reached you?-Informed - Reached Warehouse and Refund initiated</option>
												<option value="Return/Exchange-Customer claiming product picked up-Asked to share acknowledgement copy">Return/Exchange-Customer claiming product picked up-Asked to share acknowledgement copy</option>
												<option value="Return/Exchange-How do I return/exchange this item?-Declined - Time Period lapsed">Return/Exchange-How do I return/exchange this item?-Declined - Time Period lapsed</option>
												<option value="Return/Exchange-How do I return/exchange this item?-Email sent to confirm policy - Fitment Issue">Return/Exchange-How do I return/exchange this item?-Email sent to confirm policy - Fitment Issue</option>
												<option value="Return/Exchange-How do I return/exchange this item?-Informed Return Policy - others">Return/Exchange-How do I return/exchange this item?-Informed Return Policy - others</option>
												<option value="Return/Exchange-Has my Self-Ship Return reached you?-Updated tracking number for the customer">Return/Exchange-Has my Self-Ship Return reached you?-Updated tracking number for the customer</option>
												<option value="Return/Exchange-How do I return/exchange this item?-Educated Customer on Exchange Policy">Return/Exchange-How do I return/exchange this item?-Educated Customer on Exchange Policy</option>
												<option value="Return/Exchange-How do I return/exchange this item?-Declined - Product Used">Return/Exchange-How do I return/exchange this item?-Declined - Product Used</option>
												<option value="Return/Exchange-How do I return/exchange this item?-Declined - Non returnable product">Return/Exchange-How do I return/exchange this item?-Declined - Non returnable product</option>
												<option value="Return/Exchange-How do I return/exchange this item?-Declined – Non exchangeable product">Return/Exchange-How do I return/exchange this item?-Declined – Non exchangeable product</option>
												<option value="Return/Exchange-How do I return/exchange this item?-Declined - tags/shoebox missing">Return/Exchange-How do I return/exchange this item?-Declined - tags/shoebox missing</option>
												<option value="Return/Exchange-How do I return/exchange this item?-Requested image for wrong product delivered">Return/Exchange-How do I return/exchange this item?-Requested image for wrong product delivered</option>
												<option value="Return/Exchange-How do I return/exchange this item?-Email sent to confirm policy - Didn't like product">Return/Exchange-How do I return/exchange this item?-Email sent to confirm policy - Didn't like product</option>
												<option value="Return/Exchange-Unable to create return on website/mobile-Created Return for customer">Return/Exchange-Unable to create return on website/mobile-Created Return for customer</option>
												<option value="Return/Exchange-How do I return/exchange this item?-Educated customer on Self Service steps">Return/Exchange-How do I return/exchange this item?-Educated customer on Self Service steps</option>
												<option value="Return/Exchange-How do I return/exchange this item?-Informed Return Policy - products">Return/Exchange-How do I return/exchange this item?-Informed Return Policy - products</option>
												<option value="Return/Exchange-Pickup related-Provided shipping address">Return/Exchange-Pickup related-Provided shipping address</option>
												<option value="Return/Exchange-Pickup related-Informed - Reached WH and Refund initiated">Return/Exchange-Pickup related-Informed - Reached WH and Refund initiated</option>
												<option value="Return/Exchange-Pickup related-Others">Return/Exchange-Pickup related-Others</option>
												<option value="Return/Exchange-Pickup related-Provided information on packing product">Return/Exchange-Pickup related-Provided information on packing product</option>
												<option value="Return/Exchange-Pickup related-Informed - product will be picked up">Return/Exchange-Pickup related-Informed - product will be picked up</option>
												<option value="Return/Exchange-Pickup related-Informed - picked up product still has to reach Warehouse">Return/Exchange-Pickup related-Informed - picked up product still has to reach Warehouse</option>
												<option value="Return/Exchange-Is my pin code serviceable for Exchange/Return?-Explained pin-code Serviceability">Return/Exchange-Is my pin code serviceable for Exchange/Return?-Explained pin-code Serviceability</option>
												<option value="Website-Access/Function-Helped in returning order">Website-Access/Function-Helped in returning order</option>
												<option value="Website-Access/Function-Helped in accessing page/site">Website-Access/Function-Helped in accessing page/site</option>
												<option value="Ticket-Cx-Shared attachment-Cx-Shared attachment">Ticket-Cx-Shared attachment-Cx-Shared attachment</option>
												<option value="Website-Access/Function-Helped in viewing account details">Website-Access/Function-Helped in viewing account details</option>
												<option value="Website-Access/Function-Helped in cancelling order">Website-Access/Function-Helped in cancelling order</option>
												<option value="Website-Access/Function-Helped in signup/login">Website-Access/Function-Helped in signup/login</option>
												<option value="Website-How to shop on App?-Guided customer to visit the App">Website-How to shop on App?-Guided customer to visit the App</option>
												<option value="Website-How to shop on m-site?-Guided customer to visit the mobile site">Website-How to shop on m-site?-Guided customer to visit the mobile site</option>
												<option value="OB-Delayed Delivery-To Be Delivered">OB-Delayed Delivery-To Be Delivered</option>
												<option value="OB-Delayed Delivery-Not Connected">OB-Delayed Delivery-Not Connected</option>
												<option value="OB-Delayed Delivery-Delivered">OB-Delayed Delivery-Delivered</option>
												<option value="OB-Delayed Delivery-RTO">OB-Delayed Delivery-RTO</option>
												<option value="Website-Please explain AJIO-Explained about website">Website-Please explain AJIO-Explained about website</option>
												<option value="OB-Order In Progress-Not Connected">OB-Order In Progress-Not Connected</option>
												<option value="OB-NDR-Delivered">OB-NDR-Delivered</option>
												<option value="OB-Misc-Informed">OB-Misc-Informed</option>
												<option value="OB-NDR-To Be Delivered">OB-NDR-To Be Delivered</option>
												<option value="OB-Misc-Not Connected">OB-Misc-Not Connected</option>
												<option value="OB-Order In Progress-MRP Mismatch - Credit">OB-Order In Progress-MRP Mismatch - Credit</option>
												<option value="OB-Order In Progress-MRP Mismatch - Waiver">OB-Order In Progress-MRP Mismatch - Waiver</option>
												<option value="OB-Order In Progress-Short Pick - Partially Cancelled">OB-Order In Progress-Short Pick - Partially Cancelled</option>
												<option value="OB-Order In Progress-MRP Mismatch - Cancelled">OB-Order In Progress-MRP Mismatch - Cancelled</option>
												<option value="OB-Order In Progress-Sales Tax - To be RTOed">OB-Order In Progress-Sales Tax - To be RTOed</option>
												<option value="OB-Order In Progress-Sales Tax - To be delivered">OB-Order In Progress-Sales Tax - To be delivered</option>
												<option value="OB-Order In Progress-Order Lost - Informed">OB-Order In Progress-Order Lost - Informed</option>
												<option value="OB-Callback-Not Connected">OB-Callback-Not Connected</option>
												<option value="OB-Ticket-Not Connected">OB-Ticket-Not Connected</option>
												<option value="OB-Order In Progress-Telesales - Cancelled">OB-Order In Progress-Telesales - Cancelled</option>
												<option value="OB-Order In Progress-OOS - Informed">OB-Order In Progress-OOS - Informed</option>
												<option value="OB-Order In Progress-Short Pick - Cancelled">OB-Order In Progress-Short Pick - Cancelled</option>
												<option value="OB-Cancellation due to QC fail-Not Connected">OB-Cancellation due to QC fail-Not Connected</option>
												<option value="OB-Ticket-Ticket Created">OB-Ticket-Ticket Created</option>
												<option value="OB-Cancellation due to QC fail-Informed">OB-Cancellation due to QC fail-Informed</option>
												<option value="OB-Survey-Not Connected">OB-Survey-Not Connected</option>
												<option value="OB-Ticket-Ticket Escalation">OB-Ticket-Ticket Escalation</option>
												<option value="OB-Ticket-Ticket Closed">OB-Ticket-Ticket Closed</option>
												<option value="OB-Ticket-Ticket Follow Up">OB-Ticket-Ticket Follow Up</option>
												<option value="OB-Survey-Incomplete Survey">OB-Survey-Incomplete Survey</option>
												<option value="OB-NDR-To Be Delivered - Fake Remarks">OB-NDR-To Be Delivered - Fake Remarks</option>
												<option value="OB-Survey-Completed">OB-Survey-Completed</option>
												<option value="OB-NDR-Not Contactable2">OB-NDR-Not Contactable2</option>
												<option value="OB-NDR-Not Contactable1">OB-NDR-Not Contactable1</option>
												<option value="OB-NPR-Picked Up">OB-NPR-Picked Up</option>
												<option value="OB-NPR-Not Contactable3">OB-NPR-Not Contactable3</option>
												<option value="OB-NPR-To Be Picked Up - Fake Remarks">OB-NPR-To Be Picked Up - Fake Remarks</option>
												<option value="OB-NPR-Pickup Cancelled">OB-NPR-Pickup Cancelled</option>
												<option value="OB-NPR-Not Contactable2">OB-NPR-Not Contactable2</option>
												<option value="OB-NPR-To Be Picked Up">OB-NPR-To Be Picked Up</option>
												<option value="OB-NDR-Not Contactable3">OB-NDR-Not Contactable3</option>
												<option value="OB-NPR-Not Contactable1">OB-NPR-Not Contactable1</option>
												<option value="OB-NDR-To Be RTO - Fake Remarks">OB-NDR-To Be RTO - Fake Remarks</option>
												<option value="OB-NDR-To Be RTO">OB-NDR-To Be RTO</option>
												<option value="Feedback-Others-N/A">Feedback-Others-N/A</option>
												<option value="Feedback-Suggestions about Website-N/A">Feedback-Suggestions about Website-N/A</option>
												<option value="Feedback-Suggestions about CC-N/A">Feedback-Suggestions about CC-N/A</option>
												<option value="Feedback-Suggestions about Warehouse-N/A">Feedback-Suggestions about Warehouse-N/A</option>
												<option value="Feedback-Suggestions about Profile-N/A">Feedback-Suggestions about Profile-N/A</option>
												<option value="Feedback-Suggestions about Returns/Exchange-N/A">Feedback-Suggestions about Returns/Exchange-N/A</option>
												<option value="Feedback-Suggestions about Delivery-N/A">Feedback-Suggestions about Delivery-N/A</option>
												<option value="Feedback-Suggestions about CC-Unable to reach customer care number">Feedback-Suggestions about CC-Unable to reach customer care number</option>
												<option value="Feedback-Suggestions about Products-N/A">Feedback-Suggestions about Products-N/A</option>
												<option value="Feedback-Suggestions about CC-Others">Feedback-Suggestions about CC-Others</option>
												<option value="Feedback-Suggestions about Refund-N/A">Feedback-Suggestions about Refund-N/A</option>
												<option value="Feedback-Mobile App-Feedback/Suggestion about mobile App">Feedback-Mobile App-Feedback/Suggestion about mobile App</option>
												<option value="Online Refund-Refund not done against Reference No. - Prepaid cancelled-N/A">Online Refund-Refund not done against Reference No. - Prepaid cancelled-N/A</option>
												<option value="WH - Order Related Issues-Forward-Shipment Lost to be refunded">WH - Order Related Issues-Forward-Shipment Lost to be refunded</option>
												<option value="Delivery-POD Required-Customer Disputes on POD Shared">Delivery-POD Required-Customer Disputes on POD Shared</option>
												<option value="Delivery-Where is my Order?-Informed Order is RTOed">Delivery-Where is my Order?-Informed Order is RTOed</option>
												<option value="Delivery-Where is my Order?-Informed Promised Delivery Date">Delivery-Where is my Order?-Informed Promised Delivery Date</option>
												<option value="Delivery-Order not marked as Delivered-N/A">Delivery-Order not marked as Delivered-N/A</option>
												<option value="Coupon-How do I use my Jio Prime Points?-Educated customer on Jio Prime points">Coupon-How do I use my Jio Prime Points?-Educated customer on Jio Prime points</option>
												<option value="Return/Exchange-Is my pin code serviceable for Exchange/Return?-Informed about non availability of exchange at store">Return/Exchange-Is my pin code serviceable for Exchange/Return?-Informed about non availability of exchange at store</option>
												<option value="Return/Exchange-Is my pin code serviceable for Exchange/Return?-Informed serviceability of drop at store for product/store">Return/Exchange-Is my pin code serviceable for Exchange/Return?-Informed serviceability of drop at store for product/store</option>
												<option value="Return/Exchange-How do I return/exchange this item?-Informed how drop at store option works">Return/Exchange-How do I return/exchange this item?-Informed how drop at store option works</option>
												<option value="Refund-How do I get my money back?-Informed customer about Drop at Store refund – Prepaid Order">Refund-How do I get my money back?-Informed customer about Drop at Store refund – Prepaid Order</option>
												<option value="Refund-How do I get my money back?-Informed Cx about SC refund for Drop at Store">Refund-How do I get my money back?-Informed Cx about SC refund for Drop at Store</option>
												<option value="Refund-How do I get my money back?-Informed Cx about cash refund for drop at store">Refund-How do I get my money back?-Informed Cx about cash refund for drop at store</option>
												<option value="Refund-Where is my Refund?-Informed about drop at store refund TAT">Refund-Where is my Refund?-Informed about drop at store refund TAT</option>
												<option value="WH - Order Related Issues-Customer Return-Wrong Product Received – EAN Matched">WH - Order Related Issues-Customer Return-Wrong Product Received – EAN Matched</option>
												<option value="WH - Order Related Issues-Customer Return-Used Product Received">WH - Order Related Issues-Customer Return-Used Product Received</option>
												<option value="Goodwill Request-CM insisting Compensation-Coupon Reactivation">Goodwill Request-CM insisting Compensation-Coupon Reactivation</option>
												<option value="Return-Non Returnable Product-Wrong Product delivered">Return-Non Returnable Product-Wrong Product delivered</option>
												<option value="Return-Customer Delight-N/A">Return-Customer Delight-N/A</option>
												<option value="Delivery-Customer Delight-N/A">Delivery-Customer Delight-N/A</option>
												<option value="Return-Non Returnable Product-Tags Detached but available">Return-Non Returnable Product-Tags Detached but available</option>
												<option value="Return-Non Returnable Product-Tags Not Available - Not Received">Return-Non Returnable Product-Tags Not Available - Not Received</option>
												<option value="Return-Non Returnable Product-Tags Not Available - Misplaced by customer">Return-Non Returnable Product-Tags Not Available - Misplaced by customer</option>
												<option value="Return-Non Returnable Product-Used Product Delivered">Return-Non Returnable Product-Used Product Delivered</option>
												<option value="Return-Non Returnable Product-Classified as non-returnable">Return-Non Returnable Product-Classified as non-returnable</option>
												<option value="Return-Non Returnable Product-Return - Post Return Window">Return-Non Returnable Product-Return - Post Return Window</option>
												<option value="Return/Exchange-How do I return/exchange this item?-Requested customer to share the images">Return/Exchange-How do I return/exchange this item?-Requested customer to share the images</option>
												<option value="WH - Order Related Issues-Customer Return-Customer confirmation Required (Non-AJIO Product Received)">WH - Order Related Issues-Customer Return-Customer confirmation Required (Non-AJIO Product Received)</option>
												<option value="WH - Order Related Issues-Customer Return-Other node shipment received">WH - Order Related Issues-Customer Return-Other node shipment received</option>
												<option value="Account-Store Credit Discrepancy-AJIO Cash">Account-Store Credit Discrepancy-AJIO Cash</option>
												<option value="Account-Store Credit Discrepancy-Bonus Points">Account-Store Credit Discrepancy-Bonus Points</option>
												<option value="NAR Calls/Emails-NAR Emails-Replied & Asked for More Information">NAR Calls/Emails-NAR Emails-Replied & Asked for More Information</option>
												<option value="Delivery-Where is my Order?-Guided customer to track the order online">Delivery-Where is my Order?-Guided customer to track the order online</option>
												<option value="Order-I had a problem while placing an order-ADONP – within 48 hrs">Order-I had a problem while placing an order-ADONP – within 48 hrs</option>
												<option value="Website-Complaint relating to Website-Return ID in Approved Status">Website-Complaint relating to Website-Return ID in Approved Status</option>
												<option value="Order-What are the payment modes?-Informed Cx COD Not Available">Order-What are the payment modes?-Informed Cx COD Not Available</option>
												<option value="Website-Complaint relating to Website-AWB Not Assigned">Website-Complaint relating to Website-AWB Not Assigned</option>
												<option value="NAR Calls/Emails-NAR Calls-Already Actioned">NAR Calls/Emails-NAR Calls-Already Actioned</option>
												<option value="NAR Calls/Emails-NAR Emails-Already Actioned">NAR Calls/Emails-NAR Emails-Already Actioned</option>
												<option value="OB-QC fail while returning-Callback Requested">OB-QC fail while returning-Callback Requested</option>
												<option value="OB-QC fail while returning-Others">OB-QC fail while returning-Others</option>
												<option value="OB-QC fail while returning-Asked to share images">OB-QC fail while returning-Asked to share images</option>
												<option value="OB-QC fail while returning-Raised pick without QC">OB-QC fail while returning-Raised pick without QC</option>
												<option value="OB-QC fail while returning-Declined Returns">OB-QC fail while returning-Declined Returns</option>
												<option value="OB-QC fail while returning-Raised Fake Attempt Complaint">OB-QC fail while returning-Raised Fake Attempt Complaint</option>
												<option value="Pre Order - RJ-What are my delivery / payment options-Informed customer of payment / delivery options">Pre Order - RJ-What are my delivery / payment options-Informed customer of payment / delivery options</option>
												<option value="Pre Order - RJ-I need Authenticity information-Provided Information">Pre Order - RJ-I need Authenticity information-Provided Information</option>
												<option value="Pre Order - RJ-Explain the features of the product-Explained about product features / Pricing">Pre Order - RJ-Explain the features of the product-Explained about product features / Pricing</option>
												<option value="Account-Query / Dispute about LR-Guided customer to LR team">Account-Query / Dispute about LR-Guided customer to LR team</option>
												<option value="Account-How do I use my Loyalty Rewards-Explained how to use LR">Account-How do I use my Loyalty Rewards-Explained how to use LR</option>
												<option value="Delivery-Order not dispatched from Warehouse-Shipment in Packed Status">Delivery-Order not dispatched from Warehouse-Shipment in Packed Status</option>
												<option value="Return-Reached Warehouse - Refund not Initiated-Excess product handed over">Return-Reached Warehouse - Refund not Initiated-Excess product handed over</option>
												<option value="Delivery-POD Required-Req cx to check with neighbour / security">Delivery-POD Required-Req cx to check with neighbour / security</option>
												<option value="Return-Wrong item with no tag-Return form">Return-Wrong item with no tag-Return form</option>
												<option value="Return-Wrong Item-Return form">Return-Wrong Item-Return form</option>
												<option value="OB-Misc-Not Connected - Email Sent">OB-Misc-Not Connected - Email Sent</option>
												<option value="Reliance Jewels-I want certification of authenticity-Certificate to be sent">Reliance Jewels-I want certification of authenticity-Certificate to be sent</option>
												<option value="Reliance Jewels-Information on weight/purity-Requested customer to visit nearest RJ store">Reliance Jewels-Information on weight/purity-Requested customer to visit nearest RJ store</option>
												<option value="Return-Package ID related-cancellation due to items exceeding the package dimension">Return-Package ID related-cancellation due to items exceeding the package dimension</option>
												<option value="Return-Package ID related-duplicate Package ID to be sent">Return-Package ID related-duplicate Package ID to be sent</option>
												<option value="Pre Order - AJIO LUX-Explain the features of the product-Explained about product features">Pre Order - AJIO LUX-Explain the features of the product-Explained about product features</option>
												<option value="Pre Order - AJIO LUX-I need warranty information-Provided Information">Pre Order - AJIO LUX-I need warranty information-Provided Information</option>
												<option value="Pre Order - AJIO LUX-Where can i find this product?-Informed customer that the product is not in stock">Pre Order - AJIO LUX-Where can i find this product?-Informed customer that the product is not in stock</option>
												<option value="Pre Order - AJIO LUX-Where can i find this product?-Helped customer to find the product">Pre Order - AJIO LUX-Where can i find this product?-Helped customer to find the product</option>
												<option value="Delivery-Marked the order as delivered-N/A">Delivery-Marked the order as delivered-N/A</option>
												<option value="Refund-Where is my Refund?-Educated customer about GST refund">Refund-Where is my Refund?-Educated customer about GST refund</option>
												<option value="Return/Exchange-How do I return/exchange this item?-Email sent to confirm policy - Missing Product/Component">Return/Exchange-How do I return/exchange this item?-Email sent to confirm policy - Missing Product/Component</option>
												<option value="NAR Calls/Emails-NAR Emails-Non AJIO Query">NAR Calls/Emails-NAR Emails-Non AJIO Query</option>
												<option value="Coupon-Unable to apply coupon-Requested to share coupon details/images">Coupon-Unable to apply coupon-Requested to share coupon details/images</option>
												<option value="Account-Store Credit Debited Order Not Processed-R-1 Points">Account-Store Credit Debited Order Not Processed-R-1 Points</option>
												<option value="Account-I have not received my referral bonus-Informed about referral credit">Account-I have not received my referral bonus-Informed about referral credit</option>
												<option value="Account-Ajio Referral Discrepancy-Referral points/code not received">Account-Ajio Referral Discrepancy-Referral points/code not received</option>
												<option value="Website-Complaint relating to Website-Order Delivered - Consignment not visible">Website-Complaint relating to Website-Order Delivered - Consignment not visible</option>
												<option value="Return-Reached Warehouse - Refund not Initiated-Partial Refund Initiated">Return-Reached Warehouse - Refund not Initiated-Partial Refund Initiated</option>
												<option value="Website-Complaint relating to Website-Change in login info">Website-Complaint relating to Website-Change in login info</option>
												<option value="Account-Fraudulent Activity reported-Educated customer as per policy">Account-Fraudulent Activity reported-Educated customer as per policy</option>
												<option value="Return-Cancelation Request (Chatbot only)-Return to be cancelled (Chatbot only)">Return-Cancelation Request (Chatbot only)-Return to be cancelled (Chatbot only)</option>
												<option value="Account-R- One related-R - One refund not credited">Account-R- One related-R - One refund not credited</option>
												<option value="Account-How do I use my R - One points-Explained how to use R - One points">Account-How do I use my R - One points-Explained how to use R - One points</option>
												<option value="Account-I have not received my R - One points-Informed about R - One points">Account-I have not received my R - One points-Informed about R - One points</option>
												<option value="Website-Complaint related to website-R - One points not visible">Website-Complaint related to website-R - One points not visible</option>
												<option value="Account-R- One related-R - One points not credited">Account-R- One related-R - One points not credited</option>
												<option value="Delivery-Cancelation Request (Chatbot only)-Exchange to be cancelled (Chatbot only)">Delivery-Cancelation Request (Chatbot only)-Exchange to be cancelled (Chatbot only)</option>
												<option value="Delivery-Marked the order as delivered-Requested customer to wait for 2 business days">Delivery-Marked the order as delivered-Requested customer to wait for 2 business days</option>
												<option value="Return-Non Returnable Product-Damaged Product Received - Fragile">Return-Non Returnable Product-Damaged Product Received - Fragile</option>
												<option value="Return-Non Returnable Product-Damaged Product Received">Return-Non Returnable Product-Damaged Product Received</option>
												<option value="Refund-Where is my Refund?-Imps Failed - Requested Customer to share NEFT details">Refund-Where is my Refund?-Imps Failed - Requested Customer to share NEFT details</option>
												<option value="NEFT(Refund Request)-NEFT Followup-Request for NEFT Transfer">NEFT(Refund Request)-NEFT Followup-Request for NEFT Transfer</option>
												<option value="Delivery-Empty Package Received-Outer Packaging NOT Tampered">Delivery-Empty Package Received-Outer Packaging NOT Tampered</option>
												<option value="Delivery-Incomplete Order received - Product(s) missing from shipment-Outer Packaging NOT Tampered">Delivery-Incomplete Order received - Product(s) missing from shipment-Outer Packaging NOT Tampered</option>
												<option value="Delivery-Incomplete Order received - Unit(s) missing from a Set/Pack-Outer Packaging NOT Tampered">Delivery-Incomplete Order received - Unit(s) missing from a Set/Pack-Outer Packaging NOT Tampered</option>
												<option value="Return-Reached Warehouse - Refund not Initiated-Excess product handed over">Return-Reached Warehouse - Refund not Initiated-Excess product handed over</option>
												<option value="Delivery-Empty Package Received-Outer Packaging NOT Tampered">Delivery-Empty Package Received-Outer Packaging NOT Tampered</option>
												<option value="Delivery-Empty Package Received-Outer Packaging Tampered">Delivery-Empty Package Received-Outer Packaging Tampered</option>
												<option value="Delivery-Empty Package Received – RJ(Jewels)-Outer Packaging NOT Tampered">Delivery-Empty Package Received – RJ(Jewels)-Outer Packaging NOT Tampered</option>
												<option value="Delivery-Empty Package Received – RJ(Jewels)-Outer Packaging Tampered">Delivery-Empty Package Received – RJ(Jewels)-Outer Packaging Tampered</option>
												<option value="Delivery-Incomplete Order received - Unit(s) missing from a Set/Pack-Outer Package Tampered">Delivery-Incomplete Order received - Unit(s) missing from a Set/Pack-Outer Package Tampered</option>
												<option value="Delivery-Incomplete Order received - Product(s) missing from shipment-Outer Package Tampered">Delivery-Incomplete Order received - Product(s) missing from shipment-Outer Package Tampered</option>
												<option value="Delivery-Incomplete Order received - item(s) missing from an outfit/dress-Outer Package Tampered">Delivery-Incomplete Order received - item(s) missing from an outfit/dress-Outer Package Tampered</option>
												<option value="Feedback-Suggestions about Convenience charge-NA">Feedback-Suggestions about Convenience charge-NA</option>
												<option value="Price-What's the price for this order?-Guided Customer on Delivery charge">Price-What's the price for this order?-Guided Customer on Delivery charge</option>
												<option value="Price-What's the price for this order?-Guided Customer on COD charge">Price-What's the price for this order?-Guided Customer on COD charge</option>
												<option value="Price-What's the price for this order?-Guided Customer on Fulfilment Convenience charge">Price-What's the price for this order?-Guided Customer on Fulfilment Convenience charge</option>
												<option value="Goodwill Request-CM insisting Compensation-Convenience Charge">Goodwill Request-CM insisting Compensation-Convenience Charge</option>
												<option value="Other-I want convenience charge-Convinced the customer - No Action Required">Other-I want convenience charge-Convinced the customer - No Action Required</option>
												<option value="Ticket-Cx-Ticket Follow up - within TAT-Return related">Ticket-Cx-Ticket Follow up - within TAT-Return related</option>
												<option value="Ticket-Cx-Ticket Follow up - within TAT-Pickup related">Ticket-Cx-Ticket Follow up - within TAT-Pickup related</option>
												<option value="Ticket-Cx-Ticket Follow up - within TAT-Others">Ticket-Cx-Ticket Follow up - within TAT-Others</option>
												<option value="Ticket-Cx-Ticket Follow up - within TAT-Missing Product related">Ticket-Cx-Ticket Follow up - within TAT-Missing Product related</option>
												<option value="Ticket-Cx-Ticket Follow up - within TAT-Refund related">Ticket-Cx-Ticket Follow up - within TAT-Refund related</option>
												<option value="Ticket-Cx-Ticket Follow up - within TAT-Website related">Ticket-Cx-Ticket Follow up - within TAT-Website related</option>
												<option value="Ticket-Cx-Ticket Follow up - TAT Breached-Others">Ticket-Cx-Ticket Follow up - TAT Breached-Others</option>
												<option value="Ticket-Cx-Ticket Follow up - TAT Breached-Return related">Ticket-Cx-Ticket Follow up - TAT Breached-Return related</option>
												<option value="Ticket-Cx-Ticket Follow up - TAT Breached-Delivery related">Ticket-Cx-Ticket Follow up - TAT Breached-Delivery related</option>
												<option value="Ticket-Cx-Ticket Follow up - TAT Breached-Refund related">Ticket-Cx-Ticket Follow up - TAT Breached-Refund related</option>
												<option value="Ticket-Cx-Ticket Follow up - TAT Breached-Missing Product related">Ticket-Cx-Ticket Follow up - TAT Breached-Missing Product related</option>
												<option value="Ticket-Cx-Ticket Follow up - TAT Breached-Website related">Ticket-Cx-Ticket Follow up - TAT Breached-Website related</option>
												<option value="Ticket-Cx-Ticket Follow up - TAT Breached-Pickup related">Ticket-Cx-Ticket Follow up - TAT Breached-Pickup related</option>
												<option value="Ticket-Cx-Ticket Follow up - within TAT-Delivery related">Ticket-Cx-Ticket Follow up - within TAT-Delivery related</option>
												<option value="Callback-Regional Callback-CallBack Needed - Telugu">Callback-Regional Callback-CallBack Needed - Telugu</option>
												<option value="Callback-Regional Callback-CallBack Needed - Tamil">Callback-Regional Callback-CallBack Needed - Tamil</option>
												<option value="Callback-Regional Callback-CallBack Needed - Kannada">Callback-Regional Callback-CallBack Needed - Kannada</option>
												<option value="Account-Suspended Account (Reason for Suspension Required)-Customer wanted Wallet amount transferred">Account-Suspended Account (Reason for Suspension Required)-Customer wanted Wallet amount transferred</option>
												<option value="Account-Suspended Account (Reason for Suspension Required)-Customer wanted to return product">Account-Suspended Account (Reason for Suspension Required)-Customer wanted to return product</option>
												<option value="Account-Suspended Account (Reason for Suspension Required)-Customer wanted to know suspension reason">Account-Suspended Account (Reason for Suspension Required)-Customer wanted to know suspension reason</option>
												<option value="Callback-Regional Callback-CallBack Needed - Malyalam">Callback-Regional Callback-CallBack Needed - Malyalam</option>
												<option value="Order-Excess COD Collected-Informed customer to share image/screenshot">Order-Excess COD Collected-Informed customer to share image/screenshot</option>
												<option value="Marketing-Gift not Received post winning contest-Top Shopper Gift">Marketing-Gift not Received post winning contest-Top Shopper Gift</option>
												<option value="Marketing-Gift not Received post winning contest-High Value Assured Gift - Instant Reward">Marketing-Gift not Received post winning contest-High Value Assured Gift - Instant Reward</option>
												<option value="Marketing-Gift not Received post winning contest-High Value Assured Gift - Reward post return window">Marketing-Gift not Received post winning contest-High Value Assured Gift - Reward post return window</option>
												<option value="Delivery-Incomplete Order received - item(s) missing from an outfit/dress-Outer Packaging NOT Tampered">Delivery-Incomplete Order received - item(s) missing from an outfit/dress-Outer Packaging NOT Tampered</option>
												<option value="Return/Exchange-Return On Hold-Informed about Release/Verification TAT">Return/Exchange-Return On Hold-Informed about Release/Verification TAT</option>
											</select>
										</td>
									</tr>
									<tr>
										<td style="font-weight:bold; font-size:16px; text-align:right">Earned Score:</td>
										<td><input type="text" readonly id="earnedScore" name="data[earned_score]" class="form-control" style="font-weight:bold" value="<?php echo $ajio_inb_v2['earned_score'] ?>"></td>
										<td style="font-weight:bold; font-size:16px; text-align:right">Possible Score:</td>
										<td><input type="text" readonly id="possibleScore" name="data[possible_score]" class="form-control" style="font-weight:bold" value="<?php echo $ajio_inb_v2['possible_score'] ?>"></td>
										<td style="font-weight:bold; font-size:16px; text-align:right">Overall Score:</td>
										<td><input type="text" readonly id="overallScore" name="data[overall_score]" class="form-control ajio_inb_v2Fatal" style="font-weight:bold" value="<?php echo $ajio_inb_v2['overall_score'] ?>"></td>
									</tr>
									<tr style="font-weight:bold">
										<td><input type="hidden" class="form-control" id="prefatal" name="data[pre_fatal_score]" value="<?php echo $ajio_inb_v2['pre_fatal_score'] ?>"></td>
										<td><input type="hidden" class="form-control" id="fatalcount" name="data[fatal_count]" value="<?php echo $ajio_inb_v2['fatal_count'] ?>"></td>
									</tr>
									<tr style="background-color:#85C1E9; font-weight:bold">
										<td>Parameter</td>
										<td colspan=>Sub Parameter</td>
										<td>Defect</td>
										<td>Points</td>
										<td>L1 Reason</td>
										<td>L2 Reason</td>
									</tr>
									<tr>
										<td rowspan=4 style="background-color:#85C1E9; font-weight:bold">Call Quality & Ettiquettes</td>
										<td  style="color:red">Did the champ open the call within 4 seconds and introduce himself properly</td>
										<td>
											<select class="form-control ajio fatal ajioAF1" id="ajioAF1_inb_v2" name="data[open_call_within_4sec]" required>
												<option ajio_val=5 ajio_max=5 <?php echo $ajio_inb_v2['open_call_within_4sec'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ajio_val=0 ajio_max=5 <?php echo $ajio_inb_v2['open_call_within_4sec'] == "No"?"selected":"";?> value="No">No</option>
												<option ajio_val=0 ajio_max=5 <?php echo $ajio_inb_v2['open_call_within_4sec'] == "Autofail"?"selected":"";?> value="Autofail">Autofail</option>
											</select>
										</td>
										<td>5</td>
										<!-- <td><textarea class="form-control" name="data[l1_reason1]"><?php //echo $ajio_inb_v2['l1_reason1'] ?></textarea></td> -->
										<td>
											
											<select class="form-control" id="AF1_inb_v2" name="data[l1_reason1]" required>
												<?php 
												if($ajio_inb_v2['l1_reason1']!=''){
													?>
													<option value="<?php echo $ajio_inb_v2['l1_reason1'] ?>"><?php echo $ajio_inb_v2['l1_reason1'] ?></option>
													<?php
												}
												?>
												<option  <?php echo $ajio_inb_v2['l1_reason1'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
												
											</select>
										</td>
										<td><textarea class="form-control" name="data[l2_reason1]"><?php echo $ajio_inb_v2['l2_reason1'] ?></textarea></td>
									</tr>
									<tr>
										<td >Did the champ address the customer by name</td>
										<td>
											<select class="form-control ajio" id="address_customer_inb_v2" name="data[address_customer_by_name]" required>
												<option ajio_val=5 ajio_max=5 <?php echo $ajio_inb_v2['address_customer_by_name'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ajio_val=0 ajio_max=5 <?php echo $ajio_inb_v2['address_customer_by_name'] == "No"?"selected":"";?> value="No">No</option>
											</select>
										</td>
										<td>5</td>
										<!-- <td><textarea class="form-control" name="data[l1_reason2]"><?php //echo $ajio_inb_v2['l1_reason2'] ?></textarea></td> -->
										<td>
											
											<select class="form-control" id="address_inb_v2" name="data[l1_reason2]" required>
												<?php 
												if($ajio_inb_v2['l1_reason2']!=''){
													?>
													<option value="<?php echo $ajio_inb_v2['l1_reason2'] ?>"><?php echo $ajio_inb_v2['l1_reason2'] ?></option>
													<?php
												}
												?>
												<option  <?php echo $ajio_inb_v2['l1_reason2'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
												
											</select>
										</td>
										<td><textarea class="form-control" name="data[l2_reason2]"><?php echo $ajio_inb_v2['l2_reason2'] ?></textarea></td>
									</tr>
									<tr>
										<td  style="color:red">Champ followed the hold procedure as per the SOP</td>
										<td>
											<select class="form-control ajio fatal ajioAF2" id="ajioAF2_inb_v2" name="data[follow_hold_procedure]" required>
												<option ajio_val=5 ajio_max=5 <?php echo $ajio_inb_v2['follow_hold_procedure'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ajio_val=0 ajio_max=5 <?php echo $ajio_inb_v2['follow_hold_procedure'] == "No"?"selected":"";?> value="No">No</option>
												<!-- <option ajio_val=0 ajio_max=5 <?php //echo $ajio_inb_v2['follow_hold_procedure'] == "Unwarranted Hold"?"selected":"";?> value="Unwarranted Hold">Unwarranted Hold</option>
												<option ajio_val=0 ajio_max=5 <?php //echo $ajio_inb_v2['follow_hold_procedure'] == "Dead Air"?"selected":"";?> value="Dead Air">Dead Air</option>
												<option ajio_val=0 ajio_max=5 <?php //echo $ajio_inb_v2['follow_hold_procedure'] == "Uninformed Hold"?"selected":"";?> value="Uninformed Hold">Uninformed Hold</option>
												<option ajio_val=0 ajio_max=5 <?php //echo $ajio_inb_v2['follow_hold_procedure'] == "Uninformed Absence/mute"?"selected":"";?> value="Uninformed Absence/mute">Uninformed Absence/mute</option>
												<option ajio_val=0 ajio_max=5 <?php //echo $ajio_inb_v2['follow_hold_procedure'] == "Hold not refreshed withinh stipulated time"?"selected":"";?> value="Hold not refreshed withinh stipulated time">Hold not refreshed withinh stipulated time</option>
												<option ajio_val=0 ajio_max=5 <?php //echo $ajio_inb_v2['follow_hold_procedure'] == "Hold script/procedure not adhered"?"selected":"";?> value="Hold script/procedure not adhered">Hold script/procedure not adhered</option> -->
												<option ajio_val=0 ajio_max=5 <?php echo $ajio_inb_v2['follow_hold_procedure'] == "Autofail"?"selected":"";?> value="Autofail">Autofail</option>
											</select>
										</td>
										<td>5</td>
										<!-- <td><textarea class="form-control" name="data[l1_reason3]"><?php //echo $ajio_inb_v2['l1_reason3'] ?></textarea></td> -->
										<td>
											
											<select class="form-control" id="AF2_inb_v2" name="data[l1_reason3]" required>
												<?php 
												if($ajio_inb_v2['l1_reason3']!=''){
													?>
													<option value="<?php echo $ajio_inb_v2['l1_reason3'] ?>"><?php echo $ajio_inb_v2['l1_reason3'] ?></option>
													<?php
												}
												?>
												<option  <?php echo $ajio_inb_v2['l1_reason3'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
												
											</select>
										</td>
										<td><textarea class="form-control" name="data[l2_reason3]"><?php echo $ajio_inb_v2['l2_reason3'] ?></textarea></td>
									</tr>
									<tr>
										<td  style="">Did the champ offer further assistance and follow appropriate call closure/supervisor transfer process</td>
										<td>
											<select class="form-control ajio" id="ajioAF3_inb_v2" name="data[follow_appropiate_call_closure]" required>
												<option ajio_val=5 ajio_max=5 <?php echo $ajio_inb_v2['follow_appropiate_call_closure'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ajio_val=0 ajio_max=5 <?php echo $ajio_inb_v2['follow_appropiate_call_closure'] == "No"?"selected":"";?> value="No">No</option>
												
												<!-- <option ajio_val=0 ajio_max=5 <?php //echo $ajio_inb_v2['follow_appropiate_call_closure'] == "Autofail"?"selected":"";?> value="Autofail">Autofail</option> -->
											</select>
										</td>
										<td>5</td>
										<!-- <td><textarea class="form-control" name="data[l1_reason4]"><?php //echo $ajio_inb_v2['l1_reason4'] ?></textarea></td> -->
										<td>
											
											<select class="form-control" id="AF3_inb_v2" name="data[l1_reason4]" required>
												<?php 
												if($ajio_inb_v2['l1_reason4']!=''){
													?>
													<option value="<?php echo $ajio_inb_v2['l1_reason4'] ?>"><?php echo $ajio_inb_v2['l1_reason4'] ?></option>
													<?php
												}
												?>
												<option  <?php echo $ajio_inb_v2['l1_reason4'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
												
											</select>
										</td>
										<td><textarea class="form-control" name="data[l2_reason4]"><?php echo $ajio_inb_v2['l2_reason4'] ?></textarea></td>
									</tr>
									<tr>
										<td rowspan=5 style="background-color:#85C1E9; font-weight:bold">Communication Skills</td>
										<td >Was the champ polite and used apology and assurance wherever required</td>
										<td>
											<select class="form-control ajio" id="polite_appology_inb_v2" name="data[polite_use_appology]" required>
												<option ajio_val=5 ajio_max=5 <?php echo $ajio_inb_v2['polite_use_appology'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<!-- <option ajio_val=0 ajio_max=5 <?php //echo $ajio_inb_v2['polite_use_appology'] == "Apology used but misplaced"?"selected":"";?> value="Apology used but misplaced">Apology used but misplaced</option>
												<option ajio_val=0 ajio_max=5 <?php //echo $ajio_inb_v2['polite_use_appology'] == "Did not provide effective assurance"?"selected":"";?> value="Did not provide effective assurance">Did not provide effective assurance</option>
												<option ajio_val=0 ajio_max=5 <?php //echo $ajio_inb_v2['polite_use_appology'] == "Did not acknowledge/apologize when required"?"selected":"";?> value="Did not acknowledge/apologize when required">Did not acknowledge/apologize when required</option>
												<option ajio_val=0 ajio_max=5 <?php //echo $ajio_inb_v2['polite_use_appology'] == "Lack of pleasantries"?"selected":"";?> value="Lack of pleasantries">Lack of pleasantries</option> -->
												<option ajio_val=0 ajio_max=5 <?php echo $ajio_inb_v2['polite_use_appology'] == "No"?"selected":"";?> value="No">No</option>
											</select>
										</td>
										<td>5</td>
										<!-- <td><textarea class="form-control" name="data[l1_reason5]"><?php echo $ajio_inb_v2['l1_reason5'] ?></textarea></td> -->
										<td>
											
											<select class="form-control" id="appology_inb_v2" name="data[l1_reason5]" required>
												<?php 
												if($ajio_inb_v2['l1_reason5']!=''){
													?>
													<option value="<?php echo $ajio_inb_v2['l1_reason5'] ?>"><?php echo $ajio_inb_v2['l1_reason5'] ?></option>
													<?php
												}
												?>
												<option  <?php echo $ajio_inb_v2['l1_reason5'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
												
											</select>
										</td>
										<td><textarea class="form-control" name="data[l2_reason5]"><?php echo $ajio_inb_v2['l2_reason5'] ?></textarea></td>
									</tr>
									<tr>
										<td >Was the champ able to comprehend and paraphrase the customer's concern</td>
										<td>
											<select class="form-control ajio" id="comprehend_concern_inb_v2" name="data[comprehend_customer_concern]" required>
												<option ajio_val=10 ajio_max=10 <?php echo $ajio_inb_v2['comprehend_customer_concern'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<!-- <option ajio_val=0 ajio_max=10 <?php //echo $ajio_inb_v2['comprehend_customer_concern'] == "Asked unnecessary/irrelevant questions"?"selected":"";?> value="Asked unnecessary/irrelevant questions">Asked unnecessary/irrelevant questions</option>
												<option ajio_val=0 ajio_max=10 <?php //echo $ajio_inb_v2['comprehend_customer_concern'] == "Asked details already available"?"selected":"";?> value="Asked details already available">Asked details already available</option>
												<option ajio_val=0 ajio_max=10 <?php //echo $ajio_inb_v2['comprehend_customer_concern'] == "Unable to comprehend"?"selected":"";?> value="Unable to comprehend">Unable to comprehend</option>
												<option ajio_val=0 ajio_max=10 <?php //echo $ajio_inb_v2['comprehend_customer_concern'] == "Failed to paraphrase to ensure understanding"?"selected":"";?> value="Failed to paraphrase to ensure understanding">Failed to paraphrase to ensure understanding</option> -->
												<option ajio_val=0 ajio_max=10 <?php echo $ajio_inb_v2['comprehend_customer_concern'] == "No"?"selected":"";?> value="No">No</option>
											</select>
										</td>
										<td>10</td>
										<!-- <td><textarea class="form-control" name="data[l1_reason6]"><?php //echo $ajio_inb_v2['l1_reason6'] ?></textarea></td> -->
										<td>
											
											<select class="form-control" id="comprehend_inb_v2" name="data[l1_reason6]" required>
												<?php 
												if($ajio_inb_v2['l1_reason6']!=''){
													?>
													<option value="<?php echo $ajio_inb_v2['l1_reason6'] ?>"><?php echo $ajio_inb_v2['l1_reason6'] ?></option>
													<?php
												}
												?>
												<option  <?php echo $ajio_inb_v2['l1_reason6'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
												
											</select>
										</td>
										<td><textarea class="form-control" name="data[l2_reason6]"><?php echo $ajio_inb_v2['l2_reason6'] ?></textarea></td>
									</tr>
									<tr>
										<td >Did the champ display active listening skills without making the customer repeat</td>
										<td>
											<select class="form-control ajio" id="listening_skill_inb_v2" name="data[display_active_listening_skill]" required>
												<option ajio_val=5 ajio_max=5 <?php echo $ajio_inb_v2['display_active_listening_skill'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<!-- <option ajio_val=0 ajio_max=5 <?php //echo $ajio_inb_v2['display_active_listening_skill'] == "Champ made the customer repeat"?"selected":"";?> value="Champ made the customer repeat">Champ made the customer repeat</option>
												<option ajio_val=0 ajio_max=5 <?php //echo $ajio_inb_v2['display_active_listening_skill'] == "Did not listen actively impacting the call"?"selected":"";?> value="Did not listen actively impacting the call">Did not listen actively impacting the call</option> -->
												<option ajio_val=0 ajio_max=5 <?php echo $ajio_inb_v2['display_active_listening_skill'] == "No"?"selected":"";?> value="No">No</option>
											</select>
										</td>
										<td>5</td>
										<!-- <td><textarea class="form-control" name="data[l1_reason7]"><?php //echo $ajio_inb_v2['l1_reason7'] ?></textarea></td> -->
										<td>
											
											<select class="form-control" id="skill_inb_v2" name="data[l1_reason7]" required>
												<?php 
												if($ajio_inb_v2['l1_reason7']!=''){
													?>
													<option value="<?php echo $ajio_inb_v2['l1_reason7'] ?>"><?php echo $ajio_inb_v2['l1_reason7'] ?></option>
													<?php
												}
												?>
												<option  <?php echo $ajio_inb_v2['l1_reason7'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
												
											</select>
										</td>
										<td><textarea class="form-control" name="data[l2_reason7]"><?php echo $ajio_inb_v2['l2_reason7'] ?></textarea></td>
									</tr>
									<tr>
										<td >Was the champ able to handle objections effectively and offer rebuttals wherever required</td>
										<td>
											<select class="form-control ajio" id="handle_objection_inb_v2" name="data[handle_objection_effectively]" required>
												<option ajio_val=10 ajio_max=10 <?php echo $ajio_inb_v2['handle_objection_effectively'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ajio_val=0 ajio_max=10 <?php echo $ajio_inb_v2['handle_objection_effectively'] == "No"?"selected":"";?> value="No">No</option>
												<!-- <option ajio_val=10 ajio_max=10 <?php echo $ajio_inb_v2['handle_objection_effectively'] == "N/A"?"selected":"";?> value="N/A">N/A</option> -->
											</select>
										</td>
										<td>10</td>
										<!-- <td><textarea class="form-control" name="data[l1_reason8]"><?php //echo $ajio_inb_v2['l1_reason8'] ?></textarea></td> -->
										<td>
											
											<select class="form-control" id="objection_inb_v2" name="data[l1_reason8]" required>
												<?php 
												if($ajio_inb_v2['l1_reason8']!=''){
													?>
													<option value="<?php echo $ajio_inb_v2['l1_reason8'] ?>"><?php echo $ajio_inb_v2['l1_reason8'] ?></option>
													<?php
												}
												?>
												<option  <?php echo $ajio_inb_v2['l1_reason8'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
												
											</select>
										</td>
										<td><textarea class="form-control" name="data[l2_reason8]"><?php echo $ajio_inb_v2['l2_reason8'] ?></textarea></td>
									</tr>
									<tr>
										<td >Was champ able to express/articulate himself and seamlessly converse with the customer</td>
										<td>
											<select class="form-control ajio" id="express_himself_inb_v2" name="data[express_himself_with_customer]" required>
												<option ajio_val=10 ajio_max=10 <?php echo $ajio_inb_v2['express_himself_with_customer'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<!-- <option ajio_val=0 ajio_max=10 <?php //echo $ajio_inb_v2['express_himself_with_customer'] == "Champ was struggling to express himself"?"selected":"";?> value="Champ was struggling to express himself">Champ was struggling to express himself</option>
												<option ajio_val=0 ajio_max=10 <?php //echo $ajio_inb_v2['express_himself_with_customer'] == "Champ swtiched language to express himself"?"selected":"";?> value="Champ swtiched language to express himself">Champ swtiched language to express himself</option>
												<option ajio_val=0 ajio_max=10 <?php //echo $ajio_inb_v2['express_himself_with_customer'] == "Customer expressed difficulty in understanding the champ"?"selected":"";?> value="Customer expressed difficulty in understanding the champ">Customer expressed difficulty in understanding the champ</option> -->
												<option ajio_val=0 ajio_max=10 <?php echo $ajio_inb_v2['express_himself_with_customer'] == "No"?"selected":"";?> value="No">No</option>
											</select>
										</td>
										<td>10</td>
										<!-- <td><textarea class="form-control" name="data[l1_reason9]"><?php //echo $ajio_inb_v2['l1_reason9'] ?></textarea></td> -->
										<td>
											
											<select class="form-control" id="himself_inb_v2" name="data[l1_reason9]" required>
												<?php 
												if($ajio_inb_v2['l1_reason9']!=''){
													?>
													<option value="<?php echo $ajio_inb_v2['l1_reason9'] ?>"><?php echo $ajio_inb_v2['l1_reason9'] ?></option>
													<?php
												}
												?>
												<option  <?php echo $ajio_inb_v2['l1_reason9'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
												
											</select>
										</td>
										<td><textarea class="form-control" name="data[l2_reason9]"><?php echo $ajio_inb_v2['l2_reason9'] ?></textarea></td>
									</tr>
									<tr>
										<td rowspan=4 style="background-color:#85C1E9; font-weight:bold">Effective System Navigation & KM Usage</td>
										<td >Did the champ refer to all relevant articles/T2Rs correctly</td>
										<td>
											<select class="form-control ajio" id="releavnt_article_inb_v2" name="data[refer_all_releavnt_article]" required>
												<option ajio_val=5 ajio_max=5 <?php echo $ajio_inb_v2['refer_all_releavnt_article'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ajio_val=0 ajio_max=5 <?php echo $ajio_inb_v2['refer_all_releavnt_article'] == "No"?"selected":"";?> value="No">No</option>
											</select>
										</td>
										<td>5</td>
										<!-- <td><textarea class="form-control" name="data[l1_reason10]"><?php //echo $ajio_inb_v2['l1_reason10'] ?></textarea></td> -->
										<td>
											
											<select class="form-control" id="article_inb_v2" name="data[l1_reason10]" required>
												<?php 
												if($ajio_inb_v2['l1_reason10']!=''){
													?>
													<option value="<?php echo $ajio_inb_v2['l1_reason10'] ?>"><?php echo $ajio_inb_v2['l1_reason10'] ?></option>
													<?php
												}
												?>
												<option  <?php echo $ajio_inb_v2['l1_reason10'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
												
											</select>
										</td>
										<td><textarea class="form-control" name="data[l2_reason10]"><?php echo $ajio_inb_v2['l2_reason10'] ?></textarea></td>
									</tr>
									<tr>
										<td >Did the champ refer to different applications/portals/tools to identify the root cause of customer issue and enable resolution</td>
										<td>
											<select class="form-control ajio" id="different_application_inb_v2" name="data[refer_different_application]" required>
												<option ajio_val=5 ajio_max=5 <?php echo $ajio_inb_v2['refer_different_application'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ajio_val=0 ajio_max=5 <?php echo $ajio_inb_v2['refer_different_application'] == "No"?"selected":"";?> value="No">No</option>
											</select>
										</td>
										<td>5</td>
										<!-- <td><textarea class="form-control" name="data[l1_reason11]"><?php //echo $ajio_inb_v2['l1_reason11'] ?></textarea></td> -->
										<td>
											
											<select class="form-control" id="application_inb_v2" name="data[l1_reason11]" required>
												<?php 
												if($ajio_inb_v2['l1_reason11']!=''){
													?>
													<option value="<?php echo $ajio_inb_v2['l1_reason11'] ?>"><?php echo $ajio_inb_v2['l1_reason11'] ?></option>
													<?php
												}
												?>
												<option  <?php echo $ajio_inb_v2['l1_reason11'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
												
											</select>
										</td>
										<td><textarea class="form-control" name="data[l2_reason11]"><?php echo $ajio_inb_v2['l2_reason11'] ?></textarea></td>
									</tr>
									<tr>
										<td  style="color:red">Call/Interaction was authenticated wherever required</td>
										<td>
											<select class="form-control ajio fatal ajioAF9" id="ajioAF4_inb_v2" name="data[call_was_authenticated]" required>
												<option ajio_val=5 ajio_max=5 <?php echo $ajio_inb_v2['call_was_authenticated'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ajio_val=0 ajio_max=5 <?php echo $ajio_inb_v2['call_was_authenticated'] == "No"?"selected":"";?> value="No">No</option>
												<option ajio_val=0 ajio_max=5 <?php echo $ajio_inb_v2['call_was_authenticated'] == "Autofail"?"selected":"";?> value="Autofail">Autofail</option>
											</select>
										</td>
										<td>5</td>
										<!-- <td><textarea class="form-control" name="data[l1_reason12]"><?php //echo $ajio_inb_v2['l1_reason12'] ?></textarea></td> -->
										<td>
											
											<select class="form-control" id="AF4_inb_v2" name="data[l1_reason12]" required>
												<?php 
												if($ajio_inb_v2['l1_reason12']!=''){
													?>

													<option value="<?php echo $ajio_inb_v2['l1_reason12'] ?>"><?php echo $ajio_inb_v2['l1_reason12'] ?></option>
													<?php
												}
												?>
												<option  <?php echo $ajio_inb_v2['l1_reason12'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
												
											</select>
										</td>
										<td><textarea class="form-control" name="data[l2_reason12]"><?php echo $ajio_inb_v2['l2_reason12'] ?></textarea></td>
									</tr>
									<tr>
										<td >Was the champ able to effectively navigate through and toggle between different tools/aids to wrap up the call in a timely manner</td>
										<td>
											<select class="form-control ajio" id="navigate_through_inb_v2" name="data[effectively_navigate_through]" required>
												<option ajio_val=5 ajio_max=5 <?php echo $ajio_inb_v2['effectively_navigate_through'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ajio_val=0 ajio_max=5 <?php echo $ajio_inb_v2['effectively_navigate_through'] == "No"?"selected":"";?> value="No">No</option>
											</select>
										</td>
										<td>5</td>
										<!-- <td><textarea class="form-control" name="data[l1_reason13]"><?php //echo $ajio_inb_v2['l1_reason13'] ?></textarea></td> -->
										<td>
											
											<select class="form-control" id="through_inb_v2" name="data[l1_reason13]" required>
												<?php 
												if($ajio_inb_v2['l1_reason13']!=''){
													?>
													<option value="No navigation observed during hold" <?= ($ajio_inb_v2['l1_reason13']=="No navigation observed during hold")?"selected":"" ?>>No navigation observed during hold</option>
													<option value="Viewed application/s not relevent to the interaction - Impacted AHT" <?= ($ajio_inb_v2['l1_reason13']=="Viewed application/s not relevent to the interaction - Impacted AHT")?"selected":"" ?>>Viewed application/s not relevent to the interaction - Impacted AHT</option>
													<option value="Didn't transfer the call to TNPS survey after pitching script - >2 seconds" <?= ($ajio_inb_v2['l1_reason13']=="Didn't transfer the call to TNPS survey after pitching script - >2 seconds")?"selected":"" ?>>Didn't transfer the call to TNPS survey after pitching script - >2 seconds</option>

													<!-- <option value="<?php //echo $ajio_inb_v2['l1_reason13'] ?>"><?php //echo $ajio_inb_v2['l1_reason13'] ?></option> -->
													
													<?php
												}
												?>
												<option  <?php echo $ajio_inb_v2['l1_reason13'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
												
											</select>
										</td>
										<td><textarea class="form-control" name="data[l2_reason13]"><?php echo $ajio_inb_v2['l2_reason13'] ?></textarea></td>
									</tr>
									<tr>
										<td rowspan=3 style="background-color:#85C1E9; font-weight:bold">Issue Resolution</td>
										<td  style="color:red">Champ executed all necessary actions to ensure issue resolution</td>
										<td>
											<select class="form-control ajio fatal ajioAF5" id="ajioAF5_inb_v2" name="data[executed_all_necessary]" required>
												<option ajio_val=5 ajio_max=5 <?php echo $ajio_inb_v2['executed_all_necessary'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
											<option ajio_val=0 ajio_max=5 <?php echo $ajio_inb_v2['executed_all_necessary'] == "No"?"selected":"";?> value="No">No</option>
												<option ajio_val=0 ajio_max=5 <?php echo $ajio_inb_v2['executed_all_necessary'] == "Autofail"?"selected":"";?> value="Autofail">Autofail</option>
											</select>
										</td>
										<td>5</td>
										<td>
											
											<select class="form-control" id="AF5_inb_v2" name="data[l1_reason14]" required>
												<?php 
												if($ajio_inb_v2['l1_reason14']!=''){
													?>
													<option value="<?php echo $ajio_inb_v2['l1_reason14'] ?>"><?php echo $ajio_inb_v2['l1_reason14'] ?></option>
													<?php
												}
												?>
												<option  <?php echo $ajio_inb_v2['l1_reason14'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
												
											</select>
										</td>
										<td><textarea class="form-control" name="data[l2_reason14]"><?php echo $ajio_inb_v2['l2_reason14'] ?></textarea></td>
									</tr>
									<tr>
										<td  style="color:red">All the queries were answered properly and in an informative way to avoid repeat call. Champ provided a clear understanding of action taken and the way forward to the customer</td>
										<td>
											<select class="form-control ajio ajioAF6" id="ajioAF6_inb_v2" name="data[queries_answered_properly]" required>
												<option ajio_val=10 ajio_max=10 <?php echo $ajio_inb_v2['queries_answered_properly'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ajio_val=0 ajio_max=10 <?php echo $ajio_inb_v2['queries_answered_properly'] == "No"?"selected":"";?> value="No">No</option>
												<option ajio_val=0 ajio_max=10 <?php echo $ajio_inb_v2['queries_answered_properly'] == "Autofail"?"selected":"";?> value="Autofail">Autofail</option>
											</select>
										</td>
										<!-- <td>
											<textarea class="form-control" name="data[l1_reason15]"><?php //echo $ajio_inb_v2['l1_reason15'] ?></textarea>
											<select class="form-control" name="data[l1_reason15]" >
												<option value=""></option>
												<option <?php //echo $ajio_inb_v2['l1_reason15'] == "Incorrect information Shared"?"selected":"";?> value="Incorrect information Shared">Incorrect information Shared</option>
												<option <?php //echo $ajio_inb_v2['l1_reason15'] == "Incomplete information Shared"?"selected":"";?> value="Incomplete information Shared">Incomplete information Shared</option>
												<option <?php //echo $ajio_inb_v2['l1_reason15'] == "Wrong action taken & No action taken"?"selected":"";?> value="Wrong action taken & No action taken">Wrong action taken & No action taken</option>
											</select>
										</td> -->
										<td>10</td>
										<td>
											
											<select class="form-control" id="AF6_inb_v2" name="data[l1_reason15]" required>
												<?php 
												if($ajio_inb_v2['l1_reason15']!=''){
													?>
													<option value="<?php echo $ajio_inb_v2['l1_reason15'] ?>"><?php echo $ajio_inb_v2['l1_reason15'] ?></option>
													<?php
												}
												?>
												<option  <?php echo $ajio_inb_v2['l1_reason15'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
												
											</select>
										</td>
										<td><textarea class="form-control" name="data[l2_reason15]"><?php echo $ajio_inb_v2['l2_reason15'] ?></textarea></td>
									</tr>
									<tr>
										<td  style="color:red">Did the champ document the case correctly and adhered to tagging guidelines</td>
										<td>
											<select class="form-control ajio fatal ajioAF7" id="ajioAF7_inb_v2" name="data[document_the_case_correctly]" required>
												<option ajio_val=5 ajio_max=5 <?php echo $ajio_inb_v2['document_the_case_correctly'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ajio_val=0 ajio_max=5 <?php echo $ajio_inb_v2['document_the_case_correctly'] == "No"?"selected":"";?> value="No">No</option>
												<!-- <option ajio_val=0 ajio_max=5 <?php //echo $ajio_inb_v2['document_the_case_correctly'] == "CAM rule not adhered to"?"selected":"";?> value="CAM rule not adhered to">CAM rule not adhered to</option>
												<option ajio_val=0 ajio_max=5 <?php //echo $ajio_inb_v2['document_the_case_correctly'] == "Documented on incorrect account"?"selected":"";?> value="Documented on incorrect account">Documented on incorrect account</option>
												<option ajio_val=0 ajio_max=5 <?php//// echo $ajio_inb_v2['document_the_case_correctly'] == "All queries not documented"?"selected":"";?> value="All queries not documented">All queries not documented</option> -->
												<option ajio_val=0 ajio_max=5 <?php echo $ajio_inb_v2['document_the_case_correctly'] == "Autofail"?"selected":"";?> value="Autofail">Autofail</option>
											</select>
										</td>
										<td>5</td>
										<!-- <td><textarea class="form-control" name="data[l1_reason16]"><?php //echo $ajio_inb_v2['l1_reason16'] ?></textarea></td> -->
										<td>
											
											<select class="form-control" id="AF7_inb_v2" name="data[l1_reason16]" required>
												<?php 
												if($ajio_inb_v2['l1_reason16']!=''){
													?>
													<option value="<?php echo $ajio_inb_v2['l1_reason16'] ?>"><?php echo $ajio_inb_v2['l1_reason16'] ?></option>
													<?php
												}
												?>
												<option  <?php echo $ajio_inb_v2['l1_reason16'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
												
											</select>
										</td>
										<td><textarea class="form-control" name="data[l2_reason16]"><?php echo $ajio_inb_v2['l2_reason16'] ?></textarea></td>
									</tr>
									<tr>
										<td style="background-color:#F1948A; font-weight:bold">ZTP</td>
										<td  style="color:red">As per AJIO ZTP guidelines</td>
										<td>
											<select class="form-control ajio fatal ajioAF8"  id="ajioAF8_inb_v2" name="data[ztp_guidelines]">
												<option ajio_val=0 ajio_max=0 <?php echo $ajio_inb_v2['ztp_guidelines'] == "No"?"selected":"";?> value="No">No</option>
												<option ajio_val=0 ajio_max=0 <?php echo $ajio_inb_v2['ztp_guidelines'] == "Autofail"?"selected":"";?> value="Autofail">Autofail</option>
											</select>
										</td>
										<td>0</td>
										<!-- <td><textarea class="form-control" name="data[l1_reason17]"><?php //echo $ajio_inb_v2['l1_reason17'] ?></textarea></td> -->
										<td>
											
											<select class="form-control" id="AF8_inb_v2" name="data[l1_reason17]" required>
												<?php 
												if($ajio_inb_v2['l1_reason17']!=''){
													?>
													<option value="<?php echo $ajio_inb_v2['l1_reason17'] ?>"><?php echo $ajio_inb_v2['l1_reason17'] ?></option>
													<?php
												}
												?>
												<option  <?php echo $ajio_inb_v2['l1_reason17'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
												
											</select>
										</td>
										<td><textarea class="form-control" name="data[l2_reason17]"><?php echo $ajio_inb_v2['l2_reason17'] ?></textarea></td>
									</tr>
									<tr>
										<td>Call Summary:</td>
										<td colspan=5><textarea class="form-control" name="data[call_synopsis]"><?php echo $ajio_inb_v2['call_synopsis'] ?></textarea></td>
									</tr>
									<tr>
										<td>Call Observation:</td>
										<td colspan=2><textarea class="form-control" name="data[call_summary]"><?php echo $ajio_inb_v2['call_summary'] ?></textarea></td>
										<td>Feedback:</td>
										<td colspan=2><textarea class="form-control" name="data[feedback]"><?php echo $ajio_inb_v2['feedback'] ?></textarea></td>
									</tr>
									<tr>
										<td colspan=2>Upload Files [m4a,mp4,mp3,wav]</td>
										<?php if($ajio_id==0){ ?>
											<td colspan=4><input type="file" multiple class="form-control" id="attach_file" name="attach_file[]" accept=".m4a,.mp4,.mp3,.wav,audio/*" ></td>
										<?php }else{
											if($ajio_inb_v2['attach_file']!=''){ ?>
												<td colspan=4>
													<input type="file" multiple class="form-control"  id="attach_file" name="attach_file[]" accept=".m4a,.mp4,.mp3,.wav,audio/*"> 
													<?php $attach_file = explode(",",$ajio_inb_v2['attach_file']);
													 foreach($attach_file as $mp){ ?>
														<audio controls='' style="background-color:#607F93"> 
														  <source src="<?php echo base_url(); ?>qa_files/qa_ajio/inbound/<?php echo $mp; ?>" type="audio/ogg">
														  <source src="<?php echo base_url(); ?>qa_files/qa_ajio/inbound/<?php echo $mp; ?>" type="audio/mpeg">
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
									
									<?php if($ajio_id!=0){ ?>
										<tr><td colspan=2 style="font-size:16px; font-weight:bold">Agent Feedback Acceptance:</td><td colspan=4><?php echo $ajio_inb_v2['agnt_fd_acpt'] ?></td></tr>
										<tr><td colspan=2 style="font-size:16px; font-weight:bold">Agent Review:</td><td colspan=4><?php echo $ajio_inb_v2['agent_rvw_note'] ?></td></tr>
										<tr><td colspan=2 style="font-size:16px; font-weight:bold">Management Review:</td><td colspan=4><?php echo $ajio_inb_v2['mgnt_rvw_note'] ?></td></tr>
										<tr><td colspan=2 style="font-size:16px; font-weight:bold">Client Review:</td><td colspan=4><?php echo $ajio_inb_v2['client_rvw_note'] ?></td></tr>
										
										<tr><td colspan=2  style="font-size:16px">Your Review</td><td colspan=4><textarea class="form-control1" style="width:100%" id="note" name="note" required></textarea></td></tr>
									<?php } ?>
									
									<?php 
									if($ajio_id==0){
										if(is_access_qa_module()==true || is_access_qa_operations_module()==true){ ?>
											<tr><td colspan=6><button class="btn btn-success waves-effect" type="submit" id="qaformsubmit" style="width:500px">SAVE</button></td></tr>
									<?php 
										} 
									}else{ 
										if(is_access_qa_module()==true || is_access_qa_operations_module()==true){
											if(is_available_qa_feedback($ajio_inb_v2['entry_date'],72) == true){ ?>
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
