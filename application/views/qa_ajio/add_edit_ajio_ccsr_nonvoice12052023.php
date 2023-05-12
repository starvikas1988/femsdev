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
										<td colspan="7" id="theader" style="font-size:40px">AJIO [CCSR NON-Voice]</td>
										<input type="hidden" name="audit_start_time" value="<?php echo CurrMySqlDate(); ?>">
									</tr>
									<?php
										if($ajio_id==0){
											$auditorName = get_username();
											$auditDate = CurrDateMDY();
											$clDate_val='';
										}else{
											if($ajio_ccsr_nonvoice['entry_by']!=''){
												$auditorName = $ajio_ccsr_nonvoice['auditor_name'];
											}else{
												$auditorName = $ajio_ccsr_nonvoice['client_name'];
											}
											$auditDate = mysql2mmddyy($ajio_ccsr_nonvoice['audit_date']);
											$clDate_val = mysqlDt2mmddyy($ajio_ccsr_nonvoice['call_date']);
										}
										//onkeydown="return false;"
									?>
									<tr>
										<td>Auditor Name:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control" value="<?php echo $auditorName; ?>" disabled></td>
										<td>Audit Date:<span style="font-size:24px;color:red">*</span></td>
										<td style="width:200px;"><input type="text" class="form-control" value="<?php echo $auditDate; ?>" disabled></td>
										<td style="width:100px">Call Date/Time:<span style="font-size:24px;color:red">*</span></td>
										<td colspan="2"><input type="text" class="form-control" id="call_date_time" name="call_date" value="<?php echo $clDate_val; ?>" required></td>
									</tr>
									<tr>
										<td>Champ/Agent Name:<span style="font-size:24px;color:red">*</span></td>
										<td>
											<select class="form-control" id="agent_id" name="data[agent_id]" required >
												<?php
												if ($ajio_ccsr_nonvoice['agent_id']!='') {
													?>
													<option value="<?php echo $ajio_ccsr_nonvoice['agent_id'] ?>"><?php echo $ajio_ccsr_nonvoice['fname']." ".$ajio_ccsr_nonvoice['lname'] ?></option>
													<?php
												}
												?>
												<option value="">-Select-</option>
												<?php foreach($agentName as $row):  ?>
													<option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
												<?php endforeach; ?>
											</select>
										</td>
										<td>Fusion ID:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control" id="fusion_id" value="<?php echo $ajio_ccsr_nonvoice['fusion_id'] ?>" readonly ></td>
										<td>L1 Supervisor:</td>
										<td colspan="2">
											<input type="text" class="form-control" id="tl_names"  value="<?php echo $ajio_ccsr_nonvoice['tl_name'] ?>" readonly>
												<input type="hidden" class="form-control" id="tl_id" name="data[tl_id]" value="<?php echo $ajio_ccsr_nonvoice['tl_id'] ?>" required>
										</td>
									</tr>
									<tr>
										<td>Interaction ID:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control" name="data[call_id]" value="<?php echo $ajio_ccsr_nonvoice['call_id'] ?>" required ></td>
										<td>Type of Audit:<span style="font-size:24px;color:red">*</span></td>
										<td>
											<select class="form-control" name="data[type_of_audit]" required>
												<?php 
												if($ajio_ccsr_nonvoice['type_of_audit']!=''){
													?>
													<option value="<?php echo $ajio_ccsr_nonvoice['type_of_audit'] ?>"><?php echo $ajio_ccsr_nonvoice['type_of_audit'] ?></option>
													<?php
												}
												?>
												<option value="">-Select-</option>
												<option value="GB Audit">GB Audit</option>
												<option value="High AHT Audit">High AHT Audit</option>
												<option value="Random Audit">Random Audit</option>
												<option value="A2A">A2A</option>
												<option value="Calibration">Calibration</option>
											</select>
										</td>
										<td>VOC:<span style="font-size:24px;color:red">*</span></td>
										<td colspan="2">
											<select class="form-control" id="voc" name="data[voc]" required>
												<?php
												if($ajio_ccsr_nonvoice['voc']!=''){
													?>
													<option value="<?php echo $ajio_ccsr_nonvoice['voc'] ?>"><?php echo $ajio_ccsr_nonvoice['voc'] ?></option>
													<?php
												}
												 ?> 
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
										<td>Order Id:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control" name="data[order_id]" value="<?php echo $ajio_ccsr_nonvoice['order_id']; ?>" requied>
										</td>
										<td>Ticket Id:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control" name="data[ticket_id]" value="<?php echo $ajio_ccsr_nonvoice['ticket_id']; ?>" requied>
										</td>
										<td>Partner:<span style="font-size:24px;color:red">*</span></td>
										<td colspan="2"><input type="text" class="form-control" name="data[partner]" value="<?php echo $ajio_ccsr_nonvoice['partner']; ?>" requied>
										</td>
									</tr>
									<tr>
										<td>Predactive CSAT:<span style="font-size:24px;color:red">*</span></td>
										<td>
											<select class="form-control" id="audit_type" name="data[audit_type]" >
												<?php 
												if($ajio_ccsr_nonvoice['audit_type']!=''){
													?>
													<option value="<?php echo $ajio_ccsr_nonvoice['audit_type'] ?>"><?php echo $ajio_ccsr_nonvoice['audit_type'] ?></option>
													<?php
												}
												?>
												<option value="">-Select-</option>
												<option value="CQ Audit">CQ Audit</option>
												<option value="BQ Audit">BQ Audit</option>
												<option value="Calibration">Calibration</option>
												<option value="Pre-Certificate Mock Call">Pre-Certificate Mock Call</option>
												<option value="Certification Audit">Certification Audit</option>
												<option value="Operation Audit">Operation Audit</option>
												<option value="Trainer Audit">Trainer Audit</option>
												<option value="Hygiene Audit">Hygiene Audit</option>
											</select>
										</td>
										<td class="auType">Auditor Type</td>
										<td class="auType">
											<select class="form-control" id="auditor_type" name="data[auditor_type]">
												<option value="">-Select-</option>
												<option value="Master">Master</option>
												<option value="Regular">Regular</option>
											</select>
										</td>
									</tr>
									<tr>
									<td>Ticket Type:<span style="font-size:24px;color:red">*</span></td>
										<td>
											<select class="form-control" id="ticket_type" name="data[ticket_type]" required>
												<option value="">-Select-</option>
												<option <?php echo $ajio_ccsr_nonvoice['ticket_type']=='Complaint'?"selected":""; ?> value="Complaint">Complaint</option>
												<option <?php echo $ajio_ccsr_nonvoice['ticket_type']=='Query'?"selected":""; ?> value="Query">Query</option>
												<option <?php echo $ajio_ccsr_nonvoice['ticket_type']=='Proactive SR'?"selected":""; ?> value="Proactive SR">Proactive SR</option>
											</select>
										</td>
									<td>Tagging By Evaluator:<span style="font-size:24px;color:red">*</span></td>
										<td colspan="2">
											<select class="form-control" id="tagging_evaluator" name="data[tagging_evaluator]" required>
												<option value="">-Select-</option>
												<option <?php echo $ajio_ccsr_nonvoice['tagging_evaluator']=='Delivery-Fake Attempt-N/A'?"selected":""; ?> value="Delivery-Fake Attempt-N/A">Delivery-Fake Attempt-N/A</option>
												<option <?php echo $ajio_ccsr_nonvoice['tagging_evaluator']=='Account-Store Credit Debited Order Not Processed-N/A'?"selected":""; ?> value="Account-Store Credit Debited Order Not Processed-N/A">Account-Store Credit Debited Order Not Processed-N/A</option>
												<option <?php echo $ajio_ccsr_nonvoice['tagging_evaluator']=='Account-Store Credit Discrepancy-Others'?"selected":""; ?> value="Account-Store Credit Discrepancy-Others">Account-Store Credit Discrepancy-Others</option>
												<option <?php echo $ajio_ccsr_nonvoice['tagging_evaluator']=='Account-Customer information Leak-N/A'?"selected":""; ?> value="Account-Customer information Leak-N/A">Account-Customer information Leak-N/A</option>
												<option <?php echo $ajio_ccsr_nonvoice['tagging_evaluator']=='Callback-Others-N/A'?"selected":""; ?> value="Callback-Others-N/A">Callback-Others-N/A</option>
												<option value="Delivery-Snatch Case-N/A"  <?= ($ajio_ccsr_nonvoice['audit_type']=="Delivery-Snatch Case-N/A")?"selected":"" ?>>Delivery-Snatch Case-N/A</option>
                                                <option value="Delivery-Order not dispatched from Warehouse-N/A"  <?= ($ajio_ccsr_nonvoice['tagging_evaluator']=="Delivery-Order not dispatched from Warehouse-N/A")?"selected":"" ?>>Delivery-Order not dispatched from Warehouse-N/A</option>
                                                <option value="Delivery-Delayed Delivery-N/A"  <?= ($ajio_ccsr_nonvoice['tagging_evaluator']=="Delivery-Delayed Delivery-N/A")?"selected":"" ?>>Delivery-Delayed Delivery-N/A</option>
											</select>
										</td>		
									</tr>
									<tr>
									<td>Auditor Department:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control" value="<?php echo $department[0]['department']; ?>" disabled>
										</td>
									<td>Auditor Role:<span style="font-size:24px;color:red">*</span></td>
										<td colspan="2"><input type="text" class="form-control" value="<?php echo $role[0]['role']; ?>" disabled>
										</td>		
									</tr>
									
									<tr>
										<td style="font-weight:bold; font-size:16px; text-align:right">Earned Score:</td>
										<td><input type="text" readonly id="earnedScore" name="data[earned_score]" class="form-control" style="font-weight:bold" value="<?php echo $ajio_ccsr_nonvoice['earned_score'] ?>"></td>
										<td style="font-weight:bold; font-size:16px; text-align:right">Possible Score:</td>
										<td><input type="text" readonly id="possibleScore" name="data[possible_score]" class="form-control" style="font-weight:bold" value="<?php echo $ajio_ccsr_nonvoice['possible_score'] ?>"></td>
										<td style="font-weight:bold; font-size:16px; text-align:right">Overall Score:</td>
										<td colspan="2"><input type="text" readonly id="overallScore" name="data[overall_score]" class="form-control ajio_ccsr_nonvoice_Fatal" style="font-weight:bold" value="<?php echo $ajio_ccsr_nonvoice['overall_score'] ?>"></td>
									</tr>
									<tr style="font-weight:bold">
										<td><input type="hidden" class="form-control" id="prefatal" name="data[pre_fatal_score]" value="<?php echo $ajio_ccsr_nonvoice['pre_fatal_score'] ?>"></td>
										<td><input type="hidden" class="form-control" id="fatalcount" name="data[fatal_count]" value="<?php echo $ajio_ccsr_nonvoice['fatal_count'] ?>"></td>
									</tr>
									<tr style="background-color:#85C1E9; font-weight:bold">
										<td>Parameter</td>
										<td colspan=2>Sub Parameter</td>
										<td>Defect</td>
										<td>Weightage</td>
										<td>L1 Reason</td>
										<td>Remarks</td>
									</tr>
									<tr>
										<td rowspan=7 style="background-color:#85C1E9; font-weight:bold">Comprehension & Email Ettiquettes</td>
										<td colspan=2>Did the champ use appropriate acknowledgements, re-assurance and apology wherever required</td>
										<td>
											<select class="form-control ajio" id="appropriate_acknowledgements_ccsrnonvoice" name="data[appropriate_acknowledgements]" required>
												<option ajio_val=10 ajio_max=10 <?php echo $ajio_ccsr_nonvoice['appropriate_acknowledgements'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ajio_val=0 ajio_max=10 <?php echo $ajio_ccsr_nonvoice['appropriate_acknowledgements'] == "No"?"selected":"";?> value="No">No</option>
											</select>
										</td>
										<td>10</td>
										<td>
											<!-- <textarea class="form-control" name="data[l1_reason1]"><?php //echo $ajio_ccsr_nonvoice['l1_reason1'] ?></textarea> -->
											<select class="form-control" id="appropriat_ccsrnonvoice" name="data[l1_reason1]" required>
												<?php 
												if($ajio_ccsr_nonvoice['l1_reason1']!=''){
													?>
													<option value="<?php echo $ajio_ccsr_nonvoice['l1_reason1'] ?>"><?php echo $ajio_ccsr_nonvoice['l1_reason1'] ?></option>
													<?php
												}
												?>
												<option  <?php echo $ajio_ccsr_nonvoice['l1_reason1'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
												
											</select>
										</td>
										<td><textarea class="form-control" name="data[cmt1]"><?php echo $ajio_ccsr_nonvoice['cmt1'] ?></textarea></td>
									</tr>
									<tr>
										<td colspan=2>Did the champ use font, font size, and formatting  as per AJIO's brand guidelines</td>
										<td>
											<select class="form-control ajio" id="font_size_formatting_cccsrnonvoice" name="data[font_size_formatting]" required>
												<option ajio_val=5 ajio_max=5 <?php echo $ajio_ccsr_nonvoice['font_size_formatting'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ajio_val=0 ajio_max=5 <?php echo $ajio_ccsr_nonvoice['font_size_formatting'] == "No"?"selected":"";?> value="No">No</option>
											</select>
										</td>
										<td>5</td>
										<td>
											<!-- <textarea class="form-control" name="data[l1_reason2]"><?php echo $ajio_ccsr_nonvoice['l1_reason2'] ?></textarea> -->
											<select class="form-control" id="font_size_cccsrnonvoice" name="data[l1_reason2]" required>
												<?php 
												if($ajio_ccsr_nonvoice['l1_reason2']!=''){
													?>
													<option value="<?php echo $ajio_ccsr_nonvoice['l1_reason2'] ?>"><?php echo $ajio_ccsr_nonvoice['l1_reason2'] ?></option>
													<?php
												}
												?>
												<option  <?php echo $ajio_ccsr_nonvoice['l1_reason2'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td><textarea class="form-control" name="data[cmt2]"><?php echo $ajio_ccsr_nonvoice['cmt2'] ?></textarea></td>
									</tr>
									<tr>
										<td colspan=2>Was the email response in line with AJIO's approved template/format </td>
										<td>
											<select class="form-control ajio" id="approved_template_ccsrnonvoice" name="data[approved_template]" required>
												<option ajio_val=5 ajio_max=5 <?php echo $ajio_ccsr_nonvoice['approved_template'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ajio_val=0 ajio_max=5 <?php echo $ajio_ccsr_nonvoice['approved_template'] == "No"?"selected":"";?> value="No">No</option>
											</select>
										</td>
										<td>5</td>
										<td>
											<!-- <textarea class="form-control" name="data[l1_reason3]"><?php //echo $ajio_ccsr_nonvoice['l1_reason3'] ?></textarea> -->
											<select class="form-control" id="approved_ccsrnonvoice" name="data[l1_reason3]" required>
												<?php 
												if($ajio_ccsr_nonvoice['l1_reason3']!=''){
													?>
													<option value="<?php //echo $ajio_ccsr_nonvoice['audit_type'] ?>"><?php echo $ajio_ccsr_nonvoice['l1_reason3'] ?></option>
													<?php
												}
												?>
												<option  <?php echo $ajio_ccsr_nonvoice['l1_reason3'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>	
										</td>
										<td><textarea class="form-control" name="data[cmt3]"><?php echo $ajio_ccsr_nonvoice['cmt3'] ?></textarea></td>
									</tr>
									<tr>
										<td colspan=2 >Was the champ able to comprehend and articulate the resolution to the cusomer in a manner which was easily understood by the customer.</td>
										<td>
										<select class="form-control ajio" id="seamlessly_ccsrnonvoice" name="data[seamlessly]" required>
												<option ajio_val=10 ajio_max=10 <?php echo $ajio_ccsr_nonvoice['seamlessly'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ajio_val=0 ajio_max=10 <?php echo $ajio_ccsr_nonvoice['seamlessly'] == "No"?"selected":"";?> value="No">No</option>
											</select>
										</td>
										<td>10</td>
										<td>
											<!-- <textarea class="form-control" name="data[l1_reason4]"><?php //echo $ajio_ccsr_nonvoice['l1_reason4'] ?></textarea> -->
											<select class="form-control" id="seam_ccsrnonvoice" name="data[l1_reason4]" required>
												<?php 
												if($ajio_ccsr_nonvoice['l1_reason4']!=''){
													?>
													<option value="<?php //echo $ajio_ccsr_nonvoice['audit_type'] ?>"><?php echo $ajio_ccsr_nonvoice['l1_reason4'] ?></option>
													<?php
												}
												?>
												<option  <?php echo $ajio_ccsr_nonvoice['l1_reason4'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>	
										</td>
										<td><textarea class="form-control" name="data[cmt4]"><?php echo $ajio_ccsr_nonvoice['cmt4'] ?></textarea></td>
									</tr>

									<tr>
										<td colspan=2 style="color:red">Did the champ refer to all relevant previous interactions when required to gather information about customer's account and issue end to end</td>
										<td>
											<select class="form-control ajio fatal ajioAF7" id="ajioAF7_ccsrnonvoice" name="data[gather_information]" required>
												<option ajio_val=10 ajio_max=10 <?php echo $ajio_ccsr_nonvoice['gather_information'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ajio_val=0 ajio_max=10 <?php echo $ajio_ccsr_nonvoice['gather_information'] == "Autofail"?"selected":"";?> value="Autofail">Autofail</option>
											</select>
										</td>
										<td>10</td>
										<td>
											<!-- <textarea class="form-control" name="data[l1_reason5]"><?php //echo $ajio_ccsr_nonvoice['l1_reason5'] ?></textarea> -->
											<select class="form-control" id="gather_information_ccsrnonvoice" name="data[l1_reason5]" required>
												<?php 
												if($ajio_ccsr_nonvoice['l1_reason5']!=''){
													?>
													<option value="<?php //echo $ajio_ccsr_nonvoice['audit_type'] ?>"><?php echo $ajio_ccsr_nonvoice['l1_reason5'] ?></option>
													<?php
												}
												?>
												<option  <?php echo $ajio_ccsr_nonvoice['l1_reason5'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>	

										</td>
										<td><textarea class="form-control" name="data[cmt5]"><?php echo $ajio_ccsr_nonvoice['cmt5'] ?></textarea></td>
									</tr>
									<tr>
										<td colspan=2 style="color:red">Did the champ use appropriate template(s) and customized it to ensure all concerns raised were answered appropriately</td>
										<td>
										<select class="form-control ajio fatal ajioAF1" id="ajioAF1_ccsrnonvoice" name="data[use_appropriate_template]" required>
												<option ajio_val=10 ajio_max=10 <?php echo $ajio_ccsr_nonvoice['use_appropriate_template'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ajio_val=0 ajio_max=10 <?php echo $ajio_ccsr_nonvoice['use_appropriate_template'] == "Autofail"?"selected":"";?> value="Autofail">Autofail</option>
											</select>
										</td>
										<td>10</td>
										<td>
											<select class="form-control" id="appro_ccsrnonvoice" name="data[l1_reason6]" required>
												<?php 
												if($ajio_ccsr_nonvoice['l1_reason6']!=''){
													?>
													<option value="<?php //echo $ajio_ccsr_nonvoice['audit_type'] ?>"><?php echo $ajio_ccsr_nonvoice['l1_reason6'] ?></option>
													<?php
												}
												?>
												<option  <?php echo $ajio_ccsr_nonvoice['l1_reason6'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td><textarea class="form-control" name="data[cmt6]"><?php echo $ajio_ccsr_nonvoice['cmt6'] ?></textarea></td>
									</tr>

									<tr>
										<td colspan=2 >Was the champ able to identify and handle objections effectively and offer rebuttals wherever required</td>
										<td>
										<select class="form-control ajio" id="offer_rebuttals_ccsrnonvoice" name="data[offer_rebuttals]" required>
												<option ajio_val=10 ajio_max=10 <?php echo $ajio_ccsr_nonvoice['offer_rebuttals'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ajio_val=0 ajio_max=10 <?php echo $ajio_ccsr_nonvoice['offer_rebuttals'] == "No"?"selected":"";?> value="No">No</option>
											</select>
										</td>
										<td>10</td>
										<td>
											<!-- <textarea class="form-control" name="data[l1_reason4]"><?php //echo $ajio_ccsr_nonvoice['l1_reason4'] ?></textarea> -->
											<select class="form-control" id="offer_rebu_ccsrnonvoice" name="data[l1_reason15]" required>
												<?php 
												if($ajio_ccsr_nonvoice['l1_reason15']!=''){
													?>
													<option value="<?php //echo $ajio_ccsr_nonvoice['audit_type'] ?>"><?php echo $ajio_ccsr_nonvoice['l1_reason15'] ?></option>
													<?php
												}
												?>
												<option  <?php echo $ajio_ccsr_nonvoice['l1_reason15'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>	
										</td>
										<td><textarea class="form-control" name="data[cmt15]"><?php echo $ajio_ccsr_nonvoice['cmt15'] ?></textarea></td>
									</tr>
									<tr>
										<td rowspan=4 style="background-color:#85C1E9; font-weight:bold">Effective System Navigation & KM Usage </td>
										<td colspan=2>Did the champ refer to different applications/portals/tools to identify the root cause of customer issue and enable resolution.</td>
										<td>
											<select class="form-control ajio" id="application_portals_ccsrnonvoice" name="data[application_portals]" required>
												<option ajio_val=5 ajio_max=5 <?php echo $ajio_ccsr_nonvoice['application_portals'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ajio_val=0 ajio_max=5 <?php echo $ajio_ccsr_nonvoice['application_portals'] == "No"?"selected":"";?> value="No">No</option>
											</select>
										</td>
										<td>5</td>
										<td>
											<!-- <textarea class="form-control" name="data[l1_reason7]"><?php //echo $ajio_ccsr_nonvoice['l1_reason7'] ?></textarea> -->
											<select class="form-control" id="application_port_ccsrnonvoice" name="data[l1_reason7]" required>
												<?php 
												if($ajio_ccsr_nonvoice['l1_reason18']!=''){
													?>
													<option value="<?php //echo $ajio_ccsr_nonvoice['audit_type'] ?>"><?php echo $ajio_ccsr_nonvoice['l1_reason18'] ?></option>
													<?php
												}
												?>
												<option  <?php echo $ajio_ccsr_nonvoice['l1_reason18'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td><textarea class="form-control" name="data[cmt18]"><?php echo $ajio_ccsr_nonvoice['cmt18'] ?></textarea></td>
									</tr>
								
									<tr>
										<td colspan=2>Did the champ refer to all releavnt articles/T2Rs correctly</td>
										<td>
										<select class="form-control ajio fatal" id="releavnt_ccsrnonvoice" name="data[relevant_previous_interactions]" required>
												<option ajio_val=5 ajio_max=5 <?php echo $ajio_ccsr_nonvoice['relevant_previous_interactions'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ajio_val=0 ajio_max=5 <?php echo $ajio_ccsr_nonvoice['relevant_previous_interactions'] == "No"?"selected":"";?> value="No">No</option>
											</select>
										</td>
										<td>5</td>
										<td>
											<!-- <textarea class="form-control" name="data[l1_reason7]"><?php //echo $ajio_ccsr_nonvoice['l1_reason7'] ?></textarea> -->
											<select class="form-control" id="rel_ccsr_nonvoice" name="data[l1_reason8]" required>
												<?php 
												if($ajio_ccsr_nonvoice['l1_reason8']!=''){
													?>
													<option value="<?php //echo $ajio_ccsr_nonvoice['audit_type'] ?>"><?php echo $ajio_ccsr_nonvoice['l1_reason8'] ?></option>
													<?php
												}
												?>
												<option  <?php echo $ajio_ccsr_nonvoice['l1_reason8'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td><textarea class="form-control" name="data[cmt8]"><?php echo $ajio_ccsr_nonvoice['cmt8'] ?></textarea></td>
									</tr>
									<tr>
										<td colspan=2 style="color:red">Email/Interaction was authenticated wherever required</td>
										<td>
											<select class="form-control ajio fatal ajioAF8" id="email_interaction_ccsrnonvoice" name="data[email_interaction]" required>
												<option ajio_val=5 ajio_max=5 <?php echo $ajio_ccsr_nonvoice['email_interaction'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ajio_val=0 ajio_max=5 <?php echo $ajio_ccsr_nonvoice['email_interaction'] == "Autofail"?"selected":"";?> value="Autofail">Autofail</option>
												<option ajio_val=5 ajio_max=5 <?php echo $ajio_ccsr_nonvoice['email_interaction'] == "No"?"selected":"";?> value="No">No</option>
											</select>
										</td>
										<td>5</td>
										<td>
											<!-- <textarea class="form-control" name="data[l1_reason7]"><?php //echo $ajio_ccsr_nonvoice['l1_reason7'] ?></textarea> -->
											<select class="form-control" id="email_interact_ccsrnonvoice" name="data[l1_reason16]" required>
												<?php 
												if($ajio_ccsr_nonvoice['l1_reason16']!=''){
													?>
													<option value="<?php //echo $ajio_ccsr_nonvoice['audit_type'] ?>"><?php echo $ajio_ccsr_nonvoice['l1_reason16'] ?></option>
													<?php
												}
												?>
												<option  <?php echo $ajio_ccsr_nonvoice['l1_reason16'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td><textarea class="form-control" name="data[cmt16]"><?php echo $ajio_ccsr_nonvoice['cmt16'] ?></textarea></td>
									</tr>
									<tr>
										<td colspan=2>Did the champ take ownership and request for outcall/call back was addressed wherever required</td>
										<td>
											<select class="form-control ajio" id="call_back_ccsrnonvoice" name="data[call_back_address]" required>
											<option ajio_val=5 ajio_max=5 <?php echo $ajio_ccsr_nonvoice['call_back_address'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ajio_val=0 ajio_max=5 <?php echo $ajio_ccsr_nonvoice['call_back_address'] == "Autofail"?"selected":"";?> value="Autofail">Autofail</option>
												<option ajio_val=5 ajio_max=5 <?php echo $ajio_ccsr_nonvoice['call_back_address'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td>5</td>
										<td>
											<!-- <textarea class="form-control" name="data[l1_reason8]"><?php //echo $ajio_ccsr_nonvoice['l1_reason8'] ?></textarea> -->
											<select class="form-control" id="call_bac_ccsrnonvoice" name="data[l1_reason17]" required>
												<?php 
												if($ajio_ccsr_nonvoice['l1_reason17']!=''){
													?>
													<option value="<?php //echo $ajio_ccsr_nonvoice['audit_type'] ?>"><?php echo $ajio_ccsr_nonvoice['l1_reason17'] ?></option>
													<?php
												}
												?>
												<option  <?php echo $ajio_ccsr_nonvoice['l1_reason17'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td><textarea class="form-control" name="data[cmt17]"><?php echo $ajio_ccsr_nonvoice['cmt17'] ?></textarea></td>
									</tr>
									<tr>
									<td rowspan=3 style="background-color:#85C1E9; font-weight:bold">Issue Resolution</td>
										<td colspan=2 style="color:red">Champ executed all necessary actions to ensure issue resolution</td>
										<td>
											<select class="form-control ajio fatal ajioAF3" id="ajio_ccsrnonvoiceAF3" name="data[ensure_issue_resolution]" required>
												<option ajio_val=5 ajio_max=5 <?php echo $ajio_ccsr_nonvoice['ensure_issue_resolution'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ajio_val=0 ajio_max=5 <?php echo $ajio_ccsr_nonvoice['ensure_issue_resolution'] == "Autofail"?"selected":"";?> value="Autofail">Autofail</option>
											</select>
										</td>
										<td>5</td>
										<td>
											<!-- <textarea class="form-control" name="data[l1_reason10]"><?php //echo $ajio_ccsr_nonvoice['l1_reason10'] ?></textarea> -->
											<select class="form-control" id="issue_ccsrnonvoice" name="data[l1_reason11]" required>
												<?php 
												if($ajio_ccsr_nonvoice['l1_reason11']!=''){
													?>
													<option value="<?php //echo $ajio_ccsr_nonvoice['audit_type'] ?>"><?php echo $ajio_ccsr_nonvoice['l1_reason11'] ?></option>
													<?php
												}
												?>
												<option  <?php echo $ajio_ccsr_nonvoice['l1_reason11'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td><textarea class="form-control" name="data[cmt11]"><?php echo $ajio_ccsr_nonvoice['cmt11'] ?></textarea></td>
									</tr>
									<tr>
										<td colspan=2 style="color:red">All the queries were answered properly and in an informative way to avoid repeat call. Champ provided a clear understanding of action taken and the way forward to the customer.</td>
										<td>
											<select class="form-control ajio fatal ajioAF4" id="ajio_ccsrnonvoiceAF4" name="data[avoid_repeat_call]" required>
												<option ajio_val=10 ajio_max=10 <?php echo $ajio_ccsr_nonvoice['avoid_repeat_call'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ajio_val=0 ajio_max=10 <?php echo $ajio_ccsr_nonvoice['avoid_repeat_call'] == "Autofail"?"selected":"";?> value="Autofail">Autofail</option>
											</select>
										</td>
										<td>10</td>
										<td>
											<!-- <textarea class="form-control" name="data[l1_reason13]"><?php //echo $ajio_ccsr_nonvoice['l1_reason13'] ?></textarea> -->
											<select class="form-control" id="avoid_repeat_ccsrnonvoice" name="data[l1_reason12]" required>
												<?php 
												if($ajio_ccsr_nonvoice['l1_reason12']!=''){
													?>
													<option value="<?php //echo $ajio_ccsr_nonvoice['audit_type'] ?>"><?php echo $ajio_ccsr_nonvoice['l1_reason12'] ?></option>
													<?php
												}
												?>
												<option  <?php echo $ajio_ccsr_nonvoice['l1_reason12'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td><textarea class="form-control" name="data[cmt12]"><?php echo $ajio_ccsr_nonvoice['cmt12'] ?></textarea></td>
									</tr>
									<tr>
										<td colspan=2 style="color:red">Did the champ document the case correctly and adhered to tagging guidelines.</td>
										<td>
											<select class="form-control ajio fatal ajioAF5" id="ajio_ccsrnonvoiceAF5" name="data[tagging_guidelines]" required>
												<option ajio_val=5 ajio_max=5 <?php echo $ajio_ccsr_nonvoice['tagging_guidelines'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option ajio_val=0 ajio_max=5 <?php echo $ajio_ccsr_nonvoice['tagging_guidelines'] == "No"?"selected":"";?> value="No">No</option>
												<option ajio_val=0 ajio_max=5 <?php echo $ajio_ccsr_nonvoice['tagging_guidelines'] == "Autofail"?"selected":"";?> value="Autofail">Autofail</option>
											</select>
										</td>
										<td>5</td>
										<td>
											<!-- <textarea class="form-control" name="data[l1_reason14]"><?php //echo $ajio_ccsr_nonvoice['l1_reason14'] ?></textarea> -->
										<select class="form-control" id="tagging_guide_ccsrnonvoice" name="data[l1_reason13]" required>
											<?php 
												if($ajio_ccsr_nonvoice['l1_reason13']!=''){
													?>
													<option value="<?php //echo $ajio_ccsr_nonvoice['audit_type'] ?>"><?php echo $ajio_ccsr_nonvoice['l1_reason14'] ?></option>
													<?php
												}
												?>
												<option  <?php echo $ajio_ccsr_nonvoice['l1_reason13'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td><textarea class="form-control" name="data[cmt13]"><?php echo $ajio_ccsr_nonvoice['cmt13'] ?></textarea></td>
									</tr>

									<tr>
										<td style="background-color:#F1948A; font-weight:bold">ZTP</td>
										<td colspan=2 style="color:red">As per AJIO ZTP guidelines</td>
										<td>
											<select class="form-control ajio fatal ajioAF6" id="ajio_ccsrnonvoiceAF6" name="data[ztp_guidelines]" required>
												<option ajio_val=0 ajio_max=0 <?php echo $ajio_ccsr_nonvoice['ztp_guidelines'] == "No"?"selected":"";?> value="No">No</option>
												<option ajio_val=0 ajio_max=0 <?php echo $ajio_ccsr_nonvoice['ztp_guidelines'] == "Autofail"?"selected":"";?> value="Autofail">Autofail</option>
											</select>
										</td>
										<td>0</td>
									<!-- <td>
											<select class="form-control" id="ztp_guide_ccsrvoice" name="data[l1_reason14]" required>
											<?php 
												if($ajio_ccsr_nonvoice['l1_reason14']!=''){
													?>
													<option value="<?php //echo $ajio_ccsr_nonvoice['l1_reason14'] ?>"><?php //echo $ajio_ccsr_nonvoice['l1_reason14'] ?></option>
													<?php
												}
												?>
												<option  <?php //echo $ajio_ccsr_nonvoice['l1_reason14'] == "......."?"selected":"";?> value=".......">.....</option>
												
											</select>	
										</td> -->
										<td><input type="text" class="form-control" name="data[l1_reason14]" value="<?php echo $ajio_ccsr_nonvoice['l1_reason14']?>"></td>

										<td><textarea class="form-control" name="data[cmt14]"><?php echo $ajio_ccsr_nonvoice['cmt14'] ?></textarea></td>
									</tr>
									<tr>
										<td>Call Synopsis:</td>
										<td colspan="7"><textarea class="form-control" name="data[call_synopsis]"><?php echo $ajio_ccsr_nonvoice['call_synopsis'] ?></textarea></td>
									</tr>
									<tr>
										<td>Call Observation:</td>
										<td colspan=2><textarea class="form-control" name="data[call_summary]"><?php echo $ajio_ccsr_nonvoice['call_summary'] ?></textarea></td>
										<td>Feedback:</td>
										<td colspan="4"><textarea class="form-control" name="data[feedback]"><?php echo $ajio_ccsr_nonvoice['feedback'] ?></textarea></td>
									</tr>
									<tr>
										<td colspan=2>Upload Files [m4a,mp4,mp3,wav]</td>
										<?php if($ajio_id==0){ ?>
											<td colspan="5"><input type="file" multiple class="form-control" id="attach_file" name="attach_file[]" accept=".m4a,.mp4,.mp3,.wav,audio/*" style="padding: 10px 10px 10px 10px;"></td>
										<?php }else{
											if($ajio_ccsr_nonvoice['attach_file']!=''){ ?>
												<input type="file" multiple class="form-control"  id="attach_file" name="attach_file[]" accept=".m4a,.mp4,.mp3,.wav,audio/*"> 
												<td colspan=4>
													<?php $attach_file = explode(",",$ajio_ccsr_nonvoice['attach_file']);
													 foreach($attach_file as $mp){ ?>
														<audio controls='' style="background-color:#607F93"> 
														  <source src="<?php echo base_url(); ?>qa_files/qa_ajio/ccsr/<?php echo $mp; ?>" type="audio/ogg">
														  <source src="<?php echo base_url(); ?>qa_files/qa_ajio/ccsr/<?php echo $mp; ?>" type="audio/mpeg">
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
										<tr><td colspan=2 style="font-size:16px; font-weight:bold">Agent Feedback Acceptance:</td><td colspan=5><?php echo $ajio_ccsr_nonvoice['agnt_fd_acpt'] ?></td></tr>
										<tr><td colspan=2 style="font-size:16px; font-weight:bold">Agent Review:</td><td colspan=5><?php echo $ajio_ccsr_nonvoice['agent_rvw_note'] ?></td></tr>
										<tr><td colspan=2 style="font-size:16px; font-weight:bold">Management Review:</td><td colspan=5><?php echo $ajio_ccsr_nonvoice['mgnt_rvw_note'] ?></td></tr>
										<tr><td colspan=2 style="font-size:16px; font-weight:bold">Client Review:</td><td colspan=5><?php echo $ajio_ccsr_nonvoice['client_rvw_note'] ?></td></tr>
										
										<tr><td colspan=2  style="font-size:16px">Your Review</td><td colspan=5><textarea class="form-control1" style="width:100%" id="note" name="note" required></textarea></td></tr>
									<?php } ?>
									
									<?php 
									if($ajio_id==0){
										if(is_access_qa_module()==true || is_access_qa_operations_module()==true){ ?>
											<tr><td colspan=7><button class="btn btn-success waves-effect" type="submit" id="qaformsubmit" style="width:500px">SAVE</button></td></tr>
									<?php 
										} 
									}else{ 
										if(is_access_qa_module()==true || is_access_qa_operations_module()==true){
											if(is_available_qa_feedback($ajio_ccsr_nonvoice['entry_date'],72) == true){ ?>
												<tr><td colspan="7"><button class="btn btn-success waves-effect" type="submit" id='qaformsubmit' name='btnSave' value="SAVE" style="width:500px">SAVE</button></td></tr>
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
