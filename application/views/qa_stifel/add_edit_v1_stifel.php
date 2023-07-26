
<style>

.table > tbody > tr > td{
	text-align: center;
	font-size:13px;
}

#theader{
	font-size:20px;
	font-weight:bold;
	background-color:#CA6F1E;
}

input[type='checkbox']{
	width: 20px;
}

#fatalspan3{

	background-color: transparent;
	border: none;
	outline: none;
	color: white;
}

.ui-datepicker .ui-datepicker-buttonpane button.ui-datepicker-current {
	 float: left;
	 display: none;
	}

</style>

<?php if($stifel_id!=0){
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
									<tr style="background-color:#AEB6BF">
										<td colspan="6" id="theader">Stifel [VERSION V1] Form  </td>
										<input type="hidden" name="audit_start_time" value="<?php echo CurrMySqlDate(); ?>">
									</tr>
									<tr>

									<?php
										if ($stifel_id == 0) {
											$auditorName = get_username();
											//$auditDate = CurrDateMDY();
											$auditDate =  CurrDateTimeMDY();
											$clDate_val = '';
										} else {
											if ($stifel_v2_data['entry_by'] != '') {
												$auditorName = $stifel_v2_data['auditor_name'];
											} else {
												$auditorName = $stifel_v2_data['client_name'];
											}
											$clDate_val = mysql2mmddyySls($stifel_v2_data['call_date']);
											$auditDate = mysql2mmddyySls($stifel_v2_data['audit_date']);
										}
										if ($rand_id != 0) {
											$agent_id = $rand_data['sid'];
											$fusion_id = $rand_data['fusion_id'];
											$agent_name = $rand_data['fname'] . " " . $rand_data['lname'];
											$tl_id = $rand_data['assigned_to'];
											$tl_name = $rand_data['tl_name'];
											$call_duration = $rand_data['call_duration'];
											
										} else {
											$agent_id = $stifel_v2_data['agent_id'];
											$fusion_id = $stifel_v2_data['fusion_id'];
											$agent_name = $stifel_v2_data['fname'] . " " . $stifel_v2_data['lname'] ;
											$tl_id = $stifel_v2_data['tl_id'];
											$tl_name = $stifel_v2_data['tl_name'];
											$call_duration = $stifel_v2_data['call_duration'];
										}
										?>
										<td>QA Name:<span style="font-size:24px;color:red">*</span></td>
										<td style="width:300px"><input type="text" class="form-control" value="<?php echo $auditorName; ?>" disabled></td>
										<td style="width:150px">Audit Date:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control" value="<?php echo $auditDate; ?>" disabled></td>
										<td>Call Date:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control" id="call_date" name="call_date" value="<?php echo $clDate_val; ?>" required></td>
									</tr>
									<tr>
										<td>Employee Name:<span style="font-size:24px;color:red">*</span></td>
										<td>
											<select class="form-control" id="agent_id" name="data[agent_id]" required>
												<option value="<?php echo $stifel_v2_data['agent_id'] ?>"><?php echo $agent_name; ?></option>
												<option value="">-Select-</option>
												<?php foreach($agentName as $row):  ?>
													<option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
												<?php endforeach; ?>
											</select>
										</td>
										<td>Fusion ID:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control" id="fusion_id" name="" value="<?php echo $fusion_id; ?>" readonly></td>
										<td>L1 Supervisor:<span style="font-size:24px;color:red">*</span></td>
										<td style="width:250px">
											<input type="text" class="form-control" id="tl_names"  value="<?php echo $tl_name; ?>" readonly>
												<input type="hidden" class="form-control" id="tl_id" name="data[tl_id]" value="<?php echo $tl_id; ?>" required>
										</td>
									</tr>
									<tr>
										<td>Call Duration:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control" id="call_duration" onkeydown="return false;" name="data[call_duration]" value="<?php echo $call_duration; ?>" required></td>
										<td>Call Link:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control"  name="data[call_link]" value="<?php echo $stifel_v2_data['call_link']; ?>" required></td>
										<td>Account:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control"  onkeyup="checkDecConsumer(this);" name="data[account]" value="<?php echo $stifel_v2_data['account']; ?>" required></td>
									</tr>
			
									<tr>
										<td>KPI - ACPT:<span style="font-size:24px;color:red">*</span></td>
										<td>
												<select class="form-control" id="KPI_ACPT" name="data[KPI_ACPT]" required>
													<option value="">-Select-</option>
													<option value="Agent"  <?= ($stifel_v2_data['KPI_ACPT']=="Agent")?"selected":"" ?>>Agent</option>
													<option value="Process"  <?= ($stifel_v2_data['KPI_ACPT']=="Process")?"selected":"" ?>>Process</option>
													<option value="Customer"  <?= ($stifel_v2_data['KPI_ACPT']=="Customer")?"selected":"" ?>>Customer</option>
													<option value="Technology"  <?= ($stifel_v2_data['KPI_ACPT']=="Technology")?"selected":"" ?>>Technology</option>
													<option value="NA"  <?= ($stifel_v2_data['KPI_ACPT']=="NA")?"selected":"" ?>>NA</option>
												</select>
											</td>
										<td>VOC:<span style="font-size:24px;color:red">*</span></td>
										<td>
											<select class="form-control" id="voc" name="data[voc]" required>
												<option value="">-Select-</option>
												<option <?php echo $stifel_v2_data['voc']=='1'?"selected":""; ?> value="1">1</option>
												<option <?php echo $stifel_v2_data['voc']=='2'?"selected":""; ?> value="2">2</option>
												<option <?php echo $stifel_v2_data['voc']=='3'?"selected":""; ?> value="3">3</option>
												<option <?php echo $stifel_v2_data['voc']=='4'?"selected":""; ?> value="4">4</option>
												<option <?php echo $stifel_v2_data['voc']=='5'?"selected":""; ?> value="5">5</option>
											</select>
										</td>
										<td>Audit Type:<span style="font-size:24px;color:red">*</span></td>
										<td>
											<select class="form-control" id="audit_type" name="data[audit_type]" required>
                                                    <option value="">-Select-</option>
                                                    <option value="CQ Audit" <?= ($stifel_v2_data['audit_type']=="CQ Audit")?"selected":"" ?>>CQ Audit</option>
                                                    <option value="BQ Audit" <?= ($stifel_v2_data['audit_type']=="BQ Audit")?"selected":"" ?>>BQ Audit</option>
                                                    <option value="Calibration" <?= ($stifel_v2_data['audit_type']=="Calibration")?"selected":"" ?>>Calibration</option>
                                                    <option value="Pre-Certificate Mock Call" <?= ($stifel_v2_data['audit_type']=="Pre-Certificate Mock Call")?"selected":"" ?>>Pre-Certificate Mock Call</option>
                                                    <option value="Certification Audit" <?= ($stifel_v2_data['audit_type']=="Certification Audit")?"selected":"" ?>>Certification Audit</option>
                                                    <option value="WoW Call"  <?= ($stifel_v2_data['audit_type']=="WoW Call")?"selected":"" ?>>WoW Call</option>
                                                    <option value="Hygiene Audit"  <?= ($stifel_v2_data['audit_type']=="Hygiene Audit")?"selected":"" ?>>Hygiene Audit</option>
                                                    <option value="Operation Audit"  <?= ($stifel_v2_data['audit_type']=="Operation Audit")?"selected":"" ?>>Operation Audit</option>
                                                    <option value="Trainer Audit"  <?= ($stifel_v2_data['audit_type']=="Trainer Audit")?"selected":"" ?>>Trainer Audit</option> 
                                                    <option value="QA Supervisor Audit"  <?= ($stifel_v2_data['audit_type']=="QA Supervisor Audit")?"selected":"" ?>>QA Supervisor Audit</option> 
                                                </select>
										</td>
									</tr>
									<tr>
										<td class="auType">Auditor Type<span style="font-size:24px;color:red">*</span></td>
										<td class="auType">
											<select class="form-control" id="auditor_type" name="data[auditor_type]">
												<option value="">-Select-</option>
												<option value="Master">Master</option>
												<option value="Regular">Regular</option>
											</select>
										</td>
									</tr>
									<tr>
										<td style="font-weight:bold">Earned Score:</td>
										<td><input type="text" readonly id="stifel_v2Earned" name="data[earned_score]" class="form-control" style="font-weight:bold" value="<?php echo $stifel_v2_data['overall_score'] ?>"></td>
										<td style="font-weight:bold">Possible Score:</td>
										<td><input type="text" readonly id="stifel_v2Possible" name="data[possible_score]" class="form-control" style="font-weight:bold" value="<?php echo $stifel_v2_data['overall_score'] ?>"></td>
										<td style="font-weight:bold">Overall Score Percentage:</td>
										<td><input type="text" readonly id="stifel_v2OverallScore" name="data[overall_score]" class="form-control stifel_v2_Fatal" style="font-weight:bold" value="<?php echo $stifel_v2_data['overall_score'] ?>"></td>
									</tr>
									<tr style="font-weight:bold; background-color:#2471A3; color:white">
										<td colspan=3>Parameters</td>
										<td>Weightage</td>
										<td>Rating</td>
										<td>Remarks</td>
									</tr>
									<tr>
										<td style="background-color:#BFC9CA"><b>1</b></td>
										<td colspan=2 style="background-color:#BFC9CA">Greeting and Farewell</td>
										<td style="background-color:#BFC9CA">10</td>
										<td style="background-color:#BFC9CA"></td>
										<td style="background-color:#BFC9CA"></td>
									</tr>
									<tr>
										<td></td>
										<td colspan=2>Opening : Did the agent open the call within 10 second using their name and the appropriate branding for the call?</td>
										<td>5</td>
										<td>
											<select class="form-control stifelVal_v2" data-id="greeting_opening" name="data[greeting_opening]" required>
												<option stifel_v2_val=5 stifel_v2_max="5" <?php echo $stifel_v2_data['greeting_opening']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option stifel_v2_val=0 stifel_v2_max="5" <?php echo $stifel_v2_data['greeting_opening']=='No'?"selected":""; ?> value="No">No</option>
												<option stifel_v2_val=5 stifel_v2_max="5" <?php echo $stifel_v2_data['greeting_opening']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td><input type="text" name="data[comm1]" class="form-control" value="<?php echo $stifel_v2_data['comm1'] ?>"></td>
									</tr>
									<tr>
										<td></td>
										<td colspan=2>Closing : Did the agent offer further assistance before closing the call and closed the call using the appropriate branding?</td>
										<td>5</td>
										<td>
											<select class="form-control stifelVal_v2" data-id="greeting_closing" name="data[greeting_closing]" required>
												<option stifel_v2_val=5 stifel_v2_max="5" <?php echo $stifel_v2_data['greeting_closing']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option stifel_v2_val=0 stifel_v2_max="5" <?php echo $stifel_v2_data['greeting_closing']=='No'?"selected":""; ?> value="No">No</option>
												<option stifel_v2_val=5 stifel_v2_max="5" <?php echo $stifel_v2_data['greeting_closing']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td><input type="text" name="data[comm2]" class="form-control" value="<?php echo $stifel_v2_data['comm2'] ?>"></td>
									</tr>
									<tr>
										<td style="background-color:#BFC9CA"><b>2</b></td>
										<td colspan=2 style="background-color:#BFC9CA">Ownership</td>
										<td style="background-color:#BFC9CA">10</td>
										<td style="background-color:#BFC9CA"></td>
										<td style="background-color:#BFC9CA"></td>
									</tr>
									<tr>
										<td></td>
										<td colspan=2>Ownership/ Assurance : Did the agent showed willingness to assist the customer by providing the statement like “I will definitely assist you with that.” etc</td>
										<td>5</td>
										<td>
											<select class="form-control stifelVal_v2" data-id="ownership_assurance" name="data[ownership_assurance]" required>
												<option stifel_v2_val=5 stifel_v2_max="5" <?php echo $stifel_v2_data['ownership_assurance']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option stifel_v2_val=0 stifel_v2_max="5" <?php echo $stifel_v2_data['ownership_assurance']=='No'?"selected":""; ?> value="No">No</option>
												<option stifel_v2_val=5 stifel_v2_max="5" <?php echo $stifel_v2_data['ownership_assurance']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td><input type="text" name="data[comm3]" class="form-control" value="<?php echo $stifel_v2_data['comm3'] ?>"></td>
									</tr>
									<tr>
										<td></td>
										<td colspan=2>Did the agent offer to stay on the call until the issue has been resolved?</td>
										<td>5</td>
										<td>
											<select class="form-control stifelVal_v2" data-id="issue_resolved" name="data[issue_resolved]" required>
												<option stifel_v2_val=5 stifel_v2_max="5" <?php echo $stifel_v2_data['issue_resolved']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option stifel_v2_val=0 stifel_v2_max="5" <?php echo $stifel_v2_data['issue_resolved']=='No'?"selected":""; ?> value="No">No</option>
												<option stifel_v2_val=5 stifel_v2_max="5" <?php echo $stifel_v2_data['issue_resolved']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td><input type="text" name="data[comm4]" class="form-control" value="<?php echo $stifel_v2_data['comm4'] ?>"></td>
									</tr>
									<tr>
										<td style="background-color:#BFC9CA"><b>3</b></td>
										<td colspan=2 style="background-color:#BFC9CA">Verification</td>
										<td style="background-color:#BFC9CA">10</td>
										<td style="background-color:#BFC9CA"></td>
										<td style="background-color:#BFC9CA"></td>
									</tr>
									<tr>
										<td></td>
										<td colspan=2 style="color:red;">Did the agent verify the customer with the necessary information?</td>
										<td>10</td>
										<td>
											<select class="form-control stifelVal_v2" id="stifel_v2_Fatal1" name="data[verification]" required>
												<option stifel_v2_val=10 stifel_v2_max="10" <?php echo $stifel_v2_data['verification']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option stifel_v2_val=0 stifel_v2_max="10" <?php echo $stifel_v2_data['verification']=='No'?"selected":""; ?> value="No">No</option>
												<option stifel_v2_val=10 stifel_v2_max="10" <?php echo $stifel_v2_data['verification']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td><input type="text" name="data[comm5]" class="form-control" value="<?php echo $stifel_v2_data['comm5'] ?>"></td>
									</tr>
									<tr>
										<td style="background-color:#BFC9CA"><b>6</b></td>
										<td colspan=2 style="background-color:#BFC9CA">Resolution</td>
										<td style="background-color:#BFC9CA">25</td>
										<td style="background-color:#BFC9CA"></td>
										<td style="background-color:#BFC9CA"></td>
									</tr>
									<tr>
										<td></td>
										<td colspan=2 style="color:red;">Issue Identification / Understanding : Did the agent ask proper set of probing questions to fully understand the customer’s concern?</td>
										<td>13</td>
										<td>
											<select class="form-control stifelVal_v2" id="stifel_v2_Fatal2" name="data[issue_identification]" required>
												<option stifel_v2_val=13 stifel_v2_max="13" <?php echo $stifel_v2_data['issue_identification']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option stifel_v2_val=0 stifel_v2_max="13"  <?php echo $stifel_v2_data['issue_identification']=='No'?"selected":""; ?> value="No">No</option>
												<option stifel_v2_val=13 stifel_v2_max="13"  <?php echo $stifel_v2_data['issue_identification']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td><input type="text" name="data[comm6]" class="form-control" value="<?php echo $stifel_v2_data['comm6'] ?>"></td>
									</tr>
									<tr>
										<td></td>
										<td colspan=2 style="color:red;">Correct & Accurate Information : Did the agent deliver the correct and accurate information and resolution to the customer?</td>
										<td>12</td>
										<td>
											<select class="form-control stifelVal_v2" id="stifel_v2_Fatal3" name="data[accurate_information]" required>
												<option stifel_v2_val=12 stifel_v2_max="12" <?php echo $stifel_v2_data['accurate_information']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option stifel_v2_val=0 stifel_v2_max="12" <?php echo $stifel_v2_data['accurate_information']=='No'?"selected":""; ?> value="No">No</option>
												<option stifel_v2_val=12 stifel_v2_max="12" <?php echo $stifel_v2_data['accurate_information']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td><input type="text" name="data[comm7]" class="form-control" value="<?php echo $stifel_v2_data['comm7'] ?>"></td>
									</tr>
									<tr>
										<td style="background-color:#BFC9CA"><b>7</b></td>
										<td colspan=2 style="background-color:#BFC9CA">Hold and Transfer Protocol</td>
										<td style="background-color:#BFC9CA">10</td>
										<td style="background-color:#BFC9CA"></td>
										<td style="background-color:#BFC9CA"></td>
									</tr>
									<tr>
										<td></td>
										<td colspan=2>Hold and Dead air Procedure : Did the agent ask for permission prior placing the customer on hold? / Did the agent refresh the hold if the duration is longer than what the customer was advised? / Did the agent avoid dead air more than 20 secs?</td>
										<td>5</td>
										<td>
											<select class="form-control stifelVal_v2" data-id="dead_air" name="data[dead_air]" required>
												<option stifel_v2_val=5 stifel_v2_max="5" <?php echo $stifel_v2_data['dead_air']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option stifel_v2_val=0 stifel_v2_max="5" <?php echo $stifel_v2_data['dead_air']=='No'?"selected":""; ?> value="No">No</option>
												<option stifel_v2_val=5 stifel_v2_max="5" <?php echo $stifel_v2_data['dead_air']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td><input type="text" name="data[comm8]" class="form-control" value="<?php echo $stifel_v2_data['comm8'] ?>"></td>
									</tr>
									<tr>
										<td></td>
										<td colspan=2>Transfer : Did the agent properly transfer call if required? / The agent is not require to stay on the call once it was transferred not unless the customer request it </td>
										<td>5</td>
										<td>
											<select class="form-control stifelVal_v2" data-id="transfer_call" name="data[transfer_call]" required>
												<option stifel_v2_val=5 stifel_v2_max="5" <?php echo $stifel_v2_data['transfer_call']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option stifel_v2_val=0 stifel_v2_max="5" <?php echo $stifel_v2_data['transfer_call']=='No'?"selected":""; ?> value="No">No</option>
												<option stifel_v2_val=5 stifel_v2_max="5" <?php echo $stifel_v2_data['transfer_call']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td><input type="text" name="data[comm9]" class="form-control" value="<?php echo $stifel_v2_data['comm9'] ?>"></td>
									</tr>
									<tr>
										<td style="background-color:#BFC9CA"><b>8</b></td>
										<td colspan=2 style="background-color:#BFC9CA">ZTP</td>
										<td style="background-color:#BFC9CA">5</td>
										<td style="background-color:#BFC9CA"></td>
										<td style="background-color:#BFC9CA"></td>
									</tr>
									<tr>
										<td></td>
										<td colspan=2 style="color:red;">Rudeness : Did the agent avoid using negative remarks or inappropriate words?</td>
										<td>3</td>
										<td>
											<select class="form-control stifelVal_v2" id="stifel_v2_Fatal4" name="data[rudeness]" required>
												<option stifel_v2_val=3 stifel_v2_max="3" <?php echo $stifel_v2_data['rudeness']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option stifel_v2_val=0 stifel_v2_max="3" <?php echo $stifel_v2_data['rudeness']=='No'?"selected":""; ?> value="No">No</option>
												<option stifel_v2_val=3 stifel_v2_max="3" <?php echo $stifel_v2_data['rudeness']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td><input type="text" name="data[comm10]" class="form-control" value="<?php echo $stifel_v2_data['comm10'] ?>"></td>
									</tr>
									<tr>
										<td></td>
										<td colspan=2 style="color:red;">Correct & Accurate Information : Did the agent deliver the correct and accurate information and resolution to the customer?</td>
										<td>2</td>
										<td>
											<select class="form-control stifelVal_v2" id="stifel_v2_Fatal5" name="data[call_avoidance]" required>
												<option stifel_v2_val=2 stifel_v2_max="2" <?php echo $stifel_v2_data['call_avoidance']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option stifel_v2_val=0 stifel_v2_max="2" <?php echo $stifel_v2_data['call_avoidance']=='No'?"selected":""; ?> value="No">No</option>
												<option stifel_v2_val=2 stifel_v2_max="2" <?php echo $stifel_v2_data['call_avoidance']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td><input type="text" name="data[comm11]" class="form-control" value="<?php echo $stifel_v2_data['comm11'] ?>"></td>
									</tr>
									<tr>
										<td style="background-color:#BFC9CA"><b>9</b></td>
										<td colspan=2 style="background-color:#BFC9CA">Soft Skills and Telephone Etiquettes</td>
										<td style="background-color:#BFC9CA">30</td>
										<td style="background-color:#BFC9CA"></td>
										<td style="background-color:#BFC9CA"></td>
									</tr>
									<tr>
										<td></td>
										<td colspan=2>Empathy / Apology : Did the agent provide empathy / apology whenever it is required?</td>
										<td>6</td>
										<td>
											<select class="form-control stifelVal_v2" id="" name="data[empathy]" required>
												<option stifel_v2_val=6 stifel_v2_max="6" <?php echo $stifel_v2_data['empathy']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option stifel_v2_val=0 stifel_v2_max="6" <?php echo $stifel_v2_data['empathy']=='No'?"selected":""; ?> value="No">No</option>
												<option stifel_v2_val=6 stifel_v2_max="6" <?php echo $stifel_v2_data['empathy']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td><input type="text" name="data[comm12]" class="form-control" value="<?php echo $stifel_v2_data['comm12'] ?>"></td>
									</tr>
									<tr>
										<td></td>
										<td colspan=2>Tone / Pacing / Fumbling : Did the agent able to converse in a pleasant tone with appropriate rate of speech, confidence and enthusiasm?</td>
										<td>8</td>
										<td>
											<select class="form-control stifelVal_v2" id="" name="data[tone_pacing]" required>
												<option stifel_v2_val=8 stifel_v2_max="8" <?php echo $stifel_v2_data['tone_pacing']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option stifel_v2_val=0 stifel_v2_max="8" <?php echo $stifel_v2_data['tone_pacing']=='No'?"selected":""; ?> value="No">No</option>
												<option stifel_v2_val=8 stifel_v2_max="8" <?php echo $stifel_v2_data['tone_pacing']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td><input type="text" name="data[comm13]" class="form-control" value="<?php echo $stifel_v2_data['comm13'] ?>"></td>
									</tr>
									<tr>
										<td></td>
										<td colspan=2>Active Listening : Did the agent demonstrate active listening?</td>
										<td>8</td>
										<td>
											<select class="form-control stifelVal_v2" id="" name="data[active_listening]" required>
												<option stifel_v2_val=8 stifel_v2_max="8" <?php echo $stifel_v2_data['active_listening']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option stifel_v2_val=0 stifel_v2_max="8" <?php echo $stifel_v2_data['active_listening']=='No'?"selected":""; ?> value="No">No</option>
												<option stifel_v2_val=8 stifel_v2_max="8" <?php echo $stifel_v2_data['active_listening']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td><input type="text" name="data[comm14]" class="form-control" value="<?php echo $stifel_v2_data['comm14'] ?>"></td>
									</tr>
									<tr>
										<td></td>
										<td colspan=2>Professionalism : Did the agent speak in a respectful tone, use proper manners, and say 'please' and 'thank you' throughout the conversation?</td>
										<td>8</td>
										<td>
											<select class="form-control stifelVal_v2" id="" name="data[professionalism]" required>
												<option stifel_v2_val=8 stifel_v2_max="8" <?php echo $stifel_v2_data['professionalism']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option stifel_v2_val=0 stifel_v2_max="8" <?php echo $stifel_v2_data['professionalism']=='No'?"selected":""; ?> value="No">No</option>
												<option stifel_v2_val=8 stifel_v2_max="8" <?php echo $stifel_v2_data['professionalism']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td>
											<input type="text" name="data[comm15]" class="form-control" value="<?php echo $stifel_v2_data['comm15'] ?>">
											</td>
									</tr>
									<tr>
										<td>Observations:</td>
										<td colspan=2><textarea class="form-control"  name="data[call_summary]"><?php echo $stifel_v2_data['call_summary'] ?></textarea></td>
										<td>Area of opportunity:</td>
										<td colspan=2><textarea class="form-control"  name="data[feedback]"><?php echo $stifel_v2_data['feedback'] ?></textarea></td>
									</tr>
									<?php if($stifel_id==0){ ?>
									<tr>
										<td colspan=2>Upload Files [m4a,mp4,mp3,wav]</td>
										<td colspan=4><input type="file" multiple class="form-control" id="attach_file" name="attach_file[]" accept=".m4a,.mp4,.mp3,.wav,audio/*"></td>
									</tr>
									<?php }else{ ?>
									<tr>	
										<td colspan=2>Upload Files [m4a,mp4,mp3,wav]</td>
										<?php if($stifel_v2_data['attach_file']!=''){ ?>
											<td colspan=4>
												<input type="file" multiple class="form-control"  id="attach_file" name="attach_file[]" accept=".m4a,.mp4,.mp3,.wav,audio/*"> 
												<?php $attach_file = explode(",",$stifel_v2_data['attach_file']);
												 foreach($attach_file as $mp){ ?>
													<audio controls='' style="background-color:#607F93"> 
													  <source src="<?php echo base_url(); ?>qa_files/qa_stifel/<?php echo $mp; ?>" type="audio/ogg">
													  <source src="<?php echo base_url(); ?>qa_files/qa_stifel/<?php echo $mp; ?>" type="audio/mpeg">
													</audio> </br>
												 <?php } ?>
											</td>
										<?php }else{
												echo '<td colspan=6>
													<input type="file" multiple class="form-control" id="attach_file" name="attach_file[]" accept=".m4a,.mp4,.mp3,.wav,audio/*">
													<b>No Files</b></td>';
											  }
										} ?>
									</tr>
										
									<?php if($stifel_id!=0){ ?>
										<tr><td colspan=2 style="font-size:16px; font-weight:bold">Agent Review:</td><td colspan=4><?php echo $stifel_v2_data['agent_rvw_note'] ?></td></tr>
										<tr><td colspan=2 style="font-size:16px; font-weight:bold">Management Review:</td><td colspan=4><?php echo $stifel_v2_data['mgnt_rvw_note'] ?></td></tr>
										<tr><td colspan=2 style="font-size:16px; font-weight:bold">Client Review:</td><td colspan=4><?php echo $stifel_v2_data['client_rvw_note'] ?></td></tr>
										
										<tr><td colspan=2  style="font-size:16px">Your Review</td><td colspan=4><textarea class="form-control1" style="width:100%" id="note" name="note" required></textarea></td></tr>
									<?php } ?>
										
									<?php 
									if($stifel_id==0){
										if(is_access_qa_module()==true || is_access_qa_operations_module()==true){ ?>
											<tr><td colspan=6><button class="btn btn-success waves-effect" type="submit" id="qaformsubmit" style="width:500px">SAVE</button></td></tr>
									<?php 
										} 
									}else{ 
										if(is_access_qa_module()==true || is_access_qa_operations_module()==true){
											if(is_available_qa_feedback($stifel_v2_data['entry_date'],72) == true){ ?>
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
