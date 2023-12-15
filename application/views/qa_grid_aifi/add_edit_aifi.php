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

<?php if($aifi_id!=0){
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
										<td colspan="6" id="theader" style="font-size:40px">AIFI-Quality Form</td>
										<input type="hidden" name="audit_start_time" value="<?php echo CurrMySqlDate(); ?>">
									</tr>
									<?php
										if($aifi_id==0){
											$auditorName = get_username();
											$auditDate = CurrDateMDY();
											$clDate_val='';
										}else{
											if($aifi_data['entry_by']!=''){
												$auditorName = $aifi_data['auditor_name'];
											}else{
												$auditorName = $aifi_data['client_name'];
											}
											$auditDate = mysql2mmddyy($aifi_data['audit_date']);
											$clDate_val = mysqlDt2mmddyy($aifi_data['call_date']);
										}
										if ($rand_id != 0) {
											$agent_id = $rand_data['sid'];
											$fusion_id = $rand_data['fusion_id'];
											$agent_name = $rand_data['fname'] . " " . $rand_data['lname'];
											$tl_id = $rand_data['assigned_to'];
											$tl_name = $rand_data['tl_name'];
											$call_duration = $rand_data['call_duration'];
											
										} else {
											$agent_id = $aifi_data['agent_id'];
											$fusion_id = $aifi_data['fusion_id'];
											$agent_name = $aifi_data['fname'] . " " . $aifi_data['lname'] ;
											$tl_id = $aifi_data['tl_id'];
											$tl_name = $aifi_data['tl_name'];
											$call_duration = $aifi_data['call_duration'];
										}
									?>
									<tr>
										<td>Auditor Name:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control" value="<?php echo $auditorName; ?>" disabled></td>
										<td>Audit Date:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control" value="<?php echo $auditDate; ?>" disabled></td>
										<td>Interaction ID:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control" name="data[interaction_id]"  onkeypress="return /[0-9a-zA-Z]/i.test(event.key)" title="Only alphanumeric allowed" value="<?php echo $aifi_data['interaction_id'] ?>" required ></td>
										
									</tr>
									<tr>
										<td>Agent Name:<span style="font-size:24px;color:red">*</span></td>
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
										<td>Employee ID:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control" id="fusion_id" value="<?php echo $aifi_data['fusion_id'] ?>" readonly ></td>
										<td>L1 Supervisor:<span style="font-size:24px;color:red">*</span></td>
										<td>
											<input type="text" class="form-control" id="tl_name"  value="<?php echo $tl_name; ?>" readonly>
												<input type="hidden" class="form-control" id="tl_id" name="data[tl_id]" value="<?php echo $tl_id; ?>" required>
										</td>
									</tr>
									<tr>
										<td>Case Number:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control" name="data[case_number]"  onkeypress="return /[0-9a-zA-Z]/i.test(event.key)" title="Only alphanumeric allowed" value="<?php echo $aifi_data['case_number'] ?>" required ></td>
										<td>Date/Time:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control" id="call_date_time" name="call_date" value="<?php echo $clDate_val; ?>" required></td>
										<td>Transaction Duration:</td>
										<td>
											<input type="text" class="form-control"  id="" name="data[call_duration]" value="<?php echo $call_duration; ?>">
										</td>
									</tr>
									
								
									<tr>
										
										<td>KPI - ACPT:<span style="font-size:24px;color:red">*</span></td>
										<td>
											<select class="form-control" name="data[KPI_ACPT]" required>
												<option value="">-Select-</option>
												<option <?php echo $aifi_data['KPI_ACPT'] == "Agent"?"selected":"";?> value="Agent">Agent</option>
												<option <?php echo $aifi_data['KPI_ACPT'] == "Process"?"selected":"";?> value="Process">Process</option>
												<option <?php echo $aifi_data['KPI_ACPT'] == "Customer"?"selected":"";?> value="Customer">Customer</option>
												<option <?php echo $aifi_data['KPI_ACPT'] == "Technology"?"selected":"";?> value="Technology">Technology</option>
												<option <?php echo $aifi_data['KPI_ACPT'] == "NA"?"selected":"";?> value="NA">NA</option>
											</select> 
										</td>
										<td>VOC:</td>
											<td>
												<select class="form-control" id="voc" name="data[voc]">
													
													<option value="">-Select-</option>
													<option value="1"  <?= ($aifi_data['voc']=="1")?"selected":"" ?>>1</option>
													<option value="2"  <?= ($aifi_data['voc']=="2")?"selected":"" ?>>2</option>
													<option value="3"  <?= ($aifi_data['voc']=="3")?"selected":"" ?>>3</option>
													<option value="4"  <?= ($aifi_data['voc']=="4")?"selected":"" ?>>4</option>
													<option value="5"  <?= ($aifi_data['voc']=="5")?"selected":"" ?>>5</option>
													<option value="6"  <?= ($aifi_data['voc']=="6")?"selected":"" ?>>6</option>
													<option value="7"  <?= ($aifi_data['voc']=="7")?"selected":"" ?>>7</option>
													<option value="8"  <?= ($aifi_data['voc']=="8")?"selected":"" ?>>8</option>
													<option value="9"  <?= ($aifi_data['voc']=="9")?"selected":"" ?>>9</option>
													<option value="10"  <?= ($aifi_data['voc']=="10")?"selected":"" ?>>10</option>
												</select>
											</td>
											<td>Case Topic:<span style="font-size:24px;color:red">*</span></td>
											<td>
											<input type="text" class="form-control"  id="" name="data[case_topic]" value="<?php echo $aifi_data['case_topic']; ?>" required>
										</td>
									</tr>
									
									<tr>
										
										<td>Audit Type:<span style="font-size:24px;color:red">*</span></td>
										<td>
											<select class="form-control" id="audit_type" name="data[audit_type]" required>
                                                    <option value="">-Select-</option>
                                                    <option value="CQ Audit" <?= ($aifi_data['audit_type']=="CQ Audit")?"selected":"" ?>>CQ Audit</option>
                                                    <option value="BQ Audit" <?= ($aifi_data['audit_type']=="BQ Audit")?"selected":"" ?>>BQ Audit</option>
                                                    <option value="Calibration" <?= ($aifi_data['audit_type']=="Calibration")?"selected":"" ?>>Calibration</option>
                                                    <option value="Pre-Certificate Mock Call" <?= ($aifi_data['audit_type']=="Pre-Certificate Mock Call")?"selected":"" ?>>Pre-Certificate Mock Call</option>
                                                    <option value="Certification Audit" <?= ($aifi_data['audit_type']=="Certification Audit")?"selected":"" ?>>Certification Audit</option>
                                                    <option value="WoW Call"  <?= ($aifi_data['audit_type']=="WoW Call")?"selected":"" ?>>WoW Call</option>
                                                    <option value="Hygiene Audit"  <?= ($aifi_data['audit_type']=="Hygiene Audit")?"selected":"" ?>>Hygiene Audit</option>
                                                    <option value="Operation Audit"  <?= ($aifi_data['audit_type']=="Operation Audit")?"selected":"" ?>>Operation Audit</option>
                                                    <option value="Trainer Audit"  <?= ($aifi_data['audit_type']=="Trainer Audit")?"selected":"" ?>>Trainer Audit</option> 
                                                    <option value="QA Supervisor Audit"  <?= ($aifi_data['audit_type']=="QA Supervisor Audit")?"selected":"" ?>>QA Supervisor Audit</option> 
                                                </select>
										</td>
										<td class="auType_epi">Auditor Type<span style="font-size:24px;color:red">*</span></td>
											<td class="auType_epi">
												<select class="form-control" id="auditor_type" name="data[auditor_type]">
                                                    <option value="">Select</option>
                                                    <option value="Master" <?= ($aifi_data['auditor_type']=="Master")?"selected":"" ?>>Master</option>
                                                    <option value="Regular" <?= ($aifi_data['auditor_type']=="Regular")?"selected":"" ?>>Regular</option>
                                                </select>
											</td>
									</tr>
									<tr>
										<td style="font-weight:bold; font-size:16px; text-align:right">Earned Score:</td>
										<td><input type="text" readonly id="aifi_earned_score" name="data[earned_score]" class="form-control" style="font-weight:bold" value="<?php echo $aifi_data['earned_score'] ?>"></td>
										<td style="font-weight:bold; font-size:16px; text-align:right">Possible Score:</td>
										<td><input type="text" readonly id="aifi_possible_score" name="data[possible_score]" class="form-control" style="font-weight:bold" value="<?php echo $aifi_data['possible_score'] ?>"></td>
										<td style="font-weight:bold; font-size:16px; text-align:right">Overall Score:</td>
										<td><input type="text" readonly id="aifi_overall_score" name="data[overall_score]" class="form-control aifiFatal" style="font-weight:bold" value="<?php echo $aifi_data['overall_score'] ?>"></td>
									</tr>
									<!-- <tr style="font-weight:bold">
										<td><input type="hidden" class="form-control" id="prefatal" name="data[pre_fatal_score]" value="<?php //echo $aifi_data['pre_fatal_score'] ?>"></td>
										<td><input type="hidden" class="form-control" id="fatalcount" name="data[fatal_count]" value="<?php //echo $aifi_data['fatal_count'] ?>"></td>
									</tr> -->
									<tr style="background-color:#85C1E9; font-weight:bold">
										<td>Parameter</td>
										<td colspan="2">Sub Parameter</td>
										<td>Weightage</td>
										<td>Score</td>
										<td>Remarks</td>
									</tr>
									<tr>
										<td colspan="6" style="background-color:#85C1E9; font-weight:bold; text-align:center;">Critical Category</td>
										
									</tr>
									<tr>
										<td rowspan=1>Business Critical</td>
										<td style="color:red" colspan="2">Did the operator breach any Business critical requirements</td>
										<td></td>
										<td>
											<select class="form-control aifi_point" id="aifiAF1" name="data[breach_business_critical]" required>
												<option aifi_val=0 aifi_max=0 <?php echo $aifi_data['breach_business_critical'] == "Pass"?"selected":"";?> value="Pass">Pass</option>
												<option aifi_val=0 aifi_max=0 <?php echo $aifi_data['breach_business_critical'] == "Fail"?"selected":"";?> value="Fail">Fail</option>
												<option aifi_val=0 aifi_max=0 <?php echo $aifi_data['breach_business_critical'] == "NA"?"selected":"";?> value="NA">NA</option>
											</select>
										</td>
										<td><textarea class="form-control" name="data[cmt1]"><?php echo $aifi_data['cmt1'] ?></textarea></td>
									</tr>
									<tr>
										<td rowspan=1>Compliance Critical</td>
										<td style="color:red" colspan="2">Did the operator breach any Compliance critical requirements</td>
										<td></td>
										<td>
											<select class="form-control aifi_point" id="aifiAF2" name="data[breach_compliance_critical]" required>
												<option aifi_val=0 aifi_max=0 <?php echo $aifi_data['breach_compliance_critical'] == "Pass"?"selected":"";?> value="Pass">Pass</option>
												<option aifi_val=0 aifi_max=0 <?php echo $aifi_data['breach_compliance_critical'] == "Fail"?"selected":"";?> value="Fail">Fail</option>
												<option aifi_val=0 aifi_max=0 <?php echo $aifi_data['breach_compliance_critical'] == "NA"?"selected":"";?> value="NA">NA</option>
											</select>
										</td>
										<td><textarea class="form-control" name="data[cmt2]"><?php echo $aifi_data['cmt2'] ?></textarea></td>
									</tr>
									<tr>
										<td rowspan=1>Customer  Critical</td>
										<td style="color:red" colspan="2">Did the operator breach any Customer critical requirements</td>
										<td></td>
										<td>
											<select class="form-control aifi_point" id="aifiAF3" name="data[breach_customer_critical]" required>
												<option aifi_val=0 aifi_max=0 <?php echo $aifi_data['breach_customer_critical'] == "Pass"?"selected":"";?> value="Pass">Pass</option>
												<option aifi_val=0 aifi_max=0 <?php echo $aifi_data['breach_customer_critical'] == "Fail"?"selected":"";?> value="Fail">Fail</option>
												<option aifi_val=0 aifi_max=0 <?php echo $aifi_data['breach_customer_critical'] == "NA"?"selected":"";?> value="NA">NA</option>
											</select>
										</td>
										<td><textarea class="form-control" name="data[cmt3]"><?php echo $aifi_data['cmt3'] ?></textarea></td>
									</tr>
									<tr>
										<td colspan="6" style="background-color:#85C1E9; font-weight:bold; text-align:center;">Process</td>	
									</tr>
									<tr>
										<td rowspan=3>Resolution</td>
										<td colspan="2">Did the operator select the right procedure to follow</td>
										<td>20</td>
										<td>
											<select class="form-control aifi_point" id="" name="data[right_procedure]" required>
												<option aifi_val=20 aifi_max=20 <?php echo $aifi_data['right_procedure'] == "Pass"?"selected":"";?> value="Pass">Pass</option>
												<option aifi_val=0 aifi_max=20 <?php echo $aifi_data['right_procedure'] == "Fail"?"selected":"";?> value="Fail">Fail</option>
												<option aifi_val=20 aifi_max=20 <?php echo $aifi_data['right_procedure'] == "NA"?"selected":"";?> value="NA">NA</option>
											</select>
										</td>
										<td><textarea class="form-control" name="data[cmt4]"><?php echo $aifi_data['cmt4'] ?></textarea></td>
									</tr>
									<tr>
										<td colspan="2">Did the operator follow the procedure correctly</td>
										<td>30</td>
										<td>
											<select class="form-control aifi_point" id="" name="data[follow_procedure]" required>
												<option aifi_val=30 aifi_max=30 <?php echo $aifi_data['follow_procedure'] == "Pass"?"selected":"";?> value="Pass">Pass</option>
												<option aifi_val=0 aifi_max=30 <?php echo $aifi_data['follow_procedure'] == "Fail"?"selected":"";?> value="Fail">Fail</option>
												<option aifi_val=30 aifi_max=30 <?php echo $aifi_data['follow_procedure'] == "NA"?"selected":"";?> value="NA">NA</option>
											</select>
										</td>
										<td><textarea class="form-control" name="data[cmt5]"><?php echo $aifi_data['cmt5'] ?></textarea></td>
									</tr>
									<tr>
										<td colspan="2">Was final resolution achieved</td>
										<td>15</td>
										<td>
											<select class="form-control aifi_point" id="" name="data[final_resolution]" required>
												<option aifi_val=15 aifi_max=15 <?php echo $aifi_data['final_resolution'] == "Pass"?"selected":"";?> value="Pass">Pass</option>
												<option aifi_val=0 aifi_max=15 <?php echo $aifi_data['final_resolution'] == "Fail"?"selected":"";?> value="Fail">Fail</option>
												<option aifi_val=15 aifi_max=15 <?php echo $aifi_data['final_resolution'] == "NA"?"selected":"";?> value="NA">NA</option>
											</select>
										</td>
										<td><textarea class="form-control" name="data[cmt6]"><?php echo $aifi_data['cmt6'] ?></textarea></td>
									</tr>

									<tr>
										<td rowspan=2>Communication</td>
										<td colspan="2">Did the operator sent a communication to the client where required?</td>
										<td>15</td>
										<td>
											<select class="form-control aifi_point" id="" name="data[sent_communication]" required>
												<option aifi_val=15 aifi_max=15 <?php echo $aifi_data['sent_communication'] == "Pass"?"selected":"";?> value="Pass">Pass</option>
												<option aifi_val=0 aifi_max=15 <?php echo $aifi_data['sent_communication'] == "Fail"?"selected":"";?> value="Fail">Fail</option>
												<option aifi_val=15 aifi_max=15 <?php echo $aifi_data['sent_communication'] == "NA"?"selected":"";?> value="NA">NA</option>
											</select>
										</td>
										<td><textarea class="form-control" name="data[cmt7]"><?php echo $aifi_data['cmt7'] ?></textarea></td>
									</tr>
									<tr>
										<td colspan="2">Did the operator post an internal summary?</td>
										<td>15</td>
										<td>
											<select class="form-control aifi_point" id="" name="data[internal_summary]" required>
												<option aifi_val=15 aifi_max=15 <?php echo $aifi_data['internal_summary'] == "Pass"?"selected":"";?> value="Pass">Pass</option>
												<option aifi_val=0 aifi_max=15 <?php echo $aifi_data['internal_summary'] == "Fail"?"selected":"";?> value="Fail">Fail</option>
												<option aifi_val=15 aifi_max=15 <?php echo $aifi_data['internal_summary'] == "NA"?"selected":"";?> value="NA">NA</option>
											</select>
										</td>
										<td><textarea class="form-control" name="data[cmt8]"><?php echo $aifi_data['cmt8'] ?></textarea></td>
									</tr>
									<tr>
										<td rowspan=2>Jira Flow</td>
										<td colspan="2">Did the operator update the ticket status correctly</td>
										<td>10</td>
										<td>
											<select class="form-control aifi_point" id="" name="data[ticket_status]" required>
												<option aifi_val=10 aifi_max=10 <?php echo $aifi_data['ticket_status'] == "Pass"?"selected":"";?> value="Pass">Pass</option>
												<option aifi_val=0 aifi_max=10 <?php echo $aifi_data['ticket_status'] == "Fail"?"selected":"";?> value="Fail">Fail</option>
												<option aifi_val=10 aifi_max=10 <?php echo $aifi_data['ticket_status'] == "NA"?"selected":"";?> value="NA">NA</option>
											</select>
										</td>
										<td><textarea class="form-control" name="data[cmt9]"><?php echo $aifi_data['cmt9'] ?></textarea></td>
									</tr>
									<tr>
										<td colspan="2">Did the operator select the correct RCA from available options</td>
										<td>5</td>
										<td>
											<select class="form-control aifi_point" id="" name="data[correct_RCA]" required>
												<option aifi_val=5 aifi_max=5 <?php echo $aifi_data['correct_RCA'] == "Pass"?"selected":"";?> value="Pass">Pass</option>
												<option aifi_val=0 aifi_max=5 <?php echo $aifi_data['correct_RCA'] == "Fail"?"selected":"";?> value="Fail">Fail</option>
												<option aifi_val=5 aifi_max=5 <?php echo $aifi_data['correct_RCA'] == "NA"?"selected":"";?> value="NA">NA</option>
											</select>
										</td>
										<td><textarea class="form-control" name="data[cmt10]"><?php echo $aifi_data['cmt10'] ?></textarea></td>
									</tr>
									<tr>
										<td colspan="6" style="background-color:#85C1E9; font-weight:bold; text-align:center;">External Communication</td>	
									</tr>
									<tr>
										<td rowspan=2>Form</td>
										<td colspan="2">Did the operator set an appropriate tone and level of formality</td>
										<td>10</td>
										<td>
											<select class="form-control aifi_point" id="" name="data[appropriate_tone]" required>
												<option aifi_val=10 aifi_max=10 <?php echo $aifi_data['appropriate_tone'] == "Pass"?"selected":"";?> value="Pass">Pass</option>
												<option aifi_val=0 aifi_max=10 <?php echo $aifi_data['appropriate_tone'] == "Fail"?"selected":"";?> value="Fail">Fail</option>
												<option aifi_val=10 aifi_max=10 <?php echo $aifi_data['appropriate_tone'] == "NA"?"selected":"";?> value="NA">NA</option>
											</select>
										</td>
										<td><textarea class="form-control" name="data[cmt11]"><?php echo $aifi_data['cmt11'] ?></textarea></td>
									</tr>
									<tr>
										<td colspan="2">Did the operator communicate in a clear and easy-to-understand way?</td>
										<td>15</td>
										<td>
											<select class="form-control aifi_point" id="" name="data[communicate_clear]" required>
												<option aifi_val=15 aifi_max=15 <?php echo $aifi_data['communicate_clear'] == "Pass"?"selected":"";?> value="Pass">Pass</option>
												<option aifi_val=0 aifi_max=15 <?php echo $aifi_data['communicate_clear'] == "Fail"?"selected":"";?> value="Fail">Fail</option>
												<option aifi_val=15 aifi_max=15 <?php echo $aifi_data['communicate_clear'] == "NA"?"selected":"";?> value="NA">NA</option>
											</select>
										</td>
										<td><textarea class="form-control" name="data[cmt12]"><?php echo $aifi_data['cmt12'] ?></textarea></td>
									</tr>
									<tr>
										<td rowspan=3>Content</td>
										<td colspan="2">Did the operator show understanding of the client's request</td>
										<td>5</td>
										<td>
											<select class="form-control aifi_point" id="" name="data[show_understanding]" required>
												<option aifi_val=5 aifi_max=5 <?php echo $aifi_data['show_understanding'] == "Pass"?"selected":"";?> value="Pass">Pass</option>
												<option aifi_val=0 aifi_max=5 <?php echo $aifi_data['show_understanding'] == "Fail"?"selected":"";?> value="Fail">Fail</option>
												<option aifi_val=5 aifi_max=5 <?php echo $aifi_data['show_understanding'] == "NA"?"selected":"";?> value="NA">NA</option>
											</select>
										</td>
										<td><textarea class="form-control" name="data[cmt13]"><?php echo $aifi_data['cmt13'] ?></textarea></td>
									</tr>
									<tr>
										<td colspan="2">Did the operator share required and valid information</td>
										<td>10</td>
										<td>
											<select class="form-control aifi_point" id="" name="data[valid_information]" required>
												<option aifi_val=10 aifi_max=10 <?php echo $aifi_data['valid_information'] == "Pass"?"selected":"";?> value="Pass">Pass</option>
												<option aifi_val=0 aifi_max=10 <?php echo $aifi_data['valid_information'] == "Fail"?"selected":"";?> value="Fail">Fail</option>
												<option aifi_val=10 aifi_max=10 <?php echo $aifi_data['valid_information'] == "NA"?"selected":"";?> value="NA">NA</option>
											</select>
										</td>
										<td><textarea class="form-control" name="data[cmt14]"><?php echo $aifi_data['cmt14'] ?></textarea></td>
									</tr>
									<tr>
										<td colspan="2">Did the agent commit to follow up actions</td>
										<td>5</td>
										<td>
											<select class="form-control aifi_point" id="" name="data[follow_up]" required>
												<option aifi_val=5 aifi_max=5 <?php echo $aifi_data['follow_up'] == "Pass"?"selected":"";?> value="Pass">Pass</option>
												<option aifi_val=0 aifi_max=5 <?php echo $aifi_data['follow_up'] == "Fail"?"selected":"";?> value="Fail">Fail</option>
												<option aifi_val=5 aifi_max=5 <?php echo $aifi_data['follow_up'] == "NA"?"selected":"";?> value="NA">NA</option>
											</select>
										</td>
										<td><textarea class="form-control" name="data[cmt15]"><?php echo $aifi_data['cmt15'] ?></textarea></td>
									</tr>
									<tr>
										<td colspan="6" style="background-color:#85C1E9; font-weight:bold; text-align:center;">Internal Communication</td>	
									</tr>
									<tr>
										<td rowspan=3>Form</td>
										<td colspan="2">Did the operator communicate in a clear and easy-to-understand way</td>
										<td>15</td>
										<td>
											<select class="form-control aifi_point" id="" name="data[communicate_easy]" required>
												<option aifi_val=15 aifi_max=15 <?php echo $aifi_data['communicate_easy'] == "Pass"?"selected":"";?> value="Pass">Pass</option>
												<option aifi_val=0 aifi_max=15 <?php echo $aifi_data['communicate_easy'] == "Fail"?"selected":"";?> value="Fail">Fail</option>
												<option aifi_val=15 aifi_max=15 <?php echo $aifi_data['communicate_easy'] == "NA"?"selected":"";?> value="NA">NA</option>
											</select>
										</td>
										<td><textarea class="form-control" name="data[cmt16]"><?php echo $aifi_data['cmt16'] ?></textarea></td>
									</tr>
									<tr>
										<td colspan="2">Is the operator professional</td>
										<td>5</td>
										<td>
											<select class="form-control aifi_point" id="" name="data[professional]" required>
												<option aifi_val=5 aifi_max=5 <?php echo $aifi_data['professional'] == "Pass"?"selected":"";?> value="Pass">Pass</option>
												<option aifi_val=0 aifi_max=5 <?php echo $aifi_data['professional'] == "Fail"?"selected":"";?> value="Fail">Fail</option>
												<option aifi_val=5 aifi_max=5 <?php echo $aifi_data['professional'] == "NA"?"selected":"";?> value="NA">NA</option>
											</select>
										</td>
										<td><textarea class="form-control" name="data[cmt17]"><?php echo $aifi_data['cmt17'] ?></textarea></td>
									</tr>
									<tr>
										<td colspan="2">Did the operator submit internal escalation correctly</td>
										<td>15</td>
										<td>
											<select class="form-control aifi_point" id="" name="data[internal_escalation]" required>
												<option aifi_val=15 aifi_max=15 <?php echo $aifi_data['internal_escalation'] == "Pass"?"selected":"";?> value="Pass">Pass</option>
												<option aifi_val=0 aifi_max=15 <?php echo $aifi_data['internal_escalation'] == "Fail"?"selected":"";?> value="Fail">Fail</option>
												<option aifi_val=15 aifi_max=15 <?php echo $aifi_data['internal_escalation'] == "NA"?"selected":"";?> value="NA">NA</option>
											</select>
										</td>
										<td><textarea class="form-control" name="data[cmt18]"><?php echo $aifi_data['cmt18'] ?></textarea></td>
									</tr>
									<tr>
										<td rowspan=1>Content</td>
										<td colspan="2">Is the internal and external communication aligned</td>
										<td>10</td>
										<td>
											<select class="form-control aifi_point" id="" name="data[communication_aligned]" required>
												<option aifi_val=10 aifi_max=10 <?php echo $aifi_data['communication_aligned'] == "Pass"?"selected":"";?> value="Pass">Pass</option>
												<option aifi_val=0 aifi_max=10 <?php echo $aifi_data['communication_aligned'] == "Fail"?"selected":"";?> value="Fail">Fail</option>
												<option aifi_val=10 aifi_max=10 <?php echo $aifi_data['communication_aligned'] == "NA"?"selected":"";?> value="NA">NA</option>
											</select>
										</td>
										<td><textarea class="form-control" name="data[cmt19]"><?php echo $aifi_data['cmt19'] ?></textarea></td>
									</tr>
									<tr>
										<td>QA Summary:</td>
										<td colspan=2><textarea class="form-control" name="data[call_summary]"><?php echo $aifi_data['call_summary'] ?></textarea></td>
										<td>Feedback:</td>
										<td colspan=2><textarea class="form-control" name="data[feedback]"><?php echo $aifi_data['feedback'] ?></textarea></td>
									</tr>
									<tr>
										<td colspan=2>Upload Files [m4a,mp4,mp3,wav]</td>
											<?php if ($aifi_id == 0) { ?>
												<td colspan=6>
													<input type="file" name="attach_file[]" id="attach_file" accept=".m4a,.mp4,.mp3,.wav,audio/*" />
												</td>
												<?php } else {
												if ($aifi_data['attach_file'] != '') { ?>
													<td colspan=6>
														<input type="file" multiple class="form-control"  id="attach_file" name="attach_file[]" accept=".m4a,.mp4,.mp3,.wav,audio/*"> 
														<?php $attach_file = explode(",", $aifi_data['attach_file']);
														foreach ($attach_file as $mp) { ?>
															<audio controls='' style="background-color:#607F93">
																<source src="<?php echo base_url(); ?>qa_files/qa_grid_aifi/<?php echo $mp; ?>" type="audio/ogg">
																<source src="<?php echo base_url(); ?>qa_files/qa_grid_aifi/<?php echo $mp; ?>" type="audio/mpeg">
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
									
									<?php if($aifi_id!=0){ ?>
										<tr><td colspan=2 style="font-size:16px; font-weight:bold">Agent Feedback Acceptance:</td><td colspan=4><?php echo $aifi_data['agnt_fd_acpt'] ?></td></tr>
										<tr><td colspan=2 style="font-size:16px; font-weight:bold">Agent Review:</td><td colspan=4><?php echo $aifi_data['agent_rvw_note'] ?></td></tr>
										<tr><td colspan=2 style="font-size:16px; font-weight:bold">Management Review:</td><td colspan=4><?php echo $aifi_data['mgnt_rvw_note'] ?></td></tr>
										<tr><td colspan=2 style="font-size:16px; font-weight:bold">Client Review:</td><td colspan=4><?php echo $aifi_data['client_rvw_note'] ?></td></tr>
										
										<tr><td colspan=2  style="font-size:16px">Your Review</td><td colspan=4><textarea class="form-control1" style="width:100%" id="note" name="note"  ></textarea></td></tr>
									<?php } ?>
									
									<?php 
									if($aifi_id==0){
										if(is_access_qa_module()==true || is_access_qa_operations_module()==true){ ?>
											<tr><td colspan=6><button class="btn btn-success waves-effect" type="submit" id="qaformsubmit" style="width:500px">SAVE</button></td></tr>
									<?php 
										} 
									}else{ 
										if(is_access_qa_module()==true || is_access_qa_operations_module()==true){
											if(is_available_qa_feedback($aifi_data['entry_date'],72) == true){ ?>
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
