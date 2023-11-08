
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

#fatalspan1{

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
										<td colspan="6" id="theader">SCAN QA Form </td>
										<input type="hidden" name="audit_start_time" value="<?php echo CurrMySqlDate(); ?>">
									</tr>
									<tr>
									<?php
										
										
										if ($scan_data['entry_by'] != '') {
											$auditorName = $scan_data['auditor_name'];
										} else {
											$auditorName = $scan_data['client_name'];
										}
									
										$auditDate = mysql2mmddyy($scan_data['audit_date']);
									 
										$clDate_val = mysqlDt2mmddyy($scan_data['call_date']);
										

										if ($rand_id != 0) {
											$agent_id = $rand_data['sid'];
											$fusion_id = $rand_data['fusion_id'];
											$agent_name = $rand_data['fname'] . " " . $rand_data['lname'];
											$tl_id = $rand_data['assigned_to'];
											$tl_name = $rand_data['tl_name'];
											$call_duration = $rand_data['call_duration'];
											
										} else {
											$agent_id = $scan_data['agent_id'];
											$fusion_id = $scan_data['fusion_id'];
											$agent_name = $scan_data['fname'] . " " . $scan_data['lname'] ;
											$tl_id = $scan_data['tl_id'];
											$tl_name = $scan_data['tl_name'];
											$call_duration = $scan_data['call_duration'];
										}
										?>	
									
										<td>QA Name:<span style="font-size:24px;color:red">*</span></td>
										<td style="width:300px"><input type="text" class="form-control" value="<?php echo $auditorName; ?>" disabled></td>
										<td style="width:150px">Audit Date:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control" value="<?php echo $auditDate; ?>" disabled></td>
										<td>Call Date/Time:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control" id="call_date_time" name="call_date"  onkeydown="return false;" value="<?php echo $clDate_val; ?>" disabled></td>
									</tr>
									<tr>
										<td>Agent Name:<span style="font-size:24px;color:red">*</span></td>
										<td>
											<select class="form-control" id="agent_id" name="data[agent_id]" disabled>
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
										<td><input type="text" class="form-control" id="fusion_id" name="" value="<?php echo $scan_data['fusion_id']; ?>" readonly></td>
										<td>L1 Supervisor:<span style="font-size:24px;color:red">*</span></td>
										<td style="width:250px">
											<input type="text" class="form-control" id="tl_name"  value="<?php echo $tl_name; ?>" readonly>
												<input type="hidden" class="form-control" id="tl_id" name="data[tl_id]" value="<?php echo $tl_id ?>" disabled>
										</td>
									</tr>
									<tr>
										<td>Call Duration:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control" id="call_duration" name="data[call_duration]" onkeydown="return false;" value="<?php echo $call_duration; ?>" disabled></td> 
										<!-- <td>Employee ID:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control"  name="data[employee_id]" value="<?php //echo $scan_data['employee_id']; ?>" disabled></td> -->

										<td>KPI - ACPT:<span style="font-size:24px;color:red">*</span></td>
										<td>
											<select class="form-control" id="" name="data[kpi_acpt]" disabled>
												<option value="">-Select-</option>
												<option value="Agent"  <?= ($scan_data['kpi_acpt']=="Agent")?"selected":"" ?>>Agent</option>
												<option value="Process"  <?= ($scan_data['kpi_acpt']=="Process")?"selected":"" ?>>Process</option>
												<option value="Customer"  <?= ($scan_data['kpi_acpt']=="Customer")?"selected":"" ?>>Customer</option>
												<option value="Technology"  <?= ($scan_data['kpi_acpt']=="Technology")?"selected":"" ?>>Technology</option>
												<option value="NA"  <?= ($scan_data['kpi_acpt']=="NA")?"selected":"" ?>>NA</option>
											</select>
										</td>

										<td>VOC:<span style="font-size:24px;color:red">*</span></td>
										<td>
											<select class="form-control" id="voc" name="data[voc]" disabled>
												<option value="">-Select-</option>
												<option <?php echo $scan_data['voc']=='1'?"selected":""; ?> value="1">1</option>
												<option <?php echo $scan_data['voc']=='2'?"selected":""; ?> value="2">2</option>
												<option <?php echo $scan_data['voc']=='3'?"selected":""; ?> value="3">3</option>
												<option <?php echo $scan_data['voc']=='4'?"selected":""; ?> value="4">4</option>
												<option <?php echo $scan_data['voc']=='5'?"selected":""; ?> value="5">5</option>
												<option value="6"  <?= ($scan_data['voc']=="6")?"selected":"" ?>>6</option>
												<option value="7"  <?= ($scan_data['voc']=="7")?"selected":"" ?>>7</option>
												<option value="8"  <?= ($scan_data['voc']=="8")?"selected":"" ?>>8</option>
												<option value="9"  <?= ($scan_data['voc']=="9")?"selected":"" ?>>9</option>
												<option value="10"  <?= ($scan_data['voc']=="10")?"selected":"" ?>>10</option>
											</select>
										</td>
									</tr>
									
									<tr>
										<td>Audit Type:<span style="font-size:24px;color:red">*</span></td>
										<td>
											<select class="form-control" id="audit_type" name="data[audit_type]" disabled>
												<option value="">-Select-</option>
												<option value="CQ Audit" <?= ($scan_data['audit_type']=="CQ Audit")?"selected":"" ?>>CQ Audit</option>
												<option value="BQ Audit" <?= ($scan_data['audit_type']=="BQ Audit")?"selected":"" ?>>BQ Audit</option>
												<option value="Calibration" <?= ($scan_data['audit_type']=="Calibration")?"selected":"" ?>>Calibration</option>
												<option value="Pre-Certificate Mock Call" <?= ($scan_data['audit_type']=="Pre-Certificate Mock Call")?"selected":"" ?>>Pre-Certificate Mock Call</option>
												<option value="Certification Audit" <?= ($scan_data['audit_type']=="Certification Audit")?"selected":"" ?>>Certification Audit</option>
												<option value="WoW Call"  <?= ($scan_data['audit_type']=="WoW Call")?"selected":"" ?>>WoW Call</option>
												<option value="Hygiene Audit"  <?= ($scan_data['audit_type']=="Hygiene Audit")?"selected":"" ?>>Hygiene Audit</option>
												<option value="Operation Audit"  <?= ($scan_data['audit_type']=="Operation Audit")?"selected":"" ?>>Operation Audit</option>
												<option value="Trainer Audit"  <?= ($scan_data['audit_type']=="Trainer Audit")?"selected":"" ?>>Trainer Audit</option> 
												<option value="QA Supervisor Audit"  <?= ($scan_data['audit_type']=="QA Supervisor Audit")?"selected":"" ?>>QA Supervisor Audit</option> 
											</select>
										</td>
										<td class="auType">Auditor Type<span style="font-size:24px;color:red">*</span></td>
										<td class="auType">
											<select class="form-control" id="auditor_type" name="data[auditor_type]">
												<option value="">-Select-</option>
												 <option value="Master" <?= ($scan_data['auditor_type']=="Master")?"selected":"" ?>>Master</option> 
												 <option value="Regular" <?= ($scan_data['auditor_type']=="Regular")?"selected":"" ?>>Regular</option> 
											</select>
										</td>
									</tr>
									
									<tr>
										<td style="font-weight:bold">Earned Score:</td>
										<td><input type="text" readonly id="scanEarned" name="data[earned_score]" class="form-control" style="font-weight:bold" value="<?php echo $scan_data['overall_score'] ?>"></td>
										<td style="font-weight:bold">Possible Score:</td>
										<td><input type="text" readonly id="scanPossible" name="data[possible_score]" class="form-control" style="font-weight:bold" value="<?php echo $scan_data['overall_score'] ?>"></td>
										<td style="font-weight:bold">Overall Score Percentage:</td>
										<td><input type="text" readonly id="scanOverallScore" name="data[overall_score]" class="form-control scanCallFatal" style="font-weight:bold" value="<?php echo $scan_data['overall_score'] ?>"></td>
									</tr>	

									<tr style="font-weight:bold; background-color:#2471A3; color:white">
										<td colspan=2>Parameters</td>
										<td>Weightage</td>
										<td>Rating</td>
										<td colspan="2">Remarks</td>
									</tr>
									<tr>
										<td style="background-color:#BFC9CA"><b>1</b></td>
										<td colspan=1 style="background-color:#BFC9CA">COMPLIANCE</td>
										<td style="background-color:#BFC9CA">40</td>
										<td style="background-color:#BFC9CA" id="score_compliance"></td>
										<td colspan="2" style="background-color:#BFC9CA"></td>
									</tr>
									<tr>
										<td></td>
										<td colspan=1>HIPAA/PHI</td>
										<td>0,10</td>
										<td>
											<select class="form-control scanVal" data-id="compliance"  name="data[hipaa_phi]" disabled>
												<option scan_val=0 scan_max='10' <?php echo $scan_data['hipaa_phi']=='0'?"selected":""; ?> value="0">0</option>
												<option scan_val=10 scan_max='10' <?php echo $scan_data['hipaa_phi']=='10'?"selected":""; ?> value="10">10</option>
											</select>
										</td>
										<td colspan="2"> <textarea class="form-control" disabled name="data[cmt1]"><?php echo $scan_data['cmt1'] ?></textarea></td>
									</tr>
									<tr>
										<td></td>
										<td colspan=1>Call Recording Disclosure</td>
										<td>0,5,10</td>
										<td>
											<select class="form-control scanVal" data-id="compliance"  name="data[call_recording]" disabled>
												<option scan_val=0 scan_max='10' <?php echo $scan_data['call_recording']=='10'?"selected":""; ?> value="0">0</option>
												<option scan_val=5 scan_max='10' <?php echo $scan_data['call_recording']=='5'?"selected":""; ?> value="5">5</option>
												<option scan_val=10 scan_max='10' <?php echo $scan_data['call_recording']=='10'?"selected":""; ?> value="10">10</option>
											</select>
										</td>
										<td colspan="2"> <textarea class="form-control" disabled name="data[cmt2]"><?php echo $scan_data['cmt2'] ?></textarea></td>
									</tr>
									<tr>
										<td></td>
										<td colspan=1>Accurate Information</td>
										<td>0,10</td>
										<td>
											<select class="form-control scanVal" data-id="compliance"  name="data[accurate_information]" disabled>
												<option scan_val=0 scan_max='10' <?php echo $scan_data['accurate_information']=='0'?"selected":""; ?> value="0">0</option>
												<option scan_val=10 scan_max='10' <?php echo $scan_data['accurate_information']=='10'?"selected":""; ?> value="10">10</option>
											</select>
										</td>
										<td colspan="2"> <textarea class="form-control" disabled name="data[cmt3]"><?php echo $scan_data['cmt3'] ?></textarea></td>
									</tr>
									<tr>
										<td></td>
										<td colspan=1>Telephonic Agreement</td>
										<td>0,5,10</td>
										<td>
											<select class="form-control scanVal" data-id="compliance"  name="data[telephonic_agreement]" disabled>
												<option scan_val=0 scan_max='10' <?php echo $scan_data['telephonic_agreement']=='0'?"selected":""; ?> value="0">0</option>
												<option scan_val=5 scan_max='10' <?php echo $scan_data['telephonic_agreement']=='5'?"selected":""; ?> value="5">5</option>
												<option scan_val=10 scan_max='10' <?php echo $scan_data['telephonic_agreement']=='10'?"selected":""; ?> value="10">10</option>
											</select>
										</td>
										<td colspan="2"> <textarea class="form-control" disabled name="data[cmt4]"><?php echo $scan_data['cmt4'] ?></textarea></td>
									</tr>

									<tr>
										<td style="background-color:#BFC9CA"><b>2</b></td>
										<td colspan=1 style="background-color:#BFC9CA">CALL FLOW</td>
										<td style="background-color:#BFC9CA">36</td>
										<td style="background-color:#BFC9CA" id="score_call_flow"></td>
										<td colspan="2" style="background-color:#BFC9CA"></td>
									</tr>
									<tr>
										<td></td>
										<td colspan=1>Greeting</td>
										<td>4</td>
										<td>
											<select class="form-control scanVal" data-id="call_flow"  name="data[greeting]" disabled>
												<option scan_val=0 scan_max='4' <?php echo $scan_data['greeting']=='0'?"selected":""; ?> value="0">0</option>
												<option scan_val=1 scan_max='4' <?php echo $scan_data['greeting']=='1'?"selected":""; ?> value="1">1</option>
												<option scan_val=2 scan_max='4' <?php echo $scan_data['greeting']=='2'?"selected":""; ?> value="2">2</option>
												<option scan_val=3 scan_max='4' <?php echo $scan_data['greeting']=='3'?"selected":""; ?> value="3">3</option>
												<option scan_val=4 scan_max='4' <?php echo $scan_data['greeting']=='4'?"selected":""; ?> value="4">4</option>
											</select>
										</td>
										<td colspan="2"> <textarea class="form-control" disabled name="data[cmt5]"><?php echo $scan_data['cmt5'] ?></textarea></td>
									</tr>
									<tr>
										<td></td>
										<td colspan=1>Probing/Paraphrasing</td>
										<td>4</td>
										<td>
											<select class="form-control scanVal" data-id="call_flow"  name="data[probing]" disabled>
												<option scan_val=0 scan_max='4' <?php echo $scan_data['probing']=='0'?"selected":""; ?> value="0">0</option>
												<option scan_val=1 scan_max='4' <?php echo $scan_data['probing']=='1'?"selected":""; ?> value="1">1</option>
												<option scan_val=2 scan_max='4' <?php echo $scan_data['probing']=='2'?"selected":""; ?> value="2">2</option>
												<option scan_val=3 scan_max='4' <?php echo $scan_data['probing']=='3'?"selected":""; ?> value="3">3</option>
												<option scan_val=4 scan_max='4' <?php echo $scan_data['probing']=='4'?"selected":""; ?> value="4">4</option>
											</select>
										</td>
										<td colspan="2"> <textarea class="form-control" disabled name="data[cmt6]"><?php echo $scan_data['cmt6'] ?></textarea></td>
									</tr>
									<tr>
										<td></td>
										<td colspan=1>Critical Thinking</td>
										<td>4</td>
										<td>
											<select class="form-control scanVal" data-id="call_flow"  name="data[critical_thinking]" disabled>
												<option scan_val=0 scan_max='4' <?php echo $scan_data['critical_thinking']=='0'?"selected":""; ?> value="0">0</option>
												<option scan_val=1 scan_max='4' <?php echo $scan_data['critical_thinking']=='1'?"selected":""; ?> value="1">1</option>
												<option scan_val=2 scan_max='4' <?php echo $scan_data['critical_thinking']=='2'?"selected":""; ?> value="2">2</option>
												<option scan_val=3 scan_max='4' <?php echo $scan_data['critical_thinking']=='3'?"selected":""; ?> value="3">3</option>
												<option scan_val=4 scan_max='4' <?php echo $scan_data['critical_thinking']=='4'?"selected":""; ?> value="4">4</option>
											</select>
										</td>
										<td colspan="2"> <textarea class="form-control" disabled name="data[cmt7]"><?php echo $scan_data['cmt7'] ?></textarea></td>
									</tr>
									<tr>
										<td></td>
										<td colspan=1>Resolution</td>
										<td>4</td>
										<td>
											<select class="form-control scanVal" data-id="call_flow"  name="data[resolution]" disabled>
												<option scan_val=0 scan_max='4' <?php echo $scan_data['resolution']=='0'?"selected":""; ?> value="0">0</option>
												<option scan_val=1 scan_max='4' <?php echo $scan_data['resolution']=='1'?"selected":""; ?> value="1">1</option>
												<option scan_val=2 scan_max='4' <?php echo $scan_data['resolution']=='2'?"selected":""; ?> value="2">2</option>
												<option scan_val=3 scan_max='4' <?php echo $scan_data['resolution']=='3'?"selected":""; ?> value="3">3</option>
												<option scan_val=4 scan_max='4' <?php echo $scan_data['resolution']=='4'?"selected":""; ?> value="4">4</option>
											</select>
										</td>
										<td colspan="2"> <textarea class="form-control" disabled name="data[cmt8]"><?php echo $scan_data['cmt8'] ?></textarea></td>
									</tr>
									<tr>
										<td></td>
										<td colspan=1>Offer Additional Assistance</td>
										<td>4</td>
										<td>
											<select class="form-control scanVal" data-id="call_flow"  name="data[additional_assistance]" disabled>
												<option scan_val=0 scan_max='4' <?php echo $scan_data['additional_assistance']=='0'?"selected":""; ?> value="0">0</option>
												<option scan_val=1 scan_max='4' <?php echo $scan_data['additional_assistance']=='1'?"selected":""; ?> value="1">1</option>
												<option scan_val=2 scan_max='4' <?php echo $scan_data['additional_assistance']=='2'?"selected":""; ?> value="2">2</option>
												<option scan_val=3 scan_max='4' <?php echo $scan_data['additional_assistance']=='3'?"selected":""; ?> value="3">3</option>
												<option scan_val=4 scan_max='4' <?php echo $scan_data['additional_assistance']=='4'?"selected":""; ?> value="4">4</option>
											</select>
										</td>
										<td colspan="2"> <textarea class="form-control" disabled name="data[cmt9]"><?php echo $scan_data['cmt9'] ?></textarea></td>
									</tr>
									<tr>
										<td></td>
										<td colspan=1>Closing</td>
										<td>4</td>
										<td>
											<select class="form-control scanVal" data-id="call_flow"  name="data[closing]" disabled>
												<option scan_val=0 scan_max='4' <?php echo $scan_data['closing']=='0'?"selected":""; ?> value="0">0</option>
												<option scan_val=1 scan_max='4' <?php echo $scan_data['closing']=='1'?"selected":""; ?> value="1">1</option>
												<option scan_val=2 scan_max='4' <?php echo $scan_data['closing']=='2'?"selected":""; ?> value="2">2</option>
												<option scan_val=3 scan_max='4' <?php echo $scan_data['closing']=='3'?"selected":""; ?> value="3">3</option>
												<option scan_val=4 scan_max='4' <?php echo $scan_data['closing']=='4'?"selected":""; ?> value="4">4</option>
											</select>
										</td>
										<td colspan="2"> <textarea class="form-control" disabled name="data[cmt10]"><?php echo $scan_data['cmt10'] ?></textarea></td>
									</tr>
									<tr>
										<td></td>
										<td colspan=1>Proper Category, Sub Category</td>
										<td>4</td>
										<td>
											<select class="form-control scanVal" data-id="call_flow"  name="data[proper_category]" disabled>
												<option scan_val=0 scan_max='4' <?php echo $scan_data['proper_category']=='0'?"selected":""; ?> value="0">0</option>
												<option scan_val=1 scan_max='4' <?php echo $scan_data['proper_category']=='1'?"selected":""; ?> value="1">1</option>
												<option scan_val=2 scan_max='4' <?php echo $scan_data['proper_category']=='2'?"selected":""; ?> value="2">2</option>
												<option scan_val=3 scan_max='4' <?php echo $scan_data['proper_category']=='3'?"selected":""; ?> value="3">3</option>
												<option scan_val=4 scan_max='4' <?php echo $scan_data['proper_category']=='4'?"selected":""; ?> value="4">4</option>
											</select>
										</td>
										<td colspan="2"> <textarea class="form-control" disabled name="data[cmt11]"><?php echo $scan_data['cmt11'] ?></textarea></td>
									</tr>
									<tr>
										<td></td>
										<td colspan=1>Documentation</td>
										<td>4</td>
										<td>
											<select class="form-control scanVal" data-id="call_flow"  name="data[documentation]" disabled>
												<option scan_val=0 scan_max='4' <?php echo $scan_data['documentation']=='0'?"selected":""; ?> value="0">0</option>
												<option scan_val=1 scan_max='4' <?php echo $scan_data['documentation']=='1'?"selected":""; ?> value="1">1</option>
												<option scan_val=2 scan_max='4' <?php echo $scan_data['documentation']=='2'?"selected":""; ?> value="2">2</option>
												<option scan_val=3 scan_max='4' <?php echo $scan_data['documentation']=='3'?"selected":""; ?> value="3">3</option>
												<option scan_val=4 scan_max='4' <?php echo $scan_data['documentation']=='4'?"selected":""; ?> value="4">4</option>
											</select>
										</td>
										<td colspan="2"> <textarea class="form-control" disabled name="data[cmt12]"><?php echo $scan_data['cmt12'] ?></textarea></td>
									</tr>
									<tr>
										<td></td>
										<td colspan=1>Use of Technology and Resources</td>
										<td>4</td>
										<td>
											<select class="form-control scanVal" data-id="call_flow"  name="data[technology_resources]" disabled>
												<option scan_val=0 scan_max='4' <?php echo $scan_data['technology_resources']=='0'?"selected":""; ?> value="0">0</option>
												<option scan_val=1 scan_max='4' <?php echo $scan_data['technology_resources']=='1'?"selected":""; ?> value="1">1</option>
												<option scan_val=2 scan_max='4' <?php echo $scan_data['technology_resources']=='2'?"selected":""; ?> value="2">2</option>
												<option scan_val=3 scan_max='4' <?php echo $scan_data['technology_resources']=='3'?"selected":""; ?> value="3">3</option>
												<option scan_val=4 scan_max='4' <?php echo $scan_data['technology_resources']=='4'?"selected":""; ?> value="4">4</option>
											</select>
										</td>
										<td colspan="2"> <textarea class="form-control" disabled name="data[cmt13]"><?php echo $scan_data['cmt13'] ?></textarea></td>
									</tr>
									<tr>
										<td style="background-color:#BFC9CA"><b>3</b></td>
										<td colspan=1 style="background-color:#BFC9CA">MEMBER CENTRIC</td>
										<td style="background-color:#BFC9CA">20</td>
										<td style="background-color:#BFC9CA" id="score_member_centric"></td>
										<td colspan="2" style="background-color:#BFC9CA"></td>
									</tr>
									<tr>
										<td></td>
										<td colspan=1>Active Listening & Avoiding Interruption</td>
										<td>4</td>
										<td>
											<select class="form-control scanVal" data-id="member_centric"  name="data[active_listening]" disabled>
												<option scan_val=0 scan_max='4' <?php echo $scan_data['active_listening']=='0'?"selected":""; ?> value="0">0</option>
												<option scan_val=1 scan_max='4' <?php echo $scan_data['active_listening']=='1'?"selected":""; ?> value="1">1</option>
												<option scan_val=2 scan_max='4' <?php echo $scan_data['active_listening']=='2'?"selected":""; ?> value="2">2</option>
												<option scan_val=3 scan_max='4' <?php echo $scan_data['active_listening']=='3'?"selected":""; ?> value="3">3</option>
												<option scan_val=4 scan_max='4' <?php echo $scan_data['active_listening']=='4'?"selected":""; ?> value="4">4</option>
											</select>
										</td>
										<td colspan="2"> <textarea class="form-control" disabled name="data[cmt14]"><?php echo $scan_data['cmt14'] ?></textarea></td>
									</tr>
									<tr>
										<td></td>
										<td colspan=1>Courtesy & Emphaty</td>
										<td>4</td>
										<td>
											<select class="form-control scanVal" data-id="member_centric"  name="data[courtesy_emphaty]" disabled>
												<option scan_val=0 scan_max='4' <?php echo $scan_data['courtesy_emphaty']=='0'?"selected":""; ?> value="0">0</option>
												<option scan_val=1 scan_max='4' <?php echo $scan_data['courtesy_emphaty']=='1'?"selected":""; ?> value="1">1</option>
												<option scan_val=2 scan_max='4' <?php echo $scan_data['courtesy_emphaty']=='2'?"selected":""; ?> value="2">2</option>
												<option scan_val=3 scan_max='4' <?php echo $scan_data['courtesy_emphaty']=='3'?"selected":""; ?> value="3">3</option>
												<option scan_val=4 scan_max='4' <?php echo $scan_data['courtesy_emphaty']=='4'?"selected":""; ?> value="4">4</option>
											</select>
										</td>
										<td colspan="2"> <textarea class="form-control" disabled name="data[cmt15]"><?php echo $scan_data['cmt15'] ?></textarea></td>
									</tr>
									<tr>
										<td></td>
										<td colspan=1>Proffesional Language</td>
										<td>4</td>
										<td>
											<select class="form-control scanVal" data-id="member_centric"  name="data[proffesional_language]" disabled>
												<option scan_val=0 scan_max='4' <?php echo $scan_data['proffesional_language']=='0'?"selected":""; ?> value="0">0</option>
												<option scan_val=1 scan_max='4' <?php echo $scan_data['proffesional_language']=='1'?"selected":""; ?> value="1">1</option>
												<option scan_val=2 scan_max='4' <?php echo $scan_data['proffesional_language']=='2'?"selected":""; ?> value="2">2</option>
												<option scan_val=3 scan_max='4' <?php echo $scan_data['proffesional_language']=='3'?"selected":""; ?> value="3">3</option>
												<option scan_val=4 scan_max='4' <?php echo $scan_data['proffesional_language']=='4'?"selected":""; ?> value="4">4</option>
											</select>
										</td>
										<td colspan="2"> <textarea class="form-control" disabled name="data[cmt16]"><?php echo $scan_data['cmt16'] ?></textarea></td>
									</tr>
									<tr>
										<td></td>
										<td colspan=1>Hold Time and Dead Air</td>
										<td>4</td>
										<td>
											<select class="form-control scanVal" data-id="member_centric"  name="data[dead_air]" disabled>
												<option scan_val=0 scan_max='4' <?php echo $scan_data['dead_air']=='0'?"selected":""; ?> value="0">0</option>
												<option scan_val=1 scan_max='4' <?php echo $scan_data['dead_air']=='1'?"selected":""; ?> value="1">1</option>
												<option scan_val=2 scan_max='4' <?php echo $scan_data['dead_air']=='2'?"selected":""; ?> value="2">2</option>
												<option scan_val=3 scan_max='4' <?php echo $scan_data['dead_air']=='3'?"selected":""; ?> value="3">3</option>
												<option scan_val=4 scan_max='4' <?php echo $scan_data['dead_air']=='4'?"selected":""; ?> value="4">4</option>
											</select>
										</td>
										<td colspan="2"> <textarea class="form-control" disabled name="data[cmt17]"><?php echo $scan_data['cmt17'] ?></textarea></td>
									</tr>
									<tr>
										<td></td>
										<td colspan=1>Concierge: Own the Relationship & Make it Simple / SAL: Make it Simple</td>
										<td>4</td>
										<td>
											<select class="form-control scanVal" data-id="member_centric"  name="data[make_simple]" disabled>
												<option scan_val=0 scan_max='4' <?php echo $scan_data['make_simple']=='0'?"selected":""; ?> value="0">0</option>
												<option scan_val=1 scan_max='4' <?php echo $scan_data['make_simple']=='1'?"selected":""; ?> value="1">1</option>
												<option scan_val=2 scan_max='4' <?php echo $scan_data['make_simple']=='2'?"selected":""; ?> value="2">2</option>
												<option scan_val=3 scan_max='4' <?php echo $scan_data['make_simple']=='3'?"selected":""; ?> value="3">3</option>
												<option scan_val=4 scan_max='4' <?php echo $scan_data['make_simple']=='4'?"selected":""; ?> value="4">4</option>
											</select>
										</td>
										<td colspan="2"> <textarea class="form-control" disabled name="data[cmt18]"><?php echo $scan_data['cmt18'] ?></textarea></td>
									</tr>
									<tr>
										<td style="background-color:#BFC9CA"><b>4</b></td>
										<td colspan=1 style="background-color:#BFC9CA">BOOK OF BUSINESS</td>
										<td style="background-color:#BFC9CA">4</td>
										<td style="background-color:#BFC9CA" id="score_book_business"></td>
										<td colspan="2" style="background-color:#BFC9CA"></td>
									</tr>
									<tr>
										<td></td>
										<td colspan=1>Briefcase Management</td>
										<td>4</td>
										<td>
											<select class="form-control scanVal" data-id="book_business"  name="data[briefcase_management]" disabled>
												<option scan_val=0 scan_max='4' <?php echo $scan_data['briefcase_management']=='0'?"selected":""; ?> value="0">0</option>
												<option scan_val=1 scan_max='4' <?php echo $scan_data['briefcase_management']=='1'?"selected":""; ?> value="1">1</option>
												<option scan_val=2 scan_max='4' <?php echo $scan_data['briefcase_management']=='2'?"selected":""; ?> value="2">2</option>
												<option scan_val=3 scan_max='4' <?php echo $scan_data['briefcase_management']=='3'?"selected":""; ?> value="3">3</option>
												<option scan_val=4 scan_max='4' <?php echo $scan_data['briefcase_management']=='4'?"selected":""; ?> value="4">4</option>
											</select>
										</td>
										<td colspan="2"> <textarea class="form-control" disabled name="data[cmt19]"><?php echo $scan_data['cmt19'] ?></textarea></td>
									</tr>
									<tr>
										<td>Call Summary:</td>
										<td colspan=2><textarea class="form-control"  disabled name="data[call_summary]"><?php echo $scan_data['call_summary'] ?></textarea></td>
										<td>Feedback:</td>
										<td colspan=2><textarea class="form-control"  disabled name="data[feedback]"><?php echo $scan_data['feedback'] ?></textarea></td>
									</tr>
									
									<?php if($scan_data['attach_file']!=''){ ?>
									<tr oncontextmenu="return false;">
										<td colspan="2">Audio Files (Mp4/Mp3/M4a/Wav)</td>
										<td colspan="4">
											<?php $attach_file = explode(",",$scan_data['attach_file']);
											 foreach($attach_file as $af){ ?>
												<audio oncontextmenu="return false;" controls controlslist="nodownload" style="background-color:#607F93">
													  <source src="<?php echo base_url(); ?>qa_files/qa_scan/<?php echo $af; ?>" type="audio/ogg">
													  <source src="<?php echo base_url(); ?>qa_files/qa_scan/<?php echo $af; ?>" type="audio/mpeg">
												</audio> </br>
											 <?php } ?>
										</td>
									</tr>
									<?php } ?>

									<tr>
										<td style="font-size:12px">Manager Review:</td>
										<td colspan="8" style="text-align:left"><?php echo $scan_data['mgnt_rvw_note'] ?></td>
									</tr>
									<tr>
										<td style="font-size:12px">Client Review:</td>
										<td colspan="8" style="text-align:left"><?php echo $scan_data['client_rvw_note'] ?></td>
									</tr>

									<tr><td colspan="10" style="background-color:#C5C8C8"></td></tr>
									
									 <form id="form_agent_user" method="POST" action="">
										<input type="hidden" name="scan_id" class="form-control" value="<?php echo $scan_id; ?>">
										
										<tr>
											<td colspan=2 style="font-size:16px">Feedback Acceptance<span style="font-size:24px;color:red">*</span></td>
											<td colspan=6>
												<select class="form-control" id="" name="agnt_fd_acpt" required="">
													<option value="">--Select--</option>
													<option <?php echo $scan_data['agnt_fd_acpt']=='Acceptance'?"selected":""; ?> value="Acceptance">Acceptance</option>	
													<option <?php echo $scan_data['agnt_fd_acpt']=='Not Acceptance'?"selected":""; ?> value="Not Acceptance">Not Acceptance</option>	
												</select>
											</td>
										</tr>
										<tr>
											<td colspan=2 style="font-size:16px">Your Review<span style="font-size:24px;color:red">*</span></td>
											<td colspan=6><textarea class="form-control" name="note" required><?php echo $scan_data['agent_rvw_note'] ?></textarea></td>
										</tr>
										
										<?php if(is_access_qa_agent_module()==true){
										if(is_available_qa_feedback($scan_data['entry_date'],72) == true){ ?>
											<tr>
												<?php if($scan_data['agent_rvw_note']==''){ ?>
													<td colspan="10"><button class="btn btn-success waves-effect" type="submit" id='btnagentSave' name='btnSave' value="SAVE" style="width:500px;margin:auto;display:block;">SAVE</button></td>
												<?php } ?>
											</tr>
										<?php } 
										} ?>
									
									  </form>
									
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
