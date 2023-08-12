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
											<td colspan="8" id="theader" style="font-size:40px; text-align:center!important; ">Craftjack Inbound / Outbound QA FORM</td>
											<input type="hidden" name="audit_start_time" value="<?php echo CurrMySqlDate(); ?>">
										</tr>

										<?php
										
											if ($craftjack_inbound_outbound_data['entry_by'] != '') {
												$auditorName = $craftjack_inbound_outbound_data['auditor_name'];
											} else {
												$auditorName = $craftjack_inbound_outbound_data['client_name'];
											}
											$clDate_val = mysql2mmddyySls($craftjack_inbound_outbound_data['call_date']);
											$auditDate = mysql2mmddyySls($craftjack_inbound_outbound_data['audit_date']);
										
										if ($rand_id != 0) {
											$agent_id = $rand_data['sid'];
											$fusion_id = $rand_data['fusion_id'];
											$agent_name = $rand_data['fname'] . " " . $rand_data['lname'];
											$tl_id = $rand_data['assigned_to'];
											$tl_name = $rand_data['tl_name'];
											$call_duration = $rand_data['call_duration'];
											
										} else {
											$agent_id = $craftjack_inbound_outbound_data['agent_id'];
											$fusion_id = $craftjack_inbound_outbound_data['fusion_id'];
											$agent_name = $craftjack_inbound_outbound_data['fname'] . " " . $craftjack_inbound_outbound_data['lname'] ;
											$tl_id = $craftjack_inbound_outbound_data['tl_id'];
											$tl_name = $craftjack_inbound_outbound_data['tl_name'];
											$call_duration = $craftjack_inbound_outbound_data['call_duration'];
										}
										?>

										<tr>
											<td>Auditor Name: <span style="font-size:24px;color:red">*</span></td>
											<td colspan="2"><input type="text" class="form-control" value="<?= $auditorName; ?>" disabled></td>
											<td>Audit Date:<span style="font-size:24px;color:red">*</span></td>
											<td colspan="2"><input type="text" class="form-control" value="<?= $auditDate; ?>" disabled></td>
											<td>Location:<span style="font-size:24px;color:red">*</span></td>
											<td colspan="2">
												<select class="form-control" id="location" name="data[location]" disabled>
											
											    <option value="">-Select-</option>
											    <option value="Jamaica" <?= ($craftjack_inbound_outbound_data['location']=="Jamaica")?"selected":"" ?>>Jamaica</option>
												<option value="Cebu" <?= ($craftjack_inbound_outbound_data['location']=="Cebu")?"selected":"" ?>>Cebu</option>
												<option value="ESal" <?= ($craftjack_inbound_outbound_data['location']=="ESal")?"selected":"" ?>>ESal</option>
										</select>
											</td>
											
										</tr>
										<tr>
											<td>Call Date:<span style="font-size:24px;color:red">*</span></td>
											<td colspan="2">
												<input type="text" id="call_date" name="call_date"  onkeydown="return false;" value="<?php echo $clDate_val; ?>" max="<?php echo date("Y-m-d"); ?>" class="form-control" disabled>
											</td>
											<td>Agent Name:<span style="font-size:24px;color:red">*</span></td>
											<td colspan="2">
												<select class="form-control" id="agent_ids" name="data[agent_id]" disabled>
													<?php 
													if($craftjack_inbound_outbound_data['agent_id']!=''){
														?>
														<option value="<?php echo $craftjack_inbound_outbound_data['agent_id'] ?>"><?php echo $agent_name?></option>
														<?php
													}else{
														?>
														<option value="">Select</option>
														<?php
													}
													?>
													
													
													<?php foreach ($agentName as $row) :  ?>
													<?php 
													if($row['id'] == $craftjack_inbound_outbound_data['agent_id']){
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
											<td colspan="2"><input type="text" class="form-control" id="fusion_id" disabled value="<?php echo $craftjack_inbound_outbound_data['fusion_id'] ?>" readonly></td>
											
										</tr>
										<tr>
											<td> L1 Supervisor:<span style="font-size:24px;color:red">*</span></td>
											<td colspan="2">

												<input type="text" class="form-control" id="tl_names"  value="<?php echo $tl_name ?>" readonly>
												<input type="hidden" class="form-control" id="tl_id" name="data[tl_id]" value="<?php echo $craftjack_inbound_outbound_data['tl_id'] ?>" disabled>
											</td>
											<td>Type of Call:<span style="font-size:24px;color:red">*</span></td>
											<td colspan="2">
												<select class="form-control" id="type_of_call" name="data[call_type]" disabled>
											
											    <option value="">-Select-</option>
											    <option value="IB" <?= ($craftjack_inbound_outbound_data['call_type']=="IB")?"selected":"" ?>>IB</option>
												<option value="OB" <?= ($craftjack_inbound_outbound_data['call_type']=="OB")?"selected":"" ?>>OB</option>
											
										</select>
											</td>
											<td>Customer Number:<span style="font-size:24px;color:red">*</span></td>
											<td colspan="2"><input type="text" class="form-control" name="data[phone_no]" value="<?php echo $craftjack_inbound_outbound_data['phone_no'] ?>" onkeyup="checkDec(this);" disabled>
												<span id="start_phone" style="color:red"></span></td>
										</tr>
										<tr>
											<td>No of SR: <span style="font-size:24px;color:red">*</span></td>
											<td colspan="2">
												<input type="text" class="form-control" name="data[no_of_SR]" value="<?php echo $craftjack_inbound_outbound_data['no_of_SR'] ?>" disabled>
											</td>
											<td>SR/Link:<span style="font-size:24px;color:red">*</span></td>
											<td colspan="2">
												<input type="text" class="form-control" name="data[sr_link]" value="<?php echo $craftjack_inbound_outbound_data['sr_link'] ?>" disabled>
											</td>
											<td>Customer Name:<span style="font-size:24px;color:red">*</span></td>
											<td colspan="2">
												<input type="text" class="form-control" name="data[customer_name]" value="<?php echo $craftjack_inbound_outbound_data['customer_name'] ?>" disabled>
											</td>
											
										</tr>
										<tr>
											<td>Call Duration:<span style="font-size:24px;color:red">*</span></td>
											<td colspan="2"><input type="text" class="form-control" onkeydown="return false;" id="call_duration" name="data[call_duration]" value="<?php echo $call_duration; ?>" disabled></td>
											<td>VOC:<span style="font-size:24px;color:red">*</span></td>

											<td colspan="2">
												<select class="form-control" id="voc" name="data[voc]" disabled>
													
													<option value="">-Select-</option>
													<option value="1"  <?= ($craftjack_inbound_outbound_data['voc']=="1")?"selected":"" ?>>1</option>
													<option value="2"  <?= ($craftjack_inbound_outbound_data['voc']=="2")?"selected":"" ?>>2</option>
													<option value="3"  <?= ($craftjack_inbound_outbound_data['voc']=="3")?"selected":"" ?>>3</option>
													<option value="4"  <?= ($craftjack_inbound_outbound_data['voc']=="4")?"selected":"" ?>>4</option>
													<option value="5"  <?= ($craftjack_inbound_outbound_data['voc']=="5")?"selected":"" ?>>5</option>
													<option value="6"  <?= ($craftjack_inbound_outbound_data['voc']=="6")?"selected":"" ?>>6</option>
													<option value="7"  <?= ($craftjack_inbound_outbound_data['voc']=="7")?"selected":"" ?>>7</option>
													<option value="8"  <?= ($craftjack_inbound_outbound_data['voc']=="8")?"selected":"" ?>>8</option>
													<option value="9"  <?= ($craftjack_inbound_outbound_data['voc']=="9")?"selected":"" ?>>9</option>
													<option value="10"  <?= ($craftjack_inbound_outbound_data['voc']=="10")?"selected":"" ?>>10</option>
												</select>
											</td>
											<td>Audit Type:<span style="font-size:24px;color:red">*</span></td>
											<td colspan="2">
												<select class="form-control" id="audit_type" name="data[audit_type]" disabled>
                                                    <option value="">-Select-</option>
                                                    <option value="CQ Audit" <?= ($craftjack_inbound_outbound_data['audit_type']=="CQ Audit")?"selected":"" ?>>CQ Audit</option>
                                                    <option value="BQ Audit" <?= ($craftjack_inbound_outbound_data['audit_type']=="BQ Audit")?"selected":"" ?>>BQ Audit</option>
                                                    <option value="Calibration" <?= ($craftjack_inbound_outbound_data['audit_type']=="Calibration")?"selected":"" ?>>Calibration</option>
                                                    <option value="Pre-Certificate Mock Call" <?= ($craftjack_inbound_outbound_data['audit_type']=="Pre-Certificate Mock Call")?"selected":"" ?>>Pre-Certificate Mock Call</option>
                                                    <option value="Certification Audit" <?= ($craftjack_inbound_outbound_data['audit_type']=="Certification Audit")?"selected":"" ?>>Certification Audit</option>
                                                    <option value="WOW Call"  <?= ($craftjack_inbound_outbound_data['audit_type']=="WOW Call")?"selected":"" ?>>WOW Call</option>  
                                                </select>
											</td>
										
										</tr>
										<tr>
											<td class="auType_epi">Auditor Type<span style="font-size:24px;color:red">*</span></td>
											<td class="auType_epi">
												<select class="form-control" id="auditor_type" name="data[auditor_type]">
                                                    <option value="">Select</option>
                                                    <option value="Master" <?= ($craftjack_inbound_outbound_data['auditor_type']=="Master")?"selected":"" ?>>Master</option>
                                                    <option value="Regular" <?= ($craftjack_inbound_outbound_data['auditor_type']=="Regular")?"selected":"" ?>>Regular</option>
                                                </select>
											</td>
										</tr>
										<tr>
											<td style="font-weight:bold; font-size:16px; text-align:left">Earned Score</td>
											<td colspan="2"><input type="text" readonly id="mtl_earned_score" name="data[earned_score]" class="form-control" value="<?php echo $craftjack_inbound_outbound_data['earned_score'] ?>" /></td>
											<td style="font-weight:bold; font-size:16px; text-align:left">Possible Score</td>
											<td colspan="2"><input type="text" readonly id="mtl_possible_score" name="data[possible_score]" class="form-control" value="<?php echo $craftjack_inbound_outbound_data['possible_score'] ?>" /></td>
											<td style="font-weight:bold; font-size:16px; text-align:right">Overall Score:</td>
											<td colspan="2"><input type="text" readonly id="mtl_overall_score" name="data[overall_score]" class="form-control acgFatal" style="font-weight:bold" value="<?php echo $craftjack_inbound_outbound_data['overall_score'] ?>"></td>
										</tr>
										
										<tr class="eml" style="height:25px; font-weight:bold">
											<td colspan=3>PARAMETER</td>
											<td>WEIGHTAGE</td>
											<td>STATUS</td>
											<td colspan=2>REMARKS</td>
											<td>Critical Accuracy</td>
										</tr>

									<tr>
										<td style="background-color:#BFC9CA"><b>A</b></td>
										<td colspan=2 style="background-color:#BFC9CA">Introduction</td>
										<td style="background-color:#BFC9CA">20</td>
										<td style="background-color:#BFC9CA"></td>
										<td colspan=2 style="background-color:#BFC9CA"></td>
										<td style="background-color:#BFC9CA"></td>
									</tr>

									<tr>
										<td>IB/OB</td>
										<td colspan=2>Agent asked/mentioned customer's name?</td>
										<td>5</td>
										<td>
											<select class="form-control craftjack_inbound_outbound_point craftjack_IB_OB_point_ib craftjack_IB_OB_point_ob compliance compliance_ib compliance_ob" id="" name="data[intro_mentioned_customer_name]" disabled>
												<option craftjack_inbound_outbound_val=5 craftjack_inbound_outbound_max="5" <?php echo $craftjack_inbound_outbound_data['intro_mentioned_customer_name']=='Pass'?"selected":""; ?> value="Pass">Pass</option>
												<option craftjack_inbound_outbound_val=0 craftjack_inbound_outbound_max="5" <?php echo $craftjack_inbound_outbound_data['intro_mentioned_customer_name']=='Fail'?"selected":""; ?> value="Fail">Fail</option>
												<option craftjack_inbound_outbound_val=5 craftjack_inbound_outbound_max="5" <?php echo $craftjack_inbound_outbound_data['intro_mentioned_customer_name']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" name="data[cmt1]" class="form-control" value="<?php echo $craftjack_inbound_outbound_data['cmt1'] ?>"></td>
										<td style="font-weight:bold; background-color:#D7BDE2">Compliance</td>
									</tr>
									<tr>
										<td>IB/OB</td>
										<td colspan=2>Agent mentioned his/her name?</td>
										<td>5</td>
										<td>
											<select class="form-control craftjack_inbound_outbound_point craftjack_IB_OB_point_ib craftjack_IB_OB_point_ob compliance compliance_ib compliance_ob" id="" name="data[intro_agent_mentioned_name]" disabled>
												<option craftjack_inbound_outbound_val=5 craftjack_inbound_outbound_max="5" <?php echo $craftjack_inbound_outbound_data['intro_agent_mentioned_name']=='Pass'?"selected":""; ?> value="Pass">Pass</option>
												<option craftjack_inbound_outbound_val=0 craftjack_inbound_outbound_max="5" <?php echo $craftjack_inbound_outbound_data['intro_agent_mentioned_name']=='Fail'?"selected":""; ?> value="Fail">Fail</option>
												<option craftjack_inbound_outbound_val=5 craftjack_inbound_outbound_max="5" <?php echo $craftjack_inbound_outbound_data['intro_agent_mentioned_name']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" name="data[cmt2]" class="form-control" value="<?php echo $craftjack_inbound_outbound_data['cmt2'] ?>"></td>
										<td style="font-weight:bold; background-color:#D7BDE2">Compliance</td>
									</tr>
									<tr>
										<td>IB/OB</td>
										<td colspan=2>Agent confirmed Requested Job</td>
										<td>5</td>
										<td>
											<select class="form-control craftjack_inbound_outbound_point craftjack_IB_OB_point_ib craftjack_IB_OB_point_ob business business_ib business_ob" id="" name="data[intro_confirmed_requested_job]" disabled>
												<option craftjack_inbound_outbound_val=5 craftjack_inbound_outbound_max="5" <?php echo $craftjack_inbound_outbound_data['intro_confirmed_requested_job']=='Pass'?"selected":""; ?> value="Pass">Pass</option>
												<option craftjack_inbound_outbound_val=0 craftjack_inbound_outbound_max="5" <?php echo $craftjack_inbound_outbound_data['intro_confirmed_requested_job']=='Fail'?"selected":""; ?> value="Fail">Fail</option>
												<option craftjack_inbound_outbound_val=5 craftjack_inbound_outbound_max="5" <?php echo $craftjack_inbound_outbound_data['intro_confirmed_requested_job']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" name="data[cmt3]" class="form-control" value="<?php echo $craftjack_inbound_outbound_data['cmt3'] ?>"></td>
										<td style="font-weight:bold; background-color:#D7BDE2">Business</td>
									</tr>
									<tr>
										<td>IB/OB</td>
										<td colspan=2>Agent Opened call Properly (did the agent deliver the opening spiel within the first 5 seconds)</td>
										<td>5</td>
										<td>
											<select class="form-control craftjack_inbound_outbound_point craftjack_IB_OB_point_ib craftjack_IB_OB_point_ob compliance compliance_ib compliance_ob" id="" name="data[intro_opened_call_properly]" disabled>
												<option craftjack_inbound_outbound_val=5 craftjack_inbound_outbound_max="5" <?php echo $craftjack_inbound_outbound_data['intro_opened_call_properly']=='Pass'?"selected":""; ?> value="Pass">Pass</option>
												<option craftjack_inbound_outbound_val=0 craftjack_inbound_outbound_max="5" <?php echo $craftjack_inbound_outbound_data['intro_opened_call_properly']=='Fail'?"selected":""; ?> value="Fail">Fail</option>
												<option craftjack_inbound_outbound_val=5 craftjack_inbound_outbound_max="5" <?php echo $craftjack_inbound_outbound_data['intro_opened_call_properly']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" name="data[cmt4]" class="form-control" value="<?php echo $craftjack_inbound_outbound_data['cmt4'] ?>"></td>
										<td style="font-weight:bold; background-color:#D7BDE2">Business</td>
									</tr>
									
									<tr>
										<td style="background-color:#BFC9CA"><b>B</b></td>
										<td colspan=2 style="background-color:#BFC9CA">Follow Up</td>
										<td style="background-color:#BFC9CA">
											<input type="text" name="follow_up" id="follow_up" value="35" readonly>
										</td>
										<td style="background-color:#BFC9CA"></td>
										<td colspan=2 style="background-color:#BFC9CA"></td>
										<td style="background-color:#BFC9CA"></td>
									</tr>
									<tr>
										<td>IB/OB</td>
										<td colspan=2>Did the agent ask for brief description about the project?</td>
										<td>10</td>
										<td>
											<select class="form-control craftjack_inbound_outbound_point craftjack_IB_OB_point_ib craftjack_IB_OB_point_ob business business_ib business_ob" id="" name="data[follow_up_brief_description]" disabled>
												<option craftjack_inbound_outbound_val=10 craftjack_inbound_outbound_max="10" <?php echo $craftjack_inbound_outbound_data['follow_up_brief_description']=='Pass'?"selected":""; ?> value="Pass">Pass</option>
												<option craftjack_inbound_outbound_val=0 craftjack_inbound_outbound_max="10" <?php echo $craftjack_inbound_outbound_data['follow_up_brief_description']=='Fail'?"selected":""; ?> value="Fail">Fail</option>
												<option craftjack_inbound_outbound_val=10 craftjack_inbound_outbound_max="10" <?php echo $craftjack_inbound_outbound_data['follow_up_brief_description']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" name="data[cmt5]" class="form-control" value="<?php echo $craftjack_inbound_outbound_data['cmt5'] ?>"></td>
										<td style="font-weight:bold; background-color:#D7BDE2">Business</td>
									</tr>
									<tr>
										<td class="ib_show">IB</td>
										<td class="ib_show" colspan=2>Did the agent follow the questions to the panel?</td>
										<td class="ib_show">5</td>
										<td class="ib_show">
											<select class="form-control craftjack_inbound_outbound_point craftjack_IB_OB_point_ib  compliance compliance_ib" id="ib_show1" name="data[follow_up_questions_panel_ib]" disabled>
												<option craftjack_inbound_outbound_val=5 craftjack_inbound_outbound_max="5" <?php echo $craftjack_inbound_outbound_data['follow_up_questions_panel_ib']=='Pass'?"selected":""; ?> value="Pass">Pass</option>
												<option craftjack_inbound_outbound_val=0 craftjack_inbound_outbound_max="5" <?php echo $craftjack_inbound_outbound_data['follow_up_questions_panel_ib']=='Fail'?"selected":""; ?> value="Fail">Fail</option>
												<option craftjack_inbound_outbound_val=5 craftjack_inbound_outbound_max="5" <?php echo $craftjack_inbound_outbound_data['follow_up_questions_panel_ib']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td class="ib_show" colspan=2><input type="text" name="data[cmt6]" class="form-control" value="<?php echo $craftjack_inbound_outbound_data['cmt6'] ?>"></td>
										<td class="ib_show" style="font-weight:bold; background-color:#D7BDE2">Compliance</td>
									</tr>

									<tr>
										<td class="ib_show">IB</td>
										<td class="ib_show" colspan=2>Did the agent select the correct panel?</td>
										<td class="ib_show">5</td>
										<td class="ib_show">
											<select class="form-control craftjack_inbound_outbound_point craftjack_IB_OB_point_ib compliance compliance_ib" id="ib_show2" name="data[follow_up_access_correct_panel_ib]" disabled>
												<option craftjack_inbound_outbound_val=5 craftjack_inbound_outbound_max="5" <?php echo $craftjack_inbound_outbound_data['follow_up_access_correct_panel_ib']=='Pass'?"selected":""; ?> value="Pass">Pass</option>
												<option craftjack_inbound_outbound_val=0 craftjack_inbound_outbound_max="5" <?php echo $craftjack_inbound_outbound_data['follow_up_access_correct_panel_ib']=='Fail'?"selected":""; ?> value="Fail">Fail</option>
												<option craftjack_inbound_outbound_val=5 craftjack_inbound_outbound_max="5" <?php echo $craftjack_inbound_outbound_data['follow_up_access_correct_panel_ib']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td class="ib_show" colspan=2><input type="text" name="data[cmt7]" class="form-control" value="<?php echo $craftjack_inbound_outbound_data['cmt7'] ?>"></td>
										<td class="ib_show" style="font-weight:bold; background-color:#D7BDE2">Compliance</td>
									</tr>
									<tr>
										<td class="ob_show">OB</td>
										<td class="ob_show" colspan=2>Did the agent probe if Job done?</td>
										<td class="ob_show">5</td>
										<td class="ob_show">
											<select class="form-control craftjack_inbound_outbound_point craftjack_IB_OB_point_ob business business_ob" id="ob_show1" name="data[follow_up_probe_job_done_ob]" disabled>
												<option craftjack_inbound_outbound_val=5 craftjack_inbound_outbound_max="5" <?php echo $craftjack_inbound_outbound_data['follow_up_probe_job_done_ob']=='Pass'?"selected":""; ?> value="Pass">Pass</option>
												<option craftjack_inbound_outbound_val=0 craftjack_inbound_outbound_max="5" <?php echo $craftjack_inbound_outbound_data['follow_up_probe_job_done_ob']=='Fail'?"selected":""; ?> value="Fail">Fail</option>
												<option craftjack_inbound_outbound_val=5 craftjack_inbound_outbound_max="5" <?php echo $craftjack_inbound_outbound_data['follow_up_probe_job_done_ob']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td class="ob_show" colspan=2><input type="text" name="data[cmt8]" class="form-control" value="<?php echo $craftjack_inbound_outbound_data['cmt8'] ?>"></td>
										<td class="ob_show" style="font-weight:bold; background-color:#D7BDE2">Business</td>
									</tr>
									<tr>
										<td class="ob_show">OB</td>
										<td class="ob_show" colspan=2>Did the agent ask if the Job done by suggested company?</td>
										<td class="ob_show">5</td>
										<td class="ob_show">
											<select class="form-control craftjack_inbound_outbound_point craftjack_IB_OB_point_ob business business_ob" id="ob_show2" name="data[follow_up_job_done_by_suggested_company_ob]" disabled>
												<option craftjack_inbound_outbound_val=5 craftjack_inbound_outbound_max="5" <?php echo $craftjack_inbound_outbound_data['follow_up_job_done_by_suggested_company_ob']=='Pass'?"selected":""; ?> value="Pass">Pass</option>
												<option craftjack_inbound_outbound_val=0 craftjack_inbound_outbound_max="5" <?php echo $craftjack_inbound_outbound_data['follow_up_job_done_by_suggested_company_ob']=='Fail'?"selected":""; ?> value="Fail">Fail</option>
												<option craftjack_inbound_outbound_val=5 craftjack_inbound_outbound_max="5" <?php echo $craftjack_inbound_outbound_data['follow_up_job_done_by_suggested_company_ob']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td class="ob_show" colspan=2><input type="text" name="data[cmt9]" class="form-control" value="<?php echo $craftjack_inbound_outbound_data['cmt9'] ?>"></td>
										<td class="ob_show" style="font-weight:bold; background-color:#D7BDE2">Business</td>
									</tr>
									<tr>
										<td class="ob_show">OB</td>
										<td class="ob_show" colspan=2>Did  the agent probe experience (job done)?	</td>
										<td class="ob_show">5</td>
										<td class="ob_show">
											<select class="form-control craftjack_inbound_outbound_point craftjack_IB_OB_point_ob business business_ob" id="ob_show3" name="data[follow_up_probe_experience_ob]" disabled>
												<option craftjack_inbound_outbound_val=5 craftjack_inbound_outbound_max="5" <?php echo $craftjack_inbound_outbound_data['follow_up_probe_experience_ob']=='Pass'?"selected":""; ?> value="Pass">Pass</option>
												<option craftjack_inbound_outbound_val=0 craftjack_inbound_outbound_max="5" <?php echo $craftjack_inbound_outbound_data['follow_up_probe_experience_ob']=='Fail'?"selected":""; ?> value="Fail">Fail</option>
												<option craftjack_inbound_outbound_val=5 craftjack_inbound_outbound_max="5" <?php echo $craftjack_inbound_outbound_data['follow_up_probe_experience_ob']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td class="ob_show" colspan=2><input type="text" name="data[cmt10]" class="form-control" value="<?php echo $craftjack_inbound_outbound_data['cmt10'] ?>"></td>
										<td class="ob_show" style="font-weight:bold; background-color:#D7BDE2">Business</td>
									</tr>	
									<tr>
										<td style="background-color:#BFC9CA"><b>C</b></td>
										<td colspan=2 style="background-color:#BFC9CA">Communication</td>
										<td style="background-color:#BFC9CA">30</td>
										<td style="background-color:#BFC9CA"></td>
										<td colspan=2 style="background-color:#BFC9CA"></td>
										<td style="background-color:#BFC9CA"></td>
									</tr>
									<tr>
										<td>IB/OB</td>
										<td colspan=2>Active Listening</td>
										<td>5</td>
										<td>
											<select class="form-control craftjack_inbound_outbound_point craftjack_IB_OB_point_ib craftjack_IB_OB_point_ob customer customer_ib customer_ob" id="" name="data[communication_active_listening]" disabled>
												<option craftjack_inbound_outbound_val=5 craftjack_inbound_outbound_max="5" <?php echo $craftjack_inbound_outbound_data['communication_active_listening']=='Pass'?"selected":""; ?> value="Pass">Pass</option>
												<option craftjack_inbound_outbound_val=0 craftjack_inbound_outbound_max="5" <?php echo $craftjack_inbound_outbound_data['communication_active_listening']=='Fail'?"selected":""; ?> value="Fail">Fail</option>
												<option craftjack_inbound_outbound_val=5 craftjack_inbound_outbound_max="5" <?php echo $craftjack_inbound_outbound_data['communication_active_listening']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" name="data[cmt11]" class="form-control" value="<?php echo $craftjack_inbound_outbound_data['cmt11'] ?>"></td>
										<td style="font-weight:bold; background-color:#D7BDE2">Customer</td>
									</tr>
									<tr>
										<td>IB/OB</td>
										<td colspan=2>Call Etiquette</td>
										<td>5</td>
										<td>
											<select class="form-control craftjack_inbound_outbound_point craftjack_IB_OB_point_ib craftjack_IB_OB_point_ob customer customer_ib customer_ob" id="" name="data[communication_call_etiquette]" disabled>
												<option craftjack_inbound_outbound_val=5 craftjack_inbound_outbound_max="5" <?php echo $craftjack_inbound_outbound_data['communication_call_etiquette']=='Pass'?"selected":""; ?> value="Pass">Pass</option>
												<option craftjack_inbound_outbound_val=0 craftjack_inbound_outbound_max="5" <?php echo $craftjack_inbound_outbound_data['communication_call_etiquette']=='Fail'?"selected":""; ?> value="Fail">Fail</option>
												<option craftjack_inbound_outbound_val=5 craftjack_inbound_outbound_max="5" <?php echo $craftjack_inbound_outbound_data['communication_call_etiquette']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" name="data[cmt12]" class="form-control" value="<?php echo $craftjack_inbound_outbound_data['cmt12'] ?>"></td>
										<td style="font-weight:bold; background-color:#D7BDE2">Customer</td>
									</tr>
									<tr>
										<td>IB/OB</td>
										<td colspan=2>Dead Air</td>
										<td>5</td>
										<td>
											<select class="form-control craftjack_inbound_outbound_point craftjack_IB_OB_point_ib craftjack_IB_OB_point_ob customer customer_ib customer_ob" id="" name="data[communication_dead_air]" disabled>
												<option craftjack_inbound_outbound_val=5 craftjack_inbound_outbound_max="5" <?php echo $craftjack_inbound_outbound_data['communication_dead_air']=='Pass'?"selected":""; ?> value="Pass">Pass</option>
												<option craftjack_inbound_outbound_val=0 craftjack_inbound_outbound_max="5" <?php echo $craftjack_inbound_outbound_data['communication_dead_air']=='Fail'?"selected":""; ?> value="Fail">Fail</option>
												<option craftjack_inbound_outbound_val=5 craftjack_inbound_outbound_max="5" <?php echo $craftjack_inbound_outbound_data['communication_dead_air']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" name="data[cmt13]" class="form-control" value="<?php echo $craftjack_inbound_outbound_data['cmt13'] ?>"></td>
										<td style="font-weight:bold; background-color:#D7BDE2">Customer</td>
									</tr>
									<tr>
										<td>IB/OB</td>
										<td colspan=2>Interrupted customer</td>
										<td>5</td>
										<td>
											<select class="form-control craftjack_inbound_outbound_point craftjack_IB_OB_point_ib craftjack_IB_OB_point_ob customer customer_ib customer_ob" id="" name="data[communication_interrupted_customer]" disabled>
												<option craftjack_inbound_outbound_val=5 craftjack_inbound_outbound_max="5" <?php echo $craftjack_inbound_outbound_data['communication_interrupted_customer']=='Pass'?"selected":""; ?> value="Pass">Pass</option>
												<option craftjack_inbound_outbound_val=0 craftjack_inbound_outbound_max="5" <?php echo $craftjack_inbound_outbound_data['communication_interrupted_customer']=='Fail'?"selected":""; ?> value="Fail">Fail</option>
												<option craftjack_inbound_outbound_val=5 craftjack_inbound_outbound_max="5" <?php echo $craftjack_inbound_outbound_data['communication_interrupted_customer']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" name="data[cmt14]" class="form-control" value="<?php echo $craftjack_inbound_outbound_data['cmt14'] ?>"></td>
										<td style="font-weight:bold; background-color:#D7BDE2">Customer</td>
									</tr>
									<tr>
										<td>IB/OB</td>
										<td colspan=2>Ownership of call</td>
										<td>5</td>
										<td>
											<select class="form-control craftjack_inbound_outbound_point craftjack_IB_OB_point_ib craftjack_IB_OB_point_ob customer customer_ib customer_ob" id="" name="data[communication_ownership_call]" disabled>
												<option craftjack_inbound_outbound_val=5 craftjack_inbound_outbound_max="5" <?php echo $craftjack_inbound_outbound_data['communication_ownership_call']=='Pass'?"selected":""; ?> value="Pass">Pass</option>
												<option craftjack_inbound_outbound_val=0 craftjack_inbound_outbound_max="5" <?php echo $craftjack_inbound_outbound_data['communication_ownership_call']=='Fail'?"selected":""; ?> value="Fail">Fail</option>
												<option craftjack_inbound_outbound_val=5 craftjack_inbound_outbound_max="5" <?php echo $craftjack_inbound_outbound_data['communication_ownership_call']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" name="data[cmt15]" class="form-control" value="<?php echo $craftjack_inbound_outbound_data['cmt15'] ?>"></td>
										<td style="font-weight:bold; background-color:#D7BDE2">Customer</td>
									</tr>
									<tr>
										<td>IB/OB</td>
										<td colspan=2>Rate of speech / Clarity</td>
										<td>5</td>
										<td>
											<select class="form-control craftjack_inbound_outbound_point craftjack_IB_OB_point_ib craftjack_IB_OB_point_ob customer customer_ib customer_ob" id="" name="data[communication_rate_of_speech]" disabled>
												<option craftjack_inbound_outbound_val=5 craftjack_inbound_outbound_max="5" <?php echo $craftjack_inbound_outbound_data['communication_rate_of_speech']=='Pass'?"selected":""; ?> value="Pass">Pass</option>
												<option craftjack_inbound_outbound_val=0 craftjack_inbound_outbound_max="5" <?php echo $craftjack_inbound_outbound_data['communication_rate_of_speech']=='Fail'?"selected":""; ?> value="Fail">Fail</option>
												<option craftjack_inbound_outbound_val=5 craftjack_inbound_outbound_max="5" <?php echo $craftjack_inbound_outbound_data['communication_rate_of_speech']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" name="data[cmt16]" class="form-control" value="<?php echo $craftjack_inbound_outbound_data['cmt16'] ?>"></td>
										<td style="font-weight:bold; background-color:#D7BDE2">Customer</td>
									</tr>
									<tr>
										<td style="background-color:#BFC9CA"><b>D</b></td>
										<td colspan=2 style="background-color:#BFC9CA">Cross Sell</td>
										<td style="background-color:#BFC9CA">10</td>
										<td style="background-color:#BFC9CA"></td>
										<td colspan=2 style="background-color:#BFC9CA"></td>
										<td style="background-color:#BFC9CA"></td>
									</tr>
									<tr>
										<td>IB/OB</td>
										<td colspan=2>Rate of speech / Clarity</td>
										<td>10</td>
										<td>
											<select class="form-control craftjack_inbound_outbound_point craftjack_IB_OB_point_ib craftjack_IB_OB_point_ob business business_ib business_ob" id="" name="data[cross_sell_offered_upsell]" disabled>
												<option craftjack_inbound_outbound_val=10 craftjack_inbound_outbound_max="10" <?php echo $craftjack_inbound_outbound_data['cross_sell_offered_upsell']=='Pass'?"selected":""; ?> value="Pass">Pass</option>
												<option craftjack_inbound_outbound_val=0 craftjack_inbound_outbound_max="10" <?php echo $craftjack_inbound_outbound_data['cross_sell_offered_upsell']=='Fail'?"selected":""; ?> value="Fail">Fail</option>
												<option craftjack_inbound_outbound_val=10 craftjack_inbound_outbound_max="10" <?php echo $craftjack_inbound_outbound_data['cross_sell_offered_upsell']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" name="data[cmt17]" class="form-control" value="<?php echo $craftjack_inbound_outbound_data['cmt17'] ?>"></td>
										<td style="font-weight:bold; background-color:#D7BDE2">Business</td>
									</tr>
									<tr>
										<td style="background-color:#BFC9CA"><b>E</b></td>
										<td colspan=2 style="background-color:#BFC9CA">SR</td>
										<td style="background-color:#BFC9CA">
											<input type="text" name="sr" id="sr" value="45" readonly>
										</td>
										<td style="background-color:#BFC9CA"></td>
										<td colspan=2 style="background-color:#BFC9CA"></td>
										<td style="background-color:#BFC9CA"></td>
									</tr>
									<tr>
										<td class="ob_show">OB</td>
										<td class="ob_show" colspan=2>Authorized to Send Details</td>
										<td class="ob_show">5</td>
										<td class="ob_show">
											<select class="form-control craftjack_inbound_outbound_point craftjack_IB_OB_point_ob compliance compliance_ob" id="ob_show4" name="data[sr_send_details_ob]" disabled>
												<option craftjack_inbound_outbound_val=5 craftjack_inbound_outbound_max="5" <?php echo $craftjack_inbound_outbound_data['sr_send_details_ob']=='Pass'?"selected":""; ?> value="Pass">Pass</option>
												<option craftjack_inbound_outbound_val=0 craftjack_inbound_outbound_max="5" <?php echo $craftjack_inbound_outbound_data['sr_send_details_ob']=='Fail'?"selected":""; ?> value="Fail">Fail</option>
												<option craftjack_inbound_outbound_val=5 craftjack_inbound_outbound_max="5" <?php echo $craftjack_inbound_outbound_data['sr_send_details_ob']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td class="ob_show" colspan=2><input type="text" name="data[cmt18]" class="form-control" value="<?php echo $craftjack_inbound_outbound_data['cmt18'] ?>"></td>
										<td class="ob_show" style="font-weight:bold; background-color:#D7BDE2">Compliance</td>
									</tr>
									<tr>
										<td>IB/OB</td>
										<td colspan=2>Did the agent understand the correct project Request?</td>
										<td>10</td>
										<td>
											<select class="form-control craftjack_inbound_outbound_point craftjack_IB_OB_point_ib craftjack_IB_OB_point_ob business business_ib business_ob" id="" name="data[sr_correct_project_request]" disabled>
												<option craftjack_inbound_outbound_val=10 craftjack_inbound_outbound_max="10" <?php echo $craftjack_inbound_outbound_data['sr_correct_project_request']=='Pass'?"selected":""; ?> value="Pass">Pass</option>
												<option craftjack_inbound_outbound_val=0 craftjack_inbound_outbound_max="10" <?php echo $craftjack_inbound_outbound_data['sr_correct_project_request']=='Fail'?"selected":""; ?> value="Fail">Fail</option>
												<option craftjack_inbound_outbound_val=10 craftjack_inbound_outbound_max="10" <?php echo $craftjack_inbound_outbound_data['sr_correct_project_request']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" name="data[cmt19]" class="form-control" value="<?php echo $craftjack_inbound_outbound_data['cmt19'] ?>"></td>
										<td style="font-weight:bold; background-color:#D7BDE2">Business</td>
									</tr>
									<tr>
										<td>IB/OB</td>
										<td colspan=2>Gather Contact Details (email/phone/address)</td>
										<td>10</td>
										<td>
											<select class="form-control craftjack_inbound_outbound_point craftjack_IB_OB_point_ib craftjack_IB_OB_point_ob compliance compliance_ib compliance_ob" id="" name="data[sr_gather_contact_details]" disabled>
												<option craftjack_inbound_outbound_val=10 craftjack_inbound_outbound_max="10" <?php echo $craftjack_inbound_outbound_data['sr_gather_contact_details']=='Pass'?"selected":""; ?> value="Pass">Pass</option>
												<option craftjack_inbound_outbound_val=0 craftjack_inbound_outbound_max="10" <?php echo $craftjack_inbound_outbound_data['sr_gather_contact_details']=='Fail'?"selected":""; ?> value="Fail">Fail</option>
												<option craftjack_inbound_outbound_val=10 craftjack_inbound_outbound_max="10" <?php echo $craftjack_inbound_outbound_data['sr_gather_contact_details']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" name="data[cmt20]" class="form-control" value="<?php echo $craftjack_inbound_outbound_data['cmt20'] ?>"></td>
										<td style="font-weight:bold; background-color:#D7BDE2">Compliance</td>
									</tr>
									<tr>
										<td>IB/OB</td>
										<td colspan=2>Offered General Contractor</td>
										<td>10</td>
										<td>
											<select class="form-control craftjack_inbound_outbound_point craftjack_IB_OB_point_ib craftjack_IB_OB_point_ob business business_ib business_ob" id="" name="data[sr_general_contracter]" disabled>
												<option craftjack_inbound_outbound_val=10 craftjack_inbound_outbound_max="10" <?php echo $craftjack_inbound_outbound_data['sr_general_contracter']=='Pass'?"selected":""; ?> value="Pass">Pass</option>
												<option craftjack_inbound_outbound_val=0 craftjack_inbound_outbound_max="10" <?php echo $craftjack_inbound_outbound_data['sr_general_contracter']=='Fail'?"selected":""; ?> value="Fail">Fail</option>
												<option craftjack_inbound_outbound_val=10 craftjack_inbound_outbound_max="10" <?php echo $craftjack_inbound_outbound_data['sr_general_contracter']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" name="data[cmt21]" class="form-control" value="<?php echo $craftjack_inbound_outbound_data['cmt21'] ?>"></td>
										<td style="font-weight:bold; background-color:#D7BDE2">Business</td>
									</tr>
									<tr>
										<td>IB/OB</td>
										<td colspan=2>Verified Authorization of the Project</td>
										<td>10</td>
										<td>
											<select class="form-control craftjack_inbound_outbound_point craftjack_IB_OB_point_ib craftjack_IB_OB_point_ob compliance compliance_ib compliance_ob" id="" name="data[sr_verified_auth_project]" disabled>
												<option craftjack_inbound_outbound_val=10 craftjack_inbound_outbound_max="10" <?php echo $craftjack_inbound_outbound_data['sr_verified_auth_project']=='Pass'?"selected":""; ?> value="Pass">Pass</option>
												<option craftjack_inbound_outbound_val=0 craftjack_inbound_outbound_max="10" <?php echo $craftjack_inbound_outbound_data['sr_verified_auth_project']=='Fail'?"selected":""; ?> value="Fail">Fail</option>
												<option craftjack_inbound_outbound_val=10 craftjack_inbound_outbound_max="10" <?php echo $craftjack_inbound_outbound_data['sr_verified_auth_project']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" name="data[cmt22]" class="form-control" value="<?php echo $craftjack_inbound_outbound_data['cmt22'] ?>"></td>
										<td style="font-weight:bold; background-color:#D7BDE2">Compliance</td>
									</tr>
									<tr>
										<td style="background-color:#BFC9CA"><b>F</b></td>
										<td colspan=2 style="background-color:#BFC9CA">Closing</td>
										<td style="background-color:#BFC9CA">5</td>
										<td style="background-color:#BFC9CA"></td>
										<td colspan=2 style="background-color:#BFC9CA"></td>
										<td style="background-color:#BFC9CA"></td>
									</tr>
									<tr>
										<td>IB/OB</td>
										<td colspan=2>Did the agent ended the call with the closure greeting? "Thank you for calling improvenet"</td>
										<td>5</td>
										<td>
											<select class="form-control craftjack_inbound_outbound_point craftjack_IB_OB_point_ib craftjack_IB_OB_point_ob business business_ib business_ob" id="" name="data[closing_closure_greeting]" disabled>
												<option craftjack_inbound_outbound_val=5 craftjack_inbound_outbound_max="5" <?php echo $craftjack_inbound_outbound_data['closing_closure_greeting']=='Pass'?"selected":""; ?> value="Pass">Pass</option>
												<option craftjack_inbound_outbound_val=0 craftjack_inbound_outbound_max="5" <?php echo $craftjack_inbound_outbound_data['closing_closure_greeting']=='Fail'?"selected":""; ?> value="Fail">Fail</option>
												<option craftjack_inbound_outbound_val=5 craftjack_inbound_outbound_max="5" <?php echo $craftjack_inbound_outbound_data['closing_closure_greeting']=='N/A'?"selected":""; ?> value="N/A">N/A</option>
											</select>
										</td>
										<td colspan=2><input type="text" name="data[cmt23]" class="form-control" value="<?php echo $craftjack_inbound_outbound_data['cmt23'] ?>"></td>
										<td style="font-weight:bold; background-color:#D7BDE2">Business</td>
									</tr>
									<tr>
										<td style="background-color:#BFC9CA"><b>G</b></td>
										<td colspan=2 style="background-color:#BFC9CA">Critical Fails</td>
										<td style="background-color:#BFC9CA">40</td>
										<td style="background-color:#BFC9CA">
											<input type="text" name="autofail_status" id="autofail_status" value="Pass" readonly>
										</td>
										<td colspan=2 style="background-color:#BFC9CA"></td>
										<td style="background-color:#BFC9CA"></td>
									</tr>
									<tr>
										<td>IB/OB</td>
										<td colspan=2 style="color:red">Valid SR?</td>
										<td>10</td>
										<td>
											<select class="form-control craftjack_inbound_outbound_point craftjack_IB_OB_point_ib craftjack_IB_OB_point_ob compliance compliance_ib compliance_ob" id="ib_ob_Fail1" name="data[critical_valid_SR]" disabled>
												<option craftjack_inbound_outbound_val=10 craftjack_inbound_outbound_max="10" <?php echo $craftjack_inbound_outbound_data['critical_valid_SR']=='Pass'?"selected":""; ?> value="Pass">Pass</option>
												<option craftjack_inbound_outbound_val=0 craftjack_inbound_outbound_max="10" <?php echo $craftjack_inbound_outbound_data['critical_valid_SR']=='Fail'?"selected":""; ?> value="Fail">Fail</option>
											</select>
										</td>
										<td colspan=2><input type="text" name="data[cmt24]" class="form-control" value="<?php echo $craftjack_inbound_outbound_data['cmt24'] ?>"></td>
										<td style="font-weight:bold; background-color:#D7BDE2">Compliance</td>
									</tr>
									<tr>
										<td>IB/OB</td>
										<td colspan=2 style="color:red">Correct CTT?</td>
										<td>10</td>
										<td>
											<select class="form-control craftjack_inbound_outbound_point craftjack_IB_OB_point_ib craftjack_IB_OB_point_ob compliance compliance_ib compliance_ob" id="ib_ob_Fail2" name="data[critical_correct_CTT]" disabled>
												<option craftjack_inbound_outbound_val=10 craftjack_inbound_outbound_max="10" <?php echo $craftjack_inbound_outbound_data['critical_correct_CTT']=='Pass'?"selected":""; ?> value="Pass">Pass</option>
												<option craftjack_inbound_outbound_val=0 craftjack_inbound_outbound_max="10" <?php echo $craftjack_inbound_outbound_data['critical_correct_CTT']=='Fail'?"selected":""; ?> value="Fail">Fail</option>
											</select>
										</td>
										<td colspan=2><input type="text" name="data[cmt25]" class="form-control" value="<?php echo $craftjack_inbound_outbound_data['cmt25'] ?>"></td>
										<td style="font-weight:bold; background-color:#D7BDE2">Compliance</td>
									</tr>
									<tr>
										<td>IB/OB</td>
										<td colspan=2 style="color:red">Read Contact Verbatim?</td>
										<td>10</td>
										<td>
											<select class="form-control craftjack_inbound_outbound_point craftjack_IB_OB_point_ib craftjack_IB_OB_point_ob compliance compliance_ib compliance_ob" id="ib_ob_Fail3" name="data[critical_contact_verbatim]" disabled>
												<option craftjack_inbound_outbound_val=10 craftjack_inbound_outbound_max="10" <?php echo $craftjack_inbound_outbound_data['critical_contact_verbatim']=='Pass'?"selected":""; ?> value="Pass">Pass</option>
												<option craftjack_inbound_outbound_val=0 craftjack_inbound_outbound_max="10" <?php echo $craftjack_inbound_outbound_data['critical_contact_verbatim']=='Fail'?"selected":""; ?> value="Fail">Fail</option>
											</select>
										</td>
										<td colspan=2><input type="text" name="data[cmt26]" class="form-control" value="<?php echo $craftjack_inbound_outbound_data['cmt26'] ?>"></td>
										<td style="font-weight:bold; background-color:#D7BDE2">Compliance</td>
									</tr>
									<tr>
										<td>IB/OB</td>
										<td colspan=2 style="color:red">Agent mentioned about the recorded line?</td>
										<td>10</td>
										<td>
											<select class="form-control craftjack_inbound_outbound_point craftjack_IB_OB_point_ib craftjack_IB_OB_point_ob compliance compliance_ib compliance_ob" id="ib_ob_Fail4" name="data[critical_recorded_line]" disabled>
												<option craftjack_inbound_outbound_val=10 craftjack_inbound_outbound_max="10" <?php echo $craftjack_inbound_outbound_data['critical_recorded_line']=='Pass'?"selected":""; ?> value="Pass">Pass</option>
												<option craftjack_inbound_outbound_val=0 craftjack_inbound_outbound_max="10" <?php echo $craftjack_inbound_outbound_data['critical_recorded_line']=='Fail'?"selected":""; ?> value="Fail">Fail</option>
											</select>
										</td>
										<td colspan=2><input type="text" name="data[cmt27]" class="form-control" value="<?php echo $craftjack_inbound_outbound_data['cmt27'] ?>"></td>
										<td style="font-weight:bold; background-color:#D7BDE2">Compliance</td>
									</tr>
									<!-- Add ACPT -->
										<?php $adtsht='';
											echo $global_element.'/'.$adtsht; 
										?>
									<!-- -->		
									<tr style="font-weight:bold; background-color:#D7BDE2">
										<td colspan=3>Customer Score</td>
										<td colspan=3>Business Score</td>
										<td colspan=3>Compliance Score</td>
									</tr>

									<tr style="font-weight:bold; background-color:#D7BDE2">
										<td>Earned Point:</td><td colspan=2><input type="text" readonly class="form-control" id="customer_earned_score" name="data[customer_earned_score]" value="<?php echo $craftjack_inbound_outbound_data['customer_earned_score'] ?>"></td>
										<td>Earned Point:</td><td colspan=2><input type="text" readonly class="form-control" id="business_earned_score" name="data[business_earned_score]" value="<?php echo $craftjack_inbound_outbound_data['business_earned_score'] ?>"></td>
										<td>Earned Point:</td><td colspan=2><input type="text" readonly class="form-control" id="compliance_earned_score" name="data[compliance_earned_score]" value="<?php echo $craftjack_inbound_outbound_data['compliance_earned_score'] ?>"></td>
									</tr>
									<tr style="font-weight:bold; background-color:#D7BDE2">
										<td>Possible Point:</td><td colspan=2><input type="text" readonly class="form-control" id="customer_possible_score" name="data[customer_possible_score]" value="<?php echo $craftjack_inbound_outbound_data['customer_possible_score'] ?>"></td>
										<td>Possible Point:</td><td colspan=2><input type="text" readonly class="form-control" id="business_possible_score" name="data[business_possible_score]" value="<?php echo $craftjack_inbound_outbound_data['business_possible_score'] ?>"></td>
										<td>Possible Point:</td><td colspan=2><input type="text" readonly class="form-control" id="compliance_possible_score" name="data[compliance_possible_score]" value="<?php echo $craftjack_inbound_outbound_data['compliance_possible_score'] ?>"></td>
									</tr>
									<tr style="font-weight:bold; background-color:#D7BDE2">
										<td>Overall Percentage:</td><td colspan=2><input type="text" readonly class="form-control" id="customer_overall_score" name="data[customer_overall_score]" value="<?php echo $craftjack_inbound_outbound_data['customer_overall_score'] ?>"></td>
										<td>Overall Percentage:</td><td colspan=2><input type="text" readonly class="form-control" id="business_overall_score" name="data[business_overall_score]" value="<?php echo $craftjack_inbound_outbound_data['business_overall_score'] ?>"></td>
										<td>Overall Percentage:</td><td colspan=2><input type="text" readonly class="form-control" id="compliance_overall_score" name="data[compliance_overall_score]" value="<?php echo $craftjack_inbound_outbound_data['compliance_overall_score'] ?>"></td>
									</tr>

										<tr>
											<td>Call Summary:</td>
											<td colspan=2><textarea class="form-control" name="data[call_summary]"><?php echo $craftjack_inbound_outbound_data['call_summary'] ?></textarea></td>
											<td>Feedback:</td>
											<td colspan=4><textarea class="form-control" name="data[feedback]"><?php echo $craftjack_inbound_outbound_data['feedback'] ?></textarea></td>
										</tr>
										<?php if($craftjack_inbound_outbound_data['attach_file']!=''){ ?>
									<tr oncontextmenu="return false;">
										<td colspan="2">Audio Files (Mp4/Mp3/M4a/Wav)</td>
										<td colspan="4">
											<?php $attach_file = explode(",",$craftjack_inbound_outbound_data['attach_file']);
											 foreach($attach_file as $af){ ?>
												<audio oncontextmenu="return false;" controls controlslist="nodownload" style="background-color:#607F93">
													  <source src="<?php echo base_url(); ?>qa_files/craftjack/qa_audio_files/<?php echo $af; ?>" type="audio/ogg">
													  <source src="<?php echo base_url(); ?>qa_files/craftjack/qa_audio_files/<?php echo $af; ?>" type="audio/mpeg">
												</audio> </br>
											 <?php } ?>
										</td>
									</tr>
									<?php } ?>

									<tr>
										<td style="font-size:12px">Manager Review:</td>
										<td colspan="8" style="text-align:left"><?php echo $craftjack_inbound_outbound_data['mgnt_rvw_note'] ?></td>
									</tr>
									<tr>
										<td style="font-size:12px">Client Review:</td>
										<td colspan="8" style="text-align:left"><?php echo $craftjack_inbound_outbound_data['client_rvw_note'] ?></td>
									</tr>

									<tr><td colspan="10" style="background-color:#C5C8C8"></td></tr>
									
									 <form id="form_agent_user" method="POST" action="">
										<input type="hidden" name="craftjack_inbound_outbound_id" class="form-control" value="<?php echo $craftjack_inbound_outbound_id; ?>">
										
										<tr>
											<td colspan=2 style="font-size:16px">Feedback Acceptance<span style="font-size:24px;color:red">*</span></td>
											<td colspan=6>
												<select class="form-control" id="" name="agnt_fd_acpt" required="">
													<option value="">--Select--</option>
													<option <?php echo $craftjack_inbound_outbound_data['agnt_fd_acpt']=='Acceptance'?"selected":""; ?> value="Acceptance">Acceptance</option>	
													<option <?php echo $craftjack_inbound_outbound_data['agnt_fd_acpt']=='Not Acceptance'?"selected":""; ?> value="Not Acceptance">Not Acceptance</option>	
												</select>
											</td>
										</tr>
										<tr>
											<td colspan=2 style="font-size:16px">Your Review<span style="font-size:24px;color:red">*</span></td>
											<td colspan=6><textarea class="form-control" name="note" required><?php echo $craftjack_inbound_outbound_data['agent_rvw_note'] ?></textarea></td>
										</tr>
										
										<?php if(is_access_qa_agent_module()==true){
										if(is_available_qa_feedback($craftjack_inbound_outbound_data['entry_date'],72) == true){ ?>
											<tr>
												<?php if($craftjack_inbound_outbound_data['agent_rvw_note']==''){ ?>
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