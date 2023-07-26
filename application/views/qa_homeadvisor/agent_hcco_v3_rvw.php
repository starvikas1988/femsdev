<style>
.table > tbody > tr > td{
	text-align: center;
	font-size:12px;
}

#theader{
	font-size:20px;
	font-weight:bold;
	background-color:#95A5A6;
}

.eml{
	font-weight:bold;
	background-color:#F4D03F;
}
.eml1{
	font-weight:bold;
	background-color:#add8e6;
}
.eml2{
	font-weight:bold;
	background-color:#90ee90;
}
.eml3{
	font-weight:bold;
	background-color:#C4A484;
}
.eml4{
	font-weight:bold;
	background-color:#969d54;
}
.eml5{
	font-weight:bold;
	background-color:#ee9090;
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
										<tr>
											<td colspan="8" id="theader" style="font-size:40px">HCCO QA FORM V3</td>
											<input type="hidden" name="audit_start_time" value="<?php echo CurrMySqlDate(); ?>">
										</tr>
										<?php
										$rand_id = 0;
										
											if ($hcco_v3_data['entry_by'] != '') {
												$auditorName = $hcco_v3_data['auditor_name'];
											} else {
												$auditorName = $hcco_v3_data['client_name'];
											}
											$clDate_val = mysql2mmddyySls($hcco_v3_data['call_date']);
										
										if ($rand_id != 0) {
											$agent_id = $rand_data['sid'];
											$fusion_id = $rand_data['fusion_id'];
											$agent_name = $rand_data['fname'] . " " . $rand_data['lname'];
											$tl_id = $rand_data['assigned_to'];
											$tl_name = $rand_data['tl_name'];
											$call_duration = $rand_data['call_duration'];
											
										} else {
											$agent_id = $hcco_v3_data['agent_id'];
											$fusion_id = $hcco_v3_data['fusion_id'];
											$agent_name = $hcco_v3_data['fname'] . " " . $hcco_v3_data['lname'] ;
											$tl_id = $hcco_v3_data['tl_id'];
											$tl_name = $hcco_v3_data['tl_name'];
											$call_duration = $hcco_v3_data['call_duration'];
										}
										?>
										<tr>
											<td>Auditor Name:</td>
											<td><input type="text" class="form-control" value="<?= $auditorName; ?>" disabled></td>
											<td>Audit Date:</td>
											<td colspan="2"><input type="text" class="form-control" value="<?= CurrDateMDY() ?>" disabled></td>
											<td>Call Date:<span style="font-size:24px;color:red">*</span></td>
											<td colspan="2">
												<input type="text" id="call_date" name="call_date"  onkeydown="return false;" value="<?php echo $clDate_val; ?>" max="<?php echo date("Y-m-d"); ?>" class="form-control" disabled>
											</td>
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
											<td>Employee ID:</td>
											<td colspan="2"><input type="text" class="form-control" id="fusion_id" disabled value="<?php echo $fusion_id; ?>" readonly></td>
											<td> L1 Supervisor:<span style="font-size:24px;color:red">*</span></td>
											<td colspan="2">
												<input type="text" class="form-control" id="tl_names"  value="<?php echo $tl_name; ?>" readonly>
												<input type="hidden" class="form-control" id="tl_id" name="data[tl_id]" value="<?php echo $tl_id; ?>" disabled>
											</td>
										</tr>
										<tr>
											<td>Original SR ID:<span style="font-size:24px;color:red">*</span></td>
											<td>
												<input type="text" id="original_sr_id" name="data[original_sr_id]"  value="<?php echo $hcco_v3_data['original_sr_id']; ?>" class="form-control" disabled>
											</td>
											<td>New SR (if applicable):<span style="font-size:24px;color:red">*</span></td>
											<td colspan="2">
												<input type="text" id="new_sr_id" name="data[new_sr_id]"  value="<?php echo $hcco_v3_data['new_sr_id']; ?>" class="form-control" disabled>
											</td>
											<td>Call Duration:<span style="font-size:24px;color:red">*</span></td>
											<td colspan="2"><input type="text" class="form-control" onkeydown="return false;" id="call_duration" name="data[call_duration]" value="<?php echo $call_duration; ?>" disabled></td>
										</tr>
										<tr>
											<td>VOC:<span style="font-size:24px;color:red">*</span></td>
											<td>
												<select class="form-control" id="voc" name="data[voc]" disabled>
													
													<option value="">-Select-</option>
													<option value="1"  <?= ($hcco_v3_data['voc']=="1")?"selected":"" ?>>1</option>
													<option value="2"  <?= ($hcco_v3_data['voc']=="2")?"selected":"" ?>>2</option>
													<option value="3"  <?= ($hcco_v3_data['voc']=="3")?"selected":"" ?>>3</option>
													<option value="4"  <?= ($hcco_v3_data['voc']=="4")?"selected":"" ?>>4</option>
													<option value="5"  <?= ($hcco_v3_data['voc']=="5")?"selected":"" ?>>5</option>
													<option value="6"  <?= ($hcco_v3_data['voc']=="6")?"selected":"" ?>>6</option>
													<option value="7"  <?= ($hcco_v3_data['voc']=="7")?"selected":"" ?>>7</option>
													<option value="8"  <?= ($hcco_v3_data['voc']=="8")?"selected":"" ?>>8</option>
													<option value="9"  <?= ($hcco_v3_data['voc']=="9")?"selected":"" ?>>9</option>
													<option value="10"  <?= ($hcco_v3_data['voc']=="10")?"selected":"" ?>>10</option>
												</select>
											</td>
												
											<td>Audit Type:<span style="font-size:24px;color:red">*</span></td>
											<td colspan="2">
												<select class="form-control" id="audit_type" name="data[audit_type]" disabled>
                                                    <option value="">-Select-</option>
                                                    <option value="CQ Audit" <?= ($hcco_v3_data['audit_type']=="CQ Audit")?"selected":"" ?>>CQ Audit</option>
                                                    <option value="BQ Audit" <?= ($hcco_v3_data['audit_type']=="BQ Audit")?"selected":"" ?>>BQ Audit</option>
                                                    <option value="Calibration" <?= ($hcco_v3_data['audit_type']=="Calibration")?"selected":"" ?>>Calibration</option>
                                                    <option value="Pre-Certificate Mock Call" <?= ($hcco_v3_data['audit_type']=="Pre-Certificate Mock Call")?"selected":"" ?>>Pre-Certificate Mock Call</option>
                                                    <option value="Certification Audit" <?= ($hcco_v3_data['audit_type']=="Certification Audit")?"selected":"" ?>>Certification Audit</option>
                                                    <option value="Operation Audit" <?= ($hcco_v3_data['audit_type']=="Operation Audit")?"selected":"" ?>>Operation Audit</option>
                                                    <option value="Trainer Audit"  <?= ($hcco_v3_data['audit_type']=="Trainer Audit")?"selected":"" ?>>Trainer Audit</option>
                                                    <option value="WOW Call" <?= ($hcco_v3_data['audit_type']=="WOW Call")?"selected":"" ?>>Wow Call nomination</option>
                                                </select>
											</td>
											<td class="auType">Auditor Type<span style="font-size:24px;color:red">*</span></td>
											<td colspan="2" class="auType">
												<select class="form-control" id="auditor_type" name="data[auditor_type]">
                                                    <option>Select</option>
                                                    <option value="Master" <?= ($hcco_v3_data['auditor_type']=="Master")?"selected":"" ?>>Master</option>
                                                    <option value="Regular" <?= ($hcco_v3_data['auditor_type']=="Regular")?"selected":"" ?>>Regular</option>
                                                </select>
											</td>
										</tr>
										
										<tr>
											<td style="font-weight:bold; font-size:16px; text-align:left">Earned Score</td>
											<td><input type="text" readonly id="hcco_v3_earned_score" name="data[earned_score]" class="form-control" value="<?php echo $hcco_v3_data['earned_score'] ?>" /></td>
											<td style="font-weight:bold; font-size:16px; text-align:left">Possible Score</td>
											<td colspan="2"><input type="text" readonly id="hcco_v3_possible_score" name="data[possible_score]" class="form-control" value="<?php echo $hcco_v3_data['possible_score'] ?>" /></td>
											<td style="font-weight:bold; font-size:16px; text-align:right">Overall Score:</td>
											<td colspan="2"><input type="text" readonly id="hcco_v3_overall_score" name="data[overall_score]" class="form-control hcco_v3Fatal" style="font-weight:bold" value="<?php echo $hcco_v3_data['overall_score'] ?>"></td>
										</tr>
										<tr class="eml" style="height:25px; font-weight:bold">
											<td>COPC Parameter</td>
											<td>PARAMETER</td>
											<td colspan=4>SUB PARAMETER</td>
											<td>Weightage</td>
											<td>STATUS</td>
										</tr>

										<tr>
											<td class="eml" rowspan=9 style="font-weight:bold; background-color:#d6bf91">Business Critical</td>
											<td rowspan=9 style="font-weight:bold; background-color:#ee9090">Call Beginning</td>
											<td colspan=4 style="font-weight:bold; background-color:#90bfee">Introduction and Purpose</td>
											<td>10</td>
											<td>
												<select class="form-control hcco_v3_point business" name="data[introduction_purpose]" disabled>
													<option hcco_v3_val=10 hcco_v3_max=10 <?php echo $hcco_v3_data['introduction_purpose'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
													<option hcco_v3_val=10 hcco_v3_max=10 <?php echo $hcco_v3_data['introduction_purpose'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option hcco_v3_val=0 hcco_v3_max=10 <?php echo $hcco_v3_data['introduction_purpose'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													
													
												</select>
											</td>
										</tr>
										<tr>
											<td colspan=4>Did not verify person speaking</td>
											<td>10</td>
											<td>
												<select class="form-control" name="data[verify_person_speaking]" disabled>
													<option hcco_v3_val=10 hcco_v3_max=10 <?php echo $hcco_v3_data['verify_person_speaking'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
													<option hcco_v3_val=10 hcco_v3_max=10 <?php echo $hcco_v3_data['verify_person_speaking'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option hcco_v3_val=0 hcco_v3_max=10 <?php echo $hcco_v3_data['verify_person_speaking'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													
													
												</select>
											</td>
										</tr>
										<tr>
											<td colspan=4>Incorrect branding</td>
											<td>10</td>
											<td>
												<select class="form-control" name="data[incorrect_branding]" disabled>
													<option hcco_v3_val=10 hcco_v3_max=10 <?php echo $hcco_v3_data['incorrect_branding'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
													<option hcco_v3_val=10 hcco_v3_max=10 <?php echo $hcco_v3_data['incorrect_branding'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option hcco_v3_val=0 hcco_v3_max=10 <?php echo $hcco_v3_data['incorrect_branding'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
												</select>
											</td>
										</tr>
										<tr>
											<td colspan=4>No Branding</td>
											<td>10</td>
											<td>
												<select class="form-control" name="data[no_branding]" disabled>
													<option hcco_v3_val=10 hcco_v3_max=10 <?php echo $hcco_v3_data['no_branding'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
													<option hcco_v3_val=10 hcco_v3_max=10 <?php echo $hcco_v3_data['no_branding'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option hcco_v3_val=0 hcco_v3_max=10 <?php echo $hcco_v3_data['no_branding'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
												</select>
											</td>
										</tr>
										<tr>
											<td colspan=4>Did not state the purpose of your call</td>
											<td>10</td>
											<td>
												<select class="form-control" name="data[purpose_of_call]" disabled>
													<option hcco_v3_val=10 hcco_v3_max=10 <?php echo $hcco_v3_data['purpose_of_call'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
													<option hcco_v3_val=10 hcco_v3_max=10 <?php echo $hcco_v3_data['purpose_of_call'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option hcco_v3_val=0 hcco_v3_max=10 <?php echo $hcco_v3_data['purpose_of_call'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
												</select>
											</td>
										</tr>
										<tr>
											<td colspan=4 style="font-weight:bold; background-color:#90bfee">Follow Up</td>
											<td>10</td>
											<td>
												<select class="form-control hcco_v3_point business" name="data[follow_up]" disabled>
													<option hcco_v3_val=10 hcco_v3_max=10 <?php echo $hcco_v3_data['follow_up'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
													<option hcco_v3_val=10 hcco_v3_max=10 <?php echo $hcco_v3_data['follow_up'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option hcco_v3_val=0 hcco_v3_max=10 <?php echo $hcco_v3_data['follow_up'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
												</select>
											</td>
										</tr>
										<tr>
											<td colspan=4>Did not probe with open ended questions</td>
											<td>10</td>
											<td>
												<select class="form-control" name="data[probe_open_ended_questions]" disabled>
													<option hcco_v3_val=10 hcco_v3_max=10 <?php echo $hcco_v3_data['probe_open_ended_questions'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
													<option hcco_v3_val=10 hcco_v3_max=10 <?php echo $hcco_v3_data['probe_open_ended_questions'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option hcco_v3_val=0 hcco_v3_max=10 <?php echo $hcco_v3_data['probe_open_ended_questions'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
												</select>
											</td>
										</tr>
										<tr>
											<td colspan=4>Did not review detailed description</td>
											<td>10</td>
											<td>
												<select class="form-control" name="data[review_description]" disabled>
													<option hcco_v3_val=10 hcco_v3_max=10 <?php echo $hcco_v3_data['review_description'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
													<option hcco_v3_val=10 hcco_v3_max=10 <?php echo $hcco_v3_data['review_description'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option hcco_v3_val=0 hcco_v3_max=10 <?php echo $hcco_v3_data['review_description'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
												</select>
											</td>
										</tr>
										<tr>
											<td colspan=4>Did not offer to take review</td>
											<td>10</td>
											<td>
												<select class="form-control" name="data[offer_review]" disabled>
													<option hcco_v3_val=10 hcco_v3_max=10 <?php echo $hcco_v3_data['offer_review'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
													<option hcco_v3_val=10 hcco_v3_max=10 <?php echo $hcco_v3_data['offer_review'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option hcco_v3_val=0 hcco_v3_max=10 <?php echo $hcco_v3_data['offer_review'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
												</select>
											</td>
										</tr>
										<tr>
											<td class="eml" rowspan=7 style="font-weight:bold; background-color:#D7BDE2">Compliance Critical</td>
											<td rowspan=21 style="font-weight:bold; background-color:#94ffff">Policy Adherence</td>
											<td colspan=4 style="font-weight:bold; background-color:#90bfee">Marketplace Pre-Submit Guidelines</td>
											<td>10</td>
											<td>
												<select class="form-control hcco_v3_point compliance" name="data[marketplace_Pre_Submit_Guidelines]" disabled>
													<option hcco_v3_val=10 hcco_v3_max=10 <?php echo $hcco_v3_data['marketplace_Pre_Submit_Guidelines'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
													<option hcco_v3_val=10 hcco_v3_max=10 <?php echo $hcco_v3_data['marketplace_Pre_Submit_Guidelines'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option hcco_v3_val=0 hcco_v3_max=10 <?php echo $hcco_v3_data['marketplace_Pre_Submit_Guidelines'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													
													
												</select>
											</td>
										</tr>
										<tr>
											<td colspan=4>Incorrect CTT submitted</td>
											<td>10</td>
											<td>
												<select class="form-control" name="data[incorrect_CTT]" disabled>
													<option hcco_v3_val=10 hcco_v3_max=10 <?php echo $hcco_v3_data['incorrect_CTT'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
													<option hcco_v3_val=10 hcco_v3_max=10 <?php echo $hcco_v3_data['incorrect_CTT'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option hcco_v3_val=0 hcco_v3_max=10 <?php echo $hcco_v3_data['incorrect_CTT'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
												</select>
											</td>
										</tr>
										<tr>
											<td colspan=4>Did not verify zip code or email</td>
											<td>10</td>
											<td>
												<select class="form-control" name="data[verify_zipp_code]" disabled>
													<option hcco_v3_val=10 hcco_v3_max=10 <?php echo $hcco_v3_data['verify_zipp_code'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
													<option hcco_v3_val=10 hcco_v3_max=10 <?php echo $hcco_v3_data['verify_zipp_code'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option hcco_v3_val=0 hcco_v3_max=10 <?php echo $hcco_v3_data['verify_zipp_code'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
												</select>
											</td>
										</tr>
										<tr>
											<td colspan=4>Pros were not presented by name</td>
											<td>10</td>
											<td>
												<select class="form-control" name="data[pros_presented_name]" disabled>
													<option hcco_v3_val=10 hcco_v3_max=10 <?php echo $hcco_v3_data['pros_presented_name'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
													<option hcco_v3_val=10 hcco_v3_max=10 <?php echo $hcco_v3_data['pros_presented_name'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option hcco_v3_val=0 hcco_v3_max=10 <?php echo $hcco_v3_data['pros_presented_name'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
												</select>
											</td>
										</tr>
										<tr>
											<td colspan=4>Did not include a detailed description</td>
											<td>10</td>
											<td>
												<select class="form-control" name="data[detailed_description]" disabled>
													<option hcco_v3_val=10 hcco_v3_max=10 <?php echo $hcco_v3_data['detailed_description'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
													<option hcco_v3_val=10 hcco_v3_max=10 <?php echo $hcco_v3_data['detailed_description'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option hcco_v3_val=0 hcco_v3_max=10 <?php echo $hcco_v3_data['detailed_description'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
												</select>
											</td>
										</tr>
										<tr>
											<td colspan=4>Did not provide OL possibilty veribiage (for No Match)</td>
											<td>10</td>
											<td>
												<select class="form-control" name="data[pre_OL_possibilty_veribiage]" disabled>
													<option hcco_v3_val=10 hcco_v3_max=10 <?php echo $hcco_v3_data['pre_OL_possibilty_veribiage'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
													<option hcco_v3_val=10 hcco_v3_max=10 <?php echo $hcco_v3_data['pre_OL_possibilty_veribiage'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option hcco_v3_val=0 hcco_v3_max=10 <?php echo $hcco_v3_data['pre_OL_possibilty_veribiage'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
												</select>
											</td>
										</tr>
										<tr>
											<td colspan=4>Did not set pre-submit expecatations</td>
											<td>10</td>
											<td>
												<select class="form-control" name="data[pre_submit_expecatations]" disabled>
													<option hcco_v3_val=10 hcco_v3_max=10 <?php echo $hcco_v3_data['pre_submit_expecatations'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
													<option hcco_v3_val=10 hcco_v3_max=10 <?php echo $hcco_v3_data['pre_submit_expecatations'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option hcco_v3_val=0 hcco_v3_max=10 <?php echo $hcco_v3_data['pre_submit_expecatations'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
												</select>
											</td>
										</tr>
									<tr>
											<td class="eml" rowspan=5 style="font-weight:bold; background-color:#D7BDE2">Compliance Critical</td>
											<td colspan=4 style="font-weight:bold; background-color:#90bfee">Marketplace Post-Submit Guidelines</td>
											<td>10</td>
											<td>
												<select class="form-control hcco_v3_point compliance" name="data[marketplace_Post_Submit_Guidelines]" disabled>
													<option hcco_v3_val=10 hcco_v3_max=10 <?php echo $hcco_v3_data['marketplace_Post_Submit_Guidelines'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
													<option hcco_v3_val=10 hcco_v3_max=10 <?php echo $hcco_v3_data['marketplace_Post_Submit_Guidelines'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option hcco_v3_val=0 hcco_v3_max=10 <?php echo $hcco_v3_data['marketplace_Post_Submit_Guidelines'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													
													
												</select>
											</td>
										</tr>
										<tr>
											<td colspan=4>Gave incorrect information</td>
											<td>10</td>
											<td>
												<select class="form-control" name="data[incorrect_information]" disabled>
													<option hcco_v3_val=10 hcco_v3_max=10 <?php echo $hcco_v3_data['incorrect_information'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
													<option hcco_v3_val=10 hcco_v3_max=10 <?php echo $hcco_v3_data['incorrect_information'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option hcco_v3_val=0 hcco_v3_max=10 <?php echo $hcco_v3_data['incorrect_information'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													
													
												</select>
											</td>
										</tr>
										<tr>
											<td colspan=4>Did not set the proper expectations</td>
											<td>10</td>
											<td>
												<select class="form-control" name="data[proper_expectations]" disabled>
													<option hcco_v3_val=10 hcco_v3_max=10 <?php echo $hcco_v3_data['proper_expectations'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
													<option hcco_v3_val=10 hcco_v3_max=10 <?php echo $hcco_v3_data['proper_expectations'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option hcco_v3_val=0 hcco_v3_max=10 <?php echo $hcco_v3_data['proper_expectations'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													
													
												</select>
											</td>
										</tr>
										<tr>
											<td colspan=4>Did not provide OL possibilty veribiage expecatations (For less than 4 matches or a 'No Match'</td>
											<td>10</td>
											<td>
												<select class="form-control" name="data[post_OL_possibilty_veribiage]" disabled>
													<option hcco_v3_val=10 hcco_v3_max=10 <?php echo $hcco_v3_data['post_OL_possibilty_veribiage'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
													<option hcco_v3_val=10 hcco_v3_max=10 <?php echo $hcco_v3_data['post_OL_possibilty_veribiage'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option hcco_v3_val=0 hcco_v3_max=10 <?php echo $hcco_v3_data['post_OL_possibilty_veribiage'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													
													
												</select>
											</td>
										</tr>
										<tr>
											<td colspan=4>Transfer was not offered</td>
											<td>10</td>
											<td>
												<select class="form-control" name="data[transfer_not_offered]" disabled>
													<option hcco_v3_val=10 hcco_v3_max=10 <?php echo $hcco_v3_data['transfer_not_offered'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
													<option hcco_v3_val=10 hcco_v3_max=10 <?php echo $hcco_v3_data['transfer_not_offered'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option hcco_v3_val=0 hcco_v3_max=10 <?php echo $hcco_v3_data['transfer_not_offered'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													
													
												</select>
											</td>
										</tr>
										<tr>
											<td class="eml" rowspan=3 style="font-weight:bold; background-color:#D7BDE2">Compliance Critical</td>
											<td colspan=4 style="font-weight:bold; background-color:#90bfee">Pre-Priced Presentation</td>
											<td>10</td>
											<td>
												<select class="form-control hcco_v3_point compliance" name="data[pre_Priced_Presentation]" disabled>
													<option hcco_v3_val=10 hcco_v3_max=10 <?php echo $hcco_v3_data['pre_Priced_Presentation'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
													<option hcco_v3_val=10 hcco_v3_max=10 <?php echo $hcco_v3_data['pre_Priced_Presentation'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option hcco_v3_val=0 hcco_v3_max=10 <?php echo $hcco_v3_data['pre_Priced_Presentation'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													
													
												</select>
											</td>
										</tr>
										<tr>
											<td colspan=4>Task was pre-priced eligible and it was not offered</td>
											<td>10</td>
											<td>
												<select class="form-control" name="data[pre_priced_eligible]" disabled>
													<option hcco_v3_val=10 hcco_v3_max=10 <?php echo $hcco_v3_data['pre_priced_eligible'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
													<option hcco_v3_val=10 hcco_v3_max=10 <?php echo $hcco_v3_data['pre_priced_eligible'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option hcco_v3_val=0 hcco_v3_max=10 <?php echo $hcco_v3_data['pre_priced_eligible'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
												</select>
											</td>
										</tr>
										<tr>
											<td colspan=4>Pre-priced was presented incorrectly</td>
											<td>10</td>
											<td>
												<select class="form-control" name="data[pre_priced_presented_incorrectly]" disabled>
													<option hcco_v3_val=10 hcco_v3_max=10 <?php echo $hcco_v3_data['pre_priced_presented_incorrectly'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
													<option hcco_v3_val=10 hcco_v3_max=10 <?php echo $hcco_v3_data['pre_priced_presented_incorrectly'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option hcco_v3_val=0 hcco_v3_max=10 <?php echo $hcco_v3_data['pre_priced_presented_incorrectly'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
												</select>
											</td>
										</tr>
										<tr>
											<td class="eml" rowspan=6 style="font-weight:bold; background-color:#D7BDE2">Compliance Critical</td>
											<td colspan=4 style="font-weight:bold; background-color:#90bfee">Pre-Priced Situational Policy</td>
											<td>10</td>
											<td>
												<select class="form-control hcco_v3_point compliance" name="data[pre_Priced_Situational_Policy]" disabled>
													<option hcco_v3_val=10 hcco_v3_max=10 <?php echo $hcco_v3_data['pre_Priced_Situational_Policy'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
													<option hcco_v3_val=10 hcco_v3_max=10 <?php echo $hcco_v3_data['pre_Priced_Situational_Policy'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option hcco_v3_val=0 hcco_v3_max=10 <?php echo $hcco_v3_data['pre_Priced_Situational_Policy'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													
													
												</select>
											</td>
										</tr>
										<tr>
											<td colspan=4>Did not give accurate infomation </td>
											<td>10</td>
											<td>
												<select class="form-control" name="data[accurate_information]" disabled>
													<option hcco_v3_val=10 hcco_v3_max=10 <?php echo $hcco_v3_data['accurate_information'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
													<option hcco_v3_val=10 hcco_v3_max=10 <?php echo $hcco_v3_data['accurate_information'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option hcco_v3_val=0 hcco_v3_max=10 <?php echo $hcco_v3_data['accurate_information'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													
													
												</select>
											</td>
										</tr>
										<tr>
											<td colspan=4>Did not follow legal language script</td>
											<td>10</td>
											<td>
												<select class="form-control" name="data[legal_language_script]" disabled>
													<option hcco_v3_val=10 hcco_v3_max=10 <?php echo $hcco_v3_data['legal_language_script'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
													<option hcco_v3_val=10 hcco_v3_max=10 <?php echo $hcco_v3_data['legal_language_script'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option hcco_v3_val=0 hcco_v3_max=10 <?php echo $hcco_v3_data['legal_language_script'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													
													
												</select>
											</td>
										</tr>
										<tr>
											<td colspan=4>Overpromised</td>
											<td>10</td>
											<td>
												<select class="form-control" name="data[overpromised]" disabled>
													<option hcco_v3_val=10 hcco_v3_max=10 <?php echo $hcco_v3_data['overpromised'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
													<option hcco_v3_val=10 hcco_v3_max=10 <?php echo $hcco_v3_data['overpromised'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option hcco_v3_val=0 hcco_v3_max=10 <?php echo $hcco_v3_data['overpromised'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													
													
												</select>
											</td>
										</tr>
										<tr>
											<td colspan=4>No coupon offered</td>
											<td>10</td>
											<td>
												<select class="form-control" name="data[no_coupon_offered]" disabled>
													<option hcco_v3_val=10 hcco_v3_max=10 <?php echo $hcco_v3_data['no_coupon_offered'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
													<option hcco_v3_val=10 hcco_v3_max=10 <?php echo $hcco_v3_data['no_coupon_offered'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option hcco_v3_val=0 hcco_v3_max=10 <?php echo $hcco_v3_data['no_coupon_offered'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													
													
												</select>
											</td>
										</tr>
										<tr>
											<td colspan=4>Coupon offered when it wasn't needed</td>
											<td>10</td>
											<td>
												<select class="form-control" name="data[coupon_offered_not_needed]" disabled>
													<option hcco_v3_val=10 hcco_v3_max=10 <?php echo $hcco_v3_data['coupon_offered_not_needed'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
													<option hcco_v3_val=10 hcco_v3_max=10 <?php echo $hcco_v3_data['coupon_offered_not_needed'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option hcco_v3_val=0 hcco_v3_max=10 <?php echo $hcco_v3_data['coupon_offered_not_needed'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													
													
												</select>
											</td>
										</tr>
									<tr>
											<td class="eml" rowspan=6 style="font-weight:bold; background-color:#90bfee">Customer Critical</td>
											<td rowspan=15 style="font-weight:bold; background-color:#90eebf">Communication</td>
											<td colspan=4 style="font-weight:bold; background-color:#90bfee">Educate</td>
											<td>5</td>
											<td>
												<select class="form-control hcco_v3_point customer" name="data[educate]" disabled>
													<option hcco_v3_val=5 hcco_v3_max=5 <?php echo $hcco_v3_data['educate'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
													<option hcco_v3_val=5 hcco_v3_max=5 <?php echo $hcco_v3_data['educate'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option hcco_v3_val=0 hcco_v3_max=5 <?php echo $hcco_v3_data['educate'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													
													
												</select>
											</td>
										</tr>
										<tr>
											<td colspan=4>Did not provide scope of our services (600+ CTTs) and/or (inside/outside)</td>
											<td>5</td>
											<td>
												<select class="form-control" name="data[scope_of_services]" disabled>
													<option hcco_v3_val=5 hcco_v3_max=5 <?php echo $hcco_v3_data['scope_of_services'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
													<option hcco_v3_val=5 hcco_v3_max=5 <?php echo $hcco_v3_data['scope_of_services'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option hcco_v3_val=0 hcco_v3_max=5 <?php echo $hcco_v3_data['scope_of_services'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													
													
												</select>
											</td>
										</tr>
										<tr>
											<td colspan=4>Did not mention two specific CTTs</td>
											<td>5</td>
											<td>
												<select class="form-control" name="data[scope_of_services]" disabled>
													<option hcco_v3_val=5 hcco_v3_max=5 <?php echo $hcco_v3_data['mention_two_specific_CTT'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
													<option hcco_v3_val=5 hcco_v3_max=5 <?php echo $hcco_v3_data['mention_two_specific_CTT'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option hcco_v3_val=0 hcco_v3_max=5 <?php echo $hcco_v3_data['mention_two_specific_CTT'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													
													
												</select>
											</td>
										</tr>
										<tr>
											<td colspan=4>Did not educate on the scope of our services before asking for a cross-sell</td>
											<td>5</td>
											<td>
												<select class="form-control" name="data[educate_cross_sell]" disabled>
													<option hcco_v3_val=5 hcco_v3_max=5 <?php echo $hcco_v3_data['educate_cross_sell'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
													<option hcco_v3_val=5 hcco_v3_max=5 <?php echo $hcco_v3_data['educate_cross_sell'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option hcco_v3_val=0 hcco_v3_max=5 <?php echo $hcco_v3_data['educate_cross_sell'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													
													
												</select>
											</td>
										</tr>
										<tr>
											<td colspan=4>Did not mention the Angi App</td>
											<td>5</td>
											<td>
												<select class="form-control" name="data[mention_Agni_App]" disabled>
													<option hcco_v3_val=5 hcco_v3_max=5 <?php echo $hcco_v3_data['mention_Agni_App'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
													<option hcco_v3_val=5 hcco_v3_max=5 <?php echo $hcco_v3_data['mention_Agni_App'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option hcco_v3_val=0 hcco_v3_max=5 <?php echo $hcco_v3_data['mention_Agni_App'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													
													
												</select>
											</td>
										</tr>
										<tr>
											<td colspan=4>Gave inaccurate information </td>
											<td>5</td>
											<td>
												<select class="form-control" name="data[inaccurate_information]" disabled>
													<option hcco_v3_val=5 hcco_v3_max=5 <?php echo $hcco_v3_data['inaccurate_information'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
													<option hcco_v3_val=5 hcco_v3_max=5 <?php echo $hcco_v3_data['inaccurate_information'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option hcco_v3_val=0 hcco_v3_max=5 <?php echo $hcco_v3_data['inaccurate_information'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													
													
												</select>
											</td>
										</tr>
									<tr>
											<td class="eml" rowspan=2 style="font-weight:bold; background-color:#d6bf91">Business Critical</td>
											<td colspan=4 style="font-weight:bold; background-color:#90bfee">Cross Sell</td>
											<td>5</td>
											<td>
												<select class="form-control hcco_v3_point business" name="data[cross_sell]" disabled>
													<option hcco_v3_val=5 hcco_v3_max=5 <?php echo $hcco_v3_data['cross_sell'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
													<option hcco_v3_val=5 hcco_v3_max=5 <?php echo $hcco_v3_data['cross_sell'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option hcco_v3_val=0 hcco_v3_max=5 <?php echo $hcco_v3_data['cross_sell'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													
													
												</select>
											</td>
										</tr>
										<tr>
											<td colspan=4>Did not ask for a cross-sell with an open ended question</td>
											<td>5</td>
											<td>
												<select class="form-control" name="data[cross_sell_openended_question]" disabled>
													<option hcco_v3_val=5 hcco_v3_max=5 <?php echo $hcco_v3_data['cross_sell_openended_question'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
													<option hcco_v3_val=5 hcco_v3_max=5 <?php echo $hcco_v3_data['cross_sell_openended_question'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option hcco_v3_val=0 hcco_v3_max=5 <?php echo $hcco_v3_data['cross_sell_openended_question'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													
													
												</select>
											</td>
										</tr>	

									<tr>
											<td class="eml" rowspan=7 style="font-weight:bold; background-color:#90bfee">Customer Critical</td>
											<td colspan=4 style="font-weight:bold; background-color:#90bfee">Tone</td>
											<td>10</td>
											<td>
												<select class="form-control hcco_v3_point customer" name="data[tone]" disabled>
													<option hcco_v3_val=10 hcco_v3_max=10 <?php echo $hcco_v3_data['tone'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
													<option hcco_v3_val=10 hcco_v3_max=10 <?php echo $hcco_v3_data['tone'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option hcco_v3_val=0 hcco_v3_max=10 <?php echo $hcco_v3_data['tone'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													
													
												</select>
											</td>
										</tr>
									<tr>
											<td colspan=4>Tone was not professional/not positive</td>
											<td>10</td>
											<td>
												<select class="form-control" name="data[tone_not_professional]" disabled>
													<option hcco_v3_val=10 hcco_v3_max=10 <?php echo $hcco_v3_data['tone_not_professional'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
													<option hcco_v3_val=10 hcco_v3_max=10 <?php echo $hcco_v3_data['tone_not_professional'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option hcco_v3_val=0 hcco_v3_max=10 <?php echo $hcco_v3_data['tone_not_professional'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													
													
												</select>
											</td>
										</tr>
										<tr>
											<td colspan=4>The agent did not actively listen to the customer and did not </td>
											<td>10</td>
											<td>
												<select class="form-control" name="data[actively_listen_customer]" disabled>
													<option hcco_v3_val=10 hcco_v3_max=10 <?php echo $hcco_v3_data['actively_listen_customer'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
													<option hcco_v3_val=10 hcco_v3_max=10 <?php echo $hcco_v3_data['actively_listen_customer'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option hcco_v3_val=0 hcco_v3_max=10 <?php echo $hcco_v3_data['actively_listen_customer'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													
													
												</select>
											</td>
										</tr>
										<tr>
											<td colspan=4>The agent had inappropriate rapport </td>
											<td>10</td>
											<td>
												<select class="form-control" name="data[inappropriate_rapport]" disabled>
													<option hcco_v3_val=10 hcco_v3_max=10 <?php echo $hcco_v3_data['inappropriate_rapport'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
													<option hcco_v3_val=10 hcco_v3_max=10 <?php echo $hcco_v3_data['inappropriate_rapport'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option hcco_v3_val=0 hcco_v3_max=10 <?php echo $hcco_v3_data['inappropriate_rapport'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													
													
												</select>
											</td>
										</tr>
										<tr>
											<td colspan=4>Dear air or long silences present</td>
											<td>10</td>
											<td>
												<select class="form-control" name="data[dead_air]" disabled>
													<option hcco_v3_val=10 hcco_v3_max=10 <?php echo $hcco_v3_data['dead_air'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
													<option hcco_v3_val=10 hcco_v3_max=10 <?php echo $hcco_v3_data['dead_air'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option hcco_v3_val=0 hcco_v3_max=10 <?php echo $hcco_v3_data['dead_air'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													
													
												</select>
											</td>
										</tr>
										<tr>
											<td colspan=4>Did not show empathy where appropriate</td>
											<td>10</td>
											<td>
												<select class="form-control" name="data[show_empathy]" disabled>
													<option hcco_v3_val=10 hcco_v3_max=10 <?php echo $hcco_v3_data['show_empathy'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
													<option hcco_v3_val=10 hcco_v3_max=10 <?php echo $hcco_v3_data['show_empathy'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option hcco_v3_val=0 hcco_v3_max=10 <?php echo $hcco_v3_data['show_empathy'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													
													
												</select>
											</td>
										</tr>
										<tr>
											<td colspan=4>The agent used internal jargon</td>
											<td>10</td>
											<td>
												<select class="form-control" name="data[used_internal_jargon]" disabled>
													<option hcco_v3_val=10 hcco_v3_max=10 <?php echo $hcco_v3_data['used_internal_jargon'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
													<option hcco_v3_val=10 hcco_v3_max=10 <?php echo $hcco_v3_data['used_internal_jargon'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option hcco_v3_val=0 hcco_v3_max=10 <?php echo $hcco_v3_data['used_internal_jargon'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													
													
												</select>
											</td>
										</tr>
									<tr>
											<td class="eml" rowspan=5 style="font-weight:bold; background-color:#d6bf91">Business Critical</td>
											<td rowspan=9 style="font-weight:bold; background-color:#bf90ee">Resolution</td>
											<td colspan=4 style="font-weight:bold; background-color:#90bfee">Disposition tagging</td>
											<td>10</td>
											<td>
												<select class="form-control hcco_v3_point business" name="data[disposition_tagging]" disabled>
													<option hcco_v3_val=10 hcco_v3_max=10 <?php echo $hcco_v3_data['disposition_tagging'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
													<option hcco_v3_val=10 hcco_v3_max=10 <?php echo $hcco_v3_data['disposition_tagging'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option hcco_v3_val=0 hcco_v3_max=10 <?php echo $hcco_v3_data['disposition_tagging'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													
													
												</select>
											</td>
										</tr>
									<tr>
											<td colspan=4>Did not disposition SRs submitting within the last 14 days</td>
											<td>10</td>
											<td>
												<select class="form-control" name="data[disposition_SRs]" disabled>
													<option hcco_v3_val=10 hcco_v3_max=10 <?php echo $hcco_v3_data['disposition_SRs'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
													<option hcco_v3_val=10 hcco_v3_max=10 <?php echo $hcco_v3_data['disposition_SRs'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option hcco_v3_val=0 hcco_v3_max=10 <?php echo $hcco_v3_data['disposition_SRs'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													
													
												</select>
											</td>
										</tr>
									<tr>
											<td colspan=4>Incorrect disposition </td>
											<td>10</td>
											<td>
												<select class="form-control" name="data[incorrect_disposition]" disabled>
													<option hcco_v3_val=10 hcco_v3_max=10 <?php echo $hcco_v3_data['incorrect_disposition'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
													<option hcco_v3_val=10 hcco_v3_max=10 <?php echo $hcco_v3_data['incorrect_disposition'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option hcco_v3_val=0 hcco_v3_max=10 <?php echo $hcco_v3_data['incorrect_disposition'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													
													
												</select>
											</td>
										</tr>
									<tr>
											<td colspan=4>Missing summary notes in the lead audit </td>
											<td>10</td>
											<td>
												<select class="form-control" name="data[missing_summary_notes]" disabled>
													<option hcco_v3_val=10 hcco_v3_max=10 <?php echo $hcco_v3_data['missing_summary_notes'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
													<option hcco_v3_val=10 hcco_v3_max=10 <?php echo $hcco_v3_data['missing_summary_notes'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option hcco_v3_val=0 hcco_v3_max=10 <?php echo $hcco_v3_data['missing_summary_notes'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													
													
												</select>
											</td>
										</tr>
										<tr>
											<td colspan=4>Missing customer name in audit notes. </td>
											<td>10</td>
											<td>
												<select class="form-control" name="data[missing_customer_name]" disabled>
													<option hcco_v3_val=10 hcco_v3_max=10 <?php echo $hcco_v3_data['missing_customer_name'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
													<option hcco_v3_val=10 hcco_v3_max=10 <?php echo $hcco_v3_data['missing_customer_name'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option hcco_v3_val=0 hcco_v3_max=10 <?php echo $hcco_v3_data['missing_customer_name'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													
													
												</select>
											</td>
										</tr>
										<tr>
											<td class="eml" rowspan=4 style="font-weight:bold; background-color:#90bfee">Customer Critical</td>
											<td colspan=4 style="font-weight:bold; background-color:#90bfee">Correct Action</td>
											<td>10</td>
											<td>
												<select class="form-control hcco_v3_point customer" name="data[correct_action]" disabled>
													<option hcco_v3_val=10 hcco_v3_max=10 <?php echo $hcco_v3_data['correct_action'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
													<option hcco_v3_val=10 hcco_v3_max=10 <?php echo $hcco_v3_data['correct_action'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option hcco_v3_val=0 hcco_v3_max=10 <?php echo $hcco_v3_data['correct_action'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													
													
												</select>
											</td>
										</tr>
										<tr>
											<td colspan=4>Did not take the correct action</td>
											<td>10</td>
											<td>
												<select class="form-control" name="data[take_correct_action]" disabled>
													<option hcco_v3_val=10 hcco_v3_max=10 <?php echo $hcco_v3_data['take_correct_action'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
													<option hcco_v3_val=10 hcco_v3_max=10 <?php echo $hcco_v3_data['take_correct_action'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option hcco_v3_val=0 hcco_v3_max=10 <?php echo $hcco_v3_data['take_correct_action'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													
													
												</select>
											</td>
										</tr>
										<tr>
											<td colspan=4>Did not do what they told the customer they would do</td>
											<td>10</td>
											<td>
												<select class="form-control" name="data[do_what_customer_told]" disabled>
													<option hcco_v3_val=10 hcco_v3_max=10 <?php echo $hcco_v3_data['do_what_customer_told'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
													<option hcco_v3_val=10 hcco_v3_max=10 <?php echo $hcco_v3_data['do_what_customer_told'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option hcco_v3_val=0 hcco_v3_max=10 <?php echo $hcco_v3_data['do_what_customer_told'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
													
													
												</select>
											</td>
										</tr>
										<tr>
											<td colspan=4>Did not address all of the customers concerns.</td>
											<td>10</td>
											<td>
												<select class="form-control" name="data[address_customer_concern]" disabled>
													<option hcco_v3_val=10 hcco_v3_max=10 <?php echo $hcco_v3_data['address_customer_concern'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
													<option hcco_v3_val=10 hcco_v3_max=10 <?php echo $hcco_v3_data['address_customer_concern'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option hcco_v3_val=0 hcco_v3_max=10 <?php echo $hcco_v3_data['address_customer_concern'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
												</select>
											</td>
										</tr>
									<tr>
											<td colspan="2" rowspan=10 style="font-weight:bold; background-color:#ffa07a">Critical Fail (Automatic Zero)</td>
											<td colspan=4 style="font-weight:bold; background-color:#90bfee">Critical Fail Behaviors</td>
											<td rowspan=10></td>
											<td>
												<input type="text" class="form-control" onkeydown="return false;" id="hcco_Fail1" name="data[critical_Fail_Behaviors]" value="<?php echo $hcco_v3_data['critical_Fail_Behaviors']; ?>" disabled>
												<!-- <select class="form-control hcco_v3_point"  id="hcco_Fail1" name="data[critical_Fail_Behaviors]" disabled>
													<option hcco_v3_val=0 hcco_v3_max=0 <?php echo $hcco_v3_data['critical_Fail_Behaviors'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option hcco_v3_val=0 hcco_v3_max=0 <?php echo $hcco_v3_data['critical_Fail_Behaviors'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
												</select> -->
											</td>
										</tr>
									    <tr>
											<td colspan=4>Recorded line was not mentioned/Not mentioned at the beginning of the call</td>
											<td>
												<select class="form-control hcco_v3_point"  id="hcco_Fail2" name="data[recorded_line]" disabled>
													<option hcco_v3_val=0 hcco_v3_max=0 <?php echo $hcco_v3_data['recorded_line'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option hcco_v3_val=0 hcco_v3_max=0 <?php echo $hcco_v3_data['recorded_line'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
												</select>
											</td>
										</tr>
										<tr>
											<td colspan=4>Leading the customer into selecting multiple matches/breaking down a larger remodel into multiple projects (Leading, CTT fishing, Submitting without homeowners knowledge or authorization)</td>
											<td>
												<select class="form-control hcco_v3_point" id="hcco_Fail3" name="data[leading_customer]" disabled>
													<option hcco_v3_val=0 hcco_v3_max=0 <?php echo $hcco_v3_data['leading_customer'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option hcco_v3_val=0 hcco_v3_max=0 <?php echo $hcco_v3_data['leading_customer'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
												</select>
											</td>
										</tr>
										<tr>
											<td colspan=4>Submitting the SR without authorization from the customer</td>
											<td>
												<select class="form-control hcco_v3_point" id="hcco_Fail4" name="data[Submitting_SR]" disabled>
													<option hcco_v3_val=0 hcco_v3_max=0 <?php echo $hcco_v3_data['Submitting_SR'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option hcco_v3_val=0 hcco_v3_max=0 <?php echo $hcco_v3_data['Submitting_SR'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
												</select>
											</td>
										</tr>
										<tr>
											<td colspan=4>Credit Card information was recorded</td>
											<td>
												<select class="form-control hcco_v3_point" id="hcco_Fail5" name="data[credit_Card_information]" disabled>
													<option hcco_v3_val=0 hcco_v3_max=0 <?php echo $hcco_v3_data['credit_Card_information'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option hcco_v3_val=0 hcco_v3_max=0 <?php echo $hcco_v3_data['credit_Card_information'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
												</select>
											</td>
										</tr>
										<tr>
											<td colspan=4>Not adding a DNC in Betti when a customer requests it</td>
											<td>
												<select class="form-control hcco_v3_point" id="hcco_Fail6" name="data[adding_DNC]" disabled>
													<option hcco_v3_val=0 hcco_v3_max=0 <?php echo $hcco_v3_data['adding_DNC'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option hcco_v3_val=0 hcco_v3_max=0 <?php echo $hcco_v3_data['adding_DNC'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
												</select>
											</td>
										</tr>
										<tr>
											<td colspan=4>No Disposition</td>
											<td>
												<select class="form-control hcco_v3_point" id="hcco_Fail7" name="data[no_Disposition]" disabled>
													<option hcco_v3_val=0 hcco_v3_max=0 <?php echo $hcco_v3_data['no_Disposition'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option hcco_v3_val=0 hcco_v3_max=0 <?php echo $hcco_v3_data['no_Disposition'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
												</select>
											</td>
										</tr>
										<tr>
											<td colspan=4>Offered pre-priced in one of the forbidden states (FL, IN, KY, AZ)</td>
											<td>
												<select class="form-control hcco_v3_point" id="hcco_Fail8" name="data[offered_pre_priced]" disabled>
													<option hcco_v3_val=0 hcco_v3_max=0 <?php echo $hcco_v3_data['offered_pre_priced'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option hcco_v3_val=0 hcco_v3_max=0 <?php echo $hcco_v3_data['offered_pre_priced'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
												</select>
											</td>
										</tr>
										<tr>
											<td colspan=4>Presented SR as just email information </td>
											<td>
												<select class="form-control hcco_v3_point" id="hcco_Fail9" name="data[presented_SR]" disabled>
													<option hcco_v3_val=0 hcco_v3_max=0 <?php echo $hcco_v3_data['presented_SR'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option hcco_v3_val=0 hcco_v3_max=0 <?php echo $hcco_v3_data['presented_SR'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
												</select>
											</td>
										</tr>
										<tr>
											<td colspan=4>Flagrantly inappropriate response (cursing, insulting, speaking negatively of company/agent/pro, etc.) - DISCIPLINARY ACTION disabled </td>
											<td>
												<select class="form-control hcco_v3_point" id="hcco_Fail10" name="data[flagrantly_inappropriate_response]" disabled>
													<option hcco_v3_val=0 hcco_v3_max=0 <?php echo $hcco_v3_data['flagrantly_inappropriate_response'] == "Pass" ? "selected" : ""; ?> value="Pass">Pass</option>
													<option hcco_v3_val=0 hcco_v3_max=0 <?php echo $hcco_v3_data['flagrantly_inappropriate_response'] == "Fail" ? "selected" : ""; ?> value="Fail">Fail</option>
												</select>
											</td>
										</tr>
										<tr>
											
											<td colspan=2 rowspan=3 style="font-weight:bold; color:red">Hygiene Sampling</td>
											<td colspan=4>Agent was not stella phishing?</td>
											<td></td>
											<td>
												<select class="form-control" name="data[stella_phishing]" disabled>
													<option hcco_v3_val=0 hcco_v3_max=0 <?php echo $hcco_v3_data['stella_phishing'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
													<option hcco_v3_val=0 hcco_v3_max=0 <?php echo $hcco_v3_data['stella_phishing'] == "Yes" ? "selected" : ""; ?> value="Yes">Yes</option>
													<option hcco_v3_val=0 hcco_v3_max=0 <?php echo $hcco_v3_data['stella_phishing'] == "No" ? "selected" : ""; ?> value="No">No</option>
													
													
												</select>
											</td>
										</tr>
										<tr>
											<td colspan=4>Agent was not avoiding Stella Survey?</td>
											<td></td>
											<td>
												<select class="form-control" name="data[avoiding_Stella_Survey]" disabled>
													<option hcco_v3_val=0 hcco_v3_max=0 <?php echo $hcco_v3_data['avoiding_Stella_Survey'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
													<option hcco_v3_val=0 hcco_v3_max=0 <?php echo $hcco_v3_data['avoiding_Stella_Survey'] == "Yes" ? "selected" : ""; ?> value="Yes">Yes</option>
													<option hcco_v3_val=0 hcco_v3_max=0 <?php echo $hcco_v3_data['avoiding_Stella_Survey'] == "No" ? "selected" : ""; ?> value="No">No</option>
													
													
												</select>
											</td>
										</tr>
										<tr>
											<td colspan=4>Attempted to Cross Sell?</td>
											<td></td>
											<td>
												<select class="form-control" name="data[attempted_Cross_Sell]" disabled>
													<option hcco_v3_val=0 hcco_v3_max=0 <?php echo $hcco_v3_data['attempted_Cross_Sell'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
													<option hcco_v3_val=0 hcco_v3_max=0 <?php echo $hcco_v3_data['attempted_Cross_Sell'] == "Yes" ? "selected" : ""; ?> value="Yes">Yes</option>
													<option hcco_v3_val=0 hcco_v3_max=0 <?php echo $hcco_v3_data['attempted_Cross_Sell'] == "No" ? "selected" : ""; ?> value="No">No</option>	
												</select>
											</td>
										</tr>
										<tr>
											
											<td colspan=2 rowspan=4 style="font-weight:bold; color:red">AHT Related Spot Check</td>
											<td colspan=4>Agent</td>
											<td></td>
											<td>
												<select class="form-control" name="data[AHT_agent]" disabled>
													<option hcco_v3_val=0 hcco_v3_max=0 <?php echo $hcco_v3_data['AHT_agent'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
													<option hcco_v3_val=0 hcco_v3_max=0 <?php echo $hcco_v3_data['AHT_agent'] == "Previous / Other Agent" ? "selected" : ""; ?> value="Previous / Other Agent">Previous / Other Agent</option>
													<option hcco_v3_val=0 hcco_v3_max=0 <?php echo $hcco_v3_data['AHT_agent'] == "Product Knowledge" ? "selected" : ""; ?> value="Product Knowledge">Product Knowledge</option>
													<option hcco_v3_val=0 hcco_v3_max=0 <?php echo $hcco_v3_data['AHT_agent'] == "Resolution" ? "selected" : ""; ?> value="Resolution">Resolution</option>
													<option hcco_v3_val=0 hcco_v3_max=0 <?php echo $hcco_v3_data['AHT_agent'] == "Soft Skills" ? "selected" : ""; ?> value="Soft Skills">Soft Skills</option>
												</select>
											</td>
										</tr>
										<tr>
											<td colspan=4>Customer</td>
											<td></td>
											<td>
												<select class="form-control" name="data[AHT_customer]" disabled>
													<option hcco_v3_val=0 hcco_v3_max=0 <?php echo $hcco_v3_data['AHT_customer'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
													<option hcco_v3_val=0 hcco_v3_max=0 <?php echo $hcco_v3_data['AHT_customer'] == "Call disconnected" ? "selected" : ""; ?> value="Call disconnected">Call disconnected</option>
													<option hcco_v3_val=0 hcco_v3_max=0 <?php echo $hcco_v3_data['AHT_customer'] == "Customer on hold" ? "selected" : ""; ?> value="Customer on hold">Customer on hold</option>
													<option hcco_v3_val=0 hcco_v3_max=0 <?php echo $hcco_v3_data['AHT_customer'] == "Know It All Customer" ? "selected" : ""; ?> value="Know It All Customer">Know It All Customer</option>
													<option hcco_v3_val=0 hcco_v3_max=0 <?php echo $hcco_v3_data['AHT_customer'] == "Multiple concern/request" ? "selected" : ""; ?> value="Multiple concern/request">Multiple concern/request</option>
												</select>
											</td>
										</tr>
										<tr>
											<td colspan=4>Process</td>
											<td></td>
											<td>
												<select class="form-control" name="data[AHT_process]" disabled>
													<option hcco_v3_val=0 hcco_v3_max=0 <?php echo $hcco_v3_data['AHT_process'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
													<option hcco_v3_val=0 hcco_v3_max=0 <?php echo $hcco_v3_data['AHT_process'] == "Rules and Protocols" ? "selected" : ""; ?> value="Rules and Protocols">Rules and Protocols</option>
												</select>
											</td>
										</tr>
										<tr>
											<td colspan=4>Technology</td>
											<td></td>
											<td>
												<select class="form-control" name="data[AHT_technology]" disabled>
													<option hcco_v3_val=0 hcco_v3_max=0 <?php echo $hcco_v3_data['AHT_technology'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
													<option hcco_v3_val=0 hcco_v3_max=0 <?php echo $hcco_v3_data['AHT_technology'] == "Betti Latency" ? "selected" : ""; ?> value="Betti Latency">Betti Latency</option>
													<option hcco_v3_val=0 hcco_v3_max=0 <?php echo $hcco_v3_data['AHT_technology'] == "System Downtime" ? "selected" : ""; ?> value="System Downtime">System Downtime</option>
												</select>
											</td>
										</tr>
										<tr>
											
											<td colspan=2 rowspan=4 style="font-weight:bold; color:red">Conversion Related Spot Check</td>
											<td colspan=4>Agent</td>
											<td></td>
											<td>
												<select class="form-control" name="data[Conversion_agent]" disabled>
													<option hcco_v3_val=0 hcco_v3_max=0 <?php echo $hcco_v3_data['Conversion_agent'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
													<option hcco_v3_val=0 hcco_v3_max=0 <?php echo $hcco_v3_data['Conversion_agent'] == "Previous / Other Agent" ? "selected" : ""; ?> value="Previous / Other Agent">Previous / Other Agent</option>
													<option hcco_v3_val=0 hcco_v3_max=0 <?php echo $hcco_v3_data['Conversion_agent'] == "Product Knowledge" ? "selected" : ""; ?> value="Product Knowledge">Product Knowledge</option>
													<option hcco_v3_val=0 hcco_v3_max=0 <?php echo $hcco_v3_data['Conversion_agent'] == "Soft Skills" ? "selected" : ""; ?> value="Soft Skills">Soft Skills</option>
												</select>
											</td>
										</tr>
										<tr>
											<td colspan=4>Customer</td>
											<td></td>
											<td>
												<select class="form-control" name="data[Conversion_customer]" disabled>
													<option hcco_v3_val=0 hcco_v3_max=0 <?php echo $hcco_v3_data['Conversion_customer'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
													<option hcco_v3_val=0 hcco_v3_max=0 <?php echo $hcco_v3_data['Conversion_customer'] == "Customer on hold" ? "selected" : ""; ?> value="Customer on hold">Customer on hold</option>
													<option hcco_v3_val=0 hcco_v3_max=0 <?php echo $hcco_v3_data['Conversion_customer'] == "In a hurry" ? "selected" : ""; ?> value="In a hurry">In a hurry</option>
													<option hcco_v3_val=0 hcco_v3_max=0 <?php echo $hcco_v3_data['Conversion_customer'] == "Know It All Customer" ? "selected" : ""; ?> value="Know It All Customer">Know It All Customer</option>
													<option hcco_v3_val=0 hcco_v3_max=0 <?php echo $hcco_v3_data['Conversion_customer'] == "Not in Need" ? "selected" : ""; ?> value="Not in Need">Not in Need</option>
													<option hcco_v3_val=0 hcco_v3_max=0 <?php echo $hcco_v3_data['Conversion_customer'] == "Pro Related Bad Experience" ? "selected" : ""; ?> value="Pro Related Bad Experience">Pro Related Bad Experience</option>
													<option hcco_v3_val=0 hcco_v3_max=0 <?php echo $hcco_v3_data['Conversion_customer'] == "Self Service" ? "selected" : ""; ?> value="Self Service">Self Service</option>
													<option hcco_v3_val=0 hcco_v3_max=0 <?php echo $hcco_v3_data['Conversion_customer'] == "Undecided" ? "selected" : ""; ?> value="Undecided">Undecided</option>
												</select>
											</td>
										</tr>
										<tr>
											<td colspan=4>Process</td>
											<td></td>
											<td>
												<select class="form-control" name="data[Conversion_process]" disabled>
													<option hcco_v3_val=0 hcco_v3_max=0 <?php echo $hcco_v3_data['Conversion_process'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
													<option hcco_v3_val=0 hcco_v3_max=0 <?php echo $hcco_v3_data['Conversion_process'] == "Rules and Protocols" ? "selected" : ""; ?> value="Rules and Protocols">Rules and Protocols</option>
												</select>
											</td>
										</tr>
										<tr>
											<td colspan=4>Technology</td>
											<td></td>
											<td>
												<select class="form-control" name="data[Conversion_technology]" disabled>
													<option hcco_v3_val=0 hcco_v3_max=0 <?php echo $hcco_v3_data['Conversion_technology'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
													<option hcco_v3_val=0 hcco_v3_max=0 <?php echo $hcco_v3_data['Conversion_technology'] == "Betti Latency" ? "selected" : ""; ?> value="Betti Latency">Betti Latency</option>
													<option hcco_v3_val=0 hcco_v3_max=0 <?php echo $hcco_v3_data['Conversion_technology'] == "System Downtime" ? "selected" : ""; ?> value="System Downtime">System Downtime</option>
												</select>
											</td>
										</tr>
										<tr>
											
											<td colspan=2 rowspan=4 style="font-weight:bold; color:red">SR/HR Related Spot Check</td>
											<td colspan=4>Agent</td>
											<td></td>
											<td>
												<select class="form-control" name="data[SR_agent]" disabled>
													<option hcco_v3_val=0 hcco_v3_max=0 <?php echo $hcco_v3_data['SR_agent'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
													<option hcco_v3_val=0 hcco_v3_max=0 <?php echo $hcco_v3_data['SR_agent'] == "Previous / Other Agent" ? "selected" : ""; ?> value="Previous / Other Agent">Previous / Other Agent</option>
													<option hcco_v3_val=0 hcco_v3_max=0 <?php echo $hcco_v3_data['SR_agent'] == "Product Knowledge" ? "selected" : ""; ?> value="Product Knowledge">Product Knowledge</option>	
													<option hcco_v3_val=0 hcco_v3_max=0 <?php echo $hcco_v3_data['SR_agent'] == "Resolution" ? "selected" : ""; ?> value="Resolution">Resolution</option>	
													<option hcco_v3_val=0 hcco_v3_max=0 <?php echo $hcco_v3_data['SR_agent'] == "Soft Skills" ? "selected" : ""; ?> value="Soft Skills">Soft Skills</option>	
												</select>
											</td>
										</tr>
										<tr>
											<td colspan=4>Customer</td>
											<td></td>
											<td>
												<select class="form-control" name="data[SR_customer]" disabled>
													<option hcco_v3_val=0 hcco_v3_max=0 <?php echo $hcco_v3_data['SR_customer'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
													<option hcco_v3_val=0 hcco_v3_max=0 <?php echo $hcco_v3_data['SR_customer'] == "Customer on hold" ? "selected" : ""; ?> value="Customer on hold">Customer on hold</option>
													<option hcco_v3_val=0 hcco_v3_max=0 <?php echo $hcco_v3_data['SR_customer'] == "In a hurry" ? "selected" : ""; ?> value="In a hurry">In a hurry</option>
													<option hcco_v3_val=0 hcco_v3_max=0 <?php echo $hcco_v3_data['SR_customer'] == "Know It All Customer" ? "selected" : ""; ?> value="Know It All Customer">Know It All Customer</option>	
													<option hcco_v3_val=0 hcco_v3_max=0 <?php echo $hcco_v3_data['SR_customer'] == "Not in Need" ? "selected" : ""; ?> value="Not in Need">Not in Need</option>	
													<option hcco_v3_val=0 hcco_v3_max=0 <?php echo $hcco_v3_data['SR_customer'] == "Pricy Pro" ? "selected" : ""; ?> value="Pricy Pro">Pricy Pro</option>	
													<option hcco_v3_val=0 hcco_v3_max=0 <?php echo $hcco_v3_data['SR_customer'] == "Pro Related Bad Experience" ? "selected" : ""; ?> value="Pro Related Bad Experience">Pro Related Bad Experience</option>		
													<option hcco_v3_val=0 hcco_v3_max=0 <?php echo $hcco_v3_data['SR_customer'] == "Self Service" ? "selected" : ""; ?> value="Self Service">Self Service</option>
													<option hcco_v3_val=0 hcco_v3_max=0 <?php echo $hcco_v3_data['SR_customer'] == "Undecided" ? "selected" : ""; ?> value="Undecided">Undecided</option>		
												</select>
											</td>
										</tr>
										<tr>
											<td colspan=4>Process</td>
											<td></td>
											<td>
												<select class="form-control" name="data[SR_process]" disabled>
													<option hcco_v3_val=0 hcco_v3_max=0 <?php echo $hcco_v3_data['SR_process'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
													<option hcco_v3_val=0 hcco_v3_max=0 <?php echo $hcco_v3_data['SR_process'] == "Rules and Protocols" ? "selected" : ""; ?> value="Rules and Protocols">Rules and Protocols</option>
												</select>
											</td>
										</tr>
										<tr>
											<td colspan=4>Technology</td>
											<td></td>
											<td>
												<select class="form-control" name="data[SR_technology]" disabled>
													<option hcco_v3_val=0 hcco_v3_max=0 <?php echo $hcco_v3_data['SR_technology'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
													<option hcco_v3_val=0 hcco_v3_max=0 <?php echo $hcco_v3_data['SR_technology'] == "Betti Latency" ? "selected" : ""; ?> value="Betti Latency">Betti Latency</option>
													<option hcco_v3_val=0 hcco_v3_max=0 <?php echo $hcco_v3_data['SR_technology'] == "System Downtime" ? "selected" : ""; ?> value="System Downtime">System Downtime</option>	
												</select>
											</td>
										</tr>
										<tr>
											
											<td colspan=2 rowspan=4 style="font-weight:bold; color:red">CSAT Related Spot Check</td>
											<td colspan=4>Agent</td>
											<td></td>
											<td>
												<select class="form-control" name="data[CSAT_agent]" disabled>
													<option hcco_v3_val=0 hcco_v3_max=0 <?php echo $hcco_v3_data['CSAT_agent'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
													<option hcco_v3_val=0 hcco_v3_max=0 <?php echo $hcco_v3_data['CSAT_agent'] == "Previous / Other Agent" ? "selected" : ""; ?> value="Previous / Other Agent">Previous / Other Agent</option>
													<option hcco_v3_val=0 hcco_v3_max=0 <?php echo $hcco_v3_data['CSAT_agent'] == "Product Knowledge" ? "selected" : ""; ?> value="Product Knowledge">Product Knowledge</option>
													<option hcco_v3_val=0 hcco_v3_max=0 <?php echo $hcco_v3_data['CSAT_agent'] == "Resolution" ? "selected" : ""; ?> value="Resolution">Resolution</option>	
													<option hcco_v3_val=0 hcco_v3_max=0 <?php echo $hcco_v3_data['CSAT_agent'] == "Soft Skills" ? "selected" : ""; ?> value="Soft Skills">Soft Skills</option>		
												</select>
											</td>
										</tr>
										<tr>
											<td colspan=4>Customer</td>
											<td></td>
											<td>
												<select class="form-control" name="data[CSAT_customer]" disabled>
													<option hcco_v3_val=0 hcco_v3_max=0 <?php echo $hcco_v3_data['CSAT_customer'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
													<option hcco_v3_val=0 hcco_v3_max=0 <?php echo $hcco_v3_data['CSAT_customer'] == "Know It All Customer" ? "selected" : ""; ?> value="Know It All Customer">Know It All Customer</option>	
												</select>
											</td>
										</tr>
										<tr>
											<td colspan=4>Process</td>
											<td></td>
											<td>
												<select class="form-control" name="data[CSAT_process]" disabled>
													<option hcco_v3_val=0 hcco_v3_max=0 <?php echo $hcco_v3_data['CSAT_process'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
													<option hcco_v3_val=0 hcco_v3_max=0 <?php echo $hcco_v3_data['CSAT_process'] == "Rules and Protocols" ? "selected" : ""; ?> value="Rules and Protocols">Rules and Protocols</option>
												</select>
											</td>
										</tr>
										<tr>
											<td colspan=4>Technology</td>
											<td></td>
											<td>
												<select class="form-control" name="data[CSAT_technology]" disabled>
													<option hcco_v3_val=0 hcco_v3_max=0 <?php echo $hcco_v3_data['CSAT_technology'] == "N/A" ? "selected" : ""; ?> value="N/A">N/A</option>
													<option hcco_v3_val=0 hcco_v3_max=0 <?php echo $hcco_v3_data['CSAT_technology'] == "System Downtime" ? "selected" : ""; ?> value="System Downtime">System Downtime</option>
													<option hcco_v3_val=0 hcco_v3_max=0 <?php echo $hcco_v3_data['CSAT_technology'] == "Betti Latency" ? "selected" : ""; ?> value="Betti Latency">Betti Latency</option>	
												</select>
											</td>
										</tr>									
									<tr style="font-weight:bold; background-color:#D7BDE2"><td colspan=2>Customer Score</td><td colspan=2>Business Score</td><td colspan=4>Compliance Score</td></tr>

									<tr style="font-weight:bold; background-color:#D7BDE2">
										<td>Earned Point:</td><td ><input type="text" readonly class="form-control" id="customer_earned_score" name="data[customer_earned_score]" value="<?php echo $hcco_v3_data['customer_earned_score'] ?>"></td>
										<td>Earned Point:</td><td ><input type="text" readonly class="form-control" id="business_earned_score" name="data[business_earned_score]" value="<?php echo $hcco_v3_data['business_earned_score'] ?>"></td>
										<td colspan=2>Earned Point:</td><td colspan=2><input type="text" readonly class="form-control" id="compliance_earned_score" name="data[compliance_earned_score]" value="<?php echo $hcco_v3_data['compliance_earned_score'] ?>"></td>
									</tr>
									<tr style="font-weight:bold; background-color:#D7BDE2">
										<td>Possible Point:</td><td ><input type="text" readonly class="form-control" id="customer_possible_score" name="data[customer_possible_score]" value="<?php echo $hcco_v3_data['customer_possible_score'] ?>"></td>
										<td>Possible Point:</td><td ><input type="text" readonly class="form-control" id="business_possible_score" name="data[business_possible_score]" value="<?php echo $hcco_v3_data['business_possible_score'] ?>"></td>
										<td colspan=2>Possible Point:</td><td colspan=2><input type="text" readonly class="form-control" id="compliance_possible_score" name="data[compliance_possible_score]" value="<?php echo $hcco_v3_data['compliance_possible_score'] ?>"></td>
									</tr>
									<tr style="font-weight:bold; background-color:#D7BDE2">
										<td>Overall Percentage:</td><td ><input type="text" readonly class="form-control" id="customer_overall_score" name="data[customer_overall_score]" value="<?php echo $hcco_v3_data['customer_overall_score'] ?>"></td>
										<td>Overall Percentage:</td><td ><input type="text" readonly class="form-control" id="business_overall_score" name="data[business_overall_score]" value="<?php echo $hcco_v3_data['business_overall_score'] ?>"></td>
										<td colspan=2>Overall Percentage:</td><td colspan=2><input type="text" readonly class="form-control" id="compliance_overall_score" name="data[compliance_overall_score]" value="<?php echo $hcco_v3_data['compliance_overall_score'] ?>"></td>
									</tr>
										<tr>
											<td>Call Summary:</td>
											<td colspan=2><textarea class="form-control" disabled name="data[call_summary]"><?php echo $hcco_v3_data['call_summary'] ?></textarea></td>
											<td>Feedback:</td>
											<td colspan=4><textarea class="form-control" disabled name="data[feedback]"><?php echo $hcco_v3_data['feedback'] ?></textarea></td>
										</tr>
										<?php if($hcco_v3_data['attach_file']!=''){ ?>
									<tr oncontextmenu="return false;">
										<td colspan="2">Audio Files (Mp4/Mp3/M4a/Wav)</td>
										<td colspan="4">
											<?php $attach_file = explode(",",$hcco_v3_data['attach_file']);
											 foreach($attach_file as $af){ ?>
												<audio oncontextmenu="return false;" controls controlslist="nodownload" style="background-color:#607F93">
													  <source src="<?php echo base_url(); ?>qa_files/qa_homeadvisor/hcco_qa_v3/<?php echo $af; ?>" type="audio/ogg">
													  <source src="<?php echo base_url(); ?>qa_files/qa_homeadvisor/hcco_qa_v3/<?php echo $af; ?>" type="audio/mpeg">
												</audio> </br>
											 <?php } ?>
										</td>
									</tr>
									<?php } ?>

									<tr>
										<td style="font-size:12px">Manager Review:</td>
										<td colspan="8" style="text-align:left"><?php echo $hcco_v3_data['mgnt_rvw_note'] ?></td>
									</tr>
									<tr>
										<td style="font-size:12px">Client Review:</td>
										<td colspan="8" style="text-align:left"><?php echo $hcco_v3_data['client_rvw_note'] ?></td>
									</tr>
									<tr><td colspan="6" style="background-color:#C5C8C8"></td></tr>
									
									 <form id="form_agent_user" method="POST" action="">
										<input type="hidden" name="pnid" class="form-control" value="<?php echo $pnid; ?>">
										
										<tr>
											<td colspan=2 style="font-size:16px">Feedback Acceptance<span style="font-size:24px;color:red">*</span></td>
											<td colspan=2>
												<select class="form-control" id="" name="agnt_fd_acpt" required="">
													<option value="">--Select--</option>
													<option <?php echo $hcco_v3_data['agnt_fd_acpt']=='Acceptance'?"selected":""; ?> value="Acceptance">Acceptance</option>	
													<option <?php echo $hcco_v3_data['agnt_fd_acpt']=='Not Acceptance'?"selected":""; ?> value="Not Acceptance">Not Acceptance</option>	
												</select>
											</td>
										</tr>
										<tr>
											<td colspan=2 style="font-size:16px">Your Review<span style="font-size:24px;color:red">*</span></td>
											<td colspan=4><textarea class="form-control" name="note" required><?php echo $hcco_v3_data['agent_rvw_note'] ?></textarea></td>
										</tr>
										
										<?php if(is_access_qa_agent_module()==true){
										if(is_available_qa_feedback($hcco_v3_data['entry_date'],72) == true){ ?>
											<tr>
												<?php if($hcco_v3_data['agent_rvw_note']==''){ ?>
													<td colspan="6"><button class="btn btn-success waves-effect" type="submit" id='btnagentSave' name='btnSave' value="SAVE" style="width:500px;margin:auto;display:block;">SAVE</button></td>
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