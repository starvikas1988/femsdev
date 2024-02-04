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
										<td>QA Name:</td>
										<?php if ($avon['entry_by'] != '') {
											$auditorName = $avon['auditor_name'];
										} else {
											$auditorName = $avon['client_name'];
										} ?>
										<td><input type="text" class="form-control" value="<?php echo $auditorName; ?>" disabled></td>
										<td>Audit Date:</td>
										<td><input type="text" class="form-control" value="<?php echo mysql2mmddyy($avon['audit_date']); ?>" disabled></td>
										<td>Call Date:</td>
										<td><input type="text" class="form-control" value="<?php echo mysql2mmddyy($avon['call_date']); ?>" disabled></td>
									</tr>
									<tr>
										<td>Agent:</td>
										<td>
											<select class="form-control" disabled>
												<option><?php echo $avon['fname'] . " " . $avon['lname'] ?></option>
											</select>
										</td>
										<td>Fusion ID:</td>
										<td><input type="text" class="form-control" value="<?php echo $avon['fusion_id'] ?>" disabled></td>
										<td>L1 Supervisor:</td>
										<td>
											<select class="form-control" disabled>
												<option><?php echo $avon['tl_name'] ?></option>
											</select>
										</td>
									</tr>
									<tr>
										<td colspan="2">Call Duration:</td>
										<td colspan="2"><input type="text" class="form-control" id="call_duration" name="data[call_duration]" value="<?php echo $avon['call_duration'] ?>" disabled></td>
										<td>Type of Call:</td>
										<td><input type="text" class="form-control" name="data[call_type]" value="<?php echo $avon['call_type'] ?>" disabled></td>
									</tr>
									<tr>
										<td colspan="2">Digital/Non Digital</td>
										<td colspan="2">
											<input type="text" disabled name="data[digital_non_digital]" value="<?=$avon['digital_non_digital']?>" class="form-control"/>
										</td>
										<td>Week</td>
										<td>
											<input type="text" disabled value="<?= $avon['week']?>" name="data[week]" class="form-control"/>
										</td>
									</tr>
									<tr>
										<td>Audit Type:</td>
										<td><select class="form-control" disabled>
												<option><?php echo $avon['audit_type'] ?></option>
											</select></td>
										<td>VOC:</td>
										<td><select class="form-control" disabled>
												<option><?php echo $avon['voc'] ?></option>
											</select></td>
										<td class="auType">Auditor Type</td>
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
										<td>PARAMETER</td>
										<td colspan=2>SUB PARAMETER</td>
										<td>STATUS</td>
										<td colspan=2>REMARKS</td>
									</tr>
									<tr>
										<td class="eml" rowspan=3>Opening Spiel</td>
										<td colspan=2>Verbatim Opening</td>
										<td>
											<select class="form-control avon_point" name="data[opening_spiel_verbatim_opening]" required disabled>
												<option value="">-Select-</option>
												<option avon_val=1 <?php echo $avon['opening_spiel_verbatim_opening'] == "Yes" ? "selected" : ""; ?> value="Yes">Yes</option>
												<option avon_val=0 <?php echo $avon['opening_spiel_verbatim_opening'] == "No" ? "selected" : ""; ?> value="No">No</option>
												<option avon_val=0 <?php echo $avon['opening_spiel_verbatim_opening'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" name="data[cmt1]" class="form-control" value="<?php echo $avon['cmt1'] ?>" disabled></td>
									</tr>
									<tr>
										<td colspan=2>Rate Of Speech</td>
										<td>
											<select class="form-control avon_point" name="data[opening_spiel_rate_of_speech]" required disabled>
												<option value="">-Select-</option>
												<option avon_val=3 <?php echo $avon['opening_spiel_rate_of_speech'] == "Yes" ? "selected" : ""; ?> value="Yes">Yes</option>
												<option avon_val=0 <?php echo $avon['opening_spiel_rate_of_speech'] == "No" ? "selected" : ""; ?> value="No">No</option>
												<option avon_val=0 <?php echo $avon['opening_spiel_rate_of_speech'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" name="data[cmt2]" class="form-control" value="<?php echo $avon['cmt2'] ?>" disabled></td>
									</tr>
									<tr>
										<td colspan="2">Clarity and Tone</td>
										<td>
											<select class="form-control avon_point" name="data[opening_spiel_clarity_and_tone]" required disabled>
												<option value="">-Select-</option>
												<option avon_val=3 <?= $avon["opening_spiel_clarity_and_tone"] == "Yes" ? "selected" : "" ?> value="Yes">Yes</option>
												<option avon_val=0 <?= $avon["opening_spiel_clarity_and_tone"] == "No" ? "selected" : "" ?> value="No">No</option>
												<option avon_val=0 <?= $avon["opening_spiel_clarity_and_tone"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" name="data[cmt3]" class="form-control" value="<?php echo $avon['cmt3'] ?>" disabled></td>
									</tr>
									<tr>
										<td class="eml" colspan="3">Assurance Statement</td>
										<td>
											<select class="form-control avon_point" name="data[assurance_statement]" required disabled>
												<option value="">-Select-</option>
												<option avon_val=3 <?= $avon["assurance_statement"] == "Yes" ? "selected" : "" ?> value="Yes">Yes</option>
												<option avon_val=0 <?= $avon["assurance_statement"] == "No" ? "selected" : "" ?> value="No">No</option>
												<option avon_val=0 <?= $avon["assurance_statement"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" name="data[cmt4]" class="form-control" value="<?php echo $avon['cmt4'] ?>" disabled></td>
									</tr>
									<tr>
										<td class="eml" colspan="3">Appropriate Acknowledgement</td>
										<td>
											<select class="form-control avon_point" name="data[appropriate_acknowledgement]" required disabled>
												<option value="">-Select-</option>
												<option avon_val=3 <?= $avon["appropriate_acknowledgement"] == "Yes" ? "selected" : "" ?> value="Yes">Yes</option>
												<option avon_val=0 <?= $avon["appropriate_acknowledgement"] == "No" ? "selected" : "" ?> value="No">No</option>
												<option avon_val=0 <?= $avon["appropriate_acknowledgement"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" name="data[cmt5]" class="form-control" value="<?php echo $avon['cmt5'] ?>" disabled></td>
									</tr>
									<tr>
										<td rowspan="4" class="eml">Customer Service</td>
										<td colspan="2">Interruption</td>
										<td>
											<select class="form-control avon_point" name="data[customer_service_interruption]" required disabled>
												<option value="">-Select-</option>
												<option avon_val=3 <?= $avon["customer_service_interruption"] == "Yes" ? "selected" : "" ?> value="Yes">Yes</option>
												<option avon_val=0 <?= $avon["customer_service_interruption"] == "No" ? "selected" : "" ?> value="No">No</option>
												<option avon_val=0 <?= $avon["customer_service_interruption"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" name="data[cmt6]" class="form-control" value="<?php echo $avon['cmt6'] ?>" disabled></td>
									</tr>
									<tr>
										<td colspan="2">Polite Words/Professionalism</td>
										<td>
											<select class="form-control avon_point" name="data[customer_service_polite_words_professionalism]" required disabled>
												<option value="">-Select-</option>
												<option avon_val=3 <?= $avon["customer_service_polite_words_professionalism"] == "Yes" ? "selected" : "" ?> value="Yes">Yes</option>
												<option avon_val=0 <?= $avon["customer_service_polite_words_professionalism"] == "No" ? "selected" : "" ?> value="No">No</option>
												<option avon_val=0 <?= $avon["customer_service_polite_words_professionalism"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" name="data[cmt7]" class="form-control" value="<?php echo $avon['cmt7'] ?>" disabled></td>
									</tr>
									<tr>
										<td colspan="2">Personalization</td>
										<td>
											<select class="form-control avon_point" name="data[customer_service_personalization]" required disabled>
												<option value="">-Select-</option>
												<option avon_val=3 <?= $avon["customer_service_personalization"] == "Yes" ? "selected" : "" ?> value="Yes">Yes</option>
												<option avon_val=0 <?= $avon["customer_service_personalization"] == "No" ? "selected" : "" ?> value="No">No</option>
												<option avon_val=0 <?= $avon["customer_service_personalization"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" name="data[cmt8]" class="form-control" value="<?php echo $avon['cmt8'] ?>" disabled></td>
									</tr>
									<tr>
										<td colspan="2">Enthusiasm</td>
										<td>
											<select class="form-control avon_point" name="data[customer_service_enthusiasm]" required disabled>
												<option value="">-Select-</option>
												<option avon_val=3 <?= $avon["customer_service_enthusiasm"] == "Yes" ? "selected" : "" ?> value="Yes">Yes</option>
												<option avon_val=0 <?= $avon["customer_service_enthusiasm"] == "No" ? "selected" : "" ?> value="No">No</option>
												<option avon_val=0 <?= $avon["customer_service_enthusiasm"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" name="data[cmt9]" class="form-control" value="<?php echo $avon['cmt9'] ?>" disabled></td>
									</tr>
									<tr>
										<td class="eml" colspan="3">Hold Procedure</td>
										<td>
											<select class="form-control avon_point" name="data[hold_procedure]" required disabled>
												<option value="">-Select-</option>
												<option avon_val=1 <?= $avon["hold_procedure"] == "Yes" ? "selected" : "" ?> value="Yes">Yes</option>
												<option avon_val=0 <?= $avon["hold_procedure"] == "No" ? "selected" : "" ?> value="No">No</option>
												<option avon_val=0 <?= $avon["hold_procedure"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" name="data[cmt10]" class="form-control" value="<?php echo $avon['cmt10'] ?>" disabled></td>
									</tr>
									<tr>
										<td colspan="3" class="eml">Dead Air</td>
										<td>
											<select class="form-control avon_point" name="data[dead_air]" required disabled>
												<option value="">-Select-</option>
												<option avon_val=1 <?= $avon["dead_air"] == "Yes" ? "selected" : "" ?> value="Yes">Yes</option>
												<option avon_val=0 <?= $avon["dead_air"] == "No" ? "selected" : "" ?> value="No">No</option>
												<option avon_val=0 <?= $avon["dead_air"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" name="data[cmt11]" class="form-control" value="<?php echo $avon['cmt11'] ?>" disabled></td>
									</tr>
									<tr>
										<td colspan="3" class="eml">Probing Question (If Available)</td>
										<td>
											<select class="form-control avon_point" name="data[probing_question_if_applicable]" required disabled>
												<option value="">-Select-</option>
												<option avon_val=3 <?= $avon["probing_question_if_applicable"] == "Yes" ? "selected" : "" ?> value="Yes">Yes</option>
												<option avon_val=0 <?= $avon["probing_question_if_applicable"] == "No" ? "selected" : "" ?> value="No">No</option>
												<option avon_val=0 <?= $avon["probing_question_if_applicable"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" name="data[cmt12]" class="form-control" value="<?php echo $avon['cmt12'] ?>" disabled></td>
									</tr>
									<tr>
										<td colspan="3" class="eml">Listening Skills</td>
										<td>
											<select class="form-control avon_point" name="data[listening_skills]" required disabled>
												<option value="">-Select-</option>
												<option avon_val=3 <?= $avon["listening_skills"] == "Yes" ? "selected" : "" ?> value="Yes">Yes</option>
												<option avon_val=0 <?= $avon["listening_skills"] == "No" ? "selected" : "" ?> value="No">No</option>
												<option avon_val=0 <?= $avon["listening_skills"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" name="data[cmt13]" class="form-control" value="<?php echo $avon['cmt13'] ?>" disabled></td>
									</tr>
									<tr>
										<td colspan="3">Ghost Spiel</td>
										<td>
											<select class="form-control avon_point" name="data[ghost_spiel]" required disabled>
												<option value="">-Select-</option>
												<option avon_val=2 <?= $avon["ghost_spiel"] == "Yes" ? "selected" : "" ?> value="Yes">Yes</option>
												<option avon_val=0 <?= $avon["ghost_spiel"] == "No" ? "selected" : "" ?> value="No">Yes</option>
												<option avon_val=0 <?= $avon["ghost_spiel"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" name="data[cmt14]" class="form-control" value="<?php echo $avon['cmt14'] ?>" disabled></td>
									</tr>
									<tr>
										<td colspan="3">Bad Line Spiel</td>
										<td>
											<select class="form-control avon_point" name="data[bad_line_spiel]" required disabled>
												<option value="">-Select-</option>
												<option avon_val=2 <?= $avon["bad_line_spiel"] == "Yes" ? "selected" : "" ?> value="Yes">Yes</option>
												<option avon_val=0 <?= $avon["bad_line_spiel"] == "No" ? "selected" : "" ?> value="No">No</option>
												<option avon_val=0 <?= $avon["bad_line_spiel"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" name="data[cmt15]" class="form-control" value="<?php echo $avon['cmt15'] ?>" disabled></td>
									</tr>
									<tr>
										<td colspan="3">Profanity Spiel</td>
										<td>
											<select class="form-control avon_point" name="data[profanity_spiel]" required disabled>
												<option value="">-Select-</option>
												<option avon_val=2 <?= $avon["profanity_spiel"] == "Yes" ? "selected" : "" ?> value="Yes">Yes</option>
												<option avon_val=0 <?= $avon["profanity_spiel"] == "No" ? "selected" : "" ?> value="No">No</option>
												<option avon_val=0 <?= $avon["profanity_spiel"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" name="data[cmt16]" class="form-control" value="<?php echo $avon['cmt16'] ?>" disabled></td>
									</tr>
									<tr>
										<td colspan="3">Others</td>
										<td>
											<select class="form-control avon_point" name="data[others]" required disabled>
												<option value="">-Select-</option>
												<option avon_val=1 <?= $avon["others"] == "Yes" ? "selected" : "" ?> value="Yes">Yes</option>
												<option avon_val=0 <?= $avon["others"] == "No" ? "selected" : "" ?> value="No">No</option>
												<option avon_val=0 <?= $avon["others"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" name="data[cmt17]" class="form-control" value="<?php echo $avon['cmt17'] ?>" disabled></td>
									</tr>
									<tr>
										<td class="eml" colspan="3">Request Documents (If Applicable)</td>
										<td>
											<select class="form-control avon_point" name="data[request_documents_if_applicable]" required disabled>
												<option value="">-Select-</option>
												<option avon_val=5 <?= $avon["request_documents_if_applicable"] == "Yes" ? "selected" : "" ?> value="Yes">Yes</option>
												<option avon_val=0 <?= $avon["request_documents_if_applicable"] == "No" ? "selected" : "" ?> value="No">No</option>
												<option avon_val=0 <?= $avon["request_documents_if_applicable"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" name="data[cmt18]" class="form-control" value="<?php echo $avon['cmt18'] ?>" disabled></td>
									</tr>
									<tr>
										<td class="eml" colspan="3">Ticket/Email Handling (If Applicable)</td>
										<td>
											<select class="form-control avon_point" name="data[ticket_email_handling_if_applicable]" required disabled>
												<option value="">-Select-</option>
												<option avon_val=0 <?= $avon["ticket_email_handling_if_applicable"] == "Yes" ? "selected" : "" ?> value="Yes">Yes</option>
												<option avon_val=0 <?= $avon["ticket_email_handling_if_applicable"] == "No" ? "selected" : "" ?> value="No">No</option>
												<option avon_val=0 <?= $avon["ticket_email_handling_if_applicable"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" name="data[cmt19]" class="form-control" value="<?php echo $avon['cmt19'] ?>" disabled></td>
									</tr>
									<tr>
										<td class="eml" rowspan="2">Information Shared</td>
										<td colspan="2">Incomplete Information</td>
										<td>
											<select class="form-control avon_point" name="data[information_shared_incomplete]" required disabled>
												<option value="">-Select-</option>
												<option avon_val=10 <?= $avon["information_shared_incomplete"] == "Yes" ? "selected" : "" ?> value="Yes">Yes</option>
												<option avon_val=0 <?= $avon["information_shared_incomplete"] == "No" ? "selected" : "" ?> value="No">No</option>
												<option avon_val=0 <?= $avon["information_shared_incomplete"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" name="data[cmt20]" class="form-control" value="<?php echo $avon['cmt20'] ?>" disabled></td>
									</tr>
									<tr>
										<td colspan="2">Inaccurate Information</td>
										<td>
											<select class="form-control avon_point" name="data[information_shared_inaccurate]" required disabled>
												<option value="">-Select-</option>
												<option avon_val=10 <?= $avon["information_shared_inaccurate"] == "Yes" ? "selected" : "" ?> value="Yes">Yes</option>
												<option avon_val=0 <?= $avon["information_shared_inaccurate"] == "No" ? "selected" : "" ?> value="No">No</option>
												<option avon_val=0 <?= $avon["information_shared_inaccurate"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" name="data[cmt21]" class="form-control" value="<?php echo $avon['cmt21'] ?>" disabled></td>
									</tr>
									<tr>
										<td rowspan="5" class="eml">First Call Resolution</td>
										<td colspan="2">Information Shared</td>
										<td rowspan="5">
											<select class="form-control avon_point" name="data[first_call_resolution]" required disabled>
												<option value="">-Select-</option>
												<option avon_val=5 <?= $avon["first_call_resolution"] == "Yes" ? "selected" : "" ?> value="Yes">Yes</option>
												<option avon_val=0 <?= $avon["first_call_resolution"] == "No" ? "selected" : "" ?> value="No">No</option>
												<option avon_val=0 <?= $avon["first_call_resolution"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
											</select>
										</td>
										<td rowspan="5" colspan="2">
											<input type="text" name="data[cmt22]" class="form-control" value="<?php echo $avon['cmt22'] ?>" disabled>
										</td>
									</tr>
									<tr>
										<td colspan="2">Failed to Escalate</td>
									</tr>
									<tr>
										<td colspan="2">Confidence</td>
									</tr>
									<tr>
										<td colspan="2">Failed to call the customer back</td>
									</tr>
									<tr>
										<td colspan="2">Others</td>
									</tr>
									<tr>
										<td colspan="3" class="eml">Disposition</td>
										<td>
											<select class="form-control avon_point" name="data[disposition]" required disabled>
												<option value="">-Select-</option>
												<option avon_val=3 <?= $avon["disposition"] == "Yes" ? "selected" : "" ?> value="Yes">Yes</option>
												<option avon_val=0 <?= $avon["disposition"] == "No" ? "selected" : "" ?> value="No">No</option>
												<option avon_val=0 <?= $avon["disposition"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" name="data[cmt23]" class="form-control" value="<?php echo $avon['cmt23'] ?>" disabled></td>
									</tr>
									<tr>
										<td colspan="3" class="eml">Additional Assistance</td>
										<td>
											<select class="form-control avon_point" name="data[additional_assistance]" required disabled>
												<option value="">-Select-</option>
												<option avon_val=1 <?= $avon["additional_assistance"] == "Yes" ? "selected" : "" ?> value="Yes">Yes</option>
												<option avon_val=0 <?= $avon["additional_assistance"] == "No" ? "selected" : "" ?> value="No">No</option>
												<option avon_val=0 <?= $avon["additional_assistance"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" name="data[cmt24]" class="form-control" value="<?php echo $avon['cmt24'] ?>" disabled></td>
									</tr>
									<tr>
										<td colspan="3" class="eml">Closing Spiel</td>
										<td>
											<select class="form-control avon_point" name="data[closing_spiel]" required disabled>
												<option value="">-Select-</option>
												<option avon_val=5 <?= $avon["closing_spiel"] == "Yes" ? "selected" : "" ?> value="Yes">Yes</option>
												<option avon_val=0 <?= $avon["closing_spiel"] == "No" ? "selected" : "" ?> value="No">No</option>
												<option avon_val=0 <?= $avon["closing_spiel"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" name="data[cmt25]" class="form-control" value="<?php echo $avon['cmt25'] ?>" disabled></td>
									</tr>
									<tr>
										<td colspan="3" class="eml">Avon Security (If Applicable)</td>
										<td>
											<select class="form-control avon_point" name="data[avon_security_if_applicable]" required disabled>
												<option value="">-Select-</option>
												<option avon_val=5 <?= $avon["avon_security_if_applicable"] == "Yes" ? "selected" : "" ?> value="Yes">Yes</option>
												<option avon_val=0 <?= $avon["avon_security_if_applicable"] == "No" ? "selected" : "" ?> value="No">No</option>
												<option avon_val=0 <?= $avon["avon_security_if_applicable"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" name="data[cmt26]" class="form-control" value="<?php echo $avon['cmt26'] ?>" disabled></td>
									</tr>
									<tr class="fatal">
										<td colspan="3" class="eml">Late Opening</td>
										<td>
											<select class="form-control avon_point avon_fatal" name="data[late_opening]" required disabled>
												<option value="">-Select-</option>
												<option avon_val=0 <?= $avon["late_opening"] == "Yes" ? "selected" : "" ?> value="Yes">Yes</option>
												<option avon_val=0 <?= $avon["late_opening"] == "No" ? "selected" : "" ?> value="No">No</option>
												<option avon_val=0 <?= $avon["late_opening"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" name="data[cmt27]" class="form-control" value="<?php echo $avon['cmt27'] ?>" disabled></td>
									</tr>
									<tr class="fatal">
										<td colspan="3" class="eml">Rudeness</td>
										<td>
											<select class="form-control avon_point avon_fatal" name="data[rudeness]" required disabled>
												<option value="">-Select-</option>
												<option avon_val=0 <?= $avon["rudeness"] == "Yes" ? "selected" : "" ?> value="Yes">Yes</option>
												<option avon_val=0 <?= $avon["rudeness"] == "No" ? "selected" : "" ?> value="No">No</option>
												<option avon_val=0 <?= $avon["rudeness"] == "N/A" ? "selected" : "" ?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" name="data[cmt28]" class="form-control" value="<?php echo $avon['cmt28'] ?>" disabled></td>
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
											<td colspan=2 style="font-size:16px">Feedback Acceptance</td>
											<td colspan=2>
												<select class="form-control" id="" name="agnt_fd_acpt" required>
													<option value="">--Select--</option>
													<option <?php echo $avon['agnt_fd_acpt'] == 'Acceptance' ? "selected" : ""; ?> value="Acceptance">Acceptance</option>
													<option <?php echo $avon['agnt_fd_acpt'] == 'Not Acceptance' ? "selected" : ""; ?> value="Not Acceptance">Not Acceptance</option>
												</select>
											</td>
										</tr>
										<tr>
											<td colspan=2 style="font-size:16px">Your Review</td>
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