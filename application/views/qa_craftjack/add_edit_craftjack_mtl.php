<style>
	.table>tbody>tr>td {
		text-align: center;
		font-size: 13px;
	}

	#theader {
		font-size: 20px;
		font-weight: bold;
		background-color: #95A5A6;
	}

	.eml {
		background-color: #85C1E9;
	}
	.fatal .eml{
		background-color: red;
		color:white;
	}
	.ui-datepicker .ui-datepicker-buttonpane button.ui-datepicker-current {
	 float: left;
	 display: none;
	}
</style>

<?php if ($craftjack_id != 0) {
	if (is_access_qa_edit_feedback() == false) { ?>
		<style>
			.form-control {
				pointer-events: none;
				background-color: #D5DBDB;
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
											<td colspan="8" id="theader" style="font-size:40px; text-align:center!important; ">Craftjack MTL QA FORM</td>
											<input type="hidden" name="audit_start_time" value="<?php echo CurrMySqlDate(); ?>">
										</tr>
										<?php
										if ($craftjack_id == 0) {
											$auditorName = get_username();
											$auditDate = CurrDateMDY();
											//$auditDate =  CurrDateTimeMDY();
											$clDate_val = '';
										} else {
											if ($craftjack_mtl['entry_by'] != '') {
												$auditorName = $craftjack_mtl['auditor_name'];
											} else {
												$auditorName = $craftjack_mtl['client_name'];
											}
											//$new = explode("-", $craftjack_mtl['audit_date']);
											//$new1 = explode(" ", $new[2]);
											//print_r($new);
											$auditDate = mysql2mmddyy($craftjack_mtl['audit_date']);
										 //    $at = array($new[1], $new1[0], $new[0]);
										 //    $n_date = implode("/", $at);
											// $auditDate = ($n_date)." ".$new1[1];
											$clDate_val = mysql2mmddyy($craftjack_mtl['call_date']);
										}
										?>
										<tr>
											<td>Auditor Name: <span style="font-size:24px;color:red">*</span></td>
											<td colspan="2"><input type="text" class="form-control" value="<?= $auditorName; ?>" disabled></td>
											<td>Audit Date:<span style="font-size:24px;color:red">*</span></td>
											<td colspan="2"><input type="text" class="form-control" value="<?= $auditDate; ?>" disabled></td>
											<td>Call Date:<span style="font-size:24px;color:red">*</span></td>
											<td colspan="2">
												<input type="text" id="call_date" name="call_date"  onkeydown="return false;" value="<?php echo $clDate_val; ?>" max="<?php echo date("Y-m-d"); ?>" class="form-control" required>
											</td>
										</tr>
										<tr>
											<td>Agent Name:<span style="font-size:24px;color:red">*</span></td>
											<td colspan="2">
												<select class="form-control" id="agent_ids" name="data[agent_id]" required>
													<?php 
													if($craftjack_mtl['agent_id']!=''){
														?>
														<option value="<?php echo $craftjack_mtl['agent_id'] ?>"><?php echo $craftjack_mtl['fname'] . " " . $craftjack_mtl['lname'] ?></option>
														<?php
													}else{
														?>
														<option value="">Select</option>
														<?php
													}
													?>
													
													
													<?php foreach ($agentName as $row) :  ?>
													<?php 
													if($row['id'] == $craftjack_mtl['agent_id']){
														continue;
													}else{
														?>
														<option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
														<?php
													}
													?>
														
													<?php endforeach; ?>
												</select>
											</td>
											<td>Fusion ID:<span style="font-size:24px;color:red">*</span></td>
											<td colspan="2"><input type="text" class="form-control" id="fusion_id" required value="<?php echo $craftjack_mtl['fusion_id'] ?>" readonly></td>
											<td> L1 Supervisor:<span style="font-size:24px;color:red">*</span></td>
											<td colspan="2">
													<!-- <select class="form-control" id="tl_id" name="data[tl_id]" readonly>
													<?php 
													if($craftjack_mtl['tl_id']!=''){
														?>
														<option value="<?php echo $craftjack_mtl['tl_id'] ?>"><?php echo $craftjack_mtl['tl_name'] ?></option>
														<?php 

													}else{
														?>
														<option value="">--Select--</option>
														<?php foreach ($tlname as $tl) : ?>
														<option value="<?php echo $tl['id']; ?>"><?php echo $tl['fname'] . " " . $tl['lname']; ?></option>
													<?php endforeach; ?>
														<?php
													}
													?>
												</select>  -->

												<input type="text" class="form-control" id="tl_names"  value="<?php echo $craftjack_mtl['tl_name'] ?>" readonly>
												<input type="hidden" class="form-control" id="tl_id" name="data[tl_id]" value="<?php echo $craftjack_mtl['tl_id'] ?>" required>
											</td>
										</tr>
										<tr>
											<td>AHT RCA:<span style="font-size:24px;color:red">*</span></td>
											<td colspan="2">
												<select class="form-control" id="" name="data[AHT_RCA]" required>
											
											    <option value="">-Select-</option>
											    <option value="Agent" <?= ($craftjack_mtl['AHT_RCA']=="Agent")?"selected":"" ?>>Agent</option>
												<option value="Customer" <?= ($craftjack_mtl['AHT_RCA']=="Customer")?"selected":"" ?>>Customer</option>
												<option value="Process" <?= ($craftjack_mtl['AHT_RCA']=="Process")?"selected":"" ?>>Process</option>
												<option value="Technology" <?= ($craftjack_mtl['AHT_RCA']=="Technology")?"selected":"" ?>>Technology</option>
												<option value="NA" <?= ($craftjack_mtl['AHT_RCA']=="NA")?"selected":"" ?>>NA</option>
											
										</select>
											</td>
											<td>Phone Number:<span style="font-size:24px;color:red">*</span></td>
											<td colspan="2"><input type="text" class="form-control" name="data[phone_no]" value="<?php echo $craftjack_mtl['phone_no'] ?>" onkeyup="checkDec(this);" required>
												<span id="start_phone" style="color:red"></span></td>

											<td>Customer Name:<span style="font-size:24px;color:red">*</span></td>
											<td colspan="2">
												<input type="text" class="form-control" name="data[customer_name]" value="<?php echo $craftjack_mtl['customer_name'] ?>" required>
											</td>
										</tr>
										<tr>
											<td>Type of Call: <span style="font-size:24px;color:red">*</span></td>
											<td colspan="2">
												<input type="text" class="form-control" name="data[call_type]" value="<?php echo $craftjack_mtl['call_type'] ?>" required>
											</td>
											<td>L1:<span style="font-size:24px;color:red">*</span></td>
											<td colspan="2">
												<input type="text" class="form-control" name="data[L1]" value="<?php echo $craftjack_mtl['L1'] ?>" required>
											</td>
											<td>L2:<span style="font-size:24px;color:red">*</span></td>
											<td colspan="2">
												<input type="text" class="form-control" name="data[L2]" value="<?php echo $craftjack_mtl['L2'] ?>" required>
											</td>
											
										</tr>
										<tr>
											<td>Call Duration:<span style="font-size:24px;color:red">*</span></td>
											<td colspan="2"><input type="text" class="form-control" onkeydown="return false;" id="call_duration" name="data[call_duration]" value="<?php echo $craftjack_mtl['call_duration']?>" required></td>

											<td>Week No:<span style="font-size:24px;color:red">*</span></td>
											<td colspan="2"><input type="text" class="form-control" id="week_no" name="data[week_no]" value="<?php echo $craftjack_mtl['week_no']?>" required></td>
											<td>Reason of Cancellation:<span style="font-size:24px;color:red">*</span></td>
											<td colspan="2"><input type="text" class="form-control" id="reason_of_cancellation" name="data[reason_of_cancellation]" value="<?php echo $craftjack_mtl['reason_of_cancellation']?>" required></td>
										</tr>
										<tr>
											
											<td>VOC:<span style="font-size:24px;color:red">*</span></td>
											<td colspan="2">
												<select class="form-control" id="voc" name="data[voc]" required>
													
													<option value="">-Select-</option>
													<option value="1"  <?= ($craftjack_mtl['voc']=="1")?"selected":"" ?>>1</option>
													<option value="2"  <?= ($craftjack_mtl['voc']=="2")?"selected":"" ?>>2</option>
													<option value="3"  <?= ($craftjack_mtl['voc']=="3")?"selected":"" ?>>3</option>
													<option value="4"  <?= ($craftjack_mtl['voc']=="4")?"selected":"" ?>>4</option>
													<option value="5"  <?= ($craftjack_mtl['voc']=="5")?"selected":"" ?>>5</option>
													<option value="6"  <?= ($craftjack_mtl['voc']=="6")?"selected":"" ?>>6</option>
													<option value="7"  <?= ($craftjack_mtl['voc']=="7")?"selected":"" ?>>7</option>
													<option value="8"  <?= ($craftjack_mtl['voc']=="8")?"selected":"" ?>>8</option>
													<option value="9"  <?= ($craftjack_mtl['voc']=="9")?"selected":"" ?>>9</option>
													<option value="10"  <?= ($craftjack_mtl['voc']=="10")?"selected":"" ?>>10</option>
												</select>
											</td>
											<td>Audit Type:<span style="font-size:24px;color:red">*</span></td>
											<td colspan="2">
												<select class="form-control" id="audit_type" name="data[audit_type]" required>
                                                    <option value="">-Select-</option>
                                                    <option value="CQ Audit" <?= ($craftjack_mtl['audit_type']=="CQ Audit")?"selected":"" ?>>CQ Audit</option>
                                                    <option value="BQ Audit" <?= ($craftjack_mtl['audit_type']=="BQ Audit")?"selected":"" ?>>BQ Audit</option>
                                                    <option value="Calibration" <?= ($craftjack_mtl['audit_type']=="Calibration")?"selected":"" ?>>Calibration</option>
                                                    <option value="Pre-Certificate Mock Call" <?= ($craftjack_mtl['audit_type']=="Pre-Certificate Mock Call")?"selected":"" ?>>Pre-Certificate Mock Call</option>
                                                    <option value="Certification Audit" <?= ($craftjack_mtl['audit_type']=="Certification Audit")?"selected":"" ?>>Certification Audit</option>
                                                    <option value="WOW Call"  <?= ($craftjack_mtl['audit_type']=="WOW Call")?"selected":"" ?>>WOW Call</option>
                                                   
                                                    
                                                </select>
											</td>
											<td class="auType_epi">Auditor Type<span style="font-size:24px;color:red">*</span></td>
											<td class="auType_epi">
												<select class="form-control" id="auditor_type" name="data[auditor_type]">
                                                    <option value="">Select</option>
                                                    <option value="Master" <?= ($craftjack_mtl['auditor_type']=="Master")?"selected":"" ?>>Master</option>
                                                    <option value="Regular" <?= ($craftjack_mtl['auditor_type']=="Regular")?"selected":"" ?>>Regular</option>
                                                </select>
											</td>
										</tr>
										<tr>
											<td style="font-weight:bold; font-size:16px; text-align:left">Earned Score</td>
											<td colspan="2"><input type="text" readonly id="mtl_earned_score" name="data[earned_score]" class="form-control" value="<?php echo $craftjack_mtl['earned_score'] ?>" /></td>
											<td style="font-weight:bold; font-size:16px; text-align:left">Possible Score</td>
											<td colspan="2"><input type="text" readonly id="mtl_possible_score" name="data[possible_score]" class="form-control" value="<?php echo $craftjack_mtl['possible_score'] ?>" /></td>
											<td style="font-weight:bold; font-size:16px; text-align:right">Overall Score:</td>
											<td colspan="2"><input type="text" readonly id="mtl_overall_score" name="data[overall_score]" class="form-control acgFatal" style="font-weight:bold" value="<?php echo $craftjack_mtl['overall_score'] ?>"></td>
										</tr>
										<tr class="eml" style="height:25px; font-weight:bold">
											<td>PARAMETER</td>
											<td colspan=2>SUB PARAMETER</td>
											<td>WEIGHTAGE</td>
											<td>STATUS</td>
											<td colspan=2>REMARKS</td>
											<td>Critical Accuracy</td>
										</tr>

										<tr>
											<td class="eml" rowspan=4>Opening</td>
											<td colspan=2>1.1 Did the agent greet the customer promptly?</td>
											<td>5</td>
											<td>
												<select class="form-control mtl_point business" name="data[greet_customer]" required>
													
													<option mtl_val=5 mtl_max="5"<?php echo $craftjack_mtl['greet_customer'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option mtl_val=0 mtl_max="5" <?php echo $craftjack_mtl['greet_customer'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													<option mtl_val=0 mtl_max="5" <?php echo $craftjack_mtl['greet_customer'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt1]" class="form-control" value="<?php echo $craftjack_mtl['cmt1'] ?>"></td>
											<td style="font-weight:bold; background-color:#D7BDE2">Business Citical</td>
										</tr>
										<tr>
											<td colspan=2>1.2 Did the agent provide his/her name? </td>
											<td>5</td>
											<td>
												<select class="form-control mtl_point business" name="data[provide_name]" required>
													
													<option mtl_val=5 mtl_max="5" <?php echo $craftjack_mtl['provide_name'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option mtl_val=0 mtl_max="5" <?php echo $craftjack_mtl['provide_name'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													<option mtl_val=0 mtl_max="5" <?php echo $craftjack_mtl['provide_name'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt2]" class="form-control" value="<?php echo $craftjack_mtl['cmt2'] ?>"></td>
											<td style="font-weight:bold; background-color:#D7BDE2">Business Citical</td>
										</tr>

										<tr>
											<td colspan="2" class="text-danger">1.3 Did the agent informed the customer about the recorded line?</td>
											<td>1</td>
											<td>
												<select class="form-control mtl_point compliance" id ="ajioAF1" name="data[inform_recorded_line]" required>
													
													<option mtl_val=1 mtl_max="1" <?= $craftjack_mtl["inform_recorded_line"] == "Pass" ? "selected" : "" ?> value="Pass">Pass</option>
													<option mtl_val=0 mtl_max="1" <?= $craftjack_mtl["inform_recorded_line"] == "Fail" ? "selected" : "" ?> value="Fail">Fail</option>
													<option mtl_val=0 mtl_max="1" <?= $craftjack_mtl["inform_recorded_line"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt3]" class="form-control" value="<?php echo $craftjack_mtl['cmt3'] ?>"></td>
											<td style="font-weight:bold; background-color:#D7BDE2">Compliance Citical</td>
										</tr>
										<tr>
											<td colspan="2">1.4 Did the agent ask how/he or she could assist the caller?</td>
											<td>6</td>
											<td>
												<select class="form-control mtl_point customer"  name="data[assist_caller]" required>
													
													<option mtl_val=6 mtl_max="6" <?= $craftjack_mtl["assist_caller"] == "Pass" ? "selected" : "" ?> value="Pass">Pass</option>
													<option mtl_val=0 mtl_max="6" <?= $craftjack_mtl["assist_caller"] == "Fail" ? "selected" : "" ?> value="Fail">Fail</option>
													<option mtl_val=0 mtl_max="6" <?= $craftjack_mtl["assist_caller"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt4]" class="form-control" value="<?php echo $craftjack_mtl['cmt4'] ?>"></td>
											<td style="font-weight:bold; background-color:#D7BDE2">Customer Citical</td>
										</tr>

										<tr>
											<td class="eml" rowspan=8>Process and Procedure</td>
											<td colspan=2>2.1 Did the agent checked the Customer’s Account?</td>
											<td>10</td>
											<td>
												<select class="form-control mtl_point compliance" name="data[checked_customer_account]" required>
													
													<option mtl_val=10 mtl_max="10" <?php echo $craftjack_mtl['checked_customer_account'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option mtl_val=0 mtl_max="10" <?php echo $craftjack_mtl['checked_customer_account'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													<option mtl_val=0 mtl_max="10" <?php echo $craftjack_mtl['checked_customer_account'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt5]" class="form-control" value="<?php echo $craftjack_mtl['cmt5'] ?>"></td>
											<td style="font-weight:bold; background-color:#D7BDE2">Compliance Citical</td>
										</tr>

										<tr>
											<td colspan=2>2.2 Did the agent tried to solve the customer’s Issue?</td>
											<td>10</td>
											<td>
												<select class="form-control mtl_point customer" name="data[solve_customer_issue]" required>
													
													<option mtl_val=10 mtl_max="10" <?php echo $craftjack_mtl['solve_customer_issue'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option mtl_val=0 mtl_max="10" <?php echo $craftjack_mtl['solve_customer_issue'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													<option mtl_val=0 mtl_max="10" <?php echo $craftjack_mtl['solve_customer_issue'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt6]" class="form-control" value="<?php echo $craftjack_mtl['cmt6'] ?>"></td>
											<td style="font-weight:bold; background-color:#D7BDE2">Customer Citical</td>
										</tr>

										<tr>
											<td  colspan="2" class="text-danger">2.3 Did the agent ask the customer the cancellation reason?</td>
											<td>1</td>
											<td>
												<select class="form-control mtl_point business" id ="ajioAF2"name="data[cancellation_reason]" required>
													
													<option mtl_val=1 mtl_max="1" <?= $craftjack_mtl["cancellation_reason"] == "Pass" ? "selected" : "" ?> value="Pass">Pass</option>
													<option mtl_val=0 mtl_max="1" <?= $craftjack_mtl["cancellation_reason"] == "Fail" ? "selected" : "" ?> value="Fail">Fail</option>
													<option mtl_val=0 <?= $craftjack_mtl["cancellation_reason"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt7]" class="form-control" value="<?php echo $craftjack_mtl['cmt7'] ?>"></td>
											<td style="font-weight:bold; background-color:#D7BDE2">Business Citical</td>
										</tr>
										
										<tr>
											<td  colspan="2" class="text-danger">2.4 Did the agent make an offer or an attempt to try to save the account?</td>
											<td>1</td>
											<td>
												<select class="form-control mtl_point business" id ="ajioAF3"name="data[save_account]" required>
													
													<option mtl_val=1 mtl_max="1" <?= $craftjack_mtl["save_account"] == "Pass" ? "selected" : "" ?> value="Pass">Pass</option>
													<option mtl_val=0 mtl_max="1" <?= $craftjack_mtl["save_account"] == "Fail" ? "selected" : "" ?> value="Fail">Fail</option>
													<option mtl_val=0 <?= $craftjack_mtl["save_account"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt8]" class="form-control" value="<?php echo $craftjack_mtl['cmt8'] ?>"></td>
											<td style="font-weight:bold; background-color:#D7BDE2">Business Citical</td>
										</tr>
										<tr>
											<td  colspan="2">2.5 Did the agent leave detailed notes?</td>
											<td>9</td>
											<td>
												<select class="form-control mtl_point customer" id ="" name="data[leave_detailed_note]" required>
													
													<option mtl_val=9 mtl_max="9" <?= $craftjack_mtl["leave_detailed_note"] == "Pass" ? "selected" : "" ?> value="Pass">Pass</option>
													<option mtl_val=0 mtl_max="9" <?= $craftjack_mtl["leave_detailed_note"] == "Fail" ? "selected" : "" ?> value="Fail">Fail</option>
													<option mtl_val=0 <?= $craftjack_mtl["leave_detailed_note"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt9]" class="form-control" value="<?php echo $craftjack_mtl['cmt9'] ?>"></td>
											<td style="font-weight:bold; background-color:#D7BDE2">Customer Citical</td>
										</tr>
										<tr>
											<td  colspan="2" class="text-danger">2.6 Did the agent inform the SP about the statement that will be sent after the call?</td>
											<td>1</td>
											<td>
												<select class="form-control mtl_point customer" id ="ajioAF4"name="data[inform_SP]" required>
													
													<option mtl_val=1 mtl_max="1" <?= $craftjack_mtl["inform_SP"] == "Pass" ? "selected" : "" ?> value="Pass">Pass</option>
													<option mtl_val=0 mtl_max="1" <?= $craftjack_mtl["inform_SP"] == "Fail" ? "selected" : "" ?> value="Fail">Fail</option>
													<option mtl_val=0 <?= $craftjack_mtl["inform_SP"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt10]" class="form-control" value="<?php echo $craftjack_mtl['cmt10'] ?>"></td>
											<td style="font-weight:bold; background-color:#D7BDE2">Customer Citical</td>
										</tr>
										<tr>
											<td  colspan="2">2.7 Did the agent educate the customer properly?</td>
											<td>10</td>
											<td>
												<select class="form-control mtl_point customer" id ="" name="data[educate_customer]" required>
													
													<option mtl_val=10 mtl_max="10" <?= $craftjack_mtl["educate_customer"] == "Pass" ? "selected" : "" ?> value="Pass">Pass</option>
													<option mtl_val=0 mtl_max="10" <?= $craftjack_mtl["educate_customer"] == "Fail" ? "selected" : "" ?> value="Fail">Fail</option>
													<option mtl_val=0 <?= $craftjack_mtl["educate_customer"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt11]" class="form-control" value="<?php echo $craftjack_mtl['cmt11'] ?>"></td>
											<td style="font-weight:bold; background-color:#D7BDE2">Customer Citical</td>
										</tr>
										<tr>
											<td  colspan="2" class="text-danger">2.8 Did the agent pause the recording when caller is providing their credit card information?</td>
											<td>1</td>
											<td>
												<select class="form-control mtl_point compliance" id="ajioAF6" name="data[agent_pause_recording]" required>
													
													<option mtl_val=1 mtl_max="1" <?= $craftjack_mtl["agent_pause_recording"] == "Pass" ? "selected" : "" ?> value="Pass">Pass</option>
													<option mtl_val=0 mtl_max="1" <?= $craftjack_mtl["agent_pause_recording"] == "Fail" ? "selected" : "" ?> value="Fail">Fail</option>
													<option mtl_val=0 <?= $craftjack_mtl["agent_pause_recording"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt19]" class="form-control" value="<?php echo $craftjack_mtl['cmt19'] ?>"></td>
											<td style="font-weight:bold; background-color:#D7BDE2">Compliance Citical</td>
										</tr>
										<tr>
											<td class="eml" rowspan=5>Soft Skills</td>
											<td colspan="2">3.1 Did the agent have an appropriate tone and Pacing? Did the agent rush the call?</td>
											<td>8</td>
											<td>
												<select class="form-control mtl_point customer" name="data[appropriate_tone]" required>
												
													<option mtl_val=8 mtl_max="8"<?= $craftjack_mtl["appropriate_tone"] == "Pass" ? "selected" : "" ?> value="Pass">Pass</option>
													<option mtl_val=0 mtl_max="8"<?= $craftjack_mtl["appropriate_tone"] == "Fail" ? "selected" : "" ?> value="Fail">Fail</option>
													<option mtl_val=0 mtl_max="8"<?= $craftjack_mtl["appropriate_tone"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt12]" class="form-control" value="<?php echo $craftjack_mtl['cmt12'] ?>"></td>
											<td style="font-weight:bold; background-color:#D7BDE2">Customer Citical</td>
										</tr>
										<tr>
											<td colspan="2">3.2 Did the agent use empathy & assurance to help statements over the call (if applicable)?</td>
											<td>7</td>
											<td>
												<select class="form-control mtl_point customer" name="data[use_empathy]" required>
												
													<option mtl_val=7 mtl_max="7" <?= $craftjack_mtl["use_empathy"] == "Pass" ? "selected" : "" ?> value="Pass">Pass</option>
													<option mtl_val=0 mtl_max="7" <?= $craftjack_mtl["use_empathy"] == "Fail" ? "selected" : "" ?> value="Fail">Fail</option>
													<option mtl_val=0 mtl_max="7" <?= $craftjack_mtl["use_empathy"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt13]" class="form-control" value="<?php echo $craftjack_mtl['cmt13'] ?>"></td>
											<td style="font-weight:bold; background-color:#D7BDE2">Customer Citical</td>
										</tr>
										<tr>
											<td colspan="2" class="text-danger">3.3 Did the agent intentionally interrupted the customer?</td>
											<td>1</td>
											<td>
												<select class="form-control mtl_point customer" id ="ajioAF5" name="data[intentionally_interrupted]" required>
												
													<option mtl_val=1 mtl_max="1" <?= $craftjack_mtl["intentionally_interrupted"] == "Pass" ? "selected" : "" ?> value="Pass">Pass</option>
													<option mtl_val=0 mtl_max="1" <?= $craftjack_mtl["intentionally_interrupted"] == "Fail" ? "selected" : "" ?> value="Fail">Fail</option>
													<option mtl_val=0 mtl_max="1" <?= $craftjack_mtl["intentionally_interrupted"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt14]" class="form-control" value="<?php echo $craftjack_mtl['cmt14'] ?>"></td>
											<td style="font-weight:bold; background-color:#D7BDE2">Customer Citical</td>
										</tr>

										<tr>
											<td colspan="2">3.4 Professionalism</td>
											<td>8</td>
											<td>
												<select class="form-control mtl_point customer" name="data[professionalism]" required>
												
													<option mtl_val=8 mtl_max="8" <?= $craftjack_mtl["professionalism"] == "Pass" ? "selected" : "" ?> value="Pass">Pass</option>
													<option mtl_val=0 mtl_max="8" <?= $craftjack_mtl["professionalism"] == "Fail" ? "selected" : "" ?> value="Fail">Fail</option>
													<option mtl_val=0 mtl_max="8" <?= $craftjack_mtl["professionalism"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt15]" class="form-control" value="<?php echo $craftjack_mtl['cmt15'] ?>"></td>
											<td style="font-weight:bold; background-color:#D7BDE2">Customer Citical</td>
										</tr>

										<tr>
											<td colspan="2">3.5 Did the agent follow the hold procedure/ dead air?</td>
											<td>6</td>
											<td>
												<select class="form-control mtl_point customer" name="data[dead_air]" required>
												
													<option mtl_val=6 mtl_max="6" <?= $craftjack_mtl["dead_air"] == "Pass" ? "selected" : "" ?> value="Pass">Pass</option>
													<option mtl_val=0 mtl_max="6" <?= $craftjack_mtl["dead_air"] == "Fail" ? "selected" : "" ?> value="Fail">Fail</option>
													<option mtl_val=0 mtl_max="6" <?= $craftjack_mtl["dead_air"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt16]" class="form-control" value="<?php echo $craftjack_mtl['cmt16'] ?>"></td>
											<td style="font-weight:bold; background-color:#D7BDE2">Customer Citical</td>
										</tr>

										<tr>
											<td class="eml" rowspan=2>Closing</td>
											<td colspan="2">4.1 Did the agent offer further assistance once the primary issue of the customer is addressed? </td>
											<td>5</td>
											<td>
												<select class="form-control mtl_point customer" id ="" name="data[further_assistance]" required>
												
													<option mtl_val=5 mtl_max="5" <?= $craftjack_mtl["further_assistance"] == "Pass" ? "selected" : "" ?> value="Pass">Pass</option>
													<option mtl_val=0 mtl_max="5" <?= $craftjack_mtl["further_assistance"] == "Fail" ? "selected" : "" ?> value="Fail">Fail</option>
													<option mtl_val=0 mtl_max="5" <?= $craftjack_mtl["further_assistance"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt17]" class="form-control" value="<?php echo $craftjack_mtl['cmt17'] ?>"></td>
											<td style="font-weight:bold; background-color:#D7BDE2">Customer Citical</td>
										</tr>
										<tr>
											<td colspan="2">4.2 Did the agent close the call correctly? </td>
											<td>5</td>
											<td>
												<select class="form-control mtl_point customer" name="data[close_call]" required>
												
													<option mtl_val=5 mtl_max="5" <?= $craftjack_mtl["close_call"] == "Pass" ? "selected" : "" ?> value="Pass">Pass</option>
													<option mtl_val=0 mtl_max="5"<?= $craftjack_mtl["close_call"] == "Fail" ? "selected" : "" ?> value="Fail">Fail</option>
													<option mtl_val=0 mtl_max="5"<?= $craftjack_mtl["close_call"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt18]" class="form-control" value="<?php echo $craftjack_mtl['cmt18'] ?>"></td>
											<td style="font-weight:bold; background-color:#D7BDE2">Customer Citical</td>
										</tr>

									<tr style="font-weight:bold; background-color:#D7BDE2">
										<td colspan=3>Customer Score</td>
										<td colspan=3>Business Score</td>
										<td colspan=3>Compliance Score</td>
									</tr>

									<tr style="font-weight:bold; background-color:#D7BDE2">
										<td>Earned Point:</td><td colspan=2><input type="text" readonly class="form-control" id="customer_earned_score" name="data[customer_earned_score]" value="<?php echo $craftjack_mtl['customer_earned_score'] ?>"></td>
										<td>Earned Point:</td><td colspan=2><input type="text" readonly class="form-control" id="business_earned_score" name="data[business_earned_score]" value="<?php echo $craftjack_mtl['business_earned_score'] ?>"></td>
										<td>Earned Point:</td><td colspan=2><input type="text" readonly class="form-control" id="compliance_earned_score" name="data[compliance_earned_score]" value="<?php echo $craftjack_mtl['compliance_earned_score'] ?>"></td>
									</tr>
									<tr style="font-weight:bold; background-color:#D7BDE2">
										<td>Possible Point:</td><td colspan=2><input type="text" readonly class="form-control" id="customer_possible_score" name="data[customer_possible_score]" value="<?php echo $craftjack_mtl['customer_possible_score'] ?>"></td>
										<td>Possible Point:</td><td colspan=2><input type="text" readonly class="form-control" id="business_possible_score" name="data[business_possible_score]" value="<?php echo $craftjack_mtl['business_possible_score'] ?>"></td>
										<td>Possible Point:</td><td colspan=2><input type="text" readonly class="form-control" id="compliance_possible_score" name="data[compliance_possible_score]" value="<?php echo $craftjack_mtl['compliance_possible_score'] ?>"></td>
									</tr>
									<tr style="font-weight:bold; background-color:#D7BDE2">
										<td>Overall Percentage:</td><td colspan=2><input type="text" readonly class="form-control" id="customer_overall_score" name="data[customer_overall_score]" value="<?php echo $craftjack_mtl['customer_overall_score'] ?>"></td>
										<td>Overall Percentage:</td><td colspan=2><input type="text" readonly class="form-control" id="business_overall_score" name="data[business_overall_score]" value="<?php echo $craftjack_mtl['business_overall_score'] ?>"></td>
										<td>Overall Percentage:</td><td colspan=2><input type="text" readonly class="form-control" id="compliance_overall_score" name="data[compliance_overall_score]" value="<?php echo $craftjack_mtl['compliance_overall_score'] ?>"></td>
									</tr>

										<tr>
											<td>Call Summary:</td>
											<td colspan=2><textarea class="form-control" name="data[call_summary]"><?php echo $craftjack_mtl['call_summary'] ?></textarea></td>
											<td>Feedback:</td>
											<td colspan=4><textarea class="form-control" name="data[feedback]"><?php echo $craftjack_mtl['feedback'] ?></textarea></td>
										</tr>
										<tr>
											<td colspan=2>Upload Files [m4a,mp4,mp3,wav]</td>
											<?php if ($craftjack_id == 0) { ?>
												<td colspan=6>
													<!-- <input type="file" multiple class="form-control"  id="attach_file" name="attach_file[]"> -->
													<input type="file" name="attach_file[]" id="attach_file" accept=".m4a,.mp4,.mp3,.wav,audio/*" />
												</td>
												<?php } else {
												if ($craftjack_mtl['attach_file'] != '') { ?>
													<td colspan=6>
														<input type="file" multiple class="form-control"  id="attach_file" name="attach_file[]" accept=".m4a,.mp4,.mp3,.wav,audio/*"> 
														<?php $attach_file = explode(",", $craftjack_mtl['attach_file']);
														foreach ($attach_file as $mp) { ?>
															<audio controls='' style="background-color:#607F93">
																<source src="<?php echo base_url(); ?>qa_files/craftjack/qa_audio_files/<?php echo $mp; ?>" type="audio/ogg">
																<source src="<?php echo base_url(); ?>qa_files/craftjack/qa_audio_files/<?php echo $mp; ?>" type="audio/mpeg">
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

										<?php if ($craftjack_id != 0) { ?>
											<tr>
												<td colspan=2 style="font-size:16px; font-weight:bold">Agent Feedback Acceptance:</td>
												<td colspan=6><?php echo $craftjack_mtl['agnt_fd_acpt'] ?></td>
											</tr>
											<tr>
												<td colspan=2 style="font-size:16px; font-weight:bold">Agent Review:</td>
												<td colspan=6><?php echo $craftjack_mtl['agent_rvw_note'] ?></td>
											</tr>
											<tr>
												<td colspan=2 style="font-size:16px; font-weight:bold">Management Review:</td>
												<td colspan=6><?php echo $craftjack_mtl['mgnt_rvw_note'] ?></td>
											</tr>
											<tr>
												<td colspan=2 style="font-size:16px; font-weight:bold">Client Review:</td>
												<td colspan=6><?php echo $craftjack_mtl['client_rvw_note'] ?></td>
											</tr>

											<tr>
												<td colspan=2 style="font-size:16px">Your Review<span style="font-size:24px;color:red">*</span></td>
												<td colspan=6><textarea class="form-control1" style="width:100%" id="note" name="note" required></textarea></td>
											</tr>
										<?php } ?>

										<?php
										if ($craftjack_id == 0) {
											if (is_access_qa_module() == true || is_access_qa_operations_module() == true) { ?>
												<tr>
													<td colspan=8><button class="btn btn-success blains-effect" type="submit" id="qaformsubmit" style="width:500px;margin:auto;display:block;">SAVE</button></td>
												</tr>
												<?php
											}
										} else {
											if (is_access_qa_module() == true || is_access_qa_operations_module() == true) {
												if (is_available_qa_feedback($craftjack_mtl['entry_date'], 72) == true) { ?>
													<tr>
														<td colspan="8"><button class="btn btn-success blains-effect" type="submit" id='qaformsubmit' name='btnSave' value="SAVE" style="width:500px;margin:auto;display:block;">SAVE</button></td>
													</tr>
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