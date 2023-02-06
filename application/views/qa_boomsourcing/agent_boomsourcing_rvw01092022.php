<style>
.table > tbody > tr > td{
	text-align: center;
	font-size:13px;
	
}

#theader{
	font-size:20px;
	font-weight:bold;
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
									<tr style="background-color:#114150"><td id="theader" style="color:white" colspan="6"><?php echo ucfirst($campaign); ?></td></tr>
									
									<?php if($campaign=="boomsourcing"){ ?>
									
										<tr>
											<td>Name of Auditor:</td>
											<td><input type="text" class="form-control" value="<?php echo $boomsourcing_data['auditor_name']; ?>" disabled>
											<input type="hidden" class="form-control" name="data[auditor_id]" value="<?php echo $boomsourcing_data['entry_by']; ?>"></td>
											<td>Date of Audit:</td>
											<td><input type="text" class="form-control" value="<?php echo ConvServerToLocal($boomsourcing_data['entry_date']); ?>" disabled></td>
											<td>Ticket/Transaction ID:</td>
											<td><input type="text" class="form-control" name="data[ticket_id]" value="<?php echo $boomsourcing_data['ticket_id']; ?>" disabled></td>
										</tr>
										<tr>
											<td>Agent:</td>
											<td>
												<select class="form-control" id="agent_id" name="data[agent_id]" disabled>
													<option value="<?php echo $boomsourcing_data['agent_id'] ?>"><?php echo $boomsourcing_data['fname']." ".$boomsourcing_data['lname'] ?></option>
												</select>
											</td>
											<td>Fusion ID:</td>
											<td><input type="text" disabled class="form-control" id="fusion_id" value="<?php echo $boomsourcing_data['xpoid'] ?>"></td>
											<td>L1 Supervisor:</td>
											<td>
												<select class="form-control" id="tl_id" name="data[tl_id]" disabled>
													<option value="<?php echo $boomsourcing_data['tl_id'] ?>"><?php echo $boomsourcing_data['tl_name'] ?></option>	
												</select>
											</td>
										</tr>
										<tr>
											<td>Call/Transaction Date:</td>
											<td><input type="text" class="form-control" id="call_date" name="call_date" value="<?php echo mysqlDt2mmddyy($boomsourcing_data['call_date']); ?>" disabled></td>
											<td>Call Duration:</td>
											<td><input type="text" class="form-control" id="call_duration" name="data[call_duration]" value="<?php echo $boomsourcing_data['call_duration'] ?>" disabled ></td>
											<td>Zone:</td>
											<td><input type="text" class="form-control" name="data[zone]" value="<?php echo $boomsourcing_data['zone'] ?>" disabled ></td>		
										</tr>
										<tr>
										<td>Phone:</td>
										<td><input type="text" class="form-control" id="phone" name="data[phone]" value="<?php echo $boomsourcing_data['phone'] ?>" disabled></td>
										<td>Link:</td>
										<td><input type="text" class="form-control" id="link" name="data[link]" value="<?php echo $boomsourcing_data['link'] ?>" disabled ></td>
										<td>Rep's Name:</td>
										<td><input type="text" class="form-control" name="data[reps_name]" value="<?php echo $boomsourcing_data['reps_name'] ?>" disabled ></td>
									</tr>
									<tr>
										<td>Center:</td>
										<td><input type="text" class="form-control" name="data[center]" value="<?php echo $boomsourcing_data['center'] ?>" disabled></td>
										<td>Disposition:</td>
										<td><input type="text" class="form-control" name="data[disposition]" value="<?php echo $boomsourcing_data['disposition'] ?>" disabled></td>
										<td>Week No:</td>
										<td><input type="text" class="form-control" name="data[week]" value="<?php echo $boomsourcing_data['week'] ?>" disabled></td>
									</tr>
									<tr>
											<td>Audit Type:</td>
											<td>
												<select class="form-control" name="data[audit_type]" disabled>
													<option><?php echo $boomsourcing_data['audit_type'] ?></option>
												</select>
											</td>
											<td>VOC:</td>
											<td>
												<select class="form-control" id="voc" name="data[voc]" disabled>
													<option><?php echo $boomsourcing_data['voc'] ?></option>
												</select>
											</td>
										</tr>
									<tr>
										<td>NSC Type</td>
										<td><input type="text" class="form-control" id="ncs" readonly name="data[ncs]" value="<?php echo $boomsourcing_data['ncs'] ?>"></td>
									</tr>
										<tr style="font-weight:bold">
											<td style="font-size:18px; text-align:right">Earn Score:</td>
											<td><input type="text" class="form-control" id="earnScore" name="data[earned_score]"value="<?php echo $boomsourcing_data['earned_score'] ?>" readonly></td>
											<td style="font-size:18px; text-align:right">Possible Score:</td>
											<td><input type="text" class="form-control" id="possibleScore" name="data[possible_score]"value="<?php echo $boomsourcing_data['possible_score'] ?>" readonly></td>
											<td style="font-size:18px; text-align:right">Total Score:</td>
											<td><input type="text" class="form-control dunzoVoiceFatal" id="overallScore" name="overall_score" value="<?php echo $boomsourcing_data['overall_score'] ?>" readonly></td>
										</tr>

									<tr style=" font-weight:bold;background-color:#6d71e3 ;color: white;">
										<td colspan=3>Quality Attribute</td>
										<td>Weightage</td>
										<td>Status</td>
										<td>Remarks</td>
									</tr>
									<tr>
										<td colspan=3>Minor Interruption/s/Talking over</td>
										<td>5</td>
										<td>
											<select class="form-control boomsourcing_point" name="data[talking_over]" disabled>
												<option boomsourcing_val=5 <?php echo $boomsourcing_data['talking_over'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option boomsourcing_val=5 <?php echo $boomsourcing_data['talking_over'] == "No"?"selected":"";?> value="No">No</option>
												<option boomsourcing_val=5 <?php echo $boomsourcing_data['talking_over'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
										<td><input type="text" class="form-control" name="data[comm1]" value="<?php echo $boomsourcing_data['comm1'] ?>" disabled></td>
									</tr>
									<tr>
										<td colspan=3>Unnecessary key pressed of nodes</td>
										<td>10</td>
										<td>
											<select class="form-control boomsourcing_point" name="data[key_pressed]" disabled>
												<option boomsourcing_val=10 <?php echo $boomsourcing_data['key_pressed'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option boomsourcing_val=10 <?php echo $boomsourcing_data['key_pressed'] == "No"?"selected":"";?> value="No">No</option>
												<option boomsourcing_val=10 <?php echo $boomsourcing_data['key_pressed'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
										<td><input type="text" class="form-control" name="data[comm2]" value="<?php echo $boomsourcing_data['comm2'] ?>" disabled></td>
									</tr>
									<tr>
										<td colspan=3>Start/stopping of nodes</td>
										<td>10</td>
										<td>
											<select class="form-control boomsourcing_point" name="data[start_stop_nodes]" disabled>
												<option boomsourcing_val=10 <?php echo $boomsourcing_data['start_stop_nodes'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option boomsourcing_val=10 <?php echo $boomsourcing_data['start_stop_nodes'] == "No"?"selected":"";?> value="No">No</option>
												<option boomsourcing_val=10 <?php echo $boomsourcing_data['start_stop_nodes'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
										<td><input type="text" class="form-control" name="data[comm3]" value="<?php echo $boomsourcing_data['comm3'] ?>" disabled></td>
									</tr>
									<tr>
										<td colspan=3>Lags/Delayed responses (3-5 seconds)</td>
										<td>5</td>
										<td>
											<select class="form-control boomsourcing_point" name="data[delayed_responses]" disabled>
												<option boomsourcing_val=5 <?php echo $boomsourcing_data['delayed_responses'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option boomsourcing_val=5 <?php echo $boomsourcing_data['delayed_responses'] == "No"?"selected":"";?> value="No">No</option>
												<option boomsourcing_val=5 <?php echo $boomsourcing_data['delayed_responses'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
										<td><input type="text" class="form-control" name="data[comm4]" value="<?php echo $boomsourcing_data['comm4'] ?>" disabled></td>
									</tr>
									<tr>
										<td colspan=3>Dead air (6 seconds to 10)</td>
										<td>15</td>
										<td>
											<select class="form-control boomsourcing_point" name="data[dead_air]" disabled>
												<option boomsourcing_val=15 <?php echo $boomsourcing_data['dead_air'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option boomsourcing_val=15 <?php echo $boomsourcing_data['dead_air'] == "No"?"selected":"";?> value="No">No</option>
												<option boomsourcing_val=15 <?php echo $boomsourcing_data['dead_air'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
										<td><input type="text" class="form-control" name="data[comm5]" value="<?php echo $boomsourcing_data['comm5'] ?>" disabled></td>
									</tr>
									<tr>
										<td colspan=3>Active Listening/asked to repeat clearly answered question</td>
										<td>5</td>
										<td>
											<select class="form-control boomsourcing_point" name="data[active_listening]" disabled>
												<option boomsourcing_val=5 <?php echo $boomsourcing_data['active_listening'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option boomsourcing_val=5 <?php echo $boomsourcing_data['active_listening'] == "No"?"selected":"";?> value="No">No</option>
												<option boomsourcing_val=5 <?php echo $boomsourcing_data['active_listening'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
										<td><input type="text" class="form-control" name="data[comm6]" value="<?php echo $boomsourcing_data['comm6'] ?>" disabled></td>
									</tr>
									<tr>
										<td colspan=3>Incorrect responses/Incorrect rebuttal used</td>
										<td>10</td>
										<td>
											<select class="form-control boomsourcing_point" name="data[incorrect_responses]" disabled>
												<option boomsourcing_val=10 <?php echo $boomsourcing_data['incorrect_responses'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option boomsourcing_val=10 <?php echo $boomsourcing_data['incorrect_responses'] == "No"?"selected":"";?> value="No">No</option>
												<option boomsourcing_val=10 <?php echo $boomsourcing_data['incorrect_responses'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
										<td><input type="text" class="form-control" name="data[comm7]" value="<?php echo $boomsourcing_data['comm7'] ?>" disabled></td>
									</tr>
									<tr>
										<td colspan=3>Hand off Issue/s</td>
										<td>10</td>
										<td>
											<select class="form-control boomsourcing_point" name="data[hand_off_issue]" disabled>
												<option boomsourcing_val=10 <?php echo $boomsourcing_data['hand_off_issue'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option boomsourcing_val=10 <?php echo $boomsourcing_data['hand_off_issue'] == "No"?"selected":"";?> value="No">No</option>
												<option boomsourcing_val=10 <?php echo $boomsourcing_data['hand_off_issue'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
										<td><input type="text" class="form-control" name="data[comm8]" value="<?php echo $boomsourcing_data['comm8'] ?>" disabled></td>
									</tr>
									<tr>
										<td colspan=3>Failed to get for affirmative answer before transferring</td>
										<td>10</td>
										<td>
											<select class="form-control boomsourcing_point" name="data[affirmative_answer]" disabled>
												<option boomsourcing_val=10 <?php echo $boomsourcing_data['affirmative_answer'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option boomsourcing_val=10 <?php echo $boomsourcing_data['affirmative_answer'] == "No"?"selected":"";?> value="No">No</option>
												<option boomsourcing_val=10 <?php echo $boomsourcing_data['affirmative_answer'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
										<td><input type="text" class="form-control" name="data[comm9]" value="<?php echo $boomsourcing_data['comm9'] ?>" disabled></td>
									</tr>
									<tr>
										<td colspan=3>Wrong Disposition (not 100% rep error)</td>
										<td>5</td>
										<td>
											<select class="form-control boomsourcing_point" name="data[wrong_disposition]" disabled>
												<option boomsourcing_val=5 <?php echo $boomsourcing_data['wrong_disposition'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option boomsourcing_val=5 <?php echo $boomsourcing_data['wrong_disposition'] == "No"?"selected":"";?> value="No">No</option>
												<option boomsourcing_val=5 <?php echo $boomsourcing_data['wrong_disposition'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
										<td><input type="text" class="form-control" name="data[comm10]" value="<?php echo $boomsourcing_data['comm10'] ?>"disabled></td>
									</tr>
									<tr>
										<td colspan=3>Incomplete information (optional)</td>
										<td>5</td>
										<td>
											<select class="form-control boomsourcing_point" name="data[incomplete_information]" disabled>
												<option boomsourcing_val=5 <?php echo $boomsourcing_data['incomplete_information'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option boomsourcing_val=5 <?php echo $boomsourcing_data['incomplete_information'] == "No"?"selected":"";?> value="No">No</option>
												<option boomsourcing_val=5 <?php echo $boomsourcing_data['incomplete_information'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
										<td><input type="text" class="form-control" name="data[comm11]" value="<?php echo $boomsourcing_data['comm11'] ?>" disabled></td>
									</tr>
									<tr>
										<td colspan=3>Scrambling of script</td>
										<td>10</td>
										<td>
											<select class="form-control boomsourcing_point" name="data[scrambling_script]" disabled>
												<option boomsourcing_val=10 <?php echo $boomsourcing_data['scrambling_script'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option boomsourcing_val=10 <?php echo $boomsourcing_data['scrambling_script'] == "No"?"selected":"";?> value="No">No</option>
												<option boomsourcing_val=10 <?php echo $boomsourcing_data['scrambling_script'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
										<td><input type="text" class="form-control" name="data[comm12]" value="<?php echo $boomsourcing_data['comm12'] ?>" disabled></td>
									</tr>
									<tr>
										<td colspan=3 style="color:red">Major interruption/talking over</td>
										<td>-</td>
										<td>
											<select class="form-control boomsourcing_point boomsourcing_fatal" id="boomsourcingAF1" name="data[major_interruption]" disabled>
												<option boomsourcing_val=0 <?php echo $boomsourcing_data['major_interruption'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option boomsourcing_val=0 <?php echo $boomsourcing_data['major_interruption'] == "Fatal"?"selected":"";?> value="Fatal">Fatal</option>
												<option boomsourcing_val=0 <?php echo $boomsourcing_data['major_interruption'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
										<td><input type="text" class="form-control" name="data[comm13]" value="<?php echo $boomsourcing_data['comm13'] ?>" disabled></td>
									</tr>
									<tr>
										<td colspan=3 style="color:red">Skipping /cutting of script</td>
										<td>-</td>
										<td>
											<select class="form-control boomsourcing_point boomsourcing_fatal" id="boomsourcingAF2" name="data[cutting_script]" disabled>
												<option boomsourcing_val=0 <?php echo $boomsourcing_data['cutting_script'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option boomsourcing_val=0 <?php echo $boomsourcing_data['cutting_script'] == "Fatal"?"selected":"";?> value="Fatal">Fatal</option>
												<option boomsourcing_val=0 <?php echo $boomsourcing_data['cutting_script'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
										<td><input type="text" class="form-control" name="data[comm14]" value="<?php echo $boomsourcing_data['comm14'] ?>" disabled></td>
									</tr>
									<tr>
										<td colspan=3 style="color:red">Failed to rebut</td>
										<td>-</td>
										<td>
											<select class="form-control boomsourcing_point boomsourcing_fatal" id="boomsourcingAF3" name="data[failed_rebut]" disabled>
												<option boomsourcing_val=0 <?php echo $boomsourcing_data['failed_rebut'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option boomsourcing_val=0 <?php echo $boomsourcing_data['failed_rebut'] == "Fatal"?"selected":"";?> value="Fatal">Fatal</option>
												<option boomsourcing_val=0 <?php echo $boomsourcing_data['failed_rebut'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
										<td><input type="text" class="form-control" name="data[comm15]" value="<?php echo $boomsourcing_data['comm15'] ?>" disabled></td>
									</tr>
									<tr>
										<td colspan=3 style="color:red">Over pushing</td>
										<td>-</td>
										<td>
											<select class="form-control boomsourcing_point boomsourcing_fatal" id="boomsourcingAF4" name="data[over_pushing]" disabled>
												<option boomsourcing_val=0 <?php echo $boomsourcing_data['over_pushing'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option boomsourcing_val=0 <?php echo $boomsourcing_data['over_pushing'] == "Fatal"?"selected":"";?> value="Fatal">Fatal</option>
												<option boomsourcing_val=0 <?php echo $boomsourcing_data['over_pushing'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
										<td><input type="text" class="form-control" name="data[comm16]" value="<?php echo $boomsourcing_data['comm16'] ?>" disabled></td>
									</tr>
									<tr>
										<td colspan=3 style="color:red">Legal Compliance/Sales Falsification</td>
										<td>-</td>
										<td>
											<select class="form-control boomsourcing_point boomsourcing_fatal" id="boomsourcingAF5" name="data[legal_compliance]" disabled>
												<option boomsourcing_val=0 <?php echo $boomsourcing_data['legal_compliance'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option boomsourcing_val=0 <?php echo $boomsourcing_data['legal_compliance'] == "Fatal"?"selected":"";?> value="Fatal">Fatal</option>
												<option boomsourcing_val=0 <?php echo $boomsourcing_data['legal_compliance'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
										<td><input type="text" class="form-control" name="data[comm17]" value="<?php echo $boomsourcing_data['comm17'] ?>" disabled></td>
									</tr>
									<tr>
										<td colspan=3 style="color:red">Call avoidance (Over staying >10sec)</td>
										<td>-</td>
										<td>
											<select class="form-control boomsourcing_point boomsourcing_fatal" id="boomsourcingAF6" name="data[call_avoidance]" disabled>
												<option boomsourcing_val=0 <?php echo $boomsourcing_data['call_avoidance'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option boomsourcing_val=0 <?php echo $boomsourcing_data['call_avoidance'] == "Fatal"?"selected":"";?> value="Fatal">Fatal</option>
												<option boomsourcing_val=0 <?php echo $boomsourcing_data['call_avoidance'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
										<td><input type="text" class="form-control" name="data[comm18]" value="<?php echo $boomsourcing_data['comm18'] ?>" disabled></td>
									</tr>
									<tr>
										<td colspan=3 style="color:red">Failed to provide all the necessary info (required)</td>
										<td>-</td>
										<td>
											<select class="form-control boomsourcing_point boomsourcing_fatal" id="boomsourcingAF7" name="data[necessary_info]" disabled>
												<option boomsourcing_val=0 <?php echo $boomsourcing_data['necessary_info'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option boomsourcing_val=0 <?php echo $boomsourcing_data['necessary_info'] == "Fatal"?"selected":"";?> value="Fatal">Fatal</option>
												<option boomsourcing_val=0 <?php echo $boomsourcing_data['necessary_info'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
										<td><input type="text" class="form-control" name="data[comm19]" value="<?php echo $boomsourcing_data['comm19'] ?>" disabled></td>
									</tr>
									<tr>
										<td colspan=3 style="color:red">Failed to bowout</td>
										<td>-</td>
										<td>
											<select class="form-control boomsourcing_point boomsourcing_fatal" id="boomsourcingAF8" name="data[failed_bowout]" disabled>
												<option boomsourcing_val=0 <?php echo $boomsourcing_data['failed_bowout'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option boomsourcing_val=0 <?php echo $boomsourcing_data['failed_bowout'] == "Fatal"?"selected":"";?> value="Fatal">Fatal</option>
												<option boomsourcing_val=0 <?php echo $boomsourcing_data['failed_bowout'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
										<td><input type="text" class="form-control" name="data[comm20]" value="<?php echo $boomsourcing_data['comm20'] ?>" disabled></td>
									</tr>
									<tr>
										<td colspan=3 style="color:red">Wrong Disposition (rep error)</td>
										<td>-</td>
										<td>
											<select class="form-control boomsourcing_point boomsourcing_fatal" id="boomsourcingAF9" name="data[wrong_disposition_error]" disabled>
												<option boomsourcing_val=0 <?php echo $boomsourcing_data['wrong_disposition_error'] == "Yes"?"selected":"";?> value="Yes">Yes</option>
												<option boomsourcing_val=0 <?php echo $boomsourcing_data['wrong_disposition_error'] == "Fatal"?"selected":"";?> value="Fatal">Fatal</option>
												<option boomsourcing_val=0 <?php echo $boomsourcing_data['wrong_disposition_error'] == "N/A"?"selected":"";?> value="N/A">N/A</option>
											</select> 
										</td>
										<td><input type="text" class="form-control" name="data[comm21]" value="<?php echo $boomsourcing_data['comm21'] ?>" disabled></td>
									</tr>
									
									<tr>
										<td>Very Interested/No objection (Q3):</td>
										<td colspan=2><textarea class="form-control" name="data[no_objection]" disabled><?php echo $boomsourcing_data['no_objection'] ?></textarea></td>
										<td>Asked a question but no objection/Hung Up within 10 seconds of transferring (Q2):</td>
										<td colspan=2><textarea class="form-control" name="data[hung_up]" disabled><?php echo $boomsourcing_data['hung_up'] ?></textarea></td>
									</tr>
									<tr>
										<td>Declined once but agreed after rep rebut (Q1):</td>
										<td colspan=2><textarea class="form-control" name="data[rep_rebut]" disabled><?php echo $boomsourcing_data['rep_rebut'] ?></textarea></td>
										<td>Failed to meet the qualifications. INVALID (Q0):</td>
										<td colspan=2><textarea class="form-control" name="data[meet_qualifications]" disabled><?php echo $boomsourcing_data['meet_qualifications'] ?></textarea></td>
									</tr>
									<tr>
										<td>Incorrectly Disposed/None qualified tagged as Transfers:</td>
										<td colspan=3><textarea class="form-control" name="data[incorrectly_disposed]" disabled><?php echo $boomsourcing_data['incorrectly_disposed'] ?></textarea></td>
									</tr>
									<tr>
										<td>Call Summary:</td>
										<td colspan=2><textarea class="form-control" name="data[call_summary]" disabled><?php echo $boomsourcing_data['call_summary'] ?></textarea></td>
										<td>Feedback:</td>
										<td colspan=2><textarea class="form-control" name="data[feedback]" disabled><?php echo $boomsourcing_data['feedback'] ?></textarea></td>
									</tr>
									<tr style="background-color:#F5B7B1">
										<td colspan=2>Upload Audio Files (WAV,WMV,MP3,MP4)</td>
										<?php if($ss_id==0){ ?>
											<td colspan=2><input type="file" multiple class="form-control audioFile" id="attach_file" name="attach_file[]" disabled></td>
											<td colspan=2>
												<?php echo '<a class="btn btn-warning" style="font-size:15px" href="'.base_url().'Qa_boomsourcing/record_audio/'.$ss_id.'" target="a_blank" style="margin-left:5px; font-size:10px;">Record Audio Here</a>';  ?>
											</td>
										<?php }else{ ?>
											<td colspan=2><input type="file" multiple class="form-control audioFile" id="attach_file" name="attach_file[]" disabled></td>
										<?php if($boomsourcing_data['attach_file']!=''){ ?>
											<td colspan=2>
												<?php $attach_file = explode(",",$boomsourcing_data['attach_file']);
												 foreach($attach_file as $mp){ ?>
													<audio controls='' style="background-color:#607F93"> 
													  <source src="<?php echo base_url(); ?>qa_files/Qa_boomsourcing/<?php echo $mp; ?>" type="audio/ogg">
													  <source src="<?php echo base_url(); ?>qa_files/Qa_boomsourcing/<?php echo $mp; ?>" type="audio/mpeg">
													</audio> </br>
												 <?php } ?>
											</td>
										<?php }else{
												echo '<td colspan="2"><b>No Audio Files Uploaded</b></td>';
											  }
										} ?>
									</tr>
									<tr style="background-color:#A5DDBD">
										<td colspan="2">Upload Screenshot Files (JPG,JPEG,PNG)</td>
										<?php if($ss_id==0){ ?>
											<td colspan=2><input type="file" multiple class="form-control imageFile" name="attach_img_file[]" disabled></td>
										<?php }else{ 
											if($boomsourcing_data['attach_img_file']!=''){ ?>
											<td colspan="4">
												<?php $attach_img_file = explode(",",$boomsourcing_data['attach_img_file']);
												 foreach($attach_img_file as $mp){ ?>
													<button class="btn btn-info"><a href="<?php echo base_url(); ?>qa_files/Qa_boomsourcing/<?php echo $mp; ?>"><?php echo $mp; ?></a></button>
												 <?php } ?>
											</td>
										<?php }else{
												echo '<td colspan="4"><b>No Screenshot Files Uploaded</b></td>';
											  }
										} ?>
									</tr>
									<?php } ?>
									
									<tr><td colspan="6" style="background-color:#C5C8C8"></td></tr>
									
									<?php 
										echo '<tr><td style="font-size:16px">Operation TL/Manager Review:</td> <td colspan="5" style="text-align:left">'.$boomsourcing_data['mgnt_rvw_note'].'</td></tr>';
										echo '<tr><td style="font-size:16px">QA Rebuttal:</td><td style="text-align:left">'.$boomsourcing_data['qa_rebuttal'].'</td><td style="font-size:16px">Rebuttal Comment:</td><td colspan="3" style="text-align:left">'.$boomsourcing_data['qa_rebuttal_comment'].'</td></tr>';
										echo '<tr><td style="font-size:16px">QA TL/Manager Rebuttal:</td><td style="text-align:left">'.$boomsourcing_data['qa_mgnt_rebuttal'].'</td><td style="font-size:16px">Rebuttal Comment:</td><td colspan="3" style="text-align:left">'.$boomsourcing_data['qa_mgnt_rebuttal_comment'].'</td></tr>';
									?>
									
									<tr><td colspan="6" style="background-color:#C5C8C8"></td></tr>
									
									<form id="form_agent_user" method="POST" action="">
									  <input type="hidden" name="pnid" value="<?php echo $pnid; ?>">
									
									<tr>
										<td>Agent Feedback Acceptance</td>
										<td colspan=2>
											<select class="form-control" name="agnt_fd_acpt" required>
												<option value="">-Select-</option>
												<option <?php echo $boomsourcing_data['agnt_fd_acpt']=='Accepted'?"selected":""; ?> value="Accepted">Accepted</option>
												<option <?php echo $boomsourcing_data['agnt_fd_acpt']=='Not Accepted'?"selected":""; ?> value="Not Accepted">Not Accepted</option>
											</select>
										</td>
									</tr>
									<tr>
										<td colspan=2 style="font-size:16px">Your Review</td>
										<td colspan=4><textarea class="form-control" name="agent_rvw_note" required><?php echo $boomsourcing_data['agent_rvw_note'] ?></textarea></td>
									</tr>
									
									<?php 
									if($boomsourcing_data['qa_rebuttal']!="" && $boomsourcing_data['qa_mgnt_rebuttal']==""){
										$entry_date=$boomsourcing_data['qa_rebuttal_date'];
										$acpt_time='48';
									}else if($boomsourcing_data['qa_mgnt_rebuttal']!=""){
										$entry_date=$boomsourcing_data['qa_mgnt_rebuttal_date'];
										$acpt_time='48';
									}else{
										$entry_date=$boomsourcing_data['entry_date'];
										$acpt_time='72';
									}
									
									if(is_access_qa_agent_module()==true){
										if(is_available_qa_feedback($entry_date,$acpt_time) == true){ ?>
										<tr>
											<?php if($boomsourcing_data['agnt_fd_acpt']!='Accepted'){ ?>
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
		</div>

	</section>
</div>
