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
	font-weight:bold;
	background-color:#85C1E9;
}

.eml1{
	font-weight:bold;
	background-color:#76D7C4;
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
									<tr>
										<td colspan="7" id="theader" style="font-size:40px">Premier Health Solutions [Email Version 2]</td>
										<input type="hidden" name="audit_start_time" value="<?php echo CurrMySqlDate(); ?>">
									</tr>
									<tr>
										<td>Auditor Name:<span style="font-size:24px;color:red">*</span></td>
										<?php if($phs_email_v2['entry_by']!=''){
												$auditorName = $phs_email_v2['auditor_name'];
											}else{
												$auditorName = $phs_email_v2['client_name'];
										} ?>
										<td><input type="text" class="form-control" value="<?php echo $auditorName; ?>" disabled></td>
										<td>Audit Date:<span style="font-size:24px;color:red">*</span></td>
										<td colspan="2"><input type="text" class="form-control" value="<?php echo mysql2mmddyy($phs_email_v2['audit_date']); ?>" disabled></td>
										<td>Email Date:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control" value="<?php echo mysql2mmddyy($phs_email_v2['call_date']); ?>" disabled></td>
									</tr>
									<tr>
										<td>Agent:<span style="font-size:24px;color:red">*</span></td>
										<td>
											<select class="form-control" disabled>
												<option><?php echo $phs_email_v2['fname']." ".$phs_email_v2['lname'] ?></option>
											</select>
										</td>
										<td>Fusion ID:<span style="font-size:24px;color:red">*</span></td>
										<td colspan="2"><input type="text" class="form-control" value="<?php echo $phs_email_v2['fusion_id'] ?>" disabled></td>
										<td>L1 Supervisor:<span style="font-size:24px;color:red">*</span></td>
										<td>
											<select class="form-control" disabled>
												<option><?php echo $phs_email_v2['tl_name'] ?></option>	
											</select>
										</td>
									</tr>
									<tr>
										<td>Channel:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control" value="<?php echo $phs_email_v2['channel'] ?>" disabled></td>
										<td>File Number:<span style="font-size:24px;color:red">*</span></td>
										<td colspan="2"><input type="text" class="form-control" value="<?php echo $phs_email_v2['file_no'] ?>" disabled></td>
										<td>Time stamp/ Link:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control" value="<?php echo $phs_email_v2['link'] ?>" disabled></td>
									</tr>
									<tr>
										<td>ACPT:<span style="font-size:24px;color:red">*</span></td>
										<td><select class="form-control" disabled><option><?php echo $phs_email_v2['acpt'] ?></option></select></td>
										<td>ZTP:<span style="font-size:24px;color:red">*</span></td>
										<td colspan="2"><select class="form-control" disabled><option><?php echo $phs_email_v2['ztp'] ?></option></select></td>
										<td>Member ID:<span style="font-size:24px;color:red">*</span></td>
										<td><input type="text" class="form-control" value="<?php echo $phs_email_v2['member_id'] ?>" disabled></td>
									</tr>
									<tr>
										<td>Email Type:<span style="font-size:24px;color:red">*</span></td>
										<td>
											<select class="form-control" name="data[call_type]" disabled>
											<option><?php echo $phs_email_v2['call_type'] ?></option>
											</select>
										</td>
									  <td>Caller Type:<span style="font-size:24px;color:red">*</span></td>
										<td colspan="2"><select class="form-control" disabled><option><?php echo $phs_email_v2['caller_type'] ?></option></select></td>
										<td>PHS Product/Agency:<span style="font-size:24px;color:red">*</span></td>
										<td><select class="form-control" disabled><option><?php echo $phs_email_v2['product_agency'] ?></option></select></td>
									</tr>
									<tr>
										<td>Audit Type:<span style="font-size:24px;color:red">*</span></td>
										<td><select class="form-control" disabled><option><?php echo $phs_email_v2['audit_type'] ?></option></select></td>
										<td>VOC:<span style="font-size:24px;color:red">*</span></td>
										<td colspan="2"><select class="form-control" disabled><option><?php echo $phs_email_v2['voc'] ?></option></select></td>
										<td>Language:<span style="font-size:24px;color:red">*</span></td>
										<td><select class="form-control" disabled><option><?php echo $phs_email_v2['language'] ?></option></select></td>
									</tr>
									<tr>
										<td style="font-weight:bold; font-size:16px">Possible Score:</td>
										<td><input type="text" readonly id="phs_chatemail_possible" name="data[possible_score]" class="form-control" style="font-weight:bold" value="<?php echo $phs_email_v2['possible_score'] ?>"></td>
										<td style="font-weight:bold; font-size:16px">Earned Score:</td>
										<td colspan="2"><input type="text" readonly id="phs_chatemail_earned" name="data[earned_score]" class="form-control" style="font-weight:bold" value="<?php echo $phs_email_v2['earned_score'] ?>"></td>
										<td style="font-weight:bold; font-size:16px; text-align:right">Overall Score:</td>
										<td colspan="2"><input type="text" readonly id="phs_chatemail_overall" name="data[overall_score]" class="form-control phs_chatemail_v2Fatal" style="font-weight:bold" value="<?php echo $phs_email_v2['overall_score'] ?>"></td>
									</tr>
									<tr style="height:18px; font-weight:bold"><td colspan=7 class="prm1">Critical / Immediate Fail</td></tr>
									<tr>
										<td class="prm1">1</td>
										<td class="eml1" colspan=2 style="color:red">Did the CSR adhere to all of the Security Policies of the member's account?</td>
										<td>
											<select class="form-control chatemail_pnt" id ="ajioAF1" name="data[csr_adhere]" disabled>
												<option value="">-Select-</option>
												<option phs_val=10 phs_max="10" <?php echo $phs_email_v2['csr_adhere'] == "Completely"?"selected":"";?> value="Completely">Completely</option>
												<option phs_val=5 phs_max="10"<?php echo $phs_email_v2['csr_adhere'] == "Partially"?"selected":"";?> value="Partially">Partially</option>
												<option phs_val=0 phs_max="10"<?php echo $phs_email_v2['csr_adhere'] == "Fatal"?"selected":"";?> value="Fatal">Fatal</option>
												<option phs_val=0 phs_max="10"<?php echo $phs_email_v2['csr_adhere'] == "TBD"?"selected":"";?> value="TBD">TBD</option>
												<option phs_val=0 phs_max="10"<?php echo $phs_email_v2['csr_adhere'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td>H</td>
										<td>10</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt1]" value="<?php echo $phs_email_v2['cmt1'] ?>" disabled></td>
									</tr>
									<tr>
										<td class="prm1">2</td>
										<td class="eml1" colspan=2 style="color:red">Entered Interaction Notes in E123 </td>
										<td>
											<select class="form-control chatemail_pnt" id ="ajioAF2" name="data[entraction_notes]" disabled>
												<option value="">-Select-</option>
												<option phs_val=10 phs_max="10"<?php echo $phs_email_v2['entraction_notes'] == "Completely"?"selected":"";?> value="Completely">Completely</option>
												<option phs_val=5 phs_max="10"<?php echo $phs_email_v2['entraction_notes'] == "Partially"?"selected":"";?> value="Partially">Partially</option>
												<option phs_val=0 phs_max="10"<?php echo $phs_email_v2['entraction_notes'] == "Fatal"?"selected":"";?> value="Fatal">Fatal</option>
												<option phs_val=0 phs_max="10"<?php echo $phs_email_v2['entraction_notes'] == "TBD"?"selected":"";?> value="TBD">TBD</option>
												<option phs_val=0 phs_max="10"<?php echo $phs_email_v2['entraction_notes'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td>H</td>
										<td>10</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt2]" value="<?php echo $phs_email_v2['cmt2'] ?>" disabled></td>
									</tr>
									<tr>
										<td class="prm1">3</td>
										<td class="eml1" colspan=2 style="color:red">Did the CSR follow the Policy/Procedure correctly</td>
										<td>
											<select class="form-control chatemail_pnt" id ="ajioAF3"name="data[csr_policy]" disabled>
												<option value="">-Select-</option>
												<option phs_val=10 phs_max="10"<?php echo $phs_email_v2['csr_policy'] == "Completely"?"selected":"";?> value="Completely">Completely</option>
												<option phs_val=5 phs_max="10"<?php echo $phs_email_v2['csr_policy'] == "Partially"?"selected":"";?> value="Partially">Partially</option>
												<option phs_val=0 phs_max="10"<?php echo $phs_email_v2['csr_policy'] == "Fatal"?"selected":"";?> value="Fatal">Fatal</option>
												<option phs_val=0 phs_max="10"<?php echo $phs_email_v2['csr_policy'] == "TBD"?"selected":"";?> value="TBD">TBD</option>
												<option phs_val=0 phs_max="10"<?php echo $phs_email_v2['csr_policy'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td>H</td>
										<td>10</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt3]" value="<?php echo $phs_email_v2['cmt3'] ?>" disabled></td>
									</tr>
									<tr>
										<td class="prm1">4</td>
										<td class="eml1" colspan=2 style="color:red">Was the reason for the email addressed fully according to policy?</td>
										<td>
											<select class="form-control chatemail_pnt" id ="ajioAF4" name="data[reason_for_email]" disabled>
												<option value="">-Select-</option>
												<option phs_val=10 phs_max="10"<?php echo $phs_email_v2['reason_for_email'] == "Completely"?"selected":"";?> value="Completely">Completely</option>
												<option phs_val=5 phs_max="10"<?php echo $phs_email_v2['reason_for_email'] == "Partially"?"selected":"";?> value="Partially">Partially</option>
												<option phs_val=0 phs_max="10"<?php echo $phs_email_v2['reason_for_email'] == "Fatal"?"selected":"";?> value="Fatal">Fatal</option>
												<option phs_val=0 phs_max="10"<?php echo $phs_email_v2['reason_for_email'] == "TBD"?"selected":"";?> value="TBD">TBD</option>
												<option phs_val=0 phs_max="10"<?php echo $phs_email_v2['reason_for_email'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td>H</td>
										<td>10</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt4]" value="<?php echo $phs_email_v2['cmt4'] ?>" disabled></td>
									</tr>
									<tr>
										<td class="prm1">5</td>
										<td class="eml1" colspan=2 style="color:red">Did the CSR provide accurate information? (Correct information given without liability impact)</td>
										<td>
											<select class="form-control chatemail_pnt" id ="ajioAF5"name="data[accurate_information]" disabled>
												<option value="">-Select-</option>
												<option phs_val=10 phs_max="10"<?php echo $phs_email_v2['accurate_information'] == "Completely"?"selected":"";?> value="Completely">Completely</option>
												<option phs_val=5 phs_max="10"<?php echo $phs_email_v2['accurate_information'] == "Partially"?"selected":"";?> value="Partially">Partially</option>
												<option phs_val=0 phs_max="10"<?php echo $phs_email_v2['accurate_information'] == "Fatal"?"selected":"";?> value="Fatal">Fatal</option>
												<option phs_val=0 phs_max="10"<?php echo $phs_email_v2['accurate_information'] == "TBD"?"selected":"";?> value="TBD">TBD</option>
												<option phs_val=0 phs_max="10"<?php echo $phs_email_v2['accurate_information'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td>H</td>
										<td>10</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt5]" value="<?php echo $phs_email_v2['cmt5'] ?>" disabled></td>
									</tr>
									<tr>
										<td class="prm1">6</td>
										<td class="eml1" colspan=2 style="color:red">Was the email composed correctly?</td>
										<td>
											<select class="form-control chatemail_pnt" id ="ajioAF6" name="data[email_composed]" disabled>
												<option value="">-Select-</option>
												<option phs_val=10 phs_max="10"<?php echo $phs_email_v2['email_composed'] == "Completely"?"selected":"";?> value="Completely">Completely</option>
												<option phs_val=5 phs_max="10"<?php echo $phs_email_v2['email_composed'] == "Partially"?"selected":"";?> value="Partially">Partially</option>
												<option phs_val=0 phs_max="10"<?php echo $phs_email_v2['email_composed'] == "Fatal"?"selected":"";?> value="Fatal">Fatal</option>
												<option phs_val=0 phs_max="10"<?php echo $phs_email_v2['email_composed'] == "TBD"?"selected":"";?> value="TBD">TBD</option>
												<option phs_val=0 phs_max="10"<?php echo $phs_email_v2['email_composed'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td>H</td>
										<td>10</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt6]" value="<?php echo $phs_email_v2['cmt6'] ?>" disabled></td>
									</tr>
									<tr>
										<td class="prm1">7</td>
										<td class="eml1" colspan=2 style="color:red">Did the CSR reply to the email during the standard time allowed</td>
										<td>
											<select class="form-control chatemail_pnt" id ="ajioAF7" name="data[standard_time]" disabled>
												<option value="">-Select-</option>
												<option phs_val=10 phs_max="10"<?php echo $phs_email_v2['standard_time'] == "Completely"?"selected":"";?> value="Completely">Completely</option>
												<option phs_val=5 phs_max="10"<?php echo $phs_email_v2['standard_time'] == "Partially"?"selected":"";?> value="Partially">Partially</option>
												<option phs_val=0 phs_max="10"<?php echo $phs_email_v2['standard_time'] == "Fatal"?"selected":"";?> value="Fatal">Fatal</option>
												<option phs_val=0 phs_max="10"<?php echo $phs_email_v2['standard_time'] == "TBD"?"selected":"";?> value="TBD">TBD</option>
												<option phs_val=0 phs_max="10"<?php echo $phs_email_v2['standard_time'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td>H</td>
										<td>10</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt7]" value="<?php echo $phs_email_v2['cmt7'] ?>" disabled></td>
									</tr>
									<tr style="height:18px; font-weight:bold"><td colspan=7 class="prm1">Rapport</td></tr>
									<tr>
										<td class="prm1">8</td>
										<td class="eml1" colspan=2>Active Reading</td>
										<td>
											<select class="form-control chatemail_pnt" name="data[active_reading]" disabled>
												<option value="">-Select-</option>
												<option phs_val=6 phs_max="6"<?php echo $phs_email_v2['active_reading'] == "Completely"?"selected":"";?> value="Completely">Completely</option>
												<option phs_val=3 phs_max="6"<?php echo $phs_email_v2['active_reading'] == "Partially"?"selected":"";?> value="Partially">Partially</option>
												<option phs_val=0 phs_max="6"<?php echo $phs_email_v2['active_reading'] == "Not at all"?"selected":"";?> value="Not at all">Not at all</option>
												<option phs_val=0 phs_max="6"<?php echo $phs_email_v2['active_reading'] == "TBD"?"selected":"";?> value="TBD">TBD</option>
												<option phs_val=0 phs_max="6"<?php echo $phs_email_v2['active_reading'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td>M</td>
										<td>6</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt8]" value="<?php echo $phs_email_v2['cmt8'] ?>" disabled></td>
									</tr>
									<tr>
										<td class="prm1">9</td>
										<td class="eml1" colspan=2>Was the CSR Tone/Words/Statements/Polite/Positive/Professional</td>
										<td>
											<select class="form-control chatemail_pnt" name="data[csr_tone]" disabled>
												<option value="">-Select-</option>
												<option phs_val=6 phs_max="6"<?php echo $phs_email_v2['csr_tone'] == "Completely"?"selected":"";?> value="Completely">Completely</option>
												<option phs_val=3 phs_max="6"<?php echo $phs_email_v2['csr_tone'] == "Partially"?"selected":"";?> value="Partially">Partially</option>
												<option phs_val=0 phs_max="6"<?php echo $phs_email_v2['csr_tone'] == "Not at all"?"selected":"";?> value="Not at all">Not at all</option>
												<option phs_val=0 phs_max="6"<?php echo $phs_email_v2['csr_tone'] == "TBD"?"selected":"";?> value="TBD">TBD</option>
												<option phs_val=0 phs_max="6"<?php echo $phs_email_v2['csr_tone'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td>M</td>
										<td>6</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt9]" value="<?php echo $phs_email_v2['cmt9'] ?>" disabled></td>
									</tr>
									<tr>
										<td class="prm1">10</td>
										<td class="eml1" colspan=2>Express Empathy/Understanding</td>
										<td>
											<select class="form-control chatemail_pnt" name="data[empathy]" disabled>
												<option value="">-Select-</option>
												<option phs_val=6 phs_max="6"<?php echo $phs_email_v2['empathy'] == "Completely"?"selected":"";?> value="Completely">Completely</option>
												<option phs_val=3 phs_max="6"<?php echo $phs_email_v2['empathy'] == "Partially"?"selected":"";?> value="Partially">Partially</option>
												<option phs_val=0 phs_max="6"<?php echo $phs_email_v2['empathy'] == "Not at all"?"selected":"";?> value="Not at all">Not at all</option>
												<option phs_val=0 phs_max="6"<?php echo $phs_email_v2['empathy'] == "TBD"?"selected":"";?> value="TBD">TBD</option>
												<option phs_val=0 phs_max="6"<?php echo $phs_email_v2['empathy'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td>M</td>
										<td>6</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt10]" value="<?php echo $phs_email_v2['cmt10'] ?>" disabled></td>
									</tr>

									<tr style="height:18px; font-weight:bold"><td colspan=7 class="prm1">Knowledge</td></tr>
									<tr>
										<td class="prm1">11</td>
										<td class="eml1" colspan=2>Did the CSR review all interactions, history, billing, finance, and AOR notes</td>
										<td>
											<select class="form-control chatemail_pnt" name="data[csr_review]" disabled>
												<option value="">-Select-</option>
												<option phs_val=6 phs_max="6"<?php echo $phs_email_v2['csr_review'] == "Completely"?"selected":"";?> value="Completely">Completely</option>
												<option phs_val=3 phs_max="6"<?php echo $phs_email_v2['csr_review'] == "Partially"?"selected":"";?> value="Partially">Partially</option>
												<option phs_val=0 phs_max="6"<?php echo $phs_email_v2['csr_review'] == "Not at all"?"selected":"";?> value="Not at all">Not at all</option>
												<option phs_val=0 phs_max="6"<?php echo $phs_email_v2['csr_review'] == "TBD"?"selected":"";?> value="TBD">TBD</option>
												<option phs_val=0 phs_max="6"<?php echo $phs_email_v2['csr_review'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td>M</td>
										<td>6</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt11]" value="<?php echo $phs_email_v2['cmt11'] ?>" disabled></td>
									</tr>
									<tr>
										<td class="prm1">12</td>
										<td class="eml1" colspan=2>Does the CSR have a good understanding of the products/benefits</td>
										<td>
											<select class="form-control chatemail_pnt" name="data[products_benefits]" disabled>
												<option value="">-Select-</option>
												<option phs_val=6 phs_max="6"<?php echo $phs_email_v2['products_benefits'] == "Completely"?"selected":"";?> value="Completely">Completely</option>
												<option phs_val=3 phs_max="6"<?php echo $phs_email_v2['products_benefits'] == "Partially"?"selected":"";?> value="Partially">Partially</option>
												<option phs_val=0 phs_max="6"<?php echo $phs_email_v2['products_benefits'] == "Not at all"?"selected":"";?> value="Not at all">Not at all</option>
												<option phs_val=0 phs_max="6"<?php echo $phs_email_v2['products_benefits'] == "TBD"?"selected":"";?> value="TBD">TBD</option>
												<option phs_val=0 phs_max="6"<?php echo $phs_email_v2['products_benefits'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td>M</td>
										<td>6</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt12]" value="<?php echo $phs_email_v2['cmt12'] ?>" disabled></td>
									</tr>

									<tr style="height:18px; font-weight:bold"><td colspan=7 class="prm1">Closing</td></tr>
									<tr>
										<td class="prm1">13</td>
										<td class="eml1" colspan=2>Offer Self Service options</td>
										<td>
											<select class="form-control chatemail_pnt" name="data[self_service]" disabled>
												<option value="">-Select-</option>
												<option phs_val=2 phs_max="2"<?php echo $phs_email_v2['self_service'] == "Completely"?"selected":"";?> value="Completely">Completely</option>
												<option phs_val=1 phs_max="2"<?php echo $phs_email_v2['self_service'] == "Partially"?"selected":"";?> value="Partially">Partially</option>
												<option phs_val=0 phs_max="2"<?php echo $phs_email_v2['self_service'] == "Not at all"?"selected":"";?> value="Not at all">Not at all</option>
												<option phs_val=0 phs_max="2"<?php echo $phs_email_v2['self_service'] == "TBD"?"selected":"";?> value="TBD">TBD</option>
												<option phs_val=0 phs_max="2"<?php echo $phs_email_v2['self_service'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td>L</td>
										<td>2</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt13]" value="<?php echo $phs_email_v2['cmt13'] ?>" disabled></td>
									</tr>
									<tr>
										<td class="prm1">14</td>
										<td class="eml1" colspan=2>Provided information for additional assistance</td>
										<td>
											<select class="form-control chatemail_pnt" name="data[additional_assistance]" disabled>
												<option value="">-Select-</option>
												<option phs_val=6 phs_max="6"<?php echo $phs_email_v2['additional_assistance'] == "Completely"?"selected":"";?> value="Completely">Completely</option>
												<option phs_val=3 phs_max="6"<?php echo $phs_email_v2['additional_assistance'] == "Partially"?"selected":"";?> value="Partially">Partially</option>
												<option phs_val=0 phs_max="6"<?php echo $phs_email_v2['additional_assistance'] == "Not at all"?"selected":"";?> value="Not at all">Not at all</option>
												<option phs_val=0 phs_max="6"<?php echo $phs_email_v2['additional_assistance'] == "TBD"?"selected":"";?> value="TBD">TBD</option>
												<option phs_val=0 phs_max="6"<?php echo $phs_email_v2['additional_assistance'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td>M</td>
										<td>6</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt14]" value="<?php echo $phs_email_v2['cmt14'] ?>" disabled></td>
									</tr>
									<tr>
										<td class="prm1">15</td>
										<td class="eml1" colspan=2>Updated information correctly in E123 (NBD, Payment Information, Address Changes, etc.)</td>
										<td>
											<select class="form-control chatemail_pnt" name="data[updated_information]" disabled>
												<option value="">-Select-</option>
												<option phs_val=6 phs_max="6"<?php echo $phs_email_v2['updated_information'] == "Completely"?"selected":"";?> value="Completely">Completely</option>
												<option phs_val=3 phs_max="6"<?php echo $phs_email_v2['updated_information'] == "Partially"?"selected":"";?> value="Partially">Partially</option>
												<option phs_val=0 phs_max="6"<?php echo $phs_email_v2['updated_information'] == "Not at all"?"selected":"";?> value="Not at all">Not at all</option>
												<option phs_val=0 phs_max="6"<?php echo $phs_email_v2['updated_information'] == "TBD"?"selected":"";?> value="TBD">TBD</option>
												<option phs_val=0 phs_max="6"<?php echo $phs_email_v2['updated_information'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td>M</td>
										<td>6</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt15]" value="<?php echo $phs_email_v2['cmt15'] ?>" disabled></td>
									</tr>
									<tr>
										<td class="prm1">16</td>
										<td class="eml1" colspan=2>Did the CSR select the appropriate dispositions</td>
										<td>
											<select class="form-control chatemail_pnt" name="data[appropriate_disposition]" disabled>
												<option value="">-Select-</option>
												<option phs_val=2 phs_max="2"<?php echo $phs_email_v2['appropriate_disposition'] == "Completely"?"selected":"";?> value="Completely">Completely</option>
												<option phs_val=1 phs_max="2"<?php echo $phs_email_v2['appropriate_disposition'] == "Partially"?"selected":"";?> value="Partially">Partially</option>
												<option phs_val=0 phs_max="2"<?php echo $phs_email_v2['appropriate_disposition'] == "Not at all"?"selected":"";?> value="Not at all">Not at all</option>
												<option phs_val=0 phs_max="2"<?php echo $phs_email_v2['appropriate_disposition'] == "TBD"?"selected":"";?> value="TBD">TBD</option>
												<option phs_val=0 phs_max="2"<?php echo $phs_email_v2['appropriate_disposition'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td>L</td>
										<td>2</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt16]" value="<?php echo $phs_email_v2['cmt16'] ?>" disabled></td>
									</tr>
									<tr>
										<td class="prm1">17</td>
										<td class="eml1" colspan=2>Offered help above & beyond</td>
										<td>
											<select class="form-control chatemail_pnt" name="data[offer_help]" disabled>
												<option value="">-Select-</option>
												<option phs_val=2 phs_max="2"<?php echo $phs_email_v2['offer_help'] == "Completely"?"selected":"";?> value="Completely">Completely</option>
												<option phs_val=1 phs_max="2"<?php echo $phs_email_v2['offer_help'] == "Partially"?"selected":"";?> value="Partially">Partially</option>
												<option phs_val=0 phs_max="2"<?php echo $phs_email_v2['offer_help'] == "Not at all"?"selected":"";?> value="Not at all">Not at all</option>
												<option phs_val=0 phs_max="2"<?php echo $phs_email_v2['offer_help'] == "TBD"?"selected":"";?> value="TBD">TBD</option>
												<option phs_val=0 phs_max="2"<?php echo $phs_email_v2['offer_help'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select>
										</td>
										<td>L</td>
										<td>2</td>
										<td colspan=2><input type="text" class="form-control" name="data[cmt17]" value="<?php echo $phs_email_v2['cmt17'] ?>" disabled></td>
									</tr>
									<tr>
										<td>Call Summary:</td>
										<td colspan="2"><textarea class="form-control" disabled   name="data[call_summary]"><?php echo $phs_email_v2['call_summary'] ?></textarea></td>
										<td>Feedback:</td>
										<td colspan="3"><textarea class="form-control" disabled   name="data[feedback]"><?php echo $phs_email_v2['feedback'] ?></textarea></td>
									</tr>
									
								<?php if($phs_email_v2['attach_file']!=''){ ?>
									<tr oncontextmenu="return false;">
										<td colspan="2">Audio Files (mp3|avi|mp4|wmv|wav)</td>
										<td colspan="5">
											<?php $attach_file = explode(",",$phs_email_v2['attach_file']);
											 foreach($attach_file as $mp){ ?>
												<audio controls='' controlsList="nodownload" style="background-color:#607F93"> 
												  <source src="<?php echo base_url(); ?>qa_files/qa_phs/email/<?php echo $mp; ?>" type="audio/ogg">
												  <source src="<?php echo base_url(); ?>qa_files/qa_phs/email/<?php echo $mp; ?>" type="audio/mpeg">
												</audio> </br>
											 <?php } ?>
										</td>
									</tr>
									<?php } ?>
									
									<tr><td colspan="7" style="background-color:#C5C8C8"></td></tr>
									
									<tr><td colspan="2" style="font-size:16px">Manager Review:</td> <td colspan="5" style="text-align:left"><?php echo $phs_email_v2['mgnt_rvw_note'] ?></td></tr>
									<tr><td colspan="2" style="font-size:16px">Client Review:</td> <td colspan="5" style="text-align:left"><?php echo $phs_email_v2['client_rvw_note'] ?></td></tr>
									
									<tr><td colspan="7" style="background-color:#C5C8C8"></td></tr>
									
									<form id="form_agent_user" method="POST" action="">
									 <input type="hidden" name="pnid" class="form-control" value="<?php echo $pnid; ?>">
										
										<tr>
											<td colspan=2 style="font-size:16px">Feedback Acceptance<span style="font-size:24px;color:red">*</span></td>
											<td colspan=2>
												<select class="form-control" id="" name="agnt_fd_acpt" required>
													<option value="">--Select--</option>
													<option <?php echo $phs_email_v2['agnt_fd_acpt']=='Acceptance'?"selected":""; ?> value="Acceptance">Acceptance</option>	
													<option <?php echo $phs_email_v2['agnt_fd_acpt']=='Not Acceptance'?"selected":""; ?> value="Not Acceptance">Not Acceptance</option>	
												</select>
											</td>
										</tr>
										<tr>
											<td colspan=2 style="font-size:16px">Your Review<span style="font-size:24px;color:red">*</span></td>
											<td colspan=5><textarea class="form-control" name="note" required><?php echo $phs_email_v2['agent_rvw_note'] ?></textarea></td>
										</tr>
										
										<?php if(is_access_qa_agent_module()==true){
										if(is_available_qa_feedback($phs_email_v2['entry_date'],72) == true){ ?>
											<tr>
												<?php if($phs_email_v2['agent_rvw_note']==''){ ?>
													<td colspan="7"><button class="btn btn-success waves-effect" type="submit" id='btnagentSave' name='btnSave' value="SAVE" style="width:500px">SAVE</button></td>
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
