<style>
	.table>tbody>tr>td {
		text-align: center;
		font-size: 13px;
	}

	#theader {
		font-size: 20px;
		font-weight: bold;
	}

	.eml {
		background-color: #85C1E9;
	}

	.fatal .eml {
		background-color: red;
		color: white;
	}
</style>


<div class="wrap">
	<section class="app-content">


		<div class="row">
			<div class="col-12">
				<div class="widget">

					<div class="widget-body">
						<div class="table-responsive">
							<table class="table table-striped skt-table" width="100%">
								<tbody>
									<tr style="background-color:#AEB6BF">
										<td colspan="6" id="theader" style="font-size:30px">Avon</td>
									</tr>

									<tr>
										<td>Auditor Name: </td>
										<?php if ($avon['entry_by'] != '') {
											$auditorName = $avon['auditor_name'];
										} else {
											$auditorName = $avon['client_name'];
										} 
									 	$new = explode("-", $avon['entry_date']);
										$new1 = explode(" ", $new[2]);
										//print_r($new);
									    $a = array($new[1], $new1[0], $new[0]);
									    $n_date = implode("/", $a);
										$auditDate = ($n_date)." ".$new1[1]; 
										?>
										<td><input type="text" class="form-control" value="<?php echo $auditorName; ?>" disabled></td>
										<td>Audit Date: </td>
										<td><input type="text" class="form-control" value="<?php echo ($auditDate) ?>"disabled></td>
										<td>Transaction Date: </td>
										<td><input type="text" class="form-control" value="<?php echo mysql2mmddyySls($avon['call_date']); ?>" disabled></td>
									</tr>
									<tr>
										<td>Agent Name: </td>
										<td>
											<select class="form-control" disabled>
												<option><?php echo $avon['fname'] . " " . $avon['lname'] ?></option>
											</select>
										</td>
										<td>Employee ID: </td>
										<td><input type="text" class="form-control" value="<?php echo $avon['fusion_id'] ?>" disabled></td>
										<td>TL Name: </td>
										<td>
											<select class="form-control" disabled>
												<option><?php echo $avon['tl_name'] ?></option>
											</select>
										</td>
									</tr>
									<tr>
										<td>AHT: </td>
										<td><input type="text" class="form-control" id="call_duration" name="data[call_duration]" value="<?php echo $avon['call_duration'] ?>" disabled></td>
										<td>Call Type: </td>
										<td><input type="text" class="form-control" name="data[call_type]" value="<?php echo $avon['call_type'] ?>" disabled></td>
										<td>LOB/Channel: </td>
											<td>
												<select class="form-control" id="" name="data[lob]" disabled>
											
											<?php 
												if($avon['lob']!=''){
													?>
													<option value="<?php echo $avon['lob']; ?>"><?php echo $avon['lob']; ?></option>
													<?php
												}
											?>
											
										</select>
										</td>
									</tr>
									<tr>
										

										<!-- <td>Digital/Non Digital </td>
										<td>
											<input type="text" disabled name="data[digital_non_digital]" value="<?=$avon['digital_non_digital']?>" class="form-control"/>
										</td> -->
										<td>Week</td>
										<td>
											<input type="text" disabled value="<?= $avon['week']?>" name="data[week]" class="form-control"/>
										</td>
										<td>VOC: </td>
										<td><select class="form-control" disabled>
												<option><?php echo $avon['voc'] ?></option>
											</select>
										</td>
										<td>Audit Type: </td>
										<td><select class="form-control" disabled>
												<option><?php echo $avon['audit_type'] ?></option>
											</select></td>
									</tr>
									<tr>
										<td class="auType">Auditor Type </td>
										<td class="auType">
											<select class="form-control" id="auditor_type" name="data[auditor_type]" disabled>
												<option value="">-Select-</option>
												<option value="Master" <?= ($avon["auditor_type"] == "Master") ? "selected" : "" ?>>Master</option>
												<option value="Regular" <?= ($avon["auditor_type"] == "Regular") ? "selected" : "" ?>>Regular</option>
											</select>
										</td>
									</tr>
									<tr>
										<td style="font-weight:bold; font-size:16px; text-align:left">Earned Score</td>
										<td><input type="text" readonly id="avon_earned_score" name="data[earned_score]" class="form-control" value="<?php echo $avon['earned_score'] ?>" disabled /></td>
										<td style="font-weight:bold; font-size:16px; text-align:left">Possible Score</td>
										<td><input type="text" readonly id="avon_possible_score" name="data[possible_score]" class="form-control" value="<?php echo $avon['possible_score'] ?>" disabled /></td>
										<td style="font-weight:bold; font-size:16px; text-align:right">Overall Score:</td>
										<td><input type="text" disabled id="huda_overall_score" name="data[overall_score]" class="form-control hudaFatal" style="font-weight:bold" value="<?php echo $avon['overall_score'] ?>%"></td>
									</tr>
									<tr class="eml" style="height:25px; font-weight:bold">
										<td>Critical Accuracy</td>
										<td>PARAMETER</td>
										<td colspan=2>SUB PARAMETER</td>
										<td>STATUS</td>
										<td colspan=2>REMARKS</td>
									</tr>

									<tr>
											<td class="eml" rowspan=6 style="font-weight:bold; background-color:#D7BDE2">Compliance Citical</td>
											<td class="eml" rowspan=2>Opening</td>
											<td colspan=2>Used Suggested Opening Spiel</td>
											<td>
												<select class="form-control avon_point compliance" name="data[suggested_opening_spiel]" disabled>
													<option value="">-Select-</option>
													<option avon_val=1 <?php echo $avon['suggested_opening_spiel'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option avon_val=0 <?php echo $avon['suggested_opening_spiel'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													<option avon_val=0 <?php echo $avon['suggested_opening_spiel'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt1]" class="form-control" value="<?php echo $avon['cmt1'] ?>" disabled></td>
										</tr>
										<tr>
											<td colspan=2>SLA</td>
											<td>
												<select class="form-control avon_point compliance" name="data[sla]" disabled>
													<option value="">-Select-</option>
													<option avon_val=1 <?php echo $avon['sla'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option avon_val=0 <?php echo $avon['sla'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													<option avon_val=0 <?php echo $avon['sla'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt2]" class="form-control" value="<?php echo $avon['cmt2'] ?>" disabled></td>
										</tr>

										<tr>
											<td class="eml" rowspan=3>Closing</td>
											<td colspan="2">Used Suggested Closing Spiel</td>
											<td>
												<select class="form-control avon_point compliance" name="data[suggested_closing_spiel]" disabled>
													<option value="">-Select-</option>
													<option avon_val=1 <?= $avon["suggested_closing_spiel"] == "Pass" ? "selected" : "" ?> value="Pass">Pass</option>
													<option avon_val=0 <?= $avon["suggested_closing_spiel"] == "Fail" ? "selected" : "" ?> value="Fail">Fail</option>
													<option avon_val=0 <?= $avon["suggested_closing_spiel"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt3]" class="form-control" value="<?php echo $avon['cmt3'] ?>" disabled></td>
										</tr>

										<tr>
											<td colspan=2>Additional Assistance</td>
											<td>
												<select class="form-control avon_point compliance" name="data[additional_assistance]" disabled>
													<option value="">-Select-</option>
													<option avon_val=1 <?php echo $avon['additional_assistance'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option avon_val=0 <?php echo $avon['additional_assistance'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													<option avon_val=0 <?php echo $avon['additional_assistance'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt4]" class="form-control" value="<?php echo $avon['cmt4'] ?>" disabled></td>
										</tr>

										<tr>
											<td colspan=2>Spiel Adherance</td>
											<td>
												<select class="form-control avon_point compliance" name="data[spiel_adherance]" disabled>
													<option value="">-Select-</option>
													<option avon_val=1 <?php echo $avon['spiel_adherance'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option avon_val=0 <?php echo $avon['spiel_adherance'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													<option avon_val=0 <?php echo $avon['spiel_adherance'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt5]" class="form-control" value="<?php echo $avon['cmt5'] ?>" disabled></td>
										</tr>

										<tr>
											<td class="eml" rowspan=1>Disclaimer and Concent</td>
											<td  colspan="2">Did the agent use proper script</td>
											<td>
												<select class="form-control avon_point compliance" name="data[use_proper_script]" disabled>
													<option value="">-Select-</option>
													<option avon_val=2 <?= $avon["use_proper_script"] == "Pass" ? "selected" : "" ?> value="Pass">Pass</option>
													<option avon_val=0 <?= $avon["use_proper_script"] == "Fail" ? "selected" : "" ?> value="Fail">Fail</option>
													<option avon_val=0 <?= $avon["use_proper_script"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt6]" class="form-control" value="<?php echo $avon['cmt6'] ?>" disabled></td>
										</tr>
										<tr>
											<td class="eml" rowspan=15 style="font-weight:bold; background-color:pink">Customer Critical</td>
											<td class="eml" rowspan=3>Acknowledgement, Empathy and Assurance</td>
											<td  colspan="2">Did the agent acknowledge the issue of the customer?</td>
											<td>
												<select class="form-control avon_point customer" name="data[acknowledge_issue]" disabled>
													<option value="">-Select-</option>
													<option avon_val=1 <?= $avon["acknowledge_issue"] == "Pass" ? "selected" : "" ?> value="Pass">Pass</option>
													<option avon_val=0 <?= $avon["acknowledge_issue"] == "Fail" ? "selected" : "" ?> value="Fail">Fail</option>
													<option avon_val=0 <?= $avon["acknowledge_issue"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt7]" class="form-control" value="<?php echo $avon['cmt7'] ?>" disabled></td>
										</tr>
										<tr>
											<td  colspan="2">Did the agent provide empathy statement?(when necessary)</td>
											<td>
												<select class="form-control avon_point customer" name="data[empathy_statement]" disabled>
													<option value="">-Select-</option>
													<option avon_val=1 <?= $avon["empathy_statement"] == "Pass" ? "selected" : "" ?> value="Pass">Pass</option>
													<option avon_val=0 <?= $avon["empathy_statement"] == "Fail" ? "selected" : "" ?> value="Fail">Fail</option>
													<option avon_val=0 <?= $avon["empathy_statement"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt8]" class="form-control" value="<?php echo $avon['cmt8'] ?>" disabled></td>
										</tr>
										<tr>
											<td  colspan="2">Did the agent provide assurance to help the customer?</td>
											<td>
												<select class="form-control avon_point customer" name="data[provide_assurance]" disabled>
													<option value="">-Select-</option>
													<option avon_val=1 <?= $avon["provide_assurance"] == "Pass" ? "selected" : "" ?> value="Pass">Pass</option>
													<option avon_val=0 <?= $avon["provide_assurance"] == "Fail" ? "selected" : "" ?> value="Fail">Fail</option>
													<option avon_val=0 <?= $avon["provide_assurance"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt9]" class="form-control" value="<?php echo $avon['cmt9'] ?>" disabled></td>
										</tr>

										<tr>
											<td class="eml" rowspan=3>First Time Resolution</td>
											<td  colspan="2">Information Shared</td>
											<td>
												<select class="form-control avon_point customer" name="data[information_shared]" disabled>
													<option value="">-Select-</option>
													<option avon_val=1 <?= $avon["information_shared"] == "Pass" ? "selected" : "" ?> value="Pass">Pass</option>
													<option avon_val=0 <?= $avon["information_shared"] == "Fail" ? "selected" : "" ?> value="Fail">Fail</option>
													<option avon_val=0 <?= $avon["information_shared"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt10]" class="form-control" value="<?php echo $avon['cmt10'] ?>" disabled></td>
										</tr>
										<tr>
											<td  colspan="2">Probing question</td>
											<td>
												<select class="form-control avon_point customer" name="data[probing_question]" disabled>
													<option value="">-Select-</option>
													<option avon_val=1 <?= $avon["probing_question"] == "Pass" ? "selected" : "" ?> value="Pass">Pass</option>
													<option avon_val=0 <?= $avon["probing_question"] == "Fail" ? "selected" : "" ?> value="Fail">Fail</option>
													<option avon_val=0 <?= $avon["probing_question"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt11]" class="form-control" value="<?php echo $avon['cmt11'] ?>" disabled></td>
										</tr>
										<tr>
											<td  colspan="2">Failed to Escalate/Call back</td>
											<td>
												<select class="form-control avon_point customer" name="data[call_back]" disabled>
													<option value="">-Select-</option>
													<option avon_val=1 <?= $avon["call_back"] == "Pass" ? "selected" : "" ?> value="Pass">Pass</option>
													<option avon_val=0 <?= $avon["call_back"] == "Fail" ? "selected" : "" ?> value="Fail">Fail</option>
													<option avon_val=0 <?= $avon["call_back"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt12]" class="form-control" value="<?php echo $avon['cmt12'] ?>" disabled></td>
										</tr>

										<tr>
											<td class="eml" rowspan=4>Communication Skills</td>
											<td  colspan="2">Active Listening/Reading</td>
											<td>
												<select class="form-control avon_point customer" name="data[active_listening]" disabled>
													<option value="">-Select-</option>
													<option avon_val=1 <?= $avon["active_listening"] == "Pass" ? "selected" : "" ?> value="Pass">Pass</option>
													<option avon_val=0 <?= $avon["active_listening"] == "Fail" ? "selected" : "" ?> value="Fail">Fail</option>
													<option avon_val=0 <?= $avon["active_listening"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt13]" class="form-control" value="<?php echo $avon['cmt13'] ?>" disabled></td>
										</tr>
										<tr>
											<td colspan="2">Interruption</td>
											<td>
												<select class="form-control avon_point customer" name="data[interruption]" disabled>
													<option value="">-Select-</option>
													<option avon_val=1 <?= $avon["interruption"] == "Pass" ? "selected" : "" ?> value="Pass">Pass</option>
													<option avon_val=0 <?= $avon["interruption"] == "Fail" ? "selected" : "" ?> value="Fail">Fail</option>
													<option avon_val=0 <?= $avon["interruption"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt14]" class="form-control" value="<?php echo $avon['cmt14'] ?>" disabled></td>
										</tr>
										<tr>
											<td colspan="2">Dead Air and Proper Hold Technique</td>
											<td>
												<select class="form-control avon_point customer" name="data[dead_air]" disabled>
													<option value="">-Select-</option>
													<option avon_val=1 <?= $avon["dead_air"] == "Pass" ? "selected" : "" ?> value="Pass">Pass</option>
													<option avon_val=0 <?= $avon["dead_air"] == "Fail" ? "selected" : "" ?> value="Fail">Fail</option>
													<option avon_val=0 <?= $avon["dead_air"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt15]" class="form-control" value="<?php echo $avon['cmt15'] ?>" disabled></td>
										</tr>
										<tr>
											<td colspan="2">Grammar usage/Technical Writing and Pronunciation/branding</td>
											<td>
												<select class="form-control avon_point customer" name="data[grammar_usage]" disabled>
													<option value="">-Select-</option>
													<option avon_val=1 <?= $avon["grammar_usage"] == "Pass" ? "selected" : "" ?> value="Pass">Pass</option>
													<option avon_val=0 <?= $avon["grammar_usage"] == "Fail" ? "selected" : "" ?> value="Fail">Fail</option>
													<option avon_val=0 <?= $avon["grammar_usage"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt16]" class="form-control" value="<?php echo $avon['cmt16'] ?>" disabled></td>
										</tr>

										<tr>
											<td class="eml" rowspan=5>TOV</td>
											<td colspan="2">Professionalism (ZTP)</td>
											<td>
												<select class="form-control avon_point customer" name="data[professionalism]" disabled>
													<option value="">-Select-</option>
													<option avon_val=1 <?= $avon["professionalism"] == "Pass" ? "selected" : "" ?> value="Pass">Pass</option>
													<option avon_val=0 <?= $avon["professionalism"] == "Fail" ? "selected" : "" ?> value="Fail">Fail</option>
													<option avon_val=0 <?= $avon["professionalism"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt17]" class="form-control" value="<?php echo $avon['cmt17'] ?>" disabled></td>
										</tr>
										<tr>
											<td colspan="2">Interact with intention</td>
											<td>
												<select class="form-control avon_point customer" name="data[interact_with_intention]" disabled>
													<option value="">-Select-</option>
													<option avon_val=1 <?= $avon["interact_with_intention"] == "Pass" ? "selected" : "" ?> value="Pass">Pass</option>
													<option avon_val=0 <?= $avon["interact_with_intention"] == "Fail" ? "selected" : "" ?> value="Fail">Fail</option>
													<option avon_val=0 <?= $avon["interact_with_intention"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt18]" class="form-control" value="<?php echo $avon['cmt18'] ?>" disabled></td>
										</tr>
										<tr>
											<td colspan="2">Strong Ownership</td>
											<td>
												<select class="form-control avon_point customer" name="data[strong_ownership]" disabled>
													<option value="">-Select-</option>
													<option avon_val=1 <?= $avon["strong_ownership"] == "Pass" ? "selected" : "" ?> value="Pass">Pass</option>
													<option avon_val=0 <?= $avon["strong_ownership"] == "Fail" ? "selected" : "" ?> value="Fail">Fail</option>
													<option avon_val=0 <?= $avon["strong_ownership"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt19]" class="form-control" value="<?php echo $avon['cmt19'] ?>" disabled></td>
										</tr>
										<tr>
											<td colspan="2">Enthusiasm</td>
											<td>
												<select class="form-control avon_point customer" name="data[enthusiasm]" disabled>
													<option value="">-Select-</option>
													<option avon_val=1 <?= $avon["enthusiasm"] == "Pass" ? "selected" : "" ?> value="Pass">Pass</option>
													<option avon_val=0 <?= $avon["enthusiasm"] == "Fail" ? "selected" : "" ?> value="Fail">Fail</option>
													<option avon_val=0 <?= $avon["enthusiasm"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt20]" class="form-control" value="<?php echo $avon['cmt20'] ?>" disabled></td>
										</tr>
										<tr>
											<td colspan="2">Tailored Contact</td>
											<td>
												<select class="form-control avon_point customer" name="data[tailored_contact]" disabled>
													<option value="">-Select-</option>
													<option avon_val=1 <?= $avon["tailored_contact"] == "Pass" ? "selected" : "" ?> value="Pass">Pass</option>
													<option avon_val=0 <?= $avon["tailored_contact"] == "Fail" ? "selected" : "" ?> value="Fail">Fail</option>
													<option avon_val=0 <?= $avon["tailored_contact"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt21]" class="form-control" value="<?php echo $avon['cmt21'] ?>" disabled></td>
										</tr>

										<tr>
											<td class="eml" rowspan=5 style="font-weight:bold; background-color:#d6bf91">Business Critical</td>
											<td class="eml" rowspan=1>Avon Security </td>
											<td colspan="2">Avon Security </td>
											<td>
												<select class="form-control avon_point business" name="data[avon_security]" disabled>
													<option value="">-Select-</option>
													<option avon_val=4 <?= $avon["avon_security"] == "Pass" ? "selected" : "" ?> value="Pass">Pass</option>
													<option avon_val=0 <?= $avon["avon_security"] == "Fail" ? "selected" : "" ?> value="Fail">Fail</option>
													<option avon_val=0 <?= $avon["avon_security"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt22]" class="form-control" value="<?php echo $avon['cmt22'] ?>" disabled></td>
										</tr>
										<tr>
											<td class="eml" rowspan=3>Ticket/Email Handling (if Applicable)</td>
											<td colspan="2">Send to the right approver </td>
											<td>
												<select class="form-control avon_point business" name="data[send_right_approver]" disabled>
													<option value="">-Select-</option>
													<option avon_val=1 <?= $avon["send_right_approver"] == "Pass" ? "selected" : "" ?> value="Pass">Pass</option>
													<option avon_val=0 <?= $avon["send_right_approver"] == "Fail" ? "selected" : "" ?> value="Fail">Fail</option>
													<option avon_val=0 <?= $avon["send_right_approver"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt23]" class="form-control" value="<?php echo $avon['cmt23'] ?>" disabled></td>
										</tr>
										<tr>
											<td  colspan="2">Efficiency of Action</td>
											<td>
												<select class="form-control avon_point business" name="data[efficiency_of_action]" disabled>
													<option value="">-Select-</option>
													<option avon_val=1 <?= $avon["efficiency_of_action"] == "Pass" ? "selected" : "" ?> value="Pass">Pass</option>
													<option avon_val=0 <?= $avon["efficiency_of_action"] == "Fail" ? "selected" : "" ?> value="Fail">Fail</option>
													<option avon_val=0 <?= $avon["efficiency_of_action"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt24]" class="form-control" value="<?php echo $avon['cmt24'] ?>" disabled></td>
										</tr>
										<tr>
											<td colspan="2">Documentation</td>
											<td>
												<select class="form-control avon_point business" name="data[documentation]" disabled>
													<option value="">-Select-</option>
													<option avon_val=1 <?= $avon["documentation"] == "Pass" ? "selected" : "" ?> value="Pass">Pass</option>
													<option avon_val=0 <?= $avon["documentation"] == "Fail" ? "selected" : "" ?> value="Fail">Fail</option>
													<option avon_val=0 <?= $avon["documentation"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt25]" class="form-control" value="<?php echo $avon['cmt25'] ?>" disabled></td>
										</tr>


										<tr>
											<td class="eml" rowspan=1>Disposition / Correct Tagging</td>
											<td colspan="2">Use proper disposition and tagging</td>
											<td>
												<select class="form-control avon_point business" name="data[proper_disposition_tagging]" disabled>
													<option value="">-Select-</option>
													<option avon_val=4 <?= $avon["proper_disposition_tagging"] == "Pass" ? "selected" : "" ?> value="Pass">Pass</option>
													<option avon_val=0 <?= $avon["proper_disposition_tagging"] == "Fail" ? "selected" : "" ?> value="Fail">Fail</option>
													<option avon_val=0 <?= $avon["proper_disposition_tagging"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt26]" class="form-control" value="<?php echo $avon['cmt26'] ?>" disabled></td>
										</tr>
										<tr class="fatal">
											<td class="eml" rowspan=2 style="font-weight:bold; background-color:red">FATAL ERROR</td>
											<td class="eml" rowspan=1>CALL/EMAIL/SMS/CHAT/CRM AVOIDANCE</td>
											<td colspan="2">Did the agent resolved the concerns within the interactions?</td>
											<td>
												<select class="form-control avon_point avon_fatal" name="data[resolved_the_concerns]" disabled>
													<option value="">-Select-</option>
													<option avon_val=0 <?= $avon["resolved_the_concerns"] == "Pass" ? "selected" : "" ?> value="Pass">Pass</option>
													<option avon_val=0 <?= $avon["resolved_the_concerns"] == "Fail" ? "selected" : "" ?> value="Fail">Fail</option>
													<option avon_val=0 <?= $avon["resolved_the_concerns"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt27]" class="form-control" value="<?php echo $avon['cmt27'] ?>" disabled></td>
										</tr>
										<tr class="fatal">
											<td class="eml" rowspan=1>Email/SMS/ First response/acknowledge</td>
											<td colspan="2">Did the agent used first response?</td>
											<td>
												<select class="form-control avon_point avon_fatal" name="data[first_response]" disabled>
													<option value="">-Select-</option>
													<option avon_val=0 <?= $avon["first_response"] == "Pass" ? "selected" : "" ?> value="Pass">Pass</option>
													<option avon_val=0 <?= $avon["first_response"] == "Fail" ? "selected" : "" ?> value="Fail">Fail</option>
													<option avon_val=0 <?= $avon["first_response"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
												</select>
											</td>
											<td colspan=2><input type="text" name="data[cmt28]" class="form-control" value="<?php echo $avon['cmt28'] ?>" disabled></td>
										</tr>
									<tr style="font-weight:bold; background-color:#D7BDE2"><td colspan=2>Customer Score</td><td colspan=2>Business Score</td><td colspan=2>Compliance Score</td></tr>
									<tr style="font-weight:bold; background-color:#D7BDE2">
										<td>Earned Point:</td><td ><input type="text" readonly class="form-control" id="customer_earned_score" name="data[customer_earned_score]" value="<?php echo $avon['customer_earned_score'] ?>"></td>
										<td>Earned Point:</td><td ><input type="text" readonly class="form-control" id="business_earned_score" name="data[business_earned_score]" value="<?php echo $avon['business_earned_score'] ?>"></td>
										<td>Earned Point:</td><td ><input type="text" readonly class="form-control" id="compliance_earned_score" name="data[compliance_earned_score]" value="<?php echo $avon['compliance_earned_score'] ?>"></td>
									</tr>
									<tr style="font-weight:bold; background-color:#D7BDE2">
										<td>Possible Point:</td><td ><input type="text" readonly class="form-control" id="customer_possible_score" name="data[customer_possible_score]" value="<?php echo $avon['customer_possible_score'] ?>"></td>
										<td>Possible Point:</td><td ><input type="text" readonly class="form-control" id="business_possible_score" name="data[business_possible_score]" value="<?php echo $avon['business_possible_score'] ?>"></td>
										<td>Possible Point:</td><td ><input type="text" readonly class="form-control" id="compliance_possible_score" name="data[compliance_possible_score]" value="<?php echo $avon['compliance_possible_score'] ?>"></td>
									</tr>
									<tr style="font-weight:bold; background-color:#D7BDE2">
										<td>Overall Percentage:</td><td ><input type="text" readonly class="form-control" id="customer_overall_score" name="data[customer_overall_score]" value="<?php echo $avon['customer_overall_score'] ?>"></td>
										<td>Overall Percentage:</td><td ><input type="text" readonly class="form-control" id="business_overall_score" name="data[business_overall_score]" value="<?php echo $avon['business_overall_score'] ?>"></td>
										<td>Overall Percentage:</td><td ><input type="text" readonly class="form-control" id="compliance_overall_score" name="data[compliance_overall_score]" value="<?php echo $avon['compliance_overall_score'] ?>"></td>
									</tr>	

									<tr>
										<td>Call Summary:</td>
										<td colspan="2"><textarea class="form-control" disabled><?php echo $avon['call_summary'] ?></textarea></td>
										<td>Feedback:</td>
										<td colspan="2"><textarea class="form-control" disabled><?php echo $avon['feedback'] ?></textarea></td>
									</tr>

									<?php if ($avon['attach_file'] != '') { ?>
										<tr oncontextmenu="return false;">
											<td colspan="2">Audio Files</td>
											<td colspan="4">
												<?php $attach_file = explode(",", $avon['attach_file']);
												foreach ($attach_file as $mp) { ?>
													<audio controls='' style="background-color:#607F93">
														<source src="<?php echo base_url(); ?>qa_files/qa_avon/<?php echo $mp; ?>" type="audio/ogg">
														<source src="<?php echo base_url(); ?>qa_files/qa_avon/<?php echo $mp; ?>" type="audio/mpeg">
													</audio> </br>
												<?php } ?>
											</td>
										</tr>
									<?php } ?>

									<tr>
										<td colspan="6" style="background-color:#C5C8C8"></td>
									</tr>

									<tr>
										<td style="font-size:16px">Manager Review:</td>
										<td colspan="5" style="text-align:left"><?php echo $avon['mgnt_rvw_note'] ?></td>
									</tr>
									<tr>
										<td style="font-size:16px">Client Review:</td>
										<td colspan="5" style="text-align:left"><?php echo $avon['client_rvw_note'] ?></td>
									</tr>

									<tr>
										<td colspan="6" style="background-color:#C5C8C8"></td>
									</tr>

									<form id="form_agent_user" method="POST" action="">
										<input type="hidden" name="pnid" class="form-control" value="<?php echo $pnid; ?>">

										<tr>
											<td colspan=2 style="font-size:16px">Feedback Acceptance:<span style="font-size:24px;color:red">*</span></td>
											<td colspan=2>
												<select class="form-control" id="" name="agnt_fd_acpt" required>
													<option value="">--Select--</option>
													<option <?php echo $avon['agnt_fd_acpt'] == 'Acceptance' ? "selected" : ""; ?> value="Acceptance">Acceptance</option>
													<option <?php echo $avon['agnt_fd_acpt'] == 'Not Acceptance' ? "selected" : ""; ?> value="Not Acceptance">Not Acceptance</option>
												</select>
											</td>
										</tr>
										<tr>
											<td colspan=2 style="font-size:16px">Your Review:<span style="font-size:24px;color:red">*</span></td>
											<td colspan=4><textarea class="form-control" name="note" required><?php echo $avon['agent_rvw_note'] ?></textarea></td>
										</tr>

										<?php if (is_access_qa_agent_module() == true) {
											if (is_available_qa_feedback($avon['entry_date'], 72) == true) { ?>
												<tr>
													<?php if ($avon['agent_rvw_note'] == '') { ?>
														<td colspan="6"><button class="btn btn-success waves-effect" type="submit" id='btnagentSave' name='btnSave' value="SAVE" style="width:500px">SAVE</button></td>
													<?php } ?>
												</tr>
										<?php }
										} ?>

									</form>

								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>

			</form>
		</div>

	</section>
</div>