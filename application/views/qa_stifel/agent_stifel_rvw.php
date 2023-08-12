
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
	background-color:#85C1E9;
}

</style>


<div class="wrap">
	<section class="app-content">

	<?php if($campaign=='stifel'){ ?>
		<div class="row">
			<div class="col-12">
				<div class="widget">
				  <form id="form_audit_user" method="POST" action="" enctype="multipart/form-data">
					
					<div class="widget-body">
					 	<div class="table-responsive">
							<table class="table table-striped skt-table" width="100%">
								<tbody>
									<tr>
										<td colspan="9" id="theader" style="font-size:40px">Stifel Scorecard</td>
										<input type="hidden" name="audit_start_time" value="<?php echo CurrMySqlDate(); ?>">
									</tr>
									<?php
										
											$tl_id = $stifel['tl_id'];
											$tl_name = $stifel['tl_name'];
											if($stifel['entry_by']!=''){
												$auditorName = $stifel['auditor_name'];
											}else{
												$auditorName = $stifel['client_name'];
											}
											$auditDate = mysql2mmddyy($stifel['audit_date']);
											$clDate_val = mysqlDt2mmddyy($stifel['call_date']);
										
									?>
									<tr>
										<td style="width:130px;">Auditor Name:<span style="font-size:24px;color:red">*</span></td>
										<td colspan="2"><input type="text" class="form-control" value="<?php echo $auditorName; ?>" disabled></td>
										<td >Audit Date:<span style="font-size:24px;color:red">*</span></td>
										<td colspan="2"><input type="text" class="form-control" value="<?php echo $auditDate; ?>" disabled></td>
										<td style="width:100px;">Call Date:<span style="font-size:24px;color:red">*</span></td>
										<td colspan="2"><input type="text" class="form-control" id="call_date_time" name="call_date" value="<?php echo $clDate_val; ?>" disabled></td>
									</tr>
									<tr>
										<td style="width:130px;">Agent:<span style="font-size:24px;color:red">*</span></td>
										<td colspan="2">
											<select class="form-control" id="agent_id" name="data[agent_id]" disabled >
												<option value="<?php echo $stifel['agent_id'] ?>"><?php echo $stifel['fname']." ".$stifel['lname'] ?></option>
												<option value="">-Select-</option>
												<?php foreach($agentName as $row):  ?>
													<option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
												<?php endforeach; ?>
											</select>
										</td>
										<td >Fusion ID:<span style="font-size:24px;color:red">*</span></td>
										<td colspan="2"><input type="text" class="form-control" id="fusion_id" value="<?php echo $stifel['fusion_id'] ?>" readonly ></td>
										<td style="width:100px;">L1 Supervisor:<span style="font-size:24px;color:red">*</span></td>
										<td colspan="2">
											<input type="text" class="form-control" id="tl_names"  value="<?php echo $tl_name; ?>" readonly>
											<input type="hidden" class="form-control" id="tl_id" name="data[tl_id]" value="<?php echo $tl_id; ?>" disabled>
										</td>
									</tr>
									<tr>
										<td style="width:130px;">Call Duration:<span style="font-size:24px;color:red">*</span></td>
										<td colspan="2"><input type="text" class="form-control" id="call_duration" onkeydown="return false;" name="data[call_duration]" value="<?php echo $stifel['call_duration'] ?>" disabled></td>
										<td>Site/Location:<span style="font-size:24px;color:red">*</span></td>
										<td colspan="2"><input type="text" class="form-control" id="" name="data[site]" value="<?php echo $stifel['site'] ?>" disabled></td>
										<td style="width:100px;">File No:<span style="font-size:24px;color:red">*</span></td>
										<td colspan="2"><input type="text" class="form-control" id="file_no" name="data[file_no]" value="<?php echo $stifel['file_no'] ?>" disabled></td>
									</tr>
									<tr>
									
										<td>Audit Type:<span style="font-size:24px;color:red">*</span></td>
										<td colspan="2">
											<select class="form-control" id="audit_type" name="data[audit_type]" disabled>
												<option value="">-Select-</option>
												 <option value="CQ Audit" <?= ($stifel['audit_type']=="CQ Audit")?"selected":"" ?>>CQ Audit</option>
                                                    <option value="BQ Audit" <?= ($stifel['audit_type']=="BQ Audit")?"selected":"" ?>>BQ Audit</option>
                                                    <option value="Calibration" <?= ($stifel['audit_type']=="Calibration")?"selected":"" ?>>Calibration</option>
                                                    <option value="Pre-Certificate Mock Call" <?= ($stifel['audit_type']=="Pre-Certificate Mock Call")?"selected":"" ?>>Pre-Certificate Mock Call</option>
                                                    <option value="Certification Audit" <?= ($stifel['audit_type']=="Certification Audit")?"selected":"" ?>>Certification Audit</option>
                                                    <option value="WoW Call"  <?= ($stifel['audit_type']=="WoW Call")?"selected":"" ?>>WoW Call</option>
                                                    <option value="Hygiene Audit"  <?= ($stifel['audit_type']=="Hygiene Audit")?"selected":"" ?>>Hygiene Audit</option>
                                                    <option value="Operation Audit"  <?= ($stifel['audit_type']=="Operation Audit")?"selected":"" ?>>Operation Audit</option>
                                                    <option value="Trainer Audit"  <?= ($stifel['audit_type']=="Trainer Audit")?"selected":"" ?>>Trainer Audit</option> 
                                                    <option value="QA Supervisor Audit"  <?= ($stifel['audit_type']=="QA Supervisor Audit")?"selected":"" ?>>QA Supervisor Audit</option> 
											</select>
										</td>
										<td class="auType" style="width: 100px;">Auditor Type<span style="font-size:24px;color:red">*</span></td>
										<td class="auType">
											<select class="form-control" id="auditor_type" name="data[auditor_type]">
												<option value="">-Select-</option>
												<option value="Master">Master</option>
												<option value="Regular">Regular</option>
											</select>
										</td>
										<td>VOC:<span style="font-size:24px;color:red">*</span></td>
										<td colspan="2">
											<select class="form-control" id="voc" name="data[voc]" disabled>
												<option value="">-Select-</option>
												<option <?php echo $stifel['voc']=='1'?"selected":""; ?> value="1">1</option>
												<option <?php echo $stifel['voc']=='2'?"selected":""; ?> value="2">2</option>
												<option <?php echo $stifel['voc']=='3'?"selected":""; ?> value="3">3</option>
												<option <?php echo $stifel['voc']=='4'?"selected":""; ?> value="4">4</option>
												<option <?php echo $stifel['voc']=='5'?"selected":""; ?> value="5">5</option>
												<option <?php echo $stifel['voc']=='6'?"selected":""; ?> value="6">6</option>
												<option <?php echo $stifel['voc']=='7'?"selected":""; ?> value="7">7</option>
												<option <?php echo $stifel['voc']=='8'?"selected":""; ?> value="8">8</option>
												<option <?php echo $stifel['voc']=='9'?"selected":""; ?> value="9">9</option>
												<option <?php echo $stifel['voc']=='10'?"selected":""; ?> value="10">10</option>
											</select>
										</td>
									</tr>
									<tr>
										<td style="font-weight:bold; font-size:16px; text-align:right">Earned Score:</td>
										<td colspan="2"><input type="text" value="<?= $stifel['earned_score']?>" readonly id="jurys_inn_earned_score" name="data[earned_score]" class="form-control" style="font-weight:bold"></td>
										<td style="font-weight:bold; font-size:16px; text-align:right">Possible Score:</td>
										<td colspan="2"><input type="text" value="<?= $stifel['possible_score']?>" readonly id="jurys_inn_possible_score" name="data[possible_score]" class="form-control" style="font-weight:bold"></td>
										<td style="font-weight:bold; font-size:16px; text-align:right">Overall Score:</td>
										<td colspan="2"><input type="text" readonly id="jurys_inn_overall_score" name="data[overall_score]" class="form-control stifel_fatal" style="font-weight:bold" value="<?php echo $stifel['overall_score'] ?>"></td>
									</tr>
									<tr style="height:25px; font-weight:bold; background-color:#D2B4DE">
										<td>PARAMETER</td>
										<td colspan=2>SUB PARAMETER</td>
										<td>Weightage</td>
										<td>STATUS</td>
										<td colspan=2>REMARKS</td>
										<td>Critical Error</td>
									</tr>
									<tr>
										<td class="eml" rowspan=2>Greeting and Farewell</td>
										<td colspan=2 style="color:red">Opening</td>
										<td>5</td>
										<td>
											<select class="form-control jurry_points customer" id="stifel_AF7" name="data[opening]" disabled>
												<!-- <option value="">-Select-</option> -->
												<option ji_val=5 <?php echo $stifel['opening'] == "Pass"?"selected":"";?> value="Pass">Pass</option>
												<option ji_val=5 <?php echo $stifel['opening'] == "Fail"?"selected":"";?> value="Fail">Fail</option>
											</select> 
										</td>
										<td colspan=2><input type="text" name="data[cmt1]" class="form-control" disabled value="<?php echo $stifel['cmt1'] ?>"></td>
										<td>Customer Critical</td>
									</tr>
									<tr>
										<td colspan=2 style="color:red">Closing</td>
										<td>5</td>
										<td>
											<select class="form-control jurry_points customer"  id="stifel_AF8" name="data[closing]" disabled>
												<!-- <option value="">-Select-</option> -->
												<option ji_val=5 <?php echo $stifel['closing'] == "Pass"?"selected":"";?> value="Pass">Pass</option>
												<option ji_val=5 <?php echo $stifel['closing'] == "Fail"?"selected":"";?> value="Fail">Fail</option>
											</select> 
										</td>
										<td colspan=2><input type="text" name="data[cmt3]" class="form-control" disabled value="<?php echo $stifel['cmt3'] ?>"></td>
										<td>Customer Critical</td>
									</tr>
									<tr>
										<td class="eml" rowspan=2>Ownership</td>
										<td colspan=2>Needs to offer to stay on the call until the issue has been resolved</td>
										<td>10</td>
										<td>
											<select class="form-control jurry_points customer" name="data[stay_on_call]" disabled>
												<!-- <option value="">-Select-</option> -->
												<option ji_val=10 <?php echo $stifel['stay_on_call'] == "Pass"?"selected":"";?> value="Pass">Pass</option>
												<option ji_val=10 <?php echo $stifel['stay_on_call'] == "Fail"?"selected":"";?> value="Fail">Fail</option>
												<option ji_val=10 <?php echo $stifel['stay_on_call'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
										<td colspan=2><input type="text" name="data[cmt4]" class="form-control" disabled value="<?php echo $stifel['cmt4'] ?>"></td>
										<td>Customer Critical</td>
									</tr>
									<tr>
										<td colspan=2>Ownership / Assurance</td>
										<td>10</td>
										<td>
											<select class="form-control jurry_points customer" name="data[owenship_assurance]" disabled>
												<!-- <option value="">-Select-</option> -->
												<option ji_val=10 <?php echo $stifel['owenship_assurance'] == "Pass"?"selected":"";?> value="Pass">Pass</option>
												<option ji_val=10 <?php echo $stifel['owenship_assurance'] == "Fail"?"selected":"";?> value="Fail">Fail</option>
												<option ji_val=10 <?php echo $stifel['owenship_assurance'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
										<td colspan=2><input type="text" name="data[cmt5]" class="form-control" disabled value="<?php echo $stifel['cmt5'] ?>"></td>
										<td>Customer Critical</td>
									</tr>
									<tr>
										<td class="eml" rowspan=2>Hold and Escalation Protocol</td>
										<td colspan=2>Call Control</td>
										<td>10</td>
										<td>
											<select class="form-control jurry_points customer" name="data[hold_protocol]" disabled>
												<!-- <option value="">-Select-</option> -->
												<option ji_val=10 <?php echo $stifel['hold_protocol'] == "Pass"?"selected":"";?> value="Pass">Pass</option>
												<option ji_val=10 <?php echo $stifel['hold_protocol'] == "Fail"?"selected":"";?> value="Fail">Fail</option>
												<option ji_val=10 <?php echo $stifel['hold_protocol'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
										<td colspan=2><input type="text" name="data[cmt6]" class="form-control" disabled value="<?php echo $stifel['cmt6'] ?>"></td>
										<td>Customer Critical</td>
									</tr>
									<tr>
										<td colspan=2>Transfer</td>
										<td>10</td>
										<td>
											<select class="form-control jurry_points business" name="data[transfer]" disabled>
												<!-- <option value="">-Select-</option> -->
												<option ji_val=10 <?php echo $stifel['transfer'] == "Pass"?"selected":"";?> value="Pass">Pass</option>
												<option ji_val=10 <?php echo $stifel['transfer'] == "Fail"?"selected":"";?> value="Fail">Fail</option>
												<option ji_val=10 <?php echo $stifel['transfer'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
										<td colspan=2><input type="text" name="data[cmt7]" class="form-control" disabled value="<?php echo $stifel['cmt7'] ?>"></td>
										<td>Business Critical</td>
									</tr>
									<tr>
										<td class="eml" rowspan=3>Effective Communication</td>
										<td colspan=2 style="color:red">Tone / Rate Of Speech / Fumbling/Pacing</td>
										<td>10</td>
										<td>
											<select class="form-control jurry_points customer"  id="stifel_AF10" name="data[rate_of_speech]" disabled>
												<!-- <option value="">-Select-</option> -->
												<option ji_val=10 <?php echo $stifel['rate_of_speech'] == "Pass"?"selected":"";?> value="Pass">Pass</option>
												<option ji_val=10 <?php echo $stifel['rate_of_speech'] == "Fail"?"selected":"";?> value="Fail">Fail</option>
											</select> 
										</td>
										<td colspan=2><input type="text" name="data[cmt8]" class="form-control" disabled value="<?php echo $stifel['cmt8'] ?>"></td>
										<td>Customer Critical</td>
									</tr>
									<tr>
										<td colspan=2 style="color:red">Active Listening</td>
										<td>10</td>
										<td>
											<select class="form-control jurry_points customer"  id="stifel_AF11" name="data[active_listening]" disabled>
												<!-- <option value="">-Select-</option> -->
												<option ji_val=10 <?php echo $stifel['active_listening'] == "Pass"?"selected":"";?> value="Pass">Pass</option>
												<option ji_val=10 <?php echo $stifel['active_listening'] == "Fail"?"selected":"";?> value="Fail">Fail</option>
											</select> 
										</td>
										<td colspan=2><input type="text" name="data[cmt9]" class="form-control" disabled value="<?php echo $stifel['cmt9'] ?>"></td>
										<td>Customer Critical</td>
									</tr>
									<tr>
										<td colspan=2 style="color:red">Professionalism</td>
										<td>10</td>
										<td>
											<select class="form-control jurry_points customer" id="stifel_AF12"  name="data[parallel_conversion]" disabled>
												<!-- <option value="">-Select-</option> -->
												<option ji_val=10 <?php echo $stifel['parallel_conversion'] == "Pass"?"selected":"";?> value="Pass">Pass</option>
												<option ji_val=10 <?php echo $stifel['parallel_conversion'] == "Fail"?"selected":"";?> value="Fail">Fail</option>
											</select> 
										</td>
										<td colspan=2><input type="text" name="data[cmt10]" class="form-control" disabled value="<?php echo $stifel['cmt10'] ?>"></td>
										<td>Customer Critical</td>
									</tr>
									<tr>
										<td class="eml" rowspan=2>Resolution</td>
										<td colspan=2 style="color:red">Issue Identification / Understanding</td>
										<td>2</td>
										<td>
											<select class="form-control jurry_points business" id="stifel_AF1" name="data[issue_identification]" disabled>
												<!-- <option value="">-Select-</option> -->
												<option ji_val=2 <?php echo $stifel['issue_identification'] == "Pass"?"selected":"";?> value="Pass">Pass</option>
												<option ji_val=2 <?php echo $stifel['issue_identification'] == "Fail"?"selected":"";?> value="Fail">Fail</option>
											</select> 
										</td>
										<td colspan=2><input type="text" name="data[cmt11]" class="form-control" disabled value="<?php echo $stifel['cmt11'] ?>"></td>
										<td>Business Critical</td>
									</tr>
									<tr>
										<td colspan=2 style="color:red">False Commitment(Correct and Accurate Information)</td>
										<td>3</td>
										<td>
											<select class="form-control jurry_points business" id="stifel_AF2" name="data[false_commitment]" disabled>
												<!-- <option value="">-Select-</option> -->
												<option ji_val=3 <?php echo $stifel['false_commitment'] == "Pass"?"selected":"";?> value="Pass">Pass</option>
												<option ji_val=3 <?php echo $stifel['false_commitment'] == "Fail"?"selected":"";?> value="Fail">Fail</option>
											</select> 
										</td>
										<td colspan=2><input type="text" name="data[cmt13]" class="form-control" disabled value="<?php echo $stifel['cmt13'] ?>"></td>
										<td>Business Critical</td>
									</tr>
									<tr>
										<td class="eml">Verification</td>
										<td colspan=2 style="color:red">Verification</td>
										<td>3</td>
										<td>
											<select class="form-control jurry_points compliance1" id="stifel_AF3" name="data[verification_process_follow]" disabled>
												<!-- <option value="">-Select-</option> -->
												<option ji_val=3 <?php echo $stifel['verification_process_follow'] == "Pass"?"selected":"";?> value="Pass">Pass</option>
												<option ji_val=3 <?php echo $stifel['verification_process_follow'] == "Fail"?"selected":"";?> value="Fail">Fail</option>
											</select> 
										</td>
										<td colspan=2><input type="text" name="data[cmt14]" class="form-control" disabled value="<?php echo $stifel['cmt14'] ?>"></td>
										<td>Compliance Critical</td>
									</tr>
									<tr>
										<td class="eml" rowspan=2 >ZTP</td>
										<td colspan=2 style="color:red">Rudeness</td>
										<td>2</td>
										<td>
											<select class="form-control jurry_points customer" id="stifel_AF5" name="data[rudeness]" disabled>
												<!-- <option value="">-Select-</option> -->
												<option ji_val=2 <?php echo $stifel['rudeness'] == "Pass"?"selected":"";?> value="Pass">Pass</option>
												<option ji_val=2 <?php echo $stifel['rudeness'] == "Fail"?"selected":"";?> value="Fail">Fail</option>
											</select> 
										</td>
										<td colspan=2><input type="text" name="data[cmt15]" class="form-control" disabled value="<?php echo $stifel['cmt15'] ?>"></td>
										<td>Customer Critical</td>
									</tr>
									<tr>
										<td colspan=2 style="color:red">Call Avoidance</td>
										<td>2</td>
										<td>
											<select class="form-control jurry_points customer" id="stifel_AF6" name="data[call_avoidance]" disabled>
												<!-- <option value="">-Select-</option> -->
												<option ji_val=2 <?php echo $stifel['call_avoidance'] == "Pass"?"selected":"";?> value="Pass">Pass</option>
												<option ji_val=2 <?php echo $stifel['call_avoidance'] == "Fail"?"selected":"";?> value="Fail">Fail</option>
											</select> 
										</td>
										<td colspan=2><input type="text" name="data[cmt16]" class="form-control" disabled value="<?php echo $stifel['cmt16'] ?>"></td>
										<td>Customer Critical</td>
									</tr>
									<tr>
										<td class="eml" rowspan=1 >Empathy</td>
										<td colspan=2 style="color:red">Empathy / Apology</td>
										<td>8</td>
										<td>
											<select class="form-control jurry_points customer" id="stifel_AF9" name="data[empathy]" disabled>
												<!-- <option value="">-Select-</option> -->
												<option ji_val=8 <?php echo $stifel['empathy'] == "Pass"?"selected":"";?> value="Pass">Pass</option>
												<option ji_val=8 <?php echo $stifel['empathy'] == "Fail"?"selected":"";?> value="Fail">Fail</option>
											</select> 
										</td>
										<td colspan=2><input type="text" name="data[cmt17]" class="form-control" disabled value="<?php echo $stifel['cmt17'] ?>"></td>
										<td>Customer Critical</td>
									</tr>
									<tr style="background-color:#D2B4DE"><td colspan="3">Customer Score</td><td colspan="3">Business Score</td><td colspan="3">Compliance Score</td></tr>
									<tr style="background-color:#D2B4DE">
										<td>Earned:</td><td id="custJiCisEarned" colspan="2"></td><td>Earned:</td><td id="busiJiCisEarned" colspan="2"></td><td>Earned:</td><td id="complJiCisEarned" colspan="2"></td>
									</tr>
									<tr style="background-color:#D2B4DE">
										<td>Possible:</td><td id="custJiCisPossible" colspan="2"></td><td>Possible:</td><td id="busiJiCisPossible" colspan="2"></td><td>Possible:</td><td id="complJiCisPossible" colspan="2"></td>
									</tr>
									<tr style="background-color:#D2B4DE">
										<td>Percentage:</td><td colspan="2"><input type="text" readonly style="background-color:#D2B4DE; text-align:center" class="form-control" id="custJiCisScore" name="data[customer_score]" value="<?php echo $stifel['customer_score'] ?>"></td>
										<td>Percentage:</td><td colspan="2"><input type="text" readonly style="background-color:#D2B4DE; text-align:center" class="form-control" id="busiJiCisScore" name="data[business_score]" value="<?php echo $stifel['business_score'] ?>"></td>
										<td>Percentage:</td><td colspan="2"><input type="text" readonly style="background-color:#D2B4DE; text-align:center" class="form-control" id="complJiCisScore" name="data[compliance_score]" value="<?php echo $stifel['compliance_score'] ?>"></td>
									</tr>
									<tr>
										<td>Call Summary:</td>
										<td colspan="3"><textarea class="form-control" name="data[call_summary]"><?php echo $stifel['call_summary'] ?></textarea></td>
										<td>Feedback:</td>
										<td colspan="3"><textarea class="form-control" name="data[feedback]"><?php echo $stifel['feedback'] ?></textarea></td>
									</tr>
									<?php if($stifel['attach_file']!=''){ ?>
									<tr oncontextmenu="return false;">
										<td colspan="2">Audio Files (Mp4/Mp3/M4a/Wav)</td>
										<td colspan="4">
											<?php $attach_file = explode(",",$stifel['attach_file']);
											 foreach($attach_file as $af){ ?>
												<audio oncontextmenu="return false;" controls controlslist="nodownload" style="background-color:#607F93">
													  <source src="<?php echo base_url(); ?>qa_files/qa_stifel/<?php echo $af; ?>" type="audio/ogg">
													  <source src="<?php echo base_url(); ?>qa_files/qa_stifel/<?php echo $af; ?>" type="audio/mpeg">
												</audio> </br>
											 <?php } ?>
										</td>
									</tr>
									<?php } ?>

									<tr>
										<td style="font-size:12px">Manager Review:</td>
										<td colspan="8" style="text-align:left"><?php echo $stifel['mgnt_rvw_note'] ?></td>
									</tr>
									<tr>
										<td style="font-size:12px">Client Review:</td>
										<td colspan="8" style="text-align:left"><?php echo $stifel['client_rvw_note'] ?></td>
									</tr>

									<tr><td colspan="10" style="background-color:#C5C8C8"></td></tr>
									
									 <form id="form_agent_user" method="POST" action="">
										<input type="hidden" name="pnid" class="form-control" value="<?php echo $pnid; ?>">
										
										<tr>
											<td colspan=2 style="font-size:16px">Feedback Acceptance<span style="font-size:24px;color:red">*</span></td>
											<td colspan=6>
												<select class="form-control" id="" name="agnt_fd_acpt" required="">
													<option value="">--Select--</option>
													<option <?php echo $stifel['agnt_fd_acpt']=='Acceptance'?"selected":""; ?> value="Acceptance">Acceptance</option>	
													<option <?php echo $stifel['agnt_fd_acpt']=='Not Acceptance'?"selected":""; ?> value="Not Acceptance">Not Acceptance</option>	
												</select>
											</td>
										</tr>
										<tr>
											<td colspan=2 style="font-size:16px">Your Review<span style="font-size:24px;color:red">*</span></td>
											<td colspan=6><textarea class="form-control" name="note" required><?php echo $stifel['agent_rvw_note'] ?></textarea></td>
										</tr>
										
										<?php if(is_access_qa_agent_module()==true){
										if(is_available_qa_feedback($stifel['entry_date'],72) == true){ ?>
											<tr>
												<?php if($stifel['agent_rvw_note']==''){ ?>
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
	<?php } ?>

	<?php if($campaign=='stifel_v1'){ ?>
		<div class="row">
			<div class="col-12">
				<div class="widget">

				  <form id="form_audit_user" method="POST" action="" enctype="multipart/form-data">
					
					<div class="widget-body">
					 	<div class="table-responsive">
							<table class="table table-striped skt-table" width="100%">
								<tbody>
									<tr style="background-color:#AEB6BF">
										<td colspan="6" id="theader">Stifel Banking Agent Form  </td>
										<input type="hidden" name="audit_start_time" value="<?php echo CurrMySqlDate(); ?>">
									</tr>
									<tr>

									<?php
										$rand_id  = 0;
										if ($stifel['entry_by'] != '') {
											$auditorName = $stifel['auditor_name'];
										} else {
											$auditorName = $stifel['client_name'];
										}
										$clDate_val = mysql2mmddyySls($stifel['call_date']);
										$auditDate = mysql2mmddyySls($stifel['audit_date']);
										
										if ($rand_id != 0) {
											$agent_id = $rand_data['sid'];
											$fusion_id = $rand_data['fusion_id'];
											$agent_name = $rand_data['fname'] . " " . $rand_data['lname'];
											$tl_id = $rand_data['assigned_to'];
											$tl_name = $rand_data['tl_name'];
											$call_duration = $rand_data['call_duration'];
											
										} else {
											$agent_id = $stifel['agent_id'];
											$fusion_id = $stifel['fusion_id'];
											$agent_name = $stifel['fname'] . " " . $stifel['lname'] ;
											$tl_id = $stifel['tl_id'];
											$tl_name = $stifel['tl_name'];
											$call_duration = $stifel['call_duration'];
										}
										?>
										<td>QA Name:<span style="font-size:24px;color:red">*</span></td>
										<td style="width:300px"><input type="text" class="form-control" value="<?php echo $auditorName; ?>" disabled></td>
										<td style="width:150px">Audit Date:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control" value="<?php echo $auditDate; ?>" disabled></td>
										<td>Call Date:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control" id="call_date" name="call_date" value="<?php echo $clDate_val; ?>" disabled></td>
									</tr>
									<tr>
										<td>Employee Name:<span style="font-size:24px;color:red">*</span></td>
										<td>
											<select class="form-control" id="agent_id" name="data[agent_id]" disabled>
												<option value="<?php echo $stifel['agent_id'] ?>"><?php echo $agent_name; ?></option>
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
												<input type="hidden" class="form-control" id="tl_id" name="data[tl_id]" value="<?php echo $tl_id; ?>" disabled>
										</td>
									</tr>
									<tr>
										<td>Call Duration:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control" id="call_duration" onkeydown="return false;" name="data[call_duration]" value="<?php echo $call_duration; ?>" disabled></td>
										<td>Call Link:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control"  name="data[call_link]" value="<?php echo $stifel['call_link']; ?>" disabled></td>
										<td>Account:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control"  onkeyup="checkDecConsumer(this);" name="data[account]" value="<?php echo $stifel['account']; ?>" disabled></td>
									</tr>
			
									<tr>
										<td>KPI - ACPT:<span style="font-size:24px;color:red">*</span></td>
										<td>
												<select class="form-control" id="KPI_ACPT" name="data[KPI_ACPT]" disabled>
													<option value="">-Select-</option>
													<option value="Agent"  <?= ($stifel['KPI_ACPT']=="Agent")?"selected":"" ?>>Agent</option>
													<option value="Process"  <?= ($stifel['KPI_ACPT']=="Process")?"selected":"" ?>>Process</option>
													<option value="Customer"  <?= ($stifel['KPI_ACPT']=="Customer")?"selected":"" ?>>Customer</option>
													<option value="Technology"  <?= ($stifel['KPI_ACPT']=="Technology")?"selected":"" ?>>Technology</option>
													<option value="NA"  <?= ($stifel['KPI_ACPT']=="NA")?"selected":"" ?>>NA</option>
												</select>
											</td>
										<td>VOC:<span style="font-size:24px;color:red">*</span></td>
										<td>
											<select class="form-control" id="voc" name="data[voc]" disabled>
												<option value="">-Select-</option>
												<option <?php echo $stifel['voc']=='1'?"selected":""; ?> value="1">1</option>
												<option <?php echo $stifel['voc']=='2'?"selected":""; ?> value="2">2</option>
												<option <?php echo $stifel['voc']=='3'?"selected":""; ?> value="3">3</option>
												<option <?php echo $stifel['voc']=='4'?"selected":""; ?> value="4">4</option>
												<option <?php echo $stifel['voc']=='5'?"selected":""; ?> value="5">5</option>
												<option value="6"  <?= ($stifel['voc']=="6")?"selected":"" ?>>6</option>
												<option value="7"  <?= ($stifel['voc']=="7")?"selected":"" ?>>7</option>
												<option value="8"  <?= ($stifel['voc']=="8")?"selected":"" ?>>8</option>
												<option value="9"  <?= ($stifel['voc']=="9")?"selected":"" ?>>9</option>
												<option value="10"  <?= ($stifel['voc']=="10")?"selected":"" ?>>10</option>
											</select>
										</td>
										<td>Audit Type:<span style="font-size:24px;color:red">*</span></td>
										<td>
											<select class="form-control" id="audit_type" name="data[audit_type]" disabled>
                                                    <option value="">-Select-</option>
                                                    <option value="CQ Audit" <?= ($stifel['audit_type']=="CQ Audit")?"selected":"" ?>>CQ Audit</option>
                                                    <option value="BQ Audit" <?= ($stifel['audit_type']=="BQ Audit")?"selected":"" ?>>BQ Audit</option>
                                                    <option value="Calibration" <?= ($stifel['audit_type']=="Calibration")?"selected":"" ?>>Calibration</option>
                                                    <option value="Pre-Certificate Mock Call" <?= ($stifel['audit_type']=="Pre-Certificate Mock Call")?"selected":"" ?>>Pre-Certificate Mock Call</option>
                                                    <option value="Certification Audit" <?= ($stifel['audit_type']=="Certification Audit")?"selected":"" ?>>Certification Audit</option>
                                                    <option value="WoW Call"  <?= ($stifel['audit_type']=="WoW Call")?"selected":"" ?>>WoW Call</option>
                                                    <option value="Hygiene Audit"  <?= ($stifel['audit_type']=="Hygiene Audit")?"selected":"" ?>>Hygiene Audit</option>
                                                    <option value="Operation Audit"  <?= ($stifel['audit_type']=="Operation Audit")?"selected":"" ?>>Operation Audit</option>
                                                    <option value="Trainer Audit"  <?= ($stifel['audit_type']=="Trainer Audit")?"selected":"" ?>>Trainer Audit</option> 
                                                    <option value="QA Supervisor Audit"  <?= ($stifel['audit_type']=="QA Supervisor Audit")?"selected":"" ?>>QA Supervisor Audit</option> 
                                                </select>
										</td>
									</tr>
									<tr>
										<td class="auType">Auditor Type<span style="font-size:24px;color:red">*</span></td>
										<td class="auType">
											<select class="form-control" id="auditor_type" name="data[auditor_type]">
												<option value="">-Select-</option>
												<option value="Master" <?= ($stifel['auditor_type']=="Master")?"selected":"" ?>>Master</option> 
												 <option value="Regular" <?= ($stifel['auditor_type']=="Regular")?"selected":"" ?>>Regular</option> 
											</select>
										</td>
									</tr>
									<tr>
										<td style="font-weight:bold">Earned Score:</td>
										<td><input type="text" readonly id="stifel_v2Earned" name="data[earned_score]" class="form-control" style="font-weight:bold" value="<?php echo $stifel['overall_score'] ?>"></td>
										<td style="font-weight:bold">Possible Score:</td>
										<td><input type="text" readonly id="stifel_v2Possible" name="data[possible_score]" class="form-control" style="font-weight:bold" value="<?php echo $stifel['overall_score'] ?>"></td>
										<td style="font-weight:bold">Overall Score Percentage:</td>
										<td><input type="text" readonly id="stifel_v2OverallScore" name="data[overall_score]" class="form-control stifel_v2_Fatal" style="font-weight:bold" value="<?php echo $stifel['overall_score'] ?>"></td>
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
											<select class="form-control stifelVal_v2" data-id="greeting_opening" name="data[greeting_opening]" disabled>
												<option stifel_v2_val=5 stifel_v2_max="5" <?php echo $stifel['greeting_opening']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option stifel_v2_val=0 stifel_v2_max="5" <?php echo $stifel['greeting_opening']=='No'?"selected":""; ?> value="No">No</option>
												<option stifel_v2_val=5 stifel_v2_max="5" <?php echo $stifel['greeting_opening']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td><input type="text" name="data[comm1]" class="form-control" disabled value="<?php echo $stifel['comm1'] ?>"></td>
									</tr>
									<tr>
										<td></td>
										<td colspan=2>Closing : Did the agent offer further assistance before closing the call and closed the call using the appropriate branding?</td>
										<td>5</td>
										<td>
											<select class="form-control stifelVal_v2" data-id="greeting_closing" name="data[greeting_closing]" disabled>
												<option stifel_v2_val=5 stifel_v2_max="5" <?php echo $stifel['greeting_closing']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option stifel_v2_val=0 stifel_v2_max="5" <?php echo $stifel['greeting_closing']=='No'?"selected":""; ?> value="No">No</option>
												<option stifel_v2_val=5 stifel_v2_max="5" <?php echo $stifel['greeting_closing']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td><input type="text" name="data[comm2]" class="form-control" disabled value="<?php echo $stifel['comm2'] ?>"></td>
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
											<select class="form-control stifelVal_v2" data-id="ownership_assurance" name="data[ownership_assurance]" disabled>
												<option stifel_v2_val=5 stifel_v2_max="5" <?php echo $stifel['ownership_assurance']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option stifel_v2_val=0 stifel_v2_max="5" <?php echo $stifel['ownership_assurance']=='No'?"selected":""; ?> value="No">No</option>
												<option stifel_v2_val=5 stifel_v2_max="5" <?php echo $stifel['ownership_assurance']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td><input type="text" name="data[comm3]" class="form-control" disabled value="<?php echo $stifel['comm3'] ?>"></td>
									</tr>
									<tr>
										<td></td>
										<td colspan=2>Did the agent offer to stay on the call until the issue has been resolved?</td>
										<td>5</td>
										<td>
											<select class="form-control stifelVal_v2" data-id="issue_resolved" name="data[issue_resolved]" disabled>
												<option stifel_v2_val=5 stifel_v2_max="5" <?php echo $stifel['issue_resolved']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option stifel_v2_val=0 stifel_v2_max="5" <?php echo $stifel['issue_resolved']=='No'?"selected":""; ?> value="No">No</option>
												<option stifel_v2_val=5 stifel_v2_max="5" <?php echo $stifel['issue_resolved']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td><input type="text" name="data[comm4]" class="form-control" disabled value="<?php echo $stifel['comm4'] ?>"></td>
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
											<select class="form-control stifelVal_v2" id="stifel_v2_Fatal1" name="data[verification]" disabled>
												<option stifel_v2_val=10 stifel_v2_max="10" <?php echo $stifel['verification']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option stifel_v2_val=0 stifel_v2_max="10" <?php echo $stifel['verification']=='No'?"selected":""; ?> value="No">No</option>
											</select>
										</td>
										<td><input type="text" name="data[comm5]" class="form-control" disabled value="<?php echo $stifel['comm5'] ?>"></td>
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
											<select class="form-control stifelVal_v2" id="stifel_v2_Fatal2" name="data[issue_identification]" disabled>
												<option stifel_v2_val=13 stifel_v2_max="13" <?php echo $stifel['issue_identification']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option stifel_v2_val=0 stifel_v2_max="13"  <?php echo $stifel['issue_identification']=='No'?"selected":""; ?> value="No">No</option>
											</select>
										</td>
										<td><input type="text" name="data[comm6]" class="form-control" disabled value="<?php echo $stifel['comm6'] ?>"></td>
									</tr>
									<tr>
										<td></td>
										<td colspan=2 style="color:red;">Correct & Accurate Information : Did the agent deliver the correct and accurate information and resolution to the customer?</td>
										<td>12</td>
										<td>
											<select class="form-control stifelVal_v2" id="stifel_v2_Fatal3" name="data[accurate_information]" disabled>
												<option stifel_v2_val=12 stifel_v2_max="12" <?php echo $stifel['accurate_information']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option stifel_v2_val=0 stifel_v2_max="12" <?php echo $stifel['accurate_information']=='No'?"selected":""; ?> value="No">No</option>
											</select>
										</td>
										<td><input type="text" name="data[comm7]" class="form-control" disabled value="<?php echo $stifel['comm7'] ?>"></td>
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
											<select class="form-control stifelVal_v2" data-id="dead_air" name="data[dead_air]" disabled>
												<option stifel_v2_val=5 stifel_v2_max="5" <?php echo $stifel['dead_air']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option stifel_v2_val=0 stifel_v2_max="5" <?php echo $stifel['dead_air']=='No'?"selected":""; ?> value="No">No</option>
												<option stifel_v2_val=5 stifel_v2_max="5" <?php echo $stifel['dead_air']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td><input type="text" name="data[comm8]" class="form-control" disabled value="<?php echo $stifel['comm8'] ?>"></td>
									</tr>
									<tr>
										<td></td>
										<td colspan=2>Transfer : Did the agent properly transfer call if disabled? / The agent is not require to stay on the call once it was transferred not unless the customer request it </td>
										<td>5</td>
										<td>
											<select class="form-control stifelVal_v2" data-id="transfer_call" name="data[transfer_call]" disabled>
												<option stifel_v2_val=5 stifel_v2_max="5" <?php echo $stifel['transfer_call']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option stifel_v2_val=0 stifel_v2_max="5" <?php echo $stifel['transfer_call']=='No'?"selected":""; ?> value="No">No</option>
												<option stifel_v2_val=5 stifel_v2_max="5" <?php echo $stifel['transfer_call']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td><input type="text" name="data[comm9]" class="form-control" disabled value="<?php echo $stifel['comm9'] ?>"></td>
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
											<select class="form-control stifelVal_v2" id="stifel_v2_Fatal4" name="data[rudeness]" disabled>
												<option stifel_v2_val=3 stifel_v2_max="3" <?php echo $stifel['rudeness']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option stifel_v2_val=0 stifel_v2_max="3" <?php echo $stifel['rudeness']=='No'?"selected":""; ?> value="No">No</option>
											</select>
										</td>
										<td><input type="text" name="data[comm10]" class="form-control" disabled value="<?php echo $stifel['comm10'] ?>"></td>
									</tr>
									<tr>
										<td></td>
										<td colspan=2 style="color:red;">Call Avoidance : Did the agent try to avoid the call?</td>
										<td>2</td>
										<td>
											<select class="form-control stifelVal_v2" id="stifel_v2_Fatal5" name="data[call_avoidance]" disabled>
												<option stifel_v2_val=2 stifel_v2_max="2" <?php echo $stifel['call_avoidance']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option stifel_v2_val=0 stifel_v2_max="2" <?php echo $stifel['call_avoidance']=='No'?"selected":""; ?> value="No">No</option>
											</select>
										</td>
										<td><input type="text" name="data[comm11]" class="form-control" disabled value="<?php echo $stifel['comm11'] ?>"></td>
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
										<td colspan=2>Empathy / Apology : Did the agent provide empathy / apology whenever it is disabled?</td>
										<td>6</td>
										<td>
											<select class="form-control stifelVal_v2" id="" name="data[empathy]" disabled>
												<option stifel_v2_val=6 stifel_v2_max="6" <?php echo $stifel['empathy']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option stifel_v2_val=0 stifel_v2_max="6" <?php echo $stifel['empathy']=='No'?"selected":""; ?> value="No">No</option>
												<option stifel_v2_val=6 stifel_v2_max="6" <?php echo $stifel['empathy']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td><input type="text" name="data[comm12]" class="form-control" disabled value="<?php echo $stifel['comm12'] ?>"></td>
									</tr>
									<tr>
										<td></td>
										<td colspan=2>Tone / Pacing / Fumbling : Did the agent able to converse in a pleasant tone with appropriate rate of speech, confidence and enthusiasm?</td>
										<td>8</td>
										<td>
											<select class="form-control stifelVal_v2" id="" name="data[tone_pacing]" disabled>
												<option stifel_v2_val=8 stifel_v2_max="8" <?php echo $stifel['tone_pacing']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option stifel_v2_val=0 stifel_v2_max="8" <?php echo $stifel['tone_pacing']=='No'?"selected":""; ?> value="No">No</option>
												<option stifel_v2_val=8 stifel_v2_max="8" <?php echo $stifel['tone_pacing']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td><input type="text" name="data[comm13]" class="form-control" disabled value="<?php echo $stifel['comm13'] ?>"></td>
									</tr>
									<tr>
										<td></td>
										<td colspan=2>Active Listening : Did the agent demonstrate active listening?</td>
										<td>8</td>
										<td>
											<select class="form-control stifelVal_v2" id="" name="data[active_listening]" disabled>
												<option stifel_v2_val=8 stifel_v2_max="8" <?php echo $stifel['active_listening']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option stifel_v2_val=0 stifel_v2_max="8" <?php echo $stifel['active_listening']=='No'?"selected":""; ?> value="No">No</option>
												<option stifel_v2_val=8 stifel_v2_max="8" <?php echo $stifel['active_listening']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td><input type="text" name="data[comm14]" class="form-control" disabled value="<?php echo $stifel['comm14'] ?>"></td>
									</tr>
									<tr>
										<td></td>
										<td colspan=2>Professionalism : Did the agent speak in a respectful tone, use proper manners, and say 'please' and 'thank you' throughout the conversation?</td>
										<td>8</td>
										<td>
											<select class="form-control stifelVal_v2" id="" name="data[professionalism]" disabled>
												<option stifel_v2_val=8 stifel_v2_max="8" <?php echo $stifel['professionalism']=='Yes'?"selected":""; ?> value="Yes">Yes</option>
												<option stifel_v2_val=0 stifel_v2_max="8" <?php echo $stifel['professionalism']=='No'?"selected":""; ?> value="No">No</option>
												<option stifel_v2_val=8 stifel_v2_max="8" <?php echo $stifel['professionalism']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td>
											<input type="text" name="data[comm15]" class="form-control" disabled value="<?php echo $stifel['comm15'] ?>">
											</td>
									</tr>
									<tr>
										<td>Observations:</td>
										<td colspan=2><textarea class="form-control"  disabled name="data[call_summary]"><?php echo $stifel['call_summary'] ?></textarea></td>
										<td>Area of opportunity:</td>
										<td colspan=2><textarea class="form-control" disabled name="data[feedback]"><?php echo $stifel['feedback'] ?></textarea></td>
									</tr>
								

										<?php if($stifel['attach_file']!=''){ ?>
									<tr oncontextmenu="return false;">
										<td colspan="2">Audio Files (Mp4/Mp3/M4a/Wav)</td>
										<td colspan="4">
											<?php $attach_file = explode(",",$stifel['attach_file']);
											 foreach($attach_file as $af){ ?>
												<audio oncontextmenu="return false;" controls controlslist="nodownload" style="background-color:#607F93">
													  <source src="<?php echo base_url(); ?>qa_files/qa_stifel/<?php echo $af; ?>" type="audio/ogg">
													  <source src="<?php echo base_url(); ?>qa_files/qa_stifel/<?php echo $af; ?>" type="audio/mpeg">
												</audio> </br>
											 <?php } ?>
										</td>
									</tr>
									<?php } ?>

									<tr>
										<td style="font-size:12px">Manager Review:</td>
										<td colspan="8" style="text-align:left"><?php echo $stifel['mgnt_rvw_note'] ?></td>
									</tr>
									<tr>
										<td style="font-size:12px">Client Review:</td>
										<td colspan="8" style="text-align:left"><?php echo $stifel['client_rvw_note'] ?></td>
									</tr>

									<tr><td colspan="10" style="background-color:#C5C8C8"></td></tr>
									
									 <form id="form_agent_user" method="POST" action="">
										<input type="hidden" name="pnid" class="form-control" value="<?php echo $pnid; ?>">
										
										<tr>
											<td colspan=2 style="font-size:16px">Feedback Acceptance<span style="font-size:24px;color:red">*</span></td>
											<td colspan=6>
												<select class="form-control" id="" name="agnt_fd_acpt" required="">
													<option value="">--Select--</option>
													<option <?php echo $stifel['agnt_fd_acpt']=='Acceptance'?"selected":""; ?> value="Acceptance">Acceptance</option>	
													<option <?php echo $stifel['agnt_fd_acpt']=='Not Acceptance'?"selected":""; ?> value="Not Acceptance">Not Acceptance</option>	
												</select>
											</td>
										</tr>
										<tr>
											<td colspan=2 style="font-size:16px">Your Review<span style="font-size:24px;color:red">*</span></td>
											<td colspan=6><textarea class="form-control" name="note" required><?php echo $stifel['agent_rvw_note'] ?></textarea></td>
										</tr>
										
										<?php if(is_access_qa_agent_module()==true){
										if(is_available_qa_feedback($stifel['entry_date'],72) == true){ ?>
											<tr>
												<?php if($stifel['agent_rvw_note']==''){ ?>
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
	<?php } ?>	
	</section>
</div>
