
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
										<td>Call ID:</td>
										<td><input type="text" class="form-control" name="data[call_id]" value="<?php echo $ajio_inb_v2['call_id'] ?>" required ></td>
										<td>Call Duration:</td>
										<td><input type="text" class="form-control" id="call_duration" name="data[call_duration]" value="<?php echo $ajio_inb_v2['call_duration'] ?>" required ></td>
								
										<td>Type of Audit:</td>
										<td>
											<select class="form-control" id="type_of_audit" name="data[type_of_audit]" required>
												<option value="<?php echo $ajio_inb_v2['type_of_audit'] ?>"><?php echo $ajio_inb_v2['type_of_audit'] ?></option>
												<option value="">-Select-</option>
												<option value="Detractor Audit">Detractor Audit</option>
												<option value="Passive Audit">Passive Audit</option>
												<option value="Promoter Audit">Promoter Audit</option>
												<option value="High AHT Audit">High AHT Audit</option>
												<option value="Random Audit">Random Audit</option>
												<option value="A2A">A2A</option>
												<option value="Calibration">Calibration</option>
												<option value="WOW Call">WOW Call</option>
											</select>
										</td>
									</tr>
									<tr>
										<td>Predactive CSAT:</td>
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
									
									<tr>
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
									</tr>
									
									<tr>
									<td>Tagging by Evaluator:<span style="font-size:24px;color:red">*</span></td>
										<td colspan="5">
											<select class="form-control agentName" id="tagging_evaluator" name="data[tagging_evaluator]" required>
												<?php 
												if($ajio_inb_v2['tagging_evaluator']!=''){
													?>
													<option value="<?php echo $ajio_inb_v2['tagging_evaluator'] ?>"><?php echo $ajio_inb_v2['tagging_evaluator'] ?></option>
													<?php
												}
												?>
												<option value="">-Select-</option>
												<option value="Query-Refund-Where Is My Refund?-Informed About Refund Tat">Query-Refund-Where Is My Refund?-Informed About Refund Tat</option>
												<option value="Complaint-Delivery-Delayed Delivery-N/A">Complaint-Delivery-Delayed Delivery-N/A</option>
												<option value="Query-Delivery-Where Is My Order?-Informed Promised Delivery Date">Query-Delivery-Where Is My Order?-Informed Promised Delivery Date</option>
												<option value="Proactive Sr-Wh - Order Related Issues-Return To Be Cancelled-Awb Not Cancelled (Pickup Not Required)">Proactive Sr-Wh - Order Related Issues-Return To Be Cancelled-Awb Not Cancelled (Pickup Not Required)</option>
												<option value="Query-Return/Exchange-How Do I Return/Exchange This Item?-Requested Customer To Share The Images">Query-Return/Exchange-How Do I Return/Exchange This Item?-Requested Customer To Share The Images</option>
												<option value="Query-Return/Exchange-Pickup Related-Informed - Product Will Be Picked Up">Query-Return/Exchange-Pickup Related-Informed - Product Will Be Picked Up</option>
												<option value="Complaint-Return-Fake Attempt-N/A">Complaint-Return-Fake Attempt-N/A</option>
												<option value="Query-Refund-Where Is My Refund?-Imps Failed - Requested Customer To Share Neft Details">Query-Refund-Where Is My Refund?-Imps Failed - Requested Customer To Share Neft Details</option>
												<option value="Query-Ticket-Cx-Ticket Follow Up - Within Tat-Delivery Related">Query-Ticket-Cx-Ticket Follow Up - Within Tat-Delivery Related</option>
												<option value="Complaint-Delivery-Fake Attempt-N/A">Complaint-Delivery-Fake Attempt-N/A</option>
												<option value="Query-Ticket-Cx-Ticket Follow Up - Within Tat-Return Related">Query-Ticket-Cx-Ticket Follow Up - Within Tat-Return Related</option>
												<option value="Query-Return/Exchange-How Do I Return/Exchange This Item?-Educated Customer On Self Service Steps">Query-Return/Exchange-How Do I Return/Exchange This Item?-Educated Customer On Self Service Steps</option>
												<option value="Query-Refund-How Long Does It Take To Reflect In Account Once Refund Is Initiated?-Informed Customer Of Time To Refund">Query-Refund-How Long Does It Take To Reflect In Account Once Refund Is Initiated?-Informed Customer Of Time To Refund</option>
												<option value="Complaint-Return-Customer Claiming Product Picked Up-Customer Did Not Have Acknowledgement Copy">Complaint-Return-Customer Claiming Product Picked Up-Customer Did Not Have Acknowledgement Copy</option>
												<option value="Complaint-Return-Pickup Delayed-N/A">Complaint-Return-Pickup Delayed-N/A</option>
												<option value="Query-Return/Exchange-Create A Return For Me-Created Return For Customer">Query-Return/Exchange-Create A Return For Me-Created Return For Customer</option>
												<option value="Complaint-Delivery-Incomplete Order Received - Product(S) Missing From Shipment-Outer Packaging Not Tampered">Complaint-Delivery-Incomplete Order Received - Product(S) Missing From Shipment-Outer Packaging Not Tampered</option>
												<option value="Query-Cancel-Cancel My Return/Exchange-Cancelled The Return /Exchange Request">Query-Cancel-Cancel My Return/Exchange-Cancelled The Return /Exchange Request</option>
												<option value="Complaint-Delivery-Order Not Dispatched From Warehouse-N/A">Complaint-Delivery-Order Not Dispatched From Warehouse-N/A</option>
												<option value="Query-Nar Calls/Emails-Incomplete Call/Email-Call Dropped After Knowing The Query">Query-Nar Calls/Emails-Incomplete Call/Email-Call Dropped After Knowing The Query</option>
												<option value="Query-Refund-My Refund Hasn'T Reflected In Source Account-Provided Reference No. For Cc/Dc/Nb">Query-Refund-My Refund Hasn'T Reflected In Source Account-Provided Reference No. For Cc/Dc/Nb</option>
												<option value="Complaint-Website-Complaint Relating To Website-Unable To Return">Complaint-Website-Complaint Relating To Website-Unable To Return</option>
												<option value="Query-Cancel-I Want To Cancel-Informed Customer To Refuse The Delivery">Query-Cancel-I Want To Cancel-Informed Customer To Refuse The Delivery</option>
												<option value="Complaint-Website-Complaint Relating To Website-Awb Not Assigned">Complaint-Website-Complaint Relating To Website-Awb Not Assigned</option>
												<option value="Query-Return/Exchange-How Do I Return/Exchange This Item?-Informed Return Policy - Products">Query-Return/Exchange-How Do I Return/Exchange This Item?-Informed Return Policy - Products</option>
												<option value="Query-Delivery-I Want Quicker Delivery-Informed About Expediting Policy">Query-Delivery-I Want Quicker Delivery-Informed About Expediting Policy</option>
												<option value="Query-Refund-My Refund Hasn'T Reflected In Source Account-Provided Reference Number For Imps">Query-Refund-My Refund Hasn'T Reflected In Source Account-Provided Reference Number For Imps</option>
												<option value="Query-Other-I Need To Talk To A Supervisor-Transferred Call To Supervisor">Query-Other-I Need To Talk To A Supervisor-Transferred Call To Supervisor</option>
												<option value="Query-Delivery-Where Is My Order?-Informed Order Is Rtoed">Query-Delivery-Where Is My Order?-Informed Order Is Rtoed</option>
												<option value="Query-Refund-How Do I Get My Money Back?-Informed Customer About Imps Procedure">Query-Refund-How Do I Get My Money Back?-Informed Customer About Imps Procedure</option>
												<option value="Complaint-Delivery-Order Not Marked As Delivered-N/A">Complaint-Delivery-Order Not Marked As Delivered-N/A</option>
												<option value="Query-Ticket-Cx-Ticket Follow Up - Within Tat-Refund Related">Query-Ticket-Cx-Ticket Follow Up - Within Tat-Refund Related</option>
												<option value="Complaint-Account-Store Credit Discrepancy-Ajio Cash">Complaint-Account-Store Credit Discrepancy-Ajio Cash</option>
												<option value="Proactive Sr-Wh - Order Related Issues-Return To Be Cancelled-Awb Cancelled (Pickup Not Required)">Proactive Sr-Wh - Order Related Issues-Return To Be Cancelled-Awb Cancelled (Pickup Not Required)</option>
												<option value="Complaint-Delivery-Pod Required-Customer Disputes On Pod Shared">Complaint-Delivery-Pod Required-Customer Disputes On Pod Shared</option>
												<option value="Query-Nar Calls/Emails-Blank Call-Blank Call">Query-Nar Calls/Emails-Blank Call-Blank Call</option>
												<option value="Query-Delivery-Where Is My Order?-Guided Customer To Track The Order Online">Query-Delivery-Where Is My Order?-Guided Customer To Track The Order Online</option>
												<option value="Query-Delivery-I Want Delivery/Pickup At Specific Time-Informed About Delivery Policy">Query-Delivery-I Want Delivery/Pickup At Specific Time-Informed About Delivery Policy</option>
												<option value="Query-Ticket-Cx-Ticket Follow Up - Within Tat-Pickup Related">Query-Ticket-Cx-Ticket Follow Up - Within Tat-Pickup Related</option>
												<option value="Complaint-Return-Picked Up - Did Not Reach Warehouse-N/A">Complaint-Return-Picked Up - Did Not Reach Warehouse-N/A</option>
												<option value="Query-Nar Calls/Emails-Incomplete Call/Email-Call Dropped Before Knowing The Query">Query-Nar Calls/Emails-Incomplete Call/Email-Call Dropped Before Knowing The Query</option>
												<option value="Complaint-Delivery-Special Instructions For Contact Details Update-N/A">Complaint-Delivery-Special Instructions For Contact Details Update-N/A</option>
												<option value="Query-Return/Exchange-Create A Return For Me-Created Return - Different Product Delivered">Query-Return/Exchange-Create A Return For Me-Created Return - Different Product Delivered</option>
												<option value="Query-Ticket-Cx-Ticket Follow Up - Within Tat-Missing Product Related">Query-Ticket-Cx-Ticket Follow Up - Within Tat-Missing Product Related</option>
												<option value="Complaint-Delivery-Complaint Against Delivery Person-Rude Behavior">Complaint-Delivery-Complaint Against Delivery Person-Rude Behavior</option>
												<option value="Complaint-Delivery-Incomplete Order Received - Unit(S) Missing From A Set/Pack-Outer Packaging Not Tampered">Complaint-Delivery-Incomplete Order Received - Unit(S) Missing From A Set/Pack-Outer Packaging Not Tampered</option>
												<option value="Query-Return/Exchange-How Do I Return/Exchange This Item?-Educated Customer On Exchange Policy">Query-Return/Exchange-How Do I Return/Exchange This Item?-Educated Customer On Exchange Policy</option>
												<option value="Complaint-Website-Complaint Relating To Website-Unable To Exchange">Complaint-Website-Complaint Relating To Website-Unable To Exchange</option>
												<option value="Complaint-Callback-Supervisor Callback-N/A">Complaint-Callback-Supervisor Callback-N/A</option>
												<option value="Complaint-Return-Reached Warehouse - Refund Not Initiated-N/A">Complaint-Return-Reached Warehouse - Refund Not Initiated-N/A</option>
												<option value="Query-Refund-Where Is My Refund?-Prepaid Refund Is Processed - Informed To Wait For 5-7 Business Days">Query-Refund-Where Is My Refund?-Prepaid Refund Is Processed - Informed To Wait For 5-7 Business Days</option>
												<option value="Query-Return/Exchange-How Do I Return/Exchange This Item?-Requested Image For Wrong Product Delivered">Query-Return/Exchange-How Do I Return/Exchange This Item?-Requested Image For Wrong Product Delivered</option>
												<option value="Query-Cancel-Why Was My Order Cancelled?-Explained The Cancellation Reason">Query-Cancel-Why Was My Order Cancelled?-Explained The Cancellation Reason</option>
												<option value="Complaint-Delivery-Incomplete Order Received -  Item(S) Missing From An Outfit/Dress-Outer Packaging Not Tampered">Complaint-Delivery-Incomplete Order Received -  Item(S) Missing From An Outfit/Dress-Outer Packaging Not Tampered</option>
												<option value="Complaint-Return-Complaint Against Delivery Person-Excess Product Handed Over">Complaint-Return-Complaint Against Delivery Person-Excess Product Handed Over</option>
												<option value="Query-Cancel-I Want To Cancel-Cancelled Order">Query-Cancel-I Want To Cancel-Cancelled Order</option>
												<option value="Query-Ticket-Cx-Ticket Follow Up - Tat Breached-Return Related">Query-Ticket-Cx-Ticket Follow Up - Tat Breached-Return Related</option>
												<option value="Query-Return/Exchange-How Do I Return/Exchange This Item?-Informed Return Policy - Others">Query-Return/Exchange-How Do I Return/Exchange This Item?-Informed Return Policy - Others</option>
												<option value="Query-Delivery-Marked The Order As Delivered-Requested Customer To Wait For 2 Business Days">Query-Delivery-Marked The Order As Delivered-Requested Customer To Wait For 2 Business Days</option>
												<option value="Complaint-Delivery-Incomplete Order Received - Product(S) Missing From Shipment-Outer Package Tampered">Complaint-Delivery-Incomplete Order Received - Product(S) Missing From Shipment-Outer Package Tampered</option>
												<option value="Query-Other-I Want To Know More About An Offer/Promotion-Explained The Promotion To Customer">Query-Other-I Want To Know More About An Offer/Promotion-Explained The Promotion To Customer</option>
												<option value="Complaint-Delivery-Order Not Dispatched From Warehouse-Shipment In Packed Status">Complaint-Delivery-Order Not Dispatched From Warehouse-Shipment In Packed Status</option>
												<option value="Complaint-Return-Complaint Against Delivery Person-Didn?T Know Which Product To Pickup">Complaint-Return-Complaint Against Delivery Person-Didn?T Know Which Product To Pickup</option>
												<option value="Query-Order-I Had A Problem While Placing An Order-Adonp  Within 48 Hrs">Query-Order-I Had A Problem While Placing An Order-Adonp Within 48 Hrs</option>
												<option value="Query-Account-Why Is My Account Suspended ?-Guided Customer On Reason For Suspension">Query-Account-Why Is My Account Suspended ?-Guided Customer On Reason For Suspension</option>
												<option value="Query-Refund-How Do I Get My Money Back?-Informed Customer About Prepaid Refund">Query-Refund-How Do I Get My Money Back?-Informed Customer About Prepaid Refund</option>
												<option value="Query-Return/Exchange-Exchange Related-Informed ? Product Will Get Exchanged">Query-Return/Exchange-Exchange Related-Informed ? Product Will Get Exchanged</option>
												<option value="Query-Nar Calls/Emails-Incomplete Call/Email-Call Suddenly Went Blank During Conversation">Query-Nar Calls/Emails-Incomplete Call/Email-Call Suddenly Went Blank During Conversation</option>
												<option value="Complaint-Account-Store Credit Discrepancy-Others">Complaint-Account-Store Credit Discrepancy-Others</option>
												<option value="Query-Ticket-Cx-Ticket Follow Up - Within Tat-Website Related">Query-Ticket-Cx-Ticket Follow Up - Within Tat-Website Related</option>
												<option value="Query-Account-I Need Help With My Account-Informed Customer About Account Information">Query-Account-I Need Help With My Account-Informed Customer About Account Information</option>
												<option value="Query-Ticket-Cx-Ticket Follow Up - Within Tat-Others">Query-Ticket-Cx-Ticket Follow Up - Within Tat-Others</option>
												<option value="Query-Return/Exchange-Create An Exchange For Me-Created Exchange For Customer">Query-Return/Exchange-Create An Exchange For Me-Created Exchange For Customer</option>
												<option value="Query-Order-I Had A Problem While Placing An Order-Informed Customer Of Pin Code Serviceability">Query-Order-I Had A Problem While Placing An Order-Informed Customer Of Pin Code Serviceability</option>
												<option value="Query-Return/Exchange-Pickup Related-Others">Query-Return/Exchange-Pickup Related-Others</option>
												<option value="Query-Coupon-How Do I Use My Coupon?-Educated Customer On Coupon Features">Query-Coupon-How Do I Use My Coupon?-Educated Customer On Coupon Features</option>
												<option value="Query-Refund-Where Is My Refund?-Imps Refund Is Processed - Informed To Wait For 1 Business Day">Query-Refund-Where Is My Refund?-Imps Refund Is Processed - Informed To Wait For 1 Business Day</option>
												<option value="Query-Price-What'S The Price For This Order?-Informed Customer About Cost Split">Query-Price-What'S The Price For This Order?-Informed Customer About Cost Split</option>
												<option value="Complaint-Return-Complaint Against Delivery Person-Rude Behavior">Complaint-Return-Complaint Against Delivery Person-Rude Behavior</option>
												<option value="Query-Ticket-Cx-Ticket Follow Up - Tat Breached-Refund Related">Query-Ticket-Cx-Ticket Follow Up - Tat Breached-Refund Related</option>
												<option value="Complaint-Return-Complaint Against Delivery Person-Courier Person Refused To Pick A Product">Complaint-Return-Complaint Against Delivery Person-Courier Person Refused To Pick A Product</option>
												<option value="Query-Coupon-Unable To Apply Coupon-Requested To Share Coupon Details/Images">Query-Coupon-Unable To Apply Coupon-Requested To Share Coupon Details/Images</option>
												<option value="Query-Ticket-Cx-Ticket Follow Up - Tat Breached-Delivery Related">Query-Ticket-Cx-Ticket Follow Up - Tat Breached-Delivery Related</option>
												<option value="Query-Return/Exchange-Create A Return For Me-Created Return - Wrong Size Delivered">Query-Return/Exchange-Create A Return For Me-Created Return - Wrong Size Delivered</option>
												<option value="Query-Coupon-I Did Not Receive A Coupon After Returning/Cancelling-Educated Customer On Coupon Policy">Query-Coupon-I Did Not Receive A Coupon After Returning/Cancelling-Educated Customer On Coupon Policy</option>
												<option value="Complaint-Delivery-Rto Refund Delayed-N/A">Complaint-Delivery-Rto Refund Delayed-N/A</option>
												<option value="Query-Refund-My Refund Hasn'T Reflected In Source Account-Provided Reference No. For E-Wallets">Query-Refund-My Refund Hasn'T Reflected In Source Account-Provided Reference No. For E-Wallets</option>
												<option value="Query-Cancel-Explain The Cancellation Policy-Explained The Cancellation Policy">Query-Cancel-Explain The Cancellation Policy-Explained The Cancellation Policy</option>
												<option value="Feedback-Feedback-Suggestions About Delivery-N/A">Feedback-Feedback-Suggestions About Delivery-N/A</option>
												<option value="Complaint-Delivery-Empty Package Received-Outer Packaging Not Tampered">Complaint-Delivery-Empty Package Received-Outer Packaging Not Tampered</option>
												<option value="Proactive Sr-Wh - Order Related Issues-Return To Be Cancelled-Awb Not Cancelled (Pickup Required)">Proactive Sr-Wh - Order Related Issues-Return To Be Cancelled-Awb Not Cancelled (Pickup Required)</option>
												<option value="Query-Refund-Enable My Imps Refund-Enabled The Imps Switch">Query-Refund-Enable My Imps Refund-Enabled The Imps Switch</option>
												<option value="Complaint-Delivery-Complaint Against Delivery Person-Courier Person Took Extra Money">Complaint-Delivery-Complaint Against Delivery Person-Courier Person Took Extra Money</option>
												<option value="Complaint-Return-Self Shipped No Update From Wh-N/A">Complaint-Return-Self Shipped No Update From Wh-N/A</option>
												<option value="Complaint-Return-Special Instructions For Contact Details Update-N/A">Complaint-Return-Special Instructions For Contact Details Update-N/A</option>
												<option value="Query-Price-What'S The Price For This Order?-Guided Customer On Delivery Charge">Query-Price-What'S The Price For This Order?-Guided Customer On Delivery Charge</option>
												<option value="Query-Ticket-Cx-Ticket Follow Up - Tat Breached-Missing Product Related">Query-Ticket-Cx-Ticket Follow Up - Tat Breached-Missing Product Related</option>
												<option value="Query-Price-What'S The Price For This Order?-Guided Customer On Fulfilment Convenience Charge">Query-Price-What'S The Price For This Order?-Guided Customer On Fulfilment Convenience Charge</option>
												<option value="Complaint-Callback-Regional Callback-Callback Needed - Telugu">Complaint-Callback-Regional Callback-Callback Needed - Telugu</option>
												<option value="Complaint-Website-Complaint Relating To Website-Unable To Place Order">Complaint-Website-Complaint Relating To Website-Unable To Place Order</option>
												<option value="Query-Refund-Where Is My Refund?-Informed About Drop At Store Refund Tat">Query-Refund-Where Is My Refund?-Informed About Drop At Store Refund Tat</option>
												<option value="Query-Ob-Misc-Not Connected">Query-Ob-Misc-Not Connected</option>
												<option value="Proactive Sr-Return-Wrong Item-Return Form">Proactive Sr-Return-Wrong Item-Return Form</option>
												<option value="Query-Account-I Need Help With My Account-Guided Customer On My Accounts">Query-Account-I Need Help With My Account-Guided Customer On My Accounts</option>
												<option value="Query-Return/Exchange-Pickup Related-Provided Shipping Address">Query-Return/Exchange-Pickup Related-Provided Shipping Address</option>
												<option value="Complaint-Return-Customer Claiming Product Picked Up-Shared Acknowledgement Copy">Complaint-Return-Customer Claiming Product Picked Up-Shared Acknowledgement Copy</option>
												<option value="Query-Order-I Want To Modify My Order (Ph/Addr Etc)-Guided Customer To Modify Details On Website/App">Query-Order-I Want To Modify My Order (Ph/Addr Etc)-Guided Customer To Modify Details On Website/App</option>
												<option value="Query-Refund-How Do I Get My Money Back?-Informed Customer About Wallet Refund">Query-Refund-How Do I Get My Money Back?-Informed Customer About Wallet Refund</option>
												<option value="Query-Delivery-Marked The Order As Delivered-N/A">Query-Delivery-Marked The Order As Delivered-N/A</option>
												<option value="Query-Ob-Callback-Not Connected">Query-Ob-Callback-Not Connected</option>
												<option value="Complaint-Mobile App-Complaint Relating To Mobile App-Unable To Return">Complaint-Mobile App-Complaint Relating To Mobile App-Unable To Return</option>
												<option value="Query-Pre Order - F&L-Explain The Features Of The Product-Explained About Product Features">Query-Pre Order - F&L-Explain The Features Of The Product-Explained About Product Features</option>
												<option value="Complaint-Neft(Refund Request)-Neft Follow-Up-Request For Neft Transfer">Complaint-Neft(Refund Request)-Neft Follow-Up-Request For Neft Transfer</option>
												<option value="Query-Ticket-Cx-Ticket Follow Up - Tat Breached-Pickup Related">Query-Ticket-Cx-Ticket Follow Up - Tat Breached-Pickup Related</option>
												<option value="Query-Price-What'S The Price For This Order?-Guided Customer On Cod Charge">Query-Price-What'S The Price For This Order?-Guided Customer On Cod Charge</option>
												<option value="Complaint-Delivery-Incomplete Order Received - Item(S) Missing From An Outfit/Dress-Outer Packaging Not Tampered">Complaint-Delivery-Incomplete Order Received - Item(S) Missing From An Outfit/Dress-Outer Packaging Not Tampered</option>
												<option value="Query-Cancel-I Want To Cancel-Educated Customer On Cancellation Policy">Query-Cancel-I Want To Cancel-Educated Customer On Cancellation Policy</option>
												<option value="Complaint-Mobile App-Complaint Relating To Mobile App-Unable To Place Order">Complaint-Mobile App-Complaint Relating To Mobile App-Unable To Place Order</option>
												<option value="Complaint-Delivery-Empty Package Received-Outer Packaging Tampered">Complaint-Delivery-Empty Package Received-Outer Packaging Tampered</option>
												<option value="Query-Return/Exchange-Customer Claiming Product Picked Up-Asked To Share Acknowledgement Copy">Query-Return/Exchange-Customer Claiming Product Picked Up-Asked To Share Acknowledgement Copy</option>
												<option value="Query-Order-I Had A Problem While Placing An Order-Helped The Customer To Place The Order On Website/App">Query-Order-I Had A Problem While Placing An Order-Helped The Customer To Place The Order On Website/App</option>
												<option value="Query-Refund-Where Is My Refund?-Informed Customer About Self-Ship Status">Query-Refund-Where Is My Refund?-Informed Customer About Self-Ship Status</option>
												<option value="Query-Ob-Misc-Informed">Query-Ob-Misc-Informed</option>
												<option value="Complaint-Delivery-Incomplete Order Received - Unit(S) Missing From A Set/Pack-Outer Package Tampered">Complaint-Delivery-Incomplete Order Received - Unit(S) Missing From A Set/Pack-Outer Package Tampered</option>
												<option value="Query-Cancel-Cancel My Return/Exchange-Informed Unable To Cancel">Query-Cancel-Cancel My Return/Exchange-Informed Unable To Cancel</option>
												<option value="Query-Account-How Do I Use My Store Credits?-Explained How To Use Store Credits">Query-Account-How Do I Use My Store Credits?-Explained How To Use Store Credits</option>
												<option value="Complaint-Website-Complaint Relating To Website-Unable To Cancel">Complaint-Website-Complaint Relating To Website-Unable To Cancel</option>
												<option value="Query-Return/Exchange-Unable To Create Return On Website/Mobile-Created Return For Customer">Query-Return/Exchange-Unable To Create Return On Website/Mobile-Created Return For Customer</option>
												<option value="Query-Order-I Want To Place An Order-Guided Customer On Placing An Order On Website/App">Query-Order-I Want To Place An Order-Guided Customer On Placing An Order On Website/App</option>
												<option value="Query-Return/Exchange-Create A Return For Me-Wrong Product Delivered">Query-Return/Exchange-Create A Return For Me-Wrong Product Delivered</option>
												<option value="Query-Account-How Do I Use My Store Credits?-Informed About Store Credit Policy">Query-Account-How Do I Use My Store Credits?-Informed About Store Credit Policy</option>
												<option value="Complaint-Neft(Refund Request)-Neft Transfer-N/A">Complaint-Neft(Refund Request)-Neft Transfer-N/A</option>
												<option value="Complaint-Delivery-Incomplete Order Received -  Item(S) Missing From An Outfit/Dress-Outer Package Tampered">Complaint-Delivery-Incomplete Order Received -  Item(S) Missing From An Outfit/Dress-Outer Package Tampered</option>
												<option value="Query-Nar Calls/Emails-Incomplete Call/Email-Call Suddenly Got Interrupted By Static Noise During Conversation">Query-Nar Calls/Emails-Incomplete Call/Email-Call Suddenly Got Interrupted By Static Noise During Conversation</option>
												<option value="Complaint-Return-Non Returnable Product-Return - Post Return Window">Complaint-Return-Non Returnable Product-Return - Post Return Window</option>
												<option value="Query-Return/Exchange-Create A Return For Me-Created Return - Tags/Shoebox Missing">Query-Return/Exchange-Create A Return For Me-Created Return - Tags/Shoebox Missing</option>
												<option value="Query-Return/Exchange-Create A Return For Me-Created Return - Wrong Colour Delivered">Query-Return/Exchange-Create A Return For Me-Created Return - Wrong Colour Delivered</option>
												<option value="Feedback-Feedback-Suggestions About Products-N/A">Feedback-Feedback-Suggestions About Products-N/A</option>
												<option value="Complaint-Delivery-Complaint Against Delivery Person-Courier Person Asking Extra Money">Complaint-Delivery-Complaint Against Delivery Person-Courier Person Asking Extra Money</option>
												<option value="Query-Return/Exchange-How Do I Return/Exchange This Item?-Declined - Non Returnable Product">Query-Return/Exchange-How Do I Return/Exchange This Item?-Declined - Non Returnable Product</option>
												<option value="Proactive Sr-Delivery-Customer Delight-N/A">Proactive Sr-Delivery-Customer Delight-N/A</option>
												<option value="Complaint-Return-Pickup - Wrong Status Update-Product Not Picked Up - Return Related">Complaint-Return-Pickup - Wrong Status Update-Product Not Picked Up - Return Related</option>
												<option value="Complaint-Return-Reached Warehouse - Refund Not Initiated-Partial Refund Initiated">Complaint-Return-Reached Warehouse - Refund Not Initiated-Partial Refund Initiated</option>
												<option value="Complaint-Callback-Regional Callback-Callback Needed - Kannada">Complaint-Callback-Regional Callback-Callback Needed - Kannada</option>
												<option value="Query-Return/Exchange-Pickup Related-Provided Information On Packing Product">Query-Return/Exchange-Pickup Related-Provided Information On Packing Product</option>
												<option value="Query-Ticket-Cx-Ticket Follow Up - Tat Breached-Website Related">Query-Ticket-Cx-Ticket Follow Up - Tat Breached-Website Related</option>
												<option value="Query-Nar Calls/Emails-Nar Calls-Non Ajio Queries">Query-Nar Calls/Emails-Nar Calls-Non Ajio Queries</option>
												<option value="Query-Ticket-Cx-Ticket Follow Up - Tat Breached-Others">Query-Ticket-Cx-Ticket Follow Up - Tat Breached-Others</option>
												<option value="Proactive Sr-Return-Wrong Item With No Tag-Return Form">Proactive Sr-Return-Wrong Item With No Tag-Return Form</option>
												<option value="Complaint-Return-Non Returnable Product-Classified As Non-Returnable">Complaint-Return-Non Returnable Product-Classified As Non-Returnable</option>
												<option value="Complaint-Return-Self Ship Courier Charges Not Credited-N/A">Complaint-Return-Self Ship Courier Charges Not Credited-N/A</option>
												<option value="Complaint-Website-Complaint Relating To Website-Return Id In Approved Status">Complaint-Website-Complaint Relating To Website-Return Id In Approved Status</option>
												<option value="Query-Return/Exchange-Has My Self-Ship Return Reached You?-Others">Query-Return/Exchange-Has My Self-Ship Return Reached You?-Others</option>
												<option value="Query-Cancel-Why Was My Pickup/Exchange Cancelled?-Explained The Reason">Query-Cancel-Why Was My Pickup/Exchange Cancelled?-Explained The Reason</option>
												<option value="Query-Account-How Many Store Credits Do I Have?-Provided The Amount To The Customer">Query-Account-How Many Store Credits Do I Have?-Provided The Amount To The Customer</option>
												<option value="Query-Refund-Where Is My Refund?-Jiomoney Refund Is Processed - Informed To Wait For 2 Business Days">Query-Refund-Where Is My Refund?-Jiomoney Refund Is Processed - Informed To Wait For 2 Business Days</option>
												<option value="Query-Cancel-I Want To Cancel-Guided Customer To Cancel On Website/App">Query-Cancel-I Want To Cancel-Guided Customer To Cancel On Website/App</option>
												<option value="Feedback-Feedback-Others-N/A">Feedback-Feedback-Others-N/A</option>
												<option value="Query-Order-I Want To Modify My Order (Ph/Addr Etc)-Modified Ph. No. /Address On Cs Cockpit">Query-Order-I Want To Modify My Order (Ph/Addr Etc)-Modified Ph. No. /Address On Cs Cockpit</option>
												<option value="Complaint-Website-Complaint Relating To Website-Change In Login Info">Complaint-Website-Complaint Relating To Website-Change In Login Info</option>
												<option value="Complaint-Website-Complaint Relating To Website-Unable To Login/Signup">Complaint-Website-Complaint Relating To Website-Unable To Login/Signup</option>
												<option value="Query-Return/Exchange-How Do I Return/Exchange This Item?-Declined - Tags/Shoebox Missing">Query-Return/Exchange-How Do I Return/Exchange This Item?-Declined - Tags/Shoebox Missing</option>
												<option value="Query-Other-I Want To Know More About An Offer/Promotion-Explained That There Is No Current Promotion At Ajio">Query-Other-I Want To Know More About An Offer/Promotion-Explained That There Is No Current Promotion At Ajio</option>
												<option value="Query-Refund-How Do I Get My Money Back?-Informed Customer About Cod Refund">Query-Refund-How Do I Get My Money Back?-Informed Customer About Cod Refund</option>
												<option value="Complaint-Online Refund-Refund Not Done Against Reference No. - Prepaid Cancelled-N/A">Complaint-Online Refund-Refund Not Done Against Reference No. - Prepaid Cancelled-N/A</option>
												<option value="Complaint-Callback-Regional Callback-Callback Needed - Tamil">Complaint-Callback-Regional Callback-Callback Needed - Tamil</option>
												<option value="Query-Account-How Do I Use My R - One Points-Explained How To Use R - One Points">Query-Account-How Do I Use My R - One Points-Explained How To Use R - One Points</option>
												<option value="Query-Pre Order - F&L-Where Can I Find This Product?-Informed Customer That The Product Is Not In Stock">Query-Pre Order - F&L-Where Can I Find This Product?-Informed Customer That The Product Is Not In Stock</option>
												<option value="Feedback-Feedback-Suggestions About Returns/Exchange-N/A">Feedback-Feedback-Suggestions About Returns/Exchange-N/A</option>
												<option value="Complaint-Marketing-Gift Not Received Post Winning Contest-High Value Assured Gift - Reward Post Return Window">Complaint-Marketing-Gift Not Received Post Winning Contest-High Value Assured Gift - Reward Post Return Window</option>
												<option value="Complaint-Marketing-Promotion Related-N/A">Complaint-Marketing-Promotion Related-N/A</option>
												<option value="Complaint-Return-Reached Warehouse - Refund Not Initiated-Excess Product Handed Over">Complaint-Return-Reached Warehouse - Refund Not Initiated-Excess Product Handed Over</option>
												<option value="Proactive Sr-Wh - Order Related Issues-Return To Be Cancelled-Awb Cancelled (Pickup Required)">Proactive Sr-Wh - Order Related Issues-Return To Be Cancelled-Awb Cancelled (Pickup Required)</option>
												<option value="Complaint-Online Refund-Refund Not Done Against Reference No.-N/A">Complaint-Online Refund-Refund Not Done Against Reference No.-N/A</option>
												<option value="Query-Ob-Ticket-Not Connected">Query-Ob-Ticket-Not Connected</option>
												<option value="Complaint-Mobile App-Complaint Relating To Mobile App-Unable To Exchange">Complaint-Mobile App-Complaint Relating To Mobile App-Unable To Exchange</option>
												<option value="Complaint-Account-Store Credit Discrepancy-Bonus Points">Complaint-Account-Store Credit Discrepancy-Bonus Points</option>
												<option value="Complaint-Online Refund-Amount Debited Order Not Processed-N/A">Complaint-Online Refund-Amount Debited Order Not Processed-N/A</option>
												<option value="Complaint-Return-Non Returnable Product-Wrong Product Delivered">Complaint-Return-Non Returnable Product-Wrong Product Delivered</option>
												<option value="Query-Return/Exchange-Is My Pin Code Serviceable For Exchange/Return?-Explained Pin-Code Serviceability">Query-Return/Exchange-Is My Pin Code Serviceable For Exchange/Return?-Explained Pin-Code Serviceability</option>
												<option value="Complaint-Account-Account Deactivation-N/A">Complaint-Account-Account Deactivation-N/A</option>
												<option value="Complaint-Marketing-Gift Not Received Post Winning Contest-High Value Assured Gift - Instant Reward">Complaint-Marketing-Gift Not Received Post Winning Contest-High Value Assured Gift - Instant Reward</option>
												<option value="Feedback-Feedback-Suggestions About Refund-N/A">Feedback-Feedback-Suggestions About Refund-N/A</option>
												<option value="Query-Account-I Have Not Received My Referral Bonus-Informed About Referral Credit">Query-Account-I Have Not Received My Referral Bonus-Informed About Referral Credit</option>
												<option value="Query-Account-I Have Not Received My R - One Points-Informed About R - One Points">Query-Account-I Have Not Received My R - One Points-Informed About R - One Points</option>
												<option value="Query-Return/Exchange-How Do I Return/Exchange This Item?-Declined - Time Period Lapsed">Query-Return/Exchange-How Do I Return/Exchange This Item?-Declined - Time Period Lapsed</option>
												<option value="Complaint-Delivery-Order Not Dispatched From Warehouse-Packed ? Need To Cancel">Complaint-Delivery-Order Not Dispatched From Warehouse-Packed ? Need To Cancel</option>
												<option value="Query-Nar Calls/Emails-Nar Calls-No Action Required">Query-Nar Calls/Emails-Nar Calls-No Action Required</option>
												<option value="Query-Order-I Had A Problem While Placing An Order-Clarified That Order Was Not Processed">Query-Order-I Had A Problem While Placing An Order-Clarified That Order Was Not Processed</option>
												<option value="Query-Website-Access/Function-Helped In Accessing Page/Site">Query-Website-Access/Function-Helped In Accessing Page/Site</option>
												<option value="Complaint-Online Refund-Refund Reference No. Needed-Cc/Dc/Nb">Complaint-Online Refund-Refund Reference No. Needed-Cc/Dc/Nb</option>
												<option value="Query-Nar Calls/Emails-Abusive Caller-Abusive Caller">Query-Nar Calls/Emails-Abusive Caller-Abusive Caller</option>
												<option value="Query-Coupon-How Do I Use My Jio Prime Points?-Educated Customer On Jio Prime Points">Query-Coupon-How Do I Use My Jio Prime Points?-Educated Customer On Jio Prime Points</option>
												<option value="Complaint-Account-Store Credit Debited Order Not Processed-N/A">Complaint-Account-Store Credit Debited Order Not Processed-N/A</option>
												<option value="Query-Order-I Had A Problem While Placing An Order-Clarified That Order Was Processed.">Query-Order-I Had A Problem While Placing An Order-Clarified That Order Was Processed.</option>
												<option value="Complaint-Account-R- One Related-R - One Points Not Credited">Complaint-Account-R- One Related-R - One Points Not Credited</option>
												<option value="Query-Delivery-Pod Required-Req Cx To Check With Neighbour / Security">Query-Delivery-Pod Required-Req Cx To Check With Neighbour / Security</option>
												<option value="Complaint-Return-Non Returnable Product-Damaged Product Received">Complaint-Return-Non Returnable Product-Damaged Product Received</option>
												<option value="Query-Order-I Want To Place An Order-Informed Customer Of Pin Code Serviceability">Query-Order-I Want To Place An Order-Informed Customer Of Pin Code Serviceability</option>
												<option value="Query-Return/Exchange-How Do I Return/Exchange This Item?-Declined ? Non Exchangeable Product">Query-Return/Exchange-How Do I Return/Exchange This Item?-Declined ? Non Exchangeable Product</option>
												<option value="Query-Return/Exchange-Has My Self-Ship Return Reached You?-Asked To Check With Customer'S Courier Company">Query-Return/Exchange-Has My Self-Ship Return Reached You?-Asked To Check With Customer'S Courier Company</option>
												<option value="Complaint-Account-Customer Information  Leak-N/A">Complaint-Account-Customer Information  Leak-N/A</option>
												<option value="Proactive Sr-Return-Customer Delight-N/A">Proactive Sr-Return-Customer Delight-N/A</option>
												<option value="Query-Order-What Are The Payment Modes?-Informed Customer Of Payment Options">Query-Order-What Are The Payment Modes?-Informed Customer Of Payment Options</option>
												<option value="Query-Return/Exchange-Has My Self-Ship Return Reached You?-Informed - Reached Warehouse And Refund Initiated">Query-Return/Exchange-Has My Self-Ship Return Reached You?-Informed - Reached Warehouse And Refund Initiated</option>
												<option value="Query-Refund-There Is A Discrepancy With My Store Credits-Clarified Discrepancy With Customer">Query-Refund-There Is A Discrepancy With My Store Credits-Clarified Discrepancy With Customer</option>
												<option value="Query-Account-How Do I Use My Loyalty Rewards-Explained How To Use Lr">Query-Account-How Do I Use My Loyalty Rewards-Explained How To Use Lr</option>
												<option value="Query-Account-Fraudulent Activity Reported-Educated Customer As Per Policy">Query-Account-Fraudulent Activity Reported-Educated Customer As Per Policy</option>
												<option value="Query-Return/Exchange-Pickup Related-Informed - Picked Up Product Still Has To Reach Warehouse">Query-Return/Exchange-Pickup Related-Informed - Picked Up Product Still Has To Reach Warehouse</option>
												<option value="Complaint-Website-Complaint Relating To Website-Slow Functioning/Unable To Open Feature-Webpage-Website">Complaint-Website-Complaint Relating To Website-Slow Functioning/Unable To Open Feature-Webpage-Website</option>
												<option value="Complaint-Account-Suspended Account (Reason For Suspension Required)-Customer Wanted To Know Suspension Reason">Complaint-Account-Suspended Account (Reason For Suspension Required)-Customer Wanted To Know Suspension Reason</option>
												<option value="Query-Return/Exchange-Create An Exchange For Me-Created Return Due To Lack Of Size">Query-Return/Exchange-Create An Exchange For Me-Created Return Due To Lack Of Size</option>
												<option value="Query-Return/Exchange-Pickup Related-Informed - Reached Wh And Refund Initiated">Query-Return/Exchange-Pickup Related-Informed - Reached Wh And Refund Initiated</option>
												<option value="Query-Website-Please Explain Ajio-Explained About Website">Query-Website-Please Explain Ajio-Explained About Website</option>
												<option value="Query-Return/Exchange-Create A Return For Me-Created Return For Used Product">Query-Return/Exchange-Create A Return For Me-Created Return For Used Product</option>
												<option value="Query-Other-I Want Convenience Charge-Convinced The Customer - No Action Required">Query-Other-I Want Convenience Charge-Convinced The Customer - No Action Required</option>
												<option value="Query-Mobile App-The App Is Slow/ Loading & Functionality Issues-Troubleshooting Done">Query-Mobile App-The App Is Slow/ Loading & Functionality Issues-Troubleshooting Done</option>
												<option value="Complaint-Website-Complaint Relating To Website-No Confirmation Received On Website/Email/Sms">Complaint-Website-Complaint Relating To Website-No Confirmation Received On Website/Email/Sms</option>
												<option value="Feedback-Feedback-Suggestions About Warehouse-N/A">Feedback-Feedback-Suggestions About Warehouse-N/A</option>
												<option value="Complaint-Goodwill Request-Cm Insisting Compensation-N/A">Complaint-Goodwill Request-Cm Insisting Compensation-N/A</option>
												<option value="Query-Return/Exchange-Create A Return For Me-Created Return - Received Damaged Product">Query-Return/Exchange-Create A Return For Me-Created Return - Received Damaged Product</option>
												<option value="Complaint-Mobile App-Complaint Relating To Mobile App-Unable To Login">Complaint-Mobile App-Complaint Relating To Mobile App-Unable To Login</option>
												<option value="Query-Mobile App-I Have A Problem Using Your App-Explained The App Feature/Functions">Query-Mobile App-I Have A Problem Using Your App-Explained The App Feature/Functions</option>
												<option value="Query-Return/Exchange-Has My Self-Ship Return Reached You?-Updated Tracking Number For The Customer">Query-Return/Exchange-Has My Self-Ship Return Reached You?-Updated Tracking Number For The Customer</option>
												<option value="Complaint-Website-Complaint Relating To Website-Unable To View/Edit Profile Details">Complaint-Website-Complaint Relating To Website-Unable To View/Edit Profile Details</option>
												<option value="Query-Nar Calls/Emails-Prank Call-Prank Call">Query-Nar Calls/Emails-Prank Call-Prank Call</option>
												<option value="Complaint-Callback-Regional Callback-Callback Needed - Malyalam">Complaint-Callback-Regional Callback-Callback Needed - Malyalam</option>
												<option value="Complaint-Delivery-Empty Package Received – Rj(Jewels)-Outer Packaging Tampered">Complaint-Delivery-Empty Package Received – Rj(Jewels)-Outer Packaging Tampered</option>
												<option value="Complaint-Return-Damaged Product-Damaged Post Usage">Complaint-Return-Damaged Product-Damaged Post Usage</option>
												<option value="Query-Nar Calls/Emails-Nar Emails-Non Ajio Query">Query-Nar Calls/Emails-Nar Emails-Non Ajio Query</option>
												<option value="Complaint-Online Refund-Refund Reference No. Needed-Imps Transfer">Complaint-Online Refund-Refund Reference No. Needed-Imps Transfer</option>
												<option value="Query-Order-I Want My Invoice-Emailed Invoice To The Customer">Query-Order-I Want My Invoice-Emailed Invoice To The Customer</option>
												<option value="Complaint-Return-Regular Courier Charges Not Credited-N/A">Complaint-Return-Regular Courier Charges Not Credited-N/A</option>
												<option value="Query-Mobile App-Help Me Shop On The App-Helped The Customer">Query-Mobile App-Help Me Shop On The App-Helped The Customer</option>
												<option value="Query-Other-I Want Compensation-Convinced The Customer - No Action Required">Query-Other-I Want Compensation-Convinced The Customer - No Action Required</option>
												<option value="Query-Refund-Where Is My Refund?-Educated Customer About Gst Refund">Query-Refund-Where Is My Refund?-Educated Customer About Gst Refund</option>
												<option value="Query-Website-Access/Function-Helped In Viewing Account Details">Query-Website-Access/Function-Helped In Viewing Account Details</option>
												<option value="Query-Website-How To Shop On App?-Guided Customer To Visit The App">Query-Website-How To Shop On App?-Guided Customer To Visit The App</option>
												<option value="Feedback-Feedback-Mobile App-Feedback/Suggestion About Mobile App">Feedback-Feedback-Mobile App-Feedback/Suggestion About Mobile App</option>
												<option value="Feedback-Feedback-Suggestions About Website-N/A">Feedback-Feedback-Suggestions About Website-N/A</option>
												<option value="Complaint-Mobile App-Complaint Relating To Mobile App-Slow Functioning/Unable To Open Feature-Webpage-Website">Complaint-Mobile App-Complaint Relating To Mobile App-Slow Functioning/Unable To Open Feature-Webpage-Website</option>
												<option value="Complaint-Delivery-Empty Package Received – Rj(Jewels)-Outer Packaging Not Tampered">Complaint-Delivery-Empty Package Received – Rj(Jewels)-Outer Packaging Not Tampered</option>
												<option value="Complaint-Account-Stop Sms/Email (Promotional)-N/A">Complaint-Account-Stop Sms/Email (Promotional)-N/A</option>
												<option value="Complaint-Return-Non Returnable Product-Tags Not Available - Not Received">Complaint-Return-Non Returnable Product-Tags Not Available - Not Received</option>
												<option value="Complaint-Return-Cancelation Request (Chatbot Only)-Return To Be Cancelled (Chatbot Only)">Complaint-Return-Cancelation Request (Chatbot Only)-Return To Be Cancelled (Chatbot Only)</option>
												<option value="Query-Return/Exchange-Create A Return For Me-Defective Product Received">Query-Return/Exchange-Create A Return For Me-Defective Product Received</option>
												<option value="Complaint-Marketing-Gift Not Received Post Winning Contest-N/A">Complaint-Marketing-Gift Not Received Post Winning Contest-N/A</option>
												<option value="Complaint-Return-Non Ajio Product Returned-Product Reached Wh">Complaint-Return-Non Ajio Product Returned-Product Reached Wh</option>
												<option value="Query-Return/Exchange-How Do I Return/Exchange This Item?-Email Sent To Confirm Policy - Didn'T Like Product">Query-Return/Exchange-How Do I Return/Exchange This Item?-Email Sent To Confirm Policy - Didn'T Like Product</option>
												<option value="Complaint-Website-Complaint Relating To Website-Order Delivered - Consignment Not Visible">Complaint-Website-Complaint Relating To Website-Order Delivered - Consignment Not Visible</option>
												<option value="Complaint-Return-Complaint Against Delivery Person-Didn?T Have Pickup Receipt">Complaint-Return-Complaint Against Delivery Person-Didn?T Have Pickup Receipt</option>
												<option value="Query-Return/Exchange-Create A Return For Me-Created Return - Product Damaged Post Usage">Query-Return/Exchange-Create A Return For Me-Created Return - Product Damaged Post Usage</option>
												<option value="Query-Order-What Are My Delivery / Payment Options?-Informed Customer Of Payment Options">Query-Order-What Are My Delivery / Payment Options?-Informed Customer Of Payment Options</option>
												<option value="Query-Website-Access/Function-Helped In Signup/Login">Query-Website-Access/Function-Helped In Signup/Login</option>
												<option value="Query-Return/Exchange-Has My Self-Ship Return Reached You?-Informed - Reached Warehouse And Refund Pending">Query-Return/Exchange-Has My Self-Ship Return Reached You?-Informed - Reached Warehouse And Refund Pending</option>
												<option value="Query-Return/Exchange-How Do I Return/Exchange This Item?-Email Sent To Confirm Policy - Missing Product/Component">Query-Return/Exchange-How Do I Return/Exchange This Item?-Email Sent To Confirm Policy - Missing Product/Component</option>
												<option value="Query-Mobile App-I Am Unable To Login/Sign Up On The App-Helped The Customer Login/Signup">Query-Mobile App-I Am Unable To Login/Sign Up On The App-Helped The Customer Login/Signup</option>
												<option value="Complaint-Account-Fraudulent Activity Reported ( Cyber Crime)-N/A">Complaint-Account-Fraudulent Activity Reported ( Cyber Crime)-N/A</option>
												<option value="Complaint-Mobile App-Complaint Relating To Mobile App-Unable To Cancel">Complaint-Mobile App-Complaint Relating To Mobile App-Unable To Cancel</option>
												<option value="Query-Ob-Npr-Not Contactable1">Query-Ob-Npr-Not Contactable1</option>
												<option value="Query-Mobile App-Others-Others">Query-Mobile App-Others-Others</option>
												<option value="Query-Account-I Need Help With My Account-Guided Customer On Password Query">Query-Account-I Need Help With My Account-Guided Customer On Password Query</option>
												<option value="Complaint-Return-Non Returnable Product-Used Product Delivered">Complaint-Return-Non Returnable Product-Used Product Delivered</option>
												<option value="Query-Price-How Much Does Gift Wrap Cost?-Guided Customer On Gift Wrap Charges">Query-Price-How Much Does Gift Wrap Cost?-Guided Customer On Gift Wrap Charges</option>
												<option value="Query-Return/Exchange-How Do I Return/Exchange This Item?-Email Sent To Confirm Policy - Fitment Issue">Query-Return/Exchange-How Do I Return/Exchange This Item?-Email Sent To Confirm Policy - Fitment Issue</option>
												<option value="Query-Nar Calls/Emails-Nar Emails-No Action Required">Query-Nar Calls/Emails-Nar Emails-No Action Required</option>
												<option value="Feedback-Feedback-Suggestions About Convenience Charge-Na">Feedback-Feedback-Suggestions About Convenience Charge-Na</option>
												<option value="Query-Nar Calls/Emails-Nar Calls-Already Actioned">Query-Nar Calls/Emails-Nar Calls-Already Actioned</option>
												<option value="Query-Ticket-Cx-Shared Attachment-Cx-Shared Attachment">Query-Ticket-Cx-Shared Attachment-Cx-Shared Attachment</option>
												<option value="Query-Refund-Why Is My Return Rejected/Put On Hold?-Guided Customer On Reason">Query-Refund-Why Is My Return Rejected/Put On Hold?-Guided Customer On Reason</option>
												<option value="Query-Order-What Are My Delivery / Payment Options?-Informed Customer Of Serviceability">Query-Order-What Are My Delivery / Payment Options?-Informed Customer Of Serviceability</option>
												<option value="Query-Ob-Ticket-Ticket Created">Query-Ob-Ticket-Ticket Created</option>
												<option value="Query-Refund-How Do I Get My Money Back?-Informed Customer About Drop At Store Refund ? Prepaid Order">Query-Refund-How Do I Get My Money Back?-Informed Customer About Drop At Store Refund ? Prepaid Order</option>
												<option value="Complaint-Account-Suspended Account (Reason For Suspension Required)-Customer Wanted Wallet Amount Transferred">Complaint-Account-Suspended Account (Reason For Suspension Required)-Customer Wanted Wallet Amount Transferred</option>
												<option value="Complaint-Account-Store Credit Debited Order Not Processed-R-1 Points">Complaint-Account-Store Credit Debited Order Not Processed-R-1 Points</option>
												<option value="Query-Return/Exchange-How Do I Return/Exchange This Item?-Declined - Product Used">Query-Return/Exchange-How Do I Return/Exchange This Item?-Declined - Product Used</option>
												<option value="Proactive Sr-Wh - Order Related Issues-Customer Return-Tags Missing">Proactive Sr-Wh - Order Related Issues-Customer Return-Tags Missing</option>
												<option value="Complaint-Website-Complaint Related To Website-R - One Points Not Visible">Complaint-Website-Complaint Related To Website-R - One Points Not Visible</option>
												<option value="Query-Pre Order - Ajio Lux-Where Can I Find This Product?-Informed Customer That The Product Is Not In Stock">Query-Pre Order - Ajio Lux-Where Can I Find This Product?-Informed Customer That The Product Is Not In Stock</option>
												<option value="Query-Refund-How Do I Get My Money Back?-Informed Cx About Cash Refund For Drop At Store">Query-Refund-How Do I Get My Money Back?-Informed Cx About Cash Refund For Drop At Store</option>
												<option value="Feedback-Feedback-Suggestions About Profile-N/A">Feedback-Feedback-Suggestions About Profile-N/A</option>
												<option value="Query-Other-I Need To Speak In Regional Language-Informed About Non-Availability">Query-Other-I Need To Speak In Regional Language-Informed About Non-Availability</option>
												<option value="Complaint-Account-Suspended Account (Reason For Suspension Required)-Customer Wanted To Return Product">Complaint-Account-Suspended Account (Reason For Suspension Required)-Customer Wanted To Return Product</option>
												<option value="Complaint-Return-Non Returnable Product-Damaged Product Received - Fragile">Complaint-Return-Non Returnable Product-Damaged Product Received - Fragile</option>
												<option value="Complaint-Goodwill Request-Cm Insisting Compensation-Coupon Reactivation">Complaint-Goodwill Request-Cm Insisting Compensation-Coupon Reactivation</option>
												<option value="Query-Nar Calls/Emails-Nar Emails-Already Actioned">Query-Nar Calls/Emails-Nar Emails-Already Actioned</option>
												<option value="Complaint-Return-Non Ajio Product Returned-Product Picked Up">Complaint-Return-Non Ajio Product Returned-Product Picked Up</option>
												<option value="Query-Pre Order - F&L-I Need Warranty Information-Provided Information">Query-Pre Order - F&L-I Need Warranty Information-Provided Information</option>
												<option value="Query-Ob-Npr-Picked Up">Query-Ob-Npr-Picked Up</option>
												<option value="Complaint-Account-Store Credit Discrepancy-Jio Mahabachat Points">Complaint-Account-Store Credit Discrepancy-Jio Mahabachat Points</option>
												<option value="Query-Account-I Did Not Place This Order-Cancelled The Order">Query-Account-I Did Not Place This Order-Cancelled The Order</option>
												<option value="Query-Pre Order - F&L-Where Can I Find This Product?-Helped Customer To Find The Product">Query-Pre Order - F&L-Where Can I Find This Product?-Helped Customer To Find The Product</option>
												<option value="Complaint-Return-Additional Self Ship Courier Charges Required-N/A">Complaint-Return-Additional Self Ship Courier Charges Required-N/A</option>
												<option value="Query-Business-I Want To Apply For Job At Ajio-Guided Customer On Process">Query-Business-I Want To Apply For Job At Ajio-Guided Customer On Process</option>
												<option value="Query-Return/Exchange-How Do I Return/Exchange This Item?-Informed How Drop At Store Option Works">Query-Return/Exchange-How Do I Return/Exchange This Item?-Informed How Drop At Store Option Works</option>
												<option value="Query-Account-How Do I Use Jiomoney?-Guided Customer To Jiomoney Customer Care">Query-Account-How Do I Use Jiomoney?-Guided Customer To Jiomoney Customer Care</option>
												<option value="Query-Website-Access/Function-Helped In Returning Order">Query-Website-Access/Function-Helped In Returning Order</option>
												<option value="Query-Return/Exchange-Is My Pin Code Serviceable For Exchange/Return?-Informed About Non Availability Of Exchange At Store">Query-Return/Exchange-Is My Pin Code Serviceable For Exchange/Return?-Informed About Non Availability Of Exchange At Store</option>
												<option value="Query-Nar Calls/Emails-Nar Emails-Duplicate Email">Query-Nar Calls/Emails-Nar Emails-Duplicate Email</option>
												<option value="Query-Return/Exchange-Is My Pin Code Serviceable For Exchange/Return?-Informed Serviceability Of Drop At Store For Product/Store">Query-Return/Exchange-Is My Pin Code Serviceable For Exchange/Return?-Informed Serviceability Of Drop At Store For Product/Store</option>
												<option value="Query-Other-I Need To Speak In Regional Language-Transferred Call To Other Champ">Query-Other-I Need To Speak In Regional Language-Transferred Call To Other Champ</option>
												<option value="Query-Ob-Ticket-Ticket Closed">Query-Ob-Ticket-Ticket Closed</option>
												<option value="Complaint-Account-R- One Related-R - One Refund Not Credited">Complaint-Account-R- One Related-R - One Refund Not Credited</option>
												<option value="Query-Pre Order - Tech Related - Mobile / Iphone-Where Can I Buy Accessory-Provided Information">Query-Pre Order - Tech Related - Mobile / Iphone-Where Can I Buy Accessory-Provided Information</option>
												<option value="Complaint-Mobile App-Complaint Relating To Mobile App-Unable To View/Edit Profile Details">Complaint-Mobile App-Complaint Relating To Mobile App-Unable To View/Edit Profile Details</option>
												<option value="Complaint-Mobile App-Complaint Relating To Mobile App-Issue With Product Page Info">Complaint-Mobile App-Complaint Relating To Mobile App-Issue With Product Page Info</option>
												<option value="Complaint-Website-Complaint Relating To Website-Mrp Mismatch">Complaint-Website-Complaint Relating To Website-Mrp Mismatch</option>
												<option value="Query-Pre Order - Tech Related - Jio Fi-Where Can I Buy Accessory-Provided Information">Query-Pre Order - Tech Related - Jio Fi-Where Can I Buy Accessory-Provided Information</option>
												<option value="Complaint-Mobile App-Complaint Relating To Mobile App-No Confirmation Received On Website/Email/Sms">Complaint-Mobile App-Complaint Relating To Mobile App-No Confirmation Received On Website/Email/Sms</option>
												<option value="Query-Pre Order - Tech Related - Others-Where Can I Find This Product?-Helped Customer To Find The Product">Query-Pre Order - Tech Related - Others-Where Can I Find This Product?-Helped Customer To Find The Product</option>
												<option value="Query-Ob-Delayed Delivery-Not Connected">Query-Ob-Delayed Delivery-Not Connected</option>
												<option value="Query-Account-I Did Not Place This Order-Retained The Order">Query-Account-I Did Not Place This Order-Retained The Order</option>
												<option value="Feedback-Feedback-Suggestions About Cc-Unable To Reach Customer Care Number">Feedback-Feedback-Suggestions About Cc-Unable To Reach Customer Care Number</option>
												<option value="Complaint-Mobile App-Complaint Relating To Mobile App-Mrp Mismatch">Complaint-Mobile App-Complaint Relating To Mobile App-Mrp Mismatch</option>
												<option value="Query-Pre Order - Ajio Lux-Where Can I Find This Product?-Helped Customer To Find The Product">Query-Pre Order - Ajio Lux-Where Can I Find This Product?-Helped Customer To Find The Product</option>
												<option value="Query-Pre Order - Rj-Explain The Features Of The Product-Explained About Product Features / Pricing">Query-Pre Order - Rj-Explain The Features Of The Product-Explained About Product Features / Pricing</option>
												<option value="Query-Business-I Want To Do Marketing/Promotion For Ajio-Advised About The Procedure">Query-Business-I Want To Do Marketing/Promotion For Ajio-Advised About The Procedure</option>
												<option value="Query-Ob-Qc Fail While Returning-Others">Query-Ob-Qc Fail While Returning-Others</option>
												<option value="Query-Ob-Misc-Not Connected - Email Sent">Query-Ob-Misc-Not Connected - Email Sent</option>
												<option value="Complaint-Delivery-Cancelation Request (Chatbot Only)-Exchange To Be Cancelled (Chatbot Only)">Complaint-Delivery-Cancelation Request (Chatbot Only)-Exchange To Be Cancelled (Chatbot Only)</option>
												<option value="Complaint-Account-Jio Mahabachat Points-Points Not Credited Against Ajio Purchase">Complaint-Account-Jio Mahabachat Points-Points Not Credited Against Ajio Purchase</option>
												<option value="Query-Ob-Survey-Completed">Query-Ob-Survey-Completed</option>
												<option value="Complaint-Website-Complaint Relating To Website-Product Details Required">Complaint-Website-Complaint Relating To Website-Product Details Required</option>
												<option value="Query-Other-I Want Compensation-Transferred Call To Supervisor">Query-Other-I Want Compensation-Transferred Call To Supervisor</option>
												<option value="Query-Business-I Want To Sell My Merchandise On Ajio-Advised About The Procedure">Query-Business-I Want To Sell My Merchandise On Ajio-Advised About The Procedure</option>
												<option value="Query-Ob-Ticket-Ticket Follow Up">Query-Ob-Ticket-Ticket Follow Up</option>
												<option value="Query-Business-Others-Advised About The Procedure">Query-Business-Others-Advised About The Procedure</option>
												<option value="Query-Return/Exchange-Create An Exchange For Me-Created Exchange ? Received Damaged Product">Query-Return/Exchange-Create An Exchange For Me-Created Exchange ? Received Damaged Product</option>
												<option value="Query-Nar Calls/Emails-Test-Test Call">Query-Nar Calls/Emails-Test-Test Call</option>
												<option value="Query-Order-Excess Cod Collected-Informed Customer To Share Image/Screenshot">Query-Order-Excess Cod Collected-Informed Customer To Share Image/Screenshot</option>
												<option value="Proactive Sr-Wh - Order Related Issues-Customer Return-Customer Confirmation Required (Non-Ajio Product Received)">Proactive Sr-Wh - Order Related Issues-Customer Return-Customer Confirmation Required (Non-Ajio Product Received)</option>
												<option value="Complaint-Mobile App-Complaint Relating To Mobile App-Unable To Signup">Complaint-Mobile App-Complaint Relating To Mobile App-Unable To Signup</option>
												<option value="Proactive Sr-Reliance Jewels-I Want Certification Of Authenticity-Certificate To Be Sent">Proactive Sr-Reliance Jewels-I Want Certification Of Authenticity-Certificate To Be Sent</option>
												<option value="Complaint-Voc-Complaint Against Cc Employee-N/A">Complaint-Voc-Complaint Against Cc Employee-N/A</option>
												<option value="Complaint-Return-Non Returnable Product-Tags Not Available - Misplaced By Customer">Complaint-Return-Non Returnable Product-Tags Not Available - Misplaced By Customer</option>
												<option value="Query – Return/Exchange-Return On Hold – Informed about Release/Verification TAT">Query – Return/Exchange-Return On Hold – Informed about Release/Verification TAT</option>
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
												<option ajio_val=10 ajio_max=10 <?php echo $ajio_inb_v2['handle_objection_effectively'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
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
										<td  style="">Call/Interaction was authenticated wherever required</td>
										<td>
											<select class="form-control ajio" id="ajioAF4_inb_v2" name="data[call_was_authenticated]" required>
												<option ajio_val=5 ajio_max=5 <?php echo $ajio_inb_v2['call_was_authenticated'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ajio_val=0 ajio_max=5 <?php echo $ajio_inb_v2['call_was_authenticated'] == "No"?"selected":"";?> value="No">No</option>
												<!-- <option ajio_val=5 ajio_max=5 <?php //echo $ajio_inb_v2['call_was_authenticated'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
												<option ajio_val=0 ajio_max=5 <?php //echo $ajio_inb_v2['call_was_authenticated'] == "Autofail"?"selected":"";?> value="Autofail">Autofail</option> -->
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
													<option value="<?php echo $ajio_inb_v2['l1_reason13'] ?>"><?php echo $ajio_inb_v2['l1_reason13'] ?></option>
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
											<select class="form-control ajio fatal ajioAF8"  id="ajioAF8_inb_v2" name="data[ztp_guidelines]" required>
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
										<td>Call Synopsis:</td>
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
										
										<tr><td colspan=2  style="font-size:16px">Your Review</td><td colspan=4><textarea class="form-control1" style="width:100%" id="note" name="note"  ></textarea></td></tr>
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
