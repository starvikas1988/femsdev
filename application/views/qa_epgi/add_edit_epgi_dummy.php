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

<?php if ($epgi_id != 0) {
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
											<td colspan="6" id="theader" style="font-size:40px">EPGI</td>
											<input type="hidden" name="audit_start_time" value="<?php echo CurrMySqlDate(); ?>">
										</tr>
										<?php
										if ($epgi_id == 0) {
											$auditorName = get_username();
											//$auditDate = CurrDateMDY();
											$auditDate =  CurrDateTimeMDY();
											$clDate_val = '';
										} else {
											if ($epgi_data['entry_by'] != '') {
												$auditorName = $epgi_data['auditor_name'];
											} else {
												$auditorName = $epgi_data['client_name'];
											}
											$clDate_val = mysql2mmddyySls($epgi_data['call_date']);
										}
										?>
										<tr>
											<td>Auditor Name:</td>
											<td><input type="text" class="form-control" value="<?= $auditorName; ?>" disabled></td>
											<td>Audit Date:</td>
											<td><input type="text" class="form-control" value="<?= CurrDateTimeMDY() ?>" disabled></td>
											<td>Transaction Date:<span style="font-size:24px;color:red">*</span></td>
											<td>
												<input type="text" id="call_date" name="call_date"  onkeydown="return false;" value="<?php echo $clDate_val; ?>" max="<?php echo date("Y-m-d"); ?>" class="form-control" required>
											</td>
										</tr>
										<tr>
											<td>Agent Name:<span style="font-size:24px;color:red">*</span></td>
											<td>
												<select class="form-control" id="agent_id" name="data[agent_id]" required>
													<?php 
													if($epgi_data['agent_id']!=''){
														?>
														<option value="<?php echo $epgi_data['agent_id'] ?>"><?php echo $epgi_data['fname'] . " " . $epgi_data['lname'] ?></option>
														<?php
													}else{
														?>
														<option value="">Select</option>
														<?php
													}
													?>
													
													<?php foreach ($agentName as $row) :  ?>
														<option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
													<?php endforeach; ?>
												</select>
											</td>
											<td>Employee ID:</td>
											<td><input type="text" class="form-control" id="fusion_id" required value="<?php echo $epgi_data['fusion_id'] ?>" readonly></td>
											<td> TL Name:<span style="font-size:24px;color:red">*</span></td>
											<td>
												<input type="text" class="form-control" id="tl_name" required value="<?php echo $epgi_data['tl_name'] ?>" readonly>
												<input type="hidden" class="form-control" id="tl_id" name="data[tl_id]" value="<?php echo $epgi_data['tl_id'] ?>" required>
											</td>
										</tr>
										<tr>
											<td>Call Id:<span style="font-size:24px;color:red">*</span></td>
											<td>
												<input type="text" id="call_id" name="call_id"  value="<?php echo $epgi_data['call_id']; ?>" class="form-control" required>
											</td>
											<td>AHT:<span style="font-size:24px;color:red">*</span></td>
											<td><input type="text" class="form-control" onkeydown="return false;" id="call_duration" name="data[call_duration]" value="<?php echo $epgi_data['call_duration']?>" required></td>
											<td>Call Type:<span style="font-size:24px;color:red">*</span></td>
											<td>
												<select class="form-control" name="data[call_type]" required>
													<option value="">-Select-</option>
													<option value="Inbound" <?= ($epgi_data['call_type']=="Inbound")?"selected":""?>>Inbound</option>
													<option value="Outbound" <?= ($epgi_data['call_type']=="Outbound")?"selected":""?>>Outbound</option>
												</select>
											</td>
										</tr>
										<tr>
											<td>ACPT<span style="font-size:24px;color:red">*</span></td>
											<td>
												<select class="form-control" name="data[acpt]" required>
													<option value="">-Select-</option>
                                                    <option value="Agent"  <?= ($epgi_data['acpt']=="Agent")?"selected":"" ?>>Agent</option>
                                                    <option value="Process"  <?= ($epgi_data['acpt']=="Process")?"selected":"" ?>>Process</option>
                                                    <option value="Customer"  <?= ($epgi_data['acpt']=="Customer")?"selected":"" ?>>Customer</option>
                                                    <option value="Technology"  <?= ($epgi_data['acpt']=="Technology")?"selected":"" ?>>Technology</option>
                                                </select>
											</td>
											<td>VOC:<span style="font-size:24px;color:red">*</span></td>
											<td>
												<select class="form-control" id="voc" name="data[voc]" required>
													
													<option value="">-Select-</option>
													<option value="1"  <?= ($epgi_data['voc']=="1")?"selected":"" ?>>1</option>
													<option value="2"  <?= ($epgi_data['voc']=="2")?"selected":"" ?>>2</option>
													<option value="3"  <?= ($epgi_data['voc']=="3")?"selected":"" ?>>3</option>
													<option value="4"  <?= ($epgi_data['voc']=="4")?"selected":"" ?>>4</option>
													<option value="5"  <?= ($epgi_data['voc']=="5")?"selected":"" ?>>5</option>
													<option value="6"  <?= ($epgi_data['voc']=="6")?"selected":"" ?>>6</option>
													<option value="7"  <?= ($epgi_data['voc']=="7")?"selected":"" ?>>7</option>
													<option value="8"  <?= ($epgi_data['voc']=="8")?"selected":"" ?>>8</option>
													<option value="9"  <?= ($epgi_data['voc']=="9")?"selected":"" ?>>9</option>
													<option value="10"  <?= ($epgi_data['voc']=="10")?"selected":"" ?>>10</option>
												</select>
											</td>
											<td>Audit Type:<span style="font-size:24px;color:red">*</span></td>
											<td>
												<select class="form-control" id="audit_type" name="data[audit_type]" required>
                                                    <option value="">-Select-</option>
                                                    <option value="CQ Audit" <?= ($epgi_data['audit_type']=="CQ Audit")?"selected":"" ?>>CQ Audit</option>
                                                    <option value="BQ Audit" <?= ($epgi_data['audit_type']=="BQ Audit")?"selected":"" ?>>BQ Audit</option>
                                                    <option value="Calibration" <?= ($epgi_data['audit_type']=="Calibration")?"selected":"" ?>>Calibration</option>
                                                    <option value="Pre-Certificate Mock Call" <?= ($epgi_data['audit_type']=="Pre-Certificate Mock Call")?"selected":"" ?>>Pre-Certificate Mock Call</option>
                                                    <option value="Certification Audit" <?= ($epgi_data['audit_type']=="Certification Audit")?"selected":"" ?>>Certification Audit</option>
                                                    <option value="Operation Audit" <?= ($epgi_data['audit_type']=="Operation Audit")?"selected":"" ?>>Operation Audit</option>
                                                    <option value="Trainer Audit"  <?= ($epgi_data['audit_type']=="Trainer Audit")?"selected":"" ?>>Trainer Audit</option>
                                                </select>
											</td>
										</tr>
										<tr>
											<td class="auType">Auditor Type<span style="font-size:24px;color:red">*</span></td>
											<td class="auType">
												<select class="form-control" id="auditor_type" name="data[auditor_type]">
                                                    
                                                    <option value="Master" <?= ($epgi_data['auditor_type']=="Master")?"selected":"" ?>>Master</option>
                                                    <option value="Regular" <?= ($epgi_data['auditor_type']=="Regular")?"selected":"" ?>>Regular</option>
                                                </select>
											</td>
											<td>Site:<span style="font-size:24px;color:red">*</span></td>
											<td><input type="text" class="form-control" id="site" name="data[site]" value="<?php echo $epgi_data['site'] ?>" readonly></td>
											
										</tr>
										<tr>
											<td style="font-weight:bold; font-size:16px; text-align:left">Earned Score</td>
											<td><input type="text" readonly id="avon_earned_score" name="data[earned_score]" class="form-control" value="<?php echo $epgi_data['earned_score'] ?>" /></td>
											<td style="font-weight:bold; font-size:16px; text-align:left">Possible Score</td>
											<td><input type="text" readonly id="avon_possible_score" name="data[possible_score]" class="form-control" value="<?php echo $epgi_data['possible_score'] ?>" /></td>
											<td style="font-weight:bold; font-size:16px; text-align:right">Overall Score:</td>
											<td><input type="text" readonly id="avon_overall_score" name="data[overall_score]" class="form-control avonFatal" style="font-weight:bold" value="<?php echo $epgi_data['overall_score'] ?>"></td>
										</tr>
										<tr class="eml" style="height:25px; font-weight:bold">
											<td>Critical Accuracy</td>
											<td>PARAMETER</td>
											<td colspan=2>SUB PARAMETER</td>
											<td>STATUS</td>
											<td colspan=2>REMARKS</td>
										</tr>

										<tr>
											<td class="eml" rowspan=4 style="font-weight:bold; background-color:#D7BDE2">Business Critical</td>
											<td class="eml" rowspan=2>Greeting</td>
											<td colspan=2>The appropriate greeting was used (inbound/outbound)</td>
											<td>
												<select class="form-control epgi_point business" name="data[suggested_opening_spiel]" required>
													
													<option avon_val=1 <?php echo $epgi_data['suggested_opening_spiel'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option avon_val=0 <?php echo $epgi_data['suggested_opening_spiel'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													<option avon_val=0 <?php echo $epgi_data['suggested_opening_spiel'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt1]" class="form-control" value="<?php echo $epgi_data['cmt1'] ?>"></td>
										</tr>
										<tr>
											<td colspan=2>SLA</td>
											<td>
												<select class="form-control epgi_point compliance" name="data[sla]" required>
													
													<option avon_val=1 <?php echo $epgi_data['sla'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option avon_val=0 <?php echo $epgi_data['sla'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													<option avon_val=0 <?php echo $epgi_data['sla'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt2]" class="form-control" value="<?php echo $epgi_data['cmt2'] ?>"></td>
										</tr>

										<tr>
											<td class="eml" rowspan=3>Closing</td>
											<td colspan="2">Used Suggested Closing Spiel</td>
											<td>
												<select class="form-control epgi_point compliance" name="data[suggested_closing_spiel]" required>
													
													<option avon_val=1 <?= $epgi_data["suggested_closing_spiel"] == "Pass" ? "selected" : "" ?> value="Pass">Pass</option>
													<option avon_val=0 <?= $epgi_data["suggested_closing_spiel"] == "Fail" ? "selected" : "" ?> value="Fail">Fail</option>
													<option avon_val=0 <?= $epgi_data["suggested_closing_spiel"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt3]" class="form-control" value="<?php echo $epgi_data['cmt3'] ?>"></td>
										</tr>

										<tr>
											<td colspan=2>Additional Assistance</td>
											<td>
												<select class="form-control epgi_point compliance" name="data[additional_assistance]" required>
													
													<option avon_val=1 <?php echo $epgi_data['additional_assistance'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option avon_val=0 <?php echo $epgi_data['additional_assistance'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													<option avon_val=0 <?php echo $epgi_data['additional_assistance'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt4]" class="form-control" value="<?php echo $epgi_data['cmt4'] ?>"></td>
										</tr>

										<tr>
											<td colspan=2>Spiel Adherance</td>
											<td>
												<select class="form-control epgi_point compliance" name="data[spiel_adherance]" required>
													
													<option avon_val=1 <?php echo $epgi_data['spiel_adherance'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option avon_val=0 <?php echo $epgi_data['spiel_adherance'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													<option avon_val=0 <?php echo $epgi_data['spiel_adherance'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt5]" class="form-control" value="<?php echo $epgi_data['cmt5'] ?>"></td>
										</tr>

										<tr>
											<td class="eml" rowspan=1>Disclaimer and Concent</td>
											<td  colspan="2">Did the agent use proper script</td>
											<td>
												<select class="form-control epgi_point compliance" name="data[use_proper_script]" required>
													
													<option avon_val=2 <?= $epgi_data["use_proper_script"] == "Pass" ? "selected" : "" ?> value="Pass">Pass</option>
													<option avon_val=0 <?= $epgi_data["use_proper_script"] == "Fail" ? "selected" : "" ?> value="Fail">Fail</option>
													<option avon_val=0 <?= $epgi_data["use_proper_script"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt6]" class="form-control" value="<?php echo $epgi_data['cmt6'] ?>"></td>
										</tr>
										<tr>
											<td class="eml" rowspan=15 style="font-weight:bold; background-color:pink">Customer Critical</td>
											<td class="eml" rowspan=3>Acknowledgement, Empathy and Assurance</td>
											<td colspan="2">Did the agent acknowledge the issue of the customer?</td>
											<td>
												<select class="form-control epgi_point customer" name="data[acknowledge_issue]" required>
												
													<option avon_val=1 <?= $epgi_data["acknowledge_issue"] == "Pass" ? "selected" : "" ?> value="Pass">Pass</option>
													<option avon_val=0 <?= $epgi_data["acknowledge_issue"] == "Fail" ? "selected" : "" ?> value="Fail">Fail</option>
													<option avon_val=0 <?= $epgi_data["acknowledge_issue"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt7]" class="form-control" value="<?php echo $epgi_data['cmt7'] ?>"></td>
										</tr>
										<tr>
											<td colspan="2">Did the agent provide empathy statement?(when necessary)</td>
											<td>
												<select class="form-control epgi_point customer" name="data[empathy_statement]" required>
												
													<option avon_val=1 <?= $epgi_data["empathy_statement"] == "Pass" ? "selected" : "" ?> value="Pass">Pass</option>
													<option avon_val=0 <?= $epgi_data["empathy_statement"] == "Fail" ? "selected" : "" ?> value="Fail">Fail</option>
													<option avon_val=0 <?= $epgi_data["empathy_statement"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt8]" class="form-control" value="<?php echo $epgi_data['cmt8'] ?>"></td>
										</tr>
										<tr>
											<td colspan="2">Did the agent provide assurance to help the customer?</td>
											<td>
												<select class="form-control epgi_point customer" name="data[provide_assurance]" required>
												
													<option avon_val=1 <?= $epgi_data["provide_assurance"] == "Pass" ? "selected" : "" ?> value="Pass">Pass</option>
													<option avon_val=0 <?= $epgi_data["provide_assurance"] == "Fail" ? "selected" : "" ?> value="Fail">Fail</option>
													<option avon_val=0 <?= $epgi_data["provide_assurance"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt9]" class="form-control" value="<?php echo $epgi_data['cmt9'] ?>"></td>
										</tr>

										<tr>
											<td class="eml" rowspan=3>First Time Resolution</td>
											<td colspan="2">Information Shared</td>
											<td>
												<select class="form-control epgi_point customer" name="data[information_shared]" required>
												
													<option avon_val=1 <?= $epgi_data["information_shared"] == "Pass" ? "selected" : "" ?> value="Pass">Pass</option>
													<option avon_val=0 <?= $epgi_data["information_shared"] == "Fail" ? "selected" : "" ?> value="Fail">Fail</option>
													<option avon_val=0 <?= $epgi_data["information_shared"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt10]" class="form-control" value="<?php echo $epgi_data['cmt10'] ?>"></td>
										</tr>
										<tr>
											<td colspan="2">Probing question</td>
											<td>
												<select class="form-control epgi_point customer" name="data[probing_question]" required>
												
													<option avon_val=1 <?= $epgi_data["probing_question"] == "Pass" ? "selected" : "" ?> value="Pass">Pass</option>
													<option avon_val=0 <?= $epgi_data["probing_question"] == "Fail" ? "selected" : "" ?> value="Fail">Fail</option>
													<option avon_val=0 <?= $epgi_data["probing_question"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt11]" class="form-control" value="<?php echo $epgi_data['cmt11'] ?>"></td>
										</tr>
										<tr>
											<td colspan="2">Failed to Escalate/Call back</td>
											<td>
												<select class="form-control epgi_point customer" name="data[call_back]" required>
												
													<option avon_val=1 <?= $epgi_data["call_back"] == "Pass" ? "selected" : "" ?> value="Pass">Pass</option>
													<option avon_val=0 <?= $epgi_data["call_back"] == "Fail" ? "selected" : "" ?> value="Fail">Fail</option>
													<option avon_val=0 <?= $epgi_data["call_back"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt12]" class="form-control" value="<?php echo $epgi_data['cmt12'] ?>"></td>
										</tr>

										<tr>
											<td class="eml" rowspan=4>Communication Skills</td>
											<td colspan="2">Active Listening/Reading</td>
											<td>
												<select class="form-control epgi_point customer" name="data[active_listening]" required>
											
													<option avon_val=1 <?= $epgi_data["active_listening"] == "Pass" ? "selected" : "" ?> value="Pass">Pass</option>
													<option avon_val=0 <?= $epgi_data["active_listening"] == "Fail" ? "selected" : "" ?> value="Fail">Fail</option>
													<option avon_val=0 <?= $epgi_data["active_listening"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt13]" class="form-control" value="<?php echo $epgi_data['cmt13'] ?>"></td>
										</tr>
										<tr>
											<td colspan="2">Interruption</td>
											<td>
												<select class="form-control epgi_point customer" name="data[interruption]" required>
										
													<option avon_val=1 <?= $epgi_data["interruption"] == "Pass" ? "selected" : "" ?> value="Pass">Pass</option>
													<option avon_val=0 <?= $epgi_data["interruption"] == "Fail" ? "selected" : "" ?> value="Fail">Fail</option>
													<option avon_val=0 <?= $epgi_data["interruption"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt14]" class="form-control" value="<?php echo $epgi_data['cmt14'] ?>"></td>
										</tr>
										<tr>
											<td colspan="2">Dead Air and Proper Hold Technique</td>
											<td>
												<select class="form-control epgi_point customer" name="data[dead_air]" required>
													<option avon_val=1 <?= $epgi_data["dead_air"] == "Pass" ? "selected" : "" ?> value="Pass">Pass</option>
													<option avon_val=0 <?= $epgi_data["dead_air"] == "Fail" ? "selected" : "" ?> value="Fail">Fail</option>
													<option avon_val=0 <?= $epgi_data["dead_air"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt15]" class="form-control" value="<?php echo $epgi_data['cmt15'] ?>"></td>
										</tr>
										<tr>
											<td colspan="2">Grammar usage/Technical Writing and Pronunciation/branding</td>
											<td>
												<select class="form-control epgi_point customer" name="data[grammar_usage]" required>
													<option avon_val=1 <?= $epgi_data["grammar_usage"] == "Pass" ? "selected" : "" ?> value="Pass">Pass</option>
													<option avon_val=0 <?= $epgi_data["grammar_usage"] == "Fail" ? "selected" : "" ?> value="Fail">Fail</option>
													<option avon_val=0 <?= $epgi_data["grammar_usage"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt16]" class="form-control" value="<?php echo $epgi_data['cmt16'] ?>"></td>
										</tr>

										<tr>
											<td class="eml" rowspan=5>TOV</td>
											<td colspan="2">Professionalism (ZTP)</td>
											<td>
												<select class="form-control epgi_point customer" name="data[professionalism]" required>
													<option avon_val=1 <?= $epgi_data["professionalism"] == "Pass" ? "selected" : "" ?> value="Pass">Pass</option>
													<option avon_val=0 <?= $epgi_data["professionalism"] == "Fail" ? "selected" : "" ?> value="Fail">Fail</option>
													<option avon_val=0 <?= $epgi_data["professionalism"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt17]" class="form-control" value="<?php echo $epgi_data['cmt17'] ?>"></td>
										</tr>
										<tr>
											<td colspan="2">Interact with intention</td>
											<td>
												<select class="form-control epgi_point customer" name="data[interact_with_intention]" required>
													<option avon_val=1 <?= $epgi_data["interact_with_intention"] == "Pass" ? "selected" : "" ?> value="Pass">Pass</option>
													<option avon_val=0 <?= $epgi_data["interact_with_intention"] == "Fail" ? "selected" : "" ?> value="Fail">Fail</option>
													<option avon_val=0 <?= $epgi_data["interact_with_intention"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt18]" class="form-control" value="<?php echo $epgi_data['cmt18'] ?>"></td>
										</tr>
										<tr>
											<td colspan="2">Strong Ownership</td>
											<td>
												<select class="form-control epgi_point customer" name="data[strong_ownership]" required>
													<option avon_val=1 <?= $epgi_data["strong_ownership"] == "Pass" ? "selected" : "" ?> value="Pass">Pass</option>
													<option avon_val=0 <?= $epgi_data["strong_ownership"] == "Fail" ? "selected" : "" ?> value="Fail">Fail</option>
													<option avon_val=0 <?= $epgi_data["strong_ownership"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt19]" class="form-control" value="<?php echo $epgi_data['cmt19'] ?>"></td>
										</tr>
										<tr>
											<td colspan="2">Enthusiasm</td>
											<td>
												<select class="form-control epgi_point customer" name="data[enthusiasm]" required>
													<option avon_val=1 <?= $epgi_data["enthusiasm"] == "Pass" ? "selected" : "" ?> value="Pass">Pass</option>
													<option avon_val=0 <?= $epgi_data["enthusiasm"] == "Fail" ? "selected" : "" ?> value="Fail">Fail</option>
													<option avon_val=0 <?= $epgi_data["enthusiasm"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt20]" class="form-control" value="<?php echo $epgi_data['cmt20'] ?>"></td>
										</tr>
										<tr>
											<td colspan="2">Tailored Contact</td>
											<td>
												<select class="form-control epgi_point customer" name="data[tailored_contact]" required>
													<option avon_val=1 <?= $epgi_data["tailored_contact"] == "Pass" ? "selected" : "" ?> value="Pass">Pass</option>
													<option avon_val=0 <?= $epgi_data["tailored_contact"] == "Fail" ? "selected" : "" ?> value="Fail">Fail</option>
													<option avon_val=0 <?= $epgi_data["tailored_contact"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt21]" class="form-control" value="<?php echo $epgi_data['cmt21'] ?>"></td>
										</tr>

										<tr>
											<td class="eml" rowspan=5 style="font-weight:bold; background-color:#d6bf91">Business Critical</td>
											<td class="eml" rowspan=1>Avon Security </td>
											<td  colspan="2">Avon Security </td>
											<td>
												<select class="form-control epgi_point business" name="data[avon_security]" required>
													<option avon_val=4 <?= $epgi_data["avon_security"] == "Pass" ? "selected" : "" ?> value="Pass">Pass</option>
													<option avon_val=0 <?= $epgi_data["avon_security"] == "Fail" ? "selected" : "" ?> value="Fail">Fail</option>
													<option avon_val=0 <?= $epgi_data["avon_security"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt22]" class="form-control" value="<?php echo $epgi_data['cmt22'] ?>"></td>
										</tr>
										<tr>
											<td class="eml" rowspan=3>Ticket/Email Handling (if Applicable)</td>
											<td colspan="2">Send to the right approver </td>
											<td>
												<select class="form-control epgi_point business" name="data[send_right_approver]" required>
													<option avon_val=1 <?= $epgi_data["send_right_approver"] == "Pass" ? "selected" : "" ?> value="Pass">Pass</option>
													<option avon_val=0 <?= $epgi_data["send_right_approver"] == "Fail" ? "selected" : "" ?> value="Fail">Fail</option>
													<option avon_val=0 <?= $epgi_data["send_right_approver"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt23]" class="form-control" value="<?php echo $epgi_data['cmt23'] ?>"></td>
										</tr>
										<tr>
											<td colspan="2">Efficiency of Action</td>
											<td>
												<select class="form-control epgi_point business" name="data[efficiency_of_action]" required>
													<option avon_val=1 <?= $epgi_data["efficiency_of_action"] == "Pass" ? "selected" : "" ?> value="Pass">Pass</option>
													<option avon_val=0 <?= $epgi_data["efficiency_of_action"] == "Fail" ? "selected" : "" ?> value="Fail">Fail</option>
													<option avon_val=0 <?= $epgi_data["efficiency_of_action"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt24]" class="form-control" value="<?php echo $epgi_data['cmt24'] ?>"></td>
										</tr>
										<tr>
											<td colspan="2">Documentation</td>
											<td>
												<select class="form-control epgi_point business" name="data[documentation]" required>
													<option avon_val=1 <?= $epgi_data["documentation"] == "Pass" ? "selected" : "" ?> value="Pass">Pass</option>
													<option avon_val=0 <?= $epgi_data["documentation"] == "Fail" ? "selected" : "" ?> value="Fail">Fail</option>
													<option avon_val=0 <?= $epgi_data["documentation"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt25]" class="form-control" value="<?php echo $epgi_data['cmt25'] ?>"></td>
										</tr>


										<tr>
											<td class="eml" rowspan=1>Disposition / Correct Tagging</td>
											<td colspan="2">Use proper disposition and tagging</td>
											<td>
												<select class="form-control epgi_point business" name="data[proper_disposition_tagging]" required>
													<option avon_val=4 <?= $epgi_data["proper_disposition_tagging"] == "Pass" ? "selected" : "" ?> value="Pass">Pass</option>
													<option avon_val=0 <?= $epgi_data["proper_disposition_tagging"] == "Fail" ? "selected" : "" ?> value="Fail">Fail</option>
													<option avon_val=0 <?= $epgi_data["proper_disposition_tagging"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt26]" class="form-control" value="<?php echo $epgi_data['cmt26'] ?>"></td>
										</tr>
										<tr class="fatal">
											<td class="eml" rowspan=2 style="font-weight:bold; background-color:red">FATAL ERROR</td>
											<td class="eml" rowspan=1>CALL/EMAIL/SMS/CHAT/CRM AVOIDANCE</td>
											<td colspan="2">Did the agent resolved the concerns within the interactions?</td>
											<td>
												<select class="form-control epgi_point avon_fatal" name="data[resolved_the_concerns]" required>
													<option avon_val=0 <?= $epgi_data["resolved_the_concerns"] == "Pass" ? "selected" : "" ?> value="Pass">Pass</option>
													<option avon_val=0 <?= $epgi_data["resolved_the_concerns"] == "Fail" ? "selected" : "" ?> value="Fail">Fail</option>
													<option avon_val=0 <?= $epgi_data["resolved_the_concerns"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt27]" class="form-control" value="<?php echo $epgi_data['cmt27'] ?>"></td>
										</tr>
										<tr class="fatal">
											<td class="eml" rowspan=1>Email/SMS/ First response/acknowledge</td>
											<td colspan="2">Did the agent used first response?</td>
											<td>
												<select class="form-control epgi_point avon_fatal" name="data[first_response]" required>
													<option avon_val=0 <?= $epgi_data["first_response"] == "Pass" ? "selected" : "" ?> value="Pass">Pass</option>
													<option avon_val=0 <?= $epgi_data["first_response"] == "Fail" ? "selected" : "" ?> value="Fail">Fail</option>
													<option avon_val=0 <?= $epgi_data["first_response"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt28]" class="form-control" value="<?php echo $epgi_data['cmt28'] ?>"></td>
										</tr>

									<tr style="font-weight:bold; background-color:#D7BDE2"><td colspan=2>Customer Score</td><td colspan=2>Business Score</td><td colspan=2>Compliance Score</td></tr>
									<tr style="font-weight:bold; background-color:#D7BDE2">
										<td>Earned Point:</td><td ><input type="text" readonly class="form-control" id="customer_earned_score" name="data[customer_earned_score]" value="<?php echo $epgi_data['customer_earned_score'] ?>"></td>
										<td>Earned Point:</td><td ><input type="text" readonly class="form-control" id="business_earned_score" name="data[business_earned_score]" value="<?php echo $epgi_data['business_earned_score'] ?>"></td>
										<td>Earned Point:</td><td ><input type="text" readonly class="form-control" id="compliance_earned_score" name="data[compliance_earned_score]" value="<?php echo $epgi_data['compliance_earned_score'] ?>"></td>
									</tr>
									<tr style="font-weight:bold; background-color:#D7BDE2">
										<td>Possible Point:</td><td ><input type="text" readonly class="form-control" id="customer_possible_score" name="data[customer_possible_score]" value="<?php echo $epgi_data['customer_possible_score'] ?>"></td>
										<td>Possible Point:</td><td ><input type="text" readonly class="form-control" id="business_possible_score" name="data[business_possible_score]" value="<?php echo $epgi_data['business_possible_score'] ?>"></td>
										<td>Possible Point:</td><td ><input type="text" readonly class="form-control" id="compliance_possible_score" name="data[compliance_possible_score]" value="<?php echo $epgi_data['compliance_possible_score'] ?>"></td>
									</tr>
									<tr style="font-weight:bold; background-color:#D7BDE2">
										<td>Overall Percentage:</td><td ><input type="text" readonly class="form-control" id="customer_overall_score" name="data[customer_overall_score]" value="<?php echo $epgi_data['customer_overall_score'] ?>"></td>
										<td>Overall Percentage:</td><td ><input type="text" readonly class="form-control" id="business_overall_score" name="data[business_overall_score]" value="<?php echo $epgi_data['business_overall_score'] ?>"></td>
										<td>Overall Percentage:</td><td ><input type="text" readonly class="form-control" id="compliance_overall_score" name="data[compliance_overall_score]" value="<?php echo $epgi_data['compliance_overall_score'] ?>"></td>
									</tr>
										<tr>
											<td>Call Summary:</td>
											<td colspan=2><textarea class="form-control" name="data[call_summary]"><?php echo $epgi_data['call_summary'] ?></textarea></td>
											<td>Feedback:</td>
											<td colspan=2><textarea class="form-control" name="data[feedback]"><?php echo $epgi_data['feedback'] ?></textarea></td>
										</tr>
										<tr>
											<td colspan=2>Upload Files [m4a,mp4,mp3,wav]</td>
											<?php if ($epgi_id == 0) { ?>
												<td colspan=4>
													<input type="file" name="attach_file[]" id="attach_file" accept=".m4a,.mp4,.mp3,.wav,audio/*" />
												</td>
												<?php } else {
												if ($epgi_data['attach_file'] != '') { ?>
													<td colspan=4>
														<input type="file" multiple class="form-control"  id="attach_file" name="attach_file[]" accept=".m4a,.mp4,.mp3,.wav,audio/*"> 
														<?php $attach_file = explode(",", $epgi_data['attach_file']);
														foreach ($attach_file as $mp) { ?>
															<audio controls='' style="background-color:#607F93">
																<source src="<?php echo base_url(); ?>qa_files/qa_epgi/<?php echo $mp; ?>" type="audio/ogg">
																<source src="<?php echo base_url(); ?>qa_files/qa_epgi/<?php echo $mp; ?>" type="audio/mpeg">
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

										<?php if ($epgi_id != 0) { ?>
											<tr>
												<td colspan=2 style="font-size:16px; font-weight:bold">Agent Feedback Acceptance:</td>
												<td colspan=4><?php echo $epgi_data['agnt_fd_acpt'] ?></td>
											</tr>
											<tr>
												<td colspan=2 style="font-size:16px; font-weight:bold">Agent Review:</td>
												<td colspan=4><?php echo $epgi_data['agent_rvw_note'] ?></td>
											</tr>
											<tr>
												<td colspan=2 style="font-size:16px; font-weight:bold">Management Review:</td>
												<td colspan=4><?php echo $epgi_data['mgnt_rvw_note'] ?></td>
											</tr>
											<tr>
												<td colspan=2 style="font-size:16px; font-weight:bold">Client Review:</td>
												<td colspan=4><?php echo $epgi_data['client_rvw_note'] ?></td>
											</tr>

											<tr>
												<td colspan=2 style="font-size:16px">Your Review<span style="font-size:24px;color:red">*</span></td>
												<td colspan=4><textarea class="form-control1" style="width:100%" id="note" name="note" required></textarea></td>
											</tr>
										<?php } ?>

										<?php
										if ($epgi_id == 0) {
											if (is_access_qa_module() == true || is_access_qa_operations_module() == true) { ?>
												<tr>
													<td colspan=6><button class="btn btn-success waves-effect" type="submit" id="qaformsubmit" style="width:500px">SAVE</button></td>
												</tr>
												<?php
											}
										} else {
											if (is_access_qa_module() == true || is_access_qa_operations_module() == true) {
												if (is_available_qa_feedback($epgi_data['entry_date'], 72) == true) { ?>
													<tr>
														<td colspan="6"><button class="btn btn-success waves-effect" type="submit" id='qaformsubmit' name='btnSave' value="SAVE" style="width:500px">SAVE</button></td>
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